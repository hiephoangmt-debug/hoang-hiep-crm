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

/**
 * Khung cao bằng nội dung bảng thống kê: bảng gửi chiều cao qua postMessage, trang này đặt lại chiều cao iframe
 * → chỉ còn một thanh cuộn (của trang), lướt trên điện thoại không bị khựng do cuộn lồng nhau.
 * Bảng chưa hỗ trợ thì khung giữ nguyên 85vh như cũ.
 */
add_action(
	'wp_footer',
	static function () {
		if ( ! is_page( HH_TKDT_SLUG ) ) {
			return;
		}
		?>
<script id="hh-tkdt-js">
(function () {
	var ORIGIN = 'https://hiephoangmt-debug.github.io';
	var f = document.querySelector('iframe[src^="' + ORIGIN + '/hoang-hiep-crm/dau-tu/"]');
	if (!f) return;
	f.loading = 'eager';
	function headH() { var h = document.querySelector('.site-header'); return h ? h.getBoundingClientRect().height : 0; }
	addEventListener('message', function (e) {
		if (e.origin !== ORIGIN || e.source !== f.contentWindow || !e.data || typeof e.data !== 'object') return;
		var d = e.data;
		if (d.hhDauTu === 'h') {
			var h = Math.max(640, Math.min(200000, +d.h || 0));
			if (h) { f.style.height = h + 'px'; f.style.minHeight = '0'; f.setAttribute('scrolling', 'no'); }
		} else if (d.hhDauTu === 'go') {
			var top = f.getBoundingClientRect().top + scrollY + (+d.y || 0);
			var vt = scrollY + headH(), vb = scrollY + innerHeight;
			if (d.nearest && top >= vt && top + (+d.h || 0) <= vb) return;
			scrollTo({ top: Math.max(0, top - headH() - 8), behavior: d.smooth ? 'smooth' : 'auto' });
		}
	});
})();
</script>
		<?php
	}
);
