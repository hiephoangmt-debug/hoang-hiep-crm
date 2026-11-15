<?php
/**
 * Chuẩn SEO bài viết theo bộ chấm Rank Math (anh Hiệp 15/11/2026: "các bài viết không được chuẩn SEO", bài mẫu 29/100).
 * Với từ khoá chính (từ khoá đầu tiên trong ô Rank Math) của mỗi bài:
 *  1. Tiêu đề SEO chưa có từ khoá → "{Từ khoá}: {phần còn lại}" (≤ 60 ký tự, từ khoá ở đầu tiêu đề).
 *  2. Mô tả SEO chưa có từ khoá → "{Từ khoá}: {mô tả}" (≤ 160 ký tự).
 *  3. Từ khoá chưa có ở đầu nội dung → khung "Điểm chính" đổi thành "Điểm chính về {từ khoá}" (bài không có khung: thêm từ khoá in đậm vào đầu đoạn đầu).
 *  4. Cuối bài thêm mục "Đọc thêm về {từ khoá}": 5 bài cùng dự án / chuyên mục (liên kết nội bộ, tiêu đề phụ có từ khoá, bài đủ dài hơn).
 *  5. Liên kết nguồn báo chí / cơ quan nhà nước / chủ đầu tư bỏ nofollow (Rank Math: cần ít nhất 1 liên kết ra ngoài dofollow);
 *     trang dự án thêm mục "Nguồn tham khảo" (chỉ nguồn uy tín, không đưa trang đơn vị phân phối).
 * Chỉ sửa bài web tự tạo chưa bị sửa tay (nội dung khớp _hh_news_hash); ô SEO chỉ sửa khi đang thiếu từ khoá. Chạy dần cho bài cũ,
 * và chạy ngay sau khi Nhập nhanh / tự đăng / nhập dữ liệu tạo bài mới.
 */

defined( 'ABSPATH' ) || exit;

const HH_SEO_POST_FIX_V = 1;

/** Nguồn uy tín được để dofollow: cổng nhà nước, báo chí lớn, văn bản pháp luật, chủ đầu tư. */
function hh_seo_trusted_host( $host ) {
	$host = preg_replace( '/^www\./', '', strtolower( (string) $host ) );
	if ( '' === $host ) {
		return false;
	}
	if ( preg_match( '/(^|\.)gov\.vn$/', $host ) ) {
		return true;
	}
	$ok = array( 'vnexpress.net', 'tuoitre.vn', 'thanhnien.vn', 'baodautu.vn', 'vneconomy.vn', 'nhandan.vn', 'cafef.vn', 'cafeland.vn', 'dantri.com.vn', 'baodanang.vn', 'danangfantasticity.com', 'thuvienphapluat.vn', 'luatvietnam.vn', 'vietnamplus.vn', 'laodong.vn', 'tienphong.vn', 'vov.vn', 'baochinhphu.vn', 'nld.com.vn', 'znews.vn', 'plo.vn', 'nhadautu.vn', 'baovanhoa.vn', 'vtv.vn', 'vietnamnet.vn', 'sggp.org.vn', 'qdnd.vn', 'baodauthau.vn', 'doanhnhan.baophapluat.vn', 'baophapluat.vn', 'tapchicongthuong.vn', 'sungroup.com.vn', 'sunproperty.com.vn', 'nobudanang.vn' );
	foreach ( $ok as $d ) {
		if ( $host === $d || str_ends_with( $host, '.' . $d ) ) {
			return true;
		}
	}
	return false;
}

/** Bỏ nofollow ở liên kết tới nguồn uy tín. */
function hh_seo_follow_trusted( $html ) {
	return preg_replace_callback(
		'/<a\s[^>]*href="(https?:\/\/[^"]+)"[^>]*>/i',
		static function ( $m ) {
			if ( false === stripos( $m[0], 'nofollow' ) || ! hh_seo_trusted_host( wp_parse_url( html_entity_decode( $m[1] ), PHP_URL_HOST ) ) ) {
				return $m[0];
			}
			$t = preg_replace( '/\brel="([^"]*)"/i', 'rel="__REL__$1"', $m[0] );
			return preg_replace_callback( '/rel="__REL__([^"]*)"/', static fn( $r ) => 'rel="' . trim( preg_replace( '/\s+/', ' ', str_ireplace( 'nofollow', '', $r[1] ) ) ) . '"', $t );
		},
		(string) $html
	);
}

