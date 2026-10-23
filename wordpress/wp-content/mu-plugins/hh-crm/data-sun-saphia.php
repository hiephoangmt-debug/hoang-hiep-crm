<?php
/**
 * Sun Saphia Residence – tòa căn hộ 30 tầng của Sun Group (Sun Property) trên đường Trường Sa, khu Sơn Thủy, Ngũ Hành Sơn.
 * Nguồn: slide giới thiệu dự án anh Hiệp gửi 17/10/2026 (thông số, bàn giao, bản đồ kết nối), báo chí về công viên
 * bãi tắm Sơn Thủy (đất thu hồi từ dự án Hòn Ngọc Á Châu), mở rộng Võ Nguyên Giáp – Trường Sa – Lạc Long Quân,
 * đường sắt đô thị sân bay – Mỹ Khê – Hội An. Bản vẽ chia lô Hòa Hải H1-3 (2017), hồ sơ khảo sát, bản vẽ điều chỉnh
 * quy hoạch công viên chỉ dùng để đối chiếu vị trí, không đăng. Không dùng ảnh Google Maps, ảnh báo Tuổi Trẻ, ảnh
 * minh hoạ thể thao biển (ảnh stock). Chưa có bảng giá công khai.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/sun-saphia/sun-saphia-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'phoi-canh-ven-bien-son-thuy', 'Phối cảnh Sun Saphia Residence – căn hộ 30 tầng của Sun Group bên biển Sơn Thủy, Đà Nẵng', 'đại diện' ),
			$img( 'so-do-vi-tri', 'Sơ đồ vị trí Sun Saphia Residence trên đường Trường Sa, đối diện công viên bãi tắm Sơn Thủy', 'tổng thể', 'Sơ đồ vị trí' ),
			$img( 'ban-do-ket-noi', 'Bản đồ kết nối Sun Saphia Residence: bãi tắm Sơn Thủy, Ngũ Hành Sơn, Sun Riverpolis, sân bay Đà Nẵng', 'tổng thể', 'Bản đồ kết nối' ),
			$img( 'phoi-canh-toa-thap-30-tang', 'Phối cảnh tòa tháp Sun Saphia Residence 30 tầng, cao 114 m, khối đế thương mại', 'thư viện' ),
			$img( 'poster-can-ho-mat-bien', 'Sun Saphia Residence – dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng', 'thư viện' ),
		);
		$content = '<p><strong>Sun Saphia Residence</strong> là tòa căn hộ cao 30 tầng (114 m) của <strong>Sun Group</strong> do Sun Property phát triển, nằm trên đường Trường Sa thuộc khu Sơn Thủy, phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng. Chủ đầu tư giới thiệu đây là <strong>dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng</strong>: 782 căn trên khu đất 3.720,1 m², phần lớn là studio, dự kiến bàn giao tháng 11/2028.</p>
<h2>Thông tin tổng quan Sun Saphia Residence</h2>
<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Tập đoàn Sun Group (Sun Property phát triển)</td></tr>
<tr><th>Vị trí</th><td>Đường Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng</td></tr>
<tr><th>Diện tích đất</th><td>3.720,1 m²</td></tr>
<tr><th>Quy mô</th><td>1 tòa 30 tầng, cao 114 m, 2 tầng hầm, khối đế thương mại</td></tr>
<tr><th>Tổng số căn</th><td>782 căn</td></tr>
<tr><th>Loại căn</th><td>Studio 30 – 31 m², 1PN+1 50 – 51 m², 2PN 60 – 70 m²</td></tr>
<tr><th>Bàn giao</th><td>Dự kiến tháng 11/2028</td></tr>
<tr><th>Giá</th><td>Chưa công bố – liên hệ để nhận bảng giá khi mở bán</td></tr>
</tbody>
</table>
<h2>Cơ cấu căn hộ: hơn 65% là studio</h2>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Diện tích</th><th>Phù hợp</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>513</td><td>30 – 31 m²</td><td>Cho thuê ngắn hạn, khách du lịch, người độc thân</td></tr>
<tr><td>1PN+1</td><td>108</td><td>50 – 51 m²</td><td>Cặp vợ chồng trẻ, chuyên gia thuê dài hạn</td></tr>
<tr><td>2PN</td><td>149</td><td>60 – 70 m²</td><td>Gia đình nhỏ, nghỉ dưỡng cuối tuần</td></tr>
</tbody>
</table>
<p>Ba loại căn trong tài liệu cộng lại 770 căn; 12 căn còn lại so với tổng 782 căn chưa được ghi loại (có thể là căn đặc biệt hoặc căn tầng cao) – cần chờ mặt bằng chi tiết của chủ đầu tư. Với tỷ lệ studio cao, Sun Saphia Residence nghiêng rõ về sản phẩm <strong>đầu tư cho thuê</strong> ở khu biển đông khách du lịch.</p>
<h2>Vị trí Sun Saphia Residence: đối diện công viên bãi tắm Sơn Thủy</h2>
<p>Tòa tháp nằm phía Tây đường Trường Sa, ngay khu bãi tắm Sơn Thủy – đoạn biển giữa Mỹ Khê và Non Nước. Bên kia đường, thành phố đã thu hồi khoảng <strong>2,45 ha</strong> phía Nam dự án Khu du lịch ven biển Hòn Ngọc Á Châu (bỏ hoang nhiều năm) để làm <strong>công viên công cộng</strong>, tổng mức đầu tư hơn 47 tỷ đồng từ ngân sách, thực hiện giai đoạn 2025 – 2027: bãi đậu xe, đường dạo, sân tập thể dục, khu vui chơi trẻ em, khu dã ngoại, quảng trường biển và khu tổ chức sự kiện. Cư dân vì vậy có lối ra biển qua công viên thay vì một khu đất trống.</p>
<p>Theo bản đồ kết nối của chủ đầu tư, từ dự án đến tổ hợp <a href="/du-an/sun-galaxy-complex/">Sun Galaxy</a> và <a href="/du-an/da-nang-downtown/">Đà Nẵng Downtown</a> khoảng 4 km; gần danh thắng Ngũ Hành Sơn, khu đô thị Sun Riverpolis, các resort ven biển (Premier Village, Sheraton Grand) và sân golf ven biển.</p>
<h2>Hạ tầng sắp tới quanh Sun Saphia Residence</h2>
<ul>
<li><strong>Mở rộng đường ven biển:</strong> Đà Nẵng đưa dự án mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân, vốn dự kiến <strong>2.633 tỷ đồng</strong>, vào nhóm dự án đầu tư công được ưu tiên "luồng xanh" (Tuổi Trẻ, 10/2026); phương án nghiên cứu nâng từ 4 lên 6 làn xe.</li>
<li><strong>Đường sắt đô thị sân bay – Mỹ Khê – Hội An:</strong> tuyến được thành phố ưu tiên nghiên cứu; giai đoạn đầu là tuyến LRT nối sân bay với biển Mỹ Khê. Doanh nghiệp được giao lập hồ sơ đề xuất cho biết dự kiến khởi công tháng 2/2027 nếu được phê duyệt.</li>
</ul>
<p>Các dự án hạ tầng trên đang ở bước chuẩn bị đầu tư; tiến độ thực tế có thể thay đổi.</p>
<h2>So sánh với căn hộ ven biển Đà Nẵng</h2>
<p>Tài liệu bán hàng của chủ đầu tư đưa ra mặt bằng giá chuyển nhượng tham khảo của một số dự án ven biển (chưa gồm Sun Saphia):</p>
<table>
<thead><tr><th>Dự án</th><th>Studio</th><th>1PN</th><th>2PN</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">The Soleil Đà Nẵng</a></td><td>4,6 – 5,4 tỷ</td><td>6,5 – 7,8 tỷ</td><td>12 – 17,5 tỷ</td></tr>
<tr><td>Futa Residence Đà Nẵng</td><td>9,1 – 10,5 tỷ</td><td>10,3 – 11,5 tỷ</td><td>17,4 – 17,6 tỷ</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Đà Nẵng</a></td><td>6,3 – 6,4 tỷ</td><td>10,5 – 10,6 tỷ</td><td>21,4 – 21,7 tỷ</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>–</td><td>1PN+ 5,4 – 6,4 tỷ</td><td>6,8 – 8,3 tỷ</td></tr>
</tbody>
</table>
<p>Giá trên là số liệu tham khảo trong tài liệu bán hàng, chưa phải giá chốt từng căn. Studio diện tích nhỏ 30 – 31 m² giúp tổng tiền mỗi căn Sun Saphia dễ tiếp cận hơn các căn hộ hàng hiệu sát biển Mỹ Khê, nhưng giá/m² thực tế phải chờ chủ đầu tư công bố.</p>
<h3>Sun Saphia Residence phù hợp ai?</h3>
<p>Nhà đầu tư cho thuê ngắn hạn (studio), người mua căn thứ hai để nghỉ dưỡng gần biển, khách ở xa muốn giao căn cho đơn vị vận hành. Người mua để ở lâu dài nên cân nhắc căn 1PN+1 và 2PN. Trước khi đặt chỗ, nên kiểm tra văn bản đủ điều kiện bán nhà ở hình thành trong tương lai, hình thức sở hữu và chính sách cam kết cho thuê (nếu có).</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để đăng ký nhận bảng giá, mặt bằng tầng và chính sách Sun Saphia Residence ngay khi mở bán, hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';

		$projects[] = array(
			'slug'    => 'sun-saphia-residence',
			'title'   => 'Sun Saphia Residence Đà Nẵng',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'ngu-hanh-son',
			'hot'     => true,
			'excerpt' => 'Sun Saphia Residence – căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng: tòa 30 tầng (114 m) trên đường Trường Sa, khu Sơn Thủy, 782 căn studio, 1PN+1, 2PN, đối diện công viên bãi tắm Sơn Thủy, bàn giao dự kiến 11/2028.',
			'meta'    => array(
				'hh_p_status'        => 'sap-mo-ban',
				'hh_p_developer'     => 'Tập đoàn Sun Group (Sun Property phát triển)',
				'hh_p_type'          => 'Căn hộ ven biển',
				'hh_p_address'       => 'Đường Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng',
				'hh_p_map_address'   => 'Bãi tắm Sơn Thủy, Trường Sa, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'         => '3.720,1 m² đất',
				'hh_p_blocks'        => '1 tòa',
				'hh_p_floors'        => '30 tầng (114 m), 2 tầng hầm',
				'hh_p_units'         => '782 căn hộ',
				'hh_p_unit_area'     => 'Studio 30 – 31 m² · 1PN+1 50 – 51 m² · 2PN 60 – 70 m²',
				'hh_p_unit_types'    => "Studio (513 căn) | 30 – 31 m² | Studio | Liên hệ\nCăn 1PN+1 (108 căn) | 50 – 51 m² | 1 + phòng đa năng | Liên hệ\nCăn 2PN (149 căn) | 60 – 70 m² | 2 | Liên hệ",
				'hh_p_handover'      => 'Tháng 11/2028 (dự kiến)',
				'hh_p_highlights'    => "Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng (theo chủ đầu tư)\nTòa 30 tầng cao 114 m, 782 căn, 2 tầng hầm\nĐối diện công viên bãi tắm Sơn Thủy khoảng 2,45 ha đang được thành phố đầu tư\n513 studio 30 – 31 m² – tổng tiền mỗi căn dễ tiếp cận, hợp cho thuê\nĐường ven biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân dự kiến mở rộng (2.633 tỷ đồng)\nCách Sun Galaxy và Đà Nẵng Downtown khoảng 4 km",
				'hh_p_location_desc' => 'Phía Tây đường Trường Sa, khu bãi tắm Sơn Thủy – đoạn biển giữa Mỹ Khê và Non Nước, phường Ngũ Hành Sơn (Hòa Hải cũ). Bên kia đường là công viên công cộng khoảng 2,45 ha trên phần đất thu hồi từ dự án Hòn Ngọc Á Châu.',
				'hh_p_connections'   => "Đối diện | Công viên bãi tắm Sơn Thủy\nKhoảng 4 km | Sun Galaxy, Đà Nẵng Downtown\nGần | Danh thắng Ngũ Hành Sơn\nGần | Khu đô thị Sun Riverpolis",
				'hh_p_amenities_in'  => "Khối đế thương mại\n2 tầng hầm đỗ xe\nTiện ích nội khu theo công bố của chủ đầu tư",
				'hh_p_amenities_out' => "Bãi tắm Sơn Thủy, biển Mỹ Khê – Non Nước\nCông viên công cộng ven biển (đang đầu tư)\nDanh thắng Ngũ Hành Sơn\nResort ven biển: Premier Village, Sheraton Grand, sân golf ven biển",
				'hh_p_image_links'   => implode( "\n", $lines ),
				'hh_p_faq'           => "Sun Saphia Residence ở đâu? | Trên đường Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng – đối diện công viên bãi tắm Sơn Thủy khoảng 2,45 ha.\nSun Saphia Residence có bao nhiêu căn? | 782 căn trong tòa 30 tầng cao 114 m: 513 studio 30 – 31 m², 108 căn 1PN+1 50 – 51 m², 149 căn 2PN 60 – 70 m².\nSun Saphia Residence bao giờ bàn giao? | Chủ đầu tư dự kiến bàn giao tháng 11/2028.\nGiá Sun Saphia Residence bao nhiêu? | Chưa có bảng giá công khai. Hoàng Hiệp gửi bảng giá và chính sách ngay khi chủ đầu tư công bố.\nSun Saphia Residence của chủ đầu tư nào? | Tập đoàn Sun Group, do Sun Property phát triển – theo chủ đầu tư, đây là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng.",
			),
			'content' => $content,
			'sources' => array(
				'https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp',
				'https://tienphong.vn/da-nang-rot-47-ty-dong-danh-thuc-khu-dat-vang-bo-hoang-post1767479.html',
				'https://tuoitre.vn/da-nang-mo-luong-xanh-cho-loat-du-an-dau-tu-cong-100261007145100694.htm',
				'https://tuoitre.vn/tuyen-duong-sat-do-thi-da-nang-se-khoi-cong-vao-thang-2-2027-20260420182515178.htm',
			),
		);
		/*
		 * Cập nhật 23/10/2026 theo tài liệu giới thiệu dự án của chủ đầu tư (slide 23/10): pháp lý 50 năm từ 17/09/2026,
		 * 2PN 133 căn, mặt bằng tầng 3A – 28 (28 căn/sàn), layout từng loại căn, ga LRT 09, bài toán cho thuê tham khảo.
		 * Bản trên (giữ nguyên) là dữ liệu cũ: chỉ thay ô nào trên web còn đúng bản cũ (anh chưa sửa tay).
		 */
		$i         = array_key_last( $projects );
		$p         = &$projects[ $i ];
		$old_meta  = $p['meta'];
		$add_lines = array(
			$img( 'phoi-canh-dem-toa-thap-ven-bien', 'Phối cảnh đêm tòa tháp Sun Saphia Residence 30 tầng bên biển Sơn Thủy, giao lộ Võ Nguyên Giáp – Trường Sa', 'thư viện', 'Phối cảnh về đêm' ),
			$img( 'mat-bang-tong-the-cong-vien-bai-tam', 'Mặt bằng tổng thể Sun Saphia Residence và công viên bãi tắm ven biển phía trước dự án', 'tổng thể', 'Mặt bằng tổng thể' ),
			$img( 'mat-bang-tang-3a-28', 'Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence: 19 studio, 4 căn 1PN+, 5 căn 2PN mỗi sàn', 'mặt bằng', 'Tầng 3A – 28' ),
			$img( 'layout-can-studio', 'Layout căn hộ studio Sun Saphia Residence khoảng 30 m², mặt tiền 3,8 m, sâu 9 m', 'layout', 'Căn studio' ),
			$img( 'layout-can-1pn-plus', 'Layout căn hộ 1PN+ Sun Saphia Residence khoảng 50 m², phòng ngủ và phòng đa năng', 'layout', 'Căn 1PN+' ),
			$img( 'layout-can-2pn', 'Layout căn hộ 2 phòng ngủ góc Sun Saphia Residence khoảng 60 – 70 m²', 'layout', 'Căn 2PN' ),
		);
		$new_meta  = array(
			'hh_p_type'          => 'Căn hộ ven biển (thời hạn 50 năm)',
			'hh_p_address'       => 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_floors'        => '30 tầng (114 m), 2 tầng hầm; chiều cao tầng căn hộ 3,5 m',
			'hh_p_unit_area'     => 'Studio 30 – 31 m² · 1PN+ 49 – 51 m² · 2PN 60 – 70 m² (thông thủy)',
			'hh_p_unit_types'    => "Studio (513 căn) | 30 – 31 m² | Studio | Liên hệ\nCăn 1PN+ (108 căn) | 49 – 51 m² | 1 + phòng đa năng | Liên hệ\nCăn 2PN (133 căn) | 60 – 70 m² | 2 | Liên hệ",
			'hh_p_handover'      => 'Tháng 11/2028 (dự kiến), hoàn thiện cơ bản',
			'hh_p_handover_std'  => 'Hoàn thiện cơ bản',
			'hh_p_ownership'     => 'Thời hạn 50 năm kể từ 17/09/2026 (thời hạn dự án); công trình cấp I, niên hạn sử dụng 100 năm',
			'hh_p_legal'         => 'Thời hạn dự án 50 năm kể từ ngày 17/09/2026; công trình cấp I, niên hạn sử dụng 100 năm (theo tài liệu chủ đầu tư 10/2026)',
			'hh_p_loan_bank'     => 'VietinBank, BIDV, NCB',
			'hh_p_design_desc'   => 'Mặt bằng tầng điển hình 3A – 28 có 28 căn/sàn: 19 studio (thông thủy 30 – 31 m², căn góc 40 m²), 4 căn 1PN+ (49 – 51 m²) và 5 căn 2PN (60 – 70 m²). Dãy căn phía Đông hướng biển Mỹ Khê – Sơn Thủy; căn 2PN nằm ở các góc tòa. Studio mặt tiền 3,8 m, sâu 9 m; căn 1PN+ có thêm phòng đa năng. Kiến trúc lấy cảm hứng từ điêu khắc Chăm Pa và hình tượng vũ nữ Apsara.',
			'hh_p_highlights'    => "Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng (theo chủ đầu tư)\nTòa 30 tầng cao 114 m, 782 căn, chiều cao tầng căn hộ 3,5 m\nĐối diện công viên bãi tắm ven biển khoảng 2,45 ha thành phố đang đầu tư\nKhoảng 500 m tới ga LRT 09 tuyến đường sắt đô thị sân bay – biển\nTầm nhìn biển Mỹ Khê, Ngũ Hành Sơn, sông và đô thị\nThời hạn 50 năm từ 17/09/2026, ngân hàng hỗ trợ VietinBank, BIDV, NCB",
			'hh_p_location_desc' => 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy – đoạn biển giữa Mỹ Khê và Non Nước. Phía trước là công viên công cộng khoảng 2,45 ha trên phần đất thu hồi từ dự án Hòn Ngọc Á Châu; khoảng 500 m tới ga LRT 09.',
			'hh_p_connections'   => "Đối diện | Công viên bãi tắm ven biển\nKhoảng 500 m | Ga LRT 09 (đường sắt đô thị, dự kiến)\nKhoảng 4 km | Sun Galaxy, Đà Nẵng Downtown\nGần | Danh thắng Ngũ Hành Sơn, Sun Riverpolis",
			'hh_p_amenities_in'  => "Bể bơi view biển, yoga\nGym, pilates\nKhối đế thương mại\n2 tầng hầm đỗ xe",
			'hh_p_amenities_out' => "Chuỗi 3 công viên bãi tắm: Sơn Thủy, công viên đối diện dự án, công viên bãi tắm Huyền Trân Công Chúa\nThể thao biển: kayak, SUP, dù lượn, jetski\nDanh thắng Ngũ Hành Sơn\nResort ven biển, sân golf; trường học, siêu thị, bệnh viện",
			'hh_p_rental'        => 'Bài toán tham khảo của chủ đầu tư (cho thuê ngắn ngày): studio 30 m² giá tham khảo 3 tỷ, 2,5 triệu/đêm, lấp đầy 60% → lợi nhuận khoảng 351 triệu/năm (11,7%); 1PN 50 m² giá tham khảo 4,5 tỷ, 3,5 triệu/đêm → khoảng 492 triệu/năm (10,9%). Đây là giả định của tài liệu bán hàng, không phải cam kết.',
			'hh_p_image_links'   => implode( "\n", array_merge( $lines, $add_lines ) ),
			'hh_p_faq'           => "Sun Saphia Residence ở đâu? | Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng – đối diện công viên bãi tắm khoảng 2,45 ha.\nSun Saphia Residence có bao nhiêu căn? | 782 căn trong tòa 30 tầng cao 114 m; theo tài liệu 10/2026: 513 studio 30 – 31 m², 108 căn 1PN+ khoảng 50 m², 133 căn 2PN 60 – 70 m².\nSun Saphia Residence sở hữu bao lâu? | Thời hạn dự án 50 năm kể từ ngày 17/09/2026; công trình cấp I, niên hạn sử dụng 100 năm.\nSun Saphia Residence bao giờ bàn giao? | Dự kiến tháng 11/2028, tiêu chuẩn hoàn thiện cơ bản.\nGiá Sun Saphia Residence bao nhiêu? | Chưa có bảng giá chính thức; bài toán cho thuê trong tài liệu chủ đầu tư dùng giá tham khảo studio 30 m² khoảng 3 tỷ, căn 1PN 50 m² khoảng 4,5 tỷ.\nNgân hàng nào hỗ trợ vay mua Sun Saphia Residence? | VietinBank, BIDV và NCB theo tài liệu giới thiệu dự án.",
		);
		$p['fix_meta'] = (array) ( $p['fix_meta'] ?? array() );
		foreach ( $new_meta as $k => $v ) {
			if ( isset( $old_meta[ $k ] ) && $old_meta[ $k ] !== $v ) {
				$p['fix_meta'][ $k ] = array( $old_meta[ $k ] );
			}
			$p['meta'][ $k ] = $v;
		}
		$p['fix_content'] = array( $p['content'] );
		$p['fix_excerpt'] = $p['excerpt'];
		$p['excerpt']     = 'Sun Saphia Residence – căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng: tòa 30 tầng (114 m) giao lộ Võ Nguyên Giáp – Trường Sa, 782 căn studio, 1PN+, 2PN, thời hạn 50 năm, đối diện công viên bãi tắm Sơn Thủy, bàn giao 11/2028.';
		$p['type']         = array( 'can-ho-dich-vu' );
		$p['remove_types'] = array( 'can-ho-so-huu-lau-dai' ); // Tài liệu chủ đầu tư: thời hạn 50 năm.
		$p['content']      = '<p><strong>Sun Saphia Residence</strong> là tòa căn hộ cao 30 tầng (114 m) của <strong>Sun Group</strong> do Sun Property phát triển, tại giao lộ <strong>Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa</strong>, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng. Chủ đầu tư giới thiệu đây là <strong>dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng</strong>: 782 căn trên khu đất 3.720,1 m², phần lớn là studio, thời hạn 50 năm, dự kiến bàn giao tháng 11/2028.</p>
