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
		$s .= ', tọa lạc tại ' . hh_lcfirst( $m( 'hh_p_address' ) );
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
			$m( 'hh_p_handover' ) ? 'bàn giao ' . hh_lcfirst( $m( 'hh_p_handover' ) ) : '',
		)
	);
	if ( $legal ) {
		$paras[] = hh_ucfirst( implode( '; ', $legal ) ) . '.';
	}
	$paras[] = 'Hoàng Hiệp cập nhật bảng giá, rổ hàng, lịch thanh toán và chính sách mới nhất của ' . $title . ', hỗ trợ đi xem dự án và tính toán phương án vay vốn phù hợp.';
	return $paras;
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

	$defs = array(
		'can-ho'    => array( 'Căn hộ', array( 'Loại căn', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), array_intersect( $terms, array( 'can-ho-so-huu-lau-dai', 'can-ho-dich-vu' ) ) || $has( array( 'căn hộ', 'condotel' ) ), array( 'căn hộ', 'cao tầng' ) ),
		'shop'      => array( 'Shop khối đế', hh_special_columns( 'shop' ), $has( array( 'shop khối đế', 'khối đế' ) ), array( 'shop', 'khối đế' ) ),
		'penthouse' => array( 'Penthouse', hh_special_columns( 'penthouse' ), $has( 'penthouse' ), array( 'penthouse' ) ),
		'duplex'    => array( 'Duplex', hh_special_columns( 'duplex' ), $has( 'duplex' ), array( 'duplex' ) ),
		'villa'     => array( 'Biệt thự / Villa', hh_special_columns( 'villa' ), in_array( 'biet-thu', $terms, true ) || $has( array( 'biệt thự', 'villa' ) ), array( 'biệt thự', 'villa' ) ),
		'nha-pho'   => array( 'Nhà phố – Shophouse', hh_special_columns( 'nha-pho' ), in_array( 'shophouse', $terms, true ) || $has( array( 'nhà phố', 'shophouse', 'liền kề' ) ), array( 'nhà phố', 'shophouse', 'liền kề' ) ),
		'dat-nen'   => array( 'Block đất nền', hh_special_columns( 'dat-nen' ), in_array( 'dat-nen', $terms, true ) || $has( 'đất nền' ), array( 'đất nền', 'lô đất' ) ),
	);

	$out = array();
	foreach ( $defs as $key => list( $label, $cols, $relevant, $words ) ) {
		$rows    = 'can-ho' === $key ? hh_table( 'hh_p_unit_types', 4, $post_id ) : hh_table( "hh_p_{$key}_table", count( $cols ), $post_id );
		$desc    = 'can-ho' === $key ? '' : hh_meta( "hh_p_{$key}_desc", $post_id );
		$gallery = 'can-ho' === $key ? array() : hh_ids( "hh_p_{$key}_gallery", $post_id );
		if ( ! $relevant && ! $rows && ! $desc && ! $gallery ) {
			continue;
		}
		$in_zones = array_values(
			array_filter(
				$zones,
				static function ( $z ) use ( $words ) {
					$t = mb_strtolower( $z[0] . ' ' . $z[1] );
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
		$faq[] = array( $title . ' nằm ở đâu?', 'Dự án tọa lạc tại ' . hh_lcfirst( $m( 'hh_p_address' ) ) . '.' );
	}
	if ( $m( 'hh_p_type' ) || $m( 'hh_p_units' ) ) {
		$faq[] = array( $title . ' có những loại sản phẩm nào?', hh_ucfirst( trim( implode( '; ', array_filter( array( $m( 'hh_p_type' ), $m( 'hh_p_units' ) ? 'quy mô ' . hh_lcfirst( $m( 'hh_p_units' ) ) : '' ) ) ) ) ) . '.' );
	}
	if ( $m( 'hh_p_ownership' ) || $m( 'hh_p_legal' ) ) {
		$faq[] = array( 'Pháp lý và hình thức sở hữu của ' . $title . ' thế nào?', hh_ucfirst( implode( '; ', array_filter( array( $m( 'hh_p_ownership' ), $m( 'hh_p_legal' ) ) ) ) ) . '.' );
	}
	if ( $m( 'hh_p_handover' ) || $m( 'hh_p_status' ) ) {
		$status = hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) );
		$faq[]  = array( 'Khi nào ' . $title . ' bàn giao?', hh_ucfirst( implode( '. ', array_filter( array( $status ? 'Tình trạng hiện tại: ' . mb_strtolower( $status ) : '', $m( 'hh_p_handover' ) ? 'Thời gian bàn giao: ' . hh_lcfirst( $m( 'hh_p_handover' ) ) : '' ) ) ) ) . '.' );
	}
	$faq[] = array( 'Giá bán ' . $title . ' hiện nay bao nhiêu?', ( $m( 'hh_p_price_from' ) ? hh_project_price( $post_id ) . '. ' : '' ) . 'Giá và chính sách thay đổi theo từng đợt mở bán, vị trí căn. Gọi hoặc nhắn Zalo ' . $phone . ' để nhận bảng giá, lịch thanh toán và rổ hàng mới nhất.' );
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
