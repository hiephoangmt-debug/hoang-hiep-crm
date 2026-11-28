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
		'slug'           => 'khoi-cong-3-khu-do-thi-chu-lai-40400-ty',
		'old_slug'       => array( 'da-nang-an-dinh-thoi-han-khoi-cong-3-khu-do-thi-chu-lai' ),
		'title'          => 'Đà Nẵng ấn định thời hạn khởi công 3 khu đô thị hơn 40.400 tỷ tại Chu Lai',
		'excerpt'        => 'Ba dự án khu đô thị tại Khu kinh tế mở Chu Lai với tổng vốn hơn 40.400 tỷ đồng được yêu cầu khởi công chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô từng dự án và tác động tới đất nền phía Nam Đà Nẵng.',
		'keyword'        => 'khu đô thị Chu Lai',
		'keywords_extra' => array( 'Khu kinh tế mở Chu Lai', 'khu đô thị ven sông Trường Giang', 'bất động sản Núi Thành', 'hạ tầng Đà Nẵng 2026' ),
		'project'        => 'vinh-an-hoa-city',
		'schedule'       => '2026-11-05 08:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Chu Lai', 'Quy hoạch' ),
		'image'          => 'plugin:img/tin-tuc/khoi-cong-3-khu-do-thi-chu-lai-11-2026.jpg',
		'image_alt'      => 'Thời hạn khởi công 3 khu đô thị Chu Lai tại Khu kinh tế mở Chu Lai, Đà Nẵng',
		'image_caption'  => 'Tóm tắt 3 dự án và thời hạn khởi công (Hoàng Hiệp vẽ, sơ đồ không theo tỷ lệ).',
		'content'        => <<<HTML
<p>Ba dự án <strong>khu đô thị Chu Lai</strong> vừa được Đà Nẵng ấn định thời hạn khởi công. Ngày 4/11/2026, tại buổi làm việc với Ban Quản lý Khu kinh tế mở Chu Lai, Phó Chủ tịch UBND TP Đà Nẵng Phan Thái Bình yêu cầu các nhà đầu tư khởi công đúng hạn. Tổng vốn đầu tư của 3 dự án hơn <strong>40.400 tỷ đồng</strong> (<a href="https://tuoitre.vn/sap-khoi-cong-3-du-an-tong-von-hon-40460-ti-tai-chu-lai-100261104104348024.htm">Tuổi Trẻ</a>, <a href="https://baodautu.vn/da-nang-an-dinh-thoi-diem-khoi-cong-3-du-an-do-thi-hon-40400-ty-dong-d737415.html">Báo Đầu tư</a>, 4/11/2026).</p>
<!--hh-featured-->
<h2>3 dự án khu đô thị Chu Lai và thời hạn khởi công</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô – vốn (theo báo chí)</th><th>Thời hạn khởi công</th></tr></thead>
<tbody>
<tr><td>Khu đô thị Chu Lai (xã Núi Thành) – Công ty CP Đầu tư Địa ốc Đại Quang Minh</td><td>Khoảng 188,56 ha, vốn hơn 18.854 tỷ đồng</td><td>Phấn đấu tháng 12/2026, chậm nhất 29/3/2027</td></tr>
<tr><td>Khu đô thị ven sông Trường Giang (Quảng Phú, Bàn Thạch) – Công ty CP Green Industrial Chu Lai</td><td>74,05 ha, vốn hơn 3.069 tỷ đồng, thực hiện 2026 – 2034</td><td>Trước 30/4/2027</td></tr>
<tr><td>Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành</td><td>Phần còn lại của tổng vốn hơn 40.400 tỷ</td><td>Trước 30/4/2027</td></tr>
</tbody>
</table>
<p>Với dự án lớn nhất – khu đô thị Chu Lai tại xã Núi Thành – việc ký hợp đồng dự án được báo chí nêu dự kiến vào ngày 9/11/2026. Các mốc trên là yêu cầu của thành phố; tiến độ thực tế còn phụ thuộc giải phóng mặt bằng và thủ tục của từng dự án.</p>
<h2>Vì sao khu đô thị Chu Lai được chú ý?</h2>
<p>Chu Lai là vùng có sân bay, cảng biển và các khu công nghiệp lớn ở phía Nam thành phố, nhưng phần đô thị – nhà ở, thương mại, dịch vụ – phát triển chậm hơn công nghiệp. Ba dự án khu đô thị Chu Lai lần này nếu triển khai đúng hạn sẽ bổ sung quỹ nhà ở cho người lao động, chuyên gia và gia đình đang làm việc trong khu kinh tế. Riêng khu đô thị Chu Lai tại Núi Thành có khoảng 17,4 ha nằm trong danh mục quỹ đất phát triển nhà ở xã hội của thành phố (xem <a href="/khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026/">nhà ở xã hội Đà Nẵng</a>).</p>
<p>Điểm cần theo dõi là các mốc sau khởi công: giải phóng mặt bằng, đầu tư hạ tầng kỹ thuật, kết nối với Quốc lộ 1 và tuyến cao tốc nội thị đang chuẩn bị. Khi những mốc này có thật, giá trị khu vực mới được định hình rõ.</p>
<h2>Tác động / nhận định của Hoàng Hiệp về khu đô thị Chu Lai</h2>
<ul>
<li><strong>Chu Lai – Núi Thành có thêm nguồn cung đô thị lớn</strong>: gần 263 ha của hai dự án đã công bố quy mô, cạnh sân bay Chu Lai và các khu công nghiệp. Khi khởi công thật, hạ tầng nội khu và đường kết nối sẽ làm rõ giá trị khu vực.</li>
<li><strong>Nguồn cung nhiều cũng là rủi ro</strong>: đất nền phía Nam sẽ cạnh tranh mạnh trong 3 – 5 năm tới. Nên ưu tiên dự án đã có hạ tầng, pháp lý rõ, thay vì mua theo tin "sắp khởi công".</li>
<li><strong>Trục Đà Nẵng – Chu Lai</strong> đang được chú ý cùng với <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen/">cao tốc nội thị Đà Nẵng – Chu Lai</a>; khi tuyến này triển khai, thời gian từ Chu Lai về trung tâm Đà Nẵng sẽ được rút ngắn.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> (Núi Thành, cạnh sân bay Chu Lai): hưởng lợi trực tiếp nhất khi khu đô thị Chu Lai và dân cư mới hình thành, nhưng cũng chịu cạnh tranh nguồn cung.</li>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>: thuộc hành lang ven biển phía Nam, cùng được nhắc đến khi trục Đà Nẵng – Chu Lai phát triển.</li>
<li>Khu vực Bàn Thạch – Tam Kỳ (nơi có khu đô thị ven sông Trường Giang) cũng có thêm động lực; xem thông tin tham khảo tại trang <a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a>.</li>
</ul>
<p>Xem thêm: <a href="/mat-cat-cao-toc-noi-thi-da-nang-quy-dat-tod/">mặt cắt và quỹ đất dọc cao tốc nội thị</a>, <a href="/chinh-sach-bat-dong-san-da-nang-11-2026/">chính sách mới ảnh hưởng bất động sản Đà Nẵng 11/2026</a>.</p>
{$cta}
<p class="src">Nguồn: Tuổi Trẻ, Báo Đầu tư, Tiền Phong, Dân trí, CafeF (4/11/2026). Thông tin tham khảo.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Khu đô thị Chu Lai: 3 dự án 40.400 tỷ, hạn khởi công 2027',
			'desc'      => 'Đà Nẵng yêu cầu khởi công 3 dự án khu đô thị Chu Lai hơn 40.400 tỷ chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô dự án, tác động tới đất nền phía Nam.',
			'points'    => array(
				'Khu đô thị Chu Lai (Núi Thành) khoảng 188,56 ha, hơn 18.854 tỷ, khởi công chậm nhất 29/3/2027.',
				'Khu đô thị ven sông Trường Giang 74,05 ha, hơn 3.069 tỷ, khởi công trước 30/4/2027.',
				'Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành khởi công trước 30/4/2027.',
				'Tổng vốn 3 dự án hơn 40.400 tỷ đồng.',
			),
			'faq'       => array(
				array( 'Khi nào khởi công Khu đô thị Chu Lai?', 'Thành phố yêu cầu phấn đấu khởi công tháng 12/2026, chậm nhất ngày 29/3/2027 (báo chí 4/11/2026).' ),
				array( 'Khu đô thị ven sông Trường Giang ở đâu?', 'Tại khu vực Quảng Phú và Bàn Thạch, quy mô 74,05 ha, vốn hơn 3.069 tỷ đồng, yêu cầu khởi công trước 30/4/2027.' ),
				array( '3 dự án khu đô thị tại Chu Lai có tổng vốn bao nhiêu?', 'Hơn 40.400 tỷ đồng theo báo chí đưa tin ngày 4/11/2026.' ),
				array( 'Có nên mua đất gần khu đô thị Chu Lai lúc này?', 'Nên chờ các mốc thật như khởi công, giải phóng mặt bằng, hạ tầng kết nối; ưu tiên sản phẩm đã có hạ tầng và pháp lý rõ, kiểm tra quy hoạch thửa đất trước khi đặt cọc.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/sap-khoi-cong-3-du-an-tong-von-hon-40460-ti-tai-chu-lai-100261104104348024.htm',
			'https://baodautu.vn/da-nang-an-dinh-thoi-diem-khoi-cong-3-du-an-do-thi-hon-40400-ty-dong-d737415.html',
		),
	);

	/* ---------------- 06/11 – Chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026 ---------------- */
	$posts[] = array(
		'slug'           => 'chinh-sach-ban-hang-sun-group-da-nang-11-2026',
		'old_slug'       => array( 'chinh-sach-ban-hang-du-an-sun-group-da-nang-thang-11-2026' ),
		'title'          => 'Chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026: Spana, Cora, S-Light, FourS',
		'excerpt'        => 'Tổng hợp chính sách bán hàng tháng 11/2026 của Spana, Cora, S-Light, FourS: chiết khấu không vay 3 – 5%, thanh toán sớm 95% chiết khấu 6 – 10% (hạn 25/11), vay tối đa 70% hỗ trợ lãi suất 24 tháng, Sun Early Key trả 70% nhận nhà.',
		'keyword'        => 'chính sách bán hàng Sun Group',
		'keywords_extra' => array( 'chính sách Spana Tower', 'chính sách Cora Tower', 'chính sách S-Light Tower', 'chính sách FourS Tower' ),
		'project'        => 'sun-neo-city',
		'schedule'       => '2026-11-06 15:30',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Dự án',
		'tags'           => array( 'Sun Group', 'Chính sách bán hàng', 'Căn hộ Đà Nẵng' ),
		'image'          => 'plugin:img/tin-tuc/chinh-sach-ban-hang-sun-da-nang-11-2026.jpg',
		'image_alt'      => 'Bảng tóm tắt chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026',
		'content'        => <<<HTML
<p><strong>Chính sách bán hàng Sun Group</strong> tháng 11/2026 tại Đà Nẵng được Hoàng Hiệp tổng hợp cho các dự án căn hộ: <a href="/du-an/spana-tower/">Spana Tower</a>, <a href="/du-an/cora-tower/">Cora Tower</a>, <a href="/du-an/s-light-tower/">S-Light Tower</a> (khu Sun NeO City, Hòa Xuân) và FourS Tower (Sun Riverpolis). Mức chiết khấu thanh toán sớm thay đổi theo tháng – bảng dưới là mức có hạn đến <strong>25/11/2026</strong>.</p>
<!--hh-featured-->
<h2>Bảng so sánh nhanh chính sách bán hàng Sun Group tháng 11/2026</h2>
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
<p>Trong chính sách bán hàng Sun Group, chiết khấu tính trên giá chưa VAT và phí bảo trì. Gói thanh toán sớm không áp dụng cùng gói vay.</p>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg|Spana Tower – một trong các dự án áp dụng chính sách bán hàng Sun Group tháng 11/2026, hai tòa – hai tòa bên sông Cẩm Lệ, chân cầu Hòa Xuân (ảnh flycam)-->
<h2>Điểm chung trong chính sách bán hàng Sun Group</h2>
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
<h2>Các mốc 70% – 95% theo luật</h2>
<p>Hai mốc lặp lại trong chính sách bán hàng Sun Group – trả 70% để nhận nhà và thanh toán sớm 95% – bám theo giới hạn của <a href="https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Kinh-doanh-bat-dong-san-29-2023-QH15-530116.aspx">Luật Kinh doanh bất động sản 2023</a> với nhà ở hình thành trong tương lai: trước khi bàn giao, chủ đầu tư không thu quá 70% giá trị hợp đồng; trước khi người mua được cấp giấy chứng nhận, không thu quá 95%. Đó là lý do các gói thanh toán sớm trong chính sách bán hàng Sun Group dừng ở mức 95%.</p>
<h2>Ví dụ đọc chính sách bán hàng Sun Group cho một căn 3 tỷ</h2>
<p>Giả sử một căn có giá chưa VAT và phí bảo trì là 3 tỷ đồng (số tròn để minh họa, không phải giá căn cụ thể). Ở dự án chiết khấu không vay 5%, người mua theo tiến độ chuẩn được giảm khoảng 150 triệu. Nếu chọn thanh toán sớm 95% ở dự án có mức 10%, phần giảm thêm tính trên giá còn lại sau các ưu đãi trước – tổng tiết kiệm có thể vài trăm triệu. Đổi lại, người mua phải trả gần hết tiền sớm, nên cần so với lãi tiền gửi trong thời gian chờ nhận nhà. Phiếu tính giá của chủ đầu tư cho từng căn mới là con số chính xác.</p>
<h2>Nhận định của Hoàng Hiệp về chính sách bán hàng Sun Group</h2>
<p>Nếu có sẵn vốn, gói thanh toán sớm 95% tháng này cao nhất ở S-Light (10%) và FourS F1, F5 (9%) – nhưng cần so với lãi tiền gửi trong thời gian chờ nhận nhà. Nếu cần đòn bẩy, cả 4 dự án đều hỗ trợ lãi suất 24 tháng, nên chọn theo mốc nhận nhà sớm (Spana 6/2027, Cora 10/2027) để sớm cho thuê. Chính sách đổi theo từng đợt; nên lấy phiếu tính giá căn cụ thể trước khi quyết định.</p>
<p>Nhận phiếu tính giá theo chính sách bán hàng Sun Group mới nhất, so sánh dòng tiền vay và thanh toán sớm từng dự án: liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: chính sách bán hàng chủ đầu tư (CSƯĐ 03 Spana 06/2026, CSƯĐ 06/06.1 Cora 08/2026, CSBH 01 S-Light 07 – 08/2026, CSBH 04 và 4.2 FourS 08 – 09/2026) và mức thanh toán sớm tháng 11/2026. Thông tin tham khảo, có thể thay đổi.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Chính sách bán hàng Sun Group Đà Nẵng tháng 11/2026',
			'desc'      => 'Chính sách bán hàng Sun Group 11/2026 (Spana, Cora, S-Light, FourS): không vay chiết khấu 3 – 5%, TT sớm 95% chiết khấu 6 – 10%, trả 70% nhận nhà.',
			'points'    => array(
				'Chính sách bán hàng Sun Group 11/2026 – không vay ngân hàng: chiết khấu 5% (Spana, Cora, FourS F1/F5), 3% (S-Light, FourS F2).',
				'Thanh toán sớm 95% tháng 11 (hạn 25/11): Spana 6%, Cora 7,5%, FourS F1/F5 9%, S-Light 10%.',
				'Vay tối đa 70%, hỗ trợ lãi suất 24 tháng, ân hạn gốc cùng thời gian.',
				'Sun Early Key: thanh toán 70% là nhận nhà sử dụng.',
			),
			'faq'       => array(
				array( 'Mua Spana, Cora, S-Light không vay được chiết khấu bao nhiêu?', 'Spana và Cora chiết khấu 5%, S-Light 3% trên giá chưa VAT và phí bảo trì (chính sách 11/2026).' ),
				array( 'Thanh toán sớm 95% được chiết khấu bao nhiêu?', 'Theo chính sách bán hàng Sun Group, mức tháng 11/2026 (hạn 25/11): Spana 6%, Cora 7,5%, FourS F1/F5 9%, S-Light 10%; FourS F2 liên hệ để cập nhật.' ),
				array( 'Chính sách bán hàng Sun Group có cho nhận nhà sớm không?', 'Có. Theo chương trình Sun Early Key, khách thanh toán đủ 70% giá trị (gồm VAT) được nhận nhà sử dụng; mốc nhận nhà dự kiến khác nhau theo từng dự án.' ),
				array( 'Dự án Sun Đà Nẵng hỗ trợ lãi suất bao lâu?', 'Spana, Cora, S-Light, FourS hỗ trợ lãi suất 24 tháng trên khoản vay tối đa 70%, ân hạn nợ gốc cùng thời gian.' ),
			),
		),
		'sources'        => array( 'https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Kinh-doanh-bat-dong-san-29-2023-QH15-530116.aspx' ),
	);
	/* ---------------- 06/11 – Quy hoạch chung đô thị Thăng Điền đến 2050 ---------------- */
	$posts[] = array(
		'slug'           => 'quy-hoach-chung-do-thi-thang-dien-den-2050',
		'title'          => 'Đà Nẵng duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050: hơn 6.158 ha, gần 96.500 dân',
		'excerpt'        => 'Ngày 5/11/2026, Đà Nẵng phê duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến năm 2050 (QĐ 5047/QĐ-UBND): khoảng 6.158,71 ha, dân số dự báo khoảng 96.498 người, định hướng dịch vụ, logistics, công nghiệp sạch.',
		'keyword'        => 'đô thị Thăng Điền',
		'keywords_extra' => array( 'quy hoạch đô thị Thăng Điền', 'xã Thăng Điền Đà Nẵng', 'quy hoạch phía Nam Đà Nẵng', 'Thăng Bình cũ' ),
		'project'        => 'hoiana-resort-golf',
		'schedule'       => '2026-11-06 08:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch Đà Nẵng', 'Thăng Điền', 'Đô thị mới' ),
		'image'          => 'plugin:img/tin-tuc/quy-hoach-chung-do-thi-thang-dien-2050.jpg',
		'image_alt'      => 'Sơ đồ minh hoạ đô thị Thăng Điền giữa Quốc lộ 1, các trục Đông – Tây và biển, quy hoạch chung đến năm 2050',
		'content'        => <<<HTML
<p><strong>Đô thị Thăng Điền</strong> chính thức có nhiệm vụ quy hoạch chung: ngày 5/11/2026, UBND thành phố Đà Nẵng cho biết đã ban hành <strong>Quyết định số 5047/QĐ-UBND</strong> phê duyệt nhiệm vụ <strong>quy hoạch chung đô thị Thăng Điền đến năm 2050</strong>. Đây là bước đầu để định hướng không gian đô thị và thúc đẩy kinh tế khu vực phía Nam thành phố.</p>
<!--hh-featured-->
<h2>Những con số chính của đô thị Thăng Điền</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo nhiệm vụ quy hoạch</th></tr></thead>
<tbody>
<tr><td>Phạm vi</td><td>Toàn bộ địa giới hành chính xã Thăng Điền, hình thành từ việc hợp nhất 3 xã Bình Tú, Bình Trung và Bình An trước đây</td></tr>
<tr><td>Diện tích tự nhiên</td><td>Khoảng 6.158,71 ha</td></tr>
<tr><td>Dân số dự báo năm 2050</td><td>Khoảng 96.498 người (gồm dân số thường trú và dân số quy đổi)</td></tr>
<tr><td>Định hướng chức năng</td><td>Trung tâm dịch vụ, logistics, công nghiệp sạch và nông nghiệp công nghệ cao ở phía Nam Đà Nẵng</td></tr>
<tr><td>Khung không gian</td><td>Quốc lộ 1 và các trục Đông – Tây giữ vai trò quan trọng trong tổ chức không gian</td></tr>
<tr><td>Đơn vị tổ chức lập</td><td>UBND xã Thăng Điền chủ trì, phối hợp các sở, ngành</td></tr>
</tbody>
</table>
<p>Theo quy hoạch chung thành phố, Thăng Điền là một trong 7 đô thị mới dự kiến hình thành đến năm 2050, cùng Duy Nghĩa, Thăng An, Thăng Trường, Tây Hồ, Vu Gia và Hoàng Sa. Đến năm 2050, toàn thành phố có khoảng 30 đô thị (23 đô thị hiện hữu và 7 đô thị mới). Bối cảnh chung xem thêm tại <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng đến 2050</a> (toàn văn <a href="https://thuvienphapluat.vn/van-ban/Xay-dung-Do-thi/Quyet-dinh-2016-QD-TTg-2026-phe-duyet-Quy-hoach-chung-Da-Nang-den-2050-729960.aspx">Quyết định 2016/QĐ-TTg trên Thư viện Pháp luật</a>).</p>
<h2>Nhiệm vụ quy hoạch đô thị Thăng Điền khác đồ án quy hoạch thế nào?</h2>
<p>Nhiều người đọc tin "duyệt quy hoạch" dễ hiểu nhầm là đã có bản đồ phân khu. Thực tế, quy hoạch đô thị thường đi qua hai bước: <strong>nhiệm vụ quy hoạch</strong> xác định phạm vi, mục tiêu, quy mô dân số và yêu cầu nghiên cứu; sau đó mới đến <strong>đồ án quy hoạch chung</strong> với bản đồ sử dụng đất, mạng lưới giao thông, chỉ tiêu từng khu. Đô thị Thăng Điền hiện mới ở bước thứ nhất.</p>
<p>Theo trình tự thông thường, sau khi có nhiệm vụ, đơn vị tư vấn lập đồ án, lấy ý kiến cộng đồng dân cư, trình thẩm định và phê duyệt. Người có đất trong xã nên theo dõi đợt lấy ý kiến đồ án, vì đó là lúc ranh giới các khu chức năng của đô thị Thăng Điền được công bố lần đầu.</p>
<h2>Tác động / nhận định của Hoàng Hiệp về đô thị Thăng Điền</h2>
<ul>
<li><strong>Đô thị Thăng Điền mới có nhiệm vụ quy hoạch:</strong> đây là bước xác định phạm vi, mục tiêu để lập đồ án. Ranh giới khu chức năng, đường quy hoạch và chỉ tiêu sử dụng đất từng khu vực chỉ rõ khi đồ án quy hoạch chung được phê duyệt.</li>
<li><strong>Đất quanh trục Quốc lộ 1 và các tuyến Đông – Tây</strong> được nhắc tới là khung không gian chính, nên thường được quan tâm sớm. Tuy nhiên, khi chưa có đồ án, anh chị nên kiểm tra quy hoạch sử dụng đất hiện hành của từng thửa trước khi giao dịch.</li>
<li><strong>Định hướng logistics, công nghiệp sạch</strong> của đô thị Thăng Điền có thể kéo theo nhu cầu nhà ở cho người lao động và dịch vụ đi kèm trong dài hạn; tiến độ phụ thuộc vào việc lập đồ án và thu hút đầu tư.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Hiện Hoàng Hiệp chưa có dự án nằm trong phạm vi đô thị Thăng Điền. Các dự án cùng hành lang ven biển phía Nam đang có trên web:</p>
<ul>
<li><a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a> – quần thể nghỉ dưỡng ven biển phía Bắc khu vực, cùng hưởng lợi khi hạ tầng và dân cư phía Nam thành phố phát triển.</li>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> – khu đô thị phía Nam, gần Khu kinh tế mở Chu Lai, cùng nằm trong vùng định hướng công nghiệp – logistics.</li>
</ul>
<p>Cần kiểm tra quy hoạch một lô đất cụ thể ở khu vực Thăng Bình cũ, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Quyết định 5047/QĐ-UBND của UBND thành phố Đà Nẵng (theo báo chí đưa tin ngày 5/11/2026: Doanh nghiệp &amp; Hội nhập); số liệu ghi theo nội dung báo chí trích dẫn.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Đô thị Thăng Điền đến 2050: 6.158 ha, gần 96.500 dân',
			'desc'      => 'Đà Nẵng duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050 (QĐ 5047/QĐ-UBND, 5/11/2026): khoảng 6.158,71 ha, dân số dự báo 96.498 người.',
			'points'    => array(
				'QĐ 5047/QĐ-UBND ngày 5/11/2026 phê duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050',
				'Khoảng 6.158,71 ha, gồm 3 xã cũ Bình Tú, Bình Trung, Bình An; dân số dự báo khoảng 96.498 người',
				'Định hướng dịch vụ, logistics, công nghiệp sạch, nông nghiệp công nghệ cao; Quốc lộ 1 và trục Đông – Tây là khung chính',
			),
			'faq'       => array(
				array( 'Đô thị Thăng Điền có phải đô thị mới của Đà Nẵng không?', 'Có. Theo quy hoạch chung thành phố đến 2050, Thăng Điền là một trong 7 đô thị mới dự kiến hình thành, cùng Duy Nghĩa, Thăng An, Thăng Trường, Tây Hồ, Vu Gia và Hoàng Sa.' ),
				array( 'Đô thị Thăng Điền ở đâu?', 'Là xã Thăng Điền thuộc TP Đà Nẵng, hình thành từ việc hợp nhất 3 xã Bình Tú, Bình Trung, Bình An (huyện Thăng Bình cũ), diện tích khoảng 6.158,71 ha.' ),
				array( 'Quy hoạch Thăng Điền đã có bản đồ chi tiết chưa?', 'Chưa. Ngày 5/11/2026 mới phê duyệt nhiệm vụ quy hoạch; ranh giới các khu chức năng chỉ rõ khi đồ án quy hoạch chung được phê duyệt.' ),
				array( 'Thăng Điền được định hướng phát triển gì?', 'Trung tâm dịch vụ, logistics, công nghiệp sạch và nông nghiệp công nghệ cao ở phía Nam Đà Nẵng.' ),
			),
		),
		'sources'        => array( 'https://doanhnghiephoinhap.vn/da-nang-quy-hoach-do-thi-thang-dien-hon-6100ha-dan-so-gan-100000-nguoi-153582.html', 'https://thuvienphapluat.vn/van-ban/Xay-dung-Do-thi/Quyet-dinh-2016-QD-TTg-2026-phe-duyet-Quy-hoach-chung-Da-Nang-den-2050-729960.aspx' ),
	);


	/* ---------------- 06/11 – Tổ hợp 25 tầng 16 Bạch Đằng + tiêu chí gỡ dự án tồn đọng ---------------- */
	$posts[] = array(
		'slug'           => 'to-hop-25-tang-16-bach-dang-da-nang',
		'old_slug'       => array( 'da-nang-chap-thuan-to-hop-25-tang-16-bach-dang-go-du-an-ton-dong' ),
		'title'          => 'Đà Nẵng chấp thuận tổ hợp khách sạn – căn hộ du lịch 25 tầng tại 16 Bạch Đằng, đặt 3 tiêu chí tài chính để gỡ dự án tồn đọng',
		'excerpt'        => 'UBND TP Đà Nẵng chấp thuận quy hoạch tổng mặt bằng tổ hợp 25 tầng nổi, 4 tầng hầm tại 16 Bạch Đằng (QĐ 5050/QĐ-UBND ngày 3/11/2026); công văn ngày 5/11 nêu 3 tiêu chí đánh giá năng lực tài chính nhà đầu tư khi tháo gỡ dự án tồn đọng.',
		'keyword'        => '16 Bạch Đằng Đà Nẵng',
		'keywords_extra' => array( 'tổ hợp khách sạn 16 Bạch Đằng', 'dự án tồn đọng Đà Nẵng', 'căn hộ du lịch Đà Nẵng', 'ven sông Hàn' ),
		'project'        => 'sun-ponte-residence',
		'schedule'       => '2026-11-06 08:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch Đà Nẵng', 'Sông Hàn', 'Dự án tồn đọng' ),
		'image'          => 'plugin:img/tin-tuc/to-hop-16-bach-dang-du-an-ton-dong-11-2026.jpg',
		'image_alt'      => 'Tổ hợp 25 tầng tại 16 Bạch Đằng Đà Nẵng và 3 tiêu chí tài chính gỡ dự án tồn đọng – hình minh hoạ',
		'content'        => <<<HTML
