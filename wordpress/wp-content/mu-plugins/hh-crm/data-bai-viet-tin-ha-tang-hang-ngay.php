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

	return $posts;
}
