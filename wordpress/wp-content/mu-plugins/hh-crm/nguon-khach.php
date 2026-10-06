<?php
/**
 * Nguồn khách: khách để lại số ở trang nào (dự án nào), vào web từ đâu (Google, quảng cáo, Facebook, Zalo…).
 * Trình duyệt ghi trang vào đầu tiên + trang giới thiệu (sessionStorage), gắn vào form & chat;
 * email / Telegram báo khách mới có thêm 2 dòng "Dự án / trang" và "Vào web từ".
 * Lọc số không phải Việt Nam (bot spam): vẫn lưu vào Khách hàng (trạng thái Không tiềm năng) nhưng không báo.
 */

defined( 'ABSPATH' ) || exit;

/** Ghi nguồn truy cập + gắn ô ẩn vào form để lại thông tin. */
add_action(
	'wp_footer',
	static function () {
		?>
<script id="hh-src">
(function(){try{var k='hh_src',s=JSON.parse(sessionStorage.getItem(k)||'null');if(!s){s={first:location.href,ref:document.referrer||''};sessionStorage.setItem(k,JSON.stringify(s));}window.HH_SRC={url:location.href,title:document.title,first:s.first,ref:s.ref};}catch(e){window.HH_SRC={url:location.href,title:document.title,first:location.href,ref:document.referrer||''};}
document.querySelectorAll('form input[name="action"][value="hh_lead"]').forEach(function(a){var f=a.form;['url','title','first','ref'].forEach(function(n){var i=document.createElement('input');i.type='hidden';i.name='src_'+n;i.value=(window.HH_SRC[n]||'').slice(0,500);f.appendChild(i);});});})();
</script>
		<?php
	},
	5
);

/** Đọc 4 ô nguồn từ dữ liệu gửi lên (form hoặc chat). */
function hh_src_from_request() {
	$get = static fn( $k ) => mb_substr( sanitize_text_field( wp_unslash( $_POST[ 'src_' . $k ] ?? '' ) ), 0, 500 ); // phpcs:ignore WordPress.Security.NonceVerification
	return array(
		'url'   => esc_url_raw( $get( 'url' ) ),
		'title' => $get( 'title' ),
		'first' => esc_url_raw( $get( 'first' ) ),
		'ref'   => esc_url_raw( $get( 'ref' ) ),
	);
}

/** Dự án / tin rao ứng với đường dẫn trang (0 nếu là trang khác). */
function hh_src_post_id( $url ) {
	if ( ! $url || 0 !== strpos( $url, home_url() ) ) {
		return 0;
	}
	$id = url_to_postid( strtok( $url, '?#' ) );
	return $id && in_array( get_post_type( $id ), array( 'du-an', 'bat-dong-san' ), true ) ? (int) $id : 0;
}

/** Khách vào web từ đâu: Google Ads, Google tìm kiếm, Facebook, Zalo… */
function hh_src_channel( $first, $ref ) {
	parse_str( (string) wp_parse_url( (string) $first, PHP_URL_QUERY ), $q );
	$host   = strtolower( (string) wp_parse_url( (string) $ref, PHP_URL_HOST ) );
	$own    = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$source = strtolower( (string) ( $q['utm_source'] ?? '' ) );
	$medium = strtolower( (string) ( $q['utm_medium'] ?? '' ) );
	$paid   = preg_match( '/cpc|ppc|paid|ads?$/', $medium );
	if ( ! empty( $q['gclid'] ) || ! empty( $q['gbraid'] ) || ! empty( $q['wbraid'] ) || ( 'google' === $source && $paid ) ) {
		$out = 'Quảng cáo Google';
	} elseif ( ! empty( $q['fbclid'] ) && $paid || preg_match( '/^(facebook|fb|instagram|meta)$/', $source ) && $paid ) {
		$out = 'Quảng cáo Facebook';
	} elseif ( ! empty( $q['zarsrc'] ) || 'zalo' === $source || false !== strpos( $host, 'zalo' ) ) {
		$out = 'Zalo';
	} elseif ( ! empty( $q['fbclid'] ) || preg_match( '/^(facebook|fb|instagram)$/', $source ) || preg_match( '/facebook|fb\.|instagram|messenger/', $host ) ) {
		$out = 'Facebook';
	} elseif ( preg_match( '/tiktok/', $source . $host ) ) {
		$out = 'TikTok';
	} elseif ( $source ) {
		$out = $q['utm_source'];
	} elseif ( preg_match( '/(^|\.)google\./', $host ) ) {
		$out = 'Google tìm kiếm';
	} elseif ( false !== strpos( $host, 'coccoc' ) ) {
		$out = 'Cốc Cốc tìm kiếm';
	} elseif ( preg_match( '/bing\.|yahoo\.|duckduckgo/', $host ) ) {
		$out = 'Bing / công cụ tìm kiếm khác';
	} elseif ( $host && $host !== $own ) {
		$out = 'Trang khác: ' . $host;
	} else {
		$out = 'Gõ địa chỉ / lưu sẵn (truy cập trực tiếp)';
	}
	if ( ! empty( $q['utm_campaign'] ) ) {
		$out .= ' – chiến dịch "' . sanitize_text_field( $q['utm_campaign'] ) . '"';
	}
	return $out;
}

