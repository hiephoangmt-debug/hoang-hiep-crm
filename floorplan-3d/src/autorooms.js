// Tự tạo phòng từ các bức tường: raster hoá tường, loang vùng kín, dò biên thành đa giác.
import { closestOnSegment, polygonArea, planBounds } from './geom.js';
import { uid } from './model.js';

const RES = 0.05;

/** opts.close: độ nới tường để bịt khe cửa (m); opts.outside: các điểm chắc chắn nằm ngoài căn */
export function detectRooms(plan, opts = {}) {
  if (!plan.walls.length) return [];
  const b = planBounds({ ...plan, rooms: [], furniture: [] });
  const pad = 0.5;
  const x0 = b.minX - pad, y0 = b.minY - pad;
  const W = Math.ceil((b.maxX - b.minX + 2 * pad) / RES), H = Math.ceil((b.maxY - b.minY + 2 * pad) / RES);
  if (W * H > 6e6) return [];
  // blocked = ô thuộc tường thật; closed = tường nới rộng thêm CLOSE để bịt tạm các khe cửa
  const CLOSE = opts.close ?? 0.45;
  const blocked = new Uint8Array(W * H), closed = new Uint8Array(W * H);
  for (const w of plan.walls) {
    const r = w.thickness / 2 + 0.01, R = r + CLOSE;
    const minI = Math.max(0, Math.floor((Math.min(w.a.x, w.b.x) - R - x0) / RES)), maxI = Math.min(W - 1, Math.ceil((Math.max(w.a.x, w.b.x) + R - x0) / RES));
    const minJ = Math.max(0, Math.floor((Math.min(w.a.y, w.b.y) - R - y0) / RES)), maxJ = Math.min(H - 1, Math.ceil((Math.max(w.a.y, w.b.y) + R - y0) / RES));
    for (let j = minJ; j <= maxJ; j++)
      for (let i = minI; i <= maxI; i++) {
        const p = { x: x0 + (i + 0.5) * RES, y: y0 + (j + 0.5) * RES };
        const d = closestOnSegment(p, w.a, w.b).d;
        // Nối dài đầu tường một chút để khép kín các góc
        if (d <= r + RES * 0.75) blocked[j * W + i] = 1;
        if (d <= R) closed[j * W + i] = 1;
      }
  }
  // Gán nhãn vùng trên lưới đã bịt khe: -1 = bên ngoài, >0 = phòng
  const label = new Int32Array(W * H);
  const stack = [];
  const nbrs = (k) => { const i = k % W, j = (k - i) / W; return [i > 0 ? k - 1 : -1, i < W - 1 ? k + 1 : -1, j > 0 ? k - W : -1, j < H - 1 ? k + W : -1]; };
  const fill = (start, id) => {
    let n = 0;
    stack.push(start);
    label[start] = id;
    while (stack.length) {
      const k = stack.pop();
      n++;
      for (const q of nbrs(k)) if (q >= 0 && !closed[q] && !label[q]) { label[q] = id; stack.push(q); }
    }
    return n;
  };
  // Bên ngoài căn hộ = ngoài đường bao lồi của các tường (lô-gia hở lan can kính vẫn tính là trong)
  const hull = convexHull(plan.walls.flatMap((w) => [w.a, w.b]));
  for (let k = 0; k < W * H; k++) {
    const i = k % W, j = (k - i) / W;
    if (!insideConvex({ x: x0 + (i + 0.5) * RES, y: y0 + (j + 0.5) * RES }, hull)) label[k] = -1;
  }
  for (const p of opts.outside || []) {
    const i = Math.floor((p.x - x0) / RES), j = Math.floor((p.y - y0) / RES);
    const k = j * W + i;
    if (i >= 0 && j >= 0 && i < W && j < H && !closed[k] && !label[k]) fill(k, -1);
  }
  const rooms = [];
  let id = 1;
  for (let k = 0; k < W * H; k++) {
    if (closed[k] || label[k]) continue;
    id++;
    const n = fill(k, id);
    let open = 0, walled = 0;
    for (let q = 0; q < W * H; q++) {
      if (label[q] !== id) continue;
      for (const r of nbrs(q)) { if (r < 0 || label[r] === -1) open++; else if (closed[r]) walled++; }
    }
    // Quá nhỏ, hoặc hở ra ngoài đường bao quá nhiều (khoảng trống quanh căn chữ L) → không phải phòng
    if (n * RES * RES < 0.4 || open > (open + walled) * 0.45) {
      for (let q = 0; q < W * H; q++) if (label[q] === id) label[q] = n * RES * RES < 0.4 ? 0 : -1;
      continue;
    }
    rooms.push(id);
  }
  // Cho các vùng (kể cả bên ngoài) cùng loang lại vào phần đã bịt, dừng ở tường thật
  let queue = [];
  for (let k = 0; k < W * H; k++) if (label[k]) queue.push(k);
  while (queue.length) {
    const next = [];
    for (const k of queue) for (const q of nbrs(k)) if (q >= 0 && !blocked[q] && !label[q]) { label[q] = label[k]; next.push(q); }
    queue = next;
  }
  // Nở vùng vào nửa bề dày tường để phòng chạm tới tim tường
  const maxT = Math.max(...plan.walls.map((w) => w.thickness));
  const steps = Math.round(maxT / 2 / RES);
  const result = [];
  for (const rid of rooms) {
    let cells = new Uint8Array(W * H);
    for (let k = 0; k < W * H; k++) if (label[k] === rid) cells[k] = 1;
    for (let s = 0; s < steps; s++) {
      const next = cells.slice();
      for (let k = 0; k < W * H; k++) {
        if (cells[k] || !blocked[k]) continue;
        const i = k % W, j = (k - i) / W;
        // Lân cận 8 hướng để góc phòng giữ vuông
        let hit = false;
        for (let dj = -1; dj <= 1 && !hit; dj++)
          for (let di = -1; di <= 1; di++) {
            const ii = i + di, jj = j + dj;
            if (ii >= 0 && jj >= 0 && ii < W && jj < H && cells[jj * W + ii]) { hit = true; break; }
          }
        if (hit) next[k] = 1;
      }
      cells = next;
    }
    const poly = traceOutline(cells, W, H);
    if (!poly) continue;
    const pts = simplify(poly.map(([i, j]) => ({ x: +(x0 + i * RES).toFixed(3), y: +(y0 + j * RES).toFixed(3) })), RES * 1.2);
    const clean = dropSlivers(pts, 0.015);
    if (clean.length < 3) continue;
    result.push(clean);
  }
  result.sort((a, b) => polygonArea(b) - polygonArea(a));
  return result.map((pts, i) => {
    const area = polygonArea(pts);
    const small = area < 6;
    return { id: uid(), name: small ? `Phòng tắm ${i + 1}` : `Phòng ${i + 1}`, floor: small ? 'tile' : 'wood', points: pts };
  });
}

