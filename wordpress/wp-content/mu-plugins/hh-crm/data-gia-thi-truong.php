<?php
/**
 * Mặt bằng giá thị trường (bán lại, cho thuê) các dự án căn hộ Đà Nẵng – tổng hợp từ tin rao công khai (10/2026).
 * Chỉ là khoảng giá tham khảo, không phải tin rao cụ thể.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_gia_thi_truong', 30 );
function hh_dataset_gia_thi_truong( $projects ) {
	$note = 'Khoảng giá tổng hợp từ các tin rao bán, cho thuê công khai tháng 10/2026, chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc tầng, view, nội thất – liên hệ để nhận danh sách căn đang giao dịch thật.';
	$add  = array(
		'sun-symphony-residence'  => array(
			'resale'  => 'Chuyển nhượng: Studio từ khoảng 3,2 – 3,6 tỷ; 1PN+ từ 4,5 tỷ; 2PN khoảng 6 – 8 tỷ; 3PN từ 8,2 tỷ (≈ 69 – 125 triệu/m²)',
			'rent'    => '1PN – 2PN khoảng 12 – 25 triệu/tháng; 3PN khoảng 10 – 40 triệu/tháng tùy nội thất, view',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-symphony-residence',
				'https://nhadat.cafeland.vn/ban-du-an/sun-symphony-residence-4336/',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-symphony-residence/gia-tu-10-trieu-den-40-trieu-3pn',
			),
		),
		'sun-cosmo-residence'     => array(
			'resale'  => 'Studio khoảng 1,8 – 2,5 tỷ; 1PN khoảng 2,8 – 5,3 tỷ; 2PN khoảng 3,6 – 6,8 tỷ; 3PN khoảng 6 – 9,5 tỷ (≈ 65 – 95 triệu/m²)',
			'rent'    => 'Studio từ 16 triệu/tháng; 1PN khoảng 23 – 24 triệu/tháng; 2PN khoảng 30 – 35 triệu/tháng; 3PN khoảng 30 – 40 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-cosmo-residence',
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p10694/sun-cosmo-residence-da-nang.html',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-cosmo-residence',
				'https://meeyland.com/cho-thue-can-ho-chung-cu-sun-cosmo-residence-ngu-hanh-son-da-nang-l24332',
			),
		),
		'sun-ponte-residence'     => array(
			'resale'  => 'Studio/1PN khoảng 2,96 – 4,49 tỷ; 1PN+ khoảng 3,6 – 4,9 tỷ; 2PN khoảng 4,3 – 6,9 tỷ; 3PN khoảng 5,6 – 10 tỷ (≈ 70 – 112 triệu/m²)',
			'rent'    => 'Studio khoảng 13 – 20 triệu/tháng; 1PN khoảng 20 – 30 triệu/tháng; 2PN khoảng 32 – 40 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-ponte-residence-da-nang',
				'https://thuviennhadat.vn/bat-dong-san/gia-ban-sun-ponte-residence-da-nang-gia-can-ho-chung-cu-thang-7-2025-20625.html',
				'https://sunhome.com.vn/ban-can-ho-sun-ponte-residence/',
			),
		),
		'peninsula-da-nang'       => array(
			'resale'  => '1PN khoảng 2,2 – 2,7 tỷ; 2PN khoảng 3 – 5 tỷ; 3PN khoảng 5,5 – 6,5 tỷ (≈ 50 – 83 triệu/m²)',
			'rent'    => '2PN khoảng 23 – 30 triệu/tháng; mặt bằng chung khoảng 20 – 45 triệu/tháng tùy diện tích, view sông Hàn',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-peninsula-da-nang',
				'https://homedy.com/ban-can-ho-peninsula-da-nang',
				'https://www.nhatot.com/mua-ban-can-ho-chung-cu--peninsula-da-nang-quan-son-tra-pj525823742',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-peninsula-da-nang',
			),
		),
		'hiyori-garden-tower'     => array(
			'resale'  => '2PN (63 – 71m²) khoảng 5 – 6,7 tỷ',
			'rent'    => '2PN khoảng 15 – 25 triệu/tháng (phổ biến 18 – 21 triệu/tháng), căn view đẹp đến 28 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-hiyori-garden-tower',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-hiyori-garden-tower',
				'https://www.nhatot.com/thue-can-ho-chung-cu--hiyori-garden-tower-quan-son-tra-pj1871336036',
			),
		),
		'the-ori-garden'          => array(
			'resale'  => '1PN khoảng 1,31 – 1,94 tỷ; 2PN khoảng 1,96 – 2,56 tỷ; 3PN khoảng 2,79 – 3,1 tỷ (≈ 37 – 42 triệu/m²)',
			'rent'    => '1PN khoảng 3 – 4,5 triệu/tháng; 2PN khoảng 4 – 6 triệu/tháng; 3PN khoảng 5 – 8 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-ori-garden',
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p10044/the-ori-garden-da-nang.html',
				'https://www.nhatot.com/thue-can-ho-chung-cu--the-ori-garden-quan-lien-chieu-pj926041972',
			),
		),
		'times-square-da-nang'    => array(
			'resale'  => 'Studio/1PN (45 – 50m²) khoảng 6,5 – 8,5 tỷ; 2PN (65 – 85m²) khoảng 12 – 14 tỷ (≈ 150 triệu/m², căn view đặc biệt cao hơn)',
			'rent'    => 'Thuê dài hạn khoảng 25 – 40 triệu/tháng; căn view trực diện biển Mỹ Khê khoảng 25 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-da-nang-times-square',
				'https://www.nhatot.com/mua-ban-can-ho-chung-cu--times-square-da-nang-quan-son-tra-pj2041952291',
				'https://thuviennhadat.vn/ban-can-ho-chung-cu-phuong-phuoc-my-pj-da-nang-times-square/ban-can-ho-time-square-da-nang-tang-cao-view-truc-dien-bien-my-khe-cho-thue-25trthang-pst152092.html',
			),
		),
		'capital-square-da-nang'  => array(
			'resale'  => '1PN khoảng 3,3 – 4,5 tỷ; 2PN khoảng 4,7 – 7,8 tỷ; 3PN khoảng 9,5 – 12,6 tỷ (≈ 74 – 90 triệu/m²)',
			'rent'    => '1PN khoảng 18 – 25 triệu/tháng (full nội thất); 2PN khoảng 25 – 35 triệu/tháng (ước tính)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-capital-square',
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p11322/capital-square.html',
			),
		),
		'newtown-diamond-da-nang' => array(
			'resale'  => '1PN khoảng 2,8 – 3,9 tỷ; 2PN khoảng 4,5 – 7,5 tỷ; 3PN khoảng 7,2 – 11,6 tỷ (≈ 60 – 90 triệu/m²)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-newtown-diamond-da-nang',
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-newtown-diamond-da-nang/1pn',
				'https://thuviennhadat.vn/ban-nha-dat-du-an-newtown-diamond-da-nang',
			),
		),
		'fpt-plaza-1'             => array(
			'resale'  => '2PN (58 – 73m²) khoảng 2,6 – 3,15 tỷ; 3PN (~86m²) khoảng 2,6 – 3 tỷ trở lên',
			'rent'    => '1PN từ 6,5 triệu/tháng; 2PN khoảng 10 – 13 triệu/tháng; 3PN khoảng 15,5 – 17 triệu/tháng (mặt bằng FPT Plaza)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-1',
				'https://www.nhatot.com/mua-ban-can-ho-chung-cu--fpt-city-quan-ngu-hanh-son-pj1818786181',
				'https://thuecanho123.com/cho-thue-can-ho-chung-cu-fpt-plaza.html',
			),
		),
		'fpt-plaza-2'             => array(
			'resale'  => '2PN khoảng 2,25 – 3,4 tỷ; 3PN khoảng 3,9 – 4,25 tỷ (≈ 30 – 42 triệu/m²)',
			'rent'    => '1PN từ 6,5 triệu/tháng; 2PN khoảng 10 – 13 triệu/tháng; 3PN khoảng 15,5 – 17 triệu/tháng (mặt bằng FPT Plaza)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-2',
				'https://www.nhatot.com/mua-ban-can-ho-chung-cu--fpt-plaza-2-quan-ngu-hanh-son-pj994730511',
				'https://homedy.com/ban-can-ho-fpt-plaza-2-da-nang',
				'https://thuecanho123.com/cho-thue-can-ho-chung-cu-fpt-plaza.html',
			),
		),
		'fpt-plaza-3'             => array(
			'resale'  => '1PN khoảng 1,6 – 2,5 tỷ; 2PN khoảng 2,6 – 4 tỷ (tin rao: 2PN 55 – 60m² từ 2,59 – 3,5 tỷ)',
			'rent'    => '1PN từ 6,5 triệu/tháng; 2PN khoảng 10 – 13 triệu/tháng; 3PN khoảng 15,5 – 17 triệu/tháng (mặt bằng FPT Plaza)',
			'sources' => array(
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p10641/fpt-plaza-3.html',
				'https://nhadatfptdanang.com/can-ho-fpt-plaza-3/',
				'https://thuecanho123.com/cho-thue-can-ho-chung-cu-fpt-plaza.html',
			),
		),
		'the-filmore-da-nang'     => array(
			'resale'  => '1PN (48 – 50m²) khoảng 4,5 – 7,6 tỷ; 2PN (71 – 81m²) khoảng 8,3 – 9,3 tỷ (≈ 110 triệu/m²)',
			'rent'    => '1PN khoảng 22 – 27 triệu/tháng; 2PN khoảng 35 – 40 triệu/tháng; 3PN view sông Hàn đến 95 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang',
				'https://homedy.com/ban-can-ho-the-filmore-da-nang',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-the-filmore-da-nang',
				'https://alonhadat.com.vn/cho-thue-can-ho-chung-cu/p10127/the-filmore-da-nang.html',
			),
		),
		'vista-residence-da-nang' => array(
			'resale'  => '2PN (76m²) khoảng 4,3 – 5,1 tỷ (≈ 48 – 55 triệu/m², tùy tầng, hướng)',
			'rent'    => '2PN khoảng 20 – 32 triệu/tháng; 3PN khoảng 30 – 40 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-vista-residence-da-nang',
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p11059/the-vista-residence-da-nang-gold-tower.html',
				'https://vietnamnet.vn/vista-residence-da-nang-tao-suc-hut-tren-thi-truong-can-ho-cho-thue-2560810.html',
			),
		),
		'wyndham-soleil-da-nang'  => array(
			'resale'  => 'Studio khoảng 2,3 – 2,6 tỷ; 1PN (55 – 58m²) khoảng 4,3 tỷ (≈ 74 – 130 triệu/m²)',
			'rent'    => 'Studio khoảng 20 triệu/tháng; căn lớn, view biển khoảng 25 – 45 triệu/tháng',
			'sources' => array(
				'https://batdongsan.com.vn/ban-condotel-wyndham-soleil-da-nang',
				'https://alonhadat.com.vn/can-ban-can-ho-chung-cu/p2261/anh-duong-wyndham-soleil.html',
				'https://www.nhatot.com/mua-ban-can-ho-chung-cu--wyndham-soleil-da-nang-quan-son-tra-pj1340311932',
			),
		),
		'masteri-da-nang'         => array(
			'resale'  => 'Chuyển nhượng HĐMB (chưa bàn giao): 2PN khoảng 4,9 tỷ, chênh khoảng 300 triệu; bảng giá: 1PN+ 4,1 – 4,5 tỷ, 2PN 5,1 – 6,3 tỷ',
			'rent'    => '1PN+ khoảng 18 – 25 triệu/tháng; 2PN khoảng 20 – 25 triệu/tháng (ước tính khu vực)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-masteri-rivera-danang',
				'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-masteri-rivera-danang',
			),
		),
		'sun-neo-city'            => array(
			'resale'  => 'Sang nhượng HĐMB Spana Tower khoảng 1,9 – 4,14 tỷ (2PN tầng cao view sông từ 2,9 tỷ)',
			'sources' => array(
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-spana-tower',
				'https://nhadat.cafeland.vn/ban-du-an/spana-tower-5406/',
				'https://batdongsan.com.vn/ban-can-ho-chung-cu-cora-tower',
			),
		),
	);
	foreach ( $projects as &$p ) {
		if ( isset( $add[ $p['slug'] ] ) ) {
			$a          = $add[ $p['slug'] ];
			$p['meta'] += array_filter( array(
				'hh_p_resale_price' => $a['resale'] ?? '',
				'hh_p_rent_price'   => $a['rent'] ?? '',
				'hh_p_resale_note'  => $note,
			) );
			$p['sources'] = array_values( array_unique( array_merge( $p['sources'] ?? array(), $a['sources'] ) ) );
		}
	}
	unset( $p );
	return $projects;
}