/** Mục "Nguồn tham khảo" của trang dự án (chỉ nguồn uy tín, dofollow). */
function hh_project_sources_html( $id ) {
	$urls = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( $id, 'hh_p_sources', true ) ) ) );
	$lis  = '';
	foreach ( array_unique( $urls ) as $u ) {
		$host = (string) wp_parse_url( $u, PHP_URL_HOST );
		if ( hh_seo_trusted_host( $host ) ) {
			$lis .= '<li><a href="' . esc_url( $u ) . '" rel="noopener" target="_blank">' . esc_html( preg_replace( '/^www\./', '', $host ) ) . '</a></li>';
		}
	}
	return $lis ? '<div class="project-sources"><h2>Nguồn tham khảo về ' . esc_html( get_the_title( $id ) ) . '</h2><ul>' . $lis . '</ul></div>' : '';
}
add_filter(
	'the_content',
	static function ( $c ) {
		if ( is_admin() || ! is_singular( 'du-an' ) || ! in_the_loop() && ! did_action( 'loop_start' ) || false !== strpos( $c, 'project-sources' ) ) {
			return $c;
		}
		return $c . hh_project_sources_html( get_the_ID() );
	},
	60
);

function hh_seo_lc( $s ) {
	return mb_strtolower( html_entity_decode( wp_strip_all_tags( (string) $s ), ENT_QUOTES, 'UTF-8' ) );
}

function hh_seo_has( $hay, $kw ) {
	return '' !== $kw && false !== mb_strpos( hh_seo_lc( $hay ), $kw );
}

function hh_seo_ucfirst( $s ) {
	return mb_strtoupper( mb_substr( $s, 0, 1 ) ) . mb_substr( $s, 1 );
}

/** Cắt theo từ, không vượt $max ký tự. */
function hh_seo_cut( $s, $max, $tail = '' ) {
	$s = trim( $s );
	if ( mb_strlen( $s ) <= $max ) {
		return $s;
	}
	$out = '';
	foreach ( preg_split( '/\s+/u', $s ) as $w ) {
		if ( mb_strlen( trim( $out . ' ' . $w ) ) + mb_strlen( $tail ) > $max ) {
			break;
		}
		$out = trim( $out . ' ' . $w );
	}
	return rtrim( $out, ' ,:;–-' ) . $tail;
}

/** "{Từ khoá}: {phần còn lại của tiêu đề}" – bỏ các từ đầu tiêu đề đã nằm trong từ khoá để khỏi lặp. */
function hh_seo_title_with_kw( $title, $kw_raw ) {
	$kwc   = hh_seo_ucfirst( trim( $kw_raw ) );
	$kw_w  = array_flip( preg_split( '/\s+/u', mb_strtolower( $kwc ) ) );
	$words = preg_split( '/\s+/u', trim( (string) $title ) );
	while ( $words && isset( $kw_w[ mb_strtolower( trim( $words[0], ' ,:;–-?' ) ) ] ) ) {
		array_shift( $words );
	}
	$rest  = trim( ltrim( implode( ' ', $words ), ' ,:;–-' ) );
	// Ứng viên phần sau: cả phần còn lại, rồi từng vế (tách theo : – ? ,) – lấy vế đầu tiên vừa khung 60 ký tự, không cắt giữa chừng.
	$segs  = array_values( array_filter( array_map( static fn( $x ) => trim( $x, ' ,:;–-' ), preg_split( '/\s*[:–?]\s*/u', $rest ) ), static fn( $x ) => mb_strlen( $x ) >= 8 ) );
	$order = array_merge( array_slice( $segs, 1 ), array_slice( $segs, 0, 1 ) ); // ưu tiên vế mô tả phía sau dấu ":".
	$cands = array( $rest );
	foreach ( $order as $seg ) {
		$cands[] = $seg;
		$cands[] = trim( explode( ',', $seg )[0] ); // vế quá dài: lấy đến dấu phẩy đầu.
	}
	$cands = array_filter( $cands, static fn( $x ) => mb_strlen( $x ) >= 8 && ! hh_seo_has( $x, mb_strtolower( $kwc ) ) );
	foreach ( $cands as $cand ) {
		if ( '' !== $cand && mb_strlen( $kwc . ': ' . $cand ) <= 60 ) {
			return $kwc . ': ' . $cand;
		}
	}
	return mb_strlen( $kwc . ' | Hoàng Hiệp' ) <= 60 ? $kwc . ' | Hoàng Hiệp' : hh_seo_cut( $kwc, 60 );
}

