<?php
/**
 * Dữ liệu dự án Đà Nẵng – Quảng Nam (cũ) tổng hợp từ thông tin công khai (10/2026).
 * Dự án có cả căn hộ và nhà phố/biệt thự: 'type' là mảng nhiều loại, chi tiết từng khu ở 'hh_p_zones'.
 *
 * Chỉ ghi các thông tin có nguồn; giá bán để trống (website hiện "Liên hệ").
 * Hãy kiểm tra lại với chủ đầu tư trước khi tư vấn. Nguồn tham khảo lưu ở meta "hh_p_sources".
 *
 * Nhập: Dự án → Nhập dữ liệu Đà Nẵng, hoặc WP-CLI: wp eval 'hh_import_projects();'
 * Chạy lại nhiều lần không bị trùng; ô đã có dữ liệu (do bạn sửa) sẽ không bị ghi đè.
 */

defined( 'ABSPATH' ) || exit;

function hh_project_dataset() {
	// Dự án khai báo ở file riêng (VD data-vinhomes-hai-van-bay.php) được thêm qua bộ lọc này.
	return apply_filters( 'hh_project_dataset', array(

		/* ---------------- Tổ hợp dự án ---------------- */
		array(
			'slug'    => 'hoiana-resort-golf',
			'title'   => 'Hoiana Resort & Golf',
			'type'    => array( 'to-hop', 'biet-thu' ),
			'area'    => 'duy-xuyen',
			'hot'     => true,
			'excerpt' => 'Quần thể nghỉ dưỡng tích hợp gần 1.000 ha tại Nam Hội An, tổng vốn khoảng 4 tỷ USD: sân golf, beach club, khách sạn, căn hộ khách sạn và biệt thự biển.',
			'meta'    => array(
				'hh_p_status'     => 'dang-mo-ban',
				'hh_p_developer'  => 'Công ty TNHH Phát triển Nam Hội An',
				'hh_p_type'       => 'Quần thể nghỉ dưỡng: căn hộ khách sạn, biệt thự biển, biệt thự sân golf',
				'hh_p_address'    => 'Xã Duy Hải, Duy Xuyên (Quảng Nam cũ), Đà Nẵng – cách phố cổ Hội An khoảng 15 phút',
				'hh_p_scale'      => '985,6 ha',
				'hh_p_highlights' => "Quần thể nghỉ dưỡng tích hợp tổng vốn khoảng 4 tỷ USD\nSân golf, beach club, nhà hàng, spa, câu lạc bộ thể thao, trung tâm mua sắm\nSản phẩm sở hữu: căn hộ khách sạn Hoiana Residences, biệt thự Hoiana Beach Villas và Hoiana Shores Golf Villas",
				'hh_p_zones'      => "Hoiana Residences | Căn hộ khách sạn | 2 tòa, 270 căn | Đang mở bán\nHoiana Beach Villas | Biệt thự biển | 36,6 ha, 198 căn | Đang mở bán – bàn giao Quý 1/2028 (dự kiến)\nHoiana Shores Golf Villas | Biệt thự sân golf | 88 căn | Đang mở bán",
			),
			'sources' => array( 'https://cafeland.vn/du-an/khu-phuc-hop-hoiana-1382.html', 'https://batdongsan.com.vn/du-an-khu-nghi-duong-sinh-thai-duy-xuyen-qna/hoiana-resort-golf-pj5415' ),
		),
		/* ---------------- Cao tầng – Căn hộ sở hữu lâu dài ---------------- */
		array(
			'slug'    => 'sun-symphony-residence',
			'title'   => 'Sun Symphony Residence',
			'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
			'remove_types' => array( 'shophouse' ), // Thấp tầng nằm ở phân khu The Sonata.
			'area'    => 'son-tra',
			'hot'     => true,
			'excerpt' => 'Tổ hợp căn hộ, shophouse và biệt thự của Sun Group bên bờ sông Hàn, quy mô 8 ha với 3 tòa căn hộ và 200 sản phẩm thấp tầng.',
			'meta'    => array(
				'hh_p_status'       => 'dang-ban-giao',
				'hh_p_developer'    => 'Tập đoàn Sun Group',
				'hh_p_type'         => 'Căn hộ, shop khối đế, nhà phố, biệt thự',
				'hh_p_address'      => 'Ven sông Hàn, Sơn Trà, Đà Nẵng',
				'hh_p_scale'        => '8 ha',
				'hh_p_blocks'       => '3 tòa (S1, S2, S3)',
				'hh_p_floors'       => '24 – 30 tầng',
				'hh_p_units'        => '1.313 căn hộ, 77 shop khối đế, 200 sản phẩm thấp tầng',
				'hh_p_unit_area'    => '35,8 – 93,1 m² (căn hộ)',
				'hh_p_ownership'    => 'Sở hữu lâu dài',
				'hh_p_handover'     => 'Thấp tầng: Quý 2/2025 · Căn hộ: Quý 1–2/2026 (dự kiến)',
				'hh_p_highlights'   => "Vị trí ven sông Hàn, trung tâm Đà Nẵng\n3 tòa căn hộ S1 (30 tầng), S2 (24 tầng), S3 (30 tầng)\nThấp tầng gồm 180 nhà phố và 20 biệt thự",
				'hh_p_unit_types'   => "Studio | 35,8 m² | 1 | Liên hệ\nCăn 1PN+1 | 49,3 m² | 1 | Liên hệ\nCăn 2PN | 68,8 m² | 2 | Liên hệ\nCăn 2PN+1 | 79,2 m² | 2 | Liên hệ\nCăn 3PN | 93,1 m² | 3 | Liên hệ",
				'hh_p_zones'        => "Khu cao tầng (tòa S1, S2, S3) | Căn hộ, duplex, shop khối đế | 1.313 căn hộ, 77 shop khối đế | Căn hộ bàn giao Quý 1–2/2026 (dự kiến)\nThe Sonata (thấp tầng, 3 ha) | Nhà phố 3 tầng, shophouse 5 tầng, biệt thự | 180 nhà phố, 20 biệt thự | Bàn giao Quý 2/2025 (dự kiến)",
				'hh_p_shop_desc'    => '77 shop khối đế tại chân 3 tòa căn hộ ven sông Hàn.',
				'hh_p_duplex_desc'  => 'Có căn duplex trong rổ hàng mở bán của cụm dự án ven sông Hàn – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://sungroupsr.vn/sun-symphony-residence/', 'https://batdongsan.kiengiang.vn/can-ho-sun-group-da-nang/' ),
		),
		array(
			'slug'    => 'sun-cosmo-residence',
			'title'   => 'Sun Cosmo Residence',
			'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai', 'shophouse' ),
			'area'    => 'ngu-hanh-son',
			'hot'     => true,
			'excerpt' => 'Dự án của Sun Group trên đường Trần Thị Lý, gồm 2 phân khu The Panoma và The Cosmo với căn hộ, shop khối đế, nhà phố và biệt thự.',
			'meta'    => array(
				'hh_p_status'       => 'dang-ban-giao',
				'hh_p_developer'    => 'Tập đoàn Sun Group',
				'hh_p_type'         => 'Căn hộ, duplex, shop khối đế, nhà phố, biệt thự',
				'hh_p_address'      => 'Đường Trần Thị Lý, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'        => '3,5 ha',
				'hh_p_units'        => 'Khoảng 650 căn hộ, 38 shop khối đế, 101 nhà phố, 45 biệt thự',
				'hh_p_ownership'    => 'Sở hữu lâu dài',
				'hh_p_start'        => 'Quý 1/2023',
				'hh_p_handover'     => 'Cuối 2025 – đầu 2026 (dự kiến)',
				'hh_p_highlights'   => "Hai phân khu: The Panoma và The Cosmo\nCăn hộ từ studio đến 3 phòng ngủ và duplex\nNhà phố 6–7 tầng (đất 100–140 m²), biệt thự 3 tầng (đất 200–500 m²)",
				'hh_p_zones'        => "Khu cao tầng | Căn hộ studio – 3PN, duplex, shop khối đế | Khoảng 650 căn hộ, 38 shop | Bàn giao cuối 2025 – đầu 2026 (dự kiến)\nKhu thấp tầng | Nhà phố 6 – 7 tầng (đất 100 – 140 m²), biệt thự 3 tầng (đất 200 – 500 m²) | 101 nhà phố, 45 biệt thự | –",
				'hh_p_shop_desc'    => '38 shop khối đế tại khu cao tầng.',
				'hh_p_duplex_desc'  => 'Có căn duplex trong khu cao tầng – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://vnexpress.net/bat-dong-san/du-an/detail/sun-cosmo-residence-da-nang-527', 'https://batdongsan.kiengiang.vn/can-ho-sun-group-da-nang/' ),
		),
		array(
			'slug'    => 'sun-ponte-residence',
			'title'   => 'Sun Ponte Residence',
			'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
			'remove_types' => array( 'shophouse' ), // Thấp tầng nằm ở phân khu The Rio.
			'area'    => 'son-tra',
			'excerpt' => 'Tòa tháp 26 tầng của Sun Group trên đường Trần Hưng Đạo, gồm căn hộ, penthouse, shophouse cùng khu nhà phố và biệt thự.',
			'meta'    => array(
				'hh_p_status'         => 'dang-mo-ban',
				'hh_p_developer'      => 'Tập đoàn Sun Group',
				'hh_p_type'           => 'Căn hộ, penthouse, shophouse, nhà phố, biệt thự',
				'hh_p_address'        => 'Đường Trần Hưng Đạo, phường An Hải Tây (cũ), Sơn Trà, Đà Nẵng',
				'hh_p_blocks'         => '1 tòa tháp',
				'hh_p_floors'         => '26 tầng nổi, 3 tầng hầm',
				'hh_p_units'          => '495 căn hộ, 7 penthouse, 26 shophouse; 41 nhà phố, 16 biệt thự',
				'hh_p_ownership'      => 'Sở hữu lâu dài',
				'hh_p_handover'       => 'Quý 3/2026 (dự kiến)',
				'hh_p_zones'          => "Tòa tháp 26 tầng | Căn hộ, penthouse, shophouse khối đế | 495 căn hộ, 7 penthouse, 26 shophouse | Bàn giao Quý 3/2026 (dự kiến)\nThe Rio (thấp tầng) | Nhà phố 6,5 tầng, biệt thự đơn lập và song lập | 41 nhà phố, 16 biệt thự | Ra mắt tháng 7/2025",
				'hh_p_shop_desc'      => '26 shophouse tại khối đế tòa tháp.',
				'hh_p_penthouse_desc' => '7 căn penthouse trên các tầng cao của tòa tháp 26 tầng.',
			),
			'sources' => array( 'https://batdongsan.com.vn/du-an-can-ho-chung-cu-son-tra-ddn/sun-ponte-residence-da-nang-pj6035', 'https://estuaryresidental.com/du-an/sun-ponte-residence-da-nang/' ),
		),
		array(
			'slug'    => 'peninsula-da-nang',
			'title'   => 'Peninsula Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'excerpt' => 'Tổ hợp căn hộ cao cấp mặt sông Hàn trên đường Lê Văn Duyệt, khoảng 941 căn hộ trong tòa tháp 30 tầng.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty TNHH Đông Đô Peninsula Đà Nẵng (Tập đoàn Đông Đô)',
				'hh_p_type'      => 'Căn hộ cao cấp',
				'hh_p_address'   => 'Khu A2-1, đường Lê Văn Duyệt, phường Nại Hiên Đông (cũ), Sơn Trà, Đà Nẵng',
				'hh_p_floors'    => '30 tầng, 3 tầng hầm',
				'hh_p_units'     => 'Khoảng 941 căn hộ',
				'hh_p_unit_area' => '46 – 109 m²',
				'hh_p_ownership' => 'Sở hữu lâu dài',
				'hh_p_start'     => 'Quý 2/2024',
			),
			'sources' => array( 'https://thuviennhadat.vn/bat-dong-san/du-an-peninsula-da-nang-da-ban-giao-chua-20575.html', 'https://datxanhmientrung.com/du-an/peninsula-da-nang' ),
		),
		array(
			'slug'    => 'hiyori-garden-tower',
			'title'   => 'Hiyori Garden Tower',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'excerpt' => 'Dự án căn hộ chuẩn Nhật Bản đầu tiên tại Việt Nam của Sun Frontier, đã vận hành ổn định và cư dân đã nhận sổ.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Bất động sản Sun Frontier Đà Nẵng',
				'hh_p_manager'   => 'Sun Frontier Fudousan',
				'hh_p_type'      => 'Căn hộ chuẩn Nhật Bản',
				'hh_p_address'   => 'Sơn Trà, Đà Nẵng',
				'hh_p_ownership' => 'Sở hữu lâu dài',
				'hh_p_legal'     => 'Cư dân đã nhận sổ',
				'hh_p_handover'  => 'Đã bàn giao',
			),
			'sources' => array( 'https://hiyorigardentower.com/en/gioi-thieu/', 'https://batdongsan.com.vn/du-an-can-ho-chung-cu-son-tra-ddn/hiyori-garden-tower-pj2930' ),
		),
		array(
			'slug'    => 'the-ori-garden',
			'title'   => 'The Ori Garden',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'lien-chieu',
			'excerpt' => 'Khu căn hộ nhà ở xã hội kết hợp thương mại tại khu đô thị Bàu Tràm, 10 tòa 21 tầng với hơn 3.300 căn hộ và shophouse.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN)',
				'hh_p_type'      => 'Căn hộ nhà ở xã hội & thương mại, shophouse',
				'hh_p_address'   => 'Khu đô thị xanh Bàu Tràm, Liên Chiểu, Đà Nẵng',
				'hh_p_scale'     => '4,03 ha',
				'hh_p_blocks'    => '10 tòa',
				'hh_p_floors'    => '21 tầng',
				'hh_p_units'     => 'Khoảng 3.358 căn hộ và shophouse',
			),
			'sources' => array( 'https://khudothi.vn/the-ori-garden/', 'https://guland.vn/du-an/the-ori-garden-apartment-tower' ),
		),

		array(
			'slug'    => 'the-legend-da-nang',
			'title'   => 'The Legend Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'hot'     => true,
			'excerpt' => 'Hai tòa tháp 29 tầng ngay chân cầu Rồng, 4 mặt tiền Võ Văn Kiệt – Ngô Quyền – Mai Hắc Đế – Lý Nam Đế, khoảng 800 căn hộ và 444 phòng khách sạn 5 sao.',
			'meta'    => array(
				'hh_p_status'         => 'dang-mo-ban',
				'hh_p_developer'      => 'Công ty TNHH MTV VIPICO',
				'hh_p_manager'        => 'Phát triển: Công ty CP ROX Signature',
				'hh_p_type'           => 'Căn hộ, penthouse, khách sạn 5 sao',
				'hh_p_address'        => 'Đường Võ Văn Kiệt, phường An Hải Tây (cũ), Sơn Trà, Đà Nẵng – chân cầu Rồng',
				'hh_p_scale'          => '11.487 m² đất',
				'hh_p_blocks'         => '2 tòa tháp',
				'hh_p_floors'         => '29 tầng nổi, 3 tầng hầm',
				'hh_p_units'          => 'Khoảng 800 căn hộ, 444 phòng khách sạn 5 sao',
				'hh_p_unit_area'      => '40 – 415 m²',
				'hh_p_highlights'     => "4 mặt tiền, ngay chân cầu Rồng\nCách biển Mỹ Khê khoảng 1 km, sân bay khoảng 3 km\nCăn 1PN, 1PN+, 2PN, 3PN và penthouse",
				'hh_p_penthouse_desc' => 'Có căn penthouse trên các tầng cao – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://thelegendcity.com/', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-legend-city' ),
		),
		array(
			'slug'    => 'times-square-da-nang',
			'title'   => 'Times Square Đà Nẵng',
			'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
			'area'    => 'son-tra',
			'excerpt' => 'Tổ hợp trung tâm thương mại, khách sạn và căn hộ cao cấp mặt tiền biển Mỹ Khê trên đường Võ Nguyên Giáp, quy mô 2,1 ha.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Kim Long Nam Group (Tập đoàn Phương Trang)',
				'hh_p_type'      => 'Căn hộ cao cấp, khách sạn, trung tâm thương mại',
				'hh_p_address'   => 'Đường Võ Nguyên Giáp, Sơn Trà, Đà Nẵng – mặt tiền biển Mỹ Khê',
				'hh_p_scale'     => '2,1 ha',
				'hh_p_blocks'    => '7 tháp cao tầng',
				'hh_p_floors'    => 'CT1, CT2: 50 tầng · CT3: 23 tầng · CT7: 30 tầng',
				'hh_p_units'     => '560 căn hộ (tòa CT3 và CT7)',
				'hh_p_unit_area' => '40 – 230 m²',
				'hh_p_ownership' => 'Sở hữu lâu dài',
				'hh_p_zones'     => "Tòa CT1, CT2 | Tổ hợp cao 50 tầng | – | –\nTòa CT3 | Căn hộ | 23 tầng | Đang mở bán\nTòa CT7 | Căn hộ | 30 tầng | Đang mở bán",
			),
			'sources' => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-da-nang-times-square', 'https://minhtrungland.com/du-an/time-square-da-nang/' ),
		),
		array(
			'slug'    => 'capital-square-da-nang',
			'title'   => 'Capital Square Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'excerpt' => 'Khu căn hộ ven sông Hàn của BRG Group trên đường Trần Hưng Đạo, gồm 2 phân khu Capital Square 2 và Capital Square 3 với 14 tòa, 3.391 căn hộ.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'BRG Group (Mega Assets – Capital Square 2; SIH – Capital Square 3)',
				'hh_p_type'      => 'Căn hộ cao cấp',
				'hh_p_address'   => 'Đường Trần Hưng Đạo, Sơn Trà, Đà Nẵng – ven sông Hàn',
				'hh_p_blocks'    => '14 tòa',
				'hh_p_floors'    => '24 – 29 tầng',
				'hh_p_units'     => '3.391 căn hộ',
				'hh_p_unit_area' => '34,14 – 128,34 m²',
				'hh_p_zones'     => "Capital Square 2 | Căn hộ (CĐT Mega Assets) | Khoảng 31.960 m² đất, 7 tòa 26 – 28 tầng, 1.681 căn | –\nCapital Square 3 | Căn hộ (CĐT SIH) | Khoảng 29.427 m² đất, 7 tòa 24 – 29 tầng, 1.710 căn | –",
				'hh_p_unit_types' => "Căn 1PN | 34,14 – 47,73 m² | 1 | Liên hệ\nCăn 2PN | 67,03 – 93,08 m² | 2 | Liên hệ\nCăn 3PN | 91,49 – 128,34 m² | 3 | Liên hệ",
			),
			'sources' => array( 'https://www.capital-square.vn/', 'https://daongocchienthangreal.vn/quy-mo-du-an-capital-square/' ),
		),
		array(
			'slug'    => 'newtown-diamond-da-nang',
			'title'   => 'Newtown Diamond Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'excerpt' => 'Ba tòa tháp 36 tầng gần biển tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, 1.733 căn hộ 1 – 3 phòng ngủ, sổ hồng sở hữu lâu dài.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty TNHH Phát triển New Town',
				'hh_p_builder'   => 'Công ty CP CONINCO 3C',
				'hh_p_type'      => 'Căn hộ cao cấp ven biển',
				'hh_p_address'   => 'Ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => '1,47 ha',
				'hh_p_blocks'    => '3 tòa',
				'hh_p_floors'    => '36 tầng nổi, 3 tầng hầm',
				'hh_p_units'     => '1.733 căn hộ',
				'hh_p_unit_area' => '34,74 – 131,96 m²',
				'hh_p_ownership' => 'Sở hữu lâu dài (sổ hồng từng căn)',
				'hh_p_handover'  => 'Quý 3/2026 (dự kiến)',
				'hh_p_zones'     => "Tòa The Ruby | Căn hộ | 829 căn | Đã cất nóc 4/2026\nTòa The Sapphire | Căn hộ | 510 căn | Đang xây dựng\nTòa The Diamond | Căn hộ | 394 căn | Đang xây dựng",
			),
			'sources' => array( 'https://cafeland.vn/du-an/du-an-can-ho-newtown-diamond-da-nang-4382.html', 'https://newtowndiamonds.com/vi-tri/' ),
		),
		array(
			'slug'    => 'fpt-plaza-1',
			'title'   => 'FPT Plaza 1',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fpt-city-da-nang',
			'excerpt' => 'Tòa căn hộ đầu tiên trong khu đô thị FPT City Đà Nẵng: 15 tầng, 586 căn hộ 1 – 3 phòng ngủ.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Căn hộ',
				'hh_p_address'   => 'Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => '8.863,9 m² đất',
				'hh_p_floors'    => '15 tầng nổi, 1 tầng hầm',
				'hh_p_units'     => '586 căn hộ',
				'hh_p_unit_area' => '45 – 82 m²',
			),
			'sources' => array( 'https://fptcity.vn/du-an/fpt-plaza-1/', 'https://fptplaza.com/fptplaza1.html' ),
		),
		array(
			'slug'    => 'fpt-plaza-2',
			'title'   => 'FPT Plaza 2',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fpt-city-da-nang',
			'excerpt' => 'Tòa căn hộ 25 tầng ở trung tâm khu đô thị FPT City Đà Nẵng, 700 căn hộ.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Căn hộ',
				'hh_p_address'   => 'Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => '5.865 m² đất',
				'hh_p_floors'    => '25 tầng nổi, 2 tầng hầm',
				'hh_p_units'     => '700 căn hộ',
			),
			'sources' => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-2', 'https://fptplaza.com/' ),
		),
		array(
			'slug'    => 'fpt-plaza-3',
			'title'   => 'FPT Plaza 3',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fpt-city-da-nang',
			'excerpt' => 'Tòa căn hộ 25 tầng với 837 căn hộ trong khu đô thị FPT City Đà Nẵng.',
			'meta'    => array(
				'hh_p_status'    => 'dang-ban-giao',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Căn hộ',
				'hh_p_address'   => 'Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_floors'    => '25 tầng nổi, 2 tầng hầm',
				'hh_p_units'     => '837 căn hộ',
				'hh_p_handover'  => 'Quý 1/2026 (dự kiến)',
			),
			'sources' => array( 'https://fptplaza3.vn/', 'https://tgdland.com/project/chung-cu-fpt-plaza-3-da-nang/' ),
		),
		array(
			'slug'    => 'fpt-plaza-4',
			'title'   => 'FPT Plaza 4',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fpt-city-da-nang',
			'hot'     => true,
			'excerpt' => 'Tòa căn hộ mới nhất của FPT City Đà Nẵng: 20 tầng, khoảng 1.400 căn hộ 1 – 3 phòng ngủ, khởi công 3/2025.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Căn hộ',
				'hh_p_address'   => 'Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_floors'    => '20 tầng nổi, 3 tầng hầm',
				'hh_p_units'     => 'Khoảng 1.395 – 1.473 căn hộ (theo các nguồn)',
				'hh_p_start'     => '19/03/2025',
				'hh_p_handover'  => 'Quý 2/2027 (dự kiến)',
				'hh_p_highlights' => "Tổng vốn đầu tư khoảng 2.790 tỷ đồng\nCăn hộ 1 – 3 phòng ngủ trong khu đô thị FPT City",
			),
			'sources' => array( 'https://www.xn--cnhfptplaza4-ynb8408h.vn/tien-do-xay-dung', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-4' ),
		),

		array(
			'slug'    => 'fpt-plaza-5',
			'title'   => 'FPT Plaza 5',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'fpt-city-da-nang',
			'excerpt' => 'Tòa căn hộ tiếp theo của FPT City Đà Nẵng: 25 tầng, hơn 832 căn hộ, dự kiến mở bán năm 2026.',
			'meta'    => array(
				'hh_p_status'    => 'sap-mo-ban',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Căn hộ',
				'hh_p_address'   => 'Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_floors'    => '25 tầng nổi, 2 tầng hầm',
				'hh_p_units'     => 'Hơn 832 căn hộ',
				'hh_p_start'     => 'Đang thi công phần móng',
				'hh_p_handover'  => 'Dự kiến mở bán năm 2026',
			),
			'sources' => array( 'https://fpt-plaza5.com/', 'https://nhadatfptdanang.com/can-ho-fpt-plaza-5/' ),
		),
		array(
			'slug'    => 'the-sonata-sun-symphony',
			'title'   => 'The Sonata – Sun Symphony Residence',
			'type'    => 'shophouse',
			'area'    => 'son-tra',
			'parent'  => 'sun-symphony-residence',
			'excerpt' => 'Phân khu thấp tầng 3 ha của Sun Symphony Residence bên sông Hàn: 180 nhà phố, shophouse và 20 biệt thự, cảm hứng kiến trúc Hội An đương đại.',
			'meta'    => array(
				'hh_p_status'     => 'dang-ban-giao',
				'hh_p_developer'  => 'Tập đoàn Sun Group',
				'hh_p_designer'   => 'Sun Group & Design Lab',
				'hh_p_type'       => 'Nhà phố, shophouse, biệt thự',
				'hh_p_address'    => 'Ven sông Hàn, Sơn Trà, Đà Nẵng (thuộc Sun Symphony Residence)',
				'hh_p_scale'      => '3 ha',
				'hh_p_units'      => '180 nhà phố (104 nhà phố 3 tầng, 76 shophouse 5 tầng), 20 biệt thự',
				'hh_p_ownership'  => 'Sở hữu lâu dài',
				'hh_p_handover'   => 'Quý 2/2025 (dự kiến)',
				'hh_p_unit_types' => "Nhà phố 3 tầng | 263 – 463 m² | – | Liên hệ\nShophouse 5 tầng | 425 – 800 m² | – | Liên hệ\nBiệt thự 3 tầng | 540 – 608 m² | – | Liên hệ",
				'hh_p_highlights' => "Mặt tiền sông Hàn, ngay trung tâm Đà Nẵng\nKiến trúc lấy cảm hứng từ Hội An đương đại\nTiện ích chung: công viên trung tâm 5.000 m², 3 bến du thuyền, đường dạo ven sông, hồ bơi vô cực",
			),
			'sources' => array( 'https://duandanang.com/the-sonata-da-nang-khu-biet-thu-shophouse-cao-cap-thuoc-du-an-sun-symphony/', 'https://vnexpress.net/tiem-nang-thuong-mai-tai-thuong-cang-sun-symphony-residence-da-nang-4776875.html' ),
		),
		array(
			'slug'    => 'the-rio-sun-ponte',
			'title'   => 'The Rio – Sun Ponte Residence',
			'type'    => 'shophouse',
			'area'    => 'son-tra',
			'parent'  => 'sun-ponte-residence',
			'hot'     => true,
			'excerpt' => 'Phân khu thấp tầng giới hạn của Sun Ponte Residence cạnh cầu Rồng: 41 nhà phố và 16 biệt thự kiến trúc châu Âu do Aedas thiết kế, ra mắt tháng 7/2025.',
			'meta'    => array(
				'hh_p_status'     => 'dang-mo-ban',
				'hh_p_developer'  => 'Tập đoàn Sun Group (Sun Property)',
				'hh_p_designer'   => 'Aedas',
				'hh_p_type'       => 'Nhà phố, biệt thự',
				'hh_p_address'    => 'Cạnh cầu Rồng, ven sông Hàn, Sơn Trà, Đà Nẵng (thuộc Sun Ponte Residence)',
				'hh_p_units'      => '41 nhà phố, 16 biệt thự',
				'hh_p_ownership'  => 'Sở hữu lâu dài',
				'hh_p_start'      => 'Ra mắt tháng 7/2025',
				'hh_p_unit_types' => "Nhà phố 6,5 tầng | 135 – 245,8 m² | – | Liên hệ\nBiệt thự đơn lập, song lập | 180 – 369,3 m² | – | Liên hệ",
				'hh_p_highlights' => "Vị trí cạnh cầu Rồng, ven sông Hàn\nSố lượng giới hạn, kiến trúc châu Âu\nDùng chung tiện ích Sun Ponte: hồ bơi vô cực, công viên ven sông, khu vui chơi trẻ em",
			),
			'sources' => array( 'https://vietnambiz.vn/sun-group-ra-mat-phan-khu-thap-tang-cao-cap-the-rio-can-ke-cau-rong-da-nang-20257411933324.htm', 'https://congly.com.vn/the-rio-phan-khu-thap-tang-gioi-han-cua-sun-group-canh-cau-rong-da-nang/' ),
		),

		/* ---------------- Cao tầng – Căn hộ dịch vụ ---------------- */
		array(
			'slug'    => 'hoiana-residences',
			'title'   => 'Hoiana Residences',
			'type'    => 'can-ho-dich-vu',
			'area'    => 'duy-xuyen',
			'parent'  => 'hoiana-resort-golf',
			'excerpt' => 'Hai tòa căn hộ khách sạn trong quần thể Hoiana Resort & Golf (985,6 ha), vận hành bởi New World (Rosewood Hotel Group).',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty Phát triển Nam Hội An (VinaCapital, VinaLiving)',
				'hh_p_manager'   => 'New World – Rosewood Hotel Group',
				'hh_p_type'      => 'Căn hộ khách sạn (condotel)',
				'hh_p_address'   => 'Thôn Tây Sơn Tây, xã Duy Hải, Duy Xuyên (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'     => 'Thuộc quần thể Hoiana 985,6 ha',
				'hh_p_blocks'    => '2 tòa',
				'hh_p_units'     => '270 căn hộ',
				'hh_p_unit_types' => "Studio | – | – | Liên hệ\nCăn 1PN | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
				'hh_p_highlights' => "Nằm trong quần thể Hoiana Resort & Golf\nNhiều căn hướng biển\nTiện ích: sân golf, beach club, spa, câu lạc bộ thể thao, trung tâm mua sắm",
			),
			'sources' => array( 'https://rever.vn/du-an/hoiana-residences', 'https://blog.rever.vn/thong-tin-hoiana-residences' ),
		),

		/* ---------------- Thấp tầng – Biệt thự nghỉ dưỡng ---------------- */
		array(
			'slug'    => 'casamia-balanca-hoi-an',
			'fix_meta'    => array( 'hh_p_units' => '297 biệt thự, 74 shophouse, 3 tòa khách sạn' ),
			'fix_excerpt' => 'Khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh, Hội An: 297 biệt thự, 74 shophouse, 3 khách sạn, ra mắt tháng 6/2025.',
			'title'   => 'Casamia Balanca Hội An',
			'type'    => array( 'to-hop', 'biet-thu' ),
			'area'    => 'hoi-an',
			'hot'     => true,
			'excerpt' => 'Khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh, Hội An: 363 sản phẩm thấp tầng gồm 173 biệt thự đơn lập, 116 song lập, 74 shophouse, ra mắt tháng 6/2025.',
			'meta'    => array(
				'hh_p_status'     => 'dang-mo-ban',
				'hh_p_developer'  => 'Tập đoàn Đạt Phương',
				'hh_p_designer'   => 'VTN Architects / ENCITY',
				'hh_p_type'       => 'Biệt thự sinh thái, shophouse',
				'hh_p_address'    => 'Xã Cẩm Thanh, Hội An (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'      => '31,1 ha',
				'hh_p_units'      => '363 sản phẩm thấp tầng: 173 biệt thự đơn lập, 116 biệt thự song lập, 74 shophouse',
				'hh_p_legal'      => 'Sổ đỏ',
				'hh_p_ownership'  => 'Sở hữu lâu dài',
				'hh_p_start'      => 'Ra mắt tháng 6/2025',
				'hh_p_highlights' => "Biệt thự view sông, có bến du thuyền riêng\nTiếp giáp trục đường 38 m kết nối Đà Nẵng – Hội An – Chu Lai\nPháp lý sở hữu lâu dài",
			),
			'sources' => array( 'https://casamiabalanca.com/', 'https://maichiland.com.vn/du-an/casamia-balanca-hoi-an-biet-thu-sinh-thai-dang-cap-ben-song-co-co' ),
		),
		array(
			'slug'    => 'casamia-calm-hoi-an',
			'title'   => 'Casamia Calm Hội An',
			'type'    => 'biet-thu',
			'area'    => 'hoi-an',
			'excerpt' => 'Quần thể 112 biệt thự sinh thái bên sông Cổ Cò do Võ Trọng Nghĩa Architects thiết kế, sở hữu lâu dài.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đạt Phương Hội An',
				'hh_p_designer'  => 'Võ Trọng Nghĩa Architects',
				'hh_p_builder'   => 'Công ty CP Xây dựng Tân Việt Á',
				'hh_p_type'      => 'Biệt thự sinh thái',
				'hh_p_address'   => 'Xã Cẩm Hà, Hội An (Quảng Nam cũ), Đà Nẵng – bên sông Cổ Cò',
				'hh_p_scale'     => '6,4 ha',
				'hh_p_units'     => '112 biệt thự',
				'hh_p_ownership' => 'Sở hữu lâu dài (sổ hồng)',
			),
			'sources' => array( 'https://cafeland.vn/du-an/casamia-calm-hoi-an-du-an-khu-biet-thu-tai-quang-nam-3942.html', 'https://toprealty.vn/du-an/casamia-calm-hoi-an/' ),
		),
		array(
			'slug'    => 'casamia-hoi-an',
			'title'   => 'Casamia Hội An',
			'type'    => 'biet-thu',
			'area'    => 'hoi-an',
			'excerpt' => 'Quần thể biệt thự sinh thái 15,6 ha tại Cẩm Thanh, trong khu dự trữ sinh quyển UNESCO cạnh phố cổ Hội An.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đạt Phương Hội An',
				'hh_p_type'      => 'Shophouse, biệt thự song lập, đơn lập, biệt thự VIP',
				'hh_p_address'   => 'Võng Nhi, xã Cẩm Thanh, Hội An (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'     => '15,6 ha (đất ở 6 ha)',
				'hh_p_units'     => '216 căn',
				'hh_p_unit_area' => '161 – 608 m²',
				'hh_p_highlights' => "Mô hình biệt thự sinh thái \"2 trong 1\": để ở và nghỉ dưỡng\nNằm trong khu dự trữ sinh quyển thế giới Cù Lao Chàm – Hội An",
			),
			'sources' => array( 'https://rever.vn/du-an/casamia-hoi-an', 'https://khudothi.vn/casamia-hoi-an/' ),
		),
		array(
			'slug'    => 'hoiana-beach-villas',
			'title'   => 'Hoiana Beach Villas',
			'type'    => 'biet-thu',
			'area'    => 'duy-xuyen',
			'parent'  => 'hoiana-resort-golf',
			'hot'     => true,
			'excerpt' => '198 biệt thự biển trên 36,6 ha trong quần thể Hoiana Resort & Golf, 3 – 9 phòng ngủ, cách phố cổ Hội An khoảng 15 phút.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Hoiana (Công ty Phát triển Nam Hội An)',
				'hh_p_type'      => 'Biệt thự biển',
				'hh_p_address'   => 'Xã Duy Hải, Duy Xuyên (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'     => '36,6 ha',
				'hh_p_units'     => '198 biệt thự',
				'hh_p_unit_area' => 'Đất khoảng 350 – 3.132 m²',
				'hh_p_handover'  => 'Quý 1/2028 (dự kiến)',
				'hh_p_unit_types' => "Shore Villa | Đất 350 m² | 3 | Liên hệ\nVeranda Mansion | Đất 3.132 m² | 9 | Liên hệ",
			),
			'sources' => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-hoiana-beach-villas', 'https://thanhdoluxuryhomes.com/hoiana-beach-villas/' ),
		),
		array(
			'slug'    => 'hoiana-shores-golf-villas',
			'title'   => 'Hoiana Shores Golf Villas',
			'type'    => 'biet-thu',
			'area'    => 'duy-xuyen',
			'parent'  => 'hoiana-resort-golf',
			'excerpt' => '88 biệt thự sân golf 3 – 5 phòng ngủ trong quần thể Hoiana, đất 710 – 1.500 m², sổ đỏ từng căn.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Hoiana (Công ty Phát triển Nam Hội An)',
				'hh_p_type'      => 'Biệt thự sân golf',
				'hh_p_address'   => 'Quần thể Hoiana, Duy Xuyên (Quảng Nam cũ), Đà Nẵng',
				'hh_p_units'     => '88 biệt thự',
				'hh_p_unit_area' => 'Đất 710 – 1.500 m²',
				'hh_p_legal'     => 'Sổ đỏ từng căn',
				'hh_p_ownership' => 'Sở hữu lâu dài',
			),
			'sources' => array( 'https://www.duanhoiana.com/', 'https://lienkebietthu.com.vn/hoiana-shores-golf-villas/' ),
		),
		array(
			'slug'    => 'the-ocean-villas-da-nang',
			'title'   => 'The Ocean Villas Đà Nẵng',
			'type'    => 'biet-thu',
			'area'    => 'ngu-hanh-son',
			'excerpt' => '114 biệt thự đơn lập ven biển 2 – 8 phòng ngủ có hồ bơi riêng, trong khu nghỉ dưỡng Danang Beach Resort hơn 260 ha.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'VinaCapital',
				'hh_p_type'      => 'Biệt thự biển đơn lập',
				'hh_p_address'   => 'Đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => 'Thuộc Danang Beach Resort hơn 260 ha',
				'hh_p_units'     => '114 biệt thự đơn lập',
				'hh_p_highlights' => "Biệt thự 2 – 8 phòng ngủ, hồ bơi và sân vườn riêng\nNằm sát biển Non Nước",
			),
			'sources' => array( 'https://cvr.com.vn/vi/project/the-ocean-villas-resort-da-nang', 'https://homedy.com/the-ocean-villas-da-nang-pj27479375' ),
		),

		/* ---------------- Thấp tầng – Shophouse / nhà phố ---------------- */
		array(
			'slug'    => 'nam-hoi-an-city',
			'title'   => 'Nam Hội An City',
			'type'    => array( 'to-hop', 'shophouse' ),
			'area'    => 'duy-xuyen',
			'hot'     => true,
			'excerpt' => 'Khu phố thương mại ven sông Thu Bồn phía nam cầu Cửa Đại: 420 nhà phố 3 tầng kiến trúc phố cổ, cách phố cổ Hội An khoảng 5 km.',
			'meta'    => array(
				'hh_p_status'     => 'dang-mo-ban',
				'hh_p_developer'  => 'Công ty CP Đầu tư FVG (Fivi Group)',
				'hh_p_type'       => 'Nhà phố thương mại, shophouse',
				'hh_p_address'    => 'Xã Duy Nghĩa, Duy Xuyên (Quảng Nam cũ), Đà Nẵng – ven sông Thu Bồn',
				'hh_p_scale'      => '19,34 ha',
				'hh_p_units'      => '420 nhà phố 3 tầng, 30 căn thương mại dịch vụ, 1 tòa căn hộ 30 tầng, khách sạn',
				'hh_p_highlights' => "Ven sông Thu Bồn, phía nam cầu Cửa Đại\nCách phố cổ Hội An khoảng 5 km\nKiến trúc lấy cảm hứng từ phố cổ Hội An",
			),
			'sources' => array( 'https://www.fvg.com.vn/linh-vuc-hoat-dong/bat-dong-san/du-an-nam-hoi-an-city-/du-an-nam-hoi-an-city-.html', 'https://vnrep.com/nam-hoi-an-city/' ),
		),

		/* ---------------- Thấp tầng – Đất nền ---------------- */
		array(
			'slug'    => 'fpt-city-da-nang',
			'title'   => 'FPT City Đà Nẵng',
			'type'    => array( 'to-hop', 'dat-nen' ),
			'area'    => 'ngu-hanh-son',
			'hot'     => true,
			'excerpt' => 'Khu đô thị xanh thông minh hơn 181 ha của FPT, hơn 3 km mặt sông Cổ Cò, cách biển khoảng 1 km.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Đất nền, shophouse, căn hộ, biệt thự',
				'hh_p_address'   => 'Đường Võ Chí Công, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => 'Hơn 181 ha (hơn 100 ha công viên, cây xanh, mặt nước)',
				'hh_p_zones'     => "Căn hộ FPT Plaza 1 – 5 | Căn hộ chung cư | 5 tòa (xem các dự án thành phần) | Plaza 1–2 đã bàn giao, Plaza 3–4 đang triển khai, Plaza 5 sắp mở bán\nĐất nền, shophouse, biệt thự | Thấp tầng | – | –",
				'hh_p_highlights' => "Hơn 3 km mặt sông Cổ Cò\nCách biển khoảng 1 km, trên trục Đà Nẵng – Hội An\nĐịnh hướng khu đô thị xanh thông minh kiểu mẫu",
			),
			'sources' => array( 'https://fptcity.vn/', 'https://cafeland.vn/du-an/fpt-city-da-nang-khu-do-thi-sinh-thai-kieu-mau-421.html' ),
		),
		array(
			'slug'    => 'dragon-smart-city',
			'title'   => 'Dragon Smart City',
			'type'    => array( 'to-hop', 'dat-nen' ),
			'area'    => 'lien-chieu',
			'excerpt' => 'Khu đô thị 78 ha tại Liên Chiểu với 2.544 lô đất nền, nhà phố, biệt thự và căn hộ.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN); phát triển: Đất Xanh Miền Trung',
				'hh_p_type'      => 'Đất nền, nhà phố, biệt thự, căn hộ',
				'hh_p_address'   => 'Liên Chiểu, Đà Nẵng',
				'hh_p_scale'     => '78 ha',
				'hh_p_units'     => '2.544 lô',
			),
			'sources' => array( 'https://cafeland.vn/du-an/du-an-khu-do-thi-dragon-smart-city-1579.html' ),
		),
		array(
			'slug'    => 'lakeside-palace',
			'title'   => 'Lakeside Palace',
			'type'    => 'dat-nen',
			'area'    => 'lien-chieu',
			'excerpt' => 'Khu đô thị 46 ha gồm đất nền và nhà phố thương mại thông minh, hợp tác phát triển cùng Đất Xanh Miền Trung.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN); hợp tác: Đất Xanh Miền Trung',
				'hh_p_type'      => 'Đất nền, shophouse',
				'hh_p_address'   => 'Liên Chiểu, Đà Nẵng',
				'hh_p_scale'     => '46 ha',
			),
			'sources' => array( 'https://batdongsan01.com.vn/shop/du-an-lakeside-palace-da-nang/' ),
		),
		array(
			'slug'    => 'one-world-regency',
			'title'   => 'One World Regency',
			'type'    => 'dat-nen',
			'area'    => 'dien-ban',
			'excerpt' => 'Khu đô thị 22 ha giáp ranh Đà Nẵng – Hội An, gần sông Cổ Cò, thuộc khu đô thị mới Điện Nam – Điện Ngọc.',
			'meta'    => array(
				'hh_p_status'    => 'da-ban-giao',
				'hh_p_developer' => 'Đất Quảng Land Group; phát triển: Đất Xanh Miền Trung',
				'hh_p_type'      => 'Đất nền',
				'hh_p_address'   => 'Khu đô thị mới Điện Nam – Điện Ngọc, Điện Bàn (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'     => '22 ha',
			),
			'sources' => array( 'https://homedy.com/one-world-regency-pj40102508', 'https://resviet.vn/one-world-regency/' ),
		),
	) );
}

