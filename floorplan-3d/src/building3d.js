// Tòa nhà 3D: dựng khối tòa theo tầng, mỗi căn một khối tô màu theo trạng thái / loại căn / mặt đứng.
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { Sky } from 'three/examples/jsm/objects/Sky.js';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';
import { CSS2DRenderer, CSS2DObject } from 'three/examples/jsm/renderers/CSS2DRenderer.js';
import { SLOT_LIST, CORES, PODIUM, rectM, STATUS, TYPE_COLORS, residentialFloors, unitCode, unitPrice } from './buildingData.js';
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
  { px: [440, 330, 820, 1140], radii: { tl: 4.2, tr: 3, bl: 4.2, br: 3 } },
  { px: [820, 630, 1290, 1100], radii: {} },
  { px: [1290, 330, 1670, 1140], radii: { tl: 3, tr: 4.2, bl: 3, br: 4.2 } },
];
const ORANGE_SLOTS = new Set(['05', '06', '07', '08', '09', '10']);
export const AVENUE_X = -52;

export class BuildingView {
  constructor(container, getBuilding, onSelect, opts = {}) {
    this.light = !!opts.light;
    this.container = container;
    this.getBuilding = getBuilding;
    this.onSelect = onSelect;
    this.colorBy = 'facade';
    this.maxFloor = Infinity;
    this.onlyFloor = null;
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
    scene.fog = new THREE.Fog(0xcbdcea, 380, 1500);
    scene.environment = new THREE.PMREMGenerator(r).fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environmentIntensity = 0.45;
    const sky = new Sky();
    sky.scale.setScalar(2500);
    const u = sky.material.uniforms;
    u.turbidity.value = 3; u.rayleigh.value = 1.2; u.mieCoefficient.value = 0.003; u.mieDirectionalG.value = 0.8;
    u.sunPosition.value.setFromSphericalCoords(1, THREE.MathUtils.degToRad(42), THREE.MathUtils.degToRad(200));
    scene.add(sky);
    const sun = new THREE.DirectionalLight(0xfff1dc, 3.2);
    sun.position.set(-110, 190, 160);
    sun.castShadow = true;
    sun.shadow.mapSize.set(4096, 4096);
    Object.assign(sun.shadow.camera, { left: -190, right: 190, top: 190, bottom: -190, far: 700 });
    sun.shadow.bias = -0.0004;
    sun.shadow.normalBias = 0.05;
    scene.add(sun, new THREE.HemisphereLight(0xcfe6ff, 0x6b7f4f, 1.0));

    const fp = rectM(PODIUM);
    // Các tòa lân cận (chỉ để làm cảnh, không tương tác)
    this.neighbors = [
      { x: 2 * AVENUE_X, z: 0, mirror: true, floors: 20 },
      { x: 2 * AVENUE_X, z: -90, mirror: true, floors: 17, rot: Math.PI },
      { x: 0, z: -92, mirror: false, floors: 15, rot: Math.PI },
    ];
    this.surroundArgs = {
      footprint: { x0: fp.x0, x1: fp.x1, z0: fp.y0, z1: fp.y1 },
      avenueX: AVENUE_X,
      reserved: this.neighbors.map((n) => ({ x: n.x, z: n.z, w: fp.x1 - fp.x0 + 20, d: fp.y1 - fp.y0 + 20 })),
    };
    this.surround = buildSurroundings({ ...this.surroundArgs, density: this.light ? 0.3 : 1 });
    scene.add(this.surround);
    const b0 = getBuilding();
    for (const n of this.neighbors) {
      const g = new THREE.Group();
      this.buildTower(g, { ...b0, floors: n.floors, units: {} }, { interactive: false, colorBy: 'facade' });
      g.position.set(n.x, 0, n.z);
      g.rotation.y = n.rot || 0;
      if (n.mirror) g.scale.x = -1;
      scene.add(g);
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

  setActive(on) {
    if (on === this.active) return;
    this.active = on;
    this.renderer.setAnimationLoop(on ? () => {
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
    this.scene.add(this.surround);
    this.resize();
  }

  /** Góc nhìn: 'perspective' = như ảnh phối cảnh (dọc đại lộ), 'close' = cận cảnh tòa */
  setView(name) {
    if (name === 'perspective') { this.camera.position.set(AVENUE_X + 6, 62, 260); this.controls.target.set(AVENUE_X + 10, 38, -10); }
    else { this.camera.position.set(95, 85, 120); this.controls.target.set(0, 30, 0); }
    this.controls.update();
  }

  /** Dựng một tòa vào group; interactive = có khối căn để chọn */
  buildTower(root, b, { interactive, colorBy }) {
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
    const pod = rectM(PODIUM);
    for (let i = 0; i < b.podiumFloors; i++) {
      add(roundedPrism(pod, i * P, P - 0.45, { tl: 5, tr: 5, bl: 5, br: 5 }, 0.5), glassMat);
      add(roundedPrism(pod, i * P + P - 0.45, 0.45, { tl: 5, tr: 5, bl: 5, br: 5 }), slabMat);
    }
    const base = b.podiumFloors * P;
    const units = [];
    const visibleTop = interactive ? Math.min(this.maxFloor, floors.length) : floors.length;
    const only = interactive ? this.onlyFloor : null;
    floors.forEach((fl, fi) => {
      if (fi >= visibleTop || (only !== null && fi > only)) return;
      const y = base + fi * H;
      const ghost = only !== null && fi < only;
      for (const c of CORES) add(roundedPrism(rectM(c), y, H - 0.3, {}, 0.05), coreMat, false);
      for (const sl of SLOT_LIST) {
        const st = b.units[`${fl}-${sl.slot}`]?.status || 'available';
        const passes = !interactive || (this.filter.status.has(st) && (!this.filter.type || this.filter.type === sl.type));
        let material;
        if (colorBy === 'facade') {
          const map = this.facadeTex[ORANGE_SLOTS.has(sl.slot) ? 'orange' : fi < 6 && sl.rect.x0 < 0 ? 'green' : 'beige'];
          map.repeat.set(1 / 4.5, 1 / (H - 0.3));
          material = new THREE.MeshStandardMaterial({ map, roughness: 0.55, transparent: ghost || !passes, opacity: ghost ? 0.15 : passes ? 1 : 0.2 });
        } else {
          const col = colorBy === 'type' ? TYPE_COLORS[sl.type] : STATUS[st].color;
          material = new THREE.MeshStandardMaterial({ color: col, roughness: 0.45, transparent: !passes || ghost, opacity: ghost ? 0.12 : passes ? 1 : 0.18 });
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
      m.material.emissive?.setHex(on ? 0x3b82f6 : 0x000000);
      m.material.emissiveIntensity = on ? 0.9 : 0;
    }
  }

  pick(e) {
    const rect = this.renderer.domElement.getBoundingClientRect();
    const v = new THREE.Vector2(((e.clientX - rect.left) / rect.width) * 2 - 1, -((e.clientY - rect.top) / rect.height) * 2 + 1);
    this.raycaster.setFromCamera(v, this.camera);
    const hit = this.raycaster.intersectObjects(this.unitMeshes.filter((m) => !m.material.transparent || m.material.opacity > 0.5), false)[0];
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
      t.innerHTML = `<b>${unitCode(b, floor, slot.slot)}</b> · ${slot.type}<br>${slot.tim} m² tim · ${slot.tt} m² TT<br>${STATUS[u.status || 'available'].name} · ${unitPrice(b, floorIndex, slot).toFixed(2)} tỷ`;
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
