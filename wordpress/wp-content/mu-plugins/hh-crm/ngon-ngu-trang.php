<?php
/**
 * Trang tiếng Anh / tiếng Hàn chạy bằng code, không qua Google Dịch (anh Hiệp 26/11/2026).
 *
 * Mọi trang tiếng Việt có thêm 2 địa chỉ:
 * - https://hiephoangmt.com/en/<đường dẫn tiếng Việt>
 * - https://hiephoangmt.com/ko/<đường dẫn tiếng Việt>
 * Ví dụ: /en/du-an/premier-village-da-nang/.
 *
 * Web dựng đúng trang tiếng Việt rồi thay từng đoạn chữ bằng bản dịch viết sẵn trong tr/*.json, ngay trên máy chủ:
 * - tr/chung.json: nhãn dùng chung.
 * - tr/<loại>/<slug>.json: theo từng trang.
 * - Bảng thuật ngữ trong ngon-ngu.php.
 *
 * Các phần đi kèm:
 * - Tiêu đề mục ghép lại đúng trật tự từng thứ tiếng.
 * - Liên kết nội bộ giữ nguyên ngôn ngữ đang xem.
 * - Thẻ lang, canonical, hreflang cho SEO.
 *
 * Đoạn nào chưa có bản dịch thì giữ tiếng Việt, bổ sung dần vào bảng dịch.
 * Trang chủ /en/, /ko/ vẫn là trang giới thiệu riêng như cũ.
 */

defined( 'ABSPATH' ) || exit;

/** Ngôn ngữ trang dịch đang xem: 'en', 'ko' hoặc '' (trang tiếng Việt / trang khác). */
function hh_tl() {
	return (string) ( $GLOBALS['hh_tl'] ?? '' );
}

/** Đường dẫn tiếng Việt của trang đang xem (bỏ tiền tố /en, /ko), luôn bắt đầu bằng "/". */
function hh_tl_path() {
	if ( isset( $GLOBALS['hh_tl_path'] ) ) {
		return (string) $GLOBALS['hh_tl_path'];
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/'; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	return (string) ( wp_parse_url( $uri, PHP_URL_PATH ) ?: '/' );
}

/** Địa chỉ của trang đang xem ở ngôn ngữ $code ('vi', 'en', 'ko'). */
function hh_tl_url( $code ) {
	$path = hh_tl_path();
	if ( 'vi' === $code ) {
		return home_url( $path );
	}
	return home_url( '/' . $code . ( '/' === $path ? '/' : $path ) );
}

/** Đường dẫn có dịch được không (trang nội dung, không phải file, quản trị, API). */
function hh_tl_path_ok( $path ) {
	return '' !== trim( $path, '/' )
		&& ! preg_match( '#^/(wp-|xmlrpc|feed/|sitemap|[a-z0-9_-]*sitemap|robots\.txt|favicon|en/|ko/)#i', $path )
		&& ! preg_match( '#\.[a-z0-9]{2,5}$#i', $path );
}

/*
 * Nhận diện /en/…, /ko/… trước khi WordPress đọc đường dẫn: bỏ tiền tố để WordPress tìm đúng trang tiếng Việt,
 * ghi nhớ ngôn ngữ để dịch lúc xuất trang. /en/ và /ko/ (trang giới thiệu) giữ nguyên.
 */
add_filter(
	'do_parse_request',
	static function ( $do ) {
		if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return $do;
		}
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
		if ( preg_match( '#^/(en|ko)(/.+)$#', $path, $m ) && hh_tl_path_ok( $m[2] ) ) {
			$GLOBALS['hh_tl']      = $m[1];
			$GLOBALS['hh_tl_path'] = $m[2];
			$q                     = (string) wp_parse_url( $uri, PHP_URL_QUERY );
			$_SERVER['REQUEST_URI'] = $m[2] . ( '' !== $q ? '?' . $q : '' );
		}
		return $do;
	},
	1
);

