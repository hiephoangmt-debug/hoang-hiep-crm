<?php
/**
 * Sun Ponte Residence – ảnh thực tế 11/2026 (flycam anh Hiệp gửi 04/11/2026): tòa tháp hoàn thiện mặt ngoài, nhà phố The Rio
 * ven sông đang hoàn thiện. Thêm vào "Ảnh tiến độ thực tế" và một dòng bảng tiến độ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$line = 'plugin:img/sun-ponte/sun-ponte-thuc-te-11-2026-flycam-cau-rong.jpg | Ảnh thực tế Sun Ponte Residence 11/2026: tòa tháp hoàn thiện mặt ngoài bên sông Hàn, cạnh cầu Rồng; nhà phố The Rio đang hoàn thiện | tiến độ';
		$row  = '11/2026 | Ảnh flycam thực tế: tòa tháp The Ponte đã hoàn thiện mặt ngoài; dãy nhà phố, biệt thự The Rio ven sông đang hoàn thiện';
		foreach ( $projects as $i => $p ) {
			if ( 'sun-ponte-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, 'thuc-te-11-2026' ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . $line );
				if ( '' !== $cur ) {
					$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
				}
			}
			// Bảng tiến độ gốc nằm ở data-du-an-chi-tiet.php (gộp vào sau) → lấy ra để nối thêm dòng mới.
			$prog = (string) ( $p['meta']['hh_p_progress'] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['sun-ponte-residence']['meta']['hh_p_progress'] ?? '' ) : '' ) );
			if ( false === strpos( $prog, '11/2026' ) ) {
				$projects[ $i ]['meta']['hh_p_progress'] = trim( $prog . "\n" . $row );
				if ( '' !== $prog ) {
					$projects[ $i ]['fix_meta']['hh_p_progress'] = array_merge( (array) ( $p['fix_meta']['hh_p_progress'] ?? array() ), array( $prog ) );
				}
			}
		}
		return $projects;
	},
	70 // Sau bộ ảnh chủ đầu tư (60).
);
