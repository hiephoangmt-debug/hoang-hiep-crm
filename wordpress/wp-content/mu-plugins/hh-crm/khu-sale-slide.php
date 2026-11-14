<?php
/**
 * Khu Sale – slide đào tạo tự dựng.
 * /sale/slide/<dự-án>      : bộ slide dự án dựng từ dữ liệu trang dự án + khung "Dành cho sale" (đổi dữ liệu là slide đổi theo).
 * /sale/slide/bai-<bài học>: bộ slide bài đào tạo chung (mỗi tiêu đề nhỏ trong bài là 1 slide) + câu hỏi cuối bài.
 * Trình chiếu toàn màn hình: ← → / Space / vuốt / bấm; phím F toàn màn hình; nút In → Lưu PDF (mỗi slide 1 trang ngang).
 * Chỉ người có quyền Khu Sale mới xem được (kiểm tra ở template_redirect của khu-sale.php). Không đưa tài liệu riêng tư vào slide.
 */

defined( 'ABSPATH' ) || exit;

/** Cắt chuỗi gọn cho slide. */
function hh_slide_cut( $s, $n = 150 ) {
	$s = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $s ) ) );
	return mb_strlen( $s ) > $n ? rtrim( mb_substr( $s, 0, $n - 1 ) ) . '…' : $s;
}

function hh_slide_ul( $items, $max = 6, $n = 150, $frag = false ) {
	$items = array_slice( array_values( array_filter( array_map( static fn( $x ) => hh_slide_cut( $x, $n ), (array) $items ) ) ), 0, $max );
	if ( ! $items ) {
		return '';
	}
	$h = '<ul class="bl">';
	foreach ( $items as $x ) {
		$h .= '<li' . ( $frag ? ' class="frag"' : '' ) . '>' . esc_html( $x ) . '</li>';
	}
	return $h . '</ul>';
}

function hh_slide_kv( $rows ) {
	$rows = array_filter( array_map( static fn( $v ) => hh_slide_cut( $v, 110 ), $rows ) );
	if ( ! $rows ) {
		return '';
	}
	$h = '<div class="kv">';
	foreach ( $rows as $k => $v ) {
		$h .= '<div><span>' . esc_html( $k ) . '</span><b>' . esc_html( $v ) . '</b></div>';
	}
	return $h . '</div>';
}

function hh_slide_table( $head, $rows, $max = 7 ) {
	$rows = array_slice( array_values( array_filter( (array) $rows, static fn( $r ) => '' !== trim( implode( '', (array) $r ) ) ) ), 0, $max );
	if ( ! $rows ) {
		return '';
	}
	$h = '<table><tr>';
	foreach ( $head as $c ) {
		$h .= '<th>' . esc_html( $c ) . '</th>';
	}
	$h .= '</tr>';
	foreach ( $rows as $r ) {
		$h .= '<tr>';
		foreach ( array_keys( $head ) as $i ) {
			$h .= '<td>' . esc_html( hh_slide_cut( $r[ $i ] ?? '', 90 ) ) . '</td>';
		}
		$h .= '</tr>';
	}
	return $h . '</table>';
}

function hh_slide_img_url( $aid, $size = 'large' ) {
	return is_numeric( $aid ) ? (string) wp_get_attachment_image_url( (int) $aid, $size ) : '';
}

/** Slide câu hỏi trắc nghiệm: bấm tiếp để hiện đáp án đúng + giải thích. */
function hh_slide_quiz( $q, $i, $total ) {
	$opts = array_merge( array( $q[1] ), array_slice( (array) $q[2], 0, 3 ) );
	shuffle( $opts );
	$h = '<ol class="opts" type="A">';
	foreach ( $opts as $o ) {
		$h .= '<li' . ( $o === $q[1] ? ' class="ok"' : '' ) . '>' . esc_html( hh_slide_cut( $o, 120 ) ) . '</li>';
	}
	$h .= '</ol><p class="frag ans">Đáp án: <b>' . esc_html( hh_slide_cut( $q[1], 120 ) ) . '</b>' . ( ! empty( $q[3] ) ? ' – ' . esc_html( hh_slide_cut( $q[3], 220 ) ) : '' ) . '</p>';
	return array( 'q', 'Câu hỏi ' . $i . '/' . $total, '<p class="qq">' . esc_html( hh_slide_cut( $q[0], 200 ) ) . '</p>' . $h );
}

