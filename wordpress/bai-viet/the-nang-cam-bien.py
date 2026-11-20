"""Ảnh "NẮNG CAM – BÃI BIỂN" khổ vuông 1080x1080 (anh Hiệp 20/11/2026: "thêm hình và chữ kiểu vậy" theo ảnh
"Dấu ấn mặt biển" của chủ đầu tư): nền cát kem, sóng biển phía dưới, tiêu đề khối cam–đỏ có hình người nằm ghế
chen giữa hai chữ, bong bóng, lá xanh. Không logo chủ đầu tư / đại lý.
Chạy: python3 wordpress/bai-viet/the-nang-cam-bien.py <cau-hinh.json> <anh-dai-dien.jpg> <out.jpg>
Cấu hình: kicker, left, right (2 chữ hai bên hình), sub (2 dòng, dùng \\n), project, bg (nền sóng), figure (png), note."""
import base64, html, json, os, subprocess, sys

CFG, AVA, OUT = sys.argv[1:4]
c = json.load(open(CFG, encoding='utf-8'))
HERE = os.path.dirname(os.path.abspath(__file__))
FD = os.path.join(HERE, 'fonts')
e = html.escape
R = {'vietnamese': 'U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB',
     'latin-ext': 'U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+1E00-1E9F,U+1EF2-1EFF', 'latin': 'U+0000-00FF,U+2000-206F,U+2190-21FF'}
faces = ''
for fam, key, ws in (('BVP', 'be-vietnam-pro', (600, 700, 800, 900)), ('OS', 'oswald', (700,)), ('GV', 'great-vibes', (400,))):
    for w in ws:
        for sub, rng in R.items():
            f = f'{FD}/{key}-{w}-{sub}.woff2'
            if os.path.exists(f):
                faces += "@font-face{font-family:%s;font-weight:%d;src:url('file://%s');unicode-range:%s}\n" % (fam, w, f, rng)


def b64(p):
    mime = 'png' if p.lower().endswith('.png') else 'jpeg'
    return f'data:image/{mime};base64,' + base64.b64encode(open(p, 'rb').read()).decode()


LEAF = ('<svg viewBox="0 0 200 90" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="l" x1="0" y1="0" x2="1" y2="1">'
        '<stop offset="0" stop-color="#b7e35a"/><stop offset=".55" stop-color="#4fae2f"/><stop offset="1" stop-color="#2f7d22"/></linearGradient></defs>'
        '<path d="M4 46 C40 2 140 -6 196 40 C140 88 44 92 4 46Z" fill="url(#l)"/><path d="M8 46 C70 40 130 40 192 41" stroke="#e9f7c8" stroke-width="2.4" fill="none" opacity=".75"/></svg>')
