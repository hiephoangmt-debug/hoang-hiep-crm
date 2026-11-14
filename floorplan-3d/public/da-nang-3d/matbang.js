// Xem mặt bằng tầng / layout căn của dự án: lưới ảnh nhỏ theo nhóm, chạm để xem lớn,
// phóng to bằng lăn chuột / chụm 2 ngón / chạm đúp, kéo để di chuyển, ← → để chuyển ảnh.
const CSS = `
.mb { position: fixed; inset: 0; z-index: 9; background: #0b1220f7; color: #eef2ff; display: flex; flex-direction: column; font-family: Inter, system-ui, sans-serif; }
.mb .hd { display: flex; align-items: center; gap: 8px; padding: max(10px, env(safe-area-inset-top)) 12px 8px 16px; }
.mb .hd h2 { margin: 0; font-size: 16px; flex: 1; }
.mb .x { border: 0; background: #ffffff24; color: #fff; border-radius: 999px; width: 34px; height: 34px; font-size: 15px; cursor: pointer; flex: none; }
.mb .tabs { display: flex; gap: 6px; padding: 0 16px 10px; overflow-x: auto; scrollbar-width: none; }
.mb .grid { flex: 1; overflow: auto; padding: 0 16px max(16px, env(safe-area-inset-bottom)); display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; align-content: start; }
.mb .grid button { border: 0; padding: 0; background: #fff; border-radius: 10px; overflow: hidden; cursor: pointer; text-align: left; color: #111827; }
.mb .grid img { display: block; width: 100%; aspect-ratio: 1.414; object-fit: contain; background: #fff; }
.mb .grid span { display: block; padding: 7px 9px; font: 600 12px Inter, sans-serif; background: #f3f4f6; }
.mb .zv { position: fixed; inset: 0; z-index: 10; background: #fff; touch-action: none; overflow: hidden; }
.mb .zv img { position: absolute; left: 0; top: 0; transform-origin: 0 0; user-select: none; -webkit-user-drag: none; max-width: none; }
.mb .zv .bar { position: absolute; left: 0; right: 0; bottom: 0; display: flex; align-items: center; gap: 6px; padding: 10px 12px max(10px, env(safe-area-inset-bottom)); background: #0b1220e6; color: #fff; }
.mb .zv .bar b { flex: 1; font-size: 13px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.mb .zv .x { position: absolute; top: max(10px, env(safe-area-inset-top)); right: 12px; background: #0b1220b3; }
.mb .zv .ld { position: absolute; inset: 0; display: grid; place-items: center; color: #6b7280; font-size: 13px; pointer-events: none; }
`;

let V = null;
export function openPlans(P, group = 0) {
  if (!V) V = make();
  V.show(P, group);
}

