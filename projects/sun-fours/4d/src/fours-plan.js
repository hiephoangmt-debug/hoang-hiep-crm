/* ---------- MẶT BẰNG TẦNG trên tòa nhà: cắt ngang 4 tòa ở cao độ tầng đang chọn, đặt mặt bằng căn (vẽ lại từ bản vẽ CĐT) ---------- */
var CRM=/[?&]crm/.test(location.search);
var CC_URL='__CC_URL__';
var TYPEC={'STU':'#86b5c6','1PN':'#bf8f78','1PN+':'#5d8f46','2PN':'#f6b625','2PN+':'#f6b625','3PN':'#ee6b4d','P':'#a993d6','SH':'#c9b9e6'};
var TNAME={'STU':'Studio','1PN':'1 phòng ngủ','1PN+':'1 phòng ngủ + 1','2PN':'2 phòng ngủ','2PN+':'2 phòng ngủ + 1','3PN':'3 phòng ngủ','P':'1PN+ (khối giữa)','SH':'Thương mại (shophouse)'};
var TWN=['F1','F2','F5'];                       // tòa có mặt bằng CĐT
function pad(f){ var m=/^(\d+)(.*)$/.exec(f); return (m[1].length<2?'0':'')+m[1]+m[2]; }
function bbP(P){ var b=[1e9,1e9,-1e9,-1e9]; P.forEach(function(p){ b[0]=Math.min(b[0],p[0]); b[1]=Math.min(b[1],p[1]); b[2]=Math.max(b[2],p[0]); b[3]=Math.max(b[3],p[1]); }); return b; }
function cenP(P){ var a=0,x=0,y=0; for(var i=0,j=P.length-1;i<P.length;j=i++){ var c=P[j][0]*P[i][1]-P[i][0]*P[j][1]; a+=c; x+=(P[j][0]+P[i][0])*c; y+=(P[j][1]+P[i][1])*c; } a/=2; return Math.abs(a)<1e-6?P[0]:[x/(6*a),y/(6*a)]; }
function labelPt(P){ var c=cenP(P); if(inPoly(c[0],c[1],P)) return c; var b=bbP(P), best=null, bd=-1; for(var i=1;i<14;i++) for(var j=1;j<14;j++){ var x=b[0]+(b[2]-b[0])*i/14, y=b[1]+(b[3]-b[1])*j/14; if(!inPoly(x,y,P)) continue; var d=1e9; for(var k=0;k<P.length;k++) d=Math.min(d,Math.hypot(P[k][0]-x,P[k][1]-y)); if(d>bd){ bd=d; best=[x,y]; } } return best||c; }
function upBrg(t){ return PL[t].up==='NW'?BRG-90:BRG; }
function wind(b){ b=((b%360)+360)%360; return ['Bắc','Đông Bắc','Đông','Đông Nam','Nam','Tây Nam','Tây','Tây Bắc'][Math.round(b/45)%8]; }
var DIRS=[[0,-1,0],[1,0,90],[0,1,180],[-1,0,270]];
function faces(u,B){ var c=labelPt(u.poly), out=[];
  DIRS.forEach(function(d){ var x=c[0], y=c[1], k=0; while(k<400&&inPoly(x,y,u.poly)){ x+=d[0]*.25; y+=d[1]*.25; k++; }
    for(var s=0;s<=10;s++){ var px=x+d[0]*s*.25, py=y+d[1]*s*.25; if(!inPoly(px,py,B.foot)){ out.push({d:d,p:[px,py]}); break; } } });
  return out; }
function bandAt(t,f){ if(t==='F2'&&window.FS_MBC){ var k=FS_MBC.F2.floors[FN(f)]; return k?FS_MBC.F2.sheets[k]:null; } return PL[t]?band(t,FN(f)):null; }   // F2: mặt bằng chuẩn (tường, kính, cửa đo trên bản gốc CĐT)
function nearBandFloor(t,f){ if(bandAt(t,f)) return f; for(var k=1;k<19;k++){ if(bandAt(t,f-k)) return f-k; if(bandAt(t,f+k)) return f+k; } return f; }
function uCodeOf(t,f,u){ return t+'-'+pad(FN(f))+'-'+u.code; }
var STOCK={}; (window.FOURS_STOCK&&FOURS_STOCK.units||[]).forEach(function(r){ STOCK[r[0]]=r; });
function ty(x){ return (x/1e9).toFixed(2).replace('.',','); }
function um2(x){ return String(x).replace('.',','); }

