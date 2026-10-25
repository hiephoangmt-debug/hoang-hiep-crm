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
<style id="hh-landing-mobile">
/* Điện thoại: bảng nhiều cột (bảng giá, giỏ hàng) thành thẻ từng căn – không bị cắt cột, không xuống dòng từng chữ; đầu trang tự ẩn khi cuộn xuống. */
body>header,header#hdr,header.top{transition:transform .25s ease,background .3s,padding .3s,box-shadow .3s}
@media (max-width:760px){
header.hh-hide{transform:translateY(-110%)}
table.hh-fit{min-width:0!important}
table.hh-fit th,table.hh-fit td{padding:10px 12px!important;font-size:14px}
table.hh-cards{min-width:0!important;width:100%;border-collapse:separate}
table.hh-cards thead{position:absolute;left:-9999px}
table.hh-cards caption{text-align:left;padding:14px 14px 2px;white-space:normal}
table.hh-cards tbody{display:block;padding:4px 10px 10px}
table.hh-cards tr{display:grid;grid-template-columns:1fr 1fr;gap:8px 14px;padding:12px 14px;margin:10px 0;border:1px solid rgba(0,0,0,.09);border-radius:14px;background:#fff!important;box-shadow:0 4px 14px -10px rgba(0,0,0,.3)}
table.hh-cards tr>*{display:block;padding:0!important;margin:0;text-align:left!important;border:0!important;background:none!important;font-size:14px;line-height:1.45;white-space:normal!important;min-width:0;word-break:normal;overflow-wrap:break-word}
table.hh-cards tr>[data-label]::before{content:attr(data-label);display:block;font-size:11px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;opacity:.6;margin-bottom:1px}
table.hh-cards tr>:first-child:not([colspan]){grid-column:1/-1;font-size:16px;font-weight:700}
table.hh-cards tr>:first-child::before{display:none}
table.hh-cards tr>.hh-full,table.hh-cards tr>[colspan]{grid-column:1/-1}
table.hh-cards td small{display:block;white-space:normal!important}
table.hh-cards .unit-acts{justify-content:flex-start}
}
</style>
</head>
<body <?php body_class( 'hh-landing' ); ?>>
<?php wp_body_open(); ?>
<?php echo $hh_body; // phpcs:ignore WordPress.Security.EscapeOutput -- Nội dung landing dựng sẵn trong giao diện. ?>
<script>
(function(){
	// Điện thoại: bảng ≥5 cột → thẻ từng dòng (gắn tên cột cho từng ô); bảng ≤4 cột → vừa màn hình, không phải vuốt ngang.
	function label(t){
		if (t.closest('[data-hh-skip]') || t.querySelector('[data-l]') || t.matches('.tbl')) return; // Bảng đã có kiểu điện thoại riêng (Sun Saphia).
		var hs = t.tHead ? [].map.call(t.tHead.rows[0] ? t.tHead.rows[0].cells : [], function (c) { return c.querySelector('.sr,[style*="-9999"]') ? '' : c.textContent.replace(/\s+/g, ' ').trim(); }) : [];
		if (hs.length >= 5) {
			t.classList.add('hh-cards');
			[].forEach.call(t.tBodies, function (b) { [].forEach.call(b.rows, function (r) {
				var i = 0;
				[].forEach.call(r.cells, function (c) {
					var h = hs[i] || ''; i += c.colSpan || 1;
					if (h && c.colSpan < 2) c.setAttribute('data-label', h); else c.removeAttribute('data-label');
					if (!h || c.classList.contains('hl') || c.colSpan > 1) c.classList.add('hh-full');
				});
			}); });
		} else t.classList.add('hh-fit');
	}
	function all(){ [].forEach.call(document.querySelectorAll('table'), label); }
	all();
	// Bảng dựng bằng script (giỏ hàng, bảng tính): gắn lại khi đổi dòng.
	[].forEach.call(document.querySelectorAll('table'), function (t) {
		if (window.MutationObserver) new MutationObserver(function () { label(t); }).observe(t, { childList: true, subtree: true });
	});
	// Đầu trang: cuộn xuống thì ẩn (không che chữ), cuộn lên thì hiện lại.
	var hd = document.querySelector('header#hdr, body > header, header.top'), y0 = window.scrollY, mq = window.matchMedia('(max-width:760px)');
	if (hd) window.addEventListener('scroll', function () {
		var y = window.scrollY, open = document.querySelector('#menu.open, .menu.open, [aria-expanded="true"]');
		if (!mq.matches || open || y < 120) { hd.classList.remove('hh-hide'); y0 = y; return; }
		if (Math.abs(y - y0) < 12) return; // Cuộn ít (rung tay) – giữ nguyên.
		hd.classList.toggle('hh-hide', y > y0);
		y0 = y;
	}, { passive: true });
})();
</script>
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
