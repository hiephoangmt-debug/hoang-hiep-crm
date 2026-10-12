<?php
/**
 * Đất nền Điện Ngọc (nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng): 8 khu đô thị / khu dân cư
 * trong Đô thị mới Điện Nam – Điện Ngọc – tổng hợp báo chí, quy hoạch và tin rao công khai (10/2026).
 * Giá là khoảng giá rao tham khảo (không phải giá giao dịch, không phải bảng giá chủ đầu tư);
 * không chép tên, số điện thoại người đăng tin.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Danh sách liên kết chéo giữa các dự án đất nền Điện Ngọc (dùng cuối mỗi trang).
 */
function hh_dien_ngoc_links( $skip ) {
	$all = array(
		'khu-do-thi-1a-1b-dien-ngoc'    => 'Khu đô thị 1A – 1B Điện Ngọc (gần ĐH FPT)',
		'khu-do-thi-so-3-dien-ngoc'     => 'Khu đô thị số 3 Điện Nam – Điện Ngọc',
		'khu-do-thi-7b-dien-ngoc'       => 'Khu đô thị 7B Điện Ngọc (Coco Center House, Sentosa City)',
		'khu-do-thi-so-9-dien-ngoc'     => 'Khu đô thị số 9 Điện Ngọc',
		'pho-cho-dien-ngoc'             => 'Phố chợ Điện Ngọc',
		'sentosa-riverside-dien-ngoc'   => 'Sentosa Riverside (Peaceful Land)',
		'gaia-city-dien-ngoc'           => 'GAIA City Điện Ngọc',
		'tropical-palm-dien-ngoc'       => 'Tropical Palm (Ngọc Dương Riverside)',
		'one-world-regency'             => 'One World Regency',
		'fpt-city-da-nang'              => 'FPT City Đà Nẵng',
	);
	unset( $all[ $skip ] );
	$li = '';
	foreach ( $all as $slug => $name ) {
		$li .= '<li><a href="/du-an/' . $slug . '/">' . $name . '</a></li>';
	}
	return '<h2>Các dự án đất nền Điện Ngọc khác</h2><ul>' . $li . '</ul>'
		. '<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách lô đang bán thật, kiểm tra sổ đỏ, quy hoạch và đi xem đất trực tiếp tại Điện Ngọc.</p>';
}

