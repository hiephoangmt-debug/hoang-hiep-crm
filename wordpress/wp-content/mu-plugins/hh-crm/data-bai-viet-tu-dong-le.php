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
		'rev'      => 2, // 22/10: thêm phần mặt cắt, quỹ đất.
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
<h2>Cập nhật 22/10: hai mặt cắt điển hình và quỹ đất dọc tuyến</h2>
<p>Bản đồ mô phỏng mới chia sẻ trên mạng xã hội cho thấy hai dạng mặt cắt: đoạn mở mới qua cánh đồng phía Tây sông Trường Giang đo khoảng <strong>138 m</strong> (khớp phương án giải tỏa 138 m của Sở Xây dựng), đoạn bám ĐT 619 đo khoảng <strong>170 m</strong> – phù hợp chủ trương mở rộng nền đường hai bên để dự trữ đất, làm đường gom và dải cây xanh cách ly. Bản đồ cũng khoanh nhiều khu đất dọc sông Trường Giang, từ Thăng An đến gần Tam Hải, tương ứng định hướng khai thác quỹ đất và khu TOD mà thành phố đã nêu. Chi tiết: <a href="/mat-cat-cao-toc-noi-thi-da-nang-chu-lai-quy-dat-tod/">mặt cắt và quỹ đất dọc cao tốc nội thị</a>.</p>
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

	/* ---------------- 22/10 – Mặt cắt, quỹ đất cao tốc nội thị ---------------- */
	$posts[] = array(
		'slug'     => 'mat-cat-cao-toc-noi-thi-da-nang-chu-lai-quy-dat-tod',
		'title'    => 'Mặt cắt cao tốc nội thị Đà Nẵng – Chu Lai: đoạn 138 m, đoạn khoảng 170 m và quỹ đất dọc sông Trường Giang',
		'excerpt'  => 'Hai mặt cắt điển hình cao tốc nội thị Đà Nẵng – Chu Lai: tuyến mới phía Tây sông Trường Giang giải tỏa 138 m, đoạn bám ĐT 619 mở rộng hai bên. Quỹ đất, khu TOD và lưu ý khi mua đất dọc tuyến.',
		'keyword'  => 'mặt cắt cao tốc nội thị Đà Nẵng',
		'keywords_extra' => array( 'cao tốc nội thị Đà Nẵng Chu Lai', 'quỹ đất cao tốc nội thị', 'TOD Đà Nẵng', 'đất dọc sông Trường Giang' ),
		'project'  => 'vinh-an-hoa-city',
		'schedule' => '2026-10-22 11:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Cao tốc nội thị' ),
		'image'    => 'plugin:img/tin-tuc/cao-toc-noi-thi-mat-cat-quy-dat.jpg',
		'image_alt' => 'Sơ đồ hai mặt cắt điển hình cao tốc nội thị Đà Nẵng – Chu Lai: 138 m và đoạn bám ĐT 619',
		'content'  => <<<HTML
