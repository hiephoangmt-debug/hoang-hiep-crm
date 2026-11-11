/* Thanh menu Tuyển Sale Đà Nẵng: tự gắn vào đầu mọi trang.
   Dán 1 dòng <script src="...menu.js" defer></script> vào Thiết lập trang > Mã JavaScript/CSS > "Trước thẻ </body>". */
(function () {
  if (window.__hmMenu) return; window.__hmMenu = 1;

  function widget() {
    if (document.querySelector('.hhf')) return;
    var st = document.createElement('style'); st.textContent = "\n.hhf,.hhf *{box-sizing:border-box;font-family:\"Be Vietnam Pro\",Arial,sans-serif;line-height:1.35}\n.hhf{position:fixed;right:16px;bottom:24px;z-index:2147483000;display:flex;flex-direction:column;align-items:flex-end;gap:12px}\n.hhf a{display:flex;align-items:center;gap:10px;text-decoration:none}\n.hhf-ic{position:relative;width:54px;height:54px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:13px;flex:none;box-shadow:0 8px 20px rgba(21,36,90,.28);border:3px solid #fff}\n.hhf-ic svg{width:24px;height:24px;fill:#fff}\n.hhf-lb{background:#fff;color:#1B2D6B;font-weight:800;font-size:14px;padding:8px 13px;border-radius:999px;box-shadow:0 6px 16px rgba(21,36,90,.18);white-space:nowrap}\n.hhf-lb b{color:#FF6B1A}\n.hhf-call .hhf-ic{background:#FF6B1A;animation:hhfring 1.8s infinite}\n.hhf-call .hhf-ic svg{animation:hhfshake 1.8s infinite}\n.hhf-zalo .hhf-ic{background:#0068FF;font-size:14px;letter-spacing:.2px}\n.hhf-chat .hhf-ic{background:#1B2D6B}\n.hhf-chat .hhf-ic:after{content:\"\";position:absolute;top:2px;right:2px;width:12px;height:12px;border-radius:50%;background:#22C55E;border:2px solid #fff}\n.hhf a.hhf-tip{display:block;position:relative;width:228px;background:#fff;color:#163056;font-size:14px;line-height:1.45;padding:12px 14px;border-radius:14px 14px 4px 14px;box-shadow:0 12px 28px rgba(21,36,90,.22);border:1px solid #E3E8F1;animation:hhftip 24s 2s infinite both}\n.hhf-tip b{display:block;color:#1B2D6B;font-size:15px;margin-bottom:2px}\n.hhf-tip i{font-style:normal;color:#FF6B1A;font-weight:800}\n.hhf .hhf-lb{display:none}\n@media(min-width:900px){.hhf{bottom:28px;right:24px}.hhf .hhf-lb{display:block}.hhf-sms{display:none!important}}\n@keyframes hhfring{0%{box-shadow:0 0 0 0 rgba(255,107,26,.65),0 8px 20px rgba(21,36,90,.28)}70%{box-shadow:0 0 0 16px rgba(255,107,26,0),0 8px 20px rgba(21,36,90,.28)}100%{box-shadow:0 0 0 0 rgba(255,107,26,0),0 8px 20px rgba(21,36,90,.28)}}\n@keyframes hhfshake{0%,40%,100%{transform:rotate(0)}5%,15%,25%{transform:rotate(-16deg)}10%,20%,30%{transform:rotate(16deg)}}\n@keyframes hhftip{0%{opacity:0;transform:translateY(10px) scale(.96);visibility:hidden}3%,45%{opacity:1;transform:none;visibility:visible}50%,100%{opacity:0;transform:translateY(10px) scale(.96);visibility:hidden}}\n"; document.head.appendChild(st);
    var d = document.createElement('div'); d.innerHTML = "<div class=\"hhf\" id=\"hhf-lien-he\">\n  <a class=\"hhf-tip\" href=\"https://zalo.me/0904567009\" target=\"_blank\" rel=\"noopener\"><b>Ch\u00e0o b\u1ea1n \ud83d\udc4b M\u00ecnh l\u00e0 Hi\u1ec7p</b>H\u1ecfi l\u01b0\u01a1ng, th\u01b0\u1edfng hay l\u1ecbch ph\u1ecfng v\u1ea5n? <i>Nh\u1eafn m\u00ecnh ngay nh\u00e9!</i></a>\n  <a class=\"hhf-chat hhf-sms\" href=\"sms:0904567009?&amp;body=Ch%C3%A0o%20anh%20Hi%E1%BB%87p%2C%20em%20mu%E1%BB%91n%20%E1%BB%A9ng%20tuy%E1%BB%83n%20Sale%20B%C4%90S.%20Em%20t%C3%AAn%3A%20\" aria-label=\"Nh\u1eafn tin cho anh Hi\u1ec7p\"><span class=\"hhf-lb\">Nh\u1eafn tin</span><span class=\"hhf-ic\"><svg viewBox=\"0 0 24 24\"><path d=\"M12 3C6.5 3 2 6.9 2 11.6c0 2.6 1.4 5 3.7 6.5L5 21.5l3.8-2.1c1 .3 2.1.4 3.2.4 5.5 0 10-3.9 10-8.6S17.5 3 12 3zm-4.5 9.9a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6zm4.5 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6zm4.5 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6z\"/></svg></span></a>\n  <a class=\"hhf-zalo\" href=\"https://zalo.me/0904567009\" target=\"_blank\" rel=\"noopener\" aria-label=\"Chat Zalo v\u1edbi anh Hi\u1ec7p\"><span class=\"hhf-lb\">Chat Zalo v\u1edbi <b>Hi\u1ec7p</b></span><span class=\"hhf-ic\">Zalo</span></a>\n  <a class=\"hhf-call\" href=\"tel:0904567009\" aria-label=\"G\u1ecdi 0904 567 009\"><span class=\"hhf-lb\">G\u1ecdi <b>0904 567 009</b></span><span class=\"hhf-ic\"><svg viewBox=\"0 0 24 24\"><path d=\"M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1z\"/></svg></span></a>\n</div>"; document.body.appendChild(d.firstElementChild);
  }
  function crm() {
    if (document.querySelector('script[src*="AKfycbyMWXl47PShn"]')) return;
    var c = document.createElement('script'); c.async = true; c.setAttribute('data-key', 'yxt6hKlAI0dU');
    c.src = 'https://script.google.com/macros/s/AKfycbyMWXl47PShn-ikZKwrFONJb9z89NOmVG6yIioyjGxo55IEbLh4yP7KiREPsxgSbxBl/exec?js=1';
    document.head.appendChild(c);
  }
  function run() {
    var b = document.body; if (!b) return;
    try { widget(); } catch (e) {}
    try { crm(); } catch (e) {}
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
    [].forEach.call(document.querySelectorAll('a'), function (a) {
      if (a.closest('#hmbar')) return;
      var t = (a.textContent || '').trim();
      if (t === 'Vị trí tuyển' && a.getBoundingClientRect().top < 220) {
        var sec = a.closest('.ladi-section') || a.closest('header') || a.closest('.top');
        if (sec) sec.style.display = 'none';
      }
    });
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
