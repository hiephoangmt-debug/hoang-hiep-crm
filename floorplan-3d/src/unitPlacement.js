// Ghép mặt bằng căn chi tiết vào ô căn trên mặt bằng tầng: chọn hướng (xoay 0/90/180/270°, lật hay không)
// sao cho cửa vào quay ra hành lang và góc kính cong trùng góc bo của tòa, rồi co giãn cho vừa ô.
import * as THREE from 'three';
import { SLOT_RADII, SLOT_ORIENT, CORRIDORS, rectM } from './buildingData.js';

function unitFeatures(plan) {
  const xs = plan.walls.flatMap((w) => [w.a.x, w.b.x]), ys = plan.walls.flatMap((w) => [w.a.y, w.b.y]);
  const box = { x0: Math.min(...xs), y0: Math.min(...ys), x1: Math.max(...xs), y1: Math.max(...ys) };
  const c = { x: (box.x0 + box.x1) / 2, y: (box.y0 + box.y1) / 2 };
  const at = (o) => { const w = plan.walls.find((x) => x.id === o.wallId); return w && { x: w.a.x + (w.b.x - w.a.x) * o.t, y: w.a.y + (w.b.y - w.a.y) * o.t }; };
  const edge = (p) => Math.min(p.x - box.x0, box.x1 - p.x, p.y - box.y0, box.y1 - p.y);
  // Cửa vào: cửa đi rộng nhất nằm trên mép ngoài căn
  let entrance = null, bw = 0;
  for (const o of plan.openings) {
    if (o.type !== 'door') continue;
    const p = at(o);
    if (p && edge(p) < 0.45 && o.width > bw) { bw = o.width; entrance = p; }
  }
  // Góc kính cong: trung bình các tấm kính cong
  const glass = plan.openings.filter((o) => o.glass).map(at).filter(Boolean);
  const curve = glass.length ? { x: glass.reduce((a, p) => a + p.x, 0) / glass.length, y: glass.reduce((a, p) => a + p.y, 0) / glass.length } : null;
  return { box, c, w: box.x1 - box.x0, h: box.y1 - box.y0, entrance: entrance || c, curve };
}

// Biến đổi điểm (đã trừ tâm căn): lật trục x rồi xoay k×90° (hệ y hướng xuống)
function tf(p, k, m) {
  let x = m ? -p.x : p.x, y = p.y;
  for (let i = 0; i < k; i++) [x, y] = [-y, x];
  return { x, y };
}

function nearestOnRects(p, rects) {
  let best = Infinity;
  for (const r of rects) {
    const dx = Math.max(r.x0 - p.x, 0, p.x - r.x1), dy = Math.max(r.y0 - p.y, 0, p.y - r.y1);
    best = Math.min(best, Math.hypot(dx, dy));
  }
  return best;
}

/**
 * slot: { fit: {x0,y0,x1,y1} (mét), corner: điểm góc bo hoặc null }; corridors: các hình chữ nhật hành lang (mét)
 * Trả về Matrix4 đặt căn (toạ độ mặt bằng căn → toạ độ tòa nhà, y = cao độ sàn).
 */
/** Khung ô căn + góc bo của tòa (mét) */
export function slotFrame(sl) {
  const r = SLOT_RADII[sl.slot] || {}, f = sl.fit;
  const corner = r.tl ? { x: f.x0, y: f.y0 } : r.tr ? { x: f.x1, y: f.y0 } : r.bl ? { x: f.x0, y: f.y1 } : r.br ? { x: f.x1, y: f.y1 } : null;
  return { fit: f, corner, orient: SLOT_ORIENT[sl.slot] };
}

