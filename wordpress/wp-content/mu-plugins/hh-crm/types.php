<?php
/**
 * Post types, taxonomies, meta boxes, admin columns, URLs and front-end filtering.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'hh_register_types' );
function hh_register_types() {
	register_post_type(
		'du-an',
		array(
			'labels'        => array(
				'name'          => 'Dự án',
				'singular_name' => 'Dự án',
				'add_new'       => 'Thêm dự án',
				'add_new_item'  => 'Thêm dự án mới',
				'edit_item'     => 'Sửa dự án',
				'all_items'     => 'Tất cả dự án',
				'search_items'  => 'Tìm dự án',
				'not_found'     => 'Chưa có dự án nào',
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'du-an' ),
			'menu_icon'     => 'dashicons-building',
			'menu_position' => 4,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);

	register_post_type(
		'bat-dong-san',
		array(
			'labels'        => array(
				'name'          => 'Nhà đất',
				'singular_name' => 'Tin nhà đất',
				'add_new'       => 'Đăng tin',
				'add_new_item'  => 'Đăng tin mua bán / cho thuê',
				'edit_item'     => 'Sửa tin',
				'all_items'     => 'Tất cả tin',
				'search_items'  => 'Tìm tin',
				'not_found'     => 'Chưa có tin nào',
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'nha-dat' ),
			'menu_icon'     => 'dashicons-admin-home',
			'menu_position' => 5,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);

	register_taxonomy(
		'khu-vuc',
		array( 'du-an', 'bat-dong-san' ),
		array(
			'labels'            => array( 'name' => 'Khu vực', 'singular_name' => 'Khu vực', 'add_new_item' => 'Thêm khu vực' ),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'khu-vuc' ),
		)
	);

	register_taxonomy(
		'loai-du-an',
		'du-an',
		array(
			'labels'            => array( 'name' => 'Loại dự án', 'singular_name' => 'Loại dự án', 'add_new_item' => 'Thêm loại dự án' ),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'loai-du-an' ),
		)
	);

	register_taxonomy(
		'loai-bds',
		'bat-dong-san',
		array(
			'labels'            => array( 'name' => 'Loại nhà đất', 'singular_name' => 'Loại nhà đất', 'add_new_item' => 'Thêm loại' ),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'loai-nha-dat' ),
		)
	);

	// Đẹp URL: /mua-ban/, /cho-thue/ và trang đích /mua-ban/{khu-vuc hoặc loai-nha-dat}/.
	foreach ( array( 'mua-ban' => 'ban', 'cho-thue' => 'thue' ) as $slug => $deal ) {
		add_rewrite_rule( "^{$slug}/(?!page/)([^/]+)/page/([0-9]+)/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal . '&hh_term=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( "^{$slug}/(?!page/)([^/]+)/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal . '&hh_term=$matches[1]', 'top' );
		add_rewrite_rule( "^{$slug}/page/([0-9]+)/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal . '&paged=$matches[1]', 'top' );
		add_rewrite_rule( "^{$slug}/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal, 'top' );
	}

	if ( ! wp_installing() && get_option( 'hh_crm_rewrite' ) !== HH_CRM_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'hh_crm_rewrite', HH_CRM_VERSION );
	}
}

/**
 * Default categories, created once (sửa / thêm trong quản trị sau đó).
 */
