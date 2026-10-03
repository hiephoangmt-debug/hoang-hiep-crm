<?php
/**
 * Tổ hợp Newtown Diamond Đà Nẵng (Trường Sa – Nam Kỳ Khởi Nghĩa, Ngũ Hành Sơn): dự án chính thành tổ hợp,
 * thêm 3 tòa thành phần The Ruby, The Sapphire, The Diamond. Tổng hợp báo chí và trang phân phối (10/2026).
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
		$p['type']    = array( 'to-hop', 'can-ho-so-huu-lau-dai' );
		$p['hot']     = true;
		$p['excerpt'] = 'Tổ hợp căn hộ ven biển Newtown Diamond tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa (Ngũ Hành Sơn, Đà Nẵng): 3 tòa The Ruby, The Sapphire, The Diamond cao 36 tầng, 1.733 căn hộ sở hữu lâu dài, 6 tầng thương mại khối đế.';
		$p['meta']    = array(
			'hh_p_builder'    => $builder,
			'hh_p_zones'      => "Tòa The Ruby (M1) | Căn hộ 1 – 3PN | 829 căn | Đã cất nóc 18/4/2026\nTòa The Sapphire (M2) | Căn hộ 1 – 3PN | 510 căn | Đang xây dựng\nTòa The Diamond | Căn hộ 1 – 3PN | 394 căn | Đang xây dựng\nKhối đế thương mại | Trung tâm thương mại, tiện ích | 6 tầng | Đang xây dựng",
			'hh_p_highlights' => "Ven biển Mỹ Khê – Non Nước, đối diện Sheraton Grand Đà Nẵng, cạnh sân golf BRG\n3 tòa 36 tầng, 1.733 căn hộ, sổ hồng sở hữu lâu dài từng căn\n6 tầng trung tâm thương mại khối đế, hồ bơi vô cực tầng 6, Sky Bar, vườn trên mái\nTòa The Ruby đã cất nóc tháng 4/2026",
			'hh_p_unit_types' => "Căn 1PN | 35 – 50 m² | 1 | Khoảng 3,5 – 3,9 tỷ\nCăn 2PN | 73 – 87 m² | 2 | Khoảng 5,7 – 7,5 tỷ\nCăn 3PN | 94 – 132 m² | 3 | Liên hệ",
			'hh_p_shop_desc'  => 'Khối đế 6 tầng trung tâm thương mại (khoảng 48.000 – 50.000 m² sàn) phục vụ cư dân 3 tòa và khách du lịch dọc trục Trường Sa.',
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
</ul>
<h2>Vì sao Newtown được quan tâm</h2>
<p>Dự án nằm trên trục biển Trường Sa, đối diện Sheraton Grand Đà Nẵng Resort và cạnh sân golf BRG Đà Nẵng – khu vực tập trung resort cao cấp nhưng rất ít căn hộ có sổ hồng sở hữu lâu dài. Căn hộ 1 – 3 phòng ngủ phù hợp cả để ở lẫn cho thuê ngắn ngày phục vụ khách du lịch.</p>
<p>Giá chào bán tham khảo năm 2026: căn 1PN khoảng 3,5 – 3,9 tỷ, căn 2PN khoảng 5,7 – 7,5 tỷ (tùy tòa, tầng, view). Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá và chính sách mới nhất của từng tòa.</p>';
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

	return $projects;
}