// ảnh mặt bằng tầng: vẽ lại theo đường bao + căn hộ trích từ bản vẽ CĐT (đúng toạ độ khối tháp → đặt khít lên mặt cắt)
var PLAN_TX={};
var PIMG_BASE=(/^https?:/.test(location.href)&&/sun-fours-4d\.html/.test(location.pathname))?'plan-img/':'https://raw.githack.com/hiephoangmt-debug/hoang-hiep-crm/telegram-notify/projects/sun-fours/4d/plan-img/';
function planTex(t,B){ var key=t+B.key; if(PLAN_TX[key]) return PLAN_TX[key];
  var A=B.foot.slice(); B.gardens.forEach(function(G){ A=A.concat(G); }); var b=bbP(A), m=1.2; b=[b[0]-m,b[1]-m,b[2]+m,b[3]+m];
  var PI=window.FS_PIMG&&FS_PIMG[B.key]; if(PI) b=PI.slice();   // có ảnh bản vẽ CĐT: dùng đúng khung ảnh
  var W=b[2]-b[0], D=b[3]-b[1], S=Math.min(48,4096/Math.max(W,D)), c=document.createElement('canvas'); c.width=Math.ceil(W*S); c.height=Math.ceil(D*S);
  var g=c.getContext('2d'); g.setTransform(S,0,0,S,-b[0]*S,-b[1]*S); g.lineJoin='round';
  function pth(P){ g.beginPath(); P.forEach(function(p,i){ if(i) g.lineTo(p[0],p[1]); else g.moveTo(p[0],p[1]); }); g.closePath(); }
  B.gardens.forEach(function(G){ pth(G); g.fillStyle='#cfe8a6'; g.fill(); g.strokeStyle='#8cb85e'; g.lineWidth=.12; g.stroke(); });
  pth(B.foot); g.fillStyle='#f6f3ec'; g.fill();
  var MB=!!B.walls;
  B.units.forEach(function(u){ pth(u.poly); g.globalAlpha=MB?.55:1; g.fillStyle=TYPEC[u.color]||'#ccc'; g.fill(); g.globalAlpha=1; if(!MB){ g.strokeStyle='#0A2540'; g.lineWidth=.14; g.stroke(); } });
  if(MB){ g.fillStyle='#5fa3c9'; B.glass.forEach(function(r){ g.fillRect(r[0],r[1],Math.max(.04,r[2]-r[0]),Math.max(.04,r[3]-r[1])); });
    g.fillStyle='#1d2733'; B.walls.forEach(function(r){ g.fillRect(r[0],r[1],r[2]-r[0],r[3]-r[1]); });
    g.strokeStyle='#56606b'; g.lineWidth=.05; B.doors.forEach(function(d){ var a1=Math.atan2(d.l[1]-d.h[1],d.l[0]-d.h[0]), a2=Math.atan2(d.c[1]-d.h[1],d.c[0]-d.h[0]), sw=((a2-a1+Math.PI*2)%(Math.PI*2))<Math.PI;
      g.beginPath(); g.moveTo(d.h[0],d.h[1]); g.lineTo(d.l[0],d.l[1]); g.arc(d.h[0],d.h[1],d.r,a1,a2,!sw); g.stroke(); }); }
  else { pth(B.foot); g.strokeStyle='#0A2540'; g.lineWidth=.38; g.stroke(); }
  g.fillStyle='#0A2540'; g.textAlign='center'; g.textBaseline='middle';
  B.units.forEach(function(u){ var p=labelPt(u.poly), ub=bbP(u.poly), w=ub[2]-ub[0], h=ub[3]-ub[1], fs=Math.max(.8,Math.min(1.9,w/(u.code.length*.72+.6),h/3));
    if(MB) fs=Math.min(fs,1.3); g.font='800 '+fs+'px "Be Vietnam Pro",Arial,sans-serif'; g.fillText(u.code,p[0],p[1]-fs*.25);
    var s2=um2(u.tt)+' m²', f2=Math.min(fs*.6,w/(s2.length*.6+.6)); if(f2>=.42){ g.font='600 '+f2+'px "Be Vietnam Pro",Arial,sans-serif'; g.fillText(s2,p[0],p[1]+fs*.55); } });
  g.font='700 1px "Be Vietnam Pro",Arial,sans-serif'; g.textAlign='left'; g.fillStyle='#0A2540'; g.fillText('Tòa '+t+' · minh họa, thông số theo CĐT',b[0]+.4,b[3]-.6);
  var tx=new THREE.CanvasTexture(c); tx.encoding=THREE.sRGBEncoding; tx.anisotropy=Math.min(16,renderer.capabilities.getMaxAnisotropy());
  if(PI){ var im=new Image(); im.crossOrigin='anonymous';   // ảnh mặt bằng gốc CĐT đặt đúng toạ độ thân tháp, thêm số căn để dễ bấm
    im.onload=function(){ var c2=document.createElement('canvas'); c2.width=im.naturalWidth; c2.height=im.naturalHeight; var g2=c2.getContext('2d'), k=c2.width/(b[2]-b[0]);
      g2.drawImage(im,0,0); g2.setTransform(k,0,0,k,-b[0]*k,-b[1]*k);
      var mk=document.createElement('canvas'); mk.width=c2.width; mk.height=c2.height; var gm=mk.getContext('2d'); gm.setTransform(k,0,0,k,-b[0]*k,-b[1]*k); gm.fillStyle=gm.strokeStyle='#000'; gm.lineWidth=7; gm.lineJoin='round';   // chỉ giữ phần tòa nhà + sân vườn (bỏ chú thích bên ngoài)
      [B.foot].concat(B.gardens||[]).forEach(function(P){ gm.beginPath(); P.forEach(function(q,i){ if(i) gm.lineTo(q[0],q[1]); else gm.moveTo(q[0],q[1]); }); gm.closePath(); gm.fill(); gm.stroke(); });
      g2.save(); g2.setTransform(1,0,0,1,0,0); g2.globalCompositeOperation='destination-in'; g2.drawImage(mk,0,0); g2.restore();
      g2.globalCompositeOperation='source-over'; g2.textAlign='center'; g2.textBaseline='middle'; g2.lineJoin='round';
      B.units.forEach(function(u){ var p=labelPt(u.poly), ub=bbP(u.poly), fs=Math.max(.7,Math.min(1.25,(ub[2]-ub[0])/(u.code.length*.75+.8)));
        g2.font='800 '+fs+'px "Be Vietnam Pro",Arial,sans-serif'; g2.lineWidth=fs*.28; g2.strokeStyle='rgba(255,255,255,.95)'; g2.strokeText(u.code,p[0],p[1]); g2.fillStyle='#0A2540'; g2.fillText(u.code,p[0],p[1]); });
      tx.image=c2; tx.needsUpdate=true; };
    im.src=PIMG_BASE+B.key+'.webp'; }
  return (PLAN_TX[key]={tx:tx,b:b}); }
