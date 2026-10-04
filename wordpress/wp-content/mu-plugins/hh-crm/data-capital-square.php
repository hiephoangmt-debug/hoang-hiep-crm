<?php
/**
 * Tổ hợp Capital Square Đà Nẵng (Ngô Quyền – Trần Hưng Đạo, ven sông Hàn): dự án chính thành tổ hợp,
 * thêm trang riêng cho từng tòa theo MÃ TÒA CHÍNH THỨC trong thông báo của Sở Xây dựng Đà Nẵng:
 * – Capital Square 2 (Mega Assets): tòa 2.1 – 2.7 (từng tòa);
 * – Capital Square 3 (SIH): khối LAT 4-5, MAT 5-6, tòa MAT 7, tòa MAT 8-9 (Sở Xây dựng công bố số liệu theo khối).
 * Tên thương mại (Kings Place, Queens Place, Times Place…) được các trang phân phối gán không thống nhất,
 * nên chỉ dùng The King (2.4) / The Queen (2.6) – cặp tên có nguồn ghi rõ mã tòa. Tổng hợp báo chí (10/2026).
 * Giá là mặt bằng chào bán tham khảo chung toàn dự án – chưa có bảng giá công khai theo từng tòa.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_capital_square', 20 );
function hh_dataset_capital_square( $projects ) {
	$parent_slug = 'capital-square-da-nang';
	$dev2        = 'Công ty TNHH Mega Assets (hệ sinh thái BRG Group)';
	$dev3        = 'Công ty CP Bất động sản SIH (hệ sinh thái BRG Group)';
	$addr        = 'Đường Ngô Quyền – Trần Hưng Đạo, phường An Hải (An Hải Bắc, Sơn Trà cũ), Đà Nẵng – ven sông Hàn';
	$src_common  = array(
		'https://tuoitre.vn/1-237-can-ho-tai-14-toa-nha-cao-tang-ben-song-han-du-dieu-kien-duoc-ban-20260214144050977.htm',
		'https://vietnammoi.vn/delta-trung-thau-to-hop-can-ho-capital-square-2-3-o-da-nang-20263187387819.htm',
		'https://daongocchienthangreal.vn/quy-mo-du-an-capital-square/',
	);

	// Đoạn kết dùng chung cho trang từng tòa: liên kết nội bộ + CTA (phần thân bài viết riêng cho mỗi tòa).
	$tail = static function ( $name ) {
		return '
<h2>Vị trí và liên kết</h2>
<p>' . $name . ' nằm trong khu đất 61.368 m² của <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>, giới hạn bởi các trục Trần Hưng Đạo, Ngô Quyền và Nguyễn Công Trứ, liền kề TTTM Vincom, cách cầu Rồng khoảng 1,5 km và biển Mỹ Khê khoảng 5 phút di chuyển. Xem thêm các dự án <a href="/loai-du-an/cao-tang/">căn hộ cao tầng Đà Nẵng</a> hoặc tin đăng <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a> để nhận mặt bằng tầng, bảng giá và chính sách bán hàng mới nhất của ' . $name . '.</p>';
	};

	foreach ( $projects as &$p ) {
		if ( $parent_slug !== $p['slug'] ) {
			continue;
		}
		$p['type']    = array( 'to-hop', 'can-ho-so-huu-lau-dai' );
		$p['excerpt'] = 'Tổ hợp căn hộ ven sông Hàn của BRG tại Sơn Trà, Đà Nẵng: 14 tòa 24 – 29 tầng, 3.391 căn, gồm Capital Square 2 (tòa 2.1 – 2.7) và Capital Square 3 (LAT 4-5, MAT 5-6, MAT 7-8-9), sở hữu lâu dài.';
		$p['meta']    = array(
			'hh_p_builder'    => 'Delta Group (kết cấu, xây thô tòa 2.4, 2.6 và MAT 5, MAT 6)',
			'hh_p_zones'      => "Tòa 2.1 (Capital Square 2) | Căn hộ 1 – 3PN | 26 tầng, 207 căn | Đang mở bán\nTòa 2.2 (Capital Square 2) | Căn hộ 1 – 3PN | 26 tầng, 207 căn | Đang mở bán\nTòa 2.3 (Capital Square 2) | Căn hộ 1 – 3PN | 26 tầng, 207 căn | Đang mở bán\nTòa 2.4 – The King (Capital Square 2) | Căn hộ 1 – 3PN | 28 tầng, 265 căn | Đang mở bán\nTòa 2.5 (Capital Square 2) | Căn hộ 1 – 3PN | 28 tầng, 265 căn | Đang mở bán\nTòa 2.6 – The Queen (Capital Square 2) | Căn hộ 1 – 3PN | 28 tầng, 265 căn | Đang mở bán\nTòa 2.7 (Capital Square 2) | Căn hộ 1 – 3PN | 28 tầng, 265 căn | Đang mở bán\nKhối LAT 4-5 (Capital Square 3) | Căn hộ | 26 tầng, 374 căn | Đang cập nhật\nKhối MAT 5-6 (Capital Square 3) | Căn hộ | 24 tầng, 586 căn | Đang mở bán\nTòa MAT 7 (Capital Square 3) | Căn hộ | 29 tầng, 250 căn | Đang mở bán\nTòa MAT 8-9 (Capital Square 3) | Căn hộ | 29 tầng, 500 căn | Đang mở bán",
			'hh_p_highlights' => "14 tòa 24 – 29 tầng, 3.391 căn hộ trên khu đất 61.368 m² ven sông Hàn\nHai phân khu: Capital Square 2 (Mega Assets, 1.681 căn) và Capital Square 3 (SIH, 1.710 căn)\nĐã có văn bản đủ điều kiện bán cho tòa 2.1 – 2.7 và các khối MAT 5-6, MAT 7, MAT 8-9\nLiền kề TTTM Vincom, cách cầu Rồng khoảng 1,5 km\nSổ hồng sở hữu lâu dài; tối đa 502 (CS2) và 512 (CS3) căn bán cho người nước ngoài",
		) + $p['meta'];
		$p['fix_meta'] = array(
			'hh_p_zones' => "Capital Square 2 | Căn hộ (CĐT Mega Assets) | Khoảng 31.960 m² đất, 7 tòa 26 – 28 tầng, 1.681 căn | –\nCapital Square 3 | Căn hộ (CĐT SIH) | Khoảng 29.427 m² đất, 7 tòa 24 – 29 tầng, 1.710 căn | –",
		);
		$p['sources'] = array_values( array_unique( array_merge( $p['sources'], $src_common ) ) );
		$p['content'] = '<p><strong>Capital Square Đà Nẵng</strong> là tổ hợp căn hộ cao cấp ven sông Hàn thuộc hệ sinh thái BRG, nằm giữa các trục Trần Hưng Đạo – Ngô Quyền – Nguyễn Công Trứ (phường An Hải, Sơn Trà cũ). Trên tổng diện tích 61.368 m², dự án gồm 14 tòa tháp cao 24 – 29 tầng với 3.391 căn hộ, chia thành hai phân khu do hai chủ đầu tư phát triển: <strong>Capital Square 2</strong> của Công ty TNHH Mega Assets và <strong>Capital Square 3</strong> của Công ty CP Bất động sản SIH.</p>
<h2>Tổng quan hai phân khu</h2>
<p>Capital Square 2 rộng khoảng 31.960 m², gồm 7 tòa căn hộ (3 tòa 26 tầng, 4 tòa 28 tầng), 1 khối thương mại dịch vụ và 2 tầng hầm, tổng 1.681 căn. Capital Square 3 rộng khoảng 29.427 m², tổng vốn đầu tư khoảng 1.885 tỷ đồng, gồm 7 tòa căn hộ chia thành các khối LAT 4-5, MAT 5-6 và MAT 7-8-9, tổng 1.710 căn.</p>
<h2>Bảng các tòa trong tổ hợp</h2>
<table>
<thead><tr><th>Tòa / khối</th><th>Phân khu</th><th>Số tầng</th><th>Số căn</th><th>Đủ điều kiện bán</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/capital-square-toa-2-1/">Tòa 2.1</a></td><td>Capital Square 2</td><td>26</td><td>207</td><td>2/2026</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-2/">Tòa 2.2</a></td><td>Capital Square 2</td><td>26</td><td>207</td><td>Văn bản 7779/SXD-QLN</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-3/">Tòa 2.3</a></td><td>Capital Square 2</td><td>26</td><td>207</td><td>Văn bản 7779/SXD-QLN</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-4/">Tòa 2.4 – The King</a></td><td>Capital Square 2</td><td>28</td><td>265</td><td>6/2025</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-5/">Tòa 2.5</a></td><td>Capital Square 2</td><td>28</td><td>265</td><td>2/2026</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-6/">Tòa 2.6 – The Queen</a></td><td>Capital Square 2</td><td>28</td><td>265</td><td>6/2025</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-7/">Tòa 2.7</a></td><td>Capital Square 2</td><td>28</td><td>265</td><td>2/2026</td></tr>
<tr><td><a href="/du-an/capital-square-lat-4-5/">Khối LAT 4-5</a></td><td>Capital Square 3</td><td>26</td><td>374</td><td>Đang cập nhật</td></tr>
<tr><td><a href="/du-an/capital-square-mat-5-6/">Khối MAT 5-6</a></td><td>Capital Square 3</td><td>24</td><td>586</td><td>8/2025</td></tr>
<tr><td><a href="/du-an/capital-square-mat-7/">Tòa MAT 7</a></td><td>Capital Square 3</td><td>29</td><td>250</td><td>5/2026</td></tr>
<tr><td><a href="/du-an/capital-square-mat-8-9/">Tòa MAT 8-9</a></td><td>Capital Square 3</td><td>29</td><td>500</td><td>2/2026</td></tr>
</tbody>
</table>
<h2>Vị trí</h2>
<p>Dự án nằm bên bờ Đông sông Hàn, liền kề TTTM Vincom, cách cầu Rồng khoảng 1,5 km và biển Mỹ Khê khoảng 5 phút di chuyển. Mật độ xây dựng khoảng 40%, phần còn lại dành cho quảng trường, phố thương mại và cảnh quan nội khu.</p>
<h2>Pháp lý</h2>
<p>Căn hộ thuộc đất ở đô thị, sổ hồng sở hữu lâu dài. Sở Xây dựng Đà Nẵng đã có văn bản xác nhận nhà ở hình thành trong tương lai đủ điều kiện bán (Điều 24 Luật Kinh doanh bất động sản 2023) cho cả 7 tòa của Capital Square 2 và các khối MAT 5-6, MAT 7, MAT 8-9 của Capital Square 3. Người nước ngoài được mua tối đa 502 căn tại Capital Square 2 và 512 căn tại Capital Square 3. Khi ký hợp đồng, nên đối chiếu tình trạng thế chấp quyền sử dụng đất và bảo lãnh ngân hàng của từng tòa.</p>
<h2>Giá tham khảo và tiến độ</h2>
<p>Mặt bằng chào bán tham khảo khoảng 74 – 90 triệu/m² tùy tòa, tầng và hướng nhìn sông Hàn: căn 1PN (34,14 – 47,73 m²) khoảng 3,3 – 4,5 tỷ, căn 2PN (67,03 – 93,08 m²) khoảng 4,7 – 7,8 tỷ, căn 3PN (91,49 – 128,34 m²) khoảng 9,5 – 12,6 tỷ. Các trang phân phối công bố mục tiêu bàn giao từ quý I/2027 (bắt đầu với tòa The King và The Queen); tiến độ thực tế cần theo hợp đồng mua bán từng tòa.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận mặt bằng, bảng giá và chính sách mới nhất của từng tòa Capital Square, hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';
	}
	unset( $p );

	$tower = static function ( $slug, $title, $excerpt, $meta, $content, $sources ) use ( $parent_slug, $addr, $src_common ) {
		return array(
			'slug'    => $slug,
			'title'   => $title,
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'parent'  => $parent_slug,
			'excerpt' => $excerpt,
			'meta'    => $meta + array(
				'hh_p_type'          => 'Căn hộ cao cấp ven sông Hàn',
				'hh_p_address'       => $addr,
				'hh_p_ownership'     => 'Sở hữu lâu dài (sổ hồng từng căn)',
				'hh_p_location_desc' => 'Tòa nằm trong tổ hợp Capital Square Đà Nẵng (61.368 m²) giữa các trục Trần Hưng Đạo – Ngô Quyền – Nguyễn Công Trứ, bờ Đông sông Hàn, liền kề TTTM Vincom.',
				'hh_p_connections'   => "Liền kề | TTTM Vincom\nKhoảng 1,5 km | Cầu Rồng\n5 phút | Biển Mỹ Khê",
				'hh_p_amenities_in'  => "Dùng chung tiện ích tổ hợp: hồ bơi bốn mùa, sky lounge, vườn treo\nTrung tâm thương mại, phố thương mại nội khu\nGym, yoga, spa, sauna\nSân thể thao, đường dạo bộ, nhà trẻ",
				'hh_p_amenities_out' => "TTTM Vincom Đà Nẵng\nSông Hàn, cầu Rồng\nBiển Mỹ Khê",
			),
			'content' => $content,
			'sources' => array_values( array_unique( array_merge( $sources, $src_common ) ) ),
		);
	};

	$cs2_src_21 = array(
		'https://thuviennhadat.vn/bat-dong-san/du-an-khu-do-thi-capital-square-2-toa-21-25-va-27-tp-da-nang-du-dieu-kien-mo-ban-31175.html',
		'https://doanhnhan.baophapluat.vn/da-nang-hon-700-can-ho-tai-capital-square-2-du-dieu-kien-mo-ban.html',
	);
	$cs2_src_22 = array(
		'https://doanhnghieptiepthi.vn/cong-ty-tnhh-mega-assets.html',
		'https://tuoitre.vn/da-nang-du-an-capital-square-2-duoc-mo-ban-hang-ngan-can-ho-so-do-the-chap-xu-ly-sao-20260514151105868.htm',
	);
	$cs2_src_24 = array(
		'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-2-du-dieu-kien-mo-ban-530-can-ho-d314431.html',
		'https://doanhnghieptiepthi.vn/da-nang-hai-toa-can-ho-khu-do-thi-capital-square-2-du-dieu-kien-duoc-ban-161250610161929625.htm',
		'https://capitalsquarebrg.com.vn/tien-do/',
	);

	/* ---------- Capital Square 2 – Mega Assets ---------- */

	$projects[] = $tower(
		'capital-square-toa-2-1',
		'Capital Square Đà Nẵng – Tòa 2.1',
		'Tòa 2.1 Capital Square 2 (Mega Assets): 26 tầng, 207 căn hộ ven sông Hàn, đủ điều kiện bán từ 2/2026 – một trong ba tòa thấp tầng, ít căn nhất tổ hợp.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev2,
			'hh_p_floors'    => '26 tầng (cộng tầng kỹ thuật), 2 tầng hầm chung',
			'hh_p_units'     => '207 căn hộ',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 2501/SXD-QLN (2/2026)',
			'hh_p_progress'  => "2/2026 | Sở Xây dựng xác nhận 207 căn tòa 2.1 đủ điều kiện bán (cùng tòa 2.5, 2.7)",
		),
		'<p><strong>Tòa 2.1</strong> thuộc phân khu Capital Square 2 do Công ty TNHH Mega Assets làm chủ đầu tư, nằm trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a> ven sông Hàn. Đây là một trong ba tòa có chiều cao thấp nhất của Capital Square 2 – 26 tầng cộng tầng kỹ thuật – với 207 căn hộ, ít hơn 58 căn so với các tòa 28 tầng.</p>
