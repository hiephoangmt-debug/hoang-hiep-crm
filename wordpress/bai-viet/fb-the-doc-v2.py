"""Mẫu ảnh FB/TikTok dọc 1080×1350 bản 2 (dựng bằng HTML + Chromium, font Be Vietnam Pro + Playfair Display).
Hai kiểu:
  tap-chi : ảnh tràn toàn khung, chữ trắng trên nền tối mờ dần, ít chữ, hợp ảnh phối cảnh / ảnh thật đẹp.
  sang    : nền ngà, ảnh khung bo góc phía trên, tiêu đề chữ có chân, 4 con số lớn màu vàng đồng.
Chạy: python3 fb-the-doc-v2.py <tap-chi|sang> <cau-hinh.json> <anh-dai-dien.jpg> <anh-nen.jpg> <out.jpg>
cau-hinh.json dùng chung với fb-the-doc-anh-tren.py: tag, title, sub, xc, yc, stats[4], items[≤4], box, note.
Kiểu tap-chi chỉ dùng 3 số đầu và 3 ý đầu cho thoáng."""
import base64, html, json, os, subprocess, sys, tempfile

STYLE, CFG, AVA, BG, OUT = sys.argv[1:6]
c = json.load(open(CFG, encoding='utf-8'))
HERE = os.path.dirname(os.path.abspath(__file__))
FD = os.path.join(HERE, 'fonts')
e = html.escape

R = {
    'vietnamese': 'U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB',
    'latin-ext': 'U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AA, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF',
    'latin': 'U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD',
}


def b64(p):
    ext = os.path.splitext(p)[1].lower().lstrip('.')
    mime = {'jpg': 'jpeg', 'jpeg': 'jpeg', 'png': 'png', 'webp': 'webp'}.get(ext, 'jpeg')
    return 'data:image/%s;base64,%s' % (mime, base64.b64encode(open(p, 'rb').read()).decode())


faces = ''
for fam, key, weights in (('BVP', 'be-vietnam-pro', (400, 500, 600, 700)), ('PF', 'playfair-display', (700,))):
    for w in weights:
        for sub, rng in R.items():
            f = os.path.join(FD, '%s-%d-%s.woff2' % (key, w, sub))
            if os.path.exists(f):
                faces += "@font-face{font-family:%s;font-weight:%d;src:url('file://%s') format('woff2');unicode-range:%s}\n" % (fam, w, f, rng)

bg, ava = b64(BG), b64(AVA)
pos = '%d%% %d%%' % (c.get('xc', 0.5) * 100, c.get('yc', 0.5) * 100)
stats, items = c.get('stats', []), c.get('items', [])
foot = '<div class="foot"><img class="ava" src="%s"><div><b>Hoàng Hiệp</b><span>BĐS Đà Nẵng · Zalo 0904 567 009</span></div></div>' % ava

