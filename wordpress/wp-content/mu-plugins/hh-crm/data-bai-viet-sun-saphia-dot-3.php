<?php
/**
 * Loạt bài Sun Saphia Residence đợt 3 (30/10 – 05/11/2026, 08:00 mỗi ngày): studio, tiện ích, chi phí ngoài giá bán,
 * vay trả góp, khách du lịch và nhu cầu thuê, pháp lý cho thuê ngắn ngày, thị trường căn hộ quý III/2026.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Số liệu dự án: tài liệu chủ đầu tư 10/2026. Số liệu thị trường: báo chí trích DKRA, UBND TP Đà Nẵng (ghi nguồn từng bài).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_3' );
function hh_posts_sun_saphia_dot_3( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Cần bảng giá, mặt bằng tầng và chính sách ' . $saphia . ' khi chủ đầu tư công bố, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi kèm bảng tính chi phí, dòng tiền theo đúng căn anh chị quan tâm.</p>';

	/* ---------------- 30/10 – Studio ---------------- */
	$posts[] = array(
		'slug'     => 'studio-sun-saphia-residence-30-m2-bo-tri-ai-nen-mua',
		'title'    => 'Studio Sun Saphia Residence 30 m²: bố trí, công năng và ai nên mua',
		'excerpt'  => 'Studio chiếm 513/782 căn Sun Saphia Residence: thông thủy 30 – 31 m², mặt tiền 3,8 m, trần 3,5 m, 19 căn mỗi sàn. Bố trí thế nào, hợp với ai, chọn căn ra sao.',
		'keyword'  => 'studio Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn studio Sun Saphia', 'studio ven biển Đà Nẵng', 'căn hộ 30 m² Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-30 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ studio' ),
		'image'    => 'plugin:img/tin-tuc/studio-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Studio Sun Saphia Residence</strong> là sản phẩm chủ lực của dự án: <strong>513 trên 782 căn</strong> (khoảng 66%) là studio. Bài này tóm tắt studio được bố trí ra sao theo tài liệu chủ đầu tư tháng 10/2026, studio hợp với ai và cách chọn căn.</p>
