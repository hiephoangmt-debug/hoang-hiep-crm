<?php
/**
 * Nobu Residences Đà Nẵng – chi tiết hệ thống tiện ích (diện tích, sức chứa, vị trí tầng) theo tài liệu giới thiệu tiện ích anh Hiệp gửi 18/11/2026.
 * Ảnh gốc có logo đơn vị phân phối: chỉ cắt 3 phối cảnh mới (sảnh đón, lobby lounge, phòng ăn riêng nhà hàng Nobu), bỏ hẳn phần có logo;
 * các phối cảnh trùng với ảnh đã có từ trang chính thức thì không lấy. Ảnh "minh họa cảm hứng thiết kế" (spa, gym) không dùng.
 * Không đăng hotline / website của đơn vị khác. Chạy sau data-nobu-noi-that-1311.php (ưu tiên 35).
 */

defined( 'ABSPATH' ) || exit;

/** Mục "Tiện ích chi tiết" trong bài giới thiệu Nobu. */
function hh_nobu_tien_ich_html() {
	return <<<'HTML'

<h2>Tiện ích Nobu Residences Đà Nẵng: diện tích và vị trí từng khu</h2>
<p>Theo tài liệu giới thiệu tiện ích của dự án, hệ tiện ích chia theo tầng – từ sảnh đón ở tầng 1, spa – wellness ở tầng 3 – 4, sảnh sự kiện tầng 5, tầng tiện ích 18 cho cư dân, tới nhà hàng Nobu trên tầng 42:</p>
<table>
<thead><tr><th>Tiện ích</th><th>Vị trí</th><th>Quy mô (theo tài liệu dự án)</th></tr></thead>
<tbody>
<tr><td>Sảnh đón</td><td>Tầng 1</td><td>Thiết kế lấy cảm hứng từ giấy washi Nhật Bản và quạt giấy dó Việt Nam</td></tr>
<tr><td>Lobby lounge – sảnh chờ</td><td>Tầng 1</td><td>Trong nhà 590 m², ngoài trời 82 m²; trần cao gần 7 m, kính toàn cảnh</td></tr>
<tr><td>Wellness &amp; Retreat Center</td><td>Tầng 3 – 4</td><td>Hơn 1.000 m² (tầng 3: 515 m², tầng 4: 693 m²)</td></tr>
<tr><td>Sảnh sự kiện (ballroom)</td><td>Tầng 5</td><td>385 m², sức chứa đến 300 chỗ</td></tr>
<tr><td>Hồ bơi nước ấm Katamochi</td><td>Tầng 18</td><td>Mặt nước 241 m², thiết kế treo chân mây hướng biển; hồ jacuzzi 19 m²; quầy bar nổi 24 chỗ; hồ bơi trẻ em 19 m²</td></tr>
<tr><td>Sky gym</td><td>Tầng 18</td><td>Khoảng 100 m²</td></tr>
<tr><td>Khu vui chơi trẻ em</td><td>Tầng 18</td><td>Khoảng 60 m², lấy sáng tự nhiên</td></tr>
<tr><td>Nhà hàng Nobu – đầu tiên tại Việt Nam</td><td>Tầng 42</td><td>Trong nhà 500 m², ngoài trời 90 m², khoảng 180 chỗ</td></tr>
</tbody>
</table>
<p>Với người mua để ở hay đầu tư cho thuê, nên hỏi rõ phạm vi dịch vụ cư dân được dùng miễn phí, tiện ích nào thuộc khách sạn – nhà hàng tính phí, và quy định sử dụng hồ bơi, gym tầng 18. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận tài liệu tiện ích và mặt bằng từng tầng.</p>
HTML;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/nobu-da-nang/nobu-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'sanh-don-washi', 'Sảnh đón tầng 1 Nobu Residences Đà Nẵng – cảm hứng giấy washi Nhật Bản và quạt giấy dó Việt Nam (phối cảnh)', 'tiện ích', 'Sảnh đón' ),
			$im( 'lobby-lounge', 'Lobby lounge tầng 1 – trần cao gần 7 m, kính toàn cảnh (phối cảnh)', 'tiện ích', 'Lobby lounge' ),
			$im( 'nha-hang-nobu-phong-an-rieng', 'Phòng ăn riêng nhà hàng Nobu tầng 42 (phối cảnh)', 'tiện ích', 'Nhà hàng Nobu' ),
		);
		$amen = "Sảnh đón và lobby lounge tầng 1 (trong nhà 590 m², ngoài trời 82 m², trần cao gần 7 m)\nWellness & Retreat Center tầng 3 – 4, hơn 1.000 m²\nSảnh sự kiện tầng 5: 385 m², đến 300 chỗ\nNhà hàng Taste of Asia (tầng 6)\nKhách sạn Nobu khoảng 200 phòng, gồm 18 suite (tầng 7 – 16)\nTầng tiện ích 18: hồ bơi nước ấm Katamochi mặt nước 241 m², jacuzzi 19 m², quầy bar nổi 24 chỗ, hồ bơi trẻ em 19 m²\nSky gym khoảng 100 m² và khu vui chơi trẻ em khoảng 60 m² (tầng 18)\nNhà hàng Nobu đầu tiên tại Việt Nam (tầng 42): trong nhà 500 m², ngoài trời 90 m², khoảng 180 chỗ\nNhà hàng – bar trên không Tsukimidai (tầng 43)\nDịch vụ quản lý căn hộ theo tiêu chuẩn Nobu Hospitality";
		foreach ( $projects as $i => $p ) {
			if ( 'nobu-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $cur && false === strpos( $cur, 'sanh-don-washi' ) ) {
				$p['meta']['hh_p_image_links']     = trim( $cur . "\n" . implode( "\n", $imgs ) );
				$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
			$cur_a = (string) ( $p['meta']['hh_p_amenities_in'] ?? '' );
			if ( $cur_a !== $amen ) {
				$p['meta']['hh_p_amenities_in']     = $amen;
				$p['fix_meta']['hh_p_amenities_in'] = array_merge( (array) ( $p['fix_meta']['hh_p_amenities_in'] ?? array() ), array( $cur_a ) );
			}
			$c0 = (string) ( $p['content'] ?? '' );
			if ( '' !== $c0 && false === strpos( $c0, 'Tiện ích Nobu Residences Đà Nẵng: diện tích' ) ) {
				$p['content']     = $c0 . hh_nobu_tien_ich_html();
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	35
);