/** Các dòng nguồn khách để chèn vào email / Telegram. */
function hh_src_lines( $src, $post_id = 0 ) {
	$lines = array();
	if ( $post_id ) {
		$lines[] = '🏢 Dự án / tin: ' . get_the_title( $post_id ) . "\n" . get_permalink( $post_id );
	}
	if ( ! empty( $src['url'] ) && ( ! $post_id || strtok( $src['url'], '?#' ) !== get_permalink( $post_id ) ) ) {
		$title   = trim( preg_replace( '/\s*[–|-]\s*Hoàng Hiệp.*$/u', '', (string) $src['title'] ) );
		$lines[] = '📍 Trang khách để lại số: ' . ( $title ?: 'Trang' ) . "\n" . strtok( $src['url'], '?#' );
	}
	if ( ! empty( $src['first'] ) || ! empty( $src['ref'] ) ) {
		$lines[] = '🔎 Vào web từ: ' . hh_src_channel( $src['first'] ?? '', $src['ref'] ?? '' );
		$first   = strtok( (string) ( $src['first'] ?? '' ), '?#' );
		if ( $first && ( empty( $src['url'] ) || strtok( $src['url'], '?#' ) !== $first ) ) {
			$lines[] = '🚪 Trang vào đầu tiên: ' . $first;
		}
	}
	return $lines ? implode( "\n", $lines ) . "\n" : '';
}

/** Lưu nguồn vào khách hàng (xem trong quản trị). */
function hh_src_save( $lead_id, $src ) {
	foreach ( array( 'url', 'first', 'ref' ) as $k ) {
		if ( ! empty( $src[ $k ] ) ) {
			update_post_meta( $lead_id, 'hh_src_' . $k, $src[ $k ] );
		}
	}
	if ( ! empty( $src['first'] ) || ! empty( $src['ref'] ) ) {
		update_post_meta( $lead_id, 'hh_src_channel', hh_src_channel( $src['first'] ?? '', $src['ref'] ?? '' ) );
	}
}

/** Số điện thoại Việt Nam (0xxxxxxxxx, 84…, +84…) hoặc số quốc tế có dấu +. */
function hh_is_real_phone( $phone ) {
	$p = preg_replace( '/[ .\-]/', '', (string) $phone );
	if ( preg_match( '/^(?:\+?84|0)[235789]\d{8}$/', $p ) ) {
		return true;
	}
	return (bool) preg_match( '/^\+(?!84)\d{8,14}$/', $p );
}

/** Hiện nguồn khách trong trang sửa khách hàng. */
add_action(
	'add_meta_boxes_khach-hang',
	static function () {
		add_meta_box(
			'hh_lead_src',
			'Nguồn khách',
			static function ( $post ) {
				$rows = array(
					'Vào web từ'          => get_post_meta( $post->ID, 'hh_src_channel', true ),
					'Trang để lại số'     => get_post_meta( $post->ID, 'hh_src_url', true ),
					'Trang vào đầu tiên'  => get_post_meta( $post->ID, 'hh_src_first', true ),
					'Trang giới thiệu'    => get_post_meta( $post->ID, 'hh_src_ref', true ),
				);
				$rows = array_filter( $rows );
				if ( ! $rows ) {
					echo '<p>Chưa có (khách gửi trước bản 2.17.6).</p>';
					return;
				}
				echo '<table class="form-table">';
				foreach ( $rows as $label => $v ) {
					$v = (string) $v;
					printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( $label ), 0 === strpos( $v, 'http' ) ? '<a href="' . esc_url( $v ) . '" target="_blank" rel="noopener">' . esc_html( urldecode( $v ) ) . '</a>' : esc_html( $v ) );
				}
				echo '</table>';
			},
			'khach-hang',
			'normal',
			'default'
		);
	}
);
