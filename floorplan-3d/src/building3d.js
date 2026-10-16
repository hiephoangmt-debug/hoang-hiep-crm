// Tòa nhà 3D: dựng khối tòa theo tầng, mỗi căn một khối tô màu theo trạng thái / loại căn / mặt đứng.
import * as THREE from 'three';
import { exportImage } from './snapshot.js';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { Sky } from 'three/examples/jsm/objects/Sky.js';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';
import { CSS2DRenderer, CSS2DObject } from 'three/examples/jsm/renderers/CSS2DRenderer.js';
import { SLOT_LIST, CORES, CORRIDORS, PODIUM, rectM, STATUS, TYPE_COLORS, residentialFloors, unitCode, unitPrice, areaOf, DEFAULT_UNIT, GARDEN_FLOORS, SHOPS, POOL, POOL_DECK } from './buildingData.js';
import { buildScene } from './builder.js';
import { placeUnit } from './unitPlacement.js';
import UNITS from './units/units.json';
import { buildSurroundings } from './surroundings.js';

/** Mặt đứng 1 ô (rộng 3 m × cao 1 tầng): khung, tường, cửa kính, lan can kính, bồn cây hoa */
function facadeTexture(variant) {
  const c = document.createElement('canvas');
  c.width = 256; c.height = 256;
  const x = c.getContext('2d');
  const frame = variant === 'green' ? '#2f5d3a' : '#f4f2ec';
  const wall = variant === 'orange' ? '#e8892f' : '#c9c2b5';
  x.fillStyle = wall; x.fillRect(0, 0, 256, 256);
  if (variant === 'orange') { x.fillStyle = '#c9c2b5'; x.fillRect(150, 0, 106, 256); }
  // Cửa kính cao
  const g = x.createLinearGradient(0, 30, 0, 200);
  g.addColorStop(0, '#5c7a94'); g.addColorStop(0.5, '#2e4558'); g.addColorStop(1, '#22313f');
  x.fillStyle = g; x.fillRect(40, 30, 100, 175);
  x.fillStyle = 'rgba(255,255,255,0.18)'; x.fillRect(46, 34, 30, 160);
  x.fillStyle = '#3a4048'; x.fillRect(88, 30, 4, 175);
  x.fillStyle = g; x.fillRect(176, 60, 50, 110);
  // Lan can kính + bồn cây
  x.fillStyle = 'rgba(200,225,235,0.55)'; x.fillRect(0, 175, 256, 40);
  x.fillStyle = '#3d7a31'; x.fillRect(20, 196, 140, 20);
  for (let i = 0; i < 26; i++) { x.fillStyle = ['#e2709a', '#d9443c', '#f2a03d', '#5fa047'][i % 4]; x.beginPath(); x.arc(24 + Math.random() * 132, 196 + Math.random() * 8, 4 + Math.random() * 4, 0, 7); x.fill(); }
  // Khung: cột đứng + dải sàn
  x.fillStyle = frame; x.fillRect(0, 0, 14, 256); x.fillRect(0, 222, 256, 34);
  const t = new THREE.CanvasTexture(c);
  t.colorSpace = THREE.SRGBColorSpace;
  t.wrapS = t.wrapT = THREE.RepeatWrapping;
  t.anisotropy = 8;
  return t;
}

/** Hình chữ nhật bo góc (toạ độ mặt bằng: x, y = trục z), đùn lên theo chiều cao */
function roundedPrism(r, y0, h, radii = {}, inset = 0) {
  const x0 = r.x0 + inset, x1 = r.x1 - inset, z0 = r.y0 + inset, z1 = r.y1 - inset;
  const lim = Math.min(x1 - x0, z1 - z0) / 2;
  const R = (k) => Math.max(0, Math.min(lim, (radii[k] || 0) - inset));
  const tl = R('tl'), tr = R('tr'), br = R('br'), bl = R('bl');
  const sh = new THREE.Shape();
  const P = (x, z) => [x, -z];
  sh.moveTo(...P(x0 + tl, z0));
  sh.lineTo(...P(x1 - tr, z0)); if (tr) sh.quadraticCurveTo(...P(x1, z0), ...P(x1, z0 + tr));
  sh.lineTo(...P(x1, z1 - br)); if (br) sh.quadraticCurveTo(...P(x1, z1), ...P(x1 - br, z1));
  sh.lineTo(...P(x0 + bl, z1)); if (bl) sh.quadraticCurveTo(...P(x0, z1), ...P(x0, z1 - bl));
  sh.lineTo(...P(x0, z0 + tl)); if (tl) sh.quadraticCurveTo(...P(x0, z0), ...P(x0 + tl, z0));
  const geo = new THREE.ExtrudeGeometry(sh, { depth: h, bevelEnabled: false, curveSegments: 12 });
  geo.rotateX(-Math.PI / 2);
  geo.translate(0, y0, 0);
  return geo;
}

// Góc bo theo mặt bằng tòa F2
const SLOT_RADII = { 24: { tl: 4.2 }, 26: { tr: 3 }, '03': { tl: 3 }, '05': { tr: 4.2 }, 19: { bl: 4.2 }, 17: { br: 3 }, 12: { bl: 3 }, 10: { br: 4.2 } };
const WINGS = [
  { px: [440, 340, 810, 1135], radii: { tl: 4.2, tr: 3, bl: 4.2, br: 3 } },
  { px: [810, 635, 1265, 1095], radii: {} },
  { px: [1265, 340, 1635, 1135], radii: { tl: 3, tr: 4.2, bl: 3, br: 4.2 } },
];
const CORRIDORS_M = CORRIDORS.map(rectM);

/** Mặt bằng chi tiết của một vị trí căn: mặt bằng người dùng gán, hoặc căn mẫu mặc định */
export function slotLayout(b, slot) {
  if (b.layouts?.[slot]) return { plan: b.layouts[slot], unitId: null };
  const id = DEFAULT_UNIT[slot];
  const u = id && UNITS.find((x) => x.id === id);
  return u ? { plan: u.plan, unitId: id } : null;
}
const ORANGE_SLOTS = new Set(['05', '06', '07', '08', '09', '10']);
export const AVENUE_X = -52;
// Căn chỉnh ảnh 360 khu đất (public/pano/khu-dat-360.jpg): xoay ảnh, độ cao flycam (m), góc ống kính
// look: điểm nhìn mặc định (về phía tòa F2 và lô F3)
export const SITE_PANO = { heading: 90, alt: 170, fov: 70, look: [40, 0, -30] };

