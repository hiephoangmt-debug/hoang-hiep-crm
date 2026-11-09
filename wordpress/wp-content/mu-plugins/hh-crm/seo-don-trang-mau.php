<?php
/**
 * Dọn trang mẫu của giao diện cũ (Houzez demo: listing-v1…v6, user-dashboard, homepage-1, all-agents, about-this-demo…).
 * Các trang này tiếng Anh, không có nội dung, vẫn nằm trong sơ đồ trang gửi Google → làm loãng web, Google chậm lập chỉ mục
 * trang dự án. Chuyển một lần về Bản nháp (không xoá, khôi phục được trong Trang → Bản nháp) → hết khỏi sitemap, trả 404.
 */

defined( 'ABSPATH' ) || exit;

function hh_demo_page_slugs() {
	return array(
		'homepage-1', 'homepage-2', 'homepage-3', 'user-dashboard', 'user-dashboard-2', 'with-parallax', 'with-featured-on-top',
		'with-tabs', 'with-content-bottom', 'with-content-top', 'listing-v1', 'listing-v2', 'listing-v3', 'listing-v4', 'listing-v5',
		'listing-v6', 'listing-v1-list-view', 'listing-v2-list-view', 'listing-v5-list-view', 'listing-v1-full-width-2-cols',
		'listing-v2-full-width-2-cols', 'listing-v3-full-width-2-cols', 'listing-v5-full-width-2-cols', 'listing-v6-full-width-2-cols',
		'listing-v1-full-width-4-cols', 'listing-v2-full-width-4-cols', 'listing-v2-full-width', 'listing-v3-full-width',
		'listing-v5-full-width', 'listing-v6-full-width', 'all-agents', 'about-this-demo', 'compare', 'property-search',
		'create-listing', 'saved-search', 'properties', 'profile', 'messages', 'membership-info', 'invoices', 'insight',
		'gdpr-request', 'favorite-properties', 'search-results', 'how-much-is-my-home-worth', 'sell-with-us', 'find-an-agent',
	);
}

add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_demo_pages_don_v1' ) || ! current_user_can( 'edit_others_pages' ) ) {
			return;
		}
		$keep = array( (int) get_option( 'page_on_front' ), (int) get_option( 'page_for_posts' ) );
		foreach ( hh_demo_page_slugs() as $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page || 'publish' !== $page->post_status || in_array( (int) $page->ID, $keep, true ) ) {
				continue;
			}
			wp_update_post( array( 'ID' => $page->ID, 'post_status' => 'draft' ) );
			update_post_meta( $page->ID, '_hh_demo_hidden', 1 );
		}
		update_option( 'hh_demo_pages_don_v1', 1, false );
	}
);

/** Phòng khi trang mẫu bị đăng lại: không cho Google lập chỉ mục. */
add_filter(
	'wp_robots',
	static function ( $robots ) {
		if ( is_page() && in_array( get_post_field( 'post_name', get_queried_object_id() ), hh_demo_page_slugs(), true ) ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	},
	20
);

add_filter(
	'rank_math/frontend/robots',
	static function ( $robots ) {
		if ( is_page() && in_array( get_post_field( 'post_name', get_queried_object_id() ), hh_demo_page_slugs(), true ) ) {
			$robots['index'] = 'noindex';
		}
		return $robots;
	}
);
