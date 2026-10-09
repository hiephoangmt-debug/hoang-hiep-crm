<?php
/**
 * Thành phần trang dự án: dải con số nổi bật, giá thấp nhất theo loại căn, hồ sơ pháp lý, ảnh phối cảnh chính.
 */

defined( 'ABSPATH' ) || exit;

/** "4,53 – 5,86 tỷ" / "Thử 2,5 tỷ" / "850 triệu" → giá (triệu đồng) đầu tiên, 0 nếu không đọc được. */
function hh_px_price_trieu( $text ) {
	$text = (string) $text;
	if ( ! preg_match( '/(\d+(?:[.,]\d+)?)/u', $text, $m ) ) {
		return 0;
	}
	$v = preg_match( '/^\d{1,3}(\.\d{3})+$/', $m[1] ) ? (float) str_replace( '.', '', $m[1] ) : (float) str_replace( ',', '.', $m[1] );
	if ( false !== mb_stripos( $text, 'tỷ' ) ) {
		return $v * 1000;
	}
	return false !== mb_stripos( $text, 'triệu' ) ? $v : 0;
}

/** Nhóm loại căn từ tên dòng bảng giá. */
function hh_px_unit_group( $name ) {
	$map = array(
		'Studio'    => '/studio|\bstu\b/iu',
		'1PN+'      => '/1\s*(pn|br|phòng ngủ)\s*\+/iu',
		'1PN'       => '/1\s*(pn|br|phòng ngủ)/iu',
		'2PN+'      => '/2\s*(pn|br|phòng ngủ)\s*\+/iu',
		'2PN'       => '/2\s*(pn|br|phòng ngủ)/iu',
		'3PN'       => '/3\s*(pn|br|phòng ngủ)/iu',
		'Duplex'    => '/duplex/iu',
		'Penthouse' => '/penthouse/iu',
		'Shophouse' => '/shophouse|shop/iu',
		'Biệt thự'  => '/biệt thự|villa/iu',
		'Nhà phố'   => '/nhà phố|townhouse|liền kề/iu',
		'Đất nền'   => '/đất nền|\blô\b/iu',
	);
	foreach ( $map as $label => $re ) {
		if ( preg_match( $re, (string) $name ) ) {
			return $label;
		}
	}
	return '';
}

/** Giá thấp nhất mỗi loại căn: [ label => [ 'price' => triệu, 'area' => 'm²' ] ], sắp theo giá. */
function hh_px_price_from( $post_id = null ) {
	$out  = array();
	$add  = static function ( $name, $area, $price ) use ( &$out ) {
		$g = hh_px_unit_group( $name );
		$p = hh_px_price_trieu( $price );
		if ( ! $g || $p <= 0 ) {
			return;
		}
		if ( ! isset( $out[ $g ] ) || $p < $out[ $g ]['price'] ) {
			$out[ $g ] = array( 'price' => $p, 'area' => trim( preg_replace( '/\s*\(.*\)/u', '', (string) $area ) ) );
		}
	};
	foreach ( hh_table( 'hh_p_unit_types', 4, $post_id ) as $r ) {
		$add( $r[0], $r[1], $r[3] );
	}
	foreach ( hh_table( 'hh_p_price_table', 4, $post_id ) as $r ) {
		$add( $r[0], $r[1], $r[2] );
	}
	// Bảng căn (Dự án → Bảng tính căn): giá niêm yết = giá cao nhất trong các phương án của căn.
	$units = function_exists( 'hh_units_data' ) ? hh_units_data( $post_id ?: get_the_ID() ) : null;
	foreach ( (array) ( $units['units'] ?? array() ) as $u ) {
		$list = $u['prices'] ? max( array_map( 'floatval', (array) $u['prices'] ) ) : 0;
		$type = trim( (string) ( $u['type'] ?? '' ) );
		$type = preg_match( '/^\d$/', $type ) ? $type . 'PN' : $type;
		if ( $list > 0 && $type ) {
			$add( $type, ( $u['area'] ?? '' ) ? $u['area'] . ' m²' : '', ( $list / 1e6 ) . ' triệu' );
		}
	}
	uasort( $out, static fn( $a, $b ) => $a['price'] <=> $b['price'] );
	return $out;
}

/** Tỷ đồng gọn: 4533 → "4,53 tỷ", 850 → "850 triệu". */
function hh_px_money( $trieu ) {
	return $trieu >= 1000 ? rtrim( rtrim( number_format( $trieu / 1000, 2, ',', '.' ), '0' ), ',' ) . ' tỷ' : number_format( $trieu, 0, ',', '.' ) . ' triệu';
}

