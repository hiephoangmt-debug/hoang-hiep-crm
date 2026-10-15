// Nhận diện tường từ ảnh mặt bằng (bản vẽ đen trắng, tường nét dày, ngang/dọc).
// Các bước: thang xám -> ngưỡng Otsu -> ước lượng bề dày tường -> phép mở hình thái (bỏ nét mảnh, chữ, đồ đạc)
// -> tách vệt ngang/dọc -> ghép thành tường -> nối góc -> nhận diện cửa từ khoảng hở.
import { uid } from './model.js';

export function detectWalls(img, bg, opts = {}) {
  const maxDim = 1400;
  const f = Math.min(1, maxDim / Math.max(img.width, img.height));
  const W = Math.round(img.width * f), H = Math.round(img.height * f);
  const c = document.createElement('canvas');
  c.width = W; c.height = H;
  const ctx = c.getContext('2d', { willReadFrequently: true });
  ctx.fillStyle = '#fff';
  ctx.fillRect(0, 0, W, H);
  ctx.drawImage(img, 0, 0, W, H);
  const data = ctx.getImageData(0, 0, W, H).data;
  const gray = new Uint8Array(W * H);
  const hist = new Array(256).fill(0);
  for (let i = 0; i < W * H; i++) {
    const g = (data[i * 4] * 0.299 + data[i * 4 + 1] * 0.587 + data[i * 4 + 2] * 0.114) | 0;
    gray[i] = g;
    hist[g]++;
  }
  // Bản vẽ phối màu (tường tô một màu xám phẳng, sàn có vân): lấy đúng màu tường.
  // Bản vẽ đen trắng: ngưỡng Otsu như cũ.
  const wallTone = findWallTone(data, W * H);
  const dark = new Uint8Array(W * H);
  if (wallTone) {
    const [wr, wg, wb] = wallTone;
    for (let i = 0; i < W * H; i++) {
      const r = data[i * 4], g = data[i * 4 + 1], b = data[i * 4 + 2];
      dark[i] = Math.abs(r - wr) <= 14 && Math.abs(g - wg) <= 14 && Math.abs(b - wb) <= 14 ? 1 : 0;
    }
  } else {
    const thr = Math.min(otsu(hist, W * H), opts.threshold ?? 150);
    for (let i = 0; i < W * H; i++) dark[i] = gray[i] < thr ? 1 : 0;
  }

  // Ước lượng bề dày tường = mốt của min(chiều dài vệt ngang, vệt dọc) trong số các nét dày
  const hRun = runLengths(dark, W, H, true), vRun = runLengths(dark, W, H, false);
  const th = new Array(200).fill(0);
  for (let i = 0; i < W * H; i++) if (dark[i]) { const t = Math.min(hRun[i], vRun[i]); if (t >= 3 && t < 200) th[t] += t; }
  let mode = 0, mv = 0;
  for (let t = 3; t < 200; t++) { const v = th[t] + (th[t - 1] || 0) * 0.5 + (th[t + 1] || 0) * 0.5; if (v > mv) { mv = v; mode = t; } }
  if (!mode) return { walls: [], openings: [], message: 'Không tìm thấy nét tường dày trong ảnh.' };
  // Bản vẽ phối màu đã lọc đúng màu tường → chỉ cần bỏ nhiễu nhỏ, giữ được tường ngăn mảnh
  const k = wallTone ? 3 : Math.max(2, Math.round(mode * 0.6));

  // Phép mở (co rồi giãn) với nhân k×k
  const eroded = morph(dark, W, H, k, true);
  const mask = morph(eroded, W, H, k, false);

  const mh = runLengths(mask, W, H, true), mvv = runLengths(mask, W, H, false);
  const minLen = Math.max(mode * 1.2, 8);
  const maxT = mode * 2.2;
  const hMask = new Uint8Array(W * H), vMask = new Uint8Array(W * H);
  for (let i = 0; i < W * H; i++) {
    if (!mask[i]) continue;
    if (mh[i] >= minLen && mvv[i] <= maxT) hMask[i] = 1;
    if (mvv[i] >= minLen && mh[i] <= maxT) vMask[i] = 1;
  }
  let segs = [...components(hMask, W, H, 'h', minLen), ...components(vMask, W, H, 'v', minLen)];
  segs = mergeCollinear(segs, mode);
  joinCorners(segs, mode * 1.8);

  // Đổi pixel -> mét. Nếu chưa hiệu chỉnh tỉ lệ: giả định tường dày phổ biến 0.2m
  let mpp = bg?.mpp;
  let autoScale = false;
  let sx, sy;
  if ((opts.targetWidthM || opts.targetHeightM) && segs.length) {
    // Tỉ lệ theo kích thước tổng ghi trên bản vẽ (mép ngoài tường). Bản vẽ minh hoạ có thể
    // không đúng tỉ lệ nên co giãn riêng từng chiều khi có cả hai số.
    let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
    for (const sg of segs) {
      if (sg.dir === 'h') { minX = Math.min(minX, sg.s); maxX = Math.max(maxX, sg.e); minY = Math.min(minY, sg.c - sg.t / 2); maxY = Math.max(maxY, sg.c + sg.t / 2); }
      else { minX = Math.min(minX, sg.c - sg.t / 2); maxX = Math.max(maxX, sg.c + sg.t / 2); minY = Math.min(minY, sg.s); maxY = Math.max(maxY, sg.e); }
    }
    sx = opts.targetWidthM ? opts.targetWidthM / Math.max(1, maxX - minX) : null;
    sy = opts.targetHeightM ? opts.targetHeightM / Math.max(1, maxY - minY) : null;
    sx ??= sy; sy ??= sx;
    mpp = sx * f;
  } else {
    if (!bg?.calibrated) { mpp = (0.2 / mode) * f; autoScale = true; }
    sx = sy = mpp / f;
  }
  const scale = sx;
  const ox = opts.targetWidthM || opts.targetHeightM ? 0 : bg?.x ?? 0, oy = opts.targetWidthM || opts.targetHeightM ? 0 : bg?.y ?? 0;
  const toW = (x, y) => ({ x: +(ox + x * sx).toFixed(3), y: +(oy + y * sy).toFixed(3) });
  void scale;

  const built = buildWithOpenings(segs, mode, sx, sy, toW);
  // Bỏ mảnh nhiễu: đoạn quá ngắn, hoặc ngắn mà mảnh (viền đồ đạc, mép bàn bếp…)
  const len = (w) => Math.hypot(w.b.x - w.a.x, w.b.y - w.a.y);
  const walls = built.walls.filter((w) => len(w) >= 0.3 && !(len(w) < 0.7 && w.thickness < 0.1));
  const keep = new Set(walls.map((w) => w.id));
  const openings = built.openings.filter((o) => keep.has(o.wallId));
  closeGlassCorners(walls, openings);
  return { walls, openings, autoScale, mpp, mppY: sy * f, thicknessPx: mode / f, message: `Nhận diện ${walls.length} bức tường, ${openings.length} cửa/cửa sổ.` };
}

