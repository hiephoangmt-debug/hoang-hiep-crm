"""Bản "chỉ mặt bằng" của công cụ chọn căn (lấy nguyên bản chon-can-embed.js ở một commit, ẩn 3D/nội thất,
giữ bộ lọc hướng view + loại căn + tầng và thông tin căn, thêm nút nhận giá căn → popup của trang).
Dùng: python3 build.py <sha commit chứa projects/sun-saphia/chon-can/chon-can-embed.js>"""
import json, pathlib, subprocess, sys
here = pathlib.Path(__file__).parent
sha = sys.argv[1]
src = subprocess.check_output(['git', 'show', sha + ':projects/sun-saphia/chon-can/chon-can-embed.js'], cwd=here).decode('utf-8')
css = ('.hd,#dl3d,#dl2d,#rc .note{display:none!important}'
       '.wrap{grid-template-columns:1fr!important;max-width:1060px;margin:0 auto;position:relative}'
       'body:not(.picked) #rc{display:none!important}'
       'body:not(.picked) #plan:not(.flt) svg .u{opacity:1!important}body:not(.picked) #plan .u.sel .b{stroke:#fff!important;stroke-width:2!important}'
       'body.picked #rc{position:absolute;left:0;right:0;margin:0 auto;width:min(900px,calc(100%% - 16px));z-index:60;box-shadow:0 24px 70px rgba(10,37,64,.45);border-radius:16px;animation:ssIn .35s ease}'
       '@keyframes ssIn{from{opacity:0;transform:translateY(16px) scale(.98)}to{opacity:1;transform:none}}'
       '#ssBg{display:none;position:absolute;left:0;top:0;width:100%%;z-index:55;background:rgba(10,37,64,.55);backdrop-filter:blur(2px)}body.picked #ssBg{display:block}'
       '#ssX{position:absolute;top:8px;right:8px;z-index:5;width:38px;height:38px;border-radius:50%%;border:0;background:#0A2540;color:#fff;font:700 22px/38px var(--font);cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,.25)}'
       '#rc #info{padding-right:52px}'
       '#ssLead{display:block;width:100%%;border:0;border-radius:12px;background:linear-gradient(135deg,#FF8A3D,#E8460F);color:#fff;font:800 16px var(--font);padding:14px;cursor:pointer;box-shadow:0 8px 18px rgba(232,70,15,.3)}'
       '#ssHint{max-width:1060px;margin:10px auto 0;padding:12px 16px;background:#fff3e8;border:1.5px solid #ffd2b3;border-radius:12px;color:#0A2540;font-size:14.5px;line-height:1.5;text-align:center}'
       '@media(max-width:820px){#ssHint{margin:10px 12px 0}body.picked #rc{width:calc(100%% - 12px)}}') % ()
