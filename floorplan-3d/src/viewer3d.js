// Trình xem 3D: trời & nắng theo giờ, bóng đổ mềm, AO, cắt tường kiểu nhà búp bê, đi bộ góc nhìn thứ nhất, mở cửa.
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { PointerLockControls } from 'three/examples/jsm/controls/PointerLockControls.js';
import { Sky } from 'three/examples/jsm/objects/Sky.js';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js';
import { GTAOPass } from 'three/examples/jsm/postprocessing/GTAOPass.js';
import { UnrealBloomPass } from 'three/examples/jsm/postprocessing/UnrealBloomPass.js';
import { OutputPass } from 'three/examples/jsm/postprocessing/OutputPass.js';
import { CSS2DRenderer } from 'three/examples/jsm/renderers/CSS2DRenderer.js';
import { GLTFExporter } from 'three/examples/jsm/exporters/GLTFExporter.js';
import { buildScene, disposeTree, SHARED, CUTAWAY } from './builder.js';
import { upgradeFurniture, loadInteriorHDRI } from './realistic.js';
import { resolvePalette, roomKind } from './styles.js';
import { adCaption } from './adcopy.js';
import { exportImage, drawAdCallouts, drawCallouts } from './snapshot.js';
import { getTexture } from './textures.js';
import { closestOnSegment, rotatePoint, labelPoint, polygonArea, pointInPolygon, pointInRotRect } from './geom.js';
import { CATALOG_MAP } from './furniture.js';

const easeOut = (t) => 1 - Math.pow(1 - t, 3);

