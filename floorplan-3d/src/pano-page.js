// Trang "Toàn cảnh 4D": ảnh toàn cảnh (flycam, phối cảnh) dán lên mặt trụ / mặt cầu,
// người xem đứng ở tâm để kéo xoay, phóng to, tự lướt, xoay theo điện thoại và gắn nhãn.
// Ảnh tỉ lệ 2:1 được coi là ảnh 360° (mặt cầu); ảnh khác dán lên cung trụ vừa khít.
// Đổi ảnh qua tham số ?img=duong-dan.jpg&title=Ten
import * as THREE from 'three';

const params = new URLSearchParams(location.search);
const IMG = params.get('img') || './pano/toan-canh.jpg';
if (params.get('title')) document.getElementById('title').textContent = params.get('title');

// Nhãn mẫu cho ảnh mặc định: u, v = vị trí theo tỉ lệ ảnh (0..1, tính từ góc trên trái)
const DEFAULT_PINS = {
  './pano/toan-canh.jpg': [
    { u: 0.33, v: 0.64, label: 'Cầu dây văng' },
    { u: 0.38, v: 0.72, label: 'Tháp biểu tượng' },
    { u: 0.237, v: 0.83, label: 'Vòng quay' },
    { u: 0.565, v: 0.73, label: 'Khách sạn ven hồ' },
    { u: 0.93, v: 0.6, label: 'Bãi biển' },
    { u: 0.5, v: 0.23, label: 'Cửa biển' },
  ],
};
const pinKey = (src) => 'pano-pins:' + src;
const loadPins = (src) => {
  try { const s = localStorage.getItem(pinKey(src)); if (s) return JSON.parse(s); } catch {}
  return (DEFAULT_PINS[src] || []).map((p) => ({ ...p }));
};
const savePins = () => { try { localStorage.setItem(pinKey(state.src), JSON.stringify(state.pins)); } catch {} };

const stage = document.getElementById('stage');
const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
renderer.outputColorSpace = THREE.SRGBColorSpace;
stage.appendChild(renderer.domElement);
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(60, 1, 0.1, 100);
camera.rotation.order = 'YXZ';

// Shader: hiển thị ảnh + chế độ "đêm lung linh" (tối nền, đèn sáng lấp lánh)
const uniforms = { map: { value: null }, uNight: { value: 0 }, uTime: { value: 0 } };
const material = new THREE.ShaderMaterial({
  uniforms,
  side: THREE.DoubleSide,
  vertexShader: `varying vec2 vUv; void main(){ vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0); }`,
  fragmentShader: `
    uniform sampler2D map; uniform float uNight; uniform float uTime; varying vec2 vUv;
    float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1,311.7))) * 43758.5453); }
    void main(){
      vec3 c = texture2D(map, vUv).rgb;
      float lum = dot(c, vec3(0.299, 0.587, 0.114));
      float warm = smoothstep(0.45, 0.85, lum) * smoothstep(-0.02, 0.15, c.r - c.b);
      float tw = 0.65 + 0.35 * sin(uTime * 3.0 + hash(floor(vUv * vec2(900.0, 360.0))) * 6.283);
      vec3 night = c * mix(0.4, 1.0, smoothstep(0.35, 0.8, lum)) * vec3(0.85, 0.9, 1.08)
                 + vec3(1.0, 0.72, 0.35) * warm * tw * 0.55;
      gl_FragColor = vec4(mix(c, night, uNight), 1.0);
      #include <colorspace_fragment>
    }`,
});

const state = {
  src: IMG, pins: [], showPins: true, adding: false,
  yaw: 0, pitch: 0, fov: 60,
  mode: 'cyl', span: Math.PI, vHalf: 0.5, // span: cung ngang (rad); vHalf: nửa góc đứng (rad)
  tour: true, tourT: 0, idleSince: 0, gyro: null, night: 0, nightTarget: 0,
};
let mesh = null;

