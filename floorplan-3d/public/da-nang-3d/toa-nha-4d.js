// Toà tháp Sun Saphia Residence dựng 3D – tách từ trang 4D (projects/sun-saphia/4d/sun-saphia-4d.html).
// Toạ độ cục bộ: x hướng ra biển, z dọc đường Trường Sa về phía Nam, y lên trên (mét); gốc = tâm tháp như trong 4D.
// Khối đế theo mặt bằng tầng 2 CĐT (~55,6 × 51 m), tháp chữ L 30 tầng, mái ≈ 113,5 m.
export function buildTower(THREE) {
function M(c,o){o=o||{};return new THREE.MeshStandardMaterial(Object.assign({color:c,roughness:.85,metalness:0,envMapIntensity:.25},o));}
var seed=7; function srnd(){ seed=(seed*16807)%2147483647; return (seed-1)/2147483646; }
function rnd(a,b){return a+srnd()*(b-a);}
function mergeGeos(list){ var pos=[],nor=[]; list.forEach(function(g){ g=g.index?g.toNonIndexed():g; g.computeVertexNormals(); pos.push.apply(pos,g.attributes.position.array); nor.push.apply(nor,g.attributes.normal.array); });
  var out=new THREE.BufferGeometry(); out.setAttribute('position',new THREE.Float32BufferAttribute(pos,3)); out.setAttribute('normal',new THREE.Float32BufferAttribute(nor,3)); return out; }
function frond(len,wid,droop){ var seg=8, p=[], idx=[], g=new THREE.BufferGeometry();
  for(var i=0;i<=seg;i++){ var t=i/seg, x=len*t, y=len*.28*Math.sin(Math.PI*t*.8)-droop*t*t, w=wid*Math.sin(Math.PI*Math.min(1,t*1.05))*.5+.05; p.push(x,y,-w, x,y-.15,0, x,y,w); }
  for(var i=0;i<seg;i++){ var a=i*3; idx.push(a,a+3,a+1, a+1,a+3,a+4, a+1,a+4,a+2, a+2,a+4,a+5); }
  g.setAttribute('position',new THREE.Float32BufferAttribute(p,3)); g.setIndex(idx); return g; }
var crownParts=[]; for(var i=0;i<10;i++){ var fg=frond(5.6,1.5,2.6+(i%2)*.8); fg.rotateZ(.25-(i%3)*.12); fg.rotateY(i/10*Math.PI*2+(i%2)*.2); crownParts.push(fg); }
var crownGeo=mergeGeos(crownParts);
var trunkGeo=new THREE.CylinderGeometry(.22,.38,1,6); trunkGeo.translate(0,.5,0);
var leafMat=new THREE.MeshStandardMaterial({color:0x4f8a3a,roughness:.8,side:THREE.DoubleSide,envMapIntensity:.25});
var trunkMat=M(0x8b7356);
var dm=new THREE.Object3D();
var T=new THREE.Group();
var FL=[]; var y=0; for(var f=1;f<=30;f++){FL[f]=y; y+= f===1?7:f===2?6:(f===30?6:3.5);} var TOP=y;
var glass=M(0x5f86a6,{roughness:.06,metalness:.75,envMapIntensity:1.15});
var glassTop=M(0x7aa0bd,{roughness:.05,metalness:.7,envMapIntensity:1.2});
var white=M(0xf4f2ec,{roughness:.45,metalness:.05,envMapIntensity:.4});
var bronze=M(0xa8724a,{roughness:.42,metalness:.45,envMapIntensity:.7});
var beige=M(0xdcc8a6,{roughness:.6,metalness:.05,envMapIntensity:.4});
var stone=M(0xe6dccb,{roughness:.7});
var dark=M(0x2a3540,{roughness:.6});
function rrect(w,d,r){var s=new THREE.Shape(),x=-w/2,z=-d/2;s.moveTo(x+r,z);s.lineTo(x+w-r,z);s.quadraticCurveTo(x+w,z,x+w,z+r);s.lineTo(x+w,z+d-r);s.quadraticCurveTo(x+w,z+d,x+w-r,z+d);s.lineTo(x+r,z+d);s.quadraticCurveTo(x,z+d,x,z+d-r);s.lineTo(x,z+r);s.quadraticCurveTo(x,z,x+r,z);return s;}
function slab(grp,shape,yy,depth,mat){var g=new THREE.ExtrudeGeometry(shape,{depth:depth,bevelEnabled:false,curveSegments:4});g.rotateX(-Math.PI/2);var m=new THREE.Mesh(g,mat);m.position.y=yy;m.castShadow=true;m.receiveShadow=true;grp.add(m);return m;}
function boxP(grp,w,h,d,x,yb,z,mat){var m=new THREE.Mesh(new THREE.BoxGeometry(w,h,d),mat);m.position.set(x,yb+h/2,z);m.castShadow=true;m.receiveShadow=true;grp.add(m);return m;}
function fins(grp,list,h,yb,mat,sx,sz){ var im=new THREE.InstancedMesh(new THREE.BoxGeometry(sx||.45,1,sz||sx||.45),mat,list.length); list.forEach(function(p,i){dm.rotation.set(0,0,0);dm.position.set(p[0],yb+h/2,p[1]);dm.scale.set(1,h,1);dm.updateMatrix();im.setMatrixAt(i,dm.matrix);}); im.castShadow=true; grp.add(im); return im; }
function shrubsLocal(grp,x,yy,z){ var m=new THREE.Mesh(new THREE.IcosahedronGeometry(rnd(.8,1.4),0),M(0x467d38)); m.position.set(x,yy+.6,z); m.castShadow=true; grp.add(m); }

var A=new THREE.Group(); T.add(A);
var AW=21, AD=50;                          // tháp: 21 m (Đông–Tây) × 50 m dọc Trường Sa, mặt dài nhìn ra biển
var TX=6;                                  // tháp lệch về phía Trường Sa
/* Theo phối cảnh chính thức: khối tháp thẳng, ban công trắng bo góc chạy quanh mỗi tầng, dải đất nung (terracotta)
   chạy dọc giữa mặt hướng biển và một phần các mặt còn lại, 2 tầng đỉnh khung đất nung + kính, đế 2 tầng cột trắng,
   kính sáng ấm, góc bo tròn, mái đế là vườn cây + bể bơi phía sau. */
glass.color.set(0x3c474c); glass.metalness=.35; glass.roughness=.22; glass.envMapIntensity=.8; glassTop.color.set(0x37434a); glassTop.metalness=.4;
var terra=M(0xA8441A,{roughness:.75,metalness:0,envMapIntensity:.35});
var warm=M(0xF1C27D,{roughness:.25,metalness:.15,envMapIntensity:.6,emissive:0xffb060,emissiveIntensity:.35});
var lawn=M(0x6ea85a,{roughness:.95});
// kết cấu đất nung có ô cửa kính theo từng tầng
var tc=document.createElement('canvas'); tc.width=64; tc.height=64; (function(g){ g.fillStyle='#c2511f'; g.fillRect(0,0,64,64); g.fillStyle='#3a454b'; g.fillRect(18,14,28,34); g.fillStyle='rgba(255,255,255,.2)'; g.fillRect(18,14,28,3); g.fillStyle='#e7e2da'; g.fillRect(0,58,64,6); })(tc.getContext('2d'));
function terraMat(rx,ry){ var t=new THREE.CanvasTexture(tc); t.colorSpace=THREE.SRGBColorSpace; t.wrapS=t.wrapT=THREE.RepeatWrapping; t.repeat.set(rx,ry); t.anisotropy=Math.min(8,8); return new THREE.MeshStandardMaterial({map:t,roughness:.75,metalness:0,envMapIntensity:.35}); }
var NF=26;                                         // số tầng điển hình tầng 3–28
/* Theo MẶT BẰNG TẦNG ĐIỂN HÌNH 3A–28 do CĐT công bố (u: Bắc→Nam dọc Trường Sa, v: từ mặt biển vào trong, mét):
   thân dài ~55,5 m hướng biển; cánh phía Bắc chạy vào trong dọc Nguyễn Đức Thuận (~19,9 m × 39,45 m);
   khối 2 căn 2PN (18, 19) nhô ra phía biển ~8,6 m (đo lại trên bản vẽ 2.5D CĐT 26/10); các góc căn 2PN và đầu hồi căn 20 bo tròn như bản vẽ. */
var X1=TX+AW/2, Z0=-27.2, Z1=27.2;
function UV(u,v){ return [X1-v, Z0+u]; }
var X0=X1-39.45, CX=X1-19.9, CZ=Z0+19.9;      // X0: mặt Tây cánh Bắc; CX: mặt Tây thân; CZ: mặt Nam cánh Bắc
var ZM=CZ, SL=0, XS=CX;
var XA=X0, XB=X1, ZA=Z0, ZB=Z1, XW=X0, ZW=(Z0+CZ)/2, WL=0, WD=0, NX=X1, NZ=Z1;
// --- Đế 2 tầng: cột trắng, kính sáng ấm, góc bo tròn ---
var PX0=X0-2, PX1=X1+11, PZ0=Z0-2, PZ1=Z1+2, PW=PX1-PX0, PD=PZ1-PZ0, PCX=(PX0+PX1)/2, PCZ=(PZ0+PZ1)/2, WH=FL[3];
/* chân đế theo đúng đường bao mặt bằng tầng 2 của CĐT (u: Bắc→Nam, v: từ biển vào, mét):
   góc Tây Bắc bo elip 17 × 11 m, giếng trời cạnh khối 18–19, khoảng trống phía sau giữa sân căn 03 và vườn sau gym */
var OUT2=[[0,-8.6],[55.6,-8.6],[55.6,0],[52.5,0],[52.5,8.7],[55.5,8.7],[55.5,42.5],[34.7,42.5],[34.7,27.4],[25.4,27.4],[25.4,42.5],[0,42.5]], ROUND2={0:[15.1,11.3],1:1.8,2:.6,5:1.5,7:1.8,10:1.8,11:1.8};
function out2Dense(){ var P=OUT2, n=P.length, o=[];
  for(var i=0;i<n;i++){ var p=P[i], r=ROUND2[i], a=P[(i+n-1)%n], b=P[(i+1)%n];
    if(!r){ o.push(p); continue; }
    var rx=r.length?r[0]:r, ry=r.length?r[1]:r, la=Math.hypot(p[0]-a[0],p[1]-a[1]), lb=Math.hypot(b[0]-p[0],b[1]-p[1]);
    var di=[(p[0]-a[0])/la,(p[1]-a[1])/la], dn=[(b[0]-p[0])/lb,(b[1]-p[1])/lb], ri=Math.abs(di[0])>.5?rx:ry, ro=Math.abs(dn[0])>.5?rx:ry;
    var A0=[p[0]-di[0]*ri,p[1]-di[1]*ri], B0=[p[0]+dn[0]*ro,p[1]+dn[1]*ro], C=[A0[0]+dn[0]*ro,A0[1]+dn[1]*ro], N=r.length?16:8;
    for(var k=0;k<=N;k++){ var t=k/N*Math.PI/2; o.push([C[0]+(A0[0]-C[0])*Math.cos(t)+(B0[0]-C[0])*Math.sin(t), C[1]+(A0[1]-C[1])*Math.cos(t)+(B0[1]-C[1])*Math.sin(t)]); } }
  return o; }
var OUT2D=out2Dense();
function out2Off(g){ var P=OUT2D, n=P.length, ar=0; for(var i=0;i<n;i++){ var a=P[i], b=P[(i+1)%n]; ar+=a[0]*b[1]-b[0]*a[1]; } var sg=ar>0?1:-1, o=[];
  for(var i=0;i<n;i++){ var a=P[(i+n-1)%n], p=P[i], b=P[(i+1)%n];
    function nrm(x,y){ var L=Math.hypot(x,y)||1; return [sg*y/L,-sg*x/L]; }
    var n1=nrm(p[0]-a[0],p[1]-a[1]), n2=nrm(b[0]-p[0],b[1]-p[1]), m=[n1[0]+n2[0],n1[1]+n2[1]], ml=Math.hypot(m[0],m[1])||1; m=[m[0]/ml,m[1]/ml];
    var d=Math.max(.35,m[0]*n1[0]+m[1]*n1[1]); o.push([p[0]+m[0]*g/d,p[1]+m[1]*g/d]); }
  return o; }
function out2Shape(g){ var s=new THREE.Shape(); out2Off(g).forEach(function(q,i){ var w=UV(q[0],q[1]); if(i) s.lineTo(w[0],-w[1]); else s.moveTo(w[0],-w[1]); }); s.closePath(); return s; }
function inOut2(x,z){ var u=z-Z0, v=X1-x, c=false, P=OUT2D; for(var i=0,j=P.length-1;i<P.length;j=i++){ var a=P[i],b=P[j]; if(((a[1]>v)!==(b[1]>v))&&(u<(b[0]-a[0])*(v-a[1])/(b[1]-a[1])+a[0])) c=!c; } return c; }
slab(A,out2Shape(-1.2),0,WH-.8,warm);
var wc=[]; (function(){ var P=out2Off(-.6), acc=0; for(var i=0;i<P.length;i++){ var a=P[i], b=P[(i+1)%P.length], L=Math.hypot(b[0]-a[0],b[1]-a[1]); for(var t=(4.2-acc)%4.2;t<L;t+=4.2){ var w=UV(a[0]+(b[0]-a[0])*t/L,a[1]+(b[1]-a[1])*t/L); wc.push(w); } acc=(acc+L)%4.2; } })();
fins(A,wc,WH-.8,0,white,.9);
slab(A,out2Shape(0),FL[2]-.45,.45,white);
slab(A,out2Shape(.3),WH-.9,.9,white);
// mái đế: vườn cỏ, bồn cây, dừa quanh chân tháp
var deckY=WH+.02;
slab(A,out2Shape(-.7),deckY-.05,.1,lawn);
var rp=[]; for(var z=PZ0+3;z<=PZ1-3;z+=5){ rp.push([PX1-2.2,z]); if(z<CZ-1) rp.push([PX0+1.8,z]); } for(var x=PX0+5;x<=PX1-5;x+=5){ rp.push([x,PZ0+1.8]); rp.push([x,PZ1-2]); }
rp=rp.filter(function(q){ return inOut2(q[0],q[1]); });
rp.forEach(function(q,i){ boxP(A,2,.9,2,q[0],deckY,q[1],white); if(i%2===0){ var tr=new THREE.Mesh(trunkGeo,trunkMat); tr.position.set(q[0],deckY+.9,q[1]); tr.scale.set(.8,6,.8); tr.castShadow=true; A.add(tr); var cw=new THREE.Mesh(crownGeo,leafMat); cw.position.set(q[0],deckY+6.9,q[1]); cw.scale.set(.7,.7,.7); cw.rotation.y=i; cw.castShadow=true; A.add(cw); } else shrubsLocal(A,q[0],deckY+.6,q[1]); });
// hồ bơi phía trước (theo phối cảnh): trên mái đế, dọc mặt tháp hướng biển
(function(){ var px0=X1+1.4, px1=X1+6.2, pz0=Z0+9.5, pz1=Z0+36;
  boxP(A,px1-px0+1.2,.55,pz1-pz0+1.2,(px0+px1)/2,deckY,(pz0+pz1)/2,white);
  var pw=new THREE.Mesh(new THREE.PlaneGeometry(px1-px0,pz1-pz0),M(0x38c6d9,{roughness:.06,metalness:.1,envMapIntensity:1.2,emissive:0x0b5866,emissiveIntensity:.3}));
  pw.rotation.x=-Math.PI/2; pw.position.set((px0+px1)/2,deckY+.58,(pz0+pz1)/2); A.add(pw);
  for(var z=pz0+2;z<pz1;z+=4.5){ boxP(A,1.6,.35,.7,px0-.9,deckY+.55,z,M(0xf2efe8)); }   // ghế tắm nắng
})();
// khối thấp mái cỏ góc Tây Nam (3 tầng), sát mặt Tây khối Nam
var ax0=X1-44, ax1=X1-27, az0=Z0+31, az1=Z0+51, AXc=(ax0+ax1)/2, AZc=(az0+az1)/2, AWd=ax1-ax0, ADd=az1-az0, AH=FL[5]-deckY;
// (bỏ khối thấp mái cỏ phía sau: mặt bằng CĐT tầng 2–3 chỗ này là gym và sân vườn các căn)
// --- Thân tháp chữ L: mặt biển phẳng, khuyết góc Tây Nam ---
// đa giác (toạ độ cục bộ x,z) nới ra g mét; góc lồi bo r, góc lõm bo nhỏ (tự xác định lồi/lõm)
function Lpts(g,nb){   // nb: bỏ khối căn 18–19 nhô ra biển (tầng 29–30 theo bản vẽ CĐT)
  var P=(nb?[[0,0],[49.44,0],[49.44,8.95],[55.5,8.95],[55.5,19.9],[18.81,19.9],[18.81,24.6],[19.9,24.6],[19.9,39.45],[0,39.45]]:[[0,0],[38.4,0],[38.4,-8.6],[55.56,-8.6],[55.56,0],[49.44,0],[49.44,8.95],[55.5,8.95],[55.5,19.9],[18.81,19.9],[18.81,24.6],[19.9,24.6],[19.9,39.45],[0,39.45]]).map(function(q){ return UV(q[0],q[1]); });
  var RV=nb?[1,0,0,1,1,0,0,0,1,1]:[1,0,1,1,0,0,0,1,1,0,0,0,1,1];   // góc bo theo bản vẽ CĐT (2PN 11, 18, 19, 03, 03A và đầu hồi căn 20)
  var n=P.length, out=[];
  for(var i=0;i<n;i++){ var pr=P[(i+n-1)%n], c=P[i], nx=P[(i+1)%n];
    var ax=c[0]-pr[0], az=c[1]-pr[1], bx=nx[0]-c[0], bz=nx[1]-c[1], cross=ax*bz-az*bx;   // >0: góc lồi (đi theo chiều kim đồng hồ trong hệ x Đông, z Nam)
    var n1=[az?(az>0?1:-1):0, ax?(ax>0?-1:1):0], n2=[bz?(bz>0?1:-1):0, bx?(bx>0?-1:1):0];   // pháp tuyến ra ngoài của 2 cạnh
    out.push([c[0]+g*(n1[0]+n2[0]-(n1[0]&&n2[0]?n1[0]:0)), c[1]+g*(n1[1]+n2[1]-(n1[1]&&n2[1]?n1[1]:0)), cross>0&&RV[i]?1:0]); }
  return out; }
function Lshape(g,r,nb){ var P=Lpts(g,nb), s=new THREE.Shape(), n=P.length;
  for(var i=0;i<n;i++){ var c=P[i], pr=P[(i+n-1)%n], nx=P[(i+1)%n];
    var d1=Math.hypot(pr[0]-c[0],pr[1]-c[1]), d2=Math.hypot(nx[0]-c[0],nx[1]-c[1]), rr=Math.max(.05,Math.min(c[2]?r:Math.min(r,.6),d1/2-.01,d2/2-.01));
    var p1=[c[0]+(pr[0]-c[0])/d1*rr, c[1]+(pr[1]-c[1])/d1*rr], p2=[c[0]+(nx[0]-c[0])/d2*rr, c[1]+(nx[1]-c[1])/d2*rr];
    if(i===0) s.moveTo(p1[0],-p1[1]); else s.lineTo(p1[0],-p1[1]); s.quadraticCurveTo(c[0],-c[1],p2[0],-p2[1]); }
  s.closePath(); return s; }
function Lring(g1,g2,r,nb){ var s=Lshape(g1,r,nb); s.holes.push(Lshape(g2,Math.max(.1,r-.2),nb)); return s; }
// điểm dọc chu vi (cho khung đất nung ở đỉnh)
function Lalong(g,step,nb){ var P=Lpts(g,nb), out=[]; for(var i=0;i<P.length;i++){ var c=P[i], nx=P[(i+1)%P.length], L=Math.hypot(nx[0]-c[0],nx[1]-c[1]), k=Math.max(1,Math.round(L/step)); for(var j=0;j<k;j++) out.push([c[0]+(nx[0]-c[0])*j/k, c[1]+(nx[1]-c[1])*j/k]); } return out; }
slab(A,Lshape(0,2.6),FL[3],FL[29]-FL[3],glass);
// ban công trắng bo góc chạy quanh mỗi tầng
for(var f=4;f<=29;f++) slab(A,Lshape(1.6,4),FL[f]-.6,.6,white).position.y=FL[f]-.32;
// (bỏ lan can kính trong suốt: nhiều lớp trong suốt chồng nhau gây nháy sáng khi xoay)
var hT=FL[29]-FL[3];
function tStrip(w,d,x,z,rx){ var m=new THREE.Mesh(new THREE.BoxGeometry(w,hT,d),terraMat(rx,NF)); m.position.set(x,FL[3]+hT/2,z); m.castShadow=true; A.add(m); return m; }
// đất nung: góc trong chữ L ở mặt sau (2 mặt), giữa mặt biển (thẳng hàng cánh Bắc), mặt bên khối 2PN nhô ra, góc Đông Bắc
tStrip(8,2.4,CX-4,CZ+1.0,2);
tStrip(2.4,8,CX-1.0,CZ+4,2);
tStrip(2.4,6,X1+1.0,CZ,2);
tStrip(8.6,2.4,X1+4.3,Z0+38.4-1.0,2);
tStrip(7,2.4,X1-3.7,Z0-1.0,2);
// --- 2 tầng đỉnh: kính + khung đất nung, mái phẳng ---
var hC=TOP-FL[29];
// theo phối cảnh CĐT: khối 2PN 18–19 dừng ở tầng 28, mái là vườn (tầng 29); tầng 29–30 theo chữ L không có khối này
var roofW=M(0xeeece6,{roughness:.8});
slab(A,Lshape(-.3,.3,1),FL[29],hC,glassTop);
fins(A,Lalong(-.12,3.5,1),hC,FL[29],terra,.32);   // đố đứng đất nung mảnh, sát mặt kính (theo phối cảnh CĐT)
slab(A,Lshape(1,.6),FL[29]-.6,.8,terra);
slab(A,Lring(1.4,-.1,.6,1),TOP-1.2,3.4,terra);
slab(A,Lshape(-.3,.3,1),TOP,.5,roofW);
(function(){ var r1=UV(10,10), r2=UV(11,30), r3=UV(44,5); boxP(A,8,4,12,r1[0],TOP+.5,r1[1],roofW); boxP(A,8,3.2,6,r2[0],TOP+.5,r2[1],roofW); boxP(A,6,3,8,r3[0],TOP+.5,r3[1],roofW);
  // mái khối 18–19: lan can đất nung bo góc + vườn cỏ, bồn cây
  var bx=X1+4.3, bz=Z0+46.98;
  slab(A,Lring(1.4,-.1,.6),FL[29]+.2,1.3,terra);
  slab(A,rrect(8.3,16.9,1.6),FL[29]+.2,.35,lawn).position.set(bx,FL[29]+.2,bz);
  for(var i=0;i<6;i++){ var sh=new THREE.Mesh(new THREE.SphereGeometry(.9,10,8),leafMat); sh.position.set(bx-2.4+(i%2)*4.8,FL[29]+1.2,bz-6+Math.floor(i/2)*6); sh.scale.set(1,.8,1); sh.castShadow=true; A.add(sh); } })();
// sảnh vào chính hướng Trường Sa
boxP(A,4.5,.7,12,X1+6.5,FL[2]+.6,(Z0+ZM-SL)/2,white);

// ===== mặt bằng tầng đặt lên tháp (như nút "Mặt bằng tầng" của 4D): cắt ngang tháp tại tầng đang chọn =====
// ảnh: trái→phải = Bắc→Nam, trên = biển; tầng 3A–29 dùng chung, tầng 30 / 3 / 2 có ảnh riêng
var PLAN_F={a:'mat-bang-tang-4d.webp',30:'mat-bang-tang-30-4d.webp',3:'mat-bang-tang-3-4d.webp',2:'mat-bang-tang-2-4d.webp'}, PLAN_H={a:49.6,30:49.6,3:53.4,2:53.4};
var clipP=new THREE.Plane(new THREE.Vector3(0,-1,0),0), clipped=false, planMesh=null, planTx={}, ldr=new THREE.TextureLoader();
A.userData.setPlan=function(f, base, renderer){
  if(!clipped){ A.traverse(function(o){ if(o.isMesh&&o!==planMesh){ o.material=Array.isArray(o.material)?o.material.map(function(m){return m.clone();}):o.material.clone(); } }); clipped=true; }
  var on=f!=null;
  A.traverse(function(o){ if(!o.isMesh||o===planMesh) return; (Array.isArray(o.material)?o.material:[o.material]).forEach(function(m){ m.clippingPlanes=on?[clipP]:[]; m.clipShadows=true; m.needsUpdate=true; }); });
  if(renderer) renderer.localClippingEnabled=true;
  if(!planMesh){ var g=new THREE.PlaneGeometry(55.6,49.6); g.rotateX(-Math.PI/2); g.rotateY(-Math.PI/2);
    planMesh=new THREE.Mesh(g,new THREE.MeshBasicMaterial({transparent:true,alphaTest:.04,toneMapped:false,side:THREE.DoubleSide})); planMesh.renderOrder=11; planMesh.userData.keep=true; planMesh.visible=false; A.add(planMesh); }
  planMesh.visible=on; if(!on) return;
  f=Math.max(2,Math.min(30,f)); var k=f>=30?30:f===3?3:f===2?2:'a', y=FL[f];
  if(!planTx[k]){ var t=ldr.load(base+PLAN_F[k]); t.colorSpace=THREE.SRGBColorSpace; t.anisotropy=8; planTx[k]=t; }
  planMesh.material.map=planTx[k]; planMesh.material.needsUpdate=true;
  planMesh.scale.x=PLAN_H[k]/49.6; planMesh.position.set(X1-(PLAN_H[k]/2-9.9), y+.4, Z0+27.8);
  A.updateMatrixWorld(true); clipP.constant=A.localToWorld(new THREE.Vector3(0,y+.5,0)).y;
};
return A;
}
