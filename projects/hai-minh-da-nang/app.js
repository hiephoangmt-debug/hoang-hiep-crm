const STORAGE_KEY = 'crm-hai-minh-da-nang';

let db = load();

function load() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (raw) return JSON.parse(raw);
  } catch (e) { /* fall back to sample data */ }
  return structuredClone(SAMPLE_DATA);
}

function save() {
  try { localStorage.setItem(STORAGE_KEY, JSON.stringify(db)); } catch (e) { /* ignore */ }
  render();
}

const $ = (sel) => document.querySelector(sel);
const money = (n) => Number(n || 0).toLocaleString('vi-VN') + ' ₫';
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
const uid = (p) => p + Date.now().toString(36) + Math.random().toString(36).slice(2, 6);
const options = (list, selected, all) =>
  (all ? `<option value="">${all}</option>` : '') +
  list.map((v) => `<option ${v === selected ? 'selected' : ''}>${esc(v)}</option>`).join('');

// ---- Tabs ----
document.querySelectorAll('nav button').forEach((btn) => {
  btn.onclick = () => {
    document.querySelectorAll('nav button, .tab').forEach((el) => el.classList.remove('active'));
    btn.classList.add('active');
    $('#' + btn.dataset.tab).classList.add('active');
  };
});

// ---- Generic editor dialog ----
function openEditor(fields, record, onSave) {
  $('#editorForm').innerHTML = fields.map((f) => {
    const val = record[f.key] ?? '';
    const input = f.options
      ? `<select name="${f.key}">${options(f.options, val, f.optional ? '—' : null)}</select>`
      : f.type === 'textarea'
        ? `<textarea name="${f.key}">${esc(val)}</textarea>`
        : `<input name="${f.key}" type="${f.type || 'text'}" value="${esc(val)}" ${f.required ? 'required' : ''}>`;
    return `<label>${f.label}${input}</label>`;
  }).join('');
  $('#editorSave').onclick = (e) => {
    e.preventDefault();
    const form = $('#editorForm');
    if (!form.reportValidity()) return;
    const data = Object.fromEntries(new FormData(form));
    fields.filter((f) => f.type === 'number').forEach((f) => { data[f.key] = Number(data[f.key]); });
    onSave(data);
    $('#editor').close();
  };
  $('#editorCancel').onclick = () => $('#editor').close();
  $('#editor').showModal();
}

const UNIT_FIELDS = [
  { key: 'code', label: 'Mã căn', required: true },
  { key: 'floor', label: 'Tầng', type: 'number' },
  { key: 'type', label: 'Loại', options: UNIT_TYPES },
  { key: 'area', label: 'Diện tích (m²)', type: 'number' },
  { key: 'price', label: 'Giá thuê/tháng (₫)', type: 'number' },
  { key: 'status', label: 'Trạng thái', options: UNIT_STATUSES },
];

const customerFields = () => [
  { key: 'name', label: 'Họ tên', required: true },
  { key: 'phone', label: 'Số điện thoại', type: 'tel' },
  { key: 'source', label: 'Nguồn', options: SOURCES },
  { key: 'unit', label: 'Căn quan tâm', options: db.units.map((u) => u.code), optional: true },
  { key: 'stage', label: 'Giai đoạn', options: STAGES },
  { key: 'note', label: 'Ghi chú', type: 'textarea' },
];

const PROJECT_FIELDS = [
  { key: 'name', label: 'Tên dự án' },
  { key: 'address', label: 'Địa chỉ' },
  { key: 'floors', label: 'Số tầng', type: 'number' },
  { key: 'totalUnits', label: 'Tổng số căn', type: 'number' },
  { key: 'hotline', label: 'Hotline' },
  { key: 'manager', label: 'Người phụ trách' },
  { key: 'amenities', label: 'Tiện ích', type: 'textarea' },
  { key: 'notes', label: 'Ghi chú', type: 'textarea' },
];

function upsert(list, prefix) {
  return (record) => (data) => {
    if (record.id) Object.assign(record, data);
    else list().push({ id: uid(prefix), ...data });
    save();
  };
}
const saveUnit = upsert(() => db.units, 'u');
const saveCustomer = upsert(() => db.customers, 'c');

$('#addUnit').onclick = () => openEditor(UNIT_FIELDS, { status: 'Trống' }, saveUnit({}));
$('#addCustomer').onclick = () => openEditor(customerFields(), { stage: 'Mới' }, saveCustomer({}));

document.addEventListener('click', (e) => {
  const { action, id } = e.target.dataset;
  if (!action) return;
  if (action === 'edit-unit') {
    const u = db.units.find((x) => x.id === id);
    openEditor(UNIT_FIELDS, u, saveUnit(u));
  } else if (action === 'del-unit' && confirm('Xoá căn này?')) {
    db.units = db.units.filter((x) => x.id !== id); save();
  } else if (action === 'edit-customer') {
    const c = db.customers.find((x) => x.id === id);
    openEditor(customerFields(), c, saveCustomer(c));
  } else if (action === 'del-customer' && confirm('Xoá khách hàng này?')) {
    db.customers = db.customers.filter((x) => x.id !== id); save();
  }
});

