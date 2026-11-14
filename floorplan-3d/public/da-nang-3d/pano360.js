// Trình xem ảnh 360° flycam gắn toạ độ thật.
// Mỗi ảnh có lat/lon/độ cao (từ EXIF ảnh gốc) và heading (hướng của tâm ảnh so với Bắc).
// Nhãn địa danh, dự án, cầu, toà nhà cao… và ranh khu đất dự án được tự đặt lên ảnh
// bằng cách tính hướng + góc nhìn xuống từ vị trí flycam tới toạ độ của từng điểm.
import * as THREE from 'three';

const CSS = `
.p360 { position: fixed; inset: 0; z-index: 8; background: #000; touch-action: none; user-select: none; -webkit-user-select: none; }
.p360 canvas { display: block; width: 100%; height: 100%; cursor: grab; }
.p360 canvas:active { cursor: grabbing; }
.p360 .lbls { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.p360 .lb { position: absolute; transform: translate(-50%, -100%); display: flex; flex-direction: column; align-items: center; }
.p360 .lb b { font: 600 12px Inter, sans-serif; background: #5b3a1e; color: #fff; padding: 4px 9px; border-radius: 4px; white-space: nowrap; box-shadow: 0 2px 8px #0007; }
.p360 .lb small { font: 400 10px Inter, sans-serif; opacity: .85; margin-left: 5px; }
.p360 .lb.big b { font-size: 13px; background: #f2b33d; color: #241600; }
.p360 .lb.site b { font-size: 14px; background: #e5281f; color: #fff; }
.p360 .lb.far b { font-size: 11px; background: #111827cc; }
.p360 .lb span { width: 1.5px; height: 16px; background: linear-gradient(#fff, #fff0); }
.p360 .hd { position: absolute; top: 0; left: 0; right: 0; padding: max(10px, env(safe-area-inset-top)) 56px 14px 16px; background: linear-gradient(#000a, transparent); font: 13px Inter, sans-serif; pointer-events: none; }
.p360 .hd h2 { margin: 0 0 2px; font-size: 16px; }
.p360 .hd small { opacity: .85; }
.p360 .x { position: absolute; top: max(10px, env(safe-area-inset-top)); right: 12px; border: 0; background: #ffffff2b; color: #fff; border-radius: 999px; width: 34px; height: 34px; font-size: 15px; cursor: pointer; }
.p360 .ft { position: absolute; left: 0; right: 0; bottom: 0; padding: 18px 16px max(12px, env(safe-area-inset-bottom)); background: linear-gradient(transparent, #000b); }
.p360 .cmp { position: relative; height: 22px; margin: 0 auto 8px; max-width: 520px; overflow: hidden; font: 600 11px Inter, sans-serif; mask-image: linear-gradient(90deg, transparent, #000 20%, #000 80%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 20%, #000 80%, transparent); }
.p360 .cmp i { position: absolute; top: 4px; transform: translateX(-50%); font-style: normal; opacity: .75; }
.p360 .cmp i.c { color: #f59e0b; opacity: 1; }
.p360 .cmp:after { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: #f59e0b; }
.p360 .chips { display: flex; gap: 6px; overflow-x: auto; scrollbar-width: none; }
.p360 .chips::-webkit-scrollbar { display: none; }
`;

const DIRS = ['Bắc', 'Đông Bắc', 'Đông', 'Đông Nam', 'Nam', 'Tây Nam', 'Tây', 'Tây Bắc'];
const dirName = (b) => DIRS[Math.round((((b % 360) + 360) % 360) / 45) % 8];
const fmtKm = (m) => (m < 1000 ? Math.round(m / 10) * 10 + ' m' : (m / 1000).toFixed(m < 10000 ? 1 : 0).replace('.', ',') + ' km');

let V = null; // trình xem dùng chung (tạo 1 lần)

/**
 * Mở ảnh 360° của dự án P.
 * ctx = { LL(lat,lon)->[x,z], groundY(x,z), PLACES:[{name,pos,big,prj?}], onOpen(), onClose() }
 * Toạ độ thế giới: x = Đông (m), z = Nam (m), y = cao (m).
 */
export function openPano(P, idx, ctx) {
  if (!V) V = makeViewer(ctx);
  V.show(P, idx);
}

