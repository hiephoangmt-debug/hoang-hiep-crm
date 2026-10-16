// Thư viện nội thất: kích thước chuẩn, ký hiệu 2D (nhìn từ trên) và mô hình 3D dựng bằng khối cơ bản.
// Quy ước: tâm đồ vật ở giữa, mặt trước hướng +y (2D) / +z (3D), đơn vị mét.
import * as THREE from 'three';
import { RoundedBoxGeometry } from 'three/examples/jsm/geometries/RoundedBoxGeometry.js';
import { getTexture } from './textures.js';

const matCache = new Map();
export function mat(color, opts = {}) {
  const key = color + JSON.stringify(opts);
  if (!matCache.has(key)) matCache.set(key, new THREE.MeshStandardMaterial({ color, roughness: 0.7, metalness: 0, ...opts }));
  return matCache.get(key);
}
// Bảng màu hiện hành (do phong cách + tuỳ chỉnh của người dùng quyết định)
export const DEFAULT_PALETTE = {
  wood: '#8a5a3b', woodDark: '#4a3022', fabric: '#7d8a96', fabric2: '#c4844f', bedding: '#3f6e8c', accent: '#e0a96d',
  cabinet: '#f4f2ee', stone: '#34363a', metal: '#c7cbd1', curtain: '#f4f1ea', drape: '#7a6f66', rug1: '#8c3b2e', rug2: '#e8d3a9', leather: false,
};
let P = { ...DEFAULT_PALETTE };
export function setPalette(p) { P = { ...DEFAULT_PALETTE, ...p }; }
export function getPalette() { return P; }

const woodMat = (c, rough = 0.5) => mat(c, { roughness: rough, map: getTexture('woodGrain') });
const shadeHex = (hex, f) => { const c = new THREE.Color(hex); c.offsetHSL(0, 0, f); return '#' + c.getHexString(); };
const M = {
  wood: () => woodMat(P.wood, 0.55),
  darkWood: () => woodMat(P.woodDark, 0.45),
  lightWood: () => woodMat(P.wood, 0.6),
  cabinet: () => mat(P.cabinet, { roughness: 0.4 }),
  white: () => mat(0xf4f2ee, { roughness: 0.45 }),
  porcelain: () => mat(0xffffff, { roughness: 0.15, metalness: 0.05 }),
  steel: () => mat(0xc7cbd1, { roughness: 0.25, metalness: 0.85 }),
  metal: () => mat(P.metal, { roughness: 0.3, metalness: 0.9 }),
  black: () => mat(0x1d1f22, { roughness: 0.4 }),
  fabric: (c) => (P.leather && (c === P.fabric || c === P.fabric2) ? mat(c, { roughness: 0.42, metalness: 0.0 }) : mat(c, { roughness: 0.95, map: getTexture('fabric') })),
  glass: () => mat(0xbfe3f2, { roughness: 0.05, metalness: 0.1, transparent: true, opacity: 0.25, depthWrite: false }),
  stone: () => mat(P.stone, { roughness: 0.25, metalness: 0.05 }),
  leaf: () => mat(0x3f8f3a, { roughness: 0.8, flatShading: true }),
  leaf2: () => mat(0x5fae4a, { roughness: 0.8, flatShading: true }),
  lampShade: () => mat(0xfff1d6, { roughness: 0.9, emissive: 0xffd9a0, emissiveIntensity: 0.0 }),
};

function box(w, h, d, material, x = 0, y = 0, z = 0, rounded = 0) {
  const geo = rounded > 0 ? new RoundedBoxGeometry(w, h, d, 3, Math.min(rounded, w / 2, h / 2, d / 2)) : new THREE.BoxGeometry(w, h, d);
  const m = new THREE.Mesh(geo, material);
  m.position.set(x, y, z);
  m.castShadow = true;
  m.receiveShadow = true;
  return m;
}
function cyl(rt, rb, h, material, x = 0, y = 0, z = 0, seg = 24) {
  const m = new THREE.Mesh(new THREE.CylinderGeometry(rt, rb, h, seg), material);
  m.position.set(x, y, z);
  m.castShadow = true;
  m.receiveShadow = true;
  return m;
}
function legs(g, w, d, h, r, material, inset = 0.05) {
  for (const sx of [-1, 1]) for (const sz of [-1, 1]) g.add(cyl(r, r * 0.8, h, material, sx * (w / 2 - inset), h / 2, sz * (d / 2 - inset), 10));
}
function lampShade(g, x, y, z, r = 0.14, h = 0.2) {
  const s = cyl(r * 0.7, r, h, M.lampShade(), x, y, z);
  s.userData.lampShade = true;
  s.castShadow = false;
  g.add(s);
  g.userData.lightPoint = new THREE.Vector3(x, y, z);
}