add_filter( 'hh_project_dataset', 'hh_dataset_dat_nen_dien_ngoc', 20 );
function hh_dataset_dat_nen_dien_ngoc( $projects ) {
	$note = 'Khoảng giá tổng hợp từ tin rao công khai (chủ yếu 2026), chỉ để tham khảo mặt bằng giá – không phải giá giao dịch thành công hay bảng giá chủ đầu tư. Giá phụ thuộc độ rộng đường, lô góc, hướng, khoảng cách tới ĐH FPT – sông Cổ Cò và tình trạng sổ của từng lô; liên hệ để nhận danh sách lô đang bán thật.';
	$area = 'Phường Điện Bàn Đông, TP. Đà Nẵng (trước 1/7/2025 là phường Điện Ngọc, thị xã Điện Bàn, Quảng Nam)';
	$img  = function ( $slug, $alt ) {
		return 'plugin:img/dien-ngoc/' . $slug . '.jpg | Sơ đồ minh hoạ ' . $alt . ' | đại diện' . "\n"
			. 'plugin:img/dien-ngoc/' . $slug . '-thong-tin.jpg | ' . $alt . ' | thư viện';
	};

	// 1. Khu đô thị 1A – 1B.
	$projects[] = array(
		'slug'    => 'khu-do-thi-1a-1b-dien-ngoc',
		'title'   => 'Khu đô thị 1A 1B Điện Ngọc',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Hai khu đất nền sát ĐH FPT và FPT City, trục Trịnh Hoài Đức – Trần Đại Nghĩa; mặt bằng giá rao cao nhất Điện Ngọc, khoảng 27 – 40 triệu/m² (tham khảo 2026).',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'CTCP ĐT&XD 501 (khu 1A), CTCP ĐTXD 545 (khu 1B)',
			'hh_p_type'          => 'Đất nền nhà phố, đất biệt thự',
			'hh_p_address'       => 'Trục Trịnh Hoài Đức – Trần Đại Nghĩa – Đào Tấn, gần ĐH FPT, ' . $area,
			'hh_p_map_address'   => 'Trịnh Hoài Đức, Điện Ngọc, Điện Bàn',
			'hh_p_scale'         => 'Khu 1B khoảng 36,5 ha',
			'hh_p_unit_area'     => 'Phổ biến 122,5 – 153 m²',
			'hh_p_legal'         => 'Sổ đỏ từng lô (theo tin rao)',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_highlights'    => "Sát ĐH FPT, FPT City và ĐH Y Phan Châu Trinh – nhu cầu thuê trọ, kinh doanh lớn\nTrục Trịnh Hoài Đức rộng 23,25 m, đường nội khu 17,5 – 23,5 m\nĐất ở đô thị, sổ từng lô theo tin rao\nNằm trong Đô thị mới Điện Nam – Điện Ngọc, giáp ranh Ngũ Hành Sơn",
			'hh_p_location_desc' => 'Khu đô thị 1A nằm trên trục Trần Đại Nghĩa – Trịnh Hoài Đức; khu 1B giáp FPT City và ĐH FPT, nhiều lô trên Trịnh Hoài Đức hoặc Đào Tấn chỉ cách cổng ĐH FPT khoảng 200 – 300 m. Cả hai thuộc chuỗi khu đô thị trong quy hoạch Đô thị mới Điện Nam – Điện Ngọc, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.',
			'hh_p_connections'   => "Khoảng 200 – 300 m | ĐH FPT Đà Nẵng\nLiền kề | FPT City Đà Nẵng\nGần | ĐH Y Phan Châu Trinh\nQua Trần Đại Nghĩa | Ngũ Hành Sơn, trung tâm Đà Nẵng",
			'hh_p_amenities_out' => "ĐH FPT, FPT City\nĐH Y Phan Châu Trinh\nCông viên trong khu\nSông Cổ Cò, biển Viêm Đông",
			'hh_p_resale_price'  => '27 – 40 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'khu-do-thi-1a-1b-dien-ngoc', 'Khu đô thị 1A – 1B Điện Ngọc gần ĐH FPT – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Khu đô thị 1A – 1B Điện Ngọc ở đâu? | Trên trục Trịnh Hoài Đức – Trần Đại Nghĩa, sát ĐH FPT và FPT City; nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.\nGiá đất 1B Điện Ngọc bao nhiêu? | Theo tin rao 2026, lô 139 – 150 m² khoảng 5,35 – 5,9 tỷ (khoảng 36 – 39 triệu/m²); có lô rẻ hơn ở đường nội khu. Đây là giá rao tham khảo.\nĐất 1A – 1B có sổ đỏ chưa? | Tin rao ghi sổ đỏ từng lô, đất ở đô thị. Trước khi đặt cọc cần xem sổ bản gốc và kiểm tra quy hoạch tại phường.",
		),
		'content' => '<p><strong>Khu đô thị 1A và 1B Điện Ngọc</strong> là hai khu đất nền nằm sát <strong>ĐH FPT</strong> và <strong>FPT City</strong>, trên trục Trịnh Hoài Đức – Trần Đại Nghĩa, thuộc Đô thị mới Điện Nam – Điện Ngọc. Từ 1/7/2025, khu vực này thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Nhờ vị trí cạnh các trường đại học, đây là khu có mặt bằng giá rao cao nhất trong các dự án đất nền Điện Ngọc.</p>
<h2>Vị trí và quy mô</h2>
<ul>
<li><strong>Khu 1A</strong>: trục Trần Đại Nghĩa – Trịnh Hoài Đức (đường quy hoạch 23,25 m), chủ đầu tư được ghi là Công ty CP Đầu tư và Xây dựng 501.</li>
<li><strong>Khu 1B</strong>: giáp FPT City và ĐH FPT, có lô mặt tiền Đào Tấn nhìn công viên; trang môi giới ghi quy mô khoảng 36,5 ha, chủ đầu tư Công ty CP Đầu tư Xây dựng 545 (chưa có nguồn thứ hai xác nhận).</li>
<li>Lô phổ biến ngang 6 m, 139 – 153 m²; lô lớn 281 – 392 m². Đường nội khu 17,5 m và 23,5 m.</li>
</ul>
<h2>Giá đất 1A – 1B Điện Ngọc (tin rao 2026)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Khu 1B, đường 7 m</td><td>142 m²</td><td>5,4 tỷ (khoảng 38 triệu/m²)</td><td>Tin 7/2026</td></tr>
<tr><td>Khu 1B, mặt tiền Trịnh Hoài Đức</td><td>139 m²</td><td>5,9 tỷ</td><td>Tin 7/2026</td></tr>
<tr><td>Khu 1B, block E3</td><td>150 m²</td><td>5,35 tỷ</td><td>2026</td></tr>
<tr><td>Khu 1A, đường 23,25 m</td><td>138 m²</td><td>3,75 – 4,6 tỷ (27 – 33 triệu/m²)</td><td>Tin rao</td></tr>
<tr><td>Khu 1A, mặt tiền 16 m</td><td>384 m²</td><td>8,5 tỷ</td><td>Lô lớn</td></tr>
</tbody></table>
<p>Mặt bằng chung khoảng <strong>27 – 40 triệu/m²</strong>, lô góc có tin rao tới khoảng 51 triệu/m². Năm 2021 lô 136 – 138 m² đường 23,25 m chỉ khoảng 2,35 – 2,65 tỷ, nên giá đã tăng mạnh. Đây là giá rao tham khảo, không phải giá giao dịch.</p>
<h2>Phù hợp với ai</h2>
<p>Lô gần ĐH FPT hợp với người mua xây nhà cho thuê sinh viên, giảng viên, chuyên gia hoặc kinh doanh dịch vụ; lô đường lớn hợp làm văn phòng, cửa hàng. Cần kiểm tra kỹ sổ đỏ, chỉ giới xây dựng và quy hoạch từng lô trước khi giao dịch.</p>' . hh_dien_ngoc_links( 'khu-do-thi-1a-1b-dien-ngoc' ),
		'sources' => array(
			'https://batdongsan.com.vn/ban-dat-nen-du-an-khu-do-thi-so-1a',
			'https://baodangland.vn/khu-do-thi-1b-dien-ngoc/',
			'https://ngocphatland.com/dat-dien-ngoc/khu-do-thi-1b-dien-ngoc/',
			'https://san43.com/nha-dat-ban-prj-khu-do-thi-1b-tai-thi-xa-dien-ban.html',
			'https://dantri.com.vn/nha-dat/khu-do-thi-moi-dien-nam-dien-ngoc-dong-luc-cat-canh-cua-do-thi-mien-trung-20170329110908935.htm',
		),
	);

	// 2. Khu đô thị số 3.
	$projects[] = array(
		'slug'    => 'khu-do-thi-so-3-dien-ngoc',
		'title'   => 'Khu đô thị số 3 Điện Nam – Điện Ngọc',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị 36,5 ha của Vinaconex 25 giữa FPT City, sông Cổ Cò và chợ Điện Ngọc, có ĐH Phan Châu Trinh và hồ sinh thái 3,6 ha; giá rao khoảng 25 – 38 triệu/m².',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Công ty CP Vinaconex 25',
			'hh_p_type'          => 'Đất nền nhà phố, đất biệt thự',
			'hh_p_address'       => 'Đường Nam Trân, Phan Huy Chú, Lê Trí Viễn…, ' . $area,
			'hh_p_map_address'   => 'Khu đô thị số 3 Điện Nam Điện Ngọc',
			'hh_p_scale'         => '36,5 ha',
			'hh_p_unit_area'     => 'Phổ biến 121 – 157 m²',
			'hh_p_legal'         => 'Sổ đỏ từng lô (theo tin rao)',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_highlights'    => "Quy mô 36,5 ha, chủ đầu tư Vinaconex 25\nTrong khu có ĐH Phan Châu Trinh (9,3 ha) và hồ sinh thái 3,6 ha\nGiáp FPT City, khu 1A – 1B, sông Cổ Cò và chợ Điện Ngọc\nĐường nội khu 7,5 m, 17,5 m, 22,5 m; trục chính 48 m Đà Nẵng – Hội An",
			'hh_p_location_desc' => 'Theo quy hoạch 1/500, khu đô thị số 3 phía Bắc giáp khu 1B và FPT City, phía Tây giáp khu 1A, phía Đông giáp khu số 4 và sông Cổ Cò, phía Nam giáp chợ Điện Ngọc và khu đô thị số 9. Dự án nằm trên trục đường 48 m nối Đà Nẵng – Hội An, cách trung tâm Đà Nẵng khoảng 8 km qua Trần Đại Nghĩa, cách biển khoảng 3 km.',
			'hh_p_connections'   => "Khoảng 8 km | Trung tâm Đà Nẵng (qua Trần Đại Nghĩa)\nKhoảng 3 km | Biển Viêm Đông – Hà My\nKhoảng 10 km | Phố cổ Hội An\nKhoảng 300 m | ĐH FPT (lô đường Nam Trân)",
			'hh_p_amenities_in'  => "ĐH Phan Châu Trinh (9,3 ha)\nHồ sinh thái 3,6 ha\nQuảng trường hồ sinh thái – công viên trung tâm gần 2 ha\nCông viên xen giữa các block",
			'hh_p_amenities_out' => "FPT City, ĐH FPT\nChợ Điện Ngọc\nSân golf, Cocobay\nSông Cổ Cò",
			'hh_p_resale_price'  => '25 – 38 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'khu-do-thi-so-3-dien-ngoc', 'Khu đô thị số 3 Điện Nam – Điện Ngọc – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Khu đô thị số 3 Điện Ngọc của chủ đầu tư nào? | Công ty CP Vinaconex 25; quy hoạch được UBND tỉnh Quảng Nam phê duyệt theo QĐ 5325/QĐ-UB ngày 27/12/2004.\nGiá đất khu đô thị số 3 Điện Ngọc bao nhiêu? | Tin rao 8 – 9/2026: lô 121 – 122 m² đường Phan Huy Chú, Lê Trí Viễn khoảng 3,05 – 4,15 tỷ; lô 151 m² khoảng 4,4 – 4,7 tỷ. Đây là giá rao tham khảo.\nKhu số 3 gần những gì? | Trong khu có ĐH Phan Châu Trinh, hồ sinh thái 3,6 ha; giáp FPT City, ĐH FPT, chợ Điện Ngọc và sông Cổ Cò.",
		),
		'content' => '<p><strong>Khu đô thị số 3 Điện Nam – Điện Ngọc</strong> là khu đất nền quy mô <strong>36,5 ha</strong> (gần 20 ha đất ở) do <strong>Công ty CP Vinaconex 25</strong> làm chủ đầu tư, được UBND tỉnh Quảng Nam phê duyệt quy hoạch theo QĐ 5325/QĐ-UB ngày 27/12/2004. Khu nằm giữa FPT City, sông Cổ Cò và chợ Điện Ngọc, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.</p>
