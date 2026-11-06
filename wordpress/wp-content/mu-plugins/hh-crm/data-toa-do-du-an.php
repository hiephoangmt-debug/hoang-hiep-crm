<?php
/**
 * Tọa độ bản đồ các dự án – lấy từ bảng "Tọa độ các dự án" trên Google Drive của anh Hiệp (đổi độ-phút-giây sang số thập phân).
 * Bản đồ trên trang dự án ưu tiên tọa độ, nên ghim đúng chỗ thay vì để Google tự tìm theo tên (từng ghim sai, VD Sun Solar).
 * Chỉ điền khi ô "Tọa độ bản đồ" đang trống – không đè tọa độ anh đã tự nhập. Phân khu / tòa con tự dùng tọa độ dự án mẹ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$coords = array(
			'sun-solar-residence'    => '16.071556, 108.222167', // 16°04'17.6"N 108°13'19.8"E – Lê Duẩn, gần ngã tư Yên Bái.
			'sun-costa-residence'    => '16.080889, 108.243694', // 16°04'51.2"N 108°14'37.3"E
			'sun-symphony-residence' => '16.085056, 108.228861', // 16°05'06.2"N 108°13'43.9"E
			'sun-ponte-residence'    => '16.057889, 108.230694', // 16°03'28.4"N 108°13'50.5"E
			'spana-tower'            => '16.023083, 108.224361', // 16°01'23.1"N 108°13'27.7"E
			'cora-tower'             => '16.018472, 108.229944', // 16°01'06.5"N 108°13'47.8"E
			'fours-tower'            => '16.009639, 108.242556', // 16°00'34.7"N 108°14'33.2"E
			'the-meridian-da-nang'   => '16.034444, 108.232361', // 16°02'04.0"N 108°13'56.5"E
			'masteri-da-nang'        => '16.033250, 108.228083', // 16°01'59.7"N 108°13'41.1"E
		);
		foreach ( $projects as &$p ) {
			$slug = $p['slug'] ?? '';
			if ( isset( $coords[ $slug ] ) && empty( $p['meta']['hh_p_map_coords'] ) ) {
				$p['meta']['hh_p_map_coords'] = $coords[ $slug ];
			}
		}
		unset( $p );
		return $projects;
	},
	40
);
