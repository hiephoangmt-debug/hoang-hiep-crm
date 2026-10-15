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
  const thr = Math.min(otsu(hist, W * H), opts.threshold ?? 150);
  const dark = new Uint8Array(W * H);
  for (let i = 0; i < W * H; i++) dark[i] = gray[i] < thr ? 1 : 0;

  // Ước lượng bề dày tường = mốt của min(chiều dài vệt ngang, vệt dọc) trong số các nét dày
  const hRun = runLengths(dark, W, H, true), vRun = runLengths(dark, W, H, false);
  const th = new Array(200).fill(0);
  for (let i = 0; i < W * H; i++) if (dark[i]) { const t = Math.min(hRun[i], vRun[i]); if (t >= 3 && t < 200) th[t] += t; }
  let mode = 0, mv = 0;
  for (let t = 3; t < 200; t++) { const v = th[t] + (th[t - 1] || 0) * 0.5 + (th[t + 1] || 0) * 0.5; if (v > mv) { mv = v; mode = t; } }
  if (!mode) return { walls: [], openings: [], message: 'Không tìm thấy nét tường dày trong ảnh.' };
  const k = Math.max(2, Math.round(mode * 0.6));

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
  if (!bg?.calibrated) { mpp = (0.2 / mode) * f; autoScale = true; }
  const scale = mpp / f; // mét trên mỗi pixel ảnh thu nhỏ
  const ox = bg?.x ?? 0, oy = bg?.y ?? 0;
  const toW = (x, y) => ({ x: +(ox + x * scale).toFixed(3), y: +(oy + y * scale).toFixed(3) });

  const { walls, openings } = buildWithOpenings(segs, mode, scale, toW);
  return { walls, openings, autoScale, mpp: mpp, thicknessPx: mode / f, message: `Nhận diện ${walls.length} bức tường, ${openings.length} cửa/cửa sổ.` };
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

function buildWithOpenings(segs, mode, scale, toW) {
  const walls = [], openings = [];
  const thicknessM = (t) => Math.max(0.08, Math.min(0.4, Math.round(t * scale * 100) / 100));
  for (const dir of ['h', 'v']) {
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
          const widthM = gap * scale;
          const isDoor = widthM <= 1.05;
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
        if (gap > mode * 2.2 && gap < mode * 14) run.push(s);
        else { flush(); run = [s]; }
      }
      flush();
    }
  }
  return { walls, openings };
}
