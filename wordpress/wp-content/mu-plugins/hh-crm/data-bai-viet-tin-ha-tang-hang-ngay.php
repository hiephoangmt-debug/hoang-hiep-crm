<?php
/**
 * Bản tin hạ tầng – quy hoạch – chính sách Đà Nẵng hằng ngày (routine tự viết).
 * Không nạp trong plugin – xuất bằng scripts/xuat-bai-tu-dong.php vào wordpress/tu-dong/.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tin_ha_tang_hang_ngay' );
function hh_posts_tin_ha_tang_hang_ngay( $posts ) {
	$cta = '<p>Cần kiểm tra quy hoạch, pháp lý một lô đất hoặc so sánh dự án dọc trục Đà Nẵng – Chu Lai, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 05/11 – Thời hạn khởi công 3 khu đô thị tại Chu Lai ---------------- */
	$posts[] = array(
		'slug'           => 'da-nang-an-dinh-thoi-han-khoi-cong-3-khu-do-thi-chu-lai',
		'title'          => 'Đà Nẵng ấn định thời hạn khởi công 3 khu đô thị hơn 40.400 tỷ tại Chu Lai',
		'excerpt'        => 'Ba dự án khu đô thị tại Khu kinh tế mở Chu Lai với tổng vốn hơn 40.400 tỷ đồng được yêu cầu khởi công chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô từng dự án và tác động tới đất nền phía Nam Đà Nẵng.',
		'keyword'        => 'khu đô thị Chu Lai',
		'keywords_extra' => array( 'Khu kinh tế mở Chu Lai', 'khu đô thị ven sông Trường Giang', 'bất động sản Núi Thành', 'hạ tầng Đà Nẵng 2026' ),
		'project'        => 'vinh-an-hoa-city',
		'schedule'       => '2026-11-05 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Chu Lai', 'Quy hoạch' ),
		'image'          => 'plugin:img/tin-tuc/khoi-cong-3-khu-do-thi-chu-lai-11-2026.jpg',
		'image_alt'      => 'Thời hạn khởi công 3 khu đô thị tại Khu kinh tế mở Chu Lai, Đà Nẵng',
		'image_caption'  => 'Tóm tắt 3 dự án và thời hạn khởi công (Hoàng Hiệp vẽ, sơ đồ không theo tỷ lệ).',
		'content'        => <<<HTML
