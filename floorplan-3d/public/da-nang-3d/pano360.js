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
.p360 .lb.rs b { background: #0e7490; } .p360 .lb.mart b { background: #7c3aed; } .p360 .lb.bv b { background: #fff; color: #b91c1c; }
.p360 .lb.ph b { background: none; box-shadow: none; font-size: 11px; letter-spacing: .12em; text-transform: uppercase; text-shadow: 0 1px 3px #000, 0 0 8px #000; }
.p360 .lb.ph span { background: none; }
.p360 .lb.duong b { background: #1d4ed8; border: 1.5px solid #fff; border-radius: 3px; }
.p360 .lb.zone { pointer-events: auto; cursor: pointer; }
.p360 .lb.zone b { background: #15803d; font-size: 13px; text-align: center; line-height: 1.35; }
.p360 .lb.zone b i { display: block; font-style: normal; font-weight: 400; font-size: 11px; opacity: .95; }
@media (max-width: 640px) { .p360 .lb b { font-size: 11px; padding: 3px 7px; } .p360 .lb.big b, .p360 .lb.site b { font-size: 12px; } .p360 .lb small { display: none; } }
.p360 .hd { position: absolute; top: 0; left: 0; right: 0; padding: max(10px, env(safe-area-inset-top)) 56px 14px 16px; background: linear-gradient(#000a, transparent); font: 13px Inter, sans-serif; pointer-events: none; }
.p360 .hd h2 { margin: 0 0 2px; font-size: 16px; }
.p360 .logo { display: inline-block; background: #fffffff2; border-radius: 8px; padding: 5px 10px; margin-bottom: 6px; box-shadow: 0 2px 10px #0004; line-height: 0; }
.p360 .logo img { height: 22px; width: auto; }
@media (max-width: 640px) { .p360 .logo img { height: 18px; } }
.p360 .hd small { opacity: .85; }
.p360 .x { position: absolute; top: max(10px, env(safe-area-inset-top)); right: 12px; border: 0; background: #ffffff2b; color: #fff; border-radius: 999px; width: 34px; height: 34px; font-size: 15px; cursor: pointer; }
.p360 .ft { position: absolute; left: 0; right: 0; bottom: 0; padding: 18px 16px max(12px, env(safe-area-inset-bottom)); background: linear-gradient(transparent, #000b); }
.p360 .cmp { position: relative; height: 22px; margin: 0 auto 8px; max-width: 520px; overflow: hidden; font: 600 11px Inter, sans-serif; mask-image: linear-gradient(90deg, transparent, #000 20%, #000 80%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 20%, #000 80%, transparent); }
.p360 .cmp i { position: absolute; top: 4px; transform: translateX(-50%); font-style: normal; opacity: .75; }
.p360 .cmp i.c { color: #f59e0b; opacity: 1; }
.p360 .cmp:after { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: #f59e0b; }
.p360 .chips { display: flex; gap: 6px; overflow-x: auto; scrollbar-width: none; }
.p360 .chips::-webkit-scrollbar { display: none; }
.p360 select.chip { -webkit-appearance: none; appearance: none; padding-right: 14px; }
.p360 select.chip option { color: #111827; background: #fff; }
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
    <div class="hd"><div class="logo"><img alt="TATI Property" /></div><h2></h2><small></small></div>
    <button class="x" aria-label="Đóng">✕</button>
    <div class="ft"><div class="cmp"></div><div class="chips"></div></div>`;
  document.body.appendChild(root);
  const $ = (s) => root.querySelector(s);
  $('.logo img').src = new URL('../brand/tati-property.png', import.meta.url).href;   // logo đơn vị phân phối
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
  let cur = null, P = null, labels = [], open = false, raf = 0, showLbl = true, lblGroup = 'all', night = false;
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

  // không hiện trên ảnh 360° (theo yêu cầu)
  const HIDE = new Set(['Times Square Đà Nẵng', '123']);
  function buildLabels(C) {
    lblBox.textContent = ''; labels = [];
    // tên gọn để đỡ chồng chéo
    const SHORT = { 'Da Nang Downtown – tháp 408 m': 'Da Nang Downtown', 'Bán đảo Sơn Trà (696 m)': 'Bán đảo Sơn Trà', 'Tượng Phật Quan Âm – chùa Linh Ứng': 'Chùa Linh Ứng',
      'Sun Wheel – Công viên Châu Á': 'Công viên Châu Á', 'Cầu Sông Hàn (cầu quay)': 'Cầu Sông Hàn', 'Sân bay quốc tế Đà Nẵng': 'Sân bay Đà Nẵng', 'Cầu Tình Yêu – Cá chép hóa rồng': 'Cầu Tình Yêu' };
    const add = (name, v, dist, cls, prio) => {
      name = name.replace(/^(🏢 |🏖 )?(.*)$/, (m, i, n) => (i || '') + (SHORT[n] || n));
      const el = document.createElement('div'); el.className = 'lb ' + cls;
      el.innerHTML = '<b></b><span></span>'; el.querySelector('b').textContent = name;
      if (dist > 400) { const s = document.createElement('small'); s.textContent = fmtKm(dist); el.querySelector('b').appendChild(s); }
      lblBox.appendChild(el);
      labels.push({ el, dir: v.clone().normalize(), prio, w: 0, h: 0, site: cls === 'site', g: cls === 'site' ? 'site' : cls === 'big' ? 'prj' : cls === 'rs' ? 'rs' : cls === 'duong' ? 'duong' : 'dd' });
    };
    // khu đất của chính dự án: nhãn đỏ ở tâm khu đất
    const S = siteCenter();
    if (S) { const r = rel(C, S[0], ctx.groundY(S[0], S[1]) + 2, S[1]); add('📍 Khu đất ' + P.name, r.v, r.dist, 'site', 100); }
    for (const Z of P.zones || []) {   // ghi chú vùng quy hoạch phía trước
      const pts = Z.corners.map(([la, lo]) => ctx.LL(la, lo)), zx = pts.reduce((a, p) => a + p[0], 0) / 4, zz = pts.reduce((a, p) => a + p[1], 0) / 4;
      const r = rel(C, zx, ctx.groundY(zx, zz) + 3, zz); add(Z.name, r.v, 0, 'zone', 90);
      const L = labels[labels.length - 1], i = document.createElement('i'); i.textContent = Z.note + ' · xem bản vẽ ›'; L.el.firstChild.appendChild(i); L.g = 'zone';
      L.el.onclick = () => { const g = P.plans?.groups.findIndex(([n]) => n === Z.gallery); if (g >= 0 && ctx.openPlans) ctx.openPlans(P, g); };
    }
    if (P.lowrise?.note) {
      const pts = P.lowrise.corners.map(([la, lo]) => ctx.LL(la, lo)), zx = pts.reduce((a, p) => a + p[0], 0) / 4, zz = pts.reduce((a, p) => a + p[1], 0) / 4;
      const r = rel(C, zx, ctx.groundY(zx, zz) + 22, zz); add(P.lowrise.note[0], r.v, 0, 'zone', 88);
      const L = labels[labels.length - 1], i = document.createElement('i'); i.textContent = P.lowrise.note[1]; L.el.firstChild.appendChild(i); L.g = 'lownote';
    }
    if (P.front?.resortNote) {
      const [x0, z0] = ctx.LL(...P.front.resortCorners[0]), [x2, z2] = ctx.LL(...P.front.resortCorners[2]);
      const zx = (x0 + x2) / 2 - 60 * Math.sign(x2 - x0), zz = (z0 + z2) / 2, r = rel(C, zx, ctx.groundY(zx, zz) + 3, zz);
      add(P.front.resortNote[0], r.v, 0, 'zone', 89);
      const L = labels[labels.length - 1], i = document.createElement('i'); i.textContent = P.front.resortNote[1]; L.el.firstChild.appendChild(i); L.g = 'resortnote';
    }
    const seen = new Set();
    for (const p of ctx.PLACES) {
      if (p.lotEdge || p.lot || p.prj === P || p.pano) continue;
      if (HIDE.has(p.name.replace(/^🏢\s*/, ''))) continue;
      const name = p.name.replace(/^🏢\s*/, '');
      if (seen.has(name)) continue; seen.add(name);
      const r = rel(C, p.pos.x, p.prj ? ctx.groundY(p.pos.x, p.pos.z) + (p.pos.y - ctx.groundY(p.pos.x, p.pos.z)) * 0.5 : p.pos.y, p.pos.z);
      if (r.dist > 30000 || (!p.big && r.dist > 6000) || r.dist < 60) continue;
      const cls = p.prj ? 'big' : r.dist > 8000 ? 'far' : '';
      add((p.prj ? '🏢 ' : '') + name, r.v, r.dist, cls, (p.prj ? 50 : p.big ? 20 : 0) - r.dist / 1000);
    }
    // điểm mốc thêm (poi.js): resort, siêu thị, bệnh viện, phường…
    const ICON = { rs: '🏖 ', mart: '🛒 ', bv: '🏥 ', dd: '', ph: '', duong: '🛣 ' }, PRIO = { dd: 18, rs: 30, mart: 12, bv: 12, ph: 8, duong: 26 };
    for (const q of ctx.POI || []) {
      if (seen.has(q.n)) continue; seen.add(q.n);
      const [x, z] = ctx.LL(q.lat, q.lon), r = rel(C, x, ctx.groundY(x, z) + (q.h ?? (q.k === 'ph' ? 0 : 8)), z);
      if (r.dist > 20000 || r.dist < 100) continue;
      add(ICON[q.k] + q.n, r.v, q.k === 'ph' ? 0 : r.dist, q.k, PRIO[q.k] - r.dist / 1000);
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

  // mặt bằng trên đất + tên đường: các mặt phẳng nằm trên mặt đất, vẽ đè lên ảnh
  const planGroup = new THREE.Group(); scene.add(planGroup); let floor = 0;   // floor: chỉ số tầng đang đặt trên đất, -1 = tắt
  // Vật liệu "in xuống đất": hoà bản vẽ vào ảnh 360° tại chỗ — lấy màu ảnh flycam đúng hướng nhìn,
  // giữ bóng đổ/sáng tối của mặt đất thật lên bản vẽ, viền mờ theo kênh alpha, chỉnh tông theo ảnh.
  const makeGroundMat = (sphereMesh) => new THREE.ShaderMaterial({
    transparent: true, depthTest: false, depthWrite: false, side: THREE.DoubleSide,
    uniforms: { map: { value: null }, pano: { value: null }, rot: { value: 0 }, strength: { value: 1.0 } },
    vertexShader: `varying vec2 vUv; varying vec3 vDir;
      void main() { vUv = uv; vec4 w = modelMatrix * vec4(position, 1.0); vDir = w.xyz; gl_Position = projectionMatrix * viewMatrix * w; }`,
    fragmentShader: `uniform sampler2D map; uniform sampler2D pano; uniform float rot; uniform float strength;
      varying vec2 vUv; varying vec3 vDir;
      void main() {
        vec4 p = texture2D(map, vUv);
        if (p.a < 0.004) discard;
        vec3 d = normalize(vDir); float c = cos(rot), s = sin(rot);
        vec3 l = vec3(c * d.x - s * d.z, d.y, s * d.x + c * d.z);          // bỏ phép xoay của mặt cầu ảnh
        float phi = atan(l.z, l.x); float u = fract(phi / 6.2831853); float v = 1.0 - acos(clamp(l.y, -1.0, 1.0)) / 3.1415927;
        vec3 photo = texture2D(pano, vec2(u, v)).rgb;
        gl_FragColor = vec4(mix(photo, p.rgb, p.a * strength), 1.0);   // đặc, rõ nét: che hẳn đất bên dưới
        #include <colorspace_fragment>
      }`,
  });
  const planMat = makeGroundMat();
  function textTex(t) {
    const c = document.createElement('canvas'), g = c.getContext('2d'), f = '700 64px Inter, sans-serif';
    g.font = f; const w = Math.ceil(g.measureText(t).width) + 40; c.width = w; c.height = 96;
    g.font = f; g.textBaseline = 'middle'; g.lineWidth = 10; g.strokeStyle = '#000a'; g.strokeText(t, 20, 50); g.fillStyle = '#fff'; g.fillText(t, 20, 50);
    const tx = new THREE.CanvasTexture(c); tx.colorSpace = THREE.SRGBColorSpace; tx.anisotropy = 4; return { tx, aspect: w / 96 };
  }
  function buildPlan(C) {
    planGroup.clear();
    const gy = (x, z) => ctx.groundY(x, z) + 0.8 - C.y;
    if (P.overlay) {
      const q = (P.overlay.cornersBy?.[cur.id] || P.overlay.corners).map(([la, lo]) => { const [x, z] = ctx.LL(la, lo); return new THREE.Vector3(x - C.x, gy(x, z), z - C.z); });
      const g = new THREE.BufferGeometry().setFromPoints([q[0], q[1], q[2], q[0], q[2], q[3]]);
      g.setAttribute('uv', new THREE.Float32BufferAttribute([0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0], 2));
      const m = new THREE.Mesh(g, planMat); m.renderOrder = 4; m.name = 'plan'; planGroup.add(m);
      setFloor(floor);
    }
    for (const r of P.roads || []) {
      const [ax, az] = ctx.LL(...r.a), [bx, bz] = ctx.LL(...r.b);
      const mx = (ax + bx) / 2, mz = (az + bz) / 2, L = Math.hypot(bx - ax, bz - az);
      let dx = (bx - ax) / L, dz = (bz - az) / L;
      // chữ đọc xuôi khi nhìn từ flycam: "đầu chữ" quay ra xa vị trí chụp
      let nx = -dz, nz = dx; if (nx * (mx - C.x) + nz * (mz - C.z) < 0) { nx = -nx; nz = -nz; }
      if (dx * nz - dz * nx > 0) { dx = -dx; dz = -dz; }
      const { tx, aspect } = textTex(r.n), h = 4.2, w = h * aspect;
      const o = new THREE.Vector3(mx - C.x, gy(mx, mz) + 0.3, mz - C.z), U = new THREE.Vector3(dx, 0, dz), N = new THREE.Vector3(nx, 0, nz);
      const c = (s, t) => o.clone().addScaledVector(U, s * w / 2).addScaledVector(N, t * h / 2);
      const g = new THREE.BufferGeometry().setFromPoints([c(-1, 1), c(1, 1), c(1, -1), c(-1, 1), c(1, -1), c(-1, -1)]);
      g.setAttribute('uv', new THREE.Float32BufferAttribute([0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0], 2));
      const m = new THREE.Mesh(g, new THREE.MeshBasicMaterial({ map: tx, transparent: true, depthTest: false, depthWrite: false, side: THREE.DoubleSide })); m.renderOrder = 6; planGroup.add(m);
    }
  }

  // mặt công viên minh hoạ: cỏ cắt sọc, quảng trường đối diện dự án, lối đi uốn lượn, cây dừa, lối gỗ ven biển
  function parkTex(plaza) {
    const W = 1600, H = 910, c = document.createElement('canvas'); c.width = W; c.height = H; const g = c.getContext('2d');
    let sd = 11; const rnd = () => (sd = (sd * 16807) % 2147483647) / 2147483647;
    for (let x = 0; x < W; x += 24) { g.fillStyle = (x / 24) % 2 ? '#6fae4c' : '#79b955'; g.fillRect(x, 0, 24, H); }
    g.fillStyle = '#b98b5a'; g.fillRect(0, 0, W, 26);                                  // lối gỗ ven biển
    const px = plaza * W;
    g.fillStyle = '#e8e0d0'; g.fillRect(px - 120, 26, 240, H - 26);                      // trục quảng trường ra biển
    g.strokeStyle = '#d2c5ab'; g.lineWidth = 2; for (let y = 60; y < H; y += 40) { g.beginPath(); g.moveTo(px - 120, y); g.lineTo(px + 120, y); g.stroke(); }
    g.beginPath(); g.arc(px, H * 0.5, 70, 0, 7); g.strokeStyle = '#b9a98a'; g.lineWidth = 6; g.stroke();
    g.strokeStyle = '#ddd2bb'; g.lineWidth = 22; g.lineCap = 'round';                    // lối đi uốn lượn
    for (const s of [-1, 1]) for (const k of [0.33, 0.7]) { g.beginPath(); g.moveTo(px + s * 120, H * k);
      g.bezierCurveTo(px + s * 380, H * (k - 0.25), px + s * 560, H * (k + 0.2), px + s * 760, H * (k - 0.1)); g.stroke(); }
    for (const s of [-1, 1]) for (let i = 0; i < 3; i++) { g.beginPath(); g.ellipse(px + s * (330 + i * 190), H * (0.48 + (i % 2) * 0.14), 52, 30, 0, 0, 7); g.fillStyle = '#4cc6d6'; g.fill(); }
    const palm = (x, y, r) => { g.fillStyle = '#2f6b2a'; for (let k = 0; k < 7; k++) { const a = (k / 7) * 6.283; g.beginPath(); g.ellipse(x + Math.cos(a) * r * 0.55, y + Math.sin(a) * r * 0.55, r * 0.6, r * 0.22, a, 0, 7); g.fill(); } g.fillStyle = '#3f8a35'; g.beginPath(); g.arc(x, y, r * 0.3, 0, 7); g.fill(); };
    for (let x = 30; x < W; x += 58) palm(x, 48, 16);                                    // hàng dừa ven biển
    for (let y = 70; y < H; y += 62) { palm(px - 140, y, 14); palm(px + 140, y, 14); }  // hàng dừa hai bên quảng trường
    for (let i = 0; i < 140; i++) { const x = rnd() * W, y = 70 + rnd() * (H - 90); if (Math.abs(x - px) > 170) palm(x, y, 9 + rnd() * 7); }
    const t = new THREE.CanvasTexture(c); t.colorSpace = THREE.SRGBColorSpace; t.anisotropy = 4; return t;
  }
  const zoneGroup = new THREE.Group(); scene.add(zoneGroup); let showZone = true, frontMode = 1;   // 0 hiện trạng, 1 quy hoạch công viên, 2 + làm sạch, 3 + kiểu resort
  const stripMesh = { m: null };
  function buildZones(C) {
    zoneGroup.clear();
    for (const Z of P.zones || []) {
      const q = Z.corners.map(([la, lo]) => { const [x, z] = ctx.LL(la, lo); return new THREE.Vector3(x - C.x, ctx.groundY(x, z) + 0.5 - C.y, z - C.z); });
      const g = new THREE.BufferGeometry().setFromPoints([q[0], q[1], q[2], q[0], q[2], q[3]]);
      g.setAttribute('uv', new THREE.Float32BufferAttribute([0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0], 2));
      const m = new THREE.Mesh(g, new THREE.MeshBasicMaterial({ map: (Z.tex ||= parkTex(Z.plaza ?? 0.5)), transparent: true, opacity: 0.9, depthTest: false, depthWrite: false, side: THREE.DoubleSide }));
      m.renderOrder = 1; zoneGroup.add(m);
      if (Z.img) { m.visible = false; loadTex(Z.img).then((t) => { m.material.map = t; m.material.needsUpdate = true; m.visible = true; }).catch(() => {}); }   // ảnh quy hoạch thật thay hình vẽ minh hoạ
    }
    // dải đất phía trước (ngoài lô công viên): ảnh làm sạch / kiểu resort dựng từ chính ảnh flycam
    const F = P.front; stripMesh.m = null;
    if (F) {
      const q = F.corners.map(([la, lo]) => { const [x, z] = ctx.LL(la, lo); return new THREE.Vector3(x - C.x, ctx.groundY(x, z) + 0.3 - C.y, z - C.z); });
      const g = new THREE.BufferGeometry().setFromPoints([q[0], q[1], q[2], q[0], q[2], q[3]]);
      g.setAttribute('uv', new THREE.Float32BufferAttribute([0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0], 2));
      const m = new THREE.Mesh(g, new THREE.MeshBasicMaterial({ transparent: true, depthTest: false, depthWrite: false, side: THREE.DoubleSide }));
      m.renderOrder = 0.5; zoneGroup.add(m); stripMesh.m = m;
      if (F.resortCorners) {   // kiểu quy hoạch resort phủ cả dải (nằm dưới lô công viên)
        const q2 = F.resortCorners.map(([la, lo]) => { const [x, z] = ctx.LL(la, lo); return new THREE.Vector3(x - C.x, ctx.groundY(x, z) + 0.2 - C.y, z - C.z); });
        const g2 = new THREE.BufferGeometry().setFromPoints([q2[0], q2[1], q2[2], q2[0], q2[2], q2[3]]);
        g2.setAttribute('uv', new THREE.Float32BufferAttribute([0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0], 2));
        stripMesh.r = new THREE.Mesh(g2, new THREE.MeshBasicMaterial({ transparent: true, opacity: 0.95, depthTest: false, depthWrite: false, side: THREE.DoubleSide }));
        stripMesh.r.renderOrder = 0.4; stripMesh.r.visible = false; zoneGroup.add(stripMesh.r);
      }
    }
    setFront(frontMode);
  }
  const resortGroup = { visible: false };
  // ===== nhà thấp tầng 3D trên dải đất trống =====
  scene.add(new THREE.HemisphereLight(0xffffff, 0x8f9f7a, 1.5));
  const sunL = new THREE.DirectionalLight(0xfff1dc, 2.4); sunL.position.set(0.83, 0.55, 0.38); scene.add(sunL);   // nắng ~8h sáng từ hướng Đông
  const winTex = (wall, glass) => { const c = document.createElement('canvas'); c.width = 64; c.height = 64; const g = c.getContext('2d');
    g.fillStyle = wall; g.fillRect(0, 0, 64, 64); g.fillStyle = glass; g.fillRect(8, 14, 20, 30); g.fillRect(36, 14, 20, 30);
    g.fillStyle = '#ffffff55'; g.fillRect(8, 44, 48, 3); const t = new THREE.CanvasTexture(c); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.colorSpace = THREE.SRGBColorSpace; return t; };
  const WALLS = ['#f3efe6', '#ece4d4', '#f6f4ef', '#e9e1cf'], ROOFS = [0xb5523b, 0x9c4632, 0x6f6a66, 0xc0613f];
  const lowGroup = new THREE.Group(); scene.add(lowGroup); let showLow = true;
  function buildLowrise(C) {
    lowGroup.clear(); const F = P.lowrise; if (!F) return;
    const c = F.corners.map(([la, lo]) => { const [x, z] = ctx.LL(la, lo); return new THREE.Vector3(x - C.x, ctx.groundY(x, z) - C.y, z - C.z); });
    const S = c[1].clone().sub(c[0]), Ls = S.length(); S.normalize();
    const T = c[3].clone().sub(c[0]), Lt = T.length(); T.normalize();
    const yaw = Math.atan2(-S.z, S.x); let sd = 5; const rnd = () => (sd = (sd * 16807) % 2147483647) / 2147483647;
    const at = (s, t, y) => c[0].clone().addScaledVector(S, s).addScaledVector(T, t).add(new THREE.Vector3(0, y, 0));
    const lawnG = new THREE.BufferGeometry().setFromPoints([c[0], c[1], c[2], c[0], c[2], c[3]].map((v) => v.clone().add(new THREE.Vector3(0, 0.3, 0))));
    lowGroup.add(new THREE.Mesh(lawnG, new THREE.MeshLambertMaterial({ color: 0x86ad5f, side: THREE.DoubleSide })));
    const house = (s, t, w, d, floors, villa) => {
      const h = floors * 3.5, wall = WALLS[Math.floor(rnd() * 4)], tex = winTex(wall, '#3e5566'); tex.repeat.set(Math.max(1, Math.round(w / 4)), floors);
      const side = new THREE.MeshLambertMaterial({ map: tex }), top = new THREE.MeshLambertMaterial({ color: wall });
      const b = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), [side, side, top, top, side, side]);
      b.position.copy(at(s, t, h / 2 + 0.3)); b.rotation.y = yaw; lowGroup.add(b);
      if (villa) {   // mái dốc 4 mái ngói
        const r = new THREE.Mesh(new THREE.ConeGeometry(Math.SQRT1_2, 1, 4, 1), new THREE.MeshLambertMaterial({ color: ROOFS[Math.floor(rnd() * 4)], flatShading: true }));
        r.rotation.y = Math.PI / 4; const grp = new THREE.Group(); grp.add(r); grp.scale.set(w * 1.12, 3.2, d * 1.12);
        grp.rotation.y = yaw; grp.position.copy(at(s, t, h + 1.9)); lowGroup.add(grp);
      } else {       // mái bằng + tum thang
        const tm = new THREE.Mesh(new THREE.BoxGeometry(w * 0.6, 2.6, d * 0.3), top);
        tm.position.copy(at(s, t + d * 0.2, h + 1.6)); tm.rotation.y = yaw; lowGroup.add(tm);
      }
    };
    // nhà phố mặt tiền Trường Sa (5 × 18 m, 4–5 tầng) và biệt thự mặt đường nội bộ (10 × 14 m, 3 tầng)
    for (let s = 6; s + 5 < Ls - 6; s += 5.4) house(s + 2.5, 12, 5, 18, 4 + (rnd() < 0.35 ? 1 : 0), false);
    for (let s = 8; s + 10 < Ls - 6; s += 15) house(s + 5, Lt - 11, 10, 14, 3, true);
    const treeM = new THREE.MeshLambertMaterial({ color: 0x3f7a35, flatShading: true });
    for (let s = 4; s < Ls; s += 9) { const tr = new THREE.Mesh(new THREE.IcosahedronGeometry(2.2, 0), treeM); tr.position.copy(at(s, 1.2, 4)); lowGroup.add(tr); }
    lowGroup.visible = showLow;
  }
  // phía trước: quy hoạch đã được "in" sẵn vào ảnh 360° theo đúng phối cảnh, viền mờ, khớp tông màu (scripts bake)
  const BAKE = ['', 'qh', 'sach', 'resort'];
  const panoUrl = () => (frontMode && cur.bake ? cur.src.replace('.jpg', '-' + BAKE[frontMode] + '.jpg') : cur.src);
  function setFront(mode) {
    frontMode = mode; showZone = mode > 0; resortGroup.visible = false;
    zoneGroup.visible = !cur?.bake && showZone;   // ảnh chưa có bản in sẵn thì dùng lớp phủ phẳng như cũ
    if (cur?.bake && sphMat.map) { const want = cur; loadTex(panoUrl()).then((t) => { if (want === cur && frontMode === mode) { sphMat.map = t; sphMat.needsUpdate = true; } }).catch(() => {}); }
    if (cur?.bake) return;
    const m0 = stripMesh.m; if (!m0) return;
    m0.visible = false; if (stripMesh.r) stripMesh.r.visible = false; if (mode < 2) return;
    const m = mode === 3 && stripMesh.r ? stripMesh.r : m0;
    const url = mode === 2 ? P.front.clean : P.front.resort;
    loadTex(url).then((t) => { if (frontMode !== mode) return; m.material.map = t; m.material.needsUpdate = true; m.visible = true; }).catch(() => {});
  }
  function setFloor(i) {
    floor = i; const m = planGroup.getObjectByName('plan'); if (!m) return;
    m.visible = i >= 0; overlay.visible = showLbl && i < 0;   // đang đặt mặt bằng thì ẩn viền ranh đất
    if (i < 0) return;
    const want = P.overlay.dir + P.overlay.floors[i][0] + '-tren-dat.webp';
    loadTex(want).then((t) => { if (floor === i) { planMat.uniforms.map.value = t; } }).catch(() => {});
  }

  // buổi tối: lớp phủ (mặt bằng, công viên) tối đi cho hợp ảnh đêm
  function applyNight() {
    const c = night ? 0x7a7f9a : 0xffffff;
    scene.traverse((o) => { if (o.isMesh && o !== sphere && o.material?.color && o.material.map && !o.material.isMeshLambertMaterial) o.material.color.set(c); });
  }
  async function show(Pr, idx, keep) {
    P = Pr; cur = P.pano360[idx];
    const C = camPos(cur);
    sphere.rotation.y = THREE.MathUtils.degToRad(270 - cur.heading);
    if (!keep) { view.yaw = cur.heading; view.pitch = -18; view.fov = innerWidth < innerHeight ? 85 : 72; }
    $('h2').textContent = '🛸 360° ' + P.name;
    $('.hd small').textContent = `${cur.lat.toFixed(6)}, ${cur.lon.toFixed(6)} · cao ${Math.round(cur.alt)} m · ${cur.time}`;
    buildLabels(C); buildOverlay(C); buildPlan(C); buildZones(C); buildLowrise(C); applyNight();
    chips.textContent = '';
    P.pano360.forEach((q, i) => {
      const b = document.createElement('button'); b.className = 'chip' + (i === idx ? ' active' : '');
      b.textContent = `🛸 ${Math.round(q.alt)} m`; b.onclick = () => show(P, i); chips.appendChild(b);
    });
    if (P.plans && ctx.openPlans) { const mb = document.createElement('button'); mb.className = 'chip'; mb.textContent = '📐 Mặt bằng'; mb.onclick = () => ctx.openPlans(P); chips.appendChild(mb); }
    if (P.overlay) {   // chọn mặt bằng tầng đặt lên khu đất để tư vấn
      const sel = document.createElement('select'); sel.className = 'chip active'; sel.setAttribute('aria-label', 'Mặt bằng đặt trên khu đất');
      sel.innerHTML = '<option value="-1">🏗 Mặt bằng: tắt</option>' + P.overlay.floors.map(([, n], i) => `<option value="${i}">🏗 ${n}</option>`).join('');
      sel.value = floor; sel.onchange = () => { setFloor(+sel.value); sel.classList.toggle('active', floor >= 0); }; chips.appendChild(sel);
    }
    if (P.zones?.length) {   // phía trước: hiện trạng / quy hoạch / làm sạch / kiểu resort
      const zb = document.createElement('select'); zb.className = 'chip' + (frontMode ? ' active' : ''); zb.setAttribute('aria-label', 'Khu đất phía trước');
      zb.innerHTML = [[0, '🌴 Phía trước: hiện trạng'], [1, '🌴 Quy hoạch công viên'], ...(P.front ? [[2, '🌴 QH + làm sạch'], [3, '🏝 Quy hoạch resort']] : [])].map(([v, t]) => `<option value="${v}">${t}</option>`).join('');
      zb.value = frontMode; zb.onchange = () => { setFront(+zb.value); zb.classList.toggle('active', frontMode > 0); }; chips.appendChild(zb);
    }
    if (P.lowrise) { const lw = document.createElement('button'); lw.className = 'chip' + (showLow ? ' active' : ''); lw.textContent = '🏘 Nhà thấp tầng';
      lw.onclick = () => { showLow = !showLow; lw.classList.toggle('active', showLow); lowGroup.visible = showLow; }; chips.appendChild(lw); }
    if (cur.night) { const nb = document.createElement('button'); nb.className = 'chip' + (night ? ' active' : ''); nb.textContent = night ? '☀️ Ban ngày' : '🌙 Buổi tối';
      nb.onclick = () => { night = !night; applyNight(); show(P, P.pano360.indexOf(cur), true); }; chips.appendChild(nb); }
    const site = document.createElement('button'); site.className = 'chip'; site.textContent = '⬇ Nhìn khu đất';
    site.onclick = () => { const S = siteCenter(); if (!S) return; const r = rel(C, S[0], ctx.groundY(S[0], S[1]), S[1]); view.yaw = (THREE.MathUtils.radToDeg(Math.atan2(r.v.x, -r.v.z)) + 360) % 360; view.pitch = Math.max(-80, THREE.MathUtils.radToDeg(Math.atan2(r.v.y, r.dist)) + 12); view.fov = 80; };
    chips.appendChild(site);
    // lọc nhãn theo nhóm cho đỡ rối
    const lb = document.createElement('select'); lb.className = 'chip' + (showLbl ? ' active' : ''); lb.setAttribute('aria-label', 'Lọc nhãn');
    lb.innerHTML = [['all', '🏷 Nhãn: tất cả'], ['dd', '🏷 Địa danh'], ['rs', '🏷 Resort'], ['duong', '🏷 Tên đường'], ['prj', '🏷 Dự án'], ['off', '🏷 Tắt nhãn']].map(([v, t]) => `<option value="${v}">${t}</option>`).join('');
    lb.value = showLbl ? lblGroup : 'off';
    lb.onchange = () => { showLbl = lb.value !== 'off'; if (showLbl) lblGroup = lb.value; lb.classList.toggle('active', showLbl); overlay.visible = showLbl && floor < 0; planGroup.children.forEach((m) => { if (m.name !== 'plan') m.visible = showLbl; }); }; chips.appendChild(lb);
    const map = document.createElement('a'); map.className = 'chip'; map.target = '_blank'; map.rel = 'noopener';
    map.href = `https://www.google.com/maps/search/?api=1&query=${cur.lat},${cur.lon}`; map.textContent = '📍 Google Maps'; chips.appendChild(map);

    if (!open) { open = true; root.hidden = false; ctx.onOpen?.(); resize(); raf = requestAnimationFrame(loop); }
    const want = cur;
    try {
      const t = await loadTex(night && cur.night ? cur.night : panoUrl());
      if (want !== cur) return;
      sphMat.map = t; sphMat.color.set(0xffffff); sphMat.needsUpdate = true;
      // máy đủ mạnh: thay bằng ảnh nét 8K
      if (!night && !frontMode && cur.hd && renderer.capabilities.maxTextureSize >= 8192 && Math.max(innerWidth, innerHeight) * devicePixelRatio > 1400) {
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
    planMat.uniforms.pano.value = sphMat.map; planMat.uniforms.rot.value = sphere.rotation.y;
    renderer.render(scene, camera);
    camera.updateMatrixWorld();
    // nhãn: chiếu lên màn hình, bỏ nhãn ưu tiên thấp nếu chồng lên nhãn đã đặt
    const placed = [];
    for (const L of labels) {
      tmp.copy(L.dir).multiplyScalar(100).project(camera);
      let vis = showLbl && !(L.g === 'zone' && !showZone) && !(L.g === 'resortnote' && frontMode !== 3) && !(L.g === 'lownote' && !showLow) && (lblGroup === 'all' || L.g === 'zone' || L.g === 'resortnote' || L.g === 'lownote' || L.g === lblGroup || L.g === 'site') && !(L.site && floor >= 0) && tmp.z < 1 && Math.abs(tmp.x) < 1.1 && Math.abs(tmp.y) < 1.1;
      if (vis) {
        const x = ((tmp.x + 1) / 2) * innerWidth, y = ((1 - tmp.y) / 2) * innerHeight;
        if (!L.w) { L.el.style.display = ''; L.w = L.el.offsetWidth || 80; L.h = L.el.firstChild.offsetHeight || 22; L.stem = L.el.querySelector('span'); }
        // chồng nhau thì nâng nhãn lên 1–2 nấc; vẫn chồng thì ẩn nhãn ít quan trọng hơn
        const step = L.h + 4, maxK = innerWidth < 640 ? 2 : 3, stem = 14;
        let k = 0, box;
        for (; k < maxK; k++) {
          box = [x - L.w / 2, y - stem - L.h - k * step, x + L.w / 2, y - stem - k * step];
          if (!placed.some((q) => box[0] < q[2] + 6 && box[2] > q[0] - 6 && box[1] < q[3] + 3 && box[3] > q[1] - 3)) break;
        }
        if (k === maxK) vis = false;
        else { placed.push(box); L.el.style.left = x + 'px'; L.el.style.top = y + 'px'; if (L.k !== k) { L.k = k; L.stem.style.height = stem + k * step + 'px'; } }
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
