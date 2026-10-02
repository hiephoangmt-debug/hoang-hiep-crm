<?php
/**
 * Hoàng Hiệp theme setup.
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HH_CRM_VERSION' ) ) {
	add_action(
		'admin_notices',
		fn() => print '<div class="notice notice-error"><p>Theme Hoàng Hiệp cần plugin <strong>Hoàng Hiệp CRM</strong> (thư mục <code>wp-content/mu-plugins/</code>). Hãy tải lên trước khi dùng.</p></div>'
	);
	return;
}

require get_theme_file_path( 'inc/customizer.php' );
require get_theme_file_path( 'inc/components.php' );
require get_theme_file_path( 'inc/seo.php' );

add_action( 'after_setup_theme', 'hoanghiep_setup' );
function hoanghiep_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_image_size( 'hh-card', 720, 480, true );
	add_image_size( 'hh-hero', 1920, 900, true );

	register_nav_menus(
		array(
			'primary' => 'Menu chính',
			'footer'  => 'Menu chân trang',
		)
	);
}

add_action( 'wp_enqueue_scripts', 'hoanghiep_assets' );
function hoanghiep_assets() {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'hoanghiep-fonts', 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap', array(), null );
	wp_enqueue_style( 'hoanghiep', get_theme_file_uri( 'assets/css/main.css' ), array(), $ver );
	wp_enqueue_script( 'hoanghiep', get_theme_file_uri( 'assets/js/main.js' ), array(), $ver, array( 'strategy' => 'defer' ) );
}

/**
 * Menu used until one is assigned in Giao diện → Menu.
 */
function hoanghiep_fallback_menu( $args = array() ) {
	$flat      = 1 === (int) ( $args['depth'] ?? 0 );
	$type_link = static function ( $slug, $fallback ) {
		$term = get_term_by( 'slug', $slug, 'loai-du-an' );
		return $term ? get_term_link( $term ) : $fallback;
	};
	$projects = get_post_type_archive_link( 'du-an' );
	$items    = array(
		array( 'Trang chủ', home_url( '/' ) ),
		array( 'Dự án', $projects, array(
			array( 'Cao tầng', $type_link( 'cao-tang', $projects ), array(
				array( 'Căn hộ sở hữu lâu dài', $type_link( 'can-ho-so-huu-lau-dai', $projects ) ),
				array( 'Căn hộ dịch vụ (50 năm)', $type_link( 'can-ho-dich-vu', $projects ) ),
			) ),
			array( 'Thấp tầng', $type_link( 'thap-tang', $projects ), array(
				array( 'Biệt thự', $type_link( 'biet-thu', $projects ) ),
				array( 'Đất nền', $type_link( 'dat-nen', $projects ) ),
				array( 'Shophouse', $type_link( 'shophouse', $projects ) ),
			) ),
		) ),
		array( 'Mua bán', hh_deal_url( 'ban' ) ),
		array( 'Cho thuê', hh_deal_url( 'thue' ) ),
		array( 'Tin tức', home_url( '/tin-tuc/' ) ),
		array( 'Về Hiệp', home_url( '/gioi-thieu/' ) ),
		array( 'Liên hệ', home_url( '/lien-he/' ) ),
	);
	$current = untrailingslashit( home_url( strtok( add_query_arg( array() ), '?' ) ) );
	$render  = static function ( $items, $class ) use ( &$render, $current, $flat ) {
		printf( '<ul class="%s">', esc_attr( $class ) );
		foreach ( $items as $item ) {
			$classes = array();
			if ( ! empty( $item[2] ) && ! $flat ) {
				$classes[] = 'menu-item-has-children';
			}
			if ( untrailingslashit( $item[1] ) === $current ) {
				$classes[] = 'current-menu-item';
			}
			printf( '<li class="%s"><a href="%s">%s</a>', esc_attr( implode( ' ', $classes ) ), esc_url( $item[1] ), esc_html( $item[0] ) );
			if ( ! empty( $item[2] ) && ! $flat ) {
				$render( $item[2], 'sub-menu' );
			}
			echo '</li>';
		}
		echo '</ul>';
	};
	$render( $items, 'menu' );
}

add_filter( 'excerpt_length', fn() => 26 );
add_filter( 'excerpt_more', fn() => '…' );

/** Mixed archives (khu vực, tìm kiếm) show projects and listings together. */
add_action( 'pre_get_posts', 'hoanghiep_tax_query' );
function hoanghiep_tax_query( $q ) {
	if ( ! is_admin() && $q->is_main_query() && $q->is_tax( 'khu-vuc' ) ) {
		$q->set( 'posts_per_page', 12 );
	}
}
