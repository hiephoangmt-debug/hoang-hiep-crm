<?php
/**
 * Sun Saphia Residence đợt 5 – bài trụ cột "Đánh giá Sun Saphia Residence" (đăng 01/11/2026 15:00).
 * Tổng hợp thông tin dự án sau kick-off 23/10/2026: vị trí, view 4 hướng (mô hình 3D tầng 15), mặt bằng, giá dự kiến tầng 15,
 * giá phòng khách sạn quanh dự án, dòng tiền theo mùa có trừ khấu hao, pháp lý 50 năm, lịch sự kiện đến 28/11.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Không ghi mã căn, mã dự án; không tên đơn vị phân phối. Giá phòng: các trang đặt phòng 10/2026; thị trường: Avison Young, CoStar.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_5' );
function hh_posts_sun_saphia_dot_5( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Cần mặt bằng căn còn trống, bảng giá và chính sách ' . $saphia . ' khi chủ đầu tư công bố, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi kèm bảng tính dòng tiền theo đúng căn anh chị quan tâm.</p>';

	$posts[] = array(
		'slug'     => 'danh-gia-sun-saphia-residence-chi-tiet',
		'title'    => 'Đánh giá Sun Saphia Residence (11/2026): vị trí, view 4 hướng, giá dự kiến, dòng tiền cho thuê và pháp lý',
		'excerpt'  => 'Đánh giá chi tiết Sun Saphia Residence – căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng: cách bãi tắm Sơn Thủy 400 m, view 4 hướng từ tầng 15, studio dự kiến 2,13 – 2,85 tỷ, giá phòng khách sạn quanh dự án, dòng tiền theo mùa và pháp lý 50 năm.',
		'keyword'  => 'đánh giá Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Sun Saphia Đà Nẵng', 'view Sun Saphia Residence', 'giá Sun Saphia Residence', 'Sun Saphia cho thuê' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-01 15:00',
		'rev'      => 3, // 01/11: thống nhất mốc bàn giao dự kiến 11/2028.
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ biển Đà Nẵng', 'Đánh giá dự án' ),
		'image'    => 'plugin:img/tin-tuc/review-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p><strong>Đánh giá Sun Saphia Residence</strong> sau sự kiện kick-off ngày 23/10/2026: đây là dự án được chủ đầu tư giới thiệu là <strong>căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng</strong> – một tòa 30 tầng, 782 căn tại giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa. Bài này tổng hợp mọi thông tin đã có đến đầu tháng 11/2026 và chấm từng tiêu chí: vị trí, tầm nhìn, sản phẩm, giá, khả năng cho thuê, pháp lý – kèm những điểm người mua cần cân nhắc.</p>
<!--hh-featured-->

<h2>Tóm tắt nhanh Sun Saphia Residence</h2>
<table>
<tbody>
<tr><th>Vị trí</th><td>Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng</td></tr>
<tr><th>Đơn vị phát triển</th><td>Sun Property – thành viên Tập đoàn Sun Group</td></tr>
<tr><th>Quy mô</th><td>1 tòa 30 tầng, cao 114 m, 2 tầng hầm; khu đất 3.720,1 m²</td></tr>
<tr><th>Sản phẩm</th><td>782 căn: studio 30 – 31 m² (513 căn), 1PN+ 50 – 51 m² (108 căn), 2PN 60 – 70 m² (133 căn); trần 3,5 m</td></tr>
<tr><th>Pháp lý</th><td>Giấy chứng nhận đăng ký đầu tư cấp lần đầu 17/09/2026; thời hạn dự án 50 năm; công trình cấp I, niên hạn 100 năm</td></tr>
<tr><th>Giá dự kiến</th><td>Studio tầng 15: 2,13 – 2,85 tỷ (giá có vay, chưa VAT, chưa 2% bảo trì)</td></tr>
<tr><th>Sự kiện bán hàng</th><td>Dự kiến 28/11/2026</td></tr>
<tr><th>Bàn giao</th><td>Dự kiến tháng 11/2028, hoàn thiện cơ bản</td></tr>
</tbody>
</table>

<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg|Phối cảnh Sun Saphia Residence bên biển Sơn Thủy lúc hoàng hôn (ảnh chủ đầu tư)-->
<h2>1. Vị trí: sát biển, giữa trung tâm và Hội An</h2>
<p>Dự án nằm đúng khúc chuyển từ đại lộ Võ Nguyên Giáp sang đường Trường Sa – nơi bắt đầu dải resort ven biển Đà Nẵng – Hội An. Các khoảng cách chính theo tài liệu dự án và Google Maps:</p>
<table>
<thead><tr><th>Điểm đến</th><th>Khoảng cách / thời gian</th></tr></thead>
<tbody>
<tr><td>Bãi tắm Sơn Thủy</td><td>Khoảng 400 m, đi qua công viên ven biển</td></tr>
<tr><td>Ga LRT 09 (đường sắt đô thị, quy hoạch)</td><td>Khoảng 500 m</td></tr>
<tr><td>Phố du lịch An Thượng</td><td>Khoảng 6 phút đi xe theo trục Võ Nguyên Giáp</td></tr>
<tr><td>Sun Galaxy, Đà Nẵng Downtown</td><td>Khoảng 4 km</td></tr>
<tr><td>Sân bay Đà Nẵng · Hội An</td><td>Khoảng 10 – 15 phút · khoảng 30 phút (ô tô, ước tính)</td></tr>
</tbody>
</table>
<p><strong>Công viên biển 2,45 ha ngay phía trước</strong>: thành phố thu hồi khoảng 2,45 ha từ dự án resort Hòn Ngọc Á Châu bỏ hoang nhiều năm để làm công viên công cộng, vốn khoảng 47 tỷ đồng, thi công đến 2027 – có bãi đỗ xe, đường chạy bộ, sân chơi trẻ em, quảng trường và lối xuống biển công cộng. Cảnh quan phía trước tòa tháp vì vậy được giữ thoáng.</p>
<p><strong>Hạ tầng sắp tới</strong>: mở rộng trục Võ Nguyên Giáp – Trường Sa – Lạc Long Quân (vốn dự kiến 2.633 tỷ, nhóm ưu tiên "luồng xanh"); tuyến <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">đường sắt đô thị sân bay – Hội An</a> dự kiến khởi công giai đoạn 1 tháng 2/2027; phía Bắc có đề xuất <a href="/kinh-te-dem-bien-my-khe-da-nang-2026/">tổ hợp kinh tế đêm Mỹ Khê</a> tại 268 Võ Nguyên Giáp. Các dự án này đang ở giai đoạn quy hoạch, đề xuất – tiến độ có thể thay đổi.</p>
<p><em>Đánh giá vị trí:</em> mạnh nhất của dự án. Đi bộ ra biển, gần phố du lịch nhưng không nằm trong khu ồn ào, kết nối thuận cả về trung tâm lẫn Hội An.</p>

<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích căn (bản vẽ chủ đầu tư, tham khảo)-->
<h2>2. View Sun Saphia Residence: tầng 15 nhìn thấy gì theo từng hướng?</h2>
<p>Hoàng Hiệp dựng mô hình 3D từ mặt đứng tầng 15 để hình dung tầm nhìn (minh hoạ, không phải ảnh chụp thật; công trình xung quanh là ước lượng):</p>
<table>
<thead><tr><th>Hướng</th><th>Nhìn thấy</th><th>Phù hợp</th></tr></thead>
<tbody>
<tr><td><strong>Đông – mặt biển</strong></td><td>Biển Mỹ Khê – Sơn Thủy ngay trước mặt, dải resort ven biển; ngày trời trong thấy Cù Lao Chàm phía xa. Sáng đón mặt trời mọc, chiều mát.</td><td>Cho thuê khách du lịch, giá cao nhất</td></tr>
<tr><td><strong>Nam – Ngũ Hành Sơn</strong></td><td>Núi Ngũ Hành Sơn, bãi tắm Sơn Thủy, công viên biển phía trước, dải resort về hướng Hội An</td><td>Người thích cảnh biển và núi</td></tr>
<tr><td><strong>Tây – thành phố</strong></td><td>Trục Nguyễn Đức Thuận, các tòa tháp khu đô thị, sông Hàn phía xa; đẹp nhất buổi tối khi lên đèn. Có nắng chiều – nên tính rèm, kính cách nhiệt.</td><td>Ở lâu dài, giá vào thấp hơn</td></tr>
<tr><td><strong>Bắc – Sơn Trà</strong></td><td>Dọc trục Võ Nguyên Giáp về bán đảo Sơn Trà, tượng Quan Thế Âm chùa Linh Ứng, các cây cầu sông Hàn – hướng nhìn pháo hoa mùa lễ hội</td><td>Kết hợp view biển và thành phố</td></tr>
</tbody>
</table>
<p>Tòa tháp đặt mặt dài quay ra biển nên số căn nhìn biển trực diện nhiều hơn các khách sạn thấp tầng phía sau – lợi thế lớn khi cho thuê.</p>

<h2>3. Mặt bằng và loại căn</h2>
<p>Mỗi sàn điển hình (tầng 3A – 28) có 28 căn: <strong>19 studio, 4 căn 1PN+, 5 căn 2PN</strong>. Chi tiết: <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence</a>.</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích · kích thước</th><th>Bố trí</th><th>Hợp với</th></tr></thead>
<tbody>
<tr><td>Studio (513 căn)</td><td>30 – 31 m² · 3,8 × 9 m</td><td>Logia, giường + sofa không gian mở, bếp chữ L</td><td>Cho thuê theo đêm, người trẻ</td></tr>
<tr><td>1PN+ (108 căn)</td><td>50 – 51 m² · 6,2 × 9 m</td><td>1 phòng ngủ + phòng đa năng</td><td>Gia đình nhỏ, làm việc từ xa</td></tr>
<tr><td>2PN (133 căn)</td><td>60 – 70 m² · 7,25 × 9,9 m</td><td>2 phòng ngủ; có căn góc bo tròn</td><td>Gia đình, căn nghỉ dưỡng thứ hai</td></tr>
</tbody>
</table>
<p>Studio có bếp – điểm khác với phòng khách sạn thông thường: hợp khách gia đình, khách ở dài ngày, chuyên gia, và giúp mùa thấp điểm chuyển sang cho thuê theo tuần, theo tháng. Xem thêm <a href="/studio-sun-saphia-residence-30-m2-bo-tri-ai-nen-mua/">studio Sun Saphia 30 m²</a>.</p>
<p>Tiện ích trong tòa theo giới thiệu: bể bơi view biển, gym, yoga, pilates, khối đế thương mại (shop, café, nhà hàng) – <a href="/tien-ich-sun-saphia-residence-noi-khu-xung-quanh/">xem tiện ích</a>.</p>

<h2>4. Giá Sun Saphia Residence: studio tầng 15 từ 2,13 tỷ</h2>
<p>Chủ đầu tư chưa ban hành bảng giá chính thức. Giá dự kiến được đưa ra cuối tháng 10/2026 cho 3 vị trí studio 30 m² tầng 15:</p>
<table>
<thead><tr><th>Vị trí studio tầng 15</th><th>Giá dự kiến</th><th>Quy ra/m² thông thủy</th></tr></thead>
<tbody>
<tr><td>Dãy mặt biển – view biển trực diện</td><td>2,85 tỷ</td><td>Khoảng 95 triệu</td></tr>
<tr><td>Cánh bên – gần sảnh thang máy</td><td>2,37 tỷ</td><td>Khoảng 79 triệu</td></tr>
<tr><td>Dãy phía sau – nhìn về thành phố</td><td>2,13 tỷ</td><td>Khoảng 71 triệu</td></tr>
</tbody>
</table>
<p>Giá áp dụng khi mua có vay, chưa gồm VAT và 2% kinh phí bảo trì, chưa trừ chiết khấu; chính sách có hỗ trợ lãi suất tới 24 tháng. Cột giá/m² do Hoàng Hiệp tự tính. Chi tiết và so sánh: <a href="/gia-sun-saphia-residence-bao-nhieu/">giá Sun Saphia Residence</a>; chi phí cộng thêm: <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí ngoài giá bán</a>.</p>
<p><em>Đánh giá giá:</em> tổng tiền thấp nhất trong nhóm căn hộ sát biển Đà Nẵng nhờ diện tích nhỏ; tính trên m² thì căn mặt biển không rẻ. Chênh khoảng 0,7 tỷ giữa căn mặt biển và căn phía sau cho thấy view là yếu tố quyết định giá.</p>

<h2>5. Khả năng cho thuê: khách sạn quanh dự án thu bao nhiêu một đêm?</h2>
<p>Giá phòng tham khảo trên các trang đặt phòng tháng 10/2026 (thay đổi theo ngày, hạng phòng):</p>
<table>
<thead><tr><th>Nhóm</th><th>Ví dụ</th><th>Giá/đêm</th></tr></thead>
<tbody>
<tr><td>Resort 5 sao mặt biển</td><td>Hyatt Regency</td><td>Khoảng 3,7 – 3,9 triệu</td></tr>
<tr><td>4 sao mặt biển</td><td>Wyndham Soleil</td><td>Khoảng 2,28 – 3,13 triệu</td></tr>
<tr><td>4 sao mặt biển</td><td>Radisson</td><td>Khoảng 1,7 – 2,8 triệu</td></tr>
<tr><td>4 sao ven biển</td><td>Holiday Beach</td><td>Khoảng 1,25 – 2,64 triệu</td></tr>
<tr><td>Khách sạn 2 – 3 sao phố trong</td><td>Khu An Thượng</td><td>Khoảng 0,4 – 0,9 triệu</td></tr>
<tr><td><strong>Studio Sun Saphia (giả định)</strong></td><td>Theo tài liệu chủ đầu tư</td><td><strong>2,2 – 2,9 triệu</strong> ngoài mùa cao điểm</td></tr>
</tbody>
</table>
<p><strong>Thị trường lưu trú</strong>: khách sạn 4 – 5 sao Đà Nẵng lấp đầy khoảng 88 – 90% trong quý III/2026 (Avison Young); tính chung toàn thành phố 12 tháng đến 6/2026 khoảng 66%, giá phòng bình quân khoảng 116 USD (CoStar). Ở chiều ngược lại, gần 7.000 phòng mới sắp vào thị trường – cạnh tranh giá là có thật.</p>

<h2>6. Dòng tiền theo mùa và lợi suất sau khấu hao</h2>
<p>Hoàng Hiệp tính theo mùa, sát thực tế hơn một mức giá thuê cố định. Giả định: 180 đêm thấp điểm (khoảng 1,2 triệu/đêm), 180 đêm cao điểm; chủ nhà nhận 65% doanh thu (35% cho kênh bán phòng, vận hành, buồng phòng). Đây là ví dụ minh hoạ, không phải cam kết.</p>
<table>
<thead><tr><th>Kịch bản</th><th>Thấp điểm</th><th>Cao điểm</th><th>Chủ nhà nhận/năm</th><th>Lợi suất căn 2,13 tỷ</th><th>Lợi suất căn 2,85 tỷ</th></tr></thead>
<tbody>
<tr><td>Thận trọng</td><td>1,2 tr · lấp đầy 40%</td><td>2,5 tr · 70%</td><td>Khoảng 261 triệu</td><td>12,2%</td><td>9,2%</td></tr>
<tr><td>Cơ sở</td><td>1,2 tr · 50%</td><td>2,75 tr · 80%</td><td>Khoảng 328 triệu</td><td>15,4%</td><td>11,5%</td></tr>
</tbody>
</table>
<p><strong>Trừ khấu hao cho căn có thời hạn</strong>: căn 50 năm, bàn giao dự kiến tháng 11/2028 thì thời gian khai thác còn khoảng 47 năm. Chia đều giá mua cho 47 năm, mỗi năm "hao" khoảng 2,1% – lợi suất sau khấu hao ở kịch bản thận trọng còn khoảng 7 – 10%.</p>
<p><strong>Chưa trừ</strong>: VAT trên giá mua, thuế cho thuê (khi doanh thu trên 100 triệu/năm), phí quản lý, nội thất, lãi vay. Để đối chiếu, lợi suất cho thuê căn hộ Đà Nẵng nói chung khoảng 4,5%/năm (Batdongsan.com.vn, quý 3/2026) – bài toán cho thuê theo đêm chỉ đạt khi vận hành tốt. Xem kịch bản thận trọng hơn ở bài <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">đầu tư Sun Saphia cho thuê</a>.</p>
<p><strong>Kênh bán phòng ảnh hưởng thẳng tới lợi nhuận</strong>: hoa hồng Booking.com khoảng 15 – 18%, Agoda 12 – 20%, Airbnb 3% nếu chia phí với khách; tham gia mọi chương trình khuyến mãi có thể đẩy chi phí lên 25 – 30%. Khi chủ đầu tư công bố đơn vị vận hành, nên hỏi rõ: phí bao nhiêu, bán qua kênh nào, báo cáo doanh thu ra sao.</p>

<h2>7. Pháp lý Sun Saphia Residence</h2>
<ul>
<li><strong>Giấy chứng nhận đăng ký đầu tư</strong> cấp lần đầu ngày 17/09/2026; thời hạn dự án 50 năm (đến khoảng 2076).</li>
<li><strong>Công trình cấp I</strong> (30 tầng, khoảng 114 m), niên hạn sử dụng 100 năm theo công bố của chủ đầu tư.</li>
<li><strong>Quyền của người mua</strong>: được cấp giấy chứng nhận cho từng căn theo quy định, được bán lại, tặng cho, để thừa kế, thế chấp vay trong thời hạn còn lại.</li>
<li><strong>Khi hết thời hạn</strong>: người sử dụng có nhu cầu được Nhà nước xem xét gia hạn; trường hợp không được gia hạn thì xử lý tài sản theo khoản 3, 4 Điều 172 Luật Đất đai 2024. Không ai được hứa chắc việc gia hạn.</li>
<li><strong>Cần có trước khi xuống tiền cọc</strong>: văn bản đủ điều kiện bán nhà ở, công trình hình thành trong tương lai, giấy phép xây dựng, bảo lãnh ngân hàng, hợp đồng mẫu.</li>
</ul>
<p>Đọc thêm: <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia – sở hữu bao lâu</a> và <a href="/giu-cho-booking-can-ho-moi-da-nang-can-biet/">giữ chỗ khác đặt cọc thế nào</a>.</p>

<h2>8. Lịch sự kiện đến ngày mở bán</h2>
<table>
<thead><tr><th>Thời gian</th><th>Sự kiện</th></tr></thead>
<tbody>
<tr><td>23/10/2026</td><td>Kick-off dự án "Đón ánh dương, giao hòa nhịp sống" tại Đà Nẵng</td></tr>
<tr><td>01/11 và 15/11/2026</td><td>Sự kiện giới thiệu, nhận đặt chỗ tại Đà Nẵng</td></tr>
<tr><td>Từ 09/11/2026</td><td>Roadshow giới thiệu dự án tại Đà Nẵng</td></tr>
<tr><td>28/11/2026</td><td>Sự kiện bán hàng của chủ đầu tư (dự kiến)</td></tr>
<tr><td>11/2028</td><td>Bàn giao dự kiến</td></tr>
</tbody>
</table>
<p>Lịch có thể thay đổi theo thông báo của chủ đầu tư.</p>

<h2>Ưu điểm và điểm cần cân nhắc</h2>
<table>
<thead><tr><th>Ưu điểm</th><th>Cần cân nhắc</th></tr></thead>
<tbody>
<tr><td>Sát biển, 400 m ra bãi tắm; công viên 2,45 ha phía trước</td><td>Thời hạn 50 năm – ảnh hưởng giá bán lại về sau</td></tr>
<tr><td>Thương hiệu Sun Group, tòa 30 tầng mặt dài hướng biển</td><td>513 studio cùng tòa – cạnh tranh cho thuê mùa thấp điểm</td></tr>
<tr><td>Tổng tiền vào từ khoảng 2,1 tỷ (giá dự kiến)</td><td>Giá/m² căn mặt biển không thấp; chưa có bảng giá chính thức</td></tr>
<tr><td>Studio có bếp, hợp ở dài ngày và cho thuê theo tháng</td><td>Hơn 2 năm chờ bàn giao, chưa có dòng tiền</td></tr>
<tr><td>Hạ tầng quanh dự án đang được đầu tư</td><td>Đường sắt, mở rộng đường còn ở giai đoạn quy hoạch, đề xuất</td></tr>
</tbody>
</table>
<p><strong>Kết luận của Hoàng Hiệp</strong>: Sun Saphia Residence hợp người muốn có một căn biển thương hiệu lớn với vốn khoảng 2 – 3 tỷ, để nghỉ dưỡng kết hợp cho thuê, chấp nhận thời hạn 50 năm. Người cần tài sản để lại lâu dài nên cân nhắc thêm căn hộ sở hữu lâu dài. Phân tích ưu nhược điểm đầy đủ: <a href="/co-nen-mua-sun-saphia-residence-uu-nhuoc-diem/">có nên mua Sun Saphia Residence</a>; tránh nhầm tên: <a href="/sun-saphia-residence-va-khu-do-thi-saphia-khac-nhau/">Sun Saphia Residence và khu đô thị Saphia</a>.</p>
<p class="src">Nguồn: thông tin chủ đầu tư công bố tại kick-off 23/10/2026 và cuối tháng 10/2026; giá phòng tham khảo trên các trang đặt phòng (10/2026); Avison Young, CoStar (thị trường khách sạn); Batdongsan.com.vn (lợi suất cho thuê, quý 3/2026); báo chí về công viên biển, hạ tầng. Mô hình view 3D, ví dụ dòng tiền và cột giá/m² do Hoàng Hiệp thực hiện, chỉ để tham khảo.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đánh giá Sun Saphia Residence: vị trí, view, giá, cho thuê',
			'desc'      => 'Đánh giá Sun Saphia Residence 11/2026: cách biển 400 m, view 4 hướng tầng 15, studio dự kiến 2,13 – 2,85 tỷ, giá phòng khu vực, dòng tiền, pháp lý.',
			'points'    => array(
				'Giao lộ Võ Nguyên Giáp – Trường Sa, khoảng 400 m ra bãi tắm Sơn Thủy, công viên biển 2,45 ha phía trước',
				'Studio tầng 15 giá dự kiến 2,13 – 2,85 tỷ (có vay, chưa VAT, chưa 2% bảo trì)',
				'Khách sạn 4 sao mặt biển quanh dự án khoảng 1,7 – 3,1 triệu/đêm; giả định studio 2,2 – 2,9 triệu',
				'Thời hạn 50 năm – trừ khấu hao khoảng 2,1%/năm khi tính lợi suất',
				'Sự kiện bán hàng dự kiến 28/11/2026, bàn giao dự kiến 11/2028',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có đáng mua không?', 'Hợp người muốn căn biển thương hiệu Sun Group với vốn khoảng 2 – 3 tỷ để nghỉ dưỡng kết hợp cho thuê và chấp nhận thời hạn 50 năm. Cần cân nhắc cạnh tranh cho thuê (513 studio cùng tòa) và hơn 2 năm chờ bàn giao.' ),
				array( 'Sun Saphia Residence cách biển bao xa?', 'Khoảng 400 m tới bãi tắm Sơn Thủy, đi qua công viên ven biển khoảng 2,45 ha ngay trước dự án.' ),
				array( 'Căn hộ Sun Saphia view hướng nào đẹp nhất?', 'Hướng Đông nhìn thẳng biển Mỹ Khê – Sơn Thủy, giá cao nhất; hướng Nam thấy Ngũ Hành Sơn; hướng Bắc thấy Sơn Trà và các cầu sông Hàn; hướng Tây nhìn thành phố, giá vào thấp hơn.' ),
				array( 'Giá studio Sun Saphia Residence bao nhiêu?', 'Giá dự kiến studio 30 m² tầng 15 từ 2,13 tỷ (dãy phía sau) đến 2,85 tỷ (dãy mặt biển), áp dụng khi mua có vay, chưa VAT và 2% bảo trì; bảng giá chính thức công bố khi mở bán.' ),
				array( 'Cho thuê studio Sun Saphia được bao nhiêu?', 'Ví dụ theo mùa (180 đêm thấp điểm, 180 đêm cao điểm, chủ nhà nhận 65%): khoảng 261 – 328 triệu/năm trước thuế, phí và khấu hao. Đây là giả định minh hoạ, không phải cam kết.' ),
				array( 'Khi nào Sun Saphia Residence mở bán?', 'Sự kiện bán hàng của chủ đầu tư dự kiến ngày 28/11/2026; bàn giao dự kiến tháng 11/2028.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt.com/du-an/sun-saphia-residence/',
			'https://wiki.batdongsan.com.vn/tin-tuc/thi-truong-bat-dong-san-quy-32026-gia-ha-nhiet-chung-cu-tiep-tuc-dan-dat-nhu-cau-857618',
		),
	);

	return $posts;
}
