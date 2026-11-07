<?php
/**
 * "Khu đô thị sinh thái Hòa Xuân" và "Sun NeO City" là một dự án (tên cũ – tên mới, anh Hiệp 07/11/2026):
 * gộp về trang Sun NeO City. Trang cũ /du-an/kdt-sinh-thai-hoa-xuan/ chuyển bản nháp và tự chuyển hướng (301);
 * phân khu Đất nền Cồn Dầu, Euro Village 2 chuyển thành dự án thành phần của Sun NeO City.
 */

defined( 'ABSPATH' ) || exit;

const HH_HOA_XUAN_OLD = 'kdt-sinh-thai-hoa-xuan';

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$out = array();
		foreach ( $projects as $p ) {
			$slug = $p['slug'] ?? '';
			if ( HH_HOA_XUAN_OLD === $slug ) {
				continue; // Không nhập lại trang cũ.
			}
			if ( HH_HOA_XUAN_OLD === ( $p['parent'] ?? '' ) ) {
				$p['parent'] = 'sun-neo-city';
			}
			if ( 'sun-neo-city' === $slug ) {
				$m   = $p['meta'];
				$new = array(
					'hh_p_scale' => 'Khoảng 450 ha (Khu đô thị sinh thái ven sông Hòa Xuân); cùng Sun Riverpolis tạo hệ sinh thái hơn 1.000 ha',
					'hh_p_type'  => 'Căn hộ, shophouse khối đế, đất nền, nhà phố, biệt thự ven sông',
					'hh_p_zones' => trim( (string) ( $m['hh_p_zones'] ?? '' ) ) . "\nĐất nền Cồn Dầu | Đất nền phân lô | Khoảng 10 ha – 600 lô | Đang mở bán\nEuro Village 2 (giai đoạn 1B) | Nhà phố liền kề, biệt thự | 23,7 ha – 245 nhà phố, 175 biệt thự | Đã có sổ, giao dịch thứ cấp",
				);
				foreach ( $new as $k => $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = (string) ( $m[ $k ] ?? '' );
					$p['meta'][ $k ]       = $v;
				}
				$p['fix_excerpt'] = $p['excerpt'];
				$p['excerpt']     = 'Sun NeO City – trước đây quen gọi là Khu đô thị sinh thái Hòa Xuân – khu đô thị khoảng 450 ha của Sun Group ven sông Cẩm Lệ, phía Nam Đà Nẵng. Gồm các tòa căn hộ Cora, Spana, S-Light, đất nền Cồn Dầu, Euro Village 2 và phân khu Sunneva Island.';
				$p['type']        = array_values( array_unique( array_merge( (array) $p['type'], array( 'dat-nen' ) ) ) );
			}
			$out[] = $p;
		}
		return $out;
	},
	96
);

// Một lần: chuyển phân khu sang Sun NeO City, đưa trang cũ về bản nháp (không xoá).
add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_gop_hoa_xuan_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$old = get_page_by_path( HH_HOA_XUAN_OLD, OBJECT, 'du-an' );
		$neo = get_page_by_path( 'sun-neo-city', OBJECT, 'du-an' );
		if ( ! $neo ) {
			return;
		}
		if ( $old ) {
			foreach ( get_posts( array( 'post_type' => 'du-an', 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => 'hh_p_parent', 'meta_value' => $old->ID ) ) as $child ) {
				update_post_meta( $child, 'hh_p_parent', $neo->ID );
			}
			if ( 'publish' === $old->post_status ) {
				wp_update_post( array( 'ID' => $old->ID, 'post_status' => 'draft' ) );
			}
		}
		update_option( 'hh_gop_hoa_xuan_v1', '1', false );
	}
);

