<?php
/**
 * Chuyên mục "Nhịp sống Đà Nẵng" – tin ngắn đời sống, đô thị (anh Hiệp gửi). Nạp qua filter hh_news_posts;
 * nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, đăng ngay (không lên lịch), ảnh đại diện lấy từ img/tin-tuc/.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_nhip_song' );
function hh_posts_nhip_song( $posts ) {
	$posts[] = array(
		'slug'     => 'cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy',
		'title'    => 'Bãi tắm Sơn Thủy: Đà Nẵng chuẩn bị đầu tư công viên và câu lạc bộ thể thao biển',
		'excerpt'  => 'Đà Nẵng chuẩn bị các bước đầu tư gói thầu Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy tại phường Ngũ Hành Sơn. Phối cảnh, các bước tiếp theo và ý nghĩa với cư dân, du lịch, bất động sản ven biển.',
		'keyword'  => 'bãi tắm Sơn Thủy',
		'project'  => '',
		'category' => 'Nhịp sống Đà Nẵng',
		'date'     => '2026-10-06 08:00:00',
		'image'    => 'plugin:img/tin-tuc/cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy.jpg',
		'image_alt' => 'Phối cảnh Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng',
		'content'  => <<<'HTML'
<p><strong>Bãi tắm Sơn Thủy</strong> (phường Ngũ Hành Sơn, Đà Nẵng) sắp có diện mạo mới. Thành phố đang chuẩn bị các bước đầu tư gói thầu <strong>Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy</strong>; hồ sơ phối cảnh của dự án được ký ngày 10/8/2026. Đây là một trong những công trình công cộng ven biển đáng chú ý ở phía Đông Nam thành phố – nơi tập trung nhiều khu nghỉ dưỡng, căn hộ và biệt thự biển.</p>

<h2>Thông tin chính về dự án</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Tên gói thầu</td><td>Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy</td></tr>
<tr><td>Địa điểm</td><td>Phường Ngũ Hành Sơn, thành phố Đà Nẵng</td></tr>
<tr><td>Hồ sơ phối cảnh</td><td>Ký ngày 10/8/2026</td></tr>
<tr><td>Tình trạng</td><td>Đang chuẩn bị các bước đầu tư</td></tr>
<tr><td>Quy mô, tổng vốn, thời gian thi công</td><td>Chưa công bố – sẽ cập nhật khi có văn bản chính thức</td></tr>
</tbody>
</table>

<h2>Phối cảnh công viên và bãi tắm Sơn Thủy có gì?</h2>
<p>Theo ảnh phối cảnh được chia sẻ, dự án được thiết kế như một dải không gian công cộng liền mạch từ đường ven biển xuống bãi cát:</p>
<ul>
<li><strong>Công viên cây xanh ven biển:</strong> hàng dừa và mảng cỏ lớn, lối đi bộ uốn lượn, các quảng trường nhỏ để dạo chơi, ngắm biển.</li>
<li><strong>Câu lạc bộ thể thao biển:</strong> khu sân thể thao trên cát cùng các công trình thấp tầng phục vụ tập luyện, nghỉ chân.</li>
<li><strong>Bãi tắm công cộng:</strong> nối thẳng từ công viên ra biển, thuận tiện cho người dân và du khách.</li>
<li><strong>Khu vui chơi, thư giãn:</strong> các mảng sân, chòi nghỉ, cảnh quan xen kẽ, phù hợp cho gia đình có trẻ nhỏ.</li>
</ul>
<p><em>Ảnh phối cảnh: Danang 35K Feet. Phối cảnh có thể điều chỉnh trong quá trình thẩm định, phê duyệt.</em></p>

<h2>"Chuẩn bị đầu tư" nghĩa là gì, bao giờ thi công?</h2>
<p>Với công trình công cộng sử dụng vốn nhà nước, giai đoạn chuẩn bị đầu tư thường gồm: hoàn thiện hồ sơ thiết kế – dự toán, thẩm định và phê duyệt, lập kế hoạch lựa chọn nhà thầu, tổ chức đấu thầu; sau đó mới khởi công. Vì vậy, thời điểm thi công và hoàn thành của bãi tắm Sơn Thủy còn phụ thuộc tiến độ phê duyệt của thành phố. Hoàng Hiệp sẽ cập nhật ngay khi có quyết định phê duyệt hoặc kết quả lựa chọn nhà thầu.</p>

<h2>Ý nghĩa với cư dân và du khách</h2>
<ul>
<li><strong>Thêm không gian công cộng miễn phí:</strong> chỗ tập thể dục buổi sáng, chơi thể thao bãi biển, dạo bộ buổi chiều cho cư dân Ngũ Hành Sơn.</li>
<li><strong>Bãi tắm sạch, có tổ chức:</strong> công viên và câu lạc bộ đi kèm giúp quản lý vệ sinh, an toàn bãi tắm tốt hơn.</li>
<li><strong>Điểm đến mới cho du lịch:</strong> khu vực vốn gần danh thắng Ngũ Hành Sơn và các khu nghỉ dưỡng ven biển; thêm một công viên biển giúp du khách có lý do ở lại lâu hơn.</li>
</ul>

<h2>Tác động đến bất động sản ven biển Ngũ Hành Sơn</h2>
<p>Kinh nghiệm ở các bãi biển đã được đầu tư công viên (như dọc biển Mỹ Khê) cho thấy tiện ích công cộng ven biển giúp khu vực xung quanh sôi động hơn, tăng nhu cầu ở và thuê ngắn hạn. Với Ngũ Hành Sơn, người mua nên để ý:</p>
<ul>
<li><strong>Căn hộ, biệt thự gần biển:</strong> thêm tiện ích đi bộ ra biển là điểm cộng khi ở lâu dài hoặc cho thuê du lịch.</li>
<li><strong>Nhà phố, đất ở các tuyến kết nối ra biển:</strong> có thể hưởng lợi khi lượng khách đến khu vực tăng.</li>
<li><strong>Đừng mua theo tin đồn:</strong> dự án mới ở giai đoạn chuẩn bị đầu tư; giá trị thật đến khi công trình hoàn thành. Nên chọn sản phẩm có pháp lý rõ ràng và tính dòng tiền thận trọng.</li>
</ul>
<p>Tham khảo các dự án tại <a href="/khu-vuc/ngu-hanh-son/">khu vực Ngũ Hành Sơn</a>, biệt thự biển <a href="/du-an/the-ocean-villas-da-nang/">The Ocean Villas</a>, <a href="/du-an/vinpearl-luxury-da-nang-villa/">Vinpearl Luxury Đà Nẵng</a>, hoặc bài <a href="/toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san/">toàn cảnh hạ tầng Đà Nẵng 2026</a>. Xem thêm: <a href="/bat-dong-san-ngu-hanh-son-2026/">Bất động sản Ngũ Hành Sơn 2026</a> · <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">Giá đất ven biển Đà Nẵng</a>.</p>

<p>Anh chị đang tìm căn hộ, biệt thự hoặc nhà phố gần biển Ngũ Hành Sơn? Gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn phù hợp, giá và pháp lý mới nhất.</p>
HTML,
		'seo'      => array(
			'seo_title' => 'Bãi tắm Sơn Thủy: công viên, CLB thể thao biển Ngũ Hành Sơn',
			'desc'      => 'Đà Nẵng chuẩn bị đầu tư công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy (Ngũ Hành Sơn): phối cảnh, các bước tiếp theo, tác động đến bất động sản ven biển.',
			'points'    => array(
				'Gói thầu: Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy, phường Ngũ Hành Sơn.',
				'Hồ sơ phối cảnh ký ngày 10/8/2026; đang chuẩn bị các bước đầu tư.',
				'Phối cảnh: công viên cây xanh, sân thể thao bãi biển, bãi tắm công cộng nối liền.',
				'Quy mô, vốn và thời gian thi công chưa công bố.',
			),
			'faq'       => array(
				array( 'Bãi tắm Sơn Thủy ở đâu?', 'Bãi tắm Sơn Thủy thuộc phường Ngũ Hành Sơn, thành phố Đà Nẵng, trên dải biển phía Đông Nam thành phố.' ),
				array( 'Công viên, câu lạc bộ thể thao biển Sơn Thủy gồm những gì?', 'Theo phối cảnh: dải công viên cây xanh và hàng dừa, lối đi bộ, quảng trường nhỏ, khu sân thể thao trên cát, khu vui chơi và bãi tắm công cộng nối liền với công viên.' ),
				array( 'Khi nào dự án bãi tắm Sơn Thủy thi công?', 'Dự án đang ở giai đoạn chuẩn bị đầu tư (hồ sơ phối cảnh ký 10/8/2026). Thời gian thi công sẽ rõ sau khi thành phố phê duyệt và lựa chọn nhà thầu.' ),
				array( 'Dự án ảnh hưởng thế nào đến bất động sản Ngũ Hành Sơn?', 'Tiện ích công cộng ven biển giúp khu vực sôi động hơn, là điểm cộng cho căn hộ, biệt thự gần biển để ở và cho thuê. Tuy vậy, nên mua theo nhu cầu thật và pháp lý rõ ràng, không mua theo tin đồn.' ),
			),
		),
		'old_title' => array( 'Chuẩn bị đầu tư công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy' ),
		'old_meta' => array(
			'rank_math_title'       => 'Công viên, CLB thể thao biển và bãi tắm Sơn Thủy, Ngũ Hành Sơn',
			'rank_math_description' => 'Đà Nẵng chuẩn bị đầu tư gói thầu Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy (phường Ngũ Hành Sơn). Xem phối cảnh và ý nghĩa với khu vực.',
		),
		'sources'  => array(),
	);
	return $posts;
}
