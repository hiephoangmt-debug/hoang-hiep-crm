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
		'rev'      => 3, // 22/10: thêm phần mặt cắt, quỹ đất.
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
<!--hh-img:img/sun-saphia/sun-saphia-so-do-vi-tri.jpg|Sơ đồ vị trí Sun Saphia Residence – biển Sơn Thủy, đường Trường Sa (Hoàng Hiệp vẽ minh hoạ)-->
<h2>Quy mô và vốn đầu tư</h2>
<ul>
<li><strong>Giai đoạn đầu</strong>: thông tuyến 4 – 6 làn xe; khi lưu lượng lớn sẽ đầu tư đồng bộ toàn mặt cắt.</li>
<li>Theo Sở Xây dựng Đà Nẵng: nếu giải tỏa đủ <strong>mặt cắt 138 m</strong> và làm trước mỗi bên 3 làn, vốn gần <strong>15.000 tỷ đồng</strong>; nếu thu hồi thêm 100 m hai bên để khai thác quỹ đất, tổng mức đầu tư hơn <strong>30.800 tỷ đồng</strong>.</li>
<li>Thành phố cân nhắc hai hình thức: đầu tư công hoặc hợp tác công tư (PPP).</li>
</ul>
<p>Một số trang cộng đồng đang chia sẻ phương án chi tiết hơn: đoạn Hồ Xuân Hương – Phạm Như Xương giữ mặt cắt hiện trạng 48 m (đường chính 4 làn, đường gom mỗi bên 2 làn, dành dải giữa cho đường sắt đô thị), đoạn Phạm Như Xương – cầu Diêm Trà (xã Tam Anh) mặt cắt 138 m với 8 – 10 làn cao tốc, đoạn cầu Diêm Trà – sân bay Chu Lai 66 – 75 m, toàn tuyến 17 nút giao. Đến ngày đăng bài, Hoàng Hiệp chưa thấy văn bản chính thức công bố các số liệu này – xem như thông tin tham khảo.</p>
<!--hh-img:img/sun-saphia/sun-saphia-ban-do-ket-noi.jpg|Bản đồ kết nối Sun Saphia Residence với trung tâm Đà Nẵng, sân bay, Hội An (tài liệu chủ đầu tư)-->
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
		'project'  => 'sun-neo-city',
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
<p>Xem thông tin <a href="/du-an/sun-neo-city/">Sun NeO City (Khu đô thị sinh thái Hòa Xuân)</a>, phân khu <a href="/du-an/dat-nen-con-dau-hoa-xuan/">đất nền Cồn Dầu Hòa Xuân</a> và <a href="/du-an/euro-village-2/">Euro Village 2</a> ven sông.</p>
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

	/* ---------------- 05/11 – Chính sách FourS F2 từ 17/10/2026 (anh Hiệp gửi) ---------------- */
	$posts[] = array(
		'slug'     => 'chinh-sach-fours-tower-f2-17-10-2026-qua-noi-that-nha-xinh',
		'title'    => 'Chính sách FourS Tower F2 từ 17/10/2026: tặng nội thất Nhà Xinh đến 100 triệu, chiết khấu thanh toán sớm đến 12%',
		'excerpt'  => 'Sun FourS Tower Tòa F2 cập nhật CSBH 4.2 từ 17/10/2026: quà nội thất Nhà Xinh 35 – 100 triệu trừ vào giá bán, không vay chiết khấu 3%, thanh toán sớm 95% / 70% / 50% chiết khấu 12% / 5% / 2,5%.',
		'keyword'  => 'chính sách FourS Tower F2',
		'keywords_extra' => array( 'FourS Tower F2', 'Tháp Mai FourS', 'Sun FourS Tower', 'nội thất Nhà Xinh', 'CSBH 4.2 FourS' ),
		'project'  => 'fours-tower-f2-thap-mai',
		'schedule' => '2026-11-05 12:00',
		'category' => 'Dự án',
		'tags'     => array( 'FourS Tower', 'Sun Group', 'Chính sách bán hàng' ),
		'image'    => 'plugin:img/tin-tuc/fours-f2-chinh-sach-17-10-2026.jpg',
		'image_alt' => 'Chính sách FourS Tower Tòa F2 từ 17/10/2026: quà nội thất Nhà Xinh 35 – 100 triệu và các mức chiết khấu',
		'content'  => <<<HTML
<p>Sun FourS Tower <strong>Tòa F2 – Tháp Mai</strong> cập nhật chính sách bán hàng (CSBH 4.2) áp dụng từ ngày <strong>17/10/2026</strong>. Điểm mới là <strong>gói quà tặng nội thất Nhà Xinh</strong> trừ thẳng vào giá bán, cộng dồn với các chiết khấu không vay và thanh toán sớm. Hoàng Hiệp tóm tắt theo phiếu tính giá của chủ đầu tư.</p>
<!--hh-featured-->
<h2>Quà tặng nội thất Nhà Xinh theo loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá trị quà (trừ vào giá bán chưa VAT)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>35 triệu đồng</td></tr>
<tr><td>1PN và 1PN+</td><td>50 triệu đồng</td></tr>
<tr><td>2PN</td><td>75 triệu đồng</td></tr>
<tr><td>3PN</td><td>100 triệu đồng</td></tr>
</tbody>
</table>
<h2>Các mức chiết khấu cộng thêm</h2>
<ul>
<li><strong>Không vay ngân hàng:</strong> chiết khấu 3%.</li>
<li><strong>Thanh toán sớm 95%:</strong> chiết khấu thêm 12%.</li>
<li><strong>Thanh toán sớm 70%:</strong> chiết khấu thêm 5%, nhận bàn giao sử dụng theo chính sách Sun Early Key rồi thanh toán phần còn lại.</li>
<li><strong>Thanh toán sớm 50%:</strong> chiết khấu thêm 2,5%.</li>
<li><strong>Vay ngân hàng:</strong> vẫn nhận quà Nhà Xinh, không áp dụng chiết khấu không vay 3%; ngân hàng giải ngân 70% sau khi ký hợp đồng mua bán.</li>
</ul>
<p>Các chiết khấu áp dụng lần lượt trên giá bán chưa VAT và kinh phí bảo trì. Chiết khấu thanh toán sớm áp dụng theo mốc thời hạn chủ đầu tư công bố từng đợt – anh chị liên hệ để được xác nhận thời hạn hiện hành trước khi chọn phương án.</p>
<h2>Ví dụ theo phiếu tính giá của chủ đầu tư</h2>
<p>Căn 1PN+ diện tích thông thủy 53 m², giá niêm yết khoảng 3,02 tỷ đồng (đã gồm VAT và kinh phí bảo trì):</p>
<table>
<thead><tr><th>Phương án</th><th>Ưu đãi áp dụng</th><th>Tổng thanh toán</th><th>Tiết kiệm so với niêm yết</th></tr></thead>
<tbody>
<tr><td>Thanh toán sớm 95%</td><td>Nhà Xinh + không vay 3% + 12%</td><td>khoảng 2,534 tỷ</td><td>khoảng 491 triệu (16,2%)</td></tr>
<tr><td>Thanh toán sớm 70%</td><td>Nhà Xinh + không vay 3% + 5%</td><td>khoảng 2,735 tỷ</td><td>khoảng 289 triệu (9,6%)</td></tr>
<tr><td>Thanh toán sớm 50%</td><td>Nhà Xinh + không vay 3% + 2,5%</td><td>khoảng 2,807 tỷ</td><td>khoảng 217 triệu (7,2%)</td></tr>
<tr><td>Tiến độ chuẩn, không vay</td><td>Nhà Xinh + không vay 3%</td><td>khoảng 2,879 tỷ</td><td>khoảng 145 triệu (4,8%)</td></tr>
<tr><td>Vay ngân hàng 70%</td><td>Nhà Xinh</td><td>khoảng 2,968 tỷ</td><td>khoảng 56 triệu (1,9%)</td></tr>
</tbody>
</table>
<p>Đặt cọc 100 triệu đồng (Studio, 1PN, 1PN+, 2PN) và 150 triệu đồng (3PN). Số liệu trên là ví dụ trong phiếu tính giá, giá từng căn khác nhau theo tầng, hướng và diện tích.</p>
<p><strong>Lưu ý:</strong> chính sách 17/10/2026 áp dụng cho các căn mở bán mới. Một số căn đã được nhận từ đợt trước vẫn giữ chính sách đợt 26/9/2026 (có Early Bird 3%). Hoàng Hiệp sẽ xác nhận chính sách áp dụng cho từng căn cụ thể khi anh chị chọn căn.</p>
<h2>Góc nhìn của Hoàng Hiệp</h2>
<p>So với đợt trước, quà nội thất Nhà Xinh giúp căn hộ có thể đưa vào sử dụng hoặc cho thuê sớm hơn mà không phải bỏ thêm nhiều chi phí hoàn thiện. Với người có sẵn dòng tiền, phương án thanh toán sớm vẫn là cách tiết kiệm nhiều nhất; người cần giữ tiền mặt có thể chọn vay 70% và vẫn nhận quà nội thất.</p>
<p>Xem thêm: <a href="/du-an/fours-tower-f2-thap-mai/">FourS Tower F2 – Tháp Mai</a> · <a href="/du-an/fours-tower/">tổng quan FourS Tower</a>. Cần phiếu tính giá theo đúng căn và phương án anh chị chọn, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: phiếu tính giá CSBH 4.2 Tòa F2 của chủ đầu tư, áp dụng từ 17/10/2026.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chính sách FourS F2 từ 17/10: quà Nhà Xinh đến 100tr',
			'desc'      => 'FourS Tower F2 CSBH 4.2 từ 17/10/2026: quà nội thất Nhà Xinh 35 – 100 triệu, không vay 3%, thanh toán sớm 95%/70%/50% chiết khấu 12%/5%/2,5%.',
			'points'    => array(
				'Quà nội thất Nhà Xinh: Studio 35 triệu, 1PN/1PN+ 50 triệu, 2PN 75 triệu, 3PN 100 triệu',
				'Không vay chiết khấu 3%; thanh toán sớm 95% / 70% / 50%: 12% / 5% / 2,5%',
				'Ví dụ căn 1PN+ niêm yết ~3,02 tỷ: thanh toán sớm 95% còn khoảng 2,534 tỷ',
			),
			'faq'       => array(
				array( 'Chính sách FourS Tower F2 từ 17/10/2026 có gì mới?', 'Tặng gói nội thất Nhà Xinh trừ vào giá bán: Studio 35 triệu, 1PN và 1PN+ 50 triệu, 2PN 75 triệu, 3PN 100 triệu; cộng dồn chiết khấu không vay 3% và thanh toán sớm.' ),
				array( 'Căn nào áp dụng chính sách 17/10/2026?', 'Chính sách 17/10/2026 áp dụng cho các căn mở bán mới; một số căn đã nhận từ đợt trước vẫn giữ chính sách đợt 26/9/2026. Chính sách áp dụng được xác nhận theo từng căn.' ),
				array( 'Vay ngân hàng có được quà Nhà Xinh không?', 'Có. Phương án vay vẫn nhận quà nội thất Nhà Xinh, chỉ không áp dụng chiết khấu không vay 3%.' ),
				array( 'Thanh toán sớm FourS F2 được chiết khấu bao nhiêu?', 'Thanh toán sớm 95% chiết khấu 12%, 70% chiết khấu 5%, 50% chiết khấu 2,5%, theo thời hạn chủ đầu tư công bố từng đợt.' ),
			),
		),
		'sources'  => array(),
	);


	/* ---------------- 06/11 – Hoiana Beach Villas (bộ tài liệu chủ đầu tư anh Hiệp gửi 05/11) ---------------- */
	$hbv     = '<a href="/du-an/hoiana-beach-villas/">Hoiana Beach Villas</a>';
	$posts[] = array(
		'slug'     => 'hoiana-beach-villas-7-dong-biet-thu-dien-tich-tien-ich',
		'title'    => 'Hoiana Beach Villas: 198 biệt thự biển Nam Hội An – 7 dòng biệt thự, diện tích, tiện ích và vị trí từng dòng',
		'excerpt'  => 'Hoiana Beach Villas có 198 biệt thự biển 3 – 9 phòng ngủ trong quần thể Hoiana Resort & Golf: Shore, Dune, Azure, Pearl, Marina Villa và 2 dinh thự Patina, Veranda. Diện tích đất 350 – 3.132 m², hồ bơi riêng, bàn giao full nội thất.',
		'keyword'  => 'Hoiana Beach Villas',
		'keywords_extra' => array( 'biệt thự biển Hoiana', 'Hoiana Resort & Golf', 'biệt thự biển Hội An', 'Marina Villa Hoiana', 'Dune Villa Hoiana' ),
		'project'  => 'hoiana-beach-villas',
		'schedule' => '2026-11-06 09:30',
		'category' => 'Dự án',
		'tags'     => array( 'Hoiana', 'Biệt thự biển', 'Hội An' ),
		'image_drive' => '1WFS7kd0OZyRm7Tal2kgj2mjQirYoHrr6', // Ảnh bìa: phối cảnh Marina Villa (ảnh dự án đã tải về web).
		'image'    => 'plugin:img/tin-tuc/hoiana-beach-villas-7-dong-biet-thu.jpg', // Dự phòng khi web chưa có ảnh dự án.
		'image_alt' => 'Phối cảnh Marina Villa – biệt thự 4 phòng ngủ trực diện biển, Hoiana Beach Villas',
		'image_caption' => 'Phối cảnh Marina Villa (loại F), Hoiana Beach Villas – ảnh chủ đầu tư',
		'content'  => <<<HTML
<p>{$hbv} là phân khu biệt thự biển của quần thể <a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a> tại Nam Hội An (Duy Xuyên, Quảng Nam cũ – nay thuộc TP. Đà Nẵng), cách phố cổ Hội An khoảng 15 phút. Phân khu gồm <strong>198 biệt thự 3 – 9 phòng ngủ</strong>, mỗi căn có hồ bơi riêng, garage riêng và bàn giao đầy đủ nội thất. Bài viết tổng hợp từ tài liệu thông tin dự án của chủ đầu tư (05/2026).</p>
<!--hh-featured-->
<h2>Chủ đầu tư và quần thể Hoiana</h2>
<p>Chủ đầu tư là <strong>Công ty TNHH Phát triển Nam Hội An (HASD)</strong>, thành lập năm 2010, 100% vốn nước ngoài, trong đó 75% cổ phần thuộc VMS Group (Hồng Kông); New World Development (Hồng Kông) là đối tác tham gia phát triển. Hoiana là khu nghỉ dưỡng tích hợp tổng vốn khoảng <strong>4 tỷ USD</strong> (đã giải ngân khoảng 1,4 tỷ USD), trải trên gần 1.000 ha với <strong>4 km bờ biển</strong>.</p>
<p>Tiện ích đã vận hành trong quần thể: hơn 1.200 phòng khách sạn, hơn 25 nhà hàng và beach club, 5 spa, 3 hồ bơi lớn, 8 sân pickleball, sân golf Hoiana Shores 18 hố (7.004 yards, par 71, clubhouse 6.000 m²) do Robert Trent Jones Jr. thiết kế, trung tâm giải trí (KTV, bowling, bi-a, golf giả lập, khu trẻ em) mở từ 02/2026.</p>
<!--hh-dimg:1hHYHOYbTciyVJ5pcJYsK6mUAVXdN5dOE|Phối cảnh Marina Villa (loại F) – biệt thự 4 phòng ngủ trực diện biển (ảnh chủ đầu tư)-->
<h2>7 dòng biệt thự Hoiana Beach Villas</h2>
<table>
<thead><tr><th>Dòng biệt thự</th><th>Phòng ngủ</th><th>Đất (m²)</th><th>Sàn (m²)</th><th>Vườn mở rộng (m²)</th><th>Số căn</th></tr></thead>
<tbody>
<tr><td>Shore Villa (loại A)</td><td>3</td><td>350</td><td>263</td><td>100</td><td>36</td></tr>
<tr><td>Dune Villa (loại C)</td><td>3</td><td>544</td><td>352</td><td>170</td><td>70</td></tr>
<tr><td>Azure Villa (loại D)</td><td>4</td><td>630</td><td>398</td><td>270</td><td>46</td></tr>
<tr><td>Pearl Villa (loại E)</td><td>4</td><td>702</td><td>478</td><td>270</td><td>21</td></tr>
<tr><td>Marina Villa (loại F)</td><td>4</td><td>840</td><td>553</td><td>400</td><td>23</td></tr>
<tr><td>Patina Mansion (loại B)</td><td>7</td><td>2.208</td><td>1.655</td><td>1.345</td><td>1</td></tr>
<tr><td>Veranda Mansion (loại G)</td><td>9</td><td>3.132</td><td>2.329</td><td>1.600</td><td>1</td></tr>
</tbody>
</table>
<p>Diện tích vườn mở rộng có thể thay đổi theo vị trí từng căn. Biệt thự cao tối đa 2 tầng.</p>
<h2>Vị trí từng dòng biệt thự</h2>
<ul>
<li><strong>Trực diện biển:</strong> Marina Villa, Patina Mansion và Veranda Mansion nằm dọc đường bờ biển riêng. Patina (7 phòng ngủ, gần 20 không gian chức năng, hồ bơi vô cực riêng) và Veranda (9 phòng ngủ, căn góc nhìn biển và sân golf, duy nhất có tầng mái rooftop) là hai dinh thự độc bản.</li>
<li><strong>Lùi phía sau, giữa vườn:</strong> Dune Villa và Azure Villa – không gian yên tĩnh giữa các khu vườn riêng.</li>
<li><strong>Kế biển, giáp sân golf:</strong> Pearl Villa, tầm nhìn hướng biển và thảm cỏ sân golf.</li>
<li><strong>Giữa mảng xanh nội khu:</strong> Shore Villa – dòng có mức giá tiếp cận tốt nhất.</li>
</ul>
<!--hh-dimg:1nqByEUObXTmBT82wWzPW6030AesKSUly|Sân vườn sau và hồ bơi riêng Azure Villa (loại D) (ảnh chủ đầu tư)-->
<!--hh-dimg:1DqIQXSNcuPYHfagIFaDg-gYumDWW2iJw|Phối cảnh Dune Villa (loại C) – biệt thự 3 phòng ngủ giữa vườn (ảnh chủ đầu tư)-->
<h2>Thiết kế: nhiệt đới đương đại, cảm hứng Hội An</h2>
<p>Kiến trúc theo phong cách nhiệt đới đương đại, lấy cảm hứng từ di sản Hội An và Chùa Cầu: các không gian sinh hoạt nối liền, mở ra vườn và hồ bơi. Nội thất tối giản với gỗ, đá tự nhiên, bề mặt đan thủ công và bảng màu trung tính. Cảnh quan theo ý tưởng năm giác quan – vườn hương liệu, cây bản địa, mặt nước và lối dạo.</p>
<!--hh-dimg:1TDX1HxC-PagWaNpcE67ID691Z8ZaXDtB|Phòng khách Azure Villa (loại D) (ảnh chủ đầu tư)-->
<!--hh-dimg:16CMsBN0-9IqWtqUBkFRsQrZ_P__j-Hxz|Sảnh vào nhìn ra hồ bơi riêng – Azure Villa (loại D) (ảnh chủ đầu tư)-->
<h2>Tiện ích riêng của phân khu</h2>
<ul>
<li>Hồ bơi riêng và garage riêng trong từng biệt thự.</li>
<li>Beach club với hồ bơi vô cực dọc bờ biển, nhà hàng The Garden.</li>
<li>Trung tâm chăm sóc sức khỏe: gym, yoga, spa; Kid's club.</li>
<li>Sảnh đón, lối vào riêng; concierge và an ninh 24/7; đơn vị vận hành chuyên nghiệp.</li>
<li>Cư dân dùng toàn bộ tiện ích của Hoiana Resort &amp; Golf: sân golf, nhà hàng, giải trí, chăm sóc sức khỏe.</li>
</ul>
<!--hh-dimg:1Ei1XH_OJtqdO36Pc4Jc8m-R5JTQILKZM|Marina Villa (loại F) – góc phối cảnh khác (ảnh chủ đầu tư)-->
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Hoiana Beach Villas phù hợp khách mua biệt thự biển để nghỉ dưỡng và cho thuê trong một quần thể đã vận hành thật – khách sạn, golf, nhà hàng, beach club đều đang hoạt động, không phải chờ tiện ích hình thành. Số lượng chỉ 198 căn, mật độ xây dựng thấp, mỗi căn có hồ bơi và vườn riêng. Khi chọn căn, anh chị nên cân nhắc giữa nhóm trực diện biển (Marina) và nhóm giữa vườn (Dune, Azure) theo ngân sách và nhu cầu khai thác; hỏi kỹ phương án vận hành cho thuê, phí quản lý và tiến độ bàn giao trước khi xuống tiền.</p>
<p>Xem thêm ảnh phối cảnh, bảng loại căn tại <a href="/du-an/hoiana-beach-villas/">trang dự án Hoiana Beach Villas</a>. Nhận bảng giá, chính sách và hồ sơ dự án: <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: tài liệu thông tin dự án Hoiana Beach Villas của chủ đầu tư (05/2026), hoiana.com. Ảnh: phối cảnh của chủ đầu tư, mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hoiana Beach Villas: 7 dòng biệt thự biển, diện tích',
			'desc'      => 'Hoiana Beach Villas – 198 biệt thự biển Nam Hội An, 3 – 9 phòng ngủ, đất 350 – 3.132 m², hồ bơi riêng, full nội thất. Vị trí từng dòng, tiện ích. Gọi Hoàng Hiệp.',
			'points'    => array(
				'198 biệt thự 3 – 9 phòng ngủ: Shore, Dune, Azure, Pearl, Marina Villa, Patina và Veranda Mansion',
				'Đất 350 – 3.132 m², mỗi căn có hồ bơi riêng, garage riêng, bàn giao full nội thất',
				'Nằm trong Hoiana Resort & Golf gần 1.000 ha, 4 km bờ biển, cách phố cổ Hội An khoảng 15 phút',
			),
			'faq'       => array(
				array( 'Hoiana Beach Villas có bao nhiêu căn?', '198 biệt thự: Shore Villa 36 căn, Dune Villa 70, Azure Villa 46, Pearl Villa 21, Marina Villa 23, Patina Mansion 1 và Veranda Mansion 1.' ),
				array( 'Diện tích biệt thự Hoiana Beach Villas bao nhiêu?', 'Đất từ 350 m² (Shore Villa, 3 phòng ngủ) đến 840 m² (Marina Villa, 4 phòng ngủ); hai dinh thự Patina 2.208 m² và Veranda 3.132 m².' ),
				array( 'Dòng nào trực diện biển?', 'Marina Villa, Patina Mansion và Veranda Mansion nằm dọc bờ biển; Pearl Villa kế biển, giáp sân golf.' ),
				array( 'Ai là chủ đầu tư Hoiana Beach Villas?', 'Công ty TNHH Phát triển Nam Hội An (HASD), 100% vốn nước ngoài, 75% cổ phần thuộc VMS Group (Hồng Kông).' ),
			),
		),
		'sources'  => array( 'https://www.hoiana.com/hoiana-beach-villas' ),
	);

	/* ---------------- 09/11 – Mặt bằng giá căn hộ Đà Nẵng: bảng hàng CĐT + giá rao + Biggee.vn ---------------- */
	$posts[] = array(
		'slug'     => 'mat-bang-gia-can-ho-da-nang-11-2026',
		'title'    => 'Mặt bằng giá căn hộ Đà Nẵng 11/2026: từ 21 đến gần 190 triệu/m² – bảng giá 30 dự án',
		'excerpt'  => 'Bảng giá căn hộ 30 dự án Đà Nẵng theo triệu/m²: bảng hàng chủ đầu tư The Legend 119 – 188, Capital Square 92 – 146, Newtown Diamond 67 – 120; dự án Sun từ FourS 45 – 68 đến Sun Solar 117 – 178; Liên Chiểu dưới 40 triệu/m².',
		'keyword'  => 'mặt bằng giá căn hộ Đà Nẵng',
		'keywords_extra' => array( 'giá căn hộ Đà Nẵng 2026', 'giá căn hộ Đà Nẵng theo m2', 'bảng giá chung cư Đà Nẵng', 'căn hộ ven sông Hàn giá bao nhiêu' ),
		'schedule' => '2026-11-09 14:00',
		'category' => 'Thị trường',
		'tags'     => array( 'Giá căn hộ', 'Thị trường Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/mat-bang-gia-can-ho-da-nang-11-2026.jpg',
		'image_alt' => 'Biểu đồ khoảng giá căn hộ 27 dự án Đà Nẵng theo triệu/m², tháng 11/2026',
		'content'  => <<<HTML
<p>Giá căn hộ Đà Nẵng tháng 11/2026 trải từ khoảng <strong>21 triệu/m²</strong> (nhà ở xã hội Liên Chiểu) đến gần <strong>190 triệu/m²</strong> (căn hộ hạng sang ven sông Hàn). Hoàng Hiệp tổng hợp từ 3 nguồn, ưu tiên theo thứ tự: <strong>bảng hàng / bảng giá chủ đầu tư</strong> mới nhất, <strong>giá rao thứ cấp</strong> tháng 7 – 10/2026, và <strong>bản đồ giá Biggee.vn</strong> cho các dự án còn lại.</p>
<!--hh-featured-->
<h2>Bảng giá căn hộ Đà Nẵng theo dự án (triệu/m² thông thủy)</h2>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Giá (tr/m²)</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/the-legend-da-nang/">The Legend</a></td><td>Ven sông Hàn, Hải Châu</td><td>119 – 188</td><td>Bảng hàng CĐT 09/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square</a></td><td>Võ Nguyên Giáp, Sơn Trà</td><td>150 – 181</td><td>Bảng giá tầng 5 – 15</td></tr>
<tr><td><a href="/du-an/sun-solar-residence/">Sun Solar</a></td><td>Ven sông Hàn, Sơn Trà</td><td>117 – 178</td><td>Bảng hàng quỹ đại lý tầng 7 – 19</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Residences</a></td><td>Võ Nguyên Giáp, Sơn Trà</td><td>151 – 171</td><td>Giá rao 7 – 10/2026</td></tr>
<tr><td><a href="/du-an/capital-square-da-nang/">Capital Square</a></td><td>Ven sông Hàn, Sơn Trà</td><td>92 – 146</td><td>Bảng hàng CĐT 09/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/the-poet-residence-da-nang/">The Poet</a></td><td>Ven sông Hàn, Sơn Trà</td><td>92 – 139</td><td>Bảng hàng CĐT 01/09/2026, gồm VAT</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo</a></td><td>Ven sông Hàn, Ngũ Hành Sơn</td><td>83 – 130</td><td>Giá rao (ít tin)</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte</a></td><td>Cầu Rồng, Sơn Trà</td><td>83 – 130</td><td>Giá rao 7 – 10/2026</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a></td><td>Biển Mỹ Khê, Sơn Trà</td><td>74 – 130</td><td>Giá rao 7 – 10/2026</td></tr>
<tr><td><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a></td><td>Biển Ngũ Hành Sơn</td><td>67 – 120</td><td>Bảng hàng CĐT 09/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony</a></td><td>Ven sông Hàn, Sơn Trà</td><td>60 – 120</td><td>Giá rao trên sàn 21/10/2026</td></tr>
<tr><td><a href="/du-an/sun-costa-residence/">Sun Costa</a></td><td>Biển Mỹ Khê, Sơn Trà</td><td>70 – 105</td><td>Giá rao 7 – 10/2026</td></tr>
<tr><td><a href="/du-an/the-meridian-da-nang/">The Meridian</a></td><td>Hải Châu – Hòa Cường</td><td>86 – 89</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula</a></td><td>Ven sông Hàn, Sơn Trà</td><td>75 – 83</td><td>Niêm yết CĐT 25/07/2026</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a></td><td>Hòa Xuân, Cẩm Lệ</td><td>59 – 83</td><td>Bảng hàng 10/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a></td><td>Hòa Xuân, Cẩm Lệ</td><td>65 – 73</td><td>Bảng hàng 10/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/the-monarchy-da-nang/">The Monarchy</a></td><td>Ven sông Hàn, Sơn Trà</td><td>59 – 70</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/s-light-tower/">S-Light Tower</a></td><td>Hòa Xuân, Cẩm Lệ</td><td>58 – 69</td><td>Bảng hàng 10/2026, gồm VAT &amp; KPBT</td></tr>
<tr><td><a href="/du-an/regal-complex-da-nang/">Regal Complex</a></td><td>Khu Nam, Ngũ Hành Sơn</td><td>62 – 68</td><td>Biggee.vn</td></tr>
<tr><td>F.Home Apartment</td><td>Hải Châu</td><td>63 – 66</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/muong-thanh-luxury-da-nang-can-ho/">Chung cư Mường Thanh</a></td><td>Biển Võ Nguyên Giáp</td><td>60 – 64</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/ariyana-beach-resort-suites-da-nang/">Furama Condotel</a></td><td>Biển Ngũ Hành Sơn</td><td>59 – 155</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/fours-tower/">FourS Tower</a></td><td>Sun Riverpolis, Ngũ Hành Sơn</td><td>45 – 68</td><td>Giá rao 7 – 10/2026</td></tr>
<tr><td><a href="/du-an/fpt-plaza-4/">FPT Plaza 4</a></td><td>FPT City, Ngũ Hành Sơn</td><td>56 – 58</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/mia-center-point-da-nang/">MIA Center Point</a></td><td>Hòa Khánh, Liên Chiểu</td><td>48 – 57</td><td>Giỏ hàng CĐT 1/2026, gồm VAT</td></tr>
<tr><td><a href="/du-an/fpt-plaza-3/">FPT Plaza 3</a></td><td>FPT City, Ngũ Hành Sơn</td><td>51 – 55</td><td>Biggee.vn</td></tr>
<tr><td>Blue House</td><td>Sơn Trà</td><td>45 – 48</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/fpt-plaza-2/">FPT Plaza 2</a></td><td>FPT City, Ngũ Hành Sơn</td><td>45 – 46</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/hoa-binh-green-da-nang/">Hòa Bình Green</a></td><td>Sơn Trà</td><td>35 – 45</td><td>Biggee.vn</td></tr>
<tr><td>Hoàng Anh Gia Lai</td><td>Thanh Khê</td><td>34 – 39</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/the-ori-garden/">The Ori Garden</a></td><td>Liên Chiểu</td><td>35 – 37</td><td>Biggee.vn</td></tr>
<tr><td><a href="/du-an/ecohome-hoa-hiep-da-nang/">Ecohome Hòa Hiệp</a></td><td>Liên Chiểu</td><td>21 – 35</td><td>Biggee.vn</td></tr>
</tbody>
</table>
<p><strong>Cách đọc bảng:</strong> giá bảng hàng chủ đầu tư là giá niêm yết (gồm VAT, phần lớn gồm 2% kinh phí bảo trì), chưa trừ chiết khấu – giá thực trả sau chính sách thường thấp hơn. Giá rao thứ cấp là giá người bán đưa ra, chưa phải giá giao dịch. Sun Saphia Residence đang chờ chủ đầu tư công bố giá nên chưa có trong bảng.</p>
<!--hh-img:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg|Ảnh thực tế flycam 11/2026: sông Hàn – cầu Rồng, khu vực có giá căn hộ cao nhất Đà Nẵng-->
<h2>Giá chia theo 5 nhóm</h2>
<ul>
<li><strong>Trên 100 triệu/m²:</strong> căn hộ hạng sang ven sông Hàn và trục Võ Nguyên Giáp – The Legend, Times Square, Nobu, Sun Solar, phần căn cao cấp của Capital Square, The Poet, Sun Ponte, Sun Cosmo.</li>
<li><strong>80 – 100 triệu/m²:</strong> phần lớn căn của Newtown Diamond, Sun Symphony, Sun Costa, Wyndham Soleil, The Meridian.</li>
<li><strong>60 – 80 triệu/m²:</strong> Hòa Xuân (Cora, Spana, S-Light), Peninsula, The Monarchy, Regal Complex.</li>
<li><strong>40 – 60 triệu/m²:</strong> FourS Tower, FPT City, MIA Center Point, một số chung cư Sơn Trà.</li>
<li><strong>Dưới 40 triệu/m²:</strong> Liên Chiểu, Thanh Khê và nhà ở xã hội.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Sun Group có hàng ở mọi tầm giá:</strong> từ FourS Tower 45 – 68 triệu/m², Hòa Xuân 58 – 83, đến Sun Ponte, Sun Cosmo, Sun Solar trên 100 triệu/m² – anh chị có thể chọn theo ngân sách mà vẫn cùng một chủ đầu tư.</li>
<li><strong>Ven sông Hàn tiếp tục kéo giá lên:</strong> bảng hàng mới của The Legend, Capital Square đều có căn trên 140 triệu/m², cao hơn rõ so với mặt bằng rao bán 6 – 12 tháng trước.</li>
<li><strong>So cùng loại giá:</strong> giá chủ đầu tư (chưa chiết khấu) nên so với giá chủ đầu tư; giá rao chuyển nhượng so với giá rao. Chênh 10 – 20 triệu/m² trong cùng dự án thường do tầng, view, nội thất.</li>
</ul>
<p>Anh chị cần bảng hàng chi tiết đúng tầm giá, hoặc so sánh 2 – 3 dự án cụ thể, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: bảng hàng chủ đầu tư The Legend, Capital Square, Newtown Diamond (cập nhật 09/2026), bảng hàng / bảng giá các dự án Sun Group, The Poet, Times Square, Peninsula, MIA Center Point mà Hoàng Hiệp đang theo dõi; giá rao thứ cấp trên Batdongsan, Guland, Muaban, Cafeland, Thư viện Pháp luật (7 – 10/2026); bản đồ mặt bằng giá căn hộ Đà Nẵng của Biggee.vn (nhận 09/11/2026). Biểu đồ do Hoàng Hiệp vẽ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng giá căn hộ Đà Nẵng 11/2026: 30 dự án',
			'desc'      => 'Giá căn hộ Đà Nẵng 21 – 188 triệu/m²: bảng hàng CĐT The Legend, Capital Square, Newtown Diamond, các dự án Sun Group, Hòa Xuân, FPT City, Liên Chiểu.',
			'points'    => array(
				'Giá căn hộ Đà Nẵng khoảng 21 – 188 triệu/m² tùy khu vực và nguồn giá',
				'Bảng hàng CĐT 09/2026: The Legend 119 – 188, Capital Square 92 – 146, Newtown Diamond 67 – 120 triệu/m²',
				'Dự án Sun: FourS 45 – 68, Hòa Xuân 58 – 83, Sun Ponte, Sun Cosmo 83 – 130, Sun Solar 117 – 178 triệu/m²',
			),
			'faq'       => array(
				array( 'Giá căn hộ Đà Nẵng hiện bao nhiêu một m²?', 'Khoảng 21 – 188 triệu/m²: dưới 40 triệu ở Liên Chiểu và nhà ở xã hội, 45 – 83 triệu ở FourS, FPT City, Hòa Xuân, và từ 90 đến gần 190 triệu ven sông Hàn, trục Võ Nguyên Giáp.' ),
				array( 'Dự án căn hộ nào đắt nhất Đà Nẵng?', 'Theo bảng hàng chủ đầu tư 09/2026, The Legend ven sông Hàn ở mức 119 – 188 triệu/m²; Times Square, Nobu Residences và Sun Solar cũng trên 150 triệu/m² ở nhóm căn cao nhất.' ),
				array( 'Căn hộ Hòa Xuân giá bao nhiêu?', 'Theo bảng hàng 10/2026 (gồm VAT và phí bảo trì): Cora Tower 59 – 83, Spana Tower 65 – 73, S-Light Tower 58 – 69 triệu/m².' ),
			),
		),
		'sources'  => array( 'https://biggee.vn/' ),
	);

	/* ---------------- 11/11 18:30 – Sự kiện giới thiệu Sun Saphia Residence 15/11 ---------------- */
	$posts[] = array(
		'slug'     => 'su-kien-gioi-thieu-sun-saphia-residence-15-11-2026',
		'title'    => 'Sự kiện giới thiệu Sun Saphia Residence Chủ nhật 15/11/2026 tại Sun Gallery Đà Nẵng: chương trình, quà bốc thăm, đăng ký tham dự',
		'excerpt'  => 'Sự kiện giới thiệu dự án Sun Saphia Residence diễn ra 09:00 Chủ nhật 15/11/2026 tại Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu: giới thiệu Sun Group, dự án, tư vấn chuyên sâu và bốc thăm 5 phần quà. Chương trình chi tiết và cách đăng ký.',
		'keyword'  => 'sự kiện giới thiệu Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Sun Gallery Đà Nẵng', 'sự kiện Sun Saphia 15/11', 'Chất sống tinh hoa giao hòa nắng biển' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-11 18:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Sun Saphia Residence', 'Sự kiện dự án', 'Sun Group' ),
		'image'    => 'plugin:img/tin-tuc/su-kien-sun-saphia-15-11.jpg',
		'content'  => <<<HTML
<p>Chủ đầu tư tổ chức <strong>sự kiện giới thiệu Sun Saphia Residence</strong> với chủ đề <em>"Chất sống tinh hoa – Giao hòa nắng biển"</em> vào <strong>09:00 Chủ nhật 15/11/2026</strong> tại <strong>Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu, Hòa Cường</strong>. Đây là buổi đầu tiên khách hàng được nghe trực tiếp giới thiệu tổng thể về {$saphia} – dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng – trước sự kiện bán hàng dự kiến ngày 05/12/2026.</p>
<!--hh-featured-->
<h2>Thông tin sự kiện giới thiệu Sun Saphia Residence</h2>
<table>
<tbody>
<tr><th>Thời gian</th><td>08:30 – 11:00, Chủ nhật 15/11/2026 (khai mạc 09:00)</td></tr>
<tr><th>Địa điểm</th><td>Sun Gallery Đà Nẵng – 01 Phan Đăng Lưu, Hòa Cường, Đà Nẵng</td></tr>
<tr><th>Chủ đề</th><td>Chất sống tinh hoa – Giao hòa nắng biển</td></tr>
<tr><th>Nội dung chính</th><td>Giới thiệu Sun Group, giới thiệu dự án, tư vấn chuyên sâu, bốc thăm trúng thưởng</td></tr>
<tr><th>Đăng ký</th><td>Gọi/Zalo Hoàng Hiệp 0904 567 009 để giữ chỗ và nhận tài liệu trước</td></tr>
</tbody>
</table>
<h2>Chương trình chi tiết</h2>
<table>
<thead><tr><th>Giờ</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>08:30 – 09:00</td><td>Đón khách, tea break</td></tr>
<tr><td>09:00 – 09:15</td><td>Khai mạc</td></tr>
<tr><td>09:15 – 09:25</td><td>Giới thiệu về Tập đoàn Sun Group</td></tr>
<tr><td>09:25 – 10:15</td><td>Giới thiệu dự án Sun Saphia Residence</td></tr>
<tr><td>10:15 – 10:45</td><td>Tư vấn chuyên sâu</td></tr>
<tr><td>10:45 – 11:00</td><td>Bốc thăm trúng thưởng</td></tr>
<tr><td>11:00</td><td>Kết thúc</td></tr>
</tbody>
</table>
<!--hh-img:img/sun-saphia/sun-saphia-cdt-toa-thap-ngay.jpg|Phối cảnh tòa tháp Sun Saphia Residence 30 tầng bên biển Sơn Thủy (ảnh chủ đầu tư)-->
<h2>Quà bốc thăm may mắn cho khách tham dự</h2>
<ul>
<li><strong>01 giải Nhất:</strong> máy lọc không khí Sharp FP-J40E-W.</li>
<li><strong>02 giải Nhì:</strong> máy massage cổ Philips PPM3308.</li>
<li><strong>02 giải Ba:</strong> tai nghe Bluetooth chụp tai Sony WH-CH530.</li>
</ul>
<p>Quà dành cho khách tham dự sự kiện, bốc thăm lúc 10:45 – nên ở lại đến cuối chương trình.</p>
<h2>Sun Saphia Residence có gì để nghe tại sự kiện?</h2>
<p>Theo tài liệu chủ đầu tư đã công bố tới tháng 11/2026, đây là những thông tin chính anh chị sẽ được giới thiệu:</p>
<ul>
<li><strong>Vị trí:</strong> giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn; đối diện công viên, bãi tắm 2,45 ha thành phố đang đầu tư.</li>
<li><strong>Quy mô:</strong> 1 tòa 30 tầng, cao 114 m, 2 tầng hầm, 782 căn – 513 studio, 108 căn 1PN+, 133 căn 2PN; tầng 30 penthouse.</li>
<li><strong>Pháp lý:</strong> căn hộ thương mại dịch vụ, thời hạn 50 năm kể từ 17/09/2026; công trình cấp I, niên hạn 100 năm.</li>
<li><strong>Bàn giao:</strong> dự kiến 11/2028, liền tường trừ tủ bếp và thiết bị bếp; chiều cao tầng 3,5 m.</li>
<li><strong>Tiện ích:</strong> bể bơi view biển, gym, yoga, pilates, khối đế thương mại.</li>
<li><strong>Giá:</strong> giá dự kiến studio 30 m² tầng 15 khoảng 2,13 – 2,85 tỷ tùy dãy (chưa VAT, chưa 2% bảo trì); bảng giá chính thức công bố khi mở bán.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence: 28 căn mỗi sàn (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Nên chuẩn bị gì trước khi đi?</h2>
<ol>
<li><strong>Xác định mục đích mua</strong>: để ở, nghỉ dưỡng gia đình hay cho thuê – mỗi mục đích hợp loại căn và dãy căn khác nhau (xem <a href="/chon-day-can-sun-saphia-residence-mat-bien-canh-ben-phia-sau/">chọn dãy căn</a>, <a href="/tang-cao-hay-tang-thap-sun-saphia-residence-chon-tang-nao/">chọn tầng</a>).</li>
<li><strong>Tính trước ngân sách</strong>: tổng tiền gồm VAT, 2% bảo trì, nội thất; nếu vay, hỏi trước hạn mức với ngân hàng (xem <a href="/vay-mua-sun-saphia-residence-tra-gop-hang-thang/">vay mua Sun Saphia Residence</a>).</li>
<li><strong>Ghi sẵn câu hỏi</strong>: phí quản lý, chính sách cho thuê, tiến độ thanh toán, điều kiện hoàn tiền giữ chỗ (xem <a href="/sun-saphia-residence-hoi-dap-ban-giao-phi-quan-ly-cho-thue/">hỏi đáp Sun Saphia Residence</a>).</li>
<li><strong>Người nước ngoài</strong> lưu ý: chủ đầu tư không bán cho trường hợp có yếu tố nước ngoài (xem <a href="/nguoi-nuoc-ngoai-viet-kieu-mua-sun-saphia-residence-duoc-khong/">bài chi tiết</a>).</li>
</ol>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sự kiện giới thiệu là dịp tốt để nghe trực tiếp chủ đầu tư và xem mô hình, tài liệu, trước khi bảng giá chính thức ra ở sự kiện bán hàng. Anh chị chưa cần quyết định ngay tại buổi này; nên ghi lại thông tin, so sánh dòng tiền và chọn trước 2 – 3 căn ưng ý. Hoàng Hiệp có mặt tại sự kiện, có thể đón và đi cùng anh chị để giải thích từng mục. Xem thêm <a href="/danh-gia-sun-saphia-residence-chi-tiet/">đánh giá chi tiết Sun Saphia Residence</a> và <a href="/chuan-bi-su-kien-ban-hang-sun-saphia-residence-28-11/">7 việc nên chuẩn bị trước sự kiện bán hàng</a>.</p>
<p>Đăng ký tham dự, nhận tài liệu và bảng tính trước sự kiện: <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: thư mời sự kiện của chủ đầu tư (thời gian, địa điểm, chương trình, quà tặng); thông tin dự án theo tài liệu và buổi giải đáp của chủ đầu tư 10 – 11/2026. Chương trình có thể thay đổi theo thông báo của ban tổ chức.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sự kiện giới thiệu Sun Saphia Residence 15/11/2026',
			'desc'      => 'Sự kiện giới thiệu Sun Saphia Residence 09:00 Chủ nhật 15/11/2026 tại Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu: chương trình, quà bốc thăm, cách đăng ký.',
			'points'    => array(
				'09:00 Chủ nhật 15/11/2026 (đón khách từ 08:30), Sun Gallery Đà Nẵng – 01 Phan Đăng Lưu',
				'Giới thiệu Sun Group, giới thiệu dự án, tư vấn chuyên sâu',
				'Bốc thăm 5 phần quà cho khách tham dự lúc 10:45',
				'Sự kiện bán hàng dự kiến 05/12/2026 – bảng giá chính thức công bố khi mở bán',
			),
			'faq'       => array(
				array( 'Sự kiện giới thiệu Sun Saphia Residence diễn ra khi nào, ở đâu?', '09:00 Chủ nhật 15/11/2026 (đón khách từ 08:30) tại Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu, Hòa Cường, Đà Nẵng.' ),
				array( 'Tham dự sự kiện Sun Saphia Residence có quà không?', 'Có bốc thăm trúng thưởng lúc 10:45 cho khách tham dự: 1 máy lọc không khí Sharp, 2 máy massage cổ Philips, 2 tai nghe Sony.' ),
				array( 'Đăng ký tham dự sự kiện Sun Saphia Residence thế nào?', 'Gọi hoặc nhắn Zalo Hoàng Hiệp 0904 567 009 để giữ chỗ và nhận tài liệu dự án trước sự kiện.' ),
			),
		),
		'sources'  => array(),
	);


	/* ---------------- 13/11 – Tra cứu thông tin dự án, mã định danh trên Hệ thống thông tin nhà ở và thị trường BĐS (Bộ Xây dựng) – anh Hiệp gửi nguồn ---------------- */
	$posts[] = array(
		'slug'     => 'tra-cuu-du-an-ma-dinh-danh-bat-dong-san-thongtinbds-moc-gov-vn',
		'title'    => 'Cách tra cứu dự án, mã định danh bất động sản trên cổng thông tin của Bộ Xây dựng trước khi đặt cọc',
		'excerpt'  => 'Hệ thống thông tin về nhà ở và thị trường bất động sản của Bộ Xây dựng (thongtinbds.moc.gov.vn) cho tra cứu mã định danh bất động sản, dự án được chủ đầu tư công khai trước khi kinh doanh, tổ chức dịch vụ và môi giới có chứng chỉ. Quý II/2026 hệ thống ghi nhận 1.938 dự án, 131 dự án đủ điều kiện bán nhà ở hình thành trong tương lai.',
		'keyword'  => 'tra cứu mã định danh bất động sản',
		'keywords_extra' => array( 'thongtinbds.moc.gov.vn', 'hệ thống thông tin nhà ở và thị trường bất động sản', 'kiểm tra dự án đủ điều kiện bán', 'Nghị định 357/2025/NĐ-CP', 'tra cứu chứng chỉ môi giới bất động sản' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-13 19:00',
		'category' => 'Pháp lý nhà đất',
		'tags'     => array( 'Pháp lý nhà đất', 'Mã định danh bất động sản', 'Kinh nghiệm mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/tra-cuu-thong-tin-bds-bo-xay-dung.jpg',
		'image_alt' => 'Tra cứu dự án, mã định danh bất động sản trên Hệ thống thông tin nhà ở và thị trường bất động sản của Bộ Xây dựng',
		'content'  => <<<HTML
<p>Trước khi đặt cọc một căn hộ, nhiều anh chị hỏi Hoàng Hiệp: <em>"Làm sao biết dự án này đã được phép bán chưa?"</em>. Ngoài việc xem giấy tờ chủ đầu tư cung cấp, hiện nay người mua có thêm một kênh chính thức để đối chiếu: <strong>Hệ thống thông tin về nhà ở và thị trường bất động sản</strong> của Bộ Xây dựng tại địa chỉ <strong>thongtinbds.moc.gov.vn</strong>. Bài viết dưới đây giải thích hệ thống này là gì, tra cứu được những gì và nên dùng thế nào khi mua nhà ở Đà Nẵng.</p>
<!--hh-featured-->
<h2>Hệ thống thông tin về nhà ở và thị trường bất động sản là gì?</h2>
<p>Đây là hệ thống do Bộ Xây dựng quản lý, theo báo chí đưa tin được đưa vào vận hành từ ngày 30/7/2026 theo <strong>Nghị định 357/2025/NĐ-CP</strong> ngày 31/12/2025 (hiệu lực từ 01/3/2026), thay cho hệ thống cũ theo Nghị định 94/2024/NĐ-CP. Hệ thống dùng để công khai thông tin dự án bất động sản, bất động sản đủ điều kiện đưa vào kinh doanh, giao dịch bất động sản, thông tin về tổ chức, cá nhân hoạt động trong lĩnh vực này, và cấp <strong>mã định danh điện tử</strong> cho bất động sản. Hệ thống cũng kết nối dữ liệu với các cơ sở dữ liệu đất đai, công chứng, xây dựng.</p>
<p>Theo các trang pháp luật tóm tắt Nghị định 357/2025/NĐ-CP, mã định danh là chuỗi ký tự số và chữ, tối đa 40 ký tự, cấp cho từng nhà ở hoặc phần diện tích sàn xây dựng; với nhà ở, mã được tạo tự động trên hệ thống.</p>
<h2>Số liệu tổng quan trên hệ thống (quý II/2026, toàn quốc)</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Số liệu hiển thị trên trang chủ</th></tr></thead>
<tbody>
<tr><td>Tổng số dự án bất động sản</td><td>1.938 dự án</td></tr>
<tr><td>Bất động sản hình thành trong tương lai đủ điều kiện</td><td>59.073 bất động sản</td></tr>
<tr><td>Số lượng giao dịch bất động sản</td><td>100.005 giao dịch</td></tr>
<tr><td>Dự án nhà ở thương mại / nhà ở xã hội / du lịch, nghỉ dưỡng</td><td>1.580 / 875 / 63 dự án</td></tr>
<tr><td>Nhà ở thương mại: dự án đang triển khai xây dựng</td><td>1.297 dự án</td></tr>
<tr><td>Nhà ở thương mại: đủ điều kiện bán nhà ở hình thành trong tương lai</td><td>131 dự án</td></tr>
<tr><td>Nhà ở thương mại: số lượng bất động sản</td><td>867.583 căn/lô (388.863 nhà ở riêng lẻ, 478.720 căn chung cư)</td></tr>
</tbody>
</table>
<p>Một số ô (tổng mức đầu tư, giá trị giao dịch) hiện để trống trên hệ thống. Số liệu là tổng toàn quốc, phụ thuộc mức độ các địa phương và chủ đầu tư cập nhật; các tỉnh, thành vẫn đang được yêu cầu chuẩn hóa dữ liệu, nên chưa phản ánh đầy đủ thị trường.</p>
<h2>Tra cứu được những gì?</h2>
<table>
<thead><tr><th>Mục trên cổng</th><th>Dùng để làm gì</th></tr></thead>
<tbody>
<tr><td>Mã định danh điện tử</td><td>Danh sách tài sản đã được xác thực và gán mã định danh. Tra theo loại hình và khu vực; kết quả gồm mã dự án/công trình, mã thửa đất, loại hình, khu vực, chủ đầu tư</td></tr>
<tr><td>Bất động sản thương mại</td><td>Danh sách dự án bất động sản thương mại được chủ đầu tư công khai trước khi đưa vào kinh doanh</td></tr>
<tr><td>Nhà ở xã hội</td><td>Danh sách dự án nhà ở xã hội được chủ đầu tư công khai trước khi đưa vào kinh doanh</td></tr>
<tr><td>Tổ chức kinh doanh dịch vụ bất động sản</td><td>Lọc theo tỉnh/thành phố, loại hình, tình trạng – kiểm tra sàn giao dịch, công ty môi giới</td></tr>
<tr><td>Chứng chỉ hành nghề môi giới</td><td>Kiểm tra cá nhân môi giới có chứng chỉ hành nghề</td></tr>
<tr><td>Cá nhân được thụ hưởng chính sách hỗ trợ nhà ở</td><td>Tra cứu liên quan đối tượng mua, thuê nhà ở xã hội</td></tr>
<tr><td>Văn bản quy phạm pháp luật</td><td>Luật, nghị định, thông tư, quyết định liên quan nhà ở và kinh doanh bất động sản</td></tr>
</tbody>
</table>
<!--hh-img:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg|Sông Hàn và trung tâm Đà Nẵng về đêm – người mua căn hộ nên tra cứu dự án trên hệ thống của Bộ Xây dựng trước khi đặt cọc (ảnh thực tế)-->
<h2>Cách dùng khi mua nhà ở Đà Nẵng: 5 bước Hoàng Hiệp hay làm</h2>
<ol>
<li><strong>Vào đúng địa chỉ:</strong> gõ trực tiếp thongtinbds.moc.gov.vn (tên miền .gov.vn của Bộ Xây dựng). Không bấm link lạ gửi qua tin nhắn.</li>
<li><strong>Tra dự án:</strong> vào mục "Bất động sản thương mại" (hoặc "Nhà ở xã hội"), chọn khu vực Đà Nẵng, tìm theo tên dự án hoặc chủ đầu tư. Dự án được công khai trước khi kinh doanh là tín hiệu tốt; chưa thấy thì hỏi lại chủ đầu tư, không vội kết luận vì dữ liệu còn đang cập nhật.</li>
<li><strong>Đối chiếu với văn bản đủ điều kiện bán:</strong> với nhà ở hình thành trong tương lai, cần thêm văn bản của Sở Xây dựng thông báo nhà ở đủ điều kiện được bán – Sở Xây dựng Đà Nẵng cũng công bố danh sách này định kỳ.</li>
<li><strong>Kiểm tra người tư vấn:</strong> tra tên công ty dịch vụ bất động sản và chứng chỉ hành nghề môi giới của người đang tư vấn cho mình.</li>
<li><strong>Giữ lại kết quả tra cứu:</strong> chụp màn hình kèm ngày tra cứu, lưu cùng hồ sơ cọc để đối chiếu khi ký hợp đồng.</li>
</ol>
<h2>Lưu ý quan trọng</h2>
<ul>
<li><strong>Kết quả tra cứu không thay hồ sơ pháp lý:</strong> vẫn cần xem quyết định chủ trương đầu tư, giấy phép xây dựng, văn bản đủ điều kiện bán, bảo lãnh ngân hàng (với nhà hình thành trong tương lai) và hợp đồng mẫu.</li>
<li><strong>Căn hộ thương mại dịch vụ, condotel</strong> như Sun Saphia Residence không phải "nhà ở" theo Luật Nhà ở, nên thủ tục và danh sách công khai có thể khác căn hộ chung cư – xem thêm <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia Residence</a>.</li>
<li><strong>Quy định bắt buộc dùng mã định danh trong mọi giao dịch</strong> theo một số báo vẫn đang nằm trong dự thảo Luật Kinh doanh bất động sản sửa đổi, chưa phải quy định đã áp dụng cho mọi giao dịch nhà đất.</li>
<li><strong>Dữ liệu đang được cập nhật:</strong> TP Đà Nẵng đã có văn bản triển khai cơ sở dữ liệu nhà ở và thị trường bất động sản; theo báo chí, Sở Xây dựng đã cấp hơn 300 tài khoản cho cơ quan, đơn vị cập nhật dữ liệu.</li>
</ul>
<p>Xem thêm: <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">cách kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>
<h2>Dự án Hoàng Hiệp hỗ trợ kiểm tra hồ sơ</h2>
<ul>
<li><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a> – căn hộ thương mại dịch vụ mặt biển của Sun Group, sắp giới thiệu chính thức.</li>
<li><a href="/du-an/spana-tower/">Spana Tower Hòa Xuân</a> và <a href="/du-an/cora-tower/">Cora Tower</a> – căn hộ Sun Group ở Hòa Xuân, Hải Châu.</li>
<li><a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a> – căn hộ hàng hiệu ven biển Mỹ Khê.</li>
</ul>
<p>Anh chị cần Hiệp tra cứu giúp một dự án, đối chiếu văn bản đủ điều kiện bán hoặc kiểm tra hồ sơ trước khi đặt cọc, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: Hệ thống thông tin về nhà ở và thị trường bất động sản – Bộ Xây dựng (thongtinbds.moc.gov.vn, số liệu trang chủ "Tổng quan thị trường quý II 2026", xem ngày 13/11/2026); Nghị định 357/2025/NĐ-CP theo tóm tắt của Thư viện Pháp luật, LuatVietnam, Cổng thông tin Chính phủ; thông tin vận hành hệ thống theo Tiền Phong, Báo Xây dựng; Đà Nẵng triển khai cơ sở dữ liệu theo VnEconomy.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tra cứu mã định danh bất động sản trên cổng Bộ Xây dựng',
			'desc'      => 'Cách tra cứu dự án công khai, mã định danh bất động sản, môi giới có chứng chỉ trên thongtinbds.moc.gov.vn trước khi đặt cọc mua nhà ở Đà Nẵng.',
			'points'    => array(
				'thongtinbds.moc.gov.vn là Hệ thống thông tin về nhà ở và thị trường bất động sản của Bộ Xây dựng, vận hành theo Nghị định 357/2025/NĐ-CP',
				'Tra cứu được mã định danh bất động sản, dự án thương mại và nhà ở xã hội công khai trước khi kinh doanh, tổ chức dịch vụ, chứng chỉ môi giới',
				'Quý II/2026: 1.938 dự án, 131 dự án đủ điều kiện bán nhà ở hình thành trong tương lai, 100.005 giao dịch (toàn quốc)',
				'Kết quả tra cứu không thay hồ sơ pháp lý; vẫn cần văn bản đủ điều kiện bán của Sở Xây dựng',
			),
			'faq'       => array(
				array( 'Tra cứu mã định danh bất động sản ở đâu?', 'Trên Hệ thống thông tin về nhà ở và thị trường bất động sản của Bộ Xây dựng tại thongtinbds.moc.gov.vn, mục "Mã định danh điện tử", lọc theo loại hình và khu vực.' ),
				array( 'Làm sao biết dự án đã được phép bán?', 'Tra danh sách dự án được chủ đầu tư công khai trước khi kinh doanh trên thongtinbds.moc.gov.vn và đối chiếu văn bản thông báo đủ điều kiện bán nhà ở hình thành trong tương lai của Sở Xây dựng.' ),
				array( 'Mã định danh bất động sản là gì?', 'Theo Nghị định 357/2025/NĐ-CP, là chuỗi ký tự số và chữ tối đa 40 ký tự cấp cho từng nhà ở hoặc phần diện tích sàn xây dựng; với nhà ở, mã được tạo tự động trên hệ thống.' ),
				array( 'Có kiểm tra được môi giới bất động sản không?', 'Có. Cổng có mục tra cứu tổ chức kinh doanh dịch vụ bất động sản và danh sách cá nhân có chứng chỉ hành nghề môi giới.' ),
			),
		),
		'sources'  => array(
			'https://thongtinbds.moc.gov.vn/',
			'https://thuvienphapluat.vn/phap-luat-doanh-nghiep/bai-viet/tom-tat-nghi-dinh-357-ve-dinh-danh-bat-dong-san-tu-01-03-2026-nghi-dinh-357-2025-nd-cp-18049.html',
			'https://xaydungchinhsach.chinhphu.vn/tu-2026-gan-ma-dinh-danh-dien-tu-cho-bat-dong-san-119260120154236385.htm',
			'https://tienphong.vn/tiep-nhan-120-du-an-900-ho-so-bat-dong-san-tren-he-thong-moi-post1876224.tpo',
			'https://batdongsan.baoxaydung.vn/tung-buoc-hoan-thien-he-thong-du-lieu-nha-o-va-thi-truong-bat-dong-san-192260913200230575.htm',
			'https://vneconomy.vn/da-nang-lap-co-so-du-lieu-nha-o-va-thi-truong-bat-dong-san.htm',
		),
	);

	/* ---------------- 13/11 – FPT Plaza 3 hoàn thành cấp sổ hồng 100% căn hộ (anh Hiệp gửi thông báo CĐT + 6 ảnh) ---------------- */
	$posts[] = array(
		'slug'     => 'fpt-plaza-3-hoan-thanh-cap-so-hong-100-can-ho',
		'title'    => 'FPT Plaza 3 hoàn thành cấp sổ hồng cho 100% căn hộ sau khoảng 7 tháng bàn giao',
		'excerpt'  => 'Ngày 13/11/2026, Công ty CP Đô thị FPT Đà Nẵng (FPT City) thông báo hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ FPT Plaza 3, khoảng 7 tháng sau khi bàn giao (17/4/2026). Căn hộ đã có sổ có thể công chứng mua bán, thế chấp vay ngân hàng.',
		'keyword'  => 'sổ hồng FPT Plaza 3',
		'keywords_extra' => array( 'FPT Plaza 3', 'FPT City Đà Nẵng', 'căn hộ có sổ hồng Đà Nẵng', 'mua lại căn hộ FPT Plaza 3' ),
		'project'  => 'fpt-plaza-3',
		'schedule' => '2026-11-13 21:00',
		'category' => 'Tin dự án',
		'tags'     => array( 'FPT Plaza 3', 'FPT City', 'Pháp lý nhà đất' ),
		'image'    => 'plugin:img/tin-tuc/fpt-plaza-3-100-can-co-so-hong-11-2026.jpg',
		'image_alt' => 'FPT Plaza 3 hoàn thành cấp sổ hồng cho 100% căn hộ ngày 13/11/2026',
		'content'  => <<<HTML
<p>Ngày 13/11/2026, Công ty Cổ phần Đô thị FPT Đà Nẵng (FPT City) thông báo đã <strong>hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ FPT Plaza 3</strong>, khoảng 7 tháng sau khi dự án khánh thành và bàn giao căn hộ (17/4/2026). Với người đã mua, đây là mốc pháp lý cuối cùng: căn hộ đã có sổ riêng, đứng tên chủ sở hữu.</p>
<!--hh-featured-->
<!--hh-img:img/fpt-plaza-3/fpt-plaza-3-trao-so-11-2026-gia-dinh-3.jpg|Cư dân FPT Plaza 3 nhận Giấy chứng nhận quyền sở hữu căn hộ ngày 13/11/2026 (ảnh thực tế)-->
<h2>Các mốc pháp lý của FPT Plaza 3</h2>
<table>
<thead><tr><th>Thời gian</th><th>Mốc</th></tr></thead>
<tbody>
<tr><td>25/09/2024</td><td>Sở Xây dựng Đà Nẵng có Thông báo 7190/SXD-QLN: nhà ở hình thành trong tương lai đủ điều kiện được bán</td></tr>
<tr><td>17/4/2026</td><td>Khánh thành và bàn giao căn hộ</td></tr>
<tr><td>13/11/2026</td><td>Chủ đầu tư thông báo hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ</td></tr>
</tbody>
</table>
<p>FPT Plaza 3 gồm 2 tháp W và E cao 25 tầng nổi, khoảng 837 căn hộ và shophouse khối đế, nằm ở trung tâm Khu đô thị FPT City (Ngũ Hành Sơn), cạnh quảng trường – công viên trung tâm. Khách Việt Nam được sở hữu lâu dài.</p>
<!--hh-img:img/fpt-plaza-3/fpt-plaza-3-trao-so-11-2026-thu-tuc-2.jpg|Quầy làm thủ tục trao Giấy chứng nhận cho cư dân FPT Plaza 3 tại văn phòng FPT City (ảnh thực tế 13/11/2026)-->
<h2>Căn hộ đã có sổ hồng thì người mua được gì?</h2>
<ul>
<li><strong>Mua bán, chuyển nhượng qua công chứng:</strong> giao dịch thực hiện bằng hợp đồng công chứng và sang tên tại văn phòng đăng ký đất đai, không còn phải chuyển nhượng hợp đồng mua bán qua chủ đầu tư.</li>
<li><strong>Thế chấp vay ngân hàng bằng chính căn hộ:</strong> người mua lại có thể vay theo hạn mức ngân hàng định giá; chủ nhà cũng có thể dùng sổ để vay vốn.</li>
<li><strong>Cho thuê, đăng ký cư trú thuận lợi hơn:</strong> có giấy tờ sở hữu rõ ràng khi ký hợp đồng thuê, đăng ký tạm trú cho người thuê.</li>
<li><strong>Giảm rủi ro pháp lý:</strong> nhiều dự án tại Đà Nẵng phải chờ nhiều năm mới có sổ; với căn hộ đã có sổ, người mua kiểm tra được ngay thông tin trên giấy chứng nhận.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Tiến độ sổ nhanh là điểm cộng lớn:</strong> khoảng 7 tháng từ bàn giao đến cấp sổ cho toàn bộ căn hộ là mốc tốt so với mặt bằng chung, giúp củng cố niềm tin với các dự án tiếp theo cùng chủ đầu tư tại FPT City.</li>
<li><strong>Thị trường mua lại FPT Plaza 3 sẽ minh bạch hơn:</strong> khi đã có sổ, giao dịch thứ cấp làm thủ tục như căn hộ hoàn thiện pháp lý; người mua nên kiểm tra sổ gốc, tình trạng thế chấp và nghĩa vụ tài chính còn lại trước khi đặt cọc.</li>
<li><strong>Phù hợp người mua để ở và cho thuê dài hạn:</strong> khu FPT City gần Đại học FPT, trường quốc tế, khu công nghệ – nhu cầu thuê từ sinh viên, chuyên gia, gia đình trẻ khá ổn định.</li>
</ul>
<h2>Dự án liên quan</h2>
<ul>
<li><a href="/du-an/fpt-plaza-3/">FPT Plaza 3</a> – xem pháp lý, mặt bằng, ảnh thực tế căn hộ bàn giao.</li>
<li><a href="/du-an/fpt-plaza-4/">FPT Plaza 4</a> – dự án căn hộ tiếp theo của FPT City.</li>
<li><a href="/du-an/fpt-city-da-nang/">Khu đô thị FPT City Đà Nẵng</a> – tổng quan khu đô thị.</li>
</ul>
<p>Xem thêm: <a href="/tra-cuu-du-an-ma-dinh-danh-bat-dong-san-thongtinbds-moc-gov-vn/">cách tra cứu dự án, mã định danh bất động sản trên cổng của Bộ Xây dựng</a> và <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý nhà đất Đà Nẵng</a>.</p>
<p>Anh chị cần tìm căn FPT Plaza 3 đã có sổ để mua ở hoặc cho thuê, hoặc cần định giá căn đang sở hữu, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
<p class="src">Nguồn: thông báo của Công ty Cổ phần Đô thị FPT Đà Nẵng – FPT City ngày 13/11/2026 và ảnh sự kiện trao Giấy chứng nhận cho cư dân; Thông báo 7190/SXD-QLN ngày 25/09/2024 của Sở Xây dựng Đà Nẵng; thông tin dự án từ tài liệu chủ đầu tư.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'FPT Plaza 3 đã cấp sổ hồng cho 100% căn hộ',
			'desc'      => 'Ngày 13/11/2026 FPT City hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ FPT Plaza 3, khoảng 7 tháng sau bàn giao. Ý nghĩa với người mua.',
			'points'    => array(
				'13/11/2026: FPT City hoàn thành cấp sổ hồng cho 100% căn hộ FPT Plaza 3',
				'Khoảng 7 tháng sau khánh thành, bàn giao (17/4/2026)',
				'Căn hộ có sổ: mua bán qua công chứng, thế chấp vay ngân hàng, sở hữu lâu dài với khách Việt Nam',
			),
			'faq'       => array(
				array( 'FPT Plaza 3 đã có sổ hồng chưa?', 'Có. Ngày 13/11/2026, chủ đầu tư FPT City thông báo đã hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ FPT Plaza 3.' ),
				array( 'FPT Plaza 3 bàn giao khi nào?', 'Dự án khánh thành và bàn giao căn hộ ngày 17/4/2026; sổ hồng được cấp xong khoảng 7 tháng sau.' ),
				array( 'Mua lại căn FPT Plaza 3 đã có sổ cần lưu ý gì?', 'Kiểm tra sổ gốc, tình trạng thế chấp, nghĩa vụ tài chính và phí quản lý còn nợ; giao dịch bằng hợp đồng công chứng và sang tên tại văn phòng đăng ký đất đai.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt.com/du-an/fpt-plaza-3/',
		),
	);
	/* ---------------- 14/11 – Bài tiếng Anh (khách nước ngoài) – Nobu Residences Đà Nẵng ---------------- */
	$nobu_en = '<a href="/du-an/nobu-da-nang/en/">Nobu Residences Da Nang</a>';
	$cta_en  = '<p>For floor plans, current availability and an official price sheet for <a href="/du-an/nobu-da-nang/en/">Nobu Residences Da Nang</a>, contact <strong>Hoang Hiep – +84 904 567 009</strong> (phone, WhatsApp or Zalo). Private viewings at the sales gallery in Da Nang can be arranged on request.</p>';
	$posts[] = array(
		'slug'     => 'nobu-residences-da-nang-buyers-guide',
		'title'    => 'Nobu Residences Da Nang: A Buyer’s Guide to the Branded Residences on My Khe Beach',
		'excerpt'  => 'A clear guide to Nobu Residences Da Nang – the 43-storey beachfront tower by VCRE and Nobu Hospitality: residence types and sizes, indicative pricing, floor stacking, interiors, construction progress and what to check before you reserve.',
		'keyword'  => 'Nobu Residences Da Nang',
		'keywords_extra' => array( 'Nobu Da Nang', 'branded residences Da Nang', 'My Khe Beach apartments', 'luxury condos Da Nang' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-14 19:00',
		'category' => 'Tin dự án',
		'tags'     => array( 'Nobu Đà Nẵng', 'English', 'Căn hộ hạng sang' ),
		'image'    => 'plugin:img/tin-tuc/nobu-residences-da-nang-buyers-guide.jpg',
		'image_alt' => 'Nobu Residences Da Nang buyer’s guide – key figures',
		'content'  => <<<HTML
<div lang="en">
<p><strong>Nobu Residences Da Nang</strong> is the first Nobu-branded residential address in Vietnam: a 43-storey tower on the corner of Vo Van Kiet and Vo Nguyen Giap, directly facing My Khe Beach. Developed by VCRE (Viet Capital Real Estate) under licence from Nobu Hospitality – the lifestyle group founded by Robert De Niro, Chef Nobu Matsuhisa and Meir Teper – the tower combines 264 branded residences with a Nobu Hotel, the Nobu Restaurant and a rooftop sky bar. This guide sets out what is being built, what is for sale and what an international buyer should verify before committing.</p>
<!--hh-featured-->
<h2>The project at a glance</h2>
<ul>
<li><strong>Developer:</strong> VCRE, through the project company Circle Point Real Estate JSC; main contractor Newtecons.</li>
<li><strong>Brand and operator:</strong> Nobu Hospitality.</li>
<li><strong>Address:</strong> 01 Vo Van Kiet Street, An Hai Ward, Da Nang – one minute from the sand.</li>
<li><strong>Scale:</strong> a site of approximately 3,000 m², around 48,510 m² of gross floor area, 43 storeys (approximately 186 m) above two basement levels.</li>
<li><strong>Components:</strong> 264 branded residences; a Nobu Hotel of approximately 200 keys including 18 suites; Nobu Restaurant; spa, wellness, conference and dining venues.</li>
<li><strong>Timing:</strong> construction began in Q2 2024; completion and handover are expected in 2027.</li>
</ul>

<h2>Why the location matters</h2>
<p>Beachfront land on Vo Nguyen Giap is effectively finite. The boulevard is lined with established five-star hotels, and new freehold-style residential towers directly on the beach are rare. From the tower, the Dragon Bridge and the Han River are around five minutes away, the Hai Chau city centre about ten and Da Nang International Airport roughly fifteen. For owners who intend to spend part of the year in the city – or to place the residence in a rental programme – that combination of beach, city and airport access is the core of the proposition.</p>

<h2>Residence types, sizes and indicative pricing</h2>
<p>The collection is deliberately broad, from compact pieds-à-terre to full-floor-style homes in the sky:</p>
<table>
<thead><tr><th>Residence type</th><th>Indicative size</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>approx. 42 – 43 m²</td></tr>
<tr><td>One Bedroom</td><td>approx. 62.5 – 71.1 m²</td></tr>
<tr><td>Two Bedroom</td><td>approx. 99.7 – 118.7 m²</td></tr>
<tr><td>Three Bedroom Dual Key</td><td>approx. 130.1 – 166.2 m²</td></tr>
<tr><td>Sky Villa (6 residences, private pool)</td><td>approx. 254 – 288 m²</td></tr>
<tr><td>Penthouse (2 residences)</td><td>approx. 372 m²</td></tr>
</tbody>
</table>
<p>Published figures place one-bedroom residences at approximately VND 6.6 – 9.1 billion, with a reference range of around VND 145 – 205 million per square metre depending on floor, view and layout. These numbers are indicative only; the developer issues an official price sheet for a specific residence at the time of reservation, and pricing for Sky Villas and penthouses is released privately.</p>
<p>The <strong>Dual Key</strong> layout deserves a particular mention. A three-bedroom residence can be lived in as one home or separated into two self-contained units with their own entrances – useful for multi-generational families, or for owners who wish to occupy one part while the other is let.</p>

<h2>How the tower is organised</h2>
<p>The stacking places the private residences above the hotel, so residents enjoy the widest views and a separate address within the building:</p>
<ul>
<li><strong>Levels 1 – 6:</strong> arrival lobby and offices, spa and wellness (levels 3 – 4), conference (level 5) and the Taste of Asia restaurant (level 6).</li>
<li><strong>Levels 7 – 16:</strong> Nobu Hotel.</li>
<li><strong>Level 18:</strong> amenity floor with a heated infinity pool.</li>
<li><strong>Levels 19 – 36:</strong> branded residences.</li>
<li><strong>Levels 38 – 41:</strong> Sky Villas and penthouses.</li>
<li><strong>Levels 42 – 43:</strong> Nobu Restaurant and the Tsukimidai sky bar.</li>
</ul>
<p>Levels 17 and 37 are refuge floors. The full floor-by-floor allocation and diagram are on the {$nobu_en} page.</p>

<h2>Interiors and specification</h2>
<p>Residences are delivered fully finished in a Japandi palette – the meeting point of Japanese restraint and Scandinavian warmth that runs through every Nobu property. According to the project’s interior presentation, the specification includes herringbone timber flooring, a Wendelbo sofa set or equivalent, Serta Simmons mattresses, headboards upholstered in washi paper, imported marble kitchen countertops, a built-in coffee machine, Kohler sanitaryware and a Smeg refrigerator. As with any off-plan purchase, the binding specification is the one attached to your Sale and Purchase Agreement, so ask to see that appendix rather than relying on brochures.</p>

<h2>Construction progress</h2>
<p>Construction started in Q2 2024. The transfer slab was completed in early 2026, and by October 2026 the structure had reached level 22, with glass façade installation under way on levels 7 – 13 and mechanical, electrical and fire-protection works progressing to level 17. On that trajectory the developer continues to guide for completion in 2027. Monthly site photographs are published on the project page.</p>

<h2>Ownership and the rental programme</h2>
<p>This is the area that requires the most care. Published sources describe long-term ownership for Vietnamese buyers and a 50-year term for foreign buyers, while other sources refer to a land-use term running to 2060 on commercial–service land. Both cannot be read as a guarantee for every residence. Before you reserve, ask for written confirmation of:</p>
<ol>
<li>your eligibility to buy as a foreign individual or company, and the ownership certificate you will receive;</li>
<li>the ownership term that applies to your specific residence;</li>
<li>the payment schedule, handover standard and annual service charges;</li>
<li>the terms of the rental programme operated by Nobu Hospitality – revenue share, owner-use nights and exit provisions.</li>
</ol>
<p>Some sales materials cite an indicative rental yield of around 6% per year. Treat any such figure as an illustration until you have read the programme agreement itself. Our companion article, <a href="/branded-residences-da-nang-foreign-buyers/">Branded Residences in Da Nang: What Buyers Should Know</a>, explains the general legal framework for foreign purchasers in more detail.</p>

<h2>Who Nobu Residences Da Nang suits</h2>
<p>The project is best suited to buyers who value a globally recognised hospitality brand, a beachfront address and hotel-grade services, and who are comfortable with an off-plan timeline to 2027. Buyers seeking the lowest price per square metre in Da Nang, or immediate rental income, may find better-fitting options among completed buildings.</p>
{$cta_en}
<p class="src">Sources: developer project materials and interior presentation; developer construction updates to October 2026; project page at hiephoangmt.com. All figures are indicative and subject to change. This article is general information and not legal or financial advice.</p>
</div>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nobu Residences Da Nang: Buyer’s Guide, Prices & Floor Plans',
			'desc'      => 'Nobu Residences Da Nang on My Khe Beach: 264 branded residences, studios to Sky Villas, indicative prices, floor stacking, interiors, progress and ownership checks.',
			'points'    => array(
				'43-storey beachfront tower by VCRE and Nobu Hospitality, expected completion 2027',
				'264 residences from approx. 42 m² studios to 372 m² penthouses; six Sky Villas with private pools',
				'Confirm ownership term, foreign eligibility and rental programme terms in the SPA before reserving',
			),
			'faq'       => array(
				array( 'Where is Nobu Residences Da Nang?', 'At 01 Vo Van Kiet Street, on the corner of Vo Nguyen Giap, An Hai Ward, Da Nang – directly on My Khe Beach.' ),
				array( 'How much is a residence at Nobu Da Nang?', 'Published figures place one-bedroom residences at approximately VND 6.6 – 9.1 billion. Prices are indicative; an official price sheet is issued for each residence at reservation.' ),
				array( 'When will Nobu Residences Da Nang be completed?', 'Construction began in Q2 2024 and completion is expected in 2027. By October 2026 the structure had reached level 22.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt.com/du-an/nobu-da-nang/en/',
		),
	);

	$posts[] = array(
		'slug'     => 'branded-residences-da-nang-foreign-buyers',
		'title'    => 'Branded Residences in Da Nang: What International Buyers Should Know',
		'excerpt'  => 'How foreigners can own property in Vietnam, what a branded residence offers beyond a conventional condominium, how hotel rental programmes work and the due-diligence checklist we use with international clients in Da Nang.',
		'keyword'  => 'branded residences Da Nang',
		'keywords_extra' => array( 'foreigners buy property Vietnam', 'Da Nang property for foreigners', 'Nobu Residences Da Nang', 'Vietnam Housing Law 2023 foreign ownership' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-14 21:00',
		'category' => 'Thị trường',
		'tags'     => array( 'English', 'Pháp lý nhà đất', 'Nobu Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/branded-residences-da-nang-foreign-buyers.jpg',
		'image_alt' => 'Branded residences in Da Nang – what international buyers should know',
		'content'  => <<<HTML
<div lang="en">
<p>Da Nang has become one of Southeast Asia’s most watched coastal cities: a modern airport with direct regional connections, a 30-kilometre urban beachfront and a steady pipeline of international hotel brands. The newest chapter is the <strong>branded residence</strong> – private homes that carry the name, design language and services of a luxury hospitality group. With {$nobu_en} now rising on My Khe Beach, international buyers are asking the same questions. This article answers them in plain terms.</p>
<!--hh-featured-->
<h2>What is a branded residence?</h2>
<p>A branded residence is a home developed in partnership with a hospitality or lifestyle brand. The brand licenses its name and design standards to the developer and, in most cases, its hotel company operates the building’s services – concierge, housekeeping, dining and, where offered, a rental programme. Owners pay a premium over comparable unbranded homes in exchange for three things: consistent quality, professional management and the resale appeal of a recognised name.</p>
<p>In Da Nang, the format is still young. Most beachfront product to date has been either conventional condominiums or hotel apartments sold with a guaranteed-return scheme. A branded residence sits between the two: it is a home first, with the option to place it into a professionally managed rental pool.</p>

<h2>Can foreigners buy property in Vietnam?</h2>
<p>Yes – within limits. Under the Housing Law 2023, which took effect on 1 August 2024, foreign individuals with a valid visa and foreign-invested organisations may own housing in commercial housing projects outside areas restricted for defence and security. The key rules are:</p>
<ul>
<li><strong>Quota:</strong> foreigners may own no more than 30% of the apartments in a single apartment building, and no more than 250 landed houses within a ward-level administrative area.</li>
<li><strong>Term:</strong> individual foreign owners hold title for up to 50 years from the date the ownership certificate is issued, with the possibility of one extension of up to 50 years if requested before expiry.</li>
<li><strong>Purchase route:</strong> foreigners buy primary units from the developer or secondary units from other foreign owners; payment is made through a Vietnamese bank account.</li>
</ul>
<p>Two practical points follow. First, the quota is building-specific, so the developer must confirm that foreign allocation remains available for the residence you choose. Second, the rules for apartments on residential land differ from those for units built on commercial–service land, which is common for hotel-branded towers. In the latter case the ownership term is generally tied to the project’s land-use term, so it is essential to see what the project’s land documents actually say.</p>

<h2>Understanding rental programmes</h2>
<p>Many branded residences offer owners the option to place their home into a rental pool managed by the hotel operator. When it works well, the owner receives a share of net rental revenue while the operator handles marketing, guest services and maintenance. Before committing, read the programme agreement for:</p>
<ul>
<li>how revenue is shared and which costs are deducted before the split;</li>
<li>the number of nights owners may use their residence each year, and blackout dates;</li>
<li>furniture, fixtures and equipment reserves and who funds them;</li>
<li>the term of the programme and how an owner can exit.</li>
</ul>
<p>Be cautious with headline yields. A figure such as “6% per year” in sales materials is an illustration, not a contract, unless it is written into the agreement you sign and backed by an identified party.</p>

<h2>A due-diligence checklist</h2>
<p>For international clients we work through the following before any reservation deposit:</p>
<ol>
<li><strong>Project legal status:</strong> investment approval, land-use rights, construction permit and – for off-plan sales – the provincial housing authority’s notice that the project is eligible to sell future housing.</li>
<li><strong>Bank guarantee:</strong> for off-plan purchases, confirm the bank guarantee that protects buyers if the developer fails to deliver.</li>
<li><strong>Foreign eligibility and quota:</strong> written confirmation for the specific residence.</li>
<li><strong>Ownership term and certificate:</strong> what term applies and when the certificate is expected after handover.</li>
<li><strong>Payment schedule:</strong> instalments tied to construction milestones, and the handover payment.</li>
<li><strong>Specification:</strong> the finishes appendix attached to the Sale and Purchase Agreement.</li>
<li><strong>Running costs:</strong> service charges, sinking fund and rental-programme deductions.</li>
<li><strong>Exit:</strong> resale rules, including selling to foreign or Vietnamese buyers and the tax position.</li>
</ol>
<p>An independent Vietnamese lawyer can review the documents in English; we are happy to coordinate that process.</p>

<h2>Where Nobu Residences Da Nang fits</h2>
<p>Nobu Residences Da Nang is the clearest example of the branded-residence model in the city: 264 residences above a Nobu Hotel, with Nobu Restaurant on level 42 and a sky bar on level 43, directly on My Khe Beach. Residences range from approximately 42 m² studios to 372 m² penthouses, including six Sky Villas with private pools. Construction reached level 22 in October 2026, with completion expected in 2027. Published sources differ on the ownership term for this project, so the checklist above applies in full. Our <a href="/nobu-residences-da-nang-buyers-guide/">Nobu Residences Da Nang buyer’s guide</a> covers residence types, indicative pricing and the floor stacking in detail.</p>

<h2>The bottom line</h2>
<p>Buying in Da Nang as a foreigner is entirely possible and increasingly common. The difference between a good purchase and a disappointing one usually lies in the documents rather than the view: confirm eligibility, tenure and rental terms in writing, and buy into a project whose developer and operator you can hold to account.</p>
{$cta_en}
<p class="src">Sources: Vietnam Housing Law 2023 (Law No. 27/2023/QH15), effective 1 August 2024; Real Estate Business Law 2023; developer materials for Nobu Residences Da Nang. This article is general information and not legal advice; regulations may change and their application depends on each project.</p>
</div>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Branded Residences in Da Nang: A Guide for Foreign Buyers',
			'desc'      => 'Can foreigners buy property in Da Nang? Ownership quotas and terms under Vietnam’s Housing Law 2023, how branded-residence rental programmes work and a due-diligence checklist.',
			'points'    => array(
				'Foreigners may own up to 30% of apartments in a building, for up to 50 years with one possible extension',
				'Units on commercial–service land follow the project’s land-use term – check the land documents',
				'Read the rental programme agreement: revenue share, owner-use nights, reserves and exit terms',
			),
			'faq'       => array(
				array( 'Can foreigners buy an apartment in Da Nang?', 'Yes. Under the Housing Law 2023, foreign individuals with a valid visa may buy apartments in commercial housing projects outside restricted areas, within a 30% quota per building.' ),
				array( 'How long can a foreigner own property in Vietnam?', 'Up to 50 years from the date the ownership certificate is issued, with the possibility of one extension of up to 50 years.' ),
				array( 'Are rental yields guaranteed at branded residences?', 'Only if a guarantee is written into the agreement you sign and backed by an identified party. Figures in sales materials are illustrations.' ),
			),
		),
		'sources'  => array(
			'https://hiephoangmt.com/du-an/nobu-da-nang/en/',
		),
	);
	return $posts;
}