<p>Khu đất <strong>16 Bạch Đằng Đà Nẵng</strong> vừa được chấp thuận quy hoạch tổ hợp 25 tầng. Đầu tháng 11/2026, thành phố có hai văn bản đáng chú ý với thị trường bất động sản: chấp thuận quy hoạch tổ hợp cao tầng trên khu "đất vàng" ven sông Hàn này, và đặt tiêu chí cụ thể để tháo gỡ các dự án tồn đọng, kéo dài.</p>
<!--hh-featured-->
<h2>Tổ hợp 25 tầng tại 16 Bạch Đằng Đà Nẵng</h2>
<p>UBND thành phố ban hành <strong>Quyết định 5050/QĐ-UBND ngày 3/11/2026</strong> chấp thuận quy hoạch tổng mặt bằng tổ hợp thương mại dịch vụ, văn phòng kết hợp khách sạn và căn hộ du lịch cao cấp tại <strong>số 16 Bạch Đằng, phường Hải Châu</strong>.</p>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Diện tích khu đất 16 Bạch Đằng Đà Nẵng</td><td>1.795 m²</td></tr>
<tr><td>Quy mô</td><td>25 tầng nổi, 4 tầng hầm, cao 99 m</td></tr>
<tr><td>Tổng diện tích sàn xây dựng</td><td>30.430,56 m²</td></tr>
<tr><td>Chức năng</td><td>Thương mại dịch vụ, văn phòng, khách sạn, căn hộ du lịch</td></tr>
<tr><td>Đơn vị thực hiện</td><td>Công ty CP Dịch vụ Phúc Tín – trúng đấu giá khu đất với giá hơn 359,6 tỷ đồng</td></tr>
</tbody>
</table>
<p>Sở Xây dựng hướng dẫn, quản lý quy hoạch theo hồ sơ được chấp thuận; UBND phường Hải Châu công bố công khai quy hoạch và giám sát triển khai. Doanh nghiệp tiếp tục làm các thủ tục đầu tư, xây dựng theo quy định – chưa có thông tin về thời điểm khởi công hay mở bán (<a href="https://baodanang.vn/chap-thuan-quy-hoach-to-hop-thuong-mai-dich-vu-khach-san-va-can-ho-du-lich-cao-cap-3357465.html">Báo Đà Nẵng</a>).</p>
<p>Một vài con số giúp hình dung quy mô: tổng sàn 30.430,56 m² trên khu đất 1.795 m² tương ứng khoảng 17 m² sàn trên mỗi m² đất (Hoàng Hiệp chia từ hai số liệu trên, chưa tách phần sàn hầm). Với giá trúng đấu giá hơn 359,6 tỷ đồng, mỗi m² đất tại 16 Bạch Đằng Đà Nẵng có giá khoảng 200 triệu đồng – cho thấy mức giá đất trung tâm ven sông Hàn hiện nay.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Sông Hàn và cầu Rồng nhìn từ trên cao, tháng 11/2026 – khu vực trung tâm có khu đất 16 Bạch Đằng Đà Nẵng ở bờ Tây (ảnh flycam thực tế)-->
<h2>3 tiêu chí tài chính khi gỡ dự án tồn đọng</h2>
<p>Ngày 5/11/2026, Phó Chủ tịch UBND thành phố Trần Nam Hưng ký công văn triển khai kết luận cuộc họp ngày 27/10 về tháo gỡ các dự án tồn đọng, kéo dài. Theo báo chí đưa tin:</p>
<ul>
<li>Năng lực nhà đầu tư được rà soát theo <strong>3 tiêu chí</strong>: vốn chủ sở hữu; tỷ lệ dư nợ tín dụng và dư nợ trái phiếu doanh nghiệp trên vốn chủ sở hữu; khả năng huy động vốn.</li>
<li>Nhà đầu tư có nhiều dự án được đề nghị dồn vốn chủ sở hữu cho dự án cần ưu tiên tháo gỡ trước.</li>
<li>Doanh nghiệp chưa hoàn thành nghĩa vụ tài chính có 2 phương án xử lý, trong đó thời hạn nộp dần không quá 12 tháng kể từ ngày có văn bản chấp nhận.</li>
<li>Sở Xây dựng hướng dẫn chủ đầu tư thuê tư vấn xác định khối lượng đã đầu tư thực tế; Sở Tài chính làm đầu mối rà soát phương án xử lý.</li>
</ul>
<p>Một hiệp hội doanh nghiệp góp ý rằng dùng báo cáo tài chính gần nhất để đánh giá năng lực là chưa phù hợp với dự án đã bị "đóng băng" lâu, và kiến nghị cho nhà đầu tư chứng minh bằng phương án tài chính tái khởi động dự án.</p>
<h2>Tác động / nhận định của Hoàng Hiệp về 16 Bạch Đằng Đà Nẵng</h2>
<p>Quỹ đất trung tâm ven sông Hàn gần như không còn, nên mỗi khu đất như 16 Bạch Đằng Đà Nẵng được đấu giá và lên quy hoạch cao tầng đều củng cố mặt bằng giá của dải căn hộ, khách sạn quanh trục Bạch Đằng – Trần Hưng Đạo. Tuy nhiên dự án mới chỉ ở bước chấp thuận tổng mặt bằng; người mua nên theo dõi pháp lý từng bước trước khi quan tâm sản phẩm.</p>
<p>Với dự án tồn đọng, tiêu chí tài chính rõ ràng giúp phân loại nhanh dự án nào đủ sức tái khởi động, dự án nào phải thu hồi hoặc chuyển nhượng. Người đang góp vốn, đặt cọc ở dự án chậm triển khai nên hỏi chủ đầu tư đã nộp hồ sơ rà soát chưa và thuộc phương án nào.</p>
<h2>Người quan tâm 16 Bạch Đằng Đà Nẵng nên theo dõi gì?</h2>
<ol>
<li><strong>Thủ tục tiếp theo của 16 Bạch Đằng Đà Nẵng:</strong> giấy phép xây dựng, thẩm định thiết kế – chỉ khi có các bước này mới có mốc khởi công.</li>
<li><strong>Loại sản phẩm:</strong> căn hộ du lịch là bất động sản du lịch, pháp lý và thời hạn sở hữu khác căn hộ chung cư để ở.</li>
<li><strong>Điều kiện bán:</strong> căn hộ hình thành trong tương lai chỉ được bán khi đủ điều kiện theo luật; không nên đặt cọc theo lời mời "giữ chỗ sớm" khi dự án mới chấp thuận tổng mặt bằng.</li>
</ol>
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
			'seo_title' => '16 Bạch Đằng Đà Nẵng: tổ hợp 25 tầng, gỡ dự án tồn đọng',
			'desc'      => '16 Bạch Đằng Đà Nẵng được chấp thuận quy hoạch tổ hợp 25 tầng (QĐ 5050 ngày 3/11/2026); thành phố đặt 3 tiêu chí tài chính gỡ dự án tồn đọng.',
			'points'    => array(
				'16 Bạch Đằng Đà Nẵng: khu đất 1.795 m², 25 tầng nổi, 4 hầm, cao 99 m, sàn 30.430,56 m².',
				'Chức năng thương mại, văn phòng, khách sạn, căn hộ du lịch; Phúc Tín trúng đấu giá hơn 359,6 tỷ.',
				'Dự án tồn đọng: rà soát vốn chủ sở hữu, tỷ lệ dư nợ/vốn chủ, khả năng huy động vốn.',
				'Nợ nghĩa vụ tài chính: có phương án nộp dần tối đa 12 tháng.',
			),
			'faq'       => array(
				array( 'Dự án 16 Bạch Đằng Đà Nẵng cao bao nhiêu tầng?', 'Tổ hợp 16 Bạch Đằng Đà Nẵng có 25 tầng nổi, 4 tầng hầm, cao 99 m, tổng diện tích sàn 30.430,56 m² trên khu đất 1.795 m², theo QĐ 5050/QĐ-UBND ngày 3/11/2026.' ),
				array( 'Ai thực hiện dự án 16 Bạch Đằng Đà Nẵng?', 'Công ty CP Dịch vụ Phúc Tín, đơn vị trúng đấu giá khu đất với giá hơn 359,6 tỷ đồng.' ),
				array( 'Khi nào mở bán căn hộ du lịch 16 Bạch Đằng Đà Nẵng?', 'Chưa có thông tin. Dự án mới được chấp thuận quy hoạch tổng mặt bằng; doanh nghiệp còn phải làm các thủ tục đầu tư, xây dựng và chỉ được bán khi đủ điều kiện theo luật.' ),
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

	/* ---------------- 07/11 – 3 khu tái định cư Duy Xuyên phục vụ đường sắt tốc độ cao ---------------- */
	$posts[] = array(
		'slug'           => 'tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty',
		'rev'            => 3, // 15/11: chuẩn SEO 100/100.
		'title'          => 'Đà Nẵng duyệt 3 khu tái định cư hơn 392 tỷ tại Duy Xuyên cho đường sắt tốc độ cao Bắc – Nam',
		'excerpt'        => 'UBND TP Đà Nẵng ban hành Quyết định 5082/QĐ-UBND phê duyệt 3 khu tái định cư Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn (khoảng 31 ha, hơn 392 tỷ đồng, 2026 – 2029) phục vụ giải phóng mặt bằng đường sắt tốc độ cao Bắc – Nam.',
		'keyword'        => 'tái định cư Duy Xuyên',
		'keywords_extra' => array( 'đường sắt tốc độ cao qua Đà Nẵng', 'tái định cư đường sắt tốc độ cao Duy Xuyên', 'Quyết định 5082/QĐ-UBND', 'bất động sản Duy Xuyên' ),
		'project'        => 'nam-hoi-an-city',
		'schedule'       => '2026-11-07 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Đường sắt tốc độ cao', 'Duy Xuyên', 'Tái định cư' ),
		'image'          => 'plugin:img/tin-tuc/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao.jpg',
		'image_alt'      => 'Sơ đồ minh hoạ 3 khu tái định cư Duy Xuyên (Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn) phục vụ đường sắt tốc độ cao Bắc – Nam',
		'content'        => <<<HTML
<p>Ba khu <strong>tái định cư Duy Xuyên</strong> vừa được duyệt: UBND thành phố Đà Nẵng ban hành <strong>Quyết định số 5082/QĐ-UBND</strong> phê duyệt Dự án thành phần 11 – xây dựng 3 khu tái định cư tại xã Duy Xuyên phục vụ giải phóng mặt bằng tuyến <strong>đường sắt tốc độ cao Bắc – Nam</strong>, tổng mức đầu tư hơn 392 tỷ đồng.</p>
<!--hh-featured-->
<h2>Tái định cư Duy Xuyên: những con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định 5082/QĐ-UBND của UBND TP Đà Nẵng (Dự án thành phần 11)</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 392 tỷ đồng</td></tr>
<tr><td>Tổng diện tích</td><td>Khoảng 31 ha (310.084,38 m²)</td></tr>
<tr><td>Khu Duy Trung</td><td>Hơn 5,27 ha, thôn Hòa Lâm (xã Duy Trung cũ)</td></tr>
<tr><td>Khu Duy Sơn</td><td>Khoảng 10,99 ha, thôn Chiêm Sơn (xã Duy Sơn cũ)</td></tr>
<tr><td>Khu Duy Trinh – Duy Sơn</td><td>Hơn 14,74 ha – lớn nhất trong 3 khu</td></tr>
<tr><td>Hạ tầng đầu tư</td><td>San nền, đường giao thông, thoát nước mưa, thu gom và xử lý nước thải, cấp nước, phòng cháy chữa cháy, cấp điện, chiếu sáng, cây xanh</td></tr>
<tr><td>Thời gian thực hiện</td><td>2026 – 2029</td></tr>
</tbody>
</table>
<p>Mục đích của các khu tái định cư Duy Xuyên là tạo quỹ đất bố trí chỗ ở cho các hộ dân phải di dời khi Nhà nước thu hồi đất làm tuyến đường sắt. Theo <a href="https://www.vietnamplus.vn/da-nang-trien-khai-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao-bac-nam-post1143554.vnp">VietnamPlus</a>, tổng mức đầu tư giải phóng mặt bằng tuyến đường sắt tốc độ cao qua Đà Nẵng dự kiến hơn 19.551 tỷ đồng.</p>
<h2>Đường sắt tốc độ cao Bắc – Nam đang ở bước nào?</h2>
<ul>
<li>Tuyến dài khoảng 1.541 km, sơ bộ tổng mức đầu tư khoảng 67,34 tỷ USD, gồm 23 ga hành khách và 5 ga hàng hóa.</li>
<li>Bộ Xây dựng đặt mục tiêu nỗ lực <strong>khởi công vào tháng 12/2027</strong>; gói thầu tư vấn khảo sát, lập báo cáo nghiên cứu khả thi (TV-02) đã mở thầu.</li>
<li>Ga Đà Nẵng của tuyến dự kiến đặt tại Hòa Sơn – xem thêm <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son/">ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn</a>.</li>
</ul>
<h2>Hộ dân trong diện tái định cư Duy Xuyên cần biết gì?</h2>
<p>Với các hộ có đất bị thu hồi, khu tái định cư Duy Xuyên là nơi được bố trí đất ở mới. Thông thường, hộ dân cần theo dõi thông báo thu hồi đất, kiểm đếm, phương án bồi thường – hỗ trợ – tái định cư do UBND xã niêm yết; kiểm tra diện tích, loại đất được ghi nhận; và hỏi rõ vị trí, giá giao lô tái định cư cùng nghĩa vụ tài chính. Nếu chưa đồng ý với số liệu kiểm đếm, nên có ý kiến bằng văn bản trong thời gian niêm yết công khai.</p>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Ảnh thực tế flycam: từ bờ Duy Xuyên – nơi có 3 khu tái định cư Duy Xuyên – nhìn về cầu Cửa Đại, sông Thu Bồn và Hội An-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tín hiệu tuyến đi vào thực tế:</strong> làm tái định cư trước là bước bắt buộc để giải phóng mặt bằng. Việc dự án tái định cư Duy Xuyên có quyết định đầu tư cụ thể cho thấy hướng tuyến qua khu vực này đã được xác định ở mức đủ để lập dự án.</li>
<li><strong>Đất nằm trong hành lang tuyến cần cẩn trọng:</strong> trước khi mua đất ở Duy Xuyên, Điện Bàn hay các xã giáp ranh, anh chị nên hỏi UBND xã hoặc văn phòng đăng ký đất đai xem thửa đất có nằm trong phạm vi thu hồi của tuyến hay khu tái định cư không.</li>
<li><strong>Lô tái định cư Duy Xuyên không phải hàng bán tự do:</strong> lô được giao cho hộ bị thu hồi đất; khi có người rao "suất tái định cư", cần kiểm tra quyết định giao đất và điều kiện chuyển nhượng.</li>
<li><strong>Không nên kỳ vọng tăng giá ngắn hạn:</strong> tuyến dự kiến khởi công cuối 2027 và hoàn thành khoảng 2035; tác động lên giá đất chủ yếu là dài hạn, tập trung quanh ga chứ không phải dọc tuyến.</li>
<li><strong>Hạ tầng dân cư mới:</strong> 3 khu tái định cư Duy Xuyên có đường, điện, nước, cây xanh đồng bộ – góp phần làm dày dân cư phía Nam Hội An trong vài năm tới.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a> – nằm ở xã Duy Nghĩa (Duy Xuyên cũ), ven sông Thu Bồn, cùng khu vực đang được đầu tư hạ tầng dân cư.</li>
<li><a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a> – quần thể ven biển phía Nam Hội An; kết nối đường sắt tốc độ cao trong dài hạn giúp rút ngắn thời gian đi từ các thành phố lớn.</li>
<li><a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca Hội An</a> – khu biệt thự ở Cẩm Thanh, phía Bắc sông Thu Bồn, cùng hưởng lợi khi vùng Hội An – Duy Xuyên có thêm hạ tầng lớn.</li>
</ul>
<p>Cần kiểm tra một thửa đất cụ thể ở Duy Xuyên, Điện Bàn có nằm trong hành lang tuyến hay không, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Quyết định 5082/QĐ-UBND của UBND TP Đà Nẵng theo báo chí đưa tin đầu tháng 11/2026 (Báo Đà Nẵng, Báo Pháp luật Việt Nam, Tin nhanh Chứng khoán, VietnamPlus); thông tin tuyến đường sắt tốc độ cao theo CafeF (05/11/2026). Chưa đọc được toàn văn quyết định – số liệu ghi theo nội dung báo chí trích dẫn.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Tái định cư Duy Xuyên 392 tỷ cho đường sắt tốc độ cao',
			'desc'      => 'Đà Nẵng duyệt 3 khu tái định cư Duy Xuyên (Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn), khoảng 31 ha, hơn 392 tỷ, 2026 – 2029, phục vụ đường sắt tốc độ cao.',
			'points'    => array(
				'Tái định cư Duy Xuyên – QĐ 5082/QĐ-UBND duyệt Dự án thành phần 11: 3 khu tái định cư tại xã Duy Xuyên, hơn 392 tỷ đồng',
				'Khoảng 31 ha: Duy Trung 5,27 ha, Duy Sơn 10,99 ha, Duy Trinh – Duy Sơn 14,74 ha; thực hiện 2026 – 2029',
				'Đường sắt tốc độ cao Bắc – Nam ~1.541 km, mục tiêu khởi công 12/2027; đất trong hành lang tuyến cần kiểm tra kỹ',
			),
			'faq'       => array(
				array( '3 khu tái định cư Duy Xuyên nằm đâu?', 'Các khu tái định cư Duy Xuyên gồm khu Duy Trung (thôn Hòa Lâm, hơn 5,27 ha), khu Duy Sơn (thôn Chiêm Sơn, khoảng 10,99 ha) và khu Duy Trinh – Duy Sơn (hơn 14,74 ha), đều thuộc xã Duy Xuyên, TP Đà Nẵng.' ),
				array( 'Tổng vốn và thời gian làm các khu tái định cư Duy Xuyên?', 'Tổng mức đầu tư hơn 392 tỷ đồng theo Quyết định 5082/QĐ-UBND, dự kiến thực hiện giai đoạn 2026 – 2029.' ),
				array( 'Đường sắt tốc độ cao Bắc – Nam khi nào khởi công?', 'Bộ Xây dựng đặt mục tiêu nỗ lực khởi công vào tháng 12/2027; dự án dự kiến cơ bản hoàn thành khoảng năm 2035.' ),
			),
		),
		'sources'        => array(
			'https://baodanang.vn/hon-392-ty-dong-xay-dung-3-khu-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao-3357503.html',
			'https://doanhnhan.baophapluat.vn/da-nang-dau-tu-hon-392-ty-dong-xay-3-khu-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao.html',
			'https://www.vietnamplus.vn/da-nang-trien-khai-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao-bac-nam-post1143554.vnp',
			'https://cafef.vn/sieu-du-an-duong-sat-toc-do-cao-350km-h-di-qua-15-tinh-thanh-von-dau-tu-67-ty-usd-du-kien-khoi-cong-vao-thang-12-2027-vua-co-dien-bien-moi-188261105135853475.chn',
		),
	);

	/* ---------------- 09/11 – Dự thảo nghị quyết TOD quanh ga đường sắt ---------------- */
	$posts[] = array(
		'slug'           => 'da-nang-du-thao-nghi-quyet-tod-quanh-ga-duong-sat',
		'title'          => 'Đà Nẵng lấy ý kiến dự thảo nghị quyết TOD: tăng hệ số sử dụng đất tối đa 1,5 lần quanh ga đường sắt',
		'excerpt'        => 'Sở Xây dựng Đà Nẵng lấy ý kiến dự thảo nghị quyết HĐND về phát triển đô thị theo mô hình TOD: hệ số sử dụng đất tối đa có thể tăng đến 1,5 lần so với quy chuẩn trong khoảng 1 km quanh nhà ga; dự kiến trình HĐND kỳ họp cuối năm 2026.',
		'keyword'        => 'TOD quanh ga đường sắt',
		'keywords_extra' => array( 'dự thảo nghị quyết TOD Đà Nẵng', 'hệ số sử dụng đất quanh nhà ga', 'đô thị TOD Đà Nẵng', 'đường sắt đô thị Đà Nẵng' ),
		'project'        => 'sun-saphia-residence',
		'schedule'       => '2026-11-09 08:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'TOD', 'Đường sắt', 'Quy hoạch' ),
		'image'          => 'plugin:img/tin-tuc/tod-quanh-ga-duong-sat-da-nang-du-thao-nghi-quyet.jpg',
		'image_alt'      => 'Hình minh hoạ đô thị TOD quanh ga đường sắt: hệ số sử dụng đất cao dần về phía nhà ga trong bán kính khoảng 1 km',
		'content'        => <<<HTML
<p>Phát triển đô thị <strong>TOD quanh ga đường sắt</strong> đang được Đà Nẵng xây dựng khung chính sách: Sở Xây dựng đã ra công văn ngày <strong>23/10/2026</strong> lấy ý kiến <strong>dự thảo nghị quyết của HĐND thành phố</strong> về mô hình TOD (Transit Oriented Development – phát triển đô thị gắn với giao thông công cộng). Điểm đáng chú ý nhất với thị trường: <strong>hệ số sử dụng đất tối đa có thể tăng đến 1,5 lần</strong> so với quy chuẩn hiện hành trong khoảng <strong>1 km quanh nhà ga</strong>.</p>
<!--hh-featured-->
<h2>Dự thảo nghị quyết TOD quanh ga đường sắt nêu những gì?</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin (8/11/2026)</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Dự thảo nghị quyết HĐND TP Đà Nẵng, Sở Xây dựng lấy ý kiến từ 23/10/2026</td></tr>
<tr><td>Hệ số sử dụng đất</td><td>Tối đa của lô đất, ô phố được tăng đến 1,5 lần so với quy chuẩn hiện hành</td></tr>
<tr><td>Phạm vi áp dụng</td><td>Khoảng 1 km quanh nhà ga; tiêu đề một số báo nêu mỗi khu TOD tối đa khoảng 320 ha</td></tr>
<tr><td>Chỉ tiêu hạ tầng xã hội</td><td>Diện tích sàn công trình hạ tầng xã hội được tính vào chỉ tiêu đất hạ tầng xã hội (trừ đất trường học)</td></tr>
<tr><td>Cây xanh</td><td>Mái công trình làm công viên, cây xanh được tính vào chỉ tiêu cây xanh công cộng</td></tr>
<tr><td>Thời điểm</td><td>Dự kiến trình HĐND thành phố tại kỳ họp cuối năm 2026, sau khi bổ sung theo Luật Phát triển đô thị mới</td></tr>
</tbody>
</table>
<p>Hồ sơ hiện mới xây dựng <strong>nguyên tắc, chỉ tiêu và trình tự</strong>; <strong>chưa xác định ranh giới khu TOD cho nhà ga cụ thể nào</strong>. Trước đó, HĐND TP.HCM đã thông qua nghị quyết tương tự về TOD quanh ga đường sắt, cũng cho tăng tối đa 1,5 lần hệ số sử dụng đất (<a href="https://tienphong.vn/tphcm-tang-he-so-su-dung-dat-gop-quanh-tod-len-15-lan-post1853058.tpo">Tiền Phong</a>).</p>
<h2>Hệ số sử dụng đất tăng 1,5 lần nghĩa là gì?</h2>
<p>Hệ số sử dụng đất là tỷ lệ giữa tổng diện tích sàn xây dựng và diện tích lô đất. Ví dụ minh họa: một lô 1.000 m² có hệ số tối đa 5 lần theo quy chuẩn được xây khoảng 5.000 m² sàn; nếu nằm trong khu TOD quanh ga đường sắt và được áp mức tăng 1,5 lần, hệ số tối đa có thể lên 7,5 lần – tức khoảng 7.500 m² sàn. Phần sàn tăng thêm thường đi kèm nghĩa vụ tài chính và yêu cầu dành không gian công cộng, nên không phải lô đất nào cũng tự động được hưởng.</p>
<h2>Những nhà ga nào có thể có TOD quanh ga đường sắt?</h2>
<ul>
<li><strong>Đường sắt tốc độ cao Bắc – Nam:</strong> ga Đà Nẵng dự kiến đặt tại Hòa Sơn – xem <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son/">ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn</a>.</li>
<li><strong>Đường sắt đô thị (metro/LRT):</strong> <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng đến 2050</a> định hướng phát triển các khu đô thị TOD quanh nhà ga; tiến độ các tuyến còn phụ thuộc nguồn vốn.</li>
</ul>
<!--hh-img:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg|Ảnh thực tế: cầu sông Hàn và trung tâm Đà Nẵng về đêm-->
<h2>Tác động của TOD quanh ga đường sắt – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đất quanh ga sẽ "cao" hơn:</strong> hệ số sử dụng đất tăng nghĩa là cùng một lô đất được xây nhiều sàn hơn – giá trị đất quanh ga tăng theo, nhất là các lô lớn có thể làm căn hộ, văn phòng, thương mại.</li>
<li><strong>Chưa có ranh giới – chưa nên "đón sóng":</strong> dự thảo chưa chỉ ra khu TOD quanh ga đường sắt nào cụ thể; tin rao "đất trong vùng TOD" lúc này là chưa có căn cứ. Cần chờ nghị quyết được thông qua và quy hoạch chi tiết từng khu ga.</li>
<li><strong>Lợi thế dài hạn cho dự án gần ga:</strong> căn hộ cách ga trong khoảng đi bộ sẽ được hưởng hạ tầng công cộng, cây xanh, dịch vụ tập trung – nhưng thời gian tính bằng năm, phụ thuộc tiến độ các tuyến đường sắt.</li>
<li><strong>Nhà nước thu lại giá trị đất:</strong> mô hình TOD quanh ga đường sắt thường đi kèm đấu giá quỹ đất quanh ga để có vốn làm đường sắt – đất đấu giá mới sẽ tăng nguồn cung trong tương lai.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> – trên trục biển Võ Nguyên Giáp – Trường Sa, theo quy hoạch cách nhà ga đường sắt đô thị số 09 khoảng 500 m; nếu khu ga được quy hoạch TOD, khu vực xung quanh sẽ được đầu tư dày hơn (dài hạn, phụ thuộc tiến độ tuyến).</li>
</ul>
<p>Hoàng Hiệp sẽ cập nhật khi nghị quyết TOD quanh ga đường sắt được HĐND thông qua. Cần kiểm tra một lô đất, căn hộ cụ thể có gần nhà ga theo quy hoạch hay không, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Vietstock (08/11/2026) và CafeLand (11/2026) đưa tin về dự thảo nghị quyết TOD do Sở Xây dựng Đà Nẵng lấy ý kiến từ 23/10/2026; Báo Tiền Phong, Dân trí (6/2026) về nghị quyết TOD của TP.HCM. Chưa đọc được toàn văn dự thảo – số liệu ghi theo báo chí; con số 320 ha mới thấy ở tiêu đề bài báo, chưa đối chiếu được nội dung.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'TOD quanh ga đường sắt Đà Nẵng: hệ số đất tăng 1,5 lần',
			'desc'      => 'Dự thảo nghị quyết TOD quanh ga đường sắt Đà Nẵng: hệ số sử dụng đất tối đa tăng đến 1,5 lần trong khoảng 1 km quanh nhà ga, trình HĐND cuối 2026.',
			'points'    => array(
				'TOD quanh ga đường sắt: Sở Xây dựng lấy ý kiến dự thảo nghị quyết HĐND về đô thị TOD từ 23/10/2026',
				'Hệ số sử dụng đất tối đa tăng đến 1,5 lần trong khoảng 1 km quanh nhà ga',
				'Chưa xác định ranh giới TOD cho nhà ga cụ thể; dự kiến trình HĐND kỳ họp cuối năm 2026',
			),
			'faq'       => array(
				array( 'TOD quanh ga đường sắt là gì?', 'TOD (Transit Oriented Development) là mô hình phát triển đô thị gắn với giao thông công cộng: tập trung nhà ở, văn phòng, thương mại với mật độ cao quanh nhà ga đường sắt, metro để người dân đi bộ tới ga.' ),
				array( 'Dự thảo TOD của Đà Nẵng cho tăng hệ số sử dụng đất bao nhiêu?', 'Theo báo chí, dự thảo cho tăng tối đa 1,5 lần hệ số sử dụng đất tối đa của lô đất, ô phố so với quy chuẩn hiện hành, trong khoảng 1 km quanh nhà ga.' ),
				array( 'Đã có khu TOD quanh ga đường sắt nào ở Đà Nẵng được duyệt chưa?', 'Chưa. Dự thảo mới xây dựng nguyên tắc, chỉ tiêu và trình tự; chưa xác định ranh giới khu TOD cho nhà ga cụ thể. Dự kiến trình HĐND thành phố kỳ họp cuối năm 2026.' ),
			),
		),
		'sources'        => array(
			'https://vietstock.vn/2026/11/da-nang-muon-nang-he-so-su-dung-dat-15-lan-quanh-ga-tod-moi-khu-toi-da-320ha-4221-1512823.htm',
			'https://cafeland.vn/tin-tuc/da-nang-de-xuat-quy-hoach-tod-quanh-ga-duong-sat-pham-vi-nao-dat-dai-se-duoc-bo-tri-ra-sao-156586.html',
			'https://tienphong.vn/tphcm-tang-he-so-su-dung-dat-gop-quanh-tod-len-15-lan-post1853058.tpo',
		),
	);

	/* ---------------- 10/11 – Chuẩn bị công bố Quy hoạch chung, Aeon Mall Hòa Xuân ---------------- */
	$posts[] = array(
		'slug'           => 'cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan',
		'old_slug'       => array( 'da-nang-cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan-thang-11' ),
		'title'          => 'Đà Nẵng chuẩn bị công bố Quy hoạch chung 2050 cuối tháng 11: dự kiến khởi công Aeon Mall Hòa Xuân, tái khởi động Đa Phước',
		'excerpt'        => 'Đà Nẵng ban hành kế hoạch hội nghị công bố Quy hoạch chung đến 2050 và xúc tiến đầu tư 2026, dự kiến 28/11. Bên lề: dự kiến khởi công Aeon Mall Hòa Xuân (khu đất 101.800 m², vốn hơn 4.300 tỷ), tái khởi động Khu đô thị quốc tế Đa Phước 17/11.',
		'keyword'        => 'công bố quy hoạch chung 2050',
		'keywords_extra' => array( 'Aeon Mall Hòa Xuân', 'hội nghị xúc tiến đầu tư Đà Nẵng 2026', 'khu đô thị quốc tế Đa Phước', 'bất động sản Hòa Xuân' ),
		'project'        => 'cora-tower',
		'schedule'       => '2026-11-10 08:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch', 'Hòa Xuân', 'Xúc tiến đầu tư' ),
		'image'          => 'plugin:img/tin-tuc/cong-bo-quy-hoach-chung-da-nang-aeon-mall-hoa-xuan-11-2026.jpg',
		'image_alt'      => 'Lịch dự kiến cuối tháng 11/2026 tại Đà Nẵng: tái khởi động Đa Phước, khởi công Aeon Mall Hòa Xuân, khánh thành Quốc lộ 14E, hội nghị công bố quy hoạch chung 2050',
		'content'        => <<<HTML
<p>Lịch <strong>công bố quy hoạch chung 2050</strong> của Đà Nẵng đã được xác định: Chủ tịch UBND TP Đà Nẵng <strong>Nguyễn Mạnh Hùng</strong> đã ký ban hành <strong>kế hoạch tổ chức Hội nghị công bố Quy hoạch chung thành phố đến năm 2050, tầm nhìn đến năm 2075 và Xúc tiến đầu tư năm 2026</strong>. Theo <a href="https://baodautu.vn/da-nang-chuan-bi-to-chuc-hoi-nghi-cong-bo-quy-hoach-chung-va-xuc-tien-dau-tu-d740118.html">Báo Đầu tư</a> (09/11/2026), hội nghị dự kiến diễn ra <strong>ngày 28/11</strong> tại Trung tâm Hành chính thành phố; một số nguồn khác nêu phương án sáng 21 hoặc 28/11, khoảng 500 đại biểu. Đi kèm là chuỗi sự kiện khởi công, khánh thành – đáng chú ý với bất động sản là <strong>Aeon Mall Hòa Xuân</strong>.</p>
<!--hh-featured-->
<h2>Lịch công bố quy hoạch chung 2050 và các sự kiện cuối tháng 11/2026</h2>
<table>
<thead><tr><th>Thời gian (dự kiến)</th><th>Sự kiện</th></tr></thead>
<tbody>
<tr><td>17/11</td><td>Lễ tái khởi động Khu đô thị quốc tế Đa Phước (giai đoạn 1)</td></tr>
<tr><td>Tháng 11</td><td>Khởi công Trung tâm thương mại AEON MALL Đà Nẵng Hòa Xuân (theo Tuổi Trẻ, chủ đầu tư đang hoàn tất thủ tục, hồ sơ thiết kế)</td></tr>
<tr><td>27 hoặc 29/11</td><td>Khánh thành dự án nâng cấp Quốc lộ 14E</td></tr>
<tr><td>21 hoặc 28/11</td><td>Hội nghị công bố quy hoạch chung 2050 và xúc tiến đầu tư; trao quyết định phê duyệt quy hoạch</td></tr>
<tr><td>Bên lề</td><td>Dự kiến khai trương VSAP Lab, khởi công dự án ô tô Volkswagen; triển lãm quy hoạch</td></tr>
</tbody>
</table>
<p>Theo Báo Đầu tư, thành phố cũng đã phê duyệt dự án <strong>Luồng Cửa Lở</strong> với tổng vốn khoảng <strong>7.585 tỷ đồng</strong>. Quy hoạch chung được Phó Thủ tướng ký phê duyệt tại <a href="/quy-hoach-chung-da-nang-2050/">Quyết định 2016/QĐ-TTg ngày 21/10/2026</a>.</p>
<h2>Công bố quy hoạch chung 2050 có ý nghĩa gì?</h2>
<p>Quy hoạch chung đã được Thủ tướng phê duyệt; việc công bố quy hoạch chung 2050 là bước đưa đồ án ra công khai để người dân, doanh nghiệp biết và thực hiện. Sau công bố, các quy hoạch phân khu, quy hoạch chi tiết và kế hoạch sử dụng đất sẽ lần lượt được rà soát cho phù hợp. Với người mua nhà đất, đây là thời điểm nên đối chiếu thửa đất mình quan tâm với bản đồ định hướng: khu vực nào là đô thị mới, trục giao thông nào được mở, đâu là đất cây xanh, công cộng.</p>
<p>Hội nghị đi kèm xúc tiến đầu tư cũng cho biết thành phố đang ưu tiên kêu gọi lĩnh vực nào. Danh mục dự án được giới thiệu tại hội nghị công bố quy hoạch chung 2050 thường là tín hiệu sớm về những khu vực sắp có vốn và hạ tầng.</p>
<h2>Aeon Mall Hòa Xuân: những gì đã chắc chắn</h2>
<ul>
<li><strong>Vị trí:</strong> mặt tiền đường Trần Nam Trung, phường Hòa Xuân, trong Khu tổ hợp thể thao, giải trí và thương mại Hòa Xuân.</li>
<li><strong>Khu đất:</strong> 101.800 m², UBND thành phố cho Công ty TNHH AEON Mall Việt Nam thuê, trả tiền một lần, thời hạn đến <strong>07/8/2075</strong>.</li>
<li><strong>Vốn:</strong> hơn 4.300 tỷ đồng (một số báo ghi khoảng 4.400 tỷ); AEONMALL Việt Nam và BIM Group ký hợp tác phát triển ngày 11/5/2026.</li>
<li><strong>Quy mô:</strong> được giới thiệu là trung tâm thương mại lớn nhất Đà Nẵng, AEON MALL thứ hai tại thành phố sau cơ sở Thanh Khê.</li>
<li><strong>Chưa chắc chắn:</strong> ngày khởi công chính thức và thời điểm khai trương chưa được chủ đầu tư công bố.</li>
</ul>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg|Ảnh thực tế 11/2026: khu Hòa Xuân ven sông Cẩm Lệ, cầu Hòa Xuân-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Hòa Xuân có thêm "mỏ neo" thương mại:</strong> một trung tâm thương mại cỡ lớn kéo theo việc làm, lưu lượng người và dịch vụ – điều khu Hòa Xuân còn thiếu so với trung tâm. Căn hộ, nhà phố quanh khu tổ hợp thể thao – thương mại có thêm lý do để ở thật và cho thuê.</li>
<li><strong>Khởi công mới là bước đầu:</strong> từ khởi công đến khai trương thường mất vài năm; giá rao "sát Aeon" tăng ngay lúc này là đi trước hạ tầng. Nên so giá theo khoảng cách thật và tiến độ thật.</li>
<li><strong>Công bố quy hoạch chung 2050 là tín hiệu mở dự án:</strong> quy hoạch chung đã duyệt, thành phố bước sang giai đoạn kêu gọi đầu tư – các quỹ đất, dự án lớn sẽ được công bố dần; người mua nên theo dõi danh mục dự án kêu gọi tại hội nghị để biết khu nào sắp có vốn vào.</li>
<li><strong>Lịch có thể đổi:</strong> ngày công bố quy hoạch chung 2050 và các mốc khác đều là dự kiến theo kế hoạch và báo chí; Hoàng Hiệp sẽ cập nhật khi sự kiện diễn ra.</li>
</ul>
<!--hh-img:img/nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-duong-noi-khu-san-the-thao.jpg|Ảnh thực tế 8/2025: đường nội khu và sân thể thao khu Nam Hòa Xuân-->
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/cora-tower/">Cora Tower</a> – tòa căn hộ Sun Group trong khu đô thị Sun Neo City, phường Hòa Xuân; một trung tâm thương mại lớn cùng khu vực giúp tăng tiện ích sống và nhu cầu thuê.</li>
<li><a href="/du-an/spana-tower/">Spana Tower</a> và <a href="/du-an/s-light-tower/">S-Light Tower</a> – căn hộ Sun Group ven sông tại Hòa Xuân, hưởng lợi từ việc khu vực có thêm thương mại, dịch vụ quy mô lớn.</li>
<li><a href="/du-an/sun-neo-city/">Sun Neo City</a> – khu đô thị của Sun Group tại Hòa Xuân, nơi có Cora, Spana, S-Light.</li>
<li><a href="/dat-nen-hoa-xuan/">Đất nền Hòa Xuân</a> – nhà phố, đất ở trong bán kính phục vụ của trung tâm thương mại sẽ được quan tâm hơn khi dự án khởi công thật.</li>
</ul>
<p>Cần bảng giá, giỏ hàng căn hộ Sun Group tại Hòa Xuân, đối chiếu một thửa đất với bản đồ sau khi công bố quy hoạch chung 2050 hoặc kiểm tra khoảng cách tới khu đất Aeon Mall, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p>Hoàng Hiệp sẽ cập nhật nội dung chính sau hội nghị công bố quy hoạch chung 2050.</p>
<p class="src">Nguồn: Báo Đầu tư (09/11/2026) về kế hoạch Hội nghị công bố Quy hoạch chung và xúc tiến đầu tư; Báo Đà Nẵng (11/2026); Tuổi Trẻ (10/2026) về kế hoạch khởi công AEON MALL Hòa Xuân trong tháng 11; CafeLand, VCCI, Nhà Đầu tư (2026) về quyết định cho thuê đất, diện tích, vốn đầu tư. Chưa đọc được toàn văn kế hoạch – ngày giờ ghi theo báo chí, có thể điều chỉnh.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Công bố quy hoạch chung 2050 ngày 28/11, Aeon Hòa Xuân',
			'desc'      => 'Đà Nẵng dự kiến công bố quy hoạch chung 2050 ngày 28/11/2026; bên lề dự kiến khởi công Aeon Mall Hòa Xuân (101.800 m², hơn 4.300 tỷ), tái khởi động Đa Phước.',
			'points'    => array(
				'Công bố quy hoạch chung 2050: hội nghị kèm xúc tiến đầu tư dự kiến 28/11/2026 tại Trung tâm Hành chính',
				'Aeon Mall Hòa Xuân: khu đất 101.800 m², thuê đến 07/8/2075, vốn hơn 4.300 tỷ, dự kiến khởi công tháng 11',
				'17/11 tái khởi động Khu đô thị quốc tế Đa Phước giai đoạn 1; Quốc lộ 14E dự kiến khánh thành cuối tháng 11',
			),
			'faq'       => array(
				array( 'Khi nào Đà Nẵng công bố quy hoạch chung 2050?', 'Theo kế hoạch UBND thành phố được báo chí đưa tin, hội nghị công bố quy hoạch chung 2050, tầm nhìn 2075 và xúc tiến đầu tư dự kiến ngày 28/11/2026 tại Trung tâm Hành chính (một số nguồn nêu phương án 21/11).' ),
				array( 'Aeon Mall Hòa Xuân ở đâu, khi nào khởi công?', 'Dự án nằm mặt tiền đường Trần Nam Trung, phường Hòa Xuân, khu đất 101.800 m², vốn hơn 4.300 tỷ đồng. Báo chí đưa tin chủ đầu tư chuẩn bị khởi công trong tháng 11/2026; ngày chính thức chưa công bố.' ),
				array( 'Aeon Mall Hòa Xuân ảnh hưởng gì tới bất động sản?', 'Trung tâm thương mại lớn giúp khu Hòa Xuân có thêm tiện ích, việc làm, lưu lượng người – có lợi cho căn hộ, nhà phố quanh đó, nhất là nhu cầu ở và cho thuê. Tuy vậy từ khởi công đến khai trương còn vài năm, nên so giá theo tiến độ thật.' ),
			),
		),
		'sources'        => array(
			'https://baodautu.vn/da-nang-chuan-bi-to-chuc-hoi-nghi-cong-bo-quy-hoach-chung-va-xuc-tien-dau-tu-d740118.html',
			'https://baodanang.vn/chuan-bi-cong-bo-quy-hoach-chung-thanh-pho-da-nang-den-nam-2050-tam-nhin-nam-2075-3355754.html',
			'https://tuoitre.vn/trung-tam-thuong-mai-lon-nhat-mien-trung-cua-aeon-mall-sap-khoi-cong-o-da-nang-100261007161625634.htm',
			'https://cafeland.vn/tin-tuc/cho-thue-hon-100000-m2-dat-xay-dung-trung-tam-thuong-mai-aeon-mall-da-nang-hoa-xuan-153045.html',
			'https://www.vcci.com.vn/tin-tuc/bim-group-va-aeonmall-hop-tac-phat-trien-du-an-trung-tam-thuong-mai-hon-4300-ty',
		),
	);

	/* ---------------- 12/11 – Tái định cư Hương Trà (đường sắt tốc độ cao) và Hòa Liên – Túy Loan (cao tốc) ---------------- */
	$posts[] = array(
		'slug'           => 'tai-dinh-cu-huong-tra-hoa-lien-tuy-loan',
		'old_slug'       => array( 'tai-dinh-cu-huong-tra-duong-sat-toc-do-cao-hoa-lien-tuy-loan' ),
		'title'          => 'Đà Nẵng duyệt thêm 2 khu tái định cư hơn 471 tỷ: Hương Trà cho đường sắt tốc độ cao, Hòa Liên – Túy Loan cho cao tốc',
		'excerpt'        => 'Quyết định 5128/QĐ-UBND duyệt khu tái định cư hơn 365,8 tỷ đồng, khoảng 32,57 ha với 391 lô tại phường Hương Trà (Tam Kỳ cũ) phục vụ đường sắt tốc độ cao Bắc – Nam; Quyết định 5151/QĐ-UBND duyệt khu tái định cư số 3 hơn 105,3 tỷ cho cao tốc đoạn Hòa Liên – Túy Loan.',
		'keyword'        => 'tái định cư Hương Trà',
		'keywords_extra' => array( 'tái định cư đường sắt tốc độ cao Hương Trà', 'tái định cư cao tốc Hòa Liên Túy Loan', 'đường sắt tốc độ cao qua Tam Kỳ', 'Quyết định 5128/QĐ-UBND', 'bất động sản Tam Kỳ' ),
		'project'        => 'meta-city-tam-ky',
		'schedule'       => '2026-11-12 07:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Đường sắt tốc độ cao', 'Tái định cư' ),
		'image'          => 'plugin:img/tin-tuc/tai-dinh-cu-huong-tra-hoa-lien-11-2026.jpg',
		'image_alt'      => 'Khu tái định cư Hương Trà và khu tái định cư số 3 cao tốc Hòa Liên – Túy Loan, Đà Nẵng',
		'content'        => <<<HTML
