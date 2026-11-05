<?php
/**
 * Hoiana Beach Villas – bộ tài liệu chủ đầu tư (HASD) anh Hiệp gửi 05/11/2026: thông tin dự án 27/5/2026,
 * ảnh phối cảnh Marina Villa (F), Azure Villa (D), Dune Villa (C). Ảnh gốc rất lớn → dùng ảnh thu nhỏ Drive (2400 px).
 * Không đăng hồ sơ pháp lý (khách cần thì anh Hiệp gửi riêng).
 */

defined( 'ABSPATH' ) || exit;

/** Ảnh Drive của bộ tài liệu: mã file => array( chú thích, mục ). */
function hh_hoiana_bv_images() {
	$f = 'Phối cảnh Marina Villa (loại F) – biệt thự 4 phòng ngủ trực diện biển, Hoiana Beach Villas';
	$d = 'Phối cảnh Azure Villa (loại D) – biệt thự 4 phòng ngủ, Hoiana Beach Villas';
	$c = 'Phối cảnh Dune Villa (loại C) – biệt thự 3 phòng ngủ giữa vườn, Hoiana Beach Villas';
	return array(
		'1WFS7kd0OZyRm7Tal2kgj2mjQirYoHrr6' => array( $f, 'thư viện' ),
		'1Ei1XH_OJtqdO36Pc4Jc8m-R5JTQILKZM' => array( $f . ' (góc 2)', 'thư viện' ),
		'1hHYHOYbTciyVJ5pcJYsK6mUAVXdN5dOE' => array( $f . ' (góc 3)', 'thư viện' ),
		'1HFceqCM5v-OQF9I6p2Rm4tuzu6YS7WsT' => array( $f . ' (góc 4)', 'thư viện' ),
		'1BGll-shlWsGr5Iy3n7g5MWv9-voYLB2A' => array( $f . ' (góc 5)', 'thư viện' ),
		'11RRKj8ZEADjInaB52QCnjpQaoy3baZxN' => array( $f . ' (góc 6)', 'thư viện' ),
		'16L--JihwGMaNSFFXUg4htZIuT-GjkGjv' => array( $f . ' (góc 7)', 'thư viện' ),
		'1nqByEUObXTmBT82wWzPW6030AesKSUly' => array( 'Sân vườn sau và hồ bơi riêng Azure Villa (loại D), Hoiana Beach Villas', 'thư viện' ),
		'16CMsBN0-9IqWtqUBkFRsQrZ_P__j-Hxz' => array( 'Sảnh vào nhìn ra hồ bơi riêng – Azure Villa (loại D), Hoiana Beach Villas', 'thư viện' ),
		'1TDX1HxC-PagWaNpcE67ID691Z8ZaXDtB' => array( 'Phòng khách Azure Villa (loại D), Hoiana Beach Villas', 'thư viện' ),
		'1P12_vHFXM94hYkS_hckL8ECppxAqhA7T' => array( 'Phòng tắm Azure Villa (loại D), Hoiana Beach Villas', 'thư viện' ),
		'1iJ_vDH0ufufwTLPqGZKy6ePhsH9EbhuJ' => array( $d, 'thư viện' ),
		'1pSb6_uAgUiI4H1AfZk7nzFXhrQsgHqb6' => array( $d . ' (góc 2)', 'thư viện' ),
		'1WCMGMJ9ksCL3de8_ADKp5t-Yy2WHptTl' => array( $d . ' (góc 3)', 'thư viện' ),
		'1JmuX7HWsiG1UEfXmjGEZHevDU2B5criw' => array( $d . ' (góc 4)', 'thư viện' ),
		'1DqIQXSNcuPYHfagIFaDg-gYumDWW2iJw' => array( $c, 'thư viện' ),
		'1AVvGI6nDh_4uERJDOHYnZ5PRWznxR2L-' => array( $c . ' (góc 2)', 'thư viện' ),
		'1vh2j4iFgyUSuGvr8gIYUSbAtaXgd6zOm' => array( $c . ' (góc 3)', 'thư viện' ),
		'1H2H12HBHfecTz0KV9c9fzOHJKIpIIdS9' => array( $c . ' (góc 4)', 'thư viện' ),
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$lines = array();
		foreach ( hh_hoiana_bv_images() as $id => list( $alt, $where ) ) {
			$lines[] = "https://drive.google.com/thumbnail?id=$id&sz=w2400 | $alt | $where";
		}
		$types = "Shore Villa (loại A) – 36 căn | Đất 350 m² · sàn 263 m² · vườn 100 m² | 3 | Liên hệ\nDune Villa (loại C) – 70 căn | Đất 544 m² · sàn 352 m² · vườn 170 m² | 3 | Liên hệ\nAzure Villa (loại D) – 46 căn | Đất 630 m² · sàn 398 m² · vườn 270 m² | 4 | Liên hệ\nPearl Villa (loại E) – 21 căn | Đất 702 m² · sàn 478 m² · vườn 270 m² | 4 | Liên hệ\nMarina Villa (loại F) – 23 căn | Đất 840 m² · sàn 553 m² · vườn 400 m² | 4 | Liên hệ\nPatina Mansion (loại B) – 1 căn | Đất 2.208 m² · sàn 1.655 m² · vườn 1.345 m² | 7 | Liên hệ\nVeranda Mansion (loại G) – 1 căn | Đất 3.132 m² · sàn 2.329 m² · vườn 1.600 m² | 9 | Liên hệ";
		$new   = array(
			'hh_p_unit_types' => $types,
			'hh_p_highlights' => "198 biệt thự biển 3 – 9 phòng ngủ trong quần thể Hoiana Resort & Golf gần 1.000 ha, 4 km bờ biển\nMỗi biệt thự có hồ bơi riêng và garage riêng, bàn giao full nội thất\nMarina Villa, Patina Mansion, Veranda Mansion trực diện biển; Pearl Villa kế biển, giáp sân golf\nKiến trúc nhiệt đới đương đại lấy cảm hứng từ di sản Hội An\nCư dân dùng toàn bộ tiện ích Hoiana: sân golf 18 hố, beach club, hơn 25 nhà hàng, spa, trung tâm giải trí",
			'hh_p_design_desc' => 'Kiến trúc Hoiana Beach Villas theo phong cách nhiệt đới đương đại, lấy cảm hứng từ di sản Hội An (Chùa Cầu): không gian sinh hoạt nối liền, mở ra vườn và hồ bơi riêng. Nội thất tối giản, dùng gỗ, đá tự nhiên, bề mặt đan thủ công và bảng màu trung tính. Cảnh quan theo ý tưởng năm giác quan với vườn hương liệu, cây bản địa, mặt nước và lối dạo. Dọc bờ biển là Marina Villa, Patina Mansion và Veranda Mansion; lùi phía sau là Dune Villa và Azure Villa giữa các khu vườn; Pearl Villa kế biển, giáp sân golf; Shore Villa nằm giữa mảng xanh nội khu, mức giá tiếp cận tốt nhất. Biệt thự cao tối đa 2 tầng (theo quy hoạch chi tiết).',
			'hh_p_amenities_in' => "Hồ bơi riêng từng biệt thự, garage riêng\nBeach club với hồ bơi vô cực dọc bờ biển\nTrung tâm chăm sóc sức khỏe: gym, yoga, spa\nKid's club, nhà hàng The Garden\nSảnh đón và lối vào riêng, concierge 24/7, an ninh 24/7\nSân golf Hoiana Shores 18 hố, 7.004 yards, par 71 (Robert Trent Jones Jr.), clubhouse 6.000 m²\nHơn 25 nhà hàng, 5 spa, 8 sân pickleball, 3 hồ bơi lớn, hơn 1.200 phòng khách sạn trong quần thể\nTrung tâm giải trí (KTV, bowling, bi-a, golf giả lập, khu trẻ em) mở từ 02/2026",
		);
		foreach ( $projects as $i => $p ) {
			if ( 'hoiana-beach-villas' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['hoiana-beach-villas']['meta'][ $k ] ?? '' ) : '' );
				$projects[ $i ]['meta'][ $k ] = $v;
				if ( is_string( $cur ) && '' !== $cur && $cur !== $v ) {
					$projects[ $i ]['fix_meta'][ $k ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) ) ) );
				}
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, '1WFS7kd0OZyRm7Tal2kgj2mjQirYoHrr6' ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $lines ) );
				if ( '' !== $cur ) {
					$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
				}
			}
		}
		return $projects;
	},
	69
);
