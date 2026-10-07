<?php
/**
 * Rank Math cho trang dự án:
 * - Tự điền "Từ khóa chính" (tên dự án + "giá …" + "bảng giá …") cho dự án chưa có.
 * - Tự điền "Tiêu đề SEO": "{Tên}: Bảng giá, chính sách {tháng/năm cập nhật} | Hoàng Hiệp" (≤ 60 ký tự).
 * - Cho bộ chấm điểm của Rank Math đọc cả nội dung trong các tab Thông tin dự án
 *   (trên web các phần này đều hiển thị, nhưng Rank Math chỉ đọc ô soạn thảo chính).
 */

defined( 'ABSPATH' ) || exit;

/** Từ khóa chính của dự án: khớp đường dẫn (slug) để đạt tiêu chí "từ khóa trong URL". */
function hh_rm_project_keywords( $post ) {
	$name = trim( preg_replace( '/\s*\([^)]*\)/u', '', html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) ) );
	$slug = '-' . $post->post_name . '-';
	$main = '';
	// Cụm từ liền nhau dài nhất trong tên dự án nằm trọn trong đường dẫn (VD "Capital Square", "FourS Tower").
	foreach ( preg_split( '/\s+[–—-]\s+/u', $name ) as $seg ) {
		$w = preg_split( '/\s+/u', trim( $seg ) );
		$n = count( $w );
		for ( $i = 0; $i < $n; $i++ ) {
			for ( $j = $n; $j > $i; $j-- ) {
				$cand = implode( ' ', array_slice( $w, $i, $j - $i ) );
				if ( preg_match( '/^[&+]|[&+]$|^(đà nẵng|da nang|danang|hội an|hoi an|quảng nam|sơn trà)$/iu', $cand ) ) {
					continue; // Bỏ cụm cụt ("Resort &") hoặc chỉ là tên địa phương.
				}
				if ( mb_strlen( $cand ) > mb_strlen( $main ) && mb_strlen( $cand ) >= 4 && false !== strpos( $slug, '-' . sanitize_title( $cand ) . '-' ) ) {
					$main = $cand;
				}
			}
		}
	}
	$main = $main && preg_match( '/^[\p{Lu}\d]/u', $main ) ? $main : $name;
	// Tòa / phân khu con trùng từ khoá với dự án mẹ (VD Capital Square – Tòa 2.1): dùng tên đầy đủ để mỗi trang 1 từ khoá.
	if ( false !== strpos( $name, ' – ' ) && hh_rm_main_shared( $main, $post ) ) {
		$main = trim( preg_replace( '/\s+(Đà Nẵng|Da Nang|Danang)(?=\s|$)/u', '', str_replace( ' – ', ' ', $name ) ) );
	}
	$short = preg_match( '/\bNam\s+Hội An$/u', $main ) ? $main : ( trim( preg_replace( '/\s+(Đà Nẵng|Da Nang|Danang|Hội An|Hoi An|Quảng Nam)$/iu', '', $main ) ) ?: $main );
	return implode( ',', array_unique( array( $main, 'giá ' . $short, 'bảng giá ' . $short ) ) );
}

/** Từ khoá chính (cách tính gốc) đang dùng chung với dự án khác có đường dẫn ngắn hơn (dự án mẹ). */
function hh_rm_main_shared( $main, $post ) {
	static $map = null;
	if ( null === $map ) {
		$map = array();
		foreach ( get_posts( array( 'post_type' => 'du-an', 'post_status' => array( 'publish', 'future', 'draft', 'pending' ), 'posts_per_page' => -1 ) ) as $p ) {
			$k           = mb_strtolower( explode( ',', hh_rm_project_keywords_legacy( $p ) )[0] );
			$map[ $k ][] = $p->post_name;
		}
	}
	$list = $map[ mb_strtolower( $main ) ] ?? array();
	if ( count( $list ) < 2 ) {
		return false;
	}
	usort( $list, static fn( $a, $b ) => strlen( $a ) - strlen( $b ) );
	return $list[0] !== $post->post_name; // Dự án mẹ (đường dẫn ngắn nhất) giữ từ khoá gốc.
}

