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
(here / 'sun-saphia-4d-embed.js').write_text(out, encoding='utf-8')
print(len(out))
