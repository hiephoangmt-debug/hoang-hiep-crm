"""Gộp dan-truoc-body.html thành 1 file JS (ss-all.js) để gắn thẳng vào trang, không cần dán mã."""
import re, json, pathlib
here = pathlib.Path(__file__).parent
s = (here / 'dan-truoc-body.html').read_text(encoding='utf-8')
parts = []  # ('html', text) | ('js', code) | ('src', url)
pos = 0
for m in re.finditer(r'<script([^>]*)>(.*?)</script>', s, flags=re.S):
    pre = re.sub(r'<!--.*?-->', '', s[pos:m.start()], flags=re.S).strip()
    if pre: parts.append(('html', pre))
    src = re.search(r'src="([^"]+)"', m.group(1))
    parts.append(('src', src.group(1)) if src else ('js', m.group(2)))
    pos = m.end()
tail = re.sub(r'<!--.*?-->', '', s[pos:], flags=re.S).strip()
if tail: parts.append(('html', tail))
out = ['/* Sun Saphia – gộp toàn bộ mã "Trước </body>" (chat, Zalo, gọi, CRM, 3D·4D·5D, trắc nghiệm, máy tính). Sinh bởi build-all.py */',
       '(function(){ if(window.__ssAll) return; window.__ssAll=1;',
       'function run(){ var b=document.body;']
for kind, v in parts:
    if kind == 'html':
        out.append('(function(){var d=document.createElement("div");d.innerHTML=%s;while(d.firstChild){var n=d.firstChild;if(n.tagName==="STYLE"){document.head.appendChild(n);}else{b.appendChild(n);}}})();' % json.dumps(v, ensure_ascii=False).replace('</', '<\\/'))
    elif kind == 'js':
        out.append('try{(0,eval)(%s);}catch(e){console.error("ssAll",e);}' % json.dumps(v, ensure_ascii=False).replace('</', '<\\/'))
    else:
        out.append('(function(){var x=document.createElement("script");x.src=%s;x.defer=true;document.body.appendChild(x);})();' % json.dumps(v))
out.append('}')
out.append('function go(){ var f=/[?&]ssforce/.test(location.search); if(!f){ if(navigator.webdriver) return; if(!document.querySelector(".ladi-wraper,.ladi-section")) return; } run(); }')
out.append('if(document.readyState==="loading") document.addEventListener("DOMContentLoaded",go); else go();')
out.append('})();')
(here / 'ss-all.js').write_text('\n'.join(out), encoding='utf-8')
print([k for k, _ in parts])
