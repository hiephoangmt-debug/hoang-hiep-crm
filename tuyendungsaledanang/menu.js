/* Thanh menu Tuyển Sale Đà Nẵng: tự gắn vào đầu mọi trang.
   Dán 1 dòng <script src="...menu.js" defer></script> vào Thiết lập trang > Mã JavaScript/CSS > "Trước thẻ </body>". */
(function () {
  if (window.__hmMenu) return; window.__hmMenu = 1;
  function run() {
    var b = document.body; if (!b) return;
    // Trang đã có sẵn thanh menu (bài viết dạng tĩnh) thì thôi
    if (document.querySelector('.top .menu, .hm-menu')) {
      var ex = document.querySelector('.top .menu, .hm-menu');
      if (ex.getBoundingClientRect().height > 0) return;
    }
    var S = 'https://www.tuyendungsaledanang.com';
    var css = '#hmbar{position:fixed;top:0;left:0;right:0;z-index:2147482000;background:#1B2D6B;box-shadow:0 2px 12px rgba(0,0,0,.2);font-family:"Be Vietnam Pro",Arial,sans-serif;line-height:1.3}' +
      '#hmbar *{box-sizing:border-box}' +
      '#hmbar .r1,#hmbar .r2 .in{max-width:1160px;margin:0 auto;padding:0 16px}' +
      '#hmbar .r1{display:flex;justify-content:space-between;align-items:center;gap:10px;height:52px}' +
      '#hmbar .br{color:#fff;text-decoration:none;font-weight:800;font-size:15px;letter-spacing:.5px;white-space:nowrap}' +
      '#hmbar .br em{font-style:normal;color:#FFB98F}' +
      '#hmbar .ac{display:flex;align-items:center;gap:8px}' +
      '#hmbar .cl{color:#fff;text-decoration:none;font-weight:700;font-size:14px;white-space:nowrap}' +
      '#hmbar .ap{background:#f47c20;color:#fff;text-decoration:none;font-weight:800;font-size:14px;border-radius:999px;padding:8px 14px;white-space:nowrap}' +
      '#hmbar .r2{background:#14234f;border-top:1px solid rgba(255,255,255,.08)}' +
      '#hmbar .r2 .in{display:flex;gap:4px;overflow-x:auto;white-space:nowrap;scrollbar-width:none;height:40px;align-items:center}' +
      '#hmbar .r2 .in::-webkit-scrollbar{display:none}' +
      '#hmbar .r2 a{color:#dfe5f5;text-decoration:none;font-weight:600;font-size:14px;padding:10px;display:inline-block}' +
      '#hmbar .r2 a:hover{color:#fff;box-shadow:inset 0 -3px 0 #f47c20}' +
      '@media(max-width:520px){#hmbar .cl span{display:none}#hmbar .br{font-size:14px}}';
    var st = document.createElement('style'); st.textContent = css; document.head.appendChild(st);
    var toc = document.getElementById('muc-luc') ? '<a href="#muc-luc">📑 Mục lục</a>' : '';
    var items = [['/', 'Trang chủ'], ['/#vi-tri', 'Vị trí tuyển'], ['/#chinh-sach', 'Chính sách'], ['/#mkt-3-lop', 'Marketing 3 lớp'],
      ['/#du-an', 'Dự án'], ['/#cam-nang', 'Cẩm nang'], ['/#doi-ngu', 'Đội ngũ'], ['/#faq', 'Hỏi đáp']];
    var links = toc + items.map(function (x) { return '<a href="' + S + x[0] + '">' + x[1] + '</a>'; }).join('') +
      '<a href="https://zalo.me/0904567009" target="_blank" rel="noopener">Zalo</a>';
    var bar = document.createElement('div'); bar.id = 'hmbar';
    bar.innerHTML = '<div class="r1"><a class="br" href="' + S + '/">TUYỂN SALE <em>ĐÀ NẴNG</em></a>' +
      '<div class="ac"><a class="cl" href="tel:0904567009">📞<span> 0904 567 009</span></a><a class="ap" href="' + S + '/#dang-ky">Ứng tuyển</a></div></div>' +
      '<nav class="r2"><div class="in">' + links + '</div></nav>';
    b.insertBefore(bar, b.firstChild);
    // Ẩn thanh cũ (nếu LadiPage còn giữ) và đẩy nội dung xuống dưới thanh mới
    var old = document.querySelector('.top'); if (old && old !== bar) old.style.display = 'none';
    var pad = function () { b.style.paddingTop = bar.offsetHeight + 'px'; };
    pad(); window.addEventListener('resize', pad);
    var s2 = document.createElement('style');
    s2.textContent = 'html{scroll-padding-top:100px;scroll-behavior:smooth}';
    document.head.appendChild(s2);
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run); else run();
})();
