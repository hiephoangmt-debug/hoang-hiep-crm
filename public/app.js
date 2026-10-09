// Giao diện Kho ảnh AI → nhân viên đăng Facebook
const $ = (sel) => document.querySelector(sel);

const esc = (s) =>
  String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);

async function api(url, options = {}) {
  const res = await fetch(url, options);
  if (res.status === 204) return null;
  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.error || `Lỗi ${res.status}`);
  return data;
}

const json = (method, body) => ({
  method,
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(body),
});

let toastTimer;
function toast(msg) {
  const el = $('#toast');
  el.textContent = msg;
  el.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => el.classList.remove('show'), 2800);
}

function safeStorage(fn) {
  try { return fn(); } catch { return null; }
}

// ---- Tabs ----
document.querySelectorAll('.tab').forEach((btn) =>
  btn.addEventListener('click', () => showTab(btn.dataset.tab))
);

function showTab(name) {
  document.querySelectorAll('.tab').forEach((b) => b.classList.toggle('active', b.dataset.tab === name));
  document.querySelectorAll('.panel').forEach((p) => p.classList.toggle('active', p.id === `tab-${name}`));
  if (name === 'library') loadImages();
  if (name === 'staff') loadStaff();
  if (name === 'mine') loadMine();
}

// ---- Upload ----
const fileInput = $('#file-input');
const dropzone = $('#dropzone');
let pendingFiles = [];

function setFiles(files) {
  pendingFiles = [...files].filter((f) => f.type.startsWith('image/'));
  $('#preview').innerHTML = pendingFiles
    .map((f) => `<img src="${URL.createObjectURL(f)}" alt="">`)
    .join('');
}

fileInput.addEventListener('change', () => setFiles(fileInput.files));
['dragenter', 'dragover'].forEach((ev) =>
  dropzone.addEventListener(ev, (e) => { e.preventDefault(); dropzone.classList.add('drag'); })
);
['dragleave', 'drop'].forEach((ev) =>
  dropzone.addEventListener(ev, (e) => { e.preventDefault(); dropzone.classList.remove('drag'); })
);
dropzone.addEventListener('drop', (e) => setFiles(e.dataTransfer.files));

$('#upload-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!pendingFiles.length) return toast('Chưa chọn ảnh nào');
  const form = e.target;
  const fd = new FormData();
  pendingFiles.forEach((f) => fd.append('images', f));
  fd.append('caption', form.caption.value);
  fd.append('project', form.project.value);
  fd.append('distribute', form.distribute.checked ? 'true' : 'false');

  const btn = $('#upload-btn');
  btn.disabled = true;
  btn.textContent = 'Đang tải…';
  try {
    const r = await api('/api/images', { method: 'POST', body: fd });
    toast(
      r.staffCount
        ? `Đã tải ${r.images.length} ảnh và giao cho ${r.staffCount} nhân viên`
        : `Đã tải ${r.images.length} ảnh (chưa giao cho ai)`
    );
    form.reset();
    form.distribute.checked = true;
    setFiles([]);
    loadImages();
  } catch (err) {
    toast(err.message);
  } finally {
    btn.disabled = false;
    btn.textContent = 'Tải lên';
  }
});

$('#distribute-all').addEventListener('click', async () => {
  try {
    const r = await api('/api/distribute', { method: 'POST' });
    toast(r.assigned ? `Đã giao thêm ${r.assigned} lượt ảnh cho ${r.staffCount} nhân viên` : 'Tất cả nhân viên đã có đủ ảnh');
    loadImages();
  } catch (err) {
    toast(err.message);
  }
});

async function loadImages() {
  const images = await api('/api/images');
  $('#image-count').textContent = `(${images.length})`;
  $('#image-grid').innerHTML = images.length
    ? images
        .map(
          (img) => `
      <div class="tile">
        <a href="${esc(img.url)}" target="_blank" rel="noopener"><img src="${esc(img.url)}" alt="${esc(img.originalName)}" loading="lazy"></a>
        <div class="body">
          ${img.project ? `<div class="project">${esc(img.project)}</div>` : ''}
          ${img.caption ? `<div class="caption">${esc(img.caption)}</div>` : ''}
          <div>
            <span class="badge ${img.assignedCount && img.postedCount === img.assignedCount ? 'ok' : 'warn'}">
              Đã đăng ${img.postedCount}/${img.assignedCount}
            </span>
          </div>
          <div class="actions">
            <button class="btn sm" data-edit="${img.id}">Sửa caption</button>
            <button class="btn sm danger" data-del="${img.id}">Xóa</button>
          </div>
        </div>
      </div>`
        )
        .join('')
    : '<div class="empty">Chưa có ảnh nào. Tải ảnh AI lên ở phía trên.</div>';
  window.__images = images;
}

$('#image-grid').addEventListener('click', async (e) => {
  const delId = e.target.dataset.del;
  const editId = e.target.dataset.edit;
  try {
    if (delId && confirm('Xóa ảnh này khỏi kho và khỏi danh sách của mọi nhân viên?')) {
      await api(`/api/images/${delId}`, { method: 'DELETE' });
      toast('Đã xóa ảnh');
      loadImages();
    }
    if (editId) {
      const img = (window.__images || []).find((i) => i.id === editId);
      const caption = prompt('Caption cho ảnh:', img ? img.caption : '');
      if (caption === null) return;
      await api(`/api/images/${editId}`, json('PATCH', { caption }));
      loadImages();
    }
  } catch (err) {
    toast(err.message);
  }
});

// ---- Nhân viên ----
$('#staff-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const f = e.target;
  try {
    await api('/api/staff', json('POST', { name: f.name.value, phone: f.phone.value, fbUrl: f.fbUrl.value }));
    toast(`Đã thêm ${f.name.value}`);
    f.reset();
    loadStaff();
  } catch (err) {
    toast(err.message);
  }
});