<p>Khu <strong>tái định cư Hương Trà</strong> cho đường sắt tốc độ cao vừa được duyệt. Trong hai ngày 9 – 10/11/2026, UBND TP Đà Nẵng duyệt thêm hai dự án tái định cư phục vụ hai công trình giao thông lớn: khu tái định cư Hương Trà (Quyết định 5128/QĐ-UBND, hơn 365,8 tỷ đồng) và <strong>Khu tái định cư số 3</strong> cho cao tốc đoạn Hòa Liên – Túy Loan (Quyết định 5151/QĐ-UBND, hơn 105,3 tỷ đồng). Cộng lại, hai dự án có tổng mức đầu tư hơn 471 tỷ đồng (Hoàng Hiệp cộng từ hai quyết định).</p>
<!--hh-featured-->
<h2>Tái định cư Hương Trà: những con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định 5128/QĐ-UBND của UBND TP Đà Nẵng (Văn phòng UBND thành phố thông tin ngày 10/11/2026)</td></tr>
<tr><td>Vị trí</td><td>Phường Hương Trà – hình thành từ phường Hòa Hương, An Sơn và xã Tam Ngọc của TP Tam Kỳ (Quảng Nam cũ)</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 365,8 tỷ đồng</td></tr>
<tr><td>Quy mô</td><td>Khoảng 32,57 ha, 391 lô tái định cư</td></tr>
<tr><td>Hạng mục kèm theo</td><td>6 bãi đỗ xe (khoảng 7.033 m²), công viên cây xanh, hành lang cách ly</td></tr>
<tr><td>Đơn vị thực hiện</td><td>Ban Quản lý dự án đầu tư xây dựng các công trình giao thông và nông nghiệp TP Đà Nẵng</td></tr>
</tbody>
</table>
<p>Theo trích yếu, quyết định về khu tái định cư Hương Trà cũng giao UBND phường Hương Trà rà soát, chuẩn hóa thông tin diện tích đất để hồ sơ dự án khớp với quy hoạch, và quản lý quy hoạch xung quanh để giữ khoảng cách an toàn môi trường với trạm xử lý nước thải.</p>
<h2>Khu tái định cư số 3 cho cao tốc Hòa Liên – Túy Loan</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định 5151/QĐ-UBND ngày 09/11/2026 của Chủ tịch UBND TP Đà Nẵng</td></tr>
<tr><td>Phục vụ</td><td>Giải tỏa dự án xây dựng đường cao tốc đoạn Hòa Liên – Túy Loan</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 105,3 tỷ đồng</td></tr>
<tr><td>Hạ tầng</td><td>San nền, giao thông, thoát nước mưa, thoát và xử lý nước thải (trạm 150 m³/ngày đêm), chiếu sáng, hào kỹ thuật, cây xanh; 2 bãi đỗ xe tổng khoảng 957 m²</td></tr>
<tr><td>Chủ đầu tư</td><td>Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng</td></tr>
<tr><td>Thời gian</td><td>2026 – 2027</td></tr>
</tbody>
</table>
<!--hh-img:img/meta-city-tam-ky/meta-city-tam-ky-phoi-canh-tong-the.jpg|Phối cảnh khu đô thị Meta City ở Tây Bắc Tam Kỳ, phường Bàn Thạch – cùng khu vực Tam Kỳ cũ với khu tái định cư Hương Trà (phối cảnh chủ đầu tư)-->
<h2>Tái định cư Hương Trà trong chuỗi dự án cho đường sắt tốc độ cao</h2>
<p>Khu tái định cư Hương Trà nằm trong chuỗi dự án tái định cư thành phố đang duyệt dần cho tuyến đường sắt tốc độ cao Bắc – Nam. Đầu tháng 11/2026, Đà Nẵng đã duyệt 3 khu tái định cư hơn 392 tỷ đồng tại Duy Xuyên (xem <a href="/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty/">bài chi tiết</a>); trước đó báo chí cũng đưa tin các khu tại Hòa Tiến, Tam Xuân, Bàn Thạch, Hòa Khánh – Liên Chiểu.</p>
<p>Theo các báo (<a href="https://cafef.vn/da-nang-phe-duyet-loat-khu-tai-dinh-cu-phuc-vu-cao-toc-duong-sat-toc-do-cao-188261111144637121.chn">CafeF</a>), tuyến qua Đà Nẵng dài khoảng 116 km, từ phường Hải Vân đến xã Núi Thành; Bộ Xây dựng đặt mục tiêu khởi công tuyến vào tháng 12/2027. Ga hành khách Đà Nẵng dự kiến đặt tại Hòa Sơn – xem <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son/">ga đường sắt tốc độ cao Đà Nẵng</a>.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tuyến đường sắt đã chạm tới Tam Kỳ cũ:</strong> sau Duy Xuyên, việc dự án tái định cư Hương Trà có quyết định đầu tư cụ thể cho thấy công tác chuẩn bị mặt bằng đang trải dài khắp các địa phương phía Nam thành phố. Làm tái định cư trước là bước bắt buộc trước khi thu hồi đất.</li>
<li><strong>Kiểm tra hành lang tuyến trước khi mua đất:</strong> ở các phường, xã có tuyến đi qua như Hương Trà, Bàn Thạch, Hòa Liên, anh chị nên hỏi UBND phường, xã hoặc văn phòng đăng ký đất đai xem thửa đất có nằm trong phạm vi thu hồi, hành lang an toàn hay không trước khi đặt cọc.</li>
<li><strong>391 lô tái định cư Hương Trà không phải hàng bán tự do:</strong> lô tái định cư dành để bố trí cho hộ bị thu hồi đất. Khi có người rao "suất tái định cư", cần kiểm tra quyết định giao đất, điều kiện chuyển nhượng – tránh mua giấy tờ tay.</li>
<li><strong>Hạ tầng dân cư mới:</strong> mỗi khu tái định cư đi kèm đường, thoát nước, xử lý nước thải, bãi đỗ xe, cây xanh đồng bộ; về dài hạn giúp khu vực ven tuyến có thêm khu dân cư mới.</li>
<li><strong>Tác động giá là dài hạn:</strong> đường sắt dự kiến khởi công cuối 2027, khu tái định cư Hương Trà chỉ là bước chuẩn bị mặt bằng; giá đất thường chịu ảnh hưởng rõ nhất quanh nhà ga, không phải dọc tuyến. Không nên mua đuổi theo tin tái định cư.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a> – khu đô thị ở phường Bàn Thạch, cùng khu vực Tam Kỳ cũ với phường Hương Trà; hạ tầng đường sắt và tái định cư làm khu vực Tây Bắc Tam Kỳ được quan tâm hơn (trang thông tin tham khảo).</li>
<li><a href="/du-an/ecohome-hoa-hiep-da-nang/">Nhà ở xã hội Ecohome Hòa Hiệp</a> – khu Tây Bắc thành phố (phường Hải Vân), gần các công trình giao thông phía Tây như cao tốc qua Hòa Liên, tuyến đường sắt đoạn Hải Vân.</li>
</ul>
<p>Cần kiểm tra một thửa đất ở Tam Kỳ, Hòa Vang có nằm trong hành lang tuyến hay khu tái định cư không, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Quyết định 5128/QĐ-UBND và 5151/QĐ-UBND của UBND TP Đà Nẵng theo báo chí đưa tin ngày 10 – 11/11/2026 (Báo Đà Nẵng, CafeF, Đại Đoàn Kết, Chuyển động Thị trường); thông tin hành chính phường Hương Trà theo Nghị quyết 1659/NQ-UBTVQH15. Bài viết theo trích yếu báo chí, chưa đọc toàn văn quyết định.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Tái định cư Hương Trà 365,8 tỷ, 391 lô cho đường sắt',
			'desc'      => 'Tái định cư Hương Trà: QĐ 5128 duyệt hơn 365,8 tỷ, 32,57 ha, 391 lô cho đường sắt tốc độ cao; QĐ 5151 duyệt khu số 3 cao tốc Hòa Liên – Túy Loan.',
			'points'    => array(
				'QĐ 5128/QĐ-UBND: khu tái định cư Hương Trà hơn 365,8 tỷ, khoảng 32,57 ha, 391 lô, phục vụ đường sắt tốc độ cao',
				'QĐ 5151/QĐ-UBND (09/11/2026): khu tái định cư số 3 hơn 105,3 tỷ cho cao tốc đoạn Hòa Liên – Túy Loan, làm 2026 – 2027',
				'Đất trong hành lang tuyến cần kiểm tra kỹ; lô tái định cư không phải hàng bán tự do',
			),
			'faq'       => array(
				array( 'Khu tái định cư Hương Trà lớn bao nhiêu?', 'Theo Quyết định 5128/QĐ-UBND, khoảng 32,57 ha với 391 lô tái định cư, tổng mức đầu tư hơn 365,8 tỷ đồng, kèm 6 bãi đỗ xe và công viên cây xanh.' ),
				array( 'Mua lô tái định cư Hương Trà được không?', 'Lô tái định cư Hương Trà dùng để bố trí cho hộ bị thu hồi đất, không phải hàng bán tự do; nếu được rao bán lại, cần kiểm tra quyết định giao đất, điều kiện chuyển nhượng và tránh mua giấy tờ tay.' ),
				array( 'Phường Hương Trà ở đâu?', 'Phường Hương Trà của TP Đà Nẵng được hình thành từ phường Hòa Hương, An Sơn và xã Tam Ngọc thuộc TP Tam Kỳ (Quảng Nam cũ).' ),
				array( 'Khu tái định cư số 3 cao tốc Hòa Liên – Túy Loan làm khi nào?', 'Theo Quyết định 5151/QĐ-UBND ngày 09/11/2026, tổng mức đầu tư hơn 105,3 tỷ đồng, thực hiện trong năm 2026 – 2027.' ),
			),
		),
		'sources'        => array(
			'https://baodanang.vn/xay-dung-khu-tai-dinh-cu-so-3-phuc-vu-cao-toc-hoa-lien-tuy-loan-tri-gia-hon-105-ty-dong-3358111.html',
			'https://cafef.vn/da-nang-phe-duyet-loat-khu-tai-dinh-cu-phuc-vu-cao-toc-duong-sat-toc-do-cao-188261111144637121.chn',
			'https://daidoanket.vn/da-nang-dau-tu-hon-365-ty-dong-xay-khu-tai-dinh-cu-phuc-vu-duong-sat-toc-do-cao.html',
			'https://guland.vn/dia-danh-hanh-chinh/phuong-huong-tra-da-nang',
		),
	);


	/* ---------------- 13/11 – VSIP làm nhà đầu tư hạ tầng vị trí số 7 Khu thương mại tự do (QĐ 5202/QĐ-UBND) ---------------- */
	$posts[] = array(
		'slug'           => 'vsip-ha-tang-vi-tri-so-7-khu-thuong-mai-tu-do',
		'old_slug'       => array( 'vsip-vi-tri-so-7-khu-thuong-mai-tu-do-da-nang-3525-ty' ),
		'title'          => 'Đà Nẵng chọn VSIP làm hạ tầng vị trí số 7 Khu thương mại tự do: 3.525 tỷ, 276 ha tại Hòa Vang',
		'excerpt'        => 'Quyết định 5202/QĐ-UBND ngày 12/11/2026 chấp thuận VSIP là nhà đầu tư dự án hạ tầng khu chức năng vị trí số 7 Khu thương mại tự do Đà Nẵng: khoảng 276 ha tại xã Hòa Vang, vốn 3.525 tỷ đồng, xây hạ tầng từ quý 4/2027 đến quý 1/2032.',
		'keyword'        => 'hạ tầng vị trí số 7',
		'keywords_extra' => array( 'VSIP Đà Nẵng', 'Quyết định 5202/QĐ-UBND', 'bất động sản Hòa Vang', 'khu thương mại tự do Đà Nẵng' ),
		'project'        => 'spana-tower',
		'schedule'       => '2026-11-13 07:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Khu thương mại tự do', 'Hòa Vang' ),
		'image'          => 'plugin:img/tin-tuc/vsip-vi-tri-7-khu-thuong-mai-tu-do-11-2026.jpg',
		'image_alt'      => 'VSIP làm nhà đầu tư hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng, 3.525 tỷ đồng',
		'content'        => <<<HTML