function hh_default_terms() {
	return array(
		'loai-du-an' => array(
			'cao-tang'  => array( 'Cao tầng', array(
				'can-ho-so-huu-lau-dai' => 'Căn hộ sở hữu lâu dài',
				'can-ho-dich-vu'  => 'Căn hộ dịch vụ (50 năm)',
			) ),
			'thap-tang' => array( 'Thấp tầng', array(
				'biet-thu'  => 'Biệt thự nghỉ dưỡng',
				'dat-nen'   => 'Đất nền',
				'shophouse' => 'Shophouse',
			) ),
		),
		'loai-bds'   => array(
			'can-ho-chung-cu'     => array( 'Căn hộ chung cư', array() ),
			'can-ho-dich-vu'      => array( 'Căn hộ dịch vụ', array() ),
			'penthouse'           => array( 'Penthouse', array() ),
			'duplex'              => array( 'Duplex', array() ),
			'shop-khoi-de'        => array( 'Shop khối đế', array() ),
			'nha-pho'             => array( 'Nhà phố', array() ),
			'nha-kiet'            => array( 'Nhà kiệt / hẻm', array() ),
			'biet-thu'            => array( 'Biệt thự', array() ),
			'shophouse'           => array( 'Shophouse', array() ),
			'dat-nen'             => array( 'Đất nền', array() ),
			'mat-bang-kinh-doanh' => array( 'Mặt bằng kinh doanh', array() ),
		),
		'khu-vuc'    => array(
			'hai-chau'      => array( 'Hải Châu', array() ),
			'thanh-khe'     => array( 'Thanh Khê', array() ),
			'son-tra'       => array( 'Sơn Trà', array() ),
			'ngu-hanh-son'  => array( 'Ngũ Hành Sơn', array() ),
			'lien-chieu'    => array( 'Liên Chiểu', array() ),
			'cam-le'        => array( 'Cẩm Lệ', array() ),
			'hoa-vang'      => array( 'Hòa Vang', array() ),
			'hoi-an'        => array( 'Hội An', array() ),
			'dien-ban'      => array( 'Điện Bàn', array() ),
			'duy-xuyen'     => array( 'Duy Xuyên', array() ),
		),
	);
}

add_action( 'init', 'hh_seed_terms', 20 );
function hh_seed_terms() {
	if ( wp_installing() || '4' === get_option( 'hh_terms_seeded' ) ) {
		return;
	}
	// Đổi tên cũ "Biệt thự" → "Biệt thự nghỉ dưỡng".
	$villa = get_term_by( 'slug', 'biet-thu', 'loai-du-an' );
	if ( $villa && 'Biệt thự' === $villa->name ) {
		wp_update_term( $villa->term_id, 'loai-du-an', array( 'name' => 'Biệt thự nghỉ dưỡng' ) );
	}
	// Đổi tên cũ "Căn hộ lâu dài" → "Căn hộ sở hữu lâu dài".
	$old = get_term_by( 'slug', 'can-ho-lau-dai', 'loai-du-an' );
	if ( $old ) {
		wp_update_term( $old->term_id, 'loai-du-an', array( 'name' => 'Căn hộ sở hữu lâu dài', 'slug' => 'can-ho-so-huu-lau-dai' ) );
	}
	foreach ( hh_default_terms() as $tax => $terms ) {
		foreach ( $terms as $slug => list( $name, $children ) ) {
			$parent = term_exists( $slug, $tax ) ?: wp_insert_term( $name, $tax, array( 'slug' => $slug ) );
			if ( is_wp_error( $parent ) ) {
				continue;
			}
			foreach ( $children as $child_slug => $child_name ) {
				if ( ! term_exists( $child_slug, $tax ) ) {
					wp_insert_term( $child_name, $tax, array( 'slug' => $child_slug, 'parent' => (int) $parent['term_id'] ) );
				}
			}
		}
	}
	update_option( 'hh_terms_seeded', '4' );
}

/** Most specific "Loại dự án" of a project (child term preferred). */
function hh_project_type( $post_id = null ) {
	$terms = get_the_terms( $post_id ?: get_the_ID(), 'loai-du-an' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return null;
	}
	usort( $terms, fn( $a, $b ) => (int) ( 0 === $a->parent ) - (int) ( 0 === $b->parent ) );
	return $terms[0];
}

/** Whether a project belongs to the "Cao tầng" branch. */
function hh_is_high_rise( $post_id = null ) {
	$type = hh_project_type( $post_id );
	if ( ! $type ) {
		return false;
	}
	$ancestors = get_ancestors( $type->term_id, 'loai-du-an', 'taxonomy' );
	$root      = $ancestors ? get_term( (int) end( $ancestors ), 'loai-du-an' ) : $type;
	return $root && ! is_wp_error( $root ) && 'cao-tang' === $root->slug;
}

add_filter( 'query_vars', 'hh_query_vars' );
function hh_query_vars( $vars ) {
	return array_merge( $vars, array( 'hh_deal', 'hh_term', 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'tt' ) );
}