function buildMesh(tex) {
  const { width: w, height: h } = tex.image;
  const aspect = w / h;
  if (mesh) { scene.remove(mesh); mesh.geometry.dispose(); }
  let geo;
  if (Math.abs(aspect - 2) < 0.06) {
    // Ảnh 360° chuẩn
    state.mode = 'sphere'; state.span = Math.PI * 2; state.vHalf = Math.PI / 2;
    geo = new THREE.SphereGeometry(10, 96, 64);
  } else {
    // Ảnh rộng thường: chọn cung ngang theo tỉ lệ ảnh, chiều cao giữ đúng tỉ lệ
    state.mode = 'cyl';
    state.span = THREE.MathUtils.clamp(aspect * THREE.MathUtils.degToRad(60), THREE.MathUtils.degToRad(80), Math.PI * 2);
    const R = 10, H = (R * state.span) / aspect;
    state.vHalf = Math.atan(H / 2 / R);
    geo = new THREE.CylinderGeometry(R, R, H, 128, 1, true, Math.PI - state.span / 2, state.span);
  }
  geo.scale(-1, 1, 1); // nhìn từ trong ra: lật ảnh cho đúng chiều
  mesh = new THREE.Mesh(geo, material);
  if (state.mode === 'sphere') mesh.rotation.y = -Math.PI / 2;
  scene.add(mesh);
  uniforms.map.value = tex;
  state.yaw = 0; state.pitch = state.mode === 'sphere' ? 0 : -state.vHalf * 0.25;
  state.fov = maxFov();
  document.getElementById('mini').style.backgroundImage = `url("${tex.image.src}")`;
}

// Chuyển giữa (u,v) trên ảnh và góc nhìn (yaw, pitch)
function uvToAngles(u, v) {
  const yaw = state.mode === 'sphere' ? (0.5 - u) * Math.PI * 2 : (0.5 - u) * state.span;
  const pitch = state.mode === 'sphere'
    ? (0.5 - v) * Math.PI
    : Math.atan(Math.tan(state.vHalf) * (1 - 2 * v));
  return { yaw, pitch };
}
function anglesToUv(yaw, pitch) {
  const u = state.mode === 'sphere' ? 0.5 - yaw / (Math.PI * 2) : 0.5 - yaw / state.span;
  const v = state.mode === 'sphere' ? 0.5 - pitch / Math.PI : (1 - Math.tan(pitch) / Math.tan(state.vHalf)) / 2;
  return { u, v };
}
const dirFromAngles = (yaw, pitch) =>
  new THREE.Vector3(-Math.sin(yaw) * Math.cos(pitch), Math.sin(pitch), -Math.cos(yaw) * Math.cos(pitch));

// Giới hạn khung nhìn để không lộ ra ngoài mép ảnh
const hFov = (vfovRad) => 2 * Math.atan(Math.tan(vfovRad / 2) * camera.aspect);
function maxFov() {
  if (state.mode === 'sphere') return 75;
  let v = Math.min(2 * state.vHalf * 0.98, THREE.MathUtils.degToRad(75));
  while (hFov(v) > state.span * 0.98 && v > 0.1) v *= 0.97;
  return THREE.MathUtils.radToDeg(v);
}
function clampView() {
  state.fov = THREE.MathUtils.clamp(state.fov, 15, maxFov());
  if (state.mode === 'sphere') { state.pitch = THREE.MathUtils.clamp(state.pitch, -1.45, 1.45); return; }
  const v = THREE.MathUtils.degToRad(state.fov);
  const yMax = Math.max(0, state.span / 2 - hFov(v) / 2);
  const pMax = Math.max(0, state.vHalf - v / 2);
  state.yaw = THREE.MathUtils.clamp(state.yaw, -yMax, yMax);
  state.pitch = THREE.MathUtils.clamp(state.pitch, -pMax, pMax);
}

