<?php
/**
 * Bản tin hạ tầng – quy hoạch – chính sách Đà Nẵng hằng ngày (routine tự viết).
 * Không nạp trong plugin – xuất bằng scripts/xuat-bai-tu-dong.php vào wordpress/tu-dong/.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_tin_ha_tang_hang_ngay' );
function hh_posts_tin_ha_tang_hang_ngay( $posts ) {
	$cta = '<p>Cần kiểm tra quy hoạch, pháp lý một lô đất hoặc so sánh dự án dọc trục Đà Nẵng – Chu Lai, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 05/11 – Thời hạn khởi công 3 khu đô thị tại Chu Lai ---------------- */
	$posts[] = array(
		'slug'           => 'da-nang-an-dinh-thoi-han-khoi-cong-3-khu-do-thi-chu-lai',
		'title'          => 'Đà Nẵng ấn định thời hạn khởi công 3 khu đô thị hơn 40.400 tỷ tại Chu Lai',
		'excerpt'        => 'Ba dự án khu đô thị tại Khu kinh tế mở Chu Lai với tổng vốn hơn 40.400 tỷ đồng được yêu cầu khởi công chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô từng dự án và tác động tới đất nền phía Nam Đà Nẵng.',
		'keyword'        => 'khu đô thị Chu Lai',
		'keywords_extra' => array( 'Khu kinh tế mở Chu Lai', 'khu đô thị ven sông Trường Giang', 'bất động sản Núi Thành', 'hạ tầng Đà Nẵng 2026' ),
		'project'        => 'vinh-an-hoa-city',
		'schedule'       => '2026-11-05 08:00',
		'category'       => 'Hạ tầng & quy hoạch',
		'tags'           => array( 'Hạ tầng Đà Nẵng', 'Chu Lai', 'Quy hoạch' ),
		'image'          => 'plugin:img/tin-tuc/khoi-cong-3-khu-do-thi-chu-lai-11-2026.jpg',
		'image_alt'      => 'Thời hạn khởi công 3 khu đô thị tại Khu kinh tế mở Chu Lai, Đà Nẵng',
		'image_caption'  => 'Tóm tắt 3 dự án và thời hạn khởi công (Hoàng Hiệp vẽ, sơ đồ không theo tỷ lệ).',
		'content'        => <<<HTML
<p>Ngày 4/11/2026, tại buổi làm việc với Ban Quản lý Khu kinh tế mở Chu Lai, Phó Chủ tịch UBND TP Đà Nẵng Phan Thái Bình yêu cầu các nhà đầu tư <strong>khởi công 3 dự án khu đô thị</strong> tại Chu Lai đúng thời hạn. Tổng vốn đầu tư của 3 dự án hơn <strong>40.400 tỷ đồng</strong> (Tuổi Trẻ, Báo Đầu tư, 4/11/2026).</p>
<!--hh-featured-->
<h2>3 dự án và thời hạn khởi công</h2>
<table>
<thead><tr><th>Dự án</th><th>Quy mô – vốn (theo báo chí)</th><th>Thời hạn khởi công</th></tr></thead>
<tbody>
<tr><td>Khu đô thị Chu Lai (xã Núi Thành) – Công ty CP Đầu tư Địa ốc Đại Quang Minh</td><td>Khoảng 188,56 ha, vốn hơn 18.854 tỷ đồng</td><td>Phấn đấu tháng 12/2026, chậm nhất 29/3/2027</td></tr>
<tr><td>Khu đô thị ven sông Trường Giang (Quảng Phú, Bàn Thạch) – Công ty CP Green Industrial Chu Lai</td><td>74,05 ha, vốn hơn 3.069 tỷ đồng, thực hiện 2026 – 2034</td><td>Trước 30/4/2027</td></tr>
<tr><td>Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành</td><td>Phần còn lại của tổng vốn hơn 40.400 tỷ</td><td>Trước 30/4/2027</td></tr>
</tbody>
</table>
<p>Với dự án Khu đô thị Chu Lai, việc ký hợp đồng dự án được báo chí nêu dự kiến vào ngày 9/11/2026. Các mốc trên là yêu cầu của thành phố; tiến độ thực tế còn phụ thuộc giải phóng mặt bằng và thủ tục của từng dự án.</p>
<h2>Tác động / nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Chu Lai – Núi Thành có thêm nguồn cung đô thị lớn</strong>: gần 263 ha của hai dự án đã công bố quy mô, cạnh sân bay Chu Lai và các khu công nghiệp. Khi khởi công thật, hạ tầng nội khu và đường kết nối sẽ làm rõ giá trị khu vực.</li>
<li><strong>Nguồn cung nhiều cũng là rủi ro</strong>: đất nền phía Nam sẽ cạnh tranh mạnh trong 3 – 5 năm tới. Nên ưu tiên dự án đã có hạ tầng, pháp lý rõ, thay vì mua theo tin "sắp khởi công".</li>
<li><strong>Trục Đà Nẵng – Chu Lai</strong> đang được chú ý cùng với <a href="/cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do/">cao tốc nội thị Đà Nẵng – Chu Lai</a>; khi tuyến này triển khai, thời gian từ Chu Lai về trung tâm Đà Nẵng sẽ được rút ngắn.</li>
</ul>
<h2>Dự án chịu ảnh hưởng</h2>
<ul>
<li><a href="/du-an/vinh-an-hoa-city/">Vịnh An Hòa City</a> (Núi Thành, cạnh sân bay Chu Lai): hưởng lợi trực tiếp nhất khi khu vực có thêm khu đô thị và dân cư mới, nhưng cũng chịu cạnh tranh nguồn cung.</li>
<li><a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>: thuộc hành lang ven biển phía Nam, cùng được nhắc đến khi trục Đà Nẵng – Chu Lai phát triển.</li>
<li>Khu vực Bàn Thạch – Tam Kỳ (nơi có khu đô thị ven sông Trường Giang) cũng có thêm động lực; xem thông tin tham khảo tại trang <a href="/du-an/meta-city-tam-ky/">Meta City Tam Kỳ</a>.</li>
</ul>
<p>Xem thêm: <a href="/mat-cat-cao-toc-noi-thi-da-nang-chu-lai-quy-dat-tod/">mặt cắt và quỹ đất dọc cao tốc nội thị</a>, <a href="/chinh-sach-moi-anh-huong-bat-dong-san-da-nang-11-2026/">chính sách mới ảnh hưởng bất động sản Đà Nẵng 11/2026</a>.</p>
{$cta}
<p class="src">Nguồn: Tuổi Trẻ, Báo Đầu tư, Tiền Phong, Dân trí, CafeF (4/11/2026). Thông tin tham khảo.</p>
HTML
		,
		'seo'            => array(
			'seo_title' => 'Thời hạn khởi công 3 khu đô thị 40.400 tỷ tại Chu Lai',
			'desc'      => 'Đà Nẵng yêu cầu khởi công 3 khu đô thị hơn 40.400 tỷ tại Chu Lai chậm nhất 29/3/2027 và trước 30/4/2027. Quy mô dự án và tác động tới đất nền phía Nam.',
			'points'    => array(
				'Khu đô thị Chu Lai khoảng 188,56 ha, hơn 18.854 tỷ, khởi công chậm nhất 29/3/2027.',
				'Khu đô thị ven sông Trường Giang 74,05 ha, hơn 3.069 tỷ, khởi công trước 30/4/2027.',
				'Khu đô thị hỗn hợp phía Nam trục Nguyễn Tất Thành khởi công trước 30/4/2027.',
				'Tổng vốn 3 dự án hơn 40.400 tỷ đồng.',
			),
			'faq'       => array(
				array( 'Khi nào khởi công Khu đô thị Chu Lai?', 'Thành phố yêu cầu phấn đấu khởi công tháng 12/2026, chậm nhất ngày 29/3/2027 (báo chí 4/11/2026).' ),
				array( 'Khu đô thị ven sông Trường Giang ở đâu?', 'Tại khu vực Quảng Phú và Bàn Thạch, quy mô 74,05 ha, vốn hơn 3.069 tỷ đồng, yêu cầu khởi công trước 30/4/2027.' ),
				array( '3 dự án khu đô thị tại Chu Lai có tổng vốn bao nhiêu?', 'Hơn 40.400 tỷ đồng theo báo chí đưa tin ngày 4/11/2026.' ),
			),
		),
		'sources'        => array(
			'https://tuoitre.vn/sap-khoi-cong-3-du-an-tong-von-hon-40460-ti-tai-chu-lai-100261104104348024.htm',
			'https://baodautu.vn/da-nang-an-dinh-thoi-diem-khoi-cong-3-du-an-do-thi-hon-40400-ty-dong-d737415.html',
		),
	);

	return $posts;
}
