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
	$disc = array();
	foreach ( hh_table( 'hh_p_discount_table', 4, $post_id ) as $row ) {
		$sum    = hh_px_discount_sum( $row[3] ?? '' );
		$disc[] = $sum > 0 ? hh_px_pct( $sum ) : ( $row[2] ?? '' ); // Tổng cộng thẳng, như bảng chiết khấu.
	}
	$disc = implode( ' ', $disc );
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

/**
 * Hình minh họa mặt bằng (SVG tự vẽ) theo loại căn – dùng khi dự án chưa có ảnh layout thật.
 * Chỉ mang tính minh họa số phòng, không phải layout thực tế của căn.
 */
function hh_px_plan_svg( $group ) {
	$rect = static function ( $x, $y, $w, $h, $fill, $label ) {
		$t = $label ? sprintf( '<text x="%s" y="%s" text-anchor="middle" dominant-baseline="middle">%s</text>', $x + $w / 2, $y + $h / 2, esc_html( $label ) ) : '';
		return sprintf( '<rect x="%s" y="%s" width="%s" height="%s" fill="%s"/>', $x, $y, $w, $h, $fill ) . $t;
	};
	$bed   = '#f5ede5';
	$live  = '#ffffff';
	$wc    = '#e3eef9';
	$plus  = '#fff1e6';
	$out   = $rect( 10, 100, 180, 14, '#e3f3ea', 'Ban công' );
	$beds  = array( 'Studio' => 0, '1PN' => 1, '1PN+' => 1, '2PN' => 2, '2PN+' => 2, '3PN' => 3, 'Duplex' => 3, 'Penthouse' => 3 );
	if ( 'Shophouse' === $group ) {
		$out  = $rect( 10, 10, 180, 70, $live, 'Không gian kinh doanh' ) . $rect( 150, 80, 40, 20, $wc, 'WC' ) . $rect( 10, 80, 140, 20, $bed, 'Kho / bếp' );
		$out .= '<path d="M30 114h50M120 114h50" stroke="#ea580c" stroke-width="4"/>';
	} elseif ( isset( $beds[ $group ] ) ) {
		$n = $beds[ $group ];
		if ( ! $n ) {
			$out .= $rect( 10, 10, 145, 90, $live, 'Ngủ + khách + bếp' ) . $rect( 155, 10, 35, 40, $wc, 'WC' ) . $rect( 155, 50, 35, 50, $bed, 'Tủ' );
		} else {
			$w = ( 180 - 35 ) / $n;
			for ( $i = 0; $i < $n; $i++ ) {
				$out .= $rect( 10 + $w * $i, 10, $w, 50, $bed, 'PN ' . ( $i + 1 ) );
			}
			$out .= $rect( 155, 10, 35, 50, $wc, 'WC' );
			if ( false !== strpos( $group, '+' ) ) {
				$out .= $rect( 10, 60, 45, 40, $plus, 'Đa năng' ) . $rect( 55, 60, 135, 40, $live, 'Khách + bếp' );
			} else {
				$out .= $rect( 10, 60, 180, 40, $live, 'Phòng khách + bếp' );
			}
			if ( in_array( $group, array( 'Duplex', 'Penthouse' ), true ) ) {
				$out .= '<path d="M160 66h24M160 73h24M160 80h24M160 87h24M160 94h24" stroke="#8a5a36" stroke-width="2"/>';
			}
		}
	} else {
		return '';
	}
	return '<svg class="ucard__plan" viewBox="0 0 200 124" role="img" aria-label="' . esc_attr( 'Hình minh họa bố trí ' . $group ) . '"><g stroke="#0b2447" stroke-width="1.5" font-size="9" font-family="sans-serif" fill="#44526a">' . str_replace( '<text', '<text stroke="none" fill="#44526a"', $out ) . '</g><rect x="10" y="10" width="180" height="104" fill="none" stroke="#0b2447" stroke-width="3.5"/></svg>';
}

/**
 * Tổng chiết khấu cộng thẳng từ cột "Cách tính" ("Early Bird 3% + không vay 3% + thanh toán sớm 12%" → 18). Bỏ phần trong ngoặc.
 * Trả 0 nếu không đọc được.
 */
function hh_px_discount_sum( $how ) {
	$how = preg_replace( '/\([^)]*\)/u', '', (string) $how );
	$sum = 0;
	$n   = 0;
	foreach ( preg_split( '/\s*\+\s*/u', $how ) as $part ) {
		if ( preg_match( '/(\d+(?:[.,]\d+)?)\s*%/u', $part, $m ) ) {
			$sum += (float) str_replace( ',', '.', $m[1] );
			$n++;
		}
	}
	return $n ? $sum : 0;
}

/** 18 → "18%", 8.5 → "8,5%". */
function hh_px_pct( $f ) {
	return str_replace( '.', ',', rtrim( rtrim( number_format( (float) $f, 2, '.', '' ), '0' ), '.' ) ) . '%';
}
