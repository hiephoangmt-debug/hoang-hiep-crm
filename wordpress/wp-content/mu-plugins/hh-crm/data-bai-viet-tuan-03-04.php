<?php
/**
 * Bài viết kế hoạch nội dung – tuần 3–4 (cụm Sun Group Nam Đà Nẵng: FourS Tower, Sun Riverpolis, đất nền Đầm Sen, hạ tầng Hòa Xuân – Hòa Quý; cụm Casamia Balanca Hội An). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_03_04' );
function hh_posts_tuan_03_04( $posts ) {

	/* ======================= TUẦN 3 ======================= */

	$posts[] = array(
		'slug'     => 'co-nen-mua-can-ho-fours-tower',
		'title'    => 'Có nên mua FourS Tower? Ưu – nhược điểm căn hộ Sun Group Nam Đà Nẵng',
		'excerpt'  => 'Có nên mua FourS Tower? Phân tích vị trí, quy mô, giá tham khảo, ưu – nhược điểm và ai phù hợp xuống tiền, cập nhật tháng 10/2026.',
		'keyword'  => 'có nên mua FourS Tower',
		'project'  => 'fours-tower',
		'week'     => 3,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Có nên mua FourS Tower? Câu trả lời ngắn của Hoàng Hiệp: <strong>nên cân nhắc nếu bạn mua để ở lâu dài hoặc đầu tư trung – dài hạn</strong> ở phía Nam Đà Nẵng, chấp nhận chờ bàn giao và không cần dòng tiền ngay. Nếu cần nhà ở ngay hoặc muốn lướt sóng ngắn, bạn nên cân nhắc kỹ hơn. Bài viết cập nhật tháng 10/2026, tổng hợp từ thông tin công bố của chủ đầu tư, báo chí và các đơn vị phân phối.</p>

<h2>FourS Tower là dự án gì?</h2>
<p><a href="/du-an/fours-tower/">FourS Tower (Tháp Bốn Mùa)</a> là phân khu căn hộ đầu tiên của khu đô thị <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a>, do Sun Property (thành viên Sun Group) phát triển. Dự án ra mắt ngày 19/3/2026, nằm tại ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn.</p>
<p>Dự án gồm 4 tòa Mai – Trúc – Cúc – Tùng, cao 20 tầng nổi và 2 tầng hầm, cung cấp khoảng 2.291 căn từ Studio đến 3 phòng ngủ, sở hữu lâu dài. Tên bốn tòa lấy cảm hứng từ bộ tranh tứ quý, tương ứng bốn mùa trong năm.</p>

<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Sun Group (Sun Property phát triển)</td></tr>
<tr><td>Vị trí</td><td>Ngã tư Nguyễn Phước Lan – Minh Mạng, Hòa Quý, Ngũ Hành Sơn</td></tr>
<tr><td>Quy mô</td><td>4 tòa, 20 tầng nổi, 2 tầng hầm, khoảng 2.291 căn</td></tr>
<tr><td>Loại căn</td><td>Studio, 1PN, 2PN, 3PN</td></tr>
<tr><td>Giá tham khảo</td><td>Khoảng 50 – 60 triệu/m² (theo các trang phân phối, tham khảo)</td></tr>
<tr><td>Bàn giao</td><td>Một số đơn vị phân phối ghi dự kiến 31/3/2028 – cần đối chiếu hợp đồng</td></tr>
<tr><td>Sở hữu</td><td>Lâu dài</td></tr>
</tbody>
</table>

<h2>Ưu điểm khi mua FourS Tower</h2>
<h3>1. Vị trí trung tâm khu đô thị phía Nam</h3>
<p>Ngã tư Nguyễn Phước Lan – Minh Mạng là trục chính của khu Nam Hòa Xuân, gần sông Cổ Cò, cách biển chỉ vài phút và nhìn về Ngũ Hành Sơn. Khu vực nằm trong hệ sinh thái hơn 1.000 ha của Sun Group cùng <a href="/du-an/sun-neo-city/">Sun NeO City</a>.</p>
<h3>2. Thương hiệu chủ đầu tư và hệ tiện ích</h3>
<p>Tiện ích nội khu bố trí tại tầng 2 gồm hồ bơi bốn mùa, gym, yoga, spa, khu vui chơi trẻ em, không gian cộng đồng và phòng khám. Với người mua để ở, đây là nhóm tiện ích dùng hằng ngày, không phải tiện ích trang trí.</p>
<h3>3. Giá vào còn mềm so với căn hộ ven sông Hàn, ven biển</h3>
<p>Theo các trang phân phối, giá tham khảo từ khoảng 1,7 tỷ cho Studio, khoảng 2,6 tỷ cho 1PN+ và khoảng 3,6 tỷ cho 2PN. Mức này thấp hơn đáng kể so với nhiều dự án <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a> ở trung tâm Hải Châu, Sơn Trà.</p>
<h3>4. Hạ tầng phía Nam đang được đầu tư</h3>
<p>Cụm nút giao cầu Hòa Xuân hơn 1.378 tỷ đồng, thực hiện 2026 – 2029, sẽ cải thiện kết nối về trung tâm. Xem phân tích chi tiết tại bài <a href="/bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026/">hạ tầng Hòa Xuân – Hòa Quý và bất động sản Nam Đà Nẵng</a>.</p>

<h2>Nhược điểm cần cân nhắc</h2>
<ul>
<li><strong>Thời gian chờ:</strong> sản phẩm hình thành trong tương lai, người mua phải chờ bàn giao, chưa có dòng tiền cho thuê trong vài năm đầu.</li>
<li><strong>Nguồn cung lớn:</strong> khoảng 2.291 căn, cộng thêm Spana Tower, S-Light Tower, Cora Tower cùng khu vực. Khi bàn giao đồng loạt, áp lực cạnh tranh cho thuê và bán lại là có thật.</li>
<li><strong>Khu đô thị còn đang hình thành:</strong> mật độ dân cư, dịch vụ ngoài nội khu cần thời gian để lấp đầy.</li>
<li><strong>Giá thông tin chưa thống nhất:</strong> các trang ghi khác nhau; bạn chỉ nên tin bảng giá và chính sách có hiệu lực tại thời điểm ký.</li>
</ul>

<h2>Ai nên mua FourS Tower?</h2>
<table>
<thead><tr><th>Nhu cầu</th><th>Mức phù hợp</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Gia đình trẻ mua để ở</td><td>Phù hợp</td><td>Chọn 2PN – 3PN, tầng trung, view nội khu hoặc sông</td></tr>
<tr><td>Đầu tư cho thuê dài hạn</td><td>Khá phù hợp</td><td>Ưu tiên Studio, 1PN+ gần tiện ích, chấp nhận chờ</td></tr>
<tr><td>Lướt sóng ngắn hạn</td><td>Cân nhắc</td><td>Nguồn cung lớn, chênh lệch phụ thuộc đợt bán</td></tr>
<tr><td>Cần nhà ở ngay</td><td>Chưa phù hợp</td><td>Nên xem căn hộ đã bàn giao trên <a href="/mua-ban/can-ho-chung-cu/">trang mua bán căn hộ</a></td></tr>
</tbody>
</table>

<h2>Kinh nghiệm chọn căn của Hoàng Hiệp</h2>
<p>Trước khi đặt chỗ, hãy so sánh FourS Tower với các tòa cùng hệ sinh thái Sun Group – xem bài <a href="/so-sanh-fours-tower-spana-tower-s-light-tower/">so sánh FourS Tower, Spana Tower và S-Light Tower</a>. Kiểm tra kỹ hướng căn, khoảng cách tới tiện ích tầng 2, lịch thanh toán và điều khoản bàn giao trong hợp đồng.</p>
<p>Với khách đầu tư, nên tính trước kịch bản giữ tối thiểu 3 – 5 năm. Với khách mua ở, nên ưu tiên căn có công năng tốt hơn là chạy theo căn giá thấp nhất.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá FourS Tower đợt hiện hành, quỹ căn còn lại và tư vấn chọn căn theo nhu cầu ở hay đầu tư.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Có nên mua FourS Tower? Ưu – nhược điểm 2026',
			'desc'      => 'Có nên mua FourS Tower? Phân tích vị trí, giá tham khảo, ưu – nhược điểm, ai nên mua. Gọi Hoàng Hiệp 0904 567 009 để nhận bảng giá mới.',
			'points'    => array(
				'FourS Tower: 4 tòa 20 tầng, khoảng 2.291 căn Studio – 3PN tại ngã tư Nguyễn Phước Lan – Minh Mạng, ra mắt 19/3/2026.',
				'Ưu điểm: vị trí trung tâm Nam Đà Nẵng, thương hiệu Sun Group, giá vào tham khảo từ khoảng 1,7 tỷ.',
				'Nhược điểm: phải chờ bàn giao, nguồn cung khu vực lớn, khu đô thị còn đang hình thành.',
			),
			'faq'       => array(
				array( 'Có nên mua FourS Tower để ở không?', 'Phù hợp với gia đình mua ở lâu dài, chấp nhận chờ bàn giao. Nên chọn căn 2PN – 3PN có công năng tốt.' ),
				array( 'FourS Tower giá bao nhiêu?', 'Theo các trang phân phối, giá tham khảo khoảng 50 – 60 triệu/m², Studio từ khoảng 1,7 tỷ. Giá chính thức thay đổi theo từng đợt bán.' ),
				array( 'FourS Tower có sở hữu lâu dài không?', 'Có, căn hộ FourS Tower là sở hữu lâu dài theo thông tin công bố.' ),
				array( 'Nhược điểm lớn nhất của FourS Tower là gì?', 'Thời gian chờ bàn giao và nguồn cung căn hộ lớn ở khu vực Nam Hòa Xuân khi các tòa bàn giao gần nhau.' ),
			),
		),
		'sources'  => array( 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm', 'https://tuoitre.vn/fours-tower-an-cu-dau-tu-tai-trung-tam-nam-da-nang-20260410181212744.htm', 'https://cafeland.vn/du-an/fours-tower-phan-khu-can-ho-tai-sun-riverpolis-da-nang-5311.html', 'https://duanbdsdanang.com/du-an/fours-tower-da-nang/' ),
	);

	$posts[] = array(
		'slug'     => 'so-sanh-fours-tower-spana-tower-s-light-tower',
		'title'    => 'So sánh căn hộ Sun Group Đà Nẵng: FourS Tower, Spana Tower, S-Light Tower',
		'excerpt'  => 'So sánh căn hộ Sun Group Đà Nẵng: vị trí, quy mô, loại căn, bàn giao và giá tham khảo của FourS Tower, Spana Tower, S-Light Tower.',
		'keyword'  => 'so sánh căn hộ Sun Group Đà Nẵng',
		'project'  => 'fours-tower',
		'week'     => 3,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>So sánh căn hộ Sun Group Đà Nẵng ở phía Nam, ba cái tên được hỏi nhiều nhất là FourS Tower, Spana Tower và S-Light Tower. Tóm tắt nhanh: <strong>Spana Tower</strong> bàn giao sớm nhất (dự kiến giữa 2027), <strong>S-Light Tower</strong> có lợi thế view ba dòng sông, còn <strong>FourS Tower</strong> có quy mô lớn nhất và giá vào tham khảo mềm. Thông tin cập nhật tháng 10/2026.</p>

<h2>Bảng so sánh căn hộ Sun Group Đà Nẵng</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>FourS Tower</th><th>Spana Tower</th><th>S-Light Tower</th></tr></thead>
<tbody>
<tr><td>Khu đô thị</td><td>Sun Riverpolis (Hòa Quý)</td><td>Sun NeO City (Hòa Xuân)</td><td>Sun NeO City (Hòa Xuân)</td></tr>
<tr><td>Vị trí</td><td>Ngã tư Nguyễn Phước Lan – Minh Mạng</td><td>Mặt tiền Nguyễn Phước Lan, chân cầu Hòa Xuân</td><td>Đường 29/3 giao Nguyễn Đình Thi</td></tr>
<tr><td>Quy mô</td><td>4 tòa, 20 tầng, 2 hầm, khoảng 2.291 căn</td><td>2 tòa (A1.3, A1.4), 22 tầng, 2 hầm, khoảng 1.281 căn</td><td>2 tháp, 22 tầng, 3 hầm, gần 800 căn</td></tr>
<tr><td>Loại căn</td><td>Studio – 3PN</td><td>Studio – 3PN, Penthouse, shophouse khối đế</td><td>Studio – 3PN góc, Penthouse (33,3 – 95,1 m²)</td></tr>
<tr><td>Bàn giao (dự kiến)</td><td>31/3/2028 (theo nguồn phân phối)</td><td>30/6/2027</td><td>6/2028 (theo nguồn phân phối)</td></tr>
<tr><td>Giá tham khảo</td><td>Khoảng 50 – 60 triệu/m²; Studio từ khoảng 1,7 tỷ</td><td>Khoảng 60 triệu/m² (dao động theo nguồn)</td><td>Từ khoảng 2,4 tỷ/căn</td></tr>
</tbody>
</table>
<p>Giá trên là mức tham khảo tổng hợp từ các trang phân phối và báo chí, chưa phải bảng giá chính thức. Giá thực tế thay đổi theo tầng, hướng, đợt bán và chính sách thanh toán.</p>

<h2>Điểm mạnh riêng của từng dự án</h2>
<h3>FourS Tower – quy mô lớn, trung tâm Nam Hòa Xuân</h3>
<p><a href="/du-an/fours-tower/">FourS Tower</a> là phân khu căn hộ đầu tiên của Sun Riverpolis, ra mắt 19/3/2026. Tiện ích tầng 2 gồm hồ bơi bốn mùa, gym, yoga, spa, khu trẻ em và phòng khám. Quy mô lớn giúp cộng đồng cư dân đông, nhưng cũng đồng nghĩa nguồn cung cho thuê nhiều.</p>
<h3>Spana Tower – sát cầu Hòa Xuân, bàn giao sớm</h3>
<p><a href="/du-an/spana-tower/">Spana Tower</a> nằm ngay chân cầu Hòa Xuân, gần trung tâm nhất trong ba dự án. Tầng 1 – 2 là shophouse khối đế và tiện ích. Lịch bàn giao dự kiến 30/6/2027 giúp người mua sớm có nhà ở hoặc khai thác cho thuê.</p>
<h3>S-Light Tower – view ba dòng sông</h3>
<p><a href="/du-an/s-light-tower/">S-Light Tower</a> ra mắt tháng 6/2026, nằm ở ngã ba sông Hàn – Cẩm Lệ – Đô Toả, tầm nhìn về pháo hoa DIFF. Dự án công bố 100% căn đón nắng gió tự nhiên, diện tích từ 33,3 đến 95,1 m², bàn giao hoàn thiện trần, tường, sàn.</p>

<h2>Nên chọn dự án nào?</h2>
<table>
<thead><tr><th>Nhu cầu</th><th>Gợi ý</th><th>Lý do</th></tr></thead>
<tbody>
<tr><td>Cần nhận nhà sớm</td><td>Spana Tower</td><td>Bàn giao dự kiến giữa 2027</td></tr>
<tr><td>Ưu tiên view sông, pháo hoa</td><td>S-Light Tower</td><td>Vị trí ngã ba sông, tầm nhìn rộng</td></tr>
<tr><td>Ngân sách vừa phải, ở lâu dài</td><td>FourS Tower</td><td>Giá vào tham khảo mềm, tiện ích nội khu đầy đủ</td></tr>
<tr><td>Kinh doanh tầng trệt</td><td>Spana Tower</td><td>Có shophouse khối đế mặt tiền Nguyễn Phước Lan</td></tr>
</tbody>
</table>

<h2>Lưu ý chung khi so sánh căn hộ Sun Group</h2>
<ul>
<li>Cả ba dự án đều là căn hộ sở hữu lâu dài thuộc hệ sinh thái hơn 1.000 ha của Sun Group phía Nam Đà Nẵng.</li>
<li>Ngoài ba tòa trên, khu vực còn có <a href="/du-an/cora-tower/">Cora Tower</a> (giao lộ Nguyễn Phước Lan – 29/3, bàn giao dự kiến 30/7/2027).</li>
<li>Đọc kỹ tiêu chuẩn bàn giao, lịch thanh toán và chính sách hỗ trợ vay của từng đợt; đừng so sánh chỉ bằng con số đơn giá/m².</li>
</ul>
<p>Nếu còn phân vân về FourS Tower, bạn có thể đọc thêm bài <a href="/co-nen-mua-can-ho-fours-tower/">có nên mua FourS Tower</a>. Danh sách đầy đủ các dự án khu vực có tại trang <a href="/du-an/">dự án BĐS Đà Nẵng</a>.</p>

<h2>Hạ tầng chung: cả ba dự án cùng hưởng lợi</h2>
<p>Ba dự án đều nằm trên trục Nguyễn Phước Lan – đường 29/3 – Minh Mạng, kết nối về trung tâm qua cầu Hòa Xuân. Cụm nút giao cầu Hòa Xuân hơn 1.378 tỷ đồng (thực hiện 2026 – 2029) bổ sung một cầu mới phía hạ lưu, giúp giảm ùn tắc giờ cao điểm.</p>
<p>Spana Tower và S-Light Tower gần cầu hơn nên hưởng lợi trực tiếp; FourS Tower ở sâu hơn về phía Nam nhưng gần biển và sông Cổ Cò. Xem phân tích tại bài <a href="/bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026/">bất động sản Nam Đà Nẵng 2026</a>.</p>

<h2>Câu hỏi nên đặt ra trước khi chọn</h2>
<ul>
<li>Bạn cần nhận nhà năm nào? Mốc bàn giao chênh nhau gần một năm giữa các dự án.</li>
<li>Bạn ưu tiên view sông, tiện ích nội khu hay tổng tiền thấp?</li>
<li>Nếu cho thuê, khách thuê mục tiêu là ai: chuyên gia, gia đình trẻ hay khách du lịch?</li>
<li>Bạn có thể giữ tài sản bao lâu nếu thị trường đi ngang?</li>
</ul>
<p>Trả lời rõ bốn câu hỏi này thường giúp loại nhanh một hoặc hai lựa chọn, thay vì so sánh dàn trải.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá ba dự án theo cùng thời điểm và được so sánh căn cụ thể theo ngân sách của bạn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'So sánh căn hộ Sun Group Đà Nẵng: FourS, Spana, S-Light',
			'desc'      => 'So sánh căn hộ Sun Group Đà Nẵng: vị trí, quy mô, bàn giao, giá FourS Tower, Spana Tower, S-Light Tower. Gọi Hoàng Hiệp 0904 567 009.',
			'points'    => array(
				'FourS Tower: khoảng 2.291 căn, Sun Riverpolis, giá tham khảo khoảng 50 – 60 triệu/m².',
				'Spana Tower: khoảng 1.281 căn chân cầu Hòa Xuân, bàn giao dự kiến 30/6/2027.',
				'S-Light Tower: gần 800 căn view ba dòng sông, diện tích 33,3 – 95,1 m², ra mắt 6/2026.',
			),
			'faq'       => array(
				array( 'Dự án căn hộ Sun Group nào ở Đà Nẵng bàn giao sớm nhất?', 'Trong ba dự án, Spana Tower có lịch bàn giao dự kiến sớm nhất là 30/6/2027.' ),
				array( 'Căn hộ Sun Group nào có view sông đẹp?', 'S-Light Tower nằm tại ngã ba sông Hàn – Cẩm Lệ – Đô Toả, tầm nhìn về sông và pháo hoa DIFF.' ),
				array( 'FourS Tower và Spana Tower khác nhau thế nào?', 'FourS Tower thuộc Sun Riverpolis (Hòa Quý), 4 tòa khoảng 2.291 căn; Spana Tower thuộc Sun NeO City, chân cầu Hòa Xuân, 2 tòa khoảng 1.281 căn, có shophouse khối đế.' ),
			),
		),
		'sources'  => array( 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm', 'https://cafeland.vn/du-an/spana-tower-du-an-can-ho-tai-da-nang-5406.html', 'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn', 'https://cafeland.vn/du-an/s-light-tower-to-hop-can-ho-thuoc-sun-neo-city-da-nang-5622.html' ),
	);

	$posts[] = array(
		'slug'     => 'sun-riverpolis-khu-do-thi-ven-song-hoa-quy',
		'title'    => 'Sun Riverpolis: khu đô thị ven sông Hòa Quý của Sun Group tại Đà Nẵng',
		'excerpt'  => 'Sun Riverpolis là khu đô thị ven sông của Sun Group tại Hòa Quý, Nam Đà Nẵng: vị trí, quy mô, các phân khu FourS Tower, đất nền Đầm Sen.',
		'keyword'  => 'Sun Riverpolis',
		'project'  => 'sun-riverpolis',
		'week'     => 3,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Sun Riverpolis là khu đô thị ven sông của Sun Group tại phường Hòa Quý (cũ), quận Ngũ Hành Sơn, phía Nam Đà Nẵng – được bao quanh bởi sông nước, cách biển chưa đến 2 km. Đến tháng 10/2026, dự án đã có hai sản phẩm chính trên thị trường: phân khu đất nền Đầm Sen (mở bán từ 8/2025) và tổ hợp căn hộ FourS Tower (ra mắt 3/2026).</p>

<h2>Tổng quan Sun Riverpolis</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Sun Group (Sun Property phát triển)</td></tr>
<tr><td>Vị trí</td><td>Hòa Quý (cũ), Ngũ Hành Sơn – khu đô thị Nam Hòa Xuân</td></tr>
<tr><td>Quy mô</td><td>Khoảng 482,8 ha theo VnExpress; thuộc hệ sinh thái hơn 1.000 ha cùng Sun NeO City</td></tr>
<tr><td>Sản phẩm</td><td>Căn hộ, đất nền, nhà phố, biệt thự ven sông</td></tr>
<tr><td>Pháp lý</td><td>Căn hộ sở hữu lâu dài; đất nền sổ đỏ lâu dài (theo nguồn phân phối)</td></tr>
</tbody>
</table>

<h2>Vị trí Sun Riverpolis: ven sông, gần biển</h2>
<p><a href="/du-an/sun-riverpolis/">Sun Riverpolis</a> nằm trên khu vực ba mặt giáp sông của Hòa Quý, cách trung tâm thành phố khoảng 10 km. Trục giao thông chính là Nguyễn Phước Lan và Minh Mạng; khu vực kết nối với trung tâm qua cầu Hòa Xuân, cầu Trung Lương và với biển qua các tuyến về phía Võ Chí Công.</p>
<p>Đây là một trong ba cấu phần của chuỗi đô thị Sun Group ở Đông Nam Đà Nẵng, bên cạnh Sunneva Island và các khu thương mại lân cận. Phía Bắc là <a href="/du-an/sun-neo-city/">Sun NeO City</a> với các tòa Cora, Spana, S-Light.</p>

<h3>Điểm nhấn cảnh quan</h3>
<p>Theo VnExpress, công viên ven sông là điểm nhấn của Sun Riverpolis với quy mô khoảng 50 ha. Thiết kế tận dụng mặt nước tự nhiên giúp khu đô thị có không khí thoáng, phù hợp gia đình trẻ và người lớn tuổi.</p>

<h2>Các phân khu đang mở bán</h2>
<table>
<thead><tr><th>Phân khu</th><th>Loại hình</th><th>Quy mô</th><th>Thời điểm</th></tr></thead>
<tbody>
<tr><td>FourS Tower (Mai – Trúc – Cúc – Tùng)</td><td>Căn hộ Studio – 3PN</td><td>4 tòa 20 tầng, khoảng 2.291 căn</td><td>Ra mắt 19/3/2026</td></tr>
<tr><td>Đất nền Đầm Sen</td><td>Đất nền, đất biệt thự view sông</td><td>Khoảng 900 lô</td><td>Mở bán từ 9/8/2025</td></tr>
</tbody>
</table>

<h3>FourS Tower – căn hộ đầu tiên của Sun Riverpolis</h3>
<p><a href="/du-an/fours-tower/">FourS Tower</a> đặt tại ngã tư Nguyễn Phước Lan – Minh Mạng, 20 tầng nổi và 2 tầng hầm, tiện ích tầng 2 gồm hồ bơi bốn mùa, gym, spa, khu trẻ em, phòng khám. Đọc thêm phân tích <a href="/co-nen-mua-can-ho-fours-tower/">có nên mua FourS Tower</a>.</p>
<h3>Đất nền Đầm Sen</h3>
<p>Phân khu <a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">đất nền Đầm Sen</a> gồm các lô 100 – 150 m², lô mặt tiền Nguyễn Phước Lan, Minh Mạng khoảng 200 m² và quỹ đất biệt thự view sông. Giá tham khảo khi mở bán từ khoảng 4,8 tỷ/lô. Chi tiết tại bài <a href="/dat-nen-dam-sen-sun-riverpolis-gia-phap-ly/">giá và pháp lý đất nền Đầm Sen</a>.</p>

<h2>Sun Riverpolis phù hợp với ai?</h2>
<ul>
<li><strong>Gia đình mua để ở:</strong> căn hộ FourS Tower với tiện ích nội khu, môi trường ven sông.</li>
<li><strong>Người muốn tự xây nhà:</strong> đất nền Đầm Sen có sổ đỏ lâu dài, diện tích phổ biến 100 – 125 m².</li>
<li><strong>Nhà đầu tư trung – dài hạn:</strong> đón đầu hạ tầng phía Nam như cụm nút giao cầu Hòa Xuân (2026 – 2029).</li>
</ul>

<h2>Lưu ý trước khi mua</h2>
<p>Sun Riverpolis là khu đô thị quy mô lớn đang hình thành, tiện ích ngoại khu và mật độ dân cư cần thời gian để hoàn thiện. Quy mô và số liệu giữa các nguồn chưa hoàn toàn thống nhất, vì vậy bạn nên đối chiếu thông tin trong hợp đồng và văn bản của chủ đầu tư.</p>
<p>Xem thêm bức tranh chung khu vực tại bài <a href="/bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026/">hạ tầng Hòa Xuân – Hòa Quý và bất động sản Nam Đà Nẵng</a>, hoặc các dự án khác tại <a href="/khu-vuc/ngu-hanh-son/">khu vực Ngũ Hành Sơn</a>.</p>

<h2>Sun Riverpolis so với Sun NeO City</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Sun Riverpolis</th><th>Sun NeO City</th></tr></thead>
<tbody>
<tr><td>Khu vực</td><td>Hòa Quý, Ngũ Hành Sơn</td><td>Hòa Xuân, Cẩm Lệ</td></tr>
<tr><td>Căn hộ</td><td>FourS Tower</td><td>Cora Tower, Spana Tower, S-Light Tower</td></tr>
<tr><td>Thấp tầng</td><td>Đất nền Đầm Sen, biệt thự view sông</td><td>Sunneva Island</td></tr>
<tr><td>Điểm mạnh</td><td>Gần biển, cảnh quan sông nước</td><td>Gần cầu Hòa Xuân, gần trung tâm hơn</td></tr>
</tbody>
</table>
<p>Hai khu đô thị bổ trợ nhau: Sun NeO City thuận tiện về trung tâm, Sun Riverpolis yên tĩnh và gần biển hơn. Nếu đang phân vân giữa các tòa căn hộ, xem bài <a href="/so-sanh-fours-tower-spana-tower-s-light-tower/">so sánh FourS Tower, Spana Tower, S-Light Tower</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận sơ đồ phân khu, bảng giá căn hộ FourS Tower và quỹ lô đất nền Đầm Sen đang có tại Sun Riverpolis.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Riverpolis: khu đô thị ven sông Hòa Quý Đà Nẵng',
			'desc'      => 'Sun Riverpolis của Sun Group tại Hòa Quý: vị trí, quy mô, phân khu FourS Tower và đất nền Đầm Sen. Gọi Hoàng Hiệp 0904 567 009 nhận bảng giá.',
			'points'    => array(
				'Sun Riverpolis nằm tại Hòa Quý, Ngũ Hành Sơn, ba mặt giáp sông, cách biển chưa đến 2 km.',
				'Quy mô khoảng 482,8 ha (theo VnExpress), thuộc hệ sinh thái hơn 1.000 ha cùng Sun NeO City.',
				'Hai sản phẩm chính: đất nền Đầm Sen (từ 8/2025) và căn hộ FourS Tower (từ 3/2026).',
			),
			'faq'       => array(
				array( 'Sun Riverpolis ở đâu?', 'Tại phường Hòa Quý (cũ), quận Ngũ Hành Sơn, phía Nam Đà Nẵng, thuộc khu đô thị Nam Hòa Xuân.' ),
				array( 'Sun Riverpolis có những sản phẩm gì?', 'Hiện có căn hộ FourS Tower và đất nền Đầm Sen, cùng quỹ đất nhà phố, biệt thự ven sông.' ),
				array( 'Sun Riverpolis và Sun NeO City khác nhau thế nào?', 'Sun NeO City ở Hòa Xuân với các tòa Cora, Spana, S-Light; Sun Riverpolis ở Hòa Quý với FourS Tower và đất nền Đầm Sen. Hai khu cùng thuộc hệ sinh thái hơn 1.000 ha của Sun Group.' ),
			),
		),
		'sources'  => array( 'https://vnexpress.net/sun-riverpolis-khu-do-thi-ven-song-tai-da-nang-4504158.html', 'https://dantri.com.vn/kinh-doanh/sun-riverpolis-khu-do-thi-ven-song-co-vi-tri-dac-dia-o-da-nang-20220907113809563.htm', 'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm' ),
	);

	$posts[] = array(
		'slug'     => 'dat-nen-dam-sen-sun-riverpolis-gia-phap-ly',
		'title'    => 'Đất nền Đầm Sen Sun Riverpolis: giá bán, pháp lý và cách chọn lô',
		'excerpt'  => 'Đất nền Đầm Sen thuộc Sun Riverpolis: khoảng 900 lô 100 – 150 m², giá tham khảo từ khoảng 4,8 tỷ/lô, sổ đỏ lâu dài. Cập nhật 10/2026.',
		'keyword'  => 'đất nền Đầm Sen',
		'project'  => 'dat-nen-dam-sen-sun-riverpolis',
		'week'     => 3,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Đất nền Đầm Sen là phân khu đất nền của Sun Riverpolis (Hòa Quý, Nam Đà Nẵng) do Sun Group mở bán từ ngày 9/8/2025, gồm khoảng 900 lô diện tích 100 – 150 m². Giá tham khảo khi mở bán từ khoảng 4,8 tỷ/lô, tương đương khoảng 40 – 48 triệu/m²; pháp lý sổ đỏ lâu dài theo các đơn vị phân phối. Thông tin cập nhật tháng 10/2026.</p>

<h2>Tổng quan đất nền Đầm Sen</h2>
<p><a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">Đất nền Đầm Sen</a> nằm trong khu đô thị <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a>, phường Hòa Quý (cũ), Ngũ Hành Sơn. Phân khu được mô tả có bốn mặt giáp sông, các lô mặt tiền Nguyễn Phước Lan, Minh Mạng và dãy đất biệt thự view sông gần cầu Trung Lương, đối diện Sunneva Island.</p>
<p>Kích thước lô phổ biến: 100 m² (5 x 20 m), 125 m² (5 x 25 m), 150 m² (7,5 x 25 m); lô mặt tiền trục chính khoảng 200 m².</p>

<h2>Giá đất nền Đầm Sen tham khảo</h2>
<table>
<thead><tr><th>Loại lô / Block</th><th>Diện tích</th><th>Đường</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Lô 100 m² (169 lô)</td><td>100 m²</td><td>7,5 m</td><td>Từ khoảng 4,8 tỷ</td></tr>
<tr><td>Lô 125 m² (101 lô)</td><td>125 m²</td><td>7,5 m</td><td>Liên hệ</td></tr>
<tr><td>Lô 150 m² (9 lô)</td><td>150 m²</td><td>7,5 m</td><td>Liên hệ</td></tr>
<tr><td>Block B2-122</td><td>–</td><td>–</td><td>Khoảng 5,2 – 5,4 tỷ</td></tr>
<tr><td>Block B2-116</td><td>–</td><td>–</td><td>Khoảng 5,4 – 5,5 tỷ</td></tr>
<tr><td>Block B2-111</td><td>–</td><td>–</td><td>Khoảng 6 tỷ</td></tr>
<tr><td>Block B2-157</td><td>–</td><td>–</td><td>Khoảng 8 tỷ</td></tr>
<tr><td>Mặt tiền Nguyễn Phước Lan, Minh Mạng</td><td>Khoảng 200 m²</td><td>Trục chính</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Bảng trên là giá tham khảo thời điểm mở bán, tổng hợp từ các sàn phân phối. Trên thị trường thứ cấp năm 2026, các sàn ghi nhận lô 100 m² khoảng 4 – 5,5 tỷ, lô lớn 200 – 210 m² có thể lên khoảng 8 – 13,8 tỷ tùy vị trí, hướng. Giá chính xác phụ thuộc từng lô, hãy yêu cầu bảng hàng cập nhật trước khi quyết định.</p>

<h2>Pháp lý đất nền Đầm Sen</h2>
<p>Theo thông tin từ các đơn vị phân phối, đất nền Đầm Sen có <strong>sổ đỏ lâu dài</strong>, có thể sang tên. Dù vậy, người mua vẫn nên tự kiểm tra:</p>
<ul>
<li>Bản gốc giấy chứng nhận quyền sử dụng đất, đúng số thửa, tờ bản đồ, diện tích.</li>
<li>Thông tin quy hoạch lô: mật độ xây dựng, số tầng, chỉ giới xây dựng.</li>
<li>Tình trạng thế chấp, tranh chấp; hợp đồng chuyển nhượng phải công chứng.</li>
<li>Với hàng chuyển nhượng lại, kiểm tra người bán đúng là chủ sở hữu trên sổ.</li>
</ul>

<h2>Cách chọn lô đất nền Đầm Sen</h2>
<h3>Mua để xây nhà ở</h3>
<p>Ưu tiên lô 100 – 125 m² đường 7,5 m, gần công viên, trường học nội khu, hướng Đông Nam hoặc Nam. Lô nhỏ giúp tổng tiền vừa sức, dễ xây nhà phố 3 – 4 tầng.</p>
<h3>Mua để đầu tư</h3>
<p>Lô mặt tiền trục chính hoặc lô view sông có tính thanh khoản và khả năng kinh doanh tốt hơn, nhưng tổng tiền lớn. Nên giữ trung – dài hạn để hưởng lợi từ hạ tầng như cụm nút giao cầu Hòa Xuân (2026 – 2029).</p>
<h3>Biệt thự view sông</h3>
<p>Quỹ đất biệt thự gần cầu Trung Lương khoảng 68 – 92 lô và dãy đối diện Sunneva Island khoảng 24 lô, phù hợp khách tìm không gian sống rộng. Giá từng lô đang cập nhật theo đợt, liên hệ để nhận danh sách.</p>

<h2>So với đất nền lân cận</h2>
<p>Nếu ngân sách thấp hơn, bạn có thể tham khảo <a href="/du-an/dat-nen-con-dau-hoa-xuan/">đất nền Cồn Dầu Hòa Xuân</a> hoặc <a href="/du-an/dat-nen-vo-chi-cong/">đất nền Võ Chí Công</a>. Danh sách lô đang bán có tại trang <a href="/mua-ban/dat-nen/">mua bán đất nền Đà Nẵng</a>. Muốn hiểu tác động hạ tầng, đọc bài <a href="/bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026/">bất động sản Nam Đà Nẵng 2026</a>.</p>

<h2>Quy trình mua đất nền Đầm Sen</h2>
<ol>
<li><strong>Chọn lô:</strong> xem sơ đồ phân lô, đối chiếu hướng, lộ giới, khoảng cách tới sông và tiện ích.</li>
<li><strong>Kiểm tra pháp lý:</strong> bản gốc sổ, thông tin quy hoạch, tình trạng thế chấp.</li>
<li><strong>Đặt cọc:</strong> hợp đồng đặt cọc ghi rõ số tiền, thời hạn công chứng, điều kiện hoàn cọc.</li>
<li><strong>Công chứng chuyển nhượng:</strong> thanh toán theo thỏa thuận, nộp thuế, phí.</li>
<li><strong>Sang tên:</strong> nộp hồ sơ đăng ký biến động tại cơ quan đất đai và nhận sổ mang tên mình.</li>
</ol>
<p>Với lô mua từ chủ đầu tư, quy trình có thể khác (hợp đồng mua bán, tiến độ thanh toán), cần đọc kỹ chính sách từng đợt.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng hàng đất nền Đầm Sen theo block, kiểm tra pháp lý từng lô và tư vấn chọn lô theo ngân sách.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đất nền Đầm Sen Sun Riverpolis: giá, pháp lý 2026',
			'desc'      => 'Đất nền Đầm Sen Sun Riverpolis: khoảng 900 lô 100 – 150 m², giá tham khảo từ 4,8 tỷ, sổ đỏ lâu dài. Gọi Hoàng Hiệp 0904 567 009 nhận bảng hàng.',
			'points'    => array(
				'Khoảng 900 lô 100 – 150 m², mở bán từ 9/8/2025 tại Sun Riverpolis, Hòa Quý.',
				'Giá tham khảo khi mở bán từ khoảng 4,8 tỷ/lô, khoảng 40 – 48 triệu/m².',
				'Pháp lý sổ đỏ lâu dài theo đơn vị phân phối; cần kiểm tra sổ, quy hoạch từng lô.',
			),
			'faq'       => array(
				array( 'Đất nền Đầm Sen giá bao nhiêu?', 'Giá tham khảo khi mở bán từ khoảng 4,8 tỷ/lô 100 m²; một số block khoảng 5,2 – 8 tỷ. Giá thay đổi theo vị trí và thời điểm.' ),
				array( 'Đất nền Đầm Sen có sổ đỏ chưa?', 'Theo các đơn vị phân phối, đất nền Đầm Sen có sổ đỏ lâu dài. Người mua nên kiểm tra bản gốc và hồ sơ quy hoạch từng lô.' ),
				array( 'Diện tích lô đất nền Đầm Sen là bao nhiêu?', 'Phổ biến 100 m² (5 x 20), 125 m² (5 x 25), 150 m² (7,5 x 25); lô mặt tiền trục chính khoảng 200 m².' ),
			),
		),
		'sources'  => array( 'https://datnenhoaxuan.com/mo-ban-riverpolis-dam-sen', 'https://kingreal.com/to-hop-sun-riverpolis-da-nang/', 'https://datnenhoaxuan.com/mo-ban-111-116-122-157-dam-sen-nam-hoa-xuan', 'https://batdongsan.com.vn/ban-dat-phuong-hoa-quy-prj-han-river-village-nam-hoa-xuan/sun-group-mo-ban-900-lo-nen-khu-dam-sen-gia-goc-pr43762102' ),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026',
		'title'    => 'Bất động sản Nam Đà Nẵng 2026: hạ tầng Hòa Xuân – Hòa Quý và giá nhà đất',
		'excerpt'  => 'Bất động sản Nam Đà Nẵng 2026: hạ tầng Hòa Xuân – Hòa Quý đang thay đổi ra sao và mặt bằng giá căn hộ, đất nền khu vực hiện ở mức nào.',
		'keyword'  => 'bất động sản Nam Đà Nẵng',
		'project'  => 'sun-neo-city',
		'week'     => 3,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Bất động sản Nam Đà Nẵng năm 2026 được dẫn dắt bởi hai yếu tố: hạ tầng giao thông Hòa Xuân – Hòa Quý được nâng cấp và nguồn cung lớn từ các khu đô thị Sun Group. Mặt bằng giá căn hộ mới khu vực tham khảo khoảng 50 – 60 triệu/m², đất nền Nam Hòa Xuân phổ biến khoảng 2,2 – 4,2 tỷ/lô nội khu. Bài viết cập nhật tháng 10/2026.</p>

