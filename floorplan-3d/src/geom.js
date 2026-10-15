// Hàm hình học 2D dùng chung (đơn vị: mét, trục y hướng xuống trên mặt bằng)

export const dist = (a, b) => Math.hypot(a.x - b.x, a.y - b.y);

export function wallLength(w) {
  return dist(w.a, w.b);
}

export function wallDir(w) {
  const L = wallLength(w) || 1;
  return { x: (w.b.x - w.a.x) / L, y: (w.b.y - w.a.y) / L };
}

export function closestOnSegment(p, a, b) {
  const dx = b.x - a.x, dy = b.y - a.y;
  const L2 = dx * dx + dy * dy || 1e-9;
  let t = ((p.x - a.x) * dx + (p.y - a.y) * dy) / L2;
  t = Math.max(0, Math.min(1, t));
  const q = { x: a.x + dx * t, y: a.y + dy * t };
  return { t, point: q, d: dist(p, q) };
}

export function pointAlongWall(w, t) {
  return { x: w.a.x + (w.b.x - w.a.x) * t, y: w.a.y + (w.b.y - w.a.y) * t };
}

/** Khoảng [bắt đầu, kết thúc] (mét, tính từ điểm a) của một ô cửa trên tường */
export function openingRange(w, op) {
  const L = wallLength(w);
  const c = op.t * L;
  const half = Math.min(op.width, L) / 2;
  const s = Math.max(0, Math.min(L - 2 * half, c - half));
  return [s, s + 2 * half];
}

export function pointInPolygon(p, pts) {
  let inside = false;
  for (let i = 0, j = pts.length - 1; i < pts.length; j = i++) {
    const a = pts[i], b = pts[j];
    if ((a.y > p.y) !== (b.y > p.y) && p.x < ((b.x - a.x) * (p.y - a.y)) / (b.y - a.y) + a.x) inside = !inside;
  }
  return inside;
}

export function polygonArea(pts) {
  let s = 0;
  for (let i = 0; i < pts.length; i++) {
    const a = pts[i], b = pts[(i + 1) % pts.length];
    s += a.x * b.y - b.x * a.y;
  }
  return Math.abs(s) / 2;
}

export function polygonCentroid(pts) {
  let cx = 0, cy = 0, A = 0;
  for (let i = 0; i < pts.length; i++) {
    const a = pts[i], b = pts[(i + 1) % pts.length];
    const f = a.x * b.y - b.x * a.y;
    cx += (a.x + b.x) * f;
    cy += (a.y + b.y) * f;
    A += f;
  }
  if (Math.abs(A) < 1e-9) {
    const n = pts.length || 1;
    return { x: pts.reduce((s, p) => s + p.x, 0) / n, y: pts.reduce((s, p) => s + p.y, 0) / n };
  }
  return { x: cx / (3 * A), y: cy / (3 * A) };
}

/** Điểm nằm trong đa giác, ưu tiên gần trọng tâm (dùng để đặt nhãn phòng hình chữ L) */
export function labelPoint(pts) {
  const c = polygonCentroid(pts);
  if (pointInPolygon(c, pts)) return c;
  let best = null, bestD = Infinity;
  const xs = pts.map((p) => p.x), ys = pts.map((p) => p.y);
  const minX = Math.min(...xs), maxX = Math.max(...xs), minY = Math.min(...ys), maxY = Math.max(...ys);
  for (let i = 1; i < 20; i++)
    for (let j = 1; j < 20; j++) {
      const p = { x: minX + ((maxX - minX) * i) / 20, y: minY + ((maxY - minY) * j) / 20 };
      if (!pointInPolygon(p, pts)) continue;
      let edge = Infinity;
      for (let k = 0; k < pts.length; k++) edge = Math.min(edge, closestOnSegment(p, pts[k], pts[(k + 1) % pts.length]).d);
      const score = dist(p, c) - edge * 2;
      if (score < bestD) { bestD = score; best = p; }
    }
  return best || c;
}

export function rotatePoint(p, angleRad) {
  const c = Math.cos(angleRad), s = Math.sin(angleRad);
  return { x: p.x * c - p.y * s, y: p.x * s + p.y * c };
}

/** Kiểm tra điểm nằm trong hình chữ nhật xoay (đồ nội thất) */
export function pointInRotRect(p, cx, cy, w, d, rotDeg) {
  const local = rotatePoint({ x: p.x - cx, y: p.y - cy }, (-rotDeg * Math.PI) / 180);
  return Math.abs(local.x) <= w / 2 && Math.abs(local.y) <= d / 2;
}

export function planBounds(plan) {
  let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
  const add = (p) => {
    minX = Math.min(minX, p.x); minY = Math.min(minY, p.y);
    maxX = Math.max(maxX, p.x); maxY = Math.max(maxY, p.y);
  };
  plan.walls.forEach((w) => { add(w.a); add(w.b); });
  plan.rooms.forEach((r) => r.points.forEach(add));
  plan.furniture.forEach((f) => add(f));
  if (!isFinite(minX)) return { minX: -5, minY: -5, maxX: 5, maxY: 5 };
  return { minX, minY, maxX, maxY };
}

export const fmt = (v, d = 2) => Number(v).toFixed(d).replace(/\.?0+$/, '') || '0';