<h2>Điểm khác biệt của tòa 2.1</h2>
<p>Với số căn ít hơn trên mỗi tòa, tòa 2.1 phù hợp người mua ưu tiên mật độ cư dân thấp, thang máy ít chờ và cộng đồng nhỏ hơn. Tháng 2/2026, Sở Xây dựng Đà Nẵng ban hành Văn bản 2501/SXD-QLN xác nhận 207 căn của tòa 2.1 đủ điều kiện bán cùng đợt với tòa 2.5 và 2.7 (tổng 737 căn), đây là đợt mở bán thứ hai của Capital Square 2 sau tòa The King và The Queen.</p>
<h2>Loại căn và giá tham khảo</h2>
<p>Mặt bằng chi tiết từng tầng của tòa 2.1 đang cập nhật. Khung diện tích chung của dự án: căn 1PN 34,14 – 47,73 m², 2PN 67,03 – 93,08 m², 3PN 91,49 – 128,34 m²; giá chào bán tham khảo toàn dự án khoảng 74 – 90 triệu/m². Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá.</p>
<h3>Tòa 2.1 khi nào bàn giao?</h3>
<p>Chủ đầu tư chưa công bố mốc bàn giao riêng cho tòa 2.1; các trang phân phối nêu mục tiêu bàn giao toàn dự án từ quý I/2027, có thể kéo dài theo từng tòa. Người mua nên đối chiếu tiến độ ghi trong hợp đồng.</p>' . $tail( 'tòa 2.1' ),
		$cs2_src_21
	);

	$projects[] = $tower(
		'capital-square-toa-2-2',
		'Capital Square Đà Nẵng – Tòa 2.2',
		'Tòa 2.2 Capital Square 2 (Mega Assets): 26 tầng, 207 căn hộ, đủ điều kiện bán theo Văn bản 7779/SXD-QLN cùng tòa 2.3 – lựa chọn mật độ thấp ven sông Hàn.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev2,
			'hh_p_floors'    => '26 tầng (cộng tầng kỹ thuật), 2 tầng hầm chung',
			'hh_p_units'     => '207 căn hộ',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 7779/SXD-QLN',
			'hh_p_progress'  => "2026 | Sở Xây dựng xác nhận 207 căn tòa 2.2 đủ điều kiện bán (Văn bản 7779/SXD-QLN, cùng tòa 2.3)",
		),
		'<p><strong>Tòa 2.2</strong> là một trong 7 tòa căn hộ của phân khu Capital Square 2 (chủ đầu tư Mega Assets) thuộc <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tòa cao 26 tầng với 207 căn – cùng quy mô với tòa 2.1 và 2.3, nhóm tòa “nhỏ” của phân khu.</p>
