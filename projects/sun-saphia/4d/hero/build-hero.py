"""Tạo hero-4d-embed.js: mô hình 4D (bản trên nhánh claude/sweet-knuth, ghim theo commit) làm hình chính đầu trang.
Dùng: python3 build-hero.py <sha commit chứa projects/sun-saphia/4d/sun-saphia-4d.html>"""
import json, pathlib, sys
here = pathlib.Path(__file__).parent
sha = sys.argv[1]
src = ['https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@%s/projects/sun-saphia/4d/sun-saphia-4d.html' % sha,
       'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/%s/projects/sun-saphia/4d/sun-saphia-4d.html' % sha]
js = (here / 'hero.js').read_text(encoding='utf-8')
css = (here / 'hero.css.html').read_text(encoding='utf-8')
out = r'''/* Sun Saphia – hero 4D: mô hình 3D tự xoay chậm, nắng theo giờ thực ở Đà Nẵng, chữ chìm số điện thoại. Sinh tự động bởi build-hero.py */
(function(){
  var box=document.getElementById('h4d'); if(!box||box.__on) return; box.__on=1;
  var SRC=__SRC__, JS=__JS__, CSS=__CSS__, f=null;
  box.addEventListener('contextmenu',function(e){ e.preventDefault(); });
  addEventListener('message',function(e){ if(e.data&&e.data.ss4dHero==='ready'&&f){ setTimeout(function(){ f.style.opacity=1; box.classList.add('on'); },1200); } });
  function get(k){ return fetch(SRC[k]).then(function(r){ if(!r.ok) throw 0; return r.text(); }).catch(function(){ return k+1<SRC.length?get(k+1):''; }); }
  function go(){ if(!window.fetch) return;
    get(0).then(function(h){ var i=h.lastIndexOf('\nloop();\n})();'); if(i<0) return;
      h=h.slice(0,i)+'\n'+JS+h.slice(i)+CSS;
      f=document.createElement('iframe'); f.title='Mô hình 4D Sun Saphia Residence'; f.setAttribute('aria-hidden','true'); f.tabIndex=-1;
      f.style.cssText='position:absolute;inset:0;width:100%;height:100%;border:0;pointer-events:none;opacity:0;transition:opacity 1.2s ease';
      f.srcdoc=h; box.insertBefore(f,box.firstChild.nextSibling);
      try{ if(window.gtag) gtag('event','hero_4d',{event_label:location.pathname}); }catch(e){} }).catch(function(){});
  }
  /* tải ngay khi DOM sẵn sàng, không chờ toàn bộ ảnh/video của trang */
  var ld=document.createElement('span'); ld.className='h4dload'; ld.textContent='⏳ Đang tải mô hình 4D…'; ld.style.cssText='position:absolute;right:14px;top:12px;z-index:2;background:rgba(10,37,64,.75);color:#fff;font-size:12px;font-weight:700;padding:6px 12px;border-radius:999px'; box.appendChild(ld);
  addEventListener('message',function(e){ if(e.data&&e.data.ss4dHero==='ready') setTimeout(function(){ ld.remove(); },1200); });
  setTimeout(function(){ if(ld.parentNode) ld.remove(); },30000);
  if(document.readyState!=='loading') setTimeout(go,50); else addEventListener('DOMContentLoaded',function(){ setTimeout(go,50); });
})();
'''.replace('__SRC__', json.dumps(src)).replace('__JS__', json.dumps(js, ensure_ascii=False).replace('</', '<\\/')).replace('__CSS__', json.dumps(css, ensure_ascii=False).replace('</', '<\\/'))
(here / 'hero-4d-embed.js').write_text(out, encoding='utf-8')
print(len(out))
