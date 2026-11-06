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
  'body.pm .compass{display:none!important}'
  '@media (max-width:760px){body.pm .console{grid-template-columns:1fr!important;gap:6px!important;padding-top:8px!important;padding-bottom:8px!important}'
  'body.pm .modes{display:none!important}body.pm .console .sl label{font-size:10.5px!important}}')
OLD = "bPlan.onclick=function(){ setPlan(!planOn); };"
NEW = (TAG + "\nfunction pmFrame(){ if(!document.body.classList.contains('pm')||!planOn||mode==='view') return;\n"
  "  var f=+floorEl.value, y=planY(f), con=document.querySelector('.console'), ch=con?con.getBoundingClientRect().bottom:0, IH=innerHeight, H=Math.max(120,IH-ch-56), t=Math.tan(camera.fov*Math.PI/360), asp=innerWidth/IH, ext=60;\n"
  "  var d=Math.max(ext/(2*t)*(IH/H), ext/(2*t*asp))*1.04, Vh=2*d*t, s=((ch-56)/2)/IH*Vh;\n"
  "  var tg=new THREE.Vector3(X1-14.9+s,y,Z0+27.8), p=new THREE.Vector3(tg.x-d*0.02,y+d,tg.z);\n"
  "  flyTo(T.localToWorld(p),T.localToWorld(tg)); }\n"
  "bPlan.onclick=function(){ if(document.body.classList.contains('pm')){ if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,30); return; } setPlan(!planOn); };\n"
  "addEventListener('message',function(e){ var d=e.data; if(!d||!d.ss4dPlanMode) return; document.body.classList.add('pm'); if(mode==='view') setMode('overview'); if(!planOn) setPlan(true); setTimeout(pmFrame,60); });\n"
  "addEventListener('resize',function(){ setTimeout(pmFrame,120); });")
if TAG not in doc:
    k = doc.index('</style>'); doc = doc[:k] + CSS + doc[k:]
    assert doc.count(OLD) == 1
    doc = doc.replace(OLD, NEW)
    a = "f3Btn=document.createElement('button');"
    assert doc.count(a) == 1
    doc = doc.replace(a, a + " f3Btn.id='f3Btn';")
    src = src[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + src[j:]
    f.write_text(src, encoding='utf-8'); print('patched', f)
else:
    print('already patched', f)