/** Cách tính từ khoá cũ (≤ 2.17) – chỉ để nhận ra từ khoá web tự điền trước đây và thay bằng bản mới. */
function hh_rm_project_keywords_legacy( $post ) {
	$name = trim( preg_replace( '/\s*\([^)]*\)/u', '', html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) ) );
	$slug = '-' . $post->post_name . '-';
	$main = '';
	// Cụm từ liền nhau dài nhất trong tên dự án nằm trọn trong đường dẫn (VD "Capital Square", "FourS Tower").
	foreach ( preg_split( '/\s+[–—-]\s+/u', $name ) as $seg ) {
		$w = preg_split( '/\s+/u', trim( $seg ) );
		$n = count( $w );
		for ( $i = 0; $i < $n; $i++ ) {
			for ( $j = $n; $j > $i; $j-- ) {
				$cand = implode( ' ', array_slice( $w, $i, $j - $i ) );
				if ( preg_match( '/^[&+]|[&+]$|^(đà nẵng|da nang|danang|hội an|hoi an|quảng nam|sơn trà)$/iu', $cand ) ) {
					continue; // Bỏ cụm cụt ("Resort &") hoặc chỉ là tên địa phương.
				}
				if ( mb_strlen( $cand ) > mb_strlen( $main ) && mb_strlen( $cand ) >= 4 && false !== strpos( $slug, '-' . sanitize_title( $cand ) . '-' ) ) {
					$main = $cand;
				}
			}
		}
	}
	$main  = $main && preg_match( '/^[\p{Lu}\d]/u', $main ) ? $main : $name;
	$short = trim( preg_replace( '/\s+(Đà Nẵng|Da Nang|Danang|Hội An|Hoi An|Quảng Nam)$/iu', '', $main ) ) ?: $main;
	return implode( ',', array_unique( array( $main, 'giá ' . $short, 'bảng giá ' . $short ) ) );
}

/**
 * Tiêu đề SEO trang dự án: "{Tên}: Bảng giá, chính sách {tháng}/{năm} | Hoàng Hiệp" (≤ 60 ký tự, tự rút gọn).
 * Tháng/năm = lần cập nhật dữ liệu dự án gần nhất (không phải ngày hôm nay).
 */
function hh_rm_project_title( $post ) {
	$kw   = explode( ',', hh_rm_project_keywords( $post ) );
	$name = '';
	foreach ( $kw as $k ) {
		if ( 0 === strpos( $k, 'bảng giá ' ) ) {
			$name = trim( substr( $k, strlen( 'bảng giá ' ) ) );
		}
	}
	$name  = $name ?: trim( preg_replace( '/\s*\([^)]*\)/u', '', html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) ) );
	$when  = wp_date( 'm/Y', (int) get_post_modified_time( 'U', true, $post ) );
	$brand = function_exists( 'hoanghiep_opt' ) && hoanghiep_opt( 'hh_person_name' ) ? hoanghiep_opt( 'hh_person_name' ) : 'Hoàng Hiệp';
	foreach ( array(
		$name . ': Bảng giá, chính sách ' . $when . ' | ' . $brand,
		$name . ': Bảng giá, chính sách ' . $when,
		$name . ': Bảng giá ' . $when . ' | ' . $brand,
		$name . ': Bảng giá ' . $when,
	) as $title ) {
		if ( mb_strlen( $title ) <= 60 ) {
			return $title;
		}
	}
	return rtrim( mb_substr( $name, 0, 60 - mb_strlen( ': Bảng giá ' . $when ) - 1 ) ) . '…: Bảng giá ' . $when;
}

