<?php
/**
 * Customizer: Giao diện → Tùy biến → "Hoàng Hiệp – Thương hiệu".
 */

defined( 'ABSPATH' ) || exit;

function hoanghiep_defaults() {
	return array(
		// Cá nhân.
		'hh_person_name'   => 'Hoàng Hiệp',
		'hh_person_title'  => 'Chuyên gia bất động sản tại Đà Nẵng',
		'hh_person_company' => '',
		'hh_person_career' => "Trưởng nhóm kinh doanh | Trực tiếp tư vấn, dẫn khách và chốt giao dịch tại các dự án Đà Nẵng\nTrưởng phòng kinh doanh | Xây dựng và dẫn dắt đội ngũ chuyên viên tư vấn\nGiám đốc sàn giao dịch | Vận hành sàn, phân phối nhiều dự án căn hộ, đất nền khu vực miền Trung\nGiám đốc kinh doanh | Hoạch định chiến lược bán hàng, làm việc trực tiếp với chủ đầu tư\nCEO | Điều hành doanh nghiệp môi giới, phát triển thị trường Đà Nẵng – miền Trung",
		'hh_person_photo'  => '',
		'hh_person_photo2' => '',
		'hh_person_avatar' => '',
		'hh_highlights'    => '{theme}/assets/img/hoi-nghi-tatiland-2026.jpg | Phát biểu tại Hội nghị tổng kết TATILAND “Thế & Lực 2026” – Furama Resort Đà Nẵng, 07/02/2026',
		'hh_person_slogan' => 'Đúng nhu cầu – Đúng giá trị – Đúng pháp lý',
		'hh_person_bio'    => 'Tôi là Hoàng Hiệp, hơn 15 năm gắn bó với thị trường bất động sản Đà Nẵng và miền Trung. Đi lên từ trưởng nhóm, trưởng phòng, giám đốc sàn, giám đốc kinh doanh đến CEO, tôi hiểu rõ từng dự án, từng khu vực và cách chọn đúng sản phẩm cho nhu cầu ở hay đầu tư.',
		// Số liệu (để trống sẽ ẩn).
		'hh_stat1_num'     => '15+',
		'hh_stat1_label'   => 'Năm kinh nghiệm BĐS Đà Nẵng – miền Trung',
		'hh_stat2_num'     => '5',
		'hh_stat2_label'   => 'Cấp quản lý, từ trưởng nhóm đến CEO',
		'hh_stat3_num'     => '',
		'hh_stat3_label'   => 'Giao dịch thành công',
		'hh_stat4_num'     => '',
		'hh_stat4_label'   => 'Dự án phân phối',
		// Liên hệ.
		'hh_phone'         => '0904 567 009',
		'hh_zalo'          => '0904567009',
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

/**
 * Ảnh của Hiệp: ảnh tải lên trong Tùy biến, nếu chưa có thì dùng ảnh có sẵn trong theme.
 *
 * @param string $which portrait | portrait2 | avatar
 */
function hoanghiep_photo( $which = 'portrait' ) {
	$map = array(
		'portrait'  => array( 'hh_person_photo', 'hoang-hiep-chan-dung-2.jpg' ),
		'portrait2' => array( 'hh_person_photo2', 'hoang-hiep-chan-dung-1.jpg' ),
		'avatar'    => array( 'hh_person_avatar', 'hoang-hiep-avatar.jpg' ),
	);
	list( $key, $file ) = $map[ $which ] ?? $map['portrait'];
	return hoanghiep_opt( $key ) ?: get_theme_file_uri( 'assets/img/' . $file );
}

/** Hình ảnh hoạt động: [url, caption] pairs ("{theme}" = thư mục theme). */
function hoanghiep_highlights() {
	$rows = array();
	foreach ( preg_split( '/\R/u', hoanghiep_opt( 'hh_highlights' ) ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( '' === $parts[0] ) {
			continue;
		}
		$url    = str_replace( '{theme}', untrailingslashit( get_theme_file_uri() ), $parts[0] );
		$rows[] = array( $url, $parts[1] ?? '' );
	}
	return $rows;
}

/** Career steps as [role, note] pairs. */
function hoanghiep_career() {
	$rows = array();
	foreach ( preg_split( '/\R/u', hoanghiep_opt( 'hh_person_career' ) ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( '' !== $parts[0] ) {
			$rows[] = array( $parts[0], $parts[1] ?? '' );
		}
	}
	return $rows;
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
		'hh_person_company' => array( 'hh_person', 'Đơn vị đang công tác (để trống nếu không muốn hiển thị)', 'text' ),
		'hh_person_career' => array( 'hh_person', 'Hành trình nghề nghiệp (mỗi dòng: Chức vụ | Mô tả)', 'textarea' ),
		'hh_highlights'    => array( 'hh_person', 'Hình ảnh hoạt động, sự kiện (mỗi dòng: link ảnh | chú thích). Tải ảnh ở Media → copy link.', 'textarea' ),
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

	// Bảng màu.
	$wp_customize->add_section( 'hh_colors', array( 'title' => 'Bảng màu', 'panel' => 'hh_brand', 'priority' => 5 ) );
	$wp_customize->add_setting( 'hh_palette', array( 'default' => 'cam', 'sanitize_callback' => static fn( $v ) => isset( hoanghiep_palettes()[ $v ] ) ? $v : 'cam' ) );
	$wp_customize->add_control( 'hh_palette', array( 'label' => 'Bảng màu website', 'section' => 'hh_colors', 'type' => 'radio', 'choices' => wp_list_pluck( hoanghiep_palettes(), 'label' ) ) );

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

	foreach ( array( 'hh_person_photo' => array( 'hh_person', 'Ảnh chân dung chính (để trống = ảnh có sẵn)' ), 'hh_person_photo2' => array( 'hh_person', 'Ảnh chân dung phụ – trang Về Hiệp' ), 'hh_person_avatar' => array( 'hh_person', 'Ảnh đại diện vuông (logo, thẻ liên hệ)' ), 'hh_hero_image' => array( 'hh_hero', 'Ảnh nền banner' ) ) as $id => list( $section, $label ) ) {
		$wp_customize->add_setting( $id, array( 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $label, 'section' => $section ) ) );
	}
}

/** Bảng màu chọn được trong Tùy biến (mặc định: navy đậm + xanh dương + cam – trong main.css). */
function hoanghiep_palettes() {
	return array(
		'cam'  => array( 'label' => 'Xanh navy + nâu + nút cam (mặc định)', 'vars' => array() ),
		'navycam' => array( 'label' => 'Navy + cam (không nâu – nổi bật nhất)', 'vars' => array( '--gold' => '#ffb627', '--gold-2' => '#ea580c', '--gold-3' => '#c2410c', '--gold-soft' => '#fff3e8' ) ),
		'do'   => array( 'label' => 'Navy + đỏ + vàng (khuyến mãi, mạnh mẽ)', 'vars' => array( '--navy' => '#0a2342', '--navy-2' => '#11407a', '--navy-3' => '#1a63c4', '--gold' => '#ffcf4d', '--gold-2' => '#d62828', '--gold-3' => '#a4161a', '--gold-soft' => '#fdeeee', '--cta' => '#d62828', '--cta-2' => '#a4161a' ) ),
		'vang' => array( 'label' => 'Xanh dương + vàng cam (tươi sáng)', 'vars' => array( '--navy' => '#06204a', '--navy-2' => '#0b3d8c', '--navy-3' => '#1565e0', '--gold' => '#ffc83d', '--gold-2' => '#f59e0b', '--gold-3' => '#d97706', '--gold-soft' => '#fff7e0', '--cta' => '#f59e0b', '--cta-2' => '#d97706' ) ),
		'nau'  => array( 'label' => 'Navy + nâu (bản cũ, nút nâu)', 'vars' => array( '--navy' => '#0a2342', '--navy-2' => '#123761', '--navy-3' => '#1d4a7d', '--gold' => '#c99b70', '--gold-2' => '#8a5a36', '--gold-3' => '#6e4527', '--gold-soft' => '#f5ede5', '--cta' => '#8a5a36', '--cta-2' => '#6e4527' ) ),
	);
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		$vars = hoanghiep_palettes()[ get_theme_mod( 'hh_palette', 'cam' ) ]['vars'] ?? array();
		if ( $vars ) {
			$css = '';
			foreach ( $vars as $k => $v ) {
				$css .= $k . ':' . $v . ';';
			}
			wp_add_inline_style( 'hoanghiep', ':root{' . $css . '}' );
		}
	},
	20
);