/** Màu xám phẳng chiếm nhiều nhất trong các màu tối – coi là màu tô tường (null nếu không có) */
function findWallTone(data, n) {
  const counts = new Map();
  for (let i = 0; i < n; i += 2) {
    const r = data[i * 4], g = data[i * 4 + 1], b = data[i * 4 + 2];
    if (Math.max(r, g, b) - Math.min(r, g, b) > 12) continue;
    const l = (r + g + b) / 3;
    if (l < 35 || l > 140) continue;
    const key = ((r >> 2) << 12) | ((g >> 2) << 6) | (b >> 2);
    counts.set(key, (counts.get(key) || 0) + 1);
  }
  let best = 0, bc = 0;
  for (const [k, c] of counts) if (c > bc) { bc = c; best = k; }
  if (bc < (n / 2) * 0.015) return null;
  return [((best >> 12) & 63) * 4 + 2, ((best >> 6) & 63) * 4 + 2, (best & 63) * 4 + 2];
}

/** Đầu tường "hở" ở góc ngoài (thường là kính cong) → nối bằng vách kính để khép kín căn hộ */
function closeGlassCorners(walls, openings) {
  if (walls.length < 3) return;
  const ends = [];
  const near = (p, w) => {
    const dx = w.b.x - w.a.x, dy = w.b.y - w.a.y, L2 = dx * dx + dy * dy || 1;
    const t = Math.max(0, Math.min(1, ((p.x - w.a.x) * dx + (p.y - w.a.y) * dy) / L2));
    return Math.hypot(p.x - (w.a.x + dx * t), p.y - (w.a.y + dy * t)) < w.thickness / 2 + 0.05;
  };
  for (const w of walls) for (const k of ['a', 'b']) {
    const p = w[k];
    const L = Math.hypot(w.b.x - w.a.x, w.b.y - w.a.y);
    if (L >= 1 && w.thickness >= 0.12 && !walls.some((o) => o !== w && near(p, o))) ends.push({ p, w, horiz: Math.abs(w.a.y - w.b.y) < 1e-3 });
  }
  const xs = walls.flatMap((w) => [w.a.x, w.b.x]), ys = walls.flatMap((w) => [w.a.y, w.b.y]);
  const minX = Math.min(...xs), maxX = Math.max(...xs), minY = Math.min(...ys), maxY = Math.max(...ys);
  const onEdge = (p) => Math.min(p.x - minX, maxX - p.x, p.y - minY, maxY - p.y) < 0.8;
  const used = new Set();
  for (let i = 0; i < ends.length; i++) {
    if (used.has(i) || !onEdge(ends[i].p)) continue;
    let best = -1, bd = 4.5;
    for (let j = 0; j < ends.length; j++) {
      if (j === i || used.has(j) || ends[j].w === ends[i].w || ends[j].horiz === ends[i].horiz || !onEdge(ends[j].p)) continue;
      const d = Math.hypot(ends[i].p.x - ends[j].p.x, ends[i].p.y - ends[j].p.y);
      if (d > 0.3 && d < bd) { bd = d; best = j; }
    }
    if (best < 0) continue;
    used.add(i); used.add(best);
    const a = ends[i].p, b = ends[best].p;
    // Kính cong: cung 1/4 elip từ đầu tường này sang đầu tường kia, tâm là góc phía trong
    const cx = (minX + maxX) / 2, cy = (minY + maxY) / 2;
    const c1 = { x: b.x, y: a.y }, c2 = { x: a.x, y: b.y };
    const outer = Math.hypot(c1.x - cx, c1.y - cy) > Math.hypot(c2.x - cx, c2.y - cy) ? c1 : c2;
    const center = outer === c1 ? c2 : c1;
    // Chọn đầu nằm cùng hàng với góc ngoài theo trục y làm điểm bắt đầu
    const start = Math.abs(a.y - outer.y) < Math.abs(b.y - outer.y) ? a : b;
    const end = start === a ? b : a;
    const ry = start.y - center.y, rx = end.x - center.x;
    const N = bd > 1.2 ? 6 : 3;
    let prev = { ...start };
    for (let k = 1; k <= N; k++) {
      const th = (k / N) * (Math.PI / 2);
      const p = k === N ? { ...end } : { x: +(center.x + rx * Math.sin(th)).toFixed(3), y: +(center.y + ry * Math.cos(th)).toFixed(3) };
      const wall = { id: uid(), a: prev, b: p, thickness: 0.08 };
      walls.push(wall);
      const len = Math.hypot(p.x - prev.x, p.y - prev.y);
      if (len > 0.25) openings.push({ id: uid(), wallId: wall.id, type: 'window', t: 0.5, width: +(len - 0.04).toFixed(2), height: 2.45, sill: 0.15, glass: true });
      prev = p;
    }
  }
}

