<?php
/**
 * Sun Saphia Residence đợt 6 – 6 bài tin tách từ thông tin sau kick-off (02/11 – 07/11/2026, 15:00 mỗi ngày):
 * công viên biển 2,45 ha, thị trường khách sạn Đà Nẵng, so sánh loại hình đầu tư cho thuê, xây/mua khách sạn hay mua căn
 * lưu trú, phí kênh bán phòng, công trình cấp I. Mỗi bài dẫn về bài trụ cột "Đánh giá Sun Saphia Residence" và trang dự án.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Giá rao, giá phòng là tham khảo 10/2026; ví dụ tính là minh hoạ, không cam kết.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_6' );
function hh_posts_sun_saphia_dot_6( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$review = '<a href="/danh-gia-sun-saphia-residence-chi-tiet/">đánh giá chi tiết Sun Saphia Residence</a>';
	$cta    = '<p>Cần mặt bằng, bảng giá và bảng tính dòng tiền ' . $saphia . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 02/11 – Công viên biển 2,45 ha ---------------- */
	$posts[] = array(
		'slug'     => 'cong-vien-bien-truong-sa-2-45-ha-truoc-sun-saphia-residence',
		'title'    => 'Công viên biển 2,45 ha trên đường Trường Sa: đất dự án bỏ hoang thành công viên trước Sun Saphia Residence',
		'excerpt'  => 'Đà Nẵng thu hồi khoảng 2,45 ha từ dự án resort Hòn Ngọc Á Châu bỏ hoang để làm công viên công cộng ven biển trên đường Trường Sa, vốn khoảng 47 tỷ, làm đến 2027 – ngay phía trước Sun Saphia Residence.',
		'keyword'  => 'công viên biển Trường Sa Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Hòn Ngọc Á Châu thu hồi', 'công viên bãi tắm Sơn Thủy', 'công viên ven biển Ngũ Hành Sơn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-02 15:00',
		'category' => 'Hạ tầng & quy hoạch',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn', 'Hạ tầng Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/cong-vien-bien-truong-sa-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Trên đường Trường Sa (phường Ngũ Hành Sơn), khu đất phía Nam dự án resort <strong>Hòn Ngọc Á Châu</strong> – khởi công năm 2010 trên khoảng 12 ha rồi bỏ hoang nhiều năm – đang được chuyển thành <strong>công viên công cộng ven biển khoảng 2,45 ha</strong>. Đây cũng là khoảng đất ngay phía trước {$saphia}, tòa căn hộ 30 tầng của Sun Group tại giao lộ Võ Nguyên Giáp – Trường Sa.</p>
<!--hh-featured-->
<h2>Công viên có gì?</h2>
<table>
<tbody>
<tr><th>Diện tích</th><td>Khoảng 2,45 ha, mặt tiền đường Trường Sa</td></tr>
<tr><th>Nguồn đất</th><td>Thu hồi từ phần phía Nam dự án resort Hòn Ngọc Á Châu</td></tr>
<tr><th>Vốn</th><td>Khoảng 47 tỷ đồng (vốn đầu tư công)</td></tr>
<tr><th>Thời gian</th><td>Thực hiện đến 2027</td></tr>
<tr><th>Hạng mục</th><td>Bãi đỗ xe, đường đi bộ – chạy bộ, sân chơi trẻ em, quảng trường tổ chức sự kiện, cây xanh, nhà vệ sinh, khu tắm nước ngọt, lối xuống biển công cộng</td></tr>
</tbody>
</table>
<p>Gần đó còn dự án riêng "Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy", nối thành chuỗi công viên bãi tắm dọc tuyến biển: bãi tắm Sơn Thủy – công viên đối diện Sun Saphia – công viên bãi tắm cuối đường Huyền Trân Công Chúa.</p>
<h2>Ý nghĩa với người dân và du khách</h2>
<ul>
<li>Thêm lối xuống biển công cộng, chỗ đỗ xe – đoạn biển này trước đây bị rào chắn bởi khu đất bỏ hoang.</li>
<li>Không gian sự kiện, thể dục ven biển cho cư dân khu Sơn Thủy, Mỹ An, Khuê Mỹ.</li>
<li>Xử lý một "vết sẹo" đô thị tồn tại hơn 10 năm trên tuyến biển đẹp nhất thành phố.</li>
</ul>
<h2>Tác động tới Sun Saphia Residence – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Cảnh quan phía trước được giữ thoáng</strong>: thay vì một công trình cao tầng chắn view, phía trước là công viên – có lợi cho các căn hướng biển.</li>
<li><strong>Ra biển thuận tiện</strong>: từ dự án đi qua công viên khoảng 400 m là tới bãi tắm Sơn Thủy.</li>
<li><strong>Cho thuê</strong>: khách du lịch, gia đình có trẻ nhỏ đánh giá cao chỗ ở có công viên, lối biển công cộng ngay trước nhà.</li>
<li><strong>Lưu ý</strong>: trong thời gian thi công đến 2027 có thể ảnh hưởng đi lại; tiến độ công trình công phụ thuộc giải ngân vốn.</li>
</ul>
<p>Xem toàn bộ vị trí, view, giá và dòng tiền ở bài {$review}.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Công viên biển 2,45 ha Trường Sa trước Sun Saphia',
			'desc'      => 'Đà Nẵng thu hồi 2,45 ha đất dự án Hòn Ngọc Á Châu bỏ hoang làm công viên ven biển trên đường Trường Sa, vốn khoảng 47 tỷ, làm đến 2027.',
			'points'    => array(
				'Khoảng 2,45 ha thu hồi từ dự án resort Hòn Ngọc Á Châu bỏ hoang',
				'Vốn khoảng 47 tỷ, thực hiện đến 2027; có bãi đỗ xe, sân chơi, quảng trường, lối xuống biển',
				'Ngay phía trước Sun Saphia Residence, giữ thoáng view biển',
			),
			'faq'       => array(
				array( 'Công viên biển trên đường Trường Sa rộng bao nhiêu?', 'Khoảng 2,45 ha, trên phần đất thu hồi từ phía Nam dự án resort Hòn Ngọc Á Châu, vốn khoảng 47 tỷ đồng, thực hiện đến 2027.' ),
				array( 'Công viên biển Trường Sa ở đâu?', 'Trên đường Trường Sa, phường Ngũ Hành Sơn, ngay phía trước dự án Sun Saphia Residence, gần bãi tắm Sơn Thủy.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 03/11 – Thị trường khách sạn ---------------- */
	$posts[] = array(
		'slug'     => 'gia-phong-khach-san-ven-bien-da-nang-2026-sun-saphia',
		'title'    => 'Giá phòng khách sạn ven biển Đà Nẵng 2026: 5 sao, 4 sao, phố trong – căn studio Sun Saphia Residence đứng ở đâu?',
		'excerpt'  => 'Giá phòng tham khảo 10/2026: resort 5 sao mặt biển khoảng 3,7 – 3,9 triệu/đêm, 4 sao mặt biển 1,25 – 3,13 triệu, 2 – 3 sao phố trong 0,4 – 0,9 triệu. Khách sạn 4 – 5 sao lấp đầy 88 – 90% quý III/2026.',
		'keyword'  => 'giá phòng khách sạn ven biển Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'công suất phòng khách sạn Đà Nẵng 2026', 'giá thuê căn hộ theo đêm Đà Nẵng', 'thị trường khách sạn Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-03 15:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Thị trường lưu trú' ),
		'image'    => 'plugin:img/tin-tuc/gia-phong-khach-san-da-nang-2026.jpg',
		'content'  => <<<HTML
<p>Người mua căn hộ ven biển để cho thuê theo đêm cần một mốc so sánh: <strong>khách sạn quanh đó đang bán phòng giá bao nhiêu</strong>. Bài tổng hợp giá phòng tham khảo khu vực Mỹ Khê – Sơn Thủy – An Thượng tháng 10/2026, số liệu công suất thị trường và đặt studio {$saphia} vào bức tranh này.</p>
<!--hh-featured-->
<h2>Bảng giá phòng tham khảo (10/2026)</h2>
<table>
<thead><tr><th>Nhóm</th><th>Ví dụ</th><th>Giá/đêm</th></tr></thead>
<tbody>
<tr><td>Biệt thự biển 3 – 4 phòng ngủ</td><td>Furama, Hyatt</td><td>Khoảng 6 – 15 triệu (thấp điểm → cao điểm)</td></tr>
<tr><td>Resort 5 sao mặt biển</td><td>Hyatt Regency</td><td>Khoảng 3,7 – 3,9 triệu (phòng King)</td></tr>
<tr><td>4 sao mặt biển</td><td>Wyndham Soleil</td><td>Khoảng 2,28 – 3,13 triệu</td></tr>
<tr><td>4 sao mặt biển</td><td>Radisson</td><td>Khoảng 1,7 – 2,8 triệu</td></tr>
<tr><td>4 sao ven biển</td><td>Holiday Beach</td><td>Khoảng 1,25 – 2,64 triệu</td></tr>
<tr><td>Boutique phố trong</td><td>Khu An Thượng</td><td>Khoảng 1,8 – 2,4 triệu</td></tr>
<tr><td>2 – 3 sao phố trong</td><td>Khu An Thượng</td><td>Khoảng 0,4 – 0,9 triệu</td></tr>
</tbody>
</table>
<p>Giá lấy trên các trang đặt phòng, thay đổi theo ngày, hạng phòng và mùa; chỉ để tham khảo.</p>
<h2>Công suất phòng: khách sạn cao cấp đang đầy</h2>
<ul>
<li>Khách sạn 4 – 5 sao Đà Nẵng lấp đầy khoảng <strong>88 – 90%</strong> trong quý III/2026 (Avison Young).</li>
<li>Tính chung toàn thành phố 12 tháng đến 6/2026: công suất khoảng <strong>66%</strong>, giá phòng bình quân khoảng <strong>116 USD</strong> (CoStar).</li>
<li>Khách sạn của Sun Group tại miền Trung đạt công suất khoảng 81,3% năm 2026 (theo chủ đầu tư).</li>
<li>Áp lực: gần <strong>7.000 phòng mới</strong> sắp vào thị trường, có thể kéo giá phòng xuống ở phân khúc trung cấp.</li>
</ul>
<h2>Studio Sun Saphia Residence nằm ở đâu?</h2>
<p>Bài toán của chủ đầu tư giả định studio 30 m² view biển cho thuê khoảng <strong>2,2 – 2,9 triệu/đêm</strong> ngoài mùa cao điểm – ngang nhóm 4 sao mặt biển, thấp hơn resort 5 sao, cao hơn khách sạn phố trong không có view biển trực diện. Điểm cộng: tòa 30 tầng mặt dài hướng biển, có bếp, bể bơi, gym; điểm trừ: chưa vận hành, chưa có đánh giá thực tế trên các kênh đặt phòng.</p>
<h2>Đọc số liệu thế nào khi tính dòng tiền?</h2>
<ul>
<li>Công suất 88 – 90% là của khách sạn 4 – 5 sao đã vận hành lâu năm; căn hộ cho thuê mới nên giả định thấp hơn (50 – 65%).</li>
<li>Giá cao điểm (hè, lễ, pháo hoa) cao hơn nhiều giá bình quân năm – tính theo mùa thay vì một giá cố định.</li>
<li>Trừ phí kênh bán phòng, vận hành, thuế trước khi so với lãi vay.</li>
</ul>
<p>Ví dụ dòng tiền theo mùa cho studio Sun Saphia: xem bài {$review}.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá phòng khách sạn ven biển Đà Nẵng 2026 và Sun Saphia',
			'desc'      => 'Giá phòng 10/2026: resort 5 sao mặt biển khoảng 3,7 – 3,9 triệu/đêm, 4 sao 1,25 – 3,13 triệu; 4 – 5 sao lấp đầy 88 – 90% quý III/2026.',
			'points'    => array(
				'Resort 5 sao mặt biển khoảng 3,7 – 3,9 triệu/đêm; 4 sao mặt biển 1,25 – 3,13 triệu',
				'Khách sạn 4 – 5 sao lấp đầy 88 – 90% quý III/2026 (Avison Young)',
				'Studio Sun Saphia giả định 2,2 – 2,9 triệu/đêm – ngang nhóm 4 sao mặt biển',
			),
			'faq'       => array(
				array( 'Giá phòng khách sạn 4 sao ven biển Đà Nẵng bao nhiêu?', 'Tham khảo 10/2026: khoảng 1,25 – 3,13 triệu/đêm tùy khách sạn, hạng phòng và mùa (ví dụ Wyndham Soleil 2,28 – 3,13 triệu, Radisson 1,7 – 2,8 triệu).' ),
				array( 'Công suất phòng khách sạn Đà Nẵng 2026 là bao nhiêu?', 'Khách sạn 4 – 5 sao lấp đầy khoảng 88 – 90% quý III/2026 (Avison Young); toàn thành phố 12 tháng đến 6/2026 khoảng 66% (CoStar).' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 04/11 – So sánh loại hình đầu tư cho thuê ---------------- */
	$posts[] = array(
		'slug'     => 'dau-tu-cho-thue-da-nang-can-ho-luu-tru-biet-thu-nha-pho-shophouse',
		'title'    => 'Đầu tư cho thuê ở Đà Nẵng: căn hộ lưu trú như Sun Saphia Residence, biệt thự biển, nhà phố hay shophouse?',
		'excerpt'  => 'So sánh 4 loại hình cho thuê ở Đà Nẵng: shophouse mặt tiền (lợi suất khoảng 2 – 3%), nhà phố trung tâm (1,4 – 1,8%), biệt thự biển (3,6 – 5,5%) và căn hộ lưu trú vốn nhỏ như studio Sun Saphia Residence.',
		'keyword'  => 'đầu tư cho thuê Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'lợi suất cho thuê biệt thự biển Đà Nẵng', 'cho thuê shophouse Đà Nẵng', 'nên đầu tư loại bất động sản nào Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-04 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Đầu tư cho thuê' ),
		'image'    => 'plugin:img/tin-tuc/so-sanh-loai-hinh-cho-thue-da-nang.jpg',
		'content'  => <<<HTML
<p>Cùng là bất động sản cho thuê ở Đà Nẵng, mỗi loại hình có một bài toán rất khác: vốn vào, cách khai thác, lợi suất và rủi ro. Bài so sánh 4 loại hình phổ biến để nhà đầu tư chọn đúng theo mục tiêu – dòng tiền hay giữ tài sản. Số liệu là tham khảo 2026, lợi suất = tiền thuê năm ÷ giá mua.</p>
<!--hh-featured-->
<h2>Bảng so sánh</h2>
<table>
<thead><tr><th>Loại hình</th><th>Vốn vào</th><th>Cách khai thác</th><th>Lợi suất tham khảo</th><th>Lưu ý</th></tr></thead>
<tbody>
<tr><td>Shophouse mặt tiền</td><td>Khoảng 200 triệu/m²; căn 110 m² rao khoảng 22 tỷ</td><td>Cho thuê dài hạn 10 – 100 triệu/tháng</td><td>Khoảng 2 – 3%</td><td>Nhiều căn bỏ trống, phụ thuộc khách thuê kinh doanh</td></tr>
<tr><td>Nhà phố trung tâm (đường nhỏ)</td><td>Khoảng 10 tỷ</td><td>Thuê nguyên căn 12 – 15 triệu/tháng</td><td>Khoảng 1,4 – 1,8%</td><td>Chia căn hộ dịch vụ vướng thủ tục, phòng cháy, tự vận hành</td></tr>
<tr><td>Biệt thự biển</td><td>30 – 60 tỷ (ví dụ Furama, trung bình khoảng 35 tỷ)</td><td>Thấp điểm khoảng 6 triệu, cao điểm 12 – 15 triệu/đêm</td><td>Khoảng 3,6 – 5,5%</td><td>Vốn lớn, thanh khoản chậm; có đất, giữ tài sản tốt</td></tr>
<tr><td>Căn hộ lưu trú (studio)</td><td>Studio {$saphia} dự kiến 2,13 – 2,85 tỷ</td><td>Cho thuê theo đêm qua đơn vị vận hành</td><td>Tùy lấp đầy – xem ví dụ dưới</td><td>Lấp đầy theo mùa, phí kênh, phí vận hành, thời hạn 50 năm</td></tr>
</tbody>
</table>
<p>Giá shophouse, biệt thự là giá rao 2026 (báo chí, trang tin bất động sản); giá thuê nhà phố, biệt thự theo khảo sát thực tế của Hoàng Hiệp. Lợi suất biệt thự đã trừ khoảng 35% chi phí vận hành.</p>
<h2>Vì sao căn hộ lưu trú cho lợi suất cao hơn?</h2>
<p>Giá thuê theo đêm của một studio view biển (khoảng 2,2 – 2,9 triệu ngoài cao điểm theo giả định của chủ đầu tư) gần bằng giá thuê tính theo mỗi phòng ngủ của biệt thự biển, nhưng vốn vào nhỏ hơn hàng chục lần. Ví dụ theo mùa (180 đêm thấp điểm, 180 đêm cao điểm, chủ nhà nhận 65%): studio có thể mang về khoảng 261 – 328 triệu/năm trước thuế, phí và khấu hao – chi tiết ở bài {$review}. Đổi lại, dòng tiền này phụ thuộc lấp đầy và chất lượng vận hành, không ổn định như hợp đồng thuê dài hạn.</p>
<h2>Chọn theo mục tiêu</h2>
<ul>
<li><strong>Cần dòng tiền với vốn 2 – 3 tỷ</strong>: căn hộ lưu trú ven biển; chia vốn mua 2 – 3 căn ở vị trí khác nhau để giảm rủi ro.</li>
<li><strong>Giữ tài sản, đất lâu dài</strong>: biệt thự, nhà phố, shophouse – lợi suất thấp nhưng có đất, nhiều căn sổ lâu dài.</li>
<li><strong>Cho thuê ổn định, ít công quản lý</strong>: căn hộ để ở cho thuê dài hạn (lợi suất căn hộ Đà Nẵng khoảng 4,5%/năm theo Batdongsan.com.vn quý 3/2026).</li>
</ul>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đầu tư cho thuê Đà Nẵng: căn hộ, biệt thự hay nhà phố?',
			'desc'      => 'So sánh đầu tư cho thuê Đà Nẵng 2026: shophouse lợi suất 2 – 3%, nhà phố 1,4 – 1,8%, biệt thự biển 3,6 – 5,5%, căn hộ lưu trú như Sun Saphia Residence.',
			'points'    => array(
				'Shophouse mặt tiền khoảng 200 triệu/m², lợi suất khoảng 2 – 3%',
				'Nhà phố trung tâm 10 tỷ cho thuê 12 – 15 triệu/tháng, lợi suất 1,4 – 1,8%',
				'Biệt thự biển 30 – 60 tỷ, lợi suất 3,6 – 5,5%; căn hộ lưu trú vốn nhỏ, lợi suất phụ thuộc lấp đầy',
			),
			'faq'       => array(
				array( 'Đầu tư cho thuê ở Đà Nẵng loại hình nào lợi suất cao nhất?', 'Căn hộ lưu trú cho thuê theo đêm thường cho lợi suất cao nhất trên vốn bỏ ra nhưng phụ thuộc lấp đầy và vận hành; biệt thự biển khoảng 3,6 – 5,5%, shophouse 2 – 3%, nhà phố trung tâm 1,4 – 1,8% (tham khảo 2026).' ),
				array( 'Biệt thự biển Đà Nẵng cho thuê được bao nhiêu?', 'Ví dụ Furama Villas: giá mua khoảng 30 – 60 tỷ, cho thuê khoảng 6 triệu/đêm thấp điểm, 12 – 15 triệu cao điểm; lợi suất ròng khoảng 3,6 – 5,5%.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 05/11 – Xây, mua khách sạn hay mua căn lưu trú ---------------- */
	$posts[] = array(
		'slug'     => 'dau-tu-khach-san-da-nang-xay-moi-mua-lai-hay-mua-can-luu-tru',
		'title'    => 'Đầu tư khách sạn ở Đà Nẵng: xây mới, mua lại hay mua căn lưu trú như Sun Saphia Residence?',
		'excerpt'  => 'Muốn có khách sạn ở Đà Nẵng: xây mới 3 sao 30 – 50 phòng tốn khoảng 15 – 30 tỷ chưa gồm đất, mất 2 – 3 năm; khách sạn 3 sao 50 phòng rao khoảng 67 tỷ; hoặc mua một căn lưu trú mặt biển như Sun Saphia Residence từ khoảng 2,1 tỷ.',
		'keyword'  => 'đầu tư khách sạn Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'chi phí xây khách sạn 3 sao', 'mua khách sạn Đà Nẵng', 'thủ tục kinh doanh khách sạn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-05 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Đầu tư khách sạn' ),
		'image'    => 'plugin:img/tin-tuc/dau-tu-khach-san-da-nang.jpg',
		'content'  => <<<HTML
<p>Du lịch Đà Nẵng tăng mạnh năm 2026 khiến nhiều nhà đầu tư tính chuyện có "một khách sạn của riêng mình". Có ba con đường: tự xây, mua lại khách sạn đang chạy, hoặc mua căn lưu trú trong một tòa có đơn vị vận hành như {$saphia}. Bài so sánh vốn, thời gian, thủ tục và rủi ro của từng cách. Số liệu là giá rao, báo giá tham khảo 2026.</p>
<!--hh-featured-->
<h2>Bảng so sánh ba con đường</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Xây khách sạn mới</th><th>Mua lại khách sạn</th><th>Mua căn lưu trú</th></tr></thead>
<tbody>
<tr><td>Vốn</td><td>3 sao 30 – 50 phòng khoảng 15 – 30 tỷ; 4 sao 80 – 120 phòng khoảng 60 – 120 tỷ (chưa gồm đất)</td><td>3 sao 50 phòng ở Hải Châu rao khoảng 67 tỷ; 4 sao 17 tầng gần Mỹ Khê rao khoảng 250 tỷ</td><td>Studio Sun Saphia dự kiến 2,13 – 2,85 tỷ/căn</td></tr>
<tr><td>Thời gian có doanh thu</td><td>2 – 3 năm</td><td>Ngay, thường phải cải tạo</td><td>Từ khi bàn giao (dự kiến 11/2028)</td></tr>
<tr><td>Thủ tục</td><td>Giấy phép xây dựng, thẩm duyệt – nghiệm thu phòng cháy, điều kiện an ninh trật tự, đăng ký kinh doanh lưu trú, xếp hạng sao (TCVN 4391:2015)</td><td>Kiểm tra pháp lý đất, phòng cháy, giấy phép sẵn có</td><td>Ký hợp đồng mua bán; chủ đầu tư lo pháp lý dự án</td></tr>
<tr><td>Vận hành</td><td>Tự tuyển nhân sự, tự bán phòng</td><td>Tiếp quản đội cũ hoặc thuê quản lý</td><td>Đơn vị vận hành chuyên nghiệp, chia doanh thu</td></tr>
<tr><td>Rủi ro chính</td><td>Vượt vốn, chậm tiến độ, thiếu kinh nghiệm</td><td>Xuống cấp, cạnh tranh gần 7.000 phòng mới</td><td>Lấp đầy theo mùa, phí vận hành, thời hạn 50 năm</td></tr>
</tbody>
</table>
<h2>Khi nào nên tự xây hoặc mua lại?</h2>
<ul>
<li>Có vốn lớn, có đất hoặc tìm được khách sạn giá hợp lý, và có kinh nghiệm (hoặc đối tác) vận hành.</li>
<li>Muốn toàn quyền thương hiệu, giá phòng, và sở hữu đất – tài sản giữ được lâu dài.</li>
</ul>
<h2>Khi nào căn lưu trú hợp hơn?</h2>
<ul>
<li>Vốn 2 – 3 tỷ, muốn "sở hữu một phòng khách sạn mặt biển" mà không tự xin phép, tự vận hành.</li>
<li>Chấp nhận chia doanh thu cho đơn vị vận hành và phụ thuộc vào chất lượng vận hành của họ.</li>
<li>Muốn chia nhỏ vốn: cùng 30 tỷ có thể mua nhiều căn ở các vị trí khác nhau thay vì một khách sạn nhỏ.</li>
</ul>
<p>Lưu ý: giá khách sạn trên là giá rao, không phải giá giao dịch; chi phí xây dựng theo báo giá các đơn vị thiết kế – thi công 2026, thay đổi theo tiêu chuẩn. Ví dụ dòng tiền một căn studio: xem bài {$review}.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đầu tư khách sạn Đà Nẵng: xây, mua lại hay mua căn lưu trú',
			'desc'      => 'Đầu tư khách sạn Đà Nẵng: xây 3 sao 30 – 50 phòng khoảng 15 – 30 tỷ chưa gồm đất, mua lại 3 sao rao 67 tỷ, hay căn lưu trú Sun Saphia từ khoảng 2,1 tỷ.',
			'points'    => array(
				'Xây khách sạn 3 sao 30 – 50 phòng khoảng 15 – 30 tỷ chưa gồm đất, mất 2 – 3 năm',
				'Khách sạn 3 sao 50 phòng ở Hải Châu rao khoảng 67 tỷ',
				'Căn lưu trú Sun Saphia dự kiến 2,13 – 2,85 tỷ, có đơn vị vận hành',
			),
			'faq'       => array(
				array( 'Xây khách sạn 3 sao ở Đà Nẵng tốn bao nhiêu?', 'Tham khảo báo giá 2026: khách sạn 2 – 3 sao 30 – 50 phòng khoảng 15 – 30 tỷ, chưa gồm tiền đất; mất khoảng 2 – 3 năm từ thủ tục đến khi đón khách.' ),
				array( 'Kinh doanh khách sạn cần những thủ tục gì?', 'Giấy phép xây dựng, thẩm duyệt và nghiệm thu phòng cháy chữa cháy, giấy chứng nhận đủ điều kiện an ninh trật tự, đăng ký kinh doanh dịch vụ lưu trú và xếp hạng sao theo TCVN 4391:2015.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 06/11 – Phí kênh bán phòng ---------------- */
	$posts[] = array(
		'slug'     => 'phi-booking-agoda-airbnb-cho-thue-can-ho-sun-saphia',
		'title'    => 'Phí Booking, Agoda, Airbnb khi cho thuê căn hộ: mỗi % hoa hồng ăn bao nhiêu vào lợi nhuận studio Sun Saphia Residence?',
		'excerpt'  => 'Hoa hồng kênh đặt phòng: Booking.com 15 – 18%, Agoda 12 – 20%, Airbnb 3% nếu chia phí với khách, Expedia 15 – 17%. Tham gia hết khuyến mãi có thể đẩy chi phí lên 25 – 30%. Giảm 5% phí kênh có thể thêm khoảng 25 triệu/năm cho một studio.',
		'keyword'  => 'phí Booking Agoda Airbnb cho thuê căn hộ',
		'keywords_extra' => array( 'Sun Saphia Residence', 'hoa hồng Booking.com', 'phí Airbnb chủ nhà', 'kênh OTA cho thuê căn hộ Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-06 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Cho thuê căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/phi-kenh-dat-phong-cho-thue.jpg',
		'content'  => <<<HTML
<p>Khi cho thuê căn hộ theo đêm, phần lớn khách đến từ các kênh đặt phòng trực tuyến (OTA). Mỗi kênh thu hoa hồng khác nhau, và chỉ vài phần trăm chênh lệch đã đổi đáng kể lợi nhuận cả năm. Bài tổng hợp mức phí phổ biến 2026 và cách tính cho một studio như {$saphia}.</p>
<!--hh-featured-->
<h2>Hoa hồng các kênh phổ biến</h2>
<table>
<thead><tr><th>Kênh</th><th>Hoa hồng phổ biến</th><th>Khách chính</th></tr></thead>
<tbody>
<tr><td>Booking.com</td><td>15 – 18%</td><td>Quốc tế, châu Âu</td></tr>
<tr><td>Agoda</td><td>12 – 20%</td><td>Châu Á, Hàn Quốc, Nhật Bản – kênh mạnh ở Đà Nẵng</td></tr>
<tr><td>Airbnb</td><td>3% nếu chia phí với khách · 14 – 16% nếu chủ chịu toàn bộ</td><td>Nhóm bạn, gia đình, ở dài ngày</td></tr>
<tr><td>Traveloka</td><td>Khoảng 14 – 18%</td><td>Khách nội địa, Đông Nam Á</td></tr>
<tr><td>Expedia</td><td>15 – 17%</td><td>Mỹ, Úc</td></tr>
<tr><td>Đặt trực tiếp</td><td>0% (cộng chi phí marketing)</td><td>Khách quen, Zalo, website</td></tr>
</tbody>
</table>
<p>Mức phí tổng hợp từ các trang quản lý khách sạn 2026, thay đổi theo hợp đồng từng kênh.</p>
<h2>Bẫy khuyến mãi</h2>
<p>Các chương trình như giảm giá thành viên, ưu đãi bí mật, khuyến mãi theo mùa giúp tăng hiển thị nhưng cộng dồn với hoa hồng, chi phí thực có thể lên <strong>25 – 30% doanh thu</strong>. Tham gia có chọn lọc theo mùa thay vì bật tất cả.</p>
<h2>Mỗi % phí đáng bao nhiêu tiền?</h2>
<p>Ví dụ minh hoạ: studio doanh thu khoảng 504 triệu/năm (180 đêm thấp điểm 1,2 triệu × 50%, 180 đêm cao điểm 2,75 triệu × 80%). Giảm 5% phí kênh nghĩa là thêm khoảng <strong>25 triệu/năm</strong> – tương đương hơn 1% lợi suất trên căn giá khoảng 2,1 tỷ.</p>
<h2>Câu nên hỏi đơn vị vận hành</h2>
<ol>
<li>Phí vận hành bao nhiêu % doanh thu, đã gồm hoa hồng kênh chưa?</li>
<li>Bán qua những kênh nào, tỷ lệ khách đặt trực tiếp mục tiêu bao nhiêu?</li>
<li>Báo cáo doanh thu, công suất cho chủ nhà hằng tháng thế nào, có xem được dữ liệu từng kênh không?</li>
<li>Chủ nhà có được tự ở bao nhiêu đêm mỗi năm, đặt trước bao lâu?</li>
</ol>
<p>Xem bài toán dòng tiền đầy đủ ở bài {$review}.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Phí Booking, Agoda, Airbnb khi cho thuê căn hộ theo đêm',
			'desc'      => 'Hoa hồng OTA 2026: Booking.com 15 – 18%, Agoda 12 – 20%, Airbnb 3% (chia phí), Expedia 15 – 17%. Mỗi 5% phí có thể bằng 25 triệu/năm với studio Sun Saphia.',
			'points'    => array(
				'Booking.com 15 – 18%, Agoda 12 – 20%, Airbnb 3% nếu chia phí với khách',
				'Cộng khuyến mãi, chi phí kênh có thể lên 25 – 30% doanh thu',
				'Giảm 5% phí kênh ≈ thêm 25 triệu/năm cho một studio doanh thu 504 triệu',
			),
			'faq'       => array(
				array( 'Booking.com thu phí chủ nhà bao nhiêu?', 'Hoa hồng phổ biến khoảng 15 – 18% giá phòng, tùy hợp đồng và chương trình tham gia.' ),
				array( 'Airbnb thu phí chủ nhà bao nhiêu?', 'Khoảng 3% nếu chọn chia phí dịch vụ với khách; khoảng 14 – 16% nếu chủ nhà chịu toàn bộ phí.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 07/11 – Công trình cấp I ---------------- */
	$posts[] = array(
		'slug'     => 'cong-trinh-cap-1-la-gi-nien-han-100-nam-sun-saphia-residence',
		'title'    => 'Công trình cấp I là gì? Tòa 30 tầng Sun Saphia Residence và niên hạn sử dụng 100 năm',
		'excerpt'  => 'Theo Thông tư 06/2021/TT-BXD, nhà cao trên 75 – 200 m hoặc 25 – 50 tầng là công trình cấp I. Sun Saphia Residence 30 tầng, cao khoảng 114 m thuộc cấp I, chủ đầu tư công bố niên hạn sử dụng 100 năm. Ý nghĩa với người mua căn 50 năm.',
		'keyword'  => 'công trình cấp I là gì',
		'keywords_extra' => array( 'Sun Saphia Residence', 'niên hạn sử dụng chung cư', 'phân cấp công trình Thông tư 06/2021', 'căn hộ 50 năm niên hạn 100 năm' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-07 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/tin-tuc/cong-trinh-cap-1-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Tài liệu dự án {$saphia} ghi "công trình cấp I, niên hạn sử dụng 100 năm" bên cạnh "thời hạn dự án 50 năm". Nhiều người mua hỏi: cấp I nghĩa là gì, và 100 năm khác 50 năm thế nào? Bài giải thích ngắn gọn.</p>
<!--hh-featured-->
<h2>Phân cấp nhà theo chiều cao, số tầng</h2>
<table>
<thead><tr><th>Cấp</th><th>Chiều cao</th><th>Số tầng</th></tr></thead>
<tbody>
<tr><td>Đặc biệt</td><td>Trên 200 m</td><td>Trên 50 tầng</td></tr>
<tr><td><strong>Cấp I</strong></td><td><strong>Trên 75 – 200 m</strong></td><td><strong>25 – 50 tầng</strong></td></tr>
<tr><td>Cấp II</td><td>Trên 28 – 75 m</td><td>8 – 24 tầng</td></tr>
<tr><td>Cấp III</td><td>6 – 28 m</td><td>2 – 7 tầng</td></tr>
<tr><td>Cấp IV</td><td>Đến 6 m</td><td>1 tầng</td></tr>
</tbody>
</table>
<p>Theo Thông tư 06/2021/TT-BXD (Phụ lục II), đã được sửa đổi, bổ sung năm 2025. Sun Saphia Residence 30 tầng, cao khoảng 114 m nên thuộc <strong>cấp I</strong>.</p>
<h2>Cấp công trình nói lên điều gì?</h2>
<ul>
<li>Cấp càng cao, yêu cầu về kết cấu, phòng cháy chữa cháy, thẩm định thiết kế càng khắt khe.</li>
<li>Nhà cấp I thường được thiết kế với tuổi thọ dài – chủ đầu tư Sun Saphia công bố niên hạn sử dụng <strong>100 năm</strong>.</li>
<li>Theo quy định hiện hành, thời hạn sử dụng nhà chung cư xác định theo hồ sơ thiết kế, ghi trong văn bản thẩm định – không tự suy ra từ bảng phân cấp. Người mua nên hỏi văn bản thẩm định thiết kế làm căn cứ cho con số 100 năm.</li>
</ul>
<h2>Niên hạn 100 năm và thời hạn 50 năm khác nhau thế nào?</h2>
<table>
<thead><tr><th></th><th>Thời hạn dự án (đất)</th><th>Niên hạn công trình</th></tr></thead>
<tbody>
<tr><td>Sun Saphia</td><td>50 năm kể từ 17/09/2026</td><td>100 năm</td></tr>
<tr><td>Ý nghĩa</td><td>Thời gian được sử dụng đất của dự án; hết hạn có thể được xem xét gia hạn</td><td>Tuổi thọ thiết kế của tòa nhà</td></tr>
</tbody>
</table>
<p>Tòa nhà được thiết kế bền lâu hơn thời hạn đất – đây là lý do Nghị quyết 278/NQ-CP (18/9/2026) giao các bộ làm rõ thời hạn sử dụng chung cư theo niên hạn công trình và quyền của người sở hữu khi hết thời hạn. Chi tiết: <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia – sở hữu bao lâu</a>.</p>
<p>Đọc tổng hợp vị trí, giá, dòng tiền: {$review}.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Công trình cấp I là gì? Sun Saphia và niên hạn 100 năm',
			'desc'      => 'Công trình cấp I theo Thông tư 06/2021: nhà cao trên 75 – 200 m hoặc 25 – 50 tầng. Sun Saphia Residence 30 tầng thuộc cấp I, niên hạn 100 năm.',
			'points'    => array(
				'Cấp I: cao trên 75 – 200 m hoặc 25 – 50 tầng (Thông tư 06/2021/TT-BXD)',
				'Sun Saphia 30 tầng, khoảng 114 m – cấp I, chủ đầu tư công bố niên hạn 100 năm',
				'Niên hạn công trình khác thời hạn dự án 50 năm',
			),
			'faq'       => array(
				array( 'Công trình cấp I là gì?', 'Theo Thông tư 06/2021/TT-BXD, nhà có chiều cao trên 75 – 200 m hoặc 25 – 50 tầng thuộc công trình cấp I.' ),
				array( 'Sun Saphia Residence thuộc cấp công trình nào?', 'Tòa 30 tầng, cao khoảng 114 m nên thuộc cấp I; chủ đầu tư công bố niên hạn sử dụng 100 năm, thời hạn dự án 50 năm kể từ 17/09/2026.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
