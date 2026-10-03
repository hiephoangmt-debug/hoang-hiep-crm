<?php
/**
 * Bài viết kế hoạch nội dung – tuần 9–10 (cụm dự án ven biển, đất – khách sạn ven biển, khu vực Đà Nẵng, kinh nghiệm đầu tư). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_09_10' );
function hh_posts_tuan_09_10( $posts ) {
	/* ---------------------------------------------------------------- Tuần 9 */
	$posts[] = array(
		'slug'     => 'newtown-diamond-3-toa-va-newtown-legend',
		'title'    => 'Newtown Diamond: 3 tòa căn hộ và phân khu thấp tầng Newtown Legend',
		'excerpt'  => 'Newtown Diamond gồm 3 tòa The Ruby, The Sapphire, The Diamond (1.733 căn) và phân khu Newtown Legend 24 biệt thự, 36 shophouse trên trục biển Trường Sa.',
		'keyword'  => 'Newtown Diamond',
		'project'  => 'newtown-diamond-da-nang',
		'week'     => 9,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Newtown Diamond</strong> là tổ hợp ven biển tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa (Ngũ Hành Sơn, Đà Nẵng), gồm 3 tòa căn hộ 36 tầng The Ruby, The Sapphire, The Diamond với tổng 1.733 căn và phân khu thấp tầng Newtown Legend (24 biệt thự, 36 shophouse). Toàn bộ sản phẩm có sổ hồng sở hữu lâu dài. Bài viết cập nhật tháng 10/2026, giúp anh chị phân biệt từng tòa, từng dòng sản phẩm và mặt bằng giá tham khảo.</p>

<h2>Tổng quan tổ hợp Newtown Diamond</h2>
<p>Chủ đầu tư là Công ty TNHH Phát triển New Town; tổng thầu là Công ty CP CONINCO 3C, trong đó Hòa Bình thi công phần thân tòa The Ruby. Khu đất khoảng 1,47 ha, 3 tòa tháp 36 tầng nổi dùng chung 3 tầng hầm, diện tích căn hộ khoảng 34,74 – 131,96 m².</p>
<p>Vị trí nằm trên trục biển Trường Sa, đối diện Sheraton Grand Đà Nẵng Resort và cạnh sân golf BRG Đà Nẵng. Từ dự án đi bộ ra biển khoảng 1 phút, đến danh thắng Ngũ Hành Sơn khoảng 5 phút, trung tâm thành phố khoảng 15 phút và phố cổ Hội An khoảng 25 phút.</p>

<h2>3 tòa căn hộ: The Ruby, The Sapphire, The Diamond</h2>
<table>
<thead><tr><th>Tòa</th><th>Số căn</th><th>Loại căn</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>The Ruby (M1)</td><td>829 căn</td><td>1 – 3 phòng ngủ</td><td>Đã cất nóc ngày 18/4/2026</td></tr>
<tr><td>The Sapphire (M2)</td><td>510 căn</td><td>1 – 3 phòng ngủ</td><td>Đang xây dựng</td></tr>
<tr><td>The Diamond</td><td>394 căn</td><td>1 – 3 phòng ngủ</td><td>Đang xây dựng</td></tr>
</tbody>
</table>
<h3>Tòa The Ruby – lớn nhất, tiến độ nhanh nhất</h3>
<p><a href="/du-an/newtown-the-ruby/">The Ruby</a> có 829 căn, cất nóc ngày 18/4/2026. Kế hoạch công bố trước đó là bàn giao quý 3/2026; thời điểm bàn giao thực tế từng căn anh chị nên đối chiếu thông báo của chủ đầu tư.</p>
<h3>Tòa The Sapphire và The Diamond</h3>
<p><a href="/du-an/newtown-the-sapphire/">The Sapphire</a> có 510 căn, <a href="/du-an/newtown-the-diamond/">The Diamond</a> có 394 căn – tòa ít căn nhất, mật độ cư dân thấp hơn. Cả hai tòa đang xây dựng, phù hợp khách muốn thanh toán giãn theo tiến độ.</p>

<h2>Giá căn hộ Newtown Diamond tham khảo</h2>
<p>Giá dưới đây tổng hợp từ bảng chào bán và tin rao chuyển nhượng năm 2026, chỉ để tham khảo. Giá thực tế chênh theo tòa, tầng, hướng view biển hay view golf.</p>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá chào bán (tham khảo)</th><th>Tin rao chuyển nhượng</th></tr></thead>
<tbody>
<tr><td>1 phòng ngủ</td><td>35 – 50 m²</td><td>Khoảng 3,5 – 3,9 tỷ</td><td>Khoảng 2,8 – 3,9 tỷ</td></tr>
<tr><td>2 phòng ngủ</td><td>73 – 87 m²</td><td>Khoảng 5,7 – 7,5 tỷ</td><td>Khoảng 4,5 – 7,5 tỷ</td></tr>
<tr><td>3 phòng ngủ</td><td>94 – 132 m²</td><td>Liên hệ</td><td>Khoảng 7,2 – 11,6 tỷ</td></tr>
</tbody>
</table>
<p>Quy đổi theo tin rao, mặt bằng khoảng 60 – 90 triệu/m². Với căn tầng thấp hoặc hướng phụ, mức thấp của khoảng giá thường là căn chuyển nhượng; căn view biển tầng cao nằm ở mức trên.</p>

<h2>Newtown Legend – biệt thự và shophouse view golf</h2>
<p><a href="/du-an/newtown-legend/">Newtown Legend</a> là phân khu thấp tầng của tổ hợp, gồm 60 căn: 24 biệt thự (22 song lập, 2 đơn lập) cao 3 tầng và 1 tầng hầm, cùng 36 shophouse 4 tầng. Đây là số ít sản phẩm thấp tầng sở hữu lâu dài trên trục biển Trường Sa.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Quy mô</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Premier Shop Residence (shophouse)</td><td>Đất khoảng 140 m², 4 tầng, sàn khoảng 379 m²</td><td>Từ khoảng 20 tỷ</td></tr>
<tr><td>Golfside Shop Villa</td><td>Biệt thự kết hợp kinh doanh</td><td>Từ khoảng 42 tỷ</td></tr>
<tr><td>Grand Golf Villa</td><td>3 tầng + 1 hầm, sàn 416 – 485 m²</td><td>Từ khoảng 50 tỷ</td></tr>
</tbody>
</table>

<h2>Tiện ích dùng chung</h2>
<ul>
<li>Khối đế 6 tầng trung tâm thương mại, khoảng 48.000 – 50.000 m² sàn.</li>
<li>Hai hồ bơi vô cực tầng 6, gym, spa, Sky Bar & Café, vườn trên mái.</li>
<li>Khu BBQ, yoga, vườn thiền, khu vui chơi trẻ em, nhà trẻ.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp: chọn tòa nào?</h2>
<p>Nếu cần nhận nhà sớm để ở hoặc cho thuê, The Ruby là lựa chọn đáng cân nhắc nhất vì đã cất nóc. Nếu muốn dòng tiền nhẹ hơn theo tiến độ, có thể xem The Sapphire hoặc The Diamond. Khách tài chính lớn, cần tài sản thấp tầng giữ giá dài hạn nên xem Newtown Legend, đặc biệt shophouse mặt trục Trường Sa.</p>
<p>Anh chị có thể so sánh thêm với các dự án khác cùng khu vực trong bài <a href="/bat-dong-san-ngu-hanh-son-2026/">bất động sản Ngũ Hành Sơn 2026</a> hoặc danh sách <a href="/loai-du-an/can-ho-so-huu-lau-dai/">căn hộ sở hữu lâu dài Đà Nẵng</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá từng tòa Newtown Diamond, quỹ căn đang bán và lịch xem biệt thự mẫu Newtown Legend.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Newtown Diamond: 3 tòa căn hộ và Newtown Legend',
			'desc'      => 'Newtown Diamond Đà Nẵng: 3 tòa The Ruby, The Sapphire, The Diamond (1.733 căn), Newtown Legend 60 căn thấp tầng, giá tham khảo 2026. Gọi Hoàng Hiệp.',
			'points'    => array(
				'3 tòa 36 tầng, 1.733 căn hộ sở hữu lâu dài; The Ruby cất nóc 18/4/2026',
				'Căn 1PN khoảng 3,5 – 3,9 tỷ, 2PN khoảng 5,7 – 7,5 tỷ (tham khảo)',
				'Newtown Legend: 24 biệt thự, 36 shophouse view golf, từ khoảng 20 tỷ',
			),
			'faq'       => array(
				array( 'Newtown Diamond có mấy tòa?', 'Tổ hợp có 3 tòa căn hộ 36 tầng: The Ruby (829 căn), The Sapphire (510 căn) và The Diamond (394 căn), cùng phân khu thấp tầng Newtown Legend.' ),
				array( 'Giá căn hộ Newtown Diamond bao nhiêu?', 'Tham khảo năm 2026: căn 1PN khoảng 3,5 – 3,9 tỷ, căn 2PN khoảng 5,7 – 7,5 tỷ; căn 3PN liên hệ. Giá thay đổi theo tòa, tầng và view.' ),
				array( 'Newtown Diamond có sổ hồng lâu dài không?', 'Có. Căn hộ và sản phẩm thấp tầng Newtown Legend đều được giới thiệu là sở hữu lâu dài, sổ hồng từng căn.' ),
				array( 'Newtown Legend có những sản phẩm nào?', 'Gồm 24 biệt thự (22 song lập, 2 đơn lập) và 36 shophouse 4 tầng, view sân golf 36 lỗ; shophouse từ khoảng 20 tỷ, biệt thự từ khoảng 42 – 50 tỷ.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/newtown-diamond-cat-noc-toa-can-ho-dau-tien-5065074.html',
			'https://cafef.vn/newtown-diamond-tam-diem-thu-hut-nha-dau-tu-tai-da-nang-188260121105200071.chn',
			'https://vn.savills.com.vn/residential/da-nang-projects/newtown-diamond.aspx',
			'https://tienphong.vn/newtown-legend-da-nang-tai-san-blue-chip-tai-toa-do-di-san-post1880313.tpo',
		),
	);

	$posts[] = array(
		'slug'     => 'biet-thu-ven-bien-da-nang-hoi-an-bang-gia',
		'title'    => 'Biệt thự ven biển Đà Nẵng – Hội An: bảng giá theo từng dự án 2026',
		'excerpt'  => 'Bảng giá biệt thự ven biển Đà Nẵng – Hội An 2026: Furama Villas, The Ocean Villas, Hyatt, Premier Village, Newtown Legend, Vinhomes Hải Vân Bay, Hoiana.',
		'keyword'  => 'biệt thự ven biển Đà Nẵng',
		'project'  => '',
		'week'     => 9,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Biệt thự ven biển Đà Nẵng</strong> năm 2026 có mặt bằng giá rất rộng: từ khoảng 10 – 16 tỷ với biệt thự song lập dự án mới ở phía Bắc, đến 21 – 83 tỷ với biệt thự nghỉ dưỡng đã vận hành trên trục Võ Nguyên Giáp – Trường Sa. Bài viết tổng hợp bảng giá theo từng dự án từ Sơn Trà, Ngũ Hành Sơn đến Hội An, cập nhật tháng 10/2026.</p>

<h2>Bảng giá biệt thự ven biển Đà Nẵng theo dự án</h2>
<p>Giá chuyển nhượng là khoảng giá tổng hợp từ tin rao công khai năm 2026, không phải giá chốt; giá dự án mới là giá tham khảo của đơn vị phân phối.</p>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Quy mô / diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Furama Villas</td><td>Ngũ Hành Sơn</td><td>134 biệt thự, đất 280 – 980 m²</td><td>Khoảng 21 – 40 tỷ (3 – 4PN)</td></tr>
<tr><td>The Ocean Villas</td><td>Ngũ Hành Sơn</td><td>114 biệt thự đơn lập, đất 500 – 808 m²</td><td>Khoảng 28,5 – 70 tỷ</td></tr>
<tr><td>Fusion Resort & Villas</td><td>Ngũ Hành Sơn</td><td>Đất khoảng 486 – 700 m²</td><td>Khoảng 32 – 54 tỷ</td></tr>
<tr><td>Hyatt Regency Residences & Villas</td><td>Ngũ Hành Sơn</td><td>27 biệt thự</td><td>3PN đất 600 m² khoảng 50 tỷ</td></tr>
<tr><td>The Ocean Estates</td><td>Ngũ Hành Sơn</td><td>33 biệt thự, đất 929 – 1.303 m²</td><td>Từ khoảng 52 tỷ; 5PN khoảng 83 tỷ</td></tr>
<tr><td>Newtown Legend</td><td>Ngũ Hành Sơn</td><td>24 biệt thự, 36 shophouse</td><td>Shop villa từ khoảng 42 tỷ, biệt thự từ khoảng 50 tỷ</td></tr>
<tr><td>Naman Residences</td><td>Ngũ Hành Sơn</td><td>34 biệt thự, đất 380 – 935 m²</td><td>Giá mở bán từ khoảng 10,9 tỷ (nguồn phân phối)</td></tr>
<tr><td>Premier Village</td><td>Sơn Trà</td><td>Biệt thự resort trên biển Mỹ Khê</td><td>Khoảng 39 – 47 tỷ trở lên</td></tr>
<tr><td>Vinhomes Hải Vân Bay</td><td>Liên Chiểu</td><td>Song lập 140 – 207 m², đơn lập 200 – 400 m²</td><td>Song lập 9,9 – 16,8 tỷ; đơn lập 15 – 50 tỷ (dự kiến)</td></tr>
<tr><td>Montgomerie Links Villas</td><td>Điện Bàn</td><td>54 biệt thự, đất 350 – 700 m²</td><td>Giá bán gốc 820.000 – 1,6 triệu USD; chuyển nhượng liên hệ</td></tr>
</tbody>
</table>

<h2>Trục Võ Nguyên Giáp – Trường Sa: biệt thự resort đã vận hành</h2>
<p>Đây là nhóm có giá cao nhất vì nằm trong các khu nghỉ dưỡng thương hiệu: <a href="/du-an/furama-villas-da-nang/">Furama Villas</a>, <a href="/du-an/the-ocean-villas-da-nang/">The Ocean Villas</a>, Fusion, Hyatt Regency, The Ocean Estates. Ưu điểm là đã hoàn thiện, có dịch vụ vận hành và lịch sử cho thuê để kiểm chứng.</p>
<p>Điểm cần kiểm tra là hợp đồng vận hành với khu nghỉ dưỡng, thời hạn sử dụng đất của từng căn và chi phí bảo trì hằng năm. Giá chênh mạnh giữa căn mặt biển, căn view golf và căn phía trong.</p>

<h2>Biệt thự dự án mới: Newtown Legend và Vinhomes Hải Vân Bay</h2>
<p><a href="/du-an/newtown-legend/">Newtown Legend</a> có lợi thế sở hữu lâu dài ngay trên trục Trường Sa, quỹ căn rất ít. <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a> ở vịnh Nam Chơn có giá đầu vào thấp hơn nhiều, biệt thự song lập Bạch Vân khoảng 9,9 – 16,8 tỷ, kèm chính sách thanh toán theo tiến độ – phù hợp khách muốn tích lũy dài hạn và chấp nhận chờ hạ tầng phía Bắc hoàn thiện.</p>

<h2>Biệt thự biển Hội An – Điện Bàn</h2>
<p>Phía Nam, thị trường có Hoiana Beach Villas (198 biệt thự biển 3 – 9 phòng ngủ trên 36,6 ha, dự kiến bàn giao quý 1/2028), Hoiana Shores Golf Villas (88 biệt thự sân golf, đất 710 – 1.500 m²), Four Seasons The Nam Hai (40 biệt thự sở hữu có hồ bơi riêng) và Shilla Monogram (34 biệt thự 3 tầng hướng biển). Phần lớn các dự án này chưa công bố giá công khai hoặc chỉ giao dịch theo từng căn – liên hệ để nhận bảng giá.</p>

<h2>Kinh nghiệm chọn biệt thự ven biển</h2>
<h3>Xác định mục đích trước khi xem giá</h3>
<p>Mua để nghỉ dưỡng gia đình nên ưu tiên căn đã hoàn thiện, có dịch vụ quản lý. Mua để giữ tài sản nên ưu tiên pháp lý sở hữu lâu dài và quỹ đất hiếm. Mua để cho thuê cần xem số liệu doanh thu thực tế, không chỉ cam kết trên giấy.</p>
<h3>Kiểm tra pháp lý từng căn</h3>
<p>Biệt thự trong khu nghỉ dưỡng có thể là đất ở lâu dài hoặc đất thương mại dịch vụ có thời hạn. Hai loại này khác nhau rất lớn về giá trị thế chấp và thanh khoản khi bán lại.</p>

<p>Xem thêm danh sách <a href="/mua-ban/biet-thu/">biệt thự đang bán tại Đà Nẵng</a> và các <a href="/loai-du-an/biet-thu/">dự án biệt thự Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách biệt thự ven biển đang bán thật, kèm pháp lý và giá chốt gần nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Biệt thự ven biển Đà Nẵng: bảng giá theo dự án 2026',
			'desc'      => 'Biệt thự ven biển Đà Nẵng – Hội An 2026: bảng giá Furama Villas, The Ocean Villas, Newtown Legend, Vinhomes Hải Vân Bay… Liên hệ Hoàng Hiệp để xem căn.',
			'points'    => array(
				'Biệt thự resort trục Võ Nguyên Giáp – Trường Sa khoảng 21 – 83 tỷ (tin rao)',
				'Dự án mới: Vinhomes Hải Vân Bay song lập 9,9 – 16,8 tỷ; Newtown Legend từ khoảng 42 tỷ',
				'Cần kiểm tra thời hạn đất và hợp đồng vận hành trước khi mua',
			),
			'faq'       => array(
				array( 'Biệt thự ven biển Đà Nẵng giá bao nhiêu?', 'Năm 2026, biệt thự resort đã vận hành trên trục Võ Nguyên Giáp – Trường Sa phổ biến khoảng 21 – 83 tỷ; biệt thự song lập dự án mới phía Bắc từ khoảng 9,9 tỷ.' ),
				array( 'Biệt thự ven biển nào có sổ lâu dài?', 'Newtown Legend và phần lớn sản phẩm thấp tầng Vinhomes Hải Vân Bay được giới thiệu là sở hữu lâu dài. Biệt thự trong resort cần kiểm tra pháp lý từng căn.' ),
				array( 'Nên mua biệt thự đã vận hành hay dự án mới?', 'Biệt thự đã vận hành có dòng tiền và chất lượng kiểm chứng được; dự án mới có giá đầu vào thấp hơn và chính sách thanh toán giãn nhưng phải chờ hạ tầng.' ),
			),
		),
		'sources'  => array(
			'https://furamavietnam.com/furama-villas/',
			'https://alonhadat.com.vn/du-an-khu-biet-thu-the-ocean-villas-pj938',
			'https://homedy.com/the-ocean-estates-pj97559495',
			'https://market.vinhomes.vn/blog/biet-thu-song-lap-vinhomes-hai-van-bay-5-ly-do-nen-dau-tu-2026',
		),
	);

	$posts[] = array(
		'slug'     => 'gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa',
		'title'    => 'Giá đất ven biển Đà Nẵng 2026: Võ Nguyên Giáp, Hoàng Sa, Trường Sa',
		'excerpt'  => 'Giá đất ven biển Đà Nẵng 2026: Võ Nguyên Giáp khoảng 150 – 400 triệu/m², Hoàng Sa 170 – 450 triệu/m², Trường Sa 60 – 130 triệu/m² (tham khảo tin rao).',
		'keyword'  => 'giá đất ven biển Đà Nẵng',
		'project'  => '',
		'week'     => 9,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Giá đất ven biển Đà Nẵng</strong> năm 2026 trên trục Võ Nguyên Giáp chào bán khoảng 150 – 400 triệu/m², đường Hoàng Sa khoảng 170 – 450 triệu/m², còn Trường Sa phía Nam mềm hơn, khoảng 60 – 130 triệu/m². Các mức này tổng hợp từ tin rao lô đất lớn, phù hợp xây khách sạn, căn hộ dịch vụ; cập nhật tháng 10/2026.</p>

<h2>Bảng giá đất ven biển Đà Nẵng theo tuyến đường</h2>
<table>
<thead><tr><th>Tuyến đường</th><th>Diện tích phổ biến</th><th>Giá chào bán tham khảo</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Võ Nguyên Giáp (Sơn Trà – Ngũ Hành Sơn)</td><td>280 – 900 m²</td><td>Khoảng 150 – 400 triệu/m²</td><td>Lô 280 m² ngang 14 m rao khoảng 108 tỷ</td></tr>
<tr><td>Hoàng Sa (Sơn Trà)</td><td>600 – 1.000 m²</td><td>Khoảng 170 – 450 triệu/m²</td><td>Lô 1.000 m² khoảng 170 tỷ; lô 600 m² ngang 30 m khoảng 240 tỷ</td></tr>
<tr><td>Trường Sa (Ngũ Hành Sơn)</td><td>500 – 1.000 m²</td><td>Khoảng 60 – 130 triệu/m²</td><td>Lô góc 500 m² khoảng 65 tỷ</td></tr>
<tr><td>Võ Văn Kiệt (Sơn Trà)</td><td>400 – 800 m²</td><td>Khoảng 310 – 400 triệu/m²</td><td>Cách biển khoảng 300 m, một số lô có phép xây 17 tầng</td></tr>
<tr><td>Phạm Văn Đồng (Sơn Trà)</td><td>250 – 825 m²</td><td>Khoảng 190 – 280 triệu/m²</td><td>Lô 777 m² khoảng 150 tỷ</td></tr>
<tr><td>Nguyễn Tất Thành (Liên Chiểu)</td><td>375 – 900 m²</td><td>Khoảng 65 – 135 triệu/m²</td><td>Lô 479 m² mặt biển khoảng 65 tỷ</td></tr>
<tr><td>Lạc Long Quân (Điện Bàn)</td><td>1.000 – 4.000 m²</td><td>Khoảng 16 – 30 triệu/m²</td><td>Quỹ đất resort, villa nghỉ dưỡng</td></tr>
</tbody>
</table>
<p>Lưu ý: đây là giá chào trên tin rao, thường còn biên độ thương lượng. Giá thực tế phụ thuộc mặt tiền, hình dáng lô, quy hoạch tầng cao và pháp lý.</p>

<h2>Võ Nguyên Giáp – trục biển đắt giá nhất</h2>
<p>Võ Nguyên Giáp chạy dọc bãi biển Mỹ Khê, quy hoạch cao tầng, tập trung khách sạn 4 – 5 sao. Theo bảng giá đất nhà nước năm 2026, tuyến này khoảng 220 – 280 triệu/m² tùy đoạn; tin rao một lô 826 m² ở khu An Thượng khoảng 200 triệu/m².</p>
<p>Lô mặt tiền ngang 14 m trở lên được săn đón vì đủ điều kiện xây khách sạn quy mô vừa. Lô hẹp, nở hậu hoặc vướng chỉ giới xây dựng thường có giá thấp hơn đáng kể.</p>

<h2>Hoàng Sa – mặt biển phía bán đảo Sơn Trà</h2>
<p>Hoàng Sa nối dài trục biển lên phía bán đảo Sơn Trà, lô đất diện tích lớn 600 – 1.000 m², quy hoạch xây cao tầng. Biên độ giá rộng (170 – 450 triệu/m²) vì khác biệt về mặt tiền, vị trí góc và khoảng cách tới khu phố du lịch.</p>

<h2>Trường Sa – giá mềm hơn, gần các resort lớn</h2>
<p>Đoạn Trường Sa ở Ngũ Hành Sơn có giá khoảng 60 – 130 triệu/m², thấp hơn rõ so với Võ Nguyên Giáp phía Bắc. Khu vực này tập trung resort và dự án lớn như <a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a>, phù hợp nhà đầu tư dài hạn chấp nhận mật độ dân cư thấp hơn.</p>

<h2>Đất ven biển nên mua để làm gì?</h2>
<h3>Xây khách sạn, căn hộ dịch vụ</h3>
<p>Phù hợp lô 280 m² trở lên trên Võ Nguyên Giáp, Hoàng Sa, Phạm Văn Đồng. Cần tính tổng vốn gồm tiền đất, chi phí xây dựng, thời gian xin phép và vận hành. Tham khảo thêm bài <a href="/ban-khach-san-da-nang-ven-bien-gia-cong-suat/">giá và công suất khách sạn ven biển Đà Nẵng</a> để so sánh mua đất tự xây với mua khách sạn đang chạy.</p>
<h3>Giữ tài sản dài hạn</h3>
<p>Quỹ đất mặt biển Đà Nẵng có hạn, nhưng giá đã ở mức cao. Người mua giữ tài sản nên ưu tiên lô pháp lý sạch, quy hoạch rõ, tránh lô có tranh chấp hoặc chưa xác định được chiều cao xây dựng.</p>

<h2>Checklist trước khi đặt cọc đất ven biển</h2>
<ul>
<li>Xin thông tin quy hoạch: tầng cao, mật độ, khoảng lùi.</li>
<li>Kiểm tra sổ, mục đích sử dụng đất, thời hạn và hiện trạng thế chấp.</li>
<li>So sánh giá với bảng giá nhà nước và các giao dịch cùng đoạn đường.</li>
<li>Đối với lô kèm giấy phép xây dựng, kiểm tra hiệu lực giấy phép.</li>
</ul>

<p>Xem danh sách <a href="/mua-ban/dat-nen/">đất nền, đất ở đang bán tại Đà Nẵng</a> hoặc trang <a href="/khu-vuc/son-tra/">bất động sản Sơn Trà</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách lô đất ven biển đang bán thật và hỗ trợ kiểm tra quy hoạch từng lô.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá đất ven biển Đà Nẵng 2026: Võ Nguyên Giáp, Hoàng Sa',
			'desc'      => 'Giá đất ven biển Đà Nẵng 2026 theo tuyến: Võ Nguyên Giáp, Hoàng Sa, Trường Sa, Võ Văn Kiệt, Nguyễn Tất Thành. Gọi Hoàng Hiệp để nhận lô đang bán.',
			'points'    => array(
				'Võ Nguyên Giáp khoảng 150 – 400 triệu/m²; Hoàng Sa khoảng 170 – 450 triệu/m² (tin rao)',
				'Trường Sa mềm hơn, khoảng 60 – 130 triệu/m²; Nguyễn Tất Thành khoảng 65 – 135 triệu/m²',
				'Bảng giá nhà nước 2026 trục Võ Nguyên Giáp khoảng 220 – 280 triệu/m²',
			),
			'faq'       => array(
				array( 'Giá đất ven biển Võ Nguyên Giáp bao nhiêu?', 'Tin rao năm 2026 khoảng 150 – 400 triệu/m² tùy đoạn và mặt tiền; bảng giá nhà nước khoảng 220 – 280 triệu/m².' ),
				array( 'Đất ven biển Đà Nẵng ở đâu giá mềm nhất?', 'Trong nội thành, Trường Sa (Ngũ Hành Sơn) và Nguyễn Tất Thành (Liên Chiểu) có mặt bằng thấp hơn, khoảng 60 – 135 triệu/m²; ven biển Điện Bàn khoảng 16 – 30 triệu/m².' ),
				array( 'Mua đất ven biển cần kiểm tra gì?', 'Quy hoạch tầng cao, mục đích và thời hạn sử dụng đất, hiện trạng thế chấp, hiệu lực giấy phép xây dựng (nếu có).' ),
			),
		),
		'sources'  => array(
			'https://guland.vn/bang-gia-dat/da-nang/thanh-pho-da-nang-cu-da-nang/vo-nguyen-giap',
			'https://batdongsan.com.vn/ban-dat-duong-hoang-sa-49',
			'https://batdongsan.com.vn/ban-dat-duong-vo-van-kiet-49',
			'https://www.nhatot.com/tags/mua-ban-dat-duong-nguyen-tat-thanh-da-nang',
		),
	);

	$posts[] = array(
		'slug'     => 'ban-khach-san-da-nang-ven-bien-gia-cong-suat',
		'title'    => 'Bán khách sạn Đà Nẵng ven biển: mặt bằng giá và công suất 2026',
		'excerpt'  => 'Bán khách sạn Đà Nẵng ven biển 2026: boutique Võ Nguyên Giáp khoảng 48 – 90 tỷ, An Thượng 28 – 125 tỷ; công suất 4 – 5 sao quý I khoảng 85 – 88%.',
		'keyword'  => 'bán khách sạn Đà Nẵng',
		'project'  => '',
		'week'     => 9,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Thị trường <strong>bán khách sạn Đà Nẵng</strong> ven biển năm 2026 có giá chào từ khoảng 28 – 125 tỷ cho khách sạn nhỏ ở phố An Thượng, 48 – 90 tỷ cho boutique mặt biển Võ Nguyên Giáp, đến 650 – 1.350 tỷ cho khách sạn 4 sao quy mô lớn. Công suất phòng khách sạn 4 – 5 sao quý I/2026 đạt khoảng 85 – 88%. Bài viết cập nhật tháng 10/2026.</p>

<h2>Bảng giá bán khách sạn Đà Nẵng theo khu vực</h2>
<table>
<thead><tr><th>Khu vực</th><th>Quy mô điển hình</th><th>Giá chào tham khảo</th></tr></thead>
<tbody>
<tr><td>Võ Nguyên Giáp – boutique mặt biển</td><td>140 m² đất, 7 – 12 tầng, 26 – 52 phòng</td><td>Khoảng 48 – 90 tỷ</td></tr>
<tr><td>Võ Nguyên Giáp – 4 sao quy mô lớn</td><td>500 – 900 m² đất, 84 – 165 phòng</td><td>Khoảng 650 – 1.350 tỷ</td></tr>
<tr><td>An Thượng (phố Tây Mỹ Khê)</td><td>80 – 300 m² đất, 16 – 40 phòng</td><td>Khoảng 28 – 125 tỷ</td></tr>
<tr><td>Trần Bạch Đằng – Đỗ Bá (Mỹ An)</td><td>155 – 300 m² đất, 40 – 57 phòng</td><td>Khoảng 75 – 170 tỷ</td></tr>
<tr><td>Hồ Nghinh (Sơn Trà)</td><td>100 – 300 m² đất, 16 – 40 phòng</td><td>Khoảng 30 – 100 tỷ</td></tr>
<tr><td>Phạm Văn Đồng (Sơn Trà)</td><td>Khoảng 340 m² đất, 81 phòng</td><td>Khoảng 165 tỷ</td></tr>
<tr><td>Hội An – An Bàng, Tân Thành</td><td>650 – 1.600 m² đất, 20 – 39 phòng</td><td>Khoảng 50 – 91 tỷ</td></tr>
</tbody>
</table>
<p>Số liệu tổng hợp từ tin rao năm 2026, giá chào thường còn biên độ thương lượng. Đây không phải danh sách căn cụ thể.</p>

<h2>Công suất phòng: con số cần đọc đúng</h2>
<p>Theo báo cáo thị trường công khai, công suất phòng khách sạn 4 – 5 sao tại Đà Nẵng quý I/2026 đạt khoảng 85 – 88%. Một số tin rao khách sạn 52 phòng trên Võ Nguyên Giáp nêu công suất mùa cao điểm khoảng 95%.</p>
<p>Tuy nhiên, công suất mùa cao điểm khác xa công suất trung bình năm. Khi xem hồ sơ, Hoàng Hiệp khuyên anh chị yêu cầu số liệu theo từng tháng trong ít nhất 12 tháng, kèm giá phòng bình quân, để tính doanh thu thực.</p>

<h2>Doanh thu tham khảo từ tin rao</h2>
<ul>
<li>Khách sạn 16 phòng ở An Thượng, doanh thu khoảng 300 triệu/tháng, rao khoảng 28 tỷ.</li>
<li>Khách sạn có hồ bơi trên Hồ Nghinh, doanh thu khoảng 600 triệu/tháng, rao khoảng 99 tỷ.</li>
<li>Khách sạn 6 tầng khu Phạm Thiều cho thuê nguyên tòa khoảng 280 triệu/tháng, rao khoảng 65 tỷ.</li>
</ul>
<p>Doanh thu là số do người bán công bố, chưa trừ chi phí nhân sự, điện nước, OTA, bảo trì. Cần đối chiếu sổ sách, hóa đơn và thuế trước khi định giá.</p>

<h2>Mua khách sạn đang chạy hay mua đất tự xây?</h2>
<h3>Mua khách sạn đang kinh doanh</h3>
<p>Ưu điểm: có dòng tiền ngay, kiểm chứng được doanh thu, giấy phép kinh doanh lưu trú đã có. Nhược điểm: phải tính chi phí cải tạo nếu công trình đã cũ, và giá thường đã bao gồm phần lợi thế kinh doanh.</p>
<h3>Mua đất xây mới</h3>
<p>Chủ động thiết kế, hạng sao, nhưng mất thời gian xin phép và xây dựng, rủi ro chi phí phát sinh. Mặt bằng giá đất các trục biển có trong bài <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>.</p>

<h2>Khu vực nào hợp với loại khách sạn nào?</h2>
<p>Phố An Thượng phù hợp khách sạn nhỏ 16 – 40 phòng phục vụ khách quốc tế tự túc, vốn vừa phải, dễ vận hành. Trục Võ Nguyên Giáp phù hợp boutique mặt biển hoặc khách sạn 4 sao, giá phòng cao nhưng vốn lớn. Khu Mỹ An, Trần Bạch Đằng cách biển 150 – 300 m, cân bằng giữa giá mua và giá phòng.</p>
<p>Ở Hội An, khu An Bàng – Tân Thành phù hợp villa, khách sạn thấp tầng trên diện tích đất rộng, phục vụ khách lưu trú dài ngày. Anh chị có thể xem thêm thị trường <a href="/khu-vuc/hoi-an/">bất động sản Hội An</a> nếu muốn mô hình nghỉ dưỡng thay vì khách sạn phố biển.</p>

<h2>Checklist khi mua khách sạn ven biển</h2>
<ul>
<li>Sổ đất, giấy phép xây dựng, hoàn công đúng số tầng thực tế.</li>
<li>Giấy chứng nhận PCCC, giấy phép kinh doanh lưu trú, hạng sao (nếu có).</li>
<li>Doanh thu 12 tháng, công suất theo tháng, giá phòng bình quân.</li>
<li>Hợp đồng lao động, hợp đồng thuê, hợp đồng OTA đang hiệu lực.</li>
<li>Tình trạng kết cấu, thang máy, hệ thống điện nước.</li>
</ul>

<p>Anh chị có thể xem các <a href="/mua-ban/khach-san/">khách sạn đang bán tại Đà Nẵng</a> hoặc nhóm <a href="/khu-vuc/son-tra/">bất động sản Sơn Trà</a> nơi tập trung nhiều khách sạn ven biển. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách khách sạn đang bán thật, kèm số liệu vận hành để thẩm định.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bán khách sạn Đà Nẵng ven biển: giá và công suất 2026',
			'desc'      => 'Bán khách sạn Đà Nẵng ven biển 2026: giá theo khu Võ Nguyên Giáp, An Thượng, Hồ Nghinh, Hội An, công suất 85 – 88%. Gọi Hoàng Hiệp để xem hồ sơ.',
			'points'    => array(
				'Boutique mặt biển Võ Nguyên Giáp khoảng 48 – 90 tỷ; An Thượng khoảng 28 – 125 tỷ',
				'Công suất 4 – 5 sao quý I/2026 khoảng 85 – 88% (báo cáo công khai)',
				'Thẩm định doanh thu 12 tháng, PCCC, hoàn công trước khi xuống tiền',
			),
			'faq'       => array(
				array( 'Giá khách sạn ven biển Đà Nẵng bao nhiêu?', 'Tham khảo tin rao 2026: khách sạn nhỏ phố An Thượng khoảng 28 – 125 tỷ, boutique mặt biển Võ Nguyên Giáp khoảng 48 – 90 tỷ, 4 sao quy mô lớn khoảng 650 – 1.350 tỷ.' ),
				array( 'Công suất phòng khách sạn Đà Nẵng hiện nay?', 'Khách sạn 4 – 5 sao quý I/2026 đạt khoảng 85 – 88% theo báo cáo thị trường; công suất trung bình năm thường thấp hơn mùa cao điểm.' ),
				array( 'Mua khách sạn cần kiểm tra giấy tờ gì?', 'Sổ đất, giấy phép xây dựng và hoàn công, PCCC, giấy phép kinh doanh lưu trú, sổ sách doanh thu và các hợp đồng đang hiệu lực.' ),
			),
		),
		'sources'  => array(
			'https://cafef.vn/bds-da-nang-2026-phan-hoa-manh-de-thanh-loc-thi-truong-188260615112835053.chn',
			'https://www.nhadatdanang.asia/2026/05/ban-khach-san-uong-vo-nguyen-giap-bien.html',
			'https://www.nhadatdanang.asia/2026/07/ban-khach-san-uong-ho-nghinh-gan-toa.html',
			'https://homedy.com/ban-khach-san-da-nang/gia-tu-30-ty-den-40-ty',
		),
	);

	$posts[] = array(
		'slug'     => 'vinhomes-hai-van-bay-cap-nhat-2026',
		'title'    => 'Vinhomes Hải Vân Bay: cập nhật 2026 – phân khu, giá, tiến độ',
		'excerpt'  => 'Vinhomes Hải Vân Bay cập nhật 2026: Bạch Vân mở bán 4/2026, Đảo Ngọc ra mắt 5/2026, Vịnh Mây 99,6 ha; giá liền kề từ khoảng 5,2 tỷ, tiến độ bàn giao.',
		'keyword'  => 'Vinhomes Hải Vân Bay',
		'project'  => 'vinhomes-hai-van-bay',
		'week'     => 9,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Vinhomes Hải Vân Bay</strong> (Làng Vân) là đô thị nghỉ dưỡng 512,2 ha tại vịnh Nam Chơn, chân đèo Hải Vân (Liên Chiểu, Đà Nẵng), do Vinpearl làm chủ đầu tư. Sau lễ ra mắt ngày 20/4/2026 với phân khu Bạch Vân, dự án đã giới thiệu tiếp Đảo Ngọc (5/2026) và Vịnh Mây (cuối tháng 9/2026). Giá liền kề tham khảo từ khoảng 5,2 tỷ; bài viết cập nhật tháng 10/2026.</p>

<h2>Mốc chính của Vinhomes Hải Vân Bay</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Sự kiện</th></tr></thead>
<tbody>
<tr><td>20/11/2024</td><td>Điều chỉnh chủ trương đầu tư: 512 ha, gần 44.000 tỷ đồng, thực hiện 5 năm</td></tr>
<tr><td>22/6/2025</td><td>Khởi công Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân</td></tr>
<tr><td>20/4/2026</td><td>Vinhomes ra mắt dự án, mở bán phân khu Bạch Vân</td></tr>
<tr><td>5/2026</td><td>Ra mắt phân khu Đảo Ngọc</td></tr>
<tr><td>Cuối 9/2026</td><td>Giới thiệu phân khu Vịnh Mây</td></tr>
<tr><td>Quý 4/2026</td><td>Hoàn thiện thô khoảng 345 căn đầu tiên tại Bạch Vân (dự kiến)</td></tr>
<tr><td>Từ 2027</td><td>Bàn giao giai đoạn 1 (dự kiến)</td></tr>
</tbody>
</table>

<h2>4 phân khu: Bạch Vân, Đảo Ngọc, Vịnh Mây, Tinh Vân</h2>
<h3>Bạch Vân – phân khu mở bán đầu tiên</h3>
<p>Rộng khoảng 112 ha ở cửa ngõ dự án, khoảng 2.500 căn thấp tầng gồm liền kề, hơn 400 shophouse, biệt thự song lập, đơn lập và khối cao tầng dự kiến. Đây là phân khu có tiến độ thi công nhanh nhất.</p>
<h3>Đảo Ngọc – biệt thự trên đảo giữa vịnh</h3>
<p>Đảo nhân tạo phong cách Costa Smeralda (Ý), khoảng 2.376 căn thấp tầng, chủ yếu biệt thự. Theo báo chí, Đảo Ngọc ghi nhận gần 1.000 lượt đặt chỗ trong 72 giờ trước khi ra mắt. Giá dự kiến biệt thự Đảo Ngọc khoảng 14,9 – 44 tỷ theo các đơn vị phân phối.</p>
<h3>Vịnh Mây – dinh thự sườn đồi</h3>
<p>Vịnh Mây rộng khoảng 99,6 ha trên triền núi Hải Vân, khoảng 690 biệt thự và nhà phố phong cách Malibu, mật độ xây dựng khoảng 19,8%. Các căn trải trên nhiều cao độ, từ khoảng 4,8 m đến 187,5 m so với mực nước biển, nên mỗi vị trí có hướng nhìn vịnh khác nhau. Bảng giá Vịnh Mây đang cập nhật theo từng đợt, liên hệ để nhận bảng giá.</p>
<h3>Tinh Vân</h3>
<p>Phân khu phong cách Nhật Bản, quỹ căn giới hạn, chưa có thông tin giá công khai.</p>

<h2>Bảng giá Vinhomes Hải Vân Bay tham khảo</h2>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề Bạch Vân (4 tầng)</td><td>63 – 100 m²</td><td>Khoảng 5,2 – 10,4 tỷ</td></tr>
<tr><td>Biệt thự song lập Bạch Vân</td><td>140 – 160 m²</td><td>Khoảng 9,9 – 16,8 tỷ</td></tr>
<tr><td>Biệt thự song lập Đảo Ngọc</td><td>197 – 207 m²</td><td>Khoảng 14,9 – 15,6 tỷ (dự kiến)</td></tr>
<tr><td>Biệt thự đơn lập</td><td>200 – 400 m²</td><td>Khoảng 15 – 50 tỷ (dự kiến)</td></tr>
<tr><td>Shophouse, căn hộ cao tầng</td><td>–</td><td>Liên hệ / chưa công bố</td></tr>
</tbody>
</table>
<p>Giá tổng hợp từ các đơn vị phân phối năm 2026, thay đổi theo đợt mở bán, vị trí và phương án thanh toán.</p>

<h2>Chính sách và pháp lý</h2>
<p>Các đợt bán năm 2026 áp dụng thanh toán theo tiến độ 15 – 18 tháng, ngân hàng cho vay đến 70%, hỗ trợ lãi suất 0% khoảng 24 tháng (liền kề, shophouse) hoặc 36 tháng (biệt thự). Chính sách thay đổi theo từng đợt; nhiều chương trình ưu đãi đã kết thúc vào cuối tháng 9/2026, nên anh chị cần hỏi chính sách hiện hành trước khi tính dòng tiền.</p>
<p>Hơn 90% sản phẩm thấp tầng nằm trên đất ở đô thị, được sở hữu lâu dài; condotel, khách sạn và shop khối đế trên đất thương mại – dịch vụ có thời hạn 50 năm.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Bạch Vân phù hợp khách muốn vốn đầu vào thấp và nhận nhà sớm nhất. Đảo Ngọc và Vịnh Mây hướng tới khách tài chính mạnh, ưu tiên không gian và tầm nhìn vịnh. Dự án hưởng lợi trực tiếp từ hạ tầng phía Tây Bắc như cảng Liên Chiểu – xem thêm bài <a href="/bat-dong-san-lien-chieu-cang-lien-chieu/">bất động sản Liên Chiểu và cảng Liên Chiểu</a>.</p>
<p>Thông tin chi tiết quỹ căn có tại trang <a href="/du-an/vinhomes-hai-van-bay/">dự án Vinhomes Hải Vân Bay</a>; so sánh với các <a href="/loai-du-an/biet-thu/">dự án biệt thự Đà Nẵng</a> khác. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá, chính sách mới nhất và bảng tính dòng tiền cho từng căn Vinhomes Hải Vân Bay.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Vinhomes Hải Vân Bay: cập nhật giá, phân khu 2026',
			'desc'      => 'Vinhomes Hải Vân Bay cập nhật 10/2026: Bạch Vân, Đảo Ngọc, Vịnh Mây, giá liền kề từ khoảng 5,2 tỷ, tiến độ bàn giao. Gọi Hoàng Hiệp nhận bảng giá.',
			'points'    => array(
				'512,2 ha tại vịnh Nam Chơn; ra mắt 20/4/2026, Đảo Ngọc 5/2026, Vịnh Mây cuối 9/2026',
				'Liền kề Bạch Vân khoảng 5,2 – 10,4 tỷ; song lập 9,9 – 16,8 tỷ (tham khảo)',
				'Hoàn thiện thô khoảng 345 căn Bạch Vân quý 4/2026, bàn giao từ 2027 (dự kiến)',
			),
			'faq'       => array(
				array( 'Vinhomes Hải Vân Bay có mấy phân khu?', 'Có 4 phân khu: Bạch Vân (mở bán đầu tiên), Đảo Ngọc, Vịnh Mây và Tinh Vân.' ),
				array( 'Giá Vinhomes Hải Vân Bay hiện nay bao nhiêu?', 'Tham khảo 2026: liền kề Bạch Vân khoảng 5,2 – 10,4 tỷ, song lập Bạch Vân khoảng 9,9 – 16,8 tỷ, biệt thự Đảo Ngọc dự kiến khoảng 14,9 – 44 tỷ.' ),
				array( 'Vịnh Mây Vinhomes Hải Vân Bay có gì?', 'Vịnh Mây rộng khoảng 99,6 ha trên sườn núi Hải Vân, khoảng 690 biệt thự và nhà phố, mật độ xây dựng khoảng 19,8%. Giá đang cập nhật theo từng đợt.' ),
				array( 'Khi nào Vinhomes Hải Vân Bay bàn giao?', 'Dự kiến hoàn thiện thô khoảng 345 căn đầu tiên tại Bạch Vân trong quý 4/2026 và bàn giao giai đoạn 1 từ năm 2027.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/ra-mat-khu-dao-ngoc-du-an-vinhomes-hai-van-bay-5070332.html',
			'https://dantri.com.vn/bat-dong-san/dao-ngoc-vinhomes-hai-van-bay-ghi-nhan-1000-luot-dat-cho-trong-72-gio-20260426110141706.htm',
			'https://tuoitre.vn/loi-the-kho-sao-chep-cua-dinh-co-suon-doi-vinh-may-100260916180730456.htm',
			'https://market.vinhomes.vn/blog/tien-do-vinhomes-hai-van-bay',
		),
	);

	/* ---------------------------------------------------------------- Tuần 10 */
	$posts[] = array(
		'slug'     => 'bat-dong-san-son-tra-2026',
		'title'    => 'Bất động sản Sơn Trà 2026: dự án, mặt bằng giá và khu vực nổi bật',
		'excerpt'  => 'Bất động sản Sơn Trà 2026: căn hộ ven sông Hàn, căn hộ biển Mỹ Khê, đất và khách sạn trục Võ Nguyên Giáp – danh sách dự án và giá tham khảo.',
		'keyword'  => 'bất động sản Sơn Trà',
		'project'  => '',
		'week'     => 10,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Sơn Trà</strong> năm 2026 là khu vực sôi động nhất Đà Nẵng, với hai trục chính: căn hộ ven sông Hàn (Trần Hưng Đạo, Lê Văn Duyệt) và căn hộ, khách sạn mặt biển Mỹ Khê (Võ Nguyên Giáp, Phạm Văn Đồng). Mặt bằng căn hộ phổ biến khoảng 50 – 125 triệu/m², căn hàng hiệu mặt biển cao hơn. Bài viết cập nhật tháng 10/2026.</p>

<h2>Vì sao bất động sản Sơn Trà được quan tâm?</h2>
<p>Sơn Trà có cả sông Hàn và biển Mỹ Khê, gần cầu Rồng và trung tâm Hải Châu, là nơi tập trung khách sạn và khách du lịch. Trung tâm tài chính quốc tế Đà Nẵng có các lô đất trên đường Võ Văn Kiệt, tạo thêm kỳ vọng cho nhu cầu thuê căn hộ cao cấp – xem bài <a href="/trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san/">trung tâm tài chính quốc tế Đà Nẵng</a>.</p>

<h2>Dự án căn hộ ven sông Hàn</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô</th><th>Giá tham khảo</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Sun Symphony Residence</td><td>1.313 căn hộ, 200 thấp tầng</td><td>Chuyển nhượng khoảng 69 – 125 triệu/m²</td><td>Đang bàn giao</td></tr>
<tr><td>Sun Ponte Residence</td><td>495 căn hộ, 7 penthouse</td><td>Khoảng 70 – 112 triệu/m²</td><td>Đang mở bán</td></tr>
<tr><td>Capital Square</td><td>14 tòa, 3.391 căn</td><td>Khoảng 74 – 90 triệu/m²</td><td>Đang mở bán</td></tr>
<tr><td>Peninsula Đà Nẵng</td><td>Khoảng 941 căn</td><td>Khoảng 50 – 83 triệu/m²</td><td>Đang mở bán</td></tr>
<tr><td>The Legend Đà Nẵng</td><td>Khoảng 800 căn, 444 phòng khách sạn</td><td>Liên hệ</td><td>Đang mở bán</td></tr>
<tr><td>HIYORI Aqua Tower</td><td>202 căn</td><td>Khoảng 55 – 75 triệu/m²</td><td>Dự kiến bàn giao quý 2/2027</td></tr>
<tr><td>The Camellia Sơn Trà</td><td>469 căn, 10 shop</td><td>Studio từ khoảng 1,98 tỷ</td><td>Dự kiến bàn giao quý 1/2028</td></tr>
<tr><td>Hiyori Garden Tower</td><td>Đã vận hành</td><td>2PN khoảng 5 – 6,7 tỷ</td><td>Đã bàn giao</td></tr>
</tbody>
</table>
<p>Nhóm Sun Group có thêm phân khu thấp tầng The Sonata (Sun Symphony) và The Rio (Sun Ponte) cho khách cần nhà phố, biệt thự ven sông.</p>

<h2>Dự án mặt biển Mỹ Khê</h2>
<ul>
<li><a href="/du-an/times-square-da-nang/">Times Square Đà Nẵng</a>: 560 căn hộ trên Võ Nguyên Giáp, studio/1PN khoảng 6,5 – 8,5 tỷ, 2PN khoảng 12 – 14 tỷ.</li>
<li><a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a>: tháp 43 tầng, 264 căn hàng hiệu, khoảng 145 – 205 triệu/m²; pháp lý sở hữu cần đối chiếu hợp đồng.</li>
<li>Wyndham Soleil Đà Nẵng: căn hộ khách sạn 50 năm, giá từ khoảng 2,95 tỷ.</li>
<li>Alizé Đà Nẵng: tòa căn hộ khách sạn 40 tầng của A&T Group, sắp mở bán.</li>
<li>Premier Village: biệt thự resort trên biển Mỹ Khê, khoảng 39 – 47 tỷ trở lên.</li>
</ul>

<h2>Đất và khách sạn Sơn Trà</h2>
<p>Đất mặt biển Võ Nguyên Giáp chào khoảng 150 – 400 triệu/m², Hoàng Sa khoảng 170 – 450 triệu/m², Võ Văn Kiệt khoảng 310 – 400 triệu/m², Phạm Văn Đồng khoảng 190 – 280 triệu/m². Khách sạn nhỏ ở An Thượng, Hồ Nghinh rao khoảng 28 – 125 tỷ. Chi tiết có trong bài <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>.</p>

<h2>Giá thuê căn hộ Sơn Trà</h2>
<table>
<thead><tr><th>Dự án</th><th>Giá thuê tham khảo</th></tr></thead>
<tbody>
<tr><td>Sun Ponte Residence</td><td>Studio 13 – 20 triệu; 1PN 20 – 30 triệu; 2PN 32 – 40 triệu/tháng</td></tr>
<tr><td>Peninsula Đà Nẵng</td><td>2PN khoảng 23 – 30 triệu/tháng</td></tr>
<tr><td>Hiyori Garden Tower</td><td>2PN phổ biến 18 – 21 triệu/tháng</td></tr>
<tr><td>Capital Square</td><td>1PN 18 – 25 triệu; 2PN 25 – 35 triệu/tháng (ước tính)</td></tr>
</tbody>
</table>

<h2>Rủi ro cần lưu ý khi mua ở Sơn Trà</h2>
<p>Nguồn cung căn hộ ven sông Hàn trong 2026 – 2028 khá lớn, đặc biệt các dự án quy mô hàng nghìn căn như Capital Square, Sun Symphony. Khi nhiều căn bàn giao cùng lúc, giá thuê có thể bị cạnh tranh, nên khách đầu tư cần tính dòng tiền thận trọng.</p>
<p>Với căn hộ khách sạn mặt biển, cần đọc kỹ thời hạn sở hữu: Wyndham Soleil là căn hộ khách sạn 50 năm; thông tin sở hữu của Nobu giữa các nguồn chưa thống nhất. Đây là yếu tố ảnh hưởng trực tiếp đến khả năng vay vốn và bán lại.</p>

<h2>Nên mua gì ở Sơn Trà?</h2>
<p>Khách ở thật nên xem căn hộ ven sông Hàn sở hữu lâu dài, đã hoặc sắp bàn giao. Khách đầu tư cho thuê ngắn ngày nên cân nhắc căn gần biển Mỹ Khê. Khách vốn lớn có thể xem đất hoặc khách sạn trên các trục biển, chấp nhận thanh khoản chậm hơn.</p>

<p>Xem toàn bộ dự án tại trang <a href="/khu-vuc/son-tra/">bất động sản Sơn Trà</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được so sánh dự án Sơn Trà theo ngân sách và mục đích mua của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Sơn Trà 2026: dự án và giá tham khảo',
			'desc'      => 'Bất động sản Sơn Trà 2026: căn hộ ven sông Hàn, căn hộ biển Mỹ Khê, đất, khách sạn Võ Nguyên Giáp – giá tham khảo, giá thuê. Gọi Hoàng Hiệp tư vấn.',
			'points'    => array(
				'Căn hộ ven sông Hàn phổ biến khoảng 50 – 125 triệu/m²',
				'Căn hộ mặt biển Mỹ Khê: Times Square, Nobu, Wyndham Soleil, Alizé',
				'Đất mặt biển Võ Nguyên Giáp khoảng 150 – 400 triệu/m² (tin rao)',
			),
			'faq'       => array(
				array( 'Căn hộ Sơn Trà giá bao nhiêu?', 'Năm 2026 căn hộ ven sông Hàn phổ biến khoảng 50 – 125 triệu/m²; The Camellia Sơn Trà có studio từ khoảng 1,98 tỷ, căn hàng hiệu mặt biển như Nobu khoảng 145 – 205 triệu/m².' ),
				array( 'Dự án nào ở Sơn Trà đã bàn giao?', 'Hiyori Garden Tower đã bàn giao; Sun Symphony Residence đang bàn giao. Các dự án như HIYORI Aqua Tower, The Camellia dự kiến bàn giao 2027 – 2028.' ),
				array( 'Thuê căn hộ Sơn Trà bao nhiêu tiền?', 'Tham khảo: 1PN khoảng 18 – 30 triệu/tháng, 2PN khoảng 18 – 40 triệu/tháng tùy dự án, nội thất và view.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-ponte-residence-da-nang',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-peninsula-da-nang',
			'https://batdongsan.com.vn/ban-dat-duong-hoang-sa-49',
		),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-hai-chau-2026',
		'title'    => 'Bất động sản Hải Châu 2026: căn hộ ven sông Hàn và trung tâm',
		'excerpt'  => 'Bất động sản Hải Châu 2026: Masteri, The Meridian, Danang Landmark, The Filmore, M Riverside, Peninsula Private, Vista Residence – giá tham khảo từng dự án.',
		'keyword'  => 'bất động sản Hải Châu',
		'project'  => '',
		'week'     => 10,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Hải Châu</strong> năm 2026 xoay quanh các tòa căn hộ ven sông Hàn và khu Hòa Cường, với mặt bằng giá khoảng 50 – 150 triệu/m² tùy dự án. Hải Châu cũng là nơi có đất đắt nhất thành phố: bảng giá nhà nước 2026 đoạn Bạch Đằng khoảng 341 triệu/m². Bài viết tổng hợp các dự án đang bán, cập nhật tháng 10/2026.</p>

<h2>Đặc điểm bất động sản Hải Châu</h2>
<p>Hải Châu là trung tâm hành chính, thương mại của Đà Nẵng, gần sân bay, cầu Rồng và công viên APEC. Quỹ đất trống gần như không còn, nên dự án mới chủ yếu là tòa căn hộ trên lô đất nhỏ, số căn ít, giá cao. Nhu cầu thuê từ người làm việc ở trung tâm và khách du lịch ổn định quanh năm.</p>

<h2>Danh sách dự án căn hộ Hải Châu</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô</th><th>Giá tham khảo</th><th>Bàn giao</th></tr></thead>
<tbody>
<tr><td>The Filmore</td><td>206 căn, 25 tầng, bên sông Hàn</td><td>Khoảng 130 – 150 triệu/m²</td><td>Đã hoàn thiện, bàn giao ngay</td></tr>
<tr><td>Danang Landmark</td><td>454 căn, cạnh công viên APEC</td><td>Khoảng 94 – 130 triệu/m²</td><td>Dự kiến giữa năm 2027</td></tr>
<tr><td>M Riverside</td><td>312 căn, số 6 đường 2/9</td><td>Khoảng 104 – 136 triệu/m²</td><td>Liên hệ</td></tr>
<tr><td>Masteri Rivera Danang</td><td>Gần 1.200 căn, 2 tháp 39 tầng</td><td>Khoảng 70 – 94 triệu/m²; từ khoảng 4,1 tỷ</td><td>Dự kiến quý III – IV/2026</td></tr>
<tr><td>The Meridian</td><td>518 căn, đường Quy Mỹ</td><td>Khoảng 70 – 95 triệu/m²; từ khoảng 2,9 tỷ</td><td>Dự kiến năm 2027</td></tr>
<tr><td>Peninsula Private</td><td>624 căn, 40 tầng</td><td>Từ khoảng 65 triệu/m² (chưa VAT)</td><td>Liên hệ</td></tr>
<tr><td>Vista Residence</td><td>112 căn 2 – 3PN</td><td>Khoảng 50 – 55 triệu/m²</td><td>Bàn giao từ 8/2026</td></tr>
</tbody>
</table>

<h2>Phân nhóm theo nhu cầu</h2>
<h3>Căn hộ hạng sang ven sông Hàn</h3>
<p><a href="/du-an/the-filmore-da-nang/">The Filmore</a>, Danang Landmark và M Riverside nằm sát sông Hàn, giá cao nhất khu vực. The Filmore có lợi thế đã hoàn thiện; Danang Landmark thuộc danh sách dự án được bán cho người nước ngoài.</p>
<h3>Căn hộ khu Hòa Cường – Quy Mỹ</h3>
<p><a href="/du-an/masteri-da-nang/">Masteri Rivera Danang</a> và <a href="/du-an/the-meridian-da-nang/">The Meridian</a> có quy mô lớn hơn, tiện ích nội khu nhiều, giá vừa phải hơn. Phù hợp gia đình trẻ và khách đầu tư cho thuê dài hạn.</p>
<h3>Căn hộ giá mềm, nhận nhà ngay</h3>
<p>Vista Residence có căn 2PN khoảng 4,5 – 5,56 tỷ, 3PN khoảng 6,8 – 7,56 tỷ, đã bàn giao – phù hợp khách cần ở ngay.</p>

<h3>Các dự án khác đáng chú ý</h3>
<p>Peninsula Private là tòa 40 tầng, cao khoảng 150 m tại Vũ Duy Thanh – Doãn Khuê (Hòa Cường), 624 căn từ studio đến 3PN, sở hữu lâu dài. M Riverside tại số 6 đường 2/9, đối diện công viên APEC, có 312 căn theo mô hình làm việc – sống – nghỉ dưỡng; loại hình sở hữu theo căn hộ dịch vụ thương mại nên cần đối chiếu hợp đồng. Danang Landmark có 454 căn, phần lớn là căn 2PN view sông Hàn và cầu Rồng, giá khoảng 5,95 – 6,7 tỷ cho căn 61 – 68 m².</p>

<h2>Giá thuê căn hộ Hải Châu</h2>
<table>
<thead><tr><th>Dự án</th><th>Giá thuê tham khảo</th></tr></thead>
<tbody>
<tr><td>The Filmore</td><td>1PN 22 – 27 triệu; 2PN 35 – 40 triệu/tháng</td></tr>
<tr><td>Vista Residence</td><td>2PN 20 – 32 triệu; 3PN 30 – 40 triệu/tháng</td></tr>
<tr><td>Masteri Rivera Danang</td><td>1PN+ 18 – 25 triệu; 2PN 20 – 25 triệu/tháng (ước tính khu vực)</td></tr>
</tbody>
</table>

<h2>Đất và dự án lớn tại Hải Châu</h2>
<p>Đất mặt tiền Bạch Đằng rao khoảng 300 triệu/m², trục Nguyễn Văn Linh khoảng 250 – 400 triệu/m². Dự án lớn sắp tới là Đà Nẵng Downtown của Sun Group trên khu Asia Park cũ, quy mô 76,92 ha, tổng vốn khoảng 79.790 tỷ đồng, có tòa tháp 69 tầng cao 408 m; dự án đang ở giai đoạn sắp mở bán.</p>

<h2>Lưu ý khi mua ở Hải Châu</h2>
<ul>
<li>Giá/m² cao, nên so sánh tổng giá căn thay vì chỉ nhìn đơn giá.</li>
<li>Kiểm tra loại hình sở hữu: một số dự án là căn hộ dịch vụ thương mại, cần đọc kỹ hợp đồng.</li>
<li>Ưu tiên căn có view sông Hàn không bị che chắn trong tương lai.</li>
</ul>

<p>Xem toàn bộ dự án tại trang <a href="/khu-vuc/hai-chau/">bất động sản Hải Châu</a> và nhóm <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá và quỹ căn các dự án Hải Châu đang bán.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Hải Châu 2026: dự án và giá căn hộ',
			'desc'      => 'Bất động sản Hải Châu 2026: The Filmore, Danang Landmark, Masteri, The Meridian, Vista Residence – giá tham khảo, giá thuê. Gọi Hoàng Hiệp tư vấn.',
			'points'    => array(
				'Căn hộ Hải Châu khoảng 50 – 150 triệu/m² tùy dự án',
				'The Filmore và Vista Residence đã có nhà; Danang Landmark, The Meridian bàn giao 2027',
				'Bảng giá đất nhà nước 2026 đoạn Bạch Đằng khoảng 341 triệu/m², cao nhất thành phố',
			),
			'faq'       => array(
				array( 'Căn hộ Hải Châu giá bao nhiêu?', 'Năm 2026 khoảng 50 – 150 triệu/m²: Vista Residence khoảng 50 – 55 triệu/m², Masteri và The Meridian khoảng 70 – 95 triệu/m², The Filmore khoảng 130 – 150 triệu/m² (tham khảo).' ),
				array( 'Dự án Hải Châu nào nhận nhà ngay?', 'The Filmore đã hoàn thiện và Vista Residence bàn giao từ tháng 8/2026.' ),
				array( 'Đà Nẵng Downtown ở đâu?', 'Dự án của Sun Group trên khu Asia Park cũ, số 01 Phan Đăng Lưu, Hải Châu, quy mô 76,92 ha, đang ở giai đoạn sắp mở bán.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/masterise-homes-ra-mat-du-an-can-ho-dau-tien-tai-da-nang-4888365.html',
			'https://thanhnien.vn/the-meridian-ra-mat-tai-da-nang-sieu-du-thuyen-kien-truc-chinh-thuc-ha-thuy-song-han-185260112084502674.htm',
			'https://nhadat.cafeland.vn/can-ban-lo-dat-1408m2-mat-tien-duong-bach-dang-view-truc-dien-song-han-da-nang-2032530.html',
		),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-ngu-hanh-son-2026',
		'title'    => 'Bất động sản Ngũ Hành Sơn 2026: căn hộ biển, biệt thự, đất nền',
		'excerpt'  => 'Bất động sản Ngũ Hành Sơn 2026: Newtown Diamond, Sun Cosmo, FPT City, Sun Riverpolis, đất nền Võ Chí Công, biệt thự Trường Sa – giá tham khảo.',
		'keyword'  => 'bất động sản Ngũ Hành Sơn',
		'project'  => '',
		'week'     => 10,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Ngũ Hành Sơn</strong> năm 2026 có đủ mọi phân khúc: căn hộ biển Trường Sa, căn hộ FPT City giá mềm, đất nền Võ Chí Công và Nam Hòa Xuân, cùng biệt thự resort ven biển. Mặt bằng căn hộ khoảng 30 – 95 triệu/m², đất nền dự án khoảng 40 – 90 triệu/m². Bài viết tổng hợp dự án theo từng nhóm, cập nhật tháng 10/2026.</p>

<h2>Bất động sản Ngũ Hành Sơn có gì nổi bật?</h2>
<p>Ngũ Hành Sơn trải dài từ cầu Trần Thị Lý xuống giáp Điện Bàn, có biển Non Nước – Mỹ Khê, sông Cổ Cò và trục Võ Chí Công nối Hội An. Đây là khu vực còn nhiều quỹ đất lớn, nơi Sun Group, FPT và các tập đoàn khác phát triển đô thị mới.</p>

<h2>Căn hộ Ngũ Hành Sơn</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô</th><th>Giá tham khảo</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Newtown Diamond</td><td>3 tòa, 1.733 căn</td><td>Khoảng 60 – 90 triệu/m²</td><td>The Ruby đã cất nóc</td></tr>
<tr><td>Sun Cosmo Residence</td><td>Khoảng 650 căn hộ</td><td>Khoảng 65 – 95 triệu/m²</td><td>Đang bàn giao</td></tr>
<tr><td>FourS Tower (Sun Riverpolis)</td><td>4 tòa, khoảng 2.291 căn</td><td>Đang cập nhật theo đợt</td><td>Đang mở bán</td></tr>
<tr><td>FPT Plaza 1, 2</td><td>586 và 700 căn</td><td>Khoảng 30 – 42 triệu/m²</td><td>Đã bàn giao</td></tr>
<tr><td>FPT Plaza 3</td><td>837 căn</td><td>1PN khoảng 1,6 – 2,5 tỷ</td><td>Đang bàn giao</td></tr>
<tr><td>FPT Plaza 4, 5</td><td>Khoảng 1.400 và hơn 832 căn</td><td>Liên hệ</td><td>Đang / sắp mở bán</td></tr>
<tr><td>Sun Galaxy Complex</td><td>Căn hộ dịch vụ do Accor vận hành</td><td>Chưa công bố</td><td>Sắp mở bán</td></tr>
</tbody>
</table>
<h3>Căn hộ biển: Newtown Diamond</h3>
<p><a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a> trên trục Trường Sa có căn 1PN khoảng 3,5 – 3,9 tỷ, 2PN khoảng 5,7 – 7,5 tỷ (tham khảo). Chi tiết từng tòa có trong bài <a href="/newtown-diamond-3-toa-va-newtown-legend/">Newtown Diamond: 3 tòa và Newtown Legend</a>.</p>
<h3>Căn hộ giá mềm: FPT City</h3>
<p>Khu đô thị FPT City hơn 181 ha bên sông Cổ Cò có mặt bằng căn hộ thấp nhất khu vực. Giá thuê FPT Plaza khoảng 10 – 13 triệu/tháng cho căn 2PN, phù hợp khách thuê là sinh viên, kỹ sư làm việc gần làng Đại học.</p>

<h3>Sun Riverpolis và FourS Tower</h3>
<p>Sun Riverpolis là khu đô thị sinh thái của Sun Group tại Hòa Quý (Nam Hòa Xuân), cùng Sun NeO City tạo hệ sinh thái hơn 1.000 ha phía Nam thành phố. Phân khu căn hộ đầu tiên là FourS Tower gồm 4 tòa Mai – Trúc – Cúc – Tùng cao 20 tầng, khoảng 2.291 căn từ studio đến 3PN, sở hữu lâu dài, nằm ở ngã tư Nguyễn Phước Lan – Minh Mạng. Bảng giá FourS Tower đang cập nhật theo từng đợt, liên hệ để nhận bảng giá.</p>

<h2>Đất nền Ngũ Hành Sơn</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Đất nền Võ Chí Công (Sun Group)</td><td>709 lô, 100 – 125 m²</td><td>Khoảng 45 – 90 triệu/m²</td></tr>
<tr><td>Đất nền Đầm Sen – Sun Riverpolis</td><td>Khoảng 900 lô, 100 – 150 m²</td><td>Khoảng 40 – 48 triệu/m²; từ khoảng 4,8 tỷ/lô</td></tr>
<tr><td>FPT City</td><td>Đất nền nhiều phân khu</td><td>Liên hệ</td></tr>
</tbody>
</table>

<h2>Biệt thự ven biển Ngũ Hành Sơn</h2>
<p>Trục Trường Sa – Võ Nguyên Giáp tập trung các khu biệt thự resort: Furama Villas (khoảng 21 – 40 tỷ), The Ocean Villas (khoảng 28,5 – 70 tỷ), Fusion (khoảng 32 – 54 tỷ), Hyatt Regency, The Ocean Estates (từ khoảng 52 tỷ), Naman Residences và Newtown Legend. Bảng giá chi tiết xem tại bài <a href="/biet-thu-ven-bien-da-nang-hoi-an-bang-gia/">biệt thự ven biển Đà Nẵng – Hội An</a>.</p>

<h2>Hạ tầng tác động</h2>
<p>Đường ven biển 129 (Võ Chí Công) được mở rộng lên 6 làn, cụm nút giao cầu Hòa Xuân được đầu tư giai đoạn 2026 – 2029, giúp kết nối khu Nam Hòa Xuân và Võ Chí Công với trung tâm tốt hơn. Dự án Sun Galaxy Complex trên đường Chương Dương khởi công ngày 25/7/2026 cũng bổ sung tiện ích lễ hội – giải trí cho khu Mỹ An.</p>

<h2>Gợi ý chọn sản phẩm</h2>
<ul>
<li>Ngân sách dưới 3 tỷ: căn hộ FPT Plaza, studio Sun Cosmo.</li>
<li>Ngân sách 3 – 8 tỷ: căn hộ Newtown Diamond, Sun Cosmo, hoặc đất nền Đầm Sen, Võ Chí Công.</li>
<li>Trên 20 tỷ: shophouse, biệt thự Newtown Legend hoặc biệt thự resort trục Trường Sa.</li>
</ul>

<p>Xem toàn bộ dự án tại trang <a href="/khu-vuc/ngu-hanh-son/">bất động sản Ngũ Hành Sơn</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được lọc dự án Ngũ Hành Sơn đúng ngân sách và nhận bảng giá mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Ngũ Hành Sơn 2026: dự án và giá',
			'desc'      => 'Bất động sản Ngũ Hành Sơn 2026: căn hộ Newtown Diamond, Sun Cosmo, FPT City, đất nền Võ Chí Công, biệt thự Trường Sa – giá tham khảo. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Căn hộ khoảng 30 – 95 triệu/m²: từ FPT Plaza đến Newtown Diamond, Sun Cosmo',
				'Đất nền Võ Chí Công khoảng 45 – 90 triệu/m²; Đầm Sen khoảng 40 – 48 triệu/m²',
				'Biệt thự resort trục Trường Sa khoảng 21 – 83 tỷ (tin rao)',
			),
			'faq'       => array(
				array( 'Căn hộ Ngũ Hành Sơn giá bao nhiêu?', 'Tham khảo 2026: FPT Plaza khoảng 30 – 42 triệu/m², Sun Cosmo khoảng 65 – 95 triệu/m², Newtown Diamond khoảng 60 – 90 triệu/m².' ),
				array( 'Đất nền Ngũ Hành Sơn ở dự án nào?', 'Đất nền Võ Chí Công (709 lô), đất nền Đầm Sen – Sun Riverpolis (khoảng 900 lô) và các phân khu FPT City.' ),
				array( 'Ngũ Hành Sơn có những khu biệt thự biển nào?', 'Furama Villas, The Ocean Villas, Fusion, Hyatt Regency, The Ocean Estates, Naman Residences và Newtown Legend.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-cosmo-residence',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-newtown-diamond-da-nang',
			'https://furamavietnam.com/furama-villas/',
		),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-lien-chieu-cang-lien-chieu',
		'title'    => 'Bất động sản Liên Chiểu: cảng Liên Chiểu và cơ hội 2026',
		'excerpt'  => 'Bất động sản Liên Chiểu 2026: cảng Liên Chiểu, khu thương mại tự do, Vinhomes Hải Vân Bay, The Ori Garden, Dragon Smart City – giá và lưu ý đầu tư.',
		'keyword'  => 'bất động sản Liên Chiểu',
		'project'  => '',
		'week'     => 10,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Liên Chiểu</strong> năm 2026 được chú ý nhờ cảng Liên Chiểu (hạ tầng dùng chung hoàn thành ngày 28/3/2026) và khu thương mại tự do Đà Nẵng khoảng 1.881 ha. Mặt bằng giá ở đây vẫn thấp hơn nhiều so với Sơn Trà, Ngũ Hành Sơn: căn hộ The Ori Garden khoảng 37 – 42 triệu/m², đất mặt biển Nguyễn Tất Thành khoảng 65 – 135 triệu/m². Bài viết cập nhật tháng 10/2026.</p>

<h2>Cảng Liên Chiểu và khu thương mại tự do</h2>
<p>Cảng Liên Chiểu là cảng biển lớn nhất của Đà Nẵng, kỳ vọng thay thế dần cảng Tiên Sa trong vận tải hàng hóa. Cùng ngày công bố hoàn thành hạ tầng dùng chung, dự án bến container Liên Chiểu vốn hơn 2 tỷ USD được khởi động. Thành phố đầu tư hơn 518 tỷ đồng cải tạo tuyến đường nối cảng với khu thương mại tự do.</p>
<p>Khu thương mại tự do gồm khoảng 1.881 ha tại 7 vị trí, có các phân khu sản xuất, logistics, thương mại – dịch vụ và công nghệ. Chi tiết xem bài <a href="/cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu/">cảng Liên Chiểu và khu thương mại tự do</a>.</p>

<h2>Dự án bất động sản Liên Chiểu</h2>
<table>
<thead><tr><th>Dự án</th><th>Loại hình</th><th>Quy mô</th><th>Giá / tình trạng</th></tr></thead>
<tbody>
<tr><td>Vinhomes Hải Vân Bay</td><td>Đô thị nghỉ dưỡng thấp tầng</td><td>512,2 ha, khoảng 5.928 căn</td><td>Liền kề từ khoảng 5,2 tỷ; đang mở bán</td></tr>
<tr><td>The Ori Garden</td><td>Căn hộ (nhà ở xã hội kết hợp thương mại)</td><td>10 tòa, khoảng 3.358 căn</td><td>1PN khoảng 1,31 – 1,94 tỷ; 2PN 1,96 – 2,56 tỷ</td></tr>
<tr><td>Dragon Smart City</td><td>Đất nền, nhà phố, biệt thự</td><td>78 ha, 2.544 lô</td><td>Đã bàn giao, giao dịch thứ cấp</td></tr>
<tr><td>Lakeside Palace</td><td>Đất nền, nhà phố</td><td>46 ha</td><td>Đã bàn giao, giao dịch thứ cấp</td></tr>
</tbody>
</table>

<h3>Vinhomes Hải Vân Bay – dự án lớn nhất khu vực</h3>
<p><a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a> tại vịnh Nam Chơn có 4 phân khu Bạch Vân, Đảo Ngọc, Vịnh Mây, Tinh Vân; hơn 90% sản phẩm thấp tầng sở hữu lâu dài. Cập nhật giá và tiến độ trong bài <a href="/vinhomes-hai-van-bay-cap-nhat-2026/">Vinhomes Hải Vân Bay: cập nhật 2026</a>.</p>
<h3>The Ori Garden – căn hộ giá thấp</h3>
<p><a href="/du-an/the-ori-garden/">The Ori Garden</a> tại khu đô thị Bàu Tràm có giá căn hộ thấp nhất trong các dự án của web, giá thuê khoảng 3 – 8 triệu/tháng. Phần căn nhà ở xã hội có điều kiện mua và chuyển nhượng riêng theo quy định, cần kiểm tra loại căn trước khi giao dịch.</p>
<h3>Đất nền Dragon Smart City, Lakeside Palace</h3>
<p>Hai khu đô thị đã hình thành hạ tầng, phù hợp khách mua đất xây nhà ở hoặc cho thuê trọ, nhà nguyên căn phục vụ lao động khu công nghiệp, cảng. Giá giao dịch thay đổi theo từng lô, liên hệ để nhận bảng giá.</p>

<h2>Đất mặt biển Nguyễn Tất Thành</h2>
<p>Tin rao năm 2026 cho thấy đất Nguyễn Tất Thành khoảng 65 – 135 triệu/m²: lô 375 m² khoảng 30 tỷ, lô 479 m² mặt biển khoảng 65 tỷ. So với trục Võ Nguyên Giáp (150 – 400 triệu/m²), đây là mặt bằng thấp hơn rõ – xem bảng so sánh tại bài <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>.</p>

<h2>Ai nên mua bất động sản Liên Chiểu?</h2>
<p>Khách ngân sách thấp cần căn hộ để ở gần các trường đại học, khu công nghiệp phía Tây Bắc có thể xem The Ori Garden. Khách muốn nhà đất có sổ để xây nhà cho thuê có thể xem lô ở Dragon Smart City, Lakeside Palace. Khách tài chính khá, muốn sản phẩm nghỉ dưỡng sở hữu lâu dài và chấp nhận chờ hạ tầng, có thể cân nhắc Vinhomes Hải Vân Bay.</p>
<p>Điểm chung là Liên Chiểu phù hợp tầm nhìn trung – dài hạn hơn là lướt sóng, vì động lực chính từ cảng và khu thương mại tự do cần nhiều năm để hình thành đầy đủ.</p>

<h2>Lưu ý khi đầu tư bất động sản Liên Chiểu</h2>
<ul>
<li>Cảng và khu thương mại tự do triển khai theo nhiều giai đoạn, cần thời gian để tạo nhu cầu ở thực.</li>
<li>Ưu tiên sản phẩm đã có pháp lý, hạ tầng hoàn thiện và khả năng cho thuê thực tế.</li>
<li>Tránh mua đất xa khu dân cư chỉ dựa vào tin quy hoạch.</li>
<li>Tính dòng tiền theo kịch bản thận trọng, không kỳ vọng tăng giá ngắn hạn.</li>
</ul>

<p>Xem toàn bộ dự án tại trang <a href="/khu-vuc/lien-chieu/">bất động sản Liên Chiểu</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tư vấn chọn sản phẩm Liên Chiểu phù hợp và nhận bảng giá mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Liên Chiểu 2026 và cảng Liên Chiểu',
			'desc'      => 'Bất động sản Liên Chiểu 2026: tác động cảng Liên Chiểu, khu thương mại tự do; dự án Vinhomes Hải Vân Bay, The Ori Garden, giá đất. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Hạ tầng dùng chung cảng Liên Chiểu hoàn thành 28/3/2026; khu thương mại tự do khoảng 1.881 ha',
				'Vinhomes Hải Vân Bay 512 ha, liền kề từ khoảng 5,2 tỷ',
				'The Ori Garden khoảng 37 – 42 triệu/m²; đất Nguyễn Tất Thành khoảng 65 – 135 triệu/m²',
			),
			'faq'       => array(
				array( 'Cảng Liên Chiểu tác động gì đến bất động sản?', 'Cảng, logistics và khu thương mại tự do kéo theo lao động, chuyên gia, làm tăng nhu cầu nhà ở và căn hộ cho thuê tại Liên Chiểu, Hòa Khánh, Hòa Hiệp.' ),
				array( 'Liên Chiểu có dự án nào đang bán?', 'Vinhomes Hải Vân Bay và The Ori Garden đang mở bán; Dragon Smart City, Lakeside Palace đã bàn giao, giao dịch thứ cấp.' ),
				array( 'Giá đất Liên Chiểu có rẻ hơn Sơn Trà không?', 'Có. Đất mặt biển Nguyễn Tất Thành khoảng 65 – 135 triệu/m², thấp hơn nhiều so với Võ Nguyên Giáp (150 – 400 triệu/m²) theo tin rao 2026.' ),
			),
		),
		'sources'  => array(
			'https://baochinhphu.vn/khoi-dong-du-an-sieu-cang-lien-chieu-da-nang-102260328105015423.htm',
			'https://danviet.vn/da-nang-chi-hon-518-ty-dong-cai-tao-tuyen-duong-ket-noi-cang-lien-chieu-voi-khu-thuong-mai-tu-do-da-nang-d1416339.html',
			'https://www.nhatot.com/tags/mua-ban-dat-duong-nguyen-tat-thanh-da-nang',
		),
	);

	$posts[] = array(
		'slug'     => 'dau-tu-bat-dong-san-da-nang-nen-chon-loai-hinh-nao',
		'title'    => 'Đầu tư bất động sản Đà Nẵng: nên chọn loại hình nào?',
		'excerpt'  => 'Đầu tư bất động sản Đà Nẵng: so sánh căn hộ, căn hộ dịch vụ, biệt thự, đất nền, shop khối đế theo vốn, dòng tiền, thanh khoản và rủi ro.',
		'keyword'  => 'đầu tư bất động sản Đà Nẵng',
		'project'  => '',
		'week'     => 10,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p><strong>Đầu tư bất động sản Đà Nẵng</strong> nên chọn loại hình theo mục tiêu: cần dòng tiền đều thì ưu tiên căn hộ sở hữu lâu dài cho thuê; muốn giữ tài sản dài hạn thì cân nhắc đất nền hoặc biệt thự; có vốn lớn và muốn kinh doanh thì xem shop khối đế. Căn hộ dịch vụ (căn hộ khách sạn) phù hợp người chấp nhận thời hạn 50 năm để đổi lấy dịch vụ vận hành. Bài viết cập nhật tháng 10/2026.</p>

<h2>Đầu tư bất động sản Đà Nẵng: so sánh 5 loại hình</h2>
<table>
<thead><tr><th>Loại hình</th><th>Vốn tham khảo</th><th>Dòng tiền</th><th>Thanh khoản</th><th>Rủi ro chính</th></tr></thead>
<tbody>
<tr><td>Căn hộ sở hữu lâu dài</td><td>Từ khoảng 1,3 – 2 tỷ</td><td>Đều, từ cho thuê dài hạn</td><td>Tốt nhất</td><td>Nguồn cung lớn, cạnh tranh giá thuê</td></tr>
<tr><td>Căn hộ dịch vụ, căn hộ khách sạn</td><td>Từ khoảng 2,95 tỷ</td><td>Phụ thuộc mùa du lịch, đơn vị vận hành</td><td>Trung bình</td><td>Thời hạn 50 năm, phí quản lý</td></tr>
<tr><td>Biệt thự</td><td>Từ khoảng 10 tỷ</td><td>Thấp so với vốn, chủ yếu giữ tài sản</td><td>Chậm</td><td>Vốn lớn, ít người mua lại</td></tr>
<tr><td>Đất nền</td><td>Từ khoảng 4,8 tỷ/lô dự án</td><td>Gần như không có</td><td>Trung bình, theo chu kỳ</td><td>Phụ thuộc hạ tầng, pháp lý</td></tr>
<tr><td>Shop khối đế</td><td>Liên hệ theo dự án</td><td>Cao nếu khai thác được</td><td>Chậm</td><td>Mặt bằng trống, phụ thuộc lưu lượng khách</td></tr>
</tbody>
</table>

<h2>Căn hộ sở hữu lâu dài – dễ bắt đầu nhất</h2>
<p>Căn hộ có mức vốn đa dạng: từ The Ori Garden (1PN khoảng 1,31 – 1,94 tỷ), FPT Plaza (2PN khoảng 2,25 – 3,4 tỷ) đến căn ven sông Hàn khoảng 50 – 125 triệu/m². Đây là loại hình dễ vay ngân hàng và dễ bán lại nhất.</p>
<p>Ví dụ minh họa từ số liệu tin rao: căn 2PN Sun Cosmo giá khoảng 5 tỷ, cho thuê khoảng 30 triệu/tháng, tương đương khoảng 7%/năm trước chi phí. Căn 2PN FPT Plaza khoảng 3 tỷ, cho thuê khoảng 12 triệu/tháng, tương đương khoảng 4,8%/năm. Đây chỉ là phép tính thô, chưa trừ phí quản lý, thời gian trống phòng, thuế. Xem danh sách tại <a href="/mua-ban/can-ho-chung-cu/">căn hộ chung cư đang bán</a>.</p>

<h2>Căn hộ dịch vụ, căn hộ khách sạn</h2>
<p>Các dự án như Wyndham Soleil (từ khoảng 2,95 tỷ, thời hạn 50 năm) hay M Riverside có ưu điểm là có đơn vị vận hành, phù hợp người không có thời gian tự cho thuê. Nhược điểm: thời hạn sở hữu thường 50 năm, doanh thu phụ thuộc mùa du lịch và năng lực đơn vị vận hành. Cần đọc kỹ hợp đồng chia sẻ doanh thu, phí quản lý và quyền tự sử dụng.</p>

<h2>Biệt thự – giữ tài sản, ít dòng tiền</h2>
<p>Biệt thự ven biển Đà Nẵng có giá từ khoảng 10 tỷ (song lập dự án mới) đến hơn 80 tỷ (resort trục Trường Sa). Dòng tiền cho thuê thường thấp so với vốn, thanh khoản chậm vì ít người đủ tài chính. Đổi lại, biệt thự sở hữu lâu dài trên quỹ đất hiếm có khả năng giữ giá tốt. Tham khảo bảng giá trong bài <a href="/biet-thu-ven-bien-da-nang-hoi-an-bang-gia/">biệt thự ven biển Đà Nẵng – Hội An</a>.</p>

<h2>Đất nền – đi theo hạ tầng</h2>
<p>Đất nền dự án như Võ Chí Công (khoảng 45 – 90 triệu/m²), Đầm Sen – Sun Riverpolis (khoảng 40 – 48 triệu/m²), Cồn Dầu Hòa Xuân (khoảng 42 – 55 triệu/m²) có sổ từng lô, phù hợp tích lũy trung – dài hạn. Rủi ro lớn nhất là kỳ vọng hạ tầng chưa thành hiện thực và thanh khoản giảm khi thị trường trầm lắng. Xem <a href="/mua-ban/dat-nen/">đất nền Đà Nẵng đang bán</a>.</p>

<h2>Shop khối đế – dòng tiền cao nhưng kén vị trí</h2>
<p>Shop khối đế (ví dụ 77 shop tại Sun Symphony, 10 shop tại The Camellia Sơn Trà) có thể cho thuê giá cao nếu nằm ở mặt đường đông khách. Nhưng nếu tòa nhà ít cư dân hoặc mặt tiền khuất, shop dễ bị trống lâu. Cần kiểm tra thời hạn sở hữu, lối tiếp cận và lượng cư dân thực tế. Xem thêm tại <a href="/san-pham/shop-khoi-de/">shop khối đế Đà Nẵng</a>.</p>

<h2>Gợi ý theo ngân sách</h2>
<ul>
<li>Dưới 3 tỷ: căn hộ The Ori Garden, FPT Plaza, studio các dự án Sơn Trà, Ngũ Hành Sơn.</li>
<li>3 – 7 tỷ: căn hộ ven sông Hàn, căn hộ biển, hoặc một lô đất nền dự án.</li>
<li>Trên 10 tỷ: biệt thự, shophouse, shop khối đế vị trí tốt.</li>
</ul>
<p>Dù chọn loại hình nào, anh chị nên giữ tỷ lệ vay vừa phải, tính dòng tiền khi hết thời gian hỗ trợ lãi suất và ưu tiên pháp lý rõ ràng.</p>

<p>Tham khảo toàn bộ <a href="/du-an/">dự án bất động sản Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tư vấn chọn loại hình đầu tư phù hợp với vốn và mục tiêu của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đầu tư bất động sản Đà Nẵng: chọn loại hình nào?',
			'desc'      => 'Đầu tư bất động sản Đà Nẵng: so sánh căn hộ, căn hộ dịch vụ, biệt thự, đất nền, shop khối đế theo vốn, dòng tiền, rủi ro. Gọi Hoàng Hiệp để tư vấn.',
			'points'    => array(
				'Căn hộ sở hữu lâu dài: vốn thấp, thanh khoản tốt nhất, dòng tiền đều',
				'Căn hộ dịch vụ: có vận hành nhưng thường thời hạn 50 năm',
				'Biệt thự, đất nền giữ tài sản dài hạn; shop khối đế kén vị trí',
			),
			'faq'       => array(
				array( 'Đầu tư bất động sản Đà Nẵng nên bắt đầu từ loại hình nào?', 'Với vốn vừa phải, căn hộ sở hữu lâu dài là lựa chọn dễ bắt đầu nhất vì dễ vay, dễ cho thuê và dễ bán lại.' ),
				array( 'Căn hộ dịch vụ khác căn hộ chung cư thế nào?', 'Căn hộ dịch vụ, căn hộ khách sạn thường do đơn vị chuyên nghiệp vận hành và có thời hạn sở hữu 50 năm; căn hộ chung cư thông thường sở hữu lâu dài.' ),
				array( 'Đất nền Đà Nẵng có nên đầu tư không?', 'Phù hợp tích lũy trung – dài hạn nếu chọn lô pháp lý rõ, gần hạ tầng đã khởi công; đất nền gần như không tạo dòng tiền trong thời gian nắm giữ.' ),
				array( 'Shop khối đế có rủi ro gì?', 'Rủi ro lớn nhất là mặt bằng trống lâu nếu tòa nhà ít cư dân hoặc vị trí khuất; cần kiểm tra lượng khách, lối tiếp cận và thời hạn sở hữu.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