<p>Dự án <strong>hạ tầng vị trí số 7</strong> của Khu thương mại tự do Đà Nẵng đã có nhà đầu tư. Ngày 12/11/2026, UBND TP Đà Nẵng ban hành <strong>Quyết định 5202/QĐ-UBND</strong>, chấp thuận Công ty Liên doanh TNHH Khu công nghiệp Việt Nam – Singapore (<strong>VSIP</strong>) là nhà đầu tư dự án đầu tư xây dựng và kinh doanh kết cấu hạ tầng khu chức năng tại <strong>vị trí số 7 – Khu thương mại tự do Đà Nẵng</strong>, xã Hòa Vang. Đây là bước tiếp theo sau khi thành phố chấp thuận chủ trương đầu tư dự án (Quyết định 4785/QĐ-UBND) hồi giữa tháng 10/2026.</p>
<!--hh-featured-->
<h2>Dự án hạ tầng vị trí số 7: những con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định 5202/QĐ-UBND ngày 12/11/2026 của UBND TP Đà Nẵng</td></tr>
<tr><td>Nhà đầu tư</td><td>Công ty Liên doanh TNHH Khu công nghiệp Việt Nam – Singapore (VSIP)</td></tr>
<tr><td>Vị trí</td><td>Vị trí số 7, Khu thương mại tự do Đà Nẵng – xã Hòa Vang</td></tr>
<tr><td>Quy mô</td><td>Khoảng 276 ha (một số báo ghi khoảng 270 ha)</td></tr>
<tr><td>Tổng vốn</td><td>3.525 tỷ đồng (khoảng 132,9 triệu USD)</td></tr>
<tr><td>Tiến độ</td><td>San lấp mặt bằng, xây hạ tầng từ quý 4/2027 đến quý 1/2032; kinh doanh, thu hút nhà đầu tư thứ cấp từ quý 4/2028</td></tr>
<tr><td>Thời hạn</td><td>70 năm kể từ ngày được quyết định cho thuê đất; vốn phải giải ngân hết trong 5 năm kể từ khi nhận đất</td></tr>
<tr><td>Định hướng</td><td>Sản xuất, logistics, công nghệ số, công nghệ thông tin</td></tr>
</tbody>
</table>
<h2>Khu thương mại tự do Đà Nẵng đang ở đâu?</h2>
<p>Khu thương mại tự do Đà Nẵng được Thủ tướng quyết định thành lập năm 2025, tổng diện tích khoảng 1.881 ha chia ở 7 vị trí, gắn với cảng Liên Chiểu ở phía Tây Bắc (xem <a href="/cang-lien-chieu-khu-thuong-mai-tu-do/">cảng Liên Chiểu và Khu thương mại tự do</a>; <a href="https://dantri.com.vn/thoi-su/quyet-dinh-7-vi-tri-lam-khu-thuong-mai-tu-do-da-nang-20250616155817749.htm">Dân trí</a>).</p>
<p>Vị trí số 7 nằm ở vùng phía Tây thành phố; theo quyết định thành lập ban đầu, vị trí này rộng khoảng 401 ha – con số 276 ha trong dự án hạ tầng vị trí số 7 lần này nhỏ hơn, báo chí chưa giải thích phần chênh lệch. Quy hoạch chung Đà Nẵng đến 2050 cũng xác định đưa 7 vị trí của Khu thương mại tự do vào hoạt động (xem <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung 2050</a>).</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-nhin-ve-trung-tam.jpg|Sông Cẩm Lệ và khu Hòa Xuân nhìn về trung tâm Đà Nẵng – khu đô thị phía Nam gần nhất với vùng phát triển phía Tây (ảnh flycam thực tế tháng 8/2025)-->
<h2>Lộ trình hạ tầng vị trí số 7 đến 2032</h2>
<ul>
<li><strong>Quý 4/2027:</strong> bắt đầu san lấp mặt bằng, xây hạ tầng vị trí số 7 (sau khi nhận đất).</li>
<li><strong>Quý 4/2028:</strong> bắt đầu kinh doanh, thu hút nhà đầu tư thứ cấp vào khu chức năng.</li>
<li><strong>Quý 1/2032:</strong> dự kiến hoàn thành xây dựng hạ tầng; vốn phải giải ngân hết trong 5 năm kể từ khi nhận đất.</li>
</ul>
<p>Lộ trình cho thấy hạ tầng vị trí số 7 được làm cuốn chiếu: phần đất có hạ tầng trước sẽ cho doanh nghiệp thuê trước, không chờ toàn bộ 276 ha hoàn thành.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Có nhà đầu tư hạ tầng chuyên nghiệp:</strong> VSIP là đơn vị đã làm nhiều khu công nghiệp tại Việt Nam; việc chọn được nhà đầu tư cho thấy Khu thương mại tự do bắt đầu chuyển từ quy hoạch sang triển khai thực tế ở vị trí này.</li>
<li><strong>Tác động là dài hạn:</strong> hạ tầng vị trí số 7 làm từ cuối 2027 đến đầu 2032, doanh nghiệp thứ cấp vào sớm nhất từ cuối 2028. Nhu cầu nhà ở cho người lao động, chuyên gia sẽ tăng dần theo tiến độ lấp đầy, không phải ngay lập tức.</li>
<li><strong>Đất Hòa Vang: kiểm tra quy hoạch trước khi mua:</strong> khu vực quanh các vị trí Khu thương mại tự do sẽ có thu hồi đất, tái định cư. Anh chị nên kiểm tra quy hoạch sử dụng đất, chỉ giới đường quy hoạch tại UBND xã hoặc văn phòng đăng ký đất đai, tránh mua theo tin "sắp lên khu công nghiệp".</li>
<li><strong>Căn hộ khu Nam – Tây Nam hưởng lợi gián tiếp:</strong> các khu đô thị có sẵn hạ tầng như Hòa Xuân, Cẩm Lệ là nơi chuyên gia, nhân sự quản lý thường chọn ở vì gần trung tâm hơn và đủ tiện ích; nhu cầu thuê có thể tăng khi các khu chức năng đi vào hoạt động.</li>
<li><strong>Không mua đuổi theo tin:</strong> mức hưởng lợi phụ thuộc tiến độ thực tế và tốc độ thu hút doanh nghiệp. Nên theo dõi các mốc giao đất, khởi công hạ tầng vị trí số 7 năm 2027 (<a href="https://tuoitre.vn/lo-dien-nha-dau-tu-rot-3525-ti-dong-vao-khu-thuong-mai-tu-do-da-nang-100261019115924845.htm">Tuổi Trẻ</a> đưa tin về chủ trương đầu tư).</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/spana-tower/">Spana Tower Hòa Xuân</a> – căn hộ Sun Group ven sông Cẩm Lệ, thuộc khu đô thị phía Nam có hạ tầng sẵn; nhu cầu ở và thuê của chuyên gia, nhân sự khi vùng phía Tây phát triển là động lực dài hạn.</li>
<li><a href="/du-an/sun-neo-city/">Sun NeO City Hòa Xuân</a> – khu đô thị Sun Group ở Hòa Xuân, cùng hướng phát triển phía Nam – Tây Nam thành phố.</li>
<li><a href="/du-an/ecohome-hoa-hiep-da-nang/">Nhà ở xã hội Ecohome Hòa Hiệp</a> – khu Tây Bắc gần cảng Liên Chiểu và các vị trí khác của Khu thương mại tự do, phù hợp nhu cầu nhà ở của người lao động.</li>
</ul>
<p>Cần xem quy hoạch một thửa đất ở Hòa Vang hoặc tìm căn hộ cho thuê gần các khu công nghiệp, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Quyết định 5202/QĐ-UBND ngày 12/11/2026 của UBND TP Đà Nẵng theo báo chí đưa tin ngày 12 – 13/11/2026 (Sài Gòn Giải Phóng, Báo Đầu tư, Doanh nghiệp Hội nhập); chủ trương đầu tư (Quyết định 4785/QĐ-UBND) theo Tuổi Trẻ, CafeF tháng 10/2026; quyết định thành lập Khu thương mại tự do theo Dân trí, VietNamNet. Bài viết theo trích yếu báo chí, chưa đọc toàn văn quyết định.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Hạ tầng vị trí số 7 khu thương mại tự do: VSIP, 3.525 tỷ',
			'desc'      => 'QĐ 5202/QĐ-UBND (12/11/2026) chọn VSIP làm hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng: 276 ha ở Hòa Vang, vốn 3.525 tỷ, làm từ 2027 đến 2032.',
			'points'    => array(
				'Quyết định 5202/QĐ-UBND ngày 12/11/2026 chấp thuận VSIP là nhà đầu tư hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng',
				'Khoảng 276 ha tại xã Hòa Vang, vốn 3.525 tỷ đồng, hạ tầng làm từ quý 4/2027 đến quý 1/2032',
				'Tác động bất động sản là dài hạn; đất Hòa Vang cần kiểm tra quy hoạch, thu hồi đất trước khi mua',
			),
			'faq'       => array(
				array( 'Vị trí số 7 Khu thương mại tự do Đà Nẵng ở đâu?', 'Theo báo chí, dự án hạ tầng vị trí số 7 nằm tại xã Hòa Vang, TP Đà Nẵng, quy mô khoảng 276 ha.' ),
				array( 'Dự án hạ tầng vị trí số 7 rộng bao nhiêu?', 'Khoảng 276 ha (một số báo ghi khoảng 270 ha), nhỏ hơn diện tích khoảng 401 ha của vị trí số 7 theo quyết định thành lập ban đầu; báo chí chưa giải thích phần chênh lệch.' ),
				array( 'Ai là nhà đầu tư hạ tầng vị trí số 7?', 'Công ty Liên doanh TNHH Khu công nghiệp Việt Nam – Singapore (VSIP), được chấp thuận tại Quyết định 5202/QĐ-UBND ngày 12/11/2026.' ),
				array( 'Khi nào dự án hạ tầng vị trí số 7 xây dựng?', 'Giai đoạn san lấp mặt bằng và xây hạ tầng dự kiến từ quý 4/2027 đến quý 1/2032; thu hút nhà đầu tư thứ cấp từ quý 4/2028.' ),
			),
		),
		'sources'        => array(
			'https://www.sggp.org.vn/chap-thuan-vsip-dau-tu-du-an-ha-tang-3525-ty-dong-tai-khu-thuong-mai-tu-do-da-nang-post881457.html',
			'https://doanhnghiephoinhap.vn/da-nang-chap-thuan-vsip-dau-tu-ha-tang-vi-tri-so-7-khu-thuong-mai-tu-do-hon-3500-ty-dong-154119.html',
			'https://baodautu.vn/hon-3520-ty-dong-dau-tu-vi-tri-so-7-khu-thuong-mai-tu-do-da-nang-d726715.html',
			'https://tuoitre.vn/lo-dien-nha-dau-tu-rot-3525-ti-dong-vao-khu-thuong-mai-tu-do-da-nang-100261019115924845.htm',
			'https://dantri.com.vn/thoi-su/quyet-dinh-7-vi-tri-lam-khu-thuong-mai-tu-do-da-nang-20250616155817749.htm',
		),
	);
	/* ---------------- 14/11 – Đà Nẵng rà soát nhà ở xã hội (buổi làm việc 10/11): 8 dự án, khoảng 4.575 căn sắp khởi công ---------------- */
	$posts[] = array(
		'slug'           => 'khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026',
		'old_slug'       => array( 'da-nang-khoi-cong-8-du-an-nha-o-xa-hoi-4575-can-cuoi-2026' ),
		'title'          => 'Đà Nẵng sắp khởi công 8 dự án nhà ở xã hội, khoảng 4.575 căn trong 2 tháng cuối năm 2026',
		'excerpt'        => 'Tại buổi làm việc ngày 10/11/2026, Đà Nẵng cho biết từ đầu năm đã giao chủ đầu tư 10 dự án nhà ở xã hội (9.916 căn), đã khởi công 4 dự án, mở bán 4 dự án và dự kiến khởi công thêm 8 dự án với khoảng 4.575 căn trong 2 tháng cuối năm. Danh mục 113 khu đất khoảng 390 ha là quỹ đất cho giai đoạn 2026 – 2030.',
		'keyword'        => 'nhà ở xã hội Đà Nẵng',
		'keywords_extra' => array( 'nhà ở xã hội Đà Nẵng 2026', '113 khu đất nhà ở xã hội Đà Nẵng', 'mua nhà ở xã hội Đà Nẵng', 'Quyết định 2259/QĐ-UBND' ),
		'project'        => '',
		'schedule'       => '2026-11-14 07:00',
		'rev'            => 2, // 15/11: chuẩn SEO 100/100.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Nhà ở xã hội', 'Chính sách nhà ở', 'Hạ tầng Đà Nẵng' ),
		'image'          => 'plugin:img/tin-tuc/da-nang-khoi-cong-8-du-an-nha-o-xa-hoi-4575-can-cuoi-2026.jpg',
		'image_alt'      => 'Nhà ở xã hội Đà Nẵng: sắp khởi công 8 dự án, khoảng 4.575 căn trong 2 tháng cuối năm 2026',
		'content'        => <<<HTML
<p><strong>Nhà ở xã hội Đà Nẵng</strong> sắp có thêm nguồn cung lớn. Ngày 10/11/2026, tại buổi làm việc về tình hình phát triển nhà ở xã hội (Chủ tịch HĐND thành phố Nguyễn Đức Dũng chủ trì, theo <a href="https://vnexpress.net/da-nang-duyet-113-khu-dat-lam-nha-o-xa-hoi-5143099.html">VnExpress</a>), Sở Xây dựng Đà Nẵng báo cáo: từ đầu năm 2026 thành phố đã chấp thuận chủ trương đầu tư, giao chủ đầu tư <strong>10 dự án với khoảng 9.916 căn</strong>; trong 2 tháng cuối năm dự kiến <strong>khởi công thêm 8 dự án, khoảng 4.575 căn</strong>. Đây là nguồn cung đáng chú ý cho người thu nhập thấp, công nhân, cán bộ – công chức đang tìm nhà ở Đà Nẵng.</p>
<!--hh-featured-->
<h2>Nhà ở xã hội Đà Nẵng 2026: các con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Đã giao chủ đầu tư từ đầu năm 2026</td><td>10 dự án, khoảng 9.916 căn</td></tr>
<tr><td>Đã khởi công</td><td>4 dự án, khoảng 2.232 căn</td></tr>
<tr><td>Đã mở bán</td><td>4 dự án, khoảng 2.685 căn</td></tr>
<tr><td>Dự kiến khởi công 2 tháng cuối năm</td><td>8 dự án, khoảng 4.575 căn</td></tr>
<tr><td>Chỉ tiêu giai đoạn 2026 – 2030</td><td>26.279 căn (Nghị quyết 303/NQ-CP ngày 30/9/2026 của Chính phủ, theo báo chí)</td></tr>
<tr><td>Quỹ đất đã duyệt</td><td>113 khu đất, khoảng 390 ha (Quyết định 2259/QĐ-UBND ngày 22/5/2026): 24 khu đang triển khai dự án, 89 khu dự kiến triển khai giai đoạn tiếp theo</td></tr>
</tbody>
</table>
<h2>Quỹ đất nhà ở xã hội Đà Nẵng: 113 khu, những khu lớn nhất</h2>
<p>Theo Quyết định 2259/QĐ-UBND, các khu đất có quy mô lớn trong danh mục gồm: Khu đô thị Tam Hòa – Tam Tiến khoảng 20,3 ha; Điểm dân cư số 1 tại xã Hòa Tiến khoảng 20,2 ha; Khu đô thị Chu Lai (xã Núi Thành) khoảng 17,4 ha; Khu nhà ở xã hội Vạn Phúc – Hội An (phường Hội An Tây) khoảng 12,41 ha. Quỹ đất trải ra cả khu vực Đà Nẵng cũ lẫn vùng Quảng Nam cũ sau hợp nhất – từ các xã phía Tây, phía Nam đến Hội An, Chu Lai.</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg|Khu đô thị ven sông Cẩm Lệ – Hòa Xuân, nơi có các dự án nhà ở xã hội Lê Kim Lăng và Hòa Phước (ảnh flycam thực tế tháng 8/2025)-->
<h2>Điều gì còn làm chậm tiến độ nhà ở xã hội Đà Nẵng?</h2>
<p>Theo Sở Xây dựng, tiến độ nhiều dự án nhà ở xã hội Đà Nẵng còn phụ thuộc vào việc điều chỉnh quy hoạch, giải phóng mặt bằng và đầu tư hạ tầng kỹ thuật kết nối; nguồn cung nhà ở xã hội <strong>cho thuê</strong> cũng còn thiếu so với chỉ tiêu. Các con số 4.575 căn hay 26.279 căn vì vậy là kế hoạch, chưa phải kết quả – người mua nên theo dõi thông báo mở bán chính thức của từng dự án.</p>
<h2>Ai được mua nhà ở xã hội Đà Nẵng?</h2>
<p>Theo Luật Nhà ở 2023 (<a href="https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Nha-o-2023-27-2023-QH15-528669.aspx">toàn văn trên Thư viện Pháp luật</a>), đối tượng được mua nhà ở xã hội gồm nhiều nhóm như người thu nhập thấp ở đô thị, công nhân, người lao động trong doanh nghiệp, cán bộ – công chức – viên chức, lực lượng vũ trang… kèm điều kiện về nhà ở hiện có và thu nhập theo văn bản hướng dẫn. Người mua nhà ở xã hội Đà Nẵng nên chuẩn bị trước giấy xác nhận đối tượng, xác nhận thực trạng nhà ở và thu nhập, vì mỗi dự án chỉ nhận hồ sơ trong một khoảng thời gian nhất định.</p>
<h2>Tác động / nhận định của Hoàng Hiệp về nhà ở xã hội Đà Nẵng</h2>
<ul>
<li><strong>Cơ hội cho người mua nhà đầu tiên:</strong> nguồn cung nhà ở xã hội Đà Nẵng tăng mạnh từ cuối 2026 – 2027. Người đủ điều kiện (theo Luật Nhà ở 2023 và các văn bản hướng dẫn về đối tượng, thu nhập, nhà ở hiện có) nên chuẩn bị hồ sơ xác nhận sớm để kịp đợt nhận hồ sơ của từng dự án.</li>
<li><strong>Giá căn hộ thương mại bình dân bị cạnh tranh:</strong> phân khúc căn hộ thương mại giá thấp ở vùng ven (Liên Chiểu, Hòa Vang, Cẩm Lệ) sẽ chịu cạnh tranh trực tiếp từ nhà ở xã hội có giá thấp hơn và được vay ưu đãi.</li>
<li><strong>Hạ tầng đi kèm:</strong> các khu nhà ở xã hội lớn thường kéo theo đường, trường, chợ – khu vực xung quanh (đặc biệt Hòa Tiến, Tam Hòa – Tam Tiến, Chu Lai) sẽ đông dân hơn, có lợi cho nhà phố kinh doanh, dịch vụ quanh đó về dài hạn.</li>
<li><strong>Không mua suất nhà ở xã hội qua trung gian:</strong> hồ sơ mua nhà ở xã hội nộp trực tiếp cho chủ đầu tư và được xét theo điều kiện; tránh các lời mời "giữ suất", "mua lại suất" có thu tiền.</li>
<li><strong>Không đủ điều kiện nhà ở xã hội:</strong> có thể tham khảo căn hộ thương mại giá vừa tại khu Nam, Hòa Xuân – nơi hạ tầng đã đồng bộ.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/loai-du-an/nha-o-xa-hoi/">Danh sách nhà ở xã hội Đà Nẵng trên web</a> – tổng hợp các dự án nhà ở xã hội, thu nhập thấp đang triển khai để anh chị so sánh vị trí, quy mô.</li>
<li><a href="/du-an/nha-o-xa-hoi-le-kim-lang-hoa-xuan/">Nhà ở xã hội Lê Kim Lăng (Hòa Xuân)</a> và <a href="/du-an/nha-o-xa-hoi-hoa-phuoc-hoa-xuan/">Khu nhà ở xã hội Hòa Phước (Hòa Xuân)</a> – nằm trong khu đô thị Hòa Xuân, hạ tầng sẵn, thuộc nhóm dự án nhà ở xã hội khu Nam thành phố.</li>
<li><a href="/du-an/nha-o-xa-hoi-chung-cu-so-5-nam-cau-cam-le/">Nhà ở xã hội Khu chung cư số 5 – Nam cầu Cẩm Lệ</a> – nguồn cung khu Cẩm Lệ, gần trung tâm.</li>
<li><a href="/du-an/nha-o-xa-hoi-bac-hoa-khanh/">Nhà ở xã hội Bắc Hòa Khánh</a> – khu Liên Chiểu, gần khu công nghiệp, phù hợp công nhân và người lao động.</li>
<li><a href="/du-an/nha-o-xa-hoi-con-tien-hoi-an/">Nhà ở xã hội Khu đô thị Cồn Tiến (Hội An)</a> và <a href="/du-an/nha-o-xa-hoi-nui-thanh-chu-lai/">Khu nhà ở xã hội Núi Thành (Chu Lai)</a> – vùng Quảng Nam cũ, nơi có các khu đất lớn trong danh mục 113 khu (Hội An Tây, Chu Lai).</li>
</ul>
<p>Cần kiểm tra điều kiện mua nhà ở xã hội Đà Nẵng hoặc so sánh với căn hộ thương mại giá vừa, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: buổi làm việc về nhà ở xã hội ngày 10/11/2026 theo VnExpress, CafeF, Báo Đầu tư, VietTimes, Vietbao (10 – 11/11/2026); Quyết định 2259/QĐ-UBND ngày 22/5/2026 về danh mục 113 vị trí khu đất phát triển nhà ở xã hội theo VnEconomy, Báo Xây dựng, Bộ Xây dựng (5/2026). Bài viết theo trích yếu báo chí, chưa đọc toàn văn các văn bản.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Nhà ở xã hội Đà Nẵng: sắp khởi công 8 dự án, 4.575 căn',
			'desc'      => 'Nhà ở xã hội Đà Nẵng: dự kiến khởi công 8 dự án, khoảng 4.575 căn cuối 2026; đã giao 10 dự án 9.916 căn; quỹ 113 khu đất 390 ha. Ai nên chú ý?',
			'points'    => array(
				'Nhà ở xã hội Đà Nẵng: ngày 10/11/2026 thành phố dự kiến khởi công 8 dự án, khoảng 4.575 căn trong 2 tháng cuối năm',
				'Từ đầu 2026: giao chủ đầu tư 10 dự án (9.916 căn), khởi công 4 dự án, mở bán 4 dự án',
				'Quỹ 113 khu đất khoảng 390 ha (QĐ 2259/QĐ-UBND), chỉ tiêu 26.279 căn giai đoạn 2026 – 2030',
			),
			'faq'       => array(
				array( 'Đà Nẵng có bao nhiêu dự án nhà ở xã hội sắp khởi công?', 'Theo báo cáo tại buổi làm việc ngày 10/11/2026, thành phố dự kiến khởi công thêm 8 dự án với khoảng 4.575 căn trong 2 tháng cuối năm 2026.' ),
				array( 'Danh mục 113 khu đất nhà ở xã hội Đà Nẵng là gì?', 'Quyết định 2259/QĐ-UBND ngày 22/5/2026 phê duyệt 113 vị trí khu đất khoảng 390 ha để phát triển nhà ở xã hội, gồm 24 khu đang triển khai và 89 khu dự kiến triển khai giai đoạn tiếp theo.' ),
				array( 'Nhà ở xã hội Đà Nẵng mục tiêu bao nhiêu căn đến 2030?', 'Chỉ tiêu giai đoạn 2026 – 2030 là 26.279 căn theo Nghị quyết 303/NQ-CP được báo chí dẫn; đây là kế hoạch, tiến độ còn phụ thuộc quy hoạch, giải phóng mặt bằng và hạ tầng.' ),
				array( 'Mua nhà ở xã hội Đà Nẵng cần chú ý gì?', 'Kiểm tra điều kiện về đối tượng, thu nhập, nhà ở hiện có theo Luật Nhà ở 2023; nộp hồ sơ trực tiếp cho chủ đầu tư khi dự án thông báo nhận hồ sơ, không mua "suất" qua trung gian.' ),
			),
		),
		'sources'        => array(
			'https://vnexpress.net/da-nang-duyet-113-khu-dat-lam-nha-o-xa-hoi-5143099.html',
			'https://cafef.vn/da-nang-chot-113-khu-dat-lam-nha-o-xa-hoi-188261111200430276.chn',
			'https://baodautu.vn/da-nang-chuan-bi-khoi-cong-them-8-du-an-nha-o-xa-hoi-d664013.html',
			'https://viettimes.vn/da-nang-chuan-bi-khoi-cong-8-du-an-nha-o-xa-hoi-bo-sung-hon-4500-can-post208239.html',
			'https://vietbao.vn/da-nang-ra-tien-do-nha-o-xa-hoi-muc-tieu-26279-can-den-nam-2030-615377.html',
			'https://vneconomy.vn/da-nang-phe-duyet-danh-muc-113-vi-tri-khu-dat-phat-trien-nha-o-xa-hoi.htm',
			'https://baoxaydung.vn/da-nang-phe-duyet-danh-muc-113-khu-dat-phat-trien-nha-o-xa-hoi-192260523080124625.htm',
			'https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Nha-o-2023-27-2023-QH15-528669.aspx',
		),
	);
	/* ---------------- 18/11 – Khu đất VTV8 cũ (258 Bạch Đằng, 270 Trần Phú): hơn 6.200 m² làm công viên, bãi đỗ xe ngầm ---------------- */
	$posts[] = array(
		'slug'           => 'bai-do-xe-ngam-bach-dang-da-nang',
		'title'          => 'Bãi đỗ xe ngầm Bạch Đằng: Đà Nẵng dành hơn 6.200 m² đất vàng gần cầu Rồng làm công viên',
		'excerpt'        => 'Đà Nẵng thống nhất bố trí lại quỹ đất trên đường Bạch Đằng: VTV8 nhận đất 250 – 254 Bạch Đằng xây trụ sở mới, khoảng 6.284,6 m² tại 258 Bạch Đằng và 270 Trần Phú dành cho công viên cây xanh, giao thông và bãi đỗ xe ngầm.',
		'keyword'        => 'bãi đỗ xe ngầm Bạch Đằng',
		'keywords_extra' => array( 'đất vàng Bạch Đằng', 'trụ sở VTV8 Đà Nẵng', 'công viên ven sông Hàn', 'căn hộ ven sông Hàn' ),
		'project'        => 'the-filmore-da-nang',
		'schedule'       => '2026-11-18 07:00', // Tin tức lên sớm nhất (anh Hiệp 18/11/2026).
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Sông Hàn', 'Hải Châu' ),
		'image'          => 'plugin:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg',
		'image_alt'      => 'Sông Hàn và cầu Rồng về đêm – khu vực quy hoạch bãi đỗ xe ngầm Bạch Đằng, Đà Nẵng',
		'content'        => <<<HTML
<p>Đà Nẵng sẽ có thêm <strong>bãi đỗ xe ngầm Bạch Đằng</strong> và công viên cây xanh trên khu "đất vàng" gần cầu Rồng. Theo Trung tâm Phát triển quỹ đất TP Đà Nẵng (thông tin ngày 16/11/2026), UBND thành phố đã thống nhất phương án bố trí lại quỹ đất trên đường Bạch Đằng: Đài Phát thanh – Truyền hình khu vực Miền Trung – Tây Nguyên (VTV8) nhận đất xây trụ sở mới, phần còn lại khoảng <strong>6.284,6 m²</strong> dành cho không gian công cộng.</p>
<!--hh-featured-->
<h2>Phương án bãi đỗ xe ngầm Bạch Đằng gồm những gì?</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Đất giao VTV8 xây trụ sở mới</td><td>Các lô 250, 252, 254 Bạch Đằng và khoảng 1.100 m² thuộc khu đất 258 Bạch Đằng hiện nay</td></tr>
<tr><td>Đất dành cho công cộng</td><td>Khoảng 6.284,6 m² tại 258 Bạch Đằng (trụ sở VTV8 hiện tại) và 270 Trần Phú (trụ sở UBND quận Hải Châu cũ)</td></tr>
<tr><td>Định hướng sử dụng</td><td>Giao thông, bãi đỗ xe ngầm; mặt đất làm công viên cây xanh, kiến trúc cảnh quan</td></tr>
<tr><td>Đơn vị chủ trì thủ tục</td><td>Sở Tài chính chủ trì sắp xếp, xử lý tài sản công tại 258 Bạch Đằng</td></tr>
<tr><td>Trong thời gian chờ</td><td>VTV8 tiếp tục sử dụng trụ sở 258 Bạch Đằng đến khi trụ sở mới hoàn thành, đi vào hoạt động</td></tr>
</tbody>
</table>
<p>Một số báo ghi "hơn 6.200 m²", số liệu chi tiết của Trung tâm Phát triển quỹ đất là 6.284,6 m². Đây mới là phương án bố trí quỹ đất và định hướng nghiên cứu; quy mô, số chỗ đỗ, thời gian khởi công <strong>bãi đỗ xe ngầm Bạch Đằng</strong> chưa được công bố (<a href="https://tuoitre.vn/da-nang-danh-hon-6200m-dat-vang-bach-dang-tran-phu-lam-cong-vien-bai-do-xe-100261116103332289.htm">Tuổi Trẻ</a>).</p>
<h2>Vì sao khu đất này được gọi là "đất vàng"?</h2>
<p>Khu đất nằm giữa đường Bạch Đằng ven sông Hàn và đường Trần Phú, trong lõi trung tâm Hải Châu, gần cầu Rồng – nơi tập trung khách du lịch, khách sạn, nhà hàng và các sự kiện của thành phố. Quỹ đất trống ở đây gần như không còn; mọi khu đất lớn được giải phóng đều có giá trị đặc biệt.</p>
<p>Việc dành phần lớn diện tích cho công viên và <strong>bãi đỗ xe ngầm Bạch Đằng</strong> thay vì cho xây cao tầng thương mại phù hợp chủ trương sắp xếp lại trụ sở dôi dư sau hợp nhất hành chính: ưu tiên mục đích công cộng, giải quyết thiếu chỗ đỗ xe ở trung tâm (<a href="https://vnexpress.net/tru-so-doi-du-da-nang-danh-6-200-m2-lam-bai-xe-ngam-quang-tri-cai-tao-thanh-truong-hoc-5141841.html">VnExpress</a>).</p>
<!--hh-img:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg|Sông Hàn, du thuyền và cầu Rồng về đêm – khu trung tâm nơi Đà Nẵng định hướng bãi đỗ xe ngầm Bạch Đằng và công viên cây xanh-->
<h2>Thiếu chỗ đỗ xe ở trung tâm – vì sao cần bãi đỗ xe ngầm Bạch Đằng</h2>
<p>Khu ven sông Hàn từ cầu Rồng đến cầu Sông Hàn đông khách vào buổi tối và cuối tuần, đặc biệt mùa du lịch và các dịp lễ hội. Xe du lịch, ô tô cá nhân phần lớn đỗ dưới lòng đường hoặc trong các bãi tạm. Nếu được đầu tư, bãi đỗ xe ngầm Bạch Đằng ngay trên trục Bạch Đằng – Trần Phú sẽ giảm tải cho mặt đường và giải phóng vỉa hè cho người đi bộ.</p>
<p>Phần mặt đất làm công viên cây xanh giúp nối dài không gian xanh ven sông, phù hợp định hướng phát triển đô thị ven sông Hàn trong quy hoạch chung thành phố (xem thêm <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng đến 2050</a>).</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<p>Theo Hiệp, bãi đỗ xe ngầm Bạch Đằng và công viên trên khu đất này tác động tới bất động sản trung tâm theo 4 hướng:</p>
<ul>
<li><strong>Thêm không gian xanh, giữ "tầm nhìn sông Hàn":</strong> khu đất không bị xây khối cao tầng thương mại mà làm công viên, nên các tòa nhà xung quanh giữ được thông thoáng và tầm nhìn về phía sông. Đây là điểm cộng cho căn hộ, khách sạn ven sông Hàn ở Hải Châu.</li>
<li><strong>Bãi đỗ xe ngầm Bạch Đằng là "tiện ích công" cho cả khu:</strong> người ở căn hộ trung tâm, khách thuê ngắn ngày và khách đến nhà hàng – khách sạn sẽ có thêm chỗ đỗ ô tô, vốn là điểm yếu lớn nhất của khu phố cổ Bạch Đằng – Trần Phú.</li>
<li><strong>Đây mới là định hướng:</strong> chưa có quy mô, nhà đầu tư hay thời gian thi công. Anh chị không nên mua bán theo tin "sắp có công viên, bãi xe" với giá đẩy cao; nên theo dõi các bước tiếp theo của Sở Tài chính và UBND thành phố.</li>
<li><strong>Quỹ căn hộ ven sông Hàn rất hiếm:</strong> trục Bạch Đằng gần như không còn đất cho dự án mới; mỗi lần trung tâm được chỉnh trang, nhu cầu ở và thuê ven sông lại tăng. Với khách mua để ở lâu dài, nên ưu tiên dự án đã hoàn thiện, có sổ hồng.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/the-filmore-da-nang/">The Filmore Đà Nẵng</a> – tòa căn hộ hạng sang mặt tiền đường Bạch Đằng, cùng trục ven sông Hàn với khu đất; không gian xanh và bãi đỗ xe ngầm Bạch Đằng (khi hình thành) là lợi thế cho cư dân và khách thuê.</li>
<li><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> – căn hộ Sun Group ở chân cầu Rồng bờ Đông, nhìn sang khu trung tâm Bạch Đằng; khu bờ Tây được chỉnh trang làm tăng giá trị tầm nhìn sông Hàn của dự án.</li>
</ul>
<p>Xem thêm các <a href="/can-ho-ven-song-han-da-nang/">căn hộ ven sông Hàn Đà Nẵng</a> đang bán và cho thuê. Cần tư vấn căn hộ trung tâm Hải Châu, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Trung tâm Phát triển quỹ đất TP Đà Nẵng theo Tuổi Trẻ, Thanh Niên, VnExpress, VietTimes ngày 16 – 17/11/2026. Bài viết theo thông tin báo chí, chưa đọc toàn văn văn bản của UBND thành phố.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Bãi đỗ xe ngầm Bạch Đằng: hơn 6.200 m² gần cầu Rồng',
			'desc'      => 'Đà Nẵng dành khoảng 6.284,6 m² đất 258 Bạch Đằng, 270 Trần Phú làm công viên và bãi đỗ xe ngầm Bạch Đằng; VTV8 nhận đất 250 – 254 Bạch Đằng.',
			'points'    => array(
				'Đà Nẵng thống nhất bố trí lại quỹ đất Bạch Đằng: VTV8 nhận đất 250, 252, 254 Bạch Đằng và khoảng 1.100 m² tại 258 Bạch Đằng xây trụ sở mới',
				'Khoảng 6.284,6 m² tại 258 Bạch Đằng và 270 Trần Phú định hướng làm bãi đỗ xe ngầm Bạch Đằng, công viên cây xanh, giao thông',
				'Mới là phương án quỹ đất; chưa có quy mô, nhà đầu tư, thời gian thi công',
			),
			'faq'       => array(
				array( 'Bãi đỗ xe ngầm Bạch Đằng nằm ở đâu?', 'Trên khu đất khoảng 6.284,6 m² gồm 258 Bạch Đằng (trụ sở VTV8 hiện tại) và 270 Trần Phú (trụ sở UBND quận Hải Châu cũ), gần cầu Rồng, trung tâm Đà Nẵng.' ),
				array( 'Khi nào làm bãi đỗ xe ngầm Bạch Đằng?', 'Chưa có thời gian. Đây mới là phương án bố trí lại quỹ đất; VTV8 tiếp tục dùng trụ sở 258 Bạch Đằng đến khi trụ sở mới hoàn thành.' ),
				array( 'VTV8 chuyển trụ sở về đâu?', 'Theo phương án, VTV8 được bố trí đất tại 250, 252, 254 Bạch Đằng và khoảng 1.100 m² thuộc khu đất 258 Bạch Đằng để xây trụ sở mới.' ),
				array( 'Bãi đỗ xe ngầm Bạch Đằng ảnh hưởng gì tới căn hộ ven sông Hàn?', 'Khu trung tâm có thêm công viên và chỗ đỗ ô tô, giữ tầm nhìn sông Hàn thông thoáng – có lợi cho căn hộ, khách sạn quanh trục Bạch Đằng – Trần Phú về dài hạn.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/da-nang-danh-hon-6200m-dat-vang-bach-dang-tran-phu-lam-cong-vien-bai-do-xe-100261116103332289.htm',
			'https://thanhnien.vn/da-nang-quy-hoach-lai-khu-dat-vang-gan-cau-rong-lam-cong-vien-bai-do-xe-18526111610593433.htm',
			'https://vnexpress.net/tru-so-doi-du-da-nang-danh-6-200-m2-lam-bai-xe-ngam-quang-tri-cai-tao-thanh-truong-hoc-5141841.html',
			'https://viettimes.vn/da-nang-danh-dat-vang-xay-tru-so-vtv8-phat-trien-khong-gian-cong-cong-post208479.html',
		),
	);
	/* ---------------- 18/11 – Việt Hương Lakeside: nhà ở xã hội khu đất chung cư số 5, KDC Nam cầu Cẩm Lệ (anh Hiệp chụp bảng thông tin công trường) ---------------- */
	$vh = '<a href="/du-an/viet-huong-lakeside-hoa-xuan/">Việt Hương Lakeside</a>';
	$posts[] = array(
		'slug'           => 'nha-o-xa-hoi-viet-huong-lakeside-hoa-xuan',
		'title'          => 'Nhà ở xã hội Việt Hương Lakeside Hòa Xuân: 1.306 căn, 14 tầng, giá tạm tính khoảng 20,7 triệu/m²',
		'excerpt'        => 'Toàn cảnh nhà ở xã hội Việt Hương Lakeside tại khu đất chung cư số 5, KDC Nam cầu Cẩm Lệ (Hòa Xuân): 4 khối 14 tầng, 1.306 căn, giấy phép xây dựng 18/12/2025, khởi công 19/12/2025, giá tạm tính khoảng 20,7 triệu/m², đợt 1 đã bốc thăm 15/10/2026.',
		'keyword'        => 'nhà ở xã hội Việt Hương Lakeside',
		'keywords_extra' => array( 'nhà ở xã hội Hòa Xuân', 'nhà ở xã hội Đà Nẵng 2026', 'khu dân cư Nam cầu Cẩm Lệ', 'điều kiện mua nhà ở xã hội' ),
		'project'        => 'viet-huong-lakeside-hoa-xuan',
		'schedule'       => '2026-11-18 10:00', // Tin tức lên sớm nhất (anh Hiệp 18/11/2026).
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Nhà ở xã hội', 'Hòa Xuân', 'Cẩm Lệ' ),
		'image'          => 'plugin:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg',
		'image_alt'      => 'Khu vực Hòa Xuân ven sông Cẩm Lệ – nơi xây nhà ở xã hội Việt Hương Lakeside (ảnh flycam thực tế)',
		'content'        => <<<HTML
<p><strong>Nhà ở xã hội Việt Hương Lakeside</strong> là dự án đang thi công trên khu đất chung cư số 5 thuộc Khu B – Khu dân cư Nam cầu Cẩm Lệ, phường Hòa Xuân. Hoàng Hiệp vừa ghé công trường và ghi lại bảng thông tin dự án; bài này tổng hợp bảng công trường với thông báo của Sở Xây dựng, Cổng thông tin điện tử Đà Nẵng và báo chí để anh chị đang tìm nhà ở xã hội có bức tranh đầy đủ.</p>
<!--hh-featured-->
<h2>Nhà ở xã hội Việt Hương Lakeside là dự án nào?</h2>
<p>Tên pháp lý là "Dự án Nhà ở xã hội tại khu đất chung cư số 5 thuộc Khu B – Khu dân cư Nam cầu Cẩm Lệ"; "Việt Hương Lakeside" là tên thương mại, báo chí còn gọi là nhà ở xã hội B5 Hòa Xuân. Chủ đầu tư là Công ty CP Đầu tư Phát triển Nhà ở Toàn Cầu, trụ sở trên đường Phạm Hùng, phường Hòa Xuân. Lưu ý đây là khu đất số 5; khu đất chung cư số 3 cùng Khu B là một dự án nhà ở xã hội khác của chủ đầu tư khác, khởi công cùng ngày.</p>
<p>Khu đất nhà ở xã hội Việt Hương Lakeside nằm giữa các đường Nguyễn Kim (phía Bắc), Huỳnh Tịnh Của (phía Đông), Lê Trực (phía Tây); phía Nam giáp hồ điều tiết và cây xanh công cộng – đó là lý do dự án có chữ "Lakeside".</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg|Khu vực Hòa Xuân ven sông Cẩm Lệ, nơi có nhà ở xã hội Việt Hương Lakeside (ảnh flycam thực tế 8/2025)-->
<h2>Thông số trên bảng công trường</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Diện tích khu đất</td><td>28.942,72 m²</td></tr>
<tr><td>Diện tích xây dựng</td><td>10.418,82 m²</td></tr>
<tr><td>Cấp công trình, số tầng</td><td>Cấp I, 14 tầng, 1 tầng hầm</td></tr>
<tr><td>Giấy phép xây dựng</td><td>Số 11111/SXD-GPXD ngày 18/12/2025</td></tr>
<tr><td>Khởi công – thời gian thi công</td><td>19/12/2025 – 24 tháng</td></tr>
<tr><td>Tư vấn thiết kế</td><td>Tổng công ty Tư vấn Xây dựng Việt Nam – CTCP</td></tr>
<tr><td>Thi công chính</td><td>Liên danh Tổng công ty 36 – CTCP và Công ty CP Đầu tư và Phát triển Đông Bắc</td></tr>
</tbody>
</table>
<h2>Quy mô nhà ở xã hội Việt Hương Lakeside: 4 khối, 1.306 căn</h2>
<p>Theo thông tin công bố, nhà ở xã hội Việt Hương Lakeside gồm 4 khối nhà 14 tầng, tổng sàn khoảng 145.000 m², vốn đầu tư khoảng 1.730 tỷ đồng. Ba khối nhà ở xã hội XH1, XH2, XH3 có 1.040 căn (lần lượt 424, 411 và 205 căn); một khối nhà ở thương mại có 266 căn. Căn 1 phòng ngủ khoảng 36 – 42 m², 2 phòng ngủ khoảng 70 m², 3 phòng ngủ khoảng 77 m².</p>
<p>Giá tạm tính công bố khi mở bán đợt 1 của nhà ở xã hội Việt Hương Lakeside khoảng 20,7 triệu đồng/m² sử dụng, đã gồm VAT, chưa gồm phí bảo trì; giá chính thức sẽ ghi trong hợp đồng mua bán. So với căn hộ thương mại khu Hòa Xuân – Cẩm Lệ, đây là mức giá dễ tiếp cận cho người thu nhập thấp và người lao động.</p>
<h2>Đợt 1 đã nhận hồ sơ và bốc thăm</h2>
<ul>
<li><strong>16/3/2026:</strong> Sở Xây dựng công khai thông tin tiếp nhận hồ sơ đăng ký mua nhà ở xã hội Việt Hương Lakeside, đợt 1 gồm 849 căn (XH1 336 căn, XH2 345 căn, XH3 168 căn).</li>
<li><strong>16/4 – 16/5/2026:</strong> chủ đầu tư nhận hồ sơ trực tiếp, trực tuyến, qua bưu chính hoặc qua cơ quan nơi làm việc.</li>
<li><strong>15/10/2026:</strong> bốc thăm quyền mua tại UBND phường Hòa Xuân với hơn 1.000 khách hàng tham gia, theo Báo Đà Nẵng.</li>
</ul>
<p>Như vậy đợt 1 của nhà ở xã hội Việt Hương Lakeside đã khép lại. Người chưa nộp hồ sơ cần chờ thông báo đợt tiếp theo (nếu còn căn), danh sách dự khuyết, hoặc cân nhắc 266 căn thương mại khi chủ đầu tư mở bán.</p>
<h2>Ai được mua nhà ở xã hội Việt Hương Lakeside?</h2>
<p>Người mua phải thuộc nhóm đối tượng được hưởng chính sách nhà ở xã hội theo Điều 76 Luật Nhà ở 2023 – như người thu nhập thấp tại đô thị, công nhân, cán bộ công chức viên chức, lực lượng vũ trang – và đáp ứng điều kiện về nhà ở, thu nhập. Hồ sơ gồm đơn đăng ký, giấy xác nhận đối tượng và thu nhập, giấy xác nhận điều kiện nhà ở cùng giấy tờ nhân thân theo mẫu của Bộ Xây dựng. Căn nhà ở xã hội bị hạn chế chuyển nhượng trong thời gian luật định, nên chỉ phù hợp người mua để ở.</p>
<h2>Tiến độ và mốc bàn giao</h2>
<p>Bảng công trường nhà ở xã hội Việt Hương Lakeside ghi thời gian thi công 24 tháng kể từ 19/12/2025. Tháng 8/2026, UBND thành phố yêu cầu các chủ đầu tư nhà ở xã hội, trong đó có dự án này, thực hiện đúng cam kết tiến độ; một số báo ghi dự kiến bàn giao cuối năm 2027. Người đã có quyền mua nên theo dõi thông báo của chủ đầu tư về lịch ký hợp đồng và các đợt thanh toán.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Thêm nguồn cung nhà ở giá vừa túi tiền ở phía Nam:</strong> nhà ở xã hội Việt Hương Lakeside cùng dự án khu đất số 3 bên cạnh bổ sung gần 2.000 căn cho khu Hòa Xuân – Cẩm Lệ, nằm trong mục tiêu phát triển nhà ở xã hội của thành phố (xem <a href="/khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026/">nhà ở xã hội Đà Nẵng 2026</a>).</li>
<li><strong>Vị trí thuận tiện:</strong> gần sông Cẩm Lệ, Aeon Mall Hòa Xuân và trục đi trung tâm, hạ tầng khu Nam cầu Cẩm Lệ đã hình thành.</li>
<li><strong>Cơ hội cho người chưa trúng đợt 1:</strong> theo dõi đợt nhận hồ sơ tiếp theo và căn thương mại; chuẩn bị sẵn giấy xác nhận đối tượng, thu nhập để không lỡ hạn.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Trang dự án {$vh} cập nhật thông tin, tiến độ và các đợt nhận hồ sơ. Khu Hòa Xuân còn nhiều dự án đất nền, nhà phố ven sông Cẩm Lệ – anh chị cần so sánh với nhà ở xã hội Việt Hương Lakeside, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được hướng dẫn điều kiện và hồ sơ.</p>
<p class="src">Nguồn: <a href="https://danang.gov.vn/vi/web/dng/w/cong-khai-thong-tin-tiep-nhan-ho-so-dang-ky-mua-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le">Cổng thông tin điện tử TP Đà Nẵng</a>, <a href="https://hoaxuan.danang.gov.vn/ve-viec-lay-y-kien-ve-dieu-chinh-quy-hoach-chi-tiet-ty-le-1-500-du-an-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le/">UBND phường Hòa Xuân</a>, <a href="https://baodanang.vn/hon-1-000-khach-hang-boc-tham-du-an-nha-o-xa-hoi-b5-hoa-xuan-3355268.html">Báo Đà Nẵng</a>, CafeLand; bảng thông tin công trường (Hoàng Hiệp chụp 11/2026). Giá tạm tính, mang tính tham khảo.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Nhà ở xã hội Việt Hương Lakeside: 1.306 căn Hòa Xuân',
			'desc'      => 'Nhà ở xã hội Việt Hương Lakeside ở Hòa Xuân: 4 khối 14 tầng, 1.306 căn 36 – 77 m², giá tạm tính khoảng 20,7 triệu/m², đợt 1 đã bốc thăm 15/10/2026.',
			'points'    => array(
				'Khu đất chung cư số 5, Khu B – KDC Nam cầu Cẩm Lệ (Hòa Xuân): 4 khối 14 tầng, 1.040 căn nhà ở xã hội và 266 căn thương mại',
				'Giấy phép xây dựng 11111/SXD-GPXD ngày 18/12/2025, khởi công 19/12/2025, thi công 24 tháng',
				'Giá tạm tính khoảng 20,7 triệu/m² (đã gồm VAT); đợt 1 849 căn đã bốc thăm ngày 15/10/2026',
			),
			'faq'       => array(
				array( 'Nhà ở xã hội Việt Hương Lakeside ở đâu?', 'Khu đất chung cư số 5 thuộc Khu B – Khu dân cư Nam cầu Cẩm Lệ, phường Hòa Xuân, giữa các đường Nguyễn Kim – Huỳnh Tịnh Của – Lê Trực, phía Nam giáp hồ điều tiết.' ),
				array( 'Giá nhà ở xã hội Việt Hương Lakeside bao nhiêu?', 'Giá tạm tính công bố khi mở bán đợt 1 khoảng 20,7 triệu đồng/m² sử dụng, đã gồm VAT, chưa gồm phí bảo trì; giá chính thức theo hợp đồng.' ),
				array( 'Còn nộp hồ sơ mua được không?', 'Đợt 1 (849 căn) đã nhận hồ sơ 16/4 – 16/5/2026 và bốc thăm 15/10/2026. Cần chờ thông báo đợt tiếp theo hoặc danh sách dự khuyết của chủ đầu tư.' ),
				array( 'Khi nào dự án hoàn thành?', 'Bảng công trường ghi thi công 24 tháng từ 19/12/2025; báo chí ghi dự kiến bàn giao cuối năm 2027.' ),
			),
		),
		'sources'        => array(
			'https://danang.gov.vn/vi/web/dng/w/cong-khai-thong-tin-tiep-nhan-ho-so-dang-ky-mua-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le',
			'https://hoaxuan.danang.gov.vn/ve-viec-lay-y-kien-ve-dieu-chinh-quy-hoach-chi-tiet-ty-le-1-500-du-an-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le/',
			'https://baodanang.vn/hon-1-000-khach-hang-boc-tham-du-an-nha-o-xa-hoi-b5-hoa-xuan-3355268.html',
			'https://cafeland.vn/du-an/viet-huong-lakeside-du-an-nha-o-xa-hoi-tai-da-nang-5282.html',
		),
	);
	/* ---------------- 18/11 – NOXH khu đất A2-4 đường Ngũ Hành Sơn – đường dẫn cầu Tiên Sơn: hồ sơ quy hoạch tổng mặt bằng (anh Hiệp gửi) ---------------- */
	$posts[] = array(
		'slug'           => 'nha-o-xa-hoi-cau-tien-son-731-can',
		'title'          => 'Nhà ở xã hội cầu Tiên Sơn: 2 tháp 31 tầng, 731 căn, vốn khoảng 1.225 tỷ đồng',
		'excerpt'        => 'Dự án nhà ở xã hội tại khu đất A2-4, đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn đang làm thủ tục quy hoạch tổng mặt bằng: 2 tháp 31 tầng + tum, 2 hầm, cao 123,1 m, 731 căn (175 căn giữ lại cho thuê), tổng sàn 82.945 m², vốn sơ bộ khoảng 1.225 tỷ đồng.',
		'keyword'        => 'nhà ở xã hội cầu Tiên Sơn',
		'keywords_extra' => array( 'nhà ở xã hội Ngũ Hành Sơn', 'nhà ở xã hội Đà Nẵng 2026', 'khu đất A2-4 đường Ngũ Hành Sơn', 'A&T Peninsula nhà ở xã hội' ),
		'project'        => 'peninsula-da-nang',
		'schedule'       => '2026-11-18 19:15', // Tin tức lên sớm nhất (anh Hiệp 18/11/2026).
		'rev'            => 2, // 20/11: QĐ 3128/QĐ-UBND, chỉ tiêu quy hoạch, phối cảnh, bản đồ quy hoạch, link trang dự án.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Nhà ở xã hội', 'Ngũ Hành Sơn', 'Cầu Tiên Sơn' ),
		'image'          => 'plugin:img/hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-nhin-ve-trung-tam.jpg',
		'image_alt'      => 'Sông Cẩm Lệ – sông Hàn nhìn về trung tâm Đà Nẵng, khu vực có nhà ở xã hội cầu Tiên Sơn (ảnh flycam thực tế)',
		'content'        => <<<HTML
<p><strong>Nhà ở xã hội cầu Tiên Sơn</strong> – tên đầy đủ là Dự án Nhà ở xã hội tại khu đất A2-4, đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn – đang làm các thủ tục về quy hoạch tổng mặt bằng sau khi được UBND TP Đà Nẵng chấp thuận chủ trương đầu tư (tháng 6/2025) và giao chủ đầu tư theo Quyết định 3128/QĐ-UBND ngày 16/7/2026. Hồ sơ mới cho thấy quy mô 2 tòa tháp 31 tầng với 731 căn hộ, ngay nút giao đường dẫn cầu Tiên Sơn và đường Ngũ Hành Sơn.</p>
<!--hh-featured-->
<h2>Quy mô nhà ở xã hội cầu Tiên Sơn theo hồ sơ quy hoạch</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Khu đất A2-4, nút giao đường dẫn cầu Tiên Sơn – đường Ngũ Hành Sơn, phường Ngũ Hành Sơn</td></tr>
<tr><td>Diện tích khu đất</td><td>Khoảng 6.970 m² theo hồ sơ quy hoạch tổng mặt bằng (lúc mời đầu tư 2025 báo chí ghi khoảng 7.060 m²)</td></tr>
<tr><td>Công trình</td><td>2 tòa tháp, mỗi tòa 31 tầng + tầng tum, 2 tầng hầm, cao 123,1 m</td></tr>
<tr><td>Số căn hộ</td><td>731 căn, trong đó chủ đầu tư giữ lại 175 căn để cho thuê (căn hộ dịch vụ du lịch)</td></tr>
<tr><td>Tổng diện tích sàn</td><td>82.945 m²</td></tr>
<tr><td>Mật độ xây dựng / hệ số sử dụng đất</td><td>33% / 9,4 lần (tháp A 862 m², tháp B 1.440 m²)</td></tr>
<tr><td>Cây xanh / giao thông nội bộ</td><td>1.420 m² (20,4%) / 3.248 m² (46,6%)</td></tr>
<tr><td>Dân số thường trú</td><td>Khoảng 1.412 người</td></tr>
<tr><td>Tổng mức đầu tư sơ bộ</td><td>Khoảng 1.225 tỷ đồng</td></tr>
</tbody>
</table>
<p>Lưu ý: khi thành phố mời đầu tư năm 2025, một số báo ghi nhà ở xã hội cầu Tiên Sơn khoảng 831 căn hộ. Con số 731 căn là theo hồ sơ quy hoạch tổng mặt bằng đang lập; số căn bán theo cơ chế nhà ở xã hội chính thức sẽ theo văn bản phê duyệt và thông báo mở bán của Sở Xây dựng.</p>
<!--hh-img:img/noxh-cau-tien-son/noxh-cau-tien-son-phoi-canh-ven-song.jpg|Phối cảnh nhà ở xã hội cầu Tiên Sơn – 2 tháp 31 tầng nhìn từ công viên ven sông (phối cảnh dự án)-->
<p>Trên bản đồ quy hoạch phân khu Ven sông Hàn và bờ Đông, khu đất là ô nhà ở xã hội NOXH-2, nằm ở góc vòng xoay đường Ngũ Hành Sơn – đường dẫn cầu Tiên Sơn – Hồ Xuân Hương – Lê Văn Hiến. Ranh giới: phía Đông giáp đường Ngũ Hành Sơn, phía Nam giáp đường dẫn lên cầu Tiên Sơn, phía Tây giáp hành lang tuyến điện, phía Bắc giáp trụ sở công an phường.</p>
<!--hh-img:img/noxh-cau-tien-son/noxh-cau-tien-son-ban-do-quy-hoach-khu-dat-a2-4.jpg|Vị trí nhà ở xã hội cầu Tiên Sơn (ô X – khu đất A2-4) trên bản đồ quy hoạch, ngay vòng xoay chân cầu Tiên Sơn-->
<h2>Ai làm chủ đầu tư nhà ở xã hội cầu Tiên Sơn?</h2>
<p>Theo Quyết định 3128/QĐ-UBND ngày 16/7/2026 và CafeLand (17/7/2026), UBND thành phố đã giao chủ đầu tư dự án cho liên danh gồm Công ty CP Đầu tư Phát triển đô thị A&amp;T Đà Nẵng, Công ty TNHH Peninsula Private Đà Nẵng, Công ty CP Đầu tư Phát triển đô thị A&amp;T Bình Dương và Công ty TNHH Đông Đô Peninsula Đà Nẵng; trong đó Công ty CP Đầu tư Phát triển đô thị A&amp;T Bình Dương là chủ đầu tư. Chủ trương đầu tư theo Quyết định 1942/QĐ-UBND ngày 24/6/2025. Vốn thực hiện là vốn góp của các thành viên liên danh.</p>
<p>Đây cũng là nhóm doanh nghiệp đứng sau hai dự án căn hộ ven sông Hàn đang có trên web Hoàng Hiệp: <a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a> và <a href="/du-an/peninsula-private-da-nang/">Peninsula Private</a>. Kinh nghiệm thi công cao tầng ven sông của nhóm này là điểm cộng cho tiến độ nhà ở xã hội cầu Tiên Sơn.</p>
<!--hh-img:img/peninsula/peninsula-da-nang-tien-do-6-2026-tu-bo-tay-song-han.jpg|Peninsula Đà Nẵng – dự án của cùng nhóm nhà đầu tư nhà ở xã hội cầu Tiên Sơn, nhìn từ bờ Tây sông Hàn (ảnh thực tế 6/2026)-->
<h2>Tiến độ nhà ở xã hội cầu Tiên Sơn</h2>
<ul>
<li><strong>24/6/2025:</strong> UBND TP chấp thuận chủ trương đầu tư (Quyết định 1942/QĐ-UBND).</li>
<li><strong>16/7/2026:</strong> giao chủ đầu tư cho liên danh A&amp;T – Peninsula – Đông Đô (Quyết định 3128/QĐ-UBND).</li>
<li><strong>Hiện nay:</strong> làm thủ tục quy hoạch tổng mặt bằng.</li>
<li><strong>Thời gian xây dựng:</strong> theo quyết định, xây dựng cơ bản và đưa vào vận hành trong 3 năm kể từ khi được giao đất hoặc cho thuê đất; thời hạn hoạt động dự án 50 năm.</li>
</ul>
<p>Như vậy nhà ở xã hội cầu Tiên Sơn chưa đến bước nhận hồ sơ đăng ký mua. Giá bán, đối tượng và thời gian nhận hồ sơ sẽ có khi chủ đầu tư được Sở Xây dựng công khai thông tin theo quy định.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Vị trí hiếm cho nhà ở xã hội:</strong> nằm ngay chân cầu Tiên Sơn, sang trung tâm Hải Châu chỉ một cây cầu; hiếm dự án nhà ở xã hội nào ở vị trí trung tâm như vậy.</li>
<li><strong>Mô hình kết hợp:</strong> phần lớn căn của nhà ở xã hội cầu Tiên Sơn bán theo cơ chế nhà ở xã hội, một phần (175 căn) giữ lại cho thuê dịch vụ du lịch – cách các chủ đầu tư bù chi phí và giữ dòng tiền vận hành.</li>
<li><strong>Nguồn cung căn hộ khu Ngũ Hành Sơn – Sơn Trà tăng:</strong> cùng các dự án thương mại ven sông Hàn, khu vực sẽ đông dân hơn, hạ tầng dịch vụ quanh đường Ngũ Hành Sơn có thêm lực cầu.</li>
<li><strong>Người cần nhà ở xã hội:</strong> nên chuẩn bị sớm cho nhà ở xã hội cầu Tiên Sơn: giấy xác nhận đối tượng, thu nhập và điều kiện nhà ở; dự án mới ở bước quy hoạch nên còn thời gian (xem thêm <a href="/nha-o-xa-hoi-viet-huong-lakeside-hoa-xuan/">nhà ở xã hội Việt Hương Lakeside</a> và <a href="/khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026/">nhà ở xã hội Đà Nẵng 2026</a>).</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Xem trang dự án <a href="/du-an/nha-o-xa-hoi-a2-4-ngu-hanh-son/">nhà ở xã hội cầu Tiên Sơn</a> để theo dõi tiến độ, quy hoạch tổng mặt bằng và thời điểm nhận hồ sơ.</p>
<ul>
<li><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a> và <a href="/du-an/peninsula-private-da-nang/">Peninsula Private</a>: cùng nhóm nhà đầu tư; năng lực triển khai của nhóm được thể hiện qua tiến độ các dự án này.</li>
<li><a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a>: nằm phía đầu cầu Tiên Sơn bên Hải Châu (cạnh Cung thể thao Tiên Sơn); khu vực hai đầu cầu sẽ đông dân cư hơn khi nhà ở xã hội cầu Tiên Sơn hoàn thành.</li>
</ul>
<p>Cần theo dõi khi nhà ở xã hội cầu Tiên Sơn mở nhận hồ sơ, hoặc tìm căn hộ thương mại khu vực này, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: hồ sơ quy hoạch tổng mặt bằng dự án do trang Danang 35K Feet đăng tải (11/2026); <a href="https://cafeland.vn/tin-tuc/doanh-nghiep-nao-thuc-hien-du-an-nha-o-xa-hoi-hon-1225-ty-dong-tai-thanh-pho-da-nang-153347.html">CafeLand</a> (17/7/2026); <a href="https://tuoitre.vn/du-an-nha-o-xa-hoi-hon-1225-ti-dong-vua-duoc-da-nang-giao-chu-dau-tu-thuc-hien-100260716175913488.htm">Tuổi Trẻ</a>. Số liệu theo hồ sơ đang lập, có thể thay đổi khi được phê duyệt.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Nhà ở xã hội cầu Tiên Sơn: 731 căn, 2 tháp 31 tầng',
			'desc'      => 'Nhà ở xã hội cầu Tiên Sơn (khu đất A2-4, đường Ngũ Hành Sơn): 2 tháp 31 tầng, 731 căn, cao 123,1 m, vốn sơ bộ khoảng 1.225 tỷ, đang lập quy hoạch tổng mặt bằng.',
			'points'    => array(
				'Khu đất A2-4 khoảng 6.970 m² ở nút giao đường dẫn cầu Tiên Sơn – đường Ngũ Hành Sơn',
				'2 tháp 31 tầng + tum, 2 hầm, cao 123,1 m; 731 căn, 175 căn giữ lại cho thuê; tổng sàn 82.945 m²',
				'Chủ trương 24/6/2025; Quyết định 3128/QĐ-UBND ngày 16/7/2026 giao liên danh A&T – Peninsula – Đông Đô làm chủ đầu tư; vốn sơ bộ khoảng 1.225 tỷ',
			),
			'faq'       => array(
				array( 'Nhà ở xã hội cầu Tiên Sơn nằm ở đâu?', 'Khu đất A2-4 tại nút giao đường dẫn lên cầu Tiên Sơn và đường Ngũ Hành Sơn, phường Ngũ Hành Sơn, TP Đà Nẵng.' ),
				array( 'Dự án có bao nhiêu căn?', 'Theo hồ sơ quy hoạch tổng mặt bằng: 731 căn hộ, trong đó chủ đầu tư giữ lại 175 căn để cho thuê; năm 2025 một số báo ghi khoảng 831 căn khi mời đầu tư.' ),
				array( 'Ai là chủ đầu tư?', 'Liên danh A&T Đà Nẵng – Peninsula Private Đà Nẵng – A&T Bình Dương – Đông Đô Peninsula Đà Nẵng, trong đó Công ty CP Đầu tư Phát triển đô thị A&T Bình Dương là chủ đầu tư (theo CafeLand 17/7/2026).' ),
				array( 'Khi nào nhận hồ sơ mua?', 'Chưa có. Dự án đang làm thủ tục quy hoạch tổng mặt bằng; thời gian nhận hồ sơ, giá bán sẽ theo thông báo của chủ đầu tư và Sở Xây dựng.' ),
			),
		),
		'sources'        => array(
			'https://cafeland.vn/tin-tuc/doanh-nghiep-nao-thuc-hien-du-an-nha-o-xa-hoi-hon-1225-ty-dong-tai-thanh-pho-da-nang-153347.html',
			'https://tuoitre.vn/du-an-nha-o-xa-hoi-hon-1225-ti-dong-vua-duoc-da-nang-giao-chu-dau-tu-thuc-hien-100260716175913488.htm',
			'https://vneconomy.vn/da-nang-moi-dau-tu-du-an-nha-o-xa-hoi-von-hon-1225-ty-dong-nhan-ho-so-den-109.htm',
		),
	);
	/* ---------------- 18/11 – Khu đô thị quốc tế Đa Phước: phối cảnh mới, tiến độ 3 giai đoạn (anh Hiệp gửi, nguồn danang.gov.vn) ---------------- */
	$posts[] = array(
		'slug'           => 'khu-do-thi-quoc-te-da-phuoc-3-giai-doan',
		'title'          => 'Khu đô thị quốc tế Đa Phước: phối cảnh mới và tiến độ 3 giai đoạn, hoàn thành quý II/2033',
		'excerpt'        => 'Khu đô thị quốc tế Đa Phước (khoảng 170,7 ha, vốn khoảng 54.788 tỷ đồng) chia 3 giai đoạn: giai đoạn 1 khoảng 39,8 ha xong quý IV/2028, giai đoạn 2 khoảng 117,9 ha xong quý III/2032, giai đoạn 3 khoảng 13 ha (bệnh viện, khách sạn, hội nghị) xong quý II/2033.',
		'keyword'        => 'khu đô thị quốc tế Đa Phước',
		'keywords_extra' => array( 'Đa Phước tái khởi động', 'dự án lấn biển Đà Nẵng', 'cửa sông Hàn', 'The Sunrise Bay' ),
		'project'        => 'peninsula-da-nang',
		'schedule'       => '2026-11-19 06:45', // Sáng sớm nhất sau khi cài gói 2.20.323 (ảnh Đa Phước nằm trong plugin).
		'rev'            => 2, // 19/11: nạp lại ảnh phối cảnh sau khi cài 2.20.323.
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Đa Phước', 'Quy hoạch Đà Nẵng', 'Sông Hàn' ),
		'image'          => 'plugin:img/da-phuoc/da-phuoc-phoi-canh-tong-the-cua-song-han.jpg',
		'image_alt'      => 'Phối cảnh khu đô thị quốc tế Đa Phước ở cửa sông Hàn, nhìn về bán đảo Sơn Trà',
		'content'        => <<<HTML
<p><strong>Khu đô thị quốc tế Đa Phước</strong> vừa có thêm bộ phối cảnh mới cùng tiến độ chi tiết theo từng giai đoạn, sau khi UBND TP Đà Nẵng chấp thuận điều chỉnh chủ trương đầu tư. Theo phương án phân kỳ công bố trên Cổng thông tin điện tử thành phố, dự án lấn biển ở cửa sông Hàn chia làm 3 giai đoạn, hoàn thành toàn bộ vào quý II/2033.</p>
<!--hh-featured-->
<h2>Khu đô thị quốc tế Đa Phước sau điều chỉnh chủ trương</h2>
<p>Theo báo chí, quyết định ngày 12/8/2026 của UBND thành phố chấp thuận điều chỉnh chủ trương đầu tư dự án (chủ trương gốc theo Quyết định 1443/QĐ-UBND ngày 17/3/2017), chủ đầu tư là Công ty TNHH The Sunrise Bay, tổng vốn khoảng 54.788 tỷ đồng. Tổng diện tích ba giai đoạn của khu đô thị quốc tế Đa Phước khoảng 170,7 ha (39,8 + 117,9 + 13 ha). Chủ đầu tư phải bàn giao khoảng 13,099 ha đất do thành phố quản lý cho Trung tâm Phát triển quỹ đất.</p>
<!--hh-img:img/da-phuoc/da-phuoc-phoi-canh-tong-the-cua-song-han.jpg|Phối cảnh khu đô thị quốc tế Đa Phước ở cửa sông Hàn, phía sau là bán đảo Sơn Trà (phối cảnh dự án)-->
<h2>Tiến độ 3 giai đoạn của khu đô thị quốc tế Đa Phước</h2>
<table>
<thead><tr><th>Giai đoạn</th><th>Diện tích</th><th>Hạng mục chính</th><th>Hoàn thành dự kiến</th></tr></thead>
<tbody>
<tr><td>Giai đoạn 1</td><td>Khoảng 39,8 ha</td><td>Tháo gỡ vướng mắc, hoàn tất pháp lý điều chỉnh để triển khai xây dựng trong quý III/2026; nhà thấp tầng từ tháng 9/2026 đến quý II/2028; kè theo giấy phép đến quý I/2028; hạ tầng kỹ thuật đến quý IV/2028</td><td>Quý IV/2028</td></tr>
<tr><td>Giai đoạn 2</td><td>Khoảng 117,9 ha</td><td>Phần kè biển còn lại (có khu vui chơi dịch vụ giải trí) đến quý II/2028; hạ tầng kỹ thuật còn lại đến quý IV/2029; nhà thấp tầng, trường học, dịch vụ công cộng đến quý III/2032</td><td>Quý III/2032</td></tr>
<tr><td>Giai đoạn 3</td><td>Khoảng 13 ha</td><td>Bệnh viện; thương mại, dịch vụ, khách sạn, trung tâm hội nghị, khu vui chơi giải trí</td><td>Quý II/2033</td></tr>
</tbody>
</table>
<!--hh-img:img/da-phuoc/da-phuoc-giai-doan-1-39-8-ha.jpg|Giai đoạn 1 khu đô thị quốc tế Đa Phước khoảng 39,8 ha – khu nhà thấp tầng ven biển (phối cảnh dự án)-->
<p>Giai đoạn 1 của khu đô thị quốc tế Đa Phước là khu nhà thấp tầng sát bờ biển phía Nam dự án, gần trục giao thông hiện hữu nên triển khai trước. Thi công nhà thấp tầng của khu đô thị quốc tế Đa Phước dự kiến bắt đầu từ tháng 9/2026, tức đã nằm trong lịch tái khởi động của thành phố.</p>
<!--hh-img:img/da-phuoc/da-phuoc-giai-doan-2-117-9-ha.jpg|Giai đoạn 2 khoảng 117,9 ha: kè biển, nhà thấp tầng ven kênh, trường học và hòn đảo dịch vụ giải trí (phối cảnh dự án)-->
<p>Giai đoạn 2 lớn nhất, chiếm gần 70% diện tích khu đô thị quốc tế Đa Phước, gồm khu biệt thự ven kênh nội khu, kè biển và hòn đảo dịch vụ giải trí. Giai đoạn 3 là cụm đảo khoảng 13 ha với bệnh viện, khách sạn, trung tâm hội nghị – phần tạo dịch vụ cao cấp cho toàn khu.</p>
<!--hh-img:img/da-phuoc/da-phuoc-giai-doan-3-dao-13-ha.jpg|Giai đoạn 3 khu đô thị quốc tế Đa Phước khoảng 13 ha: bệnh viện, khách sạn, trung tâm hội nghị trên đảo (phối cảnh dự án)-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Dự án "đắp chiếu" được tháo gỡ:</strong> sau nhiều năm đình trệ, khu đô thị quốc tế Đa Phước có lộ trình rõ theo quý – tín hiệu tích cực cho niềm tin thị trường Đà Nẵng, nhất là khu cửa sông Hàn.</li>
<li><strong>Thêm nguồn cung thấp tầng ven biển trung tâm:</strong> giai đoạn 1 dự kiến có nhà thấp tầng hoàn thiện từ quý II/2028; các khu thấp tầng gần trung tâm hiện rất khan hiếm.</li>
<li><strong>Bệnh viện, trường học, khách sạn, hội nghị:</strong> khi giai đoạn 2 – 3 của khu đô thị quốc tế Đa Phước hoàn thành, khu cửa sông Hàn có thêm tiện ích lớn, lợi cho các dự án căn hộ hai bờ sông Hàn và quanh cầu Thuận Phước.</li>
<li><strong>Theo dõi sát:</strong> tiến độ thực tế ở từng mốc (kè, hạ tầng, quy hoạch 1/500) mới là thước đo – các mốc trên là kế hoạch theo phương án phân kỳ.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>: bên bờ Đông sông Hàn gần cầu Thuận Phước, nhìn về phía cửa sông – hưởng lợi trực tiếp khi khu cửa sông Hàn được lấp đầy, có thêm tiện ích.</li>
<li><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> và <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>: căn hộ ven sông Hàn của Sun Group, cùng trục cảnh quan sông Hàn – cửa biển.</li>
</ul>
<p>Xem thêm lịch các sự kiện lớn cuối năm tại bài <a href="/cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan/">công bố Quy hoạch chung 2050</a>. Cần tư vấn căn hộ ven sông Hàn hưởng lợi từ khu đô thị quốc tế Đa Phước, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://danang.gov.vn/vi/w/dieu-chinh-chu-truong-dau-tu-du-an-khu-do-thi-quoc-te-da-phuoc">Cổng thông tin điện tử TP Đà Nẵng</a>; <a href="https://cafeland.vn/tin-tuc/du-an-lan-bien-da-phuoc-gan-55000-ty-dong-tai-da-nang-vua-co-buoc-tien-quan-trong-154117.html">CafeLand</a>; <a href="https://nhadautu.vn/da-nang-hoi-sinh-khu-do-thi-quoc-te-da-phuoc-d106941.html">Nhà Đầu tư</a>. Phối cảnh dự án; tiến độ theo phương án phân kỳ đầu tư, có thể điều chỉnh.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Khu đô thị quốc tế Đa Phước: 3 giai đoạn, xong 2033',
			'desc'      => 'Khu đô thị quốc tế Đa Phước khoảng 170,7 ha, vốn khoảng 54.788 tỷ: giai đoạn 1 xong quý IV/2028, giai đoạn 2 quý III/2032, giai đoạn 3 quý II/2033.',
			'points'    => array(
				'Giai đoạn 1 khoảng 39,8 ha: nhà thấp tầng thi công từ 9/2026, hoàn thành quý IV/2028',
				'Giai đoạn 2 khoảng 117,9 ha: kè biển, hạ tầng, nhà thấp tầng, trường học – hoàn thành quý III/2032',
				'Giai đoạn 3 khoảng 13 ha: bệnh viện, khách sạn, hội nghị – hoàn thành quý II/2033',
			),
			'faq'       => array(
				array( 'Khu đô thị quốc tế Đa Phước rộng bao nhiêu?', 'Khoảng 170,7 ha theo ba giai đoạn (39,8 ha, 117,9 ha và 13 ha), vốn khoảng 54.788 tỷ đồng, chủ đầu tư Công ty TNHH The Sunrise Bay.' ),
				array( 'Khi nào giai đoạn 1 hoàn thành?', 'Quý IV/2028; nhà thấp tầng thi công từ tháng 9/2026 và dự kiến xong quý II/2028.' ),
				array( 'Giai đoạn 3 gồm những gì?', 'Bệnh viện, thương mại – dịch vụ, khách sạn, trung tâm hội nghị và khu vui chơi giải trí, hoàn thành dự kiến quý II/2033.' ),
				array( 'Dự án ảnh hưởng gì tới căn hộ ven sông Hàn?', 'Khu cửa sông Hàn sẽ có thêm dân cư và tiện ích lớn (bệnh viện, khách sạn, hội nghị), tăng sức hút cho các dự án căn hộ hai bờ sông Hàn quanh cầu Thuận Phước.' ),
			),
		),
		'sources'        => array(
			'https://danang.gov.vn/vi/w/dieu-chinh-chu-truong-dau-tu-du-an-khu-do-thi-quoc-te-da-phuoc',
			'https://cafeland.vn/tin-tuc/du-an-lan-bien-da-phuoc-gan-55000-ty-dong-tai-da-nang-vua-co-buoc-tien-quan-trong-154117.html',
			'https://nhadautu.vn/da-nang-hoi-sinh-khu-do-thi-quoc-te-da-phuoc-d106941.html',
		),
	);
	/* ---------------- 20/11 – Hủy quy hoạch khu biệt thự 25,6 ha trên bán đảo Sơn Trà (Tuổi Trẻ, VnExpress 19/11/2026) ---------------- */
	$posts[] = array(
		'slug'           => 'huy-quy-hoach-khu-biet-thu-son-tra',
		'title'          => 'Đà Nẵng hủy quy hoạch khu biệt thự Sơn Trà 25,6 ha: bán đảo được giữ nguyên rừng',
		'excerpt'        => 'Ngày 19/11/2026, UBND TP Đà Nẵng hủy hai quyết định quy hoạch khu biệt thự trên bán đảo Sơn Trà (Quyết định 7214/QĐ-UBND năm 2011 và 2289/QĐ-UBND năm 2014), tổng diện tích khoảng 25,6 ha. Tác động tới bất động sản quanh chân bán đảo.',
		'keyword'        => 'hủy quy hoạch khu biệt thự Sơn Trà',
		'keywords_extra' => array( 'bán đảo Sơn Trà', 'quy hoạch 1/500 Sơn Trà', 'biệt thự Sơn Trà', 'bất động sản Sơn Trà' ),
		'project'        => 'the-camellia-son-tra',
		'schedule'       => '2026-11-20 06:45',
		'rev'            => 3, // 20/11: ảnh The Camellia chưa có trên web → đổi ảnh có sẵn; rev 3: ảnh đại diện là ảnh thực tế anh Hiệp gửi (tu-dong/bia-bai).
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Sơn Trà', 'Quy hoạch Đà Nẵng', 'Biệt thự' ),
		'image'          => 'plugin:img/peninsula/peninsula-da-nang-tien-do-6-2026-ben-song-han-ban-dao-son-tra.jpg',
		'image_alt'      => 'Hủy quy hoạch khu biệt thự Sơn Trà – khu biệt thự xây dở trên bán đảo Sơn Trà nhìn từ trên cao',
		'content'        => <<<'HTML'
<p>Việc <strong>hủy quy hoạch khu biệt thự Sơn Trà</strong> đã chính thức có quyết định: ngày 19/11/2026, UBND TP Đà Nẵng hủy bỏ hai quyết định quy hoạch của dự án khu biệt thự trên bán đảo Sơn Trà, khép lại một dự án gây tranh cãi hơn 15 năm. Diện tích quy hoạch bị hủy khoảng 25,6 ha, trong đó hơn 13 ha từng được quy hoạch làm đất ở biệt thự.</p>
<!--hh-featured-->
<h2>Hủy quy hoạch khu biệt thự Sơn Trà: hai quyết định bị bãi bỏ</h2>
<p>Theo báo Tuổi Trẻ và VnExpress, quyết định ngày 19/11/2026 của UBND thành phố hủy bỏ:</p>
<ul>
<li><strong>Quyết định 7214/QĐ-UBND ngày 22/8/2011</strong> phê duyệt quy hoạch chi tiết tỷ lệ 1/500 khu biệt thự tại bán đảo Sơn Trà;</li>
<li><strong>Quyết định 2289/QĐ-UBND ngày 14/4/2014</strong> phê duyệt điều chỉnh tổng mặt bằng khu số 2 của dự án.</li>
</ul>
<p>Đồ án bị hủy có tổng diện tích 256.348 m² (khoảng 25,6 ha), trong đó đất ở biệt thự 132.208 m². Sở Xây dựng được giao rà soát, tham mưu phương án xử lý việc dừng thực hiện dự án hạ tầng kỹ thuật khu biệt thự. UBND phường Sơn Trà có trách nhiệm công bố công khai quyết định và quản lý khu vực theo quy hoạch chung, quy hoạch phân khu đã được duyệt.</p>
<!--hh-img:img/sun-ponte/sun-ponte-toan-canh-ban-dao-son-tra.jpg|Sau khi hủy quy hoạch khu biệt thự Sơn Trà, rừng bán đảo Sơn Trà (phía sau) được giữ làm cảnh quan cho cả bờ Đông sông Hàn (phối cảnh dự án Sun Ponte Residence)-->
<h2>Quá trình đi tới quyết định hủy quy hoạch khu biệt thự Sơn Trà</h2>
<p>Dự án khu biệt thự trên bán đảo Sơn Trà được duyệt quy hoạch từ năm 2011, sau đó điều chỉnh năm 2014, nhưng nhiều năm không triển khai trọn vẹn và nằm trong diện rà soát sau các kết luận thanh tra. Đầu tháng 5/2026, UBND phường Sơn Trà tổ chức lấy ý kiến cộng đồng dân cư về việc hủy bỏ đồ án quy hoạch chi tiết 1/500 này (Tuổi Trẻ đưa tin ngày 8/5/2026). Trước đó, thành phố cũng đã thu hồi các chấp thuận ranh giới đất của một số dự án chưa triển khai trên bán đảo.</p>
<p>Với quyết định ngày 19/11/2026, việc hủy quy hoạch khu biệt thự Sơn Trà cho thấy định hướng rõ của thành phố: bán đảo Sơn Trà ưu tiên bảo tồn rừng, cảnh quan và phát triển du lịch sinh thái có kiểm soát, không mở thêm khu ở biệt thự trên sườn núi.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<p>Theo Hoàng Hiệp, việc hủy quy hoạch khu biệt thự Sơn Trà tác động tới thị trường ở bốn điểm:</p>
<ul>
<li><strong>Nguồn cung biệt thự trên bán đảo gần như đóng lại:</strong> sau khi hủy quy hoạch khu biệt thự Sơn Trà, khó có thêm dự án nhà ở mới trên sườn bán đảo. Bất động sản sát chân bán đảo (Lê Văn Lương, Lê Đức Thọ, Hoàng Sa, khu Thọ Quang – Mân Thái) càng hiếm.</li>
<li><strong>Giữ cảnh quan – giữ giá trị view:</strong> rừng Sơn Trà được bảo toàn là "phông nền" lâu dài cho các căn hộ, khách sạn nhìn về bán đảo. View núi rừng, biển Sơn Trà không lo bị che bởi khu biệt thự mới.</li>
<li><strong>Tín hiệu pháp lý minh bạch:</strong> thành phố xử lý dứt điểm các dự án tồn đọng trên bán đảo theo kết luận thanh tra; người mua nên tránh các lời mời "đất, biệt thự trên Sơn Trà" không có pháp lý rõ ràng.</li>
<li><strong>Theo dõi tiếp:</strong> sau khi hủy quy hoạch khu biệt thự Sơn Trà, phương án xử lý phần hạ tầng kỹ thuật đã làm và các lô đất liên quan sẽ do Sở Xây dựng tham mưu – Hoàng Hiệp sẽ cập nhật khi có văn bản.</li>
</ul>
<!--hh-img:img/peninsula/peninsula-da-nang-tien-do-6-2026-ben-song-han-ban-dao-son-tra.jpg|Bán đảo Sơn Trà phía sau dự án Peninsula Đà Nẵng bên sông Hàn – rừng Sơn Trà là phông nền lâu dài cho căn hộ ven sông (ảnh tiến độ thực tế 6/2026)-->
<h2>Dự án chịu ảnh hưởng</h2>
<p>Các dự án dưới đây nằm quanh chân bán đảo hoặc nhìn về bán đảo – nhóm hưởng lợi rõ nhất khi hủy quy hoạch khu biệt thự Sơn Trà giữ nguyên rừng:</p>
<ul>
<li><a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a>: ngã tư Lê Văn Lương – Lê Đức Thọ, sát chân bán đảo – căn hộ hiếm hoi gần rừng, gần biển phía Bắc khi bán đảo không mở thêm khu ở.</li>
<li><a href="/du-an/hiyori-aqua-tower/">Hiyori Aqua Tower</a>: cùng trục Lê Đức Thọ, hướng về bán đảo và vịnh Mân Quang.</li>
<li><a href="/du-an/sun-costa-residence/">Sun Costa Residence</a> và <a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a>: căn hộ ven biển Mỹ Khê – Phạm Văn Đồng, nhìn về bán đảo Sơn Trà.</li>
<li><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>: bên bờ Đông sông Hàn, view trực diện núi Sơn Trà.</li>
</ul>
<p>Xem thêm tổng quan <a href="/bat-dong-san-son-tra-2026/">bất động sản Sơn Trà 2026</a> và bài <a href="/cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan/">công bố Quy hoạch chung Đà Nẵng 2050</a>. Cần tư vấn căn hộ, nhà phố quanh chân bán đảo sau khi hủy quy hoạch khu biệt thự Sơn Trà, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://tuoitre.vn/da-nang-chinh-thuc-huy-quy-hoach-du-an-khu-biet-thu-tai-ban-dao-son-tra-10026111916590273.htm">Tuổi Trẻ</a>; <a href="https://vnexpress.net/da-nang-huy-quy-hoach-khu-biet-thu-25-6-ha-tren-ban-dao-son-tra-5146783.html">VnExpress</a>; <a href="https://tuoitre.vn/se-xoa-so-quy-hoach-khu-biet-thu-tren-ban-dao-son-tra-nguoi-dan-duoc-lay-y-kien-2026050810221295.htm">Tuổi Trẻ (5/2026)</a>. Nội dung theo báo chí đưa tin về quyết định của UBND TP Đà Nẵng ngày 19/11/2026.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Hủy quy hoạch khu biệt thự Sơn Trà 25,6 ha: điều cần biết',
			'desc'      => 'Hủy quy hoạch khu biệt thự Sơn Trà: ngày 19/11/2026 Đà Nẵng bãi bỏ quy hoạch 1/500 khu biệt thự 25,6 ha trên bán đảo. Tác động tới nhà ở chân bán đảo.',
			'points'    => array(
				'19/11/2026: UBND TP hủy Quyết định 7214/QĐ-UBND (2011) và 2289/QĐ-UBND (2014) về quy hoạch khu biệt thự bán đảo Sơn Trà',
				'Diện tích khoảng 25,6 ha (256.348 m²), trong đó đất ở biệt thự 132.208 m²',
				'Sở Xây dựng rà soát phương án dừng dự án hạ tầng kỹ thuật; phường Sơn Trà công bố, quản lý theo quy hoạch chung, phân khu',
			),
			'faq'       => array(
				array( 'Đà Nẵng hủy quy hoạch khu biệt thự Sơn Trà khi nào?', 'Ngày 19/11/2026, UBND TP Đà Nẵng ban hành quyết định hủy bỏ hai quyết định quy hoạch của dự án khu biệt thự trên bán đảo Sơn Trà.' ),
				array( 'Những quyết định nào bị hủy?', 'Quyết định 7214/QĐ-UBND ngày 22/8/2011 phê duyệt quy hoạch chi tiết 1/500 và Quyết định 2289/QĐ-UBND ngày 14/4/2014 điều chỉnh tổng mặt bằng khu số 2.' ),
				array( 'Khu biệt thự bị hủy quy hoạch rộng bao nhiêu?', 'Khoảng 25,6 ha (256.348 m²), trong đó đất ở biệt thự 132.208 m².' ),
				array( 'Ảnh hưởng gì tới bất động sản Sơn Trà?', 'Sau khi hủy quy hoạch khu biệt thự Sơn Trà, nguồn cung nhà ở trên bán đảo gần như đóng lại, rừng Sơn Trà được giữ làm cảnh quan lâu dài; căn hộ, nhà phố sát chân bán đảo và view Sơn Trà càng khan hiếm.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/da-nang-chinh-thuc-huy-quy-hoach-du-an-khu-biet-thu-tai-ban-dao-son-tra-10026111916590273.htm',
			'https://vnexpress.net/da-nang-huy-quy-hoach-khu-biet-thu-25-6-ha-tren-ban-dao-son-tra-5146783.html',
			'https://tuoitre.vn/se-xoa-so-quy-hoach-khu-biet-thu-tren-ban-dao-son-tra-nguoi-dan-duoc-lay-y-kien-2026050810221295.htm',
		),
	);

	/* ---------------- 20/11 – Khu đô thị Hòa Vang 183,9 ha, gần 19.000 tỷ: đấu thầu quốc tế chọn nhà đầu tư (Tuổi Trẻ, Thanh Niên 19/11/2026) ---------------- */
	$posts[] = array(
		'slug'           => 'khu-do-thi-hoa-vang-dau-thau-quoc-te',
		'rev'            => 2, // 22/11: giọng văn thương hiệu Hiệp.
		'title'          => 'Khu đô thị Hòa Vang 183,9 ha, gần 19.000 tỷ đồng: Đà Nẵng đấu thầu quốc tế chọn nhà đầu tư',
		'excerpt'        => 'Ngày 19/11/2026, UBND TP Đà Nẵng phê duyệt thông tin dự án Khu đô thị Hòa Vang: 183,9 ha, khoảng 33.910 dân, vốn hơn 18.922 tỷ đồng, 55,1 ha đất ở; chọn nhà đầu tư qua đấu thầu rộng rãi quốc tế từ quý IV/2026 đến quý II/2027.',
		'keyword'        => 'khu đô thị Hòa Vang',
		'keywords_extra' => array( 'đấu thầu quốc tế Đà Nẵng', 'dự án khu đô thị Đà Nẵng 2026', 'giãn dân Đà Nẵng', 'quỹ nhà ở Đà Nẵng' ),
		'project'        => 'sun-neo-city',
		'schedule'       => '2026-11-20 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hòa Vang', 'Khu đô thị', 'Quy hoạch Đà Nẵng' ),
		'image'          => 'plugin:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg',
		'image_alt'      => 'Khu đô thị Hòa Vang – hướng phát triển phía Nam, Tây Nam Đà Nẵng (ảnh flycam ven sông Cẩm Lệ)',
		'content'        => <<<'HTML'
<p><strong>Khu đô thị Hòa Vang</strong> quy mô 183,9 ha, tổng vốn hơn 18.922 tỷ đồng vừa được UBND TP Đà Nẵng phê duyệt thông tin dự án và bảng theo dõi tiến độ lựa chọn nhà đầu tư ngày 19/11/2026. Nhà đầu tư sẽ được chọn bằng hình thức đấu thầu rộng rãi quốc tế – một trong những dự án khu đô thị lớn nhất thành phố đưa ra đấu thầu năm nay.</p>
<!--hh-featured-->
<h2>Khu đô thị Hòa Vang: quy mô và vốn đầu tư</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin (theo báo chí)</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Xã Hòa Vang, TP Đà Nẵng</td></tr>
<tr><td>Quy mô</td><td>183,9 ha, trong đó khoảng 55,1 ha đất ở</td></tr>
<tr><td>Dân số dự kiến</td><td>Khoảng 33.910 người</td></tr>
<tr><td>Tổng vốn dự kiến</td><td>Hơn 18.922 tỷ đồng (khoảng 13.580 tỷ thực hiện dự án, khoảng 2.503 tỷ bồi thường – tái định cư – giải phóng mặt bằng, phần còn lại dự phòng)</td></tr>
<tr><td>Hình thức chọn nhà đầu tư</td><td>Đấu thầu rộng rãi quốc tế, một giai đoạn một túi hồ sơ</td></tr>
<tr><td>Lựa chọn nhà đầu tư</td><td>Quý IV/2026 – quý II/2027</td></tr>
<tr><td>Thực hiện dự án</td><td>Từ quý III/2027, kéo dài tới năm 2034</td></tr>
</tbody>
</table>
<p>Quyết định do Phó Chủ tịch UBND thành phố Lê Quang Nam ký. Theo báo chí, mục tiêu của khu đô thị Hòa Vang là giãn dân cho khu trung tâm, bổ sung quỹ nhà ở và hình thành khu đô thị đồng bộ hạ tầng ở phía Tây Nam thành phố. Ở các đề xuất trước (cuối năm 2025), dự án có quy mô hơn 160 ha, vốn hơn 16.000 tỷ đồng – nay được nâng lên 183,9 ha.</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg|Khu đô thị Hòa Vang nằm trên hướng phát triển phía Nam – Tây Nam, nơi các khu đô thị ven sông Cẩm Lệ đã hình thành (ảnh flycam thực tế 8/2025)-->
<h2>Tiến độ dự kiến của khu đô thị Hòa Vang</h2>
<p>Thành phố dự kiến chọn được nhà đầu tư trong khoảng quý IV/2026 – quý II/2027, sau đó nhà đầu tư triển khai bồi thường, giải phóng mặt bằng và xây dựng hạ tầng từ quý III/2027. Với quy mô gần 184 ha, khu đô thị Hòa Vang sẽ làm theo nhiều giai đoạn, kéo dài tới năm 2034. Như vậy, sản phẩm nhà ở đầu tiên khó ra thị trường trước năm 2028 – 2029, tùy tiến độ giải phóng mặt bằng.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đô thị hóa lan về phía Tây Nam:</strong> sau Hòa Xuân, Nam Hòa Xuân, việc mời đầu tư khu đô thị Hòa Vang cho thấy thành phố đẩy mạnh phát triển vùng ven theo Quy hoạch chung 2050. Hạ tầng kết nối (đường, cầu, điện, nước) sẽ đi trước, kéo giá đất khu vực.</li>
<li><strong>Nguồn cung dài hạn, chưa phải ngắn hạn:</strong> khu đô thị Hòa Vang chưa có nhà đầu tư; Hiệp khuyên khách tránh các lời mời "đặt cọc giữ chỗ" khi dự án chưa đủ điều kiện kinh doanh.</li>
<li><strong>Đấu thầu quốc tế – kỳ vọng nhà đầu tư lớn:</strong> hình thức đấu thầu rộng rãi quốc tế mở cửa cho các tập đoàn có năng lực tài chính, giúp dự án làm đồng bộ hơn các khu phân lô nhỏ lẻ.</li>
<li><strong>Khu đô thị hiện hữu hưởng lợi trước:</strong> các khu đã có hạ tầng, đã ra sổ ở phía Nam như Hòa Xuân hưởng lợi sớm khi dân cư, tiện ích dịch chuyển về hướng này.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-neo-city/">Sun NeO City</a> (Hòa Xuân, ven sông Cẩm Lệ): khu đô thị đã hình thành ở cửa ngõ phía Nam, hưởng lợi khi hướng Nam – Tây Nam tiếp tục được đô thị hóa.</li>
<li><a href="/du-an/spana-tower/">Spana Tower</a> và <a href="/du-an/cora-tower/">Cora Tower</a>: căn hộ Sun Group trong Sun NeO City, bàn giao 2027 – lựa chọn có sẵn hạ tầng thay vì chờ khu đô thị mới.</li>
<li><a href="/du-an/viet-huong-lakeside-hoa-xuan/">Việt Hương Lakeside</a>: nhà ở xã hội tại Hòa Xuân, phục vụ đúng nhu cầu giãn dân mà khu đô thị Hòa Vang hướng tới.</li>
</ul>
<p>Xem thêm bài <a href="/cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan/">công bố Quy hoạch chung Đà Nẵng 2050</a> và <a href="/khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026/">8 dự án nhà ở xã hội khởi công cuối 2026</a>. Cần tư vấn bất động sản phía Nam Đà Nẵng, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://tuoitre.vn/da-nang-chuan-bi-dau-thau-quoc-te-du-an-khu-do-thi-gan-19000-ti-dong-o-hoa-vang-100261119141652851.htm">Tuổi Trẻ</a>; <a href="https://thanhnien.vn/phe-duyet-du-an-khu-do-thi-hoa-vang-gan-19000-ti-dong-o-da-nang-185261119141313206.htm">Thanh Niên</a>; <a href="https://www.sggp.org.vn/da-nang-dau-thau-quoc-te-du-an-khu-do-thi-hoa-vang-hon-18900-ty-dong-post882602.html">Sài Gòn Giải Phóng</a>. Số liệu theo báo chí đưa tin về quyết định ngày 19/11/2026; có thể điều chỉnh khi lập hồ sơ mời thầu.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Khu đô thị Hòa Vang 183,9 ha gần 19.000 tỷ: đấu thầu quốc tế',
			'desc'      => 'Khu đô thị Hòa Vang 183,9 ha, vốn hơn 18.922 tỷ, khoảng 33.910 dân: Đà Nẵng chọn nhà đầu tư qua đấu thầu quốc tế từ quý IV/2026 đến quý II/2027.',
			'points'    => array(
				'183,9 ha tại xã Hòa Vang, 55,1 ha đất ở, khoảng 33.910 dân',
				'Tổng vốn hơn 18.922 tỷ đồng; đấu thầu rộng rãi quốc tế, một giai đoạn một túi hồ sơ',
				'Chọn nhà đầu tư quý IV/2026 – quý II/2027; thực hiện từ quý III/2027 tới năm 2034',
			),
			'faq'       => array(
				array( 'Khu đô thị Hòa Vang rộng bao nhiêu?', 'Khoảng 183,9 ha tại xã Hòa Vang, trong đó khoảng 55,1 ha đất ở, dân số dự kiến khoảng 33.910 người.' ),
				array( 'Tổng vốn đầu tư bao nhiêu?', 'Hơn 18.922 tỷ đồng, gồm khoảng 13.580 tỷ thực hiện dự án, khoảng 2.503 tỷ bồi thường – giải phóng mặt bằng và phần dự phòng.' ),
				array( 'Khi nào chọn được nhà đầu tư?', 'Theo bảng tiến độ được duyệt, việc lựa chọn nhà đầu tư diễn ra từ quý IV/2026 đến quý II/2027, theo hình thức đấu thầu rộng rãi quốc tế.' ),
				array( 'Đã mua được nhà ở khu đô thị Hòa Vang chưa?', 'Chưa. Dự án chưa có nhà đầu tư, chưa đủ điều kiện kinh doanh; cần cảnh giác với lời mời đặt cọc giữ chỗ.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/da-nang-chuan-bi-dau-thau-quoc-te-du-an-khu-do-thi-gan-19000-ti-dong-o-hoa-vang-100261119141652851.htm',
			'https://thanhnien.vn/phe-duyet-du-an-khu-do-thi-hoa-vang-gan-19000-ti-dong-o-da-nang-185261119141313206.htm',
			'https://www.sggp.org.vn/da-nang-dau-thau-quoc-te-du-an-khu-do-thi-hoa-vang-hon-18900-ty-dong-post882602.html',
		),
	);

	/* ---------------- 21/11 – Phấn đấu khởi công cải tạo đường băng 17R/35L sân bay Đà Nẵng cuối 11/2026 (Thời báo Tài chính VN, VnEconomy, QĐ 1417/QĐ-BXD) ---------------- */
	$posts[] = array(
		'slug'           => 'khoi-cong-duong-bang-san-bay-da-nang',
		'rev'            => 2, // 22/11: giọng văn thương hiệu Hiệp.
		'title'          => 'Khởi công đường băng sân bay Đà Nẵng cuối tháng 11/2026: dự án gần 1.696 tỷ đồng được rút ngắn thủ tục',
		'excerpt'        => 'Bộ Xây dựng chấp thuận dùng thiết kế kỹ thuật thay thiết kế cơ sở, rút ngắn khoảng 1 tháng để phấn đấu khởi công cải tạo đường cất hạ cánh 17R/35L sân bay Đà Nẵng cuối tháng 11/2026; dự án nhóm B gần 1.696 tỷ đồng, thực hiện 2026 – 2028.',
		'keyword'        => 'khởi công đường băng sân bay Đà Nẵng',
		'keywords_extra' => array( 'đường cất hạ cánh 17R/35L', 'cải tạo đường băng sân bay Đà Nẵng', 'sân bay quốc tế Đà Nẵng 2026', 'căn hộ gần sân bay Đà Nẵng' ),
		'project'        => 'sun-saphia-residence',
		'schedule'       => '2026-11-21 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Sân bay Đà Nẵng', 'Hạ tầng giao thông', 'Quy hoạch Đà Nẵng' ),
		'image'          => 'plugin:img/tin-tuc/san-bay-da-nang-sun-saphia.jpg',
		'image_alt'      => 'Khởi công đường băng sân bay Đà Nẵng: cải tạo đường cất hạ cánh 17R/35L, tổng mức đầu tư gần 1.696 tỷ đồng',
		'content'        => <<<'HTML'
<p>Lịch <strong>khởi công đường băng sân bay Đà Nẵng</strong> đã được đẩy lên sớm: Bộ Xây dựng chấp thuận dùng thiết kế kỹ thuật thay cho thiết kế cơ sở trong báo cáo nghiên cứu khả thi, giúp rút ngắn khoảng 1 tháng so với trình tự thông thường, để phấn đấu khởi công dự án cải tạo đường cất hạ cánh 17R/35L vào cuối tháng 11/2026. Đây là dự án nhóm B, tổng mức đầu tư gần 1.696 tỷ đồng, thực hiện giai đoạn 2026 – 2028.</p>
<!--hh-featured-->
<h2>Vì sao phải khởi công đường băng sân bay Đà Nẵng sớm?</h2>
<p>Theo báo chí, kết cấu mặt đường cất hạ cánh 17R/35L đã hết tuổi thọ thiết kế nhưng vẫn phải khai thác với cường độ cao, làm tăng nguy cơ bong bật mặt đường và hư hỏng tàu bay. Vì vậy, việc khởi công đường băng sân bay Đà Nẵng được xem là yêu cầu cấp bách về an toàn bay, không chỉ là nâng cấp để đón thêm chuyến.</p>
<p>Đề xuất dùng thiết kế kỹ thuật thay thiết kế cơ sở do Ban quản lý dự án Thăng Long đưa ra. Khi được chấp thuận, hồ sơ thiết kế được làm sâu ngay từ đầu, bớt một bước trình duyệt, nhờ đó tiến độ chuẩn bị rút ngắn khoảng 1 tháng.</p>
<h2>Thông tin dự án cải tạo đường cất hạ cánh 17R/35L</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin (theo báo chí, văn bản)</th></tr></thead>
<tbody>
<tr><td>Căn cứ</td><td>Quyết định 1417/QĐ-BXD ngày 12/8/2026 của Bộ Xây dựng về chủ trương đầu tư</td></tr>
<tr><td>Phạm vi</td><td>Cải tạo đường cất hạ cánh 17R/35L và hệ thống trang thiết bị phụ trợ; xây 1 đường lăn thoát nhanh, 1 đường lăn nối giữa hai đường cất hạ cánh, 1 đường lăn nối với đường lăn song song E</td></tr>
<tr><td>Quy mô</td><td>Theo cấp sân bay 4E (ICAO)</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Khoảng 1.696 tỷ đồng, dự án nhóm B</td></tr>
<tr><td>Nguồn vốn</td><td>Ngân sách trung ương</td></tr>
<tr><td>Thời gian thực hiện</td><td>2026 – 2028</td></tr>
<tr><td>Mốc khởi công</td><td>Phấn đấu cuối tháng 11/2026 (kế hoạch, chưa phải lễ khởi công đã diễn ra)</td></tr>
</tbody>
</table>
<p>Như vậy, khởi công đường băng sân bay Đà Nẵng sẽ là bước tiếp theo sau quyết định chủ trương đầu tư ban hành tháng 8/2026. Trước khi được duyệt, Cục Hàng không Việt Nam trình phương án với tổng mức khoảng 1.819,8 tỷ đồng; con số được Bộ Xây dựng chốt trong quyết định là khoảng 1.696 tỷ đồng.</p>
<!--hh-img:img/tin-tuc/san-bay-da-nang-sun-saphia.jpg|Khởi công đường băng sân bay Đà Nẵng: cải tạo đường cất hạ cánh 17R/35L khoảng 1.696 tỷ đồng, thực hiện 2026 – 2028-->
<h2>Khởi công đường băng sân bay Đà Nẵng ảnh hưởng gì tới chuyến bay?</h2>
<p>Sân bay Đà Nẵng có hai đường cất hạ cánh song song. Khi một đường băng thi công, đường còn lại vẫn khai thác, nên sân bay không phải đóng cửa. Tuy vậy, trong giai đoạn thi công, năng lực cất hạ cánh giờ cao điểm có thể bị hạn chế; lịch bay cụ thể do nhà chức trách hàng không và các hãng thông báo. Báo chí hiện chưa công bố phương án điều hành bay chi tiết, nên du khách và chủ căn hộ cho thuê nên theo dõi thông báo chính thức.</p>
<p>Về dài hạn, khi khởi công đường băng sân bay Đà Nẵng và hoàn thành năm 2028, đường cất hạ cánh mới cùng đường lăn thoát nhanh giúp máy bay rời đường băng nhanh hơn, tăng số chuyến mỗi giờ – điều kiện để sân bay đón thêm đường bay quốc tế, đi cùng việc <a href="/mo-rong-nha-ga-t2-san-bay-da-nang/">mở rộng nhà ga T2 sân bay Đà Nẵng</a>.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Trung tâm Đà Nẵng bên sông Hàn, cách sân bay vài km – khu vực hưởng lợi khi sân bay được cải tạo (ảnh flycam thực tế 11/2026)-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Du lịch là động lực của căn hộ cho thuê:</strong> sân bay khai thác an toàn, thêm chuyến quốc tế thì lượng khách lưu trú tăng – có lợi cho căn hộ ven biển và trung tâm đang khai thác cho thuê ngắn ngày.</li>
<li><strong>Ngắn hạn cần tính tới thi công:</strong> sau khi khởi công đường băng sân bay Đà Nẵng, trong 2026 – 2028, nếu năng lực cất hạ cánh bị hạn chế giờ cao điểm, Hiệp hay nhắc các chủ căn cho thuê nên linh hoạt giờ nhận, trả phòng của khách.</li>
<li><strong>Tin hạ tầng đã được phê duyệt, có vốn:</strong> khác với các đề xuất, việc khởi công đường băng sân bay Đà Nẵng có quyết định chủ trương đầu tư và vốn ngân sách trung ương, nên mức chắc chắn cao.</li>
<li><strong>Không nên mua chỉ vì một tin:</strong> khởi công đường băng sân bay Đà Nẵng là tin tốt cho cả thành phố, nhưng giá căn hộ vẫn phụ thuộc pháp lý, chủ đầu tư, vị trí và dòng tiền thực tế; tin sân bay là yếu tố cộng thêm, không thay thế việc kiểm tra dự án.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Các dự án dưới đây nằm ở khu vực có kết nối sân bay thuận tiện, nên tin khởi công đường băng sân bay Đà Nẵng là yếu tố cộng thêm cho nhu cầu lưu trú:</p>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> (khu biển Sơn Thủy): cách sân bay khoảng 9 – 14 km, sản phẩm hướng tới khách lưu trú – hưởng lợi trực tiếp khi sân bay đón thêm chuyến. Xem bài <a href="/sun-saphia-residence-di-san-bay/">Sun Saphia Residence đi sân bay mất bao lâu</a>.</li>
<li><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> và <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> (ven sông Hàn): đang bàn giao, nằm ở trung tâm gần sân bay, phù hợp cả ở và cho thuê.</li>
</ul>
<p>Xem thêm: <a href="/nang-cap-san-bay-da-nang-1696-ty-sun-saphia/">nâng cấp sân bay Đà Nẵng 1.696 tỷ</a> và <a href="/duong-sat-do-thi-da-nang-san-bay-my-khe-hoi-an/">đường sắt đô thị sân bay – Mỹ Khê</a>. Cần tư vấn căn hộ gần sân bay, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://thoibaotaichinhvietnam.vn/khoi-cong-cai-tao-tong-the-duong-cat-ha-canh-san-bay-da-nang-vao-cuoi-thang-11-2026-202900.html">Thời báo Tài chính Việt Nam</a>; <a href="https://vneconomy.vn/gan-1696-ty-dong-dau-tu-du-an-cai-tao-duong-cat-ha-canh-duong-lan-cang-hang-khong-quoc-te-da-nang.htm">VnEconomy</a>; <a href="https://luatvietnam.vn/dau-tu/quyet-dinh-1417-qd-bxd-2026-dau-tu-xay-dung-cai-tao-duong-cat-ha-canh-cang-hang-khong-da-nang-444767-d1.html">Quyết định 1417/QĐ-BXD (LuatVietnam)</a>; <a href="https://www.tinnhanhchungkhoan.vn/dau-tu-1819-ty-dong-xay-dung-cai-tao-duong-cat-ha-canh-san-bay-da-nang-post393036.html">Tin nhanh chứng khoán</a>. Mốc khởi công là kế hoạch theo báo chí, có thể thay đổi.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Khởi công đường băng sân bay Đà Nẵng 11/2026: gần 1.696 tỷ',
			'desc'      => 'Khởi công đường băng sân bay Đà Nẵng phấn đấu cuối 11/2026: cải tạo đường cất hạ cánh 17R/35L gần 1.696 tỷ đồng, thực hiện 2026 – 2028.',
			'points'    => array(
				'Bộ Xây dựng cho dùng thiết kế kỹ thuật thay thiết kế cơ sở, rút ngắn khoảng 1 tháng',
				'Phấn đấu khởi công đường băng sân bay Đà Nẵng cuối tháng 11/2026',
				'Cải tạo đường cất hạ cánh 17R/35L, thêm 3 đường lăn; gần 1.696 tỷ đồng, vốn ngân sách trung ương, 2026 – 2028',
			),
			'faq'       => array(
				array( 'Khi nào khởi công đường băng sân bay Đà Nẵng?', 'Theo báo chí, dự án phấn đấu khởi công cuối tháng 11/2026 nhờ được dùng thiết kế kỹ thuật thay thiết kế cơ sở, rút ngắn khoảng 1 tháng chuẩn bị.' ),
				array( 'Dự án cải tạo đường băng bao nhiêu tiền?', 'Khoảng 1.696 tỷ đồng theo Quyết định 1417/QĐ-BXD ngày 12/8/2026, dự án nhóm B, vốn ngân sách trung ương, thực hiện 2026 – 2028.' ),
				array( 'Sân bay Đà Nẵng có đóng cửa khi thi công không?', 'Sân bay có hai đường cất hạ cánh song song nên vẫn khai thác trên đường còn lại; lịch bay cụ thể theo thông báo của nhà chức trách và các hãng.' ),
				array( 'Vì sao phải cải tạo đường cất hạ cánh 17R/35L?', 'Kết cấu mặt đường đã hết tuổi thọ thiết kế nhưng vẫn khai thác cường độ cao, tăng nguy cơ bong bật mặt đường và hư hỏng tàu bay.' ),
			),
		),
		'sources'        => array(
			'https://thoibaotaichinhvietnam.vn/khoi-cong-cai-tao-tong-the-duong-cat-ha-canh-san-bay-da-nang-vao-cuoi-thang-11-2026-202900.html',
			'https://vneconomy.vn/gan-1696-ty-dong-dau-tu-du-an-cai-tao-duong-cat-ha-canh-duong-lan-cang-hang-khong-quoc-te-da-nang.htm',
			'https://luatvietnam.vn/dau-tu/quyet-dinh-1417-qd-bxd-2026-dau-tu-xay-dung-cai-tao-duong-cat-ha-canh-cang-hang-khong-da-nang-444767-d1.html',
			'https://www.tinnhanhchungkhoan.vn/dau-tu-1819-ty-dong-xay-dung-cai-tao-duong-cat-ha-canh-san-bay-da-nang-post393036.html',
		),
	);

	/* ---------------- 21/11 – Đề xuất công viên kiểu Disneyland tại xã Thăng An trong kế hoạch kinh tế ban đêm 2027 – 2030 (Tuổi Trẻ 20/11/2026, anh Hiệp gửi) ---------------- */
	$posts[] = array(
		'slug'           => 'cong-vien-kieu-disneyland-da-nang-thang-an',
		'rev'            => 2, // 22/11: giọng văn thương hiệu Hiệp.
		'title'          => 'Công viên kiểu Disneyland Đà Nẵng: đề xuất kêu gọi đầu tư tại xã Thăng An để phát triển kinh tế đêm 2027 – 2030',
		'excerpt'        => 'Sáng 20/11/2026, Sở Văn hóa, Thể thao và Du lịch Đà Nẵng tham vấn đề án phát triển kinh tế ban đêm 2027 – 2030, tầm nhìn 2050; dự thảo đề xuất kêu gọi đầu tư khu phức hợp vui chơi giải trí, lễ hội, sự kiện quốc tế theo mô hình Disneyland tại xã Thăng An.',
		'keyword'        => 'công viên kiểu Disneyland Đà Nẵng',
		'keywords_extra' => array( 'kinh tế ban đêm Đà Nẵng', 'xã Thăng An Đà Nẵng', 'khu vui chơi giải trí Đà Nẵng', 'bất động sản Nam Hội An' ),
		'project'        => 'hoiana-residences',
		'schedule'       => '2026-11-21 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Kinh tế đêm', 'Du lịch Đà Nẵng', 'Quy hoạch Đà Nẵng' ),
		'image'          => 'plugin:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg',
		'image_alt'      => 'Công viên kiểu Disneyland Đà Nẵng được đề xuất tại xã Thăng An, vùng ven biển phía Nam thành phố (ảnh flycam thực tế khu vực Nam Hội An)',
		'content'        => <<<'HTML'
