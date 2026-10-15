// Người cách điệu (kiểu ảnh phối cảnh kiến trúc): đứng, ngồi; đặt tự động quanh sofa, bàn ăn, bếp, sân vườn.
import * as THREE from 'three';
import { RoundedBoxGeometry } from 'three/examples/jsm/geometries/RoundedBoxGeometry.js';
import { CATALOG_MAP } from './furniture.js';

const SKIN = [0xf1c7a5, 0xe0ac86, 0xc68a62, 0x8d5a3b];
const SHIRTS = [0xffffff, 0x2f3b4c, 0xc0392b, 0x2e86c1, 0xe5b84b, 0x6c8f5b, 0xd98aa6, 0x1f1f1f];
const PANTS = [0x22262d, 0x3b4a63, 0x6b5b4b, 0xe8e2d6];
const HAIR = [0x1b1410, 0x3a2414, 0x6b4a2a];
const mats = new Map();
const m = (c, r = 0.75) => { const k = c + ':' + r; if (!mats.has(k)) mats.set(k, new THREE.MeshStandardMaterial({ color: c, roughness: r })); return mats.get(k); };
const part = (geo, mat, x, y, z) => { const o = new THREE.Mesh(geo, mat); o.position.set(x, y, z); o.castShadow = true; o.receiveShadow = true; return o; };

function rnd(seed) { let s = seed >>> 0; return () => ((s = (s * 1664525 + 1013904223) >>> 0) / 4294967296); }

/** Một người; pose: 'stand' | 'sit'. Mặt hướng +z (giống quy ước nội thất). */
export function person(pose = 'stand', seed = 1) {
  const r = rnd(seed * 7919 + 13);
  const g = new THREE.Group();
  const skin = m(SKIN[Math.floor(r() * SKIN.length)], 0.6), shirt = m(SHIRTS[Math.floor(r() * SHIRTS.length)], 0.85), pants = m(PANTS[Math.floor(r() * PANTS.length)], 0.85), hair = m(HAIR[Math.floor(r() * HAIR.length)], 0.9);
  const tall = 0.94 + r() * 0.12;
  const hip = pose === 'sit' ? 0.46 : 0.86 * tall;
  // Thân, vai, đầu, tóc
  g.add(part(new RoundedBoxGeometry(0.36, 0.56 * tall, 0.21, 3, 0.08), shirt, 0, hip + 0.3 * tall, 0));
  g.add(part(new THREE.CylinderGeometry(0.045, 0.05, 0.08, 10), skin, 0, hip + 0.62 * tall, 0));
  g.add(part(new THREE.SphereGeometry(0.105, 16, 12), skin, 0, hip + 0.74 * tall, 0.005));
  const cap = part(new THREE.SphereGeometry(0.112, 16, 10, 0, Math.PI * 2, 0, Math.PI * 0.55), hair, 0, hip + 0.755 * tall, -0.01);
  g.add(cap);
  // Tay
  for (const s of [-1, 1]) {
    const arm = part(new THREE.CapsuleGeometry(0.045, 0.46 * tall, 4, 8), shirt, s * 0.215, hip + 0.3 * tall, pose === 'sit' ? 0.08 : 0);
    arm.rotation.x = pose === 'sit' ? -0.5 : 0.05 * s;
    g.add(arm);
    g.add(part(new THREE.SphereGeometry(0.045, 8, 6), skin, s * 0.215, hip + (pose === 'sit' ? 0.08 : 0.03) * tall, pose === 'sit' ? 0.22 : 0.02));
  }
  // Chân
  for (const s of [-1, 1]) {
    if (pose === 'sit') {
      const thigh = part(new THREE.CapsuleGeometry(0.068, 0.36, 4, 8), pants, s * 0.1, hip, 0.2);
      thigh.rotation.x = Math.PI / 2;
      g.add(thigh);
      g.add(part(new THREE.CapsuleGeometry(0.058, 0.34, 4, 8), pants, s * 0.1, 0.23, 0.42));
      g.add(part(new RoundedBoxGeometry(0.1, 0.07, 0.24, 2, 0.03), m(0x1d1f22), s * 0.1, 0.035, 0.48));
    } else {
      g.add(part(new THREE.CapsuleGeometry(0.07, hip - 0.15, 4, 8), pants, s * 0.1, hip / 2 + 0.04, 0));
      g.add(part(new RoundedBoxGeometry(0.1, 0.07, 0.25, 2, 0.03), m(0x1d1f22), s * 0.1, 0.035, 0.05));
    }
  }
  g.userData.person = true;
  return g;
}

/** Đặt người hợp lý theo nội thất: ngồi sofa / ghế ăn, đứng bếp. Trả về Group. */
export function placePeople(plan, max = 7) {
  const out = new THREE.Group();
  out.name = 'Người';
  let n = 0, seed = 1;
  const at = (f, lx, lz, pose, faceBack = false) => {
    if (n >= max) return;
    const p = person(pose, seed++);
    const a = (-(f.rot || 0) * Math.PI) / 180;
    const c = Math.cos(a), s = Math.sin(a);
    // Toạ độ cục bộ của đồ (x ngang, z hướng mặt trước) → toạ độ căn
    p.position.set(f.x + lx * c + lz * s, 0, f.y - lx * s + lz * c);
    p.rotation.y = a + (faceBack ? Math.PI : 0);
    out.add(p);
    n++;
  };
  const sz = (f) => { const d = CATALOG_MAP[f.type] || {}; return { w: f.w ?? d.w ?? 1, d: f.d ?? d.d ?? 1 }; };
  const by = (t) => plan.furniture.filter((f) => f.type === t);
  for (const f of by('sofa').slice(0, 1)) { const { w, d } = sz(f); at(f, -w * 0.22, d / 2 - 0.45, 'sit'); at(f, w * 0.18, d / 2 - 0.45, 'sit'); }
  const chairs = by('chair');
  chairs.forEach((f, i) => { if (i % 2 === 0) at(f, 0, -0.02, 'sit'); });
  for (const f of by('kitchen').slice(0, 1)) { const { w, d } = sz(f); at(f, w * 0.1, d / 2 + 0.38, 'stand', true); }
  for (const f of by('armchair').slice(0, 1)) at(f, 0, -0.03, 'sit');
  for (const f of by('desk').slice(0, 1)) { const { d } = sz(f); at(f, 0, d / 2 + 0.3, 'sit', true); }
  return out;
}
