<?php
/**
 * The Poet Residence – căn hộ 25 tầng, 95 – 99 Hồ Xuân Hương (Ngũ Hành Sơn), gần biển Mỹ Khê. Chủ đầu tư Phúc Thanh An.
 * Ảnh: bộ phối cảnh / tiện ích / layout chủ đầu tư anh Hiệp gửi qua Drive (06/11/2026); không dùng ảnh căn hộ mẫu có logo đại lý.
 * Số liệu tổng hợp từ Central (tổng thầu), Thư viện Pháp luật, Thư viện Nhà đất (11/2026) và layout chủ đầu tư; giá là mức tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$d   = static fn( $id, $alt, $where, $title = '' ) => "https://drive.google.com/thumbnail?id=$id&sz=w2400 | $alt | $where" . ( $title ? " | $title" : '' );
		$img = array(
			$d( '1DymNjJsXNGR7rs92yUJ13fOa98NR2FYs', 'Phối cảnh The Poet Residence – tháp căn hộ 25 tầng trên đường Hồ Xuân Hương, gần biển Mỹ Khê', 'đại diện' ),
			$d( '1xtKqF0ZJt8K9Fhys_YX06X8JP5rqrneM', 'The Poet Residence về đêm – tháp căn hộ 25 tầng, Ngũ Hành Sơn, Đà Nẵng', 'thư viện' ),
			$d( '15_IrbCN6_KqNoDXKmpqe_w43Kd0Yb1cZ', 'Phối cảnh The Poet Residence nhìn từ góc đường', 'thư viện' ),
			$d( '1ZR3rP2JdLDbGPuosUkR1rqCE1pTuwnlX', 'The Poet Residence lên đèn, mặt đứng với khung viền sáng', 'thư viện' ),
			$d( '10ao7XpOIi38yc2ZKnnPJgtUKUzzbkmqz', 'Khối đế thương mại và sảnh The Poet Residence trên đường Hồ Xuân Hương', 'thư viện' ),
			$d( '1-UlHnV4FxjZSPiotvjPEXcMcMZSqu7gg', 'Khối đế thương mại The Poet Residence về đêm', 'thư viện' ),
			$d( '11D-q92zHW2WO6_NknFELz9oS0o_l-R1G', 'Sảnh đón The Poet Residence', 'tiện ích', 'Sảnh đón' ),
			$d( '1GrejZCqoIrDnxclYGqNqr6CE59tLb17p', 'Sảnh sinh hoạt cư dân (lounge) The Poet Residence', 'tiện ích', 'Lounge cư dân' ),
			$d( '1fRYP09S-upDsCf6WjDaNzAUezY8M-1Dk', 'Nhà hàng – café trong tòa nhà The Poet Residence', 'tiện ích', 'Nhà hàng – café' ),
			$d( '1Iyen8S_N2G-qCzTzTzSa_UeIgvm7hy6y', 'Hồ bơi trong nhà The Poet Residence', 'tiện ích', 'Hồ bơi trong nhà' ),
			$d( '1vMo3FZ0DLIlvhpaeGqp91E0JTTXdNWNG', 'Hồ bơi trong nhà và bể sục The Poet Residence', 'tiện ích', 'Bể sục' ),
			$d( '1wFJf6t0phIrOdn5-Py-j03ouXOxkqdaI', 'Khu ghế thư giãn bên hồ bơi The Poet Residence', 'tiện ích', 'Khu thư giãn' ),
			$d( '1kZiuuzyu1TralkTJ_m2X9sQpjfnspO1r', 'Phòng gym nhìn ra phố – The Poet Residence', 'tiện ích', 'Phòng gym' ),
			$d( '1AVn0POFnZI2dg8YTHURTXl7MNU_iIkBS', 'Phòng yoga The Poet Residence', 'tiện ích', 'Phòng yoga' ),
		);
		// Layout căn hộ (bản vẽ chủ đầu tư). Ảnh căn hộ mẫu có logo đại lý: không dùng.
		$img[] = $d( '1nOxbEL1imWfGyWvRiwrYPQyaadb-oBuy', 'Layout căn 3PN góc 89,4 m² The Poet Residence – view biển Mỹ Khê, logia hướng Đông Bắc', 'layout', '3PN góc 89,4 m²' );
		$img[] = $d( '1t6vyTLvOqVY9MNFlkJgy9XN292m08819', 'Layout căn 2PN góc 80,6 m² The Poet Residence – view sông Hàn, logia hướng Tây Nam', 'layout', '2PN góc 80,6 m²' );
		$img[] = $d( '1F3nKA8kXfHkq5qMuOU4qLJfu_dUPo81I', 'Layout căn 2PN góc 74,9 m² The Poet Residence – view sông Hàn, logia hướng Tây Nam', 'layout', '2PN góc 74,9 m²' );
		$img[] = $d( '1drB8LTHS72R5-mYjzv8Xf2gfG-Q340df', 'Layout căn 2PN góc 66,2 m² The Poet Residence – view biển Mỹ Khê, logia hướng Đông Bắc', 'layout', '2PN góc 66,2 m²' );
		$img[] = $d( '1B20u_7dvJplkLj8BeYuOKHjjdlKhPPkt', 'Layout căn 2PN 64,4 m² The Poet Residence – view biển Mỹ Khê, logia hướng Đông Bắc', 'layout', '2PN 64,4 m²' );
		$img[] = $d( '1-S_Mdlc0Kfqff0nmO3s2KHaA1yY_RhPi', 'Layout căn 1PN+1 45,8 m² The Poet Residence – view biển Mỹ Khê', 'layout', '1PN+1 45,8 m²' );

		$projects[] = array(
			'slug'    => 'the-poet-residence-da-nang',
			'title'   => 'The Poet Residence Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'hot'     => true,
			'excerpt' => 'The Poet Residence – tháp căn hộ 25 tầng, khoảng 263 căn tại 95 – 99 Hồ Xuân Hương (Ngũ Hành Sơn), cách biển Mỹ Khê khoảng 300 m; căn 1PN+1 đến 3PN, view biển hoặc sông Hàn, hồ bơi trong nhà, gym, yoga. Chủ đầu tư Phúc Thanh An.',
			'meta'    => array(
				'hh_p_status'       => 'dang-mo-ban',
				'hh_p_developer'    => 'Công ty Cổ phần Địa ốc Phúc Thanh An',
				'hh_p_builder'      => 'Central (Centralcons) – tổng thầu',
				'hh_p_type'         => 'Căn hộ cao cấp, khối đế thương mại',
				'hh_p_address'      => '95 – 97 – 99 Hồ Xuân Hương, phường Mỹ An (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'        => 'Tổng diện tích sàn khoảng 30.080 m²',
				'hh_p_blocks'       => '1 tòa tháp',
				'hh_p_floors'       => '25 tầng nổi, 2 – 3 tầng hầm (tùy nguồn)',
				'hh_p_units'        => 'Khoảng 263 căn hộ',
				'hh_p_unit_area'    => 'Khoảng 45,8 – 89,4 m² (căn điển hình); căn lớn nhất đến khoảng 230 m²',
				'hh_p_price_from'   => 2700,
				'hh_p_price_m2'     => 'Liên hệ – giá theo từng căn, tầng, hướng (tham khảo từ khoảng 2,7 tỷ)',
				'hh_p_start'        => 'Khởi công 10/8/2025',
				'hh_p_handover'     => 'Dự kiến Quý II – Quý III/2027 (tùy nguồn)',
				'hh_p_highlights'   => "Cách biển Mỹ Khê khoảng 300 m, trên trục Hồ Xuân Hương\nCăn góc view biển Mỹ Khê (hướng Đông Bắc) hoặc view sông Hàn – pháo hoa (hướng Tây Nam)\nKính lớn toàn căn, phòng tắm có cửa sổ riêng\nHồ bơi trong nhà, bể sục, gym, yoga, lounge, nhà hàng – café\nTổng thầu Central",
				'hh_p_design_desc'  => 'Tháp căn hộ 25 tầng trên khối đế thương mại, mặt đứng khung viền sáng. Mỗi tầng điển hình có các căn 1PN+1 45,8 m², 2PN 64,4 – 80,6 m² và 3PN góc 89,4 m²; căn phía Đông Bắc nhìn biển Mỹ Khê, căn phía Tây Nam nhìn sông Hàn và pháo hoa.',
				'hh_p_unit_types'   => "Căn 1PN+1 | 45,8 m² | 1+ | Liên hệ\nCăn 2PN | 64,4 m² | 2 | Liên hệ\nCăn 2PN góc view biển | 66,2 m² | 2 | Liên hệ\nCăn 2PN góc view sông Hàn | 74,9 – 80,6 m² | 2 | Liên hệ\nCăn 3PN góc view biển | 89,4 m² | 3 | Liên hệ",
				'hh_p_location_desc' => 'Dự án trên đường Hồ Xuân Hương (Ngũ Hành Sơn), đi bộ ra biển Mỹ Khê khoảng 300 m; gần cầu Tiên Sơn, Lotte Mart, khu Đà Nẵng Downtown và sông Hàn.',
				'hh_p_connections'  => "Khoảng 300 m | Biển Mỹ Khê\nKhoảng 1,5 km | Cầu Tiên Sơn\nKhoảng 2 km | Lotte Mart Đà Nẵng\nKhoảng 3,5 km | Đà Nẵng Downtown\nKhoảng 6,5 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in' => "Sảnh đón, lounge cư dân\nHồ bơi trong nhà, bể sục\nPhòng gym, phòng yoga\nNhà hàng – café\nTầng mái: vườn trà (Thi), coffee, bar coffee, quảng trường ngắm pháo hoa, vườn \"Cầm\", khu vui chơi trẻ em, khu VIP\nKhối đế thương mại, hầm đỗ xe\nThang máy Schindler",
				'hh_p_handover_std' => 'Hoàn thiện cao cấp: sàn porcelain, trần Vĩnh Tường / Gyproc, sơn Jotun, cửa Xingfa kính Low-E, khóa điện tử Sharp, thiết bị vệ sinh Innoci / Grohe / Toto, điều hòa âm trần Samsung, điện Legrand, bếp Teka / Malloca (hoặc tương đương)',
				'hh_p_amenities_out' => "Biển Mỹ Khê\nSông Hàn, cầu Tiên Sơn\nLotte Mart, Đà Nẵng Downtown\nSân bay quốc tế Đà Nẵng",
				'hh_p_progress'     => "10/8/2025 | Khởi công\n2027 | Dự kiến bàn giao (Quý II – Quý III/2027 tùy nguồn)",
				'hh_p_image_links'  => implode( "\n", $img ),
			),
			'content' => '<p><strong>The Poet Residence</strong> là tháp căn hộ 25 tầng của Công ty Cổ phần Địa ốc Phúc Thanh An tại 95 – 99 Hồ Xuân Hương (Ngũ Hành Sơn, Đà Nẵng), cách biển Mỹ Khê khoảng 300 m. Dự án có khoảng 263 căn hộ, tổng thầu là Central, khởi công ngày 10/8/2025.</p>
<h2>Các loại căn The Poet Residence</h2>
<ul>
<li>Căn 1PN+1 khoảng 45,8 m², view biển Mỹ Khê.</li>
<li>Căn 2PN 64,4 m² và 2PN góc 66,2 m² view biển, logia hướng Đông Bắc.</li>
<li>Căn 2PN góc 74,9 – 80,6 m² view sông Hàn và pháo hoa, logia hướng Tây Nam.</li>
<li>Căn 3PN góc 89,4 m², 2 logia, view biển Mỹ Khê.</li>
</ul>
<h2>Tiện ích</h2>
<p>Hồ bơi trong nhà có bể sục, phòng gym, phòng yoga, lounge cư dân, nhà hàng – café và khối đế thương mại ngay trong tòa nhà.</p>
<h2>Tiện ích tầng mái</h2>
<p>Tầng mái được thiết kế thành không gian ngoài trời gồm vườn trà (Thi), coffee và bar coffee, quảng trường ngắm pháo hoa sông Hàn, vườn "Cầm", khu vui chơi trẻ em và các khu VIP.</p>
<h2>Tiêu chuẩn bàn giao</h2>
<p>Căn hộ bàn giao hoàn thiện: sàn gạch porcelain 800×800, trần thạch cao Vĩnh Tường / Gyproc, sơn Jotun, cửa sổ nhôm Xingfa kính hộp Low-E, khóa điện tử Sharp, thiết bị vệ sinh Innoci / Grohe / Toto, điều hòa âm trần Samsung, thiết bị điện Legrand và bếp Teka / Malloca kèm tủ An Cường / Suofeiya (theo danh mục vật tư chủ đầu tư, thương hiệu có thể thay bằng loại tương đương).</p>
<h2>Tiến độ</h2>
<p>Dự án khởi công tháng 8/2025, bàn giao dự kiến năm 2027 (các nguồn ghi Quý II đến Quý III/2027). Giá bán theo từng căn, tầng và hướng; các nguồn ghi mức khởi điểm khoảng 2,7 tỷ (tham khảo).</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, căn còn trống và chính sách thanh toán mới nhất của The Poet Residence.</p>',
			'sources' => array(
				'https://www.centralcons.vn/?p=13782',
				'https://thuvienphapluat.vn/phap-luat-nha-dat/du-an-the-poet-residence-da-nang-gia-ban-hien-nay-bao-nhieu-8667.html',
				'https://thuvienphapluat.vn/phap-luat-nha-dat/he-thong-tien-ich-du-an-the-poet-residence-co-gi-thu-hut-15044.html',
				'https://thuviennhadat.vn/du-an-bat-dong-san/the-poet-residence-8497.html',
				'https://www.tinnhanhchungkhoan.vn/dia-oc-phuc-thanh-an-lam-chu-dau-tu-chung-cu-hon-792-ty-dong-o-da-nang-post326445.html',
			),
		);
		return $projects;
	},
	20
);