function hh_deal_url( $deal ) {
	return home_url( 'ban' === $deal ? '/mua-ban/' : '/cho-thue/' );
}

/** SEO landing URL, e.g. /mua-ban/son-tra/. */
function hh_deal_term_url( $deal, $term ) {
	return trailingslashit( hh_deal_url( $deal ) . $term->slug );
}

/** Term (khu-vuc or loai-bds) of the current /mua-ban/{slug}/ page, or null. */
function hh_current_deal_term() {
	$slug = sanitize_title( (string) get_query_var( 'hh_term' ) );
	if ( '' === $slug ) {
		return null;
	}
	foreach ( array( 'khu-vuc', 'loai-bds' ) as $tax ) {
		$term = get_term_by( 'slug', $slug, $tax );
		if ( $term ) {
			return $term;
		}
	}
	return false;
}

/** Landing terms of a deal that have at least one listing: [term, count]. */
function hh_deal_landing_terms( $deal, $taxonomy ) {
	$out = array();
	foreach ( get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => true, 'orderby' => 'term_id' ) ) ?: array() as $term ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'bat-dong-san',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_query'     => array( array( 'key' => 'hh_deal', 'value' => $deal ) ),
				'tax_query'      => array( array( 'taxonomy' => $taxonomy, 'terms' => $term->term_id ) ),
			)
		);
		if ( $q->found_posts ) {
			$out[] = array( $term, (int) $q->found_posts );
		}
	}
	return $out;
}

/**
 * Market numbers for the current listing archive (all pages, not only the visible one).
 * Returns count, min/max price (triệu), average price per m² (triệu), latest date, top areas.
 */
function hh_listing_stats() {
	global $wp_query;
	$vars                   = $wp_query->query_vars;
	$vars['posts_per_page'] = 500;
	$vars['paged']          = 1;
	$vars['fields']         = 'ids';
	$vars['no_found_rows']  = true;
	$ids                    = get_posts( $vars );
	$prices                 = array();
	$per_m2                 = array();
	$areas                  = array();
	$latest                 = 0;
	foreach ( $ids as $id ) {
		$price = (float) get_post_meta( $id, 'hh_price', true );
		$size  = (float) get_post_meta( $id, 'hh_area', true );
		if ( $price > 0 ) {
			$prices[] = $price;
			if ( $size > 0 ) {
				$per_m2[] = $price / $size;
			}
		}
		$latest = max( $latest, (int) get_post_modified_time( 'U', true, $id ) );
		foreach ( get_the_terms( $id, 'khu-vuc' ) ?: array() as $t ) {
			$areas[ $t->name ] = ( $areas[ $t->name ] ?? 0 ) + 1;
		}
	}
	arsort( $areas );
	return array(
		'count'  => count( $ids ),
		'min'    => $prices ? min( $prices ) : 0,
		'max'    => $prices ? max( $prices ) : 0,
		'avg_m2' => $per_m2 ? array_sum( $per_m2 ) / count( $per_m2 ) : 0,
		'latest' => $latest,
		'areas'  => array_slice( $areas, 0, 3, true ),
	);
}

/* -------------------------------------------------------------------------
 * Meta boxes
 * ---------------------------------------------------------------------- */

add_action( 'add_meta_boxes', 'hh_add_meta_boxes' );
function hh_add_meta_boxes() {
	add_meta_box( 'hh_project', 'Thông tin dự án', fn( $post ) => hh_render_meta_box( $post, hh_project_schema() ), 'du-an', 'normal', 'high' );
	add_meta_box( 'hh_listing', 'Thông tin nhà đất', fn( $post ) => hh_render_meta_box( $post, hh_listing_schema() ), 'bat-dong-san', 'normal', 'high' );
}

add_action( 'save_post', 'hh_save_post_meta', 10, 2 );
function hh_save_post_meta( $post_id, $post ) {
	if ( ! isset( $_POST['hh_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_meta_nonce'] ), 'hh_save_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'du-an' === $post->post_type ) {
		hh_save_schema( $post_id, hh_project_schema() );
	} elseif ( 'bat-dong-san' === $post->post_type ) {
		hh_save_schema( $post_id, hh_listing_schema() );
	}
}

