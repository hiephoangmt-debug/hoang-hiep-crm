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
  'body.pm .compass{display:none!important}body.pm #uCard{top:auto!important;bottom:calc(env(safe-area-inset-bottom,0px) + 62px)!important}'
  '@media (max-width:760px){body.pm .console{grid-template-columns:1fr!important;gap:6px!important;padding-top:8px!important;padding-bottom:8px!important}'
  'body.pm .modes{display:none!important}body.pm .console .sl label{font-size:10.5px!important}}')
OLD = "bPlan.onclick=function(){ setPlan(!planOn); };"
NEW = (TAG + "\nfunction pmFly(cx,cz,ext){ if(!document.body.classList.contains('pm')||!planOn||mode==='view') return;\n"
  "  var y=planY(+floorEl.value), con=document.querySelector('.console'), ch=con?con.getBoundingClientRect().bottom:0, IH=innerHeight, H=Math.max(120,IH-ch-56), t=Math.tan(camera.fov*Math.PI/360), asp=innerWidth/IH;\n"
  "  var d=Math.max(ext/(2*t)*(IH/H), ext/(2*t*asp))*1.04, Vh=2*d*t, s=(ch/2)/IH*Vh;\n"
  "  var tg=new THREE.Vector3(cx+s,y,cz), p=new THREE.Vector3(tg.x-d*0.02,y+d,tg.z);\n"
  "  flyTo(T.localToWorld(p),T.localToWorld(tg)); }\n"
  "function pmFrame(){ pmFly(X1-14.9,Z0+27.8,60); }\n"
  "var showUnitPm0=showUnit; showUnit=function(r){ showUnitPm0(r); if(!document.body.classList.contains('pm')||!uCard) return;\n"
  "  var uf=uFloor(), AR=uf>=30?UA30[r[0]]:(uf===2&&UA2[r[0]])||UAREA[r[0]], inf=UINFO[r[1]]||['',''], vw=UVIEW[r[6]]||[''], code=uCode(r);\n"
  "  var bx=uCard.querySelector('.b'); if(bx) bx.innerHTML='<button class=\\'o\\' data-a=\\'all\\'>← Cả tầng</button><button class=\\'n\\' data-a=\\'lead\\'>Nhận giá căn này</button>';\n"
  "  function back(){ uCard.style.display='none'; uHi.visible=false; pmFrame(); }\n"
  "  uCard.querySelector('.x').onclick=back; var ba=uCard.querySelector('[data-a=all]'); if(ba) ba.onclick=back;\n"
  "  var info={code:code,type:inf[0],area:AR?um2(AR[0]):'',view:vw[0],floor:FN(uf)}; var bl=uCard.querySelector('[data-a=lead]'); if(bl) bl.onclick=function(){ try{ parent.postMessage({ss4dUnit:info,lead:1},'*'); }catch(e){} };\n"
  "  pmFly(X1-(r[4]+r[5])/2, Z0+(r[2]+r[3])/2, Math.max(r[3]-r[2],r[5]-r[4])*1.7+6);\n"
  "  try{ parent.postMessage({ss4dUnit:info},'*'); }catch(e){} };\n"
  "bPlan.onclick=function(){ if(document.body.classList.contains('pm')){ if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,30); return; } setPlan(!planOn); };\n"
  "addEventListener('message',function(e){ var d=e.data; if(!d||!d.ss4dPlanMode) return; if(!document.body.classList.contains('pm')){ hourEl.max='23.5'; var lb=document.querySelector('label[for=hour]'); if(lb) lb.textContent='Giờ · ngày → đêm'; } document.body.classList.add('pm'); if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,60); });\n"
  "addEventListener('resize',function(){ setTimeout(pmFrame,120); });")
if TAG not in doc:
    k = doc.index('</style>'); doc = doc[:k] + CSS + doc[k:]
    assert doc.count(OLD) == 1
    doc = doc.replace(OLD, NEW)
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