<h2>Pháp lý mở bán của tòa 2.2</h2>
<p>Tòa 2.2 và 2.3 được Sở Xây dựng Đà Nẵng xác nhận đủ điều kiện bán theo Văn bản 7779/SXD-QLN với tổng 414 căn (mỗi tòa 207 căn). Đây là đợt hoàn tất pháp lý mở bán cho cả 7 tòa của Capital Square 2, sau tòa 2.4, 2.6 (6/2025) và 2.1, 2.5, 2.7 (2/2026). Vì mở bán sau, rổ hàng tòa 2.2 thường còn nhiều lựa chọn tầng và hướng hơn các tòa ra hàng đợt đầu.</p>
<h2>Vì sao chọn tòa 26 tầng?</h2>
<p>So với tòa 28 tầng (265 căn), tòa 2.2 có ít căn hơn nên mật độ sử dụng thang máy, sảnh và hầm xe thấp hơn – phù hợp gia đình mua để ở lâu dài. Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá; khung diện tích chung dự án từ 34,14 m² (1PN) đến 128,34 m² (3PN).</p>
<h3>Lưu ý khi mua tòa 2.2</h3>
<p>Báo chí năm 2026 có đặt vấn đề về việc xử lý quyền sử dụng đất đang thế chấp tại Capital Square 2. Khi ký hợp đồng, nên yêu cầu chủ đầu tư cung cấp văn bản bảo lãnh ngân hàng và phương án giải chấp cho căn hộ.</p>' . $tail( 'tòa 2.2' ),
		$cs2_src_22
	);

	$projects[] = $tower(
		'capital-square-toa-2-3',
		'Capital Square Đà Nẵng – Tòa 2.3',
		'Tòa 2.3 Capital Square 2: 26 tầng, 207 căn hộ do Mega Assets phát triển, đủ điều kiện bán cùng tòa 2.2 – một trong ba tòa ít căn nhất tổ hợp ven sông Hàn.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev2,
			'hh_p_floors'    => '26 tầng (cộng tầng kỹ thuật), 2 tầng hầm chung',
			'hh_p_units'     => '207 căn hộ',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 7779/SXD-QLN',
			'hh_p_progress'  => "2026 | Sở Xây dựng xác nhận 207 căn tòa 2.3 đủ điều kiện bán (Văn bản 7779/SXD-QLN, cùng tòa 2.2)",
		),
		'<p><strong>Tòa 2.3</strong> khép lại nhóm ba tòa 26 tầng của Capital Square 2 (2.1, 2.2, 2.3) trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tòa có 207 căn hộ, chủ đầu tư là Công ty TNHH Mega Assets – đơn vị phát triển toàn bộ phân khu Capital Square 2 trên khoảng 31.960 m² đất.</p>