/* -------------------------------------------------------------------------
 * Admin list columns
 * ---------------------------------------------------------------------- */

add_filter( 'manage_bat-dong-san_posts_columns', 'hh_listing_columns' );
function hh_listing_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['hh_code']   = 'Mã tin';
			$new['hh_deal']   = 'Hình thức';
			$new['hh_price']  = 'Giá';
			$new['hh_area']   = 'Diện tích';
			$new['hh_status'] = 'Tình trạng';
		}
	}
	return $new;
}

add_action( 'manage_bat-dong-san_posts_custom_column', 'hh_listing_column', 10, 2 );
function hh_listing_column( $column, $post_id ) {
	$schema = hh_listing_schema();
	switch ( $column ) {
		case 'hh_code':
			echo esc_html( hh_listing_code( $post_id ) );
			break;
		case 'hh_deal':
		case 'hh_status':
			echo esc_html( hh_option_label( $schema, $column, hh_meta( $column, $post_id ) ) );
			break;
		case 'hh_price':
			echo esc_html( hh_listing_price( $post_id ) );
			break;
		case 'hh_area':
			$area = hh_meta( 'hh_area', $post_id );
			echo $area ? esc_html( $area . ' m²' ) : '—';
			break;
	}
}

add_filter( 'manage_du-an_posts_columns', 'hh_project_columns' );
function hh_project_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['hh_p_status']     = 'Tình trạng';
			$new['hh_p_price_from'] = 'Giá từ';
			$new['hh_p_featured']   = 'Nổi bật';
		}
	}
	return $new;
}

add_action( 'manage_du-an_posts_custom_column', 'hh_project_column', 10, 2 );
function hh_project_column( $column, $post_id ) {
	switch ( $column ) {
		case 'hh_p_status':
			echo esc_html( hh_option_label( hh_project_schema(), $column, hh_meta( $column, $post_id ) ) );
			break;
		case 'hh_p_price_from':
			echo esc_html( hh_project_price( $post_id ) );
			break;
		case 'hh_p_featured':
			echo '1' === hh_meta( $column, $post_id ) ? '★' : '';
			break;
	}
}

/* -------------------------------------------------------------------------
 * Template helpers
 * ---------------------------------------------------------------------- */

function hh_listing_code( $post_id = null ) {
	return 'HH' . str_pad( (string) ( $post_id ?: get_the_ID() ), 5, '0', STR_PAD_LEFT );
}

function hh_listing_price( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	return hh_format_price( hh_meta( 'hh_price', $post_id ), 'thue' === hh_meta( 'hh_deal', $post_id ) );
}

/** Price per m² for sale listings, e.g. "44,4 triệu/m²". */
function hh_listing_price_m2( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$price   = (float) hh_meta( 'hh_price', $post_id );
	$area    = (float) hh_meta( 'hh_area', $post_id );
	if ( 'thue' === hh_meta( 'hh_deal', $post_id ) || $price <= 0 || $area <= 0 ) {
		return '';
	}
	return rtrim( rtrim( number_format( $price / $area, 1, ',', '.' ), '0' ), ',' ) . ' triệu/m²';
}

function hh_project_price( $post_id = null ) {
	$from = hh_meta( 'hh_p_price_from', $post_id );
	return '' === $from ? 'Giá: Liên hệ' : 'Từ ' . hh_format_price( $from );
}

