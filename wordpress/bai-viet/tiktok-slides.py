"""Bộ 3 ảnh TikTok dọc 1080x1920 (anh Hiệp 18/11/2026): 1 = câu tò mò, 2 = số liệu dẫn chứng, 3 = ảnh thật + Zalo.
Chạy: python3 wordpress/bai-viet/tiktok-slides.py <cau-hinh.json> <anh-dai-dien.jpg> <tien-to-file-ra>
-> <tien-to>-1.jpg, -2.jpg, -3.jpg. Cấu hình:
{
 "hook": ["dòng trên chữ thường", "DÒNG GIỮA IN HOA", "chữ nghiêng"], "question": "câu hỏi phụ?",
 "hook_bg": "ảnh nền ảnh 1", "data_title": ["dòng trên", "DÒNG TO"],
 "rows": [["con số", "nhãn", "giải thích ngắn"], ...]   (4-6 dòng),
 "note": "nguồn số liệu", "photo": "ảnh 3", "photo_caption": "chú thích ảnh 3", "cta": "lời mời ở ảnh 3"
}
Vùng an toàn TikTok (anh Hiệp 21/11/2026 báo bị cắt hình): mọi chữ nằm trong y 260–1480, x 50–920 – vừa khung 3:4 ở giữa, vừa tránh thanh trên, nút bên phải và lời bài phía dưới."""
import base64, html, json, os, subprocess, sys

CFG, AVA, OUT = sys.argv[1:4]
c = json.load(open(CFG, encoding='utf-8'))
HERE = os.path.dirname(os.path.abspath(__file__))
FD = os.path.join(HERE, 'fonts')
R = {'vietnamese': 'U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB',
     'latin-ext': 'U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+1E00-1E9F,U+1EF2-1EFF', 'latin': 'U+0000-00FF,U+2000-206F,U+2190-21FF'}
faces = ''
for fam, key, ws in (('BVP', 'be-vietnam-pro', (500, 600, 700)), ('CG', 'cormorant-garamond', (600, 700)), ('GV', 'great-vibes', (400,))):
    for w in ws:
        for sub, rng in R.items():
            f = f'{FD}/{key}-{w}-{sub}.woff2'
            if os.path.exists(f):
                faces += "@font-face{font-family:%s;font-weight:%d;src:url('file://%s');unicode-range:%s}\n" % (fam, w, f, rng)
e = html.escape
def b64(p):
    return 'data:image/jpeg;base64,' + base64.b64encode(open(p, 'rb').read()).decode()

BASE = """*{margin:0;box-sizing:border-box;font-variant-numeric:lining-nums!important}body{width:1080px;height:1920px;position:relative;overflow:hidden;font-family:BVP;color:#14233f;font-variant-numeric:lining-nums;
background:linear-gradient(180deg,#d9ecf9 0%,#eef6fc 50%,#ffffff 100%)}
.brand{position:absolute;top:270px;left:0;right:0;text-align:center;font:700 30px BVP;letter-spacing:.2em;color:#1f4f86}
.cop{font-variant-numeric:lining-nums;background:linear-gradient(180deg,#e0701f,#b44d16);-webkit-background-clip:text;color:transparent;padding:.22em .08em .12em;margin:-.22em -.08em -.12em}
.photo{position:absolute;left:0;right:0;bottom:0;background-size:cover;background-position:center}
.photo:before{content:'';position:absolute;inset:0;background:linear-gradient(180deg,#eaf4fc 0%,rgba(234,244,252,.85) 12%,rgba(234,244,252,0) 38%)}
"""

def page(css, body):
    return f'<!doctype html><meta charset="utf-8"><style>{faces}{BASE}{css}</style><body>{body}</body>'

h = c['hook']
s1 = page("""
.h1{position:absolute;top:350px;left:0;right:0;text-align:center;font:600 84px/1.1 CG;color:#14233f}
.h2{position:absolute;top:455px;left:70px;right:150px;text-align:center;font:700 150px/1 CG;letter-spacing:.01em;white-space:nowrap}
.h3{position:absolute;top:600px;left:0;right:170px;text-align:right;font:400 120px GV;color:#c4561a}
.q{position:absolute;top:800px;left:70px;right:170px;text-align:center;font:700 60px/1.3 BVP;color:#14233f;text-wrap:balance}
.photo{top:960px}
.swipe{position:absolute;top:1360px;left:44%;transform:translateX(-50%);white-space:nowrap;background:#14233f;color:#fff;font:700 42px BVP;padding:22px 48px;border-radius:999px;box-shadow:0 14px 34px rgba(20,35,63,.3)}
""", f"""<div class="photo" style="background-image:url({b64(c['hook_bg'])})"></div>
<div class="brand">HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG</div>
<div class="h1">{e(h[0])}</div><div class="h2"><span class="cop">{e(h[1])}</span></div><div class="h3">{e(h[2])}</div>
<div class="q">{e(c['question'])}</div><div class="swipe">Vuốt xem số liệu →</div>""")