export class BuildingView {
  constructor(container, getBuilding, onSelect, opts = {}) {
    this.light = !!opts.light;
    this.readonly = !!opts.readonly;
    this.container = container;
    this.getBuilding = getBuilding;
    this.onSelect = onSelect;
    this.colorBy = 'facade';
    this.maxFloor = Infinity;
    this.onlyFloor = null;
    this.detail = true;
    this.filter = { status: new Set(Object.keys(STATUS)), type: null };
    this.facadeTex = { beige: facadeTexture('beige'), orange: facadeTexture('orange'), green: facadeTexture('green') };
    const r = (this.renderer = new THREE.WebGLRenderer({ antialias: true }));
    r.setPixelRatio(Math.min(window.devicePixelRatio, this.light ? 1 : 2));
    r.shadowMap.enabled = !this.light;
    r.toneMapping = THREE.ACESFilmicToneMapping;
    r.toneMappingExposure = 1.05;
    container.appendChild(r.domElement);
    this.labels = new CSS2DRenderer();
    this.labels.domElement.className = 'labels-layer';
    container.appendChild(this.labels.domElement);
    const scene = (this.scene = new THREE.Scene());
    this.fog = scene.fog = new THREE.Fog(0xcbdcea, 380, 1500);
    scene.environment = new THREE.PMREMGenerator(r).fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environmentIntensity = 0.45;
    const sky = new Sky();
    sky.scale.setScalar(2500);
    const u = sky.material.uniforms;
    u.turbidity.value = 3; u.rayleigh.value = 1.2; u.mieCoefficient.value = 0.003; u.mieDirectionalG.value = 0.8;
    u.sunPosition.value.setFromSphericalCoords(1, THREE.MathUtils.degToRad(42), THREE.MathUtils.degToRad(200));
    scene.add(sky);
    this.skyMesh = sky;
    const sun = new THREE.DirectionalLight(0xfff1dc, 3.2);
    sun.position.set(-110, 190, 160);
    sun.castShadow = true;
    sun.shadow.mapSize.set(4096, 4096);
    Object.assign(sun.shadow.camera, { left: -190, right: 190, top: 190, bottom: -190, far: 700 });
    sun.shadow.bias = -0.0004;
    sun.shadow.normalBias = 0.05;
    scene.add(sun, new THREE.HemisphereLight(0xcfe6ff, 0x6b7f4f, 1.0));

    const fpp = rectM(PODIUM), fp = { x0: fpp.x0 - 3, y0: fpp.y0 - 3, x1: fpp.x1 + 3, y1: fpp.y1 + 3 };
    // Các tòa lân cận (chỉ để làm cảnh, không tương tác)
    // Cụm 4 tòa quanh ngã tư Minh Mạng (Tây) – Nguyễn Phước Lan (Nam) theo mặt bằng tổng thể
    const fp0 = rectM(PODIUM);
    const roadZ = fp0.y1 + 26;
    this.neighbors = [
      { name: 'TÒA F1 – TÙNG', x: 2 * AVENUE_X, z: 0, mirror: true, floors: 22, crown: 0xe8742f },
      { name: 'TÒA F5 – CÚC', x: 2 * AVENUE_X, z: 2 * roadZ, mirror: true, floors: 22, rot: Math.PI, crown: 0xe8b52f },
      { name: 'TÒA F3 – TRÚC', x: 0, z: 2 * roadZ, mirror: false, floors: 22, rot: Math.PI, crown: 0x3f8f3a },
    ];
    this.roadZ = roadZ;
    this.surroundArgs = {
      footprint: { x0: fp.x0, x1: fp.x1, z0: fp.y0, z1: fp.y1 },
      avenueX: AVENUE_X,
      reserved: this.neighbors.map((n) => ({ x: n.x, z: n.z, w: fp.x1 - fp.x0 + 20, d: fp.y1 - fp.y0 + 20 })),
    };
    this.surround = buildSurroundings({ ...this.surroundArgs, density: this.light ? 0.3 : 1 });
    scene.add(this.surround);
    const b0 = getBuilding();
    this.neighborGroup = new THREE.Group();
    scene.add(this.neighborGroup);
    // Bóng đổ của tòa xuống ảnh 360 (mặt đất trong suốt chỉ nhận bóng)
    this.shadowCatcher = new THREE.Mesh(new THREE.PlaneGeometry(400, 400), new THREE.ShadowMaterial({ opacity: 0.3 }));
    this.shadowCatcher.rotation.x = -Math.PI / 2;
    this.shadowCatcher.position.y = 0.02;
    this.shadowCatcher.receiveShadow = true;
    this.shadowCatcher.visible = false;
    scene.add(this.shadowCatcher);
    for (const n of this.neighbors) {
      const g = new THREE.Group();
      this.buildTower(g, { ...b0, floors: n.floors, units: {} }, { interactive: false, colorBy: 'facade', crown: n.crown });
      const top = b0.podiumFloors * b0.podiumHeight + residentialFloors(n.floors).length * b0.floorHeight;
      g.add(this.towerTag(n.name, n.crown, top + 8));
      g.position.set(n.x, 0, n.z);
      g.rotation.y = n.rot || 0;
      if (n.mirror) g.scale.x = -1;
      this.neighborGroup.add(g);
    }

    // Biển tên F2 và tên đường
    this.f2Tag = this.towerTag('TÒA F2 – MAI', 0xd9542f, b0.podiumFloors * b0.podiumHeight + residentialFloors(b0.floors).length * b0.floorHeight + 8);
    scene.add(this.f2Tag);
    for (const [t, x, z, cls] of [['Đ. MINH MẠNG', AVENUE_X, -60, 'road green'], ['Đ. MINH MẠNG', AVENUE_X, 150, 'road green'], ['Đ. QUẢNG NAM', 90, roadZ, 'road gold'], ['Đ. NGUYỄN PHƯỚC LAN', -200, roadZ, 'road gold'], ['CẦU BÔ QUAN', AVENUE_X, -357, 'road green'], ['SÔNG ĐÔ TỎA', 120, -357, 'road blue'], ['BIỂN SƠN THỦY · MỸ KHÊ', 0, -700, 'road blue'], ['NÚI SƠN TRÀ', -820, -880, 'road green'], ['NGŨ HÀNH SƠN', 320, -575, 'road green']]) {
      const el = document.createElement('div');
      el.className = 'roadtag ' + cls;
      el.textContent = t;
      const o = new CSS2DObject(el);
      o.position.set(x, 1, z);
      (this.roadTags ||= []).push(o);
      scene.add(o);
    }

    this.camera = new THREE.PerspectiveCamera(38, 1, 0.5, 4000);
    this.controls = new OrbitControls(this.camera, r.domElement);
    this.controls.enableDamping = true;
    this.controls.maxPolarAngle = Math.PI * 0.495;
    this.controls.minDistance = 15;
    this.controls.maxDistance = 900;
    this.setView('perspective');

    this.raycaster = new THREE.Raycaster();
    this.tooltip = document.createElement('div');
    this.tooltip.className = 'tooltip3d';
    container.appendChild(this.tooltip);
    this.bindEvents();
    new ResizeObserver(() => this.resize()).observe(container);
    this.resize();
    this.rebuild();
    this.setActive(true);
  }

  /** Biển tên tòa nổi trên mái */
  towerTag(text, color, y) {
    const el = document.createElement('div');
    el.className = 'towertag';
    el.textContent = text;
    el.style.background = '#' + new THREE.Color(color).getHexString();
    const o = new CSS2DObject(el);
    o.position.set(0, y, 0);
    return o;
  }

  setActive(on) {
    if (on === this.active) return;
    this.active = on;
    this.renderer.setAnimationLoop(on ? () => {
      this.tickFly();
      this.controls.update();
      this.renderer.render(this.scene, this.camera);
      this.labels.render(this.scene, this.camera);
    } : null);
  }

