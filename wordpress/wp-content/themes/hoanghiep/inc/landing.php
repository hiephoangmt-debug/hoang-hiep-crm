<?php
/**
 * Trang dự án dạng landing (VD Sun Saphia Residence): file landing/<đường dẫn dự án>.html dựng từ bộ landing riêng
 * (scripts/landing-sun-saphia.py). Có file thì trang dự án hiện landing thay giao diện chuẩn; vẫn giữ SEO, sitemap,
 * đo lường của WordPress. Muốn về giao diện chuẩn: sửa dự án → ô "Giao diện trang" chọn Chuẩn (hh_p_layout = chuan).
 */

defined( 'ABSPATH' ) || exit;

function hoanghiep_landing_file() {
	if ( ! is_singular( 'du-an' ) ) {
		return '';
	}
	$id = get_queried_object_id();
	if ( 'chuan' === get_post_meta( $id, 'hh_p_layout', true ) ) {
		return '';
	}
	$file = get_theme_file_path( 'landing/' . get_post_field( 'post_name', $id ) . '.html' );
	return is_file( $file ) ? $file : '';
}

// Landing có CSS, chat, nút liên hệ riêng – không tải CSS/JS giao diện chuẩn và chat của web (tránh chồng, trùng).
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! hoanghiep_landing_file() ) {
			return;
		}
		wp_dequeue_style( 'hoanghiep' );
		wp_dequeue_script( 'hoanghiep' );
		wp_dequeue_script( 'hh-chat' );
	},
	100
);
