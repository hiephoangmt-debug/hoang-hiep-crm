<?php
/**
 * Plugin Name: Hoàng Hiệp CRM
 * Description: Dữ liệu bất động sản (dự án/căn hộ) và khách hàng tiềm năng thu từ form liên hệ cho hiephoangmt.com.
 * Version: 1.0.0
 * Author: Hoàng Hiệp
 */

defined( 'ABSPATH' ) || exit;

const HH_PROPERTY_FIELDS = array(
	'hh_price'    => 'Giá (VD: 3,5 tỷ)',
	'hh_area'     => 'Diện tích (m²)',
	'hh_address'  => 'Địa chỉ',
	'hh_bedrooms' => 'Số phòng ngủ',
	'hh_legal'    => 'Pháp lý (VD: Sổ hồng)',
);

const HH_PROPERTY_STATUSES = array(
	'dang-ban' => 'Đang bán',
	'cho-thue' => 'Cho thuê',
	'da-ban'   => 'Đã bán',
);

const HH_LEAD_STATUSES = array(
	'moi'          => 'Mới',
	'da-lien-he'   => 'Đã liên hệ',
	'dang-cham-soc'=> 'Đang chăm sóc',
	'chot'         => 'Đã chốt',
	'huy'          => 'Không tiềm năng',
);

/* -------------------------------------------------------------------------
 * Post types & taxonomies
 * ---------------------------------------------------------------------- */

add_action( 'init', 'hh_register_types' );
function hh_register_types() {
	register_post_type(
		'bat-dong-san',
		array(
			'labels'        => array(
				'name'          => 'Bất động sản',
				'singular_name' => 'Bất động sản',
				'add_new'       => 'Thêm mới',
				'add_new_item'  => 'Thêm bất động sản',
				'edit_item'     => 'Sửa bất động sản',
				'all_items'     => 'Tất cả BĐS',
				'search_items'  => 'Tìm BĐS',
				'not_found'     => 'Chưa có bất động sản nào',
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'bat-dong-san' ),
			'menu_icon'     => 'dashicons-building',
			'menu_position' => 5,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);

	register_taxonomy(
		'khu-vuc',
		'bat-dong-san',
		array(
			'labels'            => array(
				'name'          => 'Khu vực',
				'singular_name' => 'Khu vực',
				'add_new_item'  => 'Thêm khu vực',
			),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'khu-vuc' ),
		)
	);

	register_taxonomy(
		'loai-bds',
		'bat-dong-san',
		array(
			'labels'            => array(
				'name'          => 'Loại BĐS',
				'singular_name' => 'Loại BĐS',
				'add_new_item'  => 'Thêm loại BĐS',
			),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'loai-bds' ),
		)
	);

	register_post_type(
		'khach-hang',
		array(
			'labels'          => array(
				'name'          => 'Khách hàng',
				'singular_name' => 'Khách hàng',
				'add_new_item'  => 'Thêm khách hàng',
				'edit_item'     => 'Sửa khách hàng',
				'all_items'     => 'Tất cả khách hàng',
				'search_items'  => 'Tìm khách hàng',
				'not_found'     => 'Chưa có khách hàng nào',
			),
			'public'          => false,
			'show_ui'         => true,
			'menu_icon'       => 'dashicons-groups',
			'menu_position'   => 6,
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
		)
	);
}

/* -------------------------------------------------------------------------
 * Meta boxes
 * ---------------------------------------------------------------------- */

add_action( 'add_meta_boxes', 'hh_add_meta_boxes' );
function hh_add_meta_boxes() {
	add_meta_box( 'hh_property_info', 'Thông tin bất động sản', 'hh_property_meta_box', 'bat-dong-san', 'normal', 'high' );
	add_meta_box( 'hh_lead_info', 'Thông tin khách hàng', 'hh_lead_meta_box', 'khach-hang', 'normal', 'high' );
}

function hh_property_meta_box( $post ) {
	wp_nonce_field( 'hh_save_meta', 'hh_meta_nonce' );
	echo '<table class="form-table">';
	foreach ( HH_PROPERTY_FIELDS as $key => $label ) {
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" class="regular-text" id="%1$s" name="%1$s" value="%3$s"></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
	$current = get_post_meta( $post->ID, 'hh_status', true ) ?: 'dang-ban';
	echo '<tr><th><label for="hh_status">Trạng thái</label></th><td><select id="hh_status" name="hh_status">';
	foreach ( HH_PROPERTY_STATUSES as $value => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $current, $value, false ), esc_html( $label ) );
	}
	echo '</select></td></tr>';
	printf(
		'<tr><th><label for="hh_featured">Nổi bật</label></th><td><label><input type="checkbox" id="hh_featured" name="hh_featured" value="1"%s> Hiển thị ở trang chủ</label></td></tr>',
		checked( get_post_meta( $post->ID, 'hh_featured', true ), '1', false )
	);
	echo '</table>';
}