function otsu(hist, total) {
  let sum = 0;
  for (let i = 0; i < 256; i++) sum += i * hist[i];
  let sumB = 0, wB = 0, best = 0, thr = 127;
  for (let t = 0; t < 256; t++) {
    wB += hist[t];
    if (!wB) continue;
    const wF = total - wB;
    if (!wF) break;
    sumB += t * hist[t];
    const mB = sumB / wB, mF = (sum - sumB) / wF;
    const v = wB * wF * (mB - mF) * (mB - mF);
    if (v > best) { best = v; thr = t; }
  }
  return thr;
}

function runLengths(m, W, H, horizontal) {
  const out = new Uint16Array(W * H);
  if (horizontal) {
    for (let y = 0; y < H; y++) {
      let x = 0;
      while (x < W) {
        if (!m[y * W + x]) { x++; continue; }
        let e = x;
        while (e < W && m[y * W + e]) e++;
        const L = Math.min(65535, e - x);
        for (let i = x; i < e; i++) out[y * W + i] = L;
        x = e;
      }
    }
  } else {
    for (let x = 0; x < W; x++) {
      let y = 0;
      while (y < H) {
        if (!m[y * W + x]) { y++; continue; }
        let e = y;
        while (e < H && m[e * W + x]) e++;
        const L = Math.min(65535, e - y);
        for (let i = y; i < e; i++) out[i * W + x] = L;
        y = e;
      }
    }
  }
  return out;
}

