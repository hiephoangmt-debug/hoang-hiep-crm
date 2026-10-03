<?php
/**
 * Nội dung đầy đủ cho trang dự án: mục nào chưa nhập thì website tự soạn từ thông tin đã có
 * (giới thiệu, liên kết vùng theo khu vực, loại sản phẩm, tiến độ, hỏi đáp, tin tức liên quan).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Thông tin tham khảo theo khu vực: mô tả, thời gian di chuyển, tiện ích xung quanh.
 * Dùng khi dự án chưa nhập "Liên kết vùng" / "Tiện ích ngoại khu".
 */
function hh_area_profiles() {
	return array(
		'hai-chau'     => array(
			'desc'  => 'Hải Châu là quận trung tâm hành chính, thương mại của Đà Nẵng, nằm bờ Tây sông Hàn.',
			'links' => array( array( '5 phút', 'Cầu Rồng, cầu sông Hàn' ), array( '5 phút', 'Chợ Hàn, chợ Cồn' ), array( '10 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '10 phút', 'Biển Mỹ Khê' ), array( '45 phút', 'Phố cổ Hội An' ) ),
			'near'  => array( 'Chợ Hàn, chợ Cồn', 'Công viên APEC, Cung thể thao Tiên Sơn', 'Bệnh viện Đà Nẵng', 'Trung tâm hành chính thành phố' ),
		),
		'son-tra'      => array(
			'desc'  => 'Sơn Trà nằm giữa sông Hàn và biển Mỹ Khê, tựa lưng bán đảo Sơn Trà – khu vực tập trung nhiều dự án căn hộ view sông, view biển.',
			'links' => array( array( '5 phút', 'Cầu Rồng, trung tâm thành phố' ), array( '5 phút', 'Biển Mỹ Khê' ), array( '15 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '20 phút', 'Bán đảo Sơn Trà, chùa Linh Ứng' ), array( '40 phút', 'Phố cổ Hội An' ) ),
			'near'  => array( 'Biển Mỹ Khê', 'Vincom Plaza Ngô Quyền', 'Chợ đêm Sơn Trà', 'Bán đảo Sơn Trà' ),
		),
		'ngu-hanh-son' => array(
			'desc'  => 'Ngũ Hành Sơn là dải ven biển phía Đông Nam Đà Nẵng, trục Võ Nguyên Giáp – Trường Sa với nhiều khu nghỉ dưỡng, kết nối thẳng về Hội An.',
			'links' => array( array( '5 phút', 'Biển Mỹ Khê, biển Non Nước' ), array( '10 phút', 'Danh thắng Ngũ Hành Sơn' ), array( '15 phút', 'Trung tâm thành phố' ), array( '15 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '25 phút', 'Phố cổ Hội An' ) ),
			'near'  => array( 'Biển Non Nước, biển Mỹ Khê', 'Danh thắng Ngũ Hành Sơn, làng đá Non Nước', 'Chuỗi resort ven biển Trường Sa', 'Đại học Kinh tế Đà Nẵng' ),
		),
		'thanh-khe'    => array(
			'desc'  => 'Thanh Khê nằm phía Tây trung tâm, sát sân bay quốc tế Đà Nẵng và biển Thanh Khê.',
			'links' => array( array( '5 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '5 phút', 'Biển Thanh Khê' ), array( '10 phút', 'Trung tâm thành phố' ), array( '45 phút', 'Phố cổ Hội An' ) ),
			'near'  => array( 'Biển Thanh Khê', 'Công viên 29/3', 'Sân bay quốc tế Đà Nẵng' ),
		),
		'lien-chieu'   => array(
			'desc'  => 'Liên Chiểu là cửa ngõ phía Tây Bắc Đà Nẵng, dọc vịnh Đà Nẵng và trục Nguyễn Tất Thành, gần các trường đại học và khu công nghiệp.',
			'links' => array( array( '5 phút', 'Biển Nguyễn Tất Thành, Xuân Thiều' ), array( '15 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '20 phút', 'Trung tâm thành phố' ), array( '20 phút', 'Đèo Hải Vân' ) ),
			'near'  => array( 'Đại học Bách khoa, Đại học Sư phạm Đà Nẵng', 'Biển Xuân Thiều, Nam Ô', 'Khu công nghiệp Hòa Khánh' ),
		),
		'cam-le'       => array(
			'desc'  => 'Cẩm Lệ nằm phía Tây Nam trung tâm, giáp Hải Châu và Hòa Vang, nhiều khu dân cư mới.',
			'links' => array( array( '10 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '15 phút', 'Trung tâm thành phố' ), array( '20 phút', 'Biển Mỹ Khê' ), array( '40 phút', 'Phố cổ Hội An' ) ),
			'near'  => array( 'Chợ Cẩm Lệ', 'Khu dân cư Hòa Xuân', 'Trục Cách Mạng Tháng 8' ),
		),
		'hoa-vang'     => array(
			'desc'  => 'Hòa Vang là vùng ven phía Tây Đà Nẵng, quỹ đất lớn, hướng về khu du lịch Bà Nà Hills.',
			'links' => array( array( '25 phút', 'Trung tâm thành phố' ), array( '25 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '30 phút', 'Bà Nà Hills' ) ),
			'near'  => array( 'Khu du lịch Bà Nà Hills', 'Quốc lộ 14B, cao tốc Đà Nẵng – Quảng Ngãi' ),
		),
		'dien-ban'     => array(
			'desc'  => 'Điện Bàn (Quảng Nam cũ, nay thuộc Đà Nẵng) giáp Ngũ Hành Sơn, dải ven biển Điện Ngọc – Điện Dương nối liền Đà Nẵng và Hội An.',
			'links' => array( array( '5 phút', 'Biển Hà My, biển Non Nước' ), array( '15 phút', 'Phố cổ Hội An' ), array( '20 phút', 'Trung tâm Đà Nẵng' ), array( '25 phút', 'Sân bay quốc tế Đà Nẵng' ) ),
			'near'  => array( 'Làng đại học Đà Nẵng', 'Biển Hà My', 'Chuỗi resort ven biển Đà Nẵng – Hội An' ),
		),
		'hoi-an'       => array(
			'desc'  => 'Hội An có phố cổ là di sản văn hóa thế giới UNESCO, cùng biển An Bàng, Cửa Đại – điểm đến du lịch hàng đầu miền Trung.',
			'links' => array( array( '10 phút', 'Phố cổ Hội An' ), array( '10 phút', 'Biển An Bàng, Cửa Đại' ), array( '45 phút', 'Trung tâm Đà Nẵng' ), array( '45 phút', 'Sân bay quốc tế Đà Nẵng' ) ),
			'near'  => array( 'Phố cổ Hội An (di sản UNESCO)', 'Biển An Bàng, Cửa Đại', 'Rừng dừa Bảy Mẫu' ),
		),
		'duy-xuyen'    => array(
			'desc'  => 'Duy Xuyên (Quảng Nam cũ, nay thuộc Đà Nẵng) có dải biển Nam Hội An hoang sơ, nơi tập trung các quần thể nghỉ dưỡng lớn.',
			'links' => array( array( '15 – 20 phút', 'Phố cổ Hội An' ), array( '45 – 50 phút', 'Sân bay quốc tế Đà Nẵng' ), array( '45 phút', 'Thánh địa Mỹ Sơn' ) ),
			'near'  => array( 'Biển Nam Hội An', 'Thánh địa Mỹ Sơn (di sản UNESCO)', 'Phố cổ Hội An' ),
		),
	);
}

function hh_project_area( $post_id = null ) {
	$terms = get_the_terms( $post_id ?: get_the_ID(), 'khu-vuc' );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
}

function hh_project_area_profile( $post_id = null ) {
	$area = hh_project_area( $post_id );
	$all  = hh_area_profiles();
	return $area && isset( $all[ $area->slug ] ) ? $all[ $area->slug ] + array( 'name' => $area->name ) : null;
}

/** Đoạn giới thiệu tự soạn từ thông tin dự án (dùng khi chưa viết nội dung). */
function hh_project_intro( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$m       = static fn( $k ) => trim( (string) hh_meta( $k, $post_id ) );
	$title   = get_the_title( $post_id );
	$paras   = array();

	$types = hh_project_types_label( $post_id );
	$s     = $title . ' là dự án ' . ( $m( 'hh_p_type' ) ? hh_lcfirst( $m( 'hh_p_type' ) ) : mb_strtolower( $types ?: 'bất động sản' ) );
	if ( $m( 'hh_p_developer' ) ) {
		$s .= ' do ' . $m( 'hh_p_developer' ) . ' phát triển';
	}
	if ( $m( 'hh_p_address' ) ) {
		$s .= ', tọa lạc tại ' . hh_lc_address( $m( 'hh_p_address' ) );
	}
	$paras[] = $s . '.';

	$scale = array_filter(
		array(
			$m( 'hh_p_scale' ) ? 'quy mô ' . $m( 'hh_p_scale' ) : '',
			$m( 'hh_p_blocks' ) ? hh_lcfirst( $m( 'hh_p_blocks' ) ) : '',
			$m( 'hh_p_floors' ) ? 'cao ' . $m( 'hh_p_floors' ) : '',
			$m( 'hh_p_units' ) ? 'cung cấp ' . hh_lcfirst( $m( 'hh_p_units' ) ) : '',
			$m( 'hh_p_unit_area' ) ? 'diện tích ' . $m( 'hh_p_unit_area' ) : '',
		)
	);
	if ( $scale ) {
		$paras[] = 'Dự án có ' . implode( ', ', $scale ) . '.';
	}

	$status = hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) );
	$legal  = array_filter(
		array(
			$m( 'hh_p_ownership' ) ? 'Hình thức sở hữu: ' . hh_lcfirst( $m( 'hh_p_ownership' ) ) : '',
			$m( 'hh_p_legal' ) ? 'pháp lý: ' . hh_lcfirst( $m( 'hh_p_legal' ) ) : '',
			$status ? 'tình trạng hiện tại: ' . mb_strtolower( $status ) : '',
			$m( 'hh_p_handover' ) && 0 !== mb_stripos( $m( 'hh_p_handover' ), 'đã' ) ? 'bàn giao ' . hh_lcfirst( $m( 'hh_p_handover' ) ) : '',
		)
	);
	if ( $legal ) {
		$paras[] = hh_ucfirst( implode( '; ', $legal ) ) . '.';
	}
	$paras[] = hh_project_is_resale( $post_id )
		? 'Hoàng Hiệp cập nhật các căn chuyển nhượng, cho thuê và giá thị trường mới nhất của ' . $title . ', hỗ trợ kiểm tra pháp lý, thủ tục sang tên và nhận ký gửi bán, cho thuê.'
		: 'Hoàng Hiệp cập nhật bảng giá, rổ hàng, lịch thanh toán và chính sách mới nhất của ' . $title . ', hỗ trợ đi xem dự án và tính toán phương án vay vốn phù hợp.';
	return $paras;
}

/** Viết thường chữ đầu địa chỉ chỉ khi bắt đầu bằng danh từ chung (Đường, Khu, Xã…), giữ nguyên địa danh. */
function hh_lc_address( $address ) {
	$first = mb_strtolower( (string) strtok( $address, ' ,' ) );
	return in_array( $first, array( 'đường', 'khu', 'xã', 'phường', 'lô', 'ven', 'mặt', 'thôn', 'ngã', 'giao', 'số', 'trục', 'tuyến', 'quận', 'huyện' ), true ) ? hh_lcfirst( $address ) : $address;
}

function hh_ucfirst( $text ) {
	return mb_strtoupper( mb_substr( $text, 0, 1 ) ) . mb_substr( $text, 1 );
}

/** Liên kết vùng: [rows, is_reference]. */
function hh_project_connections( $post_id = null ) {
	$rows    = hh_table( 'hh_p_connections', 2, $post_id );
	$profile = hh_project_area_profile( $post_id );
	if ( count( $rows ) >= 4 || ! $profile ) {
		return array( $rows, false );
	}
	// Ít mốc: bổ sung mốc tham khảo theo khu vực, bỏ địa điểm đã có.
	$added = false;
	$have  = mb_strtolower( implode( ' ', wp_list_pluck( $rows, 1 ) ) );
	foreach ( $profile['links'] as $link ) {
		$key = implode( ' ', array_slice( preg_split( '/[\s,]+/u', mb_strtolower( $link[1] ) ), 0, 2 ) );
		if ( false === mb_strpos( $have, $key ) ) {
			$rows[] = $link;
			$added  = true;
		}
	}
	return array( $rows, $added );
}

/** Tiện ích ngoại khu: [items, is_reference]. */
function hh_project_nearby( $post_id = null ) {
	$items = hh_lines( 'hh_p_amenities_out', $post_id );
	if ( $items ) {
		return array( $items, false );
	}
	$profile = hh_project_area_profile( $post_id );
	return array( $profile ? $profile['near'] : array(), true );
}

/**
 * Các loại sản phẩm của dự án: căn hộ, shop khối đế, penthouse, duplex, biệt thự, nhà phố, đất nền.
 * Hiện loại nào dự án có (theo Loại dự án / Loại hình / Phân khu) hoặc đã nhập dữ liệu.
 */
function hh_project_products( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$terms   = wp_list_pluck( get_the_terms( $post_id, 'loai-du-an' ) ?: array(), 'slug' );
	$zones   = hh_table( 'hh_p_zones', 4, $post_id );
	$text    = mb_strtolower( hh_meta( 'hh_p_type', $post_id ) . ' ' . implode( ' ', wp_list_pluck( $zones, 1 ) ) );
	$has     = static fn( $words ) => (bool) array_filter( (array) $words, static fn( $w ) => false !== mb_strpos( $text, $w ) );
	// Thấp tầng: bỏ các cụm của cao tầng ("shophouse khối đế", "Sky Villa") để không hiện nhầm mục nhà phố / biệt thự.
	$podium  = static fn( $z ) => false !== mb_strpos( mb_strtolower( implode( ' ', $z ) ), 'khối đế' );
	$low     = mb_strtolower( hh_meta( 'hh_p_type', $post_id ) . ' ' . implode( ' ', wp_list_pluck( array_filter( $zones, static fn( $z ) => ! $podium( $z ) ), 1 ) ) );
	$low     = str_replace( array( 'shophouse khối đế', 'shop khối đế', 'sky villa' ), ' ', $low );
	$has_low = static fn( $words ) => (bool) array_filter( (array) $words, static fn( $w ) => false !== mb_strpos( $low, $w ) );

	$defs = array(
		'can-ho'    => array( 'Căn hộ', array( 'Loại căn', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), array_intersect( $terms, array( 'can-ho-so-huu-lau-dai', 'can-ho-dich-vu' ) ) || $has( array( 'căn hộ', 'condotel' ) ), array( 'căn hộ', 'cao tầng' ) ),
		'shop'      => array( 'Shop khối đế', hh_special_columns( 'shop' ), $has( array( 'shop khối đế', 'khối đế' ) ), array( 'shop', 'khối đế' ) ),
		'penthouse' => array( 'Penthouse', hh_special_columns( 'penthouse' ), $has( 'penthouse' ), array( 'penthouse' ) ),
		'duplex'    => array( 'Duplex', hh_special_columns( 'duplex' ), $has( 'duplex' ), array( 'duplex' ) ),
		'villa'     => array( 'Biệt thự / Villa', hh_special_columns( 'villa' ), in_array( 'biet-thu', $terms, true ) || $has_low( array( 'biệt thự', 'villa' ) ), array( 'biệt thự', 'villa' ) ),
		'nha-pho'   => array( 'Nhà phố – Shophouse', hh_special_columns( 'nha-pho' ), in_array( 'shophouse', $terms, true ) || $has_low( array( 'nhà phố', 'shophouse', 'liền kề' ) ), array( 'nhà phố', 'shophouse', 'liền kề' ) ),
		'dat-nen'   => array( 'Block đất nền', hh_special_columns( 'dat-nen' ), in_array( 'dat-nen', $terms, true ) || $has( 'đất nền' ), array( 'đất nền', 'lô đất' ) ),
	);

	$out = array();
	foreach ( $defs as $key => list( $label, $cols, $relevant, $words ) ) {
		$rows    = 'can-ho' === $key ? hh_table( 'hh_p_unit_types', 4, $post_id ) : hh_table( "hh_p_{$key}_table", count( $cols ), $post_id );
		$desc    = 'can-ho' === $key ? '' : hh_meta( "hh_p_{$key}_desc", $post_id );
		$gallery = 'can-ho' === $key ? array() : hh_ids( "hh_p_{$key}_gallery", $post_id );
		// Shop khối đế, penthouse, duplex: chỉ hiện khi dự án có thông tin thật (mô tả, bảng căn hoặc ảnh).
		if ( isset( HH_SPECIAL_PAGES[ $key ] ) ) {
			$relevant = false;
		}
		if ( ! $relevant && ! $rows && ! $desc && ! $gallery ) {
			continue;
		}
		$in_zones = array_values(
			array_filter(
				$zones,
				static function ( $z ) use ( $words ) {
					$t = mb_strtolower( $z[0] . ' ' . $z[1] );
					if ( array_intersect( $words, array( 'biệt thự', 'villa', 'nhà phố', 'shophouse', 'liền kề' ) ) ) {
						if ( false !== mb_strpos( mb_strtolower( implode( ' ', $z ) ), 'khối đế' ) ) {
							return false;
						}
						$t = str_replace( array( 'shophouse khối đế', 'shop khối đế', 'sky villa' ), ' ', $t );
					}
					foreach ( $words as $w ) {
						if ( false !== mb_strpos( $t, $w ) ) {
							return true;
						}
					}
					return false;
				}
			)
		);
		$out[ $key ] = compact( 'label', 'cols', 'rows', 'desc', 'gallery', 'in_zones' );
	}
	return $out;
}

/** Tiến độ: [rows, is_auto]. Chưa nhập thì dựng mốc từ khởi công / tình trạng / bàn giao. */
function hh_project_timeline( $post_id = null ) {
	$rows = hh_table( 'hh_p_progress', 2, $post_id );
	if ( $rows ) {
		return array( $rows, false );
	}
	$status = hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status', $post_id ) );
	$rows   = array_filter(
		array(
			hh_meta( 'hh_p_start', $post_id ) ? array( hh_meta( 'hh_p_start', $post_id ), 'Khởi công dự án' ) : null,
			$status ? array( 'Hiện tại', $status ) : null,
			hh_meta( 'hh_p_handover', $post_id ) ? array( 'Bàn giao', hh_meta( 'hh_p_handover', $post_id ) ) : null,
		)
	);
	return array( array_values( $rows ), true );
}

/** Hỏi đáp: dùng câu đã nhập, chưa có thì tự tạo từ thông tin dự án. */
function hh_project_faq( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$rows    = hh_table( 'hh_p_faq', 2, $post_id );
	if ( $rows ) {
		return $rows;
	}
	$m     = static fn( $k ) => trim( (string) hh_meta( $k, $post_id ) );
	$title = get_the_title( $post_id );
	$phone = function_exists( 'hoanghiep_opt' ) ? hoanghiep_opt( 'hh_phone' ) : '';
	$faq   = array();
	if ( $m( 'hh_p_developer' ) ) {
		$faq[] = array( 'Chủ đầu tư dự án ' . $title . ' là ai?', 'Dự án do ' . $m( 'hh_p_developer' ) . ' làm chủ đầu tư.' );
	}
	if ( $m( 'hh_p_address' ) ) {
		$faq[] = array( $title . ' nằm ở đâu?', 'Dự án tọa lạc tại ' . hh_lc_address( $m( 'hh_p_address' ) ) . '.' );
	}
	if ( $m( 'hh_p_type' ) || $m( 'hh_p_units' ) ) {
		$faq[] = array( $title . ' có những loại sản phẩm nào?', hh_ucfirst( trim( implode( '; ', array_filter( array( $m( 'hh_p_type' ), $m( 'hh_p_units' ) ? 'quy mô ' . hh_lcfirst( $m( 'hh_p_units' ) ) : '' ) ) ) ) ) . '.' );
	}
	if ( $m( 'hh_p_ownership' ) || $m( 'hh_p_legal' ) ) {
		$faq[] = array( 'Pháp lý và hình thức sở hữu của ' . $title . ' thế nào?', hh_ucfirst( implode( '; ', array_filter( array( hh_lcfirst( $m( 'hh_p_ownership' ) ), hh_lcfirst( $m( 'hh_p_legal' ) ) ) ) ) ) . '.' );
	}
	if ( $m( 'hh_p_handover' ) || $m( 'hh_p_status' ) ) {
		$status = hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) );
		$faq[]  = array( 'Khi nào ' . $title . ' bàn giao?', hh_ucfirst( implode( '. ', array_filter( array( $status ? 'Tình trạng hiện tại: ' . mb_strtolower( $status ) : '', $m( 'hh_p_handover' ) && 0 !== mb_stripos( $m( 'hh_p_handover' ), 'đã' ) ? 'Thời gian bàn giao: ' . hh_lcfirst( $m( 'hh_p_handover' ) ) : '' ) ) ) ) . '.' );
	}
	if ( hh_project_is_resale( $post_id ) ) {
		$market = hh_project_market( $post_id );
		$range  = $market['ban']['range'] ? 'Các căn đang chuyển nhượng có giá ' . $market['ban']['range'] . '. ' : ( $m( 'hh_p_resale_price' ) ? 'Giá chuyển nhượng tham khảo: ' . $m( 'hh_p_resale_price' ) . '. ' : '' );
		$faq[]  = array( 'Giá chuyển nhượng ' . $title . ' hiện nay bao nhiêu?', $range . 'Giá tùy vị trí, tầng, view và nội thất từng căn. Gọi hoặc nhắn Zalo ' . $phone . ' để nhận danh sách căn đang bán.' );
		$faq[]  = array( 'Giá thuê tại ' . $title . ' bao nhiêu?', ( $market['thue']['range'] ? 'Các căn đang cho thuê có giá ' . $market['thue']['range'] . '. ' : ( $m( 'hh_p_rent_price' ) ? 'Giá thuê tham khảo: ' . $m( 'hh_p_rent_price' ) . '. ' : '' ) ) . 'Liên hệ ' . $phone . ' để nhận danh sách căn trống và lịch xem nhà.' );
	} else {
		$faq[] = array( 'Giá bán ' . $title . ' hiện nay bao nhiêu?', ( $m( 'hh_p_price_from' ) ? hh_project_price( $post_id ) . '. ' : '' ) . 'Giá và chính sách thay đổi theo từng đợt mở bán, vị trí căn. Gọi hoặc nhắn Zalo ' . $phone . ' để nhận bảng giá, lịch thanh toán và rổ hàng mới nhất.' );
	}
	$faq[] = array( 'Mua ' . $title . ' có được hỗ trợ vay ngân hàng không?', $m( 'hh_p_loan' ) ? $m( 'hh_p_loan' ) : 'Trang dự án có bảng tính vay và dòng tiền để bạn tự ước tính số tiền trả hằng tháng. Hiệp hỗ trợ kết nối ngân hàng, hồ sơ vay khi bạn chọn được căn phù hợp.' );
	return $faq;
}

/** Tin tức liên quan dự án: bài gắn "Dự án liên quan" hoặc có tên dự án trong tiêu đề. */
function hh_project_news( $post_id = null, $limit = 6 ) {
	$post_id  = $post_id ?: get_the_ID();
	$projects = array( $post_id );
	$parent   = (int) hh_meta( 'hh_p_parent', $post_id );
	if ( $parent ) {
		$projects[] = $parent;
	}
	$projects = array_merge( $projects, get_posts( array( 'post_type' => 'du-an', 'fields' => 'ids', 'numberposts' => 20, 'meta_key' => 'hh_p_parent', 'meta_value' => $post_id ) ) );

	$ids = get_posts(
		array(
			'post_type'   => 'post',
			'fields'      => 'ids',
			'numberposts' => $limit,
			'meta_query'  => array( array( 'key' => 'hh_post_project', 'value' => array_map( 'strval', $projects ), 'compare' => 'IN' ) ),
		)
	);
	if ( count( $ids ) < $limit ) {
		$ids = array_merge(
			$ids,
			get_posts(
				array(
					'post_type'      => 'post',
					'fields'         => 'ids',
					'numberposts'    => $limit,
					's'              => get_the_title( $post_id ),
					'sentence'       => true,
					'search_columns' => array( 'post_title' ),
					'post__not_in'   => $ids ?: array( 0 ),
				)
			)
		);
	}
	if ( ! $ids ) {
		return null;
	}
	return new WP_Query(
		array(
			'post_type'      => 'post',
			'post__in'       => array_slice( array_unique( $ids ), 0, $limit ),
			'orderby'        => 'date',
			'posts_per_page' => $limit,
			'no_found_rows'  => true,
		)
	);
}

/* -------------------------------------------------------------------------
 * Thị trường thứ cấp: mua bán, chuyển nhượng, cho thuê trong dự án
 * ---------------------------------------------------------------------- */

/** Dự án đã bán hết hoặc đã bàn giao: ưu tiên hiện chuyển nhượng & cho thuê. */
function hh_project_is_resale( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	return '1' === hh_meta( 'hh_p_sold_out', $post_id ) || 'da-ban-giao' === hh_meta( 'hh_p_status', $post_id );
}

/** Dự án và các dự án thành phần / phân khu của nó. */
function hh_project_family( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$kids    = get_posts( array( 'post_type' => 'du-an', 'fields' => 'ids', 'numberposts' => 50, 'meta_key' => 'hh_p_parent', 'meta_value' => $post_id ) );
	return array_map( 'strval', array_merge( array( $post_id ), $kids ) );
}

/** Tin đang đăng (chưa giao dịch) thuộc dự án, theo hình thức ban / thue. */
function hh_project_listing_ids( $post_id, $deal ) {
	static $cache = array();
	$key = $post_id . $deal;
	if ( ! isset( $cache[ $key ] ) ) {
		$cache[ $key ] = get_posts(
			array(
				'post_type'   => 'bat-dong-san',
				'fields'      => 'ids',
				'numberposts' => 200,
				'meta_query'  => array(
					array( 'key' => 'hh_project', 'value' => hh_project_family( $post_id ), 'compare' => 'IN' ),
					array( 'key' => 'hh_deal', 'value' => $deal ),
					array( 'key' => 'hh_status', 'value' => 'da-giao-dich', 'compare' => '!=' ),
				),
			)
		);
	}
	return $cache[ $key ];
}

/** Tóm tắt thị trường: số tin, khoảng giá, đơn giá trung bình/m² (tin bán). */
function hh_project_market( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$out     = array();
	foreach ( array( 'ban', 'thue' ) as $deal ) {
		$ids    = hh_project_listing_ids( $post_id, $deal );
		$prices = array();
		$per_m2 = array();
		foreach ( $ids as $id ) {
			$price = (float) hh_meta( 'hh_price', $id );
			$area  = (float) hh_meta( 'hh_area', $id );
			if ( $price > 0 ) {
				$prices[] = $price;
				if ( $area > 0 && 'ban' === $deal ) {
					$per_m2[] = $price / $area;
				}
			}
		}
		$out[ $deal ] = array(
			'count' => count( $ids ),
			'range' => $prices ? hh_price_range( min( $prices ), max( $prices ), 'thue' === $deal ) : '',
			'm2'    => $per_m2 ? number_format( array_sum( $per_m2 ) / count( $per_m2 ), 1, ',', '.' ) . ' triệu/m²' : '',
		);
	}
	return $out;
}

/** Danh sách tin của dự án: tin HOT trước, rồi mới nhất. */
function hh_project_listings( $post_id, $deal, $limit = 6 ) {
	$ids = hh_project_listing_ids( $post_id, $deal );
	if ( ! $ids ) {
		return null;
	}
	usort(
		$ids,
		static fn( $a, $b ) => ( hh_is_hot( $b ) <=> hh_is_hot( $a ) ) ?: ( get_post_time( 'U', true, $b ) <=> get_post_time( 'U', true, $a ) )
	);
	return new WP_Query(
		array(
			'post_type'      => 'bat-dong-san',
			'post__in'       => array_slice( $ids, 0, $limit ),
			'orderby'        => 'post__in',
			'posts_per_page' => $limit,
			'no_found_rows'  => true,
		)
	);
}

/** Link tất cả tin bán / cho thuê của dự án. */
function hh_project_listings_url( $post_id, $deal ) {
	return add_query_arg( 'duan', get_post_field( 'post_name', $post_id ), hh_deal_url( $deal ) );
}

/* -------------------------------------------------------------------------
 * Trang tổng hợp /san-pham/shop-khoi-de/, /san-pham/penthouse/, /san-pham/duplex/
 * ---------------------------------------------------------------------- */

/** Slug trang tổng hợp => [khóa sản phẩm, tên]. */
const HH_SPECIAL_PAGES = array(
	'shop'      => array( 'shop-khoi-de', 'Shop khối đế' ),
	'penthouse' => array( 'penthouse', 'Penthouse' ),
	'duplex'    => array( 'duplex', 'Duplex' ),
);

/** Khóa sản phẩm từ slug trang (shop-khoi-de => shop). */
function hh_special_key( $slug ) {
	foreach ( HH_SPECIAL_PAGES as $key => list( $s ) ) {
		if ( $s === $slug ) {
			return $key;
		}
	}
	return '';
}

function hh_special_url( $key ) {
	return home_url( '/san-pham/' . HH_SPECIAL_PAGES[ $key ][0] . '/' );
}

/**
 * Dự án sắp mở bán, đang mở bán, đang bàn giao (chưa bán hết) có thông tin loại sản phẩm $key.
 * Trả về [post_id => dữ liệu sản phẩm], dự án HOT lên trước.
 */
function hh_special_projects( $key ) {
	$ids = get_posts(
		array(
			'post_type'      => 'du-an',
			'posts_per_page' => 200,
			'fields'         => 'ids',
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array( array( 'key' => 'hh_p_status', 'value' => array( 'sap-mo-ban', 'dang-mo-ban', 'dang-ban-giao' ), 'compare' => 'IN' ) ),
		)
	);
	$out = array();
	foreach ( $ids as $id ) {
		if ( hh_meta( 'hh_p_sold_out', $id ) ) {
			continue;
		}
		$products = hh_project_products( $id );
		if ( isset( $products[ $key ] ) ) {
			$out[ $id ] = $products[ $key ];
		}
	}
	uksort( $out, static fn( $a, $b ) => (int) (bool) hh_meta( 'hh_p_featured', $b ) - (int) (bool) hh_meta( 'hh_p_featured', $a ) );
	return $out;
}

function hh_special_title( $key ) {
	return HH_SPECIAL_PAGES[ $key ][1] . ' Đà Nẵng – dự án đang mở bán';
}

/** Đoạn mở đầu và hỏi đáp cho trang tổng hợp. */
function hh_special_intro( $key ) {
	$phone = function_exists( 'hoanghiep_opt' ) ? hoanghiep_opt( 'hh_phone' ) : '0904 567 009';
	$data  = array(
		'shop'      => array(
			'lead' => 'Shop khối đế (shophouse chân đế) tại các dự án căn hộ đang mở bán ở Đà Nẵng: số lượng, diện tích, giá tham khảo và vị trí từng dự án.',
			'faq'  => array(
				array( 'Shop khối đế là gì?', 'Là các căn thương mại ở tầng 1 – 2 (đôi khi đến tầng 3) dưới chân tòa căn hộ, mặt tiền đường hoặc nội khu, dùng để kinh doanh hoặc cho thuê. Phần lớn dự án ở Đà Nẵng bán shop khối đế sở hữu lâu dài.' ),
				array( 'Shop khối đế khác shophouse thấp tầng thế nào?', 'Shop khối đế nằm trong tòa căn hộ, giá thấp hơn, khách hàng sẵn có là cư dân tòa nhà; shophouse thấp tầng là nhà phố riêng biệt có đất, nhiều tầng, giá cao hơn.' ),
				array( 'Nên chọn shop khối đế thế nào?', 'Ưu tiên căn mặt tiền đường lớn, góc hai mặt tiền, trần cao, dự án đông cư dân và đã có kế hoạch bàn giao rõ ràng. Hỏi kỹ phí quản lý, giờ hoạt động và quy định ngành nghề kinh doanh.' ),
				array( 'Liên hệ nhận rổ hàng shop khối đế ở đâu?', 'Gọi hoặc Zalo Hoàng Hiệp ' . $phone . ' để nhận danh sách căn, bảng giá và chính sách mới nhất của từng dự án.' ),
			),
		),
		'penthouse' => array(
			'lead' => 'Căn penthouse tại các dự án đang mở bán ở Đà Nẵng: số căn, diện tích, giá tham khảo, view sông Hàn, biển và vị trí từng dự án.',
			'faq'  => array(
				array( 'Penthouse là gì?', 'Là căn hộ trên các tầng cao nhất của tòa nhà, diện tích lớn, trần cao, nhiều căn có sân vườn hoặc hồ bơi riêng và tầm nhìn toàn cảnh.' ),
				array( 'Penthouse ở Đà Nẵng có sở hữu lâu dài không?', 'Tùy dự án. Penthouse trong dự án căn hộ ở có sổ hồng sở hữu lâu dài; penthouse trong dự án căn hộ dịch vụ, condotel thường sở hữu có thời hạn 50 năm. Xem mục pháp lý trên trang từng dự án.' ),
				array( 'Số lượng penthouse mỗi dự án có nhiều không?', 'Rất ít – thường chỉ vài căn đến vài chục căn mỗi dự án, nên giá và chính sách thường được chủ đầu tư công bố riêng.' ),
				array( 'Liên hệ nhận danh sách penthouse ở đâu?', 'Gọi hoặc Zalo Hoàng Hiệp ' . $phone . ' để nhận danh sách căn penthouse còn trống và bảng giá mới nhất.' ),
			),
		),
		'duplex'    => array(
			'lead' => 'Căn duplex (căn hộ thông tầng) tại các dự án đang mở bán ở Đà Nẵng: diện tích, số phòng ngủ, giá tham khảo và vị trí từng dự án.',
			'faq'  => array(
				array( 'Căn duplex là gì?', 'Là căn hộ có 2 tầng nối với nhau bằng cầu thang riêng bên trong căn, phòng khách thường có trần cao gấp đôi, phù hợp gia đình nhiều thế hệ.' ),
				array( 'Duplex khác penthouse thế nào?', 'Duplex có thể nằm ở bất kỳ tầng nào, điểm đặc trưng là 2 tầng thông nhau; penthouse nằm trên tầng cao nhất. Một số dự án có căn penthouse thiết kế dạng duplex.' ),
				array( 'Liên hệ nhận danh sách căn duplex ở đâu?', 'Gọi hoặc Zalo Hoàng Hiệp ' . $phone . ' để nhận danh sách căn duplex còn trống và bảng giá mới nhất.' ),
			),
		),
	);
	return $data[ $key ];
}