<p>Ngày 4/11/2026, tại buổi làm việc với Ban Quản lý Khu kinh tế mở Chu Lai, Phó Chủ tịch UBND TP Đà Nẵng Phan Thái Bình yêu cầu các nhà đầu tư <strong>khởi công 3 dự án khu đô thị</strong> tại Chu Lai đúng thời hạn. Tổng vốn đầu tư của 3 dự án hơn <strong>40.400 tỷ đồng</strong> (Tuổi Trẻ, Báo Đầu tư, 4/11/2026).</p>
<!--hh-featured-->
<h2>3 dự án và thời hạn khởi công</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô – vốn (theo báo chí)</th><th>Thời hạn khởi công</th></tr></thead>
<tbody>
<tr><td>Khu đô thị Chu Lai (xã Núi Thành) – Công ty CP Đầu tư Địa ốc Đại Quang Minh</td><td>Khoảng 188,56 ha, vốn hơn 18.854 tỷ đồng</td><td>Phấn đấu tháng 12/2026, chậm nhất 29/3/2027</td></tr>
<tr><td>Khu đô thị ven sông Trường Giang (Quảng Phú, Bàn Thạch) – Công ty CP Green Industrial Chu Lai</td><td>74,05 ha, vốn hơn 3.069 tỷ đồng, thực hiện 2026 – 2034</td><td>Trước 30/4/2027</td></tr>
<tr><td>Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành</td><td>Phần còn lại của tổng vốn hơn 40.400 tỷ</td><td>Trước 30/4/2027</td></tr>
</tbody>
</table>
<p>Với dự án Khu đô thị Chu Lai, việc ký hợp đồng dự án được báo chí nêu dự kiến vào ngày 9/11/2026. Các mốc trên là yêu cầu của thành phố; tiến độ thực tế còn phụ thuộc giải phóng mặt bằng và thủ tục của từng dự án.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Chu Lai – Núi Thành có thêm nguồn cung đô thị lớn</strong>: gần 263 ha của hai dự án đã công bố quy mô, cạnh sân bay Chu Lai và các khu công nghiệp. Khi khởi công thật, hạ tầng nội khu và đường kết nối sẽ làm rõ giá trị khu vực.</li>
<li><strong>Nguồn cung nhiều cũng là rủi ro</strong>: đất nền phía Nam sẽ cạnh tranh mạnh trong 3 – 5 năm tới. Nên ưu tiên dự án đã có hạ tầng, pháp lý rõ, thay vì mua theo tin "sắp khởi công".</li>
<li><strong>Trục Đà Nẵng – Chu Lai</strong> đang được chú ý cùng với <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">cao tốc nội thị Đà Nẵng – Chu Lai</a>; khi tuyến này triển khai, thời gian từ Chu Lai về trung tâm Đà Nẵng sẽ được rút ngắn.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> (Núi Thành, cạnh sân bay Chu Lai): hưởng lợi trực tiếp nhất khi khu vực có thêm khu đô thị và dân cư mới, nhưng cũng chịu cạnh tranh nguồn cung.</li>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>: thuộc hành lang ven biển phía Nam, cùng được nhắc đến khi trục Đà Nẵng – Chu Lai phát triển.</li>
<li>Khu vực Bàn Thạch – Tam Kỳ (nơi có khu đô thị ven sông Trường Giang) cũng có thêm động lực; xem thông tin tham khảo tại trang <a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a>.</li>
</ul>
<p>Xem thêm: <a href="/mat-cat-cao-toc-noi-thi-da-nang-chu-lai-quy-dat-tod/">mặt cắt và quỹ đất dọc cao tốc nội thị</a>, <a href="/chinh-sach-moi-anh-huong-bat-dong-san-da-nang-11-2026/">chính sách mới ảnh hưởng bất động sản Đà Nẵng 11/2026</a>.</p>
{$cta}
<p class="src">Nguồn: Tuổi Trẻ, Báo Đầu tư, Tiền Phong, Dân trí, CafeF (4/11/2026). Thông tin tham khảo.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Thời hạn khởi công 3 khu đô thị 40.400 tỷ tại Chu Lai',
			'desc'      => 'Đà Nẵng yêu cầu khởi công 3 khu đô thị hơn 40.400 tỷ tại Chu Lai chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô dự án và tác động tới đất nền phía Nam.',
			'points'    => array(
				'Khu đô thị Chu Lai khoảng 188,56 ha, hơn 18.854 tỷ, khởi công chậm nhất 29/3/2027.',
				'Khu đô thị ven sông Trường Giang 74,05 ha, hơn 3.069 tỷ, khởi công trước 30/4/2027.',
				'Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành khởi công trước 30/4/2027.',
				'Tổng vốn 3 dự án hơn 40.400 tỷ đồng.',
			),
			'faq'       => array(
				array( 'Khi nào khởi công Khu đô thị Chu Lai?', 'Thành phố yêu cầu phấn đấu khởi công tháng 12/2026, chậm nhất ngày 29/3/2027 (báo chí 4/11/2026).' ),
				array( 'Khu đô thị ven sông Trường Giang ở đâu?', 'Tại khu vực Quảng Phú và Bàn Thạch, quy mô 74,05 ha, vốn hơn 3.069 tỷ đồng, yêu cầu khởi công trước 30/4/2027.' ),
				array( '3 dự án khu đô thị tại Chu Lai có tổng vốn bao nhiêu?', 'Hơn 40.400 tỷ đồng theo báo chí đưa tin ngày 4/11/2026.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/sap-khoi-cong-3-du-an-tong-von-hon-40460-ti-tai-chu-lai-100261104104348024.htm',
			'https://baodautu.vn/da-nang-an-dinh-thoi-diem-khoi-cong-3-du-an-do-thi-hon-40400-ty-dong-d737415.html',
		),
	);

	/* ---------------- 06/11 – Chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026 ---------------- */
	$posts[] = array(
		'slug'           => 'chinh-sach-ban-hang-du-an-sun-group-da-nang-thang-11-2026',
		'title'          => 'Chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026: Spana, Cora, S-Light, FourS',
		'excerpt'        => 'Tổng hợp chính sách bán hàng tháng 11/2026 của Spana, Cora, S-Light, FourS: chiết khấu không vay 3 – 5%, thanh toán sớm 95% chiết khấu 6 – 10% (hạn 25/11), vay tối đa 70% hỗ trợ lãi suất 24 tháng, Sun Early Key trả 70% nhận nhà.',
		'keyword'        => 'chính sách bán hàng Sun Group Đà Nẵng',
		'keywords_extra' => array( 'chính sách Spana Tower', 'chính sách Cora Tower', 'chính sách S-Light Tower', 'chính sách FourS Tower' ),
		'project'        => 'sun-neo-city',
		'schedule'       => '2026-11-06 15:30',
		'category'       => 'Dự án',
		'tags'           => array( 'Sun Group', 'Chính sách bán hàng', 'Căn hộ Đà Nẵng' ),
		'image'          => 'plugin:img/tin-tuc/chinh-sach-ban-hang-sun-da-nang-11-2026.jpg',
		'image_alt'      => 'Bảng tóm tắt chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026',
		'content'        => <<<HTML
<p>Hoàng Hiệp tổng hợp chính sách bán hàng đang áp dụng tháng 11/2026 của các dự án căn hộ Sun Group tại Đà Nẵng: <a href="/du-an/spana-tower/">Spana Tower</a>, <a href="/du-an/cora-tower/">Cora Tower</a>, <a href="/du-an/s-light-tower/">S-Light Tower</a> (khu Sun NeO City, Hòa Xuân) và FourS Tower (Sun Riverpolis). Mức chiết khấu thanh toán sớm thay đổi theo tháng – bảng dưới là mức có hạn đến <strong>25/11/2026</strong>.</p>
<!--hh-featured-->
<h2>Bảng so sánh nhanh</h2>
<table>
<thead><tr><th>Dự án</th><th>Ưu đãi riêng</th><th>Không vay</th><th>TT sớm 95% / 70%</th><th>Hỗ trợ lãi suất</th><th>Giãn tiến độ</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a></td><td>Quà tặng an cư 3%</td><td>5%</td><td>6% / 1%</td><td>24 tháng (đến 30/6/2028)</td><td>38 tháng</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a> căn hộ</td><td>Hoàn thiện nội thất 7%</td><td>5%</td><td>7,5% / 1,5%</td><td>24 tháng (đến 30/9/2028)</td><td>40 tháng</td></tr>
<tr><td>Cora Tower shop khối đế</td><td>Nội thất kinh doanh 4%</td><td>5%</td><td>7,5% / 1,5%</td><td>24 tháng (đến 30/9/2028)</td><td>40 tháng</td></tr>
<tr><td><a href="/du-an/s-light-tower/">S-Light Tower</a> (cả penthouse)</td><td>–</td><td>3%</td><td>10% / 3%</td><td>24 tháng (đến 30/9/2028)</td><td>48 tháng</td></tr>
<tr><td>FourS F1, F5</td><td>Hoàn thiện nội thất 7%</td><td>5%</td><td>9% / 2,5%</td><td>24 tháng (đến 31/10/2028)</td><td>45 tháng</td></tr>
<tr><td>FourS F2</td><td>Quà nội thất 35 – 100 triệu</td><td>3%</td><td>Liên hệ (mức tháng 11 chưa công bố)</td><td>24 tháng (đến 31/1/2029)</td><td>45 tháng</td></tr>
</tbody>
</table>
<p>Chiết khấu tính trên giá chưa VAT và phí bảo trì. Gói thanh toán sớm không áp dụng cùng gói vay.</p>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg|Spana Tower thực tế tháng 11/2026 – hai tòa bên sông Cẩm Lệ, chân cầu Hòa Xuân (ảnh flycam)-->
<h2>Điểm chung của các dự án</h2>
<ul>
<li><strong>Hình thức ký:</strong> ký hợp đồng thực hiện nguyện vọng trước, hợp đồng mua bán sau.</li>
<li><strong>Vay ngân hàng</strong> tối đa 70%, chủ đầu tư hỗ trợ lãi suất và ân hạn nợ gốc cùng thời gian; trong thời gian hỗ trợ được trả nợ trước hạn miễn phí.</li>
<li><strong>Sun Early Key:</strong> thanh toán đủ 70% (gồm VAT) là được nhận nhà sử dụng.</li>
<li><strong>Trả trước hạn từng đợt</strong> (sớm ít nhất 10 ngày) được hưởng lãi 8%/năm; 5% cuối đóng khi bàn giao, chủ đầu tư trả lãi 8%/năm trên khoản này.</li>
<li><strong>Miễn phí quản lý</strong> 1 năm (FourS F2: 2 năm). Khách đã mua sản phẩm Sun được cộng điểm thưởng hoặc chiết khấu thêm theo hạng thành viên.</li>
</ul>
<h2>Đặt cọc và bàn giao dự kiến</h2>
<table>
<thead><tr><th>Dự án</th><th>Đặt cọc</th><th>Nhận nhà (Early Key) dự kiến</th></tr></thead>
<tbody>
<tr><td>Spana Tower</td><td>100 triệu (3PN 150 triệu)</td><td>30/6/2027</td></tr>
<tr><td>Cora Tower</td><td>100 triệu (3PN 150 triệu, penthouse và shop 300 triệu)</td><td>31/10/2027</td></tr>
<tr><td>S-Light Tower</td><td>Studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu, penthouse 300 triệu</td><td>30/6/2028</td></tr>
<tr><td>FourS F1, F5</td><td>100 triệu (3PN 150 triệu)</td><td>31/3/2028</td></tr>
<tr><td>FourS F2</td><td>100 triệu (3PN 150 triệu)</td><td>31/5/2028</td></tr>
</tbody>
</table>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-nhin-tu-cau-hoa-xuan.jpg|Spana Tower nhìn từ cầu Hòa Xuân, tháng 11/2026 (ảnh flycam thực tế)-->
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Nếu có sẵn vốn, gói thanh toán sớm 95% tháng này cao nhất ở S-Light (10%) và FourS F1, F5 (9%) – nhưng cần so với lãi tiền gửi trong thời gian chờ nhận nhà. Nếu cần đòn bẩy, cả 4 dự án đều hỗ trợ lãi suất 24 tháng, nên chọn theo mốc nhận nhà sớm (Spana 6/2027, Cora 10/2027) để sớm cho thuê. Chính sách đổi theo từng đợt; nên lấy phiếu tính giá căn cụ thể trước khi quyết định.</p>
<p>Nhận phiếu tính giá, so sánh dòng tiền vay và thanh toán sớm từng dự án: liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: chính sách bán hàng chủ đầu tư (CSƯĐ 03 Spana 06/2026, CSƯĐ 06/06.1 Cora 08/2026, CSBH 01 S-Light 07 – 08/2026, CSBH 04 và 4.2 FourS 08 – 09/2026) và mức thanh toán sớm tháng 11/2026. Thông tin tham khảo, có thể thay đổi.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Chính sách bán hàng Sun Group Đà Nẵng tháng 11/2026',
			'desc'      => 'Chính sách tháng 11/2026 Spana, Cora, S-Light, FourS: không vay chiết khấu 3 – 5%, TT sớm 95% chiết khấu 6 – 10%, hỗ trợ lãi suất 24 tháng, trả 70% nhận nhà.',
			'points'    => array(
				'Không vay ngân hàng: chiết khấu 5% (Spana, Cora, FourS F1/F5), 3% (S-Light, FourS F2).',
				'Thanh toán sớm 95% tháng 11 (hạn 25/11): Spana 6%, Cora 7,5%, FourS F1/F5 9%, S-Light 10%.',
				'Vay tối đa 70%, hỗ trợ lãi suất 24 tháng, ân hạn gốc cùng thời gian.',
				'Sun Early Key: thanh toán 70% là nhận nhà sử dụng.',
			),
			'faq'       => array(
				array( 'Mua Spana, Cora, S-Light không vay được chiết khấu bao nhiêu?', 'Spana và Cora chiết khấu 5%, S-Light 3% trên giá chưa VAT và phí bảo trì (chính sách 11/2026).' ),
				array( 'Thanh toán sớm 95% được chiết khấu bao nhiêu?', 'Mức tháng 11/2026 (hạn 25/11): Spana 6%, Cora 7,5%, FourS F1/F5 9%, S-Light 10%; FourS F2 liên hệ để cập nhật.' ),
				array( 'Dự án Sun Đà Nẵng hỗ trợ lãi suất bao lâu?', 'Spana, Cora, S-Light, FourS hỗ trợ lãi suất 24 tháng trên khoản vay tối đa 70%, ân hạn nợ gốc cùng thời gian.' ),
			),
		),
		'sources'        => array(),
	);


	/* ---------------- 06/11 – Tổ hợp 25 tầng 16 Bạch Đằng + tiêu chí gỡ dự án tồn đọng ---------------- */
	$posts[] = array(
		'slug'           => 'da-nang-chap-thuan-to-hop-25-tang-16-bach-dang-go-du-an-ton-dong',
		'title'          => 'Đà Nẵng chấp thuận tổ hợp khách sạn – căn hộ du lịch 25 tầng tại 16 Bạch Đằng, đặt 3 tiêu chí tài chính để gỡ dự án tồn đọng',
		'excerpt'        => 'UBND TP Đà Nẵng chấp thuận quy hoạch tổng mặt bằng tổ hợp 25 tầng nổi, 4 tầng hầm tại 16 Bạch Đằng (QĐ 5050/QĐ-UBND ngày 3/11/2026); công văn ngày 5/11 nêu 3 tiêu chí đánh giá năng lực tài chính nhà đầu tư khi tháo gỡ dự án tồn đọng.',
		'keyword'        => '16 Bạch Đằng Đà Nẵng',
		'keywords_extra' => array( 'tổ hợp khách sạn 16 Bạch Đằng', 'dự án tồn đọng Đà Nẵng', 'căn hộ du lịch Đà Nẵng', 'ven sông Hàn' ),
		'project'        => 'sun-ponte-residence',
		'schedule'       => '2026-11-06 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch Đà Nẵng', 'Sông Hàn', 'Dự án tồn đọng' ),
		'image'          => 'plugin:img/tin-tuc/to-hop-16-bach-dang-du-an-ton-dong-11-2026.jpg',
		'image_alt'      => 'Tổ hợp 25 tầng tại 16 Bạch Đằng, Đà Nẵng và 3 tiêu chí tài chính gỡ dự án tồn đọng – hình minh hoạ',
		'content'        => <<<HTML
