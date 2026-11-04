<?php
/**
 * The Camellia Sơn Trà – cập nhật tiến độ thi công 11/2026, lộ trình tiếp theo, giá từ 1,82 tỷ và chính sách bán hàng
 * (bài chủ đầu tư anh Hiệp gửi 04/11/2026) + 4 phối cảnh chủ đầu tư (đã cắt viền ảnh chụp màn hình).
 * Thay giá trị cũ nếu web chưa sửa tay (fix_meta).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/the-camellia/the-camellia-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'phoi-canh-hoang-hon-ban-dao', 'Phối cảnh The Camellia Sơn Trà lúc hoàng hôn, chân bán đảo Sơn Trà, hướng biển', 'đại diện' ),
			$img( 'toan-canh-vinh-da-nang', 'The Camellia Sơn Trà nhìn từ bán đảo Sơn Trà về vịnh và trung tâm Đà Nẵng', 'thư viện' ),
			$img( 'ben-bai-bien-chan-nui', 'The Camellia Sơn Trà bên bãi biển, tựa lưng bán đảo Sơn Trà', 'thư viện' ),
			$img( 'cong-vien-tren-cao', 'Công viên trên cao The Camellia Sơn Trà nhìn ra biển', 'tiện ích', 'Công viên trên cao' ),
		);
		$new = array(
			'hh_p_price_from' => 1820,
			'hh_p_progress'   => "15/7/2026 | Hoàn thành tầng hầm, thi công khối đế\n26/7/2026 | MBLand ra mắt dự án tại Đà Nẵng\n11/2026 | Hoàn thành kết cấu dầm sàn tầng 5\n10/12/2026 | Dự kiến hoàn thành kết cấu tầng 10\n10/03/2027 | Dự kiến hoàn thành kết cấu tầng 20\nTrước 30/04/2027 | Dự kiến cất nóc\n09/2027 | Dự kiến hoàn thiện mặt ngoài\nQuý 1/2028 | Dự kiến nghiệm thu, bàn giao",
			'hh_p_policy'     => "Giá từ khoảng 1,82 tỷ/căn (tham khảo, 11/2026). Chính sách bán hàng hiện hành:\n• Hỗ trợ lãi suất khoản vay 70% đến 18 tháng\n• Chiết khấu đến 13% khi thanh toán sớm\n• Phương án \"Thảnh thơi\": chỉ thanh toán 50% đến khi nhận nhà\n• Chiết khấu mua chung đến 3%\n• Khách đã mua giới thiệu khách mới: tặng 1 chỉ vàng; khách mua mới/mua thêm: tặng 1 chỉ vàng + chiết khấu 1%\n• Miễn phí quản lý 12 tháng\nChính sách thay đổi theo từng đợt – liên hệ Hoàng Hiệp 0904 567 009 để nhận bảng tính chi tiết.",
		);
		$old = array(
			'hh_p_price_from' => array( '1980' ),
			'hh_p_progress'   => array( "15/7/2026 | Hoàn thành tầng hầm, thi công khối đế\n26/7/2026 | MBLand ra mắt dự án tại Đà Nẵng\nQuý 1/2028 | Dự kiến bàn giao" ),
			'hh_p_policy'     => array( 'Hỗ trợ vay đến 70% giá trị căn hộ, tối đa 18 tháng không trả gốc và lãi hoặc ân hạn nợ gốc dài hạn (các nguồn nêu 3 – 5 năm); chiết khấu khoảng 2 – 13% tùy phương thức thanh toán; miễn phí quản lý 12 tháng. Chính sách thay đổi theo từng đợt.' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'the-camellia-son-tra' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $key => $value ) {
				$projects[ $i ]['meta'][ $key ]     = $value;
				$projects[ $i ]['fix_meta'][ $key ] = array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), $old[ $key ] );
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, 'img/the-camellia/' ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $lines ) );
			}
			$projects[ $i ]['excerpt'] = str_replace( 'dự kiến bàn giao quý 1/2028.', 'đã xong kết cấu tầng 5 (11/2026), dự kiến cất nóc trước 30/4/2027, bàn giao quý 1/2028.', (string) ( $p['excerpt'] ?? '' ) );
		}
		return $projects;
	},
	60
);

add_filter( 'hh_news_posts', 'hh_posts_camellia_tien_do_11_2026' );
function hh_posts_camellia_tien_do_11_2026( $posts ) {
	$posts[] = array(
		'slug'          => 'the-camellia-son-tra-tien-do-thang-11-2026',
		'title'         => 'Tiến độ The Camellia Sơn Trà 11/2026: xong kết cấu tầng 5, dự kiến cất nóc trước 30/4/2027',
		'excerpt'       => 'The Camellia Sơn Trà (MBLand) đã hoàn thành kết cấu dầm sàn tầng 5; dự kiến xong tầng 10 ngày 10/12/2026, tầng 20 ngày 10/3/2027, cất nóc trước 30/4/2027 và bàn giao quý 1/2028. Giá từ khoảng 1,82 tỷ/căn.',
		'keyword'       => 'tiến độ The Camellia Sơn Trà',
		'project'       => 'the-camellia-son-tra',
		'category'      => 'Dự án',
		'date'          => '2026-11-04 18:00:00',
		'image'         => 'plugin:img/the-camellia/the-camellia-phoi-canh-hoang-hon-ban-dao.jpg',
		'image_alt'     => 'Phối cảnh The Camellia Sơn Trà chân bán đảo Sơn Trà, Đà Nẵng',
		'image_caption' => 'Phối cảnh The Camellia Sơn Trà (ảnh chủ đầu tư).',
		'content'       => <<<'HTML'
<p>Theo cập nhật của chủ đầu tư tháng 11/2026, <a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a> – tòa căn hộ 25 tầng của MBLand ở góc Lê Văn Lương – Lê Đức Thọ, chân bán đảo Sơn Trà – đã <strong>hoàn thành kết cấu dầm sàn tầng 5</strong>. Tiến độ các mốc tiếp theo phụ thuộc thời tiết những ngày tới.</p>
<!--hh-featured-->

<h2>Lộ trình thi công dự kiến</h2>
<table>
<thead><tr><th>Mốc</th><th>Hạng mục</th></tr></thead>
<tbody>
<tr><td>11/2026</td><td>Đã hoàn thành kết cấu dầm sàn tầng 5</td></tr>
<tr><td>10/12/2026</td><td>Hoàn thành kết cấu tầng 10</td></tr>
<tr><td>10/03/2027</td><td>Hoàn thành kết cấu tầng 20</td></tr>
<tr><td>Trước 30/04/2027</td><td>Cất nóc</td></tr>
<tr><td>09/2027</td><td>Hoàn thiện mặt ngoài</td></tr>
<tr><td>Quý 1/2028</td><td>Nghiệm thu, bàn giao</td></tr>
</tbody>
</table>

<h2>Giá và chính sách bán hàng</h2>
<p>Giá từ khoảng <strong>1,82 tỷ/căn</strong>, bàn giao hoàn thiện. Chính sách hiện hành:</p>
<ul>
<li>Hỗ trợ lãi suất khoản vay 70% đến 18 tháng.</li>
<li>Chiết khấu đến 13% khi thanh toán sớm.</li>
<li>Phương án "Thảnh thơi": chỉ thanh toán 50% đến khi nhận nhà.</li>
<li>Chiết khấu mua chung đến 3%.</li>
<li>Khách đã mua giới thiệu khách mới được tặng 1 chỉ vàng; khách mua mới hoặc mua thêm được tặng 1 chỉ vàng và chiết khấu 1%.</li>
<li>Miễn phí quản lý 12 tháng.</li>
</ul>
<p><strong>Nhận định của Hoàng Hiệp:</strong> với mốc cất nóc dự kiến trước 30/4/2027, phương án chỉ đóng 50% đến khi nhận nhà giúp người mua để ở giảm áp lực dòng tiền trong giai đoạn xây dựng. Nên so sánh tổng chi phí giữa phương án thanh toán sớm (chiết khấu cao) và phương án vay hỗ trợ lãi suất trước khi chọn.</p>
<p>Nhận bảng giá, giỏ căn và bảng tính dòng tiền The Camellia Sơn Trà: nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: thông tin cập nhật tiến độ và chính sách bán hàng của chủ đầu tư (11/2026). Thông tin tham khảo, có thể thay đổi theo từng đợt.</p>
HTML,
		'seo'           => array(
			'seo_title' => 'Tiến độ The Camellia Sơn Trà 11/2026 – xong tầng 5',
			'desc'      => 'The Camellia Sơn Trà xong kết cấu tầng 5 (11/2026), dự kiến cất nóc trước 30/4/2027, bàn giao quý 1/2028. Giá từ 1,82 tỷ, hỗ trợ lãi suất 18 tháng.',
			'points'    => array(
				'Đã hoàn thành kết cấu dầm sàn tầng 5 (11/2026).',
				'Dự kiến xong tầng 10 (10/12/2026), tầng 20 (10/3/2027), cất nóc trước 30/4/2027.',
				'Hoàn thiện mặt ngoài 9/2027, bàn giao quý 1/2028.',
				'Giá từ khoảng 1,82 tỷ/căn; hỗ trợ lãi suất 70% đến 18 tháng, chiết khấu thanh toán sớm đến 13%.',
			),
			'faq'       => array(
				array( 'The Camellia Sơn Trà đang thi công đến đâu?', 'Tháng 11/2026 dự án đã hoàn thành kết cấu dầm sàn tầng 5.' ),
				array( 'Khi nào The Camellia Sơn Trà cất nóc?', 'Chủ đầu tư dự kiến cất nóc trước 30/4/2027.' ),
				array( 'Khi nào bàn giao The Camellia Sơn Trà?', 'Dự kiến nghiệm thu, bàn giao quý 1/2028.' ),
				array( 'Giá The Camellia Sơn Trà bao nhiêu?', 'Giá từ khoảng 1,82 tỷ/căn (tham khảo 11/2026), kèm chính sách hỗ trợ lãi suất, chiết khấu thanh toán sớm đến 13%.' ),
			),
		),
		'sources'       => array(),
	);
	return $posts;
}
