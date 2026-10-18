// Chuyển dữ liệu mặt bằng 2D thành cảnh 3D (tường có ô cửa, sàn theo phòng, trần, cửa, nội thất, cảnh quan)
import * as THREE from 'three';
import { mergeGeometries } from 'three/examples/jsm/utils/BufferGeometryUtils.js';
import { CSS2DObject } from 'three/examples/jsm/renderers/CSS2DRenderer.js';
import { wallLength, openingRange, labelPoint, polygonArea, planBounds, pointInPolygon, closestOnSegment, fmt } from './geom.js';
import { floorMaterial, getTexture } from './textures.js';
import { buildFurniture3D, CATALOG_MAP, mat, setPalette } from './furniture.js';
import { resolvePalette } from './styles.js';
import { placePeople } from './people.js';

const wallMat = new THREE.MeshStandardMaterial({ color: 0xf4efe6, roughness: 0.9, map: getTexture('plaster') });
const capMat = new THREE.MeshBasicMaterial({ color: 0x2f3237, side: THREE.BackSide });

/**
 * Mặt cắt kiểu phối cảnh bán hàng (dollhouse): tường bao phía gần camera hạ thấp còn ~1 m để thấy rõ nội thất,
 * vách ngăn trong cũng hạ thấp; chỉ tường bao phía xa giữ cao làm nền. aFace = (pháp tuyến ngoài x, z, cờ: 1 tường bao, 2 vách trong).
 */
export const CUTAWAY = { on: { value: 0 }, dir: { value: new THREE.Vector2(0, 1) }, low: { value: 1.0 } };
function cutawayShader(material) {
  const prev = material.onBeforeCompile;
  material.onBeforeCompile = (sh, r) => {
    prev?.(sh, r);
    sh.uniforms.uCutOn = CUTAWAY.on; sh.uniforms.uCutDir = CUTAWAY.dir; sh.uniforms.uCutLow = CUTAWAY.low;
    sh.vertexShader = 'attribute vec3 aFace;\nvarying vec3 vFace;\nvarying float vCutY;\n' + sh.vertexShader.replace('#include <project_vertex>', '#include <project_vertex>\nvFace = aFace;\nvCutY = (modelMatrix * vec4(transformed, 1.0)).y;');
    sh.fragmentShader = 'uniform float uCutOn;\nuniform vec2 uCutDir;\nuniform float uCutLow;\nvarying vec3 vFace;\nvarying float vCutY;\n' + sh.fragmentShader.replace('void main() {', 'void main() {\n  if (uCutOn > 0.5 && vCutY > uCutLow && (vFace.z > 1.5 || (vFace.z > 0.5 && dot(vFace.xy, uCutDir) < -0.2))) discard;');
  };
  material.customProgramCacheKey = () => 'cutaway';
}

const frameMat = new THREE.MeshStandardMaterial({ color: 0x3a3f46, roughness: 0.35, metalness: 0.6 });
const doorFrameMat = new THREE.MeshStandardMaterial({ color: 0xe9e2d6, roughness: 0.5 });
const doorLeafMat = new THREE.MeshStandardMaterial({ color: 0x8b5a36, roughness: 0.45, map: getTexture('woodGrain') });
const topCapMat = new THREE.MeshStandardMaterial({ color: 0x3a3b3e, roughness: 0.85 });
const skirtMat = new THREE.MeshStandardMaterial({ color: 0xe0dbd2, roughness: 0.5 });
const ledMat = new THREE.MeshStandardMaterial({ color: 0x000000, emissive: 0xffcf8f, emissiveIntensity: 3 });
const rodMat = new THREE.MeshStandardMaterial({ color: 0x2b2b2b, roughness: 0.3, metalness: 0.8 });
const handleMat = new THREE.MeshStandardMaterial({ color: 0xd9d9d9, roughness: 0.2, metalness: 1 });
const glassMat = new THREE.MeshStandardMaterial({ color: 0xa9d6ea, roughness: 0.03, metalness: 0.4, transparent: true, opacity: 0.22, depthWrite: false, emissive: 0xffc77a, emissiveIntensity: 0 });
const ceilingMat = new THREE.MeshStandardMaterial({ color: 0xfbfaf7, roughness: 0.95, side: THREE.BackSide, emissive: 0x4a4844 });
const lampMat = new THREE.MeshStandardMaterial({ color: 0xffffff, emissive: 0xfff0d0, emissiveIntensity: 0 });
const slabMat = new THREE.MeshStandardMaterial({ color: 0xbdb7ad, roughness: 0.9, map: getTexture('concrete') });
const pavingMat = new THREE.MeshStandardMaterial({ map: getTexture('paving'), roughness: 0.85 });
const trunkMat = new THREE.MeshStandardMaterial({ color: 0x6b4a32, roughness: 0.9 });
const crownMats = [0x4e8f3a, 0x3d7a33, 0x67a547].map((c) => new THREE.MeshStandardMaterial({ color: c, roughness: 0.85, flatShading: true }));

cutawayShader(wallMat);
cutawayShader(capMat);

export const SHARED = { wallMat, capMat, glassMat, lampMat, frameMat, doorFrameMat, doorLeafMat, ceilingMat, ledMat, topCapMat };

