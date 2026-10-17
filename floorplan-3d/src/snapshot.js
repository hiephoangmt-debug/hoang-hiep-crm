// Xuất ảnh PNG nét cao từ khung 3D: ảnh render + nhãn đang hiện (tên phòng, mã căn) + khung tên ở dưới.
import * as THREE from 'three';

function roundRect(x, X, Y, w, h, r) {
  x.beginPath();
  x.moveTo(X + r, Y); x.arcTo(X + w, Y, X + w, Y + h, r); x.arcTo(X + w, Y + h, X, Y + h, r);
  x.arcTo(X, Y + h, X, Y, r); x.arcTo(X, Y, X + w, Y, r); x.closePath();
}

/**
 * renderer, scene, camera: của khung 3D; render(): vẽ lại một khung hình (đã gồm hậu kỳ);
 * keepRatio: true khi đang path tracing (không đổi độ phân giải để khỏi mất các lượt đã tích luỹ);
 * title / lines / note: chữ ở khung tên.
 */
export function exportImage({ renderer, scene, camera, render, source = null, keepRatio = false, scale = 2, title = '', lines = [], note = '', callouts = null, plan = null, frame = null, focus = null, ad = null }) {
  // frame: { W, H, side, band, s } – khung ảnh cố định (vd. 5:6); người gọi đã render vào canvas cỡ (W − 2·side) × (H − band)
  let W, H, s, band, side, src = source || renderer.domElement;
  const p0 = renderer.getPixelRatio();
  const k = keepRatio || frame ? 1 : scale;
  if (k !== 1) renderer.setPixelRatio(p0 * k);
  render(k);
  if (frame) { s = frame.s; side = frame.side; band = frame.band; W = frame.W - 2 * side; H = frame.H - band; }
  else { W = src.width; H = src.height; s = W / (src.clientWidth || W); band = Math.round(84 * s); side = callouts ? Math.round(230 * s) : 0; }
  const c = document.createElement('canvas');
  c.width = W + side * 2; c.height = H + band;
  const x = c.getContext('2d');
  x.fillStyle = '#ffffff'; x.fillRect(0, 0, c.width, c.height);
  x.fillStyle = '#dcdcdc'; x.fillRect(0, 0, c.width, H);
  // Ảnh render: thu trọn vào vùng giữa (khi đang path tracing không đổi được cỡ khung nên không cắt, chừa nền)
  // focus: các điểm 3D cần giữ trong ảnh (góc căn) → chỉ lấy vùng quanh chúng rồi phóng cho vừa khung
  // cỡ khung lúc vừa render (nét cao) – phải giữ lại vì trả pixel ratio về cũ sẽ làm canvas nhỏ lại
  const srcW = src.width, srcH = src.height;
  let sx = 0, sy = 0, sw = srcW, sh = srcH;
  if (focus) {
    const q = new THREE.Vector3();
    const pts = focus.map((p) => { q.set(p.x, p.y, p.z).project(camera); return [(q.x * 0.5 + 0.5) * src.width, (-q.y * 0.5 + 0.5) * src.height]; });
    const x0 = Math.min(...pts.map((p) => p[0])), x1 = Math.max(...pts.map((p) => p[0])), y0 = Math.min(...pts.map((p) => p[1])), y1 = Math.max(...pts.map((p) => p[1]));
    let w = (x1 - x0) * 1.12, h = (y1 - y0) * 1.12;
    if (w / h < W / H) w = h * W / H; else h = w * H / W; // giữ đúng tỉ lệ vùng giữa
    sx = (x0 + x1) / 2 - w / 2; sy = (y0 + y1) / 2 - h / 2; sw = w; sh = h;
  }
  const sc = Math.min(W / sw, H / sh), dw = sw * sc, dh = sh * sc;
  {
    // vùng lấy có thể vượt khỏi khung render → tô trước bằng đúng màu nền ảnh render (lấy ở góc)
    const t = document.createElement('canvas'); t.width = t.height = 1;
    const tx = t.getContext('2d'); tx.drawImage(src, 2, 2, 1, 1, 0, 0, 1, 1);
    const d = tx.getImageData(0, 0, 1, 1).data;
    x.fillStyle = `rgb(${d[0]},${d[1]},${d[2]})`; x.fillRect(0, 0, c.width, H);
  }
  x.drawImage(src, sx, sy, sw, sh, side + (W - dw) / 2, (H - dh) / 2, dw, dh);
  const crop = { ox: side + (W - dw) / 2 - sx * sc, oy: (H - dh) / 2 - sy * sc, sc };
  if (k !== 1) { renderer.setPixelRatio(p0); render(1); }
  const v = new THREE.Vector3();
  const toScreen = (p) => { v.set(p.x, p.y, p.z).project(camera); return { x: crop.ox + (v.x * 0.5 + 0.5) * srcW * crop.sc, y: crop.oy + (-v.y * 0.5 + 0.5) * srcH * crop.sc }; };
  if (callouts && ad) drawAdCallouts(x, callouts, toScreen, s, W, H, side);
  else if (callouts) drawCallouts(x, callouts, plan, toScreen, s, W, H, side);
  // Nhãn CSS (tên phòng, mã căn, tên tòa…) đang hiện trên màn hình
  if (!callouts) {
  x.textAlign = 'center'; x.textBaseline = 'middle';
  scene.traverse((o) => {
    if (!o.isCSS2DObject || !o.element || o.element.style.display === 'none') return;
    let vis = true; o.traverseAncestors((a) => { if (!a.visible) vis = false; });
    if (!vis || !o.visible) return;
    o.getWorldPosition(v).project(camera);
    if (v.z > 1 || Math.abs(v.x) > 1 || Math.abs(v.y) > 1) return;
    const px = crop.ox + (v.x * 0.5 + 0.5) * srcW * crop.sc, py = crop.oy + (-v.y * 0.5 + 0.5) * srcH * crop.sc;
    const parts = [...o.element.querySelectorAll('b, span, small')].map((e) => e.textContent.trim()).filter(Boolean);
    const rows = parts.length ? parts : [o.element.textContent.trim()].filter(Boolean);
    if (!rows.length) return;
    const f1 = Math.round(12 * s), f2 = Math.round(10.5 * s);
    x.font = `700 ${f1}px Inter, Arial, sans-serif`;
    const w = Math.max(...rows.map((t, i) => { x.font = `${i ? 500 : 700} ${i ? f2 : f1}px Inter, Arial, sans-serif`; return x.measureText(t).width; })) + 14 * s;
    const h = (f1 + (rows.length - 1) * (f2 + 3 * s)) + 10 * s;
    x.fillStyle = 'rgba(30,34,42,.78)'; roundRect(x, px - w / 2, py - h / 2, w, h, 6 * s); x.fill();
    x.fillStyle = '#fff';
    let yy = py - h / 2 + 5 * s + f1 / 2;
    rows.forEach((t, i) => { x.font = `${i ? 500 : 700} ${i ? f2 : f1}px Inter, Arial, sans-serif`; x.fillText(t, px, yy); yy += (i ? f2 : f1) / 2 + 3 * s + f2 / 2; });
  });
  }
  if (ad) {
    // Kiểu quảng cáo: nền kem liền, câu chốt chữ viết tay ở giữa, tên căn nhỏ bên dưới
    x.fillStyle = '#fbf8f2'; x.fillRect(0, H, c.width, band);
    const cx = c.width / 2;
    x.textAlign = 'center'; x.textBaseline = 'alphabetic'; x.fillStyle = '#2f3a2c';
    x.font = `700 ${Math.round(30 * s)}px 'Dancing Script', 'Brush Script MT', cursive`;
    const tw = x.measureText(ad.title).width;
    x.fillText(ad.title, cx, H + 36 * s);
    x.strokeStyle = '#2f3a2c'; x.lineWidth = 1.2 * s;
    for (const d of [-1, 1]) { x.beginPath(); x.moveTo(cx + d * (tw / 2 + 14 * s), H + 26 * s); x.lineTo(cx + d * (tw / 2 + 70 * s), H + 26 * s); x.stroke(); }
    x.fillStyle = '#5d6656'; x.font = `500 ${Math.round(13 * s)}px Inter, Arial, sans-serif`;
    x.fillText(ad.line, cx, H + 58 * s);
    x.fillStyle = '#8a8f99'; x.font = `500 ${Math.round(11 * s)}px Inter, Arial, sans-serif`;
    x.fillText([title, ...lines.slice(0, 2)].join('  ·  '), cx, H + 76 * s);
    return new Promise((res) => c.toBlob(res, 'image/png'));
  }
  // Khung tên
  x.fillStyle = '#c8812a'; x.fillRect(0, H, Math.round(10 * s), band);
  x.textAlign = 'left'; x.textBaseline = 'alphabetic';
  x.fillStyle = '#1d2330'; x.font = `800 ${Math.round(22 * s)}px Inter, Arial, sans-serif`;
  x.fillText(title, 24 * s, H + 34 * s);
  x.fillStyle = '#4a5160';
  // chữ dòng thông số co lại nếu dài, không chồng lên dòng ghi chú bên phải
  const lineTxt = lines.filter(Boolean).join('   ·   ');
  const maxW = c.width - 24 * s - 260 * s;
  let fz = 13;
  do { x.font = `500 ${Math.round(fz * s)}px Inter, Arial, sans-serif`; fz -= 0.5; } while (x.measureText(lineTxt).width > maxW && fz > 8);
  x.fillText(lineTxt, 24 * s, H + 60 * s);
  x.textAlign = 'right'; x.fillStyle = '#8a8f99'; x.font = `italic ${Math.round(11 * s)}px Inter, Arial, sans-serif`;
  x.fillText(note || 'Hình ảnh chỉ mang tính chất minh hoạ', c.width - 20 * s, H + 60 * s);
  return new Promise((res) => c.toBlob(res, 'image/png'));
}

