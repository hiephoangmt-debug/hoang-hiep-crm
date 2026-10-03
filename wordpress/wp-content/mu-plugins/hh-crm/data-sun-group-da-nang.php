<?php
/**
 * Dự án Sun Group tại Đà Nẵng mở bán 2025 – 2026: Sun NeO City (Hòa Xuân), Sun Riverpolis (Hòa Quý),
 * Đà Nẵng Downtown và Sun Galaxy Complex. Tổng hợp từ báo chí và trang phân phối (10/2026).
 * Số căn, bàn giao lấy theo nguồn công khai – nguồn có chỗ chưa thống nhất, cần đối chiếu chủ đầu tư.
 *
 * Slug "cora-tower" trùng dự án CORA TOWER đã có trên web: trình nhập chỉ điền ô trống, gắn vào tổ hợp.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_sun_group_da_nang' );
function hh_dataset_sun_group_da_nang( $projects ) {
	$sun = 'Tập đoàn Sun Group (Sun Property phát triển)';

	/* ---------------- Sun NeO City – Hòa Xuân ---------------- */
	$projects[] = array(
		'slug'    => 'sun-neo-city',
		'title'   => 'Sun NeO City Hòa Xuân',
		'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
		'area'    => 'cam-le',
		'hot'     => true,
		'excerpt' => 'Khu đô thị của Sun Group tại Hòa Xuân, phía Nam Đà Nẵng – cùng Sun Riverpolis tạo hệ sinh thái hơn 1.000 ha. Gồm các tòa căn hộ Cora Tower, Spana Tower, S-Light Tower và phân khu Sunneva Island.',
		'meta'    => array(
			'hh_p_status'        => 'dang-mo-ban',
			'hh_p_developer'     => $sun,
			'hh_p_type'          => 'Căn hộ, shophouse khối đế, nhà phố, biệt thự ven sông',
			'hh_p_address'       => 'Phường Hòa Xuân (cũ), phía Nam Đà Nẵng – ven sông Cẩm Lệ, chân cầu Hòa Xuân',
			'hh_p_scale'         => 'Thuộc hệ sinh thái hơn 1.000 ha cùng Sun Riverpolis',
			'hh_p_ownership'     => 'Căn hộ sở hữu lâu dài',
			'hh_p_highlights'    => "Khu đô thị quy hoạch đồng bộ phía Nam Đà Nẵng, ven sông, nhìn về pháo hoa DIFF\nCác tòa căn hộ đang mở bán: Cora Tower, Spana Tower, S-Light Tower\nKết nối nhanh trung tâm qua cầu Hòa Xuân, Nguyễn Phước Lan, đường 29/3",
			'hh_p_zones'         => "Cora Tower | Căn hộ, shophouse khối đế | Giao Nguyễn Phước Lan – 29/3 | Đang mở bán\nSpana Tower (A1.3, A1.4) | Căn hộ, penthouse, shophouse khối đế | 2 tòa 22 tầng, khoảng 1.281 căn | Đang mở bán\nS-Light Tower | Căn hộ, penthouse | 2 tòa 22 tầng, gần 800 căn | Ra mắt 6/2026\nSunneva Island | Thấp tầng ven sông | – | Theo đợt mở bán",
			'hh_p_location_desc' => 'Sun NeO City nằm ở phía Nam Đà Nẵng, khu vực Hòa Xuân ven sông Cẩm Lệ, nơi giao nhau của sông Hàn, sông Cẩm Lệ và sông Đô Toả. Khu đô thị kết nối trung tâm qua cầu Hòa Xuân và các trục Nguyễn Phước Lan, đường 29/3.',
			'hh_p_connections'   => "10 phút | Trung tâm thành phố, cầu Rồng\n10 phút | Sân bay quốc tế Đà Nẵng\n20 phút | Chùa Linh Ứng Sơn Trà\n30 phút | Phố cổ Hội An",
		),
		'sources' => array( 'https://sunpropertygroup.vn/cac-du-an/sun-neo-city-9553', 'https://baothanhhoa.vn/sun-group-gioi-thieu-cora-tower-tam-diem-moi-phia-nam-da-nang-265228.htm' ),
	);
	$projects[] = array(
		'slug'    => 'cora-tower',
		'title'   => 'Cora Tower Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'cam-le',
		'parent'  => 'sun-neo-city',
		'hot'     => true,
		'excerpt' => 'Tòa căn hộ của Sun Group tại giao lộ Nguyễn Phước Lan – đường 29/3, trung tâm khu đô thị Sun NeO City (Hòa Xuân, Đà Nẵng); căn Studio đến 3 phòng ngủ, bàn giao hoàn thiện cơ bản.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => $sun,
			'hh_p_type'         => 'Căn hộ, shophouse khối đế',
			'hh_p_address'      => 'Giao lộ Nguyễn Phước Lan – đường 29/3, khu đô thị Sun NeO City, Hòa Xuân, Đà Nẵng',
			'hh_p_units'        => 'Mỗi tòa 616 căn hộ điển hình, 28 căn/tầng',
			'hh_p_ownership'    => 'Sở hữu lâu dài',
			'hh_p_handover'     => '30/07/2027 (dự kiến)',
			'hh_p_handover_std' => 'Hoàn thiện trần, tường, sàn (chưa gồm nội thất rời)',
			'hh_p_unit_types'   => "Studio | – | – | Liên hệ\nCăn 1PN+ | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
			'hh_p_design_desc'  => 'Mỗi tầng 28 căn: 6 Studio, 16 căn 1PN+, 5 căn 2PN và 1 căn 3PN. Mỗi tòa có 132 Studio, 352 căn 1PN+, 110 căn 2PN, 22 căn 3PN.',
			'hh_p_location_desc' => 'Cora Tower tọa lạc tại giao lộ Nguyễn Phước Lan và đường 29/3 – vị trí trung tâm của khu đô thị Sun NeO City (Nam Hòa Xuân), phía Nam Đà Nẵng.',
		),
		'sources' => array( 'https://baothanhhoa.vn/sun-group-gioi-thieu-cora-tower-tam-diem-moi-phia-nam-da-nang-265228.htm', 'https://congly.com.vn/cora-tower-tam-diem-dau-tu-moi-cua-sun-group-tai-nam-da-nang/', 'https://scdgroup.vn/sun-cora-tower' ),
	);
	$projects[] = array(
		'slug'    => 'spana-tower',
		'title'   => 'Spana Tower Hòa Xuân',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'cam-le',
		'parent'  => 'sun-neo-city',
		'excerpt' => 'Hai tòa căn hộ A1.3 và A1.4 của Sun Group ngay chân cầu Hòa Xuân, mặt tiền Nguyễn Phước Lan: 22 tầng, khoảng 1.281 căn từ Studio đến Penthouse, khối đế shophouse và tiện ích.',
		'meta'    => array(
			'hh_p_status'      => 'dang-mo-ban',
			'hh_p_developer'   => $sun,
			'hh_p_type'        => 'Căn hộ, penthouse, shophouse khối đế',
			'hh_p_address'     => 'Mặt tiền Nguyễn Phước Lan, chân cầu Hòa Xuân, khu đô thị Sun NeO City, Đà Nẵng',
			'hh_p_blocks'      => '2 tòa (A1.3, A1.4)',
			'hh_p_floors'      => '22 tầng nổi, 2 tầng hầm',
			'hh_p_units'       => 'Khoảng 1.281 căn hộ',
			'hh_p_ownership'   => 'Sở hữu lâu dài',
			'hh_p_handover'    => '30/06/2027 (dự kiến)',
			'hh_p_unit_types'  => "Studio | – | – | Liên hệ\nCăn 1PN+ | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
			'hh_p_shop_desc'   => 'Tầng 1 – 2 bố trí shophouse khối đế và tiện ích nội khu.',
			'hh_p_penthouse_desc' => 'Có căn Penthouse trên các tầng cao – liên hệ để nhận danh sách căn.',
			'hh_p_amenities_in' => "Hồ bơi\nGym & spa\nKids club\nShophouse khối đế tầng 1 – 2",
			'hh_p_connections' => "Chân cầu | Cầu Hòa Xuân\n10 phút | Trung tâm thành phố, cầu Rồng\n10 phút | Sân bay quốc tế Đà Nẵng\n30 phút | Bán đảo Sơn Trà, phố cổ Hội An",
		),
		'sources' => array( 'https://minhminhgroup.vn/sun-group-mo-ban-can-ho-hoa-xuan-spana-tower/', 'https://sunurbancityhanam.vn/sun-spana-tower/' ),
	);
	$projects[] = array(
		'slug'    => 's-light-tower',
		'title'   => 'S-Light Tower Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'cam-le',
		'parent'  => 'sun-neo-city',
		'hot'     => true,
		'excerpt' => 'Cặp tháp căn hộ 22 tầng của Sun Property tại Sun NeO City (Hòa Xuân), nơi giao ba dòng sông Hàn – Cẩm Lệ – Đô Toả: gần 800 căn từ 33,3 đến 95,1 m², view sông và pháo hoa DIFF.',
		'meta'    => array(
			'hh_p_status'     => 'dang-mo-ban',
			'hh_p_developer'  => $sun,
			'hh_p_type'       => 'Căn hộ, penthouse',
			'hh_p_address'    => 'Đường 29/3 giao Nguyễn Đình Thi, khu đô thị Sun NeO City, Hòa Xuân, Đà Nẵng',
			'hh_p_blocks'     => '2 tháp',
			'hh_p_floors'     => '22 tầng nổi, 3 tầng hầm',
			'hh_p_units'      => 'Gần 800 căn hộ',
			'hh_p_unit_area'  => '33,3 – 95,1 m²',
			'hh_p_ownership'  => 'Sở hữu lâu dài',
			'hh_p_unit_types' => "Studio | Từ 33,3 m² | – | Liên hệ\nCăn 1PN+ | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN góc | Đến 95,1 m² | 3 | Liên hệ",
			'hh_p_penthouse_desc' => 'Có dòng Penthouse – liên hệ để nhận danh sách căn.',
			'hh_p_highlights' => "Ngã ba sông Hàn – Cẩm Lệ – Đô Toả, tầm nhìn 270° ra sông và pháo hoa DIFF\n100% căn hộ đón nắng và gió tự nhiên\nSở hữu lâu dài",
			'hh_p_progress'   => '6/2026 | Sun Property ra mắt S-Light Tower',
		),
		'sources' => array( 'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn', 'https://anninhthudo.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-post657042.antd' ),
	);

	/* ---------------- Sun Riverpolis – Hòa Quý (Nam Hòa Xuân) ---------------- */
	$projects[] = array(
		'slug'    => 'sun-riverpolis',
		'title'   => 'Sun Riverpolis Nam Hòa Xuân',
		'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
		'area'    => 'ngu-hanh-son',
		'excerpt' => 'Khu đô thị sinh thái của Sun Group tại Hòa Quý (Nam Hòa Xuân, Đà Nẵng) – cùng Sun NeO City tạo hệ sinh thái hơn 1.000 ha phía Nam thành phố. Phân khu căn hộ đầu tiên: FourS Tower.',
		'meta'    => array(
			'hh_p_status'     => 'dang-mo-ban',
			'hh_p_developer'  => $sun,
			'hh_p_type'       => 'Căn hộ, đất nền, nhà phố, biệt thự ven sông',
			'hh_p_address'    => 'Phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng – khu đô thị Nam Hòa Xuân',
			'hh_p_scale'      => 'Thuộc hệ sinh thái hơn 1.000 ha cùng Sun NeO City',
			'hh_p_zones'      => 'FourS Tower (Mai – Trúc – Cúc – Tùng) | Căn hộ | 4 tòa 20 tầng, khoảng 2.291 căn | Ra mắt 3/2026',
			'hh_p_location_desc' => 'Sun Riverpolis nằm tại Hòa Quý, phía Nam Đà Nẵng, bao quanh bởi sông nước, gần biển và trục Nguyễn Phước Lan – Minh Mạng.',
		),
		'sources' => array( 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm' ),
	);
	$projects[] = array(
		'slug'    => 'fours-tower',
		'title'   => 'FourS Tower (Tháp Bốn Mùa) Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'ngu-hanh-son',
		'parent'  => 'sun-riverpolis',
		'hot'     => true,
		'excerpt' => 'Phân khu căn hộ đầu tiên của Sun Riverpolis (Hòa Quý, Nam Đà Nẵng): 4 tòa Mai – Trúc – Cúc – Tùng cao 20 tầng, khoảng 2.291 căn từ Studio đến 3 phòng ngủ, ngay ngã tư Nguyễn Phước Lan – Minh Mạng.',
		'meta'    => array(
			'hh_p_status'      => 'dang-mo-ban',
			'hh_p_developer'   => $sun,
			'hh_p_type'        => 'Căn hộ Studio – 3 phòng ngủ',
			'hh_p_address'     => 'Ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_blocks'      => '4 tòa (Mai, Trúc, Cúc, Tùng)',
			'hh_p_floors'      => '20 tầng nổi, 2 tầng hầm',
			'hh_p_units'       => 'Khoảng 2.291 căn hộ',
			'hh_p_ownership'   => 'Sở hữu lâu dài',
			'hh_p_unit_types'  => "Studio | – | – | Liên hệ\nCăn 1PN | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
			'hh_p_amenities_in' => "Hồ bơi bốn mùa\nGym, yoga, spa\nKhu vui chơi trẻ em\nKhông gian sinh hoạt cộng đồng\nPhòng khám Mặt Trời\n(Tiện ích bố trí tại tầng 2)",
			'hh_p_progress'    => '19/3/2026 | Sun Property ra mắt FourS Tower',
		),
		'sources' => array( 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm', 'https://tuoitre.vn/fours-tower-an-cu-dau-tu-tai-trung-tam-nam-da-nang-20260410181212744.htm' ),
	);

	/* ---------------- Đà Nẵng Downtown & Sun Galaxy Complex ---------------- */
	$projects[] = array(
		'slug'    => 'da-nang-downtown',
		'title'   => 'Đà Nẵng Downtown (Sun Group)',
		'type'    => array( 'to-hop', 'can-ho-so-huu-lau-dai' ),
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Siêu tổ hợp giải trí – thương mại – đô thị 76,92 ha ven sông Hàn của Sun Group trên khu đất Asia Park cũ, tổng vốn khoảng 79.790 tỷ đồng, có tòa tháp 69 tầng cao 408 m – cao nhất miền Trung.',
		'meta'    => array(
			'hh_p_status'     => 'sap-mo-ban',
			'hh_p_developer'  => 'Tập đoàn Sun Group',
			'hh_p_type'       => 'Tổ hợp: căn hộ cao cấp, khách sạn 5 sao, văn phòng, trung tâm thương mại, công viên văn hóa giải trí',
			'hh_p_address'    => 'Số 01 Phan Đăng Lưu (khu Asia Park cũ), phường Hòa Cường (cũ), Hải Châu, Đà Nẵng – ven sông Hàn',
			'hh_p_scale'      => '76,92 ha – tổng vốn khoảng 79.790 tỷ đồng',
			'hh_p_start'      => '19/8/2025',
			'hh_p_highlights' => "Tòa tháp biểu tượng 69 tầng, cao 408 m – cao nhất miền Trung\nCông viên văn hóa giải trí, nhà hát, phố thương mại ven sông Hàn\nTháp tích hợp khách sạn 5 sao, văn phòng hạng A, căn hộ cao cấp, trung tâm thương mại",
			'hh_p_zones'      => "Tháp biểu tượng 69 tầng | Khách sạn 5 sao, văn phòng, căn hộ cao cấp, TTTM | 408 m | Đang thi công\nSun Galaxy Complex | Căn hộ dịch vụ, khách sạn, khán đài pháo hoa, TTTM | Hơn 210.000 m² | Khởi công 25/7/2026",
			'hh_p_progress'   => "19/8/2025 | Khởi công Đà Nẵng Downtown\n25/7/2026 | Khởi công Sun Galaxy Complex",
			'hh_p_location_desc' => 'Đà Nẵng Downtown nằm ngay trung tâm thành phố, ven sông Hàn trong đoạn giữa cầu Trần Thị Lý và cầu Tiên Sơn, tại giao lộ Phan Đăng Lưu – Đỗ Pháp Thuận (khu Asia Park cũ).',
		),
		'sources' => array( 'https://dantri.com.vn/bat-dong-san/sun-group-khoi-cong-sieu-to-hop-giai-tri-thuong-mai-gan-80000-ty-dong-tai-da-nang-20250819202225532.htm', 'https://cafef.vn/sun-group-khoi-cong-sieu-du-an-80000-ty-dong-tai-da-nang-quyet-xay-toa-thap-cao-thu-2-viet-nam-188250819063225554.chn', 'https://baodautu.vn/batdongsan/da-nang-khoi-cong-sieu-du-an-da-nang-downtown-tong-von-gan-80000-ty-dong-d363815.html' ),
	);
	$projects[] = array(
		'slug'    => 'sun-galaxy-complex',
		'title'   => 'Sun Galaxy Complex Đà Nẵng',
		'type'    => 'can-ho-dich-vu',
		'area'    => 'ngu-hanh-son',
		'parent'  => 'da-nang-downtown',
		'hot'     => true,
		'excerpt' => 'Tổ hợp lễ hội – giải trí – căn hộ dịch vụ hơn 210.000 m² của Sun Group trên đường Chương Dương, bờ Đông sông Hàn: khán đài pháo hoa DIFF, khách sạn quốc tế, TTTM và căn hộ do Accor quản lý vận hành. Khởi công 25/7/2026.',
		'meta'    => array(
			'hh_p_status'     => 'sap-mo-ban',
			'hh_p_developer'  => 'Tập đoàn Sun Group',
			'hh_p_manager'    => 'Accor (thương hiệu Sofitel, Swissôtel) – theo đơn vị phân phối',
			'hh_p_type'       => 'Căn hộ dịch vụ, khách sạn quốc tế, nhà phố, trung tâm thương mại, khán đài pháo hoa',
			'hh_p_address'    => 'Đường Chương Dương, khu Mỹ An, bờ Đông sông Hàn, Ngũ Hành Sơn, Đà Nẵng – gần cầu Trần Thị Lý',
			'hh_p_scale'      => 'Hơn 210.000 m² – tổng vốn khoảng 10.750 tỷ đồng',
			'hh_p_units'      => 'Khán đài gần 20.000 chỗ, TTTM 7 tầng, 114 nhà phố, khoảng 1.400 phòng lưu trú (theo báo chí); đơn vị phân phối nêu khoảng 3.800 căn hộ',
			'hh_p_unit_area'  => 'Studio 32,6 m² · 1PN 49,1 m² · 2PN 72,3 m²',
			'hh_p_start'      => '25/7/2026',
			'hh_p_handover'   => 'Khoảng 36 tháng kể từ ngày nhận bàn giao mặt bằng (dự kiến)',
			'hh_p_highlights' => "Cổng Mặt Trăng (Moon Gate) đường kính 69 m nhìn thẳng không gian pháo hoa DIFF\nKhán đài lễ hội gần 20.000 chỗ, TTTM ven sông 7 tầng\nCăn hộ dịch vụ do Accor quản lý (theo đơn vị phân phối)",
			'hh_p_unit_types' => "Studio | 32,6 m² | – | Liên hệ\nCăn 1PN | 49,1 m² | 1 | Liên hệ\nCăn 2PN | 72,3 m² | 2 | Liên hệ\nCăn 3 – 4PN | – | 3 | Liên hệ",
			'hh_p_amenities_in' => "Khán đài pháo hoa DIFF\nTrung tâm thương mại ven sông 7 tầng\nHồ bơi vô cực, sky bar\nNhà hàng, gym, spa\nConcierge 24/7",
			'hh_p_progress'   => '25/7/2026 | Khởi công Sun Galaxy Complex',
		),
		'sources' => array( 'https://vneconomy.vn/buoc-dot-pha-trong-phat-trien-cong-nghiep-van-hoa-da-nang.htm', 'https://cafeland.vn/du-an/sun-galaxy-complex-to-hop-can-ho-tai-da-nang-5758.html' ),
	);

	return $projects;
}
