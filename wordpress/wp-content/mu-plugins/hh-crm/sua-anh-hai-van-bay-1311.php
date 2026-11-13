<?php
/**
 * Vinhomes Hải Vân Bay (13/11/2026): lượt tải ảnh trước dừng ở ảnh thứ 18 của phân khu Đảo Ngọc
 * (còn vườn cờ + 8 ảnh Công viên Nắng Biển). Chạy 1 lần trong trang quản trị: bỏ đánh dấu lỗi / bỏ qua
 * của các ảnh "plugin:img/vinhomes-hai-van-bay/…" chưa tải được, xoá bộ đếm lỗi rồi đưa 3 trang Hải Vân Bay
 * vào lại hàng chờ – bấm "Tải ảnh ngay" là tải tiếp. Ảnh đã tải thì giữ nguyên (không tải trùng).
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_init',
	static function () {
		if ( 'v2' === get_option( 'hh_sua_anh_hvb_1311' ) || ! function_exists( 'hh_img_links_queue' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		foreach ( array( 'vinhomes-hai-van-bay-dao-ngoc', 'vinhomes-hai-van-bay', 'vinhomes-hai-van-bay-bach-van' ) as $slug ) {
			$post = get_page_by_path( $slug, OBJECT, 'du-an' );
			if ( ! $post ) {
				continue;
			}
			$done    = (array) get_post_meta( $post->ID, '_hh_img_links', true );
			$changed = false;
			foreach ( $done as $key => $val ) {
				if ( 0 === strpos( (string) $key, 'plugin:img/vinhomes-hai-van-bay/' ) && ! is_int( $val ) ) {
					unset( $done[ $key ] );
					delete_post_meta( $post->ID, '_hh_img_fail_' . md5( $key ) );
					$changed = true;
				}
			}
			if ( $changed ) {
				update_post_meta( $post->ID, '_hh_img_links', $done );
			}
			delete_post_meta( $post->ID, '_hh_img_links_tries' );
			delete_post_meta( $post->ID, '_hh_img_links_err' );
			if ( hh_img_links_pending( $post->ID ) ) {
				hh_img_links_queue( $post->ID );
			}
		}
		update_option( 'hh_sua_anh_hvb_1311', 'v2', false );
	},
	30
);