<p>Sau hướng tuyến, câu hỏi tiếp theo về <strong>cao tốc nội thị Đà Nẵng – Chu Lai</strong> là đường rộng bao nhiêu và đất hai bên sẽ ra sao. Một bản đồ mô phỏng vừa được chia sẻ trên mạng xã hội cho thấy hai mặt cắt điển hình và các khu đất được khoanh dọc tuyến. Hoàng Hiệp đối chiếu với thông tin chính thức đã công bố để tách phần chắc chắn và phần còn là mô phỏng.</p>
<!--hh-featured-->
<h2>Mặt cắt 1: tuyến mở mới phía Tây sông Trường Giang – 138 m</h2>
<p>Đoạn 1 (khoảng 46,9 km) đi theo đường Lê Văn Hiến đến nút Phạm Như Xương, rồi mở tuyến mới về phía Tây sông Trường Giang đến nút Bình Sa. Theo Sở Xây dựng Đà Nẵng, phương án giai đoạn 1 <strong>giải tỏa đủ 138 m mặt cắt ngang</strong>, làm trước mặt đường mỗi bên 3 làn, vốn gần 15.000 tỷ đồng. Trên bản đồ mô phỏng, khoảng cách giữa hai mép tuyến qua cánh đồng đo được 138,1 m – khớp với con số này.</p>
<h2>Mặt cắt 2: bám ĐT 619 – mở rộng hai bên</h2>
<p>Đoạn 2 (khoảng 41,8 km) bám ĐT 619 (đường ven biển 129) hiện trạng. Phương án đã công bố: <strong>mở rộng nền đường hai bên để dự trữ quỹ đất</strong> cho nâng cấp sau này, bố trí đường gom và dải cây xanh cách ly. Trên bản đồ mô phỏng, phạm vi đoạn qua vùng cát ven biển đo khoảng 170 m. Con số này là đo trên hình mô phỏng, chưa phải mặt cắt thiết kế chính thức.</p>
<table>
<thead><tr><th></th><th>Đoạn mở mới</th><th>Đoạn bám ĐT 619</th></tr></thead>
<tbody>
<tr><td>Chiều dài</td><td>Khoảng 46,9 km</td><td>Khoảng 41,8 km</td></tr>
<tr><td>Mặt cắt</td><td>138 m (phương án Sở Xây dựng)</td><td>Mở rộng hai bên; khoảng 170 m trên bản đồ mô phỏng</td></tr>
<tr><td>Địa hình</td><td>Cánh đồng, khu dân cư phía Tây sông Trường Giang</td><td>Vùng cát ven biển, đường hiện hữu</td></tr>
</tbody>
</table>
<h2>Quỹ đất và khu TOD dọc tuyến</h2>
<ul>
<li>Phương án hoàn chỉnh: hai bên vệt tuyến <strong>thu hồi thêm 100 m</strong> chiều ngang, đền bù sạch – tổng mức đầu tư hơn <strong>30.800 tỷ đồng</strong>.</li>
<li>Lãnh đạo thành phố kỳ vọng giá trị khai thác quỹ đất dọc tuyến có thể vượt tổng mức đầu tư; các khu TOD (đô thị quanh nút giao thông) sẽ tính theo địa hình và dân cư hiện trạng.</li>
<li>Bản đồ mô phỏng khoanh nhiều khu đất dọc sông Trường Giang, quanh Thăng An, Bản Thạch đến gần Tam Hải – ranh giới cụ thể chưa có văn bản công bố.</li>
</ul>
<h2>Người mua đất dọc tuyến cần lưu ý</h2>
<ol>
<li><strong>Đất trong phạm vi 138 m</strong> (và có thể thêm 100 m mỗi bên) có khả năng bị thu hồi theo giá bồi thường, không phải giá thị trường.</li>
<li>Đất nông nghiệp trong khu khoanh quỹ đất <strong>khó chuyển đổi</strong> khi Nhà nước đã định hướng khai thác.</li>
<li>Đất ở ngoài phạm vi thu hồi, gần nút giao mới là nhóm hưởng lợi rõ nhất khi tuyến hoàn thành.</li>
<li>Tin rao "sát cao tốc" khi dự án còn ở bước chuẩn bị đầu tư cần kiểm tra quy hoạch tại xã, phường trước khi đặt cọc.</li>
</ol>
<h2>Dự án hưởng lợi ở hai đầu tuyến</h2>
<p>Đầu phía Nam, <a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> ven vịnh An Hòa – sông Trường Giang, cạnh sân bay Chu Lai, và <a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a> được rút ngắn đường về trung tâm. Đầu phía Bắc, tuyến bắt đầu từ Lê Văn Hiến – song song đường biển Trường Sa, gần dự án <a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> tại khu biển Sơn Thủy.</p>
<p>Đọc thêm: <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">hướng tuyến, vốn và tiến độ cao tốc nội thị Đà Nẵng – Chu Lai</a>.</p>
<p>Cần kiểm tra một lô đất có nằm trong phạm vi tuyến hay không, hoặc tìm sản phẩm dọc trục Đà Nẵng – Chu Lai, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt cắt cao tốc nội thị Đà Nẵng – Chu Lai: 138 m, quỹ đất',
			'desc'      => 'Mặt cắt cao tốc nội thị Đà Nẵng – Chu Lai: tuyến mới 138 m phía Tây sông Trường Giang, đoạn ĐT 619 mở rộng hai bên. Quỹ đất, TOD, lưu ý mua đất dọc tuyến.',
			'points'    => array(
				'Đoạn mở mới phía Tây sông Trường Giang: giải tỏa 138 m (Sở Xây dựng Đà Nẵng)',
				'Đoạn bám ĐT 619: mở rộng hai bên dự trữ đất; khoảng 170 m trên bản đồ mô phỏng',
				'Thu hồi thêm 100 m mỗi bên để khai thác quỹ đất – tổng mức hơn 30.800 tỷ',
			),
			'faq'       => array(
				array( 'Cao tốc nội thị Đà Nẵng – Chu Lai rộng bao nhiêu mét?', 'Đoạn mở mới phía Tây sông Trường Giang theo phương án giải tỏa 138 m; đoạn bám ĐT 619 mở rộng hai bên, bản đồ mô phỏng đo khoảng 170 m – chưa phải thiết kế chính thức.' ),
				array( 'Đất hai bên cao tốc nội thị có bị thu hồi không?', 'Phương án hoàn chỉnh thu hồi thêm 100 m mỗi bên để khai thác quỹ đất; ranh giới cụ thể chờ quy hoạch và quyết định thu hồi chính thức.' ),
			),
		),
		'sources'  => array(
			'https://tienphong.vn/tuyen-cao-toc-noi-thi-4-6-lan-xe-ket-noi-trung-tam-da-nang-den-chu-lai-chay-qua-nhung-khu-vuc-nao-post1827072.tpo',
			'https://plo.vn/cao-toc-noi-thanh-da-nang-co-van-toc-thiet-ke-80-kmgio-post908251.html',
			'https://danviet.vn/da-nang-tinh-lam-cao-toc-noi-thi-gan-90-km-noi-thang-chu-lai-d1409821.html',
			'https://tuoitre.vn/cao-toc-noi-thi-tu-trung-tam-da-nang-den-chu-lai-se-di-qua-17-xa-phuong-20260506190504808.htm',
		),
	);

	return $posts;
}
