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
				// [cũ, mới] hoặc [cũ, mới, [giá trị đã từng ghi lên web cần thay]].
				if ( ! is_array( $pair ) || count( $pair ) < 2 || $cur !== (string) $pair[0] ) {
					continue;
				}
				$projects[ $i ]['meta'][ $k ]     = (string) $pair[1];
				$projects[ $i ]['fix_meta'][ $k ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ), (array) ( $pair[2] ?? array() ) ) ) );
			}
		}
		// Ảnh lấy từ web cũ (bo-sung-anh-11-2026.json): nối thêm vào danh sách link ảnh của dự án.
		$raw  = file_get_contents( __DIR__ . '/bo-sung-anh-11-2026.json' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$imgs = $raw ? json_decode( $raw, true ) : null;
		foreach ( is_array( $imgs ) ? $projects : array() as $i => $p ) {
			$add = (array) ( $imgs[ $p['slug'] ?? '' ] ?? array() );
			if ( ! $add ) {
				continue;
			}
			$cur   = (string) ( $projects[ $i ]['meta']['hh_p_image_links'] ?? '' );
			$lines = array_filter( array_map( 'trim', explode( "\n", $cur ) ) );
			$keys  = array_map( static fn( $l ) => trim( explode( '|', $l )[0] ), $lines );
			foreach ( $add as $l ) {
				if ( ! in_array( trim( explode( '|', $l )[0] ), $keys, true ) ) {
					$lines[] = $l;
				}
			}
			$new = implode( "\n", $lines );
			if ( $new !== $cur ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = $new;
				if ( '' !== trim( $cur ) ) {
					$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $projects[ $i ]['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) ) ) );
				}
			}
		}
		return $projects;
	},
	999
);
