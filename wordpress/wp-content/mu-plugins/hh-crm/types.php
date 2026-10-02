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

	// Đẹp URL: /mua-ban/ và /cho-thue/.
	foreach ( array( 'mua-ban' => 'ban', 'cho-thue' => 'thue' ) as $slug => $deal ) {
		add_rewrite_rule( "^{$slug}/page/([0-9]+)/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal . '&paged=$matches[1]', 'top' );
		add_rewrite_rule( "^{$slug}/?$", 'index.php?post_type=bat-dong-san&hh_deal=' . $deal, 'top' );
	}

	if ( ! wp_installing() && get_option( 'hh_crm_rewrite' ) !== HH_CRM_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'hh_crm_rewrite', HH_CRM_VERSION );
	}
}

add_filter( 'query_vars', 'hh_query_vars' );
function hh_query_vars( $vars ) {
	return array_merge( $vars, array( 'hh_deal', 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'tt' ) );
}

function hh_deal_url( $deal ) {
	return home_url( 'ban' === $deal ? '/mua-ban/' : '/cho-thue/' );
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
	return '' === $from ? 'Đang cập nhật' : 'Từ ' . hh_format_price( $from );
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

/** Archive title for listing pages, e.g. "Nhà đất bán". */
function hh_listing_archive_title() {
	$deal = get_query_var( 'hh_deal' );
	if ( is_tax() ) {
		return single_term_title( '', false );
	}
	return 'ban' === $deal ? 'Nhà đất bán' : ( 'thue' === $deal ? 'Nhà đất cho thuê' : 'Nhà đất mua bán & cho thuê' );
}
