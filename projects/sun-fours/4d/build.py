"""Dựng sun-fours-4d.html: lấy nguyên khung mô hình Sun Saphia (commit 75ff1fe7) làm nền – giữ toàn bộ hiệu ứng
(nắng/bóng 4D, đêm, pháo hoa DIFF có tiếng, máy bay, du thuyền, dù lượn, tàu hàng, người đi dạo, cầu Rồng, cầu sông Hàn,
cầu Trần Thị Lý, tượng Quan Âm, tự xoay, chạm 2 lần bay sát) – chỉ đổi tâm về Sun FourS và đổi tòa chính thành 4 tòa FourS.
Chạy: python3 projects/sun-fours/4d/build.py  (sau đó build-embed.py để tạo bản nhúng website)."""
import json, math, pathlib, re, subprocess
H = pathlib.Path(__file__).parent
REPO = H.parents[2]
SS = '75ff1fe7b3d5e08d31b1e3a0ee247f1555a94a31'
src = subprocess.check_output(['git', '-C', str(REPO), 'show', SS + ':projects/sun-saphia/4d/sun-saphia-4d.html']).decode('utf-8')
L = src.split('\n')
def seg(a, b): return L[a-1:b]          # dòng a..b (đánh số từ 1, gồm cả b)
def rep(s, old, new, n=1):
    c = s.count(old)
    assert c == n, (old[:80], c)
    return s.replace(old, new)
CC_COMMIT = subprocess.check_output(['git', '-C', str(REPO), 'log', '-1', '--format=%H', '--', 'projects/fours/chon-can']).decode().strip()
CC_URL = 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/' + CC_COMMIT + '/projects/fours/chon-can/chon-can.html'

# --- tâm FourS theo đúng hàm W(lat,lon) của bản Saphia ---
LAT0, LON0, OX, OZ, TH, DX = 16.0213, 108.257659, 26.888, -33.847, 0.427, -9
KX = 111320 * math.cos(math.radians(LAT0)); KZ = 110574
def W(lat, lon):
    sx = (lon - LON0) * KX - OX; sz = -(lat - LAT0) * KZ - OZ; c, s = math.cos(TH), math.sin(TH)
    return (sx * c - sz * s + DX, sx * s + sz * c)
FC = W(16.009588, 108.242570)
# vị trí nhãn 2 trục đường qua dự án: điểm trên tim đường cách tâm ~190 m (theo OpenStreetMap)
osm = json.load(open(REPO / 'projects/sun-fours/osm/sf-osm-roads.json'))['elements']
N = {e['id']: (e['lat'], e['lon']) for e in osm if e['type'] == 'node'}
def road_pt(name, want=190, side=None):
    best = None
    for w in osm:
        if w['type'] != 'way' or w.get('tags', {}).get('name') != name: continue
        for n in w['nodes']:
            if n not in N: continue
            p = W(*N[n]); d = math.hypot(p[0]-FC[0], p[1]-FC[1]); sc = abs(d - want)
            if side and not side(p): continue
            if best is None or sc < best[0]: best = (sc, p)
    return best[1]
pMM = road_pt('Đường Minh Mạng', side=lambda p: p[1] < FC[1])
pNPL = road_pt('Đường Quảng Nam', side=lambda p: p[0] < FC[0])

# --- 1. đầu trang, giao diện ---
head = '\n'.join(seg(1, 145))
head = rep(head, '<title>Sun Saphia 3D · 4D · 5D</title>', '<title>Sun FourS Tower 3D · 4D · 5D</title>')
head = rep(head, '<b class="srb">SR</b>', '<b class="srb">FS</b>')
head = rep(head, '<h1><span>Sun Saphia</span> Residence</h1>', '<h1><span>Sun FourS</span> Tower</h1>')
head = rep(head, '<p>30 tầng · ~114 m · 782 căn · góc Trường Sa – Nguyễn Đức Thuận</p>', '<p>4 tòa F1 · F2 · F3 · F5 · 20 tầng · góc Minh Mạng – Nguyễn Phước Lan</p>')
head = rep(head, 'Kéo để nhìn quanh 360° · quay lưng ra biển là hướng TP, sông Hàn, sân bay', 'Kéo để nhìn quanh 360°')
head = rep(head, '<button class="chip" id="mSL" aria-pressed="false">S Light</button>',
           '<button class="chip" id="mSL" aria-pressed="false">S Light</button>\n    <button class="chip" id="mSap" aria-pressed="false">Sun Saphia</button>')
