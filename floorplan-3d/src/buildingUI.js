// Giao diện chế độ Tòa nhà: bảng thống kê, bộ lọc, chi tiết căn. Dùng chung cho trang chính và trang toa-nha.html.
import { BuildingView, slotLayout } from './building3d.js';
import { sampleBuilding, SLOT_LIST, STATUS, TYPE_COLORS, residentialFloors, unitCode, unitPrice, areaOf } from './buildingData.js';

const $ = (s) => document.querySelector(s);
const $$ = (s) => [...document.querySelectorAll(s)];
const B_KEY = 'floorplan3d.building';
let building;
try { building = JSON.parse(localStorage.getItem(B_KEY) || 'null'); } catch { building = null; }
building ||= sampleBuilding();
let bview = null, bsel = null, H = null;
const saveBuilding = () => { try { localStorage.setItem(B_KEY, JSON.stringify(building)); } catch { /* bộ nhớ đầy */ } };
const bUnit = (key) => (building.units[key] ||= { status: 'available' });
const vndTy = (n) => n.toLocaleString('vi-VN', { maximumFractionDigits: 2 });

/**
 * Gắn giao diện tòa nhà vào trang. hooks: { toast, ask, download, getCurrentPlan, openUnit(layout, info) }
 * Trả về { view } để trang chủ có thể tạm dừng / chạy lại vòng vẽ.
 */
export function mountBuildingUI(hooks) {
  H = hooks;
  if (!bview) bview = new BuildingView($('#buildingView'), () => building, (sel) => { bsel = sel; renderBDetail(); }, { light: lightMode() });
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
  return { st, total: floors.length * SLOT_LIST.length };
}

