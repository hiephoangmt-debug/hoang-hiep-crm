<?php
/**
 * In trang landing dự án (đầu trang: wp_head – tiêu đề, mô tả, canonical, schema của web; thân: nội dung landing).
 * Form landing vẫn gửi như bản gốc; thêm: lưu khách vào mục Khách hàng của web.
 */

defined( 'ABSPATH' ) || exit;

$hh_file = hoanghiep_landing_file();
if ( $hh_file ) {
	$hh_html = (string) file_get_contents( $hh_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$hh_head = (string) strstr( (string) strstr( $hh_html, '<!--HH-LANDING-HEAD-->' ), '<!--HH-LANDING-BODY-->', true );
	$hh_body = (string) substr( (string) strstr( $hh_html, '<!--HH-LANDING-BODY-->' ), strlen( '<!--HH-LANDING-BODY-->' ) );
} else {
	// Mẫu tự động (giống trang The Poet): CSS landing-mau.css nạp qua wp_head, nội dung dựng từ dữ liệu dự án.
	$hh_head = '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">';
	ob_start();
	get_template_part( 'template-parts/project-landing-auto' );
	$hh_body = (string) ob_get_clean();
}
// Ảnh lớn trong plugin có sẵn bản WebP nhẹ (x.w1200.webp): điện thoại tải bản này.
if ( defined( 'HH_CRM_DIR' ) ) {
	$hh_body = preg_replace_callback(
		'#<img\b([^>]*?)\ssrc="\{\{HH_CRM_URL\}\}(img/[^"]+?)\.(jpe?g|png)"([^>]*)>#i',
		static function ( $m ) {
			if ( false !== stripos( $m[1] . $m[4], 'srcset=' ) ) {
				return $m[0];
			}
			$set = array();
			foreach ( array( 1200 ) as $w ) {
				if ( is_file( HH_CRM_DIR . $m[2] . '.w' . $w . '.webp' ) ) {
					$set[] = '{{HH_CRM_URL}}' . $m[2] . '.w' . $w . '.webp ' . $w . 'w';
				}
			}
			if ( ! $set ) {
				return $m[0];
			}
			// Giữ tỷ lệ khung theo width/height (không giật bố cục khi ảnh tải xong).
			if ( preg_match( '/\swidth="(\d+)"/', $m[1] . $m[4], $wm ) && preg_match( '/\sheight="(\d+)"/', $m[1] . $m[4], $hm ) && false === stripos( $m[1] . $m[4], 'style=' ) ) {
				$m[4] .= ' style="--ar:' . $wm[1] . '/' . $hm[1] . '"';
			}
			// Màn hình ≤ 900px: bản WebP 1200px; máy tính: ảnh gốc.
			return '<picture class="hh-pic"><source media="(max-width: 900px)" type="image/webp" srcset="' . explode( ' ', $set[0] )[0] . '"><img' . $m[1] . ' src="{{HH_CRM_URL}}' . $m[2] . '.' . $m[3] . '"' . $m[4] . '></picture>';
		},
		$hh_body
	);
}
// Nền mờ phía sau ảnh đầu trang (--bg:url(…)): ảnh đã làm mờ nên dùng bản WebP 1200px thay file gốc.
if ( defined( 'HH_CRM_DIR' ) ) {
	$hh_body = preg_replace_callback(
		"#--bg:url\\('\\{\\{HH_CRM_URL\\}\\}(img/[^']+?)\\.(jpe?g|png)'\\)#i",
		static fn( $m ) => is_file( HH_CRM_DIR . $m[1] . '.w1200.webp' ) ? "--bg:url('{{HH_CRM_URL}}" . $m[1] . ".w1200.webp')" : $m[0],
		$hh_body
	);
}
// Ảnh lưu trong plugin (img/…): {{HH_CRM_URL}} → đường dẫn thư mục plugin trên web.
$hh_body = str_replace( '{{HH_CRM_URL}}', defined( 'HH_CRM_URL' ) ? HH_CRM_URL : '', $hh_body );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php echo $hh_head; // phpcs:ignore WordPress.Security.EscapeOutput -- CSS của landing dựng sẵn trong giao diện. ?>
<style id="hh-landing-mobile">
picture.hh-pic{display:contents}
.answer-sec{padding:28px 0 6px}
.hh-answer{border:1px solid rgba(176,125,74,.35);border-left:4px solid #b07d4a;background:#fffaf3;color:#14223a;border-radius:14px;padding:18px 20px 8px;max-width:980px;margin:0 auto;font-size:16px;line-height:1.6}
.hh-answer p{margin:0 0 10px}
.hh-answer table{width:100%;border-collapse:collapse;margin:8px 0 10px;font-size:15px;background:#fff}
.hh-answer th,.hh-answer td{border:1px solid rgba(0,0,0,.08);padding:8px 10px;text-align:left}
.hh-answer th{background:#f3ece2;font-weight:600}
.hh-answer small{display:block;color:#6b7280;line-height:1.5}
/* Đăng nhập (có thanh quản trị WordPress): đầu trang dính ngay dưới thanh, không bị che. */
body.admin-bar>header.top,body.admin-bar>header#hdr{top:32px}
@media (max-width:782px){body.admin-bar>header.top,body.admin-bar>header#hdr{top:46px}}
@media (max-width:600px){body.admin-bar>header.top,body.admin-bar>header#hdr{top:0}}
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
.hh-gate4d{position:absolute;inset:0;z-index:5;display:flex;align-items:center;justify-content:center;padding:16px;background:rgba(8,22,44,.72);backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px);font-family:inherit}
.hh-gate4d form{width:100%;max-width:340px;background:#fff;color:#14223a;border-radius:16px;padding:20px 18px 16px;box-shadow:0 20px 50px -12px rgba(0,0,0,.55);text-align:left}
.hh-gate4d b{display:block;font-size:18px;line-height:1.3;margin-bottom:6px}
.hh-gate4d p{margin:0 0 12px;font-size:14px;line-height:1.45;color:#4a5872}
.hh-gate4d input{display:block;width:100%;box-sizing:border-box;margin:0 0 10px;padding:12px 14px;border:1.5px solid #d5dce8;border-radius:10px;font:inherit;font-size:16px;color:#14223a;background:#fff}
.hh-gate4d button{display:block;width:100%;border:0;border-radius:999px;padding:13px 16px;background:#E96118;color:#fff;font:inherit;font-size:16px;font-weight:700;cursor:pointer}
.hh-gate4d .e{color:#c0392b;font-size:13px;min-height:1em;margin:-4px 0 8px}
.hh-gate4d small{display:block;margin-top:10px;text-align:center;font-size:13px;color:#6b7891}
.hh-gate4d small a{color:#E96118;font-weight:700;text-decoration:none}
/* Màu hành động (11/2026): cam rực trên nền navy – nút để lại thông tin nổi nhất trang; nút chat cùng màu. Zalo xanh dương, Gọi xanh lá giữ nguyên. */
body.hh-landing{--act:#f2551d;--act2:#ff8a3d;--act-ink:#fff}
body.hh-landing .btn-gold,body.hh-landing a.btn-gold,body.hh-landing button.btn-gold{background:linear-gradient(135deg,var(--act),var(--act2));color:var(--act-ink);font-weight:700;box-shadow:0 0 0 3px rgba(255,138,61,.3),0 12px 26px -10px rgba(242,85,29,.95);transition:transform .15s,box-shadow .15s}
body.hh-landing .btn-gold:hover{transform:translateY(-2px);box-shadow:0 0 0 4px rgba(255,138,61,.45),0 16px 30px -10px rgba(242,85,29,1);color:var(--act-ink)}
body.hh-landing header .btn-gold,body.hh-landing .top .btn-gold{animation:hhActPulse 2.6s ease-out infinite}
@keyframes hhActPulse{0%{box-shadow:0 0 0 0 rgba(255,110,50,.7),0 12px 26px -10px rgba(242,85,29,.95)}70%{box-shadow:0 0 0 12px rgba(255,110,50,0),0 12px 26px -10px rgba(242,85,29,.95)}100%{box-shadow:0 0 0 0 rgba(255,110,50,0),0 12px 26px -10px rgba(242,85,29,.95)}}
@media (prefers-reduced-motion:reduce){body.hh-landing header .btn-gold,body.hh-landing .top .btn-gold{animation:none}}
body.hh-landing .hhc{--hhc-cta:#f2551d}
body.hh-landing .hhc__fab{background:linear-gradient(135deg,var(--act),var(--act2));color:var(--act-ink)}
body.hh-landing .hhc__chip{border-color:#f2551d;color:#c2410c}
body.hh-landing .hhc__chip:hover{background:var(--act);color:var(--act-ink)}
body.hh-landing .hhc__form button{color:var(--act-ink)}
body.hh-landing section.cta h2 em,body.hh-landing section.cta .title em{color:#ff7a3d!important}
body.hh-landing section.cta .advisor a{color:#ff8a3d}
</style>
</head>
<body <?php body_class( 'hh-landing' ); ?>>
<?php wp_body_open(); ?>
<?php echo $hh_body; // phpcs:ignore WordPress.Security.EscapeOutput -- Nội dung landing dựng sẵn trong giao diện. ?>
<style>
/* Điện thoại / máy tính bảng: menu mục lục thành nút 3 gạch, bấm sổ danh sách (mọi trang dự án dạng landing). */
.hh-burger{display:none;flex:none;align-items:center;justify-content:center;width:44px;height:44px;margin-left:auto;padding:0;border:0;border-radius:10px;background:transparent;color:inherit;cursor:pointer}
.hh-burger svg{width:26px;height:26px}
.hh-burger .i-close,.hh-mb-open .hh-burger .i-open{display:none}
.hh-mb-open .hh-burger .i-close{display:block}
@media (max-width:980px){
	.hh-burger{display:inline-flex}
	.hh-mb-nav{display:none!important}
	.hh-mb-open .hh-mb-nav{display:flex!important;flex-direction:column;position:fixed;left:0;right:0;top:var(--hh-mb-top,64px);z-index:9998;margin:0!important;padding:6px 0!important;width:auto!important;max-height:calc(100vh - var(--hh-mb-top,64px));overflow-y:auto;background:#fff;box-shadow:0 18px 30px -12px rgba(14,28,51,.35);order:initial}
	.hh-mb-open .hh-mb-nav a{display:block;margin:0;padding:14px 22px!important;border-radius:0!important;background:none!important;color:#14223a!important;opacity:1!important;font-size:16px!important;font-weight:600;white-space:normal;border-bottom:1px solid #eee}
	.hh-mb-open .hh-mb-nav a:last-child{border-bottom:0}
	.hh-mb-open .hh-mb-nav a.on,.hh-mb-open .hh-mb-nav a[aria-current]{color:#f2551d!important}
}
</style>
<script>
(function(){
	var nav = document.querySelector('header.top nav.nav, header.top nav.mnav');
	if (!nav || document.querySelector('.burger')) return; // Landing đã có nút menu riêng (FourS) thì giữ nguyên.
	var hdr = nav.closest('header'), box = nav.parentNode;
	var b = document.createElement('button');
	b.type = 'button'; b.className = 'hh-burger'; b.setAttribute('aria-label', 'Mở menu'); b.setAttribute('aria-expanded', 'false');
	b.innerHTML = '<svg class="i-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg><svg class="i-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>';
	nav.classList.add('hh-mb-nav');
	box.appendChild(b);
	function set(open){
		if (open) document.documentElement.style.setProperty('--hh-mb-top', Math.max(0, Math.round(hdr.getBoundingClientRect().bottom)) + 'px');
		hdr.classList.toggle('hh-mb-open', open);
		b.setAttribute('aria-expanded', open ? 'true' : 'false');
		b.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
	}
	b.addEventListener('click', function(){ set(!hdr.classList.contains('hh-mb-open')); });
	nav.addEventListener('click', function(e){ if (e.target.closest('a')) set(false); });
	document.addEventListener('click', function(e){ if (hdr.classList.contains('hh-mb-open') && !hdr.contains(e.target)) set(false); });
	document.addEventListener('keydown', function(e){ if (e.key === 'Escape') set(false); });
	window.addEventListener('resize', function(){ if (window.innerWidth > 980) set(false); });
})();
</script>
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
		// Đã để lại số ở form bất kỳ → không hỏi lại khi xem mô hình 3D/4D.
		try { localStorage.setItem('hhZalo', '1'); } catch (err) {}
		document.querySelectorAll('.hh-gate4d').forEach(function (x) { x.remove(); });
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
	// Khung khác của trang đang mở (form nhận bảng giá, chat…) → chờ, không hiện chồng 2 form.
	function busy() {
		var shown = function (el) { var cs = getComputedStyle(el); return !el.hidden && cs.display !== 'none' && cs.visibility !== 'hidden' && el.getBoundingClientRect().height > 100; };
		return [].some.call(document.querySelectorAll('#leadPop, [role="dialog"], .lp.on, .modal.show'), function (el) { return !el.closest('.hh-gate4d') && shown(el); });
	}
	function gate(box) {
		if (gated || known() || busy()) return;
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
