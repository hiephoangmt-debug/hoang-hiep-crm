/* Sun Saphia – chữ chìm tên web + số điện thoại trên toàn trang (ảnh chụp màn hình luôn mang thương hiệu),
   chặn kéo/lưu ảnh, hạn chế bôi đen; nội dung bị sao chép tự kèm nguồn. Dán 1 dòng vào "Trước </body>". */
(function(){
  if (window.__ssProtect) return; window.__ssProtect = 1;
  var host = (location.hostname || 'sun-saphia-residence.com').replace(/^www\./, '');
  if (/ladipage|ldpdemo|localhost|^[\d.]+$|^$/.test(host)) host = 'sun-saphia-residence.com';
  var PHONE = '0904 567 009', TXT = host + ' · ' + PHONE;
  function esc(s){ return s.replace(/&/g,'&amp;').replace(/</g,'&lt;'); }
  // ô lặp chữ chìm (SVG) – nghiêng, mờ, không chặn bấm
  var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="560" height="300"><g transform="rotate(-22 280 150)" font-family="Arial,sans-serif" font-weight="700" fill="#ffffff" stroke="#0A2540" stroke-width="0.7" paint-order="stroke">'
    + '<text x="280" y="140" font-size="21" text-anchor="middle">' + esc(host) + '</text><text x="280" y="168" font-size="19" text-anchor="middle">Hotline ' + PHONE + '</text></g></svg>';
  var url = 'url("data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg) + '")';
  var css = '#ss-wm{position:fixed;inset:0;z-index:2147482000;pointer-events:none;background-image:' + url + ';background-repeat:repeat;opacity:.16}'
    + '#ss-wm2{position:fixed;left:50%;bottom:14%;transform:translateX(-50%) rotate(-8deg);z-index:2147482001;pointer-events:none;font:800 clamp(16px,3.4vw,30px)/1.25 Arial,sans-serif;color:#fff;-webkit-text-stroke:.6px #0A2540;opacity:.22;white-space:nowrap;text-align:center}'
    + 'body{-webkit-user-select:none;user-select:none;-webkit-touch-callout:none}'
    + 'input,textarea,select,[contenteditable],[contenteditable] *,.ladi-form *,form *{-webkit-user-select:text;user-select:text;-webkit-touch-callout:default}'
    + 'img{-webkit-user-drag:none;user-drag:none}'
    + '@media print{body *{visibility:hidden!important}body:after{content:"' + TXT + ' – vui lòng liên hệ để nhận tài liệu";visibility:visible;position:fixed;top:40%;left:0;right:0;text-align:center;font:700 24px Arial}}';
  var st = document.createElement('style'); st.textContent = css; (document.head || document.documentElement).appendChild(st);
  function mount(){
    if (document.getElementById('ss-wm') || !document.body) return;
    var a = document.createElement('div'); a.id = 'ss-wm'; a.setAttribute('aria-hidden','true');
    var b = document.createElement('div'); b.id = 'ss-wm2'; b.setAttribute('aria-hidden','true'); b.textContent = TXT;
    document.body.appendChild(a); document.body.appendChild(b);
  }
  if (document.body) mount(); else document.addEventListener('DOMContentLoaded', mount);
  setTimeout(mount, 1500);
  // chặn menu chuột phải / nhấn giữ trên ảnh, chặn kéo ảnh
  function isMedia(el){ for (var i=0; el && i<4; i++, el=el.parentElement){ if (el.tagName==='IMG'||el.tagName==='PICTURE'||el.tagName==='CANVAS'||el.tagName==='VIDEO') return true;
      var bg = el.style && el.style.backgroundImage; if (bg && bg!=='none') return true; if (el.classList && (el.classList.contains('ladi-image')||el.classList.contains('ladi-image-background'))) return true; } return false; }
  document.addEventListener('contextmenu', function(e){ if (isMedia(e.target)) e.preventDefault(); }, true);
  document.addEventListener('dragstart', function(e){ if (isMedia(e.target)) e.preventDefault(); }, true);
  // sao chép chữ: tự kèm nguồn
  document.addEventListener('copy', function(e){
    var t = String(window.getSelection ? window.getSelection() : ''); if (!t || !e.clipboardData) return;
    var tg = e.target && e.target.closest && e.target.closest('input,textarea,form'); if (tg) return;
    e.clipboardData.setData('text/plain', t + '\n\n— Nguồn: ' + host + ' · Hotline/Zalo ' + PHONE);
    e.preventDefault();
  });
  // phím tắt lưu/in trang
  document.addEventListener('keydown', function(e){ var k=(e.key||'').toLowerCase(); if ((e.ctrlKey||e.metaKey) && (k==='s'||k==='p'||k==='u')) e.preventDefault(); });
})();
