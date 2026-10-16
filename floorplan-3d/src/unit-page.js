// Trang xem căn hộ cho khách: chọn loại căn → 2D (ảnh gốc) / 3D (phối cảnh, đổi phong cách, ngày/đêm) / 4D (tham quan tự động).
import { Viewer3D } from './viewer3d.js';
import { STYLES, roomKind } from './styles.js';
import { polygonArea } from './geom.js';
import { toast, READONLY, linkTo, download, isStaleChunkError, reloadForUpdate } from './ui.js';
import UNITS from './units/units.json';
import { AD_FOOTER } from './adcopy.js';
import { DEFAULT_UNIT, GARDEN_UNIT, gardenOf, SLOT_LIST, SLOT_ORIENT, SHOPS, PROVISIONAL, areaOf, residentialFloors } from './buildingData.js';
import { orientPlan } from './unitPlacement.js';
import { gardenUnit } from './gardenUnit.js';

/** Mã căn (vị trí trên mặt bằng tầng) dùng mẫu này – để dễ nhận diện */
function codesOf(id) {
  const base = Object.entries(GARDEN_UNIT).find(([, sv]) => sv === id)?.[0];
  const slots = Object.entries(DEFAULT_UNIT).filter(([, u]) => u === (base || id)).map(([k]) => k);
  if (!slots.length) return '';
  if (!base) return `Căn ${slots.join(' · ')}`;
  // căn sân vườn: chỉ các căn có sân theo bảng, ghi tầng có sân
  const FL = ['03', '03A', '05', '06', '07'], groups = {};
  for (const k of slots) {
    const fl = FL.filter((f) => gardenOf(f, k));
    if (!fl.length) continue;
    const label = fl.length === 1 ? `tầng ${fl[0].replace(/^0/, '')}` : `tầng ${fl[0].replace(/^0/, '')}–${fl[fl.length - 1].replace(/^0/, '')}`;
    (groups[label] ||= []).push(k);
  }
  return 'Căn ' + Object.entries(groups).map(([lb, ks]) => `${ks.join(' · ')} (${lb})`).join(' · ');
}

// Diện tích pháp lý theo bảng chủ đầu tư (căn đại diện của từng loại): [tim, thông thủy, sân vườn tim, sân vườn thông thủy]
const OFFICIAL = {
  '3pn': [94.3, 87.0], '2pn-a': [70.1, 64.0], '2pn-b': [65.5, 59.6], '1pn-plus': [65.5, 59.6], '1pn-plus-c': [55.4, 51.0], '1pn-plus-b': [58.1, 53.5],
  '2pn-1wc': [66.3, 61.6], '1pn': [36.8, 32.6], studio: [33.7, 30.4], 'studio-b': [37.8, 33.7],
  'sv-3pn': [94.3, 87.0, 56.9, 47.6], 'sv-2pn-a': [70.1, 63.7, 24.7, 20.0], 'sv-2pn-2wc': [65.5, 59.6, 12.4, 9.3],
  'sv-1pn-plus-l': [55.4, 51.0, 19.2, 15.9], 'sv-1pn-plus': [58.1, 53.5, 13.5, 10.3], 'sv-2pn-1wc': [66.3, 61.6, 21.5, 18.2],
  'sv-1pn': [36.8, 32.9, 6.2, 5.0], 'sv-studio': [33.7, 30.4, 10.9, 8.0], 'sv-studio-b': [37.8, 33.7, 12.2, 9.8],
};

const offOf = (u) => u.official || OFFICIAL[u.id];

// ---------- Từng mã căn 01 → 32: mặt bằng quay/lật đúng vị trí trên mặt bằng tầng, sân vườn theo diện tích từng tầng ----------
const fl = (f) => f.replace(/^0/, '');
const CODES = SLOT_LIST.map((s) => s.slot).filter((k) => DEFAULT_UNIT[k])
  .sort((a, b) => parseInt(a, 10) - parseInt(b, 10) || a.localeCompare(b));
