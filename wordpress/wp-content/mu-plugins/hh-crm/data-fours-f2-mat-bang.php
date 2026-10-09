<?php
/**
 * FourS Tower – Tòa F2 (Tháp Mai): mặt bằng tầng 3A, 5, 6, 7, 8 – 19 (anh Hiệp gửi 09/10/2026), ảnh trong img/fours-tower/.
 * Nhập dữ liệu Đà Nẵng: thêm vào "Ảnh mặt bằng tầng" của trang Tòa F2 (mỗi tầng một tab), tải ngầm như ảnh phối cảnh.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$floors = array(
			'tang-3a'   => 'Tầng 3A',
			'tang-5'    => 'Tầng 5',
			'tang-6'    => 'Tầng 6',
			'tang-7'    => 'Tầng 7',
			'tang-8-19' => 'Tầng 8 – 19',
		);
		$lines = array();
		foreach ( $floors as $file => $title ) {
			$lines[] = "plugin:img/fours-tower/fours-tower-f2-mat-bang-$file.jpg | Mặt bằng $title Tòa F2 – Tháp Mai FourS Tower | mặt bằng | $title";
		}
		foreach ( $projects as $i => $p ) {
			if ( 'fours-tower-f2-thap-mai' !== ( $p['slug'] ?? '' ) || ! function_exists( 'hh_fours_image_links' ) ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = hh_fours_image_links() . "\n" . implode( "\n", $lines );
			// Web đã có danh sách ảnh phối cảnh cũ (chưa sửa tay) → thay bằng danh sách mới để tải thêm mặt bằng.
			$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( hh_fours_image_links() ) );
		}
		return $projects;
	},
	60 // Sau hh_dataset_fours_f2 (ưu tiên 50) – lúc đó trang Tòa F2 đã có trong danh sách.
);
