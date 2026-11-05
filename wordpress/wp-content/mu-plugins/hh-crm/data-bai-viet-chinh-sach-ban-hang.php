<?php
/**
 * Bài "Chính sách bán hàng" theo THÁNG và theo TỪNG DỰ ÁN (chuyên mục "Chính sách bán hàng", hiện ở trang
 * /chinh-sach-bang-tinh/). Mỗi tháng thêm 1 khối mới cho từng dự án (slug có tháng), không sửa bài tháng cũ.
 * Nội dung lấy từ hh_sun_policy_11_2026() (data-sun-chinh-sach-11-2026.php).
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/data-sun-chinh-sach-11-2026.php';

add_filter( 'hh_news_posts', 'hh_posts_chinh_sach_ban_hang' );
function hh_posts_chinh_sach_ban_hang( $posts ) {
	$pol  = hh_sun_policy_11_2026();
	$cta  = '<p>Nhận phiếu tính giá theo đúng căn, so sánh phương án vay và thanh toán sớm: liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem chính sách tất cả dự án tại <a href="/chinh-sach-bang-tinh/">Chính sách &amp; bảng tính giá</a>.</p>';
	$list = static function ( $text ) {
		$li = '';
		foreach ( array_filter( array_map( 'trim', explode( "\n", $text ) ) ) as $line ) {
			$li .= '<li>' . htmlspecialchars( $line, ENT_QUOTES ) . '</li>';
		}
		return '<ul>' . $li . '</ul>';
	};
	$items = array(
		array( 'spana-tower', 'Spana Tower', 'spana-tower', 'chinh-sach-spana-tower-11-2026', '2026-11-05 16:30', '<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg|Spana Tower thực tế tháng 11/2026 – hai tòa bên sông Cẩm Lệ (ảnh flycam)-->' ),
		array( 'cora-tower', 'Cora Tower', 'cora-tower', 'chinh-sach-cora-tower-11-2026', '2026-11-05 16:45', '' ),
		array( 's-light-tower', 'S-Light Tower', 's-light-tower', 'chinh-sach-s-light-tower-11-2026', '2026-11-05 17:00', '' ),
		array( 'fours-tower-f1-thap-tung', 'FourS Tower F1, F5', 'fours-tower-f1-thap-tung', 'chinh-sach-fours-f1-f5-11-2026', '2026-11-05 17:15', '' ),
		array( 'fours-tower-f2-thap-mai', 'FourS Tower F2', 'fours-tower-f2-thap-mai', 'chinh-sach-fours-f2-11-2026', '2026-11-05 17:30', '' ),
	);
	foreach ( $items as list( $key, $name, $project, $img, $when, $extra ) ) {
		$posts[] = array(
			'slug'     => 'chinh-sach-ban-hang-' . str_replace( 'fours-tower-f1-thap-tung', 'fours-tower-f1-f5', $project ) . '-thang-11-2026',
			'title'    => 'Chính sách bán hàng ' . $name . ' tháng 11/2026',
			'excerpt'  => 'Chính sách bán hàng ' . $name . ' áp dụng tháng 11/2026: chiết khấu không vay, thanh toán sớm (hạn 25/11), đặt cọc, giãn tiến độ, hỗ trợ lãi suất, Sun Early Key.',
			'keyword'  => 'chính sách bán hàng ' . $name,
			'project'  => $project,
			'schedule' => $when,
			'category' => 'Chính sách bán hàng',
			'tags'     => array( $name, 'Chính sách bán hàng', 'Sun Group' ),
			'image'    => 'plugin:img/tin-tuc/' . $img . '.jpg',
			'image_alt' => 'Tóm tắt chính sách bán hàng ' . $name . ' tháng 11/2026',
			'content'  => '<p>Chính sách bán hàng <a href="/du-an/' . $project . '/">' . $name . '</a> đang áp dụng tháng 11/2026 theo văn bản của chủ đầu tư. Mức thanh toán sớm có hạn đến <strong>25/11/2026</strong> và thay đổi theo tháng.</p>
<!--hh-featured-->
<h2>Chính sách tháng 11/2026</h2>
' . $list( $pol[ $key ] ) . '
' . $extra . '
<h2>Tính tiền từng đợt</h2>
<p>Dùng <a href="/du-an/' . $project . '/bang-tinh/">bảng tính giá ' . $name . '</a> để nhập giá căn, chọn phương án (không vay, vay ngân hàng, thanh toán sớm) và xem số tiền từng đợt. Chính sách các tháng trước và các dự án khác: <a href="/chinh-sach-bang-tinh/#' . $project . '">Chính sách &amp; bảng tính giá</a>.</p>
' . $cta . '
<p class="src">Nguồn: chính sách bán hàng và phiếu tính giá của chủ đầu tư (11/2026). Thông tin tham khảo, có thể thay đổi theo từng đợt.</p>',
			'seo'      => array(
				'seo_title' => mb_substr( 'Chính sách bán hàng ' . $name . ' tháng 11/2026', 0, 58 ),
				'desc'      => 'Chính sách ' . $name . ' tháng 11/2026: chiết khấu không vay, thanh toán sớm hạn 25/11, đặt cọc, hỗ trợ lãi suất, trả 70% nhận nhà.',
				'points'    => array_slice( array_filter( array_map( 'trim', explode( "\n", $pol[ $key ] ) ) ), 0, 4 ),
				'faq'       => array(),
			),
			'sources'  => array(),
		);
	}
	return $posts;
}
