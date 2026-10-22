/* ===== Cấu hình ===== */
const CONFIG = {
  // URL Web App của Google Apps Script (xem integrations/google-apps-script/Code.gs). Để trống thì lead chỉ hiện lời cảm ơn.
  LEAD_ENDPOINT: "",
  // Link thư mục Google Drive chứa bảng giá, mặt bằng, brochure (chia sẻ "Bất kỳ ai có đường liên kết"). Để trống thì gửi qua Zalo.
  DOCS_URL: "",
  HOTLINE: "0904 567 009",
  PHONE_E164: "+84904567009",
  ZALO_URL: "https://zalo.me/0904567009",
  EMAIL: "hiephoangmt@gmail.com"
};

(function () {
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const store = {
    get(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { sessionStorage.setItem(k, v); } catch (e) {} }
  };
  const PHONE_RE = /^(\+84|0)\d{9,10}$/;
  const cleanPhone = (v) => (v || '').replace(/[\s.\-()]/g, '');
  const pageSource = 'seo' + (location.pathname.replace(/\//g, '-').replace(/-$/, '') || '-da-nang-downtown');
  const esc = (s) => String(s).replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

  /* ===== Gửi lead ===== */
  async function submitLead(data) {
    const payload = Object.assign({
      need: '', unit_type: '', channel: '', note: '',
      source: pageSource, page: location.href, submitted_at: new Date().toISOString()
    }, data);
    if (window.dataLayer) window.dataLayer.push({ event: 'generate_lead', form: payload.via || 'form', page: location.pathname });
    if (typeof window.fbq === 'function') window.fbq('track', 'Lead');
    if (!CONFIG.LEAD_ENDPOINT) return true;
    // text/plain tránh preflight CORS với Google Apps Script
    await fetch(CONFIG.LEAD_ENDPOINT, { method: 'POST', mode: 'no-cors', headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: JSON.stringify(payload) });
    return true;
  }

  function afterLeadActions() {
    const docs = CONFIG.DOCS_URL
      ? `<a class="btn btn-accent" href="${CONFIG.DOCS_URL}" target="_blank" rel="noopener">Mở tài liệu trên Google Drive</a>`
      : '';
    return `<div class="after-lead">${docs}<a class="btn btn-zalo" href="${CONFIG.ZALO_URL}" target="_blank" rel="noopener">Nhắn Zalo ${CONFIG.HOTLINE}</a></div>`;
  }

  /* ===== Mục lục: tô sáng mục đang đọc ===== */
  const tocLinks = $$('.toc a');
  const tocMap = new Map(tocLinks.map(a => [a.getAttribute('href').slice(1), a]));
  if ('IntersectionObserver' in window && tocLinks.length) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        tocLinks.forEach(l => l.classList.remove('active'));
        const a = tocMap.get(e.target.id);
        if (a) a.classList.add('active');
      });
    }, { rootMargin: '-80px 0px -70% 0px' });
    tocMap.forEach((_, id) => { const el = document.getElementById(id); if (el) io.observe(el); });
  }

  /* ===== Form chính và form popup ===== */
  function bindForm(form) {
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      if (form.website && form.website.value) return; // honeypot
      const name = form.name.value.trim();
      const phone = cleanPhone(form.phone.value);
      if (!name) { form.name.focus(); return; }
      if (!PHONE_RE.test(phone)) {
        form.phone.setCustomValidity('Số điện thoại chưa đúng (ví dụ 0904567009)');
        form.phone.reportValidity();
        form.phone.setCustomValidity('');
        return;
      }
      const btn = form.querySelector('button[type=submit]');
      const ok = form.querySelector('.form-ok');
      btn.disabled = true;
      try {
        await submitLead({
          name, phone,
          need: form.need ? form.need.value : '',
          unit_type: form.unit_type ? form.unit_type.value : '',
          channel: form.channel ? form.channel.value : '',
          via: form.dataset.via || 'form'
        });
        ok.innerHTML = `<strong>Đã nhận thông tin của ${esc(name)}.</strong> Chuyên viên sẽ gửi tài liệu qua ${esc(form.channel ? form.channel.value : 'Zalo')} trong ít phút.` + afterLeadActions();
        ok.style.display = 'block';
        form.reset();
      } catch (err) {
        ok.innerHTML = `Chưa gửi được. Vui lòng gọi hoặc nhắn Zalo <strong>${CONFIG.HOTLINE}</strong>.` + afterLeadActions();
        ok.style.display = 'block';
      } finally {
        btn.disabled = false;
      }
    });
  }
  $$('form.lead-form').forEach(bindForm);

  /* ===== Popup tải tài liệu ===== */
  const modal = document.createElement('div');
  modal.className = 'modal';
  modal.hidden = true;
  modal.innerHTML = `
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <button class="modal-x" type="button" aria-label="Đóng">×</button>
      <span class="modal-tag">Miễn phí · Gửi ngay qua Zalo</span>
      <h2 id="modal-title">Nhận bộ tài liệu dự án</h2>
      <ul class="modal-list">
        <li>Bảng giá và chính sách bán hàng đợt mới nhất</li>
        <li>Mặt bằng tầng, layout từng loại căn</li>
        <li>Brochure và bảng tính dòng tiền cho thuê</li>
      </ul>
      <form class="lead-form" data-via="popup" novalidate>
        <label for="m-name">Họ và tên *</label>
        <input id="m-name" name="name" autocomplete="name" required>
        <label for="m-phone">Số điện thoại / Zalo *</label>
        <input id="m-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required>
        <label for="m-channel">Nhận tài liệu qua</label>
        <select id="m-channel" name="channel"><option>Zalo</option><option>Gọi điện</option><option>Email</option></select>
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hp">
        <button class="btn btn-accent" type="submit">Gửi tài liệu cho tôi</button>
        <p class="form-note">Bảo mật thông tin. Không spam.</p>
        <div class="form-ok" role="status" aria-live="polite"></div>
      </form>
    </div>`;
  document.body.appendChild(modal);
  bindForm($('form', modal));
  let lastFocus = null;
  function openModal() {
    lastFocus = document.activeElement;
    modal.hidden = false;
    document.body.classList.add('no-scroll');
    store.set('ddt_modal_seen', '1');
    setTimeout(() => $('#m-name').focus(), 50);
  }
  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove('no-scroll');
    if (lastFocus) lastFocus.focus();
  }
  $('.modal-x', modal).addEventListener('click', closeModal);
  modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) closeModal(); });
  document.addEventListener('click', e => {
    const t = e.target.closest('[data-open="docs"]');
    if (t) { e.preventDefault(); openModal(); }
  });
  // Exit intent (desktop), tối đa 1 lần mỗi phiên
  document.addEventListener('mouseout', e => {
    if (e.clientY <= 0 && !e.relatedTarget && !store.get('ddt_modal_seen') && window.innerWidth > 960) openModal();
  });

  /* ===== Nút nổi: Zalo, gọi, chat ===== */
  const fab = document.createElement('div');
  fab.className = 'fab';
  fab.innerHTML = `
    <a class="fab-btn fab-zalo" href="${CONFIG.ZALO_URL}" target="_blank" rel="noopener" aria-label="Nhắn Zalo ${CONFIG.HOTLINE}"><span>Zalo</span></a>
    <a class="fab-btn fab-call" href="tel:${CONFIG.PHONE_E164}" aria-label="Gọi ${CONFIG.HOTLINE}">
      <svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2a1 1 0 011-.25 11.4 11.4 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.6a1 1 0 01-.25 1z"/></svg>
    </a>
    <button class="fab-btn fab-chat" type="button" aria-label="Chat tư vấn" aria-expanded="false">
      <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M4 4h16a2 2 0 012 2v10a2 2 0 01-2 2H8l-4 4V6a2 2 0 012-2z"/></svg>
      <i class="fab-dot" aria-hidden="true"></i>
    </button>
    <div class="fab-teaser" hidden>Anh/chị cần <b>bảng giá</b> hoặc <b>mặt bằng</b>? Em gửi ngay ạ!</div>`;
  document.body.appendChild(fab);

  /* ===== Chat tự động ===== */
  const KB = [
    { k: ['giá', 'gia', 'bao nhiêu', 'tiền', 'triệu', 'tỷ', 'bảng giá'], a: 'Hiện Sun Group <b>chưa công bố bảng giá chính thức</b>. Mức thị trường đang lưu hành khoảng 60–100 triệu/m² cho Da Nang Downtown, riêng Sun Galaxy Complex các nguồn ghi từ 60 đến khoảng 148 triệu/m². Em gửi anh/chị bảng giá ngay khi có đợt mới nhé?', lead: true },
    { k: ['vị trí', 'vi tri', 'ở đâu', 'địa chỉ', 'chỗ nào'], a: 'Dự án nằm trên đất <b>Công viên Châu Á cũ</b>, phường Hòa Cường, bờ Đông sông Hàn, giữa cầu Trần Thị Lý và cầu Tiên Sơn. Cách biển Mỹ Khê khoảng 2–3 km, sân bay khoảng 10–15 phút.' },
    { k: ['galaxy', 'accor', 'sofitel', 'swiss', 'mgallery', 'moon gate', 'pháo hoa'], a: '<b>Sun Galaxy Complex</b> là phân khu đầu tiên, khởi công 25/7/2026, vốn gần 10.750 tỷ. Tháp 47 tầng (~183m), Accor vận hành Sofitel, Swissôtel, MGallery. Có khán đài pháo hoa DIFF gần 20.000 chỗ. Dự án đang <b>nhận giữ chỗ</b> khoảng 50 triệu/căn.', lead: true },
    { k: ['vay', 'lãi', 'ngân hàng', 'trả góp', 'thanh toán'], a: 'Chính sách đang được giới thiệu: hỗ trợ vay tới 70–80%, <b>ân hạn gốc và hỗ trợ lãi 0% tối đa 30 tháng</b>. Anh/chị có thể thử mục <a href="/#tinh-vay">Tính khoản vay</a> trên trang. Chính sách chính xác theo từng đợt, em gửi bản mới nhất nhé?', lead: true },
    { k: ['pháp lý', 'phap ly', 'sổ', 'sở hữu', 'người nước ngoài', 'quy hoạch'], a: 'Quy hoạch 1/500 theo QĐ 392/QĐ-UBND ngày 15/8/2025. Căn hộ ở: người Việt sở hữu lâu dài, người nước ngoài tối đa 50 năm. Căn hộ lưu trú có quy định riêng. Trước khi đặt cọc nên xem văn bản đủ điều kiện mở bán và bảo lãnh ngân hàng.' },
    { k: ['bàn giao', 'ban giao', 'tiến độ', 'khi nào', 'thi công'], a: 'Khởi công tổng thể 19/8/2025, Sun Galaxy Complex khởi công 25/7/2026. Mốc bàn giao căn hộ đang được giới thiệu là <b>quý 4/2028</b>. Tháp 69 tầng dự kiến hoàn thành khoảng 2030.' },
    { k: ['tháp', 'thap', '408', '69 tầng', 'cao nhất'], a: 'Tháp biểu tượng <b>69 tầng, cao 408m</b>, cao thứ 2 Việt Nam sau Landmark 81, gồm khách sạn, văn phòng, căn hộ, TTTM và đài quan sát.' },
    { k: ['loại căn', 'studio', 'phòng ngủ', '1pn', '2pn', '3pn', 'penthouse', 'shophouse', 'diện tích'], a: 'Sản phẩm dự kiến gồm Studio, 1PN+, 2PN, 3PN, Sky Villa/Penthouse và shophouse ven sông. Mặt bằng chi tiết công bố theo bảng hàng, em gửi anh/chị layout từng loại nhé?', lead: true },
    { k: ['tiện ích', 'tien ich', 'hồ bơi', 'nhà hát', 'opera'], a: 'Toàn khu có nhà hát opera 4.000 chỗ, bảo tàng, phố thương mại ven sông, khán đài pháo hoa. Nội khu dự kiến có hồ bơi vô cực, gym, spa, kid club.' }
  ];
  const QUICK = ['Bảng giá', 'Vị trí', 'Sun Galaxy Complex', 'Chính sách vay', 'Pháp lý', 'Gặp chuyên viên'];

  const chat = document.createElement('section');
  chat.className = 'chat';
  chat.hidden = true;
  chat.setAttribute('aria-label', 'Chat tư vấn tự động');
  chat.innerHTML = `
    <header class="chat-head">
      <div class="chat-avatar" aria-hidden="true">HH</div>
      <div><b>Tư vấn Da Nang Downtown</b><small><i class="online"></i> Trả lời tự động 24/7</small></div>
      <button class="chat-x" type="button" aria-label="Đóng chat">×</button>
    </header>
    <div class="chat-body" aria-live="polite"></div>
    <div class="chat-quick"></div>
    <form class="chat-input" autocomplete="off">
      <label for="chat-text" class="sr-only">Nhập tin nhắn</label>
      <input id="chat-text" placeholder="Nhập câu hỏi hoặc số điện thoại…" maxlength="300">
      <button type="submit" aria-label="Gửi"><svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 20l18-8L3 4v6l12 2-12 2z"/></svg></button>
    </form>`;
  document.body.appendChild(chat);
  const body = $('.chat-body', chat);
  const quick = $('.chat-quick', chat);
  const input = $('#chat-text', chat);
  const chatBtn = $('.fab-chat', fab);
  const teaser = $('.fab-teaser', fab);
  const lead = { step: null, name: '', phone: '', channel: '', log: [] };
  let started = false;

  function say(html, who = 'bot') {
    const m = document.createElement('div');
    m.className = 'msg ' + who;
    m.innerHTML = html;
    body.appendChild(m);
    body.scrollTop = body.scrollHeight;
    lead.log.push((who === 'bot' ? 'Bot: ' : 'Khách: ') + m.textContent);
  }
  function botSay(html, delay = 450) {
    const typing = document.createElement('div');
    typing.className = 'msg bot typing';
    typing.innerHTML = '<span></span><span></span><span></span>';
    body.appendChild(typing);
    body.scrollTop = body.scrollHeight;
    return new Promise(r => setTimeout(() => { typing.remove(); say(html); r(); }, delay));
  }
  function setQuick(items) {
    quick.innerHTML = '';
    items.forEach(t => {
      const b = document.createElement('button');
      b.type = 'button';
      b.textContent = t;
      b.addEventListener('click', () => handle(t));
      quick.appendChild(b);
    });
  }
  async function askLead() {
    lead.step = 'name';
    await botSay('Anh/chị cho em xin <b>tên</b> để chuyên viên tiện xưng hô ạ?');
    setQuick([]);
  }
  async function finishLead() {
    lead.step = 'done';
    try {
      await submitLead({ name: lead.name, phone: lead.phone, channel: lead.channel, via: 'chat', note: lead.log.slice(-12).join(' | ') });
    } catch (e) {}
    await botSay(`Cảm ơn <b>${esc(lead.name)}</b>! Em đã ghi nhận số <b>${esc(lead.phone)}</b>. Chuyên viên sẽ gửi bảng giá và mặt bằng qua ${esc(lead.channel)} trong ít phút.` + afterLeadActions(), 700);
    setQuick(['Vị trí', 'Sun Galaxy Complex', 'Chính sách vay', 'Pháp lý']);
  }

  async function handle(text) {
    text = text.trim();
    if (!text) return;
    say(esc(text), 'me');
    const low = text.toLowerCase();
    const phone = cleanPhone((text.match(/(\+?84|0)[\d\s.\-]{8,13}/) || [''])[0]);

    if (lead.step === 'name') {
      lead.name = text.slice(0, 60);
      lead.step = 'phone';
      await botSay(`Dạ chào ${esc(lead.name)}! Anh/chị cho em xin <b>số điện thoại hoặc Zalo</b> để gửi tài liệu ạ.`);
      return;
    }
    if (lead.step === 'phone') {
      if (!PHONE_RE.test(phone)) { await botSay('Số điện thoại chưa đúng, anh/chị nhập lại giúp em (ví dụ 0904567009) ạ.'); return; }
      lead.phone = phone;
      lead.step = 'channel';
      await botSay('Anh/chị muốn nhận tài liệu qua kênh nào ạ?');
      setQuick(['Zalo', 'Gọi điện', 'Email']);
      return;
    }
    if (lead.step === 'channel') {
      lead.channel = ['Zalo', 'Gọi điện', 'Email'].find(c => low.includes(c.toLowerCase())) || 'Zalo';
      await finishLead();
      return;
    }
    if (PHONE_RE.test(phone) && lead.step !== 'done') {
      lead.phone = phone;
      lead.name = lead.name || 'Khách chat';
      lead.channel = 'Zalo';
      await finishLead();
      return;
    }
    if (/chuyên viên|tư vấn viên|gặp người|liên hệ|gọi lại|nhận bảng giá|gửi bảng giá|mặt bằng/.test(low) && lead.step !== 'done') {
      await askLead();
      return;
    }
    const hit = KB.find(item => item.k.some(k => low.includes(k)));
    if (hit) {
      await botSay(hit.a);
      if (hit.lead && lead.step !== 'done') {
        setQuick(['Nhận bảng giá', 'Gặp chuyên viên', 'Hỏi câu khác']);
      } else {
        setQuick(QUICK);
      }
      return;
    }
    if (/hỏi câu khác|câu khác/.test(low)) { await botSay('Anh/chị muốn tìm hiểu thêm phần nào ạ?'); setQuick(QUICK); return; }
    await botSay(`Câu này em xin phép chuyển chuyên viên trả lời chính xác. Anh/chị để lại số điện thoại, hoặc nhắn Zalo <b>${CONFIG.HOTLINE}</b> ạ.`);
    if (lead.step !== 'done') setQuick(['Gặp chuyên viên', 'Bảng giá', 'Vị trí']);
  }

  async function openChat() {
    chat.hidden = false;
    teaser.hidden = true;
    chatBtn.setAttribute('aria-expanded', 'true');
    fab.classList.add('chat-open');
    chatBtn.classList.add('seen');
    store.set('ddt_chat_seen', '1');
    if (!started) {
      started = true;
      await botSay('Xin chào anh/chị 👋 Em là trợ lý tư vấn dự án <b>Da Nang Downtown</b> và <b>Sun Galaxy Complex</b>.', 300);
      await botSay('Anh/chị quan tâm thông tin nào ạ? Em gửi <b>bảng giá, mặt bằng, chính sách</b> miễn phí qua Zalo.');
      setQuick(QUICK);
    }
    setTimeout(() => input.focus(), 50);
  }
  function closeChat() {
    chat.hidden = true;
    fab.classList.remove('chat-open');
    chatBtn.setAttribute('aria-expanded', 'false');
    chatBtn.focus();
  }
  chatBtn.addEventListener('click', () => (chat.hidden ? openChat() : closeChat()));
  $('.chat-x', chat).addEventListener('click', closeChat);
  teaser.addEventListener('click', openChat);
  $('.chat-input', chat).addEventListener('submit', e => { e.preventDefault(); const v = input.value; input.value = ''; handle(v); });
  document.addEventListener('click', e => { if (e.target.closest('[data-open="chat"]')) { e.preventDefault(); openChat(); } });
  // Lời mời chat sau 20 giây, một lần mỗi phiên
  if (!store.get('ddt_chat_seen')) setTimeout(() => { if (chat.hidden && modal.hidden) teaser.hidden = false; }, 20000);

  /* ===== Tính khoản vay ===== */
  const calc = $('#loan-calc');
  if (calc) {
    const fmt = (n) => new Intl.NumberFormat('vi-VN', { maximumFractionDigits: 0 }).format(Math.round(n));
    const money = (n) => n >= 1e9 ? (n / 1e9).toLocaleString('vi-VN', { maximumFractionDigits: 2 }) + ' tỷ' : fmt(n / 1e6) + ' triệu';
    const run = () => {
      const price = parseFloat(calc.price.value) * 1e9 || 0;
      const ratio = parseFloat(calc.ratio.value) / 100;
      const grace = parseInt(calc.grace.value, 10);
      const rate = parseFloat(calc.rate.value) / 100 / 12;
      const years = parseInt(calc.years.value, 10);
      const loan = price * ratio;
      const n = Math.max(years * 12 - grace, 1);
      const monthly = rate > 0 ? loan * rate / (1 - Math.pow(1 + rate, -n)) : loan / n;
      $('#out-ratio').textContent = calc.ratio.value + '%';
      $('#out-grace').textContent = grace + ' tháng';
      $('#r-own').textContent = money(price - loan);
      $('#r-loan').textContent = money(loan);
      $('#r-grace').textContent = grace > 0 ? `0 đ/tháng trong ${grace} tháng đầu` : 'Không có ân hạn';
      $('#r-monthly').textContent = monthly > 0 ? (monthly / 1e6).toLocaleString('vi-VN', { maximumFractionDigits: 1 }) + ' triệu/tháng' : '–';
    };
    calc.addEventListener('input', run);
    run();
  }
})();
