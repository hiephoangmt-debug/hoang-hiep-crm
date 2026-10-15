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
export function exportImage({ renderer, scene, camera, render, keepRatio = false, scale = 2, title = '', lines = [], note = '' }) {
  const p0 = renderer.getPixelRatio();
  const k = keepRatio ? 1 : scale;
  if (k !== 1) renderer.setPixelRatio(p0 * k);
  render(k);
  const src = renderer.domElement;
  const W = src.width, H = src.height, s = W / (src.clientWidth || W);
  const band = Math.round(84 * s);
  const c = document.createElement('canvas');
  c.width = W; c.height = H + band;
  const x = c.getContext('2d');
  x.fillStyle = '#ffffff'; x.fillRect(0, 0, c.width, c.height);
  x.drawImage(src, 0, 0);
  if (k !== 1) { renderer.setPixelRatio(p0); render(1); }
  // Nhãn CSS (tên phòng, mã căn, tên tòa…) đang hiện trên màn hình
  const v = new THREE.Vector3();
  x.textAlign = 'center'; x.textBaseline = 'middle';
  scene.traverse((o) => {
    if (!o.isCSS2DObject || !o.element || o.element.style.display === 'none') return;
    let vis = true; o.traverseAncestors((a) => { if (!a.visible) vis = false; });
    if (!vis || !o.visible) return;
    o.getWorldPosition(v).project(camera);
    if (v.z > 1 || Math.abs(v.x) > 1 || Math.abs(v.y) > 1) return;
    const px = (v.x * 0.5 + 0.5) * W, py = (-v.y * 0.5 + 0.5) * H;
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
  // Khung tên
  x.fillStyle = '#c8812a'; x.fillRect(0, H, Math.round(10 * s), band);
  x.textAlign = 'left'; x.textBaseline = 'alphabetic';
  x.fillStyle = '#1d2330'; x.font = `800 ${Math.round(22 * s)}px Inter, Arial, sans-serif`;
  x.fillText(title, 24 * s, H + 34 * s);
  x.fillStyle = '#4a5160'; x.font = `500 ${Math.round(13 * s)}px Inter, Arial, sans-serif`;
  x.fillText(lines.join('   ·   '), 24 * s, H + 60 * s);
  x.textAlign = 'right'; x.fillStyle = '#8a8f99'; x.font = `italic ${Math.round(11 * s)}px Inter, Arial, sans-serif`;
  x.fillText(note || 'Hình ảnh chỉ mang tính chất minh hoạ', W - 20 * s, H + 60 * s);
  return new Promise((res) => c.toBlob(res, 'image/png'));
}
