<?php
/**
 * Trang chi tiết tin rao (bat-dong-san) – dữ liệu dùng chung cho template và schema (anh Hiệp 17/11/2026).
 * Chỉ dùng dữ liệu thật của tin; ô nào trống thì ẩn.
 */

defined( 'ABSPATH' ) || exit;

/** Ảnh có chú thích / alt / tên file là mặt bằng, bản vẽ, sơ đồ → mục "Mặt bằng & thiết kế". */
function hh_ld_is_plan_img( $id ) {
	$t = implode( ' ', array( get_post_meta( $id, '_wp_attachment_image_alt', true ), wp_get_attachment_caption( $id ), get_the_title( $id ), basename( (string) get_attached_file( $id ) ) ) );
	return (bool) preg_match( '/m[aặ]t[ -]?b[aằ]ng|b[aả]n[ -]?v[eẽ]|s[oơ][ -]?đ[oồ]|so-do|layout|ph[aâ]n l[oô]|thi[eế]t k[eế]/iu', $t );
}

/** Ảnh tin: [ảnh chính (thực tế), ảnh mặt bằng / bản vẽ]. */
function hh_ld_photos( $post_id ) {
	$all   = array_values( array_unique( array_filter( array_map( 'intval', array_merge( array( get_post_thumbnail_id( $post_id ) ), hh_ids( 'hh_gallery', $post_id ) ) ) ) ) );
	$plans = array_values( array_unique( array_filter( array_map( 'intval', hh_ids( 'hh_plans', $post_id ) ) ) ) );
	$main  = array();
	foreach ( $all as $i => $id ) {
		if ( $i > 0 && hh_ld_is_plan_img( $id ) ) {
			$plans[] = $id;
		} else {
			$main[] = $id;
		}
	}
	return array( $main, array_values( array_unique( $plans ) ) );
}

/** Ô thông số nổi bật: [nhãn, giá trị, lớp]. Chỉ ô có dữ liệu. */
function hh_ld_facts( $post_id ) {
	$schema = hh_listing_schema();
	$m      = static fn( $k ) => hh_meta( $k, $post_id );
	$opt    = static fn( $k ) => $m( $k ) ? hh_option_label( $schema, $k, $m( $k ) ) : '';
	$num    = static fn( $v ) => function_exists( 'hh_vn_num' ) ? hh_vn_num( $v ) : $v;
	$type   = get_the_terms( $post_id, 'loai-bds' );
	$area   = get_the_terms( $post_id, 'khu-vuc' );
	$rent   = 'thue' === ( $m( 'hh_deal' ) ?: 'ban' );
	$size   = $m( 'hh_width' ) && $m( 'hh_length' ) ? $num( $m( 'hh_width' ) ) . ' × ' . $num( $m( 'hh_length' ) ) . ' m' : ( $m( 'hh_frontage' ) ? 'Mặt tiền ' . $num( $m( 'hh_frontage' ) ) . ' m' : '' );
	$facts  = array(
		array( $rent ? 'Giá thuê' : 'Giá bán', hh_listing_price( $post_id ), 'price' ),
		array( 'Diện tích', $m( 'hh_area' ) ? $num( $m( 'hh_area' ) ) . ' m²' : '', 'area' ),
		array( 'Đơn giá', $rent ? '' : hh_listing_price_m2( $post_id ), '' ),
		array( 'Loại hình', $type && ! is_wp_error( $type ) ? $type[0]->name : '', '' ),
		array( 'Phòng ngủ', $m( 'hh_bedrooms' ) ? $m( 'hh_bedrooms' ) . ' PN' : '', '' ),
		array( 'Phòng vệ sinh', $m( 'hh_bathrooms' ) ? $m( 'hh_bathrooms' ) . ' WC' : '', '' ),
		array( 'Hướng nhà', $opt( 'hh_direction' ), '' ),
		array( 'Hướng ban công', $opt( 'hh_balcony' ), '' ),
		array( 'Kích thước', $size, '' ),
		array( 'Số tầng', $m( 'hh_floors' ) ? $m( 'hh_floors' ) . ' tầng' : '', '' ),
		array( 'Nội thất', $opt( 'hh_furniture' ), '' ),
		array( 'Pháp lý', $opt( 'hh_legal' ), '' ),
		array( 'Tình trạng', $opt( 'hh_status' ), '' ),
		array( 'Năm xây / bàn giao', $m( 'hh_year' ), '' ),
		array( 'Khu vực', $area && ! is_wp_error( $area ) ? $area[0]->name : '', '' ),
	);
	return array_values( array_filter( $facts, static fn( $f ) => '' !== trim( (string) $f[1] ) ) );
}