function makeViewer(ctx) {
  const st = document.createElement('style'); st.textContent = CSS; document.head.appendChild(st);
  const root = document.createElement('div'); root.className = 'p360'; root.hidden = true;
  root.innerHTML = `<div class="lbls"></div>
    <div class="hd"><h2></h2><small></small></div>
    <button class="x" aria-label="Đóng">✕</button>
    <div class="ft"><div class="cmp"></div><div class="chips"></div></div>`;
  document.body.appendChild(root);
  const $ = (s) => root.querySelector(s);
  const lblBox = $('.lbls'), cmp = $('.cmp'), chips = $('.chips');

  const renderer = new THREE.WebGLRenderer({ antialias: true });
  renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
  root.prepend(renderer.domElement);
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(75, 1, 0.5, 5000);
  camera.rotation.order = 'YXZ';
  // Mặt cầu ảnh: lật trong-ngoài; tâm ảnh (u = 0.5) nằm ở phía -x (hướng 270°)
  const sphGeo = new THREE.SphereGeometry(2000, 96, 48); sphGeo.scale(-1, 1, 1);
  const sphMat = new THREE.MeshBasicMaterial({ color: 0x222222 });
  const sphere = new THREE.Mesh(sphGeo, sphMat); scene.add(sphere);
  const overlay = new THREE.Group(); scene.add(overlay);   // ranh khu đất vẽ đè lên ảnh

  // hướng nhìn: yaw = góc so với Bắc (độ, theo chiều kim đồng hồ), pitch = ngẩng (+) / cúi (−)
  const view = { yaw: 0, pitch: -15, fov: 75 };
  let cur = null, P = null, labels = [], open = false, raf = 0, showLbl = true;
  const loader = new THREE.TextureLoader();
  const texCache = new Map();
  const loadTex = (url) => {
    if (texCache.has(url)) return texCache.get(url);
    const p = new Promise((res, rej) => loader.load(url, (t) => { t.colorSpace = THREE.SRGBColorSpace; t.anisotropy = 4; res(t); }, undefined, rej));
    texCache.set(url, p); return p;
  };

  function camPos(q) {
    const [x, z] = ctx.LL(q.lat, q.lon);
    return new THREE.Vector3(x, ctx.groundY(x, z) + q.alt, z);
  }
  // vector hướng từ flycam tới điểm (có tính độ cong Trái Đất + khúc xạ)
  function rel(C, x, y, z) {
    const dx = x - C.x, dz = z - C.z, h = Math.hypot(dx, dz);
    return { v: new THREE.Vector3(dx, y - C.y - (0.87 * h * h) / (2 * 6371000), dz), dist: h };
  }

  function buildLabels(C) {
    lblBox.textContent = ''; labels = [];
    const add = (name, v, dist, cls, prio) => {
      const el = document.createElement('div'); el.className = 'lb ' + cls;
      el.innerHTML = '<b></b><span></span>'; el.querySelector('b').textContent = name;
      if (dist > 400) { const s = document.createElement('small'); s.textContent = fmtKm(dist); el.querySelector('b').appendChild(s); }
      lblBox.appendChild(el);
      labels.push({ el, dir: v.clone().normalize(), prio, w: 0, h: 0 });
    };
    // khu đất của chính dự án: nhãn đỏ ở tâm khu đất
    const S = siteCenter();
    if (S) { const r = rel(C, S[0], ctx.groundY(S[0], S[1]) + 2, S[1]); add('📍 Khu đất ' + P.name, r.v, r.dist, 'site', 100); }
    const seen = new Set();
    for (const p of ctx.PLACES) {
      if (p.lotEdge || p.prj === P || p.pano) continue;
      const name = p.name.replace(/^🏢\s*/, '');
      if (seen.has(name)) continue; seen.add(name);
      const r = rel(C, p.pos.x, p.prj ? ctx.groundY(p.pos.x, p.pos.z) + (p.pos.y - ctx.groundY(p.pos.x, p.pos.z)) * 0.5 : p.pos.y, p.pos.z);
      if (r.dist > 30000 || (!p.big && r.dist > 6000) || r.dist < 60) continue;
      const cls = p.prj ? 'big' : r.dist > 8000 ? 'far' : '';
      add((p.prj ? '🏢 ' : '') + name, r.v, r.dist, cls, (p.prj ? 50 : p.big ? 20 : 0) - r.dist / 1000);
    }
    labels.sort((a, b) => b.prio - a.prio);
  }

  // ranh khu đất [[x, z]…]: P.site (lat/lon đo trên ảnh flycam) hoặc khối minh hoạ P.model.plot
  function siteRing() {
    if (P.site) return P.site.map(([la, lo]) => ctx.LL(la, lo));
    const F = P.fit; if (!F || !P.model) return null;
    const [pw, pd] = P.model.plot, c = Math.cos(F.ang), s = Math.sin(F.ang);
    return [[-1, -1], [1, -1], [1, 1], [-1, 1]].map(([u, v]) => [F.x + (u * pw / 2) * c - (v * pd / 2) * s, F.z + (u * pw / 2) * s + (v * pd / 2) * c]);
  }
  function siteCenter() { const r = siteRing(); return r && [r.reduce((a, p) => a + p[0], 0) / r.length, r.reduce((a, p) => a + p[1], 0) / r.length]; }

  function buildOverlay(C) {
    overlay.clear();
    const ring = siteRing(); if (!ring) return;
    const [cx, cz] = siteCenter(), y = ctx.groundY(cx, cz) + 1;
    const pts = ring.map(([x, z]) => new THREE.Vector3(x - C.x, y - C.y, z - C.z));
    const mat = (color, opacity) => new THREE.MeshBasicMaterial({ color, transparent: true, opacity, depthTest: false, depthWrite: false, side: THREE.DoubleSide });
    // mặt khu đất mờ
    const tri = THREE.ShapeUtils.triangulateShape(ring.map(([x, z]) => new THREE.Vector2(x, z)), []);
    const fill = new THREE.BufferGeometry().setFromPoints(tri.flat().map((i) => pts[i]));
    const fm = new THREE.Mesh(fill, mat(0xffc23d, 0.22)); fm.renderOrder = 2; overlay.add(fm);
    // viền dày 1,6 m
    const W = 0.6, pos = [];
    for (let i = 0; i < pts.length; i++) {
      const a = pts[i], b = pts[(i + 1) % pts.length], d = b.clone().sub(a).setY(0).normalize(), n = new THREE.Vector3(-d.z, 0, d.x).multiplyScalar(W);
      const a1 = a.clone().sub(n), a2 = a.clone().add(n), b1 = b.clone().sub(n), b2 = b.clone().add(n);
      pos.push(a1, b1, b2, a1, b2, a2);
    }
    const em = new THREE.Mesh(new THREE.BufferGeometry().setFromPoints(pos), mat(0xffd34d, 0.95)); em.renderOrder = 3; overlay.add(em);
  }

  async function show(Pr, idx) {
    P = Pr; cur = P.pano360[idx];
    const C = camPos(cur);
    sphere.rotation.y = THREE.MathUtils.degToRad(270 - cur.heading);
    view.yaw = cur.heading; view.pitch = -18; view.fov = innerWidth < innerHeight ? 85 : 72;
    $('h2').textContent = '🛸 360° ' + P.name;
    $('.hd small').textContent = `${cur.lat.toFixed(6)}, ${cur.lon.toFixed(6)} · cao ${Math.round(cur.alt)} m · ${cur.time}`;
    buildLabels(C); buildOverlay(C);
    chips.textContent = '';
    P.pano360.forEach((q, i) => {
      const b = document.createElement('button'); b.className = 'chip' + (i === idx ? ' active' : '');
      b.textContent = `🛸 ${Math.round(q.alt)} m`; b.onclick = () => show(P, i); chips.appendChild(b);
    });
    if (P.plans && ctx.openPlans) { const mb = document.createElement('button'); mb.className = 'chip'; mb.textContent = '📐 Mặt bằng'; mb.onclick = () => ctx.openPlans(P); chips.appendChild(mb); }
    const site = document.createElement('button'); site.className = 'chip'; site.textContent = '⬇ Nhìn khu đất';
    site.onclick = () => { const S = siteCenter(); if (!S) return; const r = rel(C, S[0], ctx.groundY(S[0], S[1]), S[1]); view.yaw = (THREE.MathUtils.radToDeg(Math.atan2(r.v.x, -r.v.z)) + 360) % 360; view.pitch = Math.max(-80, THREE.MathUtils.radToDeg(Math.atan2(r.v.y, r.dist)) + 12); view.fov = 80; };
    chips.appendChild(site);
    const lb = document.createElement('button'); lb.className = 'chip' + (showLbl ? ' active' : ''); lb.textContent = '🏷 Nhãn';
    lb.onclick = () => { showLbl = !showLbl; lb.classList.toggle('active', showLbl); overlay.visible = showLbl; }; chips.appendChild(lb);
    const map = document.createElement('a'); map.className = 'chip'; map.target = '_blank'; map.rel = 'noopener';
    map.href = `https://www.google.com/maps/search/?api=1&query=${cur.lat},${cur.lon}`; map.textContent = '📍 Google Maps'; chips.appendChild(map);
    const back = document.createElement('button'); back.className = 'chip'; back.textContent = '↩ Về bản đồ 3D'; back.onclick = close; chips.appendChild(back);

    if (!open) { open = true; root.hidden = false; ctx.onOpen?.(); resize(); raf = requestAnimationFrame(loop); }
    const want = cur;
    try {
      const t = await loadTex(cur.src);
      if (want !== cur) return;
      sphMat.map = t; sphMat.color.set(0xffffff); sphMat.needsUpdate = true;
      // máy đủ mạnh: thay bằng ảnh nét 8K
      if (cur.hd && renderer.capabilities.maxTextureSize >= 8192 && Math.max(innerWidth, innerHeight) * devicePixelRatio > 1400) {
        const hd = await loadTex(cur.hd).catch(() => null);
        if (hd && want === cur) { sphMat.map = hd; sphMat.needsUpdate = true; }
      }
    } catch { $('.hd small').textContent = 'Không tải được ảnh 360°'; }
  }

  function close() {
    open = false; root.hidden = true; cancelAnimationFrame(raf); ctx.onClose?.();
  }
  $('.x').onclick = close;
  addEventListener('keydown', (e) => { if (open && e.key === 'Escape') close(); });

  function resize() {
    if (!open) return;
    renderer.setSize(innerWidth, innerHeight);
    camera.aspect = innerWidth / innerHeight; camera.updateProjectionMatrix();
  }
  addEventListener('resize', resize);

  // ----- kéo để nhìn quanh, lăn chuột / chụm 2 ngón để phóng -----
  const ptr = new Map(); let pinch0 = 0, fov0 = 0;
  const cv = renderer.domElement;
  cv.addEventListener('pointerdown', (e) => { cv.setPointerCapture(e.pointerId); ptr.set(e.pointerId, [e.clientX, e.clientY]); if (ptr.size === 2) { const [a, b] = [...ptr.values()]; pinch0 = Math.hypot(a[0] - b[0], a[1] - b[1]); fov0 = view.fov; } });
  cv.addEventListener('pointermove', (e) => {
    if (!ptr.has(e.pointerId)) return;
    const [px, py] = ptr.get(e.pointerId); ptr.set(e.pointerId, [e.clientX, e.clientY]);
    if (ptr.size === 2) { const [a, b] = [...ptr.values()]; const d = Math.hypot(a[0] - b[0], a[1] - b[1]); if (pinch0) view.fov = THREE.MathUtils.clamp(fov0 * pinch0 / d, 20, 100); return; }
    const k = view.fov / innerHeight;
    view.yaw -= (e.clientX - px) * k; view.pitch = THREE.MathUtils.clamp(view.pitch + (e.clientY - py) * k, -89, 89);
  });
  const up = (e) => { ptr.delete(e.pointerId); if (ptr.size < 2) pinch0 = 0; };
  cv.addEventListener('pointerup', up); cv.addEventListener('pointercancel', up);
  cv.addEventListener('wheel', (e) => { e.preventDefault(); view.fov = THREE.MathUtils.clamp(view.fov * Math.exp(e.deltaY * 0.001), 20, 100); }, { passive: false });

  const tmp = new THREE.Vector3();
  function loop() {
    if (!open) return;
    camera.fov = view.fov; camera.updateProjectionMatrix();
    camera.rotation.y = -THREE.MathUtils.degToRad(view.yaw);
    camera.rotation.x = THREE.MathUtils.degToRad(view.pitch);
    renderer.render(scene, camera);
    camera.updateMatrixWorld();
    // nhãn: chiếu lên màn hình, bỏ nhãn ưu tiên thấp nếu chồng lên nhãn đã đặt
    const placed = [];
    for (const L of labels) {
      tmp.copy(L.dir).multiplyScalar(100).project(camera);
      let vis = showLbl && tmp.z < 1 && Math.abs(tmp.x) < 1.1 && Math.abs(tmp.y) < 1.1;
      if (vis) {
        const x = ((tmp.x + 1) / 2) * innerWidth, y = ((1 - tmp.y) / 2) * innerHeight;
        if (!L.w) { L.el.style.display = ''; L.w = L.el.offsetWidth || 80; L.h = 24; }
        const box = [x - L.w / 2, y - 40, x + L.w / 2, y - 16];
        if (placed.some((q) => box[0] < q[2] + 4 && box[2] > q[0] - 4 && box[1] < q[3] + 2 && box[3] > q[1] - 2)) vis = false;
        else { placed.push(box); L.el.style.left = x + 'px'; L.el.style.top = y + 'px'; }
      }
      L.el.style.display = vis ? '' : 'none';
    }
    // la bàn
    const yaw = ((view.yaw % 360) + 360) % 360, span = view.fov * camera.aspect * 1.2;
    let html = '';
    for (let b = 0; b < 360; b += 15) {
      let d = b - yaw; d = ((d + 540) % 360) - 180;
      if (Math.abs(d) > span / 2) continue;
      const t = b % 90 === 0 ? ['B', 'Đ', 'N', 'T'][b / 90] : b % 45 === 0 ? ['ĐB', 'ĐN', 'TN', 'TB'][(b - 45) / 90] : b;
      html += `<i style="left:${50 + (d / span) * 100}%">${t}</i>`;
    }
    cmp.innerHTML = html + `<i class="c" style="left:50%;top:-2px;display:none"></i>`;
    cmp.title = `Hướng nhìn ${Math.round(yaw)}° (${dirName(yaw)})`;
    raf = requestAnimationFrame(loop);
  }
  return { show };
}