/** Spec rows [label => value] for a listing, skipping empty values. */
function hh_listing_specs( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$schema  = hh_listing_schema();
	$m       = static fn( $k ) => hh_meta( $k, $post_id );
	$opt     = static fn( $k ) => hh_option_label( $schema, $k, $m( $k ) );
	$terms   = static function ( $tax ) use ( $post_id ) {
		$t = get_the_terms( $post_id, $tax );
		return $t && ! is_wp_error( $t ) ? implode( ', ', wp_list_pluck( $t, 'name' ) ) : '';
	};
	$project = (int) $m( 'hh_project' );

	$rows = array(
		'Mã tin'              => hh_listing_code( $post_id ),
		'Hình thức'           => $opt( 'hh_deal' ),
		'Loại nhà đất'        => $terms( 'loai-bds' ),
		'Giá'                 => hh_listing_price( $post_id ) . ( '1' === $m( 'hh_negotiable' ) ? ' (thương lượng)' : '' ),
		'Đơn giá'             => hh_listing_price_m2( $post_id ),
		'Diện tích'           => $m( 'hh_area' ) ? $m( 'hh_area' ) . ' m²' : '',
		'Diện tích sử dụng'   => $m( 'hh_area_use' ) ? $m( 'hh_area_use' ) . ' m²' : '',
		'Kích thước'          => $m( 'hh_width' ) && $m( 'hh_length' ) ? $m( 'hh_width' ) . ' × ' . $m( 'hh_length' ) . ' m' : '',
		'Mặt tiền'            => $m( 'hh_frontage' ) ? $m( 'hh_frontage' ) . ' m' : '',
		'Đường vào'           => $m( 'hh_road' ) ? $m( 'hh_road' ) . ' m' : '',
		'Hướng nhà'           => $m( 'hh_direction' ) ? $opt( 'hh_direction' ) : '',
		'Hướng ban công'      => $m( 'hh_balcony' ) ? $opt( 'hh_balcony' ) : '',
		'Số tầng'             => $m( 'hh_floors' ),
		'Tầng'                => $m( 'hh_floor_no' ),
		'Phòng ngủ'           => $m( 'hh_bedrooms' ),
		'Phòng vệ sinh'       => $m( 'hh_bathrooms' ),
		'Nội thất'            => $m( 'hh_furniture' ) ? $opt( 'hh_furniture' ) : '',
		'Pháp lý'             => $m( 'hh_legal' ) ? $opt( 'hh_legal' ) : '',
		'Năm xây dựng'        => $m( 'hh_year' ),
		'Khu vực'             => $terms( 'khu-vuc' ),
		'Dự án'               => $project ? get_the_title( $project ) : '',
		'Tình trạng'          => $opt( 'hh_status' ),
	);
	return array_filter( $rows, 'strlen' );
}

/** Overview rows for a project, skipping empty values. */
function hh_project_specs( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$m       = static fn( $k ) => hh_meta( $k, $post_id );
	$rows    = array(
		'Tên thương mại'        => $m( 'hh_p_name' ),
		'Chủ đầu tư'            => $m( 'hh_p_developer' ),
		'Vị trí'                => $m( 'hh_p_address' ),
		'Loại hình'             => $m( 'hh_p_type' ),
		'Quy mô'                => $m( 'hh_p_scale' ),
		'Mật độ xây dựng'       => $m( 'hh_p_density' ),
		'Số tòa'                => $m( 'hh_p_blocks' ),
		'Số tầng'               => $m( 'hh_p_floors' ),
		'Tổng số sản phẩm'      => $m( 'hh_p_units' ),
		'Diện tích sản phẩm'    => $m( 'hh_p_unit_area' ),
		'Giá bán'               => '' !== $m( 'hh_p_price_from' ) ? hh_project_price( $post_id ) : '',
		'Đơn giá'               => $m( 'hh_p_price_m2' ),
		'Pháp lý'               => $m( 'hh_p_legal' ),
		'Hình thức sở hữu'      => $m( 'hh_p_ownership' ),
		'Khởi công'             => $m( 'hh_p_start' ),
		'Bàn giao'              => $m( 'hh_p_handover' ),
		'Tiêu chuẩn bàn giao'   => $m( 'hh_p_handover_std' ),
		'Nhà thầu'              => $m( 'hh_p_builder' ),
		'Thiết kế'              => $m( 'hh_p_designer' ),
		'Quản lý vận hành'      => $m( 'hh_p_manager' ),
		'Tình trạng'            => hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) ),
	);
	return array_filter( $rows, 'strlen' );
}

/**
 * "Hot & mới": tin/dự án đánh dấu HOT trước, sau đó tới bài mới nhất – chỉ cùng loại.
 *
 * @param string $post_type du-an | bat-dong-san
 * @param array  $args      exclude (int[]), limit (int), deal (ban|thue), type_term (int, loai-du-an)
 */
