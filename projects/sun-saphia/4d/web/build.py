"""Bản 4D cho website: lấy nguyên sun-saphia-4d-embed.js ở một commit, thêm chữ chìm số Zalo (chống copy/chụp),
chặn chuột phải/bôi đen, và nới khung xem rộng – cao hơn.
Dùng: python3 build.py <sha commit chứa projects/sun-saphia/4d/sun-saphia-4d-embed.js>"""
import json, pathlib, subprocess, sys, urllib.parse
here = pathlib.Path(__file__).parent
sha = sys.argv[1]
src = subprocess.check_output(['git', 'show', sha + ':projects/sun-saphia/4d/sun-saphia-4d-embed.js'], cwd=here).decode('utf-8')
svg = ("<svg xmlns='http://www.w3.org/2000/svg' width='460' height='250'><g transform='rotate(-22 230 125)' font-family='Arial,sans-serif' font-weight='700' text-anchor='middle'>"
       "<text x='230' y='118' font-size='22' fill='rgba(255,255,255,.30)' stroke='rgba(10,37,64,.22)' stroke-width='.8'>Sun Saphia · Zalo 0904 567 009</text>"
       "<text x='230' y='146' font-size='13' fill='rgba(255,255,255,.26)' stroke='rgba(10,37,64,.18)' stroke-width='.6'>sun-saphia-residence.com · Hoàng Hiệp</text></g></svg>")
url = 'data:image/svg+xml;charset=utf-8,' + urllib.parse.quote(svg)
css = ('#ssWm{position:fixed;inset:0;pointer-events:none;z-index:40;background-image:url("%s");background-size:460px 250px}'
       '#ssWmB{position:fixed;right:10px;bottom:auto;top:50%%;transform:translateY(-50%%) rotate(-90deg);transform-origin:right center;pointer-events:none;z-index:41;'
       'font:800 12px/1 Arial,sans-serif;letter-spacing:.06em;color:rgba(255,255,255,.75);text-shadow:0 1px 3px rgba(0,0,0,.6);white-space:nowrap}'
       'body{-webkit-user-select:none;user-select:none;-webkit-touch-callout:none}') % url
js = ('(function(){function add(){if(document.getElementById("ssWm"))return;var w=document.createElement("div");w.id="ssWm";w.setAttribute("aria-hidden","true");document.body.appendChild(w);'
      'var b=document.createElement("div");b.id="ssWmB";b.textContent="Sun Saphia · Zalo 0904 567 009";document.body.appendChild(b);}'
      'if(document.body)add();else addEventListener("DOMContentLoaded",add);'
      'addEventListener("contextmenu",function(e){e.preventDefault()},true);addEventListener("dragstart",function(e){e.preventDefault()},true);'
      'addEventListener("keydown",function(e){var k=(e.key||"").toLowerCase();if((e.ctrlKey||e.metaKey)&&(k==="s"||k==="p"||k==="c"||k==="u"))e.preventDefault()},true);})();')
i = src.index('var DOC = ') + len('var DOC = ')
j = src.index(';\n', i)
doc = json.loads(src[i:j].replace('<\\/', '</'))
CAM = [("camera.position.copy(world.localToWorld(new THREE.Vector3(-377,260,-214)));", "camera.position.copy(world.localToWorld(new THREE.Vector3(-497,170,-319)));"),
       ("camera.position.copy(world.localToWorld(new THREE.Vector3(-520,360,-330)));", "camera.position.copy(world.localToWorld(new THREE.Vector3(-610,215,-402)));")]
CAM.append(("var tgt=world.localToWorld(new THREE.Vector3(-27,30,86));", "var tgt=world.localToWorld(new THREE.Vector3(-27,44,86));"))
CAM.append(("controls.target.copy(world.localToWorld(new THREE.Vector3(-40,45,60)));", "controls.target.copy(world.localToWorld(new THREE.Vector3(-40,52,60)));"))
for a_, b_ in CAM:
    assert a_ in doc; doc = doc.replace(a_, b_)
