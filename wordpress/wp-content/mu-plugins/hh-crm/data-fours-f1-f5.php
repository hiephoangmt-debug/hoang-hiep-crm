<?php
/**
 * FourS Tower – Tòa F1 (Tháp Tùng, Mùa Đông) và Tòa F5 (Tháp Cúc, Mùa Thu): 2 trang dự án con của FourS Tower.
 * Nguồn: bộ landing sun-fours-tower.com (nhánh telegram-notify): bảng giá dự kiến theo căn mẫu, giỏ hàng 03/10/2026
 * (assets/fourstower/data/stock.js), chính sách CSBH 01/FT/SPG/04-2026, hồ sơ pháp lý chung 4 tòa. Chữ viết riêng cho hiephoangmt.com.
 * Giá: đã gồm VAT & KPBT, chưa áp chiết khấu; "thanh toán sớm" là phương án trả sớm theo chính sách – tham khảo, đổi theo đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_fours_f1_f5', 51 );
function hh_dataset_fours_f1_f5( $projects ) {
	$common = array(
		'hh_p_status'        => 'dang-mo-ban',
		'hh_p_developer'     => 'Tập đoàn Sun Group (Sun Property phát triển)',
		'hh_p_type'          => 'Căn hộ Studio – 3 phòng ngủ',
		'hh_p_address'       => 'Ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng',
		'hh_p_floors'        => '20 tầng nổi, 2 tầng hầm',
		'hh_p_ownership'     => 'Sở hữu lâu dài',
		'hh_p_handover'      => 'Nhận nhà dự kiến 31/3/2028 (Sun Early Key – thanh toán 70%)',
		'hh_p_handover_std'  => 'Hoàn thiện cơ bản',
		'hh_p_legal'         => 'Đủ điều kiện bán (VB 17239/SXD-QLN ngày 19/9/2026), sổ đỏ từng lô, bảo lãnh Techcombank',
		'hh_p_loan'          => 'Ngân hàng cho vay tối đa 70%, chủ đầu tư hỗ trợ lãi suất tới 30 tháng (không muộn hơn 30/4/2029), ân hạn nợ gốc, miễn phí trả nợ trước hạn',
		'hh_p_policy'        => "Đặt cọc 100 triệu (Studio, 1PN, 1PN+, 2PN) · 150 triệu (3PN)\nSun Early Key: trả 15% khi ký, mỗi đợt thêm khoảng 5%, đủ 70% là nhận nhà; 30% còn lại giãn tới năm 2030\nKhông vay: chiết khấu 5% trên giá trước VAT & KPBT, tiến độ 70 – 30 kéo dài tới 48 tháng\nTrả trước hạn bằng vốn tự có: hưởng 8%/năm trên số tiền và số ngày trả sớm\nTặng 1 năm phí quản lý từ ngày bàn giao\nKhách sở hữu bất động sản Sun Group thứ 2 trở lên: thêm 1% – 1,5% theo hạng thành viên\nTheo CSBH 01/FT/SPG/04-2026 – chủ đầu tư có thể điều chỉnh",
		'hh_p_amenities_in'  => "Hồ bơi bốn mùa\nGym, yoga, spa\nKhu vui chơi trẻ em\nKhông gian sinh hoạt cộng đồng\nThương mại tầng đế",
		'hh_p_location_desc' => 'Nằm trong cụm 4 tháp FourS Tower ở ngã tư Nguyễn Phước Lan – Minh Mạng, trung tâm khu Nam Đà Nẵng, thuộc đại đô thị Sun Riverpolis (Hòa Quý). Ra sông Cổ Cò vài phút, đi biển và danh thắng Ngũ Hành Sơn thuận tiện.',
	);
	$tower = static function ( $slug, $title, $excerpt, $meta, $content, $order ) use ( $common ) {
		return array(
			'slug'    => $slug,
			'title'   => $title,
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fours-tower',
			'order'   => $order,
			'excerpt' => $excerpt,
			'meta'    => $meta + $common,
			'content' => $content,
			'sources' => array(
				'https://www.sun-fours-tower.com/',
				'https://tuoitre.vn/fours-tower-an-cu-dau-tu-tai-trung-tam-nam-da-nang-20260410181212744.htm',
			),
		);
	};

	$cta = '<p>Muốn biết căn nào còn trống, giá sau chiết khấu và lịch thanh toán cho đúng căn mình chọn, anh/chị nhắn <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hiệp so sánh luôn với Tòa F2 để anh/chị chọn phương án lợi nhất.</p>';

	$projects[] = $tower(
		'fours-tower-f1-thap-tung',
		'FourS Tower F1 – Tháp Tùng (Mùa Đông) Đà Nẵng',
		'Tòa F1 – Tháp Tùng FourS Tower Đà Nẵng: 20 tầng, nhận nhà dự kiến 31/3/2028. Studio 30,5 m² từ khoảng 1,77 tỷ (thanh toán sớm), 2PN 64 m² khoảng 4,3 – 5,2 tỷ. Cọc 100 triệu, vay 70% hỗ trợ lãi 30 tháng.',
		array(
			'hh_p_blocks'      => 'Tòa F1 – Tháp Tùng (Mùa Đông), 1 trong 4 tháp FourS Tower',
			'hh_p_image_links' => "plugin:img/fours-tower/fours-tower-phoi-canh-4-thap.jpg | Phối cảnh 4 tháp FourS Tower Đà Nẵng, trong đó có Tòa F1 – Tháp Tùng | đại diện\nplugin:img/fours-tower/fours-tower-truc-duong-trung-tam.jpg | Trục đường trung tâm giữa các tháp FourS Tower | thư viện\nplugin:img/fours-tower/fours-tower-pho-thuong-mai-khoi-de.jpg | Phố thương mại khối đế FourS Tower | tiện ích",
			'hh_p_price_from'  => 1770,
			'hh_p_price_m2'    => 'Khoảng 54 – 71 triệu/m² thông thủy tùy căn và cách thanh toán (gồm VAT & KPBT)',
			'hh_p_unit_types'  => "Studio | 30,5 m² | – | Khoảng 1,77 – 2,58 tỷ\nCăn 1PN+1 | 53,8 m² | 1 + phòng đa năng | Khoảng 2,89 – 3,62 tỷ\nCăn 2PN | 63,8 – 64,9 m² | 2 | Khoảng 3,65 – 5,16 tỷ",
			'hh_p_price_table' => "Studio (căn 16) | 30,5 m² | 2,12 tỷ vay · 1,77 tỷ trả sớm | Giá tiêu chuẩn 2,01 tỷ\nStudio (căn 23) | 30,5 m² | 2,58 tỷ vay · 2,16 tỷ trả sớm | Giá tiêu chuẩn 2,45 tỷ\n1PN+1 (căn 05) | 53,8 m² | 3,45 tỷ vay · 2,89 tỷ trả sớm | Giá tiêu chuẩn 3,28 tỷ\n1PN+1 (căn 19) | 53,8 m² | 3,62 tỷ vay · 3,03 tỷ trả sớm | Giá tiêu chuẩn 3,44 tỷ\n2PN (căn 15) | 64,4 m² | 4,36 tỷ vay · 3,65 tỷ trả sớm | Giá tiêu chuẩn 4,14 tỷ\n2PN (căn 08) | 64,9 m² | 4,52 tỷ vay · 3,78 tỷ trả sớm | Giá tiêu chuẩn 4,30 tỷ\n2PN (căn 24) | 63,8 m² | 5,05 tỷ vay · 4,23 tỷ trả sớm | Giá tiêu chuẩn 4,80 tỷ\nGiỏ hàng 03/10/2026 | – | 4 căn 2PN 64,4 – 64,8 m², 4,32 – 5,16 tỷ | Có 1 căn sân vườn 54,6 m² tầng 3",
			'hh_p_highlights'  => "Tháp Tùng – biểu tượng của sự bền bỉ, sống gần thiên nhiên\nNhận nhà dự kiến 31/3/2028 – sớm hơn Tòa F2 (31/5/2028)\nStudio 30,5 m² từ khoảng 1,77 tỷ nếu thanh toán sớm\nChỉ cần 70% là nhận nhà, 30% còn lại giãn tới 2030\nPháp lý chung 4 tòa: đủ điều kiện bán, sổ từng lô, bảo lãnh Techcombank",
			'hh_p_faq'         => "Tòa F1 FourS Tower là tháp nào? | F1 là Tháp Tùng (Mùa Đông) – một trong 4 tháp Mai, Trúc, Cúc, Tùng của FourS Tower (Sun Group) tại ngã tư Nguyễn Phước Lan – Minh Mạng, Đà Nẵng.\nGiá căn hộ Tòa F1 bao nhiêu? | Theo bảng giá dự kiến: Studio 30,5 m² khoảng 1,77 – 2,58 tỷ, 1PN+1 53,8 m² khoảng 2,89 – 3,62 tỷ, 2PN khoảng 3,65 – 5,16 tỷ tùy căn và cách thanh toán (gồm VAT & KPBT).\nKhi nào nhận nhà Tòa F1? | Dự kiến 31/3/2028 theo chính sách Sun Early Key – thanh toán đủ 70% là nhận nhà.\nMua Tòa F1 có được vay không? | Có, ngân hàng cho vay tới 70%, chủ đầu tư hỗ trợ lãi suất tới 30 tháng (không muộn hơn 30/4/2029). Không vay thì được chiết khấu 5%.",
			'rank_math_title'       => 'FourS Tower F1 Tháp Tùng: Giá, chính sách 10/2026',
			'rank_math_description' => 'Tòa F1 – Tháp Tùng FourS Tower Đà Nẵng: Studio từ khoảng 1,77 tỷ, 2PN 4,3 – 5,2 tỷ, nhận nhà dự kiến 31/3/2028, vay 70% hỗ trợ lãi 30 tháng.',
			'rank_math_focus_keyword' => 'FourS Tower F1,tòa F1 FourS Tower,Tháp Tùng FourS Tower',
		),
		<<<HTML
<p><strong>Tòa F1 – Tháp Tùng (Mùa Đông)</strong> là một trong hai tòa mở bán đầu tiên của <a href="/du-an/fours-tower/">FourS Tower</a> từ tháng 3/2026, cùng với Tòa F5. Tháp lấy hình tượng cây tùng – bền bỉ, xanh quanh năm – và hướng tới người muốn một căn hộ Sun Group giá vừa tầm ở trung tâm khu Nam Đà Nẵng.</p>
<h2>Tòa F1 có những loại căn nào?</h2>
<p>Bảng giá dự kiến của Tòa F1 có ba nhóm căn: Studio 30,5 m², căn 1PN+1 53,8 m² và căn 2 phòng ngủ khoảng 64 m². Cùng một căn, chênh lệch giữa phương án vay và thanh toán sớm có thể tới vài trăm triệu – ví dụ Studio căn 16: khoảng 2,12 tỷ khi vay, khoảng 1,77 tỷ khi thanh toán sớm.</p>
<p>Giỏ hàng cập nhật 03/10/2026 ghi nhận 4 căn 2PN của Tòa F1 (64,4 – 64,8 m², khoảng 4,32 – 5,16 tỷ), trong đó có một căn tầng 3 kèm sân vườn 54,6 m². Căn trống thay đổi hằng ngày nên anh/chị nên hỏi lại trước khi chọn.</p>
<h2>Chính sách thanh toán Tòa F1</h2>
<ul>
<li><strong>Sun Early Key:</strong> ký Hợp đồng thực hiện nguyện vọng trả 15%, sau đó mỗi đợt khoảng 5%; đủ 70% là nhận nhà (dự kiến 31/3/2028), 30% còn lại giãn tới năm 2030.</li>
<li><strong>Vay ngân hàng:</strong> tối đa 70%, chủ đầu tư hỗ trợ lãi suất tới 30 tháng, ân hạn nợ gốc.</li>
<li><strong>Không vay:</strong> chiết khấu 5% trên giá chưa VAT & KPBT; trả trước hạn được tính 8%/năm.</li>
</ul>
<h2>F1 hay F2 – chọn tòa nào?</h2>
<p>Tòa F1 nhận nhà sớm hơn F2 khoảng 2 tháng và có mức giá dự kiến mềm ở nhóm Studio. Tòa F2 là đợt mới nhất với chính sách CSBH 4.2 và quà nội thất. Anh/chị cần dòng tiền nhẹ hay cần nhận nhà sớm thì phương án sẽ khác – xem thêm <a href="/du-an/fours-tower-f2-thap-mai/">Tòa F2 – Tháp Mai</a> và <a href="/du-an/fours-tower/gio-hang/">giỏ hàng FourS Tower</a>.</p>
{$cta}
HTML
		,
		2
	);

	$projects[] = $tower(
		'fours-tower-f5-thap-cuc',
		'FourS Tower F5 – Tháp Cúc (Mùa Thu) Đà Nẵng',
		'Tòa F5 – Tháp Cúc FourS Tower Đà Nẵng: 20 tầng, nhận nhà dự kiến 31/3/2028. Studio 34,9 m² từ khoảng 1,96 tỷ (thanh toán sớm), 1PN+ 45 – 48 m² khoảng 3,0 – 3,4 tỷ, 3PN khoảng 5,5 – 6,6 tỷ.',
		array(
			'hh_p_blocks'      => 'Tòa F5 – Tháp Cúc (Mùa Thu), 1 trong 4 tháp FourS Tower',
			'hh_p_image_links' => "plugin:img/fours-tower/fours-tower-ve-dem-huong-song.jpg | FourS Tower về đêm hướng sông – cụm 4 tháp có Tòa F5 – Tháp Cúc | đại diện\nplugin:img/fours-tower/fours-tower-toan-canh-hoang-hon.jpg | Toàn cảnh FourS Tower Đà Nẵng lúc hoàng hôn | thư viện\nplugin:img/fours-tower/fours-tower-pho-thuong-mai-khoi-de.jpg | Phố thương mại khối đế FourS Tower | tiện ích",
			'hh_p_price_from'  => 1960,
			'hh_p_price_m2'    => 'Khoảng 52 – 72 triệu/m² thông thủy tùy căn và cách thanh toán (gồm VAT & KPBT)',
			'hh_p_unit_types'  => "Studio | 34,9 m² | – | Khoảng 1,96 – 2,34 tỷ\nCăn 1PN | 46,7 m² | 1 | Khoảng 2,91 tỷ\nCăn 1PN+ / 1PN+1 | 45,2 – 53,8 m² | 1 + phòng đa năng | Khoảng 2,69 – 3,48 tỷ\nCăn 2PN | 73,1 m² | 2 | Khoảng 4,89 – 4,93 tỷ\nCăn 3PN | 92,8 – 93,2 m² | 3 | Khoảng 5,51 – 6,59 tỷ",
			'hh_p_price_table' => "Studio (căn 18) | 34,9 m² | 2,34 tỷ vay · 1,96 tỷ trả sớm | Giá tiêu chuẩn 2,23 tỷ\n1PN+ (căn 24) | 45,2 m² | 3,22 tỷ vay · 2,69 tỷ trả sớm | Giá tiêu chuẩn 3,06 tỷ\n1PN+1 (căn 15) | 53,8 m² | 3,36 tỷ vay · 2,81 tỷ trả sớm | Giá tiêu chuẩn 3,19 tỷ\n1PN+1 (căn 31) | 53,8 m² | 3,48 tỷ vay · 2,91 tỷ trả sớm | Giá tiêu chuẩn 3,31 tỷ\n3PN (căn 09) | 92,8 m² | 6,59 tỷ vay · 5,51 tỷ trả sớm | Giá tiêu chuẩn 6,26 tỷ\nGiỏ hàng 03/10/2026 | – | 22 căn: 18 căn 1PN+ 3,02 – 3,37 tỷ, 2 căn 2PN, 1 căn 1PN, 1 căn 3PN | 5 căn có sân vườn",
			'hh_p_highlights'  => "Tháp Cúc – an nhiên, phúc lộc, không gian thoáng\nNhận nhà dự kiến 31/3/2028\nNhiều căn 1PN+ 45 – 48 m² khoảng 3,0 – 3,4 tỷ – hợp ở và cho thuê\nCó căn 3PN 92,8 – 93,2 m² cho gia đình\nPháp lý chung 4 tòa: đủ điều kiện bán, sổ từng lô, bảo lãnh Techcombank",
			'hh_p_faq'         => "Tòa F5 FourS Tower là tháp nào? | F5 là Tháp Cúc (Mùa Thu) – một trong 4 tháp Mai, Trúc, Cúc, Tùng của FourS Tower (Sun Group) tại ngã tư Nguyễn Phước Lan – Minh Mạng, Đà Nẵng.\nGiá căn hộ Tòa F5 bao nhiêu? | Theo bảng giá dự kiến: Studio 34,9 m² khoảng 1,96 – 2,34 tỷ, 1PN+ / 1PN+1 khoảng 2,69 – 3,48 tỷ, 3PN 92,8 m² khoảng 5,51 – 6,59 tỷ tùy cách thanh toán (gồm VAT & KPBT).\nTòa F5 còn căn không? | Giỏ hàng 03/10/2026 có 22 căn, nhiều nhất là 1PN+ 45 – 48 m² (khoảng 3,02 – 3,37 tỷ). Căn trống thay đổi hằng ngày – hỏi Hoàng Hiệp trước khi chọn.\nKhi nào nhận nhà Tòa F5? | Dự kiến 31/3/2028 theo chính sách Sun Early Key – thanh toán đủ 70% là nhận nhà.",
			'rank_math_title'       => 'FourS Tower F5 Tháp Cúc: Giá, chính sách 10/2026',
			'rank_math_description' => 'Tòa F5 – Tháp Cúc FourS Tower Đà Nẵng: Studio từ khoảng 1,96 tỷ, 1PN+ 3,0 – 3,4 tỷ, 3PN 5,5 – 6,6 tỷ, nhận nhà dự kiến 31/3/2028, giỏ hàng 22 căn.',
			'rank_math_focus_keyword' => 'FourS Tower F5,tòa F5 FourS Tower,Tháp Cúc FourS Tower',
		),
		<<<HTML
<p><strong>Tòa F5 – Tháp Cúc (Mùa Thu)</strong> mở bán từ tháng 3/2026 cùng Tòa F1, là tòa có nhiều căn 1 phòng ngủ cộng (1PN+) nhất trong giỏ hàng hiện tại của <a href="/du-an/fours-tower/">FourS Tower</a>. Hình tượng hoa cúc gắn với sự an nhiên – hợp với người mua để ở lâu dài lẫn người cần căn nhỏ để cho thuê.</p>
<h2>Giá và loại căn Tòa F5</h2>
<p>Theo bảng giá dự kiến, Studio 34,9 m² của F5 khoảng 2,34 tỷ khi vay và còn khoảng 1,96 tỷ nếu thanh toán sớm. Nhóm 1PN+ / 1PN+1 (45,2 – 53,8 m²) dao động khoảng 2,69 – 3,48 tỷ; căn 3 phòng ngủ 92,8 m² khoảng 5,51 – 6,59 tỷ.</p>
<p>Giỏ hàng ngày 03/10/2026 có 22 căn F5: 18 căn 1PN+ (khoảng 3,02 – 3,37 tỷ), 2 căn 2PN 73,1 m², 1 căn 1PN và 1 căn 3PN – trong đó 5 căn kèm sân vườn. Danh sách căn trống cập nhật liên tục, anh/chị nhắn để nhận bản mới nhất.</p>
<h2>Thanh toán và nhận nhà</h2>
<ul>
<li>Cọc 100 triệu (Studio đến 2PN), 150 triệu với căn 3PN.</li>
<li>Trả 15% khi ký, mỗi đợt thêm khoảng 5%; đủ 70% là nhận nhà – dự kiến 31/3/2028; 30% còn lại giãn tới năm 2030.</li>
<li>Vay tối đa 70%, hỗ trợ lãi suất tới 30 tháng; không vay được chiết khấu 5%.</li>
</ul>
<h2>F5 hợp với ai?</h2>
<p>Căn 1PN+ diện tích 45 – 48 m² là lựa chọn gọn cho vợ chồng trẻ hoặc người mua cho thuê dài hạn; căn 3PN dành cho gia đình đông người. So sánh với <a href="/du-an/fours-tower-f1-thap-tung/">Tòa F1</a> và <a href="/du-an/fours-tower-f2-thap-mai/">Tòa F2</a> trước khi chốt để chọn đúng tòa, đúng tầng.</p>
{$cta}
HTML
		,
		3
	);
	return $projects;
}