/** Tiện ích xung quanh chia nhóm theo từ khoá của từng dòng (dòng không khớp → "Tiện ích khác"). */
function hh_ld_nearby_groups( $post_id ) {
	$groups = array(
		'Biển, sông, công viên'        => '/biển|bãi tắm|sông|hồ |công viên|quảng trường|cây xanh/iu',
		'Trường học'                   => '/trường|mầm non|tiểu học|THCS|THPT|đại học|học viện/iu',
		'Y tế'                         => '/bệnh viện|phòng khám|trạm y tế|nhà thuốc/iu',
		'Mua sắm'                      => '/chợ|siêu thị|trung tâm thương mại|TTTM|vincom|lotte|aeon|go!|big c|cửa hàng/iu',
		'Giao thông'                   => '/sân bay|ga |bến xe|cầu |đường |cao tốc|quốc lộ|ngã tư|vòng xoay|trung tâm thành phố/iu',
		'Nhà hàng, giải trí, dịch vụ'  => '/nhà hàng|cà phê|cafe|khu vui chơi|giải trí|rạp|gym|spa|khách sạn|resort|golf/iu',
	);
	$out = array();
	foreach ( hh_lines( 'hh_nearby', $post_id ) as $line ) {
		$key = 'Tiện ích khác';
		foreach ( $groups as $g => $re ) {
			if ( preg_match( $re, $line ) ) {
				$key = $g;
				break;
			}
		}
		$out[ $key ][] = $line;
	}
	return $out;
}

/** Hỏi đáp chỉ từ dữ liệu có thật của tin. */
function hh_ld_faq( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$schema  = hh_listing_schema();
	$m       = static fn( $k ) => hh_meta( $k, $post_id );
	$num     = static fn( $v ) => function_exists( 'hh_vn_num' ) ? hh_vn_num( $v ) : $v;
	$rent    = 'thue' === ( $m( 'hh_deal' ) ?: 'ban' );
	$title   = get_the_title( $post_id );
	$phone   = function_exists( 'hoanghiep_opt' ) ? hoanghiep_opt( 'hh_phone' ) : '';
	$rows    = array();
	$price   = hh_listing_price( $post_id );
	if ( $price && ! preg_match( '/liên hệ|thỏa thuận|thoả thuận/iu', $price ) ) {
		$rows[] = array( ( $rent ? 'Giá thuê' : 'Giá bán' ) . ' bao nhiêu?', ( $rent ? 'Giá thuê ' : 'Giá bán ' ) . $price . ( hh_listing_price_m2( $post_id ) && ! $rent ? ' (' . hh_listing_price_m2( $post_id ) . ')' : '' ) . ( '1' === $m( 'hh_negotiable' ) ? ', còn thương lượng' : '' ) . '.' );
	}
	if ( $m( 'hh_area' ) ) {
		$rows[] = array( 'Diện tích bao nhiêu?', 'Diện tích ' . $num( $m( 'hh_area' ) ) . ' m²' . ( $m( 'hh_area_use' ) ? ', diện tích sử dụng ' . $num( $m( 'hh_area_use' ) ) . ' m²' : '' ) . ( $m( 'hh_width' ) && $m( 'hh_length' ) ? ', kích thước ' . $num( $m( 'hh_width' ) ) . ' × ' . $num( $m( 'hh_length' ) ) . ' m' : '' ) . '.' );
	}
	if ( $m( 'hh_legal' ) ) {
		$rows[] = array( 'Pháp lý như thế nào?', 'Pháp lý: ' . hh_option_label( $schema, 'hh_legal', $m( 'hh_legal' ) ) . '. Hoàng Hiệp gửi bản chụp giấy tờ để kiểm tra trước khi xem nhà.' );
	}
	if ( $m( 'hh_address' ) ) {
		$rows[] = array( 'Bất động sản ở đâu?', $m( 'hh_address' ) . '.' );
	}
	$rows[] = array( 'Có thể xem nhà thực tế không?', 'Có. Liên hệ Hoàng Hiệp' . ( $phone ? ' – ' . $phone : '' ) . ' (gọi hoặc Zalo) để hẹn lịch xem ' . ( $rent ? 'nhà' : 'tận nơi' ) . ' và nhận thêm ảnh, video thực tế.' );
	return $rows;
}

/**
 * Mặt bằng, hình tòa nhà và công cụ chọn căn lấy từ dự án của tin (anh Hiệp 17/11/2026).
 * Trả về array() nếu tin không gắn dự án hoặc dự án chưa có ảnh.
 */
