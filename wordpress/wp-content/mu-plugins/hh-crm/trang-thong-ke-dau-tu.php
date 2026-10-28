<?php
/**
 * Trang "Thống kê đầu tư" (/thong-ke-dau-tu/): tự tạo một lần khi quản trị viên vào trang quản trị sau khi cài bản cập nhật.
 * Nội dung là một khối HTML tùy chỉnh nhúng bảng thống kê trên GitHub Pages. Nếu anh xóa trang thì không tự tạo lại.
 * Menu chính thêm mục này qua giao diện (functions.php).
 */

defined( 'ABSPATH' ) || exit;

const HH_TKDT_SLUG = 'thong-ke-dau-tu';

function hh_tkdt_content() {
	return "<!-- wp:html -->\n"
		. '<iframe src="https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/" title="Thống kê kênh đầu tư" style="width:100%;height:85vh;min-height:640px;border:0;border-radius:12px" loading="lazy"></iframe>' . "\n"
		. '<p style="text-align:center"><a href="https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/" target="_blank" rel="noopener">Mở toàn màn hình ↗</a></p>' . "\n"
		. '<!-- /wp:html -->';
}

/** Tạo trang (một lần). */
function hh_tkdt_ensure_page() {
	if ( get_option( 'hh_tkdt_page_created' ) || ! current_user_can( 'publish_pages' ) ) {
		return;
	}
	$page = get_page_by_path( HH_TKDT_SLUG );
	if ( ! $page ) {
		kses_remove_filters(); // Giữ nguyên iframe trong khối HTML.
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Thống kê đầu tư',
				'post_name'    => HH_TKDT_SLUG,
				'post_content' => hh_tkdt_content(),
				'post_excerpt' => 'Thống kê các kênh đầu tư: vàng, chứng khoán, khối ngoại, USD, Bitcoin, bất động sản, lãi suất tiết kiệm – cập nhật mỗi ngày bằng biểu đồ.',
			),
			true
		);
		kses_init_filters();
		if ( is_wp_error( $id ) || ! $id ) {
			return;
		}
	}
	update_option( 'hh_tkdt_page_created', 1, false );
}
add_action( 'admin_init', 'hh_tkdt_ensure_page' );

/** Trang đã xuất bản thì trả về link, chưa có thì trả về rỗng (để menu không có link chết). */
function hh_tkdt_url() {
	static $url = null;
	if ( null === $url ) {
		$page = get_page_by_path( HH_TKDT_SLUG );
		$url  = ( $page && 'publish' === $page->post_status ) ? get_permalink( $page ) : '';
	}
	return $url;
}

/** Trang này hiển thị rộng hơn (khung thống kê cần chỗ). */
add_action(
	'wp_head',
	static function () {
		if ( is_page( HH_TKDT_SLUG ) ) {
			echo '<style id="hh-tkdt">.page .section.narrow{max-width:1200px}</style>' . "\n";
		}
	}
);
