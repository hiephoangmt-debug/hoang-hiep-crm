<?php
/** Đẩy SEO dự án đang bán – nhóm hai-van-bay-furama (22/11/2026). Không nạp trong plugin – xuất bằng scripts/xuat-bai-tu-dong.php. */
defined( 'ABSPATH' ) || exit;
add_filter( 'hh_news_posts', 'hh_posts_day_seo_hai_van_bay_furama' );
function hh_posts_day_seo_hai_van_bay_furama( $posts ) {
	$hvb_src = array(
		'https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm',
		'https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html',
		'https://tienphong.vn/so-do-lau-dai-gia-tri-thuc-tao-loi-the-khong-doi-thu-cho-do-thi-vinh-bien-vinhomes-hai-van-bay-post1831206.tpo',
		'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
	);

	/* ---------------- 1. Vinhomes Hải Vân Bay – Chính sách bán hàng từ 19/11/2026 ---------------- */
	$posts[] = array(
		'slug'     => 'chinh-sach-vinhomes-hai-van-bay-19-11-2026',
		'title'    => 'Chính sách Vinhomes Hải Vân Bay từ 19/11/2026: thanh toán sớm 7,5%, voucher 30%, cam kết thuê 7%/năm',
		'excerpt'  => 'Chính sách Vinhomes Hải Vân Bay áp dụng từ 19/11/2026 cho Bạch Vân, Vịnh Mây, Đảo Ngọc: ưu đãi thanh toán sớm 7,5%, voucher thanh toán tới 30%, VinClub 0,5 – 0,9%, Bạch Vân về ở sớm 10%, Đảo Ngọc cam kết thuê 7%/năm và 2 phương án vay.',
		'keyword'  => 'chính sách Vinhomes Hải Vân Bay',
		'keywords_extra' => array( 'chính sách bán hàng Vinhomes Hải Vân Bay', 'ưu đãi Vinhomes Hải Vân Bay tháng 11/2026', 'vay mua Vinhomes Hải Vân Bay' ),
		'project'  => 'vinhomes-hai-van-bay',
		'schedule' => '2026-11-22 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Vinhomes Hải Vân Bay', 'Chính sách bán hàng', 'Làng Vân' ),
		'image'    => 'plugin:img/vinhomes-hai-van-bay/vhvb-dao-ngoc-tong-the-2.jpg',
		'image_alt' => 'Chính sách Vinhomes Hải Vân Bay từ 19/11/2026 – phối cảnh Khu Đảo Ngọc bên vịnh Nam Chơn',
		'content'  => <<<'HTML'
<p><strong>Chính sách Vinhomes Hải Vân Bay</strong> mới nhất áp dụng từ ngày 19/11/2026 cho ba phân khu đang bán Bạch Vân, Vịnh Mây và Đảo Ngọc, thay cho chương trình tháng 10/2026. Điểm chính gồm ưu đãi thanh toán sớm 7,5%, voucher Vinhomes thanh toán tới 30% giá trị căn, ưu đãi VinClub, chương trình về ở sớm 10% và cam kết tiền thuê 7%/năm cho căn hoàn thiện Đảo Ngọc. Bài viết tóm tắt từng ưu đãi và hai phương án vay để anh chị tự tính dòng tiền.</p>
<!--hh-featured-->
<h2>Tóm tắt chính sách Vinhomes Hải Vân Bay từ 19/11/2026</h2>
<p>Thông tin dưới đây tổng hợp từ chính sách bán hàng của chủ đầu tư áp dụng từ 19/11/2026. Điều kiện chi tiết và danh sách căn được áp dụng từng chương trình theo bản chính sách chính thức tại thời điểm ký.</p>
<table>
<thead><tr><th>Ưu đãi</th><th>Mức</th><th>Áp dụng</th></tr></thead>
<tbody>
<tr><td>Thanh toán sớm</td><td>7,5%</td><td>Bạch Vân, Vịnh Mây, Đảo Ngọc</td></tr>
<tr><td>Voucher Vinhomes</td><td>Thanh toán tối đa 30% giá trị căn</td><td>Dùng voucher chậm nhất 31/12/2026, mỗi voucher 01 căn</td></tr>
<tr><td>Ưu đãi VinClub</td><td>0,5% – 0,7% – 0,9%</td><td>Tùy hạng thành viên</td></tr>
<tr><td>Về ở sớm</td><td>10%</td><td>Bạch Vân (nhà thô, xây ngay) theo danh sách căn</td></tr>
<tr><td>Cam kết tiền thuê</td><td>7%/năm trong 3 năm</td><td>Đảo Ngọc – căn hoàn thiện thuộc chương trình</td></tr>
<tr><td>Vay ngân hàng</td><td>Tới 70% giá trị căn</td><td>2 phương án: lãi cố định (PA1) hoặc hỗ trợ lãi 0% (PA2)</td></tr>
</tbody>
</table>

<h2>Ưu đãi chung cho cả 3 phân khu</h2>
<h3>Thanh toán sớm 7,5%</h3>
<p>Khách có sẵn vốn và chọn thanh toán sớm được ưu đãi 7,5%. Đây là mức ưu đãi đáng tính nhất trong chính sách Vinhomes Hải Vân Bay đợt này nếu anh chị không cần dùng đòn bẩy ngân hàng, vì khoản ưu đãi tính thẳng trên giá trị căn.</p>
<h3>Voucher Vinhomes thanh toán tới 30%</h3>
<p>Trong chính sách Vinhomes Hải Vân Bay, voucher Vinhomes được dùng để thanh toán tối đa 30% giá trị bất động sản. Hạn áp dụng voucher chậm nhất ngày 31/12/2026; mỗi voucher chỉ áp cho 01 căn và căn đó bị hạn chế chuyển nhượng 03 tháng kể từ ngày dùng voucher. Người mua để lướt sóng ngắn hạn cần lưu ý mốc 3 tháng này.</p>
<h3>Ưu đãi hội viên VinClub</h3>
<p>Khách là thành viên VinClub được ưu đãi thêm 0,5%, 0,7% hoặc 0,9% tùy hạng thẻ. Mức này nhỏ nhưng cộng dồn được với các ưu đãi khác theo điều kiện của chính sách Vinhomes Hải Vân Bay.</p>

<h2>Bạch Vân: về ở sớm ưu đãi 10%</h2>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-facade-lien-ke-bach-van-shanghai.jpg|Chính sách Vinhomes Hải Vân Bay cho Bạch Vân: về ở sớm ưu đãi 10% – phối cảnh phố liền kề Bạch Vân (phối cảnh chủ đầu tư)-->
<p>Với nhà thô xây ngay tại <a href="/du-an/vinhomes-hai-van-bay-bach-van/">phân khu Bạch Vân</a>, khách cam kết về ở sớm được ưu đãi 10%. Khoản ưu đãi được trừ vào giá trên hợp đồng mua bán khi ký, và được hoàn tiền khi khách đủ điều kiện về ở sớm theo chương trình. Ưu đãi này trong chính sách Vinhomes Hải Vân Bay chỉ áp dụng cho các căn nằm trong danh sách của chủ đầu tư.</p>
<p>Bạch Vân là phân khu mở bán đầu tiên (20/4/2026), khoảng 345 căn thấp tầng dự kiến bàn giao thô trong quý 4/2026, nên đây là lựa chọn hợp với gia đình muốn dọn về ở sớm hoặc mở kinh doanh dịch vụ.</p>

<h2>Đảo Ngọc: cam kết thuê 7%/năm hoặc về ở sớm 10%</h2>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-biet-thu-dao-ngoc.jpg|Dãy biệt thự Đảo Ngọc bên phố đi bộ – căn hoàn thiện nhận cam kết thuê 7%/năm theo chính sách Vinhomes Hải Vân Bay (phối cảnh chủ đầu tư)-->
<p>Theo chính sách Vinhomes Hải Vân Bay, căn hoàn thiện tại <a href="/du-an/vinhomes-hai-van-bay-dao-ngoc/">phân khu Đảo Ngọc</a> thuộc chương trình được cam kết tiền thuê 7%/năm trong 3 năm. Riêng 223 căn theo danh sách, khách được chọn 1 trong 2 phương án:</p>
<ul>
<li><strong>Nhận cam kết tiền thuê 7%/năm trong 3 năm:</strong> khách bàn giao lại nhà cho chủ đầu tư khai thác.</li>
<li><strong>Về ở sớm ưu đãi 10%:</strong> tính trên giá hợp đồng mua bán trước VAT và kinh phí bảo trì; không nhận cam kết thuê và phải về ở trong 3 tháng kể từ ngày nhận nhà.</li>
</ul>
<p>Nếu mua để giữ tài sản và có dòng tiền đều, cam kết thuê dễ tính hơn. Nếu gia đình sẽ dùng căn nhà thường xuyên, khoản 10% trừ thẳng có lợi hơn trong ngắn hạn.</p>

<h2>Hai phương án vay trong chính sách Vinhomes Hải Vân Bay</h2>
<p>Chính sách Vinhomes Hải Vân Bay cho khách chọn 1 trong 2 phương án vay. Hạn mức, thời gian hỗ trợ và chi phí cộng thêm theo xét duyệt ngân hàng.</p>
<table>
<thead><tr><th>Thời gian hỗ trợ</th><th>PA1 – lãi cố định: khách trả</th><th>PA2 – lãi 0%: cộng vào giá gốc (vay 70%)</th></tr></thead>
<tbody>
<tr><td>18 tháng</td><td>3%/năm</td><td>+3,5%</td></tr>
<tr><td>24 tháng</td><td>4,5%/năm</td><td>+8%</td></tr>
<tr><td>30 tháng</td><td>6%/năm</td><td>+13,5%</td></tr>
<tr><td>36 tháng</td><td>7,5%/năm</td><td>+19,5%</td></tr>
<tr><td>48 tháng</td><td>8,5%/năm</td><td>–</td></tr>
<tr><td>60 tháng</td><td>9%/năm</td><td>–</td></tr>
</tbody>
</table>
<ul>
<li><strong>PA1:</strong> vay theo giá gốc tới 70% giá trị căn; sản phẩm giãn xây vay tới 80% tiền đất và thương mại nhưng không vượt 70% tổng giá trị.</li>
<li><strong>PA2:</strong> hỗ trợ lãi suất 0%, chi phí cộng thêm vào giá gốc. Với nhà giãn xây vay 80% tiền đất và thương mại, mức cộng là +5,5%, +10,5%, +17,5%, +25% tương ứng 18 – 36 tháng.</li>
<li>Căn hoàn thiện nội thất vay ngân hàng chỉ áp dụng PA1.</li>
</ul>

<h2>Chính sách Vinhomes Hải Vân Bay cũ nào đã hết hiệu lực?</h2>
<p>Chương trình khóa trần lãi suất 6%/năm trong 5 năm thuộc đợt 20/4 – 20/7/2026 (theo <a href="https://tienphong.vn/vinhomes-hai-van-bay-bung-no-giao-dich-trong-ngay-dau-sieu-chinh-sach-khoa-tran-lai-suat-6nam-trong-5-nam-co-hieu-luc-post1836841.tpo">Tiền Phong</a>) và chính sách tháng 10/2026 không còn là chính sách hiện hành. Khi đọc tin cũ trên mạng, anh chị nên đối chiếu ngày áp dụng trước khi tính toán.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Chính sách Vinhomes Hải Vân Bay đợt 19/11/2026 chia khá rõ theo nhu cầu: khách dư vốn nên tính ưu đãi thanh toán sớm 7,5% cộng VinClub; khách muốn ở thật chọn Bạch Vân về ở sớm 10%; khách cần dòng tiền thụ động cân nhắc căn hoàn thiện Đảo Ngọc nhận cam kết 7%/năm. Với vay ngân hàng, PA2 hấp dẫn về dòng tiền nhưng chi phí cộng vào giá tăng nhanh theo thời gian hỗ trợ, nên so tổng tiền phải trả của cả hai phương án cho đúng căn định mua.</p>
<p>Xem tổng quan dự án tại trang <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a> và bài <a href="/phan-khu-vinhomes-hai-van-bay-2026/">phân khu Vinhomes Hải Vân Bay</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận phiếu tính giá theo chính sách Vinhomes Hải Vân Bay hiện hành cho từng phương án thanh toán.</p>
<p class="src">Nguồn: chính sách bán hàng Vinhomes Hải Vân Bay của chủ đầu tư áp dụng từ 19/11/2026; <a href="https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay">Vinhomes</a>; <a href="https://tienphong.vn/vinhomes-hai-van-bay-bung-no-giao-dich-trong-ngay-dau-sieu-chinh-sach-khoa-tran-lai-suat-6nam-trong-5-nam-co-hieu-luc-post1836841.tpo">Tiền Phong</a>. Phối cảnh mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Chính sách Vinhomes Hải Vân Bay 19/11/2026: ưu đãi 7,5%',
			'desc'      => 'Chính sách Vinhomes Hải Vân Bay từ 19/11/2026: thanh toán sớm 7,5%, voucher tới 30%, Bạch Vân về ở sớm 10%, Đảo Ngọc cam kết thuê 7%/năm, 2 phương án vay.',
			'points'    => array(
				'Chính sách Vinhomes Hải Vân Bay áp dụng từ 19/11/2026 cho Bạch Vân, Vịnh Mây, Đảo Ngọc: thanh toán sớm 7,5%, voucher thanh toán tới 30% (dùng trước 31/12/2026), VinClub 0,5 – 0,9%',
				'Bạch Vân về ở sớm ưu đãi 10%; Đảo Ngọc cam kết thuê 7%/năm trong 3 năm (223 căn được chọn cam kết thuê hoặc về ở sớm 10%)',
				'Vay tới 70%: PA1 lãi cố định khách trả 3 – 9%/năm (18 – 60 tháng) hoặc PA2 lãi 0% cộng 3,5 – 19,5% vào giá gốc',
			),
			'faq'       => array(
				array( 'Chính sách Vinhomes Hải Vân Bay mới nhất áp dụng từ khi nào?', 'Chính sách Vinhomes Hải Vân Bay hiện hành áp dụng từ ngày 19/11/2026 cho ba phân khu Bạch Vân, Vịnh Mây và Đảo Ngọc.' ),
				array( 'Voucher trong chính sách Vinhomes Hải Vân Bay dùng thế nào?', 'Voucher thanh toán tối đa 30% giá trị căn, dùng chậm nhất ngày 31/12/2026, mỗi voucher 01 căn; căn dùng voucher bị hạn chế chuyển nhượng 03 tháng.' ),
				array( 'Đảo Ngọc cam kết thuê bao nhiêu?', 'Căn hoàn thiện thuộc chương trình được cam kết tiền thuê 7%/năm trong 3 năm; 223 căn theo danh sách được chọn cam kết thuê hoặc về ở sớm ưu đãi 10%.' ),
				array( 'Vay mua theo chính sách Vinhomes Hải Vân Bay được bao nhiêu?', 'Tới 70% giá trị căn (nhà giãn xây vay tới 80% tiền đất và thương mại), chọn PA1 lãi cố định hoặc PA2 hỗ trợ lãi 0% có chi phí cộng thêm; căn hoàn thiện nội thất chỉ áp dụng PA1.' ),
			),
		),
		'sources'  => array(
			'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
			'https://tienphong.vn/vinhomes-hai-van-bay-bung-no-giao-dich-trong-ngay-dau-sieu-chinh-sach-khoa-tran-lai-suat-6nam-trong-5-nam-co-hieu-luc-post1836841.tpo',
			'https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html',
		),
	);

	/* ---------------- 2. Vinhomes Hải Vân Bay – Giá 2026 theo phân khu ---------------- */
	$posts[] = array(
		'slug'     => 'gia-vinhomes-hai-van-bay-2026-theo-phan-khu',
		'title'    => 'Giá Vinhomes Hải Vân Bay 2026 theo phân khu: Bạch Vân, Vịnh Mây, Đảo Ngọc chỉ từ bao nhiêu?',
		'excerpt'  => 'Giá Vinhomes Hải Vân Bay 2026 theo từng phân khu: liền kề Bạch Vân chỉ từ khoảng 5,3 tỷ, liền kề Vịnh Mây từ 5,6 tỷ, biệt thự đơn lập Bạch Vân từ 11,1 tỷ, Đảo Ngọc từ 7,6 tỷ (tham khảo, gồm VAT).',
		'keyword'  => 'giá Vinhomes Hải Vân Bay 2026',
		'keywords_extra' => array( 'giá Bạch Vân Vinhomes Hải Vân Bay', 'giá Vịnh Mây', 'giá Đảo Ngọc Vinhomes' ),
		'project'  => 'vinhomes-hai-van-bay',
		'schedule' => '2026-11-23 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Vinhomes Hải Vân Bay', 'Bảng giá', 'Biệt thự Đà Nẵng' ),
		'image'    => 'plugin:img/vinhomes-hai-van-bay/vhvb-dao-ngoc-tong-the-1.jpg',
		'image_alt' => 'Giá Vinhomes Hải Vân Bay 2026 theo phân khu – phối cảnh Khu Đảo Ngọc và VinWonders Hải Vân',
		'content'  => <<<'HTML'