// ---------- Mô hình 3D ----------
const builders = {
  bed(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.28, d, M.darkWood(), 0, 0.14, 0, 0.02));
    g.add(box(w - 0.06, 0.24, d - 0.12, M.white(), 0, 0.4, 0.03, 0.06));
    g.add(box(w + 0.04, 1.05, 0.1, M.fabric(P.fabric), 0, 0.52, -d / 2 + 0.05, 0.04));
    const n = w > 1.3 ? 2 : 1;
    for (let i = 0; i < n; i++) {
      const pw = (w - 0.2) / n - 0.06;
      g.add(box(pw, 0.14, 0.38, M.fabric(0xffffff), -w / 2 + 0.1 + (i + 0.5) * ((w - 0.2) / n), 0.58, -d / 2 + 0.36, 0.06));
    }
    g.add(box(w + 0.02, 0.07, d * 0.62, M.fabric(P.bedding), 0, 0.53, d / 2 - d * 0.31 + 0.02, 0.03));
    g.add(box(w + 0.03, 0.08, 0.32, M.fabric(P.accent), 0, 0.56, d / 2 - 0.45, 0.03));
    return g;
  },
  nightstand(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, h, d, M.wood(), 0, h / 2, 0, 0.01));
    g.add(box(w - 0.06, 0.005, 0.01, M.black(), 0, h * 0.55, d / 2 + 0.005));
    g.add(box(0.1, 0.02, 0.02, M.steel(), 0, h * 0.75, d / 2 + 0.01));
    g.add(cyl(0.05, 0.07, 0.25, M.white(), 0, h + 0.125, -0.02, 16));
    lampShade(g, 0, h + 0.33, -0.02, 0.12, 0.16);
    return g;
  },
  wardrobe(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, h, d, M.lightWood(), 0, h / 2, 0, 0.01));
    const n = Math.max(2, Math.round(w / 0.5));
    for (let i = 0; i < n; i++) {
      const dw = w / n;
      const x = -w / 2 + dw * (i + 0.5);
      g.add(box(dw - 0.012, h - 0.04, 0.02, M.lightWood(), x, h / 2, d / 2 + 0.01));
      g.add(box(0.02, 0.25, 0.03, M.metal(), x + (i % 2 ? -1 : 1) * (dw / 2 - 0.05), h * 0.52, d / 2 + 0.035));
    }
    return g;
  },
  sofa(w, d) {
    const g = new THREE.Group();
    const c = M.fabric(P.fabric), c2 = M.fabric(P.leather ? P.fabric : shadeHex(P.fabric, 0.04));
    g.add(box(w, 0.25, d, c, 0, 0.2, 0, 0.05));
    g.add(box(w, 0.48, 0.22, c, 0, 0.5, -d / 2 + 0.11, 0.08));
    for (const s of [-1, 1]) g.add(box(0.18, 0.38, d, c, s * (w / 2 - 0.09), 0.45, 0, 0.08));
    const n = Math.max(1, Math.round((w - 0.36) / 0.65));
    const cw = (w - 0.36) / n;
    for (let i = 0; i < n; i++) {
      const x = -w / 2 + 0.18 + cw * (i + 0.5);
      g.add(box(cw - 0.02, 0.14, d - 0.26, c2, x, 0.39, 0.1, 0.06));
      g.add(box(cw - 0.04, 0.4, 0.14, c2, x, 0.6, -d / 2 + 0.28, 0.06));
    }
    g.add(box(0.36, 0.34, 0.12, M.fabric(P.accent), -w / 2 + 0.45, 0.6, -d / 2 + 0.38, 0.06));
    legs(g, w, d, 0.08, 0.025, M.darkWood());
    return g;
  },
  armchair(w, d) {
    const g = new THREE.Group();
    const c = M.fabric(P.fabric2);
    g.add(box(w, 0.25, d, c, 0, 0.22, 0, 0.05));
    g.add(box(w, 0.5, 0.18, c, 0, 0.55, -d / 2 + 0.09, 0.07));
    for (const s of [-1, 1]) g.add(box(0.14, 0.32, d, c, s * (w / 2 - 0.07), 0.48, 0, 0.06));
    g.add(box(w - 0.3, 0.12, d - 0.22, M.fabric(P.fabric2), 0, 0.4, 0.08, 0.05));
    legs(g, w, d, 0.1, 0.02, M.darkWood());
    return g;
  },
  coffeeTable(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, 0.04, d, M.wood(), 0, h - 0.02, 0, 0.01));
    g.add(box(w - 0.1, 0.02, d - 0.1, M.wood(), 0, 0.12, 0));
    legs(g, w, d, h - 0.04, 0.02, M.black());
    g.add(cyl(0.06, 0.05, 0.12, M.porcelain(), w * 0.2, h + 0.06, 0, 16));
    g.add(box(0.25, 0.03, 0.18, M.fabric(P.accent), -w * 0.2, h + 0.015, 0));
    return g;
  },
  tvStand(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, h, d, M.darkWood(), 0, h / 2 + 0.05, 0, 0.01));
    legs(g, w, d, 0.05, 0.02, M.black());
    const tw = Math.min(w * 0.85, 1.45), th = tw * 0.57;
    g.add(box(tw, th, 0.04, M.black(), 0, h + 0.1 + th / 2, -d / 2 + 0.12, 0.01));
    const screen = new THREE.Mesh(new THREE.PlaneGeometry(tw - 0.03, th - 0.03), mat(0x0e2a3d, { roughness: 0.15, emissive: 0x2d6f9e, emissiveIntensity: 0.35 }));
    screen.position.set(0, h + 0.1 + th / 2, -d / 2 + 0.141);
    g.add(screen);
    g.add(box(0.3, 0.02, 0.18, M.black(), 0, h + 0.06, -d / 2 + 0.12));
    if (P.slats) {
      // Vách lam gỗ phía sau TV
      const sw = w + 0.8, n = Math.round(sw / 0.06);
      g.add(box(sw, 2.5, 0.015, M.darkWood(), 0, 1.25, -d / 2 - 0.035));
      for (let i = 0; i < n; i++) g.add(box(0.035, 2.5, 0.025, M.wood(), -sw / 2 + 0.03 + (i * (sw - 0.06)) / (n - 1), 1.25, -d / 2 - 0.015));
    }
    g.add(box(0.05, 0.08, 0.04, M.black(), 0, h + 0.09, -d / 2 + 0.12));
    return g;
  },
  roundTable(w, d, h) {
    const g = new THREE.Group();
    g.add(cyl(w / 2, w / 2, 0.035, M.stone(), 0, h - 0.018, 0, 40));
    g.add(cyl(0.03, 0.03, h - 0.04, M.metal(), 0, (h - 0.04) / 2, 0, 12));
    g.add(cyl(w * 0.3, w * 0.32, 0.02, M.metal(), 0, 0.01, 0, 30));
    g.add(box(0.28, 0.025, 0.2, M.fabric(P.accent), -0.1, h + 0.012, 0.05));
    g.add(cyl(0.05, 0.04, 0.14, M.porcelain(), 0.15, h + 0.07, -0.08, 16));
    return g;
  },
  diningTable(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, 0.05, d, M.lightWood(), 0, h - 0.025, 0, 0.01));
    legs(g, w, d, h - 0.05, 0.03, M.lightWood(), 0.08);
    g.add(cyl(0.12, 0.08, 0.1, M.porcelain(), 0, h + 0.05, 0, 20));
    for (let i = 0; i < 3; i++) {
      const s = new THREE.Mesh(new THREE.SphereGeometry(0.04, 12, 10), mat([0xe74c3c, 0xf1c40f, 0x27ae60][i]));
      s.position.set(-0.04 + i * 0.04, h + 0.12, (i - 1) * 0.03);
      g.add(s);
    }
    return g;
  },
  chair(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.05, d, M.lightWood(), 0, 0.46, 0, 0.01));
    g.add(box(w - 0.04, 0.04, d - 0.06, M.fabric(P.fabric), 0, 0.5, 0.02, 0.02));
    g.add(box(w, 0.42, 0.04, M.lightWood(), 0, 0.72, -d / 2 + 0.02, 0.01));
    legs(g, w, d, 0.44, 0.015, M.lightWood(), 0.03);
    return g;
  },
  desk(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, 0.04, d, M.wood(), 0, h - 0.02, 0, 0.005));
    for (const s of [-1, 1]) g.add(box(0.04, h - 0.04, d - 0.04, M.black(), s * (w / 2 - 0.04), (h - 0.04) / 2, 0));
    g.add(box(0.55, 0.32, 0.03, M.black(), 0, h + 0.28, -d / 2 + 0.12, 0.01));
    g.add(box(0.06, 0.12, 0.04, M.black(), 0, h + 0.06, -d / 2 + 0.12));
    const scr = new THREE.Mesh(new THREE.PlaneGeometry(0.52, 0.29), mat(0x123048, { emissive: 0x4a90c2, emissiveIntensity: 0.4 }));
    scr.position.set(0, h + 0.28, -d / 2 + 0.136);
    g.add(scr);
    g.add(box(0.42, 0.015, 0.14, M.black(), 0, h + 0.008, 0.08));
    return g;
  },
  officeChair(w, d) {
    const g = new THREE.Group();
    g.add(cyl(0.25, 0.25, 0.03, M.black(), 0, 0.06, 0, 5));
    g.add(cyl(0.025, 0.025, 0.35, M.steel(), 0, 0.25, 0, 10));
    g.add(box(w, 0.08, d * 0.9, M.fabric(0x2e3b4e), 0, 0.46, 0.02, 0.03));
    g.add(box(w * 0.9, 0.5, 0.06, M.fabric(0x2e3b4e), 0, 0.78, -d / 2 + 0.06, 0.03));
    return g;
  },
  kitchen(w, d) {
    const g = new THREE.Group();
    const H = 0.86;
    g.add(box(w, H - 0.1, d - 0.04, M.cabinet(), 0, (H - 0.1) / 2 + 0.1, -0.02));
    g.add(box(w, 0.1, d - 0.1, M.black(), 0, 0.05, -0.05));
    g.add(box(w + 0.02, 0.04, d + 0.02, M.stone(), 0, H + 0.02, 0));
    const n = Math.max(2, Math.round(w / 0.6));
    for (let i = 0; i < n; i++) {
      const x = -w / 2 + (w / n) * (i + 0.5);
      g.add(box(w / n - 0.012, H - 0.14, 0.02, M.cabinet(), x, (H - 0.1) / 2 + 0.1, d / 2 - 0.03));
      g.add(box(0.2, 0.015, 0.02, M.metal(), x, H - 0.1, d / 2 - 0.01));
    }
    // Chậu rửa
    g.add(box(0.7, 0.02, 0.42, M.steel(), -w / 2 + 0.6, H + 0.035, 0.02));
    g.add(box(0.6, 0.02, 0.34, mat(0x7c8288, { metalness: 0.8, roughness: 0.3 }), -w / 2 + 0.6, H + 0.04, 0.02));
    g.add(cyl(0.015, 0.015, 0.28, M.steel(), -w / 2 + 0.6, H + 0.18, -d / 2 + 0.1, 10));
    // Bếp từ
    if (w > 1.6) {
      g.add(box(0.6, 0.01, 0.5, M.black(), w / 2 - 0.65, H + 0.045, 0));
      for (const [ox, oz] of [[-0.14, -0.11], [0.14, -0.11], [-0.14, 0.11], [0.14, 0.11]]) {
        const ring = new THREE.Mesh(new THREE.RingGeometry(0.06, 0.075, 24), mat(0x666666));
        ring.rotation.x = -Math.PI / 2;
        ring.position.set(w / 2 - 0.65 + ox, H + 0.052, oz);
        g.add(ring);
      }
      g.add(box(0.7, 0.35, 0.45, M.steel(), w / 2 - 0.65, 1.95, -d / 2 + 0.25));
    }
    // Ốp tường bếp
    g.add(box(w, 0.95, 0.015, M.stone(), 0, H + 0.5, -d / 2 + 0.008));
    // Tủ bếp trên
    g.add(box(w, 0.7, 0.35, M.cabinet(), 0, 1.85 + 0.35, -d / 2 + 0.175, 0.01));
    return g;
  },
  fridge(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, h, d, M.steel(), 0, h / 2, 0, 0.03));
    g.add(box(w - 0.02, 0.008, 0.01, M.black(), 0, h * 0.62, d / 2 + 0.002));
    for (const y of [h * 0.8, h * 0.4]) g.add(box(0.025, 0.3, 0.04, M.black(), w / 2 - 0.08, y, d / 2 + 0.03));
    return g;
  },
  toilet(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.38, 0.18, M.porcelain(), 0, 0.6, -d / 2 + 0.09, 0.04));
    const bowl = cyl(0.19, 0.15, 0.4, M.porcelain(), 0, 0.2, 0.06, 28);
    bowl.scale.z = 1.3;
    g.add(bowl);
    const seat = cyl(0.2, 0.2, 0.03, M.porcelain(), 0, 0.41, 0.06, 28);
    seat.scale.z = 1.3;
    g.add(seat);
    return g;
  },
  vanity(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.5, d, M.wood(), 0, 0.55, 0, 0.01));
    g.add(box(w + 0.02, 0.04, d + 0.02, M.porcelain(), 0, 0.82, 0, 0.01));
    const basin = cyl(0.2, 0.15, 0.12, M.porcelain(), 0, 0.9, 0.02, 28);
    g.add(basin);
    g.add(cyl(0.012, 0.012, 0.2, M.steel(), 0, 0.94, -d / 2 + 0.08, 10));
    const mirror = box(w * 0.9, 0.7, 0.02, mat(0xdde8ef, { metalness: 1, roughness: 0.02 }), 0, 1.55, -d / 2 + 0.01, 0.01);
    g.add(mirror);
    return g;
  },
  shower(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.06, d, M.porcelain(), 0, 0.03, 0, 0.01));
    g.add(box(0.01, 1.95, d, M.glass(), w / 2 - 0.005, 1.0, 0));
    g.add(box(w, 1.95, 0.01, M.glass(), 0, 1.0, d / 2 - 0.005));
    g.add(cyl(0.012, 0.012, 1.4, M.steel(), -w / 2 + 0.08, 1.3, -d / 2 + 0.06, 8));
    g.add(cyl(0.1, 0.1, 0.02, M.steel(), -w / 2 + 0.2, 2.0, -d / 2 + 0.15, 20));
    return g;
  },
  bathtub(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.55, d, M.porcelain(), 0, 0.275, 0, 0.08));
    const water = box(w - 0.16, 0.02, d - 0.16, mat(0x9fd3e6, { roughness: 0.05, transparent: true, opacity: 0.85 }), 0, 0.48, 0, 0.05);
    g.add(water);
    g.add(cyl(0.015, 0.015, 0.15, M.steel(), -w / 2 + 0.12, 0.62, 0, 10));
    return g;
  },
  plant(w) {
    const g = new THREE.Group();
    const r = w / 2;
    g.add(cyl(r * 0.6, r * 0.45, 0.35, mat(0xd9d4cc, { roughness: 0.6 }), 0, 0.175, 0, 20));
    g.add(cyl(r * 0.55, r * 0.55, 0.02, mat(0x4b3621), 0, 0.34, 0, 20));
    g.add(cyl(0.02, 0.025, 0.6, mat(0x5b4030), 0, 0.6, 0, 8));
    const rnd = mulberry(Math.round(w * 1000));
    for (let i = 0; i < 9; i++) {
      const s = r * (0.45 + rnd() * 0.35);
      const leaf = new THREE.Mesh(new THREE.IcosahedronGeometry(s, 0), i % 2 ? M.leaf() : M.leaf2());
      const a = rnd() * Math.PI * 2, rr = rnd() * r * 0.6;
      leaf.position.set(Math.cos(a) * rr, 0.75 + rnd() * 0.6, Math.sin(a) * rr);
      leaf.rotation.set(rnd() * 3, rnd() * 3, rnd() * 3);
      leaf.castShadow = true;
      g.add(leaf);
    }
    return g;
  },
  /** Sàn gỗ ngoài trời (deck) kiểu resort: ván gỗ teak có khe */
  deck(w, d) {
    const g = new THREE.Group();
    const m = mat(0xa8774e, { roughness: 0.75, map: getTexture('woodGrain') });
    const pw = 0.14, n = Math.floor(d / pw);
    for (let i = 0; i < n; i++) {
      const b = box(w, 0.05, pw - 0.012, m, 0, 0.025, -d / 2 + pw / 2 + i * pw);
      b.castShadow = false;
      g.add(b);
    }
    return g;
  },
  /** Ghế nằm tắm nắng: khung gỗ, đệm trắng, tựa lưng nghiêng */
  lounger(w, d) {
    const g = new THREE.Group();
    const frame = mat(0x8a5a36, { roughness: 0.6, map: getTexture('woodGrain') });
    const cush = mat(0xf3efe6, { roughness: 0.95, map: getTexture('fabric') });
    g.add(box(w, 0.08, d * 0.68, frame, 0, 0.3, d * 0.16));
    for (const sx of [-1, 1]) for (const sz of [-0.2, 0.48]) g.add(box(0.05, 0.3, 0.05, frame, sx * (w / 2 - 0.05), 0.15, sz * d));
    g.add(box(w - 0.06, 0.07, d * 0.66, cush, 0, 0.375, d * 0.16, 0.03));
    const back = new THREE.Group();
    back.add(box(w, 0.06, d * 0.32, frame, 0, 0, -d * 0.16));
    back.add(box(w - 0.06, 0.07, d * 0.3, cush, 0, 0.06, -d * 0.16, 0.03));
    back.position.set(0, 0.34, -d * 0.18);
    back.rotation.x = -0.6;
    g.add(back);
    g.add(box(0.36, 0.06, 0.2, cush, 0, 0.62, -d * 0.36, 0.03)); // gối
    return g;
  },
  /** Dù che nắng: trụ gỗ, tán vải kem hình nón */
  parasol(w) {
    const g = new THREE.Group();
    g.add(cyl(0.22, 0.25, 0.08, mat(0x4a4a4a, { roughness: 0.6 }), 0, 0.04, 0, 16));
    g.add(cyl(0.025, 0.025, 2.3, mat(0x8a5a36, { roughness: 0.6 }), 0, 1.15, 0, 8));
    const canopy = new THREE.Mesh(new THREE.ConeGeometry(w / 2, 0.45, 8, 1, true), mat(0xefe6d4, { roughness: 0.95, side: THREE.DoubleSide, map: getTexture('fabric') }));
    canopy.position.y = 2.25;
    canopy.castShadow = true;
    g.add(canopy);
    return g;
  },
  /** Cây dừa / cau kiểu nhiệt đới: thân cong nhiều đốt, tán lá dài rủ */
  palm(w, d, h) {
    const g = new THREE.Group();
    const H = h || 3.4;
    const trunk = mat(0x8c7a62, { roughness: 0.95, map: getTexture('woodGrain') });
    const rnd = mulberry(Math.round(H * 1000 + w * 77));
    const segs = 10;
    let x = 0, z = 0;
    const lean = 0.035 + rnd() * 0.02, dir = rnd() * Math.PI * 2;
    for (let i = 0; i < segs; i++) {
      const r0 = 0.11 - i * 0.004;
      const c = cyl(r0, r0 + 0.012, H / segs + 0.02, trunk, x, (i + 0.5) * H / segs, z, 9);
      g.add(c);
      x += Math.cos(dir) * lean * i * 0.25; z += Math.sin(dir) * lean * i * 0.25;
    }
    // bồn đá dưới gốc
    g.add(cyl(0.38, 0.34, 0.32, mat(0xcfc8bb, { roughness: 0.9, map: getTexture('concrete') }), 0, 0.16, 0, 18));
    // Tàu lá: dải lá dài uốn cong rủ xuống, hoạ tiết lá chét xẻ lông chim (ảnh có kênh trong suốt)
    const leafTex = palmLeafTexture();
    const leafMats = [0x5a9440, 0x6aa24a, 0x4b843a].map((c) => mat(c, { roughness: 0.75, side: THREE.DoubleSide, map: leafTex, alphaTest: 0.45 }));
    const top = new THREE.Vector3(x, H, z);
    const nF = 12;
    for (let f = 0; f < nF; f++) {
      const a = (f / nF) * Math.PI * 2 + rnd() * 0.25;
      const len = 1.4 + rnd() * 0.5, wid = 0.55;
      const geo = new THREE.PlaneGeometry(len, wid, 12, 1);
      const pos = geo.attributes.position;
      for (let i = 0; i < pos.count; i++) {
        const t = (pos.getX(i) + len / 2) / len; // 0 ở gốc → 1 ở ngọn
        pos.setXYZ(i, t * len, 0.3 * Math.sin(t * Math.PI * 0.55) - 0.75 * t * t + Math.abs(pos.getY(i)) * 0.25, pos.getY(i) * (0.35 + 0.65 * Math.sin(Math.PI * Math.min(1, t * 1.1))));
      }
      geo.computeVertexNormals();
      const frond = new THREE.Mesh(geo, leafMats[f % 3]);
      frond.position.copy(top);
      frond.rotation.y = a;
      frond.castShadow = true;
      g.add(frond);
    }
    return g;
  },
  /** Viền sỏi trắng */
  pebbles(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.03, d, mat(0xeeeae2, { roughness: 1, map: getTexture('concrete') }), 0, 0.015, 0));
    const rnd = mulberry(Math.round(w * 313 + d * 71));
    const pm = [0xf6f3ee, 0xe2ddd3, 0xd3cdc2].map((c) => mat(c, { roughness: 0.9 }));
    const geo = new THREE.SphereGeometry(1, 8, 6);
    for (let i = 0; i < Math.round(w * d * 70); i++) {
      const p = new THREE.Mesh(geo, pm[i % 3]);
      const r = 0.025 + rnd() * 0.025;
      p.scale.set(r * 1.3, r * 0.6, r);
      p.position.set((rnd() - 0.5) * w, 0.03, (rnd() - 0.5) * d);
      g.add(p);
    }
    return g;
  },
  /** Đá lát bước chân trên cỏ: tấm đá tròn méo, mép bo, vân đá nhạt, lún nhẹ trong cỏ */
  steppingStone(w, d) {
    const g = new THREE.Group();
    const rnd = mulberry(Math.round(w * 7919 + d * 104729));
    const sh = new THREE.Shape();
    const n = 14;
    for (let i = 0; i <= n; i++) {
      const a = (i / n) * Math.PI * 2, k = 0.88 + rnd() * 0.18;
      const px = Math.cos(a) * w / 2 * k, py = Math.sin(a) * d / 2 * k;
      i ? sh.lineTo(px, py) : sh.moveTo(px, py);
    }
    const geo = new THREE.ExtrudeGeometry(sh, { depth: 0.03, bevelEnabled: true, bevelThickness: 0.012, bevelSize: 0.015, bevelSegments: 2, curveSegments: 4 });
    geo.rotateX(-Math.PI / 2);
    const m = new THREE.Mesh(geo, mat(0xd6d0c4, { roughness: 0.92, map: getTexture('concrete') }));
    m.position.y = 0.0;
    m.receiveShadow = true;
    g.add(m);
    return g;
  },
  /** Luống cây bụi + hoa: viền gỗ thấp, mỗi bụi là chùm nhiều cụm lá tròn mềm (không góc cạnh), điểm hoa */
  shrubBed(w, d) {
    const g = new THREE.Group();
    g.add(box(w, 0.16, d, mat(0x5e4330, { roughness: 0.8, map: getTexture('woodGrain') }), 0, 0.08, 0, 0.02));
    g.add(box(w - 0.06, 0.02, d - 0.06, mat(0x3d3024, { roughness: 1 }), 0, 0.165, 0));
    const rnd = mulberry(Math.round(w * 997 + d * 131));
    const leafTex = getTexture('foliage');
    const greens = [0x4f8a3a, 0x6a9a44, 0x3e7a45, 0x7aa64e, 0x5b8f5f, 0x8aa84a];
    const flowers = [0xe58fb0, 0xf6f2ea, 0xf2c94c, 0xd96a8a, 0xb38fd6, 0xf08a5d].map((c) => mat(c, { roughness: 0.7 }));
    const ball = new THREE.SphereGeometry(1, 14, 10);
    const n = Math.max(3, Math.round(w * d * 6));
    for (let i = 0; i < n; i++) {
      const s = 0.16 + rnd() * 0.18;
      const bx = (rnd() - 0.5) * (w - s * 1.2), bz = (rnd() - 0.5) * (d - s * 1.2);
      const leaf = mat(greens[Math.floor(rnd() * greens.length)], { roughness: 0.9, map: leafTex });
      // chùm 5–8 cụm lá nhỏ chồng nhau → dáng bụi cây tự nhiên
      const k = 5 + Math.floor(rnd() * 4);
      for (let j = 0; j < k; j++) {
        const r = s * (0.45 + rnd() * 0.35);
        const b = new THREE.Mesh(ball, leaf);
        b.scale.set(r, r * (0.8 + rnd() * 0.3), r);
        b.position.set(bx + (rnd() - 0.5) * s, 0.18 + r * 0.8 + rnd() * s * 0.5, bz + (rnd() - 0.5) * s);
        b.castShadow = true;
        g.add(b);
      }
      if (rnd() < 0.5) for (let f = 0; f < 6; f++) {
        const fl = new THREE.Mesh(new THREE.IcosahedronGeometry(0.025 + rnd() * 0.02, 1), flowers[i % flowers.length]);
        const a = rnd() * Math.PI * 2;
        fl.position.set(bx + Math.cos(a) * s * 0.6, 0.2 + s * 1.15 + rnd() * 0.05, bz + Math.sin(a) * s * 0.6);
        g.add(fl);
      }
    }
    return g;
  },
  rug(w, d) {
    const g = new THREE.Group();
    const m = box(w, 0.012, d, new THREE.MeshStandardMaterial({ map: rugTexture(), roughness: 1 }), 0, 0.006, 0);
    m.castShadow = false;
    g.add(m);
    return g;
  },
  floorLamp() {
    const g = new THREE.Group();
    g.add(cyl(0.16, 0.16, 0.03, M.black(), 0, 0.015, 0));
    g.add(cyl(0.012, 0.012, 1.5, M.steel(), 0, 0.77, 0, 8));
    lampShade(g, 0, 1.55, 0, 0.2, 0.28);
    return g;
  },
  bookshelf(w, d, h) {
    const g = new THREE.Group();
    const wood = M.wood();
    for (const s of [-1, 1]) g.add(box(0.03, h, d, wood, s * (w / 2 - 0.015), h / 2, 0));
    g.add(box(w, h, 0.02, wood, 0, h / 2, -d / 2 + 0.01));
    const shelves = 5;
    const rnd = mulberry(Math.round(w * 777));
    const colors = [0xb03a2e, 0x2e86c1, 0x229954, 0xd4ac0d, 0x6c3483, 0xeeeeee, 0x34495e];
    for (let i = 0; i <= shelves; i++) {
      const y = 0.02 + (i * (h - 0.04)) / shelves;
      g.add(box(w - 0.06, 0.025, d - 0.02, wood, 0, y, 0));
      if (i === shelves) break;
      let x = -w / 2 + 0.05;
      while (x < w / 2 - 0.1) {
        const bw = 0.025 + rnd() * 0.04, bh = 0.18 + rnd() * 0.12;
        if (rnd() > 0.15) g.add(box(bw, bh, d * 0.75, mat(colors[Math.floor(rnd() * colors.length)]), x + bw / 2, y + 0.0125 + bh / 2, 0));
        x += bw + 0.004;
      }
    }
    return g;
  },
  stairs(w, d, h) {
    const g = new THREE.Group();
    const n = Math.max(8, Math.round(h / 0.17));
    const depth = d / n;
    for (let i = 0; i < n; i++) {
      const sh = ((i + 1) * h) / n;
      g.add(box(w, sh, depth, M.lightWood(), 0, sh / 2, d / 2 - depth * (i + 0.5)));
    }
    g.add(box(0.04, 0.9, 0.04, M.black(), w / 2 - 0.03, 0.45 + h / n, d / 2 - 0.05));
    const rail = box(0.05, 0.05, Math.hypot(d, h), M.black(), w / 2 - 0.03, h / 2 + 0.9, 0);
    rail.rotation.x = Math.atan2(h, d);
    g.add(rail);
    return g;
  },
  washer(w, d, h) {
    const g = new THREE.Group();
    g.add(box(w, h, d, M.white(), 0, h / 2, 0, 0.03));
    const door = new THREE.Mesh(new THREE.TorusGeometry(0.17, 0.03, 10, 30), M.steel());
    door.position.set(0, h * 0.48, d / 2 + 0.01);
    g.add(door);
    const glass = new THREE.Mesh(new THREE.CircleGeometry(0.16, 30), mat(0x2b3a48, { roughness: 0.1 }));
    glass.position.set(0, h * 0.48, d / 2 + 0.005);
    g.add(glass);
    return g;
  },
  car(w, d) {
    const g = new THREE.Group();
    const body = mat(0xc0392b, { roughness: 0.25, metalness: 0.6 });
    g.add(box(w, 0.6, d, body, 0, 0.55, 0, 0.15));
    g.add(box(w * 0.86, 0.5, d * 0.5, mat(0x1b2631, { roughness: 0.1, metalness: 0.4 }), 0, 1.05, -0.1, 0.12));
    for (const sx of [-1, 1]) for (const sz of [-1, 1]) {
      const wh = cyl(0.33, 0.33, 0.22, M.black(), sx * (w / 2 - 0.08), 0.33, sz * (d / 2 - 0.7), 20);
      wh.rotation.z = Math.PI / 2;
      g.add(wh);
    }
    return g;
  },
};

