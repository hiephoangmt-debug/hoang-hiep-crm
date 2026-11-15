<?php
/**
 * Đà Nẵng Downtown – tháp biểu tượng "Aurora" (anh Hiệp gửi sơ đồ phân tầng 15/11/2026): 69 tầng + tầng mái, cao 408 m,
 * 504 căn hộ cao cấp (tầng 11 – 22: 264 căn, tầng 28 – 42: 240 căn), 396 phòng lưu trú du lịch (tầng 43, 44 – 66, 67), 2 penthouse (tầng 68 – 69).
 * Ảnh gốc có chữ chìm của trang khác nên không dùng – sơ đồ tự vẽ theo dáng tòa tháp (bai-viet/aurora-phan-tang-anh.py, bản 2.20.288; 2.20.286 sơ đồ cột, 2.20.287 bản dáng tòa đầu tiên).
 * Tên "Aurora" và số căn/phòng theo tài liệu giới thiệu, chủ đầu tư chưa công bố chính thức trên báo chí – ghi rõ tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img  = 'plugin:img/da-nang-downtown/da-nang-downtown-thap-aurora-dang-toa-3.jpg | Sơ đồ phân tầng tháp Aurora 408 m – Đà Nẵng Downtown: căn hộ cao cấp tầng 11 – 22 và 28 – 42, phòng lưu trú tầng 43 – 67, penthouse tầng 68 – 69 (theo tài liệu giới thiệu, tham khảo) | mặt bằng | Phân tầng tháp Aurora';
		$sec  = '<h2>Tháp Aurora 408 m: phân tầng chức năng</h2>
<p>Theo tài liệu giới thiệu dự án, tòa tháp biểu tượng của Đà Nẵng Downtown có tên <strong>Aurora</strong>, cao 408 m với 69 tầng và tầng mái kỹ thuật, gồm <strong>504 căn hộ cao cấp</strong>, <strong>396 phòng lưu trú du lịch</strong> và <strong>2 căn penthouse</strong>. Số liệu dưới đây để tham khảo, chủ đầu tư sẽ công bố chính thức khi mở bán.</p>
<!--hh-img:img/da-nang-downtown/da-nang-downtown-thap-aurora-dang-toa-3.jpg|Tháp Aurora – Đà Nẵng Downtown: phân tầng chức năng theo dáng tòa tháp (đồ hoạ Hoàng Hiệp vẽ lại theo tài liệu giới thiệu)-->
<table>
<tr><th>Tầng</th><th>Chức năng</th><th>Số lượng</th></tr>
<tr><td>Mái</td><td>Bể nước, phòng kỹ thuật</td><td>–</td></tr>
<tr><td>68 – 69</td><td>Căn hộ penthouse siêu sang</td><td>2 căn (1 căn/tầng)</td></tr>
<tr><td>67</td><td>Phòng lưu trú du lịch + Sky Bar</td><td>14 phòng</td></tr>
<tr><td>44 – 66</td><td>Phòng lưu trú du lịch</td><td>368 phòng (16 phòng/tầng)</td></tr>
<tr><td>43</td><td>Phòng lưu trú du lịch + Sky Bar</td><td>14 phòng</td></tr>
<tr><td>28 – 42</td><td>Căn hộ cao cấp</td><td>240 căn (16 căn/tầng)</td></tr>
<tr><td>24 – 27</td><td>Trung tâm mua sắm cao cấp</td><td>–</td></tr>
<tr><td>23</td><td>Nhà hàng ẩm thực</td><td>–</td></tr>
<tr><td>11 – 22</td><td>Căn hộ cao cấp</td><td>264 căn (22 căn/tầng)</td></tr>
<tr><td>6 – 10</td><td>Nhà hàng ẩm thực cao cấp, phòng yoga</td><td>–</td></tr>
<tr><td>5</td><td>Không gian hội nghị, rạp chiếu phim</td><td>–</td></tr>
<tr><td>4</td><td>Khu trưng bày, phòng hội nghị, gym, spa, mua sắm</td><td>–</td></tr>
<tr><td>1 – 3</td><td>Trung tâm thương mại dịch vụ khối đế</td><td>–</td></tr>
</table>
<p>Hai khối căn hộ (tầng 11 – 22 và 28 – 42) được tách bởi tầng ẩm thực và trung tâm mua sắm; khối lưu trú du lịch nằm phía trên với hai tầng Sky Bar (43, 67). Cần tư vấn chọn tầng, hướng nhìn sông Hàn – biển, liên hệ Hoàng Hiệp 0904 567 009.</p>
';
		$hl   = 'Tháp Aurora 408 m: 504 căn hộ cao cấp (tầng 11 – 22, 28 – 42), 396 phòng lưu trú du lịch, 2 penthouse tầng 68 – 69 (theo tài liệu giới thiệu)';
		$zone = "Tháp Aurora 69 tầng | 504 căn hộ cao cấp, 396 phòng lưu trú, 2 penthouse, TTTM, nhà hàng, hội nghị, rạp phim | 408 m | Đang thi công";
		// Các bản trước đã có thể nhập lên web: 2.20.286 (sơ đồ cột, ...-phan-tang.jpg), 2.20.287 (...-dang-toa.jpg), 2.20.288 (...-dang-toa-2.jpg). Bản 2.20.289: khổ dọc theo bố cục tài liệu gốc (...-dang-toa-3.jpg).
		$c286 = 'Sơ đồ phân tầng tháp Aurora – Đà Nẵng Downtown (đồ hoạ Hoàng Hiệp vẽ lại theo tài liệu giới thiệu)';
		$c287 = 'Tháp Aurora – Đà Nẵng Downtown: phân tầng chức năng theo dáng tòa tháp (đồ hoạ Hoàng Hiệp vẽ lại theo tài liệu giới thiệu)';
		$olds = static fn( $x ) => array(
			str_replace( array( 'thap-aurora-dang-toa-3.jpg', $c287 ), array( 'thap-aurora-phan-tang.jpg', $c286 ), $x ),
			str_replace( 'thap-aurora-dang-toa-3.jpg', 'thap-aurora-dang-toa.jpg', $x ),
			str_replace( 'thap-aurora-dang-toa-3.jpg', 'thap-aurora-dang-toa-2.jpg', $x ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'da-nang-downtown' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			// Ảnh sơ đồ.
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, 'thap-aurora-' ) ) {
				$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . $img );
				// Bản 2.20.286 (sơ đồ cột) đã nhập lên web → cho phép thay.
				$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array_filter( array_merge( array( $cur ), array_map( static fn( $o ) => trim( $cur . "\n" . $o ), $olds( $img ) ) ) ) );
			}
			// Điểm nổi bật, phân khu.
			$h = (string) ( $p['meta']['hh_p_highlights'] ?? '' );
			if ( false === strpos( $h, 'Aurora' ) ) {
				$p['meta']['hh_p_highlights'] = trim( $h . "\n" . $hl );
				$p['fix_meta']['hh_p_highlights'] = array_merge( (array) ( $p['fix_meta']['hh_p_highlights'] ?? array() ), array( $h ) );
			}
			$z = (string) ( $p['meta']['hh_p_zones'] ?? '' );
			$z2 = preg_replace( '/^Tháp biểu tượng 69 tầng \|[^\n]*/u', $zone, $z );
			if ( $z2 !== $z ) {
				$p['meta']['hh_p_zones'] = $z2;
				$p['fix_meta']['hh_p_zones'] = array_merge( (array) ( $p['fix_meta']['hh_p_zones'] ?? array() ), array( $z ) );
			}
			$p['meta']['hh_p_floors'] = '69 tầng nổi + tầng mái, cao 408 m (tháp Aurora)';
			// Nội dung: chèn mục phân tầng trước "Tiến độ mới nhất".
			$ct = (string) ( $p['content'] ?? '' );
			if ( false === strpos( $ct, 'Tháp Aurora 408 m' ) ) {
				$new = preg_replace( '/<h2>Tiến độ mới nhất/u', $sec . '<h2>Tiến độ mới nhất', $ct, 1 );
				if ( $new === $ct ) {
					$new = $ct . "\n" . $sec;
				}
				$p['content']     = $new;
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array_merge( array( $ct ), $olds( $new ) ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	69
);
