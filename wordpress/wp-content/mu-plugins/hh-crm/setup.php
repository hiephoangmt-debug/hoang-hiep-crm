<?php
/**
 * Cài đặt nhanh 1 nút (dùng khi cài trên hosting, không có WP-CLI):
 * kích hoạt theme, đường dẫn đẹp, trang, trang chủ, chuyên mục, menu 3 cấp, dữ liệu dự án.
 * Làm giống scripts/setup.sh; chạy lại nhiều lần không tạo trùng.
 */

defined( 'ABSPATH' ) || exit;

function hh_quick_setup() {
	$done = array();

	if ( 'hoanghiep' !== get_stylesheet() && wp_get_theme( 'hoanghiep' )->exists() ) {
		switch_theme( 'hoanghiep' );
		$done[] = 'Kích hoạt giao diện Hoàng Hiệp';
	}

	update_option( 'timezone_string', 'Asia/Ho_Chi_Minh' );
	update_option( 'date_format', 'd/m/Y' );
	if ( in_array( get_option( 'blogdescription' ), array( '', 'Just another WordPress site', 'Một trang web mới sử dụng WordPress' ), true ) ) {
		update_option( 'blogdescription', 'Bất động sản Đà Nẵng – dự án, mua bán & cho thuê' );
	}
	$done[] = 'Múi giờ Việt Nam, ngày dạng 03/10/2026';

	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$done[] = 'Đường dẫn đẹp (/ten-bai-viet/)';

	// Xóa bài và trang mẫu của WordPress (chỉ khi còn nguyên).
	foreach ( array( 'hello-world', 'sample-page', 'trang-mau', 'chao-moi-nguoi' ) as $slug ) {
		$sample = get_page_by_path( $slug, OBJECT, array( 'post', 'page' ) );
		if ( $sample && strtotime( $sample->post_modified_gmt ) - strtotime( $sample->post_date_gmt ) < 60 ) {
			wp_delete_post( $sample->ID, true );
		}
	}

	$pages = array();
	foreach ( array( 'trang-chu' => 'Trang chủ', 'tin-tuc' => 'Tin tức', 'gioi-thieu' => 'Về Hiệp', 'lien-he' => 'Liên hệ' ) as $slug => $title ) {
		$page = get_page_by_path( $slug );
		$pages[ $slug ] = $page ? $page->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_name' => $slug, 'post_title' => $title ) );
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $pages['trang-chu'] );
	update_option( 'page_for_posts', $pages['tin-tuc'] );
	$done[] = 'Trang: Trang chủ, Tin tức, Về Hiệp, Liên hệ';

	hh_seed_terms();
	$done[] = 'Loại dự án, loại nhà đất, khu vực Đà Nẵng – Quảng Nam';

	$cat = get_term( (int) get_option( 'default_category' ), 'category' );
	if ( $cat && ! is_wp_error( $cat ) && in_array( $cat->slug, array( 'uncategorized', 'chua-phan-loai', 'khong-phan-loai' ), true ) ) {
		wp_update_term( $cat->term_id, 'category', array( 'name' => 'Thị trường Đà Nẵng', 'slug' => 'thi-truong-da-nang' ) );
	}
	foreach ( array( 'Tin dự án', 'Kinh nghiệm mua bán', 'Pháp lý nhà đất' ) as $name ) {
		if ( ! term_exists( $name, 'category' ) ) {
			wp_insert_term( $name, 'category' );
		}
	}
	$done[] = 'Chuyên mục tin tức';

	if ( hh_setup_menu( $pages ) ) {
		$done[] = 'Menu chính 3 cấp (Dự án → Tổ hợp / Cao tầng / Thấp tầng…)';
	}

	list( $created, $updated ) = hh_import_projects();
	$done[] = sprintf( 'Dữ liệu dự án: tạo mới %d, cập nhật %d', $created, $updated );

	flush_rewrite_rules();
	update_option( 'hh_flush_rewrite', 1 ); // Làm mới lần nữa ở lượt tải sau, khi đường dẫn đẹp đã có hiệu lực.
	update_option( 'hh_setup_done', time() );
	return $done;
}

add_action( 'init', 'hh_maybe_flush_rewrite', 99 );
function hh_maybe_flush_rewrite() {
	if ( get_option( 'hh_flush_rewrite' ) ) {
		delete_option( 'hh_flush_rewrite' );
		flush_rewrite_rules();
	}
}

