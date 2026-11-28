<?php
/**
 * Cân giữa lưới thẻ trên mọi trang (anh Hiệp 28/11/2026): lưới (CSS grid) nào có hàng cuối thiếu thẻ, hoặc ít thẻ hơn số cột,
 * thì chuyển sang xếp hàng căn giữa – giữ nguyên độ rộng thẻ, khoảng cách và chiều cao bằng nhau trong một hàng.
 * Chỉ áp cho lưới có các cột rộng bằng nhau và không có thẻ chiếm nhiều cột (không đụng bố cục ảnh lớn + chữ,
 * album có ảnh to). Không áp trong form, menu. Bỏ qua phần tử có thuộc tính data-no-center.
 *
 * @package HoangHiep
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_footer',
	static function () {
		?>
<script id="hh-can-giua-luoi">
(function () {
	var KEYS = ['display', 'flexWrap', 'justifyContent', 'alignItems', 'columnGap', 'rowGap'];
	var KID = ['flex', 'maxWidth', 'minWidth', 'width'];
	function undo(el) {
		if (!el.__hhc) return;
		KEYS.forEach(function (k) { el.style[k] = el.__hhc.s[k]; });
		el.__hhc.k.forEach(function (o) { KID.forEach(function (k) { o.el.style[k] = o.s[k]; }); });
		el.__hhc = null;
		el.removeAttribute('data-hh-center');
	}
	function fix(el) {
		if (/^(UL|OL|DL|TABLE|TBODY|THEAD|TR)$/.test(el.tagName) || el.closest('form,nav,[data-no-center]')) return; // Danh sách gạch đầu dòng giữ nguyên.
		var cs = getComputedStyle(el);
		if (cs.display !== 'grid' && cs.display !== 'inline-grid') return;
		var tr = cs.gridTemplateColumns.split(/\s+/).map(parseFloat).filter(function (v) { return v > 0; });
		var cols = tr.length;
		if (cols < 2 || Math.max.apply(null, tr) - Math.min.apply(null, tr) > 2) return;
		var kids = Array.prototype.filter.call(el.children, function (c) {
			var s = getComputedStyle(c);
			return s.display !== 'none' && s.position !== 'absolute' && s.position !== 'fixed' && c.tagName !== 'SCRIPT' && c.tagName !== 'TEMPLATE';
		});
		var n = kids.length;
		if (!n || n % cols === 0) return;
		for (var i = 0; i < n; i++) {
			var k = getComputedStyle(kids[i]);
			if (/span\s*([2-9]|\d\d)/.test(k.gridColumnEnd + ' ' + k.gridColumnStart) || /span\s*([2-9]|\d\d)/.test(k.gridRowEnd + ' ' + k.gridRowStart)) return;
		}
		var w = tr[0];
		var save = { s: {}, k: [] };
		KEYS.forEach(function (k) { save.s[k] = el.style[k]; });
		var cg = cs.columnGap, rg = cs.rowGap;
		el.style.display = 'flex';
		el.style.flexWrap = 'wrap';
		el.style.justifyContent = 'center';
		el.style.alignItems = cs.alignItems === 'start' ? 'flex-start' : (cs.alignItems === 'center' ? 'center' : 'stretch');
		el.style.columnGap = cg === 'normal' ? '0px' : cg;
		el.style.rowGap = rg === 'normal' ? '0px' : rg;
		kids.forEach(function (c) {
			var o = { el: c, s: {} };
			KID.forEach(function (k) { o.s[k] = c.style[k]; });
			save.k.push(o);
			c.style.flex = '0 0 ' + w + 'px';
			c.style.maxWidth = w + 'px';
			c.style.minWidth = '0';
		});
		el.__hhc = save;
		el.setAttribute('data-hh-center', '1');
	}
	function run() {
		document.querySelectorAll('[data-hh-center]').forEach(undo);
		var all = document.body.getElementsByTagName('*');
		for (var i = 0; i < all.length; i++) {
			var el = all[i];
			if (el.children.length && el.offsetWidth) {
				try { fix(el); } catch (e) {}
			}
		}
	}
	var t;
	function later(ms) { clearTimeout(t); t = setTimeout(run, ms || 120); }
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { later(0); }); else later(0);
	window.addEventListener('load', function () { later(50); });
	window.addEventListener('resize', function () { later(200); });
	document.addEventListener('click', function () { later(250); }, true);
	if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { later(50); });
})();
</script>
		<?php
	},
	98
);