/** Nhóm các tầng liền nhau có cùng diện tích căn + sân vườn */
function floorGroups(code) {
  const sl = SLOT_LIST.find((s) => s.slot === code);
  const apt2 = SHOPS.find((s) => s.floor === '02' && s.apt && s.slot === code);
  const rows = [...(apt2 ? [['02', { tim: apt2.tim, tt: apt2.tt }]] : []), ...residentialFloors(22).map((f) => [f, areaOf(f, sl)])]
    .map(([f, a]) => ({ f, a, g: gardenOf(f, code) }));
  const out = [];
  for (const r of rows) {
    const key = JSON.stringify([r.a, r.g]), last = out[out.length - 1];
    if (last?.key === key) last.floors.push(r.f); else out.push({ key, floors: [r.f], a: r.a, g: r.g });
  }
  for (const g of out) g.label = 'Tầng ' + (g.floors.length > 1 ? `${fl(g.floors[0])}–${fl(g.floors[g.floors.length - 1])}` : fl(g.floors[0]));
  return out;
}
const codeCache = new Map();
/** Căn theo mã + nhóm tầng (dựng sân vườn đúng diện tích, quay/lật theo vị trí) */
function codeUnit(code, gi) {
  const groups = floorGroups(code), grp = groups[gi] || groups[0];
  const key = code + '@' + grp.floors[0];
  if (codeCache.has(key)) return codeCache.get(key);
  const base = UNITS.find((u) => u.id === DEFAULT_UNIT[code]);
  const sv = grp.g && UNITS.find((u) => u.id === GARDEN_UNIT[base.id]);
  const src = sv?.gardenSpec ? gardenUnit(base, { id: sv.id, name: sv.name, type: sv.type, garden: { ...sv.gardenSpec, area: grp.g.tt } }) : base;
  const o = SLOT_ORIENT[code] || { k: 0, m: false };
  const dims = o.k % 2 ? [src.dims[1], src.dims[0]] : src.dims;
  const u = {
    ...src, id: `can-${code}@${grp.floors[0]}`, code, group: grp, groups, tpl: base.id, mirrored: o.m,
    name: `Căn ${code}${grp.g ? ' · BC sân vườn' : ''}`, dims, plan: orientPlan(src.plan, o),
    official: [grp.a.tim, grp.a.tt, ...(grp.g ? [grp.g.tim, grp.g.tt] : [])],
  };
  codeCache.set(key, u);
  return u;
}

const $ = (s) => document.querySelector(s);
const $$ = (s) => [...document.querySelectorAll(s)];
const fmt = (n, d = 1) => n.toLocaleString('vi-VN', { maximumFractionDigits: d, minimumFractionDigits: d });

// Kho dữ liệu tối giản mà trình xem 3D cần
const store = { plan: null, background: null, addEventListener() {}, changed() {} };
let unit = null;
let tab = '3d';
let viewer = null;
// Mặt cắt kiểu phối cảnh bán hàng: cắt tường ở 2 m, bỏ trần để nhìn rõ bố trí
const CUT_H = 2.4;
let section = true;
function applySection() {
  const H = viewer.built?.height || 2.8;
  viewer.state.cut = section ? (CUT_H - 0.25) / (H - 0.25) : 1;
  viewer.updateClip();
  $('#cutBtn')?.classList.toggle('active', section);
}

