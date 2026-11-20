<?php
/**
 * Gộp trang dự án trùng: trang cũ chuyển hướng 301 sang trang mới đầy đủ hơn, trang cũ chuyển nháp (không hiện ở danh sách, sơ đồ trang).
 * 19/11/2026: "Nhà ở xã hội Khu chung cư số 5 – Nam cầu Cẩm Lệ" (tạo từ du-an-tong-hop.json) trùng với trang Việt Hương Lakeside.
 */

defined( 'ABSPATH' ) || exit;

/** Danh sách slug cũ => slug mới (cùng loại du-an). */
function hh_du_an_gop_trang() {
	return array(
		'nha-o-xa-hoi-chung-cu-so-5-nam-cau-cam-le' => 'viet-huong-lakeside-hoa-xuan',
	);
}

// Không nhập lại trang cũ từ bộ dữ liệu.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$old = hh_du_an_gop_trang();
		return array_values( array_filter( $projects, static fn( $p ) => ! isset( $old[ $p['slug'] ?? '' ] ) ) );
	},
	999
);

// Chuyển trang cũ sang nháp (chạy khi vào trang quản trị, mỗi slug một lần).
add_action(
	'admin_init',
	static function () {
		$done = (array) get_option( 'hh_du_an_gop_done', array() );
		foreach ( hh_du_an_gop_trang() as $old => $new ) {
			if ( in_array( $old, $done, true ) ) {
				continue;
			}
			$p = get_page_by_path( $old, OBJECT, 'du-an' );
			$n = get_page_by_path( $new, OBJECT, 'du-an' );
			if ( $p && $n && 'publish' === $p->post_status ) {
				wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
			}
			if ( $n ) {
				$done[] = $old;
			}
		}
		update_option( 'hh_du_an_gop_done', array_values( array_unique( $done ) ), false );
	}
);

// Chuyển hướng 301 đường dẫn cũ.
add_action(
	'template_redirect',
	static function () {
		$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		foreach ( hh_du_an_gop_trang() as $old => $new ) {
			if ( 'du-an/' . $old === $path ) {
				wp_safe_redirect( home_url( '/du-an/' . $new . '/' ), 301 );
				exit;
			}
		}
	},
	1
);

/**
 * Bài viết đổi đường dẫn (bài tự đăng bị bỏ qua, đăng lại đường dẫn mới) – link cũ đã chia sẻ chuyển 301.
 * 20/11/2026: link Facebook /can-ho-hang-hieu-la-gi-nobu-da-nang/ báo "Page Not Found".
 */
function hh_bai_doi_duong_dan() {
	return array(
		'can-ho-hang-hieu-la-gi-nobu-da-nang' => 'can-ho-hang-hieu-la-gi-nobu-residences',
	);
}

add_action(
	'template_redirect',
	static function () {
		$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$map  = hh_bai_doi_duong_dan();
		if ( isset( $map[ $path ] ) && ! get_page_by_path( $path, OBJECT, 'post' ) ) {
			wp_safe_redirect( home_url( '/' . $map[ $path ] . '/' ), 301 );
			exit;
		}
	},
	1
);
