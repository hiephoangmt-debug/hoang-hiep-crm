<?php
/**
 * Bảng trong bài viết / nội dung dự án: tự gắn nhãn cột để hiển thị đẹp trên điện thoại.
 * - Bảng 2 cột (Tên | Giá trị): giữ dạng bảng, chữ xuống dòng, không tràn màn hình.
 * - Bảng có tiêu đề từ 3 cột trở lên: mỗi dòng thành một thẻ, nhãn cột đứng trước giá trị.
 */

defined( 'ABSPATH' ) || exit;

function hoanghiep_content_tables( $html ) {
	if ( false === stripos( $html, '<table' ) ) {
		return $html;
	}
	return preg_replace_callback(
		'#<table([^>]*)>(.*?)</table>#is',
		static function ( $m ) {
			$attrs = $m[1];
			$body  = $m[2];
			if ( false !== strpos( $attrs, 'hh-tbl' ) ) {
				return $m[0];
			}
			$labels = array();
			if ( preg_match( '#<thead[^>]*>(.*?)</thead>#is', $body, $head ) ) {
				preg_match_all( '#<th[^>]*>(.*?)</th>#is', $head[1], $ths );
				$labels = array_map( static fn( $t ) => trim( wp_strip_all_tags( $t ) ), $ths[1] );
			}
			preg_match( '#<tr[^>]*>(.*?)</tr>#is', preg_replace( '#<thead.*?</thead>#is', '', $body ), $first );
			$cols  = $labels ? count( $labels ) : ( $first ? preg_match_all( '#<t[dh][\s>]#i', $first[1] ) : 0 );
			$class = 2 >= $cols ? 'hh-tbl hh-tbl--kv' : ( $labels ? 'hh-tbl hh-tbl--cards' : 'hh-tbl hh-tbl--scroll' );
			if ( $labels && $cols > 2 ) {
				$body = preg_replace_callback(
					'#<tr([^>]*)>(.*?)</tr>#is',
					static function ( $r ) use ( $labels ) {
						$i = 0;
						$cells = preg_replace_callback(
							'#<td(?![^>]*data-label)([^>]*)>#i',
							static function ( $c ) use ( $labels, &$i ) {
								$label = $labels[ $i++ ] ?? '';
								return '<td data-label="' . esc_attr( $label ) . '"' . $c[1] . '>';
							},
							$r[2]
						);
						return '<tr' . $r[1] . '>' . $cells . '</tr>';
					},
					$body
				);
			}
			$attrs = preg_match( '#class="#', $attrs ) ? preg_replace( '#class="#', 'class="' . $class . ' ', $attrs, 1 ) : $attrs . ' class="' . $class . '"';
			return '<div class="hh-tbl-wrap"><table' . $attrs . '>' . $body . '</table></div>';
		},
		$html
	);
}
add_filter( 'the_content', 'hoanghiep_content_tables', 30 );

/**
 * Trang dự án: bài giới thiệu thường có các mục "Tổng quan", "Vị trí", "Bảng giá", "Chính sách"… trùng với các mục
 * trang tự dựng từ dữ liệu bên dưới. Ẩn mục trùng (chỉ khi mục bên dưới đã có dữ liệu), giữ phần nhận định riêng.
 */
function hoanghiep_project_dedupe( $html ) {
	if ( ! is_singular( 'du-an' ) || false === stripos( $html, '<h2' ) || ! in_the_loop() ) {
		return $html;
	}
	$id   = get_the_ID();
	$has  = static fn( $key ) => '' !== trim( (string) get_post_meta( $id, $key, true ) );
	$dups = array(
		'/^(thông tin )?tổng quan/u'          => true,
		'/^\d+ phân khu/u'                    => $has( 'hh_p_zones' ),
		'/^vị trí/u'                          => $has( 'hh_p_location_desc' ),
		'/^tiện ích/u'                        => $has( 'hh_p_amenities_in' ),
		'/^bảng giá/u'                        => $has( 'hh_p_price_table' ),
		'/^chính sách/u'                      => $has( 'hh_p_policy' ),
		'/^tiến độ/u'                         => $has( 'hh_p_progress' ),
		'/^pháp lý/u'                         => $has( 'hh_p_legal' ),
		'/^(câu hỏi|hỏi đáp)/u'               => $has( 'hh_p_faq' ),
	);
	$parts = preg_split( '#(?=<h2[\s>])#i', $html );
	foreach ( $parts as $i => $part ) {
		if ( ! preg_match( '#^<h2[^>]*>(.*?)</h2>#is', $part, $m ) ) {
			continue;
		}
		$head = mb_strtolower( trim( html_entity_decode( wp_strip_all_tags( $m[1] ) ) ) );
		foreach ( $dups as $re => $on ) {
			if ( $on && preg_match( $re, $head ) ) {
				unset( $parts[ $i ] );
				break;
			}
		}
	}
	return implode( '', $parts );
}
add_filter( 'the_content', 'hoanghiep_project_dedupe', 25 );