head = rep(head, '<button class="chip" id="sA" hidden aria-pressed="true" title="Theo phối cảnh nhìn từ trên cao">Phối cảnh A</button>\n    <button class="chip" id="sB" hidden aria-pressed="false" title="Theo phối cảnh mặt đứng trắng">Phối cảnh B</button>\n',
           '<button class="chip" id="sA" hidden></button><button class="chip" id="sB" hidden></button>\n')
head = rep(head, '  </div>\n  <div class="sl">\n    <label for="hour">',
           '  </div>\n  <div class="modes" id="twRow" role="group" aria-label="Chọn tòa" hidden>\n'
           '    <button class="chip" data-t="F1" aria-pressed="false">Tòa F1</button>\n    <button class="chip" data-t="F2" aria-pressed="true">Tòa F2</button>\n'
           '    <button class="chip" data-t="F5" aria-pressed="false">Tòa F5</button>\n    <button class="chip" data-t="F3" aria-pressed="false" disabled title="Chưa có bản vẽ CĐT">Tòa F3 (chờ bản vẽ)</button>\n'
           '  </div>\n  <div class="sl">\n    <label for="hour">')
head = rep(head, '<input id="floor" type="range" min="2" max="30" step="1" value="22">', '<input id="floor" type="range" min="1" max="19" step="1" value="12">')
head = rep(head, '<output id="floorOut" for="floor">Tầng 22</output>', '<output id="floorOut" for="floor">Tầng 12</output>')
head = re.sub(r'<p class="note">.*?</p>', '<p class="note"><b>Chạm 2 lần vào chỗ muốn xem để bay sát tới.</b> Mô hình dựng lại theo mặt bằng tầng, phối cảnh của chủ đầu tư và bản đồ để minh họa vị trí, hướng nắng và tầm nhìn: minh họa, thông số theo CĐT. Công trình xung quanh và tầm nhìn chỉ là ước lượng.</p>', head, count=1, flags=re.S)
head += '\n<style>.chip:disabled{opacity:.45;cursor:not-allowed}#twRow{grid-column:1/-1}#twRow[hidden]{display:none}</style>'

gate = '\n'.join(seg(146, 205))
gate = rep(gate, "<div class=\"lg\">SR</div><h3>Link riêng Sun Saphia Residence</h3>", "<div class=\"lg\">FS</div><h3>Link riêng Sun FourS Tower</h3>")

osm_js = (REPO / 'projects/sun-fours/osm/sf-osm-scene.js').read_text(encoding='utf-8').split('\n', 1)[1].strip()
plans_js = (REPO / 'projects/fours/plans/plans-data.js').read_text(encoding='utf-8')
stock_js = (REPO / 'landing-pages/assets/fourstower/data/stock.js').read_text(encoding='utf-8')
data = ('<script>/*OSM-DATA*/' + osm_js + '/*/OSM-DATA*/</script>\n<script>\n' + plans_js + '\n' + stock_js + '\n</script>')

# --- 2. khung cảnh (giữ nguyên) ---
core = '\n'.join(seg(207, 524))

# --- 3. 4 tòa FourS (thay khối FourS đơn giản cũ) ---
fs = (REPO / 'projects/fours/4d/scene.js').read_text(encoding='utf-8').split('\n')
i0 = next(i for i, s in enumerate(fs) if s.startswith('/* ---------- Vật liệu mặt dựng'))
i1 = next(i for i, s in enumerate(fs) if s.startswith('var T=F2.grp;'))
towers_src = '\n'.join(fs[i0:i1])
towers_src = rep(towers_src, 'grp.rotation.y=rotY||0; world.add(grp);', 'grp.rotation.y=rotY||0; FW.add(grp);')
towers = (H / 'src/fours-towers.js').read_text(encoding='utf-8').replace('__FCX__', '%.2f' % FC[0]).replace('__FCZ__', '%.2f' % FC[1]).replace('__TOWERS__', towers_src)