<p>Đầu tháng 11/2026, Đà Nẵng có hai văn bản đáng chú ý với thị trường bất động sản: chấp thuận quy hoạch một tổ hợp cao tầng trên khu "đất vàng" ven sông Hàn, và đặt tiêu chí cụ thể để tháo gỡ các dự án tồn đọng, kéo dài.</p>
<!--hh-featured-->
<h2>Tổ hợp 25 tầng tại 16 Bạch Đằng</h2>
<p>UBND thành phố ban hành <strong>Quyết định 5050/QĐ-UBND ngày 3/11/2026</strong> chấp thuận quy hoạch tổng mặt bằng tổ hợp thương mại dịch vụ, văn phòng kết hợp khách sạn và căn hộ du lịch cao cấp tại <strong>số 16 Bạch Đằng, phường Hải Châu</strong>.</p>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Diện tích khu đất</td><td>1.795 m²</td></tr>
<tr><td>Quy mô</td><td>25 tầng nổi, 4 tầng hầm, cao 99 m</td></tr>
<tr><td>Tổng diện tích sàn xây dựng</td><td>30.430,56 m²</td></tr>
<tr><td>Chức năng</td><td>Thương mại dịch vụ, văn phòng, khách sạn, căn hộ du lịch</td></tr>
<tr><td>Đơn vị thực hiện</td><td>Công ty CP Dịch vụ Phúc Tín – trúng đấu giá khu đất với giá hơn 359,6 tỷ đồng</td></tr>
</tbody>
</table>
<p>Sở Xây dựng hướng dẫn, quản lý quy hoạch theo hồ sơ được chấp thuận; UBND phường Hải Châu công bố công khai quy hoạch và giám sát triển khai. Doanh nghiệp tiếp tục làm các thủ tục đầu tư, xây dựng theo quy định – chưa có thông tin về thời điểm khởi công hay mở bán.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Sông Hàn và cầu Rồng nhìn từ trên cao, tháng 11/2026 (ảnh flycam thực tế)-->
<h2>3 tiêu chí tài chính khi gỡ dự án tồn đọng</h2>
<p>Ngày 5/11/2026, Phó Chủ tịch UBND thành phố Trần Nam Hưng ký công văn triển khai kết luận cuộc họp ngày 27/10 về tháo gỡ các dự án tồn đọng, kéo dài. Theo báo chí đưa tin:</p>
<ul>
<li>Năng lực nhà đầu tư được rà soát theo <strong>3 tiêu chí</strong>: vốn chủ sở hữu; tỷ lệ dư nợ tín dụng và dư nợ trái phiếu doanh nghiệp trên vốn chủ sở hữu; khả năng huy động vốn.</li>
<li>Nhà đầu tư có nhiều dự án được đề nghị dồn vốn chủ sở hữu cho dự án cần ưu tiên tháo gỡ trước.</li>
<li>Doanh nghiệp chưa hoàn thành nghĩa vụ tài chính có 2 phương án xử lý, trong đó thời hạn nộp dần không quá 12 tháng kể từ ngày có văn bản chấp nhận.</li>
<li>Sở Xây dựng hướng dẫn chủ đầu tư thuê tư vấn xác định khối lượng đã đầu tư thực tế; Sở Tài chính làm đầu mối rà soát phương án xử lý.</li>
</ul>
<p>Một hiệp hội doanh nghiệp góp ý rằng dùng báo cáo tài chính gần nhất để đánh giá năng lực là chưa phù hợp với dự án đã bị "đóng băng" lâu, và kiến nghị cho nhà đầu tư chứng minh bằng phương án tài chính tái khởi động dự án.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<p>Quỹ đất trung tâm ven sông Hàn gần như không còn, nên mỗi khu đất như 16 Bạch Đằng được đấu giá và lên quy hoạch cao tầng đều củng cố mặt bằng giá của dải căn hộ, khách sạn quanh trục Bạch Đằng – Trần Hưng Đạo. Tuy nhiên dự án mới chỉ ở bước chấp thuận tổng mặt bằng; người mua nên theo dõi pháp lý từng bước trước khi quan tâm sản phẩm.</p>
<p>Với dự án tồn đọng, tiêu chí tài chính rõ ràng giúp phân loại nhanh dự án nào đủ sức tái khởi động, dự án nào phải thu hồi hoặc chuyển nhượng. Người đang góp vốn, đặt cọc ở dự án chậm triển khai nên hỏi chủ đầu tư đã nộp hồ sơ rà soát chưa và thuộc phương án nào.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> – bờ Đông sông Hàn, cạnh cầu Rồng: cùng nhóm căn hộ ven sông Hàn, nguồn cung trung tâm hạn chế giúp giữ giá cho thuê, chuyển nhượng.</li>
<li><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> – tổ hợp ven sông Hàn (Sơn Trà), nhóm sản phẩm ven sông cạnh tranh trực tiếp với các tổ hợp cao tầng mới ở bờ Tây.</li>
<li><a href="/du-an/da-nang-downtown/">Đà Nẵng Downtown</a> – siêu tổ hợp ven sông Hàn của Sun Group ở Hải Châu, cùng xu hướng phát triển khách sạn – căn hộ cao tầng dọc sông.</li>
</ul>
<p>Cần so sánh căn hộ ven sông Hàn đang bàn giao hoặc đang bán, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Báo Đà Nẵng, Báo Đầu tư, Pháp luật (congly.vn) về QĐ 5050/QĐ-UBND ngày 3/11/2026; Tuổi Trẻ, Báo Đà Nẵng, Báo Xây dựng về công văn ngày 5/11/2026 tháo gỡ dự án tồn đọng. Nội dung theo báo chí, chưa đối chiếu toàn văn văn bản.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Tổ hợp 25 tầng 16 Bạch Đằng, gỡ dự án tồn đọng',
			'desc'      => 'Đà Nẵng chấp thuận quy hoạch tổ hợp 25 tầng tại 16 Bạch Đằng (QĐ 5050 ngày 3/11/2026) và đặt 3 tiêu chí tài chính để tháo gỡ dự án tồn đọng.',
			'points'    => array(
				'16 Bạch Đằng: khu đất 1.795 m², 25 tầng nổi, 4 hầm, cao 99 m, sàn 30.430,56 m².',
				'Chức năng thương mại, văn phòng, khách sạn, căn hộ du lịch; Phúc Tín trúng đấu giá hơn 359,6 tỷ.',
				'Dự án tồn đọng: rà soát vốn chủ sở hữu, tỷ lệ dư nợ/vốn chủ, khả năng huy động vốn.',
				'Nợ nghĩa vụ tài chính: có phương án nộp dần tối đa 12 tháng.',
			),
			'faq'       => array(
				array( 'Dự án 16 Bạch Đằng Đà Nẵng cao bao nhiêu tầng?', '25 tầng nổi, 4 tầng hầm, cao 99 m, tổng diện tích sàn 30.430,56 m² trên khu đất 1.795 m², theo QĐ 5050/QĐ-UBND ngày 3/11/2026.' ),
				array( 'Ai thực hiện dự án 16 Bạch Đằng?', 'Công ty CP Dịch vụ Phúc Tín, đơn vị trúng đấu giá khu đất với giá hơn 359,6 tỷ đồng.' ),
				array( 'Đà Nẵng đánh giá năng lực nhà đầu tư dự án tồn đọng thế nào?', 'Theo 3 tiêu chí: vốn chủ sở hữu; tỷ lệ dư nợ tín dụng và trái phiếu trên vốn chủ sở hữu; khả năng huy động vốn.' ),
			),
		),
		'sources'        => array(
			'https://baodanang.vn/chap-thuan-quy-hoach-to-hop-thuong-mai-dich-vu-khach-san-va-can-ho-du-lich-cao-cap-3357465.html',
			'https://baodautu.vn/da-nang-quy-hoach-to-hop-thuong-mai-can-ho-du-lich-cao-cap-tai-khu-dat-16-bach-dang-d736995.html',
			'https://congly.vn/da-nang-chap-thuan-quy-hoach-to-hop-khach-san-25-tang-tai-khu-dat-vang-16-bach-dang-546166.html',
			'https://tuoitre.vn/da-nang-co-quyet-dinh-quan-trong-go-kho-cho-du-an-ton-dong-keo-dai-100261105130036738.htm',
			'https://baodanang.vn/da-nang-ra-soat-nang-luc-nha-dau-tu-thao-go-vuong-mac-cac-du-an-ton-dong-3357518.html',
			'https://batdongsan.baoxaydung.vn/da-nang-go-kho-khan-du-an-bat-dong-san-ton-dong-ra-soat-nang-luc-tai-chinh-nha-dau-tu-192261105122600444.htm',
		),
	);

	return $posts;
}