<h2>Vị trí và quy hoạch</h2>
<ul>
<li>Bắc giáp khu 1B và FPT City; Tây giáp khu 1A; Đông giáp khu số 4 và sông Cổ Cò; Nam giáp chợ Điện Ngọc và khu đô thị số 9 (theo quy hoạch 1/500).</li>
<li>Nằm trên trục đường 48 m nối Đà Nẵng – Hội An; cách trung tâm Đà Nẵng khoảng 8 km, biển khoảng 3 km, phố cổ Hội An khoảng 10 km.</li>
<li>Đường nội khu 7,5 m, 17,5 m và 22,5 m (lòng đường 10,5 m, vỉa hè mỗi bên 6 m); các tuyến hay gặp trong tin rao: Nam Trân, Phan Huy Chú, Lê Trí Viễn.</li>
<li>Trong khu có <strong>ĐH Phan Châu Trinh</strong> (9,3 ha), hồ sinh thái 3,6 ha và quảng trường – công viên trung tâm gần 2 ha.</li>
</ul>
<h2>Giá đất khu đô thị số 3 Điện Ngọc (tin rao)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Đường Phan Huy Chú / Lê Trí Viễn</td><td>121 – 122 m²</td><td>3,05 – 4,15 tỷ</td><td>Tin 8 – 9/2026</td></tr>
<tr><td>Mặt tiền Lê Trí Viễn</td><td>123 m²</td><td>4,29 tỷ</td><td>Tin rao</td></tr>
<tr><td>Đường 7,5 m, block E3</td><td>151 m²</td><td>4,4 – 4,7 tỷ (khoảng 31 triệu/m²)</td><td>Tin rao</td></tr>
<tr><td>Sát FPT City, ngang 7 m</td><td>157 m²</td><td>2,9 tỷ</td><td>Tin rao, cần xác minh</td></tr>
<tr><td>Lô góc đối diện ĐH Phan Châu Trinh</td><td>290 m²</td><td>9,5 tỷ</td><td>Lô góc</td></tr>
</tbody></table>
<p>Mặt bằng rao bán phổ biến khoảng <strong>25 – 38 triệu/m²</strong>; khoảng rộng hơn (10 – 54 triệu/m²) trên các trang rao vặt gồm cả tin cũ và lô đặc biệt. Giá chỉ để tham khảo.</p>
<h2>Lưu ý khi mua</h2>
<p>Khu số 3 đã hình thành lâu, nhiều lô đã chuyển nhượng qua nhiều chủ. Trước khi đặt cọc nên xem sổ bản gốc, đối chiếu số thửa – tờ bản đồ, chỉ giới xây dựng và hiện trạng hạ tầng tuyến đường của lô.</p>' . hh_dien_ngoc_links( 'khu-do-thi-so-3-dien-ngoc' ),
		'sources' => array(
			'https://batdongsan.com.vn/du-an-khu-do-thi-moi-dien-ban-qna/khu-do-thi-so-3-dien-nam-dien-ngoc-pj1232',
			'https://batdongsan.com.vn/ban-dat-nen-du-an-khu-do-thi-so-3-dien-nam-dien-ngoc',
			'https://ngocphatland.com/khu-do-thi-so-3-dien-ngoc/1-500-khu-do-thi-so-3-dien-ngoc/',
			'https://san43.com/ban-dat-prj-khu-do-thi-so-3-tai-thi-xa-dien-ban.html',
			'https://baodangland.vn/khu-do-thi-so-3-dien-ngoc/',
		),
	);

	// 3. Khu đô thị 7B.
	$projects[] = array(
		'slug'    => 'khu-do-thi-7b-dien-ngoc',
		'title'   => 'Khu đô thị 7B Điện Ngọc (Coco Center House, Sentosa City)',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị 7B (Bách Đạt 2) ven sông Cổ Cò, đối diện sân golf và Cocobay, bán dưới tên Sentosa City và Coco Center House; lô 87,5 – 275 m², giá rao khoảng 14 – 28 triệu/m².',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_name'          => 'Sentosa City, Coco Center House (Coco Smart House) – KĐT Bách Đạt 2',
			'hh_p_developer'     => 'Nhóm Bách Đạt (Bách Đạt, Bách Đạt An)',
			'hh_p_type'          => 'Đất nền liền kề, đất biệt thự',
			'hh_p_address'       => 'Ven sông Cổ Cò, gần ĐT603A – Trần Đại Nghĩa, ' . $area,
			'hh_p_map_address'   => 'Khu đô thị 7B Điện Ngọc',
			'hh_p_scale'         => 'Khoảng 29,7 ha',
			'hh_p_unit_area'     => 'Phổ biến 87,5 – 150 m²',
			'hh_p_legal'         => 'Sổ từng lô (theo tin rao) – cần kiểm tra',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_highlights'    => "Mặt tiền sông Cổ Cò, đối diện sân golf và Cocobay\nKhoảng 29,7 ha, đường quy hoạch 17,5 – 33 m, điện ngầm\nĐã có nhiều nhà xây, giao dịch chuyển nhượng sôi động\nMức giá vào tiền dễ hơn khu gần ĐH FPT",
			'hh_p_location_desc' => 'Khu đô thị 7B nằm ven sông Cổ Cò, đối diện các sân golf và Cocobay; kết nối ĐT603A, đường Trần Đại Nghĩa và tuyến ven biển Trường Sa – Lạc Long Quân. Các nguồn mô tả ranh giới khác nhau, phổ biến: Bắc giáp khu 6B (Green City), Đông giáp sông Cổ Cò, Tây hướng về Trần Đại Nghĩa và công viên trung tâm 11 ha.',
			'hh_p_connections'   => "Khoảng 500 m | Sân golf Montgomerie Links\nKhoảng 1,2 km | Cocobay\nKhoảng 1 – 3 km | Bãi tắm Viêm Đông\nKhoảng 2,5 – 4 km | Làng Đại học, ĐH FPT\nKhoảng 30 phút | Sân bay Đà Nẵng",
			'hh_p_amenities_in'  => "Công viên, quảng trường\nLối dạo ven sông Cổ Cò\nĐất trường học, y tế, thương mại theo quy hoạch",
			'hh_p_amenities_out' => "Sân golf Montgomerie Links, Đà Nẵng Golf\nCocobay\nBiển Viêm Đông – Hà My\nĐH FPT, Làng Đại học",
			'hh_p_resale_price'  => '14 – 28 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'khu-do-thi-7b-dien-ngoc', 'Khu đô thị 7B Điện Ngọc Coco Center House Sentosa City – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Khu đô thị 7B, Coco Center House và Sentosa City có phải một dự án? | Có. Đây là cùng khu đô thị số 7B (KĐT Bách Đạt 2) ở Điện Ngọc, được phân phối dưới hai tên thương mại Sentosa City và Coco Center House.\nGiá đất 7B Điện Ngọc bao nhiêu? | Tin rao 3 – 10/2026: lô 87 – 95 m² khoảng 1,6 – 2 tỷ, lô 120 – 137 m² khoảng 2 – 2,85 tỷ, lô 250 – 275 m² khoảng 5,4 – 5,5 tỷ (tham khảo).\nCần lưu ý gì về pháp lý? | Tin rao ghi sổ từng lô, nhưng nên xem sổ bản gốc và tra cứu tình trạng thửa đất tại phường, vì nhóm chủ đầu tư từng bị xử lý chậm tiến độ ở dự án khác.",
		),
		'content' => '<p><strong>Khu đô thị 7B Điện Nam – Điện Ngọc</strong> (còn gọi KĐT Bách Đạt 2) là khu đất nền ven <strong>sông Cổ Cò</strong>, đối diện sân golf và Cocobay, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Dự án từng được phân phối dưới hai tên thương mại: <strong>Sentosa City</strong> và <strong>Coco Center House</strong> (Coco Smart House) – thực chất là cùng một khu.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>Khoảng 29,7 ha (297.800 m²); một số nguồn ghi 20,5 – 25 ha.</li>
