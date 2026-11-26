<?php
/**
 * Bài vệ tinh lô 2 (theo báo cáo phân tích đối thủ 10/11/2026):
 * giá Cora Tower; chọn tòa nào ở Sun NeO City; bảng giá Capital Square; Hudson Place S4 và Broadway Place S3; căn hộ dưới 3 tỷ Đà Nẵng.
 * Số liệu lấy từ dữ liệu dự án trên web (giỏ hàng, chính sách, tài liệu chủ đầu tư) – không thêm số mới.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_cum_du_an_11_2026_lo_2' );
function hh_posts_cum_du_an_11_2026_lo_2( $posts ) {
	$cora   = '<a href="/du-an/cora-tower/">Cora Tower</a>';
	$cs     = '<a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a>';
	$hudson = '<a href="/du-an/capital-square-hudson-place-s4/">Hudson Place S4</a>';
	$sign   = '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ giỏ hàng và tài liệu chủ đầu tư · cập nhật 10/11/2026. Giá tham khảo, thay đổi theo đợt.</small></p>';
	$cta    = static fn( $name ) => '<p>Cần bảng giá từng căn, mặt bằng tầng và phiếu tính dòng tiền ' . $name . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi giỏ hàng mới nhất và so sánh với các dự án cùng tầm giá.</p>';

	/* ---------------- Cora Tower – Giá ---------------- */
	$posts[] = array(
		'slug'     => 'gia-cora-tower-da-nang-bao-nhieu',
		'title'    => 'Giá Cora Tower Đà Nẵng bao nhiêu? Studio từ 2,42 tỷ, 1PN+ 3,45 – 3,84 tỷ (11/2026)',
		'excerpt'  => 'Giá Cora Tower – Sun NeO City (Hòa Xuân) theo giỏ hàng 11/2026: studio 32,3 m² khoảng 2,42 – 2,74 tỷ, căn 1PN+ 53,2 – 54,2 m² khoảng 3,45 – 3,84 tỷ, shop khối đế 5,17 – 9,12 tỷ. Chiết khấu, vay 70%, nhận nhà 30/07/2027.',
		'keyword'  => 'giá Cora Tower bao nhiêu',
		'keywords_extra' => array( 'giá Cora Tower Đà Nẵng', 'bảng giá Cora Tower', 'Cora Tower Sun NeO City giá' ),
		'project'  => 'cora-tower',
		'schedule' => '2026-11-15 09:00',
		'rev'      => 3, // 26/11: chiết khấu thanh toán sớm tháng 12/2026 (hạn 25/12).
		'category' => 'Thị trường',
		'tags'     => array( 'Cora Tower', 'Sun NeO City', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/gia-cora-tower-sun-neo-city.jpg',
		'image_alt' => 'Giá Cora Tower bao nhiêu – Cora Tower nhìn từ trên cao, giao lộ Nguyễn Phước Lan – đường 29/3, Sun NeO City (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Giá Cora Tower bao nhiêu?</strong> Theo giỏ hàng 11/2026, căn studio 32,3 m² khoảng <strong>2,42 – 2,74 tỷ</strong>; căn 1PN+ 53,2 – 54,2 m² khoảng <strong>3,45 – 3,84 tỷ</strong>; shop khối đế tầng 1 tòa A2 khoảng 5,17 – 9,12 tỷ. Giá đã gồm VAT và phí bảo trì, chưa trừ chiết khấu. Căn hộ sở hữu lâu dài, bàn giao dự kiến 30/07/2027.</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>32,3 m²</td><td>Khoảng 2,42 – 2,74 tỷ</td></tr>
<tr><td>Căn 1PN+</td><td>53,2 – 54,2 m²</td><td>Khoảng 3,45 – 3,84 tỷ</td></tr>
<tr><td>Căn 2PN, 3PN</td><td>–</td><td>Liên hệ</td></tr>
<tr><td>Shop khối đế tầng 1 (tòa A2)</td><td>43,8 – 87,3 m²</td><td>Khoảng 5,17 – 9,12 tỷ</td></tr>
</tbody>
</table>
{$sign}
</div>
<p>{$cora} là cặp tòa căn hộ A1, A2 của Sun Group tại giao lộ Nguyễn Phước Lan – đường 29/3, trung tâm khu đô thị Sun NeO City (Hòa Xuân). Bài này trả lời <strong>giá Cora Tower bao nhiêu</strong> theo giỏ hàng tháng 11/2026 và các khoản ưu đãi được trừ vào giá.</p>
<!--hh-featured-->
<h2>Thông tin nhanh trước khi hỏi giá Cora Tower bao nhiêu</h2>
<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Tập đoàn Sun Group (Sun Property phát triển)</td></tr>
<tr><th>Vị trí</th><td>Giao lộ Nguyễn Phước Lan – đường 29/3, Sun NeO City, Hòa Xuân, Đà Nẵng</td></tr>
<tr><th>Quy mô</th><td>2 tòa A1, A2; mỗi tòa 616 căn hộ điển hình, 28 căn/tầng</td></tr>
<tr><th>Sở hữu</th><td>Lâu dài</td></tr>
<tr><th>Bàn giao</th><td>Dự kiến 30/07/2027, hoàn thiện trần, tường, sàn (chưa gồm nội thất rời)</td></tr>
</tbody>
</table>
<!--hh-dimg:1v4t7lNiDJAClwLbcoTY1637kgnKRUGsC|Phối cảnh hai tòa A1, A2 Cora Tower (ảnh chủ đầu tư)-->
<h2>Giá Cora Tower bao nhiêu: đã gồm gì, được trừ gì</h2>
<ul>
<li><strong>Đã gồm:</strong> VAT và phí bảo trì.</li>
<li><strong>Đặc quyền hoàn thiện nội thất 7%</strong> cho căn hộ tòa A1, A2 (CSƯĐ 06.1 từ 21/8/2026).</li>
<li><strong>Không vay ngân hàng:</strong> chiết khấu thêm 5%.</li>
<li><strong>Thanh toán sớm tháng 12/2026</strong> (hạn 25/12): 95% chiết khấu 7%; 70% chiết khấu 1% (áp dụng cho căn hộ và shop khối đế).</li>
<li>Các khoản chiết khấu tính trên giá chưa VAT và phí bảo trì.</li>
</ul>
<h2>Thanh toán và vay</h2>
<ul>
<li>Đặt cọc căn hộ 100 triệu (3PN 150 triệu, penthouse 300 triệu), giãn tiến độ đến 40 tháng.</li>
<li>Vay tối đa 70%, chủ đầu tư hỗ trợ lãi suất 24 tháng (không muộn hơn 30/9/2028), ân hạn gốc cùng thời gian.</li>
<li>Sun Early Key: thanh toán đủ 70% là nhận nhà sử dụng.</li>
<li>Trả trước hạn từng đợt (từ 10 ngày): hưởng 8%/năm; 5% cuối đóng khi bàn giao, chủ đầu tư trả lãi 8%/năm.</li>
<li>Miễn phí quản lý 1 năm.</li>
</ul>
<!--hh-dimg:1oulS9J32GRh9HDGp4mcH3_OhQejkCP1s|Layout căn Studio Cora Tower (bản vẽ chủ đầu tư)-->
<h2>Shop khối đế</h2>
<p>Với shop, giá Cora Tower bao nhiêu được tính riêng: shop tầng 1 tòa A2 diện tích 43,8 – 87,3 m², giá khoảng 5,17 – 9,12 tỷ. Chính sách shop (CSƯĐ 06 từ 17/8/2026): Early Bird 3% (có thời hạn), hỗ trợ nội thất kinh doanh 4%, đặt cọc 300 triệu; nhận nhà khi thanh toán 70% (dự kiến 31/10/2027).</p>
<h2>Giá Cora Tower bao nhiêu so với các tòa khác ở Sun NeO City</h2>
<p>Cora Tower có giỏ hàng công khai rõ nhất trong ba tòa căn hộ Sun Group ở Hòa Xuân. Spana Tower bàn giao sớm hơn một tháng (dự kiến 30/06/2027), S-Light Tower có chiết khấu thanh toán sớm cao hơn. So sánh chi tiết: <a href="/cora-spana-s-light-sun-neo-city-nen-chon-toa-nao/">Cora, Spana hay S-Light – nên chọn tòa nào</a>.</p>
<h2>Ví dụ: giá Cora Tower bao nhiêu với căn studio 2,42 tỷ</h2>
<p>Hoàng Hiệp tự tính theo chính sách tháng 12/2026 để anh chị hình dung, chưa phải phiếu tính giá của chủ đầu tư:</p>
<ul>
<li><strong>Đặt cọc:</strong> 100 triệu.</li>
<li><strong>Vay tối đa 70%:</strong> khoảng 1,69 tỷ; chủ đầu tư hỗ trợ lãi suất 24 tháng (không muộn hơn 30/9/2028), ân hạn gốc cùng thời gian.</li>
<li><strong>Vốn tự có 30%:</strong> khoảng 0,73 tỷ, đóng theo tiến độ, giãn đến 40 tháng.</li>
<li><strong>Nhận nhà:</strong> khi đã thanh toán đủ 70% (Sun Early Key).</li>
</ul>
<p>Nếu không vay, anh chị được chiết khấu thêm 5% trên giá chưa VAT và phí bảo trì; nếu thanh toán sớm 95% trong đợt tháng 12/2026 thì chiết khấu thêm 7% (hạn 25/12).</p>
<h2>Vị trí và quy mô</h2>
<p>Cora Tower gồm hai tòa A1, A2 hai bên đường 29/3, sát vòng xoay giao Nguyễn Phước Lan, trung tâm khu đô thị Sun NeO City (Hòa Xuân). Mỗi tòa có 616 căn hộ điển hình, 28 căn mỗi tầng; tầng 1 shophouse, tầng 25 penthouse. Xem chi tiết <a href="/mat-bang-can-ho-cora-tower/">mặt bằng Cora Tower</a>.</p>
<!--hh-dimg:1wnsijH2qgHtzHwhDnYpb6ELxk_aKErVa|Cora Tower nhìn từ trên cao – giao lộ Nguyễn Phước Lan, đường 29/3 (phối cảnh chủ đầu tư)-->
<h2>Ưu đãi khác ảnh hưởng đến giá Cora Tower bao nhiêu</h2>
<ul>
<li>Điểm thưởng hội viên Sun Signature 0,7 – 2% theo hạng.</li>
<li>Miễn phí quản lý 1 năm.</li>
<li>Trả trước hạn từng đợt (từ 10 ngày): hưởng 8%/năm trên số tiền trả trước.</li>
</ul>
<h2>Giá Cora Tower bao nhiêu sau ưu đãi: đọc phiếu tính giá thế nào</h2>
<p>Các khoản ưu đãi của Cora Tower đều tính trên giá chưa VAT và phí bảo trì, nên con số thực trả luôn thấp hơn giá giỏ hàng. Để biết chính xác giá Cora Tower bao nhiêu với căn mình chọn, anh chị nên kiểm tra trên phiếu tính giá ba điểm:</p>
<ol>
<li><strong>Phần giá làm căn cứ chiết khấu:</strong> giá giỏ hàng đã tách VAT và phí bảo trì.</li>
<li><strong>Các ưu đãi được áp dụng cùng lúc:</strong> đặc quyền hoàn thiện nội thất 7%, chiết khấu 5% nếu không vay, chiết khấu thanh toán sớm (95% được 7%, 70% được 1%, hạn 25/12/2026) và cách cộng dồn theo phiếu.</li>
<li><strong>Phần cộng lại sau chiết khấu:</strong> VAT và phí bảo trì được tính lại trên giá sau ưu đãi hay giữ nguyên.</li>
</ol>
<p>Hai khách cùng mua một căn studio nhưng chọn vay và không vay sẽ có câu trả lời khác nhau cho giá Cora Tower bao nhiêu. Vì vậy, Hoàng Hiệp luôn gửi khách hai phiếu tính giá (vay và không vay) để so trước khi đặt cọc. Thông tin tổng quan dự án có trên <a href="https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html">CafeLand</a>; các dòng sản phẩm giới hạn ở tổ hợp căn hộ Sun Group khu Nam trung tâm Đà Nẵng từng được <a href="https://cafef.vn/lo-dien-gan-300-san-pham-phien-ban-gioi-han-tai-cac-to-hop-can-ho-sun-group-nam-trung-tam-da-nang-188260811154747855.chn">CafeF</a> đưa tin.</p>
<p>Xem mốc bàn giao và tiến độ: <a href="/cora-tower-spana-tower-khi-nao-ban-giao/">Cora Tower khi nào bàn giao</a>.</p>
{$cta('Cora Tower')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Cora Tower bao nhiêu? Studio từ 2,42 tỷ (11/2026)',
			'desc'      => 'Giá Cora Tower bao nhiêu? Giỏ hàng 11/2026: studio 32,3 m² 2,42 – 2,74 tỷ, 1PN+ 3,45 – 3,84 tỷ, shop 5,17 – 9,12 tỷ, đã gồm VAT. Vay 70%.',
			'points'    => array(
				'Giá Cora Tower bao nhiêu: studio 32,3 m² khoảng 2,42 – 2,74 tỷ; 1PN+ khoảng 3,45 – 3,84 tỷ',
				'Đặc quyền hoàn thiện nội thất 7%; không vay chiết khấu thêm 5%',
				'Sở hữu lâu dài, bàn giao dự kiến 30/07/2027',
			),
			'faq'       => array(
				array( 'Giá Cora Tower bao nhiêu theo giỏ hàng 11/2026?', 'Theo giỏ hàng 11/2026: studio 32,3 m² khoảng 2,42 – 2,74 tỷ, căn 1PN+ 53,2 – 54,2 m² khoảng 3,45 – 3,84 tỷ, shop khối đế tòa A2 khoảng 5,17 – 9,12 tỷ. Giá gồm VAT và phí bảo trì, chưa trừ chiết khấu.' ),
				array( 'Cora Tower sở hữu bao lâu?', 'Căn hộ Cora Tower sở hữu lâu dài.' ),
				array( 'Cora Tower khi nào bàn giao?', 'Dự kiến 30/07/2027, bàn giao hoàn thiện trần, tường, sàn; thanh toán đủ 70% là nhận nhà sử dụng (Sun Early Key).' ),
				array( 'Mua Cora Tower được chiết khấu bao nhiêu?', 'Đặc quyền hoàn thiện nội thất 7%, không vay thêm 5%, thanh toán sớm 95% trong tháng 12/2026 thêm 7% (hạn 25/12). Chiết khấu tính trên giá chưa VAT và phí bảo trì, nên giá Cora Tower bao nhiêu khi thực trả phụ thuộc phương án thanh toán.' ),
				array( 'Giá Cora Tower bao nhiêu một m²?', 'Quy từ giỏ hàng 11/2026, studio khoảng 75 – 85 triệu/m², căn 1PN+ khoảng 64 – 72 triệu/m² (Hoàng Hiệp tự quy đổi, giá gồm VAT và phí bảo trì, chưa trừ chiết khấu).' ),
				array( 'Giá Cora Tower bao nhiêu với căn 2PN, 3PN?', 'Giỏ hàng 11/2026 chưa công khai giá căn 2PN, 3PN. Anh chị liên hệ Hoàng Hiệp để nhận giá từng căn còn trống.' ),
			),
		),
		'sources'  => array( 'https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html', 'https://cafef.vn/lo-dien-gan-300-san-pham-phien-ban-gioi-han-tai-cac-to-hop-can-ho-sun-group-nam-trung-tam-da-nang-188260811154747855.chn' ),
	);

	/* ---------------- Sun NeO City – chọn tòa ---------------- */
	$posts[] = array(
		'slug'     => 'cora-spana-s-light-sun-neo-city-nen-chon-toa-nao',
		'title'    => 'Cora, Spana hay S-Light: mua căn hộ Sun NeO City Hòa Xuân nên chọn tòa nào?',
		'excerpt'  => 'So sánh 3 tòa căn hộ Sun Group ở Sun NeO City (Hòa Xuân, Đà Nẵng): Cora Tower, Spana Tower và S-Light Tower – vị trí, quy mô, bàn giao, chiết khấu, đặt cọc. Ai hợp tòa nào.',
		'keyword'  => 'Sun NeO City chọn tòa nào',
		'keywords_extra' => array( 'căn hộ Sun NeO City', 'so sánh Cora Spana S-Light', 'căn hộ Hòa Xuân Sun Group' ),
		'project'  => 'cora-tower',
		'schedule' => '2026-11-15 14:00',
		'rev'      => 4, // 26/11 chiều: S-Light nhận nhà dự kiến 30/06/2028. // 26/11: chiết khấu thanh toán sớm tháng 12/2026 (hạn 25/12).
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun NeO City', 'Cora Tower', 'Spana Tower', 'S-Light Tower' ),
		'image'    => 'plugin:img/tin-tuc/chon-toa-sun-neo-city-hoa-xuan.jpg',
		'image_alt' => 'S-Light Tower nhìn từ trên cao, ngã ba sông Hàn – Cẩm Lệ – Đô Toả, Sun NeO City (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Sun NeO City chọn tòa nào?</strong> Cả ba tòa đều của Sun Group, sở hữu lâu dài, nhận nhà khi thanh toán 70%. <strong>Cora Tower</strong> nằm giữa khu đô thị, có giỏ hàng công khai (studio từ khoảng 2,42 tỷ), bàn giao dự kiến 30/07/2027. <strong>Spana Tower</strong> ngay chân cầu Hòa Xuân, quy mô lớn nhất (1.237 căn), bàn giao sớm nhất (dự kiến 30/06/2027). <strong>S-Light Tower</strong> ở ngã ba sông, view sông và pháo hoa, chiết khấu thanh toán sớm cao nhất (95% được 10%).</p>
{$sign}
</div>
<p>Khách tìm căn hộ Sun Group ở Hòa Xuân thường phân vân giữa ba tòa: {$cora}, <a href="/du-an/spana-tower/">Spana Tower</a> và <a href="/du-an/s-light-tower/">S-Light Tower</a>. Bài này so sánh theo những tiêu chí người mua hỏi nhiều nhất để trả lời câu hỏi Sun NeO City chọn tòa nào.</p>
<!--hh-featured-->
<h2>Sun NeO City chọn tòa nào: bảng so sánh 3 tòa</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Cora Tower</th><th>Spana Tower</th><th>S-Light Tower</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Giao lộ Nguyễn Phước Lan – đường 29/3, giữa khu đô thị</td><td>Chân cầu Hòa Xuân, ven sông Cẩm Lệ</td><td>Đường 29/3 giao Nguyễn Đình Thi, ngã ba sông Hàn – Cẩm Lệ – Đô Toả</td></tr>
<tr><td>Quy mô</td><td>2 tòa A1, A2; 616 căn điển hình/tòa</td><td>2 tòa S1, S2; 22 tầng + tum; 1.237 căn</td><td>2 tháp 22 tầng; gần 800 căn</td></tr>
<tr><td>Diện tích</td><td>Studio 32,3 m², 1PN+ 53,2 – 54,2 m², 2PN, 3PN</td><td>Studio 31,6 m² đến 3PN 95,5 m²</td><td>33,3 – 95,1 m²</td></tr>
<tr><td>Giá tham khảo</td><td>Studio 2,42 – 2,74 tỷ; 1PN+ 3,45 – 3,84 tỷ</td><td>Liên hệ</td><td>Liên hệ</td></tr>
<tr><td>Bàn giao</td><td>Dự kiến 30/07/2027</td><td>Dự kiến 30/06/2027</td><td>Nhận nhà sử dụng dự kiến 30/06/2028</td></tr>
<tr><td>Không vay</td><td>Chiết khấu thêm 5%</td><td>Chiết khấu thêm 5%</td><td>Chiết khấu thêm 3%</td></tr>
<tr><td>Thanh toán sớm 95% (12/2026)</td><td>7%</td><td>5,5%</td><td>9,5%</td></tr>
<tr><td>Thanh toán sớm 70% (12/2026)</td><td>1%</td><td>Không áp dụng</td><td>2,5%</td></tr>
<tr><td>Ưu đãi riêng</td><td>Hoàn thiện nội thất 7%</td><td>Quà an cư 3%</td><td>Early Bird 3% (có thời hạn)</td></tr>
<tr><td>Đặt cọc</td><td>100 triệu (3PN 150 triệu)</td><td>100 triệu (3PN 150 triệu)</td><td>Studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu</td></tr>
<tr><td>Giãn tiến độ</td><td>Đến 40 tháng</td><td>Đến 38 tháng</td><td>Đến 48 tháng</td></tr>
</tbody>
</table>
<p><small>Chính sách tham khảo; mức thanh toán sớm tháng 12/2026, hạn 25/12/2026. Chiết khấu tính trên giá chưa VAT và phí bảo trì.</small></p>
<h2>Sun NeO City chọn tòa nào cũng có 4 điểm chung</h2>
<ul>
<li>Chủ đầu tư Sun Group, sở hữu lâu dài.</li>
<li>Vay tối đa 70%, chủ đầu tư hỗ trợ lãi suất 24 tháng, ân hạn gốc cùng thời gian.</li>
<li>Sun Early Key: thanh toán đủ 70% là nhận nhà sử dụng.</li>
<li>Trả trước hạn hưởng 8%/năm; miễn phí quản lý 1 năm.</li>
</ul>
<h2>Sun NeO City chọn tòa nào theo nhu cầu</h2>
<h3>Cora Tower: muốn biết rõ giá trước khi quyết</h3>
<p>Cora có giỏ hàng công khai theo loại căn, studio từ khoảng 2,42 tỷ. Vị trí trung tâm khu đô thị, gần trục Nguyễn Phước Lan. Hợp khách mua lần đầu, cần so tổng tiền cụ thể: nếu đang phân vân Sun NeO City chọn tòa nào mà ưu tiên giá rõ, Cora là điểm bắt đầu. Xem <a href="/gia-cora-tower-da-nang-bao-nhieu/">giá Cora Tower</a>.</p>
<!--hh-dimg:16CvhXKb-qvrDsD40RjoVaRjVWvjw1uzD|Cora Tower về đêm (phối cảnh chủ đầu tư)-->
<h3>Spana Tower: muốn nhận nhà sớm</h3>
<p>Spana bàn giao dự kiến 30/06/2027, sớm nhất trong ba tòa. Sở Xây dựng xác nhận đủ điều kiện bán ngày 05/5/2026, có bảo lãnh VietinBank. Tháng 11/2026 hai tòa đang thi công phần thân, lên khoảng tầng 10. Trọn tầng 2 là tiện ích: bể bơi, gym, spa, co-working, khu trẻ em.</p>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-nhin-tu-cau-hoa-xuan.jpg|Sun NeO City chọn tòa nào nếu muốn nhận nhà sớm: Spana Tower nhìn từ cầu Hòa Xuân, hai tòa S1, S2 đang thi công (tiến độ 11/2026)-->
<h3>S-Light Tower: muốn view sông và trả sớm</h3>
<p>S-Light nằm ở ngã ba sông Hàn – Cẩm Lệ – Đô Toả, tầm nhìn sông và pháo hoa DIFF. Chiết khấu thanh toán sớm 95% cao nhất (9,5% trong tháng 12/2026), giãn tiến độ dài nhất (48 tháng). Đổi lại, tiền cọc căn lớn cao hơn.</p>
<!--hh-dimg:1PzoF4f2-geg_T48jzs58EJhAIQrEJkMI|Hai tháp S-Light Tower bên sông (phối cảnh chủ đầu tư)-->
<p>Ba tòa đều có penthouse, xem thêm <a href="/penthouse-spana-cora-s-light-sun-neo-city/">penthouse Spana, Cora, S-Light</a>.</p>
<h2>Sun NeO City chọn tòa nào: pháp lý từng tòa</h2>
<ul>
<li><strong>Spana Tower:</strong> Sở Xây dựng xác nhận đủ điều kiện bán (VB 7111/SXD-QLN, 05/5/2026); VietinBank bảo lãnh; đất ở đô thị, 2 giấy chứng nhận riêng cho lô A1-3 và A1-4; hợp đồng mẫu đăng ký với Sở Công Thương.</li>
<li><strong>Cora Tower, S-Light Tower:</strong> sở hữu lâu dài; anh chị nên đề nghị xem văn bản đủ điều kiện bán và thư bảo lãnh ngân hàng của tòa khi đặt căn.</li>
</ul>
<h2>Shophouse khối đế</h2>
<p><strong>Spana:</strong> tầng 1 mỗi tòa là dãy shophouse mặt đường, căn điển hình mặt tiền khoảng 6,2 m, diện tích khoảng 46 – 148 m². <strong>Cora:</strong> 5 shop tầng 1 tòa A2, 43,8 – 87,3 m², khoảng 5,17 – 9,12 tỷ, giao lộ Nguyễn Phước Lan – đường 29/3. Shophouse hợp cà phê, cửa hàng tiện lợi, phòng khám phục vụ cư dân.</p>
<!--hh-img:img/spana-tower/spana-tower-hoang-hon-khoi-de-thuong-mai.jpg|Sun NeO City chọn tòa nào để kinh doanh: khối đế thương mại Spana Tower lúc hoàng hôn (phối cảnh chủ đầu tư)-->
<h2>Sun NeO City chọn tòa nào theo mốc bàn giao</h2>
<p>Spana dự kiến 30/06/2027 (tháng 11/2026 lên khoảng tầng 10), Cora dự kiến 30/07/2027. Xem chi tiết <a href="/cora-tower-spana-tower-khi-nao-ban-giao/">Cora Tower khi nào bàn giao</a>.</p>
<h2>Sun NeO City chọn tòa nào để đặt cọc nhẹ nhất</h2>
<p>Cora và Spana cùng đặt cọc 100 triệu cho căn studio đến 2PN, 150 triệu cho căn 3PN. S-Light đặt cọc theo loại căn: studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu, penthouse 300 triệu; đổi lại S-Light cho giãn tiến độ dài nhất, đến 48 tháng.</p>
<h2>Sun NeO City chọn tòa nào: 4 câu tự hỏi trước khi đặt cọc</h2>
<ol>
<li><strong>Có cần biết tổng tiền ngay không?</strong> Nếu có, Cora là tòa có giỏ hàng công khai theo loại căn (studio từ khoảng 2,42 tỷ, 1PN+ từ khoảng 3,45 tỷ).</li>
<li><strong>Cần nhận nhà sớm nhất?</strong> Spana dự kiến bàn giao 30/06/2027, sớm hơn Cora một tháng.</li>
<li><strong>Có thể thanh toán sớm 95% không?</strong> Nếu có, S-Light cho chiết khấu cao nhất (9,5%, hạn 25/12/2026).</li>
<li><strong>Vốn ban đầu ít?</strong> Cora và Spana đặt cọc 100 triệu cho căn đến 2PN; S-Light cọc cao hơn với căn lớn nhưng giãn tiến độ đến 48 tháng.</li>
</ol>
<p>Trả lời xong bốn câu này, câu hỏi Sun NeO City chọn tòa nào thường chỉ còn một hoặc hai phương án. Thông tin ra mắt S-Light Tower từng được <a href="https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn">CafeF</a> đưa tin; tổng quan Cora Tower và S-Light Tower có trên <a href="https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html">CafeLand</a>.</p>
{$cta('Sun NeO City')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun NeO City chọn tòa nào? So sánh 3 tòa 11/2026',
			'desc'      => 'Sun NeO City chọn tòa nào: so sánh Cora Tower, Spana Tower, S-Light Tower ở Hòa Xuân – vị trí, quy mô, bàn giao, chiết khấu, đặt cọc 11/2026.',
			'points'    => array(
				'Sun NeO City chọn tòa nào: Cora có giỏ hàng công khai, studio từ khoảng 2,42 tỷ, bàn giao 30/07/2027',
				'Spana: chân cầu Hòa Xuân, 1.237 căn, bàn giao sớm nhất 30/06/2027',
				'S-Light: ngã ba sông, chiết khấu thanh toán sớm 95% cao nhất 9,5% (tháng 12/2026)',
			),
			'faq'       => array(
				array( 'Sun NeO City có những tòa căn hộ nào?', 'Ba tòa căn hộ Sun Group đang bán: Cora Tower (A1, A2), Spana Tower (S1, S2) và S-Light Tower (2 tháp 22 tầng), đều sở hữu lâu dài.' ),
				array( 'Tòa nào ở Sun NeO City bàn giao sớm nhất?', 'Spana Tower, dự kiến 30/06/2027. Cora Tower dự kiến 30/07/2027.' ),
				array( 'Sun NeO City chọn tòa nào nếu thanh toán sớm?', 'S-Light Tower: thanh toán sớm 95% được chiết khấu 9,5% (chính sách tháng 12/2026, hạn 25/12).' ),
				array( 'Sun NeO City chọn tòa nào để cho thuê?', 'Nếu cần tổng tiền thấp và giá rõ, Cora có giỏ hàng công khai (studio từ khoảng 2,42 tỷ); nếu nhắm khách thích view sông, S-Light ở ngã ba sông Hàn – Cẩm Lệ – Đô Toả. Nên so tổng tiền sau ưu đãi của từng căn.' ),
				array( 'Sun NeO City chọn tòa nào để gia đình ở?', 'Spana có căn đến 3PN 95,5 m², trọn tầng 2 tiện ích và bàn giao sớm nhất; Cora có căn 2PN, 3PN ở vị trí giữa khu đô thị, gần trục Nguyễn Phước Lan.' ),
			),
		),
		'sources'  => array( 'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn', 'https://cafeland.vn/du-an/s-light-tower-to-hop-can-ho-thuoc-sun-neo-city-da-nang-5622.html', 'https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html' ),
	);

	/* ---------------- Capital Square – Bảng giá ---------------- */
	$posts[] = array(
		'slug'     => 'bang-gia-capital-square-da-nang-theo-toa',
		'title'    => 'Giá Capital Square Đà Nẵng theo tòa (11/2026): từ 4,32 tỷ, căn 1PN đến 3PN',
		'excerpt'  => 'Bảng giá Capital Square Đà Nẵng giỏ hàng 11/2026 theo tòa: S4 Hudson Place 4,32 – 13,41 tỷ, S3 Broadway 4,78 – 11,61 tỷ, C7 Victory, C6 The Kings, C1 The Times, C4 The Queens. Giá theo loại căn, ưu đãi và sở hữu.',
		'keyword'  => 'giá Capital Square theo tòa',
		'keywords_extra' => array( 'giá Capital Square Đà Nẵng', 'bảng giá Capital Square Đà Nẵng', 'giá căn hộ Capital Square' ),
		'project'  => 'capital-square-da-nang',
		'schedule' => '2026-11-16 09:00',
		'rev'      => 2,
		'category' => 'Thị trường',
		'tags'     => array( 'Capital Square Đà Nẵng', 'Căn hộ sông Hàn', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/capital-square/capital-square-phoi-canh-toan-canh-ban-ngay.jpg',
		'image_alt' => 'Phối cảnh Capital Square Đà Nẵng – các tòa căn hộ bên bờ Đông sông Hàn (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Giá Capital Square theo tòa (giỏ hàng 11/2026):</strong> căn 1PN khoảng <strong>4,3 – 5,1 tỷ</strong>, 2PN khoảng 6,2 – 10,6 tỷ, 2PN+1 khoảng 7,3 – 10,8 tỷ, 3PN khoảng 9,3 – 13,9 tỷ. Thấp nhất hiện là tòa S4 Hudson Place từ 4,32 tỷ. Giá gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu. Căn hộ sở hữu lâu dài với khách Việt Nam.</p>
<table>
<thead><tr><th>Tòa</th><th>Diện tích</th><th>Giá (tham khảo)</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>S4 Hudson Place</td><td>46 – 102 m²</td><td>4,32 – 13,41 tỷ</td><td>View sông Hàn, cầu Rồng</td></tr>
<tr><td>C7 Victory</td><td>45 – 104 m²</td><td>4,77 – 13,32 tỷ</td><td>Căn góc 3PN 12,6 – 13,3 tỷ</td></tr>
<tr><td>S3 Broadway</td><td>47 – 101 m²</td><td>4,78 – 11,61 tỷ</td><td>1PN từ 4,78 tỷ, 2PN từ 6,58 tỷ, 3PN từ 8,50 tỷ</td></tr>
<tr><td>C6 The Kings</td><td>45 – 104 m²</td><td>5,08 – 13,11 tỷ</td><td>2PN từ 6,29 tỷ, 2PN+1 từ 7,27 tỷ, 3PN từ 10,27 tỷ</td></tr>
<tr><td>C1 The Times</td><td>66 – 120 m²</td><td>6,53 – 12,21 tỷ</td><td>Tầng 20 – 24</td></tr>
<tr><td>C4 The Queens</td><td>69 – 113 m²</td><td>7,07 – 13,93 tỷ</td><td>Tầng 22 – 26</td></tr>
</tbody>
</table>
{$sign}
</div>
<p>{$cs} là tổ hợp 14 tòa, 3.391 căn hộ của hệ sinh thái BRG bên bờ Đông sông Hàn. Mỗi tòa có giỏ hàng và mức giá riêng, nên câu hỏi "giá Capital Square bao nhiêu" cần trả lời theo từng tòa. Bài này tổng hợp <strong>giá Capital Square theo tòa</strong> từ giỏ hàng tháng 11/2026.</p>
<!--hh-featured-->
<h2>Giá Capital Square theo tòa và theo loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá (tham khảo)</th></tr></thead>
<tbody>
<tr><td>1PN</td><td>45 – 47 m²</td><td>Khoảng 4,3 – 5,1 tỷ</td></tr>
<tr><td>2PN</td><td>61,6 – 81 m²</td><td>Khoảng 6,2 – 10,6 tỷ</td></tr>
<tr><td>2PN+1</td><td>77,7 – 84,6 m²</td><td>Khoảng 7,3 – 10,8 tỷ</td></tr>
<tr><td>3PN</td><td>91,3 – 120 m²</td><td>Khoảng 9,3 – 13,9 tỷ</td></tr>
</tbody>
</table>
<p>Ngoài giá Capital Square theo tòa, chênh lệch trong cùng loại căn chủ yếu do tầng và hướng: căn nhìn sông Hàn, cầu Rồng ở tầng cao có giá cao nhất.</p>
<!--hh-img:img/capital-square/capital-square-phoi-canh-ngay-ven-song-han.jpg|Giá Capital Square theo tòa chênh theo vị trí: tổ hợp nhìn từ sông Hàn ban ngày (ảnh chủ đầu tư)-->
<h2>Giá Capital Square theo tòa: tòa nào hợp ngân sách nào</h2>
<p>Đọc bảng giá Capital Square theo tòa ở đầu bài, có thể chia nhanh theo ngân sách như sau (giỏ hàng 11/2026, gồm VAT và kinh phí bảo trì, chưa trừ ưu đãi):</p>
<ul>
<li><strong>Khoảng 4,3 – 5 tỷ:</strong> căn 1PN ở S4 Hudson Place (từ 4,32 tỷ), C7 Victory (từ 4,77 tỷ) hoặc S3 Broadway (từ 4,78 tỷ).</li>
<li><strong>Khoảng 6,3 – 7 tỷ:</strong> căn 2PN ở C6 The Kings (từ 6,29 tỷ), S3 Broadway (từ 6,58 tỷ); C1 The Times bắt đầu từ 6,53 tỷ ở tầng 20 – 24.</li>
<li><strong>Cần 3PN dưới 9 tỷ:</strong> S3 Broadway có 3PN từ khoảng 8,50 tỷ.</li>
<li><strong>Muốn tầng cao, căn lớn:</strong> C4 The Queens (tầng 22 – 26) từ 7,07 tỷ, căn lớn nhất đến khoảng 13,93 tỷ.</li>
</ul>
<p>Cách chia này chỉ là điểm khởi đầu: trong cùng một tòa, giá còn chênh theo tầng và hướng nhìn sông Hàn, cầu Rồng. Sau khi khoanh vùng tòa, anh chị nên xin giỏ hàng chi tiết để so từng căn.</p>
<h2>Ưu đãi đang áp dụng</h2>
<h3>Chung toàn tổ hợp</h3>
<ul>
<li>Đặt cọc 100 triệu/căn.</li>
<li>Thưởng nóng 44 triệu/căn với căn 2PN, 2PN+1; 66 triệu/căn với căn 3PN (đã gồm VAT), khi ký hợp đồng mua bán và thanh toán đợt 1.</li>
<li>Có phương án vay 0% lãi và thanh toán sớm 95%, 100% có chiết khấu.</li>
</ul>
<h3>Riêng tòa S3 Broadway Place và S4 Hudson Place (11/2026)</h3>
<ul>
<li>Vay ngân hàng: 5 năm không lo lãi suất (điều kiện, hạn mức theo chính sách).</li>
<li>Chiết khấu thêm 5%.</li>
<li>Quà Smart Home: 1PN 100 triệu, 2PN 200 triệu, 3PN 300 triệu.</li>
<li>Tặng chuyến du lịch châu Âu trị giá 100 triệu.</li>
</ul>
<p>So sánh chi tiết hai tòa này: <a href="/hudson-place-hay-broadway-place-capital-square/">Hudson Place S4 và Broadway Place S3</a>.</p>
<h2>Sở hữu và bàn giao</h2>
<ul>
<li>Sở hữu lâu dài với khách Việt Nam; 50 năm với khách nước ngoài (trong hạn mức được phép: tối đa 502 căn ở Capital Square 2 và 512 căn ở Capital Square 3).</li>
<li>Bàn giao toàn tổ hợp dự kiến quý I/2027; riêng Hudson Place dự kiến quý III/2027.</li>
<li>Bàn giao liền tường theo danh mục vật liệu chủ đầu tư: cửa chính chống cháy, khóa từ kỹ thuật số; sàn, trần phòng ở khách tự hoàn thiện.</li>
</ul>
<!--hh-img:img/capital-square/capital-square-tien-ich-ho-boi-lon.jpg|Hồ bơi lớn nội khu Capital Square (ảnh chủ đầu tư)-->
<h2>Lưu ý khi so giá Capital Square theo tòa</h2>
<ol>
<li>Tên tòa trong giỏ hàng (Kings, Queens, Times, Victory, Broadway, Hudson) là tên bán hàng; văn bản của Sở Xây dựng dùng mã tòa (2.1 – 2.7, LAT, MAT). Hỏi rõ mã tòa khi đặt căn.</li>
<li>Giá đã gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu và quà.</li>
<li>So theo tổng tiền thực trả sau ưu đãi, không chỉ theo giá niêm yết.</li>
</ol>
<h2>Hai phân khu, hai chủ đầu tư</h2>
<p>Capital Square 2 do Công ty TNHH Mega Assets làm chủ đầu tư, gồm tòa 2.1 – 2.7 với 1.681 căn; Capital Square 3 do Công ty CP Bất động sản SIH làm chủ đầu tư, gồm các khối LAT 4-5, MAT 5-6, MAT 7, MAT 8-9 với 1.710 căn. Cả hai thuộc hệ sinh thái BRG. Tổ hợp nằm trên khu đất 61.368 m² giữa Trần Hưng Đạo, Ngô Quyền và Nguyễn Công Trứ, liền kề Vincom, cách cầu Rồng khoảng 1,5 km. Vì mỗi phân khu có chủ đầu tư và đợt mở bán riêng, giá Capital Square theo tòa cũng được công bố theo từng đợt.</p>
<!--hh-img:img/capital-square/capital-square-phoi-canh-dem-ven-song-han.jpg|Phối cảnh Capital Square về đêm bên sông Hàn (ảnh chủ đầu tư)-->
<h2>Chiết khấu theo phương thức thanh toán</h2>
<p>Theo tài liệu ngày 28/9/2026 cho tòa Hudson Place, ưu đãi theo phương thức thanh toán là: theo tiến độ 8%, thanh toán nhanh 100% giá chuyển nhượng hợp đồng 12%, thanh toán sớm 95% 18%. Mức đang áp dụng có thể đã thay đổi – anh chị hỏi lại khi đặt căn.</p>
<h2>Hỏi gì khi nhận giá Capital Square theo tòa</h2>
<ol>
<li>Giá đã gồm VAT và kinh phí bảo trì chưa?</li>
<li>Căn thuộc mã tòa nào trong văn bản của Sở Xây dựng?</li>
<li>Áp dụng chính sách nào (thưởng nóng, chiết khấu thêm 5%, Smart Home)?</li>
</ol>
<p>Các đợt Capital Square 2 và Capital Square 3 đủ điều kiện mở bán đã được <a href="https://baodautu.vn/da-nang-khu-do-thi-capital-square-3-tiep-tuc-duoc-phep-mo-ban-250-can-ho-d605920.html">Báo Đầu tư</a> đưa tin (<a href="https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-2-du-dieu-kien-mo-ban-530-can-ho-d314431.html">Capital Square 2</a>, <a href="https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html">Capital Square 3</a>) – đây là căn cứ để đối chiếu mã tòa khi xem giá Capital Square theo tòa.</p>
{$cta('Capital Square')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Capital Square theo tòa 11/2026: từ 4,32 tỷ',
			'desc'      => 'Giá Capital Square theo tòa, giỏ hàng 11/2026: S4 Hudson từ 4,32 tỷ, C7 Victory 4,77 tỷ, S3 Broadway 4,78 tỷ; 1PN 4,3 – 5,1 tỷ, 3PN 9,3 – 13,9 tỷ.',
			'points'    => array(
				'1PN khoảng 4,3 – 5,1 tỷ; 2PN 6,2 – 10,6 tỷ; 3PN 9,3 – 13,9 tỷ (gồm VAT, phí bảo trì)',
				'Giá Capital Square theo tòa: thấp nhất S4 Hudson Place từ 4,32 tỷ, C7 Victory từ 4,77 tỷ, S3 Broadway từ 4,78 tỷ',
				'Thưởng nóng 44 – 66 triệu/căn; S3, S4 thêm chiết khấu 5%, quà Smart Home',
			),
			'faq'       => array(
				array( 'Giá Capital Square theo tòa hiện ra sao?', 'Theo giỏ hàng 11/2026: căn 1PN khoảng 4,3 – 5,1 tỷ, 2PN 6,2 – 10,6 tỷ, 2PN+1 7,3 – 10,8 tỷ, 3PN 9,3 – 13,9 tỷ. Giá gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu.' ),
				array( 'Tòa nào Capital Square giá thấp nhất?', 'Theo giá Capital Square theo tòa tháng 11/2026, thấp nhất là tòa S4 Hudson Place, từ khoảng 4,32 tỷ cho căn 1PN (giỏ hàng 11/2026).' ),
				array( 'Capital Square sở hữu bao lâu?', 'Sở hữu lâu dài với khách Việt Nam; 50 năm với khách nước ngoài trong hạn mức được phép.' ),
				array( 'Vì sao giá Capital Square theo tòa chênh nhau?', 'Do vị trí trong tổ hợp, tầng bán, hướng nhìn sông Hàn – cầu Rồng và chính sách riêng từng tòa (ví dụ S3, S4 có thêm chiết khấu 5% và quà Smart Home tháng 11/2026).' ),
				array( 'Giá Capital Square theo tòa đã gồm VAT chưa?', 'Đã gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu, thưởng nóng và quà.' ),
			),
		),
		'sources'  => array( 'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-2-du-dieu-kien-mo-ban-530-can-ho-d314431.html', 'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html', 'https://baodautu.vn/da-nang-khu-do-thi-capital-square-3-tiep-tuc-duoc-phep-mo-ban-250-can-ho-d605920.html' ),
	);

	/* ---------------- Hudson Place S4 và Broadway S3 ---------------- */
	$posts[] = array(
		'slug'     => 'hudson-place-hay-broadway-place-capital-square',
		'old_slug' => array( 'hudson-place-s4-va-broadway-place-s3-capital-square-chon-toa-nao' ),
		'title'    => 'Hudson Place S4 và Broadway Place S3 Capital Square: khác nhau thế nào, nên chọn tòa nào?',
		'excerpt'  => 'So sánh tòa S4 Hudson Place và S3 Broadway Place – Capital Square 3 (Đà Nẵng): giá giỏ hàng, loại căn, vị trí trong tổ hợp, chính sách 11/2026 (vay 5 năm không lo lãi suất, chiết khấu 5%, quà Smart Home).',
		'keyword'  => 'Hudson Place hay Broadway Place',
		'keywords_extra' => array( 'Hudson Place S4', 'Broadway Place S3', 'Hudson Place Capital Square', 'Capital Square 3 nên mua tòa nào' ),
		'project'  => 'capital-square-hudson-place-s4',
		'schedule' => '2026-11-16 14:00',
		'rev'      => 2,
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Capital Square Đà Nẵng', 'Hudson Place', 'Căn hộ sông Hàn' ),
		'image'    => 'plugin:img/hudson-place/hudson-place-phoi-canh-toa-s4-ven-song-han.jpg',
		'image_alt' => 'Phối cảnh tòa S4 Hudson Place ven sông Hàn, Capital Square Đà Nẵng (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Hudson Place hay Broadway Place?</strong> Đây là hai tòa S4 và S3 cùng cụm của Capital Square 3, cùng chính sách 11/2026 (vay 5 năm không lo lãi suất, chiết khấu thêm 5%, quà Smart Home 100 – 300 triệu). <strong>S4</strong> có giá vào thấp hơn (1PN từ khoảng 4,32 tỷ), 314 căn, có căn 3PN dualkey, vận hành Savills, bàn giao dự kiến quý III/2027. <strong>S3</strong> có 1PN từ khoảng 4,78 tỷ, 3PN từ khoảng 8,50 tỷ – thấp hơn mức 3PN của S4.</p>
{$sign}
</div>
<p>Trong tổ hợp {$cs}, hai tòa đang được hỏi nhiều nhất tháng 11/2026 là {$hudson} và Broadway Place S3, vì cùng có bộ chính sách ưu đãi mới. Bài này trả lời câu hỏi Hudson Place hay Broadway Place để anh chị chọn đúng căn theo ngân sách.</p>
<!--hh-featured-->
<h2>Hudson Place hay Broadway Place: bảng so sánh</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>S4 Hudson Place</th><th>S3 Broadway Place</th></tr></thead>
<tbody>
<tr><td>Phân khu</td><td>Capital Square 3 (CĐT SIH, hệ sinh thái BRG)</td><td>Capital Square 3</td></tr>
<tr><td>Quy mô</td><td>24 tầng, 314 căn, 15 căn/sàn</td><td>Mặt bằng điển hình tầng 5 – 12, 14 – 24</td></tr>
<tr><td>Loại căn</td><td>1PN 46,3 – 47,2 m²; 2PN 72,0 – 74,3 m²; 3PN 91,3 – 91,4 m²; 3PN dualkey 101,0 – 101,6 m²</td><td>1PN, 2PN, 3PN; 47 – 101 m²</td></tr>
<tr><td>Giá giỏ hàng</td><td>4,32 – 13,41 tỷ</td><td>4,78 – 11,61 tỷ</td></tr>
<tr><td>1PN từ</td><td>4,32 tỷ</td><td>4,78 tỷ</td></tr>
<tr><td>2PN từ</td><td>6,61 tỷ</td><td>6,58 tỷ</td></tr>
<tr><td>3PN từ</td><td>9,33 tỷ (dualkey) / 10,16 tỷ</td><td>8,50 tỷ</td></tr>
<tr><td>Tiến độ 9/2026</td><td>Thi công phần thân</td><td>Thi công phần thân</td></tr>
</tbody>
</table>
<p><small>Giá gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu. Giỏ hàng S4 tháng 10/2026, S3 tháng 11/2026.</small></p>
<h2>Hudson Place hay Broadway Place: vị trí trong tổ hợp</h2>
<p>Theo mặt bằng vị trí của chủ đầu tư, Hudson Place đứng cùng cụm với Broadway Place, nhìn ra bể bơi resort phía đường Nguyễn Công Trứ. Phía Bắc là các tòa Kings, Queens, Times; phía Tây là đường Trần Hưng Đạo ven sông Hàn; phía Đông là đại lộ Ngô Quyền.</p>
<!--hh-img:img/hudson-place/hudson-place-mat-bang-vi-tri-capital-square-3.jpg|Hudson Place hay Broadway Place – vị trí hai tòa S4, S3 trên mặt bằng Capital Square 3 (tài liệu chủ đầu tư)-->
<h2>Điểm riêng của Hudson Place S4</h2>
<ul>
<li>Layout vuông, 100% phòng lấy sáng tự nhiên, hành lang rộng 2 m.</li>
<li>Căn 2PN đều có 2 lô gia; có dòng <strong>3PN dualkey</strong> (2PN + studio riêng cửa) – ở một phần, cho thuê một phần.</li>
<li>Cạnh bể bơi và cụm tiện ích lớn nhất Capital Square, có sân golf mini nội khu.</li>
<li>Vận hành bởi Savills; bàn giao dự kiến quý III/2027, bán hoàn thiện.</li>
<li>Mua theo hình thức chuyển nhượng hợp đồng mua bán, ký tại văn phòng chủ đầu tư.</li>
</ul>
<!--hh-img:img/hudson-place/hudson-place-layout-can-3pn-dualkey.jpg|Layout căn 3PN dualkey Hudson Place S4 (tài liệu chủ đầu tư)-->
<h2>Điểm riêng của Broadway Place S3</h2>
<ul>
<li>Giá vào căn 3PN thấp hơn S4 (từ khoảng 8,50 tỷ).</li>
<li>Mặt bằng điển hình dùng chung cho tầng 5 – 12 và 14 – 24, gồm căn 1PN, 2PN, 3PN.</li>
</ul>
<!--hh-img:img/capital-square/capital-square-mat-bang-dien-hinh-toa-s3-broadway.jpg|Mặt bằng điển hình tòa S3 Broadway tầng 5 – 12, 14 – 24 (tài liệu chủ đầu tư)-->
<h2>Hudson Place hay Broadway Place cũng có chung chính sách 11/2026</h2>
<ul>
<li>Vay ngân hàng: 5 năm không lo lãi suất (hỏi điều kiện và hạn mức cụ thể).</li>
<li>Chiết khấu thêm 5%.</li>
<li>Quà Smart Home: 1PN 100 triệu, 2PN 200 triệu, 3PN 300 triệu.</li>
<li>Tặng chuyến du lịch châu Âu trị giá 100 triệu; miễn phí quản lý 1 năm.</li>
</ul>
<h2>Hudson Place hay Broadway Place: chọn tòa nào</h2>
<ul>
<li><strong>Ngân sách 1PN quanh 4,3 – 4,9 tỷ:</strong> S4 có giá vào thấp hơn.</li>
<li><strong>Cần 3PN dưới 9 tỷ:</strong> xem S3 (3PN từ khoảng 8,50 tỷ).</li>
<li><strong>Vừa ở vừa cho thuê:</strong> căn 3PN dualkey của S4.</li>
</ul>
<p>Xem giá các tòa còn lại: <a href="/bang-gia-capital-square-da-nang-theo-toa/">bảng giá Capital Square theo tòa</a>.</p>
<h2>Hudson Place hay Broadway Place: so theo 3 mức ngân sách</h2>
<ul>
<li><strong>Căn 1PN:</strong> Hudson Place từ khoảng 4,32 tỷ, Broadway Place từ khoảng 4,78 tỷ – Hudson thấp hơn khoảng 0,46 tỷ ở mức giá vào (Hoàng Hiệp tự tính từ giỏ hàng).</li>
<li><strong>Căn 2PN:</strong> Broadway Place từ 6,58 tỷ, Hudson Place từ 6,61 tỷ – gần như ngang nhau, nên chọn theo layout, hướng và tầng.</li>
<li><strong>Căn 3PN:</strong> Broadway Place từ khoảng 8,50 tỷ; Hudson Place từ 9,33 tỷ (3PN dualkey) hoặc 10,16 tỷ (3PN thường).</li>
</ul>
<p>Như vậy, câu hỏi Hudson Place hay Broadway Place phụ thuộc nhiều vào loại căn: mua 1PN nghiêng về Hudson Place, mua 3PN với ngân sách dưới 9 tỷ nghiêng về Broadway Place, còn 2PN thì so từng căn cụ thể. Các đợt Capital Square 3 được phép mở bán từng được <a href="https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html">Báo Đầu tư</a> đưa tin.</p>
<h2>Tầng điển hình Hudson Place có gì</h2>
<p>Mỗi sàn điển hình của Hudson Place có 15 căn gồm 2 căn 1PN, 7 căn 2PN và 6 căn 3PN. Đơn giá tham khảo khoảng 92 – 146 triệu/m² thông thủy tùy tầng, hướng (gồm VAT và kinh phí bảo trì, giỏ hàng 10/2026). Căn 2PN hướng Nam nhìn sông Hàn, cầu Rồng có giá cao nhất.</p>
<!--hh-img:img/hudson-place/hudson-place-mat-bang-tang-5-12-14-24.jpg|Mặt bằng tầng 5 – 12, 14 – 24 tòa S4 Hudson Place (tài liệu chủ đầu tư)-->
<h2>Vay và thanh toán</h2>
<ul>
<li>Vay tới 70% tổng giá bán (có VAT, không gồm kinh phí bảo trì), ân hạn gốc 36 tháng.</li>
<li>Phương án 1: 0% lãi suất 36 tháng với phần vay bằng 50% giá bán, 24 tháng với phần 20%.</li>
<li>Phương án 2: 0% 24 tháng và 12 tháng, sau đó cố định 7,5%/năm trong 36 tháng.</li>
<li>Chi tiết: <a href="/vay-mua-capital-square-da-nang-tra-gop-hang-thang/">vay mua Capital Square</a>.</li>
</ul>
<h2>Chọn Hudson Place hay Broadway Place đều dùng chung tiện ích</h2>
<p>Hudson Place và Broadway Place cùng cụm, nhìn ra bể bơi resort phía đường Nguyễn Công Trứ. Theo phối cảnh chủ đầu tư, quanh tòa có bể bơi, café ngoài trời, sân golf mini, sân chơi trẻ em và sân vườn thư giãn; xa hơn là phố đi bộ thương mại và quảng trường của tổ hợp Capital Square.</p>
<p>Dù chọn Hudson Place hay Broadway Place, người nước ngoài được mua căn hộ Capital Square trong hạn mức (tối đa 512 căn ở Capital Square 3), thời hạn 50 năm.</p>
{$cta('Hudson Place S4 và Broadway Place S3')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hudson Place hay Broadway Place? So sánh 2 tòa 11/2026',
			'desc'      => 'Hudson Place hay Broadway Place (Capital Square Đà Nẵng): 1PN từ 4,32 / 4,78 tỷ, 3PN từ 9,33 / 8,50 tỷ, loại căn, vị trí, chính sách 11/2026.',
			'points'    => array(
				'Hudson Place hay Broadway Place: S4 có 1PN từ khoảng 4,32 tỷ, 3PN dualkey, vận hành Savills, bàn giao quý III/2027',
				'S3: 1PN từ khoảng 4,78 tỷ, 3PN từ khoảng 8,50 tỷ',
				'Hudson Place hay Broadway Place đều áp dụng chính sách 11/2026: vay 5 năm không lo lãi suất, chiết khấu 5%, quà Smart Home',
			),
			'faq'       => array(
				array( 'Hudson Place S4 giá bao nhiêu?', 'Giỏ hàng 10/2026: 1PN 46,3 – 47,2 m² khoảng 4,32 – 4,91 tỷ, 2PN 6,61 – 10,58 tỷ, 3PN và 3PN dualkey 9,33 – 13,41 tỷ (gồm VAT, kinh phí bảo trì).' ),
				array( 'Broadway Place S3 giá bao nhiêu?', 'Giỏ hàng 11/2026: 4,78 – 11,61 tỷ cho căn 47 – 101 m²; 1PN từ 4,78 tỷ, 2PN từ 6,58 tỷ, 3PN từ 8,50 tỷ.' ),
				array( 'Hudson Place khi nào bàn giao?', 'Dự kiến quý III/2027, bán hoàn thiện.' ),
				array( 'Hudson Place hay Broadway Place rẻ hơn?', 'Căn 1PN: Hudson Place từ khoảng 4,32 tỷ, thấp hơn Broadway Place (từ 4,78 tỷ). Căn 3PN: Broadway Place từ khoảng 8,50 tỷ, thấp hơn Hudson Place (từ 9,33 tỷ với 3PN dualkey).' ),
				array( 'Hudson Place hay Broadway Place hợp cho thuê hơn?', 'Nếu vừa ở vừa cho thuê, căn 3PN dualkey của Hudson Place (2PN cộng studio riêng cửa) đáng xem, tòa do Savills vận hành. Broadway Place hợp người cần căn 3PN với ngân sách dưới 9 tỷ.' ),
			),
		),
		'sources'  => array( 'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-3-duoc-phep-mo-ban-hon-580-can-ho-d362936.html', 'https://baodautu.vn/da-nang-khu-do-thi-capital-square-3-tiep-tuc-duoc-phep-mo-ban-250-can-ho-d605920.html' ),
	);

	/* ---------------- Căn hộ dưới 3 tỷ ---------------- */
	$posts[] = array(
		'slug'     => 'can-ho-duoi-3-ty-da-nang-du-an-dang-ban',
		'title'    => 'Căn hộ dưới 3 tỷ ở Đà Nẵng: 7 dự án đang bán, giá từng loại căn (11/2026)',
		'excerpt'  => 'Căn hộ dưới 3 tỷ ở Đà Nẵng tháng 11/2026: FourS Tower F1, F5, The Camellia Sơn Trà, FPT Plaza 4, Sun Saphia Residence, Cora Tower, Symphony 5 – diện tích, giá, sở hữu, bàn giao.',
		'keyword'  => 'căn hộ dưới 3 tỷ',
		'keywords_extra' => array( 'căn hộ Đà Nẵng giá rẻ', 'căn hộ Đà Nẵng 2 tỷ', 'mua căn hộ Đà Nẵng dưới 3 tỷ' ),
		'schedule' => '2026-11-17 09:00',
		'rev'      => 2,
		'category' => 'Thị trường',
		'tags'     => array( 'Căn hộ Đà Nẵng', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/fours-tower/fours-tower-phoi-canh-4-thap.jpg',
		'image_alt' => 'Phối cảnh 4 tháp FourS Tower, Ngũ Hành Sơn, Đà Nẵng (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Căn hộ dưới 3 tỷ Đà Nẵng (11/2026):</strong> hiện có 7 dự án đang bán có căn dưới 3 tỷ, chủ yếu là studio và căn 1PN. Rẻ nhất là <strong>FourS Tower F1</strong> (studio 30,5 m² từ khoảng 1,77 tỷ khi trả sớm), <strong>FourS Tower F5</strong> (studio 34,9 m² từ khoảng 1,96 tỷ) và <strong>The Camellia Sơn Trà</strong> (studio 27,8 – 31,4 m² từ khoảng 1,98 tỷ). Dự án sở hữu lâu dài chiếm 5/7.</p>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Căn dưới 3 tỷ</th><th>Giá (tham khảo)</th><th>Sở hữu</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/fours-tower-f1-thap-tung/">FourS Tower F1</a></td><td>Ngũ Hành Sơn</td><td>Studio 30,5 m²; 1PN+1 53,8 m² (trả sớm)</td><td>1,77 – 2,58 tỷ; 1PN+1 từ 2,89 tỷ</td><td>Lâu dài</td></tr>
<tr><td><a href="/du-an/fours-tower-f5-thap-cuc/">FourS Tower F5</a></td><td>Ngũ Hành Sơn</td><td>Studio 34,9 m²; 1PN+ 45,2 m²; 1PN 46,7 m²</td><td>1,96 – 2,34 tỷ; 1PN+ từ 2,69 tỷ; 1PN 2,91 tỷ</td><td>Lâu dài</td></tr>
<tr><td><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a></td><td>Sơn Trà</td><td>Studio 27,8 – 31,4 m²</td><td>1,98 – 2,64 tỷ</td><td>Lâu dài</td></tr>
<tr><td><a href="/du-an/fpt-plaza-4/">FPT Plaza 4</a></td><td>Ngũ Hành Sơn (FPT City)</td><td>1PN, 1PN+1 45,5 – 50,1 m²; 2PN từ 2,9 tỷ</td><td>Từ khoảng 2,1 tỷ</td><td>Lâu dài</td></tr>
<tr><td><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a></td><td>Ngũ Hành Sơn (biển Sơn Thủy)</td><td>Studio 30 m² tầng 15</td><td>2,13 – 2,85 tỷ (giá dự kiến, chưa VAT, KPBT)</td><td>50 năm</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a></td><td>Hòa Xuân (Sun NeO City)</td><td>Studio 32,3 m²</td><td>2,42 – 2,74 tỷ</td><td>Lâu dài</td></tr>
<tr><td><a href="/du-an/symphony-5-sun-symphony-residence/">Symphony 5</a></td><td>Sơn Trà (bờ Đông sông Hàn)</td><td>Studio 30 – 33 m²</td><td>Từ khoảng 2,50 tỷ</td><td>50 năm</td></tr>
</tbody>
</table>
{$sign}
</div>
<p>Với ngân sách <strong>dưới 3 tỷ</strong>, người mua căn hộ ở Đà Nẵng hiện vẫn có lựa chọn từ ven biển Ngũ Hành Sơn, chân bán đảo Sơn Trà đến bên sông Hàn. Bài này gom các dự án đang bán có căn hộ dưới 3 tỷ, kèm diện tích, pháp lý và thời gian nhận nhà để anh chị so nhanh.</p>
<!--hh-featured-->
<h2>Cách đọc giá căn hộ dưới 3 tỷ Đà Nẵng</h2>
<ul>
<li><strong>FourS Tower F1, F5:</strong> giá thấp là phương án thanh toán sớm, giá cao là phương án vay (theo phiếu tính giá chủ đầu tư). Ví dụ studio F1: 2,12 tỷ khi vay, 1,77 tỷ khi trả sớm (giá tiêu chuẩn 2,01 tỷ).</li>
<li><strong>The Camellia:</strong> giá định hướng toàn dự án, phương án vay hỗ trợ lãi suất; thanh toán sớm 95% studio còn khoảng 1,72 – 2,30 tỷ, căn 1PN+1 (1,5PN) 47 m² còn khoảng 2,85 – 3,58 tỷ.</li>
<li><strong>Sun Saphia Residence:</strong> giá dự kiến của chủ đầu tư ngày 28/10/2026, chưa gồm VAT và kinh phí bảo trì; bảng giá chính thức có khi mở bán.</li>
<li><strong>Cora Tower, Symphony 5:</strong> giỏ hàng 11/2026, đã gồm VAT và phí bảo trì, chưa trừ chiết khấu.</li>
</ul>
<h2>Căn hộ dưới 3 tỷ nhận nhà khi nào</h2>
<table>
<thead><tr><th>Dự án</th><th>Bàn giao / nhận nhà (dự kiến)</th></tr></thead>
<tbody>
<tr><td>Cora Tower</td><td>30/07/2027</td></tr>
<tr><td>FPT Plaza 4</td><td>Quý IV/2027</td></tr>
<tr><td>The Camellia Sơn Trà</td><td>Quý 1/2028</td></tr>
<tr><td>FourS Tower F1, F5</td><td>31/3/2028 (thanh toán 70%)</td></tr>
<tr><td>Symphony 5</td><td>30/06/2028 (thanh toán 70%)</td></tr>
<tr><td>Sun Saphia Residence</td><td>11/2028</td></tr>
</tbody>
</table>
<!--hh-img:img/the-camellia/the-camellia-phoi-canh-hoang-hon-ban-dao.jpg|Căn hộ dưới 3 tỷ ở Sơn Trà: The Camellia lúc hoàng hôn, chân bán đảo Sơn Trà (phối cảnh chủ đầu tư)-->
<h2>Căn hộ dưới 3 tỷ: sở hữu lâu dài hay 50 năm</h2>
<p>Năm dự án (FourS F1, F5, The Camellia, FPT Plaza 4, Cora Tower) là căn hộ sở hữu lâu dài. Sun Saphia Residence và Symphony 5 nằm trên đất thương mại dịch vụ, thời hạn 50 năm, đổi lại có vị trí sát biển hoặc sát sông. Mua để ở lâu dài nên ưu tiên nhóm sở hữu lâu dài; mua cho thuê ngắn ngày thì nhóm 50 năm có lợi thế vị trí. Đọc thêm: <a href="/phap-ly-symphony-5-so-huu-50-nam/">sở hữu 50 năm nghĩa là gì</a>.</p>
<h2>Căn hộ dưới 3 tỷ: studio hay 1PN</h2>
<ul>
<li><strong>Studio 28 – 35 m²:</strong> tổng tiền thấp nhất, dễ cho thuê ngắn ngày, phù hợp người ở một mình.</li>
<li><strong>1PN, 1PN+ 45 – 54 m²:</strong> có phòng ngủ riêng, hợp cặp vợ chồng trẻ hoặc cho thuê dài hạn. Dưới 3 tỷ hiện có ở FourS F1, F5 và The Camellia (khi thanh toán sớm) và FPT Plaza 4.</li>
</ul>
<!--hh-img:img/fpt-plaza-4/fpt-plaza-4-ho-boi-tang-20-thu-gian.jpg|Hồ bơi tầng 20 FPT Plaza 4 (phối cảnh chủ đầu tư)-->
<h2>Lưu ý khi mua căn hộ dưới 3 tỷ</h2>
<ol>
<li>So theo tổng tiền thực trả sau chiết khấu, đã gồm VAT và phí bảo trì.</li>
<li>Kiểm tra căn trả sớm và căn vay có cùng giá tiêu chuẩn không.</li>
<li>Hỏi phí quản lý hằng tháng và chi phí hoàn thiện nội thất (studio bàn giao thô cần thêm tiền làm nội thất).</li>
<li>Giỏ hàng giá thấp hết nhanh: nên giữ chỗ khi đã chọn được căn.</li>
</ol>
<p>Xem thêm: <a href="/mat-bang-gia-can-ho-da-nang-11-2026/">mặt bằng giá căn hộ Đà Nẵng tháng 11/2026</a>.</p>
<h2>Căn hộ dưới 3 tỷ: cần chuẩn bị bao nhiêu vốn</h2>
<p>Với phần lớn dự án trong danh sách, ngân hàng cho vay tối đa 70% giá trị căn. Ví dụ một căn hộ dưới 3 tỷ giá 2,5 tỷ: nếu vay 70% (khoảng 1,75 tỷ), vốn tự có khoảng 750 triệu, đóng dần theo tiến độ (Hoàng Hiệp tự tính, chưa trừ chiết khấu). Nếu căn bàn giao thô như Symphony 5, cộng thêm chi phí hoàn thiện; nếu giá chưa gồm VAT và kinh phí bảo trì như giá dự kiến Sun Saphia, cộng thêm hai khoản này.</p>
<p>Nhóm căn hộ dưới 3 tỷ ở Đà Nẵng phần lớn đến từ các tòa mới của Sun Group ở Nam Đà Nẵng; việc ra mắt bốn tháp FourS Tower từng được <a href="https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm">Tuổi Trẻ</a> và <a href="https://vnexpress.net/sun-group-ra-mat-khu-can-ho-fours-tower-tai-nam-da-nang-5052323.html">VnExpress</a> đưa tin. Xem thêm các khoản ngoài giá bán: <a href="/chi-phi-khi-mua-can-ho-moi-ngoai-gia-ban/">chi phí khi mua căn hộ mới</a>.</p>
<p>Giá trong bài là giá tham khảo tại thời điểm cập nhật; giỏ hàng giá thấp thay đổi nhanh theo từng đợt mở bán.</p>
<p>Muốn so sánh hai dự án studio 50 năm: <a href="/sun-saphia-hay-symphony-5-mua-studio-cho-thue/">Sun Saphia hay Symphony 5</a>.</p>
{$cta('các dự án dưới 3 tỷ')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ dưới 3 tỷ Đà Nẵng: 7 dự án đang bán (11/2026)',
			'desc'      => 'Căn hộ dưới 3 tỷ Đà Nẵng 11/2026: FourS F1, F5 studio từ 1,77 – 1,96 tỷ, The Camellia từ 1,98 tỷ, FPT Plaza 4 từ 2,1 tỷ, Cora, Symphony 5.',
			'points'    => array(
				'Căn hộ dưới 3 tỷ: 7 dự án đang bán, chủ yếu studio và 1PN',
				'Rẻ nhất: FourS F1 studio từ 1,77 tỷ (trả sớm), F5 từ 1,96 tỷ, The Camellia từ 1,98 tỷ',
				'5/7 dự án sở hữu lâu dài; Sun Saphia, Symphony 5 sở hữu 50 năm',
			),
			'faq'       => array(
				array( 'Đà Nẵng còn căn hộ dưới 3 tỷ không?', 'Còn. Tháng 11/2026 có 7 dự án đang bán có căn dưới 3 tỷ: FourS Tower F1, F5, The Camellia Sơn Trà, FPT Plaza 4, Sun Saphia Residence, Cora Tower và Symphony 5, chủ yếu là studio và 1PN.' ),
				array( 'Căn hộ rẻ nhất Đà Nẵng hiện nay bao nhiêu?', 'Trong các dự án mới đang bán, studio FourS Tower F1 30,5 m² từ khoảng 1,77 tỷ khi thanh toán sớm (2,12 tỷ khi vay).' ),
				array( 'Dưới 3 tỷ mua được căn 1 phòng ngủ ở Đà Nẵng không?', 'Được, ở FourS Tower F1, F5 và The Camellia Sơn Trà (khi thanh toán sớm) và FPT Plaza 4 (1PN từ khoảng 2,1 tỷ).' ),
				array( 'Căn hộ dưới 3 tỷ nào sở hữu lâu dài?', 'FourS Tower F1, F5, The Camellia Sơn Trà, FPT Plaza 4 và Cora Tower. Sun Saphia Residence và Symphony 5 có thời hạn 50 năm.' ),
				array( 'Mua căn hộ dưới 3 tỷ cần bao nhiêu vốn tự có?', 'Nếu vay 70%, căn 2,5 tỷ cần khoảng 750 triệu vốn tự có, đóng dần theo tiến độ (ước tính, chưa trừ chiết khấu). Cộng thêm chi phí hoàn thiện nếu căn bàn giao thô.' ),
			),
		),
		'sources'  => array( 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm', 'https://vnexpress.net/sun-group-ra-mat-khu-can-ho-fours-tower-tai-nam-da-nang-5052323.html' ),
	);

	return $posts;
}