<p>Ý tưởng <strong>công viên kiểu Disneyland Đà Nẵng</strong> vừa được đưa vào dự thảo đề án phát triển kinh tế ban đêm giai đoạn 2027 – 2030, tầm nhìn đến năm 2050. Sáng 20/11/2026, Sở Văn hóa, Thể thao và Du lịch TP Đà Nẵng mời chuyên gia, doanh nghiệp du lịch tham vấn các nội dung của đề án; một trong những đề xuất được chú ý là xúc tiến kêu gọi đầu tư khu phức hợp vui chơi giải trí, lễ hội và sự kiện quốc tế theo mô hình công viên Disneyland tại xã Thăng An.</p>
<!--hh-featured-->
<h2>Công viên kiểu Disneyland Đà Nẵng gồm những gì?</h2>
<p>Theo dự thảo được Tuổi Trẻ đưa tin, công viên kiểu Disneyland Đà Nẵng tại xã Thăng An có thể gồm các hạng mục:</p>
<table>
<thead><tr><th>Hạng mục đề xuất</th><th>Vai trò với kinh tế ban đêm</th></tr></thead>
<tbody>
<tr><td>Công viên giải trí chuyên đề</td><td>Điểm vui chơi chính, giữ chân khách cả ngày và buổi tối</td></tr>
<tr><td>Khu nghỉ dưỡng cao cấp</td><td>Lưu trú tại chỗ, kéo dài số đêm khách ở lại</td></tr>
<tr><td>Quảng trường sự kiện, sân khấu ngoài trời</td><td>Tổ chức lễ hội, biểu diễn, sự kiện quốc tế về đêm</td></tr>
<tr><td>Trung tâm triển lãm và hội nghị</td><td>Thu hút khách MICE, hội nghị, triển lãm</td></tr>
</tbody>
</table>
<p>Đây mới là nội dung trong dự thảo đang lấy ý kiến, chưa phải quyết định đầu tư. Báo chí chưa công bố quy mô diện tích, tổng vốn, nhà đầu tư hay mốc thời gian cụ thể cho công viên kiểu Disneyland Đà Nẵng. Hoàng Hiệp sẽ cập nhật khi đề án được thông qua hoặc có nhà đầu tư đăng ký.</p>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Công viên kiểu Disneyland Đà Nẵng được đề xuất ở vùng ven biển phía Nam thành phố, nơi đã có nhiều khu nghỉ dưỡng (ảnh flycam thực tế từ Duy Xuyên nhìn về cầu Cửa Đại, Hội An)-->
<h2>Vì sao chọn xã Thăng An?</h2>
<p>Xã Thăng An nằm ở vùng ven biển phía Nam thành phố, dọc sông Trường Giang (khu vực Thăng Bình thuộc Quảng Nam cũ trước hợp nhất). Theo Quy hoạch chung Đà Nẵng đến năm 2050, Thăng An là một trong 7 đô thị mới dự kiến hình thành, cùng Duy Nghĩa, Thăng Điền, Thăng Trường, Tây Hồ, Vu Gia và Hoàng Sa. Khu vực này còn quỹ đất lớn, gần trục ven biển và các khu nghỉ dưỡng Nam Hội An – điều kiện phù hợp cho một tổ hợp vui chơi quy mô lớn mà nội đô Đà Nẵng khó bố trí.</p>
<p>Nếu được kêu gọi thành công, công viên kiểu Disneyland Đà Nẵng sẽ bổ sung cho chuỗi điểm đến về đêm hiện có ở trung tâm như sông Hàn, cầu Rồng, bãi biển Mỹ Khê, đồng thời kéo dòng khách xuống phía Nam thay vì chỉ tập trung ở nội đô.</p>
<!--hh-img:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg|Kinh tế ban đêm Đà Nẵng hiện tập trung ở sông Hàn, cầu Rồng – công viên kiểu Disneyland Đà Nẵng ở Thăng An sẽ mở thêm điểm đến phía Nam (ảnh thực tế)-->
<h2>Kinh tế ban đêm Đà Nẵng: các đề xuất khác</h2>
<p>Cùng dịp này, Tuổi Trẻ cũng nhắc tới đề xuất tổ hợp kinh tế đêm khoảng 5.000 tỉ đồng tại bãi biển Mỹ Khê của một doanh nghiệp (xem bài <a href="/kinh-te-dem-bien-my-khe-da-nang-2026/">kinh tế đêm biển Mỹ Khê</a>). Trước đó, lãnh đạo UBND thành phố từng kêu gọi doanh nghiệp đầu tư một khu vui chơi giải trí đẳng cấp kiểu Disneyland. Đề án kinh tế ban đêm 2027 – 2030 là bước cụ thể hóa định hướng đó, với công viên kiểu Disneyland Đà Nẵng là điểm nhấn được chú ý nhất.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Động lực dài hạn cho du lịch phía Nam:</strong> một công viên kiểu Disneyland Đà Nẵng quy mô quốc tế thường kéo theo khách sạn, dịch vụ, nhà ở cho người lao động. Vùng Nam Hội An – Thăng Bình cũ sẽ có thêm lý do để khách lưu trú dài ngày.</li>
<li><strong>Mới là đề xuất trong dự thảo:</strong> chưa có nhà đầu tư, vốn, quy mô. Từ ý tưởng tới khởi công một công viên kiểu Disneyland Đà Nẵng thường mất nhiều năm; Hiệp không khuyên khách mua đất chỉ vì tin này.</li>
<li><strong>Cảnh giác "sốt" đất Thăng An:</strong> khi có tin lớn như công viên kiểu Disneyland Đà Nẵng, môi giới dễ thổi giá đất nông nghiệp, đất chưa có quy hoạch chi tiết. Cần kiểm tra quy hoạch sử dụng đất, sổ đỏ trước khi đặt cọc.</li>
<li><strong>Ưu tiên sản phẩm đã có pháp lý, đã vận hành:</strong> các khu nghỉ dưỡng ven biển phía Nam đã hoạt động hưởng lợi sớm nhất nếu lượng khách tăng.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Các dự án dưới đây cùng nằm trên vùng ven biển phía Nam, sẽ hưởng lợi nếu công viên kiểu Disneyland Đà Nẵng được kêu gọi đầu tư thành công:</p>
<ul>
<li><a href="/du-an/hoiana-residences/">Hoiana Residences</a> (Duy Hải, ven biển Nam Hội An): căn hộ trong quần thể nghỉ dưỡng đã vận hành, cùng hướng phát triển du lịch phía Nam.</li>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>: khu đô thị ven biển phía Nam, gần khu vực Thăng Bình cũ, hưởng lợi khi dòng khách và dân cư dịch chuyển xuống phía Nam.</li>
</ul>
<p>Xem thêm bài <a href="/quy-hoach-chung-do-thi-thang-dien-den-2050/">quy hoạch đô thị Thăng Điền đến 2050</a> và <a href="/bat-dong-san-hoi-an-2026-sau-hop-nhat/">bất động sản Hội An 2026 sau hợp nhất</a>. Cần tư vấn bất động sản ven biển phía Nam Đà Nẵng, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://tuoitre.vn/da-nang-se-lam-cong-vien-kieu-disneyland-o-xa-thang-an-de-khai-thac-kinh-te-dem-100261120103228017.htm">Tuổi Trẻ (20/11/2026)</a>; <a href="https://plo.vn/da-nang-keu-goi-dau-tu-cong-vien-giai-tri-dang-cap-nhu-disneyland-post875301.html">Pháp Luật TP.HCM</a>. Nội dung là đề xuất trong dự thảo đề án đang tham vấn, có thể thay đổi khi được phê duyệt.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Công viên kiểu Disneyland Đà Nẵng ở Thăng An: đề xuất 2027',
			'desc'      => 'Công viên kiểu Disneyland Đà Nẵng được đề xuất tại xã Thăng An trong đề án kinh tế ban đêm 2027 – 2030: giải trí chuyên đề, nghỉ dưỡng, lễ hội, hội nghị.',
			'points'    => array(
				'Sáng 20/11/2026, Sở VH-TT-DL Đà Nẵng tham vấn đề án kinh tế ban đêm 2027 – 2030, tầm nhìn 2050',
				'Đề xuất kêu gọi đầu tư khu phức hợp vui chơi, lễ hội, sự kiện quốc tế theo mô hình Disneyland tại xã Thăng An',
				'Có thể gồm công viên chuyên đề, nghỉ dưỡng cao cấp, quảng trường sự kiện, sân khấu ngoài trời, trung tâm triển lãm – hội nghị',
			),
			'faq'       => array(
				array( 'Công viên kiểu Disneyland Đà Nẵng ở đâu?', 'Theo dự thảo đề án kinh tế ban đêm, khu phức hợp được đề xuất kêu gọi đầu tư tại xã Thăng An, vùng ven biển phía Nam thành phố.' ),
				array( 'Đã có nhà đầu tư chưa?', 'Chưa. Đây là đề xuất trong dự thảo đang tham vấn (20/11/2026); chưa công bố nhà đầu tư, quy mô hay vốn.' ),
				array( 'Tổ hợp gồm những hạng mục nào?', 'Có thể gồm công viên giải trí chuyên đề, khu nghỉ dưỡng cao cấp, quảng trường sự kiện, sân khấu ngoài trời, trung tâm triển lãm và hội nghị.' ),
				array( 'Có nên mua đất Thăng An đón tin này?', 'Cần thận trọng: dự án mới là đề xuất. Chỉ nên xem xét đất có sổ, đúng quy hoạch và tránh đặt cọc theo tin đồn.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/da-nang-se-lam-cong-vien-kieu-disneyland-o-xa-thang-an-de-khai-thac-kinh-te-dem-100261120103228017.htm',
			'https://plo.vn/da-nang-keu-goi-dau-tu-cong-vien-giai-tri-dang-cap-nhu-disneyland-post875301.html',
		),
	);

	/* ---------------- 21/11 – QĐ 5316/QĐ-UBND ngày 20/11/2026 phê duyệt giá đất cụ thể dự án Alphanam Luxury, phường An Hải (danang.gov.vn 21/11, anh Hiệp gửi) ---------------- */
	$posts[] = array(
		'slug'           => 'gia-dat-cu-the-alphanam-luxury-an-hai',
		'rev'            => 2, // 22/11: giọng văn thương hiệu Hiệp.
		'title'          => 'Giá đất cụ thể Alphanam Luxury: Đà Nẵng duyệt 96,7 triệu đồng/m² để thu nghĩa vụ tài chính do điều chỉnh quy hoạch',
		'excerpt'        => 'Quyết định 5316/QĐ-UBND ngày 20/11/2026 phê duyệt giá đất cụ thể tại dự án Alphanam Luxury, phường An Hải, tại thời điểm 29/10/2018: 96.734.786 đồng/m² sau điều chỉnh quy hoạch, làm cơ sở thu nghĩa vụ tài chính phát sinh (nếu có).',
		'keyword'        => 'giá đất cụ thể Alphanam Luxury',
		'keywords_extra' => array( 'Quyết định 5316/QĐ-UBND', 'giá đất An Hải Đà Nẵng', 'nghĩa vụ tài chính điều chỉnh quy hoạch', 'giá đất ven sông Hàn' ),
		'project'        => 'sun-ponte-residence',
		'schedule'       => '2026-11-21 07:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Giá đất', 'An Hải', 'Pháp lý dự án' ),
		'image'          => 'plugin:img/capital-square/capital-square-tien-do-5-2026-flycam-01.jpg',
		'image_alt'      => 'Giá đất cụ thể Alphanam Luxury tại phường An Hải – khu ven sông Hàn, Đà Nẵng (ảnh flycam thực tế)',
		'content'        => <<<'HTML'