function mulberry(a) {
  return function () {
    a |= 0; a = (a + 0x6d2b79f5) | 0;
    let t = Math.imul(a ^ (a >>> 15), 1 | a);
    t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
    return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
  };
}

const rugCache = new Map();
/** Thảm hoạ tiết hình học (trellis kiểu Ma-rốc) theo 2 màu của bảng màu */
function rugTexture() {
  const key = P.rug1 + P.rug2;
  if (rugCache.has(key)) return rugCache.get(key);
  const c = document.createElement('canvas');
  c.width = c.height = 512;
  const x = c.getContext('2d');
  x.fillStyle = P.rug1; x.fillRect(0, 0, 512, 512);
  x.strokeStyle = P.rug2; x.lineWidth = 7; x.lineJoin = 'round';
  const s = 64;
  for (let i = -1; i < 9; i++) for (let j = -1; j < 9; j++) {
    const cx = i * s + (j % 2 ? s / 2 : 0), cy = j * s * 0.75;
    x.beginPath();
    x.moveTo(cx, cy - s * 0.42); x.lineTo(cx + s * 0.22, cy - s * 0.2); x.lineTo(cx + s * 0.22, cy + s * 0.2);
    x.lineTo(cx, cy + s * 0.42); x.lineTo(cx - s * 0.22, cy + s * 0.2); x.lineTo(cx - s * 0.22, cy - s * 0.2); x.closePath();
    x.stroke();
  }
  x.lineWidth = 14; x.strokeRect(10, 10, 492, 492);
  const t = new THREE.CanvasTexture(c);
  t.colorSpace = THREE.SRGBColorSpace;
  t.anisotropy = 8;
  rugCache.set(key, t);
  return t;
}

