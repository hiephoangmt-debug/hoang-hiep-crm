<?php
/**
 * Tin hạ tầng: đề xuất cầu mới qua sông Hàn (Sở Xây dựng Đà Nẵng, 11/9/2026) và kế hoạch đầu tư công trung hạn 2026–2030.
 * Nạp qua filter hh_news_posts với 'status' => 'draft': nút Dự án → Nhập dữ liệu Đà Nẵng tạo BẢN NHÁP để anh Hiệp duyệt,
 * không tự đăng. Chỉ ghi điều đã kiểm chứng được qua báo chí; số vốn, vị trí, nghị quyết riêng cho cây cầu chưa có
 * nguồn xác nhận nên bài ghi rõ là "chưa công bố/chưa xác minh".
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_cau_song_han' );
function hh_posts_cau_song_han( $posts ) {
	$posts[] = array(
		'slug'      => 'da-nang-de-xuat-xay-cau-moi-qua-song-han',
		'title'     => 'Đà Nẵng đề xuất xây cầu mới qua sông Hàn, khởi công trước năm 2030',
		'excerpt'   => 'Sở Xây dựng Đà Nẵng đề xuất nghiên cứu một cây cầu mới qua sông Hàn, phấn đấu khởi công trước năm 2030 để giảm tải 5 trục Đông – Tây. Đề xuất đang ở giai đoạn nghiên cứu: vị trí, quy mô và vốn chưa được công bố chính thức.',
		'keyword'   => 'cầu mới qua sông Hàn',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'status'    => 'draft',
		'date'      => '2026-10-09 08:00:00',
		'image'     => 'plugin:img/tin-tuc/de-xuat-cau-moi-qua-song-han-so-do.jpg',
		'image_alt' => 'Sơ đồ minh hoạ 5 cầu qua sông Hàn và vị trí đề xuất cầu mới, Đà Nẵng',
		'content'   => <<<'HTML'
<p>Đà Nẵng đang tính đến một <strong>cầu mới qua sông Hàn</strong>. Tại buổi làm việc với Bí thư Thành ủy Lê Ngọc Quang ngày 11/9/2026, Sở Xây dựng thành phố đề xuất nghiên cứu xây thêm một cây cầu nối hai bờ Hải Châu – Sơn Trà, phấn đấu khởi công trước năm 2030. Lý do được nêu là các trục giao thông Đông – Tây hiện hữu, nhất là những tuyến đi qua cầu Sông Hàn, cầu Rồng và cầu Trần Thị Lý, đang quá tải vào giờ cao điểm.</p>
<p>Cần nói rõ ngay từ đầu: đây là <strong>đề xuất của cơ quan chuyên môn</strong>, chưa phải dự án đã được phê duyệt chủ trương đầu tư. Bài viết dưới đây tách bạch những gì đã có nguồn chính thức, những gì còn chờ công bố, và người đang quan tâm <a href="/bat-dong-san-hai-chau-2026/">bất động sản Hải Châu</a>, <a href="/bat-dong-san-son-tra-2026/">Sơn Trà</a> nên đọc thông tin này thế nào.</p>

<h2>Đề xuất cầu mới qua sông Hàn: những gì đã được xác nhận</h2>
<p>Theo Tuổi Trẻ (đăng ngày 11/9/2026), Sở Xây dựng Đà Nẵng đề xuất nghiên cứu thêm một cây cầu qua sông Hàn, với mục tiêu khởi công trước năm 2030. Thông tin then chốt có thể tóm lại như sau:</p>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Cơ quan đề xuất</td><td>Sở Xây dựng TP Đà Nẵng</td><td>Đã có nguồn báo chí</td></tr>
<tr><td>Thời điểm, bối cảnh</td><td>Buổi làm việc với Bí thư Thành ủy Lê Ngọc Quang, ngày 11/9/2026</td><td>Đã có nguồn báo chí</td></tr>
<tr><td>Mục tiêu tiến độ</td><td>Phấn đấu khởi công trước năm 2030</td><td>Là mục tiêu đề xuất, chưa phải quyết định</td></tr>
<tr><td>Lý do</td><td>Giảm tải 5 trục giao thông Đông – Tây đi qua sông Hàn</td><td>Đã có nguồn báo chí</td></tr>
<tr><td>Vị trí cầu</td><td>Báo chí nhắc đến khu vực cuối đường Đống Đa – nơi từng nghiên cứu phương án hầm vượt sông</td><td>Chưa có quyết định chọn vị trí</td></tr>
<tr><td>Quy mô, tổng mức đầu tư, nguồn vốn</td><td>Chưa công bố chính thức</td><td>Sẽ cập nhật khi có văn bản</td></tr>
<tr><td>Chủ trương đầu tư</td><td>Chưa thấy văn bản phê duyệt</td><td>Chưa phê duyệt</td></tr>
</tbody>
</table>

<h2>Vì sao Đà Nẵng cần thêm một cây cầu qua sông Hàn?</h2>
<p>Sông Hàn chia trung tâm Đà Nẵng thành hai nửa: bờ Tây là quận trung tâm cũ Hải Châu với khu hành chính, thương mại; bờ Đông là Sơn Trà với dải biển Mỹ Khê, khu khách sạn, căn hộ du lịch. Mọi dòng người đi làm, đi học, du khách di chuyển giữa hai bờ đều phải dồn qua các cây cầu. Theo Sở Xây dựng, giao thông Đông – Tây hiện tập trung trên 5 trục chính:</p>
<ol>
<li><strong>Nguyễn Tất Thành – cầu Thuận Phước</strong> (phía Bắc, gần cửa sông).</li>
<li><strong>Lê Duẩn – cầu Sông Hàn</strong> (cầu quay biểu tượng, khánh thành năm 2000).</li>
<li><strong>Nguyễn Văn Linh – cầu Rồng</strong>.</li>
<li><strong>Duy Tân – cầu Trần Thị Lý</strong>.</li>
<li><strong>Xô Viết Nghệ Tĩnh – cầu Tiên Sơn</strong> (phía Nam).</li>
</ol>
<p>Trong đó, ba trục ở giữa (Lê Duẩn, Nguyễn Văn Linh, Duy Tân) gánh lưu lượng lớn nhất, gây ùn ứ tại các nút giao đầu cầu vào giờ cao điểm. Khoảng cách giữa cầu Thuận Phước và cầu Sông Hàn khá xa, khiến người dân khu vực phía Bắc Hải Châu phải vòng xuống các cầu trung tâm. Một cây cầu mới ở đoạn này – nếu được chọn – sẽ chia bớt dòng xe, rút ngắn quãng đường giữa phía Bắc Hải Châu và phía Bắc Sơn Trà.</p>
<p>Cùng buổi làm việc, Sở Xây dựng cũng nêu hướng nghiên cứu một số tuyến đường trên cao để tăng năng lực giao thông đô thị. Các phương án này đều ở mức nghiên cứu sơ bộ.</p>

<h2>Cầu mới qua sông Hàn sẽ nằm ở đâu?</h2>
<p>Đây là câu hỏi nhiều người quan tâm nhất, nhưng hiện <strong>chưa có vị trí chính thức</strong>. Bài báo nhắc đến khu vực cuối đường Đống Đa (phường Hải Châu), nơi trước đây từng được nghiên cứu cho phương án hầm chui qua sông Hàn. Một số thông tin cần biết về lịch sử khu vực này:</p>
<ul>
<li><strong>Phương án hầm chui:</strong> được đưa ra từ khoảng năm 2016, dài hơn 1.300 m, nối khu vực Đống Đa – Trần Phú (Hải Châu) sang Vân Đồn – Trần Hưng Đạo (Sơn Trà). Theo báo Đại biểu Nhân dân, hầm được đưa vào quy hoạch thời kỳ 2021–2030, tầm nhìn 2050, với giai đoạn đầu tư dự kiến <strong>sau năm 2030</strong>.</li>
<li><strong>Cuộc thi ý tưởng cầu:</strong> thành phố từng tổ chức thi thiết kế cho một công trình vượt sông ở vị trí nút Đống Đa – Như Nguyệt (bờ Tây) sang Vân Đồn – Lê Văn Duyệt – Trần Hưng Đạo (bờ Đông). Các phương án dự thi có mức kinh phí ước tính khác nhau theo từng kiểu kết cấu. Đây là số liệu của cuộc thi trước đây, <strong>không phải tổng mức đầu tư của đề xuất 2026</strong>.</li>
</ul>
<p>Vì vậy, nếu thấy thông tin "cầu ở Đống Đa, vốn X tỷ, khởi công năm Y" lan truyền trên mạng xã hội, anh chị nên đối chiếu với văn bản của UBND, HĐND thành phố trước khi tin.</p>

<h2>Liên quan gì đến kế hoạch đầu tư công trung hạn 2026–2030?</h2>
<p>Ngày 6/10/2026, HĐND TP Đà Nẵng khóa XI khai mạc kỳ họp thứ 6 (chuyên đề) và thông qua 22 nghị quyết, trong đó có nghị quyết <strong>điều chỉnh, bổ sung kế hoạch vốn đầu tư công trung hạn giai đoạn 2026–2030</strong>. Trước đó, kế hoạch đầu tư công trung hạn 2026–2030 của thành phố được duyệt với tổng vốn ngân sách địa phương hơn 138.800 tỷ đồng (theo Báo Đầu tư).</p>
<p>Một số thông tin đang lan truyền cho rằng đợt điều chỉnh này bổ sung khoảng 500 tỷ đồng cho cầu mới qua sông Hàn, với tổng mức đầu tư khoảng 2.300 tỷ đồng. <strong>Hoàng Hiệp chưa tìm được văn bản hoặc bài báo chính thức xác nhận các con số này</strong> – kể cả số hiệu nghị quyết, danh mục dự án kèm theo và nguồn vốn cụ thể. Khi HĐND/UBND công bố danh mục chi tiết, bài viết sẽ được cập nhật.</p>
<p>Điều có thể nói chắc: một công trình cầu vượt sông lớn ở khu trung tâm muốn khởi công trước 2030 thì cần được đưa vào kế hoạch đầu tư công trung hạn và được phê duyệt chủ trương đầu tư trong giai đoạn 2026–2030. Theo dõi các kỳ họp HĐND thành phố là cách nhanh nhất để biết đề xuất này có thành dự án hay không.</p>

<h2>Từ đề xuất đến khởi công: còn những bước nào?</h2>
<p>Với công trình giao thông dùng vốn đầu tư công, quy trình thường gồm:</p>
<ol>
<li><strong>Nghiên cứu, đề xuất</strong> – giai đoạn hiện tại theo thông tin báo chí.</li>
<li><strong>Lập báo cáo đề xuất chủ trương đầu tư</strong>, xác định sơ bộ vị trí, quy mô, tổng mức đầu tư, nguồn vốn.</li>
<li><strong>Bố trí vào kế hoạch đầu tư công trung hạn</strong> và được HĐND thành phố quyết định chủ trương đầu tư (với dự án nhóm A, B tùy quy mô).</li>
<li><strong>Lập báo cáo nghiên cứu khả thi</strong>, đánh giá tác động môi trường, phê duyệt dự án.</li>
<li><strong>Thiết kế, giải phóng mặt bằng, lựa chọn nhà thầu</strong>, rồi mới khởi công.</li>
</ol>
<p>Mỗi bước đều có thể làm thay đổi vị trí, kết cấu hoặc thời gian. Mốc "trước năm 2030" vì thế nên được hiểu là mục tiêu, chưa phải cam kết.</p>

<h2>Hạ tầng giao thông Đà Nẵng: bức tranh rộng hơn</h2>
<p>Đề xuất cầu mới qua sông Hàn nằm trong làn sóng đầu tư hạ tầng giao thông Đà Nẵng sau khi hợp nhất với Quảng Nam. Thành phố đang triển khai <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao và cầu Hòa Xuân</a> ở phía Nam, mở rộng nhà ga sân bay, phát triển <a href="/trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san/">trung tâm tài chính quốc tế</a> ở khu vực ven sông, cửa sông. Xem tổng quan tại bài <a href="/toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san/">toàn cảnh hạ tầng Đà Nẵng 2026</a>.</p>
<p>Nhìn chung, quy hoạch Đà Nẵng ưu tiên kết nối hai bờ sông Hàn và mở rộng không gian đô thị về phía Bắc (cửa sông, Thuận Phước) và phía Nam (Hòa Xuân, Ngũ Hành Sơn). Một cây cầu mới ở đoạn phía Bắc trung tâm, nếu thành hiện thực, sẽ ăn khớp với định hướng đó.</p>

<h2>Bất động sản Đà Nẵng: đọc tin cầu mới thế nào cho đúng?</h2>
<p>Kinh nghiệm từ các cây cầu trước đây (cầu Rồng, cầu Trần Thị Lý, cầu Tiên Sơn) cho thấy hạ tầng vượt sông giúp các khu vực đầu cầu thuận tiện hơn, dễ kinh doanh, cho thuê hơn về dài hạn. Tuy vậy, với một đề xuất mới ở giai đoạn nghiên cứu, anh chị nên lưu ý:</p>
<ul>
<li><strong>Chưa có vị trí, chưa có "đầu cầu":</strong> mọi lời chào bán "đất ngay chân cầu mới" lúc này đều dựa trên phỏng đoán. Hỏi người bán văn bản nào xác định vị trí.</li>
<li><strong>Kiểm tra quy hoạch trước khi xuống tiền:</strong> lô đất nằm trong phạm vi nút giao, đường dẫn lên cầu có thể bị thu hồi một phần. Xem hướng dẫn <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</li>
<li><strong>Thời gian là rủi ro chính:</strong> từ đề xuất đến khi cầu thông xe thường mất nhiều năm. Ưu tiên tài sản tự đứng được bằng giá trị sử dụng hiện tại (ở thật, cho thuê được), coi hạ tầng là điểm cộng thêm.</li>
<li><strong>Căn hộ ven sông Hàn đã có sẵn tiện ích:</strong> các dự án đã bàn giao như <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>, <a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a> đang có giao dịch chuyển nhượng, cho thuê; xem thêm <a href="/can-ho-view-song-han-du-an-va-gia/">căn hộ view sông Hàn và giá tham khảo</a>.</li>
</ul>
<p>Giá bất động sản Đà Nẵng ở hai bờ sông Hàn đã phản ánh vị trí trung tâm; tin về cầu mới không nên là lý do duy nhất để mua. Anh chị có thể xem các dự án theo khu vực <a href="/khu-vuc/hai-chau/">Hải Châu</a> và <a href="/khu-vuc/son-tra/">Sơn Trà</a> để so sánh.</p>

<h2>Những điểm Hoàng Hiệp sẽ tiếp tục theo dõi</h2>
<ul>
<li>Văn bản chính thức của UBND/HĐND thành phố về chủ trương đầu tư cầu mới qua sông Hàn.</li>
<li>Danh mục dự án trong nghị quyết điều chỉnh kế hoạch đầu tư công trung hạn 2026–2030 (kỳ họp HĐND ngày 6/10/2026).</li>
<li>Vị trí, quy mô, tổng mức đầu tư và nguồn vốn được công bố.</li>
<li>Mốc lập báo cáo nghiên cứu khả thi, thiết kế và lựa chọn nhà thầu.</li>
</ul>
<p>Bài viết sẽ được cập nhật khi có thông tin chính thức. Anh chị cần tư vấn căn hộ, nhà phố hai bờ sông Hàn với pháp lý rõ ràng, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong>.</p>
<p><em>Ảnh: sơ đồ minh hoạ do hiephoangmt.com thực hiện dựa trên thông tin Sở Xây dựng Đà Nẵng nêu ngày 11/9/2026; không theo tỷ lệ, không phải phối cảnh chính thức của công trình.</em></p>
HTML,
		'seo'       => array(
			'seo_title' => 'Cầu mới qua sông Hàn: Đà Nẵng đề xuất khởi công trước 2030',
			'desc'      => 'Cầu mới qua sông Hàn được Sở Xây dựng Đà Nẵng đề xuất, phấn đấu khởi công trước năm 2030 để giảm tải 5 trục Đông – Tây. Điều đã xác nhận, điều còn chờ.',
			'points'    => array(
				'Sở Xây dựng Đà Nẵng đề xuất nghiên cứu cầu mới qua sông Hàn, phấn đấu khởi công trước năm 2030 (buổi làm việc 11/9/2026).',
				'Mục tiêu: giảm tải 5 trục Đông – Tây, nhất là Lê Duẩn, Nguyễn Văn Linh, Duy Tân.',
				'Vị trí, quy mô, tổng mức đầu tư và nguồn vốn chưa được công bố chính thức.',
				'HĐND thành phố đã thông qua điều chỉnh kế hoạch đầu tư công trung hạn 2026–2030 ngày 6/10/2026; chưa xác minh được khoản vốn riêng cho cây cầu.',
			),
			'faq'       => array(
				array( 'Cầu mới qua sông Hàn đã được phê duyệt chưa?', 'Chưa. Theo thông tin báo chí, đây là đề xuất của Sở Xây dựng Đà Nẵng tại buổi làm việc ngày 11/9/2026. Chưa thấy văn bản phê duyệt chủ trương đầu tư.' ),
				array( 'Cầu mới qua sông Hàn nằm ở đâu?', 'Chưa có vị trí chính thức. Báo chí nhắc đến khu vực cuối đường Đống Đa (Hải Châu) – nơi từng nghiên cứu phương án hầm vượt sông – nhưng vị trí cụ thể sẽ do bước lập chủ trương đầu tư xác định.' ),
				array( 'Khi nào cầu mới qua sông Hàn khởi công?', 'Sở Xây dựng đề xuất phấn đấu khởi công trước năm 2030. Đây là mục tiêu; tiến độ thực tế phụ thuộc vào phê duyệt chủ trương, bố trí vốn, thiết kế và giải phóng mặt bằng.' ),
				array( 'Cầu mới qua sông Hàn có tổng vốn bao nhiêu?', 'Chưa có con số chính thức. Các con số đang lan truyền (như 500 tỷ hay 2.300 tỷ đồng) chưa được xác minh qua văn bản của HĐND, UBND thành phố.' ),
				array( 'Có nên mua đất gần vị trí dự kiến làm cầu?', 'Nên thận trọng. Vị trí chưa chốt, đất trong phạm vi nút giao có thể bị thu hồi. Hãy kiểm tra quy hoạch và chọn tài sản có giá trị sử dụng thật, coi hạ tầng là điểm cộng.' ),
			),
		),
		'sources'   => array(
			'https://tuoitre.vn/de-xuat-khoi-cong-xay-them-mot-cau-qua-song-han-da-nang-truoc-nam-2030-10026091117310746.htm',
			'https://daibieunhandan.vn/ky-hop-thu-sau-hdnd-tp-da-nang-thong-qua-22-nghi-quyet-thao-go-diem-nghen-sau-hop-nhat-10432907.html',
			'https://baodautu.vn/da-nang-duyet-hon-138000-ty-dong-dau-tu-cong-trung-han-giai-doan-2026---2030-d679654.html',
			'https://daibieunhandan.vn/da-nang-ham-chui-qua-song-han-se-duoc-dau-tu-sau-nam-2030-post382459.html',
		),
	);
	return $posts;
}

/** Bài tin thời sự: schema NewsArticle thay cho BlogPosting mặc định của Rank Math. */
add_filter(
	'rank_math/json_ld',
	static function ( $data ) {
		if ( ! is_singular( 'post' ) || 'da-nang-de-xuat-xay-cau-moi-qua-song-han' !== get_post_field( 'post_name', get_queried_object_id() ) ) {
			return $data;
		}
		foreach ( $data as $key => $node ) {
			if ( is_array( $node ) && in_array( $node['@type'] ?? '', array( 'BlogPosting', 'Article' ), true ) ) {
				$data[ $key ]['@type'] = 'NewsArticle';
			}
		}
		return $data;
	},
	99
);