# --- 4. Sun Saphia: giữ nguyên khối tháp (thành tòa lân cận), đổi tên biến để không trùng với FourS ---
sap = '\n'.join(seg(531, 681))
sap = re.sub(r'\bT\b(?=[.,)])|\bT(?==new)', 'SAP', sap)
sap = re.sub(r'\bFL\b', 'SFL', sap); sap = re.sub(r'\bTOP\b', 'STOP', sap); sap = re.sub(r'\bNF\b', 'SNF', sap)
sap = rep(sap, 'var SAP=new THREE.Group();', 'var SAP=new THREE.Group();')
assert '\nvar T=' not in sap and 'T.add' not in sap
sap += '''
// đánh dấu tầng đang chọn trên tòa FourS đang xem
var hiMat=new THREE.MeshStandardMaterial({color:0xff6a2b,emissive:0xff6a2b,emissiveIntensity:.55,polygonOffset:true,polygonOffsetFactor:-2,polygonOffsetUnits:-2});
var hi=new THREE.Mesh(new THREE.BufferGeometry(),hiMat), curF=12, SCH='A';
function fitHi(){ var t=(typeof curT!=='undefined'&&curT)||'F2', T0=TOWERS[t], P=(T0.PT!==T0.P&&curF>=FI('16'))?T0.PT:T0.P;
  var g=new THREE.ExtrudeGeometry(ring(P,.6,T0.cx,T0.cy,.7,.3),{depth:3.1,bevelEnabled:false,curveSegments:6}); g.rotateX(-Math.PI/2); hi.geometry.dispose(); hi.geometry=g; if(hi.parent!==T0.grp) T0.grp.add(hi); }
fitHi();
function setScheme(){}
var B={visible:false};
'''

# --- 5. hiệu ứng, nhãn, giờ trong ngày, chế độ xem (giữ nguyên, sửa phần gắn với tòa chính) ---
mid = '\n'.join(seg(690, 1104))
mid = rep(mid, "var mainLbl=label('SUN SAPHIA','main',T,[0,TOP+18,0]);", "var mainLbl=label('SUN FOURS','main',T,[0,TOP+16,0]);")
for s in ["label('Khu đất dự án · 3.720,1 m²','',world,[-50,3,64]); label('Khu thấp tầng & hồ cảnh quan (phối cảnh minh họa)','',world,[66,14,-430]); ",
          "label('Dải đất resort ven biển (đang điều chỉnh quy hoạch)','',world,[62,10,-60]);\n",
          "label('Hồ bơi phía trước (theo phối cảnh)','',world,[66,8,8]);\n",
          "label('Công viên biển Trường Sa (quy hoạch) · cuối Minh Mạng','',world,[64,10,353]);\n",
          "label('Sun FourS Tower · 4 tòa 20 tầng','far',world,[-2053,96,527]);\n"]:
    mid = rep(mid, s, '')
mid = rep(mid, "label('S Light Tower · 2 tòa 22 tầng','far',world,[-2155,100,-1337]);",
          "label('S Light Tower · 2 tòa 22 tầng','far',world,[-2155,100,-1337]);\nlabel('Sun Saphia Residence · 30 tầng','far',world,[-47,STOP+12,39]);\n"
          "label('Minh Mạng','road',world,[%.0f,3,%.0f]);\nlabel('Nguyễn Phước Lan','road',world,[%.0f,3,%.0f]);" % (pMM[0], pMM[1], pNPL[0], pNPL[1]))
mid = rep(mid, "function FN(f){ return f===4?'3A':String(f); }   // tầng 3A thay cho tầng 4 (theo bản vẽ CĐT)\n", '')
mid = rep(mid, "function setFloor(f){ curF=f; fitHi(); hi.position.y=FL[f]-.2; floorOut.textContent='Tầng '+FN(f); mainLbl.textContent='SUN SAPHIA';",
          "function setFloor(f){ curF=f; fitHi(); hi.position.y=FL[f]-.2; floorOut.textContent='Tầng '+FN(f); mainLbl.textContent='SUN FOURS';")