/** Hướng đặt căn mẫu vào ô: k (số lần xoay 90°), m (lật), sx/sy (co giãn) */
export function slotOrientation(plan, slot, corridors = CORRIDORS.map(rectM)) {
  const f = unitFeatures(plan);
  const fit = slot.fit;
  const SW = fit.x1 - fit.x0, SH = fit.y1 - fit.y0;
  const sc = { x: (fit.x0 + fit.x1) / 2, y: (fit.y0 + fit.y1) / 2 };
  // Điểm trên mép ô gần hành lang nhất
  let door = sc, dd = Infinity;
  for (let i = 0; i <= 40; i++) {
    const t = i / 40;
    for (const p of [{ x: fit.x0 + SW * t, y: fit.y0 }, { x: fit.x0 + SW * t, y: fit.y1 }, { x: fit.x0, y: fit.y0 + SH * t }, { x: fit.x1, y: fit.y0 + SH * t }]) {
      const d = nearestOnRects(p, corridors);
      if (d < dd - 1e-6) { dd = d; door = p; }
    }
  }
  let best = null;
  for (let k = 0; k < 4; k++)
    for (const m of [false, true]) {
      if (slot.orient && (slot.orient.k !== k || slot.orient.m !== m)) continue; // hướng đã đối chiếu bản vẽ
      const W = k % 2 ? f.h : f.w, H = k % 2 ? f.w : f.h;
      const sx = SW / W, sy = SH / H;
      const map = (p) => { const q = tf({ x: p.x - f.c.x, y: p.y - f.c.y }, k, m); return { x: sc.x + q.x * sx, y: sc.y + q.y * sy }; };
      const e = map(f.entrance);
      let score = Math.hypot(e.x - door.x, e.y - door.y) + Math.abs(Math.log(sx / sy)) * 6;
      if (f.curve && slot.corner) { const cc = map(f.curve); score += Math.hypot(cc.x - slot.corner.x, cc.y - slot.corner.y) * 1.5; }
      else if (f.curve || slot.corner) score += 4;
      if (!best || score < best.score) best = { score, k, m, sx, sy, c: f.c, sc };
    }
  return best;
}

/**
 * slot: { fit: {x0,y0,x1,y1} (mét), corner: điểm góc bo hoặc null }; corridors: các hình chữ nhật hành lang (mét)
 * Trả về Matrix4 đặt căn (toạ độ mặt bằng căn → toạ độ tòa nhà, y = cao độ sàn).
 */
export function placeUnit(plan, slot, corridors, floorY) {
  const best = slotOrientation(plan, slot, corridors);
  // Ghép ma trận: dời tâm căn về gốc → lật → xoay → co giãn → đặt vào ô
  const M = new THREE.Matrix4().makeTranslation(-best.c.x, 0, -best.c.y);
  if (best.m) M.premultiply(new THREE.Matrix4().makeScale(-1, 1, 1));
  M.premultiply(new THREE.Matrix4().makeRotationY((-best.k * Math.PI) / 2));
  M.premultiply(new THREE.Matrix4().makeScale(best.sx, 1, best.sy));
  M.premultiply(new THREE.Matrix4().makeTranslation(best.sc.x, floorY, best.sc.y));
  return M;
}

/**
 * Mặt bằng căn quay/lật đúng như vị trí trên mặt bằng tầng (giữ nguyên kích thước thật).
 * Lật: đảo đầu tường (giữ phía mở cửa) và đổi bản lề cửa; đồ nội thất đổi góc.
 */
export function orientPlan(plan, { k, m }) {
  const p = JSON.parse(JSON.stringify(plan));
  const T = (q) => { const r = tf(q, k, m); q.x = +r.x.toFixed(4); q.y = +r.y.toFixed(4); };
  for (const w of p.walls) { T(w.a); T(w.b); if (m) [w.a, w.b] = [w.b, w.a]; }
  if (m) for (const o of p.openings) { o.t = 1 - o.t; if (o.type === 'door') o.flip = !o.flip; }
  for (const r of p.rooms) { r.points.forEach(T); if (m) r.points.reverse(); }
  for (const f of p.furniture) {
    T(f);
    let rot = f.rot || 0;
    if (m) rot = 360 - rot;
    f.rot = (((rot + k * 90) % 360) + 360) % 360;
  }
  for (const l of p.labels || []) T(l);
  return p;
}
