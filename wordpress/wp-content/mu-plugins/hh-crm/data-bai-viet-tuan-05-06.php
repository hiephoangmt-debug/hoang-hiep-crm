<?php
/**
 * Bài viết kế hoạch nội dung – tuần 5–6 (cụm căn hộ Đà Nẵng: dự án, view, ngân sách, vay, cho thuê, pháp lý, penthouse, shop khối đế). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_05_06' );
function hh_posts_tuan_05_06( $posts ) {

	/* ---------------- Tuần 5 ---------------- */

	$posts[] = array(
		'slug'     => 'can-ho-da-nang-2026-du-an-dang-mo-ban',
		'title'    => 'Căn hộ Đà Nẵng 2026: các dự án đang mở bán, giá và thời điểm bàn giao',
		'excerpt'  => 'Tổng hợp căn hộ Đà Nẵng 2026 đang mở bán: khu vực, giá tham khảo, thời điểm bàn giao của từng dự án để anh chị so sánh nhanh.',
		'keyword'  => 'căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 5,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Căn hộ Đà Nẵng năm 2026 có nguồn cung khá đa dạng: từ dòng căn hộ ven sông Hàn, ven biển Mỹ Khê đến các tòa tháp mới ở Hòa Xuân, FPT City. Giá tham khảo phổ biến từ khoảng 2 tỷ cho studio ở khu phía Nam đến trên 10 tỷ cho căn 3 phòng ngủ ven sông, ven biển. Bài viết được Hoàng Hiệp tổng hợp từ dữ liệu dự án, cập nhật tháng 10/2026.</p>

<h2>Bức tranh chung thị trường căn hộ Đà Nẵng 2026</h2>
<p>Theo các báo cáo thị trường được báo chí dẫn lại, mặt bằng giá sơ cấp căn hộ Đà Nẵng đã lên khoảng 80 – 90 triệu/m², tăng mạnh so với cùng kỳ. Nguồn cung mới tập trung nhiều ở khu Ngũ Hành Sơn và Hòa Xuân, nơi còn quỹ đất cho dự án quy mô lớn.</p>
<p>Điều đó có nghĩa là người mua có nhiều lựa chọn hơn, nhưng chênh lệch giá giữa các khu vực cũng lớn hơn. Chọn đúng khu vực và đúng thời điểm bàn giao quan trọng không kém chọn đúng dự án.</p>

<h2>Bảng dự án căn hộ Đà Nẵng đang mở bán</h2>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Giá tham khảo</th><th>Bàn giao</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Sơn Trà – ven sông Hàn</td><td>Chuyển nhượng khoảng 2,96 – 10 tỷ (studio – 3PN)</td><td>Quý 3/2026 (dự kiến)</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Sơn Trà – ven sông Hàn</td><td>1PN khoảng 2,2 – 2,7 tỷ; 2PN khoảng 3 – 5 tỷ</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a></td><td>Sơn Trà – ven sông Hàn</td><td>1PN khoảng 3,3 – 4,5 tỷ; 2PN khoảng 4,7 – 7,8 tỷ</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a></td><td>Sơn Trà</td><td>Studio từ khoảng 1,98 tỷ; 2PN khoảng 3,9 – 5,99 tỷ</td><td>Quý 1/2028 (dự kiến)</td></tr>
<tr><td><a href="/du-an/hiyori-aqua-tower/">HIYORI Aqua Tower</a></td><td>Sơn Trà</td><td>2PN 68 m² khoảng 4,5 tỷ</td><td>Quý 2/2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a></td><td>Hải Châu</td><td>1PN+ từ khoảng 4,13 tỷ; 3PN khoảng 6,68 – 8,11 tỷ</td><td>Quý III/2026 (dự kiến)</td></tr>
<tr><td><a href="/du-an/the-meridian-da-nang/">The Meridian Đà Nẵng</a></td><td>Hải Châu – ven sông Hàn</td><td>Studio/1PN khoảng 2,9 – 4,2 tỷ; 2PN khoảng 5,1 – 6,3 tỷ</td><td>Năm 2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/danang-landmark/">Danang Landmark</a></td><td>Hải Châu – ven sông Hàn</td><td>2PN 61 – 68 m² khoảng 5,95 – 6,7 tỷ</td><td>Giữa năm 2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/m-riverside-da-nang/">M Riverside Đà Nẵng</a></td><td>Hải Châu – ven sông Hàn</td><td>Khoảng 117 – 128 triệu/m²</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/peninsula-private-da-nang/">Peninsula Private Đà Nẵng</a></td><td>Hải Châu</td><td>Studio từ khoảng 65 triệu/m²</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>Ngũ Hành Sơn – ven biển</td><td>1PN khoảng 3,5 – 3,9 tỷ; 2PN khoảng 5,7 – 7,5 tỷ</td><td>Quý 3/2026 (dự kiến)</td></tr>
<tr><td><a href="/du-an/fpt-plaza-4/">FPT Plaza 4</a></td><td>Ngũ Hành Sơn – FPT City</td><td>Đang cập nhật theo đợt</td><td>Quý 2/2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a></td><td>Hòa Xuân</td><td>Sang nhượng HĐMB khoảng 1,9 – 4,14 tỷ</td><td>30/06/2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a></td><td>Hòa Xuân</td><td>Đang cập nhật theo đợt</td><td>30/07/2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/s-light-tower/">S-Light Tower</a></td><td>Hòa Xuân</td><td>Đang cập nhật theo đợt</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/fours-tower/">FourS Tower</a></td><td>Ngũ Hành Sơn – Hòa Quý</td><td>Đang cập nhật theo đợt</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Giá trong bảng là khoảng giá tham khảo từ bảng giá công bố hoặc tin chuyển nhượng công khai, thay đổi theo tầng, view, chính sách từng đợt. Dự án ghi "đang cập nhật" là chưa có số liệu đủ tin cậy, anh chị liên hệ để nhận bảng giá mới nhất.</p>

<h2>Dự án sắp mở bán và đã bàn giao đáng chú ý</h2>
<h3>Sắp mở bán</h3>
<p><a href="/du-an/fpt-plaza-5/">FPT Plaza 5</a> (hơn 832 căn, FPT City), <a href="/du-an/sun-galaxy-complex/">Sun Galaxy Complex</a> (khởi công 25/7/2026, bờ Đông sông Hàn) và <a href="/du-an/da-nang-downtown/">Đà Nẵng Downtown</a> của Sun Group đều đang ở giai đoạn sắp mở bán. Với nhóm này, người mua nên đăng ký nhận thông tin sớm và chờ bảng giá, chính sách chính thức.</p>
<h3>Đã và đang bàn giao</h3>
<p>Nếu cần nhận nhà ngay, có thể xem <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, <a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a>, <a href="/du-an/the-filmore-da-nang/">The Filmore</a> hay <a href="/du-an/vista-residence-da-nang/">Vista Residence</a>. Giao dịch ở nhóm này chủ yếu là chuyển nhượng thứ cấp, giá đã phản ánh tiến độ hoàn thiện.</p>

<h2>Chọn căn hộ Đà Nẵng theo nhu cầu</h2>
<ul>
<li><strong>Ở thực, ngân sách vừa phải:</strong> khu Hòa Xuân, FPT City có mức giá dễ tiếp cận hơn, tiện ích nội khu đầy đủ.</li>
<li><strong>Cho thuê, khai thác khách du lịch – chuyên gia:</strong> ưu tiên trục sông Hàn và ven biển, nơi giá thuê cao hơn mặt bằng chung.</li>
<li><strong>Tích sản dài hạn:</strong> chọn dự án sở hữu lâu dài, pháp lý rõ, chủ đầu tư có năng lực bàn giao.</li>
</ul>
<p>Anh chị muốn xem theo từng nhóm có thể đọc thêm <a href="/can-ho-view-song-han-du-an-va-gia/">căn hộ view sông Hàn</a>, <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Mỹ Khê</a> hoặc <a href="/mua-can-ho-da-nang-2-ty-3-ty/">căn hộ 2 – 3 tỷ</a>. Danh sách đầy đủ có tại trang <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>.</p>

<h2>Lưu ý trước khi chọn dự án</h2>
<p>Với căn hộ hình thành trong tương lai, cần kiểm tra văn bản đủ điều kiện bán, bảo lãnh ngân hàng và tiến độ thi công thực tế. Mốc bàn giao trong bảng đều là dự kiến, có thể thay đổi.</p>
<p>Giá chào bán và giá chuyển nhượng có thể chênh nhau đáng kể, nhất là ở dự án sắp bàn giao. Hãy so sánh cả hai trước khi quyết định.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá căn hộ Đà Nẵng cập nhật theo từng dự án và danh sách căn đang giao dịch thật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ Đà Nẵng 2026: dự án đang mở bán, giá, bàn giao',
			'desc'      => 'Căn hộ Đà Nẵng 2026: bảng dự án đang mở bán theo khu vực, giá tham khảo và thời điểm bàn giao. Liên hệ Hoàng Hiệp để nhận bảng giá mới.',
			'points'    => array( 'Giá sơ cấp căn hộ Đà Nẵng khoảng 80 – 90 triệu/m² theo báo cáo thị trường', 'Bảng hơn 15 dự án đang mở bán: khu vực, giá tham khảo, bàn giao', 'Chọn khu vực theo nhu cầu ở thực, cho thuê hay tích sản' ),
			'faq'       => array(
				array( 'Căn hộ Đà Nẵng 2026 giá bao nhiêu?', 'Giá tham khảo từ khoảng 2 tỷ cho studio ở Sơn Trà, Hòa Xuân đến trên 10 tỷ cho căn 3PN ven sông, ven biển. Giá sơ cấp phổ biến khoảng 80 – 90 triệu/m².' ),
				array( 'Khu vực nào có nhiều căn hộ mới nhất?', 'Nguồn cung mới tập trung ở Ngũ Hành Sơn (FPT City, Hòa Quý) và Hòa Xuân với các dự án Cora Tower, Spana Tower, S-Light Tower, FourS Tower.' ),
				array( 'Dự án nào bàn giao sớm nhất?', 'Sun Ponte Residence, Masteri Rivera Danang và Newtown Diamond đều dự kiến bàn giao quý 3/2026; Sun Symphony, Sun Cosmo, The Filmore đã và đang bàn giao.' ),
				array( 'Mua căn hộ Đà Nẵng cần kiểm tra gì?', 'Kiểm tra văn bản đủ điều kiện bán, bảo lãnh ngân hàng, thời hạn sở hữu, tiến độ thi công và so sánh giá với thị trường chuyển nhượng.' ),
			),
		),
		'sources'  => array( 'https://vietnamfinance.vn/can-ho-da-nang-vao-chu-ky-gia-cao-cau-dau-tu-dan-dat-ap-luc-an-cu-gia-tang-d144155.html', 'https://thitruongtaichinhtiente.vn/ty-le-hap-thu-can-ho-da-nang-khiem-ton-chi-30-40-77144.html', 'https://vnexpress.net/chung-cu-moi-o-da-nang-ngay-cang-dat-do-5067793.html' ),
	);

	$posts[] = array(
		'slug'     => 'can-ho-view-song-han-du-an-va-gia',
		'title'    => 'Căn hộ view sông Hàn: các dự án đang bán và mức giá tham khảo',
		'excerpt'  => 'Căn hộ view sông Hàn ở hai bờ Sơn Trà và Hải Châu: danh sách dự án, giá tham khảo, tình trạng bàn giao, cập nhật 10/2026.',
		'keyword'  => 'căn hộ view sông Hàn',
		'project'  => '',
		'week'     => 5,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Căn hộ view sông Hàn hiện có ở cả hai bờ: bờ Đông (Sơn Trà, Ngũ Hành Sơn) với các dự án của Sun Group, Peninsula, Capital Square, The Legend và bờ Tây (Hải Châu) với The Filmore, Danang Landmark, M Riverside, The Meridian. Giá tham khảo phổ biến khoảng 50 – 128 triệu/m² tùy dự án, tầng và hướng nhìn. Thông tin được Hoàng Hiệp cập nhật tháng 10/2026.</p>

<h2>Vì sao căn hộ view sông Hàn luôn được săn đón</h2>
<p>Sông Hàn là trục cảnh quan trung tâm của Đà Nẵng, gắn với cầu Rồng, cầu Trần Thị Lý và khu vực bắn pháo hoa quốc tế. Căn hộ nhìn ra sông vừa phục vụ ở thực, vừa dễ cho thuê với khách du lịch, chuyên gia.</p>
<p>Quỹ đất ven sông gần như không còn mới, nên số dự án có view sông trực diện rất hạn chế. Đây là lý do giá căn view sông thường cao hơn căn cùng dự án nhưng nhìn về hướng khác.</p>

<h2>Bảng căn hộ view sông Hàn và giá tham khảo</h2>
<table>
<thead><tr><th>Dự án</th><th>Bờ sông</th><th>Giá tham khảo</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a></td><td>Bờ Đông (Sơn Trà)</td><td>Studio từ khoảng 3,2 tỷ; 2PN khoảng 6 – 8 tỷ</td><td>Đang bàn giao</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Bờ Đông (Sơn Trà)</td><td>Khoảng 70 – 112 triệu/m²</td><td>Bàn giao Quý 3/2026 (dự kiến)</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Bờ Đông (chân cầu Trần Thị Lý)</td><td>Studio khoảng 1,8 – 2,5 tỷ; 2PN khoảng 3,6 – 6,8 tỷ</td><td>Đang bàn giao</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Bờ Đông (gần cầu Thuận Phước)</td><td>Khoảng 50 – 83 triệu/m²</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/capital-square-da-nang/">Capital Square</a></td><td>Bờ Đông (Trần Hưng Đạo)</td><td>Khoảng 74 – 90 triệu/m²</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a></td><td>Bờ Đông (đầu cầu Rồng)</td><td>Penthouse từ khoảng 37 tỷ; căn thường liên hệ</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/the-filmore-da-nang/">The Filmore</a></td><td>Bờ Tây (Bạch Đằng)</td><td>Khoảng 110 triệu/m²; 1PN khoảng 5,5 – 6 tỷ</td><td>Đang bàn giao</td></tr>
<tr><td><a href="/du-an/danang-landmark/">Danang Landmark</a></td><td>Bờ Tây (đối diện công viên APEC)</td><td>2PN khoảng 5,95 – 6,7 tỷ</td><td>Giữa năm 2027 (dự kiến)</td></tr>
<tr><td><a href="/du-an/m-riverside-da-nang/">M Riverside</a></td><td>Bờ Tây (đường 2/9)</td><td>Khoảng 117 – 128 triệu/m²</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/the-meridian-da-nang/">The Meridian</a></td><td>Bờ Tây (Quy Mỹ)</td><td>Studio/1PN từ khoảng 2,9 tỷ</td><td>Năm 2027 (dự kiến)</td></tr>
</tbody>
</table>
<p>Giá là khoảng tham khảo từ bảng giá công bố và tin chuyển nhượng công khai. Căn tầng cao, view sông trực diện thường nằm ở mức trên của khoảng giá.</p>

<h2>Bờ Đông hay bờ Tây sông Hàn?</h2>
<h3>Bờ Đông – Sơn Trà</h3>
<p>Bờ Đông có nhiều dự án quy mô lớn, nhìn sang trung tâm Hải Châu, gần biển Mỹ Khê. Nguồn hàng đa dạng từ studio đến penthouse, phù hợp cả ở thực và cho thuê.</p>
<h3>Bờ Tây – Hải Châu</h3>
<p>Bờ Tây là lõi hành chính, thương mại với công viên APEC, chợ Hàn, phố đi bộ ven sông. Số căn ít hơn, giá mỗi m² thường cao hơn, phù hợp khách tìm căn hạng sang hoặc căn cho thuê chuyên gia.</p>

<h2>Kinh nghiệm chọn căn view sông Hàn</h2>
<ul>
<li><strong>Xác định view thật:</strong> view trực diện, view chéo hay view một phần khác nhau rất nhiều về giá và khả năng cho thuê.</li>
<li><strong>Chú ý tầng:</strong> tầng thấp có thể bị che bởi công trình xung quanh trong tương lai.</li>
<li><strong>Kiểm tra hướng nắng:</strong> căn nhìn sông từ bờ Đông thường hướng Tây, cần tính rèm, kính cách nhiệt.</li>
<li><strong>So sánh giá chuyển nhượng:</strong> dự án đã bàn giao có dữ liệu giao dịch thật để đối chiếu.</li>
</ul>
<p>Nếu anh chị quan tâm thêm dòng căn ven biển, xem bài <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Đà Nẵng</a>. Danh sách đầy đủ dự án cao tầng có tại trang <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a> và <a href="/khu-vuc/son-tra/">khu vực Sơn Trà</a>.</p>

<h2>Mức giá thuê tham khảo của căn view sông</h2>
<p>View sông Hàn không chỉ đẹp mà còn giúp căn hộ cho thuê tốt hơn. Theo tin cho thuê công khai, căn 1PN tại The Filmore khoảng 22 – 27 triệu/tháng, căn 3PN view sông có thể đến 95 triệu/tháng.</p>
<p>Ở bờ Đông, 2PN Sun Ponte Residence khoảng 32 – 40 triệu/tháng, Peninsula Đà Nẵng khoảng 20 – 45 triệu/tháng tùy diện tích và view. Đây là các khoảng giá tham khảo, phụ thuộc nhiều vào nội thất.</p>
<p>Khi so sánh, anh chị nên lấy giá thuê chia giá mua để có tỷ suất gộp, thay vì chỉ nhìn giá thuê tuyệt đối. Chi tiết xem bài <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn hộ view sông Hàn trực diện đang có hàng và so sánh giá từng tầng, từng hướng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ view sông Hàn: dự án và giá tham khảo 2026',
			'desc'      => 'Căn hộ view sông Hàn hai bờ Sơn Trà, Hải Châu: bảng dự án, giá tham khảo, tình trạng bàn giao. Gọi Hoàng Hiệp để nhận căn view đẹp.',
			'points'    => array( '10 dự án căn hộ có view sông Hàn ở hai bờ', 'Giá tham khảo khoảng 50 – 128 triệu/m² tùy dự án, tầng, view', 'Phân biệt view trực diện, view chéo khi chọn căn' ),
			'faq'       => array(
				array( 'Căn hộ view sông Hàn giá bao nhiêu?', 'Tùy dự án, giá tham khảo khoảng 50 – 128 triệu/m²; studio từ khoảng 1,8 – 3,2 tỷ, căn 2PN phổ biến 4 – 8 tỷ.' ),
				array( 'Dự án view sông Hàn nào đã bàn giao?', 'Sun Symphony Residence, Sun Cosmo Residence và The Filmore đã và đang bàn giao, có thể nhận nhà sớm.' ),
				array( 'Nên mua bờ Đông hay bờ Tây sông Hàn?', 'Bờ Đông nhiều lựa chọn, giá đa dạng, gần biển; bờ Tây ít căn hơn, giá cao hơn nhưng nằm ngay lõi trung tâm Hải Châu.' ),
			),
		),
		'sources'  => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-symphony-residence', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang', 'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html' ),
	);

	$posts[] = array(
		'slug'     => 'can-ho-view-bien-da-nang-my-khe',
		'title'    => 'Căn hộ view biển Đà Nẵng: dự án ven biển Mỹ Khê và giá tham khảo',
		'excerpt'  => 'Căn hộ view biển Đà Nẵng dọc Mỹ Khê, Trường Sa: Times Square, Nobu, Wyndham Soleil, Newtown, HIYORI Aqua – giá tham khảo, cập nhật 10/2026.',
		'keyword'  => 'căn hộ view biển Đà Nẵng',
		'project'  => '',
		'week'     => 5,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Căn hộ view biển Đà Nẵng tập trung dọc trục Võ Nguyên Giáp – Trường Sa, nhìn ra biển Mỹ Khê. Nhóm dự án đáng chú ý gồm Times Square, Nobu Residences, Wyndham Soleil, Newtown Diamond và các tòa tháp gần biển ở bán đảo Sơn Trà. Giá tham khảo dao động rộng, từ khoảng 2,3 tỷ cho studio căn hộ khách sạn đến hơn 12 tỷ cho căn 2PN mặt biển, cập nhật tháng 10/2026.</p>

<h2>Đặc điểm căn hộ view biển Đà Nẵng</h2>
<p>Bãi biển Mỹ Khê là điểm đến hút khách du lịch quanh năm, nên căn hộ mặt biển có lợi thế lớn khi cho thuê. Tuy vậy, nhóm này có nhiều loại hình khác nhau: căn hộ sở hữu lâu dài, căn hộ khách sạn, căn hộ hàng hiệu.</p>
<p>Vì vậy, trước khi so giá, anh chị nên phân biệt rõ loại hình và thời hạn sở hữu của từng dự án.</p>

<h2>Bảng dự án căn hộ view biển Đà Nẵng</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Loại hình</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square Đà Nẵng</a></td><td>Võ Nguyên Giáp, trực diện Mỹ Khê</td><td>Căn hộ sở hữu lâu dài</td><td>Studio/1PN khoảng 6,5 – 8,5 tỷ; 2PN khoảng 12 – 14 tỷ</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a></td><td>Góc Võ Văn Kiệt – Võ Nguyên Giáp</td><td>Căn hộ hàng hiệu</td><td>1PN khoảng 6,63 – 9,06 tỷ</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil Đà Nẵng</a></td><td>Phạm Văn Đồng – Võ Nguyên Giáp</td><td>Căn hộ khách sạn 50 năm</td><td>Chuyển nhượng studio khoảng 2,3 – 2,6 tỷ</td></tr>
<tr><td><a href="/du-an/alize-da-nang/">Alizé Đà Nẵng</a></td><td>Vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt</td><td>Căn hộ khách sạn</td><td>Sắp mở bán – đang cập nhật</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>Trường Sa – Nam Kỳ Khởi Nghĩa</td><td>Căn hộ sở hữu lâu dài</td><td>1PN khoảng 3,5 – 3,9 tỷ; 2PN khoảng 5,7 – 7,5 tỷ</td></tr>
<tr><td><a href="/du-an/hiyori-aqua-tower/">HIYORI Aqua Tower</a></td><td>Bán đảo Sơn Trà, khoảng 5 phút đi bộ ra biển</td><td>Căn hộ sở hữu lâu dài</td><td>2PN 68 m² khoảng 4,5 tỷ</td></tr>
<tr><td><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a></td><td>Lê Văn Lương – Lê Đức Thọ</td><td>Căn hộ sở hữu lâu dài</td><td>Studio từ khoảng 1,98 tỷ</td></tr>
</tbody>
</table>
<p>Giá là khoảng tham khảo theo bảng giá công bố hoặc tin chuyển nhượng công khai. Không phải căn nào trong dự án cũng có view biển trực diện, cần kiểm tra mặt bằng từng tầng.</p>

<h2>Từng nhóm dự án ven biển</h2>
<h3>Mặt biển Mỹ Khê – Sơn Trà</h3>
<p>Times Square có khoảng 80% căn hộ nhìn ra biển, khối đế đã có thương hiệu F&amp;B hoạt động. Nobu Residences cao 43 tầng, gồm 264 căn hộ hàng hiệu, dự kiến hoàn thiện năm 2027. Wyndham Soleil là căn hộ khách sạn có thể ủy thác vận hành cho thuê.</p>
<h3>Trục Trường Sa – Ngũ Hành Sơn</h3>
<p>Newtown Diamond nằm đối diện Sheraton Grand Đà Nẵng Resort, cạnh sân golf BRG, cách bãi biển khoảng 1 phút đi bộ. Tổ hợp có 1.733 căn hộ, sở hữu lâu dài với sổ hồng từng căn, tòa The Ruby dự kiến bàn giao quý 3/2026.</p>
<h3>Gần biển, giá mềm hơn</h3>
<p>HIYORI Aqua Tower và The Camellia không nằm mặt biển nhưng chỉ cách biển vài phút, giá dễ tiếp cận hơn nhóm mặt tiền. Đây là lựa chọn hợp lý cho người cần ở thực gần biển.</p>

<h2>Lưu ý khi mua căn hộ view biển Đà Nẵng</h2>
<ul>
<li><strong>Thời hạn sở hữu:</strong> căn hộ khách sạn, căn hộ hàng hiệu thường gắn với đất thương mại dịch vụ, cần đối chiếu hợp đồng.</li>
<li><strong>Cam kết lợi nhuận:</strong> chỉ tham khảo, cần đọc kỹ điều kiện và chương trình đang áp dụng.</li>
<li><strong>Chi phí bảo trì:</strong> nhà gần biển chịu gió muối, nên ưu tiên dự án có vật liệu, quản lý vận hành tốt.</li>
</ul>
<p>Xem thêm so sánh <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">căn hộ sở hữu lâu dài và căn hộ dịch vụ 50 năm</a>, hoặc toàn bộ dự án tại <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a> và <a href="/khu-vuc/ngu-hanh-son/">khu vực Ngũ Hành Sơn</a>.</p>

<h2>Giá thuê căn hộ ven biển tham khảo</h2>
<p>Căn hộ ven biển hướng tới khách du lịch, chuyên gia nước ngoài nên giá thuê thường cao hơn mặt bằng chung. Theo tin cho thuê công khai, Times Square cho thuê dài hạn khoảng 25 – 40 triệu/tháng.</p>
<p>Wyndham Soleil có studio cho thuê khoảng 20 triệu/tháng, căn lớn view biển khoảng 25 – 45 triệu/tháng. Với căn hộ khách sạn, chủ căn có thể ủy thác cho đơn vị vận hành thay vì tự cho thuê.</p>
<p>Khi tính hiệu quả, hãy trừ mùa thấp điểm, phí quản lý và chi phí thay mới nội thất do môi trường biển. Một căn view biển trực diện có giá thuê tốt nhưng giá mua cũng cao, nên tỷ suất chưa chắc vượt căn gần biển giá mềm hơn.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn hộ view biển Đà Nẵng có view trực diện và bảng giá theo từng tầng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ view biển Đà Nẵng: dự án Mỹ Khê và giá 2026',
			'desc'      => 'Căn hộ view biển Đà Nẵng dọc Mỹ Khê, Trường Sa: bảng dự án, loại hình, giá tham khảo. Liên hệ Hoàng Hiệp để nhận căn view biển trực diện.',
			'points'    => array( 'Các dự án mặt biển Mỹ Khê và trục Trường Sa', 'Phân biệt căn hộ sở hữu lâu dài, căn hộ khách sạn, căn hộ hàng hiệu', 'Giá tham khảo từ khoảng 2 tỷ đến hơn 12 tỷ' ),
			'faq'       => array(
				array( 'Căn hộ view biển Đà Nẵng nào sở hữu lâu dài?', 'Times Square, Newtown Diamond, HIYORI Aqua Tower và The Camellia Sơn Trà được công bố là căn hộ sở hữu lâu dài.' ),
				array( 'Căn hộ mặt biển Mỹ Khê giá bao nhiêu?', 'Times Square khoảng 150 triệu/m² theo tin chuyển nhượng; Nobu 1PN khoảng 6,63 – 9,06 tỷ (tham khảo).' ),
				array( 'Có căn hộ gần biển giá dưới 3 tỷ không?', 'Có, ví dụ studio The Camellia từ khoảng 1,98 tỷ hoặc studio Wyndham Soleil chuyển nhượng khoảng 2,3 – 2,6 tỷ (căn hộ khách sạn 50 năm).' ),
			),
		),
		'sources'  => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-da-nang-times-square', 'https://cafeland.vn/du-an/to-hop-can-ho-khach-san-nobu-residences-da-nang-4356.html', 'https://vnexpress.net/newtown-diamond-cat-noc-toa-can-ho-dau-tien-5065074.html' ),
	);

	$posts[] = array(
		'slug'     => 'mua-can-ho-da-nang-2-ty-3-ty',
		'title'    => 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ: chọn dự án nào hợp túi tiền?',
		'excerpt'  => 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ vẫn có lựa chọn ở FPT City, Hòa Xuân, Sơn Trà. Bảng dự án, loại căn và giá tham khảo cập nhật 10/2026.',
		'keyword'  => 'mua căn hộ Đà Nẵng 2 tỷ',
		'project'  => '',
		'week'     => 5,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Mua căn hộ Đà Nẵng 2 tỷ đến 3 tỷ vẫn khả thi trong năm 2026, chủ yếu với căn studio, 1 phòng ngủ ở Sơn Trà, Hòa Xuân hoặc căn 2 phòng ngủ ở FPT City, Liên Chiểu. Hoàng Hiệp tổng hợp các dự án có giá tham khảo trong tầm này dựa trên bảng giá và tin chuyển nhượng công khai, cập nhật tháng 10/2026.</p>

<h2>Mua căn hộ Đà Nẵng 2 tỷ: thực tế thị trường</h2>
<p>Mặt bằng giá căn hộ mới tại Đà Nẵng đã tăng mạnh, nên với 2 – 3 tỷ, anh chị cần chấp nhận một trong ba điều: diện tích nhỏ, vị trí xa trung tâm hơn, hoặc mua lại căn đã bàn giao. Hiểu rõ đánh đổi này giúp chọn nhanh và đúng hơn.</p>

<h2>Bảng dự án có căn trong tầm 2 – 3 tỷ</h2>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Loại căn phù hợp</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/the-ori-garden/">The Ori Garden</a></td><td>Liên Chiểu</td><td>1PN – 3PN</td><td>1PN khoảng 1,31 – 1,94 tỷ; 2PN khoảng 1,96 – 2,56 tỷ; 3PN khoảng 2,79 – 3,1 tỷ</td></tr>
<tr><td><a href="/du-an/fpt-plaza-2/">FPT Plaza 2</a></td><td>Ngũ Hành Sơn – FPT City</td><td>2PN</td><td>Khoảng 2,25 – 3,4 tỷ</td></tr>
<tr><td><a href="/du-an/fpt-plaza-1/">FPT Plaza 1</a></td><td>Ngũ Hành Sơn – FPT City</td><td>2PN (58 – 73 m²)</td><td>Khoảng 2,6 – 3,15 tỷ</td></tr>
<tr><td><a href="/du-an/fpt-plaza-3/">FPT Plaza 3</a></td><td>Ngũ Hành Sơn – FPT City</td><td>1PN, 2PN nhỏ</td><td>1PN khoảng 1,6 – 2,5 tỷ; 2PN 55 – 60 m² từ khoảng 2,59 tỷ</td></tr>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a></td><td>Hòa Xuân</td><td>Sang nhượng hợp đồng</td><td>Khoảng 1,9 – 4,14 tỷ; 2PN tầng cao view sông từ khoảng 2,9 tỷ</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Ngũ Hành Sơn – ven sông Hàn</td><td>Studio</td><td>Khoảng 1,8 – 2,5 tỷ</td></tr>
<tr><td><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a></td><td>Sơn Trà</td><td>Studio</td><td>Khoảng 1,98 – 2,64 tỷ</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Sơn Trà – ven sông Hàn</td><td>1PN</td><td>Khoảng 2,2 – 2,7 tỷ</td></tr>
<tr><td><a href="/du-an/the-meridian-da-nang/">The Meridian</a></td><td>Hải Châu</td><td>Studio/1PN</td><td>Từ khoảng 2,9 tỷ</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>Ngũ Hành Sơn – ven biển</td><td>1PN (chuyển nhượng)</td><td>Từ khoảng 2,8 tỷ</td></tr>
</tbody>
</table>
<p>Giá chỉ là khoảng tham khảo, thay đổi theo tầng, view, nội thất và từng đợt bán. The Ori Garden có cả căn nhà ở xã hội và thương mại, căn nhà ở xã hội có điều kiện mua riêng.</p>

<h2>Ba hướng chọn với ngân sách 2 – 3 tỷ</h2>
<h3>1. Căn 2PN ở thực tại FPT City hoặc Liên Chiểu</h3>
<p>FPT Plaza 1, 2, 3 và The Ori Garden cho phép mua căn 2 phòng ngủ trong tầm 2 – 3 tỷ. Phù hợp gia đình trẻ cần không gian, ưu tiên trường học và tiện ích khu đô thị.</p>
<h3>2. Studio, 1PN ở vị trí trung tâm</h3>
<p>Sun Cosmo, The Camellia, Peninsula Đà Nẵng có căn nhỏ ở Sơn Trà, ven sông Hàn. Diện tích hạn chế nhưng vị trí tốt, dễ cho thuê cho người đi làm, khách du lịch.</p>
<h3>3. Sang nhượng hợp đồng ở khu Nam Đà Nẵng</h3>
<p>Spana Tower ở Hòa Xuân có căn sang nhượng hợp đồng mua bán từ khoảng 1,9 tỷ, bàn giao dự kiến 30/06/2027. Cần kiểm tra kỹ thủ tục chuyển nhượng hợp đồng và khoản đã thanh toán.</p>

<h2>Dùng đòn bẩy ngân hàng hợp lý</h2>
<p>Nhiều dự án có ngân hàng hỗ trợ vay đến 70% giá trị căn. Với căn 3 tỷ, vốn tự có khoảng 0,9 – 1 tỷ là có thể bắt đầu, nhưng cần tính kỹ khoản trả hằng tháng sau thời gian ưu đãi.</p>
<p>Chi tiết lãi suất, ân hạn xem tại bài <a href="/vay-mua-can-ho-da-nang-2026-lai-suat/">vay mua căn hộ Đà Nẵng 2026</a>. Danh sách căn đang rao bán có tại trang <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư</a>.</p>

<h2>Lưu ý khi mua căn hộ giá mềm</h2>
<ul>
<li>Kiểm tra căn là nhà ở thương mại hay nhà ở xã hội.</li>
<li>Với căn chuyển nhượng, xác minh hợp đồng, tiến độ đã đóng và xác nhận của chủ đầu tư.</li>
<li>Tính thêm phí bảo trì 2%, phí quản lý, nội thất vào tổng ngân sách.</li>
</ul>
<p>Xem thêm <a href="/kinh-nghiem-mua-can-ho-da-nang/">10 điều cần kiểm tra khi mua căn hộ Đà Nẵng</a>.</p>

<h2>Mua để ở hay để cho thuê?</h2>
<p>Nếu mua để ở, nên ưu tiên căn 2PN ở khu đô thị có trường học, công viên như FPT City, dù xa trung tâm hơn. Không gian sống và tiện ích nội khu quan trọng hơn view.</p>
<p>Nếu mua để cho thuê, căn nhỏ ở vị trí trung tâm thường cho tỷ suất tốt hơn. Ví dụ giá thuê tham khảo: căn 2PN FPT Plaza khoảng 10 – 13 triệu/tháng, studio Sun Cosmo từ khoảng 16 triệu/tháng, trong khi 2PN The Ori Garden khoảng 4 – 6 triệu/tháng.</p>
<p>Với cùng 2 – 3 tỷ, chênh lệch dòng tiền cho thuê giữa các khu vực là đáng kể. Hãy xác định mục tiêu chính trước khi chọn dự án.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn hộ Đà Nẵng 2 – 3 tỷ đang có hàng thật và phương án tài chính phù hợp.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ: chọn dự án nào?',
			'desc'      => 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ: bảng 10 dự án có căn trong tầm giá ở FPT City, Hòa Xuân, Sơn Trà. Gọi Hoàng Hiệp nhận danh sách căn thật.',
			'points'    => array( '10 dự án có căn tham khảo trong tầm 2 – 3 tỷ', 'Ba hướng chọn: 2PN ngoại vi, studio trung tâm, sang nhượng hợp đồng', 'Vay đến 70% giúp giảm vốn tự có ban đầu' ),
			'faq'       => array(
				array( 'Có 2 tỷ mua được căn hộ Đà Nẵng nào?', 'Có thể xem 1PN, 2PN The Ori Garden, 1PN FPT Plaza 3, studio Sun Cosmo hoặc The Camellia (giá tham khảo khoảng 1,3 – 2,6 tỷ).' ),
				array( 'Căn 2PN dưới 3 tỷ ở đâu?', 'Chủ yếu ở FPT City (FPT Plaza 1, 2, 3) và The Ori Garden (Liên Chiểu), giá tham khảo khoảng 1,96 – 3,15 tỷ.' ),
				array( 'Có nên mua sang nhượng hợp đồng không?', 'Có thể, nếu xác minh được hợp đồng gốc, số tiền đã đóng và chủ đầu tư xác nhận thủ tục chuyển nhượng.' ),
			),
		),
		'sources'  => array( 'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-ori-garden', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-2', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-spana-tower', 'https://cafeland.vn/du-an/the-camellia-son-tra-du-an-can-ho-tai-da-nang-5777.html' ),
	);

	$posts[] = array(
		'slug'     => 'kinh-nghiem-mua-can-ho-da-nang',
		'title'    => 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra trước khi xuống tiền',
		'excerpt'  => 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra về pháp lý, tiến độ, thanh toán, thời hạn sở hữu, giá và khả năng cho thuê.',
		'keyword'  => 'kinh nghiệm mua căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 5,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Kinh nghiệm mua căn hộ Đà Nẵng quan trọng nhất là kiểm tra kỹ pháp lý, tiến độ thanh toán, thời hạn sở hữu và giá thị trường trước khi đặt cọc. Dưới đây là 10 điều Hoàng Hiệp luôn rà soát cùng khách hàng, áp dụng cho cả căn mới và căn chuyển nhượng, cập nhật tháng 10/2026.</p>

<h2>Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra</h2>

<h3>1. Văn bản đủ điều kiện bán nhà ở hình thành trong tương lai</h3>
<p>Với căn hộ chưa xây xong, chủ đầu tư phải có văn bản của Sở Xây dựng xác nhận đủ điều kiện kinh doanh. Ví dụ, <a href="/du-an/danang-landmark/">Danang Landmark</a> được xác nhận ngày 03/03/2026 cho 454 căn.</p>

<h3>2. Bảo lãnh ngân hàng</h3>
<p>Nhà ở hình thành trong tương lai cần có bảo lãnh của ngân hàng cho nghĩa vụ bàn giao. Hãy yêu cầu xem văn bản bảo lãnh trước khi ký hợp đồng.</p>

<h3>3. Tiến độ thanh toán đúng luật</h3>
<p>Theo Luật Kinh doanh bất động sản 2023, tiền đặt cọc không quá 5% giá bán, thanh toán lần đầu không quá 30% và tổng thanh toán trước bàn giao không quá 70% giá trị hợp đồng. Lịch thanh toán khác thường là tín hiệu cần hỏi kỹ.</p>

<h3>4. Thời hạn sở hữu</h3>
<p>Căn hộ chung cư thường sở hữu lâu dài với người Việt Nam, còn căn hộ khách sạn, căn hộ dịch vụ trên đất thương mại có thời hạn theo dự án. Xem thêm bài <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">căn hộ sở hữu lâu dài hay căn hộ dịch vụ 50 năm</a>.</p>

<h3>5. Năng lực chủ đầu tư và tiến độ thực tế</h3>
<p>Đừng chỉ nghe mốc bàn giao dự kiến, hãy xem công trường đang ở giai đoạn nào: tầng hầm, thân hay cất nóc. Dự án đã cất nóc hoặc đang bàn giao giảm rủi ro chậm tiến độ.</p>

<h3>6. Mật độ căn trên tầng và tiện ích</h3>
<p>Số căn mỗi tầng ảnh hưởng trực tiếp đến sự riêng tư và thời gian chờ thang máy. Chẳng hạn <a href="/du-an/the-filmore-da-nang/">The Filmore</a> có 9 căn/tầng điển hình, trong khi <a href="/du-an/cora-tower/">Cora Tower</a> có 28 căn/tầng.</p>

<h3>7. View, hướng và tầng</h3>
<p>Căn cùng dự án có thể chênh nhau lớn về giá chỉ vì view. Kiểm tra mặt bằng tầng, công trình có thể mọc lên phía trước và hướng nắng chiều.</p>

<h3>8. So sánh giá sơ cấp với giá chuyển nhượng</h3>
<p>Ở dự án đang bàn giao, giá chuyển nhượng là thước đo thật. Ví dụ <a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a> có tin chuyển nhượng hợp đồng 2PN khoảng 4,9 tỷ, trong khi bảng giá 2PN khoảng 5,1 – 6,3 tỷ.</p>

<h3>9. Chính sách bán hàng và chi phí ẩn</h3>
<p>Chiết khấu, hỗ trợ lãi suất, miễn phí quản lý thay đổi theo từng đợt. Hãy tính đủ phí bảo trì 2%, phí quản lý hằng tháng, nội thất và chi phí vay sau ưu đãi.</p>

<h3>10. Khả năng cho thuê và thanh khoản</h3>
<p>Kể cả mua để ở, khả năng cho thuê và bán lại là tấm đệm an toàn. Tham khảo bài <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a> để ước tính dòng tiền.</p>

<h2>Bảng kiểm nhanh trước khi đặt cọc</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Tài liệu cần xem</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Pháp lý dự án</td><td>Văn bản đủ điều kiện bán, giấy phép xây dựng</td><td>Bắt buộc với căn hình thành trong tương lai</td></tr>
<tr><td>Bảo lãnh</td><td>Thư bảo lãnh ngân hàng</td><td>Nhận khi ký hợp đồng mua bán</td></tr>
<tr><td>Thanh toán</td><td>Phụ lục tiến độ thanh toán</td><td>Cọc ≤ 5%, lần đầu ≤ 30%, trước bàn giao ≤ 70%</td></tr>
<tr><td>Sở hữu</td><td>Hợp đồng, loại đất</td><td>Lâu dài hay có thời hạn</td></tr>
<tr><td>Căn chuyển nhượng</td><td>Hợp đồng gốc, phiếu thu, xác nhận chủ đầu tư</td><td>Tránh mua qua nhiều tầng trung gian</td></tr>
</tbody>
</table>

<h2>Những sai lầm thường gặp khi mua căn hộ</h2>
<ul>
<li><strong>Đặt cọc vì sợ hết hàng:</strong> nhiều đợt mở bán tạo cảm giác khan hiếm, nhưng cần đủ thời gian đọc hợp đồng.</li>
<li><strong>Chỉ nhìn giá tổng:</strong> nên quy ra giá mỗi m² thông thủy để so sánh công bằng giữa các dự án.</li>
<li><strong>Bỏ qua chi phí sau ưu đãi:</strong> lãi suất thả nổi sau giai đoạn hỗ trợ có thể cao hơn nhiều, xem bài <a href="/vay-mua-can-ho-da-nang-2026-lai-suat/">vay mua căn hộ Đà Nẵng</a>.</li>
<li><strong>Tin vào cam kết miệng:</strong> mọi ưu đãi, quà tặng, chiết khấu cần được ghi trong văn bản.</li>
</ul>

<h2>Lời khuyên từ Hoàng Hiệp</h2>
<p>Hãy so sánh ít nhất 2 – 3 dự án cùng phân khúc trước khi quyết định. Đọc thêm tổng quan <a href="/can-ho-da-nang-2026-du-an-dang-mo-ban/">căn hộ Đà Nẵng 2026 đang mở bán</a> hoặc xem trang <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được rà soát pháp lý, hợp đồng và so sánh giá trước khi xuống tiền mua căn hộ Đà Nẵng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra',
			'desc'      => 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra về pháp lý, bảo lãnh, thanh toán, sở hữu, giá. Gọi Hoàng Hiệp để được rà soát miễn phí.',
			'points'    => array( 'Kiểm tra văn bản đủ điều kiện bán và bảo lãnh ngân hàng', 'Cọc ≤ 5%, lần đầu ≤ 30%, trước bàn giao ≤ 70% theo Luật KDBĐS 2023', 'So sánh giá sơ cấp với giá chuyển nhượng thực tế' ),
			'faq'       => array(
				array( 'Mua căn hộ hình thành trong tương lai cần giấy tờ gì?', 'Cần văn bản đủ điều kiện bán của Sở Xây dựng, giấy phép xây dựng và bảo lãnh ngân hàng cho nghĩa vụ bàn giao.' ),
				array( 'Đặt cọc căn hộ tối đa bao nhiêu?', 'Theo Luật Kinh doanh bất động sản 2023, tiền đặt cọc không quá 5% giá bán nhà ở hình thành trong tương lai.' ),
				array( 'Mua căn chuyển nhượng hợp đồng cần lưu ý gì?', 'Xem hợp đồng gốc, phiếu thu các đợt đã đóng và thủ tục xác nhận chuyển nhượng của chủ đầu tư.' ),
				array( 'Có nên mua căn hộ khách sạn để ở?', 'Có thể, nhưng cần hiểu rõ thời hạn sử dụng theo đất thương mại dịch vụ và quy định vận hành của dự án.' ),
			),
		),
		'sources'  => array( 'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html' ),
	);

	/* ---------------- Tuần 6 ---------------- */

	$posts[] = array(
		'slug'     => 'vay-mua-can-ho-da-nang-2026-lai-suat',
		'title'    => 'Vay mua căn hộ Đà Nẵng 2026: lãi suất ngân hàng, ân hạn và cách tính',
		'excerpt'  => 'Vay mua căn hộ Đà Nẵng 2026: lãi suất ưu đãi các ngân hàng tháng 9/2026, chính sách ân hạn của dự án và ví dụ tính tiền trả hằng tháng.',
		'keyword'  => 'vay mua căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 6,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Vay mua căn hộ Đà Nẵng năm 2026 có lãi suất ưu đãi kỳ đầu phổ biến khoảng 8 – 10%/năm, nhưng sau ưu đãi có thể lên trên 13%/năm tùy ngân hàng. Nhiều dự án hỗ trợ vay đến 70% giá trị căn, kèm ân hạn gốc hoặc hỗ trợ lãi suất có thời hạn. Số liệu dưới đây là tham khảo, cập nhật tháng 10/2026.</p>

<h2>Lãi suất vay mua căn hộ Đà Nẵng tại các ngân hàng</h2>
<p>Theo các bài tổng hợp trên báo chí tháng 9/2026, lãi suất vay mua nhà bình quân khoảng 10,9%/năm với khoản vay cố định 12 – 24 tháng. Mức dưới 10% vẫn còn nhưng không nhiều.</p>
<table>
<thead><tr><th>Ngân hàng</th><th>Ưu đãi kỳ đầu (tham khảo)</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Agribank</td><td>8% (6 tháng); 8,5% (12 tháng); 9,8% (18 tháng)</td><td>Nhóm ngân hàng nhà nước</td></tr>
<tr><td>Vietcombank</td><td>9,6% (6 tháng); 9,9% (12 tháng); 13,6% (18 tháng)</td><td>Kỳ cố định dài lãi cao hơn</td></tr>
<tr><td>BIDV</td><td>Từ 9,7% (6 tháng); từ 10,1% (12 tháng)</td><td>Nhóm ngân hàng nhà nước</td></tr>
<tr><td>VietinBank</td><td>Khoảng 10% cố định 36 tháng</td><td>Theo tổng hợp báo chí</td></tr>
<tr><td>ACB</td><td>8,3% (12 tháng); 8,8% (24 tháng)</td><td>Ngân hàng tư nhân</td></tr>
<tr><td>MB</td><td>8,5% (12 tháng); 9% (18 tháng); 9,5% (24 tháng)</td><td>Ngân hàng tư nhân</td></tr>
<tr><td>Shinhan Bank</td><td>7,95% (12 tháng); 8% (24 tháng)</td><td>Ngân hàng nước ngoài</td></tr>
</tbody>
</table>
<p>Lãi suất thay đổi thường xuyên và phụ thuộc hồ sơ từng khách. Hãy xác nhận trực tiếp với ngân hàng, đặc biệt là biên độ cộng thêm sau thời gian ưu đãi.</p>

<h2>Chính sách vay và ân hạn tại một số dự án</h2>
<ul>
<li><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a>: hỗ trợ vay đến 70%, tối đa 18 tháng không trả gốc và lãi hoặc ân hạn nợ gốc dài hạn (các nguồn nêu 3 – 5 năm).</li>
<li><a href="/du-an/peninsula-private-da-nang/">Peninsula Private</a>: theo trang phân phối, ngân hàng hỗ trợ vay đến 70%, có gói 0% lãi suất trong 24 tháng.</li>
<li><a href="/du-an/the-meridian-da-nang/">The Meridian</a>: chính sách công bố có ngân hàng SHB hỗ trợ vay đến 70%, lãi suất 0% năm đầu.</li>
<li><a href="/du-an/m-riverside-da-nang/">M Riverside</a>: thanh toán linh hoạt tới 15 đợt, ngân hàng hỗ trợ vay tới 70%.</li>
</ul>
<p>Các chính sách này thay đổi theo từng đợt mở bán, chỉ nên dùng để so sánh ban đầu.</p>

<h2>Ân hạn gốc và hỗ trợ lãi suất khác nhau thế nào?</h2>
<h3>Ân hạn nợ gốc</h3>
<p>Trong thời gian ân hạn, người vay chỉ trả lãi, chưa trả gốc. Áp lực hằng tháng nhẹ hơn nhưng tổng lãi phải trả không giảm.</p>
<h3>Hỗ trợ lãi suất 0%</h3>
<p>Chủ đầu tư trả thay phần lãi trong một thời gian nhất định. Đây là ưu đãi thật, nhưng thường đi kèm giá bán không chiết khấu thêm, cần so với phương án thanh toán nhanh.</p>

<h2>Ví dụ tính tiền trả hằng tháng</h2>
<p>Giả sử vay 3 tỷ trong 20 năm, lãi suất 10%/năm, trả gốc đều. Gốc mỗi tháng khoảng 12,5 triệu, lãi tháng đầu khoảng 25 triệu, tổng tháng đầu khoảng 37,5 triệu và giảm dần theo dư nợ.</p>
<table>
<thead><tr><th>Kịch bản</th><th>Trả tháng đầu (ước tính)</th></tr></thead>
<tbody>
<tr><td>Đang ân hạn gốc, lãi 10%/năm</td><td>Khoảng 25 triệu (chỉ trả lãi)</td></tr>
<tr><td>Hết ân hạn, lãi 10%/năm</td><td>Khoảng 37,5 triệu</td></tr>
<tr><td>Hết ưu đãi, lãi 13%/năm</td><td>Khoảng 45 triệu</td></tr>
</tbody>
</table>
<p>Quy tắc an toàn: tổng tiền trả nợ không nên vượt 40 – 50% thu nhập ổn định hằng tháng. Với căn cho thuê, hãy so tiền trả nợ với <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a> thực tế.</p>

<h2>Vay theo tiến độ hay vay khi nhận nhà?</h2>
<p>Với căn hộ hình thành trong tương lai, ngân hàng thường giải ngân theo từng đợt thanh toán. Cách này giúp người mua chỉ trả lãi trên phần đã giải ngân, nhưng hồ sơ phải được duyệt ngay từ đầu.</p>
<p>Với căn đã bàn giao hoặc chuyển nhượng, khoản vay thường giải ngân một lần và tài sản đảm bảo là chính căn hộ. Lãi suất và hạn mức có thể khác so với gói liên kết dự án.</p>
<h3>Mẹo giảm chi phí vay</h3>
<ul>
<li>So sánh tổng chi phí cả vòng đời khoản vay, không chỉ lãi suất ưu đãi.</li>
<li>Hỏi rõ phí trả nợ trước hạn và biên độ cộng sau ưu đãi.</li>
<li>Cân nhắc phương án thanh toán nhanh để hưởng chiết khấu nếu dòng tiền cho phép.</li>
</ul>

<h2>Hồ sơ vay cần chuẩn bị</h2>
<ul>
<li>Giấy tờ nhân thân, tình trạng hôn nhân, nơi cư trú.</li>
<li>Chứng minh thu nhập: sao kê lương, hợp đồng lao động, giấy tờ kinh doanh hoặc hợp đồng cho thuê.</li>
<li>Hợp đồng mua bán căn hộ và tài liệu pháp lý của dự án.</li>
</ul>
<p>Anh chị đang chọn căn trong tầm vừa phải có thể xem thêm <a href="/mua-can-ho-da-nang-2-ty-3-ty/">mua căn hộ Đà Nẵng 2 – 3 tỷ</a> hoặc danh sách <a href="/mua-ban/can-ho-chung-cu/">căn hộ chung cư đang bán</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tính phương án vay mua căn hộ Đà Nẵng theo từng dự án và kết nối ngân hàng đang hỗ trợ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Vay mua căn hộ Đà Nẵng 2026: lãi suất, ân hạn',
			'desc'      => 'Vay mua căn hộ Đà Nẵng 2026: bảng lãi suất ưu đãi các ngân hàng, chính sách ân hạn dự án, ví dụ tính tiền trả. Gọi Hoàng Hiệp để tính phương án.',
			'points'    => array( 'Lãi suất ưu đãi kỳ đầu phổ biến khoảng 8 – 10%/năm (tham khảo 9/2026)', 'Nhiều dự án hỗ trợ vay đến 70%, có ân hạn gốc hoặc hỗ trợ lãi 0%', 'Vay 3 tỷ, 20 năm, lãi 10%: tháng đầu khoảng 37,5 triệu' ),
			'faq'       => array(
				array( 'Lãi suất vay mua căn hộ Đà Nẵng hiện bao nhiêu?', 'Theo tổng hợp tháng 9/2026, ưu đãi kỳ đầu khoảng 8 – 10%/năm, bình quân khoảng 10,9%/năm với khoản vay cố định 12 – 24 tháng (tham khảo).' ),
				array( 'Được vay tối đa bao nhiêu phần trăm giá trị căn hộ?', 'Nhiều dự án tại Đà Nẵng có ngân hàng hỗ trợ vay đến 70% giá trị căn, tùy hồ sơ thu nhập.' ),
				array( 'Ân hạn nợ gốc có lợi không?', 'Ân hạn giúp giảm áp lực trả hằng tháng giai đoạn đầu, nhưng tổng lãi không giảm; cần tính kỹ khoản trả sau khi hết ân hạn.' ),
			),
		),
		'sources'  => array( 'https://dantri.com.vn/bat-dong-san/thang-9-cac-ngan-hang-dang-cho-vay-mua-nha-lai-suat-bao-nhieu-20260903083127075.htm', 'https://nguoiquansat.vn/lai-suat-vay-mua-nha-thang-9-muc-duoi-10-khong-con-nhieu-313957.html', 'https://www.24h.com.vn/kinh-doanh/lai-suat-vay-mua-nha-thang-9-ngan-hang-nao-con-duoi-10-c161a1792123.html' ),
	);

	$posts[] = array(
		'slug'     => 'gia-thue-can-ho-da-nang-moi-thang',
		'title'    => 'Giá thuê căn hộ Đà Nẵng: cho thuê thu bao nhiêu mỗi tháng?',
		'excerpt'  => 'Giá thuê căn hộ Đà Nẵng theo từng dự án: studio, 1PN, 2PN, 3PN thu bao nhiêu mỗi tháng và cách ước tính tỷ suất cho thuê, cập nhật 10/2026.',
		'keyword'  => 'giá thuê căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 6,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Giá thuê căn hộ Đà Nẵng hiện dao động rất rộng: khoảng 3 – 8 triệu/tháng ở khu Liên Chiểu, 6,5 – 17 triệu/tháng ở FPT City và 20 – 40 triệu/tháng cho căn ven sông Hàn, ven biển có nội thất. Căn view đẹp ở dự án hạng sang có thể đến 95 triệu/tháng. Bảng dưới đây tổng hợp từ tin cho thuê công khai, cập nhật tháng 10/2026.</p>

<h2>Bảng giá thuê căn hộ Đà Nẵng theo dự án</h2>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Giá thuê tham khảo (triệu/tháng)</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/the-ori-garden/">The Ori Garden</a></td><td>Liên Chiểu</td><td>1PN 3 – 4,5; 2PN 4 – 6; 3PN 5 – 8</td></tr>
<tr><td><a href="/du-an/fpt-plaza-2/">FPT Plaza</a></td><td>FPT City</td><td>1PN từ 6,5; 2PN 10 – 13; 3PN 15,5 – 17</td></tr>
<tr><td><a href="/du-an/hiyori-garden-tower/">Hiyori Garden Tower</a></td><td>Sơn Trà</td><td>2PN 15 – 25 (phổ biến 18 – 21)</td></tr>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a></td><td>Sơn Trà – sông Hàn</td><td>1PN – 2PN 12 – 25; 3PN 10 – 40</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Sơn Trà – sông Hàn</td><td>Studio 13 – 20; 1PN 20 – 30; 2PN 32 – 40</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Ngũ Hành Sơn – sông Hàn</td><td>Studio từ 16; 1PN 23 – 24; 2PN 30 – 35</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Sơn Trà – sông Hàn</td><td>2PN 23 – 30; chung 20 – 45</td></tr>
<tr><td><a href="/du-an/capital-square-da-nang/">Capital Square</a></td><td>Sơn Trà – sông Hàn</td><td>1PN 18 – 25; 2PN 25 – 35 (ước tính)</td></tr>
<tr><td><a href="/du-an/vista-residence-da-nang/">Vista Residence</a></td><td>Hải Châu</td><td>2PN 20 – 32; 3PN 30 – 40</td></tr>
<tr><td><a href="/du-an/the-filmore-da-nang/">The Filmore</a></td><td>Hải Châu – sông Hàn</td><td>1PN 22 – 27; 2PN 35 – 40; 3PN đến 95</td></tr>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square</a></td><td>Sơn Trà – biển Mỹ Khê</td><td>Dài hạn 25 – 40</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a></td><td>Sơn Trà – biển</td><td>Studio khoảng 20; căn lớn 25 – 45</td></tr>
</tbody>
</table>
<p>Đây là khoảng giá tổng hợp từ tin rao, phụ thuộc nội thất, tầng, view và thời điểm. Giá thuê thực tế cần kiểm chứng với hợp đồng đang chạy.</p>

<h2>Yếu tố quyết định giá thuê căn hộ Đà Nẵng</h2>
<h3>Vị trí và view</h3>
<p>Căn ven sông Hàn, ven biển có giá thuê cao gấp 3 – 5 lần căn ở khu ngoại vi. Khách thuê chính là chuyên gia, người nước ngoài và khách du lịch dài ngày.</p>
<h3>Nội thất</h3>
<p>Căn đầy đủ nội thất thường cho thuê nhanh và giá cao hơn rõ rệt so với căn trống. Chi phí nội thất cần được tính vào vốn đầu tư.</p>
<h3>Thuê dài hạn hay ngắn hạn</h3>
<p>Thuê ngắn hạn có thể cho doanh thu cao hơn mùa cao điểm, nhưng tốn công vận hành và phụ thuộc quy định của tòa nhà. Thuê dài hạn ổn định hơn, ít rủi ro trống phòng.</p>

<h2>Cách ước tính tỷ suất cho thuê</h2>
<p>Tỷ suất gộp = tiền thuê cả năm chia giá mua. Ví dụ căn 2PN mua khoảng 5 tỷ, cho thuê 25 triệu/tháng thì thu khoảng 300 triệu/năm, tỷ suất gộp khoảng 6%/năm.</p>
<p>Sau khi trừ phí quản lý, thời gian trống phòng, bảo trì và thuế, tỷ suất ròng sẽ thấp hơn. Nếu có vay, cần so dòng tiền thuê với tiền trả nợ, xem thêm bài <a href="/vay-mua-can-ho-da-nang-2026-lai-suat/">vay mua căn hộ Đà Nẵng 2026</a>.</p>

<h2>Chi phí cần trừ khi cho thuê</h2>
<table>
<thead><tr><th>Khoản chi</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Phí quản lý tòa nhà</td><td>Tính theo m², trả hằng tháng dù có khách hay không</td></tr>
<tr><td>Thời gian trống phòng</td><td>Nên dự phòng 1 – 2 tháng/năm với thuê dài hạn</td></tr>
<tr><td>Bảo trì, thay nội thất</td><td>Cao hơn với căn thuê ngắn hạn, căn gần biển</td></tr>
<tr><td>Thuế cho thuê tài sản</td><td>Theo quy định hiện hành với cá nhân cho thuê</td></tr>
<tr><td>Phí môi giới, vận hành</td><td>Khi thuê đơn vị quản lý hoặc tìm khách qua môi giới</td></tr>
</tbody>
</table>
<p>Lập bảng dòng tiền đầy đủ giúp anh chị so sánh trung thực giữa các dự án, thay vì chỉ nhìn giá thuê đăng trên tin rao.</p>

<h2>Nên mua căn nào để cho thuê?</h2>
<ul>
<li>Ngân sách vừa phải: studio, 1PN gần sông Hàn hoặc biển, dễ cho thuê cho người đi làm và khách du lịch.</li>
<li>Khách chuyên gia, gia đình: 2PN – 3PN có nội thất ở trung tâm Hải Châu, Sơn Trà.</li>
<li>Muốn nhàn: căn hộ khách sạn có đơn vị vận hành, nhưng cần đọc kỹ điều kiện chia lợi nhuận.</li>
</ul>
<p>Anh chị có thể xem căn đang cho thuê tại trang <a href="/cho-thue/">cho thuê bất động sản Đà Nẵng</a> hoặc tham khảo <a href="/can-ho-view-song-han-du-an-va-gia/">căn hộ view sông Hàn</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được ước tính dòng tiền cho thuê theo từng căn cụ thể hoặc ký gửi căn hộ cho thuê.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá thuê căn hộ Đà Nẵng: thu bao nhiêu mỗi tháng?',
			'desc'      => 'Giá thuê căn hộ Đà Nẵng theo 12 dự án: studio đến 3PN, ven sông, ven biển, FPT City. Cách tính tỷ suất cho thuê. Gọi Hoàng Hiệp để được tư vấn.',
			'points'    => array( 'Giá thuê từ 3 – 8 triệu (Liên Chiểu) đến 20 – 40 triệu (ven sông, biển)', 'Căn hạng sang view sông Hàn có thể đến 95 triệu/tháng', 'Ví dụ: căn 5 tỷ thuê 25 triệu/tháng cho tỷ suất gộp khoảng 6%/năm' ),
			'faq'       => array(
				array( 'Giá thuê căn hộ Đà Nẵng 2PN bao nhiêu?', 'Tham khảo khoảng 4 – 6 triệu ở Liên Chiểu, 10 – 13 triệu ở FPT City và 20 – 40 triệu ở dự án ven sông Hàn, ven biển có nội thất.' ),
				array( 'Cho thuê căn hộ Đà Nẵng lãi bao nhiêu phần trăm?', 'Tùy giá mua và giá thuê; ví dụ căn 5 tỷ cho thuê 25 triệu/tháng có tỷ suất gộp khoảng 6%/năm, tỷ suất ròng thấp hơn sau chi phí.' ),
				array( 'Thuê ngắn hạn hay dài hạn tốt hơn?', 'Ngắn hạn có thể thu cao hơn mùa du lịch nhưng tốn công vận hành; dài hạn ổn định, ít trống phòng hơn.' ),
			),
		),
		'sources'  => array( 'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-cosmo-residence', 'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-the-filmore-da-nang', 'https://thuecanho123.com/cho-thue-can-ho-chung-cu-fpt-plaza.html', 'https://vietnamnet.vn/vista-residence-da-nang-tao-suc-hut-tren-thi-truong-can-ho-cho-thue-2560810.html' ),
	);

	$posts[] = array(
		'slug'     => 'can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam',
		'title'    => 'Căn hộ sở hữu lâu dài Đà Nẵng hay căn hộ dịch vụ 50 năm: chọn loại nào?',
		'excerpt'  => 'So sánh căn hộ sở hữu lâu dài Đà Nẵng với căn hộ dịch vụ, căn hộ khách sạn 50 năm: pháp lý, giá, khai thác cho thuê và dự án tiêu biểu.',
		'keyword'  => 'căn hộ sở hữu lâu dài Đà Nẵng',
		'project'  => '',
		'week'     => 6,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Căn hộ sở hữu lâu dài Đà Nẵng phù hợp người mua để ở và tích sản qua nhiều thế hệ, còn căn hộ dịch vụ, căn hộ khách sạn thời hạn khoảng 50 năm phù hợp người ưu tiên khai thác cho thuê, có đơn vị vận hành. Khác biệt cốt lõi nằm ở loại đất, thời hạn sử dụng và cách vận hành. Bài viết do Hoàng Hiệp tổng hợp, cập nhật tháng 10/2026.</p>

<h2>Căn hộ sở hữu lâu dài Đà Nẵng là gì?</h2>
<p>Đây là căn hộ chung cư xây trên đất ở, người Việt Nam được cấp giấy chứng nhận với thời hạn sử dụng lâu dài. Người nước ngoài, nếu dự án được phép bán, thường sở hữu có thời hạn 50 năm theo quy định.</p>
<p>Các dự án đang bán thuộc nhóm này gồm <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>, <a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a>, <a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a>, <a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a>, HIYORI Aqua Tower và các tòa tháp tại Sun NeO City.</p>

<h2>Căn hộ dịch vụ, căn hộ khách sạn 50 năm là gì?</h2>
<p>Nhóm này thường xây trên đất thương mại dịch vụ, thời hạn sử dụng theo dự án, phổ biến 50 năm. Luật Đất đai 2024 và các văn bản hướng dẫn đã tạo cơ sở cấp giấy chứng nhận cho căn hộ du lịch, nhưng thời hạn vẫn theo thời hạn sử dụng đất.</p>
<p>Ví dụ: <a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil Đà Nẵng</a> là căn hộ khách sạn thời hạn 50 năm theo thời hạn đất dự án; <a href="/du-an/hoiana-residences/">Hoiana Residences</a> là căn hộ khách sạn trong quần thể Hoiana. Với <a href="/du-an/nobu-da-nang/">Nobu Residences</a>, các nguồn chưa thống nhất về thời hạn, cần đối chiếu hợp đồng.</p>

<h2>Bảng so sánh hai loại căn hộ</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Căn hộ sở hữu lâu dài</th><th>Căn hộ dịch vụ / khách sạn</th></tr></thead>
<tbody>
<tr><td>Loại đất</td><td>Đất ở</td><td>Đất thương mại dịch vụ</td></tr>
<tr><td>Thời hạn</td><td>Lâu dài (người Việt Nam)</td><td>Theo dự án, phổ biến 50 năm</td></tr>
<tr><td>Đăng ký cư trú</td><td>Thuận lợi</td><td>Tùy quy định, thường hạn chế hơn</td></tr>
<tr><td>Vay ngân hàng</td><td>Phổ biến, dễ thẩm định</td><td>Có, nhưng ngân hàng thẩm định kỹ hơn</td></tr>
<tr><td>Khai thác cho thuê</td><td>Tự cho thuê hoặc thuê đơn vị quản lý</td><td>Thường có thương hiệu vận hành, chia lợi nhuận</td></tr>
<tr><td>Vị trí phổ biến</td><td>Trung tâm, khu đô thị</td><td>Mặt biển, khu du lịch</td></tr>
</tbody>
</table>

<h2>Ưu và nhược điểm từng loại</h2>
<h3>Căn hộ sở hữu lâu dài</h3>
<p>Ưu điểm là tài sản có thể để lại lâu dài, thanh khoản tốt, dễ vay. Nhược điểm là ít dự án mặt biển, và người mua phải tự lo khai thác nếu cho thuê.</p>
<h3>Căn hộ dịch vụ 50 năm</h3>
<p>Ưu điểm là vị trí đẹp, có đơn vị vận hành chuyên nghiệp, phù hợp khai thác du lịch. Nhược điểm là thời hạn có giới hạn, doanh thu phụ thuộc du lịch, và cam kết lợi nhuận cần xem rất kỹ.</p>

<h2>Trường hợp đặc biệt cần đọc kỹ hợp đồng</h2>
<p>Một số dự án có mô hình riêng. <a href="/du-an/m-riverside-da-nang/">M Riverside</a> là căn hộ dịch vụ thương mại, chủ đầu tư công bố đất sử dụng lâu dài và cấp giấy chứng nhận khi đủ điều kiện. Với mô hình lai như vậy, hãy đọc kỹ điều khoản về loại đất và thời hạn trong hợp đồng mua bán.</p>

<h2>Giá và khả năng cho thuê: so sánh thực tế</h2>
<p>Căn hộ khách sạn mặt biển thường có giá vào thấp hơn căn sở hữu lâu dài cùng vị trí. Ví dụ, studio Wyndham Soleil chuyển nhượng khoảng 2,3 – 2,6 tỷ, trong khi studio/1PN Times Square sở hữu lâu dài khoảng 6,5 – 8,5 tỷ (tham khảo).</p>
<p>Về cho thuê, Wyndham Soleil có thể ủy thác cho Wyndham vận hành, các chương trình chia lợi nhuận đã giới thiệu ở từng giai đoạn cần xác nhận lại. Căn sở hữu lâu dài như Sun Cosmo có giá thuê tham khảo 2PN khoảng 30 – 35 triệu/tháng, chủ nhà tự quyết cách khai thác.</p>
<p>Chênh lệch giá phản ánh khác biệt thời hạn và quyền sử dụng. Đừng chỉ so giá mỗi m², hãy so cả giá trị còn lại theo thời gian.</p>

<h2>Nên chọn loại nào?</h2>
<ul>
<li><strong>Mua để ở, tích sản lâu dài:</strong> ưu tiên căn hộ sở hữu lâu dài.</li>
<li><strong>Đầu tư khai thác du lịch, không có thời gian vận hành:</strong> cân nhắc căn hộ khách sạn có thương hiệu.</li>
<li><strong>Cân bằng:</strong> căn hộ sở hữu lâu dài gần biển hoặc ven sông, tự cho thuê dài hạn.</li>
</ul>
<p>Xem danh sách tại trang <a href="/loai-du-an/can-ho-so-huu-lau-dai/">căn hộ sở hữu lâu dài</a> và <a href="/loai-du-an/can-ho-dich-vu/">căn hộ dịch vụ</a>, hoặc bài <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được đối chiếu pháp lý, thời hạn sở hữu và chọn loại căn hộ phù hợp mục tiêu của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ sở hữu lâu dài Đà Nẵng hay căn hộ dịch vụ 50 năm',
			'desc'      => 'So sánh căn hộ sở hữu lâu dài Đà Nẵng và căn hộ dịch vụ 50 năm: loại đất, thời hạn, vay, cho thuê. Liên hệ Hoàng Hiệp để được đối chiếu pháp lý.',
			'points'    => array( 'Sở hữu lâu dài xây trên đất ở; căn hộ dịch vụ trên đất thương mại dịch vụ', 'Căn hộ khách sạn thời hạn theo dự án, phổ biến 50 năm', 'Mua để ở chọn sở hữu lâu dài; khai thác du lịch cân nhắc căn hộ khách sạn' ),
			'faq'       => array(
				array( 'Căn hộ dịch vụ 50 năm hết hạn thì sao?', 'Khi hết thời hạn sử dụng đất, việc gia hạn theo quy định pháp luật đất đai tại thời điểm đó; người mua cần đọc kỹ điều khoản trong hợp đồng.' ),
				array( 'Căn hộ khách sạn có được cấp sổ không?', 'Luật Đất đai 2024 và văn bản hướng dẫn đã tạo cơ sở cấp giấy chứng nhận cho căn hộ du lịch, với thời hạn theo thời hạn sử dụng đất của dự án.' ),
				array( 'Dự án nào ở Đà Nẵng là căn hộ sở hữu lâu dài?', 'Ví dụ Sun Ponte Residence, Newtown Diamond, Masteri Rivera Danang, The Camellia Sơn Trà, HIYORI Aqua Tower, Cora Tower, Spana Tower.' ),
			),
		),
		'sources'  => array( 'https://thanhnien.vn/tuong-lai-nao-cho-can-ho-du-lich-185260902161933623.htm', 'https://plo.vn/chinh-thuc-cap-so-hong-cho-condotel-resort-villa-post727415.html', 'https://lsvn.vn/gioi-han-quyen-so-huu-doi-voi-condotel-va-nhung-van-de-phap-ly-dat-ra-trong-cap-giay-chung-nhan-theo-phap-luat-viet-nam-a172126.html' ),
	);

	$posts[] = array(
		'slug'     => 'penthouse-da-nang-du-an-va-gia',
		'title'    => 'Penthouse Đà Nẵng: các dự án có penthouse và giá tham khảo',
		'excerpt'  => 'Penthouse Đà Nẵng ven sông Hàn, biển Mỹ Khê: The Legend, The Filmore, The Meridian, Times Square, Nobu, Danang Landmark – diện tích, giá tham khảo.',
		'keyword'  => 'penthouse Đà Nẵng',
		'project'  => '',
		'week'     => 6,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Penthouse Đà Nẵng là dòng sản phẩm rất hiếm, mỗi dự án thường chỉ có 2 – 8 căn trên các tầng cao nhất. Giá tham khảo hiện từ khoảng 14 – 17,8 tỷ (The Meridian) đến từ khoảng 37 tỷ (The Legend) và 44,9 tỷ (The Filmore). Hoàng Hiệp tổng hợp các dự án có penthouse đang giao dịch, cập nhật tháng 10/2026.</p>

<h2>Bảng penthouse Đà Nẵng theo dự án</h2>
<table>
<thead><tr><th>Dự án</th><th>Số căn / vị trí</th><th>Diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a></td><td>8 căn duplex, view sông Hàn – cầu Rồng</td><td>256 – 415 m²</td><td>Từ khoảng 37 tỷ</td></tr>
<tr><td><a href="/du-an/the-filmore-da-nang/">The Filmore</a></td><td>Tầng cao nhất, sẵn sàng bàn giao</td><td>Khoảng 206 m²</td><td>Từ khoảng 44,9 tỷ</td></tr>
<tr><td><a href="/du-an/the-meridian-da-nang/">The Meridian</a></td><td>Tầng cao, view sông Hàn và biển</td><td>Đến khoảng 198 m²</td><td>Khoảng 14 – 17,8 tỷ</td></tr>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square Đà Nẵng</a></td><td>2 căn tầng 30 tòa CT7</td><td>202,01 m² (3PN)</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Residences</a></td><td>2 penthouse và 6 Sky Villa hồ bơi riêng</td><td>Khoảng 372 m²; Sky Villa 254 – 288 m²</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/danang-landmark/">Danang Landmark</a></td><td>2 căn tầng 31 tòa Phoenix</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>7 căn tầng cao</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/peninsula-private-da-nang/">Peninsula Private</a></td><td>1 tầng penthouse và Sky Villa</td><td>Chưa công bố rộng rãi</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Giá là mức chào bán tham khảo từ trang phân phối và tin rao công khai. Penthouse thường được bán theo thỏa thuận, giá thực tế cần đối chiếu bảng giá chủ đầu tư từng đợt.</p>

<h2>Penthouse ven sông Hàn</h2>
<h3>The Legend Đà Nẵng</h3>
<p>The Legend nằm ngay đầu cầu Rồng, có 8 căn penthouse thiết kế duplex thông tầng với hồ bơi riêng và vườn trên mái. Đây là nhóm có diện tích lớn nhất trong danh sách, đến khoảng 415 m².</p>
<h3>The Filmore và Danang Landmark</h3>
<p>Hai dự án cùng nằm trên trục Bạch Đằng, bờ Tây sông Hàn. The Filmore đã hoàn thiện, penthouse khoảng 206 m² có tầm nhìn sông Hàn, cầu Rồng và biển Mỹ Khê; Danang Landmark có 2 căn penthouse nhìn trực diện sông và công viên APEC.</p>
<h3>The Meridian</h3>
<p>Penthouse The Meridian rộng đến khoảng 198 m², trang phân phối ghi giá khoảng 85 – 90 triệu/m². Mức giá này dễ tiếp cận hơn so với nhóm penthouse ven sông hạng sang khác.</p>

<h2>Penthouse ven biển Mỹ Khê</h2>
<p>Times Square có 2 căn penthouse 3 phòng ngủ tại tầng 30 tòa CT7. Nobu Residences cao 43 tầng, tầng cao có 2 căn penthouse và 6 căn Sky Villa sở hữu hồ bơi riêng, nhìn toàn cảnh biển Mỹ Khê và bán đảo Sơn Trà.</p>

<h2>Penthouse khu Nam Đà Nẵng</h2>
<p>Từ tháng 8/2026, Sun Property mở booking dòng penthouse và shophouse khối đế giới hạn, tổng 132 căn cho cả <a href="/du-an/cora-tower/">Cora Tower</a>, Spana Tower và S-Light Tower. Diện tích và giá đang cập nhật theo từng đợt.</p>
<p>Penthouse khu Nam Đà Nẵng phù hợp khách muốn diện tích lớn với tổng ngân sách thấp hơn nhóm ven sông Hàn trung tâm. Các tòa tháp tại Sun NeO City được công bố sở hữu lâu dài, Cora Tower dự kiến bàn giao 30/07/2027.</p>

<h2>Penthouse, Sky Villa và duplex khác nhau thế nào?</h2>
<p>Penthouse là căn trên tầng cao nhất, thường có sân thượng hoặc vườn riêng. Sky Villa là căn rộng trên tầng cao, có thể kèm hồ bơi riêng như ở Nobu, nhưng không nhất thiết nằm trên cùng.</p>
<p>Duplex là căn hai tầng nối bằng cầu thang nội bộ, có thể nằm ở nhiều vị trí trong tòa. Penthouse The Legend kết hợp cả hai: vừa ở tầng cao nhất, vừa thiết kế thông tầng.</p>
<p>Với người mua, sự khác biệt này ảnh hưởng đến công năng, chi phí vận hành và giá bán lại. Hãy xem kỹ mặt bằng thực tế trước khi so giá.</p>

<h2>Lưu ý khi mua penthouse</h2>
<ul>
<li><strong>Thời hạn sở hữu:</strong> kiểm tra căn thuộc dự án sở hữu lâu dài hay đất thương mại dịch vụ.</li>
<li><strong>Quyền sử dụng sân thượng, mái:</strong> phần diện tích này phải ghi rõ trong hợp đồng.</li>
<li><strong>Phí quản lý:</strong> diện tích lớn nên phí quản lý hằng tháng đáng kể.</li>
<li><strong>Thanh khoản:</strong> tệp khách nhỏ, thời gian bán lại có thể lâu hơn căn thường.</li>
</ul>
<p>Danh sách penthouse đang có hàng xem tại trang <a href="/san-pham/penthouse/">penthouse Đà Nẵng</a>; căn thông tầng xem thêm tại <a href="/san-pham/duplex/">căn duplex</a>. Tham khảo thêm <a href="/can-ho-view-song-han-du-an-va-gia/">căn hộ view sông Hàn</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận thông tin penthouse Đà Nẵng còn hàng, mặt bằng chi tiết và lịch xem căn riêng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Penthouse Đà Nẵng: dự án và giá tham khảo 2026',
			'desc'      => 'Penthouse Đà Nẵng ven sông Hàn, biển Mỹ Khê: The Legend, The Filmore, The Meridian, Nobu, Times Square – diện tích, giá. Gọi Hoàng Hiệp xem căn.',
			'points'    => array( 'Mỗi dự án chỉ có khoảng 2 – 8 căn penthouse', 'Giá tham khảo từ khoảng 14 tỷ đến trên 44,9 tỷ', 'Kiểm tra thời hạn sở hữu, quyền sử dụng sân thượng, phí quản lý' ),
			'faq'       => array(
				array( 'Penthouse Đà Nẵng giá bao nhiêu?', 'Tham khảo: The Meridian khoảng 14 – 17,8 tỷ, The Legend từ khoảng 37 tỷ, The Filmore từ khoảng 44,9 tỷ; nhiều dự án bán theo thỏa thuận.' ),
				array( 'Penthouse nào ở Đà Nẵng đã sẵn sàng bàn giao?', 'Penthouse The Filmore khoảng 206 m² được chào bán trực tiếp từ chủ đầu tư, sẵn sàng bàn giao.' ),
				array( 'Penthouse view biển Mỹ Khê có ở dự án nào?', 'Times Square (2 căn tầng 30 tòa CT7) và Nobu Residences (2 penthouse, 6 Sky Villa có hồ bơi riêng).' ),
			),
		),
		'sources'  => array( 'https://thelegendanang.com.vn/tu-39m2-den-penthouse-415m2-the-legend/', 'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang-phuong-hoa-cuong-tp-da-nang/duy-nhat-penthouse-mua-truc-tiep-cdt-206m2-gia-tu-45-ty-san-sang-ban-giao-pr45059382', 'https://the-meridian.com.vn/bang-gia-the-meridian-da-nang/', 'https://dantri.com.vn/bat-dong-san/sun-property-ra-mat-dong-penthouse-shophouse-khoi-de-gioi-han-tai-nam-trung-tam-da-nang-20260811094649419.htm' ),
	);

	$posts[] = array(
		'slug'     => 'shop-khoi-de-da-nang-co-nen-dau-tu',
		'title'    => 'Shop khối đế Đà Nẵng: có nên đầu tư, dự án nào đáng xem?',
		'excerpt'  => 'Shop khối đế Đà Nẵng: ưu nhược điểm, giá tham khảo tại Sun Symphony, Sun Ponte, Peninsula, Times Square và cách đánh giá trước khi đầu tư.',
		'keyword'  => 'shop khối đế Đà Nẵng',
		'project'  => '',
		'week'     => 6,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Shop khối đế Đà Nẵng đáng cân nhắc khi dự án có lượng cư dân lớn, mặt tiền đường chính và đã hoặc sắp bàn giao. Giá tham khảo hiện từ khoảng 4 tỷ (shop 2 tầng Sun Symphony) đến hàng chục tỷ cho shop mặt tiền lớn ven sông Hàn. Hoàng Hiệp phân tích ưu nhược điểm và các dự án đáng xem, cập nhật tháng 10/2026.</p>

<h2>Shop khối đế là gì?</h2>
<p>Shop khối đế là các căn thương mại ở tầng 1 – 2 (đôi khi đến tầng 3) của tòa căn hộ, thường bàn giao thô để chủ sở hữu tự hoàn thiện. Khách hàng chính là cư dân trong tòa và người qua lại trên tuyến đường mặt tiền.</p>

<h2>Bảng shop khối đế Đà Nẵng theo dự án</h2>
<table>
<thead><tr><th>Dự án</th><th>Số lượng</th><th>Diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a></td><td>77 shop 2 tầng</td><td>Khoảng 126 m² sử dụng</td><td>Từ khoảng 4 tỷ</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>26 shop</td><td>40,7 – 308,2 m²</td><td>Khoảng 4,6 tỷ (40,7 m²); 5,5 tỷ (55,9 m²); mặt tiền Trần Hưng Đạo khoảng 13 – 64,6 tỷ</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>10 shophouse 2 tầng, hai mặt tiền</td><td>199 – 269 m²</td><td>Từ khoảng 79 triệu/m²</td></tr>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square Đà Nẵng</a></td><td>15 shophouse 2 tầng</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>38 shop</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a></td><td>10 shop tầng trệt</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
<tr><td><a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a></td><td>Shophouse, shop góc tầng 1 – 3</td><td>Đang cập nhật</td><td>Thỏa thuận</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a>, S-Light Tower</td><td>Thuộc đợt giới hạn 132 căn của Sun Property</td><td>Đang cập nhật</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Giá là mức chào bán tham khảo từ trang phân phối, báo chí, cần đối chiếu bảng giá chủ đầu tư từng đợt.</p>

<h2>Ưu điểm khi đầu tư shop khối đế Đà Nẵng</h2>
<ul>
<li><strong>Khách hàng sẵn có:</strong> dự án lớn như Sun Symphony với 1.313 căn hộ tạo nhu cầu tiêu dùng hằng ngày cho shop.</li>
<li><strong>Sở hữu lâu dài ở nhiều dự án:</strong> ví dụ shop Sun Ponte và Times Square được công bố sở hữu lâu dài.</li>
<li><strong>Linh hoạt khai thác:</strong> tự kinh doanh hoặc cho thuê F&amp;B, tiện ích. Khối đế Times Square đã có Highlands, Phúc Long, KFC hoạt động.</li>
</ul>

<h2>Rủi ro cần tính trước</h2>
<h3>Phụ thuộc tỷ lệ lấp đầy cư dân</h3>
<p>Dự án mới bàn giao thường cần thời gian để cư dân về ở. Giai đoạn đầu, shop có thể khó cho thuê hoặc giá thuê thấp hơn kỳ vọng.</p>
<h3>Vốn lớn, chi phí hoàn thiện</h3>
<p>Shop thường bàn giao thô, người mua phải đầu tư thêm hoàn thiện. Giá mỗi m² shop cũng thường cao hơn căn hộ cùng dự án.</p>
<h3>Vị trí trong khối đế</h3>
<p>Shop góc, mặt tiền đường lớn khác rất xa shop nằm trong hoặc mặt sau. Hiện chưa có đủ dữ liệu công khai về giá thuê shop từng dự án, nên cần khảo sát thực tế trước khi tính dòng tiền.</p>

<h2>Cách đánh giá một căn shop khối đế</h2>
<ul>
<li><strong>Quy mô cư dân:</strong> đếm số căn hộ phía trên và tỷ lệ cư dân đã về ở.</li>
<li><strong>Mặt tiền và lưu lượng:</strong> shop ra đường chính, góc giao lộ có lợi thế lớn.</li>
<li><strong>Chiều cao tầng:</strong> ví dụ shop Sun Ponte có tầng 1 cao 7 m, có thể làm gác tăng diện tích sử dụng.</li>
<li><strong>Ngành hàng phù hợp:</strong> F&amp;B, tiện lợi, dịch vụ cư dân thường bền hơn thời trang, đồ cao cấp.</li>
<li><strong>Thời hạn và pháp lý:</strong> xác nhận sở hữu lâu dài hay có thời hạn, có được cấp giấy chứng nhận riêng không.</li>
</ul>

<h2>Có nên đầu tư shop khối đế Đà Nẵng?</h2>
<p>Nên cân nhắc nếu anh chị có vốn dài hạn, chọn dự án quy mô lớn, mặt tiền đường chính và chấp nhận 1 – 2 năm đầu dòng tiền chưa tối ưu. Không phù hợp nếu cần dòng tiền ngay hoặc vay tỷ lệ cao.</p>
<p>Nếu muốn so sánh với nhà phố, xem thêm trang <a href="/mua-ban/">mua bán bất động sản Đà Nẵng</a>. Danh sách shop đang có hàng có tại trang <a href="/san-pham/shop-khoi-de/">shop khối đế Đà Nẵng</a>; tham khảo thêm <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a> để ước tính lượng cư dân thuê ở.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách shop khối đế Đà Nẵng còn hàng, mặt bằng vị trí và phân tích khả năng khai thác từng căn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Shop khối đế Đà Nẵng: có nên đầu tư, dự án nào?',
			'desc'      => 'Shop khối đế Đà Nẵng: giá tham khảo Sun Symphony, Sun Ponte, Peninsula, Times Square; ưu nhược điểm, rủi ro. Gọi Hoàng Hiệp nhận danh sách shop.',
			'points'    => array( 'Shop 2 tầng Sun Symphony từ khoảng 4 tỷ; Sun Ponte khoảng 4,6 – 64,6 tỷ', 'Lợi thế: khách hàng cư dân sẵn có, nhiều dự án sở hữu lâu dài', 'Rủi ro: phụ thuộc tỷ lệ lấp đầy, vốn lớn, chi phí hoàn thiện' ),
			'faq'       => array(
				array( 'Shop khối đế Đà Nẵng giá bao nhiêu?', 'Tham khảo: Sun Symphony từ khoảng 4 tỷ; Sun Ponte khoảng 4,6 – 5,5 tỷ cho shop nhỏ, 13 – 64,6 tỷ cho shop mặt tiền; Peninsula từ khoảng 79 triệu/m².' ),
				array( 'Shop khối đế có được sở hữu lâu dài không?', 'Tùy dự án; shop Sun Ponte và Times Square được công bố sở hữu lâu dài, cần đối chiếu hợp đồng từng căn.' ),
				array( 'Đầu tư shop khối đế có rủi ro gì?', 'Rủi ro chính là cư dân chưa lấp đầy, vị trí shop kém, vốn lớn và chi phí hoàn thiện do shop thường bàn giao thô.' ),
			),
		),
		'sources'  => array( 'https://newstarland.com/bang-gia-sun-symphony-residence-da-nang/', 'https://sunponte.vn/shophouse-khoi-de-sun-ponte-residence/', 'https://thoibaonganhang.vn/shophouse-peninsula-da-nang-tung-chinh-sach-uu-dai-voi-gia-ban-chi-tu-79-trieum2-169394.html', 'https://smartland.vn/can-ho-da-nang-times-square/' ),
	);

	return $posts;
}
