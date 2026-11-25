<?php
/**
 * Sun Saphia Residence đợt 12 – 8 bài, 27/11 – 29/11/2026: cho thuê mùa thấp điểm, tiền điện theo biểu giá mới 1/11/2026,
 * đi Cù Lao Chàm, sông Cổ Cò phía sau dự án, khách Ấn Độ, phường Ngũ Hành Sơn sau sắp xếp, so với khu An Thượng, đi Mỹ Sơn.
 * Mỗi bài dẫn về trang dự án và các bài đã đăng trước đó.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Thông tin dự án theo tài liệu và buổi giải đáp của chủ đầu tư (10 – 11/2026); sự kiện bán hàng dự kiến 05/12/2026;
 * số liệu khác theo báo chí, cổng thông tin Đà Nẵng nêu trong bài (tra cứu 25/11/2026); giá là giá dự kiến, tham khảo.
 * Ba bài có một liên kết tham khảo tới cẩm nang danangstay.com.vn (thời tiết, chọn khu lưu trú, chi phí chuyến đi).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_12' );
function hh_posts_sun_saphia_dot_12( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$review = '<a href="/danh-gia-sun-saphia-residence-chi-tiet/">đánh giá chi tiết Sun Saphia Residence</a>';

	/* ---------------- 27/11 13:30 – Cho thuê mùa thấp điểm ---------------- */
	$posts[] = array(
		'slug'     => 'cho-thue-sun-saphia-residence-mua-thap-diem',
		'title'    => 'Cho thuê Sun Saphia Residence mùa thấp điểm: tháng 9 – 12 mưa nhiều, làm sao để căn hộ không bỏ trống',
		'excerpt'  => 'Đà Nẵng vào mùa mưa từ tháng 9 đến tháng 12, khách ngắn ngày giảm, có nơi bị hủy phòng nhiều. Bài phân tích cho thuê Sun Saphia Residence mùa thấp điểm: lịch thời tiết, nhóm khách ở dài ngày, cách đổi từ thuê theo đêm sang thuê theo tuần, theo tháng và cách tính dòng tiền thận trọng.',
		'keyword'  => 'cho thuê Sun Saphia Residence mùa thấp điểm',
		'keywords_extra' => array( 'mùa mưa Đà Nẵng cho thuê căn hộ', 'thuê căn hộ theo tháng Đà Nẵng', 'khách ở dài ngày Đà Nẵng', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-27 13:30',
		'category' => 'Đầu tư cho thuê',
		'tags'     => array( 'Sun Saphia Residence', 'Cho thuê', 'Mùa du lịch' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-cdt-ven-bien-son-thuy-ho-nuoc.jpg',
		'image_alt' => 'Cho thuê Sun Saphia Residence mùa thấp điểm – tòa tháp bên biển Sơn Thủy (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p>Bài toán <strong>cho thuê Sun Saphia Residence mùa thấp điểm</strong> là phần mà bảng tính bán hàng thường đi lướt: tài liệu chủ đầu tư giả định studio 30 m² cho thuê 2,5 triệu/đêm, lấp đầy 60% cả năm, nhưng Đà Nẵng có bốn tháng mưa nhiều từ tháng 9 đến tháng 12. Căn hộ của {$saphia} dự kiến bàn giao 11/2028, nghĩa là mùa đầu tiên chủ căn đón khách rất có thể chính là mùa mưa. Bài này đi qua lịch thời tiết, nhóm khách còn đến trong mùa vắng và cách giữ căn không bỏ trống.</p>
<!--hh-featured-->
<h2>Cho thuê Sun Saphia Residence mùa thấp điểm: tháng nào là mùa vắng?</h2>
<p>Theo <a href="https://danangstay.com.vn/vi/thoi-tiet-da-nang-qua-tung-thang-vi/">cẩm nang thời tiết Đà Nẵng qua từng tháng</a>, mùa khô nắng kéo dài khoảng tháng 2 đến tháng 8, mùa mưa từ tháng 9 đến tháng 12, mưa nhiều nhất tháng 10 – 11 kèm nguy cơ bão. Cao điểm du lịch là tháng 6 – 8, còn tháng 9 – 12 giá phòng thường mềm hơn. Cẩm nang cũng khuyên du khách đi mùa mưa nên để trống một hai ngày dự phòng – tức là khách mùa này đặt phòng linh hoạt, dễ đổi, dễ hủy.</p>
<table>
<thead><tr><th>Giai đoạn</th><th>Thời tiết</th><th>Ý nghĩa với chủ căn</th></tr></thead>
<tbody>
<tr><td>Tháng 3 – 5</td><td>Nắng đẹp, biển êm</td><td>Khách đều, giá ổn</td></tr>
<tr><td>Tháng 6 – 8</td><td>Nóng, đông khách nhất</td><td>Giá đêm cao nhất năm</td></tr>
<tr><td>Tháng 9 – 12</td><td>Mưa, tháng 10 – 11 có thể có bão</td><td>Thấp điểm, cần đổi cách bán phòng</td></tr>
<tr><td>Tháng 12 – 2</td><td>Mát, mưa ngớt dần, Tết</td><td>Khách Tết, khách ở dài ngày</td></tr>
</tbody>
</table>
<h2>Cho thuê Sun Saphia Residence mùa thấp điểm khó tới mức nào?</h2>
<p>Năm 2026 là ví dụ rõ. <a href="https://tuoitre.vn/pho-co-hoi-an-mua-nay-vang-chi-ma-vang-100261022112849241.htm">Tuổi Trẻ</a> ngày 22/10/2026 ghi nhận phố cổ Hội An vắng bất thường; người bán hàng cho biết Hội An thường vào thấp điểm từ tháng 9, một chủ cơ sở lưu trú nói khoảng 50% lượt đặt phòng tháng 10 – 11 bị hủy so với năm trước vì khách sợ lũ. Lãnh đạo Hiệp hội Du lịch Đà Nẵng nêu hai nguyên nhân: kinh tế khó khăn và hiệu ứng thông tin từ mùa lũ 2025.</p>
<p>Với cho thuê Sun Saphia Residence mùa thấp điểm, khó khăn còn nằm ngay trong tòa: 513 studio cùng loại sẽ cạnh tranh giá khi khách ít. Căn nào chỉ bán phòng theo đêm trên một kênh sẽ chịu áp lực giảm giá đầu tiên.</p>
<!--hh-img:img/sun-saphia/sun-saphia-view-tang-10-ban-cong-bien.jpg|Cho thuê Sun Saphia Residence mùa thấp điểm – ban công tầng 10 nhìn biển Sơn Thủy (phối cảnh chủ đầu tư)-->
<h2>Khách nào giữ cho thuê Sun Saphia Residence mùa thấp điểm?</h2>
<p>Thành phố đang đẩy nhóm khách ở lâu. Theo <a href="https://tuoitre.vn/da-nang-ban-chuyen-giu-chan-khach-du-lich-trong-ngay-hoi-hon-500-doi-tac-100261018112917733.htm">Tuổi Trẻ</a> (18/10/2026), 9 tháng đầu 2026 Đà Nẵng đón khoảng 7,7 triệu lượt khách quốc tế lưu trú nhưng mỗi lượt chỉ ở gần 2 ngày; thành phố muốn kéo dài thời gian lưu trú, trong đó khách Nga và SNG được định hướng sản phẩm ở dài ngày kết hợp biển và chăm sóc sức khỏe. <a href="https://danang.gov.vn/vi/web/dng/w/du-lich-da-nang-ky-vong-but-pha-nho-le-hoi-va-mo-rong-duong-bay">Cổng thông tin Đà Nẵng</a> (28/5/2026) cho biết thị trường Nga – SNG được kỳ vọng tăng 30 – 40% trong năm.</p>
<ul>
<li><strong>Khách ở dài ngày, làm việc từ xa:</strong> cần bàn làm việc, mạng ổn định, bếp – studio và 1PN+ đáp ứng được.</li>
<li><strong>Khách Tết, khách gia đình cuối năm:</strong> tháng 12 – 2 trời mát, hợp căn 2PN.</li>
<li><strong>Chuyên gia, người đi công tác vài tháng:</strong> ưu tiên hợp đồng theo tháng, hóa đơn rõ ràng – nhóm khách ổn định nhất khi cho thuê Sun Saphia Residence mùa thấp điểm.</li>
</ul>
<h2>Cách cho thuê Sun Saphia Residence mùa thấp điểm: đổi từ đêm sang tuần, tháng</h2>
<p>Căn hộ có bếp là lợi thế so với phòng khách sạn: từ tháng 9 có thể mở thêm giá tuần, giá tháng thay vì giữ giá đêm. Khi tư vấn cho khách mua studio để cho thuê, Hiệp luôn tách năm thành hai mùa và hỏi trước: tháng 9 – 12 anh chị chấp nhận cho thuê theo tháng với giá thấp hơn, hay để trống chờ khách đêm? Câu trả lời quyết định nên chọn studio dãy mặt biển hay căn 1PN+ dễ cho thuê dài.</p>
<ol>
<li>Mở song song giá đêm và giá tháng trên nhiều kênh; ưu tiên khách ở từ 2 tuần.</li>
<li>Chính sách hủy linh hoạt hơn mùa cao điểm để khách bớt lo thời tiết.</li>
<li>Gộp ưu đãi: đưa đón sân bay, dọn phòng theo tuần thay vì hằng ngày.</li>
<li>Tận dụng tiện ích trong tòa – bể bơi, gym, yoga – để bù cho những ngày mưa không ra biển; đây là điểm cộng khi cho thuê Sun Saphia Residence mùa thấp điểm so với nhà phố cho thuê.</li>
</ol>
<p>Chi tiết hợp đồng thuê dài, tạm trú và giá thuê tháng xem bài <a href="/cho-thue-dai-han-sun-saphia-residence/">cho thuê dài hạn Sun Saphia Residence</a>.</p>
<h2>Tính dòng tiền cho thuê Sun Saphia Residence mùa thấp điểm thế nào cho an toàn?</h2>
<p>Giả định 60% lấp đầy của tài liệu bán hàng là con số trung bình cả năm, không phải cam kết. Cách thận trọng là tính riêng: mùa cao điểm theo giá đêm, mùa thấp điểm theo giá tháng hoặc lấp đầy thấp hơn hẳn. Cách chia này đã được làm mẫu trong bài <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">đầu tư Sun Saphia Residence cho thuê: dòng tiền</a>. Nếu bài toán cho thuê Sun Saphia Residence mùa thấp điểm vẫn trả được nợ vay khi bốn tháng mưa chỉ thu bằng giá thuê tháng, căn đó mới thực sự an toàn.</p>
<p>Đừng quên chi phí mùa mưa: hơi muối, gió mạnh làm ban công, cửa nhôm, điều hòa xuống cấp nhanh hơn (xem <a href="/bao-tri-can-ho-ven-bien-hoi-muoi-mua-bao/">căn hộ ven biển và mùa mưa bão</a>).</p>
<h2>Chọn căn để cho thuê Sun Saphia Residence mùa thấp điểm</h2>
<table>
<thead><tr><th>Loại căn</th><th>Mùa cao điểm</th><th>Mùa thấp điểm</th></tr></thead>
<tbody>
<tr><td>Studio dãy mặt biển</td><td>Giá đêm tốt nhất</td><td>Cạnh tranh mạnh với 512 studio còn lại</td></tr>
<tr><td>1PN+ 49 – 51 m²</td><td>Hợp cặp đôi, gia đình nhỏ</td><td>Dễ cho thuê theo tháng nhờ phòng đa năng</td></tr>
<tr><td>2PN 60 – 70 m²</td><td>Gia đình, nhóm bạn</td><td>Khách Tết, khách ở dài ngày</td></tr>
</tbody>
</table>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Cho thuê Sun Saphia Residence mùa thấp điểm không phải lý do để bỏ dự án, nhưng là lý do để chọn căn và tính tiền thận trọng hơn. Người mua nên chuẩn bị sẵn hai bảng giá – theo đêm và theo tháng – và chấp nhận rằng bốn tháng cuối năm là mùa giữ khách chứ không phải mùa kiếm lời. Bảng hàng chính thức dự kiến có tại sự kiện bán hàng 05/12/2026. Xem thêm {$review}.</p>
<p>Cần bảng dòng tiền tách hai mùa cho căn định chọn tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: bài toán cho thuê, cơ cấu căn, bàn giao theo tài liệu chủ đầu tư (10 – 11/2026); khách lưu trú, định hướng thị trường theo Tuổi Trẻ (18/10/2026, 22/10/2026) và Cổng thông tin Đà Nẵng (28/5/2026); lịch thời tiết tham khảo cẩm nang DanangStay. Bài tham khảo, không phải cam kết lợi nhuận.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cho thuê Sun Saphia Residence mùa thấp điểm: tháng 9 – 12',
			'desc'      => 'Cho thuê Sun Saphia Residence mùa thấp điểm tháng 9 – 12: mưa bão, khách hủy phòng, nhóm khách ở dài ngày và cách chuyển sang thuê theo tuần, theo tháng.',
			'points'    => array(
				'Cho thuê Sun Saphia Residence mùa thấp điểm: tháng 9 – 12 mưa nhiều, tháng 10 – 11 có thể có bão',
				'Năm 2026 có cơ sở ở Hội An bị hủy khoảng 50% lượt đặt tháng 10 – 11 (Tuổi Trẻ)',
				'Cho thuê Sun Saphia Residence mùa thấp điểm: mở giá tuần, giá tháng, nhắm khách ở dài ngày; tính dòng tiền tách hai mùa',
			),
			'faq'       => array(
				array( 'Cho thuê Sun Saphia Residence mùa thấp điểm là những tháng nào?', 'Khoảng tháng 9 đến tháng 12, khi Đà Nẵng vào mùa mưa, mưa nhiều nhất tháng 10 – 11 và có nguy cơ bão.' ),
				array( 'Mùa thấp điểm có nên hạ giá đêm thật sâu không?', 'Nên mở thêm giá tuần, giá tháng cho khách ở dài ngày trước khi hạ sâu giá đêm, vì 513 studio cùng tòa sẽ cạnh tranh bằng giá.' ),
				array( 'Loại căn nào hợp cho thuê Sun Saphia Residence mùa thấp điểm?', 'Căn 1PN+ có phòng đa năng và căn 2PN dễ cho thuê theo tháng, cho khách gia đình dịp Tết; studio cần giá linh hoạt hơn.' ),
				array( 'Lấp đầy 60% trong tài liệu có tính mùa mưa chưa?', 'Đó là giả định trung bình cả năm của tài liệu bán hàng, không phải cam kết. Nên tự tính riêng mùa thấp điểm với giá thuê tháng.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/pho-co-hoi-an-mua-nay-vang-chi-ma-vang-100261022112849241.htm',
			'https://tuoitre.vn/da-nang-ban-chuyen-giu-chan-khach-du-lich-trong-ngay-hoi-hon-500-doi-tac-100261018112917733.htm',
			'https://danang.gov.vn/vi/web/dng/w/du-lich-da-nang-ky-vong-but-pha-nho-le-hoi-va-mo-rong-duong-bay',
		),
	);

	/* ---------------- 27/11 18:00 – Tiền điện theo biểu giá mới ---------------- */
	$posts[] = array(
		'slug'     => 'tien-dien-can-ho-sun-saphia-residence',
		'title'    => 'Tiền điện căn hộ Sun Saphia Residence: biểu giá 5 bậc từ 1/11/2026 và giá riêng cho cơ sở lưu trú du lịch',
		'excerpt'  => 'Từ 1/11/2026, giá điện sinh hoạt rút còn 5 bậc, cơ sở lưu trú du lịch được tách nhóm giá riêng thấp hơn giá kinh doanh. Bài giải thích tiền điện căn hộ Sun Saphia Residence có thể tính theo nhóm nào, ví dụ hóa đơn 300 kWh và cách giảm tiền điện cho căn cho thuê.',
		'keyword'  => 'tiền điện căn hộ Sun Saphia Residence',
		'keywords_extra' => array( 'giá điện 5 bậc 2026', 'giá điện cơ sở lưu trú du lịch', 'Quyết định 2892/QĐ-BCT', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-27 18:00',
		'category' => 'Kinh nghiệm mua nhà',
		'tags'     => array( 'Sun Saphia Residence', 'Chi phí', 'Giá điện' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-phoi-canh-dem-toa-thap-ven-bien.jpg',
		'image_alt' => 'Tiền điện căn hộ Sun Saphia Residence – tòa tháp 30 tầng lên đèn bên biển (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p><strong>Tiền điện căn hộ Sun Saphia Residence</strong> là khoản chi hằng tháng người mua để ở hay cho thuê đều phải tính, và vừa có thay đổi lớn: từ 1/11/2026 giá điện sinh hoạt rút từ 6 bậc xuống 5 bậc, cơ sở lưu trú du lịch được tách thành nhóm giá riêng. Với {$saphia} – tòa 782 căn, phần lớn là studio cho thuê, bàn giao dự kiến 11/2028 – hiểu đúng biểu giá giúp tính dòng tiền sát hơn.</p>
<!--hh-featured-->
<h2>Tiền điện căn hộ Sun Saphia Residence: biểu giá đổi gì từ 1/11/2026?</h2>
<p>Theo <a href="https://tuoitre.vn/gia-dien-giam-2-chi-tiet-muc-gia-5-bac-thang-dien-sinh-hoat-100261101091531402.htm">Tuổi Trẻ</a>, giá bán lẻ điện bình quân giảm 2%, còn 2.159,9037 đồng/kWh (chưa VAT), áp dụng từ 1/11/2026; Bộ Công Thương ban hành giá cho từng nhóm khách hàng tại Quyết định 2892/QĐ-BCT ngày 31/10/2026. <a href="https://vnexpress.net/gia-dien-sinh-hoat-theo-5-bac-cao-nhat-3-844-dong-mot-kwh-5139227.html">VnExpress</a> cho biết biểu giá sinh hoạt còn 5 bậc, bậc thấp nhất (0 – 100 kWh) 1.901 đồng/kWh, mức cao nhất 3.844 đồng/kWh, đều chưa VAT.</p>
<table>
<thead><tr><th>Nội dung</th><th>Theo biểu giá từ 1/11/2026</th></tr></thead>
<tbody>
<tr><td>Giá bình quân</td><td>2.159,9037 đ/kWh (giảm 2%)</td></tr>
<tr><td>Điện sinh hoạt</td><td>5 bậc, từ 1.901 đến 3.844 đ/kWh</td></tr>
<tr><td>Cơ sở lưu trú du lịch, cấp điện áp trên 1 kV</td><td>1.814 đ/kWh giờ bình thường, 3.348 đ/kWh giờ cao điểm</td></tr>
<tr><td>Kinh doanh khác, cùng cấp điện áp</td><td>2.829 và 4.924 đ/kWh</td></tr>
<tr><td>Khung giờ</td><td>Cao điểm 17h30 – 22h30, thấp điểm 0h – 6h, Chủ nhật không có cao điểm</td></tr>
</tbody>
</table>
<p>Giá chưa gồm VAT. Số liệu nhóm lưu trú và kinh doanh theo <a href="https://thanhnien.vn/giam-hon-1500-ti-dong-tien-dien-moi-thang-18526111019531273.htm">Thanh Niên</a> (11/11/2026); khung giờ theo VnExpress.</p>
<h2>Tiền điện căn hộ Sun Saphia Residence tính theo nhóm nào?</h2>
<p>Đây là câu hỏi chưa có câu trả lời chính thức, vì dự án chưa vận hành. Sun Saphia là căn hộ thương mại dịch vụ thời hạn 50 năm; việc từng căn được ký hợp đồng mua bán điện theo giá sinh hoạt, hay cả tòa dùng điện qua trạm chung rồi ban quản lý thu lại, sẽ do chủ đầu tư, ban quản lý và điện lực thống nhất khi bàn giao. Để ước tính tiền điện căn hộ Sun Saphia Residence, người mua nên hỏi ba điểm: công tơ riêng từng căn hay không, ai đứng tên hợp đồng điện, và căn đăng ký kinh doanh lưu trú thì áp nhóm giá nào.</p>
<!--hh-img:img/sun-saphia/sun-saphia-layout-studio-30m2.jpg|Tiền điện căn hộ Sun Saphia Residence – studio 30 m², điều hòa và bếp là hai thiết bị dùng điện nhiều nhất (layout chủ đầu tư)-->
<h2>Ví dụ hóa đơn: tiền điện căn hộ Sun Saphia Residence nếu dùng 300 kWh</h2>
<p>VnExpress đưa ví dụ hộ dùng 300 kWh/tháng theo biểu 5 bậc: 100 kWh đầu khoảng 190.100 đồng, 100 kWh tiếp theo 228.900 đồng, 100 kWh còn lại 289.400 đồng – tổng khoảng 708.400 đồng chưa VAT. Một studio 30 m² chạy điều hòa nhiều mùa hè có thể chạm mức này; căn 2PN có gia đình ở thường còn cao hơn. Theo EVN được <a href="https://thanhnien.vn/evn-thong-tin-ve-thay-doi-trong-bieu-gia-dien-moi-185261104115238943.htm">Thanh Niên</a> dẫn, hộ được giảm nhiều nhất khoảng 77.900 đồng/tháng, nhưng hộ dùng 1.000 – 2.000 kWh/tháng sẽ trả thêm 37.300 – 421.000 đồng.</p>
<p>Với căn cho khách du lịch thuê, điểm cần để ý khi tính tiền điện căn hộ Sun Saphia Residence là giờ cao điểm 17h30 – 22h30: khách đi chơi về, bật điều hòa, nấu ăn, sạc thiết bị đúng khung giờ đắt nhất nếu căn áp giá theo thời gian sử dụng.</p>
<h2>Tiền điện căn hộ Sun Saphia Residence đặt cạnh các khoản khác</h2>
<table>
<thead><tr><th>Khoản hằng tháng</th><th>Studio 30 m²</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Phí quản lý</td><td>Khoảng 450.000 – 600.000 đ</td><td>Dự kiến 15.000 – 20.000 đ/m²/tháng (chủ đầu tư)</td></tr>
<tr><td>Tiền điện</td><td>Tùy mức dùng và nhóm giá</td><td>Ví dụ 300 kWh sinh hoạt ≈ 708.400 đ chưa VAT</td></tr>
<tr><td>Nước, internet</td><td>Theo hợp đồng cung cấp</td><td>Chưa có thông tin riêng của dự án</td></tr>
</tbody>
</table>
<p>Chi tiết phí quản lý xem bài <a href="/phi-quan-ly-sun-saphia-residence-bao-nhieu/">phí quản lý Sun Saphia Residence bao nhiêu</a>; các khoản một lần khi mua xem <a href="/chi-phi-mua-sun-saphia-residence-ngoai-gia-ban/">chi phí mua Sun Saphia ngoài giá bán</a>.</p>
<h2>Cách giảm tiền điện căn hộ Sun Saphia Residence</h2>
<ul>
<li><strong>Chọn hướng:</strong> căn phía Tây hứng nắng chiều, điều hòa chạy nặng hơn – cân nhắc rèm cản nắng, kính cách nhiệt (xem <a href="/huong-can-ho-sun-saphia-residence/">hướng căn hộ Sun Saphia Residence</a>).</li>
<li><strong>Thiết bị:</strong> điều hòa inverter, bếp từ, bình nóng lạnh có hẹn giờ khi làm nội thất.</li>
<li><strong>Thẻ ngắt điện:</strong> với căn cho thuê ngắn ngày, khóa thẻ từ ngắt điện khi khách ra ngoài.</li>
<li><strong>Ghi chỉ số:</strong> chụp công tơ khi khách nhận và trả phòng nếu cho thuê theo tháng.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Biểu giá mới có lợi cho nhóm lưu trú du lịch, nhưng tiền điện căn hộ Sun Saphia Residence áp nhóm nào thì phải chờ phương án cấp điện khi bàn giao. Khi lập bảng dòng tiền cho studio, Hiệp để tiền điện là chi phí của chủ căn với khách thuê đêm và tách ra cho khách thuê tháng tự trả theo công tơ – hai cách này chênh nhau rõ vào mùa hè. Giá điện còn có thể điều chỉnh theo định kỳ, nên nên xem lại khi nhận nhà. Xem thêm {$review}.</p>
<p>Cần bảng chi phí hằng tháng cho từng loại căn tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: biểu giá điện từ 1/11/2026 theo Quyết định 2892/QĐ-BCT như Tuổi Trẻ (1/11/2026), VnExpress (4/11/2026), Thanh Niên (4/11 và 11/11/2026) đưa tin; loại hình, phí quản lý dự kiến, bàn giao theo tài liệu chủ đầu tư (10 – 11/2026). Nhóm giá áp cho từng căn chưa được công bố.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiền điện căn hộ Sun Saphia Residence: giá 5 bậc 2026',
			'desc'      => 'Tiền điện căn hộ Sun Saphia Residence theo biểu giá từ 1/11/2026: sinh hoạt 5 bậc 1.901 – 3.844 đ/kWh, giá riêng cho lưu trú du lịch, ví dụ hóa đơn 300 kWh.',
			'points'    => array(
				'Tiền điện căn hộ Sun Saphia Residence: từ 1/11/2026 điện sinh hoạt còn 5 bậc, 1.901 – 3.844 đ/kWh chưa VAT',
				'Cơ sở lưu trú du lịch có nhóm giá riêng: 1.814 đ/kWh giờ bình thường, thấp hơn giá kinh doanh 2.829 đ/kWh',
				'Căn áp nhóm giá nào phụ thuộc phương án cấp điện khi bàn giao – cần hỏi công tơ, người đứng tên hợp đồng điện',
			),
			'faq'       => array(
				array( 'Tiền điện căn hộ Sun Saphia Residence tính giá sinh hoạt hay kinh doanh?', 'Chưa có thông tin chính thức. Phụ thuộc công tơ từng căn, người ký hợp đồng mua bán điện và mục đích sử dụng; cơ sở lưu trú du lịch có nhóm giá riêng từ 1/11/2026.' ),
				array( 'Dùng 300 kWh mỗi tháng trả bao nhiêu?', 'Theo ví dụ của VnExpress với biểu sinh hoạt 5 bậc, khoảng 708.400 đồng chưa VAT.' ),
				array( 'Giờ cao điểm ảnh hưởng tiền điện căn hộ Sun Saphia Residence thế nào?', 'Nếu áp giá theo thời gian sử dụng, giờ cao điểm 17h30 – 22h30 đắt nhất; thấp điểm 0h – 6h; Chủ nhật không có giờ cao điểm.' ),
				array( 'Làm sao giảm tiền điện căn hộ Sun Saphia Residence khi cho thuê?', 'Dùng điều hòa inverter, thẻ từ ngắt điện khi khách ra ngoài, rèm cản nắng cho căn phía Tây và tách tiền điện cho khách thuê tháng.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/gia-dien-giam-2-chi-tiet-muc-gia-5-bac-thang-dien-sinh-hoat-100261101091531402.htm',
			'https://vnexpress.net/gia-dien-sinh-hoat-theo-5-bac-cao-nhat-3-844-dong-mot-kwh-5139227.html',
			'https://thanhnien.vn/giam-hon-1500-ti-dong-tien-dien-moi-thang-18526111019531273.htm',
			'https://thanhnien.vn/evn-thong-tin-ve-thay-doi-trong-bieu-gia-dien-moi-185261104115238943.htm',
		),
	);

	/* ---------------- 28/11 11:30 – Đi Cù Lao Chàm ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-di-cu-lao-cham',
		'title'    => 'Từ Sun Saphia Residence đi Cù Lao Chàm: qua Cửa Đại, ca nô khoảng 20 phút và mùa nào nên đi',
		'excerpt'  => 'Cù Lao Chàm vừa có đề án du lịch 18 điểm sinh thái, mục tiêu 350.000 khách năm 2030 nhưng chỉ khoảng 35.000 khách ở lại đêm. Bài hướng dẫn đi từ Sun Saphia Residence ra đảo, mùa nên đi, lúc nào tàu tạm dừng và ý nghĩa với chủ căn cho thuê.',
		'keyword'  => 'Sun Saphia Residence đi Cù Lao Chàm',
		'keywords_extra' => array( 'đi Cù Lao Chàm từ Đà Nẵng', 'ca nô Cửa Đại Cù Lao Chàm', 'tour Cù Lao Chàm', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-28 11:30',
		'category' => 'Vị trí – tiện ích',
		'tags'     => array( 'Sun Saphia Residence', 'Cù Lao Chàm', 'Du lịch' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-view-tang-5-phong-khach-bien.jpg',
		'image_alt' => 'Sun Saphia Residence đi Cù Lao Chàm – phòng khách nhìn ra biển lúc bình minh (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p>Chuyến <strong>Sun Saphia Residence đi Cù Lao Chàm</strong> là một ngày biển mà khách thuê căn hộ ven biển Ngũ Hành Sơn hay hỏi: từ tòa tháp trên đường Trường Sa xuôi đường ven biển về Cửa Đại (Hội An), rồi đi ca nô ra đảo. Những ngày trời trong, từ dãy căn phía Đông của {$saphia} có thể thấy cụm đảo ở phía xa. Bài này tóm tắt cách đi, mùa nên đi, khi nào tàu tạm dừng và vì sao đảo quan trọng với người cho thuê căn hộ.</p>
<!--hh-featured-->
<h2>Sun Saphia Residence đi Cù Lao Chàm: đảo có gì mới?</h2>
<p>Theo <a href="https://tuoitre.vn/phat-trien-du-lich-o-dao-cu-lao-cham-voi-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-100261124101532942.htm">Tuổi Trẻ</a> ngày 24/11/2026, UBND TP Đà Nẵng phê duyệt đề án du lịch sinh thái, nghỉ dưỡng, giải trí ở Cù Lao Chàm đến 2030, tầm nhìn 2050: 18 điểm du lịch trên gần 510 ha, 12 tuyến sinh thái dài 39,8 km. Đảo hiện đón khoảng 2.000 – 3.000 khách mỗi ngày, có khoảng 2.500 cư dân thuộc xã Tân Hiệp, cách Hội An khoảng 20 phút ca nô. Chi tiết đề án xem bài <a href="/de-an-du-lich-cu-lao-cham-18-diem/">đề án du lịch Cù Lao Chàm 18 điểm</a>.</p>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Hiện nay / mục tiêu 2030</th></tr></thead>
<tbody>
<tr><td>Khách mỗi ngày</td><td>Khoảng 2.000 – 3.000 (hiện nay)</td></tr>
<tr><td>Khách mỗi năm</td><td>Khoảng 350.000 vào 2030 (140.000 quốc tế, 210.000 nội địa)</td></tr>
<tr><td>Khách lưu trú qua đêm trên đảo</td><td>Khoảng 35.000 vào 2030</td></tr>
<tr><td>Điểm du lịch</td><td>18 điểm: 12 điểm rừng, 6 điểm biển</td></tr>
</tbody>
</table>
<h2>Lộ trình Sun Saphia Residence đi Cù Lao Chàm</h2>
<ol>
<li><strong>Tòa tháp → Cửa Đại:</strong> đi theo trục ven biển Trường Sa – Lạc Long Quân về phía Hội An. Bài <a href="/sun-saphia-residence-di-hoi-an-bao-xa/">Sun Saphia Residence đi Hội An bao xa</a> ước tính quãng đường tới Hội An khoảng 22 – 25 km, 35 – 45 phút.</li>
<li><strong>Cửa Đại → đảo:</strong> ca nô khoảng 20 phút theo Tuổi Trẻ; phần lớn khách đi theo tour trọn ngày có đón tại chỗ ở.</li>
<li><strong>Trên đảo:</strong> tắm biển, lặn ngắm san hô, đi bộ đường mòn, ăn hải sản; chiều quay về đất liền.</li>
</ol>
<p>Với chuyến Sun Saphia Residence đi Cù Lao Chàm, thời gian, giá tour thay đổi theo mùa và đơn vị lữ hành, nên chủ căn hãy giới thiệu vài đơn vị có giấy phép thay vì nhận bán tour thay khách.</p>
<!--hh-img:img/sun-saphia/sun-saphia-poster-can-ho-mat-bien.jpg|Sun Saphia Residence đi Cù Lao Chàm – căn hộ mặt biển Sơn Thủy, ngày trời trong nhìn thấy cụm đảo phía xa (phối cảnh chủ đầu tư)-->
<h2>Mùa nào Sun Saphia Residence đi Cù Lao Chàm thuận lợi?</h2>
<p>Ra đảo phụ thuộc sóng gió. <a href="https://thanhnien.vn/hang-tram-du-khach-mac-ket-o-dao-cu-lao-cham-duoc-dua-vao-bo-an-toan-185260717191237478.htm">Thanh Niên</a> ngày 17/7/2026 đưa tin khoảng 300 du khách, phần lớn là khách quốc tế, mắc kẹt gần một ngày trên đảo vì thời tiết xấu khi Cảng vụ Hàng hải Đà Nẵng tạm dừng các phương tiện thủy cấp VR-SB; khách sau đó được đưa vào bờ an toàn. Nghĩa là lịch Sun Saphia Residence đi Cù Lao Chàm ngay cả mùa hè cũng có ngày tàu dừng, còn mùa mưa cuối năm khả năng này cao hơn.</p>
<ul>
<li>Nên đi vào mùa khô, biển êm; tránh những ngày có tin gió mạnh, sóng lớn.</li>
<li>Xem thông báo cho tàu xuất bến trước ngày đi; giữ một ngày dự phòng trong lịch.</li>
<li>Mang theo thuốc say sóng, đồ bơi, kem chống nắng thân thiện san hô – ba thứ khách hay quên khi Sun Saphia Residence đi Cù Lao Chàm.</li>
</ul>
<h2>Sun Saphia Residence đi Cù Lao Chàm: ý nghĩa với chủ căn cho thuê</h2>
<p>Đề án không mở đường cho resort lớn trên đảo: phân khu bảo vệ nghiêm ngặt không có hoạt động nghỉ dưỡng, công trình du lịch ở phân khu phục hồi sinh thái giới hạn 2% diện tích. Với mục tiêu khoảng 350.000 khách năm 2030 mà chỉ khoảng 35.000 khách ở lại đêm, phần lớn khách sẽ ngủ trên đất liền – Hội An, Điện Bàn và dải biển Đà Nẵng. Một tòa căn hộ ven biển như Sun Saphia có thể đón nhóm khách "ngủ ở Đà Nẵng, đi đảo trong ngày".</p>
<p>Khách gia đình thuê căn 2PN thường hỏi Hiệp có nên ở gần Hội An hơn để ra đảo; Hiệp hay gợi ý tính số ngày: ở 4 – 5 đêm thì một ngày đi Cù Lao Chàm, một ngày Hội An vẫn thuận từ Ngũ Hành Sơn, còn những ngày khác ở gần biển Sơn Thủy và trung tâm hơn.</p>
<h2>Gợi ý lịch trình Sun Saphia Residence đi Cù Lao Chàm trong ngày</h2>
<table>
<thead><tr><th>Giờ</th><th>Hoạt động</th></tr></thead>
<tbody>
<tr><td>Sáng sớm</td><td>Xe đón tại sảnh, đi Cửa Đại</td></tr>
<tr><td>Buổi sáng</td><td>Ca nô ra đảo, lặn ngắm san hô</td></tr>
<tr><td>Trưa</td><td>Ăn hải sản, nghỉ ở bãi tắm</td></tr>
<tr><td>Chiều</td><td>Về Cửa Đại, ghé phố cổ Hội An hoặc về thẳng căn hộ</td></tr>
</tbody>
</table>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Saphia Residence đi Cù Lao Chàm không phải lợi thế vị trí "sát cửa", nhưng là một trải nghiệm đáng ghi vào sổ tay hướng dẫn cho khách thuê. Chủ căn nên chuẩn bị sẵn thông tin mùa biển, lưu ý tàu tạm dừng và gợi ý ngày dự phòng – khách đánh giá tốt chủ nhà chu đáo hơn là quảng cáo xa vời. Xem thêm {$review}.</p>
<p>Cần sổ tay hướng dẫn khách thuê và lịch trình mẫu cho căn tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: đề án du lịch Cù Lao Chàm theo Tuổi Trẻ (24/11/2026); sự cố tạm dừng tàu theo Thanh Niên (17/7/2026); quãng đường đi Hội An là ước tính trong bài đã đăng trên hiephoangmt.com; thông tin dự án theo tài liệu chủ đầu tư (10 – 11/2026).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence đi Cù Lao Chàm: ca nô 20 phút 2026',
			'desc'      => 'Sun Saphia Residence đi Cù Lao Chàm: theo đường ven biển về Cửa Đại, ca nô khoảng 20 phút; đề án 18 điểm du lịch, mùa nên đi và lúc tàu tạm dừng.',
			'points'    => array(
				'Sun Saphia Residence đi Cù Lao Chàm: theo trục ven biển về Cửa Đại, ca nô ra đảo khoảng 20 phút',
				'Đề án 2030: 18 điểm du lịch, khoảng 350.000 khách/năm nhưng chỉ khoảng 35.000 khách ở lại đêm',
				'Tàu có thể tạm dừng khi thời tiết xấu – nên đi mùa biển êm và giữ ngày dự phòng',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence đi Cù Lao Chàm mất bao lâu?', 'Đi đường bộ về Hội An – Cửa Đại (ước 22 – 25 km, 35 – 45 phút tới Hội An), rồi ca nô khoảng 20 phút ra đảo.' ),
				array( 'Có ở lại đêm trên Cù Lao Chàm được không?', 'Có nhưng hạn chế; đề án đặt mục tiêu khoảng 35.000 khách lưu trú qua đêm năm 2030, phần lớn khách đi trong ngày.' ),
				array( 'Khi nào tàu ra Cù Lao Chàm tạm dừng?', 'Khi thời tiết xấu, sóng gió lớn, cơ quan chức năng tạm dừng phương tiện; tháng 7/2026 từng có khoảng 300 khách phải chờ trên đảo.' ),
				array( 'Sun Saphia Residence đi Cù Lao Chàm có lợi gì cho chủ căn cho thuê?', 'Đảo hạn chế chỗ ngủ nên nhiều khách sẽ lưu trú trên đất liền; căn hộ ven biển có thể đón nhóm khách đi đảo trong ngày.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/phat-trien-du-lich-o-dao-cu-lao-cham-voi-18-diem-du-lich-sinh-thai-nghi-duong-giai-tri-100261124101532942.htm',
			'https://thanhnien.vn/hang-tram-du-khach-mac-ket-o-dao-cu-lao-cham-duoc-dua-vao-bo-an-toan-185260717191237478.htm',
		),
	);

	/* ---------------- 28/11 13:30 – Sông Cổ Cò ---------------- */
	$posts[] = array(
		'slug'     => 'song-co-co-gan-sun-saphia-residence',
		'title'    => 'Sông Cổ Cò gần Sun Saphia Residence: dòng sông nối sông Hàn với Hội An đang được khơi thông',
		'excerpt'  => 'Phía sau Sun Saphia Residence là sông Cổ Cò – dòng sông chạy song song bờ biển, nối sông Hàn với Hội An, đang được Đà Nẵng và Hội An khơi thông với tổng vốn hơn 1.700 tỷ đồng. Bài nói rõ dự án đang ở đâu, tầm nhìn từ tầng cao và kỳ vọng hợp lý cho người mua.',
		'keyword'  => 'sông Cổ Cò gần Sun Saphia Residence',
		'keywords_extra' => array( 'khơi thông sông Cổ Cò', 'đường thủy Đà Nẵng Hội An', 'view sông Cổ Cò', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-28 13:30',
		'category' => 'Hạ tầng & quy hoạch',
		'tags'     => array( 'Sun Saphia Residence', 'Sông Cổ Cò', 'Hạ tầng' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-view-tang-20-ngu-hanh-son-song-co-co.jpg',
		'image_alt' => 'Sông Cổ Cò gần Sun Saphia Residence – tầm nhìn tầng 20 về Ngũ Hành Sơn và sông (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p><strong>Sông Cổ Cò gần Sun Saphia Residence</strong> là phần "sau lưng là sông" trong câu giới thiệu "trước mặt là biển, sau lưng là sông, bên cạnh là núi" của chủ đầu tư. Bộ ảnh tầm nhìn tầng 20 của {$saphia} cho thấy Ngũ Hành Sơn và dòng sông phía Tây. Dòng sông này từng là đường thủy nối Đà Nẵng với Hội An, bị bồi lấp hơn trăm năm và đang được khơi thông. Bài này tách phần đã có và phần còn là kế hoạch.</p>
<!--hh-featured-->
<h2>Sông Cổ Cò gần Sun Saphia Residence là sông gì?</h2>
<p>Theo <a href="https://tuoitre.vn/da-nang-quang-nam-ve-chung-nha-nhung-du-an-nao-thuan-da-trien-khai-20250507162636046.htm">Tuổi Trẻ</a> (5/2025), sông Cổ Cò chạy song song bờ biển, nối sông Hàn (Đà Nẵng) với cuối sông Thu Bồn (Hội An), từng quan trọng với hai thị cảng Đà Nẵng và Hội An. Hơn 100 năm trước sông bị bồi lấp nghiêm trọng; từ năm 2012 hai địa phương cùng khơi thông lại. Mục tiêu là khôi phục đường thủy từ sông Hàn vào Hội An, phát triển du lịch, tạo cảnh quan và thoát lũ.</p>
<table>
<thead><tr><th>Nội dung</th><th>Thông tin báo chí</th></tr></thead>
<tbody>
<tr><td>Chiều dài theo chủ trương khơi thông</td><td>Hơn 28,5 km, từ Đà Nẵng đến Hội An (Tuổi Trẻ, 10/2025)</td></tr>
<tr><td>Vốn phía Đà Nẵng</td><td>Hơn 500 tỷ đồng: nạo vét, thoát lũ, nâng cấp cầu bảo đảm tĩnh không</td></tr>
<tr><td>Vốn phía Quảng Nam (cũ)</td><td>1.200 tỷ đồng: nạo vét, thoát lũ, chống xâm nhập mặn, xây cầu</td></tr>
<tr><td>Hai bên bờ phía Đà Nẵng</td><td>Khu đô thị, sân golf, khu du lịch (Cổng thông tin Đà Nẵng, 2017)</td></tr>
</tbody>
</table>
<h2>Sông Cổ Cò gần Sun Saphia Residence nhìn thấy từ đâu?</h2>
<p>Tòa tháp nằm ở giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa; dãy căn phía sau nhìn về phía Tây, nơi có đô thị, sông và núi. Theo chủ đầu tư, công trình phía Tây được quy hoạch tối đa 7 tầng, nên từ khoảng tầng 8 trở lên tầm nhìn ít bị che. Phối cảnh tầm nhìn tầng 20 của chủ đầu tư thể hiện Ngũ Hành Sơn và sông Cổ Cò; tầm nhìn thật của từng căn cần đối chiếu mặt bằng và hướng khi nhận bảng hàng.</p>
<!--hh-img:img/sun-saphia/sun-saphia-view-tang-20-ngu-hanh-son-song-co-co.jpg|Sông Cổ Cò gần Sun Saphia Residence – tầm nhìn tầng 20 về Ngũ Hành Sơn và dòng sông phía Tây (phối cảnh chủ đầu tư)-->
<h2>Khơi thông sông Cổ Cò gần Sun Saphia Residence đang ở đâu?</h2>
<p>Tiến độ không đều giữa các đoạn. Tháng 10/2025, <a href="https://tuoitre.vn/nld/dien-bien-moi-vu-dan-da-nang-to-bun-dat-chat-dong-ven-song-co-co-196251009163420132.htm">Tuổi Trẻ</a> (Người Lao Động) đưa tin người dân phường Ngũ Hành Sơn phản ánh bùn đất chất đống ven sông trong quá trình nạo vét; việc đổ đất bị tạm dừng để xác minh. Chủ tịch HĐND TP Đà Nẵng Nguyễn Đức Dũng nhấn mạnh việc đổ đất dọc sông mà không xây kè phải kiểm tra vì có nguy cơ sạt trôi đất xuống sông.</p>
<p>Tóm lại, sông Cổ Cò gần Sun Saphia Residence là dự án đang làm, chưa phải tuyến du lịch đường thủy đã vận hành. Khi nào có tàu chạy từ sông Hàn về Hội An qua đoạn này, hiện chưa có lịch công bố.</p>
<h2>Sông Cổ Cò gần Sun Saphia Residence có ý nghĩa gì với người mua?</h2>
<ul>
<li><strong>Tầm nhìn:</strong> căn phía Tây tầng cao có thêm cảnh sông – núi thay vì chỉ mái nhà phố; nắng chiều thì cần tính chống nóng (xem <a href="/huong-can-ho-sun-saphia-residence/">hướng căn hộ Sun Saphia Residence</a>).</li>
<li><strong>Thoát nước, chống ngập:</strong> mục tiêu thoát lũ của dự án có ý nghĩa với cả khu Ngũ Hành Sơn trong mùa mưa.</li>
<li><strong>Du lịch dài hạn:</strong> nếu đường thủy được khôi phục, khách có thêm trải nghiệm thuyền về Hội An.</li>
<li><strong>Giai đoạn thi công:</strong> nạo vét, đổ đất, làm kè đoạn sông Cổ Cò gần Sun Saphia Residence có thể gây bụi, xe tải ở một số đoạn.</li>
</ul>
<h2>Chọn tầng nếu muốn nhìn sông Cổ Cò gần Sun Saphia Residence</h2>
<p>Khách hỏi Hiệp căn nào nhìn được sông, Hiệp thường mở song song ảnh tầm nhìn tầng 20 và mặt bằng tầng 3A – 28 để chỉ ra dãy căn phía sau và hai cánh nhìn chéo về Ngũ Hành Sơn, rồi lưu ý rằng ảnh là phối cảnh, độ cao thực của mỗi tầng chỉ khoảng 3,5 m. Tầng càng cao càng thoáng, nhưng giá dự kiến cũng tăng theo tầng. Cách so tầng xem bài <a href="/tang-cao-hay-tang-thap-sun-saphia-residence/">tầng cao hay tầng thấp Sun Saphia Residence</a>.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sông Cổ Cò gần Sun Saphia Residence là điểm cộng về cảnh quan và hạ tầng dài hạn, nhưng không nên trả giá cho tuyến đường thủy chưa có lịch vận hành. Chọn căn vì biển, giá, mặt bằng; coi dòng sông phía sau là phần thưởng thêm cho căn phía Tây tầng cao. Xem thêm {$review}.</p>
<p>Cần ảnh tầm nhìn theo tầng và mặt bằng căn phía Tây tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: thông tin sông Cổ Cò theo Tuổi Trẻ (7/5/2025, 9/10/2025) và Cổng thông tin Đà Nẵng (bài "Phố mới bên sông Cổ Cò", 2017); vị trí, quy hoạch phía Tây, ảnh tầm nhìn theo tài liệu chủ đầu tư (10 – 11/2026). Tầm nhìn thực tế từng căn có thể khác phối cảnh.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sông Cổ Cò gần Sun Saphia Residence: 28,5 km tới Hội An',
			'desc'      => 'Sông Cổ Cò gần Sun Saphia Residence nối sông Hàn với Hội An, đang khơi thông hơn 28,5 km. Vốn, tiến độ, tầm nhìn từ tầng cao và kỳ vọng hợp lý khi mua.',
			'points'    => array(
				'Sông Cổ Cò gần Sun Saphia Residence nằm phía Tây dự án, nối sông Hàn với cuối sông Thu Bồn (Hội An)',
				'Vốn khơi thông sông Cổ Cò gần Sun Saphia Residence: phía Đà Nẵng hơn 500 tỷ, phía Quảng Nam cũ 1.200 tỷ; chủ trương hơn 28,5 km',
				'Chưa có lịch tàu du lịch đường thủy – coi dòng sông là điểm cộng cảnh quan, không tính vào giá',
			),
			'faq'       => array(
				array( 'Sông Cổ Cò gần Sun Saphia Residence ở phía nào?', 'Ở phía Tây dự án; phối cảnh tầm nhìn tầng 20 của chủ đầu tư thể hiện Ngũ Hành Sơn và sông Cổ Cò.' ),
				array( 'Sông Cổ Cò đã có tàu du lịch chưa?', 'Chưa có lịch công bố. Dự án khơi thông đang triển khai, mục tiêu khôi phục đường thủy từ sông Hàn vào Hội An.' ),
				array( 'Căn nào nhìn được sông Cổ Cò gần Sun Saphia Residence?', 'Dãy căn phía sau và cánh nhìn chéo về Ngũ Hành Sơn, tầng cao (khoảng từ tầng 8 trở lên) ít bị che hơn.' ),
				array( 'Dự án khơi thông sông Cổ Cò bao nhiêu vốn?', 'Theo Tuổi Trẻ (5/2025), phía Đà Nẵng hơn 500 tỷ đồng, phía Quảng Nam cũ 1.200 tỷ đồng.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/da-nang-quang-nam-ve-chung-nha-nhung-du-an-nao-thuan-da-trien-khai-20250507162636046.htm',
			'https://tuoitre.vn/nld/dien-bien-moi-vu-dan-da-nang-to-bun-dat-chat-dong-ven-song-co-co-196251009163420132.htm',
			'https://danang.gov.vn/vi/w/pho-moi-ben-song-co-co-i',
		),
	);

	/* ---------------- 28/11 18:00 – Khách Ấn Độ ---------------- */
	$posts[] = array(
		'slug'     => 'khach-an-do-thue-sun-saphia-residence',
		'title'    => 'Khách Ấn Độ thuê Sun Saphia Residence: thị trường tăng 45,6%, ở 5 – 7 ngày, cần bếp và căn rộng',
		'excerpt'  => 'Khách Ấn Độ đến Việt Nam tăng 45,6% trong 6 tháng đầu 2026, thường ở 5 – 7 ngày, đi theo gia đình, đám cưới, hội nghị và cần bữa chay. Bài phân tích khách Ấn Độ thuê Sun Saphia Residence: loại căn phù hợp, cách chuẩn bị căn và điều cần thận trọng.',
		'keyword'  => 'khách Ấn Độ thuê Sun Saphia Residence',
		'keywords_extra' => array( 'khách Ấn Độ đến Đà Nẵng', 'du lịch cưới Ấn Độ Đà Nẵng', 'đường bay Ấn Độ Đà Nẵng', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-28 18:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Khách quốc tế', 'Cho thuê' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-tien-ich-ho-boi-2.jpg',
		'image_alt' => 'Khách Ấn Độ thuê Sun Saphia Residence – bể bơi ngoài trời nhìn biển (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p><strong>Khách Ấn Độ thuê Sun Saphia Residence</strong> là nhóm khách mà người mua căn để cho thuê nên để mắt tới, bên cạnh khách Hàn Quốc vốn đông nhất. Thị trường này tăng nhanh, ở lâu hơn mức trung bình và hay đi theo gia đình, đoàn cưới – đúng chỗ căn hộ có bếp, có căn 2PN của {$saphia} khác phòng khách sạn. Bài này tổng hợp số liệu báo chí và gợi ý cách chuẩn bị căn.</p>
<!--hh-featured-->
<h2>Khách Ấn Độ thuê Sun Saphia Residence: thị trường tăng thế nào?</h2>
<p>Theo <a href="https://thanhnien.vn/dieu-gi-hut-khach-an-do-den-viet-nam-185260715174439725.htm">Thanh Niên</a> (16/7/2026), dẫn số liệu Cục Du lịch Quốc gia, khách Ấn Độ đến Việt Nam 6 tháng đầu 2026 tăng 45,6%, trong khi tổng khách quốc tế gần 12,3 triệu lượt, tăng 14,9%. Phần lớn khách Ấn Độ ở 5 – 7 ngày, thường kết hợp nhiều điểm đến; có đường bay thẳng từ New Delhi, Mumbai, Ahmedabad, Bengaluru tới Hà Nội, TP.HCM và Đà Nẵng.</p>
<table>
<thead><tr><th>Chỉ số</th><th>Số liệu</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Tăng trưởng khách Ấn Độ đến Việt Nam</td><td>+45,6% (6 tháng đầu 2026)</td><td>Thanh Niên</td></tr>
<tr><td>Thời gian ở phổ biến</td><td>5 – 7 ngày</td><td>Thanh Niên</td></tr>
<tr><td>Kỳ vọng thị trường Ấn Độ tại Đà Nẵng 2026</td><td>+10 – 20%</td><td>Cổng thông tin Đà Nẵng</td></tr>
<tr><td>Đường bay quốc tế thường kỳ đến Đà Nẵng</td><td>21 đường (tổng 28 đường bay)</td><td>Cổng thông tin Đà Nẵng</td></tr>
</tbody>
</table>
<p><a href="https://danang.gov.vn/vi/web/dng/w/du-lich-da-nang-ky-vong-but-pha-nho-le-hoi-va-mo-rong-duong-bay">Cổng thông tin Đà Nẵng</a> (28/5/2026) cho biết thành phố kỳ vọng thị trường Ấn Độ tăng 10 – 20% trong năm. <a href="https://tuoitre.vn/da-nang-ban-chuyen-giu-chan-khach-du-lich-trong-ngay-hoi-hon-500-doi-tac-100261018112917733.htm">Tuổi Trẻ</a> (18/10/2026) nêu định hướng sản phẩm cho khách Ấn Độ: cưới, hội nghị và du lịch gia đình.</p>
<h2>Khách Ấn Độ thuê Sun Saphia Residence cần gì?</h2>
<ul>
<li><strong>Bếp và ăn chay:</strong> Thanh Niên ghi nhận nhu cầu thực đơn chay, Jain, Halal. Căn hộ có bếp cho khách tự nấu là lợi thế rõ so với phòng khách sạn.</li>
<li><strong>Không gian cho gia đình:</strong> đi theo nhóm nhiều thế hệ, ở 5 – 7 ngày – hợp căn 2PN 60 – 70 m² hoặc hai căn liền kề.</li>
<li><strong>Dịp cưới, sự kiện:</strong> khách dự cưới thường ở gần khách sạn tổ chức tiệc; dải resort ven biển Ngũ Hành Sơn ngay cạnh dự án.</li>
<li><strong>Tiện ích thư giãn:</strong> bể bơi nhìn biển, gym, yoga trong tòa theo tài liệu chủ đầu tư.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-70m2.jpg|Khách Ấn Độ thuê Sun Saphia Residence – căn 2PN khoảng 70 m² có bếp, hợp gia đình ở 5 – 7 ngày (layout chủ đầu tư)-->
<h2>Khách Ấn Độ thuê Sun Saphia Residence: chọn loại căn nào?</h2>
<table>
<thead><tr><th>Loại căn</th><th>Hợp nhóm khách Ấn Độ nào</th><th>Lưu ý</th></tr></thead>
<tbody>
<tr><td>Studio 30 – 31 m²</td><td>Cặp đôi, khách công tác, khách hội nghị</td><td>Bếp gọn, cần tủ lạnh đủ lớn</td></tr>
<tr><td>1PN+ 49 – 51 m²</td><td>Vợ chồng có một con, ở dài ngày</td><td>Phòng đa năng kê thêm giường</td></tr>
<tr><td>2PN 60 – 70 m²</td><td>Gia đình nhiều thế hệ, đoàn cưới</td><td>Căn góc hai mặt thoáng, giá cao hơn</td></tr>
</tbody>
</table>
<p>So sánh kỹ các mẫu 2PN ở bài <a href="/can-2pn-sun-saphia-residence-60-70m2/">căn 2PN Sun Saphia Residence 60 – 70 m²</a>; bức tranh khách quốc tế chung, nhất là khách Hàn Quốc, ở bài <a href="/khach-quoc-te-thue-can-ho-da-nang-2026/">khách quốc tế thuê căn hộ Đà Nẵng 2026</a>.</p>
<h2>Chuẩn bị căn cho khách Ấn Độ thuê Sun Saphia Residence</h2>
<ol>
<li>Bếp có nồi, chảo riêng; ghi rõ trong mô tả phòng nếu căn phù hợp nấu chay.</li>
<li>Hướng dẫn bằng tiếng Anh: nội quy tòa nhà, giờ bể bơi, cách đổ rác.</li>
<li>Danh sách quán chay, nhà hàng Ấn quanh khu biển và trung tâm.</li>
<li>Giường phụ, nệm gấp cho nhóm đông người – trong giới hạn số khách nội quy cho phép.</li>
<li>Giá theo tuần cho khách ở 5 – 7 ngày thay vì chỉ giá đêm – kiểu giá hợp nhất với khách Ấn Độ thuê Sun Saphia Residence.</li>
</ol>
<h2>Khách Ấn Độ thuê Sun Saphia Residence và văn hóa Chăm</h2>
<p>Một điểm ít người để ý: Chính phủ Ấn Độ tài trợ trùng tu nhiều nhóm tháp ở Thánh địa Mỹ Sơn. <a href="https://thanhnien.vn/cap-cuu-vung-thap-cua-nhung-bao-vat-quoc-gia-o-thanh-dia-my-son-185260615215527437.htm">Thanh Niên</a> (6/2026) cho biết dự án ở nhóm E-F do Ấn Độ tài trợ khoảng 115 tỷ đồng. Với khách Ấn Độ thuê Sun Saphia Residence, một ngày đi Mỹ Sơn hoặc Bảo tàng Điêu khắc Chăm là gợi ý có ý nghĩa, ăn khớp với cảm hứng Chăm Pa trong kiến trúc tòa tháp.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Khách Ấn Độ thuê Sun Saphia Residence là nhóm tiềm năng nhưng chưa thể thay khách Hàn Quốc làm trụ cột. Hiệp thấy căn 2PN góc và 1PN+ hưởng lợi nhiều nhất từ nhóm này vì khách đi đông, ở 5 – 7 ngày và cần bếp – ngược với studio vốn dựa vào khách cặp đôi ở ngắn. Dự án bàn giao dự kiến 11/2028, nên số liệu thị trường cần cập nhật lại trước khi lập kế hoạch cho thuê. Xem thêm {$review}.</p>
<p>Cần phân tích loại căn theo nhóm khách quốc tế tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: số liệu khách Ấn Độ theo Thanh Niên (16/7/2026), định hướng thị trường theo Tuổi Trẻ (18/10/2026) và Cổng thông tin Đà Nẵng (28/5/2026); trùng tu Mỹ Sơn theo Thanh Niên (16/6/2026); loại căn, tiện ích, bàn giao theo tài liệu chủ đầu tư (10 – 11/2026).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Khách Ấn Độ thuê Sun Saphia Residence: tăng 45,6% 2026',
			'desc'      => 'Khách Ấn Độ thuê Sun Saphia Residence: thị trường tăng 45,6% đầu 2026, ở 5 – 7 ngày, đi gia đình, cần bếp nấu chay. Loại căn phù hợp và cách chuẩn bị.',
			'points'    => array(
				'Khách Ấn Độ thuê Sun Saphia Residence: thị trường tăng 45,6% trong 6 tháng đầu 2026, thường ở 5 – 7 ngày',
				'Đà Nẵng kỳ vọng khách Ấn Độ tăng 10 – 20% năm 2026, định hướng sản phẩm cưới, hội nghị, gia đình',
				'Khách Ấn Độ thuê Sun Saphia Residence hợp căn 2PN và 1PN+ có bếp; chuẩn bị giá tuần, bếp nấu chay, hướng dẫn tiếng Anh',
			),
			'faq'       => array(
				array( 'Khách Ấn Độ thuê Sun Saphia Residence thường ở bao lâu?', 'Theo Thanh Niên, phần lớn khách Ấn Độ đến Việt Nam ở 5 – 7 ngày, thường kết hợp nhiều điểm đến.' ),
				array( 'Có đường bay thẳng từ Ấn Độ đến Đà Nẵng không?', 'Có. Thanh Niên (7/2026) nêu các chuyến bay thẳng từ New Delhi, Mumbai, Ahmedabad, Bengaluru tới Hà Nội, TP.HCM và Đà Nẵng.' ),
				array( 'Loại căn nào hợp khách Ấn Độ thuê Sun Saphia Residence?', 'Căn 2PN 60 – 70 m² cho gia đình nhiều thế hệ, đoàn cưới; 1PN+ cho gia đình nhỏ; studio cho cặp đôi, khách hội nghị.' ),
				array( 'Cần chuẩn bị gì cho khách Ấn Độ?', 'Bếp phù hợp nấu chay, hướng dẫn tiếng Anh, danh sách quán chay và giá theo tuần.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/dieu-gi-hut-khach-an-do-den-viet-nam-185260715174439725.htm',
			'https://danang.gov.vn/vi/web/dng/w/du-lich-da-nang-ky-vong-but-pha-nho-le-hoi-va-mo-rong-duong-bay',
			'https://tuoitre.vn/da-nang-ban-chuyen-giu-chan-khach-du-lich-trong-ngay-hoi-hon-500-doi-tac-100261018112917733.htm',
			'https://thanhnien.vn/cap-cuu-vung-thap-cua-nhung-bao-vat-quoc-gia-o-thanh-dia-my-son-185260615215527437.htm',
		),
	);

	/* ---------------- 29/11 11:30 – Phường Ngũ Hành Sơn ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-phuong-ngu-hanh-son',
		'title'    => 'Sun Saphia Residence ở phường Ngũ Hành Sơn: phường gộp từ 4 phường cũ, hơn 40 km² và điều cần biết về địa chỉ',
		'excerpt'  => 'Từ 1/7/2025, quận Ngũ Hành Sơn cũ thành phường Ngũ Hành Sơn – gộp Mỹ An, Khuê Mỹ, Hòa Hải, Hòa Quý. Bài giải thích địa chỉ Sun Saphia Residence phường Ngũ Hành Sơn, quy mô phường mới, những gì có trong phường và lưu ý giấy tờ khi mua, khi ở.',
		'keyword'  => 'Sun Saphia Residence phường Ngũ Hành Sơn',
		'keywords_extra' => array( 'phường Ngũ Hành Sơn sau sáp nhập', 'Hòa Hải cũ', 'Nghị quyết 1659/NQ-UBTVQH15', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-29 11:30',
		'category' => 'Vị trí – tiện ích',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn', 'Địa giới hành chính' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-so-do-vi-tri.jpg',
		'image_alt' => 'Sun Saphia Residence phường Ngũ Hành Sơn – sơ đồ vị trí trên đường Trường Sa, khu Sơn Thủy',
		'content'  => <<<HTML
<p>Trên tài liệu mới, địa chỉ <strong>Sun Saphia Residence phường Ngũ Hành Sơn</strong> được ghi là giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn, TP Đà Nẵng; một số giấy tờ cũ vẫn ghi phường Hòa Hải, quận Ngũ Hành Sơn. Hai cách ghi cùng chỉ một vị trí của {$saphia}. Bài này giải thích phường mới hình thành thế nào, có gì trong phường và người mua cần lưu ý gì về địa chỉ.</p>
<!--hh-featured-->
<h2>Sun Saphia Residence phường Ngũ Hành Sơn: phường hình thành từ đâu?</h2>
<p>Theo Nghị quyết 1659/NQ-UBTVQH15 ngày 16/6/2025 về sắp xếp đơn vị hành chính cấp xã của Đà Nẵng, toàn bộ diện tích và dân số của 4 phường Mỹ An, Khuê Mỹ, Hòa Hải và Hòa Quý được nhập thành phường Ngũ Hành Sơn, hoạt động từ 1/7/2025. <a href="https://danang.gov.vn/en/w/phuong-ngu-hanh-son">Cổng thông tin Đà Nẵng</a> ghi phường có diện tích 40,19 km², trụ sở tại 486 Lê Văn Hiến.</p>
<table>
<thead><tr><th>Nội dung</th><th>Phường Ngũ Hành Sơn</th></tr></thead>
<tbody>
<tr><td>Gộp từ</td><td>Mỹ An, Khuê Mỹ, Hòa Hải, Hòa Quý (quận Ngũ Hành Sơn cũ)</td></tr>
<tr><td>Diện tích</td><td>40,19 km²</td></tr>
<tr><td>Dân số</td><td>Hơn 112.000 người (Thanh Niên, 6/2026)</td></tr>
<tr><td>Doanh nghiệp, hộ kinh doanh</td><td>Hơn 3.500 doanh nghiệp, khoảng 9.600 hộ kinh doanh</td></tr>
<tr><td>Trụ sở</td><td>486 Lê Văn Hiến</td></tr>
</tbody>
</table>
<h2>Sun Saphia Residence phường Ngũ Hành Sơn: vị trí trong phường</h2>
<p>Dự án thuộc phần Hòa Hải cũ, trên dải biển Sơn Thủy giữa Mỹ Khê và Non Nước. Phía Bắc là khu Mỹ An – Khuê Mỹ cũ với phố du lịch An Thượng, bãi biển Mỹ An; phía Nam là danh thắng Ngũ Hành Sơn, làng đá Non Nước và dải resort; phía Tây là các khu dân cư dọc Lê Văn Hiến và sông. Trước mặt dự án là công viên bãi tắm khoảng 2,45 ha thành phố đang đầu tư.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tong-the-cong-vien-bai-tam.jpg|Sun Saphia Residence phường Ngũ Hành Sơn – mặt bằng tổng thể và công viên bãi tắm phía trước (tài liệu chủ đầu tư)-->
<h2>Quanh Sun Saphia Residence phường Ngũ Hành Sơn có gì?</h2>
<p>Theo <a href="https://thanhnien.vn/ngu-hanh-son-tang-toc-phat-trien-sau-sap-nhap-185260616160927085.htm">Thanh Niên</a> (17/6/2026), 5 tháng đầu 2026 phường đón hơn 1 triệu lượt khách, trong đó hơn 680.000 khách quốc tế; thu từ Danh thắng Ngũ Hành Sơn hơn 43,3 tỷ đồng. Làng nghề đá mỹ nghệ Non Nước có 385 cơ sở, khoảng 1.250 lao động. Năm 2026 phường có 117 dự án đầu tư công với tổng kế hoạch vốn gần 200 tỷ đồng và đặt mục tiêu xây dựng "đô thị du lịch hiện đại, văn minh".</p>
<ul>
<li><strong>Du lịch:</strong> biển Mỹ An – Sơn Thủy – Non Nước, danh thắng Ngũ Hành Sơn (xem <a href="/danh-thang-ngu-hanh-son-gan-sun-saphia-residence/">danh thắng Ngũ Hành Sơn gần Sun Saphia</a>).</li>
<li><strong>Làng nghề:</strong> đá mỹ nghệ Non Nước – quà tặng, trải nghiệm cho khách thuê căn Sun Saphia Residence phường Ngũ Hành Sơn.</li>
<li><strong>Hạ tầng:</strong> trục Võ Nguyên Giáp – Trường Sa, Lê Văn Hiến; các dự án công viên, chỉnh trang đô thị.</li>
</ul>
<h2>Địa chỉ Sun Saphia Residence phường Ngũ Hành Sơn trên giấy tờ</h2>
<p>Sau sắp xếp, tên tổ dân phố cũng đổi. <a href="https://tuoitre.vn/mot-phuong-o-da-nang-co-260-to-dan-pho-20250806123522634.htm">Tuổi Trẻ</a> (8/2025) đưa tin phường đổi tên 260 tổ dân phố của 4 phường cũ vì trùng tên: Mỹ An 75, Khuê Mỹ 43, Hòa Hải 76, Hòa Quý 66 tổ. Với người mua căn hộ, các điểm nên kiểm tra:</p>
<ol>
<li>Hợp đồng mua bán, văn bản pháp lý dự án ghi địa chỉ theo đơn vị hành chính nào; tài liệu cũ ghi Hòa Hải vẫn là cùng một vị trí.</li>
<li>Khi đăng ký tạm trú, cư trú sau bàn giao: ghi Sun Saphia Residence phường Ngũ Hành Sơn, dùng đúng tên phường mới.</li>
<li>Khi đăng tin cho thuê: ghi "phường Ngũ Hành Sơn (Hòa Hải cũ)" để khách quen tên cũ vẫn tìm được.</li>
</ol>
<p>Phân biệt thêm với khu đô thị cùng tên Saphia ở bài <a href="/sun-saphia-residence-va-khu-do-thi-saphia/">Sun Saphia Residence và Khu đô thị Saphia</a>.</p>
<h2>Sun Saphia Residence phường Ngũ Hành Sơn có lợi gì từ phường mới?</h2>
<p>Gộp 4 phường thành một đơn vị quy mô hơn 40 km² giúp quy hoạch du lịch ven biển, công viên, chỉnh trang đô thị được tính chung một khu. Hiệp thấy điều đáng giá nhất với Sun Saphia Residence phường Ngũ Hành Sơn là con số hơn 680.000 khách quốc tế trong 5 tháng: khách đến phường chủ yếu vì biển và danh thắng – đúng nhóm khách căn hộ ven biển cần. Tuy vậy, đây là số liệu toàn phường, không phải lượng khách sẽ thuê căn trong tòa.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Địa chỉ Sun Saphia Residence phường Ngũ Hành Sơn chỉ là thay tên hành chính, không đổi vị trí hay pháp lý dự án. Người mua nên đối chiếu tên phường trên hợp đồng, giữ bản tài liệu ghi cả tên cũ và mới, và dùng tên mới khi làm thủ tục sau bàn giao dự kiến 11/2028. Xem thêm {$review}.</p>
<p>Cần sơ đồ vị trí và bản đồ kết nối trong phường Ngũ Hành Sơn của {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: sắp xếp đơn vị hành chính theo Nghị quyết 1659/NQ-UBTVQH15 (16/6/2025), diện tích, trụ sở theo Cổng thông tin Đà Nẵng (28/6/2025); số liệu kinh tế – du lịch phường theo Thanh Niên (17/6/2026); đổi tên tổ dân phố theo Tuổi Trẻ (6/8/2025); địa chỉ dự án theo tài liệu chủ đầu tư (10 – 11/2026).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence phường Ngũ Hành Sơn: 4 phường gộp 2025',
			'desc'      => 'Sun Saphia Residence phường Ngũ Hành Sơn: phường gộp từ Mỹ An, Khuê Mỹ, Hòa Hải, Hòa Quý từ 1/7/2025, rộng 40,19 km². Địa chỉ mới, cũ và lưu ý giấy tờ.',
			'points'    => array(
				'Sun Saphia Residence phường Ngũ Hành Sơn: thuộc phần Hòa Hải cũ, giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa',
				'Sun Saphia Residence phường Ngũ Hành Sơn: phường gộp 4 phường từ 1/7/2025, rộng 40,19 km², hơn 112.000 dân',
				'5 tháng đầu 2026 phường đón hơn 1 triệu lượt khách, hơn 680.000 khách quốc tế',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence phường Ngũ Hành Sơn hay phường Hòa Hải?', 'Từ 1/7/2025 là phường Ngũ Hành Sơn; tài liệu cũ ghi phường Hòa Hải, quận Ngũ Hành Sơn – cùng một vị trí.' ),
				array( 'Phường Ngũ Hành Sơn gồm những phường cũ nào?', 'Mỹ An, Khuê Mỹ, Hòa Hải và Hòa Quý theo Nghị quyết 1659/NQ-UBTVQH15.' ),
				array( 'Đổi tên phường có ảnh hưởng pháp lý dự án không?', 'Không đổi vị trí hay pháp lý; chỉ cần đối chiếu tên đơn vị hành chính trên hợp đồng và giấy tờ.' ),
				array( 'Trụ sở phường Ngũ Hành Sơn ở đâu?', 'Tại 486 Lê Văn Hiến theo Cổng thông tin Đà Nẵng.' ),
			),
		),
		'sources'  => array(
			'https://danang.gov.vn/en/w/phuong-ngu-hanh-son',
			'https://thanhnien.vn/ngu-hanh-son-tang-toc-phat-trien-sau-sap-nhap-185260616160927085.htm',
			'https://tuoitre.vn/mot-phuong-o-da-nang-co-260-to-dan-pho-20250806123522634.htm',
		),
	);

	/* ---------------- 29/11 13:30 – So với An Thượng ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-so-voi-an-thuong',
		'title'    => 'Sun Saphia Residence so với An Thượng: ở dải biển yên tĩnh hay giữa phố Tây sôi động',
		'excerpt'  => 'An Thượng là phố du lịch đông khách quốc tế nhất Ngũ Hành Sơn; Sun Saphia Residence nằm trên dải biển Sơn Thủy yên tĩnh hơn, đối diện công viên bãi tắm. Bài so sánh hai khu theo nhóm khách, tiện ích quanh nhà, đêm và ngày, để chọn đúng chỗ để ở hoặc cho thuê.',
		'keyword'  => 'Sun Saphia Residence so với An Thượng',
		'keywords_extra' => array( 'phố Tây An Thượng', 'ở đâu khi đến Đà Nẵng', 'căn hộ gần biển Mỹ An', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-29 13:30',
		'category' => 'Kinh nghiệm mua nhà',
		'tags'     => array( 'Sun Saphia Residence', 'An Thượng', 'So sánh khu vực' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg',
		'image_alt' => 'Sun Saphia Residence so với An Thượng – tòa tháp bên dải biển Sơn Thủy (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p>Câu hỏi <strong>Sun Saphia Residence so với An Thượng</strong> thường đến từ người từng ở Đà Nẵng vài lần: nên chọn căn hộ trong tòa tháp trên dải biển Sơn Thủy, hay một căn ở khu phố Tây An Thượng quen thuộc, cách biển Mỹ An vài bước chân? Cả hai cùng thuộc phường Ngũ Hành Sơn, cùng gần biển, nhưng nhịp sống khác hẳn. Bài này so theo nhóm khách, tiện ích và sản phẩm để anh chị chọn đúng {$saphia} hay An Thượng cho mục đích của mình.</p>
<!--hh-featured-->
<h2>Sun Saphia Residence so với An Thượng: An Thượng là khu thế nào?</h2>
<p>Theo <a href="https://thanhnien.vn/kham-pha-du-lich-dem-o-pho-tay-an-thuong-185240305153936782.htm">Thanh Niên</a>, khu phố du lịch An Thượng thuộc Mỹ An cũ, nằm trong khu vực các đường Võ Nguyên Giáp, Hoàng Kế Viêm, Châu Thị Vĩnh Tế, Ngô Thì Sĩ; phố đi bộ và chợ đêm ở các tuyến An Thượng 1 – 4, Hoàng Kế Viêm, Trần Bạch Đằng. Khu tập trung nhà hàng, khách sạn, spa, bar, định hướng phục vụ khách nước ngoài, càng về đêm càng đông, ra biển Mỹ An chưa đầy 5 phút.</p>
<p><a href="https://danangstay.com.vn/vi/o-dau-khi-den-da-nang-so-sanh-cac-khu-vuc-vi/">Cẩm nang so sánh các khu lưu trú ở Đà Nẵng</a> xếp Mỹ Khê – An Thượng là lựa chọn cho khách đến lần đầu, cặp đôi, gia đình nhờ đi bộ được tới quán xá, nhưng đông và "du lịch" hơn; khu biển phía Nam về Non Nước hợp gia đình, khách chơi golf, nghỉ resort, yên tĩnh hơn nhưng phụ thuộc xe.</p>
<h2>Sun Saphia Residence so với An Thượng: bảng so nhanh</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Sun Saphia Residence</th><th>Khu An Thượng</th></tr></thead>
<tbody>
<tr><td>Sản phẩm</td><td>Tòa 30 tầng, 782 căn, thời hạn 50 năm, bàn giao dự kiến 11/2028</td><td>Nhà phố, khách sạn mini, căn hộ dịch vụ thấp tầng – đang vận hành</td></tr>
<tr><td>Trước nhà</td><td>Công viên bãi tắm khoảng 2,45 ha, biển Sơn Thủy</td><td>Phố quán xá, biển Mỹ An qua đường Võ Nguyên Giáp</td></tr>
<tr><td>Tiện ích trong nhà</td><td>Bể bơi nhìn biển, gym, yoga, khối đế thương mại, 2 tầng hầm</td><td>Tùy từng tòa, phần lớn không có hầm</td></tr>
<tr><td>Ban đêm</td><td>Yên tĩnh hơn, view biển và đô thị từ tầng cao</td><td>Sôi động, bar, chợ đêm, âm nhạc đường phố</td></tr>
<tr><td>Hợp với</td><td>Gia đình, khách ở dài, người cần yên tĩnh</td><td>Khách trẻ, khách thích ra phố đi bộ</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-cdt-khoi-de-pho-bien.jpg|Sun Saphia Residence so với An Thượng – khối đế thương mại dưới chân tòa thay cho dãy quán của phố du lịch (phối cảnh chủ đầu tư)-->
<h2>Sun Saphia Residence so với An Thượng khi cho thuê</h2>
<p>An Thượng có lợi thế "đã có khách": khu phố đã nổi tiếng, khách tìm phòng theo tên khu. Đổi lại, nguồn cung phòng dày, cạnh tranh giá thường xuyên. Sun Saphia chưa có lịch sử cho thuê, 513 studio cùng tòa sẽ cạnh tranh nhau, nhưng có những thứ phòng ở An Thượng khó có: tầm nhìn biển từ tầng cao, bể bơi, thang máy, bãi xe, thương hiệu Sun Group dễ nhận diện trên các kênh đặt phòng.</p>
<p>Khi khách nhờ Hiệp so một căn hộ dịch vụ ở An Thượng với studio Sun Saphia, Hiệp đặt ba câu hỏi: căn ở An Thượng còn mấy năm sử dụng và pháp lý thế nào, dòng tiền đang có thật bao nhiêu, và anh chị có chờ được tới 11/2028 không. Người cần dòng tiền ngay nghiêng về căn đang vận hành; người mua để dành, nhắm khách gia đình nghiêng về tòa mới.</p>
<h2>Sun Saphia Residence so với An Thượng khi mua để ở</h2>
<ul>
<li><strong>Tiếng ồn:</strong> An Thượng sôi động về đêm – vui với khách du lịch, nhưng người ở lâu cần chọn kỹ con kiệt.</li>
<li><strong>Đi bộ:</strong> An Thượng đi bộ tới quán dễ hơn; ở Sun Saphia, phần lớn nhu cầu hằng ngày dựa vào khối đế và xe.</li>
<li><strong>Không gian:</strong> điểm hơn rõ nhất của Sun Saphia Residence so với An Thượng là công viên biển trước mặt cho trẻ con, người lớn tuổi đi dạo.</li>
</ul>
<p>Muốn biết quanh tòa có gì để ăn, xem bài <a href="/an-uong-quanh-sun-saphia-residence/">ăn uống quanh Sun Saphia Residence</a>; so với căn hộ có sẵn ven Mỹ Khê, xem <a href="/sun-saphia-residence-hay-can-ho-co-san/">Sun Saphia Residence hay căn hộ có sẵn</a>.</p>
<h2>Sun Saphia Residence so với An Thượng: hai khu bổ sung cho nhau</h2>
<p>An Thượng và Sun Saphia cùng thuộc phường Ngũ Hành Sơn (xem <a href="/sun-saphia-residence-phuong-ngu-hanh-son/">Sun Saphia Residence phường Ngũ Hành Sơn</a>) và cùng trục Võ Nguyên Giáp – Trường Sa. Khách ở căn hộ yên tĩnh trên dải Sơn Thủy vẫn có thể đi taxi một quãng ngắn lên An Thượng ăn tối, nghe nhạc rồi về. Vì vậy Sun Saphia Residence so với An Thượng không phải lựa chọn loại trừ nhau, mà là chọn nơi ngủ hợp nhịp sống.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Saphia Residence so với An Thượng: chọn An Thượng nếu cần căn đang có khách và thích phố; chọn Sun Saphia nếu muốn tòa mới, tiện ích đầy đủ, tầm nhìn biển và chấp nhận chờ bàn giao. Dù chọn bên nào, hãy kiểm tra pháp lý, thời hạn sử dụng và tính dòng tiền mùa thấp điểm trước khi xuống tiền. Bảng hàng Sun Saphia dự kiến có tại sự kiện 05/12/2026. Xem thêm {$review}.</p>
<p>Cần so một căn cụ thể ở An Thượng với căn tương đương tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: khu phố du lịch An Thượng theo Thanh Niên (5/3/2024); đặc điểm các khu lưu trú tham khảo cẩm nang DanangStay; thông tin dự án theo tài liệu chủ đầu tư (10 – 11/2026). So sánh mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence so với An Thượng: 5 tiêu chí 2026',
			'desc'      => 'Sun Saphia Residence so với An Thượng: dải biển Sơn Thủy yên tĩnh, tòa 30 tầng có bể bơi hay phố Tây sôi động sát biển Mỹ An. So để ở và cho thuê.',
			'points'    => array(
				'Sun Saphia Residence so với An Thượng: tòa 30 tầng mới, yên tĩnh, công viên biển trước mặt so với phố du lịch sôi động',
				'An Thượng có khách sẵn nhưng cung phòng dày; Sun Saphia có bể bơi, hầm xe, tầm nhìn biển nhưng chờ bàn giao 11/2028',
				'Sun Saphia Residence so với An Thượng: hai khu cùng phường Ngũ Hành Sơn, cùng trục Võ Nguyên Giáp – Trường Sa, bổ sung cho nhau',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence so với An Thượng, khu nào yên tĩnh hơn?', 'Dải biển Sơn Thủy quanh Sun Saphia yên tĩnh hơn; An Thượng sôi động về đêm với bar, chợ đêm, âm nhạc đường phố.' ),
				array( 'Cho thuê ở An Thượng hay Sun Saphia tốt hơn?', 'An Thượng có khách ngay nhưng cạnh tranh dày; Sun Saphia có tiện ích và thương hiệu nhưng chưa có lịch sử cho thuê, bàn giao dự kiến 11/2028.' ),
				array( 'Sun Saphia Residence so với An Thượng có cùng phường không?', 'Có, cả hai thuộc phường Ngũ Hành Sơn sau sắp xếp từ 1/7/2025.' ),
				array( 'Gia đình có con nhỏ nên chọn khu nào?', 'Khu biển yên tĩnh có công viên trước mặt như Sun Saphia thường hợp hơn; An Thượng hợp khách trẻ thích phố.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/kham-pha-du-lich-dem-o-pho-tay-an-thuong-185240305153936782.htm',
		),
	);

	/* ---------------- 29/11 18:00 – Đi Mỹ Sơn ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-di-my-son',
		'title'    => 'Từ Sun Saphia Residence đi Mỹ Sơn: thánh địa Chăm Pa cách Đà Nẵng khoảng 70 km, đi thế nào trong một ngày',
		'excerpt'  => 'Thánh địa Mỹ Sơn – di sản thế giới từ 1999, hơn 70 đền tháp Chăm Pa – cách Đà Nẵng khoảng 70 km. Bài hướng dẫn chuyến Sun Saphia Residence đi Mỹ Sơn: cách đi, ghép với Hội An, chi phí xe tham khảo, điểm mới năm 2026 và gợi ý cho khách thuê căn hộ.',
		'keyword'  => 'Sun Saphia Residence đi Mỹ Sơn',
		'keywords_extra' => array( 'Thánh địa Mỹ Sơn', 'đi Mỹ Sơn từ Đà Nẵng', 'tháp Chăm Pa', 'Sun Saphia Residence' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-29 18:00',
		'category' => 'Vị trí – tiện ích',
		'tags'     => array( 'Sun Saphia Residence', 'Mỹ Sơn', 'Du lịch' ),
		'image'    => 'plugin:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg',
		'image_alt' => 'Sun Saphia Residence đi Mỹ Sơn – tòa tháp cảm hứng Chăm Pa bên biển lúc hoàng hôn (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<p>Chuyến <strong>Sun Saphia Residence đi Mỹ Sơn</strong> nối hai đầu của cùng một câu chuyện: tòa tháp có kiến trúc lấy cảm hứng từ điêu khắc Chăm Pa, và thánh địa nơi người Chăm xây đền tháp suốt nhiều thế kỷ. Thánh địa Mỹ Sơn cách TP Đà Nẵng khoảng 70 km, đi về trong một ngày được. Bài này hướng dẫn cách đi từ {$saphia}, cách ghép với Hội An và những điểm mới năm 2026.</p>
<!--hh-featured-->
<h2>Sun Saphia Residence đi Mỹ Sơn: thánh địa có gì?</h2>
<p>Theo <a href="https://tuoitre.vn/thanh-dia-my-son-huyen-ao-trong-thung-lung-bao-quanh-rung-gia-20250814114339787.htm">Tuổi Trẻ</a>, Mỹ Sơn nay thuộc xã Thu Bồn, TP Đà Nẵng, được UNESCO công nhận di sản văn hóa thế giới ngày 4/12/1999 – cùng đợt với phố cổ Hội An. Khu di tích có hơn 70 đền tháp niên đại thế kỷ 7 – 13, bình quân khoảng 1.500 khách mỗi ngày, phần lớn là khách quốc tế. <a href="https://vnexpress.net/ba-nhom-thap-o-thanh-dia-my-son-sau-trung-tu-4550512.html">VnExpress</a> ghi thánh địa cách TP Đà Nẵng khoảng 70 km.</p>
<table>
<thead><tr><th>Thông tin</th><th>Chi tiết</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Di sản thế giới</td><td>4/12/1999</td><td>Tuổi Trẻ</td></tr>
<tr><td>Quy mô</td><td>Hơn 70 đền tháp, thế kỷ 7 – 13</td><td>Tuổi Trẻ</td></tr>
<tr><td>Bảo vật quốc gia</td><td>6 bảo vật, nhóm E-F có 4</td><td>Thanh Niên</td></tr>
<tr><td>Khoảng cách</td><td>Khoảng 70 km từ TP Đà Nẵng</td><td>VnExpress</td></tr>
</tbody>
</table>
<h2>Cách Sun Saphia Residence đi Mỹ Sơn</h2>
<ol>
<li><strong>Tour ghép:</strong> đón tại sảnh, có hướng dẫn viên – tiện cho khách nước ngoài.</li>
<li><strong>Xe riêng cả ngày:</strong> chủ động giờ giấc, ghép Hội An buổi chiều. <a href="https://danangstay.com.vn/vi/mot-chuyen-di-da-nang-ton-bao-nhieu-vi/">Cẩm nang chi phí chuyến đi Đà Nẵng</a> tham khảo xe riêng cả ngày khoảng 1 – 1,8 triệu đồng, Grab ô tô Đà Nẵng – Hội An khoảng 300.000 – 450.000 đồng.</li>
<li><strong>Tự lái xe máy:</strong> chỉ nên với người quen đường, tránh nắng gắt giữa trưa mùa hè.</li>
</ol>
<p>Từ Sun Saphia, hướng đi thuận là theo trục ven biển về phía Hội An rồi rẽ lên phía Tây; bài <a href="/sun-saphia-residence-di-hoi-an-bao-xa/">Sun Saphia Residence đi Hội An bao xa</a> có quãng đường ước tính đoạn đầu.</p>
<!--hh-img:img/sun-saphia/sun-saphia-ban-do-ket-noi.jpg|Sun Saphia Residence đi Mỹ Sơn – bản đồ kết nối từ dự án về Hội An và các điểm lân cận (tài liệu chủ đầu tư)-->
<h2>Lịch trình Sun Saphia Residence đi Mỹ Sơn và Hội An trong một ngày</h2>
<table>
<thead><tr><th>Thời gian</th><th>Hoạt động</th></tr></thead>
<tbody>
<tr><td>Sáng sớm</td><td>Rời căn hộ, đi Mỹ Sơn khi trời còn mát</td></tr>
<tr><td>Buổi sáng</td><td>Tham quan các nhóm tháp, con đường đi bộ trong thung lũng</td></tr>
<tr><td>Trưa</td><td>Ăn trưa trên đường về Hội An</td></tr>
<tr><td>Chiều – tối</td><td>Phố cổ Hội An lên đèn, về căn hộ</td></tr>
</tbody>
</table>
<h2>Sun Saphia Residence đi Mỹ Sơn năm 2026: có gì mới?</h2>
<p>Theo <a href="https://thanhnien.vn/cap-cuu-vung-thap-cua-nhung-bao-vat-quoc-gia-o-thanh-dia-my-son-185260615215527437.htm">Thanh Niên</a> (16/6/2026), khu vực phía Tây nhóm tháp E-F dự kiến mở cửa đón khách trong năm 2026; nhóm E-F nắm 4 trong 6 bảo vật quốc gia của thánh địa, dự án bảo tồn ở đây do Chính phủ Ấn Độ tài trợ khoảng 115 tỷ đồng. Trước đó, VnExpress cho biết Ấn Độ đã tài trợ 50 tỷ đồng trong hơn 60 tỷ đồng trùng tu các nhóm tháp H, K, A. Vì vậy Mỹ Sơn là điểm đến có ý nghĩa với nhóm khách Ấn Độ (xem <a href="/khach-an-do-thue-sun-saphia-residence/">khách Ấn Độ thuê Sun Saphia Residence</a>).</p>
<h2>Sun Saphia Residence đi Mỹ Sơn: gợi ý cho chủ căn cho thuê</h2>
<p>Khách ở 4 – 5 đêm thường dành một ngày cho di sản. Chủ căn có thể ghi vào sổ tay hướng dẫn: giờ nên xuất phát, vài đơn vị tour có giấy phép, lời nhắc mang mũ, nước, giày đi bộ. Hiệp hay gợi ý chủ căn kể ngắn câu chuyện Chăm Pa trong sổ tay: tòa tháp khách đang ở lấy cảm hứng từ vũ nữ Apsara (xem bài <a href="/kien-truc-sun-saphia-residence/">kiến trúc Sun Saphia Residence</a>), bản gốc phù điêu Apsara Trà Kiệu ở Bảo tàng Điêu khắc Chăm, còn đền tháp gốc ở Mỹ Sơn – một mạch trải nghiệm ít căn hộ nào kể được.</p>
<ul>
<li>Sun Saphia Residence đi Mỹ Sơn mùa khô thuận hơn; mùa mưa cuối năm đường trơn, nên kiểm tra thời tiết.</li>
<li>Giá vé, giờ mở cửa thay đổi theo thời điểm – xem thông báo của ban quản lý di tích trước ngày đi.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Saphia Residence đi Mỹ Sơn không phải lợi thế khoảng cách – 70 km là chuyến đi trong ngày – nhưng là một phần của gói trải nghiệm miền Trung giúp khách ở lâu hơn. Với chủ căn cho thuê, mỗi ngày khách ở thêm đáng giá hơn một lần giảm giá phòng. Xem thêm {$review}.</p>
<p>Cần sổ tay hướng dẫn khách thuê có các tuyến di sản cho căn tại {$saphia}, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: thông tin Mỹ Sơn theo Tuổi Trẻ (14/8/2025), VnExpress (21/12/2022), Thanh Niên (16/6/2026); chi phí xe tham khảo cẩm nang DanangStay; kiến trúc, bản đồ kết nối theo tài liệu chủ đầu tư (10 – 11/2026).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence đi Mỹ Sơn: khoảng 70 km, 1 ngày',
			'desc'      => 'Sun Saphia Residence đi Mỹ Sơn: thánh địa Chăm Pa cách Đà Nẵng khoảng 70 km, di sản thế giới 1999. Cách đi, ghép Hội An, chi phí xe và điểm mới 2026.',
			'points'    => array(
				'Sun Saphia Residence đi Mỹ Sơn: thánh địa cách TP Đà Nẵng khoảng 70 km, đi về trong một ngày',
				'Di sản thế giới từ 4/12/1999, hơn 70 đền tháp thế kỷ 7 – 13, khoảng 1.500 khách mỗi ngày',
				'Sun Saphia Residence đi Mỹ Sơn năm 2026 có thêm điểm mới: dự kiến mở cửa khu phía Tây nhóm tháp E-F do Ấn Độ tài trợ bảo tồn',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence đi Mỹ Sơn bao xa?', 'Thánh địa Mỹ Sơn cách TP Đà Nẵng khoảng 70 km theo VnExpress; nên đi trọn một ngày, có thể ghép Hội An buổi chiều.' ),
				array( 'Đi Mỹ Sơn bằng gì tiện nhất?', 'Tour ghép đón tại sảnh hoặc xe riêng cả ngày (tham khảo khoảng 1 – 1,8 triệu đồng); tự lái chỉ nên với người quen đường.' ),
				array( 'Mỹ Sơn có gì mới năm 2026?', 'Theo Thanh Niên, khu phía Tây nhóm tháp E-F dự kiến mở cửa đón khách trong năm 2026.' ),
				array( 'Sun Saphia Residence đi Mỹ Sơn có liên quan gì kiến trúc tòa tháp?', 'Kiến trúc Sun Saphia lấy cảm hứng từ điêu khắc Chăm Pa và vũ nữ Apsara; Mỹ Sơn là thánh địa Chăm Pa gốc.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/thanh-dia-my-son-huyen-ao-trong-thung-lung-bao-quanh-rung-gia-20250814114339787.htm',
			'https://vnexpress.net/ba-nhom-thap-o-thanh-dia-my-son-sau-trung-tu-4550512.html',
			'https://thanhnien.vn/cap-cuu-vung-thap-cua-nhung-bao-vat-quoc-gia-o-thanh-dia-my-son-185260615215527437.htm',
		),
	);

	return $posts;
}
