<?php
/**
 * Tin tức hạ tầng Đà Nẵng & tác động đến bất động sản (tổng hợp từ báo chí, 10/2026).
 * Nhập cùng nút "Dự án → Nhập dữ liệu Đà Nẵng": tạo bài viết chuyên mục "Hạ tầng & quy hoạch",
 * gắn "Dự án liên quan" để bài hiện ở mục Tin tức của trang dự án. Không tạo trùng, không sửa bài đã có.
 */

defined( 'ABSPATH' ) || exit;

function hh_news_dataset() {
	return array(
		array(
			'slug'     => 'toan-canh-ha-tang-da-nang-2026',
			'old_slug' => array( 'toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san' ),
			'rev'      => '2026-10-09', // Quốc lộ 14D đã khởi công, thêm đường tránh Nam Hải Vân.
			'title'    => 'Toàn cảnh hạ tầng Đà Nẵng 2026: những công trình định hình lại thị trường bất động sản',
			'excerpt'  => 'Năm 2026 Đà Nẵng đồng loạt triển khai cảng Liên Chiểu, khu thương mại tự do, trung tâm tài chính quốc tế, cụm nút giao cầu Hòa Xuân, mở rộng sân bay và Quốc lộ 14D. Đây là bản đồ hạ tầng và khu vực bất động sản hưởng lợi.',
			'project'  => '',
			'keyword'  => 'hạ tầng Đà Nẵng 2026',
			'old_meta' => array(
				'rank_math_title'       => array( 'Hạ tầng Đà Nẵng 2026: công trình trọng điểm và tác động BĐS' ),
				'rank_math_description' => array( 'Toàn cảnh hạ tầng Đà Nẵng 2026: cảng Liên Chiểu, trung tâm tài chính, cầu Hòa Xuân, sân bay, QL14D và khu vực bất động sản hưởng lợi.' ),
			),
			'content'  => <<<'HTML'
<p><strong>Hạ tầng Đà Nẵng 2026</strong> đang bước vào giai đoạn đầu tư dày đặc nhất từ trước đến nay. Sau khi hợp nhất với Quảng Nam từ ngày 1/7/2025, theo kế hoạch của ngành xây dựng, năm 2026 thành phố phải hoàn thành hàng chục dự án giao thông (<a href="https://cafeland.vn/tin-tuc/se-hoan-thanh-34-du-an-giao-thong-trong-nam-2026-154764.html">CafeLand</a>), đồng thời khởi công nhiều công trình trọng điểm. Với bất động sản, hạ tầng luôn là yếu tố đi trước: khu vực nào có đường, cầu, cảng mới thì giá trị đất và nhu cầu ở, thuê ở đó thay đổi trước.</p>
<p>Bài viết gom các công trình hạ tầng Đà Nẵng 2026 vào một chỗ, ghi rõ công trình nào đã thi công, công trình nào còn ở bước đề xuất, rồi chỉ ra khu vực bất động sản chịu tác động. Mỗi mục có liên kết tới bài phân tích riêng để anh chị đọc sâu hơn.</p>

<h2>Các công trình hạ tầng Đà Nẵng 2026 nổi bật</h2>
<ul>
<li><strong>Cảng Liên Chiểu và Khu thương mại tự do:</strong> phần hạ tầng dùng chung của cảng đã hoàn thành, khu thương mại tự do khoảng 1.881 ha ở 7 vị trí – động lực cho phía Tây Bắc (Liên Chiểu, Hòa Vang). <a href="/cang-lien-chieu-khu-thuong-mai-tu-do/">Xem chi tiết</a>.</li>
<li><strong>Trung tâm tài chính quốc tế:</strong> khai trương ngày 9/1/2026, tổng diện tích khoảng 300 ha, có các lô đất trên đường Võ Văn Kiệt (Sơn Trà) và khu lấn biển Nguyễn Tất Thành. <a href="/trung-tam-tai-chinh-quoc-te-da-nang/">Xem chi tiết</a>.</li>
<li><strong>Cụm nút giao thông cầu Hòa Xuân:</strong> tổng vốn hơn 1.378 tỷ đồng, đã khởi công ngày 25/8/2026 (thi công dự kiến 730 ngày), bổ sung cầu mới phía hạ lưu và 2 hầm chui. <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">Xem chi tiết</a>.</li>
<li><strong>Mở rộng nhà ga T2 sân bay Đà Nẵng:</strong> gần 1.500 tỷ đồng, nâng công suất nhà ga quốc tế lên 6 triệu khách/năm. <a href="/mo-rong-nha-ga-t2-san-bay-da-nang/">Xem chi tiết</a>.</li>
<li><strong>Quốc lộ 14D:</strong> cải tạo, nâng cấp dài 65,37 km với tổng mức đầu tư 4.518 tỷ đồng, đã khởi công ngày 26/6/2026 – kết nối cửa khẩu Nam Giang, mở trục giao thương phía Tây.</li>
<li><strong>Đường tránh Nam Hải Vân 6 làn:</strong> đoạn Hòa Liên – đường ven biển nối cảng Liên Chiểu, khoảng 5,36 km, tổng mức hơn 1.951 tỷ đồng. <a href="/duong-tranh-nam-hai-van-6-lan-lien-chieu/">Xem chi tiết</a>.</li>
<li>Dự án <strong>tuyến hầm qua sân bay Đà Nẵng</strong> đang hoàn thiện hồ sơ.</li>
<li><strong>Đường sắt tốc độ cao Bắc – Nam:</strong> ga Đà Nẵng dự kiến đặt tại Hòa Sơn (Hòa Vang), vận hành từ năm 2035. <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son/">Xem chi tiết</a>.</li>
<li><strong>Đường ven biển 129 (Võ Chí Công):</strong> tuyến ven biển phía Nam dài khoảng 26,5 km được mở rộng lên 6 làn. <a href="/duong-ven-bien-vo-chi-cong-hoi-an/">Xem chi tiết</a>.</li>
</ul>
<!--hh-img:img/da-nang/song-han-cau-quay-trung-tam-ve-dem.jpg|Hạ tầng Đà Nẵng 2026: sông Hàn, cầu Sông Hàn và khu trung tâm về đêm-->

<h2>Hạ tầng Đà Nẵng 2026 chia thành ba nhóm tiến độ</h2>
<p>Cùng gọi là "dự án hạ tầng" nhưng mức độ chắc chắn rất khác nhau. Hoàng Hiệp chia danh sách hạ tầng Đà Nẵng 2026 ở trên thành ba nhóm để anh chị dễ đánh giá:</p>
<table>
<thead><tr><th>Nhóm</th><th>Công trình</th><th>Mức độ chắc chắn</th></tr></thead>
<tbody>
<tr><td>Đã hoàn thành hoặc đang thi công</td><td>Hạ tầng dùng chung cảng Liên Chiểu (hoàn thành 28/3/2026), Quốc lộ 14D (khởi công 26/6/2026), cụm nút giao cầu Hòa Xuân (khởi công 25/8/2026), mở rộng nhà ga T2</td><td>Cao – đã có mặt bằng, nhà thầu, tiến độ cụ thể</td></tr>
<tr><td>Đã phê duyệt, đang triển khai các bước</td><td>Đường tránh Nam Hải Vân 6 làn (2025 – 2029), đường ven biển Võ Chí Công 6 làn, các lô đất của trung tâm tài chính quốc tế (đang kêu gọi đầu tư)</td><td>Khá – có quyết định, còn phụ thuộc mặt bằng và vốn</td></tr>
<tr><td>Dài hạn hoặc mới ở bước đề xuất</td><td>Đường sắt tốc độ cao (khai thác từ 2035), tuyến hầm qua sân bay, <a href="/da-nang-de-xuat-xay-cau-moi-qua-song-han/">cầu mới qua sông Hàn</a> (đề xuất khởi công trước 2030)</td><td>Thấp – vị trí, quy mô, vốn có thể thay đổi</td></tr>
</tbody>
</table>
<p>Khi một khu đất được giới thiệu là "hưởng lợi hạ tầng", câu hỏi đầu tiên nên là: công trình đó thuộc nhóm nào? Hạ tầng Đà Nẵng 2026 ở nhóm đầu đã tác động thật đến việc đi lại và nhu cầu thuê; nhóm cuối chỉ nên xem là kỳ vọng dài hạn.</p>

<h2>Hạ tầng Đà Nẵng 2026: khu vực bất động sản hưởng lợi</h2>
<table>
<thead><tr><th>Khu vực</th><th>Hạ tầng tác động</th><th>Dòng sản phẩm đáng chú ý</th></tr></thead>
<tbody>
<tr><td>Liên Chiểu – Hải Vân</td><td>Cảng Liên Chiểu, khu thương mại tự do, khu lấn biển</td><td>Đô thị nghỉ dưỡng, đất nền, căn hộ cho chuyên gia</td></tr>
<tr><td>Sơn Trà – ven sông Hàn</td><td>Trung tâm tài chính quốc tế (Võ Văn Kiệt)</td><td>Căn hộ cao cấp ven sông, căn hộ cho thuê</td></tr>
<tr><td>Hòa Xuân – Nam Hòa Xuân</td><td>Cụm nút giao cầu Hòa Xuân</td><td>Căn hộ, đất nền, biệt thự ven sông</td></tr>
<tr><td>Ngũ Hành Sơn – Điện Ngọc – Hội An</td><td>Trục ven biển, đường Võ Chí Công, hợp nhất hành chính</td><td>Đất nền, biệt thự nghỉ dưỡng</td></tr>
<tr><td>Hòa Vang</td><td>Ga đường sắt tốc độ cao, Quốc lộ 14D</td><td>Đất nền dài hạn</td></tr>
</tbody>
</table>
<p>Bảng trên là góc nhìn theo khu vực về tác động của hạ tầng Đà Nẵng 2026, không phải khuyến nghị mua một sản phẩm cụ thể. Trong cùng một khu, giá trị vẫn phụ thuộc pháp lý dự án, khoảng cách thực tế tới công trình và năng lực chủ đầu tư. Vùng giáp ranh sau hợp nhất được phân tích riêng tại bài <a href="/hop-nhat-da-nang-quang-nam-vung-giap-ranh/">hợp nhất Đà Nẵng – Quảng Nam và bất động sản giáp ranh</a>.</p>

<h2>Mốc thời gian hạ tầng Đà Nẵng 2026 cần theo dõi</h2>
<ul>
<li><strong>2026 – 2028:</strong> cụm nút giao cầu Hòa Xuân thi công dự kiến 730 ngày kể từ 25/8/2026; từ 31/10/2026 giao thông quanh chân cầu được phân luồng.</li>
<li><strong>2025 – 2029:</strong> đường tránh Nam Hải Vân mở rộng 6 làn, kết nối cảng Liên Chiểu với cao tốc và hầm Hải Vân.</li>
<li><strong>2026 – 2030:</strong> nhà ga T2 sân bay Đà Nẵng khai thác với công suất thiết kế 6 triệu khách/năm.</li>
<li><strong>Từ 2035:</strong> đường sắt tốc độ cao Bắc – Nam dự kiến khai thác, ga Đà Nẵng dự kiến ở Hòa Sơn.</li>
</ul>
<p>Các mốc này giúp anh chị khớp thời điểm mua với thời điểm hạ tầng Đà Nẵng 2026 thực sự đi vào sử dụng, thay vì trả giá cho kỳ vọng quá sớm. Người mua để ở nên tính cả giai đoạn thi công – thường kéo theo phân luồng, bụi và tiếng ồn quanh công trường.</p>

<h2>Lưu ý khi đầu tư theo hạ tầng Đà Nẵng 2026</h2>
<p>Hạ tầng Đà Nẵng 2026 tạo giá trị thật nhưng cần thời gian. Người mua nên ưu tiên dự án có pháp lý rõ ràng, nằm gần công trình đã khởi công hoặc sắp hoàn thành, và tính dòng tiền theo kịch bản thận trọng – tránh mua theo tin đồn quy hoạch. Lô đất sát nút giao, tuyến đường mở rộng cần kiểm tra phạm vi thu hồi trước khi đặt cọc. Hoàng Hiệp sẵn sàng cùng anh chị so sánh từng khu vực và dự án cụ thể – gọi/Zalo 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://cadn.com.vn/da-nang-sap-khoi-cong-loat-du-an-dau-tu-cong-trong-diem-post336685.html', 'https://kinhtechungkhoan.vn/da-nang-len-ke-hoach-khoi-cong-hoan-thanh-loat-cong-trinh-lon-trong-nam-2026-1447359.html', 'https://cafeland.vn/tin-tuc/se-hoan-thanh-34-du-an-giao-thong-trong-nam-2026-154764.html' ),
		),
		array(
			'slug'     => 'cang-lien-chieu-khu-thuong-mai-tu-do',
			'old_slug' => array( 'cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu' ),
			'title'    => 'Cảng Liên Chiểu và Khu thương mại tự do: cú hích cho bất động sản Liên Chiểu – Hải Vân',
			'excerpt'  => 'Hạ tầng dùng chung cảng Liên Chiểu đã hoàn thành, khu thương mại tự do Đà Nẵng khoảng 1.881 ha gắn với cảng được Quốc hội cho phép thành lập. Phía Tây Bắc Đà Nẵng đang trở thành cực tăng trưởng mới.',
			'project'  => 'vinhomes-hai-van-bay',
			'keyword'  => 'cảng Liên Chiểu',
			'old_meta' => array(
				'rank_math_title'       => array( 'Cảng Liên Chiểu, khu thương mại tự do và BĐS Liên Chiểu' ),
				'rank_math_description' => array( 'Cảng Liên Chiểu hoàn thành hạ tầng dùng chung, khu thương mại tự do Đà Nẵng 1.881 ha: tác động đến căn hộ, đất nền Liên Chiểu – Hải Vân.' ),
			),
			'content'  => <<<'HTML'
<p><strong>Cảng Liên Chiểu</strong> là cảng biển lớn nhất của Đà Nẵng, được kỳ vọng thay thế dần cảng Tiên Sa trong vận tải hàng hóa và trở thành cửa ngõ của hành lang kinh tế Đông – Tây. Ngày 28/3/2026, phần hạ tầng dùng chung của dự án được công bố hoàn thành, đồng thời khởi động dự án bến container Liên Chiểu có vốn hơn 2 tỷ USD.</p>
<!--hh-img:img/tin-tuc/bat-dong-san-lien-chieu-cang-lien-chieu.jpg|Cảng Liên Chiểu và cơ hội bất động sản Liên Chiểu 2026 (Hoàng Hiệp tổng hợp)-->

<h2>Cảng Liên Chiểu: tiến độ đến năm 2026</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Hạ tầng dùng chung giai đoạn 1</td><td>Hơn 3.426 tỷ đồng, công bố hoàn thành ngày 28/3/2026</td></tr>
<tr><td>Bến container</td><td>Khởi động cùng ngày, vốn hơn 2 tỷ USD, triển khai theo quy hoạch dài hạn đến năm 2036</td></tr>
<tr><td>Đường kết nối cảng – khu thương mại tự do</td><td>Thành phố đầu tư hơn 518 tỷ đồng cải tạo</td></tr>
<tr><td>Đường tránh Nam Hải Vân 6 làn</td><td>Đoạn Hòa Liên – đường ven biển nối cảng, khoảng 5,36 km, hơn 1.951 tỷ đồng, thực hiện 2025 – 2029</td></tr>
</tbody>
</table>
<p>Theo <a href="https://tuoitre.vn/plo/vi-sao-da-nang-lui-tien-do-hoan-thanh-cang-lien-chieu-hon-3400-ti-post884372.html">Tuổi Trẻ</a>, tiến độ hoàn thành phần hạ tầng cảng từng phải lùi so với kế hoạch ban đầu. Đây là lời nhắc thực tế: công trình hạ tầng lớn thường cần nhiều thời gian hơn dự kiến, nên người mua không nên đặt toàn bộ kỳ vọng vào một mốc tiến độ. Chi tiết tuyến đường tránh xem tại bài <a href="/duong-tranh-nam-hai-van-6-lan-lien-chieu/">đường tránh Nam Hải Vân 6 làn</a>.</p>

<h2>Khu thương mại tự do gắn với cảng Liên Chiểu</h2>
<p>Quốc hội đã cho phép thành lập Khu thương mại tự do Đà Nẵng gắn với cảng Liên Chiểu, áp dụng cơ chế đặc thù để thu hút đầu tư tài chính, thương mại, du lịch và dịch vụ chất lượng cao. Khu có quy mô khoảng 1.881 ha tại 7 vị trí không liền kề, gồm các phân khu sản xuất, logistics, thương mại – dịch vụ, công nghiệp số, công nghệ thông tin và đổi mới sáng tạo. Thành phố cũng đầu tư hơn 518 tỷ đồng cải tạo tuyến đường kết nối cảng với khu thương mại tự do.</p>
<p>Ngày 12/11/2026, UBND thành phố chấp thuận VSIP làm nhà đầu tư hạ tầng vị trí số 7 của khu thương mại tự do (Quyết định 5202/QĐ-UBND): khoảng 276 ha tại xã Hòa Vang, vốn 3.525 tỷ đồng, xây dựng hạ tầng từ quý 4/2027 đến quý 1/2032. Xem <a href="/vsip-vi-tri-so-7-khu-thuong-mai-tu-do-da-nang-3525-ty/">VSIP và vị trí số 7 khu thương mại tự do</a>.</p>

<h2>Cảng Liên Chiểu trong quy hoạch chung đến 2050</h2>
<p>Theo <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng 2050</a> (Quyết định 2016/QĐ-TTg ngày 21/10/2026), cảng Liên Chiểu là cửa ngõ quốc tế của thành phố, kết nối Khu thương mại tự do và Khu công nghệ cao. Quy hoạch nghiên cứu khoảng 450 ha lấn biển tại khu cảng Liên Chiểu và mở rộng Khu công nghệ cao Đà Nẵng tại Liên Chiểu, Bà Nà lên khoảng 1.710 ha. Đây là định hướng dài hạn, chưa phải dự án đã giao đất để mua bán.</p>

<h2>Tác động của cảng Liên Chiểu đến bất động sản</h2>
<ul>
<li><strong>Nhu cầu ở thật tăng:</strong> cảng, logistics và khu thương mại tự do kéo theo hàng chục nghìn lao động, chuyên gia – nhu cầu nhà ở, căn hộ cho thuê tại Liên Chiểu, Hòa Khánh, Hòa Hiệp tăng theo.</li>
<li><strong>Đô thị ven vịnh được định giá lại:</strong> khu vực vịnh Đà Nẵng – chân đèo Hải Vân đón các dự án quy mô lớn như <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay (Làng Vân)</a> 512 ha.</li>
<li><strong>Đất nền khu đô thị hiện hữu</strong> như <a href="/du-an/dragon-smart-city/">Dragon Smart City</a>, <a href="/du-an/lakeside-palace/">Lakeside Palace</a> và căn hộ <a href="/du-an/the-ori-garden/">The Ori Garden</a> hưởng lợi từ hạ tầng kết nối và dân số tăng.</li>
</ul>
<p>Cách nhìn thực tế: nhu cầu thuê nhà của chuyên gia, người lao động tăng theo tiến độ vận hành cảng Liên Chiểu và các khu chức năng, tức là tăng dần qua từng năm chứ không tăng đột biến. Sản phẩm đã có cư dân, gần trường học, chợ, bệnh viện thường cho thuê được sớm hơn đất trống ở xa.</p>

<h2>Checklist trước khi mua nhà đất quanh cảng Liên Chiểu</h2>
<ol>
<li>Kiểm tra lô đất có nằm trong phạm vi mở rộng đường tránh Nam Hải Vân, đường nối cảng hay hành lang an toàn công trình hay không.</li>
<li>Xem khoảng cách thực tế tới khu cảng, kho bãi: quá gần có thể chịu tiếng ồn, bụi và xe container.</li>
<li>Ưu tiên sản phẩm có sổ, hạ tầng nội khu hoàn thiện, đã có người ở.</li>
<li>Tính dòng tiền cho thuê theo giá thuê thực tế hiện nay ở Hòa Khánh, Hòa Minh, không theo kỳ vọng khi cảng chạy hết công suất.</li>
</ol>

<h2>Lưu ý</h2>
<p>Khu thương mại tự do triển khai theo từng giai đoạn – riêng vị trí số 7 dự kiến xây hạ tầng đến quý 1/2032. Nhà đầu tư nên chọn sản phẩm đã có pháp lý, hạ tầng hoàn thiện và khả năng cho thuê thực tế, thay vì đất xa trung tâm chỉ dựa vào quy hoạch. Cần thông tin nhà đất khu Liên Chiểu, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://baochinhphu.vn/khoi-dong-du-an-sieu-cang-lien-chieu-da-nang-102260328105015423.htm', 'https://vietnamnet.vn/du-kien-nam-2026-thanh-lap-khu-thuong-mai-tu-do-tai-da-nang-hai-phong-tphcm-2469765.html', 'https://danviet.vn/da-nang-chi-hon-518-ty-dong-cai-tao-tuyen-duong-ket-noi-cang-lien-chieu-voi-khu-thuong-mai-tu-do-da-nang-d1416339.html', 'https://tuoitre.vn/plo/vi-sao-da-nang-lui-tien-do-hoan-thanh-cang-lien-chieu-hon-3400-ti-post884372.html', 'https://www.sggp.org.vn/chap-thuan-vsip-dau-tu-du-an-ha-tang-3525-ty-dong-tai-khu-thuong-mai-tu-do-da-nang-post881457.html' ),
		),
		array(
			'slug'     => 'trung-tam-tai-chinh-quoc-te-da-nang',
			'old_slug' => array( 'trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san' ),
			'title'    => 'Trung tâm tài chính quốc tế Đà Nẵng: khu vực nào hưởng lợi, căn hộ ven sông Hàn có gì mới?',
			'excerpt'  => 'Trung tâm tài chính quốc tế Việt Nam tại Đà Nẵng khai trương ngày 9/1/2026, quy mô khoảng 300 ha với các lô đất trên đường Võ Văn Kiệt, khu Thuận Phước và 282 ha lấn biển. Đây là tác động đến thị trường căn hộ, văn phòng.',
			'project'  => 'the-legend-da-nang',
			'keyword'  => 'trung tâm tài chính quốc tế Đà Nẵng',
			'old_meta' => array(
				'rank_math_title'       => array( 'Trung tâm tài chính quốc tế Đà Nẵng: vị trí, tác động BĐS', 'Trung tâm tài chính quốc tế Đà Nẵng: vị trí và tác động BĐS' ),
				'rank_math_description' => array( 'Trung tâm tài chính quốc tế Đà Nẵng khai trương 9/1/2026, khoảng 300 ha: các vị trí trên Võ Văn Kiệt, Thuận Phước, lấn biển và căn hộ hưởng lợi.' ),
			),
			'content'  => <<<'HTML'
<p><strong>Trung tâm tài chính quốc tế Đà Nẵng</strong> chính thức khai trương ngày 9/1/2026. Trung tâm có tổng diện tích khoảng 300 ha, phát triển thành nhiều phân khu, hướng tới các mô hình tài chính mới, thu hút dòng vốn và nhân lực chất lượng cao về thành phố (<a href="https://tuoitre.vn/ra-mat-trung-tam-tai-chinh-quoc-te-viet-nam-tai-da-nang-20260109161629181.htm">Tuổi Trẻ</a>).</p>
<p>Tên đầy đủ là Trung tâm tài chính quốc tế Việt Nam tại Đà Nẵng. Với thị trường nhà đất, câu hỏi quan trọng không phải "có trung tâm tài chính hay không" mà là: các phân khu nằm ở đâu, bao giờ có người làm việc thật, và loại bất động sản nào được hưởng lợi trước.</p>

<h2>Trung tâm tài chính quốc tế Đà Nẵng nằm ở đâu?</h2>
<ul>
<li>Cơ quan điều hành đặt tại Khu công viên phần mềm số 2, dưới chân cầu Thuận Phước; tòa nhà công nghệ thông tin 20 tầng, sàn hơn 27.000 m².</li>
<li>Năm lô đất A12, A13, A14, A15 và A* trên đường Võ Văn Kiệt (phường An Hải, Sơn Trà), tổng khoảng 6,17 ha – định hướng tổ hợp văn phòng, thương mại, căn hộ cao cấp chuẩn quốc tế.</li>
<li>Khu đất phía Tây Bắc đường dẫn cầu Thuận Phước khoảng 9,7 ha.</li>
<li>Khoảng 282 ha thuộc khu vực dự kiến lấn biển đối diện đường Nguyễn Tất Thành.</li>
</ul>
<!--hh-img:img/da-nang/song-han-du-thuyen-cau-rong-ve-dem.jpg|Sông Hàn và cầu Rồng về đêm – trục ven sông gần các lô đất của trung tâm tài chính quốc tế Đà Nẵng trên đường Võ Văn Kiệt-->
<p>Tháng 3/2026, thành phố kêu gọi đầu tư vào 5 khu đất trên đường Võ Văn Kiệt (<a href="https://tuoitre.vn/da-nang-keu-goi-dau-tu-trung-tam-tai-chinh-quoc-te-tai-5-khu-dat-vang-20260313182451685.htm">Tuổi Trẻ, 13/3/2026</a>). Phần lấn biển 282 ha đối diện Nguyễn Tất Thành là quỹ đất dài hạn: <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng 2050</a> mới xác định khu lấn biển vịnh Đà Nẵng khoảng 1.500 ha ở mức nghiên cứu.</p>

<h2>Trung tâm tài chính quốc tế Đà Nẵng: mốc đã có và còn chờ</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Khai trương</td><td>Ngày 9/1/2026</td><td>Đã diễn ra</td></tr>
<tr><td>Cơ quan điều hành</td><td>Khu công viên phần mềm số 2, chân cầu Thuận Phước</td><td>Đã bố trí</td></tr>
<tr><td>5 lô đất Võ Văn Kiệt (khoảng 6,17 ha)</td><td>Văn phòng, thương mại, căn hộ cao cấp</td><td>Đang kêu gọi đầu tư</td></tr>
<tr><td>Khu Thuận Phước (khoảng 9,7 ha)</td><td>Phía Tây Bắc đường dẫn cầu Thuận Phước</td><td>Chờ thông tin triển khai</td></tr>
<tr><td>Khu lấn biển (khoảng 282 ha)</td><td>Đối diện đường Nguyễn Tất Thành</td><td>Dài hạn, phụ thuộc quy hoạch lấn biển</td></tr>
</tbody>
</table>

<h2>Tác động của trung tâm tài chính quốc tế Đà Nẵng đến bất động sản</h2>
<p><strong>Căn hộ cao cấp ven sông Hàn, đặc biệt trục Võ Văn Kiệt – Trần Hưng Đạo (Sơn Trà)</strong> được hưởng lợi trực tiếp: nhu cầu thuê của chuyên gia tài chính, công nghệ và nhu cầu sở hữu căn hộ chuẩn quốc tế tăng. Các dự án gần khu vực này gồm <a href="/du-an/the-legend-da-nang/">The Legend</a> (đầu cầu Rồng), <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a>, <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a>, <a href="/du-an/capital-square-da-nang/">Capital Square</a> và <a href="/du-an/hiyori-garden-tower/">Hiyori Garden Tower</a>.</p>
<p><strong>Văn phòng hạng A và căn hộ dịch vụ</strong> tại trung tâm thành phố cũng có thêm động lực khi doanh nghiệp tài chính, quỹ đầu tư đặt văn phòng tại trung tâm tài chính quốc tế Đà Nẵng.</p>

<h2>Ba nhóm sản phẩm hưởng lợi theo thứ tự thời gian</h2>
<ol>
<li><strong>Căn hộ đã bàn giao ven sông Hàn:</strong> hưởng lợi sớm nhất khi có chuyên gia, nhân sự doanh nghiệp tài chính đến làm việc – họ cần chỗ ở ngay, gần nơi làm việc, ưu tiên căn có nội thất và dịch vụ quản lý tốt.</li>
<li><strong>Văn phòng, căn hộ dịch vụ khu trung tâm:</strong> phụ thuộc số doanh nghiệp, quỹ đầu tư thực sự đặt trụ sở tại trung tâm tài chính quốc tế Đà Nẵng.</li>
<li><strong>Dự án mới trên các lô Võ Văn Kiệt, Thuận Phước:</strong> chỉ hình thành sau khi có nhà đầu tư, giấy phép và thời gian xây dựng nhiều năm.</li>
</ol>
<p>Thứ tự này giúp anh chị chọn sản phẩm theo khung thời gian của mình: cần dòng tiền sớm thì chọn căn đã bàn giao; chấp nhận chờ lâu mới xem xét các dự án tương lai. Hạ tầng xung quanh, như <a href="/da-nang-de-xuat-xay-cau-moi-qua-song-han/">đề xuất cầu mới qua sông Hàn</a>, cũng nên được tính là điểm cộng dài hạn chứ chưa phải căn cứ định giá.</p>

<h2>Góc nhìn đầu tư</h2>
<p>Trung tâm tài chính là câu chuyện dài hạn 5 – 10 năm. Với người mua để ở hoặc cho thuê, căn hộ ven sông Hàn đã bàn giao hoặc sắp bàn giao, có sổ hồng lâu dài là lựa chọn an toàn hơn so với sản phẩm còn xa tiến độ. Không nên trả giá cao cho sản phẩm được quảng cáo "ăn theo" trung tâm tài chính quốc tế Đà Nẵng khi pháp lý chưa rõ. Cần so sánh các căn hộ ven sông Hàn, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://tuoitre.vn/ra-mat-trung-tam-tai-chinh-quoc-te-viet-nam-tai-da-nang-20260109161629181.htm', 'https://plo.vn/trung-tam-tai-chinh-quoc-te-tai-da-nang-co-282-ha-thuoc-khu-lan-bien-post887579.html', 'https://tuoitre.vn/da-nang-keu-goi-dau-tu-trung-tam-tai-chinh-quoc-te-tai-5-khu-dat-vang-20260313182451685.htm' ),
		),
		array(
			'slug'     => 'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang',
			'title'    => 'Cầu Hòa Xuân đã khởi công: cụm nút giao, 2 hầm chui hơn 1.378 tỷ và tác động BĐS Hòa Xuân',
			'excerpt'  => 'Cụm nút giao thông cầu Hòa Xuân hơn 1.378 tỷ đồng đã khởi công ngày 25/8/2026: thêm cầu mới phía hạ lưu, hầm chui Cách Mạng Tháng Tám và Thăng Long, thi công dự kiến 730 ngày. Tác động đến căn hộ, đất nền Hòa Xuân.',
			'project'  => 'sun-neo-city',
			'keyword'  => 'cầu Hòa Xuân',
			'rev'      => '2026-10-09', // Đã khởi công 25/8/2026.
			'old_meta' => array(
				'rank_math_title'       => 'Cầu Hòa Xuân: cụm nút giao 1.378 tỷ và BĐS Nam Đà Nẵng',
				'rank_math_description' => 'Cầu Hòa Xuân: cụm nút giao hơn 1.378 tỷ đồng, cầu mới 303,5 m, làm trong 2026 – 2029; tác động đến giá căn hộ, đất nền Hòa Xuân, Nam Hòa Xuân.',
			),
			'content'  => <<<'HTML'
<p>Cầu Hòa Xuân là cửa ngõ nối trung tâm Đà Nẵng với khu đô thị phía Nam – nơi tập trung các dự án lớn của Sun Group như Sun NeO City, Sun Riverpolis, khu đô thị sinh thái Hòa Xuân. Lượng xe qua cầu tăng nhanh khiến khu vực thường xuyên ùn tắc giờ cao điểm.</p>
<!--hh-img:img/hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-nhin-ve-trung-tam.jpg|Sông Cẩm Lệ nhìn từ Hòa Xuân về trung tâm Đà Nẵng (flycam 8/2025) – khu vực cầu Hòa Xuân nối phía Nam với trung tâm-->

<h2>Cập nhật: cầu Hòa Xuân đã khởi công ngày 25/8/2026</h2>
<p>Sáng 25/8/2026, TP Đà Nẵng khởi công Dự án cụm nút giao thông Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn cầu Hòa Xuân, sớm hơn mốc tháng 10/2026 từng công bố. Lễ khởi công có Phó Thủ tướng Thường trực Phạm Gia Túc dự (<a href="https://tuoitre.vn/da-nang-lam-them-cau-ham-chui-voi-du-an-1378-ti-tai-khu-vuc-cau-hoa-xuan-100260621154453704.htm">Tuổi Trẻ</a> đưa tin về quy mô dự án).</p>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Ngày khởi công</td><td>25/8/2026</td></tr>
<tr><td>Thời gian thi công dự kiến</td><td>730 ngày</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Hơn 1.378 tỷ đồng, ngân sách thành phố (một số báo nêu con số khác do khác phạm vi tính)</td></tr>
<tr><td>Chủ đầu tư</td><td>Ban QLDA đầu tư xây dựng các công trình giao thông và nông nghiệp TP Đà Nẵng</td></tr>
<tr><td>Nhà thầu thi công</td><td>Liên danh DACINCO, giá trúng thầu gần 1.180 tỷ đồng</td></tr>
</tbody>
</table>

<h2>Nội dung dự án</h2>
<ul>
<li>Hầm chui trên đường Cách Mạng Tháng Tám và hầm chui trên đường Thăng Long.</li>
<li>Mở rộng đường Lê Thanh Nghị.</li>
<li>Giữ cầu Hòa Xuân hiện hữu và xây thêm một đơn nguyên cầu mới phía hạ lưu dài khoảng 303,5 m, rộng 14 m.</li>
<li>Trước khi thi công, thành phố đã thử nghiệm phân luồng giao thông quanh khu vực chân cầu.</li>
</ul>

<h2>Phân luồng quanh cầu Hòa Xuân từ 31/10/2026</h2>
<p>Từ 9h ngày 31/10/2026, thành phố phân luồng để thi công: xe tải trên 2,5 tấn và xe khách từ 16 chỗ bị cấm cả ngày trong khu vực hạn chế (Lê Thanh Nghị, Cách Mạng Tháng Tám, Núi Thành, 2 Tháng 9, Đò Xu, Xô Viết Nghệ Tĩnh, Xuân Thủy, Nguyễn Phước Lan, Thăng Long); xe container đi cảng Tiên Sa đổi sang Nam Kỳ Khởi Nghĩa – Trường Chinh – Quốc lộ 1A. Chi tiết từng loại xe xem bài <a href="/phan-luong-giao-thong-cau-hoa-xuan-tu-31-10-2026/">phân luồng cầu Hòa Xuân từ 31/10/2026</a>.</p>

<h2>Tác động đến bất động sản phía Nam</h2>
<p>Khi nút giao hoàn thành, thời gian di chuyển từ Hòa Xuân, Hòa Quý về trung tâm Hải Châu rút ngắn và ổn định hơn – yếu tố quan trọng với người mua để ở. Các sản phẩm hưởng lợi rõ nhất:</p>
<ul>
<li>Căn hộ chân cầu và trục Nguyễn Phước Lan: <a href="/du-an/spana-tower/">Spana Tower</a>, <a href="/du-an/cora-tower/">Cora Tower</a>, <a href="/du-an/s-light-tower/">S-Light Tower</a> thuộc <a href="/du-an/sun-neo-city/">Sun NeO City</a>.</li>
<li>Căn hộ và đất nền Nam Hòa Xuân: <a href="/du-an/fours-tower/">FourS Tower</a>, <a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">đất nền Đầm Sen</a> (<a href="/du-an/sun-riverpolis/">Sun Riverpolis</a>).</li>
<li>Đất nền, biệt thự khu đô thị sinh thái Hòa Xuân: <a href="/du-an/dat-nen-con-dau-hoa-xuan/">Cồn Dầu</a>, <a href="/du-an/euro-village-2/">Euro Village 2</a>.</li>
</ul>

<h2>Trước và sau khi cầu Hòa Xuân mở rộng: điều gì thay đổi?</h2>
<p>Hiện nay mọi dòng xe từ Hòa Xuân, Nam Hòa Xuân và một phần Điện Ngọc về trung tâm đều dồn vào một cầu và các nút giao đồng mức ở chân cầu. Khi có thêm đơn nguyên cầu mới cùng 2 hầm chui, xe đi thẳng không phải dừng chờ đèn tại Cách Mạng Tháng Tám và Thăng Long. Với cư dân, lợi ích dễ thấy nhất là giờ đi làm, đưa đón con ổn định hơn. Với thị trường, phía Nam sông Cẩm Lệ bớt bị xem là "xa trung tâm", từ đó nhu cầu ở thật tại các khu đô thị Hòa Xuân có cơ sở tăng.</p>

<h2>Lưu ý</h2>
<p>Trong thời gian thi công (dự kiến 730 ngày kể từ 25/8/2026), giao thông quanh chân cầu bị phân luồng, có lúc ùn ứ. Người mua để ở nên cân nhắc thời điểm nhận nhà, còn nhà đầu tư dài hạn có thể tận dụng giai đoạn này để chọn sản phẩm ở mức giá hợp lý trước khi hạ tầng hoàn thiện. Lô đất sát nút giao cần kiểm tra phạm vi giải phóng mặt bằng trước khi đặt cọc. Xem thêm <a href="/toan-canh-ha-tang-da-nang-2026/">toàn cảnh hạ tầng Đà Nẵng 2026</a>.</p>
HTML,
			'sources'  => array( 'https://www.sggp.org.vn/khoi-cong-cum-nut-giao-cau-hoa-xuan-go-diem-nghen-giao-thong-phia-nam-da-nang-post868701.html', 'https://tuoitre.vn/da-nang-lam-them-cau-ham-chui-voi-du-an-1378-ti-tai-khu-vuc-cau-hoa-xuan-100260621154453704.htm', 'https://plo.vn/da-nang-duyet-du-an-cum-nut-giao-cau-hoa-xuan-hon-1378-ti-dong-post899700.html', 'https://viettimes.vn/da-nang-khoi-cong-cum-nut-giao-thong-cau-hoa-xuan-gan-1400-ty-dong-post204959.html', 'https://tuoitre.vn/da-nang-phan-luong-giao-thong-khu-vuc-cau-hoa-xuan-tu-31-10-nhung-tuyen-nao-bi-cam-100261028105103169.htm' ),
		),
		array(
			'slug'     => 'duong-ven-bien-vo-chi-cong-hoi-an',
			'old_slug' => array( 'duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an' ),
			'title'    => 'Đường ven biển 129 (Võ Chí Công) lên 6 làn: bất động sản ven biển Hội An – Nam Hội An đón sóng hạ tầng',
			'excerpt'  => 'Tuyến ven biển 129 (Võ Chí Công) dài khoảng 26,5 km được mở rộng từ 2 lên 6 làn, nối cầu Cửa Đại với khu vực sân bay Chu Lai. Dải biển Hội An – Duy Xuyên – Thăng Bình được kết nối nhanh hơn với trung tâm Đà Nẵng.',
			'project'  => 'nam-hoi-an-city',
			'keyword'  => 'đường ven biển Võ Chí Công',
			'old_meta' => array(
				'rank_math_title'       => array( 'Đường ven biển 129 Võ Chí Công 6 làn và BĐS ven biển Hội An' ),
				'rank_math_description' => array( 'Đường ven biển 129 (Võ Chí Công) dài 26,5 km mở rộng lên 6 làn, nối cầu Cửa Đại – Chu Lai: bất động sản nghỉ dưỡng Hội An, Nam Hội An hưởng lợi.' ),
			),
			'content'  => <<<'HTML'
<p><strong>Đường ven biển Võ Chí Công</strong> (đường ven biển 129) là xương sống của chuỗi đô thị nghỉ dưỡng từ Đà Nẵng xuống Hội An và phía Nam. Sau khi hợp nhất Đà Nẵng – Quảng Nam, thành phố tập trung hoàn thành tuyến đường này trong năm 2026 (<a href="https://nhandan.vn/da-nang-tap-trung-hoan-thanh-duong-ven-bien-129-vo-chi-cong-post960154.html">Nhân Dân</a>).</p>
<!--hh-img:img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg|Cầu Cửa Đại và sông Thu Bồn nhìn từ Duy Xuyên – điểm nối của đường ven biển Võ Chí Công đi Chu Lai (ảnh flycam)-->

<h2>Đường ven biển Võ Chí Công: thông tin tuyến</h2>
<ul>
<li>Chiều dài khoảng 26,5 km, điểm đầu giao Quốc lộ 40B, điểm cuối giao đường 620.</li>
<li>Mở rộng từ 2 làn lên 6 làn xe, nối liền dải ven biển từ cầu Cửa Đại đến khu vực sân bay Chu Lai.</li>
<li>Đi qua dải biển Duy Xuyên – Thăng Bình – Tam Kỳ – Núi Thành, nơi có nhiều khu nghỉ dưỡng và khu đô thị đang hình thành.</li>
</ul>

<h2>Vì sao mở rộng lên 6 làn lại quan trọng?</h2>
<p>Với 2 làn xe, tuyến ven biển phía Nam dễ quá tải vào mùa du lịch và khó phục vụ xe đưa đón khách từ sân bay Đà Nẵng, sân bay Chu Lai vào các khu nghỉ dưỡng. Mở rộng đường ven biển Võ Chí Công lên 6 làn giúp tách luồng xe, tăng an toàn và rút ngắn thời gian di chuyển – điều kiện để các quần thể nghỉ dưỡng quy mô lớn vận hành hiệu quả quanh năm, không chỉ trong mùa cao điểm.</p>

<h2>Đường ven biển Võ Chí Công trong quy hoạch chung đến 2050</h2>
<p>Theo <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng 2050</a>, đường ven biển thuộc trục phát triển Bắc – Nam phía Đông, cùng Quốc lộ 1, cao tốc Bắc – Nam, đường sắt và đường sắt tốc độ cao. Dải ven biển này đi qua cả ba cực phát triển của thành phố: cực phía Bắc (Đà Nẵng hiện hữu, Điện Bàn, Hội An), cực liên kết Nam Hội An (Duy Xuyên, Thăng Bình, Quế Sơn) và cực phía Nam (Chu Lai, Tam Kỳ, Núi Thành).</p>
<p>Quy hoạch cũng định hướng nâng cấp, mở rộng Cảng hàng không quốc tế Chu Lai gắn với trung tâm logistics hàng không, và xác định Khu kinh tế mở Chu Lai khoảng 27.040 ha. Ở đầu phía Nam, thành phố đã ấn định thời hạn khởi công 3 khu đô thị tại Chu Lai với tổng vốn hơn 40.400 tỷ đồng (xem <a href="/da-nang-an-dinh-thoi-han-khoi-cong-3-khu-do-thi-chu-lai/">3 khu đô thị Chu Lai</a>).</p>

<h2>Tác động của đường ven biển Võ Chí Công đến bất động sản</h2>
<p>Đường rộng, thông suốt giúp rút ngắn thời gian từ trung tâm Đà Nẵng, sân bay đến các khu nghỉ dưỡng phía Nam – yếu tố then chốt với biệt thự nghỉ dưỡng, khách sạn và nhà phố thương mại ven biển. Khu vực hưởng lợi gồm:</p>
<ul>
<li>Dải Nam Hội An – Duy Xuyên: <a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a>, <a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>.</li>
<li>Hội An – Cẩm Thanh: <a href="/du-an/casamia-balanca-hoi-an/">Casamia Balanca</a>, <a href="/du-an/casamia-calm-hoi-an/">Casamia Calm</a>.</li>
<li>Phía Bắc trục ven biển (Ngũ Hành Sơn – Điện Ngọc): <a href="/du-an/dat-nen-vo-chi-cong/">đất nền Võ Chí Công</a>, <a href="/du-an/fpt-city-da-nang/">FPT City</a>, <a href="/du-an/one-world-regency/">One World Regency</a>.</li>
</ul>

<h2>So sánh nhanh các dải sản phẩm dọc tuyến</h2>
<p>Dọc đường ven biển Võ Chí Công và phần nối dài lên phía Bắc, mỗi đoạn có loại sản phẩm và rủi ro riêng:</p>
<table>
<thead><tr><th>Khu vực</th><th>Sản phẩm chính</th><th>Điều cần kiểm tra</th></tr></thead>
<tbody>
<tr><td>Ngũ Hành Sơn – Điện Ngọc</td><td>Đất nền, căn hộ, khu đô thị ven biển</td><td>Sổ đỏ từng lô, hạ tầng nội khu đã hoàn thiện chưa</td></tr>
<tr><td>Hội An – Cẩm Thanh</td><td>Biệt thự, villa nghỉ dưỡng</td><td>Thời hạn sở hữu, quy định xây dựng trong vùng di sản</td></tr>
<tr><td>Nam Hội An – Duy Xuyên</td><td>Quần thể nghỉ dưỡng, khu đô thị</td><td>Đơn vị vận hành, tiến độ hạ tầng khu</td></tr>
<tr><td>Thăng Bình – Chu Lai</td><td>Đất nền, khu đô thị mới</td><td>Tiến độ khởi công dự án, mức độ dân cư hiện hữu</td></tr>
</tbody>
</table>

<h2>Lưu ý</h2>
<p>Bất động sản nghỉ dưỡng phụ thuộc nhiều vào lượng khách du lịch và năng lực vận hành của chủ đầu tư. Nên ưu tiên dự án có pháp lý sở hữu rõ ràng, đơn vị vận hành uy tín và tính kỹ dòng tiền cho thuê theo mùa. Cần thông tin dự án ven biển Hội An, Nam Hội An, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://nhandan.vn/da-nang-tap-trung-hoan-thanh-duong-ven-bien-129-vo-chi-cong-post960154.html' ),
		),
		array(
			'slug'     => 'mo-rong-nha-ga-t2-san-bay-da-nang',
			'old_slug' => array( 'mo-rong-nha-ga-t2-san-bay-da-nang-bat-dong-san-cho-thue' ),
			'title'    => 'Mở rộng nhà ga T2 sân bay Đà Nẵng gần 1.500 tỷ: thêm động lực cho căn hộ cho thuê, căn hộ dịch vụ',
			'excerpt'  => 'Dự án mở rộng nhà ga quốc tế T2 sân bay Đà Nẵng vốn gần 1.500 tỷ đồng nâng công suất lên 6 triệu khách/năm, tăng quầy thủ tục từ 54 lên 85 và cầu ống lồng từ 4 lên 7. Lượng khách quốc tế tăng kéo theo nhu cầu lưu trú.',
			'project'  => 'sun-galaxy-complex',
			'keyword'  => 'nhà ga T2 sân bay Đà Nẵng',
			'old_meta' => array(
				'rank_math_title'       => array( 'Nhà ga T2 sân bay Đà Nẵng mở rộng: cơ hội căn hộ cho thuê', 'Mở rộng nhà ga T2 sân bay Đà Nẵng: cơ hội căn hộ cho thuê' ),
				'rank_math_description' => array( 'Nhà ga T2 sân bay Đà Nẵng mở rộng gần 1.500 tỷ đồng, nâng công suất lên 6 triệu khách/năm: động lực cho căn hộ cho thuê, căn hộ dịch vụ.' ),
			),
			'content'  => <<<'HTML'
<p>Sân bay quốc tế Đà Nẵng là cửa ngõ đón khách quốc tế lớn nhất miền Trung. Để đáp ứng lượng khách tăng nhanh, dự án mở rộng <strong>nhà ga T2 sân bay Đà Nẵng</strong> (nhà ga hành khách quốc tế) với tổng vốn gần 1.500 tỷ đồng đã được khởi công (<a href="https://vnexpress.net/khoi-cong-mo-rong-nha-ga-quoc-te-da-nang-5075515.html">VnExpress</a>).</p>
<!--hh-img:img/tin-tuc/san-bay-da-nang-sun-saphia.jpg|Sân bay Đà Nẵng: quy hoạch 20 triệu khách/năm, nhà ga T2 sân bay Đà Nẵng nâng lên 6 triệu khách/năm-->

<h2>Quy mô mở rộng nhà ga T2 sân bay Đà Nẵng</h2>
<ul>
<li>Mở rộng thêm khoảng 3.600 m², nâng tổng diện tích sử dụng lên khoảng 21.085 m².</li>
<li>Quầy làm thủ tục tăng từ 54 lên 85; cửa khởi hành có cầu ống lồng tăng từ 4 lên 7.</li>
<li>Băng chuyền hành lý đi tăng từ 2 lên 4, hành lý đến từ 4 lên 6.</li>
<li>Công suất thiết kế nhà ga T2 sân bay Đà Nẵng nâng lên 6 triệu khách/năm, khai thác trong giai đoạn 2026 – 2030.</li>
</ul>

<h2>Nhà ga T2 trong quy hoạch sân bay đến 2030</h2>
<ul>
<li>Theo Quyết định 222/QĐ-BXD ngày 12/2/2026, sân bay Đà Nẵng là cảng cấp 4E, công suất khoảng 20 triệu hành khách và 100.000 tấn hàng hóa/năm giai đoạn 2021 – 2030 (<a href="https://vnexpress.net/quy-hoach-san-bay-da-nang-cong-suat-20-trieu-khach-moi-nam-5047111.html">VnExpress</a>).</li>
<li>Trong đó nhà ga T1 mở rộng về phía Nam lên 14 triệu khách/năm, nhà ga T2 sân bay Đà Nẵng 6 triệu khách/năm.</li>
<li>Năm 2025, sân bay phục vụ khoảng 15,1 triệu lượt khách, gần 89.800 chuyến bay.</li>
<li>Song song, Bộ Xây dựng phê duyệt dự án cải tạo đường cất hạ cánh, đường lăn khoảng 1.696 tỷ đồng (Quyết định 1417/QĐ-BXD ngày 12/8/2026), thực hiện 2026 – 2028 – xem <a href="/nang-cap-san-bay-da-nang-1696-ty-sun-saphia-residence/">dự án cải tạo đường cất hạ cánh</a>.</li>
</ul>

<h2>Lượng khách đến Đà Nẵng đang tăng ra sao?</h2>
<p>Theo số liệu UBND TP Đà Nẵng công bố ngày 23/10/2026, trong 9 tháng năm 2026 các cơ sở lưu trú phục vụ khoảng 15,86 triệu lượt khách, tăng 26,4% so với cùng kỳ; khách quốc tế khoảng 7,73 triệu lượt, tăng 28,7% (<a href="https://baodanang.vn/da-nang-don-gan-15-9-trieu-luot-khach-luu-tru-trong-9-thang-3354453.html">Báo Đà Nẵng</a>). Với khách quốc tế, sân bay là cửa ngõ chính, nên năng lực nhà ga T2 sân bay Đà Nẵng ảnh hưởng trực tiếp đến số khách mà ngành lưu trú có thể đón.</p>

<h2>Tác động của nhà ga T2 sân bay Đà Nẵng đến bất động sản</h2>
<p>Khách quốc tế tăng đồng nghĩa nhu cầu lưu trú ngắn ngày, căn hộ dịch vụ và khách sạn tăng – đặc biệt tại các khu ven sông Hàn, ven biển Mỹ Khê và trục pháo hoa. Các sản phẩm căn hộ dịch vụ do thương hiệu quốc tế vận hành như <a href="/du-an/sun-galaxy-complex/">Sun Galaxy Complex</a>, cùng căn hộ ven biển như <a href="/du-an/times-square-da-nang/">Times Square</a>, <a href="/du-an/newtown-diamond-da-nang/">Newtown Diamond</a> có thêm cơ sở cho bài toán cho thuê.</p>
<p>Khi nhà ga T2 sân bay Đà Nẵng mở rộng, khu vực gần sân bay như Thanh Khê, Hải Châu cũng hưởng lợi về nhu cầu thuê của nhân sự ngành hàng không, du lịch.</p>

<h2>Bài toán cho thuê: tính thế nào cho thận trọng?</h2>
<p>Khi tính lợi suất cho thuê, cần dùng tỷ lệ lấp đầy thực tế theo mùa và chi phí vận hành. Cách làm đơn giản: lấy giá thuê theo đêm trung bình cả năm (không lấy giá mùa cao điểm), nhân với số đêm có khách thực tế, rồi trừ phí quản lý, phí kênh đặt phòng, điện nước và khấu hao nội thất. Trang dự án trên website có sẵn bảng tính dòng tiền để anh chị tự kiểm tra.</p>
<ul>
<li>Mùa cao điểm (hè, lễ hội pháo hoa) và mùa mưa bão cuối năm chênh lệch công suất phòng rất lớn.</li>
<li>Khi nhà ga T2 sân bay Đà Nẵng chạy hết công suất, khách tăng nhưng nguồn cung phòng mới cũng tăng – cạnh tranh giá thuê là có thật.</li>
<li>Ưu tiên căn có pháp lý rõ ràng, đơn vị quản lý minh bạch về chi phí và hợp đồng.</li>
</ul>
<p>Xem thêm bức tranh chung tại bài <a href="/toan-canh-ha-tang-da-nang-2026/">toàn cảnh hạ tầng Đà Nẵng 2026</a>. Cần chọn căn hộ cho thuê gần biển, sông Hàn, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://vneconomy.vn/khoi-cong-du-an-mo-rong-nha-ga-t2-san-bay-quoc-te-da-nang-tong-von-dau-tu-gan-1500-ty.htm', 'https://vnexpress.net/khoi-cong-mo-rong-nha-ga-quoc-te-da-nang-5075515.html', 'https://tuoitre.vn/mo-rong-nha-ga-san-bay-da-nang-don-25-trieu-khach-vao-nam-2030-20260528162623596.htm', 'https://vnexpress.net/quy-hoach-san-bay-da-nang-cong-suat-20-trieu-khach-moi-nam-5047111.html', 'https://luatvietnam.vn/dau-tu/quyet-dinh-1417-qd-bxd-2026-dau-tu-xay-dung-cai-tao-duong-cat-ha-canh-cang-hang-khong-da-nang-444767-d1.html', 'https://baodanang.vn/da-nang-don-gan-15-9-trieu-luot-khach-luu-tru-trong-9-thang-3354453.html' ),
		),
		array(
			'slug'     => 'ga-duong-sat-toc-do-cao-da-nang-hoa-son',
			'old_slug' => array( 'ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang' ),
			'title'    => 'Ga đường sắt tốc độ cao Đà Nẵng đặt tại Hòa Sơn: cơ hội dài hạn cho bất động sản Hòa Vang',
			'excerpt'  => 'Theo phương án tuyến đường sắt tốc độ cao Bắc – Nam (350 km/h, khai thác từ 2035), ga Đà Nẵng dự kiến đặt tại xã Hòa Sơn (Hòa Vang), gần nút giao đường Bà Nà – Suối Mơ với cao tốc. Đây là động lực dài hạn cho phía Tây thành phố.',
			'project'  => '',
			'keyword'  => 'ga đường sắt tốc độ cao Đà Nẵng',
			'old_meta' => array(
				'rank_math_title'       => array( 'Ga đường sắt tốc độ cao Đà Nẵng ở Hòa Sơn và BĐS Hòa Vang', 'Ga đường sắt tốc độ cao Đà Nẵng tại Hòa Sơn và BĐS Hòa Vang' ),
				'rank_math_description' => array( 'Ga đường sắt tốc độ cao Đà Nẵng dự kiến đặt tại Hòa Sơn (Hòa Vang), tuyến 350 km/h khai thác từ 2035: cơ hội và lưu ý cho bất động sản phía Tây.', 'Ga đường sắt tốc độ cao Đà Nẵng dự kiến đặt ở Hòa Sơn (Hòa Vang), khai thác từ năm 2035: cơ hội và lưu ý cho người mua bất động sản phía Tây.' ),
			),
			'content'  => <<<'HTML'
<p>Theo phương án hiện tại, <strong>ga đường sắt tốc độ cao Đà Nẵng</strong> dự kiến đặt tại xã Hòa Sơn (Hòa Vang). Tuyến đường sắt tốc độ cao trục Bắc – Nam dài khoảng 1.541 km, tốc độ thiết kế 350 km/h, tổng vốn sơ bộ khoảng 67,34 tỷ USD, dự kiến khai thác từ năm 2035 theo Nghị quyết 172/2024/QH15. Tuyến có 23 ga hành khách, trong đó có ga Đà Nẵng.</p>
<!--hh-img:img/tin-tuc/tod-quanh-ga-duong-sat-da-nang-du-thao-nghi-quyet.jpg|Minh hoạ đô thị TOD quanh nhà ga – mô hình có thể áp dụng quanh ga đường sắt tốc độ cao Đà Nẵng (không phải bản đồ quy hoạch)-->

<h2>Vị trí ga đường sắt tốc độ cao Đà Nẵng</h2>
<p>Ga dự kiến đặt tại xã Hòa Sơn (Hòa Vang), phía Bắc nút giao giữa đường Bà Nà – Suối Mơ với đường cao tốc Bắc – Nam. Sau khi qua đèo Hải Vân, tuyến men theo sông Cu Đê, chạy song song cao tốc hiện hữu. <a href="https://baodanang.vn/duong-sat-cao-toc-bac-nam-di-qua-nhung-xa-phuong-moi-nao-cua-da-nang-3265048.html">Báo Đà Nẵng</a> đã liệt kê các xã, phường mới của thành phố mà tuyến đi qua.</p>
<p>Cần lưu ý: hồ sơ định hướng <a href="/quy-hoach-chung-do-thi-hoa-tien-da-nang-2050/">quy hoạch đô thị Hòa Tiến đến 2050</a> cũng nêu ga hành khách đường sắt tốc độ cao dự kiến đặt tại Hòa Tiến. Hai nguồn chưa thống nhất cho thấy vị trí cụ thể vẫn chờ quyết định phê duyệt dự án; cả Hòa Sơn và Hòa Tiến đều nằm ở phía Tây thành phố.</p>

<h2>Dự án đang ở bước nào?</h2>
<ul>
<li>Bộ Xây dựng đặt mục tiêu nỗ lực khởi công tuyến vào tháng 12/2027; gói thầu tư vấn khảo sát, lập báo cáo nghiên cứu khả thi đã mở thầu (<a href="https://cafef.vn/sieu-du-an-duong-sat-toc-do-cao-350km-h-di-qua-15-tinh-thanh-von-dau-tu-67-ty-usd-du-kien-khoi-cong-vao-thang-12-2027-vua-co-dien-bien-moi-188261105135853475.chn">CafeF</a>).</li>
<li>Đà Nẵng đã phê duyệt các khu tái định cư phục vụ giải phóng mặt bằng tuyến: 3 khu tại Duy Xuyên hơn 392 tỷ đồng (Quyết định 5082/QĐ-UBND) và khu tại phường Hương Trà hơn 365,8 tỷ đồng (Quyết định 5128/QĐ-UBND). Xem <a href="/tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty/">tái định cư Duy Xuyên cho đường sắt tốc độ cao</a>.</li>
<li>Theo <a href="https://www.vietnamplus.vn/da-nang-trien-khai-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao-bac-nam-post1143554.vnp">VietnamPlus</a>, tổng mức đầu tư giải phóng mặt bằng tuyến qua Đà Nẵng dự kiến hơn 19.551 tỷ đồng.</li>
</ul>

<h2>TOD quanh ga đường sắt tốc độ cao Đà Nẵng: vì sao đất quanh ga được chú ý?</h2>
<p>Sở Xây dựng Đà Nẵng đang lấy ý kiến dự thảo nghị quyết về phát triển đô thị theo mô hình TOD: trong khoảng 1 km quanh nhà ga, hệ số sử dụng đất tối đa có thể tăng đến 1,5 lần so với quy chuẩn. Dự thảo chưa xác định ranh giới khu TOD cho nhà ga cụ thể nào (xem <a href="/da-nang-du-thao-nghi-quyet-tod-quanh-ga-duong-sat/">dự thảo nghị quyết TOD</a>).</p>
<p>Nếu ga đường sắt tốc độ cao Đà Nẵng được chốt vị trí và có quy hoạch TOD, khu vực quanh ga sẽ được đầu tư dày hơn: nhà ở mật độ cao, thương mại, dịch vụ gắn với nhà ga. Nhưng đó là câu chuyện sau khi có quyết định chính thức – mô hình TOD thường đi kèm đấu giá quỹ đất quanh ga, tức là nguồn cung đất mới cũng sẽ tăng.</p>

<h2>Tác động của ga đường sắt tốc độ cao Đà Nẵng đến bất động sản</h2>
<ul>
<li><strong>Hòa Vang – phía Tây:</strong> quanh các nhà ga đường sắt tốc độ cao thường hình thành đô thị mới (mô hình TOD). Đất nền, khu dân cư quanh Hòa Sơn, Hòa Nhơn được kỳ vọng tăng giá trị trong dài hạn.</li>
<li><strong>Liên Chiểu, Cẩm Lệ:</strong> hưởng lợi gián tiếp nhờ kết nối với ga và Quốc lộ 14D đang được nâng cấp.</li>
<li><strong>Dọc tuyến, ngoài phạm vi ga:</strong> đất nằm trong hành lang tuyến có thể bị thu hồi; tác động tăng giá chủ yếu tập trung quanh ga chứ không trải đều dọc tuyến.</li>
</ul>

<h2>Lưu ý</h2>
<p>Thời gian tới khi khai thác còn gần 10 năm và vị trí ga đường sắt tốc độ cao Đà Nẵng có thể điều chỉnh trong quá trình lập dự án. Đây là kênh đầu tư dài hạn, chỉ nên dùng vốn nhàn rỗi, chọn đất có sổ, hạ tầng hiện hữu và tránh các lô "ăn theo" quy hoạch chưa chính thức. Cần kiểm tra một thửa đất ở Hòa Vang có nằm trong hành lang tuyến hay không, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://baochinhphu.vn/duong-sat-toc-do-cao-truc-bac-nam-se-co-23-ga-hanh-khach-102241001151917569.htm', 'https://baodanang.vn/duong-sat-cao-toc-bac-nam-di-qua-nhung-xa-phuong-moi-nao-cua-da-nang-3265048.html', 'https://cafef.vn/sieu-du-an-duong-sat-toc-do-cao-350km-h-di-qua-15-tinh-thanh-von-dau-tu-67-ty-usd-du-kien-khoi-cong-vao-thang-12-2027-vua-co-dien-bien-moi-188261105135853475.chn', 'https://www.vietnamplus.vn/da-nang-trien-khai-tai-dinh-cu-phuc-vu-du-an-duong-sat-toc-do-cao-bac-nam-post1143554.vnp' ),
		),
		array(
			'slug'     => 'hop-nhat-da-nang-quang-nam-vung-giap-ranh',
			'old_slug' => array( 'hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh' ),
			'title'    => 'Hợp nhất Đà Nẵng – Quảng Nam: vùng giáp ranh Điện Ngọc, Hòa Xuân, Hội An thay đổi thế nào?',
			'excerpt'  => 'Từ ngày 1/7/2025, Đà Nẵng hợp nhất với Quảng Nam, mở rộng không gian phát triển về phía Nam. Vùng giáp ranh như Điện Ngọc, Hòa Xuân, Hòa Tiến, Ngũ Hành Sơn và dải biển Hội An được định vị lại trong một siêu đô thị biển.',
			'project'  => 'one-world-regency',
			'keyword'  => 'hợp nhất Đà Nẵng Quảng Nam',
			'old_meta' => array(
				'rank_math_focus_keyword' => array( 'hợp nhất Đà Nẵng Quảng Nam bất động sản' ),
				'rank_math_title'         => array( 'Hợp nhất Đà Nẵng Quảng Nam: BĐS vùng giáp ranh ra sao', 'Hợp nhất Đà Nẵng – Quảng Nam: BĐS vùng giáp ranh ra sao' ),
				'rank_math_description'   => array( 'Đà Nẵng hợp nhất Quảng Nam từ 1/7/2025: vùng giáp ranh Điện Ngọc, Hòa Xuân, Ngũ Hành Sơn, Hội An được định vị lại, dự án nào hưởng lợi.' ),
			),
			'content'  => <<<'HTML'
<p>Từ ngày 1/7/2025, việc <strong>hợp nhất Đà Nẵng Quảng Nam</strong> chính thức có hiệu lực. Thành phố mới có không gian phát triển rộng hơn nhiều lần, hướng tới hình thành một siêu đô thị biển quy mô khu vực, đồng thời nâng chỉ tiêu phát triển nhà ở xã hội lên gần 29.000 căn đến năm 2030.</p>
<!--hh-img:img/nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-toan-canh-nhin-ra-bien.jpg|Nam Hòa Xuân nhìn ra biển (flycam 8/2025) – vùng giáp ranh được định vị lại sau khi hợp nhất Đà Nẵng Quảng Nam-->

<h2>Sau hợp nhất Đà Nẵng Quảng Nam: thành phố mới rộng đến đâu?</h2>
<p>Theo <a href="/quy-hoach-chung-da-nang-2050/">quy hoạch chung Đà Nẵng 2050</a> (Quyết định 2016/QĐ-TTg ngày 21/10/2026), thành phố có diện tích tự nhiên khoảng 11.870 km², dân số dự báo trên 6,5 triệu người vào năm 2050 (gồm khu lấn biển). Cấu trúc gồm 3 cực phát triển: cực phía Bắc (Đà Nẵng hiện hữu và mở rộng, Điện Bàn, Hội An, khu lấn biển), cực phía Nam (Chu Lai, Tam Kỳ, Núi Thành) và cực liên kết Nam Hội An (Duy Xuyên, Thăng Bình, Quế Sơn).</p>

<h2>Vùng giáp ranh được định vị lại</h2>
<p>Trước hợp nhất, ranh giới hành chính khiến hạ tầng, quy hoạch giữa Đà Nẵng và Quảng Nam thiếu đồng bộ. Khi hợp nhất Đà Nẵng Quảng Nam về chung một thành phố, các khu vực giáp ranh như <strong>Điện Ngọc, Điện Bàn, Hòa Xuân, Hòa Tiến, Ngũ Hành Sơn</strong> và dải biển Hội An có cơ hội được đầu tư hạ tầng liền mạch. Ngay khi có thông tin sáp nhập (3/2025), giá đất nền khu Điện Ngọc đã tăng khoảng 15%, lên mức 2,2 – 2,4 tỷ đồng/lô theo ghi nhận của báo chí (<a href="https://cafeland.vn/tin-tuc/nhin-lai-thi-truong-bat-dong-san-da-nang-nam-2025-147405.html">CafeLand</a>).</p>
<p>Đáng chú ý, quy hoạch chung xác định Điện Bàn là đô thị loại II, khoảng 21.626 ha, dân số khoảng 605.000 người – quy mô lớn thứ hai sau lõi Đà Nẵng; Hội An cũng là đô thị loại II, khoảng 230.000 người. Đây là cơ sở để vùng giáp ranh được đầu tư như một phần của cực đô thị phía Bắc, thay vì "vùng ven" như trước.</p>

<h2>Hạ tầng nối liền hai bên ranh giới cũ</h2>
<p>Sau khi hợp nhất Đà Nẵng Quảng Nam, nhiều tuyến giao thông nối hai bên ranh giới cũ được đẩy nhanh:</p>
<ul>
<li><strong>Đường vành đai phía Bắc Quảng Nam:</strong> dài hơn 4,6 km, tổng mức gần 500 tỷ đồng, từ cầu Quảng Đà ra biển Điện Ngọc; thành phố yêu cầu thi công trong tháng 10/2026, phấn đấu hoàn thành tháng 5/2027 (<a href="https://baodautu.vn/da-nang-yeu-cau-khoi-cong-du-an-duong-vanh-dai-phia-bac-quang-nam-trong-thang-102026-d651089.html">Báo Đầu tư</a>).</li>
<li><strong>Cụm nút giao cầu Hòa Xuân:</strong> khởi công 25/8/2026, giúp việc đi lại từ phía Nam (Hòa Xuân, Điện Ngọc) về trung tâm thuận hơn khi hoàn thành. Xem <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao cầu Hòa Xuân</a>.</li>
<li><strong>Đường ven biển Võ Chí Công (129):</strong> mở rộng 6 làn, nối dải biển từ Cửa Đại xuống Chu Lai. Xem <a href="/duong-ven-bien-vo-chi-cong-hoi-an/">đường ven biển Võ Chí Công</a>.</li>
</ul>

<h2>Thủ tục, giá đất sau hợp nhất Đà Nẵng Quảng Nam</h2>
<ul>
<li>Bảng giá đất chung cho cả Đà Nẵng cũ và Quảng Nam cũ theo Nghị quyết 28/2026/NQ-HĐND, hiệu lực từ 10/6/2026 và đang được sửa đổi – xem <a href="/bang-gia-dat-da-nang-sua-doi-2026/">bảng giá đất Đà Nẵng sửa đổi 2026</a>.</li>
<li>Nhiều thủ tục đất đai nay giải quyết ở cấp xã, phường sau sắp xếp đơn vị hành chính (Quyết định 91/2026/QĐ-UBND, Quyết định 135/2026/QĐ-UBND) – xem <a href="/chinh-sach-bat-dong-san-da-nang-11-2026/">chính sách bất động sản Đà Nẵng 11/2026</a>.</li>
<li>Tên xã, phường trên sổ đỏ cũ có thể khác tên đơn vị hành chính mới; khi giao dịch cần đối chiếu thông tin thửa đất tại văn phòng đăng ký đất đai.</li>
</ul>

<h2>Dự án nằm trong vùng hưởng lợi</h2>
<ul>
<li>Điện Ngọc – Điện Nam: <a href="/du-an/one-world-regency/">One World Regency</a>, <a href="/du-an/fpt-city-da-nang/">FPT City Đà Nẵng</a>.</li>
<li>Nam Đà Nẵng: <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a>, <a href="/du-an/sun-neo-city/">Sun NeO City (khu đô thị sinh thái Hòa Xuân)</a>, <a href="/du-an/dat-nen-vo-chi-cong/">đất nền Võ Chí Công</a>.</li>
<li>Hội An – Duy Xuyên: <a href="/du-an/casamia-hoi-an/">Casamia</a>, <a href="/du-an/hoiana-resort-golf/">Hoiana Resort &amp; Golf</a>.</li>
</ul>

<h2>Lưu ý</h2>
<p>Hợp nhất Đà Nẵng Quảng Nam tạo kỳ vọng, nhưng giá trị bền vững vẫn đến từ hạ tầng thực tế và pháp lý dự án. Cần kiểm tra quy hoạch sử dụng đất, sổ đỏ và tiến độ hạ tầng từng khu trước khi xuống tiền. Cần đối chiếu một lô đất vùng giáp ranh, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
HTML,
			'sources'  => array( 'https://baodauthau.vn/bat-dong-san-da-nang-quang-nam-ruc-rich-tang-gia-theo-tin-don-sap-nhap-post175235.html', 'https://cafeland.vn/tin-tuc/nhin-lai-thi-truong-bat-dong-san-da-nang-nam-2025-147405.html', 'https://nhandan.vn/co-hoi-cho-bat-dong-san-da-nang-truoc-chu-ky-tang-truong-moi-post953766.html', 'https://baodautu.vn/da-nang-yeu-cau-khoi-cong-du-an-duong-vanh-dai-phia-bac-quang-nam-trong-thang-102026-d651089.html' ),
		),
	);
}


