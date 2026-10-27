(function(){
if(!window.THREE){document.getElementById('app').innerHTML='<div class="err">Không tải được thư viện 3D. Vui lòng tải lại trang.</div>';return;}
var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
var app=document.getElementById('app');
var renderer;
try{renderer=new THREE.WebGLRenderer({antialias:true,powerPreference:'high-performance',logarithmicDepthBuffer:true,preserveDrawingBuffer:/[?&]shot/.test(location.search)});}catch(e){app.innerHTML='<div class="err">Trình duyệt không hỗ trợ WebGL nên không hiển thị được mô hình 3D.</div>';return;}
var LOW=innerWidth<600||/iPhone|iPad|Android/i.test(navigator.userAgent);
renderer.setPixelRatio(Math.min(window.devicePixelRatio||1,LOW?1.5:2));
renderer.setSize(innerWidth,innerHeight);
renderer.shadowMap.enabled=true; renderer.shadowMap.type=THREE.PCFSoftShadowMap;
renderer.outputEncoding=THREE.sRGBEncoding; renderer.toneMapping=THREE.ACESFilmicToneMapping; renderer.toneMappingExposure=.74;
app.appendChild(renderer.domElement);

var scene=new THREE.Scene();
scene.fog=new THREE.Fog(0xcfe2f2,1500,26000);
var camera=new THREE.PerspectiveCamera(42,innerWidth/innerHeight,2,60000);
var controls=new THREE.OrbitControls(camera,renderer.domElement);
controls.enableDamping=true; controls.dampingFactor=.08; controls.maxPolarAngle=Math.PI*.485; controls.minDistance=60; controls.maxDistance=3200;
controls.autoRotateSpeed=.6;

function M(c,o){o=o||{};return new THREE.MeshStandardMaterial(Object.assign({color:c,roughness:.85,metalness:0,envMapIntensity:.25},o));}
var seed=11; function srnd(){ seed=(seed*16807)%2147483647; return (seed-1)/2147483646; }
function rnd(a,b){return a+srnd()*(b-a);}

/* ---------- Bầu trời (cũng làm nguồn phản chiếu) ---------- */
var skyU={top:{value:new THREE.Color(0x4f8fd6)},hor:{value:new THREE.Color(0xcfe6f7)},bot:{value:new THREE.Color(0xd8cfb8)},sunDir:{value:new THREE.Vector3(1,.3,0)},sunCol:{value:new THREE.Color(1,.9,.7)}};
var skyMat=new THREE.ShaderMaterial({side:THREE.BackSide,depthWrite:false,uniforms:skyU,
  vertexShader:'varying vec3 vP;void main(){vP=normalize(position);gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.);}',
  fragmentShader:'uniform vec3 top,hor,bot,sunCol;uniform vec3 sunDir;varying vec3 vP;void main(){float h=vP.y;vec3 c=h>0.?mix(hor,top,pow(clamp(h,0.,1.),.55)):mix(hor,bot,clamp(-h*6.,0.,1.));float s=max(dot(normalize(vP),normalize(sunDir)),0.);c+=sunCol*(pow(s,600.)*3.+pow(s,12.)*.35);gl_FragColor=vec4(c,1.);}'});
var sky=new THREE.Mesh(new THREE.SphereGeometry(45000,32,16),skyMat); sky.frustumCulled=false; scene.add(sky);
var pmrem=new THREE.PMREMGenerator(renderer); var envRT=null;
var envCv=document.createElement('canvas'); envCv.width=256; envCv.height=128;
function refreshEnv(){
  var g=envCv.getContext('2d'), gr=g.createLinearGradient(0,0,0,128);
  gr.addColorStop(0,'#'+skyU.top.value.getHexString()); gr.addColorStop(.5,'#'+skyU.hor.value.getHexString()); gr.addColorStop(1,'#'+skyU.bot.value.getHexString());
  g.fillStyle=gr; g.fillRect(0,0,256,128);
  var d=skyU.sunDir.value, u=.5+Math.atan2(d.z,d.x)/(2*Math.PI), v=.5-Math.asin(Math.max(-1,Math.min(1,d.y)))/Math.PI;
  var rg=g.createRadialGradient(u*256,v*128,0,u*256,v*128,40); rg.addColorStop(0,'rgba(255,240,210,.9)'); rg.addColorStop(1,'rgba(255,240,210,0)');
  g.fillStyle=rg; g.fillRect(0,0,256,128);
  var tex=new THREE.CanvasTexture(envCv); tex.mapping=THREE.EquirectangularReflectionMapping; tex.encoding=THREE.sRGBEncoding;
  if(envRT) envRT.dispose(); envRT=pmrem.fromEquirectangular(tex); tex.dispose(); scene.environment=envRT.texture;
}

/* ---------- Ánh sáng ---------- */
var hemi=new THREE.HemisphereLight(0xcfe4ff,0x9a8a68,.55); scene.add(hemi);
var sun=new THREE.DirectionalLight(0xffffff,2.2); sun.castShadow=true; sun.shadow.mapSize.set(LOW?1024:2048,LOW?1024:2048);
var sc=sun.shadow.camera; sc.left=-260; sc.right=260; sc.top=260; sc.bottom=-260; sc.near=50; sc.far=2600; sun.shadow.bias=-0.0005; sun.shadow.normalBias=.6;
scene.add(sun); scene.add(sun.target);

/* ---------- Khung toạ độ ----------
   Cảnh: +x = Đông, +z = Nam, -z = Bắc (đúng hướng thật).
   "world" = khung theo mặt bằng CĐT: +x = bên phải bản vẽ, -z = phía trên bản vẽ.
   Theo la bàn trên mặt bằng tầng của CĐT, phía trên bản vẽ là hướng Đông Bắc → xoay -45°.
   Đường Nguyễn Phước Lan chạy dọc trục x (z=0), đường Minh Mạng dọc trục z (x=0). */
var world=new THREE.Group(); world.rotation.y=-Math.PI/4; scene.add(world);
var SITE_LAT=16.009588, SITE_LON=108.242570;   // vị trí dự án (anh Hiệp cung cấp, Google Maps)
function LL(lat,lon){ return [(lon-SITE_LON)*Math.cos(SITE_LAT*Math.PI/180)*111320, -(lat-SITE_LAT)*110574]; }
// Mặt nước quanh đảo Sunneva Island – vẽ theo ảnh vệ tinh anh Hiệp gửi (hướng Bắc lên trên),
// căn tỷ lệ bằng 2 mốc: cầu Bờ Quan (16.012547, 108.247079) ở điểm ảnh (1420,1112) và Sunneva Island (16.016665, 108.244697) ở (1072,548): ~0,77 m/điểm ảnh
var BQ=LL(16.012547,108.247079);
function PXS(px,py){ return [BQ[0]+(px-1420)*.77, BQ[1]+(py-1112)*.77]; }
var LAKE=[[-450,-250],[450,-250],[650,60],[950,150],[1100,200],[1200,250],[1220,300],[1350,420],[1500,520],[1600,700],[1640,900],[1560,1060],[1420,1112],[1380,1100],[1150,1040],[900,960],[700,880],[520,760],[330,640],[140,620],[-120,720],[-300,800],[-450,700]].map(function(p){ return PXS(p[0],p[1]); });
var ISLAND=[[420,350],[520,330],[700,370],[1000,420],[1150,470],[1350,600],[1460,700],[1480,830],[1420,900],[1300,920],[1100,870],[800,700],[600,620],[470,560],[410,450]].map(function(p){ return PXS(p[0],p[1]); });
// nhánh sông: phía Tây nối sông Hàn qua cầu Trung Lương; phía Nam qua cầu Bờ Quan chảy dọc phía Tây Ngũ Hành Sơn
var CC_W=[[16.0255,108.2245],[16.0200,108.2300],[16.015086,108.235155],[16.0160,108.2385]];
var CC_S=[[16.012547,108.247079],[16.0085,108.2500],[16.0030,108.2510],[15.9950,108.2512],[15.9850,108.2530],[15.9700,108.2570],[15.9400,108.2680]];
function inP(x,z,P){ var c=false; for(var i=0,j=P.length-1;i<P.length;j=i++){ if(((P[i][1]>z)!==(P[j][1]>z))&&(x<(P[j][0]-P[i][0])*(z-P[i][1])/(P[j][1]-P[i][1])+P[i][0])) c=!c; } return c; }
function nearLine(xs,zs,L,m){ var P=L.map(function(q){ return LL(q[0],q[1]); }); for(var i=0;i<P.length-1;i++){ var a=P[i],b=P[i+1],dx=b[0]-a[0],dz=b[1]-a[1],t=Math.max(0,Math.min(1,((xs-a[0])*dx+(zs-a[1])*dz)/(dx*dx+dz*dz))); if(Math.hypot(xs-a[0]-t*dx,zs-a[1]-t*dz)<m) return true; } return false; }
function nearRiver(xs,zs,m){ if(inP(xs,zs,LAKE)&&!inP(xs,zs,ISLAND)) return true; return nearLine(xs,zs,CC_W,m)||nearLine(xs,zs,CC_S,m); }
function flat(w,d,col,x,z,y,rot,grp){var m=new THREE.Mesh(new THREE.PlaneGeometry(w,d),M(col));m.rotation.x=-Math.PI/2;if(rot)m.rotation.z=rot;m.position.set(x,y||0.05,z);m.receiveShadow=true;(grp||world).add(m);return m;}
var ground=new THREE.Mesh(new THREE.PlaneGeometry(40000,40000),M(0xb9b48f)); ground.rotation.x=-Math.PI/2; ground.receiveShadow=true; scene.add(ground);
flat(1700,1700,0xa9b388,0,0,0.02);   // nền khu đô thị (cỏ / đất)

/* ---------- Đường ---------- */
var RW=30;   // lộ giới 2 trục chính (ước lượng): 2 làn xe mỗi chiều + dải phân cách + vỉa hè
var asph=0x5c6066, walk=0xd9d2c3;
function road(len,w,x,z,alongX){ var g=new THREE.Group(); world.add(g);
  flat(alongX?len:w,alongX?w:len,walk,x,z,.07,0,g);
  flat(alongX?len:w-7,alongX?w-7:len,asph,x,z,.09,0,g);
  flat(alongX?len:1.6,alongX?1.6:len,0x7da35a,x,z,.11,0,g);   // dải phân cách trồng cỏ
  return g; }
road(1700,RW,0,0,true); road(1700,RW,0,0,false);
// đường nội khu (ước lượng theo lưới ô phố biệt thự)
var GRID=[-640,-470,-300,-150,150,300,470,640];
GRID.forEach(function(p){ var a=road(1700,13,0,p,true); var b=road(1700,13,p,0,false); });
// vạch qua đường tại giao lộ
(function(){ for(var i=-6;i<=6;i++){ flat(1.2,6,0xffffff,i*2.2,RW/2+4,.13); flat(1.2,6,0xffffff,i*2.2,-RW/2-4,.13); flat(6,1.2,0xffffff,RW/2+4,i*2.2,.13); flat(6,1.2,0xffffff,-RW/2-4,i*2.2,.13); } })();

/* ---------- Vật liệu mặt dựng theo phối cảnh: kính tối, khung trắng dọc, tấm đất nung, dải cây xanh ---------- */
function facadeTex(kind){ var NB=kind==='terra'?3:2, c=document.createElement('canvas'); c.width=256*NB; c.height=256; var g=c.getContext('2d');
  // 256 px = 1 khoang (3,6 m) × 1 tầng (3,35 m); bản 'terra': 2 khoang kính + 1 tấm đất nung (theo phối cảnh)
  g.fillStyle='#2b3138'; g.fillRect(0,0,256*NB,256);
  for(var b=0;b<NB;b++){ var x=b*256;
    if(kind==='terra'&&b===2){ g.fillStyle='#c46d3e'; g.fillRect(x+10,0,236,256); g.fillStyle='#d98452'; g.fillRect(x+10,0,18,256); g.fillStyle='#2e3a44'; g.fillRect(x+150,40,70,170); }
    else { var gr=g.createLinearGradient(0,30,0,230); gr.addColorStop(0,'#5b7489'); gr.addColorStop(1,'#33475a'); g.fillStyle=gr; g.fillRect(x+16,28,224,200);
      g.fillStyle='rgba(255,255,255,.10)'; g.fillRect(x+16,28,224,40);
      g.fillStyle='#1d252d'; g.fillRect(x+126,28,5,200); }
    g.fillStyle='#d9d4c8'; g.fillRect(x+60,228,190,12);   // lan can ban công
  }
  g.fillStyle='#f3efe6'; for(var b=0;b<=NB;b++) g.fillRect(b*256-6,0,12,256);   // khung trắng dọc
  g.fillStyle='#e9e4d8'; g.fillRect(0,240,256*NB,16);   // viền sàn
  var t=new THREE.CanvasTexture(c); t.encoding=THREE.sRGBEncoding; t.wrapS=t.wrapT=THREE.RepeatWrapping; t.repeat.set(1/(3.6*NB),1/3.35); t.anisotropy=8; return t; }
function nightTex(){ var c=document.createElement('canvas'); c.width=512; c.height=1024; var g=c.getContext('2d'); g.fillStyle='#000'; g.fillRect(0,0,512,1024);
  for(var r=0;r<4;r++) for(var b=0;b<2;b++){ if(srnd()<.45){ g.fillStyle=srnd()<.5?'#ffd9a0':'#ffe9c4'; g.fillRect(b*256+16,r*256+28,224,200); } }
  var t=new THREE.CanvasTexture(c); t.encoding=THREE.sRGBEncoding; t.wrapS=t.wrapT=THREE.RepeatWrapping; t.repeat.set(1/7.2,1/13.4); return t; }
var NT=nightTex();
var matGlass=M(0xffffff,{map:facadeTex('glass'),roughness:.38,metalness:.15,envMapIntensity:.7,emissive:0xffffff,emissiveMap:NT,emissiveIntensity:0});
var matTerra=M(0xffffff,{map:facadeTex('terra'),roughness:.55,metalness:.05,envMapIntensity:.5,emissive:0xffffff,emissiveMap:NT,emissiveIntensity:0});
var matWhite=M(0xf1ede4,{roughness:.6}), matSlab=M(0xe7e2d6,{roughness:.7}), matGreen=M(0x3f7a3a,{roughness:.9}), matPlanter=M(0x2f5f3a,{roughness:.8});
var matShop=M(0xf5e6c8,{roughness:.3,metalness:.1,envMapIntensity:.8,emissive:0xffc77a,emissiveIntensity:.15});
var matRoof=M(0xd7d2c6,{roughness:.9}), matLawn=M(0x6f9e4c,{roughness:1});
var GLOW=[matGlass,matTerra];

/* ---------- Hình khối tháp ---------- */
// Chiều cao tầng (ước lượng theo quy mô CĐT công bố: 2 hầm + 20 tầng nổi + tum, cao ~77,95 m)
var FL=[0,0,5.4,9.9]; for(var f=4;f<=21;f++) FL[f]=9.9+(f-3)*3.35;   // FL[1]=0 … FL[20]=66,85; FL[21]=mái 70,2
var ROOF=FL[21], TOP=77.95;
function FN(f){ return f===4?'3A':String(f); }   // tầng 3A thay cho tầng 4 (theo bản vẽ CĐT)

// Đường bao mặt bằng tầng 8–19 Tòa F2 đo trên bản vẽ CĐT (tỷ lệ ~14,4 px/m, đối chiếu diện tích từng căn):
// X: trái→phải bản vẽ (mét), Y: trên→dưới bản vẽ; khối hình chữ U, sân trống quay lên phía trên bản vẽ (Đông Bắc)
var F2PTS=[[0,0],[19.4,0],[19.4,15.5],[43.2,15.5],[43.2,0],[62.6,0],[62.6,41.7],[43.2,41.7],[43.2,39.4],[19.4,39.4],[19.4,41.7],[0,41.7]];
var F2W=62.6, F2D=41.7;
// offset đa giác vuông góc (g>0: nới ra ngoài)
function offsetPts(P,g){ var n=P.length, out=[], area=0; for(var i=0;i<n;i++){ var a=P[i], b=P[(i+1)%n]; area+=a[0]*b[1]-b[0]*a[1]; } var s=area>0?1:-1;
  for(var i=0;i<n;i++){ var p=P[(i-1+n)%n], c=P[i], q=P[(i+1)%n];
    function nrm(a,b){ var dx=b[0]-a[0], dy=b[1]-a[1], L=Math.hypot(dx,dy)||1; return [s*dy/L,-s*dx/L]; }
    var n1=nrm(p,c), n2=nrm(c,q); out.push([c[0]+g*(n1[0]+n2[0]),c[1]+g*(n1[1]+n2[1])]); } return out; }
function convex(P,i){ var n=P.length, p=P[(i-1+n)%n], c=P[i], q=P[(i+1)%n], area=0; for(var k=0;k<n;k++){ var a=P[k], b=P[(k+1)%n]; area+=a[0]*b[1]-b[0]*a[1]; }
  var cr=(c[0]-p[0])*(q[1]-c[1])-(c[1]-p[1])*(q[0]-c[0]); return area>0?cr>0:cr<0; }
// Shape trong mặt phẳng XY (X,Y bản vẽ; Y bản vẽ đổi dấu để khi xoay -90° quanh X thì Y bản vẽ → +z)
function shapeOf(P,r,cx,cy){ var s=new THREE.Shape(), n=P.length;
  for(var i=0;i<n;i++){ var p=P[(i-1+n)%n], c=P[i], q=P[(i+1)%n], rr=convex(P,i)?r:Math.min(r,.3);
    var l1=Math.hypot(c[0]-p[0],c[1]-p[1]), l2=Math.hypot(q[0]-c[0],q[1]-c[1]); rr=Math.min(rr,l1/2,l2/2);
    var a=[c[0]+(p[0]-c[0])/l1*rr, c[1]+(p[1]-c[1])/l1*rr], b=[c[0]+(q[0]-c[0])/l2*rr, c[1]+(q[1]-c[1])/l2*rr];
    var A=[a[0]-cx,-(a[1]-cy)], B=[b[0]-cx,-(b[1]-cy)], C=[c[0]-cx,-(c[1]-cy)];
    if(i===0) s.moveTo(A[0],A[1]); else s.lineTo(A[0],A[1]); s.quadraticCurveTo(C[0],C[1],B[0],B[1]); }
  s.closePath(); return s; }
function extrude(shape,y0,h,mat,grp,cast){ var g=new THREE.ExtrudeGeometry(shape,{depth:h,bevelEnabled:false,curveSegments:6}); g.rotateX(-Math.PI/2); g.translate(0,y0,0);
  var m=new THREE.Mesh(g,mat); m.castShadow=cast!==false; m.receiveShadow=true; grp.add(m); return m; }
function ring(P,r,cx,cy,g1,g2){ var s=shapeOf(offsetPts(P,g1),r+g1,cx,cy); s.holes.push(shapeOf(offsetPts(P,g2),Math.max(.3,r+g2),cx,cy)); return s; }
// điểm dọc chu vi (cho khung trắng đỉnh tháp)
function along(P,g,step){ var Q=offsetPts(P,g), out=[]; for(var i=0;i<Q.length;i++){ var a=Q[i], b=Q[(i+1)%Q.length], L=Math.hypot(b[0]-a[0],b[1]-a[1]), n=Math.max(1,Math.round(L/step)); for(var k=0;k<n;k++){ var t=k/n; out.push([a[0]+(b[0]-a[0])*t,a[1]+(b[1]-a[1])*t]); } } return out; }

var TOWERS={};
function makeTower(id,P,W,D,x,z,rotY,opt){
  opt=opt||{}; var grp=new THREE.Group(); grp.position.set(x,0,z); grp.rotation.y=rotY||0; world.add(grp);
  var cx=W/2, cy=D/2, r=2.5;
  // đế 2 tầng: phủ cả sân trong (theo mặt bằng tầng 1 của CĐT), nhô thêm ~2,3 m về phía đường chính
  // đế tầng 1–2 rộng hơn thân tháp ~3 m mỗi phía (theo mặt bằng tầng 1, 2 của CĐT); mái đế tầng 3 = sân vườn, phủ cả sân giữa
  var podP=[[-3,-3-(opt.podTop||0)],[W+3,-3-(opt.podTop||0)],[W+3,D+3+(opt.podBot||0)],[-3,D+3+(opt.podBot||0)]];
  extrude(shapeOf(podP,3,cx,cy),0,FL[3]-.6,matShop,grp);
  extrude(shapeOf(offsetPts(podP,.6),3.6,cx,cy),FL[2]-.35,.45,matSlab,grp);     // sàn tầng 2 nhô
  extrude(shapeOf(offsetPts(podP,.8),3.8,cx,cy),FL[3]-.6,.6,matSlab,grp);       // mái đế
  extrude(shapeOf(offsetPts(podP,-.2),3,cx,cy),FL[3],.25,matLawn,grp,false);   // vườn mái đế
  // thân tháp tầng 3 → mái: mặt kính + tấm đất nung ở các đầu hồi
  var body=extrude(shapeOf(P,r,cx,cy),FL[3],ROOF-FL[3],[matSlab,matTerra],grp);
  // viền sàn trắng từng tầng
  var slabG=new THREE.ExtrudeGeometry(ring(P,r,cx,cy,.45,-.05),{depth:.32,bevelEnabled:false,curveSegments:6}); slabG.rotateX(-Math.PI/2);
  var sl=new THREE.InstancedMesh(slabG,matSlab,18), dm=new THREE.Object3D(); for(var f=4;f<=21;f++){ dm.position.set(0,FL[f]-.2,0); dm.updateMatrix(); sl.setMatrixAt(f-4,dm.matrix); } sl.castShadow=true; grp.add(sl);
  // sân vườn riêng các căn tầng 3A, 5, 6, 7: vòng sân rộng ~3 m quanh tháp (theo mặt bằng tầng CĐT, ghi "Sân/TT BC" từng căn)
  var GF=[4,5,6,7], gG=new THREE.ExtrudeGeometry(ring(P,r,cx,cy,3,0),{depth:.45,bevelEnabled:false,curveSegments:8}); gG.rotateX(-Math.PI/2);
  var gS=new THREE.InstancedMesh(gG,matSlab,GF.length), gT=new THREE.InstancedMesh(gG,matLawn,GF.length);
  var pG=new THREE.ExtrudeGeometry(ring(P,r,cx,cy,3,2.8),{depth:1.05,bevelEnabled:false,curveSegments:8}); pG.rotateX(-Math.PI/2);
  var pp=new THREE.InstancedMesh(pG,matWhite,GF.length+1);
  GF.forEach(function(f,k){ dm.position.set(0,FL[f]-.45,0); dm.scale.set(1,1,1); dm.updateMatrix(); gS.setMatrixAt(k,dm.matrix);
    dm.position.set(0,FL[f]-.02,0); dm.scale.set(1,.25,1); dm.updateMatrix(); gT.setMatrixAt(k,dm.matrix);
    dm.position.set(0,FL[f],0); dm.scale.set(1,1,1); dm.updateMatrix(); pp.setMatrixAt(k,dm.matrix); });
  dm.position.set(0,0,0); dm.scale.set(1,1,1);
  gS.castShadow=gS.receiveShadow=gT.receiveShadow=pp.castShadow=true; grp.add(gS); grp.add(gT);
  // lan can mép mái đế (tầng 3)
  var podRing=new THREE.Shape(); (function(){ var a=shapeOf(podP,3,cx,cy), b=shapeOf(offsetPts(podP,-.25),2.75,cx,cy); a.holes.push(b); var g=new THREE.ExtrudeGeometry(a,{depth:1.05,bevelEnabled:false,curveSegments:8}); g.rotateX(-Math.PI/2); g.translate(0,FL[3],0); var m=new THREE.Mesh(g,matWhite); m.castShadow=true; grp.add(m); })();
  pp.count=GF.length; grp.add(pp);
  // cây bụi trên sân vườn
  var sp=along(P,1.5,3.2), shG=new THREE.IcosahedronGeometry(.75,0), sh=new THREE.InstancedMesh(shG,matPlanter,sp.length*GF.length), q2=0;
  GF.forEach(function(f){ sp.forEach(function(p){ if(srnd()<.35) return; var s2=rnd(.7,1.25); dm.position.set(p[0]-cx,FL[f]+.4+s2*.5,p[1]-cy); dm.scale.set(s2,s2*1.2,s2); dm.updateMatrix(); sh.setMatrixAt(q2++,dm.matrix); }); });
  sh.count=q2; dm.scale.set(1,1,1); sh.castShadow=true; grp.add(sh);
  // khung trắng dọc chạy suốt chiều cao (cột trang trí theo phối cảnh)
  var pts=along(P,.5,7.2), fg=new THREE.BoxGeometry(.55,TOP-FL[3],.55), fr=new THREE.InstancedMesh(fg,matWhite,pts.length);
  pts.forEach(function(p,i){ dm.position.set(p[0]-cx,FL[3]+(TOP-FL[3])/2,p[1]-cy); dm.updateMatrix(); fr.setMatrixAt(i,dm.matrix); }); fr.castShadow=true; grp.add(fr);
  // đỉnh tháp: khung trắng hở 2 tầng + vườn mái + tum kỹ thuật
  extrude(shapeOf(offsetPts(P,.5),r+.5,cx,cy),ROOF-.2,.5,matSlab,grp);
  extrude(ring(P,r,cx,cy,.75,-.1),TOP-.9,.9,matWhite,grp);
  extrude(ring(P,r,cx,cy,.6,.05),ROOF+.3,1.1,matTerra,grp);    // lan can mái
  extrude(shapeOf(offsetPts(P,-1.2),Math.max(.5,r-1.2),cx,cy),ROOF+.3,.35,matLawn,grp,false);
  (opt.cores||[[W*.3,D*.6],[W*.7,D*.6]]).forEach(function(c){ var m=new THREE.Mesh(new THREE.BoxGeometry(9,4.2,7),matRoof); m.position.set(c[0]-cx,ROOF+2.4,c[1]-cy); m.castShadow=true; grp.add(m); });
  // cây trên mái
  var tg=new THREE.IcosahedronGeometry(1,0), tm=new THREE.InstancedMesh(tg,matGreen,26), q=0;
  for(var i=0;i<26;i++){ var px=rnd(2,W-2), py=rnd(2,D-2); if(!inPoly(px,py,P)) continue; var s=rnd(.9,1.6); dm.position.set(px-cx,ROOF+.8+s*.6,py-cy); dm.scale.set(s,s*1.1,s); dm.updateMatrix(); tm.setMatrixAt(q++,dm.matrix); }
  tm.count=q; dm.scale.set(1,1,1); tm.castShadow=true; grp.add(tm);
  // biển tên trên đỉnh
  var lb={grp:grp,P:P,W:W,D:D,cx:cx,cy:cy,id:id}; TOWERS[id]=lb; return lb;
}
function inPoly(x,y,P){ var c=false; for(var i=0,j=P.length-1;i<P.length;j=i++){ if(((P[i][1]>y)!==(P[j][1]>y))&&(x<(P[j][0]-P[i][0])*(y-P[i][1])/(P[j][1]-P[i][1])+P[i][0])) c=!c; } return c; }

// Bố trí 4 tòa quanh giao lộ Nguyễn Phước Lan – Minh Mạng (theo sơ đồ 4 tòa của CĐT):
// F2 góc trên-phải, F1 trên-trái, F5 dưới-trái, F3 dưới-phải. Mặt dưới bản vẽ F2 nhìn ra Nguyễn Phước Lan, mặt trái nhìn ra Minh Mạng.
// Vị trí đo trên phối cảnh nhìn từ trên cao của CĐT (~4,47 px/m, đối chiếu bề ngang F2 = 62,6 m): mép tháp cách tim giao lộ ~20 m.
var F2=makeTower('F2',F2PTS,F2W,F2D, 20+F2W/2, -(20.6+F2D/2), 0, {podBot:2.3, cores:[[25,30],[38,30]]});
// Tòa F1: hình chữ H theo mặt bằng tầng 8–19 của CĐT (~19,4 px/m, đối chiếu căn 1PN+ 53,81 m²): 2 cánh 19,4 m + thân giữa 11,2 m
var F1P=[[0,0],[19.4,0],[19.4,7.7],[30.7,7.7],[30.7,0],[50.1,0],[50.1,40.9],[30.7,40.9],[30.7,27.1],[19.4,27.1],[19.4,40.9],[0,40.9]];
var F1=makeTower('F1',F1P,50.1,40.9, -(19+25.05), -(20.6+20.45), 0, {podBot:1.5, cores:[[9,20],[41,20]]});
// Tòa F5: đường bao mặt bằng tầng 8–15 của CĐT (~19,6 px/m, đối chiếu căn 1PN+ 53,81 m²): 62 × 52 m.
// Trên bản vẽ F5 mũi Bắc chỉ lên-phải (ngược F1/F2) → xoay 90° cho khớp phối cảnh trên cao: X = y bản vẽ, Y = 62 − x bản vẽ.
var F5plan=[[31.9,0],[62,0],[62,52],[0,52],[0,20.9],[19.5,20.9],[19.5,30.6],[41.1,30.6],[41.1,8.9],[31.9,8.9]];
var F5P=F5plan.map(function(p){ return [p[1],62-p[0]]; });
var F5=makeTower('F5',F5P,52,62, -(19+26), 17+31, 0, {podTop:1.5, cores:[[14,10],[41,40]]});
// Tòa F3: hình chữ Γ theo phối cảnh trên cao (chưa có mặt bằng chi tiết – minh họa)
var F3P=[[0,0],[55,0],[55,24],[20,24],[20,63],[0,63]];
var F3=makeTower('F3',F3P,55,63, 18+27.5, 19+31.5, 0, {podTop:1.5, cores:[[30,12],[10,45]]});
// sân vườn – hồ bơi trong khối F3 (theo sơ đồ 4 tòa)
(function(){ var m=new THREE.Mesh(new THREE.BoxGeometry(18,.4,8),M(0x36b3c9,{roughness:.2,metalness:.1,envMapIntensity:1})); m.position.set(10,FL[3]+.35,14); F3.grp.add(m); })();

// tháp đang bán
var T=F2.grp;

/* ---------- Cây xanh: dọc đường, công viên, vườn biệt thự ---------- */
var trees=[], palms=[];
function addTree(x,z,s){ trees.push([x,z,s||rnd(.8,1.4)]); }
for(var p=-820;p<=820;p+=14){ if(Math.abs(p)<RW/2+4) continue; [RW/2-1.5,-RW/2+1.5].forEach(function(o){ palms.push([p,o]); palms.push([o,p]); }); }
GRID.forEach(function(g){ for(var p=-820;p<=820;p+=18){ if(Math.abs(p-g)<10) continue; addTree(p,g+5.5,rnd(.6,.9)); addTree(g+5.5,p,rnd(.6,.9)); } });
// công viên (ước lượng theo sơ đồ CĐT: mảng xanh phía Đông và Đông Bắc 4 tòa)
var PARKS=[[100,-210,150,140],[240,40,120,200],[-230,250,140,120]];
PARKS.forEach(function(k){ flat(k[2],k[3],0x7fae58,k[0],k[1],.12); for(var i=0;i<Math.round(k[2]*k[3]/420);i++) addTree(k[0]+rnd(-k[2]/2+4,k[2]/2-4),k[1]+rnd(-k[3]/2+4,k[3]/2-4)); });
// hồ nhỏ trong công viên phía Đông
flat(60,34,0x3f9fb5,250,70,.15);

/* ---------- Khu biệt thự / nhà phố thấp tầng xung quanh (Sun Riverpolis, ước lượng) ---------- */
var houses=[];
function freeAt(x,z){ if(Math.abs(x)<RW/2+3||Math.abs(z)<RW/2+3) return false; if(Math.abs(x)<100&&Math.abs(z)<100) return false;
  for(var i=0;i<GRID.length;i++){ if(Math.abs(x-GRID[i])<11||Math.abs(z-GRID[i])<11) return false; }
  for(var k=0;k<PARKS.length;k++){ var P=PARKS[k]; if(Math.abs(x-P[0])<P[2]/2+6&&Math.abs(z-P[1])<P[3]/2+6) return false; }
  if(nearRiver((x-z)/Math.SQRT2,(x+z)/Math.SQRT2,70)) return false;
  return Math.abs(x)<800&&Math.abs(z)<800; }
for(var hx=-790;hx<=790;hx+=13) for(var hz=-790;hz<=790;hz+=22){ var xx=hx+((Math.floor(hz/22)%2)*4), zz=hz; if(!freeAt(xx,zz)||srnd()<.12) continue; houses.push([xx,zz,rnd(9,13)]); if(srnd()<.25) addTree(xx+rnd(-5,5),zz+9); }
(function(){ var n=houses.length, dm=new THREE.Object3D();
  var bodyM=new THREE.InstancedMesh(new THREE.BoxGeometry(9,1,15),M(0xf1e9da,{roughness:.8}),n);
  var rg=new THREE.ConeGeometry(1,1,4); rg.rotateY(Math.PI/4); var roofM=new THREE.InstancedMesh(rg,M(0xc0623a,{roughness:.7}),n);
  houses.forEach(function(h,i){ dm.position.set(h[0],h[2]/2,h[1]); dm.scale.set(1,h[2],1); dm.rotation.set(0,0,0); dm.updateMatrix(); bodyM.setMatrixAt(i,dm.matrix);
    dm.position.set(h[0],h[2]+1.6,h[1]); dm.scale.set(7.2,3.2,11); dm.updateMatrix(); roofM.setMatrixAt(i,dm.matrix); });
  bodyM.castShadow=roofM.castShadow=true; bodyM.receiveShadow=true; world.add(bodyM); world.add(roofM); })();
(function(){ var dm=new THREE.Object3D(), n=trees.length;
  var crown=new THREE.InstancedMesh(new THREE.IcosahedronGeometry(3.2,0),M(0x4d8a3c,{roughness:.95}),n), trunk=new THREE.InstancedMesh(new THREE.CylinderGeometry(.25,.35,4,5),M(0x6b5139),n);
  trees.forEach(function(t,i){ var s=t[2]; dm.position.set(t[0],4*s+2.4*s,t[1]); dm.scale.set(s,s*1.15,s); dm.updateMatrix(); crown.setMatrixAt(i,dm.matrix); dm.position.set(t[0],2*s,t[1]); dm.scale.set(s,s,s); dm.updateMatrix(); trunk.setMatrixAt(i,dm.matrix); });
  crown.castShadow=true; world.add(crown); world.add(trunk);
  var pn=palms.length, pt=new THREE.InstancedMesh(new THREE.CylinderGeometry(.18,.3,9,5),M(0x8a7457),pn), pc=new THREE.InstancedMesh(new THREE.ConeGeometry(3,1.6,7),M(0x3d7d36),pn);
  palms.forEach(function(p,i){ dm.position.set(p[0],4.5,p[1]); dm.scale.set(1,1,1); dm.updateMatrix(); pt.setMatrixAt(i,dm.matrix); dm.position.set(p[0],9.4,p[1]); dm.rotation.set(Math.PI,0,0); dm.updateMatrix(); pc.setMatrixAt(i,dm.matrix); dm.rotation.set(0,0,0); });
  pc.castShadow=true; world.add(pt); world.add(pc); })();

/* ---------- Cảnh xa theo toạ độ thật (vĩ độ, kinh độ) – +x Đông, +z Nam ----------
   Toạ độ dự án, biển Sơn Thủy, biển Mỹ Khê, Ngũ Hành Sơn, FPT, Hội An, Cù Lao Chàm, điểm bắn pháo hoa DIFF, sân bay, cầu Rồng, Sơn Trà: anh Hiệp lấy trên Google Maps.
   Kiểm tra theo hướng view CĐT ghi trên mặt bằng: mặt Đông Nam thấy Ngũ Hành Sơn, biển; mặt Bắc thấy sông Hàn (pháo hoa DIFF). */
// vật ở rất xa: giữ đúng hướng, kéo lại gần (k) để nằm trong tầm nhìn, thu nhỏ tương ứng
function LLnear(lat,lon,maxD){ var p=LL(lat,lon), d=Math.hypot(p[0],p[1]), k=d>maxD?maxD/d:1; return [p[0]*k,p[1]*k,k,d]; }
function sFlat(w,d,col,x,z,y,ry){ var m=new THREE.Mesh(new THREE.PlaneGeometry(w,d),M(col)); m.rotation.x=-Math.PI/2; if(ry) m.rotation.z=ry; m.position.set(x,y||.04,z); m.receiveShadow=true; scene.add(m); return m; }
var waterMat=M(0x3a8fa6,{roughness:.3,metalness:.15,envMapIntensity:.9});
function riverLL(pts,w,y){ var P=pts.map(function(q){ return LL(q[0],q[1]); }), L=[], R=[];
  for(var i=0;i<P.length;i++){ var a=P[Math.max(0,i-1)], b=P[Math.min(P.length-1,i+1)], dx=b[0]-a[0], dz=b[1]-a[1], l=Math.hypot(dx,dz)||1, nx=-dz/l*w/2, nz=dx/l*w/2; L.push([P[i][0]+nx,P[i][1]+nz]); R.push([P[i][0]-nx,P[i][1]-nz]); }
  var sh=new THREE.Shape(); L.forEach(function(p,i){ if(i) sh.lineTo(p[0],-p[1]); else sh.moveTo(p[0],-p[1]); }); for(var i=R.length-1;i>=0;i--) sh.lineTo(R[i][0],-R[i][1]);
  var g=new THREE.ShapeGeometry(sh); g.rotateX(-Math.PI/2); var m=new THREE.Mesh(g,waterMat); m.position.y=y||.2; m.receiveShadow=true; scene.add(m); return P; }
// sông Cổ Cò: từ sông Hàn chảy xuống phía Nam, giữa dự án và Ngũ Hành Sơn
var CC=riverLL(CC_S,80); riverLL(CC_W,120);
(function(){ var sh=new THREE.Shape(); LAKE.forEach(function(p,i){ if(i) sh.lineTo(p[0],-p[1]); else sh.moveTo(p[0],-p[1]); });
  var h=new THREE.Path(); ISLAND.forEach(function(p,i){ if(i) h.lineTo(p[0],-p[1]); else h.moveTo(p[0],-p[1]); }); sh.holes.push(h);
  var g=new THREE.ShapeGeometry(sh); g.rotateX(-Math.PI/2); var m=new THREE.Mesh(g,waterMat); m.position.y=.22; m.receiveShadow=true; scene.add(m); })();
// sông Hàn: qua cầu Tiên Sơn, cầu Trần Thị Lý, cầu Rồng, ra cửa biển
var HAN=riverLL([[15.995,108.212],[16.012,108.219],[16.024314,108.223033],[16.032,108.229],[16.03947,108.233302],[16.050,108.2315],[16.06104,108.227019],[16.075,108.2255],[16.090,108.222],[16.105,108.218]],300,.18);   // qua điểm bắn pháo hoa DIFF và cầu Rồng
// biển: đường bờ từ Sơn Trà xuống Mỹ Khê, Non Nước (ước lượng)
var COAST=[[16.120,108.300],[16.095,108.262],[16.075,108.2440],[16.048543,108.250789],[16.017091,108.263561],[16.000,108.2708],[15.970,108.2830],[15.940,108.2960],[15.900,108.3140],[15.860,108.3360]];   // qua 2 điểm biển Mỹ Khê, Sơn Thủy
var seaMat=M(0x1b8fa8,{roughness:.32,metalness:.2,envMapIntensity:.9});
(function(){ var P=COAST.map(function(q){ return LL(q[0],q[1]); }), sh=new THREE.Shape();
  P.forEach(function(p,i){ if(i) sh.lineTo(p[0],-p[1]); else sh.moveTo(p[0],-p[1]); }); sh.lineTo(40000,-P[P.length-1][1]); sh.lineTo(40000,-P[0][1]);
  var g=new THREE.ShapeGeometry(sh); g.rotateX(-Math.PI/2); var m=new THREE.Mesh(g,seaMat); m.position.y=.6; m.receiveShadow=true; scene.add(m);
  // bãi cát dọc bờ
  var B=new THREE.Shape(); P.forEach(function(p,i){ if(i) B.lineTo(p[0]-70,-p[1]); else B.moveTo(p[0]-70,-p[1]); }); for(var i=P.length-1;i>=0;i--) B.lineTo(P[i][0]+5,-P[i][1]);
  var gb=new THREE.ShapeGeometry(B); gb.rotateX(-Math.PI/2); var mb=new THREE.Mesh(gb,M(0xf0e2bd)); mb.position.y=.3; scene.add(mb); window.__coast=P; })();
var sea={position:{y:0}}, seaGeo=null, seaPos={array:[]}, seaBase=[];
function hill(x,z,r,h,c,sx){ var m=new THREE.Mesh(new THREE.SphereGeometry(1,24,14),M(c,{roughness:1})); m.scale.set(r*(sx||1),h,r); m.position.set(x,0,z); m.castShadow=true; m.receiveShadow=true; scene.add(m); return m; }
// Ngũ Hành Sơn: 5 ngọn núi đá vôi (Thủy Sơn cao nhất ~106 m)
var NHS=LL(16.004724,108.255554);
[[0,0,150,106],[.0025,-.0035,70,60],[-.003,.003,70,55],[-.0045,-.0025,60,48],[.004,.0025,55,42]].forEach(function(k){ var p=LL(16.004724+k[0],108.255554+k[1]); hill(p[0],p[1],k[2],k[3],0x6f8a5a); });
// bán đảo Sơn Trà (~13 km, đỉnh ~690 m)
var ST=LL(16.118584,108.268184); hill(ST[0],ST[1],3200,690,0x6f8676,1.5); hill(ST[0]+2600,ST[1]+900,1600,420,0x6f8676);
// Cù Lao Chàm (~28 km Đông Đông Nam): đặt gần lại theo đúng hướng, thu nhỏ tương ứng
var CLC=LLnear(15.960865,108.499926,11000); hill(CLC[0],CLC[1],2300*CLC[2]*1.2,520*CLC[2]*1.4,0x7d93a0,1.6); hill(CLC[0]+900*CLC[2],CLC[1]-500*CLC[2],900*CLC[2],260*CLC[2],0x7d93a0);
// núi phía Tây: Bà Nà – Hải Vân
hill(-14000,-2000,6000,1300,0x8a98a6,1.3); hill(-9000,-14000,6000,1100,0x8a98a6,1.5);
// trung tâm TP (Hải Châu) và Sơn Trà – An Hải: khối cao tầng xa
(function(){ var dm=new THREE.Object3D(), n=360, im=new THREE.InstancedMesh(new THREE.BoxGeometry(1,1,1),M(0xd9dde2,{roughness:.6,envMapIntensity:.4}),n), q=0;
  for(var i=0;i<n;i++){ var west=srnd()<.62, lat=west?rnd(16.035,16.085):rnd(16.03,16.09), lon=west?rnd(108.205,108.225):rnd(108.234,108.246); var p=LL(lat,lon), h=srnd()<.15?rnd(60,170):rnd(14,45);
    dm.position.set(p[0],h/2,p[1]); dm.scale.set(rnd(20,42),h,rnd(20,42)); dm.updateMatrix(); im.setMatrixAt(q++,dm.matrix); }
  im.count=q; scene.add(im); })();
// khu dân cư thấp tầng giữa sông Cổ Cò và biển (Mỹ An, Khuê Mỹ, Hòa Hải)
(function(){ var dm=new THREE.Object3D(), n=520, im=new THREE.InstancedMesh(new THREE.BoxGeometry(1,1,1),M(0xe9e1d2,{roughness:.8}),n), q=0;
  for(var i=0;i<n;i++){ var lat=rnd(15.965,16.05), lon=rnd(108.256,108.27); var p=LL(lat,lon); if(Math.hypot(p[0]-NHS[0],p[1]-NHS[1])<600) continue;
    var cz=null; for(var k=0;k<COAST.length-1;k++){ if(lat<=COAST[k][0]&&lat>=COAST[k+1][0]){ var t=(lat-COAST[k+1][0])/(COAST[k][0]-COAST[k+1][0]); cz=COAST[k+1][1]+(COAST[k][1]-COAST[k+1][1])*t; } } if(cz&&lon>cz-.0015) continue;
    var h=srnd()<.07?rnd(25,70):rnd(8,16); dm.position.set(p[0],h/2,p[1]); dm.scale.set(rnd(10,24),h,rnd(10,24)); dm.updateMatrix(); im.setMatrixAt(q++,dm.matrix); }
  im.count=q; im.castShadow=true; scene.add(im); })();
// sân bay quốc tế Đà Nẵng: 2 đường băng hướng ~Bắc – Nam
(function(){ var p=LL(16.054092,108.200513), g=new THREE.Group(); g.position.set(p[0],0,p[1]); g.rotation.y=-.05; scene.add(g);
  [-100,100].forEach(function(o){ var m=new THREE.Mesh(new THREE.PlaneGeometry(55,3050),M(0x55595e)); m.rotation.x=-Math.PI/2; m.position.set(o,.25,0); g.add(m); }); })();
// sân vận động Chi Lăng (vòng khán đài)
var SVD=LL(15.999020,108.223335); (function(){ var m=new THREE.Mesh(new THREE.TorusGeometry(95,18,6,40),M(0xeceae4)); m.rotation.x=-Math.PI/2; m.scale.set(1,.7,.9); m.position.set(SVD[0],10,SVD[1]); scene.add(m); sFlat(120,80,0x5fa24a,SVD[0],SVD[1],.5); })();
// AEON Mall Hòa Xuân (khối thương mại lớn, thấp tầng)
var AEON=LL(15.995380,108.216964); (function(){ var m=new THREE.Mesh(new THREE.BoxGeometry(240,22,150),M(0xf1efe9,{roughness:.6})); m.position.set(AEON[0],11,AEON[1]); m.castShadow=true; scene.add(m); })();
// Làng đại học Đà Nẵng, FPT City, sân golf (ước lượng)
var LDH=LL(15.977213,108.248975), FPT=LL(15.982294,108.260892), GOLF=LL(15.9867,108.2637), DRG=LL(16.061040,108.227019), DT=LL(16.0700,108.2190), MK=LL(16.048543,108.250789), STB=LL(16.017091,108.263561), DIFF=LL(16.039470,108.233302), HA=LLnear(15.877520,108.332702,9000);   // sân golf, downtown: ước lượng
sFlat(650,900,0x8db86a,GOLF[0],GOLF[1],.35); sFlat(500,600,0x8db86a,GOLF[0]+350,GOLF[1]+700,.35);   // Legend Danang Golf Resort (đo trên ảnh bản đồ anh Hiệp gửi)
(function(){ var dm=new THREE.Object3D(), im=new THREE.InstancedMesh(new THREE.BoxGeometry(1,1,1),M(0xe6e2d8,{roughness:.7}),90), q=0;
  [[LDH,40],[FPT,50]].forEach(function(c){ for(var i=0;i<c[1];i++){ var h=rnd(10,32); dm.position.set(c[0][0]+rnd(-450,450),h/2,c[0][1]+rnd(-350,350)); dm.scale.set(rnd(20,60),h,rnd(16,36)); dm.updateMatrix(); im.setMatrixAt(q++,dm.matrix); } });
  im.count=q; im.castShadow=true; scene.add(im); })();
// MM Mega Market, cầu Hòa Xuân, cầu Trung Lương (toạ độ anh Hiệp)
var MEGA=LL(16.024962,108.220191), CHX=LL(16.024314,108.223033), CTL=LL(16.015086,108.235155), CBQ=LL(16.012547,108.247079), SNV=LL(16.016665,108.244697);
(function(){ var m=new THREE.Mesh(new THREE.BoxGeometry(170,16,120),M(0xeef0f2,{roughness:.6})); m.position.set(MEGA[0],8,MEGA[1]); m.castShadow=true; scene.add(m); })();
function bridgeAt(p,river,len,w){ var best=1e18, dir=[1,0]; for(var i=0;i<river.length-1;i++){ var a=river[i], b=river[i+1], d=Math.hypot(p[0]-(a[0]+b[0])/2,p[1]-(a[1]+b[1])/2); if(d<best){ best=d; var dx=b[0]-a[0], dz=b[1]-a[1], l=Math.hypot(dx,dz)||1; dir=[dx/l,dz/l]; } }
  var m=new THREE.Mesh(new THREE.BoxGeometry(len,1.6,w),M(0xd9d5cc,{roughness:.7})); m.position.set(p[0],4,p[1]); m.rotation.y=-Math.atan2(-dir[0],dir[1]); m.castShadow=true; scene.add(m); }
bridgeAt(CHX,HAN,420,22); bridgeAt(CTL,CC,130,18); bridgeAt(CBQ,CC,120,18);
// Sun Saphia Residence (toạ độ anh Hiệp): tháp 30 tầng ~114 m
var SAP=LL(16.021190,108.257780); (function(){ var m=new THREE.Mesh(new THREE.BoxGeometry(50,114,40),M(0xdfe9ee,{roughness:.35,metalness:.1,envMapIntensity:.7})); m.position.set(SAP[0],57,SAP[1]); m.castShadow=true; scene.add(m); })();
var NNB=LL(16.0018,108.2624);   // bãi biển Non Nước (đo trên ảnh bản đồ)
// công viên Đầm Sen (toạ độ anh Hiệp): mặt cỏ, hồ, cây
var DS=LL(16.002240,108.250477); (function(){ sFlat(360,300,0x7fae58,DS[0],DS[1],.4); sFlat(150,90,0x3f9fb5,DS[0]+20,DS[1]+10,.45);
  var dm=new THREE.Object3D(), im=new THREE.InstancedMesh(new THREE.IcosahedronGeometry(3.2,0),M(0x4d8a3c,{roughness:.95}),90);
  for(var i=0;i<90;i++){ var x=rnd(-170,170), z=rnd(-140,140); if(Math.abs(x-20)<85&&Math.abs(z-10)<55){ i--; continue; } dm.position.set(DS[0]+x,6,DS[1]+z); dm.scale.setScalar(rnd(.8,1.4)); dm.updateMatrix(); im.setMatrixAt(i,dm.matrix); }
  im.castShadow=true; scene.add(im); })();
// cầu Rồng
(function(){ var m=new THREE.Mesh(new THREE.BoxGeometry(37,8,666),M(0xd8b14a,{roughness:.5,metalness:.3})); m.position.set(DRG[0],8,DRG[1]); m.rotation.y=Math.PI/2; scene.add(m); })();

/* ---------- Xe trên 2 trục đường ---------- */
var cars=[], carMesh, dmC=new THREE.Object3D(), cc=new THREE.Color();
(function(){ var n=LOW?34:60; carMesh=new THREE.InstancedMesh(new THREE.BoxGeometry(2,1.5,4.6),M(0xffffff,{roughness:.35,metalness:.4,envMapIntensity:.8}),n);
  var cols=[0xf2f2f2,0xd9d9d9,0x2b2f36,0x9aa3ad,0xb23a2e,0x2f5c8a];
  for(var i=0;i<n;i++){ var rd=i%2, lane=srnd()<.5?-1:1; cars.push({road:rd,lane:lane,s:rnd(-820,820),v:rnd(9,15)*lane}); carMesh.setColorAt(i,cc.set(cols[i%cols.length])); }
  carMesh.castShadow=true; world.add(carMesh); })();
function updateCars(dt){ cars.forEach(function(c,i){ c.s+=c.v*dt; if(c.s>830)c.s=-830; if(c.s<-830)c.s=830;
  if(c.road===0){ dmC.position.set(c.s,.85,c.lane>0?4.2:-4.2); dmC.rotation.set(0,Math.PI/2,0); } else { dmC.position.set(c.lane>0?-4.2:4.2,.85,c.s); dmC.rotation.set(0,0,0); }
  dmC.updateMatrix(); carMesh.setMatrixAt(i,dmC.matrix); }); carMesh.instanceMatrix.needsUpdate=true; }
updateCars(0);

/* ---------- Nhãn ---------- */
var labelsEl=document.getElementById('labels'), LBL=[];
function label(text,cls,obj,pos){var e=document.createElement('div');e.className='lb '+(cls||'');e.textContent=text;labelsEl.appendChild(e);LBL.push({e:e,obj:obj,p:new THREE.Vector3(pos[0],pos[1],pos[2]),cls:cls});return e;}
var mainLbl=label('TÒA F2 · đang mở bán','main',T,[0,TOP+16,0]);
label('Tòa F1','',F1.grp,[0,TOP+10,0]); label('Tòa F5','',F5.grp,[0,TOP+10,0]); label('Tòa F3','',F3.grp,[0,TOP+10,0]);
label('Nguyễn Phước Lan','road',world,[-260,2,0]); label('Nguyễn Phước Lan','road',world,[300,2,0]);
label('Minh Mạng','road',world,[0,2,-300]); label('Minh Mạng','road',world,[0,2,280]);
label('Công viên (ước lượng)','',world,[100,6,-210]);
(function(){ function L(t,p,h,cls){ label(t,cls||'',scene,[p[0],h||12,p[1]]); }
  var cc=CC[2]; L('Sông Cổ Cò',[cc[0],cc[1]],8); L('Sunneva Island',SNV,10);
  L('Ngũ Hành Sơn',NHS,130,'far');
  L('Biển Mỹ Khê',MK,8); L('Biển Sơn Thủy',STB,8); L('Biển Đông',[STB[0]+3500,STB[1]],8,'far'); L('Hội An (~'+Math.round(HA[3]/1000)+' km)',HA,60,'far');
  L('Bán đảo Sơn Trà',ST,720,'far');
  L('Cù Lao Chàm (~'+Math.round(CLC[3]/1000)+' km)',CLC,300,'far');
  L('Trung tâm Đà Nẵng (Downtown)',DT,190,'far'); L('Cầu Rồng',DRG,40,'far'); L('Điểm bắn pháo hoa DIFF',DIFF,40,'far');
  L('Sân bay quốc tế Đà Nẵng',LL(16.054092,108.200513),30,'far');
  L('Sân vận động Chi Lăng',SVD,30); L('MM Mega Market',MEGA,25); L('Cầu Hòa Xuân',CHX,12); L('Cầu Trung Lương',CTL,12); L('Cầu Bờ Quan',CBQ,12); L('AEON Mall Hòa Xuân',AEON,30);
  L('Làng Đại học Đà Nẵng',LDH,40); L('FPT City',FPT,40); L('Sân golf Legend Danang',GOLF,20,'far'); L('Sun Saphia Residence',SAP,124); L('Bãi biển Non Nước',NNB,8); L('Công viên Đầm Sen',DS,14); })();

/* ---------- Thời gian trong ngày (chiều thứ 4) ---------- */
var hourEl=document.getElementById('hour'), hourOut=document.getElementById('hourOut');
var C=function(h){return new THREE.Color(h);};
var towerWorld=new THREE.Vector3(); T.updateWorldMatrix(true,false); T.getWorldPosition(towerWorld);
var envTimer=null;
function lerpC(a,b,t){return a.clone().lerp(b,Math.max(0,Math.min(1,t)));}
function setTime(h){
  var k=(h-5.6)/12.6, el=Math.sin(Math.PI*Math.max(-.08,Math.min(1.08,k)))*1.12, az=Math.PI*k;
  var dir=new THREE.Vector3(Math.cos(az)*Math.cos(el),Math.sin(el),.42*Math.sin(az)*Math.cos(el)).normalize();   // mọc từ biển (Đông), lặn phía núi (Tây), lệch Nam
  var up=Math.max(0,Math.sin(el)), low=1-Math.min(1,up*3.2), night=Math.max(0,Math.min(1,(-Math.sin(el))*8+(h>18.6?(h-18.6)*1.2:0)+(h<5.6?(5.6-h)*1.5:0)));
  sun.position.copy(towerWorld).addScaledVector(dir,1300); sun.target.position.copy(towerWorld);
  sun.color.copy(lerpC(C(0xffffff).lerp(C(0xfff1d6),.5),C(0xff8a3d),low));
  sun.intensity=(up>0?.2+1.7*Math.pow(up,.6):0)*(1-night);
  hemi.intensity=.12+.32*(1-night)*(.4+.6*up);
  var top=lerpC(C(0x3f82cf),C(0x41639a),low), hor=lerpC(C(0xcde5f6),C(0xffb27c),low);
  top=lerpC(top,C(0x070f22),night); hor=lerpC(hor,C(0x1c2a4a),night);
  skyU.top.value.copy(top); skyU.hor.value.copy(hor); skyU.bot.value.copy(lerpC(C(0xd8cfb8),C(0x141c2c),night));
  skyU.sunDir.value.copy(dir); skyU.sunCol.value.copy(lerpC(C(0xfff3d8),C(0xff9a4a),low)).multiplyScalar(1-night);
  scene.fog.color.copy(hor);
  seaMat.color.copy(lerpC(lerpC(C(0x1b8fa8),C(0x3a5d84),low),C(0x0c1a30),night));
  GLOW.forEach(function(m){ m.emissiveIntensity=night*.9; }); matShop.emissiveIntensity=.15+night*.9;
  renderer.toneMappingExposure=.74-.14*night;
  var hh=Math.floor(h), mm=Math.round((h-hh)*60/5)*5; if(mm===60){hh++;mm=0;}
  hourOut.textContent=(hh<10?'0':'')+hh+':'+(mm<10?'0':'')+mm;
  clearTimeout(envTimer); envTimer=setTimeout(refreshEnv,120);
}

/* ---------- Tầng đang chọn, các chế độ xem ---------- */
var floorEl=document.getElementById('floor'), floorOut=document.getElementById('floorOut');
var hiMat=new THREE.MeshStandardMaterial({color:0xff6a2b,emissive:0xff6a2b,emissiveIntensity:.55,polygonOffset:true,polygonOffsetFactor:-2,polygonOffsetUnits:-2});
var hiG=new THREE.ExtrudeGeometry(ring(F2PTS,2.5,F2.cx,F2.cy,.7,.3),{depth:3.1,bevelEnabled:false,curveSegments:6}); hiG.rotateX(-Math.PI/2);
var hi=new THREE.Mesh(hiG,hiMat); T.add(hi);
var mode='overview', saved=null, yaw=0, pitch=-.04, curF=12, unitEye=null;
function setFloor(f){ curF=f; hi.position.y=FL[f]; floorOut.textContent='Tầng '+FN(f); mainLbl.textContent='TÒA F2 · tầng '+FN(f)+' (~'+Math.round(FL[f]+1.6)+' m)'; if(mode==='view') placeViewCam(); if(mode==='close') flyClose(); }
// điểm đứng: tia từ tâm khối giữa F2 theo hướng nhìn, cắt đường bao mặt bằng → đứng sát kính phía trong
var vtmp=new THREE.Vector3();
function eyeOnTower(f,dirScene){
  var inv=new THREE.Quaternion(); T.getWorldQuaternion(inv); inv.invert();
  var d=dirScene.clone().setY(0).normalize().applyQuaternion(inv);   // hướng trong khung tháp (x: phải bản vẽ, z: xuống bản vẽ)
  var o=[F2.cx,27.5], best=1e9;   // tâm khối giữa (toạ độ bản vẽ)
  for(var i=0;i<F2PTS.length;i++){ var a=F2PTS[i], b=F2PTS[(i+1)%F2PTS.length], ex=b[0]-a[0], ey=b[1]-a[1], den=d.x*ey-d.z*ex; if(Math.abs(den)<1e-9) continue;
    var t=((a[0]-o[0])*ey-(a[1]-o[1])*ex)/den, u=((a[0]-o[0])*d.z-(a[1]-o[1])*d.x)/den; if(t>0&&u>=0&&u<=1&&t<best) best=t; }
  if(best>1e8) best=10; best+=1.5;   // đứng ngay mép ban công, ngoài hàng khung trắng – không bị cột che
  return T.localToWorld(new THREE.Vector3(o[0]+d.x*best-F2.cx,FL[f]+1.6,o[1]+d.z*best-F2.cy));
}
function placeViewCam(){
  var f=+floorEl.value, d=new THREE.Vector3(Math.cos(yaw)*Math.cos(pitch),Math.sin(pitch),Math.sin(yaw)*Math.cos(pitch));
  var p=unitEye||eyeOnTower(f,d); camera.position.copy(p); camera.lookAt(p.clone().add(d));
}
var bClose=document.getElementById('mClose'), fly=null, DEF=null,
  bOver=document.getElementById('mOverview'), bView=document.getElementById('mView'), bSpin=document.getElementById('mSpin'), hint=document.getElementById('viewhint');
function setMode(m){
  if(m!=='view') unitEye=null;
  if(m===mode&&m!=='spin') return;
  if(mode==='view'&&m!=='view'&&saved){camera.position.copy(saved.p);controls.target.copy(saved.t);}
  if(m==='view'){ saved={p:camera.position.clone(),t:controls.target.clone()}; controls.enabled=false; controls.autoRotate=false; yaw=0; pitch=-.04; camera.fov=60; camera.updateProjectionMatrix(); hi.visible=false; placeViewCam(); hint.hidden=false; setTimeout(function(){hint.hidden=true;},3500); }
  else { controls.enabled=true; camera.fov=42; camera.updateProjectionMatrix(); hi.visible=true; hint.hidden=true; controls.autoRotate=(m==='spin')&&!reduce; }
  if(m==='overview'&&DEF&&(mode==='close'||mode==='view'||mode==='top')) flyTo(DEF.p,DEF.t);
  if(m==='close') flyClose();
  mode=m; bClose.setAttribute('aria-pressed',m==='close'); bOver.setAttribute('aria-pressed',m==='overview'); bView.setAttribute('aria-pressed',m==='view'); bSpin.setAttribute('aria-pressed',m==='spin');
  document.getElementById('mTop').setAttribute('aria-pressed',m==='top');
  if(m!=='top') setFloor(+floorEl.value);
}
function flyTo(p,t){ fly={p0:camera.position.clone(),t0:controls.target.clone(),p1:p.clone(),t1:t.clone(),k:0}; }
function flyClose(){ var f=+floorEl.value, m=innerWidth<600;
  flyTo(T.localToWorld(new THREE.Vector3(m?-95:-70,FL[f]+(m?30:18),m?120:92)),T.localToWorld(new THREE.Vector3(0,FL[f]-2,6))); }
function flyTop(){ var m=innerWidth<600; if(mode==='view') setMode('overview'); mode='top'; hi.visible=false; mainLbl.textContent='ĐỈNH THÁP F2 · khung trắng · vườn mái';
  ['mOverview','mClose','mView','mSpin'].forEach(function(id){ document.getElementById(id).setAttribute('aria-pressed','false'); }); document.getElementById('mTop').setAttribute('aria-pressed','true');
  controls.autoRotate=false; flyTo(T.localToWorld(new THREE.Vector3(m?-80:-58,TOP+(m?85:55),m?95:72)),T.localToWorld(new THREE.Vector3(0,ROOF-6,0))); }
bOver.onclick=function(){setMode('overview');}; bClose.onclick=function(){ if(mode==='close') flyClose(); else setMode('close'); };
bView.onclick=function(){setMode('view');}; bSpin.onclick=function(){setMode(mode==='spin'?'overview':'spin');};
document.getElementById('mTop').onclick=flyTop;
var drag=null;
renderer.domElement.addEventListener('pointerdown',function(e){ if(mode!=='view') return; drag={x:e.clientX,y:e.clientY,yaw:yaw,pitch:pitch}; try{renderer.domElement.setPointerCapture(e.pointerId);}catch(_){ } });
renderer.domElement.addEventListener('pointermove',function(e){ if(!drag) return; yaw=drag.yaw-(e.clientX-drag.x)*.004; pitch=Math.max(-.6,Math.min(.35,drag.pitch+(e.clientY-drag.y)*.003)); placeViewCam(); });
window.addEventListener('pointerup',function(){drag=null;});
hourEl.oninput=function(){setTime(+hourEl.value);};
floorEl.oninput=function(){setFloor(+floorEl.value);};
var playing=false, playBtn=document.getElementById('play');
playBtn.onclick=function(){playing=!playing; playBtn.textContent=playing?'❚❚':'▶'; playBtn.setAttribute('aria-label',playing?'Dừng':'Chạy thời gian');};

/* ---------- Góc nhìn ban đầu: từ phía Nam giao lộ, giống phối cảnh CĐT ---------- */
controls.target.copy(world.localToWorld(new THREE.Vector3(10,28,-10)));
camera.position.copy(world.localToWorld(new THREE.Vector3(-120,125,330)));
if(innerWidth<600){ controls.target.copy(world.localToWorld(new THREE.Vector3(20,40,-20))); camera.position.copy(world.localToWorld(new THREE.Vector3(-230,230,600))); }
controls.update(); DEF={p:camera.position.clone(),t:controls.target.clone()};
var hQ=/[?&]h=([\d.]+)/.exec(location.search); if(hQ) hourEl.value=hQ[1]; var fQ=/[?&]f=(\d+)/.exec(location.search); if(fQ) floorEl.value=fQ[1];
setFloor(+floorEl.value); setTime(+hourEl.value); refreshEnv();
var camQ=/cam=([-\d.]+),([-\d.]+),([-\d.]+)/.exec(location.search); if(camQ){ camera.position.copy(world.localToWorld(new THREE.Vector3(+camQ[1],+camQ[2],+camQ[3]))); var tg=/tgt=([-\d.]+),([-\d.]+),([-\d.]+)/.exec(location.search); if(tg) controls.target.copy(world.localToWorld(new THREE.Vector3(+tg[1],+tg[2],+tg[3]))); controls.maxDistance=20000; controls.update(); }

/* ---------- Chữ chìm: vẽ vào ảnh WebGL (chụp màn hình vẫn có) ---------- */
function drawLogo(g,x,y,sz){ var r=sz*.16; g.save(); g.fillStyle='#0b2a3d'; g.beginPath(); g.moveTo(x+r,y); g.arcTo(x+sz,y,x+sz,y+sz,r); g.arcTo(x+sz,y+sz,x,y+sz,r); g.arcTo(x,y+sz,x,y,r); g.arcTo(x,y,x+sz,y,r); g.fill();
  g.strokeStyle='#e8a15f'; g.lineWidth=sz*.022; var m=sz*.06, r2=r*.75; g.beginPath(); g.moveTo(x+m+r2,y+m); g.arcTo(x+sz-m,y+m,x+sz-m,y+sz-m,r2); g.arcTo(x+sz-m,y+sz-m,x+m,y+sz-m,r2); g.arcTo(x+m,y+sz-m,x+m,y+m,r2); g.arcTo(x+m,y+m,x+sz-m,y+m,r2); g.stroke();
  g.fillStyle='#e8a15f'; g.font='bold '+Math.round(sz*.36)+'px Georgia,"Times New Roman",serif'; g.textAlign='center'; g.textBaseline='middle'; g.fillText('FS',x+sz/2,y+sz*.46); g.restore(); }
var WEB='sun-fours-tower.com';
var wmC=document.createElement('canvas'); wmC.width=1024; wmC.height=256; (function(g){
  g.shadowColor='rgba(0,0,0,.45)'; g.shadowBlur=10; drawLogo(g,20,28,200);
  g.fillStyle='#ffffff'; g.textBaseline='alphabetic'; g.font='800 64px "Be Vietnam Pro",Arial,sans-serif'; g.fillText('0904 567 009',236,112);
  g.font='600 38px "Be Vietnam Pro",Arial,sans-serif'; g.fillText('Hoàng Hiệp · Sun FourS Tower',238,166); g.fillText(WEB,238,214); })(wmC.getContext('2d'));
var hud=new THREE.Scene(), hudCam=new THREE.OrthographicCamera(0,1,1,0,-1,1);
var wmTex=new THREE.CanvasTexture(wmC); wmTex.encoding=THREE.sRGBEncoding;
var wm=new THREE.Mesh(new THREE.PlaneGeometry(1,1),new THREE.MeshBasicMaterial({map:wmTex,transparent:true,opacity:.26,depthTest:false,depthWrite:false,toneMapped:false})); hud.add(wm);
var consoleEl=document.querySelector('.console');
function placeWM(){ var W=innerWidth,H=innerHeight, w=Math.min(W*.72,480), h=w/4, cb=consoleEl?consoleEl.getBoundingClientRect().height:140; hudCam.right=W; hudCam.top=H; hudCam.updateProjectionMatrix(); wm.scale.set(w,h,1); wm.position.set(W/2,cb+(H-cb)*.42,0); }
placeWM(); window.addEventListener('resize',placeWM); setTimeout(placeWM,800);
if(/[?&]crm/.test(location.search)) wm.visible=false;

/* ---------- Vòng lặp ---------- */
var needle=document.getElementById('needle'), clock=new THREE.Clock(), v=new THREE.Vector3(), fwd=new THREE.Vector3();
function onResize(){camera.aspect=innerWidth/innerHeight;camera.updateProjectionMatrix();renderer.setSize(innerWidth,innerHeight);}
window.addEventListener('resize',onResize);
var hidden=false; document.addEventListener('visibilitychange',function(){ hidden=document.hidden; });
function loop(){
  requestAnimationFrame(loop);
  if(hidden||document.getElementById('uOv')) return;
  var dt=Math.min(.1,clock.getDelta()), t=clock.elapsedTime;
  if(!reduce) updateCars(dt);
  if(playing){ var hv=+hourEl.value+0.02; if(hv>20) hv=5; hourEl.value=hv; setTime(hv); }
  if(false){ var a=seaPos.array; for(var i=0;i<a.length;i+=3){ var bx=seaBase[i], bz=seaBase[i+2]; a[i+1]=.3*Math.sin(bx*.045+t*1.1)+.2*Math.sin(bz*.06+t*1.6+bx*.01); } seaPos.needsUpdate=true; }
  if(fly){ fly.k=Math.min(1,fly.k+Math.max(dt,.03)/1.2); var e=fly.k<.5?2*fly.k*fly.k:1-Math.pow(-2*fly.k+2,2)/2; camera.position.lerpVectors(fly.p0,fly.p1,e); controls.target.lerpVectors(fly.t0,fly.t1,e); if(fly.k>=1) fly=null; }
  if(mode!=='view') controls.update();
  camera.getWorldDirection(fwd); needle.style.transform='rotate('+(Math.atan2(fwd.x,-fwd.z)*-180/Math.PI)+'deg)';
  renderer.render(scene,camera);
  renderer.autoClear=false; renderer.render(hud,hudCam); renderer.autoClear=true;
  var W=innerWidth,H=innerHeight, placed=[];
  for(var j=0;j<LBL.length;j++){ var L=LBL[j]; v.copy(L.p); if(L.obj!==scene) L.obj.localToWorld(v); v.project(camera);
    var vis=v.z<1&&v.x>-1.1&&v.x<1.1&&v.y>-1.1&&v.y<1.1 && !(mode==='view'&&L.cls==='main');
    if(vis){ var px=(v.x+1)/2*W, py=(1-v.y)/2*H, w=L.w||(L.w=L.e.offsetWidth||L.e.textContent.length*7), h=L.h||(L.h=L.e.offsetHeight||22), r=[px-w/2-4,py-h-3,px+w/2+4,py+3];
      for(var k=0;vis&&k<placed.length;k++){ var q=placed[k]; if(r[0]<q[2]&&r[2]>q[0]&&r[1]<q[3]&&r[3]>q[1]){ vis=false; break; } }
      if(vis){ placed.push(r); L.e.style.left=px+'px'; L.e.style.top=py+'px'; } }
    L.e.style.display=vis?'block':'none'; }
}
if(/[?&]view=([-\d.]+)/.test(location.search)){ setMode('view'); yaw=+/[?&]view=([-\d.]+)/.exec(location.search)[1]; placeViewCam(); }
if(/[?&]top/.test(location.search)) setTimeout(flyTop,200);
if(/[?&]close/.test(location.search)) setMode('close');
window.__fs4d={camera:camera,controls:controls,setMode:setMode,flyTop:flyTop,T:T,world:world};
loop();
})();
