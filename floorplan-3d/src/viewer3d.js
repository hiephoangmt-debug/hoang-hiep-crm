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
import { buildScene, disposeTree, SHARED } from './builder.js';
import { upgradeFurniture, loadInteriorHDRI } from './realistic.js';
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
    const built = buildScene(this.store.plan, { clippingPlanes: [this.clipPlane], ceiling: this.state.ceiling, landscape: this.state.landscape, people: this.state.people });
    // Giữ trạng thái đóng/mở cửa sau khi dựng lại
    if (prev) for (const d of built.doors) { const o = prev.doors.find((p) => p.op.id === d.op.id); if (o) { d.open = o.open; d.target = o.target; } }
    this.built = built;
    this.scene.add(built.root);
    this.applyExterior();
    this._above = undefined;
    if (this.ptActive) this.stopRealRender();
    built.labels.forEach((l) => (l.visible = this.state.labels));
    if (this.state.realistic) upgradeFurniture(built, [this.clipPlane]);
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
      this.scene.background = new THREE.Color(night ? 0x1c2230 : 0xdcdcdc);
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
      this.pt.tiles.set(2, 2);
      this.pt.bounces = 6;
      this.pt.transmissiveBounces = 6;
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
      this.scene.environment = this.state.realistic && this.hdriEquirect ? this.hdriEquirect : grad;
    } else {
      this._ptBg = { bg: this.scene.background, env: this.scene.environment };
      this.scene.environment = this.extTex;
    }
    this._ptCatcher = this.shadowCatcher.visible;
    this.shadowCatcher.visible = false;
    this.ptActive = true;
    this.pt.setScene(this.scene, this.camera);
    this._ptCam = this.camera.matrixWorld.clone();
  }

  stopRealRender() {
    if (!this.ptActive) return;
    this.ptActive = false;
    if (this._ptBg) { this.scene.background = this._ptBg.bg; this.scene.environment = this._ptBg.env; }
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
    if (preset === 'top') pos = new THREE.Vector3(b.cx, s * 1.55 + 4, b.cy + 0.01);
    else if (preset === 'front') pos = new THREE.Vector3(b.cx, s * 0.35 + 1.5, b.maxY + s * 1.0 + 3);
    else pos = this.isStudio() ? new THREE.Vector3(b.cx + s * 0.05, s * 1.3 + 2.5, b.maxY + s * 0.32 + 1) : new THREE.Vector3(b.cx + s * 0.08, s * 1.85 + 5, b.maxY + s * 0.45 + 1.5);
    this.flyTo(pos, target, smooth);
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
      if (!this.camera.matrixWorld.equals(this._ptCam)) { this._ptCam.copy(this.camera.matrixWorld); this.pt.updateCamera(); }
      this.pt.renderSample();
      this.onPTProgress?.(this.pt.samples);
      return;
    }
    if (this.state.ao) this.composer.render();
    else if (this.bloom.enabled) this.composer.render();
    else this.renderer.render(this.scene, this.camera);
    this.labelRenderer.render(this.scene, this.camera);
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

  async exportGLB() {
    const clone = this.built.root.clone(true);
    const drop = [];
    clone.traverse((o) => { if (o.userData.noExport || o.isCSS2DObject || o.isLight) drop.push(o); });
    drop.forEach((o) => o.parent && o.parent.remove(o));
    const exporter = new GLTFExporter();
    return exporter.parseAsync(clone, { binary: true });
  }
}
