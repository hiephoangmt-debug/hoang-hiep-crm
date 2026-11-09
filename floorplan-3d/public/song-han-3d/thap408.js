// Tháp 69 tầng ~408 m – Da Nang Downtown, dựng theo phối cảnh & sa bàn của chủ đầu tư:
//  · thân gần vuông bo góc, nở nhẹ dần lên đỉnh, lam đứng màu vàng đồng
//  · "con mắt" vòm cung phát sáng gần đỉnh, quay ra sông (+x)
//  · một mặt (+z) loe xuống chân như vạt áo, có các bậc vườn xanh trên mặt dốc
//  · khối đế các dải cong giật cấp viền vàng, mái phủ cây xanh, ôm chân tháp
// Dùng chung cho song-han-3d và da-nang-3d: makeTower408(THREE) -> { group, setNight(0..1) }
export function makeTower408(THREE) {
  const g = new THREE.Group();
  const H = 400, HS = 165, E = 78;                      // cao thân, chiều cao vạt loe, độ vươn của vạt
  const W = (y) => 40 + 5 * (y / H), D = (y) => 31 + 4 * (y / H);
  const skirt = (y) => (y < HS ? E * Math.pow(1 - y / HS, 2.1) : 0);

  // ---- vật liệu ----
  const tex = (lit) => {
    const c = document.createElement('canvas'); c.width = c.height = 256; const x = c.getContext('2d');
    if (lit) { x.fillStyle = '#000'; x.fillRect(0, 0, 256, 256);
      for (let i = 0; i < 16; i++) for (let j = 0; j < 4; j++) { const r = Math.abs(Math.sin(i * 12.99 + j * 78.23) * 43758.5) % 1; x.fillStyle = r < 0.7 ? (r < 0.2 ? '#ffe0a8' : '#f2b064') : '#2a1c10'; x.fillRect(i * 16, j * 64, 16, 64); } }
    else { const gr = x.createLinearGradient(0, 0, 256, 0); gr.addColorStop(0, '#4d6a82'); gr.addColorStop(0.5, '#7d97ab'); gr.addColorStop(1, '#4d6a82'); x.fillStyle = gr; x.fillRect(0, 0, 256, 256); }
    x.fillStyle = lit ? '#000' : '#d6b073'; for (let i = 0; i < 16; i++) x.fillRect(i * 16 + 5, 0, 6, 256);   // lam đứng
    x.fillStyle = lit ? '#000' : '#c7ab78'; for (let j = 0; j < 4; j++) x.fillRect(0, j * 64, 256, 4);        // vạch sàn
    const t = new THREE.CanvasTexture(c); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.colorSpace = THREE.SRGBColorSpace; t.anisotropy = 8; return t;
  };
  const skinM = new THREE.MeshStandardMaterial({ map: tex(0), emissiveMap: tex(1), emissive: 0xffffff, emissiveIntensity: 0, roughness: 0.25, metalness: 0.35 });
  const goldM = new THREE.MeshStandardMaterial({ color: 0xd2ad6a, roughness: 0.3, metalness: 0.75, emissive: 0xffb050, emissiveIntensity: 0.05 });
  const greenM = new THREE.MeshStandardMaterial({ color: 0x5f8a45, roughness: 0.9 });
  const glassM = new THREE.MeshStandardMaterial({ color: 0xcfae78, roughness: 0.15, metalness: 0.4, emissive: 0xffcf8f, emissiveIntensity: 0 });
  const eyeM = new THREE.MeshStandardMaterial({ color: 0x7a4a22, roughness: 0.4, emissive: 0xff9438, emissiveIntensity: 0.8, side: THREE.DoubleSide });

  // ---- thân tháp: nội suy các mặt cắt chữ nhật bo góc ----
  const NC = 6, R = 6;                                    // điểm mỗi góc, bán kính bo
  const ring = (y) => {
    const w = W(y) / 2, d = D(y) / 2, e = skirt(y), fl = y < 40 ? 1 + 0.07 * (1 - y / 40) ** 2 : 1, pts = [];
    for (const [cx, cz, a0] of [[w - R, d - R, 0], [-(w - R), d - R, Math.PI / 2], [-(w - R), -(d - R), Math.PI], [w - R, -(d - R), Math.PI * 1.5]])
      for (let i = 0; i <= NC; i++) { const a = a0 + (i / NC) * Math.PI / 2; let x = (cx + R * Math.cos(a)) * fl, z = cz + R * Math.sin(a); if (z > 0) z += e * Math.min(1, z / d); pts.push([x, z]); }
    return pts;
  };
  const ys = []; for (let i = 0; i <= 80; i++) ys.push(H * Math.pow(i / 80, 1.6));   // dày hơn ở chân để vạt cong mượt
  const n = ring(0).length, pos = [], uv = [], idx = [];
  ys.forEach((y, j) => { const p = ring(y); let L = 0; for (let i = 0; i <= n; i++) { const a = p[i % n], b = p[(i + 1) % n]; pos.push(a[0], y, a[1]); uv.push(L / 24, y / 13.6); L += Math.hypot(b[0] - a[0], b[1] - a[1]); } });
  for (let j = 0; j < ys.length - 1; j++) for (let i = 0; i < n; i++) { const a = j * (n + 1) + i, b = a + n + 1; idx.push(a, b, a + 1, a + 1, b, b + 1); }
  const sg = new THREE.BufferGeometry(); sg.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3)); sg.setAttribute('uv', new THREE.Float32BufferAttribute(uv, 2)); sg.setIndex(idx); sg.computeVertexNormals();
  const shaft = new THREE.Mesh(sg, skinM); shaft.castShadow = shaft.receiveShadow = true; g.add(shaft);
  // mái + gờ đỉnh
  const top = ring(H), shp = new THREE.Shape(top.map(([x, z]) => new THREE.Vector2(x, -z)));
  const cap = new THREE.Mesh(new THREE.ShapeGeometry(shp), goldM); cap.rotation.x = -Math.PI / 2; cap.position.y = H; g.add(cap);
  const rim = new THREE.Mesh(new THREE.ExtrudeGeometry(shp, { depth: 8, bevelEnabled: false }), skinM); rim.rotation.x = -Math.PI / 2; rim.position.y = H; rim.scale.set(1.0, 1.0, 1); g.add(rim);
  // "con mắt" vòm cung gần đỉnh, mặt hướng sông (+x)
  { const ew = D(350) * 0.55, eh = 64, s = new THREE.Shape(); s.moveTo(-ew / 2, 0); s.lineTo(ew / 2, 0); s.lineTo(ew / 2, eh - ew / 2); s.absarc(0, eh - ew / 2, ew / 2, 0, Math.PI, false); s.lineTo(-ew / 2, 0);
    const eye = new THREE.Mesh(new THREE.ShapeGeometry(s, 24), eyeM); eye.rotation.y = Math.PI / 2; eye.position.set(W(330) / 2 + 0.4, 322, 0); g.add(eye);
    const fr = new THREE.Mesh(new THREE.ExtrudeGeometry(s, { depth: 1, bevelEnabled: false, curveSegments: 24 }), goldM); fr.rotation.y = Math.PI / 2; fr.scale.set(1.12, 1.06, 1); fr.position.set(W(330) / 2 + 0.1, 319, 0); g.add(fr); eye.position.x += 0.6; }
  // các bậc vườn xanh trên mặt vạt loe (+z)
  for (let y = 12; y < HS - 10; y += 11) { const z = D(y) / 2 + skirt(y), w = W(y) * 0.78;
    const b = new THREE.Mesh(new THREE.BoxGeometry(w, 2.2, 5), greenM); b.position.set(0, y + 1.1, z - 1.5); g.add(b);
    const rl = new THREE.Mesh(new THREE.BoxGeometry(w, 0.6, 0.6), goldM); rl.position.set(0, y + 2.4, z + 1); g.add(rl); }
  // ---- khối đế: các dải cong giật cấp viền vàng, mái xanh, ôm chân tháp phía vạt loe ----
  const band = (cx, cz, A, B, t, a0, a1, h, y0) => {
    const s = new THREE.Shape(), k = 48;
    for (let i = 0; i <= k; i++) { const a = a0 + (a1 - a0) * i / k; s[i ? 'lineTo' : 'moveTo'](A * Math.cos(a), B * Math.sin(a)); }
    for (let i = k; i >= 0; i--) { const a = a0 + (a1 - a0) * i / k; s.lineTo((A - t) * Math.cos(a), (B - t) * Math.sin(a)); }
    const body = new THREE.Mesh(new THREE.ExtrudeGeometry(s, { depth: h, bevelEnabled: false, curveSegments: 6 }), glassM); body.rotation.x = -Math.PI / 2; body.position.set(cx, y0, cz); body.castShadow = body.receiveShadow = true; g.add(body);
    const lip = new THREE.Mesh(new THREE.ExtrudeGeometry(s, { depth: 1.4, bevelEnabled: false, curveSegments: 6 }), goldM); lip.rotation.x = -Math.PI / 2; lip.position.set(cx, y0 + h, cz); g.add(lip);
    const roof = new THREE.Mesh(new THREE.ShapeGeometry(s, 6), greenM); roof.rotation.x = -Math.PI / 2; roof.position.set(cx, y0 + h + 1.5, cz); g.add(roof);
  };
  // tâm vòng xoáy lệch về phía vạt loe; mỗi tầng nhỏ dần, xoay dần như sa bàn
  // góc a: 0 = phía sông (+x), π/2 = phía Phan Đăng Lưu (-z); dải chạy từ Tây Bắc qua Tây sang Nam, không lấn ra đường ven sông
  for (let k = 0; k < 5; k++) band(-25, 30, 118 - k * 16, 74 - k * 11, 22 - k * 2, 2.2 + k * 0.25, 5.0 - k * 0.12, 6.5, k * 6.5);

  const setNight = (v) => { skinM.emissiveIntensity = v * 1.0; goldM.emissiveIntensity = 0.05 + v * 0.9; glassM.emissiveIntensity = v * 0.5; eyeM.emissiveIntensity = 0.8 + v * 1.6; };
  return { group: g, setNight, height: H + 8 };
}