function shadowy(m, cast = true, receive = true) {
  m.castShadow = cast;
  m.receiveShadow = receive;
  return m;
}

/** Ma trận đặt hệ toạ độ cục bộ của tường: x dọc tường, z xuyên tường, y lên trên */
function wallMatrix(w) {
  const ang = Math.atan2(w.b.y - w.a.y, w.b.x - w.a.x);
  const m = new THREE.Matrix4().makeRotationY(-ang);
  m.setPosition(w.a.x, 0, w.a.y);
  return m;
}

/** UV theo mét (ngang = dọc tường, dọc = chiều cao) để vân ốp tường không bị kéo giãn */
function meterUV(g) {
  const p = g.attributes.position, n = g.attributes.normal, uv = g.attributes.uv;
  for (let i = 0; i < p.count; i++) {
    const nx = Math.abs(n.getX(i)), ny = Math.abs(n.getY(i));
    if (ny > 0.5) uv.setXY(i, p.getX(i), p.getZ(i));
    else if (nx > 0.5) uv.setXY(i, p.getZ(i), p.getY(i));
    else uv.setXY(i, p.getX(i), p.getY(i));
  }
  uv.needsUpdate = true;
}

const isRailing = (op) => op.gap || (op.type === 'window' && (op.sill || 0) <= 0.1 && op.height <= 1.3);

function wallPieces(w, ops, H) {
  const L = wallLength(w);
  const t = w.thickness;
  const ranges = ops.map((op) => ({ op, r: openingRange(w, op) })).sort((p, q) => p.r[0] - q.r[0]);
  const pieces = [];
  let cur = 0;
  for (const { op, r } of ranges) {
    const s = Math.max(r[0], cur), e = Math.max(r[1], s);
    if (s > cur + 1e-4) pieces.push([cur, s, 0, H]);
    const sill = Math.max(0, Math.min(op.sill || 0, H));
    // Lan can lô gia: phía trên để trống (thoáng như phối cảnh), không xây lanh tô
    const top = isRailing(op) ? H : Math.min(H, sill + op.height);
    if (sill > 1e-4) pieces.push([s, e, 0, sill]);
    if (top < H - 1e-4) pieces.push([s, e, top, H]);
    cur = e;
  }
  if (cur < L - 1e-4) pieces.push([cur, L, 0, H]);
  return pieces.map(([u0, u1, y0, y1]) => {
    if (u0 <= 1e-4) u0 = -t / 2;
    if (u1 >= L - 1e-4) u1 = L + t / 2;
    return [u0, u1, y0, y1];
  });
}

/** Lan can lô-gia dạng lam đứng (sill thấp, cao ~1 m) */
function buildRailing(op, w) {
  const g = new THREE.Group();
  const h = Math.max(1.0, op.height);
  const n = Math.max(2, Math.round(op.width / 0.11));
  const geo = new THREE.BoxGeometry(0.035, h, 0.07);
  for (let i = 0; i <= n; i++) {
    const m = shadowy(new THREE.Mesh(geo, frameMat));
    m.position.set(-op.width / 2 + (op.width * i) / n, h / 2, 0);
    g.add(m);
  }
  const top = shadowy(new THREE.Mesh(new THREE.BoxGeometry(op.width, 0.05, 0.09), frameMat));
  top.position.set(0, h, 0);
  g.add(top);
  void w;
  return g;
}

function buildWindow(op, w, H) {
  if (op.gap) return new THREE.Group(); // lối thông trống (vd. lô gia ra sân vườn)
  if ((op.sill || 0) <= 0.1 && op.height <= 1.3) return buildRailing(op, w);
  const g = new THREE.Group();
  const width = op.width, h = Math.min(op.height, H - op.sill), fw = 0.055, fd = Math.min(0.09, w.thickness);
  const add = (m) => (g.add(shadowy(m)), m);
  const fb = (bw, bh, bd, x, y, z = 0, material = frameMat) => add(new THREE.Mesh(new THREE.BoxGeometry(bw, bh, bd), material)).position.set(x, y, z);
  const y0 = op.sill, y1 = op.sill + h;
  if (op.glass) {
    // Kính cong: kính liền không khung
    const gp = new THREE.Mesh(new THREE.PlaneGeometry(width + 0.06, h), glassMat);
    gp.position.set(0, (y0 + y1) / 2, 0);
    gp.material.side = THREE.DoubleSide;
    gp.renderOrder = 2;
    g.add(gp);
    return g;
  }
  fb(width, fw, fd, 0, y0 + fw / 2);
  fb(width, fw, fd, 0, y1 - fw / 2);
  fb(fw, h, fd, -width / 2 + fw / 2, (y0 + y1) / 2);
  fb(fw, h, fd, width / 2 - fw / 2, (y0 + y1) / 2);
  const panes = width > 1.7 ? 3 : width > 0.9 ? 2 : 1;
  for (let i = 1; i < panes; i++) fb(fw * 0.8, h, fd * 0.8, -width / 2 + (width * i) / panes, (y0 + y1) / 2);
  if (h > 1.2) fb(width, fw * 0.8, fd * 0.8, 0, y0 + h * 0.72);
  // Bệ cửa sổ
  fb(width + 0.1, 0.04, w.thickness + 0.08, 0, y0 - 0.02, 0, doorFrameMat);
  const glass = new THREE.Mesh(new THREE.PlaneGeometry(width - fw, h - fw), glassMat);
  glass.position.set(0, (y0 + y1) / 2, 0);
  glass.material.side = THREE.DoubleSide;
  glass.renderOrder = 2;
  g.add(glass);
  return g;
}