<p><strong>Giá Vinhomes Hải Vân Bay 2026</strong> chênh lệch khá rộng giữa các phân khu: cùng là liền kề 4 tầng nhưng Bạch Vân, Vịnh Mây và Đảo Ngọc có mức khởi điểm khác nhau do vị trí, tiện ích và tiến độ. Bài viết gom mức giá "chỉ từ" của từng dòng sản phẩm theo giỏ hàng tháng 9 – 10/2026 (đã gồm VAT, tham khảo) để anh chị chọn đúng phân khu với ngân sách của mình.</p>
<!--hh-featured-->
<h2>Giá Vinhomes Hải Vân Bay 2026: tổng quan theo phân khu</h2>
<p>Dự án 512 ha tại vịnh Nam Chơn có 4 phân khu. Ba phân khu đang bán là Bạch Vân (Khu 1), Vịnh Mây (Khu 2), Đảo Ngọc (Khu 3); Tinh Vân (Khu 4) chưa mở bán.</p>
<table>
<thead><tr><th>Phân khu</th><th>Liền kề</th><th>Song lập</th><th>Đơn lập</th></tr></thead>
<tbody>
<tr><td>Bạch Vân (~112 ha)</td><td>Chỉ từ 5,3 tỷ</td><td>Chỉ từ 9,4 tỷ</td><td>Chỉ từ 11,1 tỷ</td></tr>
<tr><td>Vịnh Mây (~99,6 ha)</td><td>Chỉ từ 5,6 tỷ</td><td>–</td><td>Chỉ từ 15,1 tỷ</td></tr>
<tr><td>Đảo Ngọc (~138,8 ha)</td><td>Chỉ từ 7,6 tỷ</td><td>Chỉ từ 19,4 tỷ</td><td>Chỉ từ 15,8 tỷ</td></tr>
<tr><td>Tinh Vân (~161,8 ha)</td><td colspan="3">Chưa mở bán, chưa công bố giá</td></tr>
</tbody>
</table>
<p>Mức giá Vinhomes Hải Vân Bay 2026 trong bảng là giá thấp nhất của từng dòng theo giỏ hàng tháng 9 – 10/2026, đã gồm VAT. Giá từng căn phụ thuộc diện tích, hướng, vị trí (mặt biển, mặt hồ, căn góc) và phương án thanh toán; liên hệ Hoàng Hiệp để nhận bảng giá từng căn.</p>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-tmb-dinh-vi-kien-truc.jpg|Giá Vinhomes Hải Vân Bay 2026 khác nhau theo 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân trên tổng mặt bằng định vị kiến trúc (tài liệu chủ đầu tư)-->

