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
import { getTexture } from './textures.js';
import { closestOnSegment, rotatePoint } from './geom.js';
import { CATALOG_MAP } from './furniture.js';
import { WebGLPathTracer, GradientEquirectTexture } from 'three-gpu-pathtracer';

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
    scene.environment = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
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
    r.setAnimationLoop(() => this.tick());
  }

  // ---------------- Dựng cảnh ----------------
  rebuild(animate = false) {
    const prev = this.built;
    if (prev) {
      this.scene.remove(prev.root);
      disposeTree(prev.root);
    }
    const built = buildScene(this.store.plan, { clippingPlanes: [this.clipPlane], ceiling: this.state.ceiling, landscape: this.state.landscape });
    // Giữ trạng thái đóng/mở cửa sau khi dựng lại
    if (prev) for (const d of built.doors) { const o = prev.doors.find((p) => p.op.id === d.op.id); if (o) { d.open = o.open; d.target = o.target; } }
    this.built = built;
    this.scene.add(built.root);
    this.applyExterior();
    this._above = undefined;
    if (this.ptActive) this.stopRealRender();
    built.labels.forEach((l) => (l.visible = this.state.labels));
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
    this.scene.environmentIntensity = 0.06 + 0.3 * day;
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
    this.isNight = night;
    this.applyLights();
  }

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
    if (key === 'ceiling' || key === 'landscape') this.rebuild();
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
    this.ground.visible = !high;
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
  startRealRender() {
    if (!this.built) return;
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
      this.scene.background = grad;
      this.scene.environment = grad;
    } else {
      this._ptBg = { bg: this.scene.background, env: this.scene.environment };
      this.scene.environment = this.extTex;
    }
    this.ptActive = true;
    this.pt.setScene(this.scene, this.camera);
    this._ptCam = this.camera.matrixWorld.clone();
  }

  stopRealRender() {
    if (!this.ptActive) return;
    this.ptActive = false;
    if (this._ptBg) { this.scene.background = this._ptBg.bg; this.scene.environment = this._ptBg.env; }
    this.built.root.traverse((o) => { if (o.userData.capBack) o.visible = true; });
    this.state.cut = this._ptSaved?.cut ?? 1;
    this.built.labels.forEach((l) => (l.visible = this._ptSaved?.labels ?? true));
    this.setHour(this.state.hour);
    this.updateClip();
    this.onPTStop?.();
  }

  // ---------------- Camera ----------------
  frameAll(smooth = true, preset = 'iso') {
    const b = this.built.bounds;
    const target = new THREE.Vector3(b.cx, 0.3, b.cy + (preset === 'iso' ? 0.4 : 0));
    const s = b.size;
    let pos;
    if (preset === 'top') pos = new THREE.Vector3(b.cx, s * 1.55 + 4, b.cy + 0.01);
    else if (preset === 'front') pos = new THREE.Vector3(b.cx, s * 0.35 + 1.5, b.maxY + s * 1.0 + 3);
    else pos = new THREE.Vector3(b.cx + s * 0.08, s * 1.85 + 5, b.maxY + s * 0.45 + 1.5);
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
    if (this.mode === 'walk') this.walk(dt);
    else this.controls.update();
    if (this.built) {
      const above = this.camera.position.y > this.built.height;
      if (above !== this._above) { this._above = above; this.built.root.traverse((o) => { if (o.userData.lampDisc) o.visible = !above; }); }
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