function hh_lead_meta_box( $post ) {
	wp_nonce_field( 'hh_save_meta', 'hh_meta_nonce' );
	$fields = array(
		'hh_phone' => 'Số điện thoại',
		'hh_email' => 'Email',
		'hh_need'  => 'Nhu cầu',
	);
	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		printf(
			'<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" class="regular-text" id="%1$s" name="%1$s" value="%3$s"></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
	$current = get_post_meta( $post->ID, 'hh_lead_status', true ) ?: 'moi';
	echo '<tr><th><label for="hh_lead_status">Trạng thái</label></th><td><select id="hh_lead_status" name="hh_lead_status">';
	foreach ( HH_LEAD_STATUSES as $value => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $current, $value, false ), esc_html( $label ) );
	}
	echo '</select></td></tr>';
	$property_id = (int) get_post_meta( $post->ID, 'hh_property_id', true );
	if ( $property_id ) {
		printf(
			'<tr><th>Quan tâm BĐS</th><td><a href="%s">%s</a></td></tr>',
			esc_url( get_edit_post_link( $property_id ) ),
			esc_html( get_the_title( $property_id ) )
		);
	}
	echo '</table>';
}

add_action( 'save_post', 'hh_save_meta', 10, 2 );
function hh_save_meta( $post_id, $post ) {
	if ( ! isset( $_POST['hh_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_meta_nonce'] ), 'hh_save_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( 'bat-dong-san' === $post->post_type ) {
		foreach ( array_keys( HH_PROPERTY_FIELDS ) as $key ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
		}
		$status = sanitize_key( $_POST['hh_status'] ?? '' );
		update_post_meta( $post_id, 'hh_status', isset( HH_PROPERTY_STATUSES[ $status ] ) ? $status : 'dang-ban' );
		update_post_meta( $post_id, 'hh_featured', empty( $_POST['hh_featured'] ) ? '0' : '1' );
	}

	if ( 'khach-hang' === $post->post_type ) {
		update_post_meta( $post_id, 'hh_phone', sanitize_text_field( wp_unslash( $_POST['hh_phone'] ?? '' ) ) );
		update_post_meta( $post_id, 'hh_email', sanitize_email( wp_unslash( $_POST['hh_email'] ?? '' ) ) );
		update_post_meta( $post_id, 'hh_need', sanitize_text_field( wp_unslash( $_POST['hh_need'] ?? '' ) ) );
		$status = sanitize_key( $_POST['hh_lead_status'] ?? '' );
		update_post_meta( $post_id, 'hh_lead_status', isset( HH_LEAD_STATUSES[ $status ] ) ? $status : 'moi' );
	}
}

/* -------------------------------------------------------------------------
 * Admin columns for leads
 * ---------------------------------------------------------------------- */

add_filter( 'manage_khach-hang_posts_columns', 'hh_lead_columns' );
function hh_lead_columns( $columns ) {
	return array(
		'cb'             => $columns['cb'],
		'title'          => 'Họ tên',
		'hh_phone'       => 'Điện thoại',
		'hh_email'       => 'Email',
		'hh_property'    => 'Quan tâm',
		'hh_lead_status' => 'Trạng thái',
		'date'           => 'Ngày gửi',
	);
}

add_action( 'manage_khach-hang_posts_custom_column', 'hh_lead_column_content', 10, 2 );
function hh_lead_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'hh_phone':
			$phone = get_post_meta( $post_id, 'hh_phone', true );
			printf( '<a href="tel:%s">%s</a>', esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ), esc_html( $phone ) );
			break;
		case 'hh_email':
			echo esc_html( get_post_meta( $post_id, 'hh_email', true ) );
			break;
		case 'hh_property':
			$property_id = (int) get_post_meta( $post_id, 'hh_property_id', true );
			echo $property_id ? esc_html( get_the_title( $property_id ) ) : '—';
			break;
		case 'hh_lead_status':
			$status = get_post_meta( $post_id, 'hh_lead_status', true ) ?: 'moi';
			echo esc_html( HH_LEAD_STATUSES[ $status ] ?? $status );
			break;
	}
}

/* -------------------------------------------------------------------------
 * Front-end lead form
 * ---------------------------------------------------------------------- */

/**
 * Render the contact / lead form. Usable as shortcode [hh_lead_form].
 */
