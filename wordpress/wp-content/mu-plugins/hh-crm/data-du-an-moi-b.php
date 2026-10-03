<?php
/**
 * Dự án mới (nhóm B): Masteri Rivera Danang (Masteri Đà Nẵng), Vista Residence Đà Nẵng, The Meridian Đà Nẵng – cùng khu Hòa Cường Nam, Hải Châu.
 * Tổng hợp từ VnExpress, CafeF, Thanh Niên, CAND, Báo Đầu tư, CafeLand và trang phân phối (10/2026). Giá là mức chào bán tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_du_an_moi_b', 20 );
function hh_dataset_du_an_moi_b( $projects ) {
	// Masteri Rivera Danang (Masteri Đà Nẵng) – Masterise Homes.
	$projects[] = array(
		'slug'    => 'masteri-da-nang',
		'title'   => 'Masteri Rivera Danang (Masteri Đà Nẵng)',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Masteri Rivera Danang – dự án đầu tiên của Masterise Homes tại Đà Nẵng: 2 tháp 39 tầng, gần 1.200 căn hộ 52 – 113 m² trên đường Quy Mỹ (Hải Châu), 31 tiện ích nội khu, giá từ khoảng 4,1 tỷ.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Masterise Homes (Masterise Group)',
			'hh_p_builder'      => 'Central (Centralcons)',
			'hh_p_type'         => 'Căn hộ cao cấp sở hữu lâu dài, Dual Key, khối đế thương mại',
			'hh_p_address'      => '50 Quy Mỹ (3 mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch), phường Hòa Cường Nam (cũ), Hải Châu, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 18.296 m² (1,83 ha), vốn đầu tư hơn 3.300 tỷ đồng',
			'hh_p_blocks'       => '2 tòa tháp',
			'hh_p_floors'       => '39 tầng nổi, 2 tầng hầm',
			'hh_p_units'        => 'Gần 1.200 căn hộ (một số nguồn ghi 1.112 căn đủ điều kiện bán – tham khảo)',
			'hh_p_unit_area'    => 'Khoảng 47 – 113 m²',
			'hh_p_price_m2'     => 'Khoảng 70 – 94 triệu/m² (tham khảo, tùy nguồn)',
			'hh_p_price_from'   => 4130,
			'hh_p_legal'        => 'Đã có văn bản đủ điều kiện bán nhà ở hình thành trong tương lai của Sở Xây dựng Đà Nẵng',
			'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam); 50 năm (người nước ngoài)',
			'hh_p_start'        => '2025 (ra mắt 20/5/2025)',
			'hh_p_handover'     => 'Dự kiến Quý III/2026 (một số nguồn ghi Quý IV/2026)',
			'hh_p_handover_std' => 'Hoàn thiện sàn, trần, tường và nội thất cơ bản',
			'hh_p_highlights'   => "Dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng\n2 tháp 39 tầng, gần 1.200 căn, ven sông Hàn khu Hòa Cường Nam\n31 tiện ích nội khu từ tầng 1 đến tầng 4\nĐã cất nóc tháng 12/2025, tổng thầu Central\nSở hữu lâu dài cho người Việt Nam",
			'hh_p_design_desc'  => 'Hai tháp 39 tầng trên khối đế thương mại tầng 1 – 3 (shophouse, trung tâm thương mại khoảng 2.500 m²), tầng 4 là hồ bơi resort, vườn dạo bộ và sân chơi trẻ em; 2 tầng hầm đỗ xe. Cơ cấu căn: 1PN+, 2PN, 2PN+, 3PN và Dual Key.',
			'hh_p_unit_types'   => "Căn 1PN+ | Khoảng 47,4 m² | 1+ | Khoảng 4,13 – 4,51 tỷ\nCăn 2PN | Khoảng 66,9 – 68,3 m² | 2 | Khoảng 5,14 – 6,3 tỷ\nCăn 2PN+ | – | 2+ | Khoảng 5,9 – 6,65 tỷ\nCăn 3PN | – | 3 | Khoảng 6,68 – 8,11 tỷ\nDual Key | – | – | Khoảng 9,43 – 10,34 tỷ",
			'hh_p_shop_desc'    => 'Khối đế thương mại tầng 1 – 3 gồm shophouse, shop góc và trung tâm thương mại khoảng 2.500 m²; giá shop chưa công bố rộng rãi (thỏa thuận).',
			'hh_p_shop_table'   => 'Shophouse / shop góc khối đế | – | Liên hệ (thỏa thuận) | Tầng 1 – 3',
			'hh_p_location_desc' => 'Dự án nằm trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu), gần sông Hàn, Lotte Mart, Asia Park (Sun World Đà Nẵng Wonders) và cách cầu Rồng không xa. Phần lớn căn hộ có hướng nhìn về sông Hàn.',
			'hh_p_connections'  => "Vài phút | Sông Hàn, đường 2/9\nVài phút | Lotte Mart, Asia Park\nKhoảng 10 phút | Cầu Rồng, trung tâm Hải Châu\nKhoảng 10 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in' => "31 tiện ích nội khu (tầng 1 – 4)\nHồ bơi resort, sảnh thư giãn\nVườn BBQ, vườn yoga\nSân chơi vườn trên cao, khu vui chơi trẻ em\nSân pickleball, phòng gym\nTrung tâm thương mại khoảng 2.500 m², nhà hàng",
			'hh_p_amenities_out' => "Lotte Mart, Asia Park\nSông Hàn, công viên ven sông\nTrường học, bệnh viện khu Hải Châu\nCầu Rồng, trung tâm hành chính",
			'hh_p_progress'     => "21/11/2024 | Đủ điều kiện bán nhà ở hình thành trong tương lai (theo trang phân phối)\n20/5/2025 | Ra mắt dự án\n8/2025 | Tri ân hơn 1.000 khách hàng\n12/2025 | Cất nóc 2 tòa tháp\nQuý III/2026 | Dự kiến bàn giao",
		),
		'content' => '<p><strong>Masteri Rivera Danang</strong> (thường gọi Masteri Đà Nẵng) là dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng, nằm trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu). Dự án rộng khoảng 18.296 m², gồm 2 tòa tháp 39 tầng, 2 tầng hầm với gần 1.200 căn hộ sở hữu lâu dài, tổng thầu là Central.</p>
<h2>Các loại căn hộ Masteri Rivera Danang</h2>
<ul>
<li>Căn 1PN+ khoảng 47 m², giá tham khảo khoảng 4,13 – 4,51 tỷ.</li>
<li>Căn 2PN khoảng 67 – 68 m², khoảng 5,14 – 6,3 tỷ; căn 2PN+ khoảng 5,9 – 6,65 tỷ.</li>
<li>Căn 3PN khoảng 6,68 – 8,11 tỷ và căn Dual Key khoảng 9,43 – 10,34 tỷ.</li>
<li>Khối đế thương mại tầng 1 – 3 có shophouse và trung tâm thương mại khoảng 2.500 m².</li>
</ul>
<h2>Vị trí Masteri Rivera Danang</h2>
<p>Dự án có ba mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch, gần sông Hàn, Lotte Mart và Asia Park. Theo chủ đầu tư, phần lớn căn hộ có hướng nhìn về sông Hàn.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Dự án đã có văn bản đủ điều kiện bán, ra mắt tháng 5/2025 và cất nóc tháng 12/2025. Bàn giao dự kiến Quý III/2026 (một số nguồn ghi Quý IV/2026). Người Việt Nam được sở hữu lâu dài, người nước ngoài 50 năm. Giá chào bán trung bình được các nguồn ghi khoảng 70 – 94 triệu/m².</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, giỏ hàng căn còn lại và chính sách thanh toán mới nhất của Masteri Rivera Danang.</p>',
		'sources' => array(
			'https://vnexpress.net/masterise-homes-ra-mat-du-an-can-ho-dau-tien-tai-da-nang-4888365.html',
			'https://cafef.vn/masterise-homes-cong-bo-masteri-rivera-danang-du-an-dau-tien-tai-da-nang-188250521110118437.chn',
			'https://cafef.vn/masterise-homes-chinh-thuc-cat-noc-du-an-masteri-rivera-danang-188251202103820178.chn',
			'https://cafeland.vn/du-an/masteri-rivera-danang-du-an-can-ho-tai-da-nang-4518.html',
			'https://masterisehomes.com/masteri-rivera-danang/en/',
			'https://www.centralcons.vn/central-cap-nhat-tien-do-du-an-masteri-rivera-danang/',
		),
	);

	// Vista Residence Đà Nẵng – Cường Thịnh Phát Land.
	$projects[] = array(
		'slug'    => 'vista-residence-da-nang',
		'title'   => 'Vista Residence Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => false,
		'excerpt' => 'Vista Residence Đà Nẵng tại 40A Xô Viết Nghệ Tĩnh (Hải Châu): tòa căn hộ 20 tầng, 112 căn 2 – 3 phòng ngủ 76 – 112 m², sở hữu lâu dài, đã bàn giao từ tháng 8/2026.',
		'meta'    => array(
			'hh_p_status'       => 'dang-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_developer'    => 'Công ty CP Cường Thịnh Phát Land',
			'hh_p_type'         => 'Căn hộ cao cấp sở hữu lâu dài (tên pháp lý: chung cư Bắc Cường)',
			'hh_p_address'      => '40A Xô Viết Nghệ Tĩnh, phường Hòa Cường Nam (cũ), Hải Châu, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 1.700 m² đất',
			'hh_p_blocks'       => '1 tòa',
			'hh_p_floors'       => '20 tầng nổi + tầng penthouse/kỹ thuật, 2 tầng hầm (một số nguồn ghi 22 tầng)',
			'hh_p_units'        => '112 căn hộ',
			'hh_p_unit_area'    => '76 – 112 m²',
			'hh_p_price_m2'     => 'Khoảng 50 – 55 triệu/m² khi mở bán (tham khảo, tùy nguồn)',
			'hh_p_price_from'   => 4500,
			'hh_p_ownership'    => 'Sở hữu lâu dài',
			'hh_p_start'        => 'Cuối tháng 7/2023',
			'hh_p_handover'     => 'Bàn giao từ 7/8/2026',
			'hh_p_handover_std' => 'Hoàn thiện: thiết bị vệ sinh TOTO, thiết bị điện Philips, Panasonic, sơn Jotun',
			'hh_p_highlights'   => "Chỉ 112 căn hộ, mật độ cư dân thấp\nToàn bộ 112 căn có chủ trong buổi mở bán chính thức\nĐã nghiệm thu hoàn thành (15/7/2026) và bàn giao từ 8/2026\nHồ bơi vô cực, sky bar trên cao\nSở hữu lâu dài, trung tâm Hải Châu",
			'hh_p_unit_types'   => "Căn 2PN | 76 – 82 m² | 2 | Khoảng 4,5 – 5,56 tỷ\nCăn 3PN | 112 m² | 3 | Khoảng 6,8 – 7,56 tỷ",
			'hh_p_location_desc' => 'Dự án nằm trên đường Xô Viết Nghệ Tĩnh, khu Hòa Cường (Hải Châu), kết nối nhanh với đường 2/9, sông Hàn và trung tâm thành phố.',
			'hh_p_connections'  => "Vài phút | Đường 2/9, sông Hàn\nVài phút | Lotte Mart, Asia Park\nKhoảng 10 phút | Trung tâm Hải Châu\nKhoảng 10 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in' => "Hồ bơi vô cực\nSky bar\nPhòng gym\nKhu thương mại\nKhu vui chơi trẻ em\n2 tầng hầm hơn 2.100 m²",
			'hh_p_amenities_out' => "Lotte Mart, Asia Park\nSông Hàn, đường 2/9\nTrường học, bệnh viện khu Hải Châu",
			'hh_p_progress'     => "7/2023 | Khởi công\n8/2024 | Đóng nắp hầm\n6/2025 | Cất nóc\n15/7/2026 | Sở Xây dựng chấp thuận kết quả nghiệm thu hoàn thành\n7/8/2026 | Lễ bàn giao căn hộ",
			'hh_p_policy'       => 'Toàn bộ 112 căn đã có chủ trong đợt mở bán chính thức; hiện chủ yếu giao dịch chuyển nhượng thứ cấp và cho thuê (giá thuê được báo khoảng 21 – 40 triệu/tháng, tham khảo).',
		),
		'content' => '<p><strong>Vista Residence Đà Nẵng</strong> là tòa căn hộ tại 40A Xô Viết Nghệ Tĩnh (Hải Châu) do Công ty CP Cường Thịnh Phát Land làm chủ đầu tư, Đất Xanh Miền Trung phân phối. Dự án xây trên khu đất khoảng 1.700 m², gồm 20 tầng nổi và tầng penthouse, 2 tầng hầm, quy mô 112 căn hộ sở hữu lâu dài.</p>
<h2>Các loại căn hộ Vista Residence</h2>
<ul>
<li>Căn 2 phòng ngủ 76 – 82 m², giá tham khảo khoảng 4,5 – 5,56 tỷ.</li>
<li>Căn 3 phòng ngủ 112 m², khoảng 6,8 – 7,56 tỷ.</li>
</ul>
<p>Giá mở bán được các nguồn ghi khoảng 50 – 55 triệu/m². Toàn bộ 112 căn đã có chủ trong buổi mở bán chính thức, nên hiện giao dịch chủ yếu là chuyển nhượng.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Dự án khởi công cuối tháng 7/2023, đóng nắp hầm tháng 8/2024 và cất nóc tháng 6/2025. Ngày 15/7/2026, Sở Xây dựng Đà Nẵng chấp thuận kết quả nghiệm thu hoàn thành; lễ bàn giao diễn ra ngày 7/8/2026. Tiện ích gồm hồ bơi vô cực, sky bar, gym, khu thương mại và khu vui chơi trẻ em.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn chuyển nhượng, căn cho thuê và giá cập nhật tại Vista Residence Đà Nẵng.</p>',
		'sources' => array(
			'https://thanhnien.vn/vista-residence-da-nang-chinh-thuc-ban-giao-can-ho-185260807165909468.htm',
			'https://cand.vn/dia-oc/toan-bo-can-ho-vista-residence-da-nang-co-chu-trong-buoi-mo-ban-chinh-thuc-i766542',
			'https://cafeland.vn/tin-tuc/cat-noc-du-an-vista-residence-da-nang-139386.html',
			'https://baodautu.vn/du-an-the-vista-residence-da-nang-hoan-tat-dong-nap-ham---hua-hen-buoc-tien-dot-pha-moi-d221918.html',
			'https://cafeland.vn/du-an/du-an-can-ho-the-vista-residence-da-nang-4448.html',
			'https://vietnamnet.vn/chinh-thuc-ban-giao-can-ho-vista-residence-da-nang-2543303.html',
		),
	);

	// The Meridian Đà Nẵng – Landcom (phân khu cao tầng Elysia Complex City).
	$projects[] = array(
		'slug'    => 'the-meridian-da-nang',
		'title'   => 'The Meridian Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'The Meridian Đà Nẵng trên đường Quy Mỹ (Hải Châu) bên sông Hàn: 2 tháp 25 tầng, 518 căn hộ studio – 3PN 42 – 139 m², sở hữu lâu dài, giá khoảng 70 – 95 triệu/m², bàn giao dự kiến 2027.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty CP Đầu tư Landcom',
			'hh_p_type'         => 'Căn hộ cao cấp ven sông Hàn, penthouse, shophouse khối đế (tên pháp lý: Elysia Complex Riverside)',
			'hh_p_address'      => 'Đường Quy Mỹ, phường Hòa Cường Nam (cũ), Hải Châu, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 7.008 m², phân khu cao tầng giai đoạn 2 khu đô thị Elysia Complex City',
			'hh_p_density'      => 'Khoảng 33,6% (một số nguồn ghi 45 – 50%)',
			'hh_p_blocks'       => '2 tòa tháp đôi T1, T2',
			'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm',
			'hh_p_units'        => '518 căn hộ (10 – 12 căn/tầng điển hình)',
			'hh_p_unit_area'    => '42 – 139 m² (penthouse khoảng 198 m²)',
			'hh_p_price_m2'     => 'Khoảng 70 – 95 triệu/m² (tham khảo)',
			'hh_p_price_from'   => 2900,
			'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam); 50 năm (người nước ngoài)',
			'hh_p_handover'     => 'Dự kiến năm 2027 (nguồn ghi Quý II/2027 hoặc Quý IV/2027)',
			'hh_p_highlights'   => "Ven sông Hàn, ban công nhìn trực diện khu bắn pháo hoa DIFF\nKiến trúc lấy cảm hứng từ siêu du thuyền\n2 tháp 25 tầng, 518 căn, hành lang rộng 1,8 m, 14 thang máy\nHơn 30 tiện ích nội khu, hồ bơi vô cực view sông\nSở hữu lâu dài cho người Việt Nam",
			'hh_p_design_desc'  => 'Hai tháp đối xứng T1 và T2, mỗi tầng điển hình 10 – 12 căn, hành lang rộng 1,8 m, 14 thang máy (gồm thang chữa cháy). Sản phẩm gồm studio, căn 1 – 3 phòng ngủ, penthouse và shophouse khối đế.',
			'hh_p_unit_types'   => "Studio / 1PN | 42 – 60,98 m² | 0 – 1 | Khoảng 2,9 – 4,2 tỷ\nCăn 2PN | 72,55 – 79,08 m² | 2 | Khoảng 5,1 – 6,3 tỷ\nCăn 3PN | 121,08 – 139,6 m² | 3 | Khoảng 8,5 – 11,2 tỷ",
			'hh_p_shop_desc'    => 'Shophouse tại tầng đế hai tháp, bên cạnh hồ bơi, gym, spa và các tiện ích nội khu; diện tích và giá chưa công bố rộng rãi.',
			'hh_p_shop_table'   => 'Shophouse khối đế | – | Liên hệ | Tầng đế tòa tháp',
			'hh_p_penthouse_desc'  => 'Penthouse trên tầng cao, diện tích đến khoảng 198 m², hướng nhìn sông Hàn và biển; trang phân phối ghi giá khoảng 85 – 90 triệu/m².',
			'hh_p_penthouse_table' => 'Penthouse | Đến khoảng 198 m² | – | Khoảng 14 – 17,8 tỷ',
			'hh_p_location_desc' => 'The Meridian nằm trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu), thuộc khu đô thị Elysia Complex City ven sông Hàn, hướng về khu vực bắn pháo hoa quốc tế Đà Nẵng (DIFF).',
			'hh_p_connections'  => "Vài phút | Sông Hàn, đường 2/9\nVài phút | Lotte Mart, Asia Park\nKhoảng 10 phút | Cầu Rồng, trung tâm Hải Châu\nKhoảng 10 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in' => "Hơn 30 tiện ích nội khu\nHồ bơi vô cực view sông Hàn\nPhòng gym, spa\nShophouse khối đế\nKhu vui chơi trẻ em",
			'hh_p_amenities_out' => "Sông Hàn, khu bắn pháo hoa DIFF\nLotte Mart, Asia Park\nTrường học, bệnh viện khu Hải Châu",
			'hh_p_progress'     => "10/2025 | Hoàn thiện hạ tầng kỹ thuật nội bộ, đào móng tầng hầm\n6/1/2026 | Khánh thành căn hộ mẫu\n11/1/2026 | Lễ giới thiệu dự án\n4/2026 | Thi công tầng hầm B2\nQuý IV/2026 | Dự kiến cất nóc\n2027 | Dự kiến bàn giao",
			'hh_p_policy'       => 'Chính sách được công bố (tham khảo): thanh toán 30% khi ký hợp đồng, sau đó 1%/tháng trong 24 tháng không lãi; chiết khấu đến 10% khi thanh toán sớm; ngân hàng SHB hỗ trợ vay đến 70% giá trị căn, lãi suất 0% năm đầu.',
		),
		'content' => '<p><strong>The Meridian Đà Nẵng</strong> là tổ hợp hai tháp căn hộ cao cấp ven sông Hàn trên đường Quy Mỹ (Hải Châu), do Công ty CP Đầu tư Landcom làm chủ đầu tư, Công ty CP Đầu tư và Phát triển Đà Thành (DDI) phát triển kinh doanh. Dự án rộng khoảng 7.008 m², thuộc khu đô thị Elysia Complex City, gồm 2 tháp 25 tầng, 2 tầng hầm với 518 căn hộ sở hữu lâu dài.</p>
<h2>Các loại căn hộ The Meridian</h2>
<ul>
<li>Studio và căn 1PN 42 – 61 m², giá tham khảo khoảng 2,9 – 4,2 tỷ.</li>
<li>Căn 2PN 72,5 – 79 m², khoảng 5,1 – 6,3 tỷ.</li>
<li>Căn 3PN 121 – 139,6 m², khoảng 8,5 – 11,2 tỷ.</li>
<li>Penthouse đến khoảng 198 m² (khoảng 14 – 17,8 tỷ) và shophouse khối đế.</li>
</ul>
<h2>Vị trí The Meridian</h2>
<p>Dự án nằm bên bờ sông Hàn, khu Hòa Cường Nam, ban công hướng về khu bắn pháo hoa quốc tế Đà Nẵng. Kiến trúc hai tháp lấy cảm hứng từ siêu du thuyền, hơn 30 tiện ích nội khu gồm hồ bơi vô cực nhìn sông, gym, spa.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Căn hộ mẫu khánh thành ngày 6/1/2026, dự án giới thiệu ngày 11/1/2026. Đầu tháng 4/2026 dự án thi công tầng hầm B2, dự kiến cất nóc Quý IV/2026 và bàn giao năm 2027 (các nguồn ghi Quý II hoặc Quý IV/2027). Giá chào bán khoảng 70 – 95 triệu/m² tùy tầng và hướng.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, mặt bằng và chính sách thanh toán mới nhất của The Meridian Đà Nẵng.</p>',
		'sources' => array(
			'https://thanhnien.vn/the-meridian-ra-mat-tai-da-nang-sieu-du-thuyen-kien-truc-chinh-thuc-ha-thuy-song-han-185260112084502674.htm',
			'https://congthuong.vn/the-meridian-da-nang-chinh-thuc-ra-mat-can-ho-mau-cu-hich-cho-thi-truong-bat-dong-san-437945.html',
			'https://diendandoanhnghiep.vn/man-nhan-va-an-tuong-voi-le-gioi-thieu-thap-can-ho-cao-cap-the-meridian-da-nang-10168954.html',
			'https://cafeland.vn/du-an/the-meridian-da-nang-phan-khu-can-ho-thuoc-elysia-complex-5345.html',
			'https://the-meridian.com.vn/bang-gia-the-meridian-da-nang/',
		),
	);

	return $projects;
}