<h2>Tình trạng pháp lý và mở bán</h2>
<p>Cùng với tòa 2.2, tòa 2.3 được Sở Xây dựng Đà Nẵng xác nhận đủ điều kiện bán nhà ở hình thành trong tương lai theo Điều 24 Luật Kinh doanh bất động sản 2023 (Văn bản 7779/SXD-QLN, 414 căn cho hai tòa). Như vậy toàn bộ 1.681 căn của Capital Square 2 đã có văn bản đủ điều kiện bán.</p>
<h2>Phù hợp với ai?</h2>
<p>Tòa 2.3 hợp với người mua muốn vào Capital Square ở giai đoạn rổ hàng mới, còn nhiều lựa chọn căn, đồng thời ưu tiên tòa ít căn để sinh hoạt yên tĩnh hơn. Căn hộ dùng chung hệ tiện ích tổ hợp: hồ bơi bốn mùa, sky lounge, trung tâm thương mại và phố thương mại nội khu.</p>
<h3>Mặt bằng và giá tòa 2.3</h3>
<p>Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá. Giá chào bán tham khảo chung toàn dự án khoảng 74 – 90 triệu/m², tùy tầng và hướng nhìn.</p>' . $tail( 'tòa 2.3' ),
		$cs2_src_22
	);

	$projects[] = $tower(
		'capital-square-toa-2-4',
		'Capital Square Đà Nẵng – Tòa 2.4 The King',
		'Tòa 2.4 The King – tòa mở bán đầu tiên của Capital Square Đà Nẵng: 28 tầng, 265 căn, diện tích xây dựng 2.108 m², 3 tầng shophouse khối đế, dự kiến bàn giao quý I/2027.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_name'      => 'The King – Tòa 2.4 Capital Square',
			'hh_p_developer' => $dev2,
			'hh_p_builder'   => 'Delta Group (kết cấu bê tông, xây thô)',
			'hh_p_floors'    => '28 tầng, 2 tầng hầm',
			'hh_p_units'     => '265 căn hộ',
			'hh_p_scale'     => 'Diện tích xây dựng khoảng 2.108 m²',
			'hh_p_shop_desc' => 'Khối đế 3 tầng shophouse (theo thông tin giới thiệu đợt mở bán đầu tòa The King và The Queen).',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 4906/SXD-QLN (6/2025)',
			'hh_p_progress'  => "6/2025 | Sở Xây dựng xác nhận 530 căn tòa 2.4 và 2.6 đủ điều kiện bán\nĐầu 2026 | Hoàn thành phần hầm, thi công tầng thân\nQuý 1/2027 | Bắt đầu bàn giao (dự kiến)",
			'hh_p_handover'  => 'Quý 1/2027 (dự kiến)',
		),
		'<p><strong>Tòa 2.4 – The King</strong> là tòa ra hàng đầu tiên của <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tháng 6/2025, Sở Xây dựng Đà Nẵng ban hành Văn bản 4906/SXD-QLN xác nhận 530 căn của tòa 2.4 và 2.6 đủ điều kiện bán – mở màn cho phân khu Capital Square 2 của Mega Assets.</p>