function hh_ld_project_media( $post_id ) {
	$pid = (int) hh_meta( 'hh_project', $post_id );
	if ( ! $pid || 'publish' !== get_post_status( $pid ) ) {
		return array();
	}
	$ok   = static fn( $id ) => $id && wp_get_attachment_image_url( $id, 'large' );
	$cap  = static fn( $id ) => trim( (string) ( wp_get_attachment_caption( $id ) ?: get_the_title( $id ) ) );
	// Hình tòa nhà: ảnh đại diện dự án, nếu đó là mặt bằng / bản vẽ thì lấy ảnh phối cảnh đầu tiên trong thư viện dự án.
	$plan_ids = array_map( 'intval', array_merge( hh_ids( 'hh_p_floorplans', $pid ), hh_ids( 'hh_p_unit_layouts', $pid ), array( (int) hh_meta( 'hh_p_masterplan_img', $pid ) ) ) );
	$bld      = 0;
	foreach ( array_merge( array( (int) get_post_thumbnail_id( $pid ) ), array_map( 'intval', hh_ids( 'hh_p_gallery', $pid ) ) ) as $cand ) {
		if ( $ok( $cand ) && ! in_array( $cand, $plan_ids, true ) && ! hh_ld_is_plan_img( $cand ) ) {
			$bld = $cand;
			break;
		}
	}
	$out  = array(
		'id'       => $pid,
		'title'    => get_the_title( $pid ),
		'url'      => get_permalink( $pid ),
		'building' => $ok( $bld ) ? $bld : 0,
		'plans'    => array(),
		'tower'    => has_term( array( 'can-ho', 'can-ho-chung-cu', 'can-ho-dich-vu', 'can-ho-so-huu-lau-dai', 'chung-cu', 'penthouse', 'duplex', 'studio', 'officetel', 'condotel' ), 'loai-bds', $post_id ) || (bool) preg_match( '/căn hộ|chung cư|studio|penthouse|duplex|\d\s*pn/iu', get_the_title( $post_id ) ),
		'units'    => (bool) hh_meta( 'hh_p_tour_units', $pid ),
		'tour'     => (bool) hh_meta( 'hh_p_tour_4d', $pid ),
	);
	// Layout đúng loại căn của tin (theo số phòng ngủ / studio).
	$beds = (int) hh_meta( 'hh_bedrooms', $post_id );
	$t    = mb_strtolower( get_the_title( $post_id ) );
	$re   = false !== strpos( $t, 'studio' ) ? '/studio/iu' : ( $beds ? '/(^|\D)' . $beds . '\s*(pn|phòng ngủ|br|bed)/iu' : '' );
	if ( $re ) {
		foreach ( hh_ids( 'hh_p_unit_layouts', $pid ) as $lid ) {
			if ( $ok( $lid ) && preg_match( $re, $cap( $lid ) . ' ' . basename( (string) get_attached_file( $lid ) ) ) ) {
				$out['plans'][] = array( (int) $lid, preg_match( '/^layout|^m[aặ]t b[aằ]ng/iu', $cap( $lid ) ) ? $cap( $lid ) : 'Layout ' . $cap( $lid ) );
			}
		}
	}
	// Mặt bằng tầng: bỏ tầng hầm, mái; tầng điển hình / tầng ở lên trước, tầng 1 – tiện ích xuống sau.
	$floors = array();
	foreach ( hh_ids( 'hh_p_floorplans', $pid ) as $fid ) {
		$c = $cap( $fid );
		if ( ! $ok( $fid ) || preg_match( '/h[aầ]m|m[aá]i\b|basement/iu', $c ) ) {
			continue;
		}
		$floors[ (int) $fid ] = preg_match( '/đi[eể]n h[iì]nh|t[aầ]ng\s*\d{1,2}\s*[-–]\s*\d/iu', $c ) ? 0 : ( preg_match( '/t[aầ]ng\s*(1|2)\b|ti[eệ]n [ií]ch|th[uư]ơng m[aạ]i|shophouse|kh[oố]i đ[eế]/iu', $c ) ? 2 : 1 );
	}
	asort( $floors );
	foreach ( array_slice( array_keys( $floors ), 0, 4 ) as $fid ) {
		if ( $ok( $fid ) ) {
			$out['plans'][] = array( (int) $fid, preg_match( '/^m[aặ]t b[aằ]ng/iu', $cap( $fid ) ) ? $cap( $fid ) : 'Mặt bằng ' . $cap( $fid ) );
		}
	}
	$mp = (int) hh_meta( 'hh_p_masterplan_img', $pid );
	if ( $ok( $mp ) ) {
		$out['plans'][] = array( $mp, 'Mặt bằng tổng thể ' . $out['title'] );
	}
	$out['plans'] = array_slice( $out['plans'], 0, 6 );
	return ( $out['building'] || $out['plans'] || $out['units'] ) ? $out : array();
}