// ---------- Nhãn địa điểm ----------
const pinsEl = document.getElementById('pins');
function renderPins() {
  pinsEl.innerHTML = '';
  state.pins.forEach((p, i) => {
    const el = document.createElement('div');
    el.className = 'pin';
    el.innerHTML = `<b></b><span></span><em></em>`;
    el.querySelector('b').textContent = p.label;
    el.title = 'Nhấn để bay tới · nhấn giữ để sửa / xoá';
    let hold;
    el.addEventListener('pointerdown', (e) => { e.stopPropagation(); hold = setTimeout(() => { hold = null; editPin(i); }, 600); });
    el.addEventListener('pointerup', (e) => { e.stopPropagation(); if (hold) { clearTimeout(hold); flyTo(p); } });
    pinsEl.appendChild(el);
    p.el = el;
  });
}
function editPin(i) {
  const p = state.pins[i];
  const name = prompt('Sửa tên nhãn (để trống để xoá):', p.label);
  if (name === null) return;
  if (name.trim()) p.label = name.trim(); else state.pins.splice(i, 1);
  savePins(); renderPins();
}
const tmp = new THREE.Vector3();
function updatePins() {
  const w = innerWidth, h = innerHeight;
  for (const p of state.pins) {
    if (!p.el) continue;
    const a = uvToAngles(p.u, p.v);
    tmp.copy(dirFromAngles(a.yaw, a.pitch)).multiplyScalar(5);
    const front = tmp.clone().applyMatrix4(camera.matrixWorldInverse).z < 0;
    tmp.project(camera);
    const vis = state.showPins && front && Math.abs(tmp.x) < 1.1 && Math.abs(tmp.y) < 1.1;
    p.el.style.display = vis ? '' : 'none';
    if (vis) p.el.style.left = ((tmp.x + 1) / 2) * w + 'px', p.el.style.top = ((1 - tmp.y) / 2) * h + 'px';
  }
}

// Bay mượt tới một nhãn
let fly = null;
function flyTo(p) {
  const a = uvToAngles(p.u, p.v);
  fly = { t: 0, from: { yaw: state.yaw, pitch: state.pitch, fov: state.fov }, to: { yaw: a.yaw, pitch: a.pitch, fov: Math.max(22, maxFov() * 0.5) } };
  stopTour();
}

// ---------- Điều khiển chuột / cảm ứng ----------
const pointers = new Map();
let last = null, pinchDist = 0, moved = 0;
stage.addEventListener('pointerdown', (e) => {
  stage.setPointerCapture(e.pointerId);
  pointers.set(e.pointerId, { x: e.clientX, y: e.clientY });
  last = { x: e.clientX, y: e.clientY }; moved = 0;
  stage.classList.add('drag'); stopTour(); fly = null; hideHint();
  if (pointers.size === 2) { const [a, b] = [...pointers.values()]; pinchDist = Math.hypot(a.x - b.x, a.y - b.y); }
});
stage.addEventListener('pointermove', (e) => {
  if (!pointers.has(e.pointerId)) return;
  pointers.set(e.pointerId, { x: e.clientX, y: e.clientY });
  if (pointers.size === 2) {
    const [a, b] = [...pointers.values()];
    const d = Math.hypot(a.x - b.x, a.y - b.y);
    if (pinchDist) state.fov *= pinchDist / d;
    pinchDist = d; moved += 10; return;
  }
  const dx = e.clientX - last.x, dy = e.clientY - last.y;
  moved += Math.abs(dx) + Math.abs(dy);
  const k = THREE.MathUtils.degToRad(state.fov) / innerHeight;
  state.yaw += dx * k; state.pitch += dy * k;
  last = { x: e.clientX, y: e.clientY };
  state.idleSince = performance.now();
});
const endPointer = (e) => {
  pointers.delete(e.pointerId);
  if (pointers.size < 2) pinchDist = 0;
  if (!pointers.size) stage.classList.remove('drag');
  if (pointers.size === 1) last = { ...[...pointers.values()][0] };
  if (e.type === 'pointerup' && moved < 6 && state.adding) addPinAt(e.clientX, e.clientY);
  state.idleSince = performance.now();
};
stage.addEventListener('pointerup', endPointer);
stage.addEventListener('pointercancel', endPointer);
stage.addEventListener('wheel', (e) => { e.preventDefault(); state.fov *= Math.exp(e.deltaY * 0.001); stopTour(); state.idleSince = performance.now(); }, { passive: false });
stage.addEventListener('dblclick', () => { state.fov = state.fov < maxFov() * 0.7 ? maxFov() : maxFov() * 0.45; });