<li>Đất nền liền kề lô 5 × 25 m (lô kinh doanh 5 × 27 m), đất biệt thự và khu chỉnh trang – tái định cư.</li>
<li>Diện tích phổ biến 87,5 – 150 m²; lô góc, biệt thự 200 – 275 m².</li>
<li>Đường quy hoạch 17,5 m, 20,5 m, 27 m và 33 m; điện ngầm; đã có khá nhiều nhà xây.</li>
</ul>
<h2>Giá đất khu đô thị 7B Điện Ngọc (tin rao)</h2>
<table><thead><tr><th>Nhóm lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Lô nhỏ</td><td>87 – 95 m²</td><td>1,6 – 2 tỷ</td><td>3/2026</td></tr>
<tr><td>Lô phổ biến</td><td>120 – 137 m²</td><td>2 – 2,85 tỷ</td><td>3/2026</td></tr>
<tr><td>Đường 20,5 m</td><td>137,5 m²</td><td>2,7 tỷ</td><td>Tin 1/10/2026</td></tr>
<tr><td>Lô lớn</td><td>150 – 187 m²</td><td>2,3 – 3,5 tỷ</td><td>3/2026</td></tr>
<tr><td>Lô góc, biệt thự</td><td>250 – 275 m²</td><td>5,4 – 5,5 tỷ</td><td>3/2026</td></tr>
</tbody></table>
<p>Mặt bằng khoảng <strong>14 – 28 triệu/m²</strong>, thấp hơn rõ so với khu 1A – 1B gần ĐH FPT. Đây là giá rao tham khảo.</p>
<h2>Lưu ý pháp lý</h2>
<p>Các trang phân phối ghi hạ tầng hoàn thiện và sổ đỏ từng lô. Tuy vậy, Công ty CP Bách Đạt An – đơn vị trong nhóm chủ đầu tư – từng bị đề xuất chấm dứt một số dự án do chậm tiến độ (2023). Người mua nên xem sổ bản gốc, tra cứu thửa đất tại phường và kiểm tra lô có đang thế chấp hay không trước khi đặt cọc.</p>' . hh_dien_ngoc_links( 'khu-do-thi-7b-dien-ngoc' ),
		'sources' => array(
			'https://muaban.net/blog/khu-do-thi-7b-dien-ngoc-610191/',
			'https://homedy.com/khu-do-thi-bach-dat-2-khu-do-thi-so-7b-dien-nam-dien-ngoc-pj88205583',
			'https://baophapluat.vn/stda-mien-trung-phan-phoi-doc-quyen-sentosa-city-post206435.html',
			'https://guland.vn/du-an/khu-do-thi-coco-center-house-khu-do-thi-bach-dat-2-khu-do-thi-so-7b-dien-nam-dien-ngoc',
			'https://bds68.com.vn/ban-dat-biet-thu-du-an/quang-nam/dien-ban/7-dien-nam-dien-ngoc',
		),
	);

	// 4. Khu đô thị số 9.
	$projects[] = array(
		'slug'    => 'khu-do-thi-so-9-dien-ngoc',
		'title'   => 'Khu đô thị số 9 Điện Ngọc',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị 54,6 ha quanh chợ Điện Ngọc, đông dân cư hiện hữu, giá rao khoảng 19 – 25 triệu/m²; báo chí từng phản ánh dự án chậm nghiệm thu, cần kiểm tra kỹ pháp lý.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Công ty CP Cấp thoát nước Quảng Nam',
			'hh_p_type'          => 'Đất nền, nhà phố',
			'hh_p_address'       => 'Quanh chợ Điện Ngọc, trục Nguyễn Tất Thành – Lê Đỉnh – Trần Hưng Đạo, ' . $area,
			'hh_p_map_address'   => 'Chợ Điện Ngọc, Điện Bàn',
			'hh_p_scale'         => '54,6 ha',
			'hh_p_unit_area'     => 'Phổ biến 110 – 147 m²',
			'hh_p_legal'         => 'Có sổ theo tin rao; dự án từng chậm nghiệm thu',
			'hh_p_start'         => 'Phê duyệt 4/2004, giao đất 11/2005',
			'hh_p_highlights'    => "Quy mô 54,6 ha, chợ Điện Ngọc nằm trong khu\nĐông dân cư hiện hữu (hơn 1.500 hộ), tiện ích sinh hoạt đầy đủ\nGiá vào tiền thấp hơn khu gần ĐH FPT\nGần ĐH FPT, Bệnh viện Phan Châu Trinh",
			'hh_p_location_desc' => 'Khu đô thị số 9 nằm phía Nam khu đô thị số 3, bao quanh chợ Điện Ngọc, trên trục Nguyễn Tất Thành – Lê Đỉnh – Trần Hưng Đạo, gần tượng đài Bảy Dũng sĩ Điện Nam – Điện Ngọc. Phố chợ Điện Ngọc là một phần ở trung tâm khu số 9.',
			'hh_p_connections'   => "Trong khu | Chợ Điện Ngọc\nLiền kề phía Bắc | Khu đô thị số 3, ĐH Phan Châu Trinh\nGần | ĐH FPT, FPT City\nQua Trần Đại Nghĩa | Ngũ Hành Sơn, trung tâm Đà Nẵng",
			'hh_p_amenities_out' => "Chợ Điện Ngọc\nBệnh viện Phan Châu Trinh\nTrường mầm non, phòng khám, ngân hàng\nĐH FPT, FPT City",
			'hh_p_resale_price'  => '19 – 25 triệu/m² (tin rao 2025 – 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'khu-do-thi-so-9-dien-ngoc', 'Khu đô thị số 9 Điện Ngọc – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Khu đô thị số 9 Điện Ngọc của chủ đầu tư nào? | Công ty CP Cấp thoát nước Quảng Nam, quy mô khoảng 54,6 ha; tỉnh phê duyệt hạ tầng 4/2004 và giao đất 11/2005.\nGiá đất khu đô thị số 9 bao nhiêu? | Tin rao: lô 110 m² khoảng 2,1 – 2,95 tỷ, lô 147 m² khoảng 3,4 – 3,65 tỷ, lô mặt trục chính 132 m² khoảng 4,5 tỷ (tham khảo).\nMua đất khu số 9 có rủi ro gì? | Báo chí năm 2022 phản ánh dự án chưa nghiệm thu, bàn giao, một số khu thoát nước kém. Nên chọn lô đã có sổ riêng, xem sổ bản gốc và hỏi phường về hiện trạng hạ tầng tuyến đường.",
		),
		'content' => '<p><strong>Khu đô thị số 9 Điện Nam – Điện Ngọc</strong> là khu dân cư quy mô <strong>54,6 ha</strong> bao quanh chợ Điện Ngọc, do <strong>Công ty CP Cấp thoát nước Quảng Nam</strong> làm chủ đầu tư. Đây là khu đã có đông dân sinh sống (hơn 1.500 hộ theo báo CADN), nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.</p>