let listMode = 'code';
function renderUnitList() {
  const head = `<div class="up-mode"><button data-mode="code" class="${listMode === 'code' ? 'active' : ''}">Theo mã căn</button><button data-mode="type" class="${listMode === 'type' ? 'active' : ''}">Theo loại căn</button></div>`;
  if (listMode === 'code') {
    $('#units').innerHTML = head + CODES.map((k) => {
      const b = UNITS.find((u) => u.id === DEFAULT_UNIT[k]), gs = floorGroups(k), sv = gs.filter((g) => g.g);
      const typ = gs.find((g) => !g.g) || gs[0];
      return `<button class="up-unit" data-code="${k}">
      <img src="./units/${b.id}.webp" alt="" loading="lazy" />
      <span><b>Căn ${k}</b><small>${b.type} · Tim ${fmt(typ.a.tim)} m² · TT ${fmt(typ.a.tt)} m²</small>${sv.length ? `<small class="up-codes">🌳 Ban công sân vườn (BC): ${sv.map((g) => g.label.replace('Tầng ', 'T')).join(', ')}</small>` : ''}${PROVISIONAL.has(k) ? '<small class="up-codes">Mặt bằng tạm (chưa có bản vẽ riêng)</small>' : ''}</span>
    </button>`;
    }).join('');
    $$('[data-code]').forEach((b) => (b.onclick = () => selectCode(b.dataset.code)));
  } else {
    $('#units').innerHTML = head + UNITS.map((u) => `
    <button class="up-unit" data-unit="${u.id}">
      <img src="./units/${u.id}.webp" alt="" loading="lazy" />
      <span><b>${u.name}</b><small>${u.type} · ${fmt(u.dims[0], 2)} × ${fmt(u.dims[1], 2)} m</small>${codesOf(u.id) ? `<small class="up-codes">${codesOf(u.id)}</small>` : ''}</span>
    </button>`).join('');
    $$('[data-unit]').forEach((b) => (b.onclick = () => selectUnit(b.dataset.unit)));
  }
  $$('[data-mode]').forEach((b) => (b.onclick = () => { listMode = b.dataset.mode; renderUnitList(); markActive(); }));
}
function markActive() {
  $$('[data-unit]').forEach((b) => b.classList.toggle('active', b.dataset.unit === unit?.id));
  $$('[data-code]').forEach((b) => b.classList.toggle('active', b.dataset.code === unit?.code));
}
function selectCode(code, gi) {
  if (gi == null) { const gs = floorGroups(code); gi = Math.max(0, gs.findIndex((g) => !g.g)); }
  selectUnit(codeUnit(code, gi));
}

function selectUnit(id) {
  unit = typeof id === 'object' ? id : UNITS.find((u) => u.id === id) || UNITS[0];
  markActive();
  try { history.replaceState(null, '', '#' + unit.id); } catch { /* bỏ qua */ }
  store.plan = JSON.parse(JSON.stringify(unit.plan));
  if (viewer?.state.ad) applyStyle('green');
  $('#planImg').src = `./units/${unit.tpl || unit.id}.webp`;
  renderInfo();
  if (!viewer) {
    viewer = new Viewer3D($('#viewer'), store);
    viewer.state.people = false;
    viewer.state.labels = false;
    viewer.isoView = { az: -38, el: 52, k: 1.2 };
    viewer.state.realistic = true;
    viewer.setRealistic(true);
    viewer.setOption('landscape', false);
    viewer.onWalkUnlock = () => { document.body.classList.remove('walking-page'); viewer.exitWalk(); };
    viewer.onPTProgress = (n) => { $('#caption').hidden = false; $('#caption').innerHTML = `📸 Ảnh như thật<small>${n < 1 ? 'đang dựng ánh sáng, chờ vài giây…' : `${Math.floor(n)} lượt – ${n < 40 ? 'đứng yên để ảnh mịn dần…' : 'xong, bấm ⬇ Tải ảnh'}`}</small>`; };
    viewer.onPTStop = () => { $('#photoBtn').classList.remove('active'); $('#caption').hidden = true; };
  } else {
    if (viewer.ptActive) viewer.stopRealRender();
    viewer.stopTour?.();
    viewer.rebuild(true);
    viewer.frameAll(false);
  }
  applySection();
  viewer.setHour(viewer.state.ad ? 8.2 : 15);
  setTab(tab);
}

