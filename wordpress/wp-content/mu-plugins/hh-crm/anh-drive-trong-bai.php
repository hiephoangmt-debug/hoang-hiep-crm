<?php
/**
 * Ảnh Google Drive chèn giữa bài viết: <!--hh-dimg:MÃ_FILE_DRIVE|Chú thích-->.
 * Ảnh lấy từ Thư viện – bản web đã tải về qua ô "Link ảnh" của dự án (drive.google.com/thumbnail?id=MÃ…).
 * Ảnh chưa tải xong thì tạm ẩn, tải xong tự hiện (xử lý lúc hiển thị bài).
 */

defined( 'ABSPATH' ) || exit;

/** Mã file Drive → ID ảnh trong Thư viện (từ danh sách link ảnh đã tải của các dự án). */
function hh_drive_attachment_id( $file_id ) {
	static $map = null;
	if ( null === $map ) {
		$map = get_transient( 'hh_drive_img_map' );
		if ( ! is_array( $map ) ) {
			$map = array();
			$ids = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => '_hh_img_links' ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
			foreach ( $ids as $pid ) {
				foreach ( (array) get_post_meta( $pid, '_hh_img_links', true ) as $url => $att ) {
					if ( is_int( $att ) && preg_match( '/[?&]id=([\w-]{10,})/', (string) $url, $m ) ) {
						$map[ $m[1] ] = $att;
					}
				}
			}
			set_transient( 'hh_drive_img_map', $map, 10 * MINUTE_IN_SECONDS );
		}
	}
	return (int) ( $map[ $file_id ] ?? 0 );
}

add_filter(
	'the_content',
	static function ( $html ) {
		if ( false === strpos( (string) $html, '<!--hh-dimg:' ) ) {
			return $html;
		}
		return preg_replace_callback(
			'/<!--hh-dimg:([\w-]{10,})\|([^>]*?)-->/',
			static function ( $m ) {
				$att = hh_drive_attachment_id( $m[1] );
				if ( ! $att || ! wp_get_attachment_url( $att ) ) {
					return '';
				}
				$cap = trim( $m[2] );
				return '<figure class="wp-block-image"><a href="' . esc_url( wp_get_attachment_url( $att ) ) . '" target="_blank" rel="noopener">' . wp_get_attachment_image( $att, 'large', false, array( 'alt' => $cap, 'loading' => 'lazy' ) ) . '</a>' . ( $cap ? '<figcaption>' . esc_html( $cap ) . '</figcaption>' : '' ) . '</figure>';
			},
			$html
		);
	},
	9
);