<h2>Thông số tòa The King</h2>
<p>Tòa cao 28 tầng với 265 căn hộ, diện tích xây dựng khoảng 2.108 m², chiều cao trần trung bình khoảng 3,6 m, 3 tầng shophouse khối đế và 2 tầng hầm. Theo các trang phân phối, The King nằm ở vị trí trung tâm, bao quanh bởi phố thương mại, trung tâm thương mại và quảng trường nội khu hơn 2.000 m². Phần kết cấu bê tông và xây thô do Delta Group thi công.</p>
<h2>Tiến độ và bàn giao</h2>
<p>Đầu năm 2026, tòa đã hoàn thành phần hầm và chuyển sang thi công tầng thân với công nghệ cốp pha nhôm. The King cùng The Queen là hai tòa được công bố bắt đầu bàn giao từ quý I/2027 – sớm nhất tổ hợp, phù hợp người mua cần nhận nhà để ở hoặc khai thác cho thuê sớm.</p>
<h3>Giá căn hộ tòa The King bao nhiêu?</h3>
<p>Chưa có bảng giá công khai riêng cho tòa 2.4; mặt bằng chào bán tham khảo toàn dự án khoảng 74 – 90 triệu/m². Đợt mở bán đầu từng áp dụng hỗ trợ lãi suất 0% đến 24 tháng, vay đến 70% giá trị căn – chính sách thay đổi theo thời điểm.</p>' . $tail( 'tòa The King (2.4)' ),
		array_merge( $cs2_src_24, array( 'https://capitalsquaredanang.org/tien-do-xay-dung-capital-square-da-nang-2026/' ) )
	);

	$projects[] = $tower(
		'capital-square-toa-2-5',
		'Capital Square Đà Nẵng – Tòa 2.5',
		'Tòa 2.5 Capital Square 2: 28 tầng, 265 căn hộ ven sông Hàn do Mega Assets phát triển, được xác nhận đủ điều kiện bán tháng 2/2026 cùng tòa 2.1 và 2.7.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev2,
			'hh_p_floors'    => '28 tầng (cộng tầng kỹ thuật), 2 tầng hầm chung',
			'hh_p_units'     => '265 căn hộ',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 2501/SXD-QLN (2/2026)',
			'hh_p_progress'  => "2/2026 | Sở Xây dựng xác nhận 265 căn tòa 2.5 đủ điều kiện bán (cùng tòa 2.1, 2.7)",
		),
		'<p><strong>Tòa 2.5</strong> là một trong bốn tòa 28 tầng – nhóm tòa cao nhất của phân khu Capital Square 2 – thuộc <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tòa có 265 căn hộ, chủ đầu tư Công ty TNHH Mega Assets.</p>
<h2>Đợt mở bán tháng 2/2026</h2>
<p>Tháng 2/2026, Sở Xây dựng Đà Nẵng ban hành Văn bản 2501/SXD-QLN xác nhận tòa 2.1, 2.5 và 2.7 đủ điều kiện bán với tổng 737 căn, trong đó tòa 2.5 đóng góp 265 căn. Cùng thời điểm, 500 căn khối MAT 8-9 của Capital Square 3 cũng được phép bán, nâng tổng số căn hai phân khu được mở bán đợt này lên khoảng 1.237 căn.</p>
<h2>Tòa 28 tầng – nhiều lựa chọn tầng cao</h2>
<p>Với 28 tầng, tòa 2.5 có thêm các tầng cao so với nhóm tòa 26 tầng, mở ra nhiều lựa chọn cho người mua ưu tiên tầm nhìn thoáng về phía sông Hàn và trung tâm thành phố. Hướng nhìn cụ thể phụ thuộc vị trí căn trên mặt bằng tầng – thông tin chi tiết tòa đang cập nhật, liên hệ để nhận mặt bằng, bảng giá.</p>
<h3>Giá tham khảo</h3>
<p>Tòa 2.5 dùng chung hệ tiện ích tổ hợp gồm hồ bơi bốn mùa, sky lounge, vườn treo, gym – spa và trung tâm thương mại khối đế. Giá chào bán tham khảo toàn dự án khoảng 74 – 90 triệu/m²; khung diện tích chung: 1PN 34,14 – 47,73 m², 2PN 67,03 – 93,08 m², 3PN 91,49 – 128,34 m².</p>' . $tail( 'tòa 2.5' ),
		$cs2_src_21
	);

	$projects[] = $tower(
		'capital-square-toa-2-6',
		'Capital Square Đà Nẵng – Tòa 2.6 The Queen',
		'Tòa 2.6 The Queen – cặp tòa mở bán đầu tiên của Capital Square Đà Nẵng cùng The King: 28 tầng, 265 căn, diện tích xây dựng 2.206 m², dự kiến bàn giao quý I/2027.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_name'      => 'The Queen – Tòa 2.6 Capital Square',
			'hh_p_developer' => $dev2,
			'hh_p_builder'   => 'Delta Group (kết cấu bê tông, xây thô)',
			'hh_p_floors'    => '28 tầng, 2 tầng hầm',
			'hh_p_units'     => '265 căn hộ',
			'hh_p_scale'     => 'Diện tích xây dựng khoảng 2.206 m²',
			'hh_p_shop_desc' => 'Khối đế 3 tầng shophouse (theo thông tin giới thiệu đợt mở bán đầu tòa The King và The Queen).',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 4906/SXD-QLN (6/2025)',
			'hh_p_progress'  => "6/2025 | Sở Xây dựng xác nhận 530 căn tòa 2.4 và 2.6 đủ điều kiện bán\nĐầu 2026 | Hoàn thành phần hầm, thi công tầng thân\nQuý 1/2027 | Bắt đầu bàn giao (dự kiến)",
			'hh_p_handover'  => 'Quý 1/2027 (dự kiến)',
		),
		'<p><strong>Tòa 2.6 – The Queen</strong> cùng tòa The King (2.4) là cặp tòa ra mắt đầu tiên của <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>, được Sở Xây dựng Đà Nẵng xác nhận đủ điều kiện bán từ tháng 6/2025 (530 căn cho hai tòa).</p>
