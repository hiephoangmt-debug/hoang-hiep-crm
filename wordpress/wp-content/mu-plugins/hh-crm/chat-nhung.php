<?php
/**
 * Nhúng khung chat của hiephoangmt.com vào trang ngoài (LadiPage…): dán 1 dòng
 *   <script src="https://hiephoangmt.com/?hh_chat_nhung=1&du_an=sun-solar-residence" defer></script>
 * Khóa API vẫn chỉ nằm trên máy chủ web; chat ở LadiPage lưu vào Khách hàng, báo Telegram như web chính.
 * Chỉ tên miền trong danh sách cho phép (cài đặt Chat trên web) mới gọi được chat – web khác chép mã cũng không dùng được.
 */

defined( 'ABSPATH' ) || exit;

/** Tên miền được nhúng chat: mặc định các tên miền LadiPage + danh sách anh tự thêm. */
function hh_chat_embed_origin_ok( $origin ) {
	$host = strtolower( (string) wp_parse_url( (string) $origin, PHP_URL_HOST ) );
	if ( '' === $host ) {
		return false;
	}
	$own = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$ok  = array_merge( array( 'ladipage.com', 'ladipage.me', 'ladipage.vn', 'ladi.me', 'ladi.page', $own ), preg_split( '/[\s,;]+/', strtolower( (string) hh_chat_opt( 'embed_domains' ) ), -1, PREG_SPLIT_NO_EMPTY ) );
	foreach ( $ok as $d ) {
		$d = preg_replace( '#^https?://|^www\.|/.*$#', '', trim( $d ) );
		if ( '' !== $d && ( $host === $d || $host === 'www.' . $d || str_ends_with( $host, '.' . $d ) ) ) {
			return true;
		}
	}
	return false;
}

/** Cho phép trang LadiPage (tên miền hợp lệ) đọc câu trả lời chat từ admin-ajax. */
add_action(
	'admin_init',
	static function () {
		if ( ! wp_doing_ajax() || 'hh_chat' !== ( $_REQUEST['action'] ?? '' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}
		$origin = (string) ( $_SERVER['HTTP_ORIGIN'] ?? '' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( '' === $origin || ! hh_chat_embed_origin_ok( $origin ) ) {
			return;
		}
		header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
		header( 'Vary: Origin' );
		if ( 'OPTIONS' === ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
			header( 'Access-Control-Allow-Methods: POST' );
			header( 'Access-Control-Allow-Headers: Content-Type' );
			exit;
		}
	},
	1
);

/** Đoạn JS nhúng: cấu hình chat (dự án theo ?du_an=) + nạp chat.css, chat.js của web chính. */
add_action(
	'init',
	static function () {
		if ( empty( $_GET['hh_chat_nhung'] ) || ! hh_chat_enabled() ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}
		$slug  = sanitize_title( wp_unslash( $_GET['du_an'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification
		$post  = $slug ? get_page_by_path( $slug, OBJECT, 'du-an' ) : null;
		$id    = $post ? (int) $post->ID : 0;
		$opt   = static fn( $k, $d = '' ) => function_exists( 'hoanghiep_opt' ) ? ( hoanghiep_opt( $k ) ?: $d ) : $d;
		$phone = $opt( 'hh_phone', '0904 567 009' );
		$name  = $opt( 'hh_person_name', 'Hoàng Hiệp' );
		$title = $id ? hh_chat_title( $id ) : '';
		$ui    = hh_chat_ui( 'vi', $name, $title );
		$greet = trim( (string) hh_chat_opt( 'greeting' ) );
		$cfg   = array(
			'ajax'   => admin_url( 'admin-ajax.php' ),
			'page'   => $id,
			'name'   => $name,
			'avatar' => function_exists( 'hoanghiep_photo' ) ? hoanghiep_photo( 'avatar' ) : '',
			'phone'  => $phone,
			'zalo'   => 'https://zalo.me/' . preg_replace( '/[^0-9]/', '', $opt( 'hh_zalo', $phone ) ),
			'fb'     => $opt( 'hh_facebook' ),
			'lang'   => 'vi',
			'ui'     => $ui,
			'greet'  => $greet ?: ( $title
				? 'Chào anh/chị 👋 Em là trợ lý của ' . $name . '. Anh/chị đang tìm hiểu ' . $title . ' – cần em gửi bảng giá, chính sách hay tính vốn cho căn nào ạ?'
				: 'Chào anh/chị 👋 Em là trợ lý của ' . $name . '. Anh/chị đang tìm mua, thuê hay đầu tư bất động sản Đà Nẵng ạ?' ),
			'chips'  => $title
				? array( 'Bảng giá & chính sách', 'Vốn tự có bao nhiêu?', 'Đặt lịch xem nhà', 'Gửi số Zalo nhận tài liệu' )
				: array( 'Tìm căn hộ', 'Mua đất nền / biệt thự', 'Thuê nhà', 'Gửi số Zalo để được tư vấn' ),
			'popup'  => '0' !== (string) hh_chat_opt( 'popup', '1' ),
			'nudges' => array(),
		);
		header( 'Content-Type: application/javascript; charset=utf-8' );
		header( 'Cache-Control: public, max-age=600' );
		$css = HH_CRM_URL . 'chat.css?ver=' . HH_CRM_VERSION;
		$js  = HH_CRM_URL . 'chat.js?ver=' . HH_CRM_VERSION;
		echo '(function(){if(window.HH_CHAT)return;window.HH_CHAT=' . wp_json_encode( $cfg ) . ';'
			. 'try{var k="hh_src",s=JSON.parse(sessionStorage.getItem(k)||"null");if(!s){s={first:location.href,ref:document.referrer||""};sessionStorage.setItem(k,JSON.stringify(s));}window.HH_SRC={url:location.href,title:"[LadiPage] "+document.title,first:s.first,ref:s.ref};}catch(e){window.HH_SRC={url:location.href,title:"[LadiPage] "+document.title,first:location.href,ref:document.referrer||""};}'
			. 'var l=document.createElement("link");l.rel="stylesheet";l.href=' . wp_json_encode( $css ) . ';document.head.appendChild(l);'
			. 'var j=document.createElement("script");j.src=' . wp_json_encode( $js ) . ';j.defer=true;(document.body||document.documentElement).appendChild(j);})();';
		exit;
	},
	1
);