function buildDoor(op, w, H, interactive) {
  const g = new THREE.Group();
  const width = op.width, h = Math.min(op.height, H), fw = 0.06, fd = w.thickness + 0.03;
  const jamb = (x) => { const m = shadowy(new THREE.Mesh(new THREE.BoxGeometry(fw, h, fd), doorFrameMat)); m.position.set(x, h / 2, 0); g.add(m); };
  jamb(-width / 2 + fw / 2); jamb(width / 2 - fw / 2);
  const head = shadowy(new THREE.Mesh(new THREE.BoxGeometry(width, fw, fd), doorFrameMat));
  head.position.set(0, h - fw / 2, 0);
  g.add(head);
  const lw = width - fw * 2, lh = h - fw - 0.01;
  const hingeX = op.flip ? width / 2 - fw : -width / 2 + fw;
  const pivot = new THREE.Group();
  pivot.position.set(hingeX, 0, 0);
  g.add(pivot);
  const leaf = shadowy(new THREE.Mesh(new THREE.BoxGeometry(lw, lh, 0.045), doorLeafMat));
  const sx = op.flip ? -1 : 1;
  leaf.position.set(sx * lw / 2, lh / 2 + 0.005, 0);
  pivot.add(leaf);
  // Ô trang trí + tay nắm
  for (const yy of [0.3, 0.7]) {
    const panel = new THREE.Mesh(new THREE.BoxGeometry(lw * 0.62, lh * 0.3, 0.052), doorLeafMat);
    panel.position.set(sx * lw / 2, lh * yy, 0);
    pivot.add(panel);
  }
  for (const zz of [-1, 1]) {
    const hd = new THREE.Mesh(new THREE.BoxGeometry(0.13, 0.02, 0.02), handleMat);
    hd.position.set(sx * (lw - 0.1), 1.0, zz * 0.045);
    pivot.add(hd);
  }
  leaf.userData.door = interactive;
  interactive.pivot = pivot;
  interactive.sign = (op.flip ? 1 : -1) * (op.swingOut ? -1 : 1);
  interactive.mesh = leaf;
  return g;
}

function buildSlide(op, w, H, interactive) {
  const g = new THREE.Group();
  const width = op.width, h = Math.min(op.height, H), fw = 0.06, fd = Math.min(0.12, w.thickness);
  const fb = (bw, bh, bd, x, y, z = 0, parent = g) => { const m = shadowy(new THREE.Mesh(new THREE.BoxGeometry(bw, bh, bd), frameMat)); m.position.set(x, y, z); parent.add(m); return m; };
  fb(width, fw, fd, 0, fw / 2); fb(width, fw, fd, 0, h - fw / 2);
  fb(fw, h, fd, -width / 2 + fw / 2, h / 2); fb(fw, h, fd, width / 2 - fw / 2, h / 2);
  const pw = (width - fw * 2) / 2 + 0.03;
  const panels = [];
  for (const [i, z] of [[0, -0.025], [1, 0.025]]) {
    const p = new THREE.Group();
    p.position.set(-width / 2 + fw + pw / 2 + i * (pw - 0.06), 0, z);
    fb(0.04, h - fw * 2, 0.04, -pw / 2 + 0.02, h / 2, 0, p);
    fb(0.04, h - fw * 2, 0.04, pw / 2 - 0.02, h / 2, 0, p);
    const gl = new THREE.Mesh(new THREE.PlaneGeometry(pw - 0.06, h - fw * 2), glassMat);
    gl.position.set(0, h / 2, 0);
    gl.renderOrder = 2;
    gl.userData.door = interactive;
    p.add(gl);
    g.add(p);
    panels.push(p);
  }
  interactive.slidePanel = panels[1];
  interactive.slideBase = panels[1].position.x;
  interactive.slideDist = -(pw - 0.1);
  interactive.mesh = panels[1].children[2];
  return g;
}

