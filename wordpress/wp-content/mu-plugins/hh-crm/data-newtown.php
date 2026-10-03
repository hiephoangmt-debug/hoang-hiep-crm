<?php
/**
 * Tổ hợp Newtown Diamond Đà Nẵng (Trường Sa – Nam Kỳ Khởi Nghĩa, Ngũ Hành Sơn): dự án chính thành tổ hợp,
 * thêm 3 tòa căn hộ The Ruby, The Sapphire, The Diamond và phân khu thấp tầng Newtown Legend (biệt thự, shophouse). Tổng hợp báo chí và trang phân phối (10/2026).
 * Giá là mặt bằng chào bán tham khảo – cần đối chiếu bảng giá chủ đầu tư từng đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_newtown', 20 );
function hh_dataset_newtown( $projects ) {
	$dev     = 'Công ty TNHH Phát triển New Town';
	$builder = 'Công ty CP CONINCO 3C (tổng thầu); Hòa Bình thi công phần thân tòa The Ruby';
	$addr    = 'Ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng';
	$src     = array(
		'https://vn.savills.com.vn/residential/da-nang-projects/newtown-diamond.aspx',
		'https://cafef.vn/newtown-diamond-tam-diem-thu-hut-nha-dau-tu-tai-da-nang-188260121105200071.chn',
		'https://congthuong.vn/newtown-diamond-tam-diem-thu-hut-nha-dau-tu-tai-da-nang-446421.html',
		'https://vnexpress.net/newtown-diamond-cat-noc-toa-can-ho-dau-tien-5065074.html',
	);

	foreach ( $projects as &$p ) {
		if ( 'newtown-diamond-da-nang' !== $p['slug'] ) {
			continue;
		}
		$p['title']   = 'Tổ hợp Newtown Diamond Đà Nẵng';
		$p['type']    = array( 'to-hop', 'can-ho-so-huu-lau-dai', 'biet-thu', 'shophouse' );
		$p['hot']     = true;
		$p['excerpt'] = 'Tổ hợp ven biển Newtown tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa (Ngũ Hành Sơn, Đà Nẵng): 3 tòa căn hộ The Ruby, The Sapphire, The Diamond (1.733 căn) và phân khu thấp tầng Newtown Legend gồm 24 biệt thự, 36 shophouse – tất cả sở hữu lâu dài.';
		$p['meta']    = array(
			'hh_p_builder'    => $builder,
			'hh_p_zones'      => "Tòa The Ruby (M1) | Căn hộ 1 – 3PN | 829 căn | Đã cất nóc 18/4/2026\nTòa The Sapphire (M2) | Căn hộ 1 – 3PN | 510 căn | Đang xây dựng\nTòa The Diamond | Căn hộ 1 – 3PN | 394 căn | Đang xây dựng\nKhối đế thương mại | Trung tâm thương mại, tiện ích | 6 tầng | Đang xây dựng\nNewtown Legend (thấp tầng) | Biệt thự golf, shop villa, shophouse | 24 biệt thự, 36 shophouse | Đang mở bán",
			'hh_p_highlights' => "Ven biển Mỹ Khê – Non Nước, đối diện Sheraton Grand Đà Nẵng, cạnh sân golf BRG\n3 tòa 36 tầng, 1.733 căn hộ, sổ hồng sở hữu lâu dài từng căn\n6 tầng trung tâm thương mại khối đế, hồ bơi vô cực tầng 6, Sky Bar, vườn trên mái\nTòa The Ruby đã cất nóc tháng 4/2026\nPhân khu thấp tầng Newtown Legend: 24 biệt thự và 36 shophouse view sân golf 36 lỗ, sở hữu lâu dài",
			'hh_p_unit_types' => "Căn 1PN | 35 – 50 m² | 1 | Khoảng 3,5 – 3,9 tỷ\nCăn 2PN | 73 – 87 m² | 2 | Khoảng 5,7 – 7,5 tỷ\nCăn 3PN | 94 – 132 m² | 3 | Liên hệ",
			'hh_p_shop_desc'  => 'Khối đế 6 tầng trung tâm thương mại (khoảng 48.000 – 50.000 m² sàn) phục vụ cư dân 3 tòa và khách du lịch dọc trục Trường Sa.',
			'hh_p_villa_desc'   => 'Phân khu thấp tầng Newtown Legend có 24 biệt thự (22 song lập, 2 đơn lập) cao 3 tầng và 1 tầng hầm, view sân golf 36 lỗ. Xem chi tiết tại trang Newtown Legend.',
			'hh_p_villa_table'  => "Grand Golf Villa (song lập / đơn lập) | – | 3 tầng + 1 hầm, sàn 416 – 485 m² | Từ khoảng 50 tỷ\nGolfside Shop Villa | – | Biệt thự kết hợp kinh doanh | Từ khoảng 42 tỷ",
			'hh_p_nha-pho_desc' => 'Newtown Legend có 36 shophouse (Premier Shop Residence) 4 tầng, đất khoảng 140 m², sàn xây dựng khoảng 379 m², tầng trệt kinh doanh – trên trục Trường Sa ven biển.',
			'hh_p_nha-pho_table' => "Premier Shop Residence | Khoảng 140 m² | 4 tầng, sàn khoảng 379 m² | Từ khoảng 20 tỷ",
			'hh_p_amenities_in' => "Hai hồ bơi vô cực tầng 6\nPhòng gym, spa\nSky Bar & Café, vườn trên mái (Rooftop Garden)\nKhu BBQ, yoga & vườn thiền\nKhu vui chơi trẻ em, nhà trẻ\n6 tầng trung tâm thương mại",
		) + $p['meta'];
		$p['fix_meta'] = array(
			'hh_p_zones' => "Tòa M1 – The Emerald | Căn hộ | 829 căn | –\nTòa M2 – The Sapphire | Căn hộ | 510 căn | –\nTòa M3 – The Aquamarine | Căn hộ | 394 căn | –",
		);
		$p['sources'] = array_values( array_unique( array_merge( $p['sources'], $src ) ) );
		$p['content'] = '<p><strong>Newtown Diamond Đà Nẵng</strong> là tổ hợp căn hộ ven biển do Công ty TNHH Phát triển New Town làm chủ đầu tư, tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa (phường Hòa Hải cũ, Ngũ Hành Sơn). Trên khu đất khoảng 1,47 ha, dự án gồm 3 tòa tháp 36 tầng và 3 tầng hầm với tổng 1.733 căn hộ, khối đế 6 tầng trung tâm thương mại.</p>
<h2>Các tòa trong tổ hợp Newtown</h2>
<ul>
<li><a href="/du-an/newtown-the-ruby/">Tòa The Ruby</a> – 829 căn, tòa lớn nhất, đã cất nóc ngày 18/4/2026.</li>
<li><a href="/du-an/newtown-the-sapphire/">Tòa The Sapphire</a> – 510 căn.</li>
<li><a href="/du-an/newtown-the-diamond/">Tòa The Diamond</a> – 394 căn.</li>
<li><a href="/du-an/newtown-legend/">Newtown Legend</a> – phân khu thấp tầng: 24 biệt thự và 36 shophouse view sân golf.</li>
</ul>
<h2>Vì sao Newtown được quan tâm</h2>
<p>Dự án nằm trên trục biển Trường Sa, đối diện Sheraton Grand Đà Nẵng Resort và cạnh sân golf BRG Đà Nẵng – khu vực tập trung resort cao cấp nhưng rất ít căn hộ có sổ hồng sở hữu lâu dài. Căn hộ 1 – 3 phòng ngủ phù hợp cả để ở lẫn cho thuê ngắn ngày phục vụ khách du lịch.</p>
<p>Giá chào bán tham khảo năm 2026: căn 1PN khoảng 3,5 – 3,9 tỷ, căn 2PN khoảng 5,7 – 7,5 tỷ (tùy tòa, tầng, view). Phân khu thấp tầng Newtown Legend: shophouse từ khoảng 20 tỷ, Golfside Shop Villa từ khoảng 42 tỷ, Grand Golf Villa từ khoảng 50 tỷ. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá và chính sách mới nhất của từng tòa.</p>';
	}
	unset( $p );

	$tower = static function ( $slug, $title, $excerpt, $meta ) use ( $dev, $builder, $addr, $src ) {
		return array(
			'slug'    => $slug,
			'title'   => $title,
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'parent'  => 'newtown-diamond-da-nang',
			'excerpt' => $excerpt,
			'meta'    => $meta + array(
				'hh_p_status'        => 'dang-mo-ban',
				'hh_p_developer'     => $dev,
				'hh_p_builder'       => $builder,
				'hh_p_type'          => 'Căn hộ cao cấp ven biển',
				'hh_p_address'       => $addr,
				'hh_p_floors'        => '36 tầng nổi, 3 tầng hầm chung',
				'hh_p_ownership'     => 'Sở hữu lâu dài (sổ hồng từng căn)',
				'hh_p_location_desc' => 'Tòa nằm trong tổ hợp Newtown Diamond tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, Ngũ Hành Sơn – đối diện Sheraton Grand Đà Nẵng Resort, cạnh sân golf BRG Đà Nẵng, cách bãi biển khoảng 1 phút đi bộ.',
				'hh_p_connections'   => "1 phút | Bãi biển\n5 phút | Danh thắng Ngũ Hành Sơn\n15 phút | Trung tâm thành phố, cầu Rồng\n25 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Dùng chung tiện ích tổ hợp: hồ bơi vô cực tầng 6, gym, spa\nSky Bar & Café, vườn trên mái\nKhu vui chơi trẻ em, nhà trẻ\n6 tầng trung tâm thương mại khối đế",
				'hh_p_amenities_out' => "Sheraton Grand Đà Nẵng Resort\nBRG Đà Nẵng Golf Resort\nBãi biển Non Nước – Mỹ Khê",
			),
			'sources' => $src,
		);
	};

	$projects[] = $tower(
		'newtown-the-ruby',
		'Newtown The Ruby',
		'Tòa The Ruby (M1) – tòa lớn nhất tổ hợp Newtown Diamond Đà Nẵng: 36 tầng, 829 căn hộ 1 – 3 phòng ngủ ven biển Trường Sa, đã cất nóc ngày 18/4/2026.',
		array(
			'hh_p_units'      => '829 căn hộ',
			'hh_p_unit_types' => "Căn 1PN | 35 – 50 m² | 1 | Khoảng 3,5 – 3,9 tỷ\nCăn 2PN | 73 – 87 m² | 2 | Khoảng 5,7 – 7,5 tỷ\nCăn 3PN | 94 – 132 m² | 3 | Liên hệ",
			'hh_p_progress'   => "18/4/2026 | Cất nóc tòa The Ruby\nQuý 3/2026 | Bàn giao (dự kiến)",
			'hh_p_handover'   => 'Quý 3/2026 (dự kiến)',
		)
	);
	$projects[] = $tower(
		'newtown-the-sapphire',
		'Newtown The Sapphire',
		'Tòa The Sapphire (M2) thuộc tổ hợp Newtown Diamond Đà Nẵng: 36 tầng, 510 căn hộ 1 – 3 phòng ngủ ven biển, sổ hồng sở hữu lâu dài.',
		array(
			'hh_p_units'      => '510 căn hộ',
			'hh_p_unit_types' => "Căn 1PN | 35 – 50 m² | 1 | Liên hệ\nCăn 2PN | 73 – 87 m² | 2 | Liên hệ\nCăn 3PN | 94 – 132 m² | 3 | Liên hệ",
		)
	);
	$projects[] = $tower(
		'newtown-the-diamond',
		'Newtown The Diamond',
		'Tòa The Diamond thuộc tổ hợp Newtown Diamond Đà Nẵng: 36 tầng, 394 căn hộ – tòa ít căn nhất, mật độ thấp, ven biển Trường Sa.',
		array(
			'hh_p_units'      => '394 căn hộ',
			'hh_p_unit_types' => "Căn 1PN | 35 – 50 m² | 1 | Liên hệ\nCăn 2PN | 73 – 87 m² | 2 | Liên hệ\nCăn 3PN | 94 – 132 m² | 3 | Liên hệ",
		)
	);

	$projects[] = array(
		'slug'    => 'newtown-legend',
		'title'   => 'Newtown Legend Đà Nẵng',
		'type'    => array( 'biet-thu', 'shophouse' ),
		'area'    => 'ngu-hanh-son',
		'parent'  => 'newtown-diamond-da-nang',
		'hot'     => true,
		'excerpt' => 'Phân khu thấp tầng của tổ hợp Newtown trên trục biển Trường Sa (Ngũ Hành Sơn, Đà Nẵng): 24 biệt thự golf và 36 shophouse 4 tầng view sân golf 36 lỗ, sở hữu lâu dài.',
		'meta'    => array(
			'hh_p_status'        => 'dang-mo-ban',
			'hh_p_developer'     => $dev,
			'hh_p_type'          => 'Biệt thự golf, shop villa, shophouse',
			'hh_p_address'       => $addr,
			'hh_p_units'         => '60 căn: 24 biệt thự, 36 shophouse',
			'hh_p_ownership'     => 'Sở hữu lâu dài',
			'hh_p_zones'         => "Legacy Street | Biệt thự, shophouse | – | Đang mở bán\nNewtown Avenue | Biệt thự, shophouse | – | Đang mở bán",
			'hh_p_highlights'    => "Hiếm hoi thấp tầng sở hữu lâu dài trên trục biển Trường Sa\nView sân golf 36 lỗ, đối diện Sheraton Grand Đà Nẵng\nDùng chung tiện ích tổ hợp Newtown Diamond: trung tâm thương mại, hồ bơi, gym\nĐã có biệt thự mẫu \"The Legendary\"",
			'hh_p_villa_desc'    => '24 biệt thự gồm 22 căn song lập và 2 căn đơn lập, cao 3 tầng và 1 tầng hầm, diện tích sàn khoảng 416 – 485 m², hướng nhìn sân golf.',
			'hh_p_villa_table'   => "Biệt thự song lập (22 căn) | – | 3 tầng + 1 hầm, sàn 416 – 485 m² | Từ khoảng 50 tỷ (Grand Golf Villa)\nBiệt thự đơn lập (2 căn) | – | 3 tầng + 1 hầm, sàn khoảng 485 m² | Liên hệ\nGolfside Shop Villa | – | Biệt thự kết hợp kinh doanh | Từ khoảng 42 tỷ",
			'hh_p_nha-pho_desc'  => '36 shophouse (Premier Shop Residence) cao 4 tầng, đất khoảng 140 m², sàn xây dựng khoảng 379 m²; tầng trệt kinh doanh, các tầng trên để ở hoặc cho thuê.',
			'hh_p_nha-pho_table' => "Premier Shop Residence | Khoảng 140 m² | 4 tầng, sàn khoảng 379 m² | Từ khoảng 20 tỷ",
			'hh_p_location_desc' => 'Newtown Legend nằm trong tổ hợp Newtown tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, Ngũ Hành Sơn – cạnh sân golf BRG Đà Nẵng 36 lỗ, đối diện Sheraton Grand Đà Nẵng Resort, sát các tòa căn hộ Newtown Diamond.',
			'hh_p_connections'   => "1 phút | Bãi biển\n5 phút | Danh thắng Ngũ Hành Sơn\n15 phút | Trung tâm thành phố, cầu Rồng\n25 phút | Phố cổ Hội An",
			'hh_p_amenities_in'  => "Sân golf 36 lỗ liền kề\nTrung tâm thương mại 6 tầng của tổ hợp\nHồ bơi, gym, spa tại Newtown Diamond\nCảnh quan nội khu, đường dạo bộ",
			'hh_p_amenities_out' => "Sheraton Grand Đà Nẵng Resort\nBRG Đà Nẵng Golf Resort\nBãi biển Non Nước – Mỹ Khê",
		),
		'sources' => array(
			'https://tienphong.vn/newtown-legend-da-nang-tai-san-blue-chip-tai-toa-do-di-san-post1880313.tpo',
			'https://thanhtra.com.vn/bat-dong-san-D986B7903/newtown-legend-da-nang-tai-san-blue-chip-tai-toa-do-di-san-9801551d9.html',
			'https://thuonggiaonline.vn/nam-da-nang-tro-thanh-cuc-tang-truong-moi-newtown-legend-don-du-dia-gia-tang-gia-tri-post572137.html',
			'https://cafeland.vn/du-an/newtown-legend-du-an-biet-thu-lien-ke-tai-da-nang-5699.html',
			'https://cvr.com.vn/property/for-sale-townhouse-at-newtown-legend-danang-legacy-street-36-hole-golf-course-view',
		),
	);

	return $projects;
}
