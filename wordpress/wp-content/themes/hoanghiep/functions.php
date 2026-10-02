<?php
/**
 * Hoàng Hiệp theme setup.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'hoanghiep_setup' );
function hoanghiep_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 200, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_image_size( 'hh-card', 640, 420, true );

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
	wp_enqueue_style( 'hoanghiep-fonts', 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'hoanghiep', get_theme_file_uri( 'assets/css/main.css' ), array(), $ver );
	wp_enqueue_script( 'hoanghiep', get_theme_file_uri( 'assets/js/main.js' ), array(), $ver, array( 'strategy' => 'defer' ) );
}

/**
 * Contact settings editable in Giao diện → Tùy biến → Thông tin liên hệ.
 */
function hoanghiep_defaults() {
	return array(
		'hh_phone'      => '0900 000 000',
		'hh_zalo'       => '0900000000',
		'hh_email'      => 'hiephoangmt@gmail.com',
		'hh_address'    => 'Việt Nam',
		'hh_facebook'   => '',
		'hh_hero_title' => 'Tìm ngôi nhà mơ ước cùng Hoàng Hiệp',
		'hh_hero_text'  => 'Tư vấn mua bán, cho thuê và đầu tư bất động sản uy tín – minh bạch pháp lý, hỗ trợ tận tâm từ A đến Z.',
		'hh_hero_image' => '',
	);
}

function hoanghiep_opt( $key ) {
	$defaults = hoanghiep_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

add_action( 'customize_register', 'hoanghiep_customize' );
function hoanghiep_customize( $wp_customize ) {
	$wp_customize->add_section( 'hh_contact', array( 'title' => 'Thông tin liên hệ', 'priority' => 30 ) );
	$wp_customize->add_section( 'hh_hero', array( 'title' => 'Banner trang chủ', 'priority' => 31 ) );

	$fields = array(
		'hh_phone'      => array( 'hh_contact', 'Số điện thoại / Hotline', 'text' ),
		'hh_zalo'       => array( 'hh_contact', 'Số Zalo', 'text' ),
		'hh_email'      => array( 'hh_contact', 'Email', 'email' ),
		'hh_address'    => array( 'hh_contact', 'Địa chỉ', 'text' ),
		'hh_facebook'   => array( 'hh_contact', 'Link Facebook', 'url' ),
		'hh_hero_title' => array( 'hh_hero', 'Tiêu đề', 'text' ),
		'hh_hero_text'  => array( 'hh_hero', 'Mô tả', 'textarea' ),
	);
	$defaults = hoanghiep_defaults();

	foreach ( $fields as $id => list( $section, $label, $type ) ) {
		$sanitize = array(
			'email'    => 'sanitize_email',
			'url'      => 'esc_url_raw',
			'textarea' => 'sanitize_textarea_field',
		)[ $type ] ?? 'sanitize_text_field';

		$wp_customize->add_setting( $id, array( 'default' => $defaults[ $id ], 'sanitize_callback' => $sanitize ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => $section, 'type' => $type ) );
	}

	$wp_customize->add_setting( 'hh_hero_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'hh_hero_image', array( 'label' => 'Ảnh nền', 'section' => 'hh_hero' ) )
	);
}

function hoanghiep_tel( $phone ) {
	return preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Fallback menu when no menu has been assigned yet.
 */
function hoanghiep_fallback_menu() {
	$items = array(
		home_url( '/' )                     => 'Trang chủ',
		get_post_type_archive_link( 'bat-dong-san' ) ?: home_url( '/bat-dong-san/' ) => 'Bất động sản',
		home_url( '/gioi-thieu/' )          => 'Giới thiệu',
		home_url( '/tin-tuc/' )             => 'Tin tức',
		home_url( '/lien-he/' )             => 'Liên hệ',
	);
	echo '<ul class="menu">';
	foreach ( $items as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Show 9 properties per page on the property archive.
 */
add_action( 'pre_get_posts', 'hoanghiep_property_query' );
function hoanghiep_property_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'bat-dong-san' ) || $query->is_tax( array( 'khu-vuc', 'loai-bds' ) ) ) {
		$query->set( 'posts_per_page', 9 );
	}
}

add_filter( 'excerpt_length', fn() => 25 );
add_filter( 'excerpt_more', fn() => '…' );