// Sun Galaxy Complex (bờ Đông, đối diện Da Nang Downtown): tháp 47 tầng ~183 m với ô cửa tròn "Moon Gate" quay ra sông (+z),
// khối đế TTTM/khách sạn Accor và khán đài pháo hoa DIFF giật cấp dọc bờ sông. makeGalaxy(THREE) -> { group, setNight }
export function makeGalaxy(THREE) {
  const g = new THREE.Group(), H = 183, Wt = 78, Dt = 26, RH = 25, YH = 122;
  const tex = (lit) => {
    const c = document.createElement('canvas'); c.width = c.height = 256; const x = c.getContext('2d');
    x.fillStyle = lit ? '#000' : '#5f7d96'; x.fillRect(0, 0, 256, 256);
    if (lit) for (let i = 0; i < 8; i++) for (let j = 0; j < 4; j++) { const r = Math.abs(Math.sin(i * 7.7 + j * 31.1) * 9871.3) % 1; if (r < 0.6) { x.fillStyle = r < 0.2 ? '#ffe3b4' : '#ffb867'; x.fillRect(i * 32 + 3, j * 64 + 10, 26, 50); } }
    x.fillStyle = lit ? '#000' : '#e9e4da'; for (let j = 0; j < 4; j++) x.fillRect(0, j * 64, 256, 8);
    for (let i = 0; i < 8; i++) x.fillRect(i * 32, 0, 3, 256);
    const t = new THREE.CanvasTexture(c); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.colorSpace = THREE.SRGBColorSpace; t.anisotropy = 8; t.repeat.set(1 / 24, 1 / 13.6); return t;
  };
  const skin = new THREE.MeshStandardMaterial({ map: tex(0), emissiveMap: tex(1), emissive: 0xffffff, emissiveIntensity: 0, roughness: 0.25, metalness: 0.3 });
  const gold = new THREE.MeshStandardMaterial({ color: 0xd8b36c, roughness: 0.3, metalness: 0.75, emissive: 0xffc070, emissiveIntensity: 0.1 });
  const moon = new THREE.MeshStandardMaterial({ color: 0xffe7b0, emissive: 0xffd98a, emissiveIntensity: 0.15, transparent: true, opacity: 0.35, side: THREE.DoubleSide });
  const seat = new THREE.MeshStandardMaterial({ color: 0xe6e1d6, roughness: 0.8 }), green = new THREE.MeshStandardMaterial({ color: 0x5f8a45, roughness: 0.9 });
  // thân tháp: tấm dày có lỗ tròn
  const s = new THREE.Shape(); s.moveTo(-Wt / 2, 0); s.lineTo(Wt / 2, 0); s.lineTo(Wt / 2, H); s.lineTo(-Wt / 2, H); s.lineTo(-Wt / 2, 0);
  const hole = new THREE.Path(); hole.absarc(0, YH, RH, 0, Math.PI * 2, true); s.holes.push(hole);
  const tg = new THREE.ExtrudeGeometry(s, { depth: Dt, bevelEnabled: false, curveSegments: 48 }); tg.translate(0, 0, -Dt / 2);
  const t = new THREE.Mesh(tg, skin); t.castShadow = t.receiveShadow = true; g.add(t);
  for (const z of [Dt / 2 + 0.6, -Dt / 2 - 0.6]) { const r = new THREE.Mesh(new THREE.TorusGeometry(RH + 0.8, 1.6, 12, 96), gold); r.position.set(0, YH, z); g.add(r); }
  const disc = new THREE.Mesh(new THREE.CircleGeometry(RH, 64), moon); disc.position.set(0, YH, 0); g.add(disc);   // "ánh trăng" trong ô cửa
  const crown = new THREE.Mesh(new THREE.BoxGeometry(Wt + 1, 2, Dt + 1), gold); crown.position.y = H + 1; g.add(crown);
  // khối đế phía sau tháp (xa sông)
  const pg = new THREE.BoxGeometry(150, 22, 80); const pod = new THREE.Mesh(pg, skin); pod.position.set(0, 11, -30); pod.castShadow = pod.receiveShadow = true; g.add(pod);
  { const uv = pg.attributes.uv; for (let f = 0; f < 6; f++) for (let i = 0; i < 4; i++) { const k = f * 4 + i, span = f < 2 ? 80 : 150; uv.setXY(k, uv.getX(k) * span, uv.getY(k) * 22); } }
  const roof = new THREE.Mesh(new THREE.BoxGeometry(146, 1, 76), green); roof.position.set(0, 22.5, -30); g.add(roof);
  // khán đài DIFF giật cấp, mặt quay ra sông
  for (let k = 0; k < 7; k++) { const h = 2 + k * 2.2, b = new THREE.Mesh(new THREE.BoxGeometry(170, h, 6), seat); b.position.set(0, h / 2, 74 - k * 6); b.castShadow = true; g.add(b); }
  const canopy = new THREE.Mesh(new THREE.BoxGeometry(176, 1.2, 30), gold); canopy.position.set(0, 26, 50); canopy.rotation.x = -0.12; g.add(canopy);
  for (const x of [-80, -40, 0, 40, 80]) { const c = new THREE.Mesh(new THREE.CylinderGeometry(0.8, 0.8, 26, 8), gold); c.position.set(x, 13, 38); g.add(c); }
  const setNight = (v) => { skin.emissiveIntensity = v * 0.9; gold.emissiveIntensity = 0.1 + v * 1.2; moon.emissiveIntensity = 0.15 + v * 2.4; moon.opacity = 0.35 + v * 0.5; };
  return { group: g, setNight, height: H + 2 };
}
