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
		return $projects;
	},
	21
);