leaf = 'data:image/svg+xml;base64,' + base64.b64encode(LEAF.encode()).decode()
sub = '<br>'.join(e(x) for x in c.get('sub', '').split('\n'))
css = f"""*{{margin:0;box-sizing:border-box;font-variant-numeric:lining-nums}}
body{{width:1080px;height:1080px;position:relative;overflow:hidden;font-family:BVP;background:url({b64(c['bg'])}) center bottom/cover}}
.brand{{position:absolute;top:58px;left:60px;font:800 24px BVP;letter-spacing:.16em;color:#1f4f9a}}
.proj{{position:absolute;top:36px;right:60px;font:400 60px GV;color:#e8731f}}
.kick{{position:absolute;top:150px;left:64px;font:700 96px/1 OS;letter-spacing:.01em}}
.title{{position:absolute;top:240px;left:40px;right:40px;display:flex;justify-content:center;align-items:flex-start;gap:0}}
.w{{font:700 330px/0.9 OS;white-space:nowrap;letter-spacing:-.01em}}
.g{{background:linear-gradient(90deg,#fdb515 0%,#f7941d 40%,#f26522 100%);-webkit-background-clip:text;color:transparent;
padding:.14em .03em .02em;margin:-.14em -.03em -.02em;filter:drop-shadow(0 4px 6px rgba(200,90,20,.12))}}
.kick .g{{background:linear-gradient(90deg,#f7941d,#f26a21);-webkit-background-clip:text}}
.r .g{{background:linear-gradient(90deg,#f26522 0%,#ec4a24 45%,#d9261c 100%);-webkit-background-clip:text}}
.fig{{position:relative;width:170px;margin:-20px -10px 0;z-index:3;filter:drop-shadow(0 18px 18px rgba(80,50,20,.25))}}
.fig img{{width:170px;display:block}}
.sub{{position:absolute;top:610px;right:70px;text-align:right;font:800 32px/1.25 BVP;color:#1f4f9a;text-transform:uppercase}}
.bub{{position:absolute;border-radius:50%;background:radial-gradient(circle at 30% 28%,rgba(255,255,255,.95) 0,rgba(255,255,255,.35) 14%,rgba(255,255,255,.05) 45%,rgba(190,225,255,.25) 80%,rgba(255,255,255,.7) 98%);
box-shadow:inset 0 0 18px rgba(255,255,255,.6),0 6px 18px rgba(120,160,200,.12)}}
.leaf{{position:absolute;background:url({leaf}) center/contain no-repeat}}
.foot{{position:absolute;left:40px;right:40px;bottom:40px;display:flex;align-items:center;gap:18px;background:rgba(20,35,63,.82);border-radius:26px;padding:16px 22px;color:#fff;z-index:5}}
.foot img{{width:84px;height:84px;border-radius:50%;object-fit:cover;border:3px solid #f6c27a}}
.foot b{{display:block;font:800 32px BVP}}.foot span{{display:block;font:700 26px BVP;color:#f6c27a;margin-top:2px}}
.foot i{{margin-left:auto;max-width:340px;text-align:right;font:500 19px/1.35 BVP;font-style:normal;color:#dfe6f0}}"""
body = f"""<div class="leaf" style="width:230px;height:104px;left:-40px;top:560px;transform:rotate(-28deg);filter:blur(1.5px)"></div>
<div class="leaf" style="width:120px;height:54px;left:600px;top:150px;transform:rotate(18deg);filter:blur(.6px)"></div>
<div class="leaf" style="width:90px;height:40px;right:40px;top:520px;transform:rotate(-150deg);filter:blur(2.5px);opacity:.85"></div>
<div class="brand">HOÀNG HIỆP · BĐS ĐÀ NẴNG</div><div class="proj">{e(c.get('project', ''))}</div>
<div class="kick"><span class="g">{e(c['kicker'])}</span></div>
<div class="title"><div class="w"><span class="g">{e(c['left'])}</span></div><div class="fig"><img src="{b64(c['figure'])}"></div><div class="w r"><span class="g">{e(c['right'])}</span></div></div>
<div class="sub">{sub}</div>
<div class="bub" style="width:250px;height:250px;left:360px;top:660px"></div>
<div class="bub" style="width:70px;height:70px;left:250px;top:560px"></div>
<div class="bub" style="width:46px;height:46px;right:250px;top:470px"></div>
<div class="foot"><img src="{b64(AVA)}"><div><b>Hoàng Hiệp</b><span>Zalo 0904 567 009</span></div><i>{e(c.get('note', ''))}</i></div>"""
page = f'<!doctype html><meta charset="utf-8"><style>{faces}{css}</style><body>{body}</body>'
tmp = OUT + '.tmp.html'
open(tmp, 'w', encoding='utf-8').write(page)
js = """const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1080}});
await p.goto('file://'+process.argv[2]);await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(300);
await p.evaluate(()=>{const t=document.querySelector('.title');let f=330;while(t.scrollWidth>t.clientWidth+2&&f>120){f-=10;document.querySelectorAll('.w').forEach(w=>w.style.fontSize=f+'px');}});
await p.screenshot({path:process.argv[3],type:'jpeg',quality:92});await b.close();})();"""
open(tmp + '.js', 'w').write(js)
subprocess.run(['node', tmp + '.js', os.path.abspath(tmp), OUT], check=True)
os.remove(tmp); os.remove(tmp + '.js')
print('ok', OUT)
