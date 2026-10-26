<?php
/**
 * Dự án căn hộ bổ sung từ đợt tổng hợp 10/2026 (căn hộ ven sông Hàn, căn hộ mới – sắp triển khai, căn hộ khách sạn / condotel).
 * Dữ liệu: du-an-tong-hop.json – mỗi dự án có nguồn báo chí / cơ quan nhà nước; không có giá nếu nguồn không nêu rõ.
 *   { "projects": [ {slug, title, type, area, excerpt, meta{…}, content, sources[]} ], "groups": { "ven-song-han": [slug…], … } }
 * Nhóm (groups) dùng cho trang tổng hợp: /can-ho-ven-song-han-da-nang/, /du-an-can-ho-moi-da-nang/, /can-ho-khach-san-condotel-da-nang/.
 */

defined( 'ABSPATH' ) || exit;

function hh_du_an_tong_hop() {
	static $data = null;
	if ( null === $data ) {
		$file = __DIR__ . '/du-an-tong-hop.json';
		$data = is_readable( $file ) ? (array) json_decode( (string) file_get_contents( $file ), true ) : array(); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$data += array( 'projects' => array(), 'groups' => array() );
	}
	return $data;
}

/** Slug dự án thuộc nhóm (ven-song-han, moi-sap-trien-khai, can-ho-khach-san). */
function hh_du_an_nhom( $group ) {
	return (array) ( hh_du_an_tong_hop()['groups'][ $group ] ?? array() );
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$have = array_flip( array_column( $projects, 'slug' ) );
		foreach ( hh_du_an_tong_hop()['projects'] as $p ) {
			if ( empty( $p['slug'] ) || empty( $p['title'] ) || isset( $have[ $p['slug'] ] ) ) {
				continue; // Dự án đã có trong dữ liệu khác – không tạo trùng.
			}
			$p['meta']    = array_filter( (array) ( $p['meta'] ?? array() ), static fn( $v ) => '' !== $v && null !== $v );
			$p['excerpt'] = (string) ( $p['excerpt'] ?? '' );
			$projects[]   = $p;
		}
		return $projects;
	},
	30
);
