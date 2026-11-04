<?php
/**
 * Bài: Định hướng quy hoạch chung đô thị Hòa Tiến (Đà Nẵng) đến 2050 – nội dung anh Hiệp gửi 04/11/2026 kèm sơ đồ vị trí,
 * bản đồ sử dụng đất (anh Hiệp yêu cầu đăng: giữ nguyên chữ chìm, logo nguồn "Quy hoạch quốc gia – tài liệu tham khảo", ghi nguồn).
 * Ảnh đại diện tự vẽ.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_quy_hoach_hoa_tien_2050' );
function hh_posts_quy_hoach_hoa_tien_2050( $posts ) {
	$posts[] = array(
		'slug'          => 'quy-hoach-chung-do-thi-hoa-tien-da-nang-2050',
		'title'         => 'Quy hoạch đô thị Hòa Tiến đến 2050: cửa ngõ Tây Nam Đà Nẵng, 4 vùng phát triển, ga đường sắt tốc độ cao',
		'excerpt'       => 'Hòa Tiến (sáp nhập Hòa Khương và Hòa Tiến cũ) được định hướng thành đô thị loại III sinh thái – dịch vụ – nông nghiệp, cửa ngõ Tây Nam Đà Nẵng: 4 vùng phát triển, cụm công nghiệp Hòa Tiến 1, 2, logistics và dự kiến ga đường sắt tốc độ cao Bắc – Nam.',
		'keyword'       => 'quy hoạch Hòa Tiến 2050',
		'project'       => '',
		'category'      => 'Hạ tầng & quy hoạch',
		'date'          => '2026-11-04 19:30:00',
		'image'         => 'plugin:img/tin-tuc/so-do-do-thi-hoa-tien-2050.jpg',
		'image_alt'     => 'Sơ đồ 4 vùng phát triển đô thị Hòa Tiến, Đà Nẵng đến năm 2050',
		'image_caption' => 'Sơ đồ minh hoạ 4 vùng phát triển Hòa Tiến (Hoàng Hiệp vẽ, không theo tỷ lệ).',
		'content'       => <<<'HTML'
<p>Định hướng <strong>quy hoạch chung đô thị Hòa Tiến (TP Đà Nẵng) đến năm 2050</strong> được lập trên cơ sở sáp nhập hai xã Hòa Khương và Hòa Tiến cũ. Hòa Tiến hướng tới <strong>đô thị loại III</strong> với tính chất sinh thái – dịch vụ – nông nghiệp, giữ vai trò <strong>cửa ngõ phía Tây Nam</strong> của Đà Nẵng, đô thị vệ tinh hỗ trợ khu trung tâm và là cực công nghiệp – dịch vụ công nghệ cao, logistics trong cụm 3 đô thị phía Tây (Bà Nà – Hòa Vang – Hòa Tiến).</p>
<p><em>Thông tin theo hồ sơ định hướng quy hoạch được chia sẻ (tài liệu tham khảo); các chỉ tiêu cụ thể chờ quyết định phê duyệt chính thức.</em></p>
<!--hh-featured-->

<h2>Phạm vi</h2>
<p>Ranh giới nghiên cứu gồm toàn bộ xã Hòa Tiến mới: phía Bắc giáp xã Hòa Vang và phường Cẩm Lệ; phía Nam giáp xã Đại Lộc và phường Điện Bàn Bắc; phía Tây giáp xã Hà Nha và xã Hòa Vang; phía Đông giáp phường Hòa Xuân và phường Điện Bàn Bắc. Thời hạn quy hoạch đến năm 2050.</p>
<!--hh-img:img/tin-tuc/quy-hoach-hoa-tien-2050-vi-tri-lien-he-vung.jpg|Sơ đồ vị trí và mối liên hệ vùng – quy hoạch chung đô thị Hòa Tiến đến 2050 (nguồn: Quy hoạch quốc gia, tài liệu tham khảo; bấm để xem ảnh lớn)-->

<h2>Cấu trúc không gian</h2>
<ul>
<li><strong>Trục Đông – Tây:</strong> chuyển tiếp từ vùng rừng núi, bán sơn địa phía Tây sang vùng đô thị tập trung phía Đông.</li>
<li><strong>Các trục Bắc – Nam:</strong> Quốc lộ 14B, ĐT605, đường Vành đai phía Tây và cao tốc Đà Nẵng – Quảng Ngãi (CT.01), kết nối khu đô thị mới, cụm công nghiệp, trung tâm logistics.</li>
<li><strong>Cực đô thị cửa ngõ:</strong> liên kết với cực sinh thái Bà Nà và đô thị Hòa Vang; cung cấp dịch vụ đô thị, công nghiệp công nghệ cao, logistics và đón dân cư giãn từ trung tâm.</li>
</ul>

<h2>4 vùng phát triển</h2>
<table>
<thead><tr><th>Vùng</th><th>Khu vực</th><th>Định hướng</th></tr></thead>
<tbody>
<tr><td>Sinh thái phía Tây</td><td>Đồng Nghệ, Phú Sơn Bắc, Phú Sơn, Phú Sơn Nam</td><td>Bảo tồn rừng, bảo vệ nguồn nước hồ Đồng Nghệ; du lịch sinh thái, nghỉ dưỡng mật độ thấp, hạn chế san gạt</td></tr>
<tr><td>Chuyển tiếp trung tâm</td><td>Hương Lam, La Châu, An Trạch, La Bông</td><td>Vùng đệm đan xen dân cư hiện hữu, đất quốc phòng, nông nghiệp và chức năng mới; cây xanh, mặt nước điều tiết</td></tr>
<tr><td>Đô thị phía Đông</td><td>Cẩm Nê, Yến Nê, Dương Sơn, Lệ Sơn…</td><td>Đô thị tập trung: khu ở mới, tái định cư, nhà ở xã hội, thương mại – dịch vụ, công trình công cộng</td></tr>
<tr><td>Công nghiệp &amp; hỗn hợp</td><td>Phú Sơn Nam; khu Nam Sơn giáp Vành đai phía Tây</td><td>Cụm công nghiệp Hòa Tiến 1, Hòa Tiến 2; trung tâm logistics, kho bãi</td></tr>
</tbody>
</table>
<!--hh-img:img/tin-tuc/quy-hoach-hoa-tien-2050-ban-do-su-dung-dat.jpg|Bản đồ sử dụng đất quy hoạch đô thị Hòa Tiến đến 2050 (nguồn: Quy hoạch quốc gia, tài liệu tham khảo; bấm để xem ảnh lớn)-->

<h2>Làng truyền thống và khung xanh</h2>
<p>Khu dân cư hiện hữu được chỉnh trang theo mô hình "làng trong đô thị", bảo tồn các làng ven sông Yên, sông Cẩm Lệ như làng nghề dệt chiếu Cẩm Nê, Yến Nê, Dương Sơn, La Châu, La Bông. Khung sinh thái nối từ rừng phía Tây, hồ Đồng Nghệ qua sông Túy Loan, sông Yên đến công viên, hồ điều hòa, công viên ngập nước phía Đông. Hạ tầng chiến lược gồm nâng cấp QL14B, ĐT605, tuyến Nam Kỳ Khởi Nghĩa, Vành đai phía Tây, cao tốc CT.01 và kết nối với <strong>ga hành khách đường sắt tốc độ cao Bắc – Nam dự kiến đặt tại Hòa Tiến</strong>.</p>

<h2>Ý nghĩa với bất động sản – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đất ở vùng phía Đông</strong> (Cẩm Nê, Yến Nê, Lệ Sơn…) – nơi định hướng đô thị tập trung, gần Cẩm Lệ, Hòa Xuân – là khu hưởng lợi rõ nhất khi hạ tầng triển khai.</li>
<li><strong>Ga đường sắt tốc độ cao, Vành đai phía Tây, cụm công nghiệp – logistics</strong> tạo nhu cầu nhà ở cho công nhân, chuyên gia và dịch vụ; nhưng đây là kế hoạch dài hạn, tiến độ phụ thuộc vốn và phê duyệt.</li>
<li><strong>Vùng phía Tây</strong> định hướng bảo tồn, mật độ thấp – không phù hợp kỳ vọng phân lô, xây dựng dày.</li>
<li>Trước khi mua đất Hòa Tiến, nên kiểm tra quy hoạch sử dụng đất từng thửa tại xã, tránh lô nằm trong đất quốc phòng, hành lang giao thông, cây xanh hoặc vùng ngập.</li>
</ul>
<p>Cần kiểm tra quy hoạch một lô đất ở Hòa Tiến, Hòa Vang, Cẩm Lệ: nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: hồ sơ định hướng quy hoạch chung đô thị Hòa Tiến, TP Đà Nẵng đến năm 2050 (sơ đồ vị trí, bản đồ sử dụng đất – Quy hoạch quốc gia, tài liệu tham khảo, 11/2026).</p>
HTML,
		'seo'           => array(
			'seo_title' => 'Quy hoạch đô thị Hòa Tiến Đà Nẵng đến 2050',
			'desc'      => 'Hòa Tiến (Đà Nẵng) định hướng đô thị loại III, cửa ngõ Tây Nam: 4 vùng phát triển, CCN Hòa Tiến 1, 2, logistics, dự kiến ga đường sắt tốc độ cao.',
			'points'    => array(
				'Hòa Tiến mới sáp nhập Hòa Khương và Hòa Tiến cũ, định hướng đô thị loại III sinh thái – dịch vụ – nông nghiệp.',
				'Cửa ngõ Tây Nam Đà Nẵng, thuộc cụm 3 đô thị phía Tây Bà Nà – Hòa Vang – Hòa Tiến.',
				'4 vùng: sinh thái phía Tây, chuyển tiếp trung tâm, đô thị phía Đông, công nghiệp – logistics.',
				'Dự kiến đặt ga hành khách đường sắt tốc độ cao Bắc – Nam tại Hòa Tiến.',
			),
			'faq'       => array(
				array( 'Đô thị Hòa Tiến gồm những xã nào?', 'Hòa Tiến mới được sáp nhập từ hai xã Hòa Khương và Hòa Tiến cũ (huyện Hòa Vang cũ), nay thuộc TP Đà Nẵng.' ),
				array( 'Hòa Tiến được quy hoạch thành đô thị loại mấy?', 'Định hướng đạt tiêu chuẩn đô thị loại III, tính chất sinh thái – dịch vụ – nông nghiệp, thời hạn đến năm 2050.' ),
				array( 'Khu nào ở Hòa Tiến phát triển đô thị tập trung?', 'Vùng phía Đông (Cẩm Nê, Yến Nê, Dương Sơn, Lệ Sơn…): khu ở mới, tái định cư, nhà ở xã hội, thương mại – dịch vụ.' ),
				array( 'Ga đường sắt tốc độ cao có đặt ở Hòa Tiến không?', 'Theo định hướng quy hoạch, ga hành khách đường sắt tốc độ cao Bắc – Nam dự kiến đặt tại Hòa Tiến; vị trí chính thức theo quyết định phê duyệt dự án.' ),
			),
		),
		'sources'       => array(),
	);
	return $posts;
}