  /** Chế độ nhẹ: ít cây/nhà, tắt bóng đổ, giảm độ phân giải */
  setLight(on) {
    this.light = on;
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, on ? 1 : 2));
    this.renderer.shadowMap.enabled = !on;
    this.scene.traverse((o) => { if (o.material) o.material.needsUpdate = true; });
    this.scene.remove(this.surround);
    this.surround.traverse((o) => o.geometry?.dispose());
    this.surround = buildSurroundings({ ...this.surroundArgs, density: on ? 0.3 : 1 });
    this.surround.visible = !this.pano;
    this.scene.add(this.surround);
    this.resize();
  }

  // ---------------- Ghép tòa nhà vào ảnh 360° thực tế ----------------
  /** Tải ảnh 360° (equirectangular) làm nền; camera đứng tại điểm chụp, nhìn quanh được */
  setPano(src, onReady, preset) {
    if (!src) { this.pano = null; this.applyPano(); return; }
    if (preset) this.pano = { ...preset };
    new THREE.TextureLoader().load(src, (t) => {
      t.mapping = THREE.EquirectangularReflectionMapping;
      t.colorSpace = THREE.SRGBColorSpace;
      this.panoTex?.dispose();
      this.panoTex = t;
      this.pano ||= { heading: 0, bearing: 200, dist: 160, alt: 60, fov: 60 };
      this.applyPano();
      onReady?.();
    });
  }

  /** p: { heading: xoay ảnh (°), bearing: hướng camera quanh tòa (°), dist: khoảng cách (m), alt: độ cao (m), fov } */
  applyPano(p) {
    if (p) Object.assign(this.pano, p);
    const on = !!(this.pano && this.panoTex);
    this.surround.visible = !on;
    // Ảnh 360: vẫn dựng đủ cụm 4 tòa của dự án, ẩn nhãn đường (có thể lệch so với ảnh)
    this.neighborGroup.visible = this.showNeighbors !== false;
    (this.roadTags || []).forEach((o) => (o.visible = !on));
    this.skyMesh.visible = !on;
    this.shadowCatcher.visible = on;
    this.scene.fog = on ? null : this.fog;
    this.scene.background = on ? this.panoTex : null;
    this.controls.enableZoom = !on;
    this.controls.enablePan = !on;
    if (!on) { this.camera.fov = 38; this.camera.updateProjectionMatrix(); this.setView('perspective'); return; }
    const q = this.pano;
    this.scene.backgroundRotation.set(0, THREE.MathUtils.degToRad(q.heading), 0);
    const b = THREE.MathUtils.degToRad(q.bearing);
    const cam = new THREE.Vector3(Math.sin(b) * q.dist, q.alt, Math.cos(b) * q.dist);
    const look = (q.look ? new THREE.Vector3(...q.look) : new THREE.Vector3(0, 30, 0)).sub(cam).normalize();
    this.camera.position.copy(cam);
    this.camera.fov = q.fov;
    this.camera.updateProjectionMatrix();
    // Nhìn quanh tại chỗ: mục tiêu đặt sát trước camera
    this.controls.target.copy(cam).add(look.multiplyScalar(0.5));
    this.controls.minDistance = 0.1;
    this.controls.update();
  }

  /** Ảnh 360 flycam khu đất dự án: camera đặt ngay trên ngã tư Minh Mạng – Nguyễn Phước Lan */
  showSitePano(onReady) {
    // Ngã tư nằm ở (AVENUE_X, roadZ) → quy ra hướng/khoảng cách so với tâm F2
    const bearing = (THREE.MathUtils.radToDeg(Math.atan2(AVENUE_X, this.roadZ)) + 360) % 360;
    const dist = Math.hypot(AVENUE_X, this.roadZ);
    this.setPano(`${import.meta.env.BASE_URL || './'}pano/khu-dat-360.jpg`, onReady, { ...SITE_PANO, bearing, dist });
  }

  // ---------------- Xem theo cao độ tầng ----------------
  floorY(fi) { const b = this.getBuilding(); return b.podiumFloors * b.podiumHeight + fi * b.floorHeight; }

  /** Bay camera mượt tới vị trí / điểm nhìn mới */
  flyTo(pos, target, dur = 1100) {
    this.fly = { t0: performance.now(), dur, p0: this.camera.position.clone(), p1: pos.clone(), q0: this.controls.target.clone(), q1: target.clone() };
  }

  tickFly() {
    const f = this.fly;
    if (!f) return;
    const t = Math.min(1, (performance.now() - f.t0) / f.dur);
    const e = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    this.camera.position.lerpVectors(f.p0, f.p1, e);
    this.controls.target.lerpVectors(f.q0, f.q1, e);
    if (t >= 1) this.fly = null;
  }

  /** Dải sáng quanh tòa đánh dấu tầng đang chọn */
  markFloor(fi) {
    if (!this.floorBand) {
      const fp = rectM(PODIUM);
      const g = new THREE.EdgesGeometry(new THREE.BoxGeometry(fp.x1 - fp.x0 + 1.2, 3.2, fp.y1 - fp.y0 + 1.2));
      this.floorBand = new THREE.LineSegments(g, new THREE.LineBasicMaterial({ color: 0x38bdf8 }));
      this.floorBand.position.set((fp.x0 + fp.x1) / 2, 0, (fp.y0 + fp.y1) / 2);
      this.scene.add(this.floorBand);
    }
    this.floorBand.visible = fi !== null;
    if (fi !== null) this.floorBand.position.y = this.floorY(fi) + 1.6;
  }

  setFov(f) { this.camera.fov = f; this.camera.updateProjectionMatrix(); }

  leavePano() {
    if (this.pano) { this.pano = null; this.applyPano(); }
    this.controls.enableZoom = true;
    this.controls.enablePan = true;
  }

  /** Xoay quanh tòa ở đúng cao độ tầng fi (giữ hướng nhìn hiện tại) */
  orbitFloor(fi, smooth = true) {
    this.leavePano();
    this.viewMode = 'orbit';
    this.markFloor(fi);
    this.setFov(55);
    this.controls.minDistance = 15;
    this.controls.maxPolarAngle = Math.PI * 0.62;
    const y = this.floorY(fi) + 1.6;
    const target = new THREE.Vector3(0, y, 0);
    const dir = this.camera.position.clone().sub(this.controls.target).setY(0);
    if (dir.lengthSq() < 1) dir.set(0.4, 0, 1);
    // Bán kính nhỏ hơn khoảng cách tới các tòa bên kia đường để không lọt vào tòa khác
    dir.normalize().multiplyScalar(52);
    const pos = target.clone().add(dir).add(new THREE.Vector3(0, 3, 0));
    smooth ? this.flyTo(pos, target) : (this.camera.position.copy(pos), this.controls.target.copy(target));
  }

  /** Đứng ở mặt tiền tầng fi (của căn slot nếu có), nhìn ra ngoài; kéo chuột để nhìn quanh tại chỗ */
  viewFromFloor(fi, slot = null, smooth = true) {
    this.leavePano();
    this.viewMode = 'look';
    this.markFloor(null);
    this.setFov(65);
    const y = this.floorY(fi) + 1.6;
    let out, at;
    if (slot) {
      const r = slot.fit || slot.rect;
      const c = new THREE.Vector3((r.x0 + r.x1) / 2, 0, (r.y0 + r.y1) / 2);
      // Hướng ra mặt tiền: cạnh ô căn xa tâm tòa nhất
      const fp = rectM(PODIUM);
      const d = [[c.x - fp.x0, -1, 0], [fp.x1 - c.x, 1, 0], [c.z - fp.y0, 0, -1], [fp.y1 - c.z, 0, 1]].sort((a, b) => a[0] - b[0])[0];
      out = new THREE.Vector3(d[1], 0, d[2]);
      at = new THREE.Vector3(d[1] ? (d[1] < 0 ? r.x0 : r.x1) : c.x, y, d[2] ? (d[2] < 0 ? r.y0 : r.y1) : c.z).add(out.clone().multiplyScalar(1.2));
    } else {
      // Không chọn căn: đứng ở mặt bắc cánh phải, nhìn về sông Đô Tỏa – biển
      const fp = rectM(PODIUM);
      const wing = rectM([1265, 340, 1635, 1135]);
      out = new THREE.Vector3(0, 0, -1);
      at = new THREE.Vector3((wing.x0 + wing.x1) / 2, y, fp.y0 - 1.2);
    }
    const target = at.clone().add(out.clone().multiplyScalar(0.6)).add(new THREE.Vector3(0, -0.12, 0));
    this.controls.minDistance = 0.1;
    this.controls.maxPolarAngle = Math.PI * 0.9;
    this.controls.enableZoom = false;
    this.controls.enablePan = false;
    smooth ? this.flyTo(at, target, 1400) : (this.camera.position.copy(at), this.controls.target.copy(target));
  }

  /** Thoát chế độ ngắm view, về góc nhìn bình thường */
  resetFloorView() {
    this.viewMode = null;
    this.markFloor(null);
    this.setFov(38);
    this.controls.minDistance = 15;
    this.controls.maxPolarAngle = Math.PI * 0.495;
    this.controls.enableZoom = true;
    this.controls.enablePan = true;
    this.setView('perspective');
  }

  /** Xem mặt bằng tầng chi tiết: chỉ tầng fi, camera nhìn xuống chếch như ảnh phối cảnh */
  /** Tải ảnh PNG nét cao của khung 3D tòa nhà (kèm nhãn mã căn / tên tòa đang hiện) */
  exportPNG(info = {}) {
    this.labels.render(this.scene, this.camera);
    return exportImage({ renderer: this.renderer, scene: this.scene, camera: this.camera, render: () => this.renderer.render(this.scene, this.camera), ...info });
  }

  /** Xem riêng khối đế: ẩn các tầng ở, hiện mã shop, đưa camera về sát khối đế */
  showShops(floor) {
    this.shopsMode = floor || 0; // 0 = cả tòa, 1 = shop tầng 1, 2 = tầng 2 + hồ bơi
    this.onlyFloor = null;
    this.maxFloor = floor ? 0 : Infinity;
    this.rebuild();
    if (floor) { this.camera.position.set(-6, 62, 46); this.controls.target.set(0, floor === 1 ? 0 : 4, 3); this.controls.update(); }
  }

  showFloorPlan(fi) {
    const b = this.getBuilding();
    this.onlyFloor = fi;
    this.rebuild();
    const y = b.podiumFloors * b.podiumHeight + fi * b.floorHeight;
    this.camera.position.set(4, y + 78, 40);
    this.controls.target.set(0, y, 1);
    this.controls.update();
  }

  /** Góc nhìn: 'perspective' = như ảnh phối cảnh (dọc đại lộ), 'close' = cận cảnh tòa */
  setView(name) {
    if (name === 'perspective') { this.camera.position.set(AVENUE_X + 6, 62, 260); this.controls.target.set(AVENUE_X + 10, 38, -10); }
    else { this.camera.position.set(95, 85, 120); this.controls.target.set(0, 30, 0); }
    this.controls.update();
  }

  /** Dựng một tòa vào group; interactive = có khối căn để chọn */
  buildTower(root, b, { interactive, colorBy, crown = 0xd9542f }) {
    const floors = residentialFloors(b.floors);
    const H = b.floorHeight, P = b.podiumHeight;
    const slabMat = new THREE.MeshStandardMaterial({ color: 0xf4f1ea, roughness: 0.6 });
    const coreMat = new THREE.MeshStandardMaterial({ color: 0x9aa0a8, roughness: 0.8 });
    const glassMat = new THREE.MeshStandardMaterial({ color: 0x2f4f6b, roughness: 0.06, metalness: 0.7 });
    const roofMat = new THREE.MeshStandardMaterial({ color: 0x5c8f3a, roughness: 1 });
    const add = (geo, material, shadow = true) => {
      const m = new THREE.Mesh(geo, material);
      m.castShadow = shadow;
      m.receiveShadow = true;
      root.add(m);
      return m;
    };
    // Khối đế rộng hơn thân tháp ~3 m mỗi phía (mái đế = sân vườn tầng 3, theo bản vẽ tầng 3)
    const pod0 = rectM(PODIUM), POD_OUT = 3;
    const pod = { x0: pod0.x0 - POD_OUT, y0: pod0.y0 - POD_OUT, x1: pod0.x1 + POD_OUT, y1: pod0.y1 + POD_OUT };
    const units = [];
    this.buildPodium(root, b, pod, { interactive, colorBy, add, slabMat, glassMat, units });
    const base = b.podiumFloors * P;
    if (!(interactive && this.shopsMode)) this.addGardenRing(root, pod, base, false);
    const visibleTop = interactive ? Math.min(this.maxFloor, floors.length) : floors.length;
    const only = interactive ? this.onlyFloor : null;
    floors.forEach((fl, fi) => {
      if (fi >= visibleTop || (only !== null && fi > only)) return;
      const y = base + fi * H;
      const ghost = only !== null && fi < only;
      const detailFloor = interactive && fi === only && this.detail;
      if (detailFloor) this.addCoreDetail(root, y);
      else for (const c of CORES) add(roundedPrism(rectM(c), y, H - 0.3, {}, 0.05), coreMat, false);
      for (const sl of SLOT_LIST) {
        const st = b.units[`${fl}-${sl.slot}`]?.status || 'available';
        const passes = !interactive || (this.filter.status.has(st) && (!this.filter.type || this.filter.type === sl.type));
        let material;
        // Ở mặt bằng tầng chi tiết, ô chưa có mặt bằng tô màu loại căn cho dễ đọc
        if (colorBy === 'facade' && fi === only) {
          material = new THREE.MeshStandardMaterial({ color: TYPE_COLORS[sl.type], roughness: 0.6 });
        } else if (colorBy === 'facade') {
          const map = this.facadeTex[ORANGE_SLOTS.has(sl.slot) ? 'orange' : fi < 6 && sl.rect.x0 < 0 ? 'green' : 'beige'];
          map.repeat.set(1 / 4.5, 1 / (H - 0.3));
          material = new THREE.MeshStandardMaterial({ map, roughness: 0.55, transparent: ghost || !passes, opacity: ghost ? 0.15 : passes ? 1 : 0.2 });
        } else {
          const col = colorBy === 'type' ? TYPE_COLORS[sl.type] : STATUS[st].color;
          material = new THREE.MeshStandardMaterial({ color: col, roughness: 0.45, transparent: !passes || ghost, opacity: ghost ? 0.12 : passes ? 1 : 0.18 });
        }
        const layout = interactive && fi === only && this.detail ? slotLayout(b, sl.slot) : null;
        if (layout) {
          units.push(this.addDetailedUnit(root, sl, layout, y, material, fl, fi));
          continue;
        }
        const m = add(roundedPrism(sl.rect, y, H - 0.3, SLOT_RADII[sl.slot], 0.08), material);
        if (!interactive) continue;
        m.userData = { floor: fl, floorIndex: fi, slot: sl, key: `${fl}-${sl.slot}` };
        units.push(m);
        if (fi === only) {
          const el = document.createElement('div');
          el.className = 'unitlabel';
          el.innerHTML = `<b>${sl.slot}</b><span>${sl.type}</span>`;
          const lab = new CSS2DObject(el);
          lab.position.set((sl.rect.x0 + sl.rect.x1) / 2, y + H, (sl.rect.y0 + sl.rect.y1) / 2);
          root.add(lab);
        }
      }
      // Sàn + ban công nhô 0,4 m tạo vệt trắng ngang (bỏ ở tầng đang xem riêng)
      if (fi !== only) for (const w of WINGS) add(roundedPrism(rectM(w.px), y + H - 0.3, 0.3, w.radii, -0.4), slabMat);
      // Tầng 3A–7: sàn sân vườn riêng bao quanh tầng (đỡ bởi sàn tầng dưới / mái khối đế)
      if (GARDEN_FLOORS.has(fl) && !ghost) this.addGardenRing(root, pod, y, true);
      if (interactive && (fi % 2 === 0 || fi === floors.length - 1)) {
        const el = document.createElement('div');
        el.className = 'floorlabel';
        el.textContent = 'T' + fl.replace(/^0/, '');
        const lab = new CSS2DObject(el);
        lab.position.set(pod.x1 + 3, y + H / 2, pod.y1);
        root.add(lab);
      }
    });
    // Mái: khung trắng + vườn trên mái
    if (visibleTop >= floors.length && only === null) {
      const roofY = base + floors.length * H;
      const leaf = new THREE.MeshStandardMaterial({ color: 0x3f7d33, flatShading: true });
      for (const w of [WINGS[0], WINGS[2]]) {
        const r = rectM(w.px);
        add(roundedPrism(r, roofY, 0.3, w.radii, 0.3), roofMat, false);
        add(roundedPrism(r, roofY + 2.4, 0.35, w.radii, -0.4), slabMat);
        for (let i = 0; i < 10; i++) {
          const t = new THREE.Mesh(new THREE.IcosahedronGeometry(0.8 + (i % 3) * 0.35, 0), leaf);
          t.position.set(r.x0 + 2 + ((r.x1 - r.x0 - 4) * ((i * 37) % 100)) / 100, roofY + 1, r.y0 + 2 + ((r.y1 - r.y0 - 4) * ((i * 61) % 100)) / 100);
          t.castShadow = true;
          root.add(t);
        }
      }
      // Khung pergola màu trên mái (mỗi tòa một màu như ảnh phối cảnh)
      const crownMat = new THREE.MeshStandardMaterial({ color: crown, roughness: 0.5 });
      for (const w of [WINGS[0], WINGS[2]]) {
        const r = rectM(w.px);
        const inset = 3.2;
        const fr = { x0: r.x0 + inset, y0: r.y0 + inset, x1: r.x1 - inset, y1: Math.min(r.y1 - inset, r.y0 + 14) };
        const bar = (x0, z0, x1, z1) => { const m = new THREE.Mesh(new THREE.BoxGeometry(Math.max(0.4, x1 - x0), 0.6, Math.max(0.4, z1 - z0)), crownMat); m.position.set((x0 + x1) / 2, roofY + 3.6, (z0 + z1) / 2); m.castShadow = true; root.add(m); };
        bar(fr.x0, fr.y0, fr.x1, fr.y0 + 0.4); bar(fr.x0, fr.y1 - 0.4, fr.x1, fr.y1); bar(fr.x0, fr.y0, fr.x0 + 0.4, fr.y1); bar(fr.x1 - 0.4, fr.y0, fr.x1, fr.y1);
        for (let x = fr.x0 + 1.2; x < fr.x1 - 0.6; x += 1.2) bar(x, fr.y0, x + 0.15, fr.y1);
        for (const [x, z] of [[fr.x0, fr.y0], [fr.x1, fr.y0], [fr.x0, fr.y1], [fr.x1, fr.y1]]) {
          const c = new THREE.Mesh(new THREE.BoxGeometry(0.4, 3.6, 0.4), crownMat);
          c.position.set(x, roofY + 1.8, z);
          root.add(c);
        }
      }
      // Cột khung trắng ở 4 góc mái
      for (const w of [WINGS[0], WINGS[2]]) {
        const r = rectM(w.px);
        for (const [x, z] of [[r.x0 + 1.5, r.y0 + 1.5], [r.x1 - 1.5, r.y0 + 1.5], [r.x0 + 1.5, r.y1 - 1.5], [r.x1 - 1.5, r.y1 - 1.5]]) {
          const c = new THREE.Mesh(new THREE.BoxGeometry(0.35, 2.4, 0.35), slabMat);
          c.position.set(x, roofY + 1.2, z);
          root.add(c);
        }
      }
    }
    return units;
  }

  /** Đặt căn chi tiết (tường, cửa, nội thất) vào ô căn; trả về khối chọn trong suốt để rê/nhấp */
  /** Khối đế 2 tầng: shop tầng 1 (từng ô bấm được, kính mặt tiền + băng biển hiệu), tầng 2 thương mại + căn hộ cánh phải,
   *  sàn hồ bơi ngoài trời ở sân giữa hai cánh */
  buildPodium(root, b, pod, { interactive, colorBy, add, slabMat, glassMat, units }) {
    const P = b.podiumHeight, R8 = { tl: 8, tr: 8, bl: 8, br: 8 };
    const bandMat = new THREE.MeshStandardMaterial({ color: 0x2b2f36, roughness: 0.5 });
    const shopGlass = new THREE.MeshStandardMaterial({ color: 0xb9d7e3, roughness: 0.08, metalness: 0.55, emissive: 0xffd9a0, emissiveIntensity: 0.12 });
    const aptMat = new THREE.MeshStandardMaterial({ color: 0xefe9df, roughness: 0.6 });
    const innerMat = new THREE.MeshStandardMaterial({ color: 0x55606b, roughness: 0.4, metalness: 0.3 });
    const near = (a, c) => Math.abs(a - c) < 0.6;
    const radiiOf = (r, box) => ({ tl: near(r.x0, box.x0) && near(r.y0, box.y0) ? 8 : 0, tr: near(r.x1, box.x1) && near(r.y0, box.y0) ? 8 : 0, bl: near(r.x0, box.x0) && near(r.y1, box.y1) ? 8 : 0, br: near(r.x1, box.x1) && near(r.y1, box.y1) ? 8 : 0 });
    const tower = rectM(PODIUM);
    // Tầng 1: lõi (sảnh, thang, hành lang) phía trong + slab; khi xem riêng tầng shop thì lõi chỉ còn là sàn
    const mode = interactive ? this.shopsMode || 0 : 0;
    const floorMat = new THREE.MeshStandardMaterial({ color: 0xe8e4dc, roughness: 0.7 });
    if (mode === 1) add(roundedPrism(pod, 0, 0.15, R8, 0.3), floorMat, false);
    else add(roundedPrism(pod, 0, P - 0.45, R8, 1.2), innerMat);
    if (mode !== 1) add(roundedPrism(pod, P - 0.45, 0.45, R8), slabMat);
    // Tầng 2: lõi thân tháp + slab; sân giữa là sàn hồ bơi để trống
    if (mode === 2) for (const w of WINGS) add(roundedPrism(rectM(w.px), P, 0.15, w.radii, 0.3), floorMat, false);
    else if (!mode) for (const w of WINGS) add(roundedPrism(rectM(w.px), P, P - 0.45, w.radii, 1.0), innerMat);
    if (!mode) for (const w of WINGS) add(roundedPrism(rectM(w.px), 2 * P - 0.45, 0.45, w.radii, -0.3), slabMat);
    const deck = rectM(POOL_DECK), pool = rectM(POOL);
    const deckMat = new THREE.MeshStandardMaterial({ color: 0xd9cbb3, roughness: 0.8 });
    const water = new THREE.MeshStandardMaterial({ color: 0x3fb4d8, roughness: 0.05, metalness: 0.2, emissive: 0x0b4f6b, emissiveIntensity: 0.25 });
    if (mode !== 1) {
    add(roundedPrism(deck, P, 0.08, {}), deckMat, false);
    add(roundedPrism(pool, P + 0.02, 0.08, { tl: 1, tr: 1, bl: 1, br: 1 }), water, false);
    for (let k = 0; k < 6; k++) { // ghế tắm nắng
      const x = pool.x0 + 1 + k * ((pool.x1 - pool.x0 - 2) / 5);
      const m = add(new THREE.BoxGeometry(0.7, 0.3, 1.8), new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.6 }));
      m.position.set(x, P + 0.25, pool.y0 - 1.6);
    }
    }
    const tagEl = (txt, x, y, z) => { if (!interactive) return; const el = document.createElement('div'); el.className = 'unitlabel shoplabel'; el.innerHTML = txt; const lab = new CSS2DObject(el); lab.position.set(x, y, z); root.add(lab); this.shopLabels.push(lab); };
    if (interactive) { this.shopLabels = []; if (mode === 2) tagEl('<span>Hồ bơi</span>', (pool.x0 + pool.x1) / 2, P + 1, (pool.y0 + pool.y1) / 2); }
    for (const sh of SHOPS) {
      const i = sh.floor === '01' ? 0 : 1, y0 = i * P;
      if (mode === 1 && i === 1) continue;
      const r = sh.rect, radii = radiiOf(r, i === 0 ? pod : tower);
      if (sh.apt) {
        // Căn hộ tầng 2 (cánh phải): bấm được như căn ở tầng trên
        const key = `02-${sh.slot}`, st = b.units[key]?.status || 'available';
        const passes = !interactive || (this.filter.status.has(st) && (!this.filter.type || this.filter.type === sh.type));
        const mat = colorBy === 'facade' ? aptMat : new THREE.MeshStandardMaterial({ color: colorBy === 'type' ? TYPE_COLORS[sh.type] : STATUS[st].color, roughness: 0.45, transparent: !passes, opacity: passes ? 1 : 0.2 });
        const m = add(roundedPrism(r, y0, mode === 2 ? 1.6 : P - 0.45, SLOT_RADII[sh.slot] || radii, 0.08), mat);
        if (interactive) { m.userData = { floor: '02', floorIndex: -1, slot: sh, key }; units.push(m); if (mode === 2) tagEl(`<b>${sh.label}</b>`, (r.x0 + r.x1) / 2, y0 + 1.8, (r.y0 + r.y1) / 2); }
        continue;
      }
      const key = `${sh.floor}-${sh.slot}`;
      const st = b.units[key]?.status || 'available';
      const passes = !interactive || (this.filter.status.has(st) && (!this.filter.type || this.filter.type === 'Shop'));
      const material = colorBy === 'facade' ? shopGlass : new THREE.MeshStandardMaterial({ color: colorBy === 'type' ? TYPE_COLORS.Shop : STATUS[st].color, roughness: 0.45, transparent: !passes, opacity: passes ? 1 : 0.2 });
      const cut = mode === i + 1; // đang xem riêng tầng này: khối thấp, không băng biển hiệu, thấy rõ màu từng ô
      const m = add(roundedPrism(r, y0, cut ? 1.6 : P - 1.1, radii, cut ? 0.25 : 0.1), material);
      if (!cut) add(roundedPrism(r, y0 + P - 1.1, 0.65, radii, 0.06), bandMat);
      if (!interactive) continue;
      m.userData = { floor: sh.floor, floorIndex: -2 + i, slot: sh, key };
      units.push(m);
      if (mode === i + 1) tagEl(`<b>${sh.label}</b>`, (r.x0 + r.x1) / 2, y0 + 1.8, (r.y0 + r.y1) / 2);
    }
  }

  /** Sân vườn bao quanh tầng: sàn cỏ, bồn cây + lan can kính ở mép, cây bụi, hàng rào cây ngăn sân giữa các căn */
  addGardenRing(root, pod, y, slab) {
    const M = (c, o = {}) => new THREE.MeshStandardMaterial({ color: c, roughness: 0.9, ...o });
    this._gm ||= { grass: M(0x6f9e48, { roughness: 1 }), planter: M(0xd9d3c7, { roughness: 0.8 }), leaf: M(0x3f7a35), slab: M(0xf2efe9, { roughness: 0.6 }), glass: new THREE.MeshStandardMaterial({ color: 0xa9d6ea, roughness: 0.05, metalness: 0.3, transparent: true, opacity: 0.3 }) };
    const g = this._gm;
    const R = { tl: 8, tr: 8, bl: 8, br: 8 };
    const add = (geo, mat, shadow = true) => { const m = new THREE.Mesh(geo, mat); m.castShadow = shadow; m.receiveShadow = true; root.add(m); return m; };
    if (slab) add(roundedPrism(pod, y - 0.3, 0.3, R), g.slab);
    add(roundedPrism(pod, y, 0.06, R, 0.4), g.grass, false);
    const bx = (x0, x1, z0, z1, y0, hh, mat) => { const m = add(new THREE.BoxGeometry(x1 - x0, hh, z1 - z0), mat); m.position.set((x0 + x1) / 2, y0 + hh / 2, (z0 + z1) / 2); return m; };
    const e = 0.9, h = 0.5, t = 0.5;
    const edges = [[pod.x0 + e, pod.x1 - e, pod.y0 + e - t, pod.y0 + e], [pod.x0 + e, pod.x1 - e, pod.y1 - e, pod.y1 - e + t], [pod.x0 + e - t, pod.x0 + e, pod.y0 + e, pod.y1 - e], [pod.x1 - e, pod.x1 - e + t, pod.y0 + e, pod.y1 - e]];
    for (const [x0, x1, z0, z1] of edges) {
      bx(x0, x1, z0, z1, y, h, g.planter);
      bx(x0, x1, z0, z1, y + h, 0.4, g.leaf);
    }
    // lan can kính ngoài cùng
    const gt = 0.04;
    for (const [x0, x1, z0, z1] of [[pod.x0 + 0.3, pod.x1 - 0.3, pod.y0 + 0.3, pod.y0 + 0.3 + gt], [pod.x0 + 0.3, pod.x1 - 0.3, pod.y1 - 0.3 - gt, pod.y1 - 0.3], [pod.x0 + 0.3, pod.x0 + 0.3 + gt, pod.y0 + 0.3, pod.y1 - 0.3], [pod.x1 - 0.3 - gt, pod.x1 - 0.3, pod.y0 + 0.3, pod.y1 - 0.3]]) bx(x0, x1, z0, z1, y, 1.1, g.glass).castShadow = false;
    // hàng rào cây ngăn sân giữa các căn ở mặt ngoài
    const T = rectM(PODIUM);
    for (const sl of SLOT_LIST) {
      const r = sl.rect;
      if (Math.abs(r.x0 - T.x0) < 0.3) for (const z of [r.y0, r.y1]) bx(pod.x0 + e, T.x0, z - 0.2, z + 0.2, y, 0.9, g.leaf);
      if (Math.abs(r.x1 - T.x1) < 0.3) for (const z of [r.y0, r.y1]) bx(T.x1, pod.x1 - e, z - 0.2, z + 0.2, y, 0.9, g.leaf);
      if (Math.abs(r.y1 - T.y1) < 0.3) for (const x of [r.x0, r.x1]) bx(x - 0.2, x + 0.2, T.y1, pod.y1 - e, y, 0.9, g.leaf);
      if (Math.abs(r.y0 - T.y0) < 0.3) for (const x of [r.x0, r.x1]) bx(x - 0.2, x + 0.2, pod.y0 + e, T.y0, y, 0.9, g.leaf);
    }
    // cây bụi tròn dọc vành sân
    this._ball ||= new THREE.SphereGeometry(0.6, 10, 8);
    const ring = (x, z) => (x < T.x0 || x > T.x1 || z < T.y0 || z > T.y1);
    for (let x = pod.x0 + 1.9; x < pod.x1 - 1.5; x += 3.1)
      for (const z of [pod.y0 + 1.9, pod.y1 - 1.9]) if (ring(x, z)) { const m = add(this._ball, g.leaf); const sc = 0.8 + ((x * 13) % 4) * 0.1; m.scale.set(sc, sc * 0.85, sc); m.position.set(x, y + 0.5 * sc, z); }
    for (let z = pod.y0 + 4; z < pod.y1 - 3; z += 3.1)
      for (const x of [pod.x0 + 1.9, pod.x1 - 1.9]) if (ring(x, z)) { const m = add(this._ball, g.leaf); const sc = 0.8 + ((z * 7) % 4) * 0.1; m.scale.set(sc, sc * 0.85, sc); m.position.set(x, y + 0.5 * sc, z); }
  }

  /** Lõi thang ở mặt bằng tầng chi tiết – vẽ theo bản vẽ tầng 8–19 (px ảnh 2000×1414, cánh phải đối xứng):
   *  lõi trên: thang bộ thoát hiểm + 2 thang máy + phòng kỹ thuật; lõi dưới: 2 thang máy + 2 phòng kỹ thuật */
  addCoreDetail(root, y) {
    const M = (c, o = {}) => new THREE.MeshStandardMaterial({ color: c, roughness: 0.7, ...o });
    const mats = { lobby: M(0xe8e4dc), floor: M(0xd8d4cc), wall: M(0x6b6e74), shaft: M(0x2b2e33), door: M(0xc4c9d0, { roughness: 0.25, metalness: 0.8 }), fire: M(0x8a4b2f), step: M(0xcfcac0), rail: M(0x55595f) };
    const WH = 2.6, yb = y + 0.1;
    const MXp = (x) => 2075 - x;
    const box = (px, y0, h, mat, mirror) => {
      const r = rectM(mirror ? [MXp(px[2]), px[1], MXp(px[0]), px[3]] : px);
      const m = new THREE.Mesh(new THREE.BoxGeometry(r.x1 - r.x0, h, r.y1 - r.y0), mat);
      m.position.set((r.x0 + r.x1) / 2, y0 + h / 2, (r.y0 + r.y1) / 2);
      m.receiveShadow = true; m.castShadow = h > 1;
      root.add(m);
    };
    const tag = (text, px, pz, mirror) => {
      const el = document.createElement('div');
      el.className = 'unitlabel corelabel';
      el.innerHTML = `<span>${text}</span>`;
      const lab = new CSS2DObject(el);
      const r = rectM([mirror ? MXp(px) : px, pz, mirror ? MXp(px) : px, pz]);
      lab.position.set(r.x0, y + WH, r.y0);
      root.add(lab);
    };
    // Hành lang: chỉ là sàn
    for (const c of CORRIDORS) { const r = rectM(c); const m = new THREE.Mesh(new THREE.BoxGeometry(r.x1 - r.x0, 0.1, r.y1 - r.y0), mats.lobby); m.position.set((r.x0 + r.x1) / 2, y + 0.05, (r.y0 + r.y1) / 2); m.receiveShadow = true; root.add(m); }
    const WALLS = [
      // lõi trên
      [657, 740, 808, 744], [804, 740, 808, 850], [657, 740, 661, 746], [657, 768, 661, 804], [657, 800, 808, 804],
      [657, 804, 661, 850], [703, 804, 707, 850], [755, 804, 758, 846],
      [661, 846, 685, 850], [700, 846, 717, 850], [745, 846, 766, 850], [794, 846, 804, 850],
      // lõi dưới
      [657, 905, 724, 909], [752, 905, 769, 909], [797, 905, 808, 909], [804, 905, 808, 970], [657, 966, 808, 970],
      [657, 909, 661, 912], [657, 930, 661, 944], [657, 962, 661, 966], [711, 909, 715, 966], [757, 909, 760, 966], [661, 935, 711, 939],
    ];
    const LIFTS = [[707, 804, 755, 846], [758, 804, 804, 846], [715, 909, 757, 966], [760, 909, 804, 966]];
    const LIFT_DOORS = [[717, 847, 745, 849], [766, 847, 794, 849], [724, 906, 752, 908], [769, 906, 797, 908]];
    const SHAFTS = [[662, 772, 692, 799], [662, 828, 682, 845]];
    for (const mirror of [false, true]) {
      // sàn lõi + sảnh thang máy (hành lang rộng ra trước thang)
      box([655, 740, 810, 970], y, 0.1, mats.floor, mirror);
      box([655, 850, 810, 905], y + 0.005, 0.1, mats.lobby, mirror);
      for (const w of WALLS) box(w, yb, WH, mats.wall, mirror);
      for (const l of LIFTS) box(l, yb, 0.02, mats.shaft, mirror);
      for (const d of LIFT_DOORS) box(d, yb, 2.1, mats.door, mirror);
      for (const sft of SHAFTS) box(sft, yb, 0.03, mats.shaft, mirror);
      box([657, 746, 659, 768], yb, 2.1, mats.fire, mirror); // cửa chống cháy thang bộ
      // Thang bộ: 2 vế chạy dọc trục x, chiếu nghỉ phía trong
      const n = 9, x0 = 735, x1 = 782, dx = (x1 - x0) / n;
      for (let k = 0; k < n; k++) {
        box([x0 + k * dx, 745, x0 + (k + 1) * dx, 769], yb, 0.17 * (n - k) * 0.5, mats.step, mirror);
        box([x0 + k * dx, 774, x0 + (k + 1) * dx, 798], yb, 0.17 * (k + 1) * 0.5 + 0.77, mats.step, mirror);
      }
      box([782, 745, 803, 798], yb, 0.17 * n * 0.5 + 0.77, mats.step, mirror);
      box([735, 770, 782, 773], yb, 1.9, mats.rail, mirror);
      tag('Thang bộ', 760, 771, mirror);
      tag('Thang máy', 756, 825, mirror);
      tag('Thang máy', 760, 937, mirror);
    }
  }

  addDetailedUnit(root, sl, layout, y, material, fl, fi) {
    this._unitCache ||= new Map();
    const key = layout.unitId || JSON.stringify(layout.plan).length + ':' + sl.slot;
    let proto = this._unitCache.get(key);
    if (!proto) {
      proto = buildScene(layout.plan, { clippingPlanes: [], ceiling: false, landscape: false, labels: false, lights: false }).root;
      // Bỏ dữ liệu tương tác (cửa mở được…) – có tham chiếu vòng, không sao chép được khi clone
      proto.traverse((o) => { o.userData = {}; });
      this._unitCache.set(key, proto);
    }
    const g = proto.clone(true);
    const r = SLOT_RADII[sl.slot] || {};
    const f = sl.fit;
    const corner = r.tl ? { x: f.x0, y: f.y0 } : r.tr ? { x: f.x1, y: f.y0 } : r.bl ? { x: f.x0, y: f.y1 } : r.br ? { x: f.x1, y: f.y1 } : null;
    g.matrixAutoUpdate = false;
    g.matrix.copy(placeUnit(layout.plan, { fit: f, corner }, CORRIDORS_M, y + 0.12));
    root.add(g);
    // Đế màu theo trạng thái / loại căn bên dưới căn (lộ ra như viền màu)
    const plate = new THREE.Mesh(roundedPrism(sl.fit, y, 0.12, SLOT_RADII[sl.slot], -0.05), material);
    plate.receiveShadow = true;
    root.add(plate);
    // Khối chọn vô hình để rê chuột / nhấp chọn căn
    const pick = new THREE.Mesh(roundedPrism(sl.fit, y, 2.8, SLOT_RADII[sl.slot], 0), new THREE.MeshBasicMaterial({ colorWrite: false, depthWrite: false }));
    pick.userData = { floor: fl, floorIndex: fi, slot: sl, key: `${fl}-${sl.slot}`, plate, detailed: true };
    root.add(pick);
    const el = document.createElement('div');
    el.className = 'unitlabel';
    el.innerHTML = `<b>${sl.slot}</b><span>${sl.type}${layout.unitId || this.getBuilding().layouts?.[sl.slot] ? '' : ''}</span>`;
    const lab = new CSS2DObject(el);
    lab.position.set((f.x0 + f.x1) / 2, y + 3.4, (f.y0 + f.y1) / 2);
    root.add(lab);
    return pick;
  }

  rebuild() {
    const b = this.getBuilding();
    if (this.root) {
      this.scene.remove(this.root);
      this.root.traverse((o) => { o.geometry?.dispose(); o.material?.dispose?.(); if (o.element?.parentNode) o.element.remove(); });
    }
    this.root = new THREE.Group();
    this.unitMeshes = this.buildTower(this.root, b, { interactive: true, colorBy: this.colorBy });
    this.floors = residentialFloors(b.floors);
    this.scene.add(this.root);
    this.highlightSelected();
  }

  setSelected(key) { this.selected = key; this.highlightSelected(); }

  highlightSelected() {
    for (const m of this.unitMeshes || []) {
      const on = m.userData.key === this.selected;
      const mat = m.userData.plate ? m.userData.plate.material : m.material;
      mat.emissive?.setHex(on ? 0x3b82f6 : 0x000000);
      mat.emissiveIntensity = on ? 0.9 : 0;
    }
  }

  pick(e) {
    const rect = this.renderer.domElement.getBoundingClientRect();
    const v = new THREE.Vector2(((e.clientX - rect.left) / rect.width) * 2 - 1, -((e.clientY - rect.top) / rect.height) * 2 + 1);
    this.raycaster.setFromCamera(v, this.camera);
    const hit = this.raycaster.intersectObjects(this.unitMeshes.filter((m) => m.userData.detailed || !m.material.transparent || m.material.opacity > 0.5), false)[0];
    return hit?.object;
  }

  bindEvents() {
    const el = this.renderer.domElement;
    let down = null;
    el.addEventListener('pointerdown', (e) => (down = { x: e.clientX, y: e.clientY }));
    el.addEventListener('pointerup', (e) => {
      if (!down || Math.hypot(e.clientX - down.x, e.clientY - down.y) > 5) return;
      const m = this.pick(e);
      if (m) { this.setSelected(m.userData.key); this.onSelect?.(m.userData); }
    });
    el.addEventListener('pointermove', (e) => {
      const m = this.pick(e);
      const t = this.tooltip;
      if (!m) { t.style.display = 'none'; el.style.cursor = ''; return; }
      const b = this.getBuilding();
      const { floor, floorIndex, slot } = m.userData;
      const u = b.units[`${floor}-${slot.slot}`] || {};
      const ar = areaOf(floor, slot);
      t.innerHTML = `<b>${unitCode(b, floor, slot.slot)}</b> · ${slot.type}<br>${ar.tim} m² tim · ${ar.tt} m² TT${this.readonly ? '' : `<br>${STATUS[u.status || 'available'].name} · ${unitPrice(b, floorIndex, slot).toFixed(2)} tỷ`}`;
      const r = this.container.getBoundingClientRect();
      t.style.display = 'block';
      t.style.left = e.clientX - r.left + 14 + 'px';
      t.style.top = e.clientY - r.top + 14 + 'px';
      el.style.cursor = 'pointer';
    });
  }

  resize() {
    const w = this.container.clientWidth || 1, h = this.container.clientHeight || 1;
    this.renderer.setSize(w, h);
    this.labels.setSize(w, h);
    this.camera.aspect = w / h;
    this.camera.updateProjectionMatrix();
  }
}