<p>Bảng <strong>giá đất cụ thể Alphanam Luxury</strong> vừa được UBND TP Đà Nẵng phê duyệt tại Quyết định số 5316/QĐ-UBND ngày 20/11/2026. Mức giá được tính tại thời điểm 29/10/2018, làm cơ sở thu nghĩa vụ tài chính phát sinh (nếu có) do điều chỉnh quy hoạch chi tiết tại dự án Tổ hợp căn hộ thương mại, dịch vụ và khách sạn Alphanam Luxury, phường An Hải, của Công ty Cổ phần Địa ốc Alphanam.</p>
<!--hh-featured-->
<h2>Giá đất cụ thể Alphanam Luxury trước và sau điều chỉnh quy hoạch</h2>
<p>Theo thông tin trên Cổng thông tin điện tử thành phố, quyết định nêu giá đất cụ thể Alphanam Luxury của quy hoạch trước và sau khi điều chỉnh:</p>
<table>
<thead><tr><th>Quy hoạch</th><th>Khu đất</th><th>Giá đất cụ thể (thời điểm 29/10/2018)</th></tr></thead>
<tbody>
<tr><td rowspan="2">Trước điều chỉnh</td><td>Thửa 29, 30, 31, 32 tờ bản đồ số 10 (lô A1, A2, A3, A4 khu biệt thự cao cấp Redstar)</td><td>Lần lượt 85.116.409; 195.359.366; 183.453.439 và 184.695.241 đồng/m²</td></tr>
<tr><td>Đất thương mại dịch vụ, thời hạn 50 năm</td><td>29.721.599 đồng/m²</td></tr>
<tr><td>Sau điều chỉnh (Quyết định 5001/QĐ-UBND ngày 29/10/2018)</td><td>1.185,8 m² đất ở xây khối căn hộ; 1.439,3 m² đất thương mại dịch vụ xây khối khách sạn; 2.866 m² đất thương mại dịch vụ phần không xây dựng</td><td>96.734.786 đồng/m²</td></tr>
</tbody>
</table>
<p>Thời điểm tính giá là ngày ký Quyết định 5001/QĐ-UBND ngày 29/10/2018 – quyết định cho phép Công ty Cổ phần Địa ốc Alphanam chuyển mục đích sử dụng đất tại dự án. Vì vậy, giá đất cụ thể Alphanam Luxury phản ánh mặt bằng giá năm 2018, không phải giá thị trường hiện nay.</p>
<!--hh-img:img/capital-square/capital-square-tien-do-5-2026-flycam-01.jpg|Giá đất cụ thể Alphanam Luxury được duyệt cho khu đất tại phường An Hải, bờ Đông sông Hàn – khu vực có nhiều dự án cao tầng (ảnh flycam thực tế 5/2026)-->
<h2>Giá đất cụ thể dùng để làm gì?</h2>
<p>Giá đất cụ thể là mức giá do UBND thành phố quyết định cho từng trường hợp, dùng để tính các khoản nghĩa vụ tài chính về đất như tiền sử dụng đất, tiền thuê đất. Ở trường hợp này, việc điều chỉnh quy hoạch chi tiết làm thay đổi cơ cấu sử dụng đất (từ các lô biệt thự và đất thương mại dịch vụ sang đất ở xây căn hộ, đất thương mại dịch vụ xây khách sạn), nên phát sinh phần chênh lệch nghĩa vụ tài chính mà doanh nghiệp có thể phải nộp thêm.</p>
<p>Theo quyết định, Văn phòng Đăng ký đất đai thành phố chuyển hồ sơ sang Thuế thành phố Đà Nẵng; cơ quan thuế căn cứ giá đất cụ thể Alphanam Luxury để thông báo nghĩa vụ tài chính cho doanh nghiệp. Thông tin công bố chưa nêu tổng số tiền phải nộp.</p>
<h2>Điều kiện để quyết định có hiệu lực</h2>
<p>Đáng chú ý, Quyết định 5316/QĐ-UBND chỉ có hiệu lực áp dụng khi được Cơ quan Kiểm toán Nhà nước xem xét, thống nhất bằng văn bản. Như vậy, giá đất cụ thể Alphanam Luxury chưa phải con số cuối cùng cho tới khi Kiểm toán Nhà nước có ý kiến.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tháo gỡ pháp lý dự án tồn đọng:</strong> việc xác định giá đất cụ thể Alphanam Luxury là bước để hoàn tất nghĩa vụ tài chính – điều kiện quan trọng để dự án tiến tới các thủ tục tiếp theo. Phê duyệt giá đất cụ thể Alphanam Luxury là tín hiệu thành phố đang xử lý dần các dự án vướng từ giai đoạn trước.</li>
<li><strong>Thước đo giá đất ven sông Hàn:</strong> ngay từ năm 2018, giá đất cụ thể các lô biệt thự tại đây đã lên tới khoảng 183 – 195 triệu đồng/m². Đây cũng là điều Hiệp hay giải thích khi khách hỏi vì sao căn hộ mới ở bờ Đông sông Hàn khó có giá thấp.</li>
<li><strong>Người mua cần xem nghĩa vụ tài chính:</strong> trường hợp giá đất cụ thể Alphanam Luxury cho thấy với dự án điều chỉnh quy hoạch, nên hỏi rõ chủ đầu tư đã hoàn thành nghĩa vụ tài chính chưa, vì việc này ảnh hưởng tới tiến độ cấp sổ.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Các dự án dưới đây cùng ở phường An Hải, bờ Đông sông Hàn – nơi giá đất cụ thể Alphanam Luxury là một tham chiếu về mặt bằng giá đất khu vực:</p>
<ul>
<li><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> (chân cầu Rồng): căn hộ Sun Group đang bàn giao, pháp lý rõ ràng, cùng khu vực ven sông.</li>
<li><a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a> (góc Võ Văn Kiệt – Võ Nguyên Giáp): căn hộ mới tại An Hải, chịu cùng mặt bằng giá đất.</li>
<li><a href="/du-an/capital-square-toa-c3/">Capital Square tòa C3</a> và <a href="/du-an/capital-square-hudson-place-s4/">Hudson Place S4</a>: tổ hợp ven sông Hàn tại An Hải.</li>
</ul>
<p>Xem thêm bài <a href="/trung-tam-tai-chinh-quoc-te-da-nang/">trung tâm tài chính quốc tế Đà Nẵng</a> và <a href="/huy-quy-hoach-khu-biet-thu-son-tra/">hủy quy hoạch khu biệt thự Sơn Trà</a>. Cần tư vấn căn hộ ven sông Hàn, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://danang.gov.vn/vi/web/dng/w/phe-duyet-gia-dat-cu-the-tai-du-an-alphanam-luxury-phuong-an-hai">Cổng thông tin điện tử TP Đà Nẵng (21/11/2026)</a> – Quyết định 5316/QĐ-UBND ngày 20/11/2026. Giá đất là giá cụ thể tại thời điểm 29/10/2018 để tính nghĩa vụ tài chính, không phải giá bán căn hộ.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Giá đất cụ thể Alphanam Luxury: 96,7 triệu/m² (QĐ 5316)',
			'desc'      => 'Giá đất cụ thể Alphanam Luxury tại An Hải: 96.734.786 đồng/m² theo QĐ 5316/QĐ-UBND ngày 20/11/2026, tính tại 29/10/2018 để thu nghĩa vụ tài chính.',
			'points'    => array(
				'QĐ 5316/QĐ-UBND ngày 20/11/2026 phê duyệt giá đất cụ thể tại thời điểm 29/10/2018',
				'Sau điều chỉnh quy hoạch: 96.734.786 đồng/m² cho 1.185,8 m² đất ở, 1.439,3 m² và 2.866 m² đất thương mại dịch vụ',
				'Chỉ có hiệu lực khi Kiểm toán Nhà nước xem xét, thống nhất bằng văn bản',
			),
			'faq'       => array(
				array( 'Giá đất cụ thể Alphanam Luxury là bao nhiêu?', 'Sau điều chỉnh quy hoạch là 96.734.786 đồng/m², tính tại thời điểm 29/10/2018, theo Quyết định 5316/QĐ-UBND ngày 20/11/2026.' ),
				array( 'Giá này dùng để làm gì?', 'Làm cơ sở thu nghĩa vụ tài chính phát sinh (nếu có) do điều chỉnh quy hoạch chi tiết; cơ quan thuế căn cứ để thông báo cho doanh nghiệp.' ),
				array( 'Quyết định đã có hiệu lực chưa?', 'Quyết định chỉ có hiệu lực áp dụng khi Cơ quan Kiểm toán Nhà nước xem xét, thống nhất bằng văn bản.' ),
				array( 'Đây có phải giá bán căn hộ không?', 'Không. Đây là giá đất để tính nghĩa vụ tài chính với Nhà nước tại thời điểm 2018, không phải giá bán căn hộ hiện nay.' ),
			),
		),
		'sources'        => array(
			'https://danang.gov.vn/vi/web/dng/w/phe-duyet-gia-dat-cu-the-tai-du-an-alphanam-luxury-phuong-an-hai',
		),
	);

	/* ---------------- 21/11 – Quốc hội thông qua Luật Kinh doanh bất động sản (sửa đổi): cọc tối đa 5%, lần đầu ≤ 30%, cấm thu tiền giữ chỗ; hiệu lực 1/7/2027 (anh Hiệp gửi link VietnamBiz) ---------------- */
	$posts[] = array(
		'slug'           => 'luat-kinh-doanh-bat-dong-san-sua-doi-2026',
		'rev'            => 3, // 21/11 17h: bổ sung trần 70% trước bàn giao, 95% trước khi cấp sổ, thuê mua 30% / 50% (anh Hiệp gửi).
		'title'          => 'Luật Kinh doanh bất động sản sửa đổi được thông qua: cọc tối đa 5%, lần đầu không quá 30%, cấm thu tiền giữ chỗ',
		'excerpt'        => 'Sáng 21/11/2026, Quốc hội thông qua Luật Kinh doanh bất động sản (sửa đổi) với 471/479 đại biểu tán thành; luật có 10 chương, 63 điều, hiệu lực từ 1/7/2027: đặt cọc tối đa 5%, nhà hình thành trong tương lai thanh toán lần đầu không quá 30%, cấm thu tiền giữ chỗ.',
		'keyword'        => 'Luật Kinh doanh bất động sản sửa đổi',
		'keywords_extra' => array( 'đặt cọc mua nhà tối đa 5%', 'nhà ở hình thành trong tương lai', 'cấm thu tiền giữ chỗ', 'luật kinh doanh bất động sản 2027' ),
		'project'        => 'sun-saphia-residence',
		'schedule'       => '2026-11-21 16:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Pháp lý', 'Luật Kinh doanh bất động sản', 'Kinh nghiệm mua nhà' ),
		'image'          => 'plugin:img/capital-square/capital-square-tien-do-5-2026-flycam-01.jpg',
		'image_alt'      => 'Luật Kinh doanh bất động sản sửa đổi siết đặt cọc, thanh toán khi mua nhà hình thành trong tương lai (ảnh công trường thực tế tại Đà Nẵng)',
		'content'        => <<<'HTML'
<p><strong>Luật Kinh doanh bất động sản sửa đổi</strong> vừa được Quốc hội thông qua sáng 21/11/2026 tại Kỳ họp thứ Hai, Quốc hội khóa XVI, với 471/479 đại biểu tham gia biểu quyết tán thành. Luật gồm 10 chương, 63 điều (giảm 20 điều so với Luật năm 2023) và có hiệu lực từ ngày 1/7/2027. Điểm người mua nhà quan tâm nhất là các quy định siết đặt cọc, tiến độ thanh toán và cấm thu tiền khi dự án chưa đủ điều kiện.</p>
<!--hh-featured-->
<h2>Luật Kinh doanh bất động sản sửa đổi: 8 điểm người mua nhà cần biết</h2>
<table>
<thead><tr><th>Nội dung</th><th>Quy định mới (theo báo chí đưa tin ngày 21/11/2026)</th></tr></thead>
<tbody>
<tr><td>Đặt cọc</td><td>Chủ đầu tư chỉ được nhận đặt cọc tối đa 5% giá bán và chỉ khi dự án đã đủ điều kiện đưa vào kinh doanh; thỏa thuận đặt cọc phải ghi rõ giá bán, tiền cọc được tính vào lần thanh toán đầu tiên</td></tr>
<tr><td>Thanh toán lần đầu</td><td>Với nhà ở hình thành trong tương lai, lần đầu không quá 30% giá trị hợp đồng (đã gồm tiền cọc); các lần sau theo tiến độ xây dựng</td></tr>
<tr><td>Trước khi bàn giao nhà</td><td>Các lần thanh toán tiếp theo phải phù hợp tiến độ xây dựng, nhưng tổng số tiền không quá 70% giá trị hợp đồng khi chưa bàn giao nhà ở, công trình cho bên mua</td></tr>
<tr><td>Trước khi cấp sổ</td><td>Chủ đầu tư không được thu quá 95% giá trị hợp đồng trước khi người mua được cấp Giấy chứng nhận; phần còn lại thanh toán khi người mua nhận giấy chứng nhận (hoặc tự nguyện làm thủ tục cấp) và chủ đầu tư đã bàn giao đủ hồ sơ</td></tr>
<tr><td>Thuê mua nhà hình thành trong tương lai</td><td>Lần đầu không quá 30% giá trị hợp đồng; tổng tiền trả trước không quá 50%, phần còn lại tính thành tiền thuê trả hằng tháng trong thời hạn thuê mua (trừ khi các bên thỏa thuận khác)</td></tr>
<tr><td>Tiền giữ chỗ, "booking"</td><td>Cấm chủ đầu tư thu tiền dưới mọi hình thức khi dự án chưa đủ điều kiện kinh doanh</td></tr>
<tr><td>Công khai thông tin</td><td>Phải công khai đầy đủ, trung thực thông tin dự án trên Hệ thống thông tin về nhà ở và thị trường bất động sản trước khi đưa vào kinh doanh</td></tr>
<tr><td>Hành vi bị cấm</td><td>Kinh doanh bất động sản không đủ điều kiện; giả mạo tài liệu, gian lận, lừa đảo; thu, sử dụng tiền của bên mua trái pháp luật</td></tr>
</tbody>
</table>
<p>Ngoài ra, Luật Kinh doanh bất động sản sửa đổi không cho chủ đầu tư ủy quyền cho bên khác ký hợp đồng đặt cọc, mua bán, trừ dự án có từ hai nhà đầu tư trở lên theo quy định của Chính phủ. Các quy định chi tiết sẽ được hướng dẫn trong nghị định; Hoàng Hiệp sẽ cập nhật khi có văn bản luật chính thức.</p>
<!--hh-img:img/capital-square/capital-square-tien-do-5-2026-flycam-01.jpg|Luật Kinh doanh bất động sản sửa đổi áp dụng cho dự án nhà ở hình thành trong tương lai đang xây dựng tại Đà Nẵng (ảnh flycam thực tế 5/2026)-->
<h2>Đặt cọc tối đa 5% – thay đổi lớn với người mua</h2>
<p>Trước khi có Luật Kinh doanh bất động sản sửa đổi, nhiều dự án thu cọc 10 – 20% hoặc thu "tiền giữ chỗ" từ khi chưa đủ điều kiện mở bán. Khi Luật Kinh doanh bất động sản sửa đổi có hiệu lực, tiền cọc bị khống chế 5% giá bán, chỉ được nhận khi dự án đã đủ điều kiện. Người mua giảm được rủi ro "kẹt tiền" ở những dự án chưa hoàn thiện pháp lý, chưa có hạ tầng.</p>
<p>Với chủ đầu tư, Luật Kinh doanh bất động sản sửa đổi buộc phải hoàn thiện pháp lý trước khi bán, không thể dùng tiền giữ chỗ để thăm dò thị trường hoặc làm vốn. Các dự án của chủ đầu tư lớn, có tiềm lực tài chính sẽ ít bị ảnh hưởng hơn.</p>
<h2>Thanh toán theo Luật Kinh doanh bất động sản sửa đổi: lần đầu không quá 30%</h2>
<p>Theo Luật Kinh doanh bất động sản sửa đổi, với căn hộ, nhà ở hình thành trong tương lai, lần thanh toán đầu tiên không quá 30% giá trị hợp đồng (đã tính cả tiền cọc); các đợt sau phải bám tiến độ xây dựng thực tế. Tổng số tiền thu không quá 70% khi chưa bàn giao nhà và không quá 95% khi người mua chưa được cấp giấy chứng nhận – 5% cuối chỉ thanh toán khi có sổ. Đây là cơ chế giúp tiền của người mua đi cùng công trình và gắn trách nhiệm làm sổ của chủ đầu tư.</p>
<h2>Luật Kinh doanh bất động sản sửa đổi có hiệu lực khi nào?</h2>
<p>Luật Kinh doanh bất động sản sửa đổi có hiệu lực từ ngày 1/7/2027. Từ nay đến thời điểm đó, các giao dịch vẫn thực hiện theo Luật Kinh doanh bất động sản năm 2023 và văn bản hướng dẫn hiện hành. Người mua nên kiểm tra kỹ điều kiện bán nhà hình thành trong tương lai, thông báo đủ điều kiện của Sở Xây dựng và bảo lãnh ngân hàng của dự án trước khi đặt cọc.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Bảo vệ người mua tốt hơn:</strong> Luật Kinh doanh bất động sản sửa đổi chặn các khoản "booking" không có cơ sở pháp lý – vốn là nguồn rủi ro lớn nhất với người mua dự án mới.</li>
<li><strong>Dự án đủ pháp lý được ưu tiên:</strong> thị trường sẽ phân hóa rõ giữa dự án đã đủ điều kiện kinh doanh và dự án "bán trước, làm sau". Khi tư vấn, Hiệp luôn ưu tiên giới thiệu dự án đã có thông báo đủ điều kiện bán.</li>
<li><strong>Dòng tiền nhẹ hơn ban đầu:</strong> cọc 5% và lần đầu tối đa 30% giúp người mua có thời gian chuẩn bị tài chính, nhất là khi kết hợp vay ngân hàng.</li>
<li><strong>Chính sách bán hàng có thể thay đổi:</strong> khi Luật Kinh doanh bất động sản sửa đổi có hiệu lực, các ưu đãi thanh toán nhanh, thanh toán sớm hiện nay sẽ cần điều chỉnh cho phù hợp; mỗi đợt bán cần xem chính sách đúng thời điểm.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Các dự án căn hộ hình thành trong tương lai tại Đà Nẵng đều chịu điều chỉnh khi Luật Kinh doanh bất động sản sửa đổi có hiệu lực; hợp đồng ký trước đó thực hiện theo quy định chuyển tiếp của Luật Kinh doanh bất động sản sửa đổi. Một số dự án đang mở bán:</p>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>: căn hộ Sun Group đang bán theo tiến độ – xem thêm <a href="/tien-do-thanh-toan-sun-saphia-residence/">tiến độ thanh toán Sun Saphia Residence</a>.</li>
<li><a href="/du-an/fours-tower/">FourS Tower</a> và <a href="/du-an/the-poet-residence-da-nang/">The Poet Residence</a>: căn hộ đang bán theo tiến độ xây dựng, người mua nên đối chiếu lịch thanh toán với quy định mới.</li>
</ul>
<p>Cần kiểm tra pháp lý, điều kiện bán của dự án trước khi đặt cọc, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://baoxaydung.vn/quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-192261121093157195.htm">Báo Xây dựng</a>; <a href="https://luatvietnam.vn/tin-van-ban-moi/sang-21-11-quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-186-116027-article.html">LuatVietnam</a>; <a href="https://tienphong.vn/quy-dinh-moi-ve-tien-do-thanh-toan-tien-dat-coc-bat-dong-san-post1896354.tpo">Tiền Phong</a>; <a href="https://dantri.com.vn/bat-dong-san/chua-co-so-do-chu-dau-tu-khong-duoc-thu-het-tien-mua-nha-20261121160032534.htm">Dân trí</a>; <a href="https://vietnambiz.vn/quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-bo-sung-nhieu-quy-dinh-ve-giao-dich-nha-dat-2026112195245509.htm">VietnamBiz</a>. Nội dung theo báo chí đưa tin ngày 21/11/2026; cần đối chiếu văn bản luật chính thức khi được công bố.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Luật Kinh doanh bất động sản sửa đổi: cọc tối đa 5% từ 2027',
			'desc'      => 'Luật Kinh doanh bất động sản sửa đổi thông qua 21/11/2026: đặt cọc tối đa 5%, nhà hình thành trong tương lai trả lần đầu ≤ 30%, cấm thu tiền giữ chỗ.',
			'points'    => array(
				'Quốc hội thông qua sáng 21/11/2026, 471/479 đại biểu tán thành; 10 chương, 63 điều; hiệu lực 1/7/2027',
				'Đặt cọc tối đa 5% giá bán, chỉ khi dự án đủ điều kiện kinh doanh; lần đầu không quá 30% (gồm cọc)',
				'Tổng tiền thu không quá 70% trước bàn giao, không quá 95% trước khi cấp sổ; cấm thu tiền giữ chỗ',
			),
			'faq'       => array(
				array( 'Luật Kinh doanh bất động sản sửa đổi có hiệu lực khi nào?', 'Từ ngày 1/7/2027. Trước thời điểm đó, giao dịch vẫn áp dụng Luật Kinh doanh bất động sản năm 2023.' ),
				array( 'Đặt cọc mua nhà tối đa bao nhiêu?', 'Theo luật mới, chủ đầu tư chỉ được nhận đặt cọc tối đa 5% giá bán và chỉ khi dự án đã đủ điều kiện đưa vào kinh doanh.' ),
				array( 'Mua nhà hình thành trong tương lai trả lần đầu bao nhiêu?', 'Không quá 30% giá trị hợp đồng, đã bao gồm tiền đặt cọc; các lần sau theo tiến độ xây dựng.' ),
				array( 'Chưa có sổ, chủ đầu tư được thu tối đa bao nhiêu?', 'Không quá 95% giá trị hợp đồng; phần còn lại thanh toán khi người mua nhận giấy chứng nhận. Trước khi bàn giao nhà, tổng tiền thu không quá 70%.' ),
				array( 'Chủ đầu tư có được thu tiền giữ chỗ không?', 'Không. Luật cấm thu tiền dưới mọi hình thức khi dự án chưa đủ điều kiện kinh doanh.' ),
			),
		),
		'sources'        => array(
			'https://baoxaydung.vn/quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-192261121093157195.htm',
			'https://luatvietnam.vn/tin-van-ban-moi/sang-21-11-quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-186-116027-article.html',
			'https://tienphong.vn/quy-dinh-moi-ve-tien-do-thanh-toan-tien-dat-coc-bat-dong-san-post1896354.tpo',
			'https://dantri.com.vn/bat-dong-san/chua-co-so-do-chu-dau-tu-khong-duoc-thu-het-tien-mua-nha-20261121160032534.htm',
			'https://vietnambiz.vn/quoc-hoi-thong-qua-luat-kinh-doanh-bat-dong-san-sua-doi-bo-sung-nhieu-quy-dinh-ve-giao-dich-nha-dat-2026112195245509.htm',
		),
	);

	/* ---------------- 23/11 – Kế hoạch hạ tầng khu kinh tế, KCN gắn Khu thương mại tự do 2026 – 2045 ---------------- */
	$posts[] = array(
		'slug'           => 'ha-tang-khu-thuong-mai-tu-do-da-nang-2045',
		'title'          => 'Hạ tầng Khu thương mại tự do Đà Nẵng: kế hoạch 2026 – 2045 nâng sân bay Chu Lai lên 4F, làm tổng thể cảng Liên Chiểu',
		'excerpt'        => 'Đà Nẵng ban hành kế hoạch phát triển hạ tầng khu kinh tế, khu công nghiệp, khu công nghệ cao gắn với Khu thương mại tự do giai đoạn 2026 – 2045: sân bay Chu Lai 4F khoảng 10 triệu khách/năm, cảng container Liên Chiểu, cảng cạn ICD. Tác động tới bất động sản Liên Chiểu, Hòa Vang.',
		'keyword'        => 'hạ tầng Khu thương mại tự do Đà Nẵng',
		'keywords_extra' => array( 'sân bay Chu Lai 4F', 'cảng Liên Chiểu', 'khu công nghiệp Đà Nẵng 2045', 'bất động sản Liên Chiểu' ),
		'project'        => 'the-ori-garden',
		'schedule'       => '2026-11-23 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Khu thương mại tự do', 'Cảng Liên Chiểu', 'Quy hoạch Đà Nẵng' ),
		'image'          => 'plugin:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg',
		'image_alt'      => 'Hạ tầng Khu thương mại tự do Đà Nẵng – kế hoạch 2026 – 2045 (ảnh tư liệu sông Hàn, Đà Nẵng)',
		'content'        => <<<'HTML'