js = r'''(function(){
  function H(){ try{ parent.postMessage({sscc:'h2',h:Math.ceil(document.documentElement.scrollHeight)},'*'); }catch(e){} }
  setInterval(H,700); addEventListener('load',H); addEventListener('resize',H);
  function code(){ var i=document.getElementById('info'); var m=i&&/SP\d{3,4}[A-Z]?/.exec(i.textContent||''); return m?m[0]:''; }
  function typ(){ var i=document.getElementById('info'), t=(i&&i.textContent)||''; return /2PN/.test(t)?'2PN':/1PN\+1/.test(t)?'1PN+1':/1BR/.test(t)?'1BR':'Studio'; }
  function hint(){ var w=document.querySelector('.wrap'); if(!w||document.getElementById('ssHint')) return; var h=document.createElement('div'); h.id='ssHint';
    h.innerHTML='👆 <b>Chọn tầng, chọn hướng rồi bấm vào một căn</b> để xem mặt bằng căn, hình 3D, view và nhận giá căn đó.'; w.parentNode.insertBefore(h,w); }
  function lead(){ var b=document.querySelector('#rc .btns'); if(!b) return; var c=code(); var l=document.getElementById('ssLead');
    if(!l){ l=document.createElement('button'); l.type='button'; l.id='ssLead'; b.insertBefore(l,b.firstChild);
      l.onclick=function(){ var f=document.getElementById('floor'); try{ parent.postMessage({sscc:'lead',unit:code(),type:typ(),floor:f?f.value:''},'*'); }catch(e){} }; }
    l.textContent='Nhận giá & tình trạng căn '+(c||'này')+' →'; }
  function bg(){ var g=document.getElementById('ssBg'); if(!g){ g=document.createElement('div'); g.id='ssBg'; document.body.appendChild(g); g.onclick=close; }
    g.style.height=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight)+'px'; return g; }
  function close(){ document.body.classList.remove('picked'); H(); }
  addEventListener('keydown',function(e){ if(e.key==='Escape') close(); });
  document.addEventListener('click',function(e){ var u=e.target.closest&&e.target.closest('#plan .u'); if(!u) return;
    var first=!document.body.classList.contains('picked'); document.body.classList.add('picked');
    var rc=document.getElementById('rc'), w=document.querySelector('.wrap');
    if(!document.getElementById('ssX')){ var x=document.createElement('button'); x.type='button'; x.id='ssX'; x.setAttribute('aria-label','Đóng'); x.textContent='×'; x.onclick=close; rc.insertBefore(x,rc.firstChild); }
    var top=u.getBoundingClientRect().top-w.getBoundingClientRect().top-(innerWidth<=820?60:140); rc.style.top=Math.max(8,top)+'px';
    bg();
    setTimeout(function(){ try{ dispatchEvent(new Event('resize')); }catch(x){} lead(); bg(); H();
      try{ parent.postMessage({sscc:'scrollrc',y:rc.getBoundingClientRect().top},'*'); }catch(x){} },first?80:20);
    try{ parent.postMessage({sscc:'pick'},'*'); }catch(x){} },true);
  setInterval(lead,500); if(document.readyState!=='loading') hint(); else addEventListener('DOMContentLoaded',hint); setTimeout(hint,300);
})();'''
i = src.index('var DOC = ') + len('var DOC = ')
j = src.index(';\n', i)
doc = json.loads(src[i:j].replace('<\\/', '</'))
k = doc.index('</style>'); doc = doc[:k] + css + doc[k:]
k = doc.rindex('</html>') if '</html>' in doc else len(doc); doc = doc[:k] + '<script>' + js + '</script>' + doc[k:]
out = src[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + src[j:]
out = out.replace("if (window.__sscc) return; window.__sscc = 1;", "if (window.__sscc) return; window.__sscc = 1; /* bản chỉ mặt bằng */")
out = out.replace('Chọn căn theo view</div>', 'Chọn căn theo hướng view</div>')
out = out.replace('Bấm vào từng căn trên mặt bằng tầng: xem 3D, nắng theo giờ và view thật', 'Chọn tầng, chọn hướng – bấm vào căn để xem view và nhận giá')
out = out.replace("function fit(){ box.style.height = (window.innerWidth < 820 ? 2080 : 1060) + 'px'; }",
  "var hh=0; function fit(){ box.style.height = (hh || (window.innerWidth < 820 ? 1150 : 820)) + 'px'; }\n"
  "    window.addEventListener('message', function(e){ var d=e.data; if(!d||!d.sscc) return;\n"
  "      if(d.sscc==='h2'&&d.h>300&&Math.abs(d.h-hh)>4){ hh=d.h; fit(); }\n"
  "      if(d.sscc==='scrollrc'){ try{ window.scrollTo({top:box.getBoundingClientRect().top+window.pageYOffset+d.y-70,behavior:'smooth'}); }catch(x){} }\n"
  "      if(d.sscc==='lead'){ var it=(document.getElementById('h4d')?'ADS':'Web')+' – chọn căn '+d.unit+' ('+d.type+', tầng '+d.floor+')', b=document.createElement('button');\n"
  "        b.type='button'; b.setAttribute('data-pop',''); b.setAttribute('data-interest',it); b.style.display='none'; document.body.appendChild(b); b.click(); setTimeout(function(){ b.remove(); },100);\n"
  "        try{ if(window.gtag) gtag('event','chon_can_lead',{event_label:d.unit}); }catch(x){} } });")
assert 'bản chỉ mặt bằng' in out and "d.sscc==='h2'" in out
(here / 'chon-can-embed.js').write_text(out, encoding='utf-8')
print(len(out))
