<?php
/**
 * IndexNow: báo ngay cho Bing (và Yandex, Naver, Seznam…) mỗi khi đăng / cập nhật bài, dự án, tin nhà đất, trang.
 * Bing là nguồn tìm kiếm của ChatGPT, Copilot. (Google không dùng IndexNow – Google đọc sơ đồ trang.)
 * - Khoá tự tạo, phục vụ tại https://{web}/{khoá}.txt.
 * - Lần đầu sau khi cài: gửi một lượt toàn bộ đường dẫn đang đăng.
 */

defined( 'ABSPATH' ) || exit;

function hh_indexnow_key() {
	$key = (string) get_option( 'hh_indexnow_key', '' );
	if ( ! preg_match( '/^[a-f0-9]{32}$/', $key ) ) {
		$key = md5( wp_generate_uuid4() . home_url() );
		update_option( 'hh_indexnow_key', $key, false );
	}
	return $key;
}

/** Chỉ gửi từ web thật (không gửi từ bản chạy thử). */
function hh_indexnow_enabled() {
	$host = (string) wp_parse_url( home_url(), PHP_URL_HOST );
	return (bool) apply_filters( 'hh_indexnow_enabled', 'hiephoangmt.com' === preg_replace( '/^www\./', '', $host ) );
}

/** Tệp khoá /{khoá}.txt. */
add_action(
	'init',
	static function () {
		$path = (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$key  = (string) get_option( 'hh_indexnow_key', '' );
		if ( '' !== $key && '/' . $key . '.txt' === $path ) {
			nocache_headers();
			header( 'Content-Type: text/plain; charset=utf-8' );
			echo $key; // phpcs:ignore WordPress.Security.EscapeOutput
			exit;
		}
	},
	0
);

function hh_indexnow_send( array $urls ) {
	$urls = array_values( array_unique( array_filter( $urls ) ) );
	if ( ! $urls || ! hh_indexnow_enabled() ) {
		return;
	}
	$key = hh_indexnow_key();
	foreach ( array_chunk( $urls, 9000 ) as $chunk ) {
		$res = wp_remote_post(
			'https://api.indexnow.org/indexnow',
			array(
				'timeout'  => 8,
				'blocking' => true,
				'headers'  => array( 'Content-Type' => 'application/json; charset=utf-8' ),
				'body'     => wp_json_encode(
					array(
						'host'        => wp_parse_url( home_url(), PHP_URL_HOST ),
						'key'         => $key,
						'keyLocation' => home_url( '/' . $key . '.txt' ),
						'urlList'     => $chunk,
					)
				),
			)
		);
		update_option(
			'hh_indexnow_last',
			array(
				'at'   => time(),
				'n'    => count( $chunk ),
				'code' => is_wp_error( $res ) ? $res->get_error_message() : wp_remote_retrieve_response_code( $res ),
			),
			false
		);
	}
}

/** Gom đường dẫn vừa đăng / sửa, gửi một lần cuối lượt chạy. */
$GLOBALS['hh_indexnow_queue'] = array();
add_action(
	'transition_post_status',
	static function ( $new, $old, $post ) {
		if ( 'publish' !== $new && 'publish' !== $old ) {
			return;
		}
		if ( wp_is_post_revision( $post ) || wp_is_post_autosave( $post ) || ! in_array( $post->post_type, array( 'post', 'du-an', 'bat-dong-san', 'page' ), true ) ) {
			return;
		}
		$url = get_permalink( $post );
		if ( ! $url || get_transient( 'hh_inx_' . md5( $url ) ) ) {
			return; // Cùng một trang: tối đa 1 lần / 10 phút.
		}
		set_transient( 'hh_inx_' . md5( $url ), 1, 10 * MINUTE_IN_SECONDS );
		$GLOBALS['hh_indexnow_queue'][] = $url; // Gỡ bài (hết đăng) cũng báo để Bing cập nhật.
	},
	10,
	3
);
add_action(
	'shutdown',
	static function () {
		if ( ! empty( $GLOBALS['hh_indexnow_queue'] ) ) {
			hh_indexnow_send( $GLOBALS['hh_indexnow_queue'] );
		}
	}
);

/** Lần đầu: gửi toàn bộ đường dẫn đang đăng. */
add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_indexnow_full_v1' ) || ! current_user_can( 'manage_options' ) || ! hh_indexnow_enabled() || wp_doing_ajax() ) {
			return;
		}
		update_option( 'hh_indexnow_full_v1', time(), false );
		$urls = array( home_url( '/' ) );
		foreach ( get_posts( array( 'post_type' => array( 'post', 'du-an', 'bat-dong-san', 'page' ), 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids' ) ) as $id ) {
			if ( function_exists( 'hh_demo_page_slugs' ) && in_array( get_post_field( 'post_name', $id ), hh_demo_page_slugs(), true ) ) {
				continue;
			}
			$urls[] = get_permalink( $id );
		}
		hh_indexnow_send( $urls );
	}
);
