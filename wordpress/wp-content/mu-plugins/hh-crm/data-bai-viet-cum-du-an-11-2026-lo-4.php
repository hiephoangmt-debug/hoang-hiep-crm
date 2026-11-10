<?php
/**
 * Bài vệ tinh lô 4 (phần còn lại của báo cáo phân tích đối thủ 10/11/2026):
 * pháp lý The Legend, có nên mua The Legend, mặt bằng Cora Tower, căn hộ hàng hiệu Nobu, mặt bằng FourS Tower,
 * căn 1PN+ Sun Saphia, tiến độ Capital Square, chi phí khi mua căn hộ mới, hợp đồng căn hộ hình thành trong tương lai.
 * Số liệu dự án lấy từ dữ liệu trên web; quy định pháp luật nêu ở mức nguyên tắc chung, ghi rõ cần đối chiếu.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_cum_du_an_11_2026_lo_4' );
function hh_posts_cum_du_an_11_2026_lo_4( $posts ) {
	$legend = '<a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a>';
	$cora   = '<a href="/du-an/cora-tower/">Cora Tower</a>';
	$nobu   = '<a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a>';
	$fours  = '<a href="/du-an/fours-tower/">FourS Tower</a>';
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cs     = '<a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a>';
	$sign   = '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ tài liệu chủ đầu tư và dữ liệu dự án · cập nhật 10/11/2026.</small></p>';
	$cta    = static fn( $name ) => '<p>Cần bảng giá, mặt bằng tầng và phiếu tính dòng tiền ' . $name . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- The Legend – Pháp lý ---------------- */
	$posts[] = array(
		'slug'     => 'phap-ly-the-legend-da-nang-so-huu-lau-dai',
		'title'    => 'Pháp lý The Legend Đà Nẵng: sở hữu lâu dài, đủ điều kiện bán 800 căn – các văn bản cần biết',
		'excerpt'  => 'Pháp lý The Legend Đà Nẵng (lô A20 Võ Văn Kiệt): đấu giá đất 2017, sổ đất 2020, quy hoạch 1/500 năm 2024, giấy phép xây dựng phần ngầm 2025, đủ điều kiện huy động vốn và 800 căn đủ điều kiện bán. Căn hộ sở hữu lâu dài.',
		'keyword'  => 'pháp lý The Legend Đà Nẵng',
		'keywords_extra' => array( 'The Legend Đà Nẵng sở hữu lâu dài', 'The Legend City pháp lý', 'The Legend sổ hồng' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-19 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'The Legend Đà Nẵng', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-hai-toa-thap-truc-vo-van-kiet.jpg',
		'image_alt' => 'Hai tòa tháp The Legend trên trục Võ Văn Kiệt lúc chiều muộn (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Pháp lý The Legend Đà Nẵng:</strong> căn hộ <strong>sở hữu lâu dài</strong> trên lô đất đấu giá A20 Võ Văn Kiệt. Dự án có quyết định công nhận kết quả đấu giá (2017), giấy chứng nhận quyền sử dụng đất (2020), quy hoạch 1/500 (2024), giấy phép xây dựng phần ngầm (2025), văn bản đủ điều kiện huy động vốn (3/2025) và thông báo 800 căn hộ đủ điều kiện bán nhà ở hình thành trong tương lai (khoảng 1/2026). Khối khách sạn, căn hộ dịch vụ thời hạn 50 năm.</p>
{$sign}
</div>
<p>Với căn hộ giá từ khoảng 7,65 tỷ, câu hỏi đầu tiên của khách là pháp lý. Bài này liệt kê các văn bản của {$legend} theo thứ tự thời gian và giải thích ý nghĩa từng văn bản với người mua.</p>
<!--hh-featured-->
<h2>Các văn bản pháp lý The Legend Đà Nẵng</h2>
<table>
<thead><tr><th>Văn bản</th><th>Ngày</th><th>Ý nghĩa với người mua</th></tr></thead>
<tbody>
<tr><td>Quyết định 4105/QĐ-UBND công nhận kết quả đấu giá khu đất A20 Võ Văn Kiệt</td><td>28/7/2017</td><td>Chủ đầu tư có đất qua đấu giá</td></tr>
<tr><td>Giấy chứng nhận quyền sử dụng đất do UBND TP Đà Nẵng cấp</td><td>25/9/2020</td><td>Đất đã có sổ</td></tr>
<tr><td>Quy hoạch chi tiết 1/500 – Quyết định 2941/QĐ-UBND</td><td>24/5/2024</td><td>Quy mô, công năng đã được duyệt</td></tr>
<tr><td>Giấy chứng nhận đăng ký đầu tư điều chỉnh lần 1</td><td>15/7/2024</td><td>Dự án đã đăng ký đầu tư</td></tr>
<tr><td>Giấy phép xây dựng phần ngầm (3 tầng hầm) số 07/GPXD</td><td>14/02/2025</td><td>Được thi công phần ngầm</td></tr>
<tr><td>Công văn 674/SXD-QLN của Sở Xây dựng: đủ điều kiện huy động vốn</td><td>19/3/2025</td><td>Được nhận tiền theo hợp đồng</td></tr>
<tr><td>Sở Xây dựng thông báo 800 căn hộ đủ điều kiện bán nhà ở hình thành trong tương lai</td><td>Khoảng 1/2026</td><td>Được ký hợp đồng mua bán căn hộ</td></tr>
</tbody>
</table>
<p><small>Theo tài liệu chủ đầu tư và thông tin công bố. Khi ký, anh chị đề nghị xem bản sao các văn bản trên.</small></p>
<h2>Sở hữu lâu dài và 50 năm trong cùng dự án</h2>
<ul>
<li><strong>800 căn hộ</strong> trong tháp căn hộ 29 tầng: sở hữu lâu dài.</li>
<li><strong>Tháp khách sạn 25 tầng</strong> (222 phòng khách sạn, 222 căn hộ dịch vụ): thời hạn 50 năm.</li>
</ul>
<p>Khi chọn căn, hỏi rõ căn thuộc tháp nào để biết thời hạn sở hữu.</p>
<!--hh-img:img/the-legend/the-legend-da-nang-tien-do-6-2025-thi-cong-tang-ham.jpg|Thi công tầng hầm The Legend tháng 6/2025, mặt tiền Võ Văn Kiệt-->
<h2>Tiến độ gắn với pháp lý</h2>
<ul>
<li>Khởi công 28/2/2025; tháng 10/2025 hoàn thành khoảng 70% dầm, sàn, cột, vách hầm B2, thi công đào hầm B3.</li>
<li>Cất nóc dự kiến 31/12/2026; bàn giao căn hộ dự kiến 31/3/2028.</li>
<li>Giấy chứng nhận cấp sau bàn giao; 5% giá trị cuối đóng khi nhận sổ.</li>
</ul>
<h2>Câu nên hỏi trước khi ký</h2>
<ol>
<li>Căn thuộc danh sách 800 căn đủ điều kiện bán không?</li>
<li>Ngân hàng nào bảo lãnh nghĩa vụ bàn giao? Không lấy bảo lãnh được chiết khấu thêm 1% – cân nhắc kỹ.</li>
<li>Thời hạn cấp giấy chứng nhận dự kiến sau bàn giao.</li>
</ol>
<p>Xem thêm: <a href="/gia-the-legend-da-nang-bao-nhieu/">giá The Legend</a>, <a href="/mat-bang-can-ho-the-legend-da-nang/">mặt bằng The Legend</a>.</p>
{$cta('The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Pháp lý The Legend Đà Nẵng: sở hữu lâu dài, 800 căn',
			'desc'      => 'Pháp lý The Legend Đà Nẵng: đất đấu giá 2017, sổ đất 2020, quy hoạch 1/500 năm 2024, đủ điều kiện huy động vốn, 800 căn đủ điều kiện bán.',
			'points'    => array(
				'Căn hộ sở hữu lâu dài; khối khách sạn, căn hộ dịch vụ 50 năm',
				'Đất đấu giá 2017, sổ đất 2020, quy hoạch 1/500 ngày 24/5/2024',
				'Đủ điều kiện huy động vốn 3/2025; 800 căn đủ điều kiện bán khoảng 1/2026',
			),
			'faq'       => array(
				array( 'The Legend Đà Nẵng sở hữu bao lâu?', '800 căn hộ trong tháp căn hộ sở hữu lâu dài; tháp khách sạn và căn hộ dịch vụ thời hạn 50 năm.' ),
				array( 'The Legend đã đủ điều kiện bán chưa?', 'Theo thông tin công bố, Sở Xây dựng Đà Nẵng thông báo 800 căn hộ đủ điều kiện bán nhà ở hình thành trong tương lai khoảng tháng 1/2026; trước đó có Công văn 674/SXD-QLN (19/3/2025) đủ điều kiện huy động vốn.' ),
				array( 'The Legend có sổ đất chưa?', 'Có. Giấy chứng nhận quyền sử dụng đất do UBND TP Đà Nẵng cấp ngày 25/9/2020.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Cora – Mặt bằng ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-can-ho-cora-tower',
		'title'    => 'Mặt bằng Cora Tower: 2 tòa A1, A2 hai bên đường 29/3, 28 căn mỗi tầng, layout studio đến 3PN',
		'excerpt'  => 'Mặt bằng Cora Tower – Sun NeO City: hai tòa A1, A2 hai bên đường 29/3 gần vòng xoay Nguyễn Phước Lan; mỗi tòa 616 căn điển hình, 28 căn/tầng; tầng 1 shophouse, tầng 3 căn sân vườn, tầng 25 penthouse.',
		'keyword'  => 'mặt bằng Cora Tower',
		'keywords_extra' => array( 'layout Cora Tower', 'Cora Tower có bao nhiêu căn', 'mặt bằng tầng Cora Tower' ),
		'project'  => 'cora-tower',
		'schedule' => '2026-11-20 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Cora Tower', 'Sun NeO City', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/mat-bang-cora-tower.jpg',
		'image_alt' => 'Tổng mặt bằng Cora Tower – hai tòa A1, A2 hai bên đường 29/3 (bản vẽ chủ đầu tư, tham khảo)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mặt bằng Cora Tower:</strong> 2 tòa A1, A2 nằm hai bên đường 29/3, sát vòng xoay giao Nguyễn Phước Lan (Sun NeO City, Hòa Xuân). Mỗi tòa có <strong>616 căn hộ điển hình, 28 căn/tầng</strong>. Tầng 1 là shophouse khối đế, tầng 3 tòa A2 có căn hộ sân vườn, tầng 25 là penthouse. Loại căn: studio 32,3 m², 1PN+ 53,2 – 54,2 m², 2PN, 3PN.</p>
{$sign}
</div>
<p>Bài này giúp anh chị đọc <strong>mặt bằng {$cora}</strong>: vị trí hai tòa, cách bố trí từng tầng và layout các loại căn, để chọn căn trước khi xem giỏ hàng.</p>
<!--hh-featured-->
<h2>Tổng mặt bằng Cora Tower</h2>
<p>Hai tòa đối xứng qua đường 29/3. Mỗi tòa có dạng thân dài cong theo trục đường, hành lang giữa, căn hộ hai bên. Đầu tòa hướng về vòng xoay Nguyễn Phước Lan; xung quanh là nhà phố, biệt thự thấp tầng của Sun NeO City nên tầng trung trở lên khá thoáng.</p>
<h2>Bố trí theo tầng</h2>
<table>
<thead><tr><th>Tầng</th><th>Công năng</th></tr></thead>
<tbody>
<tr><td>Tầng 1</td><td>Shophouse khối đế (tòa A2: 43,8 – 87,3 m², giá khoảng 5,17 – 9,12 tỷ)</td></tr>
<tr><td>Tầng 2</td><td>Mặt bằng riêng từng tòa</td></tr>
<tr><td>Tầng 3</td><td>Tòa A2 có căn hộ sân vườn</td></tr>
<tr><td>Tầng 3A – 24</td><td>Tầng điển hình, 28 căn/tầng</td></tr>
<tr><td>Tầng 25</td><td>Penthouse, có gợi ý thiết kế duplex (tầng chính và tầng lửng)</td></tr>
</tbody>
</table>
<!--hh-dimg:1SQWmknWQHDgcDTxY7_qnSrGWoO1hba3K|Mặt bằng tầng 3A – 24 tòa A2 Cora Tower (bản vẽ chủ đầu tư)-->
<h2>Loại căn và giá</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá (giỏ hàng 11/2026)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>32,3 m²</td><td>Khoảng 2,42 – 2,74 tỷ</td></tr>
<tr><td>1PN+</td><td>53,2 – 54,2 m²</td><td>Khoảng 3,45 – 3,84 tỷ</td></tr>
<tr><td>2PN</td><td>Nhiều mẫu</td><td>Liên hệ</td></tr>
<tr><td>3PN</td><td>–</td><td>Liên hệ</td></tr>
</tbody>
</table>
<h3>Studio</h3>
<!--hh-dimg:1oulS9J32GRh9HDGp4mcH3_OhQejkCP1s|Layout căn Studio Cora Tower (bản vẽ chủ đầu tư)-->
<h3>1PN+1</h3>
<p>Có hai mẫu layout, thêm một phòng đa năng làm phòng làm việc hoặc phòng ngủ nhỏ.</p>
<!--hh-dimg:1jSiPWNw9rNp07uBEWBg-e7WhOoFtUYkd|Layout căn 1PN+1 Cora Tower – mẫu 1 (bản vẽ chủ đầu tư)-->
<h3>2PN và 3PN</h3>
<p>Căn 2PN có ba mẫu chung và một mẫu riêng tòa A2.</p>
<!--hh-dimg:12UPCJwFZ3Dql4m0rzc2DydnQizlt0CQz|Layout căn 2PN Cora Tower – mẫu 1 (bản vẽ chủ đầu tư)-->
<!--hh-dimg:1sjByRXmKwwTqQ07Eog-yykM0BoaM_cZo|Layout căn 3PN Cora Tower (bản vẽ chủ đầu tư)-->
<h2>Gợi ý chọn căn</h2>
<ul>
<li><strong>Cho thuê:</strong> studio tầng trung – cao, tổng tiền thấp.</li>
<li><strong>Gia đình trẻ:</strong> 1PN+1 hoặc 2PN.</li>
<li><strong>Muốn có sân vườn:</strong> căn tầng 3 tòa A2.</li>
<li><strong>Muốn không gian rộng:</strong> penthouse tầng 25, có thể làm duplex.</li>
</ul>
<p>Bàn giao dự kiến 30/07/2027, hoàn thiện trần, tường, sàn. Xem giá: <a href="/gia-cora-tower-da-nang-bao-nhieu/">giá Cora Tower</a>.</p>
{$cta('Cora Tower')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng Cora Tower: 2 tòa A1, A2, 28 căn/tầng',
			'desc'      => 'Mặt bằng Cora Tower – Sun NeO City: 2 tòa A1, A2 hai bên đường 29/3, 616 căn điển hình mỗi tòa, 28 căn/tầng; shophouse, sân vườn, penthouse.',
			'points'    => array(
				'2 tòa A1, A2 hai bên đường 29/3, gần vòng xoay Nguyễn Phước Lan',
				'Mỗi tòa 616 căn điển hình, 28 căn/tầng',
				'Studio 32,3 m², 1PN+ 53,2 – 54,2 m²; penthouse tầng 25',
			),
			'faq'       => array(
				array( 'Cora Tower có bao nhiêu căn?', 'Mỗi tòa A1, A2 có 616 căn hộ điển hình, 28 căn/tầng, chưa kể shophouse và penthouse.' ),
				array( 'Căn studio Cora Tower rộng bao nhiêu?', '32,3 m²; căn 1PN+ 53,2 – 54,2 m².' ),
				array( 'Cora Tower có penthouse không?', 'Có, ở tầng 25 mỗi tòa, chủ đầu tư có gợi ý thiết kế duplex.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Căn hộ hàng hiệu – Nobu ---------------- */
	$posts[] = array(
		'slug'     => 'can-ho-hang-hieu-la-gi-nobu-da-nang',
		'title'    => 'Căn hộ hàng hiệu là gì? Nobu Residences Đà Nẵng khác căn hộ cao cấp thường ở đâu',
		'excerpt'  => 'Căn hộ hàng hiệu (branded residences) là căn hộ gắn thương hiệu khách sạn, được vận hành theo chuẩn thương hiệu. Lấy Nobu Residences Đà Nẵng làm ví dụ: thương hiệu, dịch vụ, chi phí, cách khai thác và điều cần hỏi trước khi mua.',
		'keyword'  => 'căn hộ hàng hiệu',
		'keywords_extra' => array( 'căn hộ hàng hiệu là gì', 'branded residences Đà Nẵng', 'Nobu Residences là gì' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-20 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Nobu Residences Đà Nẵng', 'Căn hộ hàng hiệu' ),
		'image'    => 'plugin:img/nobu-da-nang/nobu-da-nang-noi-that-japandi.jpg',
		'image_alt' => 'Nội thất phong cách Japandi Nobu Residences Đà Nẵng (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Căn hộ hàng hiệu</strong> (branded residences) là căn hộ gắn tên một thương hiệu khách sạn, nhà hàng hoặc thời trang, được thiết kế, hoàn thiện và vận hành theo tiêu chuẩn của thương hiệu đó. Ở Đà Nẵng, ví dụ rõ nhất là <strong>Nobu Residences</strong>: 264 căn hộ do Nobu Hospitality vận hành, cùng tòa với khách sạn và nhà hàng Nobu. Khác căn hộ cao cấp thường ở dịch vụ, thương hiệu và chi phí vận hành cao hơn.</p>
{$sign}
</div>
<p>"Căn hộ hàng hiệu" xuất hiện ngày càng nhiều trong quảng cáo, nhưng không phải dự án nào gắn tên tiếng Anh cũng là hàng hiệu. Bài này giải thích khái niệm, lấy {$nobu} làm ví dụ cụ thể.</p>
<!--hh-featured-->
<h2>Thế nào là căn hộ hàng hiệu</h2>
<ul>
<li><strong>Có thương hiệu vận hành thật:</strong> chủ đầu tư ký hợp đồng thương hiệu với một tập đoàn khách sạn, thương hiệu đó tham gia thiết kế và vận hành.</li>
<li><strong>Dịch vụ như khách sạn:</strong> lễ tân, dọn phòng, nhà hàng, hồ bơi, spa dùng chung với khối khách sạn.</li>
<li><strong>Số căn ít:</strong> thường vài trăm căn, giữ tính riêng tư.</li>
<li><strong>Có thể cho thuê qua thương hiệu:</strong> chủ nhà giao căn cho đơn vị vận hành khai thác.</li>
</ul>
<h2>Nobu Residences Đà Nẵng là ví dụ</h2>
<table>
<tbody>
<tr><th>Thương hiệu</th><td>Nobu Hospitality – Robert De Niro, đầu bếp Nobu Matsuhisa, Meir Teper</td></tr>
<tr><th>Chủ đầu tư</th><td>VCRE (pháp nhân dự án Circle Point)</td></tr>
<tr><th>Quy mô</th><td>Tháp 43 tầng (khoảng 186 m): 264 căn hộ, khách sạn Nobu khoảng 200 phòng (gồm 18 suite)</td></tr>
<tr><th>Dịch vụ</th><td>Nhà hàng Nobu tầng 42, hồ bơi vô cực nước ấm tầng 18, spa, gym</td></tr>
<tr><th>Hoàn thiện</th><td>Nội thất tiêu chuẩn Nobu, phong cách Japandi; kiến trúc lấy cảm hứng quạt giấy Nhật Bản</td></tr>
<tr><th>Điểm nhấn</th><td>Dự án Nobu Residences đầu tiên tại Đông Nam Á</td></tr>
</tbody>
</table>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-nha-hang-nobu.jpg|Nhà hàng Nobu (phối cảnh)-->
<h2>Khác căn hộ cao cấp thường ở đâu</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Căn hộ hàng hiệu</th><th>Căn hộ cao cấp thường</th></tr></thead>
<tbody>
<tr><td>Vận hành</td><td>Thương hiệu khách sạn</td><td>Ban quản lý tòa nhà</td></tr>
<tr><td>Dịch vụ</td><td>Như khách sạn (dọn phòng, nhà hàng…)</td><td>Tiện ích chung cơ bản</td></tr>
<tr><td>Phí hằng tháng</td><td>Cao hơn (gồm dịch vụ thương hiệu)</td><td>Phí quản lý thông thường</td></tr>
<tr><td>Cho thuê</td><td>Có thể giao thương hiệu khai thác</td><td>Thường tự cho thuê</td></tr>
<tr><td>Giá</td><td>Cao hơn mặt bằng khu vực</td><td>Theo mặt bằng khu vực</td></tr>
</tbody>
</table>
<h2>Cần hỏi gì trước khi mua</h2>
<ol>
<li><strong>Thời hạn sở hữu:</strong> với Nobu, các nguồn chưa thống nhất (lâu dài cho người Việt hay đến 2060 theo đất thương mại dịch vụ) – đối chiếu hợp đồng.</li>
<li><strong>Phí dịch vụ, phí thương hiệu</strong> mỗi tháng và cách tăng theo năm.</li>
<li><strong>Chương trình cho thuê:</strong> tỷ lệ chia doanh thu, số đêm chủ nhà được ở, mức lợi nhuận một số nơi nêu (khoảng 6%/năm) có điều kiện gì.</li>
<li><strong>Thời hạn hợp đồng thương hiệu</strong> và điều gì xảy ra khi hết hạn.</li>
</ol>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-can-dual-key.jpg|Không gian căn hộ Dual-Key Nobu Đà Nẵng (phối cảnh nội thất)-->
<p>Xem thêm: <a href="/gia-nobu-residences-da-nang-bao-nhieu/">giá Nobu Residences</a>, <a href="/nobu-residences-hay-the-legend-can-ho-cao-cap-da-nang/">Nobu hay The Legend</a>.</p>
{$cta('Nobu Residences Đà Nẵng')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ hàng hiệu là gì? Ví dụ Nobu Đà Nẵng',
			'desc'      => 'Căn hộ hàng hiệu là căn hộ gắn thương hiệu khách sạn, vận hành theo chuẩn thương hiệu. Ví dụ Nobu Residences Đà Nẵng: 264 căn, Nobu vận hành.',
			'points'    => array(
				'Căn hộ hàng hiệu: thương hiệu khách sạn tham gia thiết kế và vận hành',
				'Nobu Residences Đà Nẵng: 264 căn, cùng tòa khách sạn và nhà hàng Nobu',
				'Hỏi rõ phí dịch vụ, chương trình cho thuê, thời hạn sở hữu',
			),
			'faq'       => array(
				array( 'Căn hộ hàng hiệu là gì?', 'Là căn hộ gắn thương hiệu một tập đoàn khách sạn (hoặc thương hiệu khác), được thiết kế, hoàn thiện và vận hành theo tiêu chuẩn của thương hiệu đó, thường có dịch vụ như khách sạn.' ),
				array( 'Đà Nẵng có căn hộ hàng hiệu nào?', 'Ví dụ tiêu biểu là Nobu Residences Đà Nẵng – 264 căn hộ do Nobu Hospitality vận hành, dự án Nobu Residences đầu tiên tại Đông Nam Á.' ),
				array( 'Mua căn hộ hàng hiệu cần lưu ý gì?', 'Hỏi rõ thời hạn sở hữu, phí dịch vụ và phí thương hiệu hằng tháng, điều kiện chương trình cho thuê và thời hạn hợp đồng thương hiệu.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- FourS – Mặt bằng ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-can-ho-fours-tower',
		'title'    => 'Mặt bằng FourS Tower: 4 tháp 20 tầng, 2.394 căn – mặt bằng tầng và layout tòa F2',
		'excerpt'  => 'Mặt bằng FourS Tower (Sun Riverpolis, Ngũ Hành Sơn): 4 tháp Mai – Trúc – Cúc – Tùng cao 20 tầng, 2.394 căn studio đến 3PN; tầng 1 thương mại, tầng 2 tiện ích; mặt bằng tầng và layout tòa F2, diện tích từng loại căn.',
		'keyword'  => 'mặt bằng FourS Tower',
		'keywords_extra' => array( 'layout FourS Tower', 'mặt bằng tòa F2 FourS', 'FourS Tower có bao nhiêu căn' ),
		'project'  => 'fours-tower',
		'schedule' => '2026-11-21 09:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'FourS Tower', 'Sun Riverpolis', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/fours-tower/fours-tower-tong-mat-bang-nga-tu-nguyen-phuoc-lan-minh-mang.jpg',
		'image_alt' => 'Tổng mặt bằng FourS Tower ở ngã tư Nguyễn Phước Lan – Minh Mạng (tài liệu chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mặt bằng FourS Tower:</strong> 4 tháp Mai (F2), Trúc (F3), Cúc (F5), Tùng (F1) cao 20 tầng, 2 tầng hầm, tổng khoảng <strong>2.394 căn</strong> từ studio đến 3PN, tại ngã tư Nguyễn Phước Lan – Minh Mạng (Sun Riverpolis). Tầng 1 thương mại, tầng 2 tiện ích (hồ bơi bốn mùa, gym, spa, khu trẻ em). Diện tích tham khảo: studio 30,5 – 34,9 m², 1PN 46,7 m², 1PN+ 45,2 – 53,8 m², 2PN 63,8 – 73,1 m², 3PN 92,8 – 93,2 m².</p>
{$sign}
</div>
<p>Bài này tổng hợp <strong>mặt bằng {$fours}</strong>: vị trí 4 tháp, bố trí theo tầng (lấy tòa F2 – Tháp Mai làm ví dụ vì có bộ mặt bằng đầy đủ nhất) và layout từng loại căn.</p>
<!--hh-featured-->
<h2>Mặt bằng FourS Tower: 4 tháp và tình trạng bán</h2>
<table>
<thead><tr><th>Tháp</th><th>Tên</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>F1</td><td>Tháp Tùng (Mùa Đông)</td><td>Đang bán (từ 3/2026)</td></tr>
<tr><td>F2</td><td>Tháp Mai (Mùa Xuân)</td><td>Đang bán (ra mắt 26/9/2026)</td></tr>
<tr><td>F3</td><td>Tháp Trúc (Mùa Hạ)</td><td>Chưa công bố mở bán</td></tr>
<tr><td>F5</td><td>Tháp Cúc (Mùa Thu)</td><td>Đang bán (từ 3/2026)</td></tr>
</tbody>
</table>
<h2>Bố trí theo tầng (tòa F2)</h2>
<ul>
<li><strong>Tầng 1:</strong> thương mại, sảnh.</li>
<li><strong>Tầng 2:</strong> tiện ích trọn tầng.</li>
<li><strong>Tầng 3, 3A, 5, 6, 7:</strong> mỗi tầng một mặt bằng riêng.</li>
<li><strong>Tầng 8 – 19:</strong> tầng điển hình dùng chung một mặt bằng.</li>
</ul>
<!--hh-img:img/fours-tower/fours-tower-f2-mat-bang-tang-8-19.jpg|Mặt bằng tầng 8 – 19 tòa F2 FourS Tower (tài liệu chủ đầu tư)-->
<h2>Diện tích từng loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích (tham khảo F1, F5)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>30,5 m² (F1), 34,9 m² (F5)</td></tr>
<tr><td>1PN</td><td>46,7 m² (F5)</td></tr>
<tr><td>1PN+ / 1PN+1</td><td>45,2 – 53,8 m²</td></tr>
<tr><td>2PN</td><td>63,8 – 64,9 m² (F1), 73,1 m² (F5)</td></tr>
<tr><td>3PN</td><td>92,8 – 93,2 m² (F5)</td></tr>
</tbody>
</table>
<h2>Layout tòa F2</h2>
<h3>Studio</h3>
<!--hh-img:img/fours-tower/fours-tower-f2-layout-studio.jpg|Layout căn studio tòa F2 FourS Tower (tài liệu chủ đầu tư)-->
<h3>1PN+</h3>
<!--hh-img:img/fours-tower/fours-tower-f2-layout-1pn-plus.jpg|Layout căn 1PN+ tòa F2 FourS Tower (tài liệu chủ đầu tư)-->
<h3>2PN</h3>
<p>Tòa F2 có mẫu 2PN 2 vệ sinh và mẫu 2PN 1 vệ sinh.</p>
<!--hh-img:img/fours-tower/fours-tower-f2-layout-2pn.jpg|Layout căn 2PN tòa F2 FourS Tower (tài liệu chủ đầu tư)-->
<h3>3PN</h3>
<!--hh-img:img/fours-tower/fours-tower-f2-layout-3pn.jpg|Layout căn 3PN tòa F2 FourS Tower (tài liệu chủ đầu tư)-->
<h2>Bàn giao</h2>
<p>Hoàn thiện cơ bản: trần thạch cao, sàn gạch hoặc gỗ công nghiệp phòng ngủ, cửa chính gỗ chống cháy, cửa nhôm Xingfa kính dán an toàn. Khách tự trang bị tủ bếp, thiết bị bếp, thiết bị vệ sinh, bình nóng lạnh. Nhận nhà dự kiến: F1, F5 ngày 31/3/2028; F2 ngày 31/5/2028 (khi đã thanh toán 70%).</p>
<p>Xem giá và chính sách tại trang {$fours}.</p>
{$cta('FourS Tower')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng FourS Tower: 4 tháp, 2.394 căn',
			'desc'      => 'Mặt bằng FourS Tower: 4 tháp Mai – Trúc – Cúc – Tùng 20 tầng, 2.394 căn studio đến 3PN; tầng 1 thương mại, tầng 2 tiện ích; mặt bằng tầng, layout tòa F2.',
			'points'    => array(
				'4 tháp 20 tầng, 2 tầng hầm, 2.394 căn',
				'Studio 30,5 – 34,9 m² đến 3PN 92,8 – 93,2 m²',
				'Tòa F2: tầng 8 – 19 dùng chung mặt bằng điển hình',
			),
			'faq'       => array(
				array( 'FourS Tower có bao nhiêu căn?', '2.394 căn trong 4 tháp Mai (F2), Trúc (F3), Cúc (F5), Tùng (F1), mỗi tháp 20 tầng.' ),
				array( 'Diện tích căn hộ FourS Tower bao nhiêu?', 'Tham khảo tòa F1, F5: studio 30,5 – 34,9 m², 1PN 46,7 m², 1PN+ 45,2 – 53,8 m², 2PN 63,8 – 73,1 m², 3PN 92,8 – 93,2 m².' ),
				array( 'FourS Tower bàn giao thế nào?', 'Hoàn thiện cơ bản; khách tự trang bị bếp, thiết bị vệ sinh, nội thất rời. Nhận nhà khi đã thanh toán 70%.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Sun Saphia – 1PN+ ---------------- */
	$posts[] = array(
		'slug'     => 'can-1pn-plus-sun-saphia-residence-49-51m2',
		'title'    => 'Căn 1PN+ Sun Saphia Residence 49 – 51 m²: chỉ 108 căn, bố trí ra sao, ai nên mua',
		'excerpt'  => 'Căn 1PN+ Sun Saphia Residence: 108 căn, 49 – 51 m² thông thủy, 4 căn mỗi sàn từ tầng 3A đến 28; một phòng ngủ cộng phòng đa năng. Bố trí, giá ước tính, hợp ở hay cho thuê dài hạn.',
		'keyword'  => '1PN+ Sun Saphia',
		'keywords_extra' => array( 'căn 1 phòng ngủ Sun Saphia', 'Sun Saphia 1PN+1', 'căn hộ 50m2 Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-21 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Mặt bằng căn hộ' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-cdt-khoi-de-pho-bien.jpg',
		'image_alt' => 'Khối đế và phố biển Sun Saphia Residence (ảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Căn 1PN+ Sun Saphia Residence</strong> rộng <strong>49 – 51 m²</strong> thông thủy, gồm một phòng ngủ và một phòng đa năng. Cả tòa chỉ có <strong>108 căn 1PN+</strong> (so với 513 studio), mỗi sàn điển hình từ tầng 3A đến 28 có 4 căn. Chủ đầu tư chưa công bố giá 1PN+; Hoàng Hiệp ước tính khoảng 3,2 – 4,2 tỷ theo giá tin rao (chưa phải giá chính thức).</p>
{$sign}
</div>
<p>Phần lớn khách quan tâm {$saphia} hỏi về studio. Nhưng nếu mua để ở hoặc cho thuê dài hạn, căn 1PN+ là lựa chọn đáng xem vì số lượng ít và công năng linh hoạt hơn.</p>
<!--hh-featured-->
<h2>Thông tin căn 1PN+ Sun Saphia</h2>
<table>
<tbody>
<tr><th>Số căn</th><td>108 căn (khoảng 14% tổng 782 căn)</td></tr>
<tr><th>Diện tích</th><td>49 – 51 m² thông thủy</td></tr>
<tr><th>Mỗi sàn điển hình</th><td>4 căn (tầng 3A – 28: 19 studio, 4 căn 1PN+, 5 căn 2PN)</td></tr>
<tr><th>Công năng</th><td>1 phòng ngủ + 1 phòng đa năng (làm việc hoặc phòng ngủ nhỏ)</td></tr>
<tr><th>Chiều cao tầng</th><td>3,5 m</td></tr>
<tr><th>Thời hạn</th><td>50 năm kể từ 17/09/2026</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-layout-1pn-plus-51m2.jpg|Layout căn 1PN+ Sun Saphia Residence 51 m² (tài liệu chủ đầu tư)-->
<h2>Vì sao 1PN+ đáng chú ý</h2>
<ul>
<li><strong>Ít cạnh tranh:</strong> 108 căn so với 513 studio – khi cho thuê, ít căn cùng loại hơn.</li>
<li><strong>Linh hoạt:</strong> phòng đa năng làm phòng làm việc, phòng cho trẻ nhỏ hoặc khách.</li>
<li><strong>Hợp thuê dài hạn:</strong> vợ chồng trẻ, người làm việc từ xa, chuyên gia nước ngoài.</li>
</ul>
<h2>Giá ước tính</h2>
<p>Ngày 28/10/2026 chủ đầu tư mới đưa giá dự kiến cho studio tầng 15 (khoảng 2,13 – 2,85 tỷ, phương án có vay, chưa VAT và kinh phí bảo trì). Với căn 1PN+, Hoàng Hiệp ước tính khoảng 3,2 – 4,2 tỷ theo giá tin rao – giá chính thức có khi mở bán (sự kiện bán hàng dự kiến 05/12/2026). Xem <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia Residence</a>.</p>
<h2>Studio, 1PN+ hay 2PN</h2>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Diện tích</th><th>Hợp với</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>513</td><td>30 – 31 m²</td><td>Cho thuê ngắn ngày, người độc thân</td></tr>
<tr><td>1PN+</td><td>108</td><td>49 – 51 m²</td><td>Vợ chồng trẻ, thuê dài hạn, làm việc từ xa</td></tr>
<tr><td>2PN</td><td>133</td><td>60 – 70 m²</td><td>Gia đình nhỏ, nghỉ dưỡng</td></tr>
</tbody>
</table>
<p>Xem thêm: <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia</a>, <a href="/studio-sun-saphia-residence-30-m2-bo-tri-ai-nen-mua/">studio Sun Saphia 30 m²</a>.</p>
{$cta('căn 1PN+ Sun Saphia')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn 1PN+ Sun Saphia Residence 49 – 51 m²: 108 căn',
			'desc'      => 'Căn 1PN+ Sun Saphia Residence: 108 căn, 49 – 51 m², 4 căn mỗi sàn tầng 3A – 28, một phòng ngủ cộng phòng đa năng. Giá ước tính, hợp ở hay cho thuê dài hạn.',
			'points'    => array(
				'108 căn 1PN+ 49 – 51 m², 4 căn mỗi sàn điển hình',
				'1 phòng ngủ + phòng đa năng, trần cao 3,5 m',
				'Giá chưa công bố – ước tính 3,2 – 4,2 tỷ theo tin rao',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có bao nhiêu căn 1PN+?', '108 căn, diện tích 49 – 51 m² thông thủy; mỗi sàn điển hình từ tầng 3A đến 28 có 4 căn 1PN+.' ),
				array( 'Căn 1PN+ Sun Saphia giá bao nhiêu?', 'Chủ đầu tư chưa công bố. Hoàng Hiệp ước tính khoảng 3,2 – 4,2 tỷ theo giá tin rao; giá chính thức có khi mở bán.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Capital Square – Tiến độ ---------------- */
	$posts[] = array(
		'slug'     => 'tien-do-capital-square-da-nang',
		'title'    => 'Tiến độ Capital Square Đà Nẵng: Capital Square 3 thi công phần thân, bàn giao dự kiến 2027',
		'excerpt'  => 'Tiến độ xây dựng Capital Square Đà Nẵng qua ảnh flycam: khởi công Capital Square 3 tháng 3/2025, thi công tầng hầm 9/2025, khối đế và phần thân 5/2026, tòa S3, S4 thi công phần thân 9/2026; bàn giao dự kiến 2027.',
		'keyword'  => 'tiến độ Capital Square',
		'keywords_extra' => array( 'tiến độ Capital Square Đà Nẵng', 'Capital Square xây đến đâu', 'Capital Square bàn giao' ),
		'project'  => 'capital-square-da-nang',
		'schedule' => '2026-11-22 09:00',
		'category' => 'Dự án',
		'tags'     => array( 'Capital Square Đà Nẵng', 'Tiến độ dự án' ),
		'image'    => 'plugin:img/capital-square/capital-square-tien-do-5-2026-flycam-01.jpg',
		'image_alt' => 'Tiến độ thi công Capital Square tháng 5/2026 – ảnh flycam công trường bên sông Hàn',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Tiến độ Capital Square Đà Nẵng:</strong> Capital Square 3 khởi công tháng 3/2025. Tháng 9/2025 công trường thi công tầng hầm; tháng 5/2026 các khối đã lên phần đế, cẩu tháp hoạt động; tháng 9/2026 tòa S4 Hudson Place và S3 Broadway Place đang thi công phần thân. Bàn giao dự kiến quý I/2027 (toàn tổ hợp, có thể đến 2028 tùy tòa), riêng Hudson Place dự kiến quý III/2027.</p>
{$sign}
</div>
<p>Bài này tổng hợp tiến độ {$cs} qua ảnh flycam công trường của chủ đầu tư và các mốc đã công bố. Nhà thầu kết cấu, xây thô một số tòa (2.4, 2.6, MAT 5, MAT 6) là Delta Group.</p>
<!--hh-featured-->
<h2>Các mốc tiến độ Capital Square</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Tiến độ</th></tr></thead>
<tbody>
<tr><td>3/2025</td><td>Khởi công Capital Square 3</td></tr>
<tr><td>9/2025</td><td>Thi công tầng hầm (ảnh flycam)</td></tr>
<tr><td>5/2026</td><td>Các khối lên phần đế, nhiều cẩu tháp hoạt động (ảnh flycam)</td></tr>
<tr><td>9/2026</td><td>Tòa S4 Hudson Place và S3 Broadway Place thi công phần thân</td></tr>
<tr><td>Quý I/2027</td><td>Bàn giao dự kiến (toàn tổ hợp, có thể đến 2028 tùy tòa)</td></tr>
<tr><td>Quý III/2027</td><td>Hudson Place bàn giao dự kiến, bán hoàn thiện</td></tr>
</tbody>
</table>
<h2>Tháng 9/2025: thi công tầng hầm</h2>
<!--hh-img:img/capital-square/capital-square-tien-do-9-2025-flycam-01.jpg|Tiến độ Capital Square tháng 9/2025 – thi công tầng hầm (ảnh flycam)-->
<h2>Tháng 5/2026: lên phần đế</h2>
<p>Ảnh flycam cho thấy các khối căn hộ đã lên phần đế, lưới an toàn bao quanh, nhiều cẩu tháp hoạt động.</p>
<!--hh-img:img/capital-square/capital-square-tien-do-5-2026-flycam-05.jpg|Tiến độ thi công Capital Square tháng 5/2026 – các khối lên phần đế (ảnh flycam)-->
<h2>Tháng 9/2026: S3, S4 thi công phần thân</h2>
<!--hh-img:img/hudson-place/hudson-place-vi-tri-toa-s4-tien-do-thi-cong.jpg|Vị trí tòa S4 Hudson Place, S3 Broadway Place và tiến độ thi công (tài liệu chủ đầu tư)-->
<h2>Tình trạng pháp lý bán hàng</h2>
<ul>
<li>Capital Square 2: tòa 2.1 – 2.7 đã có văn bản đủ điều kiện bán.</li>
<li>Capital Square 3: khối MAT 5-6, MAT 7, MAT 8-9 đã có văn bản đủ điều kiện bán; khối LAT 4-5 đang cập nhật.</li>
</ul>
<p>Hoàng Hiệp cập nhật bài này khi có ảnh tiến độ mới. Xem giá: <a href="/bang-gia-capital-square-da-nang-theo-toa/">bảng giá Capital Square theo tòa</a>.</p>
{$cta('Capital Square')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiến độ Capital Square Đà Nẵng: bàn giao dự kiến 2027',
			'desc'      => 'Tiến độ Capital Square Đà Nẵng: khởi công 3/2025, tầng hầm 9/2025, phần đế 5/2026, tòa S3, S4 thi công phần thân 9/2026; bàn giao dự kiến 2027.',
			'points'    => array(
				'Khởi công Capital Square 3 tháng 3/2025',
				'9/2026: tòa S4 Hudson Place, S3 Broadway Place thi công phần thân',
				'Bàn giao dự kiến quý I/2027; Hudson Place quý III/2027',
			),
			'faq'       => array(
				array( 'Capital Square xây đến đâu rồi?', 'Tháng 9/2026, tòa S4 Hudson Place và S3 Broadway Place đang thi công phần thân; tháng 5/2026 các khối đã lên phần đế.' ),
				array( 'Capital Square khi nào bàn giao?', 'Toàn tổ hợp dự kiến quý I/2027 (có thể đến 2028 tùy tòa); Hudson Place dự kiến quý III/2027.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- The Legend – Có nên mua ---------------- */
	$posts[] = array(
		'slug'     => 'co-nen-mua-the-legend-da-nang-uu-nhuoc-diem',
		'title'    => 'Có nên mua The Legend Đà Nẵng? 5 ưu điểm, 4 điểm cần cân nhắc',
		'excerpt'  => 'Đánh giá The Legend Đà Nẵng (The Legend City) chân cầu Rồng: ưu điểm vị trí, sở hữu lâu dài, bàn giao cao cấp, ưu đãi; điểm cần cân nhắc về giá, thời gian chờ bàn giao, chung khu với khách sạn. Ai nên mua.',
		'keyword'  => 'có nên mua The Legend Đà Nẵng',
		'keywords_extra' => array( 'đánh giá The Legend Đà Nẵng', 'review The Legend City', 'The Legend ưu nhược điểm' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-22 14:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'The Legend Đà Nẵng', 'Review dự án' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-toan-canh-dem-trung-tam-da-nang.jpg',
		'image_alt' => 'The Legend về đêm giữa trung tâm Đà Nẵng, cầu Rồng rực sáng (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Có nên mua The Legend Đà Nẵng?</strong> Nên cân nhắc nếu anh chị cần <strong>căn hộ sở hữu lâu dài ngay trung tâm, bên sông Hàn</strong> và ngân sách từ khoảng 7,65 tỷ (1PN). Ưu điểm: vị trí chân cầu Rồng, sở hữu lâu dài, pháp lý đủ điều kiện bán, bàn giao hoàn thiện cao cấp, quà nội thất và chiết khấu đến 12%. Cần cân nhắc: giá cao hơn mặt bằng Sơn Trà, bàn giao dự kiến 31/3/2028, chung khu với khối khách sạn.</p>
{$sign}
</div>
<p>Dưới đây là đánh giá của Hoàng Hiệp về {$legend} dựa trên thông tin chủ đầu tư công bố, để anh chị tự đối chiếu với nhu cầu của mình.</p>
<!--hh-featured-->
<h2>5 ưu điểm</h2>
<ol>
<li><strong>Vị trí chân cầu Rồng,</strong> 4 mặt tiền Võ Văn Kiệt – Ngô Quyền – Mai Hắc Đế – Lý Nam Đế, khoảng 1 km ra biển Mỹ Khê.</li>
<li><strong>Sở hữu lâu dài</strong> – hiếm với căn hộ bên sông Hàn hiện nay.</li>
<li><strong>Pháp lý rõ:</strong> đất đấu giá có sổ (2020), quy hoạch 1/500 (2024), 800 căn đủ điều kiện bán (<a href="/phap-ly-the-legend-da-nang-so-huu-lau-dai/">chi tiết pháp lý</a>).</li>
<li><strong>Bàn giao hoàn thiện cao cấp,</strong> có smarthome; miễn phí quản lý 24 tháng.</li>
<li><strong>Ưu đãi lớn:</strong> quà nội thất 300 triệu – 1,8 tỷ trừ vào giá, chiết khấu thanh toán sớm đến 12%, vay 70% hỗ trợ lãi suất 0% trong 24 tháng.</li>
</ol>
<!--hh-img:img/the-legend/the-legend-da-nang-ban-cong-nhin-cau-rong-song-han.jpg|Ban công The Legend nhìn thẳng cầu Rồng và sông Hàn (phối cảnh)-->
<h2>4 điểm cần cân nhắc</h2>
<ol>
<li><strong>Giá cao:</strong> giỏ hàng khoảng 119 – 188 triệu/m²; căn 1PN từ khoảng 7,65 tỷ.</li>
<li><strong>Thời gian chờ:</strong> cất nóc dự kiến 31/12/2026, bàn giao dự kiến 31/3/2028.</li>
<li><strong>Chung khu với khách sạn:</strong> tháp khách sạn 25 tầng (444 phòng, căn hộ dịch vụ) cùng khối đế – đông khách hơn chung cư thuần ở.</li>
<li><strong>Chính sách theo đợt:</strong> chính sách đang dùng ban hành 17/7/2025, có thể đã điều chỉnh – hỏi bản mới nhất khi đặt căn.</li>
</ol>
<h2>Có nên mua The Legend Đà Nẵng: ai hợp</h2>
<ul>
<li><strong>Nên:</strong> gia đình muốn ở trung tâm lâu dài; người mua giữ tài sản để lại con cháu; khách cần căn hộ cao cấp sở hữu lâu dài bên sông.</li>
<li><strong>Cân nhắc:</strong> người mua để cho thuê ngắn ngày với ngân sách dưới 4 tỷ – xem các dự án như <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">Symphony 5</a>.</li>
</ul>
<p>So sánh với dự án hạng sang khác: <a href="/nobu-residences-hay-the-legend-can-ho-cao-cap-da-nang/">Nobu hay The Legend</a>.</p>
{$cta('The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Có nên mua The Legend Đà Nẵng? Ưu và nhược điểm',
			'desc'      => 'Có nên mua The Legend Đà Nẵng: ưu điểm chân cầu Rồng, sở hữu lâu dài, pháp lý rõ, ưu đãi đến 12%; cân nhắc giá cao, bàn giao dự kiến 3/2028.',
			'points'    => array(
				'Chân cầu Rồng, sở hữu lâu dài, 800 căn đủ điều kiện bán',
				'Quà nội thất đến 1,8 tỷ, chiết khấu đến 12%, vay 0% 24 tháng',
				'Giá từ khoảng 7,65 tỷ (1PN); bàn giao dự kiến 31/3/2028',
			),
			'faq'       => array(
				array( 'Có nên mua The Legend Đà Nẵng không?', 'Phù hợp nếu cần căn hộ sở hữu lâu dài ngay trung tâm bên sông Hàn và ngân sách từ khoảng 7,65 tỷ. Cần cân nhắc giá cao, bàn giao dự kiến 31/3/2028 và việc chung khu với khối khách sạn.' ),
				array( 'The Legend có ưu đãi gì?', 'Quà nội thất trừ vào giá 300 triệu – 1,8 tỷ, chiết khấu thanh toán sớm đến 12%, vay 70% hỗ trợ lãi suất 0% trong 24 tháng, miễn phí quản lý 24 tháng (chính sách 17/7/2025).' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Chi phí khi mua căn hộ mới ---------------- */
	$posts[] = array(
		'slug'     => 'chi-phi-khi-mua-can-ho-moi-ngoai-gia-ban',
		'title'    => 'Mua căn hộ mới cần trả những chi phí gì ngoài giá bán? 7 khoản người mua hay quên',
		'excerpt'  => 'Ngoài giá bán, mua căn hộ mới từ chủ đầu tư còn các khoản: VAT, kinh phí bảo trì 2%, lệ phí trước bạ 0,5% khi làm sổ, phí quản lý hằng tháng, chi phí hoàn thiện nội thất, lãi vay sau hỗ trợ và phí làm sổ. Cách đọc giá đã gồm gì.',
		'keyword'  => 'chi phí mua căn hộ mới',
		'keywords_extra' => array( 'chi phí mua căn hộ chung cư', 'phí bảo trì căn hộ 2%', 'mua căn hộ mới cần bao nhiêu tiền' ),
		'schedule' => '2026-11-23 09:00',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Kinh nghiệm mua nhà', 'Căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/fours-tower/fours-f2-can-ho-mau-3d-xem-truoc.jpg',
		'image_alt' => 'Căn hộ mẫu FourS Tower F2 (hình 3D chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mua căn hộ mới cần trả gì ngoài giá bán?</strong> Bảy khoản chi phí mua căn hộ mới thường gặp: (1) thuế VAT nếu giá chưa gồm; (2) <strong>kinh phí bảo trì 2%</strong>; (3) <strong>lệ phí trước bạ 0,5%</strong> khi làm giấy chứng nhận; (4) phí quản lý hằng tháng; (5) chi phí hoàn thiện, nội thất; (6) lãi vay sau thời gian hỗ trợ; (7) phí, lệ phí cấp giấy chứng nhận theo mức địa phương. Nhiều giỏ hàng ở Đà Nẵng đã gồm VAT và kinh phí bảo trì, nhưng không phải tất cả.</p>
{$sign}
</div>
<p>Khi so giá giữa các dự án, nhiều khách chỉ nhìn con số trên giỏ hàng. Thực tế, cùng con số nhưng một dự án đã gồm VAT và phí bảo trì, dự án khác chưa gồm, nên tổng tiền chênh nhau hàng trăm triệu. Bài này liệt kê các khoản cần cộng thêm.</p>
<!--hh-featured-->
<h2>7 khoản chi phí mua căn hộ mới ngoài giá bán</h2>
<table>
<thead><tr><th>Khoản</th><th>Mức thường gặp</th><th>Khi nào trả</th></tr></thead>
<tbody>
<tr><td>Thuế VAT</td><td>Tính trên giá căn (trừ tiền đất)</td><td>Theo các đợt thanh toán</td></tr>
<tr><td>Kinh phí bảo trì</td><td>2% giá bán</td><td>Thường khi nhận nhà</td></tr>
<tr><td>Lệ phí trước bạ</td><td>0,5% giá trị tính lệ phí</td><td>Khi làm giấy chứng nhận</td></tr>
<tr><td>Phí cấp giấy chứng nhận</td><td>Theo mức của địa phương</td><td>Khi làm giấy chứng nhận</td></tr>
<tr><td>Phí quản lý</td><td>Theo m²/tháng (nhiều dự án miễn 1 – 2 năm đầu)</td><td>Hằng tháng sau nhận nhà</td></tr>
<tr><td>Hoàn thiện, nội thất</td><td>Tùy mức bàn giao (thô, cơ bản, cao cấp)</td><td>Trước khi ở, cho thuê</td></tr>
<tr><td>Lãi vay</td><td>Theo ngân hàng sau thời gian hỗ trợ</td><td>Hằng tháng</td></tr>
</tbody>
</table>
<p><small>Mức thuế, phí theo quy định hiện hành và thông báo của cơ quan thuế; đối chiếu khi làm thủ tục.</small></p>
<h2>Đọc giỏ hàng: giá đã gồm gì</h2>
<table>
<thead><tr><th>Dự án</th><th>Giá trên giỏ hàng</th></tr></thead>
<tbody>
<tr><td>Symphony 5, Cora Tower, Capital Square, The Legend</td><td>Đã gồm VAT và kinh phí bảo trì</td></tr>
<tr><td>Sun Saphia Residence (giá dự kiến 28/10/2026)</td><td>Chưa gồm VAT và kinh phí bảo trì</td></tr>
</tbody>
</table>
<p>Ví dụ: hai căn cùng ghi 2,5 tỷ, căn chưa gồm VAT và phí bảo trì sẽ phải cộng thêm, nên tổng tiền cao hơn căn đã gồm.</p>
<h2>Chi phí hoàn thiện theo mức bàn giao</h2>
<ul>
<li><strong>Bàn giao thô</strong> (ví dụ Symphony 5): khách tự làm trần, sàn, tường; chủ đầu tư có gói hoàn thiện liền tường khoảng 9,5 – 11 triệu/m² tùy loại căn.</li>
<li><strong>Hoàn thiện cơ bản</strong> (ví dụ FourS Tower): có trần, sàn, cửa; khách tự lắp bếp, thiết bị vệ sinh, bình nóng lạnh, đồ rời.</li>
<li><strong>Hoàn thiện cao cấp</strong> (ví dụ The Legend): có sàn gỗ, thiết bị bếp, vệ sinh, smarthome; chủ yếu mua đồ rời.</li>
</ul>
<!--hh-img:img/fours-tower/fours-tower-f2-layout-2pn.jpg|Layout căn 2PN FourS Tower F2 – bàn giao hoàn thiện cơ bản (tài liệu chủ đầu tư)-->
<h2>Mẹo giảm chi phí</h2>
<ol>
<li>So tổng tiền sau chiết khấu, đã cộng VAT và phí bảo trì.</li>
<li>Tận dụng thời gian miễn phí quản lý, hỗ trợ lãi suất.</li>
<li>Hỏi gói nội thất hoặc quà nội thất trừ vào giá.</li>
</ol>
<p>Xem thêm: <a href="/can-ho-duoi-3-ty-da-nang-du-an-dang-ban/">căn hộ dưới 3 tỷ ở Đà Nẵng</a>.</p>
{$cta('căn hộ anh chị đang xem')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chi phí mua căn hộ mới: 7 khoản ngoài giá bán',
			'desc'      => 'Chi phí mua căn hộ mới ngoài giá bán: VAT, kinh phí bảo trì 2%, lệ phí trước bạ 0,5%, phí cấp sổ, phí quản lý, hoàn thiện nội thất, lãi vay.',
			'points'    => array(
				'Kinh phí bảo trì 2% giá bán; lệ phí trước bạ 0,5% khi làm sổ',
				'Kiểm tra giá giỏ hàng đã gồm VAT và phí bảo trì chưa',
				'Cộng chi phí hoàn thiện theo mức bàn giao',
			),
			'faq'       => array(
				array( 'Mua căn hộ chung cư phải đóng phí bảo trì bao nhiêu?', 'Kinh phí bảo trì phần sở hữu chung là 2% giá bán căn hộ, thường nộp khi nhận nhà.' ),
				array( 'Lệ phí trước bạ căn hộ bao nhiêu?', '0,5% giá trị tính lệ phí trước bạ, nộp khi làm giấy chứng nhận.' ),
				array( 'Giá căn hộ đã gồm VAT chưa?', 'Tùy dự án. Giỏ hàng Symphony 5, Cora Tower, Capital Square, The Legend đã gồm VAT và kinh phí bảo trì; giá dự kiến Sun Saphia Residence chưa gồm.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Hợp đồng căn hộ hình thành trong tương lai ---------------- */
	$posts[] = array(
		'slug'     => 'hop-dong-mua-can-ho-hinh-thanh-trong-tuong-lai-can-xem-gi',
		'title'    => 'Mua căn hộ hình thành trong tương lai: hợp đồng cần xem gì, đóng tiền tối đa bao nhiêu?',
		'excerpt'  => 'Mua căn hộ chưa xây xong (nhà ở hình thành trong tương lai): đặt cọc, văn bản đủ điều kiện bán, bảo lãnh ngân hàng, tỷ lệ thanh toán tối đa trước bàn giao và trước khi có sổ, các điều khoản hợp đồng cần đọc kỹ.',
		'keyword'  => 'mua căn hộ hình thành trong tương lai',
		'keywords_extra' => array( 'hợp đồng mua bán căn hộ', 'nhà ở hình thành trong tương lai', 'bảo lãnh ngân hàng mua căn hộ' ),
		'schedule' => '2026-11-23 14:00',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Kinh nghiệm mua nhà', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/fours-tower/fours-tower-f2-kien-truc-toa-f2.jpg',
		'image_alt' => 'Kiến trúc tòa F2 FourS Tower (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Mua căn hộ hình thành trong tương lai cần kiểm tra:</strong> (1) văn bản của Sở Xây dựng xác nhận dự án <strong>đủ điều kiện bán</strong>; (2) <strong>bảo lãnh ngân hàng</strong> cho nghĩa vụ bàn giao; (3) tỷ lệ thanh toán – theo Luật Kinh doanh bất động sản 2023, lần đầu không quá 30% giá trị hợp đồng (gồm tiền cọc), trước bàn giao không quá 70%, trước khi có giấy chứng nhận không quá 95%; (4) điều khoản bàn giao, phạt chậm, diện tích, thời hạn cấp sổ.</p>
{$sign}
</div>
<p>Phần lớn căn hộ mới ở Đà Nẵng hiện bán khi đang xây – gọi là nhà ở hình thành trong tương lai. Bài này tóm tắt những điểm người mua cần kiểm tra để giảm rủi ro, kèm ví dụ từ các dự án đang bán.</p>
<!--hh-featured-->
<h2>Trước khi đặt cọc mua căn hộ hình thành trong tương lai</h2>
<ul>
<li><strong>Đủ điều kiện bán:</strong> hỏi văn bản của Sở Xây dựng (ví dụ: Spana Tower có xác nhận ngày 05/5/2026; The Legend có thông báo 800 căn đủ điều kiện bán).</li>
<li><strong>Tiền đặt cọc:</strong> theo luật, chủ đầu tư chỉ được thu tiền cọc khi dự án đủ điều kiện, và không quá 5% giá bán. Ở các dự án Sun Group hiện nay cọc 100 – 300 triệu/căn tùy loại.</li>
<li><strong>Thỏa thuận giữ chỗ / nguyện vọng:</strong> đọc kỹ điều kiện hoàn tiền nếu không ký hợp đồng.</li>
</ul>
<h2>Tỷ lệ thanh toán tối đa</h2>
<table>
<thead><tr><th>Giai đoạn</th><th>Tối đa (Luật Kinh doanh bất động sản 2023)</th></tr></thead>
<tbody>
<tr><td>Lần đầu (gồm tiền cọc)</td><td>30% giá trị hợp đồng</td></tr>
<tr><td>Trước khi bàn giao</td><td>70% giá trị hợp đồng</td></tr>
<tr><td>Trước khi có giấy chứng nhận</td><td>95% – 5% còn lại trả khi nhận sổ</td></tr>
</tbody>
</table>
<p>Ví dụ: FourS Tower F2 – cọc 100 triệu, đợt 2 lên 15%, mỗi 3 tháng 10%, nhận nhà khi đã trả 70%, 5% cuối khi nhận giấy chứng nhận. Một số dự án cho thanh toán sớm 95% để nhận chiết khấu – đó là lựa chọn của khách, không bắt buộc.</p>
<!--hh-img:img/fours-tower/fours-tower-f2-hai-cum-thap-truc-duong.jpg|Hai cụm tháp FourS Tower nhìn từ trục đường (phối cảnh chủ đầu tư)-->
<h2>Bảo lãnh ngân hàng</h2>
<p>Chủ đầu tư phải có ngân hàng bảo lãnh nghĩa vụ bàn giao; nếu chủ đầu tư không bàn giao đúng cam kết, ngân hàng hoàn số tiền khách đã trả theo hợp đồng bảo lãnh. Một số dự án chiết khấu thêm (ví dụ 1%) nếu khách không lấy thư bảo lãnh – anh chị nên cân nhắc kỹ trước khi từ chối.</p>
<h2>Điều khoản hợp đồng cần đọc</h2>
<ol>
<li><strong>Diện tích:</strong> thông thủy hay tim tường; mức chênh cho phép và cách tính lại tiền.</li>
<li><strong>Thời hạn bàn giao</strong> và mức phạt khi chậm.</li>
<li><strong>Danh mục vật liệu bàn giao</strong> đính kèm.</li>
<li><strong>Thời hạn sở hữu:</strong> lâu dài hay 50 năm (đất thương mại dịch vụ).</li>
<li><strong>Thời hạn cấp giấy chứng nhận</strong> và trách nhiệm làm thủ tục.</li>
<li><strong>Chuyển nhượng hợp đồng</strong> trước khi nhận nhà: điều kiện và phí.</li>
<li><strong>Phí quản lý</strong> dự kiến và thời gian miễn phí.</li>
</ol>
<p><small>Bài viết tóm tắt nguyên tắc chung; quy định chi tiết theo Luật Kinh doanh bất động sản 2023 và văn bản hướng dẫn – anh chị nên đối chiếu khi ký.</small></p>
<p>Xem thêm: <a href="/chi-phi-khi-mua-can-ho-moi-ngoai-gia-ban/">chi phí khi mua căn hộ mới</a>, <a href="/giu-cho-booking-can-ho-moi-da-nang-can-biet/">giữ chỗ căn hộ mới cần biết gì</a>.</p>
{$cta('dự án anh chị đang xem')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua căn hộ hình thành trong tương lai: cần xem gì?',
			'desc'      => 'Mua căn hộ hình thành trong tương lai: kiểm tra văn bản đủ điều kiện bán, bảo lãnh ngân hàng, thanh toán tối đa 30% – 70% – 95%, điều khoản hợp đồng.',
			'points'    => array(
				'Kiểm tra văn bản đủ điều kiện bán và bảo lãnh ngân hàng',
				'Thanh toán tối đa: lần đầu 30%, trước bàn giao 70%, trước khi có sổ 95%',
				'Đọc kỹ diện tích, phạt chậm bàn giao, thời hạn sở hữu, cấp sổ',
			),
			'faq'       => array(
				array( 'Mua căn hộ hình thành trong tương lai đóng tối đa bao nhiêu trước bàn giao?', 'Theo Luật Kinh doanh bất động sản 2023: lần đầu không quá 30% giá trị hợp đồng (gồm tiền cọc), trước bàn giao không quá 70%, trước khi có giấy chứng nhận không quá 95%.' ),
				array( 'Có cần bảo lãnh ngân hàng khi mua căn hộ chưa xây xong không?', 'Có. Chủ đầu tư phải có ngân hàng bảo lãnh nghĩa vụ bàn giao; người mua nên giữ thư bảo lãnh để được hoàn tiền nếu chủ đầu tư không bàn giao đúng cam kết.' ),
				array( 'Tiền đặt cọc mua căn hộ hình thành trong tương lai tối đa bao nhiêu?', 'Theo luật, chủ đầu tư chỉ được nhận đặt cọc khi dự án đủ điều kiện bán và không quá 5% giá bán.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
