<?php
/**
 * Đóng gói bài tin tức / dự án cho ô "Dự án → Nhập nhanh (bài / dự án)".
 * Dùng: php wordpress/scripts/dong-goi-bai.php bai.json [anh-dai-dien.jpg] > goi.txt
 * - Bài tin tức: slug, title, excerpt, keyword, keywords_extra[], category, tags[], content, seo{…}, sources[],
 *   follow_sources, image{name, alt, caption} (ảnh = tham số thứ 2 hoặc image.file).
 * - Dự án ("kind": "du-an"): slug, title, excerpt, content, types[], area, parent, meta{hh_p_*}, gallery_mode,
 *   images{ featured: {file, alt}, hh_p_gallery: [{file, alt}…], hh_p_masterplan_img: {file, alt} … }.
 * Đường dẫn "file" tính từ thư mục chứa bai.json; ảnh được nhúng base64 vào "data".
 */
if ( $argc < 2 ) {
	fwrite( STDERR, "Dùng: php dong-goi-bai.php bai.json [anh.jpg]\n" );
	exit( 1 );
}
$dir = dirname( realpath( $argv[1] ) );
$n   = json_decode( file_get_contents( $argv[1] ), true );
$is_project = is_array( $n ) && 'du-an' === ( $n['kind'] ?? '' );
if ( ! is_array( $n ) || empty( $n['slug'] ) || ( ! $is_project && ( empty( $n['title'] ) || empty( $n['content'] ) ) ) ) {
	fwrite( STDERR, "bai.json thiếu slug/title/content hoặc JSON lỗi\n" );
	exit( 1 );
}
$embed = static function ( $img ) use ( $dir ) {
	if ( empty( $img['file'] ) ) {
		return $img;
	}
	$path = '/' === $img['file'][0] ? $img['file'] : $dir . '/' . $img['file'];
	if ( ! is_file( $path ) ) {
		fwrite( STDERR, "Không thấy ảnh: $path\n" );
		exit( 1 );
	}
	$img['name'] = $img['name'] ?? pathinfo( $path, PATHINFO_FILENAME );
	$img['data'] = base64_encode( file_get_contents( $path ) );
	unset( $img['file'] );
	return $img;
};
if ( ! empty( $argv[2] ) ) {
	$n['image']         = (array) ( $n['image'] ?? array() );
	$n['image']['file'] = realpath( $argv[2] );
}
if ( ! empty( $n['image'] ) ) {
	$n['image'] = $embed( $n['image'] );
}
foreach ( (array) ( $n['images'] ?? array() ) as $key => $imgs ) {
	$n['images'][ $key ] = isset( $imgs['file'] ) ? $embed( $imgs ) : array_map( $embed, (array) $imgs );
}
echo chunk_split( 'HHBAI1:' . base64_encode( json_encode( $n, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ), 1000, "\n" );