rows = ''.join(f'<div class="r"><div class="n"><span class="cop">{e(n)}</span></div><div class="t"><b>{e(l)}</b><span>{e(d)}</span></div></div>' for n, l, d in c['rows'])
dt = c['data_title']
s2 = page("""
.d1{position:absolute;top:330px;left:0;right:0;text-align:center;font:600 72px CG;color:#14233f}
.d2{position:absolute;top:405px;left:60px;right:150px;text-align:center;font:700 104px/1 CG;white-space:nowrap}
.rows{position:absolute;top:540px;left:50px;right:160px;display:flex;flex-direction:column;gap:16px}
.r{display:flex;align-items:center;gap:26px;background:rgba(255,255,255,.92);border-radius:26px;padding:20px 24px;box-shadow:0 10px 28px rgba(20,35,63,.10)}
.n{flex:0 0 250px;text-align:center;font:700 62px/1 CG;white-space:nowrap;font-variant-numeric:lining-nums}
.t b{display:block;font:700 36px/1.2 BVP;color:#14233f}.t span{display:block;margin-top:6px;font:500 28px/1.3 BVP;color:#4a5b70}
.note{position:absolute;top:1290px;left:60px;right:170px;font:500 26px/1.45 BVP;color:#4a5b70}
.who{position:absolute;top:1420px;left:60px;display:flex;align-items:center;gap:20px;font:700 34px BVP;color:#14233f}
.who img{width:84px;height:84px;border-radius:50%;object-fit:cover;border:4px solid #fff}
""", f"""<div class="brand">HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG</div>
<div class="d1">{e(dt[0])}</div><div class="d2"><span class="cop">{e(dt[1])}</span></div>
<div class="rows">{rows}</div><div class="note">{e(c.get('note', ''))}</div>
<div class="who"><img src="{b64(AVA)}"><span>Hoàng Hiệp · Zalo 0904 567 009</span></div>""")

s3 = page("""
body{background:#14233f}.full{position:absolute;inset:0;background-size:cover;background-position:center}
.full:after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(20,35,63,.55) 0%,rgba(20,35,63,0) 22%,rgba(20,35,63,0) 50%,rgba(20,35,63,.85) 82%)}
.brand{color:#fff;z-index:2}
.cap{position:absolute;top:1080px;left:60px;right:170px;z-index:2;font:700 58px/1.25 BVP;color:#fff;text-shadow:0 4px 18px rgba(0,0,0,.35)}
.cta{position:absolute;top:1300px;left:60px;z-index:2;display:flex;align-items:center;gap:20px;background:#fff;border-radius:999px;padding:12px 30px 12px 12px;font:700 34px BVP;color:#14233f}
.cta img{width:76px;height:76px;border-radius:50%;object-fit:cover}
""", f"""<div class="full" style="background-image:url({b64(c['photo'])})"></div><div class="brand">HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG</div>
<div class="cap">{e(c['photo_caption'])}</div><div class="cta"><img src="{b64(AVA)}"><span>{e(c.get('cta', 'Zalo 0904 567 009'))}</span></div>""")

tmp = OUT + '-tmp'
os.makedirs(os.path.dirname(os.path.abspath(OUT)), exist_ok=True)
js = """const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1920}});
for(let i=2;i<process.argv.length;i+=2){await p.goto('file://'+process.argv[i]);await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(250);
await p.evaluate(()=>{for(const el of document.querySelectorAll('.h2,.d2')){let f=parseFloat(getComputedStyle(el).fontSize);while(el.scrollWidth>el.clientWidth+2&&f>40){f-=4;el.style.fontSize=f+'px';}}});
const over=await p.evaluate(()=>[...document.querySelectorAll('.t,.q,.cap,.h2,.d2')].filter(x=>x.scrollWidth>x.clientWidth+2).length);if(over)console.log('TRAN CHU',process.argv[i]);
await p.screenshot({path:process.argv[i+1],type:'jpeg',quality:92});}await b.close();})();"""
args = []
for i, s in enumerate((s1, s2, s3), 1):
    hp = f'{tmp}-{i}.html'
    open(hp, 'w', encoding='utf-8').write(s)
    args += [os.path.abspath(hp), f'{OUT}-{i}.jpg']
open(tmp + '.js', 'w').write(js)
subprocess.run(['node', tmp + '.js'] + args, check=True)
for i in (1, 2, 3):
    os.remove(f'{tmp}-{i}.html')
os.remove(tmp + '.js')
print('ok', OUT)
