<?php
/**
 * Trang "Bản đồ dự án" (/ban-do-du-an/): bản đồ ảnh vệ tinh các dự án Đà Nẵng – Hội An và Vinhomes Hà Nội
 * (ranh giới theo OpenStreetMap, ghim dự án đang phân phối, giá, link sang trang dự án của website).
 * Bản đồ chạy trên GitHub Pages và được nhúng bằng khung; bấm "Xem trang dự án" mở trang /du-an/... của website ngay trong tab.
 * Tự tạo trang một lần khi quản trị viên vào trang quản trị; xóa trang thì không tự tạo lại. Menu chính thêm mục qua giao diện.
 */

defined( 'ABSPATH' ) || exit;

const HH_BDDA_SLUG = 'ban-do-du-an';
const HH_BDDA_BASE = 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/';

function hh_bdda_content() {
	$site = rawurlencode( untrailingslashit( home_url() ) );
	return "<!-- wp:html -->\n"
		. '<div class="hh-bdda-tabs"><button type="button" class="on" data-src="' . esc_attr( HH_BDDA_BASE . 'du-an-da-nang/?site=' . $site ) . '">📍 Đà Nẵng – Hội An</button>'
		. '<button type="button" data-src="' . esc_attr( HH_BDDA_BASE . 'vin-ha-noi/' ) . '">🗺 Vinhomes Hà Nội</button>'
		. '<button type="button" data-src="' . esc_attr( HH_BDDA_BASE . 'da-nang-3d/?go=du-an' ) . '">🏙 Đà Nẵng 3D</button></div>' . "\n"
		. '<iframe class="hh-bdda" src="' . esc_attr( HH_BDDA_BASE . 'du-an-da-nang/?site=' . $site ) . '" title="Bản đồ dự án bất động sản" style="width:100%;height:80vh;min-height:520px;border:0;border-radius:12px" allow="fullscreen; accelerometer; gyroscope" loading="eager"></iframe>' . "\n"
		. '<p style="text-align:center;font-size:14px">Bấm vào dự án trên bản đồ để xem giá và trang dự án · <a class="hh-bdda-full" href="' . esc_attr( HH_BDDA_BASE . 'du-an-da-nang/?site=' . $site ) . '" target="_blank" rel="noopener">Mở toàn màn hình ↗</a></p>' . "\n"
		. '<!-- /wp:html -->';
}

/** Tạo trang (một lần). */
function hh_bdda_ensure_page() {
	if ( get_option( 'hh_bdda_page_created' ) || ! current_user_can( 'publish_pages' ) ) {
		return;
	}
	if ( ! get_page_by_path( HH_BDDA_SLUG ) ) {
		kses_remove_filters(); // Giữ nguyên iframe trong khối HTML.
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Bản đồ dự án',
				'post_name'    => HH_BDDA_SLUG,
				'post_content' => hh_bdda_content(),
				'post_excerpt' => 'Bản đồ ảnh vệ tinh các dự án bất động sản Đà Nẵng – Hội An (Sun Saphia, Da Nang Downtown, Cora Tower, Vinhomes Hải Vân Bay, Casamia Balanca, FPT City…) và các dự án Vinhomes tại Hà Nội: vị trí, ranh giới, giá tham khảo.',
			),
			true
		);
		kses_init_filters();
		if ( is_wp_error( $id ) || ! $id ) {
			return;
		}
	}
	update_option( 'hh_bdda_page_created', 1, false );
}
add_action( 'admin_init', 'hh_bdda_ensure_page' );

/** Trang đã xuất bản thì trả về link, chưa có thì rỗng (menu không có link chết). */
function hh_bdda_url() {
	static $url = null;
	if ( null === $url ) {
		$page = get_page_by_path( HH_BDDA_SLUG );
		$url  = ( $page && 'publish' === $page->post_status ) ? get_permalink( $page ) : '';
	}
	return $url;
}

add_action(
	'wp_head',
	static function () {
		if ( is_page( HH_BDDA_SLUG ) ) {
			echo '<style id="hh-bdda">.page .section.narrow{max-width:1280px}.hh-bdda-tabs{display:flex;gap:8px;flex-wrap:wrap;margin:0 0 10px}'
				. '.hh-bdda-tabs button{border:1px solid #0b2545;background:#fff;color:#0b2545;border-radius:999px;padding:8px 14px;font:600 14px/1.2 inherit;cursor:pointer}'
				. '.hh-bdda-tabs button.on{background:#0b2545;color:#fff}@media(max-width:600px){iframe.hh-bdda{height:calc(100vh - 150px)!important}}</style>' . "\n";
		}
	}
);

add_action(
	'wp_footer',
	static function () {
		if ( ! is_page( HH_BDDA_SLUG ) ) {
			return;
		}
		?>
<script id="hh-bdda-js">
(function () {
	var f = document.querySelector('iframe.hh-bdda'), full = document.querySelector('.hh-bdda-full');
	document.querySelectorAll('.hh-bdda-tabs button').forEach(function (b) {
		b.addEventListener('click', function () {
			document.querySelectorAll('.hh-bdda-tabs button').forEach(function (x) { x.classList.toggle('on', x === b); });
			if (f) f.src = b.getAttribute('data-src');
			if (full) full.href = b.getAttribute('data-src');
		});
	});
})();
</script>
		<?php
	}
);
