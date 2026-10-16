<?php
/**
 * Hudson Place (tòa S4) – phân khu Capital Square 3 (CĐT SIH), tổ hợp Capital Square Đà Nẵng.
 * Nguồn: tài liệu đào tạo bán hàng tòa S4 ngày 28/9/2026 anh Hiệp gửi (16/10/2026): thông số, mặt bằng tầng, loại căn,
 * chính sách quà tặng – thanh toán – vay, tiêu chuẩn bàn giao, quy trình chuyển nhượng hợp đồng mua bán.
 * Tên tòa theo mặt bằng tiện ích tổng thể của chủ đầu tư (số 12 – Hudson Place); mã "S4" là mã bán hàng,
 * chưa đối chiếu được với mã khối trong thông báo của Sở Xây dựng nên không ghép vào trang khối MAT.
 * Ảnh trong img/hudson-place/ đã cắt bỏ dòng chữ của đơn vị phân phối; không dùng mã QR, trang giới thiệu đơn vị phân phối.
 * Chính sách là theo tài liệu tại thời điểm 28/9/2026, có thể thay đổi theo đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/hudson-place/hudson-place-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'phoi-canh-toa-s4-ven-song-han', 'Phối cảnh Hudson Place tòa S4 Capital Square Đà Nẵng ven sông Hàn, 24 tầng, 314 căn hộ', 'đại diện' ),
			$img( 'mat-bang-tong-the-capital-square', 'Mặt bằng tiện ích tổng thể Capital Square Đà Nẵng, Hudson Place là tòa số 12', 'tổng thể' ),
			$img( 'toan-canh-capital-square-ven-song', 'Phối cảnh tổ hợp Capital Square Đà Nẵng bên bờ Đông sông Hàn, nhìn về cầu Rồng', 'thư viện' ),
			$img( 'vi-tri-toa-s4-tien-do-thi-cong', 'Vị trí tòa S4 Hudson Place giáp đường Nguyễn Công Trứ và ảnh thi công tòa S4, S3 tháng 9/2026', 'tiến độ', 'Tháng 9/2026' ),
			$img( 'mat-bang-tien-ich-quanh-toa-s4', 'Mặt bằng tiện ích quanh tòa S4: bể bơi resort, sân vườn, sân golf mini, sân chơi trẻ em', 'tiện ích', 'Tiện ích quanh tòa S4' ),
			$img( 'mat-bang-tang-5-12-14-24', 'Mặt bằng tầng 5 – 12 và 14 – 24 tòa S4 Hudson Place: 15 căn/sàn', 'mặt bằng', 'Tầng 5 – 12, 14 – 24' ),
			$img( 'mat-bang-tang-12a', 'Mặt bằng tầng 12A tòa S4 Hudson Place: 14 căn và không gian riêng của chủ đầu tư', 'mặt bằng', 'Tầng 12A' ),
			$img( 'layout-can-1pn', 'Layout căn hộ 1 phòng ngủ Hudson Place S4 (46,33 – 47,17 m² thông thủy)', 'layout', 'Căn 1PN' ),
			$img( 'layout-can-2pn', 'Layout căn hộ 2 phòng ngủ Hudson Place S4 (72 – 74,31 m² thông thủy, 2 logia)', 'layout', 'Căn 2PN' ),
			$img( 'layout-can-3pn-dualkey', 'Layout căn hộ 3 phòng ngủ dualkey Hudson Place S4: căn 2 phòng ngủ cộng studio riêng cửa', 'layout', 'Căn 3PN dualkey' ),
			$img( 'be-boi-resort', 'Bể bơi resort cạnh tòa S4 Hudson Place, Capital Square Đà Nẵng', 'tiện ích', 'Bể bơi resort' ),
			$img( 'be-boi-cafe-ngoai-troi', 'Bể bơi và quầy café ngoài trời nội khu Capital Square 3', 'tiện ích', 'Café bên hồ bơi' ),
			$img( 'san-choi-tre-em', 'Sân chơi trẻ em cạnh bể bơi tòa S4 Hudson Place', 'tiện ích', 'Sân chơi trẻ em' ),
			$img( 'san-vuon-thu-gian', 'Sân vườn thư giãn trên khối đế, nhìn ra sông Hàn', 'tiện ích', 'Sân vườn thư giãn' ),
			$img( 'san-golf-mini', 'Sân golf mini nội khu Capital Square 3', 'tiện ích', 'Sân golf mini' ),
			$img( 'choi-nghi-cafe-noi-khu', 'Chòi nghỉ và café ngoài trời trên trục nội khu Capital Square', 'tiện ích', 'Chòi nghỉ' ),
			$img( 'tieu-chuan-ban-giao', 'Tiêu chuẩn bàn giao căn hộ bán hoàn thiện Hudson Place S4: phòng tắm đủ thiết bị, cửa chống cháy smartkey, ban công', 'thư viện', 'Tiêu chuẩn bàn giao' ),
		);
		$content = '<p><strong>Hudson Place</strong> (mã bán hàng <strong>tòa S4</strong>) là tòa căn hộ 24 tầng, 314 căn thuộc phân khu <strong>Capital Square 3</strong> do Công ty CP Bất động sản SIH làm chủ đầu tư, nằm trong <a href="/du-an/capital-square-da-nang/">tổ hợp Capital Square Đà Nẵng</a> ven sông Hàn. Tòa có căn 1PN, 2PN, 3PN và 3PN dualkey, dự kiến bàn giao quý III/2027, sổ hồng sở hữu lâu dài, đơn vị vận hành Savills.</p>
<h2>Thông số tòa S4 Hudson Place</h2>
<table>
<tbody>
<tr><th>Phân khu</th><td>Capital Square 3 – tòa số 12 trên mặt bằng tổng thể</td></tr>
<tr><th>Chủ đầu tư</th><td>Công ty CP Bất động sản SIH</td></tr>
<tr><th>Quy mô</th><td>24 tầng, 314 căn hộ; tầng điển hình 15 căn/sàn, hành lang rộng 2 m</td></tr>
<tr><th>Loại căn</th><td>1PN, 2PN, 3PN, 3PN dualkey</td></tr>
<tr><th>Bàn giao</th><td>Quý III/2027 (dự kiến), bán hoàn thiện</td></tr>
<tr><th>Pháp lý</th><td>Sở hữu lâu dài</td></tr>
<tr><th>Vận hành</th><td>Savills</td></tr>
<tr><th>Hình thức mua</th><td>Ký hợp đồng chuyển nhượng hợp đồng mua bán tại văn phòng chủ đầu tư</td></tr>
</tbody>
</table>
<h2>Vị trí trong tổ hợp Capital Square</h2>
<p>Hudson Place nằm ở góc phía Nam tổ hợp, mặt tiếp giáp đường Nguyễn Công Trứ (đường 2 làn xe), ngay cạnh bể bơi resort và cụm tiện ích lớn nhất toàn khu. Theo bản đồ của chủ đầu tư: cầu Sông Hàn khoảng 300 m, cầu Rồng khoảng 1 km, biển Mỹ Khê khoảng 1,5 km; phía Bắc là trục Đại lộ Ánh sáng, Grand Central Mall và Vincom Plaza. Ảnh tiến độ tháng 9/2026 cho thấy tòa S4 và tòa S3 (Broadway Place) đang thi công phần thân.</p>
<h2>Mặt bằng tầng: 15 căn/sàn, 100% phòng lấy sáng tự nhiên</h2>
<p>Tầng 5 – 12 và 14 – 24 có 15 căn: 2 căn 1PN, 7 căn 2PN và 6 căn 3PN. Dãy căn phía Nam (S4-01 đến S4-08) nhìn về cầu Rồng, bể bơi và khu vui chơi trẻ em; dãy phía Bắc (S4-09 đến S4-15) nhìn sân vườn nội khu; đầu hồi phía Tây nhìn sông Hàn, đầu hồi phía Đông nhìn sân golf mini và vườn thư giãn. Tầng 12A có 14 căn, vị trí căn S4-12B là không gian sử dụng riêng của chủ đầu tư.</p>
<table>
<thead><tr><th>Mã căn</th><th>Loại</th><th>Thông thủy</th><th>Tim tường</th></tr></thead>
<tbody>
<tr><td>S4-12, S4-12A</td><td>1PN</td><td>46,33 – 47,17 m²</td><td>50,44 – 51,56 m²</td></tr>
<tr><td>S4-03, 03A, 05, 06, 10, 11</td><td>2PN</td><td>72,00 – 73,12 m²</td><td>77,15 – 78,12 m²</td></tr>
<tr><td>S4-12B</td><td>2PN</td><td>74,31 m²</td><td>79,29 m²</td></tr>
<tr><td>S4-01, S4-08</td><td>3PN</td><td>91,29 – 91,40 m²</td><td>98,64 m²</td></tr>
<tr><td>S4-02, 06A, 09, 15</td><td>3PN (có dualkey)</td><td>101,00 – 101,62 m²</td><td>108,39 – 109,86 m²</td></tr>
</tbody>
</table>
<h3>Đặc điểm từng loại căn</h3>
<p><strong>Căn 1PN</strong> tài chính thấp, hợp người độc thân, gia đình trẻ hoặc nhà đầu tư cho thuê. <strong>Căn 2PN</strong> layout vuông, đều có 2 logia, hợp gia đình nhỏ hoặc vừa và kinh doanh cho thuê. <strong>Căn 3PN dualkey</strong> chia thành một căn 2 phòng ngủ và một studio có cửa riêng: ở hai thế hệ, hoặc vừa ở vừa cho thuê phần studio.</p>
<h2>Chính sách bán hàng (tài liệu ngày 28/9/2026)</h2>
<ul>
<li><strong>Quà tặng:</strong> miễn phí phí quản lý dịch vụ 1 năm; gói smarthome trừ thẳng vào giá căn: 1PN 100 triệu, 2PN 200 triệu, 3PN 300 triệu.</li>
<li><strong>Thanh toán theo tiến độ:</strong> ưu đãi 8%.</li>
<li><strong>Thanh toán nhanh</strong> 100% giá chuyển nhượng hợp đồng: ưu đãi 12%.</li>
<li><strong>Thanh toán sớm</strong> 95% giá bán căn hộ: ưu đãi 18%.</li>
<li><strong>Vay:</strong> ngân hàng cho vay tới 70% tổng giá bán (có VAT, không gồm kinh phí bảo trì), ân hạn nợ gốc 36 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ lãi suất. Phương án 1: lãi suất 0% 36 tháng cho khoản vay 50% giá bán, 24 tháng cho khoản 20%. Phương án 2: 0% 24 tháng cho 50%, 12 tháng cho 20%, sau đó cố định 7,5%/năm trong 36 tháng tiếp theo.</li>
</ul>
<p>Chính sách áp dụng theo từng đợt và từng căn; Hoàng Hiệp gửi phiếu tính giá đúng căn và phương án thanh toán anh/chị chọn.</p>
<h2>Quy trình mua: chuyển nhượng hợp đồng mua bán</h2>
<p>Căn hộ tại Capital Square 3 được bán theo hình thức <strong>chuyển nhượng hợp đồng mua bán (HĐMB)</strong>: chủ sở hữu HĐMB là Công ty CP Đầu tư Dịch vụ Vui chơi Giải trí Thể thao Hà Nội (đơn vị thành viên hệ sinh thái BRG), khách hàng ký hợp đồng chuyển nhượng tại văn phòng chủ đầu tư.</p>
<ol>
<li>Ký thỏa thuận đặt cọc chuyển nhượng (TTĐCCN) với chủ sở hữu, đặt cọc 100 triệu/căn, trong 2 ngày kể từ khi nộp đủ cọc.</li>
<li>Ký hợp đồng chuyển nhượng HĐMB, thanh toán theo tỷ lệ của phương án đã chọn.</li>
<li>Thanh toán hoặc ngân hàng giải ngân các đợt tiếp theo với chủ đầu tư SIH: đợt bàn giao, và 5% cuối khi căn hộ được cấp giấy chứng nhận.</li>
</ol>
<p>Hai khái niệm cần hiểu khi xem giá: <em>giá chuyển nhượng hợp đồng</em> là số tiền bên bán đã đóng cho chủ đầu tư cộng phần chênh bên mua chấp nhận; <em>tổng giá bán căn hộ</em> bằng giá chuyển nhượng cộng phần giá trị HĐMB còn lại chưa thanh toán cho chủ đầu tư. Theo tài liệu, chủ sở hữu chịu trách nhiệm đóng thuế theo quy định. Trước khi ký, nên xem bản gốc HĐMB, xác nhận của chủ đầu tư về tình trạng hợp đồng và số tiền đã thanh toán.</p>
<h2>Tiêu chuẩn bàn giao: bán hoàn thiện</h2>
<p>Phòng vệ sinh hoàn thiện đầy đủ thiết bị; cửa chính chống cháy có khóa smartkey và chuông cửa camera; ban công, logia hoàn thiện. Tường, vách ngăn được trát phẳng, ống gen chờ sẵn đầu điện nước; sàn chống thấm, cán phẳng để chủ nhà tự hoàn thiện theo ý thích.</p>
<h2>Tiện ích quanh tòa S4</h2>
<p>Bể bơi resort, bể bơi trẻ em, sân chơi trẻ em, sân golf mini, sân vườn thư giãn, đồi chà là, chòi nghỉ và café ngoài trời; trong tổ hợp có công viên khoảng 2.000 m², Grand Central Mall, sân pickleball, sân bóng rổ, khu BBQ, outdoor gym, sân khấu ngoài trời, đường dạo trên cao.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá từng căn, phiếu tính dòng tiền theo phương án vay hoặc thanh toán sớm của Hudson Place, hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';

		$projects[] = array(
			'slug'    => 'capital-square-hudson-place-s4',
			'title'   => 'Hudson Place S4 Capital Square Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'son-tra',
			'parent'  => 'capital-square-da-nang',
			'excerpt' => 'Hudson Place (tòa S4) – Capital Square 3, CĐT SIH: 24 tầng, 314 căn 1PN, 2PN, 3PN và 3PN dualkey ven sông Hàn, bàn giao quý III/2027, vận hành Savills, vay 70% hỗ trợ lãi suất 0% tới 36 tháng.',
			'meta'    => array(
				'hh_p_status'        => 'dang-mo-ban',
				'hh_p_developer'     => 'Công ty CP Bất động sản SIH (hệ sinh thái BRG Group)',
				'hh_p_manager'       => 'Savills (vận hành)',
				'hh_p_type'          => 'Căn hộ cao cấp ven sông Hàn',
				'hh_p_map_address'   => 'Capital Square, Trần Hưng Đạo, An Hải, Đà Nẵng',
				'hh_p_address'       => 'Đường Nguyễn Công Trứ, tổ hợp Capital Square, phường An Hải (Sơn Trà cũ), Đà Nẵng',
				'hh_p_blocks'        => '1 tòa (S4), thuộc phân khu Capital Square 3',
				'hh_p_floors'        => '24 tầng; tầng điển hình 15 căn/sàn',
				'hh_p_units'         => '314 căn hộ',
				'hh_p_unit_area'     => '1PN 46,33 – 47,17 m² · 2PN 72,00 – 74,31 m² · 3PN 91,29 – 101,62 m² (thông thủy)',
				'hh_p_unit_types'    => "Căn 1PN | 46,33 – 47,17 m² | 1 | Liên hệ\nCăn 2PN (2 logia) | 72,00 – 74,31 m² | 2 | Liên hệ\nCăn 3PN | 91,29 – 91,40 m² | 3 | Liên hệ\nCăn 3PN dualkey (2PN + studio) | 101,00 – 101,62 m² | 3 | Liên hệ",
				'hh_p_handover'      => 'Quý III/2027 (dự kiến), bán hoàn thiện',
				'hh_p_ownership'     => 'Sở hữu lâu dài (sổ hồng từng căn)',
				'hh_p_legal'         => 'Sở hữu lâu dài; mua theo hình thức chuyển nhượng hợp đồng mua bán, ký tại văn phòng chủ đầu tư',
				'hh_p_progress'      => "9/2026 | Tòa S4 Hudson Place và tòa S3 Broadway Place đang thi công phần thân\nQuý III/2027 | Dự kiến bàn giao căn hộ bán hoàn thiện",
				'hh_p_offer_title'   => 'Ưu đãi tới 18% khi thanh toán sớm 95%, tặng gói smarthome 100 – 300 triệu trừ vào giá',
				'hh_p_policy'        => "Miễn phí phí quản lý dịch vụ 1 năm\nGói smarthome trừ thẳng vào giá: 1PN 100 triệu, 2PN 200 triệu, 3PN 300 triệu\nThanh toán theo tiến độ: ưu đãi 8%\nThanh toán nhanh 100% giá chuyển nhượng hợp đồng: ưu đãi 12%\nThanh toán sớm 95% giá bán căn hộ: ưu đãi 18%\nChính sách theo tài liệu bán hàng 28/9/2026 – thay đổi theo đợt",
				'hh_p_loan'          => 'Vay tới 70% tổng giá bán (có VAT, không gồm kinh phí bảo trì), ân hạn gốc 36 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ lãi suất. Phương án 1: lãi suất 0% 36 tháng với 50% giá bán, 24 tháng với 20%. Phương án 2: 0% 24 tháng với 50%, 12 tháng với 20%, sau đó cố định 7,5%/năm trong 36 tháng.',
				'hh_p_payment'       => "Ký thỏa thuận đặt cọc chuyển nhượng | Trong 2 ngày kể từ khi nộp đủ cọc | 100 triệu/căn\nKý hợp đồng chuyển nhượng HĐMB | Trong 15 ngày kể từ ký thỏa thuận đặt cọc | Theo phương án chọn\nBàn giao căn hộ | Theo thông báo bàn giao của chủ đầu tư | Kinh phí bảo trì + VAT 5% giá bán\nNhận giấy chứng nhận | Theo thông báo của chủ đầu tư | 5% giá bán HĐMB",
				'hh_p_highlights'    => "24 tầng, 314 căn – tòa S4 cạnh bể bơi và cụm tiện ích lớn nhất Capital Square\nLayout vuông, 100% phòng lấy sáng tự nhiên, hành lang 2 m, 15 căn/sàn\nCăn 2PN đều có 2 logia; có dòng 3PN dualkey (2PN + studio riêng cửa)\nView cầu Rồng, view chéo sông Hàn, sân vườn và sân golf mini nội khu\nVay 70%, lãi suất 0% tới 36 tháng, ân hạn gốc 36 tháng\nBàn giao quý III/2027, vận hành Savills",
				'hh_p_design_desc'   => 'Tầng 5 – 12 và 14 – 24: 15 căn/sàn gồm 2 căn 1PN (S4-12, S4-12A, khoảng 46 – 47 m²), 7 căn 2PN (S4-03, 03A, 05, 06, 10, 11, 12B, khoảng 72 – 74 m²) và 6 căn 3PN (S4-01, 08 khoảng 91 m²; S4-02, 06A, 09, 15 khoảng 101 m², có thiết kế dualkey). Dãy phía Nam nhìn cầu Rồng, bể bơi, khu vui chơi trẻ em; dãy phía Bắc nhìn sân vườn nội khu; đầu hồi Tây nhìn sông Hàn, đầu hồi Đông nhìn sân golf mini và vườn thư giãn. Tầng 12A có 14 căn (vị trí S4-12B là không gian riêng của chủ đầu tư). Không có tầng 13.',
				'hh_p_location_desc' => 'Tòa S4 nằm góc phía Nam tổ hợp Capital Square, mặt tiếp giáp đường Nguyễn Công Trứ, cạnh bể bơi resort và Sales Gallery; cách cầu Sông Hàn khoảng 300 m, cầu Rồng khoảng 1 km, biển Mỹ Khê khoảng 1,5 km.',
				'hh_p_connections'   => "Khoảng 300 m | Cầu Sông Hàn\nKhoảng 1 km | Cầu Rồng\nKhoảng 1,5 km | Biển Mỹ Khê\nLiền kề | Vincom Plaza, Grand Central Mall",
				'hh_p_amenities_in'  => "Bể bơi resort, bể bơi trẻ em\nSân chơi trẻ em, sân golf mini\nSân vườn thư giãn, đồi chà là, chòi nghỉ\nCafé ngoài trời, khu BBQ, outdoor gym\nCông viên khoảng 2.000 m², Grand Central Mall\nSân pickleball, sân bóng rổ, đường dạo trên cao",
				'hh_p_amenities_out' => "Vincom Plaza Đà Nẵng\nCầu Sông Hàn, cầu Rồng, Quảng trường sông Hàn\nBiển Mỹ Khê",
				'hh_p_image_links'   => implode( "\n", $lines ),
				'hh_p_faq'           => "Hudson Place S4 có bao nhiêu căn? | 24 tầng, 314 căn hộ; tầng điển hình 15 căn/sàn gồm 2 căn 1PN, 7 căn 2PN và 6 căn 3PN.\nHudson Place S4 bao giờ bàn giao? | Dự kiến quý III/2027, bàn giao bán hoàn thiện: phòng tắm đủ thiết bị, cửa chống cháy smartkey, sàn và tường trát phẳng.\nHudson Place S4 có sổ hồng lâu dài không? | Có, sở hữu lâu dài. Khách mua theo hình thức chuyển nhượng hợp đồng mua bán, ký tại văn phòng chủ đầu tư SIH.\nVay mua Hudson Place S4 được bao nhiêu? | Tới 70% tổng giá bán, lãi suất 0% tới 36 tháng (phương án 1), ân hạn gốc 36 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ lãi suất.\nThanh toán sớm Hudson Place S4 được ưu đãi bao nhiêu? | Theo tài liệu 28/9/2026: thanh toán tiến độ 8%, thanh toán nhanh 100% giá chuyển nhượng 12%, thanh toán sớm 95% giá bán 18%; tặng gói smarthome 100 – 300 triệu trừ vào giá.\nCăn dualkey Hudson Place là gì? | Căn 3PN khoảng 101 m² chia thành một căn 2 phòng ngủ và một studio có cửa riêng, ở hai thế hệ hoặc vừa ở vừa cho thuê.\nHudson Place S4 do ai vận hành? | Savills.",
			),
			'content' => $content,
			'sources' => array( 'https://www.capital-square.vn/' ),
		);
		return $projects;
	},
	21
);
