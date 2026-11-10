<?php
/**
 * Spana Tower: bỏ mã căn (S20812, S10801…) khỏi chữ hiển thị – bảng loại căn, chú thích và tiêu đề ảnh layout.
 * Ghi theo tòa + diện tích ("3PN – tòa S2, 76,8 m²"). Ảnh bản vẽ chủ đầu tư giữ nguyên. Chạy một lần (anh Hiệp 10/11/2026).
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

/** Thay "3PN – S20801 (S2)" → "3PN – tòa S2, 76,8 m²" (có diện tích) hoặc "3PN – tòa S2" (khi dòng đã ghi diện tích). */
function hh_spana_bo_ma( $text, $with_area = false ) {
	$area = array( 'S20812' => '31,6', 'S20805' => '54,2', 'S10816' => '62,2', 'S10811' => '65,6', 'S10832' => '75,1', 'S20816' => '78,7', 'S20801' => '76,8', 'S10801' => '95,5' );
	return preg_replace_callback(
		'/(Studio|1PN\+|2PN|3PN) – (S([12])\d{4}) \(S[12]\)/u',
		static fn( $m ) => $m[1] . ' – tòa S' . $m[3] . ( $with_area && isset( $area[ $m[2] ] ) ? ', ' . $area[ $m[2] ] . ' m²' : '' ),
		(string) $text
	);
}

add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_spana_bo_ma_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$p = get_page_by_path( 'spana-tower', OBJECT, 'du-an' );
		if ( ! $p ) {
			return; // Chưa nhập dự án – lần nhập sau dùng dữ liệu đã sạch.
		}
		foreach ( array( 'hh_p_unit_types', 'hh_p_image_links' ) as $key ) {
			$old = (string) get_post_meta( $p->ID, $key, true );
			$new = 'hh_p_image_links' === $key
				? implode( "\n", array_map( static function ( $line ) {
					$parts = explode( '|', $line );
					if ( isset( $parts[1] ) ) {
						$parts[1] = str_replace( ' Spana Tower', ' Spana Tower (bản vẽ chủ đầu tư)', hh_spana_bo_ma( $parts[1], true ) );
					}
					if ( isset( $parts[3] ) ) {
						$parts[3] = ' ' . hh_spana_bo_ma( trim( $parts[3] ), true );
					}
					return implode( '|', $parts );
				}, explode( "\n", $old ) ) )
				: hh_spana_bo_ma( $old );
			if ( $new !== $old ) {
				update_post_meta( $p->ID, $key, $new );
			}
		}
		// Ảnh đã tải về thư viện: sửa chú thích, alt, tiêu đề.
		$ids = array_filter( array_map( 'intval', (array) get_post_meta( $p->ID, '_hh_img_links', true ) ) );
		$ids = array_unique( array_merge( $ids, get_children( array( 'post_parent' => $p->ID, 'post_type' => 'attachment', 'fields' => 'ids' ) ) ) );
		foreach ( $ids as $id ) {
			$att = get_post( $id );
			if ( ! $att ) {
				continue;
			}
			$alt     = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
			$new_alt = str_replace( ' Spana Tower', ' Spana Tower (bản vẽ chủ đầu tư)', hh_spana_bo_ma( $alt, true ) );
			if ( $new_alt !== $alt ) {
				update_post_meta( $id, '_wp_attachment_image_alt', $new_alt );
			}
			$upd = array();
			foreach ( array( 'post_title', 'post_excerpt', 'post_content' ) as $f ) {
				$v = hh_spana_bo_ma( $att->$f, true );
				if ( $v !== $att->$f ) {
					$upd[ $f ] = 'post_excerpt' === $f ? str_replace( ' Spana Tower', ' Spana Tower (bản vẽ chủ đầu tư)', $v ) : $v;
				}
			}
			if ( $upd ) {
				wp_update_post( array( 'ID' => $id ) + $upd );
			}
		}
		update_option( 'hh_spana_bo_ma_v1', 1, false );
	}
);
