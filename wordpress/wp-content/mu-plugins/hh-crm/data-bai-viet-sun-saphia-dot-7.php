<?php
/**
 * Sun Saphia Residence đợt 7 – 7 bài, 09/11 – 11/11/2026, 3 bài/ngày (08:00, 11:30, 16:30): chọn dãy căn (mặt biển / cánh bên / phía sau),
 * mùa du lịch và lấp đầy, thị trường khách quốc tế, tự cho thuê hay thuê đơn vị vận hành, chi phí nội thất studio,
 * nâng cấp sân bay Đà Nẵng, căn 2PN cho gia đình. Mỗi bài dẫn về trang dự án và bài đánh giá chi tiết.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Số liệu thị trường theo báo chí / đơn vị nêu trong từng bài (tra cứu 08/11/2026); giá dự án là giá dự kiến chủ đầu tư 28/10/2026.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_7' );
function hh_posts_sun_saphia_dot_7( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$review = '<a href="/danh-gia-sun-saphia-residence-chi-tiet/">đánh giá chi tiết Sun Saphia Residence</a>';
	$cta    = '<p>Cần mặt bằng, bảng giá và bảng tính dòng tiền ' . $saphia . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 13/11 – Chọn dãy căn ---------------- */
	$posts[] = array(
		'slug'     => 'chon-day-can-sun-saphia-residence-mat-bien-canh-ben-phia-sau',
		'title'    => 'Chọn căn Sun Saphia Residence: dãy mặt biển, cánh bên hay phía sau – chênh 240 – 720 triệu có đáng?',
		'excerpt'  => 'Cùng studio 30 m² tầng 15, giá dự kiến Sun Saphia Residence là 2,13 tỷ (phía sau), 2,37 tỷ (cánh bên) và 2,85 tỷ (mặt biển). Phân tích chênh lệch, dòng tiền cho thuê và ai nên chọn dãy nào.',
		'keyword'  => 'chọn căn Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ view biển Đà Nẵng', 'studio mặt biển Sơn Thủy', 'chênh lệch giá căn view biển' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-09 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ ven biển', 'Kinh nghiệm chọn căn' ),
		'image'    => 'plugin:img/tin-tuc/chon-day-can-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Một tầng điển hình của {$saphia} (tầng 3A – 28) có 28 căn: 19 studio, 4 căn 1PN+ và 5 căn 2PN. Cùng một căn studio 30 m², giá dự kiến chủ đầu tư đưa ra ngày 28/10/2026 khác nhau khá rõ theo vị trí trên sàn. Câu hỏi nhiều anh chị đặt ra: bỏ thêm vài trăm triệu để lấy view biển có đáng không?</p>
<!--hh-featured-->
<h2>Giá dự kiến studio 30 m² tầng 15 theo từng dãy</h2>
<table>
<thead><tr><th>Dãy căn</th><th>Giá dự kiến</th><th>Chênh so với phía sau</th></tr></thead>
<tbody>
<tr><td>Dãy phía sau</td><td>2,13 tỷ</td><td>–</td></tr>
<tr><td>Cánh bên</td><td>2,37 tỷ</td><td>+240 triệu (khoảng +11%)</td></tr>
<tr><td>Dãy mặt biển</td><td>2,85 tỷ</td><td>+720 triệu (khoảng +34%)</td></tr>
</tbody>
</table>
<p>Giá trên là giá dự kiến có vay, chưa VAT và 2% phí bảo trì; bảng giá chính thức công bố khi mở bán. Phần trăm chênh lệch do Hoàng Hiệp tính từ các con số này.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence: dãy phía Đông hướng biển, 2PN ở các góc (bản vẽ chủ đầu tư)-->
<h2>Dãy mặt biển phải cho thuê đắt hơn bao nhiêu mới "hòa"?</h2>
<p>Nếu muốn giữ cùng tỷ suất cho thuê như căn phía sau, doanh thu căn mặt biển phải cao hơn đúng tỷ lệ chênh giá:</p>
<ul>
<li>Cánh bên: doanh thu cần cao hơn khoảng <strong>11%</strong>.</li>
<li>Mặt biển: doanh thu cần cao hơn khoảng <strong>34%</strong> – ví dụ căn phía sau thu 2 triệu/đêm thì căn mặt biển cần khoảng 2,7 triệu/đêm với cùng tỷ lệ lấp đầy.</li>
</ul>
<p>Trên thực tế, phòng view biển trực diện thường bán được giá cao hơn và kín phòng sớm hơn vào mùa cao điểm, nhưng mức chênh tùy thời điểm và cách vận hành – anh chị nên tự kiểm tra giá các phòng view biển và không view ở khu Sơn Thủy – Mỹ Khê trên các kênh đặt phòng trước khi quyết định. Chi phí kênh đặt phòng xem thêm bài <a href="/phi-booking-agoda-airbnb-cho-thue-can-ho-sun-saphia/">phí Booking, Agoda, Airbnb</a>.</p>
<h2>Nhận định của Hoàng Hiệp: ai hợp dãy nào?</h2>
<ul>
<li><strong>Dãy mặt biển</strong> – hợp người mua để nghỉ dưỡng, ở một phần thời gian, hoặc muốn tài sản dễ bán lại nhất sau này. View biển là thứ không thể "làm thêm" sau khi mua.</li>
<li><strong>Cánh bên</strong> – cân bằng: chênh khoảng 11% nhưng vẫn có góc nhìn ra biển hoặc ra phố, hợp người vừa ở vừa cho thuê.</li>
<li><strong>Dãy phía sau</strong> – vốn thấp nhất, hợp người đầu tư cho thuê thuần túy, ưu tiên tổng số tiền bỏ ra và vay ít.</li>
<li><strong>Tầng</strong>: cùng dãy, tầng càng cao giá thường càng tăng; tầng trung (khoảng 10 – 20) thường cân bằng giữa view và giá.</li>
</ul>
<p>Giá chi tiết từng tầng xem bài <a href="/gia-sun-saphia-residence-bao-nhieu/">Giá Sun Saphia Residence bao nhiêu?</a>, mặt bằng từng loại căn xem <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence</a>, toàn cảnh dự án ở bài {$review}.</p>
{$cta}
<p class="src">Nguồn: giá dự kiến và mặt bằng theo tài liệu chủ đầu tư (28/10/2026); tỷ lệ chênh lệch và ví dụ do Hoàng Hiệp tính, mang tính minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chọn căn Sun Saphia: mặt biển, cánh bên hay phía sau?',
			'desc'      => 'Studio 30 m² Sun Saphia Residence tầng 15: 2,13 tỷ phía sau, 2,37 tỷ cánh bên, 2,85 tỷ mặt biển. Chênh 11 – 34%, cho thuê cần cao hơn bao nhiêu?',
			'points'    => array(
				'Giá dự kiến studio 30 m² tầng 15: 2,13 / 2,37 / 2,85 tỷ',
				'Căn mặt biển cần doanh thu cao hơn khoảng 34% để có cùng tỷ suất',
				'Mặt biển hợp nghỉ dưỡng, cánh bên cân bằng, phía sau hợp cho thuê vốn thấp',
			),
			'faq'       => array(
				array( 'Studio Sun Saphia Residence mặt biển đắt hơn bao nhiêu?', 'Theo giá dự kiến 28/10/2026, studio 30 m² tầng 15 dãy mặt biển khoảng 2,85 tỷ, cao hơn dãy phía sau (2,13 tỷ) khoảng 720 triệu.' ),
				array( 'Đầu tư cho thuê nên chọn dãy nào ở Sun Saphia Residence?', 'Nếu ưu tiên vốn thấp chọn dãy phía sau; nếu muốn cân bằng chọn cánh bên; căn mặt biển phải cho thuê cao hơn khoảng 34% mới có cùng tỷ suất.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 14/11 – Mùa du lịch ---------------- */
	$posts[] = array(
		'slug'     => 'mua-du-lich-da-nang-cong-suat-phong-cho-thue-sun-saphia',
		'title'    => 'Mùa du lịch Đà Nẵng: tháng nào kín phòng, tháng nào vắng – tính lấp đầy cho studio Sun Saphia Residence',
		'excerpt'  => 'Hè và mùa pháo hoa DIFF công suất phòng ven biển Đà Nẵng 75 – 98%, nhưng cả năm bình quân khoảng 66%. Cách tính lấp đầy theo mùa khi cho thuê studio Sun Saphia Residence.',
		'keyword'  => 'cho thuê Sun Saphia Residence theo mùa',
		'keywords_extra' => array( 'mùa du lịch Đà Nẵng công suất phòng', 'Sun Saphia Residence', 'công suất phòng khách sạn Đà Nẵng', 'cho thuê căn hộ theo mùa Đà Nẵng', 'DIFF 2026 kín phòng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Du lịch Đà Nẵng', 'Cho thuê căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/mua-du-lich-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Ai cho thuê căn hộ ven biển Đà Nẵng cũng nhận ra: có tháng kín phòng phải từ chối khách, có tháng gần như trống. Muốn tính dòng tiền cho một căn studio như {$saphia} cho thực tế, cần nhìn theo <strong>mùa</strong> chứ không chỉ một con số lấp đầy chung.</p>
<!--hh-featured-->
<h2>Các mốc công suất phòng đáng tin cậy</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Công suất phòng</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Hè 2025 (tháng 6 – 8)</td><td>Bình quân 75 – 80%, cuối tuần và lễ gần kín</td><td>Đại diện khách sạn, Báo Văn hóa</td></tr>
<tr><td>Dịp 30/4 – 1/5/2026</td><td>Toàn thành phố 75 – 80%; khách sạn 4 – 5 sao 90 – 95%</td><td>Báo chí tổng hợp</td></tr>
<tr><td>Mùa pháo hoa DIFF 2026</td><td>Ven biển 85 – 95% các đêm pháo hoa; đêm chung kết khu trung tâm 95 – 98%; hơn 2,72 triệu lượt khách cả mùa lễ hội</td><td>Hội Khách sạn Đà Nẵng, Sở VH-TT-DL (SGGP, Công Thương)</td></tr>
<tr><td>12 tháng đến 6/2026</td><td>Bình quân hơn 66%, giá phòng bình quân khoảng 116 USD</td><td>CoStar (qua báo chí)</td></tr>
</tbody>
</table>
<p>Con số bình quân năm thấp hơn hẳn các đỉnh mùa hè – nghĩa là các tháng mùa mưa (thường từ khoảng tháng 9 đến cuối năm ở Đà Nẵng) kéo trung bình xuống đáng kể.</p>
<!--hh-img:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg|Ảnh thực tế: sông Hàn, du thuyền và cầu Rồng về đêm – Đà Nẵng đông khách nhất vào mùa hè và mùa pháo hoa-->
<h2>Tính lấp đầy theo mùa cho một studio</h2>
<p>Tài liệu chủ đầu tư dùng giả định 60% cả năm. Anh chị có thể tự kiểm tra giả định này bằng cách chia năm thành mùa, ví dụ (minh hoạ, không phải số liệu thực tế của dự án):</p>
<ul>
<li>Mùa cao điểm (tháng 4 – 8, khoảng 5 tháng): lấp đầy giả định 80%.</li>
<li>Mùa trung bình (tháng 1 – 3): giả định 55%.</li>
<li>Mùa mưa (tháng 9 – 12): giả định 35%.</li>
</ul>
<p>Bình quân gia quyền theo số tháng ra khoảng <strong>(5×80 + 3×55 + 4×35) ÷ 12 ≈ 59%</strong> – gần với giả định 60% của chủ đầu tư. Nếu mùa mưa chỉ được 20%, bình quân giảm còn khoảng 54%. Giá phòng cũng biến động theo mùa, nên doanh thu chênh còn lớn hơn mức lấp đầy.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Kiếm tiền chính vào 5 – 6 tháng</strong>: định giá linh hoạt, mở bán phòng sớm cho mùa pháo hoa và hè.</li>
<li><strong>Mùa mưa nên cho thuê dài hơn</strong>: thuê theo tuần, theo tháng cho người làm việc từ xa, chuyên gia – giảm trống phòng.</li>
<li><strong>Nguồn cung tăng</strong>: báo chí dẫn số liệu khoảng 18 dự án khách sạn đang xây, thêm khoảng 6.835 phòng – cạnh tranh sẽ gắt hơn, căn có view và tiện ích tốt sẽ giữ giá tốt hơn.</li>
</ul>
<p>Xem thêm <a href="/khach-du-lich-da-nang-2026-nhu-cau-thue-can-ho-ven-bien/">lượng khách du lịch Đà Nẵng 2026</a>, <a href="/gia-phong-khach-san-ven-bien-da-nang-2026-sun-saphia/">giá phòng khách sạn ven biển</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Báo Văn hóa (hè 2025); SGGP, Tạp chí Công Thương (DIFF 2026, Sở VH-TT-DL Đà Nẵng, Hội Khách sạn Đà Nẵng); CoStar qua báo chí (12 tháng đến 6/2026); TheLEADER (nguồn cung phòng mới). Ví dụ tính lấp đầy theo mùa do Hoàng Hiệp minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mùa du lịch Đà Nẵng: lấp đầy studio Sun Saphia',
			'desc'      => 'Hè và DIFF công suất phòng ven biển Đà Nẵng 75 – 98%, cả năm khoảng 66%. Cách tính lấp đầy theo mùa khi cho thuê studio Sun Saphia Residence.',
			'points'    => array(
				'Hè 75 – 80%, mùa pháo hoa DIFF 85 – 98%',
				'Bình quân 12 tháng đến 6/2026 hơn 66% (CoStar)',
				'Giả định 60% của chủ đầu tư cần kiểm tra theo mùa',
			),
			'faq'       => array(
				array( 'Tháng nào Đà Nẵng đông khách nhất?', 'Mùa hè (tháng 6 – 8) và mùa pháo hoa DIFF; công suất phòng ven biển các đêm pháo hoa 2026 khoảng 85 – 95%.' ),
				array( 'Cho thuê căn hộ Đà Nẵng lấp đầy bình quân bao nhiêu?', 'Khối khách sạn bình quân 12 tháng đến 6/2026 hơn 66% theo CoStar; căn hộ cho thuê lẻ phụ thuộc cách vận hành, mùa mưa thường thấp.' ),
			),
		),
		'sources'  => array(
			'https://baovanhoa.vn/nang-cao-chat-luong-du-lich-da-nang-bung-no-khach-he-2025-160231.html',
			'https://www.sggp.org.vn/diff-2026-thu-hut-hon-27-trieu-luot-khach-nhieu-khach-san-kin-phong-post861962.html',
			'https://congthuong.vn/da-nang-khach-san-chay-phong-truoc-khai-mac-diff-2026-458806.html',
			'https://baomoi.com/gan-7-000-phong-sap-do-bo-nguon-cung-khach-san-da-nang-c55535742.epi',
		),
	);

	/* ---------------- 15/11 – Khách quốc tế ---------------- */
	$posts[] = array(
		'slug'     => 'khach-quoc-te-da-nang-2026-han-quoc-trung-quoc-thue-can-ho-sun-saphia',
		'title'    => 'Khách Hàn Quốc chiếm hơn 20% khách quốc tế đến Đà Nẵng: ai sẽ thuê studio Sun Saphia Residence?',
		'excerpt'  => 'Nửa đầu 2026, khách Hàn Quốc chiếm 20,55% khách quốc tế đến Đà Nẵng, Trung Quốc 8,6%; 10 tháng khách quốc tế tăng 20,2%. Ý nghĩa với căn hộ cho thuê ven biển như Sun Saphia Residence.',
		'keyword'  => 'khách thuê căn hộ Sun Saphia Residence',
		'keywords_extra' => array( 'khách quốc tế đến Đà Nẵng 2026', 'Sun Saphia Residence', 'khách Hàn Quốc Đà Nẵng', 'cho thuê căn hộ khách nước ngoài Đà Nẵng', 'thị trường khách du lịch Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 11:30',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Du lịch Đà Nẵng', 'Khách quốc tế' ),
		'image'    => 'plugin:img/tin-tuc/khach-quoc-te-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Người thuê căn hộ ven biển Đà Nẵng không chỉ là khách trong nước. Biết ai đang đến, ở bao lâu, đặt phòng qua kênh nào giúp chủ căn hộ như {$saphia} chọn cách bày trí, định giá và kênh bán phòng phù hợp.</p>
<!--hh-featured-->
<h2>Số liệu khách quốc tế gần nhất</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Số liệu</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Thị phần khách Hàn Quốc tại Đà Nẵng, 6 tháng 2026</td><td>20,55% tổng khách quốc tế – đứng đầu</td><td>Danang Fantasticity</td></tr>
<tr><td>Thị phần khách Trung Quốc tại Đà Nẵng, 6 tháng 2026</td><td>8,60% – đứng thứ hai</td><td>Danang Fantasticity</td></tr>
<tr><td>Khách Hàn Quốc tại Đà Nẵng, 7 tháng 2026</td><td>Khoảng 1,2 triệu lượt (20,2%)</td><td>BNEWS</td></tr>
<tr><td>Khách quốc tế đến Đà Nẵng, 10 tháng 2026</td><td>Tăng 20,2% so với cùng kỳ</td><td>CafeLand (theo số liệu cấp quốc gia)</td></tr>
<tr><td>Cả nước, 10 tháng 2026</td><td>19,5 triệu lượt; Trung Quốc gần 4,4 triệu, Hàn Quốc 3,4 triệu</td><td>Báo Tin tức</td></tr>
</tbody>
</table>
<p>Đáng chú ý: trên cả nước khách Hàn Quốc 10 tháng giảm 6,3% (Dân trí), nhưng tại Đà Nẵng tổng khách quốc tế vẫn tăng mạnh – thành phố đang bớt phụ thuộc vào một thị trường.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg|Sun Saphia Residence bên bãi tắm Sơn Thủy (phối cảnh chủ đầu tư)-->
<h2>Khách quốc tế cần gì ở một căn studio?</h2>
<ul>
<li><strong>Gần biển, đi bộ được</strong>: khách gia đình, cặp đôi Hàn Quốc chuộng chỗ ở ven biển Mỹ Khê – Sơn Thủy, gần quán ăn, cửa hàng tiện lợi.</li>
<li><strong>Kênh đặt phòng quen thuộc</strong>: mỗi thị trường dùng nền tảng khác nhau – nên có mặt trên nhiều kênh, chi phí kênh xem bài <a href="/phi-booking-agoda-airbnb-cho-thue-can-ho-sun-saphia/">phí Booking, Agoda, Airbnb</a>.</li>
<li><strong>Bếp nhỏ, máy giặt, wifi tốt</strong>: khách ở 4 – 7 đêm thường chọn căn hộ thay vì phòng khách sạn vì có bếp, chỗ phơi đồ.</li>
<li><strong>Thủ tục lưu trú</strong>: khách nước ngoài phải khai báo tạm trú – xem bài <a href="/cho-thue-ngan-ngay-can-ho-da-nang-phap-ly-thue/">cho thuê ngắn ngày: pháp lý, khai báo lưu trú và thuế</a>.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li>Studio 30 m² ở vị trí ven biển như Sun Saphia phù hợp nhóm khách 2 người – đúng nhóm đông nhất của khách quốc tế đi nghỉ ngắn ngày.</li>
<li>Khách quốc tế tăng giúp lấp phòng ngày thường và đầu mùa thấp điểm, bổ sung cho khách nội địa dồn vào cuối tuần, lễ.</li>
<li>Rủi ro: thị trường khách nước ngoài nhạy cảm với tỷ giá, đường bay, chính sách thị thực – không nên giả định lấp đầy cao cả năm.</li>
</ul>
<p>Toàn cảnh vị trí, giá và dòng tiền xem bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Danang Fantasticity (6 tháng 2026); BNEWS (7 tháng 2026); CafeLand, Báo Tin tức, Dân trí (10 tháng 2026). Nhận định của Hoàng Hiệp, mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Khách quốc tế đến Đà Nẵng 2026 và Sun Saphia',
			'desc'      => 'Khách Hàn Quốc chiếm 20,55% khách quốc tế đến Đà Nẵng nửa đầu 2026, Trung Quốc 8,6%; 10 tháng tăng 20,2%. Ý nghĩa với cho thuê studio Sun Saphia Residence.',
			'points'    => array(
				'Hàn Quốc 20,55%, Trung Quốc 8,6% khách quốc tế đến Đà Nẵng (6 tháng 2026)',
				'Khách quốc tế đến Đà Nẵng 10 tháng 2026 tăng 20,2%',
				'Studio ven biển hợp nhóm khách 2 người ở 4 – 7 đêm',
			),
			'faq'       => array(
				array( 'Khách quốc tế nào đến Đà Nẵng nhiều nhất?', 'Hàn Quốc, chiếm 20,55% khách quốc tế 6 tháng đầu 2026; Trung Quốc đứng thứ hai với 8,6% (Danang Fantasticity).' ),
				array( 'Cho khách nước ngoài thuê căn hộ cần làm gì?', 'Phải khai báo tạm trú cho khách theo quy định; nên có mặt trên các kênh đặt phòng quốc tế và chuẩn bị căn có bếp, máy giặt, wifi.' ),
			),
		),
		'sources'  => array(
			'https://danangfantasticity.com/en/%C4%91%C3%A0-n%E1%BA%B5ng-%C4%91%C3%B3n-g%E1%BA%A7n-52-tri%E1%BB%87u-l%C6%B0%E1%BB%A3t-kh%C3%A1ch-qu%E1%BB%91c-t%E1%BA%BF-trong-6-th%C3%A1ng-%C4%91%E1%BA%A7u-n%C4%83m-2026',
			'https://bnews.vn/da-nang-tang-suc-hut-khach-quoc-te/437905.html',
			'https://cafeland.vn/tin-tuc/viet-nam-don-195-trieu-luot-khach-quoc-te-trong-10-thang-156470.html',
			'https://baotintuc.vn/khach-quoc-te-den-viet-nam-dat-195-trieu-luot-trong-10-thang-nam-2026-post1399521.html',
			'https://dantri.com.vn/du-lich/du-lich-viet-nam-co-thang-ruc-ro-khach-tu-mot-quoc-gia-tang-truong-150-20261103154444651.htm',
		),
	);

	/* ---------------- 16/11 – Tự cho thuê hay đơn vị vận hành ---------------- */
	$posts[] = array(
		'slug'     => 'tu-cho-thue-hay-thue-don-vi-van-hanh-can-ho-sun-saphia',
		'title'    => 'Tự cho thuê hay giao đơn vị vận hành? Chia 85/15, phí quản lý và bài học cam kết lợi nhuận – áp vào Sun Saphia Residence',
		'excerpt'  => 'Mô hình phổ biến là chủ căn hộ giữ 85%, đơn vị vận hành 15% lợi nhuận; phí quản lý có nơi 15 – 50%. So sánh tự cho thuê và thuê vận hành cho studio Sun Saphia Residence, cùng các điều khoản cần đọc kỹ.',
		'keyword'  => 'vận hành cho thuê Sun Saphia Residence',
		'keywords_extra' => array( 'đơn vị vận hành cho thuê căn hộ', 'Sun Saphia Residence', 'tự cho thuê căn hộ du lịch', 'chia lợi nhuận 85/15', 'cam kết lợi nhuận căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Cho thuê căn hộ', 'Kinh nghiệm đầu tư' ),
		'image'    => 'plugin:img/tin-tuc/tu-cho-thue-hay-van-hanh-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Mua một căn studio ven biển để cho thuê, câu hỏi tiếp theo là: tự làm hay giao cho đơn vị chuyên nghiệp? Mỗi cách có chi phí và rủi ro riêng. Bài này tổng hợp các mức phổ biến trên thị trường và cách áp vào {$saphia}.</p>
<!--hh-featured-->
<h2>Các mô hình chia doanh thu, lợi nhuận thường gặp</h2>
<table>
<thead><tr><th>Mô hình</th><th>Mức tham khảo</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Chia lợi nhuận chủ căn – đơn vị vận hành</td><td>Phổ biến 85/15</td><td>Batdongsan Wiki, TheLEADER</td></tr>
<tr><td>Phí quản lý theo hợp đồng</td><td>15 – 50% tùy thỏa thuận, dịch vụ</td><td>Tổng hợp bài viết thị trường</td></tr>
<tr><td>Chi phí vận hành khách sạn</td><td>Khoảng 22 – 35% doanh thu</td><td>Tổng hợp bài viết thị trường</td></tr>
<tr><td>Phí kênh đặt phòng</td><td>Booking.com 15 – 18%, Agoda 12 – 20%</td><td>Xem bài phí kênh đặt phòng</td></tr>
</tbody>
</table>
<p>Các tỷ lệ trên là mức thị trường tham khảo, phần lớn từ các bài viết về condotel; mỗi hợp đồng khác nhau, cần đọc kỹ từng điều khoản.</p>
<h2>So sánh nhanh</h2>
<table>
<thead><tr><th></th><th>Tự cho thuê</th><th>Giao đơn vị vận hành</th></tr></thead>
<tbody>
<tr><td>Thu nhập giữ lại</td><td>Cao hơn (không mất phí quản lý)</td><td>Thấp hơn (chia 15% lợi nhuận hoặc phí quản lý)</td></tr>
<tr><td>Thời gian, công sức</td><td>Nhiều: đăng phòng, đón khách, dọn phòng, xử lý sự cố</td><td>Ít, phù hợp người ở xa</td></tr>
<tr><td>Giá phòng, lấp đầy</td><td>Phụ thuộc kinh nghiệm chủ căn</td><td>Đơn vị có hệ thống bán phòng, giá động</td></tr>
<tr><td>Rủi ro</td><td>Đánh giá xấu, trống phòng nếu không chuyên</td><td>Hợp đồng bất lợi, báo cáo doanh thu thiếu minh bạch</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-layout-studio-30m2.jpg|Layout studio 30 m² Sun Saphia Residence (bản vẽ chủ đầu tư)-->
<h2>Bài học từ cam kết lợi nhuận</h2>
<p>Đà Nẵng từng có dự án cam kết lợi nhuận 12%/năm rồi dừng chi trả cho khoảng 1.800 khách hàng (Cocobay, theo báo chí). Một lãnh đạo doanh nghiệp bất động sản lớn từng nhận định cam kết lợi nhuận trên 10% là có vấn đề. Bài học: mức cam kết cao chưa chắc là thu nhập thật – quan trọng là năng lực vận hành và hợp đồng.</p>
<h2>Nhận định của Hoàng Hiệp – áp vào Sun Saphia</h2>
<ul>
<li><strong>Ở xa Đà Nẵng</strong>: nên giao đơn vị vận hành hoặc đội quản lý căn hộ chuyên nghiệp; khoản 15% thường rẻ hơn chi phí trống phòng.</li>
<li><strong>Ở Đà Nẵng, có thời gian</strong>: có thể tự cho thuê một – hai căn, thuê dọn phòng theo lượt.</li>
<li><strong>Đọc kỹ hợp đồng</strong>: cách tính doanh thu, chi phí nào trừ trước khi chia, số đêm chủ được sử dụng, thời hạn, điều kiện chấm dứt, quyền xem báo cáo.</li>
<li><strong>Tài liệu bán hàng Sun Saphia</strong> chỉ đưa bài toán tham khảo (studio 2,5 triệu/đêm, lấp đầy 60%), không phải cam kết – nên tự tính lại theo mùa.</li>
</ul>
<p>Xem thêm <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">3 kịch bản dòng tiền cho thuê</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Batdongsan Wiki, TheLEADER (mô hình 85/15, nhận định về cam kết lợi nhuận); tổng hợp các bài viết thị trường về condotel; báo chí về vụ Cocobay. Nhận định của Hoàng Hiệp, mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tự cho thuê hay giao vận hành căn hộ Sun Saphia?',
			'desc'      => 'Phổ biến chia lợi nhuận 85/15, phí quản lý 15 – 50%. So sánh tự cho thuê và thuê đơn vị vận hành studio Sun Saphia Residence, điều khoản cần đọc kỹ.',
			'points'    => array(
				'Chia lợi nhuận phổ biến 85/15 giữa chủ căn và đơn vị vận hành',
				'Phí quản lý có thể 15 – 50% tùy hợp đồng',
				'Cam kết lợi nhuận cao không thay được năng lực vận hành',
			),
			'faq'       => array(
				array( 'Đơn vị vận hành căn hộ cho thuê thường lấy bao nhiêu phần trăm?', 'Mô hình phổ biến là chủ căn hộ giữ 85%, đơn vị vận hành nhận 15% lợi nhuận; một số hợp đồng tính phí quản lý 15 – 50% tùy dịch vụ.' ),
				array( 'Có nên tự cho thuê căn hộ Sun Saphia Residence?', 'Nếu ở Đà Nẵng và có thời gian thì có thể tự cho thuê; nếu ở xa nên giao đơn vị vận hành chuyên nghiệp và đọc kỹ hợp đồng chia doanh thu.' ),
			),
		),
		'sources'  => array(
			'https://wiki.batdongsan.com.vn/phan-tich-danh-gia/toan-canh-ve-condotel-duoi-goc-nhin-ke-toan-tai-chinh-luat-102747',
			'https://theleader.vn/tieu-chuan-nao-cho-cam-ket-loi-nhuan-condotel-d24453.html',
		),
	);

	/* ---------------- 17/11 – Nội thất studio ---------------- */
	$posts[] = array(
		'slug'     => 'chi-phi-noi-that-studio-30m2-cho-thue-sun-saphia',
		'title'    => 'Làm nội thất studio 30 m² để cho thuê hết bao nhiêu? Gói 80 – 300 triệu và cách tính vào dòng tiền Sun Saphia Residence',
		'excerpt'  => 'Sun Saphia Residence bàn giao hoàn thiện cơ bản, chủ căn tự làm nội thất. Báo giá thị trường 2026 cho studio: gói cơ bản 80 – 130 triệu, tiêu chuẩn 130 – 180 triệu, cao cấp 180 – 300 triệu. Cách khấu hao vào lợi nhuận cho thuê.',
		'keyword'  => 'nội thất studio Sun Saphia Residence',
		'keywords_extra' => array( 'chi phí nội thất studio 30m2', 'Sun Saphia Residence', 'nội thất căn hộ cho thuê', 'nội thất studio cho thuê du lịch', 'hoàn thiện cơ bản căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 08:00',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Nội thất', 'Cho thuê căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/noi-that-studio-sun-saphia.jpg',
		'content'  => <<<HTML
<p>{$saphia} dự kiến bàn giao <strong>hoàn thiện cơ bản</strong> – nghĩa là để cho thuê được, chủ căn còn phải làm nội thất. Khoản này thường bị quên khi tính lợi nhuận, trong khi với một studio khoảng 2 tỷ, nội thất có thể chiếm 5 – 10% vốn.</p>
<!--hh-featured-->
<h2>Báo giá nội thất studio năm 2026</h2>
<table>
<thead><tr><th>Gói</th><th>Studio (trọn gói)</th><th>Theo m² (quy ra 30 m²)</th></tr></thead>
<tbody>
<tr><td>Cơ bản</td><td>80 – 130 triệu</td><td>4 – 5 triệu/m² → 120 – 150 triệu</td></tr>
<tr><td>Tiêu chuẩn / đầy đủ</td><td>130 – 180 triệu</td><td>6 – 8 triệu/m² → 180 – 240 triệu</td></tr>
<tr><td>Cao cấp</td><td>180 – 300 triệu</td><td>9 – 12 triệu/m² → 270 – 360 triệu</td></tr>
</tbody>
</table>
<p>Số liệu do các đơn vị thi công tự công bố (NT Decor, Nội thất QI), chưa gồm hết thiết bị, rèm, vận chuyển ở một số báo giá – khi so sánh cần yêu cầu bóc tách từng hạng mục.</p>
<!--hh-img:img/sun-saphia/sun-saphia-layout-can-studio.jpg|Layout căn studio Sun Saphia Residence – mặt tiền 3,8 m, sâu 9 m (bản vẽ chủ đầu tư)-->
<h2>Studio cho thuê cần những gì?</h2>
<ul>
<li><strong>Giường, nệm, chăn ga khách sạn</strong> – hạng mục khách đánh giá nhiều nhất.</li>
<li><strong>Bếp nhỏ, tủ lạnh, lò vi sóng, máy giặt</strong> – lợi thế so với phòng khách sạn với khách ở dài ngày.</li>
<li><strong>Bàn làm việc, wifi mạnh, TV thông minh</strong> – cho khách công tác, làm việc từ xa.</li>
<li><strong>Rèm cản sáng, điều hòa, khóa cửa điện tử</strong> – giúp tự nhận phòng, giảm chi phí vận hành.</li>
<li><strong>Vật liệu chịu ẩm, chịu muối</strong> – căn ven biển, xem bài <a href="/can-ho-ven-bien-hoi-muoi-mua-bao-sun-saphia-residence/">hơi muối, mùa mưa bão và bảo trì</a>.</li>
</ul>
<h2>Tính nội thất vào dòng tiền</h2>
<p>Ví dụ minh hoạ: gói nội thất 150 triệu, dùng tốt khoảng 5 năm → khấu hao khoảng <strong>30 triệu/năm</strong>, cộng thêm thay đồ vải, sửa chữa nhỏ. Với bài toán tham khảo của chủ đầu tư (studio thu khoảng 351 triệu/năm trước phí), khoản này làm lợi nhuận giảm khoảng 8 – 9%. Chọn gói quá cao cấp không chắc tăng giá phòng tương ứng – nên làm gọn, bền, đẹp ảnh.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li>Với studio cho thuê ven biển, gói tiêu chuẩn khoảng 130 – 180 triệu thường là điểm cân bằng.</li>
<li>Nên chốt thiết kế sớm, làm ngay sau bàn giao để không mất mùa cao điểm đầu tiên.</li>
<li>Nếu giao đơn vị vận hành, hỏi trước họ có tiêu chuẩn nội thất bắt buộc không để tránh làm hai lần.</li>
</ul>
<p>Xem thêm <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí ngoài giá bán khi mua Sun Saphia</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: báo giá nội thất 2026 do NT Decor, Nội thất QI công bố trên website; bài toán cho thuê tham khảo theo tài liệu chủ đầu tư; ví dụ khấu hao do Hoàng Hiệp minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nội thất studio Sun Saphia 30 m² hết bao nhiêu?',
			'desc'      => 'Báo giá 2026: studio gói cơ bản 80 – 130 triệu, tiêu chuẩn 130 – 180 triệu, cao cấp 180 – 300 triệu. Cách tính vào dòng tiền cho thuê Sun Saphia Residence.',
			'points'    => array(
				'Sun Saphia bàn giao hoàn thiện cơ bản – chủ căn tự làm nội thất',
				'Studio: cơ bản 80 – 130 tr, tiêu chuẩn 130 – 180 tr, cao cấp 180 – 300 tr',
				'Gói 150 triệu khấu hao 5 năm khoảng 30 triệu/năm',
			),
			'faq'       => array(
				array( 'Làm nội thất studio 30 m² hết bao nhiêu tiền?', 'Theo báo giá các đơn vị thi công năm 2026: gói cơ bản 80 – 130 triệu, tiêu chuẩn 130 – 180 triệu, cao cấp 180 – 300 triệu.' ),
				array( 'Sun Saphia Residence bàn giao có nội thất không?', 'Theo tài liệu chủ đầu tư, Sun Saphia Residence bàn giao hoàn thiện cơ bản; để ở hoặc cho thuê cần làm thêm nội thất.' ),
			),
		),
		'sources'  => array(
			'https://ntdecor.vn/vi/news-vi/bao-gia-thi-cong-noi-that-can-ho-2026/',
			'https://noithatqi.vn/thi-cong-noi-that-tron-goi/',
		),
	);

	/* ---------------- 18/11 – Sân bay ---------------- */
	$posts[] = array(
		'slug'     => 'nang-cap-san-bay-da-nang-1696-ty-sun-saphia-residence',
		'title'    => 'Sân bay Đà Nẵng cải tạo đường băng gần 1.700 tỷ, quy hoạch 20 triệu khách/năm: Sun Saphia Residence được gì?',
		'excerpt'  => 'Dự án cải tạo đường cất hạ cánh 17R/35L và đường lăn sân bay Đà Nẵng khoảng 1.696 tỷ (2026 – 2028) đón tàu bay thân rộng; quy hoạch sân bay 20 triệu khách/năm. Ý nghĩa với căn hộ ven biển như Sun Saphia Residence.',
		'keyword'  => 'Sun Saphia Residence gần sân bay',
		'keywords_extra' => array( 'nâng cấp sân bay Đà Nẵng', 'Sun Saphia Residence', 'đường cất hạ cánh sân bay Đà Nẵng', 'sân bay Đà Nẵng 20 triệu khách', 'căn hộ gần sân bay Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 11:30',
		'category' => 'Hạ tầng & quy hoạch',
		'tags'     => array( 'Sun Saphia Residence', 'Hạ tầng Đà Nẵng', 'Sân bay Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/san-bay-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Với căn hộ cho thuê du lịch, sân bay là "cửa ngõ" đưa khách tới. Sân bay quốc tế Đà Nẵng đang bước vào đợt cải tạo lớn và đã có quy hoạch nâng công suất – thông tin đáng theo dõi với chủ căn hộ ven biển như {$saphia}.</p>
<!--hh-featured-->
<h2>Dự án cải tạo đường cất hạ cánh</h2>
<table>
<tbody>
<tr><th>Văn bản</th><td>Quyết định 1417/QĐ-BXD ngày 12/8/2026 của Bộ Xây dựng (chủ trương đầu tư)</td></tr>
<tr><th>Phạm vi</th><td>Cải tạo đường cất hạ cánh 17R/35L và hệ thống đường lăn, quy mô sân bay cấp 4E (ICAO)</td></tr>
<tr><th>Tàu bay khai thác</th><td>Code E như B747, B787, A350 hoặc tương đương</td></tr>
<tr><th>Tổng mức đầu tư</th><td>Khoảng 1.696 tỷ đồng, dự án nhóm B, vốn ngân sách trung ương</td></tr>
<tr><th>Thời gian</th><td>2026 – 2028</td></tr>
</tbody>
</table>
<p>Theo Thời báo Tài chính, Bộ Xây dựng chấp thuận dùng thiết kế kỹ thuật thay thiết kế cơ sở để sớm khởi công, phấn đấu cuối tháng 11/2026 – mốc này cần chờ xác nhận chính thức.</p>
<h2>Quy hoạch sân bay đến 2030</h2>
<ul>
<li>Quyết định 222/QĐ-BXD ngày 12/2/2026: sân bay cấp 4E, công suất khoảng <strong>20 triệu hành khách</strong> và 100.000 tấn hàng hóa/năm giai đoạn 2021 – 2030.</li>
<li>Nhà ga T1 mở rộng về phía Nam lên 14 triệu khách/năm; nhà ga T2 6 triệu khách/năm.</li>
<li>Năm 2025, sân bay phục vụ khoảng 15,1 triệu lượt khách, gần 89.800 chuyến bay.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-ban-do-ket-noi.jpg|Bản đồ kết nối Sun Saphia Residence: bãi tắm Sơn Thủy, Ngũ Hành Sơn, sân bay Đà Nẵng (tài liệu chủ đầu tư)-->
<h2>Từ sân bay đến Sun Saphia</h2>
<p>Sân bay nằm ngay trong nội đô; biển Mỹ Khê cách sân bay khoảng 6,5 km. Sun Saphia ở khu Sơn Thủy, phía Nam Mỹ Khê – khoảng 9 – 10 km đường xe, thường dưới 25 phút (ước tính theo bản đồ, tùy giờ). Trong tương lai, tuyến đường sắt đô thị sân bay – biển dự kiến có ga cách dự án khoảng 500 m – xem bài <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">đường sắt đô thị sân bay – Mỹ Khê – Hội An</a>.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đón tàu bay thân rộng</strong> mở đường cho các chặng bay dài, thêm khách từ thị trường xa – nhóm khách thường ở lâu hơn, chi tiêu cao hơn.</li>
<li><strong>Công suất 20 triệu khách/năm</strong> so với 15,1 triệu năm 2025 là dư địa tăng trưởng rõ ràng cho lưu trú ven biển.</li>
<li><strong>Lưu ý</strong>: trong thời gian thi công 2026 – 2028 có thể điều chỉnh khai thác; tác động lên giá căn hộ là dài hạn.</li>
</ul>
<p>Toàn cảnh vị trí, giá và dòng tiền xem bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Quyết định 1417/QĐ-BXD (LuatVietnam), VnEconomy; Thời báo Tài chính (mốc khởi công dự kiến); quy hoạch sân bay theo Quyết định 222/QĐ-BXD (VnExpress, Dân trí); khoảng cách Mỹ Khê – sân bay theo Traveloka. Thời gian di chuyển đến dự án là ước tính.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nâng cấp sân bay Đà Nẵng 1.696 tỷ và Sun Saphia',
			'desc'      => 'Cải tạo đường băng 17R/35L sân bay Đà Nẵng khoảng 1.696 tỷ (2026 – 2028), quy hoạch 20 triệu khách/năm. Căn hộ ven biển như Sun Saphia Residence được gì?',
			'points'    => array(
				'QĐ 1417/QĐ-BXD: cải tạo đường cất hạ cánh 17R/35L, khoảng 1.696 tỷ, 2026 – 2028',
				'Quy hoạch sân bay khoảng 20 triệu khách/năm; năm 2025 đón 15,1 triệu',
				'Sun Saphia cách sân bay khoảng 9 – 10 km đường xe (ước tính)',
			),
			'faq'       => array(
				array( 'Dự án nâng cấp đường băng sân bay Đà Nẵng bao nhiêu tiền?', 'Khoảng 1.696 tỷ đồng theo Quyết định 1417/QĐ-BXD ngày 12/8/2026, cải tạo đường cất hạ cánh 17R/35L và đường lăn, thực hiện 2026 – 2028.' ),
				array( 'Sun Saphia Residence cách sân bay Đà Nẵng bao xa?', 'Khoảng 9 – 10 km đường xe, thường dưới 25 phút tùy giờ (ước tính theo bản đồ).' ),
			),
		),
		'sources'  => array(
			'https://luatvietnam.vn/dau-tu/quyet-dinh-1417-qd-bxd-2026-dau-tu-xay-dung-cai-tao-duong-cat-ha-canh-cang-hang-khong-da-nang-444767-d1.html',
			'https://vneconomy.vn/gan-1696-ty-dong-dau-tu-du-an-cai-tao-duong-cat-ha-canh-duong-lan-cang-hang-khong-quoc-te-da-nang.htm',
			'https://thoibaotaichinhvietnam.vn/khoi-cong-cai-tao-tong-the-duong-cat-ha-canh-san-bay-da-nang-vao-cuoi-thang-11-2026-202900.html',
			'https://vnexpress.net/quy-hoach-san-bay-da-nang-cong-suat-20-trieu-khach-moi-nam-5047111.html',
			'https://dantri.com.vn/thoi-su/quy-hoach-san-bay-da-nang-cong-suat-20-trieu-hanh-khachnam-20260305165323515.htm',
		),
	);

	/* ---------------- 19/11 – Căn 2PN ---------------- */
	$posts[] = array(
		'slug'     => 'can-2pn-sun-saphia-residence-60-70m2-o-hay-cho-thue',
		'title'    => 'Căn 2PN Sun Saphia Residence 60 – 70 m²: 133 căn ở góc tòa – để ở, nghỉ dưỡng gia đình hay cho thuê?',
		'excerpt'  => 'Sun Saphia Residence có 133 căn 2PN 60 – 70 m², nằm ở các góc tòa, mỗi sàn điển hình 5 căn. Ưu nhược điểm, ai nên mua và cách kết hợp ở – cho thuê.',
		'keyword'  => 'căn 2PN Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ 2 phòng ngủ ven biển Đà Nẵng', 'căn góc view biển', 'căn hộ nghỉ dưỡng gia đình Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ 2PN', 'Căn hộ ven biển' ),
		'image'    => 'plugin:img/tin-tuc/can-2pn-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Phần lớn {$saphia} là studio (513 căn), nhưng tòa tháp còn có <strong>133 căn 2PN</strong> diện tích thông thủy 60 – 70 m². Đây là loại căn hiếm nhất về tỷ lệ và hợp với nhóm khách khác hẳn studio.</p>
<!--hh-featured-->
<h2>Căn 2PN có gì?</h2>
<table>
<tbody>
<tr><th>Số lượng</th><td>133 căn (tài liệu chủ đầu tư 10/2026)</td></tr>
<tr><th>Diện tích thông thủy</th><td>60 – 70 m² (các mẫu 61, 67, 70 m²)</td></tr>
<tr><th>Vị trí</th><td>Ở các góc tòa; tầng điển hình 3A – 28 có 5 căn 2PN/sàn</td></tr>
<tr><th>Chiều cao tầng căn hộ</th><td>3,5 m</td></tr>
<tr><th>Bàn giao</th><td>Hoàn thiện cơ bản, dự kiến 11/2028</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-70m2.jpg|Layout căn 2PN 70 m² Sun Saphia Residence (bản vẽ chủ đầu tư)-->
<h2>Ưu điểm</h2>
<ul>
<li><strong>Căn góc</strong>: hai mặt thoáng, nhiều cửa sổ, nhiều góc nhìn hơn căn giữa.</li>
<li><strong>Ít hàng</strong>: chỉ khoảng 17% số căn của tòa – nguồn cung hạn chế so với studio.</li>
<li><strong>Nhóm khách riêng</strong>: gia đình 4 người, nhóm bạn – khó thuê được 2 phòng khách sạn liền nhau mùa cao điểm, căn 2PN có bếp, phòng khách là lựa chọn tốt.</li>
</ul>
<h2>Cần cân nhắc</h2>
<ul>
<li><strong>Tổng tiền cao hơn studio</strong> nhiều lần; giá chính thức chưa công bố – cần chờ bảng giá khi mở bán.</li>
<li><strong>Lấp đầy</strong> căn lớn thường thấp hơn studio vào ngày thường, nhưng giá mỗi đêm cao hơn.</li>
<li><strong>Nội thất, vận hành</strong> tốn hơn: 2 phòng ngủ, 2 bộ giường, thời gian dọn phòng lâu hơn.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-61m2.jpg|Layout căn 2PN 61 m² Sun Saphia Residence (bản vẽ chủ đầu tư)-->
<h2>Nhận định của Hoàng Hiệp: ai nên chọn 2PN?</h2>
<ul>
<li><strong>Gia đình muốn có nhà nghỉ dưỡng ở biển</strong>, dùng vài tuần mỗi năm, thời gian còn lại cho thuê – căn 2PN phù hợp hơn studio.</li>
<li><strong>Người muốn giữ tài sản lâu dài</strong>: loại căn ít, vị trí góc thường dễ bán lại cho người mua để ở.</li>
<li><strong>Nhà đầu tư thuần cho thuê</strong> nên so tỷ suất trên tổng vốn với 2 căn studio cùng số tiền trước khi quyết định.</li>
</ul>
<p>Xem thêm <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence: chọn căn nào?</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: số lượng căn, diện tích, vị trí và layout theo tài liệu chủ đầu tư (10/2026). Nhận định của Hoàng Hiệp, mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn 2PN Sun Saphia 60 – 70 m²: ở hay cho thuê?',
			'desc'      => 'Sun Saphia Residence có 133 căn 2PN 60 – 70 m² ở các góc tòa, 5 căn mỗi sàn điển hình. Ưu nhược điểm, ai nên mua, kết hợp ở và cho thuê.',
			'points'    => array(
				'133 căn 2PN thông thủy 60 – 70 m², ở các góc tòa',
				'Chỉ khoảng 17% số căn – nguồn cung hạn chế',
				'Hợp gia đình nghỉ dưỡng kết hợp cho thuê',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có bao nhiêu căn 2 phòng ngủ?', 'Theo tài liệu chủ đầu tư 10/2026, có 133 căn 2PN diện tích thông thủy 60 – 70 m², nằm ở các góc tòa.' ),
				array( 'Căn 2PN Sun Saphia Residence giá bao nhiêu?', 'Giá chính thức căn 2PN chưa công bố; bảng giá sẽ có khi mở bán – liên hệ Hoàng Hiệp để nhận khi có.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
