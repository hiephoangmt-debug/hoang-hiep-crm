<?php
/**
 * Dừng bài "Bản tin quy hoạch – hạ tầng Đà Nẵng sáng dd/mm/yyyy" (danh sách link tin tổng hợp, không ảnh) do
 * tác vụ GitHub news-telegram/publish_digest.py đăng qua REST API – anh Hiệp yêu cầu dừng kiểu viết này 05/11/2026.
 * - Từ chối tạo / cập nhật bài có tiêu đề này qua REST API.
 * - Một lần: chuyển các bài bản tin đã đăng về Bản nháp (khôi phục được trong Bài viết → Bản nháp).
 */

defined( 'ABSPATH' ) || exit;

function hh_is_ban_tin_tong_hop( $title ) {
	return (bool) preg_match( '/^\s*Bản tin quy hoạch\s*[–-]\s*hạ tầng/iu', (string) $title );
}

add_filter(
	'rest_pre_insert_post',
	static function ( $prepared, $request ) {
		$title = $prepared->post_title ?? ( ! empty( $prepared->ID ) ? get_the_title( $prepared->ID ) : '' );
		if ( hh_is_ban_tin_tong_hop( $title ) ) {
			return new WP_Error( 'hh_ban_tin_off', 'Bản tin tổng hợp tự động đã tắt trên hiephoangmt.com.', array( 'status' => 403 ) );
		}
		return $prepared;
	},
	10,
	2
);

add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_ban_tin_off_v1' ) || ! current_user_can( 'edit_others_posts' ) ) {
			return;
		}
		update_option( 'hh_ban_tin_off_v1', 1, false );
		$ids = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => array( 'publish', 'future' ),
				's'              => 'Bản tin quy hoạch',
				'search_columns' => array( 'post_title' ),
				'numberposts'    => 200,
				'fields'         => 'ids',
			)
		);
		foreach ( $ids as $id ) {
			if ( hh_is_ban_tin_tong_hop( get_the_title( $id ) ) ) {
				wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
			}
		}
		do_action( 'litespeed_purge_all' );
	}
);
