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
		'slug'     => 'chon-can-sun-saphia-residence-day-mat-bien',
		'old_slug' => array( 'chon-day-can-sun-saphia-residence-mat-bien-canh-ben-phia-sau' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
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
<p><strong>Chọn căn Sun Saphia Residence</strong> bắt đầu từ mặt bằng sàn: một tầng điển hình của {$saphia} (tầng 3A – 28) có 28 căn gồm 19 studio, 4 căn 1PN+ và 5 căn 2PN. Cùng một căn studio 30 m², giá dự kiến chủ đầu tư đưa ra ngày 28/10/2026 khác nhau khá rõ theo vị trí trên sàn. Câu hỏi nhiều anh chị đặt ra: bỏ thêm vài trăm triệu để lấy view biển có đáng không?</p>
<!--hh-featured-->
<h2>Chọn căn Sun Saphia Residence: giá dự kiến studio 30 m² theo từng dãy</h2>
<table>
<thead><tr><th>Dãy căn</th><th>Giá dự kiến</th><th>Chênh so với phía sau</th></tr></thead>
<tbody>
<tr><td>Dãy phía sau</td><td>2,13 tỷ</td><td>–</td></tr>
<tr><td>Cánh bên</td><td>2,37 tỷ</td><td>+240 triệu (khoảng +11%)</td></tr>
<tr><td>Dãy mặt biển</td><td>2,85 tỷ</td><td>+720 triệu (khoảng +34%)</td></tr>
</tbody>
</table>
<p>Giá trên là giá dự kiến có vay, chưa VAT và 2% phí bảo trì; bảng giá chính thức công bố khi mở bán. Phần trăm chênh lệch do Hoàng Hiệp tính từ các con số này.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28.jpg|Chọn căn Sun Saphia Residence trên mặt bằng tầng điển hình 3A – 28: dãy phía Đông hướng biển, 2PN ở các góc (bản vẽ chủ đầu tư)-->
<h2>Chọn căn Sun Saphia Residence mặt biển: cho thuê đắt hơn bao nhiêu mới "hòa"?</h2>
<p>Nếu muốn giữ cùng tỷ suất cho thuê như căn phía sau, doanh thu căn mặt biển phải cao hơn đúng tỷ lệ chênh giá:</p>
<ul>
<li>Cánh bên: doanh thu cần cao hơn khoảng <strong>11%</strong>.</li>
<li>Mặt biển: doanh thu cần cao hơn khoảng <strong>34%</strong> – ví dụ căn phía sau thu 2 triệu/đêm thì căn mặt biển cần khoảng 2,7 triệu/đêm với cùng tỷ lệ lấp đầy.</li>
</ul>
<p>Trên thực tế, phòng view biển trực diện thường bán được giá cao hơn và kín phòng sớm hơn vào mùa cao điểm, nhưng mức chênh tùy thời điểm và cách vận hành – anh chị nên tự kiểm tra giá các phòng view biển và không view ở khu Sơn Thủy – Mỹ Khê trên các kênh đặt phòng trước khi quyết định. Chi phí kênh đặt phòng xem thêm bài <a href="/phi-booking-agoda-airbnb-cho-thue-can-ho/">phí Booking, Agoda, Airbnb</a>.</p>
<h2>Ngoài giá, chọn căn Sun Saphia Residence còn cần xem gì?</h2>
<p>Giá chỉ là một mặt. Khi chọn căn Sun Saphia Residence, Hoàng Hiệp khuyên anh chị đặt thêm bốn câu hỏi lên bản vẽ mặt bằng:</p>
<ol>
<li><strong>Khoảng cách tới sảnh thang:</strong> căn sát sảnh tiện đi lại nhưng nghe tiếng thang, tiếng khách qua lại; căn cuối hành lang yên hơn nhưng đi bộ xa hơn.</li>
<li><strong>Hướng nắng:</strong> dãy phía Tây nhìn thành phố có nắng chiều – cần rèm, kính cách nhiệt, điều hòa chạy nhiều hơn; dãy phía Đông đón nắng sáng, chiều mát.</li>
<li><strong>Tầm nhìn có bị che không:</strong> theo chủ đầu tư, phía Nam quy hoạch 26 – 30 tầng, phía Tây tối đa 7 tầng, phía trước là công viên biển 2,45 ha (<a href="https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp">VietnamPlus</a>). View biển phía Đông vì vậy ít khả năng bị chắn.</li>
<li><strong>Vị trí phòng kỹ thuật, phòng rác:</strong> căn cạnh các phòng này dễ có tiếng ồn hoặc mùi; hỏi kỹ trên bản vẽ.</li>
</ol>
<h2>Ví dụ: 2,85 tỷ mặt biển hay 2,13 tỷ phía sau cộng 720 triệu dự phòng?</h2>
<p>Một cách nghĩ thực tế khi chọn căn Sun Saphia Residence: thay vì hỏi "mặt biển có đáng không", hãy hỏi "720 triệu chênh lệch có việc gì tốt hơn để làm không". Nếu số tiền đó là vốn vay, lãi vay trên 720 triệu là chi phí thật mỗi tháng sau khi hết hỗ trợ lãi suất. Nếu là vốn tự có và anh chị định ở một phần thời gian, view biển là giá trị sử dụng mà căn phía sau không bù được. Không có đáp án chung – nhưng tính rõ như vậy giúp quyết định dựa trên con số thay vì cảm xúc lúc đi xem nhà mẫu.</p>
<h2>Nhận định của Hoàng Hiệp: chọn căn Sun Saphia Residence theo mục tiêu</h2>
<ul>
<li><strong>Dãy mặt biển</strong> – hợp người mua để nghỉ dưỡng, ở một phần thời gian, hoặc muốn tài sản dễ bán lại nhất sau này. View biển là thứ không thể "làm thêm" sau khi mua.</li>
<li><strong>Cánh bên</strong> – cân bằng: chênh khoảng 11% nhưng vẫn có góc nhìn ra biển hoặc ra phố, hợp người vừa ở vừa cho thuê.</li>
<li><strong>Dãy phía sau</strong> – vốn thấp nhất, hợp người đầu tư cho thuê thuần túy, ưu tiên tổng số tiền bỏ ra và vay ít.</li>
<li><strong>Tầng</strong>: khi chọn căn Sun Saphia Residence cùng dãy, tầng càng cao giá thường càng tăng; tầng trung (khoảng 10 – 20) thường cân bằng giữa view và giá.</li>
</ul>
<p>Giá chi tiết từng tầng xem bài <a href="/gia-sun-saphia-residence-bao-nhieu/">Giá Sun Saphia Residence bao nhiêu?</a>, mặt bằng từng loại căn xem <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence</a>, toàn cảnh dự án ở bài {$review}.</p>
{$cta}
<p class="src">Nguồn: giá dự kiến và mặt bằng theo tài liệu chủ đầu tư (28/10/2026); tỷ lệ chênh lệch và ví dụ do Hoàng Hiệp tính, mang tính minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chọn căn Sun Saphia Residence: mặt biển chênh 720 triệu',
			'desc'      => 'Chọn căn Sun Saphia Residence: studio 30 m² tầng 15 giá dự kiến 2,13 tỷ phía sau, 2,37 tỷ cánh bên, 2,85 tỷ mặt biển. Chênh 11 – 34%, có đáng không?',
			'points'    => array(
				'Chọn căn Sun Saphia Residence: cùng studio 30 m², giá đổi rõ theo dãy',
				'Giá dự kiến studio 30 m² tầng 15: 2,13 / 2,37 / 2,85 tỷ',
				'Căn mặt biển cần doanh thu cao hơn khoảng 34% để có cùng tỷ suất',
				'Mặt biển hợp nghỉ dưỡng, cánh bên cân bằng, phía sau hợp cho thuê vốn thấp',
			),
			'faq'       => array(
				array( 'Studio Sun Saphia Residence mặt biển đắt hơn bao nhiêu?', 'Theo giá dự kiến 28/10/2026, studio 30 m² tầng 15 dãy mặt biển khoảng 2,85 tỷ, cao hơn dãy phía sau (2,13 tỷ) khoảng 720 triệu.' ),
				array( 'Đầu tư cho thuê nên chọn căn Sun Saphia Residence ở dãy nào?', 'Nếu ưu tiên vốn thấp chọn dãy phía sau; nếu muốn cân bằng chọn cánh bên; căn mặt biển phải cho thuê cao hơn khoảng 34% mới có cùng tỷ suất.' ),
				array( 'Chọn căn Sun Saphia Residence cần xem gì ngoài giá?', 'Khoảng cách tới sảnh thang, hướng nắng, khả năng bị che view theo quy hoạch xung quanh và vị trí phòng kỹ thuật, phòng rác trên bản vẽ.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp',
		),
	);

	/* ---------------- 14/11 – Mùa du lịch ---------------- */
	$posts[] = array(
		'slug'     => 'cong-suat-phong-da-nang-mua-du-lich-sun-saphia',
		'old_slug' => array( 'mua-du-lich-da-nang-cong-suat-phong-cho-thue-sun-saphia' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Mùa du lịch Đà Nẵng: tháng nào kín phòng, tháng nào vắng – tính lấp đầy cho studio Sun Saphia Residence',
		'excerpt'  => 'Hè và mùa pháo hoa DIFF công suất phòng ven biển Đà Nẵng 75 – 98%, nhưng cả năm bình quân khoảng 66%. Cách tính lấp đầy theo mùa khi cho thuê studio Sun Saphia Residence.',
		'keyword'  => 'công suất phòng Đà Nẵng',
		'keywords_extra' => array( 'mùa du lịch Đà Nẵng công suất phòng', 'Sun Saphia Residence', 'công suất phòng khách sạn Đà Nẵng', 'cho thuê căn hộ theo mùa Đà Nẵng', 'DIFF 2026 kín phòng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Du lịch Đà Nẵng', 'Cho thuê căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/mua-du-lich-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p><strong>Công suất phòng Đà Nẵng</strong> lên xuống rất mạnh theo mùa: có tháng kín phòng phải từ chối khách, có tháng gần như trống. Muốn tính dòng tiền cho một căn studio như {$saphia} cho thực tế, cần nhìn công suất phòng Đà Nẵng theo <strong>mùa</strong> chứ không chỉ một con số lấp đầy chung.</p>
<!--hh-featured-->
<h2>Công suất phòng Đà Nẵng: các mốc đáng tin cậy</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Công suất phòng</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Hè 2025 (tháng 6 – 8)</td><td>Bình quân 75 – 80%, cuối tuần và lễ gần kín</td><td>Đại diện khách sạn, Báo Văn hóa</td></tr>
<tr><td>Dịp 30/4 – 1/5/2026</td><td>Toàn thành phố 75 – 80%; khách sạn 4 – 5 sao 90 – 95%</td><td>Báo chí tổng hợp</td></tr>
<tr><td>Mùa pháo hoa DIFF 2026</td><td>Ven biển 85 – 95% các đêm pháo hoa; đêm chung kết khu trung tâm 95 – 98%; hơn 2,72 triệu lượt khách cả mùa lễ hội</td><td>Hội Khách sạn Đà Nẵng, Sở VH-TT-DL (SGGP, Công Thương)</td></tr>
<tr><td>12 tháng đến 6/2026</td><td>Bình quân hơn 66%, giá phòng bình quân khoảng 116 USD</td><td>CoStar (qua báo chí)</td></tr>
</tbody>
</table>
<p>Con số công suất phòng Đà Nẵng bình quân năm thấp hơn hẳn các đỉnh mùa hè – nghĩa là các tháng mùa mưa (thường từ khoảng tháng 9 đến cuối năm ở Đà Nẵng) kéo trung bình xuống đáng kể.</p>
<!--hh-img:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg|Ảnh thực tế: sông Hàn, du thuyền và cầu Rồng về đêm – công suất phòng Đà Nẵng cao nhất vào mùa hè và mùa pháo hoa-->
<h2>Vì sao công suất phòng Đà Nẵng giảm mạnh vào mùa mưa?</h2>
<p>Đà Nẵng có mùa mưa bão rõ rệt, thường tập trung vào các tháng cuối năm. Khi đó khách tắm biển giảm mạnh, một số chuyến bay quốc tế theo mùa cũng thưa đi, trong khi nguồn phòng không đổi – công suất phòng Đà Nẵng vì vậy giảm, các khách sạn phải hạ giá để giữ khách. Ngược lại, nhu cầu chung của cả năm vẫn tăng: 9 tháng năm 2026 thành phố đón khoảng 15,86 triệu lượt khách lưu trú, tăng 26,4% (<a href="https://www.vietnamplus.vn/da-nang-don-gan-16-trieu-luot-khach-luu-tru-trong-9-thang-nam-2026-post1140183.vnp">VietnamPlus</a>). Nghĩa là "chiếc bánh" lớn lên, nhưng vẫn chia không đều giữa các tháng.</p>
<h2>Tính lấp đầy theo mùa cho một studio</h2>
<p>Tài liệu chủ đầu tư dùng giả định 60% cả năm. Anh chị có thể tự kiểm tra giả định này bằng cách chia năm thành mùa, ví dụ (minh hoạ, không phải số liệu thực tế của dự án):</p>
<ul>
<li>Mùa cao điểm (tháng 4 – 8, khoảng 5 tháng): lấp đầy giả định 80%.</li>
<li>Mùa trung bình (tháng 1 – 3): giả định 55%.</li>
<li>Mùa mưa (tháng 9 – 12): giả định 35%.</li>
</ul>
<p>Bình quân gia quyền theo số tháng ra khoảng <strong>(5×80 + 3×55 + 4×35) ÷ 12 ≈ 59%</strong> – gần với giả định 60% của chủ đầu tư. Nếu mùa mưa chỉ được 20%, bình quân giảm còn khoảng 54%. Giá phòng cũng biến động theo mùa, nên doanh thu chênh còn lớn hơn mức lấp đầy.</p>
<h2>Đọc công suất phòng Đà Nẵng của khách sạn cho đúng</h2>
<p>Các số liệu công suất phòng Đà Nẵng trên báo chí chủ yếu là của khách sạn đã vận hành nhiều năm, có hệ thống bán phòng, khách đoàn và hợp đồng với công ty lữ hành. Một căn hộ cho thuê lẻ mới đưa vào khai thác thường chưa có đánh giá trên các kênh đặt phòng, nên năm đầu công suất có thể thấp hơn mức chung. Khi lập bảng tính, Hoàng Hiệp thường lấy số của thị trường trừ đi một khoảng an toàn cho năm đầu, rồi tăng dần khi căn có đánh giá tốt.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Kiếm tiền chính vào 5 – 6 tháng</strong>: định giá linh hoạt, mở bán phòng sớm cho mùa pháo hoa và hè.</li>
<li><strong>Mùa mưa nên cho thuê dài hơn</strong>: thuê theo tuần, theo tháng cho người làm việc từ xa, chuyên gia – giảm trống phòng.</li>
<li><strong>Nguồn cung tăng</strong>: báo chí dẫn số liệu khoảng 18 dự án khách sạn đang xây, thêm khoảng 6.835 phòng – cạnh tranh sẽ gắt hơn, căn có view và tiện ích tốt sẽ giữ giá tốt hơn.</li>
</ul>
<p>Xem thêm <a href="/khach-du-lich-da-nang-2026-nhu-cau-thue-can-ho-ven-bien/">lượng khách du lịch Đà Nẵng 2026</a>, <a href="/gia-phong-khach-san-ven-bien-da-nang-2026/">giá phòng khách sạn ven biển</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Báo Văn hóa (hè 2025); SGGP, Tạp chí Công Thương (DIFF 2026, Sở VH-TT-DL Đà Nẵng, Hội Khách sạn Đà Nẵng); CoStar qua báo chí (12 tháng đến 6/2026); TheLEADER (nguồn cung phòng mới). Ví dụ tính lấp đầy theo mùa do Hoàng Hiệp minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Công suất phòng Đà Nẵng 2026: tháng nào kín, tháng nào vắng',
			'desc'      => 'Công suất phòng Đà Nẵng: hè và DIFF ven biển 75 – 98%, bình quân năm khoảng 66%. Cách tính lấp đầy theo mùa khi cho thuê studio Sun Saphia Residence.',
			'points'    => array(
				'Công suất phòng Đà Nẵng mùa hè 75 – 80%, mùa pháo hoa DIFF 85 – 98%',
				'Bình quân 12 tháng đến 6/2026 hơn 66% (CoStar)',
				'Giả định 60% của chủ đầu tư cần kiểm tra theo mùa',
			),
			'faq'       => array(
				array( 'Tháng nào Đà Nẵng đông khách nhất?', 'Mùa hè (tháng 6 – 8) và mùa pháo hoa DIFF; công suất phòng ven biển các đêm pháo hoa 2026 khoảng 85 – 95%.' ),
				array( 'Công suất phòng Đà Nẵng bình quân bao nhiêu?', 'Công suất phòng Đà Nẵng của khối khách sạn bình quân 12 tháng đến 6/2026 hơn 66% theo CoStar; căn hộ cho thuê lẻ phụ thuộc cách vận hành, mùa mưa thường thấp.' ),
				array( 'Công suất phòng Đà Nẵng thấp nhất vào tháng nào?', 'Thường vào mùa mưa bão, khoảng tháng 9 đến cuối năm; nên chuyển sang cho thuê theo tuần, theo tháng trong giai đoạn này.' ),
			),
		),
		'sources'  => array(
			'https://baovanhoa.vn/nang-cao-chat-luong-du-lich-da-nang-bung-no-khach-he-2025-160231.html',
			'https://www.vietnamplus.vn/da-nang-don-gan-16-trieu-luot-khach-luu-tru-trong-9-thang-nam-2026-post1140183.vnp',
			'https://www.sggp.org.vn/diff-2026-thu-hut-hon-27-trieu-luot-khach-nhieu-khach-san-kin-phong-post861962.html',
			'https://congthuong.vn/da-nang-khach-san-chay-phong-truoc-khai-mac-diff-2026-458806.html',
			'https://baomoi.com/gan-7-000-phong-sap-do-bo-nguon-cung-khach-san-da-nang-c55535742.epi',
		),
	);

	/* ---------------- 15/11 – Khách quốc tế ---------------- */
	$posts[] = array(
		'slug'     => 'khach-quoc-te-thue-can-ho-da-nang-2026',
		'old_slug' => array( 'khach-quoc-te-da-nang-2026-han-quoc-trung-quoc-thue-can-ho-sun-saphia' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Khách Hàn Quốc chiếm hơn 20% khách quốc tế đến Đà Nẵng: ai sẽ thuê studio Sun Saphia Residence?',
		'excerpt'  => 'Nửa đầu 2026, khách Hàn Quốc chiếm 20,55% khách quốc tế đến Đà Nẵng, Trung Quốc 8,6%; 10 tháng khách quốc tế tăng 20,2%. Ý nghĩa với căn hộ cho thuê ven biển như Sun Saphia Residence.',
		'keyword'  => 'khách quốc tế thuê căn hộ',
		'keywords_extra' => array( 'khách quốc tế đến Đà Nẵng 2026', 'Sun Saphia Residence', 'khách Hàn Quốc Đà Nẵng', 'cho thuê căn hộ khách nước ngoài Đà Nẵng', 'thị trường khách du lịch Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 11:30',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Du lịch Đà Nẵng', 'Khách quốc tế' ),
		'image'    => 'plugin:img/tin-tuc/khach-quoc-te-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p><strong>Khách quốc tế thuê căn hộ</strong> ven biển Đà Nẵng ngày càng nhiều, bên cạnh khách trong nước. Biết khách quốc tế thuê căn hộ là ai, ở bao lâu, đặt phòng qua kênh nào giúp chủ căn hộ như {$saphia} chọn cách bày trí, định giá và kênh bán phòng phù hợp.</p>
<!--hh-featured-->
<h2>Khách quốc tế thuê căn hộ ở Đà Nẵng: số liệu gần nhất</h2>
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
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg|Khách quốc tế thuê căn hộ ven biển – Sun Saphia Residence bên bãi tắm Sơn Thủy (phối cảnh chủ đầu tư)-->
<h2>Khách quốc tế thuê căn hộ cần gì ở một căn studio?</h2>
<ul>
<li><strong>Gần biển, đi bộ được</strong>: khách gia đình, cặp đôi Hàn Quốc chuộng chỗ ở ven biển Mỹ Khê – Sơn Thủy, gần quán ăn, cửa hàng tiện lợi.</li>
<li><strong>Kênh đặt phòng quen thuộc</strong>: mỗi thị trường dùng nền tảng khác nhau – nên có mặt trên nhiều kênh, chi phí kênh xem bài <a href="/phi-booking-agoda-airbnb-cho-thue-can-ho/">phí Booking, Agoda, Airbnb</a>.</li>
<li><strong>Bếp nhỏ, máy giặt, wifi tốt</strong>: khách ở 4 – 7 đêm thường chọn căn hộ thay vì phòng khách sạn vì có bếp, chỗ phơi đồ.</li>
<li><strong>Thủ tục lưu trú</strong>: khách nước ngoài phải khai báo tạm trú – xem bài <a href="/cho-thue-ngan-ngay-can-ho-da-nang-phap-ly-thue/">cho thuê ngắn ngày: pháp lý, khai báo lưu trú và thuế</a>.</li>
</ul>
<h2>Mỗi nhóm khách quốc tế thuê căn hộ khác nhau thế nào?</h2>
<table>
<thead><tr><th>Nhóm khách</th><th>Đặc điểm thường gặp</th><th>Chủ căn nên chuẩn bị</th></tr></thead>
<tbody>
<tr><td>Hàn Quốc</td><td>Đi gia đình, cặp đôi, nhóm bạn; chuyến 3 – 5 đêm; quan tâm biển, ẩm thực, golf</td><td>Hướng dẫn bằng tiếng Hàn hoặc tiếng Anh đơn giản, bếp nhỏ, máy giặt</td></tr>
<tr><td>Trung Quốc</td><td>Đi nhóm, gia đình nhiều thế hệ; quan tâm chỗ ở rộng</td><td>Căn 1PN+, 2PN; hướng dẫn thanh toán, đi lại rõ ràng</td></tr>
<tr><td>Âu, Mỹ, Úc</td><td>Ở dài hơn, nhiều người làm việc từ xa</td><td>Internet mạnh, bàn làm việc, giá thuê theo tuần, theo tháng</td></tr>
</tbody>
</table>
<p>Đây là quan sát thực tế của Hoàng Hiệp khi làm việc với chủ căn cho thuê ở khu ven biển, không phải số liệu thống kê. Điểm chung: khách quốc tế thuê căn hộ đánh giá rất kỹ trên các nền tảng, nên ảnh thật, mô tả đúng và phản hồi nhanh quan trọng không kém vị trí. Với khách ở dài ngày, xem thêm bài <a href="/digital-nomad-da-nang-thue-can-ho-sun-saphia/">digital nomad Đà Nẵng</a>.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li>Studio 30 m² ở vị trí ven biển như Sun Saphia phù hợp nhóm khách 2 người – đúng nhóm đông nhất của khách quốc tế đi nghỉ ngắn ngày.</li>
<li>Khách quốc tế tăng giúp lấp phòng ngày thường và đầu mùa thấp điểm, bổ sung cho khách nội địa dồn vào cuối tuần, lễ.</li>
<li>Rủi ro: lượng khách quốc tế thuê căn hộ nhạy cảm với tỷ giá, đường bay, chính sách thị thực – không nên giả định lấp đầy cao cả năm.</li>
</ul>
<p>Toàn cảnh vị trí, giá và dòng tiền xem bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Danang Fantasticity (6 tháng 2026); BNEWS (7 tháng 2026); CafeLand, Báo Tin tức, Dân trí (10 tháng 2026). Nhận định của Hoàng Hiệp, mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Khách quốc tế thuê căn hộ Đà Nẵng 2026: Hàn Quốc 20,55%',
			'desc'      => 'Khách quốc tế thuê căn hộ Đà Nẵng: Hàn Quốc chiếm 20,55% khách quốc tế nửa đầu 2026, Trung Quốc 8,6%; 10 tháng tăng 20,2%. Ý nghĩa với studio cho thuê.',
			'points'    => array(
				'Khách quốc tế thuê căn hộ ven biển Đà Nẵng tăng theo đà khách quốc tế 2026',
				'Hàn Quốc 20,55%, Trung Quốc 8,6% khách quốc tế đến Đà Nẵng (6 tháng 2026)',
				'Khách quốc tế đến Đà Nẵng 10 tháng 2026 tăng 20,2%',
				'Studio ven biển hợp nhóm khách 2 người ở 4 – 7 đêm',
			),
			'faq'       => array(
				array( 'Khách quốc tế thuê căn hộ Đà Nẵng ở lại bao lâu?', 'Thường 3 – 7 đêm với khách đi nghỉ; khách làm việc từ xa có thể ở theo tuần, theo tháng. Đây là quan sát thực tế, không phải số liệu thống kê.' ),
				array( 'Khách quốc tế nào đến Đà Nẵng nhiều nhất?', 'Hàn Quốc, chiếm 20,55% khách quốc tế 6 tháng đầu 2026; Trung Quốc đứng thứ hai với 8,6% (Danang Fantasticity).' ),
				array( 'Khách quốc tế thuê căn hộ thì chủ nhà cần làm gì?', 'Phải khai báo tạm trú cho khách theo quy định; nên có mặt trên các kênh đặt phòng quốc tế và chuẩn bị căn có bếp, máy giặt, wifi.' ),
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
		'slug'     => 'don-vi-van-hanh-cho-thue-can-ho-sun-saphia',
		'old_slug' => array( 'tu-cho-thue-hay-thue-don-vi-van-hanh-can-ho-sun-saphia' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Tự cho thuê hay giao đơn vị vận hành? Chia 85/15, phí quản lý và bài học cam kết lợi nhuận – áp vào Sun Saphia Residence',
		'excerpt'  => 'Mô hình phổ biến là chủ căn hộ giữ 85%, đơn vị vận hành 15% lợi nhuận; phí quản lý có nơi 15 – 50%. So sánh tự cho thuê và thuê vận hành cho studio Sun Saphia Residence, cùng các điều khoản cần đọc kỹ.',
		'keyword'  => 'đơn vị vận hành cho thuê',
		'keywords_extra' => array( 'đơn vị vận hành cho thuê căn hộ', 'Sun Saphia Residence', 'tự cho thuê căn hộ du lịch', 'chia lợi nhuận 85/15', 'cam kết lợi nhuận căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Cho thuê căn hộ', 'Kinh nghiệm đầu tư' ),
		'image'    => 'plugin:img/tin-tuc/tu-cho-thue-hay-van-hanh-sun-saphia.jpg',
		'content'  => <<<HTML
<p><strong>Đơn vị vận hành cho thuê</strong> hay tự làm? Đó là câu hỏi tiếp theo sau khi mua một căn studio ven biển. Mỗi cách có chi phí và rủi ro riêng. Bài này tổng hợp các mức phí đơn vị vận hành cho thuê phổ biến trên thị trường và cách áp vào {$saphia}.</p>
<!--hh-featured-->
<h2>Đơn vị vận hành cho thuê thu phí thế nào?</h2>
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
<h2>Tự cho thuê hay thuê đơn vị vận hành cho thuê: so sánh nhanh</h2>
<table>
<thead><tr><th></th><th>Tự cho thuê</th><th>Giao đơn vị vận hành</th></tr></thead>
<tbody>
<tr><td>Thu nhập giữ lại</td><td>Cao hơn (không mất phí quản lý)</td><td>Thấp hơn (chia 15% lợi nhuận hoặc phí quản lý)</td></tr>
<tr><td>Thời gian, công sức</td><td>Nhiều: đăng phòng, đón khách, dọn phòng, xử lý sự cố</td><td>Ít, phù hợp người ở xa</td></tr>
<tr><td>Giá phòng, lấp đầy</td><td>Phụ thuộc kinh nghiệm chủ căn</td><td>Đơn vị có hệ thống bán phòng, giá động</td></tr>
<tr><td>Rủi ro</td><td>Đánh giá xấu, trống phòng nếu không chuyên</td><td>Hợp đồng bất lợi, báo cáo doanh thu thiếu minh bạch</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-layout-studio-30m2.jpg|Layout studio 30 m² Sun Saphia Residence – căn giao đơn vị vận hành cho thuê phổ biến nhất (bản vẽ chủ đầu tư)-->
<h2>Đơn vị vận hành cho thuê thực sự làm những việc gì?</h2>
<p>Một đơn vị vận hành cho thuê đầy đủ thường đảm nhận: chụp ảnh và đăng căn lên các kênh đặt phòng, định giá theo ngày, trả lời khách, nhận – trả phòng, dọn phòng và giặt là, bổ sung đồ dùng, xử lý sự cố, khai báo lưu trú, và gửi báo cáo doanh thu cho chủ căn. Có đơn vị chỉ làm một phần (ví dụ chỉ bán phòng, chủ tự thuê người dọn), phí sẽ thấp hơn. Khi so báo giá, anh chị nên liệt kê từng việc và hỏi việc nào đã gồm trong phí, việc nào tính riêng theo lượt.</p>
<h2>Bài học từ cam kết lợi nhuận</h2>
<p>Đà Nẵng từng có dự án cam kết lợi nhuận 12%/năm rồi dừng chi trả cho khoảng 1.800 khách hàng (Cocobay, theo báo chí). Một lãnh đạo doanh nghiệp bất động sản lớn từng nhận định cam kết lợi nhuận trên 10% là có vấn đề. Bài học: mức cam kết cao chưa chắc là thu nhập thật – quan trọng là năng lực của đơn vị vận hành cho thuê và hợp đồng. Báo chí cũng đã phân tích nhiều về tương lai của loại hình căn hộ du lịch sau giai đoạn cam kết lợi nhuận (xem <a href="https://thanhnien.vn/tuong-lai-nao-cho-can-ho-du-lich-185260902161933623.htm">Thanh Niên</a>).</p>
<h2>Checklist khi chọn đơn vị vận hành cho thuê</h2>
<ol>
<li>Đã vận hành bao nhiêu căn ở khu ven biển Đà Nẵng, có cho xem báo cáo mẫu (đã ẩn thông tin chủ nhà) không?</li>
<li>Điểm đánh giá trung bình các căn họ đang quản lý trên các nền tảng đặt phòng.</li>
<li>Chi phí nào trừ trước khi chia: phí kênh, dọn phòng, giặt là, đồ dùng, sửa chữa nhỏ?</li>
<li>Chủ căn được tự ở bao nhiêu đêm, phải báo trước bao lâu?</li>
<li>Điều kiện chấm dứt hợp đồng, bàn giao lại căn và tài sản.</li>
</ol>
<h2>Nhận định của Hoàng Hiệp – áp vào Sun Saphia</h2>
<ul>
<li><strong>Ở xa Đà Nẵng</strong>: nên giao đơn vị vận hành cho thuê hoặc đội quản lý căn hộ chuyên nghiệp; khoản 15% thường rẻ hơn chi phí trống phòng.</li>
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
			'seo_title' => 'Đơn vị vận hành cho thuê: chia 85/15, phí 15 – 50%',
			'desc'      => 'Đơn vị vận hành cho thuê thường chia lợi nhuận 85/15, phí quản lý 15 – 50%. So sánh với tự cho thuê studio Sun Saphia Residence và checklist hợp đồng.',
			'points'    => array(
				'Đơn vị vận hành cho thuê thường chia lợi nhuận 85/15 với chủ căn',
				'Phí quản lý có thể 15 – 50% tùy hợp đồng',
				'Cam kết lợi nhuận cao không thay được năng lực vận hành',
			),
			'faq'       => array(
				array( 'Đơn vị vận hành cho thuê thường lấy bao nhiêu phần trăm?', 'Với đơn vị vận hành cho thuê, mô hình phổ biến là chủ căn hộ giữ 85%, đơn vị vận hành nhận 15% lợi nhuận; một số hợp đồng tính phí quản lý 15 – 50% tùy dịch vụ.' ),
				array( 'Có nên tự cho thuê căn hộ Sun Saphia Residence?', 'Nếu ở Đà Nẵng và có thời gian thì có thể tự cho thuê; nếu ở xa nên giao đơn vị vận hành cho thuê chuyên nghiệp và đọc kỹ hợp đồng chia doanh thu.' ),
				array( 'Chọn đơn vị vận hành cho thuê cần hỏi gì?', 'Kinh nghiệm ở khu ven biển, điểm đánh giá các căn đang quản lý, chi phí trừ trước khi chia, số đêm chủ được ở, điều kiện chấm dứt hợp đồng.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/tuong-lai-nao-cho-can-ho-du-lich-185260902161933623.htm',
			'https://wiki.batdongsan.com.vn/phan-tich-danh-gia/toan-canh-ve-condotel-duoi-goc-nhin-ke-toan-tai-chinh-luat-102747',
			'https://theleader.vn/tieu-chuan-nao-cho-cam-ket-loi-nhuan-condotel-d24453.html',
		),
	);

	/* ---------------- 17/11 – Nội thất studio ---------------- */
	$posts[] = array(
		'slug'     => 'noi-that-studio-sun-saphia-residence-30m2',
		'old_slug' => array( 'chi-phi-noi-that-studio-30m2-cho-thue-sun-saphia' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
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
<p><strong>Nội thất studio Sun Saphia Residence</strong> là khoản chủ căn tự lo: {$saphia} dự kiến bàn giao <strong>hoàn thiện cơ bản</strong> (liền tường, trừ tủ bếp, thiết bị bếp và hút mùi) – nghĩa là để cho thuê được, chủ căn còn phải làm nội thất. Khoản này thường bị quên khi tính lợi nhuận, trong khi với một studio khoảng 2 tỷ, nội thất có thể chiếm 5 – 10% vốn.</p>
<!--hh-featured-->
<h2>Nội thất studio Sun Saphia Residence: báo giá thị trường 2026</h2>
<table>
<thead><tr><th>Gói</th><th>Studio (trọn gói)</th><th>Theo m² (quy ra 30 m²)</th></tr></thead>
<tbody>
<tr><td>Cơ bản</td><td>80 – 130 triệu</td><td>4 – 5 triệu/m² → 120 – 150 triệu</td></tr>
<tr><td>Tiêu chuẩn / đầy đủ</td><td>130 – 180 triệu</td><td>6 – 8 triệu/m² → 180 – 240 triệu</td></tr>
<tr><td>Cao cấp</td><td>180 – 300 triệu</td><td>9 – 12 triệu/m² → 270 – 360 triệu</td></tr>
</tbody>
</table>
<p>Đây là mặt bằng chung để ước tính nội thất studio Sun Saphia Residence. Số liệu do các đơn vị thi công tự công bố (NT Decor, Nội thất QI), chưa gồm hết thiết bị, rèm, vận chuyển ở một số báo giá – khi so sánh cần yêu cầu bóc tách từng hạng mục.</p>
<!--hh-img:img/sun-saphia/sun-saphia-layout-can-studio.jpg|Nội thất studio Sun Saphia Residence – layout căn mặt tiền 3,8 m, sâu 9 m (bản vẽ chủ đầu tư)-->
<h2>Nội thất studio Sun Saphia Residence cho thuê cần những gì?</h2>
<ul>
<li><strong>Giường, nệm, chăn ga khách sạn</strong> – hạng mục khách đánh giá nhiều nhất.</li>
<li><strong>Bếp nhỏ, tủ lạnh, lò vi sóng, máy giặt</strong> – lợi thế so với phòng khách sạn với khách ở dài ngày.</li>
<li><strong>Bàn làm việc, wifi mạnh, TV thông minh</strong> – cho khách công tác, làm việc từ xa.</li>
<li><strong>Rèm cản sáng, điều hòa, khóa cửa điện tử</strong> – giúp tự nhận phòng, giảm chi phí vận hành.</li>
<li><strong>Vật liệu chịu ẩm, chịu muối</strong> – căn ven biển, xem bài <a href="/can-ho-ven-bien-hoi-muoi-mua-bao-sun-saphia-residence/">hơi muối, mùa mưa bão và bảo trì</a>.</li>
</ul>
<h2>Bố trí studio 3,8 × 9 m sao cho gọn?</h2>
<p>Căn studio có mặt tiền khoảng 3,8 m, sâu khoảng 9 m – dạng căn hẹp và dài. Với nội thất studio Sun Saphia Residence, Hoàng Hiệp gợi ý chia theo chiều sâu: khu vệ sinh và bếp nhỏ sát cửa vào, khu ngủ ở giữa, khu ngồi – bàn làm việc sát logia để tận dụng ánh sáng và view. Tránh vách ngăn kín giữa các khu vì làm căn tối và chật; nếu cần tách, dùng rèm hoặc kệ thấp. Tủ âm tường dọc một bên giúp có chỗ cất đồ mà không chiếm lối đi.</p>
<p>Trần cao 3,5 m (sàn – sàn) là lợi thế: có thể làm tủ cao kịch trần, hoặc treo đèn để căn trông rộng hơn. Màu sáng, sàn và vật liệu dễ lau chùi phù hợp căn cho thuê có nhiều lượt khách.</p>
<h2>Tính nội thất studio Sun Saphia Residence vào dòng tiền</h2>
<p>Ví dụ minh hoạ: gói nội thất 150 triệu, dùng tốt khoảng 5 năm → khấu hao khoảng <strong>30 triệu/năm</strong>, cộng thêm thay đồ vải, sửa chữa nhỏ. Với bài toán tham khảo của chủ đầu tư (studio thu khoảng 351 triệu/năm trước phí), khoản này làm lợi nhuận giảm khoảng 8 – 9%. Chọn gói quá cao cấp không chắc tăng giá phòng tương ứng – nên làm gọn, bền, đẹp ảnh.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li>Với nội thất studio Sun Saphia Residence để cho thuê ven biển, gói tiêu chuẩn khoảng 130 – 180 triệu thường là điểm cân bằng.</li>
<li>Nên chốt thiết kế sớm, làm ngay sau bàn giao để không mất mùa cao điểm đầu tiên.</li>
<li>Nếu giao đơn vị vận hành, hỏi trước họ có tiêu chuẩn nội thất studio Sun Saphia Residence bắt buộc không để tránh làm hai lần.</li>
<li>Ngoài nội thất, chủ căn cho thuê ngắn ngày cần làm đúng thủ tục đăng ký hoạt động lưu trú và kê khai thuế – báo chí đã đưa tin về yêu cầu này (<a href="https://vnexpress.net/cho-thue-can-ho-ngan-ngay-trong-chung-cu-phai-dang-ky-hoat-dong-5062683.html">VnExpress</a>).</li>
</ul>
<p>Xem thêm <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí ngoài giá bán khi mua Sun Saphia</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: báo giá nội thất 2026 do NT Decor, Nội thất QI công bố trên website; bài toán cho thuê tham khảo theo tài liệu chủ đầu tư; ví dụ khấu hao do Hoàng Hiệp minh hoạ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nội thất studio Sun Saphia Residence 30 m²: 80 – 300 triệu',
			'desc'      => 'Nội thất studio Sun Saphia Residence 30 m²: gói cơ bản 80 – 130 triệu, tiêu chuẩn 130 – 180 triệu, cao cấp 180 – 300 triệu (báo giá 2026).',
			'points'    => array(
				'Nội thất studio Sun Saphia Residence do chủ căn tự làm, nên tính ngay vào vốn',
				'Sun Saphia bàn giao hoàn thiện cơ bản – chủ căn tự làm nội thất',
				'Studio: cơ bản 80 – 130 tr, tiêu chuẩn 130 – 180 tr, cao cấp 180 – 300 tr',
				'Gói 150 triệu khấu hao 5 năm khoảng 30 triệu/năm',
			),
			'faq'       => array(
				array( 'Làm nội thất studio 30 m² hết bao nhiêu tiền?', 'Theo báo giá các đơn vị thi công năm 2026: gói cơ bản 80 – 130 triệu, tiêu chuẩn 130 – 180 triệu, cao cấp 180 – 300 triệu.' ),
				array( 'Sun Saphia Residence bàn giao có nội thất không?', 'Theo tài liệu chủ đầu tư, Sun Saphia Residence bàn giao hoàn thiện cơ bản; để ở hoặc cho thuê cần làm thêm nội thất.' ),
				array( 'Nội thất studio Sun Saphia Residence nên chọn gói nào để cho thuê?', 'Gói tiêu chuẩn khoảng 130 – 180 triệu thường cân bằng giữa chi phí và giá phòng; ưu tiên giường nệm tốt, bếp nhỏ, máy giặt, wifi, vật liệu chịu ẩm.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/cho-thue-can-ho-ngan-ngay-trong-chung-cu-phai-dang-ky-hoat-dong-5062683.html',
			'https://ntdecor.vn/vi/news-vi/bao-gia-thi-cong-noi-that-can-ho-2026/',
			'https://noithatqi.vn/thi-cong-noi-that-tron-goi/',
		),
	);

	/* ---------------- 18/11 – Sân bay ---------------- */
	$posts[] = array(
		'slug'     => 'nang-cap-san-bay-da-nang-1696-ty-sun-saphia',
		'old_slug' => array( 'nang-cap-san-bay-da-nang-1696-ty-sun-saphia-residence' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Sân bay Đà Nẵng cải tạo đường băng gần 1.700 tỷ, quy hoạch 20 triệu khách/năm: Sun Saphia Residence được gì?',
		'excerpt'  => 'Dự án cải tạo đường cất hạ cánh 17R/35L và đường lăn sân bay Đà Nẵng khoảng 1.696 tỷ (2026 – 2028) đón tàu bay thân rộng; quy hoạch sân bay 20 triệu khách/năm. Ý nghĩa với căn hộ ven biển như Sun Saphia Residence.',
		'keyword'  => 'nâng cấp sân bay Đà Nẵng',
		'keywords_extra' => array( 'nâng cấp sân bay Đà Nẵng', 'Sun Saphia Residence', 'đường cất hạ cánh sân bay Đà Nẵng', 'sân bay Đà Nẵng 20 triệu khách', 'căn hộ gần sân bay Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 11:30',
		'category' => 'Hạ tầng & quy hoạch',
		'tags'     => array( 'Sun Saphia Residence', 'Hạ tầng Đà Nẵng', 'Sân bay Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/san-bay-da-nang-sun-saphia.jpg',
		'content'  => <<<HTML
<p><strong>Nâng cấp sân bay Đà Nẵng</strong> là tin đáng theo dõi với chủ căn hộ cho thuê du lịch, vì sân bay là "cửa ngõ" đưa khách tới. Sân bay quốc tế Đà Nẵng đang bước vào đợt cải tạo lớn và đã có quy hoạch nâng công suất – bài này tóm tắt các dự án nâng cấp sân bay Đà Nẵng và ý nghĩa với căn hộ ven biển như {$saphia}.</p>
<!--hh-featured-->
<h2>Nâng cấp sân bay Đà Nẵng: dự án cải tạo đường cất hạ cánh</h2>
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
<h2>Quy hoạch và nâng cấp sân bay Đà Nẵng đến 2030</h2>
<ul>
<li>Quyết định 222/QĐ-BXD ngày 12/2/2026: sân bay cấp 4E, công suất khoảng <strong>20 triệu hành khách</strong> và 100.000 tấn hàng hóa/năm giai đoạn 2021 – 2030.</li>
<li>Nhà ga T1 mở rộng về phía Nam lên 14 triệu khách/năm; nhà ga T2 6 triệu khách/năm.</li>
<li>Năm 2025, sân bay phục vụ khoảng 15,1 triệu lượt khách, gần 89.800 chuyến bay.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-ban-do-ket-noi.jpg|Nâng cấp sân bay Đà Nẵng và bản đồ kết nối Sun Saphia Residence: bãi tắm Sơn Thủy, Ngũ Hành Sơn, sân bay (tài liệu chủ đầu tư)-->
<h2>Từ sân bay đến Sun Saphia</h2>
<p>Sân bay nằm ngay trong nội đô; biển Mỹ Khê cách sân bay khoảng 6,5 km. Sun Saphia ở khu Sơn Thủy, phía Nam Mỹ Khê – khoảng 9 – 10 km đường xe, thường dưới 25 phút (ước tính theo bản đồ, tùy giờ). Trong tương lai, tuyến đường sắt đô thị sân bay – biển dự kiến có ga cách dự án khoảng 500 m – xem bài <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">đường sắt đô thị sân bay – Mỹ Khê – Hội An</a>.</p>
<h2>Nâng cấp sân bay Đà Nẵng tác động đến khách lưu trú thế nào?</h2>
<p>Tác động rõ nhất của việc nâng cấp sân bay Đà Nẵng nằm ở <strong>loại tàu bay</strong>: đường băng đạt chuẩn đón tàu bay thân rộng (Code E) giúp các hãng mở chặng bay dài hơn, chở nhiều khách hơn mỗi chuyến. Khách từ các thị trường xa thường ở lâu hơn khách bay chặng ngắn, phù hợp với căn hộ có bếp, máy giặt hơn là phòng khách sạn nhỏ.</p>
<p>Tác động thứ hai là <strong>sức chứa</strong>: khi nhà ga T1, T2 mở rộng đúng quy hoạch, sân bay có dư địa từ 15,1 triệu khách (2025) lên khoảng 20 triệu khách/năm. Tuy vậy, sân bay chỉ là điều kiện cần – khách có đến hay không còn phụ thuộc đường bay, chính sách thị thực và sức hút điểm đến. Vì vậy Hoàng Hiệp xem nâng cấp sân bay Đà Nẵng là yếu tố hỗ trợ dài hạn, không phải lý do để tăng giả định giá thuê ngay.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Đón tàu bay thân rộng</strong> mở đường cho các chặng bay dài, thêm khách từ thị trường xa – nhóm khách thường ở lâu hơn, chi tiêu cao hơn.</li>
<li><strong>Công suất 20 triệu khách/năm</strong> so với 15,1 triệu năm 2025 là dư địa tăng trưởng rõ ràng cho lưu trú ven biển.</li>
<li><strong>Lưu ý</strong>: trong thời gian nâng cấp sân bay Đà Nẵng 2026 – 2028 có thể điều chỉnh khai thác; tác động lên giá căn hộ là dài hạn.</li>
</ul>
<p>Toàn cảnh vị trí, giá và dòng tiền xem bài {$review}.</p>
{$cta}
<p class="src">Nguồn: Quyết định 1417/QĐ-BXD (LuatVietnam), VnEconomy; Thời báo Tài chính (mốc khởi công dự kiến); quy hoạch sân bay theo Quyết định 222/QĐ-BXD (VnExpress, Dân trí); khoảng cách Mỹ Khê – sân bay theo Traveloka. Thời gian di chuyển đến dự án là ước tính.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nâng cấp sân bay Đà Nẵng 1.696 tỷ: căn hộ ven biển được gì',
			'desc'      => 'Nâng cấp sân bay Đà Nẵng: cải tạo đường băng 17R/35L khoảng 1.696 tỷ (2026 – 2028), quy hoạch 20 triệu khách/năm. Căn hộ ven biển như Sun Saphia được gì?',
			'points'    => array(
				'Nâng cấp sân bay Đà Nẵng để đón tàu bay thân rộng Code E',
				'QĐ 1417/QĐ-BXD: cải tạo đường cất hạ cánh 17R/35L, khoảng 1.696 tỷ, 2026 – 2028',
				'Quy hoạch sân bay khoảng 20 triệu khách/năm; năm 2025 đón 15,1 triệu',
				'Sun Saphia cách sân bay khoảng 9 – 10 km đường xe (ước tính)',
			),
			'faq'       => array(
				array( 'Dự án nâng cấp sân bay Đà Nẵng (đường băng) bao nhiêu tiền?', 'Dự án nâng cấp sân bay Đà Nẵng phần đường băng khoảng 1.696 tỷ đồng theo Quyết định 1417/QĐ-BXD ngày 12/8/2026, cải tạo đường cất hạ cánh 17R/35L và đường lăn, thực hiện 2026 – 2028.' ),
				array( 'Sun Saphia Residence cách sân bay Đà Nẵng bao xa?', 'Khoảng 9 – 10 km đường xe, thường dưới 25 phút tùy giờ (ước tính theo bản đồ).' ),
				array( 'Nâng cấp sân bay Đà Nẵng có làm tăng giá thuê căn hộ ngay không?', 'Không nên kỳ vọng ngay. Đây là yếu tố hỗ trợ dài hạn; lượng khách còn phụ thuộc đường bay, thị thực và sức hút điểm đến.' ),
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
		'slug'     => 'can-2pn-sun-saphia-residence-60-70m2',
		'old_slug' => array( 'can-2pn-sun-saphia-residence-60-70m2-o-hay-cho-thue' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
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
<p><strong>Căn 2PN Sun Saphia Residence</strong> chỉ có 133 căn, diện tích thông thủy 60 – 70 m², trong khi phần lớn {$saphia} là studio (513 căn). Căn 2PN Sun Saphia Residence là loại căn hiếm về tỷ lệ và hợp với nhóm khách khác hẳn studio.</p>
<!--hh-featured-->
<h2>Căn 2PN Sun Saphia Residence có gì?</h2>
<table>
<tbody>
<tr><th>Số lượng</th><td>133 căn (tài liệu chủ đầu tư 10/2026)</td></tr>
<tr><th>Diện tích thông thủy</th><td>60 – 70 m² (các mẫu 61, 67, 70 m²)</td></tr>
<tr><th>Vị trí</th><td>Ở các góc tòa; tầng điển hình 3A – 28 có 5 căn 2PN/sàn</td></tr>
<tr><th>Chiều cao tầng căn hộ</th><td>3,5 m</td></tr>
<tr><th>Bàn giao</th><td>Hoàn thiện cơ bản, dự kiến 11/2028</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-70m2.jpg|Căn 2PN Sun Saphia Residence – layout 70 m² (bản vẽ chủ đầu tư)-->
<h2>Ưu điểm của căn 2PN Sun Saphia Residence</h2>
<ul>
<li><strong>Căn góc</strong>: hai mặt thoáng, nhiều cửa sổ, nhiều góc nhìn hơn căn giữa.</li>
<li><strong>Ít hàng</strong>: chỉ khoảng 17% số căn của tòa – nguồn cung hạn chế so với studio.</li>
<li><strong>Nhóm khách riêng</strong>: gia đình 4 người, nhóm bạn – khó thuê được 2 phòng khách sạn liền nhau mùa cao điểm, căn 2PN có bếp, phòng khách là lựa chọn tốt.</li>
</ul>
<h2>Căn 2PN Sun Saphia Residence: điểm cần cân nhắc</h2>
<ul>
<li><strong>Tổng tiền cao hơn studio</strong> nhiều lần; giá chính thức chưa công bố – cần chờ bảng giá khi mở bán.</li>
<li><strong>Lấp đầy</strong> căn lớn thường thấp hơn studio vào ngày thường, nhưng giá mỗi đêm cao hơn.</li>
<li><strong>Nội thất, vận hành</strong> tốn hơn: 2 phòng ngủ, 2 bộ giường, thời gian dọn phòng lâu hơn.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-61m2.jpg|Layout căn 2PN 61 m² Sun Saphia Residence (bản vẽ chủ đầu tư)-->
<h2>Ba mẫu 61, 67, 70 m² khác nhau ở đâu?</h2>
<p>Theo bản vẽ chủ đầu tư, căn 2PN Sun Saphia Residence có ba mẫu diện tích chính 61, 67 và 70 m². Chênh lệch chủ yếu nằm ở phòng khách – bếp và độ rộng phòng ngủ chính; căn lớn hơn thường có thêm mặt thoáng ở góc tòa. Khi chọn, anh chị nên đặt hai bản vẽ cạnh nhau và tự hỏi: gia đình cần phòng khách rộng để sinh hoạt chung, hay cần phòng ngủ thứ hai đủ đặt giường đôi cho khách thuê? Với mục đích cho thuê nhóm 4 người, hai phòng ngủ đều đặt được giường đôi là ưu tiên số một.</p>
<h2>Ví dụ so sánh: 1 căn 2PN hay 2 căn studio?</h2>
<p>Nhà đầu tư thường đặt câu hỏi này vì tổng tiền có thể gần nhau. Hai căn studio cho phép bán lẻ từng căn, thuê được hai nhóm khách cùng lúc vào ngày thường, và khi cần tiền có thể bán một căn. Một căn 2PN Sun Saphia Residence hợp hơn khi khách là gia đình muốn ở chung, khi chủ nhà muốn có căn nghỉ dưỡng cho cả nhà, và chỉ phải quản lý một căn. Giá căn 2PN chưa công bố, nên phép so sánh chính xác chỉ làm được khi có bảng giá chính thức.</p>
<p>Một điểm cộng của các căn góc là tầm nhìn: phía trước dự án là công viên biển khoảng 2,45 ha do thành phố đầu tư (<a href="https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp">VietnamPlus</a>), nên góc nhìn ra biển và công viên ít khả năng bị che.</p>
<h2>Nhận định của Hoàng Hiệp: ai nên chọn căn 2PN Sun Saphia Residence?</h2>
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
			'seo_title' => 'Căn 2PN Sun Saphia Residence 60 – 70 m²: ở hay cho thuê?',
			'desc'      => 'Căn 2PN Sun Saphia Residence: 133 căn 60 – 70 m² ở các góc tòa, 5 căn mỗi sàn điển hình. Ưu nhược điểm, so sánh với 2 studio, ai nên mua để ở, cho thuê.',
			'points'    => array(
				'Căn 2PN Sun Saphia Residence: 133 căn thông thủy 60 – 70 m², ở các góc tòa',
				'Chỉ khoảng 17% số căn – nguồn cung hạn chế',
				'Hợp gia đình nghỉ dưỡng kết hợp cho thuê',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có bao nhiêu căn 2 phòng ngủ?', 'Theo tài liệu chủ đầu tư 10/2026, có 133 căn 2PN diện tích thông thủy 60 – 70 m², nằm ở các góc tòa.' ),
				array( 'Căn 2PN Sun Saphia Residence giá bao nhiêu?', 'Giá chính thức căn 2PN chưa công bố; bảng giá sẽ có khi mở bán – liên hệ Hoàng Hiệp để nhận khi có.' ),
				array( 'Nên mua 1 căn 2PN Sun Saphia Residence hay 2 căn studio?', 'Hai studio linh hoạt hơn khi cho thuê và bán lại từng căn; căn 2PN hợp gia đình nghỉ dưỡng, khách đi nhóm 4 người và người muốn quản lý một căn.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp',
		),
	);

	return $posts;
}
