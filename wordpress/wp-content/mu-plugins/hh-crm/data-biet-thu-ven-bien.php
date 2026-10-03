<?php
/**
 * Biệt thự ven biển Đà Nẵng – Quảng Nam (cũ) đã bán / đang giao dịch chuyển nhượng.
 * Thông số dự án theo nguồn công khai; giá chuyển nhượng là KHOẢNG GIÁ tổng hợp từ tin rao
 * (batdongsan, alonhadat, homedy… 2026) – không sao chép tin rao, chỉ dùng làm mặt bằng giá tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_biet_thu_ven_bien', 20 );
function hh_dataset_biet_thu_ven_bien( $projects ) {
	$note = 'Khoảng giá tổng hợp từ các tin rao chuyển nhượng công khai năm 2026, chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc vị trí (mặt biển, sân golf, sông), diện tích, nội thất và hợp đồng vận hành – liên hệ để nhận danh sách căn đang bán thật.';

	// The Ocean Villas đã có trong dữ liệu chính: bổ sung giá chuyển nhượng.
	foreach ( $projects as &$p ) {
		if ( 'the-ocean-villas-da-nang' === $p['slug'] ) {
			$p['meta'] += array(
				'hh_p_sold_out'     => '1',
				'hh_p_resale_price' => 'Khoảng 28,5 – 70 tỷ (2 – 5 phòng ngủ, đất 500 – 808 m²)',
				'hh_p_resale_note'  => $note,
				'hh_p_villa_table'  => "Biệt thự 2PN view biển (tin rao) | – | 2 phòng ngủ | Khoảng 28,5 tỷ\nBiệt thự 3PN view sông (tin rao) | 508 m² | 3 phòng ngủ | Khoảng 35,5 tỷ\nBiệt thự 3PN (tin rao) | 620 m² | 3 phòng ngủ | Khoảng 48 tỷ\nBiệt thự 5PN (tin rao) | 808 m² | 5 phòng ngủ | Khoảng 70 tỷ",
			);
			$p['sources'][] = 'https://alonhadat.com.vn/du-an-khu-biet-thu-the-ocean-villas-pj938';
		}
	}
	unset( $p );

	$villa = static function ( $slug, $title, $area, $excerpt, $meta, $sources ) use ( $note ) {
		return array(
			'slug'    => $slug,
			'title'   => $title,
			'type'    => 'biet-thu',
			'area'    => $area,
			'excerpt' => $excerpt,
			'meta'    => $meta + array( 'hh_p_resale_note' => $note ),
			'sources' => $sources,
		);
	};

	$projects[] = $villa(
		'furama-villas-da-nang',
		'Furama Villas Đà Nẵng',
		'ngu-hanh-son',
		'Khu biệt thự Furama Villas cạnh Furama Resort trên bãi biển Non Nước – Mỹ Khê (Ngũ Hành Sơn): 134 biệt thự đất 280 – 980 m², giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'      => 'Đường Võ Nguyên Giáp – Trường Sa, Ngũ Hành Sơn, Đà Nẵng (cạnh Furama Resort)',
			'hh_p_units'        => '134 biệt thự',
			'hh_p_unit_area'    => 'Đất 280 – 980 m²',
			'hh_p_resale_price' => 'Khoảng 21 – 40 tỷ (3 – 4 phòng ngủ)',
			'hh_p_villa_table'  => "Biệt thự 3PN (tin rao) | – | 3 phòng ngủ | Khoảng 21 – 25 tỷ\nBiệt thự 4PN (tin rao) | – | 4 phòng ngủ | Khoảng 30 – 40 tỷ",
		),
		array( 'https://furamavietnam.com/furama-villas/', 'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-furama-villas' )
	);
	$projects[] = $villa(
		'hyatt-regency-danang-residences',
		'Hyatt Regency Danang Residences & Villas',
		'ngu-hanh-son',
		'Biệt thự và căn hộ thuộc khu nghỉ dưỡng Hyatt Regency Danang Resort & Spa (Ngũ Hành Sơn): 27 biệt thự Hyatt Villas và 160 căn hộ Residences, giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự biển, căn hộ nghỉ dưỡng',
			'hh_p_address'      => 'Đường Trường Sa, Ngũ Hành Sơn, Đà Nẵng (Hyatt Regency Danang Resort & Spa)',
			'hh_p_manager'      => 'Hyatt',
			'hh_p_units'        => '27 biệt thự, 160 căn hộ Residences',
			'hh_p_resale_price' => 'Biệt thự 3PN đất 600 m² khoảng 50 tỷ (tin rao)',
			'hh_p_villa_table'  => 'Biệt thự biển 3PN (tin rao) | 600 m² | 3 phòng ngủ | Khoảng 50 tỷ',
		),
		array( 'https://www.mvpvietnam.com/luxury/hyatt-regency-danang/', 'https://alonhadat.com.vn/can-ban-biet-thu-nha-lien-ke/p917/hyatt-regency-danang-residences.html' )
	);
	$projects[] = $villa(
		'fusion-resort-villas-da-nang',
		'Fusion Resort & Villas Đà Nẵng',
		'ngu-hanh-son',
		'Biệt thự biển thuộc Fusion Resort & Villas Đà Nẵng trên trục Trường Sa (Ngũ Hành Sơn), đất khoảng 486 – 700 m², giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'      => 'Đường Trường Sa, Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_manager'      => 'Fusion',
			'hh_p_unit_area'    => 'Đất khoảng 486 – 700 m²',
			'hh_p_resale_price' => 'Khoảng 32 – 54 tỷ',
			'hh_p_villa_table'  => 'Biệt thự biển (tin rao) | 486 – 700 m² | – | Khoảng 32 – 54 tỷ',
		),
		array( 'https://alonhadat.com.vn/du-an-khu-nghi-duong-fusion-resort-villas-da-nang-pj8564' )
	);
	$projects[] = $villa(
		'premier-village-da-nang',
		'Premier Village Đà Nẵng',
		'son-tra',
		'Biệt thự trong khu nghỉ dưỡng 5 sao Premier Village Danang Resort trên bãi biển Mỹ Khê (Sơn Trà), giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'      => 'Đường Võ Nguyên Giáp, bãi biển Mỹ Khê, Sơn Trà, Đà Nẵng',
			'hh_p_resale_price' => 'Khoảng 39 – 47 tỷ trở lên',
			'hh_p_villa_table'  => "Biệt thự biển Mỹ Khê (tin rao) | 300 m² | – | Khoảng 39 tỷ\nBiệt thự (tin rao) | – | – | Từ khoảng 47 tỷ",
		),
		array( 'https://homedy.com/ban-nha-biet-thu-lien-ke-premier-village-danang-resort/can-trong-5-da-nang-gia-chi-tu-47-ty-es2357032' )
	);
	$projects[] = $villa(
		'the-ocean-estates-da-nang',
		'The Ocean Estates Đà Nẵng',
		'ngu-hanh-son',
		'Khu 33 biệt thự 3 – 5 phòng ngủ của VinaCapital trên đường Trường Sa (Ngũ Hành Sơn), đất trung bình 929 – 1.303 m², thuộc quần thể Danang Beach Resort; giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_developer'    => 'VinaCapital Real Estate',
			'hh_p_type'         => 'Biệt thự sân golf – ven biển',
			'hh_p_address'      => 'Đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_units'        => '33 biệt thự 3 – 5 phòng ngủ',
			'hh_p_unit_area'    => 'Đất khoảng 929 – 1.303 m²',
			'hh_p_resale_price' => 'Từ khoảng 52 tỷ (5PN đất 965 m² khoảng 83 tỷ)',
			'hh_p_villa_table'  => "Biệt thự (tin rao) | – | – | Từ khoảng 52 tỷ\nBiệt thự 5PN (tin rao) | 965 m² | 5 phòng ngủ | Khoảng 83 tỷ",
		),
		array( 'https://homedy.com/the-ocean-estates-pj97559495', 'https://hiendproperty.com/mua-ban-bds/bds-thu-cap/biet-thu/the-ocean-estates-dn-biet-thu-5-phong-ngu/' )
	);
	$projects[] = $villa(
		'naman-residences',
		'Naman Residences Đà Nẵng',
		'ngu-hanh-son',
		'34 biệt thự trên đường Trường Sa (Ngũ Hành Sơn), nằm giữa sân golf Danang Golf Club và Montgomerie Links, đất 380 – 935 m², chủ đầu tư Thanh Đô.',
		array(
			'hh_p_developer'    => 'Công ty CP Đầu tư Phát triển Xây dựng Thanh Đô',
			'hh_p_type'         => 'Biệt thự nghỉ dưỡng',
			'hh_p_address'      => 'Đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 34.000 m²',
			'hh_p_units'        => '34 biệt thự, 4 loại',
			'hh_p_unit_area'    => 'Đất 380 – 935 m²',
			'hh_p_resale_price' => 'Giá mở bán từ khoảng 10,9 tỷ/căn (theo nguồn phân phối) – liên hệ để nhận giá hiện tại',
		),
		array( 'https://batdongsan.com.vn/du-an-khu-nghi-duong-sinh-thai-ngu-hanh-son-ddn/naman-residences-pj2179', 'https://meeyproject.com/project/naman-residences-1688357557583' )
	);
	$projects[] = $villa(
		'montgomerie-links-villas',
		'Montgomerie Links Villas',
		'dien-ban',
		'54 biệt thự 3 phòng ngủ trong sân golf Montgomerie Links (Điện Ngọc, giữa Đà Nẵng và Hội An), đất 350 – 700 m², hoàn thành 2014; giao dịch chuyển nhượng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự sân golf',
			'hh_p_address'      => 'Sân golf Montgomerie Links, Điện Ngọc, Điện Bàn (Quảng Nam cũ), Đà Nẵng',
			'hh_p_scale'        => '70 ha',
			'hh_p_units'        => '54 biệt thự 3 phòng ngủ (The Estates)',
			'hh_p_unit_area'    => 'Đất 350 – 700 m², sàn 276 – 395 m²',
			'hh_p_start'        => '2008',
			'hh_p_handover'     => 'Hoàn thành 2014',
			'hh_p_resale_price' => 'Giá bán gốc 820.000 – 1,6 triệu USD/căn; giá chuyển nhượng liên hệ',
			'hh_p_amenities_in' => "Sân golf Montgomerie Links\nHồ bơi riêng có điều chỉnh nhiệt độ\nKhách sạn Montgomerie Links Hotel",
		),
		array( 'https://vnexpress.net/biet-thu-san-golf-montgomerie-link-2696231.html', 'https://cafebatdongsan.com.vn/du-an-xem/16/montgomerie-links-villa' )
	);
	$projects[] = $villa(
		'four-seasons-the-nam-hai',
		'Four Seasons Resort The Nam Hai (biệt thự sở hữu)',
		'dien-ban',
		'Khu nghỉ dưỡng Four Seasons The Nam Hai 35 ha bên biển Hà My (Điện Bàn – Hội An), gồm 40 biệt thự sở hữu 1 – 5 phòng ngủ có hồ bơi riêng.',
		array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_type'         => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'      => 'Bãi biển Hà My, Điện Dương, Điện Bàn (Quảng Nam cũ), Đà Nẵng – gần Hội An',
			'hh_p_manager'      => 'Four Seasons',
			'hh_p_scale'        => '35 ha',
			'hh_p_units'        => '100 biệt thự, trong đó 40 biệt thự sở hữu 1 – 5 phòng ngủ có hồ bơi riêng',
			'hh_p_resale_price' => 'Liên hệ',
		),
		array( 'https://tienphong.vn/tiet-lo-ve-chu-so-huu-resort-gia-60-trieu-dongdem-co-ran-ghe-tham-post1531140.tpo' )
	);
	$projects[] = $villa(
		'shilla-monogram-quang-nam',
		'Shilla Monogram Quảng Nam – Đà Nẵng',
		'dien-ban',
		'Khu nghỉ dưỡng 5 sao thương hiệu Shilla (Samsung) ven biển Điện Ngọc, gồm 34 biệt thự 3 tầng hướng biển.',
		array(
			'hh_p_type'         => 'Biệt thự biển, khách sạn nghỉ dưỡng',
			'hh_p_address'      => 'Ven biển Điện Ngọc, Điện Bàn (Quảng Nam cũ), Đà Nẵng',
			'hh_p_manager'      => 'Shilla Monogram (Samsung)',
			'hh_p_units'        => '34 biệt thự 3 tầng hướng biển',
			'hh_p_resale_price' => 'Liên hệ',
		),
		array( 'https://haphong.com/portfolio/shilla-monogram-quang-nam/' )
	);

	return $projects;
}
