// Giao diện chế độ Tòa nhà: bảng thống kê, bộ lọc, chi tiết căn. Dùng chung cho trang chính và trang toa-nha.html.
import { BuildingView, slotLayout } from './building3d.js';
import { READONLY } from './ui.js';
import { sampleBuilding, SLOT_LIST, STATUS, TYPE_COLORS, residentialFloors, unitCode, unitPrice, areaOf, PROVISIONAL, GARDEN_FLOORS, GARDEN_UNIT, SHOPS } from './buildingData.js';

const $ = (s) => document.querySelector(s);
const $$ = (s) => [...document.querySelectorAll(s)];
const B_KEY = 'floorplan3d.building';
let building;
try { building = JSON.parse(localStorage.getItem(B_KEY) || 'null'); } catch { building = null; }
building ||= sampleBuilding();
let bview = null, bsel = null, H = null, bFloorIdx = 7;
// Điện thoại: bảng điều khiển thu gọn mặc định để không che khung 3D
// Bảng điều khiển thu gọn sẵn để không che tòa nhà; bấm “Mở bảng” mới hiện
let panelCollapsed = true;
const saveBuilding = () => { try { localStorage.setItem(B_KEY, JSON.stringify(building)); } catch { /* bộ nhớ đầy */ } };
const bUnit = (key) => (building.units[key] ||= { status: 'available' });
const vndTy = (n) => n.toLocaleString('vi-VN', { maximumFractionDigits: 2 });

/**
 * Gắn giao diện tòa nhà vào trang. hooks: { toast, ask, download, getCurrentPlan, openUnit(layout, info) }
 * Trả về { view } để trang chủ có thể tạm dừng / chạy lại vòng vẽ.
 */
export function mountBuildingUI(hooks) {
  H = hooks;
  if (!bview) bview = new BuildingView($('#buildingView'), () => building, (sel) => { bsel = sel; renderBDetail(); }, { light: lightMode(), readonly: READONLY });
  renderBPanel();
  return bview;
}

const LIGHT_KEY = 'floorplan3d.light';
function lightMode() {
  try { const v = localStorage.getItem(LIGHT_KEY); if (v !== null) return v === '1'; } catch { /* không đọc được */ }
  // Mặc định nhẹ cho điện thoại / máy ít nhân
  return /Mobi|Android/i.test(navigator.userAgent) || (navigator.hardwareConcurrency || 8) <= 4;
}

function bStats() {
  const floors = residentialFloors(building.floors);
  const st = Object.fromEntries(Object.keys(STATUS).map((k) => [k, { n: 0, value: 0 }]));
  floors.forEach((fl, fi) => SLOT_LIST.forEach((sl) => {
    const s = building.units[`${fl}-${sl.slot}`]?.status || 'available';
    st[s].n++;
    st[s].value += unitPrice(building, fi, sl);
  }));
  for (const sh of SHOPS) {
    if (!sh.shop) continue;
    const s = building.units[`${sh.floor}-${sh.slot}`]?.status || 'available';
    st[s].n++;
    st[s].value += unitPrice(building, 0, sh);
  }
  return { st, total: floors.length * SLOT_LIST.length };
}

