/* ---------- SUN FOURS TOWER (tòa chính): 4 tòa F1, F2, F3, F5 · 20 tầng · góc Minh Mạng – Nguyễn Phước Lan ----------
   Khối tháp lấy từ mô hình FourS (đường bao mặt bằng tầng CĐT, plans-data.js). Hệ toạ độ riêng của cụm FourS (FW):
   gốc = tâm giao lộ (GPS 16.009588, 108.242570), trục theo đường Minh Mạng (lệch 37,7° so với Bắc). */
var BRG=37.7;
var FC=[__FCX__,__FCZ__];                      // tâm FourS trong hệ world (đổi từ GPS bằng W(lat,lon))
var FW=new THREE.Group(); FW.position.set(FC[0],0,FC[1]); FW.rotation.y=-BRG*Math.PI/180-world.rotation.y; world.add(FW);
__TOWERS__
var T=FW;
(NIGHT_MATS=NIGHT_MATS||[]).push([matGlass,1.5],[matTerra,1.2]);
// sân, lối đi quanh chân 4 tòa
(function(){ var m=new THREE.Mesh(new THREE.PlaneGeometry(250,250),M(0xd6cfbf,{roughness:.9,polygonOffset:true,polygonOffsetFactor:-1,polygonOffsetUnits:-1})); m.rotation.x=-Math.PI/2; m.position.y=.08; m.receiveShadow=true; FW.add(m); })();