if STYLE == 'tap-chi':
    st = ''.join('<div class="st"><b>%s</b><span>%s</span></div>' % (e(a), e(b)) for a, b in stats[:3])
    it = ''.join('<li><b>%s</b><span>%s</span></li>' % (e(a), e(b)) for a, b in items[:3])
    body = '''<div class="card mag" style="background-image:url(%s);background-position:%s">
<div class="shade"></div>
<div class="tag">%s</div>
<div class="low">
 <h1>%s</h1><p class="sub">%s</p>
 <div class="stats">%s</div>
 <ul>%s</ul>
 <div class="row">%s<div class="box">%s</div></div>
 <p class="note">%s</p>
</div></div>''' % (bg, pos, e(c['tag']), e(c['title']), e(c['sub']), st, it, foot, e(c.get('box', '')), e(c.get('note', '')))
    css = '''
.mag{background-size:cover;color:#fff}
.mag .shade{position:absolute;inset:0;background:linear-gradient(180deg,rgba(8,20,40,.55) 0%,rgba(8,20,40,0) 18%,rgba(8,20,40,0) 34%,rgba(8,20,40,.78) 52%,rgba(8,20,40,.96) 70%,#081428 100%)}
.mag .tag{position:absolute;left:64px;top:60px;font:600 22px BVP;letter-spacing:.14em;text-transform:uppercase;padding:12px 22px;border:1.5px solid rgba(232,200,140,.9);color:#f3d9a4;border-radius:999px;background:rgba(8,20,40,.35);backdrop-filter:blur(6px)}
.mag .low{position:absolute;left:64px;right:64px;bottom:44px}
.mag h1{font:700 76px/1.08 PF;margin:0 0 14px;letter-spacing:-.01em;text-shadow:0 2px 24px rgba(0,0,0,.35)}
.mag .sub{font:500 30px/1.35 BVP;color:#f3d9a4;margin:0 0 34px}
.mag .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:30px}
.mag .st{padding:22px 20px;border-radius:20px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.16);backdrop-filter:blur(8px)}
.mag .st b{display:block;font:700 38px/1.1 BVP;color:#f3d9a4;white-space:nowrap}
.mag .st span{display:block;font:400 20px/1.3 BVP;color:#d6dbe6;margin-top:8px}
.mag ul{list-style:none;margin:0 0 30px;padding:0}
.mag li{position:relative;padding-left:30px;margin-bottom:16px}
.mag li:before{content:"";position:absolute;left:0;top:13px;width:12px;height:12px;border-radius:50%;background:#e8c88c}
.mag li b{font:600 28px/1.3 BVP}
.mag li span{font:400 24px/1.3 BVP;color:#c4cbd9;margin-left:10px}
.mag .row{display:flex;align-items:center;gap:22px;border-top:1px solid rgba(255,255,255,.18);padding-top:26px}
.mag .box{flex:1;font:500 22px/1.4 BVP;color:#f3d9a4;text-align:right}
.mag .foot b{color:#fff}.mag .foot span{color:#e8c88c}
.mag .note{font:400 17px BVP;color:#8f99ad;margin:18px 0 0;text-align:right}'''
else:
    st = ''.join('<div class="st"><b>%s</b><span>%s</span></div>' % (e(a), e(b)) for a, b in stats[:4])
    it = ''.join('<li><i>%d</i><div><b>%s</b><span>%s</span></div></li>' % (k + 1, e(a), e(b)) for k, (a, b) in enumerate(items[:4]))
    body = '''<div class="card lux">
<div class="ph" style="background-image:url(%s);background-position:%s"><div class="tag">%s</div></div>
<div class="in">
 <h1>%s</h1><p class="sub">%s</p>
 <div class="stats">%s</div>
 <ul>%s</ul>
 <div class="box">%s</div>
 <div class="bt">%s<p class="note">%s</p></div>
</div></div>''' % (bg, pos, e(c['tag']), e(c['title']), e(c['sub']), st, it, e(c.get('box', '')), foot, e(c.get('note', '')))
    css = '''
.lux{background:#f7f2e8;color:#14233f}
.lux .ph{position:absolute;left:36px;right:36px;top:36px;height:560px;border-radius:28px;background-size:cover;box-shadow:0 18px 40px rgba(20,35,63,.18)}
.lux .tag{position:absolute;left:26px;top:26px;font:600 20px BVP;letter-spacing:.14em;text-transform:uppercase;padding:11px 20px;border-radius:999px;background:rgba(247,242,232,.92);color:#8a6a2b}
.lux .in{position:absolute;left:64px;right:64px;top:630px;bottom:36px;display:flex;flex-direction:column}
.lux h1{font:700 60px/1.1 PF;margin:0 0 10px;color:#14233f}
.lux .sub{font:500 27px/1.35 BVP;color:#9a7433;margin:0 0 24px}
.lux .stats{display:grid;grid-template-columns:repeat(4,1fr);border-top:1.5px solid #d9c9a6;border-bottom:1.5px solid #d9c9a6;margin-bottom:22px}
.lux .st{padding:18px 8px;text-align:center}.lux .st+.st{border-left:1px solid #e3d6b9}
.lux .st b{display:block;font:700 32px/1.1 BVP;color:#a57a2c;white-space:nowrap}
.lux .st span{display:block;font:500 17px/1.3 BVP;color:#5d6b84;margin-top:8px}
.lux ul{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:16px 28px}
.lux li{display:flex;gap:14px}
.lux li i{flex:none;width:34px;height:34px;border-radius:50%;background:#14233f;color:#f3d9a4;font:700 18px/34px BVP;font-style:normal;text-align:center}
.lux li b{display:block;font:600 22px/1.3 BVP}
.lux li span{display:block;font:400 19px/1.35 BVP;color:#5d6b84;margin-top:3px}
.lux .box{margin-top:22px;padding:16px 22px;border-radius:16px;background:#14233f;color:#f3d9a4;font:500 22px/1.35 BVP;text-align:center}
.lux .bt{margin-top:auto;display:flex;align-items:flex-end;justify-content:space-between;gap:20px}
.lux .foot b{color:#14233f}.lux .foot span{color:#9a7433}
.lux .note{font:400 15px/1.35 BVP;color:#8a93a5;margin:0;text-align:right;max-width:400px}'''

page = '''<!doctype html><html><head><meta charset="utf-8"><style>%s
*{box-sizing:border-box}html,body{margin:0;width:1080px;height:1350px}
.card{position:relative;width:1080px;height:1350px;overflow:hidden;font-family:BVP}
.foot{display:flex;align-items:center;gap:18px}
.ava{width:92px;height:92px;border-radius:50%%;object-fit:cover;border:3px solid #e8c88c}
.foot b{display:block;font:700 30px BVP}.foot span{display:block;font:500 21px BVP;margin-top:4px;white-space:nowrap}
h1{font-variant-numeric:lining-nums}
%s</style></head><body>%s</body></html>''' % (faces, css, body)

tmp = tempfile.NamedTemporaryFile('w', suffix='.html', delete=False, encoding='utf-8')
tmp.write(page)
tmp.close()
js = '''const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1350},deviceScaleFactor:2});
await p.goto('file://'+process.argv[2]);await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(300);
const o=await p.evaluate(()=>[...document.querySelectorAll('h1,.sub,.st b,li b,li span,.box')].filter(e=>e.scrollWidth>e.clientWidth+1||e.getBoundingClientRect().right>1080).map(e=>e.textContent));
if(o.length)console.error('TRAN CHU:',JSON.stringify(o));
await p.screenshot({path:process.argv[3],type:'jpeg',quality:92});await b.close();})();'''
jsf = tmp.name + '.js'
open(jsf, 'w').write(js)
png = OUT + '.tmp.jpg'
subprocess.run(['node', jsf, tmp.name, png], check=True)
from PIL import Image
Image.open(png).convert('RGB').resize((1080, 1350), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
os.remove(png)
os.remove(jsf)
os.remove(tmp.name)