/** SEO cho từng bài: tiêu đề Google (≤ 60 ký tự), mô tả (≤ 155), điểm chính, hỏi đáp. */
function hh_news_seo() {
	return array(
		'toan-canh-ha-tang-da-nang-2026' => array(
			'seo_title' => 'Hạ tầng Đà Nẵng 2026: công trình trọng điểm và tác động BĐS',
			'desc'      => 'Hạ tầng Đà Nẵng 2026: cảng Liên Chiểu, trung tâm tài chính, cầu Hòa Xuân, nhà ga T2, Quốc lộ 14D và các khu vực bất động sản được hưởng lợi rõ nhất.',
			'points'    => array(
				'Hạ tầng Đà Nẵng 2026 bước vào giai đoạn cao điểm: sau hợp nhất với Quảng Nam (1/7/2025), thành phố triển khai hàng loạt công trình trọng điểm.',
				'Các động lực lớn: cảng Liên Chiểu và khu thương mại tự do, trung tâm tài chính quốc tế, cụm nút giao cầu Hòa Xuân, mở rộng nhà ga T2, Quốc lộ 14D.',
				'Khu vực hưởng lợi rõ từ hạ tầng Đà Nẵng 2026: Liên Chiểu – Hải Vân, Sơn Trà ven sông Hàn, Hòa Xuân – Nam Hòa Xuân, dải ven biển Ngũ Hành Sơn – Hội An.',
			),
			'faq'       => array(
				array( 'Hạ tầng Đà Nẵng 2026 có những dự án lớn nào?', 'Nổi bật gồm cảng Liên Chiểu và khu thương mại tự do, trung tâm tài chính quốc tế, cụm nút giao cầu Hòa Xuân (hơn 1.378 tỷ đồng), mở rộng nhà ga T2 sân bay (gần 1.500 tỷ đồng) và cải tạo Quốc lộ 14D (4.518 tỷ đồng).' ),
				array( 'Khu vực nào hưởng lợi nhiều nhất từ hạ tầng Đà Nẵng 2026?', 'Liên Chiểu – Hải Vân (cảng, khu thương mại tự do), Sơn Trà ven sông Hàn (trung tâm tài chính), Hòa Xuân – Nam Hòa Xuân (cầu Hòa Xuân) và dải ven biển Ngũ Hành Sơn – Hội An.' ),
				array( 'Công trình nào đã thi công, công trình nào còn là đề xuất?', 'Trong hạ tầng Đà Nẵng 2026, cảng Liên Chiểu (hạ tầng dùng chung), Quốc lộ 14D, cụm nút giao cầu Hòa Xuân và nhà ga T2 đã hoàn thành hoặc đang thi công; đường sắt tốc độ cao (khai thác từ 2035) và cầu mới qua sông Hàn còn là kế hoạch dài hạn, đề xuất.' ),
				array( 'Có nên mua bất động sản theo hạ tầng?', 'Với hạ tầng Đà Nẵng 2026, nên ưu tiên dự án có pháp lý rõ ràng, gần công trình đã khởi công hoặc sắp hoàn thành, và tính dòng tiền thận trọng thay vì mua theo tin đồn quy hoạch.' ),
			),
		),
		'cang-lien-chieu-khu-thuong-mai-tu-do' => array(
			'seo_title' => 'Cảng Liên Chiểu 2026: khu thương mại tự do và BĐS Liên Chiểu',
			'desc'      => 'Cảng Liên Chiểu đã xong hạ tầng dùng chung, khu thương mại tự do Đà Nẵng khoảng 1.881 ha: tác động đến căn hộ, đất nền khu Liên Chiểu – Hải Vân.',
			'points'    => array(
				'Ngày 28/3/2026, hạ tầng dùng chung cảng Liên Chiểu hoàn thành; khởi động bến container vốn hơn 2 tỷ USD.',
				'Khu thương mại tự do Đà Nẵng gắn với cảng Liên Chiểu, quy mô khoảng 1.881 ha tại 7 vị trí; vị trí số 7 (276 ha, Hòa Vang) đã có nhà đầu tư hạ tầng.',
				'Nhu cầu ở và thuê tại Liên Chiểu tăng theo lao động, chuyên gia; đô thị ven vịnh Hải Vân được định giá lại.',
			),
			'faq'       => array(
				array( 'Cảng Liên Chiểu ở đâu, khi nào hoạt động?', 'Cảng nằm tại vịnh Đà Nẵng, phía Tây Bắc thành phố (Liên Chiểu). Phần hạ tầng dùng chung hoàn thành ngày 28/3/2026; bến container đang được đầu tư tiếp theo quy hoạch dài hạn đến năm 2036.' ),
				array( 'Khu thương mại tự do Đà Nẵng rộng bao nhiêu?', 'Khoảng 1.881 ha tại 7 vị trí không liền kề, gồm sản xuất, logistics, thương mại – dịch vụ, công nghiệp số và đổi mới sáng tạo.' ),
				array( 'Bất động sản nào hưởng lợi từ cảng Liên Chiểu?', 'Căn hộ, đất nền và đô thị ven vịnh Liên Chiểu – Hải Vân như Vinhomes Hải Vân Bay, Dragon Smart City, Lakeside Palace, The Ori Garden.' ),
				array( 'Mua đất gần cảng Liên Chiểu cần kiểm tra gì?', 'Kiểm tra lô đất có nằm trong phạm vi mở rộng đường tránh Nam Hải Vân, đường nối cảng hay không; khoảng cách tới khu cảng, kho bãi; sổ đỏ và hạ tầng nội khu.' ),
			),
		),
		'trung-tam-tai-chinh-quoc-te-da-nang' => array(
			'seo_title' => 'Trung tâm tài chính quốc tế Đà Nẵng: 300 ha, tác động BĐS',
			'desc'      => 'Trung tâm tài chính quốc tế Đà Nẵng khai trương 9/1/2026, khoảng 300 ha: vị trí Võ Văn Kiệt, Thuận Phước, khu lấn biển và căn hộ được hưởng lợi.',
			'points'    => array(
				'Trung tâm tài chính quốc tế Đà Nẵng khai trương ngày 9/1/2026, tổng diện tích khoảng 300 ha.',
				'Vị trí: lô A12 – A15 và A* đường Võ Văn Kiệt (6,17 ha), khu Thuận Phước (9,7 ha), 282 ha lấn biển Nguyễn Tất Thành.',
				'Căn hộ cao cấp ven sông Hàn (Sơn Trà) và căn hộ cho thuê chuyên gia hưởng lợi trực tiếp.',
			),
			'faq'       => array(
				array( 'Trung tâm tài chính quốc tế Đà Nẵng nằm ở đâu?', 'Cơ quan điều hành đặt tại Khu công viên phần mềm số 2 (chân cầu Thuận Phước); các lô đất trên đường Võ Văn Kiệt (Sơn Trà), khu Thuận Phước và khu lấn biển đối diện Nguyễn Tất Thành.' ),
				array( 'Trung tâm tài chính quốc tế Đà Nẵng khai trương khi nào?', 'Ngày 9/1/2026. Tháng 3/2026, thành phố tiếp tục kêu gọi đầu tư vào 5 khu đất trên đường Võ Văn Kiệt.' ),
				array( 'Căn hộ nào hưởng lợi từ trung tâm tài chính quốc tế Đà Nẵng?', 'Căn hộ cao cấp ven sông Hàn khu Sơn Trà như The Legend, Sun Ponte Residence, Sun Symphony Residence, Capital Square, Hiyori Garden Tower.' ),
			),
		),
		'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang' => array(
			'seo_title' => 'Cụm nút giao cầu Hòa Xuân 1.378 tỷ và BĐS Nam Đà Nẵng',
			'desc'      => 'Cụm nút giao cầu Hòa Xuân hơn 1.378 tỷ đồng, cầu mới 303,5 m, thực hiện 2026 – 2029: tác động đến căn hộ, đất nền Hòa Xuân, Nam Hòa Xuân.',
			'points'    => array(
				'Cụm nút giao cầu Hòa Xuân đã khởi công ngày 25/8/2026, thi công dự kiến 730 ngày; tổng vốn hơn 1.378 tỷ đồng.',
				'Hầm chui Cách Mạng Tháng Tám, hầm chui Thăng Long, mở rộng Lê Thanh Nghị, thêm cầu mới phía hạ lưu dài khoảng 303,5 m.',
				'Từ 31/10/2026 phân luồng quanh chân cầu: cấm xe tải trên 2,5 tấn, xe khách từ 16 chỗ trong khu vực hạn chế.',
				'Hưởng lợi: Sun NeO City (Cora, Spana, S-Light), Sun Riverpolis (FourS Tower, đất nền Đầm Sen), Cồn Dầu, Euro Village 2.',
			),
			'faq'       => array(
				array( 'Dự án cụm nút giao cầu Hòa Xuân gồm những gì?', 'Hầm chui trên đường Cách Mạng Tháng Tám, hầm chui trên đường Thăng Long, mở rộng đường Lê Thanh Nghị và xây thêm cầu mới phía hạ lưu dài khoảng 303,5 m, rộng 14 m; cầu hiện hữu được giữ lại.' ),
				array( 'Cầu Hòa Xuân khởi công khi nào, bao giờ xong?', 'Dự án khởi công ngày 25/8/2026, thời gian thi công dự kiến 730 ngày; kế hoạch đưa vào sử dụng trong giai đoạn đến năm 2029.' ),
				array( 'Dự án nào ở Hòa Xuân hưởng lợi từ cầu Hòa Xuân mới?', 'Các tòa căn hộ Spana Tower, Cora Tower, S-Light Tower (Sun NeO City), FourS Tower và đất nền Đầm Sen (Sun Riverpolis), đất nền Cồn Dầu và Euro Village 2.' ),
			),
		),
		'duong-ven-bien-vo-chi-cong-hoi-an' => array(
			'seo_title' => 'Đường ven biển Võ Chí Công 6 làn và BĐS ven biển Hội An',
			'desc'      => 'Đường ven biển Võ Chí Công (đường 129) dài 26,5 km mở rộng 6 làn, nối Cửa Đại – Chu Lai: bất động sản nghỉ dưỡng Hội An, Nam Hội An hưởng lợi.',
			'points'    => array(
				'Đường ven biển Võ Chí Công (đường 129) dài khoảng 26,5 km, mở rộng từ 2 lên 6 làn xe.',
				'Nối dải ven biển từ cầu Cửa Đại đến khu vực sân bay Chu Lai, đi qua cả ba cực phát triển theo quy hoạch chung 2050.',
				'Hưởng lợi: Hoiana, Nam Hội An City, Casamia Balanca, Casamia Calm và đất nền ven biển phía Bắc trục.',
			),
			'faq'       => array(
				array( 'Đường ven biển Võ Chí Công dài bao nhiêu?', 'Đoạn đường ven biển 129 dài khoảng 26,5 km, từ giao Quốc lộ 40B đến giao đường 620, được mở rộng từ 2 lên 6 làn.' ),
				array( 'Đường ven biển Võ Chí Công kết nối những đâu?', 'Nối dải ven biển từ cầu Cửa Đại (Hội An) qua Duy Xuyên, Thăng Bình đến khu vực sân bay Chu Lai.' ),
				array( 'Bất động sản nào hưởng lợi từ đường ven biển Võ Chí Công?', 'Biệt thự, khu nghỉ dưỡng ven biển Hội An – Duy Xuyên như Hoiana Resort & Golf, Nam Hội An City, Casamia Balanca, Casamia Calm; phía Bắc trục có đất nền Võ Chí Công, FPT City, One World Regency.' ),
			),
		),
		'mo-rong-nha-ga-t2-san-bay-da-nang' => array(
			'seo_title' => 'Nhà ga T2 sân bay Đà Nẵng: 6 triệu khách, cơ hội cho thuê',
			'desc'      => 'Nhà ga T2 sân bay Đà Nẵng mở rộng gần 1.500 tỷ đồng, nâng công suất lên 6 triệu khách/năm: động lực lớn cho căn hộ cho thuê và căn hộ dịch vụ.',
			'points'    => array(
				'Nhà ga T2 sân bay Đà Nẵng mở rộng với tổng vốn gần 1.500 tỷ đồng, thêm khoảng 3.600 m², tổng diện tích sử dụng khoảng 21.085 m².',
				'Quầy thủ tục tăng từ 54 lên 85, cầu ống lồng từ 4 lên 7; công suất nhà ga T2 đạt 6 triệu khách/năm.',
				'Quy hoạch sân bay đến 2030: khoảng 20 triệu khách/năm; năm 2025 sân bay phục vụ khoảng 15,1 triệu lượt khách.',
				'Khách quốc tế tăng kéo theo nhu cầu căn hộ dịch vụ, căn hộ cho thuê ven sông Hàn và ven biển.',
			),
			'faq'       => array(
				array( 'Nhà ga T2 sân bay Đà Nẵng mở rộng bao nhiêu?', 'Mở rộng thêm khoảng 3.600 m², nâng tổng diện tích sử dụng lên khoảng 21.085 m² và công suất lên 6 triệu khách/năm.' ),
				array( 'Dự án mở rộng nhà ga T2 sân bay Đà Nẵng có vốn bao nhiêu?', 'Gần 1.500 tỷ đồng, khai thác trong giai đoạn 2026 – 2030.' ),
				array( 'Sân bay Đà Nẵng quy hoạch công suất bao nhiêu?', 'Theo Quyết định 222/QĐ-BXD ngày 12/2/2026, khoảng 20 triệu hành khách và 100.000 tấn hàng hóa/năm giai đoạn 2021 – 2030, trong đó nhà ga T1 14 triệu và nhà ga T2 6 triệu khách/năm.' ),
				array( 'Mở rộng sân bay ảnh hưởng thế nào đến bất động sản Đà Nẵng?', 'Lượng khách quốc tế tăng làm tăng nhu cầu lưu trú, có lợi cho căn hộ dịch vụ và căn hộ cho thuê ven sông Hàn, ven biển và khu gần sân bay; cần tính lợi suất theo công suất phòng thực tế từng mùa.' ),
			),
		),
		'ga-duong-sat-toc-do-cao-da-nang-hoa-son' => array(
			'seo_title' => 'Ga đường sắt tốc độ cao Đà Nẵng: Hòa Sơn, khai thác 2035',
			'desc'      => 'Ga đường sắt tốc độ cao Đà Nẵng dự kiến đặt ở Hòa Sơn (Hòa Vang), khai thác từ năm 2035: tiến độ dự án, TOD quanh ga và lưu ý khi mua đất phía Tây.',
			'points'    => array(
				'Ga đường sắt tốc độ cao Đà Nẵng dự kiến đặt tại xã Hòa Sơn (Hòa Vang), gần nút giao Bà Nà – Suối Mơ với cao tốc.',
				'Tuyến Bắc – Nam dài khoảng 1.541 km, tốc độ 350 km/h, vốn sơ bộ khoảng 67,34 tỷ USD, mục tiêu khởi công 12/2027, khai thác từ 2035.',
				'Đà Nẵng đã duyệt các khu tái định cư phục vụ giải phóng mặt bằng tuyến tại Duy Xuyên, Hương Trà.',
				'Cơ hội dài hạn cho đất nền Hòa Vang; vị trí ga có thể điều chỉnh, chỉ nên đầu tư bằng vốn nhàn rỗi.',
			),
			'faq'       => array(
				array( 'Ga đường sắt tốc độ cao Đà Nẵng đặt ở đâu?', 'Theo phương án hiện tại, ga Đà Nẵng dự kiến đặt tại xã Hòa Sơn (Hòa Vang), phía Bắc nút giao đường Bà Nà – Suối Mơ với cao tốc Bắc – Nam; vị trí chính thức theo quyết định phê duyệt dự án.' ),
				array( 'Khi nào đường sắt tốc độ cao Bắc – Nam hoạt động?', 'Dự kiến khai thác từ năm 2035 theo Nghị quyết 172/2024/QH15 – khi đó ga đường sắt tốc độ cao Đà Nẵng mới đón khách; Bộ Xây dựng đặt mục tiêu khởi công vào tháng 12/2027.' ),
				array( 'Ga đường sắt tốc độ cao Đà Nẵng có phải ga metro không?', 'Không. Đây là ga của tuyến liên tỉnh Bắc – Nam; còn đường sắt đô thị (metro/LRT) phục vụ đi lại trong thành phố là hệ thống riêng theo quy hoạch chung đến 2050.' ),
				array( 'Có nên mua đất gần ga đường sắt tốc độ cao Đà Nẵng?', 'Chỉ nên xem là kênh đầu tư dài hạn, chọn đất có sổ và hạ tầng hiện hữu vì vị trí ga có thể điều chỉnh trong quá trình lập dự án.' ),
			),
		),
		'hop-nhat-da-nang-quang-nam-vung-giap-ranh' => array(
			'seo_title' => 'Hợp nhất Đà Nẵng Quảng Nam 2025: BĐS vùng giáp ranh ra sao',
			'desc'      => 'Hợp nhất Đà Nẵng Quảng Nam từ 1/7/2025: bất động sản vùng giáp ranh Điện Ngọc, Hòa Xuân, Ngũ Hành Sơn, Hội An thay đổi ra sao, dự án nào hưởng lợi.',
			'points'    => array(
				'Hợp nhất Đà Nẵng Quảng Nam có hiệu lực từ ngày 1/7/2025, hướng tới siêu đô thị biển.',
				'Vùng giáp ranh Điện Ngọc, Điện Bàn, Hòa Xuân, Hòa Tiến, Ngũ Hành Sơn có cơ hội đầu tư hạ tầng liền mạch.',
				'Theo quy hoạch chung 2050, Điện Bàn là đô thị loại II khoảng 605.000 dân, lớn thứ hai sau lõi Đà Nẵng.',
				'Khi có thông tin sáp nhập (3/2025), đất nền Điện Ngọc tăng khoảng 15% theo ghi nhận báo chí.',
			),
			'faq'       => array(
				array( 'Hợp nhất Đà Nẵng Quảng Nam từ khi nào?', 'Từ ngày 1/7/2025.' ),
				array( 'Vùng nào hưởng lợi khi hợp nhất Đà Nẵng Quảng Nam?', 'Các khu giáp ranh như Điện Ngọc, Điện Bàn, Hòa Xuân, Hòa Tiến, Ngũ Hành Sơn và dải biển Hội An – Duy Xuyên.' ),
				array( 'Sau hợp nhất Đà Nẵng Quảng Nam, bảng giá đất áp dụng thế nào?', 'Toàn thành phố áp dụng chung bảng giá đất theo Nghị quyết 28/2026/NQ-HĐND (hiệu lực từ 10/6/2026), đang được HĐND xem xét sửa đổi, bổ sung.' ),
				array( 'Hợp nhất có làm giá đất tăng không?', 'Khi có thông tin sáp nhập (3/2025), giá đất nền khu Điện Ngọc tăng khoảng 15%; giá trị bền vững vẫn phụ thuộc hạ tầng thực tế và pháp lý dự án.' ),
			),
		),
	);
}

