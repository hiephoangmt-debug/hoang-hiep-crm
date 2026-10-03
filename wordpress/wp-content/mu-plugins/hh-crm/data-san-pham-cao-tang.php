<?php
/**
 * Shop khối đế, penthouse, duplex của các dự án đang bán tại Đà Nẵng (tổng hợp báo chí và trang phân phối, 10/2026).
 * Trang dự án chỉ hiện mục này khi có thông tin; trang /san-pham/shop-khoi-de/, /san-pham/penthouse/, /san-pham/duplex/
 * tự gom các dự án có dữ liệu. Giá là mức chào bán tham khảo – đối chiếu bảng giá chủ đầu tư từng đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_san_pham_cao_tang', 30 );
function hh_dataset_san_pham_cao_tang( $projects ) {
	$add = array(
		'sun-symphony-residence' => array(
			'meta'    => array(
				'hh_p_shop_desc'  => '77 shop khối đế 2 tầng tại chân các tòa căn hộ ven sông Hàn; mỗi tầng khoảng 60 – 66 m², tổng diện tích sử dụng khoảng 126 m².',
				'hh_p_shop_table' => 'Shop khối đế 2 tầng | Khoảng 126 m² sử dụng | Từ khoảng 4 tỷ (tham khảo) | Ven sông Hàn',
			),
			'sources' => array( 'https://newstarland.com/bang-gia-sun-symphony-residence-da-nang/' ),
		),
		'sun-cosmo-residence'    => array(
			'meta'    => array(
				'hh_p_shop_desc' => '38 shop khối đế tại 2 tầng đế của tòa A (27 tầng) và tòa B (33 tầng); tầng thứ 3 của khối đế dành cho tiện ích.',
			),
			'sources' => array( 'https://sungroups.vn/sun-cosmo-residence/' ),
		),
		'sun-ponte-residence'    => array(
			'meta'    => array(
				'hh_p_shop_desc'  => '26 shop khối đế, diện tích 40 – 150 m² (căn mặt tiền Trần Hưng Đạo đến khoảng 308 m²); tầng 1 cao 7 m, tầng 2 cao 4,5 m; bàn giao thô, sở hữu lâu dài.',
				'hh_p_shop_table' => "Shop nhỏ (có thể làm gác thành ~80 m²) | 40,7 m² | Khoảng 4,6 tỷ | Tầng 1 cao 7 m\nShop T0123 (có thể làm ~110 m²) | 55,9 m² | Khoảng 5,5 tỷ | –\nShop mặt tiền Trần Hưng Đạo | 101,8 – 308,2 m² | Khoảng 13 – 64,6 tỷ | View sông Hàn",
			),
			'fix'     => array( 'hh_p_shop_desc' => '26 shophouse tại khối đế tòa tháp.' ),
			'sources' => array( 'https://sunponte.vn/shophouse-khoi-de-sun-ponte-residence/', 'https://newstarland.com/shophouse-sun-ponte-residence/' ),
		),
		'the-legend-da-nang'     => array(
			'meta'    => array(
				'hh_p_penthouse_desc'  => '8 căn penthouse thiết kế duplex thông tầng, diện tích 256 – 415 m², hồ bơi riêng và vườn trên mái, view sông Hàn – cầu Rồng.',
				'hh_p_penthouse_table' => 'Penthouse duplex (8 căn) | 256 – 415 m² | – | Từ khoảng 37 tỷ',
				'hh_p_duplex_desc'     => 'Các căn penthouse của The Legend thiết kế duplex: 2 tầng nối bằng cầu thang riêng, phòng khách thông tầng.',
				'hh_p_duplex_table'    => 'Penthouse duplex | 256 – 415 m² | – | Từ khoảng 37 tỷ',
			),
			'fix'     => array( 'hh_p_penthouse_desc' => 'Có căn penthouse trên các tầng cao – liên hệ để nhận danh sách căn.' ),
			'sources' => array( 'https://thelegendanang.com.vn/tu-39m2-den-penthouse-415m2-the-legend/' ),
		),
		'peninsula-da-nang'      => array(
			'meta'    => array(
				'hh_p_shop_desc'  => '10 shophouse khối đế 2 tầng, hai mặt tiền: một mặt ra đường Lê Văn Duyệt, Hồ Hán Thương, Bùi Dương Lịch hoặc Nại Hưng 1, một mặt ra công viên nội khu. Tổng diện tích 199 – 269 m².',
				'hh_p_shop_table' => 'Shophouse khối đế 2 tầng (10 căn) | 199 – 269 m² | Từ khoảng 79 triệu/m² | Hai mặt tiền',
			),
			'sources' => array( 'https://thoibaonganhang.vn/shophouse-peninsula-da-nang-tung-chinh-sach-uu-dai-voi-gia-ban-chi-tu-79-trieum2-169394.html', 'https://nongnghiepmoitruong.vn/tiem-nang-dau-tu-doc-ton-cua-shophouse-khoi-de-peninsula-da-nang-d769657.html' ),
		),
		'times-square-da-nang'   => array(
			'meta'    => array(
				'hh_p_shop_desc'       => '15 shophouse khối đế 2 tầng, sở hữu lâu dài, mặt tiền đường biển; khối đế đã có các thương hiệu F&B như Highlands, Phúc Long, KFC.',
				'hh_p_penthouse_desc'  => '2 căn penthouse 3 phòng ngủ tại tầng 30 tòa CT7, diện tích 202,01 m².',
				'hh_p_penthouse_table' => 'Penthouse tầng 30 tòa CT7 (2 căn) | 202,01 m² | 3 | Liên hệ',
			),
			'sources' => array( 'https://smartland.vn/can-ho-da-nang-times-square/' ),
		),
		'capital-square-da-nang' => array(
			'meta'    => array(
				'hh_p_shop_desc'      => 'Khối đế thương mại gồm shophouse 3 – 5 tầng, trung tâm thương mại, nhà hàng, café và phố đi bộ nối sông Hàn với đường Ngô Quyền.',
				'hh_p_penthouse_desc' => 'Có căn penthouse trên các tầng cao, view sông Hàn – liên hệ để nhận danh sách căn.',
				'hh_p_duplex_desc'    => 'Căn duplex diện tích khoảng 138 – 138,9 m²; căn thông tầng lớn khoảng 215,2 m².',
				'hh_p_duplex_table'   => "Duplex | 138 – 138,9 m² | – | Liên hệ\nCăn thông tầng | 215,2 m² | – | Liên hệ",
			),
			'sources' => array( 'https://capitalsquaredanang.vn/mat-bang/' ),
		),
		'cora-tower'             => array(
			'meta'    => array(
				'hh_p_shop_desc'      => 'Shophouse khối đế tại tầng đế tòa tháp, giao lộ Nguyễn Phước Lan – đường 29/3. Sun Property mở booking dòng penthouse và shophouse khối đế giới hạn (tổng 132 căn cho cả Cora, Spana, S-Light) từ 8/2026.',
				'hh_p_penthouse_desc' => 'Có căn penthouse trên các tầng cao, view sông – núi – biển, thuộc đợt mở bán penthouse giới hạn của Sun Property (8/2026).',
			),
			'sources' => array( 'https://dantri.com.vn/bat-dong-san/sun-property-ra-mat-dong-penthouse-shophouse-khoi-de-gioi-han-tai-nam-trung-tam-da-nang-20260811094649419.htm' ),
		),
		'spana-tower'            => array(
			'meta'    => array(
				'hh_p_duplex_desc' => 'Spana Tower có căn duplex trong rổ hàng cùng studio, 1 – 3 phòng ngủ và penthouse – liên hệ để nhận danh sách căn.',
			),
			'sources' => array( 'https://dantri.com.vn/bat-dong-san/sun-property-ra-mat-dong-penthouse-shophouse-khoi-de-gioi-han-tai-nam-trung-tam-da-nang-20260811094649419.htm' ),
		),
		's-light-tower'          => array(
			'meta'    => array(
				'hh_p_shop_desc' => 'Shophouse khối đế tại chân 2 tòa 22 tầng, thuộc đợt mở bán shophouse khối đế giới hạn của Sun Property (8/2026).',
			),
			'sources' => array( 'https://dantri.com.vn/bat-dong-san/sun-property-ra-mat-dong-penthouse-shophouse-khoi-de-gioi-han-tai-nam-trung-tam-da-nang-20260811094649419.htm' ),
		),
	);

	foreach ( $projects as &$p ) {
		if ( isset( $add[ $p['slug'] ] ) ) {
			$p['meta']    = $add[ $p['slug'] ]['meta'] + $p['meta'];
			// Mô tả chung chung nhập trước đây được thay bằng thông tin cụ thể (chỉ khi bạn chưa tự sửa).
			$p['fix_meta'] = ( $add[ $p['slug'] ]['fix'] ?? array() ) + ( $p['fix_meta'] ?? array() );
			$p['sources'] = array_values( array_unique( array_merge( $p['sources'] ?? array(), $add[ $p['slug'] ]['sources'] ) ) );
		}
	}
	unset( $p );
	return $projects;
}
