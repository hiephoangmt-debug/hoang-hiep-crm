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

	/* ---------------- 22/10 – Cải tạo cảnh quan hai bờ sông Hàn ---------------- */
	$posts[] = array(
		'slug'     => 'cai-tao-canh-quan-hai-bo-song-han-29-ha',
		'title'    => 'Cải tạo cảnh quan hai bờ sông Hàn khoảng 29,22 ha: 5 phường, các khu vực dự kiến và căn hộ ven sông hưởng lợi',
		'excerpt'  => 'Dự án đầu tư, cải tạo cảnh quan hai bờ sông Hàn dự kiến khoảng 29,22 ha qua 5 phường Sơn Trà, An Hải, Hải Châu, Hòa Cường, Ngũ Hành Sơn: bến thủy, tuyến đi bộ, chiếu sáng. Các khu vực và tác động tới căn hộ ven sông.',
		'keyword'  => 'cải tạo cảnh quan sông Hàn',
		'keywords_extra' => array( 'cảnh quan hai bờ sông Hàn', 'căn hộ ven sông Hàn', 'bờ Đông sông Hàn', 'Capital Square Đà Nẵng' ),
		'project'  => 'capital-square-da-nang',
		'schedule' => '2026-10-22 10:30',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Sông Hàn', 'Căn hộ ven sông Hàn' ),
		'image'    => 'plugin:img/tin-tuc/cai-tao-canh-quan-hai-bo-song-han.jpg',
		'image_alt' => 'Sơ đồ minh hoạ các khu vực dự kiến cải tạo cảnh quan hai bờ sông Hàn, từ cầu Thuận Phước đến cầu Tiên Sơn',
		'content'  => <<<HTML
<p>Đà Nẵng đang chuẩn bị dự án <strong>đầu tư, cải tạo cảnh quan hai bên bờ sông Hàn</strong>. Theo thông tin đang được chia sẻ, phạm vi dự kiến khoảng <strong>292.194 m² (khoảng 29,22 ha)</strong>, trải trên 5 phường Sơn Trà, An Hải, Hải Châu, Hòa Cường và Ngũ Hành Sơn – từ khu cầu Thuận Phước đến cầu Tiên Sơn. Hoàng Hiệp tổng hợp các khu vực dự kiến, mục tiêu dự án và tác động tới nhà ở ven sông.</p>
<!--hh-featured-->
<h2>Dự án làm gì?</h2>
<p>Mục tiêu được nêu: cải tạo, chỉnh trang và nâng cao chất lượng cảnh quan đô thị; liên kết với <strong>hệ thống bến thủy nội địa</strong>, <strong>tuyến đi bộ</strong> và <strong>chiếu sáng cảnh quan</strong> các công trình, cầu qua sông; tăng khả năng tiếp cận mặt nước, kết nối không gian đô thị và phát huy giá trị cảnh quan sông Hàn.</p>
<h2>Các khu vực dự kiến</h2>
<table>
<thead><tr><th>Bờ</th><th>Khu vực</th><th>Đoạn sông (theo bản đồ dự kiến)</th></tr></thead>
<tbody>
<tr><td rowspan="5">Bờ Tây (Hải Châu, Hòa Cường)</td><td>1, 2</td><td>Phía Bắc, từ khu cầu Thuận Phước đến cầu Sông Hàn</td></tr>
<tr><td>3.1</td><td>Cầu Sông Hàn – cầu Rồng</td></tr>
<tr><td>3.2, 4.1</td><td>Cầu Rồng – cầu Trần Thị Lý</td></tr>
<tr><td>4.2</td><td>Phía Nam cầu Trần Thị Lý</td></tr>
<tr><td>4.3</td><td>Gần cầu Tiên Sơn</td></tr>
<tr><td rowspan="3">Bờ Đông (Sơn Trà, An Hải, Ngũ Hành Sơn)</td><td>6</td><td>Phía Bắc cầu Sông Hàn</td></tr>
<tr><td>5.1</td><td>Cầu Sông Hàn – cầu Rồng (dọc đường Trần Hưng Đạo)</td></tr>
<tr><td>5.2, 5.3</td><td>Cầu Rồng – cầu Trần Thị Lý</td></tr>
</tbody>
</table>
<p>Ranh giới và tổng mức đầu tư từng khu vực chưa được công bố trên báo chí đến ngày đăng bài – cần chờ văn bản phê duyệt chính thức.</p>
<h2>Nằm trong chuỗi dự án ven sông Hàn</h2>
<ul>
<li><strong>Quy hoạch phân khu ven sông Hàn và bờ Đông</strong> (Quyết định 2451/QĐ-UBND, hơn 6.600 ha): bờ Đông định hướng trung tâm tài chính – thương mại mới, bờ Tây bảo tồn di sản, kết nối cộng đồng (Thanh Niên, 9/2026).</li>
<li><strong>Cải tạo cảnh quan bờ Đông dọc đường Trần Hưng Đạo</strong>: vốn hơn 425 tỷ đồng, thực hiện 2025 – 2028.</li>
<li><strong>Chiếu sáng nghệ thuật "Dòng sông ánh sáng"</strong>: giai đoạn 1 khoảng 149 tỷ đồng, 2025 – 2027 – đèn trang trí các cầu, chiếu sáng mặt nước.</li>
<li>Điều chỉnh dự án bến du thuyền theo hướng tăng cây xanh, mở lối đi công cộng (Tuổi Trẻ, 3/2026); hầm vượt sông Hàn nối Sơn Trà – Hải Châu, nâng cấp cầu đi bộ Nguyễn Văn Trỗi đang được thúc đẩy.</li>
</ul>
<h2>Căn hộ ven sông nào hưởng lợi?</h2>
<p><strong>Bờ Đông, đường Trần Hưng Đạo</strong> (khu vực 5.1 – 5.3): tổ hợp <a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a> với các tòa mặt đường Trần Hưng Đạo, <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> và <a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a> phía Nam. Phía Bắc bờ Đông (khu vực 6) có <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, <a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>.</p>
<p><strong>Bờ Tây</strong> (khu vực 3.2 – 4.3): <a href="/du-an/the-filmore-da-nang/">The Filmore</a>, <a href="/du-an/danang-landmark/">Danang Landmark</a> trên đường Bạch Đằng, <a href="/du-an/m-riverside-da-nang/">M Riverside</a> gần cầu Trần Thị Lý.</p>
<p>Lợi ích trực tiếp: lối đi bộ và tiếp cận mặt nước tốt hơn, bến thủy phục vụ du lịch đường sông, cảnh quan về đêm đẹp hơn – yếu tố quan trọng với căn hộ cho thuê khách du lịch. Trong thời gian thi công, các đoạn đường ven sông có thể bị rào chắn tạm thời.</p>
<p>Xem thêm: <a href="/du-an/capital-square-hudson-place-s4/">Hudson Place S4 Capital Square</a> – tòa căn hộ cạnh cầu Sông Hàn.</p>
<p>Cần bảng giá căn hộ ven sông Hàn hai bờ hoặc so sánh dự án, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cải tạo cảnh quan hai bờ sông Hàn 29,22 ha: các khu vực',
			'desc'      => 'Dự án cải tạo cảnh quan hai bờ sông Hàn khoảng 29,22 ha qua 5 phường: bến thủy, tuyến đi bộ, chiếu sáng. Các khu vực dự kiến, căn hộ ven sông hưởng lợi.',
			'points'    => array(
				'Phạm vi dự kiến khoảng 29,22 ha, 5 phường hai bờ sông Hàn',
				'Bến thủy nội địa, tuyến đi bộ, chiếu sáng cảnh quan công trình và cầu',
				'Bờ Đông Trần Hưng Đạo đã có dự án cảnh quan hơn 425 tỷ (2025 – 2028)',
			),
			'faq'       => array(
				array( 'Dự án cải tạo cảnh quan hai bờ sông Hàn rộng bao nhiêu?', 'Theo thông tin đang được chia sẻ, khoảng 292.194 m² (29,22 ha) thuộc các phường Sơn Trà, An Hải, Hải Châu, Hòa Cường, Ngũ Hành Sơn; chờ văn bản phê duyệt chính thức.' ),
				array( 'Cải tạo cảnh quan sông Hàn gồm những gì?', 'Chỉnh trang cảnh quan, kết nối bến thủy nội địa, tuyến đi bộ, chiếu sáng cảnh quan công trình và cầu qua sông, tăng khả năng tiếp cận mặt nước.' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/dien-mao-hai-bo-song-han-5-nam-toi-185260917170837573.htm',
			'https://www.vietnamplus.vn/da-nang-nang-cap-cai-tao-canh-quan-tuyen-duong-ven-song-han-post941645.vnp',
			'https://dantri.com.vn/du-lich/da-nang-chi-149-ty-dong-thap-sang-song-han-20250924190725916.htm',
			'https://tuoitre.vn/dieu-chinh-du-an-ben-du-thuyen-da-nang-tang-cay-xanh-mo-loi-di-cong-cong-20260325163605872.htm',
		),
	);

	/* ---------------- 22/10 – Trường tiểu học Hòa Xuân ---------------- */
	$posts[] = array(
		'slug'     => 'truong-tieu-hoc-cong-lap-khu-do-thi-sinh-thai-hoa-xuan',
		'title'    => 'Trường tiểu học công lập trong Khu đô thị sinh thái Hòa Xuân: khu đất 13.655 m², 3 mặt tiền Lê Sỹ – Cồn Dầu 18 – Đỗ Quỳ',
		'excerpt'  => 'Đà Nẵng triển khai đầu tư Trường Tiểu học Hòa Xuân trong Khu đô thị sinh thái Hòa Xuân: khu đất 13.655 m², ba mặt tiền Lê Sỹ, Cồn Dầu 18, Đỗ Quỳ. Ý nghĩa với cư dân và đất nền khu vực.',
		'keyword'  => 'trường tiểu học Hòa Xuân',
		'keywords_extra' => array( 'khu đô thị sinh thái Hòa Xuân', 'đất nền Hòa Xuân', 'trường học Cẩm Lệ', 'Cồn Dầu Hòa Xuân' ),
		'project'  => 'kdt-sinh-thai-hoa-xuan',
		'schedule' => '2026-10-22 17:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Hòa Xuân', 'Trường học' ),
		'image'    => 'plugin:img/tin-tuc/truong-tieu-hoc-hoa-xuan.jpg',
		'image_alt' => 'Sơ đồ mặt bằng chức năng Trường Tiểu học Hòa Xuân: khối lớp học, hành chính, bể bơi, sân chào cờ, cổng phía đường Lê Sỹ',
		'content'  => <<<HTML
<p>Khu đô thị sinh thái Hòa Xuân sắp có thêm một <strong>trường tiểu học công lập</strong>. Theo thông tin đang được chia sẻ, dự án <strong>Trường Tiểu học Hòa Xuân</strong> được phê duyệt chủ trương đầu tư tháng 9/2026, trên khu đất <strong>13.655 m²</strong> có ba mặt tiếp giáp các đường <strong>Lê Sỹ, Cồn Dầu 18 và Đỗ Quỳ</strong>. Phương án kiến trúc giới thiệu các khối lớp học bao quanh sân trường, khu thể thao và mảng xanh lớn.</p>
<!--hh-featured-->
<h2>Thông tin dự án</h2>
<table>
<tbody>
<tr><th>Tên dự án</th><td>Trường Tiểu học Hòa Xuân (công lập)</td></tr>
<tr><th>Vị trí</th><td>Khu đô thị sinh thái Hòa Xuân, phường Hòa Xuân (Cẩm Lệ cũ), Đà Nẵng</td></tr>
<tr><th>Diện tích đất</th><td>13.655 m²</td></tr>
<tr><th>Tiếp giáp</th><td>Đường Lê Sỹ, Cồn Dầu 18, Đỗ Quỳ</td></tr>
<tr><th>Chủ trương đầu tư</th><td>Phê duyệt tháng 9/2026 (theo thông tin đang chia sẻ)</td></tr>
</tbody>
</table>
<p>Đến ngày đăng bài, Hoàng Hiệp chưa thấy báo chí đăng số quyết định, tổng mức đầu tư và thời gian thi công – bài sẽ cập nhật khi có văn bản chính thức.</p>
<h2>Thiết kế: khối lớp 4 tầng, bể bơi, sân chào cờ trung tâm</h2>
<p>Theo bản vẽ quy hoạch tổng mặt bằng và phối cảnh đang được chia sẻ, trường bố trí:</p>
<ul>
<li><strong>Khối lớp học</strong> 4 tầng hình chữ L, mái lắp pin năng lượng mặt trời, sân thượng trồng cây.</li>
<li><strong>Khối phục vụ học tập</strong> và <strong>khối hành chính quản trị</strong> riêng.</li>
<li><strong>Bể bơi</strong> trong nhà thi đấu mái vòm – tiện ích hiếm ở trường tiểu học công lập.</li>
<li><strong>Sân chào cờ</strong> bậc cấp nhiều màu ở trung tâm, sân khấu, vườn dạo cây xanh và <strong>vườn thực nghiệm</strong> cho học sinh.</li>
<li>Cổng chính và <strong>vịnh dừng đón/trả học sinh</strong> phía đường Lê Sỹ, tách lối vào cho giáo viên, học sinh và lối xe kỹ thuật, nhà để xe, nhà bảo vệ, trạm biến áp.</li>
</ul>
<h2>Vị trí trên bản đồ</h2>
<p>Khu đất hiện là bãi đất trống trong lõi khu dân cư Cồn Dầu, được bao bởi các tuyến Lê Sỹ, Đỗ Quỳ và Cồn Dầu 18; xung quanh là các đường Cồn Dầu 12, 16, 17, 19 và Lê Quang Chi, phía Bắc có công viên cây xanh với lối dạo vòng tròn. Từ đây ra đường Hoàng Thế Thiện và sông Cẩm Lệ chỉ vài phút. Phía Tây Nam khu đất còn một phần đất trống chưa xây dựng.</p>
<h2>Nằm trong đề án trường lớp 2026 – 2030</h2>
<p>HĐND thành phố đã thông qua đề án đầu tư trường lớp mầm non và phổ thông công lập giai đoạn 2026 – 2030 với tổng kinh phí gần <strong>28.500 tỷ đồng</strong> (VOV), ưu tiên các khu đô thị mới đông dân. Cùng khu vực, thành phố đã phê duyệt chủ trương đầu tư <strong>hạ tầng Khu liên hợp thể dục thể thao Hòa Xuân</strong>, tổng mức hơn 233,7 tỷ đồng, thực hiện 2025 – 2029.</p>
<h2>Ý nghĩa với cư dân và nhà đất Hòa Xuân</h2>
<ul>
<li><strong>Gia đình trẻ</strong>: trường công lập ngay trong khu giúp con đi học gần, giảm áp lực tuyển sinh ở các trường cũ.</li>
<li><strong>Nhà phố, đất nền quanh trường</strong> (các tuyến Lê Sỹ, Đỗ Quỳ, Cồn Dầu): thuận lợi ở thật và kinh doanh dịch vụ phục vụ phụ huynh, học sinh. Ngược lại, lô sát cổng trường có thể ồn và kẹt xe giờ đưa đón.</li>
<li><strong>Tiện ích xã hội hoàn thiện dần</strong> là yếu tố giữ giá dài hạn cho khu đô thị mới, bên cạnh hạ tầng giao thông và cảnh quan ven sông Cẩm Lệ.</li>
</ul>
<h2>Dự án quanh khu vực</h2>
<p>Xem thông tin <a href="/du-an/kdt-sinh-thai-hoa-xuan/">Khu đô thị sinh thái Hòa Xuân</a>, phân khu <a href="/du-an/dat-nen-con-dau-hoa-xuan/">đất nền Cồn Dầu Hòa Xuân</a> và <a href="/du-an/euro-village-2/">Euro Village 2</a> ven sông.</p>
<p>Cần tìm lô đất, nhà phố gần trường hoặc kiểm tra quy hoạch một lô ở Hòa Xuân, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Trường tiểu học Hòa Xuân: 13.655 m², KĐT sinh thái',
			'desc'      => 'Trường Tiểu học Hòa Xuân công lập trong Khu đô thị sinh thái Hòa Xuân: khu đất 13.655 m², 3 mặt tiền Lê Sỹ, Cồn Dầu 18, Đỗ Quỳ. Tác động tới nhà đất.',
			'points'    => array(
				'Khu đất 13.655 m², ba mặt tiền Lê Sỹ – Cồn Dầu 18 – Đỗ Quỳ',
				'Chủ trương đầu tư phê duyệt 9/2026 (theo thông tin đang chia sẻ)',
				'Nằm trong đề án trường lớp công lập 2026 – 2030 gần 28.500 tỷ đồng',
			),
			'faq'       => array(
				array( 'Trường Tiểu học Hòa Xuân mới xây ở đâu?', 'Trong Khu đô thị sinh thái Hòa Xuân, trên khu đất 13.655 m² giáp ba đường Lê Sỹ, Cồn Dầu 18 và Đỗ Quỳ.' ),
				array( 'Khi nào xây Trường Tiểu học Hòa Xuân?', 'Chủ trương đầu tư được phê duyệt tháng 9/2026 theo thông tin đang chia sẻ; thời gian thi công chờ quyết định đầu tư chính thức.' ),
			),
		),
		'sources'  => array(
			'https://vov.vn/xa-hoi/da-nang-dau-tu-gan-28500-ty-dong-xay-dung-nang-cap-truong-hoc-thiet-bi-day-hoc-post1320232.vov',
			'https://danang.gov.vn/vi/w/chi-dao-ieu-hanh-noi-bat-cua-ubnd-thanh-pho-chu-tich-ubnd-thanh-pho-ngay-29-5',
		),
	);

	/* ---------------- 27/10 – Giá đất Nam Việt Á ---------------- */
	$posts[] = array(
		'slug'     => 'gia-dat-nam-viet-a-da-nang-10-2026',
		'title'    => 'Giá đất Nam Việt Á Đà Nẵng tháng 10/2026: lô ống, biệt thự, lô góc theo từng tuyến đường',
		'excerpt'  => 'Bảng giá đất Nam Việt Á (KĐT sinh thái Nam cầu Tuyên Sơn) 10/2026: lô ống 7,35 – 12 tỷ (77 – 120 triệu/m²), biệt thự 84 – 102 triệu/m², Chương Dương ven sông tới 193 triệu/m², lô góc 22 – 27,5 tỷ.',
		'keyword'  => 'giá đất Nam Việt Á',
		'keywords_extra' => array( 'đất Nam Việt Á', 'khu đô thị Nam Việt Á', 'biệt thự Nam Việt Á', 'Nam cầu Tuyên Sơn' ),
		'project'  => 'khu-do-thi-nam-viet-a',
		'schedule' => '2026-10-27 11:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Nam Việt Á', 'Đất nền Đà Nẵng', 'Ngũ Hành Sơn' ),
		'image'    => 'plugin:img/tin-tuc/gia-dat-nam-viet-a-10-2026.jpg',
		'image_alt' => 'Biểu đồ giá chào bán mỗi m² đất Nam Việt Á theo lô ống, biệt thự, lô góc tháng 10/2026',
		'content'  => <<<HTML
