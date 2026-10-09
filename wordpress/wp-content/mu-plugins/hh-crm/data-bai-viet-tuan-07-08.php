<?php
/**
 * Bài viết kế hoạch nội dung – tuần 7–8 (cụm Sun NeO City – sông Hàn – căn hộ cao cấp trung tâm). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_07_08' );
function hh_posts_tuan_07_08( $posts ) {
	/* ===================== TUẦN 7 ===================== */
	$posts[] = array(
		'slug'     => 'spana-tower-hoa-xuan-gia-mat-bang',
		'old_meta' => array( 'rank_math_description' => array( 'Mặt bằng Spana Tower Hòa Xuân của Sun Group: 2 tòa 22 tầng, khoảng 1.281 căn, giá tham khảo từ 1,9 tỷ, tiến độ xây dựng. Gọi Hoàng Hiệp nhận bảng giá.' ) ),
		'title'    => 'Spana Tower Hòa Xuân: giá bán, mặt bằng và loại căn 2026',
		'excerpt'  => 'Spana Tower là cặp tòa A1.3 – A1.4 của Sun Group ngay chân cầu Hòa Xuân, 1.237 căn. Tổng hợp giá tham khảo, mặt bằng và tiến độ.',
		'keyword'  => 'Spana Tower',
		'project'  => 'spana-tower',
		'week'     => 7,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Spana Tower</strong> là cặp tòa căn hộ A1.3 và A1.4 của Sun Group tại khu đô thị Sun NeO City, mặt tiền Nguyễn Phước Lan, ngay chân cầu Hòa Xuân. Dự án cao 22 tầng nổi, 2 tầng hầm với 1.237 căn từ Studio đến Penthouse, giá chào bán tham khảo từ khoảng 1,9 – 2,4 tỷ cho căn Studio. Bài viết cập nhật tháng 10/2026, giúp bạn nắm nhanh giá, mặt bằng và những điểm cần kiểm tra trước khi xuống tiền.</p>

<h2>Spana Tower ở đâu trong Sun NeO City?</h2>
<p>Sun NeO City là khu đô thị của Sun Group tại Hòa Xuân, phía Nam Đà Nẵng, cùng Sun Riverpolis tạo thành hệ sinh thái hơn 1.000 ha. Trong khu này hiện có ba tòa căn hộ đang bán: Cora Tower, Spana Tower và S-Light Tower.</p>
<p>Spana Tower nằm ngay chân cầu Hòa Xuân, mặt tiền trục Nguyễn Phước Lan. Từ đây đi trung tâm thành phố, cầu Rồng hay sân bay quốc tế Đà Nẵng mất khoảng 10 phút; ra bán đảo Sơn Trà hoặc phố cổ Hội An khoảng 30 phút (thời gian ước tính theo nguồn công bố).</p>
<p>Nếu bạn muốn so sánh với hai tòa còn lại cùng khu, có thể đọc thêm bài <a href="/cora-tower-sun-neo-city/">Cora Tower – tòa căn hộ trung tâm Sun NeO City</a> và <a href="/s-light-tower-mo-ban-2026/">S-Light Tower đợt mở bán 2026</a>.</p>

<h2>Quy mô và mặt bằng Spana Tower</h2>
<p>Dự án gồm 2 tòa A1.3 và A1.4, mỗi tòa 22 tầng nổi, chung 2 tầng hầm, tổng 1.237 căn hộ sở hữu lâu dài. Tầng 1 – 2 là shophouse khối đế và tiện ích nội khu; các tầng cao có căn Penthouse.</p>
<h3>Cơ cấu loại căn</h3>
<p>Rổ hàng gồm Studio, căn 1PN+, 2PN, 3PN, một số căn duplex và Penthouse. Diện tích theo các trang phân phối: Studio khoảng 31,6 m², 1PN khoảng 54,2 m², 2PN khoảng 70,3 m² và 3PN khoảng 104,3 m² (tham khảo, có thể khác theo từng mã căn).</p>
<h3>Tiện ích nội khu</h3>
<p>Theo thông tin công bố, Spana Tower có hồ bơi, gym & spa, kids club và dãy shophouse khối đế tầng 1 – 2. Bên ngoài là hạ tầng chung của Sun NeO City ven sông Cẩm Lệ, hướng về khu vực pháo hoa DIFF.</p>

<h2>Giá Spana Tower tham khảo theo loại căn</h2>
<p>Chủ đầu tư công bố giá theo từng đợt và từng mã căn, nên con số dưới đây chỉ là mặt bằng tham khảo tổng hợp từ các trang phân phối và tin rao công khai. Mức chung được nêu khoảng 60 triệu/m² (chưa gồm VAT và phí bảo trì).</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích tham khảo</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 31,6 m²</td><td>Khoảng 1,9 – 2,4 tỷ</td></tr>
<tr><td>Căn 1PN / 1PN+</td><td>Khoảng 54,2 m²</td><td>Khoảng 2,4 – 3,1 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>Khoảng 70,3 m²</td><td>Khoảng 3,4 – 4,2 tỷ</td></tr>
<tr><td>Căn 3PN</td><td>Khoảng 104,3 m²</td><td>Khoảng 5,0 – 6,5 tỷ</td></tr>
<tr><td>Penthouse, duplex, shophouse</td><td>Theo mã căn</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Trên thị trường thứ cấp, tin rao sang nhượng hợp đồng mua bán Spana Tower ghi khoảng 1,9 – 4,14 tỷ, trong đó căn 2PN tầng cao view sông được chào từ khoảng 2,9 tỷ (tham khảo). Giá thực tế phụ thuộc tầng, hướng, view và chính sách tại thời điểm ký.</p>

<h2>Penthouse và shophouse khối đế</h2>
<p>Tháng 8/2026, Sun Property ra mắt dòng penthouse và shophouse khối đế số lượng giới hạn tại ba tòa Cora, Spana và S-Light. Theo báo chí, có 150 căn shophouse khối đế, trong đó Spana Tower chiếm 50 căn, cùng 132 căn penthouse cho cả ba tòa.</p>
<p>Shophouse khối đế được giới thiệu với trần tầng 1 cao khoảng 7 m, có thể bố trí thêm sàn để vừa kinh doanh vừa làm văn phòng. Bạn có thể xem thêm nhóm sản phẩm này tại trang <a href="/san-pham/shop-khoi-de/">shop khối đế Đà Nẵng</a>.</p>

<h2>Pháp lý và tiến độ bàn giao</h2>
<p>Căn hộ Spana Tower là loại hình sở hữu lâu dài. Bàn giao được ghi dự kiến ngày 30/6/2027 theo thông tin đang có; mốc thực tế cần đối chiếu hợp đồng mua bán.</p>
<p>Trước khi đặt cọc, Hiệp khuyên bạn kiểm tra văn bản đủ điều kiện kinh doanh của từng tòa, tiến độ thanh toán và điều khoản bàn giao (tiêu chuẩn hoàn thiện, thời điểm nhận sổ).</p>

<h2>Spana Tower phù hợp với ai?</h2>
<ul>
<li>Người mua để ở cần căn hộ sở hữu lâu dài phía Nam thành phố với ngân sách khoảng 2 – 4 tỷ.</li>
<li>Nhà đầu tư cho thuê nhắm tới chuyên gia, người làm việc tại khu vực Hòa Xuân – Nam Đà Nẵng.</li>
<li>Khách muốn sở hữu shophouse khối đế trong khu đô thị đang hình thành cộng đồng cư dân.</li>
</ul>
<p>Điểm cần cân nhắc là khu Hòa Xuân vẫn đang hoàn thiện hạ tầng và tiện ích, nên giá trị dài hạn phụ thuộc tốc độ lấp đầy cư dân. So với căn hộ sát sông Hàn như <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, mặt bằng giá Spana thấp hơn rõ rệt.</p>

<h2>Câu hỏi thường gặp về Spana Tower</h2>
<h3>Spana Tower có mấy tòa, bao nhiêu căn?</h3>
<p>Hai tòa A1.3 và A1.4, cao 22 tầng nổi, 2 tầng hầm, tổng 1.237 căn hộ.</p>
<h3>Giá Spana Tower bao nhiêu?</h3>
<p>Tham khảo từ khoảng 1,9 – 2,4 tỷ cho Studio, khoảng 3,4 – 4,2 tỷ cho căn 2PN; giá chính thức theo bảng giá chủ đầu tư từng đợt.</p>

<p>Xem tổng quan dự án tại trang <a href="/du-an/spana-tower/">Spana Tower</a> hoặc danh sách <a href="/khu-vuc/cam-le/">dự án khu Cẩm Lệ</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Spana Tower mới nhất, mặt bằng từng tầng và danh sách căn còn lại.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Spana Tower Hòa Xuân: giá bán, mặt bằng 2026',
			'desc'      => 'Spana Tower Hòa Xuân của Sun Group: 2 tòa 22 tầng, 1.237 căn, giá tham khảo từ 1,9 tỷ. Xem mặt bằng, tiến độ và nhận bảng giá mới.',
			'points'    => array(
				'2 tòa A1.3 – A1.4, 22 tầng, 1.237 căn sở hữu lâu dài tại chân cầu Hòa Xuân',
				'Giá tham khảo: Studio khoảng 1,9 – 2,4 tỷ, 2PN khoảng 3,4 – 4,2 tỷ',
				'50 căn shophouse khối đế thuộc đợt sản phẩm giới hạn ra mắt 8/2026',
				'Bàn giao dự kiến 30/6/2027 – cần đối chiếu hợp đồng',
			),
			'faq'       => array(
				array( 'Spana Tower nằm ở đâu?', 'Mặt tiền Nguyễn Phước Lan, ngay chân cầu Hòa Xuân, trong khu đô thị Sun NeO City của Sun Group phía Nam Đà Nẵng.' ),
				array( 'Spana Tower có bao nhiêu căn hộ?', 'Gồm 1.237 căn thuộc 2 tòa A1.3 và A1.4, mỗi tòa 22 tầng nổi, chung 2 tầng hầm.' ),
				array( 'Giá căn hộ Spana Tower bao nhiêu?', 'Tham khảo từ khoảng 1,9 – 2,4 tỷ cho Studio đến khoảng 5 – 6,5 tỷ cho căn 3PN. Giá chính thức theo bảng giá chủ đầu tư từng đợt.' ),
				array( 'Khi nào Spana Tower bàn giao?', 'Thông tin hiện có ghi dự kiến 30/6/2027; mốc cụ thể cần đối chiếu hợp đồng mua bán.' ),
			),
		),
		'sources'  => array(
			'https://minhminhgroup.vn/sun-group-mo-ban-can-ho-hoa-xuan-spana-tower/',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-spana-tower',
			'https://smartrealtors.vn/gia-ban-spana-tower-dat-hay-re/',
			'https://cafef.vn/lo-dien-gan-300-san-pham-phien-ban-gioi-han-tai-cac-to-hop-can-ho-sun-group-nam-trung-tam-da-nang-188260811154747855.chn',
		),
	);

	$posts[] = array(
		'slug'     => 's-light-tower-mo-ban-2026',
		'title'    => 'S-Light Tower: đợt mở bán 2026, giá và chính sách tham khảo',
		'excerpt'  => 'S-Light Tower là cặp tháp 22 tầng, gần 800 căn của Sun Property tại Sun NeO City, ra mắt 6/2026. Cập nhật đợt mở bán, giá tham khảo và loại căn.',
		'keyword'  => 'S-Light Tower',
		'project'  => 's-light-tower',
		'week'     => 7,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>S-Light Tower</strong> là cặp tháp căn hộ 22 tầng của Sun Property (Sun Group) tại khu đô thị Sun NeO City, Hòa Xuân, ra mắt tháng 6/2026 với gần 800 căn từ 33,3 đến 95,1 m². Giá chào bán chính thức đi theo từng đợt; các đơn vị phân phối nêu mức từ khoảng 2 – 2,4 tỷ/căn. Bài viết cập nhật tháng 10/2026 tổng hợp các mốc mở bán, loại căn và những điều nên kiểm tra.</p>

<h2>S-Light Tower là dự án gì?</h2>
<p>S-Light Tower là tòa căn hộ thứ ba được Sun Property đưa ra thị trường tại Sun NeO City, sau Cora Tower và Spana Tower. Dự án nằm tại giao lộ đường 29/3 – Nguyễn Đình Thi, khu vực ngã ba sông Hàn – Cẩm Lệ – Đô Toả.</p>
<p>Điểm nhấn được chủ đầu tư giới thiệu là tầm nhìn khoảng 270° ra sông và không gian pháo hoa DIFF, cùng cam kết 100% căn hộ đón nắng và gió tự nhiên.</p>

<h2>Thông số chính S-Light Tower</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Sun Group (Sun Property phát triển)</td></tr>
<tr><td>Vị trí</td><td>Đường 29/3 giao Nguyễn Đình Thi, Sun NeO City, Hòa Xuân</td></tr>
<tr><td>Quy mô</td><td>2 tháp, 22 tầng nổi, 3 tầng hầm</td></tr>
<tr><td>Số căn</td><td>Gần 800 căn hộ</td></tr>
<tr><td>Diện tích</td><td>Khoảng 33,3 – 95,1 m²</td></tr>
<tr><td>Loại căn</td><td>Studio, 1PN+, 2PN, 3PN góc, Penthouse, shophouse khối đế</td></tr>
<tr><td>Sở hữu</td><td>Lâu dài</td></tr>
</tbody>
</table>

<h2>Các đợt mở bán S-Light Tower năm 2026</h2>
<h3>Tháng 6/2026: ra mắt dự án</h3>
<p>Sun Property chính thức ra mắt S-Light Tower vào tháng 6/2026, giới thiệu đây là "tâm điểm" mới của khu Nam trung tâm Đà Nẵng. Booking giai đoạn đầu được các đại lý thông báo ở mức khoảng 50 triệu/căn.</p>
<h3>Tháng 8/2026: penthouse và shophouse giới hạn</h3>
<p>Ngày 8/8/2026, Sun Property ra mắt dòng penthouse và shophouse khối đế số lượng giới hạn cho ba tòa Cora, Spana và S-Light. Theo báo chí, S-Light Tower có 38 căn shophouse trong tổng 150 căn; ba tòa có tổng 132 căn penthouse.</p>
<h3>Các đợt tiếp theo</h3>
<p>Giỏ hàng được mở theo từng đợt, mỗi đợt có bảng giá và chính sách riêng. Hiện các đợt sau đang cập nhật theo chủ đầu tư; liên hệ để nhận bảng giá và giỏ căn đúng thời điểm.</p>

<h2>Giá S-Light Tower tham khảo</h2>
<p>Bảng giá chính thức được gửi theo từng đợt và từng mã căn, chưa được công bố đại trà. Một số trang phân phối ghi giá từ khoảng 2 tỷ (đã gồm VAT và phí giao dịch theo cách tính của họ) hoặc từ khoảng 2,4 tỷ kèm chiết khấu.</p>
<p>Mặt bằng ước tính được nêu khoảng 70 – 90 triệu/m², nhưng đây là ước tính thị trường, không phải bảng giá chủ đầu tư. Hiệp khuyên bạn so sánh trên cùng điều kiện: giá trước/sau VAT, đã trừ chiết khấu hay chưa, và tiến độ thanh toán.</p>

<h2>Chính sách thanh toán được nhắc đến</h2>
<p>Các đơn vị phân phối giới thiệu chính sách "Sun Early Key": khách thanh toán khoảng 70% giá trị căn để nhận nhà khi bàn giao. Ngoài ra có thể có chiết khấu thanh toán sớm và hỗ trợ vay theo ngân hàng liên kết.</p>
<p>Chính sách thay đổi theo từng đợt, nên chỉ nên căn cứ vào văn bản chính sách đính kèm khi ký. Không nên quyết định chỉ dựa trên mức chiết khấu quảng cáo.</p>

<h2>Có nên mua S-Light Tower?</h2>
<p>S-Light Tower phù hợp với người mua cần căn hộ sở hữu lâu dài ven sông ở phía Nam thành phố, ngân sách khoảng 2 – 4 tỷ, chấp nhận chờ hạ tầng khu Hòa Xuân hoàn thiện. Căn góc 3PN đến 95,1 m² là lựa chọn cho gia đình đông người.</p>
<ul>
<li>Ưu điểm: thương hiệu Sun Group, view sông – pháo hoa, hệ sinh thái Sun NeO City đang hình thành.</li>
<li>Cần cân nhắc: nguồn cung lớn cùng khu (Cora, Spana, FourS Tower), thanh khoản cho thuê phụ thuộc mật độ cư dân.</li>
</ul>
<p>Để so sánh giá trong cùng khu, bạn có thể xem <a href="/spana-tower-hoa-xuan-gia-mat-bang/">giá Spana Tower Hòa Xuân</a> và <a href="/cora-tower-sun-neo-city/">Cora Tower</a>, hoặc trang tổng hợp <a href="/du-an/sun-neo-city/">Sun NeO City</a>.</p>

<p>Xem thêm danh sách <a href="/loai-du-an/can-ho-so-huu-lau-dai/">căn hộ sở hữu lâu dài Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá S-Light Tower đợt mới, mặt bằng căn và chính sách thanh toán đang áp dụng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'S-Light Tower: đợt mở bán 2026, giá tham khảo',
			'desc'      => 'S-Light Tower của Sun Property tại Hòa Xuân: 2 tháp 22 tầng, gần 800 căn 33,3 – 95,1 m². Cập nhật đợt mở bán 2026 – gọi Hoàng Hiệp nhận giá.',
			'points'    => array(
				'Ra mắt tháng 6/2026, 2 tháp 22 tầng, gần 800 căn, sở hữu lâu dài',
				'Diện tích 33,3 – 95,1 m², từ Studio đến 3PN góc và penthouse',
				'38 shophouse khối đế thuộc đợt sản phẩm giới hạn ngày 8/8/2026',
				'Giá theo bảng giá từng đợt; phân phối nêu từ khoảng 2 – 2,4 tỷ/căn',
			),
			'faq'       => array(
				array( 'S-Light Tower mở bán khi nào?', 'Sun Property ra mắt S-Light Tower tháng 6/2026; dòng penthouse và shophouse khối đế ra mắt ngày 8/8/2026. Giỏ hàng tiếp tục mở theo từng đợt.' ),
				array( 'Giá S-Light Tower bao nhiêu?', 'Bảng giá chính thức theo từng đợt. Các đơn vị phân phối nêu từ khoảng 2 – 2,4 tỷ/căn; liên hệ để nhận giá theo mã căn.' ),
				array( 'S-Light Tower có bao nhiêu căn?', 'Gần 800 căn hộ trong 2 tháp 22 tầng nổi, 3 tầng hầm.' ),
				array( 'S-Light Tower sở hữu bao lâu?', 'Căn hộ sở hữu lâu dài theo thông tin công bố của dự án.' ),
			),
		),
		'sources'  => array(
			'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn',
			'https://anninhthudo.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-post657042.antd',
			'https://cafeland.vn/du-an/s-light-tower-to-hop-can-ho-thuoc-sun-neo-city-da-nang-5622.html',
			'https://cafef.vn/lo-dien-gan-300-san-pham-phien-ban-gioi-han-tai-cac-to-hop-can-ho-sun-group-nam-trung-tam-da-nang-188260811154747855.chn',
		),
	);

	$posts[] = array(
		'slug'     => 'cora-tower-sun-neo-city',
		'title'    => 'Cora Tower: tòa căn hộ trung tâm Sun NeO City Hòa Xuân',
		'excerpt'  => 'Cora Tower nằm tại giao lộ Nguyễn Phước Lan – 29/3, trung tâm Sun NeO City. Tổng hợp mặt bằng tầng, loại căn, giá tham khảo và tiến độ bàn giao.',
		'keyword'  => 'Cora Tower',
		'project'  => 'cora-tower',
		'week'     => 7,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Cora Tower</strong> là tòa căn hộ của Sun Group nằm ở giao lộ Nguyễn Phước Lan – đường 29/3, vị trí trung tâm khu đô thị Sun NeO City (Hòa Xuân, Đà Nẵng). Dự án có căn Studio đến 3 phòng ngủ, bàn giao hoàn thiện cơ bản, sở hữu lâu dài, giá tham khảo từ khoảng 1,7 tỷ/căn theo các trang phân phối. Thông tin cập nhật tháng 10/2026.</p>

<h2>Vị trí Cora Tower trong Sun NeO City</h2>
<p>Sun NeO City là khu đô thị ven sông Cẩm Lệ ở phía Nam Đà Nẵng, kết nối trung tâm qua cầu Hòa Xuân và các trục Nguyễn Phước Lan, đường 29/3. Cora Tower được đặt tại giao lộ hai trục này, nên thường được giới thiệu là "trái tim" của khu đô thị.</p>
<p>Cùng khu còn có <a href="/du-an/spana-tower/">Spana Tower</a> ngay chân cầu Hòa Xuân và <a href="/du-an/s-light-tower/">S-Light Tower</a> ở ngã ba sông. Ba tòa dùng chung hạ tầng và hệ tiện ích của Sun NeO City.</p>

<h2>Mặt bằng điển hình Cora Tower</h2>
<p>Theo thông tin chủ đầu tư công bố, mỗi tầng điển hình có 28 căn: 6 Studio, 16 căn 1PN+, 5 căn 2PN và 1 căn 3PN. Tính theo tòa, mỗi tòa có 616 căn hộ điển hình.</p>
<table>
<thead><tr><th>Loại căn</th><th>Số căn/tầng</th><th>Số căn/tòa</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>6</td><td>132</td></tr>
<tr><td>Căn 1PN+</td><td>16</td><td>352</td></tr>
<tr><td>Căn 2PN</td><td>5</td><td>110</td></tr>
<tr><td>Căn 3PN</td><td>1</td><td>22</td></tr>
<tr><td><strong>Tổng</strong></td><td><strong>28</strong></td><td><strong>616</strong></td></tr>
</tbody>
</table>
<p>Lưu ý: một số trang phân phối ghi thông số khác (số tầng, tổng số căn, diện tích đất). Bảng trên lấy theo cơ cấu tầng điển hình được công bố; số liệu cuối cùng cần đối chiếu hồ sơ dự án và hợp đồng.</p>
<h3>Cơ cấu phù hợp nhu cầu nào?</h3>
<p>Tỷ lệ Studio và 1PN+ chiếm phần lớn cho thấy Cora Tower nhắm tới người trẻ, người mua căn đầu tiên và nhà đầu tư cho thuê. Căn 2PN, 3PN số lượng ít, phù hợp gia đình muốn chọn căn sớm.</p>

<h2>Giá Cora Tower tham khảo</h2>
<p>Các trang phân phối và tin rao ghi mặt bằng giá Cora Tower khoảng 45 – 55 triệu/m², tương đương khoảng 1,5 – 5 tỷ/căn tùy loại và vị trí; có nguồn ghi giá từ khoảng 1,7 tỷ/căn kèm ưu đãi. Đây là giá tham khảo, không phải bảng giá chính thức.</p>
<p>So với mặt bằng căn hộ ven sông Hàn khu trung tâm, Cora Tower có mức giá dễ tiếp cận hơn đáng kể. Đổi lại, tiện ích khu vực Hòa Xuân còn đang được hoàn thiện, nên người mua cần tính thời gian chờ.</p>

<h2>Shophouse khối đế và penthouse</h2>
<p>Tầng đế Cora Tower bố trí shophouse hướng ra giao lộ Nguyễn Phước Lan – 29/3. Trong đợt ra mắt sản phẩm giới hạn ngày 8/8/2026, Cora Tower có 62 căn shophouse khối đế – nhiều nhất trong ba tòa – cùng các căn penthouse view sông – núi – biển.</p>
<p>Shophouse ở vị trí giao lộ phù hợp kinh doanh dịch vụ phục vụ cư dân như cà phê, cửa hàng tiện lợi, phòng khám. Xem thêm nhóm sản phẩm tại <a href="/san-pham/penthouse/">penthouse Đà Nẵng</a>.</p>

<h2>Bàn giao và pháp lý</h2>
<p>Cora Tower bàn giao theo tiêu chuẩn hoàn thiện trần, tường, sàn (chưa gồm nội thất rời). Mốc bàn giao được ghi dự kiến ngày 30/7/2027.</p>
<p>Căn hộ sở hữu lâu dài. Khi đặt chỗ, bạn nên yêu cầu xem văn bản đủ điều kiện kinh doanh, phụ lục tiến độ thanh toán và danh mục vật liệu bàn giao.</p>

<h2>Cora Tower phù hợp với ai?</h2>
<ul>
<li>Người mua nhà lần đầu cần căn Studio, 1PN+ sở hữu lâu dài với ngân sách vừa phải.</li>
<li>Nhà đầu tư cho thuê dài hạn nhắm tới người làm việc tại khu Nam Đà Nẵng.</li>
<li>Khách tìm shophouse khối đế ở vị trí giao lộ trong khu đô thị mới.</li>
</ul>
<h2>Cora Tower khác gì Spana và S-Light?</h2>
<p>Ba tòa cùng thuộc Sun NeO City nhưng khác vị trí và thời điểm bàn giao. Cora Tower ở giao lộ trung tâm khu đô thị, bàn giao dự kiến 30/7/2027; Spana Tower nằm ngay chân cầu Hòa Xuân, bàn giao dự kiến 30/6/2027; S-Light Tower ra mắt muộn nhất (6/2026), nằm ở ngã ba sông với diện tích căn 33,3 – 95,1 m².</p>
<p>Nếu ưu tiên kinh doanh shophouse, Cora có số shophouse khối đế nhiều nhất. Nếu ưu tiên view sông và pháo hoa, nên xem kỹ mặt bằng S-Light. Chi tiết từng tòa có trong bài <a href="/spana-tower-hoa-xuan-gia-mat-bang/">Spana Tower Hòa Xuân</a> và <a href="/s-light-tower-mo-ban-2026/">S-Light Tower</a>.</p>
<p>Nếu cần so sánh thêm các lựa chọn khác, xem trang <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận mặt bằng Cora Tower từng tầng, bảng giá theo mã căn và danh sách shophouse còn lại.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cora Tower Sun NeO City: mặt bằng, giá tham khảo',
			'desc'      => 'Cora Tower tại giao lộ Nguyễn Phước Lan – 29/3, trung tâm Sun NeO City: 28 căn/tầng, Studio – 3PN, bàn giao dự kiến 7/2027. Nhận giá mới.',
			'points'    => array(
				'Giao lộ Nguyễn Phước Lan – đường 29/3, trung tâm Sun NeO City',
				'Tầng điển hình 28 căn: 6 Studio, 16 căn 1PN+, 5 căn 2PN, 1 căn 3PN',
				'62 shophouse khối đế trong đợt sản phẩm giới hạn 8/2026',
				'Bàn giao hoàn thiện cơ bản, dự kiến 30/7/2027',
			),
			'faq'       => array(
				array( 'Cora Tower ở đâu?', 'Giao lộ Nguyễn Phước Lan – đường 29/3, trung tâm khu đô thị Sun NeO City, Hòa Xuân, phía Nam Đà Nẵng.' ),
				array( 'Giá Cora Tower bao nhiêu?', 'Các trang phân phối ghi khoảng 45 – 55 triệu/m², từ khoảng 1,7 tỷ/căn (tham khảo). Giá chính thức theo bảng giá chủ đầu tư từng đợt.' ),
				array( 'Cora Tower bàn giao khi nào?', 'Dự kiến 30/7/2027, hoàn thiện trần, tường, sàn, chưa gồm nội thất rời.' ),
				array( 'Cora Tower có shophouse không?', 'Có. Đợt ra mắt ngày 8/8/2026 có 62 shophouse khối đế tại Cora Tower.' ),
			),
		),
		'sources'  => array(
			'https://baothanhhoa.vn/sun-group-gioi-thieu-cora-tower-tam-diem-moi-phia-nam-da-nang-265228.htm',
			'https://congly.com.vn/cora-tower-tam-diem-dau-tu-moi-cua-sun-group-tai-nam-da-nang/',
			'https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html',
			'https://cafef.vn/lo-dien-gan-300-san-pham-phien-ban-gioi-han-tai-cac-to-hop-can-ho-sun-group-nam-trung-tam-da-nang-188260811154747855.chn',
		),
	);

	$posts[] = array(
		'slug'     => 'sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue',
		'title'    => 'Sun Symphony Đà Nẵng: giá chuyển nhượng và giá cho thuê 2026',
		'excerpt'  => 'Giá chuyển nhượng Sun Symphony Đà Nẵng từ khoảng 3,2 tỷ cho Studio, cho thuê 1PN – 2PN khoảng 12 – 25 triệu/tháng. Bảng giá tham khảo theo loại căn.',
		'keyword'  => 'Sun Symphony Đà Nẵng',
		'project'  => 'sun-symphony-residence',
		'week'     => 7,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Căn hộ <strong>Sun Symphony Đà Nẵng</strong> (Sun Symphony Residence) đang được chuyển nhượng với mặt bằng tham khảo khoảng 69 – 125 triệu/m²: Studio từ khoảng 3,2 – 3,6 tỷ, căn 2PN khoảng 6 – 8 tỷ. Giá cho thuê 1PN – 2PN phổ biến khoảng 12 – 25 triệu/tháng. Số liệu tổng hợp từ tin rao công khai, cập nhật tháng 10/2026.</p>

<h2>Sun Symphony Đà Nẵng: thông tin nhanh</h2>
<p>Sun Symphony Residence là tổ hợp căn hộ, shophouse và biệt thự của Sun Group bên bờ Đông sông Hàn, trục Trần Hưng Đạo – Lê Văn Duyệt (Sơn Trà). Quy mô 8 ha, gồm 3 tòa căn hộ S1 (30 tầng), S2 (24 tầng), S3 (30 tầng) với 1.313 căn hộ, 77 shop khối đế và 200 sản phẩm thấp tầng thuộc phân khu The Sonata.</p>
<p>Diện tích căn hộ từ khoảng 35,8 m² (Studio) đến 93,1 m² (3PN), sở hữu lâu dài. Ba tòa cất nóc ngày 30/6/2025 và dự án bước vào giai đoạn bàn giao căn hộ năm 2026, nên giao dịch hiện chủ yếu là chuyển nhượng và cho thuê.</p>

<h2>Giá chuyển nhượng Sun Symphony theo loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá chuyển nhượng tham khảo</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 35,8 m²</td><td>Khoảng 3,2 – 3,6 tỷ</td></tr>
<tr><td>Căn 1PN+1</td><td>Khoảng 49,3 m²</td><td>Từ khoảng 4,5 tỷ</td></tr>
<tr><td>Căn 2PN / 2PN+1</td><td>Khoảng 68,8 – 79,2 m²</td><td>Khoảng 6 – 8 tỷ</td></tr>
<tr><td>Căn 3PN</td><td>Khoảng 93,1 m²</td><td>Từ khoảng 8,2 tỷ</td></tr>
<tr><td>Shop khối đế 2 tầng</td><td>Khoảng 126 m² sử dụng</td><td>Từ khoảng 4 tỷ (giá chào bán tham khảo)</td></tr>
</tbody>
</table>
<p>Khoảng giá trên rộng vì phụ thuộc tòa, tầng, hướng view (trực diện sông Hàn, pháo hoa hay hướng phố) và tình trạng nội thất. Căn view sông tầng cao thường nằm ở nhóm giá trên.</p>
<h3>Lưu ý khi mua chuyển nhượng</h3>
<ul>
<li>Xác minh căn đã bàn giao hay còn ở dạng hợp đồng mua bán; thủ tục và chi phí chuyển nhượng khác nhau.</li>
<li>Kiểm tra số tiền đã thanh toán cho chủ đầu tư, phần còn lại và các khoản phí quản lý, bảo trì.</li>
<li>Đối chiếu mã căn, diện tích thông thủy trên hợp đồng gốc với căn thực tế.</li>
</ul>

<h2>Giá cho thuê Sun Symphony Đà Nẵng</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>Căn 1PN – 2PN</td><td>Khoảng 12 – 25 triệu</td></tr>
<tr><td>Căn 3PN</td><td>Khoảng 10 – 40 triệu tùy nội thất, view</td></tr>
</tbody>
</table>
<p>Biên độ giá thuê lớn vì nhiều căn mới nhận bàn giao, nội thất chưa đồng đều. Căn full nội thất, view sông Hàn hướng pháo hoa thường cho thuê tốt hơn, đặc biệt vào mùa lễ hội.</p>
<p>Nếu bạn là chủ nhà muốn đăng cho thuê hoặc là khách cần thuê, có thể xem thêm danh mục <a href="/cho-thue/">cho thuê bất động sản Đà Nẵng</a>.</p>

<h2>Tiện ích tạo giá trị cho Sun Symphony</h2>
<p>Dự án có công viên trung tâm khoảng 5.000 m², 3 bến du thuyền nội khu, đường dạo ven sông Hàn, hồ bơi vô cực và hồ bơi trong nhà, sky lounge, gym, spa, kids club. Đây là nhóm tiện ích ít dự án ven sông Hàn có đủ.</p>
<p>Về kết nối, từ dự án đến cầu quay sông Hàn khoảng 3 phút, cầu Rồng và biển Mỹ Khê khoảng 5 phút, sân bay khoảng 15 phút (ước tính theo nguồn công bố).</p>

<h2>Mua Sun Symphony để ở hay cho thuê?</h2>
<p>Để ở, Sun Symphony phù hợp gia đình muốn sống sát trung tâm, cạnh sông Hàn, nhiều tiện ích nội khu. Để cho thuê, lợi suất phụ thuộc giá mua vào: mua ở mức cao của khoảng giá thì lợi suất cho thuê dài hạn sẽ không lớn.</p>
<p>Hiệp thường khuyên khách tính lợi suất trên tổng chi phí thực tế (giá mua, nội thất, phí quản lý) thay vì dùng giá thuê cao nhất trên tin rao. Nếu đang phân vân giữa các dự án ven sông, hãy đọc bài <a href="/so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula/">so sánh căn hộ ven sông Hàn: Sun Symphony, Sun Ponte, Peninsula</a>.</p>

<h2>Câu hỏi thường gặp</h2>
<h3>Sun Symphony Đà Nẵng đã bàn giao chưa?</h3>
<p>Ba tòa S1, S2, S3 cất nóc tháng 6/2025 và dự án bàn giao căn hộ trong năm 2026; mốc từng căn theo thông báo của chủ đầu tư.</p>
<h3>Có nên mua căn Studio Sun Symphony để cho thuê?</h3>
<p>Studio có vốn thấp nhất trong dự án và dễ cho thuê ngắn hạn, nhưng nên kiểm tra quy định vận hành của tòa nhà về lưu trú ngắn ngày.</p>

<p>Xem thêm trang dự án <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> và các căn đang bán tại <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Sun Symphony đang chuyển nhượng và cho thuê thật, kèm giá cập nhật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Symphony Đà Nẵng: giá chuyển nhượng, cho thuê',
			'desc'      => 'Giá chuyển nhượng Sun Symphony Đà Nẵng từ khoảng 3,2 tỷ, thuê 1PN – 2PN khoảng 12 – 25 triệu/tháng. Xem bảng giá, liên hệ nhận căn thật.',
			'points'    => array(
				'Chuyển nhượng khoảng 69 – 125 triệu/m², Studio từ khoảng 3,2 tỷ',
				'Cho thuê 1PN – 2PN khoảng 12 – 25 triệu/tháng; 3PN đến khoảng 40 triệu',
				'3 tòa S1, S2, S3 – 1.313 căn hộ, cất nóc 6/2025, bàn giao năm 2026',
				'Tiện ích: công viên 5.000 m², 3 bến du thuyền, hồ bơi vô cực',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng Sun Symphony Đà Nẵng bao nhiêu?', 'Tham khảo: Studio khoảng 3,2 – 3,6 tỷ, 1PN+ từ 4,5 tỷ, 2PN khoảng 6 – 8 tỷ, 3PN từ 8,2 tỷ, tùy tầng và view.' ),
				array( 'Thuê căn hộ Sun Symphony giá bao nhiêu?', 'Căn 1PN – 2PN khoảng 12 – 25 triệu/tháng; 3PN khoảng 10 – 40 triệu/tháng tùy nội thất và view.' ),
				array( 'Sun Symphony có bao nhiêu căn hộ?', '1.313 căn hộ trong 3 tòa S1, S2, S3, cùng 77 shop khối đế và 200 sản phẩm thấp tầng.' ),
				array( 'Mua chuyển nhượng Sun Symphony cần kiểm tra gì?', 'Tình trạng bàn giao, số tiền đã thanh toán, hợp đồng gốc, diện tích thông thủy và các khoản phí quản lý.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-symphony-residence',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-symphony-residence/gia-tu-10-trieu-den-40-trieu-3pn',
			'https://scdgroup.vn/tin-tuc/sun-symphony-residence-thang-42026-dien-mao-hoan-thien-san-sang-ban-giao-giua-mua-le-hoi',
			'https://anninhthudo.vn/ban-giao-than-toc-to-hop-sun-symphony-residence-mat-song-han-chinh-thuc-sang-den-post652466.antd',
		),
	);

	$posts[] = array(
		'slug'     => 'so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula',
		'title'    => 'Căn hộ ven sông Hàn: so sánh Sun Symphony, Sun Ponte, Peninsula',
		'excerpt'  => 'So sánh căn hộ ven sông Hàn: Sun Symphony, Sun Ponte và Peninsula Đà Nẵng về quy mô, giá chuyển nhượng, giá thuê và tiến độ bàn giao.',
		'keyword'  => 'căn hộ ven sông Hàn',
		'project'  => 'sun-symphony-residence',
		'week'     => 7,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Nếu tìm <strong>căn hộ ven sông Hàn</strong> phía Sơn Trà, ba lựa chọn được hỏi nhiều nhất là Sun Symphony Residence, Sun Ponte Residence và Peninsula Đà Nẵng. Tóm tắt nhanh: Sun Symphony có quy mô và tiện ích lớn nhất, Sun Ponte sát cầu Rồng và giá thuê cao, Peninsula có mặt bằng giá dễ tiếp cận nhất. Bảng so sánh dưới đây cập nhật tháng 10/2026, giá là mức tham khảo từ tin rao công khai.</p>

<h2>Bảng so sánh nhanh ba dự án</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Sun Symphony Residence</th><th>Sun Ponte Residence</th><th>Peninsula Đà Nẵng</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Sun Group</td><td>Sun Group</td><td>Tập đoàn Đông Đô</td></tr>
<tr><td>Vị trí</td><td>Trần Hưng Đạo – Lê Văn Duyệt, gần cầu quay sông Hàn</td><td>Trần Hưng Đạo, giữa cầu Rồng và cầu Trần Thị Lý</td><td>Lê Văn Duyệt, gần cầu Thuận Phước</td></tr>
<tr><td>Quy mô</td><td>8 ha, 3 tòa 24 – 30 tầng</td><td>1 tòa 26 tầng</td><td>1 tòa 30 tầng</td></tr>
<tr><td>Số căn hộ</td><td>1.313</td><td>495 (+7 penthouse)</td><td>Khoảng 941</td></tr>
<tr><td>Diện tích căn</td><td>35,8 – 93,1 m²</td><td>Studio – 3PN</td><td>46 – 109 m²</td></tr>
<tr><td>Giá chuyển nhượng</td><td>≈ 69 – 125 triệu/m²</td><td>≈ 70 – 112 triệu/m²</td><td>≈ 50 – 83 triệu/m²</td></tr>
<tr><td>Thuê 2PN/tháng</td><td>Khoảng 12 – 25 triệu (1PN – 2PN)</td><td>Khoảng 32 – 40 triệu</td><td>Khoảng 23 – 30 triệu</td></tr>
<tr><td>Bàn giao</td><td>Năm 2026</td><td>Từ 3/2026, hoàn tất dự kiến Quý 3/2026</td><td>Hoàn thành dự kiến Quý 4/2026</td></tr>
</tbody>
</table>
<p>Lưu ý: giá thuê ở đây tổng hợp từ tin rao, mỗi dự án có tỷ lệ căn full nội thất khác nhau nên chỉ dùng để tham khảo mặt bằng, không phải lợi suất cam kết.</p>

<h2>Sun Symphony Residence: quy mô và tiện ích lớn nhất</h2>
<p>Sun Symphony rộng 8 ha với 3 tòa S1, S2, S3, có công viên trung tâm khoảng 5.000 m², 3 bến du thuyền nội khu và đường dạo ven sông. Giá chuyển nhượng tham khảo: Studio khoảng 3,2 – 3,6 tỷ, 2PN khoảng 6 – 8 tỷ, 3PN từ 8,2 tỷ.</p>
<p>Phù hợp gia đình cần không gian sống rộng, nhiều tiện ích trong nội khu. Chi tiết giá và cho thuê xem tại bài <a href="/sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue/">Sun Symphony Đà Nẵng: giá chuyển nhượng và cho thuê</a>.</p>

<h2>Sun Ponte Residence: sát cầu Rồng, giá thuê cao</h2>
<p>Sun Ponte là tòa tháp 26 tầng trên đường Trần Hưng Đạo, chỉ khoảng 1 phút tới cầu Rồng. Dự án có 495 căn hộ, 7 penthouse, 26 shophouse và phân khu thấp tầng The Rio.</p>
<p>Giá chuyển nhượng tham khảo: Studio/1PN khoảng 2,96 – 4,49 tỷ, 2PN khoảng 4,3 – 6,9 tỷ, 3PN khoảng 5,6 – 10 tỷ. Giá thuê 2PN được rao khoảng 32 – 40 triệu/tháng, cao nhất trong nhóm, nhờ vị trí sát cầu Rồng và khu du lịch.</p>
<p>Phù hợp nhà đầu tư cho thuê và người cần căn nhỏ ở vị trí trung tâm. Xem thêm tại trang <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>.</p>

<h2>Peninsula Đà Nẵng: mặt bằng giá dễ tiếp cận</h2>
<p>Peninsula nằm trên khu đất khoảng 7.167 m² có 4 mặt tiền và 3 mặt hướng sông Hàn, gần cầu Thuận Phước. Dự án cao 30 tầng, khoảng 941 căn, hồ bơi vô cực ở tầng 30.</p>
<p>Giá chuyển nhượng tham khảo: 1PN khoảng 2,2 – 2,7 tỷ, 2PN khoảng 3 – 5 tỷ, 3PN khoảng 5,5 – 6,5 tỷ. Theo kế hoạch công bố, dự án hoàn thành dự kiến Quý 4/2026, nên người mua cần tính thời gian chờ nhận nhà.</p>
<p>Phù hợp người mua để ở với ngân sách 3 – 5 tỷ vẫn muốn view sông Hàn. Xem thêm tại trang <a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>.</p>

<h2>Chọn dự án nào theo nhu cầu?</h2>
<h3>Mua để ở lâu dài</h3>
<p>Ưu tiên Sun Symphony nếu ngân sách cho phép vì tiện ích nội khu đầy đủ; Peninsula nếu muốn tiết kiệm chi phí mà vẫn giữ view sông.</p>
<h3>Mua để cho thuê</h3>
<p>Sun Ponte có lợi thế vị trí cho khách du lịch và chuyên gia. Tuy nhiên, giá mua vào cũng cao, nên cần tính lợi suất trên tổng chi phí thực tế.</p>
<h3>Mua để chờ tăng giá</h3>
<p>Dự án chưa bàn giao thường có giá thấp hơn dự án đã vận hành, nhưng đi kèm rủi ro tiến độ. Hãy đối chiếu tiến độ thi công thực tế và điều khoản phạt chậm bàn giao trong hợp đồng.</p>

<h2>Checklist trước khi chọn căn hộ ven sông Hàn</h2>
<ul>
<li>Hướng view: trực diện sông, pháo hoa hay hướng phố – chênh lệch giá có thể đáng kể.</li>
<li>Tầng: tầng thấp dễ bị che view khi khu vực xây thêm công trình.</li>
<li>Pháp lý: hợp đồng mua bán, tiến độ cấp sổ, thời hạn sở hữu.</li>
<li>Chi phí vận hành: phí quản lý, gửi xe, bảo trì.</li>
</ul>

<p>Xem thêm các dự án cùng khu tại <a href="/khu-vuc/son-tra/">bất động sản Sơn Trà</a> hoặc danh sách <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được so sánh căn cụ thể theo ngân sách và nhận danh sách căn ven sông Hàn đang giao dịch.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ ven sông Hàn: Sun Symphony, Sun Ponte, Peninsula',
			'desc'      => 'So sánh căn hộ ven sông Hàn Sun Symphony, Sun Ponte, Peninsula: quy mô, giá chuyển nhượng, giá thuê, bàn giao. Gọi Hoàng Hiệp để chọn căn.',
			'points'    => array(
				'Sun Symphony: 8 ha, 1.313 căn, tiện ích nội khu lớn nhất, ≈ 69 – 125 triệu/m²',
				'Sun Ponte: sát cầu Rồng, 495 căn, giá thuê 2PN khoảng 32 – 40 triệu/tháng',
				'Peninsula: khoảng 941 căn, ≈ 50 – 83 triệu/m², hoàn thành dự kiến Quý 4/2026',
				'Chọn theo mục đích: ở lâu dài, cho thuê hay chờ tăng giá',
			),
			'faq'       => array(
				array( 'Căn hộ ven sông Hàn nào giá mềm nhất trong ba dự án?', 'Peninsula Đà Nẵng có mặt bằng chuyển nhượng tham khảo khoảng 50 – 83 triệu/m², thấp hơn Sun Symphony và Sun Ponte.' ),
				array( 'Dự án nào cho thuê tốt nhất?', 'Tin rao cho thấy Sun Ponte có giá thuê 2PN cao nhất (khoảng 32 – 40 triệu/tháng) nhờ vị trí sát cầu Rồng; lợi suất còn phụ thuộc giá mua vào.' ),
				array( 'Sun Symphony và Sun Ponte khác nhau thế nào?', 'Sun Symphony là tổ hợp 8 ha, 3 tòa, 1.313 căn với nhiều tiện ích; Sun Ponte là 1 tòa 26 tầng, 495 căn, vị trí sát cầu Rồng.' ),
				array( 'Peninsula Đà Nẵng khi nào hoàn thành?', 'Theo kế hoạch công bố, dự án hoàn thành dự kiến Quý 4/2026.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-symphony-residence',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-ponte-residence-da-nang',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-peninsula-da-nang',
			'https://cafeland.vn/du-an/du-an-can-ho-peninsula-da-nang-4522.html',
		),
	);

	/* ===================== TUẦN 8 ===================== */
	$posts[] = array(
		'slug'     => 'masteri-da-nang-gia-tien-do-ban-giao',
		'title'    => 'Masteri Đà Nẵng: giá bán và tiến độ bàn giao mới nhất',
		'excerpt'  => 'Masteri Đà Nẵng (Masteri Rivera Danang) có giá tham khảo từ khoảng 4,13 tỷ, đã cất nóc 12/2025, bàn giao theo kế hoạch Quý III – IV/2026.',
		'keyword'  => 'Masteri Đà Nẵng',
		'project'  => 'masteri-da-nang',
		'week'     => 8,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Masteri Đà Nẵng</strong> (tên chính thức Masteri Rivera Danang) là dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng, gồm 2 tháp 39 tầng với gần 1.200 căn trên đường Quy Mỹ, Hải Châu. Giá tham khảo từ khoảng 4,13 tỷ cho căn 1PN+; dự án đã cất nóc tháng 12/2025 và bàn giao theo kế hoạch Quý III/2026 (một số nguồn ghi Quý IV/2026). Thông tin cập nhật tháng 10/2026.</p>

<h2>Tổng quan Masteri Đà Nẵng</h2>
<p>Dự án rộng khoảng 18.296 m², vốn đầu tư hơn 3.300 tỷ đồng, nằm ở vị trí ba mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch, khu Hòa Cường Nam. Tổng thầu là Central (Centralcons).</p>
<p>Hai tháp 39 tầng đặt trên khối đế thương mại tầng 1 – 3 với trung tâm thương mại khoảng 2.500 m²; tầng 4 là hồ bơi resort, vườn dạo bộ và sân chơi trẻ em. Tổng cộng có 31 tiện ích nội khu.</p>
<p>Về số căn, nguồn chủ đầu tư nêu gần 1.200 căn, một số nguồn ghi 1.112 căn đủ điều kiện bán – con số cụ thể nên đối chiếu khi ký hợp đồng.</p>

<h2>Bảng giá Masteri Đà Nẵng tham khảo</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích tham khảo</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Căn 1PN+</td><td>Khoảng 47,4 m²</td><td>Khoảng 4,13 – 4,51 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>Khoảng 66,9 – 68,3 m²</td><td>Khoảng 5,14 – 6,3 tỷ</td></tr>
<tr><td>Căn 2PN+</td><td>–</td><td>Khoảng 5,9 – 6,65 tỷ</td></tr>
<tr><td>Căn 3PN</td><td>–</td><td>Khoảng 6,68 – 8,11 tỷ</td></tr>
<tr><td>Dual Key</td><td>–</td><td>Khoảng 9,43 – 10,34 tỷ</td></tr>
</tbody>
</table>
<p>Đơn giá được các nguồn ghi khoảng 70 – 94 triệu/m², tùy tầng và hướng. Trên thị trường thứ cấp đã xuất hiện tin rao chuyển nhượng hợp đồng mua bán, ví dụ căn 2PN khoảng 4,9 tỷ với mức chênh khoảng 300 triệu (tham khảo theo tin rao).</p>
<h3>Giá thuê dự kiến khi bàn giao</h3>
<p>Mặt bằng thuê ước tính khu vực: căn 1PN+ khoảng 18 – 25 triệu/tháng, 2PN khoảng 20 – 25 triệu/tháng. Đây là ước tính khu vực, giá thực tế phụ thuộc nội thất và thời điểm đưa căn ra thị trường.</p>

<h2>Tiến độ bàn giao Masteri Đà Nẵng</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Mốc tiến độ</th></tr></thead>
<tbody>
<tr><td>21/11/2024</td><td>Đủ điều kiện bán nhà ở hình thành trong tương lai (theo trang phân phối)</td></tr>
<tr><td>20/5/2025</td><td>Ra mắt dự án</td></tr>
<tr><td>12/2025</td><td>Cất nóc 2 tòa tháp</td></tr>
<tr><td>Quý III – IV/2026</td><td>Bàn giao theo kế hoạch (các nguồn ghi khác nhau)</td></tr>
</tbody>
</table>
<p>Căn hộ bàn giao hoàn thiện sàn, trần, tường và nội thất cơ bản. Vì các nguồn ghi mốc bàn giao khác nhau, khách đã ký hợp đồng nên theo dõi thông báo bàn giao chính thức từ chủ đầu tư; khách mới nên hỏi rõ thời điểm nhận nhà của từng tòa.</p>

<h2>Pháp lý và thời hạn sở hữu</h2>
<p>Dự án đã có văn bản đủ điều kiện bán nhà ở hình thành trong tương lai của Sở Xây dựng Đà Nẵng. Người Việt Nam sở hữu lâu dài, người nước ngoài sở hữu 50 năm theo quy định.</p>
<p>Các ngân hàng liên kết được giới thiệu hỗ trợ vay khoảng 50 – 70% giá trị căn, có thời gian ân hạn gốc lãi theo từng đợt chính sách. Điều kiện vay cụ thể cần xác nhận với ngân hàng tại thời điểm ký.</p>

<h2>Vị trí và kết nối</h2>
<p>Masteri Đà Nẵng nằm gần sông Hàn, Lotte Mart và Asia Park (Sun World Đà Nẵng Wonders), cách cầu Rồng và sân bay khoảng 10 phút. Theo chủ đầu tư, phần lớn căn hộ có hướng nhìn về sông Hàn.</p>
<p>Cùng khu Hòa Cường Nam còn có <a href="/du-an/the-meridian-da-nang/">The Meridian Đà Nẵng</a> và <a href="/du-an/vista-residence-da-nang/">Vista Residence</a>, nên bạn có thể so sánh trực tiếp các lựa chọn. Xem bài phân tích <a href="/the-meridian-da-nang-co-nen-mua/">The Meridian Đà Nẵng có nên mua</a>.</p>

<h2>Masteri Đà Nẵng phù hợp với ai?</h2>
<ul>
<li>Người mua để ở muốn căn hộ thương hiệu quốc tế, gần trung tâm Hải Châu, sắp nhận nhà.</li>
<li>Nhà đầu tư cho thuê chuyên gia, nhân sự văn phòng khu trung tâm.</li>
<li>Khách nước ngoài đủ điều kiện mua căn hộ tại Việt Nam (thời hạn 50 năm).</li>
</ul>

<p>Xem thêm tại trang <a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a> và các dự án <a href="/khu-vuc/hai-chau/">khu Hải Châu</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Masteri Đà Nẵng, căn chuyển nhượng và cập nhật lịch bàn giao mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Masteri Đà Nẵng: giá bán, tiến độ bàn giao 2026',
			'desc'      => 'Masteri Đà Nẵng (Masteri Rivera Danang): 2 tháp 39 tầng, giá từ khoảng 4,13 tỷ, cất nóc 12/2025, bàn giao Quý III – IV/2026. Nhận bảng giá.',
			'points'    => array(
				'Dự án đầu tiên của Masterise Homes tại Đà Nẵng, 2 tháp 39 tầng, gần 1.200 căn',
				'Giá tham khảo: 1PN+ khoảng 4,13 – 4,51 tỷ, 2PN khoảng 5,14 – 6,3 tỷ',
				'Cất nóc 12/2025, bàn giao kế hoạch Quý III/2026 (có nguồn ghi Quý IV/2026)',
				'Sở hữu lâu dài cho người Việt, 50 năm cho người nước ngoài',
			),
			'faq'       => array(
				array( 'Masteri Đà Nẵng giá bao nhiêu?', 'Tham khảo từ khoảng 4,13 tỷ cho căn 1PN+, 2PN khoảng 5,14 – 6,3 tỷ, 3PN khoảng 6,68 – 8,11 tỷ, đơn giá khoảng 70 – 94 triệu/m².' ),
				array( 'Masteri Đà Nẵng khi nào bàn giao?', 'Kế hoạch được công bố là Quý III/2026, một số nguồn ghi Quý IV/2026; cần theo dõi thông báo chính thức của chủ đầu tư.' ),
				array( 'Masteri Đà Nẵng nằm ở đâu?', 'Số 50 Quy Mỹ, ba mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch, khu Hòa Cường Nam, Hải Châu.' ),
				array( 'Người nước ngoài có mua được Masteri Đà Nẵng không?', 'Có, theo quy định người nước ngoài được sở hữu 50 năm; người Việt Nam sở hữu lâu dài.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/masterise-homes-ra-mat-du-an-can-ho-dau-tien-tai-da-nang-4888365.html',
			'https://cafef.vn/masterise-homes-chinh-thuc-cat-noc-du-an-masteri-rivera-danang-188251202103820178.chn',
			'https://cafeland.vn/du-an/masteri-rivera-danang-du-an-can-ho-tai-da-nang-4518.html',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-masteri-rivera-danang',
		),
	);

	$posts[] = array(
		'slug'     => 'the-meridian-da-nang-co-nen-mua',
		'title'    => 'The Meridian Đà Nẵng: có nên mua? Ưu điểm, giá và rủi ro',
		'excerpt'  => 'The Meridian Đà Nẵng có 518 căn ven sông Hàn, giá khoảng 70 – 95 triệu/m², bàn giao dự kiến 2027. Phân tích ưu điểm, rủi ro và ai nên mua.',
		'keyword'  => 'The Meridian Đà Nẵng',
		'project'  => 'the-meridian-da-nang',
		'week'     => 8,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>The Meridian Đà Nẵng</strong> đáng cân nhắc nếu bạn muốn căn hộ sở hữu lâu dài ven sông Hàn, hướng về khu bắn pháo hoa DIFF, và chấp nhận chờ bàn giao dự kiến năm 2027. Dự án có 2 tháp 25 tầng, 518 căn, giá chào bán tham khảo khoảng 70 – 95 triệu/m², căn nhỏ từ khoảng 2,9 tỷ. Phân tích dưới đây cập nhật tháng 10/2026.</p>

<h2>The Meridian Đà Nẵng là dự án gì?</h2>
<p>The Meridian là phân khu cao tầng giai đoạn 2 của khu đô thị Elysia Complex City, tên pháp lý Elysia Complex Riverside, trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu). Chủ đầu tư là Công ty CP Đầu tư Landcom.</p>
<p>Dự án rộng khoảng 7.008 m², gồm hai tháp đối xứng T1, T2 cao 25 tầng, 2 tầng hầm, mỗi tầng điển hình 10 – 12 căn, hành lang rộng 1,8 m và 14 thang máy. Kiến trúc lấy cảm hứng từ siêu du thuyền.</p>

<h2>Giá The Meridian Đà Nẵng tham khảo</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Studio / 1PN</td><td>42 – 60,98 m²</td><td>Khoảng 2,9 – 4,2 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>72,55 – 79,08 m²</td><td>Khoảng 5,1 – 6,3 tỷ</td></tr>
<tr><td>Căn 3PN</td><td>121,08 – 139,6 m²</td><td>Khoảng 8,5 – 11,2 tỷ</td></tr>
<tr><td>Penthouse</td><td>Đến khoảng 198 m²</td><td>Khoảng 14 – 17,8 tỷ</td></tr>
<tr><td>Shophouse khối đế</td><td>–</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Chính sách được công bố (tham khảo): thanh toán 30% khi ký hợp đồng, sau đó 1%/tháng trong 24 tháng không lãi; chiết khấu đến 10% khi thanh toán sớm; ngân hàng SHB hỗ trợ vay đến 70%, lãi suất 0% năm đầu. Chính sách có thể thay đổi theo từng đợt.</p>

<h2>Ưu điểm của The Meridian</h2>
<h3>Vị trí ven sông Hàn, hướng pháo hoa</h3>
<p>Ban công nhiều căn nhìn trực diện khu bắn pháo hoa quốc tế Đà Nẵng. Từ dự án đi Lotte Mart, Asia Park chỉ vài phút; cầu Rồng và sân bay khoảng 10 phút.</p>
<h3>Mật độ căn vừa phải</h3>
<p>518 căn cho 2 tháp, 10 – 12 căn/tầng là mức tương đối thoáng so với nhiều dự án cao tầng. Hơn 30 tiện ích nội khu, trong đó có hồ bơi vô cực nhìn sông, gym, spa.</p>
<h3>Lịch thanh toán giãn</h3>
<p>Với mức 1%/tháng trong 24 tháng, người mua có thể chia nhỏ dòng tiền trong thời gian xây dựng thay vì đóng theo đợt lớn.</p>

<h2>Rủi ro và điểm cần cân nhắc</h2>
<ul>
<li><strong>Tiến độ:</strong> tháng 4/2026 dự án thi công tầng hầm B2; cất nóc dự kiến cuối 2026 (các nguồn ghi Quý III hoặc Quý IV/2026), bàn giao dự kiến năm 2027 (Quý II hoặc Quý IV/2027). Thời gian chờ còn khá dài.</li>
<li><strong>Thông số chưa thống nhất:</strong> mật độ xây dựng có nguồn ghi khoảng 33,6%, có nguồn ghi 45 – 50%. Nên đối chiếu hồ sơ quy hoạch.</li>
<li><strong>Cạnh tranh nguồn cung:</strong> cùng khu có Masteri Rivera Danang sắp bàn giao, người mua nên so sánh giá trên cùng điều kiện.</li>
<li><strong>Chi phí vốn:</strong> ưu đãi lãi suất thường chỉ trong thời gian đầu; hãy tính khả năng trả nợ khi lãi suất thả nổi.</li>
</ul>

<h2>Vậy có nên mua The Meridian Đà Nẵng?</h2>
<p>Nên cân nhắc nếu bạn mua để ở lâu dài hoặc tích lũy tài sản, có dòng tiền ổn định để theo lịch thanh toán giãn, và ưu tiên view sông Hàn – pháo hoa. Căn Studio/1PN phù hợp vốn khoảng 3 – 4 tỷ, căn 2PN cho gia đình nhỏ.</p>
<h3>Mẹo chọn căn tại The Meridian</h3>
<p>Ưu tiên căn có ban công hướng sông Hàn và khu pháo hoa, tầng trung trở lên để hạn chế bị che view. Với căn 3PN diện tích 121 – 139,6 m², hãy so tổng giá với căn cùng loại ở dự án đã bàn giao để thấy rõ khoản chênh mình đang trả cho vị trí và thời gian chờ.</p>
<p>Trước khi đặt cọc, kiểm tra văn bản đủ điều kiện kinh doanh, bảo lãnh ngân hàng cho nghĩa vụ bàn giao và điều khoản phạt chậm tiến độ trong hợp đồng.</p>
<p>Chưa nên vội nếu bạn cần nhà ở ngay hoặc kỳ vọng lướt sóng ngắn hạn. Trường hợp cần nhận nhà sớm, bài <a href="/masteri-da-nang-gia-tien-do-ban-giao/">Masteri Đà Nẵng: giá và tiến độ bàn giao</a> có thể hữu ích để so sánh.</p>

<p>Xem trang dự án <a href="/du-an/the-meridian-da-nang/">The Meridian Đà Nẵng</a>, danh sách <a href="/khu-vuc/hai-chau/">dự án Hải Châu</a> và nhóm <a href="/san-pham/penthouse/">penthouse Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá The Meridian, mặt bằng tầng và tư vấn chọn căn theo view.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'The Meridian Đà Nẵng: có nên mua? Giá và rủi ro',
			'desc'      => 'The Meridian Đà Nẵng: 518 căn ven sông Hàn, giá khoảng 70 – 95 triệu/m², bàn giao dự kiến 2027. Xem ưu điểm, rủi ro và nhận tư vấn chọn căn.',
			'points'    => array(
				'2 tháp 25 tầng, 518 căn studio – 3PN và penthouse, sở hữu lâu dài',
				'Giá tham khảo khoảng 70 – 95 triệu/m², căn nhỏ từ khoảng 2,9 tỷ',
				'Thanh toán 30% rồi 1%/tháng trong 24 tháng (chính sách tham khảo)',
				'Bàn giao dự kiến 2027 – phù hợp người mua để ở dài hạn, không lướt sóng',
			),
			'faq'       => array(
				array( 'The Meridian Đà Nẵng giá bao nhiêu?', 'Khoảng 70 – 95 triệu/m² (tham khảo): Studio/1PN khoảng 2,9 – 4,2 tỷ, 2PN khoảng 5,1 – 6,3 tỷ, 3PN khoảng 8,5 – 11,2 tỷ.' ),
				array( 'Khi nào The Meridian bàn giao?', 'Dự kiến năm 2027; các nguồn ghi Quý II hoặc Quý IV/2027.' ),
				array( 'The Meridian Đà Nẵng của chủ đầu tư nào?', 'Công ty CP Đầu tư Landcom; dự án là phân khu cao tầng của khu đô thị Elysia Complex City.' ),
				array( 'Có nên mua The Meridian để lướt sóng?', 'Không phù hợp lắm vì thời gian chờ bàn giao còn dài; dự án hợp hơn với người mua để ở hoặc tích lũy dài hạn.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/the-meridian-ra-mat-tai-da-nang-sieu-du-thuyen-kien-truc-chinh-thuc-ha-thuy-song-han-185260112084502674.htm',
			'https://congthuong.vn/the-meridian-da-nang-chinh-thuc-ra-mat-can-ho-mau-cu-hich-cho-thi-truong-bat-dong-san-437945.html',
			'https://cafeland.vn/du-an/the-meridian-da-nang-phan-khu-can-ho-thuoc-elysia-complex-5345.html',
			'https://the-meridian.com.vn/bang-gia-the-meridian-da-nang/',
		),
	);

	$posts[] = array(
		'slug'     => 'nobu-da-nang-can-ho-hang-hieu',
		'title'    => 'Nobu Đà Nẵng: căn hộ hàng hiệu ven biển Mỹ Khê có gì đặc biệt',
		'excerpt'  => 'Nobu Đà Nẵng là tháp 43 tầng với 264 căn hộ hàng hiệu Nobu và 186 phòng khách sạn bên biển Mỹ Khê, giá tham khảo khoảng 145 – 205 triệu/m².',
		'keyword'  => 'Nobu Đà Nẵng',
		'project'  => 'nobu-da-nang',
		'week'     => 8,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Nobu Đà Nẵng</strong> (Nobu Residences Danang) là tháp 43 tầng cao khoảng 186 m tại góc Võ Văn Kiệt – Võ Nguyên Giáp, gồm 264 căn hộ hàng hiệu và 186 phòng khách sạn do Nobu Hospitality vận hành. Giá chào bán tham khảo khoảng 145 – 205 triệu/m²; căn 1PN khoảng 6,6 – 9,1 tỷ. Đây là dự án Nobu Residences đầu tiên tại Đông Nam Á – thông tin cập nhật tháng 10/2026.</p>

<h2>Căn hộ hàng hiệu là gì và vì sao Nobu được chú ý?</h2>
<p>Căn hộ hàng hiệu (branded residences) là căn hộ gắn với một thương hiệu khách sạn hoặc phong cách sống, được vận hành theo tiêu chuẩn của thương hiệu đó. Người mua trả thêm cho dịch vụ, chất lượng hoàn thiện và giá trị nhận diện.</p>
<p>Nobu Hospitality do diễn viên Robert De Niro, đầu bếp Nobu Matsuhisa và Meir Teper sáng lập. Tại Đà Nẵng, VCRE (Viet Capital Real Estate) phát triển dự án, Newtecons thi công.</p>

<h2>Thông số Nobu Đà Nẵng</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>01 Võ Văn Kiệt (góc Võ Nguyên Giáp), Sơn Trà – mặt biển Mỹ Khê</td></tr>
<tr><td>Quy mô</td><td>Khoảng 3.000 m² đất, 43 tầng nổi, 2 tầng hầm</td></tr>
<tr><td>Sản phẩm</td><td>264 căn hộ hàng hiệu, 186 phòng khách sạn Nobu</td></tr>
<tr><td>Studio</td><td>Khoảng 42 – 43 m² – liên hệ</td></tr>
<tr><td>Căn 1PN</td><td>Khoảng 62,5 – 71,1 m² – khoảng 6,63 – 9,06 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>Khoảng 99,7 – 118,7 m² – liên hệ</td></tr>
<tr><td>Căn 3PN Dual Key</td><td>Khoảng 130,1 – 166,2 m² – liên hệ</td></tr>
<tr><td>Sky Villa, penthouse</td><td>6 Sky Villa hồ bơi riêng (khoảng 254 – 288 m²), 2 penthouse (khoảng 372 m²)</td></tr>
</tbody>
</table>

<h2>Điểm đặc biệt của Nobu Đà Nẵng</h2>
<h3>Thiết kế lấy cảm hứng Nhật Bản</h3>
<p>Kiến trúc mô phỏng quạt giấy Nhật Bản (Sensu) và nguyên lý mượn cảnh (Shakkei), nội thất phong cách Japandi tối giản. Căn hộ được bàn giao hoàn thiện nội thất theo tiêu chuẩn Nobu.</p>
<h3>Tiện ích của thương hiệu</h3>
<p>Nhà hàng Nobu đặt tại tầng 42, hồ bơi vô cực nước ấm tại tầng 18, cùng spa, gym và dịch vụ quản lý căn hộ theo tiêu chuẩn Nobu Hospitality.</p>
<h3>Số lượng căn giới hạn</h3>
<p>Chỉ 264 căn hộ cho cả tòa, trong đó nhóm Sky Villa và penthouse rất ít. Đây là yếu tố khan hiếm mà người mua dòng hàng hiệu thường quan tâm.</p>

<h2>Tiến độ và pháp lý</h2>
<p>Dự án khởi công Quý 2/2024. Theo cập nhật của chủ đầu tư tháng 5/2026, công trình đã đổ bê tông sàn tầng 8 và lắp hệ leo tầng 9. Về thời điểm hoàn thành, các nguồn ghi từ cuối năm 2026 đến năm 2027 – nên đối chiếu tiến độ thực tế khi xem dự án.</p>
<p>Về thời hạn sở hữu, các nguồn chưa thống nhất: trang phân phối ghi sở hữu lâu dài cho người Việt Nam và 50 năm cho người nước ngoài, nguồn khác ghi thời hạn đến năm 2060 theo đất thương mại dịch vụ. Người mua cần đọc kỹ hợp đồng mua bán trước khi ký.</p>

<h2>Có nên mua Nobu Đà Nẵng để cho thuê?</h2>
<p>Căn hộ có thể tham gia chương trình cho thuê do Nobu Hospitality vận hành. Một số nguồn phân phối nêu mức cam kết lợi nhuận khoảng 6%/năm, nhưng điều kiện cụ thể phải kiểm tra theo hợp đồng.</p>
<ul>
<li>Phù hợp: người mua tài sản hàng hiệu để giữ giá trị lâu dài, nghỉ dưỡng kết hợp cho thuê.</li>
<li>Cần cân nhắc: đơn giá cao hơn nhiều so với mặt bằng căn hộ Đà Nẵng, phí dịch vụ cao, thanh khoản thứ cấp hẹp hơn căn hộ phổ thông.</li>
</ul>
<h3>Những câu hỏi nên đặt ra trước khi ký</h3>
<ul>
<li>Căn hộ được tự ở, cho thuê tự do hay bắt buộc tham gia chương trình cho thuê của nhà vận hành?</li>
<li>Phí dịch vụ hàng năm, tỷ lệ chia doanh thu và chi phí bảo trì nội thất do ai chịu?</li>
<li>Khi bán lại, người mua sau có được hưởng nguyên quyền lợi thương hiệu và dịch vụ không?</li>
<li>Thời hạn sở hữu ghi trong hợp đồng là lâu dài hay có thời hạn?</li>
</ul>
<p>Nếu ngân sách thấp hơn, bạn có thể tham khảo các dự án ven sông Hàn trong bài <a href="/so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula/">so sánh căn hộ ven sông Hàn</a>.</p>

<p>Xem trang dự án <a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a>, nhóm <a href="/san-pham/penthouse/">penthouse Đà Nẵng</a> và các dự án <a href="/khu-vuc/son-tra/">khu Sơn Trà</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Nobu Đà Nẵng, mặt bằng căn và chính sách cho thuê đang áp dụng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nobu Đà Nẵng: căn hộ hàng hiệu ven biển Mỹ Khê',
			'desc'      => 'Nobu Đà Nẵng: tháp 43 tầng, 264 căn hộ hàng hiệu và 186 phòng khách sạn bên biển Mỹ Khê, khoảng 145 – 205 triệu/m². Gọi Hoàng Hiệp nhận giá.',
			'points'    => array(
				'Dự án Nobu Residences đầu tiên tại Đông Nam Á, do VCRE phát triển',
				'Tháp 43 tầng: 264 căn hộ, 186 phòng khách sạn, 6 Sky Villa, 2 penthouse',
				'Giá tham khảo khoảng 145 – 205 triệu/m², căn 1PN khoảng 6,6 – 9,1 tỷ',
				'Thời hạn sở hữu các nguồn chưa thống nhất – cần đối chiếu hợp đồng',
			),
			'faq'       => array(
				array( 'Nobu Đà Nẵng ở đâu?', 'Số 01 Võ Văn Kiệt, góc Võ Nguyên Giáp, Sơn Trà, mặt tiền biển Mỹ Khê.' ),
				array( 'Giá căn hộ Nobu Đà Nẵng bao nhiêu?', 'Tham khảo khoảng 145 – 205 triệu/m²; căn 1PN khoảng 6,63 – 9,06 tỷ. Các căn lớn, Sky Villa, penthouse liên hệ.' ),
				array( 'Nobu Đà Nẵng sở hữu bao lâu?', 'Các nguồn chưa thống nhất: có nguồn ghi sở hữu lâu dài cho người Việt, nguồn khác ghi đến năm 2060 theo đất thương mại dịch vụ. Cần đọc hợp đồng mua bán.' ),
				array( 'Khi nào Nobu Đà Nẵng hoàn thành?', 'Tháng 5/2026 công trình thi công tới tầng 8 – 9; các nguồn ghi hoàn thành từ cuối 2026 đến năm 2027.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/huyen-thoai-hollywood-dua-thuong-hieu-nobu-den-da-nang-4761311.html',
			'https://cafeland.vn/du-an/to-hop-can-ho-khach-san-nobu-residences-da-nang-4356.html',
			'https://nobudanang.vn/constructions/cap-nhat-tien-do-xay-dung-thang-05-2026/',
			'https://newtecons.vn/newtecons-va-vcre-hop-tac-chien-luoc-kien-tao-sieu-pham-nobu-da-nang/',
		),
	);

	$posts[] = array(
		'slug'     => 'danang-landmark-can-ho-canh-cau-rong',
		'title'    => 'Danang Landmark: căn hộ cạnh cầu Rồng, giá và pháp lý 2026',
		'excerpt'  => 'Danang Landmark là tháp đôi Dragon – Phoenix với 454 căn cạnh công viên APEC, cầu Rồng; đủ điều kiện kinh doanh từ 3/2026, giá khoảng 94 – 130 triệu/m².',
		'keyword'  => 'Danang Landmark',
		'project'  => 'danang-landmark',
		'week'     => 8,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Danang Landmark</strong> (Đà Nẵng Landmark Tower) là tháp đôi căn hộ trên đường Bạch Đằng nối dài, đối diện công viên APEC và cách cầu Rồng chưa đến 100 m. Dự án gồm 454 căn sở hữu lâu dài, được Sở Xây dựng Đà Nẵng xác nhận đủ điều kiện kinh doanh ngày 03/3/2026; giá chào bán tham khảo khoảng 94 – 130 triệu/m², căn 2PN từ khoảng 5,95 tỷ. Cập nhật tháng 10/2026.</p>

<h2>Vị trí Danang Landmark: sát cầu Rồng, mặt sông Hàn</h2>
<p>Dự án có ba mặt tiền Bạch Đằng – Bình Minh 4 – Trần Văn Trứ, nằm trên đoạn giữa cầu Rồng và cầu Trần Thị Lý, bờ Tây sông Hàn. Đây là khu vực tổ chức pháo hoa quốc tế và các sự kiện lớn của thành phố.</p>
<p>Từ dự án đến công viên APEC khoảng 1 phút, cầu Rồng khoảng 2 phút, biển Mỹ Khê khoảng 7 phút và sân bay khoảng 10 phút (ước tính theo nguồn công bố). Gần đó còn có <a href="/du-an/m-riverside-da-nang/">M Riverside Đà Nẵng</a> cùng trục ven sông.</p>

<h2>Quy mô tháp đôi Dragon – Phoenix</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Tòa Dragon</th><th>Tòa Phoenix</th></tr></thead>
<tbody>
<tr><td>Số tầng</td><td>39 tầng</td><td>31 tầng</td></tr>
<tr><td>Căn hộ</td><td>Khoảng 249 căn + duplex tầng 38 – 39</td><td>Khoảng 197 căn + 2 penthouse tầng 31</td></tr>
<tr><td>Sản phẩm đặc biệt</td><td>Duplex khoảng 248,5 – 390,5 m² (3 căn/tầng)</td><td>Penthouse view sông Hàn, công viên APEC</td></tr>
</tbody>
</table>
<p>Tổng cộng 454 căn (446 căn hộ ở và 8 căn hộ kết hợp kinh doanh ở khối đế), chung 2 tầng hầm. Dự án rộng khoảng 3.765 m², tổng vốn khoảng 1.600 tỷ đồng, do Cosmos Housing làm chủ đầu tư, DIN Capital hợp tác đầu tư, DINCO thi công.</p>

<h2>Giá Danang Landmark tham khảo</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Căn 2PN view sông Hàn, cầu Rồng</td><td>Khoảng 61 – 68 m²</td><td>Khoảng 5,95 – 6,7 tỷ</td></tr>
<tr><td>Căn 2PN diện tích lớn</td><td>Khoảng 70 – 229 m²</td><td>Liên hệ</td></tr>
<tr><td>Căn 3PN</td><td>Khoảng 167 m²</td><td>Liên hệ</td></tr>
<tr><td>Penthouse, duplex</td><td>Đến khoảng 390,5 m²</td><td>Liên hệ</td></tr>
<tr><td>Căn hộ kết hợp kinh doanh</td><td>8 căn, tổng khoảng 751,58 m² sàn</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Mặt bằng giá được các nguồn ghi khoảng 94 – 130 triệu/m², có trang phân phối nêu khoảng 110 triệu/m², tùy tầng và hướng view. Giá chính thức theo bảng giá chủ đầu tư từng đợt.</p>

<h2>Pháp lý Danang Landmark</h2>
<h3>Đủ điều kiện kinh doanh</h3>
<p>Ngày 23/2/2026, chủ đầu tư hoàn thành nghĩa vụ tài chính về đất. Ngày 03/3/2026, Sở Xây dựng Đà Nẵng xác nhận nhà ở hình thành trong tương lai tại dự án đủ điều kiện đưa vào kinh doanh với 454 căn.</p>
<h3>Sở hữu và người nước ngoài</h3>
<p>Người Việt Nam sở hữu lâu dài. Dự án nằm trong danh sách được bán cho người nước ngoài theo công bố của thành phố.</p>
<h3>Thanh toán theo luật</h3>
<p>Theo Luật Kinh doanh bất động sản 2023: đặt cọc không quá 5% giá bán, thanh toán lần đầu không quá 30% giá trị hợp đồng (gồm tiền cọc), tổng thanh toán trước bàn giao không quá 70%. Chủ đầu tư phải giải chấp trước khi ký hợp đồng mua bán – người mua nên yêu cầu xem văn bản này.</p>

<h2>Tiến độ xây dựng</h2>
<p>Dự án được cấp chủ trương đầu tư tháng 9/2022, khởi công ngày 14/9/2024 và dự kiến bàn giao khoảng giữa năm 2027. Tòa nhà được giới thiệu vận hành theo tiêu chuẩn Nhật Bản, với trung tâm thương mại khối đế, hồ bơi vô cực, sky bar, gym & spa, phòng tập golf, nhà trẻ và bãi đỗ xe thông minh.</p>

<h2>Danang Landmark phù hợp với ai?</h2>
<ul>
<li>Người mua muốn căn hộ sở hữu lâu dài ngay trung tâm bờ Tây sông Hàn, sát cầu Rồng.</li>
<li>Nhà đầu tư cho thuê khách du lịch, chuyên gia nhờ vị trí khu sự kiện và pháo hoa.</li>
<li>Khách nước ngoài cần dự án đã có trong danh sách được bán cho người nước ngoài.</li>
</ul>
<p>Điểm cần cân nhắc: đơn giá thuộc nhóm cao của thị trường, và dự án còn trong giai đoạn xây dựng. Nếu muốn so sánh với căn hộ bờ Đông sông Hàn, xem bài <a href="/so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula/">so sánh căn hộ ven sông Hàn</a>.</p>

<p>Xem thêm trang dự án <a href="/du-an/danang-landmark/">Danang Landmark</a>, nhóm <a href="/san-pham/duplex/">căn duplex Đà Nẵng</a> và các dự án <a href="/khu-vuc/hai-chau/">khu Hải Châu</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Danang Landmark, danh sách căn view cầu Rồng và chính sách thanh toán mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Danang Landmark: căn hộ cạnh cầu Rồng, giá 2026',
			'desc'      => 'Danang Landmark: tháp đôi 39 và 31 tầng, 454 căn cạnh cầu Rồng, đủ điều kiện kinh doanh 3/2026, khoảng 94 – 130 triệu/m². Liên hệ nhận giá.',
			'points'    => array(
				'Tháp đôi Dragon 39 tầng và Phoenix 31 tầng, 454 căn sở hữu lâu dài',
				'Cách cầu Rồng chưa đến 100 m, đối diện công viên APEC',
				'Đủ điều kiện kinh doanh từ 03/3/2026, được bán cho người nước ngoài',
				'Giá tham khảo khoảng 94 – 130 triệu/m², căn 2PN từ khoảng 5,95 tỷ',
			),
			'faq'       => array(
				array( 'Danang Landmark ở đâu?', 'Đường Bạch Đằng nối dài (giáp Bình Minh 4, Trần Văn Trứ), cạnh công viên APEC, cách cầu Rồng chưa đến 100 m.' ),
				array( 'Danang Landmark đủ điều kiện bán chưa?', 'Có. Ngày 03/3/2026 Sở Xây dựng Đà Nẵng xác nhận 454 căn nhà ở hình thành trong tương lai đủ điều kiện kinh doanh.' ),
				array( 'Giá Danang Landmark bao nhiêu?', 'Khoảng 94 – 130 triệu/m² (tham khảo); căn 2PN 61 – 68 m² khoảng 5,95 – 6,7 tỷ.' ),
				array( 'Danang Landmark bàn giao khi nào?', 'Dự kiến khoảng giữa năm 2027.' ),
			),
		),
		'sources'  => array(
			'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html',
			'https://tuoitre.vn/nld/da-nang-hai-toa-thap-ben-song-han-duoc-mo-ban-hon-450-can-ho-196260304164928532.htm',
			'https://vietnamfinance.vn/thap-doi-danang-landmark-du-dieu-kien-mo-ban-d141000.html',
			'https://baodautu.vn/da-nang-cong-bo-hai-du-an-bat-dong-san-tiep-theo-duoc-ban-cho-nguoi-nuoc-ngoai-d572248.html',
		),
	);

	$posts[] = array(
		'slug'     => 'm-riverside-da-nang-gia-chinh-sach',
		'title'    => 'M Riverside Đà Nẵng: giá bán và chính sách bán hàng 2026',
		'excerpt'  => 'M Riverside Đà Nẵng có 312 căn ven sông Hàn tại số 6 đường 2/9, giá khoảng 104 – 136 triệu/m², từ khoảng 3,5 tỷ, chiết khấu tới khoảng 26%.',
		'keyword'  => 'M Riverside Đà Nẵng',
		'project'  => 'm-riverside-da-nang',
		'week'     => 8,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>M Riverside Đà Nẵng</strong> là tòa căn hộ dịch vụ thương mại 25 tầng tại số 6 đường 2/9 (Hải Châu), đối diện công viên APEC, gồm 312 căn từ studio đến 2PN. Giá chào bán tham khảo khoảng 104 – 136 triệu/m², từ khoảng 3,5 tỷ/căn; chính sách được công bố gồm chiết khấu tới khoảng 26%, miễn phí quản lý 2 năm và thanh toán tới 15 đợt. Thông tin cập nhật tháng 10/2026.</p>

<h2>Tổng quan M Riverside Đà Nẵng</h2>
<p>Dự án do Kyoritsu Maintenance Việt Nam (Nhật Bản) phát triển, hợp tác cùng CTCP Sao Mai Việt (HNX: UNI); tổng thầu Central, tư vấn quản lý dự án và giám sát Artelia. Khu đất khoảng 1.853 m², ba mặt tiền 2/9 – Bình Hiên – Đào Tấn.</p>
<p>Tòa nhà cao 25 tầng nổi, 3 tầng hầm, theo mô hình Work – Live – Resort: không gian làm việc (co-working, lounge thương gia), căn hộ và tiện ích nghỉ dưỡng như hồ bơi vô cực tầng thượng nhìn sông Hàn, rooftop lounge, gym, sauna, yoga, nhà hàng.</p>

<h2>Bảng giá M Riverside Đà Nẵng tham khảo</h2>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Diện tích</th><th>Đơn giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>89</td><td>31,9 – 45,7 m²</td><td>Khoảng 117 triệu/m²</td></tr>
<tr><td>Căn 1PN</td><td>129</td><td>35,5 – 69,6 m²</td><td>Khoảng 126 triệu/m²</td></tr>
<tr><td>Căn 2PN</td><td>89</td><td>76,8 – 99,3 m²</td><td>Khoảng 128 triệu/m²</td></tr>
<tr><td>Căn đặc biệt</td><td>5</td><td>–</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Mức giá dao động khoảng 104 – 136 triệu/m² tùy hướng nhìn thành phố, sông Hàn hay trực diện sông – biển; giá trên là trước chiết khấu theo các nguồn công bố. Căn studio là lựa chọn vốn thấp nhất, từ khoảng 3,5 tỷ.</p>

<h2>Chính sách bán hàng M Riverside</h2>
<ul>
<li>Chiết khấu tới khoảng 26% (tùy phương án thanh toán).</li>
<li>Miễn phí quản lý 2 năm.</li>
<li>Thanh toán linh hoạt tới 15 đợt theo tiến độ; thanh toán sớm hưởng chiết khấu cao hơn.</li>
<li>Ngân hàng hỗ trợ vay tới khoảng 70% giá trị căn, lãi suất ưu đãi giai đoạn đầu.</li>
</ul>
<h3>Ví dụ cách tính giá sau chiết khấu</h3>
<p>Giả sử một căn studio có giá niêm yết khoảng 4 tỷ. Nếu đủ điều kiện hưởng mức chiết khấu tối đa khoảng 26%, giá còn khoảng 2,96 tỷ trước VAT và phí bảo trì; nếu chọn thanh toán giãn 15 đợt, mức chiết khấu thường thấp hơn. Đây chỉ là ví dụ minh họa cách tính, không phải bảng giá thực tế của một căn cụ thể.</p>
<p>Chính sách áp dụng theo từng thời điểm. Khi so sánh, hãy quy về giá sau chiết khấu, cộng VAT và phí bảo trì, rồi mới đặt cạnh các dự án khác.</p>

<h2>Pháp lý và tiến độ</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Mốc</th></tr></thead>
<tbody>
<tr><td>13/11/2023</td><td>Cấp giấy phép môi trường</td></tr>
<tr><td>14/8/2024</td><td>Cấp giấy phép xây dựng số 18/GPXD</td></tr>
<tr><td>7/2026</td><td>Khai trương nhà mẫu; thi công hoàn thiện phần hầm</td></tr>
<tr><td>21/9/2026</td><td>Ra quân tổng đại lý miền Bắc, triển khai bán hàng</td></tr>
<tr><td>Quý IV/2026</td><td>Dự kiến thi công phần thân</td></tr>
</tbody>
</table>
<p>M Riverside là căn hộ dịch vụ thương mại. Chủ đầu tư công bố đất sử dụng lâu dài và cấp giấy chứng nhận khi đủ điều kiện, nhưng hình thức sở hữu của loại hình này khác căn hộ chung cư để ở. Hiệp khuyên bạn yêu cầu xem văn bản đủ điều kiện kinh doanh và đọc kỹ điều khoản sở hữu trong hợp đồng trước khi ký.</p>

<h2>M Riverside phù hợp với ai?</h2>
<p>Dự án phù hợp nhà đầu tư cho thuê nhắm tới chuyên gia, doanh nhân và cư dân quốc tế làm việc ở trung tâm, đặc biệt trong bối cảnh Đà Nẵng phát triển trung tâm tài chính quốc tế cách dự án khoảng 5 – 10 phút. Chủ đầu tư Nhật Bản có kinh nghiệm vận hành lưu trú là điểm cộng cho mô hình cho thuê.</p>
<p>Người mua để ở lâu dài cho gia đình nên cân nhắc diện tích căn khá nhỏ và tính chất căn hộ dịch vụ. Nếu ưu tiên căn hộ chung cư sở hữu lâu dài cùng khu, có thể xem <a href="/danang-landmark-can-ho-canh-cau-rong/">Danang Landmark cạnh cầu Rồng</a> hoặc <a href="/masteri-da-nang-gia-tien-do-ban-giao/">Masteri Đà Nẵng</a>.</p>

<p>Xem trang dự án <a href="/du-an/m-riverside-da-nang/">M Riverside Đà Nẵng</a> và danh sách <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá M Riverside sau chiết khấu, căn đẹp theo view và tính toán phương án thanh toán phù hợp.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'M Riverside Đà Nẵng: giá bán, chính sách 2026',
			'desc'      => 'M Riverside Đà Nẵng: 312 căn ven sông Hàn, khoảng 104 – 136 triệu/m², từ khoảng 3,5 tỷ, chiết khấu tới khoảng 26%. Gọi Hoàng Hiệp nhận giá.',
			'points'    => array(
				'Tòa 25 tầng, 312 căn studio – 2PN tại số 6 đường 2/9, đối diện công viên APEC',
				'Đơn giá tham khảo khoảng 104 – 136 triệu/m², từ khoảng 3,5 tỷ/căn',
				'Chiết khấu tới khoảng 26%, miễn phí quản lý 2 năm, thanh toán tới 15 đợt',
				'Căn hộ dịch vụ thương mại – cần đọc kỹ điều khoản sở hữu',
			),
			'faq'       => array(
				array( 'M Riverside Đà Nẵng giá bao nhiêu?', 'Khoảng 104 – 136 triệu/m² tùy view (tham khảo): studio khoảng 117, 1PN khoảng 126, 2PN khoảng 128 triệu/m²; từ khoảng 3,5 tỷ/căn.' ),
				array( 'Chính sách bán hàng M Riverside có gì?', 'Theo công bố: chiết khấu tới khoảng 26%, miễn phí quản lý 2 năm, thanh toán tới 15 đợt, ngân hàng hỗ trợ vay tới khoảng 70%. Chính sách thay đổi theo thời điểm.' ),
				array( 'M Riverside là loại hình gì?', 'Căn hộ dịch vụ thương mại theo mô hình Work – Live – Resort; quyền sở hữu cần đối chiếu hợp đồng của chủ đầu tư.' ),
				array( 'Chủ đầu tư M Riverside là ai?', 'Kyoritsu Maintenance Việt Nam hợp tác cùng CTCP Sao Mai Việt (HNX: UNI); tổng thầu Central.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/m-riverside-da-nang-khai-thac-loi-the-ba-mat-tien-trung-tam-thanh-pho-5088719.html',
			'https://cafeland.vn/du-an/m-riverside-danang-du-an-can-ho-tai-da-nang-5737.html',
			'https://cafeland.vn/tin-tuc/m-riverside-danang-chinh-thuc-ra-quan-tai-mien-bac-155225.html',
			'https://znews.vn/le-ra-quan-tong-dai-ly-mien-bac-cua-m-riverside-danang-post1685116.html',
		),
	);

	return $posts;
}
