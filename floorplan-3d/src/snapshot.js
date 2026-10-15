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
export function exportImage({ renderer, scene, camera, render, keepRatio = false, scale = 2, title = '', lines = [], note = '', callouts = null, plan = null, frame = null }) {
  // frame: { W, H, side, band, s } – khung ảnh cố định (vd. 5:6); người gọi đã render vào canvas cỡ (W − 2·side) × (H − band)
  let W, H, s, band, side, src = renderer.domElement;
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
  // Ảnh render: vừa khít vùng giữa (cắt bớt nếu khác tỉ lệ – khi đang path tracing không đổi được cỡ khung)
  const sc = Math.max(W / src.width, H / src.height), dw = src.width * sc, dh = src.height * sc;
  x.drawImage(src, side + (W - dw) / 2, (H - dh) / 2, dw, dh);
  const crop = { ox: side + (W - dw) / 2, oy: (H - dh) / 2, sc };
  if (k !== 1) { renderer.setPixelRatio(p0); render(1); }
  const v = new THREE.Vector3();
  const toScreen = (p) => { v.set(p.x, p.y, p.z).project(camera); return { x: crop.ox + (v.x * 0.5 + 0.5) * src.width * crop.sc, y: crop.oy + (-v.y * 0.5 + 0.5) * src.height * crop.sc }; };
  if (callouts) drawCallouts(x, callouts, plan, toScreen, s, W, H, side);
  // Nhãn CSS (tên phòng, mã căn, tên tòa…) đang hiện trên màn hình
  if (!callouts) {
  x.textAlign = 'center'; x.textBaseline = 'middle';
  scene.traverse((o) => {
    if (!o.isCSS2DObject || !o.element || o.element.style.display === 'none') return;
    let vis = true; o.traverseAncestors((a) => { if (!a.visible) vis = false; });
    if (!vis || !o.visible) return;
    o.getWorldPosition(v).project(camera);
    if (v.z > 1 || Math.abs(v.x) > 1 || Math.abs(v.y) > 1) return;
    const px = crop.ox + (v.x * 0.5 + 0.5) * src.width * crop.sc, py = crop.oy + (-v.y * 0.5 + 0.5) * src.height * crop.sc;
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
  // Khung tên
  x.fillStyle = '#c8812a'; x.fillRect(0, H, Math.round(10 * s), band);
  x.textAlign = 'left'; x.textBaseline = 'alphabetic';
  x.fillStyle = '#1d2330'; x.font = `800 ${Math.round(22 * s)}px Inter, Arial, sans-serif`;
  x.fillText(title, 24 * s, H + 34 * s);
  x.fillStyle = '#4a5160'; x.font = `500 ${Math.round(13 * s)}px Inter, Arial, sans-serif`;
  x.fillText(lines.join('   ·   '), 24 * s, H + 60 * s);
  x.textAlign = 'right'; x.fillStyle = '#8a8f99'; x.font = `italic ${Math.round(11 * s)}px Inter, Arial, sans-serif`;
  x.fillText(note || 'Hình ảnh chỉ mang tính chất minh hoạ', c.width - 20 * s, H + 60 * s);
  return new Promise((res) => c.toBlob(res, 'image/png'));
}

const fmtM = (n, d = 2) => n.toLocaleString('vi-VN', { minimumFractionDigits: d, maximumFractionDigits: d });

/** Chú thích phòng đặt ra ngoài mặt bằng (2 bên), có đường dẫn; kèm đường kích thước tổng của căn */
function drawCallouts(x, callouts, plan, toScreen, s, W, H, side) {
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
  dim(eW[0], eW[1], String(Math.round(plan.w * 1000)));
  dim(eD[0], eD[1], String(Math.round(plan.d * 1000)));
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