/** Dò cạnh biên của tập ô lưới, trả về vòng dài nhất (đỉnh lưới) */
function traceOutline(cells, W, H) {
  const edges = new Map();
  const add = (ax, ay, bx, by) => {
    const key = ax + ',' + ay;
    if (!edges.has(key)) edges.set(key, []);
    edges.get(key).push([bx, by]);
  };
  for (let j = 0; j < H; j++)
    for (let i = 0; i < W; i++) {
      if (!cells[j * W + i]) continue;
      // Cạnh có hướng sao cho ô nằm bên phải (theo chiều kim đồng hồ khi y hướng xuống)
      if (j === 0 || !cells[(j - 1) * W + i]) add(i, j, i + 1, j);
      if (i === W - 1 || !cells[j * W + i + 1]) add(i + 1, j, i + 1, j + 1);
      if (j === H - 1 || !cells[(j + 1) * W + i]) add(i + 1, j + 1, i, j + 1);
      if (i === 0 || !cells[j * W + i - 1]) add(i, j + 1, i, j);
    }
  let best = null;
  while (edges.size) {
    const [startKey, list] = edges.entries().next().value;
    const loop = [];
    let [cx, cy] = startKey.split(',').map(Number);
    let key = startKey;
    let guard = 0;
    while (edges.has(key) && guard++ < 1e6) {
      const l = edges.get(key);
      const nxt = l.pop();
      if (!l.length) edges.delete(key);
      loop.push([cx, cy]);
      [cx, cy] = nxt;
      key = cx + ',' + cy;
      if (key === startKey) break;
    }
    void list;
    if (!best || loop.length > best.length) best = loop;
  }
  return best;
}