var planOn=false, bPlan=document.getElementById('mPlan'), curT='F2', PM={}, CAPS={};
renderer.localClippingEnabled=true;
var CLIP=new THREE.Plane(new THREE.Vector3(0,-1,0),1e5);
[matGlass,matTerra,matWhite,matSlab,matGreen,matPlanter,matShop,matRoof,matLawn].forEach(function(m){ m.clippingPlanes=[CLIP]; m.clipShadows=true; });
function planMesh(t){ if(PM[t]) return PM[t]; var m=new THREE.Mesh(new THREE.PlaneGeometry(1,1),new THREE.MeshBasicMaterial({transparent:true,alphaTest:.02,toneMapped:false,side:THREE.DoubleSide}));
  m.geometry.rotateX(-Math.PI/2); m.renderOrder=3; m.visible=false; TOWERS[t].grp.add(m); return (PM[t]=m); }
function capMesh(t){ if(CAPS[t]) return CAPS[t]; var T0=TOWERS[t], g=new THREE.ExtrudeGeometry(shapeOf(T0.P,.6,T0.cx,T0.cy),{depth:.3,bevelEnabled:false}); g.rotateX(-Math.PI/2);
  var m=new THREE.Mesh(g,M(0xe9e5dc)); m.visible=false; T0.grp.add(m); return (CAPS[t]=m); }
// tường, kính, cửa đúng mặt bằng chuẩn dựng 3D cao 1,2 m trên mặt cắt (Tòa F2)
var WALL3={}, wallM=M(0x2b3440,{roughness:.8}), glassM=M(0x5fa3c9,{roughness:.2,metalness:.2,transparent:true,opacity:.75}), doorM=M(0xb88a5c,{roughness:.6});
function walls3(t,B){ if(!B.walls) return null; var k=t+B.key; if(WALL3[k]) return WALL3[k]; var T0=TOWERS[t], g=new THREE.Group(), bx=new THREE.BoxGeometry(1,1,1); bx.translate(0,.5,0);
  function inst(L,mat,h){ var im=new THREE.InstancedMesh(bx,mat,L.length), o=new THREE.Object3D(); L.forEach(function(r,i){ o.position.set((r[0]+r[2])/2-T0.cx,0,(r[1]+r[3])/2-T0.cy); o.scale.set(Math.max(.04,r[2]-r[0]),h,Math.max(.04,r[3]-r[1])); o.updateMatrix(); im.setMatrixAt(i,o.matrix); }); im.castShadow=true; g.add(im); }
  inst(B.walls,wallM,1.2); inst(B.glass,glassM,1.0);
  var dl=B.doors.map(function(d){ var x0=Math.min(d.h[0],d.c[0]), x1=Math.max(d.h[0],d.c[0]), y0=Math.min(d.h[1],d.c[1]), y1=Math.max(d.h[1],d.c[1]); return [x0,y0,x1,y1]; });   // cửa đóng: tấm gỗ thấp đúng ô cửa
  inst(dl.map(function(r){ var w=r[2]-r[0], d=r[3]-r[1]; return w>d?[r[0],(r[1]+r[3])/2-.03,r[2],(r[1]+r[3])/2+.03]:[(r[0]+r[2])/2-.03,r[1],(r[0]+r[2])/2+.03,r[3]]; }),doorM,.9);
  g.visible=false; T0.grp.add(g); return (WALL3[k]=g); }
