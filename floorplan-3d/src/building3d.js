// Tòa nhà 3D: dựng khối tòa theo tầng, mỗi căn một khối tô màu theo trạng thái / loại căn / mặt đứng.
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { Sky } from 'three/examples/jsm/objects/Sky.js';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';
import { CSS2DRenderer, CSS2DObject } from 'three/examples/jsm/renderers/CSS2DRenderer.js';
import { SLOT_LIST, CORES, PODIUM, rectM, STATUS, TYPE_COLORS, residentialFloors, unitCode, unitPrice } from './buildingData.js';
import { getTexture } from './textures.js';

function facadeTexture() {
  const c = document.createElement('canvas');
  c.width = 256; c.height = 128;
  const x = c.getContext('2d');
  x.fillStyle = '#d9d3c7'; x.fillRect(0, 0, 256, 128);
  x.fillStyle = '#2c3e50';
  x.fillRect(18, 18, 100, 88); x.fillRect(138, 18, 100, 88);
  const g = x.createLinearGradient(0, 18, 0, 106);
  g.addColorStop(0, 'rgba(160,200,230,0.55)'); g.addColorStop(1, 'rgba(40,60,80,0.1)');
  x.fillStyle = g; x.fillRect(18, 18, 100, 88); x.fillRect(138, 18, 100, 88);
  x.fillStyle = '#f2efe8'; x.fillRect(0, 112, 256, 16);
  const t = new THREE.CanvasTexture(c);
  t.colorSpace = THREE.SRGBColorSpace;
  return t;
}

export class BuildingView {
  constructor(container, getBuilding, onSelect) {
    this.container = container;
    this.getBuilding = getBuilding;
    this.onSelect = onSelect;
    this.colorBy = 'status';
    this.maxFloor = Infinity;
    this.onlyFloor = null;
    this.filter = { status: new Set(Object.keys(STATUS)), type: null };
    const r = (this.renderer = new THREE.WebGLRenderer({ antialias: true }));
    r.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    r.shadowMap.enabled = true;
    r.toneMapping = THREE.ACESFilmicToneMapping;
    container.appendChild(r.domElement);
    this.labels = new CSS2DRenderer();
    this.labels.domElement.className = 'labels-layer';
    container.appendChild(this.labels.domElement);
    const scene = (this.scene = new THREE.Scene());
    scene.environment = new THREE.PMREMGenerator(r).fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environmentIntensity = 0.4;
    const sky = new Sky();
    sky.scale.setScalar(2000);
    const u = sky.material.uniforms;
    u.turbidity.value = 5; u.rayleigh.value = 1.4; u.mieCoefficient.value = 0.004;
    u.sunPosition.value.setFromSphericalCoords(1, THREE.MathUtils.degToRad(50), THREE.MathUtils.degToRad(210));
    scene.add(sky);
    const sun = new THREE.DirectionalLight(0xfff1dc, 3);
    sun.position.set(-90, 160, 110);
    sun.castShadow = true;
    sun.shadow.mapSize.set(4096, 4096);
    Object.assign(sun.shadow.camera, { left: -110, right: 110, top: 110, bottom: -110, far: 500 });
    sun.shadow.bias = -0.0005;
    scene.add(sun, new THREE.HemisphereLight(0xcfe6ff, 0x6b7f4f, 1.0));
    const gt = getTexture('grass').clone();
    gt.needsUpdate = true;
    gt.repeat.set(160, 160);
    const ground = new THREE.Mesh(new THREE.PlaneGeometry(400, 400), new THREE.MeshStandardMaterial({ map: gt }));
    ground.rotation.x = -Math.PI / 2;
    ground.receiveShadow = true;
    scene.add(ground);
    const road = new THREE.Mesh(new THREE.PlaneGeometry(16, 400), new THREE.MeshStandardMaterial({ color: 0x3a3d42, roughness: 0.9 }));
    road.rotation.x = -Math.PI / 2;
    road.position.set(-48, 0.02, 0);
    road.receiveShadow = true;
    scene.add(road);
    const line = new THREE.Mesh(new THREE.PlaneGeometry(0.25, 400), new THREE.MeshBasicMaterial({ color: 0xf5c542 }));
    line.rotation.x = -Math.PI / 2;
    line.position.set(-48, 0.03, 0);
    scene.add(line);

    this.camera = new THREE.PerspectiveCamera(40, 1, 0.5, 3000);
    this.camera.position.set(95, 85, 120);
    this.controls = new OrbitControls(this.camera, r.domElement);
    this.controls.target.set(0, 30, 0);
    this.controls.enableDamping = true;
    this.controls.maxPolarAngle = Math.PI * 0.49;
    this.controls.minDistance = 15;
    this.controls.maxDistance = 400;

    this.facadeTex = facadeTexture();
    this.raycaster = new THREE.Raycaster();
    this.tooltip = document.createElement('div');
    this.tooltip.className = 'tooltip3d';
    container.appendChild(this.tooltip);
    this.bindEvents();
    new ResizeObserver(() => this.resize()).observe(container);
    this.resize();
    this.rebuild();
    r.setAnimationLoop(() => {
      this.controls.update();
      r.render(scene, this.camera);
      this.labels.render(scene, this.camera);
    });
  }

