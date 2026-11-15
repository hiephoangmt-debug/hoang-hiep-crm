<?php
/**
 * Liên kết nội bộ tự động: lần nhắc đầu tiên tên một dự án ưu tiên trong bài viết / trang dự án
 * được gắn link về trang dự án đó (tối đa 3 link mỗi trang, không đụng tiêu đề, link có sẵn).
 * Giúp các dự án ít link trỏ về (Symphony 5, The Legend, Nobu, Cora, Capital Square, The Poet, Casamia Balanca) dễ được Google thu thập.
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

function hh_autolink_targets() {
	// Thứ tự = ưu tiên (tối đa 3 link mỗi trang). Khóa "post:<slug>" = bài viết (VD bài giá), còn lại là trang dự án.
	return array(
		'sun-saphia-residence'              => array( 'Sun Saphia Residence', 'Sun Saphia' ),
		'post:gia-sun-saphia-residence-bao-nhieu' => array( 'giá Sun Saphia Residence', 'giá Sun Saphia', 'bảng giá Sun Saphia' ),
		'spana-tower'                       => array( 'Spana Tower' ),
		's-light-tower'                     => array( 'S-Light Tower', "Sun's Light", 'S-Light' ),
		'fours-tower'                       => array( 'FourS Tower' ),
		'sun-ponte-residence'               => array( 'Sun Ponte Residence', 'Sun Ponte' ),
		'sun-symphony-residence'            => array( 'Sun Symphony Residence' ),
		'symphony-5-sun-symphony-residence' => array( 'Sun Symphony 5', 'Symphony 5' ),
		'the-legend-da-nang'                => array( 'The Legend City', 'The Legend Đà Nẵng', 'The Legend' ),
		'nobu-da-nang'                      => array( 'Nobu Residences Đà Nẵng', 'Nobu Residences', 'Nobu Đà Nẵng' ),
		'cora-tower'                        => array( 'Cora Tower' ),
		'capital-square-da-nang'            => array( 'Capital Square Đà Nẵng', 'Capital Square' ),
		'the-poet-residence-da-nang'        => array( 'The Poet Residence', 'The Poet Đà Nẵng' ),
		'casamia-balanca-hoi-an'            => array( 'Casamia Balanca' ),
	);
}

add_filter( 'the_content', 'hh_autolink_projects', 40 );
function hh_autolink_projects( $html ) {
	if ( is_admin() || is_feed() || ! is_singular( array( 'post', 'du-an' ) ) || ! in_the_loop() || ! is_main_query() || '' === $html ) {
		return $html;
	}
	$self  = get_post_field( 'post_name', get_the_ID() );
	$todo  = array();
	foreach ( hh_autolink_targets() as $slug => $names ) {
		$type = 0 === strpos( $slug, 'post:' ) ? 'post' : 'du-an';
		$path = 'post' === $type ? substr( $slug, 5 ) : $slug;
		if ( $path === $self || ( 'du-an' === $type && 0 === strpos( $self, $slug . '-' ) ) ) {
			continue;
		}
		$p = get_page_by_path( $path, OBJECT, $type );
		if ( ! $p || 'publish' !== $p->post_status ) {
			continue;
		}
		$url = get_permalink( $p );
		if ( false !== strpos( $html, ( 'post' === $type ? '/' : '/du-an/' ) . $path . '/' ) || false !== strpos( $html, $url ) ) {
			continue; // Bài đã có link tới dự án này.
		}
		$todo[ $slug ] = array( $url, $names );
	}
	if ( ! $todo ) {
		return $html;
	}
	$parts = preg_split( '/(<[^>]+>)/u', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
	$skip  = 0; // Độ sâu trong a / h1-h6 / script / style / button / figcaption.
	$left  = 3;
	foreach ( $parts as $i => $part ) {
		if ( '' === $part ) {
			continue;
		}
		if ( '<' === $part[0] ) {
			if ( preg_match( '#^<(/?)(a|h[1-6]|script|style|button|figcaption|title|summary|label|option|textarea)\b#i', $part, $m ) ) {
				$skip += '/' === $m[1] ? -1 : 1;
				$skip  = max( 0, $skip );
			}
			continue;
		}
		if ( $skip || $left <= 0 ) {
			continue;
		}
		foreach ( $todo as $slug => $t ) {
			foreach ( $t[1] as $name ) {
				$re = '/(?<![\p{L}\d\-])' . preg_quote( $name, '/' ) . '(?![\p{L}\d])/u';
				if ( preg_match( $re, $part, $mm, PREG_OFFSET_CAPTURE ) ) {
					$pos  = $mm[0][1];
					$part = substr( $part, 0, $pos ) . '<a href="' . esc_url( $t[0] ) . '">' . $mm[0][0] . '</a>' . substr( $part, $pos + strlen( $mm[0][0] ) );
					unset( $todo[ $slug ] );
					--$left;
					break;
				}
			}
			if ( $left <= 0 ) {
				break;
			}
		}
		$parts[ $i ] = $part;
		if ( ! $todo ) {
			break;
		}
	}
	return implode( '', $parts );
}
