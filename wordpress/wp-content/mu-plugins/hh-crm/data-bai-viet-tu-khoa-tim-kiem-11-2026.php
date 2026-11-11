<?php
/**
 * Bài theo đúng câu khách gõ trên Google (gợi ý tìm kiếm Google, 11/2026):
 * "cora tower / spana tower khi nào bàn giao", "nobu đà nẵng của ai", "the legend đà nẵng của chủ đầu tư nào",
 * "sun symphony 5 ở đâu". Mỗi bài dẫn về trang dự án chính ngay đoạn đầu.
 * Số liệu lấy từ dữ liệu dự án, hồ sơ chủ đầu tư trên web – không thêm số mới.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tu_khoa_tim_kiem_11_2026' );
function hh_posts_tu_khoa_tim_kiem_11_2026( $posts ) {
	$sign = '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ tài liệu chủ đầu tư, văn bản Sở Xây dựng và báo chí · cập nhật 11/2026.</small></p>';
	$cta  = static fn( $name ) => '<p>Cần bảng giá, giỏ hàng và tiến độ mới nhất ' . $name . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- Cora, Spana, S-Light khi nào bàn giao ---------------- */
	$posts[] = array(
		'slug'     => 'cora-tower-spana-tower-khi-nao-ban-giao',
		'title'    => 'Cora Tower khi nào bàn giao? Spana Tower, S-Light Tower và tiến độ Sun NeO City Hòa Xuân',
		'excerpt'  => 'Cora Tower dự kiến bàn giao 30/07/2027, Spana Tower dự kiến 30/06/2027; tháng 11/2026 hai tòa Spana đang lên khoảng tầng 10. Nhận nhà sớm khi thanh toán 70% (Sun Early Key). S-Light Tower ở đâu, đã mở bán từ khi nào.',
		'keyword'  => 'Cora Tower khi nào bàn giao',
		'keywords_extra' => array( 'Spana Tower khi nào bàn giao', 'tiến độ Spana Tower', 'tiến độ Cora Tower', 'S-Light Tower ở đâu' ),
		'project'  => 'cora-tower',
		'schedule' => '2026-11-24 09:00',
		'category' => 'Dự án',
		'tags'     => array( 'Cora Tower', 'Spana Tower', 'S-Light Tower', 'Sun NeO City', 'Tiến độ dự án' ),
		'image'    => 'plugin:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg',
		'image_alt' => 'Hai tòa Spana Tower đang thi công phần thân bên sông Cẩm Lệ, cạnh cầu Hòa Xuân (tiến độ 11/2026)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Cora Tower khi nào bàn giao?</strong> Dự kiến <strong>30/07/2027</strong>. <strong>Spana Tower khi nào bàn giao?</strong> Dự kiến <strong>30/06/2027</strong>; tháng 11/2026 hai tòa S1, S2 đang thi công phần thân, lên khoảng tầng 10. Cả hai áp dụng Sun Early Key: thanh toán đủ 70% là nhận nhà sử dụng. <strong>S-Light Tower</strong> ra mắt tháng 6/2026, nằm ở đường 29/3 giao Nguyễn Đình Thi; mốc bàn giao theo hợp đồng từng căn.</p>
{$sign}
</div>
<p>Ba tòa căn hộ Sun Group ở khu đô thị Sun NeO City (Hòa Xuân) là <a href="/du-an/cora-tower/">Cora Tower</a>, <a href="/du-an/spana-tower/">Spana Tower</a> và <a href="/du-an/s-light-tower/">S-Light Tower</a>. Câu khách hỏi nhiều nhất là "khi nào bàn giao" và "xây đến đâu rồi". Bài này trả lời theo tài liệu chủ đầu tư và ảnh công trường mới nhất.</p>
<!--hh-featured-->
<h2>Cora Tower khi nào bàn giao: mốc của ba tòa</h2>
<table>
<thead><tr><th>Tòa</th><th>Bàn giao dự kiến</th><th>Tiến độ / pháp lý</th></tr></thead>
<tbody>
<tr><td>Spana Tower (S1, S2)</td><td>30/06/2027</td><td>Đủ điều kiện bán (VB 7111/SXD-QLN, 05/5/2026), bảo lãnh VietinBank; 11/2026 lên khoảng tầng 10</td></tr>
<tr><td>Cora Tower (A1, A2)</td><td>30/07/2027 (căn hộ); shop khối đế nhận nhà khi thanh toán 70%, dự kiến 31/10/2027</td><td>Đang bán</td></tr>
<tr><td>S-Light Tower</td><td>Theo hợp đồng từng căn</td><td>Ra mắt 6/2026, đang bán</td></tr>
</tbody>
</table>
<h2>Spana Tower: xây đến đâu</h2>
<p>Ảnh flycam tháng 11/2026 cho thấy hai tòa S1, S2 hai bên đường dẫn cầu Hòa Xuân đang thi công phần thân, lên khoảng tầng 10, cẩu tháp hoạt động, lưới an toàn phủ kín. Mỗi tòa cao 22 tầng và tum.</p>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-toa-thap-nhin-chinh-dien.jpg|Tòa tháp Spana Tower đang lên khoảng tầng 10 (tiến độ 11/2026)-->
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-nhin-tu-tren-cao.jpg|Flycam từ trên cao: hai tòa Spana Tower hai bên đường dẫn cầu Hòa Xuân (tiến độ 11/2026)-->
<h2>Cora Tower: mốc bàn giao</h2>
<p>Chủ đầu tư công bố bàn giao căn hộ Cora Tower dự kiến <strong>30/07/2027</strong>, hoàn thiện trần, tường, sàn (chưa gồm nội thất rời). Khách thanh toán đủ 70% được nhận nhà sử dụng theo Sun Early Key. Xem thêm <a href="/gia-cora-tower-da-nang-bao-nhieu/">giá Cora Tower</a>.</p>
<!--hh-dimg:1wnsijH2qgHtzHwhDnYpb6ELxk_aKErVa|Cora Tower nhìn từ trên cao – giao lộ Nguyễn Phước Lan, đường 29/3 (phối cảnh chủ đầu tư)-->
<h2>S-Light Tower ở đâu</h2>
<p>S-Light Tower nằm ở đường 29/3 giao Nguyễn Đình Thi, trong Sun NeO City, nơi giao ba dòng sông Hàn – Cẩm Lệ – Đô Toả. Cặp tháp 22 tầng, 3 tầng hầm, gần 800 căn từ 33,3 đến 95,1 m², sở hữu lâu dài. Sun Property ra mắt dự án tháng 6/2026.</p>
<!--hh-dimg:1qTRfjGsKIbM5fallG7B1yV6aaum8f1XC|S-Light Tower nhìn từ trên cao, ngã ba sông Hàn – Cẩm Lệ – Đô Toả (phối cảnh chủ đầu tư)-->
<h2>Nhận nhà sớm: Sun Early Key</h2>
<ul>
<li>Thanh toán đủ 70% giá trị căn là được nhận nhà sử dụng, không cần chờ trả hết.</li>
<li>5% cuối đóng khi bàn giao, chủ đầu tư trả lãi 8%/năm trên khoản này.</li>
<li>Vay tối đa 70%, chủ đầu tư hỗ trợ lãi suất 24 tháng.</li>
</ul>
<p>So sánh ba tòa: <a href="/cora-spana-s-light-sun-neo-city-nen-chon-toa-nao/">Cora, Spana hay S-Light – nên chọn tòa nào</a>.</p>
<h2>Pháp lý Spana Tower đi kèm mốc bàn giao</h2>
<ul>
<li>Sở Xây dựng xác nhận nhà ở hình thành trong tương lai đủ điều kiện bán (VB 7111/SXD-QLN, 05/5/2026).</li>
<li>VietinBank cam kết phát hành bảo lãnh cho người mua (07/5/2026); dự án không thế chấp khi ký hợp đồng mua bán.</li>
<li>Đất ở đô thị, 2 giấy chứng nhận riêng cho lô A1-3 và A1-4; sở hữu lâu dài.</li>
<li>Hợp đồng mua bán theo mẫu đã đăng ký với Sở Công Thương (TB 1737/TB-SCT, 09/4/2026).</li>
</ul>
<h2>Khi nhận nhà, anh chị nhận gì</h2>
<ul>
<li><strong>Cora Tower:</strong> căn hộ hoàn thiện trần, tường, sàn; chưa gồm nội thất rời.</li>
<li><strong>Spana Tower:</strong> trọn tầng 2 là tiện ích nội khu – bể bơi, gym và spa, co-working, cafe, khu trẻ em; tầng 1 là shophouse khối đế.</li>
<li><strong>Cả hai:</strong> miễn phí quản lý 1 năm; 5% cuối đóng khi bàn giao và được chủ đầu tư trả lãi 8%/năm đến khi có sổ.</li>
</ul>
<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-nhin-tu-bo-song-cam-le.jpg|Công trường Spana Tower nhìn từ bờ sông Cẩm Lệ (tiến độ 11/2026)-->
<h2>Checklist khi nhận bàn giao căn hộ</h2>
<ol>
<li>Đo lại diện tích thông thủy, so với hợp đồng.</li>
<li>Kiểm tra trần, tường, sàn: vết nứt, thấm, độ phẳng.</li>
<li>Thử cửa, khóa, cửa sổ, lan can lô gia.</li>
<li>Thử điện, nước, thoát sàn vệ sinh, lô gia.</li>
<li>Ghi biên bản các điểm cần sửa, hẹn thời hạn khắc phục.</li>
<li>Nhận đủ giấy tờ: biên bản bàn giao, hướng dẫn sử dụng, thông tin bảo hành.</li>
</ol>
<h2>Nên chọn tòa nào theo mốc bàn giao</h2>
<ul>
<li><strong>Muốn ở hoặc cho thuê sớm nhất:</strong> Spana Tower (dự kiến 30/06/2027).</li>
<li><strong>Muốn giỏ hàng có giá công khai:</strong> Cora Tower (studio từ khoảng 2,42 tỷ, dự kiến 30/07/2027).</li>
<li><strong>Muốn view sông, giãn tiến độ dài:</strong> S-Light Tower (giãn đến 48 tháng).</li>
</ul>
<h2>Thanh toán đến lúc nhận nhà</h2>
<p>Cả Cora và Spana: đặt cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 40 tháng (Cora) hoặc 38 tháng (Spana); vay tối đa 70%, hỗ trợ lãi suất 24 tháng. Khi đã thanh toán đủ 70% là nhận nhà sử dụng.</p>
<h2>Mốc bàn giao có thể thay đổi không</h2>
<p>Mốc trong bài là mốc dự kiến chủ đầu tư công bố. Mốc ràng buộc là mốc ghi trong hợp đồng mua bán, kèm điều khoản phạt khi chậm bàn giao. Anh chị nên đọc kỹ điều khoản này trước khi ký và theo dõi ảnh tiến độ định kỳ của từng tòa.</p>
{$cta('Cora Tower, Spana Tower, S-Light Tower')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cora Tower khi nào bàn giao? Spana, S-Light (11/2026)',
			'desc'      => 'Cora Tower khi nào bàn giao: dự kiến 30/07/2027; Spana Tower 30/06/2027, tháng 11/2026 lên khoảng tầng 10. Nhận nhà khi trả 70%. S-Light ở đâu.',
			'points'    => array(
				'Spana Tower bàn giao dự kiến 30/06/2027; 11/2026 lên khoảng tầng 10',
				'Cora Tower bàn giao dự kiến 30/07/2027',
				'Sun Early Key: thanh toán đủ 70% là nhận nhà sử dụng',
			),
			'faq'       => array(
				array( 'Cora Tower khi nào bàn giao?', 'Dự kiến 30/07/2027, bàn giao hoàn thiện trần, tường, sàn; thanh toán đủ 70% là nhận nhà sử dụng (Sun Early Key).' ),
				array( 'Spana Tower khi nào bàn giao?', 'Dự kiến 30/06/2027. Tháng 11/2026 hai tòa S1, S2 đang thi công phần thân, lên khoảng tầng 10.' ),
				array( 'S-Light Tower ở đâu?', 'Đường 29/3 giao Nguyễn Đình Thi, khu đô thị Sun NeO City (Hòa Xuân, Đà Nẵng), nơi giao ba dòng sông Hàn – Cẩm Lệ – Đô Toả.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Nobu Đà Nẵng của ai ---------------- */
	$posts[] = array(
		'slug'     => 'nobu-da-nang-cua-ai-chu-dau-tu',
		'title'    => 'Nobu Đà Nẵng của ai? Chủ đầu tư VCRE, thương hiệu Nobu Hospitality và tòa tháp 43 tầng',
		'excerpt'  => 'Nobu Đà Nẵng (Nobu Residences Danang) do VCRE – Công ty CP Bất động sản Bản Việt, thành viên Phoenix Holdings – phát triển cùng Nobu Hospitality. Tòa tháp 43 tầng ở 01 Võ Văn Kiệt, góc Võ Nguyên Giáp; tiến độ, số căn, điều cần kiểm tra.',
		'keyword'  => 'Nobu Đà Nẵng của ai',
		'keywords_extra' => array( 'chủ đầu tư Nobu Đà Nẵng', 'Nobu Đà Nẵng bao nhiêu tầng', 'Nobu Đà Nẵng địa chỉ' ),
		'project'  => 'nobu-da-nang',
		'schedule' => '2026-11-24 14:00',
		'category' => 'Dự án',
		'tags'     => array( 'Nobu Residences Đà Nẵng', 'Chủ đầu tư' ),
		'image'    => 'plugin:img/nobu-da-nang/nobu-da-nang-phoi-canh-thap-nhin-tu-tren-cao.jpg',
		'image_alt' => 'Tháp Nobu Đà Nẵng 43 tầng nhìn từ trên cao về sông Hàn (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Nobu Đà Nẵng của ai?</strong> Dự án do <strong>VCRE</strong> (Viet Capital Real Estate – Công ty CP Bất động sản Bản Việt, thành viên Phoenix Holdings) phát triển cùng Công ty TNHH Phoenix Holdings và <strong>Nobu Hospitality</strong> – thương hiệu của đầu bếp Nobu Matsuhisa, diễn viên Robert De Niro và Meir Teper. Tòa tháp 43 tầng (khoảng 186 m) ở <strong>01 Võ Văn Kiệt, góc Võ Nguyên Giáp</strong>, nhìn ra biển Mỹ Khê; dự kiến hoàn thành năm 2027.</p>
{$sign}
</div>
<p>Trên Google, nhiều người gõ "Nobu Đà Nẵng của ai", "chủ đầu tư Nobu Đà Nẵng". Bài này trả lời ngắn gọn ai đứng sau <a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a>, vai trò từng bên và những điều người mua nên kiểm tra.</p>
<!--hh-featured-->
<h2>Nobu Đà Nẵng của ai: vai trò từng bên</h2>
<table>
<thead><tr><th>Bên</th><th>Vai trò</th></tr></thead>
<tbody>
<tr><td>VCRE – Công ty CP Bất động sản Bản Việt</td><td>Phát triển dự án; thành lập 2007, thành viên Phoenix Holdings</td></tr>
<tr><td>Công ty TNHH Phoenix Holdings</td><td>Đối tác phát triển dự án tại Đà Nẵng</td></tr>
<tr><td>Nobu Hospitality</td><td>Thương hiệu, vận hành khách sạn, nhà hàng và căn hộ hàng hiệu</td></tr>
<tr><td>Newtecons</td><td>Nhà thầu thi công (khởi công quý 2/2024)</td></tr>
</tbody>
</table>
<p>Hồ sơ chủ đầu tư chi tiết: <a href="/chu-dau-tu/vcre/">VCRE (Bất động sản Bản Việt)</a>.</p>
<h2>Nobu Đà Nẵng ở đâu, bao nhiêu tầng</h2>
<ul>
<li><strong>Địa chỉ:</strong> 01 Võ Văn Kiệt, góc Võ Nguyên Giáp, phường An Hải (Phước Mỹ, Sơn Trà cũ), Đà Nẵng – mặt biển Mỹ Khê.</li>
<li><strong>Quy mô:</strong> 43 tầng nổi (khoảng 186 m), 2 tầng hầm, khu đất khoảng 3.000 m².</li>
<li><strong>Sản phẩm:</strong> 264 căn hộ hàng hiệu và khách sạn Nobu khoảng 200 phòng (gồm 18 suite), nhà hàng Nobu tầng 42.</li>
</ul>
<p><small>Số căn, số phòng các nguồn công bố khác nhau theo thời điểm; người mua lấy số liệu trong hồ sơ pháp lý và hợp đồng làm căn cứ.</small></p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-khoi-de-sanh-don.jpg|Khối đế và sảnh đón Nobu Đà Nẵng trên đường Võ Nguyên Giáp (phối cảnh)-->
<h2>Tiến độ</h2>
<p>Tháng 10/2026 kết cấu đã lên tầng 22; đang lắp mặt dựng kính tầng 7 – 13, thi công cơ điện và PCCC tới tầng 17. Lãnh đạo VCRE cho biết dự án dự kiến hoàn thành năm 2027. Chi tiết: <a href="/tien-do-nobu-residences-da-nang/">tiến độ Nobu Đà Nẵng</a>.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-tien-do-10-2026-toan-canh.jpg|Công trường Nobu Đà Nẵng tháng 10/2026 – kết cấu đến tầng 22 (ảnh thực tế của chủ đầu tư)-->
<h2>Người mua nên kiểm tra gì</h2>
<ol>
<li><strong>Tên pháp nhân ký hợp đồng:</strong> đối chiếu tên chủ đầu tư trên hợp đồng mua bán và giấy phép xây dựng.</li>
<li><strong>Thời hạn sở hữu:</strong> các nguồn chưa thống nhất (lâu dài cho người Việt hay đến 2060 theo đất thương mại dịch vụ).</li>
<li><strong>Hợp đồng vận hành với Nobu Hospitality:</strong> phí dịch vụ, chương trình cho thuê.</li>
</ol>
<p>Xem thêm: <a href="/gia-nobu-residences-da-nang-bao-nhieu/">giá Nobu Đà Nẵng</a>, <a href="/can-ho-hang-hieu-la-gi-nobu-da-nang/">căn hộ hàng hiệu là gì</a>.</p>
<h2>VCRE là ai</h2>
<p>VCRE (Viet Capital Real Estate) là tên viết tắt của Công ty CP Bất động sản Bản Việt, thành lập năm 2007 và là thành viên của Phoenix Holdings. Doanh nghiệp theo đuổi phân khúc nhà ở và lưu trú hạng sang gắn với thương hiệu quốc tế, đã mở thêm văn phòng kinh doanh tại Hà Nội. Tổng giám đốc là ông Võ Thành Lâm. Theo VnEconomy, sau Đà Nẵng, VCRE tiếp tục hợp tác với Nobu để đưa thương hiệu này vào TP.HCM.</p>
<h2>Nobu Hospitality là ai</h2>
<p>Nobu Hospitality là thương hiệu khách sạn – nhà hàng quốc tế mang tên đầu bếp Nobu Matsuhisa, đồng sáng lập cùng diễn viên Robert De Niro và nhà sản xuất Meir Teper. Ở Đà Nẵng, thương hiệu này vận hành khách sạn, nhà hàng Nobu và dịch vụ cho cư dân căn hộ hàng hiệu. Nobu Đà Nẵng được giới thiệu là dự án Nobu Residences đầu tiên tại Đông Nam Á.</p>
<!--hh-img:img/nobu-da-nang/nobu-da-nang-nha-hang-nobu.jpg|Nhà hàng Nobu (phối cảnh)-->
<h2>Thiết kế và tiện ích</h2>
<p>Kiến trúc tòa tháp lấy cảm hứng từ quạt giấy Nhật Bản (Sensu) và nguyên lý mượn cảnh (Shakkei); nội thất phong cách Japandi tối giản, tận dụng ánh sáng tự nhiên và hướng nhìn biển Mỹ Khê. Tiện ích theo phối cảnh chủ đầu tư gồm hồ bơi nước ấm trên cao, nhà hàng Nobu, bar trên không, beach club, quầy bar bên hồ bơi, phòng tập trên không, sảnh hội nghị và khu vui chơi trẻ em.</p>
<h2>Các loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích (khoảng)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>42,2 – 43 m²</td></tr>
<tr><td>1PN</td><td>62,5 – 71,1 m²</td></tr>
<tr><td>2PN</td><td>99,7 – 118,7 m²</td></tr>
<tr><td>3PN Dual Key</td><td>130,1 – 166,2 m²</td></tr>
<tr><td>Sky Villa hồ bơi riêng (6 căn)</td><td>254 – 288 m²</td></tr>
<tr><td>Penthouse (2 căn)</td><td>Khoảng 372 m²</td></tr>
</tbody>
</table>
<p>Lưu ý số liệu: các nguồn công bố khác nhau theo thời điểm (có nguồn ghi 271 căn hộ và 2 penthouse, nguồn khác ghi khách sạn 206 phòng và 253 căn hộ). Anh chị nên lấy số liệu trong hồ sơ pháp lý và hợp đồng làm căn cứ.</p>
<h2>Giá tham khảo</h2>
<p>Căn 1PN 62,5 – 71,1 m² tham khảo khoảng 6,63 – 9,06 tỷ; đơn giá một số nguồn nêu khoảng 145 – 205 triệu/m² tùy tầng và hướng view. Chi tiết: <a href="/gia-nobu-residences-da-nang-bao-nhieu/">giá Nobu Đà Nẵng</a>.</p>
{$cta('Nobu Đà Nẵng')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Nobu Đà Nẵng của ai? Chủ đầu tư VCRE và Nobu',
			'desc'      => 'Nobu Đà Nẵng của ai: VCRE (Bất động sản Bản Việt, thành viên Phoenix Holdings) phát triển cùng Nobu Hospitality; tháp 43 tầng ở 01 Võ Văn Kiệt.',
			'points'    => array(
				'VCRE (Bất động sản Bản Việt) phát triển cùng Phoenix Holdings',
				'Nobu Hospitality vận hành khách sạn, nhà hàng, căn hộ hàng hiệu',
				'Tháp 43 tầng ở 01 Võ Văn Kiệt; 10/2026 kết cấu đến tầng 22',
			),
			'faq'       => array(
				array( 'Nobu Đà Nẵng của ai?', 'Dự án do VCRE (Công ty CP Bất động sản Bản Việt, thành viên Phoenix Holdings) phát triển cùng Công ty TNHH Phoenix Holdings và thương hiệu Nobu Hospitality.' ),
				array( 'Nobu Đà Nẵng bao nhiêu tầng?', '43 tầng nổi (khoảng 186 m) và 2 tầng hầm.' ),
				array( 'Nobu Đà Nẵng ở đâu?', 'Số 01 Võ Văn Kiệt, góc Võ Nguyên Giáp, phường An Hải (Sơn Trà cũ), Đà Nẵng – nhìn ra biển Mỹ Khê.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- The Legend của chủ đầu tư nào ---------------- */
	$posts[] = array(
		'slug'     => 'the-legend-da-nang-cua-chu-dau-tu-nao',
		'title'    => 'The Legend Đà Nẵng của chủ đầu tư nào? VIPICO và dự án The Legend City đầu cầu Rồng',
		'excerpt'  => 'The Legend Đà Nẵng (The Legend City Danang) do Công ty TNHH MTV VIPICO làm chủ đầu tư, ROX Signature phát triển, trên lô A20 Võ Văn Kiệt ngay đầu cầu Rồng. Quy mô, vốn, lịch sử pháp lý khu đất và điều người mua cần kiểm tra.',
		'keyword'  => 'The Legend Đà Nẵng của chủ đầu tư nào',
		'keywords_extra' => array( 'The Legend Đà Nẵng của chủ đầu tư nào', 'chủ đầu tư The Legend City', 'VIPICO Đà Nẵng' ),
		'project'  => 'the-legend-da-nang',
		'schedule' => '2026-11-25 09:00',
		'category' => 'Dự án',
		'tags'     => array( 'The Legend Đà Nẵng', 'Chủ đầu tư' ),
		'image'    => 'plugin:img/the-legend/the-legend-da-nang-toa-thap-goc-nhin-tu-duong.jpg',
		'image_alt' => 'Tòa tháp The Legend nhìn từ góc đường (phối cảnh)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>The Legend Đà Nẵng của chủ đầu tư nào?</strong> Chủ đầu tư là <strong>Công ty TNHH MTV VIPICO</strong>; đơn vị phát triển là Công ty CP ROX Signature. Dự án có tên đầy đủ là The Legend City Danang (Thành phố huyền thoại – Đà Nẵng), nằm trên lô A20 Võ Văn Kiệt, ngay đầu cầu Rồng phía Sơn Trà, gồm tháp căn hộ (800 căn sở hữu lâu dài) và tháp khách sạn.</p>
{$sign}
</div>
<p>Từ khoá "The Legend Đà Nẵng chủ đầu tư", "của chủ đầu tư nào" được tìm nhiều vì khu đất A20 từng có lịch sử pháp lý phức tạp. Bài này tóm tắt chủ đầu tư, quá trình tháo gỡ và tình trạng hiện tại của <a href="/du-an/the-legend-da-nang/">The Legend Đà Nẵng</a>.</p>
<!--hh-featured-->
<h2>The Legend Đà Nẵng của chủ đầu tư nào: thông tin VIPICO</h2>
<table>
<tbody>
<tr><th>Chủ đầu tư</th><td>Công ty TNHH MTV VIPICO</td></tr>
<tr><th>Đơn vị phát triển</th><td>Công ty CP ROX Signature</td></tr>
<tr><th>Dự án</th><td>The Legend City Danang – tổ hợp trung tâm thương mại, khách sạn và căn hộ</td></tr>
<tr><th>Vốn xây dựng nhà ở</th><td>2.352 tỷ đồng, được huy động 1.764 tỷ đồng (Tuổi Trẻ, 3/2025)</td></tr>
<tr><th>Khởi công</th><td>28/02/2025</td></tr>
</tbody>
</table>
<p>Hồ sơ chi tiết: <a href="/chu-dau-tu/vipico/">chủ đầu tư VIPICO</a>.</p>
<h2>Lịch sử khu đất A20</h2>
<ul>
<li><strong>28/7/2017:</strong> Quyết định 4105/QĐ-UBND công nhận kết quả đấu giá khu đất A20 Võ Văn Kiệt.</li>
<li>Sau đó phát sinh tranh chấp giữa doanh nghiệp và chính quyền; theo báo chí, UBND TP Đà Nẵng thua kiện ở cả sơ thẩm và phúc thẩm, dự án được tháo gỡ.</li>
<li><strong>25/9/2020:</strong> cấp giấy chứng nhận quyền sử dụng đất.</li>
<li><strong>24/5/2024:</strong> phê duyệt quy hoạch 1/500.</li>
<li><strong>14/02/2025:</strong> giấy phép xây dựng phần ngầm (3 tầng hầm); khởi công 28/02/2025.</li>
<li><strong>19/3/2025:</strong> Sở Xây dựng xác nhận đủ điều kiện huy động vốn; khoảng 1/2026 thông báo 800 căn đủ điều kiện bán.</li>
</ul>
<!--hh-img:img/the-legend/the-legend-da-nang-vi-tri-chan-cau-rong-tu-tren-cao.jpg|Vị trí The Legend ngay chân cầu Rồng, nhìn từ trên cao (phối cảnh)-->
<h2>The Legend ở đâu</h2>
<p>Lô A20 Võ Văn Kiệt, An Hải Tây (Sơn Trà cũ) – khu đất 4 mặt tiền Võ Văn Kiệt, Ngô Quyền, Lý Nam Đế, Mai Hắc Đế, ngay đầu cầu Rồng, khoảng 1 km ra biển Mỹ Khê.</p>
<h2>Người mua nên kiểm tra gì</h2>
<ol>
<li>Văn bản Sở Xây dựng xác nhận căn mình mua thuộc danh sách đủ điều kiện bán.</li>
<li>Thư bảo lãnh ngân hàng cho nghĩa vụ bàn giao.</li>
<li>Tên pháp nhân ký hợp đồng là Công ty TNHH MTV VIPICO.</li>
</ol>
<p>Xem thêm: <a href="/phap-ly-the-legend-da-nang-so-huu-lau-dai/">pháp lý The Legend</a>, <a href="/gia-the-legend-da-nang-bao-nhieu/">giá The Legend</a>.</p>
<h2>Dự án gồm những gì</h2>
<table>
<tbody>
<tr><th>Khu đất</th><td>11.487 m² (khoảng 1,2 ha), 4 mặt tiền</td></tr>
<tr><th>Tháp căn hộ</th><td>29 tầng, 800 căn sở hữu lâu dài (1PN đến 3PN, 8 penthouse duplex)</td></tr>
<tr><th>Tháp khách sạn</th><td>25 tầng: 222 phòng khách sạn, 222 căn hộ dịch vụ, thời hạn 50 năm</td></tr>
<tr><th>Tầng hầm</th><td>3 tầng hầm chung</td></tr>
<tr><th>Khối đế</th><td>Thương mại, nhà hàng, tiện ích; đang bán 19 shop (đợt 10/2026)</td></tr>
</tbody>
</table>
<h2>Mốc thời gian chính</h2>
<table>
<thead><tr><th>Thời điểm</th><th>Sự kiện</th></tr></thead>
<tbody>
<tr><td>2017</td><td>Phê duyệt kết quả đấu giá quyền sử dụng đất lô A20</td></tr>
<tr><td>Sau 2017</td><td>Tranh chấp pháp lý, sau đó được tháo gỡ</td></tr>
<tr><td>14/02/2025</td><td>Giấy phép xây dựng phần ngầm (3 tầng hầm, giai đoạn 1)</td></tr>
<tr><td>28/02/2025</td><td>Khởi công</td></tr>
<tr><td>3/2025</td><td>Công bố vốn xây dựng nhà ở 2.352 tỷ đồng, được huy động 1.764 tỷ</td></tr>
<tr><td>31/12/2026</td><td>Cất nóc (dự kiến theo chính sách bán hàng)</td></tr>
<tr><td>31/3/2028</td><td>Bàn giao căn hộ (dự kiến theo chính sách bán hàng)</td></tr>
<tr><td>Quý 4/2028</td><td>Mốc hoàn thành theo tiến độ đăng ký</td></tr>
</tbody>
</table>
<!--hh-img:img/the-legend/the-legend-da-nang-tien-do-6-2025-flycam-cong-truong.jpg|Công trường The Legend tháng 6/2025 – flycam nhìn về sông Hàn-->
<h2>Vì sao cần đọc kỹ hồ sơ</h2>
<ul>
<li>Mua lúc này là mua nhà hình thành trong tương lai – dự án khởi công 02/2025.</li>
<li>Khu đất từng có tranh chấp (đấu giá 2017, vụ kiện sau đó); đã có thời điểm Sở Xây dựng lưu ý dự án chưa đủ điều kiện bán, sau đó báo chí cho biết dự án đủ điều kiện mở bán.</li>
<li>Dự án có cả khối khách sạn và khối chung cư – hỏi rõ căn mình mua thuộc khối nào và thời hạn sở hữu tương ứng (lâu dài hay 50 năm).</li>
</ul>
<h2>Ưu đãi hiện có</h2>
<p>Quà nội thất trừ vào giá 300 triệu – 1,8 tỷ, chiết khấu thanh toán sớm đến 12%, vay 70% hỗ trợ lãi suất 0% trong 24 tháng (MSB, Vietcombank, MB), miễn phí quản lý 24 tháng – theo chính sách ban hành 17/7/2025, có thể đã điều chỉnh theo đợt. Xem <a href="/co-nen-mua-the-legend-da-nang-uu-nhuoc-diem/">có nên mua The Legend</a>.</p>
<h2>Câu hỏi khi làm việc với chủ đầu tư</h2>
<ol>
<li>Văn bản xác nhận đủ điều kiện bán áp dụng cho căn nào, số văn bản, ngày ban hành?</li>
<li>Ngân hàng nào phát hành thư bảo lãnh?</li>
<li>Mốc bàn giao trong hợp đồng là 31/3/2028 hay mốc khác?</li>
</ol>
<p>Xem giá từng loại căn: <a href="/gia-the-legend-da-nang-bao-nhieu/">giá The Legend Đà Nẵng</a>.</p>
{$cta('The Legend')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'The Legend Đà Nẵng của chủ đầu tư nào? VIPICO',
			'desc'      => 'The Legend Đà Nẵng của chủ đầu tư nào: Công ty TNHH MTV VIPICO, ROX Signature phát triển; lô A20 Võ Văn Kiệt đầu cầu Rồng, pháp lý hiện tại.',
			'points'    => array(
				'Chủ đầu tư Công ty TNHH MTV VIPICO, ROX Signature phát triển',
				'Lô A20 Võ Văn Kiệt, đầu cầu Rồng; khởi công 28/02/2025',
				'Khu đất từng tranh chấp, đã tháo gỡ; 800 căn đủ điều kiện bán',
			),
			'faq'       => array(
				array( 'The Legend Đà Nẵng của chủ đầu tư nào?', 'Công ty TNHH MTV VIPICO là chủ đầu tư; Công ty CP ROX Signature là đơn vị phát triển.' ),
				array( 'The Legend City và The Legend Đà Nẵng có phải một dự án?', 'Đúng, The Legend City Danang (Thành phố huyền thoại – Đà Nẵng) là tên đầy đủ của dự án trên lô A20 Võ Văn Kiệt.' ),
				array( 'The Legend Đà Nẵng ở đâu?', 'Lô A20 Võ Văn Kiệt, An Hải Tây (Sơn Trà cũ), ngay đầu cầu Rồng, 4 mặt tiền Võ Văn Kiệt – Ngô Quyền – Lý Nam Đế – Mai Hắc Đế.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- Sun Symphony 5 ở đâu ---------------- */
	$posts[] = array(
		'slug'     => 'sun-symphony-5-o-dau-vi-tri',
		'title'    => 'Sun Symphony 5 ở đâu? Vị trí bên sông Hàn, cách cầu Rồng 1,5 km, biển Mỹ Khê 2,5 km',
		'excerpt'  => 'Sun Symphony 5 (Symphony 5 – Sun Symphony Residence) nằm trên đường Lê Văn Duyệt, phường Sơn Trà (Nại Hiên Đông cũ), bờ Đông sông Hàn: cách cầu Rồng 1,5 km, biển Mỹ Khê 2,5 km, sân bay 6 km. Tiện ích xung quanh, tổng mặt bằng.',
		'keyword'  => 'Sun Symphony 5 ở đâu',
		'keywords_extra' => array( 'Symphony 5 ở đâu', 'Sun Symphony 5 vị trí', 'vị trí Symphony 5 Đà Nẵng' ),
		'project'  => 'symphony-5-sun-symphony-residence',
		'schedule' => '2026-11-25 14:00',
		'category' => 'Dự án',
		'tags'     => array( 'Symphony 5', 'Sun Symphony Residence', 'Sơn Trà' ),
		'image'    => 'plugin:img/sun-symphony-5/sun-symphony-5-pc-09-ban-ngay.jpg',
		'image_alt' => 'Tổ hợp Sun Symphony Residence ban ngày nhìn về trung tâm Đà Nẵng (phối cảnh chủ đầu tư)',
		'content'  => <<<HTML
<div class="hh-answer">
<p><strong>Sun Symphony 5 ở đâu?</strong> Tháp Symphony 5 nằm trên <strong>đường Lê Văn Duyệt, phường Sơn Trà (Nại Hiên Đông cũ), bờ Đông sông Hàn</strong>, là mảnh ghép cuối của tổ hợp Sun Symphony Residence. Từ dự án đi cầu Rồng khoảng 1,5 km, trung tâm hành chính 2 km, biển Mỹ Khê 2,5 km, Đà Nẵng Downtown 5 km, sân bay 6 km. Ngay trước dự án là điểm ngắm pháo hoa quốc tế DIFF.</p>
{$sign}
</div>
<p>"Sun Symphony 5 ở đâu", "Symphony 5 vị trí" là những câu khách gõ nhiều nhất trước khi xem giá. Bài này mô tả vị trí <a href="/du-an/symphony-5-sun-symphony-residence/">Sun Symphony 5</a>, khoảng cách tới các điểm chính và tiện ích trong, ngoài dự án.</p>
<!--hh-featured-->
<h2>Sun Symphony 5 ở đâu: khoảng cách tới các điểm chính</h2>
<table>
<thead><tr><th>Điểm đến</th><th>Khoảng cách</th></tr></thead>
<tbody>
<tr><td>Cầu Rồng</td><td>1,5 km</td></tr>
<tr><td>Trung tâm hành chính thành phố</td><td>2 km</td></tr>
<tr><td>Biển Mỹ Khê</td><td>2,5 km</td></tr>
<tr><td>Đà Nẵng Downtown</td><td>5 km</td></tr>
<tr><td>Sân bay quốc tế Đà Nẵng</td><td>6 km</td></tr>
</tbody>
</table>
<h2>Tổng mặt bằng phân khu</h2>
<p>Symphony 5 là tháp 31 tầng trên khoảng 11.371 m² đất thương mại dịch vụ. Xung quanh tháp có công viên thể thao khoảng 10.000 m², Central Park khoảng 5.000 m², công viên ven sông khoảng 4.000 m², bến du thuyền và đường dạo bộ ven sông Hàn.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-tmb.jpg|Tổng mặt bằng phân khu Symphony 5 – Sun Symphony Residence (tài liệu chủ đầu tư)-->
<h2>View từ căn hộ</h2>
<ul>
<li><strong>Sông Hàn, cầu Thuận Phước:</strong> hướng được hỏi nhiều nhất, xem pháo hoa DIFF.</li>
<li><strong>Cảng Thọ Quang, bán đảo Sơn Trà:</strong> thoáng, giá mềm hơn.</li>
<li><strong>Trung tâm Đà Nẵng:</strong> nhìn qua sông về phía Hải Châu.</li>
</ul>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-03-view-cau-thuan-phuoc.jpg|Ban công Symphony 5 nhìn cầu Thuận Phước về đêm (phối cảnh chủ đầu tư)-->
<h2>Tiện ích trong tòa</h2>
<p>Bể bơi, gym, sân yoga tầng 27 nhìn biển, spa và sauna, kids club, club house, phố thương mại khối đế.</p>
<h2>Thông tin nhanh</h2>
<ul>
<li>Chủ đầu tư: Công ty TNHH Mặt Trời Sông Hàn (thành viên Sun Group).</li>
<li>1.228 căn: 725 studio, 331 căn 1PN+, 160 căn 2PN, 12 penthouse; sở hữu 50 năm.</li>
<li>Giá studio từ khoảng 2,50 tỷ (giỏ hàng 11/2026); nhận căn sử dụng dự kiến 30/06/2028.</li>
</ul>
<p>Xem thêm: <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá Sun Symphony 5</a>, <a href="/mat-bang-can-ho-symphony-5/">mặt bằng Symphony 5</a>.</p>
<h2>Symphony 5 trong tổ hợp Sun Symphony Residence</h2>
<p>Sun Symphony Residence là tổ hợp căn hộ và thấp tầng của Sun Group bên bờ Đông sông Hàn. Các phân khu trước đã và đang bàn giao (thấp tầng từ quý 2/2025, căn hộ quý 1 – 2/2026 theo kế hoạch). Symphony 5 là mảnh ghép cuối, do Công ty TNHH Mặt Trời Sông Hàn (thành viên Sun Group) làm chủ đầu tư, trên khu đất thương mại dịch vụ khoảng 11.371 m², tổng vốn hơn 3.716 tỷ đồng.</p>
<p>Xem tổng quan tổ hợp: <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>.</p>
<h2>Vị trí này hợp với ai</h2>
<ul>
<li><strong>Người làm việc ở trung tâm:</strong> qua cầu Rồng là vào Hải Châu, cách trung tâm hành chính khoảng 2 km.</li>
<li><strong>Người mua để cho thuê:</strong> khách công tác, khách đi sự kiện, mùa pháo hoa DIFF; vẫn chỉ khoảng 2,5 km ra biển Mỹ Khê.</li>
<li><strong>Người thích không gian xanh:</strong> công viên thể thao, Central Park và công viên ven sông ngay trong phân khu.</li>
</ul>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-10-ban-ngay-2.jpg|Symphony 5 và bờ Đông sông Hàn lúc bình minh (phối cảnh chủ đầu tư)-->
<h2>So khoảng cách với các dự án Sun Group khác</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Điểm nhấn khoảng cách</th></tr></thead>
<tbody>
<tr><td>Sun Symphony 5</td><td>Bờ Đông sông Hàn (Sơn Trà)</td><td>Cầu Rồng 1,5 km, biển Mỹ Khê 2,5 km</td></tr>
<tr><td><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a></td><td>Biển Sơn Thủy (Ngũ Hành Sơn)</td><td>Đối diện công viên bãi tắm; khoảng 4 km tới Đà Nẵng Downtown</td></tr>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a></td><td>Sun NeO City (Hòa Xuân)</td><td>Giao lộ Nguyễn Phước Lan – đường 29/3</td></tr>
</tbody>
</table>
<h2>Pháp lý và nhận nhà</h2>
<ul>
<li>Đấu giá quyền sử dụng đất 14/12/2025, chấp thuận nhà đầu tư 12/03/2026, quy hoạch 1/500 phê duyệt 23/4/2026.</li>
<li>Sở hữu 50 năm (đất thương mại dịch vụ). Xem <a href="/phap-ly-symphony-5-so-huu-50-nam/">pháp lý Symphony 5</a>.</li>
<li>Thanh toán tối thiểu 70% nhận căn sử dụng dự kiến 30/06/2028 (Sun Early Key); bàn giao chính thức theo tiến độ không vay dự kiến 30/06/2030.</li>
</ul>
<h2>Giá và chính sách tại vị trí này</h2>
<p>Giỏ hàng 11/2026: studio 30 – 33 m² khoảng 2,50 – 3,30 tỷ, 1PN khoảng 3,09 – 3,30 tỷ, 1PN+ khoảng 3,45 – 4,54 tỷ (gồm VAT và phí bảo trì). Vay tối đa 70%, hỗ trợ lãi suất tối đa 30 tháng; không vay chiết khấu 5%. Chi tiết: <a href="/gia-symphony-5-sun-symphony-residence-bao-nhieu/">giá Sun Symphony 5</a>.</p>
<!--hh-img:img/sun-symphony-5/sun-symphony-5-pc-11-hoang-hon.jpg|Symphony 5 – Sun Symphony Residence bên sông Hàn lúc hoàng hôn (phối cảnh chủ đầu tư)-->
<h2>Cách đi từ Symphony 5</h2>
<ul>
<li><strong>Vào trung tâm Hải Châu:</strong> qua cầu Rồng hoặc cầu sông Hàn.</li>
<li><strong>Ra biển Mỹ Khê:</strong> đi theo trục Đông – Tây về Võ Nguyên Giáp.</li>
<li><strong>Ra sân bay:</strong> qua sông về phía Hải Châu, khoảng 6 km.</li>
</ul>
<h2>Sống ở bờ Đông sông Hàn</h2>
<p>Bờ Đông sông Hàn (Sơn Trà) là khu vực có nhiều dự án căn hộ mới của Đà Nẵng, nằm giữa trung tâm Hải Châu bên kia sông và bãi biển Mỹ Khê phía Đông. Người ở đây có thể đi bộ dọc sông, ngắm cầu Rồng, cầu Thuận Phước về đêm; mùa lễ hội pháo hoa quốc tế DIFF, khu vực ven sông là điểm xem pháo hoa quen thuộc. Với căn hộ cho thuê, vị trí này phục vụ cả khách du lịch biển lẫn khách công tác ở trung tâm.</p>
{$cta('Sun Symphony 5')}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Symphony 5 ở đâu? Vị trí bên sông Hàn',
			'desc'      => 'Sun Symphony 5 ở đâu: đường Lê Văn Duyệt, Sơn Trà, bờ Đông sông Hàn; cách cầu Rồng 1,5 km, biển Mỹ Khê 2,5 km, sân bay 6 km.',
			'points'    => array(
				'Đường Lê Văn Duyệt, phường Sơn Trà, bờ Đông sông Hàn',
				'Cầu Rồng 1,5 km, biển Mỹ Khê 2,5 km, sân bay 6 km',
				'Công viên thể thao 10.000 m², Central Park 5.000 m², bến du thuyền',
			),
			'faq'       => array(
				array( 'Sun Symphony 5 ở đâu?', 'Đường Lê Văn Duyệt, phường Sơn Trà (Nại Hiên Đông cũ), bờ Đông sông Hàn, Đà Nẵng – thuộc tổ hợp Sun Symphony Residence.' ),
				array( 'Sun Symphony 5 cách biển bao xa?', 'Khoảng 2,5 km tới biển Mỹ Khê; cách cầu Rồng 1,5 km và sân bay 6 km.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
