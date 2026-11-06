"""Chế độ "mặt bằng" cho khối Mặt bằng trên website: trang mẹ gửi postMessage({ss4dPlanMode:1}) vào iframe 4D →
- ẩn tiêu đề và gần hết nút chế độ, thanh Tầng + Giờ trong ngày đưa lên trên cùng (chỉ giữ nút "Mặt bằng tầng" để quay lại);
- mặt bằng tầng nằm chính giữa phần khung còn trống (camera nhìn thẳng từ trên xuống, tự tính khoảng cách cho vừa);
- nút "Bản vẽ CĐT tầng này" xuống đáy khung, ẩn nút "3D cả tầng" (mở công cụ chọn căn cũ).
Các nơi khác dùng 4D (không gửi lệnh) giữ nguyên. Chạy lại an toàn: python3 plan_mode.py [sun-saphia-4d-embed.js]"""
import json, pathlib, sys
f = pathlib.Path(sys.argv[1] if len(sys.argv) > 1 else pathlib.Path(__file__).parent / 'sun-saphia-4d-embed.js')
src = f.read_text(encoding='utf-8')
i = src.index('var DOC = ') + len('var DOC = ')
doc, n = json.JSONDecoder().raw_decode(src[i:])
j = i + n
TAG = '/*ss-plan-mode*/'
CSS = TAG + ('body.pm .top{display:none!important}'
  'body.pm .console{top:0!important;bottom:auto!important;border-top:0!important;border-bottom:1px solid var(--line);'
  'grid-template-columns:auto 1fr 1fr!important;gap:8px 22px!important;padding-top:10px!important;padding-bottom:10px!important}'
  'body.pm .modes{grid-column:auto!important;flex-wrap:nowrap!important}body.pm .modes .chip{display:none!important}body.pm .modes #mPlan{display:inline-block!important}'
  'body.pm .note,body.pm #spinRow{display:none!important}body.pm .console .sl:has(#floor){order:-1}body.pm .modes{order:-2}'
  'body.pm #f3Btn{display:none!important}body.pm #ofcBtn{bottom:calc(env(safe-area-inset-bottom,0px) + 14px)!important}'
  'body.pm .compass{display:none!important}body.pm #uCard{top:auto!important;bottom:calc(env(safe-area-inset-bottom,0px) + 12px)!important;left:12px!important;right:auto!important;transform:none!important;width:min(320px,calc(100% - 24px))!important;padding:10px 12px!important;opacity:.97}body.pm #uCard h4{font-size:15px!important;margin:0 0 4px!important}body.pm #uCard .s{font-size:12.5px!important;line-height:1.4!important}body.pm #uCard .b button{padding:8px 10px!important;font-size:13px!important}body.pm.pu #ofcBtn{display:none!important}'
  'body.pm.pu #uCard{left:10px!important;right:84px!important;width:auto!important;bottom:calc(env(safe-area-inset-bottom,0px) + 10px)!important;background:transparent!important;box-shadow:none!important;border:0!important;padding:0!important;display:block!important;opacity:1}'
  '.pmc{position:relative;display:grid;grid-template-columns:auto 1fr auto;gap:14px;align-items:center;padding:12px 44px 12px 14px;border-radius:16px;color:#fff;background:linear-gradient(120deg,#0B1A3A 0%,#13285A 60%,#1F3F82 100%);box-shadow:0 14px 34px rgba(5,12,28,.45),inset 0 0 0 1px rgba(255,160,74,.35);animation:pmcIn .45s cubic-bezier(.2,.9,.3,1.15) both;overflow:hidden}'
  '.pmc:before{content:"";position:absolute;inset:0;background:linear-gradient(100deg,transparent 30%,rgba(255,255,255,.10) 45%,transparent 60%);transform:translateX(-100%);animation:pmcSh 3.2s ease-in-out 1s infinite;pointer-events:none}'
  '@keyframes pmcIn{from{opacity:0;transform:translateY(24px) scale(.98)}to{opacity:1;transform:none}}@keyframes pmcSh{0%{transform:translateX(-100%)}60%,100%{transform:translateX(100%)}}'
  '.pmc-id{padding-right:14px;border-right:1px solid rgba(255,255,255,.15)}.pmc-id small{display:block;font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:#FFB067}.pmc-id b{display:block;font-size:24px;line-height:1.1;font-weight:800;letter-spacing:.02em}.pmc-id span{display:block;font-size:12.5px;color:#C9D6EA;margin-top:2px}'
  '.pmc-st{display:flex;gap:8px;flex-wrap:wrap;min-width:0}.pmc-st div{display:flex;align-items:center;gap:7px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:12px;padding:6px 10px;animation:pmcIn .5s both}.pmc-st div:nth-child(2){animation-delay:.06s}.pmc-st div:nth-child(3){animation-delay:.12s}.pmc-st div:nth-child(4){animation-delay:.18s}.pmc-st div:nth-child(5){animation-delay:.24s}'
  '.pmc-st i{font-style:normal;font-size:17px}.pmc-st b{display:block;font-size:14px;font-weight:800;line-height:1.15}.pmc-st small{display:block;font-size:10.5px;color:#AFC0D8}'
  '.pmc-b{display:flex;gap:8px;align-items:center}.pmc-b button{border:0;border-radius:999px;font:800 14px inherit;cursor:pointer;white-space:nowrap}.pmc-cta{background:linear-gradient(135deg,#FFA04A,#F07B1F);color:#fff;padding:11px 18px;animation:pmcP 1.8s infinite}.pmc-back{background:transparent;color:#fff;border:1px solid rgba(255,255,255,.35)!important;padding:10px 14px}'
  '@keyframes pmcP{0%{box-shadow:0 0 0 0 rgba(255,160,74,.7)}70%{box-shadow:0 0 0 12px rgba(255,160,74,0)}100%{box-shadow:0 0 0 0 rgba(255,160,74,0)}}'
  '.pmc-x{position:absolute;top:8px;right:10px;width:28px;height:28px;border-radius:50%;border:0;background:rgba(255,255,255,.12);color:#fff;font-size:15px;cursor:pointer}'
  '@media (max-width:760px){body.pm.pu #uCard{left:8px!important;right:64px!important}.pmc{grid-template-columns:1fr auto;gap:8px;padding:9px 38px 9px 11px}.pmc-id{border:0;padding:0}.pmc-id b{font-size:19px}.pmc-st{grid-column:1/-1;grid-row:2;flex-wrap:nowrap;overflow-x:auto;scrollbar-width:none}.pmc-st::-webkit-scrollbar{display:none}.pmc-st div{flex:0 0 auto;padding:5px 8px}.pmc-st b{font-size:12.5px}.pmc-b{grid-column:2;grid-row:1}.pmc-back{display:none}.pmc-cta{padding:9px 13px;font-size:13px}}'
  '@media (max-width:760px){body.pm .console{grid-template-columns:1fr!important;gap:6px!important;padding-top:8px!important;padding-bottom:8px!important}'
  'body.pm .modes{display:none!important}body.pm .console .sl label{font-size:10.5px!important}}')