function renderInfo() {
  const rooms = store.plan.rooms.slice().sort((a, b) => polygonArea(b.points) - polygonArea(a.points));
  const isGarden = (r) => /sân vườn/i.test(r.name);
  const total = rooms.filter((r) => !isGarden(r)).reduce((s, r) => s + polygonArea(r.points), 0);
  const garden = rooms.filter(isGarden).reduce((s, r) => s + polygonArea(r.points), 0);
  const beds = rooms.filter((r) => /ngủ/i.test(r.name)).length;
  const wcs = rooms.filter((r) => /wc|tắm/i.test(r.name)).length;
  $('#info').innerHTML = `
    <h2>${unit.name}</h2>
    ${unit.code ? `<div><small class="up-note">Chọn tầng (tầng 2–7 có ban công sân vườn (BC); diện tích theo bảng từng tầng)</small>
      <div class="up-floors">${unit.groups.map((g, i) => `<button class="chip ${g === unit.group ? 'active' : ''}" data-grp="${i}">${g.label}${g.g ? ' 🌳' : ''}</button>`).join('')}</div>
      <p class="up-note">Mã căn: ${unit.group.floors.map((f) => `F2-${f}-${unit.code}`).slice(0, 3).join(', ')}${unit.group.floors.length > 3 ? '…' : ''}. Mặt bằng xoay${unit.mirrored ? ', lật đối xứng' : ''} đúng như vị trí căn trên mặt bằng tầng.${PROVISIONAL.has(unit.code) ? ' <b>Căn này chưa có bản vẽ riêng – đang ghép tạm mặt bằng 1PN.</b>' : ''}</p></div>` : ''}
    <div class="kv">
      <div><small>Loại căn</small><b>${unit.type}</b></div>
      ${!unit.code && codesOf(unit.id) ? `<div style="grid-column: span 2"><small>Mã căn (vị trí trên mặt bằng tầng)</small><b>${codesOf(unit.id).replace('Căn ', '')}</b></div>` : ''}
      <div><small>Kích thước</small><b>${fmt(unit.dims[0], 2)} × ${fmt(unit.dims[1], 2)} m</b></div>
      <div><small>Phòng ngủ</small><b>${beds}</b></div>
      <div><small>WC</small><b>${wcs}</b></div>
    </div>
    <div><small class="up-note">Các phòng (bấm để xem trong 3D)</small>
      <div class="up-rooms">${rooms.map((r, i) => `<button data-room="${i}"><span>${r.name}</span><small>${fmt(polygonArea(r.points))} m²</small></button>`).join('')}</div>
    </div>
    ${offOf(unit) ? `<div class="kv">
      <div><small>DT tim tường</small><b>${fmt(offOf(unit)[0])} m²</b></div>
      <div><small>DT thông thủy</small><b>${fmt(offOf(unit)[1])} m²</b></div>
      ${offOf(unit)[2] ? `<div><small>🌳 BC sân vườn – tim</small><b>${fmt(offOf(unit)[2])} m²</b></div><div><small>🌳 BC sân vườn – thông thủy</small><b>${fmt(offOf(unit)[3])} m²</b></div>` : ''}
    </div>` : ''}
    <p class="up-note">Diện tích theo bảng của chủ đầu tư (căn đại diện; diện tích sân vườn khác nhau theo tầng – xem chính xác trong Bảng hàng tòa nhà). Tổng các phòng đo trên hình vẽ (tính tới tim tường): ${fmt(total)} m².</p>
    <p class="up-note">Hình ảnh và diện tích mang tính minh hoạ, dựng từ mặt bằng bán hàng. Thông số chính thức theo hợp đồng mua bán.</p>
    ${READONLY ? '' : '<button id="openDesign">✏️ Mở căn này trong công cụ thiết kế</button>'}`;
  $$('[data-grp]').forEach((b) => (b.onclick = () => selectCode(unit.code, +b.dataset.grp)));
  $$('[data-room]').forEach((b) => (b.onclick = () => {
    if (tab !== '3d') setTab('3d');
    const shot = viewer.roomShot(rooms[+b.dataset.room]);
    viewer.state.cut = 1;
    viewer.updateClip();
    viewer.flyTo(shot.pos, shot.target);
  }));
  if ($('#openDesign')) $('#openDesign').onclick = () => {
    try { localStorage.setItem('floorplan3d.openUnit', JSON.stringify({ layout: store.plan, info: { code: unit.name, floor: '10', slot: { type: unit.type, tt: +total.toFixed(1) } } })); } catch { return toast('Không lưu được dữ liệu để chuyển trang.'); }
    location.href = './index.html';
  };
}

function applyStyle(key) {
  const st = STYLES[key];
  store.plan.settings.style = key;
  store.plan.settings.palette = {};
  // sân vườn giữ cỏ
  store.plan.rooms.forEach((r) => { if (!/sân vườn/i.test(r.name)) r.floor = st.floors[roomKind(r.name)] || r.floor; });
  renderStyles();
}

