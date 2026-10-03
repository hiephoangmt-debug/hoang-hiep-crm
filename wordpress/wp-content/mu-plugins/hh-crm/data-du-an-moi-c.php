<?php
/**
 * Dự án mới (nhóm C) ven biển Mỹ Khê – Sơn Trà: Nobu Residences Đà Nẵng, Alizé Đà Nẵng, Wyndham Soleil Đà Nẵng.
 * Tổng hợp từ VnExpress, VnEconomy, Báo Đầu tư, CafeLand, CafeF, Savills và trang dự án (10/2026). Giá là mức chào bán tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_du_an_moi_c', 20 );
function hh_dataset_du_an_moi_c( $projects ) {
	$projects[] = array(
		'slug'    => 'nobu-da-nang',
		'title'   => 'Nobu Residences Đà Nẵng',
		'type'    => 'can-ho-dich-vu',
		'area'    => 'son-tra',
		'hot'     => true,
		'excerpt' => 'Nobu Residences Đà Nẵng – tháp 43 tầng tại góc Võ Văn Kiệt – Võ Nguyên Giáp (Sơn Trà): 264 căn hộ hàng hiệu Nobu và 186 phòng khách sạn, bàn giao dự kiến 2027.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'VCRE (Viet Capital Real Estate) – pháp nhân dự án: Công ty CP Bất động sản Circle Point',
			'hh_p_builder'      => 'Newtecons',
			'hh_p_manager'      => 'Nobu Hospitality',
			'hh_p_type'         => 'Căn hộ hàng hiệu (branded residences), khách sạn Nobu, nhà hàng Nobu',
			'hh_p_address'      => '01 Võ Văn Kiệt (góc Võ Nguyên Giáp), phường Phước Mỹ (cũ), Sơn Trà, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 3.000 m² đất, tổng sàn xây dựng khoảng 48.510 m²',
			'hh_p_blocks'       => '1 tòa tháp',
			'hh_p_floors'       => '43 tầng nổi (cao khoảng 186 m), 2 tầng hầm',
			'hh_p_units'        => '264 căn hộ hàng hiệu và 186 phòng khách sạn',
			'hh_p_unit_area'    => 'Khoảng 42 – 372 m² (studio đến penthouse)',
			'hh_p_price_m2'     => 'Khoảng 145 – 205 triệu/m² tùy tầng, view (tham khảo; một số nguồn ghi 150 – 250 triệu/m²)',
			'hh_p_legal'        => 'Đất thương mại dịch vụ, thời hạn đến năm 2060 (theo một số nguồn phân phối)',
			'hh_p_ownership'    => 'Các nguồn chưa thống nhất: trang phân phối ghi sở hữu lâu dài cho người Việt Nam và 50 năm cho người nước ngoài, nguồn khác ghi thời hạn đến 2060 theo đất thương mại dịch vụ – cần đối chiếu hợp đồng mua bán',
			'hh_p_start'        => 'Quý 2/2024',
			'hh_p_handover'     => 'Dự kiến năm 2027 (các nguồn ghi Quý 1 – Quý 3/2027)',
			'hh_p_handover_std' => 'Hoàn thiện nội thất theo tiêu chuẩn Nobu, phong cách Japandi',
			'hh_p_highlights'   => "Dự án Nobu Residences đầu tiên tại Đông Nam Á\nThương hiệu Nobu Hospitality của Robert De Niro, Nobu Matsuhisa và Meir Teper\nTháp 43 tầng cao khoảng 186 m, kiến trúc hình quạt giấy Nhật Bản (Sensu)\nNhà hàng Nobu trên tầng 42, hồ bơi vô cực nước ấm tại tầng 18\nChỉ 264 căn hộ, có Sky Villa hồ bơi riêng và penthouse",
			'hh_p_design_desc'  => 'Kiến trúc lấy cảm hứng từ quạt giấy Nhật Bản (Sensu) và nguyên lý mượn cảnh (Shakkei), nội thất phong cách Japandi tối giản, tận dụng ánh sáng tự nhiên và hướng nhìn biển Mỹ Khê. Cơ cấu gồm studio, căn 1 – 3 phòng ngủ, căn Dual Key, Sky Villa có hồ bơi riêng và penthouse.',
			'hh_p_unit_types'   => "Studio | Khoảng 42,2 – 43 m² | – | Liên hệ\nCăn 1PN | Khoảng 62,5 – 71,1 m² | 1 | Khoảng 6,63 – 9,06 tỷ (tham khảo)\nCăn 2PN | Khoảng 99,7 – 118,7 m² | 2 | Liên hệ\nCăn 3PN Dual Key | Khoảng 130,1 – 166,2 m² | 3 | Liên hệ",
			'hh_p_penthouse_desc'  => 'Tầng cao có 6 căn Sky Villa sở hữu hồ bơi riêng (khoảng 254 – 288 m²) và 2 căn penthouse (khoảng 372 m²; một số nguồn ghi 358,5 – 424 m²), tầm nhìn toàn cảnh biển Mỹ Khê và bán đảo Sơn Trà.',
			'hh_p_penthouse_table' => "Sky Villa hồ bơi riêng (6 căn) | Khoảng 254 – 288 m² | – | Liên hệ\nPenthouse (2 căn) | Khoảng 372 m² | – | Liên hệ",
			'hh_p_location_desc'   => 'Nobu Đà Nẵng nằm tại góc giao Võ Văn Kiệt – Võ Nguyên Giáp, mặt tiền biển Mỹ Khê thuộc Sơn Trà. Từ dự án đi cầu Rồng, cầu sông Hàn vào trung tâm Hải Châu và ra sân bay quốc tế Đà Nẵng thuận tiện.',
			'hh_p_connections'     => "1 phút | Bãi biển Mỹ Khê\n5 phút | Cầu Rồng, sông Hàn\n10 phút | Trung tâm Hải Châu\n15 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in'    => "Nhà hàng Nobu (tầng 42)\nHồ bơi vô cực nước ấm (tầng 18)\nKhách sạn Nobu 186 phòng\nSpa, phòng gym\nDịch vụ quản lý căn hộ theo tiêu chuẩn Nobu Hospitality",
			'hh_p_amenities_out'   => "Bãi biển Mỹ Khê, công viên Biển Đông\nPhố ẩm thực, nhà hàng ven biển Võ Nguyên Giáp\nCầu Rồng, trung tâm Hải Châu",
			'hh_p_progress'        => "Quý 2/2024 | Khởi công, Newtecons thi công\n01 – 02/2026 | Hoàn thành sàn chuyển L6M, chuyển sang thi công tầng điển hình\n05/2026 | Đổ bê tông sàn tầng 8, lắp hệ leo tầng 9\n2027 | Dự kiến hoàn thiện, bàn giao và vận hành",
			'hh_p_rental'          => 'Căn hộ có thể tham gia chương trình cho thuê do Nobu Hospitality vận hành; một số nguồn phân phối nêu mức cam kết lợi nhuận khoảng 6%/năm – cần kiểm tra điều kiện cụ thể theo hợp đồng.',
		),
		'content' => '<p><strong>Nobu Residences Đà Nẵng</strong> (Nobu Danang) là tổ hợp căn hộ hàng hiệu và khách sạn do VCRE (Viet Capital Real Estate) phát triển theo giấy phép thương hiệu của Nobu Hospitality – thương hiệu do Robert De Niro, đầu bếp Nobu Matsuhisa và Meir Teper sáng lập. Dự án nằm tại góc Võ Văn Kiệt – Võ Nguyên Giáp (Sơn Trà), trên khu đất khoảng 3.000 m², cao 43 tầng (khoảng 186 m) với 264 căn hộ và 186 phòng khách sạn. Đây là dự án Nobu Residences đầu tiên tại Đông Nam Á.</p>
<h2>Các loại căn hộ Nobu Đà Nẵng</h2>
<ul>
<li>Studio khoảng 42 – 43 m².</li>
<li>Căn 1 phòng ngủ khoảng 62,5 – 71,1 m², giá tham khảo khoảng 6,6 – 9,1 tỷ.</li>
<li>Căn 2 phòng ngủ khoảng 99,7 – 118,7 m² và căn 3 phòng ngủ Dual Key khoảng 130 – 166 m².</li>
<li>6 căn Sky Villa có hồ bơi riêng và 2 căn penthouse khoảng 372 m².</li>
</ul>
<p>Đơn giá chào bán tham khảo khoảng 145 – 205 triệu/m² tùy tầng và hướng view.</p>
<h2>Vị trí ven biển Mỹ Khê</h2>
<p>Dự án mặt tiền đường Võ Nguyên Giáp, nhìn thẳng biển Mỹ Khê, kết nối nhanh với cầu Rồng, trung tâm Hải Châu và sân bay quốc tế Đà Nẵng.</p>
<h2>Thương hiệu vận hành</h2>
<p>Nobu Hospitality vận hành khách sạn, nhà hàng Nobu (tầng 42) và dịch vụ cho cư dân. Tầng 18 có hồ bơi vô cực nước ấm. Thiết kế lấy cảm hứng từ quạt giấy Nhật Bản, nội thất phong cách Japandi.</p>
<h2>Pháp lý &amp; tiến độ</h2>
<p>Dự án khởi công Quý 2/2024, Newtecons là nhà thầu thi công; tháng 5/2026 công trình đã thi công tới tầng 8 – 9. Bàn giao dự kiến năm 2027. Về thời hạn sở hữu, các nguồn chưa thống nhất (sở hữu lâu dài cho người Việt hoặc đến năm 2060 theo đất thương mại dịch vụ), người mua nên đối chiếu hợp đồng.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, mặt bằng căn hộ và chính sách bán hàng mới nhất của Nobu Đà Nẵng.</p>',
		'sources' => array(
			'https://vnexpress.net/vcre-cung-nobu-hospitality-kien-tao-bieu-tuong-phong-cach-song-tai-da-nang-4598075.html',
			'https://vnexpress.net/huyen-thoai-hollywood-dua-thuong-hieu-nobu-den-da-nang-4761311.html',
			'https://vneconomy.vn/nobu-danang-san-sang-chao-don-nhung-chu-nhan-tinh-hoa-moi.htm',
			'https://cafeland.vn/du-an/to-hop-can-ho-khach-san-nobu-residences-da-nang-4356.html',
			'https://newtecons.vn/newtecons-va-vcre-hop-tac-chien-luoc-kien-tao-sieu-pham-nobu-da-nang/',
			'https://nobudanang.vn/constructions/cap-nhat-tien-do-xay-dung-thang-05-2026/',
		),
	);

	$projects[] = array(
		'slug'    => 'alize-da-nang',
		'title'   => 'Alizé Đà Nẵng',
		'type'    => 'can-ho-dich-vu',
		'area'    => 'son-tra',
		'excerpt' => 'Alizé Đà Nẵng – tòa căn hộ khách sạn 40 tầng của A&T Group, thiết kế Aedas, tại vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, mặt biển Mỹ Khê (Sơn Trà).',
		'meta'    => array(
			'hh_p_status'      => 'sap-mo-ban',
			'hh_p_developer'   => 'A&T Group (Công ty CP Đầu tư Thương mại Kỹ thuật A&T Việt Nam)',
			'hh_p_designer'    => 'Aedas',
			'hh_p_type'        => 'Căn hộ khách sạn cao cấp ven biển',
			'hh_p_address'     => 'Vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, mặt biển Mỹ Khê, Sơn Trà, Đà Nẵng',
			'hh_p_blocks'      => '1 tòa tháp',
			'hh_p_floors'      => '40 tầng',
			'hh_p_highlights'  => "Mặt tiền biển Mỹ Khê, tại vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt\nTòa tháp 40 tầng do A&T Group hợp tác cùng Aedas thiết kế\nKiến trúc xanh “Wind Garden” đón gió biển, giảm nhiệt\nCăn hộ khách sạn 1 – 3 phòng ngủ view biển, có dòng Sky Villa tầng cao",
			'hh_p_design_desc' => 'Mặt đứng thiết kế theo ý tưởng “Wind Garden” – các tầng vườn xanh đón gió biển, tạo thông gió tự nhiên và giảm nhiệt cho công trình, khác biệt với các khối bê tông dọc trục Võ Nguyên Giáp. Sản phẩm là căn hộ khách sạn 1 – 3 phòng ngủ hướng biển; trang dự án giới thiệu thêm dòng Sky Villa tầng cao có hồ bơi riêng.',
			'hh_p_location_desc' => 'Alizé nằm tại vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, mặt tiền biển Mỹ Khê thuộc Sơn Trà, kết nối nhanh với cầu Rồng, trung tâm Hải Châu và sân bay quốc tế Đà Nẵng.',
			'hh_p_connections' => "1 phút | Bãi biển Mỹ Khê\n5 phút | Cầu Rồng, sông Hàn\n10 phút | Trung tâm Hải Châu\n15 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_out' => "Bãi biển Mỹ Khê, công viên Biển Đông\nPhố ẩm thực, nhà hàng ven biển Võ Nguyên Giáp\nCầu Rồng, trung tâm Hải Châu",
		),
		'content' => '<p><strong>Alizé Đà Nẵng</strong> là dự án căn hộ khách sạn cao cấp do A&amp;T Group (Công ty CP Đầu tư Thương mại Kỹ thuật A&amp;T Việt Nam) phát triển, tọa lạc tại vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, mặt tiền biển Mỹ Khê thuộc Sơn Trà. Công trình là tòa tháp 40 tầng do A&amp;T Group hợp tác cùng đơn vị thiết kế quốc tế Aedas.</p>
<h2>Các loại căn hộ Alizé Đà Nẵng</h2>
<p>Sản phẩm là căn hộ khách sạn 1 – 3 phòng ngủ hướng biển. Trang dự án giới thiệu thêm dòng Sky Villa ở các tầng cao với hồ bơi riêng và hệ thống nhà thông minh. Diện tích, số lượng căn và bảng giá chính thức chưa được công bố rộng rãi trên báo chí.</p>
<h2>Kiến trúc “Wind Garden”</h2>
<p>Điểm nhận diện của Alizé là mặt đứng xanh “Wind Garden”: các tầng vườn đón gió biển, giúp thông gió tự nhiên và giảm nhiệt, tạo khác biệt với các khối nhà bê tông dọc trục Võ Nguyên Giáp.</p>
<h2>Vị trí ven biển Mỹ Khê</h2>
<p>Từ vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, cư dân ra biển Mỹ Khê trong khoảng 1 phút, sang trung tâm Hải Châu qua cầu Rồng và đi sân bay quốc tế Đà Nẵng thuận tiện.</p>
<h2>Chủ đầu tư</h2>
<p>A&amp;T Group thành lập năm 2007, hoạt động trong lĩnh vực bất động sản, thương mại – dịch vụ và quản lý vận hành tòa nhà; các dự án khác gồm A&amp;T Sky Garden, A&amp;T Saigon Riverside. Thời hạn sở hữu, tiến độ và đơn vị vận hành của Alizé cần xác nhận theo hồ sơ pháp lý chủ đầu tư công bố.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để cập nhật thông tin mở bán, mặt bằng và bảng giá Alizé Đà Nẵng.</p>',
		'sources' => array(
			'https://alize-danang.com/wind-garden-kien-truc-xanh-doc-ban-tai-alize-da-nang/',
			'https://vietnammoi.vn/lien-danh-at-peninsula-lam-du-an-nha-o-1200-ty-tai-da-nang-202681714110930.htm',
			'https://cafef.vn/doanh-nghiep-dung-sau-du-an-at-saigon-riverside-co-tiem-luc-ra-sao-188260930091132504.chn',
			'https://sites.google.com/view/alizedanang/home',
		),
	);

	$projects[] = array(
		'slug'    => 'wyndham-soleil-da-nang',
		'title'   => 'Wyndham Soleil Đà Nẵng',
		'type'    => 'can-ho-dich-vu',
		'area'    => 'son-tra',
		'hot'     => true,
		'excerpt' => 'Wyndham Soleil Đà Nẵng – tổ hợp 4 tháp đến 57 tầng tại Phạm Văn Đồng – Võ Nguyên Giáp (Sơn Trà): căn hộ khách sạn 50 năm do Wyndham vận hành, giá từ khoảng 2,95 tỷ.',
		'meta'    => array(
			'hh_p_status'       => 'dang-ban-giao',
			'hh_p_developer'    => 'Công ty CP PPC An Thịnh Đà Nẵng (thành viên PPCAT Việt Nam)',
			'hh_p_manager'      => 'Wyndham Hotel Group (Mỹ); quản lý dự án: Artelia (Pháp)',
			'hh_p_designer'     => 'Aedas',
			'hh_p_type'         => 'Căn hộ khách sạn (condotel), khách sạn 5 sao',
			'hh_p_address'      => '02 Phạm Văn Đồng (giao Võ Nguyên Giáp, Hồ Nghinh), phường Phước Mỹ (cũ), Sơn Trà, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 21.800 m² đất',
			'hh_p_blocks'       => '4 tòa: 1 tòa khách sạn (B), 3 tòa căn hộ khách sạn (A1, A2, D)',
			'hh_p_floors'       => 'Tòa A1, A2 57 tầng; tòa D 50 tầng; tòa khách sạn 45 – 50 tầng (các nguồn khác nhau)',
			'hh_p_units'        => 'Các nguồn khác nhau: khoảng 1.000 căn hộ, hoặc tổng 3.849 căn (3.070 căn hộ và 779 phòng khách sạn); riêng tòa A1 khoảng 1.168 căn',
			'hh_p_unit_area'    => 'Khoảng 27,9 – 165,6 m² (studio đến 3PN)',
			'hh_p_price_m2'     => 'Khoảng 65 – 145 triệu/m² tùy tòa, tầng, view (các nguồn khác nhau, tham khảo)',
			'hh_p_price_from'   => 2950,
			'hh_p_legal'        => 'Đất thương mại dịch vụ; đã có quy hoạch, giấy chứng nhận quyền sử dụng đất và giấy phép xây dựng (theo trang phân phối)',
			'hh_p_ownership'    => 'Căn hộ khách sạn thời hạn 50 năm theo thời hạn sử dụng đất của dự án',
			'hh_p_handover'     => 'Tòa D: đang bàn giao từ 2025 – 2026; tòa A1: dự kiến Quý 4/2027',
			'hh_p_handover_std' => 'Nội thất hoàn thiện theo tiêu chuẩn Wyndham 5 sao',
			'hh_p_zones'        => "Tòa D – The Maris Soleil (Ethereal) | Căn hộ khách sạn | 50 tầng | Đang bàn giao\nTòa A1 – The Grand Soleil (Nimbus) | Căn hộ khách sạn | 57 tầng, khoảng 1.168 căn | Thi công lại từ 9/2025, dự kiến bàn giao Quý 4/2027\nTòa A2 | Căn hộ khách sạn | 57 tầng | –\nTòa khách sạn Wyndham Soleil | Khách sạn 5 sao | 779 phòng | Đi vào hoạt động 6/2025",
			'hh_p_highlights'   => "Ngã ba Phạm Văn Đồng – Võ Nguyên Giáp, đối diện công viên Biển Đông\nTổ hợp 4 tòa tháp, cao nhất 57 tầng (khoảng 199 m)\nThiết kế Aedas với cầu kính trên không nối các tòa\nNhiều hồ bơi vô cực trên cao, hơn 30 tiện ích\nWyndham Hotel Group quản lý vận hành",
			'hh_p_design_desc'  => 'Tổ hợp gồm 3 tòa căn hộ khách sạn và 1 tòa khách sạn, thiết kế bởi Aedas. Các tòa được nối bằng cầu kính trên cao (cầu nối tòa A2 và D ở tầng 23 – 25). Cơ cấu căn: studio 27,88 – 38,15 m², 1PN 54,69 – 95,57 m², 2PN 90,23 – 123,42 m², 3PN 149,79 – 165,55 m².',
			'hh_p_unit_types'   => "Studio | 27,88 – 38,15 m² | – | Khoảng 2,95 – 3,69 tỷ (tham khảo)\nCăn 1PN | 54,69 – 95,57 m² | 1 | Khoảng 4,5 – 5,6 tỷ (tham khảo)\nCăn 2PN | 90,23 – 123,42 m² | 2 | Khoảng 7,2 – 11 tỷ (tham khảo)\nCăn 3PN | 149,79 – 165,55 m² | 3 | Liên hệ",
			'hh_p_location_desc'   => 'Dự án nằm tại giao lộ Phạm Văn Đồng – Võ Nguyên Giáp – Hồ Nghinh, đối diện công viên Biển Đông và bãi biển Phạm Văn Đồng (Mỹ Khê), đầu cầu sông Hàn phía Sơn Trà.',
			'hh_p_connections'     => "1 phút | Bãi biển Phạm Văn Đồng, công viên Biển Đông\n5 phút | Cầu sông Hàn, cầu Rồng\n10 phút | Trung tâm Hải Châu\n15 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in'    => "Khách sạn Wyndham Soleil 5 sao\nHồ bơi vô cực trên cao, pool bar\nCầu kính trên không nối các tòa\nNhà hàng, spa, xông hơi\nKhu thương mại trong tổ hợp",
			'hh_p_amenities_out'   => "Bãi biển Mỹ Khê, công viên Biển Đông\nPhố ẩm thực Phạm Văn Đồng, Hồ Nghinh\nCầu sông Hàn, cầu Rồng\nBán đảo Sơn Trà",
			'hh_p_progress'        => "05/2025 | Bắt đầu giai đoạn bàn giao căn hộ\n06/2025 | Khách sạn Wyndham Soleil đi vào hoạt động\n08/2025 | Tòa D (Ethereal) đạt khoảng 95% khối lượng\n09/2025 | Tòa A1 thi công trở lại\nQuý 2/2026 | Bàn giao tòa D – The Maris Soleil (dự kiến)\nQuý 4/2027 | Bàn giao tòa A1 – The Grand Soleil (dự kiến)",
			'hh_p_rental'          => 'Căn hộ có thể ủy thác cho Wyndham vận hành cho thuê. Các chương trình đã được giới thiệu ở từng giai đoạn gồm cam kết lợi nhuận khoảng 9%/năm trong 5 năm rồi chia lợi nhuận 80/20, hoặc trừ trước 24% lợi nhuận 3 năm vào giá bán rồi chia 75/25 – cần xác nhận chương trình đang áp dụng.',
		),
		'content' => '<p><strong>Wyndham Soleil Đà Nẵng</strong> (còn gọi Soleil Ánh Dương Đà Nẵng) là tổ hợp căn hộ khách sạn và khách sạn 5 sao do Công ty CP PPC An Thịnh Đà Nẵng làm chủ đầu tư, Wyndham Hotel Group quản lý vận hành và Aedas thiết kế. Dự án rộng khoảng 21.800 m² tại 02 Phạm Văn Đồng – Võ Nguyên Giáp (Sơn Trà), gồm 4 tòa tháp: khách sạn và 3 tòa căn hộ khách sạn A1, A2 (57 tầng) và D (50 tầng).</p>
<h2>Các loại căn hộ Wyndham Soleil</h2>
<ul>
<li>Studio 27,88 – 38,15 m², giá tham khảo khoảng 2,95 – 3,69 tỷ.</li>
<li>Căn 1 phòng ngủ 54,69 – 95,57 m², khoảng 4,5 – 5,6 tỷ.</li>
<li>Căn 2 phòng ngủ 90,23 – 123,42 m², khoảng 7,2 – 11 tỷ.</li>
<li>Căn 3 phòng ngủ 149,79 – 165,55 m².</li>
</ul>
<h2>Vị trí đối diện công viên Biển Đông</h2>
<p>Dự án nằm tại giao lộ Phạm Văn Đồng – Võ Nguyên Giáp – Hồ Nghinh, đối diện công viên Biển Đông, gần cầu sông Hàn và phố ẩm thực ven biển Sơn Trà.</p>
<h2>Thương hiệu vận hành</h2>
<p>Khách sạn Wyndham Soleil đi vào hoạt động từ tháng 6/2025. Chủ căn hộ có thể ủy thác cho Wyndham khai thác cho thuê theo chương trình chủ đầu tư công bố ở từng giai đoạn.</p>
<h2>Pháp lý &amp; tiến độ</h2>
<p>Sản phẩm là căn hộ khách sạn trên đất thương mại dịch vụ, thời hạn 50 năm. Dự án bắt đầu bàn giao từ tháng 5/2025; tòa D – The Maris Soleil bàn giao dự kiến Quý 2/2026, tòa A1 – The Grand Soleil thi công lại từ 9/2025, dự kiến bàn giao Quý 4/2027. Tổng số căn được các nguồn công bố khác nhau, cần đối chiếu theo từng tòa.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận giỏ hàng tòa D, tòa A1 và chính sách cho thuê mới nhất của Wyndham Soleil Đà Nẵng.</p>',
		'sources' => array(
			'https://baodautu.vn/emagazine-wyndham-soleil-da-nang---vien-ngoc-bien-dong-cua-ppc-an-thinh-m104326.html',
			'https://cafeland.vn/du-an/khu-phuc-hop-wyndham-soleil-da-nang-1482.html',
			'https://thanhnien.vn/wyndham-soleil-danang-va-cai-bat-tay-tu-3-ong-lon-trong-linh-vuc-dau-tu-1851010146.htm',
			'https://www.skyscrapercenter.com/complex/2902',
			'https://giagocchudautu.com/wyndham-soleil-da-nang/',
		),
	);
	return $projects;
}
