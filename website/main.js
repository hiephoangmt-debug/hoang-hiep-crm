(function () {
  var header = document.getElementById('site-header');
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');

  // Header đổi nền khi cuộn khỏi hero
  function onScroll() { header.classList.toggle('scrolled', window.scrollY > 40); }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // Menu trên điện thoại
  function setMenu(open) {
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
    nav.classList.toggle('open', open);
    header.classList.toggle('menu-open', open);
  }
  toggle.addEventListener('click', function () {
    setMenu(toggle.getAttribute('aria-expanded') !== 'true');
  });
  nav.addEventListener('click', function (e) {
    if (e.target.closest('a')) setMenu(false);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setMenu(false);
  });

  // Đánh dấu mục menu đang xem
  var links = nav.querySelectorAll('a[href^="#"]:not(.btn)');
  if ('IntersectionObserver' in window) {
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        links.forEach(function (a) { a.classList.toggle('active', a.getAttribute('href') === '#' + en.target.id); });
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    links.forEach(function (a) {
      var s = document.querySelector(a.getAttribute('href'));
      if (s) spy.observe(s);
    });
  }

  // Hiệu ứng xuất hiện khi cuộn
  var reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px' });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('in'); });
  }

  // Lọc tin theo loại hình
  var tabs = document.querySelectorAll('.filter-tabs [data-filter]');
  var cards = document.querySelectorAll('#listing-grid .card');
  function applyFilter(type) {
    tabs.forEach(function (t) { t.setAttribute('aria-pressed', String(t.dataset.filter === type)); });
    cards.forEach(function (c) {
      c.hidden = type !== 'all' && c.dataset.type !== type;
      c.classList.add('in');
    });
  }
  tabs.forEach(function (t) {
    t.addEventListener('click', function () { applyFilter(t.dataset.filter); });
  });

  // Ô tìm kiếm: lọc theo loại hình rồi cuộn xuống danh sách
  document.getElementById('search-box').addEventListener('submit', function (e) {
    e.preventDefault();
    applyFilter(document.getElementById('s-type').value || 'all');
    document.getElementById('bat-dong-san').scrollIntoView();
  });

  // Form tư vấn: kiểm tra dữ liệu ở trình duyệt.
  // Khi có endpoint thật (CRM / Google Form / LadiPage), gửi dữ liệu bằng fetch tại đây.
  var form = document.getElementById('lead-form');
  var status = form.querySelector('.form-status');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var name = form.elements.name.value.trim();
    var phone = form.elements.phone.value.replace(/[\s.]+/g, '');
    if (!name || !/^0\d{9}$/.test(phone)) {
      status.className = 'form-status err';
      status.textContent = 'Vui lòng nhập họ tên và số điện thoại hợp lệ (10 số, bắt đầu bằng 0).';
      return;
    }
    status.className = 'form-status ok';
    status.textContent = 'Cảm ơn ' + name + '! Chúng tôi sẽ liên hệ lại sớm nhất.';
    form.reset();
  });

  document.getElementById('year').textContent = new Date().getFullYear();
})();
