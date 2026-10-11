/* Hoàng Hiệp CRM – giao diện (không framework) */
'use strict';

const $ = (sel, root = document) => root.querySelector(sel);
const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
const app = $('#app');

const STATUS = { moi: 'Mới', dang_cham_soc: 'Đang chăm sóc', quan_tam: 'Quan tâm', hen_xem: 'Hẹn xem nhà', dam_phan: 'Đàm phán', da_mua: 'Đã mua', ngung: 'Ngừng' };
const STATUS_COLOR = { moi: 'blue', dang_cham_soc: 'teal', quan_tam: 'amber', hen_xem: 'amber', dam_phan: 'red', da_mua: 'green', ngung: '' };
const TEMP = { nong: '🔥 Nóng', am: '🌤 Ấm', lanh: '❄️ Lạnh' };
const NEED_TYPE = { can_ho: 'Căn hộ', dat_nen: 'Đất nền', nha_pho: 'Nhà phố', biet_thu: 'Biệt thự', shophouse: 'Shophouse', khac: 'Khác' };
const PURPOSE = { o: 'Để ở', dau_tu: 'Đầu tư', cho_thue: 'Cho thuê' };
const ACT_TYPE = { call: '📞 Gọi điện', zalo: '💬 Zalo', sms: '✉️ SMS', email: '📧 Email', meeting: '🤝 Gặp mặt', site_visit: '🏗 Dẫn xem nhà', note: '📝 Ghi chú', system: '⚙️ Hệ thống' };
const OUTCOME = {
  nghe_may: 'Đã nói chuyện', quan_tam: 'Quan tâm, xin thêm thông tin', hen_xem: 'Hẹn đi xem', hen_goi_lai: 'Hẹn gọi lại',
  khong_nghe: 'Không nghe máy', thue_bao: 'Thuê bao / tắt máy', tu_choi: 'Từ chối / chưa có nhu cầu', sai_so: 'Sai số',
};
const PROJECT_STATUS = { sap_mo: 'Sắp mở bán', dang_ban: 'Đang bán', ngung: 'Ngừng' };
const INVITE = { can_goi: 'Cần gọi', da_moi: 'Đã mời', quan_tam: 'Quan tâm', khong: 'Không quan tâm' };