function hh_lead_form( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'property_id' => 0,
			'title'       => 'Nhận tư vấn miễn phí',
		),
		$atts,
		'hh_lead_form'
	);

	$result = isset( $_GET['lien-he'] ) ? sanitize_key( $_GET['lien-he'] ) : '';

	ob_start();
	?>
	<form class="hh-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( $atts['title'] ) : ?>
			<h3 class="hh-form__title"><?php echo esc_html( $atts['title'] ); ?></h3>
		<?php endif; ?>
		<?php if ( 'ok' === $result ) : ?>
			<p class="hh-form__notice hh-form__notice--ok">Cảm ơn bạn! Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.</p>
		<?php elseif ( 'loi' === $result ) : ?>
			<p class="hh-form__notice hh-form__notice--error">Vui lòng nhập họ tên và số điện thoại hợp lệ.</p>
		<?php endif; ?>
		<input type="hidden" name="action" value="hh_lead">
		<input type="hidden" name="property_id" value="<?php echo (int) $atts['property_id']; ?>">
		<?php wp_nonce_field( 'hh_lead', 'hh_lead_nonce' ); ?>
		<div class="hh-form__hp" aria-hidden="true">
			<label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
		</div>
		<label>Họ và tên *<input type="text" name="name" required maxlength="100"></label>
		<label>Số điện thoại *<input type="tel" name="phone" required pattern="[0-9+ .]{9,15}" maxlength="15"></label>
		<label>Email<input type="email" name="email" maxlength="100"></label>
		<label>Nhu cầu
			<select name="need">
				<option value="Mua">Mua</option>
				<option value="Thuê">Thuê</option>
				<option value="Bán / Ký gửi">Bán / Ký gửi</option>
				<option value="Đầu tư">Đầu tư</option>
			</select>
		</label>
		<label>Lời nhắn<textarea name="message" rows="3" maxlength="1000"></textarea></label>
		<button type="submit" class="btn btn--primary">Gửi thông tin</button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hh_lead_form', 'hh_lead_form' );

add_action( 'admin_post_nopriv_hh_lead', 'hh_handle_lead' );
add_action( 'admin_post_hh_lead', 'hh_handle_lead' );
function hh_handle_lead() {
	$back = wp_get_referer() ?: home_url( '/' );
	$back = remove_query_arg( 'lien-he', $back );

	if ( ! isset( $_POST['hh_lead_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_lead_nonce'] ), 'hh_lead' ) ) {
		wp_safe_redirect( add_query_arg( 'lien-he', 'loi', $back ) . '#lien-he' );
		exit;
	}

	// Honeypot: bots fill every field; pretend success.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'lien-he', 'ok', $back ) . '#lien-he' );
		exit;
	}

	$name        = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$phone       = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$email       = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$need        = sanitize_text_field( wp_unslash( $_POST['need'] ?? '' ) );
	$message     = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	$property_id = absint( $_POST['property_id'] ?? 0 );

	if ( '' === $name || ! preg_match( '/^[0-9+ .]{9,15}$/', $phone ) ) {
		wp_safe_redirect( add_query_arg( 'lien-he', 'loi', $back ) . '#lien-he' );
		exit;
	}

	if ( $property_id && 'bat-dong-san' !== get_post_type( $property_id ) ) {
		$property_id = 0;
	}

	$lead_id = wp_insert_post(
		array(
			'post_type'    => 'khach-hang',
			'post_status'  => 'private',
			'post_title'   => $name,
			'post_content' => $message,
		)
	);

	if ( $lead_id && ! is_wp_error( $lead_id ) ) {
		update_post_meta( $lead_id, 'hh_phone', $phone );
		update_post_meta( $lead_id, 'hh_email', $email );
		update_post_meta( $lead_id, 'hh_need', $need );
		update_post_meta( $lead_id, 'hh_lead_status', 'moi' );
		if ( $property_id ) {
			update_post_meta( $lead_id, 'hh_property_id', $property_id );
		}

		$body  = "Khách hàng mới từ website:\n\n";
		$body .= "Họ tên: {$name}\nĐiện thoại: {$phone}\nEmail: {$email}\nNhu cầu: {$need}\n";
		if ( $property_id ) {
			$body .= 'Quan tâm: ' . get_the_title( $property_id ) . ' - ' . get_permalink( $property_id ) . "\n";
		}
		$body .= "\nLời nhắn:\n{$message}\n\nXem trong quản trị: " . admin_url( 'post.php?post=' . $lead_id . '&action=edit' );
		wp_mail( get_option( 'admin_email' ), '[Website] Khách hàng mới: ' . $name, $body );
	}

	wp_safe_redirect( add_query_arg( 'lien-he', 'ok', $back ) . '#lien-he' );
	exit;
}

/* -------------------------------------------------------------------------
 * Helpers for the theme
 * ---------------------------------------------------------------------- */

function hh_property_meta( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$meta    = array();
	foreach ( array_keys( HH_PROPERTY_FIELDS ) as $key ) {
		$meta[ $key ] = get_post_meta( $post_id, $key, true );
	}
	$status              = get_post_meta( $post_id, 'hh_status', true ) ?: 'dang-ban';
	$meta['hh_status']   = $status;
	$meta['status_label'] = HH_PROPERTY_STATUSES[ $status ] ?? '';
	return $meta;
}
