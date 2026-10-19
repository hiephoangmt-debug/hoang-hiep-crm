<?php
/**
 * Xuất bài trong file dữ liệu (data-bai-viet-*.php có 'schedule') thành gói HHBAI1 vào wordpress/tu-dong/bai/
 * và cập nhật wordpress/tu-dong/index.json – web đọc thư mục này để tự đăng (tu-dong-dang-bai.php).
 * Dùng: php wordpress/scripts/xuat-bai-tu-dong.php wordpress/wp-content/mu-plugins/hh-crm/data-bai-viet-sun-saphia-dot-1.php [...]
 */
define( 'ABSPATH', __DIR__ . '/' );
$GLOBALS['hh_cb'] = array();
function add_filter( $hook, $cb ) { if ( 'hh_news_posts' === $hook ) { $GLOBALS['hh_cb'][] = $cb; } }
function add_action() {}
$root  = dirname( __DIR__ );
$out   = $root . '/tu-dong';
$plug  = $root . '/wp-content/mu-plugins/hh-crm/';
@mkdir( $out . '/bai', 0755, true );
foreach ( array_slice( $argv, 1 ) as $f ) {
	require $f;
}
$posts = array();
foreach ( $GLOBALS['hh_cb'] as $cb ) {
	$posts = $cb( $posts );
}
$index = is_file( $out . '/index.json' ) ? json_decode( file_get_contents( $out . '/index.json' ), true ) : array( 'posts' => array() );
$by    = array();
foreach ( (array) $index['posts'] as $p ) {
	$by[ $p['slug'] ] = $p;
}
foreach ( $posts as $n ) {
	if ( empty( $n['schedule'] ) ) {
		continue;
	}
	$img = $n['image'] ?? '';
	if ( is_string( $img ) && 0 === strpos( $img, 'plugin:' ) ) {
		$path = $plug . substr( $img, 7 );
		if ( ! is_file( $path ) ) {
			fwrite( STDERR, "Thiếu ảnh $path\n" );
			exit( 1 );
		}
		$n['image'] = array( 'name' => pathinfo( $path, PATHINFO_FILENAME ), 'alt' => $n['image_alt'] ?? $n['title'], 'caption' => $n['image_caption'] ?? '', 'data' => base64_encode( file_get_contents( $path ) ) );
	}
	$pub = strlen( $n['schedule'] ) <= 10 ? $n['schedule'] . ' 08:00' : $n['schedule'];
	unset( $n['schedule'], $n['week'] );
	$file = 'bai/' . $n['slug'] . '.txt';
	file_put_contents( $out . '/' . $file, chunk_split( 'HHBAI1:' . base64_encode( json_encode( $n, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ), 1000, "\n" ) );
	$by[ $n['slug'] ] = array( 'slug' => $n['slug'], 'title' => $n['title'], 'publish' => $pub, 'file' => $file );
	echo "$pub  {$n['slug']}\n";
}
uasort( $by, static fn( $a, $b ) => strcmp( $a['publish'], $b['publish'] ) );
file_put_contents( $out . '/index.json', json_encode( array( 'updated' => gmdate( 'c' ), 'posts' => array_values( $by ) ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "\n" );