function renderStyles() {
  $('#styles').innerHTML = Object.entries(STYLES).slice(0, 6).map(([k, v]) => `<button class="chip ${store.plan?.settings.style === k ? 'active' : ''}" data-style="${k}" title="${v.desc}"><span class="sw">${[v.wall, v.palette.wood, v.palette.fabric].map((c) => `<i style="background:${c}"></i>`).join('')}</span>${v.name.replace(/ \(.*\)/, '')}</button>`).join('');
  $$('[data-style]').forEach((b) => (b.onclick = () => { applyStyle(b.dataset.style); viewer.rebuild(); }));
}

function setTab(t) {
  tab = t;
  $$('[data-tab]').forEach((b) => b.classList.toggle('active', b.dataset.tab === t));
  $('#view2d').hidden = t !== '2d';
  $('#view3d').hidden = t === '2d';
  $('#bar3d').hidden = t !== '3d';
  $('#bar4d').hidden = t !== '4d';
  $('#caption').hidden = true;
  $('#progress').hidden = t !== '4d';
  viewer.setActive(t !== '2d');
  if (t !== '4d') viewer.stopTour();
  if (t === '3d') { viewer.resize(); applySection(); viewer.frameAll(true); }
  if (t === '4d') startTour();
  renderStyles();
}

function startTour() {
  viewer.resize();
  $('#tourBtn').textContent = '⏹ Dừng';
  viewer.playTour({
    onCaption: (c) => {
      const [name, area] = c.split(' · ');
      $('#caption').innerHTML = `${name}${area ? `<small>${area}</small>` : ''}`;
      $('#caption').hidden = false;
    },
    onProgress: (p, h) => { $('#progress i').style.width = (p * 100).toFixed(1) + '%'; $('#caption').dataset.hour = h; },
    onDone: () => { $('#tourBtn').textContent = '▶ Tham quan'; },
  });
}