a = mid.index('function placeViewCam(){'); b = mid.index('var bClose=')
mid = mid[:a] + '''function placeViewCam(){ if(!unitEye) return; camera.position.copy(unitEye);   // đứng trong căn: nhìn theo hướng kéo
  var d=new THREE.Vector3(Math.cos(yaw)*Math.cos(pitch),Math.sin(pitch),Math.sin(yaw)*Math.cos(pitch)); camera.lookAt(camera.position.clone().add(d)); }
''' + mid[b:]
mid = rep(mid, "  if(m==='view') hint.textContent='Kéo để nhìn quanh 360° · quay lưng ra biển là hướng TP, sông Hàn, sân bay';", "  if(m==='view') hint.textContent='Kéo để nhìn quanh 360°';")
a = mid.index('function flyClose(){'); b = mid.index(' bView.onclick=function(){setMode(\'view\');};')
mid = mid[:a] + "function flyClose(){ var f=+floorEl.value, m=innerWidth<600, T0=TOWERS[(typeof curT!=='undefined'&&curT)||'F2']; T0.grp.updateMatrixWorld(true); flyTo(T0.grp.localToWorld(new THREE.Vector3(m?-40:-25,FL[f]+(m?40:26),-(T0.D/2+(m?125:90)))),T0.grp.localToWorld(new THREE.Vector3(0,FL[f],0))); }" + mid[b:]
# xe chạy cả trên các trục quanh FourS (Minh Mạng, Nguyễn Phước Lan, 29/3, Nguyễn Đình Thi), bật đèn pha buổi tối
mid = rep(mid, '/* người đi dạo trên bãi biển', '''var cars2=[], car2M=null, car2F=null, car2R=null;
(function(){ var P=ROADS2.map(function(R){ var c=[0]; for(var i=2;i<R.length;i+=2) c.push(c[c.length-1]+Math.hypot(R[i]-R[i-2],R[i+1]-R[i-1])); return {R:R,c:c,len:c[c.length-1]}; }).filter(function(p){ return p.len>120; });
  if(!P.length) return; var n=90, cols=[0xf2f2f2,0xd9d9d9,0x2b2f36,0x9aa3ad,0xb23a2e,0x2f5c8a];
  car2M=new THREE.InstancedMesh(new THREE.BoxGeometry(2,1.5,4.6),M(0xffffff,{roughness:.35,metalness:.4,envMapIntensity:.8}),n);
  car2F=new THREE.InstancedMesh(new THREE.BoxGeometry(1.7,.35,.15),new THREE.MeshBasicMaterial({color:0xfff6dc,transparent:true,opacity:0}),n);
  car2R=new THREE.InstancedMesh(new THREE.BoxGeometry(1.7,.3,.15),new THREE.MeshBasicMaterial({color:0xff2a1a,transparent:true,opacity:0}),n);
  var tot=P.reduce(function(a,p){ return a+p.len; },0);
  for(var i=0;i<n;i++){ var r=srnd()*tot, k=0; while(r>P[k].len&&k<P.length-1){ r-=P[k].len; k++; } cars2.push({p:P[k],s:Math.min(r,P[k].len),v:rnd(8,13)*(srnd()<.5?-1:1),j:0}); car2M.setColorAt(i,cc.set(cols[i%cols.length])); }
  car2M.castShadow=true; world.add(car2M); world.add(car2F); world.add(car2R); })();
var _c2=new THREE.Matrix4(), _c2o=new THREE.Matrix4();
function updateCars2(dt){ if(!car2M) return; car2F.material.opacity=car2R.material.opacity=curNight;
  cars2.forEach(function(c,i){ var p=c.p; c.s+=c.v*dt; if(c.s>p.len) c.s-=p.len; if(c.s<0) c.s+=p.len;
    var j=c.j; while(j<p.c.length-2&&p.c[j+1]<c.s) j++; while(j>0&&p.c[j]>c.s) j--; c.j=j;
    var R=p.R, x0=R[j*2], z0=R[j*2+1], x1=R[j*2+2], z1=R[j*2+3], L=(p.c[j+1]-p.c[j])||1, t=(c.s-p.c[j])/L, ux=(x1-x0)/L, uz=(z1-z0)/L, sg=c.v>0?1:-1;
    dm.position.set(x0+(x1-x0)*t-uz*3.2*sg,.85,z0+(z1-z0)*t+ux*3.2*sg); dm.rotation.set(0,Math.atan2(ux*sg,uz*sg),0); dm.scale.set(1,1,1); dm.updateMatrix(); car2M.setMatrixAt(i,dm.matrix);
    _c2o.makeTranslation(0,-.1,2.35); _c2.multiplyMatrices(dm.matrix,_c2o); car2F.setMatrixAt(i,_c2); _c2o.makeTranslation(0,0,-2.35); _c2.multiplyMatrices(dm.matrix,_c2o); car2R.setMatrixAt(i,_c2); });
  car2M.instanceMatrix.needsUpdate=car2F.instanceMatrix.needsUpdate=car2R.instanceMatrix.needsUpdate=true; }

/* người đi dạo trên bãi biển''')

