<?php
/**
 * In trang landing dự án (đầu trang: wp_head – tiêu đề, mô tả, canonical, schema của web; thân: nội dung landing).
 * Form landing vẫn gửi như bản gốc; thêm: lưu khách vào mục Khách hàng của web.
 */

defined( 'ABSPATH' ) || exit;

$hh_file = hoanghiep_landing_file();
$hh_html = (string) file_get_contents( $hh_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
$hh_head = (string) strstr( (string) strstr( $hh_html, '<!--HH-LANDING-HEAD-->' ), '<!--HH-LANDING-BODY-->', true );
$hh_body = (string) substr( (string) strstr( $hh_html, '<!--HH-LANDING-BODY-->' ), strlen( '<!--HH-LANDING-BODY-->' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php echo $hh_head; // phpcs:ignore WordPress.Security.EscapeOutput -- CSS của landing dựng sẵn trong giao diện. ?>
</head>
<body <?php body_class( 'hh-landing' ); ?>>
<?php wp_body_open(); ?>
<?php echo $hh_body; // phpcs:ignore WordPress.Security.EscapeOutput -- Nội dung landing dựng sẵn trong giao diện. ?>
<script>
(function(){
	// Form landing: ngoài kênh gửi sẵn có, lưu thêm khách vào mục Khách hàng của web.
	var url = <?php echo wp_json_encode( admin_url( 'admin-post.php' ) ); ?>, ref = <?php echo (int) get_queried_object_id(); ?>;
	window.addEventListener('submit', function (e) { // Bắt ở cấp window (chạy trước script landing, script đó dừng sự kiện ở document).
		var f = e.target;
		if (!f || !f.querySelector || f.matches('.hhc-i, #chatForm, .chat-foot, #calcForm, .hd-search')) return;
		var tel = f.querySelector('[name=phone], input[type=tel]');
		if (!tel) return;
		var pick = function (sel) { var el = f.querySelector(sel); return el ? String(el.value || '').trim() : ''; };
		var phone = String(tel.value || '').replace(/[^0-9+]/g, '');
		if (!/^(\+?84|0)\d{8,10}$/.test(phone)) return;
		var name = pick('[name=name], [autocomplete=name], input[type=text]');
		var extra = pick('select');
		var d = new FormData();
		d.append('action', 'hh_lead'); d.append('ajax', '1'); d.append('ref_id', ref);
		d.append('name', name || 'Khách trang ' + document.title.split(/[–|-]/)[0].trim()); d.append('phone', phone);
		d.append('need', 'Nhận bảng giá dự án');
		d.append('message', 'Trang landing: ' + document.title + (f.getAttribute('data-form') ? ' – ' + f.getAttribute('data-form') : '') + (extra ? ' – quan tâm: ' + extra : ''));
		try { fetch(url, { method: 'POST', body: d, credentials: 'same-origin', keepalive: true }); } catch (err) {}
	}, true);
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