<h2>Quy mô và vị trí</h2>
<ul>
<li>Tổng 54,559 ha: đất ở 24,3 ha, hạ tầng 18,4 ha, cây xanh 12,8 ha.</li>
<li>Lô phổ biến 110 m² (4,5 × 24,5 m) và 147 m²; đường nội khu 7,5 m và 17,5 m, lô mặt tiền trên các trục 27 – 40 m.</li>
<li>Phía Bắc giáp khu đô thị số 3; trục chính Nguyễn Tất Thành – Lê Đỉnh – Trần Hưng Đạo; chợ Điện Ngọc và Phố chợ Điện Ngọc nằm trong khu.</li>
</ul>
<h2>Giá đất khu đô thị số 9 Điện Ngọc (tin rao)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Đường 7,5 m gần cổng chợ</td><td>110 m²</td><td>khoảng 2,1 tỷ</td><td>Tin rao</td></tr>
<tr><td>Lô phổ biến</td><td>110 m²</td><td>tới khoảng 2,95 tỷ</td><td>Tin rao</td></tr>
<tr><td>Block E32</td><td>122,5 m²</td><td>2,6 – 2,7 tỷ</td><td>Tin rao</td></tr>
<tr><td>Lô 147 – 168 m²</td><td>147 – 168 m²</td><td>3,4 – 4 tỷ</td><td>Tin rao</td></tr>
<tr><td>Mặt trục chính</td><td>132 m²</td><td>4,5 tỷ</td><td>Tin 3/2026</td></tr>
</tbody></table>
<p>Mặt bằng phổ biến khoảng <strong>19 – 25 triệu/m²</strong>, thấp hơn mức trung bình toàn phường Điện Ngọc (khoảng 27,5 triệu/m² theo Alonhadat 9/2026). Đây là giá rao tham khảo.</p>
<h2>Lưu ý pháp lý và hạ tầng</h2>
<p>Năm 2022, báo Reatimes và Tuổi Trẻ Thủ Đô phản ánh dự án gần 20 năm vẫn chưa được nghiệm thu, bàn giao; một số hộ chưa được đền bù, một số tuyến thoát nước kém, ngập khi mưa lớn. Vì vậy người mua nên ưu tiên lô <strong>đã có sổ riêng</strong>, xem sổ bản gốc, kiểm tra thửa đất tại phường và đi xem hiện trạng tuyến đường vào mùa mưa.</p>' . hh_dien_ngoc_links( 'khu-do-thi-so-9-dien-ngoc' ),
		'sources' => array(
			'https://batdongsan.com.vn/ban-dat-nen-du-an-khu-do-thi-so-9-dien-nam-dien-ngoc',
			'https://reatimes.vn/ky-1-gan-20-nam-du-anvan-chua-nghiem-thu-ban-giao-202201224000013792.htm',
			'https://tuoitrethudo.vn/quang-nam-nguoi-dan-song-do-chet-do-canh-du-an-khu-do-thi-so-9-tai-phuong-dien-ngoc-158726.html',
			'https://baodangland.vn/khu-do-thi-so-9/',
			'https://alonhadat.com.vn/nha-dat/can-ban/dat-tho-cu-dat-o/phuong-dien-ngoc-thi-xa-dien-ban-px7706.html',
		),
	);

	// 5. Phố chợ Điện Ngọc.
	$projects[] = array(
		'slug'    => 'pho-cho-dien-ngoc',
		'title'   => 'Phố chợ Điện Ngọc',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu phố chợ khoảng 1 ha ở trung tâm khu đô thị số 9, sát chợ Điện Ngọc – hợp kinh doanh buôn bán; giá rao khoảng 27 – 46 triệu/m² (tham khảo 2026).',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Đất Xanh Miền Trung (nay Regal Group)',
			'hh_p_type'          => 'Đất nền, nhà phố kinh doanh',
			'hh_p_address'       => 'Quanh chợ Điện Ngọc, khu đô thị số 9, ' . $area,
			'hh_p_map_address'   => 'Chợ Điện Ngọc, Điện Bàn',
			'hh_p_scale'         => 'Khoảng 1 ha · 70 nền',
			'hh_p_unit_area'     => 'Phổ biến 85 – 128 m²',
			'hh_p_legal'         => 'Có sổ (theo tin rao 2026)',
			'hh_p_start'         => 'Khởi công 2012',
			'hh_p_highlights'    => "Sát chợ Điện Ngọc – vị trí buôn bán sầm uất\nĐường 7,5 m, nhiều lô ngang 8 m\nKhu dân cư hiện hữu, tiện ích sinh hoạt đầy đủ\nGiá rao tăng khoảng 42% trong một năm (batdongsan, 10/2026)",
			'hh_p_location_desc' => 'Phố chợ Điện Ngọc nằm ở trung tâm khu đô thị số 9 thuộc Đô thị mới Điện Nam – Điện Ngọc, bao quanh chợ Điện Ngọc, gần các trục Trần Hưng Đạo – Nguyễn Tất Thành; cách Ngũ Hành Sơn khoảng 3 km.',
			'hh_p_connections'   => "Ngay | Chợ Điện Ngọc\nKhoảng 3 km | Ngũ Hành Sơn (Đà Nẵng)\nGần | ĐH FPT, FPT City, khu đô thị số 3",
			'hh_p_amenities_out' => "Chợ Điện Ngọc\nTrường học, ngân hàng, phòng khám khu số 9\nĐH FPT, ĐH Phan Châu Trinh",
			'hh_p_resale_price'  => '27 – 46 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'pho-cho-dien-ngoc', 'Phố chợ Điện Ngọc – đất nền sát chợ, giá tham khảo' ),
			'hh_p_faq'           => "Phố chợ Điện Ngọc ở đâu? | Ở trung tâm khu đô thị số 9, bao quanh chợ Điện Ngọc; nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.\nGiá đất phố chợ Điện Ngọc bao nhiêu? | Tin rao 2026: lô 85 m² khoảng 2,85 – 3,6 tỷ, lô 110 – 128 m² khoảng 2,45 – 3,6 tỷ; lô mặt tiền Trần Hưng Đạo 375 m² khoảng 19,5 tỷ (tham khảo).\nĐất phố chợ có hợp kinh doanh không? | Lô sát chợ và đường lớn hợp mở cửa hàng; lô đường 7,5 m hợp để ở kết hợp buôn bán nhỏ.",
		),
		'content' => '<p><strong>Phố chợ Điện Ngọc</strong> là khu đất nền khoảng <strong>1 ha</strong> (khoảng 70 nền) bao quanh chợ Điện Ngọc, nằm ở trung tâm khu đô thị số 9 thuộc Đô thị mới Điện Nam – Điện Ngọc, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Khu được khởi công năm 2012 và mở bán khoảng 2012 – 2013 qua Đất Xanh Miền Trung (nay là Regal Group).</p>
