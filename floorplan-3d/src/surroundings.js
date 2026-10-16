// Phối cảnh xung quanh tòa nhà: đại lộ có dải cọ, xe cộ, biệt thự mái ngói, cây hoa, công viên, sông, núi xa, mây.
// Dùng InstancedMesh để vẽ hàng nghìn vật thể nhẹ nhàng.
import * as THREE from 'three';
import { mergeGeometries } from 'three/examples/jsm/utils/BufferGeometryUtils.js';
import { getTexture } from './textures.js';

function rand(seed) { let s = seed >>> 0; return () => ((s = (s * 1664525 + 1013904223) >>> 0) / 4294967296); }

function roadTexture(lanes) {
  const c = document.createElement('canvas');
  c.width = 256; c.height = 256;
  const x = c.getContext('2d');
  x.fillStyle = '#3b3e43'; x.fillRect(0, 0, 256, 256);
  for (let i = 0; i < 2500; i++) { x.fillStyle = `rgba(255,255,255,${Math.random() * 0.05})`; x.fillRect(Math.random() * 256, Math.random() * 256, 2, 2); }
  x.fillStyle = '#e8e8e8';
  for (let l = 1; l < lanes; l++) { const px = (256 * l) / lanes; for (let y = 0; y < 256; y += 64) x.fillRect(px - 2, y, 4, 34); }
  x.fillRect(4, 0, 4, 256); x.fillRect(248, 0, 4, 256);
  const t = new THREE.CanvasTexture(c);
  t.wrapS = t.wrapT = THREE.RepeatWrapping;
  t.colorSpace = THREE.SRGBColorSpace;
  t.anisotropy = 8;
  return t;
}

function cloudTexture() {
  const c = document.createElement('canvas');
  c.width = 256; c.height = 128;
  const x = c.getContext('2d');
  for (let i = 0; i < 22; i++) {
    const cx = 40 + Math.random() * 176, cy = 50 + Math.random() * 40, r = 18 + Math.random() * 30;
    const g = x.createRadialGradient(cx, cy, 0, cx, cy, r);
    g.addColorStop(0, 'rgba(255,255,255,0.9)'); g.addColorStop(1, 'rgba(255,255,255,0)');
    x.fillStyle = g; x.fillRect(0, 0, 256, 128);
  }
  const t = new THREE.CanvasTexture(c);
  t.colorSpace = THREE.SRGBColorSpace;
  return t;
}

/** Hình học cây cọ: thân cong + 8 tàu lá (gộp làm một) */
function palmGeometries() {
  const trunk = new THREE.CylinderGeometry(0.16, 0.26, 8, 7);
  trunk.translate(0, 4, 0);
  const fronds = [];
  for (let i = 0; i < 8; i++) {
    const f = new THREE.ConeGeometry(0.55, 4.2, 4, 1);
    f.scale(1, 1, 0.18);
    f.translate(0, 2.1, 0);
    f.rotateZ(-1.15 - (i % 2) * 0.25);
    f.rotateY((i / 8) * Math.PI * 2);
    f.translate(0, 8, 0);
    fronds.push(f);
  }
  return { trunk, crown: mergeGeometries(fronds) };
}