OLD = "bPlan.onclick=function(){ setPlan(!planOn); };"
NEW = (TAG + "\nfunction pmFly(cx,cz,ext){ if(!document.body.classList.contains('pm')||!planOn||mode==='view') return;\n"
  "  var y=planY(+floorEl.value), con=document.querySelector('.console'), ch=con?con.getBoundingClientRect().bottom:0, IH=innerHeight, H=Math.max(120,IH-ch-56), t=Math.tan(camera.fov*Math.PI/360), asp=innerWidth/IH;\n"
  "  var d=Math.max(ext/(2*t)*(IH/H), ext/(2*t*asp))*1.04, Vh=2*d*t, s=(ch/2)/IH*Vh;\n"
  "  var tg=new THREE.Vector3(cx+s,y,cz), p=new THREE.Vector3(tg.x-d*0.02,y+d,tg.z);\n"
  "  flyTo(T.localToWorld(p),T.localToWorld(tg)); }\n"
  "function pmFrame(){ if(camera.fov!==42){ camera.fov=42; camera.updateProjectionMatrix(); } pmFly(X1-14.9,Z0+27.8,60); }\n"
  "function pmUnit(r){ var y=planY(+floorEl.value), yaw=(UVIEW[r[6]]||[0,0])[1], dx=Math.cos(yaw), dz=Math.sin(yaw), cx=X1-(r[4]+r[5])/2, cz=Z0+(r[2]+r[3])/2, m=innerWidth<600;\n"
  "  camera.fov=m?70:58; camera.updateProjectionMatrix(); document.body.classList.add('pu');\n"
  "  var con=document.querySelector('.console'); document.body.style.setProperty('--uct',((con?con.getBoundingClientRect().bottom:56)+8)+'px');\n"
  "  /* chia khung 6 phần: view 3/6 trên (chân trời ~40%), mặt bằng 2/6 (căn ở ~2/3 chiều cao), thông số 1/6 dưới */\n"
  "  controls.autoRotate=false; var t=Math.tan(camera.fov*Math.PI/360), a=Math.atan(.2*t), b=a+Math.atan(t/3), R=m?16:15, h=R*Math.tan(b);\n"
  "  var tg=new THREE.Vector3(cx,y+h-R*Math.tan(a),cz), p=new THREE.Vector3(cx-dx*R,y+h,cz-dz*R);\n"
  "  flyTo(T.localToWorld(p),T.localToWorld(tg)); }\n"
  "var showUnitPm0=showUnit; showUnit=function(r){ showUnitPm0(r); if(!document.body.classList.contains('pm')||!uCard) return;\n"
  "  var uf=uFloor(), AR=uf>=30?UA30[r[0]]:(uf===2&&UA2[r[0]])||UAREA[r[0]], inf=UINFO[r[1]]||['',''], vw=UVIEW[r[6]]||[''], code=uCode(r);\n"
  "  var bal=(uf===3||uf===2&&ONLY2.indexOf(r[0])>=0)&&UBAL3[r[0]], VI={E:'🌊',W:'🌆',N:'⛰️',S:'🏙️'}[r[6]]||'🧭';\n"
  "  function back(){ uCard.style.display='none'; uHi.visible=false; document.body.classList.remove('pu'); pmFrame(); }\n"
  "  uCard.innerHTML='<div class=pmc><button class=pmc-x aria-label=Đóng>✕</button><div class=pmc-id><small>Căn đang chọn</small><b>'+code+'</b><span>'+inf[0]+' · tầng '+FN(uf)+'</span></div><div class=pmc-st>'\n"
  "    +(AR?'<div><i>📐</i><span><b>'+um2(AR[0])+' m²</b><small>thông thủy</small></span></div><div><i>🧱</i><span><b>'+um2(AR[1])+' m²</b><small>tim tường</small></span></div>':'')\n"
  "    +(bal?'<div><i>🌿</i><span><b>'+um2(bal)+' m²</b><small>ban công</small></span></div>':'')\n"
  "    +'<div><i>'+VI+'</i><span><b>'+vw[0]+'</b><small>hướng view</small></span></div>'+(inf[1]?'<div><i>✨</i><span><b>'+inf[1]+'</b><small>đặc điểm</small></span></div>':'')\n"
  "    +'</div><div class=pmc-b><button class=pmc-back data-a=all>← Cả tầng</button><button class=pmc-cta data-a=lead>Nhận giá căn này →</button></div></div>';\n"
  "  uCard.querySelector('.pmc-x').onclick=back; uCard.querySelector('[data-a=all]').onclick=back;\n"
  "  var info={code:code,type:inf[0],area:AR?um2(AR[0]):'',view:vw[0],floor:FN(uf)}; uCard.querySelector('[data-a=lead]').onclick=function(){ try{ parent.postMessage({ss4dUnit:info,lead:1},'*'); }catch(e){} };\n"
  "  pmUnit(r);\n"
  "  try{ parent.postMessage({ss4dUnit:info},'*'); }catch(e){} };\n"
  "bPlan.onclick=function(){ if(document.body.classList.contains('pm')){ if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,30); return; } setPlan(!planOn); };\n"
  "addEventListener('message',function(e){ var d=e.data; if(!d||!d.ss4dPlanMode) return; if(!document.body.classList.contains('pm')){ hourEl.max='23.5'; var lb=document.querySelector('label[for=hour]'); if(lb) lb.textContent='Giờ · ngày → đêm'; } var first=!document.body.classList.contains('pm'); document.body.classList.add('pm'); if(first&&!playing) playBtn.click(); if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,60); });\n"
  "addEventListener('resize',function(){ setTimeout(pmFrame,120); });")
if TAG not in doc:
    k = doc.index('</style>'); doc = doc[:k] + CSS + doc[k:]
    assert doc.count(OLD) == 1
    doc = doc.replace(OLD, NEW)
    q = "var hv=+hourEl.value+0.02;"
    assert doc.count(q) == 1
    doc = doc.replace(q, "var hv=+hourEl.value+(document.body.classList.contains('pm')?0.012:0.02);")
    p = "if(hv>20) hv=5;"
    assert doc.count(p) == 1
    doc = doc.replace(p, "if(hv>+hourEl.max) hv=+hourEl.min;")
    a = "f3Btn=document.createElement('button');"
    assert doc.count(a) == 1
    doc = doc.replace(a, a + " f3Btn.id='f3Btn';")
    src = src[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + src[j:]
    for a, b in [("function arm(){ if(sentL()) return;", "function arm(){ if(sentL()||window.SS4D_NOGATE) return;"),
                 ("function gate(){ if(sentL()||gOn) return;", "function gate(){ if(sentL()||gOn||window.SS4D_NOGATE) return;")]:
        assert src.count(a) == 1, a
        src = src.replace(a, b)
    f.write_text(src, encoding='utf-8'); print('patched', f)
else:
    print('already patched', f)
