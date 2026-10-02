(function () {
  // Menu điện thoại
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('nav');
  toggle.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', open);
  });
  nav.addEventListener('click', function (e) {
    if (e.target.tagName === 'A') { nav.classList.remove('is-open'); toggle.setAttribute('aria-expanded', 'false'); }
  });
  document.getElementById('year').textContent = new Date().getFullYear();

  function money(n) { return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ'; }
  function num(s) { return Number(String(s || '').replace(',', '.').replace('%', '').trim()) || 0; }
  function parseAmount(s) {
    var t = String(s || '').trim().toLowerCase();
    var m = t.match(/^([\d.,]+)\s*(tr|triệu|trieu)$/);
    if (m) return Math.round(Number(m[1].replace(',', '.')) * 1e6);
    var n = Number(t.replace(/[.,\s]/g, ''));
    return n > 0 && n < 100000 ? n * 1000 : n || 0;
  }

  // Máy tính phí
  var fa = document.getElementById('fee-amount'), fr = document.getElementById('fee-rate'), fo = document.getElementById('fee-out');
  function fee() {
    var a = parseAmount(fa.value), r = num(fr.value);
    fo.innerHTML = a ? 'Số tiền <b>' + money(a) + '</b> × ' + r + '% = phí khoảng <b>' + money(a * r / 100) + '</b>' : 'Nhập số tiền, ví dụ 50tr.';
  }
  fa.addEventListener('input', fee); fr.addEventListener('input', fee); fee();
  document.getElementById('fee-tool').addEventListener('submit', function (e) { e.preventDefault(); });

  // Ngày rút đẹp sau sao kê
  var sk = document.getElementById('sk-day'), dd = document.getElementById('due-day'), so = document.getElementById('sk-out');
  function dim(y, m) { return new Date(y, m + 1, 0).getDate(); }
  function at(y, m, d) { var x = new Date(y, m, 1); return new Date(x.getFullYear(), x.getMonth(), Math.min(d, dim(x.getFullYear(), x.getMonth()))); }
  function fmt(d) { return ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth() + 1)).slice(-2); }
  function skCalc() {
    var s = Math.round(num(sk.value)), due = Math.round(num(dd.value));
    if (!(s >= 1 && s <= 31)) { so.textContent = 'Nhập ngày sao kê từ 1 đến 31.'; return; }
    var t = new Date(); t.setHours(0, 0, 0, 0);
    var stmt = at(t.getFullYear(), t.getMonth(), s);
    if (stmt < t) stmt = at(t.getFullYear(), t.getMonth() + 1, s);
    var best = new Date(stmt); best.setDate(best.getDate() + 1);
    var nextStmt = at(best.getFullYear(), best.getMonth() + 1, s);
    var pay;
    if (due >= 1 && due <= 31) { pay = at(nextStmt.getFullYear(), nextStmt.getMonth(), due); if (pay <= nextStmt) pay = at(nextStmt.getFullYear(), nextStmt.getMonth() + 1, due); }
    else { pay = new Date(nextStmt); pay.setDate(pay.getDate() + 25); }
    var days = Math.round((pay - best) / 864e5) + 1;
    so.innerHTML = 'Ngày rút đẹp tới: <b>' + fmt(best) + '</b> (ngay sau sao kê ' + fmt(stmt) + '). Hạn thanh toán ' + (due ? '' : 'ước tính ') +
      '<b>' + fmt(pay) + '</b> → miễn lãi khoảng <b>' + days + ' ngày</b>.';
  }
  sk.addEventListener('input', skCalc); dd.addEventListener('input', skCalc); skCalc();
  document.getElementById('sk-tool').addEventListener('submit', function (e) { e.preventDefault(); });

  // Form → CRM (Google Apps Script). Lỗi thì mở Zalo.
  var CRM_URL = 'https://script.google.com/macros/s/AKfycbzJxDXzFGBt0fZi-18p5ZIYFtMJtRSSidJWFyIL0AHC1RezxptJ2ZbAxfgFb_DColkX/exec';
  var form = document.getElementById('contact-form');
  var msg = form.querySelector('.form__msg');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var name = form.elements.name.value.trim();
    var phone = form.elements.phone.value.replace(/[\s.]/g, '');
    if (!name || !/^0\d{9,10}$/.test(phone)) {
      msg.className = 'form__msg is-err';
      msg.textContent = 'Vui lòng nhập họ tên và số điện thoại đúng (10 số).';
      return;
    }
    var btn = form.querySelector('[type=submit]');
    btn.disabled = true;
    msg.className = 'form__msg';
    msg.textContent = 'Đang gửi...';
    fetch(CRM_URL, {
      method: 'POST', mode: 'no-cors', headers: { 'Content-Type': 'text/plain;charset=utf-8' },
      body: JSON.stringify({ name: name, phone: phone, service: form.elements.service.value,
        source: location.hostname || 'www.dichvuthetindungdanang.com', website: form.elements.website.value })
    }).then(function () {
      msg.className = 'form__msg is-ok';
      msg.textContent = 'Đã nhận! Chúng tôi sẽ gọi hoặc nhắn Zalo cho bạn trong ít phút.';
      form.reset();
    }).catch(function () {
      msg.className = 'form__msg is-err';
      msg.textContent = 'Chưa gửi được. Vui lòng gọi hoặc nhắn Zalo 0909 669 325.';
    }).then(function () { btn.disabled = false; });
  });

  // Khách bấm Zalo / Gọi → ghi vào CRM (mục Liên hệ từ web), không cần để lại số.
  var lastPing = {};
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href^="tel:"], a[href*="zalo.me"]');
    if (!a || !CRM_URL) return;
    var loai = a.href.indexOf('tel:') === 0 ? 'goi' : 'zalo';
    var now = Date.now();
    if (lastPing[loai] && now - lastPing[loai] < 60000) return; // 1 lần/phút mỗi loại
    lastPing[loai] = now;
    var where = a.closest('header, .hero, .fab, footer, section');
    var key = where ? (where.id || where.className.split(' ')[0]) : '';
    var place = { top: 'đầu trang', header: 'đầu trang', hero: 'màn đầu', fab: 'nút nổi bên cạnh', 'lien-he': 'phần liên hệ', footer: 'chân trang' }[key] || key;
    var body = JSON.stringify({ loai: loai, source: location.hostname || 'www.dichvuthetindungdanang.com',
      service: 'Nút ' + (loai === 'goi' ? 'Gọi' : 'Zalo') + (place ? ' – ' + place : '') });
    try {
      if (!(navigator.sendBeacon && navigator.sendBeacon(CRM_URL, new Blob([body], { type: 'text/plain;charset=utf-8' })))) {
        fetch(CRM_URL, { method: 'POST', mode: 'no-cors', keepalive: true, headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: body });
      }
    } catch (err) {}
  }, true);
})();