<h2>Giá Vinhomes Hải Vân Bay 2026 tại Bạch Vân</h2>
<p><a href="/du-an/vinhomes-hai-van-bay-bach-van/">Bạch Vân</a> là phân khu cửa ngõ, phong cách Hong Kong, gồm liền kề đất 63 – 140 m², shophouse, biệt thự song lập 140 – 160 m² và đơn lập 140 – 290 m². Liền kề chỉ từ khoảng 5,3 tỷ là mức vào cửa thấp nhất dự án; song lập có đơn giá từ khoảng 67 triệu/m² đất.</p>
<p>Ưu điểm lớn của Bạch Vân là tiến độ: khoảng 345 căn thấp tầng dự kiến bàn giao thô quý 4/2026, cao tầng quý 4/2027. Tiện ích nội khu gồm Lifestyle Hub, chợ Hong Kong, làng ẩm thực ven suối và Hồ Ngọc Trai.</p>

<h2>Giá Vinhomes Hải Vân Bay 2026 tại Vịnh Mây</h2>
<p><a href="/du-an/vinhomes-hai-van-bay-vinh-may/">Vịnh Mây</a> nằm trên sườn đồi cao độ khoảng 4,8 – 187,5 m, phong cách Malibu, 690 sản phẩm gồm 429 biệt thự và 261 liền kề, mật độ xây dựng khoảng 19,8%. Liền kề chỉ từ khoảng 5,6 tỷ; biệt thự đơn lập trên đồi chỉ từ khoảng 15,1 tỷ, đơn giá từ khoảng 60 triệu/m² đất – thấp nhất trong các dòng biệt thự của dự án.</p>
<p>Đổi lại, Vịnh Mây ra mắt muộn nhất (26/9/2026), phần lớn sản phẩm thanh toán giãn xây 24 tháng, phù hợp khách không cần nhận nhà gấp.</p>

<h2>Giá Vinhomes Hải Vân Bay 2026 tại Đảo Ngọc</h2>
<p><a href="/du-an/vinhomes-hai-van-bay-dao-ngoc/">Đảo Ngọc</a> là phân khu trung tâm, phong cách Costa Smeralda (Ý), kết nối VinWonders Hải Vân theo quy hoạch điều chỉnh mới nhất. Liền kề 70 m² chỉ từ khoảng 7,6 tỷ, liền kề xẻ khe từ 8,9 tỷ, đơn lập từ 15,8 tỷ (đơn giá từ khoảng 72 triệu/m² đất), song lập từ 19,4 tỷ.</p>
<p>Trong bảng giá Vinhomes Hải Vân Bay 2026, Đảo Ngọc có giá vào cửa cao hơn Bạch Vân vì vị trí sát khu vui chơi, phố đi bộ biển Emerald Boulevard dài khoảng 1,3 km và có lựa chọn căn hoàn thiện nhận cam kết thuê.</p>

<h2>Vì sao giá Vinhomes Hải Vân Bay 2026 chênh giữa các phân khu?</h2>
<ul>
<li><strong>Vị trí và tiện ích:</strong> căn gần VinWonders, mặt biển, mặt hồ có giá cao hơn căn phía trong.</li>
<li><strong>Tiến độ:</strong> Bạch Vân nhận nhà sớm nhất; Vịnh Mây đi sau, bù lại bằng đơn giá thấp và giãn xây 24 tháng.</li>
<li><strong>Tình trạng bàn giao:</strong> căn hoàn thiện nội thất có giá khác nhà thô.</li>
<li><strong>Chính sách:</strong> ưu đãi từ 19/11/2026 (thanh toán sớm 7,5%, voucher tới 30%, VinClub) làm giá thực trả của từng khách khác nhau.</li>
</ul>

<h2>Cần bao nhiêu vốn với giá Vinhomes Hải Vân Bay 2026?</h2>
<p>Theo chính sách hiện hành, ngân hàng cho vay tới 70% giá trị căn. Với căn liền kề Bạch Vân chỉ từ khoảng 5,3 tỷ, phần vốn tự có 30% vào khoảng 1,6 tỷ; số tiền thực tế còn phụ thuộc phương án vay (PA1 lãi cố định hay PA2 lãi 0%) và ưu đãi được áp dụng. Chi tiết xem bài <a href="/chinh-sach-vinhomes-hai-van-bay-19-11-2026/">chính sách Vinhomes Hải Vân Bay từ 19/11/2026</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Nếu ngân sách khoảng 5 – 6 tỷ, liền kề Bạch Vân hoặc Vịnh Mây là hai lựa chọn chính: Bạch Vân nhận nhà sớm, Vịnh Mây đơn giá thấp và giãn xây lâu hơn. Ngân sách từ 15 tỷ trở lên nên so biệt thự đơn lập Vịnh Mây (tầm nhìn vịnh từ đồi) với đơn lập Đảo Ngọc (gần VinWonders, phố biển). Giá Vinhomes Hải Vân Bay 2026 thay đổi theo đợt, vì vậy hãy xin bảng giá đúng ngày trước khi đặt cọc. Theo <a href="https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html">VnExpress</a>, dự án được Vinhomes ra mắt ngày 20/4/2026.</p>
<p>Xem thêm trang <a href="/du-an/vinhomes-hai-van-bay/">dự án Vinhomes Hải Vân Bay</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá từng căn và phiếu tính giá theo chính sách mới nhất.</p>
<p class="src">Nguồn: giỏ hàng tháng 9 – 10/2026 (giá gồm VAT, tham khảo); tài liệu chủ đầu tư; <a href="https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html">VnExpress</a>; <a href="https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay">Vinhomes</a>. Phối cảnh mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá Vinhomes Hải Vân Bay 2026: liền kề chỉ từ 5,3 tỷ',
			'desc'      => 'Giá Vinhomes Hải Vân Bay 2026 theo phân khu: Bạch Vân liền kề từ 5,3 tỷ, Vịnh Mây từ 5,6 tỷ, Đảo Ngọc từ 7,6 tỷ, đơn lập từ 11,1 tỷ (tham khảo, gồm VAT).',
			'points'    => array(
				'Giá Vinhomes Hải Vân Bay 2026 theo giỏ hàng 9 – 10/2026 (gồm VAT): liền kề Bạch Vân chỉ từ khoảng 5,3 tỷ, Vịnh Mây từ 5,6 tỷ, Đảo Ngọc từ 7,6 tỷ',
				'Giá Vinhomes Hải Vân Bay 2026 dòng biệt thự: đơn lập Bạch Vân từ 11,1 tỷ, Vịnh Mây từ 15,1 tỷ, Đảo Ngọc từ 15,8 tỷ; song lập Bạch Vân từ 9,4 tỷ',
				'Tinh Vân chưa mở bán; vay tới 70% theo chính sách từ 19/11/2026',
			),
			'faq'       => array(
				array( 'Giá Vinhomes Hải Vân Bay 2026 thấp nhất bao nhiêu?', 'Theo giỏ hàng tháng 9 – 10/2026 (gồm VAT, tham khảo), liền kề Bạch Vân chỉ từ khoảng 5,3 tỷ – mức vào cửa thấp nhất dự án.' ),
				array( 'Phân khu nào có biệt thự đơn giá thấp nhất?', 'Xét giá Vinhomes Hải Vân Bay 2026, Vịnh Mây có biệt thự đơn lập trên đồi có đơn giá từ khoảng 60 triệu/m² đất, giá chỉ từ khoảng 15,1 tỷ.' ),
				array( 'Vì sao Đảo Ngọc giá cao hơn Bạch Vân?', 'Đảo Ngọc là phân khu trung tâm, kết nối VinWonders Hải Vân và phố đi bộ biển, có căn hoàn thiện nhận cam kết thuê nên giá vào cửa cao hơn.' ),
				array( 'Tinh Vân có giá chưa?', 'Chưa. Tính đến 11/2026, Tinh Vân (Khu 4) chưa mở bán và chưa công bố giá.' ),
			),
		),
		'sources'  => $hvb_src,
	);

	/* ---------------- 3. Furama Villas – Giá biệt thự chuyển nhượng ---------------- */
	$posts[] = array(
		'slug'     => 'gia-biet-thu-furama-villas-da-nang-2026',
		'title'    => 'Giá biệt thự Furama Villas Đà Nẵng 2026: 3 – 4 phòng ngủ khoảng 21 – 40 tỷ, cần kiểm tra gì?',
		'excerpt'  => 'Giá biệt thự Furama Villas chuyển nhượng 2026: 3 phòng ngủ khoảng 21 – 25 tỷ, 4 phòng ngủ khoảng 30 – 40 tỷ (tin rao, tham khảo). 134 biệt thự đất 280 – 980 m² cạnh Furama Resort – chi phí, pháp lý cần kiểm tra.',
		'keyword'  => 'giá biệt thự Furama Villas',
		'keywords_extra' => array( 'Furama Villas Đà Nẵng', 'biệt thự Furama chuyển nhượng', 'biệt thự biển Ngũ Hành Sơn' ),
		'project'  => 'furama-villas-da-nang',
		'schedule' => '2026-11-24 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Furama Villas', 'Biệt thự biển', 'Ngũ Hành Sơn' ),
		'image'    => 'plugin:img/du-an-bia/furama-villas-da-nang.jpg',
		'image_alt' => 'Giá biệt thự Furama Villas Đà Nẵng 2026 – biệt thự nghỉ dưỡng Ngũ Hành Sơn',
		'content'  => <<<'HTML'
