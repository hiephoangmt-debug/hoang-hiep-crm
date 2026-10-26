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
		'the-camellia-son-tra'            => 'Công ty TNHH Địa ốc Thành Lâm',
		'shilla-monogram-quang-nam'       => 'TCG Land (Tập đoàn Thành Công); The Shilla Hotels & Resorts quản lý vận hành',
		'four-seasons-the-nam-hai'        => 'Liên doanh Hotel Properties Limited (Singapore) – ASB Development (Dubai); Indochina Land phát triển ban đầu',
		'montgomerie-links-villas'        => 'Indochina Land (Indochina Capital)',
		'fusion-resort-villas-da-nang'    => 'Công ty TNHH Khách sạn và Biệt thự Nam Phát (Lodgis Hospitality – Warburg Pincus, VinaCapital)',
		'hyatt-regency-danang-residences' => 'Indochina Land (Indochina Capital); Hyatt quản lý vận hành',
		'furama-villas-da-nang'           => 'Công ty CP Ariyana (Sovico Holdings)',
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
