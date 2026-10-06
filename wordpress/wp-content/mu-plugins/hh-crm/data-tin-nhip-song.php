<?php
/**
 * Chuyên mục "Nhịp sống Đà Nẵng" – tin ngắn đời sống, đô thị (anh Hiệp gửi). Nạp qua filter hh_news_posts;
 * nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, đăng ngay (không lên lịch), ảnh đại diện lấy từ img/tin-tuc/.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_nhip_song' );
function hh_posts_nhip_song( $posts ) {
	$posts[] = array(
		'slug'     => 'cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy',
		'title'    => 'Chuẩn bị đầu tư công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy',
		'excerpt'  => 'Đà Nẵng chuẩn bị các bước đầu tư gói thầu Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy tại phường Ngũ Hành Sơn. Phối cảnh cho thấy dải công viên cây xanh, sân thể thao bãi biển và khu vui chơi sát biển.',
		'keyword'  => 'bãi tắm Sơn Thủy',
		'project'  => '',
		'category' => 'Nhịp sống Đà Nẵng',
		'date'     => '2026-10-06 08:00:00',
		'image'    => 'plugin:img/tin-tuc/cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy.jpg',
		'image_alt' => 'Phối cảnh Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy, phường Ngũ Hành Sơn, Đà Nẵng',
		'content'  => <<<'HTML'
<p>Đà Nẵng đang chuẩn bị các bước đầu tư gói thầu <strong>Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy</strong> tại <strong>phường Ngũ Hành Sơn</strong>. Hồ sơ phối cảnh của dự án được ký ngày 10/8/2026.</p>

<h2>Phối cảnh dự án có gì</h2>
<ul>
<li>Dải công viên cây xanh, hàng dừa chạy dọc bãi biển, có lối đi bộ và quảng trường nhỏ.</li>
<li>Khu câu lạc bộ thể thao biển với sân thể thao trên cát và khu vui chơi, thư giãn.</li>
<li>Bãi tắm công cộng nối thẳng với công viên, thuận tiện cho người dân và du khách.</li>
</ul>
<p><em>Ảnh phối cảnh: Danang 35K Feet.</em></p>
<p>Quy mô, tổng mức đầu tư và thời gian thi công sẽ được cập nhật khi thành phố công bố chính thức.</p>

<h2>Ý nghĩa với cư dân và bất động sản Ngũ Hành Sơn</h2>
<p>Bãi biển được đầu tư công viên và tiện ích thể thao giúp đời sống ven biển phía Nam Đà Nẵng đầy đủ hơn: có thêm chỗ tập luyện, vui chơi miễn phí, cảnh quan sạch đẹp. Với người mua nhà, tiện ích công cộng gần biển là điểm cộng cho căn hộ, biệt thự và khách sạn quanh khu vực Ngũ Hành Sơn, nhất là nhu cầu ở lâu dài và cho thuê du lịch.</p>
<p>Xem thêm: <a href="/bat-dong-san-ngu-hanh-son-2026/">Bất động sản Ngũ Hành Sơn 2026</a> · <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">Giá đất ven biển Đà Nẵng</a>.</p>
<p>Anh chị muốn tìm căn hộ, nhà phố gần biển Ngũ Hành Sơn, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách và giá mới nhất.</p>
HTML,
		'seo'      => array(
			'seo_title' => 'Công viên, CLB thể thao biển và bãi tắm Sơn Thủy, Ngũ Hành Sơn',
			'desc'      => 'Đà Nẵng chuẩn bị đầu tư gói thầu Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy (phường Ngũ Hành Sơn). Xem phối cảnh và ý nghĩa với khu vực.',
			'points'    => array(
				'Dự án: Công viên, câu lạc bộ thể thao biển và bãi tắm Sơn Thủy.',
				'Địa điểm: phường Ngũ Hành Sơn, thành phố Đà Nẵng.',
				'Tiến độ: đang chuẩn bị các bước đầu tư gói thầu.',
			),
		),
		'sources'  => array(),
	);
	return $posts;
}
