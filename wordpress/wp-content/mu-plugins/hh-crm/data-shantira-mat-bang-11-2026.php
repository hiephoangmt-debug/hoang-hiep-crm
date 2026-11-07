<?php
/**
 * Shantira Beach Resort & Spa – mặt bằng tầng và layout căn hộ anh Hiệp gửi 07/11/2026 (tài liệu của Hoi An Royal Group):
 * 4 mặt bằng tầng (tầng 2 tòa A, tầng 2 tòa B, tầng 3 – 5A – 5 và tầng 6 – 11 hai tòa) và 2 bản layout điều chỉnh căn 01, 02 tòa A (bản mới nhất, bỏ các bản trùng).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$l    = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/shantira/shantira-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );
		$imgs = array(
			$l( 'mat-bang-tang-2-toa-a', 'Mặt bằng tầng 2 tòa A Shantira: căn studio, 1PN, 2PN hình chữ V hướng biển', 'mặt bằng', 'Tầng 2 – tòa A' ),
			$l( 'mat-bang-tang-2-toa-b', 'Mặt bằng tầng 2 tòa B Shantira: căn studio, 1PN, 2PN', 'mặt bằng', 'Tầng 2 – tòa B' ),
			$l( 'mat-bang-tang-3-5a-5-toa-a-b', 'Mặt bằng tầng 3, 5A, 5 tòa A và B Shantira', 'mặt bằng', 'Tầng 3 – 5A – 5' ),
			$l( 'mat-bang-tang-6-11-toa-a-b', 'Mặt bằng tầng 6 – 11 tòa A và B Shantira: thêm căn 3PN đầu hồi nhìn biển', 'mặt bằng', 'Tầng 6 – 11' ),
			$l( 'layout-can-02-tang-2-3-5a-5-toa-a', 'Layout căn 1PN (41 m²) và studio (26,8 m²) tách từ căn 02 tầng 2, 3, 5A, 5 tòa A Shantira', 'layout', '1PN + studio' ),
			$l( 'layout-can-01-02-tang-6-7-9-toa-a', 'Layout căn 2PN (55,7 m²), 1PN (37,6 m²) và studio (26,2 – 27,4 m²) tầng 6, 7, 9 tòa A Shantira', 'layout', '2PN, 1PN, studio' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'shantira-beach-resort-hoi-an' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $cur;
			$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	99
);
