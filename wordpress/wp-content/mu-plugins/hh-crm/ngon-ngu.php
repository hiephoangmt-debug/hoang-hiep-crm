<?php
/**
 * Trang ngoại ngữ cho khách nước ngoài: /en/ (tiếng Anh), /ko/ (tiếng Hàn).
 *
 * Mỗi ngôn ngữ là 1 trang WordPress (tự tạo, slug "en" / "ko"), hiển thị bằng mẫu page-en.php / page-ko.php của giao diện.
 * Các trang tiếng Việt khác: nút EN / KO mở bản dịch tự động của Google (translate.goog) – không tạo trang trùng lặp.
 */

defined( 'ABSPATH' ) || exit;

/** Ngôn ngữ phụ: mã => [locale, tên hiển thị, tiêu đề SEO, mô tả SEO, tiêu đề trang]. */
function hh_langs() {
	return array(
		'en' => array(
			'locale' => 'en_US',
			'name'   => 'English',
			'title'  => 'Da Nang Real Estate Advisor for Foreigners – Hoang Hiep',
			'desc'   => 'Buy, rent or invest in Da Nang property with an English-speaking advisor: new condos, resale apartments, villas, foreign ownership rules, legal checks. Zalo +84 904 567 009.',
			'page'   => 'Da Nang Real Estate for Foreign Buyers',
		),
		'ko' => array(
			'locale' => 'ko_KR',
			'name'   => '한국어',
			'title'  => '다낭 부동산 상담 – 외국인 아파트 구매 | 호앙 히엡',
			'desc'   => '다낭 아파트·빌라 구매, 임대, 투자 상담. 외국인 소유 규정, 분양 프로젝트, 법적 서류 확인까지 안내합니다. Zalo +84 904 567 009.',
			'page'   => '다낭 부동산 – 외국인 구매 안내',
		),
	);
}

/** Tạo trang /en/, /ko/ nếu chưa có (chạy 1 lần mỗi phiên bản plugin). */
add_action(
	'init',
	static function () {
		if ( wp_installing() || get_option( 'hh_lang_pages_ver' ) === HH_CRM_VERSION ) {
			return;
		}
		$ids = array();
		foreach ( hh_langs() as $code => $l ) {
			$page = get_page_by_path( $code );
			$ids[ $code ] = $page ? $page->ID : wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_name'   => $code,
					'post_title'  => $l['page'],
				)
			);
		}
		update_option( 'hh_lang_pages', array_map( 'intval', $ids ) );
		update_option( 'hh_lang_pages_ver', HH_CRM_VERSION );
	},
	30
);

/** Mã ngôn ngữ trang đang xem: 'en', 'ko' hoặc 'vi'. */
function hh_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	if ( ! did_action( 'wp' ) ) {
		return 'vi';
	}
	$lang = 'vi';
	foreach ( (array) get_option( 'hh_lang_pages', array() ) as $code => $id ) {
		if ( $id && is_page( $id ) ) {
			$lang = $code;
		}
	}
	return $lang;
}

function hh_lang_url( $code ) {
	$id = (int) ( get_option( 'hh_lang_pages', array() )[ $code ] ?? 0 );
	return 'vi' === $code || ! $id ? home_url( '/' ) : get_permalink( $id );
}

/** Bản dịch tự động của Google cho 1 URL tiếng Việt (https://hiephoangmt-com.translate.goog/...). */
function hh_translate_url( $url, $code ) {
	$p = wp_parse_url( $url );
	if ( empty( $p['host'] ) ) {
		return $url;
	}
	$host = str_replace( '.', '-', str_replace( '-', '--', $p['host'] ) ) . '.translate.goog';
	$out  = 'https://' . $host . ( $p['path'] ?? '/' ) . ( isset( $p['query'] ) ? '?' . $p['query'] : '' );
	return add_query_arg( array( '_x_tr_sl' => 'vi', '_x_tr_tl' => $code, '_x_tr_hl' => $code ), $out );
}

/** Liên kết nút chuyển ngôn ngữ: trang chủ / trang ngoại ngữ → trang riêng; trang tiếng Việt khác → bản dịch tự động. */
function hh_lang_switch_url( $code ) {
	if ( 'vi' === $code || 'vi' !== hh_lang() || is_front_page() ) {
		return hh_lang_url( $code );
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/'; // phpcs:ignore
	return hh_translate_url( home_url( $uri ), $code );
}

/* SEO: thẻ lang, og:locale, hreflang, tiêu đề + mô tả riêng. */
add_filter(
	'language_attributes',
	static function ( $out ) {
		return 'vi' === hh_lang() ? $out : 'lang="' . esc_attr( str_replace( '_', '-', hh_langs()[ hh_lang() ]['locale'] ) ) . '"';
	}
);
add_filter( 'rank_math/opengraph/facebook/og_locale', static fn( $l ) => 'vi' === hh_lang() ? $l : hh_langs()[ hh_lang() ]['locale'] );
add_action(
	'wp_head',
	static function () {
		if ( ! is_front_page() && 'vi' === hh_lang() ) {
			return;
		}
		printf( "<link rel=\"alternate\" hreflang=\"vi\" href=\"%s\">\n", esc_url( home_url( '/' ) ) );
		foreach ( array_keys( hh_langs() ) as $code ) {
			printf( "<link rel=\"alternate\" hreflang=\"%s\" href=\"%s\">\n", esc_attr( $code ), esc_url( hh_lang_url( $code ) ) );
		}
		printf( "<link rel=\"alternate\" hreflang=\"x-default\" href=\"%s\">\n", esc_url( home_url( '/' ) ) );
	},
	2
);
foreach ( array( 'rank_math/frontend/title', 'rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title', 'wpseo_title', 'wpseo_opengraph_title' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => 'vi' === hh_lang() ? $v : hh_langs()[ hh_lang() ]['title'], 120 );
}
foreach ( array( 'rank_math/frontend/description', 'rank_math/opengraph/facebook/og_description', 'rank_math/opengraph/twitter/twitter_description', 'wpseo_metadesc', 'wpseo_opengraph_desc' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => 'vi' === hh_lang() ? $v : hh_langs()[ hh_lang() ]['desc'], 120 );
}
unset( $hh_filter );
add_filter( 'document_title_parts', static fn( $parts ) => 'vi' === hh_lang() ? $parts : array( 'title' => hh_langs()[ hh_lang() ]['title'] ), 120 );