// Đường dẫn cũ → trang Sun NeO City (301), giữ khách và thứ hạng tìm kiếm.
add_action(
	'template_redirect',
	static function () {
		$path = (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( preg_match( '#/du-an/' . HH_HOA_XUAN_OLD . '/?$#', $path ) ) {
			wp_safe_redirect( home_url( '/du-an/sun-neo-city/' ), 301 );
			exit;
		}
	},
	1
);

/**
 * Bản vẽ "tổng mặt bằng Sun NeO City" thực ra là mặt bằng phân lô đất nền Cồn Dầu (anh Hiệp 07/11/2026):
 * gỡ khỏi trang Sun NeO City (ảnh tải trùng 2 lần – xoá bản thừa), chuyển 1 bản sang trang Đất nền Cồn Dầu, sửa chú thích.
 */
add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_con_dau_plan_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$neo = get_page_by_path( 'sun-neo-city', OBJECT, 'du-an' );
		$cd  = get_page_by_path( 'dat-nen-con-dau-hoa-xuan', OBJECT, 'du-an' );
		if ( ! $neo || ! $cd ) {
			return;
		}
		$ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $neo->ID, 'hh_p_masterplan_img', true ) ) ) );
		$plan = array();
		foreach ( $ids as $aid ) {
			if ( false !== strpos( (string) get_attached_file( $aid ), 'tong-mat-bang-khu-do-thi-sun-neo-city' ) ) {
				$plan[] = $aid;
			}
		}
		if ( $plan ) {
			$keep = (int) array_shift( $plan );
			foreach ( $plan as $dup ) {
				wp_delete_attachment( $dup, true );
			}
			update_post_meta( $neo->ID, 'hh_p_masterplan_img', implode( ',', array_diff( $ids, array( $keep ), $plan ) ) );
			$alt = 'Mặt bằng phân lô đất nền Cồn Dầu – Sun NeO City Hòa Xuân (bản vẽ chủ đầu tư, tham khảo)';
			update_post_meta( $keep, '_wp_attachment_image_alt', $alt );
			wp_update_post( array( 'ID' => $keep, 'post_excerpt' => $alt, 'post_parent' => $cd->ID ) );
			$cd_ids   = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $cd->ID, 'hh_p_masterplan_img', true ) ) ) );
			$cd_ids[] = $keep;
			update_post_meta( $cd->ID, 'hh_p_masterplan_img', implode( ',', array_unique( $cd_ids ) ) );
			// Ghi nhớ link ảnh cho trang Cồn Dầu để web không tải lại bản vẽ này lần nữa.
			$neo_done = (array) get_post_meta( $neo->ID, '_hh_img_links', true );
			$cd_done  = (array) get_post_meta( $cd->ID, '_hh_img_links', true );
			foreach ( $neo_done as $k => $v ) {
				if ( false !== strpos( (string) $k, '1Fj7V4DJyp12BKdgOqKwJRbkFkdH-ccL0' ) ) {
					$cd_done[ $k ] = $keep;
				}
			}
			update_post_meta( $cd->ID, '_hh_img_links', $cd_done );
			if ( ! has_post_thumbnail( $cd->ID ) ) {
				set_post_thumbnail( $cd->ID, $keep );
			}
		}
		update_option( 'hh_con_dau_plan_v1', '1', false );
	}
);

/**
 * Ảnh nền (ảnh đại diện) Sun NeO City, Euro Village 2, Đất nền Cồn Dầu đang là bản vẽ mặt bằng Cồn Dầu →
 * đổi sang ảnh flycam toàn khu Hòa Xuân ven sông Cẩm Lệ (8/2025). Bản vẽ vẫn ở mục Mặt bằng của trang Cồn Dầu.
 * Chỉ đổi khi ảnh đại diện hiện tại đúng là bản vẽ đó (ảnh anh tự chọn giữ nguyên).
 */
add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_hoa_xuan_hero_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$neo = get_page_by_path( 'sun-neo-city', OBJECT, 'du-an' );
		if ( ! $neo ) {
			return;
		}
		$key  = 'plugin:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg';
		$done = (array) get_post_meta( $neo->ID, '_hh_img_links', true );
		$fly  = (int) ( $done[ $key ] ?? 0 );
		if ( ! $fly || ! wp_attachment_is_image( $fly ) ) {
			// Chưa tải: lấy thẳng từ ảnh đi kèm plugin vào Thư viện, ghi nhớ để lần "Tải ảnh" sau không tải trùng.
			$file = HH_CRM_DIR . 'img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg';
			if ( ! is_file( $file ) ) {
				return;
			}
			$up = wp_upload_bits( basename( $file ), null, (string) file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			if ( ! empty( $up['error'] ) ) {
				return;
			}
			$alt = 'Toàn cảnh khu đô thị ven sông Hòa Xuân, sông Cẩm Lệ uốn quanh, nhìn về trung tâm Đà Nẵng (ảnh flycam thực tế 8/2025)';
			$fly = wp_insert_attachment( array( 'post_mime_type' => 'image/jpeg', 'post_title' => $alt, 'post_excerpt' => $alt, 'post_status' => 'inherit' ), $up['file'], $neo->ID );
			if ( ! $fly || is_wp_error( $fly ) ) {
				return;
			}
			require_once ABSPATH . 'wp-admin/includes/image.php';
			wp_update_attachment_metadata( $fly, wp_generate_attachment_metadata( $fly, $up['file'] ) );
			update_post_meta( $fly, '_wp_attachment_image_alt', $alt );
			$done[ $key ] = $fly;
			update_post_meta( $neo->ID, '_hh_img_links', $done );
		}
		foreach ( array( 'sun-neo-city', 'euro-village-2', 'dat-nen-con-dau-hoa-xuan' ) as $slug ) {
			$p = get_page_by_path( $slug, OBJECT, 'du-an' );
			if ( ! $p ) {
				continue;
			}
			$cur = (int) get_post_thumbnail_id( $p->ID );
			if ( ! $cur || false !== strpos( (string) get_attached_file( $cur ), 'tong-mat-bang-khu-do-thi-sun-neo-city' ) ) {
				set_post_thumbnail( $p->ID, $fly );
			}
		}
		update_option( 'hh_hoa_xuan_hero_v1', '1', false );
	}
);
