<?php
/**
 * Spana Tower – shophouse khối đế tầng 1 theo mặt bằng kích thước của chủ đầu tư (Drive "Shophouse khối đế", anh Hiệp gửi
 * 04/11/2026): mặt tiền, diện tích điển hình. Ảnh mặt bằng kích thước nhẹ (~300 KB) → web tải thẳng từ link Drive.
 * Không ghi mã căn.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$lines = array(
			'https://drive.google.com/file/d/1yDNuR9KxiG7xN9QAuSM1LXQhy-2yYV7i/view | Mặt bằng kích thước shophouse tầng 1 tòa S1 Spana Tower: mặt tiền từng căn, vỉa hè bao quanh (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | S1 – Shophouse tầng 1 (kích thước)',
			'https://drive.google.com/file/d/13WES2x8fINLFPdkHMRBIa9j-BuzBf23a/view | Mặt bằng kích thước shophouse tầng 1 tòa S2 Spana Tower: mặt tiền từng căn, vỉa hè bao quanh (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | S2 – Shophouse tầng 1 (kích thước)',
		);
		$shop = 'Tầng 1 mỗi tòa S1, S2 là dãy shophouse khối đế mặt đường, vỉa hè bao quanh. Theo mặt bằng kích thước của chủ đầu tư: căn điển hình mặt tiền khoảng 6,2 m, diện tích khoảng 88 m² (thông thủy khoảng 82,8 m²); căn góc mặt tiền khoảng 7,5 m; tòa S1 có dãy căn lớn khoảng 120,7 m² (thông thủy khoảng 113,2 m²). Diện tích shophouse từ khoảng 46 m² đến gần 148 m². Tầng 2 là tiện ích nội khu (bể bơi, gym & spa, co-working, cafe, khu trẻ em). Nhận danh sách căn shophouse còn trống, giá và chính sách: Zalo Hoàng Hiệp 0904 567 009.';
		foreach ( $projects as $i => $p ) {
			if ( 'spana-tower' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, '1yDNuR9KxiG7xN9QAuSM1LXQhy-2yYV7i' ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $lines ) );
				if ( '' !== $cur ) {
					$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
				}
			}
			$old = (string) ( $p['meta']['hh_p_shop_desc'] ?? '' );
			$projects[ $i ]['meta']['hh_p_shop_desc'] = $shop;
			$projects[ $i ]['fix_meta']['hh_p_shop_desc'] = array_values(
				array_unique(
					array_filter(
						array_merge(
							(array) ( $p['fix_meta']['hh_p_shop_desc'] ?? array() ),
							array( $old, 'Tầng 1 – 2 bố trí shophouse khối đế và tiện ích nội khu.', 'Tầng 1 mỗi tòa (S1, S2) bố trí khoảng 24 – 25 căn shophouse mặt đường, diện tích 46,5 – 140,4 m²; tầng 2 là tiện ích nội khu (bể bơi, gym & spa, co-working, cafe, khu trẻ em).' )
						),
						static fn( $v ) => '' !== $v && $v !== $shop
					)
				)
			);
		}
		return $projects;
	},
	65 // Sau ảnh tiến độ (60) – nối thêm vào cùng danh sách ảnh.
);
