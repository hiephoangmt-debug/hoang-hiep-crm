<?php
/**
 * Chuyển dữ liệu từ giao diện Houzez (bất động sản kiểu "property") sang Hoàng Hiệp:
 * tin Bán / Cho thuê → Nhà đất, tin loại "Dự án" → Dự án. Giữ ảnh, giá, diện tích, phòng ngủ…
 * Link cũ của Houzez tự chuyển hướng 301 sang trang mới (giữ thứ hạng Google).
 *
 * Đọc thẳng cơ sở dữ liệu nên vẫn chạy khi plugin Houzez đã tắt. Chạy lại không tạo trùng.
 */

defined( 'ABSPATH' ) || exit;

const HH_HZ_TYPE = 'property';

/** Tên các term Houzez của một tin (đọc DB, không cần taxonomy còn đăng ký). */
function hh_hz_terms( $post_id, $taxonomies ) {
	global $wpdb;
	$in = implode( ',', array_fill( 0, count( (array) $taxonomies ), '%s' ) );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQLPlaceholders
	return $wpdb->get_col( $wpdb->prepare( "SELECT t.name FROM {$wpdb->terms} t JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = t.term_id JOIN {$wpdb->term_relationships} tr ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id = %d AND tt.taxonomy IN ($in)", array_merge( array( $post_id ), (array) $taxonomies ) ) );
}

function hh_hz_posts() {
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE post_type = %s AND post_status IN ('publish','draft','pending','private') ORDER BY post_date DESC", HH_HZ_TYPE ) );
}

/** "3.500.000.000", "3,5", "68.5 m²" → số. */
function hh_hz_number( $raw ) {
	$raw = preg_replace( '/[.,](?=\d{3}(\D|$))/', '', trim( (string) $raw ) ); // Bỏ dấu phân cách hàng nghìn.
	$num = (float) preg_replace( '/[^\d.]/', '', str_replace( ',', '.', $raw ) );
	return $num > 0 ? $num : '';
}

/** Số tiền Houzez (đồng) → triệu đồng; số nhỏ coi như đã là triệu. */
function hh_hz_money( $raw ) {
	$num = hh_hz_number( $raw );
	if ( '' === $num ) {
		return '';
	}
	return $num >= 100000 ? round( $num / 1000000, 2 ) : $num;
}

/** Tìm term của Hoàng Hiệp khớp tên Houzez (bỏ "Quận", "Huyện", "TP."…). */
function hh_hz_match_term( $names, $taxonomy, $aliases = array() ) {
	foreach ( (array) $names as $name ) {
		$clean = trim( preg_replace( '/^(quận|huyện|thành phố|tp\.?|thị xã|phường|xã)\s+/iu', '', $name ) );
		$slug  = sanitize_title( $clean );
		foreach ( $aliases as $needle => $target ) {
			if ( false !== mb_stripos( $name, $needle ) ) {
				$slug = $target;
				break;
			}
		}
		$term = get_term_by( 'slug', $slug, $taxonomy ) ?: get_term_by( 'name', $clean, $taxonomy );
		if ( $term ) {
			return (int) $term->term_id;
		}
	}
	return 0;
}

/** Xem trước: mỗi tin Houzez sẽ thành gì. */
function hh_hz_plan( $p ) {
	$status = hh_hz_terms( $p->ID, array( 'property_status', 'property_label' ) );
	$types  = hh_hz_terms( $p->ID, 'property_type' );
	$text   = mb_strtolower( implode( ' ', array_merge( $status, $types ) ) . ' ' . $p->post_title );
	$target = false !== mb_strpos( implode( ' ', array_map( 'mb_strtolower', $types ) ), 'dự án' ) ? 'du-an' : 'bat-dong-san';
	$deal   = preg_match( '/thuê|rent|lease/u', $text ) ? 'thue' : 'ban';
	return compact( 'status', 'types', 'target', 'deal' );
}

