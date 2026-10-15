import { Store, samplePlan, studioPlan, luxuryPlan, emptyPlan, FLOOR_TYPES, uid } from './model.js';
import { STYLES, PALETTE_FIELDS, roomKind, resolvePalette } from './styles.js';
import { MAIN_KEY } from './furniture.js';
import { computeEstimate, estimateCSV, vnd, DEFAULT_PRICES, STYLE_FACTOR } from './estimate.js';
import { Editor2D } from './editor2d.js';
import { Viewer3D } from './viewer3d.js';
import { CATALOG, CATALOG_MAP } from './furniture.js';
import { wallLength, openingRange, polygonArea, fmt } from './geom.js';
import { detectWalls } from './detect.js';
import { detectRooms } from './autorooms.js';

const $ = (s) => document.querySelector(s);
const $$ = (s) => [...document.querySelectorAll(s)];
const store = new Store();
const editor = new Editor2D($('#plan'), store);
const viewer = new Viewer3D($('#viewer'), store);
editor.active = true;

/** Hộp thoại trong trang (thay cho confirm/prompt vốn bị chặn trong khung nhúng) */
function ask(message, { input = null, inputs = null, ok = 'Đồng ý', cancel = 'Huỷ' } = {}) {
  // inputs: [{ label, value, placeholder }] → trả về mảng giá trị; input: một ô → trả về chuỗi
  const fields = inputs || (input !== null ? [{ label: '', value: input }] : []);
  return new Promise((resolve) => {
    const wrap = document.createElement('div');
    wrap.className = 'modal';
    wrap.innerHTML = `<form class="sheet dialog"><p></p>${fields.map((f, i) => `<label class="askfield"><span></span><input type="text" id="askInput${i}" inputmode="decimal" /></label>`).join('')}
      <div class="btnrow"><button type="button" data-r="cancel">${cancel}</button><button type="submit" class="primary">${ok}</button></div></form>`;
    wrap.querySelector('p').textContent = message;
    const inps = [...wrap.querySelectorAll('input')];
    inps.forEach((inp, i) => { inp.value = fields[i].value ?? ''; inp.placeholder = fields[i].placeholder || ''; inp.previousElementSibling.textContent = fields[i].label; });
    const value = () => (inputs ? inps.map((x) => x.value) : inps.length ? inps[0].value : true);
    const done = (v) => { wrap.remove(); resolve(v); };
    wrap.querySelector('form').onsubmit = (e) => { e.preventDefault(); done(value()); };
    wrap.querySelector('[data-r="cancel"]').onclick = () => done(fields.length ? null : false);
    wrap.onkeydown = (e) => { if (e.key === 'Escape') done(fields.length ? null : false); };
    document.body.appendChild(wrap);
    (inps[0] || wrap.querySelector('[type=submit]')).focus();
    inps[0]?.select();
  });
}