const ray = new THREE.Raycaster();
function addPinAt(x, y) {
  ray.setFromCamera(new THREE.Vector2((x / innerWidth) * 2 - 1, -(y / innerHeight) * 2 + 1), camera);
  const hit = ray.intersectObject(mesh)[0];
  if (!hit) return;
  const a = new THREE.Vector3().copy(hit.point).normalize();
  const yaw = Math.atan2(-a.x, -a.z), pitch = Math.asin(a.y);
  const { u, v } = anglesToUv(yaw, pitch);
  const label = prompt('Tên địa điểm:');
  if (!label?.trim()) return;
  state.pins.push({ u: +u.toFixed(4), v: +v.toFixed(4), label: label.trim() });
  savePins(); renderPins();
}

// Bản đồ thu nhỏ: khung đang xem, nhấn để nhảy tới
const mini = document.getElementById('mini'), miniBox = document.getElementById('miniBox');
function updateMini() {
  const v = THREE.MathUtils.degToRad(state.fov);
  const a = anglesToUv(state.yaw + hFov(v) / 2, state.pitch + v / 2);
  const b = anglesToUv(state.yaw - hFov(v) / 2, state.pitch - v / 2);
  const cl = (x) => Math.min(1, Math.max(0, x)) * 100;
  Object.assign(miniBox.style, { left: cl(a.u) + '%', width: cl(b.u) - cl(a.u) + '%', top: cl(a.v) + '%', height: cl(b.v) - cl(a.v) + '%' });
}
mini.addEventListener('click', (e) => {
  const r = mini.getBoundingClientRect();
  flyTo({ u: (e.clientX - r.left) / r.width, v: (e.clientY - r.top) / r.height });
  fly.to.fov = state.fov;
});

// ---------- Nút chức năng ----------
const $ = (id) => document.getElementById(id);
function toast(msg) { const t = $('toast'); t.textContent = msg; t.classList.add('show'); clearTimeout(toast.t); toast.t = setTimeout(() => t.classList.remove('show'), 2200); }
function hideHint() { $('hint').style.opacity = 0; }
function stopTour() { if (state.tour) { state.tour = false; $('tourBtn').classList.remove('active'); $('tourBtn').textContent = '▶ Tự lướt'; } }
$('tourBtn').onclick = () => {
  state.tour = !state.tour;
  $('tourBtn').classList.toggle('active', state.tour);
  $('tourBtn').textContent = state.tour ? '⏸ Dừng lướt' : '▶ Tự lướt';
  if (state.tour) { state.tourT = Math.asin(THREE.MathUtils.clamp(state.yaw / (tourRange() || 1), -1, 1)); }
};
$('tourBtn').textContent = '⏸ Dừng lướt';
const tourRange = () => {
  if (state.mode === 'sphere') return Infinity;
  return Math.max(0, state.span / 2 - hFov(THREE.MathUtils.degToRad(state.fov)) / 2);
};
$('pinBtn').onclick = () => { state.showPins = !state.showPins; $('pinBtn').classList.toggle('active', state.showPins); };
$('addBtn').onclick = () => {
  state.adding = !state.adding;
  $('addBtn').classList.toggle('active', state.adding);
  stage.classList.toggle('adding', state.adding);
  if (state.adding) { stopTour(); toast('Chạm vào vị trí trên ảnh để gắn nhãn'); }
};
$('nightBtn').onclick = () => { state.nightTarget = state.nightTarget ? 0 : 1; $('nightBtn').classList.toggle('active', !!state.nightTarget); };
$('fullBtn').onclick = () => (document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen?.());
$('shotBtn').onclick = () => {
  renderer.render(scene, camera);
  renderer.domElement.toBlob((b) => {
    const a = document.createElement('a');
    a.href = URL.createObjectURL(b); a.download = 'toan-canh.png'; a.click();
    setTimeout(() => URL.revokeObjectURL(a.href), 1000);
  });
};
$('file').onchange = (e) => {
  const f = e.target.files[0];
  if (f) load(URL.createObjectURL(f), 'file:' + f.name);
};