<h2>The Queen khác The King ở điểm nào?</h2>
<p>Hai tòa cùng 28 tầng và 265 căn, nhưng The Queen có diện tích xây dựng lớn hơn – khoảng 2.206 m² so với 2.108 m² của The King. Theo giới thiệu của các đơn vị phân phối, The Queen nằm ở vị trí chuyển tiếp giữa phố thương mại sôi động và quảng trường xanh nội khu, hướng tới nhịp sống cân bằng hơn. Tòa có trần cao trung bình khoảng 3,6 m, 3 tầng shophouse khối đế và 2 tầng hầm; Delta Group thi công phần kết cấu và xây thô.</p>
<h2>Tiến độ thi công</h2>
<p>Đến đầu năm 2026, tòa đã xong phần hầm và đang lên tầng thân. The Queen nằm trong nhóm tòa được công bố bắt đầu bàn giao từ quý I/2027 – là lựa chọn của người mua muốn nhận nhà sớm trong tổ hợp.</p>
<h3>Giá và chính sách</h3>
<p>Chưa có bảng giá công khai riêng cho tòa 2.6; giá chào bán tham khảo toàn dự án khoảng 74 – 90 triệu/m². Thông tin chi tiết từng căn đang cập nhật – liên hệ để nhận mặt bằng, bảng giá.</p>' . $tail( 'tòa The Queen (2.6)' ),
		array_merge( $cs2_src_24, array( 'https://vietnamfinance.vn/delta-group-lien-tiep-trung-thau-du-an-capital-square-2-capital-square-3-da-nang-d145760.html' ) )
	);

	$projects[] = $tower(
		'capital-square-toa-2-7',
		'Capital Square Đà Nẵng – Tòa 2.7',
		'Tòa 2.7 Capital Square 2 (Mega Assets): 28 tầng, 265 căn hộ, đủ điều kiện bán từ tháng 2/2026 – tòa cao tầng trong phân khu ven sông Hàn, sổ hồng lâu dài.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev2,
			'hh_p_floors'    => '28 tầng (cộng tầng kỹ thuật), 2 tầng hầm chung',
			'hh_p_units'     => '265 căn hộ',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai – Văn bản 2501/SXD-QLN (2/2026)',
			'hh_p_progress'  => "2/2026 | Sở Xây dựng xác nhận 265 căn tòa 2.7 đủ điều kiện bán (cùng tòa 2.1, 2.5)",
		),
		'<p><strong>Tòa 2.7</strong> là tòa mang số thứ tự cuối của phân khu Capital Square 2 trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tòa cao 28 tầng cộng tầng kỹ thuật, gồm 265 căn hộ, do Công ty TNHH Mega Assets đầu tư.</p>
