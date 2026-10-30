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
		'slug'      => 'khu-du-lich-sinh-thai-ven-bien-ngu-hanh-son-trien-khai',
		'title'     => 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn khởi động: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch',
		'excerpt'   => 'Dự án Khu du lịch, dịch vụ sinh thái ven biển tại phường Ngũ Hành Sơn (giữa Fusion Resort và Naman Retreat) đã dọn mặt bằng, triển khai hạng mục đầu tiên. Theo quy hoạch 1/500 duyệt 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, khu biệt thự – thông tin đang chờ xác nhận chính thức.',
		'keyword'   => 'khu du lịch sinh thái ven biển Ngũ Hành Sơn',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-30 15:00:00',
		'image'         => 'plugin:img/tin-tuc/kdl-sinh-thai-ven-bien-ngu-hanh-son.jpg',
		'image_alt'     => 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn – tóm tắt quy hoạch 1/500: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng',
		'image_caption' => 'Tóm tắt thông tin quy hoạch 1/500 của dự án (Hoàng Hiệp tổng hợp, thông tin đang chờ xác nhận chính thức).',
		'content'   => <<<'HTML'
<p>Dự án <strong>Khu du lịch, dịch vụ sinh thái ven biển tại phường Ngũ Hành Sơn</strong> (Đà Nẵng) đã dọn dẹp mặt bằng và bắt đầu triển khai những hạng mục đầu tiên, theo hình ảnh công trường được chia sẻ ngày 30/10/2026. Chủ đầu tư là <strong>Công ty TNHH Đầu tư và Phát triển Đệ Nhất</strong>.</p>
<p><em>Lưu ý: thông tin quy mô dưới đây theo quy hoạch tổng mặt bằng tỷ lệ 1/500 được chấp thuận tháng 4/2026, được chia sẻ trên mạng xã hội. Hoàng Hiệp chưa thấy báo chí, cơ quan nhà nước công bố chính thức – thông tin đang chờ xác nhận, sẽ cập nhật khi có nguồn chính thống.</em></p>
<!--hh-featured-->

<h2>Vị trí dự án</h2>
<p>Khu đất nằm trên dải ven biển đường Trường Sa (phường Ngũ Hành Sơn), mặt chính hướng ra biển, <strong>phía Bắc giáp Fusion Resort &amp; Villas Đà Nẵng, phía Nam giáp Naman Retreat</strong> – đoạn biển tập trung nhiều khu nghỉ dưỡng cao cấp của Đà Nẵng.</p>

<h2>Quy mô theo quy hoạch 1/500</h2>
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

<h2>Ảnh hưởng tới bất động sản ven biển Ngũ Hành Sơn – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Thêm một khách sạn 5 sao trên trục biển Trường Sa:</strong> bổ sung lượng khách lưu trú cao cấp, làm dày dịch vụ cho dải biển phía Nam, nối tiếp chuỗi khu nghỉ dưỡng hiện có.</li>
<li><strong>Nguồn cung căn hộ du lịch mới:</strong> 2 tháp 15 tầng là sản phẩm nghỉ dưỡng, cần chờ chủ đầu tư công bố pháp lý, thời hạn sở hữu và chính sách vận hành trước khi tính chuyện xuống tiền.</li>
<li><strong>Nhà, đất khu dân cư phía trong:</strong> các khu dân cư <a href="/khu-vuc/ngu-hanh-son/">Ngũ Hành Sơn</a> gần biển có thêm lý do để giữ giá khi dự án vận hành; nhưng đây là tác động dài hạn, chưa phải lý do để mua vội.</li>
<li><strong>Để so sánh:</strong> người mua để ở hoặc cho thuê có thể tham khảo thêm các dự án căn hộ ven biển đang mở bán như <a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>.</li>
</ul>
<p>Cần tìm hiểu nhà, đất, căn hộ ven biển Ngũ Hành Sơn, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: thông tin quy hoạch tổng mặt bằng 1/500 và hình ảnh công trường chia sẻ trên mạng xã hội (30/10/2026); đang chờ xác nhận từ nguồn chính thức.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn khởi động',
			'desc'      => 'Dự án Khu du lịch, dịch vụ sinh thái ven biển P. Ngũ Hành Sơn (giữa Fusion – Naman) đã triển khai hạng mục đầu: khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch.',
			'points'    => array(
				'Dự án nằm ven biển Trường Sa, giữa Fusion Resort & Villas Đà Nẵng và Naman Retreat.',
				'Chủ đầu tư: Công ty TNHH Đầu tư và Phát triển Đệ Nhất; đã dọn mặt bằng, triển khai hạng mục đầu tiên.',
				'Theo quy hoạch 1/500 duyệt 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, khu biệt thự nghỉ dưỡng.',
				'Thông tin quy mô đang chờ xác nhận từ nguồn chính thức.',
			),
			'faq'       => array(
				array( 'Khu du lịch sinh thái ven biển Ngũ Hành Sơn ở đâu?', 'Trên dải ven biển đường Trường Sa, phường Ngũ Hành Sơn, Đà Nẵng; phía Bắc giáp Fusion Resort & Villas, phía Nam giáp Naman Retreat.' ),
				array( 'Ai là chủ đầu tư dự án?', 'Công ty TNHH Đầu tư và Phát triển Đệ Nhất.' ),
				array( 'Dự án gồm những hạng mục gì?', 'Theo quy hoạch 1/500 duyệt tháng 4/2026: 1 tháp khách sạn 5 sao 30 tầng, 2 tháp căn hộ du lịch 15 tầng, 3 cụm biệt thự nghỉ dưỡng, nhà hàng, bể bơi, nhà đón tiếp và thương mại dịch vụ. Thông tin đang chờ xác nhận chính thức.' ),
				array( 'Dự án đã mở bán căn hộ chưa?', 'Chưa có thông tin mở bán, giá bán hay pháp lý sở hữu căn hộ du lịch. Anh chị nên chờ chủ đầu tư công bố chính thức.' ),
			),
		),
		'sources'   => array(),
	);
	return $posts;
}
