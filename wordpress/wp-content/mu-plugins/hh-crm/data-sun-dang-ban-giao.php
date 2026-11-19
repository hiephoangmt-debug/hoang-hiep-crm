<?php
/**
 * Sun Ponte Residence, Sun Symphony Residence: ĐANG BÀN GIAO (anh Hiệp xác nhận 19/11/2026).
 * Sun Ponte bắt đầu bàn giao căn hộ tòa tháp từ tháng 3/2026; Sun Symphony bàn giao căn hộ S1 – S3 từ tháng 5/2026 (theo báo chí).
 * Chỉ thay các ô còn giữ giá trị web nhập cũ (fix_meta), ô anh đã tự sửa thì không đè.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$enrich = function_exists( 'hh_project_enrichment' ) ? hh_project_enrichment() : array();
		foreach ( $projects as $i => $p ) {
			$slug = (string) ( $p['slug'] ?? '' );
			if ( ! in_array( $slug, array( 'sun-ponte-residence', 'sun-symphony-residence' ), true ) ) {
				continue;
			}
			$set = static function ( $key, $new, $olds ) use ( &$p ) {
				$cur  = (string) ( $p['meta'][ $key ] ?? '' );
				$olds = array_values( array_filter( array_unique( array_merge( array( $cur ), (array) $olds ) ), static fn( $v ) => '' !== $v && $v !== $new ) );
				$p['meta'][ $key ] = $new;
				if ( $olds ) {
					$p['fix_meta'][ $key ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), $olds ) ) );
				}
			};
			$prog = (string) ( $p['meta']['hh_p_progress'] ?? ( $enrich[ $slug ]['meta']['hh_p_progress'] ?? '' ) );
			if ( 'sun-ponte-residence' === $slug ) {
				$set( 'hh_p_status', 'dang-ban-giao', array( 'dang-mo-ban' ) );
				$set( 'hh_p_handover', 'Đang bàn giao căn hộ tòa tháp (bắt đầu từ tháng 3/2026)', array( 'Quý 3/2026 (dự kiến)' ) );
				$z = (string) ( $p['meta']['hh_p_zones'] ?? '' );
				if ( false !== strpos( $z, 'Bàn giao Quý 3/2026 (dự kiến)' ) ) {
					$set( 'hh_p_zones', str_replace( 'Bàn giao Quý 3/2026 (dự kiến)', 'Đang bàn giao (từ tháng 3/2026)', $z ), array() );
				}
				if ( '' !== $prog && false !== strpos( $prog, 'Hoàn tất bàn giao (dự kiến)' ) ) {
					$set( 'hh_p_progress', str_replace( 'Quý 3/2026 | Hoàn tất bàn giao (dự kiến)', '11/2026 | Đang bàn giao căn hộ cho khách hàng', $prog ), array() );
				}
			} else {
				$set( 'hh_p_status', 'dang-ban-giao', array( 'dang-mo-ban' ) );
				$set( 'hh_p_handover', 'Căn hộ S1, S2, S3: đang bàn giao (bắt đầu từ tháng 5/2026)', array( 'Thấp tầng: Quý 2/2025 · Căn hộ: Quý 1–2/2026 (dự kiến)' ) );
				if ( '' !== $prog && false !== strpos( $prog, 'Bàn giao căn hộ (kế hoạch' ) ) {
					$set( 'hh_p_progress', preg_replace( '/^Tháng 6\/2026 \| Bàn giao căn hộ \(kế hoạch[^\n]*$/m', "Tháng 5/2026 | Bắt đầu bàn giao căn hộ S1 – S3\n11/2026 | Đang bàn giao căn hộ cho khách hàng", $prog ), array() );
				}
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	80
);
