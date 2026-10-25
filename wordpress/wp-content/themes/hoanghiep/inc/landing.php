<?php
/**
 * Trang dự án dạng landing (Sun Saphia Residence, FourS Tower…): file landing/<đường dẫn dự án>.html dựng từ bộ landing riêng
 * (scripts/landing-sun-saphia.py, scripts/landing-fours.py). Có file thì trang dự án hiện landing thay giao diện chuẩn; vẫn giữ
 * SEO, sitemap, đo lường của WordPress. Muốn về giao diện chuẩn: sửa dự án → ô "Giao diện trang" chọn Chuẩn (hh_p_layout = chuan).
 *
 * Trang con của landing: file landing/<dự án>--<trang con>.html → /du-an/<dự án>/<trang con>/ (VD /du-an/fours-tower/gio-hang/),
 * tiêu đề, mô tả, schema lấy từ dòng <!--HH-LANDING-META {...} --> đầu file.
 */

defined( 'ABSPATH' ) || exit;

/** Danh sách trang con có file: [dự án => [trang con, …]]. */
function hoanghiep_landing_subpages() {
	static $list = null;
	if ( null === $list ) {
		$list = array();
		foreach ( (array) glob( get_theme_file_path( 'landing/*--*.html' ) ) as $f ) {
			list( $project, $sub ) = explode( '--', basename( $f, '.html' ), 2 );
			$list[ $project ][] = $sub;
		}
	}
	return $list;
}

add_filter(
	'query_vars',
	static function ( $vars ) {
		$vars[] = 'hh_landing_sub';
		return $vars;
	}
);

add_action(
	'init',
	static function () {
		$sig = array();
		foreach ( hoanghiep_landing_subpages() as $project => $subs ) {
			$re = '^du-an/(' . preg_quote( $project, '#' ) . ')/(' . implode( '|', array_map( 'preg_quote', $subs ) ) . ')/?$';
			add_rewrite_rule( $re, 'index.php?du-an=$matches[1]&hh_landing_sub=$matches[2]', 'top' );
			$sig[] = $re;
		}
		// Có trang con mới (sau khi cập nhật giao diện) → làm mới đường dẫn một lần.
		$sig = md5( implode( '|', $sig ) );
		if ( get_option( 'hoanghiep_landing_rules' ) !== $sig ) {
			update_option( 'hoanghiep_landing_rules', $sig, true );
			flush_rewrite_rules( false );
		}
	},
	20
);

function hoanghiep_landing_file() {
	if ( ! is_singular( 'du-an' ) ) {
		return '';
	}
	$id = get_queried_object_id();
	if ( 'chuan' === get_post_meta( $id, 'hh_p_layout', true ) ) {
		return '';
	}
	$slug = get_post_field( 'post_name', $id );
	$sub  = sanitize_key( (string) get_query_var( 'hh_landing_sub' ) );
	$file = get_theme_file_path( 'landing/' . $slug . ( $sub ? '--' . $sub : '' ) . '.html' );
	return is_file( $file ) ? $file : '';
}

/** Thông tin trang con (tiêu đề, mô tả, đường dẫn) – rỗng nếu đang ở trang dự án. */
function hoanghiep_landing_meta() {
	static $meta = null;
	if ( null !== $meta ) {
		return $meta;
	}
	$meta = array();
	$file = get_query_var( 'hh_landing_sub' ) ? hoanghiep_landing_file() : '';
	if ( $file ) {
		$line = (string) fgets( fopen( $file, 'r' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( preg_match( '/<!--HH-LANDING-META (\{.*\}) -->/', $line, $m ) ) {
			$meta = (array) json_decode( $m[1], true );
		}
	}
	return $meta;
}

// Landing có CSS, chat, nút liên hệ riêng – không tải CSS/JS giao diện chuẩn và chat của web (tránh chồng, trùng).
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! hoanghiep_landing_file() ) {
			return;
		}
		wp_dequeue_style( 'hoanghiep' );
		wp_dequeue_script( 'hoanghiep' );
		wp_dequeue_script( 'hh-chat' );
	},
	100
);

// Trang con: tiêu đề, mô tả, canonical riêng (thay thẻ SEO của trang dự án mẹ).
add_action(
	'wp',
	static function () {
		$meta = hoanghiep_landing_meta();
		if ( ! $meta ) {
			return;
		}
		remove_all_actions( 'rank_math/head' );
		remove_action( 'wp_head', 'hh_seo_head', 1 );
		remove_action( 'wp_head', 'hh_seo_schema', 20 );
		remove_action( 'wp_head', 'rel_canonical' );
		add_filter( 'pre_get_document_title', static fn() => (string) $meta['title'], 99 );
		add_action(
			'wp_head',
			static function () use ( $meta ) {
				$url = home_url( (string) $meta['url'] );
				if ( ! did_action( 'hh_landing_title' ) && ! has_filter( 'wp_head', '_wp_render_title_tag' ) ) {
					printf( "<title>%s</title>\n", esc_html( $meta['title'] ) );
				}
				printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $meta['description'] ) );
				printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( $url ) );
				echo "<meta name=\"robots\" content=\"index, follow, max-image-preview:large\">\n";
				printf( "<meta property=\"og:type\" content=\"website\">\n<meta property=\"og:url\" content=\"%s\">\n<meta property=\"og:title\" content=\"%s\">\n<meta property=\"og:description\" content=\"%s\">\n", esc_url( $url ), esc_attr( $meta['title'] ), esc_attr( $meta['description'] ) );
			},
			1
		);
	}
);
