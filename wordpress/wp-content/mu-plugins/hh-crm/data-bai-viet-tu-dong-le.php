<?php
/**
 * Bài tin lẻ cho mục Tự đăng bài (không nạp trong plugin – xuất bằng scripts/xuat-bai-tu-dong.php vào wordpress/tu-dong/).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tu_dong_le' );
function hh_posts_tu_dong_le( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Cần bảng giá, mặt bằng ' . $saphia . ' hoặc so sánh căn hộ, đất nền dọc trục Đà Nẵng – Chu Lai, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 19/10 – Cao tốc nội thị Đà Nẵng – Chu Lai ---------------- */
	$posts[] = array(
		'slug'     => 'cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do',
		'title'    => 'Cao tốc nội thị Đà Nẵng – Chu Lai gần 90 km: hướng tuyến, quy mô, tiến độ và tác động tới Sun Saphia Residence',
		'excerpt'  => 'Cao tốc nội thị Đà Nẵng – Chu Lai dài gần 90 km, tốc độ 80 km/h, đi từ nút Hồ Xuân Hương theo Lê Văn Hiến về sân bay Chu Lai. Hướng tuyến, vốn 15.000 – 30.800 tỷ, tiến độ và bất động sản hưởng lợi.',
		'keyword'  => 'cao tốc nội thị Đà Nẵng Chu Lai',
		'keywords_extra' => array( 'Sun Saphia Residence', 'cao tốc nội thị Đà Nẵng', 'đường Lê Văn Hiến mở rộng', 'hạ tầng Đà Nẵng 2026' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-19 15:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Cao tốc nội thị', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/cao-toc-noi-thi-da-nang-chu-lai.jpg',
		'image_alt' => 'Sơ đồ minh hoạ hướng tuyến cao tốc nội thị Đà Nẵng – Chu Lai',
		'content'  => <<<HTML
<p><strong>Cao tốc nội thị Đà Nẵng – Chu Lai</strong> là tuyến đường đô thị tốc độ cao dài gần 90 km, nối trung tâm thành phố (nút giao Hồ Xuân Hương – cầu Tiên Sơn) với sân bay Chu Lai. Tuyến đi theo đường Lê Văn Hiến qua Ngũ Hành Sơn – cách khu biển Sơn Thủy, nơi Sun Group ra mắt {$saphia}, chỉ vài phút chạy xe. Dưới đây là thông tin đã được báo chí công bố và những điểm còn chờ phê duyệt.</p>
<!--hh-featured-->
<h2>Hướng tuyến cao tốc nội thị Đà Nẵng – Chu Lai</h2>
<table>
<thead><tr><th>Đoạn</th><th>Hướng tuyến</th><th>Chiều dài</th></tr></thead>
<tbody>
<tr><td>Đoạn 1</td><td>Từ nút Hồ Xuân Hương theo đường Lê Văn Hiến hiện trạng (khoảng 9,5 km trùng tuyến) đến nút Phạm Như Xương; từ đây mở tuyến mới phía Tây sông Trường Giang đến nút Bình Sa, nối ĐT 619</td><td>Khoảng 46,9 km</td></tr>
<tr><td>Đoạn 2</td><td>Bám ĐT 619 (đường ven biển 129) hiện trạng, nâng cấp thành đường đô thị tốc độ cao về sân bay Chu Lai</td><td>Khoảng 41,8 km</td></tr>
</tbody>
</table>
<p>Tuyến đi qua 17 xã, phường; tốc độ thiết kế dự kiến <strong>80 km/h</strong>; Ban Quản lý các dự án đầu tư cơ sở hạ tầng ưu tiên thành phố được giao làm chủ đầu tư (Thanh Niên, Tiền Phong, Pháp Luật TP.HCM, 3 – 5/2026).</p>
<h2>Quy mô và vốn đầu tư</h2>
<ul>
<li><strong>Giai đoạn đầu</strong>: thông tuyến 4 – 6 làn xe; khi lưu lượng lớn sẽ đầu tư đồng bộ toàn mặt cắt.</li>
<li>Theo Sở Xây dựng Đà Nẵng: nếu giải tỏa đủ <strong>mặt cắt 138 m</strong> và làm trước mỗi bên 3 làn, vốn gần <strong>15.000 tỷ đồng</strong>; nếu thu hồi thêm 100 m hai bên để khai thác quỹ đất, tổng mức đầu tư hơn <strong>30.800 tỷ đồng</strong>.</li>
<li>Thành phố cân nhắc hai hình thức: đầu tư công hoặc hợp tác công tư (PPP).</li>
</ul>
<p>Một số trang cộng đồng đang chia sẻ phương án chi tiết hơn: đoạn Hồ Xuân Hương – Phạm Như Xương giữ mặt cắt hiện trạng 48 m (đường chính 4 làn, đường gom mỗi bên 2 làn, dành dải giữa cho đường sắt đô thị), đoạn Phạm Như Xương – cầu Diêm Trà (xã Tam Anh) mặt cắt 138 m với 8 – 10 làn cao tốc, đoạn cầu Diêm Trà – sân bay Chu Lai 66 – 75 m, toàn tuyến 17 nút giao. Đến ngày đăng bài, Hoàng Hiệp chưa thấy văn bản chính thức công bố các số liệu này – xem như thông tin tham khảo.</p>
<h2>Tiến độ dự kiến</h2>
<ul>
<li>Lộ trình đề xuất: phê duyệt báo cáo tiền khả thi 9/2026, báo cáo khả thi 2/2027, khởi công 10/2027, hoàn thành 2031.</li>
<li>Chủ tịch UBND thành phố cho rằng mốc 2031 là quá chậm và yêu cầu tính phương án rút ngắn thi công còn 1 – 2 năm (5/2026).</li>
<li>Dự án đi song song với tuyến đường sắt đô thị nối sân bay Đà Nẵng về phía Nam.</li>
</ul>
<h2>Bất động sản nào hưởng lợi?</h2>
<p><strong>Căn hộ ven biển Ngũ Hành Sơn</strong>: Lê Văn Hiến là trục song song đường biển Trường Sa. Khi tuyến hoàn thành, cư dân và khách thuê ở khu Sơn Thủy – Non Nước đi nhanh về Hội An, Tam Kỳ, Chu Lai, trong khi vẫn gần trung tâm. Đây là lợi thế cộng thêm cho các dự án mới như {$saphia} (30 tầng, 782 căn, bàn giao dự kiến 11/2028), bên cạnh dự án mở rộng đường ven biển Võ Nguyên Giáp – Trường Sa.</p>
<p><strong>Đất nền phía Nam</strong>: các khu đô thị dọc trục như <a href="/du-an/khu-do-thi-1a-1b-dien-ngoc/">Khu đô thị 1A 1B Điện Ngọc</a>, <a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a> và <a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> cạnh sân bay Chu Lai được rút ngắn thời gian về trung tâm Đà Nẵng.</p>
<h2>Lưu ý khi mua dọc tuyến</h2>
<ul>
<li>Dự án đang ở giai đoạn chuẩn bị đầu tư; hướng tuyến và mặt cắt có thể điều chỉnh khi phê duyệt.</li>
<li>Đất nằm trong phạm vi 138 m (và có thể thêm 100 m hai bên) có nguy cơ bị thu hồi – cần kiểm tra quy hoạch trước khi đặt cọc.</li>
<li>Cẩn thận tin rao "sát cao tốc" dùng để đẩy giá khi chưa có quyết định đầu tư.</li>
</ul>
<p>Xem thêm: <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>, <a href="/duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu/">đường tránh Nam Hải Vân 6 làn</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cao tốc nội thị Đà Nẵng – Chu Lai: tuyến, vốn, Sun Saphia',
			'desc'      => 'Cao tốc nội thị Đà Nẵng – Chu Lai gần 90 km, 80 km/h, vốn 15.000 – 30.800 tỷ: hướng tuyến qua Lê Văn Hiến, tiến độ và tác động tới Sun Saphia Residence.',
			'points'    => array(
				'Dài gần 90 km, tốc độ thiết kế 80 km/h, giai đoạn đầu 4 – 6 làn',
				'Vốn gần 15.000 tỷ (mặt cắt 138 m) đến hơn 30.800 tỷ nếu thu hồi thêm quỹ đất',
				'Dự kiến khởi công 10/2027; thành phố yêu cầu rút ngắn tiến độ',
			),
			'faq'       => array(
				array( 'Cao tốc nội thị Đà Nẵng – Chu Lai dài bao nhiêu km?', 'Gần 90 km: đoạn 1 khoảng 46,9 km từ nút Hồ Xuân Hương theo Lê Văn Hiến đến nút Bình Sa; đoạn 2 khoảng 41,8 km bám ĐT 619 về sân bay Chu Lai.' ),
				array( 'Khi nào khởi công cao tốc nội thị Đà Nẵng?', 'Theo lộ trình đề xuất (5/2026), dự kiến khởi công 10/2027 và hoàn thành 2031; thành phố đang yêu cầu rút ngắn tiến độ.' ),
				array( 'Cao tốc nội thị có đi qua Sun Saphia Residence không?', 'Tuyến đi theo đường Lê Văn Hiến, song song đường biển Trường Sa; Sun Saphia Residence ở khu biển Sơn Thủy gần đầu tuyến, nên kết nối về phía Nam thuận tiện hơn.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/cao-toc-noi-thi-dai-90-km-ma-da-nang-sap-dau-tu-co-gi-dac-biet-185260313105559431.htm',
			'https://tienphong.vn/tuyen-cao-toc-noi-thi-4-6-lan-xe-ket-noi-trung-tam-da-nang-den-chu-lai-chay-qua-nhung-khu-vuc-nao-post1827072.tpo',
			'https://plo.vn/cao-toc-noi-thanh-da-nang-co-van-toc-thiet-ke-80-kmgio-post908251.html',
			'https://tuoitre.vn/cao-toc-noi-thi-tu-trung-tam-da-nang-den-chu-lai-se-di-qua-17-xa-phuong-20260506190504808.htm',
			'https://cafef.vn/cao-toc-noi-thi-da-nang-du-kien-moc-2031-chu-tich-thanh-pho-noi-thang-qua-cham-18826050618550502.chn',
		),
	);

	return $posts;
}