/** Tạo "Menu chính" (nếu chưa có) và gán vào menu đầu trang + chân trang. */
function hh_setup_menu( $pages ) {
	if ( wp_get_nav_menu_object( 'Menu chính' ) ) {
		return false;
	}
	$menu = wp_create_nav_menu( 'Menu chính' );
	if ( is_wp_error( $menu ) ) {
		return false;
	}
	$add = static function ( $title, $url, $parent = 0 ) use ( $menu ) {
		return wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => $title, 'menu-item-url' => home_url( $url ), 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent ) );
	};
	$add( 'Trang chủ', '/' );
	$projects = $add( 'Dự án', '/du-an/' );
	$add( 'Tổ hợp dự án', '/loai-du-an/to-hop/', $projects );
	$high = $add( 'Cao tầng', '/loai-du-an/cao-tang/', $projects );
	$add( 'Căn hộ sở hữu lâu dài', '/loai-du-an/can-ho-so-huu-lau-dai/', $high );
	$add( 'Căn hộ dịch vụ (50 năm)', '/loai-du-an/can-ho-dich-vu/', $high );
	$low = $add( 'Thấp tầng', '/loai-du-an/thap-tang/', $projects );
	$add( 'Biệt thự nghỉ dưỡng', '/loai-du-an/biet-thu/', $low );
	$add( 'Đất nền', '/loai-du-an/dat-nen/', $low );
	$add( 'Nhà phố – Shophouse', '/loai-du-an/shophouse/', $low );
	$add( 'Mua bán', '/mua-ban/' );
	$add( 'Cho thuê', '/cho-thue/' );
	foreach ( array( 'tin-tuc' => 'Tin tức', 'gioi-thieu' => 'Về Hiệp', 'lien-he' => 'Liên hệ' ) as $slug => $title ) {
		wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => $title, 'menu-item-object' => 'page', 'menu-item-object-id' => $pages[ $slug ], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
	}
	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu;
	$locations['footer']  = $menu;
	set_theme_mod( 'nav_menu_locations', $locations );
	return true;
}

/* -------------------------------------------------------------------------
 * Trang quản trị: Công cụ → Cài đặt nhanh Hoàng Hiệp + nhắc trên Bảng tin
 * ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'hh_setup_menu_page' );
function hh_setup_menu_page() {
	add_management_page( 'Cài đặt nhanh Hoàng Hiệp', 'Cài đặt nhanh Hoàng Hiệp', 'manage_options', 'hh-setup', 'hh_setup_page' );
}

add_action( 'admin_notices', 'hh_setup_notice' );
function hh_setup_notice() {
	if ( get_option( 'hh_setup_done' ) || ! current_user_can( 'manage_options' ) || ( isset( $_GET['page'] ) && 'hh-setup' === $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	printf(
		'<div class="notice notice-info"><p><strong>Website Hoàng Hiệp:</strong> bấm 1 nút để tạo trang, menu, loại dự án và dữ liệu dự án Đà Nẵng. <a class="button button-primary" href="%s">Cài đặt nhanh</a></p></div>',
		esc_url( admin_url( 'tools.php?page=hh-setup' ) )
	);
}

function hh_setup_page() {
	$done = null;
	if ( isset( $_POST['hh_setup'] ) && check_admin_referer( 'hh_quick_setup' ) ) {
		$done = hh_quick_setup();
	}
	?>
	<div class="wrap">
		<h1>Cài đặt nhanh website Hoàng Hiệp</h1>
		<?php if ( $done ) : ?>
			<div class="notice notice-success">
				<p><strong>Đã cài đặt xong:</strong></p>
				<ul style="list-style:disc;padding-left:20px"><?php foreach ( $done as $line ) : ?><li><?php echo esc_html( $line ); ?></li><?php endforeach; ?></ul>
				<p><a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener">Xem website</a> <a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">Sửa thông tin cá nhân, số điện thoại, ảnh</a></p>
			</div>
		<?php elseif ( get_option( 'hh_setup_done' ) ) : ?>
			<div class="notice notice-info"><p>Đã cài đặt lúc <?php echo esc_html( wp_date( 'H:i d/m/Y', (int) get_option( 'hh_setup_done' ) ) ); ?>. Bấm lại nếu cần – không tạo trùng, không ghi đè nội dung bạn đã sửa.</p></div>
		<?php endif; ?>
		<p>Nút dưới đây sẽ:</p>
		<ul style="list-style:disc;padding-left:20px">
			<li>Kích hoạt giao diện Hoàng Hiệp, đặt múi giờ Việt Nam và đường dẫn đẹp.</li>
			<li>Tạo trang Trang chủ, Tin tức, Về Hiệp, Liên hệ và đặt trang chủ.</li>
			<li>Tạo loại dự án (Tổ hợp / Cao tầng / Thấp tầng), loại nhà đất, khu vực, chuyên mục tin tức.</li>
			<li>Tạo "Menu chính" 3 cấp (sửa được ở Giao diện → Menu).</li>
			<li>Nhập <?php echo count( hh_project_dataset() ); ?> dự án Đà Nẵng – Quảng Nam (cũ).</li>
		</ul>
		<form method="post">
			<?php wp_nonce_field( 'hh_quick_setup' ); ?>
			<p><button class="button button-primary button-hero" name="hh_setup" value="1">Cài đặt nhanh</button></p>
		</form>
	</div>
	<?php
}