/** Douglas–Peucker cho đa giác khép kín + bỏ điểm thẳng hàng */
function simplify(pts, eps) {
  if (pts.length < 4) return pts;
  // Bắt đầu từ điểm xa nhất so với điểm đầu để ổn định
  let far = 0, fd = -1;
  for (let i = 0; i < pts.length; i++) { const d = Math.hypot(pts[i].x - pts[0].x, pts[i].y - pts[0].y); if (d > fd) { fd = d; far = i; } }
  const a = dp(pts.slice(0, far + 1), eps), b = dp([...pts.slice(far), pts[0]], eps);
  const out = [...a.slice(0, -1), ...b.slice(0, -1)];
  // Loại điểm thẳng hàng còn sót
  const res = [];
  for (let i = 0; i < out.length; i++) {
    const p = out[(i - 1 + out.length) % out.length], c = out[i], n = out[(i + 1) % out.length];
    const cross = (c.x - p.x) * (n.y - c.y) - (c.y - p.y) * (n.x - c.x);
    if (Math.abs(cross) > 1e-6) res.push(c);
  }
  return res;
}

function dp(pts, eps) {
  if (pts.length < 3) return pts;
  const a = pts[0], b = pts[pts.length - 1];
  let idx = -1, md = 0;
  for (let i = 1; i < pts.length - 1; i++) {
    const d = closestOnSegment(pts[i], a, b).d;
    if (d > md) { md = d; idx = i; }
  }
  if (md <= eps) return [a, b];
  const l = dp(pts.slice(0, idx + 1), eps), r = dp(pts.slice(idx), eps);
  return [...l.slice(0, -1), ...r];
}

/** Bỏ các đỉnh tạo tam giác rất nhỏ (gờ, vát góc do raster) */
function dropSlivers(pts, minArea) {
  const out = pts.slice();
  let changed = true;
  while (changed && out.length > 3) {
    changed = false;
    for (let i = 0; i < out.length && out.length > 3; i++) {
      const p = out[(i - 1 + out.length) % out.length], c = out[i], n = out[(i + 1) % out.length];
      const area = Math.abs((c.x - p.x) * (n.y - p.y) - (c.y - p.y) * (n.x - p.x)) / 2;
      if (area < minArea) { out.splice(i, 1); changed = true; i--; }
    }
  }
  return out;
}

function convexHull(pts) {
  const p = pts.map((q) => [q.x, q.y]).sort((a, b) => a[0] - b[0] || a[1] - b[1]);
  if (p.length < 3) return p;
  const cross = (o, a, b) => (a[0] - o[0]) * (b[1] - o[1]) - (a[1] - o[1]) * (b[0] - o[0]);
  const lower = [], upper = [];
  for (const q of p) { while (lower.length >= 2 && cross(lower[lower.length - 2], lower[lower.length - 1], q) <= 0) lower.pop(); lower.push(q); }
  for (const q of p.slice().reverse()) { while (upper.length >= 2 && cross(upper[upper.length - 2], upper[upper.length - 1], q) <= 0) upper.pop(); upper.push(q); }
  return lower.slice(0, -1).concat(upper.slice(0, -1));
}

function insideConvex(pt, hull) {
  if (hull.length < 3) return true;
  for (let i = 0; i < hull.length; i++) {
    const a = hull[i], b = hull[(i + 1) % hull.length];
    if ((b[0] - a[0]) * (pt.y - a[1]) - (b[1] - a[1]) * (pt.x - a[0]) < -1e-9) return false;
  }
  return true;
}