$$('[data-tab]').forEach((b) => (b.onclick = () => { if (viewer.ptActive) viewer.stopRealRender(); setTab(b.dataset.tab); }));
$('#view2d').onclick = () => $('#view2d').classList.toggle('zoom');
$('#dayBtn').onclick = () => { viewer.setHour(15); $('#dayBtn').classList.add('active'); $('#nightBtn').classList.remove('active'); };
$('#nightBtn').onclick = () => { viewer.setHour(20); $('#nightBtn').classList.add('active'); $('#dayBtn').classList.remove('active'); };
$('#topBtn').onclick = () => { applySection(); viewer.setView('top'); };
$('#cutBtn').onclick = () => { section = !section; applySection(); viewer.frameAll(true); };
$('#realBtn').onclick = () => {
  const on = !viewer.state.realistic;
  viewer.setRealistic(on);
  $('#realBtn').classList.toggle('active', on);
};
$('#photoBtn').onclick = () => {
  if (viewer.ptActive) { viewer.stopRealRender(); return; }
  $('#photoBtn').classList.add('active');
  $('#caption').hidden = false;
  $('#caption').innerHTML = 'Đang chuẩn bị ảnh như thật…';
  viewer.startRealRender().catch((err) => { viewer.stopRealRender(); $('#photoBtn').classList.remove('active'); if (isStaleChunkError(err) && reloadForUpdate()) return; toast('Máy này chưa hỗ trợ chụp ảnh như thật: ' + err.message, 5000); });
};
$('#labelBtn').onclick = () => {
  const on = !viewer.state.labels;
  viewer.setOption('labels', on);
  viewer._adKey = null;
  viewer.frameAll(true);
  $('#labelBtn').classList.toggle('active', on);
};
$('#peopleBtn').onclick = () => {
  const on = !viewer.state.people;
  viewer.setOption('people', on);
  $('#peopleBtn').classList.toggle('active', on);
};
$('#landBtn').onclick = () => {
  const on = !viewer.state.landscape;
  viewer.setOption('landscape', on);
  $('#landBtn').classList.toggle('active', on);
};
async function saveImage(mode) {
  const total = store.plan.rooms.filter((r) => !/sân vườn/i.test(r.name)).reduce((s, r) => s + polygonArea(r.points), 0);
  const garden = store.plan.rooms.filter((r) => /sân vườn/i.test(r.name)).reduce((s, r) => s + polygonArea(r.points), 0);
  const blob = await viewer.exportPNG({
    mode,
    dims: unit.dims,
    title: `${unit.name} · Tòa F2`,
    lines: [unit.type, `${fmt(unit.dims[0], 2)} × ${fmt(unit.dims[1], 2)} m`, ...(unit.code ? [unit.group.label] : []), ...(offOf(unit) ? [`Tim ${fmt(offOf(unit)[0])} m² · Thông thủy ${fmt(offOf(unit)[1])} m²`, offOf(unit)[2] ? `BC sân vườn ${fmt(offOf(unit)[3])} m² TT` : ''] : [`Tổng DT các phòng ${fmt(total)} m²`, garden ? `Sân vườn ${fmt(garden)} m²` : '']), STYLES[store.plan.settings.style]?.name || ''].filter(Boolean),
  });
  download(blob, `${unit.id.replace('@', '-tang-')}-${mode === 'plan' ? 'mat-bang' : 'phoi-canh'}.png`);
  toast(mode === 'plan' ? 'Đã tải ảnh mặt bằng (5:6, nhìn từ trên, kèm diện tích và dài × rộng từng phòng).' : 'Đã tải ảnh phối cảnh theo góc đang xem (5:6). Mẹo: bấm 📸 Chụp ảnh như thật, chờ ảnh mịn rồi tải để có ảnh đẹp nhất.', 6000);
}
// Kiểu quảng cáo: đế sách, phong cách gỗ & xanh rêu, nắng sáng xiên có bóng lá, chú thích cảm xúc
let adPrev = null;
function setAd(on) {
  if (on === !!viewer.state.ad) return;
  if (on) {
    adPrev = { style: store.plan.settings.style, hour: viewer.state.hour, labels: viewer.state.labels, iso: viewer.isoView };
    applyStyle('green');
    viewer.state.ad = true;
    viewer.state.labels = true;
    viewer.isoView = { az: -8, el: 62, k: 1.05 };
    viewer.rebuild();
    viewer.setHour(8.2);
  } else {
    viewer.state.ad = false;
    viewer.state.labels = adPrev?.labels ?? false;
    viewer.isoView = adPrev?.iso || viewer.isoView;
    applyStyle(adPrev?.style || 'warm');
    viewer.rebuild();
    viewer.setHour(adPrev?.hour ?? 15);
  }
  viewer.frameAll(true);
  $('#adBtn').classList.toggle('active', on);
  $('#saveAdBtn').hidden = !on;
}
$('#adBtn').onclick = () => setAd(!viewer.state.ad);
$('#saveAdBtn').onclick = async () => {
  const blob = await viewer.exportPNG({ mode: 'view', ad: AD_FOOTER, title: `${unit.name} · Tòa F2`, lines: [unit.type, `${fmt(unit.dims[0], 2)} × ${fmt(unit.dims[1], 2)} m`] });
  download(blob, `${unit.id.replace('@', '-tang-')}-quang-cao.png`);
  toast('Đã tải ảnh quảng cáo 5:6. Mẹo: bấm 📸 Chụp ảnh như thật, chờ ảnh mịn rồi tải để có ảnh đẹp nhất.', 6000);
};
$('#saveBtn').onclick = () => saveImage('plan');
$('#saveViewBtn').onclick = () => saveImage('view');
$('#walkBtn').onclick = () => { document.body.classList.add('walking-page'); viewer.enterWalk(); };
$('#tourBtn').onclick = () => (viewer.tour ? viewer.stopTour() : startTour());
$('#tourAgain').onclick = () => startTour();

renderUnitList();
const fromHash = decodeURIComponent(location.hash.slice(1));
const hc = /^can-([0-9AB]+)(?:@(\w+))?$/.exec(fromHash);
if (hc && CODES.includes(hc[1])) {
  const gs = floorGroups(hc[1]);
  const gi = gs.findIndex((g) => g.floors.includes(hc[2]));
  selectCode(hc[1], gi >= 0 ? gi : undefined);
} else if (UNITS.some((u) => u.id === fromHash)) { listMode = 'type'; renderUnitList(); selectUnit(fromHash); }
else selectCode('24');

document.querySelectorAll('[data-link]').forEach((a) => (a.href = linkTo(a.dataset.link)));