<h2>Hạ tầng Hòa Xuân – Hòa Quý 2026</h2>
<h3>Cụm nút giao cầu Hòa Xuân hơn 1.378 tỷ đồng</h3>
<p>Đây là dự án quan trọng nhất với phía Nam: giữ cầu Hòa Xuân hiện hữu, xây thêm cầu mới phía hạ lưu dài khoảng 303,5 m, rộng 14 m, kết hợp nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long với cầu vượt, hầm chui. Dự án thực hiện giai đoạn 2026 – 2029. Phân tích chi tiết tại bài <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao cầu Hòa Xuân và bất động sản Nam Đà Nẵng</a>.</p>
<h3>Mạng lưới cầu và trục chính</h3>
<p>Khu vực đã có các cầu Cẩm Lệ, Nguyễn Tri Phương, Hòa Xuân, Trung Lương kết nối về trung tâm, cùng các trục Nguyễn Phước Lan, Minh Mạng, đường 29/3. Phía Đông là trục Võ Chí Công nối ra biển và về Hội An.</p>
<h3>Lợi thế sau hợp nhất Đà Nẵng – Quảng Nam</h3>
<p>Từ 1/7/2025, Hòa Xuân, Hòa Quý không còn là vùng giáp ranh mà nằm giữa trục phát triển Đà Nẵng – Điện Bàn – Hội An, thuận lợi cho đầu tư hạ tầng liền mạch.</p>