<h2>Thông tin tổng quan Sun Saphia Residence</h2>
<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Tập đoàn Sun Group (Sun Property phát triển)</td></tr>
<tr><th>Vị trí</th><td>Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn</td></tr>
<tr><th>Diện tích đất</th><td>3.720,1 m²</td></tr>
<tr><th>Quy mô</th><td>1 tòa 30 tầng, cao 114 m, 2 tầng hầm; chiều cao tầng căn hộ 3,5 m</td></tr>
<tr><th>Tổng số căn</th><td>782 căn</td></tr>
<tr><th>Loại căn</th><td>Studio 30 – 31 m² (513 căn), 1PN+ 49 – 51 m² (108 căn), 2PN 60 – 70 m² (133 căn)</td></tr>
<tr><th>Pháp lý</th><td>Thời hạn dự án 50 năm kể từ 17/09/2026; công trình cấp I, niên hạn sử dụng 100 năm</td></tr>
<tr><th>Bàn giao</th><td>Dự kiến tháng 11/2028, hoàn thiện cơ bản</td></tr>
<tr><th>Ngân hàng hỗ trợ</th><td>VietinBank, BIDV, NCB</td></tr>
<tr><th>Giá</th><td>Chưa có bảng giá chính thức – liên hệ để nhận khi mở bán</td></tr>
</tbody>
</table>
<h2>Mặt bằng tầng 3A – 28: 28 căn mỗi sàn</h2>
<p>Theo mặt bằng tầng điển hình của chủ đầu tư, mỗi sàn từ tầng 3A đến 28 có <strong>28 căn</strong>: 19 studio, 4 căn 1PN+ và 5 căn 2PN. Dãy căn phía Đông nhìn thẳng ra biển; các căn 2PN nằm ở góc tòa nên có hai mặt thoáng.</p>
<table>
<thead><tr><th>Loại căn</th><th>Số căn toàn dự án</th><th>Thông thủy</th><th>Mỗi sàn điển hình</th><th>Phù hợp</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>513</td><td>30 – 31 m² (căn góc 40 m²)</td><td>19 căn</td><td>Cho thuê ngắn ngày, khách du lịch, người độc thân</td></tr>
<tr><td>1PN+</td><td>108</td><td>49 – 51 m²</td><td>4 căn</td><td>Vợ chồng trẻ, làm việc từ xa, thuê dài hạn</td></tr>
<tr><td>2PN</td><td>133</td><td>60 – 70 m²</td><td>5 căn</td><td>Gia đình nhỏ, second home nghỉ dưỡng</td></tr>
</tbody>
</table>
<p>Ba loại căn cộng lại 754 căn; số căn còn lại so với tổng 782 thuộc các tầng có mặt bằng khác, chủ đầu tư chưa công bố chi tiết. Studio có mặt tiền 3,8 m, sâu 9 m; căn 1PN+ có thêm phòng đa năng làm phòng làm việc hoặc phòng ngủ nhỏ.</p>
<h2>Pháp lý: thời hạn 50 năm, công trình niên hạn 100 năm</h2>
<p>Tài liệu giới thiệu dự án ghi: <strong>thời hạn dự án 50 năm kể từ ngày 17/09/2026</strong>, công trình cấp I với niên hạn sử dụng 100 năm. Đây là dạng căn hộ có thời hạn (thường gọi căn hộ 50 năm) – khác với căn hộ sở hữu lâu dài trên đất ở. Nghị quyết 278/NQ-CP ngày 18/9/2026 của Chính phủ giao các bộ làm rõ thời hạn sử dụng chung cư theo niên hạn công trình và quyền, nghĩa vụ khi hết thời hạn – hướng tới tách bạch quyền sở hữu căn hộ và quyền sử dụng đất. Người mua nên đối chiếu thời hạn ghi trong hợp đồng mua bán khi ký.</p>
<h2>Vị trí: trước mặt là biển, sau lưng là sông, bên cạnh là núi</h2>
<p>Tòa tháp nằm ngay khu bãi tắm Sơn Thủy – đoạn biển giữa Mỹ Khê và Non Nước. Phía trước, thành phố thu hồi khoảng <strong>2,45 ha</strong> phía Nam dự án Hòn Ngọc Á Châu (quy mô 12 ha, khởi công 2010 rồi bỏ hoang) để làm <strong>công viên công cộng</strong>, tổng mức đầu tư hơn 47 tỷ đồng, thực hiện 2025 – 2027. Dọc tuyến biển có chuỗi 3 công viên bãi tắm: Sơn Thủy, công viên đối diện dự án và công viên bãi tắm cuối đường Huyền Trân Công Chúa.</p>
<p>Từ các tầng cao, tầm nhìn mở ra cả <strong>biển Mỹ Khê</strong>, <strong>Ngũ Hành Sơn</strong>, dòng sông phía Tây và đô thị về đêm. Theo chủ đầu tư, dự án cách <a href="/du-an/sun-galaxy-complex/">Sun Galaxy</a> và <a href="/du-an/da-nang-downtown/">Đà Nẵng Downtown</a> khoảng 4 km – đủ gần để kết nối, đủ xa để riêng tư.</p>
<h2>Hạ tầng thúc đẩy giá trị</h2>
<ul>
<li><strong>Ga LRT 09 cách khoảng 500 m</strong> trên tuyến đường sắt đô thị nối sân bay với khu biển – thuận tiện cho khách du lịch và cho thuê (tuyến đang chuẩn bị đầu tư, doanh nghiệp lập hồ sơ cho biết dự kiến khởi công 2/2027).</li>
<li><strong>Mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân</strong>: vốn dự kiến 2.633 tỷ đồng, nhóm dự án ưu tiên "luồng xanh" (Tuổi Trẻ, 10/2026).</li>
<li><strong>Cao tốc nội thị Đà Nẵng – Chu Lai</strong> đi theo đường Lê Văn Hiến, song song đường biển: <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">hướng tuyến và tiến độ</a>.</li>
</ul>
<h2>Thiết kế và tiện ích</h2>
<p>Kiến trúc lấy cảm hứng từ nghệ thuật điêu khắc Chăm Pa và hình tượng vũ nữ <strong>Apsara</strong>, thể hiện bằng ngôn ngữ đương đại. Tiện ích nội khu theo giới thiệu: bể bơi view biển, yoga, gym, pilates; ngoài khu là bãi biển với các môn thể thao kayak, SUP, dù lượn, jetski.</p>
<h2>Bài toán cho thuê tham khảo</h2>
<p>Tài liệu bán hàng đưa ra bài toán cho thuê ngắn ngày (giả định của chủ đầu tư, không phải cam kết):</p>
<table>
<thead><tr><th></th><th>Studio view biển</th><th>1PN view biển</th></tr></thead>
<tbody>
<tr><td>Diện tích · giá tham khảo</td><td>30 m² · 3 tỷ</td><td>50 m² · 4,5 tỷ</td></tr>
<tr><td>Giá thuê · lấp đầy</td><td>2,5 triệu/đêm · 60%</td><td>3,5 triệu/đêm · 60%</td></tr>
<tr><td>Doanh thu năm</td><td>540 triệu</td><td>756 triệu</td></tr>
<tr><td>Lợi nhuận (65% doanh thu)</td><td>351 triệu/năm · khoảng 11,7%</td><td>492 triệu/năm · khoảng 10,9%</td></tr>
</tbody>
</table>
<p>Để đối chiếu: căn hộ, khách sạn view biển lân cận đang cho thuê studio khoảng 2,2 – 2,9 triệu/đêm, 1PN+ khoảng 3,4 – 3,7 triệu/đêm ngoài mùa cao điểm; mặt bằng lợi suất cho thuê căn hộ toàn Đà Nẵng khoảng 4,5%/năm (Batdongsan.com.vn, quý 3/2026). Xem cách tự tính: <a href="/studio-ven-bien-da-nang-gia-mua-gia-thue-2026/">giá mua, giá thuê và dòng tiền studio ven biển</a>.</p>
<h2>So sánh căn hộ mặt biển Đà Nẵng</h2>
<p>Giá chuyển nhượng tham khảo trong tài liệu (10/2026):</p>
<table>
<thead><tr><th>Dự án</th><th>Studio</th><th>1PN</th><th>2PN</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">The Soleil Đà Nẵng</a></td><td>5,2 – 5,5 tỷ</td><td>7,7 – 7,8 tỷ</td><td>17,5 tỷ</td></tr>
<tr><td>Futa Residence Đà Nẵng</td><td>9,1 – 10,5 tỷ</td><td>10,3 – 11,5 tỷ</td><td>17,4 – 17,6 tỷ</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Đà Nẵng</a></td><td>6,3 – 6,4 tỷ</td><td>10,5 – 10,6 tỷ</td><td>21,4 – 21,7 tỷ</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>–</td><td>1PN+ 5,3 – 5,6 tỷ</td><td>6,8 – 8,3 tỷ</td></tr>
</tbody>
</table>
<p>Nếu giá Sun Saphia gần mức tham khảo 3 tỷ cho studio, tổng tiền thấp hơn khá nhiều so với các căn hộ hàng hiệu sát biển Mỹ Khê – nhưng cần chờ bảng giá chính thức để so giá/m².</p>
<h2>Sun Saphia Residence phù hợp ai?</h2>
<ul>
<li><strong>Người trẻ làm việc tự do</strong>: studio, 1PN+ gọn, cạnh biển, cho thuê bù chi phí.</li>
<li><strong>Người thành đạt cần second home</strong>: căn 2PN góc, thương hiệu Sun Group, tầm nhìn sông – núi – biển.</li>
<li><strong>Người muốn nghỉ hưu sớm, người lớn tuổi</strong>: biển trước nhà, công viên, trường học, siêu thị, bệnh viện quanh khu.</li>
<li><strong>Nhà đầu tư cho thuê</strong>: studio tầng cao hướng biển; cân nhắc yếu tố thời hạn 50 năm khi tính giá bán lại.</li>
</ul>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận mặt bằng tầng, bảng giá và chính sách Sun Saphia Residence ngay khi mở bán, hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';
		unset( $p );
		return $projects;
	},
	21
);
