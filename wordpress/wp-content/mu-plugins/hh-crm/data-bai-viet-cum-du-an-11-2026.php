<?php
/**
 * Bài vệ tinh cho các dự án còn ít bài (theo báo cáo phân tích đối thủ 10/11/2026):
 * Symphony 5 (giá, mặt bằng, pháp lý), The Legend (giá, mặt bằng), Nobu Residences (giá, tiến độ).
 * Số liệu lấy từ dữ liệu dự án trên web (giỏ hàng, chính sách, tài liệu chủ đầu tư) – không thêm số mới.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_cum_du_an_11_2026' );
function hh_posts_cum_du_an_11_2026( $posts ) {
	$s5     = '<a href="/du-an/symphony-5-sun-symphony-residence/">Symphony 5 – Sun Symphony Residence</a>';
	$legend = '<a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a>';
	$nobu   = '<a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a>';
	$sign   = '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ giỏ hàng và tài liệu chủ đầu tư · cập nhật 10/11/2026. Giá tham khảo, thay đổi theo đợt.</small></p>';
	$cta    = static fn( $name ) => '<p>Cần bảng giá từng căn, mặt bằng tầng và phiếu tính dòng tiền ' . $name . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi giỏ hàng mới nhất và so sánh với các dự án cùng tầm giá.</p>';

	$s5_facts = '<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Công ty TNHH Mặt Trời Sông Hàn (thành viên Sun Group)</td></tr>
<tr><th>Vị trí</th><td>Đường Lê Văn Duyệt, phường Sơn Trà (Nại Hiên Đông cũ), bờ Đông sông Hàn</td></tr>
<tr><th>Quy mô</th><td>1 tháp 31 tầng nổi, 1 tầng hầm, đất thương mại dịch vụ khoảng 11.371 m²</td></tr>
<tr><th>Số căn</th><td>1.228 căn: 725 studio, 331 căn 1PN+, 160 căn 2PN, 12 penthouse</td></tr>
<tr><th>Sở hữu</th><td>50 năm (đất thương mại dịch vụ)</td></tr>
<tr><th>Nhận căn</th><td>Dự kiến 30/06/2028 (Sun Early Key, thanh toán từ 70%)</td></tr>
</tbody>
</table>';

	/* ---------------- Symphony 5 – Giá ---------------- */
	$posts[] = array(
		'slug'     => 'gia-symphony-5-sun-symphony-residence-bao-nhieu',
		'title'    => 'Giá Sun Symphony 5 Đà Nẵng bao nhiêu? Studio từ 2,5 tỷ, 1PN+ đến 4,54 tỷ (11/2026)',
		'excerpt'  => 'Giá Symphony 5 – Sun Symphony Residence theo giỏ hàng 11/2026: studio 30 – 33 m² khoảng 2,50 – 3,30 tỷ, 1PN khoảng 3,09 – 3,30 tỷ, 1PN+ khoảng 3,45 – 4,54 tỷ (gồm VAT, phí bảo trì). Cách tính giá sau chiết khấu, vay 70%.',
		'keyword'  => 'giá Sun Symphony 5',
		'keywords_extra' => array( 'giá Symphony 5 Đà Nẵng', 'bảng giá Symphony 5', 'giá căn hộ Sun Symphony Residence' ),
		'project'  => 'symphony-5-sun-symphony-residence',
		'schedule' => '2026-11-11 14:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Symphony 5', 'Sun Symphony Residence', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/sun-symphony-5/sun-symphony-5-pc-11-hoang-hon.jpg',
		'image_alt' => 'Symphony 5 – Sun Symphony Residence bên sông Hàn lúc hoàng hôn (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Giá Sun Symphony 5 Đà Nẵng (giỏ hàng 11/2026):</strong> căn studio 30 – 33 m² khoảng <strong>2,50 – 3,30 tỷ</strong>; căn 1PN 46,4 – 47,8 m² khoảng 3,09 – 3,30 tỷ; căn 1PN+ 44 – 53 m² khoảng 3,45 – 4,54 tỷ. Giá đã gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu. Căn 2PN và penthouse: liên hệ để nhận giá từng căn.</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>30 – 33 m²</td><td>Khoảng 2,50 – 3,30 tỷ</td></tr>
<tr><td>Căn 1PN</td><td>46,4 – 47,8 m²</td><td>Khoảng 3,09 – 3,30 tỷ</td></tr>
<tr><td>Căn 1PN+</td><td>44 – 53 m²</td><td>Khoảng 3,45 – 4,54 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>63 – 70 m²</td><td>Liên hệ</td></tr>
<tr><td>Penthouse (12 căn)</td><td>–</td><td>Liên hệ</td></tr>
</tbody>
</table>
{$sign}
</div>
<p><strong>Giá Symphony 5</strong> là câu hỏi đầu tiên của hầu hết khách đang so sánh căn hộ bên sông Hàn. Bài này tổng hợp giá theo giỏ hàng tháng 11/2026 của {$s5}, giải thích giá đã gồm những gì và cách tính số tiền thực trả theo từng phương án thanh toán.</p>
<!--hh-featured-->
<h2>Thông tin nhanh về Symphony 5</h2>
{$s5_facts}
<h2>Giá Sun Symphony 5 theo loại căn</h2>
<p>Studio chiếm phần lớn tòa (725/1.228 căn) nên có nhiều lựa chọn tầng và hướng nhất. Chênh lệch trong cùng loại căn (ví dụ studio từ 2,50 đến 3,30 tỷ) chủ yếu do <strong>tầng</strong> và <strong>hướng nhìn</strong>: căn nhìn thẳng sông Hàn, cầu Thuận Phước có giá cao hơn căn nhìn về phía cảng Thọ Quang hoặc nội khu.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-07-tang-19-view-song-cau.jpg|Căn hộ tầng 19 Symphony 5 nhìn sông Hàn và cầu Thuận Phước (phối cảnh chủ đầu tư)-->
<p>Căn 1PN và 1PN+ có diện tích gần nhau (44 – 53 m²). Căn 1PN+ có thêm một góc đa năng nên giá cao hơn căn 1PN. Với khách mua để cho thuê, 1PN+ dễ cho gia đình nhỏ thuê dài ngày hơn studio.</p>
<h2>Giá đã gồm và chưa gồm gì</h2>
<ul>
<li><strong>Đã gồm:</strong> thuế VAT và kinh phí bảo trì (theo giỏ hàng 11/2026).</li>
<li><strong>Chưa trừ:</strong> chiết khấu 5% khi không vay (tính trên giá chưa VAT và kinh phí bảo trì), lãi 8%/năm khi thanh toán sớm hơn tiến độ.</li>
<li><strong>Bàn giao thô</strong> phần bên trong căn. Nếu chọn bàn giao hoàn thiện liền tường, cộng thêm khoảng 10,1 triệu/m² với studio, 9,5 triệu/m² với 1PN/1PN+, 11 triệu/m² với 2PN (đã gồm VAT, theo diện tích thông thủy).</li>
</ul>
<h2>Ví dụ: studio 30 m² giá 2,50 tỷ cần chuẩn bị bao nhiêu?</h2>
<p>Ví dụ dưới đây do Hoàng Hiệp tự tính theo lịch thanh toán CSBH 02 để anh chị hình dung dòng tiền, chưa phải phiếu tính giá của chủ đầu tư.</p>
<table>
<thead><tr><th>Mốc</th><th>Tỷ lệ</th><th>Số tiền (ước tính)</th></tr></thead>
<tbody>
<tr><td>Ký hợp đồng thực hiện nguyện vọng</td><td>100 triệu</td><td>100 triệu</td></tr>
<tr><td>Đợt 2 (ngày 10)</td><td>15% (gồm đợt 1)</td><td>Khoảng 375 triệu</td></tr>
<tr><td>Đợt 3 – 7 (ngày 130 – 610)</td><td>10% mỗi đợt</td><td>Khoảng 250 triệu/đợt</td></tr>
<tr><td>Đợt 8 (ngày 730)</td><td>5%</td><td>Khoảng 125 triệu</td></tr>
<tr><td>Nhận căn sử dụng (dự kiến 30/06/2028)</td><td>Đã trả tối thiểu 70%</td><td>Khoảng 1,75 tỷ</td></tr>
</tbody>
</table>
<p>Nếu vay, ngân hàng cho vay tối đa 70% giá trị căn, chủ đầu tư hỗ trợ lãi suất tối đa 30 tháng (không muộn hơn 31/03/2029). Khi đó vốn tự có ban đầu khoảng 15%.</p>
<h2>Chính sách bán hàng đang áp dụng</h2>
<ul>
<li><strong>Sun Early Key:</strong> thanh toán tối thiểu 70% được nhận căn để sử dụng, khai thác (dự kiến 30/06/2028).</li>
<li><strong>Không vay:</strong> chiết khấu 5%, giãn tiến độ đến 50 tháng.</li>
<li><strong>Vay tối đa 70%:</strong> hỗ trợ lãi suất tối đa 30 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ.</li>
<li>Miễn phí dịch vụ quản lý 1 năm từ ngày bàn giao chính thức.</li>
</ul>
<p>Chính sách theo CSBH 02/S5, áp dụng từ 20/07/2026 đến khi có chính sách mới. Xem đầy đủ tại trang dự án {$s5}.</p>
<h2>So với các dự án cùng khu</h2>
<p>Symphony 5 có tổng tiền thấp nhất trong nhóm căn hộ sát sông Hàn hiện nay. Các dự án sở hữu lâu dài ngay bên sông như <a href="/du-an/the-legend-da-nang/">The Legend</a> có căn 1PN từ khoảng 7,65 tỷ. Đổi lại, Symphony 5 là đất thương mại dịch vụ, sở hữu 50 năm (xem <a href="/phap-ly-symphony-5-so-huu-50-nam/">pháp lý Symphony 5</a>).</p>
<p>Xem thêm: <a href="/mat-bang-can-ho-symphony-5/">mặt bằng căn hộ Symphony 5</a>.</p>
{$cta('Symphony 5')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Sun Symphony 5 bao nhiêu? Studio từ 2,5 tỷ (11/2026)',
			'desc'      => 'Giá Sun Symphony 5 giỏ hàng 11/2026: studio 2,50 – 3,30 tỷ, 1PN 3,09 – 3,30 tỷ, 1PN+ 3,45 – 4,54 tỷ, đã gồm VAT và phí bảo trì. Vay 70%.',
			'points'    => array(
				'Studio 30 – 33 m² khoảng 2,50 – 3,30 tỷ; 1PN+ 44 – 53 m² khoảng 3,45 – 4,54 tỷ',
				'Giá gồm VAT và kinh phí bảo trì; chiết khấu 5% nếu không vay',
				'Thanh toán 70% nhận căn sử dụng, dự kiến 30/06/2028',
			),
			'faq'       => array(
				array( 'Giá bán Symphony 5 Đà Nẵng bao nhiêu?', 'Theo giỏ hàng 11/2026: studio 30 – 33 m² khoảng 2,50 – 3,30 tỷ, căn 1PN khoảng 3,09 – 3,30 tỷ, căn 1PN+ khoảng 3,45 – 4,54 tỷ. Giá đã gồm VAT và kinh phí bảo trì, chưa trừ chiết khấu.' ),
				array( 'Studio Symphony 5 giá bao nhiêu?', 'Khoảng 2,50 – 3,30 tỷ cho căn 30 – 33 m², tùy tầng và hướng nhìn (giỏ hàng 11/2026).' ),
				array( 'Mua Symphony 5 cần trả trước bao nhiêu?', 'Khoảng 15% giá trị căn trong 10 ngày đầu (gồm 100 triệu khi ký hợp đồng thực hiện nguyện vọng). Nếu vay, ngân hàng cho vay tối đa 70%, chủ đầu tư hỗ trợ lãi suất tối đa 30 tháng.' ),
				array( 'Symphony 5 khi nào nhận nhà?', 'Thanh toán tối thiểu 70% được nhận căn sử dụng dự kiến 30/06/2028 (Sun Early Key); bàn giao chính thức theo tiến độ không vay dự kiến 30/06/2030.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Symphony 5 – Mặt bằng ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-can-ho-symphony-5',
		'title'    => 'Mặt bằng căn hộ Symphony 5: 1.228 căn studio, 1PN+, 2PN, penthouse theo từng tầng',
		'excerpt'  => 'Mặt bằng Symphony 5 – Sun Symphony Residence: tháp 31 tầng, 1.228 căn (725 studio, 331 căn 1PN+, 160 căn 2PN, 12 penthouse). Mặt bằng tầng 3, 3A – 18, 12A, 19 – 21, 22 – 26, 27 – 30, 31 và layout từng loại căn.',
		'keyword'  => 'mặt bằng Symphony 5',
		'keywords_extra' => array( 'mặt bằng Sun Symphony Residence', 'layout căn hộ Symphony 5', 'mặt bằng tầng Symphony 5' ),
		'project'  => 'symphony-5-sun-symphony-residence',
		'schedule' => '2026-11-13 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Symphony 5', 'Sun Symphony Residence', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/sun-symphony-5/sun-symphony-5-tmb.jpg',
		'image_alt' => 'Tổng mặt bằng phân khu Symphony 5 – Sun Symphony Residence (tài liệu chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mặt bằng Symphony 5:</strong> 1 tháp 31 tầng nổi, 1 tầng hầm với <strong>1.228 căn</strong>: 725 studio (30 – 33 m²), 331 căn 1PN+ (44 – 53 m²), 160 căn 2PN (63 – 70 m²) và 12 penthouse. Chủ đầu tư chia mặt bằng theo nhóm tầng: tầng 3, 3A – 18, 12A, 19 – 21, 22 – 26, 27 – 30 và tầng 31.</p>
{$sign}
</div>
<p>Bài này giúp anh chị đọc <strong>mặt bằng Symphony 5</strong> trước khi chọn căn: tòa có những loại căn nào, mỗi nhóm tầng khác nhau ra sao và nên chọn hướng nào theo mục đích ở hay cho thuê. Thông tin chung về dự án xem tại {$s5}.</p>
<!--hh-featured-->
<h2>Tổng mặt bằng phân khu</h2>
<p>Symphony 5 là mảnh ghép cuối của tổ hợp Sun Symphony Residence trên đường Lê Văn Duyệt. Quanh tháp có công viên thể thao khoảng 10.000 m², Central Park khoảng 5.000 m², công viên ven sông khoảng 4.000 m² và bến du thuyền. Khối đế là phố thương mại.</p>
<h2>Cơ cấu căn hộ trên mặt bằng Symphony 5</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích thông thủy</th><th>Số căn</th><th>Tỷ lệ</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>30 – 33 m²</td><td>725</td><td>Khoảng 59%</td></tr>
<tr><td>1PN+</td><td>44 – 53 m²</td><td>331</td><td>Khoảng 27%</td></tr>
<tr><td>2PN</td><td>63 – 70 m²</td><td>160</td><td>Khoảng 13%</td></tr>
<tr><td>Penthouse</td><td>–</td><td>12</td><td>Khoảng 1%</td></tr>
</tbody>
</table>
<p><small>Tỷ lệ do Hoàng Hiệp tính từ số căn chủ đầu tư công bố.</small></p>
<h2>Mặt bằng theo nhóm tầng</h2>
<ul>
<li><strong>Tầng 3:</strong> tầng đầu tiên có căn hộ, nhiều căn có ban công sân vườn.</li>
<li><strong>Tầng 3A – 18:</strong> nhóm tầng dùng chung một mặt bằng, chiếm số căn lớn nhất.</li>
<li><strong>Tầng 12A:</strong> có mặt bằng riêng.</li>
<li><strong>Tầng 19 – 21, 22 – 26, 27 – 30:</strong> các nhóm tầng cao, mỗi nhóm một mặt bằng riêng. Tầng 27 có sân yoga nhìn biển.</li>
<li><strong>Tầng 31:</strong> tầng trên cùng.</li>
</ul>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-mb-tang-3a-18.jpg|Mặt bằng tầng 3A – 18 tòa Symphony 5 (tài liệu chủ đầu tư)-->
<!--hh-img:img/sun-symphony-5/sun-symphony-5-mb-tang-22-26.jpg|Mặt bằng tầng 22 – 26 tòa Symphony 5 (tài liệu chủ đầu tư)-->
<h2>Layout từng loại căn</h2>
<h3>Studio 30,1 m²</h3>
<p>Phòng ở liền khối bếp, một vệ sinh, ban công. Hợp người ở một mình hoặc cho khách du lịch thuê ngắn ngày.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-lo-studio.jpg|Layout căn Studio Symphony 5 – 30,1 m² (tài liệu chủ đầu tư)-->
<h3>1PN+ 44,1 – 50,6 m²</h3>
<p>Một phòng ngủ riêng cộng một góc đa năng (làm việc, phòng trẻ nhỏ). Chủ đầu tư có các mẫu 44,1 m², 50,3 m² và 50,6 m².</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-lo-1br-plus.jpg|Layout căn 1PN+ Symphony 5 – 50,3 m² (tài liệu chủ đầu tư)-->
<h3>2PN 62,7 m²</h3>
<p>Hai phòng ngủ, phù hợp gia đình ở hoặc cho thuê dài hạn. Chỉ có 160 căn nên ít lựa chọn hơn.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-lo-2br-plus-a.jpg|Layout căn 2PN Symphony 5 – 62,7 m² (tài liệu chủ đầu tư)-->
<h2>Chọn hướng nhìn thế nào</h2>
<ul>
<li><strong>Nhìn sông Hàn, cầu Thuận Phước:</strong> hướng được hỏi nhiều nhất, xem pháo hoa DIFF. Giá cao hơn trong cùng loại căn.</li>
<li><strong>Nhìn cảng Thọ Quang, bán đảo Sơn Trà:</strong> giá mềm hơn, vẫn thoáng.</li>
<li><strong>Nhìn nội khu, công viên:</strong> yên tĩnh, hợp ở lâu dài.</li>
</ul>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-03-view-cau-thuan-phuoc.jpg|Ban công Symphony 5 nhìn cầu Thuận Phước về đêm (phối cảnh chủ đầu tư)-->
<h2>Bàn giao</h2>
<p>Căn hộ bàn giao thô bên trong (trần, sàn, tường), mặt ngoài, cửa nhôm kính và lô gia hoàn thiện. Khách có thể đăng ký bàn giao hoàn thiện liền tường khi ký hợp đồng mua bán.</p>
<p>Xem giá từng loại căn: <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá bán Symphony 5</a>.</p>
{$cta('Symphony 5')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng Symphony 5: studio, 1PN+, 2PN theo tầng',
			'desc'      => 'Mặt bằng Symphony 5 (Sun Symphony Residence): 31 tầng, 1.228 căn – 725 studio, 331 căn 1PN+, 160 căn 2PN, 12 penthouse; layout từng căn.',
			'points'    => array(
				'1.228 căn: 725 studio, 331 căn 1PN+, 160 căn 2PN, 12 penthouse',
				'Mặt bằng chia theo nhóm tầng 3, 3A – 18, 12A, 19 – 21, 22 – 26, 27 – 30, 31',
				'Bàn giao thô, có tùy chọn hoàn thiện liền tường',
			),
			'faq'       => array(
				array( 'Symphony 5 có bao nhiêu căn hộ?', '1.228 căn: 725 studio, 331 căn 1PN+, 160 căn 2PN và 12 penthouse, trong 1 tháp 31 tầng nổi.' ),
				array( 'Diện tích căn hộ Symphony 5 bao nhiêu?', 'Studio 30 – 33 m², 1PN+ 44 – 53 m², 2PN 63 – 70 m² (thông thủy).' ),
				array( 'Symphony 5 bàn giao thô hay hoàn thiện?', 'Bàn giao thô bên trong căn; khách có thể đăng ký hoàn thiện liền tường khi ký hợp đồng mua bán, chi phí khoảng 9,5 – 11 triệu/m² tùy loại căn.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Symphony 5 – Pháp lý ---------------- */
	$posts[] = array(
		'slug'     => 'phap-ly-symphony-5-so-huu-50-nam',
		'title'    => 'Pháp lý Symphony 5: sở hữu 50 năm, đất thương mại dịch vụ – người mua cần biết gì',
		'excerpt'  => 'Pháp lý Symphony 5 – Sun Symphony Residence: đấu giá đất 14/12/2025, chấp thuận nhà đầu tư 12/03/2026, giao đất 50 năm, quy hoạch 1/500 ngày 23/4/2026. Ý nghĩa sở hữu 50 năm, ký hợp đồng gì, khi nào có sổ.',
		'keyword'  => 'pháp lý Symphony 5',
		'keywords_extra' => array( 'Symphony 5 sở hữu bao lâu', 'Symphony 5 sổ hồng', 'Sun Symphony Residence pháp lý' ),
		'project'  => 'symphony-5-sun-symphony-residence',
		'schedule' => '2026-11-14 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Symphony 5', 'Sun Symphony Residence', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/sun-symphony-5/sun-symphony-5-pc-01-tong-the-1.jpg',
		'image_alt' => 'Toàn cảnh tổ hợp Sun Symphony Residence và tháp Symphony 5 bên sông Hàn (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Pháp lý Symphony 5:</strong> dự án trên đất thương mại dịch vụ, <strong>sở hữu 50 năm</strong> theo quyết định giao đất. Các mốc chính: đấu giá quyền sử dụng đất 14/12/2025, chấp thuận nhà đầu tư 12/03/2026, phê duyệt quy hoạch 1/500 ngày 23/4/2026 (theo tài liệu chủ đầu tư). Khách hiện ký hợp đồng thực hiện nguyện vọng, sau đó ký hợp đồng mua bán.</p>
{$sign}
</div>
<p>Với căn hộ trên đất thương mại dịch vụ, câu hỏi khách hỏi nhiều nhất là "sở hữu bao lâu" và "có sổ không". Bài này tóm tắt <strong>pháp lý Symphony 5</strong> theo tài liệu chủ đầu tư và những điểm cần đọc kỹ trong hợp đồng. Thông tin dự án xem tại {$s5}.</p>
<!--hh-featured-->
<h2>Các mốc pháp lý Symphony 5</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>14/12/2025</td><td>Đấu giá quyền sử dụng đất</td></tr>
<tr><td>12/03/2026</td><td>Chấp thuận nhà đầu tư</td></tr>
<tr><td>–</td><td>Quyết định giao đất, thời hạn 50 năm</td></tr>
<tr><td>23/4/2026</td><td>Phê duyệt quy hoạch chi tiết 1/500</td></tr>
<tr><td>27/5/2026</td><td>Ban hành CSBH 01 – ký thẳng hợp đồng mua bán</td></tr>
<tr><td>20/7/2026</td><td>Áp dụng CSBH 02 – ký hợp đồng thực hiện nguyện vọng</td></tr>
</tbody>
</table>
<h2>Sở hữu 50 năm nghĩa là gì</h2>
<p>Symphony 5 là căn hộ nghỉ dưỡng trên đất thương mại dịch vụ, nên thời hạn sở hữu theo thời hạn giao đất của dự án (50 năm), khác với căn hộ chung cư trên đất ở sở hữu lâu dài. Người mua vẫn được cấp giấy chứng nhận, được bán lại, cho thuê, thế chấp vay ngân hàng trong thời hạn sở hữu.</p>
<p>Khi hết thời hạn, việc gia hạn thực hiện theo quy định pháp luật đất đai tại thời điểm đó. Anh chị nên hỏi rõ điều khoản này trong hợp đồng mua bán.</p>
<h2>Ký hợp đồng gì, khi nào</h2>
<ol>
<li><strong>Hợp đồng thực hiện nguyện vọng:</strong> ký khi đặt 100 triệu (theo CSBH 02).</li>
<li><strong>Đợt 2:</strong> ngày thứ 10, nộp đủ 15%.</li>
<li><strong>Hợp đồng mua bán:</strong> dự kiến ngày thứ 7 sau hạn đợt 2.</li>
<li><strong>Bàn giao chính thức:</strong> dự kiến 30/06/2030 theo tiến độ không vay; nhận căn sử dụng sớm dự kiến 30/06/2028 khi đã thanh toán tối thiểu 70%.</li>
<li><strong>Nhận sổ:</strong> 5% cuối nộp ký quỹ khi bàn giao, chủ đầu tư trả lãi 8%/năm trên khoản này đến khi cấp giấy chứng nhận.</li>
</ol>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-08-dem-phao-hoa.jpg|Symphony 5 đêm pháo hoa DIFF bên sông Hàn (phối cảnh chủ đầu tư)-->
<h2>Ai hợp mua căn hộ 50 năm</h2>
<ul>
<li><strong>Hợp:</strong> mua để cho thuê, nghỉ dưỡng, đầu tư trung hạn. Tổng tiền thấp hơn căn hộ sở hữu lâu dài cùng khu (studio từ khoảng 2,5 tỷ).</li>
<li><strong>Cân nhắc kỹ:</strong> mua để ở lâu dài và để lại cho con cháu. Khi đó nên so với căn hộ sở hữu lâu dài như <a href="/du-an/the-legend-da-nang/">The Legend</a>.</li>
</ul>
<h2>5 câu nên hỏi trước khi ký</h2>
<ol>
<li>Thời hạn sở hữu ghi trong hợp đồng tính từ ngày nào?</li>
<li>Loại giấy chứng nhận được cấp và thời gian cấp dự kiến?</li>
<li>Điều kiện chuyển nhượng hợp đồng trước khi bàn giao?</li>
<li>Ngân hàng cho vay, lãi suất sau thời gian hỗ trợ?</li>
<li>Quy định khai thác cho thuê (tự cho thuê hay qua đơn vị vận hành)?</li>
</ol>
<p>Xem thêm: <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá bán Symphony 5</a>, <a href="/mat-bang-can-ho-symphony-5/">mặt bằng Symphony 5</a>.</p>
{$cta('Symphony 5')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Pháp lý Symphony 5: sở hữu 50 năm, cần biết gì',
			'desc'      => 'Pháp lý Symphony 5: đất thương mại dịch vụ, sở hữu 50 năm; đấu giá đất 14/12/2025, quy hoạch 1/500 ngày 23/4/2026. Ký hợp đồng gì, khi nào có sổ.',
			'points'    => array(
				'Đất thương mại dịch vụ, sở hữu 50 năm theo quyết định giao đất',
				'Quy hoạch 1/500 phê duyệt 23/4/2026; đang ký hợp đồng thực hiện nguyện vọng',
				'5% cuối nộp ký quỹ khi bàn giao, chủ đầu tư trả lãi 8%/năm đến khi có sổ',
			),
			'faq'       => array(
				array( 'Symphony 5 sở hữu bao lâu?', '50 năm, vì dự án nằm trên đất thương mại dịch vụ có quyết định giao đất thời hạn 50 năm.' ),
				array( 'Symphony 5 có sổ hồng không?', 'Người mua được cấp giấy chứng nhận theo thời hạn sử dụng đất của dự án. 5% giá trị cuối cùng nộp ký quỹ khi bàn giao và chủ đầu tư trả lãi 8%/năm trên khoản này đến khi cấp giấy chứng nhận.' ),
				array( 'Mua Symphony 5 ký hợp đồng gì?', 'Theo CSBH 02 từ 20/7/2026: ký hợp đồng thực hiện nguyện vọng khi đặt 100 triệu, sau đó ký hợp đồng mua bán (dự kiến ngày 7 sau hạn đợt 2).' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- The Legend – Giá ---------------- */
	$posts[] = array(
		'slug'     => 'gia-the-legend-da-nang-bao-nhieu',
		'title'    => 'Giá bán The Legend Đà Nẵng (The Legend City) bao nhiêu? 1PN từ 7,65 tỷ, 2PN từ 8,96 tỷ',
		'excerpt'  => 'Giá The Legend Đà Nẵng theo giỏ hàng chủ đầu tư: 1PN 7,65 – 9,59 tỷ, 1PN+1 góc 9,39 – 10,97 tỷ, 2PN 8,96 – 14,60 tỷ, 3PN góc 16,83 – 18,98 tỷ, penthouse từ khoảng 37 tỷ. Giá sau quà nội thất, chiết khấu đến 12%.',
		'keyword'  => 'giá The Legend Đà Nẵng',
		'keywords_extra' => array( 'giá The Legend City Đà Nẵng', 'bảng giá The Legend', 'giá căn hộ The Legend cầu Rồng' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-12 09:00',
		'category' => 'Thị trường',
		'tags'     => array( 'The Legend Đà Nẵng', 'Căn hộ sông Hàn', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-toan-canh-hoang-hon-song-han-cau-rong.jpg',
		'image_alt' => 'The Legend Đà Nẵng lúc hoàng hôn bên sông Hàn, ngay chân cầu Rồng (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Giá The Legend Đà Nẵng (giỏ hàng chủ đầu tư, tầng 6 – 25):</strong> căn 1PN 54,4 – 60,3 m² khoảng <strong>7,65 – 9,59 tỷ</strong>; 1PN+1 góc khoảng 9,39 – 10,97 tỷ; 2PN 74,9 – 84,5 m² khoảng 8,96 – 14,60 tỷ; 3PN góc khoảng 16,83 – 18,98 tỷ; penthouse duplex từ khoảng 37 tỷ. Giá gồm VAT và kinh phí bảo trì, chưa trừ quà nội thất và chiết khấu (đến 12%).</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead>
<tbody>
<tr><td>1PN</td><td>54,4 – 60,3 m²</td><td>Khoảng 7,65 – 9,59 tỷ</td></tr>
<tr><td>1PN+1 (góc)</td><td>58,4 m²</td><td>Khoảng 9,39 – 10,97 tỷ</td></tr>
<tr><td>2PN</td><td>74,9 – 84,5 m²</td><td>Khoảng 8,96 – 14,60 tỷ</td></tr>
<tr><td>3PN (góc)</td><td>114,1 – 114,2 m²</td><td>Khoảng 16,83 – 18,98 tỷ</td></tr>
<tr><td>Penthouse duplex (8 căn)</td><td>256 – 415 m²</td><td>Từ khoảng 37 tỷ</td></tr>
</tbody>
</table>
{$sign}
</div>
<p>{$legend} (nhiều nơi gọi là The Legend City) là căn hộ <strong>sở hữu lâu dài</strong> trên lô đất A20 Võ Văn Kiệt, ngay chân cầu Rồng. Bài này tổng hợp <strong>giá The Legend Đà Nẵng</strong> theo giỏ hàng, cách tính giá sau ưu đãi và lịch thanh toán.</p>
<!--hh-featured-->
<h2>Giá The Legend Đà Nẵng đã gồm gì, được trừ gì</h2>
<ul>
<li><strong>Đã gồm:</strong> VAT và kinh phí bảo trì.</li>
<li><strong>Quà nội thất trừ thẳng vào giá:</strong> 1PN 300 triệu, 2PN 500 triệu, 3PN 700 triệu, penthouse 1,8 tỷ.</li>
<li><strong>Chiết khấu theo cách thanh toán:</strong> theo tiến độ 3%; sớm 50% được 6%; sớm 70% được 8%; sớm 95% linh hoạt 9%; sớm 95% được 12%.</li>
<li>Không yêu cầu bảo lãnh ngân hàng: chiết khấu thêm 1%.</li>
</ul>
<p>Chính sách chủ đầu tư ban hành 17/7/2025, có thể đã điều chỉnh theo đợt mở bán.</p>
<h2>Ví dụ: căn 2PN 84,5 m² tầng cao</h2>
<table>
<thead><tr><th>Khoản</th><th>Số tiền</th></tr></thead>
<tbody>
<tr><td>Giá niêm yết (gồm VAT, kinh phí bảo trì)</td><td>14,59 tỷ</td></tr>
<tr><td>Sau quà nội thất 500 triệu và chiết khấu 3% (thanh toán theo tiến độ)</td><td>13,61 tỷ</td></tr>
</tbody>
</table>
<p>Nếu thanh toán sớm 95%, chiết khấu lên đến 12%, giá thực trả còn thấp hơn.</p>
<!--hh-img:img/the-legend/the-legend-da-nang-ban-cong-nhin-cau-rong-song-han.jpg|Ban công căn hộ The Legend nhìn thẳng cầu Rồng và sông Hàn (phối cảnh)-->
<h2>Lịch thanh toán</h2>
<table>
<thead><tr><th>Mốc</th><th>Tỷ lệ</th><th>Thời điểm</th></tr></thead>
<tbody>
<tr><td>Giữ chỗ</td><td>200 triệu/căn</td><td>Ký thỏa thuận giữ chỗ</td></tr>
<tr><td>Hợp đồng nguyên tắc</td><td>10% (gồm tiền giữ chỗ)</td><td>Trong 15 ngày</td></tr>
<tr><td>Đợt 2</td><td>15%</td><td>Trong 90 ngày từ hợp đồng nguyên tắc</td></tr>
<tr><td>Hợp đồng mua bán</td><td>Bổ sung đủ 30%</td><td>Theo thông báo chủ đầu tư</td></tr>
<tr><td>Các đợt tiếp</td><td>5%/đợt, mỗi 30 ngày (7 đợt)</td><td>Từ ngày ký hợp đồng mua bán</td></tr>
<tr><td>Cất nóc</td><td>5%</td><td>Dự kiến 31/12/2026</td></tr>
<tr><td>Nhận nhà</td><td>25% + kinh phí bảo trì</td><td>Dự kiến 31/3/2028</td></tr>
<tr><td>Nhận sổ</td><td>5%</td><td>Khi bàn giao giấy chứng nhận</td></tr>
</tbody>
</table>
<h2>Vay ngân hàng</h2>
<p>Vay đến 70% giá trị căn tại MSB, Vietcombank hoặc MB. Chủ đầu tư hỗ trợ lãi suất 0% trong 24 tháng; ân hạn nợ gốc 36 tháng (MSB) hoặc 24 tháng (Vietcombank, MB). Khách cần thanh toán tối thiểu 25% bằng vốn tự có trước khi ngân hàng giải ngân.</p>
<h2>Vì sao giá The Legend cao hơn mặt bằng chung</h2>
<ul>
<li><strong>Sở hữu lâu dài</strong> ngay bên sông Hàn, hiếm ở trung tâm Đà Nẵng.</li>
<li><strong>Vị trí chân cầu Rồng,</strong> 4 mặt tiền Võ Văn Kiệt – Ngô Quyền – Mai Hắc Đế – Lý Nam Đế, khoảng 1 km ra biển Mỹ Khê.</li>
<li><strong>Bàn giao hoàn thiện cao cấp</strong> có smarthome, miễn phí quản lý 24 tháng.</li>
</ul>
<p>Nếu ngân sách dưới 4 tỷ, anh chị có thể tham khảo <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá Symphony 5</a> cùng bờ Đông sông Hàn (sở hữu 50 năm).</p>
<p>Xem thêm: <a href="/mat-bang-can-ho-the-legend-da-nang/">mặt bằng căn hộ The Legend</a>.</p>
{$cta('The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá The Legend Đà Nẵng bao nhiêu? 1PN từ 7,65 tỷ',
			'desc'      => 'Giá The Legend Đà Nẵng (The Legend City): 1PN 7,65 – 9,59 tỷ, 2PN 8,96 – 14,60 tỷ, 3PN 16,83 – 18,98 tỷ. Quà nội thất đến 1,8 tỷ, chiết khấu 12%.',
			'points'    => array(
				'1PN 7,65 – 9,59 tỷ; 2PN 8,96 – 14,60 tỷ; 3PN góc 16,83 – 18,98 tỷ (gồm VAT, phí bảo trì)',
				'Quà nội thất 300 triệu – 1,8 tỷ trừ thẳng vào giá; chiết khấu đến 12%',
				'Vay 70%, hỗ trợ lãi suất 0% trong 24 tháng; nhận nhà dự kiến 31/3/2028',
			),
			'faq'       => array(
				array( 'Giá bán The Legend Đà Nẵng bao nhiêu?', 'Theo giỏ hàng chủ đầu tư tầng 6 – 25: 1PN khoảng 7,65 – 9,59 tỷ, 1PN+1 góc 9,39 – 10,97 tỷ, 2PN 8,96 – 14,60 tỷ, 3PN góc 16,83 – 18,98 tỷ; penthouse từ khoảng 37 tỷ. Giá gồm VAT và kinh phí bảo trì.' ),
				array( 'The Legend City và The Legend Đà Nẵng có phải một dự án không?', 'Đúng, cùng là dự án trên lô A20 Võ Văn Kiệt, chân cầu Rồng, chủ đầu tư Công ty TNHH MTV VIPICO.' ),
				array( 'Mua The Legend được chiết khấu bao nhiêu?', 'Từ 3% (thanh toán theo tiến độ) đến 12% (thanh toán sớm 95%), cộng quà nội thất trừ vào giá 300 triệu – 1,8 tỷ tùy loại căn, theo chính sách 17/7/2025.' ),
				array( 'The Legend Đà Nẵng khi nào bàn giao?', 'Dự kiến bàn giao căn hộ 31/3/2028; cất nóc dự kiến 31/12/2026.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- The Legend – Mặt bằng ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-can-ho-the-legend-da-nang',
		'title'    => 'Mặt bằng The Legend Đà Nẵng: 2 tháp, 800 căn hộ 1PN – 3PN, cánh Legacy và Infinity',
		'excerpt'  => 'Mặt bằng The Legend Đà Nẵng: tháp căn hộ 29 tầng với 800 căn (308 căn 1PN, 88 căn 1PN+1, 308 căn 2PN, 88 căn 3PN, 8 penthouse duplex), chia cánh Legacy phía sông Hàn và Infinity phía biển; tháp khách sạn 25 tầng.',
		'keyword'  => 'mặt bằng The Legend Đà Nẵng',
		'keywords_extra' => array( 'mặt bằng The Legend City', 'The Legend Đà Nẵng có bao nhiêu căn', 'căn hộ The Legend diện tích' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-13 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'The Legend Đà Nẵng', 'Căn hộ sông Hàn', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-vi-tri-chan-cau-rong-tu-tren-cao.jpg',
		'image_alt' => 'Vị trí The Legend Đà Nẵng ngay chân cầu Rồng nhìn từ trên cao (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mặt bằng The Legend Đà Nẵng:</strong> khu đất 11.487 m², 4 mặt tiền, gồm <strong>tháp căn hộ 29 tầng</strong> với 800 căn sở hữu lâu dài và <strong>tháp khách sạn 25 tầng</strong> (222 phòng khách sạn, 222 căn hộ dịch vụ, thời hạn 50 năm), chung 3 tầng hầm. Tháp căn hộ chia 2 cánh: <strong>Legacy</strong> phía sông Hàn và <strong>Infinity</strong> phía biển Mỹ Khê.</p>
{$sign}
</div>
<p>Bài này giúp anh chị hình dung <strong>mặt bằng The Legend</strong> trước khi chọn căn: có những loại căn nào, nằm ở cánh nào và nhìn ra đâu. Giá và chính sách xem tại {$legend}.</p>
<!--hh-featured-->
<h2>Tổng mặt bằng The Legend Đà Nẵng</h2>
<table>
<thead><tr><th>Khối</th><th>Sản phẩm</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Tháp căn hộ – cánh Legacy</td><td>1PN, 1PN+1, 2PN, 3PN</td><td>Phía sông Hàn, tầng 5 – 26</td></tr>
<tr><td>Tháp căn hộ – cánh Infinity</td><td>1PN, 1PN+1, 2PN, 3PN</td><td>Phía biển Mỹ Khê, tầng 5 – 26</td></tr>
<tr><td>Penthouse duplex</td><td>8 căn 256 – 415 m²</td><td>Tầng 27 trở lên, hồ bơi và vườn riêng</td></tr>
<tr><td>Tháp khách sạn 25 tầng</td><td>222 phòng khách sạn, 222 căn hộ dịch vụ</td><td>Thời hạn 50 năm</td></tr>
<tr><td>Khối đế</td><td>Thương mại, nhà hàng, tiện ích</td><td>4 mặt tiền; đang mở bán 19 shop</td></tr>
</tbody>
</table>
<!--hh-img:img/the-legend/the-legend-da-nang-hai-toa-thap-ben-cau-rong.jpg|Hai tòa tháp The Legend bên cầu Rồng, nhìn dọc sông Hàn (phối cảnh)-->
<h2>Cơ cấu 800 căn hộ</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Số căn</th></tr></thead>
<tbody>
<tr><td>1PN</td><td>40 – 60 m²</td><td>308</td></tr>
<tr><td>1PN+1</td><td>58 – 63 m²</td><td>88</td></tr>
<tr><td>2PN</td><td>73 – 85 m²</td><td>308</td></tr>
<tr><td>3PN</td><td>112 – 117 m²</td><td>88</td></tr>
<tr><td>Penthouse duplex</td><td>256 – 415 m²</td><td>8</td></tr>
</tbody>
</table>
<p>1PN và 2PN chiếm phần lớn (616/800 căn). 3PN và 1PN+1 ít hơn, thường ở vị trí góc.</p>
<h2>Cánh Legacy hay Infinity</h2>
<ul>
<li><strong>Legacy – phía sông Hàn:</strong> nhìn cầu Rồng, sông Hàn và trung tâm Hải Châu, xem pháo hoa DIFF và rồng phun lửa cuối tuần.</li>
<li><strong>Infinity – phía biển:</strong> nhìn về biển Mỹ Khê, bán đảo Sơn Trà; buổi sáng có nắng sớm.</li>
</ul>
<!--hh-img:img/the-legend/the-legend-da-nang-vuon-mai-nhin-ve-bien-my-khe.jpg|Vườn mái The Legend nhìn về biển Mỹ Khê và bán đảo Sơn Trà (phối cảnh)-->
<h2>Penthouse duplex</h2>
<p>8 căn penthouse thiết kế 2 tầng nối bằng cầu thang riêng, phòng khách thông tầng, diện tích 256 – 415 m², có hồ bơi riêng và vườn trên mái, giá từ khoảng 37 tỷ.</p>
<h2>Tiêu chuẩn bàn giao</h2>
<p>Bàn giao hoàn thiện cao cấp, tích hợp smarthome: sàn gỗ kỹ thuật sồi châu Âu ở phòng khách và phòng ngủ, gạch nhập khẩu ở vệ sinh và bếp, cửa chính chống cháy với khóa thông minh, điều hòa âm trần nối ống gió.</p>
<!--hh-img:img/the-legend/the-legend-da-nang-khoi-de-thuong-mai-mat-tien-vo-van-kiet.jpg|Khối đế thương mại The Legend mặt tiền Võ Văn Kiệt (phối cảnh)-->
<p>Mặt bằng từng tầng và vị trí căn trống anh chị nhắn Hoàng Hiệp để nhận bản mới nhất. Xem giá từng loại căn: <a href="/gia-the-legend-da-nang-bao-nhieu/">giá bán The Legend Đà Nẵng</a>.</p>
{$cta('The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng The Legend Đà Nẵng: 800 căn, 1PN – 3PN',
			'desc'      => 'Mặt bằng The Legend Đà Nẵng: tháp căn hộ 29 tầng, 800 căn – 308 căn 1PN, 88 căn 1PN+1, 308 căn 2PN, 88 căn 3PN, 8 penthouse; Legacy, Infinity.',
			'points'    => array(
				'Tháp căn hộ 29 tầng, 800 căn sở hữu lâu dài; tháp khách sạn 25 tầng',
				'308 căn 1PN, 88 căn 1PN+1, 308 căn 2PN, 88 căn 3PN, 8 penthouse duplex',
				'Cánh Legacy nhìn sông Hàn, cánh Infinity nhìn biển Mỹ Khê',
			),
			'faq'       => array(
				array( 'The Legend Đà Nẵng có bao nhiêu căn hộ?', '800 căn hộ sở hữu lâu dài trong tháp 29 tầng: 308 căn 1PN, 88 căn 1PN+1, 308 căn 2PN, 88 căn 3PN và 8 penthouse duplex. Tháp khách sạn 25 tầng có 222 phòng khách sạn và 222 căn hộ dịch vụ.' ),
				array( 'Diện tích căn hộ The Legend bao nhiêu?', '1PN 40 – 60 m², 1PN+1 58 – 63 m², 2PN 73 – 85 m², 3PN 112 – 117 m², penthouse 256 – 415 m².' ),
				array( 'Cánh Legacy và Infinity khác nhau thế nào?', 'Legacy nằm phía sông Hàn, nhìn cầu Rồng; Infinity nằm phía biển, nhìn về Mỹ Khê và bán đảo Sơn Trà. Cả hai cánh đều có căn 1PN đến 3PN từ tầng 5 đến 26.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Nobu – Giá ---------------- */
	$posts[] = array(
		'slug'     => 'gia-nobu-residences-da-nang-bao-nhieu',
		'title'    => 'Giá Nobu Đà Nẵng (Nobu Residences) bao nhiêu? Căn 1PN từ khoảng 6,63 tỷ (11/2026)',
		'excerpt'  => 'Giá Nobu Residences Đà Nẵng tham khảo: căn 1PN 62,5 – 71,1 m² khoảng 6,63 – 9,06 tỷ; đơn giá các nguồn nêu khoảng 145 – 205 triệu/m² tùy tầng và view. Các loại căn studio đến Sky Villa, penthouse; điểm cần kiểm tra về thời hạn sở hữu.',
		'keyword'  => 'giá Nobu Đà Nẵng',
		'keywords_extra' => array( 'giá Nobu Đà Nẵng', 'bảng giá Nobu Residences', 'Nobu Danang giá' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-12 14:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Nobu Residences Đà Nẵng', 'Căn hộ hàng hiệu', 'Giá căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/nobu-da-nang/nobu-da-nang-phoi-canh-thap-ven-bien-my-khe.jpg',
		'image_alt' => 'Phối cảnh tháp Nobu Residences Đà Nẵng bên biển Mỹ Khê (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Giá Nobu Đà Nẵng – Nobu Residences (tham khảo 11/2026):</strong> căn 1PN 62,5 – 71,1 m² khoảng <strong>6,63 – 9,06 tỷ</strong>. Đơn giá một số nguồn nêu khoảng 145 – 205 triệu/m² tùy tầng và hướng view. Studio, 2PN, 3PN Dual Key, Sky Villa và penthouse: liên hệ để nhận giá từng căn.</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 42,2 – 43 m²</td><td>Liên hệ</td></tr>
<tr><td>1PN</td><td>Khoảng 62,5 – 71,1 m²</td><td>Khoảng 6,63 – 9,06 tỷ</td></tr>
<tr><td>2PN</td><td>Khoảng 99,7 – 118,7 m²</td><td>Liên hệ</td></tr>
<tr><td>3PN Dual Key</td><td>Khoảng 130,1 – 166,2 m²</td><td>Liên hệ</td></tr>
<tr><td>Sky Villa hồ bơi riêng (6 căn)</td><td>Khoảng 254 – 288 m²</td><td>Liên hệ</td></tr>
<tr><td>Penthouse (2 căn)</td><td>Khoảng 372 m²</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm · cập nhật 10/11/2026. Giá tham khảo tổng hợp từ nhiều nguồn, chưa phải bảng giá chính thức của chủ đầu tư.</small></p>
</div>
<p>{$nobu} là dự án Nobu Residences đầu tiên tại Đông Nam Á, do VCRE phát triển theo giấy phép thương hiệu Nobu Hospitality. Vì là căn hộ hàng hiệu, <strong>giá Nobu Đà Nẵng</strong> cao hơn nhiều so với căn hộ ven biển thông thường. Bài này giải thích mức giá, giá gồm những gì và điều cần kiểm tra trước khi mua.</p>
<!--hh-featured-->
<h2>Vì sao giá Nobu Đà Nẵng cao</h2>
<ul>
<li><strong>Thương hiệu Nobu Hospitality</strong> (Robert De Niro, đầu bếp Nobu Matsuhisa, Meir Teper) vận hành khách sạn, nhà hàng và dịch vụ cư dân.</li>
<li><strong>Chỉ 264 căn hộ</strong> trong tháp 43 tầng (khoảng 186 m), cùng khách sạn Nobu khoảng 200 phòng (gồm 18 suite).</li>
<li><strong>Mặt tiền biển Mỹ Khê,</strong> góc Võ Văn Kiệt – Võ Nguyên Giáp.</li>
<li><strong>Hoàn thiện nội thất</strong> theo tiêu chuẩn Nobu, phong cách Japandi.</li>
</ul>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-phong-khach-tran-cao-3m.jpg|Phòng khách trần cao gần 3 m nhìn biển (phối cảnh nội thất Nobu Đà Nẵng)-->
<h2>Đơn giá theo m²: vì sao các nguồn chênh nhau</h2>
<p>Quy từ giá căn 1PN tham khảo (6,63 – 9,06 tỷ cho 62,5 – 71,1 m²), đơn giá khoảng <strong>106 – 127 triệu/m²</strong> (Hoàng Hiệp tự tính), thấp hơn mức 145 – 205 triệu/m² một số nguồn nêu. Chênh lệch có thể do tầng, hướng view, cách tính diện tích (thông thủy hay tim tường) và giá đã gồm VAT hay chưa. Vì vậy anh chị nên so sánh theo <strong>tổng tiền từng căn</strong> trên phiếu tính giá, không chỉ theo đơn giá/m².</p>
<h2>Cần kiểm tra gì trước khi mua</h2>
<ol>
<li><strong>Thời hạn sở hữu:</strong> các nguồn chưa thống nhất. Một số ghi sở hữu lâu dài cho người Việt và 50 năm cho người nước ngoài; nguồn khác ghi thời hạn đến năm 2060 theo đất thương mại dịch vụ. Anh chị cần đối chiếu hợp đồng mua bán.</li>
<li><strong>Chương trình cho thuê:</strong> căn hộ có thể tham gia chương trình cho thuê do Nobu Hospitality vận hành. Mức lợi nhuận một số nơi nêu (khoảng 6%/năm) cần kiểm tra điều kiện cụ thể trong hợp đồng.</li>
<li><strong>Phí quản lý, phí thương hiệu</strong> hằng tháng của căn hộ hàng hiệu thường cao hơn căn hộ thường. Hỏi rõ trước khi ký.</li>
<li><strong>Tiến độ:</strong> tháng 10/2026 kết cấu đã đến tầng 22, bàn giao dự kiến năm 2027 (xem <a href="/tien-do-nobu-residences-da-nang/">tiến độ Nobu Đà Nẵng</a>).</li>
</ol>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-ho-boi-nuoc-am-tren-cao.jpg|Hồ bơi nước ấm trên cao Nobu Đà Nẵng (phối cảnh)-->
<h2>So với căn hộ cao cấp khác ở Đà Nẵng</h2>
<p>Ở phía sông Hàn, <a href="/du-an/the-legend-da-nang/">The Legend</a> (sở hữu lâu dài) có giỏ hàng khoảng 119 – 188 triệu/m². Nobu khác ở thương hiệu vận hành quốc tế và vị trí mặt biển; The Legend khác ở pháp lý sở hữu lâu dài và vị trí chân cầu Rồng.</p>
{$cta('Nobu Residences Đà Nẵng')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Nobu Đà Nẵng bao nhiêu? 1PN từ 6,63 tỷ (11/2026)',
			'desc'      => 'Giá Nobu Đà Nẵng (Nobu Residences) tham khảo: căn 1PN 62,5 – 71,1 m² khoảng 6,63 – 9,06 tỷ. Loại căn, đơn giá/m², điều cần kiểm tra về sở hữu.',
			'points'    => array(
				'Căn 1PN 62,5 – 71,1 m² khoảng 6,63 – 9,06 tỷ (tham khảo)',
				'Đơn giá các nguồn nêu khoảng 145 – 205 triệu/m², chênh theo tầng, view, cách tính',
				'Thời hạn sở hữu các nguồn chưa thống nhất – cần đối chiếu hợp đồng',
			),
			'faq'       => array(
				array( 'Giá Nobu Residences Đà Nẵng bao nhiêu?', 'Căn 1PN 62,5 – 71,1 m² tham khảo khoảng 6,63 – 9,06 tỷ; đơn giá một số nguồn nêu khoảng 145 – 205 triệu/m² tùy tầng và hướng view. Đây là giá tổng hợp từ nhiều nguồn, chưa phải bảng giá chính thức.' ),
				array( 'Nobu Đà Nẵng có bao nhiêu căn hộ?', '264 căn hộ du lịch hàng hiệu, cùng khách sạn Nobu khoảng 200 phòng (gồm 18 suite), trong tháp 43 tầng.' ),
				array( 'Nobu Residences Đà Nẵng sở hữu bao lâu?', 'Các nguồn chưa thống nhất: có nguồn ghi sở hữu lâu dài cho người Việt và 50 năm cho người nước ngoài, nguồn khác ghi đến năm 2060 theo đất thương mại dịch vụ. Người mua nên đối chiếu hợp đồng mua bán.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Nobu – Tiến độ ---------------- */
	$posts[] = array(
		'slug'     => 'tien-do-nobu-residences-da-nang',
		'title'    => 'Tiến độ Nobu Residences Đà Nẵng 10/2026: kết cấu đến tầng 22, lắp kính tầng 7 – 13',
		'excerpt'  => 'Tiến độ xây dựng Nobu Residences Đà Nẵng theo từng tháng: khởi công quý 2/2024, tháng 5/2026 đổ sàn tầng 8, tháng 10/2026 kết cấu đến tầng 22, lắp mặt dựng kính tầng 7 – 13, cơ điện và PCCC tới tầng 17. Bàn giao dự kiến 2027.',
		'keyword'  => 'tiến độ Nobu Đà Nẵng',
		'keywords_extra' => array( 'tiến độ Nobu Residences Đà Nẵng', 'Nobu Đà Nẵng xây đến đâu', 'Nobu Đà Nẵng bàn giao' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-14 14:00',
		'category' => 'Dự án',
		'tags'     => array( 'Nobu Residences Đà Nẵng', 'Tiến độ dự án' ),
		'image'    => 'plugin:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-toan-canh.jpg',
		'image_alt' => 'Công trường Nobu Đà Nẵng tháng 10/2026 – kết cấu đến tầng 22 (ảnh thực tế của chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Tiến độ Nobu Residences Đà Nẵng (cập nhật 10/2026):</strong> kết cấu đã lên đến <strong>tầng 22</strong> (tháp 43 tầng); đang lắp mặt dựng, kính từ tầng 7 đến 13; thi công cơ điện và PCCC tới tầng 17; xây tô, sơn nước khối đế tầng 2 – 6 và tầng hầm. Dự án khởi công quý 2/2024, bàn giao dự kiến năm 2027.</p>
<p><small>Tổng hợp: Hoàng Hiệp từ cập nhật tiến độ và ảnh công trường của chủ đầu tư (09/11/2026).</small></p>
</div>
<p>Khách quan tâm {$nobu} thường hỏi "đã xây đến đâu". Bài này tổng hợp <strong>tiến độ Nobu Đà Nẵng</strong> theo từng mốc, kèm ảnh công trường thực tế do chủ đầu tư công bố. Nhà thầu thi công là Newtecons.</p>
<!--hh-featured-->
<h2>Các mốc tiến độ Nobu Đà Nẵng</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Tiến độ</th></tr></thead>
<tbody>
<tr><td>Quý 2/2024</td><td>Khởi công, Newtecons thi công</td></tr>
<tr><td>01 – 02/2026</td><td>Hoàn thành sàn chuyển L6M, chuyển sang thi công tầng điển hình</td></tr>
<tr><td>05/2026</td><td>Đổ bê tông sàn tầng 8, lắp hệ leo tầng 9</td></tr>
<tr><td>06/2026</td><td>Thi công hệ bao che trượt tầng 10; xây tô, cơ điện từ tầng hầm đến tầng 5</td></tr>
<tr><td>08/2026</td><td>Tiếp tục thi công phần thân (ảnh công trường)</td></tr>
<tr><td>10/2026</td><td>Kết cấu đến tầng 22; lắp mặt dựng, kính tầng 7 – 13; cơ điện, PCCC tới tầng 17</td></tr>
<tr><td>2027</td><td>Dự kiến hoàn thiện, bàn giao và vận hành</td></tr>
</tbody>
</table>
<h2>Tháng 10/2026: công trường làm gì</h2>
<h3>Phần kết cấu</h3>
<p>Thi công cốp pha, cốt thép và đổ bê tông sàn tầng 22. Từ tháng 5 (tầng 8) đến tháng 10 (tầng 22), kết cấu lên thêm khoảng 14 tầng trong 5 tháng.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-do-san-tang-22.jpg|Thi công cốp pha, cốt thép, đổ bê tông sàn tầng 22 – tháng 10/2026 (ảnh chủ đầu tư)-->
<h3>Mặt dựng và cửa kính</h3>
<p>Lắp khung cửa kính lùa, lan can kính ở các tầng 7 – 12, mặt dựng kính tới tầng 13.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-lap-cua-kinh.jpg|Lắp khung cửa kính lùa, lan can kính tầng 7 – 12 – tháng 10/2026 (ảnh chủ đầu tư)-->
<h3>Cơ điện, PCCC</h3>
<p>Thi công hệ thống cơ điện (MEP) và phòng cháy chữa cháy ở các tầng 14 – 16, tổng thể tới tầng 17.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-co-dien-tang-14-16.jpg|Thi công cơ điện MEP, PCCC tầng 14 – 16 – tháng 10/2026 (ảnh chủ đầu tư)-->
<h3>Khối đế và tầng hầm</h3>
<p>Xây tô, sơn nước tầng 2 – 6 của khối đế; xây tô, sơn nước và cơ điện tầng hầm B1, B2.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-xay-to-khoi-de.jpg|Xây tô, sơn nước tầng 2 – 6 khối đế – tháng 10/2026 (ảnh chủ đầu tư)-->
<h2>Còn bao nhiêu tầng nữa</h2>
<p>Tháp cao 43 tầng nổi, tháng 10/2026 kết cấu ở tầng 22, tức còn khoảng 21 tầng phần thân. Hoàng Hiệp sẽ cập nhật bài này mỗi khi chủ đầu tư công bố tiến độ mới.</p>
<h2>Ý nghĩa với người mua</h2>
<ul>
<li>Phần thân đang lên đều, hoàn thiện (kính, cơ điện, xây tô) chạy song song ở các tầng dưới.</li>
<li>Bàn giao dự kiến năm 2027 (các nguồn ghi quý 1 – quý 3/2027). Mốc chính xác theo hợp đồng mua bán.</li>
</ul>
<p>Xem giá và loại căn: <a href="/gia-nobu-residences-da-nang-bao-nhieu/">giá bán Nobu Residences Đà Nẵng</a>.</p>
{$cta('Nobu Residences Đà Nẵng')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiến độ Nobu Đà Nẵng 10/2026: kết cấu đến tầng 22',
			'desc'      => 'Tiến độ Nobu Đà Nẵng 10/2026: kết cấu đến tầng 22, lắp kính tầng 7 – 13, cơ điện và PCCC tới tầng 17. Khởi công quý 2/2024, bàn giao dự kiến 2027.',
			'points'    => array(
				'Tháng 10/2026: kết cấu đến tầng 22 của tháp 43 tầng',
				'Lắp mặt dựng, kính tầng 7 – 13; cơ điện, PCCC tới tầng 17',
				'Nhà thầu Newtecons; bàn giao dự kiến năm 2027',
			),
			'faq'       => array(
				array( 'Nobu Đà Nẵng đã xây đến tầng mấy?', 'Theo cập nhật của chủ đầu tư, tháng 10/2026 kết cấu đã đến tầng 22 trong tổng số 43 tầng nổi.' ),
				array( 'Nobu Residences Đà Nẵng khi nào bàn giao?', 'Dự kiến năm 2027 (các nguồn ghi quý 1 – quý 3/2027). Mốc chính xác theo hợp đồng mua bán.' ),
				array( 'Ai thi công Nobu Đà Nẵng?', 'Nhà thầu Newtecons, khởi công quý 2/2024.' ),
			),
		),
		'sources'  => array( 'https://nobudanang.vn/constructions/cap-nhat-tien-do-xay-dung-thang-05-2026/' ),
	);

	return $posts;
}
