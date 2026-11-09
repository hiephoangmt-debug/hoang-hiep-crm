<?php
/**
 * Ảnh PNG dạng ảnh chụp/phối cảnh rất nặng (có ảnh 6,6 MB, bản 1024px vẫn 1,4 MB) → làm trang tải chậm trên điện thoại.
 * - Ảnh PNG tải lên từ nay: các cỡ thu nhỏ (1536, 1024, 768, 300…) lưu dạng WebP (nhẹ hơn 10 – 20 lần, giữ nền trong suốt).
 * - Ảnh PNG lớn đã có: mỗi lần mở trang quản trị, tạo lại các cỡ thu nhỏ dạng WebP cho vài ảnh (đến khi hết).
 *   File PNG cũ giữ nguyên (bài viết cũ có thể đang dùng), chỉ đổi cỡ ảnh web hiển thị.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'image_editor_output_format',
	static function ( $formats ) {
		if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			$formats['image/png'] = 'image/webp';
		}
		return $formats;
	}
);

add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || get_option( 'hh_png_webp_xong_v1' ) || ! current_user_can( 'upload_files' ) || ! wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			return;
		}
		$ids = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => 'image/png',
				'posts_per_page' => 40,
				'fields'         => 'ids',
				'meta_query'     => array( array( 'key' => '_hh_png_webp', 'compare' => 'NOT EXISTS' ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
			)
		);
		if ( ! $ids ) {
			update_option( 'hh_png_webp_xong_v1', 1, false );
			return;
		}
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$start = microtime( true );
		$done  = 0;
		foreach ( $ids as $id ) {
			if ( $done >= 3 || microtime( true ) - $start > 15 ) {
				break;
			}
			update_post_meta( $id, '_hh_png_webp', 1 );
			$file = get_attached_file( $id );
			if ( ! $file || ! is_file( $file ) || filesize( $file ) < 300 * 1024 ) {
				continue; // Ảnh PNG nhỏ (logo, biểu tượng): để nguyên.
			}
			$meta = wp_generate_attachment_metadata( $id, $file );
			if ( $meta && ! is_wp_error( $meta ) ) {
				wp_update_attachment_metadata( $id, $meta );
			}
			++$done;
		}
	}
);