function hh_hz_import() {
	if ( function_exists( 'hh_seed_terms' ) ) {
		hh_seed_terms();
	}
	$count = array( 'bat-dong-san' => 0, 'du-an' => 0, 'skip' => 0 );
	$area_alias = array( 'hội an' => 'hoi-an', 'điện bàn' => 'dien-ban', 'duy xuyên' => 'duy-xuyen', 'hòa vang' => 'hoa-vang' );
	$type_alias = array( 'chung cư' => 'can-ho-chung-cu', 'căn hộ dịch vụ' => 'can-ho-dich-vu', 'căn hộ' => 'can-ho-chung-cu', 'apartment' => 'can-ho-chung-cu', 'condo' => 'can-ho-chung-cu', 'biệt thự' => 'biet-thu', 'villa' => 'biet-thu', 'shophouse' => 'shophouse', 'nhà phố' => 'nha-pho', 'nhà kiệt' => 'nha-kiet', 'nhà hẻm' => 'nha-kiet', 'house' => 'nha-pho', 'đất' => 'dat-nen', 'land' => 'dat-nen', 'mặt bằng' => 'mat-bang-kinh-doanh', 'văn phòng' => 'mat-bang-kinh-doanh', 'penthouse' => 'penthouse', 'duplex' => 'duplex' );

	foreach ( hh_hz_posts() as $p ) {
		$plan = hh_hz_plan( $p );
		$done = get_posts( array( 'post_type' => array( 'bat-dong-san', 'du-an' ), 'post_status' => 'any', 'fields' => 'ids', 'numberposts' => 1, 'meta_key' => '_hh_houzez_id', 'meta_value' => $p->ID ) );
		if ( $done ) {
			++$count['skip'];
			continue;
		}
		$m  = static fn( $k ) => trim( (string) get_post_meta( $p->ID, $k, true ) );
		$id = wp_insert_post(
			array(
				'post_type'    => $plan['target'],
				'post_status'  => $p->post_status,
				'post_title'   => $p->post_title,
				'post_name'    => $p->post_name,
				'post_content' => $p->post_content,
				'post_excerpt' => $p->post_excerpt,
				'post_date'    => $p->post_date,
				'post_author'  => $p->post_author,
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		$gallery = array_filter( array_map( 'absint', (array) get_post_meta( $p->ID, 'fave_property_images' ) ) );
		$thumb   = (int) get_post_meta( $p->ID, '_thumbnail_id', true );
		if ( $thumb ) {
			set_post_thumbnail( $id, $thumb );
		}
		$address = $m( 'fave_property_map_address' ) ?: $m( 'fave_property_address' );
		$price   = hh_hz_money( $m( 'fave_property_price' ) );
		$area    = hh_hz_match_term( hh_hz_terms( $p->ID, array( 'property_area', 'property_city', 'property_state' ) ), 'khu-vuc', $area_alias );

		if ( 'du-an' === $plan['target'] ) {
			$meta = array(
				'hh_p_address'    => $address,
				'hh_p_price_from' => $price,
				'hh_p_unit_area'  => $m( 'fave_property_size' ) ? $m( 'fave_property_size' ) . ' m²' : '',
				'hh_p_gallery'    => implode( ',', $gallery ),
				'hh_p_video'      => $m( 'fave_video_url' ),
				'hh_p_featured'   => '1' === $m( 'fave_featured' ) ? '1' : '',
			);
		} else {
			$features = hh_hz_terms( $p->ID, 'property_feature' );
			$meta     = array(
				'hh_deal'       => $plan['deal'],
				'hh_status'     => 'con-hang',
				'hh_price'      => $price,
				'hh_area'       => hh_hz_number( $m( 'fave_property_size' ) ?: $m( 'fave_property_land' ) ),
				'hh_area_use'   => hh_hz_number( $m( 'fave_property_land' ) && $m( 'fave_property_size' ) ? $m( 'fave_property_size' ) : '' ),
				'hh_bedrooms'   => hh_hz_number( $m( 'fave_property_bedrooms' ) ?: $m( 'fave_property_rooms' ) ),
				'hh_bathrooms'  => hh_hz_number( $m( 'fave_property_bathrooms' ) ),
				'hh_year'       => $m( 'fave_property_year' ),
				'hh_address'    => $address,
				'hh_gallery'    => implode( ',', $gallery ),
				'hh_video'      => $m( 'fave_video_url' ),
				'hh_features'   => implode( "\n", $features ),
				'hh_featured'   => '1' === $m( 'fave_featured' ) ? '1' : '',
			);
			$type = hh_hz_match_term( hh_hz_terms( $p->ID, 'property_type' ), 'loai-bds', $type_alias );
			if ( $type ) {
				wp_set_object_terms( $id, $type, 'loai-bds' );
			}
		}
		foreach ( array_filter( $meta, 'strlen' ) as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		if ( $area ) {
			wp_set_object_terms( $id, $area, 'khu-vuc' );
		}
		// Rank Math: giữ tiêu đề / mô tả / từ khóa SEO đã nhập.
		foreach ( array( 'rank_math_title', 'rank_math_description', 'rank_math_focus_keyword', '_yoast_wpseo_title', '_yoast_wpseo_metadesc', '_yoast_wpseo_focuskw' ) as $k ) {
			if ( '' !== $m( $k ) ) {
				update_post_meta( $id, $k, $m( $k ) );
			}
		}
		$old = get_permalink( $p->ID );
		update_post_meta( $id, '_hh_houzez_id', $p->ID );
		update_post_meta( $id, '_hh_old_path', $old ? untrailingslashit( (string) wp_parse_url( $old, PHP_URL_PATH ) ) : '' );
		update_post_meta( $id, '_hh_old_slug', $p->post_name );
		++$count[ $plan['target'] ];
	}
	flush_rewrite_rules();
	return $count;
}

/* -------------------------------------------------------------------------
 * Link cũ của Houzez (VD: /property/ten-tin/) → 301 sang trang mới
 * ---------------------------------------------------------------------- */

add_action( 'template_redirect', 'hh_hz_redirect', 1 );
function hh_hz_redirect() {
	$new = 0;
	if ( is_singular( HH_HZ_TYPE ) ) {
		$new = (int) current( get_posts( array( 'post_type' => array( 'bat-dong-san', 'du-an' ), 'fields' => 'ids', 'numberposts' => 1, 'meta_key' => '_hh_houzez_id', 'meta_value' => get_queried_object_id() ) ) );
	} elseif ( is_404() ) {
		$path = untrailingslashit( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( '' === $path ) {
			return;
		}
		$args = array( 'post_type' => array( 'bat-dong-san', 'du-an' ), 'fields' => 'ids', 'numberposts' => 1 );
		$new  = (int) current( get_posts( $args + array( 'meta_key' => '_hh_old_path', 'meta_value' => $path ) ) );
		if ( ! $new ) {
			$new = (int) current( get_posts( $args + array( 'meta_key' => '_hh_old_slug', 'meta_value' => basename( $path ) ) ) );
		}
	}
	if ( $new && 'publish' === get_post_status( $new ) ) {
		wp_safe_redirect( get_permalink( $new ), 301 );
		exit;
	}
}

/* -------------------------------------------------------------------------
 * Trang quản trị: Công cụ → Chuyển dữ liệu Houzez
 * ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'hh_hz_menu' );
function hh_hz_menu() {
	if ( hh_hz_posts() || get_option( 'hh_hz_imported' ) ) {
		add_management_page( 'Chuyển dữ liệu Houzez', 'Chuyển dữ liệu Houzez', 'manage_options', 'hh-houzez', 'hh_hz_page' );
	}
}

function hh_hz_page() {
	$result = null;
	if ( isset( $_POST['hh_hz'] ) && check_admin_referer( 'hh_hz_import' ) ) {
		$result = hh_hz_import();
		update_option( 'hh_hz_imported', time() );
	}
	$posts = hh_hz_posts();
	$label = array( 'bat-dong-san' => 'Nhà đất', 'du-an' => 'Dự án' );
	?>
	<div class="wrap">
		<h1>Chuyển dữ liệu từ Houzez</h1>
		<?php if ( $result ) : ?>
			<div class="notice notice-success"><p>Đã chuyển <strong><?php echo (int) $result['bat-dong-san']; ?></strong> tin nhà đất, <strong><?php echo (int) $result['du-an']; ?></strong> dự án. Bỏ qua <?php echo (int) $result['skip']; ?> tin đã chuyển trước đó.</p></div>
		<?php endif; ?>
		<p>Tìm thấy <strong><?php echo count( $posts ); ?></strong> tin của Houzez. Tin có loại "Dự án" chuyển thành <strong>Dự án</strong>, còn lại thành <strong>Nhà đất</strong> (Bán / Cho thuê theo trạng thái). Giữ ảnh đại diện, thư viện ảnh, giá (đổi sang triệu đồng), diện tích, phòng ngủ, WC, địa chỉ, video, tiện ích, tiêu đề & mô tả SEO.</p>
		<p><strong>Tin Houzez gốc không bị xóa.</strong> Link cũ tự chuyển hướng 301 sang trang mới. Chạy lại không tạo trùng. Nên sao lưu trước (UpdraftPlus).</p>
		<form method="post">
			<?php wp_nonce_field( 'hh_hz_import' ); ?>
			<p><button class="button button-primary button-hero" name="hh_hz" value="1">Chuyển dữ liệu</button></p>
		</form>
		<?php if ( $posts ) : ?>
			<h2>Xem trước</h2>
			<table class="widefat striped">
				<thead><tr><th>Tin Houzez</th><th>Loại / trạng thái</th><th>Giá gốc</th><th>Sẽ thành</th></tr></thead>
				<tbody>
				<?php foreach ( array_slice( $posts, 0, 200 ) as $p ) : ?>
					<?php
					$plan  = hh_hz_plan( $p );
					$price = hh_hz_money( get_post_meta( $p->ID, 'fave_property_price', true ) );
					$done  = get_posts( array( 'post_type' => array( 'bat-dong-san', 'du-an' ), 'post_status' => 'any', 'fields' => 'ids', 'numberposts' => 1, 'meta_key' => '_hh_houzez_id', 'meta_value' => $p->ID ) );
					?>
					<tr>
						<td><?php echo esc_html( $p->post_title ); ?></td>
						<td><?php echo esc_html( implode( ', ', array_merge( $plan['types'], $plan['status'] ) ) ); ?></td>
						<td><?php echo esc_html( get_post_meta( $p->ID, 'fave_property_price', true ) ); ?><?php echo '' !== $price ? ' → ' . esc_html( hh_format_price( $price, 'thue' === $plan['deal'] ) ) : ''; ?></td>
						<td><?php echo $done ? '✔ Đã chuyển' : esc_html( $label[ $plan['target'] ] . ( 'bat-dong-san' === $plan['target'] ? ( 'thue' === $plan['deal'] ? ' – Cho thuê' : ' – Bán' ) : '' ) ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}