function hh_hot_query( $post_type, $args = array() ) {
	$args  = wp_parse_args( $args, array( 'exclude' => array(), 'limit' => 6, 'deal' => '', 'type_term' => 0 ) );
	$flag  = 'du-an' === $post_type ? 'hh_p_featured' : 'hh_featured';
	$base  = array(
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => $args['limit'],
		'post__not_in'   => array_map( 'intval', (array) $args['exclude'] ),
		'no_found_rows'  => true,
	);
	$meta = array();
	if ( $args['deal'] ) {
		$meta[] = array( 'key' => 'hh_deal', 'value' => $args['deal'] );
	}
	if ( 'bat-dong-san' === $post_type ) {
		$meta[] = array( 'key' => 'hh_status', 'value' => 'da-giao-dich', 'compare' => '!=' );
	}
	if ( $args['type_term'] ) {
		$base['tax_query'] = array( array( 'taxonomy' => 'loai-du-an', 'terms' => (int) $args['type_term'], 'include_children' => true ) );
	}
	$hot = get_posts( array_merge( $base, array( 'meta_query' => array_merge( $meta, array( array( 'key' => $flag, 'value' => '1' ) ) ) ) ) );
	$new = get_posts( array_merge( $base, $meta ? array( 'meta_query' => $meta ) : array() ) );
	$ids = array_slice( array_values( array_unique( array_merge( $hot, $new ) ) ), 0, $args['limit'] );

	return new WP_Query(
		array(
			'post_type'           => $post_type,
			'post__in'            => $ids ?: array( 0 ),
			'orderby'             => 'post__in',
			'posts_per_page'      => $args['limit'],
			'ignore_sticky_posts' => true,
		)
	);
}

function hh_is_hot( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	return '1' === hh_meta( 'du-an' === get_post_type( $post_id ) ? 'hh_p_featured' : 'hh_featured', $post_id );
}

/* -------------------------------------------------------------------------
 * Front-end filtering
 * ---------------------------------------------------------------------- */

function hh_price_ranges( $deal ) {
	return 'thue' === $deal
		? array( '0-5' => 'Dưới 5 triệu', '5-10' => '5 – 10 triệu', '10-20' => '10 – 20 triệu', '20-50' => '20 – 50 triệu', '50-' => 'Trên 50 triệu' )
		: array( '0-1000' => 'Dưới 1 tỷ', '1000-3000' => '1 – 3 tỷ', '3000-5000' => '3 – 5 tỷ', '5000-10000' => '5 – 10 tỷ', '10000-' => 'Trên 10 tỷ' );
}

function hh_area_ranges() {
	return array( '0-50' => 'Dưới 50 m²', '50-80' => '50 – 80 m²', '80-120' => '80 – 120 m²', '120-200' => '120 – 200 m²', '200-' => 'Trên 200 m²' );
}

function hh_sort_options() {
	return array( '' => 'Mới nhất', 'gia-tang' => 'Giá thấp → cao', 'gia-giam' => 'Giá cao → thấp', 'dt-giam' => 'Diện tích lớn nhất' );
}

function hh_range_clause( $key, $range ) {
	if ( ! preg_match( '/^(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)?$/', (string) $range, $m ) ) {
		return null;
	}
	if ( isset( $m[2] ) && '' !== $m[2] ) {
		return array( 'key' => $key, 'value' => array( (float) $m[1], (float) $m[2] ), 'compare' => 'BETWEEN', 'type' => 'DECIMAL(14,2)' );
	}
	return array( 'key' => $key, 'value' => (float) $m[1], 'compare' => '>=', 'type' => 'DECIMAL(14,2)' );
}