// Trang dịch: không để WordPress chuyển hướng về đường dẫn tiếng Việt.
add_filter( 'redirect_canonical', static fn( $url ) => hh_tl() ? false : $url, 1 );

/** Bảng dịch của trang đang xem: thuật ngữ + tr/chung.json + tr/<loại>/<slug>.json. */
function hh_tl_dict() {
	static $dict = null;
	if ( null !== $dict ) {
		return $dict;
	}
	$dict = array();
	if ( function_exists( 'hh_lang_glossary' ) ) {
		foreach ( hh_lang_glossary() as $vi => $tr ) {
			$dict[ $vi ] = array( (string) ( $tr[0] ?? '' ), (string) ( $tr[1] ?? '' ) );
		}
	}
	if ( function_exists( 'hh_lang_page_dict' ) ) {
		foreach ( hh_lang_page_dict() as $vi => $tr ) {
			$dict[ $vi ] = array( (string) ( $tr[0] ?? '' ), (string) ( $tr[1] ?? '' ) );
		}
	}
	return $dict;
}

/** Dịch 1 đoạn chữ (đã gộp khoảng trắng); '' nếu chưa có bản dịch. */
function hh_tl_text( $vi ) {
	$d = hh_tl_dict();
	$k = trim( preg_replace( '/\s+/u', ' ', (string) $vi ) );
	$i = 'ko' === hh_tl() ? 1 : 0;
	return '' !== $k && isset( $d[ $k ] ) ? (string) $d[ $k ][ $i ] : '';
}

/** Trang hiện tại có bảng dịch riêng không (để gắn hreflang ở bản tiếng Việt). */
function hh_tl_has_page_dict() {
	$obj = get_queried_object();
	if ( $obj instanceof WP_Post ) {
		return is_file( HH_CRM_DIR . 'tr/' . sanitize_key( $obj->post_type ) . '/' . sanitize_title( $obj->post_name ) . '.json' );
	}
	return is_post_type_archive( 'du-an' );
}

/* Xuất trang: gom HTML rồi dịch. */
add_action(
	'template_redirect',
	static function () {
		if ( hh_tl() && ! is_feed() ) {
			ob_start( 'hh_tl_translate_html' );
		}
	},
	0
);