<p><strong>Hạ tầng Khu thương mại tự do Đà Nẵng</strong> vừa có lộ trình dài hạn: UBND thành phố đã ban hành kế hoạch phát triển hạ tầng các khu kinh tế, khu công nghiệp, cụm công nghiệp, khu công nghệ cao và khu công nghệ số gắn với Khu thương mại tự do giai đoạn 2026 – 2045, tầm nhìn đến 2050. Theo <a href="https://baodautu.vn/da-nang-phat-trien-ha-tang-chien-luoc-ket-noi-khu-cong-nghiep-khu-thuong-mai-tu-do-d697644.html" target="_blank" rel="noopener">Báo Đầu tư</a>, kế hoạch do Phó Chủ tịch UBND thành phố Phan Thái Bình ký ban hành.</p>
<!--hh-featured-->
<h2>Hạ tầng Khu thương mại tự do Đà Nẵng: 3 trục đầu tư chính</h2>
<p>Bài viết dưới đây tóm tắt theo nội dung báo chí đã đưa tin; Hiệp chưa đọc được toàn văn kế hoạch nên chỉ nêu những điểm đã được công bố.</p>
<table>
<thead><tr><th>Hạng mục</th><th>Định hướng theo kế hoạch</th></tr></thead>
<tbody>
<tr><td>Sân bay Chu Lai</td><td>Đầu tư thành sân bay quốc tế cấp 4F, công suất khoảng 10 triệu hành khách/năm và 1,5 triệu tấn hàng hóa/năm, kèm trung tâm logistics hàng không và bảo dưỡng tàu bay</td></tr>
<tr><td>Cảng biển, logistics</td><td>Đầu tư xây dựng tổng thể bến cảng container Liên Chiểu; phát triển các cảng cạn (ICD) gắn với khu công nghiệp và Khu thương mại tự do</td></tr>
<tr><td>Khu công nghệ cao</td><td>Mở rộng Khu công nghệ cao Đà Nẵng thành đô thị khoa học – công nghệ hoàn chỉnh</td></tr>
</tbody>
</table>
<p>Ba hạng mục của kế hoạch hạ tầng Khu thương mại tự do Đà Nẵng gắn với nhau thành một chuỗi: hàng hóa sản xuất trong khu công nghiệp, khu công nghệ cao đi ra cảng Liên Chiểu bằng đường biển hoặc ra sân bay Chu Lai bằng đường hàng không, còn Khu thương mại tự do là nơi hưởng cơ chế ưu đãi về thuế, hải quan để thu hút nhà đầu tư.</p>
<h2>Hạ tầng Khu thương mại tự do Đà Nẵng đã triển khai tới đâu?</h2>
<p>Khu thương mại tự do Đà Nẵng được thành lập năm 2025, gồm nhiều vị trí phân tán ở Liên Chiểu, Hòa Vang và khu vực cảng. Tháng 11/2026, thành phố đã chọn nhà đầu tư hạ tầng cho vị trí số 7 tại Hòa Vang – chi tiết xem bài <a href="/vsip-ha-tang-vi-tri-so-7-khu-thuong-mai-tu-do/">VSIP làm hạ tầng vị trí số 7 Khu thương mại tự do</a>. Kế hoạch hạ tầng Khu thương mại tự do Đà Nẵng 2026 – 2045 vừa ban hành là bước tiếp theo: đưa hạ tầng giao thông, logistics bám theo các vị trí này.</p>
<!--hh-img:img/tin-tuc/vsip-vi-tri-7-khu-thuong-mai-tu-do-11-2026.jpg|Khu vực Hòa Vang nơi triển khai hạ tầng Khu thương mại tự do Đà Nẵng vị trí số 7-->
<p>Ở phía Nam, mắt xích hàng không của hạ tầng Khu thương mại tự do Đà Nẵng là sân bay Chu Lai, nằm trong vùng Quảng Nam cũ đã hợp nhất về Đà Nẵng. Cùng khu vực này, thành phố đã ấn định thời hạn khởi công ba khu đô thị lớn – xem bài <a href="/khoi-cong-3-khu-do-thi-chu-lai-40400-ty/">khởi công 3 khu đô thị Chu Lai</a>.</p>
<h2>Tác động tới bất động sản – nhận định của Hoàng Hiệp</h2>
<p>Kế hoạch hạ tầng Khu thương mại tự do Đà Nẵng có tầm nhìn tới 2045 – 2050, nên tác động lên giá nhà đất sẽ đến dần theo từng công trình khởi công chứ không đến ngay. Hiệp chia làm ba nhóm để khách dễ hình dung:</p>
<ul>
<li><strong>Liên Chiểu – Hòa Khánh:</strong> hưởng lợi trực tiếp nhất từ hạ tầng Khu thương mại tự do Đà Nẵng và cảng Liên Chiểu và các vị trí Khu thương mại tự do phía Tây Bắc. Nhu cầu nhà ở cho chuyên gia, kỹ sư và công nhân sẽ tăng khi cảng và khu công nghiệp vận hành, đặc biệt là căn hộ cho thuê giá vừa phải.</li>
<li><strong>Hòa Vang:</strong> quỹ đất lớn, gắn vị trí số 7 Khu thương mại tự do; phù hợp người mua dài hạn, cần kiểm tra kỹ quy hoạch từng thửa vì nhiều khu vực còn là đất nông nghiệp.</li>
<li><strong>Chu Lai – Núi Thành:</strong> câu chuyện dài hạn nhất, phụ thuộc vào tiến độ nâng cấp sân bay; Hiệp khuyên chỉ nên quan tâm khi có quyết định đầu tư và nguồn vốn cụ thể cho sân bay.</li>
</ul>
<p>Khi khách hỏi Hiệp nên chọn đâu để đón sóng hạ tầng Khu thương mại tự do Đà Nẵng, Hiệp thường gợi ý ưu tiên dự án đã có pháp lý rõ và đã xây dựng ở khu Tây Bắc, thay vì đất nền chưa có hạ tầng chỉ vì tên một kế hoạch dài hạn.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/the-ori-garden/">The Ori Garden</a> – căn hộ tại Liên Chiểu, vùng hưởng lợi từ hạ tầng Khu thương mại tự do Đà Nẵng, gần trục đi cảng Liên Chiểu và các khu công nghiệp phía Tây Bắc, phù hợp nhu cầu thuê của người làm việc tại cảng và Khu thương mại tự do.</li>
<li><a href="/du-an/dragon-smart-city/">Dragon Smart City</a> – khu đô thị ở Liên Chiểu, hưởng lợi khi hạ tầng logistics và việc làm quanh cảng tăng.</li>
<li><a href="/du-an/lakeside-palace/">Lakeside Palace</a> – khu dân cư tại Liên Chiểu, cùng vùng ảnh hưởng của cảng và khu công nghiệp.</li>
<li><a href="/du-an/ecohome-hoa-hiep-da-nang/">Nhà ở xã hội Ecohome Hòa Hiệp</a> – nguồn nhà ở cho người lao động khu Tây Bắc, gần cảng Liên Chiểu.</li>
</ul>
<p>Cần thông tin giá và pháp lý các dự án khu Liên Chiểu, Hòa Vang hoặc tư vấn chọn bất động sản đón hạ tầng Khu thương mại tự do Đà Nẵng, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Báo Đầu tư (kế hoạch phát triển hạ tầng các khu kinh tế, khu công nghiệp, khu công nghệ cao gắn với Khu thương mại tự do giai đoạn 2026 – 2045, tầm nhìn 2050); Cổng thông tin điện tử TP Đà Nẵng (Quy hoạch chung đến 2050: ưu tiên cảng Liên Chiểu, nâng cấp sân bay Chu Lai). Nội dung tóm tắt theo báo chí, chưa phải toàn văn kế hoạch.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Hạ tầng Khu thương mại tự do Đà Nẵng: kế hoạch 2026 – 2045',
			'desc'      => 'Hạ tầng Khu thương mại tự do Đà Nẵng 2026 – 2045: sân bay Chu Lai 4F khoảng 10 triệu khách/năm, cảng container Liên Chiểu, ICD. Tác động tới BĐS Liên Chiểu.',
			'points'    => array(
				'Hạ tầng Khu thương mại tự do Đà Nẵng có kế hoạch giai đoạn 2026 – 2045, tầm nhìn 2050',
				'Sân bay Chu Lai lên cấp 4F: khoảng 10 triệu hành khách và 1,5 triệu tấn hàng hóa/năm',
				'Đầu tư tổng thể bến cảng container Liên Chiểu và các cảng cạn ICD gắn khu công nghiệp',
				'Khu công nghệ cao mở rộng thành đô thị khoa học – công nghệ',
			),
			'faq'       => array(
				array( 'Kế hoạch hạ tầng Khu thương mại tự do Đà Nẵng áp dụng giai đoạn nào?', 'Giai đoạn 2026 – 2045, tầm nhìn đến 2050, gồm hạ tầng các khu kinh tế, khu công nghiệp, cụm công nghiệp, khu công nghệ cao và khu công nghệ số gắn với Khu thương mại tự do.' ),
				array( 'Sân bay Chu Lai được nâng cấp thế nào?', 'Theo kế hoạch, sân bay Chu Lai được đầu tư thành sân bay quốc tế cấp 4F, công suất khoảng 10 triệu hành khách/năm và 1,5 triệu tấn hàng hóa/năm.' ),
				array( 'Cảng Liên Chiểu có trong kế hoạch không?', 'Có. Thành phố đầu tư xây dựng tổng thể bến cảng container Liên Chiểu và phát triển các cảng cạn ICD gắn với khu công nghiệp, Khu thương mại tự do.' ),
				array( 'Bất động sản khu nào hưởng lợi?', 'Liên Chiểu – Hòa Khánh gần cảng và các vị trí Khu thương mại tự do phía Tây Bắc hưởng lợi rõ nhất; Hòa Vang và Chu Lai là câu chuyện dài hạn hơn.' ),
			),
		),
		'sources'        => array(
			'https://baodautu.vn/da-nang-phat-trien-ha-tang-chien-luoc-ket-noi-khu-cong-nghiep-khu-thuong-mai-tu-do-d697644.html',
			'https://danang.gov.vn/en/w/phe-duyet-quy-hoach-chung-thanh-pho-da-nang-den-nam-2050-tam-nhin-den-nam-2075',
		),
	);

	/* ---------------- 23/11 – Nhà ở xã hội An Hòa Sun Home nhận hồ sơ 104 căn từ 2/12 ---------------- */
	$posts[] = array(
		'slug'           => 'nha-o-xa-hoi-sun-home-son-tra-104-can',
		'title'          => 'Nhà ở xã hội Sun Home Sơn Trà nhận hồ sơ 104 căn từ 2/12/2026: giá khoảng 6,38 triệu/m², chỉ dành cho hộ di dời 3 chung cư cũ',
		'excerpt'        => 'Sun Group mở nhận hồ sơ mua 104 căn nhà ở xã hội tòa SH2, Khu dân cư An Hòa (Sun Home) trên đường Vân Đồn, phường Sơn Trà từ 2/12/2026 đến 5/1/2027. Giá khoảng 6,38 triệu đồng/m², đối tượng là hộ giải tỏa chung cư Thuận Phước, Lâm đặc sản Hòa Cường, Hòa Minh.',
		'keyword'        => 'nhà ở xã hội Sun Home Sơn Trà',
		'keywords_extra' => array( 'An Hòa Sun Home', 'nhà ở xã hội Đà Nẵng 2026', 'chung cư Thuận Phước di dời', 'nhà ở xã hội Sun Group' ),
		'project'        => 'sun-ponte-residence',
		'schedule'       => '2026-11-23 10:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Nhà ở xã hội', 'Sun Group', 'Sơn Trà' ),
		'image'          => 'plugin:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg',
		'image_alt'      => 'Nhà ở xã hội Sun Home Sơn Trà – khu vực bờ Đông sông Hàn, Đà Nẵng (ảnh flycam thực tế 11/2026)',
		'content'        => <<<'HTML'
