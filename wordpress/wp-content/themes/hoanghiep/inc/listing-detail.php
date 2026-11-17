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
