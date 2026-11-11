<?php
/**
 * Trang dự án chưa có ảnh đại diện (trang tham khảo không dùng ảnh quảng cáo trang khác): gắn ảnh bìa tự vẽ
 * img/du-an-bia/{slug}.jpg (bai-viet/anh-bia-du-an.py). Chỉ đặt ảnh đại diện – không đưa vào Thư viện ảnh dự án,
 * không đè ảnh đã có. Chạy dần trong trang quản trị, mỗi lượt 5 dự án để không quá thời gian; xong thì thôi.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_init',
	static function () {
		$ver = HH_CRM_VERSION;
		if ( get_option( 'hh_du_an_bia_done' ) === $ver || ! current_user_can( 'upload_files' ) || wp_doing_ajax() ) {
			return;
		}
		$dir   = HH_CRM_DIR . 'img/du-an-bia/';
		$files = glob( $dir . '*.jpg' ) ?: array();
		$todo  = 0;
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		foreach ( $files as $file ) {
			$post = get_page_by_path( basename( $file, '.jpg' ), OBJECT, 'du-an' );
			if ( ! $post || has_post_thumbnail( $post->ID ) || get_post_meta( $post->ID, '_hh_bia_fail', true ) ) {
				continue;
			}
			if ( ++$todo > 5 ) {
				break; // Lượt sau (lần mở trang quản trị kế tiếp) làm tiếp.
			}
			$tmp = wp_tempnam( basename( $file ) );
			if ( ! $tmp || ! copy( $file, $tmp ) ) {
				continue;
			}
			$alt = 'Ảnh bìa ' . get_the_title( $post );
			$att = media_handle_sideload( array( 'name' => basename( $file ), 'tmp_name' => $tmp ), $post->ID, $alt );
			if ( is_wp_error( $att ) ) {
				wp_delete_file( $tmp );
				update_post_meta( $post->ID, '_hh_bia_fail', 1 );
				continue;
			}
			update_post_meta( $att, '_wp_attachment_image_alt', $alt );
			update_post_meta( $att, '_hh_img_src', 'plugin:img/du-an-bia/' . basename( $file ) );
			set_post_thumbnail( $post->ID, $att );
		}
		if ( $todo <= 5 ) {
			update_option( 'hh_du_an_bia_done', $ver, false );
		}
	},
	30
);