/** Bộ slide dự án. Trả [tiêu đề, slides]; slide = [kiểu, tiêu đề, html, ảnh nền?]. */
function hh_slide_project( $p ) {
	$id    = $p->ID;
	$m     = static fn( $k ) => trim( (string) get_post_meta( $id, $k, true ) );
	$lines = static fn( $k ) => function_exists( 'hh_lines' ) ? hh_lines( $k, $id ) : array();
	$tbl   = static fn( $k, $n ) => function_exists( 'hh_table' ) ? hh_table( $k, $n, $id ) : array();
	$own   = static fn( $k ) => array_values( array_filter( array_map( 'trim', preg_split( '/\R/u', $m( $k ) ) ) ) );
	$ids   = static fn( $k ) => function_exists( 'hh_ids' ) ? array_values( hh_ids( $k, $id ) ) : array();
	$title = get_the_title( $p );
	$st    = function_exists( 'hh_project_schema' ) && function_exists( 'hh_option_label' ) ? hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) ) : '';
	$cov   = get_the_post_thumbnail_url( $p, '1536x1536' ) ?: get_the_post_thumbnail_url( $p, 'large' );
	$S     = array();

	$S[] = array( 'cover', $title, '<p class="eyb">Đào tạo sale · Học dự án</p><h1>' . esc_html( $title ) . '</h1><p class="sub">' . esc_html( trim( implode( ' · ', array_filter( array( $m( 'hh_p_developer' ), $st, $m( 'hh_p_address' ) ? hh_slide_cut( $m( 'hh_p_address' ), 70 ) : '' ) ) ) ) ) . '</p><p class="by">Hoàng Hiệp · cập nhật ' . esc_html( get_the_modified_date( 'd/m/Y', $p ) ) . '</p>', $cov );

	// Thị trường.
	$h = hh_slide_ul( $own( '_hh_sale_market' ), 5, 140, true ) . hh_slide_kv( array( 'Giá chuyển nhượng' => $m( 'hh_p_resale_price' ), 'Giá thuê' => $m( 'hh_p_rent_price' ), 'Thị trường thứ cấp' => $m( 'hh_p_resale_note' ) ) );
	if ( $h ) {
		$S[] = array( 'sec', 'Thị trường', $h );
	}
	$log = $tbl( 'hh_p_price_log', 4 );
	if ( $log ) {
		$S[] = array( 'sec', 'Giá khu vực cập nhật', hh_slide_table( array( 'Ngày', 'Khu vực / sản phẩm', 'Giá tham khảo', 'Ghi chú' ), $log, 7 ) );
	}

	// Chủ đầu tư.
	$h  = hh_slide_kv( array( 'Chủ đầu tư' => $m( 'hh_p_developer' ), 'Nhà thầu' => $m( 'hh_p_builder' ), 'Thiết kế' => $m( 'hh_p_designer' ), 'Vận hành' => $m( 'hh_p_manager' ) ) );
	$h .= hh_slide_ul( $own( '_hh_sale_developer' ), 4, 140, true );
	if ( function_exists( 'hh_cdt_match' ) && function_exists( 'hh_cdt_all' ) ) {
		foreach ( array_slice( hh_cdt_match( $m( 'hh_p_developer' ) ), 0, 1 ) as $cs ) {
			$d = hh_cdt_all()[ $cs ] ?? array();
			if ( ! empty( $d['facts'] ) && ! $own( '_hh_sale_developer' ) ) {
				$h .= hh_slide_ul( array_map( static fn( $r ) => ( $r[0] ?? '' ) . ': ' . wp_strip_all_tags( (string) ( $r[1] ?? '' ) ), array_slice( (array) $d['facts'], 0, 5 ) ), 5, 130, true );
			}
		}
	}
	if ( $h ) {
		$S[] = array( 'sec', 'Chủ đầu tư', $h );
	}

	// Key bán hàng.
	$usp = $own( '_hh_sale_usp' ) ?: $lines( 'hh_p_highlights' );
	if ( $usp ) {
		$S[] = array( 'key', 'Key – điểm bán hàng chính', hh_slide_ul( $usp, 6, 130, true ) );
	}

	// Tổng quan.
	$h = hh_slide_kv(
		array(
			'Loại hình'        => $m( 'hh_p_type' ),
			'Quy mô'           => $m( 'hh_p_scale' ),
			'Mật độ xây dựng'  => $m( 'hh_p_density' ),
			'Số tòa / tầng'    => trim( $m( 'hh_p_blocks' ) . ( $m( 'hh_p_floors' ) ? ' · ' . $m( 'hh_p_floors' ) : '' ), ' ·' ),
			'Tổng sản phẩm'    => $m( 'hh_p_units' ),
			'Diện tích'        => $m( 'hh_p_unit_area' ),
			'Pháp lý'          => $m( 'hh_p_legal' ),
			'Sở hữu'           => $m( 'hh_p_ownership' ),
			'Bàn giao'         => $m( 'hh_p_handover' ),
			'Tiêu chuẩn'       => $m( 'hh_p_handover_std' ),
		)
	);
	if ( $h ) {
		$S[] = array( 'sec', 'Tổng quan dự án', $h );
	}

	// Vị trí + liên kết vùng.
	$loc = hh_slide_img_url( $m( 'hh_p_location_img' ) );
	$h   = hh_slide_kv( array( 'Địa chỉ' => $m( 'hh_p_address' ) ) ) . ( $m( 'hh_p_location_desc' ) ? '<p class="lead">' . esc_html( hh_slide_cut( $m( 'hh_p_location_desc' ), 260 ) ) . '</p>' : '' );
	if ( $h || $loc ) {
		$S[] = array( $loc ? 'split' : 'sec', 'Vị trí', $h, $loc );
	}
	$conn = function_exists( 'hh_project_connections' ) ? hh_project_connections( $id ) : array( $tbl( 'hh_p_connections', 2 ), false );
	if ( $conn[0] ) {
		$S[] = array( 'sec', 'Liên kết vùng', hh_slide_table( array( 'Thời gian / khoảng cách', 'Địa điểm' ), $conn[0], 8 ) . ( $conn[1] ? '<p class="note">Mốc tham khảo theo khu vực – kiểm tra lại bằng Google Maps trước khi nói với khách.</p>' : '' ) );
	}

	// Tiện ích.
	$ain  = $lines( 'hh_p_amenities_in' );
	$aout = function_exists( 'hh_project_nearby' ) ? hh_project_nearby( $id )[0] : $lines( 'hh_p_amenities_out' );
	$aimg = hh_slide_img_url( $ids( 'hh_p_amenities_img' )[0] ?? '' );
	if ( $ain || $aout ) {
		$h = '<div class="cols">' . ( $ain ? '<div><h3>Nội khu</h3>' . hh_slide_ul( $ain, 6, 70 ) . '</div>' : '' ) . ( $aout ? '<div><h3>Ngoại khu</h3>' . hh_slide_ul( $aout, 6, 70 ) . '</div>' : '' ) . '</div>';
		$S[] = array( $aimg && ! ( $ain && $aout ) ? 'split' : 'sec', 'Tiện ích', $h, $aimg );
	}

	// Mặt bằng.
	$mp = hh_slide_img_url( $m( 'hh_p_masterplan_img' ), 'full' );
	if ( function_exists( 'hh_mbbd_plans' ) && isset( hh_mbbd_plans()[ $p->post_name ] ) ) {
		$mp = HH_CRM_URL . hh_mbbd_plans()[ $p->post_name ]['image'];
	}
	if ( $mp ) {
		$S[] = array( 'img', 'Mặt bằng tổng thể', '', $mp );
	}
	$types = $tbl( 'hh_p_unit_types', 4 );
	if ( $types ) {
		$S[] = array( 'sec', 'Các loại sản phẩm', hh_slide_table( array( 'Loại', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), $types, 8 ) );
	}
	$lay = array_slice( array_filter( array_map( static fn( $a ) => hh_slide_img_url( $a, 'medium_large' ), $ids( 'hh_p_unit_layouts' ) ) ), 0, 4 );
	if ( $lay ) {
		$g = '<div class="gal g' . count( $lay ) . '">';
		foreach ( $lay as $u ) {
			$g .= '<img src="' . esc_url( $u ) . '" alt="">';
		}
		$S[] = array( 'sec', 'Layout căn tiêu biểu', $g . '</div>' );
	}
	$read = array_merge( $own( '_hh_sale_floor_read' ) );
	$h    = ( $read ? '<h3>Đọc mặt bằng</h3>' . hh_slide_ul( $read, 4, 120, true ) : '' ) . ( $own( '_hh_sale_best_price' ) ? '<h3>Căn giá tốt</h3>' . hh_slide_ul( $own( '_hh_sale_best_price' ), 3, 120, true ) : '' ) . ( $own( '_hh_sale_invest' ) ? '<h3>Căn đầu tư tốt</h3>' . hh_slide_ul( $own( '_hh_sale_invest' ), 3, 120, true ) : '' );
	if ( $h ) {
		$S[] = array( 'sec', 'Tư vấn chọn căn', $h );
	}

	// Giá & chính sách.
	$h = hh_slide_kv( array( 'Đơn giá tham khảo' => $m( 'hh_p_price_m2' ), 'Ưu đãi' => $m( 'hh_p_offer_title' ), 'Hạn ưu đãi' => $m( 'hh_p_offer_deadline' ) ) ) . hh_slide_ul( $lines( 'hh_p_policy' ), 5, 130, true );
	if ( $h ) {
		$S[] = array( 'sec', 'Giá & chính sách', $h . '<p class="note">Giá, chính sách tham khảo – đối chiếu văn bản mới nhất của chủ đầu tư trước khi báo khách.</p>' );
	}
	$pt = $tbl( 'hh_p_price_table', 4 );
	if ( $pt ) {
		$S[] = array( 'sec', 'Bảng giá tham khảo', hh_slide_table( array( 'Sản phẩm', 'Diện tích', 'Giá', 'Ghi chú' ), $pt, 8 ) );
	}
	$dt = $tbl( 'hh_p_discount_table', 4 );
	if ( $dt ) {
		$S[] = array( 'sec', 'Phương án thanh toán & chiết khấu', hh_slide_table( array( 'Phương án', 'Hạn thanh toán', 'Chiết khấu', 'Cách tính' ), $dt, 7 ) );
	}
	$pay = $tbl( 'hh_p_payment', 3 );
	if ( $pay ) {
		$S[] = array( 'sec', 'Lịch thanh toán', hh_slide_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $pay, 9 ) );
	}
	$h = hh_slide_kv( array( 'Hỗ trợ vay' => $m( 'hh_p_loan' ), 'Ngân hàng' => $m( 'hh_p_loan_bank' ), 'Tỷ lệ vay tối đa' => $m( 'hh_p_loan_ratio' ) ? $m( 'hh_p_loan_ratio' ) . '%' : '', 'Thời hạn' => $m( 'hh_p_loan_years' ) ? $m( 'hh_p_loan_years' ) . ' năm' : '', 'Hỗ trợ lãi 0%' => $m( 'hh_p_loan_zero_months' ) ? $m( 'hh_p_loan_zero_months' ) . ' tháng' : '', 'Ân hạn gốc' => $m( 'hh_p_loan_grace' ) ? $m( 'hh_p_loan_grace' ) . ' tháng' : '' ) );
	if ( $h ) {
		$S[] = array( 'sec', 'Vay ngân hàng', $h );
	}

	// Tiến độ.
	$prog = array_slice( array_reverse( $tbl( 'hh_p_progress', 2 ) ), 0, 6 );
	$pimg = hh_slide_img_url( array_reverse( $ids( 'hh_p_progress_gallery' ) )[0] ?? '' );
	if ( $prog || $pimg ) {
		$S[] = array( $pimg ? 'split' : 'sec', 'Tiến độ', hh_slide_table( array( 'Thời gian', 'Nội dung' ), $prog, 6 ), $pimg );
	}

	// Q&A: câu hỏi hiện trước, bấm tiếp mới hiện câu trả lời.
	$faq = function_exists( 'hh_sale_pairs' ) ? hh_sale_pairs( $m( '_hh_sale_faq' ) ) : array();
	foreach ( array_chunk( array_slice( $faq, 0, 12 ), 3 ) as $i => $chunk ) {
		$h = '<dl class="qa">';
		foreach ( $chunk as $q ) {
			$h .= '<dt>' . esc_html( hh_slide_cut( $q[0], 140 ) ) . '</dt><dd class="frag">' . esc_html( hh_slide_cut( $q[1], 220 ) ) . '</dd>';
		}
		$S[] = array( 'sec', 'Khách hay hỏi' . ( $i ? ' (tiếp)' : '' ), $h . '</dl>' );
	}
	if ( $m( '_hh_sale_notes' ) ) {
		$S[] = array( 'warn', 'Lưu ý khi tư vấn', hh_slide_ul( $own( '_hh_sale_notes' ), 6, 150, true ) );
	}

	// Câu hỏi kiểm tra tự sinh từ dữ liệu dự án (đổi mỗi lần mở).
	if ( function_exists( 'hh_sale_build_quiz' ) ) {
		$qs = hh_sale_build_quiz( 5, $id );
		$S[] = array( 'part', 'Kiểm tra nhanh', '<h1>Kiểm tra nhanh</h1><p class="sub">' . count( $qs ) . ' câu – cả nhóm trả lời trước, bấm tiếp để hiện đáp án.</p>' );
		foreach ( $qs as $i => $q ) {
			$S[] = hh_slide_quiz( $q, $i + 1, count( $qs ) );
		}
	}
	$S[] = array( 'end', 'Kết thúc', '<h1>Cảm ơn cả nhà!</h1><p class="sub">Làm bài kiểm tra ' . esc_html( $title ) . ' trong Khu Sale để chốt kiến thức.</p><p class="by">' . esc_html( hh_sale_url( 'du-an/' . $p->post_name ) ) . '</p>', $cov );
	return array( $title, $S );
}

