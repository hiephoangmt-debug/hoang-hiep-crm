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
	/* ---------------- 06/11 – Quy hoạch chung đô thị Thăng Điền đến 2050 ---------------- */
	$posts[] = array(
		'slug'           => 'quy-hoach-chung-do-thi-thang-dien-den-2050',
		'title'          => 'Đà Nẵng duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050: hơn 6.158 ha, gần 96.500 dân',
		'excerpt'        => 'Ngày 5/11/2026, Đà Nẵng phê duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến năm 2050 (QĐ 5047/QĐ-UBND): khoảng 6.158,71 ha, dân số dự báo khoảng 96.498 người, định hướng dịch vụ, logistics, công nghiệp sạch.',
		'keyword'        => 'quy hoạch đô thị Thăng Điền',
		'keywords_extra' => array( 'đô thị Thăng Điền', 'xã Thăng Điền Đà Nẵng', 'quy hoạch phía Nam Đà Nẵng', 'Thăng Bình cũ' ),
		'project'        => 'hoiana-resort-golf',
		'schedule'       => '2026-11-06 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch Đà Nẵng', 'Thăng Điền', 'Đô thị mới' ),
		'image'          => 'plugin:img/tin-tuc/quy-hoach-chung-do-thi-thang-dien-2050.jpg',
		'image_alt'      => 'Sơ đồ minh hoạ đô thị Thăng Điền giữa Quốc lộ 1, các trục Đông – Tây và biển, quy hoạch chung đến năm 2050',
		'content'        => <<<HTML
<p>Ngày 5/11/2026, UBND thành phố Đà Nẵng cho biết đã ban hành <strong>Quyết định số 5047/QĐ-UBND</strong> phê duyệt nhiệm vụ <strong>quy hoạch chung đô thị Thăng Điền đến năm 2050</strong>. Đây là bước đầu để định hướng không gian đô thị và thúc đẩy kinh tế khu vực phía Nam thành phố.</p>
<!--hh-featured-->
<h2>Những con số chính</h2>
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
<p>Theo quy hoạch chung thành phố, Thăng Điền là một trong 7 đô thị mới dự kiến hình thành đến năm 2050, cùng Duy Nghĩa, Thăng An, Thăng Trường, Tây Hồ, Vu Gia và Hoàng Sa. Đến năm 2050, toàn thành phố có khoảng 30 đô thị (23 đô thị hiện hữu và 7 đô thị mới). Bối cảnh chung xem thêm tại <a href="/quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg/">quy hoạch chung Đà Nẵng đến 2050</a>.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Mới là nhiệm vụ quy hoạch:</strong> đây là bước xác định phạm vi, mục tiêu để lập đồ án. Ranh giới khu chức năng, đường quy hoạch và chỉ tiêu sử dụng đất từng khu vực chỉ rõ khi đồ án quy hoạch chung được phê duyệt.</li>
<li><strong>Đất quanh trục Quốc lộ 1 và các tuyến Đông – Tây</strong> được nhắc tới là khung không gian chính, nên thường được quan tâm sớm. Tuy nhiên, khi chưa có đồ án, anh chị nên kiểm tra quy hoạch sử dụng đất hiện hành của từng thửa trước khi giao dịch.</li>
<li><strong>Định hướng logistics, công nghiệp sạch</strong> có thể kéo theo nhu cầu nhà ở cho người lao động và dịch vụ đi kèm trong dài hạn; tiến độ phụ thuộc vào việc lập đồ án và thu hút đầu tư.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<p>Hiện Hoàng Hiệp chưa có dự án phân phối nằm trong xã Thăng Điền. Các dự án cùng hành lang ven biển phía Nam đang có trên web:</p>
<ul>
<li><a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a> – quần thể nghỉ dưỡng ven biển phía Bắc khu vực, cùng hưởng lợi khi hạ tầng và dân cư phía Nam thành phố phát triển.</li>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> – khu đô thị phía Nam, gần Khu kinh tế mở Chu Lai, cùng nằm trong vùng định hướng công nghiệp – logistics.</li>
</ul>
<p>Cần kiểm tra quy hoạch một lô đất cụ thể ở khu vực Thăng Bình cũ, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Quyết định 5047/QĐ-UBND của UBND thành phố Đà Nẵng (theo báo chí đưa tin ngày 5/11/2026: Doanh nghiệp &amp; Hội nhập); số liệu ghi theo nội dung báo chí trích dẫn.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Quy hoạch đô thị Thăng Điền đến 2050: 6.158 ha',
			'desc'      => 'Đà Nẵng duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050 (QĐ 5047/QĐ-UBND, 5/11/2026): khoảng 6.158,71 ha, dân số dự báo 96.498 người.',
			'points'    => array(
				'QĐ 5047/QĐ-UBND ngày 5/11/2026 phê duyệt nhiệm vụ quy hoạch chung đô thị Thăng Điền đến 2050',
				'Khoảng 6.158,71 ha, gồm 3 xã cũ Bình Tú, Bình Trung, Bình An; dân số dự báo khoảng 96.498 người',
				'Định hướng dịch vụ, logistics, công nghiệp sạch, nông nghiệp công nghệ cao; Quốc lộ 1 và trục Đông – Tây là khung chính',
			),
			'faq'       => array(
				array( 'Đô thị Thăng Điền ở đâu?', 'Là xã Thăng Điền thuộc TP Đà Nẵng, hình thành từ việc hợp nhất 3 xã Bình Tú, Bình Trung, Bình An (huyện Thăng Bình cũ), diện tích khoảng 6.158,71 ha.' ),
				array( 'Quy hoạch Thăng Điền đã có bản đồ chi tiết chưa?', 'Chưa. Ngày 5/11/2026 mới phê duyệt nhiệm vụ quy hoạch; ranh giới các khu chức năng chỉ rõ khi đồ án quy hoạch chung được phê duyệt.' ),
				array( 'Thăng Điền được định hướng phát triển gì?', 'Trung tâm dịch vụ, logistics, công nghiệp sạch và nông nghiệp công nghệ cao ở phía Nam Đà Nẵng.' ),
			),
		),
		'sources'        => array( 'https://doanhnghiephoinhap.vn/da-nang-quy-hoach-do-thi-thang-dien-hon-6100ha-dan-so-gan-100000-nguoi-153582.html' ),
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

	/* ---------------- 07/11 – 3 khu tái định cư Duy Xuyên phục vụ đường sắt tốc độ cao ---------------- */
	$posts[] = array(
		'slug'           => 'tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty',
		'rev'            => 2,
		'title'          => 'Đà Nẵng duyệt 3 khu tái định cư hơn 392 tỷ tại Duy Xuyên cho đường sắt tốc độ cao Bắc – Nam',
		'excerpt'        => 'UBND TP Đà Nẵng ban hành Quyết định 5082/QĐ-UBND phê duyệt 3 khu tái định cư Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn (khoảng 31 ha, hơn 392 tỷ đồng, 2026 – 2029) phục vụ giải phóng mặt bằng đường sắt tốc độ cao Bắc – Nam.',
		'keyword'        => 'tái định cư đường sắt tốc độ cao Duy Xuyên',
		'keywords_extra' => array( 'đường sắt tốc độ cao qua Đà Nẵng', 'tái định cư Duy Xuyên', 'Quyết định 5082/QĐ-UBND', 'bất động sản Duy Xuyên' ),
		'project'        => 'nam-hoi-an-city',
		'schedule'       => '2026-11-07 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Đường sắt tốc độ cao', 'Duy Xuyên', 'Tái định cư' ),
		'image'          => 'plugin:img/tin-tuc/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao.jpg',
		'image_alt'      => 'Sơ đồ minh hoạ 3 khu tái định cư Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn tại xã Duy Xuyên phục vụ đường sắt tốc độ cao Bắc – Nam',
		'content'        => <<<HTML