/** Dải con số nổi bật đầu trang: giá từ, chiết khấu, số căn, số tầng, quy mô, bàn giao. */
function hh_px_numbers( $post_id = null ) {
	$m     = static fn( $k ) => trim( (string) hh_meta( $k, $post_id ) );
	$items = array();
	$from  = hh_px_price_from( $post_id );
	$low   = $from ? reset( $from )['price'] : (float) $m( 'hh_p_price_from' );
	if ( $low > 0 ) {
		$items[] = array( hh_px_money( $low ), 'Giá chỉ từ' );
	}
	$pct = array();
	$disc = implode( ' ', array_column( hh_table( 'hh_p_discount_table', 4, $post_id ), 2 ) );
	foreach ( array( $disc, $m( 'hh_p_offer_title' ), $m( 'hh_p_policy' ) ) as $i => $t ) {
		$re = $i ? '/(?:chiết khấu|giảm|ưu đãi|tiết kiệm)[^%\n]{0,40}?(\d{1,2}(?:[.,]\d+)?)\s?%/iu' : '/(\d{1,2}(?:[.,]\d+)?)\s?%/u';
		if ( preg_match_all( $re, $t, $mm ) ) {
			foreach ( $mm[1] as $v ) {
				$f = (float) str_replace( ',', '.', $v );
				if ( $f > 0 && $f < 40 ) {
					$pct[] = $f;
				}
			}
		}
		if ( $pct ) {
			break;
		}
	}
	if ( $pct ) {
		$items[] = array( str_replace( '.', ',', (string) max( $pct ) ) . '%', 'Chiết khấu tới' );
	}
	if ( preg_match( '/(\d{1,3}(?:\.\d{3})+|\d{2,})\s*(căn|sản phẩm|lô|biệt thự)/u', $m( 'hh_p_units' ), $x ) ) {
		$items[] = array( $x[1], 'căn' === $x[2] ? 'Căn hộ' : ( 'lô' === $x[2] ? 'Lô đất' : 'Sản phẩm' ) );
	}
	if ( preg_match( '/(\d{1,3})\s*tầng/u', $m( 'hh_p_floors' ), $x ) ) {
		$items[] = array( $x[1], 'Tầng cao' );
	}
	if ( preg_match( '/(\d+(?:[.,]\d+)?)\s*ha\b/u', $m( 'hh_p_scale' ), $x ) ) {
		$items[] = array( $x[1] . ' ha', 'Quy mô' );
	}
	if ( preg_match( '/(\d{1,2}\/\d{1,2}\/20\d\d|quý\s*\d\s*\/\s*20\d\d|20\d\d)/iu', $m( 'hh_p_handover' ), $x ) ) {
		$items[] = array( preg_replace( '/quý\s*/iu', 'Q', $x[1] ), 'Bàn giao dự kiến' );
	}
	return array_slice( $items, 0, 5 );
}

/** Ảnh phối cảnh chính cho mục Tổng quan: ảnh thư viện đầu tiên khác ảnh đại diện, không có thì ảnh đại diện. */
function hh_px_hero_image( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$thumb   = (int) get_post_thumbnail_id( $post_id );
	foreach ( hh_ids( 'hh_p_gallery', $post_id ) as $id ) {
		if ( $id !== $thumb && wp_get_attachment_image_url( $id, 'large' ) ) {
			return $id;
		}
	}
	return $thumb;
}

/** Ảnh minh họa vị trí: ảnh vị trí → mặt bằng tổng thể → ảnh thư viện thứ 2. */
function hh_px_location_image( $post_id = null ) {
	foreach ( array( hh_ids( 'hh_p_location_img', $post_id ), hh_ids( 'hh_p_masterplan_img', $post_id ) ) as $ids ) {
		if ( $ids ) {
			return $ids[0];
		}
	}
	$g = hh_ids( 'hh_p_gallery', $post_id );
	return $g[1] ?? ( $g[0] ?? 0 );
}

/** Hồ sơ pháp lý: ô "Hồ sơ pháp lý", không có thì dựng từ ô pháp lý, hình thức sở hữu. */
function hh_px_legal_docs( $post_id = null ) {
	$docs = hh_lines( 'hh_p_legal_docs', $post_id );
	if ( $docs ) {
		return $docs;
	}
	return array_values( array_filter( array( hh_meta( 'hh_p_legal', $post_id ), hh_meta( 'hh_p_ownership', $post_id ) ? 'Hình thức sở hữu: ' . hh_meta( 'hh_p_ownership', $post_id ) : '' ) ) );
}
