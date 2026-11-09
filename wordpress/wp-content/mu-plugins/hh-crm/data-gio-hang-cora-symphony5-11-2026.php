<?php
/**
 * Giỏ hàng anh Hiệp gửi 09/11/2026 (Google Sheet): shop khối đế Cora Tower, căn hộ Cora Tower, Symphony 5.
 * Giá tổng đã gồm VAT & kinh phí bảo trì. Không đăng mã căn, tên đại lý, tình trạng cọc.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = array(
			'cora-tower' => array(
				'hh_p_shop_desc'  => 'Shophouse khối đế tại tầng đế tòa tháp, giao lộ Nguyễn Phước Lan – đường 29/3, phù hợp cà phê, cửa hàng tiện lợi, phòng khám phục vụ cư dân. Giỏ hàng 11/2026: 5 shop tầng 1 tòa A2, diện tích thông thủy 43,8 – 87,3 m², giá khoảng 5,17 – 9,12 tỷ (gồm VAT & phí bảo trì), tương đương khoảng 98 – 135 triệu/m².',
				'hh_p_shop_table' => "Shop tầng 1, tòa A2 | 43,8 m² | Khoảng 5,89 tỷ | ≈ 134 triệu/m², gồm VAT & phí bảo trì\nShop tầng 1, tòa A2 | 52,5 m² | Khoảng 5,17 tỷ | ≈ 98 triệu/m²\nShop tầng 1, tòa A2 | 73 m² | Khoảng 8,00 tỷ | ≈ 110 triệu/m²\nShop tầng 1, tòa A2 | 87 m² | Khoảng 9,09 tỷ | ≈ 104 triệu/m²\nShop tầng 1, tòa A2 | 87,3 m² | Khoảng 9,12 tỷ | ≈ 104 triệu/m²",
				'hh_p_unit_types' => "Studio | 32,3 m² | – | Khoảng 2,42 – 2,74 tỷ (giỏ hàng 11/2026, gồm VAT & phí bảo trì)\nCăn 1PN+ | 53,2 – 54,2 m² | 1 | Khoảng 3,45 – 3,84 tỷ (giỏ hàng 11/2026)\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
				'hh_p_price_from' => 2420,
			),
			'symphony-5-sun-symphony-residence' => array(
				'hh_p_unit_types' => "Studio | 30 – 33 m² (725 căn) | 0 | Khoảng 2,50 – 3,30 tỷ (giỏ hàng 11/2026, gồm VAT & phí bảo trì)\nCăn 1PN | 46,4 – 47,8 m² | 1 | Khoảng 3,09 – 3,30 tỷ (giỏ hàng 11/2026)\nCăn 1PN+ | 44 – 53 m² (331 căn) | 1 | Khoảng 3,45 – 4,54 tỷ (giỏ hàng 11/2026)\nCăn 2PN | 63 – 70 m² (160 căn) | 2 | Liên hệ\nPenthouse | 12 căn | | Liên hệ",
				'hh_p_price_from' => 2502,
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $new[ $slug ] ) ) {
				continue;
			}
			foreach ( $new[ $slug ] as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()[ $slug ]['meta'][ $k ] ?? '' ) : '' ) );
				if ( '' !== $cur && $cur !== (string) $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				$p['meta'][ $k ] = $v;
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	75
);
