<?php
/**
 * Đóng gói bài cho ô "Dự án → Nhập bài nhanh".
 * Dùng: php wordpress/scripts/dong-goi-bai.php bai.json [anh.jpg] > goi-bai.txt
 * bai.json: slug, title, excerpt, keyword, keywords_extra[], category, tags[], content, seo{…}, sources[], follow_sources,
 * image{name, alt, caption}. Ảnh (tuỳ chọn) được nhúng base64 vào image.data.
 */
if ( $argc < 2 ) {
	fwrite( STDERR, "Dùng: php dong-goi-bai.php bai.json [anh.jpg]\n" );
	exit( 1 );
}
$n = json_decode( file_get_contents( $argv[1] ), true );
if ( ! is_array( $n ) || empty( $n['slug'] ) || empty( $n['title'] ) || empty( $n['content'] ) ) {
	fwrite( STDERR, "bai.json thiếu slug/title/content hoặc JSON lỗi\n" );
	exit( 1 );
}
if ( ! empty( $argv[2] ) ) {
	$n['image']         = (array) ( $n['image'] ?? array() );
	$n['image']['name'] = $n['image']['name'] ?? basename( $argv[2] );
	$n['image']['data'] = base64_encode( file_get_contents( $argv[2] ) );
}
echo chunk_split( 'HHBAI1:' . base64_encode( json_encode( $n, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ), 1000, "\n" );