# --- 6. mặt bằng tầng, thẻ căn, 5D trong căn, các nút bay tới (viết mới cho FourS) ---
zoom = '\n'.join(seg(1180, 1194))
plan = (H / 'src/fours-plan.js').read_text(encoding='utf-8').replace('__CC_URL__', CC_URL).replace('__ZOOM__', zoom)

# --- 7. góc nhìn đầu, chữ chìm, vòng lặp ---
tail = '\n'.join(seg(1389, 1487))
a = tail.index('/* ---------- Initial camera ---------- */'); b = tail.index('/* ---------- Brand watermark')
tail = tail[:a] + '''/* ---------- Đổi tâm: dời cả bản đồ để tâm Sun FourS (giao lộ Minh Mạng – Nguyễn Phước Lan) nằm ở gốc cảnh ---------- */
(function(){ scene.updateMatrixWorld(true); var C=FW.getWorldPosition(new THREE.Vector3()); C.y=0;
  scene.children.slice().forEach(function(o){ if(o===sky||o===ground||o.isLight||o===sun.target) return; o.position.sub(C); });
  LBL.forEach(function(L){ if(L.obj===scene) L.p.sub(C); }); scene.updateMatrixWorld(true); FW.getWorldPosition(towerWorld); })();
/* ---------- Góc nhìn ban đầu: cụm 4 tòa FourS, nhìn về phía biển ---------- */
var mob=innerWidth<600;
controls.target.copy(FW.localToWorld(new THREE.Vector3(0,mob?40:30,0)));
camera.position.copy(world.localToWorld(new THREE.Vector3(FC[0]-(mob?560:430),mob?330:240,FC[1]+(mob?220:170))));
controls.update(); DEF={p:camera.position.clone(),t:controls.target.clone()};
var hQ=/[?&]h=([\\d.]+)/.exec(location.search); if(hQ) hourEl.value=hQ[1];
var fQ=/[?&]f=([0-9A]+)/i.exec(location.search); if(fQ){ var fi=FI(fQ[1].toUpperCase()); floorEl.value=fi>0?fi:Math.max(1,Math.min(19,+fQ[1]||12)); }
var tQ=/[?&]t=(F[1235])/i.exec(location.search); if(tQ&&TOWERS[tQ[1].toUpperCase()]&&tQ[1].toUpperCase()!=='F3') setTower(tQ[1].toUpperCase());
setFloor(+floorEl.value); setTime(+hourEl.value); refreshEnv();
if(/[?&]plan/.test(location.search)) setTimeout(function(){ setPlan(true); },400);
if(/[?&]top/.test(location.search)) setTimeout(flyTop,400);
// mở thẳng bên trong 1 căn: &in=03&t=F2&f=12
(function(){ var m=/[?&]in=([0-9A-Za-z]+)/.exec(location.search); if(!m) return; var f=nearBandFloor(curT,+floorEl.value), B=bandAt(curT,f), u=B&&B.units.filter(function(x){ return x.code===m[1].toUpperCase(); })[0];
  if(u) setTimeout(function(){ viewFromUnit(curT,f,u); },600); })();
window.FS4D={go:function(t,f,code){ setTower(t); floorEl.value=f; setFloor(f); var B=bandAt(t,f), u=B&&B.units.filter(function(x){ return x.code===code; })[0]; if(u) viewFromUnit(t,f,u); }, turn:function(d){ yaw+=d; placeViewCam(); }, plan:setPlan, tower:setTower, fly:flyTo, TOWERS:TOWERS, FL:FL, band:bandAt, labelPt:labelPt, skip:function(){ if(fly){ camera.position.copy(fly.p1); controls.target.copy(fly.t1); fly=null; controls.update(); } }, FW:FW, world:world, camera:camera, controls:controls};
var camQ=/cam=([-\\d.]+),([-\\d.]+),([-\\d.]+)/.exec(location.search); if(camQ){ controls.target.copy(FW.localToWorld(new THREE.Vector3(0,40,0))); camera.position.copy(FW.localToWorld(new THREE.Vector3(+camQ[1],+camQ[2],+camQ[3]))); var tg=/tgt=([-\\d.]+),([-\\d.]+),([-\\d.]+)/.exec(location.search); if(tg) controls.target.copy(FW.localToWorld(new THREE.Vector3(+tg[1],+tg[2],+tg[3]))); controls.update(); }

''' + tail[b:]
tail = rep(tail, "var WEB='sun-saphia-residence.com';", "var WEB='sun-fours-tower.com';")
tail = rep(tail, "g.fillText('Hoàng Hiệp · Sun Saphia Residence',238,166);", "g.fillText('Hoàng Hiệp · Sun FourS Tower',238,166);")
a = tail.index('if(true){ wm.visible=false;'); b = tail.index('// rooftop signage')
mins = {}
for r in json.loads(re.search(r'units: (\[.*?\])\}', stock_js, re.S).group(1)):
    k = {'STU': 'Studio', '1BR': '1PN', '1BR+': '1PN+', '2BR': '2PN'}.get(r[1], r[1]); mins[k] = min(mins.get(k, 9e12), r[3])