export function buildSurroundings({ footprint, avenueX, reserved = [], density = 1 }) {
  const g = new THREE.Group();
  const r = rand(7);
  const dummy = new THREE.Object3D();
  const color = new THREE.Color();
  const occupied = [];
  const free = (x, z, rad) => occupied.every((o) => Math.abs(x - o.x) > o.w / 2 + rad || Math.abs(z - o.z) > o.d / 2 + rad);
  const occupy = (x, z, w, d) => occupied.push({ x, z, w, d });
  reserved.forEach((o) => occupy(o.x, o.z, o.w, o.d));

  // --- Mặt đất cỏ lớn ---
  const gt = getTexture('grass').clone();
  gt.needsUpdate = true;
  gt.repeat.set(700, 700);
  const ground = new THREE.Mesh(new THREE.PlaneGeometry(1800, 1800), new THREE.MeshStandardMaterial({ map: gt, roughness: 1 }));
  ground.rotation.x = -Math.PI / 2;
  ground.receiveShadow = true;
  g.add(ground);

  // --- Đường: Minh Mạng (dọc trục z) và Nguyễn Phước Lan (dọc trục x) – cả hai 6 làn, không có
  // dải phân cách, giữa đường vạch vàng đôi, vỉa hè 5 m trồng cọ; cắt nhau tại ngã tư (avenueX, roadZ) ---
  const roadZ = footprint.z1 + 26;
  const HALF = 18; // nửa bề rộng đại lộ tính cả vỉa hè
  const L = 1600;
  const walkMat = new THREE.MeshStandardMaterial({ map: (() => { const t = getTexture('paving').clone(); t.needsUpdate = true; t.repeat.set(2, 500); return t; })(), roughness: 0.9 });
  const yellowMat = new THREE.MeshBasicMaterial({ color: 0xf2c230 });
  const lanesTex = (() => { const t = roadTexture(3); t.repeat.set(1, L / 12); return t; })();
  const laneMat = new THREE.MeshStandardMaterial({ map: lanesTex, roughness: 0.92 });
  const asphalt = new THREE.MeshStandardMaterial({ color: 0x3b3e43, roughness: 0.95 });
  // Dải dọc theo trục đường, bỏ trống đoạn qua ngã tư (gap)
  // Sông Đô Tỏa cắt ngang cuối đường Minh Mạng (theo ảnh 360: Minh Mạng → cầu Bô Quan → sông → biển Sơn Thủy)
  const RIVER_Z0 = -415, RIVER_Z1 = -300, SEA_Z = -640;
  const strip = (axis, center, offset, width, height, y, mat, gap) => {
    const ranges = axis === 'z'
      ? [[SEA_Z + 20, RIVER_Z0], [RIVER_Z1, center.cross - gap], [center.cross + gap, L / 2]]
      : [[-L / 2, center.cross - gap], [center.cross + gap, L / 2]];
    for (const [s0, s1] of ranges) {
      const len = s1 - s0;
      const m = new THREE.Mesh(height ? new THREE.BoxGeometry(width, height, len) : new THREE.PlaneGeometry(width, len), mat);
      if (!height) m.rotation.x = -Math.PI / 2;
      const along = (s0 + s1) / 2;
      if (axis === 'z') m.position.set(center.at + offset, y, along);
      else { m.position.set(along, y, center.at + offset); if (height) m.rotation.y = Math.PI / 2; else m.rotation.z = Math.PI / 2; }
      m.receiveShadow = true;
      g.add(m);
    }
  };
  const boulevards = [
    { axis: 'z', at: avenueX, cross: roadZ, name: 'Minh Mạng' },
    { axis: 'x', at: roadZ, cross: avenueX, name: 'Nguyễn Phước Lan' },
  ];
  for (const bv of boulevards) {
    for (const sd of [-1, 1]) {
      strip(bv.axis, bv, sd * 5.5, 11, 0, bv.axis === 'z' ? 0.03 : 0.032, laneMat, HALF);
      strip(bv.axis, bv, sd * 13.5, 5, 0.18, 0.09, walkMat, HALF);
      strip(bv.axis, bv, sd * 0.18, 0.15, 0, 0.04, yellowMat, HALF); // vạch vàng đôi
    }
    if (bv.axis === 'z') occupy(bv.at, 0, HALF * 2 + 2, L); else occupy(0, bv.at, L, HALF * 2 + 2);
    if (bv.axis === 'z') {
      // Cầu Bô Quan: mặt cầu + lan can bắc qua sông
      const len = RIVER_Z1 - RIVER_Z0 + 16, zc = (RIVER_Z0 + RIVER_Z1) / 2;
      const deck = new THREE.Mesh(new THREE.BoxGeometry(HALF * 2, 1.2, len), new THREE.MeshStandardMaterial({ color: 0xd9d6cf, roughness: 0.8 }));
      deck.position.set(bv.at, 0.4, zc); deck.receiveShadow = deck.castShadow = true; g.add(deck);
      const top = new THREE.Mesh(new THREE.PlaneGeometry(22, len), laneMat); top.rotation.x = -Math.PI / 2; top.position.set(bv.at, 1.02, zc); g.add(top);
      for (const sd of [-1, 1]) { const rail = new THREE.Mesh(new THREE.BoxGeometry(0.4, 1.1, len), new THREE.MeshStandardMaterial({ color: 0xf2f0ea })); rail.position.set(bv.at + sd * (HALF - 0.3), 1.55, zc); g.add(rail); }
    }
  }
  // Mặt ngã tư
  for (const [w, d] of [[22, HALF * 2], [HALF * 2, 22]]) {
    const box = new THREE.Mesh(new THREE.PlaneGeometry(w, d), asphalt);
    box.rotation.x = -Math.PI / 2;
    box.position.set(avenueX, 0.028, roadZ);
    box.receiveShadow = true;
    g.add(box);
  }
  // Góc vỉa hè ở 4 góc ngã tư (lấp chỗ hở giữa vỉa hè hai đường)
  for (const sx of [-1, 1]) for (const sz of [-1, 1]) {
    const c = new THREE.Mesh(new THREE.BoxGeometry(HALF - 11, 0.18, HALF - 11), walkMat);
    c.position.set(avenueX + sx * (11 + (HALF - 11) / 2), 0.09, roadZ + sz * (11 + (HALF - 11) / 2));
    c.receiveShadow = true;
    g.add(c);
  }
  // Vạch qua đường ở 4 nhánh: các vạch song song hướng đi bộ, xếp ngang lòng đường
  const zebra = new THREE.MeshBasicMaterial({ color: 0xf2f2f2 });
  for (const [dx, dz] of [[0, -1], [0, 1], [-1, 0], [1, 0]]) {
    for (let i = 0; i < 17; i++) {
      const off = -9.6 + i * 1.2;
      const s = new THREE.Mesh(new THREE.PlaneGeometry(0.6, 4), zebra);
      s.rotation.x = -Math.PI / 2;
      if (dz) s.position.set(avenueX + off, 0.05, roadZ + dz * (HALF - 3));
      else { s.position.set(avenueX + dx * (HALF - 3), 0.05, roadZ + off); s.rotation.z = Math.PI / 2; }
      g.add(s);
    }
  }

  // --- Quảng trường & vườn trước tòa ---
  const apron = roadZ - HALF - footprint.z1; // khoảng sân từ chân tòa ra vỉa hè
  const plaza = new THREE.Mesh(new THREE.BoxGeometry(footprint.x1 - footprint.x0 + 10, 0.15, apron), walkMat);
  plaza.position.set((footprint.x0 + footprint.x1) / 2 + 3, 0.075, footprint.z1 + apron / 2);
  plaza.receiveShadow = true;
  g.add(plaza);
  occupy(plaza.position.x, plaza.position.z, footprint.x1 - footprint.x0 + 10, apron);
  occupy((footprint.x0 + footprint.x1) / 2, (footprint.z0 + footprint.z1) / 2, footprint.x1 - footprint.x0 + 10, footprint.z1 - footprint.z0 + 10);

  // --- Sông Đô Tỏa (cắt ngang cuối Minh Mạng), bờ biển Sơn Thủy phía xa, núi Sơn Trà (trái) & Ngũ Hành Sơn (phải) ---
  const waterMat = new THREE.MeshStandardMaterial({ color: 0x4f86b3, roughness: 0.08, metalness: 0.5 });
  const river = new THREE.Mesh(new THREE.PlaneGeometry(1800, RIVER_Z1 - RIVER_Z0), waterMat);
  river.rotation.x = -Math.PI / 2;
  river.position.set(0, 0.05, (RIVER_Z0 + RIVER_Z1) / 2);
  g.add(river);
  occupy(0, (RIVER_Z0 + RIVER_Z1) / 2, 1800, RIVER_Z1 - RIVER_Z0 + 20);
  const sea = new THREE.Mesh(new THREE.PlaneGeometry(1800, 400), new THREE.MeshStandardMaterial({ color: 0x3f7fb8, roughness: 0.05, metalness: 0.45 }));
  sea.rotation.x = -Math.PI / 2;
  sea.position.set(0, 0.05, SEA_Z - 200);
  g.add(sea);
  const sand = new THREE.Mesh(new THREE.PlaneGeometry(1800, 26), new THREE.MeshStandardMaterial({ color: 0xe8dcbc, roughness: 1 }));
  sand.rotation.x = -Math.PI / 2;
  sand.position.set(0, 0.045, SEA_Z + 10);
  g.add(sand);
  occupy(0, SEA_Z - 180, 1800, 420);
  const mountainMat = new THREE.MeshStandardMaterial({ color: 0x5f7f68, roughness: 1, flatShading: true });
  const hill = (x, z, rad, h, sx = 1) => { const m = new THREE.Mesh(new THREE.SphereGeometry(1, 9, 6, 0, Math.PI * 2, 0, Math.PI / 2), mountainMat); m.scale.set(rad * sx, h, rad * 0.5); m.position.set(x, -2, z); g.add(m); };
  for (let i = 0; i < 5; i++) hill(-1020 + i * 90 + r() * 30, -880 - r() * 30, 150 + r() * 70, 110 + r() * 70, 1.3); // Sơn Trà (bên kia vịnh, lệch trái như ảnh 360)
  for (let i = 0; i < 4; i++) hill(260 + i * 45, -560 - r() * 30, 18 + r() * 10, 35 + r() * 25); // Ngũ Hành Sơn (gần biển, bên phải)
  occupy(330, -560, 220, 70);

  // --- Mây ---
  const cloudMat = new THREE.SpriteMaterial({ map: cloudTexture(), transparent: true, depthWrite: false, fog: false });
  for (let i = 0; i < 18; i++) {
    const s = new THREE.Sprite(cloudMat);
    s.position.set(-900 + r() * 1800, 220 + r() * 160, -900 + r() * 1300);
    s.scale.set(220 + r() * 160, 90 + r() * 50, 1);
    g.add(s);
  }

  // --- Biệt thự / nhà phố mái ngói (thân + mái, dạng instanced) ---
  const houses = [];
  for (let gx = -560; gx <= 300; gx += 24) {
    for (let gz = -560; gz <= 380; gz += 20) {
      const x = gx + (r() - 0.5) * 4, z = gz + (r() - 0.5) * 4;
      if (!free(x, z, 9)) continue;
      if (Math.hypot(x, z) < 85) continue;
      if (r() < 0.18 || r() > density) continue;
      houses.push({ x, z, w: 11 + r() * 4, d: 9 + r() * 3, h: 7 + Math.floor(r() * 2) * 3.2, rot: (Math.round(r()) * Math.PI) / 2 });
    }
  }
  const bodyMesh = new THREE.InstancedMesh(new THREE.BoxGeometry(1, 1, 1), new THREE.MeshStandardMaterial({ roughness: 0.8 }), houses.length);
  const roofGeo = new THREE.ConeGeometry(0.75, 1, 4);
  roofGeo.rotateY(Math.PI / 4);
  const roofMesh = new THREE.InstancedMesh(roofGeo, new THREE.MeshStandardMaterial({ roughness: 0.7 }), houses.length);
  const wallColors = [0xf3e7d3, 0xefe2c9, 0xf6f1e8, 0xe9dcc4, 0xf1e4cc];
  const roofColors = [0xb5532f, 0xc0603a, 0xa34a2b, 0xc96d3f];
  houses.forEach((h, i) => {
    dummy.position.set(h.x, h.h / 2, h.z); dummy.rotation.set(0, h.rot, 0); dummy.scale.set(h.w, h.h, h.d); dummy.updateMatrix();
    bodyMesh.setMatrixAt(i, dummy.matrix);
    bodyMesh.setColorAt(i, color.setHex(wallColors[i % wallColors.length]));
    dummy.position.set(h.x, h.h + 1.6, h.z); dummy.scale.set(h.w * 1.08, 3.2, h.d * 1.08); dummy.updateMatrix();
    roofMesh.setMatrixAt(i, dummy.matrix);
    roofMesh.setColorAt(i, color.setHex(roofColors[i % roofColors.length]));
    occupy(h.x, h.z, h.w + 3, h.d + 3);
  });
  bodyMesh.castShadow = bodyMesh.receiveShadow = true;
  roofMesh.castShadow = true;
  g.add(bodyMesh, roofMesh);

  // --- Tòa cao tầng xa ---
  const farTowers = [[-260, -470, 70], [-180, -520, 55], [160, -470, 62], [120, -540, 80], [-330, -480, 45], [-420, -250, 50], [520, 120, 40], [560, -60, 58], [520, -220, 48]];
  const towerMat = new THREE.MeshStandardMaterial({ map: (() => {
    const c = document.createElement('canvas'); c.width = 64; c.height = 64; const x = c.getContext('2d');
    x.fillStyle = '#d7d4cc'; x.fillRect(0, 0, 64, 64); x.fillStyle = '#5d7184';
    for (let i = 0; i < 4; i++) for (let j = 0; j < 4; j++) x.fillRect(4 + i * 15, 4 + j * 15, 10, 9);
    const t = new THREE.CanvasTexture(c); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.repeat.set(4, 12); t.colorSpace = THREE.SRGBColorSpace; return t;
  })(), roughness: 0.6 });
  for (const [x, z, h] of farTowers) {
    const m = new THREE.Mesh(new THREE.BoxGeometry(24, h, 20), towerMat);
    m.position.set(x, h / 2, z);
    g.add(m);
  }

  // --- Cây: cọ dọc đường, cây tán tròn & cây hoa trong vườn ---
  const palms = [];
  const step = density < 1 ? 22 : 11;
  for (let t = -780; t <= 780; t += step) {
    const nearZ = Math.abs(t - roadZ) < HALF + 3, nearX = Math.abs(t - avenueX) < HALF + 3;
    if (!nearZ && Math.abs(t) < 400) { palms.push([avenueX - 14.5, t + 5]); palms.push([avenueX + 14.5, t + 5]); }
    if (!nearX && Math.abs(t) < 400) { palms.push([t + 5, roadZ - 14.5]); palms.push([t + 5, roadZ + 14.5]); }
  }
  const pg = palmGeometries();
  const trunkMesh = new THREE.InstancedMesh(pg.trunk, new THREE.MeshStandardMaterial({ color: 0x8a6a4a, roughness: 1 }), palms.length);
  const crownMesh = new THREE.InstancedMesh(pg.crown, new THREE.MeshStandardMaterial({ color: 0x3f8a36, roughness: 0.8, flatShading: true, side: THREE.DoubleSide }), palms.length);
  palms.forEach(([x, z], i) => {
    const s = 0.85 + r() * 0.35;
    dummy.position.set(x, 0, z); dummy.rotation.set((r() - 0.5) * 0.12, r() * 6.28, (r() - 0.5) * 0.12); dummy.scale.setScalar(s); dummy.updateMatrix();
    trunkMesh.setMatrixAt(i, dummy.matrix);
    crownMesh.setMatrixAt(i, dummy.matrix);
  });
  trunkMesh.castShadow = crownMesh.castShadow = true;
  g.add(trunkMesh, crownMesh);

  const trees = [];
  for (let i = 0; i < 1400 * density; i++) {
    const x = -600 + r() * 940, z = -600 + r() * 1000;
    if (!free(x, z, 3)) continue;
    trees.push([x, z]);
  }
  // Vườn quanh chân tòa
  for (let i = 0; i < 70; i++) {
    const a = r() * Math.PI * 2, d = 38 + r() * 30;
    const x = Math.cos(a) * d * 1.2, z = Math.sin(a) * d;
    if (free(x, z, 2)) trees.push([x, z]);
  }
  const tTrunk = new THREE.InstancedMesh(new THREE.CylinderGeometry(0.2, 0.3, 3, 6).translate(0, 1.5, 0), new THREE.MeshStandardMaterial({ color: 0x6b4a32 }), trees.length);
  const tCrown = new THREE.InstancedMesh(new THREE.IcosahedronGeometry(2.6, 1), new THREE.MeshStandardMaterial({ roughness: 0.85, flatShading: true }), trees.length);
  const greens = [0x3f7d33, 0x4e8f3a, 0x5fa047, 0x356b2c], blooms = [0xc85aa8, 0xe2709a, 0xd9443c, 0x9b5fc7, 0xf2a03d];
  trees.forEach(([x, z], i) => {
    const s = 0.7 + r() * 0.8;
    dummy.position.set(x, 0, z); dummy.rotation.set(0, r() * 6, 0); dummy.scale.setScalar(s); dummy.updateMatrix();
    tTrunk.setMatrixAt(i, dummy.matrix);
    dummy.position.set(x, 3.6 * s, z); dummy.scale.set(s * (0.9 + r() * 0.3), s * (0.8 + r() * 0.3), s * (0.9 + r() * 0.3)); dummy.updateMatrix();
    tCrown.setMatrixAt(i, dummy.matrix);
    tCrown.setColorAt(i, color.setHex(r() < 0.18 ? blooms[Math.floor(r() * blooms.length)] : greens[Math.floor(r() * greens.length)]));
  });
  tTrunk.castShadow = tCrown.castShadow = true;
  g.add(tTrunk, tCrown);

  // --- Xe trên đại lộ ---
  const cars = [];
  for (let z = -780; z < 780; z += 9 + r() * 30) {
    if (Math.abs(z - roadZ) < HALF) continue;
    const lane = Math.floor(r() * 6);
    const x = lane < 3 ? avenueX - 9.4 + lane * 3.6 : avenueX + 2.2 + (lane - 3) * 3.6;
    cars.push([x, z, 0]);
  }
  for (let x = -780; x < 780; x += 9 + r() * 30) {
    if (Math.abs(x - avenueX) < HALF) continue;
    const lane = Math.floor(r() * 6);
    const z = lane < 3 ? roadZ - 9.4 + lane * 3.6 : roadZ + 2.2 + (lane - 3) * 3.6;
    cars.push([x, z, Math.PI / 2]);
  }
  const carMesh = new THREE.InstancedMesh(new THREE.BoxGeometry(1.8, 1.4, 4.3).translate(0, 0.75, 0), new THREE.MeshStandardMaterial({ roughness: 0.3, metalness: 0.5 }), cars.length);
  const carColors = [0xffffff, 0x1d1f22, 0x9aa3ab, 0xc0392b, 0x2e5d8a, 0xd9d9d9];
  cars.forEach(([x, z, ry], i) => {
    dummy.position.set(x, 0, z); dummy.rotation.set(0, ry, 0); dummy.scale.setScalar(1); dummy.updateMatrix();
    carMesh.setMatrixAt(i, dummy.matrix);
    carMesh.setColorAt(i, color.setHex(carColors[i % carColors.length]));
  });
  carMesh.castShadow = true;
  g.add(carMesh);

  // --- Bồn hoa quảng trường ---
  const flowerMesh = new THREE.InstancedMesh(new THREE.SphereGeometry(0.5, 6, 4), new THREE.MeshStandardMaterial({ roughness: 0.9 }), 260);
  for (let i = 0; i < 260; i++) {
    dummy.position.set(footprint.x0 - 4 + r() * (footprint.x1 - footprint.x0 + 8), 0.3, footprint.z1 + 1.2 + r() * 2.5);
    dummy.scale.set(1 + r(), 0.6, 1 + r()); dummy.updateMatrix();
    flowerMesh.setMatrixAt(i, dummy.matrix);
    flowerMesh.setColorAt(i, color.setHex(i % 3 === 0 ? 0x4e8f3a : blooms[i % blooms.length]));
  }
  g.add(flowerMesh);
  return g;
}
