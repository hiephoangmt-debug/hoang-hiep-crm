<?php
/**
 * Backlink sang danangstay.com.vn (trang cẩm nang du lịch Đà Nẵng – Hội An của anh Hiệp, yêu cầu 24/11/2026):
 * "lâu lâu" – chỉ khoảng 1/3 số bài viết (theo ID bài), tối đa 1 link mỗi bài, gắn vào lần nhắc đầu tiên
 * một địa danh / chủ đề du lịch có bài tương ứng bên DanangStay. Không đụng tiêu đề, link có sẵn, trang dự án.
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

function hh_danangstay_targets() {
	$vi = 'https://danangstay.com.vn/vi/';
	$en = 'https://danangstay.com.vn/';
	return array(
		// Tiếng Việt.
		$vi . 'son-tra-ban-dao-hoang-so-cach-pho-muoi-phut-vi/'          => array( 'bán đảo Sơn Trà' ),
		$vi . 'nhung-bai-bien-dep-nhat-o-da-nang-va-lan-can-vi/'         => array( 'bãi biển Mỹ Khê', 'biển Mỹ Khê', 'bãi biển Đà Nẵng' ),
		$vi . 'ba-na-va-cau-vang-di-sao-cho-dung-vi/'                    => array( 'Bà Nà Hills', 'Cầu Vàng' ),
		$vi . 'hoi-an-khi-dem-xuong-den-long-tiem-may-va-dong-song-dem-ram-vi/' => array( 'phố cổ Hội An' ),
		$vi . 'da-huong-tram-va-bien-ngu-hanh-son-va-chua-linh-ung-vi/'  => array( 'núi Ngũ Hành Sơn', 'chùa Linh Ứng' ),
		$vi . 'mot-ngay-di-hue-qua-deo-hai-van-vi/'                      => array( 'đèo Hải Vân' ),
		$vi . 'thoi-tiet-da-nang-qua-tung-thang-vi/'                     => array( 'thời tiết Đà Nẵng', 'mùa du lịch' ),
		$vi . 'o-dau-khi-den-da-nang-so-sanh-cac-khu-vuc-vi/'            => array( 'khách du lịch', 'du lịch Đà Nẵng', 'lưu trú ngắn ngày' ),
		$vi . 'muoi-hai-mon-phai-an-o-da-nang-vi/'                       => array( 'ẩm thực Đà Nẵng', 'mì Quảng' ),
		$vi . 'da-nang-ve-dem-cho-dem-quan-san-thuong-va-dong-song-vi/'  => array( 'chợ đêm', 'sông Hàn về đêm' ),
		$vi . 'le-hoi-da-nang-va-hoi-an-mot-nam-ron-rang-vi/'           => array( 'lễ hội pháo hoa', 'pháo hoa quốc tế' ),
		$vi . 'mot-chuyen-di-da-nang-ton-bao-nhieu-vi/'                  => array( 'chi phí du lịch' ),
		// English (/en/).
		$en . 'son-tra-peninsula-guide/'      => array( 'Son Tra Peninsula' ),
		$en . 'best-beaches-da-nang/'         => array( 'My Khe Beach' ),
		$en . 'ba-na-hills-golden-bridge-guide/' => array( 'Ba Na Hills', 'Golden Bridge' ),
		$en . 'hoi-an-lanterns-guide/'        => array( 'Hoi An Ancient Town', 'Hoi An old town' ),
		$en . 'marble-mountains-lady-buddha/' => array( 'Marble Mountains' ),
		$en . 'hue-day-trip-hai-van-pass/'    => array( 'Hai Van Pass' ),
		$en . 'where-to-stay-in-da-nang/'     => array( 'tourists', 'short-term rental' ),
	);
}

add_filter( 'the_content', 'hh_link_danangstay', 45 );
function hh_link_danangstay( $html ) {
	if ( is_admin() || is_feed() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() || '' === $html ) {
		return $html;
	}
	if ( 0 !== get_the_ID() % 3 || false !== stripos( $html, 'danangstay.com.vn' ) ) {
		return $html; // "Lâu lâu": ~1/3 số bài; bài đã có link DanangStay thì thôi.
	}
	$parts = preg_split( '/(<[^>]+>)/u', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
	$skip  = 0;
	foreach ( $parts as $i => $part ) {
		if ( '' === $part ) {
			continue;
		}
		if ( '<' === $part[0] ) {
			if ( preg_match( '#^<(/?)(a|h[1-6]|script|style|button|figcaption|title|summary|label|option|textarea|table)\b#i', $part, $m ) ) {
				$skip += '/' === $m[1] ? -1 : 1;
				$skip  = max( 0, $skip );
			}
			continue;
		}
		if ( $skip ) {
			continue;
		}
		foreach ( hh_danangstay_targets() as $url => $names ) {
			foreach ( $names as $name ) {
				$re = '/(?<![\p{L}\d\-])' . preg_quote( $name, '/' ) . '(?![\p{L}\d])/iu';
				if ( preg_match( $re, $part, $mm, PREG_OFFSET_CAPTURE ) ) {
					$pos         = $mm[0][1];
					$a           = '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" title="Cẩm nang du lịch Đà Nẵng – DanangStay">' . $mm[0][0] . '</a>';
					$parts[ $i ] = substr( $part, 0, $pos ) . $a . substr( $part, $pos + strlen( $mm[0][0] ) );
					return implode( '', $parts );
				}
			}
		}
	}
	return $html;
}