<h2>Mặt bằng giá bất động sản Nam Đà Nẵng</h2>
<table>
<thead><tr><th>Sản phẩm</th><th>Dự án / khu vực</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Căn hộ mới</td><td><a href="/du-an/fours-tower/">FourS Tower</a> (Hòa Quý)</td><td>Khoảng 50 – 60 triệu/m²; Studio từ khoảng 1,7 tỷ</td></tr>
<tr><td>Căn hộ mới</td><td><a href="/du-an/spana-tower/">Spana Tower</a> (chân cầu Hòa Xuân)</td><td>Khoảng 60 triệu/m² (dao động theo nguồn)</td></tr>
<tr><td>Căn hộ mới</td><td><a href="/du-an/s-light-tower/">S-Light Tower</a> (Hòa Xuân)</td><td>Từ khoảng 2,4 tỷ/căn</td></tr>
<tr><td>Đất nền dự án</td><td><a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">Đất nền Đầm Sen</a></td><td>Từ khoảng 4,8 tỷ/lô 100 m² (khi mở bán)</td></tr>
<tr><td>Đất nền thứ cấp</td><td>Nam Hòa Xuân, lô nội khu</td><td>Khoảng 2,2 – 4,2 tỷ/lô (tin rao 9/2026)</td></tr>
<tr><td>Đất nền thứ cấp</td><td>Nam Hòa Xuân, đường 7,5 m / 10,5 m</td><td>Khoảng 3,6 – 4 tỷ / 6 – 8 tỷ</td></tr>
</tbody>
</table>
<p>Số liệu tổng hợp từ báo chí, trang phân phối và tin rao, chỉ mang tính tham khảo. Giá giao dịch thực tế phụ thuộc vị trí, hướng, pháp lý từng sản phẩm.</p>

