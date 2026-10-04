<?php
/**
 * Hoàng Hiệp theme setup.
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HH_CRM_VERSION' ) ) {
	add_action(
		'admin_notices',
		fn() => print '<div class="notice notice-error"><p>Giao diện Hoàng Hiệp cần plugin <strong>Hoàng Hiệp CRM</strong>: vào <a href="' . esc_url( admin_url( 'plugin-install.php?tab=upload' ) ) . '">Plugin → Cài mới → Tải plugin lên</a>, chọn file <code>hoang-hiep-crm.zip</code> rồi bấm Kích hoạt.</p></div>'
	);
	// Ngoài website: hiện trang thông báo thay vì lỗi.
	add_filter( 'template_include', fn() => get_theme_file_path( 'no-plugin.php' ), 99 );
	return;
}

require get_theme_file_path( 'inc/customizer.php' );
require get_theme_file_path( 'inc/components.php' );
require get_theme_file_path( 'inc/content-tables.php' );
require get_theme_file_path( 'inc/project-inline-css.php' );
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
	// Thêm thời điểm sửa file vào phiên bản để trình duyệt / cache tải bản mới ngay sau khi cập nhật.
	wp_enqueue_style( 'hoanghiep', get_theme_file_uri( 'assets/css/main.css' ), array(), $ver . '.' . filemtime( get_theme_file_path( 'assets/css/main.css' ) ) );
	wp_enqueue_script( 'hoanghiep', get_theme_file_uri( 'assets/js/main.js' ), array(), $ver . '.' . filemtime( get_theme_file_path( 'assets/js/main.js' ) ), array( 'strategy' => 'defer' ) );
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
			array( 'Tổ hợp dự án', $type_link( 'to-hop', $projects ) ),
			array( 'Cao tầng', $type_link( 'cao-tang', $projects ), array(
				array( 'Căn hộ sở hữu lâu dài', $type_link( 'can-ho-so-huu-lau-dai', $projects ) ),
				array( 'Căn hộ dịch vụ (50 năm)', $type_link( 'can-ho-dich-vu', $projects ) ),
			) ),
			array( 'Thấp tầng', $type_link( 'thap-tang', $projects ), array(
				array( 'Biệt thự nghỉ dưỡng', $type_link( 'biet-thu', $projects ) ),
				array( 'Đất nền', $type_link( 'dat-nen', $projects ) ),
				array( 'Nhà phố – Shophouse', $type_link( 'shophouse', $projects ) ),
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

/**
 * Web chuyển từ giao diện cũ (Elementor / Elementor Pro theme builder): trang có mẫu Elementor gán sẵn
 * vẫn hiển thị bằng mẫu của Hoàng Hiệp cho trang chủ, dự án, nhà đất, tin tức, giới thiệu, liên hệ.
 */
/** Trang bảng tính căn /du-an/<dự án>/bang-tinh/. */
add_filter(
	'template_include',
	static fn( $template ) => function_exists( 'hh_is_units_page' ) && hh_is_units_page() ? get_theme_file_path( 'bang-tinh.php' ) : $template,
	97
);

/** Trang tổng hợp /san-pham/shop-khoi-de/, /san-pham/penthouse/, /san-pham/duplex/. */
add_filter(
	'template_include',
	static fn( $template ) => function_exists( 'hh_special_key' ) && hh_special_key( (string) get_query_var( 'hh_sp' ) ) ? get_theme_file_path( 'san-pham.php' ) : $template,
	98
);

add_filter( 'template_include', 'hoanghiep_override_builder_template', 999 );
function hoanghiep_override_builder_template( $template ) {
	if ( false === strpos( wp_normalize_path( (string) $template ), '/plugins/elementor' ) ) {
		return $template;
	}
	$ours = '';
	if ( is_front_page() ) {
		$ours = get_front_page_template();
	} elseif ( is_home() ) {
		$ours = get_home_template();
	} elseif ( is_singular( array( 'du-an', 'bat-dong-san', 'post' ) ) && ! ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) ) {
		$ours = get_single_template();
	} elseif ( is_page( array( 'gioi-thieu', 'lien-he', 'tin-tuc' ) ) ) {
		$ours = get_page_template();
	} elseif ( is_tax( array( 'loai-du-an', 'khu-vuc', 'loai-bds' ) ) ) {
		$ours = get_taxonomy_template();
	} elseif ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) {
		$ours = get_theme_file_path( 'bang-tinh.php' );
	} elseif ( get_query_var( 'hh_sp' ) ) {
		$ours = get_theme_file_path( 'san-pham.php' );
	} elseif ( is_post_type_archive( array( 'du-an', 'bat-dong-san' ) ) || is_category() ) {
		$ours = is_category() ? get_category_template() : get_archive_template();
	}
	return $ours ?: $template;
}


/** Nhắc tắt các plugin chỉ chạy được với giao diện Houzez (gây lỗi nghiêm trọng khi đã đổi giao diện). */
add_action( 'admin_notices', 'hoanghiep_old_theme_plugins_notice' );
function hoanghiep_old_theme_plugins_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$old = array_filter(
		(array) get_option( 'active_plugins', array() ),
		static fn( $p ) => 0 === strpos( $p, 'houzez-' ) || 0 === strpos( $p, 'redux-framework/' )
	);
	if ( $old ) {
		printf(
			'<div class="notice notice-error"><p><strong>Giao diện Hoàng Hiệp:</strong> hãy <a href="%s">vô hiệu hóa</a> các plugin của giao diện Houzez cũ (%s) – chúng gây lỗi nghiêm trọng khi không dùng giao diện Houzez.</p></div>',
			esc_url( admin_url( 'plugins.php?plugin_status=active' ) ),
			esc_html( implode( ', ', array_map( static fn( $p ) => dirname( $p ), $old ) ) )
		);
	}
}

/**
 * Menu chính: tự thêm các trang "Bảng giá thị trường" vào dưới mục Mua bán (khi mục đó chưa có menu con),
 * để menu đã tạo sẵn trên web cũ cũng có, không cần sửa tay.
 */
add_filter( 'wp_nav_menu_objects', 'hoanghiep_market_submenu', 10, 2 );
function hoanghiep_market_submenu( $items, $args ) {
	if ( 'primary' !== ( $args->theme_location ?? '' ) || ! function_exists( 'hh_deal_url' ) || ! function_exists( 'hh_market_pages' ) ) {
		return $items;
	}
	$target = untrailingslashit( hh_deal_url( 'ban' ) );
	$parent = null;
	foreach ( $items as $item ) {
		if ( untrailingslashit( $item->url ) === $target && ! $item->menu_item_parent ) {
			$parent = $item;
		}
	}
	if ( ! $parent ) {
		return $items;
	}
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent === (int) $parent->ID ) {
			return $items; // Đã có menu con do bạn tự tạo.
		}
	}
	$parent->classes[] = 'menu-item-has-children';
	$i                 = 0;
	foreach ( hh_market_pages() as $slug => list( $name ) ) {
		$term = get_term_by( 'slug', $slug, 'loai-bds' );
		if ( ! $term ) {
			continue;
		}
		$child                   = clone $parent;
		$child->ID               = -1000 - ( ++$i );
		$child->db_id            = $child->ID;
		$child->menu_item_parent = (string) $parent->ID;
		$child->title            = 'Bảng giá ' . mb_strtolower( $name );
		$child->url              = hh_deal_term_url( 'ban', $term );
		$child->classes          = array( 'menu-item' );
		$child->current          = false;
		$items[]                 = $child;
	}
	return $items;
}