/** Nội dung đầy đủ của một bài: điểm chính + thân bài + hỏi đáp + nguồn. */
function hh_news_build_content( $n, $seo ) {
	$html = '';
	if ( ! empty( $seo['points'] ) ) {
		$html .= '<div class="key-points"><p><strong>Điểm chính</strong></p><ul>';
		foreach ( $seo['points'] as $point ) {
			$html .= '<li>' . esc_html( $point ) . '</li>';
		}
		$html .= "</ul></div>\n\n";
	}
	$html .= $n['content'];
	if ( ! empty( $seo['faq'] ) ) {
		$html .= "\n<h2>Câu hỏi thường gặp</h2>\n";
		foreach ( $seo['faq'] as list( $question, $answer ) ) {
			$html .= '<h3>' . esc_html( $question ) . "</h3>\n<p>" . esc_html( $answer ) . "</p>\n";
		}
	}
	$rel   = empty( $n['follow_sources'] ) ? 'nofollow noopener' : 'noopener'; // Nguồn báo chí, cơ quan nhà nước: có thể để dofollow.
	// 'follow_domains': nguồn chính thống (cổng thông tin nhà nước, văn bản pháp luật) để dofollow, tin rao vẫn nofollow.
	$follow = (array) ( $n['follow_domains'] ?? array() );
	$links  = array_map(
		static function ( $u ) use ( $rel, $follow ) {
			$host = (string) wp_parse_url( $u, PHP_URL_HOST );
			$r    = array_filter( $follow, static fn( $d ) => $host === $d || str_ends_with( $host, '.' . $d ) ) ? 'noopener' : $rel;
			return '<a href="' . esc_url( $u ) . '" rel="' . $r . '" target="_blank">' . esc_html( $host ) . '</a>';
		},
		$n['sources'] ?? array()
	);
	if ( ! $links ) {
		return $html . "\n<p><em>Thông tin mang tính tham khảo, cập nhật " . esc_html( wp_date( 'm/Y' ) ) . '. Giá và chính sách thay đổi theo từng đợt – liên hệ để nhận thông tin mới nhất.</em></p>';
	}
	return $html . "\n<p><em>Nguồn tổng hợp: " . implode( ', ', $links ) . '. Bài viết mang tính tham khảo, thông tin dự án có thể thay đổi theo quyết định của cơ quan có thẩm quyền.</em></p>';
}

