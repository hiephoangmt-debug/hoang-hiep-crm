(function () {
  // Mobile menu
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('nav');
  toggle.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', open);
  });
  nav.addEventListener('click', function (e) {
    if (e.target.tagName === 'A') {
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    }
  });

  document.getElementById('year').textContent = new Date().getFullYear();

  // Contact form → CRM (Google Apps Script). Until CRM_URL is filled in, fall back to SMS / Zalo.
  var CRM_URL = 'https://script.google.com/macros/s/AKfycbzJxDXzFGBt0fZi-18p5ZIYFtMJtRSSidJWFyIL0AHC1RezxptJ2ZbAxfgFb_DColkX/exec';
  var form = document.getElementById('contact-form');
  var msg = form.querySelector('.form__msg');
  var HOTLINE = '0909669325';

  function openChat(text) {
    var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    var sep = /iPhone|iPad|iPod/i.test(navigator.userAgent) ? '&' : '?';
    window.location.href = isMobile
      ? 'sms:' + HOTLINE + sep + 'body=' + encodeURIComponent(text)
      : 'https://zalo.me/' + HOTLINE;
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var name = form.name.value.trim();
    var phone = form.phone.value.replace(/\s+/g, '');
    if (!name || !/^0\d{9}$/.test(phone)) {
      msg.className = 'form__msg is-err';
      msg.textContent = 'Vui lòng nhập họ tên và số điện thoại hợp lệ (10 số).';
      return;
    }
    var note = form.note.value.trim();
    var text = 'Xin chào, tôi là ' + name + ' (' + phone + '). Cần hỗ trợ: ' +
      form.service.value + (note ? '. Ghi chú: ' + note : '');

    if (!CRM_URL) {
      msg.className = 'form__msg is-ok';
      msg.textContent = 'Cảm ơn bạn! Đang mở tin nhắn để gửi yêu cầu tới ' + HOTLINE + '...';
      openChat(text);
      form.reset();
      return;
    }

    var btn = form.querySelector('[type=submit]');
    btn.disabled = true;
    msg.className = 'form__msg';
    msg.textContent = 'Đang gửi...';
    // text/plain + no-cors: Apps Script không trả CORS header, gửi "một chiều" là đủ.
    fetch(CRM_URL, {
      method: 'POST',
      mode: 'no-cors',
      headers: { 'Content-Type': 'text/plain;charset=utf-8' },
      body: JSON.stringify({
        name: name, phone: phone, service: form.service.value, note: note,
        source: location.hostname || 'www.the-tin-dung-da-nang.com', website: form.website ? form.website.value : ''
      })
    }).then(function () {
      msg.className = 'form__msg is-ok';
      msg.textContent = 'Đã nhận yêu cầu! Nhân viên sẽ gọi lại cho bạn trong ít phút.';
      form.reset();
    }).catch(function () {
      msg.className = 'form__msg is-err';
      msg.textContent = 'Chưa gửi được, đang mở Zalo/SMS để bạn nhắn trực tiếp...';
      openChat(text);
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
    var where = a.closest('header, .hero, .mobile-bar, .float, footer, section');
    var key = where ? (where.id || where.className.split(' ')[0]) : '';
    var place = { top: 'đầu trang', header: 'đầu trang', hero: 'màn đầu', 'mobile-bar': 'thanh dưới', float: 'nút nổi', 'lien-he': 'phần liên hệ', footer: 'chân trang' }[key] || key;
    var body = JSON.stringify({ loai: loai, source: location.hostname || 'www.the-tin-dung-da-nang.com',
      service: 'Nút ' + (loai === 'goi' ? 'Gọi' : 'Zalo') + (place ? ' – ' + place : '') });
    try {
      if (!(navigator.sendBeacon && navigator.sendBeacon(CRM_URL, new Blob([body], { type: 'text/plain;charset=utf-8' })))) {
        fetch(CRM_URL, { method: 'POST', mode: 'no-cors', keepalive: true, headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: body });
      }
    } catch (err) {}
  }, true);
})();
