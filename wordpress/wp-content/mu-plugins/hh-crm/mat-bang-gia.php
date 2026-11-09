<?php
/**
 * Mặt bằng giá căn hộ Đà Nẵng 11/2026 – dùng chung cho bài so sánh và ô "Mặt bằng giá" trên trang từng dự án.
 * Nguồn: bảng hàng / bảng giá chủ đầu tư (ưu tiên), giá rao thứ cấp 7 – 10/2026, bản đồ giá Biggee.vn.
 */

defined( 'ABSPATH' ) || exit;

/** Bài so sánh đầy đủ. */
function hh_mat_bang_gia_url() {
	return home_url( '/mat-bang-gia-can-ho-da-nang-11-2026/' );
}

/** Mỗi dòng: slug dự án ('' nếu web chưa có trang), tên, giá thấp, giá cao (triệu/m²), nguồn. */
function hh_mat_bang_gia() {
	return array(
		array( 'the-legend-da-nang', 'The Legend', 119, 188, 'Bảng hàng chủ đầu tư 09/2026, gồm VAT & phí bảo trì' ),
		array( 'times-square-da-nang', 'Times Square', 150, 181, 'Bảng giá tầng 5 – 15' ),
		array( 'sun-solar-residence', 'Sun Solar', 117, 178, 'Bảng hàng quỹ đại lý tầng 7 – 19' ),
		array( 'nobu-da-nang', 'Nobu Residences', 151, 171, 'Giá rao thứ cấp 7 – 10/2026' ),
		array( 'capital-square-da-nang', 'Capital Square', 92, 146, 'Bảng hàng chủ đầu tư 09/2026, gồm VAT & phí bảo trì' ),
		array( 'the-poet-residence-da-nang', 'The Poet', 92, 139, 'Bảng hàng chủ đầu tư 01/09/2026, gồm VAT' ),
		array( 'sun-cosmo-residence', 'Sun Cosmo', 83, 130, 'Giá rao thứ cấp (ít tin)' ),
		array( 'sun-ponte-residence', 'Sun Ponte', 83, 130, 'Giá rao thứ cấp 7 – 10/2026' ),
		array( 'wyndham-soleil-da-nang', 'Wyndham Soleil', 74, 130, 'Giá rao thứ cấp 7 – 10/2026' ),
		array( 'newtown-diamond-da-nang', 'Newtown Diamond', 67, 120, 'Bảng hàng chủ đầu tư 09/2026, gồm VAT & phí bảo trì' ),
		array( 'sun-symphony-residence', 'Sun Symphony', 60, 120, 'Giá rao trên sàn 21/10/2026' ),
		array( 'sun-costa-residence', 'Sun Costa', 70, 105, 'Giá rao thứ cấp 7 – 10/2026' ),
		array( 'the-meridian-da-nang', 'The Meridian', 86, 89, 'Bản đồ giá Biggee.vn' ),
		array( 'peninsula-da-nang', 'Peninsula', 75, 83, 'Niêm yết chủ đầu tư 25/07/2026' ),
		array( 'cora-tower', 'Cora Tower', 59, 83, 'Bảng hàng 10/2026, gồm VAT & phí bảo trì' ),
		array( 'spana-tower', 'Spana Tower', 65, 73, 'Bảng hàng 10/2026, gồm VAT & phí bảo trì' ),
		array( 'the-monarchy-da-nang', 'The Monarchy', 59, 70, 'Bản đồ giá Biggee.vn' ),
		array( 's-light-tower', 'S-Light Tower', 58, 69, 'Bảng hàng 10/2026, gồm VAT & phí bảo trì' ),
		array( 'regal-complex-da-nang', 'Regal Complex', 62, 68, 'Bản đồ giá Biggee.vn' ),
		array( '', 'F.Home Apartment', 63, 66, 'Bản đồ giá Biggee.vn' ),
		array( 'muong-thanh-luxury-da-nang-can-ho', 'Chung cư Mường Thanh', 60, 64, 'Bản đồ giá Biggee.vn' ),
		array( 'ariyana-beach-resort-suites-da-nang', 'Furama Condotel', 59, 155, 'Bản đồ giá Biggee.vn' ),
		array( 'fours-tower', 'FourS Tower', 45, 68, 'Giá rao thứ cấp 7 – 10/2026' ),
		array( 'fpt-plaza-4', 'FPT Plaza 4', 56, 58, 'Bản đồ giá Biggee.vn' ),
		array( 'mia-center-point-da-nang', 'MIA Center Point', 48, 57, 'Giỏ hàng chủ đầu tư 1/2026, gồm VAT' ),
		array( 'fpt-plaza-3', 'FPT Plaza 3', 51, 55, 'Bản đồ giá Biggee.vn' ),
		array( '', 'Blue House', 45, 48, 'Bản đồ giá Biggee.vn' ),
		array( 'fpt-plaza-2', 'FPT Plaza 2', 45, 46, 'Bản đồ giá Biggee.vn' ),
		array( 'hoa-binh-green-da-nang', 'Hòa Bình Green', 35, 45, 'Bản đồ giá Biggee.vn' ),
		array( '', 'Hoàng Anh Gia Lai', 34, 39, 'Bản đồ giá Biggee.vn' ),
		array( 'the-ori-garden', 'The Ori Garden', 35, 37, 'Bản đồ giá Biggee.vn' ),
		array( 'ecohome-hoa-hiep-da-nang', 'Ecohome Hòa Hiệp', 21, 35, 'Bản đồ giá Biggee.vn' ),
	);
}

/** Trang con (tòa, phân khu) dùng giá của dự án chính. */
function hh_mat_bang_gia_slug( $slug ) {
	$map = array(
		'capital-square-' => 'capital-square-da-nang',
		'newtown-the-'    => 'newtown-diamond-da-nang',
		'fours-tower-'    => 'fours-tower',
		'the-sonata-sun-symphony'           => 'sun-symphony-residence',
		'symphony-5-sun-symphony-residence' => 'sun-symphony-residence',
		'the-rio-sun-ponte'                 => 'sun-ponte-residence',
		'peninsula-private-da-nang'         => 'peninsula-da-nang',
	);
	foreach ( $map as $pre => $to ) {
		if ( 0 === strpos( (string) $slug, $pre ) ) {
			return $to;
		}
	}
	return (string) $slug;
}

/**
 * Dòng giá của dự án + các dự án gần mức giá nhất để so sánh.
 *
 * @return array{row:array,near:array}|null
 */
function hh_mat_bang_gia_for( $slug, $n = 5 ) {
	$slug = hh_mat_bang_gia_slug( $slug );
	$rows = hh_mat_bang_gia();
	$me   = null;
	foreach ( $rows as $r ) {
		if ( $r[0] && $r[0] === $slug ) {
			$me = $r;
		}
	}
	if ( ! $me ) {
		return null;
	}
	// Không đưa vào phần so sánh: khoảng giá quá rộng (Furama Condotel 59 – 155).
	$rows = array_values( array_filter( $rows, static fn( $r ) => $r === $me || 'ariyana-beach-resort-suites-da-nang' !== $r[0] ) );
	$mid  = ( $me[2] + $me[3] ) / 2;
	usort( $rows, static fn( $a, $b ) => abs( ( $a[2] + $a[3] ) / 2 - $mid ) <=> abs( ( $b[2] + $b[3] ) / 2 - $mid ) );
	$near = array_slice( $rows, 0, $n );
	usort( $near, static fn( $a, $b ) => ( $b[2] + $b[3] ) <=> ( $a[2] + $a[3] ) );
	return array( 'row' => $me, 'near' => $near );
}
