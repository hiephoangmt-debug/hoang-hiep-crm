// Trang xem căn hộ cho khách: chọn loại căn → 2D (ảnh gốc) / 3D (phối cảnh, đổi phong cách, ngày/đêm) / 4D (tham quan tự động).
import { Viewer3D } from './viewer3d.js';
import { STYLES, roomKind } from './styles.js';
import { polygonArea } from './geom.js';
import { toast, READONLY, linkTo } from './ui.js';
import UNITS from './units/units.json';

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
    viewer.onPTProgress = (n) => { $('#caption').hidden = false; $('#caption').innerHTML = `📸 Ảnh như thật<small>${Math.floor(n)} lượt – ${n < 40 ? 'đứng yên để ảnh mịn dần…' : 'xong, có thể chụp màn hình'}</small>`; };
    viewer.onPTStop = () => { $('#photoBtn').classList.remove('active'); $('#caption').hidden = true; };
  } else {
    if (viewer.ptActive) viewer.stopRealRender();
    viewer.stopTour?.();
    viewer.rebuild(true);
    viewer.frameAll(false);
  }
  applySection();
  viewer.setHour(15);
  setTab(tab);
}

function renderInfo() {
  const rooms = store.plan.rooms.slice().sort((a, b) => polygonArea(b.points) - polygonArea(a.points));
  const total = rooms.reduce((s, r) => s + polygonArea(r.points), 0);
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
    <div class="kv"><div style="grid-column: span 2"><small>Tổng diện tích các phòng (đo trên bản vẽ)</small><b>${fmt(total)} m²</b></div></div>
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

function renderStyles() {
  $('#styles').innerHTML = Object.entries(STYLES).slice(0, 5).map(([k, v]) => `<button class="chip ${store.plan?.settings.style === k ? 'active' : ''}" data-style="${k}" title="${v.desc}"><span class="sw">${[v.wall, v.palette.wood, v.palette.fabric].map((c) => `<i style="background:${c}"></i>`).join('')}</span>${v.name.replace(/ \(.*\)/, '')}</button>`).join('');
  $$('[data-style]').forEach((b) => (b.onclick = () => {
    const st = STYLES[b.dataset.style];
    store.plan.settings.style = b.dataset.style;
    store.plan.settings.palette = {};
    store.plan.rooms.forEach((r) => (r.floor = st.floors[roomKind(r.name)] || r.floor));
    viewer.rebuild();
    renderStyles();
  }));
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
  viewer.startRealRender().catch((err) => { toast('Máy này chưa hỗ trợ chụp ảnh như thật: ' + err.message, 5000); viewer.stopRealRender(); });
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
$('#walkBtn').onclick = () => { document.body.classList.add('walking-page'); viewer.enterWalk(); };
$('#tourBtn').onclick = () => (viewer.tour ? viewer.stopTour() : startTour());
$('#tourAgain').onclick = () => startTour();

renderUnitList();
const fromHash = location.hash.slice(1);
selectUnit(UNITS.some((u) => u.id === fromHash) ? fromHash : '3pn');

document.querySelectorAll('[data-link]').forEach((a) => (a.href = linkTo(a.dataset.link)));