<p><strong>Giá biệt thự Furama Villas</strong> trên thị trường chuyển nhượng năm 2026 vào khoảng 21 – 25 tỷ cho căn 3 phòng ngủ và 30 – 40 tỷ cho căn 4 phòng ngủ, theo tổng hợp tin rao công khai (tham khảo, không phải giá chốt). Đây là khu biệt thự nghỉ dưỡng có mức vốn dễ tiếp cận nhất trong nhóm resort trên trục Võ Nguyên Giáp – Trường Sa. Bài viết giúp anh chị đọc đúng mức giá và những điểm phải kiểm tra trước khi xuống tiền.</p>
<!--hh-featured-->
<h2>Furama Villas Đà Nẵng: thông tin chính</h2>
<table>
<tbody>
<tr><td>Vị trí</td><td>Đường Võ Nguyên Giáp – Trường Sa, Ngũ Hành Sơn, cạnh Furama Resort, bãi biển Non Nước – Mỹ Khê</td></tr>
<tr><td>Chủ đầu tư</td><td>Công ty CP Ariyana (Sovico Holdings)</td></tr>
<tr><td>Quy mô</td><td>134 biệt thự</td></tr>
<tr><td>Diện tích đất</td><td>Khoảng 280 – 980 m²</td></tr>
<tr><td>Loại căn</td><td>3 – 4 phòng ngủ</td></tr>
<tr><td>Vận hành</td><td>Furama Resort Đà Nẵng nhận quản lý 131 căn (theo báo chí)</td></tr>
<tr><td>Tình trạng</td><td>Đã hoàn thiện, giao dịch chuyển nhượng</td></tr>
</tbody>
</table>
<p>Vị trí là yếu tố chính tạo nên giá biệt thự Furama Villas: khu nằm cạnh Cung Hội nghị Quốc tế Ariyana (nơi phục vụ APEC 2017) và Furama Resort – thương hiệu nghỉ dưỡng lâu năm của Đà Nẵng. Các trang đặt phòng quốc tế hiện giới thiệu Furama Villas Danang cho thuê theo các hạng 2 – 4 phòng ngủ, mỗi căn có hồ bơi riêng; hạng 4 phòng ngủ có hướng nhìn biển và lối ra bãi biển.</p>

<h2>Bảng giá biệt thự Furama Villas chuyển nhượng 2026</h2>
<!--hh-img:img/du-an-bia/furama-villas-da-nang.jpg|Giá biệt thự Furama Villas Đà Nẵng 2026 – biệt thự nghỉ dưỡng cạnh Furama Resort, Ngũ Hành Sơn-->
<table>
<thead><tr><th>Loại căn</th><th>Giá chuyển nhượng tham khảo</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Biệt thự 3 phòng ngủ</td><td>Khoảng 21 – 25 tỷ</td><td>Mức vào cửa của khu</td></tr>
<tr><td>Biệt thự 4 phòng ngủ</td><td>Khoảng 30 – 40 tỷ</td><td>Căn đất rộng, vị trí gần biển cao hơn</td></tr>
</tbody>
</table>
<p>Giá biệt thự Furama Villas trong bảng tổng hợp từ tin rao chuyển nhượng công khai năm 2026, chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc vị trí (hàng đầu hướng biển hay phía trong), diện tích đất, tình trạng nội thất, hợp đồng vận hành đi kèm và loại sổ của từng căn.</p>

<h2>Giá biệt thự Furama Villas so với các khu lân cận</h2>
<table>
<thead><tr><th>Khu biệt thự</th><th>Diện tích đất</th><th>Giá tham khảo (tin rao 2026)</th></tr></thead>
<tbody>
<tr><td>Furama Villas</td><td>280 – 980 m²</td><td>Khoảng 21 – 40 tỷ</td></tr>
<tr><td><a href="/du-an/the-ocean-villas-da-nang/">The Ocean Villas</a></td><td>500 – 808 m²</td><td>Khoảng 28,5 – 70 tỷ</td></tr>
<tr><td><a href="/du-an/fusion-resort-villas-da-nang/">Fusion Resort &amp; Villas</a></td><td>Khoảng 486 – 700 m²</td><td>Khoảng 32 – 54 tỷ</td></tr>
<tr><td>Hyatt Regency Villas</td><td>Có căn khoảng 600 m²</td><td>3PN khoảng 50 tỷ</td></tr>
</tbody>
</table>
<p>So trên cùng trục biển Ngũ Hành Sơn, giá biệt thự Furama Villas thấp hơn rõ so với The Ocean Villas, Fusion hay Hyatt. Phần so sánh chi tiết pháp lý và vận hành xem bài <a href="/so-sanh-villa-ven-bien-da-nang-co-so/">so sánh villa ven biển Đà Nẵng có sổ</a>.</p>

<h2>Chi phí ngoài giá biệt thự Furama Villas</h2>
<p>Khi mua căn chuyển nhượng, hai khoản thuế, phí lớn nhất là thuế thu nhập cá nhân 2% giá chuyển nhượng (bên bán nộp theo luật, trừ khi hai bên thỏa thuận khác) và lệ phí trước bạ 0,5% (bên mua nộp).</p>
<table>
<thead><tr><th>Giá căn</th><th>Lệ phí trước bạ 0,5%</th><th>Thuế TNCN 2%</th></tr></thead>
<tbody>
<tr><td>21 tỷ</td><td>Khoảng 105 triệu</td><td>Khoảng 420 triệu</td></tr>
<tr><td>30 tỷ</td><td>Khoảng 150 triệu</td><td>Khoảng 600 triệu</td></tr>
<tr><td>40 tỷ</td><td>Khoảng 200 triệu</td><td>Khoảng 800 triệu</td></tr>
</tbody>
</table>
<p>Ngoài ra cần dự trù phí công chứng, phí quản lý – bảo trì hằng năm của khu nghỉ dưỡng và chi phí cải tạo nội thất, hồ bơi vốn chịu tác động của gió biển, hơi muối. Cách tính chi tiết có trong bài <a href="/thue-phi-mua-ban-nha-dat-da-nang-2026/">thuế phí mua bán nhà đất 2026</a>.</p>