function insideAnyRoom(plan, p) { return plan.rooms.some((r) => pointInPolygon(p, r.points)); }
const OUTDOOR = /lô gia|ban công|sân vườn|logia/i;
function insideIndoor(plan, p) { return plan.rooms.some((r) => !OUTDOOR.test(r.name || '') && pointInPolygon(p, r.points)); }
/** Pháp tuyến ngoài của tường bao (một phía là trong nhà, phía kia là ngoài trời / lô gia) – dùng cho mặt cắt dollhouse */
function makeCutFace(plan) {
  const xs = plan.walls.flatMap((w) => [w.a.x, w.b.x]), ys = plan.walls.flatMap((w) => [w.a.y, w.b.y]);
  const bb = { x0: Math.min(...xs), y0: Math.min(...ys), x1: Math.max(...xs), y1: Math.max(...ys) };
  return (w, L, wh, ops = []) => {
    if (wh < 1.5) return null; // lan can, tường lửng: giữ nguyên
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L, nx = -dy, ny = dx;
    let plus = 0, minus = 0;
    for (const t of [0.2, 0.5, 0.8]) {
      const c = { x: w.a.x + (w.b.x - w.a.x) * t, y: w.a.y + (w.b.y - w.a.y) * t }, o = w.thickness / 2 + 0.25;
      plus += insideIndoor(plan, { x: c.x + nx * o, y: c.y + ny * o }) ? 1 : 0;
      minus += insideIndoor(plan, { x: c.x - nx * o, y: c.y - ny * o }) ? 1 : 0;
    }
    // chỉ tường nằm ở vỏ ngoài cùng của căn (đi ra 1,2 m là ra khỏi khung căn) – vách hộp kỹ thuật, vách lô gia… coi như vách trong
    const mx = (w.a.x + w.b.x) / 2, my = (w.a.y + w.b.y) / 2;
    const reach = ops.some((o) => o.glass) ? 1.2 : 0.35; // mảng kính cong ở góc bo: cho phép xa mép khung hơn
    const outside = (sg) => { const q = { x: mx + sg * nx * reach, y: my + sg * ny * reach }; return q.x < bb.x0 || q.x > bb.x1 || q.y < bb.y0 || q.y > bb.y1; };
    if (plus >= 2 && minus <= 0 && outside(-1)) return { x: -nx, z: -ny };
    if (minus >= 2 && plus <= 0 && outside(1)) return { x: nx, z: ny };
    return { x: 0, z: 0, inner: true }; // vách ngăn trong
  };
}
function faceAttr(g, f) {
  const n = g.attributes.position.count, a = new Float32Array(n * 3);
  if (f) for (let i = 0; i < n; i++) { a[i * 3] = f.x; a[i * 3 + 1] = f.z; a[i * 3 + 2] = f.inner ? 2 : 1; }
  g.setAttribute('aFace', new THREE.BufferAttribute(a, 3));
}
function roomAreaAt(plan, p) { const r = plan.rooms.find((x) => pointInPolygon(p, x.points)); return r ? polygonArea(r.points) : 0; }

/** Tấm vải có nếp gấp (sóng sin) – mặt phẳng theo trục x, cao theo y */
function foldedCloth(width, height, folds, depth, material) {
  const seg = Math.max(8, Math.ceil(width / 0.03));
  const g = new THREE.PlaneGeometry(width, height, seg, 1);
  const pos = g.attributes.position;
  for (let i = 0; i < pos.count; i++) pos.setZ(i, Math.sin((pos.getX(i) / width + 0.5) * folds * Math.PI * 2) * depth);
  g.computeVertexNormals();
  const m = new THREE.Mesh(g, material);
  m.castShadow = true;
  m.receiveShadow = true;
  return m;
}

const curtainMats = new Map();
function curtainMat(color, sheer) {
  const key = color + sheer;
  if (!curtainMats.has(key)) curtainMats.set(key, new THREE.MeshStandardMaterial({ color, roughness: 1, side: THREE.DoubleSide, transparent: sheer, opacity: sheer ? 0.42 : 1, depthWrite: !sheer, map: getTexture('fabric') }));
  return curtainMats.get(key);
}

/** Rèm voan + 2 tấm rèm dày hai bên + thanh treo (hệ toạ độ cục bộ của tường) */
function buildCurtains(op, w, H, side, pal) {
  const g = new THREE.Group();
  const top = Math.min(H - 0.06, op.sill + op.height + 0.25);
  const bottom = 0.015;
  const h = top - bottom;
  const z = side * (w.thickness / 2 + 0.09);
  const width = op.width + 0.3;
  // Cửa kính lùa: rèm kéo gọn hai bên để thấy view; cửa sổ: có lớp voan mỏng
  if (op.type !== 'slide') {
    const sheer = foldedCloth(width, h, Math.round(width / 0.14), 0.025, curtainMat(pal.curtain, true));
    sheer.position.set(0, bottom + h / 2, z);
    sheer.renderOrder = 3;
    g.add(sheer);
  }
  for (const sx of [-1, 1]) {
    const dw = 0.42;
    const d = foldedCloth(dw, h, 3, 0.045, curtainMat(pal.drape, false));
    d.position.set(sx * (width / 2 + dw / 2 - 0.12), bottom + h / 2, z + side * 0.07);
    g.add(d);
  }
  const rod = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, width + 0.7, 10), rodMat);
  rod.rotation.z = Math.PI / 2;
  rod.position.set(0, top + 0.02, z + side * 0.03);
  g.add(rod);
  g.traverse((o) => { if (o.material && o.material !== rodMat) o.material.clippingPlanes = rodMat.clippingPlanes; });
  return g;
}

function buildTree(rnd) {
  const g = new THREE.Group();
  const h = 1.6 + rnd() * 1.4;
  const trunk = shadowy(new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.13, h, 8), trunkMat));
  trunk.position.y = h / 2;
  g.add(trunk);
  const n = 3 + Math.floor(rnd() * 3);
  for (let i = 0; i < n; i++) {
    const r = 0.7 + rnd() * 0.6;
    const c = shadowy(new THREE.Mesh(new THREE.IcosahedronGeometry(r, 1), crownMats[i % 3]));
    c.position.set((rnd() - 0.5) * 0.9, h + (rnd() - 0.2) * 0.8, (rnd() - 0.5) * 0.9);
    g.add(c);
  }
  return g;
}

