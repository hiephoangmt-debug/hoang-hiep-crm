<?php
/**
 * Tin hạ tầng – thị trường đầu tháng 10/2026 (bảng giá đất sửa đổi, đường tránh Nam Hải Vân, bản tin hạ tầng).
 * Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài và đăng ngay, ảnh đại diện lấy từ img/tin-tuc/.
 * Chỉ ghi thông tin có nguồn báo chí; điểm các báo nêu khác nhau được ghi rõ trong bài.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_thang_10_2026' );
function hh_posts_thang_10_2026( $posts ) {
	$posts[] = array(
		'slug'      => 'bang-gia-dat-da-nang-sua-doi-2026',
		'title'     => 'Bảng giá đất Đà Nẵng sửa đổi 2026: điểm mới người mua nhà đất cần biết',
		'excerpt'   => 'HĐND TP Đà Nẵng xem xét, thông qua sửa đổi Nghị quyết 28/2026 về bảng giá đất tại kỳ họp ngày 6/10/2026: bổ sung giá cho tuyến đường chưa có giá, cách tính thửa đất nằm ở nhiều vị trí. Ảnh hưởng gì đến người mua bán nhà đất?',
		'keyword'   => 'bảng giá đất Đà Nẵng',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-09 07:00:00',
		'image'     => 'plugin:img/tin-tuc/bang-gia-dat-da-nang-sua-doi-2026.jpg',
		'image_alt' => 'Bảng giá đất Đà Nẵng sửa đổi 2026 – các điểm mới chính',
		'content'   => <<<'HTML'
<p><strong>Bảng giá đất Đà Nẵng</strong> đang được điều chỉnh chỉ vài tháng sau khi áp dụng. Tại kỳ họp thứ 6 (chuyên đề) ngày 6/10/2026, HĐND TP Đà Nẵng khóa XI xem xét sửa đổi, bổ sung Nghị quyết 28/2026/NQ-HĐND quy định giá đất và bảng giá các loại đất. Lý do: qua rà soát, <strong>37/94 xã, phường</strong> đề nghị điều chỉnh, bổ sung giá đất.</p>
<p>Bảng giá đất không phải giá mua bán ngoài thị trường, nhưng là căn cứ tính tiền sử dụng đất, thuế, phí trước bạ, bồi thường khi thu hồi đất. Vì vậy, người đang mua bán, chuyển mục đích hay làm sổ ở Đà Nẵng nên nắm những thay đổi dưới đây.</p>

<h2>Bảng giá đất Đà Nẵng hiện hành là gì?</h2>
<p>Nghị quyết 28/2026/NQ-HĐND của HĐND TP Đà Nẵng quy định giá đất và bảng giá các loại đất trên địa bàn thành phố sau hợp nhất, có hiệu lực từ ngày 10/6/2026. Đây là bảng giá áp dụng chung cho cả khu vực Đà Nẵng cũ và Quảng Nam cũ.</p>
<p>Sau khi triển khai, nhiều địa phương phát hiện các vị trí, tuyến đường, đoạn đường <strong>chưa có giá</strong> trong phụ lục, hoặc tên đường, mức giá cần chỉnh lại. Đó là lý do bảng giá được đưa ra sửa đổi ngay trong năm.</p>

<h2>Những điểm mới trong lần sửa đổi</h2>
<p>Theo thông tin báo chí về nội dung trình kỳ họp, lần sửa đổi tập trung vào:</p>
<table>
<thead><tr><th>Nội dung</th><th>Điểm mới</th></tr></thead>
<tbody>
<tr><td>Tuyến đường chưa có giá</td><td>Bổ sung cách xử lý, bổ sung giá đất phi nông nghiệp cho các vị trí, tuyến, đoạn đường chưa được quy định giá</td></tr>
<tr><td>Thửa đất nằm ở nhiều vị trí</td><td>Giá đất xác định theo <strong>bình quân gia quyền</strong> theo tỷ lệ diện tích của từng vị trí</td></tr>
<tr><td>Phụ lục bảng giá</td><td>Sửa đổi giá đất, tên tuyến đường tại một số phụ lục</td></tr>
<tr><td>Đất chăn nuôi tập trung</td><td>Bổ sung giá, bằng giá đất trồng cây hằng năm</td></tr>
<tr><td>Thuê đất</td><td>Quy định tỷ lệ tính đơn giá thuê đất, thuê đất xây công trình ngầm, đất có mặt nước</td></tr>
</tbody>
</table>
<p>Cùng kỳ họp, HĐND cũng xem xét bổ sung danh mục dự án thu hồi đất năm 2026 tại các xã, phường.</p>

<h2>Đã thông qua chưa?</h2>
<p>Kỳ họp ngày 6/10/2026 đã thông qua 22 nghị quyết. Một số báo (như CafeLand) đưa tin HĐND đã thông qua nghị quyết sửa đổi bảng giá đất; các báo khác mô tả nội dung ở bước trình và thảo luận. Mức giá cụ thể từng tuyến đường chỉ chắc chắn khi nghị quyết sửa đổi được công bố toàn văn kèm phụ lục. <em>Hoàng Hiệp sẽ cập nhật số hiệu nghị quyết và ngày hiệu lực khi có văn bản chính thức.</em></p>

<h2>Ảnh hưởng gì đến người mua bán nhà đất?</h2>
<ul>
<li><strong>Nhà đất trên tuyến đường mới, chưa có giá:</strong> trước đây khó xác định nghĩa vụ tài chính khi sang tên, chuyển mục đích. Khi tuyến được bổ sung giá, thủ tục sẽ rõ ràng hơn.</li>
<li><strong>Lô đất góc, lô đất sâu, nằm qua nhiều vị trí:</strong> cách tính bình quân gia quyền giúp giá tính thuế, phí sát với thực tế hơn, tránh tính toàn bộ diện tích theo vị trí giá cao nhất.</li>
<li><strong>Người chuẩn bị chuyển mục đích sang đất ở:</strong> nên chờ phụ lục chính thức để tính tiền sử dụng đất chính xác, tránh tính sai dòng tiền.</li>
<li><strong>Người có đất trong danh mục thu hồi 2026:</strong> bảng giá đất là một căn cứ quan trọng khi tính bồi thường – kiểm tra kỹ danh mục và phương án.</li>
</ul>
<p>Lưu ý: bảng giá đất tăng hay giảm không làm giá giao dịch thay đổi ngay, nhưng ảnh hưởng trực tiếp đến chi phí thuế, phí của người mua bán.</p>

<h2>Cách tra giá đất và kiểm tra pháp lý trước khi mua</h2>
<ol>
<li>Tra tuyến đường, vị trí thửa đất trong phụ lục Nghị quyết 28/2026 và nghị quyết sửa đổi (khi được công bố).</li>
<li>Kiểm tra quy hoạch sử dụng đất, thông tin thửa đất tại UBND xã, phường hoặc văn phòng đăng ký đất đai.</li>
<li>Tính trước thuế thu nhập cá nhân, lệ phí trước bạ, tiền sử dụng đất (nếu chuyển mục đích) để không bị bất ngờ.</li>
</ol>
<p>Xem thêm hướng dẫn <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>, bài <a href="/toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san/">toàn cảnh hạ tầng Đà Nẵng 2026</a>, hoặc danh sách <a href="/mua-ban/dat-nen/">đất nền đang bán</a>.</p>
<p>Anh chị cần tính nhanh chi phí sang tên hoặc kiểm tra một lô đất cụ thể, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong>.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Bảng giá đất Đà Nẵng sửa đổi 2026: điểm mới cần biết',
			'desc'      => 'Bảng giá đất Đà Nẵng sửa đổi tại kỳ họp HĐND 6/10/2026: bổ sung giá tuyến đường chưa có giá, thửa nhiều vị trí tính bình quân gia quyền. Ảnh hưởng gì?',
			'points'    => array(
				'HĐND TP Đà Nẵng xem xét sửa đổi Nghị quyết 28/2026 về bảng giá đất tại kỳ họp ngày 6/10/2026.',
				'37/94 xã, phường đề nghị điều chỉnh, bổ sung giá đất.',
				'Bổ sung giá cho tuyến đường chưa có giá; thửa đất nằm ở nhiều vị trí tính theo bình quân gia quyền.',
				'Mức giá từng tuyến chỉ chắc chắn khi nghị quyết sửa đổi được công bố toàn văn.',
			),
			'faq'       => array(
				array( 'Bảng giá đất Đà Nẵng hiện hành theo văn bản nào?', 'Nghị quyết 28/2026/NQ-HĐND của HĐND TP Đà Nẵng quy định giá đất và bảng giá các loại đất, có hiệu lực từ ngày 10/6/2026; đang được sửa đổi, bổ sung tại kỳ họp ngày 6/10/2026.' ),
				array( 'Vì sao bảng giá đất Đà Nẵng phải sửa đổi?', 'Qua rà soát, 37/94 xã, phường đề nghị điều chỉnh, bổ sung giá; nhiều vị trí, tuyến đường chưa có giá hoặc cần sửa tên đường, mức giá trong phụ lục.' ),
				array( 'Thửa đất nằm ở nhiều vị trí tính giá thế nào?', 'Theo nội dung sửa đổi, giá đất của thửa được xác định theo bình quân gia quyền theo tỷ lệ diện tích từng vị trí.' ),
				array( 'Bảng giá đất có phải giá mua bán thị trường không?', 'Không. Bảng giá đất là căn cứ tính tiền sử dụng đất, thuế, phí, bồi thường; giá giao dịch thực tế do thị trường quyết định.' ),
			),
		),
		'sources'   => array(
			'https://cafeland.vn/tin-tuc/da-nang-sua-bang-gia-dat-bo-sung-cach-tinh-cho-loat-tuyen-duong-chua-co-gia-155669.html',
			'https://danviet.vn/da-nang-hdnd-hop-chuyen-de-nong-chuyen-gia-dat-va-sap-xep-dan-cu-vung-thien-tai-d1465010.html',
			'https://tienphong.vn/37-xa-phuong-cua-da-nang-de-nghi-sua-bang-gia-dat-moi-post1882606.tpo',
			'https://luatvietnam.vn/dat-dai/nghi-quyet-28-2026-nq-hdnd-da-nang-quy-dinh-gia-dat-va-bang-gia-cac-loai-dat-437159-d2.html',
		),
	);

	$posts[] = array(
		'slug'      => 'duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu',
		'title'     => 'Đường tránh Nam Hải Vân mở rộng 6 làn hơn 1.951 tỷ: Liên Chiểu thêm trục kết nối cảng',
		'excerpt'   => 'Đà Nẵng phê duyệt dự án nâng cấp, mở rộng đường tránh Nam Hải Vân đoạn Hòa Liên – đường ven biển nối cảng Liên Chiểu, khoảng 5,36 km, 6 làn xe, tổng mức hơn 1.951 tỷ đồng. Ý nghĩa với khu vực Liên Chiểu – Hải Vân.',
		'keyword'   => 'đường tránh Nam Hải Vân',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-09 07:15:00',
		'image'     => 'plugin:img/tin-tuc/duong-tranh-nam-hai-van-6-lan.jpg',
		'image_alt' => 'Thông tin dự án mở rộng đường tránh Nam Hải Vân 6 làn, Liên Chiểu, Đà Nẵng',
		'content'   => <<<'HTML'
<p><strong>Đường tránh Nam Hải Vân</strong> – trục nối hầm Hải Vân với cao tốc và khu Liên Chiểu – sẽ được nâng cấp lên 6 làn xe. UBND TP Đà Nẵng đã phê duyệt dự án đoạn từ nút giao Hòa Liên đến nút giao với đường ven biển nối cảng Liên Chiểu, tổng mức đầu tư hơn 1.951 tỷ đồng (Quyết định 2839/QĐ-UBND). Đây là một mảnh ghép quan trọng để hàng hóa ra vào cảng Liên Chiểu không phải đi xuyên khu dân cư.</p>

<h2>Thông tin chính về dự án</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Phạm vi</td><td>Từ nút giao Hòa Liên đến nút giao đường ven biển nối cảng Liên Chiểu</td></tr>
<tr><td>Chiều dài</td><td>Khoảng 5,36 km</td></tr>
<tr><td>Quy mô</td><td>6 làn xe cơ giới, vận tốc thiết kế 80 km/h, nền đường rộng 27,5 m</td></tr>
<tr><td>Công trình cầu</td><td>Mở rộng, cải tạo cầu Thượng Nam Ô, cầu Thủy Tú, cầu vượt ĐT.601</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 1.951 tỷ đồng, ngân sách thành phố (chủ trương đầu tư trước đó khoảng 1.965 tỷ đồng)</td></tr>
<tr><td>Chủ đầu tư</td><td>Ban QLDA đầu tư cơ sở hạ tầng ưu tiên TP Đà Nẵng</td></tr>
<tr><td>Thời gian thực hiện</td><td>Giai đoạn 2025 – 2029</td></tr>
</tbody>
</table>

<h2>Vì sao phải mở rộng đường tránh Nam Hải Vân?</h2>
<p>Cảng Liên Chiểu đã hoàn thành phần hạ tầng dùng chung giai đoạn 1 (hơn 3.426 tỷ đồng) và đang triển khai bến container theo quy hoạch dài hạn đến năm 2036. Khi cảng vận hành, lượng xe container tăng mạnh. Tuyến đường tránh hiện hữu hẹp, nhiều đoạn giao cắt, khó đáp ứng. Mở rộng 6 làn giúp:</p>
<ul>
<li>Kết nối thẳng cảng Liên Chiểu với cao tốc và hầm Hải Vân, giảm xe tải đi vào nội đô.</li>
<li>Phục vụ khu thương mại tự do Đà Nẵng và các khu công nghiệp phía Tây Bắc.</li>
<li>Tăng an toàn giao thông cho cư dân Hòa Hiệp, Hòa Liên, Nam Ô.</li>
</ul>
<p>Theo Dân Việt, HĐND thành phố cũng đã thông qua việc chuyển mục đích hơn 32 ha đất rừng để thực hiện dự án nâng cấp Quốc lộ 14D và mở rộng đường tránh Nam Hải Vân – điều kiện cần để triển khai mặt bằng.</p>

<h2>Bất động sản Liên Chiểu – Hải Vân được gì?</h2>
<p>Liên Chiểu đang là khu vực có nhiều hạ tầng lớn nhất Đà Nẵng: cảng Liên Chiểu, khu thương mại tự do, đường ven biển nối cảng, nay thêm đường tránh 6 làn. Với người mua nhà đất, có thể chia thành hai nhóm:</p>
<ul>
<li><strong>Nhà ở cho chuyên gia, người lao động:</strong> căn hộ, nhà phố gần khu công nghiệp, cảng có nhu cầu thuê ổn định khi cảng và khu thương mại tự do đi vào hoạt động.</li>
<li><strong>Đô thị nghỉ dưỡng phía Hải Vân:</strong> các dự án như <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a> (khu Làng Vân) hưởng lợi khi kết nối về trung tâm và sân bay nhanh, ít xe tải hơn.</li>
</ul>
<p>Lưu ý: dự án làm đến năm 2029, thời gian thi công sẽ có phân luồng, bụi, tiếng ồn. Lô đất sát tuyến cần kiểm tra mốc giới, phạm vi mở rộng trước khi mua.</p>
<p>Xem thêm: <a href="/cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu/">cảng Liên Chiểu và khu thương mại tự do</a>, <a href="/khu-vuc/lien-chieu/">dự án khu vực Liên Chiểu</a>, <a href="/mua-ban/lien-chieu/">nhà đất Liên Chiểu đang bán</a>.</p>
<p>Anh chị quan tâm nhà đất Liên Chiểu – Hải Vân, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong> để được gửi thông tin pháp lý, giá tham khảo.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Đường tránh Nam Hải Vân 6 làn hơn 1.951 tỷ và BĐS Liên Chiểu',
			'desc'      => 'Đường tránh Nam Hải Vân mở rộng 6 làn, 5,36 km từ Hòa Liên đến đường nối cảng Liên Chiểu, hơn 1.951 tỷ đồng, làm 2025 – 2029. Tác động BĐS Liên Chiểu.',
			'points'    => array(
				'Đoạn Hòa Liên – đường ven biển nối cảng Liên Chiểu, khoảng 5,36 km, 6 làn xe, 80 km/h.',
				'Tổng mức hơn 1.951 tỷ đồng (Quyết định 2839/QĐ-UBND), thực hiện 2025 – 2029.',
				'Mở rộng cầu Thượng Nam Ô, cầu Thủy Tú, cầu vượt ĐT.601.',
				'Kết nối cảng Liên Chiểu với cao tốc, giảm xe tải vào nội đô.',
			),
			'faq'       => array(
				array( 'Đường tránh Nam Hải Vân mở rộng đoạn nào?', 'Đoạn từ nút giao Hòa Liên đến nút giao với đường ven biển nối cảng Liên Chiểu, dài khoảng 5,36 km.' ),
				array( 'Dự án mở rộng đường tránh Nam Hải Vân tốn bao nhiêu tiền?', 'Tổng mức đầu tư hơn 1.951 tỷ đồng từ ngân sách thành phố theo Quyết định 2839/QĐ-UBND; quyết định chủ trương trước đó ghi khoảng 1.965 tỷ đồng.' ),
				array( 'Khi nào đường tránh Nam Hải Vân 6 làn hoàn thành?', 'Dự án thực hiện trong giai đoạn 2025 – 2029.' ),
				array( 'Dự án ảnh hưởng thế nào đến bất động sản Liên Chiểu?', 'Tăng kết nối cảng Liên Chiểu, khu thương mại tự do với cao tốc; hỗ trợ nhu cầu nhà ở, nhà cho thuê và các đô thị nghỉ dưỡng phía Hải Vân. Lô đất sát tuyến cần kiểm tra phạm vi mở rộng.' ),
			),
		),
		'sources'   => array(
			'https://baodautu.vn/da-nang-hon-1951-ty-dong-nang-cap-mo-rong-duong-tranh-nam-hai-van-d646622.html',
			'https://doanhnhan.baophapluat.vn/da-nang-chi-gan-2-000-ty-dong-nang-cap-mo-rong-duong-tranh-nam-hai-van.html',
			'https://danviet.vn/da-nang-hon-32ha-dat-rung-duoc-chuyen-doi-mo-duong-ket-noi-cua-khau-quoc-te-va-cang-lien-chieu-d1465075.html',
			'https://tuoitre.vn/plo/vi-sao-da-nang-lui-tien-do-hoan-thanh-cang-lien-chieu-hon-3400-ti-post884372.html',
		),
	);

	$posts[] = array(
		'slug'      => 'tin-ha-tang-da-nang-thang-10-2026',
		'title'     => 'Tin hạ tầng Đà Nẵng tháng 10/2026: cầu Hòa Xuân, Quốc lộ 14D, vành đai phía Bắc và tác động bất động sản',
		'excerpt'   => 'Tổng hợp tin hạ tầng Đà Nẵng đầu tháng 10/2026: cụm nút giao cầu Hòa Xuân đã khởi công, Quốc lộ 14D đang thi công, vành đai phía Bắc Quảng Nam thi công lại, HĐND điều chỉnh kế hoạch đầu tư công. Khu vực bất động sản nào cần theo dõi.',
		'keyword'   => 'tin hạ tầng Đà Nẵng',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-09 07:30:00',
		'image'     => 'plugin:img/tin-tuc/tin-ha-tang-da-nang-thang-10-2026.jpg',
		'image_alt' => 'Tin hạ tầng Đà Nẵng tháng 10/2026 – các công trình đang triển khai',
		'content'   => <<<'HTML'
<p>Bản <strong>tin hạ tầng Đà Nẵng</strong> đầu tháng 10/2026 tổng hợp các công trình giao thông đang thi công, sắp thi công và các quyết định mới của thành phố – kèm nhận định ngắn về khu vực bất động sản chịu tác động. Thông tin lấy từ báo chí chính thống; mục nào còn ở dạng kế hoạch, đề xuất được ghi rõ.</p>

<h2>Bảng tóm tắt</h2>
<table>
<thead><tr><th>Công trình</th><th>Tình trạng (đầu 10/2026)</th><th>Khu vực BĐS liên quan</th></tr></thead>
<tbody>
<tr><td>Cụm nút giao cầu Hòa Xuân (hơn 1.378 tỷ)</td><td>Đã khởi công 25/8/2026, thi công dự kiến 730 ngày</td><td>Hòa Xuân, Nam Hòa Xuân, Cẩm Lệ</td></tr>
<tr><td>Quốc lộ 14D (4.518 tỷ, 65,37 km)</td><td>Đã khởi công 26/6/2026</td><td>Phía Tây, Nam Giang</td></tr>
<tr><td>Đường vành đai phía Bắc Quảng Nam (~498 tỷ, 4,6 km)</td><td>Thành phố yêu cầu thi công trong tháng 10/2026, xong tháng 5/2027</td><td>Điện Bàn Bắc, Điện Ngọc</td></tr>
<tr><td>Đường tránh Nam Hải Vân 6 làn (hơn 1.951 tỷ)</td><td>Đã phê duyệt dự án, làm 2025 – 2029</td><td>Liên Chiểu – Hải Vân</td></tr>
<tr><td>Kế hoạch đầu tư công trung hạn 2026 – 2030</td><td>HĐND điều chỉnh, bổ sung tại kỳ họp 6/10/2026</td><td>Toàn thành phố</td></tr>
</tbody>
</table>

<h2>1. Cụm nút giao cầu Hòa Xuân đã khởi công</h2>
<p>Sáng 25/8/2026, Đà Nẵng khởi công cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn cầu Hòa Xuân, sớm hơn mốc tháng 10 từng công bố. Dự án gồm hầm chui trên đường Cách Mạng Tháng Tám, hầm chui trên đường Thăng Long, mở rộng Lê Thanh Nghị và thêm một đơn nguyên cầu mới phía hạ lưu. Thời gian thi công dự kiến 730 ngày. Chi tiết: <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao cầu Hòa Xuân và bất động sản Nam Đà Nẵng</a>.</p>
<p><strong>Với người mua nhà:</strong> các dự án phía Nam như <a href="/du-an/sun-neo-city/">Sun NeO City</a>, <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a> sẽ kết nối trung tâm tốt hơn khi nút giao hoàn thành; trong thời gian thi công, giờ cao điểm qua cầu sẽ chậm hơn.</p>

<h2>2. Quốc lộ 14D đang thi công</h2>
<p>Dự án cải tạo, nâng cấp Quốc lộ 14D dài 65,37 km, tổng mức đầu tư 4.518 tỷ đồng, đã khởi công ngày 26/6/2026, nối đường Hồ Chí Minh với khu vực cửa khẩu quốc tế Nam Giang. Đây là trục giao thương phía Tây của thành phố sau hợp nhất, tác động chủ yếu đến kinh tế vùng biên, logistics hơn là nhà ở đô thị.</p>

<h2>3. Đường vành đai phía Bắc Quảng Nam được yêu cầu thi công trong tháng 10</h2>
<p>Tuyến dài hơn 4,6 km, tổng mức gần 500 tỷ đồng, đi từ cầu Quảng Đà ra biển Điện Ngọc. Dự án từng khởi công năm 2024 nhưng chậm do vướng mặt bằng và vật liệu đắp. Chủ tịch UBND TP Đà Nẵng yêu cầu thi công trong tháng 10/2026 ở phần đã giải phóng mặt bằng, phấn đấu hoàn thành toàn bộ vào tháng 5/2027. Đến thời điểm viết bài, chưa có thông tin xác nhận đã thi công lại.</p>
<p><strong>Với người mua nhà:</strong> trục này nối Điện Ngọc, Điện Bàn Bắc với Đà Nẵng qua cầu Quảng Đà – đáng theo dõi với đất nền vùng giáp ranh. Xem <a href="/hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh/">bất động sản vùng giáp ranh sau hợp nhất</a>.</p>

<h2>4. Đường tránh Nam Hải Vân mở rộng 6 làn</h2>
<p>Đoạn Hòa Liên – đường ven biển nối cảng Liên Chiểu dài khoảng 5,36 km, mở rộng 6 làn, tổng mức hơn 1.951 tỷ đồng, thực hiện 2025 – 2029. Chi tiết: <a href="/duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu/">đường tránh Nam Hải Vân 6 làn và bất động sản Liên Chiểu</a>.</p>

<h2>5. HĐND điều chỉnh kế hoạch đầu tư công, sửa bảng giá đất</h2>
<p>Ngày 6/10/2026, kỳ họp thứ 6 (chuyên đề) HĐND TP Đà Nẵng khóa XI thông qua 22 nghị quyết, trong đó có điều chỉnh, bổ sung kế hoạch vốn đầu tư công trung hạn 2026 – 2030; đồng thời xem xét sửa đổi bảng giá đất theo Nghị quyết 28/2026. Xem: <a href="/bang-gia-dat-da-nang-sua-doi-2026/">bảng giá đất Đà Nẵng sửa đổi 2026</a>.</p>
<p>Trước đó, ngày 11/9/2026, Sở Xây dựng đề xuất nghiên cứu một cầu mới qua sông Hàn, phấn đấu khởi công trước năm 2030 – hiện vẫn ở giai đoạn đề xuất, chưa có quyết định đầu tư.</p>

<h2>Nhận định cho người mua bất động sản</h2>
<ul>
<li><strong>Ưu tiên hạ tầng đã khởi công:</strong> cầu Hòa Xuân, Quốc lộ 14D đã thi công thật; tác động đến khu vực xung quanh rõ ràng hơn các dự án còn ở dạng đề xuất.</li>
<li><strong>Tính thời gian:</strong> các công trình phần lớn hoàn thành giai đoạn 2027 – 2029; nên chọn tài sản ở hoặc cho thuê được ngay, coi hạ tầng là điểm cộng.</li>
<li><strong>Kiểm tra pháp lý, quy hoạch:</strong> nhất là lô đất gần nút giao, tuyến mở rộng. Xem <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">cách kiểm tra quy hoạch nhà đất Đà Nẵng</a>.</li>
</ul>
<p>Tổng quan cả năm: <a href="/toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san/">toàn cảnh hạ tầng Đà Nẵng 2026</a>. Cần tư vấn dự án theo khu vực, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong>.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Tin hạ tầng Đà Nẵng tháng 10/2026: công trình và BĐS',
			'desc'      => 'Tin hạ tầng Đà Nẵng tháng 10/2026: cầu Hòa Xuân đã khởi công, Quốc lộ 14D thi công, vành đai phía Bắc Quảng Nam, đường tránh Nam Hải Vân và tác động BĐS.',
			'points'    => array(
				'Cụm nút giao cầu Hòa Xuân đã khởi công ngày 25/8/2026, thi công dự kiến 730 ngày.',
				'Quốc lộ 14D (4.518 tỷ đồng, 65,37 km) đã khởi công ngày 26/6/2026.',
				'Vành đai phía Bắc Quảng Nam: thành phố yêu cầu thi công trong tháng 10/2026, xong tháng 5/2027.',
				'HĐND ngày 6/10/2026 điều chỉnh kế hoạch đầu tư công 2026 – 2030, xem xét sửa bảng giá đất.',
			),
			'faq'       => array(
				array( 'Cầu Hòa Xuân khởi công chưa?', 'Đã khởi công ngày 25/8/2026, gồm hầm chui Cách Mạng Tháng Tám, hầm chui Thăng Long, mở rộng Lê Thanh Nghị và cầu mới phía hạ lưu; thi công dự kiến 730 ngày.' ),
				array( 'Đường vành đai phía Bắc Quảng Nam bao giờ xong?', 'UBND TP Đà Nẵng yêu cầu thi công trong tháng 10/2026 ở phần đã có mặt bằng và phấn đấu hoàn thành toàn bộ vào tháng 5/2027.' ),
				array( 'Hạ tầng nào ảnh hưởng nhiều nhất đến bất động sản Đà Nẵng cuối 2026?', 'Các công trình đã khởi công như cụm nút giao cầu Hòa Xuân (phía Nam) và hạ tầng kết nối cảng Liên Chiểu (phía Tây Bắc) có tác động rõ nhất đến khu vực xung quanh.' ),
			),
		),
		'sources'   => array(
			'https://www.sggp.org.vn/khoi-cong-cum-nut-giao-cau-hoa-xuan-go-diem-nghen-giao-thong-phia-nam-da-nang-post868701.html',
			'https://danviet.vn/khoi-cong-du-an-nang-cap-quoc-lo-14d-hon-4518-ty-dong-mo-dong-luc-phat-trien-vung-bien-da-nang-d1438175.html',
			'https://baodautu.vn/da-nang-yeu-cau-khoi-cong-du-an-duong-vanh-dai-phia-bac-quang-nam-trong-thang-102026-d651089.html',
			'https://daibieunhandan.vn/ky-hop-thu-sau-hdnd-tp-da-nang-thong-qua-22-nghi-quyet-thao-go-diem-nghen-sau-hop-nhat-10432907.html',
		),
	);
	return $posts;
}
