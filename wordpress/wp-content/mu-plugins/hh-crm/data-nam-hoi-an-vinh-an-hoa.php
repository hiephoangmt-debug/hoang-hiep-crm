<?php
/**
 * Vịnh An Hòa City (Núi Thành) và cập nhật chi tiết Nam Hội An City (Duy Xuyên) – vùng Đông Nam Đà Nẵng mới
 * (Quảng Nam cũ). Tổng hợp báo chí, trang dự án và tin rao công khai (10/2026). Giá là giá rao tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_vinh_an_hoa', 20 );
function hh_dataset_vinh_an_hoa( $projects ) {
	$projects[] = array(
		'slug'    => 'vinh-an-hoa-city',
		'title'   => 'Vịnh An Hòa City',
		'type'    => array( 'dat-nen', 'biet-thu-lau-dai' ),
		'area'    => 'nui-thanh',
		'excerpt' => 'Khu đô thị sinh thái 99,6 ha ven vịnh An Hòa – sông Trường Giang, Núi Thành, cạnh sân bay Chu Lai: đất nền 150 – 160 m², biệt thự Hoa Sứ, biệt thự Nhật Bản; giá rao 2026 khoảng 8 – 11 triệu/m².',
		'meta'    => array(
			'hh_p_status'        => 'dang-ban-giao',
			'hh_p_name'          => 'Vịnh An Hòa City (Khu đô thị sinh thái Vịnh An Hòa)',
			'hh_p_developer'     => 'Công ty CP Đầu tư Chu Lai Hội An (hệ sinh thái FVG)',
			'hh_p_type'          => 'Đất nền nhà phố, đất biệt thự, biệt thự và nhà vườn xây sẵn',
			'hh_p_address'       => 'Quốc lộ 1A, xã Tam Hiệp (cũ), nay là xã Núi Thành, TP. Đà Nẵng – ven vịnh An Hòa, sông Trường Giang',
			'hh_p_map_address'   => 'Khu đô thị Vịnh An Hòa, Núi Thành',
			'hh_p_scale'         => '99,6 ha',
			'hh_p_units'         => 'Khoảng 2.700 sản phẩm (các nguồn ghi 2.685 – 2.741)',
			'hh_p_unit_area'     => 'Đất nền phổ biến 150 – 160 m²',
			'hh_p_legal'         => 'Tin rao ghi sổ đỏ từng lô – cần kiểm tra sổ bản gốc',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_highlights'    => "Quy mô 99,6 ha, khoảng 3,5 km tiếp giáp vịnh An Hòa – sông Trường Giang\nCạnh sân bay Chu Lai, trong vùng Khu kinh tế mở Chu Lai\nTiếp giáp Quốc lộ 1A, kết nối Võ Chí Công và cao tốc Đà Nẵng – Quảng Ngãi\nĐất nền 150 – 160 m² giá rao chỉ khoảng 1,3 – 2,2 tỷ/lô (2026)\nCó phân khu biệt thự Hoa Sứ, biệt thự Nhật Bản, nhà vườn Mỹ xây sẵn",
			'hh_p_location_desc' => 'Vịnh An Hòa City nằm ở xã Tam Hiệp cũ (từ 1/7/2025 thuộc xã Núi Thành, TP. Đà Nẵng), dọc vịnh An Hòa trên sông Trường Giang, tiếp giáp Quốc lộ 1A. Dự án gần sân bay Chu Lai và nằm trong vùng Khu kinh tế mở Chu Lai; theo trang dự án, kết nối với cao tốc Đà Nẵng – Quảng Ngãi, ĐT617 và đường ven biển Võ Chí Công.',
			'hh_p_connections'   => "Khoảng 10 – 20 phút | Sân bay Chu Lai\nKhoảng 25 km (30 phút) | Trung tâm Tam Kỳ\nKhoảng 60 phút | Phố cổ Hội An\nKhoảng 85 km (1 giờ 30 phút) | Trung tâm Đà Nẵng",
			'hh_p_amenities_in'  => "Công viên, quảng trường ven vịnh\nĐất trường học, chợ, thương mại dịch vụ theo quy hoạch\nĐất nhà ở chuyên gia",
			'hh_p_amenities_out' => "Sân bay Chu Lai\nKhu kinh tế mở Chu Lai, cảng Chu Lai\nSông Trường Giang, biển Tam Hải\nThị trấn Núi Thành (cũ)",
			'hh_p_resale_price'  => '8 – 11 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => 'Khoảng giá tổng hợp từ tin rao công khai 2026 (Homedy, Batdongsan, Alonhadat, BDS68), chỉ để tham khảo – không phải giá giao dịch hay bảng giá chủ đầu tư. Giá phụ thuộc độ rộng đường (7,5 – 25 m), hướng vịnh, block và tình trạng sổ của từng lô.',
			'hh_p_villa_desc'    => 'Các phân khu xây sẵn: biệt thự Hoa Sứ (block CL35, CL40) song lập 3 tầng, đất 150 m², sàn 305 m², giá từ khoảng 5,5 tỷ; biệt thự Nhật Bản (block B1, B2) mở bán đầu 2024, đất khoảng 276 – 294 m², giá công bố khoảng 6,8 – 8,8 tỷ; nhà vườn Mỹ (CL57, CL59, CL60) 33 căn, 130 – 254 m², khoảng 3,5 – 3,8 tỷ (1/2024).',
			'hh_p_villa_table'   => "Biệt thự Hoa Sứ (CL35, CL40) | Đất 150 m², sàn 305 m² | Song lập 3 tầng, bàn giao hoàn thiện | Từ khoảng 5,5 tỷ\nBiệt thự Nhật Bản (B1, B2) | Đất 276 – 294 m² | Mở bán đầu 2024 | Khoảng 6,8 – 8,8 tỷ\nNhà vườn Mỹ (CL57, CL59, CL60) | 130 – 254 m² | 33 căn | Khoảng 3,5 – 3,8 tỷ (1/2024)",
			'hh_p_image_links'   => "plugin:img/vinh-an-hoa/vinh-an-hoa-city.jpg | Sơ đồ minh hoạ Vịnh An Hòa City ven vịnh An Hòa, Núi Thành | đại diện\nplugin:img/vinh-an-hoa/vinh-an-hoa-city-thong-tin.jpg | Vịnh An Hòa City – thông tin và giá tham khảo | thư viện",
			'hh_p_faq'           => "Vịnh An Hòa City ở đâu? | Ven vịnh An Hòa (sông Trường Giang), tiếp giáp Quốc lộ 1A, xã Tam Hiệp cũ – từ 1/7/2025 thuộc xã Núi Thành, TP. Đà Nẵng; gần sân bay Chu Lai.\nAi là chủ đầu tư Vịnh An Hòa City? | Công ty CP Đầu tư Chu Lai Hội An, thuộc hệ sinh thái FVG (cùng nhóm phát triển Nam Hội An City).\nGiá đất Vịnh An Hòa City bao nhiêu? | Tin rao 2026: lô 150 – 160 m² khoảng 1,3 – 2,2 tỷ (khoảng 8 – 11 triệu/m²), lô đường 19,5 – 25 m cao hơn. Đây là giá rao tham khảo.\nĐất Vịnh An Hòa có sổ đỏ chưa? | Tin rao ghi sổ đỏ từng lô. Trước khi đặt cọc cần xem sổ bản gốc, kiểm tra quy hoạch và thế chấp tại xã Núi Thành.",
		),
		'content' => '<p><strong>Vịnh An Hòa City</strong> (Khu đô thị sinh thái Vịnh An Hòa) là dự án quy mô <strong>99,6 ha</strong> ven vịnh An Hòa trên sông Trường Giang, tiếp giáp Quốc lộ 1A, gần sân bay Chu Lai. Dự án thuộc xã Tam Hiệp cũ, huyện Núi Thành (Quảng Nam); từ 1/7/2025 thuộc <strong>xã Núi Thành, TP. Đà Nẵng</strong>. Chủ đầu tư là Công ty CP Đầu tư Chu Lai Hội An, thuộc hệ sinh thái FVG – cùng nhóm phát triển <a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>99,6 ha, chia hai khu An Hòa 1 và An Hòa 2; khoảng 2.700 sản phẩm (các nguồn ghi 2.685 – 2.741).</li>
<li>Đất nền nhà phố liền kề, đất biệt thự, đất thương mại dịch vụ và nhà ở chuyên gia; lô phổ biến 150 – 160 m², ngang 6 m.</li>
<li>Đường nội khu 7,5 m, 10,5 m, 15,5 m và trục 19,5 – 25 m.</li>
<li>Phân khu xây sẵn: biệt thự Hoa Sứ (CL35, CL40), biệt thự Nhật Bản (B1, B2), nhà vườn Mỹ (CL57, CL59, CL60).</li>
</ul>
<h2>Giá đất Vịnh An Hòa City (tin rao 2026)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Đường 7,5 m</td><td>157 m²</td><td>1,4 tỷ</td><td>Tin 9/2026</td></tr>
<tr><td>Đường 10,5 m</td><td>150 – 159 m²</td><td>1,58 – 1,76 tỷ (khoảng 10 triệu/m²)</td><td>Tin 2026</td></tr>
<tr><td>Lô 150 – 171 m²</td><td>150 – 171 m²</td><td>1,59 – 1,68 tỷ</td><td>Tin rao</td></tr>
<tr><td>Block CL50, đường 19,5 m</td><td>156 m²</td><td>2,19 tỷ</td><td>Tin 10/2026</td></tr>
<tr><td>Đường 20,5 m</td><td>159 m²</td><td>2,15 tỷ</td><td>Tin 9/2026</td></tr>
</tbody></table>
<p>Mặt bằng rao 2026 khoảng <strong>8 – 11 triệu/m²</strong> (khoảng 1,3 – 2,2 tỷ/lô), có tin "cắt lỗ" thấp hơn giá mở bán các năm 2021 – 2023 (khoảng 10 – 15 triệu/m², lô mặt đường 25 m hơn 2 tỷ). Đây là giá rao tham khảo, không phải giá giao dịch.</p>
<h2>Biệt thự và nhà vườn xây sẵn</h2>
<p>Biệt thự Hoa Sứ song lập 3 tầng, đất 150 m², sàn 305 m², giá từ khoảng 5,5 tỷ. Biệt thự Nhật Bản mở bán đầu năm 2024, đất khoảng 276 – 294 m², giá công bố khoảng 6,8 – 8,8 tỷ (Báo Quảng Nam, Reatimes). Nhà vườn Mỹ 33 căn, 130 – 254 m², khoảng 3,5 – 3,8 tỷ (1/2024).</p>
<h2>Động lực: sân bay và Khu kinh tế mở Chu Lai</h2>
<p>Quy hoạch mở rộng sân bay Chu Lai đề xuất đường băng mới 3.048 m, nhà ga công suất 10 triệu khách/năm, vốn khoảng 11.000 tỷ đồng; tháng 6/2026 Cục Hàng không yêu cầu rà soát lại quy hoạch (vị trí nhà ga T2, ranh giới đất). Thời điểm thi công chưa được xác nhận, nên người mua nên xem đây là động lực dài hạn.</p>
<h2>Lưu ý khi mua</h2>
<p>Vịnh An Hòa cách trung tâm Đà Nẵng khoảng 85 km, thanh khoản chậm hơn đất nền ven Đà Nẵng. Phù hợp người mua để ở gần Khu kinh tế Chu Lai hoặc đầu tư dài hạn bằng vốn nhàn rỗi. Nên xem sổ bản gốc, kiểm tra quy hoạch – thế chấp tại xã và đi xem hạ tầng thực tế của block.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách lô đang bán thật và kiểm tra pháp lý trước khi giao dịch.</p>',
		'sources' => array(
			'https://vinhanhoacity.com/gioi-thieu',
			'https://baodautu.vn/batdongsan/vinh-an-hoa-city---khu-do-thi-dang-song-nhat-vung-dong-quang-nam-d156529.html',
			'https://baoquangnam.vn/mo-ban-phan-khu-biet-thu-nhat-ban-va-nha-vuon-my-tai-du-an-vinh-an-hoa-city-3128798.html',
			'https://reatimes.vn/fvg-mo-ban-biet-thu-nhat-ban-va-nha-vuon-my-tai-vinh-an-hoa-202240121114459827.htm',
			'https://homedy.com/ban-dat-nen-du-an-vinh-an-hoa-city',
			'https://batdongsan.com.vn/ban-dat-nen-du-an-kdt-vinh-an-hoa-nui-thanh',
			'https://vietstock.vn/2026/06/cuc-hang-khong-yeu-cau-ra-soat-lai-quy-hoach-tranh-lang-phi-khi-dau-tu-mo-rong-san-bay-chu-lai-768-1456268.htm',
		),
	);

	return $projects;
}

/**
 * Nam Hội An City: cập nhật chi tiết (pháp lý Khu đô thị Nồi Rang, chủ đầu tư Chu Lai Hội An – FVG,
 * khách sạn Fivitel + resort Fivires khởi công 3/9/2025, giá chuyển nhượng 2025 – 2026).
 * Chỉ thay các ô còn đúng giá trị web nhập lần trước (fix_meta) – ô anh đã tự sửa giữ nguyên.
 */
