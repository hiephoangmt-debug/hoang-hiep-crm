<?php
/**
 * Bài: Phân luồng giao thông thi công cụm nút giao cầu Hòa Xuân từ 9h ngày 31/10/2026.
 * Nguồn: SGGP, Tuổi Trẻ, Thanh Niên, VOV, VietTimes, Báo Đà Nẵng, Báo Xây dựng (28/10/2026); phạm vi phân luồng từ xa
 * theo sơ đồ phương án phân luồng của dự án. Không đăng lại sơ đồ gốc – ảnh đại diện tự vẽ.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_phan_luong_cau_hoa_xuan' );
function hh_posts_phan_luong_cau_hoa_xuan( $posts ) {
	$posts[] = array(
		'slug'      => 'phan-luong-giao-thong-cau-hoa-xuan-tu-31-10-2026',
		'title'     => 'Phân luồng giao thông cầu Hòa Xuân từ 31/10/2026: xe nào bị cấm, đi đường nào?',
		'excerpt'   => 'Từ 9h ngày 31/10/2026, Đà Nẵng phân luồng để thi công cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – cầu Hòa Xuân: cấm xe tải trên 2,5 tấn, xe khách từ 16 chỗ trong khu vực hạn chế; xe container đi cảng Tiên Sa đổi tuyến.',
		'keyword'   => 'phân luồng cầu Hòa Xuân',
		'project'   => '',
		'category'  => 'Hạ tầng & quy hoạch',
		'date'      => '2026-10-29 10:00:00',
		'image'         => 'plugin:img/tin-tuc/so-do-phan-luong-cau-hoa-xuan-31-10-2026.jpg',
		'image_alt'     => 'Sơ đồ phân luồng cầu Hòa Xuân từ 31/10/2026 – phạm vi phân luồng từ xa và phân luồng gần',
		'image_caption' => 'Sơ đồ phương án điều tiết, phân luồng giao thông từ xa thi công cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn lên cầu Hòa Xuân (đường đứt đỏ: phân luồng từ xa; đứt xanh: phân luồng gần). Nguồn: phương án phân luồng của dự án, báo chí đăng 28/10/2026.',
		'image_replace' => 'phan-luong-cau-hoa-xuan-31-10-2026',
		'old_meta'      => array(
			'rank_math_description' => array( 'Từ 9h 31/10/2026 Đà Nẵng phân luồng thi công nút giao cầu Hòa Xuân: cấm xe tải trên 2,5 tấn, xe khách từ 16 chỗ; container đi cảng Tiên Sa đổi tuyến. Chi tiết.' ),
		),
		'content'   => <<<'HTML'
<p><strong>Phân luồng cầu Hòa Xuân</strong> bắt đầu từ <strong>9h ngày 31/10/2026</strong>: TP Đà Nẵng tổ chức phân luồng giao thông để thi công <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn lên cầu Hòa Xuân</a> (khởi công 25/8/2026). Việc phân luồng gồm hai lớp: phân luồng từ xa để xe lớn tránh hẳn khu vực, và tổ chức giao thông ngay trong phạm vi công trường.</p>

<h2>Phân luồng cầu Hòa Xuân: tóm tắt nhanh</h2>
<table>
<thead><tr><th>Nội dung</th><th>Quy định</th></tr></thead>
<tbody>
<tr><td>Bắt đầu</td><td>9h ngày 31/10/2026</td></tr>
<tr><td>Xe tải trên 2,5 tấn, xe khách từ 16 chỗ</td><td>Cấm cả ngày (24/24) trong khu vực hạn chế</td></tr>
<tr><td>Xe kéo rơ moóc, sơ mi rơ moóc, xe tải phục vụ chợ đầu mối Hòa Cường</td><td>Cấm từ 4h đến 23h trên tuyến Nguyễn Hữu Thọ – Xô Viết Nghệ Tĩnh – Lê Thanh Nghị và chiều ngược lại</td></tr>
<tr><td>Xe tải đến 2,5 tấn</td><td>Tiếp tục cấm giờ cao điểm như quy định đã có</td></tr>
<tr><td>Dừng, đỗ xe</td><td>Cấm trên một số đoạn trong thời gian thi công, gồm Nguyễn Hữu Thọ, Trần Đăng Ninh, đoạn Lê Thanh Nghị gần chợ đầu mối</td></tr>
</tbody>
</table>

<h2>Phân luồng cầu Hòa Xuân: khu vực hạn chế gồm những đường nào?</h2>
<p>Theo báo chí, khu vực hạn chế phương tiện gồm các tuyến <strong>Lê Thanh Nghị, Cách Mạng Tháng Tám, Núi Thành, đường 2 Tháng 9, Đò Xu, Xô Viết Nghệ Tĩnh, Xuân Thủy, Nguyễn Phước Lan và Thăng Long</strong>.</p>
<p>Theo sơ đồ phương án phân luồng cầu Hòa Xuân của dự án, <strong>phạm vi phân luồng từ xa</strong> được giới hạn bởi:</p>
<ul>
<li>Phía Bắc: đường Xô Viết Nghệ Tĩnh</li>
<li>Phía Nam: đường 29 Tháng 3</li>
<li>Phía Đông: đường Thăng Long, Nguyễn Phước Lan</li>
<li>Phía Tây: đường Nguyễn Hữu Thọ, Võ Chí Công</li>
</ul>
<!--hh-featured-->
<p>Bấm vào sơ đồ phân luồng cầu Hòa Xuân để xem ảnh lớn. Các vị trí biển báo trên sơ đồ có thể được điều chỉnh khi thi công theo thực tế hiện trường.</p>

<h2>Phân luồng cầu Hòa Xuân: xe đi cảng Tiên Sa, xe container đi đường nào?</h2>
<ul>
<li>Xe kéo rơ moóc, sơ mi rơ moóc từ các hướng phía Nam đi cảng Tiên Sa được hướng dẫn đi theo <strong>Nam Kỳ Khởi Nghĩa – Trường Chinh – Quốc lộ 1A</strong>, có biển báo, cảnh báo từ xa.</li>
<li>Từ <strong>Quốc lộ 14B</strong>: rẽ phải tại nút Quốc lộ 14B – cầu vượt Hòa Cầm.</li>
<li>Từ <strong>ĐT605</strong>: rẽ phải tại nút ĐT605 – Quốc lộ 1A.</li>
</ul>
<p>Các báo nêu mức độ cấm trong phương án phân luồng cầu Hòa Xuân hơi khác nhau; khi đi qua khu vực, anh chị nên theo biển báo thực tế tại hiện trường và thông báo chính thức của thành phố.</p>

<h2>Công trình đang làm gì?</h2>
<p>Dự án cụm nút giao làm hai hầm chui trên đường Cách Mạng Tháng Tám và đường Thăng Long, mở rộng Lê Thanh Nghị và xây thêm một đơn nguyên cầu mới phía hạ lưu cầu Hòa Xuân hiện hữu. Thời gian thi công dự kiến <strong>730 ngày</strong> kể từ 25/8/2026; tổng mức đầu tư hơn 1.378 tỷ đồng (một số báo nêu khoảng 1.500 – 1.571 tỷ do khác phạm vi tính).</p>

<h2>Gợi ý đi lại trong thời gian phân luồng cầu Hòa Xuân</h2>
<p>Lệnh cấm trong phương án phân luồng cầu Hòa Xuân chủ yếu áp dụng với xe tải, xe khách cỡ lớn và xe container. Với người đi làm, đưa đón con hằng ngày, một số gợi ý thực tế:</p>
<ul>
<li><strong>Xe máy, ô tô con:</strong> đi theo biển báo và hướng dẫn tại hiện trường; nếu có thể, tránh giờ cao điểm sáng và chiều qua khu vực chân cầu.</li>
<li><strong>Người ở Hòa Xuân, Nam Hòa Xuân:</strong> tính thêm thời gian di chuyển về trung tâm, cân nhắc các tuyến khác qua sông Cẩm Lệ theo hướng dẫn phân luồng từ xa.</li>
<li><strong>Doanh nghiệp vận tải, xe giao hàng tải trọng lớn:</strong> lên lộ trình mới trước, nhất là xe đi cảng Tiên Sa và chợ đầu mối Hòa Cường.</li>
<li><strong>Theo dõi thông báo chính thức:</strong> vị trí biển báo, phạm vi rào chắn có thể được điều chỉnh theo từng giai đoạn thi công.</li>
</ul>

<h2>Ảnh hưởng tới người mua nhà khu Nam – nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Ngắn hạn (khoảng 2 năm thi công):</strong> trong thời gian phân luồng cầu Hòa Xuân, đi lại qua chân cầu, Cách Mạng Tháng Tám, Nguyễn Hữu Thọ chậm hơn, nhất là giờ cao điểm. Người đang ở Hòa Xuân, Hòa Cường, Khuê Trung nên tính lại giờ đi làm, đưa đón con.</li>
<li><strong>Dài hạn:</strong> khi hai hầm chui và cầu mới xong, trục trung tâm – Hòa Xuân thông thoáng hơn, có lợi cho căn hộ, đất nền khu Nam như <a href="/du-an/euro-village-2/">Euro Village 2</a>, khu Hòa Xuân, Cẩm Lệ.</li>
<li><strong>Thời điểm mua:</strong> giai đoạn phân luồng cầu Hòa Xuân thường làm người mua e ngại; với người mua dài hạn, đây có thể là lúc dễ thương lượng hơn – nhưng nên tính cả chi phí, thời gian đi lại trong 2 năm tới.</li>
</ul>
<p>Bức tranh hạ tầng cả năm xem tại <a href="/toan-canh-ha-tang-da-nang-2026/">toàn cảnh hạ tầng Đà Nẵng 2026</a>. Cần xem nhà, đất khu Nam Đà Nẵng trong giai đoạn phân luồng, nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: SGGP, Tuổi Trẻ, Thanh Niên, VOV, VietTimes, Báo Đà Nẵng, Báo Xây dựng (28/10/2026); sơ đồ phương án phân luồng của dự án.</p>
HTML,
		'seo'       => array(
			'seo_title' => 'Phân luồng cầu Hòa Xuân từ 31/10/2026: xe nào bị cấm?',
			'desc'      => 'Phân luồng cầu Hòa Xuân từ 9h 31/10/2026: cấm xe tải trên 2,5 tấn, xe khách từ 16 chỗ trong khu vực hạn chế; container đi cảng Tiên Sa đổi tuyến.',
			'points'    => array(
				'Phân luồng cầu Hòa Xuân bắt đầu 9h ngày 31/10/2026 để thi công cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – cầu Hòa Xuân.',
				'Xe tải trên 2,5 tấn và xe khách từ 16 chỗ bị cấm cả ngày trong khu vực hạn chế.',
				'Xe container, sơ mi rơ moóc và xe phục vụ chợ đầu mối Hòa Cường cấm 4h – 23h trên Nguyễn Hữu Thọ – Xô Viết Nghệ Tĩnh – Lê Thanh Nghị.',
				'Xe đi cảng Tiên Sa đi Nam Kỳ Khởi Nghĩa – Trường Chinh – Quốc lộ 1A.',
			),
			'faq'       => array(
				array( 'Phân luồng cầu Hòa Xuân bắt đầu khi nào?', 'Từ 9h ngày 31/10/2026, phục vụ thi công cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn lên cầu Hòa Xuân.' ),
				array( 'Xe nào bị cấm qua khu vực cầu Hòa Xuân?', 'Theo phương án phân luồng cầu Hòa Xuân, xe tải trên 2,5 tấn và xe khách từ 16 chỗ bị cấm cả ngày trong khu vực hạn chế; xe kéo rơ moóc, sơ mi rơ moóc và xe tải phục vụ chợ đầu mối Hòa Cường bị cấm từ 4h đến 23h trên tuyến Nguyễn Hữu Thọ – Xô Viết Nghệ Tĩnh – Lê Thanh Nghị.' ),
				array( 'Xe container đi cảng Tiên Sa đi đường nào?', 'Theo hướng dẫn, đi Nam Kỳ Khởi Nghĩa – Trường Chinh – Quốc lộ 1A; từ Quốc lộ 14B rẽ phải tại nút cầu vượt Hòa Cầm, từ ĐT605 rẽ phải tại nút ĐT605 – Quốc lộ 1A.' ),
				array( 'Cụm nút giao cầu Hòa Xuân thi công bao lâu?', 'Thời gian thi công dự kiến 730 ngày kể từ ngày khởi công 25/8/2026.' ),
				array( 'Phân luồng cầu Hòa Xuân kéo dài đến khi nào?', 'Chưa có mốc kết thúc cụ thể được công bố. Phân luồng phục vụ thi công cụm nút giao (dự kiến 730 ngày kể từ 25/8/2026) và có thể điều chỉnh theo từng giai đoạn thi công.' ),
			),
		),
		'sources'   => array(
			'https://www.sggp.org.vn/da-nang-phan-luong-giao-thong-thi-cong-cum-nut-giao-cau-hoa-xuan-tu-ngay-31-10-post878805.html',
			'https://tuoitre.vn/da-nang-phan-luong-giao-thong-khu-vuc-cau-hoa-xuan-tu-31-10-nhung-tuyen-nao-bi-cam-100261028105103169.htm',
			'https://thanhnien.vn/phan-luong-giao-thong-qua-cau-hoa-xuan-da-nang-nhung-xe-nao-bi-cam-185261028123729445.htm',
			'https://vov.vn/xa-hoi/da-nang-phan-luong-cam-xe-phuc-vu-thi-cong-nut-giao-cau-hoa-xuan-tu-ngay-3110-post1345433.vov',
			'https://baodanang.vn/phan-luong-giao-thong-cum-nut-giao-thong-le-thanh-nghi-cach-mang-thang-tam-thang-long-duong-dan-len-cau-hoa-xuan-3356711.html',
		),
	);
	return $posts;
}
