<?php
/**
 * Bài vệ tinh lô 3 (theo báo cáo phân tích đối thủ 10/11/2026):
 * chủ đầu tư Sun Saphia; Sun Saphia hay Symphony 5 để cho thuê; vay mua Capital Square; Nobu hay The Legend.
 * Số liệu lấy từ dữ liệu dự án, hồ sơ chủ đầu tư trên web – không thêm số mới; ví dụ tính toán ghi rõ là ước tính.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_cum_du_an_11_2026_lo_3' );
function hh_posts_cum_du_an_11_2026_lo_3( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$s5     = '<a href="/du-an/symphony-5-sun-symphony-residence/">Symphony 5</a>';
	$cs     = '<a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a>';
	$sign   = '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ tài liệu chủ đầu tư và dữ liệu dự án · cập nhật 10/11/2026.</small></p>';
	$cta    = static fn( $name ) => '<p>Cần bảng giá, phiếu tính dòng tiền và so sánh ' . $name . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- Sun Saphia hay Symphony 5 ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-hay-symphony-5-mua-studio-cho-thue',
		'title'    => 'Sun Saphia Residence hay Symphony 5: mua studio cho thuê ở Đà Nẵng chọn dự án nào?',
		'excerpt'  => 'So sánh Sun Saphia Residence (biển Sơn Thủy) và Symphony 5 (sông Hàn) – hai dự án căn hộ 50 năm của Sun Group: giá studio, số căn, nhận nhà, chính sách, khách thuê, rủi ro cạnh tranh.',
		'keyword'  => 'Sun Saphia hay Symphony 5',
		'keywords_extra' => array( 'so sánh Sun Saphia và Symphony 5', 'studio cho thuê Đà Nẵng', 'căn hộ Sun Group cho thuê' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-17 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Symphony 5', 'Đầu tư cho thuê' ),
		'image'    => 'plugin:img/sun-symphony-5/sun-symphony-5-pc-02-tong-the-2.jpg',
		'image_alt' => 'Sun Symphony Residence nhìn từ sông Hàn về bán đảo Sơn Trà (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Sun Saphia hay Symphony 5?</strong> Cả hai đều là căn hộ 50 năm của Sun Group, phần lớn là studio để cho thuê. <strong>Sun Saphia Residence</strong> sát biển Sơn Thủy, 782 căn, studio 30 m² tầng 15 giá dự kiến 2,13 – 2,85 tỷ (chưa VAT, phí bảo trì), bàn giao 11/2028. <strong>Symphony 5</strong> bên sông Hàn, 1.228 căn, studio 30 – 33 m² khoảng 2,50 – 3,30 tỷ (đã gồm VAT, phí bảo trì), nhận căn sử dụng dự kiến 30/06/2028. Khách du lịch biển hợp Sun Saphia; khách thích trung tâm, pháo hoa hợp Symphony 5.</p>
{$sign}
</div>
<p>Hai dự án căn hộ Sun Group được hỏi nhiều nhất cuối năm 2026 là {$saphia} và {$s5}. Cả hai cùng thương hiệu, cùng thời hạn 50 năm, cùng nhiều studio. Bài này so sánh theo góc nhìn người mua để cho thuê.</p>
<!--hh-featured-->
<h2>Bảng so sánh</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Sun Saphia Residence</th><th>Symphony 5</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Võ Nguyên Giáp – Trường Sa, bãi tắm Sơn Thủy (Ngũ Hành Sơn)</td><td>Lê Văn Duyệt, bờ Đông sông Hàn (Sơn Trà)</td></tr>
<tr><td>Quy mô</td><td>1 tòa 30 tầng, 782 căn</td><td>1 tháp 31 tầng, 1.228 căn</td></tr>
<tr><td>Số studio</td><td>513 căn (30 – 31 m²)</td><td>725 căn (30 – 33 m²)</td></tr>
<tr><td>Giá studio</td><td>2,13 – 2,85 tỷ (tầng 15, giá dự kiến, chưa VAT, phí bảo trì)</td><td>2,50 – 3,30 tỷ (giỏ hàng 11/2026, gồm VAT, phí bảo trì)</td></tr>
<tr><td>Thời hạn</td><td>50 năm từ 17/09/2026</td><td>50 năm (đất thương mại dịch vụ)</td></tr>
<tr><td>Nhận nhà</td><td>Bàn giao dự kiến 11/2028</td><td>Nhận căn sử dụng dự kiến 30/06/2028 (thanh toán 70%)</td></tr>
<tr><td>Hỗ trợ lãi suất</td><td>Lên tới 24 tháng</td><td>Tối đa 30 tháng (vay tối đa 70%)</td></tr>
<tr><td>Tình trạng</td><td>Sắp mở bán (sự kiện bán hàng dự kiến 05/12/2026)</td><td>Đang bán (CSBH 02 từ 20/7/2026)</td></tr>
</tbody>
</table>
<p><small>Giá hai dự án tính khác nhau: Sun Saphia chưa gồm VAT và phí bảo trì, Symphony 5 đã gồm. Khi so tổng tiền, cộng thêm VAT và phí bảo trì cho Sun Saphia.</small></p>
<h2>Khách thuê của mỗi dự án</h2>
<h3>Sun Saphia: khách nghỉ biển</h3>
<p>Sát bãi tắm Sơn Thủy, phía trước là công viên ven biển khoảng 2,45 ha thành phố đang đầu tư, ga LRT 09 dự kiến cách khoảng 500 m. Hợp khách du lịch ở ngắn ngày, gia đình nghỉ biển. Mùa cao điểm hè cho thuê tốt; mùa mưa (tháng 9 – 12) cạnh tranh hơn.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg|Sun Saphia Residence nhìn từ biển Sơn Thủy (ảnh chủ đầu tư)-->
<h3>Symphony 5: khách trung tâm, sự kiện</h3>
<p>Bên sông Hàn, cách cầu Rồng khoảng 1,5 km, biển Mỹ Khê khoảng 2,5 km, ngay điểm ngắm pháo hoa DIFF. Hợp khách công tác, khách đi sự kiện, khách thuê dài hạn làm việc ở trung tâm. Có Sun Early Key: trả 70% là nhận căn khai thác sớm hơn.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-08-dem-phao-hoa.jpg|Symphony 5 đêm pháo hoa DIFF bên sông Hàn (phối cảnh chủ đầu tư)-->
<h2>Rủi ro chung: nhiều studio cùng cho thuê</h2>
<p>Sun Saphia có 513 studio, Symphony 5 có 725 studio. Khi nhận nhà, nhiều căn giống nhau cùng ra thị trường cho thuê nên giá thuê mùa thấp điểm dễ bị kéo xuống. Căn có view tốt (biển trực diện ở Sun Saphia, sông và cầu ở Symphony 5) và tầng cao giữ giá thuê tốt hơn.</p>
<h2>Bài toán dòng tiền</h2>
<p>Với studio Sun Saphia, Hoàng Hiệp đã dựng 3 kịch bản lợi suất ròng 3,5 – 5,5%/năm (thận trọng đến vận hành tốt) bên cạnh bài toán 11,7% của chủ đầu tư (cho thuê ngắn ngày, lấp đầy 60%). Xem chi tiết: <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">đầu tư Sun Saphia cho thuê – 3 kịch bản</a>. Cách tính tương tự áp dụng cho studio Symphony 5 với giá mua của từng căn.</p>
<h2>Nên chọn dự án nào</h2>
<ul>
<li><strong>Muốn sát biển, nhắm khách du lịch:</strong> Sun Saphia. Chờ bảng giá chính thức ngày mở bán.</li>
<li><strong>Muốn có giá rõ ngay, nhận căn sớm hơn:</strong> Symphony 5 (giỏ hàng đã có, nhận căn sử dụng dự kiến 30/06/2028).</li>
<li><strong>Vay nhiều:</strong> Symphony 5 hỗ trợ lãi suất dài hơn (tối đa 30 tháng so với 24 tháng).</li>
</ul>
<p>Xem thêm: <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia</a>, <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá Symphony 5</a>.</p>
{$cta('Sun Saphia và Symphony 5')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia hay Symphony 5: mua studio cho thuê?',
			'desc'      => 'So sánh Sun Saphia Residence và Symphony 5 để cho thuê: studio 2,13 – 2,85 tỷ (chưa VAT) và 2,50 – 3,30 tỷ (gồm VAT), biển Sơn Thủy và sông Hàn, nhận nhà 11/2028 và 6/2028.',
			'points'    => array(
				'Cùng Sun Group, cùng 50 năm, phần lớn là studio',
				'Sun Saphia sát biển Sơn Thủy, 513 studio; Symphony 5 bên sông Hàn, 725 studio',
				'Symphony 5 có giá rõ, nhận căn sớm hơn; Sun Saphia sắp mở bán 05/12/2026',
			),
			'faq'       => array(
				array( 'Sun Saphia và Symphony 5 dự án nào rẻ hơn?', 'Studio Sun Saphia tầng 15 giá dự kiến 2,13 – 2,85 tỷ nhưng chưa gồm VAT và phí bảo trì; studio Symphony 5 khoảng 2,50 – 3,30 tỷ đã gồm VAT và phí bảo trì. Cần cộng VAT, phí bảo trì cho Sun Saphia rồi mới so.' ),
				array( 'Sun Saphia và Symphony 5 sở hữu bao lâu?', 'Cả hai đều 50 năm: Sun Saphia tính từ 17/09/2026; Symphony 5 theo quyết định giao đất thương mại dịch vụ 50 năm.' ),
				array( 'Dự án nào nhận nhà sớm hơn?', 'Symphony 5: nhận căn sử dụng dự kiến 30/06/2028 khi thanh toán 70%. Sun Saphia bàn giao dự kiến 11/2028.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Chủ đầu tư Sun Saphia ---------------- */
	$posts[] = array(
		'slug'     => 'chu-dau-tu-sun-saphia-residence-la-ai',
		'title'    => 'Chủ đầu tư Sun Saphia Residence là ai? Sun Group, Sun Property và các dự án đã làm ở Đà Nẵng',
		'excerpt'  => 'Chủ đầu tư Sun Saphia Residence là Sun Group (Công ty CP Tập đoàn Mặt Trời), Sun Property phát triển. Tập đoàn khởi nghiệp tại Đà Nẵng năm 2007; các dự án đã bàn giao, đang bán; điều cần hỏi về pháp nhân ký hợp đồng.',
		'keyword'  => 'chủ đầu tư Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence của ai', 'Sun Property Đà Nẵng', 'Sun Group Đà Nẵng dự án' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-18 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Sun Group', 'Chủ đầu tư' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-cdt-toa-thap-ngay.jpg',
		'image_alt' => 'Tòa tháp Sun Saphia Residence ban ngày bên biển Sơn Thủy (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Chủ đầu tư Sun Saphia Residence là Sun Group</strong> (pháp danh Công ty CP Tập đoàn Mặt Trời), dự án do <strong>Sun Property</strong> – đơn vị phát triển nhà ở của tập đoàn – phát triển. Sun Group khởi nghiệp tại Đà Nẵng năm 2007, hoạt động trong du lịch nghỉ dưỡng, vui chơi giải trí, bất động sản và hạ tầng. Tại Đà Nẵng, tập đoàn đã bàn giao nhiều dự án nhà ở như Premier Village, Euro Village 2 và đang bàn giao Sun Symphony Residence, Sun Cosmo Residence.</p>
{$sign}
</div>
<p>Trước khi đặt chỗ {$saphia}, nhiều khách hỏi "chủ đầu tư là ai, đã làm những gì". Bài này tóm tắt thông tin về Sun Group, Sun Property và những dự án nhà ở tập đoàn đã làm ở Đà Nẵng, kèm điều cần kiểm tra trong hợp đồng.</p>
<!--hh-featured-->
<h2>Sun Group là ai</h2>
<table>
<tbody>
<tr><th>Tên pháp lý</th><td>Công ty CP Tập đoàn Mặt Trời</td></tr>
<tr><th>Thành lập</th><td>2007, khởi nghiệp tại Đà Nẵng</td></tr>
<tr><th>Lĩnh vực</th><td>Du lịch nghỉ dưỡng, vui chơi giải trí, bất động sản, hạ tầng</td></tr>
<tr><th>Đơn vị phát triển nhà ở</th><td>Sun Property – phát triển các dự án nhà ở tại Đà Nẵng từ Sunneva Island (2022)</td></tr>
<tr><th>Khu vực dự án ở Đà Nẵng</th><td>Bà Nà, bán đảo Sơn Trà, hai bờ sông Hàn, Hòa Xuân – Hòa Quý</td></tr>
</tbody>
</table>
<p>Hồ sơ chi tiết: <a href="/chu-dau-tu/sun-group/">chủ đầu tư Sun Group</a>.</p>
<p><strong>Lưu ý tên gần giống:</strong> Sun Frontier (chủ đầu tư Hiyori Garden Tower) là tập đoàn Nhật Bản, không liên quan Sun Group.</p>
<h2>Các dự án nhà ở của Sun Group tại Đà Nẵng</h2>
<table>
<thead><tr><th>Dự án</th><th>Loại hình</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/premier-village-da-nang/">Premier Village</a></td><td>Biệt thự</td><td>Đã bàn giao</td></tr>
<tr><td><a href="/du-an/euro-village-2/">Euro Village 2</a></td><td>Biệt thự, nhà phố Hòa Xuân</td><td>Đã bàn giao</td></tr>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a></td><td>Căn hộ, thấp tầng ven sông Hàn</td><td>Đang bàn giao</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Căn hộ</td><td>Đang bàn giao</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Căn hộ ven sông Hàn</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/sun-neo-city/">Sun NeO City</a></td><td>Khu đô thị Hòa Xuân (Cora, Spana, S-Light)</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/sun-riverpolis/">Sun Riverpolis</a></td><td>Khu đô thị Nam Hòa Xuân (FourS Tower)</td><td>Đang bán</td></tr>
<tr><td><a href="/du-an/symphony-5-sun-symphony-residence/">Symphony 5</a></td><td>Căn hộ 50 năm bên sông Hàn</td><td>Đang bán</td></tr>
<tr><td>Sun Saphia Residence</td><td>Căn hộ 50 năm ven biển</td><td>Sắp mở bán</td></tr>
</tbody>
</table>
<p>Xem toàn bộ: <a href="/du-an-can-ho-sun-group-da-nang-2026/">dự án căn hộ Sun Group Đà Nẵng 2026</a>.</p>
<!--hh-img:img/sun-saphia/sun-saphia-cdt-hoang-hon-bien-tren-cao.jpg|Sun Saphia Residence lúc hoàng hôn nhìn từ trên cao về biển (ảnh chủ đầu tư)-->
<h2>Sun Saphia Residence trong hệ sinh thái Sun Group</h2>
<p>Chủ đầu tư giới thiệu Sun Saphia là <strong>dự án căn hộ mặt biển đầu tiên</strong> của Sun Group tại Đà Nẵng: tòa 30 tầng (114 m), 782 căn trên khu đất 3.720,1 m² ở giao lộ Võ Nguyên Giáp – Trường Sa. Thời hạn dự án 50 năm kể từ 17/09/2026; công trình cấp I, niên hạn 100 năm. Ngân hàng hỗ trợ: Vietcombank, BIDV, NCB.</p>
<h2>Cần kiểm tra gì về chủ đầu tư khi ký</h2>
<ol>
<li><strong>Pháp nhân ký hợp đồng:</strong> mỗi dự án của tập đoàn thường do một công ty dự án riêng làm chủ đầu tư. Đọc tên pháp nhân trên hợp đồng đặt chỗ, hợp đồng mua bán.</li>
<li><strong>Văn bản đủ điều kiện bán</strong> của Sở Xây dựng Đà Nẵng trước khi ký hợp đồng mua bán.</li>
<li><strong>Bảo lãnh ngân hàng</strong> cho nghĩa vụ bàn giao (hỏi ngân hàng bảo lãnh).</li>
<li><strong>Thời hạn sở hữu</strong> ghi trong hợp đồng (50 năm từ 17/09/2026).</li>
</ol>
<p>Phân biệt với khu đô thị cùng tên: <a href="/sun-saphia-residence-va-khu-do-thi-saphia-khac-nhau/">Sun Saphia Residence và Khu đô thị Saphia khác nhau thế nào</a>.</p>
{$cta('Sun Saphia Residence')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chủ đầu tư Sun Saphia Residence là ai? Sun Group',
			'desc'      => 'Chủ đầu tư Sun Saphia Residence là Sun Group (Công ty CP Tập đoàn Mặt Trời), Sun Property phát triển; khởi nghiệp tại Đà Nẵng 2007. Dự án đã bàn giao, đang bán; cần kiểm tra gì khi ký.',
			'points'    => array(
				'Sun Group (Công ty CP Tập đoàn Mặt Trời), Sun Property phát triển',
				'Khởi nghiệp tại Đà Nẵng năm 2007; đã bàn giao Premier Village, Euro Village 2',
				'Kiểm tra pháp nhân ký hợp đồng, văn bản đủ điều kiện bán, bảo lãnh ngân hàng',
			),
			'faq'       => array(
				array( 'Chủ đầu tư Sun Saphia Residence là ai?', 'Sun Group (Công ty CP Tập đoàn Mặt Trời); dự án do Sun Property – đơn vị phát triển nhà ở của tập đoàn – phát triển.' ),
				array( 'Sun Group đã làm những dự án nào ở Đà Nẵng?', 'Bà Nà Hills; các dự án nhà ở Premier Village, Euro Village 2 (đã bàn giao), Sun Symphony Residence, Sun Cosmo Residence (đang bàn giao), Sun Ponte, Sun NeO City, Sun Riverpolis, Symphony 5 (đang bán).' ),
				array( 'Sun Frontier có phải Sun Group không?', 'Không. Sun Frontier là tập đoàn bất động sản Nhật Bản (chủ đầu tư Hiyori Garden Tower), không liên quan Sun Group.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Vay mua Capital Square ---------------- */
	$posts[] = array(
		'slug'     => 'vay-mua-capital-square-da-nang-tra-gop-hang-thang',
		'title'    => 'Vay mua Capital Square Đà Nẵng: vay 70%, 0% lãi suất đến 36 tháng, trả góp mỗi tháng bao nhiêu?',
		'excerpt'  => 'Vay mua căn hộ Capital Square (Hudson Place S4, Broadway S3): vay tới 70%, lãi suất 0% đến 36 tháng, ân hạn gốc 36 tháng; hai phương án hỗ trợ lãi suất và ví dụ căn 1PN 4,32 tỷ cần vốn tự có, trả góp bao nhiêu.',
		'keyword'  => 'vay mua Capital Square',
		'keywords_extra' => array( 'Capital Square trả góp', 'Hudson Place vay ngân hàng', 'vay mua căn hộ Capital Square Đà Nẵng' ),
		'project'  => 'capital-square-hudson-place-s4',
		'schedule' => '2026-11-18 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Capital Square Đà Nẵng', 'Hudson Place', 'Vay mua nhà' ),
		'image'    => 'plugin:img/hudson-place/hudson-place-toan-canh-capital-square-ven-song.jpg',
		'image_alt' => 'Toàn cảnh Capital Square ven sông Hàn, Đà Nẵng (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Vay mua Capital Square:</strong> với tòa Hudson Place S4, ngân hàng cho vay tới <strong>70% tổng giá bán</strong> (có VAT, không gồm kinh phí bảo trì), <strong>lãi suất 0% đến 36 tháng</strong>, ân hạn gốc 36 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ. Ví dụ căn 1PN 4,32 tỷ: vay khoảng 3,02 tỷ, vốn tự có khoảng 1,3 tỷ. Chính sách 11/2026 cho tòa S3, S4 nêu "vay 5 năm không lo lãi suất" – hỏi điều kiện cụ thể khi đặt căn.</p>
{$sign}
</div>
<p>Giá căn hộ {$cs} từ khoảng 4,3 tỷ nên phần lớn khách mua có vay ngân hàng. Bài này giải thích hai phương án hỗ trợ lãi suất của tòa <a href="/du-an/capital-square-hudson-place-s4/">Hudson Place S4</a> và ví dụ dòng tiền để anh chị chuẩn bị vốn.</p>
<!--hh-featured-->
<h2>Điều kiện vay</h2>
<ul>
<li>Vay tới <strong>70% tổng giá bán</strong> (có VAT, không gồm kinh phí bảo trì).</li>
<li>Ân hạn nợ gốc 36 tháng.</li>
<li>Miễn phí trả nợ trước hạn trong thời gian hỗ trợ lãi suất.</li>
</ul>
<h2>Hai phương án hỗ trợ lãi suất (Hudson Place S4)</h2>
<table>
<thead><tr><th>Phương án</th><th>Phần vay bằng 50% giá bán</th><th>Phần vay bằng 20% giá bán</th><th>Sau hỗ trợ</th></tr></thead>
<tbody>
<tr><td>Phương án 1</td><td>0% trong 36 tháng</td><td>0% trong 24 tháng</td><td>Lãi suất theo ngân hàng</td></tr>
<tr><td>Phương án 2</td><td>0% trong 24 tháng</td><td>0% trong 12 tháng</td><td>Cố định 7,5%/năm trong 36 tháng</td></tr>
</tbody>
</table>
<p>Phương án 1 hợp khách muốn hưởng 0% lâu nhất. Phương án 2 hợp khách muốn biết trước lãi suất 3 năm tiếp theo.</p>
<!--hh-img:img/hudson-place/hudson-place-phoi-canh-dem-toa-s4-c3.jpg|Tòa S4 Hudson Place và C3 về đêm (phối cảnh chủ đầu tư)-->
<h2>Ví dụ: căn 1PN Hudson Place giá 4,32 tỷ</h2>
<p>Hoàng Hiệp tự tính để anh chị hình dung, chưa trừ chiết khấu và chưa phải phiếu tính giá của chủ đầu tư.</p>
<table>
<thead><tr><th>Khoản</th><th>Số tiền (ước tính)</th></tr></thead>
<tbody>
<tr><td>Giá căn (gồm VAT, kinh phí bảo trì)</td><td>4,32 tỷ</td></tr>
<tr><td>Vay 70%</td><td>Khoảng 3,02 tỷ</td></tr>
<tr><td>Vốn tự có 30%</td><td>Khoảng 1,30 tỷ</td></tr>
<tr><td>Trong thời gian 0% lãi, ân hạn gốc</td><td>Gần như không trả lãi, gốc</td></tr>
<tr><td>Sau hỗ trợ, giả định lãi 10%/năm, vay 20 năm</td><td>Khoảng 29 triệu/tháng (gốc + lãi)</td></tr>
</tbody>
</table>
<p><small>Lãi suất 10%/năm là giả định để minh họa; lãi thực tế theo ngân hàng từng thời điểm. Với phương án 2, ba năm sau hỗ trợ cố định 7,5%/năm nên số trả mỗi tháng thấp hơn.</small></p>
<h2>Chính sách vay tháng 11/2026 cho tòa S3, S4</h2>
<p>Bộ chính sách mới của Broadway Place S3 và Hudson Place S4 gồm: vay ngân hàng "5 năm không lo lãi suất", chiết khấu thêm 5%, quà Smart Home 100 – 300 triệu và chuyến du lịch châu Âu trị giá 100 triệu. Điều kiện và hạn mức của gói "5 năm" anh chị cần hỏi khi đặt căn để so với hai phương án ở trên.</p>
<h2>Vay hay trả sớm</h2>
<ul>
<li><strong>Vay:</strong> giữ vốn, hưởng 0% lãi trong 2 – 3 năm đầu. Hợp khách mua để ở hoặc chờ tăng giá.</li>
<li><strong>Trả sớm:</strong> theo tài liệu 28/9/2026, chiết khấu theo tiến độ 8%, thanh toán nhanh 100% được 12%, thanh toán sớm 95% được 18% (hỏi lại mức đang áp dụng khi đặt căn).</li>
</ul>
<p>Xem giá từng tòa: <a href="/bang-gia-capital-square-da-nang-theo-toa/">bảng giá Capital Square theo tòa</a>.</p>
{$cta('Capital Square')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Vay mua Capital Square: 70%, lãi 0% đến 36 tháng',
			'desc'      => 'Vay mua Capital Square Đà Nẵng: vay 70% giá bán, lãi 0% đến 36 tháng, ân hạn gốc 36 tháng. Hai phương án hỗ trợ lãi suất, ví dụ căn 1PN 4,32 tỷ: vốn tự có, trả góp mỗi tháng.',
			'points'    => array(
				'Vay tới 70% giá bán, ân hạn gốc 36 tháng',
				'Phương án 1: 0% 36 tháng (phần 50%), 24 tháng (phần 20%); phương án 2 cố định 7,5%/năm sau hỗ trợ',
				'Căn 1PN 4,32 tỷ: vốn tự có khoảng 1,3 tỷ',
			),
			'faq'       => array(
				array( 'Mua Capital Square được vay bao nhiêu?', 'Với tòa Hudson Place S4: vay tới 70% tổng giá bán (có VAT, không gồm kinh phí bảo trì), ân hạn gốc 36 tháng.' ),
				array( 'Capital Square hỗ trợ lãi suất bao lâu?', 'Phương án 1: 0% trong 36 tháng với phần vay bằng 50% giá bán, 24 tháng với phần 20%. Phương án 2: 0% trong 24 và 12 tháng, sau đó cố định 7,5%/năm trong 36 tháng.' ),
				array( 'Mua căn 1PN Capital Square cần bao nhiêu vốn?', 'Ví dụ căn 1PN Hudson Place 4,32 tỷ: vay 70% khoảng 3,02 tỷ, vốn tự có khoảng 1,3 tỷ (chưa trừ chiết khấu).' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Nobu hay The Legend ---------------- */
	$posts[] = array(
		'slug'     => 'nobu-residences-hay-the-legend-can-ho-cao-cap-da-nang',
		'title'    => 'Nobu Residences hay The Legend: chọn căn hộ cao cấp nào ở Đà Nẵng?',
		'excerpt'  => 'So sánh Nobu Residences Đà Nẵng (mặt biển Mỹ Khê, thương hiệu Nobu) và The Legend Đà Nẵng (chân cầu Rồng, sở hữu lâu dài): giá căn 1PN, loại căn, pháp lý, bàn giao, vận hành – ai hợp dự án nào.',
		'keyword'  => 'căn hộ cao cấp Đà Nẵng',
		'keywords_extra' => array( 'Nobu hay The Legend', 'so sánh Nobu và The Legend', 'căn hộ hạng sang Đà Nẵng' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-19 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Nobu Residences Đà Nẵng', 'The Legend Đà Nẵng', 'Căn hộ cao cấp' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-cau-rong-va-du-an-nhin-ra-bien.jpg',
		'image_alt' => 'Cầu Rồng và The Legend Đà Nẵng, phía xa là biển Mỹ Khê (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Nobu hay The Legend?</strong> <strong>Nobu Residences</strong> là căn hộ hàng hiệu mặt biển Mỹ Khê, thương hiệu Nobu vận hành, chỉ 264 căn, căn 1PN tham khảo khoảng 6,63 – 9,06 tỷ, bàn giao dự kiến 2027; thời hạn sở hữu các nguồn chưa thống nhất. <strong>The Legend</strong> là căn hộ <strong>sở hữu lâu dài</strong> ngay chân cầu Rồng, 800 căn, căn 1PN khoảng 7,65 – 9,59 tỷ, bàn giao dự kiến 31/3/2028. Mua để ở, để lại con cháu nghiêng về The Legend; mua căn hàng hiệu nghỉ dưỡng, cho thuê qua vận hành nghiêng về Nobu.</p>
{$sign}
</div>
<p>Ở phân khúc căn hộ cao cấp Đà Nẵng, hai dự án được so nhiều nhất là <a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a> và <a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a>. Cùng ở Sơn Trà, cách nhau không xa, nhưng khác nhau về pháp lý, thương hiệu và cách khai thác.</p>
<!--hh-featured-->
<h2>Bảng so sánh</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Nobu Residences</th><th>The Legend</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Góc Võ Văn Kiệt – Võ Nguyên Giáp, mặt biển Mỹ Khê</td><td>Lô A20 Võ Văn Kiệt, chân cầu Rồng, bên sông Hàn</td></tr>
<tr><td>Chủ đầu tư</td><td>VCRE (pháp nhân dự án Circle Point)</td><td>Công ty TNHH MTV VIPICO</td></tr>
<tr><td>Quy mô</td><td>Tháp 43 tầng (khoảng 186 m); 264 căn hộ, khách sạn khoảng 200 phòng</td><td>Tháp căn hộ 29 tầng (800 căn), tháp khách sạn 25 tầng</td></tr>
<tr><td>Căn 1PN</td><td>62,5 – 71,1 m², khoảng 6,63 – 9,06 tỷ (tham khảo)</td><td>54,4 – 60,3 m², khoảng 7,65 – 9,59 tỷ (giỏ hàng)</td></tr>
<tr><td>Loại căn khác</td><td>Studio, 2PN, 3PN Dual Key, Sky Villa, penthouse</td><td>1PN+1, 2PN, 3PN, penthouse duplex</td></tr>
<tr><td>Sở hữu</td><td>Các nguồn chưa thống nhất – cần đối chiếu hợp đồng</td><td>Lâu dài</td></tr>
<tr><td>Bàn giao</td><td>Dự kiến 2027</td><td>Dự kiến 31/3/2028</td></tr>
<tr><td>Vận hành</td><td>Nobu Hospitality</td><td>Khối khách sạn vận hành theo chuẩn khách sạn</td></tr>
<tr><td>Hoàn thiện</td><td>Nội thất tiêu chuẩn Nobu, phong cách Japandi</td><td>Hoàn thiện cao cấp, smarthome; quà nội thất 300 triệu – 1,8 tỷ</td></tr>
</tbody>
</table>
<h2>Điểm mạnh của Nobu</h2>
<ul>
<li>Thương hiệu Nobu Hospitality (Robert De Niro, đầu bếp Nobu Matsuhisa, Meir Teper); dự án Nobu Residences đầu tiên ở Đông Nam Á.</li>
<li>Mặt biển Mỹ Khê, nhà hàng Nobu tầng 42, hồ bơi vô cực nước ấm tầng 18.</li>
<li>Có chương trình cho thuê do Nobu Hospitality vận hành (điều kiện theo hợp đồng).</li>
<li>Tiến độ: tháng 10/2026 kết cấu đến tầng 22 (<a href="/tien-do-nobu-residences-da-nang/">xem tiến độ</a>).</li>
</ul>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-ban-cong-kep-view-bien.jpg|Ban công kép Nobu Đà Nẵng nhìn ra biển Mỹ Khê lúc hoàng hôn (phối cảnh)-->
<h2>Điểm mạnh của The Legend</h2>
<ul>
<li>Căn hộ sở hữu lâu dài ngay bên sông Hàn – loại hàng hiếm ở trung tâm.</li>
<li>Chân cầu Rồng, 4 mặt tiền, khoảng 1 km ra biển Mỹ Khê; ngắm pháo hoa DIFF.</li>
<li>Pháp lý có văn bản đủ điều kiện bán 800 căn; chiết khấu đến 12%, vay 70% hỗ trợ lãi suất 0% 24 tháng.</li>
</ul>
<!--hh-img:img/the-legend/the-legend-da-nang-dem-phao-hoa-song-han.jpg|Đêm pháo hoa sông Hàn nhìn từ vườn mái The Legend (phối cảnh)-->
<h2>Ai hợp dự án nào</h2>
<ul>
<li><strong>Mua để ở lâu dài, để lại con cháu:</strong> The Legend (sở hữu lâu dài).</li>
<li><strong>Mua căn hàng hiệu nghỉ dưỡng, giao vận hành cho thuê:</strong> Nobu.</li>
<li><strong>Muốn nhận nhà sớm hơn:</strong> Nobu (dự kiến 2027).</li>
<li><strong>Muốn nhiều ưu đãi trừ vào giá:</strong> The Legend (quà nội thất, chiết khấu thanh toán sớm).</li>
</ul>
<p>Xem thêm: <a href="/gia-nobu-residences-da-nang-bao-nhieu/">giá Nobu Residences</a>, <a href="/gia-the-legend-da-nang-bao-nhieu/">giá The Legend</a>.</p>
{$cta('Nobu và The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nobu hay The Legend: căn hộ cao cấp Đà Nẵng nào?',
			'desc'      => 'So sánh Nobu Residences và The Legend Đà Nẵng: mặt biển và chân cầu Rồng, căn 1PN 6,63 – 9,06 tỷ và 7,65 – 9,59 tỷ, thương hiệu Nobu và sở hữu lâu dài, bàn giao 2027 và 3/2028.',
			'points'    => array(
				'Nobu: căn hộ hàng hiệu mặt biển, 264 căn, bàn giao dự kiến 2027',
				'The Legend: sở hữu lâu dài chân cầu Rồng, 800 căn, bàn giao 31/3/2028',
				'Ở lâu dài chọn The Legend; nghỉ dưỡng, cho thuê qua vận hành chọn Nobu',
			),
			'faq'       => array(
				array( 'Nobu và The Legend dự án nào sở hữu lâu dài?', 'The Legend là căn hộ sở hữu lâu dài. Với Nobu, các nguồn chưa thống nhất (lâu dài cho người Việt hoặc đến 2060 theo đất thương mại dịch vụ) – cần đối chiếu hợp đồng.' ),
				array( 'Căn 1PN Nobu và The Legend giá bao nhiêu?', 'Nobu 1PN 62,5 – 71,1 m² khoảng 6,63 – 9,06 tỷ (tham khảo); The Legend 1PN 54,4 – 60,3 m² khoảng 7,65 – 9,59 tỷ (giỏ hàng, gồm VAT và phí bảo trì).' ),
				array( 'Dự án nào bàn giao sớm hơn?', 'Nobu dự kiến năm 2027; The Legend dự kiến 31/3/2028.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