<!--hh-featured-->
<h2>Thông số căn studio</h2>
<table>
<tbody>
<tr><th>Diện tích</th><td>Thông thủy 30 – 31 m²; căn studio ở góc khoảng 40 m²</td></tr>
<tr><th>Kích thước</th><td>Mặt tiền khoảng 3,8 m, sâu khoảng 9 m</td></tr>
<tr><th>Chiều cao tầng</th><td>3,5 m (tầng căn hộ)</td></tr>
<tr><th>Số căn mỗi sàn</th><td>19 studio / 28 căn ở tầng điển hình 3A – 28</td></tr>
<tr><th>Bàn giao</th><td>Hoàn thiện cơ bản, dự kiến 11/2028</td></tr>
</tbody>
</table>
<h2>Bố trí bên trong</h2>
<p>Căn mặt tiền hẹp, sâu nên thường xếp theo một trục: cửa vào – bếp và vệ sinh – khu ngủ, sinh hoạt sát cửa kính. Trần 3,5 m giúp căn nhỏ thoáng hơn căn hộ thông thường, có chỗ cho kệ cao hoặc giường gác thấp. Vì bàn giao hoàn thiện cơ bản, chủ nhà tự chọn nội thất theo mục đích ở hay cho thuê.</p>
<p>Xem toàn bộ loại căn và cách chia sàn ở bài <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence</a>.</p>
<h2>Studio hợp với ai?</h2>
<ul>
<li><strong>Mua cho thuê</strong>: tổng tiền mỗi căn thấp nhất dự án, dễ cho khách du lịch, chuyên gia, người làm việc ngắn hạn thuê.</li>
<li><strong>Căn nghỉ dưỡng thứ hai</strong> cho gia đình ở Hà Nội, TP.HCM ra biển vài lần mỗi năm, lúc không ở thì cho thuê.</li>
<li><strong>Người trẻ ở một mình</strong> hoặc cặp đôi chưa có con, cần chỗ ở gần biển và đường sắt đô thị dự kiến (khoảng 500 m tới ga LRT 09).</li>
</ul>
<p>Studio <strong>không hợp</strong> gia đình có trẻ nhỏ ở lâu dài – nhóm này nên xem căn 1PN+ hoặc 2PN.</p>
<h2>Chọn căn studio thế nào?</h2>
<ol>
<li><strong>Hướng</strong>: dãy phía Đông nhìn biển Mỹ Khê – Sơn Thủy thường giá cao và dễ cho thuê hơn; dãy nhìn núi, sông hợp người ở lâu.</li>
<li><strong>Tầng</strong>: tầng cao hơn nhìn rộng, ít ồn từ đường Trường Sa – Võ Nguyên Giáp.</li>
<li><strong>Vị trí trên sàn</strong>: căn góc khoảng 40 m² rộng hơn hẳn, nên hỏi giá riêng; căn gần thang máy, phòng rác cần xem kỹ.</li>
</ol>
<p>So sánh giá mua, giá thuê studio ở các dự án ven biển khác: xem <a href="/studio-ven-bien-da-nang-gia-mua-gia-thue-2026/">studio ven biển Đà Nẵng: giá mua, giá thuê 2026</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Studio Sun Saphia Residence 30 m²: bố trí, ai nên mua',
			'desc'      => 'Studio Sun Saphia Residence: 513/782 căn, thông thủy 30 – 31 m², mặt tiền 3,8 m, trần 3,5 m. Bố trí bên trong, hợp với ai và 3 điểm cần xem khi chọn căn.',
			'points'    => array(
				'513 studio trên tổng 782 căn (khoảng 66%)',
				'Thông thủy 30 – 31 m², mặt tiền 3,8 m, sâu 9 m, trần 3,5 m',
				'Hợp mua cho thuê, căn nghỉ dưỡng thứ hai, người ở một mình',
			),
			'faq'       => array(
				array( 'Studio Sun Saphia Residence rộng bao nhiêu?', 'Theo tài liệu chủ đầu tư 10/2026, studio thông thủy 30 – 31 m², mặt tiền khoảng 3,8 m, sâu khoảng 9 m; căn studio góc khoảng 40 m².' ),
				array( 'Sun Saphia Residence có bao nhiêu căn studio?', '513 studio trên tổng 782 căn; tầng điển hình 3A – 28 có 19 studio trong 28 căn mỗi sàn.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 31/10 – Tiện ích ---------------- */
	$posts[] = array(
		'slug'     => 'tien-ich-sun-saphia-residence-noi-khu-xung-quanh',
		'title'    => 'Tiện ích Sun Saphia Residence: trong tòa và quanh dự án ven biển Sơn Thủy',
		'excerpt'  => 'Tiện ích Sun Saphia Residence gồm bể bơi view biển, gym, yoga, khối đế thương mại, 2 tầng hầm; quanh dự án có chuỗi công viên bãi tắm, ga LRT 09 dự kiến, danh thắng Ngũ Hành Sơn.',
		'keyword'  => 'tiện ích Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'tiện ích căn hộ Sun Saphia', 'bể bơi Sun Saphia', 'căn hộ gần biển Sơn Thủy' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-31 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Tiện ích dự án' ),
		'image'    => 'plugin:img/tin-tuc/tien-ich-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Tiện ích Sun Saphia Residence</strong> chia làm hai lớp: tiện ích trong tòa căn hộ 30 tầng và tiện ích công cộng quanh khu bãi tắm Sơn Thủy. Dưới đây là danh sách theo tài liệu chủ đầu tư tháng 10/2026 và các dự án hạ tầng thành phố đã công bố.</p>
<!--hh-featured-->
<h2>Tiện ích trong tòa</h2>
<ul>
<li><strong>Bể bơi view biển</strong>, khu yoga.</li>
<li><strong>Phòng gym, pilates</strong>.</li>
<li><strong>Khối đế thương mại</strong> phục vụ cư dân và khách thuê.</li>
<li><strong>2 tầng hầm</strong> đỗ xe.</li>
</ul>
<p>Chủ đầu tư chưa công bố chi tiết diện tích từng tiện ích và phí sử dụng. Khi nhận hồ sơ, nên hỏi tiện ích nào miễn phí, tiện ích nào thu phí riêng, giờ mở cửa và quy định cho khách thuê ngắn ngày.</p>
<h2>Tiện ích quanh dự án</h2>
<table>
<thead><tr><th>Tiện ích</th><th>Khoảng cách</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Công viên bãi tắm ven biển</td><td>Đối diện</td><td>Khoảng 2,45 ha, thành phố đang đầu tư</td></tr>
<tr><td>Bãi tắm Sơn Thủy</td><td>Đi bộ</td><td>Thể thao biển: kayak, SUP, dù lượn, jetski</td></tr>
<tr><td>Ga LRT 09</td><td>Khoảng 500 m</td><td>Đường sắt đô thị sân bay – biển (dự kiến)</td></tr>
<tr><td>Sun Galaxy, Đà Nẵng Downtown</td><td>Khoảng 4 km</td><td>Theo bản đồ kết nối của chủ đầu tư</td></tr>
</tbody>
</table>
<p>Dọc tuyến biển có chuỗi 3 công viên bãi tắm: Sơn Thủy, công viên đối diện dự án và công viên bãi tắm Huyền Trân Công Chúa. Thông tin tuyến đường sắt đô thị: xem bài <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">đường sắt đô thị sân bay – Mỹ Khê – Hội An</a>.</p>
<h2>Tiện ích nào ảnh hưởng giá thuê?</h2>
<ul>
<li><strong>Bể bơi, view biển</strong>: khách du lịch thường lọc theo hai tiêu chí này trên các ứng dụng đặt phòng.</li>
<li><strong>Bãi tắm đi bộ được</strong>: lợi thế so với căn hộ trong phố phải đi xe ra biển.</li>
<li><strong>Kết nối giao thông</strong>: ga LRT khi vận hành giúp đi sân bay, trung tâm dễ hơn – nhưng chưa có mốc khai thác chính thức, không nên tính vào giá thuê ngay.</li>
</ul>
<p>Xem thêm vị trí chi tiết ở bài <a href="/sun-saphia-residence-o-dau-vi-tri/">Sun Saphia Residence ở đâu?</a></p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiện ích Sun Saphia Residence: trong tòa và xung quanh',
			'desc'      => 'Tiện ích Sun Saphia Residence: bể bơi view biển, gym, yoga, thương mại, 2 tầng hầm; đối diện công viên bãi tắm 2,45 ha, cách ga LRT 09 khoảng 500 m.',
			'points'    => array(
				'Trong tòa: bể bơi view biển, yoga, gym, pilates, khối đế thương mại, 2 tầng hầm',
				'Đối diện công viên bãi tắm khoảng 2,45 ha',
				'Khoảng 500 m tới ga LRT 09 (dự kiến)',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có bể bơi không?', 'Có. Theo tài liệu chủ đầu tư 10/2026, tòa có bể bơi view biển, khu yoga, gym, pilates và khối đế thương mại.' ),
				array( 'Từ Sun Saphia Residence ra biển bao xa?', 'Dự án nằm trên đường Trường Sa, đối diện công viên bãi tắm ven biển; bãi tắm Sơn Thủy đi bộ được.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 01/11 – Chi phí ngoài giá bán ---------------- */
	$posts[] = array(
		'slug'     => 'chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban',
		'title'    => 'Mua Sun Saphia Residence cần thêm bao nhiêu ngoài giá bán? VAT, phí bảo trì, lệ phí trước bạ',
		'excerpt'  => 'Ngoài giá bán, người mua Sun Saphia Residence cần tính VAT, kinh phí bảo trì 2%, lệ phí trước bạ 0,5%, nội thất và phí quản lý. Bảng ước tính cho studio giá tham khảo 3 tỷ.',
		'keyword'  => 'chi phí mua căn hộ Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'phí bảo trì căn hộ 2%', 'lệ phí trước bạ căn hộ', 'chi phí mua căn hộ Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-01 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Kinh nghiệm mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/chi-phi-mua-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Khi so giá <strong>Sun Saphia Residence</strong>, nhiều người chỉ nhìn con số trên bảng giá. Thực tế, tổng tiền bỏ ra còn gồm thuế, phí và nội thất. Bài này liệt kê từng khoản theo quy định hiện hành và ví dụ cho một căn studio dùng <strong>giá tham khảo 3 tỷ</strong> trong tài liệu chủ đầu tư.</p>
<!--hh-featured-->
<h2>Các khoản ngoài giá căn</h2>
<table>
<thead><tr><th>Khoản</th><th>Mức</th><th>Căn cứ</th></tr></thead>
<tbody>
<tr><td>Thuế GTGT (VAT)</td><td>10%</td><td>Tính trên giá bán trừ phần tiền đất được khấu trừ – thường đã ghi gộp trong bảng giá "đã gồm VAT"</td></tr>
<tr><td>Kinh phí bảo trì phần sở hữu chung</td><td>2% giá bán (trước thuế)</td><td>Luật Nhà ở 2023; nộp khi nhận bàn giao hoặc theo hợp đồng</td></tr>
<tr><td>Lệ phí trước bạ</td><td>0,5%</td><td>Nghị định 10/2022/NĐ-CP (đã sửa đổi); tính trên giá cao hơn giữa giá hợp đồng và bảng giá địa phương</td></tr>
<tr><td>Phí quản lý vận hành</td><td>Chưa công bố</td><td>Thu hằng tháng theo m²; hỏi mức dự kiến khi ký</td></tr>
<tr><td>Nội thất</td><td>Tùy chọn</td><td>Bàn giao hoàn thiện cơ bản – cần tự làm nội thất</td></tr>
</tbody>
</table>
<h2>Ví dụ: studio giá tham khảo 3 tỷ</h2>
<p>Giả định 3 tỷ là giá chưa gồm VAT và kinh phí bảo trì (cách ghi giá cụ thể sẽ theo bảng giá chính thức):</p>
<table>
<thead><tr><th>Khoản</th><th>Số tiền ước tính</th></tr></thead>
<tbody>
<tr><td>Giá căn</td><td>3 tỷ</td></tr>
<tr><td>VAT 10% (mức tối đa, chưa trừ tiền đất)</td><td>Tới 300 triệu</td></tr>
<tr><td>Kinh phí bảo trì 2%</td><td>60 triệu</td></tr>
<tr><td>Lệ phí trước bạ 0,5%</td><td>Khoảng 15 triệu</td></tr>
<tr><td>Nội thất cho thuê (studio 30 m²)</td><td>Tùy mức hoàn thiện – hỏi báo giá</td></tr>
</tbody>
</table>
<p>Như vậy, ngoài nội thất, các khoản bắt buộc có thể lên tới khoảng <strong>375 triệu</strong> nếu bảng giá chưa gồm VAT. Nếu bảng giá ghi "đã gồm VAT", phần cộng thêm chủ yếu là 2% bảo trì và lệ phí trước bạ.</p>
<h2>4 câu cần hỏi khi nhận bảng giá</h2>
<ol>
<li>Giá đã gồm VAT và 2% kinh phí bảo trì chưa?</li>
<li>Diện tích tính giá là thông thủy hay tim tường? (tài liệu chủ đầu tư ghi diện tích thông thủy)</li>
<li>Phí quản lý dự kiến bao nhiêu mỗi m² mỗi tháng?</li>
<li>Chính sách chiết khấu, hỗ trợ lãi suất có áp dụng trên giá đã gồm VAT không?</li>
</ol>
<p>Giá tham khảo và cách đọc bảng giá: xem <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia Residence bao nhiêu</a>. Thời hạn sở hữu: xem <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia Residence</a>.</p>
<p><em>Bài viết tổng hợp quy định chung để tham khảo, không thay cho tư vấn pháp lý, thuế cho từng hồ sơ.</em></p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chi phí mua Sun Saphia Residence ngoài giá bán',
			'desc'      => 'Mua Sun Saphia Residence cần tính thêm VAT, kinh phí bảo trì 2%, lệ phí trước bạ 0,5%, phí quản lý, nội thất. Ví dụ studio giá tham khảo 3 tỷ.',
			'points'    => array(
				'Kinh phí bảo trì 2% giá bán trước thuế (Luật Nhà ở 2023)',
				'Lệ phí trước bạ 0,5% (Nghị định 10/2022/NĐ-CP)',
				'Studio 3 tỷ: các khoản bắt buộc tới khoảng 375 triệu nếu giá chưa gồm VAT',
			),
			'faq'       => array(
				array( 'Mua căn hộ phải đóng phí bảo trì bao nhiêu?', 'Kinh phí bảo trì phần sở hữu chung nhà chung cư bằng 2% giá bán (trước thuế) theo Luật Nhà ở 2023.' ),
				array( 'Lệ phí trước bạ căn hộ là bao nhiêu?', '0,5% trên giá tính lệ phí – giá cao hơn giữa giá hợp đồng và bảng giá do UBND địa phương ban hành (Nghị định 10/2022/NĐ-CP, đã sửa đổi).' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat-nha-dat/le-phi-truoc-ba-nha-dat-nam-2026-hien-nay-la-bao-nhieu-14934.html',
		),
	);

	/* ---------------- 02/11 – Vay trả góp ---------------- */
	$posts[] = array(
		'slug'     => 'vay-mua-sun-saphia-residence-tra-gop-hang-thang',
		'title'    => 'Vay mua Sun Saphia Residence: trả góp mỗi tháng bao nhiêu với lãi suất 10 – 12%?',
		'excerpt'  => 'Bảng tính trả góp khi vay 50 – 60% mua căn Sun Saphia Residence: studio 3 tỷ vay 1,5 tỷ trả khoảng 14,5 – 18,8 triệu/tháng (20 năm). Ngân hàng hỗ trợ: VietinBank, BIDV, NCB.',
		'keyword'  => 'vay mua Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'trả góp căn hộ Sun Saphia', 'lãi suất vay mua nhà 2026', 'vay mua căn hộ Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-02 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Vay mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/vay-mua-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Theo tài liệu chủ đầu tư tháng 10/2026, <strong>Sun Saphia Residence</strong> có ngân hàng hỗ trợ cho vay là <strong>VietinBank, BIDV và NCB</strong>. Bài này tính thử số tiền trả mỗi tháng khi vay mua studio và căn 1PN, với mức lãi suất đang phổ biến trên thị trường.</p>
<!--hh-featured-->
<h2>Lãi suất vay mua nhà đang ở mức nào?</h2>
<p>Khảo sát của báo chí cuối tháng 9/2026 ghi lãi vay mua nhà tại BIDV khoảng 9,5 – 10,5%/năm và VietinBank khoảng 9 – 10,5%/năm trong thời gian ưu đãi; sau ưu đãi, lãi thả nổi thường cao hơn. Lãi suất áp dụng thực tế tùy gói vay, hồ sơ và chính sách hỗ trợ của chủ đầu tư khi mở bán – cần hỏi trực tiếp ngân hàng.</p>
<h2>Bảng tính trả góp (giả định)</h2>
<p>Giá căn theo bài toán tham khảo của chủ đầu tư: studio 30 m² khoảng 3 tỷ, căn 1PN 50 m² khoảng 4,5 tỷ. Trả góp đều (gốc + lãi bằng nhau mỗi tháng):</p>
<table>
<thead><tr><th>Khoản vay</th><th>Thời hạn</th><th>Lãi 10%/năm</th><th>Lãi 12%/năm</th></tr></thead>
<tbody>
<tr><td>Studio – vay 1,5 tỷ (50%)</td><td>15 năm</td><td>16,1 triệu/tháng</td><td>18,0 triệu/tháng</td></tr>
<tr><td>Studio – vay 1,5 tỷ (50%)</td><td>20 năm</td><td>14,5 triệu/tháng</td><td>16,5 triệu/tháng</td></tr>
<tr><td>1PN – vay 2,7 tỷ (60%)</td><td>20 năm</td><td>26,1 triệu/tháng</td><td>29,7 triệu/tháng</td></tr>
<tr><td>1PN – vay 2,7 tỷ (60%)</td><td>25 năm</td><td>24,5 triệu/tháng</td><td>28,4 triệu/tháng</td></tr>
</tbody>
</table>
<p>Nếu ngân hàng tính theo <strong>gốc trả đều, lãi theo dư nợ giảm dần</strong>, tháng đầu trả cao hơn: vay 1,5 tỷ trong 20 năm, lãi 10% thì tháng đầu khoảng 18,8 triệu, sau đó giảm dần.</p>
<h2>So với tiền cho thuê</h2>
<ul>
<li>Bài toán của chủ đầu tư (cho thuê ngắn ngày, lấp đầy 60%): studio lợi nhuận khoảng 351 triệu/năm, tức khoảng 29 triệu/tháng – đây là giả định bán hàng, không phải cam kết.</li>
<li>Kịch bản thận trọng trong bài <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">đầu tư Sun Saphia Residence cho thuê</a>: khoảng 105 triệu/năm, tức gần 9 triệu/tháng – không đủ trả góp, cần nguồn thu khác bù.</li>
</ul>
<p>Nguyên tắc an toàn: tiền trả góp không nên vượt khoảng 40% thu nhập ổn định hằng tháng, không tính tiền cho thuê dự kiến.</p>
<h2>Hỏi gì khi làm hồ sơ vay?</h2>
<ol>
<li>Lãi ưu đãi bao lâu, lãi sau ưu đãi tính theo công thức nào (lãi cơ sở + biên độ bao nhiêu)?</li>
<li>Chủ đầu tư có hỗ trợ lãi suất, ân hạn nợ gốc đến khi nhận nhà không?</li>
<li>Phí trả nợ trước hạn trong 3 – 5 năm đầu.</li>
<li>Tỷ lệ cho vay tối đa và tài sản bảo đảm trong thời gian chưa có giấy chứng nhận.</li>
</ol>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Vay mua Sun Saphia Residence: trả góp mỗi tháng',
			'desc'      => 'Vay mua Sun Saphia Residence: studio 3 tỷ vay 1,5 tỷ trả khoảng 14,5 – 18,8 triệu/tháng (20 năm, lãi 10 – 12%). Ngân hàng hỗ trợ VietinBank, BIDV, NCB.',
			'points'    => array(
				'Ngân hàng hỗ trợ: VietinBank, BIDV, NCB (tài liệu chủ đầu tư 10/2026)',
				'Studio vay 1,5 tỷ, 20 năm: khoảng 14,5 – 16,5 triệu/tháng',
				'Lãi vay mua nhà cuối 9/2026 khoảng 9 – 10,5%/năm thời gian ưu đãi',
			),
			'faq'       => array(
				array( 'Ngân hàng nào cho vay mua Sun Saphia Residence?', 'Tài liệu chủ đầu tư tháng 10/2026 ghi ngân hàng hỗ trợ là VietinBank, BIDV và NCB.' ),
				array( 'Vay 1,5 tỷ mua căn hộ trả mỗi tháng bao nhiêu?', 'Trả góp đều 20 năm: khoảng 14,5 triệu/tháng với lãi 10%/năm, khoảng 16,5 triệu/tháng với lãi 12%/năm.' ),
			),
		),
		'sources'  => array(
			'https://fili.vn/2026/09/lai-vay-mua-nha-tren-10nam-giam-lai-co-du-de-nguoi-dan-mua-nha-757-1493561.htm',
		),
	);

	/* ---------------- 03/11 – Khách du lịch ---------------- */
	$posts[] = array(
		'slug'     => 'khach-du-lich-da-nang-2026-nhu-cau-thue-can-ho-ven-bien',
		'title'    => 'Đà Nẵng đón 15,86 triệu khách lưu trú 9 tháng 2026: tín hiệu gì cho căn hộ ven biển như Sun Saphia Residence?',
		'excerpt'  => '9 tháng 2026, Đà Nẵng đón khoảng 15,86 triệu lượt khách lưu trú (+26,4%), khách quốc tế 7,73 triệu (+28,7%). Nhu cầu thuê căn hộ ven biển và điều nhà đầu tư Sun Saphia Residence cần lưu ý.',
		'keyword'  => 'khách du lịch Đà Nẵng 2026',
		'keywords_extra' => array( 'Sun Saphia Residence', 'thuê căn hộ ven biển Đà Nẵng', 'du lịch Đà Nẵng 9 tháng 2026', 'căn hộ cho thuê Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-03 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Du lịch Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/khach-du-lich-da-nang-9-thang-2026.jpg',
		'content'  => <<<HTML
<p>Theo số liệu UBND TP Đà Nẵng công bố tại họp báo quý III (23/10/2026), các cơ sở lưu trú trong thành phố phục vụ khoảng <strong>15,86 triệu lượt khách trong 9 tháng 2026</strong>, tăng 26,4% so với cùng kỳ. Với người đang cân nhắc căn hộ ven biển để cho thuê như <strong>Sun Saphia Residence</strong>, đây là số liệu đáng xem kỹ.</p>
<!--hh-featured-->
<h2>Số liệu du lịch 9 tháng 2026</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>9 tháng 2026</th><th>So cùng kỳ</th></tr></thead>
<tbody>
<tr><td>Khách lưu trú</td><td>Khoảng 15,86 triệu lượt</td><td>+26,4%</td></tr>
<tr><td>Khách quốc tế</td><td>Khoảng 7,73 triệu lượt</td><td>+28,7%</td></tr>
<tr><td>Khách nội địa</td><td>Khoảng 8,13 triệu lượt</td><td>+24,3%</td></tr>
<tr><td>Khách ngủ qua đêm</td><td>Khoảng 14,43 triệu lượt</td><td>+29,6%</td></tr>
<tr><td>Doanh thu lưu trú, ăn uống</td><td>Khoảng 52.945 tỷ đồng</td><td>+26,2%</td></tr>
</tbody>
</table>
<p>Số liệu là ước tính, chỉ tính khách tại cơ sở lưu trú, có thể điều chỉnh khi có số chính thức.</p>
<h2>Ý nghĩa với căn hộ ven biển</h2>
<ul>
<li><strong>Khách quốc tế tăng nhanh hơn khách nội địa</strong>: nhóm này ở dài ngày hơn và hay chọn căn hộ có bếp, gần biển.</li>
<li><strong>Khách ngủ qua đêm tăng gần 30%</strong>: nhu cầu chỗ ở thật, không chỉ khách tham quan trong ngày.</li>
<li><strong>Cạnh tranh cũng tăng</strong>: nguồn phòng khách sạn, căn hộ cho thuê ven biển Mỹ Khê – Sơn Thủy – Non Nước rất lớn; căn nào view đẹp, vận hành tốt mới giữ được giá thuê.</li>
</ul>
<h2>Đặt vào bài toán Sun Saphia Residence</h2>
<p>Tài liệu chủ đầu tư dùng giả định studio 2,5 triệu/đêm, lấp đầy 60%. Lượng khách tăng là điều kiện cần, nhưng tỷ lệ lấp đầy của từng căn còn phụ thuộc mùa (Đà Nẵng đông khách từ tháng 4 đến tháng 9), giá cạnh tranh và đơn vị vận hành. So sánh các khu ven biển: xem <a href="/can-ho-ven-bien-my-khe-son-thuy-non-nuoc-so-sanh/">căn hộ ven biển Mỹ Khê – Sơn Thủy – Non Nước</a>.</p>
<p>Lưu ý: số liệu du lịch là bức tranh chung của thành phố, không phải cam kết doanh thu cho bất kỳ căn hộ nào.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Khách du lịch Đà Nẵng 9 tháng 2026 và căn hộ ven biển',
			'desc'      => '9 tháng 2026 Đà Nẵng đón khoảng 15,86 triệu khách lưu trú (+26,4%), quốc tế 7,73 triệu. Tín hiệu cho căn hộ ven biển cho thuê như Sun Saphia Residence.',
			'points'    => array(
				'15,86 triệu lượt khách lưu trú 9 tháng 2026, tăng 26,4%',
				'Khách quốc tế khoảng 7,73 triệu lượt, tăng 28,7%',
				'Khách tăng nhưng cạnh tranh nguồn phòng ven biển cũng lớn',
			),
			'faq'       => array(
				array( 'Đà Nẵng đón bao nhiêu khách 9 tháng 2026?', 'Khoảng 15,86 triệu lượt khách lưu trú, tăng 26,4% so với cùng kỳ; khách quốc tế khoảng 7,73 triệu lượt (số liệu UBND TP công bố 23/10/2026).' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-don-gan-16-trieu-luot-khach-luu-tru-trong-9-thang-nam-2026-post1140183.vnp',
			'https://baodanang.vn/da-nang-don-gan-15-9-trieu-luot-khach-luu-tru-trong-9-thang-3354453.html',
		),
	);

	/* ---------------- 04/11 – Pháp lý cho thuê ngắn ngày ---------------- */
	$posts[] = array(
		'slug'     => 'cho-thue-ngan-ngay-can-ho-da-nang-phap-ly-thue',
		'title'    => 'Cho thuê ngắn ngày căn hộ Sun Saphia Residence: pháp lý, khai báo lưu trú và thuế cần biết',
		'excerpt'  => 'Trước khi mua Sun Saphia Residence để cho thuê theo ngày, cần biết: căn hộ phải dùng đúng công năng, đăng ký cơ sở lưu trú nếu kinh doanh du lịch, khai báo lưu trú cho khách và kê khai thuế.',
		'keyword'  => 'cho thuê ngắn ngày căn hộ Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'cho thuê căn hộ theo ngày', 'khai báo lưu trú khách thuê', 'thuế cho thuê căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-04 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý cho thuê' ),
		'image'    => 'plugin:img/tin-tuc/cho-thue-ngan-ngay-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Phần lớn người hỏi mua <strong>Sun Saphia Residence</strong> có ý định cho thuê ngắn ngày (theo đêm). Năm 2026, cơ quan quản lý ở nhiều địa phương siết chặt việc cho thuê căn hộ theo ngày. Bài này tóm tắt những điểm pháp lý chung cần biết trước khi tính dòng tiền.</p>
<!--hh-featured-->
<h2>1. Căn hộ phải dùng đúng công năng</h2>
<p>Luật Nhà ở 2023 không cho tự ý chuyển công năng căn hộ để ở sang mục đích khác. Vì vậy, điều đầu tiên cần xem là <strong>công năng ghi trong hợp đồng và giấy tờ dự án</strong>: căn hộ để ở hay căn hộ kinh doanh dịch vụ, lưu trú. Tài liệu chủ đầu tư ghi Sun Saphia Residence có thời hạn dự án 50 năm kể từ 17/09/2026 – khi ký hợp đồng, hãy hỏi rõ công năng căn hộ và việc cho thuê theo ngày có được phép trong quy chế tòa nhà không.</p>
<h2>2. Đăng ký cơ sở lưu trú nếu kinh doanh du lịch</h2>
<p>Cho khách du lịch thuê theo đêm là hoạt động kinh doanh lưu trú. Theo hướng quản lý hiện nay (ví dụ quy định mới của TP.HCM năm 2026), chủ căn hộ khai thác căn hộ du lịch phải <strong>đăng ký cơ sở lưu trú</strong> và đáp ứng điều kiện an ninh trật tự, phòng cháy. Báo chí cũng ghi nhận mức phạt tới hàng trăm triệu đồng với việc biến căn hộ thành cơ sở lưu trú trái phép. Đà Nẵng có thể áp dụng quy định riêng – cần hỏi phường và cơ quan du lịch thành phố.</p>
<h2>3. Khai báo lưu trú cho mọi khách</h2>
<p>Mọi khách thuê, nhất là khách nước ngoài, phải được khai báo lưu trú với công an theo Luật Cư trú. Căn hộ tự nhận phòng bằng mật khẩu vẫn phải khai báo – đây là lỗi nhiều chủ nhà hay bỏ sót.</p>
<h2>4. Kê khai thuế</h2>
<ul>
<li>Cá nhân có doanh thu cho thuê trên <strong>100 triệu đồng/năm</strong> phải kê khai, nộp thuế giá trị gia tăng và thuế thu nhập cá nhân.</li>
<li>Tỷ lệ thuế khác nhau giữa <strong>cho thuê tài sản</strong> và <strong>kinh doanh dịch vụ lưu trú</strong> (có dọn phòng, đón khách) – hỏi cơ quan thuế để biết căn của mình thuộc nhóm nào.</li>
<li>Khi thuê đơn vị vận hành, hợp đồng cần ghi rõ bên nào kê khai, nộp thuế.</li>
</ul>
<h2>5. Cách giảm rủi ro</h2>
<ol>
<li>Đọc quy chế quản lý tòa nhà trước khi ký – quy định cho thuê ngắn ngày, khách ra vào, thẻ thang máy.</li>
<li>Hỏi chủ đầu tư về mô hình cho thuê do chủ đầu tư hoặc đơn vị chuyên nghiệp vận hành.</li>
<li>Tính thêm kịch bản cho thuê dài hạn (theo tháng) để không phụ thuộc hoàn toàn vào khách theo đêm.</li>
</ol>
<p>Bài toán dòng tiền các kịch bản: xem <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">đầu tư Sun Saphia Residence cho thuê</a>.</p>
<p><em>Bài viết tổng hợp để tham khảo, không thay cho tư vấn pháp lý, thuế; quy định có thể thay đổi và khác nhau giữa các địa phương.</em></p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cho thuê ngắn ngày Sun Saphia Residence: pháp lý, thuế',
			'desc'      => 'Cho thuê ngắn ngày Sun Saphia Residence: đúng công năng, đăng ký cơ sở lưu trú, khai báo lưu trú cho khách, nộp thuế khi doanh thu trên 100 triệu/năm.',
			'points'    => array(
				'Căn hộ phải dùng đúng công năng ghi trong hợp đồng (Luật Nhà ở 2023)',
				'Kinh doanh lưu trú du lịch cần đăng ký cơ sở lưu trú',
				'Doanh thu cho thuê trên 100 triệu/năm phải kê khai thuế',
			),
			'faq'       => array(
				array( 'Có được cho thuê căn hộ Sun Saphia Residence theo ngày không?', 'Phụ thuộc công năng căn hộ ghi trong hợp đồng, quy chế tòa nhà và quy định của Đà Nẵng về cơ sở lưu trú – cần hỏi rõ chủ đầu tư khi ký.' ),
				array( 'Cho thuê căn hộ phải nộp thuế khi nào?', 'Cá nhân có doanh thu cho thuê trên 100 triệu đồng/năm phải kê khai, nộp thuế GTGT và thuế TNCN; tỷ lệ tùy cho thuê tài sản hay kinh doanh lưu trú.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/cho-thue-can-ho-ngan-ngay-trong-chung-cu-phai-dang-ky-hoat-dong-5062683.html',
			'https://tuoitre.vn/cho-thue-chung-cu-theo-ngay-coi-chung-bi-phat-tram-trieu-vi-dung-nha-sai-muc-dich-10026091112545148.htm',
		),
	);

	/* ---------------- 05/11 – Thị trường quý III ---------------- */
	$posts[] = array(
		'slug'     => 'thi-truong-can-ho-da-nang-quy-3-2026-sun-saphia-residence',
		'title'    => 'Thị trường căn hộ Đà Nẵng quý III/2026: nguồn cung giảm 14%, Sun Saphia Residence ra hàng lúc nào là hợp lý?',
		'excerpt'  => 'Quý III/2026 Đà Nẵng có 4.385 căn hộ sơ cấp từ 20 dự án (-14%), tiêu thụ 2.099 căn, tập trung Ngũ Hành Sơn, Hải Châu, Sơn Trà. Giá sơ cấp neo cao – Sun Saphia Residence nằm ở đâu trong bức tranh này.',
		'keyword'  => 'thị trường căn hộ Đà Nẵng quý III 2026',
		'keywords_extra' => array( 'Sun Saphia Residence', 'nguồn cung căn hộ Đà Nẵng', 'giá căn hộ Đà Nẵng 2026', 'căn hộ Ngũ Hành Sơn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-05 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Thị trường căn hộ Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/thi-truong-can-ho-da-nang-quy-3-2026.jpg',
		'content'  => <<<HTML
<p>Báo cáo quý III/2026 của DKRA Consulting (báo chí trích dẫn) cho thấy <strong>thị trường căn hộ Đà Nẵng</strong> giảm cả nguồn cung lẫn giao dịch, nhưng giá sơ cấp vẫn neo cao. Bài này tóm tắt các con số chính và đặt <strong>Sun Saphia Residence</strong> – dự án đang nhận giữ chỗ ở Ngũ Hành Sơn – vào bức tranh chung.</p>
<!--hh-featured-->
<h2>Con số chính quý III/2026</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Quý III/2026</th><th>Biến động</th></tr></thead>
<tbody>
<tr><td>Nguồn cung sơ cấp</td><td>4.385 căn từ 20 dự án</td><td>-14% so với quý II</td></tr>
<tr><td>Nguồn cung mới</td><td>Giảm gần 40%</td><td>So với quý II</td></tr>
<tr><td>Tiêu thụ sơ cấp</td><td>2.099 căn (khoảng 48% nguồn cung)</td><td>-25% so với quý II, -24% so với cùng kỳ</td></tr>
<tr><td>Căn hộ hạng B</td><td>46% nguồn cung, 68% lượng tiêu thụ</td><td>Phân khúc dẫn dắt</td></tr>
<tr><td>Dự báo quý IV/2026</td><td>500 – 1.000 căn mới</td><td>Tập trung Ngũ Hành Sơn, Hải Châu, Sơn Trà</td></tr>
</tbody>
</table>
<h2>Đọc số liệu thế nào?</h2>
<ul>
<li><strong>Giá sơ cấp neo cao</strong> do chi phí đầu vào tăng; ngược lại giá thứ cấp được dự báo tiếp tục giảm vì lãi suất cao – người mua có thêm lựa chọn ở thị trường chuyển nhượng.</li>
<li><strong>Ngũ Hành Sơn là một trong ba khu tập trung nguồn cung</strong>: cạnh tranh trực tiếp với các dự án ven biển khác cùng khu vực.</li>
<li><strong>Hạng B dẫn dắt thanh khoản</strong>: sản phẩm tổng tiền vừa phải bán nhanh hơn – phù hợp với cơ cấu nhiều studio của Sun Saphia Residence (513/782 căn).</li>
</ul>
<h2>Sun Saphia Residence trong bức tranh này</h2>
<p>Sun Saphia Residence chưa công bố bảng giá chính thức. Khi có giá, nên so với ba mốc: giá sơ cấp các dự án ven biển cùng khu, giá chuyển nhượng căn hộ đã bàn giao gần biển, và chi phí vốn khi vay (lãi vay mua nhà đang khoảng 9 – 10,5%/năm thời gian ưu đãi). Tham khảo: <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia Residence</a>, <a href="/vay-mua-sun-saphia-residence-tra-gop-hang-thang/">bảng tính trả góp</a>.</p>
<p>Lưu ý: số liệu thị trường là của đơn vị nghiên cứu, báo chí trích dẫn, có thể khác giữa các nguồn; nên xem báo cáo gốc khi cần con số chính xác.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Thị trường căn hộ Đà Nẵng quý III/2026 và Sun Saphia',
			'desc'      => 'Quý III/2026: căn hộ sơ cấp Đà Nẵng 4.385 căn (-14%), tiêu thụ 2.099 căn, hạng B dẫn dắt, giá sơ cấp neo cao. Sun Saphia Residence so với thị trường.',
			'points'    => array(
				'Nguồn cung sơ cấp 4.385 căn từ 20 dự án, giảm 14%',
				'Tiêu thụ 2.099 căn, giảm 25% so với quý II',
				'Quý IV/2026 dự kiến 500 – 1.000 căn mới, tập trung Ngũ Hành Sơn, Hải Châu, Sơn Trà',
			),
			'faq'       => array(
				array( 'Nguồn cung căn hộ Đà Nẵng quý III/2026 là bao nhiêu?', 'Theo DKRA (báo chí trích dẫn), khoảng 4.385 căn sơ cấp từ 20 dự án, giảm 14% so với quý II; tiêu thụ khoảng 2.099 căn.' ),
			),
		),
		'sources'  => array(
			'https://cafef.vn/nguon-cung-so-cap-can-ho-tai-da-nang-giam-14-trong-quy-iii-2026-188261025063317834.chn',
			'https://baodautu.vn/thi-truong-dat-nen-can-ho-da-nang-quy-iii2026-dong-tien-chon-loc-d729484.html',
		),
	);

	return $posts;
}