async function loadStaff() {
  const [staff, stats] = await Promise.all([api('/api/staff'), api('/api/stats')]);
  const byId = new Map(stats.map((s) => [s.staffId, s]));
  $('#staff-table').innerHTML = staff.length
    ? staff
        .map((s) => {
          const st = byId.get(s.id) || { total: 0, posted: 0 };
          const pct = st.total ? Math.round((st.posted / st.total) * 100) : 0;
          return `
        <tr>
          <td><strong>${esc(s.name)}</strong><br><small>${esc(s.phone)}</small></td>
          <td>${s.fbUrl ? `<a href="${esc(s.fbUrl)}" target="_blank" rel="noopener">Trang FB</a>` : '—'}</td>
          <td>${st.posted}/${st.total}<div class="progress"><div style="width:${pct}%"></div></div></td>
          <td><label class="check"><input type="checkbox" data-active="${s.id}" ${s.active ? 'checked' : ''}> Nhận ảnh</label></td>
          <td><button class="btn sm danger" data-remove="${s.id}">Xóa</button></td>
        </tr>`;
        })
        .join('')
    : '<tr><td colspan="5" class="empty">Chưa có nhân viên nào.</td></tr>';
}

$('#staff-table').addEventListener('change', async (e) => {
  const id = e.target.dataset.active;
  if (!id) return;
  try {
    await api(`/api/staff/${id}`, json('PATCH', { active: e.target.checked }));
    toast(e.target.checked ? 'Nhân viên sẽ nhận ảnh mới' : 'Đã tạm ngưng giao ảnh');
  } catch (err) {
    toast(err.message);
  }
});

$('#staff-table').addEventListener('click', async (e) => {
  const id = e.target.dataset.remove;
  if (!id || !confirm('Xóa nhân viên này và toàn bộ lịch sử đăng của họ?')) return;
  try {
    await api(`/api/staff/${id}`, { method: 'DELETE' });
    loadStaff();
  } catch (err) {
    toast(err.message);
  }
});

// ---- Việc đăng của tôi ----
const meSelect = $('#me-select');
const meFilter = $('#me-filter');

async function loadMine() {
  const staff = await api('/api/staff');
  const saved = meSelect.value || safeStorage(() => localStorage.getItem('crm.me')) || '';
  meSelect.innerHTML =
    '<option value="">— Chọn tên của bạn —</option>' +
    staff.map((s) => `<option value="${s.id}">${esc(s.name)}</option>`).join('');
  if (staff.some((s) => s.id === saved)) meSelect.value = saved;
  renderMine();
}

async function renderMine() {
  const staffId = meSelect.value;
  const list = $('#my-list');
  if (!staffId) {
    list.innerHTML = '<div class="empty">Chọn tên của bạn để xem ảnh cần đăng Facebook.</div>';
    return;
  }
  const params = new URLSearchParams({ staffId });
  if (meFilter.value) params.set('status', meFilter.value);
  const items = await api(`/api/assignments?${params}`);
  list.innerHTML = items.length
    ? items
        .map(
          (a) => `
      <div class="tile">
        <a href="${esc(a.image.url)}" target="_blank" rel="noopener"><img src="${esc(a.image.url)}" alt="" loading="lazy"></a>
        <div class="body">
          ${a.image.project ? `<div class="project">${esc(a.image.project)}</div>` : ''}
          ${a.image.caption ? `<div class="caption">${esc(a.image.caption)}</div>` : ''}
          <div>${
            a.status === 'posted'
              ? `<span class="badge ok">Đã đăng</span> ${a.postUrl ? `<a href="${esc(a.postUrl)}" target="_blank" rel="noopener">Xem bài</a>` : ''}`
              : '<span class="badge warn">Chưa đăng</span>'
          }</div>
          <div class="actions">
            <a class="btn sm" href="${esc(a.image.url)}" download="${esc(a.image.originalName)}">Tải ảnh</a>
            ${a.image.caption ? `<button class="btn sm" data-copy="${a.id}">Copy caption</button>` : ''}
            ${
              a.status === 'posted'
                ? `<button class="btn sm" data-undo="${a.id}">Bỏ đánh dấu</button>`
                : `<button class="btn sm ok" data-post="${a.id}">Đã đăng FB</button>`
            }
          </div>
        </div>
      </div>`
        )
        .join('')
    : `<div class="empty">${meFilter.value === 'pending' ? 'Không còn ảnh nào cần đăng 🎉' : 'Chưa có ảnh nào.'}</div>`;
  window.__mine = items;
}

meSelect.addEventListener('change', () => {
  safeStorage(() => localStorage.setItem('crm.me', meSelect.value));
  renderMine();
});
meFilter.addEventListener('change', renderMine);

$('#my-list').addEventListener('click', async (e) => {
  const { copy, post, undo } = e.target.dataset;
  try {
    if (copy) {
      const item = (window.__mine || []).find((a) => a.id === copy);
      await navigator.clipboard.writeText(item.image.caption);
      toast('Đã copy caption');
    }
    if (post) {
      const postUrl = prompt('Dán link bài đăng Facebook (có thể bỏ trống):', '');
      if (postUrl === null) return;
      await api(`/api/assignments/${post}`, json('PATCH', { status: 'posted', postUrl }));
      toast('Đã đánh dấu đã đăng');
      renderMine();
    }
    if (undo) {
      await api(`/api/assignments/${undo}`, json('PATCH', { status: 'pending' }));
      renderMine();
    }
  } catch (err) {
    toast(err.message);
  }
});

loadImages();