function buildShrub(rnd) {
  const g = new THREE.Group();
  for (let i = 0; i < 3; i++) {
    const r = 0.25 + rnd() * 0.25;
    const c = shadowy(new THREE.Mesh(new THREE.IcosahedronGeometry(r, 1), crownMats[(i + 1) % 3]));
    c.position.set((rnd() - 0.5) * 0.5, r * 0.8, (rnd() - 0.5) * 0.5);
    g.add(c);
  }
  return g;
}

function seeded(seed) {
  let s = seed >>> 0;
  return () => ((s = (s * 1664525 + 1013904223) >>> 0) / 4294967296);
}

/** Đế "cuốn sách" kiểu ảnh quảng cáo: bìa trên + xấp giấy + bìa dưới, bồn cây hai bên cửa vào */
function buildBook(bounds, b) {
  const g = new THREE.Group();
  g.name = 'Đế sách';
  const m = 0.7, W = b.maxX - b.minX + m * 2, D = b.maxY - b.minY + m * 2, top = -0.16;
  const cover = new THREE.MeshStandardMaterial({ color: 0xf7f3ec, roughness: 0.7 });
  const page = new THREE.MeshStandardMaterial({ color: 0xfbf8f2, roughness: 0.95 });
  const page2 = new THREE.MeshStandardMaterial({ color: 0xe9e2d6, roughness: 0.95 });
  const back = new THREE.MeshStandardMaterial({ color: 0x3a3d40, roughness: 0.6 });
  const slab = (w, h, d, y, mat, dx = 0, dz = 0) => {
    const mesh = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), mat);
    mesh.position.set(bounds.cx + dx, y - h / 2, bounds.cy + dz);
    mesh.castShadow = true; mesh.receiveShadow = true;
    g.add(mesh);
  };
  slab(W, 0.08, D, top, cover);
  // xấp giấy: các lớp mỏng thụt vào một chút, xen màu để thấy gân giấy ở mép
  const n = 16, th = 0.04;
  for (let i = 0; i < n; i++) slab(W - 0.1, th, D - 0.1, top - 0.08 - i * th, i % 2 ? page2 : page, 0.015 * ((i % 3) - 1), 0.01 * ((i % 2) * 2 - 1));
  slab(W + 0.05, 0.07, D + 0.05, top - 0.08 - n * th, back);
  return g;
}

/**
 * @returns {{root:THREE.Group, doors:any[], roomLights:THREE.PointLight[], lampLights:THREE.PointLight[],
 *   lampShades:THREE.Mesh[], labels:CSS2DObject[], bounds:any, colliders:any[], furniture:THREE.Object3D[], spawn:THREE.Vector3}}
 */