/** Chỗ đánh dấu <!--hh-featured--> trong bài → ảnh đại diện (alt chứa từ khoá) để Rank Math nhận ảnh trong nội dung. */
function hh_news_featured_in_content( $html, $id, $n ) {
	// Ảnh đi kèm plugin chèn giữa bài: <!--hh-img:img/tin-tuc/ten.jpg|Chú thích-->.
	$html  = preg_replace_callback(
		'/<!--hh-img:([a-z0-9\/._-]+\.(?:jpe?g|png|webp))\|([^>]*?)-->/i',
		static function ( $m ) {
			if ( ! defined( 'HH_CRM_DIR' ) || ! is_readable( HH_CRM_DIR . $m[1] ) ) {
				return '';
			}
			$url = HH_CRM_URL . $m[1];
			$cap = trim( $m[2] );
			return '<figure class="wp-block-image"><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( $cap ) . '" loading="lazy"></a>' . ( $cap ? '<figcaption>' . esc_html( $cap ) . '</figcaption>' : '' ) . '</figure>';
		},
		$html
	);
	$thumb = get_post_thumbnail_id( $id );
	if ( false === strpos( $html, '<!--hh-featured-->' ) || ! $thumb ) {
		return $html;
	}
	$img = wp_get_attachment_image( $thumb, 'large', false, array( 'alt' => $n['image_alt'] ?? $n['title'], 'loading' => 'lazy' ) );
	$cap = ! empty( $n['image_caption'] ) ? '<figcaption>' . esc_html( $n['image_caption'] ) . '</figcaption>' : '';
	$full = wp_get_attachment_url( $thumb );
	if ( $full ) {
		$img = '<a href="' . esc_url( $full ) . '" target="_blank" rel="noopener">' . $img . '</a>'; // bấm để xem ảnh gốc khổ lớn
	}
	return str_replace( '<!--hh-featured-->', '<figure class="wp-block-image">' . $img . $cap . '</figure>', $html );
}

