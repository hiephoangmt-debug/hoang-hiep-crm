<?php
/**
 * Gói dự án cho ô "Dự án → Nhập nhanh (bài / dự án)": JSON có "kind": "du-an".
 * - Dự án chưa có (theo slug) → tạo BẢN NHÁP đủ thông tin, ảnh.
 * - Dự án đã có → chỉ thay các ô có trong gói (giá, chính sách, ảnh tiến độ…); ô không có trong gói giữ nguyên.
 *   Giá trị cũ được lưu lại (5 lần gần nhất) để bấm "Hoàn tác" trên trang Nhập nhanh.
 *
 * JSON: slug, title, excerpt, content, types[] (loai-du-an), area (khu-vuc), parent (slug tổ hợp),
 * meta{ hh_p_*: chuỗi | mảng dòng (lines) | mảng hàng [[ô, ô…]] (table) },
 * images{ featured: ảnh, hh_p_gallery: [ảnh…], hh_p_masterplan_img: ảnh, … } với ảnh = {name, alt, data(base64)},
 * gallery_mode: "append" (mặc định, thêm vào thư viện ảnh) | "replace", sources[].
 */

defined( 'ABSPATH' ) || exit;

/** meta_key => kiểu ô, lấy từ schema trang dự án (chỉ nhận các ô có trong schema). */
function hh_quick_project_fields() {
	$fields = array();
	foreach ( hh_project_schema() as $group ) {
		foreach ( $group['fields'] as $key => $f ) {
			$fields[ $key ] = array( $f['type'], $f['label'] );
		}
	}
	return $fields;
}

/** Chuẩn hoá giá trị trong gói về đúng định dạng lưu của ô. */
function hh_quick_project_value( $type, $value ) {
	switch ( $type ) {
		case 'table':
			$rows = array();
			foreach ( (array) $value as $row ) {
				$rows[] = is_array( $row ) ? implode( ' | ', array_map( static fn( $c ) => str_replace( array( '|', "\n" ), array( '/', ' ' ), (string) $c ), $row ) ) : (string) $row;
			}
			return sanitize_textarea_field( implode( "\n", $rows ) );
		case 'lines':
			return sanitize_textarea_field( is_array( $value ) ? implode( "\n", $value ) : (string) $value );
		case 'textarea':
			return sanitize_textarea_field( (string) $value );
		case 'url':
			return esc_url_raw( (string) $value );
		case 'checkbox':
			return empty( $value ) ? '0' : '1';
		default:
			return sanitize_text_field( (string) $value );
	}
}