/** Mục "Đọc thêm" – 5 bài liên quan đã đăng. */
function hh_seo_related_block( $id, $kw_raw ) {
	$args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		'post__not_in'   => array( $id ),
		'no_found_rows'  => true,
		'fields'         => 'ids',
	);
	$proj = (int) get_post_meta( $id, 'hh_post_project', true );
	$ids  = $proj ? get_posts( $args + array( 'meta_key' => 'hh_post_project', 'meta_value' => $proj ) ) : array(); // phpcs:ignore WordPress.DB.SlowDBQuery
	if ( count( $ids ) < 5 ) {
		$cats = wp_get_post_categories( $id );
		if ( $cats ) {
			$more = get_posts( array_merge( $args, array( 'category__in' => $cats, 'post__not_in' => array_merge( array( $id ), $ids ), 'posts_per_page' => 5 - count( $ids ) ) ) );
			$ids  = array_merge( $ids, $more );
		}
	}
	$lis = '';
	foreach ( $ids as $rid ) {
		$lis .= '<li><a href="' . esc_url( get_permalink( $rid ) ) . '">' . esc_html( get_the_title( $rid ) ) . '</a></li>';
	}
	$pl = '';
	if ( $proj && 'publish' === get_post_status( $proj ) ) {
		$pl = '<p>Thông tin đầy đủ về dự án: <a href="' . esc_url( get_permalink( $proj ) ) . '">' . esc_html( get_the_title( $proj ) ) . '</a> – mặt bằng, giá tham khảo, pháp lý, tiến độ. Cần tư vấn thêm, liên hệ Hoàng Hiệp 0904 567 009 (gọi/Zalo).</p>';
	}
	if ( '' === $lis && '' === $pl ) {
		return '';
	}
	return "\n<!--hh-seo-doc-them-->\n<h2>Đọc thêm về " . esc_html( trim( $kw_raw ) ) . "</h2>\n" . $pl . ( $lis ? "\n<ul>" . $lis . "</ul>\n" : '' );
}

