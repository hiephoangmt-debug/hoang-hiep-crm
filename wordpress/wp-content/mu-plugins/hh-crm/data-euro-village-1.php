<?php
/**
 * Euro Village 1 – Làng Châu Âu ven sông Hàn (Sun Group), phường An Hải (Sơn Trà cũ). Trang mới 22/11/2026 (anh Hiệp đồng ý).
 * Số liệu: batdongsan.com.vn (trang dự án Làng Châu Âu), batdongsandanang.com.vn, nhadatvn.com.vn – 23,7 ha, 245 nhà phố, 175 biệt thự.
 * Giá: chỉ là giá RAO BÁN trên thị trường (tham khảo), không phải giá giao dịch.
 * Đồng thời sửa Euro Village 2: các số 23,7 ha / 245 nhà phố / 175 biệt thự trước đây nhập nhầm từ Euro Village 1.
 * Euro Village 2 (giai đoạn 1B KĐT sinh thái Hòa Xuân): khoảng 320 lô biệt thự 250 – 500 m² (toprealty.vn, timdanang.com).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_euro_village_1', 20 );
function hh_dataset_euro_village_1( $projects ) {
	$projects[] = array(
		'slug'    => 'euro-village-1',
		'title'   => 'Euro Village 1 – Làng Châu Âu Đà Nẵng',
		'type'    => array( 'biet-thu', 'shophouse' ),
		'area'    => 'son-tra',
		'excerpt' => 'Euro Village 1 (Làng Châu Âu) – khu biệt thự, nhà phố ven sông Hàn của Sun Group tại phường An Hải (Sơn Trà cũ), Đà Nẵng: 23,7 ha, 245 nhà phố và 175 biệt thự ven sông, sổ đỏ lâu dài, đã bàn giao – giao dịch chuyển nhượng.',
		'meta'    => array(
			'hh_p_status'       => 'da-ban-giao',
			'hh_p_sold_out'     => '1',
			'hh_p_developer'    => 'Tập đoàn Sun Group',
			'hh_p_type'         => 'Biệt thự ven sông, nhà phố thương mại',
			'hh_p_address'      => 'Ven sông Hàn, phường An Hải (Sơn Trà cũ), Đà Nẵng',
			'hh_p_scale'        => '23,7 ha',
			'hh_p_units'        => '420 sản phẩm: 245 nhà phố thương mại, 175 biệt thự ven sông',
			'hh_p_unit_area'    => 'Nhà phố khoảng 100 m²/lô · Biệt thự khoảng 200 – 1.300 m²/lô (phổ biến 250 m²)',
			'hh_p_ownership'    => 'Đất ở lâu dài, sổ đỏ từng lô',
			'hh_p_resale_price' => 'Giá rao bán khoảng 185 – 320 triệu/m² đất tùy vị trí, view sông (tham khảo, chưa phải giá giao dịch)',
			'hh_p_villa_table'  => "Nhà phố thương mại | Khoảng 100 m² | 3 – 3,5 tầng | Rao bán khoảng 20 – 22 tỷ\nBiệt thự tiêu chuẩn | Khoảng 250 m² (10 × 20 m) | Biệt thự 4 phòng ngủ | Rao bán khoảng 45 – 52 tỷ\nBiệt thự lớn view sông | Khoảng 900 m² | Có hồ bơi, sân vườn | Theo vị trí – liên hệ",
			'hh_p_highlights'   => "Khu biệt thự khép kín ven sông Hàn của Sun Group – một trong những khu biệt thự sớm nhất bờ Đông\n23,7 ha, 420 sản phẩm: 245 nhà phố thương mại và 175 biệt thự ven sông\nSổ đỏ từng lô, sở hữu lâu dài; đã bàn giao, cộng đồng cư dân hiện hữu\nGần trung tâm, các cầu qua sông Hàn, biển Mỹ Khê\nHàng hiếm: chủ yếu giao dịch chuyển nhượng, ít nguồn cung mới",
			'hh_p_image_links'  => 'plugin:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg | Sông Hàn, Đà Nẵng về đêm – khu vực ven sông nơi có Euro Village 1 (ảnh tư liệu khu vực, không phải ảnh dự án) | thư viện',
			'rank_math_title'       => 'Euro Village 1 Đà Nẵng (Làng Châu Âu): Giá biệt thự 2026',
			'rank_math_description' => 'Euro Village 1 – Làng Châu Âu ven sông Hàn của Sun Group: 23,7 ha, 245 nhà phố, 175 biệt thự, sổ đỏ lâu dài. Giá rao bán tham khảo 2026, chuyển nhượng.',
		),
		'content' => <<<'HTML'
<p><strong>Euro Village 1</strong> (Làng Châu Âu) là khu biệt thự, nhà phố ven sông Hàn do Tập đoàn Sun Group phát triển tại phường An Hải (Sơn Trà cũ), Đà Nẵng. Dự án rộng khoảng 23,7 ha với 420 sản phẩm: 245 nhà phố thương mại và 175 biệt thự ven sông, kiến trúc châu Âu, sổ đỏ từng lô sở hữu lâu dài. Dự án đã bàn giao và có cư dân sinh sống; nguồn hàng hiện nay chủ yếu là chuyển nhượng.</p>
<h2>Thông tin Euro Village 1</h2>
<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Tập đoàn Sun Group</td></tr>
<tr><th>Vị trí</th><td>Ven sông Hàn, phường An Hải (Sơn Trà cũ), Đà Nẵng</td></tr>
<tr><th>Quy mô</th><td>Khoảng 23,7 ha</td></tr>
<tr><th>Sản phẩm</th><td>245 nhà phố thương mại (khoảng 100 m²/lô), 175 biệt thự ven sông (khoảng 200 – 1.300 m²/lô)</td></tr>
<tr><th>Pháp lý</th><td>Sổ đỏ từng lô, đất ở lâu dài</td></tr>
<tr><th>Tình trạng</th><td>Đã bàn giao – giao dịch chuyển nhượng</td></tr>
</tbody>
</table>
<h2>Giá Euro Village 1 tham khảo</h2>
<p>Theo các tin rao bán trên thị trường, giá đất tại Euro Village 1 khoảng 185 – 320 triệu/m² tùy vị trí, mặt đường và view sông. Nhà phố 100 m² được rao khoảng 20 – 22 tỷ; biệt thự 250 m² khoảng 45 – 52 tỷ. Đây là giá chào bán, giá giao dịch thực tế tùy thương lượng, hiện trạng nhà và nội thất.</p>
<h2>Euro Village 1 và Euro Village 2 khác nhau thế nào?</h2>
<p>Euro Village 1 nằm ven sông Hàn ở bờ Đông, gần trung tâm; còn <a href="/du-an/euro-village-2/">Euro Village 2</a> thuộc giai đoạn 1B Khu đô thị sinh thái Hòa Xuân (Cẩm Lệ), cũng do Sun Group phát triển, với khoảng 320 lô biệt thự 250 – 500 m². Euro Village 1 có giá cao hơn nhờ vị trí trung tâm và cộng đồng đã hình thành lâu năm.</p>
<p>Cần tìm biệt thự, nhà phố Euro Village 1 đang chuyển nhượng hoặc định giá căn đang sở hữu, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML
		,
		'sources' => array(
			'https://batdongsan.com.vn/du-an-khu-do-thi-moi-son-tra-ddn/lang-chau-au-euro-village-pj1265',
			'https://batdongsandanang.com.vn/chi-tiet-du-an/kim-long-city-2/',
			'https://nhadatvn.com.vn/du-an/euro-village/',
		),
	);
	return $projects;
}

/** Sửa số liệu Euro Village 2 (trước nhập nhầm từ Euro Village 1). Ô anh đã tự sửa trong quản trị giữ nguyên. */
add_filter( 'hh_project_dataset', 'hh_dataset_euro_village_2_sua', 40 );
function hh_dataset_euro_village_2_sua( $projects ) {
	foreach ( $projects as $i => $p ) {
		if ( 'euro-village-2' !== ( $p['slug'] ?? '' ) ) {
			continue;
		}
		$upd = array(
			'hh_p_scale'     => 'Thuộc giai đoạn 1B Khu đô thị sinh thái Hòa Xuân',
			'hh_p_units'     => 'Khoảng 320 lô biệt thự',
			'hh_p_unit_area' => 'Khoảng 250 – 500 m²/lô (phổ biến 300 m², 12 × 25 m)',
		);
		foreach ( $upd as $k => $v ) {
			$cur = (string) ( $p['meta'][ $k ] ?? '' );
			if ( $cur !== $v ) {
				if ( '' !== trim( $cur ) ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) );
				}
				$p['meta'][ $k ] = $v;
			}
		}
		$old = (string) ( $p['excerpt'] ?? '' );
		$new = 'Làng Châu Âu 2 – khu biệt thự ven sông thuộc giai đoạn 1B Khu đô thị sinh thái Hòa Xuân (Cẩm Lệ, Đà Nẵng) của Sun Group: khoảng 320 lô biệt thự 250 – 500 m², sổ đỏ lâu dài; giao dịch chuyển nhượng.';
		if ( $old !== $new ) {
			$p['fix_excerpt'] = array_merge( (array) ( $p['fix_excerpt'] ?? array() ), array_filter( array( $old ) ) );
			$p['excerpt']     = $new;
		}
		$p['sources'] = array_values( array_unique( array_merge( (array) ( $p['sources'] ?? array() ), array( 'https://toprealty.vn/du-an/euro-village-2-da-nang/', 'https://www.timdanang.com/vn/du-an-euro-village-2-da-nang-lang-chau-au-2-hoa-xuan-n31.html' ) ) ) );
		$projects[ $i ] = $p;
	}
	return $projects;
}
