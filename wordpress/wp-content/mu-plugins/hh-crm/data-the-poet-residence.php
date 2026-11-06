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
			'plugin:img/the-poet/the-poet-toan-canh-bien-my-khe.jpg | The Poet Residence nhìn ra biển Mỹ Khê và bán đảo Sơn Trà (phối cảnh) | đại diện',
			'plugin:img/the-poet/the-poet-toan-canh-dem-song-han.jpg | The Poet Residence về đêm nhìn về sông Hàn, cầu Rồng và pháo hoa (phối cảnh) | thư viện',
			'plugin:img/the-poet/the-poet-tang-mai-phao-hoa-song-han.jpg | Tầng mái The Poet Residence – bar, vườn, ngắm pháo hoa sông Hàn | tiện ích | Tầng mái ngắm pháo hoa',
			$d( '1DymNjJsXNGR7rs92yUJ13fOa98NR2FYs', 'Phối cảnh The Poet Residence – tháp căn hộ 25 tầng trên đường Hồ Xuân Hương, gần biển Mỹ Khê', 'thư viện' ),
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
				'hh_p_scale'        => 'Đất 2.009 m², 1 tòa 25 tầng, 263 căn',
				'hh_p_blocks'       => '1 tòa tháp',
				'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm, 1 tum thang',
				'hh_p_units'        => '263 căn hộ',
				'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam)',
				'hh_p_legal'        => 'Đủ điều kiện bán 263 căn (Sở Xây dựng, 24/6/2026); đã có giấy phép xây dựng, sổ đất',
				'hh_p_designer'     => 'Huni Architectes (chi nhánh Việt Nam); tư vấn giám sát: Viện Khoa học Công nghệ Xây dựng (IBST)',
				'hh_p_manager'      => 'Tư vấn quản lý vận hành dự kiến: CBRE',
				'hh_p_payment'      => "Đặt cọc | Ký thỏa thuận đặt cọc | 200 triệu\nĐợt 1 | Trong 10 ngày, ký hợp đồng mua bán | 15% (gồm cọc)\nĐợt 2 – 7 | Theo tiến độ xây dựng (sàn tầng 15, 20, 25, cất nóc) | 55%\nĐợt 8 | Nhận thông báo bàn giao | 25% + kinh phí bảo trì\nĐợt 9 | Nhận giấy chứng nhận | 5%",
				'hh_p_policy'       => "Phương thức tiêu chuẩn: thanh toán theo tiến độ xây dựng, 25% khi nhận nhà, 5% khi nhận sổ\nThanh toán sớm 70% trong 30 ngày sau ký hợp đồng mua bán (ưu đãi cao nhất)\nNhận nhà ưu việt: thanh toán khoảng 45% trước bàn giao, 25% khi nhận nhà, 25% sau 12 tháng\nVay ngân hàng đến 50 – 70% giá trị căn, chủ đầu tư hỗ trợ lãi suất 100% đến khi nhận nhà, 50% thêm 12 tháng (tối đa 24 tháng), ân hạn gốc 18 – 36 tháng\nNgân hàng bảo lãnh: VietinBank; cho vay: VietinBank, Vietcombank, MB\nMức chiết khấu theo từng phương thức thay đổi theo đợt – liên hệ Hoàng Hiệp để nhận chính sách đang áp dụng",
				'hh_p_unit_area'    => 'Khoảng 46 – 91 m²; penthouse 190 – 235 m²',
				'hh_p_price_from'   => 4940,
				'hh_p_price_m2'     => 'Khoảng 92 – 107 triệu/m² thông thủy, đã gồm VAT (bảng hàng tầng 5 – 8, 11/2026 – tham khảo)',
				'hh_p_start'        => 'Khởi công 4/2025 (giấy phép xây dựng 11/4/2025)',
				'hh_p_handover'     => 'Dự kiến năm 2027',
				'hh_p_highlights'   => "Cách biển Mỹ Khê khoảng 300 m, trên trục Hồ Xuân Hương\nCăn góc view biển Mỹ Khê (hướng Đông Bắc) hoặc view sông Hàn – pháo hoa (hướng Tây Nam)\nKính lớn toàn căn, phòng tắm có cửa sổ riêng\nHồ bơi trong nhà, bể sục, gym, yoga, lounge, nhà hàng – café\nTổng thầu Central",
				'hh_p_design_desc'  => 'Tháp căn hộ 25 tầng nổi, 2 tầng hầm trên khu đất 2.009,2 m² (mật độ xây dựng khoảng 58 – 59%, hệ số sử dụng đất 12,5, tổng sàn khoảng 30.080 m², khoảng 689 cư dân), mặt đứng khung viền sáng. Cơ cấu theo chủ đầu tư: 1PN+ 45,9 – 46,7 m², 2PN 64,7 – 82,5 m², 3PN 90,2 – 91,4 m², 5 penthouse thông tầng 190 – 235 m² (diện tích thông thủy). Bàn giao dự kiến 2027 (chủ đầu tư công bố tháng 5/2027), bảo hành 60 tháng. Mỗi tầng điển hình có các căn 1PN+1 45,8 m², 2PN 64,4 – 80,6 m² và 3PN góc 89,4 m²; căn phía Đông Bắc nhìn biển Mỹ Khê, căn phía Tây Nam nhìn sông Hàn và pháo hoa.',
				'hh_p_unit_types'   => "Căn 1PN+1 | 45,8 – 45,9 m² | 1+ | Khoảng 4,94 – 4,95 tỷ
