// Tự tạo phòng từ các bức tường: raster hoá tường, loang vùng kín, dò biên thành đa giác.
import { closestOnSegment, polygonArea, planBounds } from './geom.js';
import { uid } from './model.js';

const RES = 0.05;

export function detectRooms(plan) {
  if (!plan.walls.length) return [];
  const b = planBounds({ ...plan, rooms: [], furniture: [] });
  const pad = 0.5;
  const x0 = b.minX - pad, y0 = b.minY - pad;
  const W = Math.ceil((b.maxX - b.minX + 2 * pad) / RES), H = Math.ceil((b.maxY - b.minY + 2 * pad) / RES);
  if (W * H > 6e6) return [];
  const blocked = new Uint8Array(W * H);
  for (const w of plan.walls) {
    const r = w.thickness / 2 + 0.01;
    const minI = Math.max(0, Math.floor((Math.min(w.a.x, w.b.x) - r - x0) / RES)), maxI = Math.min(W - 1, Math.ceil((Math.max(w.a.x, w.b.x) + r - x0) / RES));
    const minJ = Math.max(0, Math.floor((Math.min(w.a.y, w.b.y) - r - y0) / RES)), maxJ = Math.min(H - 1, Math.ceil((Math.max(w.a.y, w.b.y) + r - y0) / RES));
    for (let j = minJ; j <= maxJ; j++)
      for (let i = minI; i <= maxI; i++) {
        const p = { x: x0 + (i + 0.5) * RES, y: y0 + (j + 0.5) * RES };
        // Nối dài đầu tường một chút để khép kín các góc
        if (closestOnSegment(p, w.a, w.b).d <= r + RES * 0.75) blocked[j * W + i] = 1;
      }
  }
  // Gán nhãn vùng: 0 = chưa xét, -1 = bên ngoài, >0 = phòng
  const label = new Int32Array(W * H);
  const stack = [];
  const fill = (start, id) => {
    let n = 0;
    stack.push(start);
    label[start] = id;
    while (stack.length) {
      const k = stack.pop();
      n++;
      const i = k % W, j = (k - i) / W;
      const nb = [i > 0 ? k - 1 : -1, i < W - 1 ? k + 1 : -1, j > 0 ? k - W : -1, j < H - 1 ? k + W : -1];
      for (const q of nb) if (q >= 0 && !blocked[q] && !label[q]) { label[q] = id; stack.push(q); }
    }
    return n;
  };
  for (let i = 0; i < W; i++) for (const j of [0, H - 1]) { const k = j * W + i; if (!blocked[k] && !label[k]) fill(k, -1); }
  for (let j = 0; j < H; j++) for (const i of [0, W - 1]) { const k = j * W + i; if (!blocked[k] && !label[k]) fill(k, -1); }
  const rooms = [];
  let id = 1;
  for (let k = 0; k < W * H; k++) {
    if (blocked[k] || label[k]) continue;
    id++;
    const n = fill(k, id);
    if (n * RES * RES < 1.0) continue;
    rooms.push(id);
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
