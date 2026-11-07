<?php
/**
 * FPT Plaza 2 và FPT City Đà Nẵng – mặt bằng anh Hiệp gửi 07/11/2026:
 * 3 mặt bằng FPT Plaza 2 (tầng điển hình, tầng 1 shophouse, tầng tiện ích – bể bơi; đã xóa logo đơn vị phân phối ở góc ảnh)
 * và mặt bằng tổng thể + sơ đồ phân khu toàn khu FPT City.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$add = array(
			'fpt-plaza-2'      => array(
				'plugin:img/fpt-plaza-2/fpt-plaza-2-mat-bang-tang-dien-hinh.jpg | Mặt bằng tầng điển hình FPT Plaza 2: căn 56 – 78 m², mặt tiền Võ Chí Công | mặt bằng | Tầng điển hình',
				'plugin:img/fpt-plaza-2/fpt-plaza-2-mat-bang-tang-1-shophouse.jpg | Mặt bằng tầng 1 FPT Plaza 2: 23 shophouse 53 – 126 m², sảnh chính, công viên nội khu | mặt bằng | Tầng 1 – shophouse',
				'plugin:img/fpt-plaza-2/fpt-plaza-2-mat-bang-tang-tien-ich-be-boi.jpg | Tầng tiện ích FPT Plaza 2: bể bơi trong nhà, khu cà phê, phòng thể thao, phòng sinh hoạt cộng đồng | mặt bằng | Tầng tiện ích – bể bơi',
			),
			'fpt-city-da-nang' => array(
				'plugin:img/fpt-city/fpt-city-da-nang-mat-bang-tong-the-phan-khu.jpg | Mặt bằng tổng thể khu đô thị công nghệ FPT City Đà Nẵng và sơ đồ phân khu, ven sông Cổ Cò | tổng thể',
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $add[ $slug ] ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $cur;
			$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $add[ $slug ] ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	99
);