/** Dịch toàn bộ HTML của trang. */
function hh_tl_translate_html( $html ) {
	if ( '' === $html || false === stripos( $html, '<html' ) ) {
		return $html;
	}
	$tl = hh_tl();
	$h  = static fn( $s ) => html_entity_decode( (string) $s, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$e  = static fn( $s ) => htmlspecialchars( (string) $s, ENT_QUOTES | ENT_HTML5, 'UTF-8', false );

	// 1) Tiêu đề "Tiền tố <em>Tên</em>" → mẫu câu đúng trật tự ("Premier Village at a glance").
	if ( function_exists( 'hh_lang_heading_patterns' ) ) {
		$pats = hh_lang_heading_patterns();
		$html = preg_replace_callback(
			'#(<h[1-3]\b[^>]*>)(\s*)([^<]+?)(\s*)<em\b([^>]*)>([^<]*)</em>#u',
			static function ( $m ) use ( $pats, $tl, $h, $e ) {
				$pre = trim( preg_replace( '/\s+/u', ' ', $h( $m[3] ) ) );
				$pat = $pats[ $pre ][ 'ko' === $tl ? 1 : 0 ] ?? '';
				if ( '' === $pat ) {
					return $m[0];
				}
				$name  = trim( $h( $m[6] ) );
				$tname = hh_tl_text( $name );
				$parts = explode( '{n}', $pat, 2 );
				return $m[1] . $m[2] . $e( $parts[0] ) . '<em' . $m[5] . '>' . $e( '' !== $tname ? $tname : $name ) . '</em>' . $e( $parts[1] ?? '' );
			},
			$html
		);
	}

	// 2) Tách thẻ / chữ; dịch từng đoạn chữ, thuộc tính chữ; giữ liên kết nội bộ trong cùng ngôn ngữ.
	$home  = home_url();
	$hosts = preg_quote( (string) wp_parse_url( $home, PHP_URL_HOST ), '#' );
	$parts = preg_split( '#(<!--.*?-->|<script\b.*?</script>|<style\b.*?</style>|<textarea\b.*?</textarea>|<svg\b.*?</svg>|<[^>]+>)#si', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
	$skip  = 0; // Đang trong vùng translate="no".
	$stack = array();
	foreach ( $parts as $i => $p ) {
		if ( '' === $p ) {
			continue;
		}
		if ( '<' === $p[0] ) {
			if ( preg_match( '#^<(script|style|textarea|svg|!--)#i', $p ) ) {
				continue;
			}
			if ( preg_match( '#^<([a-z0-9]+)\b#i', $p, $tm ) ) {
				$tag = strtolower( $tm[1] );
				if ( '/' !== substr( $p, -2, 1 ) && ! in_array( $tag, array( 'br', 'img', 'input', 'meta', 'link', 'hr', 'source', 'wbr' ), true ) ) {
					$no = (bool) preg_match( '#\btranslate=["\']no["\']#i', $p );
					$stack[] = array( $tag, $no );
					$skip   += $no ? 1 : 0;
				}
				if ( $skip ) {
					continue;
				}
				// Thuộc tính chữ khách nhìn thấy.
				$p = preg_replace_callback(
					'#\b(placeholder|alt|title|aria-label)=(["\'])(.*?)\2#su',
					static function ( $am ) use ( $h, $e ) {
						$t = hh_tl_text( $h( $am[3] ) );
						return '' !== $t ? $am[1] . '=' . $am[2] . $e( $t ) . $am[2] : $am[0];
					},
					$p
				);
				// Liên kết nội bộ → cùng ngôn ngữ (trừ nút chọn ngôn ngữ có hreflang).
				if ( 'a' === $tag && false === stripos( $p, 'hreflang=' ) ) {
					$p = preg_replace_callback(
						'#\bhref=(["\'])(?:https?://' . $hosts . ')?(/[^"\'\#?]*)([^"\']*)\1#i',
						static function ( $lm ) use ( $tl ) {
							$path = $lm[2];
							if ( '/' === $path || ! hh_tl_path_ok( $path ) ) {
								return '/' === $path ? 'href=' . $lm[1] . home_url( '/' . $tl . '/' ) . $lm[1] : $lm[0];
							}
							return 'href=' . $lm[1] . home_url( '/' . $tl . $path ) . $lm[3] . $lm[1];
						},
						$p
					);
				}
				$parts[ $i ] = $p;
			} elseif ( preg_match( '#^</([a-z0-9]+)#i', $p, $tm ) ) {
				$tag = strtolower( $tm[1] );
				for ( $j = count( $stack ) - 1; $j >= 0; $j-- ) {
					if ( $stack[ $j ][0] === $tag ) {
						foreach ( array_splice( $stack, $j ) as $closed ) {
							$skip -= $closed[1] ? 1 : 0;
						}
						break;
					}
				}
			}
			continue;
		}
		if ( $skip || '' === trim( $p ) ) {
			continue;
		}
		$t = hh_tl_text( $h( $p ) );
		if ( '' !== $t ) {
			preg_match( '/^\s*/u', $p, $lead );
			preg_match( '/\s*$/u', $p, $trail );
			$parts[ $i ] = $lead[0] . $e( $t ) . $trail[0];
		}
	}
	$html = implode( '', $parts );

	// 3) Nút VI · EN · KO: đánh dấu ngôn ngữ đang xem, các nút còn lại trỏ sang cùng trang ở ngôn ngữ đó.
	$html = preg_replace_callback(
		'#(<nav\b[^>]*\blang-switch\b[^>]*>)(.*?)(</nav>)#si',
		static function ( $m ) use ( $tl ) {
			$names = array( 'vi' => 'Tiếng Việt', 'en' => 'English', 'ko' => '한국어' );
			$out   = '';
			foreach ( $names as $code => $name ) {
				if ( 'vi' !== $code && ! preg_match( '#hreflang=["\']' . $code . '["\']|>\s*' . strtoupper( $code ) . '\s*<#', $m[2] ) && $code !== $tl ) {
					continue;
				}
				$out .= $code === $tl
					? '<span class="lang-switch__item is-active" aria-current="true">' . strtoupper( $code ) . '</span>'
					: '<a class="lang-switch__item" href="' . esc_url( hh_tl_url( $code ) ) . '" hreflang="' . $code . '" lang="' . $code . '" title="' . esc_attr( $name ) . '">' . strtoupper( $code ) . '</a>';
			}
			return $m[1] . $out . $m[3];
		},
		$html
	);

	// 4) Thẻ ngôn ngữ của trang.
	$locale = 'ko' === $tl ? 'ko-KR' : 'en-US';
	$html   = preg_replace( '#<html\b([^>]*)\blang=(["\'])[^"\']*\2#i', '<html$1lang="' . $locale . '"', $html, 1 );
	return $html;
}

/* SEO: tiêu đề, mô tả, canonical, og:locale của trang dịch; hreflang ở cả bản Việt lẫn bản dịch. */
foreach ( array( 'rank_math/frontend/title', 'rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title', 'document_title' ) as $hh_f ) {
	add_filter(
		$hh_f,
		static function ( $v ) {
			if ( ! hh_tl() || ! is_string( $v ) ) {
				return $v;
			}
			$t = hh_tl_text( $v );
			if ( '' === $t && is_singular() ) {
				$t = hh_tl_text( get_the_title() ); // Tiêu đề SEO chưa có bản dịch: dùng tiêu đề bài đã dịch.
				$t = '' !== $t ? $t . ' | Hoang Hiep' : '';
			}
			return '' !== $t ? $t : $v;
		},
		130
	);
}
foreach ( array( 'rank_math/frontend/description', 'rank_math/opengraph/facebook/og_description', 'rank_math/opengraph/twitter/twitter_description' ) as $hh_f ) {
	add_filter(
		$hh_f,
		static function ( $v ) {
			if ( ! hh_tl() || ! is_string( $v ) ) {
				return $v;
			}
			$t = hh_tl_text( $v );
			if ( '' === $t && is_singular() ) {
				$t = hh_tl_text( trim( wp_strip_all_tags( get_the_excerpt() ) ) );
			}
			return '' !== $t ? $t : $v;
		},
		130
	);
}
unset( $hh_f );
add_filter( 'rank_math/frontend/canonical', static fn( $c ) => hh_tl() ? hh_tl_url( hh_tl() ) : $c, 130 );
add_filter( 'rank_math/opengraph/url', static fn( $u ) => hh_tl() ? hh_tl_url( hh_tl() ) : $u, 130 );
add_filter( 'rank_math/opengraph/facebook/og_locale', static fn( $l ) => hh_tl() ? ( 'ko' === hh_tl() ? 'ko_KR' : 'en_US' ) : $l, 130 );
add_action(
	'wp_head',
	static function () {
		if ( is_front_page() || is_404() || is_search() || ( function_exists( 'hh_project_en_pair' ) && hh_project_en_pair() ) || ! ( hh_tl() || hh_tl_has_page_dict() ) || ! hh_tl_path_ok( hh_tl_path() ) ) {
			return;
		}
		foreach ( array( 'vi', 'en', 'ko' ) as $code ) {
			printf( "<link rel=\"alternate\" hreflang=\"%s\" href=\"%s\">\n", esc_attr( $code ), esc_url( hh_tl_url( $code ) ) );
		}
		printf( "<link rel=\"alternate\" hreflang=\"x-default\" href=\"%s\">\n", esc_url( hh_tl_url( 'vi' ) ) );
	},
	3
);