<h2>Vì sao được quan tâm</h2>
<ul>
<li>Sát chợ Điện Ngọc – điểm buôn bán đông nhất khu vực, hợp mở cửa hàng, kinh doanh nhỏ.</li>
<li>Khu dân cư hiện hữu, đầy đủ tiện ích sinh hoạt; gần ĐH FPT, ĐH Phan Châu Trinh.</li>
<li>Lô vừa tiền (khoảng 85 – 128 m²), đường 7,5 m, nhiều lô ngang 8 m.</li>
</ul>
<h2>Giá đất phố chợ Điện Ngọc (tin rao 2026)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Lô trong khu phố chợ</td><td>85 m²</td><td>2,85 – 3,6 tỷ</td><td>Khoảng 33 – 42 triệu/m²</td></tr>
<tr><td>Lô phổ biến</td><td>110 m²</td><td>2,95 tỷ</td><td>Tin rao</td></tr>
<tr><td>Đường 7,5 m, có sổ</td><td>125 m²</td><td>2,45 tỷ</td><td>Tin rao</td></tr>
<tr><td>Ngang 8 m, gần chợ</td><td>128 m²</td><td>3,6 tỷ</td><td>Tin rao</td></tr>
<tr><td>Mặt tiền Trần Hưng Đạo</td><td>375 m²</td><td>19,5 tỷ (khoảng 52 triệu/m²)</td><td>Lô lớn</td></tr>
</tbody></table>
<p>Batdongsan (10/2026) ghi khoảng giá <strong>27,6 – 46,1 triệu/m²</strong>, tăng khoảng 42% so với một năm trước. Lúc mở bán năm 2012 – 2013, giá bình quân chỉ khoảng 210 triệu/nền. Đây là giá rao tham khảo.</p>
<h2>Lưu ý khi mua</h2>
<p>Phố chợ nằm trong khu đô thị số 9 – khu từng bị báo chí phản ánh chậm nghiệm thu và thoát nước kém (báo CADN). Nên chọn lô đã có sổ riêng, xem sổ bản gốc và kiểm tra thoát nước tuyến đường trước khi xuống tiền.</p>' . hh_dien_ngoc_links( 'pho-cho-dien-ngoc' ),
		'sources' => array(
			'https://batdongsan.com.vn/ban-dat-nen-du-an-pho-cho-dien-ngoc',
			'https://cafeland.vn/tin-tuc/mo-ban-dat-nen-khu-pho-cho-dien-ngoc-37437.html',
			'https://guland.vn/du-an/pho-cho-dien-ngoc',
			'https://cadn.com.vn/khu-pho-cho-dien-ngoc-dien-ban-quang-nam-len-pho-cung-kho-post205781.html',
			'https://tuoitre.vn/dat-xanh-mien-trung-doi-ten-thanh-regal-group-voi-chien-luoc-hoat-dong-moi-20230817162654492.htm',
		),
	);

	// 6. Sentosa Riverside (Peaceful Land).
	$projects[] = array(
		'slug'    => 'sentosa-riverside-dien-ngoc',
		'title'   => 'Sentosa Riverside Điện Ngọc (Peaceful Land)',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị 20,33 ha, 677 lô ven sông Cổ Cò, đối diện sân golf Montgomerie Links, cách biển khoảng 500 m; giá rao khoảng 18 – 26 triệu/m², lưu ý lịch sử chậm ra sổ.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_name'          => 'Sentosa Riverside (tên cũ Peaceful Land, có nơi gọi Venice Riverside)',
			'hh_p_developer'     => 'Bách Đạt, Bách Đạt An; phân phối Cen Group',
			'hh_p_type'          => 'Đất nền liền kề, đất biệt thự',
			'hh_p_address'       => 'Đường Dũng Sĩ Điện Ngọc – ĐT603, ven sông Cổ Cò, ' . $area,
			'hh_p_map_address'   => 'Sentosa Riverside Điện Ngọc',
			'hh_p_scale'         => '20,33 ha',
			'hh_p_units'         => '677 lô',
			'hh_p_unit_area'     => 'Liền kề 108 – 150 m²',
			'hh_p_legal'         => '615/677 lô có sổ (2022) – kiểm tra từng lô',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_highlights'    => "Ven sông Cổ Cò, đối diện sân golf Montgomerie Links\nCách biển khoảng 500 m, tuyến ven biển Sơn Trà – Điện Ngọc khoảng 400 m\n677 lô, 3 công viên, bến du thuyền ven sông theo quy hoạch\nGiá rao mềm hơn khu gần ĐH FPT",
			'hh_p_location_desc' => 'Sentosa Riverside phía Đông giáp sông Cổ Cò (đối diện sân golf Montgomerie Links), phía Tây giáp tuyến ĐT603 rộng 33 m nối Làng Đại học Đà Nẵng – FPT City, phía Bắc giáp khu Green City và biệt thự Bồng Lai. Từ dự án có trục thẳng ra bãi tắm Viêm Đông.',
			'hh_p_connections'   => "Khoảng 500 m | Biển Viêm Đông\nKhoảng 400 m | Tuyến ven biển Sơn Trà – Điện Ngọc\nKhoảng 5 phút | Ngũ Hành Sơn\nKhoảng 15 phút | Sân bay Đà Nẵng, phố cổ Hội An",
			'hh_p_amenities_in'  => "3 công viên, trong đó có công viên ven sông Cổ Cò\nBến du thuyền, phố đi dạo ven sông\nHồ sinh thái, mặt nước 1,11 ha",
			'hh_p_amenities_out' => "Sân golf Montgomerie Links, Đà Nẵng Golf\nCocobay, FPT City, Làng Đại học\nBiển Viêm Đông, resort ven biển Điện Ngọc",
			'hh_p_resale_price'  => '18 – 26 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'sentosa-riverside-dien-ngoc', 'Sentosa Riverside Điện Ngọc (Peaceful Land) – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Peaceful Land và Sentosa Riverside có phải một dự án? | Có. Khu đô thị Peaceful Land ở Điện Ngọc sau này được bán dưới tên Sentosa Riverside (20,33 ha, 677 lô).\nGiá đất Sentosa Riverside bao nhiêu? | Tin rao 8 – 9/2026: lô 108 – 150 m² khoảng 2,15 – 3,65 tỷ; lô mặt đường 27 m 174 m² khoảng 4,6 tỷ (tham khảo).\nSentosa Riverside đã có sổ đỏ chưa? | Giữa năm 2022 có 615/677 lô có sổ, hơn 60 lô chưa có; chưa thấy công bố cập nhật 2025 – 2026. Chỉ nên giao dịch lô đã có sổ riêng và xem sổ bản gốc.",
		),
		'content' => '<p><strong>Sentosa Riverside</strong> (tên cũ <strong>Peaceful Land</strong>) là khu đô thị đất nền quy mô <strong>20,33 ha với 677 lô</strong> ven sông Cổ Cò, đối diện sân golf Montgomerie Links, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Chủ đầu tư là nhóm Bách Đạt (Công ty TNHH SX&TM Bách Đạt, sau là Công ty CP Bách Đạt An); Cen Group là đơn vị hợp tác phát triển và phân phối từ 2016.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>Cơ cấu đất: liền kề 6,87 ha, biệt thự 4,02 ha, giao thông 5,71 ha, cây xanh 2,2 ha, mặt nước 1,11 ha.</li>