/** Co (erode=true) hoặc giãn bằng ảnh tích phân, nhân vuông k */
function morph(m, W, H, k, erode) {
  const I = new Uint32Array((W + 1) * (H + 1));
  for (let y = 0; y < H; y++) {
    let row = 0;
    for (let x = 0; x < W; x++) {
      row += m[y * W + x];
      I[(y + 1) * (W + 1) + x + 1] = I[y * (W + 1) + x + 1] + row;
    }
  }
  const out = new Uint8Array(W * H);
  const r0 = Math.floor((k - 1) / 2), r1 = k - 1 - r0;
  for (let y = 0; y < H; y++)
    for (let x = 0; x < W; x++) {
      const xa = Math.max(0, x - r0), xb = Math.min(W, x + r1 + 1), ya = Math.max(0, y - r0), yb = Math.min(H, y + r1 + 1);
      const s = I[yb * (W + 1) + xb] - I[ya * (W + 1) + xb] - I[yb * (W + 1) + xa] + I[ya * (W + 1) + xa];
      out[y * W + x] = erode ? (s === (xb - xa) * (yb - ya) ? 1 : 0) : s > 0 ? 1 : 0;
    }
  return out;
}

/** Thành phần liên thông -> đoạn tường ngang/dọc (toạ độ pixel, tim tường) */
function components(m, W, H, dir, minLen) {
  const seen = new Uint8Array(W * H);
  const segs = [];
  const stack = [];
  for (let s = 0; s < W * H; s++) {
    if (!m[s] || seen[s]) continue;
    let minX = W, maxX = 0, minY = H, maxY = 0, n = 0;
    stack.push(s); seen[s] = 1;
    while (stack.length) {
      const k = stack.pop();
      const x = k % W, y = (k - x) / W;
      n++;
      if (x < minX) minX = x; if (x > maxX) maxX = x; if (y < minY) minY = y; if (y > maxY) maxY = y;
      for (const q of [x > 0 ? k - 1 : -1, x < W - 1 ? k + 1 : -1, y > 0 ? k - W : -1, y < H - 1 ? k + W : -1])
        if (q >= 0 && m[q] && !seen[q]) { seen[q] = 1; stack.push(q); }
    }
    if (dir === 'h') {
      const len = maxX - minX + 1;
      if (len < minLen) continue;
      segs.push({ dir, c: (minY + maxY + 1) / 2, s: minX, e: maxX + 1, t: n / len });
    } else {
      const len = maxY - minY + 1;
      if (len < minLen) continue;
      segs.push({ dir, c: (minX + maxX + 1) / 2, s: minY, e: maxY + 1, t: n / len });
    }
  }
  return segs;
}

function mergeCollinear(segs, mode) {
  const out = [];
  for (const dir of ['h', 'v']) {
    const list = segs.filter((s) => s.dir === dir).sort((a, b) => a.c - b.c || a.s - b.s);
    const used = new Array(list.length).fill(false);
    for (let i = 0; i < list.length; i++) {
      if (used[i]) continue;
      const cur = { ...list[i] };
      used[i] = true;
      let changed = true;
      while (changed) {
        changed = false;
        for (let j = 0; j < list.length; j++) {
          if (used[j]) continue;
          const o = list[j];
          if (Math.abs(o.c - cur.c) > Math.max(cur.t, o.t) * 0.5) continue;
          // Chồng lấn hoặc khe rất nhỏ => gộp
          if (o.s <= cur.e + mode * 0.6 && o.e >= cur.s - mode * 0.6) {
            const L1 = cur.e - cur.s, L2 = o.e - o.s;
            cur.c = (cur.c * L1 + o.c * L2) / (L1 + L2);
            cur.t = Math.max(cur.t, o.t);
            cur.s = Math.min(cur.s, o.s); cur.e = Math.max(cur.e, o.e);
            used[j] = true;
            changed = true;
          }
        }
      }
      out.push(cur);
    }
  }
  return out;
}