add_action( 'pre_get_posts', 'hh_filter_queries' );
function hh_filter_queries( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}

	$is_listing = $q->is_post_type_archive( 'bat-dong-san' ) || $q->is_tax( 'loai-bds' );
	$is_project = $q->is_post_type_archive( 'du-an' ) || $q->is_tax( 'loai-du-an' );

	if ( ! $is_listing && ! $is_project ) {
		return;
	}

	$meta = array();
	if ( $q->get( 'tk' ) ) {
		$q->set( 's', sanitize_text_field( $q->get( 'tk' ) ) );
	}

	if ( $is_project ) {
		$q->set( 'posts_per_page', 9 );
		$status = sanitize_key( $q->get( 'tt' ) );
		if ( $status ) {
			$meta[] = array( 'key' => 'hh_p_status', 'value' => $status );
		}
	}

	if ( $is_listing ) {
		$q->set( 'posts_per_page', 12 );
		$deal = sanitize_key( $q->get( 'hh_deal' ) );
		if ( in_array( $deal, array( 'ban', 'thue' ), true ) ) {
			$meta[] = array( 'key' => 'hh_deal', 'value' => $deal );
		}
		if ( $q->get( 'hh_term' ) ) {
			$slug = sanitize_title( (string) $q->get( 'hh_term' ) );
			$term = null;
			foreach ( array( 'khu-vuc', 'loai-bds' ) as $tax ) {
				$term = $term ?: get_term_by( 'slug', $slug, $tax );
			}
			if ( $term ) {
				$q->set( 'tax_query', array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id, 'include_children' => true ) ) );
			} else {
				$q->set( 'post__in', array( 0 ) );
				add_action( 'template_redirect', static function () {
					global $wp_query;
					$wp_query->set_404();
					status_header( 404 );
				}, 1 );
			}
		}
		foreach ( array( 'gia' => 'hh_price', 'dt' => 'hh_area' ) as $var => $key ) {
			$clause = hh_range_clause( $key, $q->get( $var ) );
			if ( $clause ) {
				$meta[] = $clause;
			}
		}
		$pn = absint( $q->get( 'pn' ) );
		if ( $pn ) {
			$meta[] = array( 'key' => 'hh_bedrooms', 'value' => $pn, 'compare' => $pn >= 4 ? '>=' : '=', 'type' => 'NUMERIC' );
		}
		$huong = sanitize_key( $q->get( 'huong' ) );
		if ( $huong && isset( HH_DIRECTIONS[ $huong ] ) ) {
			$meta[] = array( 'key' => 'hh_direction', 'value' => $huong );
		}

		switch ( $q->get( 'sx' ) ) {
			case 'gia-tang':
			case 'gia-giam':
				$meta['price_clause'] = array( 'key' => 'hh_price', 'type' => 'DECIMAL(14,2)', 'compare' => 'EXISTS' );
				$q->set( 'orderby', array( 'price_clause' => 'gia-tang' === $q->get( 'sx' ) ? 'ASC' : 'DESC' ) );
				break;
			case 'dt-giam':
				$meta['area_clause'] = array( 'key' => 'hh_area', 'type' => 'DECIMAL(14,2)', 'compare' => 'EXISTS' );
				$q->set( 'orderby', array( 'area_clause' => 'DESC' ) );
				break;
		}
	}

	if ( $meta ) {
		$q->set( 'meta_query', array_merge( array( 'relation' => 'AND' ), $meta ) );
	}
}

/** Archive title for listing pages, e.g. "Nhà đất bán Sơn Trà, Đà Nẵng", "Cho thuê căn hộ chung cư Đà Nẵng". */
function hh_listing_archive_title() {
	$deal = get_query_var( 'hh_deal' );
	$term = hh_current_deal_term();
	if ( ! $term && is_tax( 'loai-bds' ) ) {
		$term = get_queried_object();
	}
	$verb = 'ban' === $deal ? 'Bán' : ( 'thue' === $deal ? 'Cho thuê' : 'Mua bán, cho thuê' );
	if ( $term && 'loai-bds' === $term->taxonomy ) {
		return $verb . ' ' . mb_strtolower( $term->name ) . ' Đà Nẵng';
	}
	$base = 'ban' === $deal ? 'Nhà đất bán' : ( 'thue' === $deal ? 'Nhà đất cho thuê' : 'Nhà đất mua bán & cho thuê' );
	if ( $term && 'khu-vuc' === $term->taxonomy ) {
		return $base . ' ' . $term->name . ', Đà Nẵng';
	}
	return $base . ' Đà Nẵng';
}
