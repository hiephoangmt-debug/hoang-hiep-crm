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

  // Contact form: no backend, so hand the request off to Zalo / SMS with a prefilled message.
  var form = document.getElementById('contact-form');
  var msg = form.querySelector('.form__msg');
  var HOTLINE = '0909669325';

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var name = form.name.value.trim();
    var phone = form.phone.value.replace(/\s+/g, '');
    if (!name || !/^0\d{9}$/.test(phone)) {
      msg.className = 'form__msg is-err';
      msg.textContent = 'Vui lòng nhập họ tên và số điện thoại hợp lệ (10 số).';
      return;
    }
    var text = 'Xin chào, tôi là ' + name + ' (' + phone + '). Cần hỗ trợ: ' +
      form.service.value + (form.note.value.trim() ? '. Ghi chú: ' + form.note.value.trim() : '');

    msg.className = 'form__msg is-ok';
    msg.textContent = 'Cảm ơn bạn! Đang mở tin nhắn để gửi yêu cầu tới ' + HOTLINE + '...';

    var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    var sep = /iPhone|iPad|iPod/i.test(navigator.userAgent) ? '&' : '?';
    window.location.href = isMobile
      ? 'sms:' + HOTLINE + sep + 'body=' + encodeURIComponent(text)
      : 'https://zalo.me/' + HOTLINE;
    form.reset();
  });
})();
