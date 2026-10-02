<?php
/**
 * Dữ liệu dự án Đà Nẵng – Quảng Nam (cũ) tổng hợp từ thông tin công khai (10/2026).
 *
 * Chỉ ghi các thông tin có nguồn; giá bán để trống (website hiện "Liên hệ").
 * Hãy kiểm tra lại với chủ đầu tư trước khi tư vấn. Nguồn tham khảo lưu ở meta "hh_p_sources".
 *
 * Nhập: Dự án → Nhập dữ liệu Đà Nẵng, hoặc WP-CLI: wp eval 'hh_import_projects();'
 * Chạy lại nhiều lần không bị trùng; ô đã có dữ liệu (do bạn sửa) sẽ không bị ghi đè.
 */

defined( 'ABSPATH' ) || exit;

function hh_project_dataset() {
	return array(
		/* ---------------- Cao tầng – Căn hộ sở hữu lâu dài ---------------- */
		array(
			'slug'    => 'sun-symphony-residence',
			'title'   => 'Sun Symphony Residence',
			'type'    => 'can-ho-so-huu-lau-dai',
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
				'hh_p_shop_desc'    => '77 shop khối đế tại chân 3 tòa căn hộ ven sông Hàn.',
				'hh_p_duplex_desc'  => 'Có căn duplex trong rổ hàng mở bán của cụm dự án ven sông Hàn – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://sungroupsr.vn/sun-symphony-residence/', 'https://batdongsan.kiengiang.vn/can-ho-sun-group-da-nang/' ),
		),
		array(
			'slug'    => 'sun-cosmo-residence',
			'title'   => 'Sun Cosmo Residence',
			'type'    => 'can-ho-so-huu-lau-dai',
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
				'hh_p_shop_desc'    => '38 shop khối đế tại khu cao tầng.',
				'hh_p_duplex_desc'  => 'Có căn duplex trong khu cao tầng – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://vnexpress.net/bat-dong-san/du-an/detail/sun-cosmo-residence-da-nang-527', 'https://batdongsan.kiengiang.vn/can-ho-sun-group-da-nang/' ),
		),
		array(
			'slug'    => 'sun-ponte-residence',
			'title'   => 'Sun Ponte Residence',
			'type'    => 'can-ho-so-huu-lau-dai',
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

		/* ---------------- Cao tầng – Căn hộ dịch vụ ---------------- */
		array(
			'slug'    => 'hoiana-residences',
			'title'   => 'Hoiana Residences',
			'type'    => 'can-ho-dich-vu',
			'area'    => 'duy-xuyen',
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
			'title'   => 'Casamia Balanca Hội An',
			'type'    => 'biet-thu',
			'area'    => 'hoi-an',
			'hot'     => true,
			'excerpt' => 'Khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh, Hội An: 297 biệt thự, 74 shophouse, 3 khách sạn, ra mắt tháng 6/2025.',
			'meta'    => array(
				'hh_p_status'     => 'dang-mo-ban',
				'hh_p_developer'  => 'Tập đoàn Đạt Phương',
				'hh_p_designer'   => 'VTN Architects / ENCITY',
				'hh_p_type'       => 'Biệt thự sinh thái, shophouse',
				'hh_p_address'    => 'Xã Cẩm Thanh, Hội An (Quảng Nam cũ), Đà Nẵng',
				'hh_p_scale'      => '31,1 ha',
				'hh_p_units'      => '297 biệt thự, 74 shophouse, 3 tòa khách sạn',
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
			'type'    => 'shophouse',
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
			'type'    => 'dat-nen',
			'area'    => 'ngu-hanh-son',
			'hot'     => true,
			'excerpt' => 'Khu đô thị xanh thông minh hơn 181 ha của FPT, hơn 3 km mặt sông Cổ Cò, cách biển khoảng 1 km.',
			'meta'    => array(
				'hh_p_status'    => 'dang-mo-ban',
				'hh_p_developer' => 'Công ty CP Đô thị FPT Đà Nẵng',
				'hh_p_type'      => 'Đất nền, shophouse, căn hộ, biệt thự',
				'hh_p_address'   => 'Đường Võ Chí Công, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'     => 'Hơn 181 ha (hơn 100 ha công viên, cây xanh, mặt nước)',
				'hh_p_highlights' => "Hơn 3 km mặt sông Cổ Cò\nCách biển khoảng 1 km, trên trục Đà Nẵng – Hội An\nĐịnh hướng khu đô thị xanh thông minh kiểu mẫu",
			),
			'sources' => array( 'https://fptcity.vn/', 'https://cafeland.vn/du-an/fpt-city-da-nang-khu-do-thi-sinh-thai-kieu-mau-421.html' ),
		),
		array(
			'slug'    => 'dragon-smart-city',
			'title'   => 'Dragon Smart City',
			'type'    => 'dat-nen',
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
	);
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
	foreach ( hh_project_dataset() as $p ) {
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
				)
			);
			if ( ! $id || is_wp_error( $id ) ) {
				continue;
			}
			++$created;
		}

		if ( ! has_term( '', 'loai-du-an', $id ) ) {
			$type = get_term_by( 'slug', $p['type'], 'loai-du-an' );
			if ( $type ) {
				wp_set_object_terms( $id, (int) $type->term_id, 'loai-du-an' );
			}
		}
		if ( ! has_term( '', 'khu-vuc', $id ) ) {
			$area = get_term_by( 'slug', $p['area'], 'khu-vuc' );
			if ( $area ) {
				wp_set_object_terms( $id, (int) $area->term_id, 'khu-vuc' );
			}
		}

		$meta = $p['meta'];
		$meta['hh_p_name'] = $meta['hh_p_name'] ?? $p['title'];
		if ( ! empty( $p['hot'] ) ) {
			$meta['hh_p_featured'] = '1';
		}
		foreach ( $meta as $key => $value ) {
			if ( '' === (string) get_post_meta( $id, $key, true ) ) {
				update_post_meta( $id, $key, $value );
			}
		}
		update_post_meta( $id, 'hh_p_sources', implode( "\n", $p['sources'] ) );
	}
	return array( $created, $updated );
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
	?>
	<div class="wrap">
		<h1>Nhập dữ liệu dự án Đà Nẵng – Quảng Nam</h1>
		<?php if ( $result ) : ?>
			<div class="notice notice-success"><p>Đã tạo <?php echo (int) $result[0]; ?> dự án mới, cập nhật <?php echo (int) $result[1]; ?> dự án có sẵn.</p></div>
		<?php endif; ?>
		<p>Tạo sẵn <?php echo count( hh_project_dataset() ); ?> dự án (căn hộ, căn hộ dịch vụ, biệt thự nghỉ dưỡng, shophouse, đất nền) với thông tin công khai: chủ đầu tư, vị trí, quy mô, tình trạng. <strong>Giá bán để trống</strong> – website hiển thị "Liên hệ".</p>
		<p>Chạy lại nhiều lần không tạo trùng. Ô bạn đã tự nhập sẽ không bị ghi đè. Sau khi nhập, hãy thêm <strong>ảnh đại diện</strong> cho từng dự án và kiểm tra lại số liệu với chủ đầu tư.</p>
		<form method="post">
			<?php wp_nonce_field( 'hh_import_du_an' ); ?>
			<p><button class="button button-primary" name="hh_import" value="1">Nhập / cập nhật dữ liệu</button></p>
		</form>
		<h2>Danh sách</h2>
		<ul style="list-style:disc;padding-left:20px">
			<?php foreach ( hh_project_dataset() as $p ) : ?>
				<li><?php echo esc_html( $p['title'] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
