<?php
/**
 * Fusion Resort & Villas Đà Nẵng: ảnh thực tế, mặt bằng loại biệt thự (anh Hiệp gửi 13/10/2026).
 * Không dùng bản vẽ thi công có logo đơn vị khác, tọa độ mốc ranh; không đăng bảng thanh toán (tài liệu ghi "Internal").
 * Chỉ điền ô còn trống.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/fusion/fusion-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'toan-canh-day-biet-thu-bien', 'Toàn cảnh dãy biệt thự Fusion Resort & Villas Đà Nẵng bên biển Trường Sa, nhìn về bán đảo Sơn Trà', 'đại diện' ),
			$img( 'mat-bang-loai-biet-thu', 'Mặt bằng tổng thể Fusion Resort & Villas Đà Nẵng theo loại biệt thự 1 – 6 phòng ngủ', 'tổng thể' ),
			$img( 'biet-thu-mat-bien-tren-cao', 'Biệt thự mặt biển Fusion Đà Nẵng nhìn từ trên cao', 'thư viện' ),
			$img( 'day-biet-thu-ven-bien', 'Dãy biệt thự ven biển Fusion Resort & Villas, mái ngói đỏ, hàng dừa', 'thư viện' ),
			$img( 'ho-boi-sat-bai-cat', 'Hồ bơi riêng biệt thự Beach Front sát bãi cát', 'thư viện' ),
			$img( 'ho-boi-jacuzzi-hoang-hon', 'Hồ bơi và bồn jacuzzi biệt thự mặt biển lúc hoàng hôn', 'thư viện' ),
			$img( 'ho-boi-tran-bo', 'Hồ bơi tràn bờ nhìn ra biển Đà Nẵng', 'thư viện' ),
			$img( 'san-trong-ho-boi', 'Sân trong và hồ bơi riêng biệt thự Fusion Đà Nẵng', 'thư viện' ),
			$img( 'san-vuon-ho-boi', 'Sân vườn, hồ bơi và chòi nghỉ biệt thự Fusion', 'thư viện' ),
			$img( 'mat-tien-biet-thu', 'Mặt tiền biệt thự Fusion Resort & Villas Đà Nẵng', 'thư viện' ),
			$img( 'cong-vao-biet-thu', 'Cổng vào biệt thự Fusion, lối đi gỗ trên mặt nước', 'thư viện' ),
			$img( 'cong-biet-thu-109', 'Cổng và tường rào biệt thự Fusion Đà Nẵng', 'thư viện' ),
			$img( 'canh-quan-bai-bien', 'Cảnh quan cây xanh sát bãi biển Fusion Resort & Villas', 'tiện ích', 'Bãi biển riêng' ),
			$img( 'loi-di-noi-khu', 'Lối đi nội khu, cây xanh và khu nhà hàng Fusion Resort & Villas', 'tiện ích', 'Nội khu' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'fusion-resort-villas-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] += array(
				'hh_p_image_links'   => implode( "\n", $lines ),
				'hh_p_design_desc'   => 'Theo mặt bằng tổng thể, khu biệt thự gồm 6 loại: Presidential Villa (6 phòng ngủ, 1 căn J1); Beach Front Villa (5 phòng ngủ, dãy J – K sát biển); Premier Villa (3 – 5 phòng ngủ, dãy D và M); Beach Garden Villa (3 – 4 phòng ngủ, dãy C và H xếp chéo); Garden Terrace Villa (2 phòng ngủ, dãy A, B, E, G) và Garden Front Villa (1 phòng ngủ, các căn đầu dãy). Giữa khu là nhà đón tiếp, spa, hồ bơi chính, nhà hàng chính; mỗi biệt thự có hồ bơi riêng, sân vườn, tường rào và cổng riêng. Lối vào từ đường Trường Sa, phía Đông giáp bãi biển.',
				'hh_p_amenities_in'  => "Bãi biển riêng\nHồ bơi chính, spa\nNhà hàng chính, nhà hàng đồ nướng\nCâu lạc bộ thể thao, sân tennis\nKhu vui chơi trẻ em\nHồ bơi riêng từng biệt thự",
				'hh_p_amenities_out' => "Biển Mỹ Khê – Non Nước\nDanh thắng Ngũ Hành Sơn\nThe Ocean Villas, sân golf ven biển\nSân bay quốc tế Đà Nẵng khoảng 15 – 20 phút",
				'hh_p_villa_desc'    => 'Biệt thự 1 – 6 phòng ngủ, mỗi căn có hồ bơi riêng, sân vườn, tường rào; dãy Beach Front và Presidential sát bãi cát. Giá theo tin rao chuyển nhượng 2026 khoảng 32 – 54 tỷ (đất khoảng 486 – 700 m²).',
			);
		}
		return $projects;
	},
	60
);