// ---------- Danh mục ----------
let palmTex = null;
/** Hoạ tiết tàu lá dừa: gân giữa + các lá chét nhọn hai bên, nền trong suốt */
function palmLeafTexture() {
  if (palmTex) return palmTex;
  const c = document.createElement('canvas'); c.width = 512; c.height = 128;
  const x = c.getContext('2d');
  x.clearRect(0, 0, 512, 128);
  x.strokeStyle = '#d9e6c8'; x.lineWidth = 3;
  x.beginPath(); x.moveTo(0, 64); x.lineTo(512, 64); x.stroke();
  for (let i = 4; i < 506; i += 11) {
    const L = 58 * Math.sin(Math.PI * (0.12 + 0.88 * i / 512));
    for (const s of [-1, 1]) {
      const g = x.createLinearGradient(i, 64, i + 16, 64 + s * L);
      g.addColorStop(0, '#e8f0dc'); g.addColorStop(1, '#ffffff');
      x.fillStyle = g;
      x.beginPath(); x.moveTo(i, 64); x.quadraticCurveTo(i + 12, 64 + s * L * 0.55, i + 20, 64 + s * L); x.quadraticCurveTo(i + 6, 64 + s * L * 0.5, i + 7, 64); x.fill();
    }
  }
  palmTex = new THREE.CanvasTexture(c);
  palmTex.colorSpace = THREE.SRGBColorSpace;
  return palmTex;
}