function make() {
  const st = document.createElement('style'); st.textContent = CSS; document.head.appendChild(st);
  const root = document.createElement('div'); root.className = 'mb'; root.hidden = true;
  root.innerHTML = `<div class="hd"><h2></h2><button class="x" aria-label="Đóng">✕</button></div><div class="tabs"></div><div class="grid"></div>
    <div class="zv" hidden><div class="ld">Đang tải ảnh…</div><img alt="" /><button class="x" aria-label="Đóng">✕</button>
      <div class="bar"><button class="chip" data-d="-1">‹</button><b></b><button class="chip" data-d="1">›</button><a class="chip" target="_blank" rel="noopener">⤓</a></div></div>`;
  document.body.appendChild(root);
  const $ = (s) => root.querySelector(s);
  const zv = $('.zv'), img = $('.zv img'), cap = $('.zv b'), dl = $('.zv a'), ld = $('.ld');
  let P = null, items = [], idx = 0;
  const z = { s: 1, x: 0, y: 0, min: 1 };

  function show(Pr, g) {
    P = Pr; $('h2').textContent = '📐 Mặt bằng · ' + P.name;
    const tabs = $('.tabs'); tabs.textContent = '';
    P.plans.groups.forEach(([name], i) => { const b = document.createElement('button'); b.className = 'chip' + (i === g ? ' active' : ''); b.textContent = name; b.onclick = () => show(P, i); tabs.appendChild(b); });
    items = P.plans.groups[g][1];
    const grid = $('.grid'); grid.textContent = ''; grid.scrollTop = 0;
    items.forEach(([f, label], i) => {
      const b = document.createElement('button');
      b.innerHTML = '<img loading="lazy" alt="" /><span></span>';
      b.firstChild.src = P.plans.dir + f + '-nho.webp'; b.firstChild.alt = label; b.lastChild.textContent = label;
      b.onclick = () => zoom(i); grid.appendChild(b);
    });
    root.hidden = false;
  }

  function apply() { img.style.transform = `translate(${z.x}px, ${z.y}px) scale(${z.s})`; }
  function fit() {
    const W = innerWidth, H = innerHeight - 56, w = img.naturalWidth, h = img.naturalHeight;
    if (!w) return;
    z.min = z.s = Math.min(W / w, H / h); z.x = (W - w * z.s) / 2; z.y = (H - h * z.s) / 2; apply();
  }
  function zoomAt(k, cx, cy) {
    const s = Math.min(Math.max(z.s * k, z.min), z.min * 12); k = s / z.s;
    z.x = cx - (cx - z.x) * k; z.y = cy - (cy - z.y) * k; z.s = s; apply();
  }
  function zoom(i) {
    idx = (i + items.length) % items.length;
    const [f, label] = items[idx];
    cap.textContent = `${label}  (${idx + 1}/${items.length})`;
    dl.href = P.plans.dir + f + '.webp';
    ld.hidden = false; img.style.visibility = 'hidden';
    img.onload = () => { ld.hidden = true; img.style.visibility = ''; fit(); };
    img.src = P.plans.dir + f + '.webp'; zv.hidden = false;
  }

  // kéo / chụm / lăn / chạm đúp
  const ptr = new Map(); let pinch = null, lastTap = 0;
  zv.addEventListener('pointerdown', (e) => {
    if (e.target.closest('.bar, .x')) return;
    zv.setPointerCapture(e.pointerId); ptr.set(e.pointerId, [e.clientX, e.clientY]);
    if (ptr.size === 2) { const [a, b] = [...ptr.values()]; pinch = { d: Math.hypot(a[0] - b[0], a[1] - b[1]) }; }
    const now = performance.now();
    if (ptr.size === 1 && now - lastTap < 300) zoomAt(z.s > z.min * 1.5 ? z.min / z.s : 3, e.clientX, e.clientY);
    lastTap = now;
  });
  zv.addEventListener('pointermove', (e) => {
    if (!ptr.has(e.pointerId)) return;
    const [px, py] = ptr.get(e.pointerId); ptr.set(e.pointerId, [e.clientX, e.clientY]);
    if (ptr.size === 2 && pinch) {
      const [a, b] = [...ptr.values()], d = Math.hypot(a[0] - b[0], a[1] - b[1]);
      zoomAt(d / pinch.d, (a[0] + b[0]) / 2, (a[1] + b[1]) / 2); pinch.d = d; return;
    }
    z.x += e.clientX - px; z.y += e.clientY - py; apply();
  });
  const up = (e) => { ptr.delete(e.pointerId); if (ptr.size < 2) pinch = null; };
  zv.addEventListener('pointerup', up); zv.addEventListener('pointercancel', up);
  zv.addEventListener('wheel', (e) => { e.preventDefault(); zoomAt(Math.exp(-e.deltaY * 0.0015), e.clientX, e.clientY); }, { passive: false });
  addEventListener('resize', () => { if (!zv.hidden) fit(); });

  root.querySelectorAll('.bar [data-d]').forEach((b) => (b.onclick = () => zoom(idx + +b.dataset.d)));
  $('.zv .x').onclick = () => (zv.hidden = true);
  $('.hd .x').onclick = () => (root.hidden = true);
  addEventListener('keydown', (e) => {
    if (root.hidden) return;
    if (e.key === 'Escape') { if (!zv.hidden) zv.hidden = true; else root.hidden = true; }
    else if (!zv.hidden && (e.key === 'ArrowRight' || e.key === 'ArrowLeft')) zoom(idx + (e.key === 'ArrowRight' ? 1 : -1));
  });
  return { show };
}
