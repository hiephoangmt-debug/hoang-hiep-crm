<?php
/**
 * Đà Nẵng Downtown: phối cảnh tổng thể có chú thích của chủ đầu tư (anh Hiệp gửi 05/11/2026) – tháp 69 tầng,
 * phân khu cao tầng / thấp tầng, nhà hát, khán đài pháo hoa bờ Đông, cầu Trần Thị Lý – Tiên Sơn, Cung thể thao.
 * Nối thêm vào ô "Link ảnh" (mục tổng thể); dự án chưa có ảnh đại diện thì web tự lấy ảnh này.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$line = 'plugin:img/da-nang-downtown/da-nang-downtown-phoi-canh-tong-the-chu-thich.jpg | Phối cảnh tổng thể Đà Nẵng Downtown ven sông Hàn: tháp 69 tầng, phân khu cao tầng và thấp tầng, nhà hát, khán đài pháo hoa bờ Đông, giữa cầu Trần Thị Lý và cầu Tiên Sơn (phối cảnh chủ đầu tư, tham khảo) | tổng thể | Phối cảnh tổng thể';
		foreach ( $projects as $i => $p ) {
			if ( 'da-nang-downtown' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = $p['meta']['hh_p_image_links'] ?? '';
			if ( is_array( $cur ) || false !== strpos( (string) $cur, 'da-nang-downtown-phoi-canh-tong-the' ) ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . $line );
			if ( '' !== $cur ) {
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
		}
		return $projects;
	},
	68
);
