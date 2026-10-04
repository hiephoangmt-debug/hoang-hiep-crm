<?php
/**
 * Tin mua bán chuyển nhượng / cho thuê theo dự án và loại căn – tổng hợp mặt bằng giá từ tin rao công khai (10/2026,
 * xem nguồn trong data-gia-thi-truong.php). Mỗi tin là một KHOẢNG GIÁ tham khảo, không phải một căn cụ thể; nội dung
 * tin ghi rõ điều này và mời khách liên hệ nhận danh sách căn đang giao dịch thật.
 * Nhập cùng nút Dự án → Nhập dữ liệu Đà Nẵng; chạy lại không tạo trùng, không ghi đè tin đã sửa tay.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mỗi dòng: deal, dự án (slug), tên ngắn, loại căn, số PN, giá thấp, giá cao (triệu; 0 = không có), "từ"?, diện tích (chữ), loại BĐS.
 */
function hh_listing_dataset() {
	$rows = array(
		// ---------------------------------------------------------------- Chuyển nhượng.
		array( 'ban', 'sun-symphony-residence', 'Sun Symphony Residence', 'Studio', 0, 3200, 3600, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-symphony-residence', 'Sun Symphony Residence', '2 phòng ngủ', 2, 6000, 8000, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-symphony-residence', 'Sun Symphony Residence', '3 phòng ngủ', 3, 8200, 0, true, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-cosmo-residence', 'Sun Cosmo Residence', 'Studio', 0, 1800, 2500, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-cosmo-residence', 'Sun Cosmo Residence', '1 phòng ngủ', 1, 2800, 5300, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-cosmo-residence', 'Sun Cosmo Residence', '2 phòng ngủ', 2, 3600, 6800, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-cosmo-residence', 'Sun Cosmo Residence', '3 phòng ngủ', 3, 6000, 9500, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-ponte-residence', 'Sun Ponte Residence', 'Studio / 1 phòng ngủ', 1, 2960, 4490, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-ponte-residence', 'Sun Ponte Residence', '2 phòng ngủ', 2, 4300, 6900, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'sun-ponte-residence', 'Sun Ponte Residence', '3 phòng ngủ', 3, 5600, 10000, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'peninsula-da-nang', 'Peninsula Đà Nẵng', '1 phòng ngủ', 1, 2200, 2700, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'peninsula-da-nang', 'Peninsula Đà Nẵng', '2 phòng ngủ', 2, 3000, 5000, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'hiyori-garden-tower', 'Hiyori Garden Tower', '2 phòng ngủ', 2, 5000, 6700, false, '63 – 71 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'the-ori-garden', 'The Ori Garden', '1 phòng ngủ', 1, 1310, 1940, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'the-ori-garden', 'The Ori Garden', '2 phòng ngủ', 2, 1960, 2560, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'times-square-da-nang', 'Times Square Đà Nẵng', 'Studio / 1 phòng ngủ', 1, 6500, 8500, false, '45 – 50 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'times-square-da-nang', 'Times Square Đà Nẵng', '2 phòng ngủ', 2, 12000, 14000, false, '65 – 85 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'capital-square-da-nang', 'Capital Square Đà Nẵng', '1 phòng ngủ', 1, 3300, 4500, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'capital-square-da-nang', 'Capital Square Đà Nẵng', '2 phòng ngủ', 2, 4700, 7800, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'newtown-diamond-da-nang', 'Newtown Diamond', '1 phòng ngủ', 1, 2800, 3900, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'newtown-diamond-da-nang', 'Newtown Diamond', '2 phòng ngủ', 2, 4500, 7500, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'fpt-plaza-2', 'FPT Plaza 2', '2 phòng ngủ', 2, 2250, 3400, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'fpt-plaza-3', 'FPT Plaza 3', '1 phòng ngủ', 1, 1600, 2500, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'fpt-plaza-3', 'FPT Plaza 3', '2 phòng ngủ', 2, 2600, 4000, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'the-filmore-da-nang', 'The Filmore Đà Nẵng', '1 phòng ngủ', 1, 4500, 7600, false, '48 – 50 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'the-filmore-da-nang', 'The Filmore Đà Nẵng', '2 phòng ngủ', 2, 8300, 9300, false, '71 – 81 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'vista-residence-da-nang', 'Vista Residence', '2 phòng ngủ', 2, 4300, 5100, false, '76 m²', 'can-ho-chung-cu' ),
		array( 'ban', 'wyndham-soleil-da-nang', 'Wyndham Soleil Đà Nẵng', 'Studio', 0, 2300, 2600, false, '', 'can-ho-dich-vu' ),
		array( 'ban', 'masteri-da-nang', 'Masteri Đà Nẵng', '2 phòng ngủ (chuyển nhượng HĐMB)', 2, 4900, 0, false, '', 'can-ho-chung-cu' ),
		array( 'ban', 'spana-tower', 'Spana Tower', 'căn hộ (sang nhượng HĐMB)', 0, 1900, 4140, false, '', 'can-ho-chung-cu' ),
		// ---------------------------------------------------------------- Cho thuê (triệu/tháng).
		array( 'thue', 'sun-symphony-residence', 'Sun Symphony Residence', '1 – 2 phòng ngủ', 2, 12, 25, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-symphony-residence', 'Sun Symphony Residence', '3 phòng ngủ', 3, 10, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-cosmo-residence', 'Sun Cosmo Residence', 'Studio', 0, 16, 0, true, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-cosmo-residence', 'Sun Cosmo Residence', '1 phòng ngủ', 1, 23, 24, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-cosmo-residence', 'Sun Cosmo Residence', '2 phòng ngủ', 2, 30, 35, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-cosmo-residence', 'Sun Cosmo Residence', '3 phòng ngủ', 3, 30, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-ponte-residence', 'Sun Ponte Residence', 'Studio', 0, 13, 20, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-ponte-residence', 'Sun Ponte Residence', '1 phòng ngủ', 1, 20, 30, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'sun-ponte-residence', 'Sun Ponte Residence', '2 phòng ngủ', 2, 32, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'peninsula-da-nang', 'Peninsula Đà Nẵng', '2 phòng ngủ', 2, 23, 30, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'hiyori-garden-tower', 'Hiyori Garden Tower', '2 phòng ngủ', 2, 15, 25, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'the-ori-garden', 'The Ori Garden', '1 phòng ngủ', 1, 3, 4.5, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'the-ori-garden', 'The Ori Garden', '2 phòng ngủ', 2, 4, 6, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'the-ori-garden', 'The Ori Garden', '3 phòng ngủ', 3, 5, 8, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'times-square-da-nang', 'Times Square Đà Nẵng', 'căn hộ dài hạn', 0, 25, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'capital-square-da-nang', 'Capital Square Đà Nẵng', '1 phòng ngủ full nội thất', 1, 18, 25, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'fpt-plaza-1', 'FPT Plaza', '1 phòng ngủ', 1, 6.5, 0, true, '', 'can-ho-chung-cu' ),
		array( 'thue', 'fpt-plaza-1', 'FPT Plaza', '2 phòng ngủ', 2, 10, 13, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'fpt-plaza-1', 'FPT Plaza', '3 phòng ngủ', 3, 15.5, 17, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'the-filmore-da-nang', 'The Filmore Đà Nẵng', '1 phòng ngủ', 1, 22, 27, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'the-filmore-da-nang', 'The Filmore Đà Nẵng', '2 phòng ngủ', 2, 35, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'vista-residence-da-nang', 'Vista Residence', '2 phòng ngủ', 2, 20, 32, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'vista-residence-da-nang', 'Vista Residence', '3 phòng ngủ', 3, 30, 40, false, '', 'can-ho-chung-cu' ),
		array( 'thue', 'wyndham-soleil-da-nang', 'Wyndham Soleil Đà Nẵng', 'Studio', 0, 20, 0, false, '', 'can-ho-dich-vu' ),
	);
	$out = array();
	foreach ( $rows as list( $deal, $project, $name, $type, $beds, $min, $max, $from, $area, $kind ) ) {
		$out[] = compact( 'deal', 'project', 'name', 'type', 'beds', 'min', 'max', 'from', 'area', 'kind' );
	}
	return apply_filters( 'hh_listing_dataset', $out );
}

/** "3,6 – 6,8 tỷ" / "từ 16 triệu/tháng" cho phần chữ. */
function hh_listing_range_text( $l ) {
	$rent = 'thue' === $l['deal'];
	$fmt  = static fn( $v ) => hh_format_price( $v );
	if ( $l['max'] > $l['min'] ) {
		$a = $fmt( $l['min'] );
		if ( ( $l['min'] >= 1000 ) === ( $l['max'] >= 1000 ) ) {
			$a = preg_replace( '/\s(tỷ|triệu)$/u', '', $a );
		}
		$t = $a . ' – ' . $fmt( $l['max'] );
	} else {
		$t = ( $l['from'] ? 'từ ' : 'khoảng ' ) . $fmt( $l['min'] );
	}
	return $t . ( $rent ? '/tháng' : '' );
}

function hh_listing_build( $l, $project_id ) {
	$rent    = 'thue' === $l['deal'];
	$range   = hh_listing_range_text( $l );
	$link    = '<a href="' . esc_url( get_permalink( $project_id ) ) . '">' . esc_html( $l['name'] ) . '</a>';
	$market  = (string) get_post_meta( $project_id, $rent ? 'hh_p_rent_price' : 'hh_p_resale_price', true );
	$address = (string) get_post_meta( $project_id, 'hh_p_address', true );
	$title   = ( $rent ? 'Cho thuê căn hộ ' : 'Chuyển nhượng căn hộ ' ) . $l['type'] . ' ' . $l['name'];
	$items   = array_filter(
		array(
			'Dự án'                                  => $link,
			'Loại căn'                               => esc_html( $l['type'] ),
			'Diện tích'                              => esc_html( $l['area'] ),
			$rent ? 'Giá thuê tham khảo' : 'Giá tham khảo' => '<strong>' . esc_html( $range ) . '</strong>',
			'Vị trí'                                 => esc_html( $address ),
			$rent ? 'Mặt bằng giá thuê toàn dự án' : 'Mặt bằng giá chuyển nhượng toàn dự án' => esc_html( $market ),
		)
	);
	$html  = '<p>' . ( $rent ? 'Tổng hợp giá thuê' : 'Tổng hợp giá chuyển nhượng' ) . ' căn hộ ' . esc_html( $l['type'] ) . ' tại ' . $link . ': ' . esc_html( $range ) . ' (theo tin rao công khai tháng 10/2026). Giá từng căn chênh lệch theo tầng, hướng, view và nội thất.</p>';
	$html .= '<h2>Thông tin tham khảo</h2><ul>';
	foreach ( $items as $k => $v ) {
		$html .= '<li>' . esc_html( $k ) . ': ' . $v . '</li>';
	}
	$html .= '</ul>';
	$html .= '<h2>Hoàng Hiệp hỗ trợ</h2><ul>';
	if ( $rent ) {
		$html .= '<li>Gửi danh sách căn ' . esc_html( $l['type'] ) . ' ' . esc_html( $l['name'] ) . ' đang cho thuê thật, kèm ảnh thực tế, giá và thời hạn thuê.</li>';
		$html .= '<li>Hẹn xem căn, soạn hợp đồng thuê, bàn giao tài sản và hướng dẫn khai báo tạm trú.</li>';
		$html .= '<li>Chủ nhà cần cho thuê: nhận ký gửi, tư vấn giá thuê phù hợp thị trường.</li>';
	} else {
		$html .= '<li>Gửi danh sách căn ' . esc_html( $l['type'] ) . ' ' . esc_html( $l['name'] ) . ' đang chuyển nhượng thật, kèm ảnh, tầng, hướng và giấy tờ (sổ hồng / hợp đồng mua bán).</li>';
		$html .= '<li>Kiểm tra pháp lý, tình trạng thế chấp, hỗ trợ thương lượng giá và thủ tục công chứng, sang tên.</li>';
		$html .= '<li>Chủ nhà cần bán: nhận ký gửi, định giá theo mặt bằng giao dịch thực tế.</li>';
	}
	$html .= '</ul>';
	$html .= '<p><em>Lưu ý: đây là tin tổng hợp mặt bằng giá theo loại căn, không phải một căn cụ thể. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận căn đang giao dịch thật và giá mới nhất.</em></p>';
	return array(
		'title'   => $title,
		'slug'    => sanitize_title( remove_accents( ( $rent ? 'cho-thue-' : 'chuyen-nhuong-' ) . 'can-ho-' . preg_replace( '/\s*\(.*\)$/u', '', $l['type'] ) . '-' . $l['name'] ) ),
		'excerpt' => ( $rent ? 'Giá thuê căn hộ ' : 'Giá chuyển nhượng căn hộ ' ) . $l['type'] . ' ' . $l['name'] . ' tham khảo ' . $range . ' (10/2026). Liên hệ Hoàng Hiệp để nhận căn đang giao dịch thật.',
		'content' => $html,
	);
}

/** Tạo các tin còn thiếu. Trả về số tin mới. */
function hh_import_listings() {
	$created = 0;
	$data    = hh_listing_dataset();
	$n       = count( $data );
	foreach ( $data as $i => $l ) {
		$project = get_page_by_path( $l['project'], OBJECT, 'du-an' );
		if ( ! $project ) {
			continue;
		}
		$b = hh_listing_build( $l, $project->ID );
		if ( get_page_by_path( $b['slug'], OBJECT, 'bat-dong-san' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'bat-dong-san',
				'post_status'  => 'publish',
				'post_title'   => $b['title'],
				'post_name'    => $b['slug'],
				'post_excerpt' => $b['excerpt'],
				'post_content' => $b['content'],
				// Tin sau trong danh sách đăng sớm hơn vài phút để thứ tự "mới nhất" giữ như danh sách.
				'post_date'    => wp_date( 'Y-m-d H:i:s', time() - ( $n - $i ) * 300 ),
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}
		$meta = array(
			'hh_deal'       => $l['deal'],
			'hh_price'      => $l['min'],
			'hh_price_max'  => $l['max'] > $l['min'] ? $l['max'] : '',
			'hh_price_from' => $l['from'] ? '1' : ( $l['max'] > $l['min'] ? '' : '2' ),
			'hh_bedrooms'   => $l['beds'] ?: '',
			'hh_area'       => preg_match( '/^(\d+(?:[.,]\d+)?)\s*m²$/u', $l['area'], $m ) ? str_replace( ',', '.', $m[1] ) : '',
			'hh_project'    => $project->ID,
			'hh_address'    => get_post_meta( $project->ID, 'hh_p_address', true ),
			'hh_ref_range'  => '1',
		);
		foreach ( array_filter( $meta, static fn( $v ) => '' !== (string) $v ) as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		$areas = wp_get_object_terms( $project->ID, 'khu-vuc', array( 'fields' => 'ids' ) );
		if ( $areas && ! is_wp_error( $areas ) ) {
			wp_set_object_terms( $id, $areas, 'khu-vuc' );
		}
		if ( term_exists( $l['kind'], 'loai-bds' ) ) {
			wp_set_object_terms( $id, $l['kind'], 'loai-bds' );
		}
		++$created;
	}
	return $created;
}