  rebuild() {
    const b = this.getBuilding();
    if (this.root) {
      this.scene.remove(this.root);
      this.root.traverse((o) => { o.geometry?.dispose(); if (o.element?.parentNode) o.element.remove(); });
    }
    const root = (this.root = new THREE.Group());
    this.unitMeshes = [];
    const floors = residentialFloors(b.floors);
    this.floors = floors;
    const H = b.floorHeight, P = b.podiumHeight;
    const slabMat = new THREE.MeshStandardMaterial({ color: 0xf4f1ea, roughness: 0.6 });
    const coreMat = new THREE.MeshStandardMaterial({ color: 0x9aa0a8, roughness: 0.8 });
    const glassMat = new THREE.MeshStandardMaterial({ color: 0x2f4f6b, roughness: 0.08, metalness: 0.6 });
    const box = (r, y0, h, material, inset = 0) => {
      const m = new THREE.Mesh(new THREE.BoxGeometry(r.x1 - r.x0 - inset * 2, h, r.y1 - r.y0 - inset * 2), material);
      m.position.set((r.x0 + r.x1) / 2, y0 + h / 2, (r.y0 + r.y1) / 2);
      m.castShadow = true;
      m.receiveShadow = true;
      root.add(m);
      return m;
    };
    // Khối đế thương mại
    const pod = rectM(PODIUM);
    for (let i = 0; i < b.podiumFloors; i++) {
      box(pod, i * P, P - 0.4, glassMat, 0.4);
      box(pod, i * P + P - 0.4, 0.4, slabMat);
    }
    const base = b.podiumFloors * P;
    const visibleTop = Math.min(this.maxFloor, floors.length);
    const status = (fl, s) => b.units[`${fl}-${s.slot}`]?.status || 'available';
    floors.forEach((fl, fi) => {
      if (fi >= visibleTop) return;
      if (this.onlyFloor !== null && fi !== this.onlyFloor && fi > this.onlyFloor) return;
      const y = base + fi * H;
      const ghost = this.onlyFloor !== null && fi < this.onlyFloor;
      for (const c of CORES) box(rectM(c), y, H - 0.3, coreMat, 0.05).userData.core = true;
      for (const s of SLOT_LIST) {
        const st = status(fl, s);
        const passes = this.filter.status.has(st) && (!this.filter.type || this.filter.type === s.type);
        let material;
        if (this.colorBy === 'facade') material = new THREE.MeshStandardMaterial({ map: this.facadeTex, roughness: 0.6 });
        else {
          const col = this.colorBy === 'type' ? TYPE_COLORS[s.type] : STATUS[st].color;
          material = new THREE.MeshStandardMaterial({ color: col, roughness: 0.45, transparent: !passes || ghost, opacity: ghost ? 0.12 : passes ? 1 : 0.18 });
        }
        const m = box(s.rect, y, H - 0.3, material, 0.08);
        m.userData = { floor: fl, floorIndex: fi, slot: s, key: `${fl}-${s.slot}` };
        this.unitMeshes.push(m);
        if (fi === this.onlyFloor) {
          const el = document.createElement('div');
          el.className = 'unitlabel';
          el.innerHTML = `<b>${s.slot}</b><span>${s.type}</span>`;
          const lab = new CSS2DObject(el);
          lab.position.set((s.rect.x0 + s.rect.x1) / 2, y + H, (s.rect.y0 + s.rect.y1) / 2);
          root.add(lab);
        }
      }
      // Sàn tầng: viền trắng theo từng cánh (bỏ ở tầng đang xem riêng để nhìn thấy các căn)
      if (fi !== this.onlyFloor) for (const r of [rectM([440, 330, 820, 1140]), rectM([820, 630, 1290, 1100]), rectM([1290, 330, 1670, 1140])]) box(r, y + H - 0.3, 0.3, slabMat);
      // Nhãn tầng
      if (fi % 2 === 0 || fi === floors.length - 1) {
        const el = document.createElement('div');
        el.className = 'floorlabel';
        el.textContent = 'T' + fl.replace(/^0/, '');
        const lab = new CSS2DObject(el);
        lab.position.set(pod.x0 - 2.5, y + H / 2, pod.y1);
        root.add(lab);
      }
    });
    // Sân vườn mái
    if (visibleTop >= floors.length && this.onlyFloor === null) {
      const roofY = base + floors.length * H;
      const green = new THREE.MeshStandardMaterial({ color: 0x5c8f3a, roughness: 1 });
      const leaf = new THREE.MeshStandardMaterial({ color: 0x3f7d33, flatShading: true });
      for (const r of [rectM([450, 340, 810, 1130]), rectM([1300, 340, 1660, 1130])]) {
        box(r, roofY, 0.25, green);
        for (let i = 0; i < 8; i++) {
          const t = new THREE.Mesh(new THREE.IcosahedronGeometry(0.9 + (i % 3) * 0.3, 0), leaf);
          t.position.set(r.x0 + 1.5 + ((r.x1 - r.x0 - 3) * ((i * 37) % 100)) / 100, roofY + 1.1, r.y0 + 1.5 + ((r.y1 - r.y0 - 3) * ((i * 61) % 100)) / 100);
          t.castShadow = true;
          root.add(t);
        }
      }
    }
    this.scene.add(root);
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