/**
 * Create / update the projects. Returns [created, updated].
 */
function hh_import_projects() {
	if ( function_exists( 'hh_seed_terms' ) ) {
		hh_seed_terms();
	}
	$created = 0;
	$updated = 0;
	// Chi tiết bổ sung (vị trí, liên kết vùng, tiện ích, tiến độ…) ở data-du-an-chi-tiet.php.
	$details = function_exists( 'hh_project_enrichment' ) ? hh_project_enrichment() : array();
	foreach ( hh_project_dataset() as $p ) {
		if ( isset( $details[ $p['slug'] ] ) ) {
			$p['meta']   += $details[ $p['slug'] ]['meta'] ?? array();
			$p['sources'] = array_values( array_unique( array_merge( $p['sources'] ?? array(), $details[ $p['slug'] ]['sources'] ?? array() ) ) );
		}
		$existing = get_page_by_path( $p['slug'], OBJECT, 'du-an' );
		if ( $existing ) {
			$id = $existing->ID;
			++$updated;
		} else {
			$id = wp_insert_post(
				array(
					'post_type'    => 'du-an',
					'post_status'  => 'publish',
					'post_name'    => $p['slug'],
					'post_title'   => $p['title'],
					'post_excerpt' => $p['excerpt'],
					'post_content' => $p['content'] ?? '',
					'menu_order'   => (int) ( $p['order'] ?? 0 ),
				)
			);
			if ( ! $id || is_wp_error( $id ) ) {
				continue;
			}
			++$created;
		}

		// Loại dự án: thêm các loại còn thiếu (dự án có cả căn hộ và nhà phố được gắn 2 loại).
		foreach ( (array) $p['type'] as $slug ) {
			$type = get_term_by( 'slug', $slug, 'loai-du-an' );
			if ( $type && ! has_term( (int) $type->term_id, 'loai-du-an', $id ) ) {
				wp_set_object_terms( $id, (int) $type->term_id, 'loai-du-an', true );
			}
		}
		if ( ! has_term( '', 'khu-vuc', $id ) ) {
			$area = get_term_by( 'slug', $p['area'], 'khu-vuc' );
			if ( $area ) {
				wp_set_object_terms( $id, (int) $area->term_id, 'khu-vuc' );
			}
		}

		// Bỏ loại cũ một lần duy nhất (không ảnh hưởng nếu sau này bạn tự gắn lại).
		if ( ! empty( $p['remove_types'] ) && ! get_post_meta( $id, '_hh_types_cleaned', true ) ) {
			foreach ( $p['remove_types'] as $slug ) {
				$type = get_term_by( 'slug', $slug, 'loai-du-an' );
				if ( $type ) {
					wp_remove_object_terms( $id, (int) $type->term_id, 'loai-du-an' );
				}
			}
			update_post_meta( $id, '_hh_types_cleaned', '1' );
		}

		// Sửa mô tả ngắn cũ đã nhập sai (chỉ khi bạn chưa tự sửa).
		if ( ! empty( $p['fix_excerpt'] ) && $p['fix_excerpt'] === get_post_field( 'post_excerpt', $id ) ) {
			wp_update_post( array( 'ID' => $id, 'post_excerpt' => $p['excerpt'] ) );
		}

		// Thứ tự hiển thị (VD phân khu Khu 1 → Khu 4) cho dự án đã có.
		if ( ! empty( $p['order'] ) && 0 === (int) get_post_field( 'menu_order', $id ) ) {
			wp_update_post( array( 'ID' => $id, 'menu_order' => (int) $p['order'] ) );
		}

		// Bài giới thiệu chi tiết: chỉ điền khi dự án chưa có nội dung, hoặc nội dung vẫn là bản cũ do web nhập (fix_content) – không đè bài bạn đã tự sửa.
		$current = get_post_field( 'post_content', $id );
		$same    = static fn( $a, $b ) => preg_replace( '/\s+/', '', wp_unslash( (string) $a ) ) === preg_replace( '/\s+/', '', (string) $b );
		if ( ! empty( $p['content'] ) && ( '' === trim( $current ) || ( ! empty( $p['fix_content'] ) && array_filter( (array) $p['fix_content'], static fn( $old ) => $same( $current, $old ) ) ) ) ) {
			wp_update_post( array( 'ID' => $id, 'post_content' => $p['content'] ) );
		}

		$meta = $p['meta'];
		$meta['hh_p_name'] = $meta['hh_p_name'] ?? $p['title'];
		if ( ! empty( $p['hot'] ) ) {
			$meta['hh_p_featured'] = '1';
		}
		// Sửa dữ liệu cũ đã nhập sai: chỉ thay khi giá trị hiện tại vẫn đúng bằng bản cũ (không đè chỗ bạn đã tự sửa).
		foreach ( $p['fix_meta'] ?? array() as $key => $old ) {
			if ( isset( $meta[ $key ] ) && (string) get_post_meta( $id, $key, true ) === $old ) {
				update_post_meta( $id, $key, $meta[ $key ] );
			}
		}
		foreach ( $meta as $key => $value ) {
			if ( '' === (string) get_post_meta( $id, $key, true ) ) {
				update_post_meta( $id, $key, $value );
			}
		}
		update_post_meta( $id, 'hh_p_sources', implode( "\n", $p['sources'] ) );
	}
	// Lượt 2: nối dự án thành phần / phân khu với tổ hợp (sau khi mọi dự án đã được tạo).
	foreach ( hh_project_dataset() as $p ) {
		if ( empty( $p['parent'] ) ) {
			continue;
		}
		$child  = get_page_by_path( $p['slug'], OBJECT, 'du-an' );
		$parent = get_page_by_path( $p['parent'], OBJECT, 'du-an' );
		if ( $child && $parent && ! get_post_meta( $child->ID, 'hh_p_parent', true ) ) {
			update_post_meta( $child->ID, 'hh_p_parent', $parent->ID );
		}
	}
	// Ảnh từ link (Google Drive) của các dự án có ô "Link ảnh".
	if ( function_exists( 'hh_img_links_import' ) && current_user_can( 'upload_files' ) ) {
		foreach ( hh_project_dataset() as $p ) {
			$post = ! empty( $p['meta']['hh_p_image_links'] ) ? get_page_by_path( $p['slug'], OBJECT, 'du-an' ) : null;
			if ( $post ) {
				hh_img_links_import( $post->ID );
			}
		}
	}
	$news     = function_exists( 'hh_import_news' ) ? hh_import_news() : 0;
	$listings = function_exists( 'hh_import_listings' ) ? hh_import_listings() : 0;
	return array( $created, $updated, $news, $listings );
}

