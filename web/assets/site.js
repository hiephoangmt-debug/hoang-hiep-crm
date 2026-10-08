/* Đặt URL nhận lead (ví dụ API của CRM hoặc Google Apps Script). Để trống thì form chỉ hiển thị cảm ơn. */
const LEAD_ENDPOINT = "";

(function () {
  // Mục lục: tô sáng mục đang đọc
  const links = [...document.querySelectorAll('.toc a')];
  const map = new Map(links.map(a => [a.getAttribute('href').slice(1), a]));
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          links.forEach(l => l.classList.remove('active'));
          const a = map.get(e.target.id);
          if (a) a.classList.add('active');
        }
      });
    }, { rootMargin: '-80px 0px -70% 0px' });
    map.forEach((_, id) => { const el = document.getElementById(id); if (el) io.observe(el); });
  }

  // Form đăng ký
  const form = document.getElementById('lead-form');
  form.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    if (form.website.value) return; // honeypot chống spam
    const phone = form.phone.value.replace(/[\s.]/g, '');
    if (!form.name.value.trim()) { form.name.focus(); return; }
    if (!/^(\+84|0)\d{9,10}$/.test(phone)) {
      form.phone.setCustomValidity('Số điện thoại chưa đúng định dạng');
      form.phone.reportValidity();
      form.phone.setCustomValidity('');
      return;
    }
    const data = {
      name: form.name.value.trim(),
      phone,
      need: form.need.value,
      unit_type: form.unit_type.value,
      source: 'seo' + (location.pathname.replace(/\//g, '-').replace(/-$/, '') || '-da-nang-downtown'),
      page: location.href,
      submitted_at: new Date().toISOString()
    };
    const btn = form.querySelector('button');
    btn.disabled = true;
    try {
      if (LEAD_ENDPOINT) {
        await fetch(LEAD_ENDPOINT, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) });
      }
      form.querySelector('.form-ok').style.display = 'block';
      form.reset();
      if (window.dataLayer) window.dataLayer.push({ event: 'generate_lead', form: location.pathname });
    } catch (err) {
      alert('Gửi chưa thành công, vui lòng gọi hotline 0900 000 000.');
    } finally {
      btn.disabled = false;
    }
  });
})();