// ---- Project info, import/export ----
$('#saveProject').onclick = () => {
  const data = Object.fromEntries(new FormData($('#projectForm')));
  PROJECT_FIELDS.filter((f) => f.type === 'number').forEach((f) => { data[f.key] = Number(data[f.key]); });
  db.project = data; save();
  alert('Đã lưu thông tin dự án');
};
$('#exportData').onclick = () => {
  const blob = new Blob([JSON.stringify(db, null, 2)], { type: 'application/json' });
  const a = Object.assign(document.createElement('a'), { href: URL.createObjectURL(blob), download: 'hai-minh-crm.json' });
  a.click(); URL.revokeObjectURL(a.href);
};
$('#importData').onchange = async (e) => {
  const file = e.target.files[0];
  if (!file) return;
  try {
    const data = JSON.parse(await file.text());
    if (!data.units || !data.customers) throw new Error('Thiếu units/customers');
    db = data; save();
  } catch (err) { alert('File không hợp lệ: ' + err.message); }
  e.target.value = '';
};
$('#resetData').onclick = () => {
  if (confirm('Xoá toàn bộ dữ liệu hiện tại và dùng lại dữ liệu mẫu?')) { db = structuredClone(SAMPLE_DATA); save(); }
};

$('#unitFilter').innerHTML = options(UNIT_STATUSES, '', 'Tất cả trạng thái');
$('#stageFilter').innerHTML = options(STAGES, '', 'Tất cả giai đoạn');
$('#unitFilter').onchange = render;
$('#stageFilter').onchange = render;
$('#customerSearch').oninput = render;

// ---- Render ----
function render() {
  const { units, customers, project } = db;
  document.title = 'CRM – ' + (project.name || 'Hải Minh');

  const rented = units.filter((u) => u.status === 'Đã cho thuê');
  const occupancy = units.length ? Math.round((rented.length / units.length) * 100) : 0;
  const revenue = rented.reduce((s, u) => s + Number(u.price || 0), 0);
  const active = customers.filter((c) => !['Ký hợp đồng', 'Thất bại'].includes(c.stage)).length;
  $('#stats').innerHTML = [
    ['Tổng số căn', units.length],
    ['Căn trống', units.filter((u) => u.status === 'Trống').length],
    ['Tỷ lệ lấp đầy', occupancy + '%'],
    ['Doanh thu thuê/tháng', money(revenue)],
    ['Khách đang chăm sóc', active],
  ].map(([k, v]) => `<div class="stat"><span>${k}</span><strong>${v}</strong></div>`).join('');

  $('#pipeline').innerHTML = STAGES.map((s) => {
    const list = customers.filter((c) => c.stage === s);
    return `<div class="col"><h3>${s} <small>${list.length}</small></h3>${list
      .map((c) => `<div class="card" data-action="edit-customer" data-id="${c.id}">${esc(c.name)}<br><small>${esc(c.unit || '—')}</small></div>`)
      .join('')}</div>`;
  }).join('');

  const uf = $('#unitFilter').value;
  $('#unitRows').innerHTML = units.filter((u) => !uf || u.status === uf).map((u) => `
    <tr><td>${esc(u.code)}</td><td>${esc(u.floor)}</td><td>${esc(u.type)}</td><td>${esc(u.area)}</td>
    <td>${money(u.price)}</td><td><span class="badge">${esc(u.status)}</span></td>
    <td><button data-action="edit-unit" data-id="${u.id}">Sửa</button><button class="danger" data-action="del-unit" data-id="${u.id}">Xoá</button></td></tr>`).join('');

  const q = $('#customerSearch').value.trim().toLowerCase();
  const sf = $('#stageFilter').value;
  $('#customerRows').innerHTML = customers
    .filter((c) => (!sf || c.stage === sf) && (!q || (c.name + ' ' + c.phone).toLowerCase().includes(q)))
    .map((c) => `
    <tr><td>${esc(c.name)}</td><td>${esc(c.phone)}</td><td>${esc(c.source)}</td><td>${esc(c.unit || '—')}</td>
    <td><span class="badge">${esc(c.stage)}</span></td><td>${esc(c.note)}</td>
    <td><button data-action="edit-customer" data-id="${c.id}">Sửa</button><button class="danger" data-action="del-customer" data-id="${c.id}">Xoá</button></td></tr>`).join('');

  $('#projectForm').innerHTML = PROJECT_FIELDS.map((f) => {
    const val = esc(project[f.key]);
    return `<label>${f.label}${f.type === 'textarea' ? `<textarea name="${f.key}">${val}</textarea>` : `<input name="${f.key}" type="${f.type || 'text'}" value="${val}">`}</label>`;
  }).join('');
}

render();
