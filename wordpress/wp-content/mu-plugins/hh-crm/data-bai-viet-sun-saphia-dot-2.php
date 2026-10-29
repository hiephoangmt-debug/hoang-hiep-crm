<?php
/**
 * Loạt bài từ khoá Sun Saphia Residence (đợt 2: 22 – 29/10/2026, 15:00 mỗi ngày) – nhắm các truy vấn người mua hay tìm:
 * giá, mặt bằng, vị trí, pháp lý, đầu tư cho thuê, có nên mua, tiến độ, phân biệt với Khu đô thị Saphia.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Giá: chưa có bảng giá chủ đầu tư; chỉ dùng giá tin rao (ghi rõ) và ước tính có công thức.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_2' );
function hh_posts_sun_saphia_dot_2( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Đăng ký nhận bảng giá, mặt bằng tầng và chính sách ' . $saphia . ' ngay khi chủ đầu tư công bố, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi kèm bảng so sánh với các dự án ven biển cùng tầm tiền.</p>';
	$facts  = '<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Sun Group (Sun Property phát triển)</td></tr>
<tr><th>Vị trí</th><td>Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng</td></tr>
<tr><th>Quy mô</th><td>1 tòa 30 tầng (114 m), 2 tầng hầm, đất 3.720,1 m²</td></tr>
<tr><th>Số căn</th><td>782 căn: 513 studio, 108 căn 1PN+, 133 căn 2PN</td></tr>
<tr><th>Pháp lý</th><td>Thời hạn dự án 50 năm kể từ 17/09/2026; công trình cấp I, niên hạn 100 năm</td></tr>
<tr><th>Bàn giao</th><td>Dự kiến 11/2028</td></tr>
</tbody>
</table>';

	/* ---------------- 22/10 – Giá ---------------- */
	$posts[] = array(
		'slug'     => 'gia-sun-saphia-residence-bao-nhieu',
		'title'    => 'Giá Sun Saphia Residence bao nhiêu? Giá dự kiến studio tầng 15 từ 2,13 tỷ (cập nhật 28/10/2026)',
		'excerpt'  => 'Giá dự kiến (rumor) Sun Saphia Residence ngày 28/10/2026: studio 30 m² tầng 15 khoảng 2,13 – 2,85 tỷ (giá có vay, chưa VAT, chưa KPBT), hỗ trợ lãi suất tới 24 tháng. Cách đọc giá và so sánh căn hộ ven biển.',
		'keyword'  => 'giá Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'bảng giá Sun Saphia', 'giá căn hộ Sun Saphia Đà Nẵng', 'giá studio Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-22 15:00',
		'rev'      => 3, // 28/10: giá dự kiến (rumor) studio tầng 15, chính sách hỗ trợ lãi suất 24 tháng, sự kiện bán hàng 28/11.
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/gia-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Giá Sun Saphia Residence</strong> là câu hỏi Hoàng Hiệp nhận nhiều nhất từ khi dự án nhận giữ chỗ. Ngày <strong>28/10/2026</strong>, chủ đầu tư đưa ra <strong>giá dự kiến (giá "rumor") cho một số căn studio tầng 15</strong>; bảng giá chính thức từng căn sẽ có khi mở bán. Bài này cập nhật mức giá dự kiến đó, cách đọc giá cho đúng và so sánh với các dự án ven biển khác của {$saphia}.</p>
<!--hh-featured-->
<h2>Giá dự kiến studio tầng 15 (28/10/2026)</h2>
<table>
<thead><tr><th>Vị trí căn studio tầng 15</th><th>Thông thủy</th><th>Giá dự kiến (có vay)</th><th>Quy ra/m² thông thủy</th></tr></thead>
<tbody>
<tr><td>Dãy mặt biển – view biển trực diện</td><td>30 m²</td><td><strong>2,85 tỷ</strong></td><td>khoảng 95 triệu/m²</td></tr>
<tr><td>Cánh bên – hông tòa</td><td>30 m²</td><td><strong>2,37 tỷ</strong></td><td>khoảng 79 triệu/m²</td></tr>
<tr><td>Dãy phía sau – không hướng biển</td><td>30 m²</td><td><strong>2,13 tỷ</strong></td><td>khoảng 71 triệu/m²</td></tr>
</tbody>
</table>
<ul>
<li>Đây là <strong>giá dự kiến</strong> áp dụng khi mua theo <strong>phương án có vay ngân hàng</strong>, chưa phải giá chốt.</li>
<li>Giá <strong>chưa gồm VAT</strong> và <strong>kinh phí bảo trì 2%</strong>, <strong>chưa trừ chiết khấu</strong> đặt chỗ sớm.</li>
<li>Bàn giao <strong>hoàn thiện cơ bản</strong>.</li>
<li>Cột giá/m² do Hoàng Hiệp tự tính (chia cho 30 m² thông thủy) để dễ so sánh.</li>
</ul>
<p>Chênh lệch giữa căn mặt biển và căn phía sau cùng tầng khoảng <strong>0,7 tỷ</strong> – view biển là yếu tố quyết định giá lớn nhất ở Sun Saphia.</p>
<h2>Chính sách bán hàng và lịch sự kiện</h2>
<ul>
<li><strong>Hỗ trợ lãi suất lên tới 24 tháng</strong>.</li>
<li><strong>Không có chương trình nhận nhà sớm (early key)</strong>; bàn giao dự kiến tháng 11/2028.</li>
<li>Các sự kiện giới thiệu dự án tại Đà Nẵng dự kiến ngày 01/11 và 15/11/2026; <strong>sự kiện bán hàng của chủ đầu tư dự kiến 28/11/2026</strong>.</li>
</ul>
<h2>Giá Sun Saphia Residence trên tin rao (trước 28/10)</h2>
<p>Trước khi có giá dự kiến, các trang tổng hợp tin đăng ghi nhận mức giá khác nhau giữa các tin, khoảng <strong>64,5 – 83 triệu/m²</strong>, nhiều tin để "giá thỏa thuận". Đây là giá người đăng tự ghi, chưa phải giá của chủ đầu tư, và chưa rõ đã gồm VAT, phí bảo trì hay chưa.</p>
<h2>Ước tính tổng tiền theo loại căn</h2>
<p>Lấy khoảng giá tin rao nhân với diện tích công bố (chưa rõ diện tích thông thủy hay tim tường):</p>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Diện tích</th><th>Tổng tiền ước tính</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>513</td><td>30 – 31 m²</td><td>Khoảng 1,9 – 2,6 tỷ</td></tr>
<tr><td>1PN+1</td><td>108</td><td>50 – 51 m²</td><td>Khoảng 3,2 – 4,2 tỷ</td></tr>
<tr><td>2PN</td><td>133</td><td>60 – 70 m²</td><td>Khoảng 3,9 – 5,8 tỷ</td></tr>
</tbody>
</table>
<p>Con số chỉ để hình dung tầm tiền. Giá thật phụ thuộc tầng, hướng nhìn biển, chính sách chiết khấu và phương án thanh toán.</p>
<h2>Giá tham khảo trong tài liệu chủ đầu tư (10/2026)</h2>
<p>Trong bài toán cho thuê của tài liệu giới thiệu dự án, chủ đầu tư dùng <strong>giá tham khảo studio 30 m² khoảng 3 tỷ</strong> (khoảng 100 triệu/m²) và <strong>căn 1PN 50 m² khoảng 4,5 tỷ</strong> (khoảng 90 triệu/m²). Đây là con số minh họa cho bài toán, chưa phải bảng giá – nhưng cho thấy giá mở bán nhiều khả năng cao hơn mức tin rao 64,5 – 83 triệu/m².</p>
<h2>So với căn hộ ven biển khác</h2>
<p>Tài liệu giới thiệu ngày 28/10/2026 của chủ đầu tư đưa mức <strong>giá tham khảo căn hộ mặt biển trên thị trường Đà Nẵng</strong>: studio khoảng <strong>5,x – 6,x tỷ</strong>, căn 1PN khoảng <strong>7,x – 9,x tỷ</strong>, căn 2PN khoảng <strong>12,x – 20,x tỷ</strong>. So với mức này, studio Sun Saphia tầng 15 giá dự kiến 2,13 – 2,85 tỷ thấp hơn nhiều về tổng tiền, chủ yếu vì diện tích nhỏ (30 m²).</p>
<p>Tài liệu bán hàng của chủ đầu tư dẫn giá chuyển nhượng tham khảo studio tại The Soleil khoảng 4,6 – 5,4 tỷ, Nobu Đà Nẵng khoảng 6,3 – 6,4 tỷ. Studio Sun Costa Residence giá bán 2025 khoảng 2,45 – 2,95 tỷ (chưa VAT). Nếu giá Sun Saphia nằm trong khoảng tin rao, studio Sun Saphia thuộc nhóm tổng tiền dễ tiếp cận nhất trong các căn hộ sát biển. Xem thêm <a href="/studio-ven-bien-da-nang-gia-mua-gia-thue-2026/">giá studio ven biển Đà Nẵng 2026</a>.</p>
<h2>5 câu cần hỏi khi nhận bảng giá</h2>
<ol>
<li>Giá đã gồm VAT và 2% kinh phí bảo trì chưa?</li>
<li>Diện tích tính giá là thông thủy hay tim tường?</li>
<li>Chiết khấu thanh toán sớm, hỗ trợ lãi suất áp dụng tới khi nào?</li>
<li>Thời hạn sở hữu ghi trong hợp đồng: tài liệu chủ đầu tư ghi thời hạn dự án 50 năm kể từ 17/09/2026.</li>
<li>Có cam kết hoặc chương trình cho thuê không, điều kiện ra sao?</li>
</ol>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Sun Saphia Residence: studio tầng 15 từ 2,13 tỷ',
			'desc'      => 'Giá dự kiến Sun Saphia Residence 28/10/2026: studio 30 m² tầng 15 khoảng 2,13 – 2,85 tỷ (có vay, chưa VAT, KPBT), hỗ trợ lãi suất 24 tháng, mở bán dự kiến 28/11.',
			'points'    => array(
				'Giá dự kiến 28/10/2026: studio 30 m² tầng 15 khoảng 2,13 – 2,85 tỷ (phương án có vay)',
				'Chưa gồm VAT, kinh phí bảo trì 2%, chưa trừ chiết khấu đặt chỗ sớm',
				'Hỗ trợ lãi suất lên tới 24 tháng; sự kiện bán hàng dự kiến 28/11/2026',
			),
			'faq'       => array(
				array( 'Studio Sun Saphia Residence giá bao nhiêu?', 'Giá dự kiến ngày 28/10/2026 cho studio 30 m² tầng 15 khoảng 2,13 – 2,85 tỷ tùy vị trí (căn mặt biển cao nhất), theo phương án có vay, chưa gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu.' ),
				array( 'Giá Sun Saphia Residence bao nhiêu một m²?', 'Quy từ giá dự kiến studio tầng 15, khoảng 71 – 95 triệu/m² thông thủy (Hoàng Hiệp tự tính). Bảng giá chính thức từng căn có khi mở bán.' ),
				array( 'Sun Saphia Residence có hỗ trợ lãi suất không?', 'Có, chính sách đợt giới thiệu hỗ trợ lãi suất lên tới 24 tháng; không có chương trình nhận nhà sớm (early key).' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 23/10 – Mặt bằng ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-can-ho-sun-saphia-residence',
		'title'    => 'Mặt bằng Sun Saphia Residence: 782 căn, 513 studio, 108 căn 1PN+, 133 căn 2PN – chọn căn nào?',
		'excerpt'  => 'Mặt bằng Sun Saphia Residence gồm 782 căn trong tòa 30 tầng: studio 30 – 31 m², 1PN+1 50 – 51 m², 2PN 60 – 70 m². Mỗi loại căn hợp với ai, cách chọn tầng và hướng.',
		'keyword'  => 'mặt bằng Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'layout căn hộ Sun Saphia', 'căn hộ 2 phòng ngủ Sun Saphia', 'căn 1PN+1 Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-23 15:00',
		'rev'      => 2, // 23/10: số căn 2PN 133, mặt bằng tầng 3A – 28 (28 căn/sàn) theo tài liệu chủ đầu tư.
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/mat-bang-sun-saphia-residence.jpg',
		'image_replace' => true, // Ảnh cũ ghi 149 căn 2PN.
		'content'  => <<<HTML
<p><strong>Mặt bằng Sun Saphia Residence</strong> cho thấy rõ định hướng của dự án: hơn 65% số căn là studio. Bài tổng hợp cơ cấu căn theo tài liệu giới thiệu của chủ đầu tư và gợi ý chọn căn {$saphia} theo mục đích mua.</p>
<!--hh-featured-->
<h2>Cơ cấu 782 căn hộ</h2>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Tỷ lệ</th><th>Diện tích</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>513</td><td>Khoảng 66%</td><td>30 – 31 m²</td></tr>
<tr><td>1PN+1</td><td>108</td><td>Khoảng 14%</td><td>50 – 51 m²</td></tr>
<tr><td>2PN</td><td>133</td><td>Khoảng 17%</td><td>60 – 70 m²</td></tr>
</tbody>
</table>
<p>Ba loại căn cộng lại 754 căn theo tài liệu giới thiệu ngày 23/10/2026 (tài liệu trước ghi 149 căn 2PN); số căn còn lại thuộc các tầng có mặt bằng khác, chưa công bố chi tiết.</p>
<h2>Mặt bằng tầng 3A – 28: 28 căn mỗi sàn</h2>
<p>Mặt bằng tầng điển hình của chủ đầu tư cho thấy mỗi sàn từ tầng 3A đến 28 có <strong>19 studio, 4 căn 1PN+ và 5 căn 2PN</strong>. Studio thông thủy 30 – 31 m² (căn góc 40 m²), mặt tiền 3,8 m, sâu 9 m; 1PN+ thông thủy 49 – 51 m²; 2PN thông thủy 60 – 70 m² nằm ở các góc tòa. Dãy căn phía Đông nhìn ra biển. Chiều cao tầng căn hộ 3,5 m, bàn giao hoàn thiện cơ bản.</p>
<h2>Studio 30 – 31 m²: cho thuê ngắn hạn</h2>
<p>Tổng tiền thấp nhất, dễ cho thuê theo ngày cho khách du lịch. Đổi lại, 513 căn cùng loại trong một tòa nghĩa là cạnh tranh cho thuê cao: căn tầng cao, nhìn biển, gần thang máy nhưng không sát phòng kỹ thuật sẽ có lợi thế.</p>
<h2>1PN+1 50 – 51 m²: ở hoặc cho thuê dài hạn</h2>
<p>Phòng "+1" dùng làm phòng làm việc hoặc phòng ngủ nhỏ – hợp vợ chồng trẻ, người làm việc từ xa, chuyên gia thuê theo năm. Chỉ có 108 căn nên nguồn cung hiếm hơn studio.</p>
<h2>2PN 60 – 70 m²: gia đình, nghỉ dưỡng</h2>
<p>Phù hợp gia đình nhỏ ở thật hoặc mua căn nghỉ dưỡng cuối tuần. Căn 2PN góc thường có hai mặt thoáng và giữ giá tốt hơn khi bán lại.</p>
<h2>Chọn tầng và hướng</h2>
<ul>
<li><strong>Hướng Đông</strong> (ra biển Sơn Thủy, công viên khoảng 2,45 ha phía trước) là hướng được săn nhất.</li>
<li><strong>Tầng cao</strong> nhìn biển rộng hơn; tầng thấp gần khối đế thương mại có thể ồn hơn.</li>
<li>Hỏi rõ vị trí phòng rác, phòng kỹ thuật, thang máy trên mặt bằng tầng trước khi chọn căn.</li>
</ul>
<p>Đọc thêm: <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia Residence ước tính theo loại căn</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng Sun Saphia Residence: studio, 1PN+1, 2PN',
			'desc'      => 'Mặt bằng Sun Saphia Residence: 782 căn, mỗi sàn 3A – 28 có 19 studio, 4 căn 1PN+, 5 căn 2PN; 133 căn 2PN 60 – 70 m². Chọn tầng, hướng thế nào.',
			'points'    => array(
				'782 căn trong tòa 30 tầng, khoảng 66% là studio',
				'1PN+1 chỉ 108 căn – nguồn cung hiếm hơn studio',
				'Hướng Đông nhìn biển Sơn Thủy và công viên ven biển',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có những loại căn nào?', 'Studio 30 – 31 m² (513 căn), 1PN+ 49 – 51 m² (108 căn), 2PN 60 – 70 m² (133 căn) theo tài liệu giới thiệu 23/10/2026 của chủ đầu tư.' ),
				array( 'Mỗi sàn Sun Saphia Residence có bao nhiêu căn?', 'Tầng điển hình 3A – 28 có 28 căn: 19 studio, 4 căn 1PN+ và 5 căn 2PN.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 24/10 – Vị trí ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-o-dau-vi-tri',
		'title'    => 'Sun Saphia Residence ở đâu? Vị trí trên đường Trường Sa, bãi tắm Sơn Thủy và kết nối xung quanh',
		'excerpt'  => 'Sun Saphia Residence nằm trên đường Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng – đối diện công viên ven biển khoảng 2,45 ha. Xung quanh có gì, đi đâu bao xa.',
		'keyword'  => 'Sun Saphia Residence ở đâu',
		'keywords_extra' => array( 'Sun Saphia Residence', 'vị trí Sun Saphia Residence', 'Sun Saphia Trường Sa', 'căn hộ bãi tắm Sơn Thủy' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-24 15:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn' ),
		'image'    => 'plugin:img/tin-tuc/vi-tri-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Sun Saphia Residence ở đâu?</strong> Dự án nằm tại giao lộ <strong>Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa</strong>, ngay khu <strong>bãi tắm Sơn Thủy</strong> – đoạn biển giữa Mỹ Khê và Non Nước, thuộc phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng. Đây là vị trí của tòa tháp 30 tầng {$saphia} mà Sun Group giới thiệu là dự án căn hộ mặt biển đầu tiên của tập đoàn tại Đà Nẵng.</p>
<!--hh-featured-->
<h2>Địa chỉ và thông tin nhanh</h2>
{$facts}
<h2>Phía trước: công viên bãi tắm Sơn Thủy</h2>
<p>Bên kia đường Trường Sa, thành phố đã thu hồi khoảng <strong>2,45 ha</strong> đất phía Nam dự án Hòn Ngọc Á Châu (bỏ hoang nhiều năm) để làm công viên công cộng, tổng mức đầu tư hơn 47 tỷ đồng, thực hiện giai đoạn 2025 – 2027: bãi đỗ xe, đường dạo, sân tập, khu vui chơi trẻ em, quảng trường biển (VietnamPlus, Tiền Phong). Cư dân ra biển qua công viên thay vì khu đất trống.</p>
<p>Dọc tuyến biển có chuỗi 3 công viên bãi tắm: bãi tắm Sơn Thủy, công viên đối diện dự án và công viên bãi tắm cuối đường Huyền Trân Công Chúa. Từ tầng cao, tầm nhìn bao quát biển Mỹ Khê, Ngũ Hành Sơn, dòng sông phía Tây và đô thị.</p>
<h2>Xung quanh có gì?</h2>
<ul>
<li>Danh thắng <strong>Ngũ Hành Sơn</strong>, các resort ven biển như Premier Village, Sheraton Grand, sân golf ven biển.</li>
<li>Khu đô thị <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a> của Sun Group.</li>
<li>Theo bản đồ kết nối của chủ đầu tư: khoảng 4 km tới <a href="/du-an/sun-galaxy-complex/">Sun Galaxy</a> và <a href="/du-an/da-nang-downtown/">Đà Nẵng Downtown</a>.</li>
</ul>
<h2>Hạ tầng sắp tới</h2>
<ul>
<li><a href="/mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty/">Mở rộng đường Võ Nguyên Giáp – Trường Sa</a>, vốn dự kiến 2.633 tỷ đồng.</li>
<li><a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">Đường sắt đô thị sân bay – Mỹ Khê – Hội An</a>: theo tài liệu chủ đầu tư, dự án cách <strong>ga LRT 09 khoảng 500 m</strong>.</li>
<li><a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">Cao tốc nội thị Đà Nẵng – Chu Lai</a> đi theo đường Lê Văn Hiến, song song đường Trường Sa.</li>
</ul>
<p>Xem các dự án khác cùng khu: <a href="/khu-vuc/ngu-hanh-son/">dự án Ngũ Hành Sơn</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence ở đâu? Vị trí Trường Sa, Sơn Thủy',
			'desc'      => 'Sun Saphia Residence ở giao lộ Võ Nguyên Giáp – Trường Sa, bãi tắm Sơn Thủy, đối diện công viên biển 2,45 ha, cách ga LRT 09 khoảng 500 m.',
			'points'    => array(
				'Đường Trường Sa, bãi tắm Sơn Thủy, phường Ngũ Hành Sơn',
				'Đối diện công viên công cộng khoảng 2,45 ha đang đầu tư',
				'Khoảng 4 km tới Sun Galaxy, Đà Nẵng Downtown (theo chủ đầu tư)',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence nằm ở đường nào?', 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn (Hòa Hải cũ), Đà Nẵng.' ),
				array( 'Từ Sun Saphia Residence ra biển bao xa?', 'Dự án nằm ngay khu bãi tắm Sơn Thủy, phía trước là công viên ven biển khoảng 2,45 ha rồi đến bãi biển.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp',
			'https://tienphong.vn/da-nang-rot-47-ty-dong-danh-thuc-khu-dat-vang-bo-hoang-post1767479.html',
		),
	);

	/* ---------------- 25/10 – Pháp lý ---------------- */
	$posts[] = array(
		'slug'     => 'phap-ly-sun-saphia-residence-so-huu-bao-lau',
		'title'    => 'Pháp lý Sun Saphia Residence: thời hạn 50 năm từ 17/9/2026, công trình niên hạn 100 năm – người mua cần biết gì?',
		'excerpt'  => 'Pháp lý Sun Saphia Residence: thời hạn dự án 50 năm kể từ 17/09/2026, công trình cấp I niên hạn 100 năm. Căn hộ 50 năm khác căn lâu dài thế nào, Nghị quyết 278 và 6 giấy tờ cần kiểm tra.',
		'keyword'  => 'pháp lý Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Sun Saphia sở hữu 50 năm', 'Sun Saphia sổ hồng', 'pháp lý căn hộ Sun Group Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-25 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/tin-tuc/phap-ly-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Pháp lý Sun Saphia Residence</strong> đã rõ hơn: tài liệu giới thiệu dự án của chủ đầu tư (10/2026) ghi <strong>thời hạn dự án 50 năm kể từ ngày 17/09/2026</strong>, công trình <strong>cấp I, niên hạn sử dụng 100 năm</strong>; ngân hàng hỗ trợ gồm VietinBank, BIDV, NCB. Bài giải thích ý nghĩa của thời hạn này và các giấy tờ cần hỏi khi mua {$saphia}.</p>
<!--hh-featured-->
<h2>Thời hạn 50 năm của Sun Saphia nghĩa là gì?</h2>
<ul>
<li><strong>50 năm</strong> là thời hạn sử dụng đất của dự án, tính từ 17/09/2026 – tức đến khoảng năm 2076; khi hết hạn có thể được xem xét gia hạn theo quy định đất đai.</li>
<li><strong>Niên hạn công trình 100 năm</strong> là tuổi thọ thiết kế của tòa nhà cấp I – dài hơn thời hạn đất.</li>
<li>Nghị quyết 278/NQ-CP ngày 18/9/2026 của Chính phủ giao các cơ quan làm rõ thời hạn sử dụng chung cư theo niên hạn công trình và quyền, nghĩa vụ khi hết thời hạn, hướng tới tách bạch quyền sở hữu căn hộ và quyền sử dụng đất – thu hẹp khoảng cách giữa căn hộ 50 năm và căn hộ lâu dài.</li>
</ul>
<h2>Căn hộ 50 năm khác căn hộ lâu dài thế nào?</h2>
<table>
<thead><tr><th></th><th>Có thời hạn (thường 50 năm)</th><th>Sở hữu lâu dài</th></tr></thead>
<tbody>
<tr><td>Đất dự án</td><td>Đất thương mại dịch vụ, thuê có thời hạn</td><td>Đất ở</td></tr>
<tr><td>Giấy chứng nhận</td><td>Ghi thời hạn theo thời hạn dự án, có thể được gia hạn theo quy định</td><td>Sổ hồng không ghi thời hạn sử dụng đất ở</td></tr>
<tr><td>Phù hợp</td><td>Đầu tư cho thuê, nghỉ dưỡng</td><td>Ở lâu dài, để lại con cháu</td></tr>
<tr><td>Giá</td><td>Thường thấp hơn căn lâu dài cùng khu</td><td>Cao hơn</td></tr>
</tbody>
</table>
<p>Căn hộ có thời hạn không xấu – nhiều sản phẩm ven biển Đà Nẵng là loại này – nhưng người mua cần biết rõ để so giá cho đúng.</p>
<h2>Mua ở giai đoạn giữ chỗ: tiền được bảo vệ đến đâu?</h2>
<p>Luật Kinh doanh bất động sản 2023 cho phép chủ đầu tư thu tiền đặt cọc tối đa 5% giá bán khi dự án <strong>đã đủ điều kiện</strong> đưa vào kinh doanh. Trước đó, khoản giữ chỗ (booking) chỉ là thỏa thuận ưu tiên mua – nên yêu cầu ghi rõ được hoàn lại. Chi tiết: <a href="/giu-cho-booking-can-ho-moi-da-nang-can-biet/">giữ chỗ căn hộ mới cần biết</a>.</p>
<h2>6 giấy tờ nên hỏi</h2>
<ol>
<li>Quyết định chủ trương đầu tư / chấp thuận nhà đầu tư.</li>
<li>Quyết định giao đất, cho thuê đất – loại đất và thời hạn.</li>
<li>Giấy phép xây dựng.</li>
<li>Văn bản của Sở Xây dựng xác nhận đủ điều kiện bán nhà ở hình thành trong tương lai.</li>
<li>Bảo lãnh ngân hàng cho nghĩa vụ tài chính của chủ đầu tư.</li>
<li>Hợp đồng mua bán mẫu: thời hạn sở hữu, diện tích, tiến độ thanh toán, phạt chậm bàn giao.</li>
</ol>
<p>Thông tin pháp lý trên lấy từ tài liệu giới thiệu dự án; khi ký hợp đồng, người mua đối chiếu thời hạn và các văn bản ghi trong hợp đồng mua bán. Hoàng Hiệp sẽ cập nhật bài khi có văn bản đủ điều kiện bán.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Pháp lý Sun Saphia Residence: 50 năm từ 17/9/2026',
			'desc'      => 'Pháp lý Sun Saphia Residence: thời hạn dự án 50 năm từ 17/09/2026, công trình cấp I niên hạn 100 năm. Khác căn lâu dài thế nào, 6 giấy tờ cần kiểm tra.',
			'points'    => array(
				'Thời hạn dự án 50 năm kể từ 17/09/2026; công trình cấp I niên hạn 100 năm',
				'Giữ chỗ trước khi đủ điều kiện bán: yêu cầu ghi rõ hoàn lại',
				'Đặt cọc tối đa 5% giá bán khi đủ điều kiện (Luật KDBĐS 2023)',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence sở hữu bao lâu?', 'Theo tài liệu chủ đầu tư, thời hạn dự án 50 năm kể từ ngày 17/09/2026; công trình cấp I có niên hạn sử dụng 100 năm. Người mua đối chiếu thời hạn ghi trong hợp đồng mua bán.' ),
				array( 'Sun Saphia Residence có sổ hồng không?', 'Căn hộ có thời hạn vẫn được cấp giấy chứng nhận, ghi thời hạn theo thời hạn dự án (50 năm từ 17/09/2026). Ngân hàng hỗ trợ: VietinBank, BIDV, NCB.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 26/10 – Đầu tư cho thuê ---------------- */
	$posts[] = array(
		'slug'     => 'dau-tu-sun-saphia-residence-cho-thue-dong-tien',
		'title'    => 'Đầu tư Sun Saphia Residence cho thuê: 3 kịch bản dòng tiền studio và rủi ro cần tính trước',
		'excerpt'  => 'Đầu tư Sun Saphia Residence cho thuê: studio giá tham khảo 3 tỷ, kịch bản lợi suất từ 3,5% đến bài toán 11,7% của chủ đầu tư, so với lãi vay và rủi ro khi 513 studio cùng cho thuê.',
		'keyword'  => 'đầu tư Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Sun Saphia cho thuê', 'lợi nhuận căn hộ Sun Saphia', 'đầu tư căn hộ biển Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-26 15:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Đầu tư cho thuê' ),
		'image'    => 'plugin:img/tin-tuc/dau-tu-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Với 513 studio trên tổng 782 căn, {$saphia} là sản phẩm thiên về <strong>đầu tư cho thuê</strong>. Bài dựng 3 kịch bản dòng tiền cho một căn studio để người mua tự đối chiếu khi có bảng giá thật. Mọi con số dưới đây là <strong>giả định minh họa</strong>.</p>
<!--hh-featured-->
<h2>Giả định</h2>
<ul>
<li>Giá mua studio: 3 tỷ – mức giá tham khảo chủ đầu tư dùng trong bài toán cho thuê (xem <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia</a>).</li>
<li>Lợi suất cho thuê căn hộ Đà Nẵng mặt bằng chung khoảng 4,5%/năm (Batdongsan.com.vn, quý 3/2026).</li>
</ul>
<h2>3 kịch bản lợi nhuận ròng mỗi năm</h2>
<table>
<thead><tr><th>Kịch bản</th><th>Lợi suất ròng</th><th>Lợi nhuận/năm</th><th>Bình quân/tháng</th></tr></thead>
<tbody>
<tr><td>Thận trọng</td><td>3,5%</td><td>105 triệu</td><td>khoảng 8,8 triệu</td></tr>
<tr><td>Trung bình thị trường</td><td>4,5%</td><td>135 triệu</td><td>khoảng 11,3 triệu</td></tr>
<tr><td>Vận hành tốt</td><td>5,5%</td><td>165 triệu</td><td>khoảng 13,8 triệu</td></tr>
<tr><td>Bài toán của chủ đầu tư</td><td>11,7%</td><td>351 triệu</td><td>khoảng 29,3 triệu</td></tr>
</tbody>
</table>
<p>Bài toán của chủ đầu tư giả định cho thuê ngắn ngày 2,5 triệu/đêm, lấp đầy 60% (doanh thu khoảng 540 triệu/năm), lợi nhuận 65% doanh thu. Nếu lấp đầy chỉ 45% và lợi nhuận còn 55% (mùa mưa, cạnh tranh giá), lợi nhuận còn khoảng 226 triệu/năm – lợi suất khoảng 7,5%. Khách sạn, căn hộ view biển lân cận đang cho thuê studio khoảng 2,2 – 2,9 triệu/đêm ngoài mùa cao điểm.</p>
<h2>Nếu vay ngân hàng</h2>
<p>Vay 50% (1,5 tỷ), giả định lãi suất sau ưu đãi 10%/năm thì tiền lãi khoảng 150 triệu/năm – cao hơn lợi nhuận ở 3 kịch bản thận trọng, thấp hơn bài toán của chủ đầu tư. Nghĩa là dòng tiền chỉ đủ trả lãi khi cho thuê ngắn ngày hiệu quả; nếu chỉ cho thuê theo tháng, lợi nhuận phải đến từ tăng giá hoặc chính sách hỗ trợ lãi suất. Ngân hàng hỗ trợ dự án: VietinBank, BIDV, NCB.</p>
<h2>Rủi ro riêng của dự án nhiều studio</h2>
<ul>
<li>Nhiều căn cùng loại cùng cho thuê → cạnh tranh giá, nhất là mùa thấp điểm (tháng 9 – 12).</li>
<li>Thời hạn 50 năm kể từ 17/09/2026 (xem <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia</a>) – cần tính vào giá bán lại.</li>
<li>Phí quản lý, phí vận hành và nội thất làm giảm lợi suất thực.</li>
</ul>
<h2>Điểm cộng</h2>
<ul>
<li>Vị trí sát biển Sơn Thủy, phía trước là công viên ven biển đang đầu tư.</li>
<li>Thương hiệu Sun Group và hệ sinh thái du lịch Đà Nẵng hút khách lưu trú.</li>
<li>Tổng tiền thấp, dễ thanh khoản hơn căn lớn.</li>
</ul>
<p>Xem cách tính chi tiết: <a href="/studio-ven-bien-da-nang-gia-mua-gia-thue-2026/">studio ven biển Đà Nẵng – giá mua, giá thuê, dòng tiền</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đầu tư Sun Saphia Residence cho thuê: 3 kịch bản dòng tiền',
			'desc'      => 'Đầu tư Sun Saphia Residence cho thuê: studio 3 tỷ, lợi suất từ 3,5% đến 11,7% (bài toán chủ đầu tư), so với lãi vay và rủi ro khi 513 studio cùng cho thuê.',
			'points'    => array(
				'Studio 3 tỷ: lợi nhuận khoảng 105 – 165 triệu/năm (thận trọng) đến 351 triệu (bài toán chủ đầu tư)',
				'Vay 50% với lãi 10%/năm: khoảng 150 triệu tiền lãi mỗi năm',
				'513 studio cùng tòa – cạnh tranh cho thuê mùa thấp điểm',
			),
			'faq'       => array(
				array( 'Mua studio Sun Saphia Residence cho thuê lãi bao nhiêu?', 'Bài toán của chủ đầu tư: studio 30 m² giá tham khảo 3 tỷ, 2,5 triệu/đêm, lấp đầy 60% cho lợi nhuận khoảng 351 triệu/năm (11,7%); kịch bản thận trọng 3,5 – 5,5% tương đương 105 – 165 triệu/năm.' ),
				array( 'Có nên vay để mua Sun Saphia Residence cho thuê?', 'Vay 50% căn 3 tỷ với lãi 10%/năm tốn khoảng 150 triệu/năm; chỉ đủ trả khi cho thuê ngắn ngày hiệu quả. Ngân hàng hỗ trợ dự án: VietinBank, BIDV, NCB.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 27/10 – Có nên mua ---------------- */
	$posts[] = array(
		'slug'     => 'co-nen-mua-sun-saphia-residence-uu-nhuoc-diem',
		'title'    => 'Có nên mua Sun Saphia Residence? 6 ưu điểm, 4 điểm cần cân nhắc trước khi giữ chỗ',
		'excerpt'  => 'Có nên mua Sun Saphia Residence – căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng? Ưu điểm về vị trí, thương hiệu, tổng tiền và những điểm cần cân nhắc: pháp lý, giá, cạnh tranh cho thuê.',
		'keyword'  => 'có nên mua Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'review Sun Saphia Residence', 'đánh giá Sun Saphia Đà Nẵng', 'Sun Saphia ưu nhược điểm' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-27 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Review dự án' ),
		'image'    => 'plugin:img/tin-tuc/co-nen-mua-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Có nên mua Sun Saphia Residence?</strong> Câu trả lời phụ thuộc mục đích: đầu tư cho thuê, mua nghỉ dưỡng hay để ở. Dưới đây là đánh giá của Hoàng Hiệp về {$saphia} dựa trên thông tin đã công bố đến 10/2026.</p>
<!--hh-featured-->
<h2>6 ưu điểm</h2>
<ol>
<li><strong>Sát biển Sơn Thủy</strong>, phía trước là công viên công cộng khoảng 2,45 ha thành phố đang đầu tư – tầm nhìn khó bị che.</li>
<li><strong>Thương hiệu Sun Group</strong>, theo chủ đầu tư là dự án căn hộ mặt biển đầu tiên của tập đoàn tại Đà Nẵng.</li>
<li><strong>Tổng tiền dễ tiếp cận</strong>: studio 30 – 31 m² có giá tham khảo khoảng 3 tỷ trong bài toán của chủ đầu tư – thấp hơn nhiều căn hộ hàng hiệu sát biển Mỹ Khê.</li>
<li><strong>Hạ tầng sắp tới</strong>: ga LRT 09 cách khoảng 500 m, mở rộng đường ven biển, cao tốc nội thị Đà Nẵng – Chu Lai.</li>
<li><strong>Khu biển yên tĩnh hơn Mỹ Khê</strong> nhưng vẫn gần trung tâm (khoảng 4 km tới Sun Galaxy, Đà Nẵng Downtown theo chủ đầu tư).</li>
<li><strong>Bàn giao 11/2028</strong> – thời gian dài để thanh toán theo tiến độ.</li>
</ol>
<h2>4 điểm cần cân nhắc</h2>
<ol>
<li><strong>Thời hạn 50 năm</strong> kể từ 17/09/2026 (công trình niên hạn 100 năm) – hợp đầu tư, nghỉ dưỡng hơn là để lại lâu dài (<a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">chi tiết</a>).</li>
<li><strong>Chưa có bảng giá</strong>: chưa so được giá/m² thực với các dự án lân cận.</li>
<li><strong>513 studio</strong> trong một tòa – cạnh tranh cho thuê và bán lại.</li>
<li><strong>Thời gian chờ</strong>: hơn 2 năm đến bàn giao, tiền vốn nằm im nếu không có dòng tiền khác.</li>
</ol>
<h2>Hợp với ai?</h2>
<table>
<thead><tr><th>Mục đích</th><th>Gợi ý</th></tr></thead>
<tbody>
<tr><td>Đầu tư cho thuê ngắn hạn</td><td>Studio tầng cao hướng biển</td></tr>
<tr><td>Cho thuê dài hạn, vừa ở vừa làm việc</td><td>1PN+1</td></tr>
<tr><td>Nghỉ dưỡng gia đình</td><td>2PN, ưu tiên căn góc</td></tr>
<tr><td>Ở lâu dài, để lại con cháu</td><td>Cân nhắc kỹ thời hạn sở hữu; so thêm căn hộ sở hữu lâu dài như <a href="/du-an/sun-cosmo-residence/">Sun Cosmo</a>, <a href="/du-an/sun-ponte-residence/">Sun Ponte</a></td></tr>
</tbody>
</table>
<p>Xem toàn bộ dự án Sun Group: <a href="/du-an-can-ho-sun-group-da-nang-2026/">căn hộ Sun Group Đà Nẵng 2026</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Có nên mua Sun Saphia Residence? Ưu và nhược điểm',
			'desc'      => 'Có nên mua Sun Saphia Residence? 6 ưu điểm: sát biển Sơn Thủy, thương hiệu Sun Group, tổng tiền thấp; 4 điểm cân nhắc: pháp lý, giá, cạnh tranh cho thuê.',
			'points'    => array(
				'Ưu điểm: sát biển Sơn Thủy, công viên phía trước, thương hiệu Sun Group',
				'Cân nhắc: pháp lý chưa công bố, chưa có bảng giá, 513 studio',
				'Hợp nhất với nhà đầu tư cho thuê và mua nghỉ dưỡng',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có đáng mua không?', 'Hợp với người đầu tư cho thuê và mua nghỉ dưỡng nhờ vị trí sát biển Sơn Thủy và tổng tiền thấp; cần chờ bảng giá và hồ sơ pháp lý để so sánh chính xác.' ),
				array( 'Mua Sun Saphia Residence để ở có được không?', 'Được, nên chọn 1PN+1 hoặc 2PN; nếu muốn để lại lâu dài cần làm rõ thời hạn sở hữu trước khi mua.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 28/10 – Tiến độ ---------------- */
	$posts[] = array(
		'slug'     => 'tien-do-sun-saphia-residence-mo-ban-ban-giao',
		'title'    => 'Tiến độ Sun Saphia Residence: giữ chỗ, mở bán, xây dựng và bàn giao 11/2028',
		'excerpt'  => 'Tiến độ Sun Saphia Residence cập nhật 10/2026: dự án đang nhận giữ chỗ, chưa công bố bảng giá; bàn giao dự kiến 11/2028. Các mốc tiếp theo và cách theo dõi.',
		'keyword'  => 'tiến độ Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Sun Saphia mở bán', 'Sun Saphia bàn giao', 'Sun Saphia Residence khi nào mở bán' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-28 15:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Tiến độ dự án' ),
		'image'    => 'plugin:img/tin-tuc/tien-do-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Tiến độ Sun Saphia Residence</strong> được cập nhật trong bài này mỗi khi có mốc mới. Đến cuối tháng 10/2026, {$saphia} đang ở giai đoạn <strong>nhận giữ chỗ</strong>; chủ đầu tư chưa công bố bảng giá và hồ sơ đủ điều kiện bán.</p>
<!--hh-featured-->
<h2>Các mốc chính</h2>
<table>
<thead><tr><th>Mốc</th><th>Trạng thái (10/2026)</th></tr></thead>
<tbody>
<tr><td>Giới thiệu dự án, nhận giữ chỗ</td><td>Đang diễn ra</td></tr>
<tr><td>Công bố bảng giá, chính sách</td><td>Chưa công bố</td></tr>
<tr><td>Thời hạn dự án</td><td>50 năm kể từ 17/09/2026 (theo tài liệu chủ đầu tư)</td></tr>
<tr><td>Đủ điều kiện bán nhà ở hình thành trong tương lai</td><td>Chưa thấy văn bản công bố</td></tr>
<tr><td>Ký hợp đồng mua bán</td><td>Sau khi đủ điều kiện bán</td></tr>
<tr><td>Bàn giao</td><td>Dự kiến tháng 11/2028, hoàn thiện cơ bản</td></tr>
</tbody>
</table>
<h2>Hạ tầng xung quanh đi cùng tiến độ dự án</h2>
<ul>
<li>Công viên bãi tắm Sơn Thủy khoảng 2,45 ha: thực hiện giai đoạn 2025 – 2027.</li>
<li>Mở rộng đường Võ Nguyên Giáp – Trường Sa: đang ưu tiên thủ tục, chưa công bố ngày khởi công.</li>
<li>Cao tốc nội thị Đà Nẵng – Chu Lai: dự kiến khởi công 10/2027 (<a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">chi tiết</a>).</li>
</ul>
<p>Nếu đúng kế hoạch, khi Sun Saphia bàn giao cuối 2028 thì công viên phía trước đã hoàn thành – lợi thế cho người nhận nhà đợt đầu.</p>
<h2>Theo dõi tiến độ thế nào?</h2>
<ul>
<li>Đăng ký nhận tin để Hoàng Hiệp gửi ngay khi có bảng giá, mặt bằng, hồ sơ pháp lý.</li>
<li>Khi đã ký hợp đồng, yêu cầu ảnh tiến độ thi công theo quý và đối chiếu mốc thanh toán.</li>
</ul>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiến độ Sun Saphia Residence: mở bán, bàn giao 11/2028',
			'desc'      => 'Tiến độ Sun Saphia Residence 10/2026: đang nhận giữ chỗ, chưa công bố bảng giá và hồ sơ đủ điều kiện bán; bàn giao dự kiến 11/2028. Các mốc tiếp theo.',
			'points'    => array(
				'10/2026: đang nhận giữ chỗ, chưa công bố bảng giá',
				'Bàn giao dự kiến tháng 11/2028',
				'Công viên bãi tắm Sơn Thủy phía trước làm giai đoạn 2025 – 2027',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence khi nào mở bán?', 'Đến 10/2026 dự án đang nhận giữ chỗ; thời điểm mở bán chính thức và bảng giá chưa được chủ đầu tư công bố.' ),
				array( 'Sun Saphia Residence bao giờ bàn giao?', 'Chủ đầu tư dự kiến bàn giao tháng 11/2028.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 29/10 – Phân biệt Khu đô thị Saphia ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-va-khu-do-thi-saphia-khac-nhau',
		'title'    => 'Sun Saphia Residence và Khu đô thị Saphia Ngũ Hành Sơn khác nhau thế nào? Tránh nhầm khi tìm mua',
		'excerpt'  => 'Tìm "Saphia Đà Nẵng" ra hai dự án khác nhau: Sun Saphia Residence (căn hộ 30 tầng của Sun Group trên đường Trường Sa) và Khu đô thị Saphia (đất nền, khu Khuê Mỹ cũ). Bảng phân biệt nhanh.',
		'keyword'  => 'Saphia Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'khu đô thị Saphia', 'Saphia Ngũ Hành Sơn', 'Sun Saphia Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-29 15:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn' ),
		'image'    => 'plugin:img/tin-tuc/sun-saphia-khac-khu-do-thi-saphia.jpg',
		'content'  => <<<HTML
<p>Gõ "<strong>Saphia Đà Nẵng</strong>" trên mạng sẽ ra hai dự án hoàn toàn khác nhau, cùng ở phường Ngũ Hành Sơn: <strong>Sun Saphia Residence</strong> – tòa căn hộ mới của Sun Group – và <strong>Khu đô thị Saphia</strong> – khu đất nền đã hình thành từ trước. Bài giúp phân biệt để không gọi nhầm người bán, nhầm giá.</p>
<!--hh-featured-->
<h2>Bảng phân biệt nhanh</h2>
<table>
<thead><tr><th></th><th>Sun Saphia Residence</th><th>Khu đô thị Saphia</th></tr></thead>
<tbody>
<tr><td>Loại sản phẩm</td><td>Căn hộ (studio, 1PN+1, 2PN)</td><td>Đất nền, nhà phố</td></tr>
<tr><td>Chủ đầu tư</td><td>Sun Group (Sun Property)</td><td>Chủ đầu tư khác, không thuộc Sun Group</td></tr>
<tr><td>Vị trí</td><td>Đường Trường Sa, bãi tắm Sơn Thủy</td><td>Khu Khuê Mỹ cũ, gần biển Sơn Thủy</td></tr>
<tr><td>Quy mô</td><td>1 tòa 30 tầng, 782 căn</td><td>Nhiều lô đất ở, lô phổ biến khoảng 150 – 300 m²</td></tr>
<tr><td>Giai đoạn</td><td>Đang nhận giữ chỗ, bàn giao dự kiến 11/2028</td><td>Đã hình thành, giao dịch chuyển nhượng</td></tr>
</tbody>
</table>
<h2>Sun Saphia Residence</h2>
<p>{$saphia} là tòa căn hộ 30 tầng (114 m) trên khu đất 3.720,1 m², 782 căn, phía trước là công viên bãi tắm Sơn Thủy khoảng 2,45 ha. Theo chủ đầu tư, đây là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng. Xem thêm <a href="/sun-saphia-residence-o-dau-vi-tri/">vị trí Sun Saphia Residence</a> và <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng các loại căn</a>.</p>
<h2>Khu đô thị Saphia</h2>
<p>Khu đô thị Saphia (còn gọi Saphia Complex trong hồ sơ quy hoạch khu khách sạn và dân cư) là khu đất nền tại khu Khuê Mỹ cũ, nay thuộc phường Ngũ Hành Sơn. Giao dịch chủ yếu là chuyển nhượng lô đất; giá trên các trang rao là giá người bán tự đăng. Khi mua đất ở đây, kiểm tra sổ đỏ, quy hoạch 1/500 và thời hạn sử dụng ghi trên giấy chứng nhận từng lô.</p>
<h2>Mẹo tìm đúng dự án</h2>
<ul>
<li>Tìm căn hộ Sun Group: dùng đủ tên "Sun Saphia Residence".</li>
<li>Tìm đất nền: thêm "khu đô thị" hoặc "đất nền" và kiểm tra lô, khu trên sổ.</li>
<li>Cẩn thận tin rao ghép tên "Saphia" cho sản phẩm khác để kéo khách.</li>
</ul>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence và Khu đô thị Saphia: khác nhau gì?',
			'desc'      => 'Saphia Đà Nẵng gồm hai dự án khác nhau: Sun Saphia Residence (căn hộ 30 tầng Sun Group, đường Trường Sa) và Khu đô thị Saphia (đất nền). Bảng phân biệt.',
			'points'    => array(
				'Sun Saphia Residence: căn hộ 30 tầng của Sun Group, 782 căn',
				'Khu đô thị Saphia: đất nền, chủ đầu tư khác, đã hình thành',
				'Tìm đúng: dùng đủ tên "Sun Saphia Residence"',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có phải Khu đô thị Saphia không?', 'Không. Sun Saphia Residence là tòa căn hộ 30 tầng của Sun Group trên đường Trường Sa; Khu đô thị Saphia là khu đất nền của chủ đầu tư khác.' ),
				array( 'Saphia Đà Nẵng ở đâu?', 'Cả hai dự án cùng thuộc phường Ngũ Hành Sơn, gần biển Sơn Thủy: Sun Saphia Residence trên đường Trường Sa, Khu đô thị Saphia ở khu Khuê Mỹ cũ.' ),
			),
		),
		'sources'  => array( 'https://guland.vn/du-an/khu-do-thi-saphia', 'https://viettimes.vn/da-nang-co-them-du-an-to-hop-khach-san-dan-cu-nghin-ty-post59374.html' ),
	);

	return $posts;
}
