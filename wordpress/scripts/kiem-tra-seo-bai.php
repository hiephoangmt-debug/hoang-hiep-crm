<?php
/**
 * Chấm bài theo các tiêu chí Rank Math TRƯỚC khi xuất / đăng (anh Hiệp 15/11/2026: "bài nào cũng phải chuẩn 100/100").
 * Dùng: php wordpress/scripts/kiem-tra-seo-bai.php <file data-bai-viet-*.php> [...] [--slug=a,b] [--all]
 *   Mặc định chỉ chấm bài có 'schedule' từ hôm nay trở đi (bài sắp đăng); --all chấm mọi bài; --slug chấm bài chỉ định.
 * Thoát mã 1 nếu còn bài trượt tiêu chí bắt buộc → routine phải sửa bài rồi chấm lại tới khi đạt.
 *
 * Tiêu chí (theo nhóm của Rank Math): ✔ bắt buộc, (!) khuyến nghị.
 *  SEO cơ bản: từ khoá trong tiêu đề SEO ✔, trong mô tả ✔, trong URL ✔, ở 10% đầu bài ✔, trong nội dung ✔, bài ≥ 800 từ ✔ (Rank Math cần ≥ 600).
 *  Bổ sung: từ khoá trong H2/H3 ✔, trong alt ảnh ✔, mật độ 1 – 2,5% ✔, URL ≤ 75 ký tự ✔, ≥ 1 liên kết ngoài dofollow ✔, ≥ 2 liên kết nội bộ ✔,
 *           từ khoá chính chưa dùng ở bài khác ✔.
 *  Tiêu đề: từ khoá ở nửa đầu tiêu đề SEO ✔, tiêu đề có con số ✔, ≤ 60 ký tự ✔. (Rank Math tiếng Việt không chấm power word / cảm xúc.)
 *  Dễ đọc: mỗi đoạn ≤ 120 từ ✔, có ảnh ✔.
 */
define( 'ABSPATH', __DIR__ . '/' );
$GLOBALS['hh_cb'] = array();
function add_filter( $hook, $cb ) { if ( 'hh_news_posts' === $hook ) { $GLOBALS['hh_cb'][] = $cb; } if ( 'hh_news_items' === $hook ) { $GLOBALS['hh_items_cb'][] = $cb; } }
$GLOBALS['hh_items_cb'] = array();
function add_action() {}
function wp_timezone_string() { return 'Asia/Ho_Chi_Minh'; }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }

$files = array(); $only = array(); $all = false;
foreach ( array_slice( $argv, 1 ) as $a ) {
	if ( 0 === strpos( $a, '--slug=' ) ) { $only = explode( ',', substr( $a, 7 ) ); }
	elseif ( '--all' === $a ) { $all = true; }
	else { $files[] = $a; }
}
foreach ( $files as $f ) { require $f; }
$posts = array();
foreach ( $GLOBALS['hh_cb'] as $cb ) { $posts = $cb( $posts ); }
// Như lúc web nhập: bài hạ tầng cố định + bản đồ từ khoá SEO (seo-tu-khoa.php ghi đè từ khoá / tiêu đề / mô tả theo slug).
if ( function_exists( 'hh_news_dataset' ) ) { $posts = array_merge( hh_news_dataset(), $posts ); }
require_once dirname( __DIR__ ) . '/wp-content/mu-plugins/hh-crm/seo-tu-khoa.php';
foreach ( $GLOBALS['hh_items_cb'] as $cb ) { $posts = $cb( $posts ); }

// Từ khoá chính đã dùng ở toàn bộ dữ liệu (để kiểm tra trùng).
$root = dirname( __DIR__ );
$used = array();
foreach ( glob( $root . '/wp-content/mu-plugins/hh-crm/*.php' ) as $f ) {
	if ( preg_match_all( "/'keyword'\\s*=>\\s*'([^']+)'/u", (string) file_get_contents( $f ), $m ) ) {
		foreach ( $m[1] as $k ) { $used[ mb_strtolower( $k ) ][] = basename( $f ); }
	}
}

