<?php
/**
 * Sửa ô "Chủ đầu tư" của dự án theo hồ sơ chủ đầu tư (chu-dau-tu.json, 10/2026):
 * - Ô này chỉ ghi chủ đầu tư (và công ty cùng tập đoàn phát triển dự án) – không ghi đơn vị phân phối, môi giới, đại lý.
 * - Cập nhật tên pháp nhân theo nguồn công khai (đổi tên, chuyển nhượng cổ phần).
 * - Dự án chưa ghi chủ đầu tư: bổ sung.
 * Chỉ thay khi ô trên web vẫn là giá trị web nhập trước đó (chưa sửa tay).
 */

defined( 'ABSPATH' ) || exit;

/** slug dự án => tên chủ đầu tư mới. */
function hh_cdt_developer_fixes() {
	return array(
		'tropical-palm-dien-ngoc'         => 'Đất Quảng Group (nay Vincent Land Group)',
		'one-world-regency'               => 'Đất Quảng Land Group (nay Vincent Land Group)',
		'sentosa-riverside-dien-ngoc'     => 'Bách Đạt, Bách Đạt An',
		'vinhomes-hai-van-bay'            => 'Công ty CP Vinpearl (Tập đoàn Vingroup), Vinhomes phát triển',
		'lakeside-palace'                 => 'Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN)',
		'dragon-smart-city'               => 'Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN)',
		'hiyori-garden-tower'             => 'Công ty TNHH MTV Sun Frontier Đà Nẵng (Sun Frontier Fudousan, Nhật Bản)',
		'naman-residences'                => 'Công ty CP Đầu tư Phát triển và Xây dựng Thành Đô',
		'danang-landmark'                 => 'Công ty CP Cosmos Housing',
		'times-square-da-nang'            => 'Công ty CP Kim Long Nam (liên kết Tập đoàn Phương Trang)',
		'hoiana-residences'               => 'Công ty TNHH Phát triển Nam Hội An (Hoiana)',
		'premier-village-da-nang'         => 'Tập đoàn Sun Group',
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$fix = hh_cdt_developer_fixes();
		foreach ( $projects as &$p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $fix[ $slug ] ) ) {
				continue;
			}
			$old = (string) ( $p['meta']['hh_p_developer'] ?? '' );
			if ( $old === $fix[ $slug ] ) {
				continue;
			}
			$p['meta']['hh_p_developer'] = $fix[ $slug ];
			if ( '' !== $old ) {
				$p['fix_meta']                   = (array) ( $p['fix_meta'] ?? array() );
				$p['fix_meta']['hh_p_developer'] = array_merge( (array) ( $p['fix_meta']['hh_p_developer'] ?? array() ), array( $old ) );
			}
		}
		unset( $p );
		return $projects;
	},
	99
);