const fmtM = (n, d = 2) => n.toLocaleString('vi-VN', { minimumFractionDigits: d, maximumFractionDigits: d });

/** Chú thích phòng đặt ra ngoài mặt bằng (2 bên), có đường dẫn; kèm đường kích thước tổng của căn */
export function drawCallouts(x, callouts, plan, toScreen, s, W, H, side, noDims = false) {
  const P = plan.corners.map(toScreen); // 4 góc mặt bằng ở cao độ sàn
  const L = Math.min(...P.map((p) => p.x)), R = Math.max(...P.map((p) => p.x));
  const T = Math.min(...P.map((p) => p.y)), B = Math.max(...P.map((p) => p.y));
  const cx = (L + R) / 2;
  // --- Đường kích thước tổng (mm) phía trên và bên phải
  x.strokeStyle = '#3b3f47'; x.fillStyle = '#3b3f47'; x.lineWidth = 1.2 * s;
  // Đường kích thước chạy song song cạnh căn (đẩy ra ngoài 18 px), chữ xoay theo cạnh
  const C = { x: P.reduce((a, p) => a + p.x, 0) / 4, y: P.reduce((a, p) => a + p.y, 0) / 4 };
  const dim = (A, Bp, txt) => {
    let nx = -(Bp.y - A.y), ny = Bp.x - A.x; const len = Math.hypot(nx, ny) || 1; nx /= len; ny /= len;
    const mid = { x: (A.x + Bp.x) / 2, y: (A.y + Bp.y) / 2 };
    if ((mid.x - C.x) * nx + (mid.y - C.y) * ny < 0) { nx = -nx; ny = -ny; }
    const o = 20 * s, a = { x: A.x + nx * o, y: A.y + ny * o }, b = { x: Bp.x + nx * o, y: Bp.y + ny * o };
    x.beginPath(); x.moveTo(a.x, a.y); x.lineTo(b.x, b.y); x.stroke();
    for (const p of [a, b]) { x.beginPath(); x.moveTo(p.x - 4 * s, p.y + 4 * s); x.lineTo(p.x + 4 * s, p.y - 4 * s); x.stroke(); }
    let ang = Math.atan2(b.y - a.y, b.x - a.x); if (ang > Math.PI / 2) ang -= Math.PI; if (ang < -Math.PI / 2) ang += Math.PI;
    x.save(); x.translate((a.x + b.x) / 2 + nx * 4 * s, (a.y + b.y) / 2 + ny * 4 * s); x.rotate(ang);
    x.font = `700 ${Math.round(13 * s)}px Inter, Arial, sans-serif`; x.textAlign = 'center'; x.textBaseline = 'middle';
    const tw = x.measureText(txt).width + 8 * s; x.fillStyle = 'rgba(220,220,220,.9)'; x.fillRect(-tw / 2, -8 * s, tw, 16 * s);
    x.fillStyle = '#3b3f47'; x.fillText(txt, 0, 0); x.restore();
  };
  // cạnh trên (độ rộng) = cạnh 0–1 hoặc 3–2, chọn cạnh nằm cao hơn trên ảnh; tương tự cạnh dọc bên phải
  const eW = (P[0].y + P[1].y) < (P[3].y + P[2].y) ? [P[0], P[1]] : [P[3], P[2]];
  const eD = (P[1].x + P[2].x) > (P[0].x + P[3].x) ? [P[1], P[2]] : [P[0], P[3]];
  if (!noDims) {
    dim(eW[0], eW[1], String(Math.round(plan.w * 1000)));
    dim(eD[0], eD[1], String(Math.round(plan.d * 1000)));
  }
  // --- Chú thích
  const f1 = Math.round(12.5 * s), f2 = Math.round(10.5 * s), bh = f1 + f2 + 14 * s, gap = 8 * s;
  const items = callouts.map((c) => ({ ...c, a: toScreen(c.anchor) }));
  for (const sideName of ['left', 'right']) {
    const g = items.filter((it) => (sideName === 'left') === (it.a.x < cx)).sort((p, q) => p.a.y - q.a.y);
    // Xếp dọc theo vị trí phòng, đẩy xuống khi chồng nhau, rồi kéo lên nếu tràn đáy
    let y = 10 * s;
    g.forEach((it) => { it.y = Math.max(it.a.y - bh / 2, y); y = it.y + bh + gap; });
    let over = y - gap - (H - 10 * s);
    for (let i = g.length - 1; i >= 0 && over > 0; i--) { const lim = i ? g[i - 1].y + bh + gap : 10 * s; const mv = Math.min(over, g[i].y - lim); g[i].y -= over; over = Math.max(0, over - mv); }
    g.forEach((it) => {
      x.font = `700 ${f1}px Inter, Arial, sans-serif`;
      const w1 = x.measureText(it.name).width;
      x.font = `500 ${f2}px Inter, Arial, sans-serif`;
      const sub = `${fmtM(it.area, 1)} m²  ·  ${fmtM(it.w)} × ${fmtM(it.d)} m`;
      const bw = Math.max(w1, x.measureText(sub).width) + 18 * s;
      const bx = sideName === 'left' ? Math.max(8 * s, Math.min(side - 8 * s, L - 46 * s) - bw) : Math.min(W + side * 2 - 8 * s - bw, Math.max(W + side + 8 * s, R + 46 * s));
      const by = it.y, ex = sideName === 'left' ? bx + bw : bx, ey = by + bh / 2;
      // đường dẫn + chấm ở tâm phòng
      x.strokeStyle = 'rgba(40,44,52,.75)'; x.lineWidth = 1.3 * s;
      x.beginPath(); x.moveTo(it.a.x, it.a.y); x.lineTo(sideName === 'left' ? L - 26 * s : R + 26 * s, ey); x.lineTo(ex, ey); x.stroke();
      x.fillStyle = '#c8812a'; x.beginPath(); x.arc(it.a.x, it.a.y, 4 * s, 0, Math.PI * 2); x.fill();
      x.strokeStyle = '#fff'; x.lineWidth = 1.5 * s; x.stroke();
      // hộp chữ
      x.fillStyle = '#ffffff'; x.strokeStyle = '#d7d2c8'; x.lineWidth = 1 * s;
      roundRect(x, bx, by, bw, bh, 6 * s); x.fill(); x.stroke();
      x.fillStyle = '#c8812a'; x.fillRect(sideName === 'left' ? bx + bw - 3 * s : bx, by + 5 * s, 3 * s, bh - 10 * s);
      x.textAlign = 'left'; x.textBaseline = 'top';
      x.fillStyle = '#1d2330'; x.font = `700 ${f1}px Inter, Arial, sans-serif`; x.fillText(it.name, bx + 9 * s, by + 6 * s);
      x.fillStyle = '#5a6070'; x.font = `500 ${f2}px Inter, Arial, sans-serif`; x.fillText(sub, bx + 9 * s, by + 8 * s + f1);
    });
  }
}