export const CATALOG = [
  { type: 'bed', name: 'Giường đôi', cat: 'Phòng ngủ', w: 1.8, d: 2.05, h: 1.0, color: '#d8c3a5', icon: '🛏️' },
  { type: 'bedSingle', base: 'bed', name: 'Giường đơn', cat: 'Phòng ngủ', w: 1.2, d: 2.0, h: 1.0, color: '#d8c3a5', icon: '🛏️' },
  { type: 'nightstand', name: 'Tab đầu giường', cat: 'Phòng ngủ', w: 0.45, d: 0.4, h: 0.5, color: '#b08968', icon: '🗄️' },
  { type: 'wardrobe', name: 'Tủ quần áo', cat: 'Phòng ngủ', w: 1.6, d: 0.6, h: 2.2, color: '#c9a27a', icon: '🚪' },
  { type: 'desk', name: 'Bàn làm việc', cat: 'Phòng ngủ', w: 1.2, d: 0.6, h: 0.75, color: '#e9ecef', icon: '💻' },
  { type: 'officeChair', name: 'Ghế xoay', cat: 'Phòng ngủ', w: 0.5, d: 0.5, h: 1.0, color: '#4a5a70', icon: '🪑' },
  { type: 'bookshelf', name: 'Kệ sách', cat: 'Phòng ngủ', w: 0.9, d: 0.32, h: 1.9, color: '#a47148', icon: '📚' },
  { type: 'sofa', name: 'Sofa 3 chỗ', cat: 'Phòng khách', w: 2.2, d: 0.9, h: 0.85, color: '#9aa7b3', icon: '🛋️' },
  { type: 'armchair', name: 'Ghế bành', cat: 'Phòng khách', w: 0.85, d: 0.85, h: 0.85, color: '#d49862', icon: '💺' },
  { type: 'coffeeTable', name: 'Bàn trà', cat: 'Phòng khách', w: 1.1, d: 0.6, h: 0.42, color: '#a47148', icon: '☕' },
  { type: 'roundTable', name: 'Bàn trà tròn', cat: 'Phòng khách', w: 0.85, d: 0.85, h: 0.45, color: '#4b4b4f', icon: '⚫' },
  { type: 'tvStand', name: 'Kệ TV + TV', cat: 'Phòng khách', w: 1.8, d: 0.45, h: 0.45, color: '#5c4033', icon: '📺' },
  { type: 'rug', name: 'Thảm', cat: 'Phòng khách', w: 2.4, d: 1.7, h: 0.01, color: '#b5654f', icon: '🟥' },
  { type: 'floorLamp', name: 'Đèn cây', cat: 'Phòng khách', w: 0.4, d: 0.4, h: 1.7, color: '#f5e6c8', icon: '💡' },
  { type: 'plant', name: 'Chậu cây', cat: 'Phòng khách', w: 0.55, d: 0.55, h: 1.4, color: '#5fae4a', icon: '🪴' },
  { type: 'kitchen', name: 'Tủ bếp', cat: 'Bếp', w: 3.0, d: 0.6, h: 0.9, color: '#e9ecef', icon: '🍳' },
  { type: 'fridge', name: 'Tủ lạnh', cat: 'Bếp', w: 0.7, d: 0.7, h: 1.8, color: '#c7cbd1', icon: '🧊' },
  { type: 'diningTable', name: 'Bàn ăn', cat: 'Bếp', w: 1.6, d: 0.9, h: 0.75, color: '#d4b48c', icon: '🍽️' },
  { type: 'chair', name: 'Ghế ăn', cat: 'Bếp', w: 0.45, d: 0.48, h: 0.9, color: '#c9a27a', icon: '🪑' },
  { type: 'washer', name: 'Máy giặt', cat: 'Phòng tắm', w: 0.6, d: 0.6, h: 0.85, color: '#f1f3f5', icon: '🫧' },
  { type: 'toilet', name: 'Bồn cầu', cat: 'Phòng tắm', w: 0.42, d: 0.68, h: 0.8, color: '#ffffff', icon: '🚽' },
  { type: 'vanity', name: 'Lavabo', cat: 'Phòng tắm', w: 0.8, d: 0.5, h: 0.85, color: '#ffffff', icon: '🚰' },
  { type: 'shower', name: 'Vòi sen kính', cat: 'Phòng tắm', w: 0.9, d: 0.9, h: 2.0, color: '#d6eef7', icon: '🚿' },
  { type: 'deck', name: 'Sàn gỗ ngoài trời', cat: 'Khác', w: 2.4, d: 2.0, h: 0.05, color: '#a8774e', icon: '🪵' },
  { type: 'lounger', name: 'Ghế nằm tắm nắng', cat: 'Khác', w: 0.7, d: 1.9, h: 0.7, color: '#f3efe6', icon: '🏖️' },
  { type: 'parasol', name: 'Dù che nắng', cat: 'Khác', w: 2.2, d: 2.2, h: 2.5, color: '#efe6d4', icon: '⛱️' },
  { type: 'palm', name: 'Cây dừa / cau', cat: 'Khác', w: 2.6, d: 2.6, h: 3.4, color: '#4e8a3c', icon: '🌴' },
  { type: 'pebbles', name: 'Viền sỏi trắng', cat: 'Khác', w: 2.0, d: 0.3, h: 0.04, color: '#eeeae2', icon: '⚪' },
  { type: 'steppingStone', name: 'Đá lát sân vườn', cat: 'Khác', w: 0.5, d: 0.32, h: 0.04, color: '#d8d3c8', icon: '🪨' },
  { type: 'shrubBed', name: 'Luống cây & hoa', cat: 'Khác', w: 2.0, d: 0.6, h: 0.6, color: '#3f7a35', icon: '🌺' },
  { type: 'bathtub', name: 'Bồn tắm', cat: 'Phòng tắm', w: 1.7, d: 0.75, h: 0.55, color: '#ffffff', icon: '🛁' },
  { type: 'stairs', name: 'Cầu thang', cat: 'Khác', w: 1.0, d: 3.2, h: 2.8, color: '#d4b48c', icon: '🪜' },
  { type: 'car', name: 'Ô tô', cat: 'Khác', w: 1.8, d: 4.4, h: 1.4, color: '#c0392b', icon: '🚗' },
];
export const CATALOG_MAP = Object.fromEntries(CATALOG.map((c) => [c.type, c]));