<h2>Pháp lý tòa 2.7</h2>
<p>Tòa 2.7 thuộc đợt mở bán tháng 2/2026: Văn bản 2501/SXD-QLN của Sở Xây dựng Đà Nẵng xác nhận 737 căn tại tòa 2.1 (207 căn), 2.5 (265 căn) và 2.7 (265 căn) đủ điều kiện bán theo Điều 24 Luật Kinh doanh bất động sản 2023. Hợp đồng mua bán áp dụng khung thanh toán theo luật: đợt đầu không quá 30%, trước bàn giao không quá 70% giá trị hợp đồng.</p>
<h2>Ai nên chọn tòa 2.7?</h2>
<p>Là tòa 28 tầng, 2.7 có quy mô 265 căn – cân bằng giữa số lượng căn để lựa chọn và mật độ cư dân. Người mua đầu tư cho thuê có thể cân nhắc các căn 1PN diện tích nhỏ (khung chung dự án 34,14 – 47,73 m²), trong khi gia đình có thể chọn căn 2PN – 3PN (67,03 – 128,34 m²).</p>
<h3>Mặt bằng, hướng nhìn và giá</h3>
<p>Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá. Giá chào bán tham khảo chung toàn dự án khoảng 74 – 90 triệu/m², căn tầng cao hướng sông Hàn thường ở mức cao hơn.</p>' . $tail( 'tòa 2.7' ),
		$cs2_src_21
	);

	/* ---------- Capital Square 3 – SIH ---------- */

	$projects[] = $tower(
		'capital-square-lat-4-5',
		'Capital Square Đà Nẵng – Khối LAT 4-5',
		'Khối LAT 4-5 Capital Square 3 (SIH): 26 tầng, 374 căn hộ, diện tích sàn 618,85 m² – khối ít căn nhất phân khu, chưa có thông báo đủ điều kiện bán.',
		array(
			'hh_p_developer' => $dev3,
			'hh_p_floors'    => '26 tầng (cộng tum thang)',
			'hh_p_units'     => '374 căn hộ',
			'hh_p_scale'     => 'Diện tích sàn khoảng 618,85 m² (theo thông báo của Sở Xây dựng)',
		),
		'<p><strong>Khối LAT 4-5</strong> thuộc phân khu Capital Square 3 do Công ty CP Bất động sản SIH làm chủ đầu tư, nằm trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Khối cao 26 tầng cộng tum thang với 374 căn hộ – quy mô nhỏ nhất trong ba khối căn hộ của Capital Square 3 (LAT 4-5, MAT 5-6, MAT 7-8-9).</p>
<h2>Vị trí trong phân khu Capital Square 3</h2>
<p>Capital Square 3 rộng khoảng 29.427 m² trên đường Ngô Quyền, tổng vốn đầu tư khoảng 1.885 tỷ đồng, gồm 7 tòa căn hộ và 1 khối thương mại dịch vụ, tổng 1.710 căn. LAT 4-5 chiếm 374 căn, diện tích sàn theo thông báo của Sở Xây dựng khoảng 618,85 m² – nhỏ hơn đáng kể so với MAT 5-6 (902,3 m²) và MAT 7-8-9 (987,51 m²).</p>
<h2>Tình trạng mở bán</h2>
<p>Đến thời điểm cập nhật (10/2026), chúng tôi chưa thấy thông báo đủ điều kiện bán riêng cho khối LAT 4-5, trong khi MAT 5-6, MAT 7 và MAT 8-9 đã có văn bản của Sở Xây dựng. Đây có thể là rổ hàng ra sau của Capital Square 3 – người mua quan tâm nên đăng ký trước để nhận thông tin sớm.</p>
<h3>Loại căn và giá khối LAT 4-5</h3>
<p>Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá. Khung diện tích chung của dự án từ căn 1PN 34,14 m² đến 3PN 128,34 m²; giá chào bán tham khảo toàn dự án khoảng 74 – 90 triệu/m².</p>' . $tail( 'khối LAT 4-5' ),
		array(
			'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html',
			'https://thuviennhadat.vn/phap-luat/khu-do-thi-capital-square-3-o-dau-dien-tich-khu-do-thi-capital-square-3-bao-nhieu-698626.html',
		)
	);

	$projects[] = $tower(
		'capital-square-mat-5-6',
		'Capital Square Đà Nẵng – Khối MAT 5-6',
		'Khối MAT 5-6 Capital Square 3 (SIH): 24 tầng, 586 căn hộ – khối mở bán đầu tiên của Capital Square 3 (8/2025), do Delta Group thi công kết cấu.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev3,
			'hh_p_builder'   => 'Delta Group (kết cấu bê tông, xây thô tòa MAT 5 và MAT 6)',
			'hh_p_floors'    => '24 tầng (cộng tum thang)',
			'hh_p_units'     => '586 căn hộ',
			'hh_p_scale'     => 'Diện tích sàn khoảng 902,3 m² (theo thông báo của Sở Xây dựng)',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai (6/8/2025); CĐT không thế chấp quyền sử dụng đất theo thông báo',
			'hh_p_progress'  => "6/8/2025 | Sở Xây dựng xác nhận 586 căn khối MAT 5-6 đủ điều kiện bán",
		),
		'<p><strong>Khối MAT 5-6</strong> là rổ hàng mở bán đầu tiên của phân khu Capital Square 3 trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Ngày 6/8/2025, Sở Xây dựng Đà Nẵng xác nhận 586 căn hộ của khối đủ điều kiện bán và cho thuê mua theo Luật Kinh doanh bất động sản 2023.</p>
<h2>Thông số khối MAT 5-6</h2>
<p>Khối gồm hai tòa MAT 5 và MAT 6, cao 24 tầng cộng tum thang – thấp nhất trong Capital Square 3 – nhưng có tới 586 căn, diện tích sàn khoảng 902,3 m². Chủ đầu tư là Công ty CP Bất động sản SIH; phần kết cấu bê tông và xây thô hai tòa MAT 5, MAT 6 do Delta Group đảm nhận.</p>
<h2>Điểm cộng về pháp lý</h2>
<p>Theo thông báo của Sở Xây dựng, chủ đầu tư Capital Square 3 không thế chấp quyền sử dụng đất của dự án. Khung thanh toán theo luật: đợt đầu không quá 30% giá trị hợp đồng, trước bàn giao không quá 70%, chưa cấp sổ không quá 95%.</p>
<h3>Khối MAT 5-6 phù hợp ai?</h3>
<p>Số căn lớn giúp rổ hàng đa dạng vị trí và diện tích, phù hợp cả người mua ở lẫn nhà đầu tư cho thuê. Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá; giá tham khảo toàn dự án khoảng 74 – 90 triệu/m².</p>' . $tail( 'khối MAT 5-6' ),
		array(
			'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html',
			'https://thegioitiepthi.danviet.vn/da-nang-cho-phep-ban-586-can-ho-thuoc-du-an-khu-do-thi-capital-square-3-d1353420.html',
			'https://vietnamfinance.vn/delta-group-lien-tiep-trung-thau-du-an-capital-square-2-capital-square-3-da-nang-d145760.html',
		)
	);

	$projects[] = $tower(
		'capital-square-mat-7',
		'Capital Square Đà Nẵng – Tòa MAT 7',
		'Tòa MAT 7 Capital Square 3 (SIH): thuộc khối 29 tầng MAT 7-8-9, 250 căn hộ được xác nhận đủ điều kiện bán tháng 5/2026 – rổ hàng mới nhất tổ hợp.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev3,
			'hh_p_floors'    => '29 tầng (cộng tum thang)',
			'hh_p_units'     => '250 căn hộ (đủ điều kiện bán)',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai (5/2026)',
			'hh_p_progress'  => "5/2026 | Sở Xây dựng xác nhận 250 căn tòa MAT 7 đủ điều kiện bán",
		),
		'<p><strong>Tòa MAT 7</strong> thuộc khối MAT 7-8-9 – khối cao nhất của phân khu Capital Square 3 trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tháng 5/2026, Sở Xây dựng Đà Nẵng xác nhận 250 căn hộ tại tòa MAT 7 đủ điều kiện bán, mua và thuê mua – đây là rổ hàng mới nhất được cấp phép của toàn tổ hợp.</p>