/** Sửa một bài. Trả về mảng các mục đã sửa. */
function hh_seo_post_fix( $id ) {
	$post = get_post( $id );
	if ( ! $post || 'post' !== $post->post_type ) {
		return array();
	}
	$kws    = (string) get_post_meta( $id, 'rank_math_focus_keyword', true );
	$kw_raw = trim( (string) strtok( $kws, ',' ) );
	$kw     = mb_strtolower( $kw_raw );
	$done   = array();
	if ( '' === $kw ) {
		update_post_meta( $id, '_hh_seo_fix_v', HH_SEO_POST_FIX_V );
		return $done;
	}
	// 1. Tiêu đề SEO.
	$t = (string) get_post_meta( $id, 'rank_math_title', true );
	if ( ! hh_seo_has( '' !== $t ? $t : $post->post_title, $kw ) || ( '' !== $t && 0 !== mb_strpos( hh_seo_lc( $t ), $kw ) && mb_strlen( $t ) > 60 ) ) {
		$new = hh_seo_title_with_kw( '' !== $t ? $t : $post->post_title, $kw_raw );
		update_post_meta( $id, 'rank_math_title', $new );
		$done[] = 'title';
	}
	// 2. Mô tả SEO.
	$desc = (string) get_post_meta( $id, 'rank_math_description', true );
	if ( '' === $desc ) {
		$desc = wp_strip_all_tags( $post->post_excerpt );
	}
	if ( ! hh_seo_has( $desc, $kw ) ) {
		update_post_meta( $id, 'rank_math_description', hh_seo_cut( hh_seo_ucfirst( $kw_raw ) . ': ' . $desc, 160, '…' ) );
		$done[] = 'desc';
	}
	// 3 – 4. Nội dung: chỉ bài web tự tạo, chưa sửa tay.
	$c      = (string) $post->post_content;
	$hash   = (string) get_post_meta( $id, '_hh_news_hash', true );
	$auto   = '' !== $hash && md5( $c ) === $hash;
	if ( $auto ) {
		$nc   = $c;
		$text = hh_seo_lc( $nc );
		$head = mb_substr( $text, 0, max( 120, (int) ( mb_strlen( $text ) * 0.1 ) ) );
		if ( false === mb_strpos( $head, $kw ) ) {
			if ( false !== strpos( $nc, '<p><strong>Điểm chính</strong></p>' ) ) {
				$nc = str_replace( '<p><strong>Điểm chính</strong></p>', '<p><strong>Điểm chính về ' . esc_html( $kw_raw ) . '</strong></p>', $nc );
			} else {
				$nc = preg_replace( '/<p>/', '<p><strong>' . esc_html( hh_seo_ucfirst( $kw_raw ) ) . '</strong>: ', $nc, 1 );
			}
			$done[] = 'intro';
		}
		$f = hh_seo_follow_trusted( $nc );
		if ( $f !== $nc ) {
			$nc     = $f;
			$done[] = 'follow';
		}
		if ( false === strpos( $nc, '<!--hh-seo-doc-them-->' ) ) {
			$block = hh_seo_related_block( $id, $kw_raw );
			if ( '' !== $block ) {
				// Đặt trước dòng nguồn (nếu có) để nguồn vẫn ở cuối bài.
				$pos = strrpos( $nc, '<p class="src">' );
				$nc  = false === $pos ? $nc . $block : substr( $nc, 0, $pos ) . $block . "\n" . substr( $nc, $pos );
				$done[] = 'related';
			}
		}
		if ( $nc !== $c ) {
			wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $nc ) ) );
			update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
			clean_post_cache( $id );
			do_action( 'litespeed_purge_post', $id );
		}
	}
	update_post_meta( $id, '_hh_seo_fix_v', HH_SEO_POST_FIX_V );
	return $done;
}

/** Chạy dần cho các bài chưa xử lý. */
function hh_seo_post_fix_run( $seconds = 10 ) {
	if ( get_transient( 'hh_seo_fix_lock' ) ) {
		return;
	}
	set_transient( 'hh_seo_fix_lock', 1, 60 );
	$ids   = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'future' ),
			'posts_per_page' => 60,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				'relation' => 'OR',
				array( 'key' => '_hh_seo_fix_v', 'compare' => 'NOT EXISTS' ),
				array( 'key' => '_hh_seo_fix_v', 'value' => HH_SEO_POST_FIX_V, 'compare' => '<', 'type' => 'NUMERIC' ),
			),
		)
	);
	$start = microtime( true );
	foreach ( $ids as $id ) {
		if ( microtime( true ) - $start > $seconds ) {
			break;
		}
		hh_seo_post_fix( $id );
	}
	delete_transient( 'hh_seo_fix_lock' );
	if ( count( $ids ) >= 60 || microtime( true ) - $start > $seconds ) {
		wp_schedule_single_event( time() + 120, 'hh_seo_post_fix_cron' );
	}
}
add_action( 'hh_seo_post_fix_cron', static fn() => hh_seo_post_fix_run( 20 ) );
add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || ! current_user_can( 'edit_posts' ) || get_option( 'hh_seo_fix_pass' ) === HH_CRM_VERSION ) {
			return;
		}
		hh_seo_post_fix_run( 8 );
		if ( ! wp_next_scheduled( 'hh_seo_post_fix_cron' ) ) {
			update_option( 'hh_seo_fix_pass', HH_CRM_VERSION, false );
		}
	},
	45
);
// Bài mới được tạo / tự đăng: xử lý sau khi các ô Rank Math đã được ghi.
add_action( 'hh_quick_post_created', 'hh_seo_post_fix' );
add_action(
	'transition_post_status',
	static function ( $new, $old, $post ) {
		if ( 'publish' === $new && 'publish' !== $old && 'post' === $post->post_type && ! wp_next_scheduled( 'hh_seo_post_fix_cron' ) ) {
			wp_schedule_single_event( time() + 60, 'hh_seo_post_fix_cron' );
			update_option( 'hh_seo_fix_pass', '', false );
		}
	},
	10,
	3
);
