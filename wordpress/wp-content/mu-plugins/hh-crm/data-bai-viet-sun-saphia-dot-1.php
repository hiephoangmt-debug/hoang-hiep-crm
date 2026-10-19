<?php
/**
 * Loạt bài hằng ngày quanh thị trường – sản phẩm, dẫn link về dự án Sun Saphia Residence (đợt 1: 20 – 26/10/2026).
 * Mỗi bài hẹn đăng 8:00 sáng giờ Việt Nam ('schedule'); nạp qua filter hh_news_posts, tạo bằng nút Dự án → Nhập dữ liệu Đà Nẵng.
 * Số liệu lấy từ dữ liệu dự án trên web, báo chí, văn bản pháp luật; giá ghi rõ tham khảo / tin rao.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_1' );
function hh_posts_sun_saphia_dot_1( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$cta    = '<p>Đăng ký nhận bảng giá, mặt bằng và chính sách ' . $saphia . ' ngay khi mở bán, hoặc cần so sánh với các dự án khác cùng tầm tiền, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 20/10 – Studio ven biển ---------------- */
	$posts[] = array(
		'slug'     => 'studio-ven-bien-da-nang-gia-mua-gia-thue-2026',
		'title'    => 'Studio ven biển Đà Nẵng 2026: giá mua, giá thuê, dòng tiền và 513 studio Sun Saphia Residence',
		'excerpt'  => 'Studio ven biển Đà Nẵng 2026: căn 30 – 38 m² gần biển Mỹ Khê, Sơn Thủy giá khoảng 2,3 – 3,7 tỷ; cách tính lợi suất cho thuê và những dự án đang có studio như Sun Saphia, Sun Costa, Wyndham Soleil.',
		'keyword'  => 'studio ven biển Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ studio Đà Nẵng', 'studio cho thuê Đà Nẵng', 'studio Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-20',
		'category' => 'Thị trường',
		'tags'     => array( 'Căn hộ studio', 'Căn hộ biển Đà Nẵng', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/studio-ven-bien-da-nang-2026.jpg',
		'content'  => <<<HTML
<p><strong>Studio ven biển Đà Nẵng</strong> là dòng sản phẩm được tung ra nhiều nhất năm 2025 – 2026: diện tích 30 – 38 m², tổng tiền dễ tiếp cận và hợp cho thuê khách du lịch. Bài tổng hợp giá mua, giá thuê tham khảo, cách tự tính dòng tiền, và 513 căn studio của dự án mới {$saphia} tại khu biển Sơn Thủy.</p>
<!--hh-featured-->
<h2>Giá studio ven biển Đà Nẵng ở các dự án (10/2026)</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Diện tích studio</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>{$saphia}</td><td>Trường Sa, khu Sơn Thủy, Ngũ Hành Sơn</td><td>30 – 31 m² (513 căn)</td><td>Chưa công bố – đang nhận giữ chỗ</td></tr>
<tr><td><a href="/du-an/sun-costa-residence/">Sun Costa Residence</a></td><td>Vương Thừa Vũ, cách biển Mỹ Khê 200 – 300 m</td><td>Khoảng 31 – 37 m²</td><td>Giá bán 2025 khoảng 2,45 – 2,95 tỷ (chưa VAT)</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a></td><td>02 Phạm Văn Đồng, Sơn Trà</td><td>27,9 – 38,2 m²</td><td>Khoảng 2,95 – 3,69 tỷ (chính sách 1/2026); tòa D chuyển nhượng khoảng 2,4 – 3,8 tỷ</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Trần Thị Lý, ven sông Hàn</td><td>–</td><td>Chuyển nhượng khoảng 1,8 – 2,5 tỷ (tin rao)</td></tr>
</tbody>
</table>
<p>Giá trong bảng là giá chính sách hoặc giá rao chuyển nhượng, chưa phải giá chốt từng căn.</p>
<h2>Giá thuê studio ven biển và lợi suất</h2>
<p>Theo báo cáo quý 3/2026 của Batdongsan.com.vn, căn hộ cho thuê ở Đà Nẵng mang lại lợi suất khoảng <strong>4,5%/năm</strong> trên giá mua. Studio gần biển thường cho thuê theo ngày, theo tháng cho khách du lịch và người làm việc từ xa; giá thuê dao động mạnh theo mùa (cao điểm tháng 4 – 8, các dịp pháo hoa, lễ Tết).</p>
<h3>Cách tự tính dòng tiền một căn studio</h3>
<ol>
<li><strong>Doanh thu năm</strong> = giá thuê bình quân mỗi đêm × số đêm có khách (công suất) – hoặc giá thuê tháng × 12.</li>
<li><strong>Trừ chi phí</strong>: phí quản lý tòa nhà, phí vận hành/nền tảng đặt phòng (thường tính theo % doanh thu), điện nước, khấu hao nội thất, thuế cho thuê.</li>
<li><strong>Lợi suất ròng</strong> = lợi nhuận năm ÷ tổng tiền mua (gồm VAT, phí bảo trì, nội thất).</li>
</ol>
<p>Ví dụ giả định để minh họa: căn 3 tỷ, lợi nhuận ròng 135 triệu/năm thì lợi suất ròng 4,5%. Nếu vay ngân hàng, cần so lợi suất với lãi vay sau thời gian ưu đãi.</p>
<h2>Vì sao các dự án mới nhiều studio?</h2>
<p>Tổng tiền thấp giúp nhiều người mua được căn biển đầu tiên, và studio dễ cho thuê ngắn ngày. Đổi lại, nguồn cung studio lớn (riêng Sun Saphia có 513 căn, Sun Costa khoảng 80% là studio) khiến cạnh tranh cho thuê cao – căn tầng cao, view biển, có đơn vị vận hành tốt sẽ có lợi thế.</p>
<p>Xem thêm: <a href="/condotel-can-ho-dich-vu-da-nang-tong-hop-gia-2026/">tổng hợp condotel, căn hộ dịch vụ Đà Nẵng 2026</a>, <a href="/thue-can-ho-bien-my-khe-gia-theo-du-an/">giá thuê căn hộ biển Mỹ Khê theo dự án</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Studio ven biển Đà Nẵng: giá, dòng tiền, studio Sun Saphia',
			'desc'      => 'Studio ven biển Đà Nẵng 2026: căn 30 – 38 m² khoảng 2,3 – 3,7 tỷ, cách tính lợi suất cho thuê, 513 studio Sun Saphia Residence đang nhận giữ chỗ.',
			'points'    => array(
				'Studio 30 – 38 m² gần biển giá khoảng 2,3 – 3,7 tỷ (tham khảo 10/2026)',
				'Lợi suất cho thuê căn hộ Đà Nẵng khoảng 4,5%/năm (Batdongsan.com.vn, quý 3/2026)',
				'Sun Saphia Residence có 513 studio 30 – 31 m², đang nhận giữ chỗ',
			),
			'faq'       => array(
				array( 'Studio ven biển Đà Nẵng giá bao nhiêu?', 'Tham khảo 10/2026: studio 30 – 38 m² gần biển Mỹ Khê khoảng 2,3 – 3,7 tỷ tùy dự án, tầng và view; Sun Saphia Residence chưa công bố giá.' ),
				array( 'Cho thuê studio ở Đà Nẵng lãi bao nhiêu?', 'Mặt bằng chung khoảng 4,5%/năm trên giá mua theo Batdongsan.com.vn quý 3/2026; từng căn khác nhau theo vị trí, mùa du lịch và đơn vị vận hành.' ),
			),
		),
		'sources'  => array( 'https://batdongsan.com.vn/ban-condotel-wyndham-soleil-da-nang' ),
	);

	/* ---------------- 21/10 – Mở rộng đường ven biển ---------------- */
	$posts[] = array(
		'slug'     => 'mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty',
		'title'    => 'Mở rộng đường Võ Nguyên Giáp – Trường Sa 2.633 tỷ: Sun Saphia Residence và bất động sản ven biển hưởng lợi gì?',
		'excerpt'  => 'Đà Nẵng đưa dự án mở rộng đường ven biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân, vốn dự kiến 2.633 tỷ đồng, vào nhóm "luồng xanh". Tác động tới căn hộ, khách sạn, đất ven biển Ngũ Hành Sơn.',
		'keyword'  => 'mở rộng đường Võ Nguyên Giáp Trường Sa',
		'keywords_extra' => array( 'Sun Saphia Residence', 'đường ven biển Đà Nẵng', 'đường Trường Sa mở rộng', 'bất động sản ven biển Ngũ Hành Sơn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-21',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Đường Trường Sa', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/mo-rong-duong-ven-bien-vo-nguyen-giap-truong-sa.jpg',
		'content'  => <<<HTML
<p>Dự án <strong>mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân</strong>, trục ven biển nối trung tâm Đà Nẵng với Hội An, được thành phố đưa vào nhóm dự án đầu tư công ưu tiên giải quyết thủ tục theo cơ chế "luồng xanh", với vốn dự kiến <strong>2.633 tỷ đồng</strong> (Tuổi Trẻ, 10/2026). Tuyến đi ngang khu biển Sơn Thủy, nơi Sun Group đang ra mắt {$saphia}.</p>
<!--hh-featured-->
<h2>Dự án mở rộng đường Võ Nguyên Giáp – Trường Sa gồm những gì?</h2>
<ul>
<li>Tuyến ven biển Hoàng Sa – Võ Nguyên Giáp – Trường Sa – Lạc Long Quân đi Hội An; lãnh đạo thành phố đã cơ bản thống nhất phương án hướng tuyến và giao lập thiết kế cảnh quan (Tuổi Trẻ, Cafeland, 3/2026).</li>
<li>Phương án nghiên cứu nâng tuyến từ 4 làn xe (15 m) lên 6 làn xe (21 m); có đề xuất hầm chui hoặc cầu vượt cho người đi bộ ra biển.</li>
<li>Vốn dự kiến 2.633 tỷ đồng – con số có thể thay đổi khi dự án được phê duyệt chính thức; chưa công bố thời điểm khởi công.</li>
</ul>
<h2>Bất động sản nào hưởng lợi?</h2>
<p><strong>Khách sạn và căn hộ mặt tiền ven biển</strong>: đường rộng hơn, lối qua đường an toàn hơn giúp khách lưu trú dễ ra biển – lợi thế cho các khu đang hình thành như bãi tắm Sơn Thủy, nơi thành phố đầu tư công viên công cộng khoảng 2,45 ha và Sun Group phát triển tòa căn hộ 30 tầng {$saphia}.</p>
<p><strong>Đất ven biển Trường Sa</strong>: mặt bằng rao bán hiện khoảng 100 triệu/m² với lô 300 m² và 60 – 130 triệu/m² với lô lớn (giá rao tham khảo, xem <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>). Khi dự án chưa khởi công, cần thận trọng với tin "sắp mở đường" dùng để đẩy giá.</p>
<h2>Lưu ý khi mua nhà dọc tuyến</h2>
<ul>
<li>Kiểm tra lô đất có nằm trong phạm vi mở rộng lộ giới hay không trước khi đặt cọc.</li>
<li>Thời gian thi công kéo dài có thể ảnh hưởng tạm thời tới kinh doanh, cho thuê mặt tiền.</li>
<li>Căn hộ nhìn ra biển phía Đông tuyến đường hưởng lợi rõ nhất về tầm nhìn và lối ra biển.</li>
</ul>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mở rộng đường Võ Nguyên Giáp Trường Sa: lợi cho Sun Saphia',
			'desc'      => 'Mở rộng đường Võ Nguyên Giáp – Trường Sa vốn dự kiến 2.633 tỷ, 4 lên 6 làn: tác động tới Sun Saphia Residence, khách sạn, đất ven biển Ngũ Hành Sơn.',
			'points'    => array(
				'Vốn dự kiến 2.633 tỷ đồng, thuộc nhóm "luồng xanh" ưu tiên thủ tục (Tuổi Trẻ, 10/2026)',
				'Phương án nghiên cứu nâng từ 4 làn (15 m) lên 6 làn (21 m)',
				'Hưởng lợi rõ nhất: khách sạn, căn hộ mặt tiền ven biển như khu Sơn Thủy',
			),
			'faq'       => array(
				array( 'Đường Võ Nguyên Giáp – Trường Sa mở rộng bao nhiêu làn?', 'Phương án nghiên cứu nâng từ 4 làn xe (15 m) lên 6 làn xe (21 m); thiết kế chính thức theo quyết định phê duyệt dự án.' ),
				array( 'Khi nào khởi công mở rộng đường ven biển Đà Nẵng?', 'Đến 10/2026 chưa công bố thời điểm khởi công; dự án đang được ưu tiên giải quyết thủ tục theo cơ chế luồng xanh.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/da-nang-mo-luong-xanh-cho-loat-du-an-dau-tu-cong-100261007145100694.htm',
			'https://tuoitre.vn/da-nang-nghien-cuu-mo-rong-tuyen-duong-bien-nguyen-tat-thanh-vo-nguyen-giap-20260313110801128.htm',
			'https://cafeland.vn/tin-tuc/da-nang-nghien-cuu-mo-rong-duong-ven-bien-hoang-sa-vo-nguyen-giap-truong-sa-hoi-an-va-duong-nguyen-tat-thanh-149544.html',
		),
	);

	/* ---------------- 22/10 – Đường sắt đô thị ---------------- */
	$posts[] = array(
		'slug'     => 'duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi',
		'title'    => 'Đường sắt đô thị sân bay – Mỹ Khê – Hội An: tiến độ mới nhất, căn hộ ven biển như Sun Saphia Residence hưởng lợi',
		'excerpt'  => 'Tuyến đường sắt đô thị nối sân bay Đà Nẵng – biển Mỹ Khê – Hội An được ưu tiên nghiên cứu, doanh nghiệp lập hồ sơ cho biết dự kiến khởi công 2/2027. Tác động tới căn hộ ven biển, ven sông.',
		'keyword'  => 'đường sắt đô thị Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'LRT sân bay Mỹ Khê', 'đường sắt đô thị Đà Nẵng Hội An', 'căn hộ gần ga đường sắt đô thị' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-22',
		'category' => 'Thị trường',
		'tags'     => array( 'Hạ tầng Đà Nẵng', 'Đường sắt đô thị', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/duong-sat-do-thi-san-bay-my-khe-hoi-an.jpg',
		'content'  => <<<HTML
<p><strong>Đường sắt đô thị Đà Nẵng</strong> tuyến sân bay – Hội An là tuyến được thành phố ưu tiên nghiên cứu đầu tiên trong mạng lưới 17 trục, dài hơn 204 km đến năm 2045. Giai đoạn đầu là tuyến LRT nối <strong>sân bay với biển Mỹ Khê</strong>, sau đó kéo dài về Hội An – Tam Kỳ – Chu Lai, đi qua dải ven biển Ngũ Hành Sơn nơi có dự án {$saphia}.</p>
<!--hh-featured-->
<h2>Tiến độ đường sắt đô thị Đà Nẵng (10/2026)</h2>
<table>
<thead><tr><th>Mốc</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>Quy hoạch</td><td>17 trục đường sắt đô thị, hơn 204 km đến 2045; tuyến sân bay – Hội An – Tam Kỳ – Chu Lai ưu tiên số 1</td></tr>
<tr><td>Giai đoạn 1 (đến 2030)</td><td>LRT sân bay – biển Mỹ Khê (hơn 7 km) và MRT từ Đại học Việt – Hàn đến ga Đà Nẵng (hơn 17 km); trước đó thành phố từng kêu gọi đầu tư phương án 14,9 km, 19 trạm, 1 depot</td></tr>
<tr><td>Nhà đầu tư</td><td>Sở Tài chính chấp thuận giao Công ty Đại Quang Minh (Thaco) lập hồ sơ đề xuất dự án; Đèo Cả cũng đề xuất theo hình thức PPP</td></tr>
<tr><td>Khởi công</td><td>Thaco cho biết dự kiến khởi công tháng 2/2027 sau khi được phê duyệt dự án và kết quả lựa chọn nhà đầu tư (Tuổi Trẻ, 4/2026)</td></tr>
</tbody>
</table>
<h2>Căn hộ nào hưởng lợi từ đường sắt đô thị?</h2>
<p>Thành phố định hướng phát triển đô thị theo mô hình TOD (lấy giao thông công cộng làm trung tâm) dọc tuyến. Hưởng lợi nhiều nhất là căn hộ cho thuê gần các ga khu biển Mỹ Khê – Ngũ Hành Sơn: khách du lịch đi từ sân bay về biển nhanh hơn, ít phụ thuộc taxi. Khu ven biển phía Nam như bãi tắm Sơn Thủy – nơi có {$saphia} – nằm trên hướng kéo dài về Hội An.</p>
<h2>Đừng mua chỉ vì "sắp có metro"</h2>
<ul>
<li>Dự án chưa được phê duyệt chính thức; vị trí ga cụ thể chưa công bố.</li>
<li>Đường sắt đô thị thường mất nhiều năm từ khởi công đến vận hành – nên xem là yếu tố cộng thêm dài hạn.</li>
<li>Giá trị căn hộ vẫn quyết định bởi pháp lý, chất lượng xây dựng, đơn vị vận hành và giá mua hợp lý.</li>
</ul>
<p>Xem thêm: <a href="/mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty/">mở rộng đường Võ Nguyên Giáp – Trường Sa</a>, <a href="/mo-rong-nha-ga-t2-san-bay-da-nang-bat-dong-san-cho-thue/">mở rộng nhà ga T2 sân bay Đà Nẵng</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đường sắt đô thị Đà Nẵng: tiến độ và căn hộ như Sun Saphia',
			'desc'      => 'Đường sắt đô thị Đà Nẵng sân bay – Mỹ Khê – Hội An: 17 trục 204 km, LRT giai đoạn 1, dự kiến khởi công 2/2027; căn hộ ven biển như Sun Saphia hưởng lợi.',
			'points'    => array(
				'Tuyến sân bay – Hội An được ưu tiên số 1 trong 17 trục đường sắt đô thị',
				'Giai đoạn 1: LRT sân bay – biển Mỹ Khê hơn 7 km',
				'Doanh nghiệp lập hồ sơ cho biết dự kiến khởi công 2/2027 nếu được phê duyệt',
			),
			'faq'       => array(
				array( 'Khi nào Đà Nẵng làm đường sắt đô thị?', 'Theo Tuổi Trẻ (4/2026), Thaco cho biết dự kiến khởi công tháng 2/2027 sau khi được phê duyệt dự án và kết quả lựa chọn nhà đầu tư.' ),
				array( 'Đường sắt đô thị Đà Nẵng đi qua đâu?', 'Tuyến ưu tiên nối sân bay Đà Nẵng – biển Mỹ Khê, kéo dài về Hội An – Tam Kỳ – Chu Lai; vị trí ga cụ thể chưa công bố.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/tuyen-duong-sat-do-thi-da-nang-se-khoi-cong-vao-thang-2-2027-20260420182515178.htm',
			'https://tuoitre.vn/da-nang-uu-tien-lam-tuyen-duong-sat-do-thi-noi-tu-san-bay-voi-hoi-an-20251024131105174.htm',
			'https://nhadautu.vn/da-nang-keu-goi-dau-tu-du-an-duong-sat-do-thi-ket-noi-san-bay-d90707.html',
		),
	);

	/* ---------------- 23/10 – Sun Group ở Đà Nẵng ---------------- */
	$posts[] = array(
		'slug'     => 'du-an-can-ho-sun-group-da-nang-2026',
		'title'    => 'Các dự án căn hộ Sun Group ở Đà Nẵng 2026: từ Sun Symphony đến Sun Saphia Residence – vị trí, bàn giao, giá',
		'excerpt'  => 'Tổng hợp dự án căn hộ Sun Group tại Đà Nẵng: Sun Symphony, Sun Ponte, Sun Cosmo đang bàn giao; Sun Costa, Sun Solar, Spana, Cora, S-Light, FourS đang bán; Sun Galaxy, Sun Saphia sắp mở bán.',
		'keyword'  => 'dự án căn hộ Sun Group Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ Sun Group Đà Nẵng', 'Sun Property Đà Nẵng' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-23',
		'category' => 'Dự án',
		'tags'     => array( 'Sun Group', 'Căn hộ Đà Nẵng', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/du-an-can-ho-sun-group-da-nang-2026.jpg',
		'content'  => <<<HTML
<p>Sun Group (Sun Property phát triển) hiện là chủ đầu tư có nhiều <strong>dự án căn hộ</strong> nhất ở Đà Nẵng: từ ven sông Hàn, khu Nam Hòa Xuân đến ven biển Mỹ Khê, Sơn Thủy. Bài tổng hợp theo trạng thái: đang bàn giao, đang bán và sắp mở bán (10/2026) – mới nhất là {$saphia}, dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng.</p>
<!--hh-featured-->
<h2>Dự án căn hộ Sun Group Đà Nẵng đang bàn giao</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Quy mô · bàn giao</th><th>Giá chuyển nhượng tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a></td><td>Ven sông Hàn, Sơn Trà</td><td>1.313 căn hộ, 24 – 30 tầng · căn hộ quý 1 – 2/2026</td><td>Studio khoảng 3,2 – 3,6 tỷ; 2PN khoảng 6 – 8 tỷ</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Trần Hưng Đạo, cạnh cầu Rồng</td><td>495 căn hộ, 26 tầng · bàn giao từ 2026</td><td>Studio/1PN khoảng 2,96 – 4,49 tỷ; 2PN khoảng 4,3 – 6,9 tỷ</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Trần Thị Lý, Ngũ Hành Sơn</td><td>Khoảng 650 căn hộ · cuối 2025 – đầu 2026</td><td>Studio khoảng 1,8 – 2,5 tỷ; 2PN khoảng 3,6 – 6,8 tỷ</td></tr>
</tbody>
</table>
<h2>Dự án Sun Group đang bán</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Quy mô · bàn giao dự kiến</th><th>Pháp lý</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-costa-residence/">Sun Costa Residence</a></td><td>Vương Thừa Vũ, gần biển Mỹ Khê</td><td>25 tầng, khoảng 560 – 640 căn, phần lớn studio · quý IV/2026 – 2027</td><td>Căn hộ thương mại dịch vụ (các nguồn ghi khác nhau)</td></tr>
<tr><td><a href="/du-an/sun-solar-residence/">Sun Solar Residence</a></td><td>9 Lê Duẩn, Hải Châu</td><td>20 tầng, khoảng 256 căn · nhận căn dự kiến 28/4/2027 (Sun Early Key)</td><td>Theo hợp đồng mua bán</td></tr>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a>, <a href="/du-an/cora-tower/">Cora Tower</a>, <a href="/du-an/s-light-tower/">S-Light Tower</a></td><td>Sun NeO City, Hòa Xuân</td><td>22 tầng · Spana 30/6/2027, Cora 30/7/2027</td><td>Sở hữu lâu dài</td></tr>
<tr><td><a href="/du-an/fours-tower/">FourS Tower</a></td><td>Nguyễn Phước Lan – Minh Mạng, Sun Riverpolis</td><td>20 tầng · tòa F2 dự kiến 31/5/2028</td><td>Sở hữu lâu dài</td></tr>
</tbody>
</table>
<h2>Sắp mở bán: Sun Galaxy Complex và Sun Saphia Residence</h2>
<ul>
<li><a href="/du-an/sun-galaxy-complex/">Sun Galaxy Complex</a> (Chương Dương, ven sông Hàn): khởi công 25/7/2026, khán đài pháo hoa gần 20.000 chỗ, khoảng 1.400 phòng lưu trú; chưa có bảng giá chính thức.</li>
<li>{$saphia} (Trường Sa, khu Sơn Thủy): tòa 30 tầng (114 m), 782 căn gồm 513 studio, 108 căn 1PN+1, 149 căn 2PN; bàn giao dự kiến 11/2028. Chủ đầu tư giới thiệu đây là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng; đang nhận giữ chỗ.</li>
</ul>
<p>Các con số trên lấy từ dữ liệu dự án trên web và tin rao; bàn giao theo hợp đồng từng dự án.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Dự án căn hộ Sun Group Đà Nẵng 2026: đến Sun Saphia',
			'desc'      => 'Dự án căn hộ Sun Group Đà Nẵng 2026: Sun Symphony, Sun Ponte, Sun Cosmo bàn giao; Sun Costa, Spana, FourS đang bán; Sun Saphia Residence sắp bán.',
			'points'    => array(
				'Đang bàn giao: Sun Symphony, Sun Ponte, Sun Cosmo – giá chuyển nhượng từ khoảng 1,8 tỷ',
				'Đang bán: Sun Costa, Sun Solar, Spana, Cora, S-Light, FourS',
				'Sắp mở bán: Sun Galaxy Complex, Sun Saphia Residence (782 căn, bàn giao 11/2028)',
			),
			'faq'       => array(
				array( 'Sun Group có những dự án căn hộ nào ở Đà Nẵng?', 'Sun Symphony, Sun Ponte, Sun Cosmo (đang bàn giao); Sun Costa, Sun Solar, Spana, Cora, S-Light, FourS (đang bán); Sun Galaxy Complex, Sun Saphia Residence (sắp mở bán).' ),
				array( 'Dự án căn hộ mặt biển của Sun Group ở Đà Nẵng là dự án nào?', 'Sun Saphia Residence trên đường Trường Sa, khu Sơn Thủy – chủ đầu tư giới thiệu là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng.' ),
			),
		),
		'sources'  => array( 'https://cafeland.vn/tin-tuc/khoi-cong-du-an-gan-10750-ty-dong-tai-da-nang-153588.html' ),
	);

	/* ---------------- 24/10 – Giữ chỗ, đặt cọc ---------------- */
	$posts[] = array(
		'slug'     => 'giu-cho-booking-can-ho-moi-da-nang-can-biet',
		'title'    => 'Giữ chỗ (booking) căn hộ mới như Sun Saphia Residence: khác gì đặt cọc, có lấy lại tiền được không?',
		'excerpt'  => 'Booking, giữ chỗ căn hộ mới trước khi mở bán khác đặt cọc thế nào; Luật Kinh doanh bất động sản 2023 chỉ cho thu cọc tối đa 5% khi dự án đủ điều kiện; 6 điều cần kiểm tra trước khi giữ chỗ.',
		'keyword'  => 'giữ chỗ căn hộ',
		'keywords_extra' => array( 'Sun Saphia Residence', 'booking căn hộ', 'giữ chỗ Sun Saphia', 'đặt cọc căn hộ hình thành trong tương lai' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-24',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Kinh nghiệm mua nhà', 'Đặt cọc', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/giu-cho-booking-can-ho-moi.jpg',
		'content'  => <<<HTML
<p>Trước khi mở bán, nhiều dự án căn hộ ở Đà Nẵng nhận <strong>giữ chỗ căn hộ</strong> (booking) – khách nộp một khoản tiền để được ưu tiên chọn căn. Ví dụ, đơn vị phân phối {$saphia} thông báo nhận giữ chỗ khoảng 50 triệu đồng, có hoàn lại (10/2026). Giữ chỗ khác đặt cọc ở đâu và người mua cần lưu ý gì?</p>
<!--hh-featured-->
<h2>Giữ chỗ căn hộ khác đặt cọc thế nào?</h2>
<table>
<thead><tr><th></th><th>Giữ chỗ (booking)</th><th>Đặt cọc</th></tr></thead>
<tbody>
<tr><td>Thời điểm</td><td>Trước khi dự án đủ điều kiện bán, chưa có giá chính thức từng căn</td><td>Khi nhà ở hình thành trong tương lai đã đủ điều kiện đưa vào kinh doanh</td></tr>
<tr><td>Mục đích</td><td>Ưu tiên thứ tự chọn căn</td><td>Cam kết mua căn cụ thể, với giá bán ghi rõ</td></tr>
<tr><td>Số tiền</td><td>Do đơn vị bán quy định, thường cố định mỗi căn</td><td>Không quá 5% giá bán (Điều 23 Luật Kinh doanh bất động sản 2023)</td></tr>
<tr><td>Hoàn tiền</td><td>Thường hoàn lại nếu không chọn được căn hoặc không mua – phải ghi rõ trên phiếu</td><td>Theo thỏa thuận đặt cọc; bỏ cọc có thể mất tiền</td></tr>
</tbody>
</table>
<h2>Luật nói gì về thu tiền giữ chỗ căn hộ?</h2>
<p>Theo Luật Kinh doanh bất động sản 2023 (hiệu lực từ 1/8/2024), chủ đầu tư chỉ được thu tiền đặt cọc <strong>không quá 5% giá bán</strong> khi nhà ở hình thành trong tương lai đã đủ điều kiện đưa vào kinh doanh, và thỏa thuận đặt cọc phải ghi rõ giá bán, diện tích. Vì vậy trước thời điểm đó, khoản giữ chỗ chỉ nên coi là tiền thiện chí, cần được ghi rõ quyền hoàn lại.</p>
<h2>6 điều cần kiểm tra trước khi giữ chỗ căn hộ</h2>
<ol>
<li>Ai nhận tiền: chủ đầu tư, công ty phân phối hay cá nhân? Chuyển khoản vào tài khoản công ty, có phiếu thu.</li>
<li>Phiếu giữ chỗ ghi rõ: số tiền, thời hạn, điều kiện và thời gian hoàn tiền.</li>
<li>Dự án đã có văn bản đủ điều kiện bán của Sở Xây dựng chưa – nếu chưa, không ký thỏa thuận đặt cọc hay hợp đồng có giá trị lớn.</li>
<li>Giá bán dự kiến, chính sách thanh toán và chiết khấu áp dụng cho khách giữ chỗ.</li>
<li>Loại hình pháp lý: căn hộ sở hữu lâu dài hay căn hộ có thời hạn.</li>
<li>Không chuyển thêm tiền "giữ căn đẹp" ngoài phiếu chính thức.</li>
</ol>
<p>Xem thêm: <a href="/hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh/">hợp đồng đặt cọc mua nhà – rủi ro và cách phòng tránh</a>, <a href="/kinh-nghiem-mua-can-ho-da-nang/">kinh nghiệm mua căn hộ Đà Nẵng</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giữ chỗ căn hộ Sun Saphia: khác đặt cọc, có hoàn tiền?',
			'desc'      => 'Giữ chỗ căn hộ (booking) như Sun Saphia Residence khác đặt cọc thế nào; luật chỉ cho cọc tối đa 5% khi dự án đủ điều kiện; 6 điều cần kiểm tra.',
			'points'    => array(
				'Giữ chỗ là tiền ưu tiên chọn căn trước khi dự án đủ điều kiện bán',
				'Đặt cọc tối đa 5% giá bán, chỉ khi dự án đủ điều kiện kinh doanh (Luật KDBĐS 2023)',
				'Phiếu giữ chỗ phải ghi rõ quyền hoàn tiền, người nhận tiền là công ty',
			),
			'faq'       => array(
				array( 'Tiền giữ chỗ căn hộ có được hoàn lại không?', 'Tùy phiếu giữ chỗ; phần lớn dự án ghi hoàn lại nếu khách không chọn được căn hoặc không mua. Cần yêu cầu ghi rõ điều kiện và thời hạn hoàn tiền.' ),
				array( 'Chủ đầu tư được thu cọc bao nhiêu?', 'Theo Luật Kinh doanh bất động sản 2023, không quá 5% giá bán và chỉ khi nhà ở hình thành trong tương lai đã đủ điều kiện đưa vào kinh doanh.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 25/10 – So sánh khu biển ---------------- */
	$posts[] = array(
		'slug'     => 'can-ho-ven-bien-my-khe-son-thuy-non-nuoc-so-sanh',
		'title'    => 'Mua căn hộ ven biển Đà Nẵng: Mỹ Khê, Sơn Thủy (Sun Saphia Residence) hay Non Nước?',
		'excerpt'  => 'So sánh ba khu biển của Đà Nẵng để mua căn hộ: Mỹ Khê (Sơn Trà) sôi động, giá cao; Sơn Thủy (Ngũ Hành Sơn) đang hình thành công viên biển; Non Nước gần resort, yên tĩnh.',
		'keyword'  => 'căn hộ ven biển Đà Nẵng',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ biển Sơn Thủy', 'căn hộ biển Mỹ Khê', 'căn hộ Ngũ Hành Sơn ven biển' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-25',
		'category' => 'Thị trường',
		'tags'     => array( 'Căn hộ biển Đà Nẵng', 'Ngũ Hành Sơn', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/can-ho-ven-bien-my-khe-son-thuy-non-nuoc.jpg',
		'content'  => <<<HTML
<p>Bờ biển Đà Nẵng dài, nhưng mỗi đoạn một "tính cách". Khi chọn <strong>căn hộ ven biển Đà Nẵng</strong>, ba khu được hỏi nhiều nhất là Mỹ Khê (Sơn Trà), Sơn Thủy và Non Nước (Ngũ Hành Sơn). Bài so sánh nhanh để chọn đúng khu theo mục đích ở, nghỉ dưỡng hay cho thuê – kèm dự án mới {$saphia} ở Sơn Thủy.</p>
<!--hh-featured-->
<h2>So sánh ba khu căn hộ ven biển Đà Nẵng</h2>
<table>
<thead><tr><th></th><th>Mỹ Khê (Sơn Trà)</th><th>Sơn Thủy (Ngũ Hành Sơn)</th><th>Non Nước (Ngũ Hành Sơn)</th></tr></thead>
<tbody>
<tr><td>Không khí</td><td>Sôi động, gần trung tâm, nhiều nhà hàng, khách sạn</td><td>Đang hình thành: công viên biển, khu nghỉ dưỡng, khu dân cư mới</td><td>Yên tĩnh, gần danh thắng Ngũ Hành Sơn, resort lớn</td></tr>
<tr><td>Dự án căn hộ tiêu biểu</td><td><a href="/du-an/nobu-da-nang/">Nobu</a>, <a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a>, <a href="/du-an/sun-costa-residence/">Sun Costa</a>, <a href="/du-an/alize-da-nang/">Alizé</a></td><td>{$saphia}</td><td><a href="/du-an/hyatt-regency-danang-residences/">Hyatt Regency Residences</a></td></tr>
<tr><td>Giá đất mặt tiền (tin rao)</td><td>Võ Nguyên Giáp khoảng 130 – 390 triệu/m²</td><td>Trường Sa khoảng 60 – 130 triệu/m²</td><td>Trường Sa khoảng 60 – 130 triệu/m²</td></tr>
<tr><td>Hợp với</td><td>Cho thuê ngắn ngày, khách thích phố biển</td><td>Đầu tư đón hạ tầng, nghỉ dưỡng cuối tuần</td><td>Nghỉ dưỡng dài ngày, khách quốc tế</td></tr>
</tbody>
</table>
<h2>Sơn Thủy: khu biển đang thay đổi nhanh</h2>
<p>Đối diện bãi tắm Sơn Thủy, thành phố thu hồi khoảng 2,45 ha đất phía Nam dự án Hòn Ngọc Á Châu (bỏ hoang nhiều năm) để làm công viên công cộng, tổng mức đầu tư hơn 47 tỷ đồng, thực hiện 2025 – 2027. Cùng với kế hoạch mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân (vốn dự kiến 2.633 tỷ), khu biển này đang có thêm sản phẩm căn hộ đầu tiên của Sun Group tại Đà Nẵng: {$saphia}, 30 tầng, 782 căn, bàn giao dự kiến 11/2028.</p>
<h2>Chọn khu nào?</h2>
<ul>
<li><strong>Cần dòng tiền cho thuê ngay</strong>: Mỹ Khê vẫn đông khách nhất, nhưng giá mua cao và cạnh tranh nhiều.</li>
<li><strong>Đón hạ tầng, giá vào thấp hơn</strong>: Sơn Thủy – chấp nhận chờ công viên, đường ven biển hoàn thiện.</li>
<li><strong>Nghỉ dưỡng yên tĩnh</strong>: Non Nước, gần resort và sân golf ven biển.</li>
</ul>
<p>Xem thêm: <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Mỹ Khê</a>, <a href="/cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy/">công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Căn hộ ven biển Đà Nẵng: Mỹ Khê hay Sơn Thủy – Sun Saphia',
			'desc'      => 'Căn hộ ven biển Đà Nẵng: Mỹ Khê sôi động giá cao, Sơn Thủy có công viên biển và Sun Saphia Residence, Non Nước yên tĩnh gần resort.',
			'points'    => array(
				'Mỹ Khê: đông khách thuê nhất, giá đất mặt tiền 130 – 390 triệu/m² (tin rao)',
				'Sơn Thủy: công viên công cộng 2,45 ha, đường ven biển dự kiến mở rộng, có Sun Saphia',
				'Non Nước: yên tĩnh, gần resort, hợp nghỉ dưỡng dài ngày',
			),
			'faq'       => array(
				array( 'Nên mua căn hộ biển Mỹ Khê hay Sơn Thủy?', 'Mỹ Khê hợp cho thuê ngắn ngày ngay, giá cao; Sơn Thủy giá vào thấp hơn, đang hình thành công viên biển và đón hạ tầng đường ven biển.' ),
				array( 'Khu Sơn Thủy có dự án căn hộ nào?', 'Sun Saphia Residence của Sun Group trên đường Trường Sa: 30 tầng, 782 căn, bàn giao dự kiến 11/2028.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-xay-cong-vien-tren-dien-tich-dat-thu-hoi-tu-du-an-hon-ngoc-a-chau-post1122567.vnp',
			'https://tienphong.vn/da-nang-rot-47-ty-dong-danh-thuc-khu-dat-vang-bo-hoang-post1767479.html',
		),
	);

	/* ---------------- 26/10 – Mua từ xa ---------------- */
	$posts[] = array(
		'slug'     => 'mua-can-ho-da-nang-tu-ha-noi-tp-hcm-kinh-nghiem',
		'title'    => 'Ở Hà Nội, TP.HCM mua căn hộ Đà Nẵng từ xa: kinh nghiệm an toàn, ví dụ Sun Saphia Residence',
		'excerpt'  => 'Kinh nghiệm cho khách ở Hà Nội, TP.HCM, nước ngoài mua căn hộ Đà Nẵng mà không cần bay vào nhiều lần: xem nhà qua video, kiểm tra pháp lý từ xa, ủy quyền công chứng, thanh toán và giao căn cho thuê.',
		'keyword'  => 'mua căn hộ Đà Nẵng từ xa',
		'keywords_extra' => array( 'Sun Saphia Residence', 'mua nhà Đà Nẵng cho người Hà Nội', 'mua căn hộ Đà Nẵng online', 'ủy quyền mua nhà' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-10-26',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Kinh nghiệm mua nhà', 'Căn hộ Đà Nẵng', 'Sun Saphia Residence' ),
		'image'    => 'plugin:img/tin-tuc/mua-can-ho-da-nang-tu-xa.jpg',
		'content'  => <<<HTML
<p>Nhiều khách mua căn hộ Đà Nẵng đang sống ở Hà Nội, TP.HCM hay nước ngoài. <strong>Mua căn hộ Đà Nẵng từ xa</strong> hoàn toàn làm được nếu đi đúng các bước: xem kỹ trước qua video, kiểm tra pháp lý bằng giấy tờ, chỉ bay vào khi cần ký hoặc nhận nhà. Bài lấy ví dụ dự án mới {$saphia} (bàn giao dự kiến 11/2028).</p>
<!--hh-featured-->
<h2>5 bước mua căn hộ Đà Nẵng từ xa</h2>
<ol>
<li><strong>Chốt nhu cầu và tầm tiền</strong>: mua để ở nghỉ dưỡng, cho thuê hay giữ tài sản; khu biển hay khu sông Hàn.</li>
<li><strong>Xem nhà qua video trực tiếp</strong>: căn thật, view thật, hành lang, tiện ích – yêu cầu quay cả giờ cao điểm và buổi tối.</li>
<li><strong>Kiểm tra pháp lý qua bản chụp</strong>: văn bản đủ điều kiện bán (dự án mới), hợp đồng mua bán, sổ hồng (căn chuyển nhượng), xác nhận của chủ đầu tư về số tiền đã thanh toán.</li>
<li><strong>Ký và thanh toán</strong>: chuyển khoản vào tài khoản chủ đầu tư hoặc theo hợp đồng công chứng; có thể ủy quyền công chứng cho người thân ký thay nếu không vào được.</li>
<li><strong>Nhận nhà và cho thuê</strong>: giao cho đơn vị vận hành hoặc người quản lý tin cậy, nhận báo cáo doanh thu hằng tháng.</li>
</ol>
<h2>Những rủi ro thường gặp khi mua từ xa</h2>
<ul>
<li>Chuyển tiền cọc cho cá nhân không rõ ràng – luôn yêu cầu tài khoản công ty hoặc hợp đồng công chứng.</li>
<li>Ảnh, video không đúng căn – yêu cầu gọi video trực tiếp, quay số căn trên cửa.</li>
<li>Căn cho thuê không như quảng cáo – hỏi số liệu cho thuê thực tế của căn tương tự trong cùng tòa.</li>
</ul>
<h2>Dự án mới: lợi thế cho người mua ở xa</h2>
<p>Với căn hộ hình thành trong tương lai như {$saphia} (bàn giao dự kiến 11/2028), người mua ở xa có thời gian thanh toán theo tiến độ, theo dõi xây dựng qua ảnh, video định kỳ và chỉ cần vào nhận nhà. Đổi lại, cần kiểm tra kỹ văn bản đủ điều kiện bán và bảo lãnh ngân hàng trước khi ký.</p>
<p>Xem thêm: <a href="/giu-cho-booking-can-ho-moi-da-nang-can-biet/">giữ chỗ căn hộ mới cần biết gì</a>, <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">quy trình mua căn hộ chuyển nhượng</a>.</p>
{$cta}
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua căn hộ Đà Nẵng từ xa: kinh nghiệm, ví dụ Sun Saphia',
			'desc'      => 'Mua căn hộ Đà Nẵng từ xa an toàn: xem nhà qua video, kiểm tra pháp lý, ủy quyền công chứng, thanh toán đúng tài khoản – ví dụ dự án Sun Saphia Residence.',
			'points'    => array(
				'Xem căn qua video trực tiếp, kiểm tra pháp lý qua bản chụp trước khi bay vào',
				'Thanh toán vào tài khoản công ty hoặc theo hợp đồng công chứng',
				'Căn hình thành trong tương lai như Sun Saphia hợp người ở xa: thanh toán theo tiến độ',
			),
			'faq'       => array(
				array( 'Ở xa có mua được căn hộ Đà Nẵng không?', 'Được: xem căn qua video, kiểm tra pháp lý qua giấy tờ, ký hợp đồng khi vào hoặc ủy quyền công chứng cho người thân, thanh toán chuyển khoản theo hợp đồng.' ),
				array( 'Mua từ xa cần bay vào Đà Nẵng mấy lần?', 'Thường một lần để ký hợp đồng hoặc công chứng (nếu không ủy quyền) và một lần nhận nhà; các bước xem căn, kiểm tra pháp lý làm từ xa.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
