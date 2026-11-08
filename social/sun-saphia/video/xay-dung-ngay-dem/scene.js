/* Cảnh "tiến độ xây dựng ngày đêm" chạy bên trong trang mô hình 4D (sun-saphia-4d.html).
   Không chữ, không logo, không biển hiệu: chỉ có hình. window.XD.frame(t) vẽ khung hình ở giây t. */
(function () {
  window.__noRAF = true;                                   // dừng vòng lặp sẵn có của trang, tự vẽ từng khung
  renderer.setPixelRatio(1); renderer.setSize(innerWidth, innerHeight);
  camera.aspect = innerWidth / innerHeight; camera.fov = 40; camera.updateProjectionMatrix();
  controls.enabled = false; controls.autoRotate = false;
  sgMat.visible = false;                                   // biển hiệu logo + số điện thoại trên nóc
  if (window.wm) wm.visible = false; if (window.hi) hi.visible = false;
  if (window.planMesh) planMesh.visible = false;
  /* cắt tòa tháp theo độ cao: dùng bản sao vật liệu riêng cho tòa tháp, mỗi khung chép lại độ sáng đèn kính theo giờ từ vật liệu gốc */
  renderer.localClippingEnabled = true; var PAIRS = [];
  T.traverse(function (o) { if (!o.isMesh || o.__site) return; var arr = Array.isArray(o.material) ? o.material : [o.material];
    var cl = arr.map(function (m) { var c = m.clone(); c.clippingPlanes = [clipP]; c.clipShadows = true; PAIRS.push([m, c]); return c; });
    o.material = Array.isArray(o.material) ? cl : cl[0]; });
  function syncMats() { PAIRS.forEach(function (p) { var m = p[0], c = p[1]; if (m.emissive) { c.emissive.copy(m.emissive); c.emissiveIntensity = m.emissiveIntensity * 1.8; }
    if (m.color) c.color.copy(m.color); if (m.envMapIntensity != null) c.envMapIntensity = m.envMapIntensity; c.opacity = m.opacity; }); }

  /* kích thước theo mô hình: khối đế PX0..PX1 × PZ0..PZ1 (cao tới WH); tháp hình chữ L = thân [CX,X1]×[Z0,Z1] + cánh Bắc [X0,CX]×[Z0,CZ] */
  var cx = (CX + X1) / 2, cz = 0, sx = X1 - CX, sz = Z1 - Z0;
  var px = PCX, pz = PCZ, psx = PW, psz = PD;
  var bt = { min: { x: CX, z: Z0 }, max: { x: X1, z: Z1 } };
  var site = new THREE.Group(); T.add(site);
  var concrete = new THREE.MeshStandardMaterial({ color: 0x9a968e, roughness: .95 });
  var dark = new THREE.MeshStandardMaterial({ color: 0x5d5a55, roughness: 1 });
  var yellow = new THREE.MeshStandardMaterial({ color: 0xf2b21b, roughness: .6, metalness: .2 });
  /* nền công trường: đất + hố móng */
  var lot = new THREE.Mesh(new THREE.BoxGeometry(psx + 16, .4, psz + 16), new THREE.MeshStandardMaterial({ color: 0x8c7a5f, roughness: 1 }));
  lot.position.set(px, .2, pz); lot.receiveShadow = true; site.add(lot);
  /* sàn bê tông đang thi công + cột chờ ở mép trên */
  var slab = new THREE.Group(); site.add(slab);
  var sPod = new THREE.Mesh(new THREE.BoxGeometry(psx, .45, psz), concrete); sPod.position.set(px, 0, pz);
  var sBody = new THREE.Mesh(new THREE.BoxGeometry(sx, .45, sz), concrete); sBody.position.set(cx, 0, cz);
  var sWing = new THREE.Mesh(new THREE.BoxGeometry(CX - X0, .45, CZ - Z0), concrete); sWing.position.set((X0 + CX) / 2, 0, (Z0 + CZ) / 2);
  [sPod, sBody, sWing].forEach(function (m) { m.castShadow = m.receiveShadow = true; slab.add(m); });
  var cols = new THREE.Group(); site.add(cols);
  for (var i = 0; i <= 6; i++) for (var j = 0; j <= 3; j++) { if (i > 0 && i < 6 && j > 0 && j < 3) continue;
    var c = new THREE.Mesh(new THREE.BoxGeometry(.7, 3.2, .7), dark); c.position.set(bt.min.x + 1 + i * (sx - 2) / 6, 1.6, bt.min.z + 1 + j * (sz - 2) / 3); c.castShadow = true; cols.add(c); }
  /* cần cẩu tháp */
  var crane = new THREE.Group(); site.add(crane);
  var mastH = 1, mast = new THREE.Mesh(new THREE.BoxGeometry(2.2, 1, 2.2), yellow); crane.add(mast);
  var top = new THREE.Group(); crane.add(top);
  var jib = new THREE.Mesh(new THREE.BoxGeometry(56, 1.6, 1.6), yellow); jib.position.x = 18; top.add(jib);
  var cj = new THREE.Mesh(new THREE.BoxGeometry(3.2, 3.2, 3.2), dark); cj.position.set(-12, -.8, 0); top.add(cj);
  var cab = new THREE.Mesh(new THREE.BoxGeometry(2.6, 2.6, 2.6), yellow); cab.position.set(0, -1.6, 2); top.add(cab);
  var apex = new THREE.Mesh(new THREE.ConeGeometry(1.1, 6, 4), yellow); apex.position.y = 3.5; top.add(apex);
  var hook = new THREE.Mesh(new THREE.BoxGeometry(.15, 1, .15), dark); top.add(hook);
  crane.position.set(bt.max.x + 6, 0, cz + sz * .2);
  crane.traverse(function (o) { if (o.isMesh) o.castShadow = true; });
  /* đèn pha công trường (ban đêm) */
  var flood = new THREE.PointLight(0xfff0d0, 0, 140, 1.6); site.add(flood);
  var bulbs = new THREE.Group(); site.add(bulbs);
  var bulbM = new THREE.MeshBasicMaterial({ color: 0xffffff, toneMapped: false });
  [[bt.min.x, bt.min.z], [bt.max.x, bt.min.z], [bt.min.x, bt.max.z], [bt.max.x, bt.max.z]].forEach(function (p) { var s = new THREE.Mesh(new THREE.SphereGeometry(.7, 8, 6), bulbM); s.position.set(p[0], 0, p[1]); bulbs.add(s); });

  var TOPH = TOP;
  function ease(x) { return x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x); }
  /* độ cao theo tầng: mỗi tầng mọc lên trong một nhịp, nghỉ ngắn giữa các tầng */
  function heightAt(p) { if (p <= 0) return 0; if (p >= 1) return TOPH + 2; var f = p * 30, n = Math.floor(f), k = ease((f - n) / .7);
    var a = n === 0 ? 0 : FL[n] + (n === 30 ? 6 : 0), b = n + 1 <= 30 ? FL[n + 1] : TOPH; return a + (b - a) * k; }
  /* giờ trong ngày: ngày → chiều → đêm → sáng, chu kỳ C giây */
  function hourAt(t, C) { var ph = (t % C) / C; // 0..1
    var P = [[0, 9], [.3, 16.5], [.42, 18.4], [.5, 19.6], [.56, 20.6], [.74, 21], [.75, 4.5], [.86, 5.9], [1, 9]];
    for (var i = 1; i < P.length; i++) if (ph <= P[i][0]) { var u = (ph - P[i - 1][0]) / (P[i][0] - P[i - 1][0]); return P[i - 1][1] + (P[i][1] - P[i - 1][1]) * u; } return 9; }

  window.XD = { cx: cx, cz: cz, heightAt: heightAt, hourAt: hourAt,
    frame: function (t, opt) {
      var D = opt.dur, B0 = opt.build0, B1 = opt.build1;
      var p = (t - B0) / (B1 - B0), h = heightAt(p), done = p >= 1;
      var hr = opt.hour != null ? opt.hour : hourAt(t, opt.cycle); setTime(hr); syncMats();
      var night = hr > 18.9 || hr < 5.4;
      clipP.constant = T.localToWorld(new THREE.Vector3(0, h, 0)).y;
      slab.visible = cols.visible = !done && h > .3; var pod = h < 14;
      sPod.visible = pod; sBody.visible = sWing.visible = !pod; slab.position.y = h - .2; cols.position.y = h; cols.visible = slab.visible && !pod;
      lot.visible = !done;
      crane.visible = !done; mastH = Math.max(h + 22, 30); mast.scale.y = mastH; mast.position.y = mastH / 2; top.position.y = mastH + .8;
      top.rotation.y = Math.sin(t * .35) * .9 + .6; hook.position.set(10 + 8 * Math.sin(t * .5), -6 - 4 * Math.sin(t * .8), 0); hook.scale.y = 6;
      flood.position.set(cx, h + 8, cz); flood.intensity = (night && !done) ? 2.2 : 0; bulbs.visible = night && !done; bulbs.position.y = h + 2;
      /* máy quay: nhìn từ phía đất liền ra biển, hạ dần theo tiến độ, cuối cùng lượn chậm */
      var a = opt.az0 + (opt.az1 - opt.az0) * ease(t / D), dist = opt.dist0 + (opt.dist1 - opt.dist0) * ease(t / D);
      var look = opt.look, ey = opt.elev;
      var tw = T.localToWorld(new THREE.Vector3(cx, look, cz));
      camera.position.set(tw.x + Math.cos(a) * dist, ey, tw.z + Math.sin(a) * dist); camera.lookAt(tw);
      renderer.autoClear = true; renderer.render(scene, camera);
      return renderer.domElement.toDataURL('image/jpeg', .93);
    } };
})();