k = doc.index('</style>'); doc = doc[:k] + css + doc[k:]
k = doc.rindex('</body>') if '</body>' in doc else len(doc); doc = doc[:k] + '<script>' + js + '</script>' + doc[k:]
out = src[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + src[j:]
a = "max-width:1140px;margin:0 auto;padding:0 16px;font-family:inherit"
b = "height:min(78vh,640px);min-height:440px"
assert a in out and b in out
out = out.replace(a, "max-width:1360px;margin:0 auto;padding:0 12px;font-family:inherit")
out = out.replace(b, "height:min(90vh,860px);min-height:560px")
out = out.replace("f.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0';",
                  "f.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0'; box.oncontextmenu = function(){ return false; };")
GATE = r"""    function sentL(){ try{ if(localStorage.getItem('ss4d_ok')) return true; for(var i=0;i<localStorage.length;i++) if(/^hhc_sent_/.test(localStorage.key(i))) return true; }catch(e){} return false; }
    var gOn=false, gT=0;
    function gate(){ if(sentL()||gOn) return; gOn=true;
      if(!document.getElementById('ssg-css')){ var st=document.createElement('style'); st.id='ssg-css'; st.textContent=
        '#ss4d-box.lock iframe{filter:blur(7px) brightness(.75);pointer-events:none}'
        +'#ssg{position:absolute;inset:0;z-index:20;display:flex;align-items:center;justify-content:center;padding:14px;background:rgba(10,37,64,.35);font-family:inherit}'
        +'#ssg .c{position:relative;width:min(470px,100%);max-height:100%;overflow:auto;background:#fffdf8;border-radius:18px;padding:22px 22px 18px;box-shadow:0 24px 60px rgba(0,0,0,.45);color:#0A2540;text-align:left;animation:ssgIn .35s ease}'
        +'@keyframes ssgIn{from{opacity:0;transform:translateY(16px) scale(.97)}to{opacity:1;transform:none}}'
        +'#ssg .x{position:absolute;right:12px;top:12px;width:34px;height:34px;border-radius:50%;border:0;background:#eef1f4;color:#7b8794;font-size:20px;cursor:pointer}'
        +'#ssg .lk{width:54px;height:54px;margin:0 auto 8px;border-radius:16px;background:#0A2540;display:flex;align-items:center;justify-content:center;font-size:26px;box-shadow:0 8px 18px rgba(10,37,64,.3)}'
        +'#ssg h3{margin:0 0 4px;font-size:19px;line-height:1.3;text-align:center;font-weight:800}#ssg .sb{margin:0 0 12px;text-align:center;color:#7b8794;font-size:13px}'
        +'#ssg ul{list-style:none;margin:0 0 14px;padding:0;display:grid;gap:7px}#ssg li{display:flex;gap:10px;align-items:center;background:#f3f5f7;border:1px solid #e3e8ee;border-radius:12px;padding:8px 10px;font-size:14px}'
        +'#ssg li i{flex:0 0 30px;height:30px;border-radius:50%;background:#0A2540;color:#fff;font-style:normal;display:flex;align-items:center;justify-content:center;font-size:15px}'
        +'#ssg input{display:block;width:100%;box-sizing:border-box;margin:0 0 8px;padding:12px 14px;border:1.5px solid #d5dde6;border-radius:12px;font-size:16px;font-weight:600;font-family:inherit;background:#fff;color:#0A2540}'
        +'#ssg input:focus{outline:0;border-color:#E96118}#ssg .go{display:block;width:100%;border:0;border-radius:12px;padding:14px;background:linear-gradient(135deg,#FF8A3D,#E8460F);color:#fff;font-size:16px;font-weight:800;font-family:inherit;cursor:pointer;box-shadow:0 8px 18px rgba(232,70,15,.35)}'
        +'#ssg .er{display:none;color:#d93025;font-size:13px;font-weight:700;margin:-2px 0 8px}#ssg .nt{margin:8px 0 0;text-align:center;font-size:12px;color:#7b8794}'
        +'#ssg-un{position:absolute;inset:0;margin:auto;z-index:19;width:250px;height:52px;border:0;border-radius:26px;background:#ff6a2b;color:#fff;font-weight:800;font-size:16px;cursor:pointer;box-shadow:0 8px 20px rgba(0,0,0,.35)}'
        +'@media(max-width:600px){#ssg .c{padding:18px 16px 14px}#ssg li{font-size:13px;padding:7px 9px}#ssg h3{font-size:17px}}';
        document.head.appendChild(st); }
      box.classList.add('lock'); try{ box.querySelector('iframe').contentWindow.postMessage({ss4dHero:'pause'},'*'); }catch(e){}
      var g=document.createElement('div'); g.id='ssg';
      g.innerHTML='<div class="c" role="dialog" aria-modal="true" aria-label="Đăng ký xem tiếp mô hình 4D"><button type="button" class="x" aria-label="Đóng">×</button>'
        +'<div class="lk">🔒</div><h3>Điền tên &amp; Zalo để xem tiếp mô hình 4D</h3><p class="sb">Miễn phí · chỉ mất 10 giây</p>'
        +'<ul><li><i>👁</i>Xem trọn mô hình 3D · 4D · 5D, view từ từng căn</li><li><i>🏢</i>Chọn căn theo tầng, theo hướng biển – sông – núi</li>'
        +'<li><i>📄</i>Nhận bảng giá gốc &amp; chính sách bán hàng qua Zalo</li><li><i>🔔</i>Báo ngay khi có căn đẹp, trạng thái căn hộ</li></ul>'
        +'<input id="ssgN" type="text" autocomplete="name" placeholder="Anh/chị tên gì ạ?"><input id="ssgP" type="tel" inputmode="tel" autocomplete="tel" placeholder="Số Zalo (09xx xxx xxx)">'
        +'<div class="er" id="ssgE">Anh/chị nhập giúp em số điện thoại / Zalo đúng nhé</div>'
        +'<button type="button" class="go" id="ssgB">Xem tiếp mô hình 4D →</button><p class="nt">🔒 Chỉ nhắn Zalo · không gọi làm phiền</p></div>';
      box.appendChild(g); try{ if(window.gtag) gtag('event','gate_4d_show'); }catch(e){}
      function un(){ var b=document.getElementById('ssg-un'); if(b) b.remove(); }
      g.querySelector('.x').onclick=function(){ g.remove(); un(); var b=document.createElement('button'); b.type='button'; b.id='ssg-un'; b.textContent='🔒 Mở khóa xem tiếp'; b.onclick=function(){ b.remove(); gOn=false; gate(); }; box.appendChild(b); };
      document.getElementById('ssgB').onclick=function(){ var n=(document.getElementById('ssgN').value||'').trim(), p=(document.getElementById('ssgP').value||'').replace(/[^0-9+]/g,'');
        if(!/^(\+?84|0)\d{8,10}$/.test(p)){ document.getElementById('ssgE').style.display='block'; return; }
        try{ if(window.hhcLead) hhcLead({name:n,phone:p,interest:(document.getElementById('h4d')?'ADS':'Web')+' – mô hình 4D: đăng ký xem tiếp'}); }catch(e){}
        try{ localStorage.setItem('ss4d_ok','1'); }catch(e){}
        g.querySelector('.c').innerHTML='<div class="lk" style="background:#1e9e5a">✓</div><h3>Cảm ơn '+(n?('anh/chị '+n.replace(/[<>&]/g,'')):'anh/chị')+'!</h3><p class="sb" style="margin:0">Mời xem tiếp mô hình. Anh Hiệp sẽ gửi bảng giá qua Zalo sớm.</p>';
        setTimeout(function(){ g.remove(); box.classList.remove('lock'); try{ box.querySelector('iframe').contentWindow.postMessage({ss4dHero:'play'},'*'); }catch(e){} },1500); };
    }
    function arm(){ if(sentL()) return; var seen=0, last=Date.now(); clearInterval(gT); gT=setInterval(function(){ var now=Date.now(), dt=Math.min(now-last,5000); last=now; if(gOn||sentL()){ clearInterval(gT); return; }
      if(document.visibilityState==='hidden') return; var r=box.getBoundingClientRect(), vh=innerHeight, vis=Math.min(r.bottom,vh)-Math.max(r.top,0);
      if(vis>r.height*0.5||vis>vh*0.6) seen+=dt; if(seen>=30000){ clearInterval(gT); gate(); } },1000); }
"""
out = out.replace("    function load(){ if (done) return; done = true;", GATE + "    function load(){ if (done) return; done = true;")
out = out.replace("box.innerHTML = ''; box.appendChild(f);", "box.innerHTML = ''; box.appendChild(f); arm();")
assert 'arm();' in out and 'function gate()' in out
(here / 'sun-saphia-4d-embed.js').write_text(out, encoding='utf-8')
print(len(out))