Căn 2PN hướng Tây Nam | 64,6 – 64,9 m² | 2 | Khoảng 5,96 – 6,04 tỷ
Căn 2PN hướng Đông Bắc (view biển) | 64,6 – 65,1 m² | 2 | Khoảng 6,12 – 6,44 tỷ
Căn 2PN góc view biển | 67,5 m² | 2 | Khoảng 6,91 – 6,93 tỷ
Căn 2PN view biển | 73,2 – 73,8 m² | 2 | Khoảng 6,86 – 7,26 tỷ
Căn 2PN góc view sông Hàn | 75,4 – 80,8 m² | 2 | Khoảng 7,66 – 7,87 tỷ
Căn 3PN góc view biển | 89,9 – 90,1 m² | 3 | Khoảng 9,2 – 9,57 tỷ",
				'hh_p_location_desc' => 'Dự án trên đường Hồ Xuân Hương (Ngũ Hành Sơn), đi bộ ra biển Mỹ Khê khoảng 300 m; gần cầu Tiên Sơn, Lotte Mart, khu Đà Nẵng Downtown và sông Hàn.',
				'hh_p_connections'  => "Khoảng 300 m | Biển Mỹ Khê\nKhoảng 1,5 km | Cầu Tiên Sơn\nKhoảng 2 km | Lotte Mart Đà Nẵng\nKhoảng 3,5 km | Đà Nẵng Downtown\nKhoảng 6,5 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in' => "Tầng 1: café, mini mart, văn phòng cho thuê\nTầng 2: 2 nhà trẻ, 2 phòng sinh hoạt cộng đồng\nTầng 3: hồ bơi trong nhà người lớn (khoảng 231 m²) và trẻ em, bể sục, gym – aerobic – yoga\nTầng mái: vườn trà (Thi), bar coffee, quảng trường ngắm pháo hoa, vườn Cầm, khu vui chơi trẻ em, khu VIP\n4 thang máy Schindler, hành lang rộng 1,8 m\nHầm đỗ xe: khoảng 92 chỗ ô tô, 353 chỗ xe máy\nAn ninh: kiểm soát xe hầm, thang máy, thang bộ; camera toàn tòa",
				'hh_p_handover_std' => 'Hoàn thiện cao cấp: sàn porcelain, trần Vĩnh Tường / Gyproc, sơn Jotun, cửa Xingfa kính Low-E, khóa điện tử Sharp, thiết bị vệ sinh Innoci / Grohe / Toto, điều hòa âm trần Samsung, điện Legrand, bếp Teka / Malloca (hoặc tương đương)',
				'hh_p_amenities_out' => "Biển Mỹ Khê\nSông Hàn, cầu Tiên Sơn\nLotte Mart, Đà Nẵng Downtown\nSân bay quốc tế Đà Nẵng",
				'hh_p_progress'     => "12/7/2023 | UBND TP chấp thuận chủ trương đầu tư và chủ đầu tư\n12/7/2024 | Phê duyệt quy hoạch tổng mặt bằng 1/500\n23/1/2025 | Cục Quản lý hoạt động xây dựng (Bộ Xây dựng) thẩm định báo cáo khả thi\n11/4/2025 | Giấy phép xây dựng 414/GPXD; khởi công tháng 4/2025\n12/2025 | Hoàn thành phần móng\n24/6/2026 | Sở Xây dựng xác nhận 263 căn đủ điều kiện bán\n2027 | Dự kiến bàn giao (Quý II – Quý III/2027 tùy nguồn)",
				'hh_p_faq'          => "The Poet Residence ở đâu? | 95 – 97 – 99 Hồ Xuân Hương, phường Ngũ Hành Sơn, Đà Nẵng; khoảng 5 phút ra biển Mỹ Khê, 10 phút tới Đà Nẵng Downtown, 15 phút tới sân bay.\nChủ đầu tư là ai? | Công ty Cổ phần Địa ốc Phúc Thanh An; tổng thầu Central, thiết kế Huni Architectes, giám sát IBST.\nDự án đủ điều kiện bán chưa? | Đã đủ: Sở Xây dựng Đà Nẵng xác nhận 263 căn đủ điều kiện bán nhà ở hình thành trong tương lai (Công văn 11222/SXD-QLN ngày 24/6/2026); ngân hàng bảo lãnh VietinBank.\nCó những loại căn nào? | 1PN+ 45,9 – 46,7 m², 2PN 64,7 – 82,5 m², 3PN 90,2 – 91,4 m² và 5 căn penthouse thông tầng 190 – 235 m²; tầng 4 – 23 mỗi tầng 12 căn.\nGiá bao nhiêu? | Tham khảo bảng hàng tầng 5 – 8 (11/2026, gồm VAT): 1PN+ khoảng 4,94 tỷ, 2PN khoảng 5,96 – 7,87 tỷ, 3PN khoảng 9,2 – 9,57 tỷ.\nThanh toán thế nào? | Đặt cọc 200 triệu, ký hợp đồng 15%; có phương thức thanh toán theo tiến độ, thanh toán sớm 70%, nhận nhà ưu việt hoặc vay ngân hàng 50 – 70% được hỗ trợ lãi suất đến 24 tháng.\nKhi nào bàn giao? | Dự kiến năm 2027; phần móng hoàn thành 12/2025. Bảo hành căn hộ 60 tháng.\nNgười nước ngoài mua được không? | Chưa được – Sở Xây dựng yêu cầu chủ đầu tư không bán cho tổ chức, cá nhân nước ngoài.\nCó chỗ đỗ ô tô không? | Có khoảng 92 chỗ ô tô và 353 chỗ xe máy ở 2 tầng hầm và tầng 1.\nThủ tục chuyển nhượng hợp đồng thế nào? | Được chuyển nhượng khi đã thanh toán đúng, đủ các đợt theo hợp đồng mua bán tới thời điểm chuyển nhượng; theo chính sách chủ đầu tư 9/2026, lần đầu miễn phí, từ lần thứ hai 9 triệu/lần.\nPhí quản lý bao nhiêu, tiện ích có tính phí không? | Chủ đầu tư chưa công bố phí quản lý và phí tiện ích; tư vấn quản lý vận hành dự kiến là CBRE.\nDoanh nghiệp có mua được không? | Có. Doanh nghiệp chuẩn bị giấy chứng nhận đăng ký doanh nghiệp, quyết định mua bất động sản, giấy ủy quyền ký và CCCD người đại diện; cá nhân chỉ cần CCCD.\nMua 2 căn liền nhau có đập thông được không? | Không tự ý đập tường, thay đổi kết cấu; chỉ làm khi được chủ đầu tư hoặc đơn vị quản lý đồng ý bằng văn bản. Sửa nhỏ không ảnh hưởng kết cấu báo trước 5 ngày.\nTrần cao bao nhiêu, hành lang rộng bao nhiêu? | Tầng căn hộ (4 – 25) cao 3,3 m/tầng; hành lang rộng 1,8 m; 4 thang máy.\nAn toàn cháy nổ, an ninh ra sao? | Đã thẩm duyệt PCCC (báo cháy tự động, chữa cháy nước, khí FM-200, thang máy chữa cháy, thoát nạn); kiểm soát xe hầm, thang máy, thang bộ, camera toàn tòa; mỗi tầng có phòng rác riêng 2 cửa.\nNgân hàng cho vay bao nhiêu? | Tối đa 50 – 70% giá trị căn tùy phương thức; VietinBank, Vietcombank, MB; hỗ trợ lãi suất tối đa 24 tháng (100% đến khi nhận nhà, 50% thêm 12 tháng), ân hạn gốc theo ngân hàng.",
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
<p>Tầng 1 có café, mini mart; tầng 2 có 2 nhà trẻ và phòng sinh hoạt cộng đồng; tầng 3 có hồ bơi trong nhà cho người lớn và trẻ em, bể sục, gym – aerobic – yoga. Tòa nhà có 4 thang máy, khoảng 92 chỗ đỗ ô tô và 353 chỗ xe máy. Căn hộ bảo hành 60 tháng.</p>
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
<h2>Thanh toán và hỗ trợ vay</h2>
<p>Đặt cọc 200 triệu, ký hợp đồng mua bán thanh toán 15% (gồm cọc). Khách chọn thanh toán theo tiến độ xây dựng (25% khi nhận nhà, 5% khi nhận sổ), thanh toán sớm 70% để nhận ưu đãi cao nhất, hoặc "nhận nhà ưu việt" giãn 25% sang 12 tháng sau bàn giao. Khách vay được ngân hàng cho vay 50 – 70% giá trị căn, chủ đầu tư hỗ trợ lãi suất 100% đến khi nhận nhà và 50% thêm 12 tháng (tối đa 24 tháng). Ngân hàng bảo lãnh là VietinBank. Mức chiết khấu thay đổi theo từng đợt chính sách – liên hệ để nhận chính sách đang áp dụng.</p>
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
		// Trang đã tạo trước đó (26/10/2026) từ du-an-tong-hop.json: thay số liệu, bài viết, mô tả, tên cũ.
		if ( function_exists( 'hh_du_an_tong_hop' ) ) {
			foreach ( hh_du_an_tong_hop()['projects'] as $j ) {
				if ( 'the-poet-residence-da-nang' === ( $j['slug'] ?? '' ) ) {
					$cu['json'] = array( 'meta' => (array) ( $j['meta'] ?? array() ), 'content' => (string) ( $j['content'] ?? '' ), 'excerpt' => (string) ( $j['excerpt'] ?? '' ), 'title' => (string) ( $j['title'] ?? '' ) );
				}
			}
		}
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
		$new['fix_excerpt'] = $cu['json']['excerpt'] ?? ( $cu['170']['excerpt'] ?? '' ); // Trang hiện có mô tả từ bản 26/10.
		if ( ! empty( $cu['json']['title'] ) ) {
			$new['fix_title'] = array( $cu['json']['title'] );
		}
		unset( $new );
		return $projects;
	},
	20
);