/** Lưu ảnh base64 vào Thư viện (gắn với dự án). Trả về ID ảnh hoặc 0. */
function hh_quick_upload( $post_id, $img ) {
	if ( empty( $img['data'] ) ) {
		return 0;
	}
	$bin = base64_decode( $img['data'], true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
	if ( ! $bin || strlen( $bin ) > 8 * MB_IN_BYTES ) {
		return 0;
	}
	$info = getimagesizefromstring( $bin );
	$ext  = array( 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp' )[ $info['mime'] ?? '' ] ?? '';
	if ( ! $ext ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$name = sanitize_file_name( pathinfo( (string) ( $img['name'] ?? 'anh-du-an' ), PATHINFO_FILENAME ) ) . '.' . $ext;
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || false === file_put_contents( $tmp, $bin ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions
		return 0;
	}
	$alt = sanitize_text_field( (string) ( $img['alt'] ?? '' ) );
	$att = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), $post_id, $alt );
	if ( is_wp_error( $att ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $att, '_wp_attachment_image_alt', $alt );
	return (int) $att;
}

/**
 * Áp dụng gói dự án. Trả về array( id, created(bool), changed labels[] ) hoặc WP_Error.
 */
function hh_quick_project_apply( $n ) {
	$fields  = hh_quick_project_fields();
	$old     = get_page_by_path( $n['slug'], OBJECT, 'du-an' );
	$created = ! $old;
	$backup  = array();
	$changed = array();

	if ( $created ) {
		if ( empty( $n['title'] ) ) {
			return new WP_Error( 'format', 'Gói dự án mới thiếu tên (title).' );
		}
		$id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'du-an',
					'post_status'  => 'draft',
					'post_name'    => $n['slug'],
					'post_title'   => $n['title'],
					'post_excerpt' => (string) ( $n['excerpt'] ?? '' ),
					'post_content' => wp_kses_post( (string) ( $n['content'] ?? '' ) ),
				)
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			return $id;
		}
		$changed[] = 'Tạo dự án mới (bản nháp)';
	} else {
		$id  = $old->ID;
		$upd = array( 'ID' => $id );
		foreach ( array( 'title' => 'post_title', 'excerpt' => 'post_excerpt', 'content' => 'post_content' ) as $k => $col ) {
			if ( isset( $n[ $k ] ) && '' !== (string) $n[ $k ] ) {
				$backup[ $col ] = $old->$col;
				$upd[ $col ]    = 'post_content' === $col ? wp_kses_post( (string) $n[ $k ] ) : (string) $n[ $k ];
				$changed[]      = array( 'post_title' => 'Tên dự án', 'post_excerpt' => 'Mô tả ngắn', 'post_content' => 'Bài giới thiệu' )[ $col ];
			}
		}
		if ( count( $upd ) > 1 ) {
			wp_update_post( wp_slash( $upd ) );
		}
	}

	// Phân loại, khu vực, tổ hợp.
	foreach ( (array) ( $n['types'] ?? array() ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'loai-du-an' );
		if ( $term ) {
			wp_set_object_terms( $id, (int) $term->term_id, 'loai-du-an', true );
		}
	}
	if ( ! empty( $n['area'] ) && ( $created || ! has_term( '', 'khu-vuc', $id ) ) ) {
		$area = get_term_by( 'slug', $n['area'], 'khu-vuc' );
		if ( $area ) {
			wp_set_object_terms( $id, (int) $area->term_id, 'khu-vuc' );
		}
	}
	if ( ! empty( $n['parent'] ) ) {
		$parent = get_page_by_path( $n['parent'], OBJECT, 'du-an' );
		if ( $parent ) {
			$backup['meta']['hh_p_parent'] = get_post_meta( $id, 'hh_p_parent', true );
			update_post_meta( $id, 'hh_p_parent', $parent->ID );
		}
	}

	// Các ô thông tin: chỉ ô có trong gói.
	foreach ( (array) ( $n['meta'] ?? array() ) as $key => $value ) {
		if ( ! isset( $fields[ $key ] ) || in_array( $fields[ $key ][0], array( 'image', 'gallery', 'file', 'files', 'post' ), true ) ) {
			continue;
		}
		$value = hh_quick_project_value( $fields[ $key ][0], $value );
		$cur   = (string) get_post_meta( $id, $key, true );
		if ( $cur === $value ) {
			continue;
		}
		$backup['meta'][ $key ] = $cur;
		if ( '' === $value ) {
			delete_post_meta( $id, $key );
		} else {
			update_post_meta( $id, $key, $value );
		}
		$changed[] = $fields[ $key ][1];
	}

	// Ảnh: ảnh đại diện, ô 1 ảnh (thay), ô thư viện (thêm vào, hoặc thay khi gallery_mode = replace).
	foreach ( (array) ( $n['images'] ?? array() ) as $key => $imgs ) {
		if ( 'featured' === $key ) {
			$att = hh_quick_upload( $id, (array) $imgs );
			if ( $att ) {
				$backup['thumb'] = (int) get_post_thumbnail_id( $id );
				set_post_thumbnail( $id, $att );
				$changed[] = 'Ảnh đại diện';
			}
			continue;
		}
		if ( ! isset( $fields[ $key ] ) ) {
			continue;
		}
		$type = $fields[ $key ][0];
		if ( 'image' === $type ) {
			$att = hh_quick_upload( $id, (array) $imgs );
			if ( $att ) {
				$backup['meta'][ $key ] = (string) get_post_meta( $id, $key, true );
				update_post_meta( $id, $key, $att );
				$changed[] = $fields[ $key ][1];
			}
		} elseif ( 'gallery' === $type ) {
			$ids = array();
			foreach ( (array) $imgs as $img ) {
				$att = hh_quick_upload( $id, (array) $img );
				if ( $att ) {
					$ids[] = $att;
				}
			}
			if ( $ids ) {
				$cur                    = (string) get_post_meta( $id, $key, true );
				$backup['meta'][ $key ] = $cur;
				$keep                   = 'replace' === ( $n['gallery_mode'] ?? 'append' ) ? array() : array_filter( array_map( 'absint', explode( ',', $cur ) ) );
				update_post_meta( $id, $key, implode( ',', array_merge( $keep, $ids ) ) );
				$changed[] = $fields[ $key ][1] . ' (+' . count( $ids ) . ' ảnh)';
			}
		}
	}

	if ( ! empty( $n['sources'] ) ) {
		$cur = (string) get_post_meta( $id, 'hh_p_sources', true );
		$add = array_diff( array_map( 'esc_url_raw', (array) $n['sources'] ), explode( "\n", $cur ) );
		if ( $add ) {
			update_post_meta( $id, 'hh_p_sources', trim( $cur . "\n" . implode( "\n", $add ) ) );
		}
	}

	if ( ! $created && $backup ) {
		$all = array_filter( (array) get_post_meta( $id, '_hh_quick_backup', true ), 'is_array' );
		$all[ (string) time() ] = $backup;
		update_post_meta( $id, '_hh_quick_backup', array_slice( $all, -5, null, true ) );
	}
	update_post_meta( $id, '_hh_quick_post', current_time( 'mysql' ) );
	return array( $id, $created, $changed );
}

