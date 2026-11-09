/* Video giới thiệu Sun Saphia – 4 cảnh flycam dựng từ mô hình 3D (chạy bên trong hàm chính của trang mô hình).
   Không chữ, không logo trong khung 3D (chữ ghép sau). XD.frame(shot, t) vẽ khung ở giây t của cảnh shot.
   Hệ tọa độ "world" của mô hình: trục biển Võ Nguyên Giáp – Trường Sa dọc z (Bắc = −z), biển phía +x. */
(function () {
  window.__noRAF = true;
  renderer.setPixelRatio(1); renderer.setSize(innerWidth, innerHeight);
  camera.aspect = innerWidth / innerHeight; camera.fov = 42; camera.far = 30000; camera.updateProjectionMatrix();
  controls.enabled = false; controls.autoRotate = false;
  sgMat.visible = false; if (window.wm) wm.visible = false; if (window.hi) hi.visible = false;

  var L = function (x, y, z) { return world.localToWorld(new THREE.Vector3(x, y, z)); };
  var TWL = new THREE.Vector3(-47, 0, 39);                // vị trí tòa tháp trong hệ world
  function ease(x) { x = Math.max(0, Math.min(1, x)); return x * x * (3 - 2 * x); }
  function easeOut(x) { x = Math.max(0, Math.min(1, x)); return 1 - Math.pow(1 - x, 3); }
  function lerp(a, b, k) { return a + (b - a) * k; }

  /* hiệu ứng hạ tầng (vật liệu phát sáng) */
  var fx = new THREE.Group(); world.add(fx);
  function glow(c, o) { return new THREE.MeshBasicMaterial({ color: c, transparent: true, opacity: o, depthWrite: false, toneMapped: false }); }
  // trục biển: dải sáng vàng mọc ra hai phía từ dự án, rồi nở rộng
  var road = new THREE.Mesh(new THREE.BoxGeometry(1, .8, 1), glow(0xffc04a, .85)); road.position.set(0, 1.6, TWL.z); fx.add(road);
  var roadEdge = []; [-1, 1].forEach(function (s) { var m = new THREE.Mesh(new THREE.BoxGeometry(1.6, 1, 1), glow(0xfff2c0, 1)); m.userData.s = s; m.position.set(0, 2, TWL.z); fx.add(m); roadEdge.push(m); });
  // công viên phía trước: mảng xanh sáng lan dần ra biển
  var park = new THREE.Mesh(new THREE.BoxGeometry(104, .6, 84), glow(0x5dff9a, .55)); park.position.set(64, 1.4, 163); fx.add(park);
  // đường sắt đô thị sân bay – Hội An: tuyến sáng cách dự án ~500 m về phía đất liền, ga gần dự án
  var RX = TWL.x - 500, R0 = -3200, R1 = 3200;
  var rail = new THREE.Mesh(new THREE.BoxGeometry(22, 6, 1), glow(0x46d6ff, .95)); rail.position.set(RX, 16, 0); fx.add(rail);
  var station = new THREE.Mesh(new THREE.CylinderGeometry(40, 40, 6, 40), glow(0x46d6ff, .9)); station.position.set(RX, 17, TWL.z); fx.add(station);
  var ring = new THREE.Mesh(new THREE.RingGeometry(48, 60, 48), glow(0xbff4ff, .9)); ring.rotation.x = -Math.PI / 2; ring.position.set(RX, 21, TWL.z); fx.add(ring);
  var link = new THREE.Mesh(new THREE.BoxGeometry(1, 3, 8), glow(0xbff4ff, .85)); fx.add(link);  // nối ga → dự án (500 m)
  var tram = new THREE.Mesh(new THREE.BoxGeometry(26, 12, 120), glow(0xffffff, 1)); fx.add(tram);
  fx.visible = false;

  function look(pos, tgt) { camera.position.copy(pos); camera.lookAt(tgt); }
  var TOW = function (y) { return L(TWL.x, y, TWL.z); };

  var SHOTS = {
    /* 1. từ trên cao lao xuống, dừng nhìn tòa tháp với biển phía sau */
    dive: function (t, D) {
      setTime(16.9); fx.visible = false;
      var k = easeOut(t / D), h = lerp(2600, 150, k), off = lerp(8, 245, ease((t / D - .35) / .65));
      look(L(TWL.x - off, h, TWL.z + off * .35), TOW(lerp(0, 52, ease((t / D - .3) / .7))));
    },
    /* 2. xoay quanh tòa tháp: nhìn ra biển → xoay về thành phố (Ngũ Hành Sơn, trung tâm) */
    orbit: function (t, D) {
      setTime(lerp(16.9, 17.75, t / D)); fx.visible = false;
      var a = lerp(Math.PI * 1.06, Math.PI * .08, ease(t / D)), r = 245, h = lerp(150, 105, ease(t / D));
      look(L(TWL.x + Math.cos(a) * r, h, TWL.z + Math.sin(a) * r * 1.0), TOW(52));
    },
    /* 3. trục biển mở rộng + công viên phía trước ra biển */
    road: function (t, D) {
      setTime(17.3); fx.visible = true; rail.visible = station.visible = ring.visible = link.visible = tram.visible = false;
      var g = easeOut(t / 3.2), len = lerp(10, 2400, g), w = lerp(28, 46, ease((t - 2.8) / 1.6));
      road.visible = true; road.scale.set(w, 1, len); road.material.opacity = .55 + .25 * Math.sin(t * 4);
      roadEdge.forEach(function (m) { m.visible = t > 2.8; m.scale.z = len; m.position.x = m.userData.s * (w / 2 + 1); });
      var pk = ease((t - 4) / 2); park.visible = pk > 0; park.scale.set(1, 1, Math.max(.01, pk)); park.position.z = 163 - 42 * (1 - pk) ; park.material.opacity = .35 + .25 * pk + .1 * Math.sin(t * 5);
      look(L(lerp(520, 430, t / D), lerp(720, 560, t / D), TWL.z + lerp(420, 300, t / D)), L(10, 0, TWL.z + 40));
    },
    /* 4. đường sắt đô thị sân bay – Hội An (ban đêm), ga cách dự án ~500 m */
    rail: function (t, D) {
      setTime(19.15); fx.visible = true; road.visible = false; roadEdge.forEach(function (m) { m.visible = false; }); park.visible = false;
      var g = ease(t / 3.4), z1 = lerp(R0, R1, g);
      rail.visible = true; rail.scale.z = Math.max(1, z1 - R0); rail.position.z = (R0 + z1) / 2;
      var st = ease((t - 2.2) / 1); station.visible = ring.visible = st > 0; station.scale.set(st, 1, st);
      ring.scale.setScalar(1 + .25 * Math.sin(t * 5)); ring.material.opacity = .5 + .4 * st;
      link.visible = t > 3; link.scale.x = 500 * ease((t - 3) / 1.2); link.position.set(RX + link.scale.x / 2, 15, TWL.z);
      tram.visible = t > 3.4; tram.position.set(RX, 20, lerp(R0, R1, ((t - 3.4) / 6) % 1));
      look(L(lerp(1050, 880, t / D), lerp(1300, 1050, t / D), TWL.z + lerp(700, 560, t / D)), L(TWL.x - 260, 0, TWL.z));
    }
  };

  window.XD = { frame: function (shot, t, D) {
    SHOTS[shot](t, D);
    renderer.autoClear = true; renderer.render(scene, camera);
    return renderer.domElement.toDataURL('image/jpeg', .93);
  } };
})();
