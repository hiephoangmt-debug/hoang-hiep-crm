<?php
/**
 * Bài: Khu du lịch, dịch vụ sinh thái ven biển tại phường Ngũ Hành Sơn triển khai hạng mục đầu tiên.
 * Nguồn: thông tin quy hoạch tổng mặt bằng 1/500 (chấp thuận 4/2026) và ảnh công trường được chia sẻ trên mạng xã hội
 * ngày 30/10/2026; chưa có bài báo chính thống xác nhận → bài ghi rõ "đang chờ xác nhận". Ảnh đại diện tự vẽ,
 * không dùng ảnh/bản vẽ có logo của trang khác.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_kdl_sinh_thai_ven_bien_ngu_hanh_son' );
function hh_posts_kdl_sinh_thai_ven_bien_ngu_hanh_son( $posts ) {
	$posts[] = array(
		'slug'      => 'khu-du-lich-sinh-thai-ven-bien-ngu-hanh-son',
		'old_slug'  => array( 'khu-du-lich-sinh-thai-ven-bien-ngu-hanh-son-trien-khai' ),
		'title'     => 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn khởi động: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch',
		'excerpt'   => 'Dự án Khu du lịch, dịch vụ sinh thái ven biển tại phường Ngũ Hành Sơn (giữa Fusion Resort và Naman Retreat) đã dọn mặt bằng, triển khai hạng mục đầu tiên. Theo quy hoạch 1/500 duyệt 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, khu biệt thự – thông tin đang chờ xác nhận chính thức.',
		'keyword'   => 'khu du lịch sinh thái Ngũ Hành Sơn',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-30 15:00:00',
		'image'         => 'plugin:img/tin-tuc/so-do-kdl-sinh-thai-ven-bien-ngu-hanh-son.jpg',
		'image_alt'     => 'Sơ đồ vị trí khu du lịch sinh thái Ngũ Hành Sơn ven biển Trường Sa, giữa Fusion Resort và Naman Retreat: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, biệt thự',
		'image_caption' => 'Sơ đồ minh hoạ vị trí và các khu chức năng (Hoàng Hiệp vẽ, không theo tỷ lệ; thông tin theo quy hoạch 1/500, đang chờ xác nhận chính thức).',
		'image_replace' => 'kdl-sinh-thai-ven-bien-ngu-hanh-son',
		'old_meta'  => array(
			'rank_math_focus_keyword' => array( 'khu du lịch sinh thái ven biển Ngũ Hành Sơn' ),
			'rank_math_title'         => array( 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn khởi động' ),
			'rank_math_description'   => array( 'Dự án Khu du lịch, dịch vụ sinh thái ven biển P. Ngũ Hành Sơn (giữa Fusion – Naman) đã triển khai hạng mục đầu: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch.' ),
		),
		'content'   => <<<'HTML'
<p>Dự án <strong>khu du lịch sinh thái Ngũ Hành Sơn</strong> – tên đầy đủ là Khu du lịch, dịch vụ sinh thái ven biển tại phường Ngũ Hành Sơn (Đà Nẵng) – đã dọn dẹp mặt bằng và bắt đầu triển khai những hạng mục đầu tiên, theo hình ảnh công trường được chia sẻ ngày 30/10/2026. Chủ đầu tư là <strong>Công ty TNHH Đầu tư và Phát triển Đệ Nhất</strong>.</p>
<p><em>Lưu ý: thông tin quy mô dưới đây theo quy hoạch tổng mặt bằng tỷ lệ 1/500 được chấp thuận tháng 4/2026, được chia sẻ trên mạng xã hội. Hoàng Hiệp chưa thấy báo chí, cơ quan nhà nước công bố chính thức – thông tin đang chờ xác nhận, sẽ cập nhật khi có nguồn chính thống.</em></p>
<!--hh-featured-->

<h2>Vị trí khu du lịch sinh thái Ngũ Hành Sơn</h2>
<p>Khu đất nằm trên dải ven biển đường Trường Sa (phường Ngũ Hành Sơn), mặt chính hướng ra biển, <strong>phía Bắc giáp Fusion Resort &amp; Villas Đà Nẵng, phía Nam giáp Naman Retreat</strong> – đoạn biển tập trung nhiều khu nghỉ dưỡng cao cấp của Đà Nẵng.</p>
<p>Dải biển này nằm trong định hướng phát triển du lịch ven biển của <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng 2050</a>: thành phố dự báo khoảng 130 – 135 triệu lượt khách du lịch lưu trú vào năm 2050 (<a href="https://danang.gov.vn/en/w/phe-duyet-quy-hoach-chung-thanh-pho-da-nang-den-nam-2050-tam-nhin-den-nam-2075">Cổng TTĐT TP Đà Nẵng</a>). Cũng trên trục biển Trường Sa – Võ Nguyên Giáp, thành phố đang chuẩn bị đầu tư <a href="/bai-tam-son-thuy-cong-vien-the-thao-bien/">công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy</a>.</p>

<h2>Quy mô khu du lịch sinh thái Ngũ Hành Sơn theo quy hoạch 1/500</h2>
<table>
<thead><tr><th>Khu chức năng</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>Khách sạn (KS-A)</td><td>1 tháp khách sạn tiêu chuẩn 5 sao, cao 30 tầng</td></tr>
<tr><td>Căn hộ du lịch (CO-B, CO-C)</td><td>2 tháp, mỗi tháp cao 15 tầng</td></tr>
<tr><td>Biệt thự nghỉ dưỡng (VILA-01, 02, 03)</td><td>3 cụm biệt thự nghỉ dưỡng</td></tr>
<tr><td>Dịch vụ – tiện ích</td><td>Nhà hàng, bể bơi, nhà đón tiếp, thương mại dịch vụ</td></tr>
<tr><td>Hạ tầng</td><td>Cây xanh cảnh quan, khu hạ tầng kỹ thuật</td></tr>
</tbody>
</table>
<p>Diện tích khu đất, tổng vốn đầu tư, tiến độ từng giai đoạn và hình thức sở hữu căn hộ du lịch hiện chưa được công bố.</p>

<h2>Những điều chưa được công bố</h2>
<p>Với khu du lịch sinh thái Ngũ Hành Sơn, nhiều thông tin quan trọng với người mua vẫn chưa có:</p>
<ul>
<li><strong>Pháp lý căn hộ du lịch:</strong> căn hộ du lịch là bất động sản du lịch, khác căn hộ để ở về mục đích sử dụng và thời hạn; cần xem dự án có đủ điều kiện cấp giấy chứng nhận cho từng căn hay không.</li>
<li><strong>Thời hạn sử dụng đất:</strong> dự án du lịch, dịch vụ thường được giao hoặc thuê đất có thời hạn; chưa có thông tin về thời hạn của dự án này.</li>
<li><strong>Đơn vị vận hành khách sạn 5 sao:</strong> thương hiệu quản lý ảnh hưởng lớn đến công suất phòng và giá thuê.</li>
<li><strong>Tiến độ từng giai đoạn:</strong> mới có hình ảnh dọn mặt bằng, chưa có mốc hoàn thành.</li>
</ul>

<h2>Ảnh hưởng của khu du lịch sinh thái Ngũ Hành Sơn tới bất động sản ven biển – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Thêm một khách sạn 5 sao trên trục biển Trường Sa:</strong> bổ sung lượng khách lưu trú cao cấp, làm dày dịch vụ cho dải biển phía Nam, nối tiếp chuỗi khu nghỉ dưỡng hiện có.</li>
<li><strong>Nguồn cung căn hộ du lịch mới:</strong> 2 tháp 15 tầng là sản phẩm nghỉ dưỡng, cần chờ chủ đầu tư công bố pháp lý, thời hạn sở hữu và chính sách vận hành trước khi tính chuyện xuống tiền.</li>
<li><strong>Nhà, đất khu dân cư phía trong:</strong> các khu dân cư <a href="/khu-vuc/ngu-hanh-son/">Ngũ Hành Sơn</a> gần biển có thêm lý do để giữ giá khi dự án vận hành; nhưng đây là tác động dài hạn, chưa phải lý do để mua vội.</li>
<li><strong>Để so sánh:</strong> người mua để ở hoặc cho thuê có thể tham khảo thêm các dự án căn hộ ven biển đang mở bán như <a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>.</li>
</ul>

<h2>Checklist nếu quan tâm căn hộ tại khu du lịch sinh thái Ngũ Hành Sơn</h2>
<ol>
<li>Chờ chủ đầu tư công bố chính thức: chủ trương đầu tư, giấy phép xây dựng, thời hạn sử dụng đất.</li>
<li>Hỏi rõ hình thức sở hữu căn hộ du lịch và điều kiện cấp giấy chứng nhận.</li>
<li>Đọc kỹ hợp đồng vận hành, cách chia doanh thu cho thuê; không ra quyết định chỉ dựa vào lời hứa lợi nhuận.</li>
<li>So sánh với căn hộ ven biển đã có sổ hồng ở khu vực lân cận về giá, pháp lý và khả năng cho thuê.</li>
</ol>
<p>Hoàng Hiệp sẽ cập nhật thông tin khu du lịch sinh thái Ngũ Hành Sơn khi có nguồn chính thống. Cần tìm hiểu nhà, đất, căn hộ ven biển Ngũ Hành Sơn, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: thông tin quy hoạch tổng mặt bằng 1/500 và hình ảnh công trường chia sẻ trên mạng xã hội (30/10/2026), đang chờ xác nhận từ nguồn chính thức; dự báo khách du lịch theo Quy hoạch chung TP Đà Nẵng đến 2050 (Cổng TTĐT TP Đà Nẵng).</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Khu du lịch sinh thái Ngũ Hành Sơn: khách sạn 30 tầng',
			'desc'      => 'Khu du lịch sinh thái Ngũ Hành Sơn (giữa Fusion – Naman) đã triển khai hạng mục đầu: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, biệt thự.',
			'points'    => array(
				'Khu du lịch sinh thái Ngũ Hành Sơn nằm ven biển Trường Sa, giữa Fusion Resort & Villas Đà Nẵng và Naman Retreat.',
				'Chủ đầu tư: Công ty TNHH Đầu tư và Phát triển Đệ Nhất; đã dọn mặt bằng, triển khai hạng mục đầu tiên.',
				'Theo quy hoạch 1/500 duyệt 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, khu biệt thự nghỉ dưỡng.',
				'Thông tin quy mô đang chờ xác nhận từ nguồn chính thức; chưa có thông tin mở bán.',
			),
			'faq'       => array(
				array( 'Khu du lịch sinh thái Ngũ Hành Sơn ở đâu?', 'Khu du lịch sinh thái Ngũ Hành Sơn nằm trên dải ven biển đường Trường Sa, phường Ngũ Hành Sơn, Đà Nẵng; phía Bắc giáp Fusion Resort & Villas, phía Nam giáp Naman Retreat.' ),
				array( 'Ai là chủ đầu tư khu du lịch sinh thái Ngũ Hành Sơn?', 'Công ty TNHH Đầu tư và Phát triển Đệ Nhất.' ),
				array( 'Khu du lịch sinh thái Ngũ Hành Sơn gồm những hạng mục gì?', 'Theo quy hoạch 1/500 duyệt tháng 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, 3 cụm biệt thự nghỉ dưỡng, nhà hàng, bể bơi, nhà đón tiếp và thương mại dịch vụ. Thông tin đang chờ xác nhận chính thức.' ),
				array( 'Khu du lịch sinh thái Ngũ Hành Sơn đã mở bán căn hộ chưa?', 'Chưa có thông tin mở bán, giá bán hay pháp lý sở hữu căn hộ du lịch. Anh chị nên chờ chủ đầu tư công bố chính thức.' ),
			),
		),
		'sources'   => array( 'https://danang.gov.vn/en/w/phe-duyet-quy-hoach-chung-thanh-pho-da-nang-den-nam-2050-tam-nhin-den-nam-2075' ),
	);
	return $posts;
}