/** Ghi tiêu đề SEO dự án khi đang trống hoặc vẫn là bản web tự tạo lần trước (anh sửa tay thì giữ nguyên). */
function hh_rm_sync_project_title( $post ) {
	$cur  = (string) get_post_meta( $post->ID, 'rank_math_title', true );
	$auto = (string) get_post_meta( $post->ID, '_hh_rm_auto_title', true );
	if ( '' !== $cur && $cur !== $auto ) {
		return;
	}
	$new = hh_rm_project_title( $post );
	if ( $new !== $cur ) {
		update_post_meta( $post->ID, 'rank_math_title', $new );
	}
	update_post_meta( $post->ID, '_hh_rm_auto_title', $new );
}

/** Điền từ khóa cho dự án đang trống (chạy một lần mỗi phiên bản plugin, và khi lưu dự án). */
add_action( 'admin_init', 'hh_rm_fill_keywords' );
function hh_rm_fill_keywords() {
	if ( get_option( 'hh_rm_kw_done' ) === HH_CRM_VERSION || ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	$ids = get_posts(
		array(
			'post_type'      => 'du-an',
			'post_status'    => array( 'publish', 'future', 'draft', 'pending' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $ids as $id ) {
		$cur = (string) get_post_meta( $id, 'rank_math_focus_keyword', true );
		// Trống, hoặc vẫn là từ khoá web tự điền theo cách cũ (anh chưa sửa tay) → điền bản mới.
		if ( '' === $cur || $cur === hh_rm_project_keywords_legacy( get_post( $id ) ) ) {
			update_post_meta( $id, 'rank_math_focus_keyword', hh_rm_project_keywords( get_post( $id ) ) );
		}
		hh_rm_sync_project_title( get_post( $id ) );
	}
	update_option( 'hh_rm_kw_done', HH_CRM_VERSION, false );
}

add_action(
	'save_post_du-an',
	static function ( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || 'auto-draft' === $post->post_status || '' === trim( $post->post_title ) ) {
			return;
		}
		if ( '' === (string) get_post_meta( $post_id, 'rank_math_focus_keyword', true ) && empty( $_POST['rank_math_focus_keyword'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $post_id, 'rank_math_focus_keyword', hh_rm_project_keywords( $post ) );
		}
		if ( empty( $_POST['rank_math_title'] ) || (string) get_post_meta( $post_id, '_hh_rm_auto_title', true ) === wp_unslash( $_POST['rank_math_title'] ) ) { // phpcs:ignore
			hh_rm_sync_project_title( get_post( $post_id ) );
		}
	},
	30,
	2
);

/** Nội dung các tab Thông tin dự án dạng HTML, để Rank Math tính độ dài, mật độ từ khóa, tiêu đề phụ. */
function hh_rm_project_text( $post_id ) {
	$html = '';
	foreach ( hh_project_schema() as $group ) {
		$parts = array();
		foreach ( $group['fields'] as $key => $f ) {
			$type = $f['type'] ?? 'text';
			if ( ! in_array( $type, array( 'text', 'textarea', 'lines', 'table' ), true ) ) {
				continue;
			}
			$v = trim( (string) get_post_meta( $post_id, $key, true ) );
			if ( '' === $v || preg_match( '#^https?://#', $v ) ) {
				continue;
			}
			$parts[] = '<p>' . esc_html( $f['label'] ) . ': ' . nl2br( esc_html( str_replace( ' | ', ', ', $v ) ) ) . '</p>';
		}
		if ( $parts ) {
			$html .= '<h2>' . esc_html( $group['title'] ) . ' ' . esc_html( get_the_title( $post_id ) ) . '</h2>' . implode( '', $parts );
		}
	}
	return $html;
}

add_action( 'admin_enqueue_scripts', 'hh_rm_enqueue' );
function hh_rm_enqueue( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'du-an' !== get_post_type() || ! defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}
	wp_enqueue_script( 'hh-rankmath', HH_CRM_URL . 'rankmath.js', array( 'wp-hooks' ), HH_CRM_VERSION, true );
	wp_localize_script( 'hh-rankmath', 'hhRankMath', array( 'content' => hh_rm_project_text( get_the_ID() ) ) );
}
