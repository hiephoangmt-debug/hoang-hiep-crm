/* Nút "4D" nổi cho website: bấm mở danh sách dự án 3D/4D ngay trên trang (khung toàn màn hình).
   Gắn vào web bằng 1 dòng:
   <script src="https://hiephoangmt-debug.github.io/hoang-hiep-crm/du-an/nut-4d.js" defer></script>
   Tuỳ chọn: data-trang="lo-dat-hoang-sa" (mở thẳng 1 dự án), data-vitri="trai" (đặt nút bên trái). */
(function () {
  if (window.__nut4d) return; window.__nut4d = 1;
  var me = document.currentScript, base = me ? me.src.replace(/du-an\/nut-4d\.js.*$/, '') : 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/';
  var page = (me && me.getAttribute('data-trang')) || 'du-an';
  var left = me && me.getAttribute('data-vitri') === 'trai';
  var css = document.createElement('style');
  css.textContent =
    '.n4d-btn{position:fixed;' + (left ? 'left' : 'right') + ':16px;bottom:96px;z-index:2147483000;width:66px;height:66px;border-radius:50%;border:0;cursor:pointer;' +
    'background:radial-gradient(circle at 30% 30%,#ffd36b,#e0901c 60%,#b8650c);color:#2a1500;font:800 20px/1 Inter,Arial,sans-serif;letter-spacing:.5px;' +
    'box-shadow:0 6px 18px rgba(0,0,0,.35);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:2px}' +
    '.n4d-btn small{font:700 8.5px/1 Inter,Arial,sans-serif;letter-spacing:.3px;text-transform:uppercase}' +
    '.n4d-btn::after{content:"";position:absolute;inset:-6px;border-radius:50%;border:3px solid #f2b33d;opacity:.7;animation:n4dp 1.8s ease-out infinite}' +
    '@keyframes n4dp{0%{transform:scale(.9);opacity:.8}100%{transform:scale(1.35);opacity:0}}' +
    '.n4d-ov{position:fixed;inset:0;z-index:2147483001;background:#0b1626;display:none}' +
    '.n4d-ov.on{display:block}.n4d-ov iframe{width:100%;height:100%;border:0;display:block}' +
    '.n4d-x{position:absolute;top:max(10px,env(safe-area-inset-top));right:10px;z-index:2;width:40px;height:40px;border-radius:50%;border:0;cursor:pointer;' +
    'background:#000a;color:#fff;font:700 20px/1 Arial,sans-serif}';
  document.head.appendChild(css);
  var b = document.createElement('button');
  b.className = 'n4d-btn'; b.type = 'button'; b.setAttribute('aria-label', 'Xem dự án 4D');
  b.innerHTML = '4D<small>Xem dự án</small>';
  var ov = document.createElement('div'); ov.className = 'n4d-ov';
  var x = document.createElement('button'); x.className = 'n4d-x'; x.type = 'button'; x.setAttribute('aria-label', 'Đóng'); x.textContent = '✕';
  ov.appendChild(x);
  var fr = null;
  b.onclick = function () {
    if (!fr) { fr = document.createElement('iframe'); fr.src = base + page + '/'; fr.allow = 'fullscreen; accelerometer; gyroscope'; fr.title = 'Dự án 4D'; ov.appendChild(fr); }
    ov.classList.add('on'); document.documentElement.style.overflow = 'hidden';
  };
  x.onclick = function () { ov.classList.remove('on'); document.documentElement.style.overflow = ''; };
  function mount() { document.body.appendChild(b); document.body.appendChild(ov); }
  if (document.body) mount(); else document.addEventListener('DOMContentLoaded', mount);
})();
