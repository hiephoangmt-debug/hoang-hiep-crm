<?php
/**
 * Bài viết kế hoạch nội dung – tuần 1–2 (cụm Về Hoàng Hiệp, thị trường Đà Nẵng 2026, FourS Tower). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_01_02' );
function hh_posts_tuan_01_02( $posts ) {

	/* ================= TUẦN 1 ================= */

	$posts[] = array(
		'slug'     => 'du-an-hoang-hiep-bat-dong-san-dang-tu-van-2026',
		'title'    => 'Hoàng Hiệp bất động sản: các dự án đang tư vấn tại Đà Nẵng 2026',
		'excerpt'  => 'Danh sách dự án Hoàng Hiệp bất động sản đang tư vấn năm 2026 tại Đà Nẵng – Hội An, chia theo khu vực và loại hình: căn hộ, đất nền, biệt thự.',
		'keyword'  => 'Hoàng Hiệp bất động sản',
		'project'  => '',
		'week'     => 1,
		'category' => 'Về Hoàng Hiệp',
		'content'  => <<<'HTML'
<p>Hoàng Hiệp bất động sản hiện tư vấn hàng chục dự án tại Đà Nẵng và vùng Hội An – Điện Bàn, gồm căn hộ sở hữu lâu dài, căn hộ dịch vụ, đất nền và biệt thự nghỉ dưỡng. Bài viết này gom các dự án theo khu vực và loại hình để anh chị tìm nhanh trang chi tiết của từng dự án (cập nhật tháng 10/2026).</p>
<p>Danh sách chỉ mang tính định hướng: tình trạng mở bán, giá và chính sách thay đổi theo từng đợt của chủ đầu tư, nên thông tin chính xác nhất luôn nằm ở trang dự án và bảng giá mới nhất mà Hiệp gửi trực tiếp.</p>

<h2>Hoàng Hiệp bất động sản tư vấn những nhóm sản phẩm nào?</h2>
<p>Hiệp chia sản phẩm thành bốn nhóm theo nhu cầu phổ biến của khách: mua để ở, mua để cho thuê, mua đất tích lũy và mua biệt thự nghỉ dưỡng. Mỗi nhóm có khu vực "trọng tâm" khác nhau, vì vậy cách đọc danh sách dưới đây là chọn nhu cầu trước, khu vực sau.</p>
<table>
<thead><tr><th>Nhu cầu</th><th>Loại hình phù hợp</th><th>Khu vực nên xem</th></tr></thead>
<tbody>
<tr><td>Mua để ở</td><td>Căn hộ 1–3 phòng ngủ, sở hữu lâu dài</td><td>Hải Châu, Sơn Trà, Nam Đà Nẵng (Hòa Xuân, Hòa Quý)</td></tr>
<tr><td>Mua để cho thuê</td><td>Studio, 1PN, căn hộ dịch vụ</td><td>Ven sông Hàn, ven biển Sơn Trà – Ngũ Hành Sơn</td></tr>
<tr><td>Tích lũy đất</td><td>Đất nền khu đô thị</td><td>Hòa Xuân, Nam Hòa Xuân, Võ Chí Công, Liên Chiểu</td></tr>
<tr><td>Nghỉ dưỡng, dòng tiền</td><td>Biệt thự biển, biệt thự golf</td><td>Ngũ Hành Sơn, Hội An, Nam Hội An</td></tr>
</tbody>
</table>

<h2>Căn hộ ven sông Hàn và quận Sơn Trà</h2>
<p>Đây là nhóm căn hộ có vị trí trung tâm, view sông Hàn hoặc biển Mỹ Khê, phù hợp cả để ở lẫn cho thuê. Các dự án Hiệp đang tư vấn gồm <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>, <a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>, The Legend, Times Square, Capital Square và Hiyori Garden Tower.</p>
<p>Phía bờ Tây sông Hàn (Hải Châu) có <a href="/du-an/danang-landmark/">Danang Landmark</a>, M Riverside, Masteri Đà Nẵng, Vista Residence, The Meridian, The Filmore và Đà Nẵng Downtown của Sun Group. Anh chị xem tổng hợp theo khu vực tại trang <a href="/khu-vuc/son-tra/">bất động sản Sơn Trà</a>.</p>

<h2>Căn hộ khu Nam Đà Nẵng: Hòa Xuân, Hòa Quý</h2>
<p>Nam Đà Nẵng là nơi tập trung nguồn cung căn hộ mới năm 2026, chủ yếu từ hệ sinh thái Sun NeO City và Sun Riverpolis của Sun Group. Nhóm này gồm <a href="/du-an/fours-tower/">FourS Tower (Tháp Bốn Mùa)</a>, Cora Tower, Spana Tower, S-Light Tower, cùng Sun Cosmo Residence, FPT Plaza và Newtown Diamond ở khu Ngũ Hành Sơn.</p>
<p>Ưu điểm chung là mặt bằng giá thường mềm hơn khu ven sông Hàn, quỹ đất rộng và hưởng lợi từ hạ tầng phía Nam. Nhược điểm là tiện ích khu vực vẫn đang hoàn thiện, cần xem tiến độ từng phân khu.</p>

<h2>Đất nền và khu đô thị</h2>
<p>Với nhu cầu tích lũy, Hiệp tư vấn các khu đất nền có pháp lý rõ ràng như <a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">đất nền Đầm Sen – Sun Riverpolis</a>, đất nền Võ Chí Công, Khu đô thị sinh thái Hòa Xuân, FPT City Đà Nẵng, Dragon Smart City và One World Regency (Điện Bàn). Danh sách lô đang chào bán xem tại <a href="/mua-ban/dat-nen/">mua bán đất nền Đà Nẵng</a>.</p>

<h2>Biệt thự biển và nghỉ dưỡng</h2>
<p>Nhóm biệt thự gồm The Ocean Villas, Furama Villas, Premier Village, Fusion Resort Villas ở ven biển Ngũ Hành Sơn – Sơn Trà, và các dự án vùng Hội An như Hoiana Resort &amp; Golf, Casamia Hội An, Nam Hội An City. Phía Tây Bắc có Vinhomes Hải Vân Bay. Anh chị lọc theo loại hình tại trang <a href="/loai-du-an/biet-thu/">biệt thự Đà Nẵng</a>.</p>

<h2>Cách dùng danh sách này hiệu quả</h2>
<h3>Bắt đầu từ ngân sách và mục đích</h3>
<p>Một danh sách dài dễ gây rối. Anh chị nên xác định ngân sách tối đa, tỷ lệ vốn tự có và mục đích (ở, cho thuê hay tích lũy) trước, sau đó Hiệp sẽ thu hẹp còn 2–3 dự án đáng xem nhất.</p>
<h3>Luôn đối chiếu với nguồn chính thức</h3>
<p>Mỗi trang dự án trên web đều ghi nguồn tham khảo. Trước khi xuống tiền, Hiệp gửi kèm bảng giá, chính sách và hồ sơ pháp lý của đợt hiện hành để anh chị đối chiếu. Quy trình đầy đủ được trình bày trong bài <a href="/quy-trinh-mua-can-ho-hoang-hiep-da-nang/">quy trình mua căn hộ Đà Nẵng cùng Hoàng Hiệp</a>.</p>
<p>Toàn bộ danh mục dự án được cập nhật tại trang <a href="/du-an/">dự án bất động sản Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách dự án phù hợp với ngân sách và bảng giá mới nhất của từng dự án.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hoàng Hiệp bất động sản: dự án đang tư vấn 2026',
			'desc'      => 'Hoàng Hiệp bất động sản tổng hợp các dự án đang tư vấn tại Đà Nẵng 2026 theo khu vực, loại hình. Gọi 0904 567 009 để nhận bảng giá mới.',
			'points'    => array( 'Dự án chia theo nhu cầu: ở, cho thuê, tích lũy đất, nghỉ dưỡng', 'Căn hộ tập trung ven sông Hàn, Sơn Trà và Nam Đà Nẵng', 'Giá và chính sách cập nhật theo từng đợt mở bán' ),
			'faq'       => array(
				array( 'Hoàng Hiệp tư vấn những loại bất động sản nào?', 'Căn hộ sở hữu lâu dài, căn hộ dịch vụ, đất nền và biệt thự nghỉ dưỡng tại Đà Nẵng, Hội An và Điện Bàn.' ),
				array( 'Khu vực nào đang có nhiều căn hộ mới năm 2026?', 'Nam Đà Nẵng (Hòa Xuân, Hòa Quý) với các phân khu của Sun NeO City và Sun Riverpolis như FourS Tower, Spana Tower, S-Light Tower.' ),
				array( 'Giá trên web có phải giá chính thức?', 'Giá trên web là tham khảo từ nguồn công khai. Bảng giá chính thức thay đổi theo từng đợt, Hoàng Hiệp gửi trực tiếp khi anh chị liên hệ.' ),
			),
		),
		'sources'  => array(),
	);

	$posts[] = array(
		'slug'     => 'quy-trinh-mua-can-ho-hoang-hiep-da-nang',
		'title'    => 'Hoàng Hiệp Đà Nẵng: quy trình mua căn hộ 6 bước từ tư vấn đến bàn giao',
		'excerpt'  => 'Quy trình mua căn hộ cùng Hoàng Hiệp Đà Nẵng gồm 6 bước: tư vấn nhu cầu, chọn dự án, xem thực tế, kiểm tra pháp lý, đặt cọc/HĐMB, vay và bàn giao.',
		'keyword'  => 'Hoàng Hiệp Đà Nẵng',
		'project'  => '',
		'week'     => 1,
		'category' => 'Về Hoàng Hiệp',
		'content'  => <<<'HTML'
<p>Mua căn hộ cùng Hoàng Hiệp Đà Nẵng đi qua 6 bước: tư vấn nhu cầu, chọn dự án, xem thực tế, kiểm tra pháp lý, đặt cọc và ký hợp đồng mua bán, cuối cùng là vay ngân hàng và nhận bàn giao. Mỗi bước có đầu ra rõ ràng để anh chị biết mình đang ở đâu và cần chuẩn bị gì (cập nhật tháng 10/2026).</p>

<h2>Tổng quan 6 bước mua căn hộ cùng Hoàng Hiệp Đà Nẵng</h2>
<table>
<thead><tr><th>Bước</th><th>Việc chính</th><th>Kết quả anh chị nhận được</th></tr></thead>
<tbody>
<tr><td>1. Tư vấn nhu cầu</td><td>Trao đổi mục đích, ngân sách, khu vực</td><td>Bộ tiêu chí chọn căn</td></tr>
<tr><td>2. Chọn dự án</td><td>So sánh 2–3 dự án phù hợp</td><td>Bảng so sánh giá, vị trí, pháp lý</td></tr>
<tr><td>3. Xem thực tế</td><td>Đi xem dự án, nhà mẫu, khu vực</td><td>Danh sách căn ưu tiên</td></tr>
<tr><td>4. Kiểm tra pháp lý</td><td>Đối chiếu giấy tờ dự án và hợp đồng mẫu</td><td>Danh mục điểm cần lưu ý</td></tr>
<tr><td>5. Đặt cọc / HĐMB</td><td>Giữ chỗ, ký thỏa thuận, ký hợp đồng</td><td>Lịch thanh toán cụ thể</td></tr>
<tr><td>6. Vay &amp; bàn giao</td><td>Hồ sơ vay, nghiệm thu, nhận nhà</td><td>Căn hộ và hồ sơ cấp sổ</td></tr>
</tbody>
</table>

<h2>Bước 1: Tư vấn nhu cầu</h2>
<p>Hiệp bắt đầu bằng vài câu hỏi đơn giản: mua để ở hay cho thuê, ngân sách tối đa, vốn tự có bao nhiêu phần trăm và thời điểm cần nhận nhà. Câu trả lời quyết định loại căn (Studio, 1PN, 2PN hay 3PN) và khu vực nên ưu tiên.</p>
<p>Ở bước này anh chị chưa cần chọn dự án. Mục tiêu là có bộ tiêu chí rõ để tránh bị cuốn theo quảng cáo.</p>

<h2>Bước 2: Chọn dự án</h2>
<p>Từ tiêu chí, Hiệp lọc ra 2–3 dự án trong danh mục <a href="/du-an/">dự án bất động sản Đà Nẵng</a> và lập bảng so sánh giá tham khảo, tiến độ, chủ đầu tư và hình thức sở hữu. Với người mua để ở, Hiệp thường đề xuất so sánh giữa khu trung tâm và khu Nam Đà Nẵng, nơi có nhiều nguồn cung mới như <a href="/du-an/fours-tower/">FourS Tower</a>.</p>

<h2>Bước 3: Xem thực tế</h2>
<p>Hiệp đưa anh chị đi xem công trường hoặc tòa đã hoàn thiện, nhà mẫu và hạ tầng xung quanh. Nên xem vào hai thời điểm khác nhau trong ngày để cảm nhận tiếng ồn, giao thông và hướng nắng.</p>
<h3>Những điểm nên ghi lại khi xem</h3>
<ul>
<li>Hướng ban công, view thực tế ở tầng dự kiến mua.</li>
<li>Khoảng cách đến trường học, chợ, bệnh viện, bãi biển.</li>
<li>Mật độ căn trên mỗi tầng và số thang máy.</li>
</ul>

<h2>Bước 4: Kiểm tra pháp lý</h2>
<p>Trước khi đặt tiền, anh chị cần biết dự án đã đủ điều kiện huy động vốn hay chưa, hình thức sở hữu (lâu dài hay có thời hạn) và các điều khoản quan trọng trong hợp đồng mẫu. Hiệp gửi danh mục giấy tờ cần đối chiếu và khuyến khích anh chị nhờ thêm luật sư nếu giá trị giao dịch lớn.</p>

<h2>Bước 5: Đặt cọc và ký hợp đồng mua bán</h2>
<p>Thông thường khách giữ chỗ (booking) trước, sau đó ký thỏa thuận đặt cọc và hợp đồng mua bán theo lịch của chủ đầu tư. Hiệp giúp anh chị đọc kỹ lịch thanh toán, mức chiết khấu đang áp dụng và điều kiện hoàn tiền nếu không mua được căn mong muốn.</p>

<h2>Bước 6: Vay ngân hàng và nhận bàn giao</h2>
<p>Nếu cần vay, Hiệp kết nối anh chị với ngân hàng mà dự án liên kết để so sánh lãi suất, thời gian ân hạn và phí trả nợ trước hạn. Đến kỳ bàn giao, anh chị kiểm tra căn hộ theo biên bản, ghi lại lỗi để chủ đầu tư khắc phục, rồi theo dõi hồ sơ cấp giấy chứng nhận.</p>
<h2>Mua căn hộ từ xa có được không?</h2>
<p>Nhiều khách ở Hà Nội, TP.HCM hoặc nước ngoài mua căn hộ Đà Nẵng mà chỉ ra thực tế một hai lần. Khi đó, Hiệp gửi video, hình ảnh, tài liệu qua Zalo ở bước 2–3 và hẹn lịch xem trực tiếp trước khi ký hợp đồng, để anh chị vẫn kiểm soát được các quyết định quan trọng.</p>
<p>Nếu đang cân nhắc chọn người đồng hành, anh chị có thể tham khảo bài <a href="/chon-moi-gioi-bat-dong-san-da-nang-8-cau-hoi/">8 câu nên hỏi khi chọn môi giới bất động sản Đà Nẵng</a>. Danh sách căn đang chào bán xem tại <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để bắt đầu bước 1 và nhận bảng so sánh dự án theo đúng ngân sách của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hoàng Hiệp Đà Nẵng: quy trình mua căn hộ 6 bước',
			'desc'      => 'Quy trình mua căn hộ cùng Hoàng Hiệp Đà Nẵng: 6 bước từ tư vấn, chọn dự án, pháp lý, đặt cọc đến vay và bàn giao. Gọi 0904 567 009.',
			'points'    => array( 'Xác định nhu cầu và ngân sách trước khi chọn dự án', 'Kiểm tra pháp lý, hợp đồng mẫu trước khi đặt cọc', 'So sánh gói vay ngân hàng và kiểm tra kỹ khi bàn giao' ),
			'faq'       => array(
				array( 'Mua căn hộ qua Hoàng Hiệp mất bao lâu?', 'Tùy dự án và lịch mở bán. Từ tư vấn đến ký hợp đồng có thể vài ngày đến vài tuần; bàn giao phụ thuộc tiến độ xây dựng.' ),
				array( 'Có cần chuẩn bị giấy tờ gì để đặt cọc?', 'Thường cần CCCD và thông tin liên hệ; khi vay ngân hàng cần thêm giấy tờ chứng minh thu nhập, tình trạng hôn nhân theo yêu cầu ngân hàng.' ),
				array( 'Hoàng Hiệp có hỗ trợ hồ sơ vay không?', 'Có, Hiệp kết nối ngân hàng liên kết với dự án và giúp so sánh lãi suất, thời gian ân hạn, phí trả nợ trước hạn.' ),
			),
		),
		'sources'  => array(),
	);

	$posts[] = array(
		'slug'     => 'chon-moi-gioi-bat-dong-san-da-nang-8-cau-hoi',
		'title'    => 'Môi giới bất động sản Đà Nẵng: 8 câu nên hỏi trước khi giao dịch',
		'excerpt'  => 'Chọn môi giới bất động sản Đà Nẵng thế nào cho an toàn? 8 câu hỏi giúp anh chị kiểm tra kiến thức, minh bạch và trách nhiệm của người tư vấn.',
		'keyword'  => 'môi giới bất động sản Đà Nẵng',
		'project'  => '',
		'week'     => 1,
		'category' => 'Về Hoàng Hiệp',
		'content'  => <<<'HTML'
<p>Một môi giới bất động sản Đà Nẵng đáng tin là người trả lời rõ ràng về pháp lý, giá, phí và rủi ro, thay vì chỉ nói về lợi nhuận. Dưới đây là 8 câu hỏi anh chị nên đặt ra trước khi giao dịch, áp dụng cho bất kỳ người tư vấn nào, kể cả Hoàng Hiệp (cập nhật tháng 10/2026).</p>

<h2>Vì sao cần "phỏng vấn" môi giới bất động sản Đà Nẵng?</h2>
<p>Thị trường Đà Nẵng năm 2026 có nhiều dự án mở bán cùng lúc, nhiều đại lý cùng phân phối một dự án và thông tin chính sách thay đổi theo đợt. Người mua dễ nhận được thông tin không đồng nhất, nên việc chủ động đặt câu hỏi giúp lọc ra người tư vấn phù hợp.</p>

<h2>8 câu hỏi nên đặt ra</h2>
<table>
<thead><tr><th>#</th><th>Câu hỏi</th><th>Câu trả lời tốt thường có</th></tr></thead>
<tbody>
<tr><td>1</td><td>Anh/chị phân phối dự án này với tư cách gì?</td><td>Nói rõ là đại lý, cộng tác viên hay môi giới độc lập</td></tr>
<tr><td>2</td><td>Pháp lý dự án đang ở bước nào?</td><td>Nêu giấy tờ cụ thể, cho xem bản sao hoặc nguồn công bố</td></tr>
<tr><td>3</td><td>Giá này là giá đợt nào, áp dụng đến khi nào?</td><td>Có bảng giá, chính sách bằng văn bản</td></tr>
<tr><td>4</td><td>Tổng chi phí thực tế là bao nhiêu?</td><td>Tính đủ VAT, phí bảo trì, phí công chứng, lãi vay</td></tr>
<tr><td>5</td><td>Rủi ro lớn nhất của sản phẩm này là gì?</td><td>Nêu thẳng nhược điểm, không né tránh</td></tr>
<tr><td>6</td><td>Có phương án nào khác trong cùng tầm giá?</td><td>Đưa ra so sánh, không ép một lựa chọn</td></tr>
<tr><td>7</td><td>Nếu không mua được căn đã chọn thì tiền giữ chỗ xử lý thế nào?</td><td>Giải thích điều kiện hoàn tiền theo văn bản</td></tr>
<tr><td>8</td><td>Sau khi ký, ai hỗ trợ tôi đến lúc bàn giao?</td><td>Cam kết đầu mối liên hệ cụ thể</td></tr>
</tbody>
</table>

<h3>Câu 1–2: Tư cách và pháp lý</h3>
<p>Biết người tư vấn là ai giúp anh chị hiểu thông tin của họ đến từ đâu. Với pháp lý, đừng chấp nhận câu trả lời chung chung như "pháp lý chuẩn", hãy hỏi cụ thể giấy tờ nào đã có và giấy tờ nào đang chờ.</p>
<h3>Câu 3–4: Giá và tổng chi phí</h3>
<p>Giá rao trên mạng thường là giá "từ", chưa phải giá căn anh chị chọn. Hãy yêu cầu bảng tính tổng chi phí theo phương án thanh toán cụ thể, gồm chiết khấu, VAT, phí bảo trì và chi phí vay nếu có.</p>
<h3>Câu 5–6: Rủi ro và phương án thay thế</h3>
<p>Người tư vấn có trách nhiệm sẽ chủ động nói về tiến độ, cạnh tranh nguồn cung cho thuê hay hạ tầng chưa hoàn thiện. Việc đưa ra 2–3 lựa chọn để so sánh cho thấy họ đặt nhu cầu của anh chị lên trước.</p>
<h3>Câu 7–8: Tiền giữ chỗ và hậu mãi</h3>
<p>Tiền booking, đặt cọc luôn cần có văn bản ghi rõ điều kiện. Ngoài ra, giai đoạn từ ký hợp đồng đến bàn giao thường kéo dài, nên cần một đầu mối theo dõi lịch thanh toán và nhắc các mốc quan trọng.</p>

<h2>Dấu hiệu nên cẩn trọng</h2>
<ul>
<li>Cam kết lợi nhuận hoặc giá tăng chắc chắn mà không có văn bản của chủ đầu tư.</li>
<li>Thúc ép chuyển tiền gấp vào tài khoản cá nhân.</li>
<li>Không cung cấp được bảng giá, chính sách bằng văn bản.</li>
<li>Né tránh câu hỏi về pháp lý hoặc phí phát sinh.</li>
</ul>

<h2>Ghi lại mọi thỏa thuận bằng văn bản</h2>
<p>Dù chọn ai, anh chị nên lưu lại tin nhắn, email và văn bản liên quan đến giá, chính sách, tiền giữ chỗ. Đây là căn cứ quan trọng nếu sau này có khác biệt giữa lời tư vấn và hợp đồng thực tế.</p>

<h2>Hoàng Hiệp làm việc với khách như thế nào?</h2>
<p>Hoàng Hiệp tư vấn và phân phối nhiều dự án tại Đà Nẵng, không phải nhân viên của chủ đầu tư nào. Mọi câu hỏi trong danh sách trên anh chị đều có thể hỏi trực tiếp Hiệp. Quy trình làm việc chi tiết xem tại bài <a href="/quy-trinh-mua-can-ho-hoang-hiep-da-nang/">quy trình mua căn hộ 6 bước</a>, thông tin về Hiệp xem tại trang <a href="/gioi-thieu/">giới thiệu</a> và danh mục <a href="/du-an/">dự án bất động sản Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để đặt bất kỳ câu hỏi nào ở trên về dự án anh chị đang quan tâm, hoặc gửi yêu cầu qua trang <a href="/lien-he/">liên hệ</a>.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Môi giới bất động sản Đà Nẵng: 8 câu nên hỏi',
			'desc'      => 'Chọn môi giới bất động sản Đà Nẵng an toàn với 8 câu hỏi về pháp lý, giá, phí và hậu mãi. Gọi 0904 567 009 để được giải đáp trực tiếp.',
			'points'    => array( 'Hỏi rõ tư cách phân phối và pháp lý dự án', 'Yêu cầu bảng giá, tổng chi phí bằng văn bản', 'Cẩn trọng với cam kết lợi nhuận và chuyển tiền vào tài khoản cá nhân' ),
			'faq'       => array(
				array( 'Có nên chuyển tiền giữ chỗ cho môi giới?', 'Nên chuyển vào tài khoản của chủ đầu tư hoặc đơn vị phân phối chính thức, có văn bản ghi rõ điều kiện hoàn tiền.' ),
				array( 'Làm sao biết thông tin pháp lý môi giới đưa ra là đúng?', 'Yêu cầu bản sao giấy tờ hoặc nguồn công bố chính thức, đối chiếu với cơ quan quản lý hoặc nhờ luật sư khi giá trị lớn.' ),
				array( 'Mua qua môi giới có đắt hơn mua trực tiếp chủ đầu tư?', 'Với dự án sơ cấp, giá và chính sách thường theo bảng giá chung của chủ đầu tư; anh chị nên đối chiếu bảng giá bằng văn bản.' ),
			),
		),
		'sources'  => array(),
	);

	$posts[] = array(
		'slug'     => 'thi-truong-bat-dong-san-da-nang-2026',
		'title'    => 'Bất động sản Đà Nẵng 2026: giá, nguồn cung và xu hướng thị trường',
		'excerpt'  => 'Bất động sản Đà Nẵng 2026: giá căn hộ sơ cấp khoảng 83 triệu/m², giao dịch quý 2 tăng 54%, đất nền phục hồi chậm. Tổng hợp từ CBRE, DKRA.',
		'keyword'  => 'bất động sản Đà Nẵng 2026',
		'project'  => '',
		'week'     => 1,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Bất động sản Đà Nẵng 2026 được dẫn dắt bởi phân khúc căn hộ: giá sơ cấp trung bình khoảng 83 triệu đồng/m² (CBRE, quý 1/2026), quý 2 có khoảng 2.793 căn giao dịch thành công, tăng 54% so với quý trước (DKRA). Đất nền phục hồi chậm hơn và biên độ tăng giá được dự báo không còn đột biến như giai đoạn 2024–2025 (cập nhật tháng 10/2026).</p>

<h2>Số liệu chính bất động sản Đà Nẵng 2026</h2>
<table>
<thead><tr><th>Chỉ số</th><th>Số liệu (tham khảo)</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Giá căn hộ sơ cấp trung bình</td><td>Khoảng 83 triệu đồng/m² (quý 1/2026)</td><td>CBRE</td></tr>
<tr><td>Nguồn cung căn hộ tích lũy</td><td>Khoảng 16.000 căn, tỷ lệ bán tích lũy khoảng 89%</td><td>CBRE</td></tr>
<tr><td>Căn hộ mới mở bán 2024–2025</td><td>Hơn 8.000 căn</td><td>CBRE</td></tr>
<tr><td>Nguồn cung sơ cấp quý 2/2026</td><td>Khoảng 5.090 căn từ 17 dự án, tăng 47% theo quý</td><td>DKRA</td></tr>
<tr><td>Giao dịch quý 2/2026</td><td>2.793 căn, tăng 54%, hấp thụ khoảng 55%</td><td>DKRA</td></tr>
<tr><td>Giá sơ cấp quý 2/2026</td><td>Tăng khoảng 2% theo quý; giá thứ cấp giảm khoảng 6%</td><td>DKRA</td></tr>
</tbody>
</table>

<h2>Căn hộ: nguồn cung tăng mạnh, giá thiết lập mặt bằng mới</h2>
<p>Theo CBRE, trước năm 2024 Đà Nẵng chỉ có dưới 1.000 căn hộ mới mỗi năm, nhưng giai đoạn 2024–2025 đã có hơn 8.000 căn mở bán. Các chủ đầu tư lớn chuyển trọng tâm từ condotel sang căn hộ sở hữu lâu dài, kéo mặt bằng giá lên cao.</p>
<p>Dự án trung tâm, ven sông Hàn ghi nhận giá khoảng 130–200 triệu đồng/m² ở phân khúc hạng sang. Ngược lại, khu Nam Đà Nẵng như Hòa Xuân, Hòa Quý có nguồn cung mới với mức giá mềm hơn, ví dụ <a href="/du-an/fours-tower/">FourS Tower</a> và các tòa của Sun NeO City.</p>
<h3>Phân hóa sơ cấp và thứ cấp</h3>
<p>DKRA ghi nhận quý 2/2026 giá sơ cấp tăng nhẹ khoảng 2% nhưng giá thứ cấp giảm khoảng 6%. Điều này cho thấy một bộ phận nhà đầu tư chấp nhận giảm kỳ vọng lợi nhuận khi chi phí vốn cao, nên người mua để ở có thêm cơ hội thương lượng ở thị trường thứ cấp.</p>

<h2>Đất nền: phục hồi chậm, phân hóa theo khu vực</h2>
<p>Trong quý 1/2026, giá sơ cấp đất nền tăng nhẹ khoảng 2% theo quý và 7% so với cùng kỳ, trong khi giá thứ cấp tăng mạnh hơn ở một số khu vực. Tuy vậy, nhiều đánh giá cho rằng sau giai đoạn tăng nóng, biên độ tăng giá đất năm 2026 sẽ chậm lại.</p>
<p>Đất nền gắn với khu đô thị có hạ tầng hoàn chỉnh, pháp lý rõ ràng vẫn được quan tâm, đặc biệt khu Nam Hòa Xuân. Anh chị xem các lô đang chào bán tại <a href="/mua-ban/dat-nen/">mua bán đất nền Đà Nẵng</a>.</p>

<h2>Hạ tầng và sáp nhập: động lực trung – dài hạn</h2>
<p>Sau khi hợp nhất với Quảng Nam, Đà Nẵng có không gian phát triển rộng hơn, cùng các dự án như Trung tâm tài chính quốc tế, Khu thương mại tự do, cảng Liên Chiểu và mở rộng sân bay. Phân tích chi tiết từng công trình có trong bài <a href="/toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san/">toàn cảnh hạ tầng Đà Nẵng 2026</a>.</p>
<p>Hạ tầng là động lực dài hạn, nhưng tác động lên giá thường diễn ra theo tiến độ thực tế. Người mua nên ưu tiên dự án gần công trình đã khởi công hơn là chỉ dựa vào quy hoạch.</p>

<h2>Xu hướng đáng chú ý cuối 2026</h2>
<ul>
<li>Căn hộ hạng A và B chiếm khoảng 88% nguồn cung, 93% giao dịch sơ cấp (DKRA quý 2/2026).</li>
<li>Chính sách thanh toán giãn, hỗ trợ lãi suất trở thành công cụ bán hàng phổ biến.</li>
<li>Nhu cầu thuê căn hộ từ khách quốc tế, chuyên gia tăng, hỗ trợ phân khúc Studio – 1PN.</li>
<li>Nghỉ dưỡng, condotel vẫn trầm lắng so với căn hộ để ở.</li>
</ul>

<h2>Gợi ý cho người mua</h2>
<p>Mua để ở nên so sánh giá thứ cấp với sơ cấp trong cùng khu vực. Mua để đầu tư nên tính kỹ chi phí vốn, khả năng cho thuê và tiến độ hạ tầng. Danh mục đầy đủ xem tại <a href="/du-an/">dự án bất động sản Đà Nẵng</a> và <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận phân tích giá theo khu vực và danh sách dự án phù hợp với kế hoạch của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Bất động sản Đà Nẵng 2026: giá, nguồn cung, xu hướng',
			'desc'      => 'Bất động sản Đà Nẵng 2026: giá căn hộ sơ cấp khoảng 83 triệu/m², giao dịch quý 2 tăng 54%, đất nền chậm lại. Gọi 0904 567 009 để được tư vấn.',
			'points'    => array( 'Giá căn hộ sơ cấp trung bình khoảng 83 triệu/m² (CBRE quý 1/2026)', 'Quý 2/2026: khoảng 2.793 căn giao dịch, tăng 54% (DKRA)', 'Đất nền phục hồi chậm, biên độ tăng giá được dự báo thu hẹp' ),
			'faq'       => array(
				array( 'Giá căn hộ Đà Nẵng 2026 khoảng bao nhiêu?', 'Theo CBRE, giá sơ cấp trung bình khoảng 83 triệu đồng/m² trong quý 1/2026; dự án hạng sang ven sông Hàn khoảng 130–200 triệu/m².' ),
				array( 'Thị trường căn hộ Đà Nẵng quý 2/2026 thế nào?', 'DKRA ghi nhận khoảng 5.090 căn sơ cấp, 2.793 căn giao dịch (tăng 54%), giá sơ cấp tăng khoảng 2% trong khi thứ cấp giảm khoảng 6%.' ),
				array( 'Đất nền Đà Nẵng 2026 có còn tăng giá?', 'Đất nền phục hồi chậm và phân hóa; nhiều đánh giá cho rằng biên độ tăng sẽ chậm lại sau giai đoạn tăng nóng 2024–2025.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnam.vn/en/cbre-viet-nam-ba-diem-nhan-cua-thi-truong-can-ho-da-nang-2026',
			'https://nguoiquansat.vn/dkra-giao-dich-can-ho-da-nang-tang-54-nhung-thi-truong-van-chua-phuc-hoi-dong-deu-307850.html',
			'https://nhipsongnhadat.vn/mxh/can-ho-da-nang-chuyen-sang-cao-cap-gia-trung-binh-83-trieu-dong-m2.html',
			'https://vnbusiness.vn/bat-dong-san-da-nang-lech-pha-trong-quy-12026-dat-nen-nong-len-nghi-duong-dong-bang.html',
		),
	);

	$posts[] = array(
		'slug'     => 'ky-gui-can-ho-da-nang-ban-cho-thue',
		'title'    => 'Ký gửi căn hộ Đà Nẵng: quy trình bán, cho thuê, giấy tờ và lưu ý',
		'excerpt'  => 'Ký gửi căn hộ Đà Nẵng để bán hoặc cho thuê: quy trình 5 bước, giấy tờ cần chuẩn bị, cách định giá và các lưu ý khi ký hợp đồng ký gửi.',
		'keyword'  => 'ký gửi căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 1,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Ký gửi căn hộ Đà Nẵng là việc chủ nhà ủy thác cho người môi giới tìm khách mua hoặc khách thuê, kèm thỏa thuận về giá, phí và thời hạn. Để ký gửi hiệu quả, anh chị cần chuẩn bị đủ giấy tờ, định giá sát thị trường và thống nhất bằng văn bản ngay từ đầu (cập nhật tháng 10/2026).</p>

<h2>Khi nào nên ký gửi căn hộ Đà Nẵng?</h2>
<p>Ký gửi phù hợp khi anh chị không ở Đà Nẵng thường xuyên, không có thời gian dẫn khách hoặc muốn tiếp cận nhiều khách hơn. Với căn hộ cho thuê, ký gửi còn giúp giảm thời gian trống phòng nhờ có người theo dõi nhu cầu thuê liên tục.</p>

<h2>Quy trình ký gửi 5 bước</h2>
<table>
<thead><tr><th>Bước</th><th>Ký gửi bán</th><th>Ký gửi cho thuê</th></tr></thead>
<tbody>
<tr><td>1. Tiếp nhận</td><td>Thông tin căn, giá mong muốn</td><td>Thông tin căn, giá thuê, thời hạn</td></tr>
<tr><td>2. Kiểm tra</td><td>Giấy tờ sở hữu, tình trạng căn</td><td>Nội thất, thiết bị, quy định tòa nhà</td></tr>
<tr><td>3. Định giá</td><td>So sánh căn tương tự đã giao dịch</td><td>So sánh giá thuê cùng tòa, cùng khu vực</td></tr>
<tr><td>4. Tiếp thị</td><td>Ảnh, video, đăng tin, dẫn khách</td><td>Ảnh, video, kết nối khách thuê</td></tr>
<tr><td>5. Giao dịch</td><td>Đặt cọc, công chứng, sang tên</td><td>Ký hợp đồng thuê, bàn giao, thu cọc</td></tr>
</tbody>
</table>

<h2>Giấy tờ cần chuẩn bị</h2>
<h3>Khi ký gửi bán</h3>
<ul>
<li>Giấy chứng nhận quyền sở hữu, hoặc hợp đồng mua bán với chủ đầu tư nếu căn chưa có sổ.</li>
<li>CCCD của chủ sở hữu; giấy tờ về tình trạng hôn nhân nếu là tài sản chung.</li>
<li>Xác nhận tình trạng thế chấp nếu căn đang vay ngân hàng.</li>
<li>Biên lai đã thanh toán với chủ đầu tư (với căn chưa có sổ).</li>
</ul>
<h3>Khi ký gửi cho thuê</h3>
<ul>
<li>Giấy tờ chứng minh quyền sở hữu hoặc quyền cho thuê.</li>
<li>Danh sách nội thất, thiết bị, chỉ số điện nước khi bàn giao.</li>
<li>Quy định của ban quản lý tòa nhà về cho thuê, đăng ký tạm trú.</li>
</ul>

<h2>Định giá: bước quyết định tốc độ giao dịch</h2>
<p>Căn hộ đặt giá quá cao thường nằm lâu trên thị trường, sau đó phải giảm sâu. Cách làm hợp lý là so sánh với các căn cùng tòa, cùng diện tích, cùng hướng đã giao dịch gần đây, rồi điều chỉnh theo tầng, view và nội thất.</p>
<p>Với cho thuê, cần tính cả mùa du lịch: căn hộ gần biển, gần sân bay thường có nhu cầu thuê ngắn hạn cao hơn vào mùa hè và dịp lễ hội. Tham khảo thêm bài <a href="/thi-truong-bat-dong-san-da-nang-2026/">thị trường bất động sản Đà Nẵng 2026</a> để nắm mặt bằng giá chung.</p>

<h2>Lưu ý khi ký hợp đồng ký gửi</h2>
<ul>
<li><strong>Phí môi giới:</strong> ghi rõ mức phí, thời điểm thanh toán và điều kiện được hưởng. Trên thị trường, phí bán thường tính theo phần trăm giá trị giao dịch, phí cho thuê thường tính theo số tháng tiền thuê; mức cụ thể do hai bên thỏa thuận.</li>
<li><strong>Thời hạn và độc quyền:</strong> ký gửi độc quyền hay không, kéo dài bao lâu, điều kiện chấm dứt.</li>
<li><strong>Giữ chìa khóa:</strong> ai giữ, dẫn khách theo lịch nào, có báo trước cho chủ nhà không.</li>
<li><strong>Tiền cọc của khách:</strong> chuyển trực tiếp cho chủ nhà hay qua môi giới, có văn bản xác nhận.</li>
<li><strong>Báo cáo:</strong> tần suất cập nhật số khách xem, phản hồi về giá.</li>
</ul>

<h2>Chủ nhà ở xa cần lưu ý gì?</h2>
<p>Nếu không ở Đà Nẵng, anh chị nên thống nhất cách nhận báo cáo định kỳ, cách xác nhận khách đặt cọc và cách ký giấy tờ (ủy quyền công chứng hoặc ra ký trực tiếp). Tiền cọc, tiền thuê nên chuyển thẳng vào tài khoản chủ nhà để minh bạch.</p>

<h2>Mẹo giúp căn hộ ký gửi nhanh có khách</h2>
<p>Dọn dẹp, sửa các lỗi nhỏ và chụp ảnh vào giờ có ánh sáng tự nhiên giúp tin đăng nổi bật hơn. Với căn cho thuê, nội thất cơ bản đầy đủ và giá điện nước minh bạch là điều khách quan tâm nhất.</p>
<p>Anh chị có thể xem các căn đang chào bán tại <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư Đà Nẵng</a> và căn cho thuê tại <a href="/cho-thue/">cho thuê bất động sản Đà Nẵng</a> để tham khảo cách trình bày tin.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để ký gửi bán hoặc cho thuê căn hộ của anh chị và nhận đánh giá giá sát thị trường.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Ký gửi căn hộ Đà Nẵng: quy trình, giấy tờ, lưu ý',
			'desc'      => 'Ký gửi căn hộ Đà Nẵng để bán hoặc cho thuê: quy trình 5 bước, giấy tờ cần có, cách định giá. Gọi 0904 567 009 để ký gửi ngay.',
			'points'    => array( 'Quy trình 5 bước: tiếp nhận, kiểm tra, định giá, tiếp thị, giao dịch', 'Chuẩn bị giấy tờ sở hữu, tình trạng thế chấp, danh sách nội thất', 'Thống nhất phí, thời hạn, quyền giữ chìa khóa bằng văn bản' ),
			'faq'       => array(
				array( 'Căn hộ chưa có sổ có ký gửi bán được không?', 'Có thể, qua hình thức chuyển nhượng hợp đồng mua bán với chủ đầu tư; cần hợp đồng, biên lai thanh toán và thủ tục theo quy định của chủ đầu tư.' ),
				array( 'Phí ký gửi căn hộ Đà Nẵng là bao nhiêu?', 'Phí do hai bên thỏa thuận; thường bán tính theo phần trăm giá trị giao dịch, cho thuê tính theo số tháng tiền thuê. Nên ghi rõ trong hợp đồng.' ),
				array( 'Có nên ký gửi độc quyền?', 'Độc quyền giúp môi giới đầu tư tiếp thị nhiều hơn, nhưng nên giới hạn thời hạn và ghi rõ điều kiện chấm dứt.' ),
			),
		),
		'sources'  => array(),
	);

	/* ================= TUẦN 2 – FourS Tower ================= */

	$posts[] = array(
		'slug'     => 'fours-tower-da-nang-tong-quan-4-thap-bon-mua',
		'title'    => 'FourS Tower Đà Nẵng: tổng quan 4 tháp Bốn Mùa Mai, Trúc, Cúc, Tùng',
		'excerpt'  => 'FourS Tower Đà Nẵng là phân khu căn hộ đầu tiên của Sun Riverpolis: 4 tháp 20 tầng, khoảng 2.291 căn Studio – 3PN, sở hữu lâu dài tại Hòa Quý.',
		'keyword'  => 'FourS Tower Đà Nẵng',
		'project'  => 'fours-tower',
		'week'     => 2,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>FourS Tower Đà Nẵng (Tháp Bốn Mùa) là phân khu căn hộ cao tầng đầu tiên của khu đô thị Sun Riverpolis do Sun Property (Sun Group) phát triển, gồm 4 tháp Mai – Trúc – Cúc – Tùng cao 20 tầng, khoảng 2.291 căn từ Studio đến 3 phòng ngủ, sở hữu lâu dài. Dự án ra mắt ngày 19/3/2026 tại ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Nam Đà Nẵng (cập nhật tháng 10/2026).</p>

<h2>Thông tin chính FourS Tower Đà Nẵng</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư / phát triển</td><td>Tập đoàn Sun Group (Sun Property phát triển)</td></tr>
<tr><td>Vị trí</td><td>Ngã tư Nguyễn Phước Lan – Minh Mạng, Hòa Quý (cũ), Ngũ Hành Sơn</td></tr>
<tr><td>Thuộc</td><td>Khu đô thị sinh thái Sun Riverpolis</td></tr>
<tr><td>Quy mô</td><td>4 tòa, 20 tầng nổi, 2 tầng hầm</td></tr>
<tr><td>Số căn</td><td>Khoảng 2.291 căn hộ</td></tr>
<tr><td>Loại căn</td><td>Studio, 1PN, 2PN, 3PN (một số nguồn nêu thêm 1PN+, 2PN+, duplex)</td></tr>
<tr><td>Sở hữu</td><td>Lâu dài</td></tr>
<tr><td>Ra mắt</td><td>19/3/2026</td></tr>
</tbody>
</table>

<h2>Ý tưởng "Bốn Mùa": 4 tháp Mai, Trúc, Cúc, Tùng</h2>
<p>Bốn tòa tháp được đặt tên theo bộ tranh tứ bình truyền thống, mỗi loài cây gắn với một mùa trong năm. Tên gọi FourS (Four Seasons) xuất phát từ ý tưởng này.</p>
<table>
<thead><tr><th>Mã tòa</th><th>Tên tháp</th><th>Mùa</th></tr></thead>
<tbody>
<tr><td>F2</td><td>Tháp Mai</td><td>Mùa Xuân</td></tr>
<tr><td>F3</td><td>Tháp Trúc</td><td>Mùa Hạ</td></tr>
<tr><td>F1</td><td>Tháp Tùng</td><td>Mùa Đông</td></tr>
<tr><td>F5</td><td>Tháp Cúc</td><td>Mùa Thu</td></tr>
</tbody>
</table>
<p>Dự án không dùng số 4 khi đặt mã tòa, vì vậy tòa thứ tư là F5 (Tháp Cúc): bốn tòa gồm F1 Tùng, F2 Mai, F3 Trúc và F5 Cúc. Theo báo chí, Tháp Mùa Xuân F2 là tòa thứ ba được giới thiệu trong bộ sưu tập.</p>

<h2>Vị trí và kết nối</h2>
<p>FourS Tower nằm ở trung tâm Sun Riverpolis, khu vực được bao quanh bởi sông nước ở phía Nam Đà Nẵng. Từ dự án có thể kết nối cầu Hòa Xuân, cầu Đồng Nò 2 và các trục giao thông chính đến biển Sơn Thủy, Ngũ Hành Sơn, Hội An.</p>
<p>Khu vực này hưởng lợi từ cụm hạ tầng phía Nam, phân tích chi tiết trong bài <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao cầu Hòa Xuân và bất động sản Nam Đà Nẵng</a>.</p>

<h2>Tiện ích nội khu</h2>
<p>Theo thông tin dự án, toàn bộ tầng 2 được dành cho tiện ích theo phong cách nghỉ dưỡng, tầng 1 bố trí thương mại. Các tiện ích được giới thiệu gồm:</p>
<ul>
<li>Hồ bơi bốn mùa.</li>
<li>Gym, yoga, spa.</li>
<li>Khu vui chơi trẻ em và không gian sinh hoạt cộng đồng.</li>
<li>Phòng khám Mặt Trời.</li>
</ul>
<p>Dự án còn có dòng căn hộ sân vườn với không gian xanh riêng, được báo chí giới thiệu là phù hợp gia đình nhiều thế hệ và chuyên gia nước ngoài.</p>

<h2>FourS Tower trong hệ sinh thái Sun Riverpolis</h2>
<p>Sun Riverpolis là khu đô thị sinh thái của Sun Group tại Hòa Quý, cùng Sun NeO City (Hòa Xuân) tạo thành hệ sinh thái hơn 1.000 ha ở phía Nam Đà Nẵng. Bên cạnh FourS Tower, Sun Riverpolis còn có phân khu đất nền và biệt thự view sông Đầm Sen, mở bán từ tháng 8/2025.</p>
<p>Việc có cả căn hộ, đất nền và biệt thự trong cùng một khu giúp hình thành cộng đồng cư dân đa dạng. Tuy vậy, đây vẫn là khu đô thị đang hình thành, tiện ích ngoại khu như trường học, chợ, bệnh viện cần thời gian để hoàn thiện. Anh chị xem thêm phân khu đất tại trang <a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">đất nền Đầm Sen</a>.</p>

<h2>Ưu điểm và điểm cần cân nhắc</h2>
<table>
<thead><tr><th>Ưu điểm</th><th>Điểm cần cân nhắc</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư lớn, sở hữu lâu dài</td><td>Khu vực đang phát triển, tiện ích ngoại khu chưa hoàn chỉnh</td></tr>
<tr><td>Nhiều loại căn, dải giá rộng</td><td>Quy mô khoảng 2.291 căn, cạnh tranh khi cho thuê</td></tr>
<tr><td>Tiện ích nghỉ dưỡng ngay trong tòa</td><td>Giá và chính sách thay đổi theo từng đợt</td></tr>
<tr><td>Kết nối Hội An, biển Sơn Thủy</td><td>Cần theo dõi tiến độ từng tòa</td></tr>
</tbody>
</table>

<h2>FourS Tower phù hợp với ai?</h2>
<p>Studio và 1PN phù hợp người trẻ, cặp vợ chồng mới cưới hoặc nhà đầu tư cho thuê. Căn 2PN và 3PN hướng đến gia đình cần không gian ở lâu dài tại Nam Đà Nẵng. Giá tham khảo từng loại căn xem trong bài <a href="/gia-fours-tower-2026/">giá FourS Tower 2026</a>, layout xem tại <a href="/mat-bang-fours-tower-studio-3pn/">mặt bằng FourS Tower</a>.</p>
<p>Thông tin đầy đủ của dự án có tại trang <a href="/du-an/fours-tower/">FourS Tower (Tháp Bốn Mùa)</a> và trang tổ hợp <a href="/du-an/sun-riverpolis/">Sun Riverpolis Nam Hòa Xuân</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận tài liệu FourS Tower, bảng giá đợt hiện hành và lịch tham quan nhà mẫu.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'FourS Tower Đà Nẵng: tổng quan 4 tháp Bốn Mùa',
			'desc'      => 'FourS Tower Đà Nẵng: 4 tháp Mai, Trúc, Cúc, Tùng 20 tầng, khoảng 2.291 căn Studio – 3PN sở hữu lâu dài. Gọi 0904 567 009 nhận tài liệu.',
			'points'    => array( 'Phân khu căn hộ đầu tiên của Sun Riverpolis, ra mắt 19/3/2026', '4 tòa 20 tầng, 2 hầm, khoảng 2.291 căn Studio – 3PN', 'Tiện ích nghỉ dưỡng tập trung tại tầng 2' ),
			'faq'       => array(
				array( 'FourS Tower Đà Nẵng nằm ở đâu?', 'Tại ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn, trong khu đô thị Sun Riverpolis.' ),
				array( 'FourS Tower có bao nhiêu căn hộ?', 'Khoảng 2.291 căn trong 4 tòa 20 tầng, từ Studio đến 3 phòng ngủ.' ),
				array( 'Căn hộ FourS Tower sở hữu bao lâu?', 'Theo thông tin công bố, căn hộ FourS Tower sở hữu lâu dài.' ),
				array( 'Ai là chủ đầu tư FourS Tower?', 'Dự án thuộc Tập đoàn Sun Group, do Sun Property phát triển.' ),
			),
		),
		'sources'  => array(
			'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm',
			'https://vnexpress.net/sun-group-ra-mat-khu-can-ho-fours-tower-tai-nam-da-nang-5052323.html',
			'https://vietnamnet.vn/thap-mua-xuan-fours-tower-chuan-muc-an-cu-da-the-he-tai-nam-trung-tam-da-nang-2555685.html',
		),
	);

	$posts[] = array(
		'slug'     => 'gia-fours-tower-2026',
		'title'    => 'Giá FourS Tower 2026: bảng giá tham khảo theo từng loại căn',
		'excerpt'  => 'Giá FourS Tower 2026 tham khảo: Studio từ khoảng 1,7 tỷ, 1PN+ từ khoảng 2,6 tỷ, 2PN từ khoảng 3,6 tỷ. Giá chính thức thay đổi theo từng đợt.',
		'keyword'  => 'giá FourS Tower',
		'project'  => 'fours-tower',
		'week'     => 2,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Giá FourS Tower 2026 theo các nguồn phân phối công khai: căn Studio từ khoảng 1,7 tỷ đồng, 1PN+ từ khoảng 2,6 tỷ đồng, 2PN từ khoảng 3,6 tỷ đồng (tham khảo). Đơn giá được rao ở khoảng 52–59 triệu đồng/m² cho đợt đầu; giá chính thức do Sun Property công bố theo từng tòa, từng đợt và có thể thay đổi (cập nhật tháng 10/2026).</p>

<h2>Bảng giá FourS Tower tham khảo theo loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích tham khảo</th><th>Giá từ (tham khảo)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 34,7 m²</td><td>Khoảng 1,7 tỷ</td></tr>
<tr><td>1PN</td><td>Khoảng 43,7 m²</td><td>Đang cập nhật theo đợt</td></tr>
<tr><td>1PN+</td><td>Khoảng 45,5 – 48,9 m²</td><td>Khoảng 2,6 tỷ</td></tr>
<tr><td>2PN</td><td>Khoảng 58 m²</td><td>Khoảng 3,6 tỷ</td></tr>
<tr><td>2PN+ / 3PN</td><td>Khoảng 87,1 m² / 102,8 m²</td><td>Đang cập nhật, liên hệ để nhận bảng giá</td></tr>
</tbody>
</table>
<p>Số liệu tổng hợp từ trang phân phối và tin rao, chưa phải bảng giá chính thức của chủ đầu tư. Giá thực tế phụ thuộc tòa, tầng, hướng, view và phương án thanh toán.</p>

<h2>Đơn giá giá FourS Tower theo m²</h2>
<p>Khi mở bán đợt đầu (tòa F1 và F5), một số trang phân phối nêu đơn giá khoảng 52–59 triệu đồng/m². Có nguồn khác ghi khoảng 35,8–59 triệu đồng/m² đã gồm VAT và phí bảo trì, khả năng là sau khi trừ chiết khấu tối đa.</p>
<p>Để so sánh, CBRE ghi nhận giá căn hộ sơ cấp trung bình toàn Đà Nẵng khoảng 83 triệu đồng/m² trong quý 1/2026. Như vậy FourS Tower nằm ở nhóm giá mềm hơn mặt bằng chung, phù hợp với vị trí khu Nam Đà Nẵng. Xem thêm bài <a href="/thi-truong-bat-dong-san-da-nang-2026/">thị trường bất động sản Đà Nẵng 2026</a>.</p>

<h2>Yếu tố ảnh hưởng đến giá từng căn</h2>
<h3>Tòa và đợt mở bán</h3>
<p>Mỗi tòa được giới thiệu theo đợt riêng (F1, F5, sau đó F2 Tháp Mùa Xuân). Đợt sau có thể có giá và chính sách khác đợt trước. Điểm khác biệt của F2 được phân tích trong bài <a href="/fours-tower-f2-thap-mai-mua-xuan/">FourS Tower F2 – Tháp Mai</a>.</p>
<h3>Tầng, hướng và view</h3>
<p>Căn tầng cao, view sông hoặc hướng mát thường có giá cao hơn căn tầng thấp, view nội khu. Căn sân vườn là dòng sản phẩm đặc biệt, giá thường được báo riêng.</p>
<h3>Phương án thanh toán</h3>
<p>Mức chiết khấu khác nhau giữa thanh toán chuẩn, thanh toán sớm hay vay ngân hàng, nên cùng một căn có thể có nhiều mức giá sau chiết khấu. Chi tiết xem bài <a href="/chinh-sach-fours-tower-thanh-toan-vay-ngan-hang/">chính sách FourS Tower</a>.</p>

<h2>Tổng chi phí cần tính khi mua</h2>
<ul>
<li>Giá căn sau chiết khấu (đã hoặc chưa gồm VAT, cần hỏi rõ).</li>
<li>Kinh phí bảo trì theo quy định.</li>
<li>Lãi vay nếu dùng đòn bẩy, sau thời gian hỗ trợ lãi suất.</li>
<li>Chi phí nội thất nếu bàn giao cơ bản.</li>
</ul>

<h2>Giá FourS Tower phù hợp với ai?</h2>
<p>Với mức "giá từ" khoảng 1,7 tỷ cho Studio, FourS Tower nằm trong tầm với của người mua căn hộ đầu tiên và nhà đầu tư cá nhân có vốn vừa phải. Căn 2PN từ khoảng 3,6 tỷ phù hợp gia đình trẻ muốn ở lâu dài tại khu Nam Đà Nẵng thay vì trung tâm có đơn giá cao hơn.</p>
<p>Người mua để cho thuê nên tính kỹ: quy mô khoảng 2.291 căn đồng nghĩa nguồn cung cho thuê trong cùng khu khá lớn khi bàn giao đồng loạt. Chọn căn có view, tầng và layout tốt sẽ giúp nổi bật hơn khi khai thác.</p>
<h3>So với mặt bằng căn hộ Đà Nẵng</h3>
<p>Khu ven sông Hàn, trung tâm Hải Châu có nhiều dự án giá cao hơn đáng kể. Nếu anh chị cần so sánh, xem danh sách tại <a href="/loai-du-an/cao-tang/">căn hộ Đà Nẵng</a> để đặt FourS Tower cạnh các lựa chọn cùng tầm tiền.</p>

<h2>Cách nhận bảng giá chính xác</h2>
<p>Bảng giá FourS Tower được chủ đầu tư phát hành theo từng đợt, kèm quỹ căn còn lại. Hiệp gửi bảng giá bằng văn bản, kèm bảng tính tổng tiền theo phương án anh chị chọn để so sánh công bằng. Thông tin dự án xem tại trang <a href="/du-an/fours-tower/">FourS Tower Đà Nẵng</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá FourS Tower đợt hiện hành và danh sách căn còn trống theo ngân sách.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá FourS Tower 2026: bảng giá theo loại căn',
			'desc'      => 'Giá FourS Tower 2026 tham khảo: Studio từ khoảng 1,7 tỷ, 2PN từ khoảng 3,6 tỷ. Gọi 0904 567 009 để nhận bảng giá chính thức đợt hiện hành.',
			'points'    => array( 'Studio từ khoảng 1,7 tỷ, 1PN+ khoảng 2,6 tỷ, 2PN khoảng 3,6 tỷ (tham khảo)', 'Đơn giá đợt đầu được rao khoảng 52–59 triệu/m²', 'Giá thay đổi theo tòa, tầng, view và phương án thanh toán' ),
			'faq'       => array(
				array( 'Giá FourS Tower bao nhiêu một căn?', 'Theo nguồn phân phối, Studio từ khoảng 1,7 tỷ, 1PN+ từ khoảng 2,6 tỷ, 2PN từ khoảng 3,6 tỷ (tham khảo, thay đổi theo đợt).' ),
				array( 'Giá FourS Tower bao nhiêu một m²?', 'Đợt đầu được rao khoảng 52–59 triệu đồng/m²; giá sau chiết khấu thấp hơn tùy phương án thanh toán.' ),
				array( 'Giá căn 3PN FourS Tower là bao nhiêu?', 'Chưa có số liệu công khai đáng tin cậy; giá đang cập nhật theo đợt, liên hệ để nhận bảng giá.' ),
			),
		),
		'sources'  => array(
			'https://fourstowersungroup.vn/gia-ban/',
			'https://cafef.vn/loi-the-mua-can-ho-tang-resort-truyen-doi-cua-f2-fours-tower-nam-da-nang-188260916110117254.chn',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-fours-tower-21005',
		),
	);

	$posts[] = array(
		'slug'     => 'mat-bang-fours-tower-studio-3pn',
		'title'    => 'Mặt bằng FourS Tower: layout căn Studio đến 3PN và diện tích',
		'excerpt'  => 'Mặt bằng FourS Tower: căn Studio khoảng 34,7 m², 1PN 43,7 m², 2PN 58 m², 3PN 102,8 m². Phân tích layout từng loại căn và cách chọn.',
		'keyword'  => 'mặt bằng FourS Tower',
		'project'  => 'fours-tower',
		'week'     => 2,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Mặt bằng FourS Tower gồm các loại căn Studio (khoảng 34,7 m²), 1PN (khoảng 43,7 m²), 1PN+ (khoảng 45,5 – 48,9 m²), 2PN (khoảng 58 m²), 2PN+ (khoảng 87,1 m²) và 3PN (khoảng 102,8 m²), bố trí trong 4 tòa 20 tầng. Tầng 1 dành cho thương mại, tầng 2 cho tiện ích, các tầng phía trên là căn hộ (cập nhật tháng 10/2026).</p>

<h2>Tổng quan mặt bằng FourS Tower</h2>
<p>Dự án gồm 4 tòa Mai – Trúc – Cúc – Tùng, mỗi tòa 20 tầng nổi và 2 tầng hầm, tổng khoảng 2.291 căn. Theo thông tin giới thiệu, cư dân đi thang máy là kết nối được với khu thương mại tầng 1 và tiện ích nghỉ dưỡng tầng 2.</p>
<table>
<thead><tr><th>Tầng</th><th>Công năng</th></tr></thead>
<tbody>
<tr><td>Hầm B1–B2</td><td>Đỗ xe, kỹ thuật</td></tr>
<tr><td>Tầng 1</td><td>Thương mại, sảnh</td></tr>
<tr><td>Tầng 2</td><td>Tiện ích: hồ bơi bốn mùa, gym, yoga, spa, khu trẻ em, phòng khám</td></tr>
<tr><td>Tầng 3 trở lên</td><td>Căn hộ Studio – 3PN, căn sân vườn</td></tr>
</tbody>
</table>
<p>Bố trí chi tiết từng tầng và số căn mỗi sàn khác nhau giữa các tòa; anh chị nên xem mặt bằng tầng chính thức của tòa đang mở bán.</p>

<h2>Diện tích các loại căn</h2>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích tham khảo</th><th>Phù hợp</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 34,7 m²</td><td>Người độc thân, cho thuê</td></tr>
<tr><td>1PN</td><td>Khoảng 43,7 m²</td><td>Cặp đôi, cho thuê dài hạn</td></tr>
<tr><td>1PN+</td><td>Khoảng 45,5 – 48,9 m²</td><td>Cặp đôi cần phòng làm việc</td></tr>
<tr><td>2PN</td><td>Khoảng 58 m²</td><td>Gia đình trẻ</td></tr>
<tr><td>2PN+</td><td>Khoảng 87,1 m²</td><td>Gia đình 4–5 người</td></tr>
<tr><td>3PN</td><td>Khoảng 102,8 m²</td><td>Gia đình nhiều thế hệ</td></tr>
</tbody>
</table>
<p>Diện tích tổng hợp từ trang phân phối, có thể khác giữa các tòa. Một số nguồn còn nêu căn duplex khoảng 200 m² ở tầng cao.</p>

<h2>Phân tích layout từng loại căn</h2>
<h3>Studio</h3>
<p>Studio gộp ngủ, sinh hoạt và bếp trong một không gian, phù hợp cho thuê. Theo một số trang phân phối, Studio tại FourS Tower được thiết kế bề ngang rộng, giúp đặt giường và sofa thoải mái hơn studio dạng hộp dài.</p>
<h3>1PN và 1PN+</h3>
<p>Căn 1PN tách phòng ngủ riêng, phòng khách liền bếp. Bản 1PN+ có thêm một góc nhỏ có thể làm phòng làm việc, phòng trẻ nhỏ hoặc phòng khách, phù hợp làm việc tại nhà.</p>
<h3>2PN và 2PN+</h3>
<p>Căn 2PN khoảng 58 m² là lựa chọn phổ biến cho gia đình trẻ. Bản 2PN+ rộng hơn đáng kể, thêm không gian linh hoạt cho gia đình đông người.</p>
<h3>3PN và căn sân vườn</h3>
<p>Căn 3PN khoảng 102,8 m² hướng đến gia đình nhiều thế hệ. Dòng căn sân vườn có khoảng xanh riêng, được báo chí giới thiệu như điểm nhấn của dự án.</p>

<h2>Chọn loại căn theo mục đích</h2>
<table>
<thead><tr><th>Mục đích</th><th>Loại căn gợi ý</th><th>Lý do</th></tr></thead>
<tbody>
<tr><td>Cho thuê ngắn hạn</td><td>Studio, 1PN</td><td>Vốn thấp, dễ trang bị nội thất, phù hợp khách du lịch</td></tr>
<tr><td>Cho thuê dài hạn chuyên gia</td><td>1PN+, 2PN</td><td>Có không gian làm việc, phù hợp người ở vài tháng đến vài năm</td></tr>
<tr><td>Gia đình trẻ ở thực</td><td>2PN, 2PN+</td><td>Đủ phòng cho con nhỏ, chi phí hợp lý</td></tr>
<tr><td>Gia đình nhiều thế hệ</td><td>3PN, căn sân vườn</td><td>Không gian rộng, có khoảng xanh riêng</td></tr>
</tbody>
</table>
<p>Báo chí cho biết dự án hướng đến cả cộng đồng chuyên gia nước ngoài đến làm việc tại Đà Nẵng. Nếu mua để cho thuê nhóm khách này, căn 1PN+ và 2PN có bố trí bàn làm việc riêng thường dễ khai thác hơn studio.</p>

<h2>Mẹo đọc mặt bằng khi chọn căn</h2>
<ul>
<li>Xem căn ở góc hay giữa sàn: căn góc thường có nhiều mặt thoáng hơn.</li>
<li>Kiểm tra hướng logia, vị trí máy lạnh, máy giặt.</li>
<li>Chú ý khoảng cách đến thang máy, phòng rác.</li>
<li>Diện tích thông thủy và tim tường khác nhau, cần hỏi rõ.</li>
</ul>
<p>Khi nhận bản vẽ, anh chị nên đối chiếu mặt bằng căn với mặt bằng tầng để biết căn nằm ở vị trí nào, nhìn ra hướng nào và có bị che khuất bởi tòa bên cạnh hay không.</p>
<p>Giá tham khảo từng loại căn xem tại bài <a href="/gia-fours-tower-2026/">giá FourS Tower 2026</a>, tổng quan dự án tại <a href="/fours-tower-da-nang-tong-quan-4-thap-bon-mua/">FourS Tower Đà Nẵng: 4 tháp Bốn Mùa</a> và trang <a href="/du-an/fours-tower/">dự án FourS Tower</a>. Anh chị cũng có thể so sánh với các dự án khác tại <a href="/loai-du-an/can-ho-so-huu-lau-dai/">căn hộ sở hữu lâu dài</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận mặt bằng tầng chính thức và danh sách căn còn trống theo loại căn anh chị quan tâm.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mặt bằng FourS Tower: layout Studio – 3PN',
			'desc'      => 'Mặt bằng FourS Tower: Studio khoảng 34,7 m², 2PN 58 m², 3PN 102,8 m². Phân tích layout và cách chọn căn. Gọi 0904 567 009 nhận mặt bằng tầng.',
			'points'    => array( 'Studio khoảng 34,7 m² đến 3PN khoảng 102,8 m²', 'Tầng 1 thương mại, tầng 2 tiện ích, căn hộ từ tầng 3', 'Có dòng căn sân vườn và căn 1PN+, 2PN+ linh hoạt' ),
			'faq'       => array(
				array( 'Căn Studio FourS Tower rộng bao nhiêu?', 'Khoảng 34,7 m² theo các trang phân phối; diện tích có thể khác giữa các tòa.' ),
				array( 'FourS Tower có căn 3 phòng ngủ không?', 'Có, căn 3PN diện tích khoảng 102,8 m², phù hợp gia đình nhiều thế hệ.' ),
				array( 'Tiện ích FourS Tower nằm ở tầng nào?', 'Theo thông tin dự án, tiện ích bố trí tại tầng 2, tầng 1 dành cho thương mại.' ),
			),
		),
		'sources'  => array(
			'https://iqivietnam.com.vn/du-an/fours-tower',
			'https://vnexpress.net/loi-the-can-ho-san-vuon-fours-tower-tai-nam-da-nang-5069319.html',
			'https://tuoitre.vn/bon-thap-can-ho-thuoc-du-an-sun-group-nam-da-nang-ra-mat-20260319112111814.htm',
		),
	);

	$posts[] = array(
		'slug'     => 'chinh-sach-fours-tower-thanh-toan-vay-ngan-hang',
		'title'    => 'Chính sách FourS Tower: thanh toán, chiết khấu và vay ngân hàng',
		'excerpt'  => 'Chính sách FourS Tower được công bố: thanh toán 70% nhận nhà, giãn phần còn lại, chiết khấu Early Bird 5%, hỗ trợ vay 70% với lãi suất 0% có thời hạn.',
		'keyword'  => 'chính sách FourS Tower',
		'project'  => 'fours-tower',
		'week'     => 2,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Chính sách FourS Tower theo các thông tin đã công bố gồm: thanh toán 70% để nhận nhà, 30% còn lại giãn đến khoảng 24 tháng sau bàn giao (tổng thời gian thanh toán có thể đến khoảng 4 năm), chiết khấu Early Bird 5% cho khách giữ chỗ sớm, và hỗ trợ vay đến 70% giá trị căn với lãi suất 0% trong thời gian nhất định. Chính sách thay đổi theo từng đợt, anh chị cần đối chiếu văn bản chính thức (cập nhật tháng 10/2026).</p>

<h2>Tóm tắt chính sách FourS Tower</h2>
<table>
<thead><tr><th>Nội dung</th><th>Thông tin được công bố / rao bán</th></tr></thead>
<tbody>
<tr><td>Thanh toán nhận nhà</td><td>70% giá trị để nhận nhà (chính sách Sun Early Key)</td></tr>
<tr><td>Phần còn lại</td><td>30% giãn đến khoảng 24 tháng sau bàn giao</td></tr>
<tr><td>Chiết khấu Early Bird</td><td>5% cho khách giữ chỗ sớm</td></tr>
<tr><td>Hỗ trợ vay</td><td>Vay đến 70%, hỗ trợ lãi suất 0% đến khoảng 30 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ</td></tr>
<tr><td>Phí giữ chỗ F2</td><td>Khoảng 50 triệu đồng/căn (theo báo chí khi ra mắt F2)</td></tr>
</tbody>
</table>

<h2>Phương án thanh toán</h2>
<h3>Thanh toán 70% nhận nhà</h3>
<p>Đây là điểm được nhắc nhiều nhất trong chính sách FourS Tower. Khách thanh toán 70% theo tiến độ là có thể nhận bàn giao và khai thác căn hộ, phần 30% còn lại giãn sau bàn giao. Phương án này giảm áp lực tài chính cho người mua để ở và cho thuê.</p>
<h3>Thanh toán sớm</h3>
<p>Khách thanh toán sớm phần lớn giá trị thường được hưởng chiết khấu cao hơn. Một số tin rao của đại lý nêu tổng ưu đãi có thể lên đến khoảng 27,5% khi thanh toán 95%, khoảng 19% khi thanh toán 70%; đây là thông tin từ tin rao, cần đối chiếu với chính sách bằng văn bản của đợt hiện hành.</p>

<h2>Chiết khấu</h2>
<p>Ngoài Early Bird 5%, chủ đầu tư thường có các khoản chiết khấu theo phương án thanh toán và ưu đãi theo từng sự kiện mở bán. Mức chiết khấu cụ thể, thời hạn áp dụng và điều kiện cộng dồn chỉ chính xác khi có văn bản chính sách đi kèm bảng giá.</p>
<p>Khi so sánh, anh chị nên quy về "giá sau chiết khấu, đã gồm VAT và phí bảo trì" để tránh nhầm lẫn giữa các phương án. Giá tham khảo xem bài <a href="/gia-fours-tower-2026/">giá FourS Tower 2026</a>.</p>

<h2>Vay ngân hàng</h2>
<p>Chương trình được rao bán là hỗ trợ vay đến 70% giá trị căn, lãi suất 0% và ân hạn gốc trong khoảng 30 tháng, miễn phí trả nợ trước hạn trong thời gian hỗ trợ. Sau giai đoạn này, lãi suất thả nổi theo ngân hàng.</p>
<h3>Những điểm cần hỏi kỹ khi vay</h3>
<ul>
<li>Ngân hàng nào tham gia, lãi suất thả nổi tính theo công thức nào.</li>
<li>Thời gian hỗ trợ lãi suất tính từ khi giải ngân hay từ khi ký hợp đồng.</li>
<li>Nếu chọn vay thì mức chiết khấu có thấp hơn phương án tự thanh toán không.</li>
<li>Khả năng trả nợ hàng tháng sau khi hết hỗ trợ.</li>
</ul>

<h2>Ví dụ minh họa dòng tiền</h2>
<p>Giả sử một căn có giá sau chiết khấu là 2 tỷ đồng (số liệu minh họa, không phải giá căn cụ thể). Với phương án 70% nhận nhà, dòng tiền chia như sau:</p>
<table>
<thead><tr><th>Giai đoạn</th><th>Tỷ lệ</th><th>Số tiền minh họa</th></tr></thead>
<tbody>
<tr><td>Trước khi nhận nhà (theo tiến độ)</td><td>70%</td><td>1,4 tỷ đồng</td></tr>
<tr><td>Sau bàn giao (giãn đến khoảng 24 tháng)</td><td>30%</td><td>0,6 tỷ đồng</td></tr>
<tr><td>Tổng</td><td>100%</td><td>2 tỷ đồng</td></tr>
</tbody>
</table>
<p>Nếu dùng vay ngân hàng trong phần 70%, số vốn tự có trước nhận nhà sẽ thấp hơn, đổi lại phải tính lãi sau thời gian hỗ trợ. Hiệp sẽ thay số theo căn thực tế và lịch thanh toán chính thức.</p>

<h2>Gợi ý chọn phương án</h2>
<p>Người mua để ở với vốn tự có vừa phải có thể cân nhắc phương án 70% nhận nhà hoặc vay có hỗ trợ lãi suất. Nhà đầu tư có vốn sẵn có thể so sánh phương án thanh toán sớm để tối đa chiết khấu. Hiệp sẽ lập bảng so sánh dòng tiền cho từng phương án để anh chị chọn.</p>
<p>Thông tin dự án xem tại trang <a href="/du-an/fours-tower/">FourS Tower Đà Nẵng</a>; quy trình đặt cọc, ký hợp đồng xem bài <a href="/quy-trinh-mua-can-ho-hoang-hiep-da-nang/">quy trình mua căn hộ 6 bước</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận văn bản chính sách FourS Tower đợt hiện hành và bảng so sánh dòng tiền theo từng phương án.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chính sách FourS Tower: thanh toán, vay ngân hàng',
			'desc'      => 'Chính sách FourS Tower: thanh toán 70% nhận nhà, Early Bird 5%, hỗ trợ vay 70% lãi suất 0% có thời hạn. Gọi 0904 567 009 nhận chính sách đợt mới.',
			'points'    => array( 'Thanh toán 70% nhận nhà, 30% giãn đến khoảng 24 tháng sau bàn giao', 'Chiết khấu Early Bird 5%, ưu đãi cao hơn khi thanh toán sớm', 'Hỗ trợ vay đến 70%, lãi suất 0% đến khoảng 30 tháng' ),
			'faq'       => array(
				array( 'Mua FourS Tower cần thanh toán bao nhiêu để nhận nhà?', 'Theo chính sách được công bố, khách thanh toán 70% là nhận nhà, 30% còn lại giãn sau bàn giao.' ),
				array( 'FourS Tower có hỗ trợ vay ngân hàng không?', 'Có, chương trình được rao là vay đến 70%, hỗ trợ lãi suất 0% và ân hạn gốc khoảng 30 tháng; cần đối chiếu văn bản chính thức.' ),
				array( 'Chiết khấu FourS Tower tối đa bao nhiêu?', 'Early Bird 5% được báo chí nêu; mức tổng ưu đãi cao hơn trong tin rao phụ thuộc phương án thanh toán và từng đợt, cần xem văn bản chính sách.' ),
			),
		),
		'sources'  => array(
			'https://cafef.vn/loi-the-mua-can-ho-tang-resort-truyen-doi-cua-f2-fours-tower-nam-da-nang-188260916110117254.chn',
			'https://www.sggp.org.vn/sun-property-mang-mua-xuan-den-som-voi-du-an-fours-tower-tai-nam-trung-tam-da-nang-post873838.html',
			'https://nhadatfptdanang.com/can-ho-fours-da-nang/',
		),
	);

	$posts[] = array(
		'slug'     => 'fours-tower-f2-thap-mai-mua-xuan',
		'title'    => 'FourS Tower F2 Tháp Mai – Mùa Xuân có gì khác 3 tháp còn lại?',
		'excerpt'  => 'FourS Tower F2 (Tháp Mai – Mùa Xuân) ra mắt ngày 26/9 với 1.369 lượt đặt chỗ, định hướng an cư đa thế hệ và căn hộ sân vườn. So sánh với F1, F3, Tháp Cúc.',
		'keyword'  => 'FourS Tower F2',
		'project'  => 'fours-tower',
		'week'     => 2,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>FourS Tower F2 là Tháp Mai – Mùa Xuân, tòa thứ ba được Sun Property giới thiệu trong bộ sưu tập Bốn Mùa, ra mắt sáng 26/9/2026 tại Royal Lotus Đà Nẵng với 1.369 lượt đặt chỗ thành công (gần 1.400 theo VnExpress). Điểm khác của F2 nằm ở định hướng an cư đa thế hệ, cảm hứng hoa mai và cách truyền thông "mua căn hộ, tặng resort truyền đời" (cập nhật tháng 10/2026).</p>

<h2>FourS Tower F2 trong bộ sưu tập Bốn Mùa</h2>
<table>
<thead><tr><th>Tháp</th><th>Mùa</th><th>Thời điểm giới thiệu (theo nguồn công khai)</th></tr></thead>
<tbody>
<tr><td>F1 – Tháp Tùng</td><td>Đông</td><td>Đợt đầu (từ 3/2026)</td></tr>
<tr><td>F5 – Tháp Cúc</td><td>Thu</td><td>Đợt đầu (từ 3/2026)</td></tr>
<tr><td>F2 – Tháp Mai</td><td>Xuân</td><td>Sự kiện 26/9/2026, tòa thứ ba</td></tr>
<tr><td>F3 – Tháp Trúc</td><td>Hạ</td><td>Chưa có thông tin mở bán công khai</td></tr>
</tbody>
</table>
<p>Mã tòa và thứ tự được tổng hợp từ báo chí và trang phân phối, có chỗ chưa thống nhất. Anh chị nên đối chiếu với tài liệu bán hàng chính thức.</p>

<h2>Kết quả ra mắt FourS Tower F2</h2>
<p>Theo VnExpress, sự kiện giới thiệu Tháp Mùa Xuân ghi nhận 1.369 lượt đặt chỗ thành công. Báo chí cũng đưa tin phí giữ chỗ F2 khoảng 50 triệu đồng/căn, giúp người mua chủ động dòng tiền ở giai đoạn đầu.</p>
<p>Lượt đặt chỗ là chỉ số quan tâm, chưa phải số căn đã ký hợp đồng mua bán. Đây là thông tin tham khảo về sức hút, không phải cam kết về thanh khoản hay giá bán lại.</p>

<h2>F2 có gì khác 3 tháp còn lại?</h2>
<h3>Định hướng an cư đa thế hệ</h3>
<p>Truyền thông về Tháp Mùa Xuân nhấn mạnh việc đáp ứng nhu cầu của mọi thành viên trong gia đình. Cơ cấu sản phẩm vẫn từ Studio đến 3PN, nhưng thông điệp hướng nhiều hơn đến gia đình ở thực so với đợt đầu.</p>
<h3>Cảm hứng hoa mai và "khởi đầu mới"</h3>
<p>Kiến trúc F2 lấy cảm hứng từ hoa mai, biểu tượng mùa xuân, khởi đầu và may mắn. Đây là khác biệt về ý tưởng thiết kế và nhận diện, còn hệ tiện ích dùng chung toàn khu.</p>
<h3>"Resort truyền đời" và căn hộ sân vườn</h3>
<p>F2 được giới thiệu với khái niệm căn hộ sở hữu lâu dài đi kèm trải nghiệm nghỉ dưỡng ngay dưới chân nhà: toàn bộ tầng 2 dành cho tiện ích, tầng 1 là thương mại. Dòng căn sân vườn với khoảng xanh riêng tiếp tục được nhấn mạnh.</p>
<h3>Chính sách theo đợt</h3>
<p>Mỗi tòa có bảng giá và chính sách riêng theo thời điểm. Các chính sách được nêu cho F2 gồm Early Bird 5% và Sun Early Key (thanh toán 70% nhận nhà). Chi tiết xem bài <a href="/chinh-sach-fours-tower-thanh-toan-vay-ngan-hang/">chính sách FourS Tower</a> và <a href="/gia-fours-tower-2026/">giá FourS Tower 2026</a>.</p>

<h2>Điểm giống nhau giữa các tháp</h2>
<ul>
<li>Cùng vị trí ngã tư Nguyễn Phước Lan – Minh Mạng, trong Sun Riverpolis.</li>
<li>Cùng quy mô 20 tầng nổi, 2 tầng hầm.</li>
<li>Cùng hình thức sở hữu lâu dài và chủ đầu tư Sun Group.</li>
<li>Dùng chung hệ tiện ích và kết nối hạ tầng khu Nam Đà Nẵng.</li>
</ul>

<h2>Lưu ý khi đặt chỗ FourS Tower F2</h2>
<ul>
<li>Phí giữ chỗ chuyển vào tài khoản của chủ đầu tư hoặc đơn vị phân phối chính thức, có phiếu xác nhận.</li>
<li>Hỏi rõ điều kiện hoàn tiền nếu không chọn được căn mong muốn trong ngày ráp căn.</li>
<li>Chuẩn bị trước 2–3 căn ưu tiên theo tầng, hướng, loại căn để không bị động.</li>
<li>Đọc kỹ bảng giá, chính sách đi kèm vì có thể khác đợt mở bán trước.</li>
</ul>
<p>Với lượng đặt chỗ lớn như sự kiện ngày 26/9, các căn tầng đẹp, view sông thường được chọn sớm. Việc chuẩn bị danh sách căn ưu tiên giúp anh chị có lựa chọn tốt hơn.</p>

<h2>Nên chọn F2 hay tòa khác?</h2>
<p>Nếu ưu tiên chọn căn đẹp ở đợt mới với chính sách hiện hành, F2 là lựa chọn đáng xem. Nếu cần nhận nhà sớm hơn, anh chị nên so sánh tiến độ dự kiến của tòa đợt đầu với F2. Tổng quan cả 4 tháp có trong bài <a href="/fours-tower-da-nang-tong-quan-4-thap-bon-mua/">FourS Tower Đà Nẵng: 4 tháp Bốn Mùa</a>; F2 chưa có trang riêng, thông tin chung xem tại <a href="/du-an/fours-tower/">dự án FourS Tower</a>.</p>

<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá, quỹ căn FourS Tower F2 và so sánh với các tòa còn lại.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'FourS Tower F2 Tháp Mai: khác gì 3 tháp còn lại?',
			'desc'      => 'FourS Tower F2 – Tháp Mai Mùa Xuân ra mắt 26/9 với 1.369 lượt đặt chỗ, định hướng an cư đa thế hệ. Gọi 0904 567 009 nhận bảng giá F2.',
			'points'    => array( 'F2 là Tháp Mai – Mùa Xuân, tòa thứ ba được giới thiệu', 'Ra mắt 26/9/2026 với 1.369 lượt đặt chỗ thành công', 'Định hướng an cư đa thế hệ, căn hộ sân vườn, tiện ích tầng 2' ),
			'faq'       => array(
				array( 'FourS Tower F2 là tháp nào?', 'F2 là Tháp Mai – Mùa Xuân, một trong 4 tháp Mai, Trúc, Cúc, Tùng của FourS Tower.' ),
				array( 'F2 ra mắt có bao nhiêu lượt đặt chỗ?', 'Theo VnExpress, sự kiện ngày 26/9 ghi nhận 1.369 lượt đặt chỗ thành công.' ),
				array( 'Phí giữ chỗ FourS Tower F2 là bao nhiêu?', 'Báo chí đưa tin khoảng 50 triệu đồng/căn; anh chị nên xác nhận lại theo văn bản của đợt mở bán.' ),
				array( 'Giá F2 có khác các tòa trước?', 'Mỗi tòa có bảng giá riêng theo đợt; giá F2 đang cập nhật, liên hệ để nhận bảng giá chính thức.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/thap-f2-fours-tower-ghi-nhan-gan-1-400-luot-dat-cho-5125919.html',
			'https://vietnamnet.vn/thap-mua-xuan-fours-tower-chuan-muc-an-cu-da-the-he-tai-nam-trung-tam-da-nang-2555685.html',
			'https://cafef.vn/loi-the-mua-can-ho-tang-resort-truyen-doi-cua-f2-fours-tower-nam-da-nang-188260916110117254.chn',
			'https://www.sggp.org.vn/sun-property-mang-mua-xuan-den-som-voi-du-an-fours-tower-tai-nam-trung-tam-da-nang-post873838.html',
		),
	);

	return $posts;
}