upd = re.search(r'updated: "([^"]+)"', stock_js).group(1)
hl = ' · '.join('%s từ %s tỷ' % (k, ('%.2f' % (mins[k] / 1e9)).replace('.', ',')) for k in ('Studio', '1PN+', '2PN') if k in mins)
tail = tail[:a] + '''wm.visible=false;
if(CRM){   // bản CRM nội bộ: không số điện thoại / website; hiện giá tham khảo CĐT
  var ct=document.querySelector('.contact'); if(ct){ [].slice.call(ct.childNodes).forEach(function(n){ if(!(n.classList&&n.classList.contains('compass'))) ct.removeChild(n); });
    var hl=document.createElement('div'); hl.className='hl'; hl.innerHTML='<span>Giá tham khảo CĐT (gồm VAT + KPBT)</span><b>%s</b><i>*cập nhật %s · bấm căn trên mặt bằng để xem giá từng căn</i>';
    ct.insertBefore(hl,ct.firstChild);
    var hs=document.createElement('style'); hs.textContent='.contact .hl span{display:block;font-size:12px}.contact .hl b{display:block;font-size:14px;white-space:normal;max-width:46vw}.contact .hl i{display:block;font-size:10px;opacity:.7;font-style:normal}@media (max-width:760px){.contact .hl span,.contact .hl i{display:none}.contact .hl b{font-size:11.5px}}'; document.head.appendChild(hs); } }
''' % (hl, upd) + tail[b:]
tail = rep(tail, "g.fillText('SUN SAPHIA',270,92);", "g.fillText('SUN FOURS',270,92);")
tail = rep(tail, "g.fillText('RESIDENCE',272,190);", "g.fillText('TOWER',272,190);")
tail = rep(tail, 'updateCars(dt); updateBoats(', 'updateCars(dt); updateCars2(dt); updateBoats(')
tail = rep(tail, "v.set(ci&1?PX1:PX0, ci&2?TOP+4:0, ci&4?PZ1:PZ0-15); T.localToWorld(v);", "v.set(ci&1?105:-105, ci&2?TOP+4:0, ci&4?105:-105); FW.localToWorld(v);")
a = tail.index('    if(vis&&inRoom&&mode===\'view\'&&unitEye){'); b = tail.index('    if(vis){ var px=')
tail = tail[:a] + tail[b:]
a = tail.index("if(/closeMod/.test(location.search))"); b = tail.index('loop();')
tail = tail[:a] + "if(/closeMod/.test(location.search)) setMode('close');\n" + tail[b:]

out = '\n'.join([head, gate, data, core, towers, '', sap, mid, plan, tail])
out = out.replace('Sun Saphia 3D', 'Sun FourS 3D')
(H / 'sun-fours-4d.html').write_text(out, encoding='utf-8')
print('sun-fours-4d.html', len(out) // 1024, 'KB · FourS', [round(v, 1) for v in FC], 'MM', [round(v) for v in pMM], 'NPL', [round(v) for v in pNPL], '·', hl)