/**
 * Tạo bài tin tức hạ tầng. Bài đã có: chỉ cập nhật nội dung nếu bạn chưa sửa bài (so mã băm),
 * và chỉ điền các ô SEO còn trống. Trả về số bài tạo mới.
 */
/** Chuyên mục theo tên (tạo nếu chưa có), trả về term_id. */
function hh_news_category( $name ) {
	static $cache = array();
	if ( ! isset( $cache[ $name ] ) ) {
		$cat            = term_exists( $name, 'category' ) ?: wp_insert_term( $name, 'category', array( 'slug' => sanitize_title( remove_accents( $name ) ) ) );
		$cache[ $name ] = is_array( $cat ) ? (int) $cat['term_id'] : (int) $cat;
	}
	return $cache[ $name ];
}

/**
 * Ngày đăng theo kế hoạch nội dung: tuần 1 = ngày nhập lần đầu, mỗi tuần 5 bài, cách nhau 1 ngày, 8:00 sáng.
 * Bài có ngày trong tương lai được lên lịch (WordPress tự đăng đúng ngày).
 */
function hh_news_plan_date( $week, $pos ) {
	$start = (int) get_option( 'hh_news_plan_start' );
	if ( ! $start ) {
		$start = (int) strtotime( wp_date( 'Y-m-d' ) . ' 08:00:00 ' . wp_timezone_string() );
		update_option( 'hh_news_plan_start', $start );
	}
	return $start + ( ( (int) $week - 1 ) * 7 + (int) $pos ) * DAY_IN_SECONDS;
}

