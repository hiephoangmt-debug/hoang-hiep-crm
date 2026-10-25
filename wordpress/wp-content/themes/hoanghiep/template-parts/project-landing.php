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
/* Mô hình 3D/4D: xem thử một lúc rồi hiện form để lại số Zalo. */
.hh-gate4d{position:absolute;inset:0;z-index:2147483602;display:flex;align-items:center;justify-content:center;padding:16px;background:rgba(8,22,44,.72);backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px);font-family:inherit}
.hh-gate4d form{width:100%;max-width:340px;background:#fff;color:#14223a;border-radius:16px;padding:20px 18px 16px;box-shadow:0 20px 50px -12px rgba(0,0,0,.55);text-align:left}
.hh-gate4d b{display:block;font-size:18px;line-height:1.3;margin-bottom:6px}
.hh-gate4d p{margin:0 0 12px;font-size:14px;line-height:1.45;color:#4a5872}
.hh-gate4d input{display:block;width:100%;box-sizing:border-box;margin:0 0 10px;padding:12px 14px;border:1.5px solid #d5dce8;border-radius:10px;font:inherit;font-size:16px;color:#14223a;background:#fff}
.hh-gate4d button{display:block;width:100%;border:0;border-radius:999px;padding:13px 16px;background:#E96118;color:#fff;font:inherit;font-size:16px;font-weight:700;cursor:pointer}
.hh-gate4d .e{color:#c0392b;font-size:13px;min-height:1em;margin:-4px 0 8px}
.hh-gate4d small{display:block;margin-top:10px;text-align:center;font-size:13px;color:#6b7891}
.hh-gate4d small a{color:#E96118;font-weight:700;text-decoration:none}
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
		if (!f || !f.querySelector || f.matches('.hhc-i, #chatForm, .chat-foot, #calcForm, .hd-search, .hh-gate4d form')) return;
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
<script>
(function(){
	// Mô hình 3D · 4D (Sun Saphia, FourS): khách xoay thử một chút (FREE giây kể từ lúc chạm vào mô hình, hoặc IDLE giây
	// mô hình nằm trên màn hình) rồi hiện form để lại tên + số Zalo; gửi xong mở khóa luôn (nhớ trên máy khách).
	var FREE = 8, IDLE = 20, BOXES = '#ss4d-box, #sscc-box, .t360-box, .hh-4dbox';
	// Khung chứa nút .t360 (FourS) – nút được thay bằng khung mô hình khi bấm.
	document.querySelectorAll('.t360').forEach(function (b) { if (b.parentElement && !b.parentElement.matches(BOXES)) b.parentElement.classList.add('hh-4dbox'); });
	var url = <?php echo wp_json_encode( admin_url( 'admin-post.php' ) ); ?>, ref = <?php echo (int) get_queried_object_id(); ?>;
	var known = function () { try { return '1' === localStorage.getItem('hhZalo'); } catch (e) { return false; } };
	if (known()) return;
	var st = new WeakMap(), gated = false;
	function gate(box) {
		if (gated || known()) return;
		gated = true;
		var o = document.createElement('div');
		o.className = 'hh-gate4d';
		o.innerHTML = '<form novalidate><b>Xem tiếp mô hình 3D · 4D</b><p>Anh/chị để lại số Zalo, Hoàng Hiệp gửi luôn bảng giá, mặt bằng căn và mở toàn bộ mô hình để xem tiếp.</p>'
			+ '<input name="name" autocomplete="name" placeholder="Họ và tên">'
			+ '<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Số điện thoại / Zalo *" required>'
			+ '<div class="e" aria-live="polite"></div><button type="submit">Xem tiếp mô hình →</button>'
			+ '<small>Hoặc gọi ngay <a href="tel:0904567009">0904 567 009</a></small></form>';
		var f = o.querySelector('form');
		window.addEventListener('submit', function (e) {
			if (e.target !== f) return;
			e.preventDefault(); e.stopImmediatePropagation();
			var phone = String(f.phone.value || '').replace(/[^0-9+]/g, '');
			if (!/^(\+?84|0)\d{8,10}$/.test(phone)) { o.querySelector('.e').textContent = 'Anh/chị kiểm tra lại số điện thoại giúp em.'; f.phone.focus(); return; }
			var d = new FormData();
			d.append('action', 'hh_lead'); d.append('ajax', '1'); d.append('ref_id', ref);
			d.append('name', String(f.name.value || '').trim() || 'Khách xem 4D'); d.append('phone', phone);
			d.append('need', 'Xem 4D, chọn căn'); d.append('message', 'Xem mô hình 3D/4D trên trang: ' + document.title);
			try { fetch(url, { method: 'POST', body: d, credentials: 'same-origin', keepalive: true }); } catch (err) {}
			try { localStorage.setItem('hhZalo', '1'); } catch (err) {}
			document.querySelectorAll('.hh-gate4d').forEach(function (x) { x.remove(); });
		}, true); // Bắt ở cấp window, trước script landing (script đó không xử lý form này).
		if (getComputedStyle(box).position === 'static') box.style.position = 'relative';
		box.appendChild(o);
	}
	// Chạm vào mô hình (khung khác tên miền): trang mất focus, khung mô hình nhận focus.
	window.addEventListener('blur', function () {
		setTimeout(function () {
			var a = document.activeElement, box = a && a.tagName === 'IFRAME' && a.closest(BOXES);
			if (box) { var s = st.get(box) || {}; if (!s.touch) { s.touch = Date.now(); st.set(box, s); } }
		}, 0);
	});
	setInterval(function () {
		if (gated) return;
		document.querySelectorAll(BOXES).forEach(function (box) {
			if (!box.querySelector('iframe')) return;
			var s = st.get(box) || { seen: 0 }, r = box.getBoundingClientRect();
			if (r.bottom > innerHeight * 0.3 && r.top < innerHeight * 0.7) s.seen = (s.seen || 0) + 1;
			st.set(box, s);
			if ((s.touch && Date.now() - s.touch > FREE * 1000) || s.seen >= IDLE) gate(box);
		});
	}, 1000);
	// Nút mở mô hình ở tab mới (toàn màn hình): hỏi số Zalo trước.
	document.addEventListener('click', function (e) {
		var a = e.target.closest && e.target.closest('a[href*="toa-nha.html"], a[href*="xem-can-ho.html"], a[href*="sun-saphia-4d"]');
		if (!a || known()) return;
		var sec = a.closest('section'), box = sec && sec.querySelector(BOXES);
		if (!box) return;
		e.preventDefault();
		var t = sec.querySelector('.t360'); if (t) t.click();
		gate(box);
		box.scrollIntoView({ block: 'center' });
	}, true);
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