<h2>Pháp lý và hợp đồng vận hành: kiểm tra từng căn</h2>
<p>Một số nguồn giới thiệu biệt thự Furama Villas được cấp sổ sở hữu lâu dài, nhưng cũng có tin rao nêu căn theo thời hạn 50 năm. Loại sổ ảnh hưởng lớn đến giá biệt thự Furama Villas, vì vậy không áp chung cho cả khu: cần đọc mục đích sử dụng đất và thời hạn ghi trên sổ của đúng căn định mua, kiểm tra tình trạng thế chấp tại văn phòng đăng ký đất đai.</p>
<p>Theo báo chí thời điểm chào bán, chủ biệt thự được nghỉ miễn phí một thời gian mỗi năm, thời gian còn lại hợp tác cho thuê qua Furama. Người mua lại cần xem hợp đồng vận hành hiện hành: tỷ lệ chia doanh thu, số đêm chủ được ở, phí quản lý và điều kiện rút khỏi chương trình.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với ngân sách khoảng 20 – 40 tỷ và mong muốn có ngay biệt thự biển hoàn thiện, đã vận hành, giá biệt thự Furama Villas là điểm vào hợp lý nhất trên trục Trường Sa. Nếu ưu tiên sổ lâu dài và chấp nhận chờ bàn giao, anh chị có thể so thêm biệt thự đơn lập <a href="/du-an/vinhomes-hai-van-bay-vinh-may/">Vịnh Mây – Vinhomes Hải Vân Bay</a> chỉ từ khoảng 15,1 tỷ. Thông tin dự án do <a href="https://vnexpress.net/khu-biet-thu-furama-villas-2701751.html">VnExpress</a> giới thiệu: 134 căn, đất khoảng 280 – 976 m², 3 – 4 phòng ngủ.</p>
<p>Xem trang <a href="/du-an/furama-villas-da-nang/">Furama Villas Đà Nẵng</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận danh sách căn đang chuyển nhượng thật, kèm thông tin sổ và giá biệt thự Furama Villas chốt gần nhất.</p>
<p class="src">Nguồn: <a href="https://vnexpress.net/khu-biet-thu-furama-villas-2701751.html">VnExpress</a>; <a href="https://vneconomy.vn/furama-resort-se-quan-ly-du-an-furama-villas.htm">VnEconomy</a>; tổng hợp tin rao chuyển nhượng công khai 2026 (tham khảo).</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Giá biệt thự Furama Villas 2026: khoảng 21 – 40 tỷ',
			'desc'      => 'Giá biệt thự Furama Villas 2026: 3 phòng ngủ khoảng 21 – 25 tỷ, 4 phòng ngủ 30 – 40 tỷ (tin rao). 134 căn cạnh Furama Resort – thuế phí, pháp lý cần kiểm tra.',
			'points'    => array(
				'Giá biệt thự Furama Villas chuyển nhượng 2026 (tin rao, tham khảo): 3 phòng ngủ khoảng 21 – 25 tỷ, 4 phòng ngủ khoảng 30 – 40 tỷ',
				'134 biệt thự, đất khoảng 280 – 980 m², cạnh Furama Resort trên trục Võ Nguyên Giáp – Trường Sa, Ngũ Hành Sơn',
				'Trước khi chốt giá biệt thự Furama Villas, cần kiểm tra loại sổ (lâu dài hay 50 năm), hợp đồng vận hành; dự trù trước bạ 0,5% và thuế TNCN 2%',
			),
			'faq'       => array(
				array( 'Giá biệt thự Furama Villas hiện nay bao nhiêu?', 'Theo tin rao chuyển nhượng năm 2026 (tham khảo), căn 3 phòng ngủ khoảng 21 – 25 tỷ, căn 4 phòng ngủ khoảng 30 – 40 tỷ.' ),
				array( 'Furama Villas có bao nhiêu căn?', 'Khu có 134 biệt thự, đất khoảng 280 – 980 m², do Công ty CP Ariyana (Sovico Holdings) đầu tư.' ),
				array( 'Biệt thự Furama Villas có sổ lâu dài không?', 'Thông tin không đồng nhất giữa các nguồn; cần kiểm tra mục đích sử dụng đất và thời hạn ghi trên sổ của từng căn.' ),
				array( 'Mua Furama Villas cần thêm chi phí gì?', 'Ngoài giá biệt thự Furama Villas, cần tính lệ phí trước bạ 0,5%, thuế TNCN 2% (theo thỏa thuận), phí công chứng, phí quản lý – bảo trì hằng năm và chi phí cải tạo nếu căn đã cũ.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/khu-biet-thu-furama-villas-2701751.html',
			'https://vneconomy.vn/furama-resort-se-quan-ly-du-an-furama-villas.htm',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-furama-villas',
		),
	);

	/* ---------------- 4. Vinhomes Hải Vân Bay – Pháp lý ---------------- */
	$posts[] = array(
		'slug'     => 'phap-ly-vinhomes-hai-van-bay-so-huu-lau-dai',
		'title'    => 'Pháp lý Vinhomes Hải Vân Bay: sản phẩm nào sở hữu lâu dài, sản phẩm nào 50 năm?',
		'excerpt'  => 'Pháp lý Vinhomes Hải Vân Bay: chủ trương đầu tư điều chỉnh 20/11/2024 (512 ha, khoảng 44.000 tỷ), hơn 90% thấp tầng trên đất ở đô thị sở hữu lâu dài; Tinh Vân và sản phẩm đất du lịch, thương mại 50 năm. Những điều cần kiểm tra khi ký.',
		'keyword'  => 'pháp lý Vinhomes Hải Vân Bay',
		'keywords_extra' => array( 'sổ đỏ Vinhomes Hải Vân Bay', 'Vinhomes Hải Vân Bay sở hữu lâu dài', 'Khu đô thị nghỉ dưỡng Làng Vân' ),
		'project'  => 'vinhomes-hai-van-bay',
		'schedule' => '2026-11-25 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Vinhomes Hải Vân Bay', 'Pháp lý', 'Sổ đỏ' ),
		'image'    => 'plugin:img/vinhomes-hai-van-bay/vhvb-dao-ngoc-tong-the-3.jpg',
		'image_alt' => 'Pháp lý Vinhomes Hải Vân Bay – toàn cảnh Đảo Ngọc ôm vịnh Nam Chơn (phối cảnh chủ đầu tư)',
		'content'  => <<<'HTML'
<p><strong>Pháp lý Vinhomes Hải Vân Bay</strong> là câu hỏi đầu tiên của nhiều khách khi tìm hiểu đô thị biển 512 ha dưới chân đèo Hải Vân: dự án đã có chủ trương đầu tư chưa, sản phẩm nào được sở hữu lâu dài, sản phẩm nào chỉ 50 năm. Bài viết tổng hợp các mốc pháp lý đã công bố và danh sách điểm cần kiểm tra khi ký hợp đồng mua bán.</p>
<!--hh-featured-->
<h2>Các mốc pháp lý Vinhomes Hải Vân Bay đã công bố</h2>
<table>
<thead><tr><th>Mốc</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>Tên pháp lý</td><td>Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân</td></tr>
<tr><td>Chủ đầu tư</td><td>Công ty CP Vinpearl; Vinhomes phát triển (Tập đoàn Vingroup)</td></tr>
<tr><td>20/11/2024</td><td>Thủ tướng Chính phủ điều chỉnh chủ trương đầu tư: 512 ha, gần 44.000 tỷ đồng, thực hiện 5 năm</td></tr>
<tr><td>22/6/2025</td><td>Khởi công dự án</td></tr>
<tr><td>20/4/2026</td><td>Vinhomes ra mắt tên thương mại Vinhomes Hải Vân Bay, mở bán Bạch Vân</td></tr>
<tr><td>Quý 4/2026</td><td>Khoảng 345 căn thấp tầng Bạch Vân bàn giao thô (dự kiến)</td></tr>
</tbody>
</table>
<p>Theo <a href="https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm">Tuổi Trẻ</a>, Vinpearl khởi công dự án khoảng 44.000 tỷ đồng dưới chân đèo Hải Vân ngày 22/6/2025. "Vinhomes Làng Vân" và "Vinhomes Hải Vân Bay" là cùng một dự án.</p>

<h2>Sở hữu lâu dài hay 50 năm: pháp lý Vinhomes Hải Vân Bay theo loại sản phẩm</h2>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-dao-ngoc-tong-the-4.jpg|Pháp lý Vinhomes Hải Vân Bay: phần lớn thấp tầng Đảo Ngọc, Bạch Vân, Vịnh Mây sở hữu lâu dài (phối cảnh chủ đầu tư)-->
<table>
<thead><tr><th>Sản phẩm</th><th>Loại đất</th><th>Thời hạn</th></tr></thead>
<tbody>
<tr><td>Liền kề, shophouse, biệt thự Bạch Vân, Vịnh Mây, Đảo Ngọc</td><td>Đất ở đô thị</td><td>Lâu dài (người Việt Nam)</td></tr>
<tr><td>Phân khu Tinh Vân (Khu 4)</td><td>Đất du lịch</td><td>50 năm</td></tr>
<tr><td>Condotel, khách sạn, shop khối đế</td><td>Đất thương mại – dịch vụ</td><td>50 năm</td></tr>
</tbody>
</table>
<p>Theo pháp lý Vinhomes Hải Vân Bay đã công bố, hơn 90% sản phẩm thấp tầng của dự án nằm trên đất ở đô thị nên được sở hữu lâu dài – lợi thế hiếm với bất động sản ven biển, nơi nhiều dự án chỉ có thời hạn 50 năm. Báo <a href="https://tienphong.vn/so-do-lau-dai-gia-tri-thuc-tao-loi-the-khong-doi-thu-cho-do-thi-vinh-bien-vinhomes-hai-van-bay-post1831206.tpo">Tiền Phong</a> cũng nhấn mạnh yếu tố sổ đỏ lâu dài này.</p>
<p>Khi tìm hiểu pháp lý Vinhomes Hải Vân Bay, khác biệt giữa hai loại thời hạn ảnh hưởng trực tiếp đến khả năng thế chấp vay ngân hàng, thanh khoản khi bán lại và giá trị để lại cho con cháu. Xem phân tích kỹ hơn ở bài <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">sở hữu lâu dài hay 50 năm</a>.</p>

<h2>Pháp lý Vinhomes Hải Vân Bay khi mua nhà hình thành trong tương lai</h2>
<p>Phần lớn sản phẩm đang bán là nhà chưa hoàn thiện, nên pháp lý Vinhomes Hải Vân Bay ở giai đoạn này gắn với quy định về nhà ở hình thành trong tương lai của Luật Kinh doanh bất động sản 2023. Người mua nên chú ý:</p>
<ul>
<li><strong>Hợp đồng mua bán:</strong> ký với chủ đầu tư, ghi rõ mã lô, diện tích đất, diện tích sàn, tiến độ thanh toán và thời hạn bàn giao.</li>
<li><strong>Bảo lãnh ngân hàng:</strong> hỏi văn bản bảo lãnh nghĩa vụ tài chính của chủ đầu tư cho căn mình mua.</li>
<li><strong>Tiến độ thanh toán:</strong> đối chiếu với tiến độ xây dựng và chính sách đang áp dụng (chính sách hiện hành từ 19/11/2026).</li>
<li><strong>Điều khoản cam kết thuê:</strong> căn hoàn thiện Đảo Ngọc nhận cam kết 7%/năm phải bàn giao lại nhà cho chủ đầu tư khai thác trong 3 năm.</li>
</ul>

<h2>Hạn chế chuyển nhượng trong pháp lý Vinhomes Hải Vân Bay</h2>
<p>Theo chính sách từ 19/11/2026, căn dùng voucher Vinhomes (thanh toán tới 30% giá trị) bị hạn chế chuyển nhượng 03 tháng kể từ ngày dùng voucher. Khách chọn phương án về ở sớm ưu đãi 10% tại Đảo Ngọc cam kết về ở trong 3 tháng kể từ ngày nhận nhà. Đây là các điều kiện thương mại, cần đọc kỹ trong phụ lục hợp đồng – xem bài <a href="/chinh-sach-vinhomes-hai-van-bay-19-11-2026/">chính sách Vinhomes Hải Vân Bay</a>.</p>

