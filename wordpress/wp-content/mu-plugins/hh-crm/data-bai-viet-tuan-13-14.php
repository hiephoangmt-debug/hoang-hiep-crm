<?php
/**
 * Bài viết kế hoạch nội dung – tuần 13–14 (biệt thự, villa nghỉ dưỡng; đất nền, khu vực, kinh nghiệm pháp lý – đặt cọc). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_13_14' );
function hh_posts_tuan_13_14( $posts ) {
	/* ---------------------------------------------------------------- Tuần 13 */
	$posts[] = array(
		'slug'     => 'biet-thu-vinpearl-da-nang-hoi-an-gia-chuyen-nhuong',
		'title'    => 'Biệt thự Vinpearl Đà Nẵng – Hội An: giá chuyển nhượng, pháp lý, cho thuê',
		'excerpt'  => 'Biệt thự Vinpearl Đà Nẵng – Hội An 2026: Vinpearl Luxury (Marriott) khoảng 40 – 75 tỷ, Vinpearl Đà Nẵng 2 khoảng 10 – 17 tỷ, Vinpearl Nam Hội An khoảng 9 – 16 tỷ (tin rao).',
		'keyword'  => 'biệt thự Vinpearl Đà Nẵng',
		'project'  => 'vinpearl-resort-spa-da-nang-villa',
		'week'     => 13,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Biệt thự Vinpearl Đà Nẵng</strong> hiện gồm ba nhóm đang giao dịch chuyển nhượng: 39 biệt thự Vinpearl Luxury Đà Nẵng (nay là Danang Marriott Resort &amp; Spa), khoảng 122 biệt thự Vinpearl Resort &amp; Spa Đà Nẵng (giai đoạn 2) trên đường Trường Sa, và 132 biệt thự Vinpearl Nam Hội An ở Thăng Bình. Chủ đầu tư đã bán hết, nên giá trên thị trường là giá chuyển nhượng giữa các chủ sở hữu. Bài viết tổng hợp mặt bằng giá tham khảo tháng 10/2026, pháp lý và chương trình cho thuê của từng nhóm.</p>

<h2>Ba khu biệt thự Vinpearl ở Đà Nẵng – Hội An</h2>
<table>
<thead><tr><th>Khu biệt thự</th><th>Vị trí</th><th>Quy mô</th><th>Diện tích đất</th></tr></thead>
<tbody>
<tr><td>Vinpearl Luxury Đà Nẵng (Danang Marriott Resort &amp; Spa)</td><td>Số 7 Trường Sa, Ngũ Hành Sơn – biển Non Nước</td><td>39 biệt thự, 200 phòng khách sạn, 15,4 ha</td><td>Khoảng 686 – 1.300 m²</td></tr>
<tr><td>Vinpearl Resort &amp; Spa Đà Nẵng (giai đoạn 2)</td><td>Đường Trường Sa, Ngũ Hành Sơn</td><td>Khoảng 122 biệt thự (có nguồn ghi 102 căn)</td><td>Khoảng 376 – 800 m²</td></tr>
<tr><td>Vinpearl Resort &amp; Golf Nam Hội An</td><td>Bình Minh – Bình Dương (Thăng Bình cũ), ven biển phía Nam Hội An</td><td>132 biệt thự, 429 phòng khách sạn, sân golf 18 lỗ</td><td>Phổ biến khoảng 380 – 500 m²</td></tr>
</tbody>
</table>

<h2>Giá chuyển nhượng biệt thự Vinpearl tham khảo 10/2026</h2>
<p>Bảng dưới là khoảng giá tổng hợp từ tin rao chuyển nhượng công khai 2025 – 2026, không phải bảng giá chủ đầu tư và chưa phải giá chốt.</p>
<table>
<thead><tr><th>Khu</th><th>Loại căn phổ biến</th><th>Giá chuyển nhượng tham khảo</th><th>Giá bán gốc khi mở bán</th></tr></thead>
<tbody>
<tr><td>Vinpearl Luxury Đà Nẵng</td><td>4PN, đất khoảng 1.000 m²</td><td>Khoảng 40 – 45 tỷ; có căn ven nước 829 m² rao khoảng 75 tỷ</td><td>–</td></tr>
<tr><td>Vinpearl Đà Nẵng 2</td><td>3PN, đất 450 – 500 m²</td><td>Khoảng 12 – 14 tỷ; căn 600 m² khoảng 15,8 – 17 tỷ</td><td>Khoảng 700.000 – 1,2 triệu USD/căn</td></tr>
<tr><td>Vinpearl Nam Hội An</td><td>3PN, đất khoảng 420 m²</td><td>Khoảng 9 – 12 tỷ; căn 500 m² khoảng 15,8 tỷ</td><td>Từ khoảng 16,8 tỷ/căn</td></tr>
</tbody>
</table>
<p>Điểm đáng chú ý: giá chuyển nhượng của Vinpearl Đà Nẵng 2 và Vinpearl Nam Hội An đang thấp hơn đáng kể so với giá bán gốc. Ngược lại, Vinpearl Luxury Đà Nẵng có đất lớn, số căn rất ít nên giữ mặt bằng giá cao hơn.</p>

<h2>Pháp lý biệt thự Vinpearl</h2>
<h3>Sổ đỏ và thời hạn sử dụng đất</h3>
<p>Theo thông tin công bố khi mở bán, biệt thự Vinpearl Luxury Đà Nẵng và Vinpearl Đà Nẵng 2 được cấp sổ đỏ, sở hữu lâu dài. Với Vinpearl Nam Hội An, chính sách mở bán giới thiệu sở hữu lâu dài nhưng người mua vẫn cần kiểm tra mục đích và thời hạn sử dụng đất ghi trên sổ của từng căn.</p>
<h3>Hợp đồng vận hành – thuê lại</h3>
<p>Phần lớn biệt thự Vinpearl nằm trong chương trình cho thuê lại do khu nghỉ dưỡng vận hành. Khi mua chuyển nhượng, anh chị nhận lại cả quyền và nghĩa vụ theo hợp đồng này: tỷ lệ chia lợi nhuận, số đêm nghỉ miễn phí, thời hạn còn lại, điều kiện chấm dứt. Đây là phần quyết định dòng tiền, cần đọc kỹ không kém sổ đỏ.</p>

<h2>Chương trình cho thuê: cam kết khi mở bán và thực tế hiện nay</h2>
<table>
<thead><tr><th>Khu</th><th>Chính sách khi mở bán</th><th>Thu nhập nêu trên tin rao (tham khảo)</th></tr></thead>
<tbody>
<tr><td>Vinpearl Luxury Đà Nẵng</td><td>Biệt thự trong chương trình vận hành của khu nghỉ dưỡng</td><td>Khoảng 3 – 3,4 tỷ/năm, chi trả 6 tháng/lần</td></tr>
<tr><td>Vinpearl Đà Nẵng 2</td><td>Lợi nhuận tối thiểu 8%/năm (USD) hoặc 10%/năm (VNĐ) trong 10 năm, chủ biệt thự hưởng 85%</td><td>Khoảng 1,55 tỷ/năm với căn 3PN 500 m²</td></tr>
<tr><td>Vinpearl Nam Hội An</td><td>Tối thiểu 10%/năm (VNĐ) hoặc 8%/năm (USD) trong 10 năm, 15 đêm nghỉ miễn phí/năm</td><td>Khoảng 1,8 – 2 tỷ/năm</td></tr>
</tbody>
</table>
<p>Thu nhập trên tin rao là số do người bán công bố. Vinpearl Đà Nẵng 2 mở bán cuối năm 2015, Vinpearl Nam Hội An khai trương năm 2018, nên với nhiều căn, giai đoạn cam kết 10 năm đã đi được phần lớn thời gian. Cần xác định ngày bắt đầu tính cam kết trong hợp đồng và chính sách áp dụng sau khi hết cam kết trước khi tính tỷ suất.</p>

<h2>So sánh nhanh: chọn khu nào?</h2>
<ul>
<li><a href="/du-an/vinpearl-luxury-da-nang-villa/">Vinpearl Luxury Đà Nẵng</a>: vốn lớn, đất trên 1.000 m², thương hiệu Marriott vận hành – phù hợp giữ tài sản hiếm.</li>
<li><a href="/du-an/vinpearl-resort-spa-da-nang-villa/">Vinpearl Đà Nẵng 2</a>: vốn khoảng 10 – 17 tỷ, vẫn ở trục Trường Sa gần trung tâm – cân bằng giữa giá và vị trí.</li>
<li><a href="/du-an/vinpearl-nam-hoi-an-villa/">Vinpearl Nam Hội An</a>: vốn thấp nhất nhóm, có sân golf và VinWonders trong tổ hợp, nhưng xa trung tâm Đà Nẵng hơn.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với biệt thự Vinpearl, Hiệp khuyên anh chị đừng chỉ so giá/m² đất. Hãy yêu cầu người bán cung cấp sao kê lợi nhuận cho thuê thực nhận ít nhất 2 năm gần nhất, bản hợp đồng vận hành đang hiệu lực và xác nhận không thế chấp. Căn có thu nhập thực ổn định và hợp đồng còn dài thường đáng giá hơn căn rẻ nhưng sắp hết cam kết.</p>
<p>Nếu cân nhắc thêm các khu biệt thự biển khác, xem bài <a href="/biet-thu-ven-bien-da-nang-hoi-an-bang-gia/">bảng giá biệt thự ven biển Đà Nẵng – Hội An</a> hoặc <a href="/so-sanh-villa-ven-bien-da-nang-co-so/">so sánh villa ven biển có sổ</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách biệt thự Vinpearl đang chuyển nhượng thật, kèm hướng dẫn kiểm tra sổ và hợp đồng vận hành từng căn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Biệt thự Vinpearl Đà Nẵng: giá chuyển nhượng 2026',
			'desc'      => 'Biệt thự Vinpearl Đà Nẵng – Hội An 2026: giá chuyển nhượng tham khảo, sổ đỏ, chương trình cho thuê của Vinpearl Luxury, Vinpearl 2, Nam Hội An. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Vinpearl Luxury Đà Nẵng (39 căn) khoảng 40 – 45 tỷ, có căn rao 75 tỷ (tin rao)',
				'Vinpearl Đà Nẵng 2 khoảng 10 – 17 tỷ; Vinpearl Nam Hội An khoảng 9 – 16 tỷ (tham khảo 10/2026)',
				'Cần kiểm tra sổ, hợp đồng vận hành và thời hạn cam kết 10 năm còn lại',
			),
			'faq'       => array(
				array( 'Biệt thự Vinpearl Đà Nẵng giá bao nhiêu?', 'Tham khảo tin rao 10/2026: Vinpearl Luxury Đà Nẵng khoảng 40 – 45 tỷ (4PN đất khoảng 1.000 m²), Vinpearl Đà Nẵng 2 khoảng 10 – 17 tỷ, Vinpearl Nam Hội An khoảng 9 – 16 tỷ.' ),
				array( 'Biệt thự Vinpearl Đà Nẵng có sổ đỏ không?', 'Theo thông tin mở bán, biệt thự Vinpearl Luxury và Vinpearl Đà Nẵng 2 được cấp sổ đỏ sở hữu lâu dài; người mua nên kiểm tra sổ bản gốc của từng căn.' ),
				array( 'Mua lại biệt thự Vinpearl có được hưởng cam kết lợi nhuận không?', 'Người mua chuyển nhượng tiếp nhận hợp đồng vận hành của căn đó; cần kiểm tra thời hạn cam kết còn lại và chính sách sau khi hết cam kết.' ),
			),
		),
		'sources'  => array(
			'https://en.nhandan.vn/vinpearl-luxury-da-nang-inaugurated-post2468.html',
			'https://vnexpress.net/mua-biet-thu-vinpearl-resort-amp-villas-duoc-dam-bao-loi-nhuan-3314577.html',
			'https://vneconomy.vn/tat-ca-trong-mot-o-vinpearl-nam-hoi-an-resort-villas.htm',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-vinpearl-premium-da-nang',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-vinpearl-nam-hoi-an',
		),
	);

	$posts[] = array(
		'slug'     => 'so-sanh-villa-ven-bien-da-nang-co-so',
		'title'    => 'So sánh villa ven biển Đà Nẵng có sổ: Premier Village, Fusion, Hyatt Regency, Furama Villas',
		'excerpt'  => 'So sánh villa ven biển Đà Nẵng 2026: Furama Villas 21 – 40 tỷ, Fusion 32 – 54 tỷ, Premier Village 39 – 47 tỷ, Hyatt Regency khoảng 50 tỷ – vị trí, quy mô, pháp lý cần kiểm tra.',
		'keyword'  => 'villa ven biển Đà Nẵng',
		'project'  => '',
		'week'     => 13,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Villa ven biển Đà Nẵng</strong> đã hoàn thiện, có sổ và đang vận hành là nhóm tài sản được khách tài chính lớn tìm nhiều nhất năm 2026. Bốn cái tên thường được đặt lên bàn cân là Premier Village (Sơn Trà), Fusion Resort &amp; Villas, Hyatt Regency Danang Residences &amp; Villas và Furama Villas (Ngũ Hành Sơn). Bài viết so sánh vị trí, quy mô, giá chuyển nhượng tham khảo tháng 10/2026 và những điểm pháp lý cần kiểm tra trước khi xuống tiền.</p>

<h2>Bảng so sánh 4 khu villa ven biển</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Furama Villas</th><th>Fusion Resort &amp; Villas</th><th>Premier Village</th><th>Hyatt Regency</th></tr></thead>
<tbody>
<tr><td>Khu vực</td><td>Võ Nguyên Giáp – Trường Sa, Ngũ Hành Sơn</td><td>Trường Sa, Ngũ Hành Sơn</td><td>Võ Nguyên Giáp, biển Mỹ Khê, Sơn Trà</td><td>Trường Sa, Ngũ Hành Sơn</td></tr>
<tr><td>Quy mô</td><td>134 biệt thự</td><td>Liên hệ</td><td>Biệt thự trong resort 5 sao</td><td>27 biệt thự, 160 căn hộ Residences</td></tr>
<tr><td>Diện tích đất</td><td>280 – 980 m²</td><td>Khoảng 486 – 700 m²</td><td>Có căn khoảng 300 m²</td><td>Có căn khoảng 600 m²</td></tr>
<tr><td>Giá chuyển nhượng tham khảo</td><td>Khoảng 21 – 40 tỷ</td><td>Khoảng 32 – 54 tỷ</td><td>Khoảng 39 – 47 tỷ trở lên</td><td>3PN đất 600 m² khoảng 50 tỷ</td></tr>
<tr><td>Đơn vị vận hành</td><td>Furama</td><td>Fusion</td><td>Premier Village Danang Resort</td><td>Hyatt</td></tr>
</tbody>
</table>
<p>Giá là khoảng tổng hợp từ tin rao chuyển nhượng công khai năm 2026, tham khảo tại thời điểm 10/2026, không phải giá chốt.</p>

<h2>Furama Villas – mức vốn dễ tiếp cận nhất nhóm</h2>
<p><a href="/du-an/furama-villas-da-nang/">Furama Villas</a> nằm cạnh Furama Resort trên bãi biển Non Nước – Mỹ Khê, gồm 134 biệt thự đất 280 – 980 m². Biệt thự 3 phòng ngủ trên tin rao khoảng 21 – 25 tỷ, 4 phòng ngủ khoảng 30 – 40 tỷ. Một số nguồn giới thiệu biệt thự được cấp sổ đỏ lâu dài, nhưng cũng có tin rao nêu căn theo thời hạn 50 năm – vì vậy phải đọc sổ từng căn, không áp chung cho cả khu.</p>

<h2>Fusion Resort &amp; Villas – đất rộng, phong cách wellness</h2>
<p><a href="/du-an/fusion-resort-villas-da-nang/">Fusion Resort &amp; Villas Đà Nẵng</a> trên trục Trường Sa có biệt thự biển đất khoảng 486 – 700 m², giá chuyển nhượng khoảng 32 – 54 tỷ. Diện tích đất lớn giúp căn có sân vườn, hồ bơi rộng, phù hợp gia đình đông người. Thông tin pháp lý chi tiết từng căn cần đối chiếu sổ – liên hệ để được kiểm tra.</p>

<h2>Premier Village – villa trên biển Mỹ Khê, gần trung tâm</h2>
<p><a href="/du-an/premier-village-da-nang/">Premier Village Đà Nẵng</a> là khu biệt thự trong resort 5 sao trên đường Võ Nguyên Giáp, Sơn Trà. Lợi thế lớn nhất là vị trí: ngay biển Mỹ Khê, gần cầu Rồng và khu phố du lịch. Tin rao năm 2026 có căn khoảng 300 m² giá khoảng 39 tỷ, nhiều căn từ khoảng 47 tỷ trở lên. Các trang giới thiệu nêu biệt thự được cấp sổ hồng sở hữu lâu dài; người mua vẫn nên kiểm tra bản gốc.</p>

<h2>Hyatt Regency – thương hiệu quốc tế, quỹ căn ít</h2>
<p><a href="/du-an/hyatt-regency-danang-residences/">Hyatt Regency Danang Residences &amp; Villas</a> có 27 biệt thự và 160 căn hộ Residences trong khu nghỉ dưỡng Hyatt Regency Danang Resort &amp; Spa. Biệt thự 3 phòng ngủ đất khoảng 600 m² được rao khoảng 50 tỷ. Với số lượng chỉ 27 căn, thanh khoản phụ thuộc rất nhiều vào thời điểm có chủ bán.</p>

<h2>"Có sổ" – cần hiểu đúng</h2>
<h3>Đất ở lâu dài hay đất thương mại dịch vụ có thời hạn</h3>
<p>Biệt thự trong resort có thể nằm trên đất ở (sở hữu lâu dài) hoặc đất thương mại – dịch vụ có thời hạn (thường 50 năm). Hai loại sổ này khác nhau về giá trị thế chấp, khả năng vay và thanh khoản. Xem thêm phân tích trong bài <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">sở hữu lâu dài hay 50 năm</a>.</p>
<h3>Hợp đồng vận hành đi kèm</h3>
<p>Villa trong resort thường gắn với hợp đồng cho thuê lại với đơn vị vận hành. Cần biết tỷ lệ chia doanh thu, phí quản lý, số đêm chủ được tự ở và điều kiện rút khỏi chương trình.</p>

<h2>Checklist so sánh trước khi chọn</h2>
<ul>
<li>Mục đích và thời hạn sử dụng đất ghi trên sổ từng căn.</li>
<li>Tình trạng thế chấp, tranh chấp; người đứng tên sổ có trùng người bán.</li>
<li>Doanh thu cho thuê thực nhận 12 – 24 tháng gần nhất.</li>
<li>Phí quản lý, bảo trì hằng năm và chi phí cải tạo nếu căn đã cũ.</li>
<li>Khoảng cách thực tế ra biển, hướng gió, nguy cơ xói lở bờ biển.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Nếu ưu tiên vị trí gần trung tâm và tiện đi lại, Premier Village đáng cân nhắc. Nếu ngân sách khoảng 20 – 40 tỷ và muốn có ngay một villa biển hoàn thiện, Furama Villas có lựa chọn rộng nhất. Fusion và Hyatt hợp với khách cần diện tích đất lớn hoặc thương hiệu vận hành quốc tế. Dù chọn khu nào, Hiệp luôn đề nghị khách kiểm tra sổ bản gốc tại văn phòng đăng ký đất đai trước khi đặt cọc.</p>
<p>Tham khảo thêm <a href="/biet-thu-vinpearl-da-nang-hoi-an-gia-chuyen-nhuong/">biệt thự Vinpearl Đà Nẵng – Hội An</a> và danh sách <a href="/mua-ban/">bất động sản đang bán</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách villa ven biển đang chuyển nhượng thật, kèm thông tin sổ và hợp đồng vận hành từng căn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'So sánh villa ven biển Đà Nẵng có sổ 2026',
			'desc'      => 'So sánh villa ven biển Đà Nẵng: Furama Villas, Fusion, Premier Village, Hyatt Regency – vị trí, quy mô, giá tham khảo 10/2026, pháp lý. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Furama Villas khoảng 21 – 40 tỷ; Fusion khoảng 32 – 54 tỷ (tin rao 2026)',
				'Premier Village khoảng 39 – 47 tỷ trở lên; Hyatt Regency 3PN khoảng 50 tỷ',
				'"Có sổ" cần kiểm tra loại đất và thời hạn từng căn, không áp chung cả khu',
			),
			'faq'       => array(
				array( 'Villa ven biển Đà Nẵng nào giá mềm nhất?', 'Trong 4 khu so sánh, Furama Villas có mức vốn thấp nhất, khoảng 21 – 25 tỷ cho căn 3 phòng ngủ theo tin rao 2026.' ),
				array( 'Premier Village Đà Nẵng có sổ hồng không?', 'Các trang giới thiệu nêu biệt thự Premier Village được cấp sổ hồng sở hữu lâu dài; người mua nên kiểm tra bản gốc sổ từng căn.' ),
				array( 'Mua villa trong resort cần lưu ý gì?', 'Kiểm tra loại đất và thời hạn trên sổ, tình trạng thế chấp, hợp đồng vận hành – chia doanh thu và chi phí quản lý hằng năm.' ),
			),
		),
		'sources'  => array(
			'https://furamavietnam.com/furama-villas/',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-furama-villas',
			'https://alonhadat.com.vn/du-an-khu-nghi-duong-fusion-resort-villas-da-nang-pj8564',
			'https://homedy.com/ban-nha-biet-thu-lien-ke-premier-village-danang-resort/can-trong-5-da-nang-gia-chi-tu-47-ty-es2357032',
			'https://www.mvpvietnam.com/luxury/hyatt-regency-danang/',
		),
	);

	$posts[] = array(
		'slug'     => 'naman-residences-shilla-monogram-villa-nghi-duong',
		'title'    => 'Naman Residences và Shilla Monogram: villa, căn hộ nghỉ dưỡng ven biển Đà Nẵng',
		'excerpt'  => 'Naman Residences: 34 biệt thự trên Trường Sa, đất 380 – 935 m², giá mở bán từ khoảng 10,9 tỷ. Shilla Monogram: resort 5 sao của Shilla tại Điện Ngọc, khai trương 26/6/2020.',
		'keyword'  => 'Naman Residences',
		'project'  => 'naman-residences',
		'week'     => 13,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Naman Residences</strong> là khu 34 biệt thự nằm cạnh resort Naman Retreat trên đường Trường Sa (Ngũ Hành Sơn), giữa hai sân golf Danang Golf Club và Montgomerie Links. Cách đó không xa về phía Nam, Shilla Monogram Quangnam Danang là khu nghỉ dưỡng 5 sao của thương hiệu Shilla (Hàn Quốc) trên bờ biển Điện Ngọc. Bài viết tổng hợp thông tin hai dự án và mức giá tham khảo tháng 10/2026.</p>

<h2>Naman Residences – tổng quan</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Công ty CP Đầu tư Phát triển Xây dựng Thanh Đô</td></tr>
<tr><td>Vị trí</td><td>Đường Trường Sa, Ngũ Hành Sơn, Đà Nẵng</td></tr>
<tr><td>Quy mô khu biệt thự</td><td>Khoảng 34.000 m², 34 biệt thự chia 4 loại</td></tr>
<tr><td>Diện tích đất</td><td>380 – 935 m²</td></tr>
<tr><td>Quần thể Naman</td><td>Hơn 6,5 ha, gồm resort Naman Retreat và khu biệt thự Naman Residences</td></tr>
<tr><td>Giá mở bán (nguồn phân phối)</td><td>Từ khoảng 10,9 tỷ/căn</td></tr>
</tbody>
</table>
<p>Naman Retreat nổi tiếng với kiến trúc tre và cây xanh của kiến trúc sư Võ Trọng Nghĩa. Theo thông tin phân phối, giai đoạn 2 Naman Residences khởi công tháng 10/2014; Savills từng là đại lý phân phối độc quyền.</p>

<h3>Giá Naman Residences hiện nay</h3>
<p>Giá mở bán theo nguồn phân phối từ khoảng 10,9 tỷ/căn. Tin rao chuyển nhượng biệt thự Naman Residences năm 2025 – 2026 trải rộng khoảng 11,5 – 45 tỷ tùy diện tích đất và vị trí trong khu (tham khảo 10/2026). Vì biên độ rất lớn, anh chị nên yêu cầu thông tin diện tích đất, diện tích sàn và hiện trạng cụ thể của từng căn trước khi so sánh.</p>

<h3>Điểm mạnh và điểm cần kiểm tra</h3>
<ul>
<li>Vị trí trục Trường Sa, nằm giữa hai sân golf, gần biển Non Nước.</li>
<li>Kiến trúc xanh, thương hiệu Naman đã có tên tuổi trên thị trường nghỉ dưỡng.</li>
<li>Cần kiểm tra: loại đất và thời hạn ghi trên sổ, hợp đồng vận hành (nếu tham gia cho thuê), chi phí quản lý.</li>
</ul>

<h2>Shilla Monogram Quangnam Danang – tổng quan</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Đường Lạc Long Quân, Điện Ngọc (Điện Bàn cũ), nay thuộc TP. Đà Nẵng</td></tr>
<tr><td>Đơn vị phát triển</td><td>Tập đoàn Thành Công (TC Group), hợp tác với The Shilla Hotels &amp; Resorts (Samsung)</td></tr>
<tr><td>Khai trương</td><td>26/6/2020</td></tr>
<tr><td>Quy mô</td><td>Khu đất khoảng 53.908 m², tòa khách sạn 9 tầng hình chữ X</td></tr>
<tr><td>Sản phẩm</td><td>Khoảng 300 phòng khách sạn, căn Residence và biệt thự Monogram Villa</td></tr>
</tbody>
</table>
<p>Về số biệt thự, các nguồn ghi chưa thống nhất: có nguồn ghi 34 biệt thự 3 tầng hướng biển, có nguồn ghi 35 căn biệt thự trong tổng thể 309 phòng và villa. Đây là khu nghỉ dưỡng đầu tiên Shilla mở ở nước ngoài, có 4 hồ bơi ngoài trời, spa, gym, nhà hàng và bar.</p>

<h3>Shilla Monogram có bán biệt thự cho cá nhân không?</h3>
<p>Hiện chưa có bảng giá bán công khai cho biệt thự hay căn Residence tại <a href="/du-an/shilla-monogram-quang-nam/">Shilla Monogram</a>. Nếu có căn chuyển nhượng, cần xác minh trực tiếp với chủ đầu tư về hình thức sở hữu, thời hạn đất và hợp đồng vận hành. Giá: liên hệ.</p>

<h2>So sánh nhanh Naman Residences và Shilla Monogram</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Naman Residences</th><th>Shilla Monogram</th></tr></thead>
<tbody>
<tr><td>Khu vực</td><td>Ngũ Hành Sơn, gần trung tâm hơn</td><td>Điện Ngọc, giữa Đà Nẵng và Hội An</td></tr>
<tr><td>Loại sản phẩm</td><td>34 biệt thự</td><td>Phòng khách sạn, Residence, biệt thự</td></tr>
<tr><td>Giá tham khảo</td><td>Mở bán từ khoảng 10,9 tỷ; tin rao khoảng 11,5 – 45 tỷ</td><td>Liên hệ</td></tr>
<tr><td>Vận hành</td><td>Naman</td><td>The Shilla Hotels &amp; Resorts</td></tr>
</tbody>
</table>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Naman Residences phù hợp khách muốn biệt thự đất rộng trên trục Trường Sa với mức vốn khởi điểm thấp hơn nhiều khu resort cùng trục. Shilla Monogram là điểm tham chiếu về chất lượng vận hành ở dải biển Điện Ngọc; nếu xuất hiện căn chuyển nhượng, cần thẩm định pháp lý rất kỹ vì chưa có thông tin bán lẻ công khai. Với khu vực Điện Ngọc, tham khảo thêm bài <a href="/hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh/">vùng giáp ranh sau hợp nhất Đà Nẵng – Quảng Nam</a>.</p>
<p>So sánh thêm tại trang <a href="/du-an/naman-residences/">Naman Residences</a> hoặc bài <a href="/so-sanh-villa-ven-bien-da-nang-co-so/">so sánh villa ven biển Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách biệt thự Naman đang chuyển nhượng và hỗ trợ kiểm tra pháp lý từng căn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Naman Residences và Shilla Monogram: villa biển',
			'desc'      => 'Naman Residences 34 biệt thự trên Trường Sa, giá mở bán từ khoảng 10,9 tỷ; Shilla Monogram resort 5 sao Điện Ngọc. Thông tin, giá tham khảo. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Naman Residences: 34 biệt thự, đất 380 – 935 m², chủ đầu tư Thanh Đô',
				'Giá mở bán từ khoảng 10,9 tỷ; tin rao chuyển nhượng khoảng 11,5 – 45 tỷ (tham khảo)',
				'Shilla Monogram khai trương 26/6/2020 tại Điện Ngọc; chưa có bảng giá bán công khai',
			),
			'faq'       => array(
				array( 'Naman Residences có bao nhiêu biệt thự?', 'Khu Naman Residences có 34 biệt thự chia 4 loại, diện tích đất 380 – 935 m², trên đường Trường Sa, Ngũ Hành Sơn.' ),
				array( 'Giá biệt thự Naman Residences bao nhiêu?', 'Giá mở bán theo nguồn phân phối từ khoảng 10,9 tỷ/căn; tin rao chuyển nhượng 2025 – 2026 khoảng 11,5 – 45 tỷ tùy diện tích, vị trí.' ),
				array( 'Shilla Monogram Đà Nẵng ở đâu?', 'Trên đường Lạc Long Quân, Điện Ngọc (Điện Bàn cũ), nay thuộc TP. Đà Nẵng, giữa trung tâm Đà Nẵng và phố cổ Hội An.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/du-an-khu-nghi-duong-sinh-thai-ngu-hanh-son-ddn/naman-residences-pj2179',
			'https://meeyproject.com/project/naman-residences-1688357557583',
			'https://batdongsan.com.vn/tags/ban/ban-biet-thu-du-an-naman-residences',
			'https://vn.savills.com.vn/insight-and-opinion/savills-news/138323-0/savills-tr%E1%BB%9F-thanh-%C4%91%E1%BA%A1i-l%C3%BD-phan-ph%E1%BB%91i-%C4%91%E1%BB%99c-quy%E1%BB%81n-naman-residences-t%E1%BA%A1i-%C4%91a-n%E1%BA%B5ng',
			'https://thanhcong.vn/tin-tuc/shilla-monogram-quangnam-danang-danh-dau-mot-nam-van-hanh.html',
			'https://www.ivivu.com/blog/2023/10/shilla-monogram-quang-nam-da-nang-khu-nghi-duong-bien-sang-trong-mang-phong-cach-han-quoc/',
			'https://haphong.com/portfolio/shilla-monogram-quang-nam/',
		),
	);

	$posts[] = array(
		'slug'     => 'shantira-hoi-an-biet-thu-can-ho-gia-tham-khao',
		'title'    => 'Shantira Beach Resort & Spa Hội An: biệt thự, căn hộ và giá tham khảo',
		'excerpt'  => 'Shantira Hội An (Wyndham Shantira) sát biển An Bàng: khoảng 70 biệt thự LegaSea, gần 500 căn hộ du lịch; biệt thự tin rao khoảng 21,5 – 33 tỷ, studio khoảng 1,65 tỷ.',
		'keyword'  => 'Shantira Hội An',
		'project'  => 'shantira-beach-resort-hoi-an',
		'week'     => 13,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Shantira Hội An</strong> (Shantira Beach Resort &amp; Spa) là khu nghỉ dưỡng 8,6 ha trên đường Lạc Long Quân, Điện Dương (Điện Bàn cũ, nay thuộc TP. Đà Nẵng), liền kề bãi biển An Bàng và cách phố cổ Hội An khoảng 5 phút. Từ ngày 11/11/2022, khu nghỉ dưỡng vận hành dưới tên Wyndham Shantira Resort Hội An. Bài viết tổng hợp sản phẩm, giá bán gốc, giá chuyển nhượng và giá thuê tham khảo tháng 10/2026.</p>

<h2>Tổng quan Shantira Hội An</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Hoàng Gia Hội An (Hoi An Royal Group, hệ sinh thái Royal Capital Group)</td></tr>
<tr><td>Đơn vị vận hành</td><td>Wyndham Hotels &amp; Resorts (từ 11/2022)</td></tr>
<tr><td>Quy mô</td><td>8,6 ha, hơn 1,5 ha mặt tiền biển; vốn khoảng 1.900 – 2.500 tỷ đồng (các nguồn ghi khác nhau)</td></tr>
<tr><td>Biệt thự</td><td>Khoảng 69 – 70 biệt thự Shantira LegaSea, 2 tầng, 2 – 3 phòng ngủ, hồ bơi riêng</td></tr>
<tr><td>Căn hộ du lịch</td><td>Khoảng 430 – 497 căn trong 2 tòa hình chữ V, 100% căn có ban công hướng biển</td></tr>
<tr><td>Mốc chính</td><td>Khởi công 4/2019, hoàn thành 3/2021 (theo nguồn tổng hợp), mở cửa 11/11/2022</td></tr>
</tbody>
</table>

<h2>Biệt thự Shantira LegaSea</h2>
<p>Biệt thự cao 2 tầng, thiết kế mở, mỗi căn có hồ bơi riêng. Có nguồn ghi riêng loại 3 phòng ngủ gồm 38 căn xếp 5 hàng, 100% view biển.</p>
<table>
<thead><tr><th>Loại</th><th>Diện tích đất</th><th>Giá bán gốc (nguồn phân phối)</th><th>Tin rao chuyển nhượng</th></tr></thead>
<tbody>
<tr><td>Biệt thự 2PN</td><td>348 – 606 m²</td><td>Khoảng 20 – 25 tỷ (chưa VAT)</td><td rowspan="2">Căn khoảng 292 m² khoảng 21,5 tỷ; căn mặt biển 319 m² khoảng 33 tỷ</td></tr>
<tr><td>Biệt thự 3PN</td><td>322 – 807 m²</td><td>Khoảng 22 – 42 tỷ (gồm VAT)</td></tr>
</tbody>
</table>

<h2>Căn hộ du lịch Shantira</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán gốc</th><th>Giá chuyển nhượng / giá thuê</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>36 – 45 m²</td><td>Từ khoảng 1,3 tỷ</td><td>Chuyển nhượng khoảng 1,65 tỷ; thuê khoảng 1,45 – 2,2 triệu/đêm</td></tr>
<tr><td>2 phòng ngủ</td><td>52 – 60 m²</td><td>Từ khoảng 1,8 tỷ</td><td>Thuê khoảng 5 – 6,5 triệu/đêm</td></tr>
</tbody>
</table>
<p>Giá thuê là mức tham khảo từ tin cho thuê, chênh giữa ngày thường và ngày lễ. Căn hộ du lịch có thời hạn sở hữu 50 năm, gia hạn theo quy định (theo nguồn phân phối).</p>

<h2>Chương trình hợp tác cho thuê</h2>
<ul>
<li>Căn hộ: chủ căn tham gia nhận 45% doanh thu thuần, kèm 20 đêm nghỉ miễn phí.</li>
<li>Biệt thự LegaSea: có nguồn ghi chủ nhận 40% doanh thu thuần, cam kết thu nhập không thấp hơn 8%/năm giá trị căn (trước VAT).</li>
</ul>
<p>Người mua chuyển nhượng cần kiểm tra thời hạn và điều khoản hợp đồng còn lại của từng căn – chính sách khi mở bán không tự động áp dụng cho mọi giao dịch sau này.</p>

<h2>Pháp lý cần kiểm tra</h2>
<h3>Căn hộ du lịch 50 năm</h3>
<p>Căn hộ du lịch nằm trên đất thương mại – dịch vụ, thời hạn theo dự án. Khả năng vay ngân hàng và thanh khoản thường kém hơn căn hộ ở lâu dài. Xem thêm bài <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">căn hộ sở hữu lâu dài hay căn hộ dịch vụ 50 năm</a>.</p>
<h3>Biệt thự LegaSea</h3>
<p>Cần kiểm tra mục đích, thời hạn sử dụng đất ghi trên sổ của từng căn và tình trạng thế chấp.</p>

<h2>Shantira phù hợp với ai?</h2>
<table>
<thead><tr><th>Nhu cầu</th><th>Sản phẩm gợi ý</th><th>Điều cần cân nhắc</th></tr></thead>
<tbody>
<tr><td>Vốn khoảng 1,5 – 2 tỷ, muốn có tài sản nghỉ dưỡng sát biển Hội An</td><td>Căn hộ studio, 2PN</td><td>Thời hạn 50 năm, doanh thu theo mùa du lịch</td></tr>
<tr><td>Gia đình muốn có villa riêng để nghỉ, kết hợp cho thuê</td><td>Biệt thự LegaSea 2 – 3PN</td><td>Số đêm tự sử dụng theo hợp đồng, phí quản lý</td></tr>
<tr><td>Giữ tài sản dài hạn gần phố cổ</td><td>Biệt thự hàng gần biển</td><td>Thanh khoản chậm, cần chọn đúng thời điểm bán</td></tr>
</tbody>
</table>
<p>So với biệt thự sinh thái ven sông như Casamia Balanca, Shantira có lợi thế mặt biển và đã vận hành, nhưng mức vốn biệt thự cao hơn. So với biệt thự Vinpearl Nam Hội An, Shantira gần phố cổ hơn nhiều.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Shantira có lợi thế khó sao chép: sát bãi biển An Bàng, gần phố cổ và có thương hiệu vận hành quốc tế. Căn hộ studio phù hợp khách muốn vốn nhỏ, ưu tiên dòng tiền theo mùa du lịch; biệt thự LegaSea phù hợp khách giữ tài sản nghỉ dưỡng gần Hội An. Trước khi mua, hãy so doanh thu thực nhận với chi phí, và tính kịch bản mùa thấp điểm.</p>
<p>Xem thêm trang <a href="/du-an/shantira-beach-resort-hoi-an/">Shantira Beach Resort &amp; Spa Hội An</a> và bài <a href="/bat-dong-san-hoi-an-2026-sau-hop-nhat/">bất động sản Hội An 2026</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Shantira đang chuyển nhượng và kiểm tra hợp đồng hợp tác cho thuê.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Shantira Hội An: biệt thự, căn hộ, giá tham khảo',
			'desc'      => 'Shantira Beach Resort & Spa Hội An (Wyndham Shantira): biệt thự LegaSea, căn hộ du lịch, giá gốc, giá chuyển nhượng, cho thuê 10/2026. Gọi Hoàng Hiệp.',
			'points'    => array(
				'8,6 ha sát biển An Bàng; Wyndham vận hành từ 11/11/2022',
				'Biệt thự tin rao khoảng 21,5 – 33 tỷ; studio chuyển nhượng khoảng 1,65 tỷ (tham khảo)',
				'Căn hộ du lịch 50 năm; chủ căn nhận 45% doanh thu thuần theo chính sách bán hàng',
			),
			'faq'       => array(
				array( 'Shantira Hội An nằm ở đâu?', 'Trên đường Lạc Long Quân, Điện Dương (Điện Bàn cũ), nay thuộc TP. Đà Nẵng, sát bãi biển An Bàng, cách phố cổ Hội An khoảng 5 phút.' ),
				array( 'Giá biệt thự Shantira bao nhiêu?', 'Giá gốc theo nguồn phân phối: 2PN khoảng 20 – 25 tỷ (chưa VAT), 3PN khoảng 22 – 42 tỷ; tin rao chuyển nhượng khoảng 21,5 – 33 tỷ (tham khảo 10/2026).' ),
				array( 'Căn hộ Shantira sở hữu bao lâu?', 'Căn hộ du lịch có thời hạn 50 năm, gia hạn theo quy định (theo nguồn phân phối).' ),
			),
		),
		'sources'  => array(
			'https://thanhnien.vn/wyndham-hotel-resort-chinh-thuc-van-hanh-shantira-beach-resort-spa-hoi-an-1851060273.htm',
			'https://thanhnien.vn/cac-gia-tri-dua-biet-thu-bien-shantira-legasea-thanh-tam-diem-tren-cung-duong-di-san-1851060128.htm',
			'https://cafeland.vn/du-an/khu-du-lich-nghi-duong-shantira-beach-resort-and-spa-hoi-an-2502.html',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-shantira-beach-resort-spa-hoi-an',
		),
	);

	$posts[] = array(
		'slug'     => 'capital-square-da-nang-cac-toa-loai-can-gia',
		'title'    => 'Capital Square Đà Nẵng: các tòa, loại căn và giá chuyển nhượng 2026',
		'excerpt'  => 'Capital Square Đà Nẵng: 14 tòa, 3.391 căn ven sông Hàn; 1PN khoảng 3,3 – 4,5 tỷ, 2PN 4,7 – 7,8 tỷ, 3PN 9,5 – 12,6 tỷ (khoảng 74 – 90 triệu/m², tham khảo 10/2026).',
		'keyword'  => 'Capital Square Đà Nẵng',
		'project'  => 'capital-square-da-nang',
		'week'     => 13,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Capital Square Đà Nẵng</strong> là tổ hợp căn hộ ven sông Hàn thuộc hệ sinh thái BRG, nằm giữa các trục Trần Hưng Đạo – Ngô Quyền – Nguyễn Công Trứ (phường An Hải, Sơn Trà cũ). Trên khu đất 61.368 m², dự án có 14 tòa cao 24 – 29 tầng với 3.391 căn hộ sở hữu lâu dài. Bài viết giúp anh chị phân biệt từng tòa, loại căn và mặt bằng giá chuyển nhượng tham khảo tháng 10/2026.</p>

<h2>Hai phân khu, hai chủ đầu tư</h2>
<table>
<thead><tr><th>Phân khu</th><th>Chủ đầu tư</th><th>Diện tích đất</th><th>Quy mô</th></tr></thead>
<tbody>
<tr><td>Capital Square 2</td><td>Công ty TNHH Mega Assets</td><td>Khoảng 31.960 m²</td><td>7 tòa 26 – 28 tầng, 1.681 căn</td></tr>
<tr><td>Capital Square 3</td><td>Công ty CP Bất động sản SIH</td><td>Khoảng 29.427 m²</td><td>7 tòa 24 – 29 tầng, 1.710 căn</td></tr>
</tbody>
</table>
<p>Hai chủ đầu tư đều thuộc hệ sinh thái BRG Group. Delta Group thi công kết cấu, xây thô các tòa 2.4, 2.6 và MAT 5, MAT 6.</p>

<h2>Danh sách các tòa Capital Square</h2>
<table>
<thead><tr><th>Tòa / khối</th><th>Phân khu</th><th>Số tầng</th><th>Số căn</th><th>Đủ điều kiện bán</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/capital-square-toa-2-4/">Tòa 2.4 – The King</a></td><td>CS2</td><td>28</td><td>265</td><td>6/2025</td></tr>
<tr><td><a href="/du-an/capital-square-toa-2-6/">Tòa 2.6 – The Queen</a></td><td>CS2</td><td>28</td><td>265</td><td>6/2025</td></tr>
<tr><td>Tòa 2.1</td><td>CS2</td><td>26</td><td>207</td><td>2/2026</td></tr>
<tr><td>Tòa 2.5, 2.7</td><td>CS2</td><td>28</td><td>265 căn/tòa</td><td>2/2026</td></tr>
<tr><td>Tòa 2.2, 2.3</td><td>CS2</td><td>26</td><td>207 căn/tòa</td><td>Văn bản 7779/SXD-QLN</td></tr>
<tr><td>Khối LAT 4-5</td><td>CS3</td><td>26</td><td>374</td><td>Đang cập nhật</td></tr>
<tr><td>Khối MAT 5-6</td><td>CS3</td><td>24</td><td>586</td><td>8/2025</td></tr>
<tr><td>Tòa MAT 7</td><td>CS3</td><td>29</td><td>250</td><td>5/2026</td></tr>
<tr><td>Tòa MAT 8-9</td><td>CS3</td><td>29</td><td>500</td><td>2/2026</td></tr>
</tbody>
</table>
<h3>Tên thương mại các tòa</h3>
<p>Các trang phân phối dùng nhiều tên thương mại (Kings Place, Queens Place, Times Place…) nhưng gán không thống nhất. Chỉ cặp The King (tòa 2.4) và The Queen (tòa 2.6) có nguồn ghi rõ mã tòa. Khi giao dịch, anh chị nên dùng mã tòa chính thức trong văn bản của Sở Xây dựng để tránh nhầm lẫn.</p>

<h2>Loại căn và giá tham khảo</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá chào bán / chuyển nhượng tham khảo</th><th>Giá thuê ước tính</th></tr></thead>
<tbody>
<tr><td>1 phòng ngủ</td><td>34,14 – 47,73 m²</td><td>Khoảng 3,3 – 4,5 tỷ</td><td>Khoảng 18 – 25 triệu/tháng (full nội thất)</td></tr>
<tr><td>2 phòng ngủ</td><td>67,03 – 93,08 m²</td><td>Khoảng 4,7 – 7,8 tỷ</td><td>Khoảng 25 – 35 triệu/tháng</td></tr>
<tr><td>3 phòng ngủ</td><td>91,49 – 128,34 m²</td><td>Khoảng 9,5 – 12,6 tỷ</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Mặt bằng quy đổi khoảng 74 – 90 triệu/m², tổng hợp từ bảng chào bán và tin rao chuyển nhượng hợp đồng mua bán năm 2026 (tham khảo 10/2026). Chưa có bảng giá công khai riêng từng tòa; giá chênh theo tầng, hướng nhìn sông Hàn và đợt mở bán. Giá thuê là ước tính vì dự án chưa bàn giao.</p>

<h2>Pháp lý và tiến độ</h2>
<p>Căn hộ thuộc đất ở đô thị, sổ hồng sở hữu lâu dài. Sở Xây dựng Đà Nẵng đã có văn bản xác nhận đủ điều kiện bán cho cả 7 tòa của Capital Square 2 và các khối MAT 5-6, MAT 7, MAT 8-9 của Capital Square 3. Người nước ngoài được mua tối đa 502 căn tại Capital Square 2 và 512 căn tại Capital Square 3.</p>
<p>Báo chí năm 2026 có đặt vấn đề về việc xử lý quyền sử dụng đất đang thế chấp tại Capital Square 2. Khi ký hợp đồng, nên yêu cầu văn bản bảo lãnh ngân hàng và phương án giải chấp cho căn hộ. Các trang phân phối nêu mục tiêu bàn giao từ quý I/2027, bắt đầu với The King và The Queen; tiến độ thực tế theo hợp đồng từng tòa.</p>

<h2>Mua chuyển nhượng hợp đồng: lưu ý</h2>
<ul>
<li>Kiểm tra hợp đồng mua bán gốc, lịch thanh toán đã đóng và phần còn lại.</li>
<li>Thủ tục chuyển nhượng hợp đồng phải được chủ đầu tư xác nhận; tính thêm phí, thuế theo quy định.</li>
<li>Khoản chênh trả cho người bán nên ghi rõ trong văn bản, thanh toán qua ngân hàng.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Nếu cần nhận nhà sớm, ưu tiên The King và The Queen vì được công bố bàn giao trước. Nếu muốn nhiều lựa chọn tầng, hướng, có thể xem các tòa mở bán sau như 2.2, 2.3. Khách đầu tư cho thuê nên lưu ý nguồn cung căn hộ ven sông Hàn giai đoạn 2027 – 2028 khá lớn, tính dòng tiền thận trọng. So sánh thêm trong bài <a href="/so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula/">so sánh căn hộ ven sông Hàn</a> và <a href="/bat-dong-san-son-tra-2026/">bất động sản Sơn Trà 2026</a>.</p>
<p>Xem tổng quan tại trang <a href="/du-an/capital-square-da-nang/">Capital Square Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận mặt bằng, bảng giá và quỹ căn chuyển nhượng theo từng tòa Capital Square.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Capital Square Đà Nẵng: các tòa, loại căn, giá 2026',
			'desc'      => 'Capital Square Đà Nẵng: 14 tòa, 3.391 căn ven sông Hàn, mã tòa The King, The Queen, MAT, LAT; giá 1PN – 3PN tham khảo 10/2026. Gọi Hoàng Hiệp.',
			'points'    => array(
				'14 tòa 24 – 29 tầng, 3.391 căn; Capital Square 2 (1.681 căn) và Capital Square 3 (1.710 căn)',
				'1PN khoảng 3,3 – 4,5 tỷ, 2PN 4,7 – 7,8 tỷ, 3PN 9,5 – 12,6 tỷ (khoảng 74 – 90 triệu/m², tham khảo)',
				'The King, The Queen dự kiến bàn giao từ quý I/2027; sổ hồng sở hữu lâu dài',
			),
			'faq'       => array(
				array( 'Capital Square Đà Nẵng có bao nhiêu tòa?', 'Tổ hợp có 14 tòa, 3.391 căn, chia thành Capital Square 2 (tòa 2.1 – 2.7) và Capital Square 3 (khối LAT 4-5, MAT 5-6, MAT 7, MAT 8-9).' ),
				array( 'Giá căn hộ Capital Square bao nhiêu?', 'Tham khảo 10/2026: 1PN khoảng 3,3 – 4,5 tỷ, 2PN khoảng 4,7 – 7,8 tỷ, 3PN khoảng 9,5 – 12,6 tỷ, tương đương khoảng 74 – 90 triệu/m².' ),
				array( 'Capital Square khi nào bàn giao?', 'Các trang phân phối nêu mục tiêu bàn giao từ quý I/2027, bắt đầu với tòa The King (2.4) và The Queen (2.6); tiến độ thực tế theo hợp đồng từng tòa.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/1-237-can-ho-tai-14-toa-nha-cao-tang-ben-song-han-du-dieu-kien-duoc-ban-20260214144050977.htm',
			'https://baodautu.vn/batdongsan/da-nang-khu-do-thi-capital-square-2-du-dieu-kien-mo-ban-530-can-ho-d314431.html',
			'https://tuoitre.vn/da-nang-du-an-capital-square-2-duoc-mo-ban-hang-ngan-can-ho-so-do-the-chap-xu-ly-sao-20260514151105868.htm',
			'https://vietnammoi.vn/delta-trung-thau-to-hop-can-ho-capital-square-2-3-o-da-nang-20263187387819.htm',
			'https://capitalsquarebrg.com.vn/tien-do/',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-capital-square',
		),
	);

	/* ---------------------------------------------------------------- Tuần 14 */
	$posts[] = array(
		'slug'     => 'dat-nen-hoa-xuan-2026-gia-theo-khu',
		'title'    => 'Đất nền Hòa Xuân 2026: giá theo khu Euro Village 2, Cồn Dầu, KĐT sinh thái Hòa Xuân',
		'excerpt'  => 'Đất nền Hòa Xuân 2026: Cồn Dầu khoảng 42 – 55 triệu/m², Nam Hòa Xuân lô từ khoảng 3,5 – 5 tỷ, Euro Village 2 lô biệt thự 300 m² tin rao khoảng 85 – 113 triệu/m² (tham khảo).',
		'keyword'  => 'đất nền Hòa Xuân',
		'project'  => 'kdt-sinh-thai-hoa-xuan',
		'week'     => 14,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Đất nền Hòa Xuân</strong> năm 2026 vẫn là phân khúc đất có sổ được giao dịch nhiều nhất phía Nam Đà Nẵng. Theo tin rao tháng 9/2026, giá nhà đất trung bình tại Hòa Xuân khoảng 61,5 triệu/m²; nhưng chênh lệch giữa các khu rất lớn – từ lô 100 m² vài tỷ ở Nam Hòa Xuân đến lô biệt thự ven sông hàng chục tỷ ở Euro Village 2. Bài viết tổng hợp giá tham khảo theo từng khu, cập nhật tháng 10/2026.</p>

<h2>Hòa Xuân nằm ở đâu sau sắp xếp hành chính?</h2>
<p>Từ ngày 1/7/2025, phường Hòa Xuân mới được hình thành trên cơ sở phường Hòa Xuân, xã Hòa Châu và xã Hòa Phước cũ. Khu đất nền chính vẫn là dải ven sông Cẩm Lệ – Cổ Cò thuộc Khu đô thị sinh thái Hòa Xuân (khoảng 450 ha) của Sun Group, kết nối trung tâm qua cầu Hòa Xuân, cầu Nguyễn Tri Phương và đường 29/3.</p>

<h2>Bảng giá đất nền Hòa Xuân theo khu</h2>
<table>
<thead><tr><th>Khu</th><th>Sản phẩm</th><th>Diện tích phổ biến</th><th>Giá tham khảo 10/2026</th></tr></thead>
<tbody>
<tr><td>Đất nền Cồn Dầu</td><td>Đất nền phân lô, khoảng 600 lô</td><td>Từ 100 m²</td><td>Khoảng 42 – 55 triệu/m² (lô 100 m² khoảng 4,2 – 5,5 tỷ); lô mặt đường lớn cao hơn, có tin rao khoảng 72 triệu/m²</td></tr>
<tr><td>Euro Village 2</td><td>Đất biệt thự, nhà phố ven sông</td><td>Biệt thự khoảng 250 – 416 m²</td><td>Lô biệt thự 300 m² tin rao khoảng 20 – 36 tỷ (khoảng 85 – 113 triệu/m², gồm cả lô đã xây)</td></tr>
<tr><td>Nam Hòa Xuân</td><td>Đất nền khu dân cư</td><td>Khoảng 100 m²</td><td>Lô thấp nhất khoảng 3,5 – 4 tỷ; phổ biến từ khoảng 5 tỷ</td></tr>
<tr><td>Hòa Xuân – đất thổ cư ven sông</td><td>Đất ở</td><td>100 – 300 m²</td><td>Khoảng 50 – 115 triệu/m²</td></tr>
</tbody>
</table>
<p>Số liệu tổng hợp từ tin rao công khai và trang phân phối, chỉ để tham khảo mặt bằng. Giá thực tế phụ thuộc hướng, bề rộng đường, lô góc, view sông và hiện trạng.</p>

<h2>Euro Village 2 – biệt thự ven sông</h2>
<p><a href="/du-an/euro-village-2/">Euro Village 2</a> (Làng Châu Âu 2) thuộc giai đoạn 1B Khu đô thị sinh thái Hòa Xuân, rộng 23,7 ha với 245 nền nhà phố liền kề và 175 nền biệt thự, đã có sổ đỏ, giao dịch thứ cấp. Dữ liệu cũ từ các trang phân phối ghi đất biệt thự khu B2.8, B2.11 khoảng 38 – 45 triệu/m²; trong khi tin rao năm 2026 cho lô 300 m² view sông, kênh lên khoảng 85 – 113 triệu/m². Chênh lệch giữa các nguồn rất lớn, nên cần thẩm định từng lô cụ thể, phân biệt rõ lô đất trống và lô đã xây biệt thự.</p>

<h2>Đất nền Cồn Dầu – lô 100 m² phổ thông</h2>
<p><a href="/du-an/dat-nen-con-dau-hoa-xuan/">Đất nền Cồn Dầu</a> có khoảng 600 lô, diện tích từ 100 m², sổ đỏ từng lô, hạ tầng đồng bộ. Đây là lựa chọn phù hợp khách cần lô xây nhà ở hoặc nhà cho thuê với vốn khoảng 4 – 6 tỷ. Lô mặt các đường lớn như Cồn Dầu 16, Cồn Dầu 24 có giá cao hơn lô đường nội khu.</p>

<h2>Hạ tầng tác động đến giá đất Hòa Xuân</h2>
<ul>
<li>Cụm nút giao cầu Hòa Xuân, vốn hơn 1.378 tỷ đồng, thực hiện 2026 – 2029 – xem bài <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao cầu Hòa Xuân</a>.</li>
<li>Sun NeO City với các tòa Cora Tower, Spana Tower, S-Light Tower kéo thêm cư dân về khu vực.</li>
<li>Trục Võ Chí Công mở rộng 6 làn kết nối biển và Hội An.</li>
</ul>

<h2>So sánh với đất nền lân cận</h2>
<table>
<thead><tr><th>Khu</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Đất nền Đầm Sen – Sun Riverpolis (Hòa Quý)</td><td>Khoảng 40 – 48 triệu/m²; từ khoảng 4,8 tỷ/lô</td></tr>
<tr><td>Đất nền Võ Chí Công (Sun Group)</td><td>Khoảng 45 – 90 triệu/m²</td></tr>
<tr><td>Đất nền Cồn Dầu (Hòa Xuân)</td><td>Khoảng 42 – 55 triệu/m²</td></tr>
</tbody>
</table>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Khách mua để ở nên ưu tiên lô có sổ, đường rộng, gần khu dân cư hiện hữu ở Cồn Dầu hoặc Nam Hòa Xuân. Khách giữ tài sản dài hạn, tài chính mạnh có thể xem đất biệt thự Euro Village 2 – nhưng với biên độ giá rộng như hiện nay, đừng dựa vào giá chào trên mạng; hãy so ít nhất 3 lô cùng khu và kiểm tra quy hoạch từng lô. Hướng dẫn kiểm tra có trong bài <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>
<p>Xem tổng quan tại trang <a href="/du-an/kdt-sinh-thai-hoa-xuan/">Khu đô thị sinh thái Hòa Xuân</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách lô đất Hòa Xuân đang bán thật theo ngân sách.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đất nền Hòa Xuân 2026: giá theo từng khu',
			'desc'      => 'Đất nền Hòa Xuân 2026: giá tham khảo Cồn Dầu, Euro Village 2, Nam Hòa Xuân, đất ven sông; hạ tầng cầu Hòa Xuân. Gọi Hoàng Hiệp nhận lô đang bán.',
			'points'    => array(
				'Cồn Dầu khoảng 42 – 55 triệu/m², lô 100 m² khoảng 4,2 – 5,5 tỷ (tham khảo)',
				'Euro Village 2: lô biệt thự 300 m² tin rao khoảng 85 – 113 triệu/m²; nguồn cũ ghi 38 – 45 triệu/m²',
				'Nam Hòa Xuân lô từ khoảng 3,5 – 5 tỷ; giá trung bình Hòa Xuân khoảng 61,5 triệu/m² (9/2026)',
			),
			'faq'       => array(
				array( 'Giá đất nền Hòa Xuân 2026 bao nhiêu?', 'Tham khảo 10/2026: Cồn Dầu khoảng 42 – 55 triệu/m², Nam Hòa Xuân lô từ khoảng 3,5 – 5 tỷ, Euro Village 2 lô biệt thự 300 m² tin rao khoảng 85 – 113 triệu/m².' ),
				array( 'Đất nền Cồn Dầu có sổ đỏ không?', 'Theo thông tin dự án, đất nền Cồn Dầu là đất ở lâu dài, sổ đỏ từng lô; người mua nên kiểm tra sổ bản gốc.' ),
				array( 'Vì sao giá Euro Village 2 chênh lệch lớn?', 'Do khác biệt giữa lô đất trống và lô đã xây biệt thự, vị trí view sông hay kênh, diện tích và hướng. Cần thẩm định từng lô thay vì dựa vào giá chào chung.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-dat-phuong-hoa-xuan',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-euro-village-2',
			'https://sungroupvn.com.vn/dat-nen-con-dau-hoa-xuan/',
			'https://datnenhoaxuan.com/nam-hoa-xuan',
			'https://thuvienphapluat.vn/phap-luat/phuong-hoa-xuan-quan-cam-le-doi-thanh-gi-phuong-hoa-xuan-quan-cam-le-cu-da-nang-sau-sap-nhap-thanh--642576-229453.html',
		),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-cam-le-2026',
		'title'    => 'Bất động sản Cẩm Lệ 2026: căn hộ Sun NeO City, đất nền Hòa Xuân và mặt bằng giá',
		'excerpt'  => 'Bất động sản Cẩm Lệ 2026: nhà đất khoảng 46 – 100 triệu/m², căn hộ Sun NeO City (Cora, Spana, S-Light) từ khoảng 1,7 – 2,4 tỷ, đất nền Cồn Dầu, Euro Village 2.',
		'keyword'  => 'bất động sản Cẩm Lệ',
		'project'  => 'sun-neo-city',
		'week'     => 14,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Cẩm Lệ</strong> năm 2026 được chú ý nhờ khu Hòa Xuân phát triển mạnh với Sun NeO City và Khu đô thị sinh thái Hòa Xuân, cùng hạ tầng cầu Hòa Xuân đang được đầu tư. Mặt bằng nhà đất Cẩm Lệ theo tin rao khoảng 46 – 100 triệu/m², căn hộ mới ở Hòa Xuân có giá chào từ khoảng 1,7 – 2,4 tỷ/căn. Bài viết cập nhật tháng 10/2026.</p>

<h2>Cẩm Lệ sau sắp xếp hành chính</h2>
<p>Từ ngày 1/7/2025, cấp quận không còn; địa bàn Cẩm Lệ cũ được tổ chức thành 3 phường:</p>
<table>
<thead><tr><th>Phường mới</th><th>Hình thành từ</th></tr></thead>
<tbody>
<tr><td>Phường Cẩm Lệ</td><td>Hòa Thọ Tây, Hòa Thọ Đông, Khuê Trung</td></tr>
<tr><td>Phường Hòa Xuân</td><td>Hòa Xuân, xã Hòa Châu, xã Hòa Phước</td></tr>
<tr><td>Phường An Khê</td><td>Hòa An, Hòa Phát, An Khê</td></tr>
</tbody>
</table>
<p>Tên "Cẩm Lệ" trong bài dùng theo thói quen của thị trường, chỉ khu vực quận Cẩm Lệ cũ.</p>

<h2>Căn hộ Cẩm Lệ: cụm Sun NeO City</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô</th><th>Giá tham khảo</th><th>Bàn giao dự kiến</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/cora-tower/">Cora Tower</a></td><td>616 căn/tòa, 28 căn/tầng</td><td>Khoảng 45 – 55 triệu/m², từ khoảng 1,7 tỷ</td><td>30/7/2027</td></tr>
<tr><td><a href="/du-an/spana-tower/">Spana Tower</a></td><td>2 tòa 22 tầng, khoảng 1.281 căn</td><td>Từ khoảng 1,9 – 2,4 tỷ; HĐMB chuyển nhượng khoảng 1,9 – 4,14 tỷ</td><td>30/6/2027</td></tr>
<tr><td><a href="/du-an/s-light-tower/">S-Light Tower</a></td><td>2 tháp 22 tầng, gần 800 căn, 33,3 – 95,1 m²</td><td>Từ khoảng 2 – 2,4 tỷ (nguồn phân phối)</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Giá tham khảo 10/2026 từ trang phân phối và tin rao; giá chính thức theo bảng giá chủ đầu tư từng đợt. Cả ba tòa đều sở hữu lâu dài. So sánh chi tiết trong bài <a href="/so-sanh-fours-tower-spana-tower-s-light-tower/">so sánh FourS Tower, Spana Tower, S-Light Tower</a>.</p>

<h2>Đất nền và nhà phố Cẩm Lệ</h2>
<table>
<thead><tr><th>Khu</th><th>Giá tham khảo 10/2026</th></tr></thead>
<tbody>
<tr><td>Đất nền Cồn Dầu (Hòa Xuân)</td><td>Khoảng 42 – 55 triệu/m²; lô 100 m² khoảng 4,2 – 5,5 tỷ</td></tr>
<tr><td>Euro Village 2 (đất biệt thự)</td><td>Tin rao lô 300 m² khoảng 85 – 113 triệu/m²</td></tr>
<tr><td>Nhà đất Hòa Xuân (trung bình)</td><td>Khoảng 61,5 triệu/m² (9/2026)</td></tr>
<tr><td>Nhà đất Cẩm Lệ nói chung</td><td>Khoảng 46 – 100 triệu/m² tùy vị trí, mặt tiền</td></tr>
</tbody>
</table>
<p>Chi tiết từng khu đất Hòa Xuân có trong bài <a href="/dat-nen-hoa-xuan-2026-gia-theo-khu/">đất nền Hòa Xuân 2026</a>.</p>

<h2>Động lực của bất động sản Cẩm Lệ</h2>
<h3>Hạ tầng giao thông</h3>
<p>Cụm nút giao thông cầu Hòa Xuân, vốn hơn 1.378 tỷ đồng, bổ sung một cầu mới dài 303,5 m phía hạ lưu, thực hiện giai đoạn 2026 – 2029. Khu vực còn được kết nối bởi các cầu Cẩm Lệ, Nguyễn Tri Phương, Trung Lương và trục 29/3, Nguyễn Phước Lan.</p>
<h3>Đô thị mới quy mô lớn</h3>
<p>Sun NeO City cùng Sun Riverpolis tạo hệ sinh thái hơn 1.000 ha phía Nam thành phố. Khi các tòa căn hộ bàn giao giai đoạn 2027, lượng cư dân mới sẽ tăng nhu cầu dịch vụ, thương mại quanh khu Hòa Xuân.</p>

<h2>Rủi ro cần lưu ý</h2>
<ul>
<li>Nguồn cung căn hộ Sun NeO City lớn (Spana khoảng 1.281 căn, S-Light gần 800 căn, cùng Cora Tower), có thể tạo cạnh tranh giá thuê khi bàn giao đồng loạt.</li>
<li>Hạ tầng cầu Hòa Xuân kéo dài đến 2029 – nên tính thời gian nắm giữ đủ dài.</li>
<li>Một số khu trũng ven sông cần xem xét yếu tố ngập khi mưa lớn.</li>
</ul>

<h2>Gợi ý theo ngân sách</h2>
<table>
<thead><tr><th>Ngân sách</th><th>Lựa chọn tại Cẩm Lệ</th><th>Phù hợp</th></tr></thead>
<tbody>
<tr><td>Khoảng 2 – 3 tỷ</td><td>Studio, 1PN+ Cora Tower, Spana Tower, S-Light Tower</td><td>Người mua nhà đầu tiên, đầu tư cho thuê</td></tr>
<tr><td>Khoảng 3 – 4 tỷ</td><td>Căn 2PN Sun NeO City hoặc lô đất thấp nhất Nam Hòa Xuân</td><td>Gia đình trẻ, tích lũy</td></tr>
<tr><td>Khoảng 4 – 6 tỷ</td><td>Lô 100 m² Cồn Dầu, Nam Hòa Xuân</td><td>Xây nhà ở, nhà cho thuê</td></tr>
<tr><td>Từ khoảng 20 tỷ</td><td>Đất biệt thự Euro Village 2</td><td>Giữ tài sản dài hạn, ở ven sông</td></tr>
</tbody>
</table>
<p>Các mức trên dựa vào giá tham khảo 10/2026 trong bài; anh chị nên cộng thêm thuế, phí công chứng, sang tên và chi phí hoàn thiện nội thất khi lập ngân sách.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với ngân sách khoảng 2 – 3 tỷ, căn hộ Sun NeO City là lựa chọn dễ tiếp cận để vào khu Hòa Xuân. Ngân sách 4 – 6 tỷ có thể cân nhắc một lô đất Cồn Dầu hoặc Nam Hòa Xuân để xây nhà ở. Khách ưu tiên dòng tiền nên so sánh thêm với căn hộ ven sông Hàn đã bàn giao, nơi giá thuê đã có số liệu kiểm chứng.</p>
<p>Xem thêm bài <a href="/bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026/">bất động sản Nam Đà Nẵng 2026</a> và trang <a href="/du-an/sun-neo-city/">Sun NeO City</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được lọc căn hộ, lô đất Cẩm Lệ đúng ngân sách và nhận bảng giá mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Cẩm Lệ 2026: căn hộ, đất nền, giá',
			'desc'      => 'Bất động sản Cẩm Lệ 2026: căn hộ Cora, Spana, S-Light Tower, đất nền Cồn Dầu, Euro Village 2, giá tham khảo và hạ tầng cầu Hòa Xuân. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Cẩm Lệ cũ nay gồm 3 phường: Cẩm Lệ, Hòa Xuân, An Khê (từ 1/7/2025)',
				'Căn hộ Sun NeO City từ khoảng 1,7 – 2,4 tỷ; Cora Tower khoảng 45 – 55 triệu/m² (tham khảo)',
				'Nhà đất Cẩm Lệ khoảng 46 – 100 triệu/m²; Hòa Xuân trung bình khoảng 61,5 triệu/m² (9/2026)',
			),
			'faq'       => array(
				array( 'Quận Cẩm Lệ nay là phường nào?', 'Từ 1/7/2025, địa bàn Cẩm Lệ cũ thành 3 phường: Cẩm Lệ (Hòa Thọ Tây, Hòa Thọ Đông, Khuê Trung), Hòa Xuân (Hòa Xuân, Hòa Châu, Hòa Phước) và An Khê (Hòa An, Hòa Phát, An Khê).' ),
				array( 'Căn hộ Cẩm Lệ giá bao nhiêu?', 'Tham khảo 10/2026: Cora Tower khoảng 45 – 55 triệu/m², từ khoảng 1,7 tỷ; Spana Tower từ khoảng 1,9 – 2,4 tỷ; S-Light Tower từ khoảng 2 – 2,4 tỷ (nguồn phân phối).' ),
				array( 'Giá đất Cẩm Lệ 2026 bao nhiêu?', 'Theo tin rao, nhà đất Cẩm Lệ khoảng 46 – 100 triệu/m²; đất nền Cồn Dầu khoảng 42 – 55 triệu/m².' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/hoi-dap-phap-luat/quan-cam-le-tp-da-nang-doi-thanh-gi-sau-sap-nhap-2025-138064800.html',
			'https://alonhadat.com.vn/nha-dat/can-ban/nha-dat/da-nang/589/quan-cam-le.html',
			'https://alonhadat.com.vn/nha-dat/can-ban/nha-dat/phuong-hoa-xuan-quan-cam-le-px1132.html',
			'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-spana-tower',
		),
	);

	$posts[] = array(
		'slug'     => 'bat-dong-san-hoi-an-2026-sau-hop-nhat',
		'title'    => 'Bất động sản Hội An 2026 sau hợp nhất Đà Nẵng – Quảng Nam',
		'excerpt'  => 'Bất động sản Hội An 2026: 3 phường mới Hội An, Hội An Đông, Hội An Tây; biệt thự Casamia Balanca 10 – 20 tỷ, Shantira, Hoiana; khách sạn An Bàng 50 – 91 tỷ (tham khảo).',
		'keyword'  => 'bất động sản Hội An',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 14,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Bất động sản Hội An</strong> bước sang năm 2026 với vị thế mới: từ ngày 1/7/2025, Hội An không còn là thành phố thuộc Quảng Nam mà trở thành các phường thuộc TP. Đà Nẵng. Thị trường vẫn xoay quanh ba dòng chính – biệt thự sinh thái ven sông, villa và khách sạn nghỉ dưỡng ven biển, nhà đất phục vụ homestay. Bài viết tổng hợp mặt bằng giá tham khảo tháng 10/2026 và những điểm cần lưu ý.</p>

<h2>Hội An sau sắp xếp hành chính</h2>
<table>
<thead><tr><th>Đơn vị mới</th><th>Hình thành từ (phường, xã cũ)</th></tr></thead>
<tbody>
<tr><td>Phường Hội An</td><td>Minh An, Cẩm Phô, Sơn Phong, Cẩm Nam, Cẩm Kim</td></tr>
<tr><td>Phường Hội An Đông</td><td>Cẩm Châu, Cửa Đại, Cẩm Thanh</td></tr>
<tr><td>Phường Hội An Tây</td><td>Cẩm Hà, Thanh Hà, Tân An, Cẩm An</td></tr>
<tr><td>Xã Tân Hiệp</td><td>Giữ nguyên (Cù Lao Chàm)</td></tr>
</tbody>
</table>
<p>Khi giao dịch, giấy tờ cũ vẫn ghi địa chỉ theo đơn vị hành chính trước sắp xếp; người mua nên đối chiếu địa chỉ mới khi làm thủ tục sang tên. Tổng quan tác động của hợp nhất có trong bài <a href="/hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh/">hợp nhất Đà Nẵng – Quảng Nam và vùng giáp ranh</a>.</p>

<h2>Mặt bằng giá bất động sản Hội An tham khảo 10/2026</h2>
<table>
<thead><tr><th>Dòng sản phẩm</th><th>Khu vực / dự án</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Biệt thự sinh thái dự án</td><td>Casamia Balanca (Cẩm Thanh)</td><td>Khoảng 10 – 20 tỷ/căn; Forestside từ khoảng 16 tỷ</td></tr>
<tr><td>Biệt thự, căn hộ resort ven biển</td><td>Shantira (An Bàng – Điện Dương)</td><td>Biệt thự khoảng 21,5 – 33 tỷ; studio khoảng 1,65 tỷ (tin rao)</td></tr>
<tr><td>Biệt thự resort phía Nam</td><td>Vinpearl Nam Hội An (Thăng Bình cũ)</td><td>Khoảng 9 – 16 tỷ (tin rao)</td></tr>
<tr><td>Villa, homestay nhà phố</td><td>Các phường Hội An</td><td>Khoảng 5,45 – 22 tỷ tùy vị trí, diện tích (tin rao)</td></tr>
<tr><td>Khách sạn, villa kinh doanh</td><td>An Bàng, Tân Thành</td><td>Khoảng 50 – 91 tỷ (20 – 39 phòng, đất 650 – 1.600 m²)</td></tr>
<tr><td>Đất ven biển quỹ resort</td><td>Lạc Long Quân (Điện Bàn ven biển)</td><td>Khoảng 16 – 30 triệu/m²</td></tr>
</tbody>
</table>
<p>Giá tổng hợp từ tin rao và nguồn phân phối, không phải tin rao cụ thể. Đất nhỏ lẻ ở các khu dân cư có tin rao từ khoảng 1,55 tỷ/lô, nhưng biên độ rất rộng theo vị trí.</p>

<h2>Các dự án nổi bật quanh Hội An</h2>
<h3>Biệt thự sinh thái Cẩm Thanh – sông Cổ Cò</h3>
<p><a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a> (31,1 ha, Đạt Phương) cùng Casamia Hội An và Casamia Calm tạo cụm biệt thự sinh thái lớn nhất phía Đông Hội An. So sánh chi tiết trong bài <a href="/casamia-balanca-so-sanh-biet-thu-hoi-an/">Casamia Balanca và biệt thự Hội An</a>.</p>
<h3>Nghỉ dưỡng ven biển</h3>
<p>Dải biển An Bàng – Hà My có Shantira, Four Seasons The Nam Hai; phía Nam có quần thể Hoiana Resort &amp; Golf gần 1.000 ha và Vinpearl Nam Hội An. Xem chi tiết tại bài <a href="/shantira-hoi-an-biet-thu-can-ho-gia-tham-khao/">Shantira Hội An</a>.</p>
<h3>Nhà phố thương mại</h3>
<p>Nam Hội An City có 420 nhà phố 3 tầng kiến trúc phố cổ ven sông Thu Bồn, phía Nam cầu Cửa Đại.</p>

<h2>Hạ tầng kết nối</h2>
<p>Đường ven biển 129 (Võ Chí Công) dài khoảng 26,5 km được mở rộng lên 6 làn, rút ngắn kết nối giữa Ngũ Hành Sơn và Hội An. Chi tiết trong bài <a href="/duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an/">đường ven biển 129 và bất động sản ven biển Hội An</a>.</p>

<h2>Lưu ý riêng khi mua bất động sản ở Hội An</h2>
<ul>
<li>Khu phố cổ và vùng đệm di sản có quy định chặt về chiều cao, kiến trúc, sửa chữa – cần hỏi kỹ trước khi mua để cải tạo.</li>
<li>Nhiều khu ven sông, ven biển chịu ảnh hưởng ngập lụt mùa mưa và xói lở – xem cao độ nền, lịch sử ngập.</li>
<li>Homestay, villa kinh doanh cần giấy phép lưu trú, PCCC; doanh thu phụ thuộc mạnh vào mùa du lịch.</li>
<li>Đất nông nghiệp, đất vườn chưa chuyển mục đích không xây được nhà – kiểm tra kỹ trên sổ và quy hoạch.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Hợp nhất hành chính tạo kỳ vọng, nhưng giá trị bền vững vẫn đến từ pháp lý rõ và khả năng khai thác thực tế. Khách cần dòng tiền nên ưu tiên tài sản đã vận hành có số liệu doanh thu; khách giữ tài sản nên chọn biệt thự dự án có sổ, quy hoạch đồng bộ. Trước khi đặt cọc bất kỳ lô đất nào ở Hội An, hãy kiểm tra quy hoạch và quy định vùng di sản.</p>
<p>Xem thêm danh sách <a href="/du-an/">dự án Đà Nẵng – Hội An</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tư vấn chọn biệt thự, villa, khách sạn Hội An phù hợp mục đích và ngân sách.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Hội An 2026 sau hợp nhất Đà Nẵng',
			'desc'      => 'Bất động sản Hội An 2026 sau hợp nhất: phường mới, giá tham khảo biệt thự Casamia, Shantira, villa, khách sạn An Bàng và lưu ý pháp lý. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Từ 1/7/2025, Hội An thành các phường Hội An, Hội An Đông, Hội An Tây và xã Tân Hiệp thuộc TP. Đà Nẵng',
				'Casamia Balanca khoảng 10 – 20 tỷ; Shantira biệt thự khoảng 21,5 – 33 tỷ (tham khảo 10/2026)',
				'Khách sạn An Bàng – Tân Thành khoảng 50 – 91 tỷ; villa, homestay khoảng 5,45 – 22 tỷ (tin rao)',
			),
			'faq'       => array(
				array( 'Hội An sau sáp nhập gồm những phường nào?', 'Phường Hội An, phường Hội An Đông, phường Hội An Tây và xã Tân Hiệp (Cù Lao Chàm), thuộc TP. Đà Nẵng từ 1/7/2025.' ),
				array( 'Giá biệt thự Hội An 2026 bao nhiêu?', 'Tham khảo 10/2026: Casamia Balanca khoảng 10 – 20 tỷ, Vinpearl Nam Hội An khoảng 9 – 16 tỷ, Shantira khoảng 21,5 – 33 tỷ theo tin rao.' ),
				array( 'Mua nhà đất Hội An cần lưu ý gì?', 'Kiểm tra quy định vùng di sản, quy hoạch, mục đích sử dụng đất, nguy cơ ngập lụt và giấy phép kinh doanh lưu trú nếu mua để làm homestay.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat/phuong-cam-an-tp-hoi-an-tinh-quang-nam-cu-doi-ten-thanh-gi-sau-sap-xep-don-vi-hanh-chinh-phuong-cam-276656-234782.html',
			'https://thuvienphapluat.vn/phap-luat/phuong-cua-dai-tp-hoi-an-tinh-quang-nam-cu-doi-ten-thanh-gi-sau-sap-xep-don-vi-hanh-chinh-phuong-cu-686639-234783.html',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-hoi-an-qna',
			'https://homedy.com/ban-dat-thanh-pho-hoi-an-quang-nam',
			'https://alonhadat.com.vn/nha-dat/can-ban/dat-tho-cu-dat-o/duong-lac-long-quan-thi-xa-dien-ban-dp24382.html',
		),
	);

	$posts[] = array(
		'slug'     => 'kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang',
		'title'    => 'Kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng trước khi mua',
		'excerpt'  => 'Cách kiểm tra quy hoạch Đà Nẵng và pháp lý nhà đất trước khi mua: tra cứu trên cổng thông tin quy hoạch của Sở Xây dựng, kiểm tra sổ, thế chấp, tranh chấp, dự án.',
		'keyword'  => 'kiểm tra quy hoạch Đà Nẵng',
		'project'  => '',
		'week'     => 14,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p><strong>Kiểm tra quy hoạch Đà Nẵng</strong> và pháp lý nhà đất là bước bắt buộc trước khi đặt cọc. Nhiều rủi ro – lô đất dính lộ giới, nằm trong quy hoạch công viên, sổ đang thế chấp, người bán không đủ quyền – đều có thể phát hiện sớm nếu kiểm tra đúng cách. Bài viết hướng dẫn trình tự kiểm tra cho cả nhà đất thổ cư và sản phẩm dự án, cập nhật tháng 10/2026.</p>

<h2>Bước 1: Tra cứu thông tin quy hoạch</h2>
<h3>Cổng thông tin quy hoạch của Sở Xây dựng Đà Nẵng</h3>
<p>Sở Xây dựng Đà Nẵng vận hành cổng thông tin quy hoạch xây dựng tại thongtinquyhoachxaydung.danang.gov.vn và cổng quy hoạch kiến trúc gisportal.danang.gov.vn/sxd; ứng dụng di động có tên TTQH Đà Nẵng trên Android và iOS. Người dùng có thể xem thông tin quy hoạch công khai mà không bắt buộc đăng nhập.</p>
<h3>Những thông tin cần đọc</h3>
<table>
<thead><tr><th>Thông tin</th><th>Ý nghĩa với người mua</th></tr></thead>
<tbody>
<tr><td>Chức năng sử dụng đất</td><td>Đất ở hay đất công viên, giao thông, công trình công cộng</td></tr>
<tr><td>Lộ giới, chỉ giới xây dựng</td><td>Phần diện tích có thể bị thu hồi khi mở đường; khoảng lùi khi xây</td></tr>
<tr><td>Mật độ xây dựng, tầng cao</td><td>Quyết định được xây bao nhiêu sàn – quan trọng với đất xây khách sạn, nhà cho thuê</td></tr>
<tr><td>Quy hoạch chi tiết 1/500 (dự án)</td><td>Đối chiếu vị trí, diện tích lô, chỉ tiêu xây dựng</td></tr>
</tbody>
</table>
<p>Thông tin trên bản đồ trực tuyến mang tính tham khảo. Với giao dịch giá trị lớn, nên đề nghị cung cấp thông tin quy hoạch bằng văn bản tại cơ quan có thẩm quyền.</p>

<h2>Bước 2: Kiểm tra giấy chứng nhận (sổ)</h2>
<ul>
<li>Xem bản gốc sổ, đối chiếu tên chủ sở hữu với giấy tờ tùy thân người bán.</li>
<li>Kiểm tra trang ghi biến động: thế chấp, xóa thế chấp, chuyển nhượng trước đó.</li>
<li>Mục đích sử dụng đất: đất ở lâu dài hay đất có thời hạn, đất nông nghiệp chưa chuyển mục đích.</li>
<li>Diện tích, kích thước trên sổ so với hiện trạng thực tế.</li>
<li>Nếu tài sản chung vợ chồng hoặc đồng sở hữu, cần đủ chữ ký các bên.</li>
</ul>

<h2>Bước 3: Kiểm tra thế chấp, tranh chấp, ngăn chặn</h2>
<p>Ngoài nội dung ghi trên sổ, người mua có thể đề nghị cung cấp thông tin tại văn phòng đăng ký đất đai và hỏi tổ chức công chứng về thông tin ngăn chặn giao dịch. Theo Luật Đất đai 2024, để chuyển nhượng, đất phải có giấy chứng nhận, không có tranh chấp hoặc tranh chấp đã được giải quyết, không bị kê biên bảo đảm thi hành án và còn trong thời hạn sử dụng đất. Hợp đồng chuyển nhượng quyền sử dụng đất giữa cá nhân phải được công chứng hoặc chứng thực.</p>

<h2>Bước 4: Kiểm tra hiện trạng</h2>
<ul>
<li>Đo đạc lại ranh giới, mốc giới; hỏi hàng xóm về tranh chấp ranh.</li>
<li>Nhà xây có phép không, số tầng thực tế có khớp giấy phép và hoàn công.</li>
<li>Lối đi chung, đường kiệt có nằm trong sổ hay chỉ là lối đi nhờ.</li>
<li>Khu vực có ngập khi mưa lớn, gần công trình gây ô nhiễm hay không.</li>
</ul>

<h2>Bước 5: Với sản phẩm dự án</h2>
<table>
<thead><tr><th>Hồ sơ</th><th>Kiểm tra gì</th></tr></thead>
<tbody>
<tr><td>Văn bản đủ điều kiện kinh doanh của Sở Xây dựng</td><td>Tòa, block, số căn được phép bán</td></tr>
<tr><td>Bảo lãnh ngân hàng</td><td>Áp dụng cho nhà ở hình thành trong tương lai</td></tr>
<tr><td>Tình trạng thế chấp dự án</td><td>Phương án giải chấp trước khi ký hợp đồng mua bán</td></tr>
<tr><td>Hợp đồng mua bán mẫu</td><td>Tiến độ thanh toán, bàn giao, cấp sổ, phạt chậm tiến độ</td></tr>
</tbody>
</table>
<p>Theo Luật Kinh doanh bất động sản 2023, tiền đặt cọc với nhà ở hình thành trong tương lai không quá 5% giá bán, thanh toán lần đầu không quá 30% và tổng thanh toán trước bàn giao không quá 70% giá trị hợp đồng. Xem thêm bài <a href="/kinh-nghiem-mua-can-ho-da-nang/">kinh nghiệm mua căn hộ Đà Nẵng</a>.</p>

<h2>Lưu ý sau sắp xếp hành chính</h2>
<p>Từ 1/7/2025, Đà Nẵng không còn cấp quận và hợp nhất với Quảng Nam. Sổ cấp trước đó vẫn ghi địa chỉ cũ; khi tra cứu quy hoạch và làm thủ tục, cần xác định đúng phường, xã mới tương ứng.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Hiệp luôn khuyên khách làm theo thứ tự: tra quy hoạch trước, xem sổ bản gốc và kiểm tra thế chấp sau, rồi mới bàn đến giá và đặt cọc. Đừng chấp nhận "sổ photo" hay lời hứa "quy hoạch sắp gỡ". Nếu một bước chưa rõ, hãy ghi điều kiện vào hợp đồng đặt cọc – xem bài <a href="/hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh/">hợp đồng đặt cọc mua nhà</a>.</p>
<p>Tham khảo thêm <a href="/quy-trinh-mua-can-ho-hoang-hiep-da-nang/">quy trình mua căn hộ 6 bước</a> và danh sách <a href="/mua-ban/">nhà đất đang bán</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được hỗ trợ kiểm tra quy hoạch, pháp lý lô đất hoặc căn hộ anh chị đang quan tâm.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Kiểm tra quy hoạch Đà Nẵng, pháp lý trước khi mua',
			'desc'      => 'Hướng dẫn kiểm tra quy hoạch Đà Nẵng và pháp lý nhà đất: cổng thông tin Sở Xây dựng, sổ, thế chấp, tranh chấp, hồ sơ dự án. Gọi Hoàng Hiệp hỗ trợ.',
			'points'    => array(
				'Tra quy hoạch trên cổng thông tin quy hoạch xây dựng của Sở Xây dựng Đà Nẵng hoặc ứng dụng TTQH Đà Nẵng',
				'Xem sổ bản gốc, trang biến động, mục đích – thời hạn sử dụng đất, tình trạng thế chấp',
				'Dự án: văn bản đủ điều kiện bán, bảo lãnh ngân hàng, cọc không quá 5% (Luật KDBĐS 2023)',
			),
			'faq'       => array(
				array( 'Tra cứu quy hoạch Đà Nẵng ở đâu?', 'Trên cổng thông tin quy hoạch xây dựng của Sở Xây dựng Đà Nẵng (thongtinquyhoachxaydung.danang.gov.vn), cổng gisportal.danang.gov.vn/sxd hoặc ứng dụng TTQH Đà Nẵng.' ),
				array( 'Đất thế nào thì đủ điều kiện chuyển nhượng?', 'Theo Luật Đất đai 2024: có giấy chứng nhận, không tranh chấp hoặc tranh chấp đã giải quyết, không bị kê biên bảo đảm thi hành án và còn thời hạn sử dụng đất.' ),
				array( 'Mua căn hộ dự án cần kiểm tra giấy tờ gì?', 'Văn bản đủ điều kiện kinh doanh của Sở Xây dựng, bảo lãnh ngân hàng, tình trạng thế chấp dự án và hợp đồng mua bán mẫu.' ),
			),
		),
		'sources'  => array(
			'https://thongtinquyhoachxaydung.danang.gov.vn/',
			'https://baodanang.vn/tra-cuu-thong-tin-quy-hoach-bang-ung-dung-di-dong-3279580.html',
			'https://thuvienphapluat.vn/cong-dong-dan-luat/quy-dinh-moi-ve-dat-coc-thanh-toan-nha-o-hinh-thanh-trong-tuong-lai-215439.html',
		),
	);

	$posts[] = array(
		'slug'     => 'hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh',
		'title'    => 'Hợp đồng đặt cọc mua nhà đất: rủi ro thường gặp và cách phòng tránh',
		'excerpt'  => 'Hợp đồng đặt cọc mua nhà đất: quy định Điều 328 Bộ luật Dân sự 2015, phạt cọc, các rủi ro thường gặp và điều khoản cần có để bảo vệ người mua tại Đà Nẵng.',
		'keyword'  => 'hợp đồng đặt cọc mua nhà',
		'project'  => '',
		'week'     => 14,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p><strong>Hợp đồng đặt cọc mua nhà</strong> là văn bản đầu tiên ràng buộc người mua và người bán, nhưng cũng là nơi phát sinh nhiều tranh chấp nhất. Một hợp đồng cọc viết sơ sài có thể khiến anh chị mất tiền cọc dù không có lỗi, hoặc không đòi được tiền khi người bán đổi ý. Bài viết tóm tắt quy định pháp luật, các rủi ro thường gặp và điều khoản nên có, cập nhật tháng 10/2026.</p>

<h2>Đặt cọc theo Bộ luật Dân sự 2015</h2>
<p>Theo Điều 328 Bộ luật Dân sự 2015, đặt cọc là việc một bên giao cho bên kia một khoản tiền hoặc tài sản có giá trị trong một thời hạn để bảo đảm giao kết hoặc thực hiện hợp đồng.</p>
<table>
<thead><tr><th>Tình huống</th><th>Hậu quả (trừ khi các bên thỏa thuận khác)</th></tr></thead>
<tbody>
<tr><td>Hợp đồng được giao kết, thực hiện</td><td>Tiền cọc được trả lại hoặc trừ vào tiền mua</td></tr>
<tr><td>Bên đặt cọc (người mua) từ chối</td><td>Mất tiền cọc</td></tr>
<tr><td>Bên nhận cọc (người bán) từ chối</td><td>Trả lại tiền cọc và một khoản tương đương giá trị tiền cọc</td></tr>
</tbody>
</table>
<p>Pháp luật không bắt buộc công chứng hợp đồng đặt cọc, nhưng nên lập văn bản rõ ràng, có chữ ký đầy đủ các bên; với giao dịch giá trị lớn có thể công chứng để hạn chế tranh chấp. Lưu ý: hợp đồng chuyển nhượng quyền sử dụng đất sau đó bắt buộc phải công chứng hoặc chứng thực.</p>

<h2>Đặt cọc khi mua căn hộ dự án</h2>
<p>Với nhà ở hình thành trong tương lai, Luật Kinh doanh bất động sản 2023 giới hạn tiền đặt cọc không quá 5% giá bán và chỉ được thu khi dự án đã đủ điều kiện đưa vào kinh doanh. Các khoản "giữ chỗ", "booking" trước thời điểm này cần xem kỹ điều kiện hoàn tiền.</p>

<h2>6 rủi ro thường gặp khi đặt cọc</h2>
<h3>1. Người nhận cọc không phải chủ sở hữu</h3>
<p>Cọc cho người không đứng tên sổ, hoặc chỉ một trong hai vợ chồng ký với tài sản chung. Môi giới không mặc nhiên có quyền nhận cọc thay chủ nhà nếu không có văn bản ủy quyền hợp lệ.</p>
<h3>2. Tài sản đang thế chấp, tranh chấp</h3>
<p>Sổ đang thế chấp ngân hàng mà hợp đồng không nêu cách giải chấp, ai chịu trách nhiệm và thời hạn.</p>
<h3>3. Lô đất dính quy hoạch, lộ giới</h3>
<p>Phát hiện sau khi cọc rằng một phần đất nằm trong lộ giới hoặc quy hoạch công trình công cộng. Xem cách kiểm tra trong bài <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>
<h3>4. Thời hạn công chứng không rõ</h3>
<p>Không ghi hạn chót ký hợp đồng chuyển nhượng, dẫn đến kéo dài hoặc bên kia viện cớ "chưa đến hạn".</p>
<h3>5. Không lường trước trở ngại khách quan</h3>
<p>Người mua vay ngân hàng nhưng hồ sơ vay bị từ chối, hoặc thủ tục hành chính kéo dài. Nếu hợp đồng không có điều khoản xử lý, rất dễ tranh chấp về việc có bị phạt cọc hay không.</p>
<h3>6. Giá ghi trong hợp đồng khác giá thực tế</h3>
<p>Ghi giá thấp để giảm thuế tiềm ẩn rủi ro pháp lý cho cả hai bên và gây bất lợi khi tranh chấp.</p>

<h2>Điều khoản nên có trong hợp đồng đặt cọc</h2>
<table>
<thead><tr><th>Điều khoản</th><th>Nội dung nên ghi</th></tr></thead>
<tbody>
<tr><td>Thông tin tài sản</td><td>Số sổ, thửa đất, tờ bản đồ, diện tích, địa chỉ cũ và mới</td></tr>
<tr><td>Giá và phương thức thanh toán</td><td>Tổng giá, số tiền cọc, các đợt thanh toán, chuyển khoản vào tài khoản chủ sở hữu</td></tr>
<tr><td>Thời hạn</td><td>Ngày ký hợp đồng công chứng, ngày bàn giao</td></tr>
<tr><td>Cam kết của bên bán</td><td>Tài sản không tranh chấp, không kê biên; cách giải chấp nếu đang thế chấp</td></tr>
<tr><td>Thuế, phí</td><td>Ai nộp thuế thu nhập cá nhân, lệ phí trước bạ, phí công chứng</td></tr>
<tr><td>Trường hợp hoàn cọc</td><td>Quy hoạch không như cam kết, ngân hàng không cho vay, trở ngại khách quan</td></tr>
<tr><td>Phạt cọc</td><td>Mức phạt cụ thể với từng bên</td></tr>
</tbody>
</table>

<h2>Cách phòng tránh rủi ro</h2>
<ul>
<li>Kiểm tra sổ bản gốc, quy hoạch, thế chấp trước khi chuyển bất kỳ khoản tiền nào.</li>
<li>Chuyển khoản vào đúng tài khoản người đứng tên sổ, ghi nội dung "đặt cọc mua nhà đất số…".</li>
<li>Mức cọc vừa phải, đủ ràng buộc; thời hạn công chứng ngắn và cụ thể.</li>
<li>Đủ chữ ký của tất cả đồng sở hữu; có người làm chứng hoặc công chứng với giao dịch lớn.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Hợp đồng cọc tốt là hợp đồng trả lời trước được câu hỏi "nếu không mua được thì sao?". Hiệp khuyên anh chị đọc kỹ từng điều khoản hoàn cọc, đặc biệt khi mua có vay ngân hàng. Với căn hộ dự án, hãy đối chiếu điều kiện hoàn tiền giữ chỗ và văn bản đủ điều kiện bán trước khi chuyển tiền.</p>
<p>Xem thêm <a href="/quy-trinh-mua-can-ho-hoang-hiep-da-nang/">quy trình mua căn hộ 6 bước</a> và danh sách <a href="/mua-ban/">nhà đất đang bán</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được hỗ trợ rà soát hợp đồng đặt cọc trước khi ký.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hợp đồng đặt cọc mua nhà: rủi ro và cách phòng tránh',
			'desc'      => 'Hợp đồng đặt cọc mua nhà đất: Điều 328 Bộ luật Dân sự, phạt cọc, 6 rủi ro thường gặp, điều khoản cần có và cách phòng tránh. Gọi Hoàng Hiệp hỗ trợ.',
			'points'    => array(
				'Điều 328 BLDS 2015: bên mua từ chối mất cọc; bên bán từ chối trả cọc và khoản tương đương, trừ khi có thỏa thuận khác',
				'Nhà ở hình thành trong tương lai: cọc không quá 5% giá bán (Luật KDBĐS 2023)',
				'Ghi rõ thời hạn công chứng, cách giải chấp, trường hợp hoàn cọc; chuyển tiền vào tài khoản chủ sở hữu',
			),
			'faq'       => array(
				array( 'Hợp đồng đặt cọc mua nhà có bắt buộc công chứng không?', 'Pháp luật không bắt buộc công chứng hợp đồng đặt cọc, nhưng nên lập văn bản rõ ràng và có thể công chứng với giao dịch lớn. Hợp đồng chuyển nhượng quyền sử dụng đất thì bắt buộc công chứng hoặc chứng thực.' ),
				array( 'Người bán đổi ý không bán thì xử lý thế nào?', 'Theo Điều 328 Bộ luật Dân sự 2015, bên nhận cọc từ chối giao kết phải trả lại tiền cọc và một khoản tương đương giá trị tiền cọc, trừ khi các bên thỏa thuận khác.' ),
				array( 'Có nên đưa tiền cọc cho môi giới?', 'Môi giới không mặc nhiên có quyền nhận cọc thay chủ nhà. Nên chuyển khoản trực tiếp vào tài khoản người đứng tên sổ, trừ khi có văn bản ủy quyền hợp lệ.' ),
			),
		),
		'sources'  => array(
			'https://tapchitoaan.vn/quyen-nghia-vu-cua-cac-ben-trong-hop-dong-dat-coc-va-trach-nhiem-cua-cong-chung-tu-mot-tinh-huong-cu-the10664.html',
			'https://vienphapluat.vn/quy-dinh-cua-phap-luat-ve-hop-dong-dat-coc-dat-nd312024.html',
			'https://thuvienphapluat.vn/cong-dong-dan-luat/quy-dinh-moi-ve-dat-coc-thanh-toan-nha-o-hinh-thanh-trong-tuong-lai-215439.html',
			'https://phapluat.suckhoedoisong.vn/dat-coc-mua-nha-dat-qua-moi-gioi-5-dieu-phai-kiem-tra-truoc-khi-chuyen-tien-284851.html',
		),
	);

	return $posts;
}
