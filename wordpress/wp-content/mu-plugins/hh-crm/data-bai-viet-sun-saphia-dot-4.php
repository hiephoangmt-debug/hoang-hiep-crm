<?php
/**
 * Loạt bài Sun Saphia Residence đợt 4 (06/11 – 12/11/2026, 08:00 mỗi ngày): tiến độ thanh toán theo luật, chuẩn bị sự kiện
 * bán hàng 28/11, hỗ trợ lãi suất 24 tháng, gửi tiết kiệm hay mua studio cho thuê, căn hộ ven biển và hơi muối – mùa bão,
 * chuyển nhượng hợp đồng trước bàn giao, dải biển Trường Sa – Ngũ Hành Sơn.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Số liệu: Luật Kinh doanh BĐS 2023 (báo chí, trang pháp luật trích), lãi suất tiết kiệm / lãi vay theo bảng Thống kê đầu tư
 * (CafeBiz, 24hMoney, DKRA, VARS), giá dự kiến và chính sách dự án theo thông tin chủ đầu tư 28/10/2026. Ví dụ tính là minh hoạ.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_4' );
function hh_posts_sun_saphia_dot_4( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Cần bảng giá, mặt bằng tầng và chính sách ' . $saphia . ' khi chủ đầu tư công bố, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Hoàng Hiệp gửi kèm bảng tính chi phí, dòng tiền theo đúng căn anh chị quan tâm.</p>';

	/* ---------------- 06/11 – Tiến độ thanh toán theo luật ---------------- */
	$posts[] = array(
		'slug'     => 'thanh-toan-can-ho-hinh-thanh-tuong-lai-sun-saphia-residence',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Mua Sun Saphia Residence trả tiền thế nào? Mức cọc 5%, 30%, 70%, 95% theo Luật Kinh doanh BĐS 2023',
		'excerpt'  => 'Căn hộ hình thành trong tương lai như Sun Saphia Residence: cọc tối đa 5% khi dự án đủ điều kiện bán, lần đầu không quá 30%, trước bàn giao không quá 70%, chưa có sổ không quá 95%. Người mua cần biết gì.',
		'keyword'  => 'thanh toán căn hộ hình thành trong tương lai',
		'keywords_extra' => array( 'Sun Saphia Residence', 'tiến độ thanh toán Sun Saphia', 'đặt cọc 5% nhà ở hình thành trong tương lai', 'Luật Kinh doanh bất động sản 2023' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-06 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/tin-tuc/thanh-toan-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>{$saphia} đang ở giai đoạn giữ chỗ, sự kiện bán hàng của chủ đầu tư dự kiến 28/11/2026, bàn giao dự kiến 11/2028. Đây là <strong>căn hộ hình thành trong tương lai</strong> – mua khi tòa nhà chưa xây xong – nên tiền trả cho chủ đầu tư bị Luật Kinh doanh bất động sản 2023 giới hạn theo từng mốc. Bài tóm tắt các mốc đó để người mua đối chiếu với phương án thanh toán khi có hợp đồng.</p>
<!--hh-featured-->
<h2>4 mốc tiền theo Luật Kinh doanh bất động sản 2023</h2>
<table>
<thead><tr><th>Mốc</th><th>Giới hạn</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Đặt cọc</td><td>Không quá 5% giá bán</td><td>Chỉ được thu khi dự án đã đủ điều kiện đưa vào kinh doanh; hợp đồng cọc ghi rõ giá bán, diện tích</td></tr>
<tr><td>Thanh toán lần đầu</td><td>Không quá 30% giá trị hợp đồng</td><td>Đã gồm tiền cọc</td></tr>
<tr><td>Trước khi bàn giao</td><td>Tổng không quá 70%</td><td>Các lần sau phải theo tiến độ xây dựng</td></tr>
<tr><td>Chưa có giấy chứng nhận</td><td>Tổng không quá 95%</td><td>5% còn lại trả khi được cấp giấy chứng nhận</td></tr>
</tbody>
</table>
<p>Luật số 29/2023/QH15 có hiệu lực từ 01/8/2024. Nội dung trên theo các trang pháp luật và báo chí trích dẫn luật (nguồn cuối bài); khi ký hợp đồng, nên đọc lại điều khoản thanh toán cùng luật sư hoặc người tư vấn.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg|Phối cảnh Sun Saphia Residence bên biển Sơn Thủy lúc hoàng hôn (ảnh chủ đầu tư)-->
<h2>Giữ chỗ khác đặt cọc</h2>
<p>Khoản giữ chỗ (booking) hiện nay chỉ là thỏa thuận ưu tiên chọn căn, chưa phải tiền cọc theo luật. Trước khi chuyển tiền, nên yêu cầu ghi rõ: số tiền, thời hạn, trường hợp được hoàn lại và hoàn trong bao lâu. Chi tiết ở bài <a href="/giu-cho-booking-can-ho-moi-da-nang-can-biet/">giữ chỗ căn hộ mới cần biết</a>.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích căn (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Bảo lãnh ngân hàng – lớp bảo vệ người mua</h2>
<p>Với nhà ở hình thành trong tương lai, chủ đầu tư phải có ngân hàng bảo lãnh nghĩa vụ tài chính: nếu không bàn giao đúng cam kết, người mua có cơ sở yêu cầu ngân hàng hoàn tiền đã trả. Khi ký hợp đồng mua bán, nên xin <strong>thư bảo lãnh cho đúng căn của mình</strong> và giữ bản gốc. Ngân hàng hỗ trợ cho vay dự án theo tài liệu chủ đầu tư: Vietcombank, BIDV, NCB.</p>
<h2>Áp vào Sun Saphia: tự tính trước</h2>
<p>Ví dụ minh hoạ với studio tầng 15 dãy mặt biển giá dự kiến 2,85 tỷ (giá có vay, chưa VAT, chưa kinh phí bảo trì – <a href="/gia-sun-saphia-residence-bao-nhieu/">xem giá dự kiến</a>):</p>
<ul>
<li>Tiền cọc tối đa 5%: khoảng 142,5 triệu.</li>
<li>Lần đầu tối đa 30%: khoảng 855 triệu (đã gồm cọc).</li>
<li>Trước bàn giao tối đa 70%: khoảng 1,995 tỷ.</li>
<li>Giữ lại tối thiểu 5% đến khi có sổ: khoảng 142,5 triệu.</li>
</ul>
<p>Phương án thanh toán thật của chủ đầu tư (số đợt, tỷ lệ, chiết khấu trả nhanh) chưa công bố. Khi có, đối chiếu với 4 mốc trên; phương án vay sẽ thay phần lớn các đợt giữa bằng tiền ngân hàng giải ngân. Tính thêm chi phí ngoài giá ở bài <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí mua Sun Saphia ngoài giá bán</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua Sun Saphia Residence trả tiền theo mốc nào?',
			'desc'      => 'Căn hộ hình thành trong tương lai như Sun Saphia Residence: cọc tối đa 5%, lần đầu ≤30%, trước bàn giao ≤70%, chưa có sổ ≤95%. Ví dụ studio 2,85 tỷ.',
			'points'    => array(
				'Cọc không quá 5% và chỉ khi dự án đủ điều kiện kinh doanh',
				'Lần đầu không quá 30%, trước bàn giao không quá 70%, chưa có sổ không quá 95%',
				'Xin thư bảo lãnh ngân hàng cho đúng căn khi ký hợp đồng',
			),
			'faq'       => array(
				array( 'Mua căn hộ hình thành trong tương lai được cọc bao nhiêu?', 'Theo Luật Kinh doanh bất động sản 2023, chủ đầu tư chỉ được thu tiền đặt cọc không quá 5% giá bán khi dự án đã đủ điều kiện đưa vào kinh doanh.' ),
				array( 'Trước khi nhận nhà phải trả bao nhiêu phần trăm?', 'Thanh toán lần đầu không quá 30% giá trị hợp đồng (gồm cọc); các lần sau theo tiến độ xây dựng, tổng không quá 70% khi chưa bàn giao; chưa có giấy chứng nhận thì không quá 95%.' ),
				array( 'Tiền giữ chỗ Sun Saphia có phải tiền cọc không?', 'Không. Giữ chỗ là thỏa thuận ưu tiên chọn căn; nên yêu cầu ghi rõ điều kiện hoàn tiền.' ),
			),
		),
		'sources'  => array(
			'https://luatvietnam.vn/tin-van-ban-moi/tu-2025-khong-dat-coc-mua-nha-hinh-thanh-trong-tuong-lai-qua-5-gia-ban-186-96489-article.html',
			'https://baophapluat.vn/khong-duoc-thu-qua-5-tien-dat-coc-nha-o-hinh-thanh-trong-tuong-lai-post496935.html',
			'https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Kinh-doanh-bat-dong-san-29-2023-QH15-530116.aspx',
		),
	);

	/* ---------------- 07/11 – Chuẩn bị sự kiện bán hàng 28/11 ---------------- */
	$posts[] = array(
		'slug'     => 'chuan-bi-su-kien-ban-hang-sun-saphia-residence-28-11',
		'title'    => 'Sự kiện bán hàng Sun Saphia Residence 28/11/2026: 7 việc nên chuẩn bị trước để chọn được căn ưng ý',
		'excerpt'  => 'Sự kiện bán hàng Sun Saphia Residence dự kiến 28/11/2026. Chuẩn bị gì trước: chọn sẵn 3 căn, tính tổng tiền gồm VAT và 2% bảo trì, hồ sơ vay, câu hỏi về giá, chính sách và giấy tờ dự án.',
		'keyword'  => 'sự kiện bán hàng Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'mở bán Sun Saphia', 'Sun Saphia 28/11', 'chọn căn Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-07 08:00',
		'rev'      => 3, // 01/11: ngân hàng hỗ trợ Vietcombank, BIDV, NCB.
		'image_replace' => true, // Ảnh cũ ghi VietinBank.
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Kinh nghiệm mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/su-kien-ban-hang-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Theo thông tin chủ đầu tư đưa ra ngày 28/10/2026, {$saphia} có các buổi giới thiệu dự án tại Đà Nẵng dự kiến ngày 01/11 và 15/11, và <strong>sự kiện bán hàng dự kiến ngày 28/11/2026</strong>. Ở các đợt mở bán căn hộ ven biển, căn đẹp thường được chọn trong những giờ đầu – người chuẩn bị trước có lợi thế. Dưới đây là 7 việc nên làm trước ngày đó.</p>
<!--hh-featured-->
<h2>1. Chọn sẵn 3 căn theo thứ tự ưu tiên</h2>
<p>Mỗi sàn tầng 3A – 28 có 28 căn: 19 studio, 4 căn 1PN+, 5 căn 2PN (<a href="/mat-bang-can-ho-sun-saphia-residence/">xem mặt bằng</a>). Chọn 1 căn chính và 2 căn dự phòng khác tầng hoặc khác dãy để không bị động khi căn đầu tiên đã có người chọn.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-toa-thap-30-tang.jpg|Phối cảnh tòa tháp 30 tầng Sun Saphia Residence (ảnh chủ đầu tư)-->
<h2>2. Tính tổng tiền, không chỉ giá căn</h2>
<p>Giá dự kiến studio tầng 15 từ 2,13 đến 2,85 tỷ là giá có vay, <strong>chưa gồm VAT và 2% kinh phí bảo trì</strong> (<a href="/gia-sun-saphia-residence-bao-nhieu/">chi tiết giá</a>). Cộng thêm lệ phí trước bạ, nội thất – xem <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí ngoài giá bán</a>.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tong-the-cong-vien-bai-tam.jpg|Mặt bằng tổng thể Sun Saphia Residence cạnh công viên bãi tắm Sơn Thủy (bản vẽ chủ đầu tư, tham khảo)-->
<h2>3. Chốt phương án tiền: tự có hay vay</h2>
<p>Nếu vay, nên hỏi trước ngân hàng hỗ trợ dự án (Vietcombank, BIDV, NCB theo tài liệu chủ đầu tư) về hạn mức và hồ sơ thu nhập. Chính sách dự án có hỗ trợ lãi suất tới 24 tháng – tính thử ở bài <a href="/vay-mua-sun-saphia-residence-tra-gop-hang-thang/">vay mua Sun Saphia trả góp</a>.</p>
<h2>4. Mang đủ giấy tờ cá nhân</h2>
<p>Căn cước công dân của người đứng tên (và vợ/chồng nếu tài sản chung), thông tin tài khoản để chuyển tiền. Ở xa không đến được, hỏi trước cách ký và chuyển tiền từ xa – xem <a href="/mua-can-ho-da-nang-tu-ha-noi-tp-hcm-kinh-nghiem/">mua căn hộ Đà Nẵng từ xa</a>.</p>
<h2>5. Chuẩn bị câu hỏi về giá và chính sách</h2>
<ul>
<li>Giá chính thức từng căn đã gồm VAT, kinh phí bảo trì chưa? Diện tích tính giá là thông thủy hay tim tường?</li>
<li>Chiết khấu cho khách giữ chỗ sớm, thanh toán nhanh là bao nhiêu, áp dụng tới khi nào?</li>
<li>Hỗ trợ lãi suất 24 tháng tính trên khoản vay nào, hết hỗ trợ thì lãi suất thả nổi ra sao?</li>
</ul>
<h2>6. Hỏi giấy tờ dự án</h2>
<p>Văn bản đủ điều kiện bán nhà ở hình thành trong tương lai, bảo lãnh ngân hàng, hợp đồng mẫu. Mức cọc, các mốc thanh toán theo luật: xem bài <a href="/thanh-toan-can-ho-hinh-thanh-tuong-lai-sun-saphia-residence/">mức cọc 5%, 30%, 70%, 95%</a>. Thời hạn sở hữu: <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia</a>.</p>
<h2>7. Đặt mức giá tối đa cho mình</h2>
<p>Không khí sự kiện dễ khiến người mua chọn căn vượt ngân sách. Viết ra giá tối đa chấp nhận được cho từng căn ưu tiên và giữ đúng mức đó.</p>
<p>Lịch sự kiện có thể thay đổi theo chủ đầu tư; Hoàng Hiệp sẽ cập nhật khi có thông báo chính thức.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sự kiện bán hàng Sun Saphia Residence 28/11: chuẩn bị gì',
			'desc'      => 'Sự kiện bán hàng Sun Saphia Residence dự kiến 28/11/2026: chọn sẵn 3 căn, tính tổng tiền gồm VAT và 2% bảo trì, hồ sơ vay, câu hỏi về giá và giấy tờ dự án.',
			'points'    => array(
				'Sự kiện bán hàng dự kiến 28/11/2026; giới thiệu dự án dự kiến 01/11 và 15/11',
				'Chọn 1 căn chính và 2 căn dự phòng, tính tổng tiền gồm VAT và 2% bảo trì',
				'Hỏi rõ chiết khấu, hỗ trợ lãi suất 24 tháng và văn bản đủ điều kiện bán',
			),
			'faq'       => array(
				array( 'Khi nào Sun Saphia Residence mở bán?', 'Theo thông tin chủ đầu tư ngày 28/10/2026, sự kiện bán hàng dự kiến ngày 28/11/2026; lịch có thể thay đổi.' ),
				array( 'Đi sự kiện bán hàng Sun Saphia cần mang gì?', 'Căn cước công dân của người đứng tên (và vợ/chồng nếu tài sản chung), phương án tài chính, danh sách căn ưu tiên và các câu hỏi về giá, chính sách.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 08/11 – Hỗ trợ lãi suất 24 tháng ---------------- */
	$posts[] = array(
		'slug'     => 'ho-tro-lai-suat-24-thang-sun-saphia-residence-tinh-thu',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Hỗ trợ lãi suất 24 tháng khi mua Sun Saphia Residence: tính thử tiết kiệm bao nhiêu và trả bao nhiêu từ tháng 25',
		'excerpt'  => 'Sun Saphia Residence có chính sách hỗ trợ lãi suất tới 24 tháng. Ví dụ vay 1,5 tỷ: lãi 24 tháng ở mức 10,9%/năm khoảng 327 triệu; từ tháng 25 nếu lãi thả nổi 13 – 15%, trả góp 20 năm khoảng 17,6 – 19,8 triệu/tháng.',
		'keyword'  => 'hỗ trợ lãi suất Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'vay mua Sun Saphia', 'hỗ trợ lãi suất 24 tháng', 'lãi suất vay mua nhà 2026' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-08 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Vay mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/ho-tro-lai-suat-sun-saphia-residence.jpg',
		'content'  => <<<HTML
<p>Chính sách {$saphia} được chủ đầu tư đưa ra ngày 28/10/2026 có <strong>hỗ trợ lãi suất lên tới 24 tháng</strong>; bàn giao dự kiến 11/2028. Chi tiết (hỗ trợ toàn bộ hay một phần lãi, trên tỷ lệ vay bao nhiêu) chưa công bố. Bài tính thử hai con số người vay cần biết: khoản lãi được đỡ trong 24 tháng và số tiền phải trả mỗi tháng khi hết hỗ trợ.</p>
<!--hh-featured-->
<h2>Giả định để tính</h2>
<ul>
<li>Khoản vay: 1,5 tỷ (khoảng một nửa giá studio).</li>
<li>Lãi suất trong 24 tháng nếu không được hỗ trợ: 10,9%/năm – bình quân lãi cố định 12 – 24 tháng của 11 ngân hàng (DKRA, 9/2026).</li>
<li>Sau ưu đãi, lãi thả nổi khoảng 13 – 15%/năm (VARS, 9/2026).</li>
<li>Giải ngân hết từ đầu, trả góp đều 20 năm từ tháng 25. Thực tế ngân hàng giải ngân theo tiến độ nên lãi giai đoạn đầu thường thấp hơn.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg|Phối cảnh Sun Saphia Residence bên biển Sơn Thủy lúc hoàng hôn (ảnh chủ đầu tư)-->
<h2>Kết quả tính thử</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Kết quả (minh hoạ)</th></tr></thead>
<tbody>
<tr><td>Lãi 24 tháng trên 1,5 tỷ ở 10,9%/năm</td><td>Khoảng 327 triệu – mức hỗ trợ tối đa nếu chủ đầu tư trả toàn bộ lãi</td></tr>
<tr><td>Trả góp tháng 25 nếu lãi 10,9%/năm</td><td>Khoảng 15,4 triệu/tháng</td></tr>
<tr><td>Trả góp tháng 25 nếu lãi 13%/năm</td><td>Khoảng 17,6 triệu/tháng</td></tr>
<tr><td>Trả góp tháng 25 nếu lãi 15%/năm</td><td>Khoảng 19,8 triệu/tháng</td></tr>
</tbody>
</table>
<p>Trả góp = gốc + lãi chia đều 240 tháng. Lãi suất ngân hàng thay đổi theo thời điểm; xem số mới nhất ở trang <a href="/thong-ke-dau-tu/">Thống kê đầu tư</a>.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích căn (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Đọc kết quả thế nào?</h2>
<ul>
<li><strong>24 tháng gần trùng thời gian xây dựng</strong>: nếu hỗ trợ toàn bộ lãi, người mua gần như không trả lãi trước khi nhận nhà – áp lực dòng tiền giai đoạn chưa cho thuê được giảm rõ.</li>
<li><strong>Tháng 25 là mốc cần chuẩn bị</strong>: khoản trả mỗi tháng có thể 15 – 20 triệu. Nếu cho thuê studio, tiền thuê ròng nhiều khả năng chưa đủ bù toàn bộ – xem <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">3 kịch bản dòng tiền</a>.</li>
<li><strong>Hỗ trợ lãi thường đi kèm giá</strong>: giá dự kiến 2,13 – 2,85 tỷ là giá áp dụng khi mua có vay; nên hỏi giá khi không vay (thường có chiết khấu) để so cho đúng.</li>
</ul>
<h2>Câu hỏi nên hỏi về chính sách</h2>
<ol>
<li>Hỗ trợ 100% lãi hay hỗ trợ một phần (ví dụ giữ lãi suất ở mức cố định)?</li>
<li>Tỷ lệ vay tối đa được hỗ trợ, ân hạn nợ gốc bao lâu?</li>
<li>Trả nợ trước hạn trong và sau 24 tháng có bị phạt không?</li>
<li>Hết hỗ trợ, lãi thả nổi tính bằng lãi cơ sở cộng biên độ bao nhiêu?</li>
</ol>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hỗ trợ lãi suất 24 tháng Sun Saphia Residence: tính thử',
			'desc'      => 'Hỗ trợ lãi suất 24 tháng Sun Saphia Residence: vay 1,5 tỷ, lãi 24 tháng khoảng 327 triệu; từ tháng 25 trả góp khoảng 15,4 – 19,8 triệu/tháng.',
			'points'    => array(
				'Vay 1,5 tỷ ở 10,9%/năm: lãi 24 tháng khoảng 327 triệu',
				'Từ tháng 25, trả góp 20 năm khoảng 15,4 – 19,8 triệu/tháng tùy lãi 10,9 – 15%',
				'Hỏi rõ hỗ trợ toàn bộ hay một phần lãi, tỷ lệ vay và phí trả trước hạn',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence hỗ trợ lãi suất bao lâu?', 'Theo thông tin chủ đầu tư ngày 28/10/2026, hỗ trợ lãi suất lên tới 24 tháng; chi tiết mức hỗ trợ chưa công bố.' ),
				array( 'Vay 1,5 tỷ mua Sun Saphia mỗi tháng trả bao nhiêu?', 'Ví dụ minh hoạ: trả góp đều 20 năm, khoảng 15,4 triệu/tháng nếu lãi 10,9%/năm, 17,6 triệu nếu 13% và 19,8 triệu nếu 15%.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/',
		),
	);

	/* ---------------- 09/11 – Gửi tiết kiệm hay mua studio cho thuê ---------------- */
	$posts[] = array(
		'slug'     => 'gui-tiet-kiem-hay-mua-studio-sun-saphia-residence-cho-thue',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Gửi tiết kiệm hay mua studio Sun Saphia Residence cho thuê? So sánh với lãi suất 5,4 – 6,7%/năm',
		'excerpt'  => 'Cùng khoảng 3,19 tỷ (studio 2,85 tỷ cộng VAT và 2% bảo trì): gửi tiết kiệm 12 tháng 5,4 – 6,7%/năm cho khoảng 172 – 214 triệu; cho thuê lợi suất ròng 3,5 – 5,5% cho khoảng 112 – 176 triệu. Phần chênh nằm ở tăng giá và rủi ro.',
		'keyword'  => 'gửi tiết kiệm hay mua căn hộ cho thuê',
		'keywords_extra' => array( 'Sun Saphia Residence', 'đầu tư studio Đà Nẵng', 'lãi suất tiết kiệm 2026', 'lợi suất cho thuê căn hộ Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-09 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Đầu tư cho thuê' ),
		'image'    => 'plugin:img/tin-tuc/tiet-kiem-hay-studio-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Câu hỏi hay gặp khi cân nhắc {$saphia}: để tiền trong ngân hàng hay mua một căn studio cho thuê? Bài đặt hai lựa chọn cạnh nhau với cùng số tiền, dùng lãi suất tiết kiệm thực tế cuối tháng 10/2026 và lợi suất cho thuê căn hộ Đà Nẵng theo báo cáo thị trường. Các con số là minh hoạ.</p>
<!--hh-featured-->
<h2>Cùng số tiền: khoảng 3,19 tỷ</h2>
<p>Studio tầng 15 dãy mặt biển giá dự kiến 2,85 tỷ (chưa VAT, chưa kinh phí bảo trì), cộng VAT tối đa 10% và 2% bảo trì là khoảng <strong>3,19 tỷ</strong>, chưa gồm nội thất (<a href="/gia-sun-saphia-residence-bao-nhieu/">giá dự kiến</a>, <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí ngoài giá</a>).</p>
<table>
<thead><tr><th>Lựa chọn</th><th>Tỷ lệ/năm</th><th>Tiền thu mỗi năm</th></tr></thead>
<tbody>
<tr><td>Tiết kiệm 12 tháng – Vietcombank, Agribank (tại quầy)</td><td>5,4%</td><td>Khoảng 172 triệu</td></tr>
<tr><td>Tiết kiệm 12 tháng – mức cao tại quầy (Saigonbank, PGBank)</td><td>6,7%</td><td>Khoảng 214 triệu</td></tr>
<tr><td>Studio cho thuê – thận trọng</td><td>3,5%</td><td>Khoảng 112 triệu</td></tr>
<tr><td>Studio cho thuê – mặt bằng Đà Nẵng</td><td>4,5%</td><td>Khoảng 144 triệu</td></tr>
<tr><td>Studio cho thuê – vận hành tốt</td><td>5,5%</td><td>Khoảng 176 triệu</td></tr>
</tbody>
</table>
<p>Lãi suất tiết kiệm: CafeBiz 20/10/2026, 24hMoney 29/10/2026 (tổng hợp ở trang <a href="/thong-ke-dau-tu/">Thống kê đầu tư</a>). Lợi suất 4,5%/năm: Batdongsan.com.vn, quý 3/2026. Lợi suất cho thuê tính trên tổng tiền, đã trừ chi phí vận hành.</p>
<!--hh-img:img/sun-saphia/sun-saphia-layout-can-studio.jpg|Layout căn Studio Sun Saphia Residence (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Chênh lệch nằm ở đâu?</h2>
<ul>
<li><strong>Thu nhập đều</strong>: tiết kiệm nhỉnh hơn hoặc tương đương, gần như không rủi ro, rút được khi cần.</li>
<li><strong>Tăng giá tài sản</strong>: căn hộ có thể tăng giá – giá rao bán chung cư Đà Nẵng từ 46 triệu/m² quý 1/2024 lên 67 triệu/m² quý 3/2026 (Batdongsan.com.vn). Quá khứ không bảo đảm tương lai; căn có thời hạn 50 năm cũng cần tính khi bán lại.</li>
<li><strong>Thời gian chờ</strong>: studio Sun Saphia bàn giao dự kiến 11/2028 – hơn 2 năm chưa có tiền thuê, trong khi tiền trả theo tiến độ.</li>
<li><strong>Công sức và rủi ro</strong>: tìm khách, mùa thấp điểm, 513 studio cùng tòa cạnh tranh – xem <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">rủi ro khi đầu tư cho thuê</a>.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg|Phối cảnh Sun Saphia Residence bên biển Sơn Thủy lúc hoàng hôn (ảnh chủ đầu tư)-->
<h2>Khi nào mua studio hợp lý hơn gửi tiết kiệm?</h2>
<ul>
<li>Tin rằng giá căn hộ ven biển còn tăng trong 5 – 10 năm và không cần dùng khoản tiền này.</li>
<li>Muốn có căn nghỉ dưỡng cho gia đình vài lần mỗi năm, lúc không ở thì cho thuê.</li>
<li>Chấp nhận thu nhập thấp hơn tiết kiệm trong vài năm đầu để đổi lấy tài sản.</li>
</ul>
<p>Nếu chỉ cần thu nhập đều và an toàn, gửi tiết kiệm vẫn là lựa chọn đơn giản hơn.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tiết kiệm hay mua studio Sun Saphia Residence cho thuê?',
			'desc'      => 'Cùng 3,19 tỷ: gửi tiết kiệm 12 tháng 5,4 – 6,7% thu khoảng 172 – 214 triệu/năm; studio Sun Saphia cho thuê lợi suất 3,5 – 5,5% thu 112 – 176 triệu.',
			'points'    => array(
				'Tiết kiệm 12 tháng 5,4 – 6,7%/năm: khoảng 172 – 214 triệu trên 3,19 tỷ',
				'Studio cho thuê lợi suất ròng 3,5 – 5,5%: khoảng 112 – 176 triệu/năm',
				'Studio có thêm khả năng tăng giá nhưng chờ bàn giao 11/2028 và có rủi ro cho thuê',
			),
			'faq'       => array(
				array( 'Gửi tiết kiệm 3 tỷ một năm được bao nhiêu?', 'Với lãi suất 12 tháng 5,4 – 6,7%/năm (cuối 10/2026), 3,19 tỷ cho khoảng 172 – 214 triệu tiền lãi mỗi năm.' ),
				array( 'Cho thuê căn hộ Đà Nẵng lợi suất bao nhiêu?', 'Theo Batdongsan.com.vn quý 3/2026, lợi suất cho thuê căn hộ Đà Nẵng khoảng 4,5%/năm.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/',
			'https://wiki.batdongsan.com.vn/tin-tuc/thi-truong-bat-dong-san-quy-32026-gia-ha-nhiet-chung-cu-tiep-tuc-dan-dat-nhu-cau-857618',
		),
	);

	/* ---------------- 10/11 – Căn hộ ven biển: hơi muối, mùa bão ---------------- */
	$posts[] = array(
		'slug'     => 'can-ho-ven-bien-hoi-muoi-mua-bao-sun-saphia-residence',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Căn hộ ven biển như Sun Saphia Residence: hơi muối, mùa mưa bão và những gì cần kiểm tra, bảo trì',
		'excerpt'  => 'Sống sát biển Đà Nẵng có cái giá riêng: hơi muối làm gỉ kim loại, ẩm, thấm; mùa mưa bão gió mạnh, sóng lớn. Chọn vật liệu nội thất, kiểm tra khi nhận nhà và bảo trì căn hộ ven biển như Sun Saphia Residence.',
		'keyword'  => 'căn hộ ven biển hơi muối',
		'keywords_extra' => array( 'Sun Saphia Residence', 'bảo trì căn hộ ven biển', 'căn hộ biển Đà Nẵng mùa mưa bão', 'nội thất căn hộ biển' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-10 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ biển Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/can-ho-ven-bien-hoi-muoi-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Căn hộ sát biển như {$saphia} (đường Trường Sa, đối diện công viên bãi tắm Sơn Thủy) có view và không khí mà căn trong phố không có. Đổi lại, môi trường biển làm đồ đạc xuống cấp nhanh hơn và mùa mưa bão cần chuẩn bị riêng. Bài tổng hợp những điểm nên biết trước khi mua, khi làm nội thất và khi sử dụng.</p>
<!--hh-featured-->
<h2>Hơi muối ảnh hưởng gì?</h2>
<p>Không khí biển chứa ion clorua – tác nhân gây ăn mòn kim loại và cốt thép trong bê tông; các nghiên cứu về bảo trì công trình ven biển khuyến nghị lập quy trình bảo trì ngay từ khi đưa công trình vào sử dụng. Với căn hộ, chỗ dễ thấy nhất:</p>
<ul>
<li>Bản lề, tay nắm, ốc vít, lan can kim loại gỉ nhanh.</li>
<li>Dàn nóng điều hòa ngoài ban công bị ăn mòn lá tản nhiệt.</li>
<li>Tường ẩm, sơn phồng, nấm mốc ở góc khuất nếu ít thông gió; một số nhà gần biển gặp nứt, thấm do độ ẩm và hơi muối cao.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tong-the-cong-vien-bai-tam.jpg|Mặt bằng tổng thể Sun Saphia Residence cạnh công viên bãi tắm Sơn Thủy (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Chọn nội thất cho căn hộ biển</h2>
<ul>
<li>Phụ kiện kim loại: ưu tiên loại chịu ăn mòn tốt (inox chất lượng cao, nhôm sơn tĩnh điện), hỏi rõ nhà cung cấp về môi trường biển.</li>
<li>Điều hòa: hỏi loại dàn nóng có lớp phủ chống ăn mòn.</li>
<li>Gỗ công nghiệp: chọn loại chống ẩm cho tủ bếp, tủ vệ sinh.</li>
<li>Rèm, sofa: vải dễ tháo giặt – căn cho thuê ngắn ngày càng cần.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-dem-toa-thap-ven-bien.jpg|Sun Saphia Residence về đêm, tòa tháp 30 tầng ven biển (ảnh chủ đầu tư)-->
<h2>Mùa mưa bão: chuẩn bị gì?</h2>
<p>Đà Nẵng thường mưa nhiều và có bão từ khoảng tháng 9 đến tháng 12. Theo báo chí, bờ biển phía Đông thành phố (Sơn Trà, Ngũ Hành Sơn) nhiều năm bị xâm thực, sạt lở vào mùa mưa bão. Với căn hộ trên cao:</p>
<ul>
<li>Kiểm tra gioăng cửa kính, ray cửa ban công trước mùa bão; nước tạt qua khe cửa là lỗi hay gặp ở căn hướng biển.</li>
<li>Dọn đồ ngoài ban công, khóa cửa kính khi có cảnh báo bão.</li>
<li>Căn cho thuê: thống nhất với đơn vị quản lý cách xử lý khi có bão, hủy phòng của khách.</li>
</ul>
<h2>Khi nhận nhà nên kiểm tra kỹ</h2>
<ol>
<li>Cửa kính, gioăng, độ kín nước (thử xịt nước nếu được).</li>
<li>Thoát nước sàn ban công, độ dốc về phễu thu.</li>
<li>Vị trí đặt dàn nóng, có mái che hay không.</li>
<li>Vết thấm, ẩm trên trần, tường giáp ban công.</li>
</ol>
<h2>Bảo trì định kỳ</h2>
<p>Vệ sinh dàn nóng điều hòa, lau phụ kiện kim loại, kiểm tra silicon, gioăng cửa – nên làm trước mùa mưa hằng năm. Chi phí này nên tính vào dòng tiền nếu mua để cho thuê (<a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">xem dòng tiền</a>). Phần kết cấu, mặt ngoài tòa nhà do ban quản trị dùng quỹ bảo trì 2% thực hiện.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ ven biển Sun Saphia: hơi muối, mùa bão, bảo trì',
			'desc'      => 'Căn hộ ven biển như Sun Saphia Residence: hơi muối làm gỉ kim loại, ẩm, thấm; mùa mưa bão tháng 9 – 12. Chọn nội thất, kiểm tra khi nhận nhà và bảo trì.',
			'points'    => array(
				'Ion clorua trong không khí biển gây ăn mòn kim loại, cốt thép',
				'Chọn phụ kiện, điều hòa, gỗ chống ẩm phù hợp môi trường biển',
				'Kiểm tra cửa kính, gioăng, thoát nước ban công trước mùa mưa bão',
			),
			'faq'       => array(
				array( 'Ở căn hộ sát biển có bị gỉ đồ không?', 'Có. Hơi muối (ion clorua) làm kim loại, dàn nóng điều hòa xuống cấp nhanh hơn; nên chọn vật liệu chịu ăn mòn và bảo trì định kỳ.' ),
				array( 'Mùa mưa bão Đà Nẵng vào tháng mấy?', 'Thường từ khoảng tháng 9 đến tháng 12.' ),
			),
		),
		'sources'  => array(
			'https://www.sggp.org.vn/bai-bien-da-nang-bi-xam-thuc-nghiem-trong-post775700.html',
			'https://vjol.info.vn/amc/article/download/81715/69619/',
		),
	);

	/* ---------------- 11/11 – Chuyển nhượng hợp đồng trước bàn giao ---------------- */
	$posts[] = array(
		'slug'     => 'chuyen-nhuong-hop-dong-sun-saphia-residence-truoc-ban-giao',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Bán lại Sun Saphia Residence trước khi nhận nhà: chuyển nhượng hợp đồng thế nào, thuế 2% ai nộp?',
		'excerpt'  => 'Mua Sun Saphia Residence rồi muốn bán lại trước bàn giao: Luật Kinh doanh BĐS 2023 cho chuyển nhượng hợp đồng mua bán nhà ở hình thành trong tương lai, lập văn bản, chủ đầu tư xác nhận; thuế thu nhập cá nhân 2% giá chuyển nhượng.',
		'keyword'  => 'chuyển nhượng hợp đồng mua bán căn hộ',
		'keywords_extra' => array( 'Sun Saphia Residence', 'bán lại Sun Saphia', 'chuyển nhượng căn hộ hình thành trong tương lai', 'thuế chuyển nhượng căn hộ 2%' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 08:00',
		'category' => 'Kinh nghiệm',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý bất động sản' ),
		'image'    => 'plugin:img/tin-tuc/chuyen-nhuong-hop-dong-sun-saphia.jpg',
		'content'  => <<<HTML
<p>{$saphia} bàn giao dự kiến 11/2028. Trong hơn 2 năm đó, người mua có thể cần bán lại vì đổi kế hoạch tài chính hoặc muốn chốt lời. Căn hộ chưa có sổ nên không bán theo kiểu sang tên sổ hồng, mà <strong>chuyển nhượng hợp đồng mua bán</strong> với chủ đầu tư. Bài tóm tắt cách làm theo Luật Kinh doanh bất động sản 2023.</p>
<!--hh-featured-->
<h2>Khi nào được chuyển nhượng hợp đồng?</h2>
<ul>
<li>Đã ký <strong>hợp đồng mua bán</strong> với chủ đầu tư (không phải chỉ phiếu giữ chỗ hay thỏa thuận đặt cọc).</li>
<li>Chuyển nhượng trước khi nộp hồ sơ đề nghị cấp giấy chứng nhận cho căn đó.</li>
<li>Chuyển nhượng toàn bộ hợp đồng; người nhận chuyển nhượng tiếp tục quyền và nghĩa vụ của người mua với chủ đầu tư.</li>
</ul>
<p>Các quy định chi tiết nằm ở các điều về chuyển nhượng hợp đồng kinh doanh bất động sản (Điều 49 – 51) của Luật số 29/2023/QH15; nên đọc văn bản gốc hoặc hỏi luật sư trước khi giao dịch.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg|Phối cảnh Sun Saphia Residence bên biển Sơn Thủy lúc hoàng hôn (ảnh chủ đầu tư)-->
<h2>Các bước thường gặp</h2>
<ol>
<li>Hai bên thỏa thuận giá, lập văn bản chuyển nhượng hợp đồng theo mẫu; công chứng hoặc chứng thực khi bên chuyển nhượng là cá nhân.</li>
<li>Nộp thuế thu nhập cá nhân và lệ phí liên quan.</li>
<li>Nộp hồ sơ để <strong>chủ đầu tư xác nhận</strong> vào văn bản chuyển nhượng; từ đây chủ đầu tư làm việc với người mua mới.</li>
<li>Bàn giao bản gốc hợp đồng, hóa đơn, chứng từ đã thanh toán cho người mua mới.</li>
</ol>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích căn (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Thuế: 2% trên giá chuyển nhượng</h2>
<p>Thuế thu nhập cá nhân khi chuyển nhượng bất động sản là <strong>2% giá chuyển nhượng</strong>; Luật Thuế thu nhập cá nhân sửa đổi thông qua cuối năm 2025 vẫn giữ mức này. Ví dụ minh hoạ: chuyển nhượng hợp đồng với giá 3 tỷ thì thuế khoảng 60 triệu. Ai trả thuế do hai bên thỏa thuận và nên ghi rõ trong văn bản. Khai giá thấp hơn thực tế để giảm thuế là rủi ro pháp lý cho cả hai bên.</p>
<h2>Người mua lại cần kiểm tra gì?</h2>
<ul>
<li>Hợp đồng gốc với chủ đầu tư, phụ lục, thư bảo lãnh ngân hàng của căn.</li>
<li>Số tiền đã trả theo từng đợt, khớp với chứng từ và xác nhận của chủ đầu tư.</li>
<li>Căn có đang thế chấp ngân hàng không – nếu có, cần ngân hàng đồng ý và tất toán hoặc chuyển khoản vay.</li>
<li>Các mốc thanh toán còn lại – xem <a href="/thanh-toan-can-ho-hinh-thanh-tuong-lai-sun-saphia-residence/">mức 30%, 70%, 95%</a>.</li>
</ul>
<p>Sau khi bàn giao và có sổ, giao dịch chuyển sang mua bán căn hộ thông thường – xem <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng: quy trình, giấy tờ</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bán lại Sun Saphia Residence trước bàn giao: thủ tục, thuế',
			'desc'      => 'Bán lại Sun Saphia Residence trước khi nhận nhà: chuyển nhượng hợp đồng theo Luật KDBĐS 2023, chủ đầu tư xác nhận, thuế TNCN 2% giá chuyển nhượng.',
			'points'    => array(
				'Chỉ chuyển nhượng được khi đã ký hợp đồng mua bán, trước khi nộp hồ sơ cấp sổ',
				'Lập văn bản chuyển nhượng, chủ đầu tư xác nhận',
				'Thuế thu nhập cá nhân 2% giá chuyển nhượng',
			),
			'faq'       => array(
				array( 'Có bán lại được căn Sun Saphia khi chưa nhận nhà không?', 'Được, bằng cách chuyển nhượng hợp đồng mua bán với chủ đầu tư theo Luật Kinh doanh bất động sản 2023, trước khi nộp hồ sơ cấp giấy chứng nhận; chủ đầu tư phải xác nhận văn bản chuyển nhượng.' ),
				array( 'Chuyển nhượng hợp đồng mua căn hộ chịu thuế bao nhiêu?', 'Thuế thu nhập cá nhân 2% trên giá chuyển nhượng; ai nộp do hai bên thỏa thuận.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat-nha-dat/ban-nha-o-hinh-thanh-trong-tuong-lai-co-phai-nop-thue-thu-nhap-ca-nhan-khong-10292.html',
			'https://hethongphapluat.com/luat-kinh-doanh-bat-dong-san-2023/dieu-51',
			'https://www.abs.vn/wp-content/uploads/2025/12/Weekly_Highlights_251212.pdf',
		),
	);

	/* ---------------- 12/11 – Dải biển Trường Sa – Ngũ Hành Sơn ---------------- */
	$posts[] = array(
		'slug'     => 'dai-bien-truong-sa-ngu-hanh-son-resort-sun-saphia-residence',
		'rev'     => 2, // 05/11: chèn ảnh dự án.
		'title'    => 'Dải biển Trường Sa – Ngũ Hành Sơn: resort, khách sạn quốc tế và vị trí của Sun Saphia Residence',
		'excerpt'  => 'Đường Trường Sa (Ngũ Hành Sơn) là dải biển tập trung nhiều resort, khách sạn quốc tế của Đà Nẵng và đang có thêm dự án nghỉ dưỡng mới. Sun Saphia Residence nằm ở đầu dải biển này, cạnh bãi tắm Sơn Thủy.',
		'keyword'  => 'dải biển Trường Sa Ngũ Hành Sơn',
		'keywords_extra' => array( 'Sun Saphia Residence', 'resort đường Trường Sa Đà Nẵng', 'bất động sản ven biển Ngũ Hành Sơn', 'căn hộ biển Ngũ Hành Sơn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-12 08:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn' ),
		'image'    => 'plugin:img/tin-tuc/dai-bien-truong-sa-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Từ giao lộ Võ Nguyên Giáp – Trường Sa đi về phía Hội An là dải biển <a href="/khu-vuc/ngu-hanh-son/">Ngũ Hành Sơn</a> – nơi tập trung nhiều resort, khách sạn quốc tế của Đà Nẵng. {$saphia} nằm ở đầu dải biển này, cạnh bãi tắm Sơn Thủy. Bài nhìn lại dải biển này đang có gì và vì sao vị trí đó ảnh hưởng tới giá và khả năng cho thuê.</p>
<!--hh-featured-->
<h2>Dải biển này đang có gì?</h2>
<ul>
<li><strong>Resort, khách sạn quốc tế</strong>: dọc Trường Sa có nhiều thương hiệu như Hyatt Regency, Sheraton Grand, Naman Retreat, Fusion Resort &amp; Villas – nhóm khách lưu trú chi tiêu cao.</li>
<li><strong>Bãi tắm công cộng</strong>: Sơn Thủy và chuỗi công viên bãi tắm thành phố đang đầu tư, gồm công viên khoảng 2,45 ha đối diện Sun Saphia (<a href="/tien-ich-sun-saphia-residence-noi-khu-xung-quanh/">xem tiện ích</a>).</li>
<li><strong>Danh thắng Ngũ Hành Sơn</strong>, làng đá Non Nước phía trong.</li>
<li><strong>Dự án nghỉ dưỡng mới</strong>: cuối tháng 10/2026, một dự án khu du lịch, dịch vụ sinh thái ven biển nằm giữa Fusion Resort và Naman Retreat đã dọn mặt bằng; theo quy hoạch 1/500 được chia sẻ, dự án có tháp khách sạn 5 sao 30 tầng và 2 tháp căn hộ du lịch 15 tầng (thông tin đang chờ xác nhận chính thức).</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tong-the-cong-vien-bai-tam.jpg|Mặt bằng tổng thể Sun Saphia Residence cạnh công viên bãi tắm Sơn Thủy (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Hạ tầng đang làm quanh dải biển</h2>
<ul>
<li>Mở rộng trục Võ Nguyên Giáp – Trường Sa – Lạc Long Quân – xem <a href="/mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty/">dự án 2.633 tỷ</a>.</li>
<li>Đường sắt đô thị sân bay – Mỹ Khê – Hội An dự kiến, ga LRT 09 cách Sun Saphia khoảng 500 m – xem <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">tiến độ</a>.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-dem-toa-thap-ven-bien.jpg|Sun Saphia Residence về đêm, tòa tháp 30 tầng ven biển (ảnh chủ đầu tư)-->
<h2>Vị trí Sun Saphia trong dải biển</h2>
<table>
<thead><tr><th>Yếu tố</th><th>Sun Saphia Residence</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Giao lộ Võ Nguyên Giáp – Trường Sa, đầu dải biển Ngũ Hành Sơn, giáp khu Mỹ Khê</td></tr>
<tr><td>Bãi tắm</td><td>Sơn Thủy, đối diện công viên ven biển</td></tr>
<tr><td>Loại sản phẩm</td><td>Căn hộ thời hạn 50 năm, 782 căn, phần lớn studio</td></tr>
<tr><td>Khác với resort</td><td>Tổng tiền mỗi căn nhỏ, người mua tự ở hoặc tự cho thuê</td></tr>
</tbody>
</table>
<h2>Ý nghĩa với người mua – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Thương hiệu xung quanh kéo khách</strong>: khách đến khu resort cao cấp cũng là nguồn khách thuê tiềm năng cho căn hộ gần đó, nhất là gia đình, nhóm bạn ở dài ngày.</li>
<li><strong>Nguồn cung lưu trú cũng tăng</strong>: thêm khách sạn, căn hộ du lịch mới nghĩa là cạnh tranh giá thuê; căn có view biển, vận hành tốt mới giữ được công suất.</li>
<li><strong>Đầu dải biển, gần phố</strong>: so với resort sâu phía Nam, Sun Saphia gần Mỹ Khê và trung tâm hơn – lợi cho người ở thật và khách thuê theo tháng.</li>
</ul>
<p>So sánh thêm các khu biển: <a href="/can-ho-ven-bien-my-khe-son-thuy-non-nuoc-so-sanh/">Mỹ Khê, Sơn Thủy hay Non Nước</a>; vị trí chi tiết: <a href="/sun-saphia-residence-o-dau-vi-tri/">Sun Saphia Residence ở đâu</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Dải biển Trường Sa – Ngũ Hành Sơn và Sun Saphia Residence',
			'desc'      => 'Dải biển Trường Sa (Ngũ Hành Sơn) tập trung resort, khách sạn quốc tế, có thêm dự án nghỉ dưỡng mới. Sun Saphia Residence nằm ở đầu dải biển này.',
			'points'    => array(
				'Dọc Trường Sa có nhiều resort, khách sạn quốc tế: Hyatt Regency, Sheraton Grand, Naman Retreat, Fusion',
				'Dự án nghỉ dưỡng mới giữa Fusion và Naman đã dọn mặt bằng (thông tin quy mô chờ xác nhận)',
				'Sun Saphia ở đầu dải biển, giao lộ Võ Nguyên Giáp – Trường Sa, cạnh bãi tắm Sơn Thủy',
			),
			'faq'       => array(
				array( 'Đường Trường Sa Đà Nẵng có những resort nào?', 'Dọc Trường Sa (phường Ngũ Hành Sơn) có nhiều resort, khách sạn quốc tế như Hyatt Regency, Sheraton Grand, Naman Retreat, Fusion Resort & Villas.' ),
				array( 'Sun Saphia Residence nằm ở đâu trên dải biển Trường Sa?', 'Ở giao lộ Võ Nguyên Giáp – Trường Sa, đầu dải biển Ngũ Hành Sơn, cạnh bãi tắm Sơn Thủy và đối diện công viên ven biển.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