export class Viewer3D {
  constructor(container, store) {
    this.container = container;
    this.store = store;
    this.state = { hour: 15, cut: 1, ao: true, labels: true, ceiling: true, lights: 'auto', autoRotate: false, landscape: true };
    this.clipPlane = new THREE.Plane(new THREE.Vector3(0, -1, 0), 100);
    this.mode = 'orbit';
    this.anim = null;
    this.keys = {};
    this.velocity = new THREE.Vector3();

    const r = (this.renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: false }));
    r.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    r.shadowMap.enabled = true;
    r.shadowMap.type = THREE.PCFShadowMap;
    r.toneMapping = THREE.ACESFilmicToneMapping;
    r.toneMappingExposure = 0.95;
    r.localClippingEnabled = true;
    container.appendChild(r.domElement);

    this.labelRenderer = new CSS2DRenderer();
    this.labelRenderer.domElement.className = 'labels-layer';
    container.appendChild(this.labelRenderer.domElement);

    const scene = (this.scene = new THREE.Scene());
    const pmrem = new THREE.PMREMGenerator(r);
    scene.environment = this._roomEnv = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environmentIntensity = 0.35;

    this.camera = new THREE.PerspectiveCamera(40, 1, 0.05, 500);
    this.camera.position.set(14, 14, 18);

    this.controls = new OrbitControls(this.camera, r.domElement);
    this.controls.enableDamping = true;
    this.controls.dampingFactor = 0.08;
    this.controls.maxPolarAngle = Math.PI * 0.495;
    this.controls.minDistance = 2;
    this.controls.maxDistance = 120;
    this.controls.autoRotateSpeed = 0.6;

    this.pointer = new PointerLockControls(this.camera, r.domElement);
    this.pointer.addEventListener('unlock', () => { if (this.mode === 'walk') this.onWalkUnlock?.(); });

    // Bầu trời + nắng
    this.sky = new Sky();
    this.sky.scale.setScalar(450);
    const u = this.sky.material.uniforms;
    u.turbidity.value = 6; u.rayleigh.value = 1.6; u.mieCoefficient.value = 0.004; u.mieDirectionalG.value = 0.85;
    scene.add(this.sky);
    this.sun = new THREE.DirectionalLight(0xfff2dd, 3);
    this.sun.castShadow = true;
    this.sun.shadow.mapSize.set(4096, 4096);
    this.sun.shadow.bias = -0.0004;
    this.sun.shadow.normalBias = 0.03;
    this.sun.shadow.radius = 4;
    scene.add(this.sun, this.sun.target);
    this.hemi = new THREE.HemisphereLight(0xcfe6ff, 0x6b7f4f, 0.8);
    scene.add(this.hemi);

    // Mặt đất cỏ
    const gt = getTexture('grass').clone();
    gt.needsUpdate = true;
    gt.repeat.set(160 / 2.5, 160 / 2.5);
    const ground = new THREE.Mesh(new THREE.PlaneGeometry(160, 160), new THREE.MeshStandardMaterial({ map: gt, roughness: 1 }));
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = -0.155;
    ground.receiveShadow = true;
    this.ground = ground;
    scene.add(ground);
    // Nền trắng kiểu ảnh phối cảnh trình bày: chỉ giữ bóng đổ mềm dưới chân căn hộ
    this.shadowCatcher = new THREE.Mesh(new THREE.PlaneGeometry(300, 300), new THREE.ShadowMaterial({ opacity: 0.16 }));
    this.shadowCatcher.rotation.x = -Math.PI / 2;
    this.shadowCatcher.position.y = -0.158;
    this.shadowCatcher.receiveShadow = true;
    scene.add(this.shadowCatcher);

    // Hậu kỳ
    this.composer = new EffectComposer(r);
    this.composer.addPass(new RenderPass(scene, this.camera));
    this.gtao = new GTAOPass(scene, this.camera, 1, 1);
    this.gtao.updateGtaoMaterial({ radius: 0.5, distanceExponent: 1.5, thickness: 1, scale: 1.2, samples: 16 });
    this.gtao.blendIntensity = 0.85;
    this.gtao.normalMaterial.clippingPlanes = [this.clipPlane];
    this.composer.addPass(this.gtao);
    this.bloom = new UnrealBloomPass(new THREE.Vector2(256, 256), 0.35, 0.5, 0.85);
    this.bloom.enabled = false;
    this.composer.addPass(this.bloom);
    this.composer.addPass(new OutputPass());

    this.raycaster = new THREE.Raycaster();
    this.mouse = new THREE.Vector2();
    this.tooltip = document.createElement('div');
    this.tooltip.className = 'tooltip3d';
    container.appendChild(this.tooltip);

    this.bindEvents();
    this.resize();
    new ResizeObserver(() => this.resize()).observe(container);
    this._last = performance.now();
    this.rebuild(false);
    this.frameAll(false);
    this.setHour(this.state.hour);
    this.setActive(true);
  }

  /** Dừng / chạy lại vòng vẽ (khi khung 3D bị ẩn thì không tốn GPU) */
  setActive(on) {
    if (on === this.active) return;
    this.active = on;
    this._last = performance.now();
    this.renderer.setAnimationLoop(on ? () => this.tick() : null);
  }

  // ---------------- Dựng cảnh ----------------
  rebuild(animate = false) {
    const prev = this.built;
    if (prev) {
      this.scene.remove(prev.root);
      disposeTree(prev.root);
    }
    const built = buildScene(this.store.plan, { clippingPlanes: [this.clipPlane], ceiling: this.state.ceiling, landscape: this.state.landscape, people: this.state.people, book: this.state.ad });
    // Giữ trạng thái đóng/mở cửa sau khi dựng lại
    if (prev) for (const d of built.doors) { const o = prev.doors.find((p) => p.op.id === d.op.id); if (o) { d.open = o.open; d.target = o.target; } }
    this.built = built;
    this.scene.add(built.root);
    this.shadowCatcher.position.y = this.state.ad ? -0.95 : -0.158;
    this._adList = null; this._plainList = null; this._adKey = null;
    if (this.state.ad) { this.addLeafShadows(built); this.adLabels(built); }
    this.applyExterior();
    this._above = undefined;
    if (this.ptActive) this.stopRealRender();
    built.labels.forEach((l) => (l.visible = this.state.labels));
    this._upgrading = this.state.realistic ? upgradeFurniture(built, [this.clipPlane], resolvePalette(this.store.plan.settings)) : null;
    this.fitShadow();
    this.applyLights();
    this.applyDoors(1);
    if (animate) this.playBuild();
    else this.updateClip();
  }

  fitShadow() {
    const b = this.built.bounds;
    const s = this.sun.shadow.camera;
    const half = b.size * 0.75 + 6;
    s.left = -half; s.right = half; s.top = half; s.bottom = -half;
    s.near = 0.5; s.far = 200;
    s.updateProjectionMatrix();
    this.sun.target.position.set(b.cx, 0, b.cy);
  }

  /** Hiệu ứng dựng nhà: tường mọc lên, đồ đạc rơi xuống đúng chỗ */
  playBuild() {
    this.anim = { t0: performance.now(), dur: 2200 };
    this.built.furniture.forEach((f, i) => { f.userData.delay = 0.45 + (i / Math.max(1, this.built.furniture.length)) * 0.45; f.visible = false; });
  }

  finishAnim() {
    this.anim = null;
    this.built.furniture.forEach((f) => { f.visible = true; f.position.y = 0; f.scale.setScalar(1); });
    this.updateClip();
  }

  updateClip(h) {
    const H = this.built?.height || 2.8;
    const full = this.state.cut >= 0.999 && this.mode !== 'cut';
    const y = h ?? (full ? 100 : 0.25 + this.state.cut * (H - 0.25));
    this.clipPlane.constant = y;
    // Trần chỉ hiện khi tường cao đủ
    this.built?.root.traverse((o) => { if (o.userData.ceiling) o.visible = this.state.ceiling && y >= H - 0.01; });
  }

  // ---------------- Ánh sáng theo giờ ----------------
  setHour(hour) {
    this.state.hour = hour;
    // Mặt trời mọc 6h, lặn 18h; quỹ đạo nghiêng về phía nam
    const dayT = (hour - 6) / 12;
    // (kiểu quảng cáo dùng giờ 8h sáng: nắng vàng xiên, bóng lá dài)
    const elev = Math.sin(Math.PI * dayT) * 62;
    const azim = 90 + dayT * 180;
    const phi = THREE.MathUtils.degToRad(90 - elev);
    const theta = THREE.MathUtils.degToRad(azim);
    const sunDir = new THREE.Vector3().setFromSphericalCoords(1, phi, theta);
    this.sky.material.uniforms.sunPosition.value.copy(sunDir);
    const b = this.built?.bounds || { cx: 0, cy: 0, size: 10 };
    const day = THREE.MathUtils.clamp(elev / 12, 0, 1);
    const night = hour < 6.3 || hour > 17.7;
    if (elev > 0) {
      this.sun.position.set(b.cx + sunDir.x * 60, sunDir.y * 60, b.cy + sunDir.z * 60);
      const warm = THREE.MathUtils.clamp(elev / 35, 0, 1);
      this.sun.color.setRGB(1, 0.72 + 0.26 * warm, 0.5 + 0.42 * warm);
      this.sun.intensity = 0.4 + 2.8 * day;
    } else {
      // Ánh trăng
      this.sun.position.set(b.cx - 30, 50, b.cy + 20);
      this.sun.color.setHex(0x9bb4ff);
      this.sun.intensity = 0.25;
    }
    this.hemi.intensity = 0.12 + 0.75 * day;
    this.hemi.color.setHex(day > 0.2 ? 0xcfe6ff : 0x34407a);
    this.scene.environmentIntensity = (this.hdriEnv && this.state.realistic ? 0.55 : 0.3) * day + 0.06;
    this.renderer.toneMappingExposure = night ? 1.05 : 0.95;
    this.sky.material.uniforms.rayleigh.value = night ? 0.15 : 1.6;
    this.sky.visible = true;
    this.scene.background = night ? new THREE.Color(0x0b1026) : null;
    this.sky.visible = !night;
    if (this.panoActive && this.extTex) {
      this.scene.background = this.extTex;
      this.scene.backgroundIntensity = night ? 0.18 : 1;
      this.sky.visible = false;
    } else this.scene.backgroundIntensity = 1;
    // Nền trắng (tắt cảnh quan): không trời, không cỏ, chỉ bóng đổ
    const studio = this.isStudio();
    this.ground.visible = !studio && !((this.exterior?.floor || 1) > 1);
    this.shadowCatcher.visible = studio;
    if (studio) {
      this.sky.visible = false;
      this.scene.background = new THREE.Color(night ? 0x1c2230 : this.state.ad ? 0xf2eee7 : 0xdcdcdc);
      this.hemi.groundColor.setHex(0xe8e6e1);
    } else this.hemi.groundColor.setHex(0x6b7f4f);
    this.isNight = night;
    this.applyLights();
  }

  /** Bật/tắt chế độ như thật: nội thất mô hình thật + HDRI */
  setRealistic(on) {
    this.state.realistic = on;
    if (on) {
      loadInteriorHDRI(this.renderer).then(({ env, equirect }) => {
        this.hdriEnv = env;
        this.hdriEquirect = equirect;
        if (this.state.realistic) { this.scene.environment = env; this.setHour(this.state.hour); }
      }).catch((e) => console.warn('HDRI', e));
    } else if (this._roomEnv) this.scene.environment = this._roomEnv;
    this.rebuild();
  }

  /** Kiểu quảng cáo: tán lá vô hình phía trên chỉ để đổ bóng lá lốm đốm lên sàn khi nắng xiên */
  addLeafShadows(built) {
    if (!this._leafTex) {
      const c = document.createElement('canvas'); c.width = c.height = 512;
      const x = c.getContext('2d');
      let seed = 7; const r = () => ((seed = (seed * 16807) % 2147483647) / 2147483647);
      x.fillStyle = '#fff';
      for (let i = 0; i < 70; i++) {
        const cx = r() * 512, cy = r() * 512, a = r() * Math.PI, l = 26 + r() * 40, w = l * 0.38;
        x.save(); x.translate(cx, cy); x.rotate(a); x.beginPath(); x.ellipse(0, 0, l, w, 0, 0, Math.PI * 2); x.fill();
        x.fillRect(-l * 1.6, -1.5, l * 0.7, 3); x.restore();
      }
      this._leafTex = new THREE.CanvasTexture(c);
    }
    const b = built.bounds, size = b.size * 1.6;
    const mat = new THREE.MeshBasicMaterial({ alphaMap: this._leafTex, alphaTest: 0.5, side: THREE.DoubleSide, colorWrite: false, depthWrite: false });
    const mesh = new THREE.Mesh(new THREE.PlaneGeometry(size, size), mat);
    mesh.customDepthMaterial = new THREE.MeshDepthMaterial({ depthPacking: THREE.RGBADepthPacking, alphaMap: this._leafTex, alphaTest: 0.5 });
    mesh.rotation.x = -Math.PI / 2;
    // đặt lệch về phía mặt trời buổi sáng (phía đông) để bóng lá rơi chéo vào một góc căn
    mesh.position.set(b.maxX + 1.5, 4.2, b.minY + b.size * 0.15);
    mesh.castShadow = true;
    mesh.userData.noExport = true;
    mesh.userData.leafGobo = true;
    built.root.add(mesh);
  }

  /** Kiểu quảng cáo: nhãn phòng thành câu cảm xúc (tiêu đề chữ nghiêng + một câu lợi ích) */
  adLabels(built) {
    const seen = {};
    built.labels.forEach((l) => {
      const name = l.userData.roomName;
      if (!name) return;
      const t = adCaption(name, (seen[roomKind(name)] = (seen[roomKind(name)] || 0) + 1));
      // một câu chỉ hiện một lần (vd. sân vườn 2 dải); nhãn gọn để không che mặt bằng
      l.element.className = 'label3d adhide'; // kiểu quảng cáo: chú thích vẽ ra ngoài mép khung (adOverlay)
      return;
      seen['t:' + t.title] = 1;
      l.element.className = 'label3d adlabel';
      l.element.innerHTML = `<i>${t.icon}</i><b>${t.title}</b><span>${t.line}</span>`;
    });
  }

  /** Danh sách chú thích phòng (tên, diện tích, dài × rộng; kiểu quảng cáo: câu cảm xúc, bỏ câu trùng) */
  calloutList(ad) {
    return this.store.plan.rooms.filter((r) => r.points.length >= 3).map((r, i, arr) => {
      const xs = r.points.map((p) => p.x), ys = r.points.map((p) => p.y);
      const lp = labelPoint(r.points);
      const base = { name: r.name, area: polygonArea(r.points), w: Math.max(...xs) - Math.min(...xs), d: Math.max(...ys) - Math.min(...ys), anchor: { x: lp.x, y: 0.1, z: lp.y } };
      if (!ad) return base;
      const nth = arr.slice(0, i + 1).filter((q) => roomKind(q.name) === roomKind(r.name)).length;
      const t = adCaption(r.name, nth);
      return { ...base, name: t.title, sub: t.line, icon: t.icon };
    }).filter((c, i, arr) => !ad || arr.findIndex((d) => d.name === c.name) === i);
  }

  /** Kiểu quảng cáo trên màn hình: chú thích đặt ra hai mép khung, mũi tên cong chỉ vào phòng */
  adOverlay() {
    let cv = this._adCanvas;
    // Nhãn tên phòng thường (khi bật 🏷 Tên phòng, nhìn từ ngoài): cũng đưa ra mép khung, có đường dẫn
    const above = this.built && this.camera.position.y > this.built.height;
    const plain = !this.state.ad && this.state.labels && above;
    if (this.built && !this.tour && this.mode !== 'walk') this.built.labels.forEach((l) => { if (l.element) l.element.style.visibility = (plain || this.state.ad) ? 'hidden' : ''; });
    const on = (this.state.ad || plain) && this.mode !== 'walk' && !this.tour && !this.ptActive;
    if (!on) { if (cv) cv.style.display = 'none'; return; }
    if (!cv) {
      cv = this._adCanvas = document.createElement('canvas');
      Object.assign(cv.style, { position: 'absolute', inset: '0', width: '100%', height: '100%', pointerEvents: 'none', zIndex: 2 });
      this.container.appendChild(cv);
    }
    cv.style.display = '';
    const dpr = Math.min(window.devicePixelRatio || 1, 2), W = this.container.clientWidth, H = this.container.clientHeight;
    if (cv.width !== Math.round(W * dpr) || cv.height !== Math.round(H * dpr)) { cv.width = Math.round(W * dpr); cv.height = Math.round(H * dpr); }
    const key = this.camera.matrixWorld.elements.join(',') + W + 'x' + H + (plain ? 'p' : 'a');
    if (key === this._adKey) return;
    this._adKey = key;
    const x = cv.getContext('2d');
    x.setTransform(1, 0, 0, 1, 0, 0);
    x.clearRect(0, 0, cv.width, cv.height);
    const v = new THREE.Vector3();
    const toScreen = (p) => { v.set(p.x, p.y, p.z).project(this.camera); return { x: (v.x * 0.5 + 0.5) * cv.width, y: (-v.y * 0.5 + 0.5) * cv.height }; };
    const s = dpr * Math.min(1, Math.max(0.62, W / 1100));
    if (plain) {
      const b = this.built.bounds;
      const plan = { w: b.maxX - b.minX, d: b.maxY - b.minY, corners: [[b.minX, b.minY], [b.maxX, b.minY], [b.maxX, b.maxY], [b.minX, b.maxY]].map(([px, pz]) => ({ x: px, y: 0, z: pz })) };
      drawCallouts(x, this._plainList ||= this.calloutList(false), plan, toScreen, s * 1.25, cv.width, cv.height, 0, true);
    } else drawAdCallouts(x, this._adList ||= this.calloutList(true), toScreen, s, cv.width, cv.height, 0);
  }

  isStudio() { return !this.state.landscape && !this.panoActive; }

  applyLights() {
    if (!this.built) return;
    const on = this.state.lights === 'on' || (this.state.lights === 'auto' && this.isNight);
    this.built.roomLights.forEach((l) => (l.intensity = on ? 6 : 0));
    this.built.lampLights.forEach((l) => (l.intensity = on ? 2.5 : 0));
    SHARED.lampMat.emissiveIntensity = on ? 2.5 : 0;
    SHARED.glassMat.emissiveIntensity = on ? 0.25 : 0;
    this.built.lampShades.forEach((s) => (s.material.emissiveIntensity = on ? 1.4 : 0));
    this.bloom.enabled = on && this.isNight;
  }

  setOption(key, value) {
    this.state[key] = value;
    if (key === 'cut') this.updateClip();
    if (key === 'labels') this.built.labels.forEach((l) => (l.visible = value));
    if (key === 'ceiling' || key === 'landscape' || key === 'people') { this.rebuild(); this.setHour(this.state.hour); }
    if (key === 'lights') this.applyLights();
    if (key === 'ao') this.gtao.enabled = value;
    if (key === 'autoRotate') this.controls.autoRotate = value;
  }

  // ---------------- View ngoài trời (ảnh 360° / ảnh thường) ----------------
  /** ext = { src, kind: 'pano'|'photo', heading (độ), floor (tầng), fov (độ, ảnh thường) } */
  setExterior(ext) {
    this.exterior = ext;
    if (!ext?.src) { this.extTex = null; this.applyExterior(); return; }
    new THREE.TextureLoader().load(ext.src, (t) => {
      t.colorSpace = THREE.SRGBColorSpace;
      this.extTex?.dispose();
      this.extTex = t;
      this.applyExterior();
    });
  }

  applyExterior() {
    const ext = this.exterior;
    const high = (ext?.floor || 1) > 1;
    // Ở trên cao thì không thấy sân cỏ, cây quanh nhà
    this.ground.visible = !high && !this.isStudio();
    this.built?.root.traverse((o) => { if (o.userData.landscape) o.visible = !high; });
    if (this.photoMesh) { this.scene.remove(this.photoMesh); this.photoMesh.geometry.dispose(); this.photoMesh = null; }
    this.scene.backgroundRotation.set(0, 0, 0);
    if (!ext?.src || !this.extTex) { this.panoActive = false; this.setHour(this.state.hour); return; }
    const b = this.built?.bounds || { cx: 0, cy: 0, size: 10 };
    const heading = THREE.MathUtils.degToRad(ext.heading || 0);
    const yBase = -0.15;
    if (ext.kind === 'pano') {
      this.extTex.mapping = THREE.EquirectangularReflectionMapping;
      this.extTex.needsUpdate = true;
      this.panoActive = true;
      this.scene.backgroundRotation.set(0, heading, 0);
    } else {
      this.panoActive = false;
      // Ảnh thường: dán lên cung trụ lớn quanh căn hộ, hướng theo "heading"
      const R = Math.max(40, b.size * 4);
      const arc = THREE.MathUtils.degToRad(ext.fov || 110);
      const img = this.extTex.image;
      const hgt = R * arc * (img.height / img.width);
      const geo = new THREE.CylinderGeometry(R, R, hgt, 64, 1, true, Math.PI - arc / 2 + heading, arc);
      this.extTex.wrapS = THREE.RepeatWrapping;
      this.extTex.repeat.x = -1;
      this.extTex.needsUpdate = true;
      const m = new THREE.Mesh(geo, new THREE.MeshBasicMaterial({ map: this.extTex, side: THREE.BackSide, fog: false }));
      m.position.set(b.cx, yBase + hgt * 0.42, b.cy);
      m.userData.extPhoto = true;
      this.photoMesh = m;
      this.scene.add(m);
    }
    this.setHour(this.state.hour);
  }

  // ---------------- Render chân thực (path tracing) ----------------
  async startRealRender() {
    if (!this.built) return;
    // Bộ path tracing khá nặng nên chỉ tải khi người dùng bấm "Render ảnh thật"
    const { WebGLPathTracer, GradientEquirectTexture } = (this._ptLib ||= await import('three-gpu-pathtracer'));
    if (this.anim) this.finishAnim();
    this.fly = null;
    this.built.doors.forEach((d) => (d.open = d.target));
    this.applyDoors(1);
    if (!this.pt) {
      this.pt = new WebGLPathTracer(this.renderer);
      // Nhanh hơn: vẽ trọn khung mỗi lượt, ít lần nảy sáng hơn, độ phân giải render thấp hơn trên điện thoại
      this.pt.tiles.set(1, 1);
      this.pt.bounces = 3;
      this.pt.transmissiveBounces = 3;
      this.pt.renderScale = matchMedia('(max-width: 900px)').matches ? 0.5 : 0.75;
      this.pt.filterGlossyFactor = 0.5;
      this.pt.minSamples = 1;
      this.pt.fadeDuration = 400;
      this.pt.renderDelay = 0;
    }
    this._ptSaved = { cut: this.state.cut, labels: this.state.labels };
    this.state.cut = 1;
    this.updateClip();
    this.built.labels.forEach((l) => (l.visible = false));
    // Ẩn những thứ path tracer không hỗ trợ: shader bầu trời, mặt cắt dựng bằng mặt sau
    this.sky.visible = false;
    const above = this.camera.position.y > this.built.height;
    this.built.root.traverse((o) => {
      if (o.userData.capBack) o.visible = false;
      if (o.userData.ceiling) o.visible = !above && this.state.ceiling;
    });
    if (!this.panoActive) {
      const grad = (this._grad ||= new GradientEquirectTexture(512));
      const night = this.isNight;
      grad.topColor.set(night ? 0x0b1026 : 0x7fb0e6);
      grad.bottomColor.set(night ? 0x05070f : 0xd8dde3);
      grad.update();
      this._ptBg = { bg: this.scene.background, env: this.scene.environment };
      // Nền trắng: nền sáng trơn; ánh sáng môi trường dùng HDRI phòng nếu có
      if (this.isStudio()) { grad.topColor.set(night ? 0x1c2230 : 0xdcdcdc); grad.bottomColor.set(night ? 0x1c2230 : 0xd4d4d4); grad.update(); }
      this.scene.background = grad;
      // Nhìn từ trên: HDRI trong nhà có "trời" là trần tối → dùng trời sáng để sàn, nội thất đủ sáng
      if (above) { grad.topColor.set(night ? 0x2a3040 : 0xffffff); grad.bottomColor.set(night ? 0x1c2230 : this.state.ad ? 0xf2eee7 : 0xdcdcdc); grad.update(); this._ptEnvI = this.scene.environmentIntensity; this.scene.environmentIntensity = night ? 0.6 : 2.4; }
      this.scene.environment = this.state.realistic && this.hdriEquirect && !above ? this.hdriEquirect : grad;
    } else {
      this._ptBg = { bg: this.scene.background, env: this.scene.environment };
      this.scene.environment = this.extTex;
    }
    this._ptCatcher = this.shadowCatcher.visible;
    this.shadowCatcher.visible = false;
    // Bộ path tracing không hỗ trợ mặt phẳng cắt: nhìn từ trên thì hạ tường xuống đúng cao độ mặt cắt,
    // bỏ vật nằm trên mặt cắt (đèn trần, LED hắt, thanh rèm) để ánh sáng trời lọt vào phòng như ảnh phối cảnh
    this._ptScaled = [];
    const cutY = this._ptSaved.cut < 0.999 ? 0.25 + this._ptSaved.cut * (this.built.height - 0.25) : null;
    // Kiểu quảng cáo giữ nắng sáng xiên (bóng dài, ấm); tán lá giả chỉ dùng cho bóng thường → bỏ khi render như thật
    if (this.state.ad) this.built.root.traverse((o) => { if (o.userData.leafGobo && o.visible) { o.visible = false; o.userData.ptHidden = true; } });
    if (above && !this.isNight && !this.state.ad) {
      // Nắng gần đỉnh đầu (lệch nhẹ) để trong phòng không bị tường che tối; tắt lại sẽ trả về theo giờ
      const t = this.sun.target.position, d = this.sun.position.distanceTo(t);
      this.sun.position.copy(t).add(new THREE.Vector3(0.28, 1, 0.38).normalize().multiplyScalar(d));
    }
    if (above && cutY) {
      const k = cutY / this.built.height;
      this.built.root.traverse((o) => {
        if (o.name === 'Tường' || o.name === 'Đỉnh tường') { this._ptScaled.push([o, o.scale.y]); o.scale.y *= k; }
      });
      const box = new THREE.Box3();
      this.built.root.traverse((o) => {
        if (!o.isMesh || o.name === 'Tường' || o.name === 'Đỉnh tường') return;
        if (o.visible && (o.name === 'LED hắt' || o.userData.lampDisc || box.setFromObject(o).min.y > cutY - 0.05)) { o.visible = false; o.userData.ptHidden = true; }
      });
    }
    // Bộ path tracing vẫn vẽ cả vật đang ẩn (trần, mặt cắt, khối đồ giản lược đã thay bằng mô hình thật…)
    // → tạm gỡ hẳn khỏi cảnh, gắn lại khi tắt
    this._ptDetached = [];
    const hidden = [];
    this.scene.traverse((o) => { if (o !== this.scene && !o.visible && o.parent) hidden.push(o); });
    hidden.forEach((o) => { this._ptDetached.push([o, o.parent]); o.parent.remove(o); });
    // Mặt cắt dollhouse cho ảnh siêu thật: bộ dò tia không chạy shader cắt tường → hạ thẳng đỉnh tường
    // (tường bao phía gần camera + vách trong) xuống cao độ cắt trên bản sao hình khối, trả lại khi tắt
    this._ptWallGeo = [];
    if (this.state.cutaway !== false && this._ptSaved.cut < 0.999 && this.mode !== 'walk') {
      const d = this.controls.target.clone().sub(this.camera.position), hz = Math.hypot(d.x, d.z) || 1, dx = d.x / hz, dz = d.z / hz, low = CUTAWAY.low.value;
      this.built.root.traverse((o) => {
        if (!o.isMesh || !(o.name === 'Tường' || o.name === 'Đỉnh tường') || !o.geometry.attributes.aFace) return;
        const g = o.geometry.clone(), pos = g.attributes.position, f = g.attributes.aFace;
        for (let i = 0; i < pos.count; i++) {
          const inner = f.getZ(i) > 1.5, outer = f.getZ(i) > 0.5 && f.getX(i) * dx + f.getY(i) * dz < -0.2;
          if ((inner || outer) && pos.getY(i) > low) pos.setY(i, o.name === 'Đỉnh tường' ? low + 0.006 : low);
        }
        pos.needsUpdate = true; g.computeBoundingBox(); g.computeBoundingSphere();
        this._ptWallGeo.push([o, o.geometry]); o.geometry = g;
      });
      for (const ob of this.built.cutObjs || []) {
        const f = ob.userData.cutFace;
        if (ob.parent && (f.inner || f.x * dx + f.z * dz < -0.2)) { this._ptDetached.push([ob, ob.parent]); ob.parent.remove(ob); }
      }
    }
    this.ptActive = true;
    this._ptDone = false;
    // đủ mịn thì dừng render (đỡ nóng máy), báo trang hiện nút tải
    const q = +new URLSearchParams(location.search).get('pt'); // ?pt=N: đổi số lượt làm mịn (thử nghiệm)
    this.ptTarget = q > 0 ? q : matchMedia('(max-width: 900px)').matches ? 32 : 48;
    this.pt.setScene(this.scene, this.camera);
    this._ptCam = this.camera.matrixWorld.clone();
  }

  stopRealRender() {
    if (!this.ptActive) return;
    this.ptActive = false;
    (this._ptDetached || []).forEach(([o, parent]) => { parent.add(o); if (o.userData.ptHidden) { o.visible = true; delete o.userData.ptHidden; } });
    this._ptDetached = null;
    (this._ptScaled || []).forEach(([o, sy]) => (o.scale.y = sy));
    (this._ptWallGeo || []).forEach(([o, geo]) => { o.geometry.dispose(); o.geometry = geo; });
    this._ptWallGeo = null;
    this._ptScaled = null;
    if (this._ptBg) { this.scene.background = this._ptBg.bg; this.scene.environment = this._ptBg.env; }
    if (this._ptEnvI != null) { this.scene.environmentIntensity = this._ptEnvI; this._ptEnvI = null; }
    if (this._ptCatcher) this.shadowCatcher.visible = true;
    this.built.root.traverse((o) => { if (o.userData.capBack) o.visible = true; });
    this.state.cut = this._ptSaved?.cut ?? 1;
    this.built.labels.forEach((l) => (l.visible = this._ptSaved?.labels ?? true));
    this.setHour(this.state.hour);
    this.updateClip();
    this.onPTStop?.();
  }

  // ---------------- 4D: tham quan tự động ----------------
  /** Vị trí camera trong phòng: góc phòng ít đồ đạc nhất, nhìn về phía tâm phòng */
  roomShot(room) {
    const pts = room.points;
    const lp = labelPoint(pts);
    const furn = this.store.plan.furniture.filter((f) => f.type !== 'rug');
    const size = (f) => ({ w: f.w ?? CATALOG_MAP[f.type]?.w ?? 1, d: f.d ?? CATALOG_MAP[f.type]?.d ?? 1, h: f.h ?? CATALOG_MAP[f.type]?.h ?? 1 });
    const blocked = (p, margin, tallOnly) => furn.some((f) => { const z = size(f); return (!tallOnly || z.h > 1.2) && pointInRotRect(p, f.x, f.y, z.w + margin, z.d + margin, f.rot || 0); });
    const xs = pts.map((p) => p.x), ys = pts.map((p) => p.y);
    const edgeDist = (p) => Math.min(...pts.map((q, i) => closestOnSegment(p, q, pts[(i + 1) % pts.length]).d));
    let best = null, bestScore = -Infinity;
    // Dò lưới điểm trong phòng: chỗ đứng xa tâm phòng, cách tường, không vướng đồ và nhìn thoáng về tâm phòng
    for (let x = Math.min(...xs) + 0.3; x < Math.max(...xs); x += 0.3)
      for (let y = Math.min(...ys) + 0.3; y < Math.max(...ys); y += 0.3) {
        const p = { x, y };
        if (!pointInPolygon(p, pts) || edgeDist(p) < 0.35 || blocked(p, 0.45, false)) continue;
        // Tránh đứng sát chỗ có người ngồi (ghế, sofa) để người không che khung hình
        if (furn.some((f) => ['chair', 'sofa', 'armchair', 'officeChair'].includes(f.type) && Math.hypot(f.x - p.x, f.y - p.y) < 1.3)) continue;
        const dx = lp.x - p.x, dy = lp.y - p.y, L = Math.hypot(dx, dy) || 1;
        let clear = 0;
        for (let i = 1; i <= 14; i++) {
          const q = { x: p.x + (dx / L) * i * 0.3, y: p.y + (dy / L) * i * 0.3 };
          if (blocked(q, 0.15, true)) break;
          clear++;
        }
        const score = clear + Math.min(L, 4) * 1.5;
        if (score > bestScore) { bestScore = score; best = p; }
      }
    best ||= lp;
    const dx = lp.x - best.x, dy = lp.y - best.y;
    const L = Math.hypot(dx, dy) || 1;
    return {
      pos: new THREE.Vector3(best.x, 1.5, best.y),
      target: new THREE.Vector3(best.x + (dx / L) * 4, 1.1, best.y + (dy / L) * 4),
    };
  }

  // ---------------- Video dọc 9:16 kiểu TikTok: cầm máy đi ở tầm mắt, mở cửa bước vào, lướt qua từng phòng ----------------
  /** Lộ trình camera: ngoài cửa chính → vào phòng khách (lia chậm) → qua cửa từng phòng → quay lại phòng khách */
  videoPath() {
    const plan = this.store.plan;
    const area = (r) => polygonArea(r.points);
    const OUT = /lô gia|ban công|sân vườn/i, WET = /wc|tắm|vệ sinh/i;
    const rooms = plan.rooms.filter((r) => r.points.length >= 3);
    const living = rooms.filter((r) => !OUT.test(r.name) && !WET.test(r.name)).sort((a, b) => area(b) - area(a))[0] || rooms[0];
    const xs = plan.walls.flatMap((w) => [w.a.x, w.b.x]), ys = plan.walls.flatMap((w) => [w.a.y, w.b.y]);
    const bb = { x0: Math.min(...xs), x1: Math.max(...xs), y0: Math.min(...ys), y1: Math.max(...ys) };
    const cx = (bb.x0 + bb.x1) / 2, cy = (bb.y0 + bb.y1) / 2;
    const at = (o) => { const w = plan.walls.find((x) => x.id === o.wallId); return w && { x: w.a.x + (w.b.x - w.a.x) * o.t, y: w.a.y + (w.b.y - w.a.y) * o.t, w }; };
    const edge = (p) => Math.min(p.x - bb.x0, bb.x1 - p.x, p.y - bb.y0, bb.y1 - p.y);
    // cửa chính: cửa đi rộng nhất trên vỏ ngoài căn
    let ent = null;
    for (const o of plan.openings) { if (o.type !== 'door') continue; const p = at(o); if (p && edge(p) < 0.45 && (!ent || o.width > ent.o.width)) ent = { o, p }; }
    const V = (x, y, h = 1.5) => new THREE.Vector3(x, h, y);
    const inwardOf = (p) => {
      const w = p.w, L = Math.hypot(w.b.x - w.a.x, w.b.y - w.a.y) || 1;
      let nx = -(w.b.y - w.a.y) / L, ny = (w.b.x - w.a.x) / L;
      if (nx * (cx - p.x) + ny * (cy - p.y) < 0) { nx = -nx; ny = -ny; }
      return { nx, ny };
    };
    const segs = [];
    const lc = labelPoint(living.points);
    const fmtA = (r) => `${r.name} · ${area(r).toFixed(1).replace('.', ',')} m²`;
    if (ent) {
      const { nx, ny } = inwardOf(ent.p);
      const out = V(ent.p.x - nx * 1.6, ent.p.y - ny * 1.6), inn = V(ent.p.x + nx * 1.1, ent.p.y + ny * 1.1);
      segs.push({ hold: 1.6, pos: out, look: V(ent.p.x + nx * 3, ent.p.y + ny * 3, 1.35), caption: 'Mở cửa căn hộ', door: true });
      segs.push({ move: [out, inn, V(lc.x, lc.y)], dur: 3.2, caption: fmtA(living) });
    } else segs.push({ move: [V(lc.x, lc.y), V(lc.x, lc.y)], dur: 0.5, caption: fmtA(living) });
    const ls = this.roomShot(living);
    segs.push({ hold: 3.2, pos: ls.pos, look: ls.target, pan: 40, caption: fmtA(living) });
    // các phòng còn lại: phòng ngủ trước, rồi lô gia / sân vườn; bỏ WC cho video gọn
    const others = rooms.filter((r) => r !== living && !WET.test(r.name) && area(r) > 2.5 && (!OUT.test(r.name) || /sân vườn/i.test(r.name)))
      .sort((a, b) => (OUT.test(a.name) ? 1 : 0) - (OUT.test(b.name) ? 1 : 0) || area(b) - area(a));
    let cur = ls.pos, exit = []; // ra khỏi phòng trước bằng đúng cửa đã vào (không đi xuyên tường)
    for (const r of others) {
      // cửa nối phòng này (gần nhất với phòng khách)
      let best = null;
      for (const o of plan.openings) {
        if (o.type === 'window' && !o.gap) continue;
        const p = at(o); if (!p) continue;
        const d = Math.min(...r.points.map((q, i) => closestOnSegment(p, q, r.points[(i + 1) % r.points.length]).d));
        if (d > 0.35) continue;
        const dl = Math.min(...living.points.map((q, i) => closestOnSegment(p, q, living.points[(i + 1) % living.points.length]).d));
        if (!best || dl < best.dl) best = { p, dl };
      }
      // video: đứng giữa phòng (xa tường, rèm), nhìn từ phía cửa vào sâu trong phòng → không dí sát rèm / tường gây chớp sáng
      const rc0 = labelPoint(r.points);
      const sh = { pos: V(rc0.x, rc0.y), target: null, center: V(rc0.x, rc0.y, 1.2) };
      const pts = [cur, ...exit];
      let door = [];
      if (best) {
        const w = best.p.w, L = Math.hypot(w.b.x - w.a.x, w.b.y - w.a.y) || 1, nx = -(w.b.y - w.a.y) / L, ny = (w.b.x - w.a.x) / L;
        const rc = labelPoint(r.points), sg = Math.sign(nx * (rc.x - best.p.x) + ny * (rc.y - best.p.y)) || 1;
        door = [V(best.p.x - sg * nx * 0.7, best.p.y - sg * ny * 0.7), V(best.p.x + sg * nx * 0.7, best.p.y + sg * ny * 0.7)];
        pts.push(...door);
      }
      // hướng ngắm: từ cửa nhìn qua tâm phòng (lùi tâm về phía cửa 0,4 m cho rộng khung)
      const inDir = best ? sh.pos.clone().sub(door[1]).setY(0) : new THREE.Vector3(0, 0, -1);
      if (inDir.lengthSq() > 0.04) { const n = inDir.clone().normalize(); sh.pos.addScaledVector(n, -Math.min(0.4, inDir.length() * 0.3)); sh.target = sh.pos.clone().addScaledVector(n, 3).setY(1.1); }
      else sh.target = sh.pos.clone().add(new THREE.Vector3(0, 0, -3)).setY(1.1);
      pts.push(sh.pos);
      segs.push({ move: pts, dur: Math.max(2.2, pts.reduce((a, p, i) => a + (i ? p.distanceTo(pts[i - 1]) : 0), 0) / 1.1), caption: fmtA(r), center: sh.center });
      segs.push({ hold: 2.6, pos: sh.pos, look: sh.target, pan: 30, caption: fmtA(r) });
      cur = sh.pos;
      exit = door.slice().reverse();
    }
    // kết: quay ra giữa phòng khách nhìn toàn không gian
    if (others.length) segs.push({ move: [cur, ...exit, V(lc.x, lc.y)], dur: 3, caption: fmtA(living), center: ls.target });
    segs.push({ hold: 1, pos: V(lc.x, lc.y), look: ls.target, caption: fmtA(living) });
    // Đi liền một mạch (không dừng): gom mọi điểm thành một đường cong, tốc độ đều; hướng nhìn nội suy giữa các điểm
    const way = [];
    const push = (p, look, caption) => { const last = way[way.length - 1]; if (last && last.p.distanceTo(p) < 0.25) { last.look = look || last.look; last.caption = caption || last.caption; return; } way.push({ p, look, caption }); };
    for (const g of segs) {
      // điểm trên đường đi nhìn về tâm phòng sắp vào (ổn định, không dí sát tường / tủ)
      if (g.move) g.move.forEach((p, k) => push(p, k === 0 ? null : g.center || null, g.caption));
      else { push(g.pos, g.look, g.caption); way[way.length - 1].shot = true; }
    }
    // điểm không có hướng nhìn riêng (cửa, lối đi): nhìn về điểm kế tiếp
    way.forEach((w, k) => {
      if (w.look) return;
      const nx = way.slice(k + 1).find((q) => q.p.distanceTo(w.p) > 0.3) || way[k - 1];
      const d = nx.p.clone().sub(w.p).setY(0); if (d.lengthSq() < 1e-4) d.set(0, 0, -1);
      w.look = w.p.clone().add(d.normalize().multiplyScalar(3)).setY(1.3);
    });
    // cảnh mở đầu đứng ngoài cửa giữ hướng nhìn vào nhà
    if (ent && way[1]) way[0].look = way[1].p.clone().add(way[1].p.clone().sub(way[0].p).setY(0).normalize().multiplyScalar(3)).setY(1.35);
    // đường gấp khúc bo góc nhỏ (không vồng ra như spline → không xuyên tường khi đi qua cửa)
    const curve = new THREE.CurvePath();
    {
      const P = way.map((w) => w.p);
      let start = P[0].clone();
      for (let k = 1; k < P.length; k++) {
        const a0 = P[k - 1], a1 = P[k], a2 = P[k + 1];
        if (!a2) { curve.add(new THREE.LineCurve3(start, a1.clone())); break; }
        const r = Math.min(1.1, a0.distanceTo(a1) / 2, a1.distanceTo(a2) / 2);
        const pIn = a1.clone().add(a0.clone().sub(a1).setLength(r)), pOut = a1.clone().add(a2.clone().sub(a1).setLength(r));
        if (start.distanceTo(pIn) > 1e-3) curve.add(new THREE.LineCurve3(start, pIn));
        curve.add(new THREE.QuadraticBezierCurve3(pIn, a1.clone(), pOut));
        start = pOut;
      }
    }
    const len = curve.getLength();
    // tốc độ đều, video ~20–28 giây
    const DUR = Math.min(28, Math.max(18, len / 0.75)), intro = ent ? 1.2 : 0;
    // bảng tra độ dài cung → tham số knot (để biết đang ở giữa 2 điểm nào)
    // vị trí từng điểm mốc theo độ dài đường đi → biết đang ở giữa 2 mốc nào để nội suy hướng nhìn
    const cum = [0]; for (let k = 1; k < way.length; k++) cum.push(cum[k - 1] + way[k].p.distanceTo(way[k - 1].p));
    const knotAt = (u) => { const d = u * cum[cum.length - 1]; let k = 0; while (k < cum.length - 2 && cum[k + 1] < d) k++; return k + Math.min(1, (d - cum[k]) / Math.max(1e-6, cum[k + 1] - cum[k])); };
    const ease = (x) => x * x * (3 - 2 * x);
    // hướng nhìn thô (theo hướng đi, gần điểm ngắm thì xoay về hướng ngắm) – chỉ lấy góc ngang (yaw)
    const posAt = (time) => curve.getPointAt(Math.min(1, Math.max(0, (time - intro) / DUR)));
    const rawDir = (time) => {
      const u = Math.min(1, Math.max(0, (time - intro) / DUR));
      if (time < intro) return way[0].look.clone().sub(way[0].p).setY(0).normalize();
      const pos = curve.getPointAt(u), ahead = curve.getPointAt(Math.min(1, u + 2 / len));
      let fwd = ahead.sub(pos).setY(0);
      if (fwd.lengthSq() < 1e-4) fwd = way[way.length - 1].look.clone().sub(pos).setY(0);
      fwd.normalize();
      const d = u * cum[cum.length - 1];
      let wgt = 0, best = null;
      way.forEach((w, k) => { if (!w.shot) return; const ww = 1 - Math.min(1, Math.abs(cum[k] - d) / 1.8); if (ww > wgt) { wgt = ww; best = w; } });
      if (best) fwd.lerp(best.look.clone().sub(best.p).setY(0).normalize(), ease(wgt));
      return fwd.lengthSq() > 1e-6 ? fwd.normalize() : new THREE.Vector3(0, 0, -1);
    };
    // làm mượt hướng nhìn: trung bình có trọng số trong ±0,7 s → quay đầu êm, không giật, không chúi xuống sàn
    const smoothDir = (time) => {
      const acc = new THREE.Vector3();
      for (let k = -12; k <= 12; k++) { const w = 1 - Math.abs(k) / 13; acc.addScaledVector(rawDir(time + k * 0.1), w); }
      if (acc.lengthSq() < 1e-6) acc.copy(rawDir(time));
      return acc.setY(0).normalize();
    };
    const sample = (time) => {
      const pos = time < intro ? way[0].p.clone() : posAt(time);
      const dir = smoothDir(time);
      const look = pos.clone().addScaledVector(dir, 3).setY(1.2);
      const u = Math.min(1, Math.max(0, (time - intro) / DUR)), kt = knotAt(u), i0 = Math.floor(kt), i1 = Math.min(way.length - 1, i0 + 1);
      return { pos, look, caption: time < intro ? 'Mở cửa căn hộ' : (kt - i0 < 0.5 ? way[i0] : way[i1]).caption, door: time < intro, k: time / intro };
    };
    // góc trình diễn phòng khách: nhìn về bộ sofa + TV (cửa sổ / lô gia phía sau), đứng lùi về phía đối diện trong phòng
    const inLiving = (q) => pointInPolygon(q, living.points);
    const fz = plan.furniture.filter((f) => inLiving(f) && /sofa|tvStand|armchair|coffeeTable/.test(f.type));
    let show = { pos: V(lc.x, lc.y), look: ls.target.clone() };
    if (fz.length) {
      const fc = fz.reduce((a, f) => ({ x: a.x + f.x / fz.length, y: a.y + f.y / fz.length }), { x: 0, y: 0 });
      const d = { x: lc.x - fc.x, y: lc.y - fc.y }, dl = Math.hypot(d.x, d.y) || 1;
      let back = 3.2, p0 = null;
      while (back > 0.5) { const q = { x: fc.x + (d.x / dl) * back, y: fc.y + (d.y / dl) * back }; if (inLiving(q) && Math.min(...living.points.map((a, i) => closestOnSegment(q, a, living.points[(i + 1) % living.points.length]).d)) > 0.45) { p0 = q; break; } back -= 0.2; }
      p0 ||= lc;
      show = { pos: V(p0.x, p0.y), look: V(fc.x, fc.y, 0.9) };
    }
    return { duration: intro + DUR, sample, showcase: ls, show };
  }

  /**
   * Quay video dọc 9:16: vẽ từng khung theo lộ trình, ghép chữ (tên phòng, diện tích, tiêu đề, khung kết) lên canvas 2D.
   * frame(t) trả về canvas đã vẽ tại thời điểm t (giây) – dùng cho ghi trực tiếp (MediaRecorder) hoặc xuất từng khung.
   */
  videoSetup({ w = 720, h = 1280, title = '', sub = '', end = [], styles = null } = {}) {
    if (this.ptActive) this.stopRealRender();
    this.stopTour?.();
    if (this.mode === 'walk') this.exitWalk();
    const path = this.videoPath();
    const END = 2.4;
    // phương án nội thất: đứng ở phòng khách, chuyển lần lượt các phong cách (mờ chuyển cảnh), mỗi phương án 2,4 s
    const SEG = 2.4, MONT = styles?.list?.length ? styles.list.length * SEG : 0;
    const saved = { cut: this.state.cut, labels: this.state.labels, fov: this.camera.fov, aspect: this.camera.aspect, pr: this.renderer.getPixelRatio(), pos: this.camera.position.clone(), target: this.controls.target.clone() };
    this.state.cut = 1; this.updateClip();
    this.built.labels.forEach((l) => (l.visible = false));
    this.built.root.traverse((o) => { if (o.userData.ceiling) o.visible = this.state.ceiling; });
    if (this._adCanvas) this._adCanvas.style.display = 'none';
    this.renderer.setPixelRatio(1); this.renderer.setSize(w, h, false);
    this.composer.setPixelRatio?.(1); this.composer.setSize(w, h);
    this.camera.aspect = w / h; this.camera.fov = 72; this.camera.updateProjectionMatrix();
    this.built.doors.forEach((d) => { d.target = 1; d.open = 0; });
    // cánh cửa trong nhà: mở hẳn và ẩn để không che hình khi đi qua (cửa chính vẫn mở dần ở cảnh đầu)
    let leaves = this.built.doors.filter((d) => d.pivot);
    const out = document.createElement('canvas'); out.width = w; out.height = h;
    const x = out.getContext('2d');
    const s = w / 720;
    const font = (wt, px) => `${wt} ${Math.round(px * s)}px Inter, Arial, sans-serif`;
    const pill = (text, cxp, cyp, size, bg, fg) => {
      x.font = font(700, size); const tw = x.measureText(text).width, pw = tw + 36 * s, ph = size * s * 1.9;
      x.fillStyle = bg; x.beginPath(); x.roundRect(cxp - pw / 2, cyp - ph / 2, pw, ph, ph / 2); x.fill();
      x.fillStyle = fg; x.textAlign = 'center'; x.textBaseline = 'middle'; x.fillText(text, cxp, cyp + 1);
    };
    const duration = path.duration + MONT + END;
    // góc trình diễn phương án: điểm ngắm đẹp nhất của phòng khách, lùi ra 0,6 m cho rộng khung
    const endPose = { pos: path.show.pos.clone().setY(1.55), look: path.show.look.clone() };
    const prevCv = document.createElement('canvas'); prevCv.width = w; prevCv.height = h;
    let styleIdx = -1, fadeT0 = -9;
    let lastT = 0;
    const frame = async (t) => {
      const dt = Math.max(0, Math.min(0.1, t - lastT)); lastT = t;
      if (MONT && t >= path.duration && t < path.duration + MONT) {
        const k = Math.min(styles.list.length - 1, Math.floor((t - path.duration) / SEG));
        if (k !== styleIdx) {
          prevCv.getContext('2d').drawImage(out, 0, 0);
          styleIdx = k; fadeT0 = t;
          await styles.apply(styles.list[k].key);
          if (this._upgrading) await this._upgrading;
          this.built.labels.forEach((l) => (l.visible = false));
          this.built.root.traverse((o) => { if (o.userData.ceiling) o.visible = this.state.ceiling; });
          leaves = this.built.doors.filter((d) => d.pivot);
          this.built.doors.forEach((d) => { d.open = 1; d.target = 1; }); this.applyDoors(0);
          leaves.forEach((d) => { d.pivot.visible = false; });
        }
        // lia rất chậm quanh phòng khách
        const ang = THREE.MathUtils.degToRad(14) * ((t - path.duration) / MONT - 0.5);
        const dir = endPose.look.clone().sub(endPose.pos).setY(0).applyAxisAngle(new THREE.Vector3(0, 1, 0), ang);
        this.camera.position.copy(endPose.pos);
        this.camera.lookAt(endPose.pos.clone().add(dir).setY(1.2));
        this.camera.updateMatrixWorld();
        if (this.state.ao || this.bloom.enabled) this.composer.render(); else this.renderer.render(this.scene, this.camera);
        x.drawImage(this.renderer.domElement, 0, 0, w, h);
        const fk = Math.min(1, (t - fadeT0) / 0.6);
        if (fk < 1) { x.globalAlpha = 1 - fk; x.drawImage(prevCv, 0, 0); x.globalAlpha = 1; }
        const g = x.createLinearGradient(0, 0, 0, 220 * s); g.addColorStop(0, 'rgba(0,0,0,.45)'); g.addColorStop(1, 'rgba(0,0,0,0)');
        x.fillStyle = g; x.fillRect(0, 0, w, 220 * s);
        x.textAlign = 'center'; x.textBaseline = 'alphabetic'; x.fillStyle = '#fff';
        x.font = font(800, 40); x.fillText(title, w / 2, 92 * s);
        x.font = font(600, 26); x.fillStyle = 'rgba(255,255,255,.92)'; x.fillText(`Phương án nội thất ${styleIdx + 1}/${styles.list.length}`, w / 2, 132 * s);
        pill(styles.list[styleIdx].name, w / 2, h - 230 * s, 30, 'rgba(200,129,42,.92)', '#fff');
        return out;
      }
      if (t < path.duration) {
        const f = path.sample(t);
        // cửa chính mở dần lúc đứng ngoài, các cửa khác đã mở sẵn
        this.built.doors.forEach((d) => { d.open = f.door ? Math.min(1, (f.k || 0) * 1.4) : 1; });
        leaves.forEach((d) => { d.pivot.visible = f.door; });
        this.applyDoors(0);
        // rung tay nhẹ như quay điện thoại
        const sway = new THREE.Vector3(0, Math.sin(t * 1.1) * 0.006, 0); // nhún rất nhẹ, không lắc ngang
        this.camera.position.copy(f.pos).add(sway);
        this.camera.lookAt(f.look);
        this.camera.updateMatrixWorld();
        this.updateCutaway?.();
        if (this.state.ao || this.bloom.enabled) this.composer.render(); else this.renderer.render(this.scene, this.camera);
        x.drawImage(this.renderer.domElement, 0, 0, w, h);
        // chữ: tiêu đề trên cùng, tên phòng + diện tích giữa dưới (hiện dần khi đổi phòng)
        const g = x.createLinearGradient(0, 0, 0, 220 * s); g.addColorStop(0, 'rgba(0,0,0,.45)'); g.addColorStop(1, 'rgba(0,0,0,0)');
        x.fillStyle = g; x.fillRect(0, 0, w, 220 * s);
        x.textAlign = 'center'; x.textBaseline = 'alphabetic'; x.fillStyle = '#fff';
        x.font = font(800, 40); x.fillText(title, w / 2, 92 * s);
        x.font = font(500, 24); x.fillStyle = 'rgba(255,255,255,.9)'; x.fillText(sub, w / 2, 132 * s);
        pill(f.caption, w / 2, h - 230 * s, 30, 'rgba(15,23,42,.72)', '#fff');
      } else {
        // khung kết: nền tối, thông tin căn + lời mời xem nhà
        const k = Math.min(1, (t - path.duration - MONT) / 0.5);
        x.drawImage(this.renderer.domElement, 0, 0, w, h);
        x.fillStyle = `rgba(12,16,24,${0.82 * k})`; x.fillRect(0, 0, w, h);
        x.globalAlpha = k; x.textAlign = 'center'; x.fillStyle = '#fff';
        x.font = font(800, 46); x.fillText(title, w / 2, h / 2 - 120 * s);
        x.font = font(500, 26); end.forEach((line, i) => x.fillText(line, w / 2, h / 2 - 50 * s + i * 46 * s));
        pill('Nhắn tin để xem nhà mẫu', w / 2, h / 2 + (end.length * 46 + 30) * s, 28, '#c8812a', '#fff');
        x.globalAlpha = 1;
      }
      return out;
    };
    const restore = async () => {
      if (MONT && styleIdx >= 0) { await styles.restore(); if (this._upgrading) await this._upgrading; leaves = this.built.doors.filter((d) => d.pivot); }
      leaves.forEach((d) => { d.pivot.visible = true; });
      this.camera.fov = saved.fov; this.camera.aspect = saved.aspect; this.camera.updateProjectionMatrix();
      this.renderer.setPixelRatio(saved.pr); this.composer.setPixelRatio?.(saved.pr);
      this.state.cut = saved.cut; this.updateClip();
      this.built.labels.forEach((l) => (l.visible = saved.labels));
      this.camera.position.copy(saved.pos); this.controls.target.copy(saved.target);
      this.resize(); this.controls.update();
    };
    return { duration, frame, canvas: out, restore, fps: 30 };
  }

  /**
   * Xuất video: dựng TỪNG KHUNG theo thời gian cố định rồi mã hoá mp4 (WebCodecs) → luôn mượt 30 hình/giây dù máy yếu.
   * Máy không có WebCodecs thì ghi trực tiếp bằng MediaRecorder (có thể hơi giật trên máy chậm).
   */
  async recordVideo(opts = {}, onProgress) {
    const v = this.videoSetup(opts);
    const wasActive = this.active;
    this.setActive(false);
    try {
      if (window.VideoEncoder && window.VideoFrame) {
        const { Muxer, ArrayBufferTarget } = await import('mp4-muxer');
        const W = v.canvas.width, H = v.canvas.height, FPS = v.fps;
        const cfg = { codec: 'avc1.4d0028', width: W, height: H, bitrate: 6e6, framerate: FPS };
        const ok = await VideoEncoder.isConfigSupported(cfg).then((r) => r.supported).catch(() => false);
        if (ok) {
          const muxer = new Muxer({ target: new ArrayBufferTarget(), video: { codec: 'avc', width: W, height: H }, fastStart: 'in-memory' });
          let err = null;
          const enc = new VideoEncoder({ output: (chunk, meta) => muxer.addVideoChunk(chunk, meta), error: (e) => (err = e) });
          enc.configure(cfg);
          const N = Math.ceil(v.duration * FPS);
          for (let i = 0; i < N; i++) {
            const t = i / FPS;
            await v.frame(t);
            const fr = new VideoFrame(v.canvas, { timestamp: Math.round(t * 1e6), duration: Math.round(1e6 / FPS) });
            enc.encode(fr, { keyFrame: i % (FPS * 2) === 0 });
            fr.close();
            if (enc.encodeQueueSize > 8) await new Promise((r) => setTimeout(r, 0));
            if (i % 6 === 0) { onProgress?.(i / N); await new Promise((r) => setTimeout(r, 0)); }
            if (err) throw err;
          }
          await enc.flush();
          muxer.finalize();
          return { blob: new Blob([muxer.target.buffer], { type: 'video/mp4' }), ext: 'mp4' };
        }
      }
      // dự phòng: ghi trực tiếp
      const mime = ['video/mp4;codecs=avc1', 'video/mp4', 'video/webm;codecs=vp9', 'video/webm'].find((m) => window.MediaRecorder?.isTypeSupported?.(m));
      if (!mime) throw new Error('Trình duyệt này chưa hỗ trợ quay video');
      const stream = v.canvas.captureStream(v.fps);
      const rec = new MediaRecorder(stream, { mimeType: mime, videoBitsPerSecond: 8e6 });
      const chunks = [];
      rec.ondataavailable = (e) => e.data.size && chunks.push(e.data);
      const done = new Promise((res) => (rec.onstop = res));
      rec.start(500);
      const t0 = performance.now();
      await new Promise((res) => {
        const step = async () => { const t = (performance.now() - t0) / 1000; await v.frame(Math.min(t, v.duration)); onProgress?.(Math.min(1, t / v.duration)); if (t >= v.duration) res(); else requestAnimationFrame(step); };
        requestAnimationFrame(step);
      });
      rec.stop(); await done;
      return { blob: new Blob(chunks, { type: mime.split(';')[0] }), ext: mime.includes('mp4') ? 'mp4' : 'webm' };
    } finally {
      await v.restore(); this.setActive(wasActive);
    }
  }

  /** Tham quan: toàn cảnh → bay lần lượt vào từng phòng → về toàn cảnh; giờ trong ngày trôi từ sáng tới tối */
  playTour({ onCaption, onProgress, onDone } = {}) {
    if (!this.built) return;
    this.stopTour();
    if (this.mode === 'walk') this.exitWalk();
    const plan = this.store.plan;
    const rooms = plan.rooms.filter((r) => polygonArea(r.points) > 2.5).sort((a, b) => polygonArea(b.points) - polygonArea(a.points));
    const b = this.built.bounds;
    const s = b.size;
    const over = { pos: new THREE.Vector3(b.cx + s * 0.08, s * 1.4 + 4, b.maxY + s * 0.5 + 1), target: new THREE.Vector3(b.cx, 0.3, b.cy + 0.3), caption: 'Toàn cảnh căn hộ' };
    const shots = [over, ...rooms.map((r) => ({ ...this.roomShot(r), caption: `${r.name} · ${polygonArea(r.points).toFixed(1).replace('.', ',')} m²` })), { ...over, caption: 'Hoàn tất tham quan' }];
    const segs = [];
    let prev = { pos: this.camera.position.clone(), target: this.controls.target.clone() };
    for (let i = 0; i < shots.length; i++) {
      const sh = shots[i];
      segs.push({ kind: 'move', from: prev, to: sh, dur: i === 0 ? 1600 : 2600, arc: i > 0, caption: sh.caption });
      segs.push({ kind: 'hold', at: sh, dur: i === 0 || i === shots.length - 1 ? 2200 : 3600, sweep: i > 0 && i < shots.length - 1, caption: sh.caption });
      prev = sh;
    }
    const total = segs.reduce((a, x) => a + x.dur, 0);
    this.controls.enabled = false;
    this._tourSaved = { cut: this.state.cut, labels: this.state.labels, hour: this.state.hour, autoRotate: this.controls.autoRotate };
    this.state.cut = 1;
    this.updateClip();
    this.controls.autoRotate = false;
    if (this.anim) this.finishAnim();
    this._tourFov = this.camera.fov;
    this.tour = { segs, total, t0: performance.now(), onCaption, onProgress, onDone, idx: -1, H: this.built.height };
  }

  stopTour(completed = false) {
    const t = this.tour;
    if (!t) return;
    this.tour = null;
    this.controls.enabled = true;
    this.camera.fov = this._tourFov || 40;
    this.camera.updateProjectionMatrix();
    const last = t.segs[t.segs.length - 1].at;
    this.controls.target.copy(last.target);
    if (this._tourSaved) {
      this.state.cut = this._tourSaved.cut;
      this.built.labels.forEach((l) => (l.visible = this._tourSaved.labels));
      this.updateClip();
    }
    t.onDone?.(completed);
  }

  tickTour(now) {
    const t = this.tour;
    let el = now - t.t0;
    let i = 0;
    while (i < t.segs.length && el > t.segs[i].dur) { el -= t.segs[i].dur; i++; }
    if (i >= t.segs.length) { this.stopTour(true); return; }
    const seg = t.segs[i];
    if (i !== t.idx) { t.idx = i; t.onCaption?.(seg.caption); }
    const k = Math.min(1, el / seg.dur);
    const e = k < 0.5 ? 4 * k * k * k : 1 - Math.pow(-2 * k + 2, 3) / 2;
    const cam = this.camera;
    let target;
    if (seg.kind === 'move') {
      const p0 = seg.from.pos, p1 = seg.to.pos;
      cam.position.lerpVectors(p0, p1, e);
      // Bay vòng qua phía trên trần khi chuyển phòng (như flycam)
      if (seg.arc) cam.position.y += Math.sin(Math.PI * e) * (Math.max(0, t.H + 2.2 - Math.min(p0.y, p1.y)) * (Math.min(p0.y, p1.y) < t.H ? 1 : 0.3));
      target = new THREE.Vector3().lerpVectors(seg.from.target, seg.to.target, e);
    } else {
      cam.position.copy(seg.at.pos);
      target = seg.at.target.clone();
      if (seg.sweep) {
        const ang = Math.sin(k * Math.PI * 2) * 0.6;
        const d = target.clone().sub(cam.position);
        d.applyAxisAngle(new THREE.Vector3(0, 1, 0), ang);
        target = cam.position.clone().add(d);
      }
    }
    cam.lookAt(target);
    this.controls.target.copy(target);
    // Góc nhìn rộng khi ở trong phòng, hẹp khi nhìn toàn cảnh
    const inside = cam.position.y < t.H;
    const fov = THREE.MathUtils.lerp(cam.fov, inside ? 72 : 40, 0.08);
    if (Math.abs(fov - cam.fov) > 0.05) { cam.fov = fov; cam.updateProjectionMatrix(); }
    // Nhãn phòng chỉ hiện khi đang ở trên cao
    const above = cam.position.y > t.H + 0.5;
    this.built.labels.forEach((l) => (l.visible = above && this._tourSaved.labels));
    // 4D: thời gian trôi từ 8h sáng tới 19h tối trong suốt chuyến tham quan
    const prog = (now - t.t0) / t.total;
    this.setHour(8 + prog * 11);
    t.onProgress?.(prog, this.state.hour);
  }

  // ---------------- Camera ----------------
  frameAll(smooth = true, preset = 'iso') {
    const b = this.built.bounds;
    const target = new THREE.Vector3(b.cx, 0.3, b.cy + (preset === 'iso' ? 0.4 : 0));
    const s = b.size;
    let pos;
    // Nhìn từ trên: căn ngang (rộng > sâu) xoay cho cạnh dài nằm dọc màn hình, khớp với ảnh mặt bằng 5:6 tải về
    // keepNorth: giữ đúng hướng như trên mặt bằng tầng (xem theo mã căn), không xoay căn ngang thành dọc
    if (preset === 'top') pos = !this.keepNorth && b.maxX - b.minX > b.maxY - b.minY ? new THREE.Vector3(b.cx - 0.01, s * 1.55 + 4, b.cy) : new THREE.Vector3(b.cx, s * 1.55 + 4, b.cy + 0.01);
    else if (preset === 'front') pos = new THREE.Vector3(b.cx, s * 0.35 + 1.5, b.maxY + s * 1.0 + 3);
    else if (this.isoView) {
      // Góc nhìn chéo kiểu phối cảnh bán hàng: từ phía mặt tiền, lệch trái, chúc xuống
      const { az, el, k = 1 } = this.isoView;
      const d = (s * 1.45 + 3.5) * k, A = THREE.MathUtils.degToRad(az), E = THREE.MathUtils.degToRad(el);
      pos = target.clone().add(new THREE.Vector3(Math.sin(A) * Math.cos(E), Math.sin(E), Math.cos(A) * Math.cos(E)).multiplyScalar(d));
    } else pos = this.isStudio() ? new THREE.Vector3(b.cx + s * 0.05, s * 1.3 + 2.5, b.maxY + s * 0.32 + 1) : new THREE.Vector3(b.cx + s * 0.08, s * 1.85 + 5, b.maxY + s * 0.45 + 1.5);
    const fit = this.fitView(pos, target, this.state.ad || this.state.labels ? 0.6 : 0.86); // kiểu quảng cáo: chừa hai bên cho chú thích
    this.flyTo(fit.pos, fit.target, smooth);
  }

  /** Giữ hướng nhìn, dời tâm + chỉnh khoảng cách để căn nằm chính giữa khung, lề đều bốn phía */
  fitView(pos, target, margin = 0.86) {
    const b = this.built.bounds;
    const H = Math.min(this.built.height, this.clipPlane.constant);
    const corners = [];
    for (const x of [b.minX, b.maxX]) for (const y of [0, H]) for (const z of [b.minY, b.maxY]) corners.push(new THREE.Vector3(x, y, z));
    const cam = this.camera.clone();
    const dir = pos.clone().sub(target);
    let dist = dir.length();
    dir.normalize();
    const t = target.clone(), p = new THREE.Vector3(), right = new THREE.Vector3(), up = new THREE.Vector3();
    for (let it = 0; it < 5; it++) {
      cam.position.copy(t).addScaledVector(dir, dist);
      cam.lookAt(t);
      cam.updateMatrixWorld();
      let x0 = Infinity, x1 = -Infinity, y0 = Infinity, y1 = -Infinity;
      for (const c of corners) { p.copy(c).project(cam); x0 = Math.min(x0, p.x); x1 = Math.max(x1, p.x); y0 = Math.min(y0, p.y); y1 = Math.max(y1, p.y); }
      const halfH = Math.tan(THREE.MathUtils.degToRad(cam.fov / 2)) * dist, halfW = halfH * cam.aspect;
      right.setFromMatrixColumn(cam.matrixWorld, 0);
      up.setFromMatrixColumn(cam.matrixWorld, 1);
      t.addScaledVector(right, ((x0 + x1) / 2) * halfW).addScaledVector(up, ((y0 + y1) / 2) * halfH);
      dist *= Math.max((x1 - x0) / 2, (y1 - y0) / 2) / margin;
    }
    return { pos: t.clone().addScaledVector(dir, dist), target: t };
  }

  flyTo(pos, target, smooth = true) {
    if (!smooth) {
      this.camera.position.copy(pos);
      this.controls.target.copy(target);
      this.controls.update();
      return;
    }
    this.fly = { t0: performance.now(), dur: 900, p0: this.camera.position.clone(), p1: pos, t0v: this.controls.target.clone(), t1v: target };
  }

  setView(name) {
    if (this.mode === 'walk') this.exitWalk();
    if (name === 'top') { this.frameAll(true, 'top'); }
    else if (name === 'front') this.frameAll(true, 'front');
    else this.frameAll(true, 'iso');
  }

  enterWalk() {
    if (!this.built) return;
    this.mode = 'walk';
    this.controls.enabled = false;
    this._savedCut = this.state.cut;
    this.state.cut = 1;
    this.updateClip();
    this.built.labels.forEach((l) => (l.visible = false));
    this.camera.position.copy(this.built.spawn);
    this.camera.rotation.set(0, 0, 0);
    this.camera.lookAt(this.built.spawn.x + 1, 1.5, this.built.spawn.z + 0.01);
    this.camera.fov = 70;
    this.camera.updateProjectionMatrix();
    this.pointer.lock();
  }

  exitWalk() {
    if (this.mode !== 'walk') return;
    this.mode = 'orbit';
    this.pointer.unlock();
    this.controls.enabled = true;
    this.state.cut = this._savedCut ?? 1;
    this.updateClip();
    this.built.labels.forEach((l) => (l.visible = this.state.labels));
    this.camera.fov = 40;
    this.camera.updateProjectionMatrix();
    this.frameAll(true);
  }

  // ---------------- Tương tác ----------------
  bindEvents() {
    const el = this.renderer.domElement;
    let down = null;
    el.addEventListener('pointerdown', (e) => (down = { x: e.clientX, y: e.clientY }));
    el.addEventListener('pointerup', (e) => {
      if (!down || Math.hypot(e.clientX - down.x, e.clientY - down.y) > 5) return;
      if (this.mode === 'walk') {
        if (!this.pointer.isLocked) this.pointer.lock();
        else this.toggleNearestDoor();
        return;
      }
      const hit = this.pick(e);
      if (hit?.door) this.toggleDoor(hit.door);
      else if (hit?.furnitureId) this.onPickFurniture?.(hit.furnitureId);
    });
    el.addEventListener('pointermove', (e) => {
      if (this.mode === 'walk') return;
      clearTimeout(this._hoverT);
      this._hoverT = setTimeout(() => this.hover(e), 30);
    });
    el.addEventListener('pointerleave', () => (this.tooltip.style.display = 'none'));
    el.addEventListener('dblclick', (e) => {
      if (this.mode === 'walk') return;
      const hit = this.pick(e, true);
      if (hit?.point) {
        const dir = this.camera.position.clone().sub(this.controls.target);
        const t = hit.point.clone();
        this.flyTo(t.clone().add(dir.multiplyScalar(0.45)), t);
      }
    });
    window.addEventListener('keydown', (e) => {
      if (this.mode !== 'walk') return;
      this.keys[e.code] = true;
      if (e.code === 'KeyE') this.toggleNearestDoor();
    });
    window.addEventListener('keyup', (e) => (this.keys[e.code] = false));
  }

  pick(e, any = false) {
    const rect = this.renderer.domElement.getBoundingClientRect();
    this.mouse.set(((e.clientX - rect.left) / rect.width) * 2 - 1, -((e.clientY - rect.top) / rect.height) * 2 + 1);
    this.raycaster.setFromCamera(this.mouse, this.camera);
    const hits = this.raycaster.intersectObject(this.built.root, true);
    for (const h of hits) {
      if (!h.object.visible) continue;
      if (h.point.y > this.clipPlane.constant + 0.001 && h.object.material?.clippingPlanes?.length) continue;
      if (h.object.material?.side === THREE.BackSide) continue;
      if (h.object.userData.door) return { door: h.object.userData.door, point: h.point };
      if (h.object.userData.furnitureId) return { furnitureId: h.object.userData.furnitureId, point: h.point };
      if (any) return { point: h.point };
      return null;
    }
    return null;
  }

  hover(e) {
    const hit = this.pick(e);
    const t = this.tooltip;
    if (!hit) { t.style.display = 'none'; this.renderer.domElement.style.cursor = ''; return; }
    let text = '';
    if (hit.door) text = (hit.door.op.type === 'slide' ? 'Cửa kính lùa' : 'Cửa đi') + ' — nhấp để ' + (hit.door.target > 0.5 ? 'đóng' : 'mở');
    else {
      const item = this.store.plan.furniture.find((f) => f.id === hit.furnitureId);
      const def = item && CATALOG_MAP[item.type];
      if (def) text = `${def.name} · ${(item.w ?? def.w).toFixed(2)} × ${(item.d ?? def.d).toFixed(2)} m`;
    }
    if (!text) { t.style.display = 'none'; return; }
    const rect = this.container.getBoundingClientRect();
    t.textContent = text;
    t.style.display = 'block';
    t.style.left = e.clientX - rect.left + 14 + 'px';
    t.style.top = e.clientY - rect.top + 14 + 'px';
    this.renderer.domElement.style.cursor = 'pointer';
  }

  toggleDoor(d) { d.target = d.target > 0.5 ? 0 : 1; }

  toggleNearestDoor() {
    let best = null, bd = 2.0;
    for (const d of this.built.doors) {
      const dd = Math.hypot(d.center.x - this.camera.position.x, d.center.z - this.camera.position.z);
      if (dd < bd) { bd = dd; best = d; }
    }
    if (best) { best.target = best.target > 0.5 ? 0 : 1; best.manual = true; }
  }

  applyDoors(k) {
    for (const d of this.built.doors) {
      d.open += (d.target - d.open) * k;
      if (d.pivot) d.pivot.rotation.y = d.sign * d.open * THREE.MathUtils.degToRad(88);
      if (d.slidePanel) d.slidePanel.position.x = d.slideBase + d.slideDist * d.open;
    }
  }

  openAllDoors(open) { this.built.doors.forEach((d) => (d.target = open ? 1 : 0)); }

  // ---------------- Đi bộ & va chạm ----------------
  walk(dt) {
    const speed = (this.keys.ShiftLeft || this.keys.ShiftRight ? 3.2 : 1.6) * dt;
    const f = (this.keys.KeyW || this.keys.ArrowUp ? 1 : 0) - (this.keys.KeyS || this.keys.ArrowDown ? 1 : 0);
    const s = (this.keys.KeyD || this.keys.ArrowRight ? 1 : 0) - (this.keys.KeyA || this.keys.ArrowLeft ? 1 : 0);
    const forward = new THREE.Vector3();
    this.camera.getWorldDirection(forward);
    forward.y = 0; forward.normalize();
    const right = new THREE.Vector3().crossVectors(forward, new THREE.Vector3(0, 1, 0));
    const move = forward.multiplyScalar(f).add(right.multiplyScalar(s));
    if (move.lengthSq() > 0) move.normalize().multiplyScalar(speed);
    const p = this.camera.position;
    const next = { x: p.x + move.x, y: p.z + move.z };
    const R = 0.22;
    for (let iter = 0; iter < 3; iter++) {
      for (const c of this.built.colliders) {
        if (c.box) {
          const local = rotatePoint({ x: next.x - c.box.x, y: next.y - c.box.y }, (-c.box.rot * Math.PI) / 180);
          const hw = c.box.w / 2 + R * 0.6, hd = c.box.d / 2 + R * 0.6;
          if (Math.abs(local.x) < hw && Math.abs(local.y) < hd) {
            const px = hw - Math.abs(local.x), py = hd - Math.abs(local.y);
            if (px < py) local.x = Math.sign(local.x) * hw; else local.y = Math.sign(local.y) * hd;
            const g = rotatePoint(local, (c.box.rot * Math.PI) / 180);
            next.x = g.x + c.box.x; next.y = g.y + c.box.y;
          }
        } else {
          const q = closestOnSegment(next, c.a, c.b);
          const min = c.r + R;
          if (q.d < min) {
            const nx = (next.x - q.point.x) / (q.d || 1), ny = (next.y - q.point.y) / (q.d || 1);
            next.x = q.point.x + nx * min; next.y = q.point.y + ny * min;
          }
        }
      }
    }
    p.x = next.x; p.z = next.y;
    // Nhún nhẹ khi bước
    this._bob = (this._bob || 0) + (move.lengthSq() > 0 ? dt * 9 : 0);
    p.y = 1.6 + Math.sin(this._bob) * 0.025;
    // Cửa tự mở khi lại gần
    for (const d of this.built.doors) {
      if (d.manual) continue;
      const dd = Math.hypot(d.center.x - p.x, d.center.z - p.z);
      d.target = dd < 1.4 ? 1 : d.target;
    }
  }

  /** Mặt cắt dollhouse: khi đang cắt tường, hạ tường bao phía gần camera (kèm cửa sổ, rèm) để nhìn rõ bên trong */
  updateCutaway() {
    const d = this.controls.target.clone().sub(this.camera.position);
    const len = d.length(), hz = Math.hypot(d.x, d.z);
    const on = this.state.cutaway !== false && this.state.cut < 0.999 && this.mode !== 'walk' && !this.tour && !this.ptActive && hz > len * 0.25;
    CUTAWAY.on.value = on ? 1 : 0;
    if (on) CUTAWAY.dir.value.set(d.x / hz, d.z / hz);
    const key = on ? `${CUTAWAY.dir.value.x.toFixed(2)},${CUTAWAY.dir.value.y.toFixed(2)}` : 'off';
    if (key === this._cutKey && this._cutBuilt === this.built) return;
    this._cutKey = key; this._cutBuilt = this.built;
    for (const o of this.built.cutObjs || []) {
      const f = o.userData.cutFace;
      o.visible = !(on && (f.inner || f.x * CUTAWAY.dir.value.x + f.z * CUTAWAY.dir.value.y < -0.2));
    }
  }

  // ---------------- Vòng lặp ----------------
  tick() {
    const now = performance.now();
    const dt = Math.min((now - this._last) / 1000, 0.05);
    this._last = now;
    if (this.anim) {
      const t = Math.min(1, (now - this.anim.t0) / this.anim.dur);
      const H = this.built.height;
      const wallT = easeOut(Math.min(1, t / 0.55));
      const finalY = this.state.cut >= 0.999 ? H + 0.05 : 0.25 + this.state.cut * (H - 0.25);
      this.updateClip(0.001 + wallT * finalY);
      for (const f of this.built.furniture) {
        const k = THREE.MathUtils.clamp((t - f.userData.delay) / 0.25, 0, 1);
        f.visible = k > 0;
        const e = easeOut(k);
        f.position.y = (1 - e) * 1.2;
        f.scale.setScalar(0.6 + 0.4 * e);
      }
      if (t >= 1) this.finishAnim();
    }
    if (this.fly) {
      const t = Math.min(1, (now - this.fly.t0) / this.fly.dur);
      const e = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
      this.camera.position.lerpVectors(this.fly.p0, this.fly.p1, e);
      this.controls.target.lerpVectors(this.fly.t0v, this.fly.t1v, e);
      if (t >= 1) this.fly = null;
    }
    if (this.built) this.applyDoors(1 - Math.pow(0.002, dt));
    if (this.built) this.updateCutaway();
    if (this.tour) this.tickTour(now);
    else if (this.mode === 'walk') this.walk(dt);
    else this.controls.update();
    if (this.built) {
      const above = this.camera.position.y > this.built.height;
      if (above !== this._above) {
        this._above = above;
        this.built.root.traverse((o) => { if (o.userData.lampDisc) o.visible = !above; });
        if (!this.tour && this.mode !== 'walk') this.built.labels.forEach((l) => (l.visible = above && this.state.labels));
      }
    }
    if (this.ptActive) {
      this.camera.updateMatrixWorld();
      if (!this.camera.matrixWorld.equals(this._ptCam)) { this._ptCam.copy(this.camera.matrixWorld); this.pt.updateCamera(); this._ptDone = false; }
      if (this._ptDone) return;
      this.pt.renderSample();
      this.onPTProgress?.(this.pt.samples);
      if (this.pt.samples >= this.ptTarget) { this._ptDone = true; this.onPTDone?.(); }
      return;
    }
    if (this.state.ao) this.composer.render();
    else if (this.bloom.enabled) this.composer.render();
    else this.renderer.render(this.scene, this.camera);
    this.labelRenderer.render(this.scene, this.camera);
    this.adOverlay();
  }

  resize() {
    const w = this.container.clientWidth || 1, h = this.container.clientHeight || 1;
    this.renderer.setSize(w, h);
    this.composer.setSize(w, h);
    this.labelRenderer.setSize(w, h);
    this.camera.aspect = w / h;
    this.camera.updateProjectionMatrix();
  }

  // ---------------- Xuất ----------------
  screenshot() {
    if (this.ptActive) { this.pt.renderSample(); return this.renderer.domElement.toDataURL('image/png'); }
    if (this.state.ao || this.bloom.enabled) this.composer.render(); else this.renderer.render(this.scene, this.camera);
    return this.renderer.domElement.toDataURL('image/png');
  }

  /** Tải ảnh PNG nét cao của khung 3D; nhìn từ trên thì kèm tên + diện tích phòng */
  exportPNG(info = {}) {
    // mode 'plan': ảnh mặt bằng nhìn thẳng từ trên (đọc rõ dài × rộng); 'view': giữ góc đang xem
    const planMode = info.mode === 'plan' && !(this.ptActive && this.pt.samples >= 1);
    const above = planMode || this.camera.position.y > (this.built?.height || 2.8) + 1;
    // bật 🏷 Tên phòng thì ảnh phối cảnh cũng đưa chú thích ra ngoài (tên, diện tích, dài × rộng)
    // ảnh như thật (chụp nhanh / siêu thật) luôn kèm chú thích phòng: tên, diện tích, dài × rộng
    const photo = !!info.soft || (this.ptActive && this.pt.samples >= 1);
    const showLabels = (above || info.ad || this.state.labels || photo) && this.mode !== 'walk' && (info.mode !== 'view' || info.ad || this.state.labels || photo);
    const prev = this.built.labels.map((l) => l.visible);
    // Ảnh như thật chỉ dùng khi đã có ít nhất 1 lượt render; chưa có thì lấy ảnh 3D thường
    const usePT = this.ptActive && this.pt.samples >= 1;
    // Ảnh đẹp nhanh: cộng dồn nhiều khung, mỗi khung lệch nắng (bóng đổ mềm như nắng thật) và lệch camera
    // nửa điểm ảnh (khử răng cưa), bật bóng tối góc (AO) – kiểu Enscape/Lumion, vài giây là xong
    const acc = info.soft && !usePT ? document.createElement('canvas') : null;
    const softRender = () => {
      const cv = this.renderer.domElement, W = cv.width, H = cv.height;
      acc.width = W; acc.height = H;
      const x = acc.getContext('2d');
      const N = info.soft === true ? 32 : info.soft;
      const sunPos = this.sun.position.clone(), t = this.sun.target.position, d = sunPos.distanceTo(t);
      const dir = sunPos.clone().sub(t).normalize(), u = new THREE.Vector3(0, 1, 0).cross(dir).normalize(), v = dir.clone().cross(u);
      const aoWas = this.gtao.enabled; this.gtao.enabled = true;
      for (let i = 0; i < N; i++) {
        // điểm rải đều trên đĩa (xoắn ốc vàng) → bóng mềm đều, không lốm đốm
        const rr = Math.sqrt((i + 0.5) / N) * d * 0.022, a = i * 2.39996;
        this.sun.position.copy(sunPos).addScaledVector(u, Math.cos(a) * rr).addScaledVector(v, Math.sin(a) * rr);
        this.camera.setViewOffset(W, H, ((i * 0.618) % 1) - 0.5, ((i * 0.382) % 1) - 0.5, W, H);
        this.updateCutaway();
        this.composer.render();
        x.globalAlpha = 1 / (i + 1);
        x.drawImage(cv, 0, 0);
      }
      this.camera.clearViewOffset();
      this.sun.position.copy(sunPos);
      this.gtao.enabled = aoWas;
    };
    const render = () => {
      if (usePT) { this.pt.renderSample(); return; }
      if (acc) { softRender(); return; }
      this.updateCutaway();
      if (this.state.ao || this.bloom.enabled) this.composer.render(); else this.renderer.render(this.scene, this.camera);
    };
    this.labelRenderer.render(this.scene, this.camera);
    // Nhìn từ trên: chú thích phòng đưa ra ngoài (tên, diện tích, dài × rộng) + kích thước tổng
    let extra = {};
    if (showLabels) {
      const b = this.built.bounds;
      extra = {
        // kích thước tổng: ưu tiên số ghi trên bản vẽ (info.dims), không có thì đo theo tường
        plan: { w: info.dims?.[0] ?? b.maxX - b.minX, d: info.dims?.[1] ?? b.maxY - b.minY, corners: [[b.minX, b.minY], [b.maxX, b.minY], [b.maxX, b.maxY], [b.minX, b.maxY]].map(([px, pz]) => ({ x: px, y: 0, z: pz })) },
        callouts: this.calloutList(info.ad),
      };
      this.built.labels.forEach((l) => (l.visible = false));
    }
    // Khung ảnh cố định 5:6 (2000 × 2400): render riêng vùng giữa đúng tỉ lệ rồi canh căn cho vừa khung
    const FW = 2000, FH = 2400, fs = 2.4, band = Math.round((info.ad ? 92 : 84) * fs);
    let side = showLabels ? Math.round((info.ad ? 200 : 185) * fs) : 0;
    if (showLabels && info.ad && extra.callouts?.length) {
      // Cột chú thích vừa đúng chữ dài nhất → vùng ảnh căn rộng hơn, căn to hơn
      const mx = document.createElement('canvas').getContext('2d');
      let tw = 0;
      for (const c of extra.callouts) {
        mx.font = `700 ${Math.round(19 * fs)}px 'Dancing Script', 'Brush Script MT', cursive`; tw = Math.max(tw, mx.measureText(c.name).width + 30 * fs);
        mx.font = `500 ${Math.round(11.5 * fs)}px Inter, Arial, sans-serif`; tw = Math.max(tw, mx.measureText(c.sub || '').width);
      }
      side = Math.round(Math.min(side, Math.max(120 * fs, tw + 34 * fs)));
    }
    const frame = { W: FW, H: FH, side, band, s: fs };
    const rw = FW - 2 * side, rh = FH - band;
    const saved = { pos: this.camera.position.clone(), target: this.controls.target.clone(), aspect: this.camera.aspect, pr: this.renderer.getPixelRatio() };
    if (!usePT) {
      this.renderer.setPixelRatio(1);
      this.renderer.setSize(rw, rh, false);
      this.composer.setPixelRatio(1);
      this.composer.setSize(rw, rh);
      this.camera.aspect = rw / rh;
      this.camera.updateProjectionMatrix();
      const t0 = planMode ? new THREE.Vector3(this.built.bounds.cx, 0, this.built.bounds.cy) : this.controls.target;
      const p0 = planMode ? t0.clone().add(new THREE.Vector3(0, this.built.bounds.size * 2 + 6, 0.001)) : this.camera.position;
      // Mặt bằng căn ngang (rộng > sâu): xoay 90° cho cạnh dài nằm dọc, căn to hơn trong khung 5:6
      const wide = !this.keepNorth && this.built.bounds.maxX - this.built.bounds.minX > this.built.bounds.maxY - this.built.bounds.minY;
      if (planMode) this.camera.up.set(wide ? 1 : 0, 0, wide ? 0 : -1);
      this.camera.lookAt(t0);
      const fit = this.fitView(p0, t0, planMode ? 0.9 : 0.98);
      this.camera.position.copy(fit.pos);
      this.camera.lookAt(fit.target);
      this.camera.updateMatrixWorld();
    }
    // Đang render như thật không đổi được khung → cắt sát vùng có căn
    let focus = null;
    if (usePT) { const b = this.built.bounds; focus = []; for (const px of [b.minX, b.maxX]) for (const pz of [b.minY, b.maxY]) for (const py of [0, this.built.height]) focus.push({ x: px, y: py, z: pz }); }
    const out = exportImage({ renderer: this.renderer, scene: this.scene, camera: this.camera, render, source: acc, keepRatio: true, frame, focus, ...extra, ...info });
    if (!usePT) {
      this.renderer.setPixelRatio(saved.pr);
      this.composer.setPixelRatio(saved.pr);
      this.camera.up.set(0, 1, 0);
      this.camera.position.copy(saved.pos);
      this.controls.target.copy(saved.target);
      this.camera.lookAt(saved.target);
      this.resize();
      this.controls.update();
    }
    this.built.labels.forEach((l, i) => (l.visible = prev[i]));
    return out;
  }

  async exportGLB() {
    const clone = this.built.root.clone(true);
    const drop = [];
    clone.traverse((o) => { if (o.userData.noExport || o.isCSS2DObject || o.isLight) drop.push(o); });
    drop.forEach((o) => o.parent && o.parent.remove(o));
    const exporter = new GLTFExporter();
    return exporter.parseAsync(clone, { binary: true });
  }
}