/** Bộ slide bài học chung. */
function hh_slide_lesson( $slug ) {
	$core = function_exists( 'hh_sale_core_lessons' ) ? hh_sale_core_lessons() : array();
	if ( isset( $core[ $slug ] ) ) {
		list( $title, $group, $body ) = $core[ $slug ];
	} else {
		$p = defined( 'HH_SALE_LESSON_TYPE' ) ? get_page_by_path( $slug, OBJECT, HH_SALE_LESSON_TYPE ) : null;
		if ( ! $p || 'publish' !== $p->post_status ) {
			return null;
		}
		$title = get_the_title( $p );
		$group = 'Bài của anh Hiệp';
		$body  = apply_filters( 'the_content', $p->post_content ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
	}
	$S     = array( array( 'cover', $title, '<p class="eyb">Đào tạo sale · ' . esc_html( $group ) . '</p><h1>' . esc_html( $title ) . '</h1><p class="by">Hoàng Hiệp</p>', '' ) );
	$parts = preg_split( '#<h[23][^>]*>(.*?)</h[23]>#isu', (string) $body, -1, PREG_SPLIT_DELIM_CAPTURE );
	$intro = trim( (string) array_shift( $parts ) );
	if ( '' !== wp_strip_all_tags( $intro ) ) {
		$S[] = array( 'sec', $title, '<div class="rich">' . wp_kses_post( $intro ) . '</div>' );
	}
	for ( $i = 0; $i + 1 < count( $parts ); $i += 2 ) {
		$S[] = array( 'sec', wp_strip_all_tags( $parts[ $i ] ), '<div class="rich">' . wp_kses_post( $parts[ $i + 1 ] ) . '</div>' );
	}
	if ( function_exists( 'hh_sale_core_questions' ) ) {
		$qs = array_values( array_filter( hh_sale_core_questions(), static fn( $q ) => ( $q[4] ?? '' ) === $slug ) );
		shuffle( $qs );
		$qs = array_slice( $qs, 0, 4 );
		if ( $qs ) {
			$S[] = array( 'part', 'Kiểm tra nhanh', '<h1>Kiểm tra nhanh</h1><p class="sub">' . count( $qs ) . ' câu – bấm tiếp để hiện đáp án.</p>' );
			foreach ( $qs as $i => $q ) {
				$S[] = hh_slide_quiz( $q, $i + 1, count( $qs ) );
			}
		}
	}
	$S[] = array( 'end', 'Kết thúc', '<h1>Hết bài!</h1><p class="sub">Làm bài kiểm tra 10 câu trong Khu Sale → Kiểm tra.</p>', '' );
	return array( $title, $S );
}

/** In trang trình chiếu. $id: slug dự án, hoặc "bai-<slug bài học>". */
function hh_sale_slide( $id ) {
	$deck = null;
	$back = hh_sale_url( 'du-an' );
	if ( 0 === strpos( $id, 'bai-' ) ) {
		$deck = hh_slide_lesson( substr( $id, 4 ) );
		$back = hh_sale_url( 'dao-tao/' . substr( $id, 4 ) );
	} else {
		$p = get_page_by_path( $id, OBJECT, 'du-an' );
		if ( $p && 'publish' === $p->post_status ) {
			$deck = hh_slide_project( $p );
			$back = hh_sale_url( 'du-an/' . $id );
		}
	}
	if ( ! $deck ) {
		wp_safe_redirect( hh_sale_url( 'dao-tao' ) );
		exit;
	}
	list( $title, $slides ) = $deck;
	$font = get_template_directory_uri() . '/assets/fonts/';
	$ff   = '';
	foreach ( array( 400, 600, 700 ) as $w ) {
		foreach ( array( 'vietnamese', 'latin', 'latin-ext' ) as $sub ) {
			$ff .= '@font-face{font-family:BVP;font-weight:' . $w . ';font-display:swap;src:url(' . esc_url( $font . 'be-vietnam-pro-' . $w . '-' . $sub . '.woff2' ) . ') format("woff2")}';
		}
	}
	$n = count( $slides );
	?><!DOCTYPE html>
<html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow">
<title><?php echo esc_html( 'Slide – ' . $title ); ?></title>
<style>
<?php echo $ff; // phpcs:ignore ?>
:root{--n:#0e223a;--n2:#1f3d63;--o:#f2551d;--o2:#ff8a3d;--cream:#f7f3ec;--mut:#5d6b7c}
*{box-sizing:border-box}html,body{margin:0;height:100%;background:#0b1a2c;font-family:BVP,system-ui,sans-serif;color:#14223a;overflow:hidden}
#deck{position:absolute;left:50%;top:50%;width:1280px;height:720px;transform-origin:center}
.s{position:absolute;inset:0;display:none;background:var(--cream);overflow:hidden;border-radius:6px}.s.on{display:block}
.s .hd{position:absolute;left:0;right:0;top:0;height:96px;display:flex;align-items:center;padding:0 64px;background:var(--n);color:#fff}
.s .hd h2{margin:0;font-size:36px;font-weight:700;letter-spacing:-.01em}.s .hd:after{content:"";position:absolute;left:64px;bottom:-4px;width:120px;height:8px;border-radius:4px;background:linear-gradient(90deg,var(--o),var(--o2))}
.s .bd{position:absolute;left:64px;right:64px;top:132px;bottom:64px;font-size:26px;line-height:1.45;overflow:hidden}
.s .ft{position:absolute;left:64px;right:64px;bottom:20px;display:flex;justify-content:space-between;font-size:15px;color:#8a97a8}
.bl{margin:0;padding:0;list-style:none}.bl li{position:relative;padding-left:38px;margin:0 0 14px}.bl li:before{content:"";position:absolute;left:4px;top:.45em;width:16px;height:16px;border-radius:4px;background:linear-gradient(135deg,var(--o),var(--o2));transform:rotate(45deg)}
.kv{display:grid;grid-template-columns:repeat(2,1fr);gap:14px 22px;margin:0 0 18px}.kv div{background:#fff;border-radius:12px;padding:12px 18px;border-left:6px solid var(--o);box-shadow:0 6px 16px -12px rgba(14,34,58,.5)}.kv span{display:block;font-size:16px;color:var(--mut)}.kv b{font-size:22px;color:var(--n);font-weight:600}
table{width:100%;border-collapse:collapse;font-size:21px;background:#fff;border-radius:12px;overflow:hidden}th{background:var(--n2);color:#fff;text-align:left;font-weight:600;padding:10px 14px}td{padding:9px 14px;border-bottom:1px solid #e6e1d6;vertical-align:top}
h3{font-size:24px;color:var(--o);margin:4px 0 8px}.cols{display:grid;grid-template-columns:1fr 1fr;gap:36px}.cols .bl li{margin-bottom:8px;font-size:22px}
.lead{font-size:23px;color:#334}.note{font-size:17px;color:var(--mut);margin-top:12px}
.split .bd{right:620px}.split .pic{position:absolute;right:0;top:96px;bottom:0;width:580px;background:#ddd center/cover no-repeat}
.img .bd{left:24px;right:24px;top:112px;bottom:44px;display:flex;align-items:center;justify-content:center}.img .bd img{max-width:100%;max-height:100%;object-fit:contain;border-radius:8px;box-shadow:0 10px 30px -14px rgba(0,0,0,.5)}
.gal{display:grid;gap:16px;height:510px}.gal.g2{grid-template-columns:1fr 1fr}.gal.g3{grid-template-columns:repeat(3,1fr)}.gal.g4{grid-template-columns:repeat(2,1fr);grid-template-rows:1fr 1fr}.gal img{width:100%;height:100%;object-fit:contain;background:#fff;border-radius:10px}
.cover,.part,.end{background:var(--n) center/cover no-repeat;color:#fff}.cover:before,.end:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(14,34,58,.95) 0%,rgba(14,34,58,.75) 55%,rgba(14,34,58,.3) 100%)}
.part:before{content:"";position:absolute;right:-160px;top:-160px;width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(255,138,61,.5),rgba(255,138,61,0) 70%)}
.cover .bd,.part .bd,.end .bd{top:0;bottom:0;display:flex;flex-direction:column;justify-content:center;right:300px}
.cover h1,.part h1,.end h1{font-size:68px;line-height:1.08;margin:0 0 18px;font-weight:700;letter-spacing:-.02em}.eyb{color:var(--o2);font-weight:700;letter-spacing:.14em;text-transform:uppercase;font-size:20px;margin:0 0 14px}.sub{font-size:26px;color:#d4deea;margin:0}.by{font-size:18px;color:#9fb0c4;margin-top:40px}
.cover .ft,.part .ft,.end .ft{color:#7f93ab}
.key .bl li{font-size:28px;font-weight:600;color:var(--n);background:#fff;border-radius:12px;padding:12px 18px 12px 54px;box-shadow:0 6px 16px -12px rgba(14,34,58,.5)}.key .bl li:before{left:20px;top:1.05em}
.warn .bd{background:#fff7e6;border:2px solid #f5d38a;border-radius:16px;padding:24px 28px}
.qa dt{font-weight:700;color:var(--n);font-size:24px;margin-top:10px}.qa dt:before{content:"Hỏi: ";color:var(--o)}.qa dd{margin:4px 0 12px;font-size:22px;color:#334;background:#fff;border-radius:10px;padding:8px 14px}.qa dd:before{content:"Đáp: ";font-weight:700;color:#167a3e}
.qq{font-size:32px;font-weight:700;color:var(--n);margin:0 0 22px;line-height:1.3}.opts{margin:0;padding-left:44px;font-size:26px}.opts li{margin:0 0 12px;padding:8px 16px;background:#fff;border-radius:10px;border:2px solid transparent}
.opts.show li.ok{border-color:#16a34a;background:#e8f7ee;font-weight:700}.ans{font-size:22px;color:#334;background:#e8f7ee;border-radius:10px;padding:10px 16px}
.rich{font-size:25px}.rich p{margin:0 0 14px}.rich ol,.rich ul{margin:0 0 12px;padding-left:34px}.rich li{margin:0 0 8px}.rich table{font-size:19px}
.frag{visibility:hidden}.frag.vis{visibility:visible;animation:fi .35s ease}@keyframes fi{from{opacity:0;transform:translateY(8px)}to{opacity:1}}
#ui{position:fixed;left:0;right:0;bottom:0;display:flex;gap:8px;align-items:center;justify-content:center;padding:8px;opacity:.15;transition:opacity .2s;z-index:5}#ui:hover{opacity:1}
#ui button,#ui a{font:600 14px BVP,sans-serif;background:rgba(255,255,255,.14);color:#fff;border:0;border-radius:999px;padding:7px 14px;cursor:pointer;text-decoration:none}#ui span{color:#c9d6e6;font:14px BVP,sans-serif;min-width:70px;text-align:center}
#bar{position:fixed;left:0;top:0;height:4px;background:linear-gradient(90deg,var(--o),var(--o2));z-index:6;transition:width .2s}
@media print{@page{size:1280px 720px;margin:0}html,body{overflow:visible;background:#fff;height:auto}#deck{position:static;transform:none!important;width:1280px;height:auto}.s{position:relative;display:block!important;width:1280px;height:720px;page-break-after:always;break-after:page;border-radius:0}.frag{visibility:visible}.opts li.ok{border-color:#16a34a;background:#e8f7ee}#ui,#bar{display:none}*{-webkit-print-color-adjust:exact;print-color-adjust:exact}}
</style></head><body>
<div id="bar"></div>
<div id="deck">
<?php foreach ( $slides as $i => $s ) : ?>
	<?php
	$kind = $s[0];
	$bg   = $s[3] ?? '';
	$full = in_array( $kind, array( 'cover', 'part', 'end' ), true );
	$cls  = 'q' === $kind ? 'sec' : $kind;
	?>
<section class="s <?php echo esc_attr( $cls ); ?>"<?php echo $full && $bg ? ' style="background-image:url(\'' . esc_url( $bg ) . '\')"' : ''; ?>>
	<?php if ( ! $full ) : ?><div class="hd"><h2><?php echo esc_html( $s[1] ); ?></h2></div><?php endif; ?>
	<?php if ( 'split' === $kind && $bg ) : ?><div class="pic" style="background-image:url('<?php echo esc_url( $bg ); ?>')"></div><?php endif; ?>
	<div class="bd"><?php echo 'img' === $kind ? '<img src="' . esc_url( $bg ) . '" alt="">' : '<div class="in">' . $s[2] . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- từng phần đã escape. ?></div>
	<div class="ft"><span><?php echo esc_html( $title ); ?> · Hoàng Hiệp – tài liệu nội bộ</span><span><?php echo (int) ( $i + 1 ) . ' / ' . (int) $n; ?></span></div>
</section>
<?php endforeach; ?>
</div>
<div id="ui"><a href="<?php echo esc_url( $back ); ?>">← Thoát</a><button data-a="prev">‹ Trước</button><span id="pg"></span><button data-a="next">Tiếp ›</button><button data-a="fs">Toàn màn hình (F)</button><button data-a="print">In / Lưu PDF</button></div>
<script>
(function () {
	var S = [].slice.call(document.querySelectorAll('.s')), deck = document.getElementById('deck'), cur = 0;
	var m = /#(\d+)/.exec(location.hash); if (m) { cur = Math.min(S.length - 1, Math.max(0, m[1] - 1)); }
	function fit() { var k = Math.min(innerWidth / 1280, innerHeight / 720); deck.style.transform = 'translate(-50%,-50%) scale(' + k + ')'; }
	// Chữ dài tràn khung: thu nhỏ dần cỡ chữ của slide đó.
	function shrink(s) { var b = s.querySelector('.bd'), n = s.querySelector('.in'); if (!b || !n || s.dataset.fit) { return; } s.dataset.fit = 1; var z = 1, bh = b.getBoundingClientRect().height, nh = n.getBoundingClientRect().height; if (nh && nh < bh * .55 && !n.querySelector('table,.gal,.opts')) { z = Math.min(1.35, bh * .7 / nh); n.style.zoom = z; } while (n.getBoundingClientRect().height > b.getBoundingClientRect().height + 1 && z > .5) { z -= .04; n.style.zoom = z; } }
	function frags(s) { return [].slice.call(s.querySelectorAll('.frag')); }
	function show(i) { S[cur].classList.remove('on'); cur = i; S[cur].classList.add('on'); shrink(S[cur]); document.getElementById('pg').textContent = (cur + 1) + ' / ' + S.length; document.getElementById('bar').style.width = ((cur + 1) / S.length * 100) + '%'; history.replaceState(null, '', '#' + (cur + 1)); }
	function next() { var f = frags(S[cur]).filter(function (x) { return !x.classList.contains('vis'); }); if (f.length) { f[0].classList.add('vis'); if (f[0].classList.contains('ans')) { var o = S[cur].querySelector('.opts'); if (o) { o.classList.add('show'); } } return; } if (cur < S.length - 1) { show(cur + 1); } }
	function prev() { if (cur > 0) { show(cur - 1); } }
	function fs() { if (document.fullscreenElement) { document.exitFullscreen(); } else if (document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); } }
	addEventListener('resize', fit);
	addEventListener('keydown', function (e) { if (['ArrowRight', 'PageDown', ' ', 'Enter'].indexOf(e.key) > -1) { e.preventDefault(); next(); } else if (['ArrowLeft', 'PageUp', 'Backspace'].indexOf(e.key) > -1) { e.preventDefault(); prev(); } else if (e.key === 'f' || e.key === 'F') { fs(); } else if (e.key === 'Home') { show(0); } else if (e.key === 'End') { show(S.length - 1); } });
	deck.addEventListener('click', function (e) { if (e.target.closest('a')) { return; } (e.clientX < innerWidth / 3 ? prev : next)(); });
	var x0 = null; addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true }); addEventListener('touchend', function (e) { if (x0 === null) { return; } var d = e.changedTouches[0].clientX - x0; if (Math.abs(d) > 40) { (d < 0 ? next : prev)(); } x0 = null; });
	document.getElementById('ui').addEventListener('click', function (e) { var a = e.target.getAttribute('data-a'); if (a === 'next') { next(); } else if (a === 'prev') { prev(); } else if (a === 'fs') { fs(); } else if (a === 'print') { S.forEach(function (x) { var on = x.classList.contains('on'); x.classList.add('on'); shrink(x); if (!on) { x.classList.remove('on'); } }); window.print(); } });
	fit(); S[cur].classList.add('on'); show(cur);
})();
</script>
</body></html>
	<?php
	exit;
}
