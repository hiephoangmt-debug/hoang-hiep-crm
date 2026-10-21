<?php
/**
 * Tòa C3 – Capital Square Đà Nẵng (mã bán hàng "C3").
 * Nguồn: mô tả phân tầng, mặt bằng điển hình tầng 10 – 12, 14 – 25, vị trí tòa trên mặt bằng tổ hợp và phối cảnh đêm
 * anh Hiệp gửi 21/10/2026. Số căn hộ tính theo mô tả phân tầng (chưa có con số tổng chính thức).
 * Chưa xác định C3 tương ứng tòa nào trong danh sách 2.1 – 2.7 / LAT / MAT nên làm trang riêng, chủ đầu tư ghi theo hệ sinh thái BRG.
 * Chưa có bảng giá riêng – dùng mức tham khảo chung toàn dự án đã có ở trang tổ hợp.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/capital-square-c3/capital-square-c3-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'phoi-canh-dem-ven-song-han', 'Phối cảnh đêm tòa C3 Capital Square Đà Nẵng bên sông Hàn, cạnh tòa S4 Hudson Place', 'đại diện' ),
			$img( 'vi-tri-trong-to-hop', 'Vị trí tòa C3 trong tổ hợp Capital Square: mặt đường Trần Hưng Đạo, nhìn sông Hàn', 'tổng thể', 'Vị trí tòa C3' ),
			$img( 'phan-tang-va-layout', 'Phân tầng tòa C3 Capital Square: shophouse tầng 1 – 3, căn sân vườn tầng 4, căn hộ tầng 5 – 25, penthouse tầng 26', 'mặt bằng', 'Phân tầng và 3 layout' ),
			$img( 'mat-bang-tang-dien-hinh', 'Mặt bằng điển hình tầng 10 – 12, 14 – 25 tòa C3 Capital Square: 9 căn 1PN, 2PN, 2PN+1, 3PN', 'mặt bằng', 'Tầng 10 – 12, 14 – 25' ),
		);
		$content = '<p><strong>Tòa C3 Capital Square Đà Nẵng</strong> là tòa căn hộ 26 tầng nằm ở mặt tiền đường <strong>Trần Hưng Đạo</strong>, nhìn thẳng ra sông Hàn, thuộc <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a> (hệ sinh thái BRG). Tòa có 3 tầng shophouse khối đế, tầng 4 căn hộ sân vườn, các tầng căn hộ 1PN – 3PN và tầng 26 penthouse.</p>
<h2>Thông số tòa C3</h2>
<table>
<tbody>
<tr><th>Vị trí</th><td>Mặt tiền đường Trần Hưng Đạo, giữa sông Hàn và Grand Central Mall, cạnh phố đi bộ Park Boulevard</td></tr>
<tr><th>Chiều cao</th><td>26 tầng (không có tầng 13, có tầng 12A)</td></tr>
<tr><th>Shophouse</th><td>Tầng 1 – 3: 16 căn</td></tr>
<tr><th>Căn hộ</th><td>Khoảng 206 căn (tính theo mô tả phân tầng) gồm căn sân vườn, 1PN, 2PN, 2PN+1, 3PN, penthouse</td></tr>
<tr><th>Diện tích</th><td>1PN 45,01 – 47,43 m², 2PN 65,82 – 66,16 m², 2PN+1 78,45 – 78,51 m², 3PN 119,71 m² (thông thủy, tầng điển hình)</td></tr>
<tr><th>Sở hữu</th><td>Sở hữu lâu dài (theo thông tin chung tổ hợp)</td></tr>
</tbody>
</table>
<h2>Phân tầng tòa C3</h2>
<table>
<thead><tr><th>Tầng</th><th>Công năng</th><th>Số căn/sàn</th></tr></thead>
<tbody>
<tr><td>1 – 3</td><td>Shophouse</td><td>16 căn (cả khối)</td></tr>
<tr><td>4</td><td>Căn hộ sân vườn</td><td>10</td></tr>
<tr><td>5 – 8</td><td>Căn hộ điển hình – layout 1</td><td>10</td></tr>
<tr><td>9 – 12</td><td>Căn hộ điển hình</td><td>9</td></tr>
<tr><td>12A</td><td>Căn hộ – layout 2, có 1 gian diện tích sử dụng riêng của chủ đầu tư</td><td>8</td></tr>
<tr><td>14 – 25</td><td>Căn hộ điển hình – layout 3</td><td>9</td></tr>
<tr><td>26</td><td>Penthouse</td><td>4</td></tr>
</tbody>
</table>
<p>Cộng theo bảng: 10 + 40 + 36 + 8 + 108 + 4 = <strong>206 căn hộ</strong> và 16 shophouse. Tài liệu mô tả ghi tầng 9 – 12 có 9 căn/sàn, còn bản mặt bằng điển hình ghi tầng 10 – 12, 14 – 25 – con số chính thức theo hợp đồng mua bán.</p>
<h2>Mặt bằng điển hình tầng 10 – 12, 14 – 25: 9 căn/sàn</h2>
<table>
<thead><tr><th>Mã căn</th><th>Loại</th><th>Thông thủy</th><th>Hướng nhìn chính</th></tr></thead>
<tbody>
<tr><td>C3-06</td><td>1PN</td><td>47,43 m²</td><td>Đầu hồi sông Hàn, phía Con đường Ánh sáng</td></tr>
<tr><td>C3-06A</td><td>1PN</td><td>45,01 m²</td><td>Con đường Ánh sáng</td></tr>
<tr><td>C3-08</td><td>2PN</td><td>66,16 m²</td><td>Con đường Ánh sáng</td></tr>
<tr><td>C3-09</td><td>2PN</td><td>65,93 m²</td><td>Con đường Ánh sáng</td></tr>
<tr><td>C3-10</td><td>2PN+1</td><td>78,51 m²</td><td>Góc Con đường Ánh sáng – Grand Central Mall</td></tr>
<tr><td>C3-05</td><td>3PN</td><td>119,71 m²</td><td>Góc sông Hàn – phố đi bộ Park Boulevard</td></tr>
<tr><td>C3-03</td><td>2PN</td><td>65,82 m²</td><td>Phố đi bộ Park Boulevard</td></tr>
<tr><td>C3-02</td><td>2PN</td><td>65,82 m²</td><td>Phố đi bộ Park Boulevard</td></tr>
<tr><td>C3-01</td><td>2PN+1</td><td>78,45 m²</td><td>Góc Park Boulevard – Grand Central Mall</td></tr>
</tbody>
</table>
<p>Mỗi sàn điển hình có 2 căn 1PN, 4 căn 2PN, 2 căn 2PN+1 và 1 căn 3PN. Căn 3PN C3-05 (gần 120 m²) và căn 1PN C3-06 nằm ở đầu hồi phía sông Hàn – nhóm căn có tầm nhìn sông rõ nhất. Tầng 5 – 8 (layout 1) có thêm căn C3-03A, còn căn C3-05 chia nhỏ; tầng 12A (layout 2) bỏ căn C3-03 để dành diện tích sử dụng riêng của chủ đầu tư.</p>
<h2>Vị trí trong tổ hợp</h2>
<p>Tòa C3 nằm ở dãy mặt tiền Trần Hưng Đạo, phía Bắc là trục Con đường Ánh sáng, phía Nam là phố đi bộ Park Boulevard, phía Đông là Grand Central Mall và quảng trường nội khu. Nhìn từ sông Hàn về đêm, C3 đứng ở hàng tòa đầu tiên sát sông, bên trái tòa S4 <a href="/du-an/capital-square-hudson-place-s4/">Hudson Place</a>. Theo bản đồ của chủ đầu tư: khoảng 5 phút ra biển Mỹ Khê, 30 phút đi Hội An; liền kề Vincom Plaza.</p>
<h2>Tòa C3 hợp với ai?</h2>
<ul>
<li><strong>Người mua ở, gia đình</strong>: căn 2PN+1 và 3PN góc, nhiều mặt thoáng.</li>
<li><strong>Đầu tư cho thuê</strong>: căn 1PN 45 – 47 m² gần phố đi bộ, trung tâm thương mại và khu khách sạn ven sông.</li>
<li><strong>Kinh doanh</strong>: shophouse tầng 1 – 3 mặt đường Trần Hưng Đạo và phố đi bộ.</li>
</ul>
<p>Chưa có bảng giá công khai riêng cho tòa C3; mặt bằng chào bán tham khảo chung toàn dự án khoảng 74 – 90 triệu/m² tùy tầng và hướng. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá từng căn, chính sách và mặt bằng các tầng còn lại của tòa C3, hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';

		$projects[] = array(
			'slug'    => 'capital-square-toa-c3',
			'title'   => 'Tòa C3 Capital Square Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'parent'  => 'capital-square-da-nang',
			'excerpt' => 'Tòa C3 Capital Square Đà Nẵng: 26 tầng mặt tiền Trần Hưng Đạo nhìn sông Hàn, 16 shophouse, khoảng 206 căn hộ 1PN 45 m² đến 3PN 120 m², tầng 4 sân vườn, tầng 26 penthouse.',
			'meta'    => array(
				'hh_p_status'        => 'dang-mo-ban',
				'hh_p_developer'     => 'Hệ sinh thái BRG Group (tổ hợp Capital Square)',
				'hh_p_type'          => 'Căn hộ cao cấp ven sông Hàn, shophouse khối đế',
				'hh_p_map_address'   => 'Capital Square, Trần Hưng Đạo, An Hải, Đà Nẵng',
				'hh_p_address'       => 'Mặt tiền đường Trần Hưng Đạo, tổ hợp Capital Square, phường An Hải (Sơn Trà cũ), Đà Nẵng',
				'hh_p_blocks'        => '1 tòa (C3)',
				'hh_p_floors'        => '26 tầng: shophouse tầng 1 – 3, căn sân vườn tầng 4, penthouse tầng 26; không có tầng 13',
				'hh_p_units'         => 'Khoảng 206 căn hộ và 16 shophouse (tính theo mô tả phân tầng)',
				'hh_p_unit_area'     => '1PN 45,01 – 47,43 m² · 2PN 65,82 – 66,16 m² · 2PN+1 78,45 – 78,51 m² · 3PN 119,71 m² (thông thủy, tầng điển hình)',
				'hh_p_unit_types'    => "Căn 1PN | 45,01 – 47,43 m² | 1 | Liên hệ\nCăn 2PN | 65,82 – 66,16 m² | 2 | Liên hệ\nCăn 2PN+1 | 78,45 – 78,51 m² | 2 + phòng đa năng | Liên hệ\nCăn 3PN | 119,71 m² | 3 | Liên hệ\nPenthouse tầng 26 | Liên hệ | – | Liên hệ\nShophouse tầng 1 – 3 | Liên hệ | – | Liên hệ",
				'hh_p_ownership'     => 'Sở hữu lâu dài (theo thông tin chung tổ hợp Capital Square)',
				'hh_p_shop_desc'     => '16 căn shophouse tầng 1 – 3 khối đế, mặt đường Trần Hưng Đạo và phố đi bộ Park Boulevard.',
				'hh_p_highlights'    => "Mặt tiền Trần Hưng Đạo, hàng tòa đầu tiên nhìn sông Hàn\n26 tầng: 16 shophouse, căn sân vườn tầng 4, penthouse tầng 26\nTầng điển hình 9 căn: 1PN, 2PN, 2PN+1 và căn 3PN gần 120 m² góc sông Hàn\nGiữa Con đường Ánh sáng, phố đi bộ Park Boulevard và Grand Central Mall\nLiền kề Vincom Plaza, 5 phút ra biển Mỹ Khê (theo chủ đầu tư)",
				'hh_p_design_desc'   => 'Tầng 10 – 12, 14 – 25: 9 căn/sàn – C3-06 (1PN 47,43 m²), C3-06A (1PN 45,01 m²), C3-08 (2PN 66,16 m²), C3-09 (2PN 65,93 m²), C3-10 (2PN+1 78,51 m²) phía Con đường Ánh sáng; C3-05 (3PN 119,71 m²), C3-03 và C3-02 (2PN 65,82 m²), C3-01 (2PN+1 78,45 m²) phía phố đi bộ Park Boulevard. Tầng 5 – 8 có 10 căn (thêm C3-03A), tầng 12A có 8 căn và 1 gian diện tích sử dụng riêng của chủ đầu tư, tầng 26 có 4 căn penthouse.',
				'hh_p_location_desc' => 'Dãy mặt tiền đường Trần Hưng Đạo của tổ hợp Capital Square, nhìn sông Hàn; phía Bắc là Con đường Ánh sáng, phía Nam phố đi bộ Park Boulevard, phía Đông Grand Central Mall.',
				'hh_p_connections'   => "Mặt tiền | Đường Trần Hưng Đạo, sông Hàn\nLiền kề | Grand Central Mall, Vincom Plaza\n5 phút | Biển Mỹ Khê (theo chủ đầu tư)\n30 phút | Hội An (theo chủ đầu tư)",
				'hh_p_amenities_in'  => "Grand Central Mall, phố đi bộ Park Boulevard\nCon đường Ánh sáng, quảng trường nội khu\nBể bơi resort, sân vườn, sân chơi trẻ em\nSân thể thao, BBQ, outdoor gym",
				'hh_p_amenities_out' => "Vincom Plaza Đà Nẵng\nCầu Sông Hàn, cầu Rồng\nBiển Mỹ Khê",
				'hh_p_image_links'   => implode( "\n", $lines ),
				'hh_p_faq'           => "Tòa C3 Capital Square có bao nhiêu tầng? | 26 tầng: tầng 1 – 3 shophouse (16 căn), tầng 4 căn hộ sân vườn, tầng 5 – 25 căn hộ (có tầng 12A, không có tầng 13), tầng 26 penthouse.\nTòa C3 có bao nhiêu căn hộ? | Khoảng 206 căn hộ theo mô tả phân tầng, cộng 16 shophouse; số chính thức theo tài liệu chủ đầu tư.\nCăn hộ tòa C3 diện tích bao nhiêu? | Tầng điển hình: 1PN 45,01 – 47,43 m², 2PN 65,82 – 66,16 m², 2PN+1 78,45 – 78,51 m², 3PN 119,71 m² thông thủy.\nCăn nào tòa C3 nhìn sông Hàn? | Đầu hồi phía Tây: căn 3PN C3-05 và căn 1PN C3-06; tầng cao nhìn sông rõ hơn.\nTòa C3 nằm ở đâu trong Capital Square? | Dãy mặt tiền đường Trần Hưng Đạo, giữa Con đường Ánh sáng và phố đi bộ Park Boulevard, cạnh Grand Central Mall.",
			),
			'content' => $content,
			'sources' => array( 'https://www.capital-square.vn/' ),
		);
		return $projects;
	},
	21
);
