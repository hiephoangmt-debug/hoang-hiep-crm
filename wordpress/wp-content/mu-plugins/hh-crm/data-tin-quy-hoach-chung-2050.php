<?php
/**
 * Bài: Quy hoạch chung TP Đà Nẵng đến 2050, tầm nhìn 2075 (Quyết định 2016/QĐ-TTg ngày 21/10/2026).
 * Số liệu lấy từ bài công bố trên Cổng thông tin điện tử TP Đà Nẵng; phần "tác động bất động sản" là nhận định của Hoàng Hiệp, ghi rõ trong bài.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_quy_hoach_chung_2050' );
function hh_posts_quy_hoach_chung_2050( $posts ) {
	$posts[] = array(
		'slug'      => 'quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg',
		'title'     => 'Quy hoạch chung Đà Nẵng đến 2050 (Quyết định 2016/QĐ-TTg): những điểm chính và tác động bất động sản',
		'excerpt'   => 'Ngày 21/10/2026, Thủ tướng phê duyệt Quy hoạch chung TP Đà Nẵng đến 2050, tầm nhìn 2075: mô hình 3 vùng – 3 cực – 2 trục – 4 hành lang, khoảng 30 đô thị, 2.050 ha lấn biển, dân số trên 6,5 triệu người năm 2050. Người mua nhà đất cần lưu ý gì?',
		'keyword'   => 'quy hoạch chung Đà Nẵng 2050',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-28 07:00:00',
		'image'     => 'plugin:img/tin-tuc/quy-hoach-chung-da-nang-2050.jpg',
		'image_alt' => 'Quy hoạch chung Đà Nẵng đến 2050 – các con số chính của Quyết định 2016/QĐ-TTg',
		'content'   => <<<'HTML'
<p>Ngày 21/10/2026, Phó Thủ tướng Thường trực Phạm Gia Túc ký <strong>Quyết định số 2016/QĐ-TTg</strong> phê duyệt <strong>Quy hoạch chung thành phố Đà Nẵng đến năm 2050, tầm nhìn đến năm 2075</strong>. Đây là bản quy hoạch chung đầu tiên cho Đà Nẵng sau khi hợp nhất với Quảng Nam (từ 1/7/2025), và là khung để các quy hoạch phân khu, quy hoạch chi tiết, dự án nhà ở về sau phải bám theo.</p>
<p>Bài này tóm tắt các con số chính theo nội dung Cổng thông tin điện tử TP Đà Nẵng công bố, sau đó là nhận định của Hoàng Hiệp về tác động tới thị trường nhà đất. Phần nhận định là ý kiến cá nhân, không phải nội dung quyết định.</p>

<h2>Phạm vi và thời hạn quy hoạch</h2>
<ul>
<li><strong>Phạm vi:</strong> toàn bộ địa giới hành chính thành phố, gồm đặc khu Hoàng Sa và vùng biển theo quy định.</li>
<li><strong>Diện tích tự nhiên:</strong> khoảng 11.870,34 km².</li>
<li><strong>Thời hạn:</strong> ngắn hạn đến 2040, dài hạn đến 2050, tầm nhìn đến 2075.</li>
</ul>

<h2>Dân số dự báo</h2>
<table>
<thead><tr><th>Chỉ tiêu</th><th>Năm 2040</th><th>Năm 2050</th></tr></thead>
<tbody>
<tr><td>Dân số toàn thành phố (gồm khu lấn biển)</td><td>khoảng 5,5 triệu người</td><td>trên 6,5 triệu người</td></tr>
<tr><td>Dân số thường trú</td><td>khoảng 4,7 triệu người</td><td>khoảng 5,4 triệu người</td></tr>
<tr><td>Khách du lịch lưu trú</td><td>105 – 110 triệu lượt</td><td>130 – 135 triệu lượt</td></tr>
</tbody>
</table>

<h2>Mô hình 3 vùng – 3 cực – 2 trục – 4 hành lang</h2>
<p><strong>3 vùng:</strong> vùng ven biển phía Đông (công nghiệp, dịch vụ, đô thị); vùng trung du, miền núi phía Tây (sinh thái, nông nghiệp, di sản); vùng biển phía Đông cùng quần đảo Hoàng Sa và các hải đảo.</p>
<p><strong>3 cực phát triển:</strong></p>
<ul>
<li><strong>Cực phía Bắc:</strong> Đà Nẵng hiện hữu và mở rộng, Điện Bàn, Hội An và các khu đô thị lấn biển.</li>
<li><strong>Cực phía Nam:</strong> Chu Lai, Tam Kỳ, Núi Thành.</li>
<li><strong>Cực liên kết Nam Hội An:</strong> Duy Xuyên, Thăng Bình, Quế Sơn.</li>
</ul>
<p><strong>2 trục Bắc – Nam:</strong> trục phía Đông (Quốc lộ 1, cao tốc Bắc – Nam, đường ven biển, đường sắt Bắc – Nam, đường sắt tốc độ cao, đường sắt đô thị, đường thủy nội địa) và trục phía Tây (đường Đông Trường Sơn, đường Hồ Chí Minh, tuyến mới phía Tây thành phố).</p>
<p><strong>4 hành lang Đông – Tây:</strong> Quốc lộ 40B; Quốc lộ 14E, 14H và đường Hồ Chí Minh qua Khâm Đức; Quốc lộ 14D (cửa khẩu Nam Giang); Quốc lộ 14G – nay là ĐT604 (cửa khẩu Tây Giang).</p>

<h2>Mạng lưới khoảng 30 đô thị đến 2050</h2>
<p>Thành phố định hướng khoảng 30 đô thị, gồm 23 đô thị hiện hữu và 7 đô thị mới. Bốn đô thị loại II:</p>
<table>
<thead><tr><th>Đô thị</th><th>Diện tích</th><th>Dân số dự báo</th></tr></thead>
<tbody>
<tr><td>Đà Nẵng (lõi)</td><td>khoảng 67.773 ha, trong đó khoảng 2.050 ha lấn biển</td><td>khoảng 2,26 triệu người, gồm khoảng 400.000 người ở khu lấn biển</td></tr>
<tr><td>Điện Bàn</td><td>khoảng 21.626 ha</td><td>khoảng 605.000 người</td></tr>
<tr><td>Tam Kỳ</td><td>khoảng 9.396 ha</td><td>khoảng 275.000 người</td></tr>
<tr><td>Hội An</td><td>khoảng 6.355 ha</td><td>khoảng 230.000 người</td></tr>
</tbody>
</table>
<p>26 đô thị loại III gồm 11 đô thị hiện hữu (Núi Thành, Hòa Tiến, Thạnh Mỹ, Prao, Trung Phước, Tak Pỏ, Atiêng, Tiên Kỳ, Tân Bình, Khâm Đức, Trà My), 8 đô thị mở rộng (Hòa Vang, Bà Nà, Chiên Đàn, Nam Phước, Thăng Bình, Đại Lộc, Quế Sơn, Xuân Phú) và 7 đô thị mới (Duy Nghĩa, Thăng An, Thăng Trường, Thăng Điền, Tây Hồ, Vu Gia, Hoàng Sa).</p>

<h2>Khu lấn biển, khu kinh tế và khu chức năng</h2>
<table>
<thead><tr><th>Khu vực</th><th>Quy mô theo quy hoạch</th></tr></thead>
<tbody>
<tr><td>Lấn biển vịnh Đà Nẵng (nghiên cứu)</td><td>khoảng 1.500 ha</td></tr>
<tr><td>Lấn biển khu cảng Liên Chiểu (nghiên cứu)</td><td>khoảng 450 ha</td></tr>
<tr><td>Lấn biển phía Nam Sơn Trà (nghiên cứu)</td><td>khoảng 100 ha</td></tr>
<tr><td>Khu công nghệ cao Đà Nẵng (mở rộng tại Liên Chiểu, Bà Nà)</td><td>khoảng 1.710 ha</td></tr>
<tr><td>Khu công nghệ thông tin tập trung</td><td>khoảng 341 ha</td></tr>
<tr><td>Khu kinh tế mở Chu Lai</td><td>khoảng 27.040 ha</td></tr>
<tr><td>Khu kinh tế cửa khẩu Nam Giang (định hướng logistics)</td><td>khoảng 31.060 ha</td></tr>
<tr><td>Khu thương mại tự do Đà Nẵng</td><td>đưa 7 vị trí đã có quyết định thành lập vào hoạt động; nghiên cứu thêm vị trí ở phía Nam</td></tr>
</tbody>
</table>
<p>Ba khu du lịch quốc gia tiềm năng được xác định: <strong>Sơn Trà, Cù Lao Chàm, Bà Nà</strong>.</p>

<h2>Cảng, sân bay, đường sắt</h2>
<ul>
<li><strong>Cảng Liên Chiểu</strong> là cửa ngõ quốc tế, kết nối Khu thương mại tự do và Khu công nghệ cao; cảng Chu Lai là cửa ngõ phía Nam.</li>
<li><strong>Sân bay:</strong> Cảng hàng không quốc tế Đà Nẵng ở cửa ngõ phía Bắc; nâng cấp, mở rộng Cảng hàng không quốc tế Chu Lai gắn với trung tâm logistics hàng không.</li>
<li><strong>Đường sắt:</strong> đường sắt Bắc – Nam, đường sắt tốc độ cao và đường sắt đô thị (metro/LRT); phát triển các khu đô thị TOD quanh nhà ga.</li>
<li><strong>Logistics:</strong> Trung tâm logistics quốc gia Chu Lai tại Núi Thành.</li>
</ul>

<h2>Phân kỳ thực hiện</h2>
<table>
<thead><tr><th>Giai đoạn</th><th>Trọng tâm</th></tr></thead>
<tbody>
<tr><td>2026 – 2030</td><td>Hoàn thiện hệ thống quy hoạch; ưu tiên hạ tầng kết nối và dự án động lực; hoàn thiện tiêu chí đô thị loại I</td></tr>
<tr><td>2030 – 2040</td><td>Hoàn thiện chuỗi đô thị ven biển đa cực; phát triển đô thị phía Tây, nông thôn, miền núi</td></tr>
<tr><td>2040 – 2050</td><td>Hoàn thiện cấu trúc đô thị đa cực, đa trung tâm</td></tr>
<tr><td>Sau 2050</td><td>Cân bằng đô thị – nông thôn, tăng trưởng – bảo tồn tài nguyên, di sản</td></tr>
</tbody>
</table>
<p>Các chương trình ưu tiên được nêu gồm metro/LRT, đường sắt tốc độ cao, cảng Liên Chiểu, Cảng hàng không Chu Lai, Trung tâm tài chính quốc tế, các Quốc lộ 14B, 14D, 14E và hạ tầng ứng phó biến đổi khí hậu. Danh mục sẽ còn được rà soát, phân kỳ theo khả năng huy động vốn.</p>

<h2>Tác động tới bất động sản – nhận định của Hoàng Hiệp</h2>
<p>Quy hoạch chung chưa phải là quy hoạch chi tiết từng lô đất, nên chưa thể dựa vào đó để kết luận một khu cụ thể sẽ tăng giá. Tuy vậy, có vài hướng đáng theo dõi:</p>
<ul>
<li><strong>Ven biển Sơn Trà – Ngũ Hành Sơn – Hội An:</strong> nằm trong cực phía Bắc, gắn với lượng khách du lịch lưu trú dự báo 130 – 135 triệu lượt năm 2050 – có lợi cho căn hộ ven biển, căn hộ cho thuê. Xem các dự án <a href="/khu-vuc/ngu-hanh-son/">khu Ngũ Hành Sơn</a>, <a href="/khu-vuc/son-tra/">Sơn Trà</a>, <a href="/khu-vuc/hoi-an/">Hội An</a>.</li>
<li><strong>Điện Bàn:</strong> được định hướng là đô thị loại II, dân số khoảng 605.000 người – quy mô lớn thứ hai sau lõi Đà Nẵng. Khu đất nền Điện Ngọc, Điện Nam – Điện Ngọc nằm trong vùng này; xem ví dụ <a href="/du-an/khu-do-thi-1a-1b-dien-ngoc/">Khu đô thị 1A – 1B Điện Ngọc</a>.</li>
<li><strong>Liên Chiểu – Hòa Vang:</strong> cảng Liên Chiểu, Khu thương mại tự do, khu công nghệ cao mở rộng và đô thị Hòa Vang, Hòa Tiến mở rộng tạo nhu cầu nhà ở cho người lao động, chuyên gia. Xem <a href="/khu-vuc/lien-chieu/">dự án Liên Chiểu</a> và bài <a href="/cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu/">cảng Liên Chiểu &amp; khu thương mại tự do</a>.</li>
<li><strong>Quanh ga đường sắt đô thị:</strong> quy hoạch nêu rõ mô hình TOD quanh nhà ga – các dự án gần tuyến metro/LRT có lợi thế dài hạn, nhưng tiến độ đường sắt đô thị còn phụ thuộc vốn.</li>
<li><strong>Khu lấn biển:</strong> 2.050 ha lấn biển mới ở mức <em>nghiên cứu</em>; đây là nguồn cung đất dài hạn, chưa có dự án cụ thể để mua bán. Cần cảnh giác với lời chào bán "đất lấn biển" ở thời điểm này.</li>
</ul>
<p>Trước khi xuống tiền ở bất kỳ khu nào, anh/chị nên kiểm tra quy hoạch phân khu, quy hoạch chi tiết 1/500 và tình trạng pháp lý của chính dự án (sổ, thế chấp, điều kiện bán nhà ở hình thành trong tương lai), cùng hồ sơ <a href="/chu-dau-tu/">chủ đầu tư</a>. Cần đối chiếu một dự án cụ thể với quy hoạch mới, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: Cổng thông tin điện tử TP Đà Nẵng – "Phê duyệt Quy hoạch chung thành phố Đà Nẵng đến năm 2050, tầm nhìn đến năm 2075"; văn bản gốc Quyết định 2016/QĐ-TTg đăng trên Cổng TTĐT Chính phủ.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Quy hoạch chung Đà Nẵng 2050 – QĐ 2016/QĐ-TTg: điểm chính',
			'desc'      => 'Quy hoạch chung Đà Nẵng đến 2050, tầm nhìn 2075 (QĐ 2016/QĐ-TTg ngày 21/10/2026): 3 vùng – 3 cực, 30 đô thị, 2.050 ha lấn biển, dân số 6,5 triệu và tác động BĐS.',
			'points'    => array(
				'Quyết định 2016/QĐ-TTg ký ngày 21/10/2026, phạm vi khoảng 11.870,34 km² gồm đặc khu Hoàng Sa.',
				'Dân số toàn thành phố khoảng 5,5 triệu người năm 2040, trên 6,5 triệu người năm 2050.',
				'Mô hình 3 vùng – 3 cực – 2 trục – 4 hành lang; khoảng 30 đô thị, 4 đô thị loại II: Đà Nẵng, Điện Bàn, Tam Kỳ, Hội An.',
				'Lõi Đà Nẵng khoảng 67.773 ha, trong đó khoảng 2.050 ha lấn biển (vịnh Đà Nẵng, Liên Chiểu, Nam Sơn Trà – đang nghiên cứu).',
			),
			'faq'       => array(
				array( 'Quy hoạch chung Đà Nẵng đến 2050 được phê duyệt khi nào?', 'Ngày 21/10/2026, theo Quyết định số 2016/QĐ-TTg do Phó Thủ tướng Thường trực Phạm Gia Túc ký.' ),
				array( 'Đà Nẵng sẽ lấn biển bao nhiêu?', 'Đô thị lõi Đà Nẵng có khoảng 2.050 ha lấn biển; các khu đang nghiên cứu gồm vịnh Đà Nẵng khoảng 1.500 ha, khu cảng Liên Chiểu khoảng 450 ha và phía Nam Sơn Trà khoảng 100 ha.' ),
				array( 'Điện Bàn trong quy hoạch chung mới thế nào?', 'Điện Bàn là một trong 4 đô thị loại II, diện tích khoảng 21.626 ha, dân số dự báo khoảng 605.000 người, thuộc cực phát triển phía Bắc cùng Đà Nẵng và Hội An.' ),
				array( 'Có nên mua đất "lấn biển" ngay bây giờ?', 'Các khu lấn biển mới ở mức nghiên cứu trong quy hoạch chung, chưa có dự án cụ thể được giao; không nên đặt cọc cho lời chào bán đất lấn biển ở thời điểm này.' ),
			),
		),
		'sources'   => array(
			'https://danang.gov.vn/en/w/phe-duyet-quy-hoach-chung-thanh-pho-da-nang-den-nam-2050-tam-nhin-den-nam-2075',
			'https://datafiles.chinhphu.vn/cpp/files/vbpq/2026/10/2016_qd-ttg_21102026-signed.signed.pdf',
		),
	);
	return $posts;
}