<p><strong>Giá đất Nam Việt Á</strong> tháng 10/2026 chênh nhau rất rõ theo loại lô và tuyến đường. Hoàng Hiệp tổng hợp các lô đang chào bán tại <a href="/du-an/khu-do-thi-nam-viet-a/">Khu đô thị Nam Việt Á</a> (Khu đô thị sinh thái Nam cầu Tuyên Sơn, Ngũ Hành Sơn) và tính giá mỗi m² để anh chị dễ so sánh.</p>
<!--hh-featured-->
<h2>Tóm tắt giá đất Nam Việt Á 10/2026</h2>
<table>
<thead><tr><th>Loại lô</th><th>Diện tích phổ biến</th><th>Giá chào bán</th><th>Khoảng giá/m²</th></tr></thead>
<tbody>
<tr><td>Lô ống (liền kề)</td><td>90 – 110 m²</td><td>7,35 – 12 tỷ</td><td>77 – 120 triệu</td></tr>
<tr><td>Đất biệt thự trong khu</td><td>182 – 334 m²</td><td>16 – 32 tỷ</td><td>84 – 102 triệu</td></tr>
<tr><td>Biệt thự mặt tiền Chương Dương</td><td>300 – 600 m²</td><td>58 – 100 tỷ</td><td>167 – 193 triệu</td></tr>
<tr><td>Lô góc</td><td>170 – 257 m²</td><td>22 – 27,5 tỷ</td><td>92 – 141 triệu</td></tr>
</tbody>
</table>
<h2>Lô ống: rẻ nhất Tuy Lý Vương, đắt nhất Trần Hữu Độ</h2>
<p>Nhóm dưới 8,5 tỷ gồm Tuy Lý Vương 95 m² (7,35 tỷ, sát góc), Nguyễn Thế Kỷ 95 m² (7,5 tỷ), Nước Mặn 5 95 m² (7,x tỷ, đối diện dãy biệt thự), Trịnh Lỗi 100 m² (8 tỷ, gần đường điện), Trương Công Hy 105 m² (8,5 tỷ, có thương lượng). Nhóm trên 9 tỷ: Mỹ Đa Tây 4 view công viên, Đoàn Khuê, Nghiêm Xuân Yêm, Lê Hy Cát 100 m² (10,2 tỷ) và Trần Hữu Độ 100 m² (12 tỷ – khoảng 120 triệu/m²).</p>
<h2>Đất biệt thự: Chương Dương ven sông gấp đôi trong khu</h2>
<p>Đất biệt thự trong khu như Nước Mặn 1 (182,5 m², 16 tỷ), Nghiêm Xuân Yêm (285 m², 24 tỷ), Bùi Tá Hán (250 m², 25,5 tỷ), Anh Thơ (300 m², 29 tỷ), Trần Trọng Khiêm (334 m², 32 tỷ) dao động khoảng 84 – 102 triệu/m². Mặt tiền <strong>Chương Dương</strong> nhìn sông là hàng hiếm: 300 m² chào 58 tỷ, 600 m² chào 100 tỷ – khoảng 167 – 193 triệu/m².</p>
<h2>Lô góc: 22 – 27,5 tỷ</h2>
<p>Góc Đoàn Khuê – Phạm Tuấn Tài 177 m² đường 11,5 m chào 25 tỷ (có thương lượng, khoảng 141 triệu/m²); góc Lê Văn Thủ – Mỹ Đa Tây 6 170 m² khoảng 22,x tỷ; góc K20 – Nước Mặn 2 241 m² 27,5 tỷ; góc Dương Tử Giang – Đa Phước 8 249 m² 23 tỷ.</p>
<h2>Đọc giá cho đúng</h2>
<ul>
<li>Đây là <strong>giá chào bán</strong>, giá chốt thường thấp hơn sau thương lượng; mặt bằng tin rao trên các sàn cùng thời điểm khoảng 93 – 138 triệu/m².</li>
<li>Cùng tuyến nhưng khác hướng, khác chiều rộng đường hoặc gần đường điện có thể chênh vài trăm triệu tới hàng tỷ.</li>
<li>Kiểm tra sổ, chỉ giới, mật độ xây dựng cho phép (lô biệt thự khác lô liền kề) trước khi đặt cọc.</li>
</ul>
<p>So sánh thêm khu ven biển cùng quận: <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>. Cần danh sách lô kèm sổ và vị trí, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá đất Nam Việt Á 10/2026: lô ống, biệt thự, lô góc',
			'desc'      => 'Giá đất Nam Việt Á 10/2026: lô ống 7,35 – 12 tỷ (77 – 120 triệu/m²), biệt thự 84 – 102 triệu/m², Chương Dương tới 193 triệu/m², lô góc 22 – 27,5 tỷ.',
			'points'    => array(
				'Lô ống 90 – 110 m²: 7,35 – 12 tỷ (77 – 120 triệu/m²)',
				'Đất biệt thự 84 – 102 triệu/m²; mặt tiền Chương Dương 167 – 193 triệu/m²',
				'Lô góc 170 – 257 m²: 22 – 27,5 tỷ',
			),
			'faq'       => array(
				array( 'Giá đất Nam Việt Á bao nhiêu một m²?', 'Chào bán 10/2026: lô ống khoảng 77 – 120 triệu/m², đất biệt thự 84 – 102 triệu/m², mặt tiền Chương Dương ven sông 167 – 193 triệu/m², lô góc 92 – 141 triệu/m².' ),
				array( 'Lô ống Nam Việt Á rẻ nhất bao nhiêu?', 'Trong danh sách 10/2026, Tuy Lý Vương 95 m² chào 7,35 tỷ và Nguyễn Thế Kỷ 95 m² chào 7,5 tỷ là nhóm thấp nhất.' ),
			),
		),
		'sources'  => array( 'https://guland.vn/du-an/khu-do-thi-nam-viet-a-da-nang' ),
	);

	return $posts;
}