<h2>Checklist kiểm tra pháp lý Vinhomes Hải Vân Bay trước khi ký</h2>
<ul>
<li>Căn thuộc phân khu nào, loại đất gì, thời hạn sử dụng ghi trong hợp đồng.</li>
<li>Thông tin bảo lãnh ngân hàng và tài khoản nhận tiền đứng tên chủ đầu tư.</li>
<li>Lịch bàn giao dự kiến và chế tài nếu chậm bàn giao.</li>
<li>Điều kiện của từng ưu đãi: voucher, về ở sớm, cam kết thuê, phương án vay.</li>
<li>Thời điểm dự kiến cấp giấy chứng nhận và nghĩa vụ phí, thuế của người mua.</li>
</ul>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Điểm mạnh nhất về pháp lý Vinhomes Hải Vân Bay là chủ trương đầu tư cấp Thủ tướng và phần lớn thấp tầng trên đất ở sở hữu lâu dài. Điểm cần theo dõi là tiến độ bàn giao và cấp sổ của từng phân khu, vì Bạch Vân đi trước, Vịnh Mây và Đảo Ngọc theo đợt. Khách muốn sổ lâu dài nên chọn Bạch Vân, Vịnh Mây, Đảo Ngọc; Tinh Vân 50 năm hợp với nhu cầu nghỉ dưỡng, khai thác. Xem thêm bài <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>
<p>Thông tin dự án tại trang <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận hồ sơ pháp lý Vinhomes Hải Vân Bay và mẫu hợp đồng mua bán của căn anh chị quan tâm.</p>
<p class="src">Nguồn: <a href="https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm">Tuổi Trẻ</a>; <a href="https://tienphong.vn/so-do-lau-dai-gia-tri-thuc-tao-loi-the-khong-doi-thu-cho-do-thi-vinh-bien-vinhomes-hai-van-bay-post1831206.tpo">Tiền Phong</a>; <a href="https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html">VnExpress</a>; chính sách bán hàng chủ đầu tư từ 19/11/2026. Phối cảnh mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Pháp lý Vinhomes Hải Vân Bay: 90% thấp tầng sổ lâu dài',
			'desc'      => 'Pháp lý Vinhomes Hải Vân Bay: chủ trương đầu tư 20/11/2024, hơn 90% thấp tầng sở hữu lâu dài, Tinh Vân 50 năm. Checklist kiểm tra hợp đồng trước khi ký.',
			'points'    => array(
				'Chủ trương đầu tư điều chỉnh 20/11/2024: 512 ha, gần 44.000 tỷ đồng; khởi công 22/6/2025, ra mắt 20/4/2026',
				'Pháp lý Vinhomes Hải Vân Bay: hơn 90% thấp tầng trên đất ở đô thị sở hữu lâu dài; Tinh Vân, condotel, khách sạn, shop khối đế 50 năm',
				'Căn dùng voucher hạn chế chuyển nhượng 3 tháng; cần kiểm tra bảo lãnh, tiến độ bàn giao và cấp sổ',
			),
			'faq'       => array(
				array( 'Pháp lý Vinhomes Hải Vân Bay đã có gì?', 'Dự án có chủ trương đầu tư điều chỉnh ngày 20/11/2024 (512 ha, gần 44.000 tỷ đồng), khởi công 22/6/2025 và mở bán từ 20/4/2026.' ),
				array( 'Vinhomes Hải Vân Bay có sổ đỏ lâu dài không?', 'Hơn 90% sản phẩm thấp tầng trên đất ở đô thị được sở hữu lâu dài cho người Việt Nam; Tinh Vân và sản phẩm đất du lịch, thương mại có thời hạn 50 năm.' ),
				array( 'Vinhomes Làng Vân và Vinhomes Hải Vân Bay có khác nhau?', 'Không. Về pháp lý Vinhomes Hải Vân Bay, tên dự án là Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân; tên thương mại là Vinhomes Hải Vân Bay.' ),
				array( 'Mua xong có bán lại ngay được không?', 'Theo pháp lý Vinhomes Hải Vân Bay và chính sách hiện hành, căn dùng voucher Vinhomes bị hạn chế chuyển nhượng 03 tháng kể từ ngày dùng voucher; các trường hợp khác theo điều khoản hợp đồng mua bán.' ),
			),
		),
		'sources'  => $hvb_src,
	);

	/* ---------------- 5. Vinhomes Làng Vân – Vị trí, kết nối ---------------- */
	$posts[] = array(
		'slug'     => 'vi-tri-vinhomes-lang-van-ket-noi-giao-thong',
		'title'    => 'Vị trí Vinhomes Làng Vân ở đâu? Kết nối hầm Hải Vân, cảng Liên Chiểu, trung tâm Đà Nẵng',
		'excerpt'  => 'Vị trí Vinhomes Làng Vân (Vinhomes Hải Vân Bay): vịnh Nam Chơn, chân đèo Hải Vân, phường Hải Vân, Đà Nẵng – khoảng 20 – 25 phút về trung tâm và sân bay, sát hầm Hải Vân, Quốc lộ 1A, gần cảng Liên Chiểu.',
		'keyword'  => 'vị trí Vinhomes Làng Vân',
		'keywords_extra' => array( 'Vinhomes Làng Vân ở đâu', 'vịnh Nam Chơn', 'Vinhomes Hải Vân Bay ở đâu' ),
		'project'  => 'vinhomes-hai-van-bay',
		'schedule' => '2026-11-26 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Vinhomes Hải Vân Bay', 'Làng Vân', 'Liên Chiểu' ),
		'image'    => 'plugin:img/vinhomes-hai-van-bay/vhvb-dao-ngoc-tong-the-4.jpg',
		'image_alt' => 'Vị trí Vinhomes Làng Vân tại vịnh Nam Chơn, chân đèo Hải Vân nhìn về Đà Nẵng (phối cảnh chủ đầu tư)',
		'content'  => <<<'HTML'
<p><strong>Vị trí Vinhomes Làng Vân</strong> nằm tại vịnh Nam Chơn, ngay dưới chân đèo Hải Vân, thuộc phường Hải Vân (trước đây Hòa Hiệp Bắc, Liên Chiểu) – cửa ngõ phía Bắc TP Đà Nẵng. Dự án mang tên thương mại Vinhomes Hải Vân Bay, quy mô 512 ha, ba mặt hướng biển và tựa lưng núi Hải Vân. Bài viết giải thích dự án ở đâu, đi trung tâm mất bao lâu và hạ tầng nào đang làm thay đổi khu vực này.</p>
<!--hh-featured-->
<h2>Vinhomes Làng Vân ở đâu?</h2>
<table>
<tbody>
<tr><td>Địa chỉ</td><td>Vịnh Nam Chơn (Làng Vân), chân đèo Hải Vân, phường Hải Vân, TP Đà Nẵng</td></tr>
<tr><td>Tên thương mại</td><td>Vinhomes Hải Vân Bay</td></tr>
<tr><td>Quy mô</td><td>Khoảng 512 ha, 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân</td></tr>
<tr><td>Bãi biển</td><td>Bãi biển Làng Vân, vịnh kín gió được núi bao bọc</td></tr>
<tr><td>Về trung tâm, sân bay</td><td>Khoảng 20 – 25 phút</td></tr>
</tbody>
</table>
<p>Vịnh Nam Chơn được núi Hải Vân che chắn, bãi biển Làng Vân kín gió và còn hoang sơ – một trong số ít quỹ đất ven biển quy mô lớn còn lại của Đà Nẵng. Vị trí Vinhomes Làng Vân vì vậy khác hẳn các dự án trên trục biển Mỹ Khê: không nằm giữa phố mà là một vịnh riêng.</p>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-tmb-dinh-vi-kien-truc.jpg|Vị trí Vinhomes Làng Vân: 4 phân khu trải dọc vịnh Nam Chơn từ cửa ngõ Bạch Vân đến Tinh Vân (tài liệu chủ đầu tư)-->

<h2>Kết nối giao thông từ vị trí Vinhomes Làng Vân</h2>
<table>
<thead><tr><th>Hướng</th><th>Kết nối</th></tr></thead>
<tbody>
<tr><td>Ngay chân đèo</td><td>Đèo Hải Vân, hầm Hải Vân</td></tr>
<tr><td>Trục chính</td><td>Quốc lộ 1A, cao tốc La Sơn – Túy Loan</td></tr>
<tr><td>Lân cận</td><td>Cảng Liên Chiểu, đường sắt Bắc – Nam</td></tr>
<tr><td>Khoảng 20 – 25 phút</td><td>Trung tâm Đà Nẵng, sân bay quốc tế</td></tr>
<tr><td>Qua hầm Hải Vân</td><td>Lăng Cô, Cố đô Huế</td></tr>
</tbody>
</table>
<p>Phân khu <a href="/du-an/vinhomes-hai-van-bay-bach-van/">Bạch Vân</a> nằm ở cửa ngõ phía Nam, gần Quốc lộ 1A và lối vào hầm Hải Vân, nên là phân khu đi lại thuận tiện nhất về trung tâm. Từ Bạch Vân, đường nội khu dẫn tới Vịnh Mây trên sườn đồi, Đảo Ngọc ở trung tâm và Tinh Vân ở phía trong vịnh.</p>

