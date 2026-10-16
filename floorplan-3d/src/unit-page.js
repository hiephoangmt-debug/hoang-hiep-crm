// Trang xem căn hộ cho khách: chọn loại căn → 2D (ảnh gốc) / 3D (phối cảnh, đổi phong cách, ngày/đêm) / 4D (tham quan tự động).
import { Viewer3D } from './viewer3d.js';
import { STYLES, roomKind } from './styles.js';
import { polygonArea } from './geom.js';
import { toast, READONLY, linkTo, download, isStaleChunkError, reloadForUpdate } from './ui.js';
import UNITS from './units/units.json';
import { AD_FOOTER } from './adcopy.js';

// Diện tích pháp lý theo bảng chủ đầu tư (căn đại diện của từng loại): [tim, thông thủy, sân vườn tim, sân vườn thông thủy]
const OFFICIAL = {
  '3pn': [94.3, 87.0], '2pn-a': [70.1, 64.0], '2pn-b': [65.5, 59.6], '1pn-plus': [52.4, 48.4], '1pn-plus-b': [58.1, 53.5],
  '2pn-1wc': [66.3, 61.6], '1pn': [36.8, 32.6], studio: [33.7, 30.4], 'studio-b': [37.8, 33.7],
  'sv-3pn': [94.3, 87.0, 56.9, 47.6], 'sv-2pn-a': [70.1, 63.7, 24.7, 20.0], 'sv-2pn-2wc': [65.5, 59.6, 12.4, 9.3],
  'sv-1pn-plus-l': [52.4, 48.4, 19.2, 15.9], 'sv-1pn-plus': [58.1, 53.5, 13.5, 10.3], 'sv-2pn-1wc': [66.3, 61.6, 21.5, 18.2],
  'sv-1pn': [36.8, 32.9, 6.2, 5.0], 'sv-studio': [33.7, 30.4, 10.9, 8.0], 'sv-studio-b': [37.8, 33.7, 12.2, 9.8],
};

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

function renderUnitList() {
  $('#units').innerHTML = UNITS.map((u) => `
    <button class="up-unit" data-unit="${u.id}">
      <img src="./units/${u.id}.webp" alt="" loading="lazy" />
      <span><b>${u.name}</b><small>${u.type} · ${fmt(u.dims[0], 2)} × ${fmt(u.dims[1], 2)} m</small></span>
    </button>`).join('');
  $$('[data-unit]').forEach((b) => (b.onclick = () => selectUnit(b.dataset.unit)));
}

function selectUnit(id) {
  unit = UNITS.find((u) => u.id === id) || UNITS[0];
  $$('[data-unit]').forEach((b) => b.classList.toggle('active', b.dataset.unit === unit.id));
  try { history.replaceState(null, '', '#' + unit.id); } catch { /* bỏ qua */ }
  store.plan = JSON.parse(JSON.stringify(unit.plan));
  if (viewer?.state.ad) applyStyle('green');
  $('#planImg').src = `./units/${unit.id}.webp`;
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
    <div class="kv">
      <div><small>Loại căn</small><b>${unit.type}</b></div>
      <div><small>Kích thước</small><b>${fmt(unit.dims[0], 2)} × ${fmt(unit.dims[1], 2)} m</b></div>
      <div><small>Phòng ngủ</small><b>${beds}</b></div>
      <div><small>WC</small><b>${wcs}</b></div>
    </div>
    <div><small class="up-note">Các phòng (bấm để xem trong 3D)</small>
      <div class="up-rooms">${rooms.map((r, i) => `<button data-room="${i}"><span>${r.name}</span><small>${fmt(polygonArea(r.points))} m²</small></button>`).join('')}</div>
    </div>
    ${OFFICIAL[unit.id] ? `<div class="kv">
      <div><small>DT tim tường</small><b>${fmt(OFFICIAL[unit.id][0])} m²</b></div>
      <div><small>DT thông thủy</small><b>${fmt(OFFICIAL[unit.id][1])} m²</b></div>
      ${OFFICIAL[unit.id][2] ? `<div><small>🌳 Sân vườn tim</small><b>${fmt(OFFICIAL[unit.id][2])} m²</b></div><div><small>🌳 Sân vườn thông thủy</small><b>${fmt(OFFICIAL[unit.id][3])} m²</b></div>` : ''}
    </div>` : ''}
    <p class="up-note">Diện tích theo bảng của chủ đầu tư (căn đại diện; diện tích sân vườn khác nhau theo tầng – xem chính xác trong Bảng hàng tòa nhà). Tổng các phòng đo trên hình vẽ (tính tới tim tường): ${fmt(total)} m².</p>
    <p class="up-note">Hình ảnh và diện tích mang tính minh hoạ, dựng từ mặt bằng bán hàng. Thông số chính thức theo hợp đồng mua bán.</p>
    ${READONLY ? '' : '<button id="openDesign">✏️ Mở căn này trong công cụ thiết kế</button>'}`;
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
    lines: [unit.type, `${fmt(unit.dims[0], 2)} × ${fmt(unit.dims[1], 2)} m`, ...(OFFICIAL[unit.id] ? [`Tim ${fmt(OFFICIAL[unit.id][0])} m² · Thông thủy ${fmt(OFFICIAL[unit.id][1])} m²`, OFFICIAL[unit.id][2] ? `Sân vườn ${fmt(OFFICIAL[unit.id][3])} m² TT` : ''] : [`Tổng DT các phòng ${fmt(total)} m²`, garden ? `Sân vườn ${fmt(garden)} m²` : '']), STYLES[store.plan.settings.style]?.name || ''].filter(Boolean),
  });
  download(blob, `${unit.id}-${mode === 'plan' ? 'mat-bang' : 'phoi-canh'}.png`);
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
  download(blob, `${unit.id}-quang-cao.png`);
  toast('Đã tải ảnh quảng cáo 5:6. Mẹo: bấm 📸 Chụp ảnh như thật, chờ ảnh mịn rồi tải để có ảnh đẹp nhất.', 6000);
};
$('#saveBtn').onclick = () => saveImage('plan');
$('#saveViewBtn').onclick = () => saveImage('view');
$('#walkBtn').onclick = () => { document.body.classList.add('walking-page'); viewer.enterWalk(); };
$('#tourBtn').onclick = () => (viewer.tour ? viewer.stopTour() : startTour());
$('#tourAgain').onclick = () => startTour();

renderUnitList();
const fromHash = location.hash.slice(1);
selectUnit(UNITS.some((u) => u.id === fromHash) ? fromHash : '3pn');

document.querySelectorAll('[data-link]').forEach((a) => (a.href = linkTo(a.dataset.link)));
