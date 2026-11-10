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
