<?php
/**
 * Rank Math cho trang dự án:
 * - Tự điền "Từ khóa chính" (tên dự án + "giá …" + "bảng giá …") cho dự án chưa có.
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
	$main  = $main && preg_match( '/^[\p{Lu}\d]/u', $main ) ? $main : $name;
	$short = trim( preg_replace( '/\s+(Đà Nẵng|Da Nang|Danang|Hội An|Hoi An|Quảng Nam)$/iu', '', $main ) ) ?: $main;
	return implode( ',', array_unique( array( $main, 'giá ' . $short, 'bảng giá ' . $short ) ) );
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
		if ( '' === (string) get_post_meta( $id, 'rank_math_focus_keyword', true ) ) {
			update_post_meta( $id, 'rank_math_focus_keyword', hh_rm_project_keywords( get_post( $id ) ) );
		}
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
