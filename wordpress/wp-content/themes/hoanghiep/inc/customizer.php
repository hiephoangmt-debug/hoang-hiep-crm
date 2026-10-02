<?php
/**
 * Customizer: Giao diện → Tùy biến → "Hoàng Hiệp – Thương hiệu".
 */

defined( 'ABSPATH' ) || exit;

function hoanghiep_defaults() {
	return array(
		// Cá nhân.
		'hh_person_name'   => 'Hoàng Hiệp',
		'hh_person_title'  => 'Chuyên viên bất động sản Đà Nẵng',
		'hh_person_photo'  => '',
		'hh_person_slogan' => 'Đúng nhu cầu – Đúng giá trị – Đúng pháp lý',
		'hh_person_bio'    => 'Tôi là Hoàng Hiệp, chuyên tư vấn mua bán, cho thuê và đầu tư bất động sản tại Đà Nẵng – từ căn hộ ven sông Hàn, nhà phố trung tâm đến đất nền ven biển. Mỗi sản phẩm tôi giới thiệu đều được kiểm tra pháp lý, khảo sát thực tế và tư vấn rõ ràng về giá trị, để bạn ra quyết định an tâm nhất.',
		// Số liệu (để trống sẽ ẩn).
		'hh_stat1_num'     => '',
		'hh_stat1_label'   => 'Năm kinh nghiệm',
		'hh_stat2_num'     => '',
		'hh_stat2_label'   => 'Khách hàng đã tư vấn',
		'hh_stat3_num'     => '',
		'hh_stat3_label'   => 'Giao dịch thành công',
		'hh_stat4_num'     => '',
		'hh_stat4_label'   => 'Dự án phân phối',
		// Liên hệ.
		'hh_phone'         => '0900 000 000',
		'hh_zalo'          => '0900000000',
		'hh_email'         => 'hiephoangmt@gmail.com',
		'hh_address'       => 'Đà Nẵng',
		'hh_hours'         => '8:00 – 21:00, tất cả các ngày',
		'hh_facebook'      => '',
		'hh_youtube'       => '',
		'hh_tiktok'        => '',
		// Banner.
		'hh_hero_title'    => 'Bất động sản Đà Nẵng cùng Hoàng Hiệp',
		'hh_hero_text'     => 'Dự án mới, nhà đất mua bán và cho thuê tại Đà Nẵng được chọn lọc kỹ, pháp lý minh bạch, tư vấn tận tâm.',
		'hh_hero_image'    => '',
	);
}

function hoanghiep_opt( $key ) {
	$defaults = hoanghiep_defaults();
	return (string) get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

function hoanghiep_tel( $phone = null ) {
	return preg_replace( '/[^0-9+]/', '', $phone ?? hoanghiep_opt( 'hh_phone' ) );
}

/** Filled-in stats as [num, label] pairs. */
function hoanghiep_stats() {
	$stats = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$num = trim( hoanghiep_opt( "hh_stat{$i}_num" ) );
		if ( '' !== $num ) {
			$stats[] = array( $num, hoanghiep_opt( "hh_stat{$i}_label" ) );
		}
	}
	return $stats;
}

add_action( 'customize_register', 'hoanghiep_customize' );
function hoanghiep_customize( $wp_customize ) {
	$wp_customize->add_panel( 'hh_brand', array( 'title' => 'Hoàng Hiệp – Thương hiệu', 'priority' => 20 ) );

	$sections = array(
		'hh_person'  => 'Thông tin cá nhân',
		'hh_stats'   => 'Số liệu nổi bật',
		'hh_contact' => 'Liên hệ & mạng xã hội',
		'hh_hero'    => 'Banner trang chủ',
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'hh_brand' ) );
	}
	$wp_customize->get_section( 'hh_stats' )->description = 'Chỉ những ô có nhập số mới hiển thị. VD: 8+, 500+, 120.';
	$wp_customize->get_section( 'hh_hero' )->description  = 'Nếu có dự án đánh dấu "nổi bật" và có ảnh đại diện, banner sẽ tự chạy slide các dự án đó.';

	$fields = array(
		'hh_person_name'   => array( 'hh_person', 'Họ tên', 'text' ),
		'hh_person_title'  => array( 'hh_person', 'Chức danh', 'text' ),
		'hh_person_slogan' => array( 'hh_person', 'Slogan', 'text' ),
		'hh_person_bio'    => array( 'hh_person', 'Giới thiệu ngắn', 'textarea' ),
		'hh_phone'         => array( 'hh_contact', 'Hotline', 'text' ),
		'hh_zalo'          => array( 'hh_contact', 'Số Zalo', 'text' ),
		'hh_email'         => array( 'hh_contact', 'Email', 'email' ),
		'hh_address'       => array( 'hh_contact', 'Địa chỉ / khu vực hoạt động', 'text' ),
		'hh_hours'         => array( 'hh_contact', 'Giờ làm việc', 'text' ),
		'hh_facebook'      => array( 'hh_contact', 'Link Facebook', 'url' ),
		'hh_youtube'       => array( 'hh_contact', 'Link YouTube', 'url' ),
		'hh_tiktok'        => array( 'hh_contact', 'Link TikTok', 'url' ),
		'hh_hero_title'    => array( 'hh_hero', 'Tiêu đề', 'text' ),
		'hh_hero_text'     => array( 'hh_hero', 'Mô tả', 'textarea' ),
	);
	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[ "hh_stat{$i}_num" ]   = array( 'hh_stats', "Số liệu {$i} – con số", 'text' );
		$fields[ "hh_stat{$i}_label" ] = array( 'hh_stats', "Số liệu {$i} – mô tả", 'text' );
	}

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

	foreach ( array( 'hh_person_photo' => array( 'hh_person', 'Ảnh chân dung' ), 'hh_hero_image' => array( 'hh_hero', 'Ảnh nền banner' ) ) as $id => list( $section, $label ) ) {
		$wp_customize->add_setting( $id, array( 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $label, 'section' => $section ) ) );
	}
}
