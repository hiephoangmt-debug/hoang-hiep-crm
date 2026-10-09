// Tạo ảnh bán hàng theo mẫu căn hộ (phối cảnh + thẻ giá + layout + chính sách + ảnh thực tế)
// Dùng chung $, api, toast, safeStorage từ app.js
(() => {
  const W = 1080;
  const H = 1500;
  const STORAGE_KEY = 'crm.template';
  const SANS = '"Segoe UI", Roboto, Arial, sans-serif';
  const SERIF = 'Georgia, "Times New Roman", serif';
  const C = {
    brown: '#6e4026',
    brownText: '#3a2a1e',
    gold: '#c49a5f',
    goldDark: '#8a5a2e',
    muted: '#b9a58f',
    cream1: '#fbf6ec',
    cream2: '#f1e2c4',
  };

  const DEFAULTS = {
    units: 'F2-19-08 | F2 | 1BR+ | 19 | 53 | 3286876036 | 3188269754 | 2805677384',
    photoLabel1: '',
    photoLabel2: 'VIEW THỰC TẾ',
    photoLabel3: '',
    priceLabel1: 'Giá vay:',
    priceLabel2: 'Giá TTTĐ:',
    priceLabel3: 'Giá TTS:',
    policyTitle: 'SUN EARLY KEY',
    p1Top: 'TỔNG CHIẾT KHẤU', p1Value: '19%', p1Sub: '',
    p2Top: 'THANH TOÁN', p2Value: '70%', p2Sub: 'NHẬN NHÀ',
    p3Top: 'HTLS', p3Value: '24', p3Sub: 'THÁNG',
    p4Top: 'TT TIẾN ĐỘ', p4Value: '45', p4Sub: 'THÁNG',
    website: 'www.scdgroup.vn',
    project: 'Four S Tower',
    caption:
      '🏢 {du_an} – Căn {ma_can} (Tòa {toa})\n' +
      '🛏 {loai} | Tầng {tang} | {dien_tich}m²\n' +
      '💰 {nhan1} {gia1}\n💰 {nhan2} {gia2}\n💰 {nhan3} {gia3}\n' +
      '🎁 {chinh_sach}\n📞 Inbox ngay để nhận bảng giá & giữ căn!',
    markers: {},
  };

  const form = $('#tpl-form');
  const canvas = $('#tpl-canvas');
  const ctx = canvas.getContext('2d');
  const images = {}; // hero, logo, unitLayout, floorPlan, photo1..3 (chỉ trong phiên)
  let config = { ...DEFAULTS, ...(safeStorage(() => JSON.parse(localStorage.getItem(STORAGE_KEY))) || {}) };
  let current = 0;
  let floorRect = null; // vùng ảnh layout tầng trên canvas, để đặt dấu căn

  // ---- Form <-> config ----
  for (const el of form.elements) {
    if (el.name && config[el.name] !== undefined) el.value = config[el.name];
  }

  function readForm() {
    for (const el of form.elements) {
      if (el.name) config[el.name] = el.value;
    }
    safeStorage(() => localStorage.setItem(STORAGE_KEY, JSON.stringify(config)));
  }

  form.addEventListener('input', () => { readForm(); render(); });

  form.querySelectorAll('input[type=file][data-img]').forEach((input) =>
    input.addEventListener('change', async () => {
      const file = input.files[0];
      if (!file) return;
      const img = new Image();
      img.src = URL.createObjectURL(file);
      await img.decode().catch(() => toast('Không đọc được ảnh'));
      images[input.dataset.img] = img;
      input.closest('label').classList.add('has');
      render();
    })
  );

  // ---- Rổ hàng ----
  function parseUnits(text) {
    return text
      .split(/\r?\n/)
      .map((line) => line.trim())
      .filter(Boolean)
      .map((line) => line.split(line.includes('\t') ? '\t' : /[|;]/).map((c) => c.trim()))
      .filter((cols) => cols[0] && !/^m[ãa]\s*c[ăa]n/i.test(cols[0]))
      .map(([code, toa, loai, tang, dienTich, ...prices]) => {
        const parts = code.split('-');
        return {
          code,
          toa: toa || (parts.length >= 3 ? parts[0] : ''),
          loai: loai || '',
          tang: tang || (parts.length >= 3 ? parts[1] : ''),
          dienTich: (dienTich || '').replace(/m2|m²/i, '').trim(),
          so: parts[parts.length - 1],
          prices: prices.slice(0, 3).map(formatPrice),
        };
      });
  }

  function formatPrice(raw) {
    const v = String(raw || '').trim();
    if (!v) return '';
    if (/^[\d.,\s]+(vn[dđ])?$/i.test(v)) {
      const digits = v.replace(/\D/g, '');
      return `${digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.')} VNĐ`;
    }
    return v;
  }

  const units = () => parseUnits(config.units);

  function captionFor(u) {
    const policy = [1, 2, 3, 4]
      .map((i) => [config[`p${i}Top`], config[`p${i}Value`], config[`p${i}Sub`]].filter(Boolean).join(' '))
      .filter(Boolean)
      .join(' • ');
    const vars = {
      du_an: config.project, ma_can: u.code, toa: u.toa, loai: u.loai, tang: u.tang, dien_tich: u.dienTich,
      nhan1: config.priceLabel1, gia1: u.prices[0] || '',
      nhan2: config.priceLabel2, gia2: u.prices[1] || '',
      nhan3: config.priceLabel3, gia3: u.prices[2] || '',
      chinh_sach: [config.policyTitle, policy].filter(Boolean).join(': '),
    };
    return config.caption
      .replace(/\{(\w+)\}/g, (m, k) => (k in vars ? vars[k] : m))
      .split('\n')
      .filter((line) => !/:\s*$/.test(line.trim())) // bỏ dòng giá bị trống
      .join('\n');
  }

  // ---- Vẽ ----
  function fit(img, x, y, w, h, mode) {
    const r = mode === 'cover' ? Math.max(w / img.width, h / img.height) : Math.min(w / img.width, h / img.height);
    const dw = img.width * r;
    const dh = img.height * r;
    const dx = x + (w - dw) / 2;
    const dy = y + (h - dh) / 2;
    if (mode === 'cover') {
      c.save();
      c.beginPath();
      c.rect(x, y, w, h);
      c.clip();
      c.drawImage(img, dx, dy, dw, dh);
      c.restore();
    } else {
      c.drawImage(img, dx, dy, dw, dh);
    }
    return { x: dx, y: dy, w: dw, h: dh };
  }

  function text(str, x, y, { size = 20, font = SANS, weight = '', color = '#000', align = 'left', maxWidth } = {}) {
    if (!str) return;
    let s = size;
    c.font = `${weight} ${s}px ${font}`;
    while (maxWidth && c.measureText(str).width > maxWidth && s > 10) {
      s -= 1;
      c.font = `${weight} ${s}px ${font}`;
    }
    c.fillStyle = color;
    c.textAlign = align;
    c.fillText(str, x, y);
  }

  function placeholder(x, y, w, h, label) {
    c.fillStyle = '#e9e2d4';
    c.fillRect(x, y, w, h);
    text(label, x + w / 2, y + h / 2 + 8, { size: 24, color: '#a3927a', align: 'center', maxWidth: w - 20 });
  }

  function roundBox(x, y, w, h, r, fill) {
    c.beginPath();
    c.roundRect(x, y, w, h, r);
    c.fillStyle = fill;
    c.fill();
  }

  let c = ctx;

  function draw(target, u) {
    c = target;
    c.textBaseline = 'alphabetic';

    // Nền kem
    const bg = c.createLinearGradient(0, 0, 0, H);
    bg.addColorStop(0, C.cream1);
    bg.addColorStop(1, C.cream2);
    c.fillStyle = bg;
    c.fillRect(0, 0, W, H);

    // Phối cảnh
    if (images.hero) fit(images.hero, 0, 0, W, 590, 'cover');
    else placeholder(0, 0, W, 590, 'Ảnh phối cảnh (ảnh AI)');
    if (images.logo) fit(images.logo, 240, 20, 600, 90, 'contain');

    drawPriceCard(u);

    // Khu layout
    c.fillStyle = '#fff';
    c.fillRect(0, 590, W, 420);
    if (images.unitLayout) fit(images.unitLayout, 30, 615, 480, 370, 'contain');
    else placeholder(30, 615, 480, 370, 'Layout gợi ý');
    floorRect = images.floorPlan
      ? fit(images.floorPlan, 550, 605, 510, 385, 'contain')
      : (placeholder(550, 605, 510, 385, 'Layout tầng'), { x: 550, y: 605, w: 510, h: 385 });
    drawMarker(u);

    [[150, 'Layout gợi ý'], [670, 'Layout tầng']].forEach(([x, label]) => {
      c.beginPath();
      c.roundRect(x, 556, 220, 38, [10, 10, 0, 0]);
      c.fillStyle = C.brown;
      c.fill();
      text(label, x + 110, 584, { size: 24, color: '#fff', align: 'center' });
    });

    drawPolicy();
    drawPhotos();

    text(config.website, W / 2, H - 22, { size: 24, color: '#9a8a78', align: 'center' });
  }

  function drawPriceCard(u) {
    const labels = [config.priceLabel1, config.priceLabel2, config.priceLabel3];
    const rows = labels.map((l, i) => [l, u.prices[i]]).filter(([, v]) => v);
    const x = 680;
    const y = 165;
    const w = 370;
    const h = 150 + rows.length * 46;

    c.save();
    c.shadowColor = 'rgba(0,0,0,.25)';
    c.shadowBlur = 24;
    roundBox(x, y, w, h, 14, '#fff');
    c.restore();
    roundBox(x + 8, y + 8, w - 16, 130, 10, C.brown);

    text('Mã căn', x + 26, y + 40, { size: 16, color: '#f1e3d3' });
    text('Tòa', x + w - 26, y + 40, { size: 16, color: '#f1e3d3', align: 'right' });
    text(u.code, x + 24, y + 92, { size: 42, weight: '700', color: '#fff', maxWidth: 240 });
    text(u.toa, x + w - 26, y + 92, { size: 28, color: '#fff', align: 'right' });
    text(u.loai, x + 26, y + 124, { size: 16, color: '#f1e3d3' });
    if (u.tang) text(`Tầng:${u.tang}`, x + 160, y + 124, { size: 16, color: '#f1e3d3', align: 'center' });
    if (u.dienTich) text(`Diện tích:${u.dienTich}m²`, x + w - 26, y + 124, { size: 16, color: '#f1e3d3', align: 'right' });

    rows.forEach(([label, value], i) => {
      const ry = y + 180 + i * 46;
      text(label, x + 20, ry, { size: 24, color: C.muted, maxWidth: 140 });
      text(value, x + w - 20, ry, { size: 21, weight: '700', color: C.brownText, align: 'right', maxWidth: 200 });
    });
  }

  function drawMarker(u) {
    const m = config.markers[u.so];
    if (!m || !floorRect) return;
    const mx = floorRect.x + m.x * floorRect.w;
    const my = floorRect.y + m.y * floorRect.h;
    roundBox(mx - 32, my - 22, 64, 44, 6, C.brown);
    text(u.so, mx, my + 11, { size: 30, weight: '700', color: '#fff', align: 'center' });
  }

  function drawPolicy() {
    const items = [1, 2, 3, 4]
      .map((i) => ({ top: config[`p${i}Top`], value: config[`p${i}Value`], sub: config[`p${i}Sub`] }))
      .filter((p) => p.top || p.value);
    text(config.policyTitle, W / 2, 1075, { size: 50, font: SERIF, color: C.gold, align: 'center', maxWidth: 900 });
    if (!items.length) return;

    const bw = 175;
    const gap = 20;
    const total = items.length * bw + (items.length - 1) * gap;
    items.forEach((p, i) => {
      const x = (W - total) / 2 + i * (bw + gap);
      const y = 1098;
      const g = c.createLinearGradient(x, y, x, y + 150);
      g.addColorStop(0, '#f8ecd6');
      g.addColorStop(1, '#e6cb9c');
      c.save();
      c.shadowColor = 'rgba(120,80,30,.25)';
      c.shadowBlur = 12;
      roundBox(x, y, bw, 150, 10, g);
      c.restore();
      c.strokeStyle = '#d6b583';
      c.lineWidth = 2;
      c.stroke();
      text(p.top, x + bw / 2, y + 30, { size: 17, font: SERIF, color: '#8a6a45', align: 'center', maxWidth: bw - 16 });
      text(p.value, x + bw / 2, y + 102, { size: 66, font: SERIF, color: C.goldDark, align: 'center', maxWidth: bw - 12 });
      text(p.sub, x + bw / 2, y + 136, { size: 17, font: SERIF, color: '#8a6a45', align: 'center', maxWidth: bw - 16 });
    });
  }

  function drawPhotos() {
    const keys = ['photo1', 'photo2', 'photo3'].filter((k) => images[k]);
    if (!keys.length) return;
    const gap = 16;
    const pw = (W - 60 - gap * (keys.length - 1)) / keys.length;
    keys.forEach((k, i) => {
      const x = 30 + i * (pw + gap);
      const y = 1278;
      c.save();
      c.beginPath();
      c.roundRect(x, y, pw, 172, 10);
      c.clip();
      fit(images[k], x, y, pw, 172, 'cover');
      c.restore();
      const label = config[`photoLabel${k.slice(-1)}`];
      if (label) {
        c.save();
        c.shadowColor = 'rgba(0,0,0,.7)';
        c.shadowBlur = 6;
        text(label, x + 16, y + 34, { size: 22, weight: '700', color: '#fff', maxWidth: pw - 30 });
        c.restore();
      }
    });
  }

  // ---- Xem trước ----
  function render() {
    const list = units();
    if (current >= list.length) current = Math.max(0, list.length - 1);
    $('#tpl-pos').textContent = list.length ? `(${current + 1}/${list.length}) ${list[current].code}` : '(chưa có căn)';
    draw(ctx, list[current] || { code: 'Mã căn', toa: '', loai: '', tang: '', dienTich: '', so: '', prices: [] });
  }

  $('#tpl-prev').addEventListener('click', () => { current = Math.max(0, current - 1); render(); });
  $('#tpl-next').addEventListener('click', () => { current = Math.min(units().length - 1, current + 1); render(); });

  // Bấm vào layout tầng để đánh dấu vị trí căn
  canvas.addEventListener('click', (e) => {
    const u = units()[current];
    if (!u || !floorRect) return;
    const rect = canvas.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width) * W;
    const y = ((e.clientY - rect.top) / rect.height) * H;
    const inside = x >= floorRect.x && x <= floorRect.x + floorRect.w && y >= floorRect.y && y <= floorRect.y + floorRect.h;
    if (!inside) return;
    config.markers = { ...config.markers, [u.so]: { x: (x - floorRect.x) / floorRect.w, y: (y - floorRect.y) / floorRect.h } };
    readForm();
    render();
    toast(`Đã đánh dấu vị trí căn số ${u.so}`);
  });

  function renderBlob(u) {
    const off = document.createElement('canvas');
    off.width = W;
    off.height = H;
    draw(off.getContext('2d'), u);
    c = ctx;
    return new Promise((resolve) => off.toBlob(resolve, 'image/jpeg', 0.92));
  }

  $('#tpl-download').addEventListener('click', async () => {
    const u = units()[current];
    if (!u) return toast('Chưa nhập căn nào');
    const blob = await renderBlob(u);
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `${u.code}.jpg`;
    a.click();
  });

  $('#tpl-publish').addEventListener('click', async () => {
    const list = units();
    if (!list.length) return toast('Chưa nhập căn nào');
    if (!images.hero && !confirm('Chưa có ảnh phối cảnh AI. Vẫn tạo ảnh?')) return;
    const btn = $('#tpl-publish');
    btn.disabled = true;
    let done = 0;
    let staffCount = 0;
    try {
      for (const u of list) {
        btn.textContent = `Đang tạo ${done + 1}/${list.length}…`;
        const fd = new FormData();
        fd.append('images', await renderBlob(u), `${u.code}.jpg`);
        fd.append('caption', captionFor(u));
        fd.append('project', [config.project, u.code].filter(Boolean).join(' – '));
        fd.append('distribute', $('#tpl-distribute').checked ? 'true' : 'false');
        const r = await api('/api/images', { method: 'POST', body: fd });
        staffCount = r.staffCount;
        done++;
      }
      toast(`Đã tạo ${done} ảnh${staffCount ? ` và giao cho ${staffCount} nhân viên` : ''}`);
      loadImages();
    } catch (err) {
      toast(`Lỗi sau ${done} ảnh: ${err.message}`);
    } finally {
      btn.disabled = false;
      btn.textContent = 'Tạo tất cả & giao cho NV đăng FB';
      render();
    }
  });

  render();
})();