/** Kéo dài đầu tường tới tim tường vuông góc gần nhất để khép góc chữ L / chữ T */
function joinCorners(segs, tol) {
  for (const a of segs) {
    for (const endKey of ['s', 'e']) {
      let best = null, bd = tol;
      for (const b of segs) {
        if (b.dir === a.dir) continue;
        // a.c nằm trong khoảng của b (có dung sai)
        if (a.c < b.s - tol || a.c > b.e + tol) continue;
        const d = Math.abs(a[endKey] - b.c);
        // Chỉ kéo dài ra ngoài, hoặc lùi vào tối đa nửa bề dày tường kia (tránh làm sụp đoạn ngắn)
        const inward = endKey === 's' ? b.c - a.s : a.e - b.c;
        if (inward > b.t * 0.75) continue;
        if (d < bd) { bd = d; best = b; }
      }
      if (best) {
        a[endKey] = best.c;
        // Nếu tường b cũng hụt tới a thì kéo b tới tim a
        if (a.c < best.s) best.s = a.c;
        if (a.c > best.e) best.e = a.c;
      }
    }
  }
}

function buildWithOpenings(segs, mode, sx, sy, toW) {
  const walls = [], openings = [];
  for (const dir of ['h', 'v']) {
    // Tường ngang: dài theo x, dày theo y (và ngược lại)
    const along = dir === 'h' ? sx : sy, across = dir === 'h' ? sy : sx;
    const thicknessM = (t) => Math.max(0.08, Math.min(0.4, Math.round(t * across * 100) / 100));
    const list = segs.filter((s) => s.dir === dir).sort((a, b) => a.c - b.c || a.s - b.s);
    // Nhóm các đoạn thẳng hàng, xét khe hở giữa chúng
    const groups = [];
    for (const s of list) {
      const g = groups.find((gr) => Math.abs(gr[0].c - s.c) <= Math.max(gr[0].t, s.t) * 0.6);
      if (g) g.push(s); else groups.push([s]);
    }
    for (const g of groups) {
      g.sort((a, b) => a.s - b.s);
      let run = [g[0]];
      const flush = () => {
        const s0 = run[0].s, e0 = Math.max(...run.map((r) => r.e));
        const c = run.reduce((acc, r) => acc + r.c * (r.e - r.s), 0) / run.reduce((acc, r) => acc + (r.e - r.s), 0);
        const t = Math.max(...run.map((r) => r.t));
        const a = dir === 'h' ? toW(s0, c) : toW(c, s0), b = dir === 'h' ? toW(e0, c) : toW(c, e0);
        const wall = { id: uid(), a, b, thickness: thicknessM(t) };
        walls.push(wall);
        const L = e0 - s0;
        for (let i = 0; i < run.length - 1; i++) {
          const gs = run[i].e, ge = run[i + 1].s;
          const gap = ge - gs;
          const widthM = gap * along;
          const isDoor = widthM <= 1.2;
          openings.push({
            id: uid(), wallId: wall.id, type: isDoor ? 'door' : 'window',
            t: ((gs + ge) / 2 - s0) / L, width: +widthM.toFixed(2),
            height: isDoor ? 2.1 : 1.3, sill: isDoor ? 0 : 0.9,
          });
        }
      };
      for (let i = 1; i < g.length; i++) {
        const prev = run[run.length - 1], s = g[i];
        const gap = s.s - prev.e;
        const gapM = gap * along;
        if (gapM > 0.5 && gapM < 3.6) run.push(s);
        else { flush(); run = [s]; }
      }
      flush();
    }
  }
  return { walls, openings };
}