<li>Lô liền kề 108 – 150 m², lô biệt thự khoảng 200 – 307 m²; đường nội khu 7,5 m, trục 27 m và 33 m.</li>
<li>3 công viên, công viên ven sông Cổ Cò kết hợp bến du thuyền và phố đi dạo theo quy hoạch.</li>
</ul>
<h2>Giá đất Sentosa Riverside (tin rao)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Block A17</td><td>108 m²</td><td>2,15 tỷ (khoảng 20 triệu/m²)</td><td>Tin 8/2026</td></tr>
<tr><td>Trục chính A18</td><td>134 m²</td><td>2,4 tỷ</td><td>Tin 2026</td></tr>
<tr><td>Block A8</td><td>150 m²</td><td>3,65 tỷ</td><td>Tin 2026</td></tr>
<tr><td>Mặt đường 27 m</td><td>174,3 m²</td><td>4,6 tỷ (khoảng 26 triệu/m²)</td><td>Tin 2/2026</td></tr>
<tr><td>Biệt thự</td><td>237 m²</td><td>khoảng 6 tỷ</td><td>Tin rao</td></tr>
</tbody></table>
<p>Mặt bằng phổ biến khoảng <strong>18 – 26 triệu/m²</strong>. Đây là giá rao tham khảo.</p>
<h2>Lưu ý pháp lý quan trọng</h2>
<p>Theo Báo Đầu tư và báo CADN (2022), giữa năm 2022 dự án có 615/677 lô được cấp sổ, hơn 60 lô chưa có sổ khiến khách hàng phản ứng. Năm 2023, Công ty CP Bách Đạt An bị đề xuất chấm dứt một số dự án do chậm tiến độ và bị cưỡng chế thuế; năm 2024 báo Người Đưa Tin phản ánh hạ tầng điện chưa hoàn thiện. Chỉ nên mua lô <strong>đã có sổ riêng</strong>, xem sổ bản gốc và kiểm tra hạ tầng điện – nước của lô.</p>' . hh_dien_ngoc_links( 'sentosa-riverside-dien-ngoc' ),
		'sources' => array(
			'https://baodautu.vn/du-an-khu-do-thi-sentosa-riverside-nhieu-khach-hang-phan-ung-viec-cham-ra-so-do-d170197.html',
			'https://cadn.com.vn/khach-hang-phan-ung-vi-du-an-sentosa-riverside-cham-ban-giao-so-do-post264293.html',
			'https://baodautu.vn/vi-sao-quang-nam-khong-gia-han-tien-do-cac-du-an-cua-cong-ty-bach-dat-an-d196502.html',
			'https://homedy.com/khu-do-thi-sentosa-riverside-pj12328465',
			'https://san43.com/ban-dat-prj-sentosa-riverside-tai-quang-nam.html',
		),
	);

	// 7. GAIA City.
	$projects[] = array(
		'slug'    => 'gaia-city-dien-ngoc',
		'title'   => 'GAIA City Điện Ngọc',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị GAIA City trên đường Dũng Sĩ Điện Ngọc, gần Cocobay và biển Viêm Đông; mở bán 8/2017 với 475 lô, giá rao 2026 khoảng 20 – 30 triệu/m².',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Công ty TNHH Đầu tư BĐS GAIA',
			'hh_p_type'          => 'Đất nền nhà phố, shophouse, đất biệt thự',
			'hh_p_address'       => 'Đường Dũng Sĩ Điện Ngọc, ' . $area,
			'hh_p_map_address'   => 'GAIA City Điện Ngọc',
			'hh_p_scale'         => 'Gần 9 ha (đợt mở bán 2017)',
			'hh_p_units'         => '475 lô đất nền (đợt mở bán 2017)',
			'hh_p_unit_area'     => 'Phổ biến 100 – 120 m²',
			'hh_p_legal'         => 'Sổ đỏ từng nền (theo tin rao)',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_start'         => 'Mở bán 20/8/2017 – bán 428/475 lô trong ngày',
			'hh_p_highlights'    => "Gần Cocobay, biển Viêm Đông và sông Cổ Cò (khoảng 1 km)\nCách FPT City khoảng 1 km\nĐường 13,5 – 34 m, có trục 34 m sang Cocobay\nCông viên trung tâm khoảng 6.000 m²",
			'hh_p_location_desc' => 'GAIA City nằm trên đường Dũng Sĩ Điện Ngọc, kết nối tuyến ven biển Sơn Trà – Điện Ngọc và ĐT607, thuộc quy hoạch Đô thị mới Điện Nam – Điện Ngọc. Phía Đông hướng về Cocobay, phía Nam là trục chính ra biển Viêm Đông.',
			'hh_p_connections'   => "Khoảng 1 km | Biển Viêm Đông, sông Cổ Cò\nKhoảng 1 km | FPT City\nKhoảng 500 m | Biệt thự Bồng Lai\nKhoảng 14 km | Trung tâm Đà Nẵng",
			'hh_p_amenities_in'  => "Công viên trung tâm khoảng 6.000 m²\nBãi đỗ xe, camera an ninh",
			'hh_p_amenities_out' => "Cocobay\nBiển Viêm Đông\nFPT City, ĐH FPT\nChợ Điện Ngọc",
			'hh_p_resale_price'  => '20 – 30 triệu/m² (tin rao)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'gaia-city-dien-ngoc', 'GAIA City Điện Ngọc – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "GAIA City Điện Ngọc ở đâu? | Trên đường Dũng Sĩ Điện Ngọc, gần Cocobay, biển Viêm Đông và FPT City; nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng.\nGiá đất GAIA City bao nhiêu? | Tin rao: lô 100 m² khoảng 2,85 tỷ, lô 108 m² khoảng 2,95 tỷ, lô 120 – 167 m² khoảng 2,8 – 3,3 tỷ (tham khảo). Năm 2017 giá mở bán chỉ khoảng 302 – 387 triệu/lô.\nQuy mô GAIA City bao nhiêu? | Báo chí 2017 ghi gần 9 ha với 475 lô đợt mở bán; một số trang rao ghi khoảng 19 – 20 ha cho toàn khu.",
		),
		'content' => '<p><strong>GAIA City</strong> là khu đô thị đất nền trên đường <strong>Dũng Sĩ Điện Ngọc</strong>, gần Cocobay, biển Viêm Đông và FPT City, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Dự án mở bán ngày 20/8/2017 với 475 lô và theo báo Đà Nẵng đã bán 428 lô ngay trong ngày.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>Báo chí năm 2017 ghi quy mô gần 9 ha cho đợt mở bán; các trang rao ghi khoảng 19 – 20 ha cho toàn khu.</li>
