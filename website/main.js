(function () {
  // Menu trên điện thoại
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  toggle.addEventListener('click', function () {
    var open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    toggle.setAttribute('aria-label', open ? 'Mở menu' : 'Đóng menu');
    nav.classList.toggle('open', !open);
  });
  nav.addEventListener('click', function (e) {
    if (e.target.closest('a')) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('open');
    }
  });

  // Lọc tin theo loại hình
  var tabs = document.querySelectorAll('.filter-tabs [data-filter]');
  var cards = document.querySelectorAll('#listing-grid .card');
  function applyFilter(type) {
    tabs.forEach(function (t) { t.setAttribute('aria-pressed', String(t.dataset.filter === type)); });
    cards.forEach(function (c) { c.hidden = type !== 'all' && c.dataset.type !== type; });
  }
  tabs.forEach(function (t) {
    t.addEventListener('click', function () { applyFilter(t.dataset.filter); });
  });

  // Ô tìm kiếm ở hero: lọc theo loại hình rồi cuộn xuống danh sách
  document.querySelector('.search-box').addEventListener('submit', function (e) {
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
    var phone = form.elements.phone.value.replace(/\s+/g, '');
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
