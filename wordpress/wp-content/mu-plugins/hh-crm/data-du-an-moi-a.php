<?php
/**
 * Dự án mới (nhóm A): The Camellia Sơn Trà (MBLand), HIYORI Aqua Tower (Sun Frontier) và Peninsula Private (Kreves Halla Land, Hòa Cường).
 * Tổng hợp báo chí (CafeLand, CafeF, Thanh Niên, Báo Đà Nẵng, Báo Đầu tư) và trang phân phối (10/2026). Giá là mức chào bán tham khảo.
 * Peninsula Private khác chủ đầu tư và khác vị trí với Peninsula Đà Nẵng (Đông Đô, Sơn Trà) nên không gán parent.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_du_an_moi_a', 20 );
function hh_dataset_du_an_moi_a( $projects ) {
	$projects[] = array(
		'slug'    => 'the-camellia-son-tra',
		'title'   => 'The Camellia Sơn Trà',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'son-tra',
		'hot'     => true,
		'excerpt' => 'The Camellia Sơn Trà – dự án đầu tiên của MBLand tại Đà Nẵng, góc Lê Văn Lương – Lê Đức Thọ: tòa 25 tầng, 469 căn hộ studio đến duplex và 10 shop khối đế, sở hữu lâu dài, dự kiến bàn giao quý 1/2028.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty TNHH Địa ốc Thành Lâm (chủ đầu tư); MBLand phát triển dự án',
			'hh_p_builder'      => 'Tập đoàn Xây dựng Delta (tổng thầu)',
			'hh_p_type'         => 'Căn hộ studio, 1PN+, 2PN, 3PN, duplex và shop khối đế',
			'hh_p_address'      => 'Ngã tư Lê Văn Lương – Lê Đức Thọ, phường Sơn Trà, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 4.299,9 m² đất, tổng sàn xây dựng khoảng 30.159 m²',
			'hh_p_density'      => 'Khoảng 48,2%',
			'hh_p_blocks'       => '1 tòa',
			'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm',
			'hh_p_units'        => '469 căn hộ và 10 shop khối đế (tổng 479 sản phẩm)',
			'hh_p_unit_area'    => '27,8 – 103,6 m² (duplex đến khoảng 226,7 m²)',
			'hh_p_price_from'   => 1980,
			'hh_p_ownership'    => 'Sở hữu lâu dài',
			'hh_p_handover'     => 'Dự kiến quý 1/2028',
			'hh_p_handover_std' => 'Hoàn thiện nội thất liền tường',
			'hh_p_highlights'   => "Dự án đầu tiên của MBLand tại Đà Nẵng, tổng thầu Delta\nGóc hai mặt tiền Lê Văn Lương – Lê Đức Thọ, chân bán đảo Sơn Trà\n469 căn hộ sở hữu lâu dài, đa dạng từ studio đến duplex\nCông viên trên cao với 6 khu vườn chủ đề, hồ bơi trong nhà\nHỗ trợ vay đến 70% giá trị căn hộ",
			'hh_p_design_desc'  => 'Tòa tháp 25 tầng với tầng trệt bố trí 10 shop thương mại, các tầng trên là căn hộ. Cơ cấu sản phẩm: studio 27,8 – 31,4 m², 1PN 46,8 – 47,3 m², 2PN 57,4 – 72,7 m², 3PN 83,9 – 103,6 m² và căn duplex 103,6 – 226,7 m².',
			'hh_p_unit_types'   => "Studio | 27,8 – 31,4 m² | – | Khoảng 1,98 – 2,64 tỷ (tham khảo)\nCăn 1PN / 1,5PN | 46,8 – 47,3 m² | 1 | Khoảng 3,28 – 4,11 tỷ (tham khảo)\nCăn 2PN | 57,4 – 72,7 m² | 2 | Khoảng 3,9 – 5,99 tỷ tùy view (tham khảo)\nCăn 3PN | 83,9 – 103,6 m² | 3 | Liên hệ",
			'hh_p_shop_desc'    => '10 shop thương mại tại tầng trệt (khối đế) của tòa tháp, mặt tiền góc Lê Văn Lương – Lê Đức Thọ.',
			'hh_p_duplex_desc'  => 'Căn duplex thông tầng là dòng sản phẩm diện tích lớn nhất của dự án, khoảng 103,6 – 226,7 m².',
			'hh_p_duplex_table' => 'Căn duplex | 103,6 – 226,7 m² | – | Liên hệ',
			'hh_p_location_desc' => 'The Camellia nằm ở góc ngã tư Lê Văn Lương – Lê Đức Thọ, phường Sơn Trà (Thọ Quang cũ), dưới chân bán đảo Sơn Trà, thuận tiện ra biển và các tuyến chính của quận Sơn Trà cũ.',
			'hh_p_amenities_in' => "Hồ bơi trong nhà và hồ bơi trẻ em\nPhòng gym, yoga, spa\nCông viên trên cao với 6 khu vườn chủ đề\nSảnh lounge, phòng sinh hoạt cộng đồng\nNhà trẻ nội khu\nKhu BBQ",
			'hh_p_progress'     => "15/7/2026 | Hoàn thành tầng hầm, thi công khối đế\n26/7/2026 | MBLand ra mắt dự án tại Đà Nẵng\nQuý 1/2028 | Dự kiến bàn giao",
			'hh_p_policy'       => 'Hỗ trợ vay đến 70% giá trị căn hộ, tối đa 18 tháng không trả gốc và lãi hoặc ân hạn nợ gốc dài hạn (các nguồn nêu 3 – 5 năm); chiết khấu khoảng 2 – 13% tùy phương thức thanh toán; miễn phí quản lý 12 tháng. Chính sách thay đổi theo từng đợt.',
		),
		'content' => '<p><strong>The Camellia Sơn Trà</strong> là dự án căn hộ đầu tiên của MBLand tại Đà Nẵng, do Công ty TNHH Địa ốc Thành Lâm làm chủ đầu tư, Tập đoàn Xây dựng Delta làm tổng thầu. Dự án nằm ở góc ngã tư Lê Văn Lương – Lê Đức Thọ (phường Sơn Trà), gồm 1 tòa 25 tầng với 469 căn hộ sở hữu lâu dài và 10 shop khối đế trên khu đất khoảng 4.300 m².</p>
<h2>Các loại căn hộ The Camellia</h2>
<ul>
<li>Studio 27,8 – 31,4 m², giá tham khảo khoảng 1,98 – 2,64 tỷ.</li>
<li>Căn 1PN / 1,5PN 46,8 – 47,3 m², khoảng 3,28 – 4,11 tỷ.</li>
<li>Căn 2PN 57,4 – 72,7 m², khoảng 3,9 – 5,99 tỷ tùy view nội khu, mặt đường hay góc nhìn bán đảo Sơn Trà.</li>
<li>Căn 3PN 83,9 – 103,6 m² và căn duplex 103,6 – 226,7 m².</li>
</ul>
<h2>Tiện ích và vị trí</h2>
<p>Dự án có hồ bơi trong nhà, phòng gym – yoga – spa, công viên trên cao với 6 khu vườn chủ đề, nhà trẻ và khu BBQ. Vị trí dưới chân bán đảo Sơn Trà phù hợp người mua để ở lẫn cho thuê.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Căn hộ sở hữu lâu dài, bàn giao hoàn thiện nội thất liền tường. Theo báo chí, dự án đã hoàn thành tầng hầm vào giữa tháng 7/2026, ra mắt thị trường cuối tháng 7/2026 và dự kiến bàn giao quý 1/2028. Khách mua được hỗ trợ vay đến 70% giá trị căn hộ.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, giỏ hàng và chính sách mới nhất của The Camellia Sơn Trà.</p>',
		'sources' => array(
			'https://cafeland.vn/du-an/the-camellia-son-tra-du-an-can-ho-tai-da-nang-5777.html',
			'https://cafeland.vn/tin-tuc/mbland-ra-mat-the-camellia-son-tra-da-nang-kien-tao-chuan-song-ben-ban-dao-son-tra-153676.html',
			'https://baodanang.vn/mbland-lua-chon-son-tra-phat-trien-du-an-the-camellia-son-tra-da-nang-3352846.html',
			'https://cafef.vn/son-tra-xac-lap-vi-the-truc-an-cu-va-tich-san-moi-tai-da-nang-188260829104316245.chn',
			'https://vietnamnet.vn/phat-trien-khong-gian-song-son-tra-dau-an-cua-nhung-nha-kien-tao-ben-vung-2556587.html',
		),
	);

	$projects[] = array(
		'slug'    => 'hiyori-aqua-tower',
		'title'   => 'HIYORI Aqua Tower',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'son-tra',
		'hot'     => true,
		'excerpt' => 'HIYORI Aqua Tower – căn hộ chuẩn Nhật của Sun Frontier tại góc Lê Đức Thọ – Ngô Cao Lãng (Sơn Trà, Đà Nẵng): tòa 25 tầng, 202 căn 1 – 3PN sở hữu lâu dài, cất nóc 9/2026, dự kiến bàn giao quý 2/2027.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty TNHH Aqua Tower; Công ty TNHH MTV Sun Frontier Đà Nẵng phát triển dự án',
			'hh_p_builder'      => 'Công ty TNHH Kỹ thuật Xây dựng DINCO',
			'hh_p_designer'     => 'ASAI KEN Architecture Research (giám sát thiết kế); Artelia Việt Nam giám sát thi công',
			'hh_p_type'         => 'Căn hộ chuẩn Nhật Bản, thương mại tầng trệt',
			'hh_p_address'      => 'Lô 03, khu A2-1, góc Lê Đức Thọ – Ngô Cao Lãng, phường Thọ Quang (cũ), Sơn Trà, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 1.850 m² đất, tổng sàn sử dụng khoảng 24.933 m²',
			'hh_p_blocks'       => '1 tòa',
			'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm',
			'hh_p_units'        => '202 căn hộ',
			'hh_p_unit_area'    => 'Khoảng 45 – 161 m² (các nguồn khác nêu 38 – 163,2 m² hoặc 48 – 170 m²)',
			'hh_p_price_m2'     => 'Khoảng 55 – 75 triệu/m², căn đặc biệt cao hơn (tham khảo)',
			'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam), sổ hồng từng căn',
			'hh_p_start'        => '10/9/2024',
			'hh_p_handover'     => 'Dự kiến quý 2/2027',
			'hh_p_handover_std' => 'Hoàn thiện nội thất liền tường',
			'hh_p_highlights'   => "Dự án thứ hai của Sun Frontier (Nhật Bản) tại Sơn Trà sau Hiyori Garden Tower\nThiết kế tối giản Nhật Bản, kỹ sư Nhật giám sát chất lượng\nChỉ 202 căn, phần lớn là căn 2 phòng ngủ\nCách biển khoảng 5 phút đi bộ\nCất nóc tháng 9/2026, dự kiến bàn giao quý 2/2027",
			'hh_p_design_desc'  => 'Tòa tháp 25 tầng, 2 tầng hầm. Tầng trệt bố trí không gian thương mại (siêu thị mini, cà phê); các tầng trên là căn hộ. Cơ cấu: 22 căn 1PN, 176 căn 2PN và 3 căn 3PN.',
			'hh_p_unit_types'   => "Căn 1PN (22 căn) | Khoảng 45 m² | 1 | Liên hệ\nCăn 2PN (176 căn) | Khoảng 58 – 74 m² | 2 | Khoảng 4,5 tỷ cho căn 68 m² (tham khảo)\nCăn 3PN (3 căn) | Khoảng 161 m² | 3 | Liên hệ",
			'hh_p_shop_desc'    => 'Không gian thương mại tại tầng 1 của tòa tháp, phục vụ dịch vụ thiết yếu như siêu thị mini, cà phê cho cư dân.',
			'hh_p_location_desc' => 'HIYORI Aqua Tower nằm tại lô 03 khu A2-1, góc đường Lê Đức Thọ – Ngô Cao Lãng, phường Thọ Quang (cũ), Sơn Trà – trên bán đảo Sơn Trà, đi bộ khoảng 5 phút ra biển, có hướng nhìn biển Mỹ Khê, cầu Rồng và khu vực bắn pháo hoa quốc tế.',
			'hh_p_connections'  => "5 phút đi bộ | Bãi biển",
			'hh_p_amenities_in' => "Hồ bơi\nPhòng gym, spa\nVườn trên cao, vườn thiền\nNhà trẻ, khu vui chơi trẻ em\nSiêu thị mini, khu thương mại\nPhòng sinh hoạt cộng đồng, lounge",
			'hh_p_progress'     => "10/9/2024 | Khởi công\n9/2026 | Thi công tầng 25, cất nóc\nQuý 2/2027 | Dự kiến bàn giao",
		),
		'content' => '<p><strong>HIYORI Aqua Tower</strong> (Chung cư Tháp Đại Dương) là dự án căn hộ phong cách Nhật Bản tại góc Lê Đức Thọ – Ngô Cao Lãng, Sơn Trà, do Công ty TNHH Aqua Tower làm chủ đầu tư và Sun Frontier Đà Nẵng phát triển – cùng nhà phát triển với <a href="/du-an/hiyori-garden-tower/">Hiyori Garden Tower</a>. Tòa nhà cao 25 tầng, 2 tầng hầm với 202 căn hộ sở hữu lâu dài; DINCO thi công, Artelia Việt Nam giám sát.</p>
<h2>Các loại căn hộ HIYORI Aqua Tower</h2>
<ul>
<li>22 căn 1 phòng ngủ, khoảng 45 m².</li>
<li>176 căn 2 phòng ngủ, khoảng 58 – 74 m²; giá tham khảo khoảng 4,5 tỷ cho căn 68 m².</li>
<li>3 căn 3 phòng ngủ, khoảng 161 m².</li>
</ul>
<p>Mặt bằng giá chào bán phổ biến khoảng 55 – 75 triệu/m² tùy tầng và view. Các trang phân phối nêu dải diện tích khác nhau (38 – 163,2 m² hoặc 48 – 170 m²), cần đối chiếu mặt bằng chính thức.</p>
<h2>Vì sao HIYORI Aqua Tower được quan tâm</h2>
<p>Sun Frontier đã bàn giao và vận hành Hiyori Garden Tower tại Đà Nẵng. Dự án mới áp dụng thiết kế tối giản kiểu Nhật, hơn 18 tiện ích như hồ bơi, gym, spa, vườn thiền, nhà trẻ và thương mại tầng trệt; vị trí đi bộ khoảng 5 phút ra biển.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Dự án khởi công ngày 10/9/2024, thi công tới tầng 25 và cất nóc vào tháng 9/2026, dự kiến bàn giao quý 2/2027 với nội thất liền tường. Người Việt Nam được sở hữu lâu dài, cấp sổ hồng từng căn.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận giỏ hàng, bảng giá và chính sách mới nhất của HIYORI Aqua Tower.</p>',
		'sources' => array(
			'https://thanhnien.vn/hiyori-aqua-tower-can-ho-phong-cach-nhat-ban-tai-ban-dao-son-tra-185260214160905684.htm',
			'https://www.baodanang.vn/kinhte/202409/khoi-cong-du-an-chung-cu-thap-dai-duong-hiyori-aqua-tower-tai-quan-son-tra-3985693/index.htm',
			'https://cafeland.vn/du-an/hiyori-aqua-tower-du-an-can-ho-tai-da-nang-5401.html',
			'https://www.hiyori-aquatower.com/',
			'https://duanbdsdanang.com/du-an/hiyori-aqua-tower-da-nang/',
		),
	);

	$projects[] = array(
		'slug'    => 'peninsula-private-da-nang',
		'title'   => 'Peninsula Private Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Peninsula Private Đà Nẵng – tòa căn hộ cao khoảng 150 m tại Vũ Duy Thanh – Doãn Khuê, phường Hòa Cường: 3 hầm, 40 tầng nổi, 624 căn studio đến 3PN, giá từ khoảng 65 triệu/m², Đất Xanh Miền Trung phân phối.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty TNHH Kreves Halla Land (chủ đầu tư); Công ty TNHH Peninsula Private Đà Nẵng phát triển dự án',
			'hh_p_type'         => 'Căn hộ cao cấp, shophouse khối đế, Sky Villa',
			'hh_p_address'      => 'Mặt tiền Vũ Duy Thanh – Doãn Khuê – Nại Nam, phường Hòa Cường (Hải Châu cũ), Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 4.585,86 m² đất, diện tích xây dựng khoảng 1.843,9 m²',
			'hh_p_density'      => 'Khoảng 40%',
			'hh_p_blocks'       => '1 tòa, cao khoảng 149,9 m',
			'hh_p_floors'       => '40 tầng nổi (39 tầng và 1 tầng penthouse), 3 tầng hầm',
			'hh_p_units'        => '624 căn',
			'hh_p_unit_area'    => '40 – 134,3 m²',
			'hh_p_price_m2'     => 'Khoảng 65 triệu/m², chưa VAT và phí bảo trì (tham khảo)',
			'hh_p_ownership'    => 'Sở hữu lâu dài, sổ hồng từng căn',
			'hh_p_start'        => '2/8/2025',
			'hh_p_handover_std' => 'Hoàn thiện nội thất liền tường cao cấp',
			'hh_p_zones'        => "Tầng 1 – 3 | Shophouse, thương mại dịch vụ | Khối đế | –\nTầng 4 | Kỹ thuật, văn phòng | – | –\nTầng 5 | Hồ bơi, gym, yoga, spa & xông hơi | Tiện ích sức khỏe | –\nTầng 6 – 38 | Căn hộ | Tầng 21 có thư viện, khu vui chơi trong nhà, vườn thông trên cao | –\nTầng 40 | Hồ bơi vô cực, Sky Bar & Cigar Lounge, Sky Garden | Tiện ích trên mái | –",
			'hh_p_highlights'   => "Tòa tháp cao khoảng 149,9 m, 40 tầng nổi tại phường Hòa Cường\nGần LOTTE Mart, view sông Hàn\nMật độ xây dựng khoảng 40%\nKhởi công 8/2025, Đất Xanh Miền Trung phân phối chính thức từ 7/2026\nHồ bơi vô cực và Sky Bar trên tầng thượng",
			'hh_p_design_desc'  => 'Khối đế tầng 1 – 3 là shophouse và thương mại dịch vụ, tầng 5 là tổ hợp chăm sóc sức khỏe, căn hộ bố trí từ tầng 6 đến tầng 38, tầng 40 là tầng tiện ích trên cao. Sản phẩm gồm Deluxe Studio, Premier Suite 1PN, Executive Residence 2PN, Grand Residence 3PN và Sky Villa.',
			'hh_p_unit_types'   => "Deluxe Studio | 40 – 40,4 m² | – | Từ khoảng 65 triệu/m² (tham khảo)\nPremier Suite 1PN | 52,3 – 54,6 m² | 1 | Liên hệ\nExecutive Residence 2PN | 81,3 – 86,7 m² | 2 | Liên hệ\nGrand Residence 3PN | 134,3 m² | 3 | Liên hệ",
			'hh_p_shop_desc'    => 'Khối đế tầng 1 – 3 bố trí shophouse và không gian thương mại dịch vụ, phục vụ cư dân và khu vực Hòa Cường.',
			'hh_p_penthouse_desc' => 'Tòa tháp có 1 tầng penthouse và dòng căn Sky Villa trên các tầng cao; diện tích và giá chưa được công bố rộng rãi – liên hệ để nhận thông tin.',
			'hh_p_location_desc' => 'Peninsula Private nằm tại mặt tiền Vũ Duy Thanh – Doãn Khuê – Nại Nam, phường Hòa Cường, cạnh LOTTE Mart và khu Đà Nẵng Downtown, hướng nhìn sông Hàn. Dự án khác vị trí và khác chủ đầu tư với Peninsula Đà Nẵng trên đường Lê Văn Duyệt (Sơn Trà).',
			'hh_p_connections'  => "Liền kề | LOTTE Mart\n5 – 12 phút | Biển Mỹ Khê\n5 – 12 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in' => "Hồ bơi, gym & fitness, yoga, spa & xông hơi (tầng 5)\nThư viện, khu vui chơi trong nhà, vườn thông trên cao (tầng 21)\nHồ bơi vô cực, Sky Bar & Cigar Lounge, Sky Garden (tầng 40)\nShophouse và thương mại dịch vụ khối đế",
			'hh_p_amenities_out' => "LOTTE Mart Đà Nẵng\nKhu Đà Nẵng Downtown\nSông Hàn\nBiển Mỹ Khê",
			'hh_p_progress'     => "2/8/2025 | Khởi công, động thổ\n7/2026 | Thi công phần móng\n9/7/2026 | Ký kết phân phối với Đất Xanh Miền Trung\n8/2026 | Ra quân bán hàng, nhận booking",
			'hh_p_policy'       => 'Theo trang phân phối: booking 50 triệu áp dụng cho 158 suất đầu tiên từ 01/8/2026, miễn phí quản lý 2 năm; ngân hàng hỗ trợ vay đến 70% giá trị căn hộ, có gói 0% lãi suất trong 24 tháng. Chính sách thay đổi theo từng đợt.',
		),
		'content' => '<p><strong>Peninsula Private Đà Nẵng</strong> là tòa căn hộ cao cấp tại mặt tiền Vũ Duy Thanh – Doãn Khuê, phường Hòa Cường, do Công ty TNHH Kreves Halla Land làm chủ đầu tư và Công ty TNHH Peninsula Private Đà Nẵng phát triển. Tòa tháp cao khoảng 149,9 m gồm 3 tầng hầm, 40 tầng nổi với 624 căn trên khu đất khoảng 4.586 m², mật độ xây dựng khoảng 40%. Dự án khác chủ đầu tư và vị trí với Peninsula Đà Nẵng (Lê Văn Duyệt, Sơn Trà).</p>
<h2>Các loại căn hộ Peninsula Private</h2>
<ul>
<li>Deluxe Studio 40 – 40,4 m².</li>
<li>Premier Suite 1PN 52,3 – 54,6 m².</li>
<li>Executive Residence 2PN 81,3 – 86,7 m².</li>
<li>Grand Residence 3PN 134,3 m², cùng dòng Sky Villa và tầng penthouse.</li>
</ul>
<p>Giá chào bán tham khảo từ khoảng 65 triệu/m² (chưa VAT, phí bảo trì), bàn giao nội thất liền tường. Khối đế tầng 1 – 3 có shophouse và thương mại dịch vụ.</p>
<h2>Vị trí & tiện ích</h2>
<p>Dự án cạnh LOTTE Mart và khu Đà Nẵng Downtown, hướng nhìn sông Hàn, kết nối nhanh tới biển Mỹ Khê và sân bay. Tiện ích phân tầng: tầng 5 có hồ bơi, gym, yoga, spa; tầng 21 có thư viện và vườn trên cao; tầng 40 có hồ bơi vô cực, Sky Bar và Sky Garden.</p>
<h2>Pháp lý & tiến độ</h2>
<p>Dự án khởi công ngày 2/8/2025; đến tháng 7/2026 đang thi công phần móng. Ngày 9/7/2026, Đất Xanh Miền Trung trở thành đơn vị phân phối chính thức. Căn hộ sở hữu lâu dài; thời điểm bàn giao chưa được công bố chính thức.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận mặt bằng, bảng giá và chính sách mới nhất của Peninsula Private.</p>',
		'sources' => array(
			'https://thanhnien.vn/peninsula-private-toa-can-ho-trung-tam-da-nang-do-dat-xanh-mien-trung-phan-phoi-185260710153206899.htm',
			'https://cafef.vn/dat-xanh-mien-trung-ra-quan-du-an-can-ho-peninsula-private-tai-da-nang-188260803155151719.chn',
			'https://baodautu.vn/chinh-thuc-phan-phoi-du-an-peninsula-private-dat-xanh-mien-trung-nang-tam-uy-tin-d640003.html',
			'https://cafeland.vn/du-an/peninsula-private-du-an-can-ho-tai-da-nang-5743.html',
			'https://peninsula.vn/peninsula-private/',
		),
	);

	return $projects;
}
