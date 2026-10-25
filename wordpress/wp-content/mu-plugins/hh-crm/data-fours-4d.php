<?php
/**
 * FourS Tower (tòa F2): căn hộ mẫu 2D · 3D · 4D và bảng hàng 3D tòa nhà (ứng dụng floorplan-3d trên GitHub Pages).
 * Dùng bản cho khách (?khach): ẩn nút thiết kế, giá, trạng thái và công cụ nội bộ.
 * Khung trên trang: căn hộ mẫu (căn 03 tầng 3, có sân vườn) – xem thử rồi hỏi số Zalo; nút chọn căn: bảng hàng tòa F2.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( ! in_array( $p['slug'] ?? '', array( 'fours-tower', 'fours-tower-f2-thap-mai' ), true ) ) {
				continue;
			}
			$p['meta'] += array(
				'hh_p_tour_name'   => 'căn hộ mẫu 4D tòa F2',
				'hh_p_tour_4d'     => 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/xem-can-ho.html?khach&v=46#can-03@03',
				'hh_p_tour_poster' => 'plugin:img/fours-tower/fours-f2-can-ho-mau-3d-xem-truoc.jpg', // Chụp từ chính căn hộ mẫu 3D (căn 03, sân vườn).
				'hh_p_tour_units'  => 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/toa-nha.html?khach&v=46',
			);
		}
		unset( $p );
		return $projects;
	},
	60
);
