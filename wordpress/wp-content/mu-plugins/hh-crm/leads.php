<?php
/**
 * Khách hàng tiềm năng: lưu từ form trên website, quản lý trong wp-admin.
 */

defined( 'ABSPATH' ) || exit;

const HH_LEAD_STATUSES = array(
	'moi'           => 'Mới',
	'da-lien-he'    => 'Đã liên hệ',
	'dang-cham-soc' => 'Đang chăm sóc',
	'chot'          => 'Đã chốt',
	'huy'           => 'Không tiềm năng',
);

const HH_LEAD_NEEDS = array( 'Mua', 'Thuê', 'Nhận bảng giá dự án', 'Đặt lịch xem nhà', 'Ký gửi bán / cho thuê', 'Tư vấn đầu tư' );

add_action( 'init', 'hh_register_leads' );
function hh_register_leads() {
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

add_action( 'add_meta_boxes', 'hh_add_lead_box' );
function hh_add_lead_box() {
	add_meta_box( 'hh_lead_info', 'Thông tin khách hàng', 'hh_lead_meta_box', 'khach-hang', 'normal', 'high' );
}

function hh_lead_meta_box( $post ) {
	wp_nonce_field( 'hh_save_lead', 'hh_lead_meta_nonce' );
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
	$ref = (int) get_post_meta( $post->ID, 'hh_property_id', true );
	if ( $ref ) {
		printf(
			'<tr><th>Quan tâm</th><td><a href="%s">%s</a></td></tr>',
			esc_url( get_edit_post_link( $ref ) ),
			esc_html( get_the_title( $ref ) )
		);
	}
	echo '</table>';
}

add_action( 'save_post_khach-hang', 'hh_save_lead_meta' );
function hh_save_lead_meta( $post_id ) {
	if ( ! isset( $_POST['hh_lead_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_lead_meta_nonce'] ), 'hh_save_lead' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'hh_phone', sanitize_text_field( wp_unslash( $_POST['hh_phone'] ?? '' ) ) );
	update_post_meta( $post_id, 'hh_email', sanitize_email( wp_unslash( $_POST['hh_email'] ?? '' ) ) );
	update_post_meta( $post_id, 'hh_need', sanitize_text_field( wp_unslash( $_POST['hh_need'] ?? '' ) ) );
	$status = sanitize_key( $_POST['hh_lead_status'] ?? '' );
	update_post_meta( $post_id, 'hh_lead_status', isset( HH_LEAD_STATUSES[ $status ] ) ? $status : 'moi' );
}

add_filter( 'manage_khach-hang_posts_columns', 'hh_lead_columns' );
function hh_lead_columns( $columns ) {
	return array(
		'cb'             => $columns['cb'],
		'title'          => 'Họ tên',
		'hh_phone'       => 'Điện thoại',
		'hh_need'        => 'Nhu cầu',
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
		case 'hh_need':
			echo esc_html( get_post_meta( $post_id, 'hh_need', true ) );
			break;
		case 'hh_property':
			$ref = (int) get_post_meta( $post_id, 'hh_property_id', true );
			echo $ref ? esc_html( get_the_title( $ref ) ) : '—';
			break;
		case 'hh_lead_status':
			$status = get_post_meta( $post_id, 'hh_lead_status', true ) ?: 'moi';
			echo esc_html( HH_LEAD_STATUSES[ $status ] ?? $status );
			break;
	}
}

/* -------------------------------------------------------------------------
 * Front-end form – shortcode [hh_lead_form title="" need="" ref_id=""]
 * ---------------------------------------------------------------------- */

function hh_lead_form( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'ref_id' => 0,
			'title'  => 'Nhận tư vấn miễn phí',
			'need'   => '',
			'button' => 'Gửi thông tin',
			'compact' => false, // Chỉ họ tên + số điện thoại (form đầu trang, popup).
			'message' => '',
		),
		$atts,
		'hh_lead_form'
	);

	$result = isset( $_GET['lien-he'] ) ? sanitize_key( $_GET['lien-he'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

	ob_start();
	?>
	<form class="hh-form<?php echo $atts['compact'] ? ' hh-form--compact' : ''; ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( $atts['title'] ) : ?>
			<h3 class="hh-form__title"><?php echo esc_html( $atts['title'] ); ?></h3>
		<?php endif; ?>
		<?php if ( 'ok' === $result ) : ?>
			<p class="hh-form__notice hh-form__notice--ok">Cảm ơn bạn! Hiệp sẽ liên hệ lại trong thời gian sớm nhất.</p>
		<?php elseif ( 'loi' === $result ) : ?>
			<p class="hh-form__notice hh-form__notice--error">Vui lòng nhập họ tên và số điện thoại hợp lệ (9–15 chữ số).</p>
		<?php endif; ?>
		<input type="hidden" name="action" value="hh_lead">
		<input type="hidden" name="ref_id" value="<?php echo (int) $atts['ref_id']; ?>">
		<?php wp_nonce_field( 'hh_lead', 'hh_lead_nonce' ); ?>
		<div class="hh-form__hp" aria-hidden="true">
			<label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
		</div>
		<label>Họ và tên *<input type="text" name="name" required maxlength="100" autocomplete="name"></label>
		<label>Số điện thoại *<input type="tel" name="phone" required pattern="[0-9+ .]{9,15}" maxlength="15" autocomplete="tel"></label>
		<?php if ( $atts['compact'] ) : ?>
			<input type="hidden" name="need" value="<?php echo esc_attr( $atts['need'] ); ?>">
			<input type="hidden" name="message" value="<?php echo esc_attr( $atts['message'] ); ?>">
		<?php else : ?>
		<label>Nhu cầu
			<select name="need">
				<?php foreach ( HH_LEAD_NEEDS as $need ) : ?>
					<option value="<?php echo esc_attr( $need ); ?>" <?php selected( $atts['need'], $need ); ?>><?php echo esc_html( $need ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Lời nhắn<textarea name="message" rows="3" maxlength="1000"></textarea></label>
		<?php endif; ?>
		<button type="submit" class="btn btn--gold btn--block"><?php echo esc_html( $atts['button'] ); ?></button>
		<p class="hh-form__note">Thông tin của bạn được bảo mật và chỉ dùng để tư vấn.</p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hh_lead_form', 'hh_lead_form' );

add_action( 'admin_post_nopriv_hh_lead', 'hh_handle_lead' );
add_action( 'admin_post_hh_lead', 'hh_handle_lead' );
function hh_handle_lead() {
	$back = remove_query_arg( 'lien-he', wp_get_referer() ?: home_url( '/' ) );
	$go   = static function ( $result ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'lien-he', $result, $back ) . '#lien-he' );
		exit;
	};

	if ( ! isset( $_POST['hh_lead_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_lead_nonce'] ), 'hh_lead' ) ) {
		$go( 'loi' );
	}
	// Honeypot: bots fill every field; pretend success.
	if ( ! empty( $_POST['website'] ) ) {
		$go( 'ok' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$need    = sanitize_text_field( wp_unslash( $_POST['need'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	$ref_id  = absint( $_POST['ref_id'] ?? 0 );

	if ( '' === $name || ! preg_match( '/^[0-9+ .]{9,15}$/', $phone ) ) {
		$go( 'loi' );
	}
	if ( $ref_id && ! in_array( get_post_type( $ref_id ), array( 'bat-dong-san', 'du-an' ), true ) ) {
		$ref_id = 0;
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
		update_post_meta( $lead_id, 'hh_need', $need );
		update_post_meta( $lead_id, 'hh_lead_status', 'moi' );
		if ( $ref_id ) {
			update_post_meta( $lead_id, 'hh_property_id', $ref_id );
		}

		$body = "Khách hàng mới từ website:\n\nHọ tên: {$name}\nĐiện thoại: {$phone}\nNhu cầu: {$need}\n";
		if ( $ref_id ) {
			$body .= 'Quan tâm: ' . get_the_title( $ref_id ) . ' – ' . get_permalink( $ref_id ) . "\n";
		}
		$body .= "\nLời nhắn:\n{$message}\n\nXem trong quản trị: " . admin_url( 'post.php?post=' . $lead_id . '&action=edit' );
		hh_lead_mail( '[Website] Khách hàng mới: ' . $name . ' – ' . $phone, $body );
	}

	$go( 'ok' );
}

/* -------------------------------------------------------------------------
 * Email báo khách mới: người nhận, gửi thử, ghi lỗi gửi
 * ---------------------------------------------------------------------- */

/** Danh sách email nhận thông báo: ô "Email nhận thông báo" → email liên hệ của giao diện → email quản trị. */
function hh_lead_recipients() {
	$list = (string) get_option( 'hh_lead_emails', '' );
	if ( '' === trim( $list ) && function_exists( 'hoanghiep_opt' ) ) {
		$list = (string) hoanghiep_opt( 'hh_email' );
	}
	$emails = array_filter( array_map( 'sanitize_email', preg_split( '/[\s,;]+/', $list . ',' . get_option( 'admin_email' ) ) ), 'is_email' );
	return array_values( array_unique( array_map( 'strtolower', $emails ) ) );
}

/** Gửi email thông báo; lưu lỗi gần nhất để hiện trong trang Thông báo email. */
function hh_lead_mail( $subject, $body ) {
	$host    = wp_parse_url( home_url(), PHP_URL_HOST );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( ! has_filter( 'wp_mail_from' ) ) {
		$headers[] = 'From: Website ' . get_bloginfo( 'name' ) . ' <no-reply@' . preg_replace( '/^www\./', '', (string) $host ) . '>';
	}
	$ok = wp_mail( hh_lead_recipients(), $subject, $body, $headers );
	update_option( 'hh_lead_mail_last', array( 'ok' => (bool) $ok, 'at' => time(), 'error' => $ok ? '' : get_option( 'hh_lead_mail_error', 'wp_mail() trả về lỗi' ) ), false );
	return $ok;
}

add_action(
	'wp_mail_failed',
	static function ( $err ) {
		update_option( 'hh_lead_mail_error', $err->get_error_message(), false );
	}
);

add_action( 'admin_menu', 'hh_lead_mail_menu' );
function hh_lead_mail_menu() {
	add_submenu_page( 'edit.php?post_type=khach-hang', 'Thông báo email', 'Thông báo email', 'manage_options', 'hh-lead-mail', 'hh_lead_mail_page' );
}

function hh_lead_mail_page() {
	$sent = null;
	if ( isset( $_POST['hh_lead_emails'] ) && check_admin_referer( 'hh_lead_mail' ) ) {
		update_option( 'hh_lead_emails', sanitize_text_field( wp_unslash( $_POST['hh_lead_emails'] ) ), false );
		if ( ! empty( $_POST['hh_test'] ) ) {
			delete_option( 'hh_lead_mail_error' );
			$sent = hh_lead_mail( '[Website] Email thử – thông báo khách hàng mới', "Đây là email thử từ " . home_url( '/' ) . ".\nNếu anh nhận được email này, form để lại thông tin trên web sẽ báo về đúng địa chỉ này.\n\nGửi lúc " . wp_date( 'H:i d/m/Y' ) );
		}
	}
	$last = get_option( 'hh_lead_mail_last' );
	$smtp = has_filter( 'wp_mail_from' ) || class_exists( 'WPMailSMTP\\Core' ) || defined( 'WPMS_PLUGIN_VER' ) || function_exists( 'fluentSmtpInit' ) || class_exists( 'FluentMail\\App\\App' );
	?>
	<div class="wrap">
		<h1>Thông báo email khi khách để lại thông tin</h1>
		<?php if ( null !== $sent ) : ?>
			<div class="notice notice-<?php echo $sent ? 'success' : 'error'; ?>"><p><?php echo $sent ? 'Đã gửi email thử tới: ' . esc_html( implode( ', ', hh_lead_recipients() ) ) . '. Kiểm tra cả hộp thư Spam / Quảng cáo.' : 'Gửi KHÔNG được: ' . esc_html( get_option( 'hh_lead_mail_error', 'máy chủ không gửi được email' ) ) . '. Cài plugin WP Mail SMTP (hướng dẫn bên dưới).'; ?></p></div>
		<?php endif; ?>
		<p>Mỗi khi khách điền form trên web, khách được lưu ở <strong>Khách hàng</strong> và web gửi email báo tới các địa chỉ dưới đây.</p>
		<form method="post">
			<?php wp_nonce_field( 'hh_lead_mail' ); ?>
			<p><label><strong>Email nhận thông báo</strong> (nhiều email cách nhau dấu phẩy)<br>
				<input type="text" class="regular-text" name="hh_lead_emails" value="<?php echo esc_attr( get_option( 'hh_lead_emails', '' ) ); ?>" placeholder="hiephoangmt@gmail.com"></label></p>
			<p>Đang gửi tới: <code><?php echo esc_html( implode( ', ', hh_lead_recipients() ) ); ?></code></p>
			<p><button class="button">Lưu</button> <button class="button button-primary" name="hh_test" value="1">Lưu &amp; gửi email thử</button></p>
		</form>
		<?php if ( $last ) : ?>
			<p>Lần gửi gần nhất: <?php echo esc_html( wp_date( 'H:i d/m/Y', $last['at'] ) ); ?> – <?php echo $last['ok'] ? '<span style="color:#00701a">máy chủ báo đã gửi</span>' : '<span style="color:#b32d2e">lỗi: ' . esc_html( $last['error'] ) . '</span>'; ?></p>
		<?php endif; ?>
		<h2>Nếu email không đến (hoặc vào Spam)</h2>
		<p><?php echo $smtp ? 'Đã có plugin gửi mail SMTP.' : '<strong>Chưa có plugin gửi mail SMTP</strong> – hosting gửi mail trực tiếp nên Gmail hay chặn hoặc cho vào Spam.'; ?> Cách chắc chắn nhất:</p>
		<ol>
			<li>Plugin → Cài mới → tìm <strong>WP Mail SMTP</strong> → Cài đặt → Kích hoạt.</li>
			<li>Chọn <strong>Other SMTP</strong>: SMTP Host <code>smtp.gmail.com</code>, Encryption <strong>TLS</strong>, Port <code>587</code>, bật Authentication.</li>
			<li>Username: <code>hiephoangmt@gmail.com</code>; Password: <strong>mật khẩu ứng dụng</strong> của Gmail (tạo tại myaccount.google.com → Bảo mật → Xác minh 2 bước → Mật khẩu ứng dụng), không dùng mật khẩu Gmail thường.</li>
			<li>From Email: <code>hiephoangmt@gmail.com</code>, From Name: Website Hoàng Hiệp → Lưu → quay lại trang này bấm <strong>Lưu &amp; gửi email thử</strong>.</li>
		</ol>
		<p>Dù email lỗi, thông tin khách vẫn luôn được lưu ở <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=khach-hang' ) ); ?>">Khách hàng</a>.</p>
	</div>
	<?php
}