/* -------------------------------------------------------------------------
 * Admin page: Dự án → Nhập dữ liệu Đà Nẵng
 * ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'hh_import_menu' );
function hh_import_menu() {
	add_submenu_page( 'edit.php?post_type=du-an', 'Nhập dữ liệu dự án Đà Nẵng', 'Nhập dữ liệu Đà Nẵng', 'manage_options', 'hh-import-du-an', 'hh_import_page' );
}

function hh_import_page() {
	$result = null;
	if ( isset( $_POST['hh_import'] ) && check_admin_referer( 'hh_import_du_an' ) ) {
		$result = hh_import_projects();
	}
	$published = null;
	if ( isset( $_POST['hh_publish_week'] ) && check_admin_referer( 'hh_import_du_an' ) && function_exists( 'hh_news_publish_now' ) ) {
		$published = hh_news_publish_now( absint( $_POST['hh_publish_week'] ) );
	}
	?>
	<div class="wrap">
		<h1>Nhập dữ liệu dự án Đà Nẵng – Quảng Nam</h1>
		<?php if ( $result ) : ?>
			<div class="notice notice-success"><p>Đã tạo <?php echo (int) $result[0]; ?> dự án mới, cập nhật <?php echo (int) $result[1]; ?> dự án có sẵn, đăng <?php echo (int) ( $result[2] ?? 0 ); ?> bài tin tức mới, <?php echo (int) ( $result[3] ?? 0 ); ?> tin mua bán / cho thuê mới.</p></div>
		<?php endif; ?>
		<p>Tạo sẵn <?php echo count( hh_project_dataset() ); ?> dự án (căn hộ, căn hộ dịch vụ, biệt thự nghỉ dưỡng, shophouse, đất nền) với thông tin công khai: chủ đầu tư, vị trí, quy mô, tình trạng. <strong>Giá bán để trống</strong> – website hiển thị "Liên hệ".</p>
		<p>Chạy lại nhiều lần không tạo trùng. Ô bạn đã tự nhập sẽ không bị ghi đè. Sau khi nhập, hãy thêm <strong>ảnh đại diện</strong> cho từng dự án và kiểm tra lại số liệu với chủ đầu tư.</p>
		<form method="post">
			<?php wp_nonce_field( 'hh_import_du_an' ); ?>
			<p><button class="button button-primary" name="hh_import" value="1">Nhập / cập nhật dữ liệu</button></p>
		</form>
		<?php if ( null !== $published ) : ?>
			<div class="notice notice-success"><p>Đã đăng ngay <?php echo (int) $published; ?> bài viết.</p></div>
		<?php endif; ?>
		<?php $plan = function_exists( 'hh_news_schedule_summary' ) ? hh_news_schedule_summary() : array(); ?>
		<?php if ( $plan ) : ?>
			<h2>Bài viết đã lên lịch (kế hoạch nội dung)</h2>
			<p>Bài tự đăng 1 bài/ngày lúc 8:00. Muốn đăng sớm cả tuần nào thì bấm nút của tuần đó.</p>
			<form method="post">
				<?php wp_nonce_field( 'hh_import_du_an' ); ?>
				<table class="widefat striped" style="max-width:760px">
					<thead><tr><th>Tuần</th><th>Bài</th><th>Ngày đăng dự kiến</th><th></th></tr></thead>
					<tbody>
						<?php foreach ( $plan as $week => $ids ) : ?>
							<tr>
								<td><?php echo (int) $week; ?></td>
								<td><?php echo esc_html( implode( ' · ', array_map( 'get_the_title', $ids ) ) ); ?></td>
								<td><?php echo esc_html( get_the_date( 'd/m', $ids[0] ) . ' – ' . get_the_date( 'd/m', end( $ids ) ) ); ?></td>
								<td><button class="button" name="hh_publish_week" value="<?php echo (int) $week; ?>">Đăng ngay tuần <?php echo (int) $week; ?></button></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p><button class="button" name="hh_publish_week" value="0" onclick="return confirm('Đăng ngay tất cả bài đã lên lịch?')">Đăng ngay tất cả</button></p>
			</form>
		<?php endif; ?>
		<h2>Danh sách</h2>
		<ul style="list-style:disc;padding-left:20px">
			<?php foreach ( hh_project_dataset() as $p ) : ?>
				<li><?php echo esc_html( $p['title'] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
