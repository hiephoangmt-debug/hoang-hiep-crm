<?php
/**
 * Chiết khấu thanh toán sớm (TTS) tháng 12/2026 các dự án Sun Group Đà Nẵng – chủ đầu tư thông báo 25/11/2026,
 * điều chỉnh DUY NHẤT mức TTS trong tháng 12/2026 (thanh toán muộn nhất 25/12/2026); các ưu đãi khác giữ nguyên.
 * Chạy sau mọi bộ lọc dữ liệu dự án khác (ưu tiên 99): thay dòng "Thanh toán sớm …" trong Chính sách bán hàng
 * và các dòng "Thanh toán sớm …" trong Bảng chiết khấu; giá trị đang có trên web được phép thay (fix_meta).
 * Không ghi hoa hồng đại lý, mã căn.
 */

defined( 'ABSPATH' ) || exit;

/** slug => [ [ nhóm (rỗng nếu chung), [ [mức, %], … ] ], … ]. */
function hh_sun_tts_12_2026() {
	$f15 = array(
		array( 'Căn ký thủ tục trước 08/8/2026', array( array( '95%', '12%' ), array( '70%', '5%' ), array( '50%', '1,5%' ) ) ),
		array( 'Căn ký thủ tục từ 08/8/2026', array( array( '95%', '8,5%' ), array( '70%', '2%' ) ) ),
	);
	$f2  = array( array( 'Tòa F2', array( array( '95%', '10,5%' ), array( '70%', '4%' ), array( '50%', '1,5%' ) ) ) );
	return array(
		'symphony-5-sun-symphony-residence' => array( array( '', array( array( '95%', '9,5%' ), array( '70%', '2,5%' ) ) ) ),
		'fours-tower-f1-thap-tung'          => $f15,
		'fours-tower-f5-thap-cuc'           => $f15,
		'fours-tower-f2-thap-mai'           => array( array( '', $f2[0][1] ) ),
		'fours-tower'                       => array( array( 'Tòa F1, F5 – ' . mb_strtolower( $f15[0][0] ), $f15[0][1] ), array( 'Tòa F1, F5 – ' . mb_strtolower( $f15[1][0] ), $f15[1][1] ), $f2[0] ),
		'spana-tower'                       => array( array( '', array( array( '95%', '5,5%' ) ) ) ),
		'cora-tower'                        => array( array( 'Căn hộ & shop khối đế', array( array( '95%', '7%' ), array( '70%', '1%' ) ) ) ),
		's-light-tower'                     => array( array( '', array( array( '95%', '9,5%' ), array( '70%', '2,5%' ) ) ) ),
		'sun-solar-residence'               => array( array( '', array( array( '95%', '9%' ), array( '70%', '3,5%' ), array( '50%', '1,5%' ) ) ) ),
		'sun-symphony-residence'            => array(
			array( 'Căn hộ Symphony 1, 2, 3', array( array( '95%', '8,5%' ) ) ),
			array( 'Shop khối đế Symphony 1, 2, 3', array( array( '95%', '10,5%' ), array( '70%', '5,5%' ), array( '50%', '4%' ) ) ),
		),
		'the-sonata-sun-symphony'           => array( array( '', array( array( '95%', '3,5%' ) ) ) ),
		'sun-cosmo-residence'               => array( array( 'Shop khối đế The Panoma', array( array( '95%', '6,5%' ), array( '70%', '1,5%' ) ) ) ),
	);
}

/** Dòng chính sách: "Thanh toán sớm tháng 12/2026 (hạn 25/12)[ – nhóm]: 95% chiết khấu 9,5% · 70% chiết khấu 2,5%". */
function hh_sun_tts_12_lines( $groups ) {
	$out = array();
	foreach ( $groups as $g ) {
		$parts = array();
		foreach ( $g[1] as $r ) {
			$parts[] = $r[0] . ' chiết khấu ' . $r[1];
		}
		$out[] = 'Thanh toán sớm tháng 12/2026 (hạn 25/12)' . ( '' !== $g[0] ? ' – ' . $g[0] : '' ) . ': ' . implode( ' · ', $parts );
	}
	return $out;
}

/** Dòng bảng chiết khấu: "Phương án | Hạn thanh toán | Chiết khấu | Cách tính". */
function hh_sun_tts_12_rows( $groups ) {
	$out = array();
	foreach ( $groups as $g ) {
		foreach ( $g[1] as $r ) {
			$out[] = 'Thanh toán sớm ' . $r[0] . ( '' !== $g[0] ? ' (' . $g[0] . ')' : '' ) . ' | Trước 25/12/2026 | ' . $r[1] . ' thanh toán sớm | Cộng dồn với ưu đãi khác đang áp dụng theo phiếu tính giá';
		}
	}
	return $out;
}

/** Thay các dòng "Thanh toán sớm …" (không đụng "Thanh toán sớm hơn tiến độ …") bằng dòng mới. */
function hh_sun_tts_12_swap( $text, $new, $before = 'Thông tin tham khảo' ) {
	$lines = preg_split( '/\r\n|\n/', (string) $text );
	$keep  = array();
	$at    = null;
	foreach ( $lines as $l ) {
		if ( preg_match( '/^\s*Thanh toán sớm(?! hơn)/u', $l ) ) {
			$at = null === $at ? count( $keep ) : $at;
			continue;
		}
		$keep[] = $l;
	}
	if ( null === $at ) {
		$at = count( $keep );
		foreach ( $keep as $i => $l ) {
			if ( 0 === strpos( $l, $before ) ) {
				$at = $i;
				break;
			}
		}
	}
	array_splice( $keep, $at, 0, $new );
	$out = implode( "\n", array_filter( $keep, static fn( $l ) => '' !== trim( $l ) ) );
	return str_replace( 'Thông tin tham khảo 11/2026', 'Thông tin tham khảo 12/2026', $out );
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$all = hh_sun_tts_12_2026();
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( empty( $all[ $slug ] ) ) {
				continue;
			}
			foreach ( array(
				'hh_p_policy'         => hh_sun_tts_12_lines( $all[ $slug ] ),
				'hh_p_discount_table' => hh_sun_tts_12_rows( $all[ $slug ] ),
			) as $key => $new ) {
				$cur = (string) ( $p['meta'][ $key ] ?? '' );
				if ( 'hh_p_discount_table' === $key && '' === trim( $cur ) ) {
					continue; // Dự án chưa có bảng chiết khấu: chỉ ghi trong chính sách.
				}
				$val = hh_sun_tts_12_swap( $cur, $new );
				if ( $val === $cur ) {
					continue;
				}
				$projects[ $i ]['meta'][ $key ] = $val;
				$old = array_filter( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), '' !== $cur ? array( $cur ) : array() ) );
				if ( $old ) {
					$projects[ $i ]['fix_meta'][ $key ] = array_values( array_unique( $old ) );
				}
			}
		}
		return $projects;
	},
	99
);