// ---------- tiện ích ----------
function esc(v) {
  return String(v ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
}
function opts(map, selected, empty) {
  return (empty !== undefined ? `<option value="">${esc(empty)}</option>` : '') +
    Object.entries(map).map(([k, v]) => `<option value="${esc(k)}" ${k === selected ? 'selected' : ''}>${esc(v)}</option>`).join('');
}
function fmtDate(iso, withTime = true) {
  if (!iso) return '';
  const d = new Date(iso);
  return d.toLocaleString('vi-VN', withTime ? { hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit', year: 'numeric' } : { day: '2-digit', month: '2-digit', year: 'numeric' });
}
function ago(iso) {
  if (!iso) return '';
  const diff = (Date.now() - new Date(iso)) / 1000;
  const fut = diff < 0;
  const s = Math.abs(diff);
  const t = s < 60 ? 'vài giây' : s < 3600 ? `${Math.floor(s / 60)} phút` : s < 86400 ? `${Math.floor(s / 3600)} giờ` : s < 86400 * 60 ? `${Math.floor(s / 86400)} ngày` : `${Math.floor(s / 86400 / 30)} tháng`;
  return fut ? `sau ${t}` : `${t} trước`;
}
function toLocalInput(iso) {
  if (!iso) return '';
  const d = new Date(iso);
  const p = (n) => String(n).padStart(2, '0');
  return `${d.getFullYear()}-${p(d.getMonth() + 1)}-${p(d.getDate())}T${p(d.getHours())}:${p(d.getMinutes())}`;
}
function fmtPhone(p) {
  return p ? p.replace(/^(\d{4})(\d{3})(\d+)$/, '$1 $2 $3') : '';
}
function budget(c) {
  if (c.budget_min == null && c.budget_max == null) return '';
  if (c.budget_min === c.budget_max || c.budget_max == null) return `${c.budget_min} tỷ`;
  if (c.budget_min == null) return `≤ ${c.budget_max} tỷ`;
  return `${c.budget_min}–${c.budget_max} tỷ`;
}
function toast(msg, ms = 2500) {
  const t = $('#toast');
  t.textContent = msg;
  t.hidden = false;
  clearTimeout(toast._t);
  toast._t = setTimeout(() => (t.hidden = true), ms);
}
async function copy(text) {
  try { await navigator.clipboard.writeText(text); toast('Đã sao chép'); } catch { prompt('Sao chép:', text); }
}
function formData(form) {
  const out = {};
  for (const el of form.elements) {
    if (!el.name) continue;
    if (el.type === 'checkbox') out[el.name] = el.checked;
    else if (el.type === 'radio') { if (el.checked) out[el.name] = el.value; }
    else out[el.name] = el.value;
  }
  return out;
}

async function api(method, path, body) {
  const res = await fetch(path, {
    method,
    headers: body ? { 'content-type': 'application/json' } : {},
    body: body ? JSON.stringify(body) : undefined,
  });
  if (res.status === 401 && !path.startsWith('/api/login')) { renderLogin(); throw new Error('Chưa đăng nhập'); }
  const data = res.headers.get('content-type')?.includes('json') ? await res.json() : await res.text();
  if (!res.ok) throw new Error(data.error || `Lỗi ${res.status}`);
  return data;
}

function callButtons(c) {
  if (!c.phone) return '';
  return `<a class="btn sm call" href="tel:${esc(c.phone)}">📞 Gọi</a><a class="btn sm zalo" href="https://zalo.me/${esc(c.phone)}" target="_blank" rel="noopener">Zalo</a>`;
}
function custLine(c, extra = '') {
  return `<li class="item">
    <div class="main">
      <a class="title" href="#/customer/${c.id}">${esc(c.salutation ? c.salutation + ' ' : '')}${esc(c.name || '(chưa có tên)')}</a>
      ${c.temperature ? `<span class="small">${TEMP[c.temperature] || ''}</span>` : ''}
      <div class="sub">${esc(fmtPhone(c.phone))}${extra}</div>
    </div>
    <div class="actions">${callButtons(c)}<a class="btn sm" href="#/customer/${c.id}">Mở</a></div>
  </li>`;
}

// ---------- đăng nhập ----------
function renderLogin() {
  stopPolling();
  app.innerHTML = `<div class="card login">
    <h1>🔐 Đăng nhập</h1>
    <form id="login"><label>Mật khẩu<input type="password" name="password" autocomplete="current-password" required autofocus></label>
    <button class="btn primary" style="width:100%">Đăng nhập</button><p class="danger-text small" id="err"></p></form></div>`;
  $('#login').onsubmit = async (e) => {
    e.preventDefault();
    try {
      await api('POST', '/api/login', formData(e.target));
      startPolling();
      route();
    } catch (err) { $('#err').textContent = err.message; }
  };
}

// ---------- HÔM NAY ----------
async function viewToday() {
  const a = await api('GET', '/api/agenda');
  const section = (title, count, body, hint = '') => `<div class="card"><h2>${title} <span class="count">${count}</span></h2>${hint}${count ? `<ul class="list">${body}</ul>` : '<p class="empty">Không có 🎉</p>'}</div>`;
  const src = (r) => r.last_source ? ` · 🌐 ${esc(r.last_source)}` : '';
  app.innerHTML = `
    <h1>Việc hôm nay <span class="muted small">${new Date().toLocaleDateString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit' })}</span></h1>
    <div class="card tip">💡 <b>Mẹo hôm nay:</b> ${esc(a.tip)}</div>
    ${a.holidays.map((h) => `<div class="card tip">🎉 <b>${esc(h.name)}</b> ${h.inDays === 0 ? 'là hôm nay' : `còn ${h.inDays} ngày`} – nhắn chúc mừng ${h.warm_customers} khách nóng/ấm để giữ quan hệ. <a href="#/scripts/dip_le">Xem mẫu tin</a></div>`).join('')}
    <div class="grid grid-2">
      <div>
        ${section('🔥 Lead mới – gọi ngay', a.new_leads.length, a.new_leads.map((r) => custLine(r,
          `${src(r)} · ${r.over_sla ? `<span class="badge red">chờ ${ago(r.last_inquiry_at || r.created_at).replace(' trước', '')}</span>` : `<span class="badge green">${ago(r.last_inquiry_at || r.created_at)}</span>`}`)).join(''),
          `<p class="muted small">Mục tiêu: gọi trong ${a.sla_minutes} phút kể từ khi khách để lại thông tin.</p>`)}
        ${section('⏰ Hẹn gọi lại', a.follow_ups.length, a.follow_ups.map((r) => custLine(r,
          ` · ${r.overdue ? '<span class="badge red">quá hạn</span>' : '<span class="badge amber">hôm nay</span>'} ${fmtDate(r.next_follow_up_at)}${r.next_follow_up_note ? ` · ${esc(r.next_follow_up_note)}` : ''}`)).join(''))}
        ${section('🏢 Mời dự án mới', a.project_calls.length, a.project_calls.map((r) => custLine(r,
          ` · <a href="#/project/${r.project_id}">${esc(r.project_name)}</a> <span class="badge blue">${PROJECT_STATUS[r.project_status] || ''}</span>`)).join(''))}
      </div>
      <div>
        ${section('🎂 Sinh nhật sắp tới', a.birthdays.length, a.birthdays.map((r) => custLine(r, ` · ${r.in_days === 0 ? '<b>Hôm nay</b>' : `còn ${r.in_days} ngày`}`)).join(''))}
        ${section('🤝 Lâu không liên lạc – hỏi thăm', a.rewarm_total, a.rewarm.map((r) => custLine(r,
          ` · ${r.days_silent} ngày chưa liên hệ · <span class="badge ${STATUS_COLOR[r.status]}">${STATUS[r.status]}</span>`)).join(''),
          '<p class="muted small">Khách chưa có lịch hẹn và đã quá nhịp chăm sóc (cài trong Cài đặt). Mở khách để xem gợi ý câu bắt chuyện.</p>')}
      </div>
    </div>`;
}

// ---------- DANH SÁCH KHÁCH ----------
const listState = { q: '', status: '', temperature: '', source: '', need_type: '', sort: 'newest', offset: 0 };
async function viewCustomers() {
  const params = new URLSearchParams(Object.entries(listState).filter(([, v]) => v !== '' && v !== 0));
  params.set('limit', 50);
  const [data, rep] = await Promise.all([api('GET', `/api/customers?${params}`), api('GET', '/api/reports?days=3650')]);
  const sources = rep.bySource.map((s) => s.source);
  app.innerHTML = `
    <div class="row"><h1>Khách hàng <span class="muted small">${data.total}</span></h1><span class="spacer"></span>
      <button class="btn primary" id="add">+ Thêm khách</button>
      <button class="btn" id="import">⬆ Nhập CSV</button>
      <a class="btn" href="/api/export.csv">⬇ Xuất CSV</a></div>
    <div class="card">
      <form id="filters" class="row">
        <input name="q" placeholder="Tìm tên, SĐT, nhu cầu, tag…" value="${esc(listState.q)}" style="flex:2;min-width:180px">
        <select name="status" style="flex:1;min-width:130px">${opts(STATUS, listState.status, 'Mọi trạng thái')}</select>
        <select name="temperature" style="flex:1;min-width:110px">${opts(TEMP, listState.temperature, 'Mọi mức độ')}</select>
        <select name="need_type" style="flex:1;min-width:120px">${opts(NEED_TYPE, listState.need_type, 'Mọi loại hình')}</select>
        <select name="source" style="flex:1;min-width:140px">${opts(Object.fromEntries(sources.map((s) => [s, s])), listState.source, 'Mọi nguồn web')}</select>
        <select name="sort" style="flex:1;min-width:150px">${opts({ newest: 'Mới đăng ký', follow: 'Lịch hẹn gần nhất', silent: 'Lâu chưa liên hệ', name: 'Tên A–Z' }, listState.sort)}</select>
      </form>
    </div>
    <div class="card"><ul class="list">${data.rows.map((c) => custLine(c,
      ` · <span class="badge ${STATUS_COLOR[c.status]}">${STATUS[c.status]}</span>
       ${c.last_source ? ` · 🌐 ${esc(c.last_source)}` : ''}${c.inquiry_count > 1 ? ` (${c.inquiry_count} lần)` : ''}
       ${c.need_type ? ` · ${esc(NEED_TYPE[c.need_type] || c.need_type)}` : ''}${budget(c) ? ` · ${budget(c)}` : ''}
       · ĐK ${ago(c.last_inquiry_at || c.created_at)}
       ${c.next_follow_up_at ? ` · ⏰ ${fmtDate(c.next_follow_up_at)}` : ''}`)).join('') || '<p class="empty">Chưa có khách nào.</p>'}</ul>
      <div class="row">${listState.offset > 0 ? '<button class="btn" id="prev">← Trước</button>' : ''}<span class="spacer"></span>
      ${listState.offset + 50 < data.total ? '<button class="btn" id="next">Sau →</button>' : ''}</div>
    </div>
    <dialog id="dlg"></dialog>`;
  let t;
  $('#filters').oninput = (e) => {
    clearTimeout(t);
    t = setTimeout(() => { Object.assign(listState, formData($('#filters')), { offset: 0 }); viewCustomers().then(() => { const q = $('#filters [name=q]'); if (e.target.name === 'q') { q.focus(); q.setSelectionRange(q.value.length, q.value.length); } }); }, e.target.name === 'q' ? 350 : 0);
  };
  $('#filters').onsubmit = (e) => e.preventDefault();
  $('#prev') && ($('#prev').onclick = () => { listState.offset -= 50; viewCustomers(); });
  $('#next') && ($('#next').onclick = () => { listState.offset += 50; viewCustomers(); });
  $('#add').onclick = () => addCustomerDialog();
  $('#import').onclick = () => importDialog();
}

function addCustomerDialog() {
  const d = $('#dlg');
  d.innerHTML = `<h2>Thêm khách hàng</h2><form id="addf" class="form-grid">
    <label>Họ tên<input name="name" required></label>
    <label>Xưng hô<select name="salutation">${opts({ anh: 'Anh', 'chị': 'Chị', 'cô': 'Cô', 'chú': 'Chú', 'em': 'Em' }, '', '—')}</select></label>
    <label>Số điện thoại<input name="phone" type="tel" required></label>
    <label>Email<input name="email" type="email"></label>
    <label>Nguồn<input name="source" placeholder="VD: Giới thiệu, Facebook, Sự kiện" value="Nhập tay"></label>
    <label>Loại hình<select name="need_type">${opts(NEED_TYPE, '', '—')}</select></label>
    <label class="full">Nhu cầu<textarea name="need_note"></textarea></label>
    <div class="row full"><span class="spacer"></span><button type="button" class="btn" id="cancel">Huỷ</button><button class="btn primary">Lưu</button></div></form>`;
  d.showModal();
  $('#cancel').onclick = () => d.close();
  $('#addf').onsubmit = async (e) => {
    e.preventDefault();
    try {
      const r = await api('POST', '/api/customers', formData(e.target));
      d.close();
      if (!r.is_new) toast('Số này đã có – đã gộp vào khách cũ');
      location.hash = `#/customer/${r.customer.id}`;
    } catch (err) { toast(err.message); }
  };
}

function parseCsv(text) {
  const rows = [];
  let row = [], cell = '', q = false;
  text = text.replace(/^﻿/, '');
  for (let i = 0; i < text.length; i++) {
    const ch = text[i];
    if (q) {
      if (ch === '"' && text[i + 1] === '"') { cell += '"'; i++; } else if (ch === '"') q = false; else cell += ch;
    } else if (ch === '"') q = true;
    else if (ch === ',' || ch === ';' || ch === '\t') { row.push(cell); cell = ''; }
    else if (ch === '\n' || ch === '\r') { if (ch === '\r' && text[i + 1] === '\n') i++; row.push(cell); rows.push(row); row = []; cell = ''; }
    else cell += ch;
  }
  if (cell || row.length) { row.push(cell); rows.push(row); }
  const [head, ...body] = rows.filter((r) => r.some((c) => c.trim()));
  return body.map((r) => Object.fromEntries(head.map((h, i) => [h.trim(), (r[i] || '').trim()])));
}

function importDialog() {
  const d = $('#dlg');
  d.innerHTML = `<h2>Nhập khách từ file CSV</h2>
    <p class="muted small">Xuất từ LadiPage (Data → Xuất Excel/CSV), Google Sheets (Tệp → Tải xuống → CSV) hoặc Excel (Lưu thành CSV UTF-8).
    Dòng đầu là tên cột – hệ thống tự nhận các cột như "Họ tên", "Số điện thoại", "Email", "Nội dung", "URL"… Khách trùng SĐT sẽ được gộp.</p>
    <label>Nguồn (ghi cho tất cả dòng, để trống nếu file có cột nguồn/URL)<input id="isrc" placeholder="VD: ladipage, hiephoangmt.com"></label>
    <input type="file" id="ifile" accept=".csv,text/csv">
    <p id="ires" class="small"></p>
    <div class="row"><span class="spacer"></span><button class="btn" id="cancel">Đóng</button><button class="btn primary" id="go" disabled>Nhập</button></div>`;
  d.showModal();
  let rows = [];
  $('#cancel').onclick = () => { d.close(); if (rows.length) viewCustomers(); };
  $('#ifile').onchange = async (e) => {
    rows = parseCsv(await e.target.files[0].text());
    $('#ires').textContent = `Đọc được ${rows.length} dòng. Cột: ${Object.keys(rows[0] || {}).join(', ')}`;
    $('#go').disabled = !rows.length;
  };
  $('#go').onclick = async () => {
    $('#go').disabled = true;
    let created = 0, merged = 0, errors = [];
    for (let i = 0; i < rows.length; i += 200) {
      const r = await api('POST', '/api/import', { rows: rows.slice(i, i + 200), source: $('#isrc').value.trim() || undefined });
      created += r.created; merged += r.merged; errors = errors.concat(r.errors);
    }
    $('#ires').innerHTML = `✅ Thêm mới ${created}, gộp ${merged}.${errors.length ? `<br><span class="danger-text">${errors.slice(0, 10).map(esc).join('<br>')}</span>` : ''}`;
  };
}

// ---------- CHI TIẾT KHÁCH ----------
async function viewCustomer(id) {
  const [d, settings] = await Promise.all([api('GET', `/api/customers/${id}`), api('GET', '/api/settings')]);
  const c = d.customer;
  const timeline = [
    ...d.inquiries.map((i) => ({ at: i.created_at, kind: 'web', i })),
    ...d.activities.map((a) => ({ at: a.created_at, kind: a.type === 'system' ? 'system' : a.type === 'call' ? 'call' : 'act', a })),
  ].sort((x, y) => (x.at < y.at ? 1 : -1));

  const groups = {};
  for (const s of d.suggestions) (groups[s.groupLabel] ||= []).push(s);

  app.innerHTML = `
    <div class="row">
      <a href="#/customers" class="btn sm">←</a>
      <h1 style="margin:0">${esc(c.salutation ? c.salutation + ' ' : '')}${esc(c.name || '(chưa có tên)')}</h1>
      <span class="badge ${STATUS_COLOR[c.status]}">${STATUS[c.status]}</span><span class="small">${TEMP[c.temperature]}</span>
      ${c.do_not_call ? '<span class="badge red">Không gọi</span>' : ''}
    </div>
    <div class="row" style="margin:10px 0 16px">
      ${c.phone ? `<a class="btn call" href="tel:${esc(c.phone)}">📞 ${esc(fmtPhone(c.phone))}</a><a class="btn zalo" href="https://zalo.me/${esc(c.phone)}" target="_blank" rel="noopener">💬 Zalo</a><button class="btn" data-copy="${esc(c.phone)}">Sao chép SĐT</button>` : ''}
      ${c.email ? `<a class="btn" href="mailto:${esc(c.email)}">📧 ${esc(c.email)}</a>` : ''}
    </div>
    ${c.next_follow_up_at ? `<div class="card tip">⏰ Hẹn liên hệ: <b>${fmtDate(c.next_follow_up_at)}</b> (${ago(c.next_follow_up_at)})${c.next_follow_up_note ? ` – ${esc(c.next_follow_up_note)}` : ''}</div>` : ''}
    <div class="grid grid-2">
      <div>
        <div class="card">
          <h2>📝 Ghi nhận liên hệ</h2>
          <form id="actf">
            <div class="chips" id="types">${Object.entries(ACT_TYPE).filter(([k]) => k !== 'system').map(([k, v], i) => `<label class="chip ${i === 0 ? 'on' : ''}"><input type="radio" name="type" value="${k}" ${i === 0 ? 'checked' : ''} hidden>${v}</label>`).join('')}</div>
            <div class="form-grid" style="margin-top:10px">
              <label>Kết quả<select name="outcome">${opts(OUTCOME, '', '—')}</select></label>
              <label>Chuyển trạng thái<select name="status">${opts(STATUS, '', '(giữ nguyên)')}</select></label>
              <label class="full">Nội dung trao đổi<textarea name="content" placeholder="Khách nói gì, cần gì, hẹn gì…"></textarea></label>
              <label>Mức độ<select name="temperature">${opts(TEMP, '', '(giữ nguyên)')}</select></label>
              <label>Hẹn liên hệ lại<select name="when" id="when">
                <option value="">Tự động theo kết quả</option><option value="tonight">Tối nay 19h</option><option value="1">Ngày mai 9h</option>
                <option value="3">3 ngày nữa</option><option value="7">1 tuần nữa</option><option value="30">1 tháng nữa</option>
                <option value="pick">Chọn ngày giờ…</option><option value="none">Không hẹn</option></select></label>
              <label class="full hidden" id="pickw">Ngày giờ<input type="datetime-local" name="pick"></label>
              <label class="full">Việc cần làm lần tới<input name="next_follow_up_note" placeholder="VD: gửi bảng giá, mời xem nhà mẫu"></label>
            </div>
            <button class="btn primary">Lưu</button>
          </form>
        </div>

        <div class="card">
          <div class="row"><h2>💬 Gợi ý cách nói</h2><span class="spacer"></span><a class="small" href="#/scripts">Thư viện kịch bản →</a></div>
          ${Object.entries(groups).map(([g, list]) => `<h3>${esc(g)}</h3>${list.map((s) => `<div class="script"><div class="stitle">${esc(s.title)}<span class="spacer"></span><button class="btn sm" data-copy="${esc(s.text)}">Sao chép</button></div><div class="stext">${esc(s.text)}</div></div>`).join('')}`).join('')}
          ${settings.ai_enabled ? `<h3>🤖 Gợi ý riêng bằng AI</h3>
            <div class="row"><input id="goal" placeholder="Mục tiêu (VD: mời xem nhà mẫu cuối tuần, hâm nóng sau 2 tháng)" style="flex:1"><button class="btn" id="aibtn">Gợi ý</button></div>
            <div id="aiout" class="script hidden" style="margin-top:8px;white-space:pre-wrap"></div>` : '<p class="muted small">Muốn gợi ý riêng theo lịch sử khách bằng AI? Xem mục Cài đặt.</p>'}
        </div>

        <div class="card">
          <h2>🕒 Lịch sử (web + liên hệ)</h2>
          <ul class="timeline">${timeline.map((t) => t.kind === 'web' ? webItem(t.i) : actItem(t.a)).join('') || '<p class="empty">Chưa có.</p>'}</ul>
        </div>
      </div>

      <div>
        <div class="card">
          <h2>👤 Hồ sơ & nhu cầu</h2>
          <form id="custf" class="form-grid">
            <label>Họ tên<input name="name" value="${esc(c.name)}"></label>
            <label>Xưng hô<select name="salutation">${opts({ anh: 'Anh', 'chị': 'Chị', 'cô': 'Cô', 'chú': 'Chú', 'em': 'Em' }, c.salutation, '—')}</select></label>
            <label>Điện thoại<input name="phone" type="tel" value="${esc(c.phone)}"></label>
            <label>Email<input name="email" type="email" value="${esc(c.email)}"></label>
            <label>Trạng thái<select name="status">${opts(STATUS, c.status)}</select></label>
            <label>Mức độ<select name="temperature">${opts(TEMP, c.temperature)}</select></label>
            <label>Loại hình<select name="need_type">${opts(NEED_TYPE, c.need_type, '—')}</select></label>
            <label>Mục đích<select name="need_purpose">${opts(PURPOSE, c.need_purpose, '—')}</select></label>
            <label>Khu vực quan tâm<input name="need_area" value="${esc(c.need_area)}"></label>
            <label>Thời điểm mua<input name="need_timeline" value="${esc(c.need_timeline)}" placeholder="VD: trong quý 4"></label>
            <label>Ngân sách từ (tỷ)<input name="budget_min" type="number" step="0.1" value="${c.budget_min ?? ''}"></label>
            <label>đến (tỷ)<input name="budget_max" type="number" step="0.1" value="${c.budget_max ?? ''}"></label>
            <label class="full">Ghi chú nhu cầu<textarea name="need_note">${esc(c.need_note)}</textarea></label>
            <label>Giờ tiện gọi<input name="best_call_time" value="${esc(c.best_call_time)}" placeholder="VD: sau 19h"></label>
            <label>Sinh nhật<input name="birthday" type="date" value="${esc(c.birthday)}"></label>
            <label>Nghề nghiệp<input name="job" value="${esc(c.job)}"></label>
            <label>Zalo<input name="zalo" value="${esc(c.zalo)}"></label>
            <label class="full">Ghi chú cá nhân (gia đình, sở thích… để bắt chuyện)<textarea name="personal_note">${esc(c.personal_note)}</textarea></label>
            <label class="full">Tag<input name="tags" value="${esc(c.tags)}" placeholder="VD: vip, nhà đầu tư, giới thiệu"></label>
            <label class="check full"><input type="checkbox" name="notify_new_projects" ${c.notify_new_projects ? 'checked' : ''}> Có dự án mới phù hợp thì gọi mời</label>
            <label class="check full"><input type="checkbox" name="do_not_call" ${c.do_not_call ? 'checked' : ''}> Không gọi nữa (khách yêu cầu / sai số)</label>
            <div class="row full"><button class="btn primary">Lưu hồ sơ</button><span class="spacer"></span><button type="button" class="btn danger sm" id="del">Xoá khách</button></div>
          </form>
        </div>
        <div class="card">
          <h2>🌐 Nguồn khách</h2>
          <p class="small">Lần đầu: <b>${esc(c.first_source || '')}</b> · ${fmtDate(c.created_at)}<br>${c.first_url ? `<a class="url" href="${esc(c.first_url)}" target="_blank" rel="noopener">${esc(c.first_url)}</a>` : ''}</p>
          <p class="small muted">Tổng ${d.inquiries.length} lần đăng ký. Lần liên hệ gần nhất: ${c.last_contact_at ? `${fmtDate(c.last_contact_at)} (${ago(c.last_contact_at)})` : 'chưa'}</p>
        </div>
        <div class="card">
          <h2>🏢 Dự án đã mời / quan tâm</h2>
          ${d.projects.length ? `<ul class="list">${d.projects.map((p) => `<li class="item"><div class="main"><a class="title" href="#/project/${p.id}">${esc(p.name)}</a><div class="sub">${INVITE[p.status]} · ${fmtDate(p.updated_at, false)}</div></div></li>`).join('')}</ul>` : '<p class="empty">Chưa có.</p>'}
        </div>
      </div>
    </div>`;

  $$('[data-copy]').forEach((b) => (b.onclick = () => copy(b.dataset.copy)));
  $$('#types .chip').forEach((ch) => (ch.onclick = () => { $$('#types .chip').forEach((x) => x.classList.remove('on')); ch.classList.add('on'); }));
  $('#when').onchange = (e) => $('#pickw').classList.toggle('hidden', e.target.value !== 'pick');

  $('#actf').onsubmit = async (e) => {
    e.preventDefault();
    const f = formData(e.target);
    const body = { type: f.type, outcome: f.outcome, content: f.content, status: f.status, temperature: f.temperature, next_follow_up_note: f.next_follow_up_note };
    const now = new Date();
    if (f.when === 'none') body.next_follow_up_at = 'none';
    else if (f.when === 'pick') body.next_follow_up_at = f.pick ? new Date(f.pick).toISOString() : '';
    else if (f.when === 'tonight') body.next_follow_up_at = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 19).toISOString();
    else if (f.when) body.next_follow_up_at = new Date(now.getFullYear(), now.getMonth(), now.getDate() + Number(f.when), 9).toISOString();
    if (!body.outcome && !body.content) return toast('Chọn kết quả hoặc ghi nội dung');
    await api('POST', `/api/customers/${id}/activities`, body);
    toast('Đã lưu');
    viewCustomer(id);
  };

  $('#custf').onsubmit = async (e) => {
    e.preventDefault();
    try { await api('PUT', `/api/customers/${id}`, formData(e.target)); toast('Đã lưu hồ sơ'); viewCustomer(id); } catch (err) { toast(err.message); }
  };
  $('#del').onclick = async () => {
    if (!confirm('Xoá khách này và toàn bộ lịch sử?')) return;
    await api('DELETE', `/api/customers/${id}`);
    location.hash = '#/customers';
  };
  $$('[data-del-act]').forEach((b) => (b.onclick = async () => {
    if (!confirm('Xoá dòng lịch sử này?')) return;
    await api('DELETE', `/api/activities/${b.dataset.delAct}`);
    viewCustomer(id);
  }));
  if ($('#aibtn')) $('#aibtn').onclick = async () => {
    const out = $('#aiout');
    out.classList.remove('hidden');
    out.textContent = 'Đang soạn gợi ý…';
    $('#aibtn').disabled = true;
    try { out.textContent = (await api('POST', `/api/customers/${id}/ai-suggest`, { goal: $('#goal').value })).text; } catch (err) { out.textContent = err.message; }
    $('#aibtn').disabled = false;
  };
}

function webItem(i) {
  let raw = {};
  try { raw = JSON.parse(i.raw || '{}'); } catch { /* bỏ qua */ }
  const utm = [i.utm_source, i.utm_medium, i.utm_campaign].filter(Boolean).join(' / ');
  return `<li class="web"><div class="meta">📥 Đăng ký trên <b>${esc(i.source)}</b> · ${fmtDate(i.created_at)} (${ago(i.created_at)})</div>
    ${i.page_url ? `<div class="small url">🔗 <a href="${esc(i.page_url)}" target="_blank" rel="noopener">${esc(i.page_title || i.page_url)}</a></div>` : ''}
    ${i.project ? `<div class="small">🏢 ${esc(i.project)}</div>` : ''}
    ${utm ? `<div class="small muted">📣 ${esc(utm)}${i.gclid ? ' · Google Ads' : ''}${i.fbclid ? ' · Facebook' : ''}</div>` : ''}
    ${i.referrer ? `<div class="small muted url">↩ Đến từ: ${esc(i.referrer)}</div>` : ''}
    ${raw.first_landing && raw.first_landing !== i.page_url ? `<div class="small muted url">🚪 Vào web lần đầu: ${esc(raw.first_landing)} ${raw.first_visit_at ? `(${fmtDate(raw.first_visit_at)})` : ''} · xem ${esc(raw.pages_viewed)} trang</div>` : ''}
    ${i.message ? `<div class="body">${esc(i.message)}</div>` : ''}</li>`;
}
function actItem(a) {
  return `<li class="${a.type === 'system' ? 'system' : a.type === 'call' ? 'call' : ''}"><div class="meta">${ACT_TYPE[a.type] || esc(a.type)}${a.outcome ? ` · <b>${esc(OUTCOME[a.outcome] || a.outcome)}</b>` : ''} · ${fmtDate(a.created_at)}
    ${a.type !== 'system' ? `<button class="btn sm" style="min-height:0;padding:0 6px;margin-left:6px" data-del-act="${a.id}" title="Xoá">×</button>` : ''}</div>
    ${a.content ? `<div class="body">${esc(a.content)}</div>` : ''}</li>`;
}

// ---------- DỰ ÁN ----------
function projectForm(p = {}) {
  return `<form id="projf" class="form-grid">
    <label class="full">Tên dự án<input name="name" required value="${esc(p.name)}"></label>
    <label>Chủ đầu tư<input name="developer" value="${esc(p.developer)}"></label>
    <label>Loại hình<select name="type">${opts(NEED_TYPE, p.type, '—')}</select></label>
    <label>Vị trí<input name="location" value="${esc(p.location)}"></label>
    <label>Khu vực (để lọc khách)<input name="area" value="${esc(p.area)}" placeholder="VD: Thủ Đức, Quận 9"></label>
    <label>Giá từ (tỷ)<input name="price_from" type="number" step="0.1" value="${p.price_from ?? ''}"></label>
    <label>Giá đến (tỷ)<input name="price_to" type="number" step="0.1" value="${p.price_to ?? ''}"></label>
    <label>Ngày mở bán<input name="launch_date" type="date" value="${esc(p.launch_date)}"></label>
    <label>Trạng thái<select name="status">${opts(PROJECT_STATUS, p.status || 'sap_mo')}</select></label>
    <label class="full">Điểm nổi bật (dùng khi gọi mời)<textarea name="highlights">${esc(p.highlights)}</textarea></label>
    <label class="full">Link landing page<input name="link" value="${esc(p.link)}"></label>
    <div class="row full"><button class="btn primary">Lưu dự án</button><span class="spacer"></span>${p.id ? '<button type="button" class="btn danger sm" id="pdel">Xoá dự án</button>' : ''}</div>
  </form>`;
}

async function viewProjects() {
  const list = await api('GET', '/api/projects');
  app.innerHTML = `<div class="row"><h1>Dự án</h1><span class="spacer"></span><button class="btn primary" id="newp">+ Dự án mới</button></div>
    <div class="card hidden" id="newcard"><h2>Dự án mới</h2>${projectForm()}</div>
    <p class="muted small">Thêm dự án sắp mở bán → hệ thống lọc khách đúng loại hình, khu vực, ngân sách để bạn gọi mời trước.</p>
    <div class="grid grid-cards">${list.map((p) => `<a class="card" href="#/project/${p.id}" style="color:inherit">
      <div class="row"><b>${esc(p.name)}</b><span class="spacer"></span><span class="badge ${p.status === 'sap_mo' ? 'amber' : p.status === 'dang_ban' ? 'green' : ''}">${PROJECT_STATUS[p.status]}</span></div>
      <div class="small muted">${esc([NEED_TYPE[p.type], p.area || p.location, p.price_from != null ? `từ ${p.price_from} tỷ` : '', p.launch_date ? `mở bán ${fmtDate(p.launch_date, false)}` : ''].filter(Boolean).join(' · '))}</div>
      <div class="small" style="margin-top:6px">📞 Cần gọi: <b>${p.to_call}</b> · ⭐ Quan tâm: <b>${p.interested}</b></div></a>`).join('') || '<p class="empty">Chưa có dự án.</p>'}</div>`;
  $('#newp').onclick = () => $('#newcard').classList.toggle('hidden');
  $('#projf').onsubmit = async (e) => {
    e.preventDefault();
    const r = await api('POST', '/api/projects', formData(e.target));
    location.hash = `#/project/${r.id}`;
  };
}

async function viewProject(id) {
  const { project: p, matches } = await api('GET', `/api/projects/${id}`);
  const invited = matches.filter((m) => m.invite_status);
  const fresh = matches.filter((m) => !m.invite_status);
  app.innerHTML = `<div class="row"><a href="#/projects" class="btn sm">←</a><h1 style="margin:0">${esc(p.name)}</h1><span class="badge amber">${PROJECT_STATUS[p.status]}</span></div>
    <div class="grid grid-2" style="margin-top:16px">
      <div>
        <div class="card"><h2>📞 Danh sách gọi mời <span class="count">${invited.length}</span></h2>
          ${invited.length ? `<ul class="list">${invited.map((m) => `<li class="item"><div class="main"><a class="title" href="#/customer/${m.id}">${esc(m.salutation ? m.salutation + ' ' : '')}${esc(m.name || '(chưa có tên)')}</a> <span class="small">${TEMP[m.temperature]}</span>
            <div class="sub">${esc(fmtPhone(m.phone))} · ${esc(m.reasons.join(', ') || 'đăng ký nhận tin dự án mới')}</div>
            <div class="chips" style="margin-top:6px">${Object.entries(INVITE).map(([k, v]) => `<button class="chip ${m.invite_status === k ? 'on' : ''}" data-inv="${m.id}" data-st="${k}">${v}</button>`).join('')}</div></div>
            <div class="actions">${callButtons(m)}</div></li>`).join('')}</ul>` : '<p class="empty">Chọn khách phù hợp ở bên dưới để đưa vào danh sách gọi.</p>'}
        </div>
        <div class="card"><div class="row"><h2>🎯 Khách phù hợp chưa mời <span class="count">${fresh.length}</span></h2><span class="spacer"></span>
          <button class="btn sm" id="selall">Chọn tất cả</button><button class="btn primary sm" id="addinv">Thêm vào danh sách gọi</button></div>
          <p class="muted small">Lọc theo loại hình, khu vực, ngân sách – chỉ gồm khách đồng ý nhận tin dự án mới.</p>
          <ul class="list">${fresh.map((m) => `<li class="item"><input type="checkbox" class="pick" value="${m.id}" style="width:auto;min-height:0">
            <div class="main"><a class="title" href="#/customer/${m.id}">${esc(m.name || '(chưa có tên)')}</a> <span class="small">${TEMP[m.temperature]}</span>
            <div class="sub">${esc([NEED_TYPE[m.need_type] || m.need_type, m.need_area, budget(m)].filter(Boolean).join(' · '))}${m.reasons.length ? ` · ✅ ${esc(m.reasons.join(', '))}` : ' · chưa rõ nhu cầu – gọi hỏi thêm'}</div></div></li>`).join('') || '<p class="empty">Không có khách phù hợp.</p>'}</ul>
        </div>
      </div>
      <div class="card"><h2>Thông tin dự án</h2>${projectForm(p)}</div>
    </div>`;
  $('#projf').onsubmit = async (e) => { e.preventDefault(); await api('PUT', `/api/projects/${id}`, formData(e.target)); toast('Đã lưu'); viewProject(id); };
  $('#pdel').onclick = async () => { if (confirm('Xoá dự án?')) { await api('DELETE', `/api/projects/${id}`); location.hash = '#/projects'; } };
  $('#selall').onclick = () => $$('.pick').forEach((c) => (c.checked = true));
  $('#addinv').onclick = async () => {
    const ids = $$('.pick').filter((c) => c.checked).map((c) => c.value);
    if (!ids.length) return toast('Chưa chọn khách');
    const r = await api('POST', `/api/projects/${id}/invite`, { customer_ids: ids });
    toast(`Đã thêm ${r.added} khách – xem ở trang Hôm nay`);
    viewProject(id);
  };
  $$('[data-inv]').forEach((b) => (b.onclick = async () => {
    await api('PUT', `/api/projects/${id}/customers/${b.dataset.inv}`, { status: b.dataset.st });
    viewProject(id);
  }));
}

// ---------- KỊCH BẢN ----------
async function viewScripts(group) {
  const { groups, scripts } = await api('GET', '/api/scripts');
  app.innerHTML = `<h1>Thư viện kịch bản</h1>
    <p class="muted small">Các chỗ trong {ngoặc} sẽ tự điền tên khách, trang khách đăng ký, dự án… khi bạn mở từng khách hàng.</p>
    <div class="chips" style="margin-bottom:16px">${Object.entries(groups).map(([k, v]) => `<a class="chip ${group === k ? 'on' : ''}" href="#/scripts/${k}">${esc(v)}</a>`).join('')}</div>
    ${Object.entries(groups).filter(([k]) => !group || k === group).map(([k, v]) => `<div class="card"><h2>${esc(v)}</h2>
      ${scripts.filter((s) => s.group === k).map((s) => `<div class="script"><div class="stitle">${esc(s.title)}<span class="spacer"></span><button class="btn sm" data-copy="${esc(s.text)}">Sao chép</button></div><div class="stext">${esc(s.text)}</div></div>`).join('')}</div>`).join('')}`;
  $$('[data-copy]').forEach((b) => (b.onclick = () => copy(b.dataset.copy)));
}

// ---------- BÁO CÁO ----------
async function viewReports(days = 30) {
  const r = await api('GET', `/api/reports?days=${days}`);
  const max = (rows, k) => Math.max(1, ...rows.map((x) => x[k]));
  const total = r.bySource.reduce((s, x) => s + x.inquiries, 0);
  const mS = max(r.bySource, 'inquiries'), mD = max(r.byDay, 'inquiries'), mH = max(r.byHour, 'inquiries');
  app.innerHTML = `<div class="row"><h1>Báo cáo</h1><span class="spacer"></span>
    <select id="days" style="width:auto">${opts({ 7: '7 ngày', 30: '30 ngày', 90: '90 ngày', 365: '1 năm' }, String(days))}</select></div>
    <div class="grid grid-cards">
      <div class="card"><div class="muted small">Lượt đăng ký</div><div style="font-size:28px;font-weight:700">${total}</div></div>
      <div class="card"><div class="muted small">Lượt liên hệ đã ghi</div><div style="font-size:28px;font-weight:700">${r.calls}</div></div>
      <div class="card"><div class="muted small">Khách theo trạng thái (tất cả)</div><div class="small">${r.byStatus.map((s) => `${STATUS[s.status] || s.status}: <b>${s.n}</b>`).join(' · ')}</div></div>
    </div>
    <div class="card"><h2>🌐 Theo website / nguồn</h2><div class="table-wrap"><table>
      <tr><th>Nguồn</th><th class="num">Lượt ĐK</th><th class="num">Khách</th><th class="num">Đang nóng</th><th class="num">Đã mua</th><th style="width:30%"></th></tr>
      ${r.bySource.map((s) => `<tr><td><a href="#/customers" data-src="${esc(s.source)}">${esc(s.source)}</a></td><td class="num">${s.inquiries}</td><td class="num">${s.customers}</td><td class="num">${s.hot}</td><td class="num">${s.won}</td>
        <td><div class="bar" style="width:${(s.inquiries / mS) * 100}%"></div></td></tr>`).join('')}</table></div></div>
    <div class="card"><h2>🔗 Theo trang (link) khách điền form</h2><div class="table-wrap"><table>
      <tr><th>Trang</th><th class="num">Lượt ĐK</th><th>Gần nhất</th></tr>
      ${r.byPage.map((p) => `<tr><td class="url small"><a href="${esc(p.page_url)}" target="_blank" rel="noopener">${esc(p.page_url)}</a></td><td class="num">${p.inquiries}</td><td class="small">${fmtDate(p.last_at)}</td></tr>`).join('') || '<tr><td colspan="3" class="muted">Chưa có</td></tr>'}</table></div></div>
    <div class="grid grid-2">
      <div class="card"><h2>📅 Theo ngày</h2><table>${r.byDay.map((d) => `<tr><td class="small" style="width:90px">${esc(d.day.slice(8))}/${esc(d.day.slice(5, 7))}</td><td><div class="bar" style="width:${(d.inquiries / mD) * 100}%"></div></td><td class="num" style="width:40px">${d.inquiries}</td></tr>`).join('')}</table></div>
      <div class="card"><h2>🕐 Theo giờ trong ngày</h2><p class="muted small">Biết khung giờ khách hay đăng ký để trực điện thoại.</p><table>${r.byHour.map((h) => `<tr><td class="small" style="width:50px">${h.hour}h</td><td><div class="bar" style="width:${(h.inquiries / mH) * 100}%"></div></td><td class="num" style="width:40px">${h.inquiries}</td></tr>`).join('')}</table></div>
    </div>
    <div class="card"><h2>📣 Theo chiến dịch quảng cáo (UTM)</h2><div class="table-wrap"><table><tr><th>utm_source</th><th>utm_campaign</th><th class="num">Lượt ĐK</th></tr>
      ${r.byCampaign.map((c) => `<tr><td>${esc(c.utm_source)}</td><td>${esc(c.utm_campaign)}</td><td class="num">${c.inquiries}</td></tr>`).join('') || '<tr><td colspan="3" class="muted">Chưa có dữ liệu UTM</td></tr>'}</table></div></div>`;
  $('#days').onchange = (e) => viewReports(Number(e.target.value));
  $$('[data-src]').forEach((a) => (a.onclick = () => { Object.assign(listState, { source: a.dataset.src, offset: 0 }); }));
}

// ---------- CÀI ĐẶT ----------
async function viewSettings() {
  const s = await api('GET', '/api/settings');
  const hook = `${s.base_url}/api/hook/lead?key=${s.webhook_key}`;
  const tracker = `<script src="${s.base_url}/tracker.js" data-key="${s.webhook_key}" async></script>`;
  const appsScript = `// Google Sheets → Tiện ích mở rộng → Apps Script. Đặt trigger "Khi gửi biểu mẫu" hoặc chạy tay.
function guiCRM(e) {
  var row = e && e.namedValues ? e.namedValues : {};
  var data = {};
  Object.keys(row).forEach(function (k) { data[k] = row[k][0]; });
  data.source = 'google-form';
  UrlFetchApp.fetch('${hook}', { method: 'post', contentType: 'application/json', payload: JSON.stringify(data) });
}`;
  app.innerHTML = `<h1>Cài đặt</h1>
    <div class="grid grid-2">
      <div>
        <div class="card"><h2>🔌 Kết nối LadiPage</h2>
          <ol class="small">
            <li>Vào LadiPage → mở landing page → chọn <b>Form</b> → <b>Cấu hình dữ liệu / Tích hợp</b> → thêm <b>Webhook</b> (hoặc vào <i>Cài đặt → Tài khoản liên kết → Webhook</i>).</li>
            <li>Dán URL dưới đây, chọn phương thức <b>POST</b>. Lưu và xuất bản lại trang.</li>
            <li>Điền thử form trên trang → khách sẽ hiện ở mục <b>Hôm nay</b> kèm link trang, thời gian, UTM.</li>
          </ol>
          <pre id="hook">${esc(hook)}</pre><button class="btn sm" data-copy="${esc(hook)}">Sao chép URL webhook</button>
          <p class="muted small">Mỗi landing page nên thêm <code>&source=ten-du-an</code> vào cuối URL nếu muốn đặt tên nguồn riêng (mặc định lấy tên miền của trang).</p>
        </div>
        <div class="card"><h2>🌐 Gắn vào website (hiephoangmt.com, hoanggiaminh.com…)</h2>
          <p class="small">Dán đoạn mã dưới đây trước thẻ <code>&lt;/body&gt;</code> (WordPress: dùng plugin <i>Insert Headers and Footers / WPCode</i> → Footer). Mã tự bắt mọi form có số điện thoại (Contact Form 7, Elementor, Flatsome, form tự viết…), ghi lại <b>trang khách điền form</b>, <b>trang vào đầu tiên</b>, nguồn Google/Facebook/UTM và thời gian.</p>
          <pre>${esc(tracker)}</pre><button class="btn sm" data-copy="${esc(tracker)}">Sao chép mã</button>
          <p class="muted small">Form gửi bằng JavaScript riêng: gọi <code>HHCRM.send({name, phone, message, project})</code>. Không muốn bắt form nào thì thêm thuộc tính <code>data-crm-ignore</code> vào thẻ form.</p>
        </div>
        <div class="card"><h2>📄 Google Form / Google Sheets</h2><pre>${esc(appsScript)}</pre><button class="btn sm" data-copy="${esc(appsScript)}">Sao chép</button></div>
      </div>
      <div>
        <div class="card"><h2>👤 Thông tin của bạn</h2>
          <form id="setf" class="form-grid">
            <label>Tên bạn (xưng trong kịch bản)<input name="sales_name" value="${esc(s.sales_name)}"></label>
            <label>Công ty / thương hiệu<input name="company" value="${esc(s.company)}"></label>
            <label class="full">SĐT của bạn<input name="sales_phone" value="${esc(s.sales_phone)}"></label>
            <h3 class="full">⏱ Nhịp chăm sóc</h3>
            <label>Gọi lead mới trong (phút)<input name="sla_minutes" type="number" value="${esc(s.sla_minutes)}"></label>
            <label>Khách 🔥 nóng: nhắc sau (ngày)<input name="cadence_nong" type="number" value="${esc(s.cadence_nong)}"></label>
            <label>Khách 🌤 ấm: nhắc sau (ngày)<input name="cadence_am" type="number" value="${esc(s.cadence_am)}"></label>
            <label>Khách ❄️ lạnh: nhắc sau (ngày)<input name="cadence_lanh" type="number" value="${esc(s.cadence_lanh)}"></label>
            <label>Khách đã mua: hỏi thăm sau (ngày)<input name="cadence_da_mua" type="number" value="${esc(s.cadence_da_mua)}"></label>
            <div class="full"><button class="btn primary">Lưu</button></div>
          </form>
        </div>
        <div class="card"><h2>🔔 Thông báo & AI</h2>
          <p class="small">Telegram báo lead mới: ${s.telegram_enabled ? '<span class="badge green">Đang bật</span>' : '<span class="badge">Chưa bật</span> – đặt TELEGRAM_BOT_TOKEN và TELEGRAM_CHAT_ID trong file .env'}</p>
          <p class="small">Thông báo trên trình duyệt: <button class="btn sm" id="notif">Bật thông báo</button></p>
          <p class="small">Gợi ý bằng AI (Claude): ${s.ai_enabled ? '<span class="badge green">Đang bật</span>' : '<span class="badge">Chưa bật</span> – đặt ANTHROPIC_API_KEY trong .env và chạy <code>npm install</code>'}</p>
        </div>
        <div class="card"><h2>🔐 Bảo mật</h2>
          <p class="small">Nếu lỡ lộ URL webhook, tạo key mới (nhớ cập nhật lại LadiPage và mã website).</p>
          <div class="row"><button class="btn danger sm" id="regen">Tạo key webhook mới</button><button class="btn sm" id="logout">Đăng xuất</button></div>
        </div>
      </div>
    </div>`;
  $$('[data-copy]').forEach((b) => (b.onclick = () => copy(b.dataset.copy)));
  $('#setf').onsubmit = async (e) => { e.preventDefault(); await api('PUT', '/api/settings', formData(e.target)); toast('Đã lưu'); };
  $('#regen').onclick = async () => { if (confirm('Key cũ sẽ ngừng hoạt động. Tiếp tục?')) { await api('PUT', '/api/settings', { regenerate_webhook_key: true }); viewSettings(); } };
  $('#logout').onclick = async () => { await api('POST', '/api/logout'); renderLogin(); };
  $('#notif').onclick = async () => toast((await Notification.requestPermission()) === 'granted' ? 'Đã bật thông báo' : 'Trình duyệt chưa cho phép');
}

// ---------- báo lead mới ----------
let pollTimer = null;
let pollSince = new Date().toISOString();
function startPolling() {
  stopPolling();
  pollTimer = setInterval(async () => {
    try {
      const r = await api('GET', `/api/poll?since=${encodeURIComponent(pollSince)}`);
      pollSince = r.now;
      if (!r.leads.length) return;
      const l = r.leads[0];
      const msg = `🔥 ${r.leads.length} lead mới: ${l.name || l.phone} (${l.source})`;
      toast(msg, 8000);
      document.title = `(${r.leads.length}) Hoàng Hiệp CRM`;
      if (window.Notification && Notification.permission === 'granted') {
        const n = new Notification('Lead mới – gọi ngay!', { body: `${l.name || ''} ${l.phone || ''} · ${l.source}` });
        n.onclick = () => { window.focus(); location.hash = `#/customer/${l.customer_id}`; };
      }
      if (location.hash === '' || location.hash.startsWith('#/today')) viewToday();
    } catch { /* mất mạng tạm thời */ }
  }, 30000);
}
function stopPolling() { clearInterval(pollTimer); }

// ---------- router ----------
async function route() {
  const [, view = 'today', arg] = (location.hash || '#/today').split('/');
  $$('[data-nav]').forEach((a) => a.classList.toggle('active', a.dataset.nav === view || (view === 'customer' && a.dataset.nav === 'customers') || (view === 'project' && a.dataset.nav === 'projects')));
  document.title = 'Hoàng Hiệp CRM';
  window.scrollTo(0, 0);
  try {
    if (view === 'customers') await viewCustomers();
    else if (view === 'customer') await viewCustomer(Number(arg));
    else if (view === 'projects') await viewProjects();
    else if (view === 'project') await viewProject(Number(arg));
    else if (view === 'scripts') await viewScripts(arg);
    else if (view === 'reports') await viewReports();
    else if (view === 'settings') await viewSettings();
    else await viewToday();
  } catch (e) {
    if (e.message !== 'Chưa đăng nhập') app.innerHTML = `<div class="card danger-text">${esc(e.message)}</div>`;
  }
}

window.addEventListener('hashchange', route);
(async () => {
  const me = await fetch('/api/me').then((r) => r.json()).catch(() => ({}));
  if (!me.ok) return renderLogin();
  startPolling();
  route();
})();