function updPlan(doFly){
  var f=+floorEl.value, y=FL[f];
  CLIP.constant=planOn?y+.5:1e5;
  ['F1','F2','F3','F5'].forEach(function(t){ var B=bandAt(t,f), T0=TOWERS[t];
    if(B){ var P=planTex(t,B), m=planMesh(t); m.material.map=P.tx; m.material.needsUpdate=true; m.scale.set(P.b[2]-P.b[0],1,P.b[3]-P.b[1]);
      m.position.set((P.b[0]+P.b[2])/2-T0.cx,y+.42,(P.b[1]+P.b[3])/2-T0.cy); m.visible=planOn; m.userData={t:t,B:B}; for(var wk in WALL3) if(WALL3[wk].parent===T0.grp) WALL3[wk].visible=false; var w3=false;   // anh Hiệp: dùng nguyên ảnh mặt bằng CĐT, không dựng lại tường if(w3){ w3.position.y=y+.44; w3.visible=true; } if(CAPS[t]) CAPS[t].visible=false; }
    else { for(var wk2 in WALL3) if(WALL3[wk2].parent===T0.grp) WALL3[wk2].visible=false; if(PM[t]) PM[t].visible=false; var c=capMesh(t); c.position.y=y+.2; c.visible=planOn; } });
  floorOut.textContent='Tầng '+FN(f)+(planOn?' · bấm căn':'');
  if(planOn) planFloorUI(f);
  if(doFly) flyPlan();
}
function flyPlan(){ var T0=TOWERS[curT], y=FL[+floorEl.value], m=innerWidth<600; T0.grp.updateMatrixWorld(true);
  flyTo(T0.grp.localToWorld(new THREE.Vector3(m?-20:-45,y+(m?118:82),m?70:85)),T0.grp.localToWorld(new THREE.Vector3(0,y,4))); }
function setPlan(on){
  if(on&&mode==='view') setMode('overview');
  planOn=on; bPlan.setAttribute('aria-pressed',on); hi.visible=!on&&mode!=='view'; mainLbl.style.visibility=on?'hidden':'';
  document.getElementById('twRow').hidden=!on; controls.maxDistance=on?2600:Math.max(controls.maxDistance,2600);
  if(on){ var f=+floorEl.value, nf=nearBandFloor(curT,f); if(nf!==f){ floorEl.value=nf; setFloor(nf); } }
  updPlan(on); if(!on){ uHi.visible=false; if(uCard) uCard.style.display='none'; if(ofcBtn) ofcBtn.style.display='none'; if(DEF) flyTo(DEF.p,DEF.t); }
}
bPlan.onclick=function(){ setPlan(!planOn); };
function setTower(t){ curT=t; document.querySelectorAll('#twRow [data-t]').forEach(function(b){ b.setAttribute('aria-pressed',b.getAttribute('data-t')===t); });
  fitHi(); if(planOn){ var f=+floorEl.value, nf=nearBandFloor(t,f); if(nf!==f){ floorEl.value=nf; setFloor(nf); } updPlan(true); } }
document.querySelectorAll('#twRow [data-t]').forEach(function(b){ b.onclick=function(){ if(b.disabled) return; setTower(b.getAttribute('data-t')); }; });
var ofcBtn=null;
function planFloorUI(f){
  if(!ofcBtn){ ofcBtn=document.createElement('button'); ofcBtn.id='ofcBtn'; ofcBtn.textContent='📐 Mặt bằng chi tiết tầng này';
    ofcBtn.style.cssText='position:fixed;left:50%;transform:translateX(-50%);top:calc(env(safe-area-inset-top,0px) + 96px);z-index:25;border:0;border-radius:18px;background:#0A2540;color:#fff;font:800 13px inherit;padding:9px 14px;box-shadow:0 6px 16px rgba(10,37,64,.3);cursor:pointer';
    ofcBtn.onclick=function(){ openUnitTool(curT,+floorEl.value,null); }; document.body.appendChild(ofcBtn); }
  ofcBtn.style.display=planOn&&bandAt(curT,f)?'block':'none';
  if(uCard){ uCard.style.display='none'; uHi.visible=false; } }

/* ---------- bấm vào căn trên mặt bằng: thẻ căn → Chọn căn FourS (mặt bằng & 3D căn) hoặc đứng trong căn (5D) ---------- */
var uHi=new THREE.Mesh(new THREE.BufferGeometry(),new THREE.MeshBasicMaterial({color:0xff6a2b,transparent:true,opacity:.45,depthWrite:false,toneMapped:false}));
uHi.visible=false; uHi.renderOrder=4;
var uCss=document.createElement('style'); uCss.textContent='#uCard{position:fixed;left:50%;top:96px;transform:translateX(-50%);z-index:30;width:min(92vw,360px);background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(10,37,64,.28);padding:12px 14px;font-family:inherit;color:#0A2540;border-top:4px solid #FF6A2B}'
 +'#uCard h4{margin:0 26px 2px 0;font-size:17px}#uCard .s{font-size:13px;color:#41505f;margin-bottom:8px;line-height:1.45}#uCard .p{font-size:13px;margin:-2px 0 8px;color:#0A2540}#uCard .p b{color:#E8460F;font-size:15px}#uCard .b{display:flex;gap:6px;flex-wrap:wrap}#uCard button{flex:1;min-width:130px;border:0;border-radius:10px;padding:9px 8px;font:800 13px inherit;cursor:pointer}'
 +'#uCard .o{background:#FF6A2B;color:#fff}#uCard .n{background:#0A2540;color:#fff}#uCard .x{position:absolute;right:8px;top:6px;background:none;min-width:0;flex:0;font-size:18px;color:#5d6b7a;padding:2px 6px}'
 +'#uOv{position:fixed;inset:0;z-index:40;background:rgba(10,37,64,.55);display:flex;align-items:center;justify-content:center}#uOv .w{position:relative;width:min(98vw,1180px);height:min(94vh,980px);background:#fff;border-radius:14px;overflow:hidden;-webkit-overflow-scrolling:touch;overflow:auto}'
 +'#uOv iframe{width:1px;min-width:100%;height:100%;border:0;display:block}#uOv .c{position:absolute;right:10px;top:8px;z-index:2;border:0;border-radius:18px;background:#FF6A2B;color:#fff;font:800 14px inherit;padding:7px 12px;cursor:pointer}';
document.head.appendChild(uCss);
var uCard=null;
function showUnit(t,f,B,u){
  var T0=TOWERS[t]; if(uHi.parent!==T0.grp) T0.grp.add(uHi);
  var g=new THREE.ShapeGeometry(shapeOf(u.poly,.05,T0.cx,T0.cy)); g.rotateX(-Math.PI/2); uHi.geometry.dispose(); uHi.geometry=g; uHi.position.y=FL[f]+.5; uHi.visible=true;
  if(!uCard){ uCard=document.createElement('div'); uCard.id='uCard'; document.body.appendChild(uCard); }
  var fs=faces(u,B), dirs=fs.map(function(x){ return wind(upBrg(t)+x.d[2]); }), code=uCodeOf(t,f,u), st=STOCK[code];
  var pr=CRM&&st?'<div class="p">Giá tham khảo CĐT từ <b>'+ty(st[3])+' tỷ</b> <small>(gồm VAT + KPBT, cập nhật '+FOURS_STOCK.updated+')</small></div>':'';
  uCard.innerHTML='<button class="x" aria-label="Đóng">✕</button><h4>Căn '+code+' · '+(TNAME[u.type]||u.type)+'</h4><div class="s"><b>Thông thủy '+um2(u.tt)+' m²</b>'+(u.tim?' · tim tường '+um2(u.tim)+' m²':'')+(u.san?' · sân vườn '+um2(u.san)+' m²':'')+'<br>Mặt thoáng nhìn về: '+(dirs.length?dirs.join(' · '):'—')+'<br><i>Minh họa, thông số theo CĐT</i></div>'+pr
    +'<div class="b"><button class="o" data-a="plan">Mặt bằng &amp; 3D căn</button><button class="n" data-a="view"'+(fs.length?'':' disabled')+'>View từ căn này (5D)</button></div>';
  uCard.style.display='block';
  uCard.querySelector('.x').onclick=function(){ uCard.style.display='none'; uHi.visible=false; };
  uCard.querySelector('[data-a=plan]').onclick=function(){ openUnitTool(t,f,u.code); };
  uCard.querySelector('[data-a=view]').onclick=function(){ viewFromUnit(t,f,u); };
}
function openUnitTool(t,f,code){
  var ov=document.createElement('div'); ov.id='uOv';
  ov.innerHTML='<div class="w"><button class="c">✕ Đóng</button><iframe title="Mặt bằng & 3D căn" allow="fullscreen" src="'+CC_URL+'?t='+t+'&f='+encodeURIComponent(FN(f))+(code?'&u='+encodeURIComponent(code):'')+(CRM?'&crm':'')+'"></iframe></div>';
  ov.querySelector('.c').onclick=function(){ ov.remove(); }; ov.onclick=function(e){ if(e.target===ov) ov.remove(); };
  document.body.appendChild(ov);
}
(function(){ var down=null, rc=new THREE.Raycaster(), ndc=new THREE.Vector2();
  renderer.domElement.addEventListener('pointerdown',function(e){ down=[e.clientX,e.clientY]; });
  renderer.domElement.addEventListener('pointerup',function(e){
    if(!down||!planOn) return; var mv=Math.hypot(e.clientX-down[0],e.clientY-down[1]); down=null; if(mv>7) return;
    var rect=renderer.domElement.getBoundingClientRect(); ndc.set((e.clientX-rect.left)/rect.width*2-1,-(e.clientY-rect.top)/rect.height*2+1);
    rc.setFromCamera(ndc,camera); var L=[]; for(var k in PM) if(PM[k].visible) L.push(PM[k]); var hit=rc.intersectObjects(L)[0]; if(!hit) return;
    var D=hit.object.userData, T0=TOWERS[D.t], lp=T0.grp.worldToLocal(hit.point.clone()), x=lp.x+T0.cx, y=lp.z+T0.cy, f=+floorEl.value;
    var u=D.B.units.filter(function(q){ return inPoly(x,y,q.poly); })[0];
    if(D.t!==curT) setTower(D.t);
    if(u) showUnit(D.t,f,D.B,u); });
})();

/* ---------- 5D: đứng bên trong căn (sàn gỗ, trần, vách, cửa kính đúng đường bao căn), kéo nhìn 360°, chạm sàn để đi ---------- */
var inRoom=null, inUnit=null, inFloor=null, unitEye=null;
var inHidden=[];
function clearRoom(){ inHidden.forEach(function(o){ o.visible=true; }); inHidden=[]; if(inRoom){ inRoom.parent&&inRoom.parent.remove(inRoom); inRoom.traverse(function(o){ if(o.geometry) o.geometry.dispose(); }); inRoom=null; } }
var RM={wood:M(0xb08a62,{roughness:.6}),wall:M(0xf3efe8,{roughness:.95,side:THREE.DoubleSide}),ceil:M(0xfbfaf7,{roughness:1,side:THREE.DoubleSide}),alu:M(0x3a4048,{roughness:.35,metalness:.7}),
  glass:new THREE.MeshStandardMaterial({color:0xcfe6f2,transparent:true,opacity:.05,roughness:0,metalness:.6,depthWrite:false,side:THREE.FrontSide}),cur:new THREE.MeshStandardMaterial({color:0xfffaf0,transparent:true,opacity:.85,roughness:1,side:THREE.DoubleSide})};
function buildRoom(t,f,B,u,face){
  clearRoom(); var T0=TOWERS[t], g=new THREE.Group(); T0.grp.add(g); inRoom=g; inUnit={t:t,code:u.code}; inFloor=f;
  T0.grp.children.forEach(function(o){ var pr=o.geometry&&o.geometry.parameters; if(o.isInstancedMesh&&pr&&pr.width===.55&&o.visible){ o.visible=false; inHidden.push(o); } });   // ẩn khung trắng dọc mặt ngoài tòa đang đứng (thực tế là cột mảnh, không che view)
  var y0=FL[f]+.33, H=2.85, cx=T0.cx, cy=T0.cy, P=u.poly, n=P.length, ar=0; for(var i=0;i<n;i++){ var a=P[i], b=P[(i+1)%n]; ar+=a[0]*b[1]-b[0]*a[1]; } var sg=ar>0?1:-1;
  var sh=shapeOf(P,.02,cx,cy), fg=new THREE.ShapeGeometry(sh); fg.rotateX(-Math.PI/2); var fl=new THREE.Mesh(fg,RM.wood); fl.position.y=y0; fl.receiveShadow=true; fl.name='inFloor'; g.add(fl);
  var cg=new THREE.ShapeGeometry(sh); cg.rotateX(-Math.PI/2); var ce=new THREE.Mesh(cg,RM.ceil); ce.position.y=y0+H; g.add(ce);
  function seg(ax,az,bx,bz,yb,h,th,mat){ var dx=bx-ax, dz=bz-az, L=Math.hypot(dx,dz); if(L<.02) return; var me=new THREE.Mesh(new THREE.BoxGeometry(L,h,th),mat); me.position.set((ax+bx)/2,yb+h/2,(az+bz)/2); me.rotation.y=Math.atan2(-dz,dx); g.add(me); }
  var best=null, bl=0, cand=[];
  for(var i=0;i<n;i++){ var a=P[i], b=P[(i+1)%n], dx=b[0]-a[0], dy=b[1]-a[1], L=Math.hypot(dx,dy); if(L<.05) continue;
    var nx=sg*dy/L, ny=-sg*dx/L, mx=(a[0]+b[0])/2, my=(a[1]+b[1])/2, ext=!inPoly(mx+nx*.9,my+ny*.9,B.foot)&&!(B.gardens||[]).some(function(G){ return inPoly(mx+nx*.9,my+ny*.9,G); }), gard=!ext&&!inPoly(mx+nx*.9,my+ny*.9,B.foot);
    var A=[a[0]-cx,a[1]-cy], Bp=[b[0]-cx,b[1]-cy];
    if(ext||gard){ cand.push({m:[mx,my],n:[nx,ny],L:L}); if(L>bl){ bl=L; best={m:[mx,my],n:[nx,ny]}; }
      if(B.walls) continue;
      seg(A[0],A[1],Bp[0],Bp[1],y0,H-.06,.03,RM.glass); seg(A[0],A[1],Bp[0],Bp[1],y0+H-.12,.12,.08,RM.alu); seg(A[0],A[1],Bp[0],Bp[1],y0,.05,.08,RM.alu);
      var k=Math.max(1,Math.round(L/1.25)); for(var j=0;j<=k;j++){ var tt=j/k, x=A[0]+(Bp[0]-A[0])*tt, z=A[1]+(Bp[1]-A[1])*tt; seg(x-dx/L*.03,z-dy/L*.03,x+dx/L*.03,z+dy/L*.03,y0,H,.07,RM.alu); }
      if(L>3){ [[0,.5],[L-.5,L]].forEach(function(r2){ for(var c2=0;c2<4;c2++){ var t2=(r2[0]+(c2+.5)*(r2[1]-r2[0])/4)/L; var x=A[0]+(Bp[0]-A[0])*t2-nx*.12, z=A[1]+(Bp[1]-A[1])*t2-ny*.12; seg(x-dx/L*.05,z-dy/L*.05,x+dx/L*.05,z+dy/L*.05,y0+.05,H-.25,.02,RM.cur); } }); } }
    else if(!B.walls) seg(A[0],A[1],Bp[0],Bp[1],y0,H,.14,RM.wall); }
  if(B.walls){ var ub=bbP(P), m3=.35; function nr(r){ return r[2]>ub[0]-m3&&r[0]<ub[2]+m3&&r[3]>ub[1]-m3&&r[1]<ub[3]+m3; }   // tường, vách, kính đúng mặt bằng chuẩn
    B.walls.forEach(function(r){ if(!nr(r)) return; var w=Math.max(.04,r[2]-r[0]), d=Math.max(.04,r[3]-r[1]), me=new THREE.Mesh(new THREE.BoxGeometry(w,H,d),RM.wall); me.position.set((r[0]+r[2])/2-cx,y0+H/2,(r[1]+r[3])/2-cy); g.add(me); });
    B.glass.forEach(function(r){ if(!nr(r)) return; var w=Math.max(.03,r[2]-r[0]), d=Math.max(.03,r[3]-r[1]), me=new THREE.Mesh(new THREE.BoxGeometry(w,H-.08,d),RM.glass); me.position.set((r[0]+r[2])/2-cx,y0+(H-.08)/2,(r[1]+r[3])/2-cy); g.add(me);
      var fr=new THREE.Mesh(new THREE.BoxGeometry(w+.02,.08,d+.02),RM.alu); fr.position.set(me.position.x,y0+H-.04,me.position.z); g.add(fr); }); }
  var lp=labelPt(P), lt=new THREE.PointLight(0xffe2bc,.8,14,2); lt.position.set(lp[0]-cx,y0+2.5,lp[1]-cy); g.add(lt); g.add(new THREE.HemisphereLight(0xffffff,0xe0cfb4,.28));
  // chỗ đứng: trong căn, cách mặt kính lớn nhất ~2,2 m, nhìn thẳng ra kính
  if(face){ var fb=null; cand.forEach(function(c){ if(c.n[0]*face.d[0]+c.n[1]*face.d[1]>.9&&(!fb||c.L>fb.L)) fb=c; }); if(fb) best=fb; }   // đứng giữa mặt kính lớn nhất phía hướng view
  if(best){ var ks=[2.8,2.4,2,1.6,1.2,.8]; for(var i2=0;i2<ks.length;i2++){ var e3=[best.m[0]-best.n[0]*ks[i2],best.m[1]-best.n[1]*ks[i2]]; if(inPoly(e3[0],e3[1],P)) return {eye:[e3[0]-cx,e3[1]-cy], look:[best.m[0]+best.n[0]*20-cx,best.m[1]+best.n[1]*20-cy], y:y0+1.55}; } }
  var eye=lp, look=null; if(best){ var e2=[best.m[0]-best.n[0]*2.2,best.m[1]-best.n[1]*2.2]; if(inPoly(e2[0],e2[1],P)) eye=e2; look=[best.m[0]+best.n[0]*10,best.m[1]+best.n[1]*10]; }
  return {eye:[eye[0]-cx,eye[1]-cy], look:look?[look[0]-cx,look[1]-cy]:null, y:y0+1.55};
}
function viewFromUnit(t,f,u,face){
  var B=bandAt(t,f); if(!B) return; if(uCard) uCard.style.display='none'; uHi.visible=false;
  if(planOn) setPlan(false); fly=null;
  if(curT!==t) setTower(t);
  floorEl.value=f; setFloor(f); setMode('view');
  var T0=TOWERS[t], rm=buildRoom(t,f,B,u,face); T0.grp.updateMatrixWorld(true);
  unitEye=T0.grp.localToWorld(new THREE.Vector3(rm.eye[0],rm.y,rm.eye[1]));
  if(rm.look){ var lw=T0.grp.localToWorld(new THREE.Vector3(rm.look[0],rm.y,rm.look[1])); yaw=Math.atan2(lw.z-unitEye.z,lw.x-unitEye.x); } pitch=-.06;
  roomCam(); placeViewCam(); inUnit.u=u;
  mainLbl.textContent='Trong căn '+uCodeOf(t,f,u);
  hint.textContent='Kéo để nhìn quanh căn 360° · chạm vào sàn để đi tới chỗ đó'; hint.hidden=false; setTimeout(function(){ hint.hidden=true; },5000);
}
// 5D mặc định: căn có mặt kính hướng về phía biển (Đông) ở tòa đang chọn
function defaultUnit(t,f){ var B=bandAt(t,f); if(!B) return null; var best=null, bs=-9, T0=TOWERS[t], q=new THREE.Quaternion(); T0.grp.updateMatrixWorld(true); T0.grp.getWorldQuaternion(q);
  var others=['F1','F2','F3','F5'].filter(function(k){ return k!==t; }).map(function(k){ return TOWERS[k].grp.getWorldPosition(new THREE.Vector3()); }), v=new THREE.Vector3();
  function open(x){ for(var s=2;s<=160;s+=3){ var px=x.p[0]+x.d[0]*s, py=x.p[1]+x.d[1]*s; if(s<=90&&inPoly(px,py,B.foot)) return false; v.set(px-T0.cx,0,py-T0.cy); T0.grp.localToWorld(v); v.y=0;
      for(var k=0;k<others.length;k++) if(Math.hypot(v.x-others[k].x,v.z-others[k].z)<40) return false; } return true; }   // mặt kính không bị chính tòa này hay tòa bên cạnh che
  B.units.forEach(function(u){ faces(u,B).forEach(function(x){ if(!open(x)) return; var d=new THREE.Vector3(x.d[0],0,x.d[1]).applyQuaternion(q), s=d.x*.95-d.z*.3+(u.type==='2PN'?.08:0); if(s>bs){ bs=s; best={u:u,x:x}; } }); }); return best; }
bView.onclick=function(){ var f=nearBandFloor(curT,+floorEl.value), r=defaultUnit(curT,f); if(r) viewFromUnit(curT,f,r.u,r.x); };
var setFloor0=setFloor;
setFloor=function(f){ setFloor0(f); if(planOn){ hi.visible=false; updPlan(false); }
  if(inUnit&&mode==='view'&&inFloor!==f){ var r=inUnit, nf=nearBandFloor(r.t,f), B=bandAt(r.t,nf), u=B&&B.units.filter(function(q){ return q.code===r.code; })[0]; if(u&&nf===f) setTimeout(function(){ viewFromUnit(r.t,f,u); },0); } };

/* chạm 2 lần (hoặc bấm đúp) vào một điểm: bay sát tới điểm đó và lấy điểm đó làm tâm xoay */
__ZOOM__
function flyTop(){ var m=innerWidth<600;
  if(planOn) setPlan(false); if(mode==='view') setMode('overview');
  hi.visible=false; mainLbl.textContent='SUN FOURS';
  flyTo(FW.localToWorld(new THREE.Vector3(m?150:120,TOP+(m?190:135),m?170:140)),FW.localToWorld(new THREE.Vector3(0,TOP-14,0))); }
document.getElementById('mTop').onclick=flyTop;
function away(){ if(planOn) setPlan(false); if(mode==='view') setMode('overview'); hi.visible=false; controls.maxDistance=8000; mainLbl.textContent='SUN FOURS'; }
document.getElementById('mFours').onclick=function(){ away(); var m=innerWidth<600;
  flyTo(FW.localToWorld(new THREE.Vector3(m?-250:-200,m?330:250,m?250:210)),FW.localToWorld(new THREE.Vector3(0,25,0))); };
document.getElementById('mSL').onclick=function(){ away(); var m=innerWidth<600;
  flyTo(world.localToWorld(new THREE.Vector3(m?-1820:-1880,m?300:230,m?-1100:-1160)),world.localToWorld(new THREE.Vector3(-2155,45,-1337))); };   // S Light Tower (SL1, SL2)
document.getElementById('mSap').onclick=function(){ away(); var m=innerWidth<600;
  flyTo(world.localToWorld(new THREE.Vector3(m?-420:-340,m?260:190,m?-200:-150)),world.localToWorld(new THREE.Vector3(-40,50,46))); };   // Sun Saphia Residence (30 tầng, ven biển)
document.getElementById('mDrg').onclick=function(){ away(); hourEl.value=21; setTime(21);
  flyTo(world.localToWorld(new THREE.Vector3(-560,140,-4850)),world.localToWorld(new THREE.Vector3(-1000,25,-5300))); };   // tối, cầu Rồng phun lửa
document.getElementById('mSnd').onclick=function(){ setSnd(!sndOn); };
document.getElementById('mFw').onclick=function(){ setSnd(true); away(); hourEl.value=20; setTime(20);
  flyTo(world.localToWorld(new THREE.Vector3(-1820,330,-1450)),world.localToWorld(new THREE.Vector3(-1585,220,-2896))); };   // tối, pháo hoa DIFF bên sông Hàn
