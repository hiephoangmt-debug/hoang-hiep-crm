<?php
/**
 * Bài viết kế hoạch nội dung – tuần 11–12 (chuyển nhượng & cho thuê căn hộ; giá chuyển nhượng, cho thuê theo từng dự án căn hộ). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tuan_11_12' );
function hh_posts_tuan_11_12( $posts ) {
	/* ---------------------------------------------------------------- Tuần 11 */
	$posts[] = array(
		'slug'     => 'mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to',
		'title'    => 'Mua căn hộ chuyển nhượng Đà Nẵng: quy trình, giấy tờ và cách kiểm tra căn',
		'excerpt'  => 'Mua căn hộ chuyển nhượng Đà Nẵng: phân biệt căn đã có sổ và căn chuyển nhượng hợp đồng mua bán, quy trình 6 bước, giấy tờ cần có và checklist kiểm tra căn.',
		'keyword'  => 'mua căn hộ chuyển nhượng Đà Nẵng',
		'project'  => '',
		'week'     => 11,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p><strong>Mua căn hộ chuyển nhượng Đà Nẵng</strong> (mua lại từ chủ nhà, không mua trực tiếp từ chủ đầu tư) giúp anh chị chọn được căn cụ thể đã thấy tận mắt, nhiều căn đã bàn giao, có thể ở hoặc cho thuê ngay. Đổi lại, thủ tục và rủi ro khác hẳn mua dự án mới. Bài viết tóm tắt quy trình, giấy tờ cần có và cách kiểm tra căn trước khi đặt cọc, cập nhật tháng 10/2026.</p>

<h2>Hai dạng căn hộ chuyển nhượng phổ biến</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Căn đã có sổ hồng</th><th>Căn chuyển nhượng hợp đồng mua bán (HĐMB)</th></tr></thead>
<tbody>
<tr><td>Tình trạng</td><td>Chủ nhà đã được cấp giấy chứng nhận</td><td>Căn chưa có sổ, người bán đang giữ HĐMB ký với chủ đầu tư</td></tr>
<tr><td>Văn bản giao dịch</td><td>Hợp đồng mua bán căn hộ, công chứng</td><td>Văn bản chuyển nhượng hợp đồng, công chứng và chủ đầu tư xác nhận</td></tr>
<tr><td>Sau giao dịch</td><td>Đăng ký sang tên tại cơ quan đăng ký đất đai</td><td>Người mua tiếp tục quyền, nghĩa vụ với chủ đầu tư, chờ cấp sổ</td></tr>
<tr><td>Ví dụ ở Đà Nẵng</td><td>Hiyori Garden Tower (cư dân đã nhận sổ), tòa CT3 The Ori Garden</td><td>Các dự án đang bàn giao hoặc chưa cấp sổ</td></tr>
</tbody>
</table>
<p>Theo Luật Kinh doanh bất động sản 2023, hợp đồng mua bán nhà ở hình thành trong tương lai được phép chuyển nhượng khi chưa nộp hồ sơ đề nghị cấp giấy chứng nhận, hợp đồng không có tranh chấp, căn hộ không bị kê biên hoặc thế chấp (trừ khi bên nhận thế chấp đồng ý). Quy định chuyển nhượng hợp đồng này không áp dụng với nhà ở xã hội.</p>

<h2>Quy trình mua căn hộ chuyển nhượng 6 bước</h2>
<h3>Bước 1: Xác định ngân sách và tổng chi phí</h3>
<p>Ngoài giá căn, cần tính thuế, phí công chứng, lệ phí trước bạ, phí quản lý và chi phí sửa sang nội thất. Chi tiết từng khoản xem bài <a href="/thue-phi-mua-ban-nha-dat-da-nang-2026/">thuế, phí khi mua bán nhà đất Đà Nẵng 2026</a>. Nếu dùng vốn vay, nên làm việc với ngân hàng từ sớm vì căn chuyển nhượng HĐMB thường cần thêm thủ tục với chủ đầu tư.</p>
<h3>Bước 2: Kiểm tra pháp lý căn hộ</h3>
<p>Đối chiếu bản gốc sổ hồng hoặc HĐMB, phụ lục, các phiếu thu đã nộp cho chủ đầu tư. Hỏi rõ căn có đang thế chấp ngân hàng không và số tiền còn phải thanh toán.</p>
<h3>Bước 3: Xem căn thực tế</h3>
<p>Kiểm tra theo checklist ở phần dưới, nên xem vào hai khung giờ khác nhau để đánh giá nắng, gió và tiếng ồn.</p>
<h3>Bước 4: Đặt cọc</h3>
<p>Hợp đồng đặt cọc ghi rõ mã căn, diện tích, giá, tiến độ thanh toán, ai chịu khoản thuế phí nào, thời hạn công chứng và cách xử lý nếu một bên vi phạm.</p>
<h3>Bước 5: Công chứng và thanh toán</h3>
<p>Ký hợp đồng mua bán (căn có sổ) hoặc văn bản chuyển nhượng hợp đồng (căn chưa có sổ) tại tổ chức hành nghề công chứng. Với căn chưa có sổ, hồ sơ công chứng gồm bản chính văn bản chuyển nhượng và bản chính HĐMB đã ký lần đầu với chủ đầu tư; sau đó nộp chủ đầu tư xác nhận.</p>
<h3>Bước 6: Kê khai thuế, sang tên, bàn giao</h3>
<p>Nộp hồ sơ kê khai thuế, lệ phí; đăng ký biến động (căn có sổ). Khi nhận căn, lập biên bản bàn giao kèm chỉ số điện nước, thẻ cư dân, chìa khóa và xác nhận đã thanh toán phí quản lý đến ngày bàn giao.</p>

<h2>Giấy tờ cần chuẩn bị</h2>
<ul>
<li><strong>Bên bán:</strong> sổ hồng hoặc HĐMB bản chính cùng phụ lục, phiếu thu; căn cước; giấy tờ hôn nhân (đăng ký kết hôn hoặc xác nhận độc thân) – nếu là tài sản chung vợ chồng thì cả hai cùng ký.</li>
<li><strong>Bên mua:</strong> căn cước, giấy tờ tình trạng hôn nhân.</li>
<li><strong>Căn chưa có sổ:</strong> thêm văn bản xác nhận của chủ đầu tư về tình trạng căn và số tiền đã nộp; nếu đang thế chấp, cần văn bản đồng ý của ngân hàng.</li>
</ul>

<h2>Checklist kiểm tra căn trước khi đặt cọc</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Cần kiểm tra</th></tr></thead>
<tbody>
<tr><td>Diện tích</td><td>Diện tích thông thủy trên sổ/HĐMB khớp với căn thực tế</td></tr>
<tr><td>Hiện trạng</td><td>Thấm trần, tường, ban công; hệ thống điện, nước, điều hòa; cửa và khóa</td></tr>
<tr><td>View, hướng</td><td>Hướng ban công, tầm nhìn có bị công trình mới che chắn không</td></tr>
<tr><td>Chi phí vận hành</td><td>Phí quản lý, gửi xe, công nợ tồn đọng với ban quản lý</td></tr>
<tr><td>Hợp đồng thuê đang chạy</td><td>Nếu căn đang cho thuê: thời hạn, tiền cọc của khách, ai nhận tiếp hợp đồng</td></tr>
<tr><td>Quy định tòa nhà</td><td>Có cho phép lưu trú ngắn ngày, nuôi thú cưng, sửa chữa cải tạo không</td></tr>
</tbody>
</table>

<h2>Người nước ngoài mua căn hộ chuyển nhượng</h2>
<p>Theo Luật Nhà ở 2023, cá nhân nước ngoài được mua căn hộ trong dự án thương mại không thuộc khu vực hạn chế, thời hạn sở hữu tối đa 50 năm (có thể gia hạn) và trong giới hạn số căn được phép bán cho người nước ngoài mỗi tòa. Trước khi đặt cọc, cần hỏi chủ đầu tư căn đó còn nằm trong quota cho người nước ngoài hay không.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với căn chuyển nhượng HĐMB, rủi ro lớn nhất thường nằm ở khoản tiền còn nợ chủ đầu tư và tình trạng thế chấp, nên anh chị cần văn bản xác nhận của chủ đầu tư trước khi đặt cọc, không chỉ dựa vào lời người bán. Với căn đã có sổ, hãy dành thời gian kiểm tra hiện trạng và công nợ phí quản lý. Giá chuyển nhượng các dự án tham khảo tại bài <a href="/gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an/">giá chuyển nhượng căn hộ Đà Nẵng 2026</a>; kinh nghiệm chung xem thêm bài <a href="/kinh-nghiem-mua-can-ho-da-nang/">kinh nghiệm mua căn hộ Đà Nẵng</a>.</p>
<p>Xem căn đang giao dịch tại <a href="/mua-ban/can-ho-chung-cu/">mua bán căn hộ chung cư Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được kiểm tra pháp lý căn cụ thể và nhận danh sách căn chuyển nhượng đang bán thật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua căn hộ chuyển nhượng Đà Nẵng: quy trình, giấy tờ',
			'desc'      => 'Mua căn hộ chuyển nhượng Đà Nẵng: căn có sổ và căn chuyển nhượng HĐMB, quy trình 6 bước, giấy tờ, checklist kiểm tra căn. Gọi Hoàng Hiệp để được hỗ trợ.',
			'points'    => array(
				'Hai dạng: căn đã có sổ hồng và căn chuyển nhượng hợp đồng mua bán',
				'Chuyển nhượng HĐMB phải công chứng và được chủ đầu tư xác nhận',
				'Kiểm tra diện tích thông thủy, thế chấp, công nợ, hợp đồng thuê đang chạy',
			),
			'faq'       => array(
				array( 'Căn hộ chưa có sổ có mua chuyển nhượng được không?', 'Được, nếu chưa nộp hồ sơ đề nghị cấp giấy chứng nhận, hợp đồng không tranh chấp, căn không bị kê biên hoặc thế chấp (trừ khi bên nhận thế chấp đồng ý). Văn bản chuyển nhượng phải công chứng và được chủ đầu tư xác nhận.' ),
				array( 'Mua căn hộ chuyển nhượng cần giấy tờ gì?', 'Bên bán cần sổ hồng hoặc HĐMB bản chính, phiếu thu, căn cước, giấy tờ hôn nhân; bên mua cần căn cước và giấy tờ hôn nhân. Căn chưa có sổ cần thêm xác nhận của chủ đầu tư.' ),
				array( 'Có nên đặt cọc trước khi kiểm tra pháp lý?', 'Không nên. Hãy đối chiếu bản gốc giấy tờ, tình trạng thế chấp và số tiền còn nợ chủ đầu tư trước khi đặt cọc.' ),
				array( 'Người nước ngoài có mua căn hộ chuyển nhượng được không?', 'Được trong dự án thương mại không thuộc khu vực hạn chế, thời hạn sở hữu tối đa 50 năm và trong giới hạn số căn cho người nước ngoài của từng tòa.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat-nha-dat/hop-dong-mua-ban-nha-o-hinh-thanh-trong-tuong-lai-co-duoc-chuyen-nhuong-khong-10106.html',
			'https://thuviennhadat.vn/phap-ly-nha-dat/chuyen-nhuong-hop-dong-mua-ban-nha-o-hinh-thanh-trong-tuong-lai-theo-trinh-tu-thu-tuc-ho-so-the-nao-604740.html',
			'https://batdongsan.vtv.vn/news/viec-chuyen-nhuong-hop-dong-mua-ban-nha-o-hinh-thanh-trong-tuong-lai-se-nhu-the-nao',
		),
	);

	$posts[] = array(
		'slug'     => 'thue-phi-mua-ban-nha-dat-da-nang-2026',
		'title'    => 'Thuế, phí khi mua bán nhà đất Đà Nẵng 2026: thuế TNCN, trước bạ, công chứng, ai trả?',
		'excerpt'  => 'Thuế phí mua bán nhà đất 2026: thuế TNCN 2% giá chuyển nhượng, lệ phí trước bạ 0,5%, phí công chứng theo biểu lũy tiến; ai trả khoản nào và ví dụ tính cho căn hộ 4 tỷ.',
		'keyword'  => 'thuế phí mua bán nhà đất',
		'project'  => '',
		'week'     => 11,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Khi giao dịch nhà đất, căn hộ tại Đà Nẵng năm 2026, <strong>thuế phí mua bán nhà đất</strong> gồm ba khoản chính: thuế thu nhập cá nhân 2% trên giá chuyển nhượng, lệ phí trước bạ 0,5% và phí công chứng tính theo giá trị hợp đồng (tối đa 70 triệu đồng). Bài viết tổng hợp mức thu, người nộp và ví dụ tính cụ thể, cập nhật tháng 10/2026. Đây là thông tin tham khảo, anh chị nên đối chiếu hướng dẫn của cơ quan thuế khi kê khai.</p>

<h2>Bảng tổng hợp thuế phí mua bán nhà đất 2026</h2>
<table>
<thead><tr><th>Khoản</th><th>Mức thu</th><th>Người nộp theo luật</th><th>Căn cứ</th></tr></thead>
<tbody>
<tr><td>Thuế thu nhập cá nhân</td><td>2% giá chuyển nhượng</td><td>Bên bán</td><td>Luật Thuế TNCN 2025 (hiệu lực 1/7/2026)</td></tr>
<tr><td>Lệ phí trước bạ</td><td>0,5% giá tính lệ phí trước bạ</td><td>Bên mua</td><td>Quy định về lệ phí trước bạ hiện hành</td></tr>
<tr><td>Phí công chứng hợp đồng</td><td>Theo biểu lũy tiến, tối đa 70 triệu/trường hợp</td><td>Theo thỏa thuận</td><td>Thông tư 257/2016/TT-BTC (sửa đổi bởi Thông tư 111/2017/TT-BTC)</td></tr>
<tr><td>Phí thẩm định hồ sơ, lệ phí cấp giấy chứng nhận</td><td>Theo nghị quyết của HĐND thành phố</td><td>Thường là bên mua</td><td>Liên hệ cơ quan đăng ký đất đai</td></tr>
</tbody>
</table>

<h2>Thuế thu nhập cá nhân 2% – thay đổi gì từ 1/7/2026?</h2>
<p>Luật Thuế thu nhập cá nhân 2025 có hiệu lực từ 1/7/2026. Với cá nhân cư trú, thuế từ chuyển nhượng bất động sản vẫn tính bằng <strong>giá chuyển nhượng × 2%</strong> cho từng lần giao dịch, không đổi so với trước. Luật bổ sung quy định thời điểm xác định thu nhập tính thuế là thời điểm hợp đồng chuyển nhượng có hiệu lực hoặc thời điểm đăng ký quyền sở hữu, quyền sử dụng.</p>
<h3>Trường hợp được miễn thuế TNCN</h3>
<ul>
<li>Chuyển nhượng giữa những người có quan hệ hôn nhân, huyết thống, nuôi dưỡng theo luật định.</li>
<li>Chuyển nhượng nhà ở, đất ở duy nhất của cá nhân. Theo Nghị định 253/2026/NĐ-CP, người bán phải có quyền sở hữu, sử dụng tối thiểu 183 ngày tính đến thời điểm chuyển nhượng; miễn thuế không áp dụng với nhà ở hình thành trong tương lai.</li>
</ul>
<p>Lưu ý: khai đúng giá giao dịch thực tế trên hợp đồng. Khai thấp giá để giảm thuế có thể gây rủi ro cho cả hai bên khi phát sinh tranh chấp hoặc khi bên mua bán lại sau này.</p>

<h2>Lệ phí trước bạ 0,5%</h2>
<p>Lệ phí trước bạ nhà đất năm 2026 là 0,5% giá tính lệ phí trước bạ. Với giao dịch chuyển nhượng, giá tính thường là giá ghi trên hợp đồng nếu cao hơn giá do UBND thành phố ban hành. Bên mua nộp khoản này khi đăng ký sang tên. Một số trường hợp được miễn lệ phí trước bạ, ví dụ chuyển giao giữa vợ chồng, cha mẹ và con theo quy định.</p>

<h2>Phí công chứng hợp đồng mua bán</h2>
<table>
<thead><tr><th>Giá trị tài sản / hợp đồng</th><th>Mức phí</th></tr></thead>
<tbody>
<tr><td>Dưới 50 triệu</td><td>50.000 đồng</td></tr>
<tr><td>Từ 50 – 100 triệu</td><td>100.000 đồng</td></tr>
<tr><td>Trên 100 triệu – 1 tỷ</td><td>0,1% giá trị</td></tr>
<tr><td>Trên 1 – 3 tỷ</td><td>1 triệu + 0,06% phần vượt 1 tỷ</td></tr>
<tr><td>Trên 3 – 5 tỷ</td><td>2,2 triệu + 0,05% phần vượt 3 tỷ</td></tr>
<tr><td>Trên 5 – 10 tỷ</td><td>3,2 triệu + 0,04% phần vượt 5 tỷ</td></tr>
<tr><td>Trên 10 – 100 tỷ</td><td>5,2 triệu + 0,03% phần vượt 10 tỷ</td></tr>
<tr><td>Trên 100 tỷ</td><td>32,2 triệu + 0,02% phần vượt 100 tỷ, tối đa 70 triệu</td></tr>
</tbody>
</table>
<p>Ngoài phí công chứng, tổ chức công chứng có thể thu thêm thù lao soạn thảo, sao y, công chứng ngoài trụ sở – nên hỏi trước.</p>

<h2>Ví dụ: căn hộ chuyển nhượng giá 4 tỷ</h2>
<table>
<thead><tr><th>Khoản</th><th>Cách tính</th><th>Số tiền</th></tr></thead>
<tbody>
<tr><td>Thuế TNCN</td><td>4 tỷ × 2%</td><td>80 triệu</td></tr>
<tr><td>Lệ phí trước bạ</td><td>4 tỷ × 0,5% (giả định giá tính bằng giá hợp đồng)</td><td>20 triệu</td></tr>
<tr><td>Phí công chứng</td><td>2,2 triệu + 0,05% × 1 tỷ</td><td>2,7 triệu</td></tr>
<tr><td><strong>Tổng ba khoản chính</strong></td><td></td><td><strong>Khoảng 102,7 triệu</strong></td></tr>
</tbody>
</table>
<p>Chưa gồm phí thẩm định hồ sơ, lệ phí cấp giấy chứng nhận và thù lao công chứng.</p>

<h2>Ai trả khoản nào?</h2>
<p>Theo luật, bên bán là người có thu nhập nên nộp thuế TNCN; bên mua là người đăng ký sở hữu nên nộp lệ phí trước bạ. Tuy nhiên, các bên được thỏa thuận khác, ví dụ "giá bán đã bao gồm thuế phí" hoặc "bên mua chịu toàn bộ". Thỏa thuận này phải ghi rõ trong hợp đồng đặt cọc và hợp đồng mua bán để tránh tranh cãi khi đến bước kê khai.</p>
<p>Với căn hộ chuyển nhượng hợp đồng mua bán (chưa có sổ), bên bán cũng phát sinh nghĩa vụ thuế TNCN trên giá chuyển nhượng; lệ phí trước bạ được nộp khi người mua làm thủ tục cấp sổ. Quy trình chi tiết xem bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Khi so giá giữa các căn, anh chị nên quy về cùng một điều kiện: giá đã gồm hay chưa gồm thuế phí, đã gồm nội thất hay chưa. Hai căn chênh nhau vài chục triệu trên tin rao có thể bằng nhau khi tính đủ chi phí. Nếu dùng vốn vay, đừng quên khoản phí liên quan đến thế chấp, tham khảo bài <a href="/vay-mua-can-ho-da-nang-2026-lai-suat/">vay mua căn hộ Đà Nẵng 2026</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được ước tính tổng chi phí giao dịch cho căn cụ thể trước khi đặt cọc.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Thuế phí mua bán nhà đất Đà Nẵng 2026: ai trả?',
			'desc'      => 'Thuế phí mua bán nhà đất 2026: thuế TNCN 2%, lệ phí trước bạ 0,5%, phí công chứng theo biểu, ai trả, ví dụ căn hộ 4 tỷ. Gọi Hoàng Hiệp để được ước tính.',
			'points'    => array(
				'Thuế TNCN 2% giá chuyển nhượng, giữ nguyên theo Luật Thuế TNCN 2025 (từ 1/7/2026)',
				'Lệ phí trước bạ 0,5%; phí công chứng theo biểu lũy tiến, tối đa 70 triệu',
				'Miễn thuế nhà ở duy nhất: sở hữu tối thiểu 183 ngày (Nghị định 253/2026)',
				'Căn 4 tỷ: ba khoản chính khoảng 102,7 triệu',
			),
			'faq'       => array(
				array( 'Thuế TNCN khi bán nhà năm 2026 là bao nhiêu?', 'Với cá nhân cư trú, thuế bằng 2% giá chuyển nhượng từng lần, giữ nguyên theo Luật Thuế TNCN 2025 có hiệu lực từ 1/7/2026.' ),
				array( 'Lệ phí trước bạ nhà đất là bao nhiêu?', 'Mức thu là 0,5% giá tính lệ phí trước bạ, do bên mua nộp khi đăng ký sang tên (trừ khi các bên thỏa thuận khác).' ),
				array( 'Bán nhà duy nhất có phải nộp thuế không?', 'Được miễn thuế TNCN nếu là nhà ở, đất ở duy nhất và sở hữu tối thiểu 183 ngày tính đến thời điểm chuyển nhượng; không áp dụng với nhà ở hình thành trong tương lai.' ),
				array( 'Phí công chứng mua bán căn hộ 4 tỷ là bao nhiêu?', 'Theo biểu phí, căn 4 tỷ có phí công chứng 2,2 triệu + 0,05% phần vượt 3 tỷ, tức khoảng 2,7 triệu, chưa gồm thù lao khác.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat-doanh-nghiep/bai-viet/thue-tncn-tu-chuyen-nhuong-bat-dong-san-tu-01-7-2026-21973.html',
			'https://vietnamnet.vn/chuyen-nhuong-quyen-su-dung-dat-nop-thue-thu-nhap-ca-nhan-the-nao-tu-1-7-2026-2485511.html',
			'https://luatvietnam.vn/thue-phi-le-phi/ban-nha-dat-duy-nhat-dieu-kien-de-duoc-mien-thue-tncn-theo-nghi-dinh-253-565-110160-article.html',
			'https://thuvienphapluat.vn/ma-so-thue/phap-luat-thue/muc-thu-le-phi-truoc-ba-khi-chuyen-nhuong-nha-dat-nam-2026-la-bao-nhieu-260838-218256.html',
			'https://thuvienphapluat.vn/phap-luat-nha-dat/cap-nhat-muc-phi-cong-chung-hop-dong-mua-nha-ban-dat-moi-nhat-nam-2026-6028.html',
			'https://congchungnguyenhue.com/van-ban-phap-luat/thong-tu-257-2016-tt-btc-ve-muc-thu-phi-cong-chung-190-125954.html',
		),
	);

	$posts[] = array(
		'slug'     => 'cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru',
		'title'    => 'Cho thuê căn hộ Đà Nẵng: hợp đồng, thuế cho thuê nhà và khai báo tạm trú khách nước ngoài',
		'excerpt'  => 'Cho thuê căn hộ Đà Nẵng 2026: hợp đồng thuê cần gì, ngưỡng doanh thu 1 tỷ/năm không chịu thuế theo Nghị định 141/2026, khai báo tạm trú người nước ngoài theo Thông tư 87/2026.',
		'keyword'  => 'cho thuê căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 11,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p><strong>Cho thuê căn hộ Đà Nẵng</strong> là nguồn thu đều cho nhiều chủ nhà nhờ lượng khách du lịch, chuyên gia và người nước ngoài sinh sống tại thành phố. Năm 2026 có ba điểm chủ nhà cần nắm: hợp đồng thuê lập thành văn bản, ngưỡng doanh thu không chịu thuế đã nâng lên 1 tỷ đồng/năm, và quy định mới về khai báo tạm trú cho người nước ngoài từ 24/7/2026. Bài viết cập nhật tháng 10/2026.</p>

<h2>Hợp đồng cho thuê căn hộ</h2>
<p>Theo Luật Nhà ở 2023, hợp đồng thuê nhà ở phải lập thành văn bản nhưng <strong>không bắt buộc công chứng, chứng thực</strong>, trừ khi các bên có nhu cầu. Thời điểm có hiệu lực do các bên thỏa thuận; nếu không thỏa thuận thì là thời điểm ký.</p>
<h3>Nội dung nên có trong hợp đồng</h3>
<table>
<thead><tr><th>Điều khoản</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Thông tin căn hộ</td><td>Mã căn, diện tích, danh mục nội thất kèm hiện trạng (nên có ảnh)</td></tr>
<tr><td>Giá thuê, kỳ thanh toán</td><td>Theo tháng/quý, phương thức chuyển khoản, điều kiện điều chỉnh giá</td></tr>
<tr><td>Tiền cọc</td><td>Số tiền, điều kiện hoàn cọc, khấu trừ hư hỏng</td></tr>
<tr><td>Chi phí phát sinh</td><td>Ai trả phí quản lý, điện nước, internet, gửi xe</td></tr>
<tr><td>Thời hạn, chấm dứt sớm</td><td>Thời gian báo trước, mức phạt khi một bên chấm dứt trước hạn</td></tr>
<tr><td>Nội quy tòa nhà</td><td>Người thuê cam kết tuân thủ nội quy, quy định về lưu trú, thú cưng</td></tr>
<tr><td>Tạm trú</td><td>Trách nhiệm cung cấp giấy tờ để khai báo, đăng ký tạm trú</td></tr>
</tbody>
</table>

<h2>Thuế cho thuê nhà năm 2026</h2>
<p>Theo Nghị định 141/2026/NĐ-CP, cá nhân cho thuê bất động sản có tổng doanh thu <strong>từ 1 tỷ đồng/năm trở xuống</strong> không phải chịu thuế giá trị gia tăng và không phải nộp thuế thu nhập cá nhân cho hoạt động này; ngưỡng được nâng từ 500 triệu lên 1 tỷ, áp dụng từ 1/1/2026.</p>
<table>
<thead><tr><th>Doanh thu cho thuê/năm</th><th>Thuế GTGT</th><th>Thuế TNCN</th></tr></thead>
<tbody>
<tr><td>Từ 1 tỷ trở xuống</td><td>Không phải nộp</td><td>Không phải nộp</td></tr>
<tr><td>Trên 1 tỷ</td><td>5% × tổng doanh thu</td><td>5% × (doanh thu – 1 tỷ)</td></tr>
</tbody>
</table>
<p>Dù không phải nộp thuế, chủ nhà vẫn có nghĩa vụ tự khai báo doanh thu cho thuê trong năm và thông báo tài khoản ngân hàng, ví điện tử dùng để nhận tiền thuê. Ví dụ một căn 2 phòng ngủ cho thuê 25 triệu/tháng có doanh thu 300 triệu/năm, thấp hơn ngưỡng 1 tỷ. Chủ sở hữu nhiều căn thì cộng doanh thu tất cả các căn. Cách khai cụ thể anh chị nên hỏi chi cục thuế nơi có căn hộ.</p>

<h2>Khai báo tạm trú cho khách</h2>
<h3>Khách là người nước ngoài</h3>
<p>Thông tư 87/2026/TT-BCA ban hành ngày 9/6/2026, có hiệu lực từ 24/7/2026, thay thế Thông tư 53/2016/TT-BCA. Theo đó, cơ sở lưu trú (bao gồm nhà ở cho người nước ngoài thuê) phải khai báo tạm trú <strong>ngay khi người nước ngoài đến lưu trú</strong>, không chờ đến cuối ngày. Hình thức: khai báo qua Hệ thống khai báo tạm trú điện tử của Bộ Công an bằng tài khoản được cấp, hoặc bằng Phiếu khai báo tạm trú.</p>
<p>Chủ nhà nên đăng ký tài khoản khai báo trước khi đón khách, giữ bản chụp hộ chiếu và thị thực của khách, và ghi trách nhiệm cung cấp giấy tờ vào hợp đồng thuê.</p>
<h3>Khách là người Việt Nam</h3>
<p>Người thuê ở dài ngày thực hiện đăng ký tạm trú theo Luật Cư trú; chủ nhà hỗ trợ bằng cách cung cấp hợp đồng thuê và đồng ý cho đăng ký tại căn hộ.</p>

<h2>Cho thuê ngắn ngày hay dài hạn?</h2>
<p>Thuê ngắn ngày theo đêm có thể cho doanh thu cao hơn vào mùa du lịch nhưng tốn công vận hành và phụ thuộc nội quy từng tòa nhà – một số tòa hạn chế lưu trú ngắn ngày. Thuê dài hạn ổn định hơn, ít hao mòn nội thất. Giá thuê theo dự án gần biển xem bài <a href="/thue-can-ho-bien-my-khe-gia-theo-du-an/">thuê căn hộ biển Mỹ Khê</a>, mặt bằng chung toàn thành phố xem bài <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Phần lớn chủ nhà có một vài căn sẽ nằm dưới ngưỡng 1 tỷ đồng/năm, nhưng vẫn nên khai báo đầy đủ để hồ sơ minh bạch khi cần vay vốn hoặc bán lại. Với khách nước ngoài, việc khai báo tạm trú ngay khi khách đến cần trở thành thói quen. Nếu không có thời gian tự vận hành, anh chị có thể tham khảo dịch vụ <a href="/ky-gui-can-ho-da-nang-ban-cho-thue/">ký gửi căn hộ cho thuê</a>.</p>
<p>Xem thêm căn đang cho thuê tại <a href="/cho-thue/">cho thuê bất động sản Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được tư vấn giá thuê phù hợp và tìm khách thuê cho căn hộ của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Cho thuê căn hộ Đà Nẵng: hợp đồng, thuế, tạm trú',
			'desc'      => 'Cho thuê căn hộ Đà Nẵng 2026: hợp đồng thuê, ngưỡng doanh thu 1 tỷ/năm không chịu thuế, khai báo tạm trú khách nước ngoài theo Thông tư 87/2026.',
			'points'    => array(
				'Hợp đồng thuê nhà lập văn bản, không bắt buộc công chứng (Luật Nhà ở 2023)',
				'Doanh thu cho thuê từ 1 tỷ/năm trở xuống không chịu GTGT, TNCN (Nghị định 141/2026)',
				'Từ 24/7/2026 khai báo tạm trú người nước ngoài ngay khi khách đến (Thông tư 87/2026)',
			),
			'faq'       => array(
				array( 'Hợp đồng cho thuê căn hộ có phải công chứng không?', 'Không bắt buộc. Theo Luật Nhà ở 2023, hợp đồng thuê nhà ở phải lập thành văn bản nhưng chỉ công chứng, chứng thực khi các bên có nhu cầu.' ),
				array( 'Cho thuê căn hộ phải nộp thuế bao nhiêu?', 'Theo Nghị định 141/2026, doanh thu cho thuê từ 1 tỷ đồng/năm trở xuống không phải nộp thuế GTGT và TNCN; vượt ngưỡng thì GTGT 5% tổng doanh thu và TNCN 5% phần vượt 1 tỷ.' ),
				array( 'Khai báo tạm trú cho khách nước ngoài trong bao lâu?', 'Từ 24/7/2026, theo Thông tư 87/2026/TT-BCA, phải khai báo ngay khi người nước ngoài đến lưu trú, qua hệ thống điện tử hoặc phiếu khai báo.' ),
				array( 'Doanh thu dưới ngưỡng có cần khai báo không?', 'Có. Chủ nhà vẫn phải tự khai báo doanh thu cho thuê và thông báo tài khoản nhận tiền dù không phải nộp thuế.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/chinh-sach-phap-luat-moi/vn/ho-tro-phap-luat/tu-van-phap-luat/71831/theo-luat-nha-o-2023-thi-hop-dong-cho-thue-nha-o-co-phai-cong-chung-chung-thuc-hay-khong',
			'https://thuvienphapluat.vn/phap-luat-doanh-nghiep/bai-viet/cach-tinh-thue-cho-thue-bat-dong-san-moi-nhat-2026-theo-nghi-dinh-141-va-nghi-dinh-68-20777.html',
			'https://congthuong.vn/nguoi-cho-thue-nha-doanh-thu-duoi-1ty-nam-duoc-mien-thue-460385.html',
			'https://cafef.vn/chuyen-gia-cho-thue-bat-dong-san-doanh-thu-duoi-1-ty-dong-duoc-mien-ca-thue-gtgt-va-thue-tncn-188260505143140765.chn',
			'https://congan.angiang.gov.vn/thong-tu-so-872026tt-bca-ngay-0962026-cua-bo-cong-an-quy-dinh-cach-thuc-thuc-hien-khai-bao-tiep-nhan-thong-tin-tam-tru-cua-nguoi-nuoc-ngoai-tai-viet-nam',
			'https://luatvietnam.vn/tin-van-ban-moi/tu-24-7-2026-co-so-luu-tru-phai-khai-bao-tam-tru-ngay-khi-nguoi-nuoc-ngoai-den-luu-tru-883-110512-article.html',
		),
	);

	$posts[] = array(
		'slug'     => 'thue-can-ho-bien-my-khe-gia-theo-du-an',
		'title'    => 'Thuê căn hộ gần biển Mỹ Khê: giá thuê theo từng dự án 2026',
		'excerpt'  => 'Thuê căn hộ biển Mỹ Khê 2026: Times Square khoảng 25 – 40 triệu/tháng, Wyndham Soleil studio khoảng 20 triệu, Hiyori Garden 2PN 15 – 25 triệu và các dự án gần biển (tham khảo).',
		'keyword'  => 'thuê căn hộ biển Mỹ Khê',
		'project'  => '',
		'week'     => 11,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p>Nhu cầu <strong>thuê căn hộ biển Mỹ Khê</strong> đến từ khách du lịch dài ngày, người nước ngoài sinh sống và làm việc từ xa, gia đình chuyên gia. Mặt bằng giá thuê dài hạn năm 2026 tham khảo từ khoảng 15 triệu/tháng cho căn 2 phòng ngủ cách biển khoảng 1 km, đến 25 – 45 triệu/tháng cho căn mặt biển có nội thất. Số liệu tổng hợp từ tin cho thuê công khai, cập nhật tháng 10/2026.</p>

<h2>Bảng giá thuê căn hộ gần biển Mỹ Khê theo dự án</h2>
<table>
<thead><tr><th>Dự án</th><th>Khoảng cách đến biển</th><th>Giá thuê tham khảo (10/2026)</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/times-square-da-nang/">Times Square Đà Nẵng</a></td><td>Mặt đường Võ Nguyên Giáp, trực diện biển</td><td>Dài hạn khoảng 25 – 40 triệu/tháng</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil Đà Nẵng</a></td><td>Phạm Văn Đồng – Võ Nguyên Giáp</td><td>Studio khoảng 20 triệu; căn lớn, view biển khoảng 25 – 45 triệu/tháng</td></tr>
<tr><td><a href="/du-an/hiyori-garden-tower/">Hiyori Garden Tower</a></td><td>Khoảng 1 km</td><td>2PN khoảng 15 – 25 triệu/tháng (phổ biến 18 – 21 triệu)</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Khoảng 3 – 5 phút di chuyển (ven sông Hàn)</td><td>Studio 13 – 20; 1PN 20 – 30; 2PN 32 – 40 triệu/tháng</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Khoảng 5 – 7 phút di chuyển (ven sông Hàn)</td><td>2PN khoảng 23 – 30 triệu; chung 20 – 45 triệu/tháng</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Khoảng 2 km</td><td>Studio từ 16; 1PN 23 – 24; 2PN 30 – 35 triệu/tháng</td></tr>
</tbody>
</table>
<p>Đây là khoảng giá tổng hợp từ tin rao, không phải giá chốt hợp đồng. Giá thực tế chênh theo tầng, hướng view, nội thất và thời hạn thuê; thuê ngắn ngày theo đêm có mặt bằng khác.</p>

<h2>Nhóm mặt biển: Times Square, Wyndham Soleil</h2>
<p>Times Square nằm trên trục Võ Nguyên Giáp, nhiều căn nhìn trực diện biển, khối đế đã có các thương hiệu F&amp;B hoạt động. Căn view trực diện biển được rao thuê khoảng 25 triệu/tháng, mặt bằng dài hạn khoảng 25 – 40 triệu/tháng.</p>
<p>Wyndham Soleil là căn hộ khách sạn, studio rao thuê khoảng 20 triệu/tháng, căn lớn view biển khoảng 25 – 45 triệu/tháng. Người thuê dài hạn nên hỏi rõ phí dịch vụ đi kèm vì mô hình căn hộ khách sạn thường có thêm các khoản này.</p>

<h2>Nhóm gần biển, giá mềm hơn: Hiyori Garden Tower</h2>
<p>Hiyori Garden Tower trên đường Võ Văn Kiệt (Sơn Trà), cách biển khoảng 1 km, đã bàn giao từ tháng 12/2019. Phần lớn là căn 2 phòng ngủ, giá thuê phổ biến 18 – 21 triệu/tháng, căn view đẹp có thể đến khoảng 28 triệu. Đây là lựa chọn hợp lý cho gia đình hoặc người ở dài hạn muốn gần biển nhưng không trả mức giá mặt biển.</p>
<p>Dự án cùng chủ phát triển là HIYORI Aqua Tower (góc Lê Đức Thọ – Ngô Cao Lãng, khoảng 5 phút đi bộ ra biển) dự kiến bàn giao quý 2/2027, nên chưa có mặt bằng giá thuê. Xem bài <a href="/hiyori-garden-tower-hiyori-aqua-tower-da-nang/">Hiyori Garden Tower và Hiyori Aqua Tower</a>.</p>

<h2>Nhóm ven sông Hàn, cách biển vài phút</h2>
<p>Nhiều người thuê chọn căn bờ Đông sông Hàn như Sun Ponte, Peninsula: vừa gần biển Mỹ Khê, vừa gần cầu Rồng và trung tâm. Sun Ponte có giá thuê cao trong nhóm nhờ vị trí sát cầu Rồng; Peninsula có mặt bằng giá mua thấp hơn nên chủ nhà thường linh hoạt giá thuê.</p>

<h2>Kinh nghiệm thuê căn hộ gần biển</h2>
<ul>
<li><strong>Kiểm tra độ ẩm, gỉ sét:</strong> căn gần biển dễ xuống cấp thiết bị kim loại, điều hòa; nên xem kỹ trước khi ký.</li>
<li><strong>Hỏi rõ chi phí ngoài giá thuê:</strong> phí quản lý, gửi xe, internet, điện nước tính theo giá nào.</li>
<li><strong>Thời điểm thuê:</strong> mùa du lịch hè và dịp lễ hội pháo hoa, căn ngắn ngày tăng giá; hợp đồng dài hạn ký từ trước giúp giữ giá ổn định.</li>
<li><strong>Giấy tờ:</strong> người nước ngoài cần cung cấp hộ chiếu, thị thực để chủ nhà khai báo tạm trú – xem bài <a href="/cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru/">cho thuê căn hộ Đà Nẵng: hợp đồng, thuế, tạm trú</a>.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với người thuê ở dài hạn, căn cách biển 1 – 2 km thường cho mức giá hợp lý hơn đáng kể mà vẫn thuận tiện đi biển hằng ngày. Với chủ nhà đang cân nhắc mua để cho thuê, hãy lấy giá thuê ở mức giữa của khoảng giá, không lấy mức cao nhất trên tin rao, khi tính lợi suất. Danh mục căn mặt biển để mua xem bài <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Đà Nẵng</a>.</p>
<p>Xem căn đang cho thuê tại <a href="/cho-thue/">cho thuê bất động sản Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn hộ gần biển Mỹ Khê đang cho thuê thật, kèm giá và ảnh thực tế.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Thuê căn hộ biển Mỹ Khê: giá thuê theo dự án 2026',
			'desc'      => 'Thuê căn hộ biển Mỹ Khê 2026: Times Square 25 – 40 triệu, Wyndham Soleil, Hiyori Garden 2PN 15 – 25 triệu/tháng (tham khảo). Gọi Hoàng Hiệp để xem căn.',
			'points'    => array(
				'Mặt biển: Times Square khoảng 25 – 40 triệu/tháng, Wyndham Soleil studio khoảng 20 triệu',
				'Gần biển: Hiyori Garden Tower 2PN khoảng 15 – 25 triệu/tháng',
				'Ven sông Hàn gần biển: Sun Ponte 2PN 32 – 40 triệu, Peninsula 2PN 23 – 30 triệu',
			),
			'faq'       => array(
				array( 'Thuê căn hộ gần biển Mỹ Khê giá bao nhiêu?', 'Tham khảo tháng 10/2026: căn 2PN cách biển khoảng 1 km từ 15 – 25 triệu/tháng; căn mặt biển có nội thất khoảng 25 – 45 triệu/tháng.' ),
				array( 'Dự án nào gần biển Mỹ Khê có giá thuê mềm?', 'Hiyori Garden Tower cách biển khoảng 1 km, căn 2PN phổ biến 18 – 21 triệu/tháng.' ),
				array( 'Thuê căn hộ khách sạn ven biển cần lưu ý gì?', 'Hỏi rõ phí dịch vụ, phí quản lý đi kèm và nội quy lưu trú, vì mô hình căn hộ khách sạn thường có thêm các khoản này.' ),
			),
		),
		'sources'  => array(
			'https://thuviennhadat.vn/ban-can-ho-chung-cu-phuong-phuoc-my-pj-da-nang-times-square/ban-can-ho-time-square-da-nang-tang-cao-view-truc-dien-bien-my-khe-cho-thue-25trthang-pst152092.html',
			'https://www.nhatot.com/mua-ban-can-ho-chung-cu--wyndham-soleil-da-nang-quan-son-tra-pj1340311932',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-hiyori-garden-tower',
			'https://www.nhatot.com/thue-can-ho-chung-cu--hiyori-garden-tower-quan-son-tra-pj1871336036',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-peninsula-da-nang',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-cosmo-residence',
		),
	);

	$posts[] = array(
		'slug'     => 'gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an',
		'title'    => 'Giá chuyển nhượng căn hộ Đà Nẵng 2026: bảng tổng hợp theo dự án',
		'excerpt'  => 'Bảng giá chuyển nhượng căn hộ Đà Nẵng tháng 10/2026 theo 15 dự án: từ khoảng 30 – 42 triệu/m² ở FPT City đến khoảng 150 triệu/m² ở Times Square (tham khảo tin rao).',
		'keyword'  => 'giá chuyển nhượng căn hộ Đà Nẵng',
		'project'  => '',
		'week'     => 11,
		'category' => 'Thị trường',
		'content'  => <<<'HTML'
<p><strong>Giá chuyển nhượng căn hộ Đà Nẵng</strong> tháng 10/2026 phân hóa rõ theo vị trí: khoảng 30 – 42 triệu/m² ở FPT City và Liên Chiểu, 50 – 125 triệu/m² ở các dự án ven sông Hàn, và khoảng 110 – 150 triệu/m² ở nhóm hạng sang mặt sông, mặt biển. Bảng dưới đây tổng hợp khoảng giá từ tin rao công khai theo từng dự án, chỉ để tham khảo mặt bằng, không phải giá chốt.</p>

<h2>Bảng giá chuyển nhượng căn hộ Đà Nẵng theo dự án (tham khảo 10/2026)</h2>
<table>
<thead><tr><th>Dự án</th><th>Khu vực</th><th>Giá chuyển nhượng tham khảo</th><th>Đơn giá ước tính</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/the-ori-garden/">The Ori Garden</a></td><td>Liên Chiểu</td><td>1PN 1,31 – 1,94 tỷ; 2PN 1,96 – 2,56 tỷ; 3PN 2,79 – 3,1 tỷ</td><td>≈ 37 – 42 triệu/m²</td></tr>
<tr><td>FPT Plaza 2</td><td>FPT City</td><td>2PN 2,25 – 3,4 tỷ; 3PN 3,9 – 4,25 tỷ</td><td>≈ 30 – 42 triệu/m²</td></tr>
<tr><td>FPT Plaza 3</td><td>FPT City</td><td>1PN 1,6 – 2,5 tỷ; 2PN 2,6 – 4 tỷ</td><td>–</td></tr>
<tr><td>Vista Residence</td><td>Hải Châu</td><td>2PN (76 m²) 4,3 – 5,1 tỷ</td><td>≈ 48 – 55 triệu/m²</td></tr>
<tr><td><a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a></td><td>Sơn Trà – sông Hàn</td><td>1PN 2,2 – 2,7 tỷ; 2PN 3 – 5 tỷ; 3PN 5,5 – 6,5 tỷ</td><td>≈ 50 – 83 triệu/m²</td></tr>
<tr><td>Newtown Diamond</td><td>Ngũ Hành Sơn – biển</td><td>1PN 2,8 – 3,9 tỷ; 2PN 4,5 – 7,5 tỷ; 3PN 7,2 – 11,6 tỷ</td><td>≈ 60 – 90 triệu/m²</td></tr>
<tr><td><a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a></td><td>Ngũ Hành Sơn – sông Hàn</td><td>Studio 1,8 – 2,5 tỷ; 1PN 2,8 – 5,3 tỷ; 2PN 3,6 – 6,8 tỷ; 3PN 6 – 9,5 tỷ</td><td>≈ 65 – 95 triệu/m²</td></tr>
<tr><td>Sun Symphony Residence</td><td>Sơn Trà – sông Hàn</td><td>Studio 3,2 – 3,6 tỷ; 1PN+ từ 4,5 tỷ; 2PN 6 – 8 tỷ; 3PN từ 8,2 tỷ</td><td>≈ 69 – 125 triệu/m²</td></tr>
<tr><td><a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a></td><td>Sơn Trà – sông Hàn</td><td>Studio/1PN 2,96 – 4,49 tỷ; 2PN 4,3 – 6,9 tỷ; 3PN 5,6 – 10 tỷ</td><td>≈ 70 – 112 triệu/m²</td></tr>
<tr><td>Capital Square</td><td>Sơn Trà – sông Hàn</td><td>1PN 3,3 – 4,5 tỷ; 2PN 4,7 – 7,8 tỷ; 3PN 9,5 – 12,6 tỷ</td><td>≈ 74 – 90 triệu/m²</td></tr>
<tr><td>Hiyori Garden Tower</td><td>Sơn Trà</td><td>2PN (63 – 71 m²) 5 – 6,7 tỷ</td><td>–</td></tr>
<tr><td>Wyndham Soleil</td><td>Sơn Trà – biển</td><td>Studio 2,3 – 2,6 tỷ; 1PN (55 – 58 m²) khoảng 4,3 tỷ</td><td>≈ 74 – 130 triệu/m²</td></tr>
<tr><td><a href="/du-an/the-filmore-da-nang/">The Filmore</a></td><td>Hải Châu – sông Hàn</td><td>1PN 4,5 – 7,6 tỷ; 2PN 8,3 – 9,3 tỷ</td><td>≈ 110 triệu/m²</td></tr>
<tr><td>Times Square</td><td>Sơn Trà – biển Mỹ Khê</td><td>Studio/1PN 6,5 – 8,5 tỷ; 2PN 12 – 14 tỷ</td><td>≈ 150 triệu/m²</td></tr>
<tr><td>Masteri Đà Nẵng</td><td>Sông Hàn</td><td>Chuyển nhượng HĐMB 2PN khoảng 4,9 tỷ</td><td>–</td></tr>
</tbody>
</table>
<p>Nguồn: tổng hợp tin rao bán công khai tháng 10/2026. Khoảng giá rộng vì phụ thuộc tầng, hướng view, nội thất, tình trạng pháp lý (đã có sổ hay chuyển nhượng hợp đồng). Giá rao thường còn biên độ thương lượng.</p>

<h2>Ba phân khúc giá chuyển nhượng</h2>
<h3>Dưới 50 triệu/m²: Liên Chiểu, FPT City</h3>
<p>The Ori Garden và các tòa FPT Plaza có tổng giá căn 2PN quanh 2 – 4 tỷ, phù hợp người mua ở thực ngân sách vừa phải. Xem thêm bài <a href="/mua-can-ho-da-nang-2-ty-3-ty/">mua căn hộ Đà Nẵng 2 – 3 tỷ</a>.</p>
<h3>50 – 100 triệu/m²: ven sông Hàn, trục Trường Sa</h3>
<p>Nhóm đông giao dịch nhất năm 2026 vì nhiều dự án vừa bàn giao: Sun Cosmo, Sun Ponte, Sun Symphony, Peninsula, Newtown Diamond, Capital Square. Chi tiết từng dự án xem các bài <a href="/sun-cosmo-residence-gia-chuyen-nhuong-cho-thue/">Sun Cosmo Residence</a>, <a href="/sun-ponte-residence-gia-chuyen-nhuong-cho-thue/">Sun Ponte Residence</a>, <a href="/peninsula-da-nang-gia-chuyen-nhuong-cho-thue/">Peninsula Đà Nẵng</a>.</p>
<h3>Trên 100 triệu/m²: hạng sang mặt sông, mặt biển</h3>
<p>The Filmore và Times Square nằm ở nhóm cao nhất, quỹ căn ít, giá giữ tốt nhờ vị trí khó thay thế. Xem bài <a href="/the-filmore-da-nang-gia-chuyen-nhuong-cho-thue/">The Filmore Đà Nẵng</a>.</p>

<h2>Cách đọc giá chuyển nhượng cho đúng</h2>
<ul>
<li><strong>Quy về đơn giá/m² thông thủy</strong> để so giữa các căn khác diện tích.</li>
<li><strong>Tách giá nội thất:</strong> căn full nội thất cao cấp có thể chênh vài trăm triệu so với căn bàn giao cơ bản.</li>
<li><strong>Phân biệt căn có sổ và chuyển nhượng HĐMB:</strong> căn HĐMB còn nghĩa vụ thanh toán với chủ đầu tư, cần cộng phần còn lại vào tổng giá.</li>
<li><strong>Tính đủ thuế phí:</strong> xem bài <a href="/thue-phi-mua-ban-nha-dat-da-nang-2026/">thuế, phí mua bán nhà đất 2026</a>.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Bảng giá tin rao giúp định vị mặt bằng, nhưng giá giao dịch thật của từng căn chỉ rõ khi đã kiểm tra tầng, view, nội thất và pháp lý. Khi chọn giữa hai dự án cùng tầm tiền, anh chị nên so thêm giá thuê thực tế để biết khả năng khai thác, và thời gian còn lại đến khi nhận sổ. Quy trình giao dịch an toàn xem bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>.</p>
<p>Xem thêm danh sách <a href="/mua-ban/can-ho-chung-cu/">căn hộ đang bán tại Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn chuyển nhượng đang giao dịch thật theo ngân sách của anh chị.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá chuyển nhượng căn hộ Đà Nẵng 2026 theo dự án',
			'desc'      => 'Giá chuyển nhượng căn hộ Đà Nẵng 10/2026 theo 15 dự án: The Ori Garden, FPT Plaza, Sun Cosmo, Sun Ponte, Peninsula, Filmore, Times Square. Gọi Hoàng Hiệp.',
			'points'    => array(
				'Liên Chiểu, FPT City khoảng 30 – 42 triệu/m² (tham khảo tin rao)',
				'Ven sông Hàn, trục Trường Sa khoảng 50 – 125 triệu/m²',
				'Hạng sang: The Filmore khoảng 110 triệu/m², Times Square khoảng 150 triệu/m²',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng căn hộ Đà Nẵng 2026 bao nhiêu?', 'Tham khảo tin rao tháng 10/2026: khoảng 30 – 42 triệu/m² ở FPT City, Liên Chiểu; 50 – 125 triệu/m² ở dự án ven sông Hàn; trên 100 triệu/m² ở nhóm hạng sang.' ),
				array( 'Căn hộ chuyển nhượng nào dưới 3 tỷ?', 'Theo tin rao, The Ori Garden, FPT Plaza và một số căn 1PN Peninsula, studio Sun Cosmo có mức dưới 3 tỷ; cần kiểm tra từng căn cụ thể.' ),
				array( 'Giá rao chuyển nhượng có phải giá chốt không?', 'Không. Đây là giá chào, thường còn biên độ thương lượng và chênh theo tầng, view, nội thất, pháp lý.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-cosmo-residence',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-ponte-residence-da-nang',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-peninsula-da-nang',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-ori-garden',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-da-nang-times-square',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-fpt-plaza-2',
		),
	);

	/* ---------------------------------------------------------------- Tuần 12 */
	$posts[] = array(
		'slug'     => 'sun-cosmo-residence-gia-chuyen-nhuong-cho-thue',
		'title'    => 'Sun Cosmo Residence: giá chuyển nhượng, giá cho thuê và các loại căn 2026',
		'excerpt'  => 'Sun Cosmo Residence (Ngũ Hành Sơn): khoảng 650 căn hộ studio – 3PN, duplex; chuyển nhượng khoảng 65 – 95 triệu/m², cho thuê 2PN khoảng 30 – 35 triệu/tháng (tham khảo 10/2026).',
		'keyword'  => 'Sun Cosmo Residence',
		'project'  => 'sun-cosmo-residence',
		'week'     => 12,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Sun Cosmo Residence</strong> là tổ hợp căn hộ, nhà phố, biệt thự của Sun Group sát chân cầu Trần Thị Lý, bờ Đông sông Hàn (Ngũ Hành Sơn, Đà Nẵng). Dự án đã bước vào giai đoạn bàn giao nên giao dịch hiện chủ yếu là chuyển nhượng và cho thuê. Giá chuyển nhượng tham khảo khoảng 65 – 95 triệu/m², căn 2PN cho thuê khoảng 30 – 35 triệu/tháng, cập nhật tháng 10/2026.</p>

<h2>Thông tin nhanh Sun Cosmo Residence</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Sun Group</td></tr>
<tr><td>Vị trí</td><td>Giao lộ Trần Hưng Đạo – Chương Dương – Nguyễn Văn Thoại, sát chân cầu Trần Thị Lý</td></tr>
<tr><td>Quy mô</td><td>3,5 ha, 2 phân khu The Panoma và The Cosmo</td></tr>
<tr><td>Cao tầng</td><td>Tòa A 27 tầng, tòa B 33 tầng; khoảng 650 căn hộ, 38 shop khối đế</td></tr>
<tr><td>Thấp tầng</td><td>101 nhà phố 6 – 7 tầng (đất 100 – 140 m²), 45 biệt thự 3 tầng (đất 200 – 500 m²)</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài</td></tr>
<tr><td>Tiến độ</td><td>Khởi công quý 1/2023, cất nóc khối căn hộ tháng 10/2024, bàn giao từ cuối 2025 – đầu 2026</td></tr>
</tbody>
</table>
<p>Từ dự án đến biển Mỹ Khê khoảng 2 km. Tiện ích nội khu gồm bể bơi, gym, spa, khu thể thao trong nhà, sky garden, khu thương mại bán lẻ và công viên cảnh quan.</p>

<h2>Các loại căn hộ Sun Cosmo</h2>
<p>Khu cao tầng có căn studio, 1 – 3 phòng ngủ và duplex. Theo các trang phân phối, diện tích căn hộ khoảng 40 – 120 m², trong đó căn 3PN khoảng 120 m²; diện tích chính xác từng mã căn cần đối chiếu mặt bằng của chủ đầu tư.</p>
<ul>
<li><strong>Studio, 1PN:</strong> vốn thấp nhất, dễ cho thuê cho người đi làm, khách lưu trú dài ngày.</li>
<li><strong>2PN:</strong> phù hợp gia đình trẻ, cũng là nhóm cho thuê chuyên gia phổ biến.</li>
<li><strong>3PN, duplex:</strong> số lượng ít, phù hợp gia đình đông người hoặc khách cần không gian lớn.</li>
</ul>

<h2>Giá chuyển nhượng Sun Cosmo Residence</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá chuyển nhượng tham khảo (10/2026)</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 1,8 – 2,5 tỷ</td></tr>
<tr><td>1 phòng ngủ</td><td>Khoảng 2,8 – 5,3 tỷ</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 3,6 – 6,8 tỷ</td></tr>
<tr><td>3 phòng ngủ</td><td>Khoảng 6 – 9,5 tỷ</td></tr>
</tbody>
</table>
<p>Quy đổi khoảng 65 – 95 triệu/m². Biên độ rộng vì khác biệt giữa tòa A và B, tầng, view sông Hàn hay hướng phố, và nội thất. Căn view sông tầng cao thường nằm ở nhóm trên.</p>

<h2>Giá cho thuê Sun Cosmo Residence</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Từ khoảng 16 triệu</td></tr>
<tr><td>1 phòng ngủ</td><td>Khoảng 23 – 24 triệu</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 30 – 35 triệu</td></tr>
<tr><td>3 phòng ngủ</td><td>Khoảng 30 – 40 triệu</td></tr>
</tbody>
</table>
<p>Giá thuê tổng hợp từ tin rao, chủ yếu là căn có nội thất. Căn mới bàn giao chưa nội thất sẽ khó đạt mức này.</p>

<h2>Shop khối đế và thấp tầng</h2>
<p>38 shop khối đế nằm ở 2 tầng đế của tòa A và tòa B; tầng thứ ba của khối đế dành cho tiện ích. Nhà phố 6 – 7 tầng và biệt thự 3 tầng ở khu thấp tầng phù hợp khách kinh doanh hoặc ở kết hợp; giá thấp tầng anh chị vui lòng liên hệ vì giao dịch theo từng căn.</p>

<h2>Câu hỏi thường gặp</h2>
<h3>Sun Cosmo Residence nằm ở đâu?</h3>
<p>Dự án nằm tại giao lộ Trần Hưng Đạo – Chương Dương – Nguyễn Văn Thoại, sát chân cầu Trần Thị Lý, bờ Đông sông Hàn, cách biển Mỹ Khê khoảng 2 km.</p>
<h3>Nên chọn căn nào để cho thuê?</h3>
<p>Studio và 1PN có vốn thấp, dễ tìm khách đi làm hoặc lưu trú dài ngày; 2PN phù hợp gia đình chuyên gia. Hãy kiểm tra nội quy tòa nhà về lưu trú ngắn ngày trước khi chọn mô hình cho thuê.</p>
<h3>Mua căn Sun Cosmo cần chuẩn bị chi phí gì ngoài giá căn?</h3>
<p>Thuế, phí giao dịch, phí quản lý và nội thất. Cách tính xem bài <a href="/thue-phi-mua-ban-nha-dat-da-nang-2026/">thuế, phí mua bán nhà đất 2026</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Cosmo có lợi thế giá đầu vào mềm hơn Sun Symphony và Sun Ponte trong khi vẫn ở bờ Đông sông Hàn, gần cầu Trần Thị Lý. Nếu mua để cho thuê, hãy tính tỷ suất trên tổng chi phí gồm nội thất và phí quản lý, và lấy giá thuê ở mức giữa khoảng tham khảo. Nếu mua căn chuyển nhượng hợp đồng (chưa có sổ), cần xác nhận của chủ đầu tư về số tiền đã thanh toán – xem bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>. So sánh với các dự án khác tại bài <a href="/gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an/">giá chuyển nhượng căn hộ Đà Nẵng 2026</a>.</p>
<p>Xem trang dự án <a href="/du-an/sun-cosmo-residence/">Sun Cosmo Residence</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Sun Cosmo đang chuyển nhượng và cho thuê thật, kèm giá cập nhật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Cosmo Residence: giá chuyển nhượng, cho thuê 2026',
			'desc'      => 'Sun Cosmo Residence Đà Nẵng: khoảng 650 căn studio – 3PN, chuyển nhượng 65 – 95 triệu/m², thuê 2PN 30 – 35 triệu/tháng (tham khảo). Gọi Hoàng Hiệp.',
			'points'    => array(
				'Sun Group, sát chân cầu Trần Thị Lý; tòa A 27 tầng, tòa B 33 tầng, khoảng 650 căn hộ',
				'Chuyển nhượng: studio 1,8 – 2,5 tỷ, 2PN 3,6 – 6,8 tỷ (tham khảo 10/2026)',
				'Cho thuê: studio từ 16 triệu, 2PN khoảng 30 – 35 triệu/tháng',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng Sun Cosmo Residence bao nhiêu?', 'Tham khảo tháng 10/2026: studio khoảng 1,8 – 2,5 tỷ, 1PN 2,8 – 5,3 tỷ, 2PN 3,6 – 6,8 tỷ, 3PN 6 – 9,5 tỷ.' ),
				array( 'Thuê căn hộ Sun Cosmo giá bao nhiêu?', 'Studio từ khoảng 16 triệu/tháng, 1PN khoảng 23 – 24 triệu, 2PN khoảng 30 – 35 triệu, 3PN khoảng 30 – 40 triệu (tin rao, chủ yếu căn có nội thất).' ),
				array( 'Sun Cosmo Residence có bao nhiêu căn hộ?', 'Khoảng 650 căn hộ trong tòa A (27 tầng) và tòa B (33 tầng), cùng 38 shop khối đế, 101 nhà phố và 45 biệt thự.' ),
				array( 'Sun Cosmo có sổ hồng lâu dài không?', 'Dự án được giới thiệu là sở hữu lâu dài; tiến độ cấp sổ từng căn theo thông báo của chủ đầu tư.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-cosmo-residence',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-sun-cosmo-residence',
			'https://meeyland.com/cho-thue-can-ho-chung-cu-sun-cosmo-residence-ngu-hanh-son-da-nang-l24332',
			'https://vnexpress.net/bat-dong-san/du-an/detail/sun-cosmo-residence-da-nang-527',
			'https://sungroups.vn/sun-cosmo-residence/',
			'https://house.com.vn/sun-cosmo-residence-da-nang/',
		),
	);

	$posts[] = array(
		'slug'     => 'sun-ponte-residence-gia-chuyen-nhuong-cho-thue',
		'title'    => 'Sun Ponte Residence: giá chuyển nhượng, giá cho thuê và các loại căn 2026',
		'excerpt'  => 'Sun Ponte Residence cạnh cầu Rồng: 495 căn hộ, 7 penthouse, 26 shophouse; chuyển nhượng khoảng 70 – 112 triệu/m², thuê 2PN khoảng 32 – 40 triệu/tháng (tham khảo 10/2026).',
		'keyword'  => 'Sun Ponte Residence',
		'project'  => 'sun-ponte-residence',
		'week'     => 12,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Sun Ponte Residence</strong> là tòa tháp 26 tầng của Sun Group trên đường Trần Hưng Đạo (Sơn Trà), nằm giữa cầu Rồng và cầu Trần Thị Lý, mặt tiền sông Hàn. Căn hộ bắt đầu bàn giao từ tháng 3/2026, nên thị trường đã hình thành giá chuyển nhượng và giá thuê. Tham khảo tháng 10/2026: chuyển nhượng khoảng 70 – 112 triệu/m², căn 2PN cho thuê khoảng 32 – 40 triệu/tháng.</p>

<h2>Thông tin nhanh Sun Ponte Residence</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Tập đoàn Sun Group</td></tr>
<tr><td>Vị trí</td><td>Mặt tiền Trần Hưng Đạo, Sơn Trà, giữa cầu Rồng và cầu Trần Thị Lý; khu đất khoảng 1,6 ha</td></tr>
<tr><td>Quy mô</td><td>1 tòa tháp 26 tầng nổi, 3 tầng hầm</td></tr>
<tr><td>Sản phẩm</td><td>495 căn hộ, 7 penthouse, 26 shophouse khối đế; phân khu The Rio gồm 41 nhà phố, 16 biệt thự</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài</td></tr>
<tr><td>Tiến độ</td><td>Khởi công quý 1/2024; bàn giao căn hộ từ tháng 3/2026, hoàn tất dự kiến quý 3/2026</td></tr>
</tbody>
</table>
<p>Kết nối: khoảng 1 phút đến cầu Rồng, 2 phút đến cầu sông Hàn, 3 – 5 phút ra biển Mỹ Khê và khoảng 10 phút đến sân bay. Tiện ích gồm hồ bơi vô cực, jacuzzi, gym, yoga, spa, kids club, khu BBQ, công viên ven sông và đường chạy bộ.</p>

<h2>Các loại căn Sun Ponte</h2>
<ul>
<li><strong>Studio, 1PN, 1PN+:</strong> nhóm vốn thấp, được nhà đầu tư cho thuê quan tâm nhờ vị trí sát cầu Rồng.</li>
<li><strong>2PN, 3PN:</strong> phù hợp gia đình, khách thuê chuyên gia.</li>
<li><strong>Penthouse:</strong> 7 căn trên các tầng cao – liên hệ để nhận thông tin từng căn.</li>
<li><strong>Shophouse khối đế:</strong> 26 căn, diện tích 40 – 150 m² (căn mặt tiền Trần Hưng Đạo đến khoảng 308 m²), tầng 1 cao 7 m.</li>
</ul>

<h2>Giá chuyển nhượng Sun Ponte Residence</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá chuyển nhượng tham khảo (10/2026)</th></tr></thead>
<tbody>
<tr><td>Studio / 1PN</td><td>Khoảng 2,96 – 4,49 tỷ</td></tr>
<tr><td>1PN+</td><td>Khoảng 3,6 – 4,9 tỷ</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 4,3 – 6,9 tỷ</td></tr>
<tr><td>3 phòng ngủ</td><td>Khoảng 5,6 – 10 tỷ</td></tr>
<tr><td>Shophouse khối đế</td><td>Khoảng 4,6 tỷ (40,7 m²) đến 13 – 64,6 tỷ (mặt tiền Trần Hưng Đạo) – giá chào bán tham khảo</td></tr>
</tbody>
</table>
<p>Quy đổi căn hộ khoảng 70 – 112 triệu/m². Căn trực diện sông Hàn, nhìn cầu Rồng và khu vực pháo hoa thường ở nhóm giá trên.</p>

<h2>Giá cho thuê Sun Ponte Residence</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>Studio</td><td>Khoảng 13 – 20 triệu</td></tr>
<tr><td>1 phòng ngủ</td><td>Khoảng 20 – 30 triệu</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 32 – 40 triệu</td></tr>
</tbody>
</table>
<p>Trong nhóm căn hộ ven sông Hàn, Sun Ponte có giá thuê 2PN được rao cao nhất nhờ vị trí sát cầu Rồng, gần các điểm du lịch. Đây là giá rao, chưa phải lợi suất bảo đảm.</p>

<h2>Phân khu The Rio</h2>
<p><a href="/du-an/the-rio-sun-ponte/">The Rio</a> là phân khu thấp tầng giới hạn của Sun Ponte, ra mắt tháng 7/2025, gồm 41 nhà phố 6,5 tầng và 16 biệt thự đơn lập, song lập do Aedas thiết kế, dùng chung tiện ích với tòa tháp. Giá The Rio giao dịch theo từng căn – liên hệ để nhận thông tin.</p>

<h2>Câu hỏi thường gặp</h2>
<h3>Sun Ponte Residence khác Sun Symphony thế nào?</h3>
<p>Sun Ponte là 1 tòa 26 tầng với 495 căn hộ, sát cầu Rồng; Sun Symphony là tổ hợp 8 ha, 3 tòa với 1.313 căn hộ và nhiều tiện ích nội khu hơn.</p>
<h3>Shophouse khối đế Sun Ponte có đặc điểm gì?</h3>
<p>26 căn, diện tích 40 – 150 m² (căn mặt tiền Trần Hưng Đạo đến khoảng 308 m²), tầng 1 cao 7 m, tầng 2 cao 4,5 m, bàn giao thô, sở hữu lâu dài.</p>
<h3>Căn Sun Ponte đang bàn giao mua chuyển nhượng thế nào?</h3>
<p>Nếu căn chưa có sổ, giao dịch là chuyển nhượng hợp đồng mua bán: công chứng văn bản chuyển nhượng và nộp chủ đầu tư xác nhận. Xem chi tiết tại bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Ponte phù hợp người cần căn nhỏ ở vị trí trung tâm để ở hoặc cho thuê. Vì giá mua vào cũng cao, anh chị nên lập bảng dòng tiền với giá thuê ở mức giữa khoảng tham khảo, trừ phí quản lý, nội thất và thời gian trống phòng trước khi quyết định. Nếu đang cân nhắc giữa các dự án ven sông, xem bài <a href="/so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula/">so sánh Sun Symphony, Sun Ponte, Peninsula</a>; nếu cho khách nước ngoài thuê, lưu ý quy định khai báo tạm trú tại bài <a href="/cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru/">cho thuê căn hộ Đà Nẵng</a>.</p>
<p>Xem trang dự án <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Sun Ponte đang chuyển nhượng và cho thuê thật, kèm giá cập nhật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Ponte Residence: giá chuyển nhượng, cho thuê 2026',
			'desc'      => 'Sun Ponte Residence cạnh cầu Rồng: 495 căn hộ, chuyển nhượng 70 – 112 triệu/m², thuê 2PN 32 – 40 triệu/tháng (tham khảo 10/2026). Gọi Hoàng Hiệp.',
			'points'    => array(
				'Tòa 26 tầng, 495 căn hộ, 7 penthouse, 26 shophouse; bàn giao từ 3/2026',
				'Chuyển nhượng: studio/1PN 2,96 – 4,49 tỷ, 2PN 4,3 – 6,9 tỷ (tham khảo)',
				'Cho thuê 2PN khoảng 32 – 40 triệu/tháng, cao nhất nhóm ven sông Hàn',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng Sun Ponte Residence bao nhiêu?', 'Tham khảo tháng 10/2026: studio/1PN khoảng 2,96 – 4,49 tỷ, 1PN+ 3,6 – 4,9 tỷ, 2PN 4,3 – 6,9 tỷ, 3PN 5,6 – 10 tỷ.' ),
				array( 'Thuê căn hộ Sun Ponte giá bao nhiêu?', 'Studio khoảng 13 – 20 triệu/tháng, 1PN 20 – 30 triệu, 2PN 32 – 40 triệu theo tin rao.' ),
				array( 'Sun Ponte Residence đã bàn giao chưa?', 'Căn hộ bắt đầu bàn giao từ tháng 3/2026, hoàn tất dự kiến quý 3/2026 theo kế hoạch công bố.' ),
				array( 'The Rio thuộc dự án nào?', 'The Rio là phân khu thấp tầng của Sun Ponte Residence, gồm 41 nhà phố và 16 biệt thự cạnh cầu Rồng.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-sun-ponte-residence-da-nang',
			'https://thuviennhadat.vn/bat-dong-san/gia-ban-sun-ponte-residence-da-nang-gia-can-ho-chung-cu-thang-7-2025-20625.html',
			'https://sunhome.com.vn/ban-can-ho-sun-ponte-residence/',
			'https://vnexpress.net/to-hop-sun-ponte-residence-mat-song-han-sau-2-nam-thi-cong-5078528.html',
			'https://sunponte.vn/shophouse-khoi-de-sun-ponte-residence/',
			'https://viettimes.vn/choang-voi-tien-do-phap-ly-cac-toa-can-ho-sun-group-tai-da-nang-post201185.html',
		),
	);

	$posts[] = array(
		'slug'     => 'peninsula-da-nang-gia-chuyen-nhuong-cho-thue',
		'title'    => 'Peninsula Đà Nẵng: giá chuyển nhượng, giá cho thuê và các loại căn 2026',
		'excerpt'  => 'Peninsula Đà Nẵng (Lê Văn Duyệt, Sơn Trà): khoảng 941 căn 46 – 109 m², chuyển nhượng khoảng 50 – 83 triệu/m², thuê 2PN khoảng 23 – 30 triệu/tháng (tham khảo 10/2026).',
		'keyword'  => 'Peninsula Đà Nẵng',
		'project'  => 'peninsula-da-nang',
		'week'     => 12,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Peninsula Đà Nẵng</strong> là tòa căn hộ 30 tầng của Tập đoàn Đông Đô trên đường Lê Văn Duyệt (Sơn Trà), khu đất có 4 mặt tiền và 3 mặt hướng sông Hàn. Trong nhóm căn hộ ven sông Hàn, Peninsula có mặt bằng giá chuyển nhượng dễ tiếp cận nhất, khoảng 50 – 83 triệu/m² (tham khảo tháng 10/2026). Bài viết tổng hợp giá chuyển nhượng, giá thuê và các loại căn.</p>

<h2>Thông tin nhanh Peninsula Đà Nẵng</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Công ty TNHH Đông Đô Peninsula Đà Nẵng (Tập đoàn Đông Đô)</td></tr>
<tr><td>Vị trí</td><td>Khu A2-1 đường Lê Văn Duyệt, Sơn Trà, khúc cua Lê Văn Duyệt – Trần Hưng Đạo, gần cầu Thuận Phước</td></tr>
<tr><td>Diện tích đất</td><td>7.167,5 m²</td></tr>
<tr><td>Quy mô</td><td>30 tầng, 3 tầng hầm, khoảng 941 căn hộ</td></tr>
<tr><td>Diện tích căn</td><td>Khoảng 46 – 109 m²</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài</td></tr>
<tr><td>Tiến độ</td><td>Khởi công quý 2/2024; các nguồn công bố mốc hoàn thành, bàn giao khác nhau (từ quý 4/2026 đến quý 1/2027) – đối chiếu thông báo của chủ đầu tư</td></tr>
</tbody>
</table>
<p>Kết nối: khoảng 2 phút đến cầu sông Hàn và TTTM Vincom, 5 phút đến cầu Rồng, 5 – 7 phút ra biển Mỹ Khê, 10 – 12 phút đến sân bay. Tiện ích gồm hồ bơi vô cực tầng 30, gym, yoga, spa, thư viện, kid zone, sân vườn, café, siêu thị.</p>

<h2>Các loại căn Peninsula</h2>
<ul>
<li><strong>1 phòng ngủ:</strong> nhóm diện tích nhỏ từ khoảng 46 m², vốn thấp.</li>
<li><strong>2 phòng ngủ:</strong> nhóm giao dịch nhiều nhất, phù hợp gia đình trẻ và cho thuê.</li>
<li><strong>3 phòng ngủ:</strong> diện tích lớn đến khoảng 109 m².</li>
<li><strong>Shophouse khối đế:</strong> 10 căn 2 tầng, hai mặt tiền, tổng diện tích 199 – 269 m², giá chào từ khoảng 79 triệu/m² (tham khảo).</li>
</ul>

<h2>Giá chuyển nhượng Peninsula Đà Nẵng</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá chuyển nhượng tham khảo (10/2026)</th></tr></thead>
<tbody>
<tr><td>1 phòng ngủ</td><td>Khoảng 2,2 – 2,7 tỷ</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 3 – 5 tỷ</td></tr>
<tr><td>3 phòng ngủ</td><td>Khoảng 5,5 – 6,5 tỷ</td></tr>
</tbody>
</table>
<p>Quy đổi khoảng 50 – 83 triệu/m². Vì dự án chưa hoàn tất bàn giao, phần lớn giao dịch là chuyển nhượng hợp đồng mua bán: người mua cần cộng phần tiền còn phải thanh toán cho chủ đầu tư vào tổng giá.</p>

<h2>Giá cho thuê Peninsula Đà Nẵng</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>2 phòng ngủ</td><td>Khoảng 23 – 30 triệu</td></tr>
<tr><td>Mặt bằng chung</td><td>Khoảng 20 – 45 triệu tùy diện tích, view sông Hàn</td></tr>
</tbody>
</table>
<p>Số tin cho thuê còn ít do dự án đang trong giai đoạn hoàn thiện; mặt bằng giá thuê sẽ rõ hơn khi nhiều căn được bàn giao và hoàn thiện nội thất.</p>

<h2>So với các dự án ven sông Hàn khác</h2>
<p>So với Sun Ponte (khoảng 70 – 112 triệu/m²) và Sun Symphony (khoảng 69 – 125 triệu/m²), Peninsula có đơn giá thấp hơn rõ, phù hợp người mua để ở với ngân sách 3 – 5 tỷ vẫn muốn view sông Hàn. Đổi lại là thời gian chờ nhận nhà và quy mô tiện ích gọn trong một tòa. Chi tiết xem bài <a href="/sun-ponte-residence-gia-chuyen-nhuong-cho-thue/">Sun Ponte Residence</a> và <a href="/gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an/">bảng giá chuyển nhượng căn hộ Đà Nẵng 2026</a>.</p>

<h2>Câu hỏi thường gặp</h2>
<h3>Peninsula Đà Nẵng có hồ bơi không?</h3>
<p>Có. Dự án có hồ bơi vô cực ở tầng 30, cùng gym, yoga, spa, thư viện, kid zone, sân vườn và café.</p>
<h3>Mua chuyển nhượng Peninsula phải nộp thuế gì?</h3>
<p>Bên bán phát sinh thuế thu nhập cá nhân 2% trên giá chuyển nhượng; các khoản khác như phí công chứng, lệ phí trước bạ khi cấp sổ do các bên thỏa thuận. Xem bài <a href="/thue-phi-mua-ban-nha-dat-da-nang-2026/">thuế, phí mua bán nhà đất 2026</a>.</p>
<h3>Shophouse Peninsula có bao nhiêu căn?</h3>
<p>10 shophouse khối đế 2 tầng, hai mặt tiền, tổng diện tích 199 – 269 m², giá chào từ khoảng 79 triệu/m² (tham khảo).</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Peninsula là điểm vào hợp lý cho khách muốn sống ven sông Hàn với tổng tiền vừa phải. Với căn chuyển nhượng hợp đồng, anh chị cần xác nhận của chủ đầu tư về số tiền đã nộp, kiểm tra căn có đang thế chấp không và đọc kỹ điều khoản bàn giao trong hợp đồng gốc. Hướng căn cũng quan trọng: căn nhìn trực diện sông và cầu sẽ giữ giá tốt hơn căn hướng phố. Quy trình chi tiết xem bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>.</p>
<p>Xem trang dự án <a href="/du-an/peninsula-da-nang/">Peninsula Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Peninsula đang chuyển nhượng, kèm hướng view và giá cập nhật.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Peninsula Đà Nẵng: giá chuyển nhượng, cho thuê 2026',
			'desc'      => 'Peninsula Đà Nẵng: khoảng 941 căn ven sông Hàn, chuyển nhượng 50 – 83 triệu/m², thuê 2PN 23 – 30 triệu/tháng (tham khảo 10/2026). Gọi Hoàng Hiệp.',
			'points'    => array(
				'Tòa 30 tầng, khoảng 941 căn 46 – 109 m², 4 mặt tiền, 3 mặt hướng sông Hàn',
				'Chuyển nhượng: 1PN 2,2 – 2,7 tỷ, 2PN 3 – 5 tỷ, 3PN 5,5 – 6,5 tỷ (tham khảo)',
				'Cho thuê 2PN khoảng 23 – 30 triệu/tháng; mặt bằng giá mềm nhất nhóm ven sông',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng Peninsula Đà Nẵng bao nhiêu?', 'Tham khảo tháng 10/2026: 1PN khoảng 2,2 – 2,7 tỷ, 2PN 3 – 5 tỷ, 3PN 5,5 – 6,5 tỷ, tương đương khoảng 50 – 83 triệu/m².' ),
				array( 'Thuê căn hộ Peninsula giá bao nhiêu?', 'Căn 2PN khoảng 23 – 30 triệu/tháng; mặt bằng chung khoảng 20 – 45 triệu tùy diện tích và view sông Hàn.' ),
				array( 'Peninsula Đà Nẵng khi nào bàn giao?', 'Các nguồn công bố mốc khác nhau, từ quý 4/2026 đến quý 1/2027; anh chị nên đối chiếu thông báo chính thức của chủ đầu tư.' ),
				array( 'Peninsula Đà Nẵng có bao nhiêu căn?', 'Khoảng 941 căn hộ trong tòa 30 tầng, 3 tầng hầm, cùng 10 shophouse khối đế.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-peninsula-da-nang',
			'https://homedy.com/ban-can-ho-peninsula-da-nang',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-peninsula-da-nang',
			'https://cafeland.vn/du-an/du-an-can-ho-peninsula-da-nang-4522.html',
			'https://thuviennhadat.vn/bat-dong-san/du-an-peninsula-da-nang-da-ban-giao-chua-20575.html',
			'https://thoibaonganhang.vn/shophouse-peninsula-da-nang-tung-chinh-sach-uu-dai-voi-gia-ban-chi-tu-79-trieum2-169394.html',
		),
	);

	$posts[] = array(
		'slug'     => 'hiyori-garden-tower-hiyori-aqua-tower-da-nang',
		'title'    => 'Hiyori Đà Nẵng: Hiyori Garden Tower và Hiyori Aqua Tower – giá, cho thuê, loại căn',
		'excerpt'  => 'Hiyori Đà Nẵng: Hiyori Garden Tower đã bàn giao, 2PN chuyển nhượng khoảng 5 – 6,7 tỷ, thuê 15 – 25 triệu/tháng; Hiyori Aqua Tower 202 căn, dự kiến bàn giao quý 2/2027.',
		'keyword'  => 'Hiyori Đà Nẵng',
		'project'  => 'hiyori-garden-tower',
		'week'     => 12,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>Hiyori Đà Nẵng</strong> là tên gọi chung hai dự án căn hộ chuẩn Nhật Bản của Sun Frontier tại Sơn Trà: <strong>Hiyori Garden Tower</strong> đã bàn giao từ cuối năm 2019 và <strong>HIYORI Aqua Tower</strong> cất nóc tháng 9/2026, dự kiến bàn giao quý 2/2027. Bài viết so sánh hai tòa về loại căn, giá chuyển nhượng, giá bán và giá thuê tham khảo, cập nhật tháng 10/2026.</p>

<h2>So sánh nhanh hai dự án Hiyori</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Hiyori Garden Tower</th><th>HIYORI Aqua Tower</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Lô 2 – A2 Võ Văn Kiệt, Sơn Trà; 4 mặt tiền; cách biển Mỹ Khê khoảng 1 km</td><td>Góc Lê Đức Thọ – Ngô Cao Lãng, Sơn Trà; khoảng 5 phút đi bộ ra biển</td></tr>
<tr><td>Quy mô</td><td>28 tầng nổi, tầng áp mái, 2 tầng hầm</td><td>25 tầng nổi, 2 tầng hầm</td></tr>
<tr><td>Số căn</td><td>306 căn (300 căn 2PN, 6 căn 3PN)</td><td>202 căn (22 căn 1PN, 176 căn 2PN, 3 căn 3PN)</td></tr>
<tr><td>Diện tích phổ biến</td><td>2PN khoảng 65,9 – 70,1 m²</td><td>1PN khoảng 45 m², 2PN khoảng 58 – 74 m², 3PN khoảng 161 m²</td></tr>
<tr><td>Tình trạng</td><td>Bàn giao tháng 12/2019, cư dân đã nhận sổ</td><td>Khởi công 10/9/2024, cất nóc 9/2026, dự kiến bàn giao quý 2/2027</td></tr>
<tr><td>Sở hữu</td><td>Lâu dài</td><td>Lâu dài (người Việt Nam), sổ hồng từng căn</td></tr>
</tbody>
</table>

<h2>Hiyori Garden Tower: căn 2PN đã có sổ</h2>
<p>Hiyori Garden Tower là dự án căn hộ phong cách Nhật đầu tiên của Sun Frontier tại Đà Nẵng, khởi công tháng 5/2017 và bàn giao tháng 12/2019. Gần như toàn bộ là căn 2 phòng ngủ, tiện ích gồm hồ bơi, gym, nhà trẻ tiêu chuẩn Nhật, công viên, khu sinh hoạt cộng đồng, cửa hàng tiện ích.</p>
<h3>Giá chuyển nhượng và cho thuê Hiyori Garden Tower</h3>
<table>
<thead><tr><th>Loại căn</th><th>Chuyển nhượng tham khảo</th><th>Cho thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>2PN (63 – 71 m²)</td><td>Khoảng 5 – 6,7 tỷ</td><td>Khoảng 15 – 25 triệu (phổ biến 18 – 21 triệu); căn view đẹp đến khoảng 28 triệu</td></tr>
</tbody>
</table>
<p>Vì đã có sổ, giao dịch tại Hiyori Garden Tower là mua bán căn hộ thông thường, thủ tục đơn giản hơn chuyển nhượng hợp đồng. Khách thuê chủ yếu là gia đình, chuyên gia muốn ở gần biển với chi phí vừa phải.</p>

<h2>HIYORI Aqua Tower: dự án mới, đang thi công</h2>
<p>HIYORI Aqua Tower (Chung cư Tháp Đại Dương) do Công ty TNHH Aqua Tower làm chủ đầu tư, Sun Frontier Đà Nẵng phát triển; DINCO thi công, Artelia Việt Nam giám sát thi công, ASAI KEN giám sát thiết kế. Tầng trệt bố trí thương mại như siêu thị mini, cà phê; tiện ích gồm hồ bơi, gym, spa, vườn trên cao, vườn thiền, nhà trẻ, phòng sinh hoạt cộng đồng.</p>
<h3>Giá bán HIYORI Aqua Tower</h3>
<table>
<thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>1PN (22 căn)</td><td>Khoảng 45 m²</td><td>Liên hệ</td></tr>
<tr><td>2PN (176 căn)</td><td>Khoảng 58 – 74 m²</td><td>Khoảng 4,5 tỷ cho căn 68 m²</td></tr>
<tr><td>3PN (3 căn)</td><td>Khoảng 161 m²</td><td>Liên hệ</td></tr>
</tbody>
</table>
<p>Mặt bằng giá chào bán khoảng 55 – 75 triệu/m² tùy tầng và view (tham khảo). Dự án chưa bàn giao nên chưa có mặt bằng giá thuê. Lưu ý các trang phân phối nêu dải diện tích khác nhau, cần đối chiếu mặt bằng chính thức.</p>

<h2>Chọn Hiyori Garden hay HIYORI Aqua?</h2>
<ul>
<li><strong>Cần ở hoặc cho thuê ngay, ưu tiên pháp lý hoàn chỉnh:</strong> Hiyori Garden Tower – đã có sổ, có lịch sử cho thuê để kiểm chứng.</li>
<li><strong>Muốn sản phẩm mới, gần biển hơn, chấp nhận chờ đến 2027:</strong> HIYORI Aqua Tower, có thêm lựa chọn căn 1PN vốn thấp.</li>
<li><strong>Cùng ngân sách khoảng 4,5 – 6,7 tỷ:</strong> so sánh căn 2PN cũ đã có sổ với căn 2PN mới chưa bàn giao, tính cả thời gian chờ và chi phí nội thất.</li>
</ul>

<h2>Câu hỏi thường gặp</h2>
<h3>Hiyori Garden Tower có căn 1 phòng ngủ không?</h3>
<p>Hầu như không. Tòa có 306 căn, trong đó 300 căn 2PN và 6 căn 3PN. Nếu cần căn 1PN, HIYORI Aqua Tower có 22 căn khoảng 45 m².</p>
<h3>HIYORI Aqua Tower ai thi công?</h3>
<p>Công ty TNHH Kỹ thuật Xây dựng DINCO thi công, Artelia Việt Nam giám sát thi công, ASAI KEN Architecture Research giám sát thiết kế.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Hai tòa Hiyori phù hợp khách thích phong cách sống yên tĩnh, quy mô nhỏ, gần biển nhưng không nằm trên trục du lịch đông đúc. Với Hiyori Garden Tower, nên kiểm tra kỹ hiện trạng nội thất và thiết bị vì tòa nhà đã vận hành từ 2019. Với HIYORI Aqua Tower, cần đọc kỹ tiến độ thanh toán và điều khoản bàn giao trong hợp đồng. Giá thuê khu gần biển xem bài <a href="/thue-can-ho-bien-my-khe-gia-theo-du-an/">thuê căn hộ biển Mỹ Khê</a>.</p>
<p>Xem trang dự án <a href="/du-an/hiyori-garden-tower/">Hiyori Garden Tower</a> và <a href="/du-an/hiyori-aqua-tower/">HIYORI Aqua Tower</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn Hiyori đang bán, cho thuê và bảng giá HIYORI Aqua Tower mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Hiyori Đà Nẵng: Garden Tower và Aqua Tower – giá 2026',
			'desc'      => 'Hiyori Đà Nẵng: Hiyori Garden Tower 2PN 5 – 6,7 tỷ, thuê 15 – 25 triệu; HIYORI Aqua Tower 202 căn, 2PN khoảng 4,5 tỷ (tham khảo). Gọi Hoàng Hiệp.',
			'points'    => array(
				'Hiyori Garden Tower: 306 căn, bàn giao 12/2019, đã có sổ; 2PN khoảng 5 – 6,7 tỷ',
				'Cho thuê Hiyori Garden 2PN khoảng 15 – 25 triệu/tháng (tham khảo)',
				'HIYORI Aqua Tower: 25 tầng, 202 căn, cất nóc 9/2026, dự kiến bàn giao quý 2/2027',
			),
			'faq'       => array(
				array( 'Hiyori Đà Nẵng gồm những dự án nào?', 'Gồm Hiyori Garden Tower (Võ Văn Kiệt, đã bàn giao 2019) và HIYORI Aqua Tower (Lê Đức Thọ – Ngô Cao Lãng, dự kiến bàn giao quý 2/2027), đều do Sun Frontier phát triển.' ),
				array( 'Giá căn hộ Hiyori Garden Tower bao nhiêu?', 'Tham khảo tháng 10/2026, căn 2PN 63 – 71 m² chuyển nhượng khoảng 5 – 6,7 tỷ.' ),
				array( 'Thuê căn hộ Hiyori Garden Tower giá bao nhiêu?', 'Căn 2PN khoảng 15 – 25 triệu/tháng, phổ biến 18 – 21 triệu; căn view đẹp đến khoảng 28 triệu.' ),
				array( 'HIYORI Aqua Tower giá bao nhiêu?', 'Mặt bằng chào bán khoảng 55 – 75 triệu/m²; căn 2PN 68 m² khoảng 4,5 tỷ (tham khảo). Căn 1PN và 3PN liên hệ.' ),
			),
		),
		'sources'  => array(
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-hiyori-garden-tower',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-hiyori-garden-tower',
			'https://www.nhatot.com/thue-can-ho-chung-cu--hiyori-garden-tower-quan-son-tra-pj1871336036',
			'https://homedy.com/news/review-chi-tiet-chung-cu-hiyori-da-nang-ne6550',
			'https://giagocchudautu.com/hiyori-garden-tower/',
			'https://pmcweb.vn/project/hiyori-garden-tower/',
		),
	);

	$posts[] = array(
		'slug'     => 'the-filmore-da-nang-gia-chuyen-nhuong-cho-thue',
		'title'    => 'The Filmore Đà Nẵng: giá chuyển nhượng, giá cho thuê và các loại căn 2026',
		'excerpt'  => 'The Filmore Đà Nẵng (Bạch Đằng, Hải Châu): 206 căn hạng sang ven sông Hàn, 1PN chuyển nhượng khoảng 4,5 – 7,6 tỷ, thuê 1PN 22 – 27 triệu, 2PN 35 – 40 triệu/tháng (tham khảo 10/2026).',
		'keyword'  => 'The Filmore Đà Nẵng',
		'project'  => 'the-filmore-da-nang',
		'week'     => 12,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p><strong>The Filmore Đà Nẵng</strong> là tòa căn hộ hạng sang 25 tầng trên đường Bạch Đằng (Hải Châu), mặt tiền sông Hàn, chỉ 206 căn, mỗi tầng 9 căn. Tòa nhà đã hoàn thiện năm 2025, người mua nhận nhà ngay. Tham khảo tháng 10/2026: chuyển nhượng khoảng 110 triệu/m², thuê 1PN khoảng 22 – 27 triệu/tháng, 2PN khoảng 35 – 40 triệu/tháng.</p>

<h2>Thông tin nhanh The Filmore</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Chủ đầu tư</td><td>Công ty CP Phát triển Bất động sản Filmore</td></tr>
<tr><td>Tổng thầu / vận hành</td><td>Tập đoàn Xây dựng Delta / CBRE Việt Nam</td></tr>
<tr><td>Vị trí</td><td>Bạch Đằng – Trần Văn Trứ – Bình Minh 5, Hải Châu</td></tr>
<tr><td>Quy mô</td><td>Đất khoảng 1.504 m², 25 tầng nổi, 3 tầng hầm</td></tr>
<tr><td>Số căn</td><td>206 căn (9 căn/tầng điển hình), khoảng 300 m² sàn thương mại</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài (người Việt Nam)</td></tr>
<tr><td>Tình trạng</td><td>Hoàn thiện 2025, bàn giao ngay, nội thất cao cấp</td></tr>
</tbody>
</table>
<p>Từ dự án đi bộ ra sông Hàn khoảng 1 phút; cầu Rồng, công viên APEC khoảng 3 phút; chợ Hàn khoảng 5 phút; biển Mỹ Khê khoảng 7 phút; sân bay khoảng 10 phút. Tiện ích gồm hồ bơi người lớn và trẻ em, gym, thư viện, phòng rượu vang và xì gà, khu vui chơi trẻ em cùng hơn 25 dịch vụ cư dân do CBRE quản lý.</p>

<h2>Các loại căn The Filmore</h2>
<table>
<thead><tr><th>Loại căn</th><th>Số căn</th><th>Diện tích</th><th>Giá chủ đầu tư tham khảo</th></tr></thead>
<tbody>
<tr><td>1 phòng ngủ</td><td>75</td><td>48,09 – 49,98 m²</td><td>Khoảng 5,5 – 6 tỷ</td></tr>
<tr><td>2 phòng ngủ</td><td>106</td><td>71,18 – 80,54 m²</td><td>Khoảng 8,2 – 9,3 tỷ</td></tr>
<tr><td>Dual Key</td><td>12</td><td>70,27 m²</td><td>Liên hệ</td></tr>
<tr><td>Sky Terrace (có sân vườn)</td><td>9</td><td>48,09 – 80,54 m²</td><td>Liên hệ</td></tr>
<tr><td>Loft 3PN thông tầng</td><td>4</td><td>122,6 m²</td><td>Khoảng 14,2 – 14,5 tỷ</td></tr>
<tr><td>Penthouse</td><td>–</td><td>Khoảng 206 m²</td><td>Từ khoảng 44,9 tỷ</td></tr>
</tbody>
</table>
<p>Căn Dual Key chia thành hai không gian độc lập trong một căn, thuận tiện vừa ở vừa cho thuê hoặc cho thuê tách hai phần.</p>

<h2>Giá chuyển nhượng The Filmore</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá chuyển nhượng tham khảo (10/2026)</th></tr></thead>
<tbody>
<tr><td>1PN (48 – 50 m²)</td><td>Khoảng 4,5 – 7,6 tỷ</td></tr>
<tr><td>2PN (71 – 81 m²)</td><td>Khoảng 8,3 – 9,3 tỷ</td></tr>
</tbody>
</table>
<p>Quy đổi khoảng 110 triệu/m², trong khi giá chào của chủ đầu tư khoảng 130 – 150 triệu/m². Khoảng giá chuyển nhượng rộng phụ thuộc tầng, hướng nhìn sông Hàn – cầu Rồng hay hướng phố.</p>

<h2>Giá cho thuê The Filmore</h2>
<table>
<thead><tr><th>Loại căn</th><th>Giá thuê tham khảo/tháng</th></tr></thead>
<tbody>
<tr><td>1 phòng ngủ</td><td>Khoảng 22 – 27 triệu</td></tr>
<tr><td>2 phòng ngủ</td><td>Khoảng 35 – 40 triệu</td></tr>
<tr><td>3 phòng ngủ view sông Hàn</td><td>Đến khoảng 95 triệu</td></tr>
</tbody>
</table>
<p>Khách thuê nhóm này thường là chuyên gia, lãnh đạo doanh nghiệp, người nước ngoài cần nơi ở trung tâm, dịch vụ quản lý chuyên nghiệp. Với khách nước ngoài, chủ nhà cần khai báo tạm trú ngay khi khách đến theo quy định mới – xem bài <a href="/cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru/">cho thuê căn hộ Đà Nẵng</a>.</p>

<h2>Câu hỏi thường gặp</h2>
<h3>Căn Dual Key của The Filmore là gì?</h3>
<p>Là căn 70,27 m² chia thành hai không gian độc lập trong cùng một căn, có thể ở một phần và cho thuê phần còn lại, hoặc cho thuê tách hai phần. Dự án có 12 căn loại này.</p>
<h3>Người nước ngoài có mua được The Filmore không?</h3>
<p>Dự án được giới thiệu sở hữu lâu dài cho người Việt Nam. Với người nước ngoài, thời hạn và điều kiện sở hữu theo Luật Nhà ở 2023 – cần hỏi chủ đầu tư về số căn còn trong giới hạn cho người nước ngoài.</p>
<h3>Mua căn The Filmore chuyển nhượng cần lưu ý gì?</h3>
<p>Kiểm tra sổ hoặc hợp đồng gốc, danh mục nội thất bàn giao và phí quản lý. Quy trình xem bài <a href="/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/">mua căn hộ chuyển nhượng Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>The Filmore phù hợp khách mua để ở lâu dài hoặc giữ tài sản ở vị trí trung tâm, nơi quỹ đất ven sông Hàn cho dự án căn hộ mới gần như không còn. Vì đơn giá thuộc nhóm cao nhất Đà Nẵng, lợi suất cho thuê tính trên giá mua sẽ không lớn; anh chị nên xem đây là tài sản giữ giá hơn là sản phẩm tối ưu dòng tiền. Khi mua chuyển nhượng, nên so sánh với giá chào trực tiếp từ chủ đầu tư cho cùng loại căn trước khi quyết định. Đối chiếu với các dự án khác tại bài <a href="/gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an/">giá chuyển nhượng căn hộ Đà Nẵng 2026</a> hoặc <a href="/can-ho-view-song-han-du-an-va-gia/">căn hộ view sông Hàn</a>.</p>
<p>Xem trang dự án <a href="/du-an/the-filmore-da-nang/">The Filmore Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn The Filmore đang chuyển nhượng, cho thuê và bảng giá chủ đầu tư mới nhất.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'The Filmore Đà Nẵng: giá chuyển nhượng, cho thuê 2026',
			'desc'      => 'The Filmore Đà Nẵng: 206 căn hạng sang ven sông Hàn, chuyển nhượng 1PN 4,5 – 7,6 tỷ, thuê 2PN 35 – 40 triệu/tháng (tham khảo 10/2026). Gọi Hoàng Hiệp.',
			'points'    => array(
				'25 tầng, 206 căn, 9 căn/tầng; Delta thi công, CBRE vận hành; hoàn thiện 2025',
				'Chuyển nhượng 1PN khoảng 4,5 – 7,6 tỷ, 2PN 8,3 – 9,3 tỷ (≈ 110 triệu/m²)',
				'Cho thuê 1PN 22 – 27 triệu, 2PN 35 – 40 triệu, 3PN view sông đến 95 triệu/tháng',
			),
			'faq'       => array(
				array( 'Giá chuyển nhượng The Filmore Đà Nẵng bao nhiêu?', 'Tham khảo tháng 10/2026: 1PN khoảng 4,5 – 7,6 tỷ, 2PN 8,3 – 9,3 tỷ, tương đương khoảng 110 triệu/m².' ),
				array( 'Thuê căn hộ The Filmore giá bao nhiêu?', '1PN khoảng 22 – 27 triệu/tháng, 2PN 35 – 40 triệu, căn 3PN view sông Hàn đến khoảng 95 triệu theo tin rao.' ),
				array( 'The Filmore có bao nhiêu căn hộ?', '206 căn gồm 75 căn 1PN, 106 căn 2PN, 12 căn Dual Key, 9 căn Sky Terrace, 4 căn Loft 3PN và penthouse.' ),
				array( 'The Filmore đã bàn giao chưa?', 'Tòa nhà hoàn thiện năm 2025, sẵn sàng bàn giao, người mua nhận nhà ở ngay.' ),
			),
		),
		'sources'  => array(
			'https://www.filmoredanang.vn/',
			'https://cafeland.vn/du-an/can-ho-the-filmore-da-nang-3101.html',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang',
			'https://homedy.com/ban-can-ho-the-filmore-da-nang',
			'https://batdongsan.com.vn/cho-thue-can-ho-chung-cu-the-filmore-da-nang',
			'https://alonhadat.com.vn/cho-thue-can-ho-chung-cu/p10127/the-filmore-da-nang.html',
		),
	);

	return $posts;
}