export function buildScene(plan, opts = {}) {
  const H = plan.settings.wallHeight || 2.8;
  const clip = opts.clippingPlanes || [];
  const pal = resolvePalette(plan.settings);
  setPalette(pal);
  wallMat.color.set(pal.wall);
  wallMat.map = getTexture(pal.wallTex || 'plaster');
  wallMat.needsUpdate = true;
  capMat.color.set(pal.cap);
  topCapMat.color.set(pal.cap);
  skirtMat.color.set(pal.wall).offsetHSL(0, 0, -0.1);
  doorLeafMat.color.set(pal.woodDark);
  for (const m of [topCapMat, skirtMat, ledMat, rodMat]) m.clippingPlanes = clip;
  const root = new THREE.Group();
  root.name = 'Ngôi nhà';
  const doors = [], roomLights = [], lampLights = [], lampShades = [], labels = [], colliders = [], furnitureObjs = [];
  const b = planBounds(plan);
  const bounds = { ...b, cx: (b.minX + b.maxX) / 2, cy: (b.minY + b.maxY) / 2, size: Math.max(b.maxX - b.minX, b.maxY - b.minY, 4) };

  // --- Nền móng + sân ---
  const pad = 0.35;
  if (opts.landscape !== false) {
    const slab = shadowy(new THREE.Mesh(new THREE.BoxGeometry(b.maxX - b.minX + pad * 2, 0.16, b.maxY - b.minY + pad * 2), slabMat), false, true);
    slab.position.set(bounds.cx, -0.08, bounds.cy);
    root.add(slab);
  } else {
    // Nền trắng: đế sàn màu than bám đúng hình các phòng (kiểu mặt cắt phối cảnh)
    const baseMat = new THREE.MeshStandardMaterial({ color: pal.cap, roughness: 0.85 });
    if (opts.book) root.add(buildBook(bounds, b));
    for (const room of plan.rooms) {
      if (room.points.length < 3) continue;
      const sh = new THREE.Shape(room.points.map((p) => new THREE.Vector2(p.x, -p.y)));
      const g = new THREE.ExtrudeGeometry(sh, { depth: 0.16, bevelEnabled: false });
      g.rotateX(-Math.PI / 2);
      g.translate(0, -0.175, 0); // thấp hơn mặt sàn 1,5 cm để không lẫn với sàn khi nhìn từ xa
      root.add(shadowy(new THREE.Mesh(g, baseMat), true, false));
    }
    // Chân tường ngoài cũng có đế
    for (const w of plan.walls) {
      const L = wallLength(w);
      if (L < 0.01) continue;
      const g = new THREE.BoxGeometry(L + w.thickness, 0.16, w.thickness);
      g.translate(L / 2, -0.095, 0);
      g.applyMatrix4(wallMatrix(w));
      root.add(shadowy(new THREE.Mesh(g, baseMat), true, false));
    }
  }

  // --- Tường ---
  const geos = [], capGeos = [], skirtGeos = [], cutObjs = [];
  const cutFace = makeCutFace(plan);
  const opsByWall = new Map();
  for (const op of plan.openings) {
    if (!opsByWall.has(op.wallId)) opsByWall.set(op.wallId, []);
    opsByWall.get(op.wallId).push(op);
  }
  for (const w of plan.walls) {
    const L = wallLength(w);
    if (L < 0.01) continue;
    const ops = opsByWall.get(w.id) || [];
    const wh = w.height || H;
    const M = wallMatrix(w);
    const face = cutFace(w, L, wh, ops);
    for (const [u0, u1, y0, y1] of wallPieces(w, ops, wh)) {
      if (u1 - u0 < 1e-3 || y1 - y0 < 1e-3) continue;
      // Mảng kính cong: bỏ các trụ tường mảnh giữa các tấm kính (nhìn như khung)
      if (ops.some((o) => o.glass) && u1 - u0 < 0.16) continue;
      const g = new THREE.BoxGeometry(u1 - u0, y1 - y0, w.thickness);
      g.translate((u0 + u1) / 2, (y0 + y1) / 2, 0);
      meterUV(g);
      g.applyMatrix4(M);
      faceAttr(g, face);
      geos.push(g);
      if (y1 >= wh - 1e-4) {
        const cg = new THREE.BoxGeometry(u1 - u0, 0.012, w.thickness + 0.002);
        cg.translate((u0 + u1) / 2, wh + 0.006, 0);
        cg.applyMatrix4(M);
        faceAttr(cg, face);
        capGeos.push(cg);
      }
      if (y0 <= 1e-4 && u1 - u0 > 0.05) {
        const sg = new THREE.BoxGeometry(u1 - u0, 0.09, w.thickness + 0.024);
        sg.translate((u0 + u1) / 2, 0.045, 0);
        sg.applyMatrix4(M);
        skirtGeos.push(sg);
      }
    }
    // Vùng va chạm cho chế độ đi bộ (bỏ qua cửa đi)
    let cur = 0;
    const passes = ops.filter((o) => o.type !== 'window' && (o.sill || 0) < 0.3).map((o) => openingRange(w, o)).sort((p, q) => p[0] - q[0]);
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
    const P = (u) => ({ x: w.a.x + dx * u, y: w.a.y + dy * u });
    for (const [s, e] of passes) { if (s > cur) colliders.push({ a: P(cur), b: P(s), r: w.thickness / 2 }); cur = Math.max(cur, e); }
    if (cur < L) colliders.push({ a: P(cur), b: P(L), r: w.thickness / 2 });

    // Cửa / cửa sổ
    for (const op of ops) {
      const [s, e] = openingRange(w, op);
      const c = (s + e) / 2;
      let g;
      const interactive = { op, open: 0, target: 0, wallId: w.id };
      if (op.type === 'window') g = buildWindow(op, w, wh);
      else if (op.type === 'slide') { g = buildSlide(op, w, wh, interactive); doors.push(interactive); }
      else { g = buildDoor(op, w, wh, interactive); doors.push(interactive); }
      g.applyMatrix4(M);
      g.position.add(new THREE.Vector3(dx * c, 0, dy * c));
      if (face) { g.userData.cutFace = face; cutObjs.push(g); }
      interactive.center = new THREE.Vector3(w.a.x + dx * c, 1, w.a.y + dy * c);
      root.add(g);
      if (plan.settings.curtains !== false && op.type !== 'door' && op.height >= 0.9 && !op.glass && op.sill > 0.05 || (op.type === 'slide' && plan.settings.curtains !== false)) {
        const cx = w.a.x + dx * c, cy = w.a.y + dy * c;
        const nx = -dy, ny = dx;
        const inPlus = insideAnyRoom(plan, { x: cx + nx * 0.4, y: cy + ny * 0.4 });
        const inMinus = insideAnyRoom(plan, { x: cx - nx * 0.4, y: cy - ny * 0.4 });
        // Rèm phía trong nhà; cửa giữa 2 phòng (vd. ra lô gia) thì treo phía phòng lớn hơn
        let side = inPlus && !inMinus ? 1 : !inPlus && inMinus ? -1 : roomAreaAt(plan, { x: cx + nx * 0.4, y: cy + ny * 0.4 }) >= roomAreaAt(plan, { x: cx - nx * 0.4, y: cy - ny * 0.4 }) ? 1 : -1;
        if (inPlus || inMinus) {
          const cur = buildCurtains(op, w, wh, side, pal);
          cur.applyMatrix4(M);
          cur.position.add(new THREE.Vector3(dx * c, 0, dy * c));
          if (face) { cur.userData.cutFace = face; cutObjs.push(cur); }
          root.add(cur);
        }
      }
    }
  }
  if (geos.length) {
    const merged = mergeGeometries(geos, false);
    geos.forEach((g) => g.dispose());
    wallMat.clippingPlanes = clip;
    capMat.clippingPlanes = clip;
    const walls = shadowy(new THREE.Mesh(merged, wallMat));
    walls.name = 'Tường';
    const caps = new THREE.Mesh(merged, capMat);
    caps.name = 'Mặt cắt tường';
    caps.userData.noExport = true;
    caps.userData.capBack = true;
    root.add(walls, caps);
    if (capGeos.length) { const m = new THREE.Mesh(mergeGeometries(capGeos), topCapMat); m.name = 'Đỉnh tường'; root.add(m); capGeos.forEach((g) => g.dispose()); }
    if (skirtGeos.length) { const m = shadowy(new THREE.Mesh(mergeGeometries(skirtGeos), skirtMat), false, true); m.name = 'Len chân tường'; root.add(m); skirtGeos.forEach((g) => g.dispose()); }
  }
  for (const m of [frameMat, doorFrameMat, doorLeafMat, glassMat, handleMat]) m.clippingPlanes = clip;

  // --- Sàn, trần, đèn phòng, nhãn ---
  const rooms = plan.rooms.length ? plan.rooms : [{ name: '', floor: 'concrete', points: [{ x: b.minX, y: b.minY }, { x: b.maxX, y: b.minY }, { x: b.maxX, y: b.maxY }, { x: b.minX, y: b.maxY }] }];
  ceilingMat.clippingPlanes = clip;
  lampMat.clippingPlanes = clip;
  for (const room of rooms) {
    if (room.points.length < 3) continue;
    const shape = new THREE.Shape(room.points.map((p) => new THREE.Vector2(p.x, -p.y)));
    const fg = new THREE.ShapeGeometry(shape);
    fg.rotateX(-Math.PI / 2);
    const floor = shadowy(new THREE.Mesh(fg, floorMaterial(room.floor || 'wood')), false, true);
    floor.position.y = 0.002;
    floor.name = room.name || 'Sàn';
    root.add(floor);

    if (opts.ceiling !== false) {
      const ceil = new THREE.Mesh(fg.clone(), ceilingMat);
      ceil.position.y = H - 0.001;
      ceil.receiveShadow = true;
      ceil.userData.ceiling = true;
      root.add(ceil);
    }
    const lp = labelPoint(room.points);
    const area = polygonArea(room.points);
    if (opts.lights !== false && area > 1.5 && roomLights.length < 10) {
      const light = new THREE.PointLight(0xffd7a1, 0, Math.max(6, Math.sqrt(area) * 2.6), 1.6);
      light.position.set(lp.x, H - 0.35, lp.y);
      root.add(light);
      roomLights.push(light);
      const lamp = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.22, 0.04, 24), lampMat);
      lamp.position.set(lp.x, H - 0.02, lp.y);
      lamp.userData.lampDisc = true;
      root.add(lamp);
    }
    if (room.name && opts.labels !== false) {
      const el = document.createElement('div');
      el.className = 'label3d';
      const rx = room.points.map((p) => p.x), ry = room.points.map((p) => p.y);
      const dm = `${fmt(Math.max(...rx) - Math.min(...rx), 2)} × ${fmt(Math.max(...ry) - Math.min(...ry), 2)} m`;
      el.innerHTML = `<b>${escapeHtml(room.name)}</b><span>${fmt(area, 1)} m² · ${dm}</span>`;
      const lab = new CSS2DObject(el);
      lab.position.set(lp.x, 0.15, lp.y);
      lab.userData.noExport = true;
      root.add(lab);
      lab.userData.roomName = room.name;
      labels.push(lab);
    }
  }

  // --- Đèn LED hắt viền trần ---
  if (pal.led && plan.rooms.length) {
    const ledGeos = [];
    for (const room of plan.rooms) {
      const pts = room.points;
      for (let i = 0; i < pts.length; i++) {
        const a = pts[i], b = pts[(i + 1) % pts.length];
        const L = Math.hypot(b.x - a.x, b.y - a.y);
        if (L < 0.4) continue;
        const mid = { x: (a.x + b.x) / 2, y: (a.y + b.y) / 2 };
        let wall = null, wd = 0.06;
        for (const w of plan.walls) { const d = closestOnSegment(mid, w.a, w.b).d; if (d < wd) { wd = d; wall = w; } }
        if (!wall) continue;
        const ux = (b.x - a.x) / L, uy = (b.y - a.y) / L;
        let nx = -uy, ny = ux;
        if (!pointInPolygon({ x: mid.x + nx * 0.3, y: mid.y + ny * 0.3 }, pts)) { nx = -nx; ny = -ny; }
        const inset = wall.thickness / 2 + 0.03;
        const g = new THREE.BoxGeometry(L - inset * 2, 0.02, 0.03);
        g.rotateY(-Math.atan2(uy, ux));
        g.translate(mid.x + nx * inset, H - 0.035, mid.y + ny * inset);
        ledGeos.push(g);
      }
    }
    if (ledGeos.length) { const m = new THREE.Mesh(mergeGeometries(ledGeos), ledMat); m.name = 'LED hắt'; root.add(m); ledGeos.forEach((g) => g.dispose()); }
  }

  // --- Nội thất ---
  for (const item of plan.furniture) {
    const def = CATALOG_MAP[item.type];
    if (!def) continue;
    const g = buildFurniture3D(item);
    g.position.set(item.x, 0, item.y);
    g.rotation.y = (-(item.rot || 0) * Math.PI) / 180;
    g.name = def.name;
    g.traverse((o) => { if (o.isMesh) o.userData.furnitureId = item.id; if (o.userData.lampShade) lampShades.push(o); });
    if (opts.lights !== false && g.userData.lightPoint && lampLights.length < 6) {
      const l = new THREE.PointLight(0xffc98a, 0, 4, 2);
      l.position.copy(g.userData.lightPoint);
      g.add(l);
      lampLights.push(l);
    }
    if (def.type !== 'rug') {
      const w = item.w ?? def.w, d = item.d ?? def.d;
      colliders.push({ box: { x: item.x, y: item.y, w, d, rot: item.rot || 0 } });
    }
    g.userData.item = item;
    root.add(g);
    furnitureObjs.push(g);
  }

  // --- Người (tuỳ chọn) ---
  if (opts.people) {
    const ppl = placePeople(plan);
    ppl.userData.noExport = true;
    root.add(ppl);
  }

  // --- Cảnh quan: lối đi trước cửa chính, cây xanh xung quanh ---
  const spawnRoom = rooms.slice().sort((p, q) => polygonArea(q.points) - polygonArea(p.points))[0];
  let spawn = new THREE.Vector3(bounds.cx, 1.6, bounds.cy);
  if (spawnRoom) { const p = labelPoint(spawnRoom.points); spawn = new THREE.Vector3(p.x, 1.6, p.y); }
  if (opts.landscape !== false) {
    const insideAny = (p) => rooms.some((r) => pointInPolygon(p, r.points));
    for (const d of doors) {
      if (d.op.type !== 'door') continue;
      const w = plan.walls.find((x) => x.id === d.wallId);
      const L = wallLength(w), nx = -(w.b.y - w.a.y) / L, ny = (w.b.x - w.a.x) / L;
      const c = { x: d.center.x, y: d.center.z };
      let side = 0;
      if (!insideAny({ x: c.x + nx * 0.5, y: c.y + ny * 0.5 })) side = 1;
      else if (!insideAny({ x: c.x - nx * 0.5, y: c.y - ny * 0.5 })) side = -1;
      if (!side) continue;
      const len = 3.2;
      const path = shadowy(new THREE.Mesh(new THREE.BoxGeometry(d.op.width + 0.6, 0.06, len), pavingMat), false, true);
      const ang = Math.atan2(ny * side, nx * side);
      path.rotation.y = -ang + Math.PI / 2;
      path.position.set(c.x + nx * side * (len / 2 + w.thickness / 2), -0.12, c.y + ny * side * (len / 2 + w.thickness / 2));
      path.userData.landscape = true;
      root.add(path);
      const step = shadowy(new THREE.Mesh(new THREE.BoxGeometry(d.op.width + 0.3, 0.08, 0.4), slabMat));
      step.rotation.y = path.rotation.y;
      step.position.set(c.x + nx * side * (w.thickness / 2 + 0.55), -0.04, c.y + ny * side * (w.thickness / 2 + 0.55));
      step.userData.landscape = true;
      root.add(step);
    }
    const rnd = seeded(Math.round(bounds.size * 1000));
    const per = 2 * (b.maxX - b.minX + b.maxY - b.minY);
    const nTrees = Math.min(14, Math.max(5, Math.round(per / 5)));
    for (let i = 0; i < nTrees; i++) {
      const along = rnd() * per;
      const off = 2.2 + rnd() * 3.5;
      let x, y;
      const wX = b.maxX - b.minX, wY = b.maxY - b.minY;
      if (along < wX) { x = b.minX + along; y = b.minY - off; }
      else if (along < wX + wY) { x = b.maxX + off; y = b.minY + along - wX; }
      else if (along < 2 * wX + wY) { x = b.maxX - (along - wX - wY); y = b.maxY + off + 1.5; }
      else { x = b.minX - off; y = b.maxY - (along - 2 * wX - wY); }
      const nearPath = doors.some((d) => d.op.type === 'door' && Math.hypot(d.center.x - x, d.center.z - y) < 3.5);
      if (nearPath) continue;
      const t = i % 3 === 2 ? buildShrub(rnd) : buildTree(rnd);
      t.position.set(x, -0.15, y);
      t.userData.landscape = true;
      root.add(t);
    }
  }

  return { root, doors, roomLights, lampLights, lampShades, labels, bounds, colliders, furniture: furnitureObjs, spawn, height: H, cutObjs };
}

function escapeHtml(s) {
  return String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);
}

export function disposeTree(obj) {
  obj.traverse((o) => {
    if (o.geometry) o.geometry.dispose();
    if (o.element && o.element.parentNode) o.element.parentNode.removeChild(o.element);
  });
}