<h2>Hạ tầng đang thay đổi vị trí Vinhomes Làng Vân</h2>
<h3>Đường tránh Nam Hải Vân mở rộng 6 làn</h3>
<p>Đà Nẵng đã phê duyệt mở rộng đường tránh Nam Hải Vân đoạn Hòa Liên – đường ven biển nối cảng Liên Chiểu, khoảng 5,36 km, 6 làn xe, tổng mức hơn 1.951 tỷ đồng, thực hiện giai đoạn 2025 – 2029. Trục này nối hầm Hải Vân với cao tốc và khu Liên Chiểu – chi tiết ở bài <a href="/duong-tranh-nam-hai-van-6-lan-lien-chieu/">đường tránh Nam Hải Vân</a>.</p>
<h3>Cảng Liên Chiểu và khu thương mại tự do</h3>
<p>Phần hạ tầng dùng chung cảng Liên Chiểu (hơn 3.426 tỷ đồng) công bố hoàn thành ngày 28/3/2026; khu thương mại tự do Đà Nẵng khoảng 1.881 ha gắn với cảng đã được cho phép thành lập. Đây là động lực việc làm, dân cư cho phía Tây Bắc – xem bài <a href="/cang-lien-chieu-khu-thuong-mai-tu-do/">cảng Liên Chiểu và khu thương mại tự do</a>.</p>

<h2>Tiện ích quanh vị trí Vinhomes Làng Vân</h2>
<ul>
<li><strong>Trong dự án:</strong> bãi biển Làng Vân, VinWonders Hải Vân khoảng 24,8 ha (kết nối Đảo Ngọc, dự kiến hoàn thành quý 4/2027), phố đi bộ biển Emerald Boulevard khoảng 1,3 km, Lifestyle Hub và chợ Hong Kong ở Bạch Vân.</li>
<li><strong>Theo quy hoạch:</strong> Vincom, Vinschool, Vinmec, resort 5 sao.</li>
<li><strong>Lân cận:</strong> biển Nam Ô, Xuân Thiều; Đại học Bách khoa, Đại học Sư phạm Đà Nẵng; Khu công nghệ cao Đà Nẵng.</li>
</ul>