function toast(msg, ms = 2600) {
  const t = $('#toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toast._t);
  toast._t = setTimeout(() => t.classList.remove('show'), ms);
}

// ---------- Đồng bộ 2D -> 3D ----------
let rebuildT = 0;
store.addEventListener('change', (e) => {
  clearTimeout(rebuildT);
  const isLoad = e.detail === 'load';
  rebuildT = setTimeout(() => {
    viewer.rebuild(isLoad);
    if (isLoad) { viewer.frameAll(true); editor.fit(); }
  }, e.detail === 'drag' ? 220 : 60);
  if (e.detail !== 'drag') renderProps();
});

// ---------- Chế độ hiển thị ----------
function setMode(mode) {
  $('#app').className = 'mode-' + mode;
  $$('#modes button').forEach((b) => b.classList.toggle('active', b.dataset.mode === mode));
  editor.active = mode !== '3d';
  requestAnimationFrame(() => { editor.resize(); viewer.resize(); });
  if (mode === '3d' && !viewer._played3d) { viewer._played3d = true; viewer.playBuild(); }
}
$$('#modes button').forEach((b) => (b.onclick = () => setMode(b.dataset.mode)));

// ---------- Công cụ ----------
const HINTS = {
  select: 'Nhấp để chọn, kéo để di chuyển. Kéo nền để cuộn, lăn chuột để phóng to. Delete để xoá, R để xoay.',
  wall: 'Nhấp điểm đầu, nhấp tiếp các điểm để vẽ tường liên tiếp. Nhấp đúp / Enter để kết thúc. Shift: khoá góc 45°, Alt: tắt bắt điểm.',
  room: 'Kéo để vẽ phòng chữ nhật (tự tạo tường bao). Hoặc nhấp từng điểm để vẽ phòng đa giác, nhấp lại điểm đầu để khép.',
  door: 'Di chuột lên một bức tường rồi nhấp để đặt cửa đi. Phím F để đổi hướng mở.',
  window: 'Di chuột lên một bức tường rồi nhấp để đặt cửa sổ.',
  slide: 'Di chuột lên tường rồi nhấp để đặt cửa kính lùa (ra ban công, sân vườn).',
  furniture: 'Nhấp để đặt. R để xoay trước khi đặt. Đồ sát tường sẽ tự áp lưng vào tường. Giữ Shift để đặt nhiều.',
  calibrate: 'Nhấp 2 điểm trên ảnh có kích thước đã biết (ví dụ một bức tường), sau đó nhập chiều dài thực.',
  movebg: 'Kéo để dời ảnh nền cho khớp với lưới.',
};
editor.addEventListener('tool', (e) => {
  const t = e.detail;
  $$('#tools button').forEach((b) => b.classList.toggle('active', b.dataset.tool === t));
  $$('#catalog button').forEach((b) => b.classList.toggle('active', t === 'furniture' && b.dataset.type === editor.furnitureType));
  $('#bgCalib').classList.toggle('active', t === 'calibrate');
  $('#bgMove').classList.toggle('active', t === 'movebg');
  $('#toolHint').textContent = HINTS[t] || '';
});
$$('#tools button').forEach((b) => (b.onclick = () => editor.setTool(b.dataset.tool)));

// ---------- Thư viện nội thất ----------
function renderCatalog(filter = '') {
  const el = $('#catalog');
  el.innerHTML = '';
  const q = filter.trim().toLowerCase();
  const cats = [...new Set(CATALOG.map((c) => c.cat))];
  for (const cat of cats) {
    const items = CATALOG.filter((c) => c.cat === cat && (!q || c.name.toLowerCase().includes(q)));
    if (!items.length) continue;
    const h = document.createElement('div');
    h.className = 'cat';
    h.textContent = cat;
    const grid = document.createElement('div');
    grid.className = 'items';
    for (const it of items) {
      const b = document.createElement('button');
      b.dataset.type = it.type;
      b.title = `${it.name} – ${it.w} × ${it.d} m`;
      b.innerHTML = `<span>${it.icon}</span>${it.name}`;
      b.onclick = () => { editor.ghostRot = 0; editor.setTool('furniture', it.type); };
      grid.appendChild(b);
    }
    el.append(h, grid);
  }
}
renderCatalog();
$('#furnSearch').oninput = (e) => renderCatalog(e.target.value);

// ---------- Bảng thuộc tính ----------
editor.addEventListener('select', () => renderProps());
viewer.onPickFurniture = (id) => editor.select({ kind: 'furniture', id });

function field(label, input) {
  return `<label class="field"><span>${label}</span>${input}</label>`;
}
const num = (key, val, step = 0.01, min = 0) => `<input type="number" data-k="${key}" value="${+(+val).toFixed(3)}" step="${step}" min="${min}" />`;
const txt = (key, val) => `<input type="text" data-k="${key}" value="${String(val ?? '').replace(/"/g, '&quot;')}" />`;
const sel = (key, val, opts) => `<select data-k="${key}">${Object.entries(opts).map(([k, v]) => `<option value="${k}" ${k === val ? 'selected' : ''}>${v}</option>`).join('')}</select>`;

function renderProps() {
  const el = $('#props');
  const s = editor.selection;
  const plan = store.plan;
  if (!s) return renderOverview(el);
  if (s.kind === 'wall') {
    const w = store.wall(s.id);
    if (!w) return renderOverview(el);
    el.innerHTML = `<h3>Tường</h3>
      ${field('Chiều dài (m)', num('length', wallLength(w), 0.05, 0.1))}
      ${field('Bề dày (m)', num('thickness', w.thickness, 0.01, 0.05))}
      ${field('Chiều cao (m)', num('height', w.height || plan.settings.wallHeight, 0.05, 0.3))}
      <div class="btnrow"><button data-a="split">✂ Chia đôi</button><button data-a="door">+ Cửa đi</button><button data-a="window">+ Cửa sổ</button><button data-a="del" class="danger">Xoá</button></div>`;
    bindInputs(el, (k, v) => store.commit(() => {
      if (k === 'length') {
        const L = wallLength(w), dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
        const old = { ...w.b };
        w.b.x = +(w.a.x + dx * v).toFixed(3); w.b.y = +(w.a.y + dy * v).toFixed(3);
        // Kéo theo các tường nối ở đầu b
        for (const o of plan.walls) for (const end of ['a', 'b']) if (o !== w && Math.hypot(o[end].x - old.x, o[end].y - old.y) < 1e-3) { o[end].x = w.b.x; o[end].y = w.b.y; }
      } else if (k === 'height') w.height = v;
      else w[k] = v;
    }));
    bindActions(el, {
      del: () => editor.deleteSelection(),
      split: () => {
        const mid = { x: (w.a.x + w.b.x) / 2, y: (w.a.y + w.b.y) / 2 };
        const nw = { ...w, id: uid(), a: { ...mid }, b: { ...w.b } };
        store.commit((pl) => {
          pl.openings.filter((o) => o.wallId === w.id).forEach((o) => { if (o.t > 0.5) { o.wallId = nw.id; o.t = (o.t - 0.5) * 2; } else o.t *= 2; });
          w.b = { ...mid };
          pl.walls.push(nw);
        });
      },
      door: () => addOpening(w, 'door'),
      window: () => addOpening(w, 'window'),
    });
  } else if (s.kind === 'opening') {
    const op = plan.openings.find((o) => o.id === s.id);
    const w = op && store.wall(op.wallId);
    if (!w) return renderOverview(el);
    const [st] = openingRange(w, op);
    el.innerHTML = `<h3>${op.type === 'window' ? 'Cửa sổ' : op.type === 'slide' ? 'Cửa kính lùa' : 'Cửa đi'}</h3>
      ${field('Loại', sel('type', op.type, { door: 'Cửa đi', window: 'Cửa sổ', slide: 'Cửa kính lùa' }))}
      ${field('Rộng (m)', num('width', op.width, 0.05, 0.3))}
      ${field('Cao (m)', num('height', op.height, 0.05, 0.3))}
      ${field('Cao bệ (m)', num('sill', op.sill || 0, 0.05, 0))}
      ${field('Cách đầu tường', num('offset', st, 0.05, 0))}
      <div class="btnrow">${op.type === 'door' ? '<button data-a="flip">⇄ Đổi hướng mở (F)</button>' : ''}<button data-a="del" class="danger">Xoá</button></div>`;
    bindInputs(el, (k, v) => store.commit(() => {
      const L = wallLength(w);
      if (k === 'offset') op.t = Math.min(1, (v + op.width / 2) / L);
      else if (k === 'type') {
        op.type = v;
        if (v === 'window' && !op.sill) { op.sill = 0.9; op.height = Math.min(op.height, 1.4); }
        if (v !== 'window') op.sill = 0;
      } else op[k] = k === 'width' ? Math.min(v, L) : v;
    }));
    bindActions(el, { del: () => editor.deleteSelection(), flip: () => editor.flipSelection() });
  } else if (s.kind === 'room') {
    const r = plan.rooms.find((x) => x.id === s.id);
    if (!r) return renderOverview(el);
    el.innerHTML = `<h3>Phòng</h3>
      ${field('Tên phòng', txt('name', r.name))}
      ${field('Vật liệu sàn', sel('floor', r.floor, FLOOR_TYPES))}
      <div class="stat"><div><b>${fmt(polygonArea(r.points), 2)}</b><small>m² diện tích</small></div><div><b>${r.points.length}</b><small>đỉnh</small></div></div>
      <p class="hint">Kéo phòng để dời, kéo ô vuông ở góc để chỉnh hình dạng.</p>
      <div class="btnrow"><button data-a="del" class="danger">Xoá phòng</button></div>`;
    bindInputs(el, (k, v) => store.commit(() => (r[k] = v)), true);
    bindActions(el, { del: () => editor.deleteSelection() });
  } else if (s.kind === 'furniture') {
    const f = plan.furniture.find((x) => x.id === s.id);
    if (!f) return renderOverview(el);
    const def = CATALOG_MAP[f.type];
    el.innerHTML = `<h3>${def.icon} ${def.name}</h3>
      ${field('Rộng (m)', num('w', f.w ?? def.w, 0.05, 0.1))}
      ${field('Sâu (m)', num('d', f.d ?? def.d, 0.05, 0.1))}
      ${field('Cao (m)', num('h', f.h ?? def.h, 0.05, 0.01))}
      ${field('Góc xoay (°)', num('rot', f.rot || 0, 15, -360))}
      ${field('Vị trí X', num('x', f.x, 0.05, -1e4))}
      ${field('Vị trí Y', num('y', f.y, 0.05, -1e4))}
      ${MAIN_KEY[def.base || def.type] ? field('Màu riêng', `<span class="colorrow"><input type="color" data-color="1" value="${f.color || resolvePalette(plan.settings)[MAIN_KEY[def.base || def.type]]}" />${f.color ? '<button data-a="uncolor" title="Dùng màu theo phong cách">↺</button>' : ''}</span>`) : ''}
      <div class="btnrow"><button data-a="rot">⟳ Xoay 90° (R)</button><button data-a="dup">⧉ Nhân bản</button><button data-a="del" class="danger">Xoá</button></div>`;
    bindInputs(el, (k, v) => store.commit(() => (f[k] = v)));
    bindActions(el, { del: () => editor.deleteSelection(), rot: () => editor.rotateSelection(90), dup: () => editor.duplicate(), uncolor: () => store.commit(() => delete f.color) });
    bindColor(el.querySelector('[data-color]'), (v) => (f.color = v));
  }
}

function renderOverview(el) {
  const plan = store.plan;
  const area = plan.rooms.reduce((s, r) => s + polygonArea(r.points), 0);
  const st = plan.settings;
  const pal = resolvePalette(st);
  el.innerHTML = `<h3>Phong cách nội thất</h3>
    <div class="styles">${Object.entries(STYLES).map(([k, v]) => `<button data-style="${k}" class="${(st.style || 'luxury') === k ? 'active' : ''}" title="${v.desc}">
      <span class="sw">${[v.wall, v.palette.wood, v.palette.fabric, v.palette.stone, v.cap].map((c) => `<i style="background:${c}"></i>`).join('')}</span>${v.name}</button>`).join('')}</div>
    <p class="hint">Chọn phong cách sẽ đổi màu tường, gỗ, vải, rèm và vật liệu sàn theo loại phòng (tự nhận theo tên phòng).</p>
    <details ${st.palette && Object.keys(st.palette).length ? 'open' : ''}><summary>🎨 Tuỳ chỉnh màu sắc</summary>
      <div class="palette">${PALETTE_FIELDS.map(([k, label]) => `<label><input type="color" data-pal="${k}" value="${pal[k]}" />${label}</label>`).join('')}</div>
      <div class="toggles col">
        <label><input type="checkbox" data-flag="led" ${pal.led ? 'checked' : ''}/> Đèn LED hắt viền trần</label>
        <label><input type="checkbox" data-flag="slats" ${pal.slats ? 'checked' : ''}/> Vách lam gỗ sau TV</label>
        <label><input type="checkbox" data-flag="leather" ${pal.leather ? 'checked' : ''}/> Sofa bọc da</label>
        <label><input type="checkbox" data-curtains="1" ${st.curtains !== false ? 'checked' : ''}/> Rèm cửa</label>
      </div>
      <div class="btnrow"><button data-a="resetpal">↺ Về màu gốc của phong cách</button></div>
    </details>
    <h3 style="margin-top:14px">View ngoài cửa sổ / lô-gia</h3>
    <div class="stack">
      <button data-a="viewload">🌆 Tải ảnh view thật (360° hoặc ảnh thường)</button>
      ${viewState ? `${field('Loại ảnh', `<select data-view="kind"><option value="pano" ${viewState.kind === 'pano' ? 'selected' : ''}>Ảnh 360° (toàn cảnh)</option><option value="photo" ${viewState.kind !== 'pano' ? 'selected' : ''}>Ảnh thường</option></select>`)}
        ${field('Hướng (°)', `<input type="range" data-view="heading" min="-180" max="180" step="1" value="${viewState.heading || 0}" />`)}
        ${viewState.kind !== 'pano' ? field('Góc ảnh (°)', `<input type="range" data-view="fov" min="40" max="360" step="5" value="${viewState.fov || 110}" />`) : ''}
        ${field('Căn hộ ở tầng', `<input type="number" data-view="floor" min="1" max="100" step="1" value="${viewState.floor || 1}" />`)}
        <button data-a="viewclear">🗑 Bỏ ảnh view</button>` : '<p class="hint">Tải ảnh chụp từ đúng tầng/ban công căn hộ để thấy view thật khi “🚶 Đi bộ” nhìn ra cửa kính, lô-gia. Ảnh 360° cho kết quả chân thực nhất.</p>'}
    </div>
    <h3 style="margin-top:14px">Tổng quan</h3>
    <div class="stat">
      <div><b>${fmt(area, 1)}</b><small>m² sàn</small></div>
      <div><b>${plan.rooms.length}</b><small>phòng</small></div>
      <div><b>${plan.walls.length}</b><small>bức tường</small></div>
      <div><b>${plan.furniture.length}</b><small>đồ nội thất</small></div>
    </div>
    ${field('Cao tường (m)', num('wallHeight', plan.settings.wallHeight, 0.1, 2))}
    ${field('Dày tường mới', num('wallThickness', plan.settings.wallThickness, 0.01, 0.05))}
    <div class="roomlist">${plan.rooms.map((r) => `<button data-room="${r.id}">${r.name}<small>${fmt(polygonArea(r.points), 1)} m² · ${FLOOR_TYPES[r.floor] || ''}</small></button>`).join('')}</div>
    <h3 style="margin-top:16px">Phím tắt</h3>
    <div class="kbd">
      <kbd>V</kbd> chọn · <kbd>W</kbd> tường · <kbd>P</kbd> phòng · <kbd>D</kbd> cửa · <kbd>C</kbd> cửa sổ<br>
      <kbd>R</kbd> xoay · <kbd>F</kbd> đổi chiều cửa · <kbd>Del</kbd> xoá · <kbd>Ctrl</kbd>+<kbd>D</kbd> nhân bản<br>
      <kbd>Ctrl</kbd>+<kbd>Z</kbd>/<kbd>Y</kbd> hoàn tác/làm lại · <kbd>Esc</kbd> huỷ<br>
      <kbd>Space</kbd>+kéo hoặc chuột phải để cuộn · <kbd>Alt</kbd> tắt bắt điểm
    </div>`;
  bindInputs(el, (k, v) => store.commit((pl) => (pl.settings[k] = v)));
  el.querySelectorAll('[data-style]').forEach((b) => (b.onclick = () => applyStyle(b.dataset.style)));
  el.querySelectorAll('[data-pal]').forEach((inp) => bindColor(inp, (v) => { st.palette ||= {}; st.palette[inp.dataset.pal] = v; }));
  el.querySelectorAll('[data-flag]').forEach((inp) => (inp.onchange = () => store.commit((pl) => { pl.settings.palette ||= {}; pl.settings.palette[inp.dataset.flag] = inp.checked; })));
  el.querySelector('[data-curtains]').onchange = (e) => store.commit((pl) => (pl.settings.curtains = e.target.checked));
  bindActions(el, {
    resetpal: () => store.commit((pl) => (pl.settings.palette = {})),
    viewload: () => $('#fileView').click(),
    viewclear: () => { setView(null); renderProps(); },
  });
  el.querySelectorAll('[data-view]').forEach((inp) => {
    const k = inp.dataset.view;
    inp.addEventListener(inp.type === 'range' ? 'input' : 'change', () => {
      viewState[k] = inp.type === 'range' || inp.type === 'number' ? +inp.value : inp.value;
      setView(viewState, k === 'kind' ? 'reload' : 'apply');
      if (k === 'kind') renderProps();
    });
  });
  el.querySelectorAll('[data-room]').forEach((b) => (b.onclick = () => editor.select({ kind: 'room', id: b.dataset.room })));
}

function bindInputs(el, apply, text = false) {
  el.querySelectorAll('[data-k]').forEach((inp) => {
    inp.addEventListener('change', () => {
      const raw = inp.value;
      const isText = inp.type === 'text' || inp.tagName === 'SELECT';
      const v = isText ? raw : parseFloat(raw);
      if (!isText && !isFinite(v)) return;
      apply(inp.dataset.k, v);
    });
  });
  void text;
}
/** Ô chọn màu: xem trước trực tiếp khi kéo, 1 bước hoàn tác cho mỗi lần chọn */
function bindColor(inp, apply) {
  if (!inp) return;
  let started = false;
  inp.addEventListener('input', () => {
    if (!started) { store.checkpoint(); started = true; }
    apply(inp.value);
    store.changed('drag');
  });
  inp.addEventListener('change', () => { started = false; apply(inp.value); store.changed('color'); });
}

function applyStyle(key) {
  const st = STYLES[key];
  store.commit((pl) => {
    pl.settings.style = key;
    pl.settings.palette = {};
    for (const r of pl.rooms) r.floor = st.floors[roomKind(r.name)] || r.floor;
    for (const f of pl.furniture) delete f.color;
  });
  toast(`Đã áp dụng phong cách “${st.name}”`);
}

// ---------- View ngoài trời ----------
let viewState = null;
try { viewState = JSON.parse(localStorage.getItem('floorplan3d.view') || 'null'); } catch { viewState = null; }
function setView(v, how = 'reload') {
  viewState = v;
  try { localStorage.setItem('floorplan3d.view', JSON.stringify(v)); } catch { /* ảnh quá lớn để lưu */ }
  if (how === 'reload') viewer.setExterior(v);
  else { viewer.exterior = v; viewer.applyExterior(); }
}
if (viewState) viewer.setExterior(viewState);

function bindActions(el, map) {
  el.querySelectorAll('[data-a]').forEach((b) => (b.onclick = () => map[b.dataset.a]?.()));
}
function addOpening(w, type) {
  const def = type === 'door' ? { width: 0.9, height: 2.1, sill: 0 } : { width: 1.2, height: 1.3, sill: 0.9 };
  const op = { id: uid(), wallId: w.id, type, t: 0.5, ...def, width: Math.min(def.width, wallLength(w) - 0.1) };
  store.commit((pl) => pl.openings.push(op));
  editor.select({ kind: 'opening', id: op.id });
}
renderProps();

// ---------- Thanh công cụ trên ----------
$('#undo').onclick = () => { store.undo(); editor.validateSelection(); };
$('#redo').onclick = () => { store.redo(); editor.validateSelection(); };
$('#template').onchange = async (e) => {
  const v = e.target.value;
  e.target.value = '';
  if (!v) return;
  if (store.plan.walls.length && !(await ask('Thay bản vẽ hiện tại bằng mẫu? Có thể hoàn tác bằng Ctrl+Z.', { ok: 'Thay bằng mẫu' }))) return;
  editor.select(null);
  store.load(v === 'luxury' ? luxuryPlan() : v === 'sample' ? samplePlan() : v === 'studio' ? studioPlan() : emptyPlan());
  if (v === 'empty') { editor.setTool('room'); toast('Kéo chuột để vẽ phòng đầu tiên, hoặc tải ảnh mặt bằng để tự nhận diện.'); }
};
$('#save').onclick = () => download(new Blob([JSON.stringify(store.plan, null, 2)], { type: 'application/json' }), 'mat-bang.json');
$('#open').onclick = () => $('#fileJson').click();
$('#fileJson').onchange = async (e) => {
  const file = e.target.files[0];
  e.target.value = '';
  if (!file) return;
  try {
    const plan = JSON.parse(await file.text());
    if (!Array.isArray(plan.walls)) throw new Error('sai định dạng');
    plan.openings ||= []; plan.rooms ||= []; plan.furniture ||= [];
    plan.settings = { wallHeight: 2.8, wallThickness: 0.2, ...(plan.settings || {}) };
    editor.select(null);
    store.load(plan);
    toast('Đã mở ' + file.name);
  } catch (err) {
    toast('Không đọc được file: ' + err.message);
  }
};
$('#shot').onclick = async () => {
  const url = viewer.screenshot();
  const blob = await (await fetch(url)).blob();
  download(blob, 'nha-3d.png');
};
$('#glb').onclick = async () => {
  toast('Đang xuất mô hình…');
  try {
    const buf = await viewer.exportGLB();
    download(new Blob([buf], { type: 'model/gltf-binary' }), 'nha-3d.glb');
    toast('Đã xuất nha-3d.glb');
  } catch (err) {
    toast('Xuất GLB lỗi: ' + err.message);
  }
};
function download(blob, name) {
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = name;
  a.click();
  setTimeout(() => URL.revokeObjectURL(a.href), 2000);
}

// ---------- Ảnh nền mặt bằng ----------
$('#bgLoad').onclick = () => $('#fileImg').click();
$('#fileImg').onchange = (e) => {
  const file = e.target.files[0];
  e.target.value = '';
  if (!file) return;
  const reader = new FileReader();
  reader.onload = () => {
    const img = new Image();
    img.onload = () => {
      // Mặc định coi chiều ngang ảnh ≈ 12 m, người dùng hiệu chỉnh lại bằng công cụ Tỉ lệ
      store.background = { src: reader.result, x: 0, y: 0, mpp: 12 / img.width, opacity: +$('#bgOpacity').value, calibrated: false };
      editor.loadBackground();
      editor.view.scale = Math.min(editor.canvas.clientWidth / 14, editor.canvas.clientHeight / (img.height * 12 / img.width + 2));
      editor.view.ox = 40; editor.view.oy = 40;
      store.save();
      toast('Đã tải ảnh. Bấm “✨ Tự nhận diện” hoặc dùng “📏 Tỉ lệ” để khai báo kích thước thật rồi vẽ đè lên.', 5000);
    };
    img.src = reader.result;
  };
  reader.readAsDataURL(file);
};
$('#bgOpacity').oninput = (e) => { if (store.background) { store.background.opacity = +e.target.value; editor.render(); } };
$('#bgOpacity').onchange = () => store.save();
$('#bgCalib').onclick = () => { if (!store.background) return toast('Hãy tải ảnh mặt bằng trước.'); editor.setTool('calibrate'); };
$('#bgMove').onclick = () => { if (!store.background) return toast('Hãy tải ảnh mặt bằng trước.'); editor.setTool('movebg'); };
$('#bgClear').onclick = () => { store.background = null; editor.loadBackground(); store.save(); };
editor.addEventListener('calibrate', async (e) => {
  const [p1, p2] = e.detail;
  const measured = Math.hypot(p2.x - p1.x, p2.y - p1.y);
  const ans = await ask(`Đoạn vừa chọn dài ${measured.toFixed(2)} m theo tỉ lệ hiện tại. Nhập chiều dài thực (mét):`, { input: measured.toFixed(2), ok: 'Áp dụng tỉ lệ' });
  const real = parseFloat(String(ans).replace(',', '.'));
  if (!ans || !isFinite(real) || real <= 0) { editor.setTool('select'); return; }
  const bg = store.background;
  const k = real / measured;
  // Giữ điểm thứ nhất cố định khi đổi tỉ lệ
  bg.x = p1.x - (p1.x - bg.x) * k;
  bg.y = p1.y - (p1.y - bg.y) * k;
  bg.mpp *= k;
  bg.calibrated = true;
  store.save();
  editor.setTool('select');
  editor.render();
  toast(`Đã hiệu chỉnh: 1 pixel ảnh = ${(bg.mpp * 100).toFixed(2)} cm`);
});
/** Đọc số kích thước: "9630" (mm) hoặc "9.63" / "9,63" (m) → mét */
const toMeters = (v) => {
  const n = parseFloat(String(v || '').replace(/\s/g, '').replace(',', '.'));
  if (!isFinite(n) || n <= 0) return null;
  return n > 100 ? n / 1000 : n;
};

/** Đặt tên phòng theo diện tích và gán sàn theo phong cách hiện tại */
function nameRooms(rooms, style) {
  const sorted = rooms.slice().sort((a, b) => polygonArea(b.points) - polygonArea(a.points));
  let bed = 0, wc = 0;
  sorted.forEach((r, i) => {
    const a = polygonArea(r.points);
    if (i === 0 && a > 14) r.name = 'Phòng khách & bếp';
    else if (a < 6.5) r.name = `WC ${String(++wc).padStart(2, '0')}`;
    else r.name = `Phòng ngủ ${++bed}`;
    r.floor = STYLES[style]?.floors[roomKind(r.name)] || r.floor;
  });
  return rooms;
}

$('#detect').onclick = async () => {
  if (!editor.bgImage) return toast('Hãy tải ảnh mặt bằng căn hộ trước (ảnh rõ nét, tường tô đậm cho kết quả tốt nhất).', 4000);
  const dims = await ask('Nhập kích thước tổng ghi trên bản vẽ (đường kích thước ngoài cùng, mm hoặc m). Bản vẽ minh hoạ thường không đúng tỉ lệ, nên nhập cả hai chiều để chính xác. Để trống nếu bản vẽ không ghi.', {
    inputs: [{ label: 'Chiều ngang', placeholder: 'vd. 9630' }, { label: 'Chiều dọc', placeholder: 'vd. 6545' }],
    ok: 'Nhận diện',
  });
  if (dims === null) return;
  const [wM, hM] = dims.map(toMeters);
  const bg = store.background;
  const res = detectWalls(editor.bgImage, bg, { targetWidthM: wM, targetHeightM: hM });
  if (!res.walls.length) return toast(res.message || 'Không nhận diện được tường.');
  if (wM || hM) Object.assign(bg, { x: 0, y: 0, mpp: res.mpp, mppY: res.mppY, calibrated: true });
  else if (res.autoScale) { bg.mpp = res.mpp; delete bg.mppY; bg.calibrated = false; }
  editor.loadBackground();
  editor.select(null);
  const replace = !store.plan.walls.length || (await ask(`${res.message} Thay thế bản vẽ hiện có, hay thêm vào?`, { ok: 'Thay thế', cancel: 'Thêm vào' }));
  let roomCount = 0;
  store.commit((pl) => {
    if (replace) { pl.walls = []; pl.openings = []; pl.rooms = []; pl.furniture = []; }
    pl.walls.push(...res.walls);
    pl.openings.push(...res.openings);
    if (replace) { pl.rooms = nameRooms(detectRooms(pl), pl.settings.style); roomCount = pl.rooms.length; }
  });
  store.save();
  editor.fit();
  toast(`${res.message} Tạo ${roomCount} phòng. Kiểm tra lại trên ảnh nền: kéo tường, thêm tường/cửa còn thiếu, đổi tên phòng.` + (res.autoScale ? ' Tỉ lệ đang ước lượng theo tường dày 20 cm.' : ''), 8000);
};
$('#autoRooms').onclick = () => {
  const rooms = detectRooms(store.plan);
  if (!rooms.length) return toast('Không tìm thấy vùng tường khép kín nào.');
  store.commit((pl) => (pl.rooms = nameRooms(rooms, pl.settings.style)));
  toast(`Đã tạo ${rooms.length} phòng. Nhấp vào từng phòng để đặt tên và chọn vật liệu sàn.`, 4000);
};

$('#fileView').onchange = (e) => {
  const file = e.target.files[0];
  e.target.value = '';
  if (!file) return;
  const reader = new FileReader();
  reader.onload = () => {
    const img = new Image();
    img.onload = () => {
      // Ảnh tỉ lệ 2:1 gần như chắc chắn là ảnh 360° equirectangular
      const pano = Math.abs(img.width / img.height - 2) < 0.15;
      setView({ src: reader.result, kind: pano ? 'pano' : 'photo', heading: 0, floor: viewState?.floor || 10, fov: 110 });
      renderProps();
      toast(pano ? 'Đã nhận ảnh 360°. Bấm “🚶 Đi bộ” để đứng trong nhà nhìn ra.' : 'Đã đặt ảnh view quanh căn hộ. Chỉnh “Hướng” để khớp với lô-gia.', 5000);
    };
    img.src = reader.result;
  };
  reader.readAsDataURL(file);
};

// ---------- Zoom 2D ----------
$('#zoomIn').onclick = () => editor.zoom(1.25);
$('#zoomOut').onclick = () => editor.zoom(0.8);
$('#zoomFit').onclick = () => editor.fit();
$('#dims').onchange = (e) => { editor.showDims = e.target.checked; editor.render(); };

// ---------- Điều khiển 3D ----------
$$('[data-view]').forEach((b) => (b.onclick = () => viewer.setView(b.dataset.view)));
$('#replay').onclick = () => viewer.playBuild();
const fmtHour = (h) => `${String(Math.floor(h)).padStart(2, '0')}:${String(Math.round((h % 1) * 60)).padStart(2, '0')}`;
$('#hour').oninput = (e) => { const h = +e.target.value; $('#hourLabel').textContent = fmtHour(h); viewer.setHour(h); };
$('#cut').oninput = (e) => viewer.setOption('cut', +e.target.value);
$('#optLabels').onchange = (e) => viewer.setOption('labels', e.target.checked);
$('#optCeiling').onchange = (e) => viewer.setOption('ceiling', e.target.checked);
$('#optLand').onchange = (e) => viewer.setOption('landscape', e.target.checked);
$('#optAO').onchange = (e) => viewer.setOption('ao', e.target.checked);
$('#optRotate').onchange = (e) => viewer.setOption('autoRotate', e.target.checked);
$('#optLights').onchange = (e) => viewer.setOption('lights', e.target.value);
let doorsOpen = false;
$('#doors').onclick = () => { doorsOpen = !doorsOpen; viewer.openAllDoors(doorsOpen); $('#doors').textContent = doorsOpen ? '🚪 Đóng tất cả cửa' : '🚪 Mở tất cả cửa'; };
$('#walk').onclick = () => {
  $('#pane3d').classList.add('walking');
  viewer.enterWalk();
};
viewer.onWalkUnlock = () => {
  $('#pane3d').classList.remove('walking');
  viewer.exitWalk();
};

$('#real').onclick = () => {
  if (viewer.ptActive) { viewer.stopRealRender(); return; }
  $('#real').classList.add('active');
  $('#ptStatus').style.display = 'block';
  $('#ptStatus').textContent = 'Đang chuẩn bị cảnh…';
  setTimeout(() => {
    try { viewer.startRealRender(); }
    catch (err) { console.error(err); toast('Trình duyệt không hỗ trợ render chân thực: ' + err.message, 5000); viewer.stopRealRender(); }
  }, 30);
};
viewer.onPTProgress = (n) => { $('#ptStatus').textContent = `📸 Render ánh sáng thật · ${Math.floor(n)} lượt mẫu${n < 60 ? ' (đợi ảnh mịn dần…)' : ' ✓'}`; };
viewer.onPTStop = () => { $('#real').classList.remove('active'); $('#ptStatus').style.display = 'none'; };

// ---------- Bóc tách & dự toán ----------
function renderEstimate() {
  const est = computeEstimate(store.plan);
  const st = store.plan.settings;
  $('#estSub').textContent = `${est.styleName} · ${est.area.toFixed(1)} m² sàn · đơn giá tham khảo thị trường, nhấp vào đơn giá để sửa`;
  $('#estOpts').innerHTML = `
    <label>Hệ số phong cách <input type="number" step="0.05" min="0.5" id="estFactor" value="${est.factor}" /></label>
    <label>Dự phòng phát sinh (%) <input type="number" step="1" min="0" id="estCont" value="${est.contingency}" /></label>
    <label>VAT (%) <input type="number" step="1" min="0" id="estVat" value="${est.vat}" /></label>
    <div class="esttotal"><small>Tổng dự toán</small><b>${vnd(est.total)} đ</b><small>≈ ${vnd(est.total / Math.max(1, est.area))} đ/m² sàn</small></div>`;
  let html = '<table><thead><tr><th>Hạng mục</th><th>ĐVT</th><th class="n">Khối lượng</th><th class="n">Đơn giá (đ)</th><th class="n">Thành tiền (đ)</th><th>Ghi chú</th></tr></thead><tbody>';
  for (const s of est.sections) {
    if (!s.rows.length) continue;
    html += `<tr class="sec"><td colspan="4">${s.title}</td><td class="n">${vnd(s.total)}</td><td></td></tr>`;
    for (const r of s.rows) html += `<tr><td>${r.name}</td><td>${r.unit}</td><td class="n">${r.qty.toLocaleString('vi-VN')}</td><td class="n"><input type="number" step="10000" min="0" data-price="${r.key}" value="${r.price}" /></td><td class="n">${vnd(r.amount)}</td><td class="note">${r.note || ''}</td></tr>`;
  }
  html += `</tbody><tfoot>
    <tr><td colspan="4">Cộng (đã nhân hệ số phong cách × ${est.factor})</td><td class="n">${vnd(est.sub)}</td><td></td></tr>
    <tr><td colspan="4">Dự phòng phát sinh ${est.contingency}%</td><td class="n">${vnd(est.cont)}</td><td></td></tr>
    <tr><td colspan="4">Thuế VAT ${est.vat}%</td><td class="n">${vnd(est.tax)}</td><td></td></tr>
    <tr class="grand"><td colspan="4">TỔNG CỘNG</td><td class="n">${vnd(est.total)}</td><td></td></tr></tfoot></table>
    <p class="hint">Khối lượng được bóc tách tự động từ mặt bằng: sàn theo vật liệu từng phòng (+5% hao hụt), sơn tường theo diện tích thực đã trừ cửa, trần, len chân tường, đèn, cửa, rèm, vách lam và đồ nội thất theo từng phòng. Đơn giá chỉ mang tính tham khảo – hãy cập nhật theo báo giá nhà cung cấp.</p>`;
  $('#estBody').innerHTML = html;
  $$('#estBody [data-price]').forEach((inp) => (inp.onchange = () => {
    const v = parseFloat(inp.value);
    if (!isFinite(v)) return;
    store.commit((pl) => { pl.settings.prices = { ...(pl.settings.prices || {}), [inp.dataset.price]: v }; });
  }));
  const setNum = (id, key) => ($(id).onchange = (e) => { const v = parseFloat(e.target.value); if (isFinite(v)) store.commit((pl) => (pl.settings[key] = v)); });
  setNum('#estFactor', 'styleFactor'); setNum('#estCont', 'contingency'); setNum('#estVat', 'vat');
  void st; void STYLE_FACTOR;
}
$('#estimateBtn').onclick = () => { $('#estimate').hidden = false; renderEstimate(); };
$('#estClose').onclick = () => ($('#estimate').hidden = true);
$('#estimate').onclick = (e) => { if (e.target.id === 'estimate') $('#estimate').hidden = true; };
$('#estCsv').onclick = () => download(new Blob([estimateCSV(computeEstimate(store.plan))], { type: 'text/csv;charset=utf-8' }), 'du-toan-noi-that.csv');
$('#estPrint').onclick = () => window.print();
$('#estReset').onclick = () => store.commit((pl) => { pl.settings.prices = {}; delete pl.settings.styleFactor; });
store.addEventListener('change', (e) => { if (!$('#estimate').hidden && e.detail !== 'drag') renderEstimate(); });
void DEFAULT_PRICES;

// Lần đầu mở: phát hiệu ứng dựng nhà
setTimeout(() => viewer.playBuild(), 300);
window.__app = { store, editor, viewer };