<h2>Phân khúc nào hưởng lợi rõ nhất?</h2>
<h3>Căn hộ trục Nguyễn Phước Lan – 29/3</h3>
<p>Các tòa thuộc <a href="/du-an/sun-neo-city/">Sun NeO City</a> gần cầu Hòa Xuân hưởng lợi trực tiếp khi nút giao hoàn thành, thời gian về Hải Châu rút ngắn và ổn định hơn.</p>
<h3>Đất nền có sổ, đã có hạ tầng</h3>
<p>Đất nền Nam Hòa Xuân, Đầm Sen phù hợp người muốn tự xây nhà. Phân khúc này thường đi trước căn hộ khi hạ tầng có thông tin mới.</p>
<h3>Biệt thự, nhà phố ven sông</h3>
<p>Quỹ đất ven sông Cổ Cò, sông Cẩm Lệ có giới hạn, phù hợp người mua để ở lâu dài, ít chịu áp lực bán.</p>

<h2>Rủi ro cần lưu ý</h2>
<ul>
<li><strong>Thi công kéo dài:</strong> trong giai đoạn 2026 – 2029, giao thông quanh chân cầu Hòa Xuân có thể bị ảnh hưởng.</li>
<li><strong>Nguồn cung căn hộ lớn:</strong> FourS Tower khoảng 2.291 căn, Spana Tower khoảng 1.281 căn, S-Light Tower gần 800 căn, cộng thêm Cora Tower.</li>
<li><strong>Kỳ vọng giá đi trước hạ tầng:</strong> không nên mua bằng đòn bẩy cao chỉ dựa vào thông tin dự án hạ tầng.</li>
</ul>

<h2>Góc nhìn của Hoàng Hiệp</h2>
<p>Nam Đà Nẵng là khu vực có câu chuyện tăng trưởng rõ ràng, nhưng nên xuống tiền theo nhu cầu thật. Người mua ở có thể chọn căn hộ bàn giao sớm hoặc đất nền đã có sổ; nhà đầu tư nên xác định thời gian nắm giữ tối thiểu 3 – 5 năm. Xem toàn bộ dự án khu vực tại <a href="/khu-vuc/cam-le/">khu vực Cẩm Lệ</a> và <a href="/khu-vuc/ngu-hanh-son/">Ngũ Hành Sơn</a>.</p>