/** Hoàn tác một lần cập nhật nhanh (khôi phục giá trị cũ đã lưu). */
function hh_quick_project_undo( $id, $time ) {
	$all = array_filter( (array) get_post_meta( $id, '_hh_quick_backup', true ), 'is_array' );
	if ( empty( $all[ $time ] ) ) {
		return false;
	}
	$b   = $all[ $time ];
	$upd = array_intersect_key( $b, array_flip( array( 'post_title', 'post_excerpt', 'post_content' ) ) );
	if ( $upd ) {
		wp_update_post( wp_slash( array( 'ID' => $id ) + $upd ) );
	}
	foreach ( (array) ( $b['meta'] ?? array() ) as $key => $value ) {
		if ( '' === (string) $value ) {
			delete_post_meta( $id, $key );
		} else {
			update_post_meta( $id, $key, $value );
		}
	}
	if ( isset( $b['thumb'] ) ) {
		$b['thumb'] ? set_post_thumbnail( $id, $b['thumb'] ) : delete_post_thumbnail( $id );
	}
	unset( $all[ $time ] );
	update_post_meta( $id, '_hh_quick_backup', $all );
	return true;
}

/** Các lần cập nhật nhanh gần đây (để hiện nút Hoàn tác). */
function hh_quick_project_recent() {
	$rows = array();
	foreach ( get_posts( array( 'post_type' => 'du-an', 'post_status' => 'any', 'numberposts' => 20, 'meta_key' => '_hh_quick_backup', 'fields' => 'ids' ) ) as $id ) { // phpcs:ignore WordPress.DB.SlowDBQuery
		foreach ( array_keys( array_filter( (array) get_post_meta( $id, '_hh_quick_backup', true ), 'is_array' ) ) as $time ) {
			$rows[] = array( $id, (string) $time );
		}
	}
	usort( $rows, static fn( $a, $b ) => (int) $b[1] <=> (int) $a[1] );
	return array_slice( $rows, 0, 10 );
}
