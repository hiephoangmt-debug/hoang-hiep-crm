<?php
/**
 * Đất nền Đầm Sen – Sun Riverpolis (Nam Hòa Xuân): ảnh, mặt bằng anh Hiệp gửi 13/10/2026 (ảnh chủ đầu tư; bỏ các ảnh có
 * logo, chữ chìm của đơn vị phân phối), phân khu theo diện tích, tiện ích công viên ven sông. Chỉ điền ô còn trống.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/dam-sen/dam-sen-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'toan-canh-nam-hoa-xuan', 'Toàn cảnh khu đô thị Nam Hòa Xuân nhìn về sông Cổ Cò, Ngũ Hành Sơn và biển Đà Nẵng', 'đại diện' ),
			$img( 'mat-bang-block-mo-ban', 'Mặt bằng các block mở bán khu công viên Đầm Sen: phân khu 100 m², 125 m², 150 m²', 'mặt bằng', 'Các block mở bán' ),
			$img( 'mat-bang-phan-khu-dam-sen', 'Mặt bằng phân khu Đầm Sen: townhouse, nhà liền kề, biệt thự ven sông Đô Toả, chung cư', 'mặt bằng', 'Phân khu Đầm Sen' ),
			$img( 'mat-bang-phia-bac', 'Mặt bằng khu phía Bắc Sun Riverpolis: cầu Trung Lương, cầu Đồng Nò, biệt thự ven sông', 'mặt bằng', 'Khu phía Bắc' ),
			$img( 'duong-noi-khu-cong-vien', 'Đường nội khu và công viên ven sông khu Đầm Sen đã hoàn thiện', 'tiện ích', 'Đường nội khu, công viên' ),
			$img( 'duong-chay-bo-ven-cong-vien', 'Đường chạy bộ cạnh công viên, hàng dừa khu Đầm Sen', 'tiện ích', 'Đường chạy bộ' ),
			$img( 'san-tap-the-duc-ven-song', 'Sân tập thể dục ngoài trời ven sông khu Đầm Sen', 'tiện ích', 'Sân tập thể dục' ),
			$img( 'cong-vien-gian-hoa', 'Giàn hoa, ghế nghỉ trong công viên cảnh quan Đầm Sen', 'tiện ích', 'Công viên cảnh quan' ),
			$img( 'duong-dao-ven-song', 'Đường dạo ven sông khu Đầm Sen', 'tiện ích', 'Đường dạo ven sông' ),
			$img( 'duong-dao-bo-cay-xanh', 'Đường dạo bộ giữa hàng cây xanh khu Đầm Sen', 'tiện ích', 'Đường dạo bộ' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'dat-nen-dam-sen-sun-riverpolis' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] += array(
				'hh_p_image_links'   => implode( "\n", $lines ),
				'hh_p_design_desc'   => 'Theo mặt bằng các block mở bán khu công viên Đầm Sen: phân khu 100 m² điển hình gồm các block B2-114, B2-116, B2-118, B2-119, B2-121, B2-122; phân khu 125 m² gồm B2-111, B2-112, B2-156 (dọc đường Nguyễn Phước Lan); phân khu 150 m² là block B2-157 gần sân bóng. Toàn khu có các dãy townhouse hai bên trục Nguyễn Phước Lan, nhà liền kề phía trong, biệt thự ven sông Đô Toả trên các tuyến Đầm Sen, Đông Khoa, Thượng Đức và một số lô chung cư ở giao lộ; cầu Đông Khoa nối sang bờ Tây.',
				'hh_p_amenities_in'  => "Công viên ven sông, công viên bến du thuyền\nCông viên nghệ thuật, công viên cảnh quan, công viên Cổ Cò\nĐồi ánh sáng, đồi hoa, đồi biển tên\nĐường dạo bộ, đường chạy bộ, sân tập thể dục ngoài trời\nSân bóng đá 11 người, sân bóng đá mini\nNhà hàng ven sông\nKhu phát triển giáo dục, trường mầm non – tiểu học – cấp 2 – THPT theo quy hoạch\nHồ sinh thái",
				'hh_p_amenities_out' => "Sunneva Island, Sun Riverpolis\nNgũ Hành Sơn, biển Non Nước\nCầu Hòa Xuân, cầu Đông Khoa\nFPT City, làng Đại học",
			);
		}
		return $projects;
	},
	60
);
