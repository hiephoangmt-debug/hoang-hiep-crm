<?php
/**
 * Trang cũ /du-an/cora-tower-da-nang/ ("CORA TOWER: Bảng giá, chính sách 10/2025") trùng trang chính /du-an/cora-tower/
 * – Search Console 11/2026 cho thấy Google lập chỉ mục cả hai, tranh cùng từ khóa. Gộp về trang chính:
 * chuyển trang cũ sang Nháp (không xoá), bài tin / dự án con đang gắn trang cũ chuyển sang trang chính, đường dẫn cũ 301.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_gop_cora_cu_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$old = get_page_by_path( 'cora-tower-da-nang', OBJECT, 'du-an' );
		$new = get_page_by_path( 'cora-tower', OBJECT, 'du-an' );
		if ( ! $new ) {
			return;
		}
		if ( $old && $old->ID !== $new->ID ) {
			foreach ( array( 'hh_post_project' => 'post', 'hh_p_parent' => 'du-an' ) as $key => $type ) {
				foreach ( get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => $key, 'meta_value' => $old->ID ) ) as $pid ) {
					update_post_meta( $pid, $key, $new->ID );
				}
			}
			if ( 'publish' === $old->post_status ) {
				wp_update_post( array( 'ID' => $old->ID, 'post_status' => 'draft' ) );
			}
		}
		update_option( 'hh_gop_cora_cu_v1', '1', false );
	}
);

add_action(
	'template_redirect',
	static function () {
		$path = (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( preg_match( '#/du-an/cora-tower-da-nang/?$#', $path ) && get_page_by_path( 'cora-tower', OBJECT, 'du-an' ) ) {
			wp_safe_redirect( home_url( '/du-an/cora-tower/' ), 301 );
			exit;
		}
	},
	1
);