<p>UBND thành phố Đà Nẵng vừa ban hành <strong>Quyết định số 5082/QĐ-UBND</strong> phê duyệt Dự án thành phần 11 – xây dựng <strong>3 khu tái định cư tại xã Duy Xuyên</strong> phục vụ giải phóng mặt bằng tuyến <strong>đường sắt tốc độ cao Bắc – Nam</strong>, tổng mức đầu tư hơn 392 tỷ đồng.</p>
<!--hh-featured-->
<h2>Những con số chính</h2>
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
<p>Mục đích là tạo quỹ đất bố trí chỗ ở cho các hộ dân phải di dời khi Nhà nước thu hồi đất làm tuyến đường sắt. Theo VietnamPlus, tổng mức đầu tư giải phóng mặt bằng tuyến đường sắt tốc độ cao qua Đà Nẵng dự kiến hơn 19.551 tỷ đồng.</p>
<h2>Đường sắt tốc độ cao Bắc – Nam đang ở bước nào?</h2>
<ul>
<li>Tuyến dài khoảng 1.541 km, sơ bộ tổng mức đầu tư khoảng 67,34 tỷ USD, gồm 23 ga hành khách và 5 ga hàng hóa.</li>
<li>Bộ Xây dựng đặt mục tiêu nỗ lực <strong>khởi công vào tháng 12/2027</strong>; gói thầu tư vấn khảo sát, lập báo cáo nghiên cứu khả thi (TV-02) đã mở thầu.</li>
<li>Ga Đà Nẵng của tuyến dự kiến đặt tại Hòa Sơn – xem thêm <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang/">ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn</a>.</li>
</ul>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Ảnh thực tế flycam: từ bờ Duy Xuyên nhìn về cầu Cửa Đại, sông Thu Bồn và Hội An-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tín hiệu tuyến đi vào thực tế:</strong> làm tái định cư trước là bước bắt buộc để giải phóng mặt bằng. Việc Duy Xuyên có quyết định đầu tư cụ thể cho thấy hướng tuyến qua khu vực này đã được xác định ở mức đủ để lập dự án.</li>
<li><strong>Đất nằm trong hành lang tuyến cần cẩn trọng:</strong> trước khi mua đất ở Duy Xuyên, Điện Bàn hay các xã giáp ranh, anh chị nên hỏi UBND xã hoặc văn phòng đăng ký đất đai xem thửa đất có nằm trong phạm vi thu hồi của tuyến hay khu tái định cư không.</li>
<li><strong>Không nên kỳ vọng tăng giá ngắn hạn:</strong> tuyến dự kiến khởi công cuối 2027 và hoàn thành khoảng 2035; tác động lên giá đất chủ yếu là dài hạn, tập trung quanh ga chứ không phải dọc tuyến.</li>
<li><strong>Hạ tầng dân cư mới:</strong> 3 khu tái định cư có đường, điện, nước, cây xanh đồng bộ – góp phần làm dày dân cư phía Nam Hội An trong vài năm tới.</li>
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
			'seo_title' => 'Tái định cư Duy Xuyên cho đường sắt tốc độ cao',
			'desc'      => 'Đà Nẵng duyệt 3 khu tái định cư Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn (~31 ha, hơn 392 tỷ, 2026 – 2029) phục vụ đường sắt tốc độ cao Bắc – Nam.',
			'points'    => array(
				'QĐ 5082/QĐ-UBND duyệt Dự án thành phần 11: 3 khu tái định cư tại xã Duy Xuyên, hơn 392 tỷ đồng',
				'Khoảng 31 ha: Duy Trung 5,27 ha, Duy Sơn 10,99 ha, Duy Trinh – Duy Sơn 14,74 ha; thực hiện 2026 – 2029',
				'Đường sắt tốc độ cao Bắc – Nam ~1.541 km, mục tiêu khởi công 12/2027; đất trong hành lang tuyến cần kiểm tra kỹ',
			),
			'faq'       => array(
				array( '3 khu tái định cư đường sắt tốc độ cao ở Duy Xuyên nằm đâu?', 'Khu Duy Trung (thôn Hòa Lâm, hơn 5,27 ha), khu Duy Sơn (thôn Chiêm Sơn, khoảng 10,99 ha) và khu Duy Trinh – Duy Sơn (hơn 14,74 ha), đều thuộc xã Duy Xuyên, TP Đà Nẵng.' ),
				array( 'Tổng vốn và thời gian làm các khu tái định cư?', 'Tổng mức đầu tư hơn 392 tỷ đồng theo Quyết định 5082/QĐ-UBND, dự kiến thực hiện giai đoạn 2026 – 2029.' ),
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
		'keyword'        => 'TOD quanh ga đường sắt Đà Nẵng',
		'keywords_extra' => array( 'dự thảo nghị quyết TOD Đà Nẵng', 'hệ số sử dụng đất quanh nhà ga', 'đô thị TOD Đà Nẵng', 'đường sắt đô thị Đà Nẵng' ),
		'project'        => 'sun-saphia-residence',
		'schedule'       => '2026-11-09 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'TOD', 'Đường sắt', 'Quy hoạch' ),
		'image'          => 'plugin:img/tin-tuc/tod-quanh-ga-duong-sat-da-nang-du-thao-nghi-quyet.jpg',
		'image_alt'      => 'Hình minh hoạ đô thị TOD: hệ số sử dụng đất cao dần về phía nhà ga trong bán kính khoảng 1 km',
		'content'        => <<<HTML
<p>Sở Xây dựng Đà Nẵng đã ra công văn ngày <strong>23/10/2026</strong> lấy ý kiến <strong>dự thảo nghị quyết của HĐND thành phố</strong> về phát triển đô thị theo mô hình <strong>TOD</strong> (Transit Oriented Development – phát triển đô thị gắn với giao thông công cộng) quanh các nhà ga đường sắt. Điểm đáng chú ý nhất với thị trường: <strong>hệ số sử dụng đất tối đa có thể tăng đến 1,5 lần</strong> so với quy chuẩn hiện hành trong khoảng <strong>1 km quanh nhà ga</strong>.</p>
<!--hh-featured-->
<h2>Dự thảo nêu những gì?</h2>
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
<p>Hồ sơ hiện mới xây dựng <strong>nguyên tắc, chỉ tiêu và trình tự</strong>; <strong>chưa xác định ranh giới khu TOD cho nhà ga cụ thể nào</strong>. Trước đó, HĐND TP.HCM đã thông qua nghị quyết tương tự, cũng cho tăng tối đa 1,5 lần hệ số sử dụng đất quanh ga đường sắt.</p>
<h2>Đà Nẵng sẽ có những nhà ga nào?</h2>
<ul>
<li><strong>Đường sắt tốc độ cao Bắc – Nam:</strong> ga Đà Nẵng dự kiến đặt tại Hòa Sơn – xem <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang/">ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn</a>.</li>
<li><strong>Đường sắt đô thị (metro/LRT):</strong> <a href="/quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg/">quy hoạch chung Đà Nẵng đến 2050</a> định hướng phát triển các khu đô thị TOD quanh nhà ga; tiến độ các tuyến còn phụ thuộc nguồn vốn.</li>
</ul>
<!--hh-img:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg|Ảnh thực tế: cầu sông Hàn và trung tâm Đà Nẵng về đêm-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đất quanh ga sẽ "cao" hơn:</strong> hệ số sử dụng đất tăng nghĩa là cùng một lô đất được xây nhiều sàn hơn – giá trị đất quanh ga tăng theo, nhất là các lô lớn có thể làm căn hộ, văn phòng, thương mại.</li>
<li><strong>Chưa có ranh giới – chưa nên "đón sóng":</strong> dự thảo chưa chỉ ra khu TOD ở ga nào; tin rao "đất trong vùng TOD" lúc này là chưa có căn cứ. Cần chờ nghị quyết được thông qua và quy hoạch chi tiết từng khu ga.</li>
<li><strong>Lợi thế dài hạn cho dự án gần ga:</strong> căn hộ cách ga trong khoảng đi bộ sẽ được hưởng hạ tầng công cộng, cây xanh, dịch vụ tập trung – nhưng thời gian tính bằng năm, phụ thuộc tiến độ các tuyến đường sắt.</li>
<li><strong>Nhà nước thu lại giá trị đất:</strong> mô hình TOD thường đi kèm đấu giá quỹ đất quanh ga để có vốn làm đường sắt – đất đấu giá mới sẽ tăng nguồn cung trong tương lai.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> – trên trục biển Võ Nguyên Giáp – Trường Sa, theo quy hoạch cách nhà ga đường sắt đô thị số 09 khoảng 500 m; nếu khu ga được quy hoạch TOD, khu vực xung quanh sẽ được đầu tư dày hơn (dài hạn, phụ thuộc tiến độ tuyến).</li>
</ul>
<p>Cần kiểm tra một lô đất, căn hộ cụ thể có gần nhà ga theo quy hoạch hay không, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Vietstock (08/11/2026) và CafeLand (11/2026) đưa tin về dự thảo nghị quyết TOD do Sở Xây dựng Đà Nẵng lấy ý kiến từ 23/10/2026; Báo Tiền Phong, Dân trí (6/2026) về nghị quyết TOD của TP.HCM. Chưa đọc được toàn văn dự thảo – số liệu ghi theo báo chí; con số 320 ha mới thấy ở tiêu đề bài báo, chưa đối chiếu được nội dung.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Dự thảo TOD Đà Nẵng: hệ số đất quanh ga gấp 1,5',
			'desc'      => 'Đà Nẵng lấy ý kiến dự thảo nghị quyết TOD: hệ số sử dụng đất tối đa tăng đến 1,5 lần trong khoảng 1 km quanh nhà ga, dự kiến trình HĐND cuối 2026.',
			'points'    => array(
				'Sở Xây dựng lấy ý kiến dự thảo nghị quyết HĐND về đô thị TOD từ 23/10/2026',
				'Hệ số sử dụng đất tối đa tăng đến 1,5 lần trong khoảng 1 km quanh nhà ga',
				'Chưa xác định ranh giới TOD cho nhà ga cụ thể; dự kiến trình HĐND kỳ họp cuối năm 2026',
			),
			'faq'       => array(
				array( 'TOD là gì?', 'TOD (Transit Oriented Development) là mô hình phát triển đô thị gắn với giao thông công cộng: tập trung nhà ở, văn phòng, thương mại với mật độ cao quanh nhà ga đường sắt, metro để người dân đi bộ tới ga.' ),
				array( 'Dự thảo TOD của Đà Nẵng cho tăng hệ số sử dụng đất bao nhiêu?', 'Theo báo chí, dự thảo cho tăng tối đa 1,5 lần hệ số sử dụng đất tối đa của lô đất, ô phố so với quy chuẩn hiện hành, trong khoảng 1 km quanh nhà ga.' ),
				array( 'Đã có khu TOD nào ở Đà Nẵng được duyệt chưa?', 'Chưa. Dự thảo mới xây dựng nguyên tắc, chỉ tiêu và trình tự; chưa xác định ranh giới khu TOD cho nhà ga cụ thể. Dự kiến trình HĐND thành phố kỳ họp cuối năm 2026.' ),
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
		'slug'           => 'da-nang-cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan-thang-11',
		'title'          => 'Đà Nẵng chuẩn bị công bố Quy hoạch chung 2050 cuối tháng 11: dự kiến khởi công Aeon Mall Hòa Xuân, tái khởi động Đa Phước',
		'excerpt'        => 'Đà Nẵng ban hành kế hoạch hội nghị công bố Quy hoạch chung đến 2050 và xúc tiến đầu tư 2026, dự kiến 28/11. Bên lề: dự kiến khởi công Aeon Mall Hòa Xuân (khu đất 101.800 m², vốn hơn 4.300 tỷ), tái khởi động Khu đô thị quốc tế Đa Phước 17/11.',
		'keyword'        => 'công bố quy hoạch chung Đà Nẵng',
		'keywords_extra' => array( 'Aeon Mall Hòa Xuân', 'hội nghị xúc tiến đầu tư Đà Nẵng 2026', 'khu đô thị quốc tế Đa Phước', 'bất động sản Hòa Xuân' ),
		'project'        => 'cora-tower',
		'schedule'       => '2026-11-10 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Quy hoạch', 'Hòa Xuân', 'Xúc tiến đầu tư' ),
		'image'          => 'plugin:img/tin-tuc/cong-bo-quy-hoach-chung-da-nang-aeon-mall-hoa-xuan-11-2026.jpg',
		'image_alt'      => 'Lịch dự kiến cuối tháng 11/2026 tại Đà Nẵng: tái khởi động Đa Phước, khởi công Aeon Mall Hòa Xuân, khánh thành Quốc lộ 14E, hội nghị công bố Quy hoạch chung',
		'content'        => <<<HTML
<p>Chủ tịch UBND TP Đà Nẵng <strong>Nguyễn Mạnh Hùng</strong> đã ký ban hành <strong>kế hoạch tổ chức Hội nghị công bố Quy hoạch chung thành phố đến năm 2050, tầm nhìn đến năm 2075 và Xúc tiến đầu tư năm 2026</strong>. Theo Báo Đầu tư (09/11/2026), hội nghị dự kiến diễn ra <strong>ngày 28/11</strong> tại Trung tâm Hành chính thành phố; một số nguồn khác nêu phương án sáng 21 hoặc 28/11, khoảng 500 đại biểu. Đi kèm là chuỗi sự kiện khởi công, khánh thành – đáng chú ý với bất động sản là <strong>Aeon Mall Hòa Xuân</strong>.</p>
<!--hh-featured-->
<h2>Lịch dự kiến cuối tháng 11/2026</h2>
<table>
<thead><tr><th>Thời gian (dự kiến)</th><th>Sự kiện</th></tr></thead>
<tbody>
<tr><td>17/11</td><td>Lễ tái khởi động Khu đô thị quốc tế Đa Phước (giai đoạn 1)</td></tr>
<tr><td>Tháng 11</td><td>Khởi công Trung tâm thương mại AEON MALL Đà Nẵng Hòa Xuân (theo Tuổi Trẻ, chủ đầu tư đang hoàn tất thủ tục, hồ sơ thiết kế)</td></tr>
<tr><td>27 hoặc 29/11</td><td>Khánh thành dự án nâng cấp Quốc lộ 14E</td></tr>
<tr><td>21 hoặc 28/11</td><td>Hội nghị công bố Quy hoạch chung đến 2050 và xúc tiến đầu tư; trao quyết định phê duyệt quy hoạch</td></tr>
<tr><td>Bên lề</td><td>Dự kiến khai trương VSAP Lab, khởi công dự án ô tô Volkswagen; triển lãm quy hoạch</td></tr>
</tbody>
</table>
<p>Theo Báo Đầu tư, thành phố cũng đã phê duyệt dự án <strong>Luồng Cửa Lở</strong> với tổng vốn khoảng <strong>7.585 tỷ đồng</strong>. Quy hoạch chung được Phó Thủ tướng ký phê duyệt tại <a href="/quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg/">Quyết định 2016/QĐ-TTg ngày 21/10/2026</a>.</p>
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
<li><strong>Hội nghị quy hoạch là tín hiệu mở dự án:</strong> quy hoạch chung đã duyệt, thành phố bước sang giai đoạn kêu gọi đầu tư – các quỹ đất, dự án lớn sẽ được công bố dần; người mua nên theo dõi danh mục dự án kêu gọi tại hội nghị để biết khu nào sắp có vốn vào.</li>
<li><strong>Lịch có thể đổi:</strong> các mốc trên đều là dự kiến theo kế hoạch và báo chí; Hoàng Hiệp sẽ cập nhật khi sự kiện diễn ra.</li>
</ul>
<!--hh-img:img/nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-duong-noi-khu-san-the-thao.jpg|Ảnh thực tế 8/2025: đường nội khu và sân thể thao khu Nam Hòa Xuân-->
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/cora-tower/">Cora Tower</a> – tòa căn hộ Sun Group trong khu đô thị Sun Neo City, phường Hòa Xuân; một trung tâm thương mại lớn cùng khu vực giúp tăng tiện ích sống và nhu cầu thuê.</li>
<li><a href="/du-an/spana-tower/">Spana Tower</a> và <a href="/du-an/s-light-tower/">S-Light Tower</a> – căn hộ Sun Group ven sông tại Hòa Xuân, hưởng lợi từ việc khu vực có thêm thương mại, dịch vụ quy mô lớn.</li>
<li><a href="/du-an/sun-neo-city/">Sun Neo City</a> – khu đô thị của Sun Group tại Hòa Xuân, nơi có Cora, Spana, S-Light.</li>
<li><a href="/dat-nen-hoa-xuan/">Đất nền Hòa Xuân</a> – nhà phố, đất ở trong bán kính phục vụ của trung tâm thương mại sẽ được quan tâm hơn khi dự án khởi công thật.</li>
</ul>
<p>Cần bảng giá, giỏ hàng căn hộ Sun Group tại Hòa Xuân hoặc kiểm tra khoảng cách tới khu đất Aeon Mall, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Báo Đầu tư (09/11/2026) về kế hoạch Hội nghị công bố Quy hoạch chung và xúc tiến đầu tư; Báo Đà Nẵng (11/2026); Tuổi Trẻ (10/2026) về kế hoạch khởi công AEON MALL Hòa Xuân trong tháng 11; CafeLand, VCCI, Nhà Đầu tư (2026) về quyết định cho thuê đất, diện tích, vốn đầu tư. Chưa đọc được toàn văn kế hoạch – ngày giờ ghi theo báo chí, có thể điều chỉnh.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Đà Nẵng công bố Quy hoạch chung 28/11, Aeon Hòa Xuân',
			'desc'      => 'Đà Nẵng dự kiến công bố Quy hoạch chung 2050 ngày 28/11; bên lề dự kiến khởi công Aeon Mall Hòa Xuân (101.800 m², hơn 4.300 tỷ), tái khởi động Đa Phước.',
			'points'    => array(
				'Hội nghị công bố Quy hoạch chung 2050 và xúc tiến đầu tư dự kiến 28/11/2026 tại Trung tâm Hành chính',
				'Aeon Mall Hòa Xuân: khu đất 101.800 m², thuê đến 07/8/2075, vốn hơn 4.300 tỷ, dự kiến khởi công tháng 11',
				'17/11 tái khởi động Khu đô thị quốc tế Đa Phước giai đoạn 1; Quốc lộ 14E dự kiến khánh thành cuối tháng 11',
			),
			'faq'       => array(
				array( 'Khi nào Đà Nẵng công bố Quy hoạch chung đến 2050?', 'Theo kế hoạch UBND thành phố được báo chí đưa tin, hội nghị công bố Quy hoạch chung đến năm 2050, tầm nhìn 2075 và xúc tiến đầu tư dự kiến ngày 28/11/2026 tại Trung tâm Hành chính (một số nguồn nêu phương án 21/11).' ),
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
		'slug'           => 'tai-dinh-cu-huong-tra-duong-sat-toc-do-cao-hoa-lien-tuy-loan',
		'title'          => 'Đà Nẵng duyệt thêm 2 khu tái định cư hơn 471 tỷ: Hương Trà cho đường sắt tốc độ cao, Hòa Liên – Túy Loan cho cao tốc',
		'excerpt'        => 'Quyết định 5128/QĐ-UBND duyệt khu tái định cư hơn 365,8 tỷ đồng, khoảng 32,57 ha với 391 lô tại phường Hương Trà (Tam Kỳ cũ) phục vụ đường sắt tốc độ cao Bắc – Nam; Quyết định 5151/QĐ-UBND duyệt khu tái định cư số 3 hơn 105,3 tỷ cho cao tốc đoạn Hòa Liên – Túy Loan.',
		'keyword'        => 'tái định cư đường sắt tốc độ cao Hương Trà',
		'keywords_extra' => array( 'tái định cư cao tốc Hòa Liên Túy Loan', 'đường sắt tốc độ cao qua Tam Kỳ', 'Quyết định 5128/QĐ-UBND', 'bất động sản Tam Kỳ' ),
		'project'        => 'meta-city-tam-ky',
		'schedule'       => '2026-11-12 07:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Đường sắt tốc độ cao', 'Tái định cư' ),
		'image'          => 'plugin:img/tin-tuc/tai-dinh-cu-huong-tra-hoa-lien-11-2026.jpg',
		'image_alt'      => 'Hai khu tái định cư mới tại phường Hương Trà và cao tốc Hòa Liên – Túy Loan, Đà Nẵng',
		'content'        => <<<HTML
<p>Trong hai ngày 9 – 10/11/2026, UBND TP Đà Nẵng duyệt thêm hai dự án tái định cư phục vụ hai công trình giao thông lớn: khu <strong>tái định cư đường sắt tốc độ cao Hương Trà</strong> (Quyết định 5128/QĐ-UBND, hơn 365,8 tỷ đồng) và <strong>Khu tái định cư số 3</strong> cho cao tốc đoạn Hòa Liên – Túy Loan (Quyết định 5151/QĐ-UBND, hơn 105,3 tỷ đồng). Cộng lại, hai dự án có tổng mức đầu tư hơn 471 tỷ đồng (Hoàng Hiệp cộng từ hai quyết định).</p>
<!--hh-featured-->
<h2>Tái định cư đường sắt tốc độ cao Hương Trà: những con số chính</h2>
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
<p>Quyết định cũng giao UBND phường Hương Trà rà soát, chuẩn hóa thông tin diện tích đất để hồ sơ dự án khớp với quy hoạch, và quản lý quy hoạch xung quanh để giữ khoảng cách an toàn môi trường với trạm xử lý nước thải.</p>
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
<!--hh-img:img/meta-city-tam-ky/meta-city-tam-ky-phoi-canh-tong-the.jpg|Phối cảnh khu đô thị Meta City ở Tây Bắc Tam Kỳ, phường Bàn Thạch – cùng khu vực Tam Kỳ cũ với phường Hương Trà (phối cảnh chủ đầu tư)-->
<h2>Chuỗi tái định cư cho đường sắt tốc độ cao qua Đà Nẵng</h2>
<p>Khu Hương Trà nằm trong chuỗi dự án tái định cư thành phố đang duyệt dần cho tuyến đường sắt tốc độ cao Bắc – Nam. Đầu tháng 11/2026, Đà Nẵng đã duyệt 3 khu tái định cư hơn 392 tỷ đồng tại Duy Xuyên (xem <a href="/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty/">bài chi tiết</a>); trước đó báo chí cũng đưa tin các khu tại Hòa Tiến, Tam Xuân, Bàn Thạch, Hòa Khánh – Liên Chiểu. Theo các báo, tuyến qua Đà Nẵng dài khoảng 116 km, từ phường Hải Vân đến xã Núi Thành; Bộ Xây dựng đặt mục tiêu khởi công tuyến vào tháng 12/2027. Ga hành khách Đà Nẵng dự kiến đặt tại Hòa Sơn – xem <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang/">ga đường sắt tốc độ cao Đà Nẵng</a>.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tuyến đường sắt đã chạm tới Tam Kỳ cũ:</strong> sau Duy Xuyên, việc có quyết định đầu tư cụ thể ở Hương Trà cho thấy công tác chuẩn bị mặt bằng đang trải dài khắp các địa phương phía Nam thành phố. Làm tái định cư trước là bước bắt buộc trước khi thu hồi đất.</li>
<li><strong>Kiểm tra hành lang tuyến trước khi mua đất:</strong> ở các phường, xã có tuyến đi qua như Hương Trà, Bàn Thạch, Hòa Liên, anh chị nên hỏi UBND phường, xã hoặc văn phòng đăng ký đất đai xem thửa đất có nằm trong phạm vi thu hồi, hành lang an toàn hay không trước khi đặt cọc.</li>
<li><strong>391 lô tái định cư không phải hàng bán tự do:</strong> lô tái định cư dành để bố trí cho hộ bị thu hồi đất. Khi có người rao "suất tái định cư", cần kiểm tra quyết định giao đất, điều kiện chuyển nhượng – tránh mua giấy tờ tay.</li>
<li><strong>Hạ tầng dân cư mới:</strong> mỗi khu tái định cư đi kèm đường, thoát nước, xử lý nước thải, bãi đỗ xe, cây xanh đồng bộ; về dài hạn giúp khu vực ven tuyến có thêm khu dân cư mới.</li>
<li><strong>Tác động giá là dài hạn:</strong> đường sắt dự kiến khởi công cuối 2027; giá đất thường chịu ảnh hưởng rõ nhất quanh nhà ga, không phải dọc tuyến. Không nên mua đuổi theo tin tái định cư.</li>
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
			'seo_title' => 'Tái định cư đường sắt tốc độ cao Hương Trà 365,8 tỷ',
			'desc'      => 'Tái định cư đường sắt tốc độ cao Hương Trà: QĐ 5128 duyệt hơn 365,8 tỷ, 32,57 ha, 391 lô; QĐ 5151 duyệt khu TĐC số 3 cao tốc Hòa Liên – Túy Loan 105,3 tỷ.',
			'points'    => array(
				'QĐ 5128/QĐ-UBND: khu tái định cư phường Hương Trà hơn 365,8 tỷ, khoảng 32,57 ha, 391 lô, phục vụ đường sắt tốc độ cao',
				'QĐ 5151/QĐ-UBND (09/11/2026): khu tái định cư số 3 hơn 105,3 tỷ cho cao tốc đoạn Hòa Liên – Túy Loan, làm 2026 – 2027',
				'Đất trong hành lang tuyến cần kiểm tra kỹ; lô tái định cư không phải hàng bán tự do',
			),
			'faq'       => array(
				array( 'Khu tái định cư đường sắt tốc độ cao ở Hương Trà lớn bao nhiêu?', 'Theo Quyết định 5128/QĐ-UBND, khoảng 32,57 ha với 391 lô tái định cư, tổng mức đầu tư hơn 365,8 tỷ đồng, kèm 6 bãi đỗ xe và công viên cây xanh.' ),
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
		'slug'           => 'vsip-vi-tri-so-7-khu-thuong-mai-tu-do-da-nang-3525-ty',
		'title'          => 'Đà Nẵng chọn VSIP làm hạ tầng vị trí số 7 Khu thương mại tự do: 3.525 tỷ, 276 ha tại Hòa Vang',
		'excerpt'        => 'Quyết định 5202/QĐ-UBND ngày 12/11/2026 chấp thuận VSIP là nhà đầu tư dự án hạ tầng khu chức năng vị trí số 7 Khu thương mại tự do Đà Nẵng: khoảng 276 ha tại xã Hòa Vang, vốn 3.525 tỷ đồng, xây hạ tầng từ quý 4/2027 đến quý 1/2032.',
		'keyword'        => 'khu thương mại tự do Đà Nẵng vị trí số 7',
		'keywords_extra' => array( 'VSIP Đà Nẵng', 'Quyết định 5202/QĐ-UBND', 'bất động sản Hòa Vang', 'khu thương mại tự do Đà Nẵng' ),
		'project'        => 'spana-tower',
		'schedule'       => '2026-11-13 07:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Khu thương mại tự do', 'Hòa Vang' ),
		'image'          => 'plugin:img/tin-tuc/vsip-vi-tri-7-khu-thuong-mai-tu-do-11-2026.jpg',
		'image_alt'      => 'VSIP làm nhà đầu tư hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng, 3.525 tỷ đồng',
		'content'        => <<<HTML
<p>Ngày 12/11/2026, UBND TP Đà Nẵng ban hành <strong>Quyết định 5202/QĐ-UBND</strong>, chấp thuận Công ty Liên doanh TNHH Khu công nghiệp Việt Nam – Singapore (<strong>VSIP</strong>) là nhà đầu tư dự án đầu tư xây dựng và kinh doanh kết cấu hạ tầng khu chức năng tại <strong>vị trí số 7 – Khu thương mại tự do Đà Nẵng</strong>, xã Hòa Vang. Đây là bước tiếp theo sau khi thành phố chấp thuận chủ trương đầu tư dự án (Quyết định 4785/QĐ-UBND) hồi giữa tháng 10/2026.</p>
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
<p>Khu thương mại tự do Đà Nẵng được Thủ tướng quyết định thành lập năm 2025, tổng diện tích khoảng 1.881 ha chia ở 7 vị trí, gắn với cảng Liên Chiểu ở phía Tây Bắc (xem <a href="/cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu/">cảng Liên Chiểu và Khu thương mại tự do</a>). Vị trí số 7 nằm ở vùng phía Tây thành phố; theo quyết định thành lập ban đầu, vị trí này rộng khoảng 401 ha – con số 276 ha trong dự án hạ tầng lần này nhỏ hơn, báo chí chưa giải thích phần chênh lệch. Quy hoạch chung Đà Nẵng đến 2050 cũng xác định đưa 7 vị trí của Khu thương mại tự do vào hoạt động (xem <a href="/quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg/">quy hoạch chung 2050</a>).</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-nhin-ve-trung-tam.jpg|Sông Cẩm Lệ và khu Hòa Xuân nhìn về trung tâm Đà Nẵng – khu đô thị phía Nam gần nhất với vùng phát triển phía Tây (ảnh flycam thực tế tháng 8/2025)-->
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Có nhà đầu tư hạ tầng chuyên nghiệp:</strong> VSIP là đơn vị đã làm nhiều khu công nghiệp tại Việt Nam; việc chọn được nhà đầu tư cho thấy Khu thương mại tự do bắt đầu chuyển từ quy hoạch sang triển khai thực tế ở vị trí này.</li>
<li><strong>Tác động là dài hạn:</strong> hạ tầng làm từ cuối 2027 đến đầu 2032, doanh nghiệp thứ cấp vào sớm nhất từ cuối 2028. Nhu cầu nhà ở cho người lao động, chuyên gia sẽ tăng dần theo tiến độ lấp đầy, không phải ngay lập tức.</li>
<li><strong>Đất Hòa Vang: kiểm tra quy hoạch trước khi mua:</strong> khu vực quanh các vị trí Khu thương mại tự do sẽ có thu hồi đất, tái định cư. Anh chị nên kiểm tra quy hoạch sử dụng đất, chỉ giới đường quy hoạch tại UBND xã hoặc văn phòng đăng ký đất đai, tránh mua theo tin "sắp lên khu công nghiệp".</li>
<li><strong>Căn hộ khu Nam – Tây Nam hưởng lợi gián tiếp:</strong> các khu đô thị có sẵn hạ tầng như Hòa Xuân, Cẩm Lệ là nơi chuyên gia, nhân sự quản lý thường chọn ở vì gần trung tâm hơn và đủ tiện ích; nhu cầu thuê có thể tăng khi các khu chức năng đi vào hoạt động.</li>
<li><strong>Không mua đuổi theo tin:</strong> mức hưởng lợi phụ thuộc tiến độ thực tế và tốc độ thu hút doanh nghiệp. Nên theo dõi các mốc giao đất, khởi công hạ tầng năm 2027.</li>
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
			'seo_title' => 'VSIP làm hạ tầng vị trí số 7 khu thương mại tự do',
			'desc'      => 'QĐ 5202/QĐ-UBND (12/11/2026) chọn VSIP làm hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng: 276 ha ở Hòa Vang, vốn 3.525 tỷ, làm từ 2027 đến 2032.',
			'points'    => array(
				'Quyết định 5202/QĐ-UBND ngày 12/11/2026 chấp thuận VSIP là nhà đầu tư hạ tầng vị trí số 7 Khu thương mại tự do Đà Nẵng',
				'Khoảng 276 ha tại xã Hòa Vang, vốn 3.525 tỷ đồng, hạ tầng làm từ quý 4/2027 đến quý 1/2032',
				'Tác động bất động sản là dài hạn; đất Hòa Vang cần kiểm tra quy hoạch, thu hồi đất trước khi mua',
			),
			'faq'       => array(
				array( 'Vị trí số 7 Khu thương mại tự do Đà Nẵng ở đâu?', 'Theo báo chí, dự án hạ tầng vị trí số 7 nằm tại xã Hòa Vang, TP Đà Nẵng, quy mô khoảng 276 ha.' ),
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
		'slug'           => 'da-nang-khoi-cong-8-du-an-nha-o-xa-hoi-4575-can-cuoi-2026',
		'title'          => 'Đà Nẵng sắp khởi công 8 dự án nhà ở xã hội, khoảng 4.575 căn trong 2 tháng cuối năm 2026',
		'excerpt'        => 'Tại buổi làm việc ngày 10/11/2026, Đà Nẵng cho biết từ đầu năm đã giao chủ đầu tư 10 dự án nhà ở xã hội (9.916 căn), đã khởi công 4 dự án, mở bán 4 dự án và dự kiến khởi công thêm 8 dự án với khoảng 4.575 căn trong 2 tháng cuối năm. Danh mục 113 khu đất khoảng 390 ha là quỹ đất cho giai đoạn 2026 – 2030.',
		'keyword'        => 'nhà ở xã hội Đà Nẵng',
		'keywords_extra' => array( 'nhà ở xã hội Đà Nẵng 2026', '113 khu đất nhà ở xã hội Đà Nẵng', 'mua nhà ở xã hội Đà Nẵng', 'Quyết định 2259/QĐ-UBND' ),
		'project'        => '',
		'schedule'       => '2026-11-14 07:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Nhà ở xã hội', 'Chính sách nhà ở', 'Hạ tầng Đà Nẵng' ),
		'image'          => 'plugin:img/tin-tuc/da-nang-khoi-cong-8-du-an-nha-o-xa-hoi-4575-can-cuoi-2026.jpg',
		'image_alt'      => 'Đà Nẵng sắp khởi công 8 dự án nhà ở xã hội, khoảng 4.575 căn trong 2 tháng cuối năm 2026',
		'content'        => <<<HTML
<p>Ngày 10/11/2026, tại buổi làm việc về tình hình phát triển <strong>nhà ở xã hội</strong> (Chủ tịch HĐND thành phố Nguyễn Đức Dũng chủ trì, theo VnExpress), Sở Xây dựng Đà Nẵng báo cáo: từ đầu năm 2026 thành phố đã chấp thuận chủ trương đầu tư, giao chủ đầu tư <strong>10 dự án với khoảng 9.916 căn</strong>; trong 2 tháng cuối năm dự kiến <strong>khởi công thêm 8 dự án, khoảng 4.575 căn</strong>. Đây là nguồn cung đáng chú ý cho người thu nhập thấp, công nhân, cán bộ – công chức đang tìm nhà ở Đà Nẵng.</p>
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
<h2>Quỹ đất 113 khu: những khu lớn nhất</h2>
<p>Theo Quyết định 2259/QĐ-UBND, các khu đất có quy mô lớn trong danh mục gồm: Khu đô thị Tam Hòa – Tam Tiến khoảng 20,3 ha; Điểm dân cư số 1 tại xã Hòa Tiến khoảng 20,2 ha; Khu đô thị Chu Lai (xã Núi Thành) khoảng 17,4 ha; Khu nhà ở xã hội Vạn Phúc – Hội An (phường Hội An Tây) khoảng 12,41 ha. Quỹ đất trải ra cả khu vực Đà Nẵng cũ lẫn vùng Quảng Nam cũ sau hợp nhất – từ các xã phía Tây, phía Nam đến Hội An, Chu Lai.</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le.jpg|Khu đô thị ven sông Cẩm Lệ – Hòa Xuân, nơi có các dự án nhà ở xã hội Lê Kim Lăng và Hòa Phước (ảnh flycam thực tế tháng 8/2025)-->
<h2>Điều gì còn làm chậm tiến độ?</h2>
<p>Theo Sở Xây dựng, tiến độ nhiều dự án còn phụ thuộc vào việc điều chỉnh quy hoạch, giải phóng mặt bằng và đầu tư hạ tầng kỹ thuật kết nối; nguồn cung nhà ở xã hội <strong>cho thuê</strong> cũng còn thiếu so với chỉ tiêu. Các con số 4.575 căn hay 26.279 căn vì vậy là kế hoạch, chưa phải kết quả – người mua nên theo dõi thông báo mở bán chính thức của từng dự án.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Cơ hội cho người mua nhà đầu tiên:</strong> nguồn cung nhà ở xã hội tăng mạnh từ cuối 2026 – 2027. Người đủ điều kiện (theo Luật Nhà ở 2023 và các văn bản hướng dẫn về đối tượng, thu nhập, nhà ở hiện có) nên chuẩn bị hồ sơ xác nhận sớm để kịp đợt nhận hồ sơ của từng dự án.</li>
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
<p>Cần kiểm tra điều kiện mua nhà ở xã hội hoặc so sánh với căn hộ thương mại giá vừa, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: buổi làm việc về nhà ở xã hội ngày 10/11/2026 theo VnExpress, CafeF, Báo Đầu tư, VietTimes, Vietbao (10 – 11/11/2026); Quyết định 2259/QĐ-UBND ngày 22/5/2026 về danh mục 113 vị trí khu đất phát triển nhà ở xã hội theo VnEconomy, Báo Xây dựng, Bộ Xây dựng (5/2026). Bài viết theo trích yếu báo chí, chưa đọc toàn văn các văn bản.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Đà Nẵng sắp khởi công 8 dự án nhà ở xã hội',
			'desc'      => 'Đà Nẵng dự kiến khởi công 8 dự án nhà ở xã hội, khoảng 4.575 căn cuối 2026; đã giao 10 dự án 9.916 căn; quỹ 113 khu đất 390 ha. Ai nên chú ý?',
			'points'    => array(
				'10/11/2026: Đà Nẵng dự kiến khởi công 8 dự án nhà ở xã hội, khoảng 4.575 căn trong 2 tháng cuối năm',
				'Từ đầu 2026: giao chủ đầu tư 10 dự án (9.916 căn), khởi công 4 dự án, mở bán 4 dự án',
				'Quỹ 113 khu đất khoảng 390 ha (QĐ 2259/QĐ-UBND), chỉ tiêu 26.279 căn giai đoạn 2026 – 2030',
			),
			'faq'       => array(
				array( 'Đà Nẵng có bao nhiêu dự án nhà ở xã hội sắp khởi công?', 'Theo báo cáo tại buổi làm việc ngày 10/11/2026, thành phố dự kiến khởi công thêm 8 dự án với khoảng 4.575 căn trong 2 tháng cuối năm 2026.' ),
				array( 'Danh mục 113 khu đất nhà ở xã hội Đà Nẵng là gì?', 'Quyết định 2259/QĐ-UBND ngày 22/5/2026 phê duyệt 113 vị trí khu đất khoảng 390 ha để phát triển nhà ở xã hội, gồm 24 khu đang triển khai và 89 khu dự kiến triển khai giai đoạn tiếp theo.' ),
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
		),
	);
	return $posts;
}