<p><strong>Nhà ở xã hội Sun Home Sơn Trà</strong> sắp nhận hồ sơ: chủ đầu tư Sun Group mở bán 104 căn nhà ở xã hội tại tòa SH2, Khu dân cư An Hòa (thường gọi là Sun Home) trên đường Vân Đồn, phường Sơn Trà, Đà Nẵng. Thời gian nhận hồ sơ từ ngày 2/12/2026 đến hết ngày 5/1/2027, theo thông tin <a href="https://vnexpress.net/sun-group-mo-ban-nha-xa-hoi-cho-cu-dan-tai-dinh-cu-5141512.html" target="_blank" rel="noopener">VnExpress</a> và nhiều báo đã đưa tin.</p>
<!--hh-featured-->
<h2>Nhà ở xã hội Sun Home Sơn Trà: thông tin đợt mở bán</h2>
<table>
<thead><tr><th>Nội dung</th><th>Thông tin theo báo chí</th></tr></thead>
<tbody>
<tr><td>Dự án</td><td>Nhà ở xã hội Khu dân cư An Hòa (Sun Home), đường Vân Đồn, phường Sơn Trà</td></tr>
<tr><td>Số căn đợt này</td><td>104 căn thuộc tòa SH2, diện tích khoảng 30 – 62 m²</td></tr>
<tr><td>Giá bán</td><td>Khoảng 6,38 triệu đồng/m², chưa gồm hệ số tầng và kinh phí bảo trì</td></tr>
<tr><td>Đối tượng</td><td>Cá nhân, hộ gia đình thuộc diện giải tỏa, di dời ở 3 chung cư xuống cấp: Thuận Phước, Lâm đặc sản Hòa Cường, Hòa Minh</td></tr>
<tr><td>Nhận hồ sơ</td><td>2/12/2026 – 5/1/2027; sáng 8h30 – 11h30, chiều 13h30 – 16h30, thứ Hai đến sáng thứ Bảy</td></tr>
<tr><td>Nơi nộp</td><td>Văn phòng Ban Quản lý dự án trên đường Trần Thánh Tông, phường Sơn Trà</td></tr>
</tbody>
</table>
<p>Với nhà ở xã hội Sun Home Sơn Trà, một số báo lưu ý mức 6,38 triệu đồng/m² là giá chủ đầu tư đưa ra; giá chính thức do Sở Xây dựng công bố sau khi thẩm định hồ sơ giá bán, cho thuê. Người đăng ký nên hỏi lại giá cuối cùng và hệ số tầng trước khi ký.</p>
<h2>Vì sao giá nhà ở xã hội Sun Home Sơn Trà thấp như vậy?</h2>
<p>Mức khoảng 6,38 triệu đồng/m² của nhà ở xã hội Sun Home Sơn Trà thấp hơn nhiều so với các dự án nhà ở xã hội mới ở Đà Nẵng (thường khoảng 16 – 21 triệu đồng/m²). Theo báo chí, chủ đầu tư giữ đơn giá dự kiến từ nhiều năm trước, và đợt này phục vụ riêng người dân phải di dời khỏi các chung cư cũ xuống cấp thuộc tài sản công. Trước đợt mở bán nhà ở xã hội Sun Home Sơn Trà này, Sở Xây dựng đã đồng ý cho đưa vào kinh doanh 347 căn nhà ở xã hội tại dự án, gồm 221 căn để bán và 126 căn cho thuê.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Bờ Đông sông Hàn, khu vực có nhà ở xã hội Sun Home Sơn Trà (ảnh flycam thực tế 11/2026)-->
<h2>Tác động của nhà ở xã hội Sun Home Sơn Trà – nhận định của Hoàng Hiệp</h2>
<p>Đợt mở bán nhà ở xã hội Sun Home Sơn Trà không dành cho người mua thông thường, nên không tạo thêm nguồn cung cho thị trường chung. Ý nghĩa lớn hơn nằm ở việc thành phố đang giải quyết dần các chung cư cũ xuống cấp: khi cư dân Thuận Phước, Hòa Minh, Hòa Cường được bố trí chỗ ở mới, quỹ đất các chung cư cũ có cơ hội được cải tạo, chỉnh trang.</p>
<p>Với khách đang tìm nhà ở xã hội ở Đà Nẵng, Hiệp khuyên theo dõi các dự án mở bán rộng rãi như <a href="/nha-o-xa-hoi-cau-tien-son-731-can/">nhà ở xã hội cầu Tiên Sơn 731 căn</a> hoặc danh sách <a href="/khoi-cong-8-du-an-nha-o-xa-hoi-da-nang-2026/">8 dự án nhà ở xã hội sắp khởi công</a>, thay vì đợt nhà ở xã hội Sun Home Sơn Trà dành riêng cho hộ di dời. Nếu nhà anh chị thuộc diện giải tỏa ở 3 chung cư trên, nên chuẩn bị giấy tờ chứng minh diện di dời và nộp trong khung giờ quy định, tránh dồn vào những ngày cuối.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> – căn hộ Sun Group ở bờ Đông sông Hàn, cùng phường với nhà ở xã hội Sun Home Sơn Trà; việc chỉnh trang chung cư cũ quanh khu vực giúp cảnh quan bờ Đông đồng bộ hơn.</li>
<li><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> – dự án Sun Group ven sông Hàn gần khu Sun Home, hưởng lợi khi khu dân cư An Hòa hoàn thiện hạ tầng.</li>
<li><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a> – căn hộ Sun Group ven sông Hàn, cùng nhóm dự án đô thị bờ sông của chủ đầu tư.</li>
</ul>
<p>Cần tư vấn chọn căn hộ ven sông Hàn của Sun Group hoặc thông tin các đợt mở bán nhà ở xã hội Đà Nẵng, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: VnExpress (Sun Group mở bán nhà xã hội cho cư dân tái định cư); CafeF, Người Quan Sát, Tiền Phong (104 căn tòa SH2, giá khoảng 6,38 triệu đồng/m², thời gian nhận hồ sơ); CafeLand (Sở Xây dựng đồng ý đưa 347 căn vào kinh doanh). Giá và thủ tục theo thông báo chính thức của chủ đầu tư và Sở Xây dựng.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Nhà ở xã hội Sun Home Sơn Trà: 104 căn, nhận hồ sơ từ 2/12',
			'desc'      => 'Nhà ở xã hội Sun Home Sơn Trà mở nhận hồ sơ 104 căn tòa SH2 từ 2/12/2026 đến 5/1/2027, giá khoảng 6,38 triệu/m², dành cho hộ di dời 3 chung cư cũ.',
			'points'    => array(
				'Nhà ở xã hội Sun Home Sơn Trà mở bán 104 căn tòa SH2, diện tích khoảng 30 – 62 m²',
				'Giá khoảng 6,38 triệu đồng/m², chưa gồm hệ số tầng và kinh phí bảo trì',
				'Chỉ dành cho hộ giải tỏa chung cư Thuận Phước, Lâm đặc sản Hòa Cường, Hòa Minh',
				'Nhận hồ sơ từ 2/12/2026 đến hết 5/1/2027 tại Ban Quản lý dự án đường Trần Thánh Tông',
			),
			'faq'       => array(
				array( 'Nhà ở xã hội Sun Home Sơn Trà ở đâu?', 'Tại Khu dân cư An Hòa trên đường Vân Đồn, phường Sơn Trà, Đà Nẵng, do Sun Group làm chủ đầu tư.' ),
				array( 'Ai được mua đợt này?', 'Cá nhân, hộ gia đình thuộc diện giải tỏa, di dời ở 3 chung cư xuống cấp: Thuận Phước, Lâm đặc sản Hòa Cường và Hòa Minh.' ),
				array( 'Giá bán bao nhiêu?', 'Khoảng 6,38 triệu đồng/m², chưa gồm hệ số tầng và kinh phí bảo trì; giá chính thức theo công bố của Sở Xây dựng.' ),
				array( 'Nộp hồ sơ khi nào, ở đâu?', 'Từ 2/12/2026 đến hết 5/1/2027, thứ Hai đến sáng thứ Bảy, tại Văn phòng Ban Quản lý dự án trên đường Trần Thánh Tông, phường Sơn Trà.' ),
			),
		),
		'sources'        => array(
			'https://vnexpress.net/sun-group-mo-ban-nha-xa-hoi-cho-cu-dan-tai-dinh-cu-5141512.html',
			'https://cafef.vn/sun-group-chuan-bi-mo-ban-hang-tram-can-nha-o-xa-hoi-tai-thanh-pho-dang-song-bac-nhat-viet-nam-18826110621443424.chn',
			'https://tienphong.vn/ai-se-duoc-mua-nha-o-xa-hoi-tai-da-nang-sap-mo-ban-post1892042.tpo',
			'https://cafeland.vn/tin-tuc/gan-350-can-nha-o-xa-hoi-cua-sun-group-tai-da-nang-du-dieu-kien-ban-cho-thue-154227.html',
		),
	);

	/* ---------------- 25/11 – Đề án du lịch sinh thái Cù Lao Chàm: 18 điểm, 509,75 ha ---------------- */
	$posts[] = array(
		'slug'           => 'de-an-du-lich-cu-lao-cham-18-diem',
		'title'          => 'Đề án du lịch Cù Lao Chàm được duyệt: 18 điểm sinh thái 509,75 ha, mục tiêu 350.000 khách năm 2030',
		'excerpt'        => 'UBND TP Đà Nẵng phê duyệt đề án du lịch sinh thái, nghỉ dưỡng, giải trí tại Khu bảo tồn thiên nhiên Cù Lao Chàm đến 2030, tầm nhìn 2050: 18 điểm du lịch trên 509,75 ha, 12 tuyến dài 39,8 km, kinh phí định hướng 346,5 tỷ đồng.',
		'keyword'        => 'đề án du lịch Cù Lao Chàm',
		'keywords_extra' => array( 'du lịch sinh thái Cù Lao Chàm', 'Cù Lao Chàm 18 điểm du lịch', 'Quyết định 5356/QĐ-UBND', 'bất động sản Hội An' ),
		'project'        => 'casamia-balanca-hoi-an',
		'schedule'       => '2026-11-25 06:30',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hội An', 'Du lịch', 'Quy hoạch' ),
		'image'          => 'plugin:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg',
		'image_alt'      => 'Đề án du lịch Cù Lao Chàm – cửa biển Cửa Đại, Hội An nhìn từ trên cao (ảnh flycam thực tế)',
		'content'        => <<<'HTML'
<p><strong>Đề án du lịch Cù Lao Chàm</strong> vừa được UBND TP Đà Nẵng phê duyệt tại Quyết định số 5356/QĐ-UBND: đề án phát triển du lịch sinh thái, nghỉ dưỡng, giải trí trong Khu bảo tồn thiên nhiên Cù Lao Chàm đến năm 2030, tầm nhìn đến năm 2050. Theo <a href="https://tuoitre.vn/phat-trien-du-lich-o-dao-cu-lao-cham-voi-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-100261124101532942.htm" target="_blank" rel="noopener">Tuổi Trẻ</a> và <a href="https://baodanang.vn/cu-lao-cham-dat-muc-tieu-don-350-000-luot-khach-nam-2030-3359411.html" target="_blank" rel="noopener">Báo Đà Nẵng</a> đưa tin ngày 24/11/2026, đảo sẽ có 18 điểm du lịch với tổng diện tích 509,75 ha.</p>
<!--hh-featured-->
<h2>Đề án du lịch Cù Lao Chàm: các con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo đề án được duyệt</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định số 5356/QĐ-UBND của UBND TP Đà Nẵng</td></tr>
<tr><td>Thời hạn</td><td>Đến năm 2030, tầm nhìn đến năm 2050</td></tr>
<tr><td>Số điểm du lịch</td><td>18 điểm, tổng diện tích 509,75 ha</td></tr>
<tr><td>Hợp phần rừng</td><td>12 điểm trải nghiệm sinh thái, hơn 257 ha</td></tr>
<tr><td>Hợp phần biển</td><td>6 điểm</td></tr>
<tr><td>Tuyến du lịch</td><td>12 tuyến sinh thái, dài khoảng 39,8 km, tận dụng đường tuần tra và đường mòn có sẵn</td></tr>
<tr><td>Mục tiêu khách</td><td>Khoảng 350.000 lượt khách mỗi năm vào năm 2030</td></tr>
<tr><td>Kinh phí định hướng</td><td>Khoảng 346,5 tỷ đồng đến năm 2030</td></tr>
</tbody>
</table>
<p>Điểm đáng chú ý của đề án du lịch Cù Lao Chàm là cách chia hai hợp phần rừng và biển có quan hệ chặt chẽ về sinh thái. Các tuyến đi bộ, quan sát rừng, lặn ngắm san hô được nối với nhau bằng hệ thống đường mòn sẵn có, hạn chế mở đường mới trên đảo.</p>
<h2>Bảo tồn đi trước: những gì không được làm</h2>
<p>Cù Lao Chàm là khu dự trữ sinh quyển thế giới, nên đề án du lịch Cù Lao Chàm đặt nhiều giới hạn. Theo các báo, trong phân khu bảo vệ nghiêm ngặt sẽ không bố trí điểm du lịch, không có hoạt động nghỉ dưỡng, giải trí và không cho thuê môi trường rừng. Ở phân khu phục hồi sinh thái, công trình xây dựng không được vượt quá 2% diện tích, theo <a href="https://baophapluat.vn/quy-hoach-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-o-cu-lao-cham.html" target="_blank" rel="noopener">Báo Pháp luật Việt Nam</a>.</p>
<p>Nói cách khác, đề án du lịch Cù Lao Chàm không mở đường cho resort lớn trên đảo. Nó tổ chức lại du lịch theo hướng có kiểm soát: khách đến trải nghiệm rồi phần lớn quay về đất liền lưu trú. Đây chính là chỗ đề án chạm tới thị trường bất động sản ven biển Hội An – Điện Bàn.</p>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Cửa Đại – điểm xuất phát ra đảo, nơi đề án du lịch Cù Lao Chàm kéo thêm khách lưu trú (ảnh flycam thực tế)-->
<h2>Tác động của đề án du lịch Cù Lao Chàm – nhận định của Hoàng Hiệp</h2>
<p>Thứ nhất, theo đề án du lịch Cù Lao Chàm, khách tăng nhưng chỗ ngủ trên đảo bị giới hạn. Với mục tiêu khoảng 350.000 lượt khách mỗi năm và quy định chặt về xây dựng, nhu cầu lưu trú sẽ dồn về bờ: phố cổ Hội An, Cửa Đại, ven biển Điện Bàn – Duy Xuyên. Khu vực này hưởng lợi rõ nhất là các sản phẩm cho thuê ngắn ngày và biệt thự nghỉ dưỡng gần bến tàu.</p>
<p>Thứ hai, chất lượng khách thay đổi. Du lịch sinh thái có kiểm soát thường hút nhóm khách chi tiêu cao hơn, ở lâu hơn và thích không gian yên tĩnh. Hiệp thấy đây là nhóm khách hợp với mô hình biệt thự compound có hồ bơi, vườn riêng hơn là khách sạn nhiều tầng.</p>
<p>Thứ ba, đừng kỳ vọng tác động tức thì. Kinh phí định hướng của đề án du lịch Cù Lao Chàm khoảng 346,5 tỷ đồng, chia đến năm 2030, nên các tuyến, điểm sẽ hoàn thiện dần. Người mua bất động sản nghỉ dưỡng quanh Hội An nên xem đề án du lịch Cù Lao Chàm là một lực đỡ trung hạn cho nhu cầu thuê, đi cùng các hạ tầng khác như <a href="/duong-ven-bien-vo-chi-cong-hoi-an/">tuyến ven biển Võ Chí Công</a>, chứ không phải lý do để mua vội.</p>
<p>Ai muốn hiểu thêm nhịp sống của khách du lịch ở Hội An, từ phố đèn lồng đến những đêm rằm bên sông, có thể đọc thêm cẩm nang <a href="https://danangstay.com.vn/vi/hoi-an-khi-dem-xuong-den-long-tiem-may-va-dong-song-dem-ram-vi/" target="_blank" rel="noopener">Hội An khi đêm xuống</a> – đó cũng là bức tranh nhu cầu lưu trú mà người cho thuê ở khu vực này đang phục vụ.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca Hội An</a> – khu biệt thự compound ven sông ở Hội An, gần tuyến ra Cửa Đại; nhóm khách sinh thái ở lâu từ đề án du lịch Cù Lao Chàm là tệp thuê phù hợp với biệt thự có vườn, hồ bơi.</li>
<li><a href="/du-an/casamia-calm-hoi-an/">Casamia Calm Hội An</a> – dự án biệt thự cùng khu vực, hưởng lợi khi lượng khách lưu trú quanh Hội An tăng theo lộ trình đến 2030.</li>
</ul>
<!--hh-img:img/casamia-balanca/casamia-balanca-flycam-toan-canh-thi-cong.jpg|Casamia Balanca Hội An – dự án biệt thự hưởng lợi từ đề án du lịch Cù Lao Chàm (ảnh flycam thi công)-->
<p>Bức tranh chung của khu vực sau hợp nhất, Hiệp đã tổng hợp trong bài <a href="/bat-dong-san-hoi-an-2026-sau-hop-nhat/">bất động sản Hội An 2026 sau hợp nhất</a>. Cần tư vấn biệt thự nghỉ dưỡng quanh Hội An hoặc phương án cho thuê, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Tuổi Trẻ, Dân Trí (18 điểm du lịch sinh thái, nghỉ dưỡng, giải trí ở Cù Lao Chàm); Báo Đà Nẵng, Báo Xây dựng (mục tiêu 350.000 lượt khách năm 2030, 12 tuyến 39,8 km); Báo Pháp luật Việt Nam (giới hạn xây dựng theo phân khu). Số liệu theo Quyết định 5356/QĐ-UBND như báo chí đưa tin; chi tiết theo văn bản chính thức của UBND TP Đà Nẵng.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Đề án du lịch Cù Lao Chàm: 18 điểm sinh thái, 509,75 ha',
			'desc'      => 'Đề án du lịch Cù Lao Chàm được duyệt: 18 điểm sinh thái trên 509,75 ha, 12 tuyến 39,8 km, mục tiêu 350.000 khách năm 2030. Tác động tới BĐS Hội An.',
			'points'    => array(
				'Đề án du lịch Cù Lao Chàm duyệt theo Quyết định 5356/QĐ-UBND, đến 2030, tầm nhìn 2050',
				'18 điểm du lịch trên 509,75 ha: 12 điểm rừng hơn 257 ha và 6 điểm biển',
				'12 tuyến du lịch sinh thái dài khoảng 39,8 km, tận dụng đường mòn có sẵn',
				'Mục tiêu khoảng 350.000 lượt khách mỗi năm vào 2030, kinh phí định hướng 346,5 tỷ đồng',
				'Không làm du lịch trong phân khu bảo vệ nghiêm ngặt – nhu cầu lưu trú dồn về bờ Hội An',
			),
			'faq'       => array(
				array( 'Đề án du lịch Cù Lao Chàm được duyệt khi nào?', 'Theo báo chí đưa tin ngày 24/11/2026, UBND TP Đà Nẵng đã phê duyệt tại Quyết định số 5356/QĐ-UBND, thời hạn đến 2030, tầm nhìn đến 2050.' ),
				array( 'Đề án có bao nhiêu điểm du lịch?', '18 điểm với tổng diện tích 509,75 ha, gồm 12 điểm trải nghiệm sinh thái ở rừng (hơn 257 ha) và 6 điểm ở biển, nối bằng 12 tuyến dài khoảng 39,8 km.' ),
				array( 'Có được xây resort trên đảo không?', 'Đề án đặt giới hạn chặt: không làm du lịch, nghỉ dưỡng trong phân khu bảo vệ nghiêm ngặt; công trình ở phân khu phục hồi sinh thái không quá 2% diện tích.' ),
				array( 'Đề án ảnh hưởng thế nào tới bất động sản Hội An?', 'Lượng khách tăng nhưng chỗ ở trên đảo bị giới hạn, nên nhu cầu lưu trú dồn về bờ Hội An, Cửa Đại – có lợi cho biệt thự nghỉ dưỡng, căn hộ cho thuê trong trung hạn.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/phat-trien-du-lich-o-dao-cu-lao-cham-voi-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-100261124101532942.htm',
			'https://dantri.com.vn/du-lich/da-nang-quy-hoach-18-diem-du-lich-sinh-thai-tai-hon-ngoc-xanh-cu-lao-cham-20261124110014462.htm',
			'https://baodanang.vn/cu-lao-cham-dat-muc-tieu-don-350-000-luot-khach-nam-2030-3359411.html',
			'https://baoxaydung.vn/da-nang-cu-lao-cham-dat-muc-tieu-350000-khach-nam-2030-siet-xay-dung-giu-he-sinh-thai-192261124071326371.htm',
			'https://baophapluat.vn/quy-hoach-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-o-cu-lao-cham.html',
		),
	);

	/* ---------------- 26/11 – KCN Tam Anh 3 – Indusvalley 238,11 ha, gần 2.479 tỷ (Chu Lai) ---------------- */
	$posts[] = array(
		'slug'           => 'khu-cong-nghiep-tam-anh-3-indusvalley',
		'title'          => 'Khu công nghiệp Tam Anh 3 – Indusvalley được chấp thuận: 238,11 ha, vốn khoảng 2.479 tỷ đồng ở phía nam Đà Nẵng',
		'excerpt'        => 'Ngày 25/11/2026, Ban Quản lý Khu kinh tế mở Chu Lai chấp thuận chủ trương đầu tư Khu công nghiệp Tam Anh 3 – Indusvalley (giai đoạn 1) tại xã Tam Anh: 238,11 ha, tổng vốn khoảng 2.479 tỷ đồng, thời hạn 70 năm.',
		'keyword'        => 'khu công nghiệp Tam Anh 3',
		'keywords_extra' => array( 'Indusvalley Chu Lai', 'khu kinh tế mở Chu Lai', 'bất động sản phía nam Đà Nẵng', 'Quyết định 259/QĐ-KTM' ),
		'project'        => 'vinh-an-hoa-city',
		'schedule'       => '2026-11-26 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Chu Lai', 'Khu công nghiệp' ),
		'image'          => 'plugin:img/vinh-an-hoa/nam-hoi-an-city-phoi-canh-tren-cao.jpg',
		'image_alt'      => 'Khu công nghiệp Tam Anh 3 – hành lang ven biển phía nam Đà Nẵng, nơi khu kinh tế mở Chu Lai mở rộng',
		'content'        => <<<'HTML'
<p><strong>Khu công nghiệp Tam Anh 3</strong> – Indusvalley (giai đoạn 1) vừa được Ban Quản lý Khu kinh tế mở Chu Lai chấp thuận chủ trương đầu tư tại Quyết định số 259/QĐ-KTM ngày 25/11/2026. Theo <a href="https://tuoitre.vn/phia-nam-da-nang-co-them-du-an-hon-2400-ti-dong-100261125153218841.htm" target="_blank" rel="noopener">Tuổi Trẻ</a> và <a href="https://cafef.vn/da-nang-chap-thuan-dau-tu-khu-cong-nghiep-tam-anh-3-indusvalley-hon-2479-ty-dong-188261125140401904.chn" target="_blank" rel="noopener">CafeF</a>, dự án rộng 238,11 ha tại xã Tam Anh, TP Đà Nẵng (vùng Quảng Nam cũ), tổng vốn khoảng 2.479 tỷ đồng.</p>
<!--hh-featured-->
<h2>Khu công nghiệp Tam Anh 3: các con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo quyết định được báo chí đưa tin</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định số 259/QĐ-KTM ngày 25/11/2026 của Ban Quản lý Khu kinh tế mở Chu Lai</td></tr>
<tr><td>Dự án</td><td>Đầu tư xây dựng và kinh doanh hạ tầng Khu công nghiệp Tam Anh 3 – Indusvalley, giai đoạn 1</td></tr>
<tr><td>Chủ đầu tư</td><td>Công ty cổ phần Indusvalley Chu Lai</td></tr>
<tr><td>Vị trí</td><td>Xã Tam Anh, TP Đà Nẵng (thuộc Khu kinh tế mở Chu Lai)</td></tr>
<tr><td>Quy mô</td><td>238,11 ha</td></tr>
<tr><td>Tổng vốn</td><td>Khoảng 2.479 tỷ đồng: vốn góp 495,8 tỷ (20%), vốn huy động 1.983,2 tỷ (80%)</td></tr>
<tr><td>Thời hạn</td><td>70 năm</td></tr>
<tr><td>Tiến độ</td><td>48 tháng kể từ ngày được Nhà nước giao đất, cho thuê đất</td></tr>
</tbody>
</table>
<p>Theo báo chí, trong phạm vi khu đất của khu công nghiệp Tam Anh 3 chưa có kết quả thăm dò, đánh giá trữ lượng khoáng sản, nên nhà đầu tư phải tự điều tra, đánh giá trước khi triển khai. Các bước tiếp theo vẫn là giải phóng mặt bằng, giao đất rồi mới xây hạ tầng – tức là từ quyết định đến lúc có nhà máy còn khá lâu.</p>
<h2>Vì sao khu công nghiệp Tam Anh 3 đáng chú ý với bất động sản?</h2>
<p>Tam Anh nằm trong vùng Núi Thành – Chu Lai, phía nam thành phố sau hợp nhất, gần sân bay Chu Lai và cảng Kỳ Hà. Khu vực này đã có nhiều khu công nghiệp và đang được thành phố đẩy mạnh với các khu đô thị mới. Đầu tháng 11, Hiệp đã tổng hợp việc <a href="/khoi-cong-3-khu-do-thi-chu-lai-40400-ty/">3 khu đô thị ở Chu Lai hơn 40.400 tỷ được ấn định thời hạn khởi công</a>; nay thêm khu công nghiệp Tam Anh 3 là thêm một nguồn việc làm cho chính vùng này.</p>
<p>Khu công nghiệp kéo theo nhu cầu nhà ở cho công nhân, chuyên gia, nhà trọ, nhà phố thương mại và dịch vụ quanh khu. Tuy nhiên, nhu cầu này chỉ thật sự hình thành khi khu công nghiệp có nhà máy đi vào hoạt động – với tiến độ 48 tháng kể từ khi giao đất, mốc đó còn vài năm nữa.</p>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Hành lang ven biển phía nam Đà Nẵng – vùng khu công nghiệp Tam Anh 3 và các khu đô thị Chu Lai đang mở rộng (ảnh flycam thực tế)-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<p>Thứ nhất, đây là tin tốt dài hạn cho cực phía nam, không phải lý do để mua đất vội. Kinh nghiệm ở các khu công nghiệp khác cho thấy giá đất quanh khu thường "chạy trước" khi có quyết định, rồi đi ngang nhiều năm chờ nhà máy. Hiệp khuyên ai quan tâm vùng Núi Thành – Tam Anh nên chọn sản phẩm có pháp lý rõ, hạ tầng đã xong, và tính dòng tiền cho thuê thực tế thay vì kỳ vọng tăng giá nhanh.</p>
<p>Thứ hai, khu công nghiệp Tam Anh 3 cùng các khu đô thị Chu Lai làm rõ hướng phát triển "đa cực" của Đà Nẵng sau hợp nhất: trung tâm cũ giữ vai trò dịch vụ – du lịch, phía nam là công nghiệp, cảng và sân bay. Người mua để ở hoặc cho thuê tại trung tâm vẫn nên ưu tiên vị trí gần biển, gần việc làm dịch vụ; còn nhà đầu tư có vốn dài hơi có thể theo dõi phía nam theo từng mốc giao đất, khởi công.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> (Núi Thành, gần sân bay Chu Lai): dự án gần khu công nghiệp Tam Anh 3 nhất trên web, hưởng lợi khi việc làm và dân cư vùng Chu Lai tăng.</li>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>: nằm trên hành lang ven biển phía nam, cùng được hưởng khi trục Đà Nẵng – Chu Lai phát triển.</li>
<li>Khu vực Tam Kỳ cũng có thêm động lực việc làm; xem thông tin tham khảo tại trang <a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a> (trang thông tin dự án).</li>
</ul>
<p>Xem thêm: <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen/">hướng tuyến cao tốc nội thị Đà Nẵng – Chu Lai</a>. Cần tư vấn bất động sản phía nam Đà Nẵng hoặc so sánh với căn hộ ven biển trung tâm, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Tuổi Trẻ (Phía nam Đà Nẵng có thêm dự án hơn 2.400 tỉ đồng, 25/11/2026); CafeF (Đà Nẵng chấp thuận đầu tư Khu công nghiệp Tam Anh 3 – Indusvalley hơn 2.479 tỷ đồng). Số liệu theo Quyết định 259/QĐ-KTM như báo chí đưa tin; chi tiết theo văn bản chính thức của Ban Quản lý Khu kinh tế mở Chu Lai.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Khu công nghiệp Tam Anh 3: 238,11 ha, vốn 2.479 tỷ',
			'desc'      => 'Khu công nghiệp Tam Anh 3 – Indusvalley được chấp thuận ngày 25/11/2026: 238,11 ha tại xã Tam Anh, vốn khoảng 2.479 tỷ đồng. Tác động tới BĐS phía nam.',
			'points'    => array(
				'Khu công nghiệp Tam Anh 3 – Indusvalley (giai đoạn 1) chấp thuận theo Quyết định 259/QĐ-KTM ngày 25/11/2026',
				'Quy mô 238,11 ha tại xã Tam Anh, TP Đà Nẵng, thuộc Khu kinh tế mở Chu Lai',
				'Tổng vốn khoảng 2.479 tỷ đồng: 20% vốn góp, 80% vốn huy động; thời hạn 70 năm',
				'Tiến độ 48 tháng kể từ khi được giao đất – nhu cầu nhà ở quanh khu hình thành sau khi có nhà máy',
			),
			'faq'       => array(
				array( 'Khu công nghiệp Tam Anh 3 ở đâu?', 'Tại xã Tam Anh, TP Đà Nẵng (vùng Núi Thành, Quảng Nam cũ), thuộc Khu kinh tế mở Chu Lai, gần sân bay Chu Lai.' ),
				array( 'Ai làm chủ đầu tư, vốn bao nhiêu?', 'Công ty cổ phần Indusvalley Chu Lai; tổng vốn khoảng 2.479 tỷ đồng, gồm 495,8 tỷ vốn góp và 1.983,2 tỷ vốn huy động.' ),
				array( 'Bao giờ khu công nghiệp hoạt động?', 'Theo quyết định, tiến độ xây dựng và đưa vào hoạt động là 48 tháng kể từ ngày được Nhà nước giao đất, cho thuê đất.' ),
				array( 'Có nên mua đất quanh khu công nghiệp Tam Anh 3 ngay?', 'Nên thận trọng: nhu cầu nhà ở chỉ tăng thật khi nhà máy hoạt động. Ưu tiên sản phẩm pháp lý rõ, hạ tầng xong và tính dòng tiền cho thuê thực tế.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/phia-nam-da-nang-co-them-du-an-hon-2400-ti-dong-100261125153218841.htm',
			'https://cafef.vn/da-nang-chap-thuan-dau-tu-khu-cong-nghiep-tam-anh-3-indusvalley-hon-2479-ty-dong-188261125140401904.chn',
		),
	);

	/* ---------------- 27/11 – Khu tái định cư Thăng Phú (Dự án thành phần 15) phục vụ đường sắt tốc độ cao ---------------- */
	$posts[] = array(
		'slug'           => 'tai-dinh-cu-thang-phu-duong-sat-toc-do-cao',
		'title'          => 'Đà Nẵng duyệt khu tái định cư Thăng Phú hơn 121 tỷ, gần 10 ha cho đường sắt tốc độ cao Bắc – Nam',
		'excerpt'        => 'Ngày 25/11/2026, UBND TP Đà Nẵng phê duyệt Dự án thành phần 15 – khu tái định cư Thăng Phú gồm 2 khu Tú Trà và Mỹ Trà, tổng mức đầu tư hơn 121 tỷ đồng, gần 10 ha, thực hiện 2026 – 2029, phục vụ giải phóng mặt bằng đường sắt tốc độ cao Bắc – Nam.',
		'keyword'        => 'tái định cư Thăng Phú',
		'keywords_extra' => array( 'khu tái định cư Tú Trà Mỹ Trà', 'đường sắt tốc độ cao qua Đà Nẵng', 'dự án thành phần 15 đường sắt tốc độ cao', 'bất động sản Thăng Bình' ),
		'project'        => 'hoiana-resort-golf',
		'schedule'       => '2026-11-27 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Đường sắt tốc độ cao', 'Thăng Phú', 'Tái định cư' ),
		'image'          => 'plugin:img/meta-city-tam-ky/meta-city-tam-ky-phoi-canh-tong-the.jpg',
		'image_alt'      => 'Tái định cư Thăng Phú phục vụ đường sắt tốc độ cao – vùng Thăng Bình, Tam Kỳ cũ phía nam Đà Nẵng (ảnh minh hoạ phối cảnh khu đô thị lân cận)',
		'content'        => <<<HTML
<p>Thêm một khu <strong>tái định cư Thăng Phú</strong> được duyệt cho tuyến đường sắt tốc độ cao: ngày <strong>25/11/2026</strong>, UBND thành phố Đà Nẵng phê duyệt <strong>Dự án thành phần 15</strong> – khu tái định cư phục vụ dự án đường sắt tốc độ cao trên trục Bắc – Nam tại xã Thăng Phú, tổng mức đầu tư <strong>hơn 121 tỷ đồng</strong>, gồm 2 khu Tú Trà và Mỹ Trà với tổng diện tích gần 10 ha.</p>
<!--hh-featured-->
<h2>Tái định cư Thăng Phú: những con số chính</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo Báo Xây dựng (25/11/2026)</th></tr></thead>
<tbody>
<tr><td>Ngày phê duyệt</td><td>25/11/2026 – quyết định của UBND TP Đà Nẵng</td></tr>
<tr><td>Tên dự án</td><td>Dự án thành phần 15: Khu tái định cư phục vụ dự án đường sắt tốc độ cao trên trục Bắc – Nam trên địa bàn xã Thăng Phú</td></tr>
<tr><td>Gồm</td><td>2 khu tái định cư: Tú Trà và Mỹ Trà</td></tr>
<tr><td>Tổng diện tích sử dụng đất</td><td>Gần 10 ha</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 121 tỷ đồng</td></tr>
<tr><td>Thời gian thực hiện</td><td>2026 – 2029</td></tr>
<tr><td>Hạng mục</td><td>San nền, giao thông, thoát nước mưa, thu gom và xử lý nước thải, cấp nước, phòng cháy chữa cháy, cấp điện, điện chiếu sáng, cây xanh và hoàn trả hạ tầng hiện trạng</td></tr>
</tbody>
</table>
<p>Khu tái định cư Thăng Phú thuộc dự án bồi thường, hỗ trợ, tái định cư và di dời công trình hạ tầng kỹ thuật của tuyến đường sắt tốc độ cao đoạn qua Đà Nẵng. Xã Thăng Phú là một trong các xã mới hình thành từ vùng huyện Thăng Bình cũ sau khi Đà Nẵng và Quảng Nam hợp nhất. Thông tin chi tiết theo bài của <a href="https://baoxaydung.vn/them-khu-tai-dinh-cu-tram-ty-phuc-vu-du-an-duong-sat-toc-do-cao-qua-da-nang-192261125212515246.htm">Báo Xây dựng</a>.</p>
<h2>Tái định cư Thăng Phú nằm trong chuỗi 31 dự án thành phần</h2>
<p>Theo Báo Xây dựng, công tác giải phóng mặt bằng, tái định cư và di dời hạ tầng kỹ thuật cho đường sắt tốc độ cao đoạn qua Đà Nẵng được chia thành <strong>31 dự án thành phần</strong>: 2 dự án chính thực hiện bồi thường, hỗ trợ, tái định cư, giải phóng mặt bằng toàn tuyến và di dời hệ thống điện, nước, viễn thông, thủy lợi, giao thông ngầm; 29 dự án độc lập xây dựng <strong>20 khu tái định cư và 9 khu nghĩa trang</strong>.</p>
<p>Trước khu tái định cư Thăng Phú, thành phố đã duyệt 3 khu tái định cư hơn 392 tỷ đồng tại Duy Xuyên (xem <a href="/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty/">tái định cư Duy Xuyên</a>) và khu Hương Trà ở vùng Tam Kỳ cũ (xem <a href="/tai-dinh-cu-huong-tra-hoa-lien-tuy-loan/">tái định cư Hương Trà, Hòa Liên – Túy Loan</a>). Các khu được duyệt dần theo hướng tuyến từ Bắc vào Nam của thành phố.</p>
<h2>Đường sắt tốc độ cao Bắc – Nam đang ở bước nào?</h2>
<ul>
<li>Tuyến dài khoảng 1.541 km, sơ bộ tổng mức đầu tư khoảng 67,34 tỷ USD, gồm 23 ga hành khách và 5 ga hàng hóa.</li>
<li>Mốc khởi công được báo chí cập nhật liên tục: đầu tháng 11/2026 nêu mục tiêu tháng 12/2027; tiêu đề bài CafeF ngày 26/11/2026 ghi "dự kiến khởi công vào cuối năm 2028" – cần chờ văn bản chính thức.</li>
<li>Ga Đà Nẵng dự kiến đặt tại Hòa Sơn – xem <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son/">ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn</a>.</li>
</ul>
<!--hh-img:img/meta-city-tam-ky/meta-city-tam-ky-phoi-canh-tong-the.jpg|Phối cảnh khu đô thị Meta City ở Tây Bắc Tam Kỳ – cùng vùng phía nam thành phố với khu tái định cư Thăng Phú (phối cảnh chủ đầu tư, ảnh minh hoạ khu vực)-->
<h2>Hộ dân trong diện tái định cư Thăng Phú cần làm gì?</h2>
<p>Với các hộ có đất nằm trong hành lang tuyến, khu tái định cư Thăng Phú (Tú Trà, Mỹ Trà) là nơi dự kiến bố trí đất ở mới. Hộ dân nên theo dõi thông báo thu hồi đất, biên bản kiểm đếm và phương án bồi thường – hỗ trợ – tái định cư được UBND xã niêm yết; kiểm tra kỹ diện tích, loại đất, tài sản trên đất được ghi nhận; hỏi rõ vị trí lô, giá giao đất tái định cư và nghĩa vụ tài chính. Nếu chưa đồng ý số liệu, nên góp ý bằng văn bản trong thời gian niêm yết công khai.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Hướng tuyến qua Thăng Bình cũ đã rõ hơn:</strong> có quyết định đầu tư khu tái định cư Thăng Phú nghĩa là phạm vi thu hồi đất của tuyến qua khu vực này đã được xác định đủ để lập dự án.</li>
<li><strong>Đất trong hành lang tuyến cần kiểm tra trước khi xuống tiền:</strong> khách hỏi Hiệp về đất nền giá thấp ở Thăng Bình, Tam Kỳ cũ thì việc đầu tiên Hiệp làm là đề nghị hỏi UBND xã hoặc văn phòng đăng ký đất đai xem thửa đất có nằm trong phạm vi thu hồi của tuyến hay khu tái định cư Thăng Phú hay không.</li>
<li><strong>Lô tái định cư không phải hàng bán tự do:</strong> đất trong khu tái định cư Thăng Phú giao cho hộ bị thu hồi; gặp tin rao "suất tái định cư" cần xem quyết định giao đất và điều kiện chuyển nhượng.</li>
<li><strong>Tác động giá là dài hạn:</strong> 2 khu Tú Trà, Mỹ Trà làm xong hạ tầng trong giai đoạn 2026 – 2029; giá đất quanh tuyến chủ yếu thay đổi khi tuyến khởi công và quanh các nhà ga, không nên kỳ vọng tăng ngay.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a> – quần thể nghỉ dưỡng ven biển phía Nam Hội An, phía bắc vùng Thăng Bình cũ; kết nối đường sắt tốc độ cao trong dài hạn giúp rút ngắn thời gian đi từ các thành phố lớn.</li>
<li><a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a> – khu đô thị ở Tây Bắc Tam Kỳ cũ, giáp vùng Thăng Bình cũ; các khu tái định cư phục vụ tuyến làm khu vực phía nam thành phố có thêm hạ tầng dân cư (trang thông tin tham khảo).</li>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> – khu đô thị phía Nam gần Khu kinh tế mở Chu Lai, cùng hành lang hạ tầng Bắc – Nam của thành phố.</li>
</ul>
<p>Cần kiểm tra một thửa đất cụ thể ở Thăng Bình, Tam Kỳ cũ có nằm trong hành lang tuyến hay khu tái định cư Thăng Phú hay không, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Báo Xây dựng (25/11/2026) về quyết định phê duyệt Dự án thành phần 15 của UBND TP Đà Nẵng ngày 25/11/2026; Người Quan Sát (11/2026); thông tin tuyến đường sắt tốc độ cao theo CafeF (05/11 và 26/11/2026). Chưa đọc được toàn văn quyết định (báo chí không nêu số hiệu) – số liệu ghi theo báo chí.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Tái định cư Thăng Phú 121 tỷ cho đường sắt tốc độ cao',
			'desc'      => 'Đà Nẵng duyệt khu tái định cư Thăng Phú (Tú Trà, Mỹ Trà) gần 10 ha, hơn 121 tỷ đồng, thực hiện 2026 – 2029 phục vụ đường sắt tốc độ cao Bắc – Nam.',
			'points'    => array(
				'Tái định cư Thăng Phú: ngày 25/11/2026 UBND TP Đà Nẵng duyệt Dự án thành phần 15, hơn 121 tỷ đồng',
				'Gồm 2 khu Tú Trà và Mỹ Trà, tổng diện tích gần 10 ha, thực hiện 2026 – 2029',
				'Đoạn qua Đà Nẵng chia 31 dự án thành phần: 20 khu tái định cư, 9 khu nghĩa trang',
			),
			'faq'       => array(
				array( 'Khu tái định cư Thăng Phú gồm những khu nào?', 'Khu tái định cư Thăng Phú (Dự án thành phần 15) gồm 2 khu Tú Trà và Mỹ Trà tại xã Thăng Phú, TP Đà Nẵng, tổng diện tích sử dụng đất gần 10 ha.' ),
				array( 'Tổng vốn và thời gian làm khu tái định cư Thăng Phú?', 'Tổng mức đầu tư hơn 121 tỷ đồng, thực hiện từ năm 2026 đến 2029, theo quyết định UBND TP Đà Nẵng phê duyệt ngày 25/11/2026.' ),
				array( 'Ai được bố trí đất ở khu tái định cư Thăng Phú?', 'Khu tái định cư Thăng Phú dành cho các hộ có đất bị thu hồi để làm tuyến đường sắt tốc độ cao Bắc – Nam qua khu vực; lô đất được giao theo phương án bồi thường, hỗ trợ, tái định cư được duyệt, không phải hàng bán tự do.' ),
			),
		),
		'sources'        => array(
			'https://baoxaydung.vn/them-khu-tai-dinh-cu-tram-ty-phuc-vu-du-an-duong-sat-toc-do-cao-qua-da-nang-192261125212515246.htm',
			'https://nguoiquansat.vn/da-nang-chi-hon-121-ty-lam-hai-khu-tai-dinh-cu-10ha-phuc-vu-duong-sat-toc-do-cao-bac-nam-330188.html',
			'https://cafef.vn/sieu-du-an-duong-sat-toc-do-cao-350km-h-di-qua-15-tinh-thanh-von-dau-tu-67-ty-usd-du-kien-khoi-cong-vao-cuoi-nam-2028-co-dien-bien-moi-188261126144003271.chn',
		),
	);

	$posts[] = array(
		'slug'           => 'thi-tuyen-cau-moi-qua-song-han',
		'title'          => 'Đà Nẵng lấy ý kiến thi tuyển cầu mới qua sông Hàn: đoạn cầu sông Hàn – cầu Thuận Phước, tầm nhìn 2075',
		'excerpt'        => 'Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng đang lấy ý kiến dự thảo nhiệm vụ thi tuyển phương án quy hoạch – kiến trúc cầu mới qua sông Hàn, trong đoạn cầu sông Hàn – cầu Thuận Phước, quy mô đáp ứng giao thông đến 2050, tầm nhìn 2075.',
		'keyword'        => 'thi tuyển cầu mới qua sông Hàn',
		'keywords_extra' => array( 'cầu mới sông Hàn Thuận Phước', 'căn hộ ven sông Hàn Sơn Trà', 'trục Đông – Tây Đà Nẵng' ),
		'project'        => 'sun-symphony-residence',
		'schedule'       => '2026-11-28 06:45',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Sông Hàn', 'Cầu mới', 'Sơn Trà', 'Hải Châu' ),
		'image'          => 'plugin:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg',
		'image_alt'      => 'Thi tuyển cầu mới qua sông Hàn – cầu sông Hàn và trung tâm bờ Tây Đà Nẵng về đêm',
		'content'        => <<<HTML
<p>Đà Nẵng chuẩn bị <strong>thi tuyển cầu mới qua sông Hàn</strong>: Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên thành phố đang lấy ý kiến dự thảo nhiệm vụ thi tuyển phương án quy hoạch – kiến trúc khu vực cầu mới qua sông Hàn và hai đầu cầu (Tuổi Trẻ, 26/11/2026). Phạm vi nghiên cứu là đoạn sông giữa <strong>cầu sông Hàn</strong> và <strong>cầu Thuận Phước</strong>, quy mô cầu phải đáp ứng nhu cầu giao thông đến năm 2050, tầm nhìn đến năm 2075.</p>
<!--hh-featured-->
<p>Việc thi tuyển cầu mới qua sông Hàn mới ở bước <strong>lấy ý kiến dự thảo nhiệm vụ</strong>, chưa phải quyết định đầu tư: vị trí cụ thể, hướng tuyến, quy mô, tổng vốn và thời gian khởi công đều chưa công bố. Bài dưới đây tóm tắt những gì dự thảo yêu cầu, phạm vi hai bờ được nghiên cứu và nhận định của Hiệp về tác động tới căn hộ ven sông Hàn.</p>
<h2>Thi tuyển cầu mới qua sông Hàn: dự thảo nhiệm vụ yêu cầu gì?</h2>
<p>Theo dự thảo được Tuổi Trẻ đưa tin, mục tiêu của cuộc thi tuyển cầu mới qua sông Hàn là chọn <strong>vị trí, hướng tuyến vượt sông và điểm đấu nối tối ưu</strong> trong đoạn cầu sông Hàn – cầu Thuận Phước, hài hòa với các công trình vượt sông hiện hữu.</p>
<table>
<thead><tr><th>Nội dung</th><th>Theo dự thảo nhiệm vụ (Tuổi Trẻ, 26/11/2026)</th></tr></thead>
<tbody>
<tr><td>Đơn vị lấy ý kiến</td><td>Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng</td></tr>
<tr><td>Phạm vi nghiên cứu</td><td>Đoạn sông giữa cầu sông Hàn và cầu Thuận Phước, cùng không gian đô thị hai bờ</td></tr>
<tr><td>Quy mô</td><td>Đáp ứng nhu cầu giao thông đến năm 2050, tầm nhìn đến năm 2075</td></tr>
<tr><td>Chức năng</td><td>Phân lưu, giảm tải cho Lê Duẩn, Trần Phú, Bạch Đằng, Nguyễn Văn Linh, cầu sông Hàn, cầu Rồng; hoàn thiện trục Đông – Tây</td></tr>
<tr><td>Kết nối</td><td>Khu hành chính phía bắc Hải Châu với khu đô thị du lịch phía nam bán đảo Sơn Trà</td></tr>
<tr><td>Yêu cầu kèm theo</td><td>Bảo lưu, tích hợp điều kiện cho đường sắt đô thị theo quy hoạch; kết nối xe buýt và đường thủy du lịch trên sông Hàn</td></tr>
<tr><td>Kiến trúc</td><td>Công trình vĩnh cửu, độc bản, mang bản sắc Đà Nẵng; không cạnh tranh hay sao chép hình ảnh các cây cầu hiện hữu</td></tr>
<tr><td>Hình thức</td><td>Thi tuyển rộng rãi, không hạn chế tổ chức, cá nhân trong nước và nước ngoài</td></tr>
</tbody>
</table>
<p>Dự thảo thi tuyển cầu mới qua sông Hàn cũng yêu cầu tổ chức giao thông thông suốt ở hai đầu cầu, hạn chế tối đa điểm xung đột với dòng xe hiện hữu và phát sinh trong tương lai, bảo đảm năng lực thông hành lâu dài.</p>
<h2>Hai bờ sông được đưa vào phạm vi nghiên cứu</h2>
<p>Phạm vi thi tuyển cầu mới qua sông Hàn bao trùm hai hành lang tuyến định hướng ở cả hai bờ:</p>
<p><strong>Bờ Tây (phường Hải Châu):</strong> khu vực nút Đống Đa – 3 Tháng 2 – Như Nguyệt – Bạch Đằng – Trần Phú và các trục Đống Đa, 3 Tháng 2, Như Nguyệt, Bạch Đằng, Trần Phú, Lê Duẩn, Lương Ngọc Quyến.</p>
<p><strong>Bờ Đông (phường Sơn Trà):</strong> các trục Trần Hưng Đạo, Vân Đồn, Bùi Dương Lịch, Hoàng Việt, Nguyễn Thị Định, Đỗ Anh Hàn, Chu Huy Mân, Trần Thánh Tông, Ngô Quyền, Vương Thừa Vũ, đường số 1 KCN An Đồn và các tuyến nhánh liên quan.</p>
<p>Ngoài cây cầu, phương án dự thi tuyển cầu mới qua sông Hàn phải nghiên cứu cả không gian hai bờ, không gian dưới cầu và hai đầu cầu; tuyến đi bộ ven sông, công viên, quảng trường; trục nhìn, đường chân trời (skyline) khu trung tâm; quan hệ với chuỗi cầu hiện hữu và <strong>các khu nhà kho, bến bãi cũ ven sông có khả năng tái cấu trúc</strong>.</p>
<!--hh-img:img/peninsula/peninsula-da-nang-tien-do-10-2026-cua-so-nhin-cau-thuan-phuoc.jpg|Thi tuyển cầu mới qua sông Hàn trong đoạn tới cầu Thuận Phước – ảnh thật từ Peninsula Đà Nẵng nhìn cầu Thuận Phước, 10/2026-->
<h2>Vì sao Đà Nẵng cần cầu mới qua sông Hàn?</h2>
<p>Bờ Tây trung tâm Hải Châu đang gánh lượng xe lớn qua Lê Duẩn, Trần Phú, Bạch Đằng, Nguyễn Văn Linh rồi dồn lên cầu sông Hàn và cầu Rồng. Dự thảo định hướng cầu mới <strong>phân lưu, giảm tải</strong> cho các trục này và hoàn thiện mạng lưới trục Đông – Tây, nối khu hành chính phía bắc Hải Châu với khu đô thị du lịch phía nam bán đảo Sơn Trà.</p>
<p>Yêu cầu tích hợp điều kiện cho đường sắt đô thị trong thi tuyển cầu mới qua sông Hàn cho thấy cây cầu được tính để dùng lâu dài, gắn với mạng lưới giao thông công cộng theo quy hoạch. Xem thêm tiến độ <a href="/duong-sat-do-thi-da-nang-san-bay-my-khe-hoi-an/">đường sắt đô thị sân bay – Mỹ Khê – Hội An</a> và dự án <a href="/cai-tao-canh-quan-hai-bo-song-han-29-ha/">cải tạo cảnh quan hai bờ sông Hàn khoảng 29,22 ha</a>.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Sông Hàn và cầu Rồng nhìn từ trên cao, 11/2026 – cầu mới được định hướng giảm tải cho cầu Rồng, cầu sông Hàn-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Mới ở bước lấy ý kiến:</strong> nhiệm vụ thi tuyển cầu mới qua sông Hàn còn phải được duyệt, sau đó mới mời dự thi, chấm giải, rồi lập dự án đầu tư. Thời gian khởi công chưa có, nên đây là yếu tố dài hạn, không phải lý do để xuống tiền ngay.</li>
<li><strong>Bờ Đông Sơn Trà hưởng lợi rõ nhất:</strong> nếu cầu đấu nối vào trục Trần Hưng Đạo – Ngô Quyền trong đoạn tới cầu Thuận Phước, khu Nại Hiên Đông, An Hải Bắc cũ sẽ gần trung tâm hành chính bờ Tây hơn, ít phụ thuộc cầu Rồng, cầu sông Hàn.</li>
<li><strong>Quỹ đất kho bãi ven sông:</strong> dự thảo nhắc tới các khu nhà kho, bến bãi cũ có thể tái cấu trúc – đây là chi tiết đáng theo dõi vì liên quan trực tiếp tới quy hoạch sử dụng đất hai bờ.</li>
<li><strong>Căn hộ ven sông đã bàn giao có lợi thế:</strong> khi hạ tầng còn nhiều năm, căn đã có sổ hoặc đang bàn giao như ở Sun Symphony, Peninsula cho phép ở hoặc cho thuê ngay, phần lợi từ cây cầu đến sau là cộng thêm.</li>
</ul>
<p>Khách hỏi Hiệp căn nào gần vị trí cầu mới nhất, Hiệp chỉ trả lời được theo phạm vi nghiên cứu (đoạn cầu sông Hàn – cầu Thuận Phước), vì dự thảo chưa chốt điểm đấu nối. Ai mua chỉ vì "chân cầu" lúc này nên chờ kết quả thi tuyển cầu mới qua sông Hàn.</p>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> – khu căn hộ của Sun Group ven sông Hàn phía Sơn Trà, nằm trong đoạn bờ Đông được nghiên cứu; cầu mới giúp sang khu hành chính bờ Tây nhanh hơn.</li>
<li><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a> – tòa căn hộ trên đường Lê Văn Duyệt, Nại Hiên Đông cũ, nhìn ra cầu Thuận Phước; nằm sát đầu phía bắc của phạm vi nghiên cứu.</li>
<li><a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a> – chân cầu Rồng phía Sơn Trà; cầu mới được định hướng giảm tải cho cầu Rồng và trục Võ Văn Kiệt – Nguyễn Văn Linh.</li>
<li><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> – căn hộ Sun Group trên Trần Hưng Đạo; trục Trần Hưng Đạo là một trong các tuyến bờ Đông được đưa vào phạm vi nghiên cứu.</li>
</ul>
<p>Cần so sánh căn hộ ven sông Hàn theo khoảng cách tới phạm vi cầu mới, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://tuoitre.vn/da-nang-tinh-lam-cau-moi-qua-song-han-o-dau-100261126095124521.htm">Tuổi Trẻ (26/11/2026)</a> về dự thảo nhiệm vụ thi tuyển phương án quy hoạch – kiến trúc khu vực cầu mới qua sông Hàn của Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng. Dự thảo chưa được phê duyệt; vị trí, quy mô, vốn và tiến độ chưa công bố – bài ghi theo nội dung báo chí.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Thi tuyển cầu mới qua sông Hàn: tầm nhìn 2050 – 2075',
			'desc'      => 'Đà Nẵng lấy ý kiến thi tuyển cầu mới qua sông Hàn trong đoạn cầu sông Hàn – cầu Thuận Phước, giảm tải bờ Tây, tích hợp đường sắt đô thị.',
			'points'    => array(
				'Thi tuyển cầu mới qua sông Hàn: Ban QLDA hạ tầng ưu tiên Đà Nẵng đang lấy ý kiến dự thảo nhiệm vụ (26/11/2026)',
				'Phạm vi: đoạn cầu sông Hàn – cầu Thuận Phước, quy mô đáp ứng giao thông đến 2050, tầm nhìn 2075',
				'Phải tích hợp điều kiện cho đường sắt đô thị, kết nối đường thủy du lịch; thi rộng rãi trong và ngoài nước',
			),
			'faq'       => array(
				array( 'Thi tuyển cầu mới qua sông Hàn đang ở bước nào?', 'Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng đang lấy ý kiến dự thảo nhiệm vụ thi tuyển cầu mới qua sông Hàn (Tuổi Trẻ, 26/11/2026). Sau khi nhiệm vụ và quy chế được duyệt mới phát hành thông báo mời dự thi.' ),
				array( 'Cầu mới qua sông Hàn nằm ở đâu?', 'Dự thảo thi tuyển cầu mới qua sông Hàn giới hạn phạm vi trong đoạn sông giữa cầu sông Hàn và cầu Thuận Phước; vị trí, hướng tuyến và điểm đấu nối cụ thể sẽ được chọn qua cuộc thi.' ),
				array( 'Ai được tham gia thi tuyển cầu mới qua sông Hàn?', 'Theo ban quản lý dự án, cuộc thi tuyển cầu mới qua sông Hàn tổ chức rộng rãi, không hạn chế tổ chức, cá nhân trong nước và nước ngoài.' ),
				array( 'Cầu mới qua sông Hàn có tổng vốn và thời gian khởi công chưa?', 'Chưa. Dự thảo nhiệm vụ thi tuyển cầu mới qua sông Hàn mới nêu mục tiêu, phạm vi và yêu cầu kiến trúc; tổng mức đầu tư, nguồn vốn và tiến độ chưa được công bố.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/da-nang-tinh-lam-cau-moi-qua-song-han-o-dau-100261126095124521.htm',
		),
	);

	$posts[] = array(
		'slug'           => 'tai-khoi-dong-to-hop-dap-non-nuoc',
		'title'          => 'Tái khởi động Tổ hợp khu đô thị du lịch biển DAP tại Non Nước: khoảng 39 ha, khởi công chậm nhất quý II/2027',
		'excerpt'        => 'Sáng 28/11/2026, Tổ hợp dự án đô thị, du lịch biển DAP, DAP 1 và DAP 2 tại bãi biển Non Nước (phường Ngũ Hành Sơn) chính thức tái khởi động. Quy mô khoảng 39 ha, được áp dụng cơ chế đặc thù, phải đủ điều kiện khởi công chậm nhất quý II/2027.',
		'keyword'        => 'tổ hợp DAP Non Nước',
		'keywords_extra' => array( 'tái khởi động dự án DAP Đà Nẵng', 'khu đô thị du lịch biển Non Nước', 'bất động sản ven biển Ngũ Hành Sơn' ),
		'project'        => 'sun-saphia-residence',
		'schedule'       => '2026-11-28 12:30',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Non Nước', 'Ngũ Hành Sơn', 'Dự án ven biển', 'Cơ chế đặc thù' ),
		'image'          => 'plugin:img/dap-non-nuoc/dap-non-nuoc-phoi-canh-to-hop-khu-do-thi-du-lich-bien.jpg',
		'image_alt'      => 'Phối cảnh tổ hợp DAP Non Nước – khu đô thị du lịch biển tại phường Ngũ Hành Sơn, Đà Nẵng',
		'content'        => <<<HTML
<p>Sáng 28/11/2026, <strong>tổ hợp DAP Non Nước</strong> – tên đầy đủ là Tổ hợp dự án đô thị, du lịch biển DAP, DAP 1 và DAP 2 – chính thức tái khởi động tại bãi biển Non Nước (phường Ngũ Hành Sơn), theo Cổng Thông tin điện tử TP Đà Nẵng. Dự án do Công ty TNHH DAP, DAP 1 và DAP 2 làm chủ đầu tư, quy mô <strong>khoảng 39 ha</strong>, được thành phố yêu cầu đủ điều kiện khởi công <strong>chậm nhất trong quý II năm 2027</strong>.</p>
<!--hh-featured-->
<p>Đây là một trong những dự án ven biển lớn ở phía nam Đà Nẵng nằm im nhiều năm, nay được đưa vào danh mục áp dụng cơ chế đặc thù. Bài dưới đây tóm tắt những gì đã công bố về tổ hợp DAP Non Nước, những gì chưa có và nhận định của Hiệp về tác động tới bất động sản ven biển Ngũ Hành Sơn.</p>
<h2>Tổ hợp DAP Non Nước: những gì đã công bố</h2>
<table>
<thead><tr><th>Nội dung</th><th>Theo Cổng TTĐT TP Đà Nẵng (28/11/2026)</th></tr></thead>
<tbody>
<tr><td>Tên dự án</td><td>Tổ hợp dự án đô thị, du lịch biển DAP, DAP 1 và DAP 2</td></tr>
<tr><td>Vị trí</td><td>Bãi biển Non Nước, phường Ngũ Hành Sơn</td></tr>
<tr><td>Chủ đầu tư</td><td>Công ty TNHH DAP, DAP 1 và DAP 2</td></tr>
<tr><td>Quy mô</td><td>Khoảng 39 ha</td></tr>
<tr><td>Định hướng</td><td>"Đô thị du lịch đa năng" cao cấp: khách sạn và căn hộ, khu biệt thự biệt lập, trung tâm hội nghị quốc tế, chuỗi nhà hàng, chăm sóc sức khỏe chuyên sâu</td></tr>
<tr><td>Cơ chế</td><td>Được bổ sung vào danh mục áp dụng cơ chế đặc thù theo Nghị quyết số 29/2026/QH16 của Quốc hội và Nghị định số 147/2026/NĐ-CP của Chính phủ</td></tr>
<tr><td>Mốc tiến độ</td><td>Đáp ứng đầy đủ điều kiện khởi công chậm nhất trong quý II năm 2027</td></tr>
</tbody>
</table>
<p>Theo bài viết, tâm điểm của tổ hợp DAP Non Nước là các tòa khách sạn và căn hộ được giới thiệu ở "đẳng cấp 7 sao", tầm nhìn bao trọn vịnh Đà Nẵng. Tổng vốn đầu tư, số căn hộ, số biệt thự, số tòa và số tầng <strong>chưa được công bố</strong>.</p>
<!--hh-img:img/dap-non-nuoc/dap-non-nuoc-le-tai-khoi-dong-28-11-2026.jpg|Đại biểu thực hiện nghi thức tái khởi động tổ hợp DAP Non Nước sáng 28/11/2026 (ảnh: Cổng TTĐT TP Đà Nẵng)-->
<h2>Lãnh đạo thành phố nói gì tại lễ tái khởi động?</h2>
<p>Dự lễ có ông Nguyễn Khắc Toàn, Ủy viên Trung ương Đảng, Phó Bí thư Thường trực Thành ủy; ông Nguyễn Mạnh Hùng, Phó Bí thư Thành ủy, Chủ tịch UBND thành phố; cùng lãnh đạo các sở, ngành, địa phương.</p>
<p>Phát biểu tại sự kiện, Phó Chủ tịch UBND thành phố Trần Nam Hưng cho biết thành phố sẽ tiếp tục đồng hành cùng các chủ đầu tư; đã bổ sung tổ hợp DAP vào danh mục áp dụng cơ chế đặc thù. Ông yêu cầu UBND phường Ngũ Hành Sơn và các sở, ngành phối hợp hướng dẫn thủ tục để dự án <strong>đáp ứng đầy đủ điều kiện khởi công chậm nhất trong quý II năm 2027</strong>.</p>
<!--hh-img:img/dap-non-nuoc/dap-non-nuoc-phoi-canh-to-hop-khu-do-thi-du-lich-bien.jpg|Phối cảnh tổ hợp DAP Non Nước bên bãi biển Non Nước: tháp khách sạn – căn hộ phía sau, biệt thự hồ bơi sát biển (ảnh: Cổng TTĐT TP Đà Nẵng)-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tái khởi động chưa phải khởi công:</strong> mốc chính thức là "đủ điều kiện khởi công chậm nhất quý II/2027". Từ nay đến đó còn thủ tục; sản phẩm, giá bán chưa có, nên chưa có gì để đặt chỗ hay "giữ suất" – khách nghe ai mời cọc tổ hợp DAP Non Nước lúc này cần hỏi kỹ văn bản.</li>
<li><strong>Tín hiệu tích cực cho dải biển Ngũ Hành Sơn:</strong> một khu đất ven biển lớn được đưa vào cơ chế đặc thù cho thấy thành phố muốn kéo các dự án "treo" ven biển phía nam chạy lại. Khi các tổ hợp du lịch cao cấp hình thành, nhu cầu lưu trú, dịch vụ và thuê nhà quanh Non Nước – Ngũ Hành Sơn có thêm động lực.</li>
<li><strong>Dòng hàng nghỉ dưỡng cao cấp sẽ dày hơn:</strong> người mua căn hộ, biệt thự ven biển nên so sánh tổ hợp DAP Non Nước (khi có thông tin bán) với các dự án đã có pháp lý, đã bàn giao hoặc có tiến độ rõ ở cùng trục biển.</li>
<li><strong>Theo dõi tiếp:</strong> quy hoạch chi tiết, tổng vốn, cơ cấu sản phẩm và pháp lý từng loại (căn hộ du lịch hay nhà ở) – Hiệp sẽ cập nhật khi có công bố chính thức.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> – căn hộ mặt biển của Sun Group tại phường Ngũ Hành Sơn (Võ Nguyên Giáp – Trường Sa); cùng dải biển phía nam, hưởng lợi khi khu Non Nước có thêm tổ hợp du lịch cao cấp.</li>
<li><a href="/du-an/the-ocean-suites-da-nang/">The Ocean Suites Đà Nẵng</a> – căn hộ trên đường Trường Sa, phường Ngũ Hành Sơn, thị trường thuê du lịch phụ thuộc trực tiếp sức hút của dải biển này.</li>
<li><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a> – khu căn hộ, nhà phố Sun Group ở Ngũ Hành Sơn, cùng khu vực phía nam thành phố.</li>
<li><a href="/du-an/ariyana-beach-resort-suites-da-nang/">Ariyana Beach Resort &amp; Suites</a> – căn hộ nghỉ dưỡng ven biển Ngũ Hành Sơn, để so sánh khi tổ hợp DAP mở bán.</li>
</ul>
<p>Cần so sánh căn hộ, biệt thự ven biển Ngũ Hành Sơn đang có pháp lý rõ, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: <a href="https://danang.gov.vn/vi/web/dng/w/tai-khoi-dong-to-hop-khu-do-thi-du-lich-bien-dap">Cổng Thông tin điện tử TP Đà Nẵng (28/11/2026)</a> – "Tái khởi động Tổ hợp Khu đô thị du lịch biển DAP". Ảnh lễ tái khởi động và phối cảnh theo cổng thông tin thành phố. Tổng vốn, cơ cấu sản phẩm và giá bán chưa công bố.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Tổ hợp DAP Non Nước tái khởi động: 39 ha, khởi công 2027',
			'desc'      => 'Tổ hợp DAP Non Nước (Ngũ Hành Sơn) tái khởi động 28/11/2026: khoảng 39 ha, cơ chế đặc thù, đủ điều kiện khởi công chậm nhất quý II/2027.',
			'points'    => array(
				'Tổ hợp DAP Non Nước (DAP, DAP 1, DAP 2) chính thức tái khởi động sáng 28/11/2026 tại bãi biển Non Nước, phường Ngũ Hành Sơn',
				'Quy mô khoảng 39 ha, chủ đầu tư Công ty TNHH DAP, DAP 1 và DAP 2; áp dụng cơ chế đặc thù theo Nghị quyết 29/2026/QH16',
				'Thành phố yêu cầu đủ điều kiện khởi công chậm nhất quý II/2027; tổng vốn, sản phẩm, giá bán chưa công bố',
			),
			'faq'       => array(
				array( 'Tổ hợp DAP Non Nước nằm ở đâu?', 'Tổ hợp DAP Non Nước nằm tại bãi biển Non Nước, phường Ngũ Hành Sơn, TP Đà Nẵng, quy mô khoảng 39 ha (Cổng TTĐT TP Đà Nẵng, 28/11/2026).' ),
				array( 'Ai là chủ đầu tư tổ hợp DAP Non Nước?', 'Chủ đầu tư là Công ty TNHH DAP, DAP 1 và DAP 2, theo Cổng Thông tin điện tử TP Đà Nẵng.' ),
				array( 'Khi nào tổ hợp DAP Non Nước khởi công?', 'Phó Chủ tịch UBND thành phố Trần Nam Hưng yêu cầu dự án đáp ứng đầy đủ điều kiện khởi công chậm nhất trong quý II năm 2027.' ),
				array( 'Tổ hợp DAP Non Nước đã mở bán chưa?', 'Chưa. Tổng vốn, cơ cấu sản phẩm, giá bán và pháp lý từng loại sản phẩm của tổ hợp DAP Non Nước chưa được công bố.' ),
			),
		),
		'sources'        => array(
			'https://danang.gov.vn/vi/web/dng/w/tai-khoi-dong-to-hop-khu-do-thi-du-lich-bien-dap',
		),
	);

	return $posts;
}