function hh_import_news() {
	$seo_all = hh_news_seo();
	$created = 0;
	$i       = 0;
	// Bài hạ tầng (cố định) + bài theo kế hoạch nội dung (các file data-bai-viet-*.php nạp qua filter "hh_news_posts").
	$items = array_map( static fn( $n ) => $n + array( 'category' => 'Hạ tầng & quy hoạch' ), hh_news_dataset() );
	$items = array_merge( $items, apply_filters( 'hh_news_posts', array() ) );
	$items = apply_filters( 'hh_news_items', $items ); // Bản đồ từ khoá SEO (seo-tu-khoa.php).
	$pos   = array();
	foreach ( $items as $n ) {
		++$i;
		$seo     = $n['seo'] ?? ( $seo_all[ $n['slug'] ] ?? array() );
		$cat_id  = hh_news_category( $n['category'] );
		$week    = (int) ( $n['week'] ?? 0 );
		$date    = ! empty( $n['date'] ) ? (int) strtotime( $n['date'] . ' ' . wp_timezone_string() ) : ( $week ? hh_news_plan_date( $week, $pos[ $week ] = ( $pos[ $week ] ?? -1 ) + 1 ) : time() - $i * HOUR_IN_SECONDS );
		if ( ! empty( $n['schedule'] ) ) {
			// 'schedule': hẹn đăng đúng ngày (Y-m-d, có thể kèm giờ H:i), mặc định 8:00 sáng giờ Việt Nam; ngày đã qua thì đăng ngay.
			$at   = date_create( $n['schedule'] . ( strlen( $n['schedule'] ) <= 10 ? ' 08:00' : '' ), new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );
			$date = $at ? $at->getTimestamp() : time();
		} elseif ( ! empty( $n['date'] ) && $date > time() ) {
			$date = time() - $i; // Tin có ngày cố định: không lên lịch (múi giờ web khác giờ Việt Nam vẫn đăng ngay).
		}
		$content = hh_news_build_content( $n, $seo );
		$post    = get_posts( array( 'name' => $n['slug'], 'post_type' => 'post', 'post_status' => array( 'publish', 'future', 'draft', 'pending', 'private' ), 'numberposts' => 1 ) )[0] ?? null;
		if ( ! $post ) {
			foreach ( (array) ( $n['old_slug'] ?? array() ) as $os ) { // Bài đổi đường dẫn (rút gọn URL): đổi tên bài cũ, link cũ chuyển hướng 301.
				$post = get_posts( array( 'name' => $os, 'post_type' => 'post', 'post_status' => array( 'publish', 'future', 'draft', 'pending', 'private' ), 'numberposts' => 1 ) )[0] ?? null;
				if ( $post ) {
					hh_post_rename_slug( $post->ID, $n['slug'] );
					$post = get_post( $post->ID );
					break;
				}
			}
		}
		if ( $post ) {
			$id   = $post->ID;
			$content = hh_news_featured_in_content( $content, $id, $n );
			if ( 'future' === $post->post_status && ! empty( $n['date'] ) && empty( $n['status'] ) ) {
				// Bản trước lỡ lên lịch tin có ngày cố định (do múi giờ) → đăng ngay.
				wp_update_post( array( 'ID' => $id, 'post_status' => 'publish', 'post_date' => wp_date( 'Y-m-d H:i:s', $date ), 'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $date ) ) );
			}
			$hash = get_post_meta( $id, '_hh_news_hash', true );
			// 'rev': bản cập nhật bắt buộc (tin có diễn biến mới) – ghi đè cả bài đã sửa tay; bản cũ vẫn còn trong mục Bản sửa đổi (Revisions).
			$force = ! empty( $n['rev'] ) && get_post_meta( $id, '_hh_news_rev', true ) !== $n['rev'];
			if ( $force || ( $hash && md5( $post->post_content ) === $hash && md5( $content ) !== $hash ) ) {
				$upd = array( 'ID' => $id, 'post_content' => $content );
				if ( $force || in_array( $post->post_title, (array) ( $n['old_title'] ?? array() ), true ) ) {
					$upd['post_title']   = $n['title']; // Tiêu đề, tóm tắt cũ do web tạo (chưa sửa tay) → đổi theo bản mới.
					$upd['post_excerpt'] = $n['excerpt'];
				}
				if ( $force && ! empty( $n['repub'] ) && 'publish' === $post->post_status ) {
					// 'repub': bài viết lại gần như toàn bộ → đưa lên đầu Tin tức với ngày đăng là hôm nay (giữ nguyên đường dẫn).
					$upd['post_date']     = current_time( 'mysql' );
					$upd['post_date_gmt'] = current_time( 'mysql', true );
				}
				wp_update_post( $upd );
				update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
				if ( ! empty( $n['rev'] ) ) {
					update_post_meta( $id, '_hh_news_rev', $n['rev'] );
				}
			} elseif ( ! $hash && false === strpos( $post->post_content, 'key-points' ) && false !== strpos( $post->post_content, 'Nguồn tổng hợp' ) ) {
				// Bài bản đầu (chưa có mã băm) và chưa bị sửa phần cấu trúc: nâng cấp lên bản có điểm chính, hỏi đáp.
				wp_update_post( array( 'ID' => $id, 'post_content' => $content ) );
				update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
			}
		} else {
			$id = wp_insert_post(
				array(
					'post_type'     => 'post',
					'post_status'   => $n['status'] ?? ( $date > time() ? 'future' : 'publish' ), // 'draft': bài chờ duyệt.
					'post_name'     => $n['slug'],
					'post_title'    => $n['title'],
					'post_excerpt'  => $n['excerpt'],
					'post_content'  => $content,
					'post_category' => $cat_id ? array( $cat_id ) : array(),
					'post_date'     => wp_date( 'Y-m-d H:i:s', $date ),
					'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $date ),
				)
			);
			if ( ! $id || is_wp_error( $id ) ) {
				continue;
			}
			update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
			if ( ! empty( $n['rev'] ) ) {
				update_post_meta( $id, '_hh_news_rev', $n['rev'] );
			}
			++$created;
		}
		if ( $week ) {
			update_post_meta( $id, '_hh_plan_week', $week );
		}
		if ( ! empty( $n['tags'] ) ) {
			wp_set_post_tags( $id, $n['tags'], true ); // Thêm thẻ, giữ thẻ đã có.
		}
		// Ảnh đại diện đi kèm plugin ("plugin:img/…"): chỉ gắn khi bài chưa có ảnh đại diện,
		// hoặc khi bài khai báo 'image_replace' và ảnh đang dùng là ảnh web gắn trước đó (khác ảnh mới).
		$hh_thumb   = get_post_thumbnail_id( $id );
		$hh_replace = false;
		if ( ! empty( $n['image_replace'] ) && $hh_thumb ) {
			// 'image_replace' = tên file ảnh cũ (không đuôi) mà web đã gắn; chỉ thay đúng ảnh đó, không đụng ảnh bạn tự chọn.
			$hh_src     = (string) get_post_meta( $hh_thumb, '_hh_img_src', true );
			$hh_file    = pathinfo( (string) get_attached_file( $hh_thumb ), PATHINFO_FILENAME );
			$hh_old     = (string) $n['image_replace'];
			$hh_replace = $hh_src !== ( $n['image'] ?? '' ) && ( false !== strpos( $hh_src, $hh_old ) || 0 === strpos( $hh_file, $hh_old ) );
		}
		if ( ! empty( $n['image'] ) && ( ! $hh_thumb || $hh_replace ) && function_exists( 'hh_img_link_local_path' ) ) {
			$file = hh_img_link_local_path( hh_img_link_key( $n['image'] ) );
			if ( $file ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';
				$tmp = wp_tempnam( basename( $file ) );
				if ( $tmp && copy( $file, $tmp ) ) {
					$att = media_handle_sideload( array( 'name' => basename( $file ), 'tmp_name' => $tmp ), $id, $n['image_alt'] ?? $n['title'] );
					if ( is_wp_error( $att ) ) {
						wp_delete_file( $tmp );
					} else {
						update_post_meta( $att, '_wp_attachment_image_alt', $n['image_alt'] ?? $n['title'] );
						set_post_thumbnail( $id, $att );
						update_post_meta( $att, '_hh_img_src', $n['image'] );
						if ( $hh_replace ) {
							$stored = get_post_field( 'post_content', $id );
							if ( md5( $stored ) === get_post_meta( $id, '_hh_news_hash', true ) ) { // bài chưa sửa tay
								wp_update_post( array( 'ID' => $id, 'post_content' => hh_news_featured_in_content( hh_news_build_content( $n, $n['seo'] ?? array() ), $id, $n ) ) );
								update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
							}
						}
					}
				}
			}
		}
		// Bài gắn dự án mà vẫn chưa có ảnh đại diện (không khai báo 'image'): dùng chung ảnh đại diện của trang dự án.
		if ( ! empty( $n['project'] ) && ! get_post_thumbnail_id( $id ) ) {
			$hh_proj = get_page_by_path( $n['project'], OBJECT, 'du-an' );
			$hh_pimg = $hh_proj ? (int) get_post_thumbnail_id( $hh_proj->ID ) : 0;
			if ( $hh_pimg ) {
				set_post_thumbnail( $id, $hh_pimg );
			}
		}
		$stored = get_post_field( 'post_content', $id );
		if ( ( false !== strpos( $stored, '<!--hh-featured-->' ) && has_post_thumbnail( $id ) ) || false !== strpos( $stored, '<!--hh-img:' ) ) {
			$hash_ok = md5( $stored ) === get_post_meta( $id, '_hh_news_hash', true );
			wp_update_post( array( 'ID' => $id, 'post_content' => hh_news_featured_in_content( $stored, $id, $n ) ) );
			if ( $hash_ok ) {
				update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
			}
		}
		$meta = array(
			'rank_math_focus_keyword' => implode( ',', array_merge( array( $n['keyword'] ), (array) ( $n['keywords_extra'] ?? array() ) ) ),
			'rank_math_title'         => $seo['seo_title'] ?? '',
			'rank_math_description'   => $seo['desc'] ?? '',
			'hh_post_faq'             => implode( "\n", array_map( static fn( $f ) => str_replace( '|', '/', $f[0] ) . ' | ' . str_replace( '|', '/', $f[1] ), $seo['faq'] ?? array() ) ),
		);
		if ( $n['project'] ) {
			$project = get_page_by_path( $n['project'], OBJECT, 'du-an' );
			$meta['hh_post_project'] = $project ? $project->ID : '';
		}
		$auto = (array) get_post_meta( $id, '_hh_news_meta_hash', true ); // Ô do web tự điền (chưa bị sửa tay) → được cập nhật theo dữ liệu mới.
		foreach ( (array) ( $n['old_meta'] ?? array() ) as $key => $olds ) {
			foreach ( (array) $olds as $o ) {
				if ( (string) get_post_meta( $id, $key, true ) === (string) $o ) {
					$auto[ $key ] = md5( (string) $o );
				}
			}
		}
		foreach ( array_filter( $meta, 'strlen' ) as $key => $value ) {
			$cur = (string) get_post_meta( $id, $key, true );
			if ( '' === $cur || ( isset( $auto[ $key ] ) && md5( $cur ) === $auto[ $key ] && $cur !== $value ) ) {
				update_post_meta( $id, $key, $value );
				$auto[ $key ] = md5( (string) $value );
			} elseif ( $cur === $value ) {
				$auto[ $key ] = md5( $cur );
			}
		}
		update_post_meta( $id, '_hh_news_meta_hash', $auto );
		do_action( 'hh_quick_post_created', $id ); // seo-bai-viet.php: chuẩn SEO Rank Math.
	}
	return $created;
}

/** Đăng ngay các bài đã lên lịch của một tuần (hoặc tất cả khi $week = 0): ngày đăng = bây giờ. */
function hh_news_publish_now( $week = 0 ) {
	$args = array( 'post_type' => 'post', 'post_status' => 'future', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'ASC', 'fields' => 'ids' );
	if ( $week ) {
		$args['meta_key']   = '_hh_plan_week'; // phpcs:ignore
		$args['meta_value'] = (int) $week; // phpcs:ignore
	}
	$ids = get_posts( $args );
	foreach ( $ids as $i => $id ) {
		$time = time() - ( count( $ids ) - $i ) * MINUTE_IN_SECONDS; // Giữ thứ tự bài trong tuần.
		wp_update_post( array( 'ID' => $id, 'post_status' => 'publish', 'post_date' => wp_date( 'Y-m-d H:i:s', $time ), 'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $time ) ) );
	}
	return count( $ids );
}

/** Lịch bài viết: số bài đã lên lịch theo tuần. */
function hh_news_schedule_summary() {
	$out = array();
	foreach ( get_posts( array( 'post_type' => 'post', 'post_status' => 'future', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => '_hh_plan_week' ) ) as $id ) { // phpcs:ignore
		$w = (int) get_post_meta( $id, '_hh_plan_week', true );
		$out[ $w ][] = $id;
	}
	ksort( $out );
	return $out;
}

/**
 * Bài lên lịch có thể liên kết tới bài tuần sau chưa đăng: tạm bỏ liên kết (giữ chữ) để không dẫn tới trang 404,
 * bài kia đăng xong liên kết tự hiện lại.
 */
add_filter( 'the_content', 'hh_news_unlink_unpublished', 20 );
function hh_news_unlink_unpublished( $html ) {
	if ( ! is_singular( 'post' ) || false === strpos( $html, 'href="/' ) ) {
		return $html;
	}
	return preg_replace_callback(
		'#<a\s+href="/([a-z0-9-]+)/"[^>]*>(.*?)</a>#u',
		static function ( $m ) {
			$p = get_page_by_path( $m[1], OBJECT, 'post' );
			return $p && 'publish' !== $p->post_status ? $m[2] : $m[0];
		},
		$html
	);
}