<h2>Tòa 29 tầng – cao nhất Capital Square</h2>
<p>Khối MAT 7-8-9 cao 29 tầng cộng tum thang, tổng 750 căn, diện tích sàn khoảng 987,51 m². Với chiều cao lớn nhất tổ hợp (các tòa khác 24 – 28 tầng), MAT 7 mang lại nhiều lựa chọn căn tầng cao cho người mua ưu tiên tầm nhìn thoáng. Hướng nhìn cụ thể từng căn phụ thuộc vị trí trên mặt bằng tầng.</p>
<h2>Lợi thế khi mua rổ hàng mới</h2>
<p>Do mở bán muộn hơn MAT 5-6 (8/2025) và MAT 8-9 (2/2026), MAT 7 thường còn đầy đủ quỹ căn ở nhiều tầng và diện tích. Chủ đầu tư SIH chịu trách nhiệm về tính chính xác của thông tin nhà ở hình thành trong tương lai theo yêu cầu của Sở Xây dựng.</p>
<h3>Giá căn hộ MAT 7</h3>
<p>Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá. Tham khảo chung toàn dự án: khoảng 74 – 90 triệu/m², căn 1PN khoảng 3,3 – 4,5 tỷ, 2PN khoảng 4,7 – 7,8 tỷ.</p>' . $tail( 'tòa MAT 7' ),
		array(
			'https://baodautu.vn/da-nang-khu-do-thi-capital-square-3-tiep-tuc-duoc-phep-mo-ban-250-can-ho-d605920.html',
			'https://doanhnghieptiepthi.vn/da-nang-them-250-can-ho-du-an-capital-square-3-du-dieu-kien-ban-16126052807183018.htm',
		)
	);

	$projects[] = $tower(
		'capital-square-mat-8-9',
		'Capital Square Đà Nẵng – Tòa MAT 8-9',
		'Tòa MAT 8-9 Capital Square 3 (SIH): 29 tầng, 500 căn hộ đủ điều kiện bán từ tháng 2/2026 – cặp tòa cao nhất tổ hợp ven sông Hàn, sổ hồng lâu dài.',
		array(
			'hh_p_status'    => 'dang-mo-ban',
			'hh_p_developer' => $dev3,
			'hh_p_floors'    => '29 tầng (cộng tum thang)',
			'hh_p_units'     => '500 căn hộ (đủ điều kiện bán)',
			'hh_p_legal'     => 'Đủ điều kiện bán nhà ở hình thành trong tương lai (2/2026)',
			'hh_p_progress'  => "2/2026 | Sở Xây dựng xác nhận 500 căn tòa MAT 8-9 đủ điều kiện bán",
		),
		'<p><strong>Tòa MAT 8-9</strong> gồm hai tòa MAT 8 và MAT 9 của phân khu Capital Square 3 (chủ đầu tư SIH) trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a>. Tháng 2/2026, Sở Xây dựng Đà Nẵng xác nhận 500 căn hộ tại MAT 8-9 đủ điều kiện bán – cùng đợt với 737 căn tòa 2.1, 2.5, 2.7 của Capital Square 2.</p>
<h2>Quy mô và chiều cao</h2>
<p>MAT 8 và MAT 9 thuộc khối MAT 7-8-9 cao 29 tầng cộng tum thang, tổng 750 căn, diện tích sàn khoảng 987,51 m² – khối có sàn lớn nhất và cao nhất Capital Square. Riêng MAT 8-9 chiếm 500 căn, là rổ hàng lớn thứ hai của Capital Square 3 sau MAT 5-6 (586 căn).</p>
<h2>Vì sao MAT 8-9 được chú ý?</h2>
<p>Hai tòa 29 tầng cho nhiều căn tầng cao, phù hợp khách ưu tiên không gian thoáng và tầm nhìn về sông Hàn – trung tâm thành phố (tùy vị trí căn). Pháp lý mở bán đã có văn bản của Sở Xây dựng; theo thông báo, chủ đầu tư Capital Square 3 không thế chấp quyền sử dụng đất của dự án.</p>
<h3>Mặt bằng và giá MAT 8-9</h3>
<p>Thông tin chi tiết tòa đang cập nhật – liên hệ để nhận mặt bằng, bảng giá. Khung diện tích chung dự án: 1PN 34,14 – 47,73 m², 2PN 67,03 – 93,08 m², 3PN 91,49 – 128,34 m²; giá tham khảo khoảng 74 – 90 triệu/m².</p>' . $tail( 'tòa MAT 8-9' ),
		array(
			'https://danviet.vn/da-nang-cho-phep-ban-500-can-ho-tai-du-an-khu-do-thi-capital-square-3-d1403242.html',
			'https://doanhnghieptiepthi.vn/da-nang-hon-1200-can-ho-du-an-capital-square-2-3-du-dieu-kien-ban-161260215151136598.htm',
		)
	);

	return $projects;
}
