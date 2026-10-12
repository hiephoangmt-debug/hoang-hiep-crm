<?php
/**
 * FPT Plaza 3: 3 ảnh phối cảnh + mặt bằng tầng 1, 2, 4, 5 – 12A, 12B, 14 – 17, 18 – 24, 25 và 2 tầng hầm (anh Hiệp gửi 12/10/2026),
 * ảnh trong img/fpt-plaza-3/. Loại căn, diện tích đọc từ bản vẽ mặt bằng của chủ đầu tư.
 * Nhập dữ liệu Đà Nẵng: thêm vào "Ảnh mặt bằng tầng" (mỗi tầng một tab) và điền các ô còn trống.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$floors = array(
			'tang-1'     => 'Tầng 1',
			'tang-2'     => 'Tầng 2',
			'tang-4'     => 'Tầng 4',
			'tang-5-12a' => 'Tầng 5 – 12A',
			'tang-12b'   => 'Tầng 12B',
			'tang-14-17' => 'Tầng 14 – 17',
			'tang-18-24' => 'Tầng 18 – 24',
			'tang-25'    => 'Tầng 25',
			'ham-1'      => 'Hầm 1',
			'ham-2'      => 'Hầm 2',
		);
		$lines = array(
			'plugin:img/fpt-plaza-3/fpt-plaza-3-phoi-canh-toan-canh-tu-tren-cao.jpg | Phối cảnh FPT Plaza 3 Đà Nẵng nhìn từ trên cao, cạnh hồ và công viên FPT City | đại diện',
			'plugin:img/fpt-plaza-3/fpt-plaza-3-phoi-canh-mat-tien.jpg | Phối cảnh mặt tiền FPT Plaza 3 – khối đế thương mại và hai cánh căn hộ | thư viện',
			'plugin:img/fpt-plaza-3/fpt-plaza-3-phoi-canh-goc-thap.jpg | Phối cảnh tòa căn hộ FPT Plaza 3, FPT City Ngũ Hành Sơn | thư viện',
		);
		foreach ( $floors as $file => $title ) {
			$lines[] = "plugin:img/fpt-plaza-3/fpt-plaza-3-mat-bang-$file.jpg | Mặt bằng $title FPT Plaza 3 Đà Nẵng | mặt bằng | $title";
		}
		foreach ( $projects as $i => $p ) {
			if ( 'fpt-plaza-3' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] += array(
				'hh_p_image_links' => implode( "\n", $lines ),
				'hh_p_blocks'      => '1 tòa, 2 sảnh thang máy (cánh W và cánh E)',
				'hh_p_unit_area'   => '1PN khoảng 42 m² · 1PN+1 khoảng 47 – 51 m² · 2PN khoảng 55 – 69 m² · 2PN+1 khoảng 73 – 76 m² · 3PN khoảng 72 – 80 m² · 3PN+1 khoảng 81 – 124 m²',
				'hh_p_unit_types'  => "Căn 1PN | 41,7 – 42,1 m² | 1 | Liên hệ\nCăn 1PN+1 | 46,9 – 50,6 m² | 1 + phòng đa năng | Liên hệ\nCăn 2PN | 55,4 – 69,2 m² | 2 | Khoảng 2,6 – 4 tỷ (tin rao)\nCăn 2PN+1 | 72,7 – 76,4 m² | 2 + phòng đa năng | Liên hệ\nCăn 3PN | 71,5 – 80,1 m² | 3 | Liên hệ\nCăn 3PN+1 | 81,1 – 123,6 m² | 3 + phòng đa năng | Liên hệ\nCăn 2 tầng (tầng 1 – 2) | 88,2 – 148,4 m² | 1 – 2 | Liên hệ\nThương mại dịch vụ tầng 1 | 55,8 – 201,2 m² | – | Liên hệ",
				'hh_p_design_desc' => 'Tòa nhà chiếm trọn một ô phố: mặt chính đường Hoàng Minh Thắng (33 m), ba mặt còn lại giáp đường N16 (17,5 m), N18 (15,5 m) và D11 (18,5 m); phía Đông nhìn ra Công viên Quảng trường trung tâm FPT City, phía Tây là dãy shophouse. Hai sảnh thang máy W và E; sàn điển hình (tầng 5 – 25) khoảng 35 – 36 căn, chủ yếu căn 2 phòng ngủ 55 – 69 m², căn góc 2PN+1 và 3PN. Tầng 1 là 14 ki-ốt thương mại dịch vụ (khoảng 56 – 201 m²), căn 1PN và căn hộ 2 tầng (thông tầng 1 – 2); tầng 2 có 3 phòng sinh hoạt cộng đồng (khoảng 163 – 174 m²); tầng 4 và tầng 12B có căn kèm tiện ích sân vườn. 2 tầng hầm để ô tô, xe máy. Không có tầng 13 (đánh số 12A, 12B).',
			);
		}
		return $projects;
	},
	60
);
