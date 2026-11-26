<?php
/**
 * Bổ sung thông tin 21 dự án từ các trang dự án trên web cũ của anh Hiệp (hoanggiaminh.com, anh Hiệp cho lấy 26/11/2026).
 * Dữ liệu ở bo-sung-du-an-11-2026.json: "add" chỉ điền ô đang trống; "replace" [cũ, mới] chỉ thay khi ô vẫn đúng bản cũ
 * (đã bị bộ lọc khác đổi thì giữ nguyên) và ghi fix_meta để web thay giá trị cũ đang có. Không đụng giá.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$raw  = file_get_contents( __DIR__ . '/bo-sung-du-an-11-2026.json' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$data = $raw ? json_decode( $raw, true ) : null;
		if ( ! is_array( $data ) ) {
			return $projects;
		}
		foreach ( $projects as $i => $p ) {
			$d = $data[ $p['slug'] ?? '' ] ?? null;
			if ( ! $d ) {
				continue;
			}
			foreach ( (array) ( $d['add'] ?? array() ) as $k => $v ) {
				if ( '' === trim( (string) ( $p['meta'][ $k ] ?? '' ) ) && '' !== trim( (string) $v ) ) {
					$projects[ $i ]['meta'][ $k ] = (string) $v;
				}
			}
			foreach ( (array) ( $d['replace'] ?? array() ) as $k => $pair ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( ! is_array( $pair ) || 2 !== count( $pair ) || $cur !== (string) $pair[0] ) {
					continue;
				}
				$projects[ $i ]['meta'][ $k ]     = (string) $pair[1];
				$projects[ $i ]['fix_meta'][ $k ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) ) ) );
			}
		}
		return $projects;
	},
	999
);