<h2>Ưu và nhược điểm của vị trí Vinhomes Làng Vân</h2>
<table>
<thead><tr><th>Ưu điểm</th><th>Cần cân nhắc</th></tr></thead>
<tbody>
<tr><td>Vịnh biển riêng, kín gió, núi bao bọc</td><td>Xa trung tâm hơn các dự án ven biển Mỹ Khê</td></tr>
<tr><td>Sát hầm Hải Vân, Quốc lộ 1A, đi Huế, Lăng Cô thuận tiện</td><td>Hạ tầng phía Tây Bắc vẫn đang thi công, cần thời gian</td></tr>
<tr><td>Hưởng lợi cảng Liên Chiểu, khu thương mại tự do</td><td>Tiện ích lớn (VinWonders) dự kiến 2027</td></tr>
</tbody>
</table>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Vị trí Vinhomes Làng Vân phù hợp người muốn một không gian biển riêng tư, quy mô lớn, chấp nhận đi xe khoảng 20 – 25 phút vào phố. Nếu cần nhận nhà sớm và đi lại nhiều, hãy ưu tiên Bạch Vân ở cửa ngõ; nếu ưu tiên tầm nhìn vịnh, xem Vịnh Mây hoặc Đảo Ngọc. Theo <a href="https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html">VnExpress</a>, dự án ra mắt ngày 20/4/2026 với phân khu Bạch Vân.</p>
<p>Xem trang <a href="/du-an/vinhomes-hai-van-bay/">dự án Vinhomes Hải Vân Bay</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để được đưa đi xem thực tế vị trí Vinhomes Làng Vân và nhà mẫu.</p>
<p class="src">Nguồn: <a href="https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html">VnExpress</a>; <a href="https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm">Tuổi Trẻ</a>; tài liệu chủ đầu tư; UBND TP Đà Nẵng (dự án đường tránh Nam Hải Vân). Phối cảnh mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Vị trí Vinhomes Làng Vân: 20 – 25 phút về trung tâm',
			'desc'      => 'Vị trí Vinhomes Làng Vân: vịnh Nam Chơn, chân đèo Hải Vân, Đà Nẵng; 20 – 25 phút về trung tâm, sát hầm Hải Vân, gần cảng Liên Chiểu. Ưu nhược điểm.',
			'points'    => array(
				'Vị trí Vinhomes Làng Vân: vịnh Nam Chơn, chân đèo Hải Vân, phường Hải Vân (trước đây Hòa Hiệp Bắc, Liên Chiểu), Đà Nẵng',
				'Khoảng 20 – 25 phút về trung tâm, sân bay; sát hầm Hải Vân, Quốc lộ 1A, cao tốc La Sơn – Túy Loan',
				'Hưởng lợi đường tránh Nam Hải Vân 6 làn (hơn 1.951 tỷ), cảng Liên Chiểu và khu thương mại tự do khoảng 1.881 ha',
			),
			'faq'       => array(
				array( 'Vinhomes Làng Vân ở đâu?', 'Tại vịnh Nam Chơn (Làng Vân), dưới chân đèo Hải Vân, phường Hải Vân, TP Đà Nẵng; tên thương mại là Vinhomes Hải Vân Bay.' ),
				array( 'Từ vị trí Vinhomes Làng Vân vào trung tâm mất bao lâu?', 'Khoảng 20 – 25 phút đi xe về trung tâm Đà Nẵng và sân bay quốc tế.' ),
				array( 'Phân khu nào gần lối ra vào nhất?', 'Bạch Vân ở cửa ngõ phía Nam dự án, gần Quốc lộ 1A và lối vào hầm Hải Vân.' ),
				array( 'Hạ tầng nào tác động đến khu vực?', 'Đường tránh Nam Hải Vân mở rộng 6 làn, cảng Liên Chiểu và khu thương mại tự do Đà Nẵng.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html',
			'https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm',
			'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
		),
	);

	/* ---------------- 6. Đảo Ngọc hay Bạch Vân ---------------- */
	$posts[] = array(
		'slug'     => 'dao-ngoc-hay-bach-van-vinhomes-hai-van-bay',
		'title'    => 'Đảo Ngọc hay Bạch Vân: nên chọn phân khu nào ở Vinhomes Hải Vân Bay?',
		'excerpt'  => 'Đảo Ngọc hay Bạch Vân? So sánh hai phân khu Vinhomes Hải Vân Bay về vị trí, quy mô, giá chỉ từ (5,3 tỷ và 7,6 tỷ), tiến độ, tiện ích và chính sách từ 19/11/2026 – chọn theo mục đích ở, cho thuê hay kinh doanh.',
		'keyword'  => 'Đảo Ngọc hay Bạch Vân',
		'keywords_extra' => array( 'so sánh Đảo Ngọc và Bạch Vân', 'nên mua phân khu nào Vinhomes Hải Vân Bay', 'Đảo Ngọc Vinhomes Hải Vân Bay' ),
		'project'  => 'vinhomes-hai-van-bay',
		'schedule' => '2026-11-27 11:30',
		'category' => 'Tin dự án',
		'tags'     => array( 'Vinhomes Hải Vân Bay', 'Đảo Ngọc', 'Bạch Vân' ),
		'image'    => 'plugin:img/vinhomes-hai-van-bay/vhvb-biet-thu-dao-ngoc.jpg',
		'image_alt' => 'Đảo Ngọc hay Bạch Vân – dãy biệt thự Đảo Ngọc bên phố đi bộ (phối cảnh chủ đầu tư)',
		'content'  => <<<'HTML'
<p><strong>Đảo Ngọc hay Bạch Vân</strong> là câu hỏi nhiều khách đặt ra khi chọn mua ở Vinhomes Hải Vân Bay, vì đây là hai phân khu đang bán có quỹ căn lớn nhất. Bạch Vân ở cửa ngõ, nhận nhà sớm, giá vào cửa thấp; Đảo Ngọc ở trung tâm, cạnh VinWonders, hợp khai thác du lịch. Bài viết so sánh từng tiêu chí để anh chị chọn đúng theo mục đích.</p>
<!--hh-featured-->
<h2>So sánh nhanh Đảo Ngọc hay Bạch Vân</h2>
<table>
<thead><tr><th>Tiêu chí</th><th>Bạch Vân (Khu 1)</th><th>Đảo Ngọc (Khu 3)</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Cửa ngõ, gần Quốc lộ 1A, hầm Hải Vân</td><td>Trung tâm dự án, kết nối VinWonders Hải Vân</td></tr>
<tr><td>Diện tích</td><td>Khoảng 112 ha</td><td>Khoảng 138,8 ha</td></tr>
<tr><td>Phong cách</td><td>Hong Kong</td><td>Costa Smeralda (Ý)</td></tr>
<tr><td>Quỹ căn</td><td>~2.524 căn thấp tầng + 15 tòa cao tầng</td><td>2.376 căn thấp tầng</td></tr>
<tr><td>Mở bán</td><td>20/4/2026</td><td>5/5/2026</td></tr>
<tr><td>Liền kề chỉ từ</td><td>Khoảng 5,3 tỷ</td><td>Khoảng 7,6 tỷ</td></tr>
<tr><td>Bàn giao</td><td>~345 căn thô quý 4/2026 (dự kiến)</td><td>Theo tiến độ từng đợt</td></tr>
<tr><td>Ưu đãi riêng (từ 19/11/2026)</td><td>Về ở sớm 10%</td><td>Cam kết thuê 7%/năm × 3 năm</td></tr>
</tbody>
</table>
<p>Khi so Đảo Ngọc hay Bạch Vân, giá chỉ từ lấy theo giỏ hàng tháng 9 – 10/2026, đã gồm VAT, tham khảo. Liên hệ để nhận giá từng căn.</p>

<h2>Bạch Vân: vốn thấp, nhận nhà sớm</h2>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-facade-lien-ke-bach-van-shanghai.jpg|Đảo Ngọc hay Bạch Vân: phố liền kề Bạch Vân phong cách Hong Kong, nhộn nhịp thương mại (phối cảnh chủ đầu tư)-->
<p><a href="/du-an/vinhomes-hai-van-bay-bach-van/">Bạch Vân</a> có liền kề đất 63 – 140 m², shophouse, song lập 140 – 160 m² (chỉ từ khoảng 9,4 tỷ) và đơn lập 140 – 290 m² (chỉ từ khoảng 11,1 tỷ). Tiện ích nội khu thiên về thương mại – giải trí: Lifestyle Hub, chợ Hong Kong, làng ẩm thực ven suối, Hồ Ngọc Trai.</p>
<p>Khi cân nhắc Đảo Ngọc hay Bạch Vân, lợi thế lớn nhất của Bạch Vân là tiến độ: Bạch Vân là phân khu bàn giao đầu tiên của dự án, phù hợp gia đình muốn về ở hoặc mở kinh doanh dịch vụ sớm. Chính sách từ 19/11/2026 còn có ưu đãi về ở sớm 10% cho nhà thô xây ngay theo danh sách căn.</p>

<h2>Đảo Ngọc: trung tâm giải trí, hợp khai thác du lịch</h2>
<!--hh-img:img/vinhomes-hai-van-bay/vhvb-emerald-park-2.jpg|Phố đi bộ biển Emerald Boulevard – lợi thế khi cân nhắc Đảo Ngọc hay Bạch Vân (phối cảnh chủ đầu tư)-->
<p><a href="/du-an/vinhomes-hai-van-bay-dao-ngoc/">Đảo Ngọc</a> gồm khoảng 1.349 liền kề/shophouse và 1.027 biệt thự. Theo tổng mặt bằng tiện ích của chủ đầu tư, phân khu có VinWonders Hải Vân khoảng 24,8 ha, công viên Botanica Park khoảng 8 ha, Pearl Park khoảng 0,65 ha, phố đi bộ biển Emerald Boulevard dài khoảng 1,3 km và resort 5 sao khoảng 4,6 ha.</p>
<p>Đảo Ngọc có căn hoàn thiện nhận cam kết tiền thuê 7%/năm trong 3 năm; riêng 223 căn theo danh sách được chọn giữa cam kết thuê và về ở sớm ưu đãi 10%. Lưu ý căn hoàn thiện nội thất vay ngân hàng chỉ áp dụng phương án lãi cố định (PA1).</p>

<h2>Đảo Ngọc hay Bạch Vân: chọn theo mục đích</h2>
<table>
<thead><tr><th>Mục đích</th><th>Nên ưu tiên</th><th>Lý do</th></tr></thead>
<tbody>
<tr><td>Ở thật, nhận nhà sớm</td><td>Bạch Vân</td><td>Bàn giao đầu tiên, gần lối ra Quốc lộ 1A</td></tr>
<tr><td>Vốn khoảng 5 – 7 tỷ</td><td>Bạch Vân</td><td>Liền kề chỉ từ khoảng 5,3 tỷ</td></tr>
<tr><td>Kinh doanh ăn uống, dịch vụ cho cư dân</td><td>Bạch Vân</td><td>Phố thương mại, chợ Hong Kong, Lifestyle Hub</td></tr>
<tr><td>Cho thuê lưu trú du lịch</td><td>Đảo Ngọc</td><td>Cạnh VinWonders, phố đi bộ biển</td></tr>
<tr><td>Dòng tiền thụ động 3 năm</td><td>Đảo Ngọc</td><td>Cam kết thuê 7%/năm cho căn hoàn thiện</td></tr>
<tr><td>Biệt thự nghỉ dưỡng gia đình</td><td>Đảo Ngọc</td><td>Đơn lập từ 15,8 tỷ, nhiều công viên, hồ bơi nội khu</td></tr>
</tbody>
</table>

<h2>Điểm chung khi chọn Đảo Ngọc hay Bạch Vân</h2>
<p>Cả hai phân khu đều có phần lớn sản phẩm thấp tầng trên đất ở đô thị, sở hữu lâu dài cho người Việt Nam, cùng áp dụng ưu đãi chung từ 19/11/2026: thanh toán sớm 7,5%, voucher thanh toán tới 30% (dùng trước 31/12/2026), VinClub 0,5 – 0,9%, vay tới 70% với hai phương án. Chi tiết xem bài <a href="/chinh-sach-vinhomes-hai-van-bay-19-11-2026/">chính sách Vinhomes Hải Vân Bay</a> và <a href="/gia-vinhomes-hai-van-bay-2026-theo-phan-khu/">giá Vinhomes Hải Vân Bay 2026 theo phân khu</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Không có đáp án chung cho câu hỏi Đảo Ngọc hay Bạch Vân. Khách cần ở, vốn vừa phải nên chọn Bạch Vân; khách mua để khai thác du lịch hoặc muốn dòng tiền cam kết nên chọn Đảo Ngọc. Đảo Ngọc ra mắt ngày 5/5/2026 (theo <a href="https://vnexpress.net/ra-mat-khu-dao-ngoc-du-an-vinhomes-hai-van-bay-5070332.html">VnExpress</a>) và ghi nhận gần 1.000 lượt đặt chỗ trong 72 giờ (theo <a href="https://dantri.com.vn/bat-dong-san/dao-ngoc-vinhomes-hai-van-bay-ghi-nhan-1000-luot-dat-cho-trong-72-gio-20260426110141706.htm">Dân trí</a>), cho thấy sức hút của vị trí cạnh VinWonders. Dù chọn Đảo Ngọc hay Bạch Vân, hãy so đúng căn, đúng hướng và tính tổng tiền theo phương án vay trước khi đặt cọc.</p>
<p>Xem tổng quan tại trang <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng so sánh căn cụ thể giữa Đảo Ngọc hay Bạch Vân theo ngân sách của anh chị.</p>
<p class="src">Nguồn: tài liệu chủ đầu tư (tổng mặt bằng tiện ích Đảo Ngọc, chính sách từ 19/11/2026); <a href="https://vnexpress.net/ra-mat-khu-dao-ngoc-du-an-vinhomes-hai-van-bay-5070332.html">VnExpress</a>; <a href="https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay">Vinhomes</a>; giỏ hàng tháng 9 – 10/2026 (tham khảo). Phối cảnh mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đảo Ngọc hay Bạch Vân: so sánh 8 tiêu chí 2026',
			'desc'      => 'Đảo Ngọc hay Bạch Vân? So sánh 2 phân khu Vinhomes Hải Vân Bay: vị trí, quỹ căn, giá chỉ từ 5,3 – 7,6 tỷ, tiến độ, ưu đãi từ 19/11/2026, chọn theo mục đích.',
			'points'    => array(
				'Bạch Vân: cửa ngõ, ~2.524 căn thấp tầng, liền kề chỉ từ khoảng 5,3 tỷ, bàn giao thô đợt đầu quý 4/2026, ưu đãi về ở sớm 10%',
				'Đảo Ngọc: trung tâm, 2.376 căn, cạnh VinWonders Hải Vân, liền kề chỉ từ khoảng 7,6 tỷ, cam kết thuê 7%/năm × 3 năm',
				'Đảo Ngọc hay Bạch Vân: ở thật, vốn vừa phải chọn Bạch Vân; khai thác du lịch, dòng tiền cam kết chọn Đảo Ngọc',
			),
			'faq'       => array(
				array( 'Đảo Ngọc hay Bạch Vân nhận nhà sớm hơn?', 'Bạch Vân. Khoảng 345 căn thấp tầng Bạch Vân dự kiến bàn giao thô quý 4/2026; Đảo Ngọc bàn giao theo tiến độ từng đợt.' ),
				array( 'Đảo Ngọc hay Bạch Vân giá rẻ hơn?', 'Bạch Vân có giá vào cửa thấp hơn: liền kề chỉ từ khoảng 5,3 tỷ, so với khoảng 7,6 tỷ ở Đảo Ngọc (giỏ hàng 9 – 10/2026, gồm VAT, tham khảo).' ),
				array( 'Đảo Ngọc hay Bạch Vân có cam kết thuê?', 'Đảo Ngọc – căn hoàn thiện thuộc chương trình được cam kết tiền thuê 7%/năm trong 3 năm theo chính sách từ 19/11/2026.' ),
				array( 'Đảo Ngọc và Bạch Vân có sổ lâu dài không?', 'Có. Sản phẩm thấp tầng của hai phân khu nằm trên đất ở đô thị, sở hữu lâu dài cho người Việt Nam.' ),
			),
		),
		'sources'  => array(
			'https://vnexpress.net/ra-mat-khu-dao-ngoc-du-an-vinhomes-hai-van-bay-5070332.html',
			'https://dantri.com.vn/bat-dong-san/dao-ngoc-vinhomes-hai-van-bay-ghi-nhan-1000-luot-dat-cho-trong-72-gio-20260426110141706.htm',
			'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
		),
	);

	return $posts;
}