/** Chú thích kiểu quảng cáo: biểu tượng + tiêu đề chữ viết tay + gạch chân + câu lợi ích, mũi tên cong chỉ vào phòng */
export function drawAdCallouts(x, callouts, toScreen, s, W, H, side) {
  const items = callouts.map((c) => ({ ...c, a: toScreen(c.anchor) }));
  const cx = side + W / 2;
  const fT = Math.round(19 * s), fL = Math.round(11.5 * s), bh = 64 * s, gap = 14 * s;
  for (const sideName of ['left', 'right']) {
    const g = items.filter((it) => (sideName === 'left') === (it.a.x < cx)).sort((p, q) => p.a.y - q.a.y);
    let y = 30 * s;
    g.forEach((it) => { it.y = Math.max(it.a.y - bh * 0.6, y); y = it.y + bh + gap; });
    g.forEach((it) => {
      const left = sideName === 'left';
      const tx = left ? 22 * s : W + side * 2 - 22 * s;
      x.textAlign = left ? 'left' : 'right'; x.textBaseline = 'alphabetic';
      // biểu tượng
      x.font = `${Math.round(18 * s)}px 'Segoe UI Emoji', 'Apple Color Emoji', 'Noto Color Emoji', sans-serif`;
      x.fillStyle = '#2f3a2c';
      x.fillText(it.icon, tx, it.y + 18 * s);
      // tiêu đề viết tay + gạch chân
      x.font = `700 ${fT}px 'Dancing Script', 'Brush Script MT', cursive`;
      x.fillText(it.name, tx, it.y + 42 * s);
      const tw = x.measureText(it.name).width;
      x.strokeStyle = '#2f3a2c'; x.lineWidth = 1.1 * s;
      const ux0 = left ? tx : tx - tw - 30 * s, ux1 = left ? tx + tw + 30 * s : tx;
      x.beginPath(); x.moveTo(ux0, it.y + 48 * s); x.lineTo(ux1, it.y + 48 * s); x.stroke();
      // câu lợi ích
      x.fillStyle = '#4d5648'; x.font = `500 ${fL}px Inter, Arial, sans-serif`;
      x.fillText(it.sub, tx, it.y + 64 * s);
      // mũi tên cong từ cuối gạch chân tới phòng
      const sx = left ? ux1 : ux0, sy = it.y + 48 * s, ex = it.a.x + (left ? -6 : 6) * s, ey = it.a.y;
      const mx = (sx + ex) / 2, my = Math.min(sy, ey) - 30 * s;
      x.strokeStyle = 'rgba(47,58,44,.85)'; x.lineWidth = 1.4 * s;
      x.beginPath(); x.moveTo(sx, sy); x.quadraticCurveTo(mx, my, ex, ey); x.stroke();
      const ang = Math.atan2(ey - my, ex - mx), hl = 9 * s;
      x.beginPath();
      x.moveTo(ex, ey); x.lineTo(ex - hl * Math.cos(ang - 0.45), ey - hl * Math.sin(ang - 0.45));
      x.moveTo(ex, ey); x.lineTo(ex - hl * Math.cos(ang + 0.45), ey - hl * Math.sin(ang + 0.45));
      x.stroke();
    });
  }
}