// Xoay theo điện thoại (con quay hồi chuyển)
$('gyroBtn').onclick = async () => {
  if (state.gyro) { removeEventListener('deviceorientation', onOrient); state.gyro = null; $('gyroBtn').classList.remove('active'); return; }
  try {
    if (typeof DeviceOrientationEvent?.requestPermission === 'function' && (await DeviceOrientationEvent.requestPermission()) !== 'granted') throw 0;
  } catch { toast('Chưa được cấp quyền cảm biến xoay'); return; }
  if (!('DeviceOrientationEvent' in window)) { toast('Máy này không có cảm biến xoay'); return; }
  state.gyro = { base: null };
  addEventListener('deviceorientation', onOrient);
  $('gyroBtn').classList.add('active'); stopTour(); toast('Nghiêng / xoay điện thoại để ngắm');
};
function onOrient(e) {
  if (e.alpha == null) return;
  const g = state.gyro;
  if (!g.base) { g.base = { a: e.alpha, b: e.beta, yaw: state.yaw, pitch: state.pitch }; return; }
  let da = e.alpha - g.base.a; if (da > 180) da -= 360; if (da < -180) da += 360;
  state.yaw = g.base.yaw + THREE.MathUtils.degToRad(da);
  state.pitch = g.base.pitch + THREE.MathUtils.degToRad(e.beta - g.base.b);
  clampView();
  // chạm biên thì dời mốc để không bị "kẹt"
  g.base.yaw += state.yaw - (g.base.yaw + THREE.MathUtils.degToRad(da));
  g.base.pitch += state.pitch - (g.base.pitch + THREE.MathUtils.degToRad(e.beta - g.base.b));
}

// ---------- Vòng lặp ----------
function resize() {
  renderer.setSize(innerWidth, innerHeight);
  camera.aspect = innerWidth / innerHeight;
  if (mesh) clampView();
}
addEventListener('resize', resize);

const clock = new THREE.Timer();
function tick() {
  clock.update();
  const dt = Math.min(clock.getDelta(), 0.1);
  uniforms.uTime.value += dt;
  state.night += (state.nightTarget - state.night) * Math.min(1, dt * 3);
  uniforms.uNight.value = state.night;
  if (mesh) {
    if (fly) {
      fly.t = Math.min(1, fly.t + dt / 1.4);
      const e = fly.t < 0.5 ? 4 * fly.t ** 3 : 1 - (-2 * fly.t + 2) ** 3 / 2;
      for (const k of ['yaw', 'pitch', 'fov']) state[k] = fly.from[k] + (fly.to[k] - fly.from[k]) * e;
      if (fly.t >= 1) fly = null;
    } else if (state.tour) {
      // Lướt qua lại chậm rãi, kèm "thở" zoom nhẹ
      state.tourT += dt * 0.12;
      const r = tourRange();
      if (r === Infinity) state.yaw += dt * 0.08;
      else state.yaw = Math.sin(state.tourT) * r;
      state.fov += (maxFov() * (0.85 + 0.1 * Math.cos(state.tourT * 2)) - state.fov) * dt;
    } else if (!state.gyro && !state.adding && !pointers.size && performance.now() - state.idleSince > 12000) {
      $('tourBtn').click(); // để yên 12 giây thì tự lướt lại
    }
    clampView();
    camera.fov = state.fov;
    camera.updateProjectionMatrix();
    camera.rotation.set(state.pitch, state.yaw, 0);
    camera.updateMatrixWorld();
    updatePins();
    updateMini();
  }
  renderer.render(scene, camera);
  requestAnimationFrame(tick);
}

function load(url, key = url) {
  new THREE.TextureLoader().load(url, (tex) => {
    tex.colorSpace = THREE.SRGBColorSpace;
    tex.anisotropy = renderer.capabilities.getMaxAnisotropy();
    tex.minFilter = THREE.LinearMipmapLinearFilter;
    uniforms.map.value?.dispose();
    state.src = key;
    buildMesh(tex);
    state.pins = loadPins(key);
    renderPins();
    clampView();
  }, undefined, () => toast('Không tải được ảnh: ' + url));
}

resize();
load(IMG);
state.idleSince = performance.now();
setTimeout(hideHint, 3500);
tick();
