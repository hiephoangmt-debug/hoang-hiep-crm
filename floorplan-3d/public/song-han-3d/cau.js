// Các cầu qua sông Hàn trong khu Sông Hàn 3D, dựng 3D theo trục cầu OpenStreetMap / ảnh vệ tinh và kích thước công bố:
//  · Cầu Rồng: dài 666 m, rộng 37,5 m, mặt cầu ~10 m trên mặt nước, thân rồng thép vàng 5 vòm uốn lượn, đầu rồng quay ra biển (Đông)
//  · Cầu Trần Thị Lý: dây văng 1 trụ tháp nghiêng cao ~145 m, dây toả về nhịp chính phía Đông
//  · Cầu Nguyễn Văn Trỗi: cầu thép cũ (nay đi bộ), dàn thép hai bên
//  · Cầu đi bộ Da Nang Downtown (QH 1/500, ô 13): từ góc Phan Đăng Lưu sang bờ Đông, hai vòm hình lá
// addBridges(THREE, parent, LL) -> { setNight(0..1) }
export function addBridges(THREE, parent, LL) {
  const V = (x, y, z) => new THREE.Vector3(x, y, z);
  const deckM = new THREE.MeshStandardMaterial({ color: 0x8d8f94, roughness: 0.85 });
  const sideM = new THREE.MeshStandardMaterial({ color: 0xd9d6cf, roughness: 0.6 });
  const pierM = new THREE.MeshStandardMaterial({ color: 0xbdb8ad, roughness: 0.8 });
  const dragonM = new THREE.MeshStandardMaterial({ color: 0xe0a92a, roughness: 0.35, metalness: 0.6, emissive: 0xffb020, emissiveIntensity: 0 });
  const whiteM = new THREE.MeshStandardMaterial({ color: 0xf2f2ee, roughness: 0.35, metalness: 0.4, emissive: 0xbfe0ff, emissiveIntensity: 0 });
  const cableM = new THREE.LineBasicMaterial({ color: 0xf5f5f5 });
  const trussM = new THREE.MeshStandardMaterial({ color: 0x6f8fa8, roughness: 0.5, metalness: 0.5, emissive: 0x7b5cff, emissiveIntensity: 0 });
  const woodM = new THREE.MeshStandardMaterial({ color: 0xc9a77a, roughness: 0.8 });
  const add = (m) => { m.castShadow = m.receiveShadow = true; parent.add(m); return m; };

  // mặt cầu thẳng từ A tới B, cao y, rộng w; trụ cầu mỗi `span` mét
  function deck(A, B, y, w, span, mat = deckM) {
    const dx = B[0] - A[0], dz = B[1] - A[1], L = Math.hypot(dx, dz), ang = Math.atan2(-dz, dx);
    const d = add(new THREE.Mesh(new THREE.BoxGeometry(L, 2.2, w), mat)); d.position.set((A[0] + B[0]) / 2, y - 1.1, (A[1] + B[1]) / 2); d.rotation.y = ang;
    for (const s of [-1, 1]) { const r = add(new THREE.Mesh(new THREE.BoxGeometry(L, 1.2, 0.6), sideM)); r.position.set(d.position.x, y + 0.6, d.position.z); r.rotation.y = ang; r.translateZ(s * (w / 2 - 0.3)); }
    for (let t = span; t < L - span / 2; t += span) { const p = add(new THREE.Mesh(new THREE.BoxGeometry(4, y, w * 0.6), pierM)); p.position.set(A[0] + dx * t / L, y / 2 - 2, A[1] + dz * t / L); p.rotation.y = ang; }
    return { L, ang, ux: dx / L, uz: dz / L };
  }

  // ---- Cầu Rồng ----
  {
    const A = LL(16.06106, 108.22445), B = LL(16.06128, 108.23145), y = 10;
    const { L, ux, uz } = deck(A, B, y, 37.5, 90);
    // thân rồng: 5 nhịp vòm, phần võng xuống chui dưới mặt cầu; chạy giữa hai chiều xe
    const pts = [];
    for (let i = 0; i <= 240; i++) { const t = i / 240, u = 0.1 + t * 0.82, s = Math.sin(t * Math.PI * 9), amp = 18 + 12 * Math.sin(Math.PI * t);
      pts.push(V(A[0] + (B[0] - A[0]) * u, y + (s > 0 ? amp * s : 7 * s), A[1] + (B[1] - A[1]) * u)); }
    const tail = [V(A[0] + (B[0] - A[0]) * 0.07, y + 2, A[1] + (B[1] - A[1]) * 0.07), ...pts];
    add(new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(tail), 400, 2.6, 10), dragonM));
    // vây lưng dọc thân
    for (let i = 4; i < 240; i += 6) { const p = pts[i], f = add(new THREE.Mesh(new THREE.ConeGeometry(0.9, 3.5, 4), dragonM)); f.position.set(p.x, p.y + 3, p.z); }
    // đầu rồng ở đầu phía Đông, ngẩng lên hướng ra biển
    const H = pts[pts.length - 1], head = new THREE.Group(); head.position.set(H.x + ux * 6, H.y + 6, H.z + uz * 6); head.rotation.y = Math.atan2(-uz, ux); parent.add(head);
    const skull = new THREE.Mesh(new THREE.ConeGeometry(4, 16, 10), dragonM); skull.rotation.z = -Math.PI / 2 - 0.35; skull.position.x = 6; head.add(skull);
    const neck = new THREE.Mesh(new THREE.CylinderGeometry(2.4, 2.8, 12, 10), dragonM); neck.rotation.z = -0.5; neck.position.set(-2, -3, 0); head.add(neck);
    for (const s of [-1, 1]) { const h = new THREE.Mesh(new THREE.ConeGeometry(0.8, 7, 6), dragonM); h.position.set(2, 5, s * 2.2); h.rotation.z = 0.6; head.add(h); }
  }

  // ---- Cầu Trần Thị Lý: dây văng, trụ tháp nghiêng ~145 m ----
  {
    const A = LL(16.04985, 108.22655), B = LL(16.0508, 108.23351), y = 12;
    const { L, ux, uz, ang } = deck(A, B, y, 34.5, 70);
    const P = LL(16.05036, 108.22786), tilt = 0.5, H = 145;     // chân tháp; nghiêng về phía Tây (ngược nhịp chính)
    const leg = add(new THREE.Mesh(new THREE.BoxGeometry(6, H, 4.5), whiteM));
    const top = V(P[0] - ux * Math.sin(tilt) * H, y + Math.cos(tilt) * H, P[1] - uz * Math.sin(tilt) * H);
    leg.position.set((P[0] + top.x) / 2, (y + top.y) / 2, (P[1] + top.z) / 2);
    leg.lookAt(top); leg.rotateX(Math.PI / 2);
    const segs = [];
    for (let k = 0; k < 18; k++) {                                     // dây toả từ thân tháp xuống nhịp phía Đông, 2 mặt phẳng dây
      const h = 0.35 + 0.65 * k / 17, a = V(P[0] + (top.x - P[0]) * h, y + (top.y - y) * h, P[1] + (top.z - P[1]) * h), dist = 40 + k * 15;
      for (const s of [-1, 1]) segs.push(a.x, a.y, a.z, P[0] + ux * dist - uz * s * 6, y + 1, P[1] + uz * dist + ux * s * 6);
    }
    const cg = new THREE.BufferGeometry(); cg.setAttribute('position', new THREE.Float32BufferAttribute(segs, 3)); parent.add(new THREE.LineSegments(cg, cableM));
  }

  // ---- Cầu Nguyễn Văn Trỗi (đo trên ảnh vệ tinh): cầu thép cũ, nay là cầu đi bộ ----
  {
    const A = LL(16.0508, 108.22678), B = LL(16.05149, 108.23156), y = 8;
    const { L, ux, uz, ang } = deck(A, B, y, 12, 45, woodM);
    for (let t = 30; t < L - 30; t += 45) for (const s of [-1, 1]) {               // dàn thép mỗi nhịp
      const cx = A[0] + ux * (t + 22), cz = A[1] + uz * (t + 22);
      const top = add(new THREE.Mesh(new THREE.BoxGeometry(40, 0.8, 0.8), trussM)); top.position.set(cx - uz * s * 6, y + 7, cz + ux * s * 6); top.rotation.y = ang;
      for (let k = -2; k <= 2; k++) { const d = add(new THREE.Mesh(new THREE.BoxGeometry(0.5, 9, 0.5), trussM)); d.position.set(cx + ux * k * 9 - uz * s * 6, y + 3.5, cz + uz * k * 9 + ux * s * 6); d.rotation.set(0, ang, k % 2 ? 0.45 : -0.45); }
    }
  }

  // ---- Cầu đi bộ Da Nang Downtown: hai vòm trắng hình lá, mặt cầu gỗ ----
  {
    const A = LL(16.03950, 108.23345), B = LL(16.03985, 108.23700);
    const dx = B[0] - A[0], dz = B[1] - A[1], L = Math.hypot(dx, dz), ux = dx / L, uz = dz / L, nx = -uz, nz = ux;
    const at = (t, off, h) => V(A[0] + dx * t + nx * off, h, A[1] + dz * t + nz * off);
    const deckC = [], archL = [], archR = [];
    for (let i = 0; i <= 40; i++) { const t = i / 40, s = Math.sin(Math.PI * t);
      deckC.push(at(t, 0, 7 + 5 * s)); archL.push(at(t, -6 - 16 * s, 7 + 24 * s)); archR.push(at(t, 6 + 16 * s, 7 + 24 * s)); }
    // mặt cầu cong nhẹ, phình rộng ở giữa (hình lá)
    const pos = [], idx = [];
    deckC.forEach((p, i) => { const w = 5 + 12 * Math.sin(Math.PI * i / 40); pos.push(p.x - nx * w, p.y, p.z - nz * w, p.x + nx * w, p.y, p.z + nz * w); if (i) { const b = (i - 1) * 2; idx.push(b, b + 2, b + 1, b + 1, b + 2, b + 3); } });
    const g = new THREE.BufferGeometry(); g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3)); g.setIndex(idx); g.computeVertexNormals();
    add(new THREE.Mesh(g, new THREE.MeshStandardMaterial({ color: 0xc9a77a, roughness: 0.8, side: THREE.DoubleSide })));
    for (const arc of [archL, archR]) {
      add(new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(arc), 120, 1.3, 8), whiteM));
      const hs = []; for (let i = 2; i < 40; i += 2) { const a = arc[i], d = deckC[i]; hs.push(a.x, a.y, a.z, d.x + (a.x - d.x) * 0.3, d.y, d.z + (a.z - d.z) * 0.3); }
      const hg = new THREE.BufferGeometry(); hg.setAttribute('position', new THREE.Float32BufferAttribute(hs, 3)); parent.add(new THREE.LineSegments(hg, cableM));
    }
    for (const t of [0.2, 0.4, 0.6, 0.8]) { const p = deckC[Math.round(t * 40)], pr = add(new THREE.Mesh(new THREE.CylinderGeometry(1.4, 1.8, p.y, 10), pierM)); pr.position.set(p.x, p.y / 2 - 0.5, p.z); }
  }

  return { setNight(v) { dragonM.emissiveIntensity = v * 1.2; whiteM.emissiveIntensity = v * 0.5; trussM.emissiveIntensity = v * 0.9; } };
}
