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
			'excerpt' => 'The Poet Residence – tháp căn hộ 25 tầng, 263 căn đã đủ điều kiện bán (Sở Xây dựng 24/6/2026) tại 95 – 99 Hồ Xuân Hương (Ngũ Hành Sơn), cách biển Mỹ Khê khoảng 300 m; căn 1PN+1 đến 3PN, view biển hoặc sông Hàn, hồ bơi trong nhà, gym, yoga. Chủ đầu tư Phúc Thanh An.',
			'meta'    => array(
				'hh_p_status'       => 'dang-mo-ban',
				'hh_p_developer'    => 'Công ty Cổ phần Địa ốc Phúc Thanh An',
				'hh_p_builder'      => 'Central (Centralcons) – tổng thầu',
				'hh_p_type'         => 'Căn hộ cao cấp, khối đế thương mại',
				'hh_p_address'      => '95 – 97 – 99 Hồ Xuân Hương, phường Mỹ An (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'        => 'Đất 2.009,2 m², mật độ xây dựng 59,23%, hệ số sử dụng đất 12,5; sàn nhà ở 17.271 m² (tổng sàn khoảng 30.080 m²); khoảng 689 cư dân',
				'hh_p_blocks'       => '1 tòa tháp',
				'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm, 1 tum thang',
				'hh_p_units'        => '263 căn hộ',
				'hh_p_legal'        => 'Đủ điều kiện bán nhà ở hình thành trong tương lai (Công văn 11222/SXD-QLN ngày 24/6/2026 của Sở Xây dựng Đà Nẵng, 263 căn); chủ trương đầu tư 1459/QĐ-UBND (12/7/2023); quy hoạch 1/500 (2585/QĐ-UBND, 12/7/2024); giấy phép xây dựng 414/GPXD (11/4/2025); thẩm duyệt PCCC (3/4/2025); đã có giấy chứng nhận quyền sử dụng đất, đã nộp tiền sử dụng đất (6/2026); dự án chưa thế chấp ngân hàng (theo chủ đầu tư báo cáo); không bán cho người nước ngoài',
				'hh_p_unit_area'    => 'Khoảng 45,8 – 89,4 m² (căn điển hình); căn lớn nhất đến khoảng 230 m²',
				'hh_p_price_from'   => 4940,
				'hh_p_price_m2'     => 'Khoảng 92 – 107 triệu/m² thông thủy, đã gồm VAT (bảng hàng tầng 5 – 8, 11/2026 – tham khảo)',
				'hh_p_start'        => 'Khởi công 4/2025 (giấy phép xây dựng 11/4/2025)',
				'hh_p_handover'     => 'Dự kiến Quý II – Quý III/2027 (tùy nguồn)',
				'hh_p_highlights'   => "Cách biển Mỹ Khê khoảng 300 m, trên trục Hồ Xuân Hương\nCăn góc view biển Mỹ Khê (hướng Đông Bắc) hoặc view sông Hàn – pháo hoa (hướng Tây Nam)\nKính lớn toàn căn, phòng tắm có cửa sổ riêng\nHồ bơi trong nhà, bể sục, gym, yoga, lounge, nhà hàng – café\nTổng thầu Central",
				'hh_p_design_desc'  => 'Tháp căn hộ 25 tầng trên khối đế thương mại, mặt đứng khung viền sáng. Mỗi tầng điển hình có các căn 1PN+1 45,8 m², 2PN 64,4 – 80,6 m² và 3PN góc 89,4 m²; căn phía Đông Bắc nhìn biển Mỹ Khê, căn phía Tây Nam nhìn sông Hàn và pháo hoa.',
				'hh_p_unit_types'   => "Căn 1PN+1 | 45,8 – 45,9 m² | 1+ | Khoảng 4,94 – 4,95 tỷ
Căn 2PN hướng Tây Nam | 64,6 – 64,9 m² | 2 | Khoảng 5,96 – 6,04 tỷ
Căn 2PN hướng Đông Bắc (view biển) | 64,6 – 65,1 m² | 2 | Khoảng 6,12 – 6,44 tỷ
Căn 2PN góc view biển | 67,5 m² | 2 | Khoảng 6,91 – 6,93 tỷ
Căn 2PN view biển | 73,2 – 73,8 m² | 2 | Khoảng 6,86 – 7,26 tỷ
Căn 2PN góc view sông Hàn | 75,4 – 80,8 m² | 2 | Khoảng 7,66 – 7,87 tỷ
Căn 3PN góc view biển | 89,9 – 90,1 m² | 3 | Khoảng 9,2 – 9,57 tỷ",
				'hh_p_location_desc' => 'Dự án trên đường Hồ Xuân Hương (Ngũ Hành Sơn), đi bộ ra biển Mỹ Khê khoảng 300 m; gần cầu Tiên Sơn, Lotte Mart, khu Đà Nẵng Downtown và sông Hàn.',
				'hh_p_connections'  => "Khoảng 300 m | Biển Mỹ Khê\nKhoảng 1,5 km | Cầu Tiên Sơn\nKhoảng 2 km | Lotte Mart Đà Nẵng\nKhoảng 3,5 km | Đà Nẵng Downtown\nKhoảng 6,5 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in' => "Sảnh đón, lounge cư dân\nHồ bơi trong nhà, bể sục\nPhòng gym, phòng yoga\nNhà hàng – café\nTầng mái: vườn trà (Thi), coffee, bar coffee, quảng trường ngắm pháo hoa, vườn \"Cầm\", khu vui chơi trẻ em, khu VIP\nKhối đế thương mại, hầm đỗ xe\nThang máy Schindler",
				'hh_p_handover_std' => 'Hoàn thiện cao cấp: sàn porcelain, trần Vĩnh Tường / Gyproc, sơn Jotun, cửa Xingfa kính Low-E, khóa điện tử Sharp, thiết bị vệ sinh Innoci / Grohe / Toto, điều hòa âm trần Samsung, điện Legrand, bếp Teka / Malloca (hoặc tương đương)',
				'hh_p_amenities_out' => "Biển Mỹ Khê\nSông Hàn, cầu Tiên Sơn\nLotte Mart, Đà Nẵng Downtown\nSân bay quốc tế Đà Nẵng",
				'hh_p_progress'     => "12/7/2023 | UBND TP chấp thuận chủ trương đầu tư và chủ đầu tư\n12/7/2024 | Phê duyệt quy hoạch tổng mặt bằng 1/500\n23/1/2025 | Cục Quản lý hoạt động xây dựng (Bộ Xây dựng) thẩm định báo cáo khả thi\n11/4/2025 | Giấy phép xây dựng 414/GPXD; khởi công tháng 4/2025\n2026 | Nghiệm thu hoàn thành phần móng\n24/6/2026 | Sở Xây dựng xác nhận 263 căn đủ điều kiện bán\n2027 | Dự kiến bàn giao (Quý II – Quý III/2027 tùy nguồn)",
				'hh_p_image_links'  => implode( "\n", $img ),
			),
			'content' => '<p><strong>The Poet Residence</strong> là tháp căn hộ 25 tầng của Công ty Cổ phần Địa ốc Phúc Thanh An tại 95 – 99 Hồ Xuân Hương (Ngũ Hành Sơn, Đà Nẵng), cách biển Mỹ Khê khoảng 300 m. Dự án có 263 căn hộ trên khu đất 2.009,2 m², tổng thầu là Central, khởi công tháng 4/2025 và đã được Sở Xây dựng xác nhận đủ điều kiện bán (6/2026).</p>
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
<h2>Pháp lý The Poet Residence</h2>
<p>Ngày 24/6/2026, Sở Xây dựng Đà Nẵng có Công văn 11222/SXD-QLN xác nhận <strong>263 căn hộ</strong> của dự án Chung cư Hồ Xuân Hương (The Poet Residence) <strong>đủ điều kiện bán nhà ở hình thành trong tương lai</strong> theo Điều 24 Luật Kinh doanh bất động sản 2023. Dự án đã có chủ trương đầu tư (2023), quy hoạch 1/500 (2024), giấy phép xây dựng và thẩm duyệt PCCC (4/2025), giấy chứng nhận quyền sử dụng đất và đã nộp tiền sử dụng đất. Theo báo cáo của chủ đầu tư, dự án chưa thế chấp ngân hàng. Căn hộ không bán cho người nước ngoài.</p>
<h2>Tiến độ</h2>
<p>Dự án khởi công tháng 4/2025, đã nghiệm thu xong phần móng, bàn giao dự kiến năm 2027 (các nguồn ghi Quý II đến Quý III/2027). Giá bán theo từng căn, tầng và hướng.</p>
<h2>Giá bán The Poet Residence (tham khảo 11/2026)</h2>
<p>Theo bảng hàng các tầng 5 – 8 (giá đã gồm VAT): căn 1PN+1 khoảng 4,94 tỷ; căn 2PN 64 – 65 m² khoảng 5,96 – 6,44 tỷ; căn 2PN 67 – 74 m² view biển khoảng 6,86 – 7,26 tỷ; căn 2PN góc 75 – 81 m² view sông Hàn khoảng 7,66 – 7,87 tỷ; căn 3PN góc khoảng 9,2 – 9,57 tỷ. Đơn giá khoảng 92 – 107 triệu/m² thông thủy; tầng cao giá cao hơn. Giá có thể thay đổi theo từng đợt, liên hệ để nhận bảng giá và căn còn trống mới nhất.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, căn còn trống và chính sách thanh toán mới nhất của The Poet Residence.</p>',
			'sources' => array(
				'https://www.centralcons.vn/?p=13782',
				'https://thuvienphapluat.vn/phap-luat-nha-dat/du-an-the-poet-residence-da-nang-gia-ban-hien-nay-bao-nhieu-8667.html',
				'https://thuvienphapluat.vn/phap-luat-nha-dat/he-thong-tien-ich-du-an-the-poet-residence-co-gi-thu-hut-15044.html',
				'https://thuviennhadat.vn/du-an-bat-dong-san/the-poet-residence-8497.html',
				'https://www.tinnhanhchungkhoan.vn/dia-oc-phuc-thanh-an-lam-chu-dau-tu-chung-cu-hon-792-ty-dong-o-da-nang-post326445.html',
			),
		);
		// Bản đã nhập trước đó (2.20.167, 2.20.168): ô nào vẫn đúng bản cũ thì thay bằng bản mới.
		$cu  = (array) include __DIR__ . '/data-the-poet-residence-cu.php';
		$new = &$projects[ count( $projects ) - 1 ];
		foreach ( $cu as $old ) {
			foreach ( (array) $old['meta'] as $k => $v ) {
				if ( isset( $new['meta'][ $k ] ) && (string) $new['meta'][ $k ] !== (string) $v ) {
					$new['fix_meta'][ $k ][] = (string) $v;
				}
			}
			if ( $old['content'] !== $new['content'] ) {
				$new['fix_content'][] = $old['content'];
			}
		}
		$new['fix_excerpt'] = $cu['168']['excerpt'] ?? '';
		unset( $new );
		return $projects;
	},
	20
);