<li>Sản phẩm: đất nền nhà phố liền kề, shophouse, đất biệt thự; lô 80 – 300 m², phổ biến 100 – 120 m².</li>
<li>Đường 13,5 m, 15,5 m, 17,5 m, 27 m và 34 m; công viên trung tâm khoảng 6.000 m².</li>
</ul>
<h2>Giá đất GAIA City (tin rao)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Lô phổ biến</td><td>100 m²</td><td>2,85 tỷ (khoảng 28,5 triệu/m²)</td><td>Tin rao</td></tr>
<tr><td>Lô phổ biến</td><td>108 m²</td><td>2,95 tỷ</td><td>Tin rao</td></tr>
<tr><td>Lô lớn</td><td>120 – 167 m²</td><td>2,8 – 3,3 tỷ (20 – 23 triệu/m²)</td><td>Tin rao</td></tr>
</tbody></table>
<p>Mặt bằng khoảng <strong>20 – 30 triệu/m²</strong>, gấp nhiều lần mức 302 – 387 triệu/lô lúc mở bán năm 2017. Đây là giá rao tham khảo.</p>
<h2>Lưu ý khi mua</h2>
<p>Các nguồn ghi chủ đầu tư và quy mô GAIA City chưa thống nhất (Công ty GAIA theo báo chí 2017, một số trang ghi Bách Đạt). Người mua nên kiểm tra tên chủ đầu tư, số thửa trên sổ và quy hoạch 1/500 tại phường trước khi giao dịch.</p>' . hh_dien_ngoc_links( 'gaia-city-dien-ngoc' ),
		'sources' => array(
			'https://baodanang.vn/da-mo-ban-428-475-lo-dat-nen-du-an-khu-do-thi-gaia-city-3025798.html',
			'https://baodautu.vn/batdongsan/dau-tu-dat-nen-gaia-city-nhan-chiet-khau-khung-d68258.html',
			'https://homedy.com/khu-do-thi-gaia-city-pj83155751',
			'https://batdongsan.com.vn/ban-dat-nen-du-an-gaia-city',
		),
	);

	// 8. Tropical Palm.
	$projects[] = array(
		'slug'    => 'tropical-palm-dien-ngoc',
		'title'   => 'Tropical Palm Điện Ngọc (Ngọc Dương Riverside mở rộng)',
		'type'    => 'dat-nen',
		'area'    => 'dien-ban',
		'excerpt' => 'Khu đô thị khoảng 20 ha, 533 sản phẩm giữa sông Cổ Cò và trục ven biển Võ Nguyên Giáp, cách biển khoảng 500 m; giá rao khoảng 17 – 30 triệu/m².',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_name'          => 'Tropical Palm (Ngọc Dương Riverside mở rộng; có nơi gọi Castia Palm)',
			'hh_p_developer'     => 'Đất Quảng Group; phân phối Đất Xanh Miền Trung',
			'hh_p_type'          => 'Đất nền liền kề, đất biệt thự, shophouse',
			'hh_p_address'       => 'Giữa sông Cổ Cò và trục ven biển Võ Nguyên Giáp, giáp ranh Điện Dương, ' . $area,
			'hh_p_map_address'   => 'Tropical Palm Điện Ngọc',
			'hh_p_scale'         => 'Khoảng 20 ha',
			'hh_p_units'         => '533 sản phẩm',
			'hh_p_unit_area'     => 'Phổ biến 100 – 125 m²',
			'hh_p_legal'         => 'Sổ đỏ lâu dài (theo tin rao)',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_start'         => 'Khởi công 2017, triển khai 2018 – 2019',
			'hh_p_highlights'    => "Hai mặt tiền: sông Cổ Cò và trục ven biển Võ Nguyên Giáp\nCách biển khoảng 500 m, phía Bắc giáp sân golf Montgomerie Links\nĐường ven sông 20,5 m, nội khu 7,5 – 15,5 m\nCông viên, hồ cảnh quan, clubhouse, bến du thuyền theo quy hoạch",
			'hh_p_location_desc' => 'Tropical Palm nằm giữa sông Cổ Cò (phía Tây) và trục ven biển Võ Nguyên Giáp nối Đà Nẵng – Hội An; phía Bắc giáp sân golf Montgomerie Links, phía Nam giáp khu tái định cư Điện Dương, phía Đông giáp khu đô thị Dương Ngọc.',
			'hh_p_connections'   => "Khoảng 500 m | Biển Điện Ngọc – Hà My\nLiền kề phía Bắc | Sân golf Montgomerie Links\nGần | Cocobay, FPT City\nTheo Võ Nguyên Giáp | Hội An, Ngũ Hành Sơn",
			'hh_p_amenities_in'  => "Công viên chủ đề, công viên nhạc nước\nClubhouse có hồ bơi, café\nHồ cảnh quan, quảng trường\nBến du thuyền ven sông Cổ Cò",
			'hh_p_amenities_out' => "Sân golf Montgomerie Links\nBiển Hà My – Viêm Đông\nCocobay\nResort ven biển Điện Dương",
			'hh_p_resale_price'  => '17 – 30 triệu/m² (tin rao 2026)',
			'hh_p_resale_note'   => $note,
			'hh_p_image_links'   => $img( 'tropical-palm-dien-ngoc', 'Tropical Palm Điện Ngọc Ngọc Dương Riverside – thông tin và giá tham khảo' ),
			'hh_p_faq'           => "Tropical Palm và Ngọc Dương Riverside có liên quan gì? | Tropical Palm là dự án Ngọc Dương Riverside mở rộng của Đất Quảng Group, do Đất Xanh Miền Trung phát triển, phân phối.\nGiá đất Tropical Palm bao nhiêu? | Tin rao 2026: lô 100 m² khoảng 1,8 – 3,3 tỷ tùy tuyến đường; lô 125 m² khoảng 2,2 – 3,2 tỷ; lô góc 370 m² ven sông khoảng 6,84 tỷ (tham khảo).\nTropical Palm cách biển bao xa? | Khoảng 500 m; dự án có mặt tiền sông Cổ Cò và trục ven biển Võ Nguyên Giáp.",
		),
		'content' => '<p><strong>Tropical Palm</strong> (Ngọc Dương Riverside mở rộng) là khu đô thị đất nền khoảng <strong>20 ha với 533 sản phẩm</strong>, nằm giữa sông Cổ Cò và trục ven biển Võ Nguyên Giáp, cách biển khoảng 500 m, nay thuộc phường Điện Bàn Đông, TP. Đà Nẵng. Chủ đầu tư là Đất Quảng Group; Đất Xanh Miền Trung phát triển và phân phối. Dự án khởi công năm 2017.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>533 sản phẩm gồm đất liền kề, khoảng 47 biệt thự và khoảng 90 – 102 shophouse (các nguồn ghi cơ cấu khác nhau).</li>
<li>Liền kề 5 × 18 – 5 × 22 m, biệt thự 10 × 22 – 10 × 25 m.</li>
<li>Đường ven sông 20,5 m, nội khu 15,5 m (7,5 m lòng đường + 2 × 4 m vỉa hè), 10,5 m, 7,5 m.</li>
<li>Tiện ích theo quy hoạch: công viên chủ đề, công viên nhạc nước, clubhouse có hồ bơi, hồ cảnh quan, bến du thuyền.</li>
</ul>
<h2>Giá đất Tropical Palm (tin rao 2026)</h2>
<table><thead><tr><th>Lô</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Mặt tiền đường 7,5 m</td><td>100 m²</td><td>3,3 tỷ</td><td>Tin 10/2026</td></tr>
<tr><td>Lô phổ biến</td><td>100 m²</td><td>2,1 – 3 tỷ</td><td>Tin 2 – 3/2026</td></tr>
<tr><td>Đường 15,5 m</td><td>125 m²</td><td>3,2 tỷ</td><td>Tin rao</td></tr>
<tr><td>Lô góc ven sông, đường 20,5 m</td><td>370 m²</td><td>6,84 tỷ (khoảng 18,5 triệu/m²)</td><td>Tin rao</td></tr>
<tr><td>Shophouse</td><td>90 m²</td><td>3,5 tỷ</td><td>Tin rao</td></tr>
</tbody></table>
<p>Mặt bằng khoảng <strong>17 – 30 triệu/m²</strong>, phần lớn 17 – 22 triệu/m²; có nhiều tin ghi "cắt lỗ" với giá thấp hơn mặt bằng. Đây là giá rao tham khảo.</p>
<h2>Lưu ý khi mua</h2>
<p>Tiện ích nội khu là theo quy hoạch quảng cáo – nên đi xem thực tế mức độ hoàn thiện hạ tầng, dân cư của từng tuyến đường. Kiểm tra sổ bản gốc và quy hoạch lô trước khi đặt cọc.</p>' . hh_dien_ngoc_links( 'tropical-palm-dien-ngoc' ),
		'sources' => array(
			'https://homedy.com/tropical-palm-ngoc-duong-riverside-pj90654697',
			'https://alonhadat.com.vn/can-ban-dat-nen-lien-ke-dat-du-an/p2002/ngoc-duong-riverside-sentosa-garden-tropical-palm-.html',
			'https://batdongsan.com.vn/tags/ban/dat-tropical-palm',
			'https://nhadatmientrung.vn/du-an-tropical-palm-ngoc-duong-riverside-mo-rong.html',
		),
	);

	return $projects;
}