function lc( $s ) { return mb_strtolower( html_entity_decode( strip_tags( (string) $s ), ENT_QUOTES, 'UTF-8' ) ); }
function words( $t ) { $t = trim( preg_replace( '/\s+/u', ' ', $t ) ); return '' === $t ? 0 : count( explode( ' ', $t ) ); }
function slugify( $s ) {
	$s = mb_strtolower( $s );
	$s = strtr( $s, array( 'đ' => 'd' ) );
	$s = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', \Normalizer::normalize( $s, \Normalizer::FORM_D ) );
	return trim( preg_replace( '/[^a-z0-9]+/', '-', $s ), '-' );
}

$today = gmdate( 'Y-m-d', time() + 7 * 3600 );
$fail  = 0; $n_checked = 0;
foreach ( $posts as $n ) {
	$slug = $n['slug'] ?? '';
	if ( $only ? ! in_array( $slug, $only, true ) : ( ! $all && ( empty( $n['schedule'] ) || substr( $n['schedule'], 0, 10 ) < $today ) ) ) {
		continue;
	}
	$n_checked++;
	$seo = $n['seo'] ?? ( function_exists( 'hh_news_seo' ) ? ( hh_news_seo()[ $slug ] ?? array() ) : array() );
	$kwr = trim( (string) ( $n['keyword'] ?? '' ) );
	$kw  = mb_strtolower( $kwr );
	// Nội dung như trên web: điểm chính + thân bài + hỏi đáp (giống hh_news_build_content).
	$html = '';
	if ( ! empty( $seo['points'] ) ) {
		$html .= '<p><strong>Điểm chính</strong></p><ul>' . implode( '', array_map( fn( $p ) => '<li>' . esc_html( $p ) . '</li>', $seo['points'] ) ) . '</ul>';
	}
	$html .= preg_replace( '/<!--hh-img:([^|]+)\|([^>]*)-->/u', '<img src="$1" alt="$2">', (string) ( $n['content'] ?? '' ) );
	foreach ( (array) ( $seo['faq'] ?? array() ) as $f ) {
		$html .= '<h3>' . esc_html( $f[0] ) . '</h3><p>' . esc_html( $f[1] ) . '</p>';
	}
	$text  = lc( preg_replace( '/<[^>]+>/', ' ', $html ) );
	$wc    = words( $text );
	$title = (string) ( $seo['seo_title'] ?? $n['title'] ?? '' );
	$desc  = (string) ( $seo['desc'] ?? '' );
	$r     = array();
	$t     = fn( $ok, $msg ) => $ok ? null : $msg;
	$r[] = $t( '' !== $kw, 'chưa có từ khoá chính' );
	$r[] = $t( false !== mb_strpos( lc( $title ), $kw ), 'tiêu đề SEO thiếu từ khoá' );
	$r[] = $t( false !== mb_strpos( lc( $desc ), $kw ), 'mô tả SEO thiếu từ khoá' );
	$r[] = $t( mb_strlen( $desc ) >= 120 && mb_strlen( $desc ) <= 160, 'mô tả nên 120 – 160 ký tự (' . mb_strlen( $desc ) . ')' );
	$r[] = $t( false !== strpos( $slug, slugify( $kwr ) ) || ! array_diff( explode( '-', slugify( $kwr ) ), explode( '-', $slug ) ), 'URL thiếu từ khoá (' . slugify( $kwr ) . ')' );
	$head = mb_substr( $text, 0, max( 120, (int) ( mb_strlen( $text ) * 0.1 ) ) );
	$r[] = $t( false !== mb_strpos( $head, $kw ), 'từ khoá chưa ở 10% đầu bài' );
	$r[] = $t( $wc >= 800, "bài $wc từ – cần ≥ 800 từ" );
	$hs  = preg_match_all( '/<h[23][^>]*>(.*?)<\/h[23]>/su', $html, $m ) ? array_map( 'lc', $m[1] ) : array();
	$r[] = $t( (bool) array_filter( $hs, fn( $h ) => false !== mb_strpos( $h, $kw ) ), 'chưa có H2/H3 chứa từ khoá' );
	$alts = preg_match_all( '/<img[^>]+alt="([^"]*)"/u', $html, $m ) ? array_map( 'lc', $m[1] ) : array();
	$alts[] = lc( $n['image_alt'] ?? '' );
	$r[] = $t( (bool) array_filter( $alts, fn( $a ) => false !== mb_strpos( $a, $kw ) ), 'chưa có ảnh với alt chứa từ khoá (chú thích <!--hh-img:...|...-->)' );
	$cnt = '' === $kw ? 0 : substr_count( $text, $kw );
	$den = $wc ? round( 100 * $cnt / $wc, 2 ) : 0; // cách Rank Math tính: số lần xuất hiện / tổng số từ.
	$r[] = $t( $den >= 1 && $den <= 2.5, "mật độ từ khoá $den% ($cnt lần) – cần 1 – 2,5%" );
	$url = 'https://hiephoangmt.com/' . $slug . '/';
	$r[] = $t( strlen( $url ) <= 75, 'URL dài ' . strlen( $url ) . ' ký tự – cần ≤ 75 (slug ≤ ' . ( 75 - 26 ) . ')' );
	preg_match_all( '/<a\s[^>]*href="([^"]+)"[^>]*>/u', $html, $m, PREG_SET_ORDER );
	$ext = $int = 0;
	foreach ( $m as $a ) {
		if ( preg_match( '#^https?://#', $a[1] ) && false === strpos( $a[1], 'hiephoangmt.com' ) ) { $ext += false === stripos( $a[0], 'nofollow' ) ? 1 : 0; }
		elseif ( '/' === ( $a[1][0] ?? '' ) || false !== strpos( $a[1], 'hiephoangmt.com' ) || '{' === ( $a[1][0] ?? '' ) ) { $int++; }
	}
	$srcs = array_filter( (array) ( $n['sources'] ?? array() ), fn( $u ) => (bool) preg_match( '#(\.gov\.vn|vnexpress\.net|tuoitre\.vn|thanhnien\.vn|baodautu\.vn|vneconomy\.vn|nhandan\.vn|cafef\.vn|cafeland\.vn|dantri\.com\.vn|baodanang\.vn|thuvienphapluat\.vn|luatvietnam\.vn|vietnamplus\.vn|laodong\.vn|tienphong\.vn|vov\.vn|nhadautu\.vn|baovanhoa\.vn|danangfantasticity\.com)#', (string) parse_url( $u, PHP_URL_HOST ) ) ); // web bỏ nofollow cho nguồn uy tín.
	$r[] = $t( $ext > 0 || $srcs, 'chưa có liên kết ngoài dofollow (thêm link nguồn báo chí / cổng nhà nước trong bài hoặc \'sources\')' );
	$r[] = $t( $int >= 2, "mới có $int liên kết nội bộ – cần ≥ 2" );
	$dup = array_diff( (array) ( $used[ $kw ] ?? array() ), array() );
	$r[] = $t( count( $dup ) <= 1, 'từ khoá chính đã dùng ở: ' . implode( ', ', array_unique( $dup ) ) );
	$pos = mb_strpos( lc( $title ), $kw );
	$r[] = $t( false !== $pos && $pos <= 2, 'từ khoá phải ở ĐẦU tiêu đề SEO' );
	$r[] = $t( (bool) preg_match( '/\d/', $title ), 'tiêu đề SEO nên có con số (năm, số liệu)' );
	$r[] = $t( mb_strlen( $title ) <= 60, 'tiêu đề SEO dài ' . mb_strlen( $title ) . ' ký tự – cần ≤ 60' );
	$longp = 0;
	if ( preg_match_all( '/<p[^>]*>(.*?)<\/p>/su', $html, $m ) ) {
		foreach ( $m[1] as $p ) { $longp += words( lc( $p ) ) > 120 ? 1 : 0; }
	}
	$r[] = $t( 0 === $longp, "$longp đoạn văn dài > 120 từ – tách ngắn" );
	$r[] = $t( false !== strpos( $html, '<img' ) || ! empty( $n['image'] ), 'chưa có ảnh trong bài' );
	$r = array_values( array_filter( $r ) );
	if ( $r ) {
		$fail++;
		echo "✗ $slug  [từ khoá: $kwr]\n   - " . implode( "\n   - ", $r ) . "\n";
	} else {
		echo "✓ $slug\n";
	}
}
echo "\nĐã chấm $n_checked bài, $fail bài chưa đạt.\n";

exit( $fail ? 1 : 0 );