function renderBPanel() {
  const { st, total } = bStats();
  const floors = residentialFloors(building.floors);
  bFloorIdx = Math.max(0, Math.min(bFloorIdx, floors.length - 1));
  const f = bview?.filter.status;
  $('#bpanel').innerHTML = `
    <div class="bhead"><h3>🏢 ${building.name} · ${floors.length} tầng ở · ${total} căn</h3><button id="bToggle" class="btoggle" aria-expanded="${!panelCollapsed}">${panelCollapsed ? '▲ Mở bảng' : '▼ Thu gọn'}</button></div>
    <div class="bbody">
    ${READONLY ? '<p class="hint">Bấm vào từng căn để xem diện tích và mặt bằng 3D.</p>' : `${building.sample ? '<div class="sample">Trạng thái và giá đang là dữ liệu mẫu để minh hoạ. Nhấp vào từng căn để cập nhật.</div>' : ''}
    <div class="bstats">${Object.entries(STATUS).map(([k, v]) => `<button data-st="${k}" class="${f && !f.has(k) ? 'off' : ''}" title="Bấm để ẩn/hiện"><small><i class="dot" style="background:${v.color}"></i>${v.name}</small><b>${st[k].n}</b></button>`).join('')}</div>
    <div class="bmoney">Đã bán + đặt cọc: <b>${vndTy(st.sold.value + st.deposit.value)} tỷ</b><br>Giá trị hàng còn trống: <b>${vndTy(st.available.value)} tỷ</b></div>`}
    <div class="row"><button id="bViewP">🎥 Góc phối cảnh</button><button id="bViewC">🔍 Cận cảnh tòa</button></div>
    <h4>360° thực tế</h4>
    <button id="b360Site" class="primary">🛰 Xem tòa trên ảnh 360 khu đất</button>
    <div class="row"><button id="b360Tour">🌐 Tour 360 dự án</button>${READONLY ? '' : '<button id="b360Load" title="Ảnh 360° dạng equirectangular (tỉ lệ 2:1), ví dụ tải về từ Kuula hoặc ảnh flycam">🖼 Ghép tòa vào ảnh 360</button>'}</div>
    ${bview?.pano && !READONLY ? `<div class="pano">
      <label class="slider">Xoay ảnh <input type="range" id="pHeading" min="-180" max="180" step="1" value="${bview.pano.heading}" /></label>
      <label class="slider">Hướng nhìn <input type="range" id="pBearing" min="0" max="360" step="1" value="${bview.pano.bearing}" /></label>
      <label class="slider">Khoảng cách <input type="range" id="pDist" min="40" max="500" step="5" value="${bview.pano.dist}" /></label>
      <label class="slider">Độ cao flycam <input type="range" id="pAlt" min="2" max="250" step="1" value="${bview.pano.alt}" /></label>
      <label class="slider">Góc ống kính <input type="range" id="pFov" min="25" max="90" step="1" value="${bview.pano.fov}" /></label>
      <button id="pClear">✕ Bỏ ảnh 360, về cảnh dựng</button></div>` : ''}
    <input type="file" id="b360File" accept="image/*" hidden />
    <h4>Tô màu theo</h4>
    <div class="row seg">${[['status', 'Trạng thái'], ['type', 'Loại căn'], ['facade', 'Mặt đứng']].filter(([k]) => !READONLY || k !== 'status').map(([k, n]) => `<button data-color="${k}" class="${(bview?.colorBy || 'facade') === k ? 'active' : ''}">${n}</button>`).join('')}</div>
    ${bview?.colorBy === 'type' ? `<div class="row">${Object.entries(TYPE_COLORS).map(([k, c]) => `<small><i class="dot" style="background:${c}"></i> ${k}</small>`).join(' ')}</div>` : ''}
    <h4>Lọc loại căn</h4>
    <select id="bType"><option value="">Tất cả loại căn</option>${Object.keys(TYPE_COLORS).map((t) => `<option ${bview?.filter.type === t ? 'selected' : ''}>${t}</option>`).join('')}</select>
    <button id="bPlan" class="primary">🗺 Mặt bằng tầng chi tiết (3D)</button>
    <button id="bSave">⬇ Tải ảnh khung 3D (PNG)</button>
    <div class="row seg"><button data-shops="1" class="${bview?.shopsMode === 1 ? 'active' : ''}">🛍️ Shop tầng 1</button><button data-shops="2" class="${bview?.shopsMode === 2 ? 'active' : ''}">🏊 Tầng 2 + hồ bơi</button></div>
    ${bview?.shopsMode ? '<button data-shops="0">↩ Hiện lại cả tòa</button>' : ''}
    <h4>Ngắm theo cao độ tầng</h4>
    <label class="slider">Tầng <b id="bFloorLabel">${floors[bFloorIdx].replace(/^0/, '')}</b><input type="range" id="bFloorRange" min="0" max="${floors.length - 1}" step="1" value="${bFloorIdx}" /></label>
    <div class="row seg"><button id="bOrbit" class="${bview?.viewMode === 'orbit' ? 'active' : ''}">🔄 Xoay quanh tầng</button><button id="bLook" class="${bview?.viewMode === 'look' ? 'active' : ''}">🔭 Ngắm view từ tầng</button></div>
    ${bview?.viewMode ? '<button id="bViewReset">↩ Về toàn cảnh</button>' : ''}
    <p class="hint">Kéo thanh để lên / xuống tầng. “Ngắm view”: đứng ở mặt tiền nhìn ra, kéo chuột để nhìn quanh.</p>
    <h4>Mặt bằng tầng</h4>
    <select id="bFloor"><option value="">Cả tòa nhà</option>${floors.map((fl, i) => `<option value="${i}" ${bview?.onlyFloor === i ? 'selected' : ''}>Tầng ${fl.replace(/^0/, '')}</option>`).join('')}</select>
    ${READONLY ? '' : `<h4>Thông số tòa</h4>
    <label class="field"><span>Số tầng ở</span><input type="number" id="bFloors" min="1" max="60" value="${building.floors}" /></label>
    <label class="field"><span>Đơn giá (tr/m² TT)</span><input type="number" id="bPrice" min="1" step="0.5" value="${building.pricePerM2}" /></label>`}
    <label class="row"><input type="checkbox" id="bLight" ${bview?.light ? 'checked' : ''} /> Chế độ nhẹ (ít cây, nhà, tắt bóng đổ – cho máy yếu, điện thoại)</label>
    ${READONLY ? '' : '<div class="row"><button id="bCsv">⬇ Xuất bảng hàng (CSV)</button><button id="bReset" title="Tạo lại dữ liệu mẫu">↺ Dữ liệu mẫu</button></div>'}
    </div>`;
  $('#bpanel').classList.toggle('collapsed', panelCollapsed);
  $('#bToggle').onclick = () => { panelCollapsed = !panelCollapsed; renderBPanel(); };
  $$('#bpanel [data-st]').forEach((b) => (b.onclick = () => { const s = bview.filter.status; s.has(b.dataset.st) ? s.delete(b.dataset.st) : s.add(b.dataset.st); bview.rebuild(); renderBPanel(); }));
  $$('#bpanel [data-color]').forEach((b) => (b.onclick = () => { bview.colorBy = b.dataset.color; bview.rebuild(); renderBPanel(); }));
  $('#bLight').onchange = (e) => { try { localStorage.setItem(LIGHT_KEY, e.target.checked ? '1' : '0'); } catch { /* bỏ qua */ } bview.setLight(e.target.checked); };
  $('#bPlan').onclick = () => {
    const fi = bview.onlyFloor ?? Math.max(0, floors.indexOf('08'));
    bview.showFloorPlan(fi);
    renderBPanel();
  };
  $$('#bpanel [data-shops]').forEach((x) => (x.onclick = () => { bview.showShops(+x.dataset.shops); renderBPanel(); }));
  $('#bSave').onclick = async () => {
    const fl = bview.onlyFloor !== null ? `Mặt bằng tầng ${floors[bview.onlyFloor].replace(/^0/, '')}` : bview.shopsMode === 1 ? 'Shop tầng 1' : bview.shopsMode === 2 ? 'Tầng 2 – thương mại & hồ bơi' : 'Phối cảnh tòa nhà';
    const blob = await bview.exportPNG({ title: `${building.name} · ${fl}`, lines: [`${floors.length} tầng ở`, 'Four S Tower', 'Đường Nguyễn Phước Lan – Minh Mạng'] });
    H.download(blob, `toa-f2-${fl.toLowerCase().replace(/[^a-z0-9]+/gi, '-')}.png`);
  };
  $('#b360Tour').onclick = () => open360Tour();
  $('#b360Site').onclick = () => bview.showSitePano(renderBPanel);
  if ($('#b360Load')) $('#b360Load').onclick = () => $('#b360File').click();
  if ($('#b360File')) $('#b360File').onchange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    bview.setPano(url, renderBPanel);
    H.toast('Đã đặt ảnh 360 làm nền. Chỉnh “Xoay ảnh”, “Hướng nhìn”, “Khoảng cách”, “Độ cao” cho tòa nhà khớp với vị trí thực tế trong ảnh.', 7000);
  };
  for (const [id, key] of [['#pHeading', 'heading'], ['#pBearing', 'bearing'], ['#pDist', 'dist'], ['#pAlt', 'alt'], ['#pFov', 'fov']]) {
    const el = $(id);
    if (el) el.oninput = () => bview.applyPano({ [key]: +el.value });
  }
  if ($('#pClear')) $('#pClear').onclick = () => { bview.setPano(null); renderBPanel(); };
  $('#bViewP').onclick = () => bview.setView('perspective');
  $('#bViewC').onclick = () => bview.setView('close');
  $('#bType').onchange = (e) => { bview.filter.type = e.target.value || null; bview.rebuild(); };
  const fullTower = () => { if (bview.onlyFloor !== null) { bview.onlyFloor = null; bview.rebuild(); } };
  const applyFloor = () => {
    if (bview.viewMode === 'look') fullTower();
    if (bview.viewMode === 'look') bview.viewFromFloor(bFloorIdx, bview.lookSlot);
    else bview.orbitFloor(bFloorIdx);
  };
  $('#bFloorRange').oninput = (e) => {
    bFloorIdx = +e.target.value;
    $('#bFloorLabel').textContent = floors[bFloorIdx].replace(/^0/, '');
    if (!bview.viewMode) bview.viewMode = 'orbit';
    applyFloor();
  };
  $('#bOrbit').onclick = () => { bview.lookSlot = null; bview.orbitFloor(bFloorIdx); renderBPanel(); };
  $('#bLook').onclick = () => { bview.lookSlot = null; fullTower(); bview.viewFromFloor(bFloorIdx); renderBPanel(); };
  if ($('#bViewReset')) $('#bViewReset').onclick = () => { bview.resetFloorView(); renderBPanel(); };
  $('#bFloor').onchange = (e) => {
    if (e.target.value !== '') { bview.showFloorPlan(+e.target.value); return; }
    bview.onlyFloor = null;
    bview.rebuild();
    const y = building.podiumFloors * building.podiumHeight + ((bview.onlyFloor ?? floors.length) + 0.5) * building.floorHeight;
    bview.controls.target.set(0, bview.onlyFloor === null ? 30 : y, 0);
  };
  if ($('#bFloors')) $('#bFloors').onchange = (e) => { building.floors = Math.max(1, Math.min(60, +e.target.value || 1)); saveBuilding(); bview.rebuild(); renderBPanel(); };
  if ($('#bPrice')) $('#bPrice').onchange = (e) => { building.pricePerM2 = +e.target.value || building.pricePerM2; saveBuilding(); renderBPanel(); renderBDetail(); };
  if ($('#bCsv')) $('#bCsv').onclick = () => {
    const rows = [['Mã căn', 'Tầng', 'Vị trí', 'Loại', 'DT tim (m²)', 'DT thông thủy (m²)', 'Giá (tỷ)', 'Trạng thái', 'Khách hàng', 'Ghi chú']];
    floors.forEach((fl, fi) => SLOT_LIST.forEach((sl) => {
      const u = building.units[`${fl}-${sl.slot}`] || {};
      const ar = areaOf(fl, sl);
      rows.push([unitCode(building, fl, sl.slot), fl, sl.slot, sl.type, ar.tim, ar.tt, unitPrice(building, fi, sl).toFixed(2), STATUS[u.status || 'available'].name, u.customer || '', u.note || '']);
    }));
    const esc = (v) => (/[",\n]/.test(String(v)) ? `"${String(v).replace(/"/g, '""')}"` : String(v));
    H.download(new Blob(['\ufeff' + rows.map((r) => r.map(esc).join(',')).join('\r\n')], { type: 'text/csv;charset=utf-8' }), `bang-hang-${building.code}.csv`);
  };
  if ($('#bReset')) $('#bReset').onclick = async () => {
    if (!(await H.ask('Tạo lại dữ liệu mẫu? Trạng thái, giá và khách hàng đã nhập sẽ bị xoá (mặt bằng đã gán vẫn giữ).', { ok: 'Tạo lại' }))) return;
    const layouts = building.layouts;
    building = sampleBuilding();
    building.layouts = layouts;
    saveBuilding(); bsel = null; renderBDetail(); bview.rebuild(); renderBPanel();
  };
}

function renderBDetail() {
  const el = $('#bdetail');
  if (!bsel) { el.hidden = true; return; }
  const { floor, floorIndex, slot } = bsel;
  const key = `${floor}-${slot.slot}`;
  const u = bUnit(key);
  const price = unitPrice(building, floorIndex, slot);
  const ar = areaOf(floor, slot);
  const layout = slot.shop ? null : slotLayout(building, slot.slot);
  const hasLayout = !!layout;
  el.hidden = false;
  el.innerHTML = `
    <h3>${unitCode(building, floor, slot.slot)} <button id="bdClose" title="Đóng">✕</button></h3>
    <div class="row">${READONLY ? '' : `<span class="chip" style="background:${STATUS[u.status || 'available'].color}">${STATUS[u.status || 'available'].name}</span>`}<small>${slot.type} · tầng ${floor.replace(/^0/, '')} · vị trí ${slot.slot}</small></div>
    <div class="kv">
      <div><small>DT tim tường</small><b>${ar.tim} m²</b></div>
      <div><small>DT thông thủy</small><b>${ar.tt} m²</b></div>
      ${READONLY ? '' : `<div><small>Giá ${u.price ? '' : '(ước tính)'}</small><b>${vndTy(price)} tỷ</b></div>
      <div><small>Đơn giá TT</small><b>${vndTy((price * 1000) / ar.tt)} tr/m²</b></div>`}
    </div>
    <button id="bdLook">🔭 Ngắm view từ căn này (tầng ${floor.replace(/^0/, '')})</button>
    ${READONLY ? `<button id="bdView" class="primary" ${layout ? '' : 'disabled'}>🏠 Xem căn hộ 2D · 3D · 4D</button>${layout && !PROVISIONAL.has(slot.slot) ? '' : '<p class="hint">Mặt bằng chi tiết của căn này đang được cập nhật; hình 3D hiện tại chỉ mang tính minh hoạ.</p>'}` : `<label class="field"><span>Trạng thái</span><select id="bdStatus">${Object.entries(STATUS).map(([k, v]) => `<option value="${k}" ${(u.status || 'available') === k ? 'selected' : ''}>${v.name}</option>`).join('')}</select></label>
    <label class="field"><span>Giá bán (tỷ)</span><input type="number" id="bdPrice" step="0.01" min="0" value="${u.price ?? ''}" placeholder="${price.toFixed(2)}" /></label>
    <label class="field"><span>Khách hàng</span><input type="text" id="bdCustomer" value="${(u.customer || '').replace(/"/g, '&quot;')}" placeholder="Tên, SĐT" /></label>
    <label class="field"><span>Ghi chú</span><input type="text" id="bdNote" value="${(u.note || '').replace(/"/g, '&quot;')}" /></label>
    <button id="bdView" class="primary">🏠 Xem căn hộ 3D</button>
    <button id="bdAssign" title="Lưu mặt bằng đang mở trong trình vẽ làm mặt bằng của vị trí ${slot.slot} (áp dụng cho mọi tầng)">📌 Gán mặt bằng đang mở cho vị trí ${slot.slot}</button>
    <p class="hint">${building.layouts[slot.slot] ? `Vị trí ${slot.slot} dùng mặt bằng đã gán (mọi tầng).` : layout ? `Vị trí ${slot.slot} đang dùng căn mẫu “${layout.unitId}”${PROVISIONAL.has(slot.slot) ? ' – GHÉP TẠM, chưa có mặt bằng đúng của căn này' : ' (ghép theo diện tích, cần xác nhận)'}.` : `Vị trí ${slot.slot} chưa có mặt bằng chi tiết. Gửi ảnh mặt bằng loại căn này để dựng, hoặc dựng ở chế độ 2D rồi bấm “Gán”.`}</p>`}`;
  if (slot.shop) {
    // Shop khối đế: không có mặt bằng căn hộ – ẩn các nút dành cho căn hộ
    for (const id of ['#bdLook', '#bdView', '#bdAssign']) { const x = $(id); if (x) x.hidden = true; }
    el.querySelectorAll('p.hint').forEach((p) => p.remove());
    el.querySelector('small').textContent = `Shop thương mại · tầng ${floor.replace(/^0/, '')} · ${slot.label}`;
    el.insertAdjacentHTML('beforeend', `<p class="hint">Shop khối đế, mặt tiền kính, trần cao ~4,8 m. Mặt bằng trong bàn giao thô (minh hoạ).</p>`);
  }
  const upd = (fn) => { fn(u); building.sample = false; saveBuilding(); bview.rebuild(); renderBPanel(); };
  $('#bdLook').onclick = () => {
    bFloorIdx = floorIndex;
    bview.lookSlot = slot;
    if (bview.onlyFloor !== null) { bview.onlyFloor = null; bview.rebuild(); }
    bview.viewFromFloor(floorIndex, slot);
    renderBPanel();
  };
  $('#bdClose').onclick = () => { bsel = null; bview.setSelected(null); renderBDetail(); };
  if ($('#bdStatus')) $('#bdStatus').onchange = (e) => { upd((x) => (x.status = e.target.value)); renderBDetail(); };
  if ($('#bdPrice')) $('#bdPrice').onchange = (e) => { upd((x) => { const v = parseFloat(e.target.value); if (isFinite(v) && v > 0) x.price = v; else delete x.price; }); renderBDetail(); };
  if ($('#bdCustomer')) $('#bdCustomer').onchange = (e) => upd((x) => (x.customer = e.target.value.trim()));
  if ($('#bdNote')) $('#bdNote').onchange = (e) => upd((x) => (x.note = e.target.value.trim()));
  if ($('#bdAssign')) $('#bdAssign').onclick = () => {
    const plan = H.getCurrentPlan?.();
    if (!plan) return H.toast('Hãy mở trình dựng căn hộ (trang chính), dựng mặt bằng rồi quay lại gán.', 5000);
    building.layouts[slot.slot] = JSON.parse(JSON.stringify(plan));
    saveBuilding();
    renderBDetail();
    H.toast(`Đã gán mặt bằng hiện tại cho vị trí ${slot.slot} (mọi tầng).`);
  };
  $('#bdView').onclick = () => {
    if (!layout) return H.toast(`Vị trí ${slot.slot} chưa có mặt bằng chi tiết.`, 4000);
    if (layout.unitId && H.openShowcase) return H.openShowcase(GARDEN_FLOORS.has(floor) && GARDEN_UNIT[layout.unitId] || layout.unitId);
    if (READONLY) return;
    H.openUnit(JSON.parse(JSON.stringify(layout.plan)), { code: unitCode(building, floor, slot.slot), floor, slot: { ...slot, tt: ar.tt } });
  };
}


// ---------- Tour 360 (Kuula) ----------
const TOUR_KEY = 'floorplan3d.tour360';
const DEFAULT_TOUR = 'https://kuula.co/post/LTTwZ';
function tourEmbedUrl(link) {
  // kuula.co/post/<id> → kuula.co/share/<id> (dạng nhúng được)
  const m = String(link).match(/kuula\.co\/(?:post|share)\/([\w-]+)/);
  return m ? `https://kuula.co/share/${m[1]}?logo=1&info=1&fs=1&vr=0&thumbs=1` : link;
}
function open360Tour() {
  let link = DEFAULT_TOUR;
  try { link = localStorage.getItem(TOUR_KEY) || DEFAULT_TOUR; } catch { /* bỏ qua */ }
  const wrap = document.createElement('div');
  wrap.className = 'modal';
  wrap.innerHTML = `<div class="sheet tour360">
    <header><div><h2>Tour 360° dự án</h2><small>Kéo để nhìn quanh. Có thể thay bằng link tour khác.</small></div>
      <div class="btnrow"><input type="text" id="tourLink" /><button id="tourSet">Đổi link</button><a class="btnlink dark" id="tourOpen" target="_blank" rel="noopener">↗ Mở tab mới</a><button id="tourClose">✕</button></div></header>
    <iframe id="tourFrame" allow="xr-spatial-tracking; gyroscope; accelerometer; fullscreen" allowfullscreen></iframe></div>`;
  document.body.appendChild(wrap);
  const set = (l) => { wrap.querySelector('#tourLink').value = l; wrap.querySelector('#tourFrame').src = tourEmbedUrl(l); wrap.querySelector('#tourOpen').href = l; };
  set(link);
  wrap.querySelector('#tourSet').onclick = () => { const l = wrap.querySelector('#tourLink').value.trim(); if (!l) return; try { localStorage.setItem(TOUR_KEY, l); } catch { /* bỏ qua */ } set(l); };
  wrap.querySelector('#tourClose').onclick = () => wrap.remove();
  wrap.onclick = (e) => { if (e.target === wrap) wrap.remove(); };
}