function renderBPanel() {
  const { st, total } = bStats();
  const floors = residentialFloors(building.floors);
  const f = bview?.filter.status;
  $('#bpanel').innerHTML = `
    <h3>🏢 ${building.name} · ${floors.length} tầng ở · ${total} căn</h3>
    ${building.sample ? '<div class="sample">Trạng thái và giá đang là dữ liệu mẫu để minh hoạ. Nhấp vào từng căn để cập nhật.</div>' : ''}
    <div class="bstats">${Object.entries(STATUS).map(([k, v]) => `<button data-st="${k}" class="${f && !f.has(k) ? 'off' : ''}" title="Bấm để ẩn/hiện"><small><i class="dot" style="background:${v.color}"></i>${v.name}</small><b>${st[k].n}</b></button>`).join('')}</div>
    <div class="bmoney">Đã bán + đặt cọc: <b>${vndTy(st.sold.value + st.deposit.value)} tỷ</b><br>Giá trị hàng còn trống: <b>${vndTy(st.available.value)} tỷ</b></div>
    <div class="row"><button id="bViewP">🎥 Góc phối cảnh</button><button id="bViewC">🔍 Cận cảnh tòa</button></div>
    <h4>Tô màu theo</h4>
    <div class="row seg">${[['status', 'Trạng thái'], ['type', 'Loại căn'], ['facade', 'Mặt đứng']].map(([k, n]) => `<button data-color="${k}" class="${(bview?.colorBy || 'facade') === k ? 'active' : ''}">${n}</button>`).join('')}</div>
    ${bview?.colorBy === 'type' ? `<div class="row">${Object.entries(TYPE_COLORS).map(([k, c]) => `<small><i class="dot" style="background:${c}"></i> ${k}</small>`).join(' ')}</div>` : ''}
    <h4>Lọc loại căn</h4>
    <select id="bType"><option value="">Tất cả loại căn</option>${Object.keys(TYPE_COLORS).map((t) => `<option ${bview?.filter.type === t ? 'selected' : ''}>${t}</option>`).join('')}</select>
    <button id="bPlan" class="primary">🗺 Mặt bằng tầng chi tiết (3D)</button>
    <h4>Xem theo tầng</h4>
    <select id="bFloor"><option value="">Cả tòa nhà</option>${floors.map((fl, i) => `<option value="${i}" ${bview?.onlyFloor === i ? 'selected' : ''}>Tầng ${fl.replace(/^0/, '')}</option>`).join('')}</select>
    <h4>Thông số tòa</h4>
    <label class="field"><span>Số tầng ở</span><input type="number" id="bFloors" min="1" max="60" value="${building.floors}" /></label>
    <label class="field"><span>Đơn giá (tr/m² TT)</span><input type="number" id="bPrice" min="1" step="0.5" value="${building.pricePerM2}" /></label>
    <label class="row"><input type="checkbox" id="bLight" ${bview?.light ? 'checked' : ''} /> Chế độ nhẹ (ít cây, nhà, tắt bóng đổ – cho máy yếu, điện thoại)</label>
    <div class="row"><button id="bCsv">⬇ Xuất bảng hàng (CSV)</button><button id="bReset" title="Tạo lại dữ liệu mẫu">↺ Dữ liệu mẫu</button></div>`;
  $$('#bpanel [data-st]').forEach((b) => (b.onclick = () => { const s = bview.filter.status; s.has(b.dataset.st) ? s.delete(b.dataset.st) : s.add(b.dataset.st); bview.rebuild(); renderBPanel(); }));
  $$('#bpanel [data-color]').forEach((b) => (b.onclick = () => { bview.colorBy = b.dataset.color; bview.rebuild(); renderBPanel(); }));
  $('#bLight').onchange = (e) => { try { localStorage.setItem(LIGHT_KEY, e.target.checked ? '1' : '0'); } catch { /* bỏ qua */ } bview.setLight(e.target.checked); };
  $('#bPlan').onclick = () => {
    const fi = bview.onlyFloor ?? Math.max(0, floors.indexOf('08'));
    bview.showFloorPlan(fi);
    renderBPanel();
  };
  $('#bViewP').onclick = () => bview.setView('perspective');
  $('#bViewC').onclick = () => bview.setView('close');
  $('#bType').onchange = (e) => { bview.filter.type = e.target.value || null; bview.rebuild(); };
  $('#bFloor').onchange = (e) => {
    if (e.target.value !== '') { bview.showFloorPlan(+e.target.value); return; }
    bview.onlyFloor = null;
    bview.rebuild();
    const y = building.podiumFloors * building.podiumHeight + ((bview.onlyFloor ?? floors.length) + 0.5) * building.floorHeight;
    bview.controls.target.set(0, bview.onlyFloor === null ? 30 : y, 0);
  };
  $('#bFloors').onchange = (e) => { building.floors = Math.max(1, Math.min(60, +e.target.value || 1)); saveBuilding(); bview.rebuild(); renderBPanel(); };
  $('#bPrice').onchange = (e) => { building.pricePerM2 = +e.target.value || building.pricePerM2; saveBuilding(); renderBPanel(); renderBDetail(); };
  $('#bCsv').onclick = () => {
    const rows = [['Mã căn', 'Tầng', 'Vị trí', 'Loại', 'DT tim (m²)', 'DT thông thủy (m²)', 'Giá (tỷ)', 'Trạng thái', 'Khách hàng', 'Ghi chú']];
    floors.forEach((fl, fi) => SLOT_LIST.forEach((sl) => {
      const u = building.units[`${fl}-${sl.slot}`] || {};
      const ar = areaOf(fl, sl);
      rows.push([unitCode(building, fl, sl.slot), fl, sl.slot, sl.type, ar.tim, ar.tt, unitPrice(building, fi, sl).toFixed(2), STATUS[u.status || 'available'].name, u.customer || '', u.note || '']);
    }));
    const esc = (v) => (/[",\n]/.test(String(v)) ? `"${String(v).replace(/"/g, '""')}"` : String(v));
    H.download(new Blob(['\ufeff' + rows.map((r) => r.map(esc).join(',')).join('\r\n')], { type: 'text/csv;charset=utf-8' }), `bang-hang-${building.code}.csv`);
  };
  $('#bReset').onclick = async () => {
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
  const layout = slotLayout(building, slot.slot);
  const hasLayout = !!layout;
  el.hidden = false;
  el.innerHTML = `
    <h3>${unitCode(building, floor, slot.slot)} <button id="bdClose" title="Đóng">✕</button></h3>
    <div class="row"><span class="chip" style="background:${STATUS[u.status || 'available'].color}">${STATUS[u.status || 'available'].name}</span><small>${slot.type} · tầng ${floor.replace(/^0/, '')} · vị trí ${slot.slot}</small></div>
    <div class="kv">
      <div><small>DT tim tường</small><b>${ar.tim} m²</b></div>
      <div><small>DT thông thủy</small><b>${ar.tt} m²</b></div>
      <div><small>Giá ${u.price ? '' : '(ước tính)'}</small><b>${vndTy(price)} tỷ</b></div>
      <div><small>Đơn giá TT</small><b>${vndTy((price * 1000) / ar.tt)} tr/m²</b></div>
    </div>
    <label class="field"><span>Trạng thái</span><select id="bdStatus">${Object.entries(STATUS).map(([k, v]) => `<option value="${k}" ${(u.status || 'available') === k ? 'selected' : ''}>${v.name}</option>`).join('')}</select></label>
    <label class="field"><span>Giá bán (tỷ)</span><input type="number" id="bdPrice" step="0.01" min="0" value="${u.price ?? ''}" placeholder="${price.toFixed(2)}" /></label>
    <label class="field"><span>Khách hàng</span><input type="text" id="bdCustomer" value="${(u.customer || '').replace(/"/g, '&quot;')}" placeholder="Tên, SĐT" /></label>
    <label class="field"><span>Ghi chú</span><input type="text" id="bdNote" value="${(u.note || '').replace(/"/g, '&quot;')}" /></label>
    <button id="bdView" class="primary">🏠 Xem căn hộ 3D</button>
    <button id="bdAssign" title="Lưu mặt bằng đang mở trong trình vẽ làm mặt bằng của vị trí ${slot.slot} (áp dụng cho mọi tầng)">📌 Gán mặt bằng đang mở cho vị trí ${slot.slot}</button>
    <p class="hint">${building.layouts[slot.slot] ? `Vị trí ${slot.slot} dùng mặt bằng đã gán (mọi tầng).` : layout ? `Vị trí ${slot.slot} đang dùng căn mẫu “${layout.unitId}” (ghép tạm theo diện tích, cần xác nhận).` : `Vị trí ${slot.slot} chưa có mặt bằng chi tiết. Gửi ảnh mặt bằng loại căn này để dựng, hoặc dựng ở chế độ 2D rồi bấm “Gán”.`}</p>`;
  const upd = (fn) => { fn(u); building.sample = false; saveBuilding(); bview.rebuild(); renderBPanel(); };
  $('#bdClose').onclick = () => { bsel = null; bview.setSelected(null); renderBDetail(); };
  $('#bdStatus').onchange = (e) => { upd((x) => (x.status = e.target.value)); renderBDetail(); };
  $('#bdPrice').onchange = (e) => { upd((x) => { const v = parseFloat(e.target.value); if (isFinite(v) && v > 0) x.price = v; else delete x.price; }); renderBDetail(); };
  $('#bdCustomer').onchange = (e) => upd((x) => (x.customer = e.target.value.trim()));
  $('#bdNote').onchange = (e) => upd((x) => (x.note = e.target.value.trim()));
  $('#bdAssign').onclick = () => {
    const plan = H.getCurrentPlan?.();
    if (!plan) return H.toast('Hãy mở trình dựng căn hộ (trang chính), dựng mặt bằng rồi quay lại gán.', 5000);
    building.layouts[slot.slot] = JSON.parse(JSON.stringify(plan));
    saveBuilding();
    renderBDetail();
    H.toast(`Đã gán mặt bằng hiện tại cho vị trí ${slot.slot} (mọi tầng).`);
  };
  $('#bdView').onclick = () => {
    if (!layout) return H.toast(`Vị trí ${slot.slot} chưa có mặt bằng chi tiết.`, 4000);
    if (layout.unitId && H.openShowcase) return H.openShowcase(layout.unitId);
    H.openUnit(JSON.parse(JSON.stringify(layout.plan)), { code: unitCode(building, floor, slot.slot), floor, slot: { ...slot, tt: ar.tt } });
  };
}