<h2>Nên chọn sản phẩm nào theo ngân sách?</h2>
<table>
<thead><tr><th>Ngân sách</th><th>Gợi ý</th></tr></thead>
<tbody>
<tr><td>Khoảng 2 – 3 tỷ</td><td>Căn Studio, 1PN+ tại FourS Tower, S-Light Tower</td></tr>
<tr><td>Khoảng 3 – 5 tỷ</td><td>Căn 2PN – 3PN hoặc đất nền nội khu Nam Hòa Xuân</td></tr>
<tr><td>Trên 5 tỷ</td><td>Đất nền Đầm Sen block đẹp, lô mặt tiền, đất biệt thự view sông</td></tr>
</tbody>
</table>
<p>Ngân sách trên là gợi ý theo giá tham khảo, chưa tính thuế phí và chi phí hoàn thiện.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tư vấn chọn căn hộ, đất nền Nam Đà Nẵng phù hợp ngân sách và mục tiêu nắm giữ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Nam Đà Nẵng 2026: hạ tầng và giá',
			'desc'      => 'Bất động sản Nam Đà Nẵng 2026: cụm nút giao cầu Hòa Xuân, giá căn hộ, đất nền Hòa Xuân – Hòa Quý. Gọi Hoàng Hiệp 0904 567 009 để được tư vấn.',
			'points'    => array(
				'Cụm nút giao cầu Hòa Xuân hơn 1.378 tỷ đồng, thực hiện 2026 – 2029, là động lực chính phía Nam.',
				'Căn hộ mới Sun Group tham khảo khoảng 50 – 60 triệu/m²; đất nền Nam Hòa Xuân khoảng 2,2 – 4,2 tỷ/lô nội khu.',
				'Rủi ro: nguồn cung căn hộ lớn, thi công kéo dài, kỳ vọng giá đi trước hạ tầng.',
			),
			'faq'       => array(
				array( 'Bất động sản Nam Đà Nẵng gồm những khu nào?', 'Chủ yếu là Hòa Xuân (Cẩm Lệ), Hòa Quý (Ngũ Hành Sơn) với các khu đô thị Sun NeO City, Sun Riverpolis, khu đô thị sinh thái Hòa Xuân.' ),
				array( 'Giá căn hộ Nam Đà Nẵng 2026 bao nhiêu?', 'Căn hộ mới của Sun Group tham khảo khoảng 50 – 60 triệu/m², căn Studio từ khoảng 1,7 tỷ tùy dự án và đợt bán.' ),
				array( 'Khi nào cụm nút giao cầu Hòa Xuân hoàn thành?', 'Dự án thực hiện giai đoạn 2026 – 2029.' ),
				array( 'Có nên đầu tư bất động sản Nam Đà Nẵng lúc này?', 'Phù hợp nếu nắm giữ trung – dài hạn và không dùng đòn bẩy cao; nên ưu tiên sản phẩm pháp lý rõ, bàn giao sớm.' ),
			),
		),
		'sources'  => array( 'https://tuoitre.vn/tai-sao-nam-da-nang-thanh-diem-nong-hut-gioi-dau-tu-dia-oc-20260430213905157.htm', 'https://plo.vn/da-nang-duyet-du-an-cum-nut-giao-cau-hoa-xuan-hon-1378-ti-dong-post899700.html', 'https://www.nhatot.com/tags/gia-dat-nam-hoa-xuan' ),
	);

	/* ======================= TUẦN 4 ======================= */

	$posts[] = array(
		'slug'     => 'casamia-balanca-hoi-an-tong-quan-du-an',
		'title'    => 'Casamia Balanca Hội An: tổng quan khu đô thị sinh thái 31,1 ha',
		'excerpt'  => 'Casamia Balanca Hội An là khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh: vị trí, quy mô, loại biệt thự, tiện ích, tiến độ.',
		'keyword'  => 'Casamia Balanca Hội An',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 4,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Casamia Balanca Hội An (Khu đô thị Cồn Tiến) là khu đô thị sinh thái ven sông rộng 31,1 ha của Tập đoàn Đạt Phương tại xã Cẩm Thanh, Hội An, nằm giữa rừng dừa Bảy Mẫu. Dự án ra mắt tháng 6/2025, cung cấp biệt thự, shophouse sở hữu lâu dài, giá tham khảo từ khoảng 10 – 20 tỷ/căn. Thông tin cập nhật tháng 10/2026.</p>

<h2>Thông tin tổng quan Casamia Balanca Hội An</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Tên thương mại</td><td>Casamia Balanca Hội An (Khu đô thị Cồn Tiến)</td></tr>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Đạt Phương</td></tr>
<tr><td>Thiết kế</td><td>VTN Architects / ENCITY</td></tr>
<tr><td>Vị trí</td><td>Xã Cẩm Thanh, Hội An (Quảng Nam cũ), nay thuộc Đà Nẵng</td></tr>
<tr><td>Quy mô</td><td>31,1 ha; mật độ xây dựng khoảng 38%, khoảng 8 ha cây xanh, mặt nước</td></tr>
<tr><td>Sản phẩm</td><td>Theo công bố ban đầu: 297 biệt thự, 74 shophouse, 3 tòa khách sạn; một số nguồn cập nhật 363 sản phẩm thấp tầng</td></tr>
<tr><td>Sở hữu</td><td>Lâu dài với người Việt Nam</td></tr>
<tr><td>Ra mắt</td><td>Tháng 6/2025</td></tr>
</tbody>
</table>

<h2>Vị trí: giữa rừng dừa, bên trục Võ Chí Công</h2>
<p><a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a> nằm trong vùng rừng dừa Bảy Mẫu thuộc Khu dự trữ sinh quyển thế giới Cù Lao Chàm – Hội An. Dự án tiếp giáp trục đường 38 m (Võ Chí Công) nối Đà Nẵng – Hội An – sân bay Chu Lai, có dòng sông tự nhiên chảy trong nội khu.</p>
<p>Từ dự án có thể di chuyển nhanh về phố cổ Hội An, biển An Bàng, Cửa Đại. Đây là lợi thế lớn cho cả nhu cầu ở nghỉ dưỡng lẫn khai thác du lịch.</p>

<h2>Các dòng sản phẩm</h2>
<p>Theo các đơn vị phân phối, dự án gồm các dòng The Boutique, Park Home, Park Villa, Forestside Villa và Riverside (Waterside) Villa. Cơ cấu được giới thiệu gồm khoảng 173 biệt thự đơn lập, 116 biệt thự song lập và 74 shophouse.</p>
<table>
<thead><tr><th>Dòng sản phẩm</th><th>Đặc điểm</th></tr></thead>
<tbody>
<tr><td>Forestside Villa</td><td>Khoảng 106 căn, đất khoảng 250 – 426 m², 2 – 3 tầng, nằm giữa kênh rạch và rừng dừa</td></tr>
<tr><td>Riverside Villa</td><td>Biệt thự ven sông, một số căn có bến du thuyền riêng</td></tr>
<tr><td>Park Villa, Park Home</td><td>Biệt thự, nhà vườn hướng công viên nội khu</td></tr>
<tr><td>The Boutique</td><td>Shophouse phục vụ kinh doanh, dịch vụ</td></tr>
</tbody>
</table>

<h2>Tiện ích nội khu</h2>
<ul>
<li>Bến du thuyền, clubhouse, nhà hàng, spa, phòng gym, sân thể thao.</li>
<li>Khu vui chơi trẻ em, công viên cây xanh, bungalow.</li>
<li>Trung tâm thương mại, trung tâm hội nghị, trường mầm non quốc tế, khách sạn.</li>
</ul>

<h2>Tiến độ dự án</h2>
<table>
<thead><tr><th>Thời gian</th><th>Mốc</th></tr></thead>
<tbody>
<tr><td>2022</td><td>Khởi công hạ tầng</td></tr>
<tr><td>4/2025</td><td>ĐHĐCĐ Đạt Phương công bố kế hoạch mở bán 120 biệt thự cuối quý 2/2025</td></tr>
<tr><td>6/2025</td><td>Ra mắt dự án</td></tr>
<tr><td>4/2026</td><td>ĐHĐCĐ 2026: tiếp tục hoàn thiện thủ tục cấp giấy chứng nhận trong năm; kế hoạch bàn giao khoảng 100 căn trong tháng 11 – 12/2026</td></tr>
</tbody>
</table>

<h2>Casamia Balanca phù hợp với ai?</h2>
<p>Dự án phù hợp với khách mua biệt thự nghỉ dưỡng để ở dài ngày, gia đình muốn sống trong môi trường sinh thái gần phố cổ, hoặc nhà đầu tư chấp nhận vốn lớn, nắm giữ dài hạn. Nếu cần sản phẩm nhỏ hơn, bạn có thể tham khảo <a href="/du-an/casamia-calm-hoi-an/">Casamia Calm</a> hoặc <a href="/du-an/casamia-hoi-an/">Casamia Hội An</a> cùng chủ đầu tư.</p>
<p>Đọc tiếp các bài trong cụm: <a href="/gia-biet-thu-casamia-balanca-2026/">giá biệt thự Casamia Balanca 2026</a>, <a href="/chinh-sach-ban-hang-casamia-balanca/">chính sách bán hàng</a> và <a href="/phap-ly-so-hong-casamia-balanca/">pháp lý, sổ hồng Casamia Balanca</a>.</p>

<h2>Ưu điểm và điểm cần cân nhắc</h2>
<h3>Ưu điểm</h3>
<ul>
<li>Môi trường sinh thái hiếm có: rừng dừa, sông nội khu, mật độ xây dựng thấp.</li>
<li>Gần phố cổ Hội An và biển, thuận lợi cho cả ở lẫn khai thác du lịch.</li>
<li>Sở hữu lâu dài với người Việt Nam; chủ đầu tư đã phát triển Casamia Hội An, Casamia Calm.</li>
</ul>
<h3>Cần cân nhắc</h3>
<ul>
<li>Tổng tiền lớn, thanh khoản biệt thự thường chậm hơn căn hộ.</li>
<li>Thủ tục cấp giấy chứng nhận từng lô đang được hoàn thiện, cần theo dõi sát.</li>
<li>Mùa mưa cuối năm ở Hội An ảnh hưởng đến khai thác du lịch.</li>
</ul>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận mặt bằng phân khu, quỹ căn Casamia Balanca Hội An đang mở và lịch tham quan nhà mẫu.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Casamia Balanca Hội An: tổng quan dự án 31,1 ha',
			'desc'      => 'Casamia Balanca Hội An: khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh, biệt thự ven sông sở hữu lâu dài. Gọi Hoàng Hiệp 0904 567 009.',
			'points'    => array(
				'Khu đô thị sinh thái 31,1 ha của Đạt Phương tại Cẩm Thanh, Hội An, giữa rừng dừa Bảy Mẫu.',
				'Biệt thự Forestside, Riverside, Park Villa và shophouse The Boutique, sở hữu lâu dài.',
				'Ra mắt 6/2025; kế hoạch bàn giao khoảng 100 căn trong tháng 11 – 12/2026.',
			),
			'faq'       => array(
				array( 'Casamia Balanca Hội An ở đâu?', 'Tại xã Cẩm Thanh, Hội An, trong vùng rừng dừa Bảy Mẫu, tiếp giáp trục Võ Chí Công.' ),
				array( 'Chủ đầu tư Casamia Balanca là ai?', 'Tập đoàn Đạt Phương, cũng là chủ đầu tư Casamia Hội An và Casamia Calm.' ),
				array( 'Casamia Balanca có bao nhiêu căn?', 'Công bố ban đầu gồm 297 biệt thự, 74 shophouse và 3 khách sạn; một số nguồn cập nhật 363 sản phẩm thấp tầng.' ),
				array( 'Khi nào Casamia Balanca bàn giao?', 'Theo ĐHĐCĐ 2026 của Đạt Phương, kế hoạch bàn giao khoảng 100 căn trong tháng 11 – 12/2026.' ),
			),
		),
		'sources'  => array( 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg--cho-doi--cu-hich--tu-du-an-casamia-balanca-127046.htm', 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg-trien-vong-tai-dinh-gia-tu-viec-mo-ban-du-an-casamia-balanca-141395.htm', 'https://diendandoanhnghiep.vn/casamia-balanca-hoi-an-chuan-song-toan-cau-giua-long-di-san-10159413.html', 'https://casamiabalanca.com/' ),
	);

	$posts[] = array(
		'slug'     => 'gia-biet-thu-casamia-balanca-2026',
		'title'    => 'Giá Casamia Balanca 2026: bảng giá biệt thự tham khảo theo dòng sản phẩm',
		'excerpt'  => 'Giá Casamia Balanca 2026 tham khảo từ khoảng 10 – 20 tỷ/căn, Forestside từ khoảng 16 tỷ. Cách tính tổng tiền và yếu tố ảnh hưởng giá.',
		'keyword'  => 'giá Casamia Balanca',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 4,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Giá Casamia Balanca năm 2026 tham khảo phổ biến từ khoảng 10 – 20 tỷ/căn tùy dòng sản phẩm và vị trí; biệt thự Forestside được giới thiệu từ khoảng 16 tỷ. Một số trang phân phối ghi mức thấp nhất từ khoảng 8,8 tỷ/căn. Đây là giá tham khảo tổng hợp, cập nhật tháng 10/2026 – giá chính thức thay đổi theo từng đợt mở bán.</p>

<h2>Bảng giá Casamia Balanca tham khảo</h2>
<table>
<thead><tr><th>Dòng sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Sản phẩm giá thấp nhất</td><td>–</td><td>Từ khoảng 8,8 tỷ/căn</td><td>Trang phân phối</td></tr>
<tr><td>Biệt thự (dải chung)</td><td>–</td><td>Khoảng 10 – 20 tỷ/căn</td><td>Báo chí, phân phối</td></tr>
<tr><td>Forestside Villa</td><td>Khoảng 250 – 426 m²</td><td>Từ khoảng 16 tỷ/căn</td><td>Trang phân phối</td></tr>
<tr><td>Riverside Villa</td><td>–</td><td>Đang cập nhật theo đợt</td><td>Liên hệ</td></tr>
<tr><td>Park Villa, Park Home</td><td>–</td><td>Đang cập nhật theo đợt</td><td>Liên hệ</td></tr>
<tr><td>Shophouse The Boutique</td><td>–</td><td>Đang cập nhật theo đợt</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Theo Tạp chí Công Thương, giá khởi điểm của biệt thự đơn lập Casamia Balanca khoảng 55 triệu/m² đất (thời điểm 12/2024). Với lô 250 m², tổng giá trị khoảng 13,75 tỷ đồng. Đây là cách ước tính hữu ích để so sánh các căn có diện tích khác nhau.</p>

<h2>Yếu tố ảnh hưởng đến giá Casamia Balanca</h2>
<h3>Vị trí trong dự án</h3>
<p>Căn ven sông, có bến thuyền riêng hoặc view rừng dừa thường có giá cao hơn căn nằm sâu trong nội khu. Căn góc, căn gần clubhouse, công viên cũng được định giá cao hơn.</p>
<h3>Loại hình và diện tích</h3>
<p>Biệt thự đơn lập có diện tích đất lớn và quyền riêng tư cao hơn song lập. Tổng tiền tăng theo diện tích đất, nên khi so sánh nên quy về đơn giá/m² đất.</p>
<h3>Hiện trạng bàn giao</h3>
<p>Kiểm tra căn bàn giao xây thô hay hoàn thiện mặt ngoài, có hồ bơi riêng hay không. Chi phí hoàn thiện nội thất biệt thự có thể chiếm phần đáng kể trong tổng vốn.</p>
<h3>Chính sách thanh toán</h3>
<p>Giá thực trả phụ thuộc chiết khấu thanh toán nhanh, hỗ trợ lãi suất. Xem chi tiết tại bài <a href="/chinh-sach-ban-hang-casamia-balanca/">chính sách bán hàng Casamia Balanca</a>.</p>

<h2>Cách tính tổng chi phí sở hữu</h2>
<table>
<thead><tr><th>Khoản mục</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Giá căn trên hợp đồng</td><td>Sau chiết khấu (nếu có)</td></tr>
<tr><td>Thuế, lệ phí trước bạ, phí cấp giấy</td><td>Theo quy định tại thời điểm cấp giấy chứng nhận</td></tr>
<tr><td>Hoàn thiện nội thất, cảnh quan</td><td>Tùy tiêu chuẩn bạn chọn</td></tr>
<tr><td>Phí quản lý</td><td>Một số chính sách tặng 2 – 3 năm đầu (theo phân phối)</td></tr>
<tr><td>Chi phí vốn vay</td><td>Sau thời gian ân hạn lãi (nếu có)</td></tr>
</tbody>
</table>

<h2>So sánh với biệt thự khu vực</h2>
<p>Trong phân khúc <a href="/loai-du-an/biet-thu/">biệt thự</a> Hội An – Nam Đà Nẵng, Casamia Balanca có lợi thế là khu đô thị sinh thái quy mô lớn, sở hữu lâu dài cho người Việt. Bạn có thể đối chiếu với <a href="/du-an/casamia-calm-hoi-an/">Casamia Calm</a> và các sản phẩm tại trang <a href="/mua-ban/biet-thu/">mua bán biệt thự</a> hoặc <a href="/khu-vuc/hoi-an/">khu vực Hội An</a>.</p>

<h2>Lời khuyên của Hoàng Hiệp</h2>
<p>Đừng chọn căn chỉ vì giá thấp nhất trong bảng hàng. Hãy so sánh đơn giá/m² đất, hướng, khoảng cách tới sông và tiện ích, sau đó tính tổng chi phí sở hữu. Nếu mua để khai thác cho thuê, đọc thêm bài <a href="/cho-thue-biet-thu-casamia-balanca-dong-tien/">dòng tiền cho thuê biệt thự Casamia Balanca</a>.</p>

<h2>Vì sao giá giữa các nguồn chênh nhau?</h2>
<p>Bạn sẽ thấy nhiều mức giá khác nhau trên mạng: từ 8,8 tỷ, từ 10 tỷ, từ 16 tỷ. Nguyên nhân là mỗi nguồn nói về một dòng sản phẩm, một đợt bán hoặc một thời điểm khác nhau; có nguồn tính giá trước chiết khấu, có nguồn tính sau.</p>
<p>Cách đọc đúng: hỏi rõ mã căn, diện tích đất, diện tích xây dựng, giá trước và sau chiết khấu, đã gồm VAT hay chưa. Chỉ khi cùng tiêu chí, việc so sánh mới có ý nghĩa.</p>
<h3>Giá thứ cấp</h3>
<p>Khi dự án bàn giao và có giấy chứng nhận, thị trường chuyển nhượng sẽ hình thành rõ hơn. Hiện mức giá chuyển nhượng lại đang cập nhật theo từng giao dịch, liên hệ để nhận thông tin căn cụ thể.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Casamia Balanca đợt hiện hành theo từng căn và bảng tính tổng chi phí sở hữu.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Casamia Balanca 2026: bảng giá biệt thự tham khảo',
			'desc'      => 'Giá Casamia Balanca 2026 tham khảo khoảng 10 – 20 tỷ/căn, Forestside từ 16 tỷ. Cách tính tổng chi phí. Gọi Hoàng Hiệp 0904 567 009 nhận bảng giá.',
			'points'    => array(
				'Giá tham khảo phổ biến khoảng 10 – 20 tỷ/căn; một số nguồn ghi từ khoảng 8,8 tỷ.',
				'Forestside Villa đất khoảng 250 – 426 m², giá từ khoảng 16 tỷ (theo phân phối).',
				'Đơn giá biệt thự đơn lập khoảng 55 triệu/m² đất (12/2024, theo Tạp chí Công Thương).',
			),
			'faq'       => array(
				array( 'Giá Casamia Balanca bao nhiêu?', 'Giá tham khảo phổ biến khoảng 10 – 20 tỷ/căn tùy dòng sản phẩm, vị trí; giá chính thức thay đổi theo từng đợt.' ),
				array( 'Biệt thự Forestside Casamia Balanca giá bao nhiêu?', 'Theo các trang phân phối, Forestside Villa có giá từ khoảng 16 tỷ, diện tích đất khoảng 250 – 426 m².' ),
				array( 'Giá Casamia Balanca đã gồm VAT chưa?', 'Tùy từng bảng giá và đợt bán; cần hỏi rõ giá đã gồm VAT, phí bảo trì và tiêu chuẩn bàn giao hay chưa.' ),
			),
		),
		'sources'  => array( 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg-trien-vong-tai-dinh-gia-tu-viec-mo-ban-du-an-casamia-balanca-141395.htm', 'https://estuaryresidental.com/du-an/khu-do-thi-casamia-balanca-hoi-an-chinh-sach-bang-hang-va-gia-ban/', 'https://duanbdsdanang.com/du-an/casamia-balanca-hoi-an/' ),
	);

	$posts[] = array(
		'slug'     => 'chinh-sach-ban-hang-casamia-balanca',
		'title'    => 'Chính sách Casamia Balanca: thanh toán, chiết khấu, hỗ trợ vay 2026',
		'excerpt'  => 'Chính sách Casamia Balanca: đặt cọc, tiến độ thanh toán, chiết khấu, hỗ trợ vay đến 70% theo thông tin phân phối và lưu ý khi so sánh.',
		'keyword'  => 'chính sách Casamia Balanca',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 4,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Chính sách Casamia Balanca được các đơn vị phân phối giới thiệu gồm: đặt cọc khoảng 100 triệu/căn, ký hợp đồng thanh toán 30%, phần còn lại theo tiến độ; khách không vay được chiết khấu khi thanh toán đúng tiến độ; khách vay được hỗ trợ đến 70% giá trị hợp đồng kèm ân hạn gốc, lãi. Thông tin tổng hợp, cập nhật tháng 10/2026 – chính sách có hiệu lực theo từng đợt và cần xác nhận lại trước khi ký.</p>

<h2>Tóm tắt chính sách Casamia Balanca (theo phân phối)</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Nội dung được giới thiệu</th></tr></thead>
<tbody>
<tr><td>Đặt cọc</td><td>Khoảng 100 triệu/căn</td></tr>
<tr><td>Ký hợp đồng mua bán</td><td>Thanh toán khoảng 30% (một số nguồn ghi 20 – 30%)</td></tr>
<tr><td>Thanh toán theo tiến độ</td><td>Khoảng 40%, chia nhiều đợt</td></tr>
<tr><td>Khách không vay</td><td>Chiết khấu khoảng 9% khi thanh toán đúng tiến độ</td></tr>
<tr><td>Hỗ trợ vay</td><td>Tối đa 70% giá trị hợp đồng, thời hạn đến 35 năm</td></tr>
<tr><td>Ân hạn</td><td>Ân hạn gốc, lãi suất 0% đến 24 tháng</td></tr>
<tr><td>Trả nợ trước hạn</td><td>Miễn phí trả nợ trước hạn 2 năm</td></tr>
<tr><td>Phí quản lý</td><td>Tặng 2 – 3 năm đầu</td></tr>
</tbody>
</table>
<p>Lưu ý: các nội dung trên được tổng hợp từ trang của đơn vị phân phối, chưa phải văn bản chính thức của chủ đầu tư. Thời hạn áp dụng, điều kiện và mức chiết khấu cụ thể đang cập nhật theo từng đợt, liên hệ để nhận bản chính sách mới nhất.</p>

<h2>Phương án thanh toán: chọn thế nào?</h2>
<h3>Thanh toán theo tiến độ, không vay</h3>
<p>Phù hợp khách có sẵn dòng tiền. Ưu điểm là được chiết khấu, không chịu chi phí lãi vay; nhược điểm là vốn bị khóa lớn ngay từ đầu.</p>
<h3>Vay ngân hàng có ân hạn</h3>
<p>Phù hợp khách muốn giữ vốn lưu động. Trong thời gian ân hạn, áp lực trả nợ thấp; nhưng cần tính trước khả năng trả gốc lãi khi hết ân hạn theo lãi suất thả nổi.</p>

<h2>Ví dụ cách so sánh hai phương án</h2>
<p>Giả sử căn biệt thự có giá trên hợp đồng là G. Phương án A: chiết khấu 9%, số tiền thực trả là 0,91 x G. Phương án B: không chiết khấu, vay 70% G, được ân hạn 24 tháng, sau đó tự trả lãi theo lãi suất thả nổi.</p>
<table>
<thead><tr><th>Tiêu chí</th><th>A – Không vay</th><th>B – Vay 70%</th></tr></thead>
<tbody>
<tr><td>Giá thực trả</td><td>0,91 x G</td><td>G</td></tr>
<tr><td>Vốn tự có ban đầu</td><td>Cao</td><td>Khoảng 30% G</td></tr>
<tr><td>Chi phí lãi</td><td>Không</td><td>Từ tháng thứ 25 (nếu chưa tất toán)</td></tr>
<tr><td>Phù hợp</td><td>Có sẵn tiền, mua ở</td><td>Cần giữ vốn, có thu nhập ổn định</td></tr>
</tbody>
</table>
<p>Chênh lệch 9% giá trị căn là con số lớn với sản phẩm 10 – 20 tỷ. Vì vậy hãy tính chi phí cơ hội của vốn và lãi suất sau ân hạn trước khi chọn.</p>

<h2>Checklist trước khi đặt cọc</h2>
<ul>
<li>Yêu cầu văn bản chính sách có chữ ký, dấu và thời hạn hiệu lực.</li>
<li>Hỏi rõ giá đã gồm VAT, phí bảo trì, tiêu chuẩn bàn giao.</li>
<li>Ngân hàng liên kết, lãi suất sau ân hạn, điều kiện phạt trả trước.</li>
<li>Điều khoản hoàn cọc nếu không ký được hợp đồng.</li>
<li>Tình trạng pháp lý, tiến độ cấp giấy chứng nhận – xem bài <a href="/phap-ly-so-hong-casamia-balanca/">pháp lý Casamia Balanca</a>.</li>
</ul>

<h2>Đọc thêm</h2>
<p>Xem tổng quan <a href="/casamia-balanca-hoi-an-tong-quan-du-an/">Casamia Balanca Hội An</a>, bảng <a href="/gia-biet-thu-casamia-balanca-2026/">giá Casamia Balanca 2026</a> hoặc trang dự án <a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a>. Các biệt thự khác tại Hội An có trong mục <a href="/mua-ban/biet-thu/">mua bán biệt thự</a>.</p>

<h2>Những điểm dễ hiểu nhầm trong chính sách</h2>
<ul>
<li><strong>Lãi suất 0%:</strong> thường chỉ áp dụng trong thời gian ân hạn; hết ân hạn sẽ áp lãi suất thả nổi của ngân hàng.</li>
<li><strong>Chiết khấu cộng dồn:</strong> không phải ưu đãi nào cũng cộng dồn được; hỏi rõ ưu đãi nào loại trừ nhau.</li>
<li><strong>Tặng phí quản lý:</strong> xác định rõ số năm, mức phí sau thời gian tặng.</li>
<li><strong>Thời hạn ưu đãi:</strong> chỉ áp dụng với hợp đồng ký trong khung thời gian nhất định.</li>
</ul>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bản chính sách Casamia Balanca đang áp dụng và bảng tính so sánh phương án thanh toán theo căn bạn quan tâm.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chính sách Casamia Balanca 2026: thanh toán, hỗ trợ vay',
			'desc'      => 'Chính sách Casamia Balanca: cọc 100 triệu, ký HĐ 30%, chiết khấu khi không vay, hỗ trợ vay 70%. Gọi Hoàng Hiệp 0904 567 009 nhận bản mới nhất.',
			'points'    => array(
				'Theo phân phối: cọc khoảng 100 triệu/căn, ký HĐMB 30%, 40% theo tiến độ.',
				'Khách không vay được chiết khấu khoảng 9%; khách vay được hỗ trợ đến 70%, ân hạn đến 24 tháng.',
				'Chính sách thay đổi theo đợt, cần văn bản chính thức của chủ đầu tư trước khi ký.',
			),
			'faq'       => array(
				array( 'Đặt cọc Casamia Balanca bao nhiêu?', 'Theo các đơn vị phân phối, đặt cọc khoảng 100 triệu/căn; mức cụ thể theo đợt bán.' ),
				array( 'Casamia Balanca hỗ trợ vay bao nhiêu?', 'Được giới thiệu hỗ trợ vay tối đa 70% giá trị hợp đồng, ân hạn gốc lãi đến 24 tháng, thời hạn đến 35 năm.' ),
				array( 'Không vay có được chiết khấu không?', 'Theo thông tin phân phối, khách không vay thanh toán đúng tiến độ được chiết khấu khoảng 9%.' ),
			),
		),
		'sources'  => array( 'https://estuaryresidental.com/du-an/khu-do-thi-casamia-balanca-hoi-an-chinh-sach-bang-hang-va-gia-ban/', 'https://duanbdsdanang.com/du-an/casamia-balanca-hoi-an/', 'https://quangminhproperty.com/du-an/casamia-balanca-hoi-an/' ),
	);

	$posts[] = array(
		'slug'     => 'cho-thue-biet-thu-casamia-balanca-dong-tien',
		'title'    => 'Cho thuê Casamia Balanca: cách ước tính dòng tiền biệt thự Hội An',
		'excerpt'  => 'Cho thuê Casamia Balanca có sinh lời không? Hướng dẫn ước tính dòng tiền biệt thự theo giá thuê villa Cẩm Thanh, công suất và chi phí.',
		'keyword'  => 'cho thuê Casamia Balanca',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 4,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Cho thuê Casamia Balanca theo mô hình villa nghỉ dưỡng là hướng khai thác khả thi vì dự án nằm ở Cẩm Thanh, gần phố cổ Hội An – nơi villa nguyên căn đang cho thuê phổ biến khoảng 1,5 – 4 triệu đồng/đêm. Tuy nhiên, đến tháng 10/2026 dự án mới bắt đầu bàn giao, <strong>chưa có số liệu doanh thu thực tế công khai</strong>. Bài viết hướng dẫn cách tự ước tính dòng tiền, thay vì đưa ra con số lợi nhuận hứa hẹn.</p>

<h2>Giá thuê villa khu Cẩm Thanh hiện nay</h2>
<table>
<thead><tr><th>Loại villa</th><th>Giá thuê tham khảo</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Villa Cẩm Thanh (mức phổ biến)</td><td>Khoảng 1,5 – 4 triệu/đêm</td><td>Trang đặt phòng, du lịch</td></tr>
<tr><td>Villa 3 – 8 phòng ngủ tại Cẩm Thanh</td><td>Từ khoảng 3,5 – 5,5 triệu/đêm</td><td>Trang du lịch</td></tr>
<tr><td>Villa 4 phòng ngủ có hồ bơi (Hội An)</td><td>Khoảng 6 – 8 triệu/đêm tùy ngày thường, cuối tuần, lễ Tết</td><td>Trang villa</td></tr>
</tbody>
</table>
<p>Giá thuê thay đổi rất mạnh theo mùa du lịch, số phòng ngủ, hồ bơi riêng và chất lượng vận hành. Đây là giá các villa đang hoạt động, không phải giá của Casamia Balanca.</p>

<h2>Công thức ước tính dòng tiền cho thuê</h2>
<p>Doanh thu năm = Giá thuê trung bình/đêm x 365 x Công suất phòng.</p>
<p>Dòng tiền ròng = Doanh thu – Phí OTA/hoa hồng – Chi phí vận hành (nhân sự, điện nước, giặt là, bảo trì hồ bơi) – Phí quản lý khu đô thị – Thuế cho thuê – Khấu hao nội thất.</p>
<p>Tỷ suất = Dòng tiền ròng / Tổng vốn đầu tư (giá căn + nội thất + chi phí khác).</p>

<h3>Minh họa doanh thu gộp với các giả định</h3>
<p>Ví dụ dưới đây dùng giá thuê 3,5 triệu/đêm (mức thấp của villa nhiều phòng ở Cẩm Thanh) và giá căn 13,75 tỷ (lô 250 m² x 55 triệu/m², theo Tạp chí Công Thương 12/2024). Công suất là <strong>giả định của người đọc</strong>, không phải số liệu dự án.</p>
<table>
<thead><tr><th>Công suất giả định</th><th>Doanh thu gộp/năm</th><th>Tỷ suất gộp trên 13,75 tỷ</th></tr></thead>
<tbody>
<tr><td>40%</td><td>Khoảng 511 triệu</td><td>Khoảng 3,7%</td></tr>
<tr><td>50%</td><td>Khoảng 639 triệu</td><td>Khoảng 4,6%</td></tr>
<tr><td>60%</td><td>Khoảng 767 triệu</td><td>Khoảng 5,6%</td></tr>
</tbody>
</table>
<p>Đây là doanh thu <strong>trước chi phí</strong>. Sau khi trừ hoa hồng nền tảng đặt phòng, vận hành, thuế, dòng tiền ròng sẽ thấp hơn đáng kể. Hãy thay số theo căn và giá thuê bạn khảo sát được.</p>

<h2>Về các gói cam kết khai thác</h2>
<p>Một số trang phân phối giới thiệu gói hợp tác khai thác chia khoảng 45% doanh thu thuần, kèm mức tối thiểu khoảng 30 triệu/tháng. Hoàng Hiệp chưa thấy văn bản chính thức của chủ đầu tư về gói này. Nếu được chào, hãy yêu cầu hợp đồng cụ thể: bên vận hành là ai, thời hạn, cách tính doanh thu thuần, ai chịu chi phí, điều kiện chấm dứt.</p>

<h2>Yếu tố giúp biệt thự cho thuê tốt</h2>
<ul>
<li><strong>Vị trí:</strong> căn ven sông, view rừng dừa, gần bến thuyền dễ bán phòng hơn.</li>
<li><strong>Thiết kế:</strong> 3 – 4 phòng ngủ có phòng tắm riêng, hồ bơi riêng phù hợp nhóm gia đình.</li>
<li><strong>Vận hành:</strong> hình ảnh, đánh giá trên nền tảng đặt phòng, dịch vụ đón tiễn.</li>
<li><strong>Mùa vụ:</strong> Hội An có mùa mưa cuối năm, cần tính công suất cả năm, không chỉ mùa cao điểm.</li>
</ul>

<h2>Lời khuyên</h2>
<p>Biệt thự Casamia Balanca nên được xem là tài sản tích lũy dài hạn kết hợp khai thác, không phải sản phẩm dòng tiền cao. Nếu ưu tiên dòng tiền, bạn có thể so sánh với căn hộ, khách sạn tại trang <a href="/cho-thue/">cho thuê</a> hoặc <a href="/mua-ban/khach-san/">mua bán khách sạn</a>. Thông tin dự án xem tại <a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a> và bảng <a href="/gia-biet-thu-casamia-balanca-2026/">giá Casamia Balanca 2026</a>.</p>

<h2>Tự vận hành hay thuê đơn vị quản lý?</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Tự vận hành</th><th>Thuê đơn vị quản lý</th></tr></thead>
<tbody>
<tr><td>Doanh thu giữ lại</td><td>Cao hơn</td><td>Thấp hơn do chia phí quản lý</td></tr>
<tr><td>Công sức</td><td>Nhiều: đăng bài, đón khách, dọn dẹp</td><td>Ít, phù hợp chủ ở xa</td></tr>
<tr><td>Rủi ro chất lượng</td><td>Phụ thuộc kinh nghiệm chủ nhà</td><td>Phụ thuộc uy tín đơn vị vận hành</td></tr>
</tbody>
</table>
<p>Dù chọn cách nào, hãy yêu cầu báo cáo doanh thu, chi phí hằng tháng để theo dõi hiệu quả thực.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng tính dòng tiền cho thuê theo từng căn Casamia Balanca, với số liệu bạn tự điều chỉnh.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cho thuê Casamia Balanca: cách ước tính dòng tiền',
			'desc'      => 'Cho thuê Casamia Balanca: giá thuê villa Cẩm Thanh, công thức ước tính dòng tiền, lưu ý gói cam kết. Gọi Hoàng Hiệp 0904 567 009 nhận bảng tính.',
			'points'    => array(
				'Villa nguyên căn Cẩm Thanh cho thuê phổ biến khoảng 1,5 – 4 triệu/đêm; villa nhiều phòng có hồ bơi cao hơn.',
				'Chưa có số liệu doanh thu thực tế công khai của Casamia Balanca; cần tự ước tính theo công thức.',
				'Gói chia doanh thu do phân phối giới thiệu cần kiểm tra hợp đồng vận hành cụ thể.',
			),
			'faq'       => array(
				array( 'Cho thuê biệt thự Casamia Balanca được bao nhiêu?', 'Chưa có số liệu doanh thu thực tế công khai. Có thể tham khảo giá thuê villa Cẩm Thanh khoảng 1,5 – 4 triệu/đêm và tự tính theo công suất giả định.' ),
				array( 'Casamia Balanca có cam kết lợi nhuận không?', 'Một số phân phối giới thiệu gói chia doanh thu; chưa thấy văn bản chính thức của chủ đầu tư, cần kiểm tra hợp đồng trước khi tin.' ),
				array( 'Cách tính dòng tiền cho thuê biệt thự?', 'Doanh thu = giá thuê/đêm x 365 x công suất; trừ hoa hồng, vận hành, phí quản lý, thuế để ra dòng tiền ròng.' ),
			),
		),
		'sources'  => array( 'https://vinwondersnamhoian.com/Du-lich-Hoi-An/Villa-Cam-Thanh-Hoi-An', 'https://namo-hoian.com/', 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg-trien-vong-tai-dinh-gia-tu-viec-mo-ban-du-an-casamia-balanca-141395.htm', 'https://www.xn--bitthcasamiabalancahoian-rg2nk9a.vn/' ),
	);

	$posts[] = array(
		'slug'     => 'phap-ly-so-hong-casamia-balanca',
		'title'    => 'Pháp lý Casamia Balanca: sổ hồng, tiến độ cấp giấy và điều cần kiểm tra',
		'excerpt'  => 'Pháp lý Casamia Balanca: sở hữu lâu dài, phê duyệt giá đất, kế hoạch cấp giấy chứng nhận năm 2026 và checklist hồ sơ trước khi mua.',
		'keyword'  => 'pháp lý Casamia Balanca',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 4,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Pháp lý Casamia Balanca: dự án được giới thiệu là sở hữu lâu dài cho người Việt Nam. Việc phê duyệt giá đất đã tháo gỡ một phần vướng mắc, tạo cơ sở để chủ đầu tư làm thủ tục cấp giấy chứng nhận (sổ) cho từng lô; tại ĐHĐCĐ ngày 25/4/2026, Đạt Phương cho biết sẽ hoàn thiện các thủ tục này trong năm 2026. Thông tin cập nhật tháng 10/2026.</p>

<h2>Tóm tắt pháp lý Casamia Balanca</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Đạt Phương</td></tr>
<tr><td>Tên pháp lý dự án</td><td>Khu đô thị Cồn Tiến, xã Cẩm Thanh, Hội An</td></tr>
<tr><td>Hình thức sở hữu</td><td>Lâu dài với người Việt Nam; người nước ngoài theo quy định (một số nguồn ghi 50 năm)</td></tr>
<tr><td>Giá đất</td><td>Đã được phê duyệt, tháo gỡ một phần vướng mắc (theo báo chí)</td></tr>
<tr><td>Giấy chứng nhận từng lô</td><td>Chủ đầu tư đặt mục tiêu hoàn thiện thủ tục trong năm 2026</td></tr>
<tr><td>Bàn giao</td><td>Kế hoạch khoảng 100 căn trong tháng 11 – 12/2026</td></tr>
</tbody>
</table>

<h2>Sổ hồng hay sổ đỏ?</h2>
<p>Với biệt thự, nhà ở gắn liền với đất, giấy tờ hiện nay là <strong>giấy chứng nhận quyền sử dụng đất, quyền sở hữu tài sản gắn liền với đất</strong> – thường được gọi chung là sổ hồng hoặc sổ đỏ. Điều quan trọng là thời điểm sổ được cấp cho từng căn và thông tin trên sổ đúng với hợp đồng.</p>

<h2>Diễn biến pháp lý đáng chú ý</h2>
<h3>Phê duyệt giá đất</h3>
<p>Báo chí cho biết việc phê duyệt giá đất là bước quan trọng giúp tháo gỡ vướng mắc tại Casamia Balanca, tạo cơ sở để chủ đầu tư hoàn thành nghĩa vụ tài chính và tiếp tục thủ tục cấp sổ.</p>
<h3>Kế hoạch 2026 của Đạt Phương</h3>
<p>Tại ĐHĐCĐ thường niên 2026, ban lãnh đạo Đạt Phương cho biết sẽ hoàn thiện thủ tục cấp giấy chứng nhận cho các lô đất tại Khu đô thị Cồn Tiến trong năm. Doanh nghiệp đặt mục tiêu doanh thu hơn 1.361 tỷ đồng, tập trung bán hàng Casamia Balanca và bàn giao khoảng 100 căn cuối năm.</p>
<p>Đây là kế hoạch của doanh nghiệp, không phải cam kết thời hạn cấp sổ cho từng khách. Người mua nên yêu cầu điều khoản về thời hạn cấp sổ ghi rõ trong hợp đồng.</p>

<h2>Checklist hồ sơ pháp lý khi mua</h2>
<table>
<thead><tr><th>Giấy tờ</th><th>Vì sao cần kiểm tra</th></tr></thead>
<tbody>
<tr><td>Quyết định chủ trương đầu tư, giao đất</td><td>Xác nhận dự án hợp lệ và đúng chủ đầu tư</td></tr>
<tr><td>Quy hoạch chi tiết 1/500</td><td>Đối chiếu vị trí, diện tích lô, chỉ tiêu xây dựng</td></tr>
<tr><td>Giấy phép xây dựng hoặc miễn phép</td><td>Đảm bảo căn được xây đúng phép</td></tr>
<tr><td>Thông báo đủ điều kiện bán nhà hình thành trong tương lai</td><td>Bắt buộc với căn chưa hoàn thành</td></tr>
<tr><td>Bảo lãnh ngân hàng</td><td>Bảo vệ tiền của người mua khi mua nhà hình thành trong tương lai</td></tr>
<tr><td>Hợp đồng mua bán</td><td>Thời hạn bàn giao, thời hạn cấp sổ, phạt chậm, quyền chuyển nhượng</td></tr>
</tbody>
</table>

<h2>Rủi ro pháp lý và cách giảm thiểu</h2>
<ul>
<li><strong>Chậm cấp sổ:</strong> thủ tục phụ thuộc cơ quan nhà nước; nên có điều khoản giữ lại một phần thanh toán đến khi nhận sổ nếu thương lượng được.</li>
<li><strong>Mua lại hợp đồng:</strong> kiểm tra văn bản chuyển nhượng hợp đồng được chủ đầu tư xác nhận.</li>
<li><strong>Thông tin trên mạng không thống nhất:</strong> chỉ dựa vào văn bản có dấu của chủ đầu tư và cơ quan nhà nước.</li>
</ul>

<h2>Đọc thêm</h2>
<p>Xem <a href="/casamia-balanca-hoi-an-tong-quan-du-an/">tổng quan Casamia Balanca Hội An</a>, <a href="/chinh-sach-ban-hang-casamia-balanca/">chính sách bán hàng Casamia Balanca</a> hoặc trang dự án <a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a>. Các dự án khác tại Hội An có ở <a href="/khu-vuc/hoi-an/">khu vực Hội An</a>.</p>

<h2>Mua trước hay sau khi có sổ?</h2>
<p>Mua trước khi có sổ, người mua thường được giá và chính sách tốt hơn nhưng chấp nhận thời gian chờ. Mua sau khi có sổ an toàn hơn về pháp lý, giao dịch nhanh, nhưng giá có thể cao hơn.</p>
<p>Với khách mua ở hoặc dùng vốn vay, Hoàng Hiệp khuyên ưu tiên sự chắc chắn: chọn căn đã đủ điều kiện bán, có bảo lãnh ngân hàng và điều khoản cấp sổ rõ ràng.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được hỗ trợ kiểm tra hồ sơ pháp lý Casamia Balanca theo căn cụ thể và cập nhật tiến độ cấp giấy chứng nhận.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Pháp lý Casamia Balanca: sổ hồng và tiến độ cấp giấy',
			'desc'      => 'Pháp lý Casamia Balanca: sở hữu lâu dài, phê duyệt giá đất, kế hoạch cấp sổ 2026, checklist hồ sơ. Gọi Hoàng Hiệp 0904 567 009 để kiểm tra.',
			'points'    => array(
				'Sở hữu lâu dài với người Việt Nam; giá đất đã được phê duyệt, tháo gỡ một phần vướng mắc.',
				'Đạt Phương đặt mục tiêu hoàn thiện thủ tục cấp giấy chứng nhận các lô trong năm 2026.',
				'Người mua cần kiểm tra quy hoạch 1/500, bảo lãnh ngân hàng, thời hạn cấp sổ trong hợp đồng.',
			),
			'faq'       => array(
				array( 'Casamia Balanca có sổ hồng chưa?', 'Đạt Phương cho biết đang hoàn thiện thủ tục cấp giấy chứng nhận cho các lô tại Khu đô thị Cồn Tiến, mục tiêu trong năm 2026. Cần kiểm tra tình trạng từng căn khi mua.' ),
				array( 'Casamia Balanca sở hữu bao lâu?', 'Sở hữu lâu dài với người Việt Nam; người nước ngoài theo quy định pháp luật.' ),
				array( 'Mua Casamia Balanca cần kiểm tra giấy tờ gì?', 'Quyết định giao đất, quy hoạch 1/500, giấy phép xây dựng, thông báo đủ điều kiện bán, bảo lãnh ngân hàng và điều khoản cấp sổ trong hợp đồng.' ),
			),
		),
		'sources'  => array( 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg-trien-vong-tai-dinh-gia-tu-viec-mo-ban-du-an-casamia-balanca-141395.htm', 'https://nguoiquansat.vn/dat-phuong-dpg-du-an-1-400-ty-duoc-thao-go-phap-ly-303803.html', 'https://www.firhouse.vn/du-an/du-an-casamia-balanca-hoi-an.html' ),
	);

	return $posts;
}