/** Màu "chính" của từng loại đồ – thứ mà người dùng đổi khi chọn màu riêng cho món đồ */
export const MAIN_KEY = {
  bed: 'bedding', nightstand: 'wood', wardrobe: 'wood', sofa: 'fabric', armchair: 'fabric2', coffeeTable: 'wood', roundTable: 'stone',
  tvStand: 'woodDark', diningTable: 'wood', chair: 'fabric', desk: 'wood', kitchen: 'cabinet', bookshelf: 'wood', rug: 'rug1',
  vanity: 'wood', stairs: 'wood', officeChair: 'fabric',
};

export function buildFurniture3D(item) {
  const def = CATALOG_MAP[item.type];
  if (!def) return new THREE.Group();
  const fn = builders[def.base || def.type];
  const saved = P;
  const key = MAIN_KEY[def.base || def.type];
  if (item.color && key) P = { ...P, [key]: item.color };
  let g;
  try { g = fn(item.w ?? def.w, item.d ?? def.d, item.h ?? def.h); } finally { P = saved; }
  g.userData.furnitureId = item.id;
  return g;
}

// ---------- Ký hiệu 2D ----------
function rr(ctx, x, y, w, h, r) {
  ctx.beginPath();
  ctx.roundRect ? ctx.roundRect(x, y, w, h, r) : ctx.rect(x, y, w, h);
}
/** Vẽ ký hiệu nhìn từ trên, hệ toạ độ cục bộ (mét) với tâm ở 0,0, mặt trước hướng +y */
export function drawFurniture2D(ctx, item, px) {
  const def = CATALOG_MAP[item.type];
  if (!def) return;
  const w = item.w ?? def.w, d = item.d ?? def.d;
  const lw = 1.2 / px;
  ctx.lineWidth = lw;
  ctx.strokeStyle = '#3d3d3d';
  ctx.fillStyle = def.color;
  const t = def.base || def.type;
  if (t === 'plant') {
    ctx.fillStyle = '#5fae4a';
    for (let i = 0; i < 6; i++) {
      const a = (i / 6) * Math.PI * 2;
      ctx.beginPath(); ctx.ellipse(Math.cos(a) * w * 0.22, Math.sin(a) * w * 0.22, w * 0.22, w * 0.12, a, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    }
    ctx.fillStyle = '#3f8f3a';
    ctx.beginPath(); ctx.arc(0, 0, w * 0.15, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    return;
  }
  if (t === 'floorLamp') {
    ctx.beginPath(); ctx.arc(0, 0, w / 2, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(-w / 3, 0); ctx.lineTo(w / 3, 0); ctx.moveTo(0, -w / 3); ctx.lineTo(0, w / 3); ctx.stroke();
    return;
  }
  if (t === 'toilet') {
    rr(ctx, -w / 2, -d / 2, w, d * 0.28, 0.03); ctx.fill(); ctx.stroke();
    ctx.beginPath(); ctx.ellipse(0, d * 0.1, w * 0.45, d * 0.36, 0, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    ctx.beginPath(); ctx.ellipse(0, d * 0.12, w * 0.28, d * 0.24, 0, 0, Math.PI * 2); ctx.stroke();
    return;
  }
  if (t === 'roundTable') {
    ctx.beginPath(); ctx.arc(0, 0, w / 2, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    return;
  }
  if (t === 'officeChair') {
    ctx.beginPath(); ctx.arc(0, 0, w / 2, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    rr(ctx, -w * 0.4, -d / 2, w * 0.8, d * 0.18, 0.03); ctx.fill(); ctx.stroke();
    return;
  }
  rr(ctx, -w / 2, -d / 2, w, d, Math.min(w, d) * 0.08);
  ctx.fill(); ctx.stroke();
  ctx.fillStyle = 'rgba(255,255,255,0.75)';
  switch (t) {
    case 'bed': {
      ctx.fillStyle = '#3f6e8c';
      ctx.fillRect(-w / 2, d / 2 - d * 0.6, w, d * 0.6); ctx.strokeRect(-w / 2, d / 2 - d * 0.6, w, d * 0.6);
      ctx.fillStyle = '#ffffff';
      const n = w > 1.3 ? 2 : 1;
      for (let i = 0; i < n; i++) { rr(ctx, -w / 2 + 0.1 + i * ((w - 0.2) / n) + 0.03, -d / 2 + 0.15, (w - 0.2) / n - 0.06, 0.38, 0.06); ctx.fill(); ctx.stroke(); }
      break;
    }
    case 'sofa':
    case 'armchair':
      ctx.fillStyle = 'rgba(0,0,0,0.12)';
      ctx.fillRect(-w / 2, -d / 2, w, 0.22);
      ctx.fillRect(-w / 2, -d / 2, 0.16, d); ctx.fillRect(w / 2 - 0.16, -d / 2, 0.16, d);
      if (t === 'sofa') { const n = Math.max(1, Math.round((w - 0.36) / 0.65)); for (let i = 1; i < n; i++) { const x = -w / 2 + 0.18 + ((w - 0.36) / n) * i; ctx.beginPath(); ctx.moveTo(x, -d / 2 + 0.22); ctx.lineTo(x, d / 2); ctx.stroke(); } }
      break;
    case 'kitchen': {
      ctx.fillStyle = '#9aa3ab'; rr(ctx, -w / 2 + 0.25, -d / 2 + 0.1, 0.7, 0.42, 0.04); ctx.fill(); ctx.stroke();
      if (w > 1.6) { ctx.fillStyle = '#333'; ctx.fillRect(w / 2 - 0.95, -d / 2 + 0.05, 0.6, 0.5); ctx.strokeStyle = '#bbb'; for (const [ox, oy] of [[-0.14, -0.11], [0.14, -0.11], [-0.14, 0.11], [0.14, 0.11]]) { ctx.beginPath(); ctx.arc(w / 2 - 0.65 + ox, -d / 2 + 0.3 + oy, 0.07, 0, Math.PI * 2); ctx.stroke(); } }
      break;
    }
    case 'bathtub':
      ctx.fillStyle = '#cfe9f3'; rr(ctx, -w / 2 + 0.08, -d / 2 + 0.08, w - 0.16, d - 0.16, 0.2); ctx.fill(); ctx.stroke();
      break;
    case 'shower':
      ctx.beginPath(); ctx.moveTo(-w / 2, -d / 2); ctx.lineTo(w / 2, d / 2); ctx.moveTo(w / 2, -d / 2); ctx.lineTo(-w / 2, d / 2); ctx.stroke();
      break;
    case 'vanity':
      ctx.fillStyle = '#fff'; ctx.beginPath(); ctx.ellipse(0, 0.02, 0.2, 0.15, 0, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
      break;
    case 'wardrobe': case 'fridge': case 'washer': case 'bookshelf':
      ctx.beginPath(); ctx.moveTo(-w / 2, -d / 2); ctx.lineTo(w / 2, d / 2); ctx.moveTo(w / 2, -d / 2); ctx.lineTo(-w / 2, d / 2); ctx.globalAlpha = 0.25; ctx.stroke(); ctx.globalAlpha = 1;
      break;
    case 'tvStand':
      ctx.fillStyle = '#111'; ctx.fillRect(-Math.min(w * 0.85, 1.45) / 2, -d / 2 + 0.08, Math.min(w * 0.85, 1.45), 0.06);
      break;
    case 'stairs': {
      const n = Math.max(8, Math.round((item.h ?? def.h) / 0.17));
      for (let i = 1; i < n; i++) { const y = d / 2 - (d / n) * i; ctx.beginPath(); ctx.moveTo(-w / 2, y); ctx.lineTo(w / 2, y); ctx.stroke(); }
      ctx.beginPath(); ctx.moveTo(0, d / 2 - 0.1); ctx.lineTo(0, -d / 2 + 0.2); ctx.lineTo(-0.12, -d / 2 + 0.35); ctx.moveTo(0, -d / 2 + 0.2); ctx.lineTo(0.12, -d / 2 + 0.35); ctx.stroke();
      break;
    }
    case 'rug':
      ctx.strokeStyle = '#e8d3a9'; ctx.lineWidth = 3 * lw; ctx.strokeRect(-w / 2 + 0.12, -d / 2 + 0.12, w - 0.24, d - 0.24);
      break;
    case 'car':
      ctx.fillStyle = '#1b2631'; rr(ctx, -w * 0.42, -d * 0.18, w * 0.84, d * 0.45, 0.15); ctx.fill();
      break;
  }
}
