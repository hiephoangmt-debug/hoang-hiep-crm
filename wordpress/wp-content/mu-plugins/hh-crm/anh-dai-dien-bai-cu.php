<?php
/**
 * Bài cũ (tuần 01 – 14) chưa khai báo ảnh đại diện và không gắn dự án: dùng ảnh bìa tự vẽ img/tin-tuc/{slug}.jpg
 * (bai-viet/anh-bia-bai-cu.py). Bài gắn dự án lấy ảnh đại diện của trang dự án (data-tin-tuc-ha-tang.php).
 * Chỉ gắn khi bài trên web chưa có ảnh đại diện – không đè ảnh đã chọn tay.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_news_posts',
	static function ( $posts ) {
		foreach ( $posts as &$p ) {
			if ( empty( $p['image'] ) && empty( $p['project'] ) && ! empty( $p['slug'] ) && is_file( HH_CRM_DIR . 'img/tin-tuc/' . $p['slug'] . '.jpg' ) ) {
				$p['image'] = 'plugin:img/tin-tuc/' . $p['slug'] . '.jpg';
			}
		}
		return $posts;
	},
	999
);