add_filter( 'hh_project_dataset', 'hh_dataset_nam_hoi_an_city_2026', 21 );
function hh_dataset_nam_hoi_an_city_2026( $projects ) {
	foreach ( $projects as $i => $p ) {
		if ( 'nam-hoi-an-city' !== $p['slug'] ) {
			continue;
		}
		$new = array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Công ty CP Đầu tư Chu Lai Hội An (FVG Group)',
			'hh_p_type'          => 'Nhà phố 3 tầng, shophouse, khách sạn – resort',
			'hh_p_address'       => 'Chân phía Nam cầu Cửa Đại, ven sông Thu Bồn, xã Duy Nghĩa, TP. Đà Nẵng (trước 1/7/2025 thuộc Duy Xuyên, Quảng Nam)',
			'hh_p_scale'         => 'Khoảng 19,34 ha',
			'hh_p_units'         => 'Khoảng 420 nhà phố 3 tầng và 30 căn thương mại dịch vụ; khách sạn Fivitel 240 phòng, resort Fivires 140 phòng',
			'hh_p_highlights'    => "Chân cầu Cửa Đại, ven sông Thu Bồn – cách phố cổ Hội An khoảng 5 km\nNhà phố 3 tầng kiến trúc phố cổ, phổ biến 100 m² (5 × 20 m)\nKhách sạn 4 sao Fivitel và resort 5 sao Fivires (gần 750 tỷ) khởi công 3/9/2025\nĐã có cơ sở lưu trú, nhà hàng, bến du thuyền – hợp kinh doanh homestay\nĐiểm đầu tuyến xe buýt Hội An – Mỹ Sơn – Đông Giang",
		);
		$fix = array();
		foreach ( $new as $key => $value ) {
			if ( isset( $p['meta'][ $key ] ) && $p['meta'][ $key ] !== $value ) {
				$fix[ $key ] = array( $p['meta'][ $key ] );
			}
		}
		$fix['hh_p_status'][] = 'dang-mo-ban';
		// Ảnh chủ đầu tư anh Hiệp gửi 13/10/2026 (đã che logo, số điện thoại đơn vị phân phối) thay sơ đồ minh hoạ.
		$nhac_imgs = "plugin:img/vinh-an-hoa/nam-hoi-an-city-phoi-canh-tren-cao.jpg | Phối cảnh Nam Hội An City nhìn từ trên cao bên sông Thu Bồn, chân cầu Cửa Đại | đại diện\n"
			. "plugin:img/vinh-an-hoa/nam-hoi-an-city-phoi-canh-chu-thich.jpg | Phối cảnh Nam Hội An City: khách sạn 5 sao cao tầng, khách sạn 4 sao Fivitel, khách sạn thấp tầng, bến du thuyền, thương mại ven sông | thư viện\n"
			. "plugin:img/vinh-an-hoa/nam-hoi-an-city-mat-bang-phan-lo.jpg | Mặt bằng phân lô Nam Hội An City: lô thương mại ven sông Thu Bồn, nhà phố CL1 – CL12, công viên, clubhouse | tổng thể\n"
			. "plugin:img/vinh-an-hoa/nam-hoi-an-city-thong-tin.jpg | Nam Hội An City – thông tin và giá tham khảo | thư viện";
		$fix['hh_p_image_links'] = array( "plugin:img/vinh-an-hoa/nam-hoi-an-city.jpg | Sơ đồ minh hoạ Nam Hội An City chân cầu Cửa Đại | đại diện\nplugin:img/vinh-an-hoa/nam-hoi-an-city-thong-tin.jpg | Nam Hội An City – thông tin và giá tham khảo | thư viện" );
		$p['fix_excerpt'] = $p['excerpt'];
		$p['excerpt']     = 'Nhà phố 3 tầng kiến trúc phố cổ chân cầu Cửa Đại (Khu đô thị Nồi Rang, 19,34 ha) của FVG, cách phố cổ Hội An 5 km; giá chuyển nhượng khoảng 35 – 62 triệu/m² (tin rao 2025 – 2026).';
		$p['fix_meta']    = $fix;
		$p['meta']        = array_merge(
			$p['meta'],
			$new,
			array(
				'hh_p_legal'         => 'Quy hoạch 1/500 Khu đô thị Nồi Rang (2017, bổ sung 2019); tin rao ghi sổ từng lô – cần kiểm tra thời hạn sử dụng đất trên sổ',
				'hh_p_unit_area'     => 'Đất phổ biến 100 m² (5 × 20 m), sàn 240 – 300 m²',
				'hh_p_density'       => '40%',
				'hh_p_resale_price'  => '35 – 62 triệu/m² (tin rao 2025 – 2026)',
				'hh_p_resale_note'   => 'Khoảng giá tổng hợp từ tin rao chuyển nhượng công khai 2025 – 2026, chỉ để tham khảo – không phải giá giao dịch. Nhà sát sông, đã hoàn thiện nội thất, đang cho thuê có giá cao hơn nhà xây thô.',
				'hh_p_rent_price'    => 'Nhà 3 tầng 100 m² khoảng 25 triệu/tháng (tham khảo một tin cho thuê)',
				'hh_p_progress'      => "10/2017 | Phê duyệt quy hoạch 1/500 Khu đô thị Nồi Rang (14,41 ha)\n10/7/2020 | Tỉnh Quảng Nam chấp thuận chuyển nhượng dự án cho Công ty CP Đầu tư Chu Lai Hội An (FVG)\n4/2025 | Duyệt tuyến xe buýt Hội An – Mỹ Sơn – Đông Giang, điểm đầu tại Nam Hội An City\n3/9/2025 | Khởi công khách sạn Fivitel (12 tầng, 240 phòng) và resort Fivires (140 phòng)\nCuối 2026 | Dự kiến hoàn thành Fivitel, Fivires",
				'hh_p_image_links'   => $nhac_imgs,
				'hh_p_design_desc'   => 'Theo mặt bằng phân lô, dự án trải dọc bờ Nam sông Thu Bồn: dãy lô thương mại dịch vụ ven sông (TM4-1 đến TM4-4) xen các ô cây xanh, bến du thuyền ở đầu dự án; phía trong là các block nhà phố liền kề CL1 – CL12 trên các tuyến Trường Giang 1 – 10 (lòng đường 7,5 m và 10,5 m, vỉa hè 4 – 5 m); công viên trung tâm và khu thương mại TM3 ở giữa; khu clubhouse hồ bơi và khu thể thao (sân tennis, sân bóng, bãi đỗ xe) ở phía Đông; dãy lô cuối giáp khu dân cư hiện hữu có các công viên xen giữa. Phối cảnh chủ đầu tư thể hiện khách sạn 5 sao cao tầng, khách sạn 4 sao Fivitel, khu khách sạn thấp tầng, bến du thuyền và dãy thương mại ven sông.',
				'hh_p_faq'           => "Nam Hội An City thuộc Đà Nẵng hay Quảng Nam? | Từ 1/7/2025 dự án thuộc xã Duy Nghĩa, TP. Đà Nẵng (trước là huyện Duy Xuyên, Quảng Nam).\nTên pháp lý của Nam Hội An City là gì? | Khu đô thị Nồi Rang. Dự án do Đạt Phương làm chủ đầu tư ban đầu, được tỉnh Quảng Nam chấp thuận chuyển nhượng cho Công ty CP Đầu tư Chu Lai Hội An (FVG) ngày 10/7/2020.\nGiá nhà Nam Hội An City bao nhiêu? | Tin rao 2025 – 2026: nhà 3 tầng 100 m² khoảng 3,4 – 4,2 tỷ, có căn tới 6,2 tỷ; tương đương khoảng 35 – 62 triệu/m² (tham khảo).\nNam Hội An City có những gì đang xây? | Khách sạn 4 sao Fivitel (240 phòng) và resort 5 sao Fivires (140 phòng), tổng gần 750 tỷ, khởi công 3/9/2025, dự kiến xong cuối 2026.",
			)
		);
		$p['content'] = '<p><strong>Nam Hội An City</strong> là khu phố thương mại – nghỉ dưỡng ven sông Thu Bồn, ngay chân phía Nam <strong>cầu Cửa Đại</strong>, cách phố cổ Hội An khoảng 5 km. Tên pháp lý của dự án là <strong>Khu đô thị Nồi Rang</strong>, quy mô khoảng 19,34 ha, nay thuộc xã Duy Nghĩa, TP. Đà Nẵng (trước 1/7/2025 thuộc Duy Xuyên, Quảng Nam). Chủ đầu tư hiện nay là <strong>Công ty CP Đầu tư Chu Lai Hội An</strong>, thành viên FVG Group – cùng nhóm phát triển <a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a>.</p>
<h2>Lịch sử và pháp lý</h2>
<ul>
<li>Quy hoạch 1/500 Khu đô thị Nồi Rang được phê duyệt tháng 10/2017 (14,41 ha), năm 2019 bổ sung khoảng 4,93 ha kè – tổng khoảng 19,34 ha.</li>
<li>Quỹ đất ban đầu thuộc nhóm Đạt Phương (thanh toán hợp đồng BT cầu Đế Võng); ngày 10/7/2020 UBND tỉnh Quảng Nam ban hành QĐ 1840/QĐ-UBND chấp thuận chuyển nhượng dự án cho Công ty CP Đầu tư Chu Lai Hội An (FVG).</li>
<li>Tin rao ghi sổ từng lô; người mua cần xem sổ bản gốc và thời hạn sử dụng đất ghi trên sổ.</li>
</ul>
<h2>Sản phẩm</h2>
<ul>
<li>Khoảng 420 nhà phố 3 tầng kiến trúc phố cổ và 30 căn thương mại dịch vụ; mật độ xây dựng 40%.</li>
<li>Đất phổ biến 100 m² (5 × 20 m), sàn 240 – 300 m², 5 phòng ngủ – hợp ở kết hợp homestay, kinh doanh.</li>
<li>Đường nội bộ 7,7 – 10,5 m; tiện ích đã có theo chủ đầu tư: nhà hàng, khách sạn, công viên, hồ bơi, khu thể thao, bến du thuyền dưới chân cầu Cửa Đại.</li>
</ul>
<h2>Khách sạn Fivitel và resort Fivires</h2>
<p>Ngày 3/9/2025, FVG khởi công khách sạn 4 sao <strong>Fivitel Nam Hội An</strong> (12 tầng, 240 phòng, 325,8 tỷ) và resort 5 sao <strong>Fivires</strong> (140 phòng, 423 tỷ) – tổng gần 750 tỷ đồng, dự kiến hoàn thành cuối năm 2026 (báo Nhân Dân, Nhà Đầu tư). Khi đi vào hoạt động, lượng khách lưu trú tại chỗ sẽ hỗ trợ nhà phố kinh doanh trong khu.</p>
<h2>Giá chuyển nhượng Nam Hội An City (tin rao)</h2>
<table><thead><tr><th>Sản phẩm</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Nhà 3 tầng</td><td>100 m²</td><td>3,4 – 3,5 tỷ</td><td>Có căn đang cho thuê khoảng 25 triệu/tháng</td></tr>
<tr><td>Shophouse đường Trường Giang 2</td><td>100 m²</td><td>3,65 tỷ</td><td>Tin rao</td></tr>
<tr><td>Nhà 3 tầng sát sông</td><td>103 m²</td><td>4,2 tỷ</td><td>Tin 9/2026</td></tr>
<tr><td>Nhà vị trí đẹp</td><td>100 m²</td><td>6,2 tỷ</td><td>Tin 9/2026</td></tr>
<tr><td>Lô lớn</td><td>240 m²</td><td>7 tỷ</td><td>Tin 2025</td></tr>
</tbody></table>
<p>Mặt bằng khoảng <strong>35 – 62 triệu/m²</strong> (3,4 – 6,2 tỷ/căn 100 m²), so với giá mở bán khoảng 2,55 – 3,6 tỷ/căn những đợt đầu. Đây là giá rao tham khảo, không phải giá giao dịch.</p>
<h2>Lưu ý khi mua</h2>
<p>Khu vực bờ sông Thu Bồn phía Duy Nghĩa từng sạt lở mạnh mùa mưa bão 2025; TP. Đà Nẵng đã duyệt dự án kè khẩn cấp hơn 498 tỷ đồng. Nên xem vị trí căn so với bờ sông, kiểm tra sổ và hiện trạng hoàn thiện (nhiều căn bàn giao xây thô bên trong) trước khi xuống tiền.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn chuyển nhượng, cho thuê đang có thật.</p>';
		$old_content  = $p['content'];
		$p['content'] = str_replace( '<h2>Khách sạn Fivitel và resort Fivires</h2>', '<h2>Mặt bằng phân lô</h2>
<p>Dự án trải dọc bờ Nam sông Thu Bồn: hàng đầu là dãy lô <strong>thương mại dịch vụ ven sông</strong> xen các ô cây xanh và <strong>bến du thuyền</strong>; phía trong là các block nhà phố liền kề trên các tuyến Trường Giang 1 – 10 (lòng đường 7,5 – 10,5 m); giữa dự án có công viên trung tâm, phía Đông là clubhouse hồ bơi và khu thể thao (sân tennis, sân bóng). Xem mặt bằng và phối cảnh tại mục Mặt bằng, Hình ảnh.</p>
<h2>Khách sạn Fivitel và resort Fivires</h2>', $old_content );
		$p['fix_content'] = array( $old_content );
		$p['sources'] = array_values( array_unique( array_merge( $p['sources'] ?? array(), array(
			'https://cafeland.vn/quy-hoach/chuyen-nhuong-du-an-khu-do-thi-noi-rang-nam-hoi-an-city-88925.html',
			'https://nhandan.vn/da-nang-khoi-cong-du-an-tai-cua-ngo-cung-duong-di-san-van-hoa-post905663.html',
			'https://nhadautu.vn/tap-doan-fvg-khoi-cong-to-hop-khach-san-resort-750-ty-o-da-nang-d98817.html',
			'https://thanhnien.vn/nam-hoi-an-city-khoi-dau-cua-hanh-trinh-di-san-185251216171959135.htm',
			'https://bds68.com.vn/nha-dat-ban/quang-nam/duy-xuyen/nam-hoi-an-city',
			'https://batdongsan.com.vn/nha-dat-ban-nam-hoi-an-city',
			'https://nhandan.vn/da-nang-dau-tu-gan-500-ty-dong-khac-phuc-sat-lo-song-thu-bon-va-bo-bien-hoi-an-post969486.html',
		) ) ) );
		$projects[ $i ] = $p;
	}
	return $projects;
}
