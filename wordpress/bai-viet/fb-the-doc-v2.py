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
for fam, key, weights in (('BVP', 'be-vietnam-pro', (400, 500, 600, 700)), ('PF', 'playfair-display', (700,)), ('GV', 'great-vibes', (400,)), ('CG', 'cormorant-garamond', (500, 600, 700)), ('CSC', 'cormorant-sc', (500, 600, 700))):
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
elif STYLE == 'poster':
    # Kiểu poster (theo mẫu anh Hiệp gửi 15/11/2026): nền ngà có vệt sáng, tiêu đề so le căn giữa
    # (chữ nghiêng Great Vibes + chữ in Cormorant SC màu đồng, chữ nhấn to đậm), 3 con số, ảnh tràn nửa dưới mờ dần lên.
    # headline_poster: các dòng; mỗi dòng {"segs": [[chữ, script|cap|big], ...], "dx": lệch ngang px, "over": đè lên dòng trên}
    # Ví dụ mẫu Noble Palace: [{"segs":[["Bình ổn","script"],["LÃI SUẤT","cap"]]}, {"segs":[["AN TÂM","big"]]},
    #                          {"segs":[["Tích sản","script"]],"dx":200,"over":true}]
    hl = c.get('headline_poster') or [{'segs': [[c['title'], 'cap']]}]
    head = ''.join('<span class="ln%s" style="transform:translateX(%dpx)">%s</span>' % (
        ' over' if ln.get('over') else '', int(ln.get('dx', 0)),
        ''.join('<span class="l %s">%s</span>' % (k, e(t)) for t, k in ln['segs'])) for ln in hl)
    st = ''.join('<div class="st"><b>%s</b><span>%s</span></div>' % (e(a), e(b)) for a, b in stats[:3])
    body = """<div class="card pos">
<div class="beam"></div>
<div class="ph" style="background-image:url(%s);background-position:%s"></div>
<div class="top"><div class="brand">HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG</div><div class="tag">%s</div>
<h1 aria-label="%s">%s</h1><p class="sub">%s</p><div class="stats">%s</div></div>
<div class="bar">%s<div class="note">%s</div></div></div>""" % (bg, pos, e(c['tag']), e(c['title']), head, e(c['sub']), st, foot, e(c.get('note', '')))
    css = """
.pos{background:radial-gradient(120% 70% at 50% 0%,#fbf4e8 0%,#f3e5cd 55%,#e9d3b2 100%);color:#3a2412}
.pos .beam{position:absolute;inset:0;background:linear-gradient(115deg,transparent 52%,rgba(255,255,255,.55) 62%,transparent 72%);pointer-events:none}
.pos .ph{position:absolute;left:0;right:0;bottom:0;height:820px;background-size:cover;-webkit-mask-image:linear-gradient(180deg,rgba(0,0,0,0) 0%,rgba(0,0,0,.04) 8%,rgba(0,0,0,.12) 16%,rgba(0,0,0,.26) 24%,rgba(0,0,0,.45) 32%,rgba(0,0,0,.66) 40%,rgba(0,0,0,.84) 48%,rgba(0,0,0,.95) 56%,#000 64%);mask-image:linear-gradient(180deg,rgba(0,0,0,0) 0%,rgba(0,0,0,.04) 8%,rgba(0,0,0,.12) 16%,rgba(0,0,0,.26) 24%,rgba(0,0,0,.45) 32%,rgba(0,0,0,.66) 40%,rgba(0,0,0,.84) 48%,rgba(0,0,0,.95) 56%,#000 64%)}
.pos .ph:after{content:'';position:absolute;left:0;right:0;top:0;height:55%;background:linear-gradient(180deg,rgba(243,229,205,.9) 0%,rgba(243,229,205,.45) 45%,rgba(243,229,205,0) 100%)}
.pos .top{position:absolute;left:60px;right:60px;top:54px;text-align:center;display:flex;flex-direction:column;align-items:center}
.pos .brand{font:600 19px BVP;letter-spacing:.32em;color:#9a6a3a}
.pos .tag{margin-top:14px;font:600 24px CSC;letter-spacing:.12em;color:#5a3a1e}
.pos h1{margin:26px 0 4px;display:flex;flex-direction:column;align-items:center}
.pos .ln{display:flex;align-items:baseline;justify-content:center;gap:18px;white-space:nowrap;position:relative}
.pos .ln.over{margin-top:-26px;z-index:2}
.pos .l{display:inline-block;white-space:nowrap;filter:drop-shadow(0 1px 0 rgba(255,255,255,.7)) drop-shadow(0 3px 6px rgba(120,60,20,.18));-webkit-background-clip:text;background-clip:text;color:transparent;background-image:linear-gradient(180deg,#d39a5c 0%,#8a4a1c 55%,#b8783f 100%);font-variant-numeric:lining-nums}
.pos .script{font:400 96px/1.1 GV;padding:4px 18px 16px 10px;margin:0 -10px -10px 0}
.pos .cap{font:600 62px/1 CSC;letter-spacing:.05em}
.pos .plain{font:500 58px/1.1 CG;letter-spacing:.03em;padding-bottom:4px;background-image:linear-gradient(180deg,#a8693a,#6e3510)}
.pos .big{font:700 138px/.9 CSC;letter-spacing:.02em;background-image:linear-gradient(180deg,#e0aa6c 0%,#9a5524 45%,#6e3510 70%,#b97d45 100%)}
.pos .sub{margin:16px 0 0;font:500 26px/1.35 BVP;color:#6b4a2a}
.pos .stats{margin-top:26px;display:flex;justify-content:center}
.pos .st{padding:0 30px;text-align:center}.pos .st+.st{border-left:1.5px solid rgba(138,74,28,.35)}
.pos .st b{display:block;font:700 44px/1.05 CG;color:#8a4a1c;white-space:nowrap;font-variant-numeric:lining-nums}
.pos .st span{display:block;font:500 18px/1.3 BVP;color:#6b4a2a;margin-top:4px}
.pos .bar{position:absolute;left:36px;right:36px;bottom:32px;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:16px 22px;border-radius:22px;background:rgba(20,30,52,.72);backdrop-filter:blur(8px)}
.pos .foot b{color:#fff}.pos .foot span{color:#f0cf9a}
.pos .note{font:400 15px/1.35 BVP;color:#c9cfdb;text-align:right;max-width:420px}"""
else:
    if c.get('headline'):
        # Tiêu đề so le kiểu poster: mỗi dòng [chữ, kiểu script|cap|big, lệch ngang px]; ghép lại đọc thành từ khoá chính.
        head = '<h1 class="hl" aria-label="%s">%s</h1>' % (e(c['title']), ''.join(
            '<span class="l %s" style="margin-left:%dpx">%s</span>' % (k, int(dx), e(t)) for t, k, dx in c['headline']))
    else:
        head = (('<div class="scr">%s</div>' % e(c['script'])) if c.get('script') else '') + '<h1>%s</h1>' % e(c['title'])
    st = ''.join('<div class="st"><b>%s</b><span>%s</span></div>' % (e(a), e(b)) for a, b in stats[:4])
    it = ''.join('<li><i>%d</i><div><b>%s</b><span>%s</span></div></li>' % (k + 1, e(a), e(b)) for k, (a, b) in enumerate(items[:4]))
    body = '''<div class="card lux%s">
<div class="ph" style="background-image:url(%s);background-position:%s"><div class="tag">%s</div></div>
<div class="in">
 %s<p class="sub">%s</p>
 <div class="stats">%s</div>
 <ul>%s</ul>
 <div class="box">%s</div>
 <div class="bt">%s<p class="note">%s</p></div>
</div></div>''' % (' has-hl' if c.get('headline') else '', bg, pos, e(c['tag']), head, e(c['sub']), st, it, e(c.get('box', '')), foot, e(c.get('note', '')))
    css = '''
.lux.has-hl .ph{height:470px}
.lux.has-hl .in{top:532px}
.lux h1.hl{display:flex;flex-direction:column;align-items:flex-start;background:none;-webkit-background-clip:initial;color:inherit;margin:-6px 0 10px;padding:0}
.lux .hl .l{display:block;white-space:nowrap;-webkit-background-clip:text;color:transparent;background-image:linear-gradient(180deg,#c98d4e 0%,#7a3f18 60%,#a8693a 100%)}
.lux .hl .script{font:400 74px/1 GV;padding:4px 12px 8px 4px;margin-bottom:-14px;background-image:linear-gradient(180deg,#d6a066,#8e5222)}
.lux .hl .cap{font:600 50px/1.05 CSC;letter-spacing:.02em}
.lux .hl .big{font:700 92px/.98 CSC;letter-spacing:.01em}
.lux .scr{font:400 66px/1 GV;margin:0 0 -8px -4px;background:linear-gradient(180deg,#d29a5f,#8e5222);-webkit-background-clip:text;color:transparent;padding:6px 10px 10px 4px}
.lux{background:#f7f2e8;color:#14233f}
.lux .ph{position:absolute;left:36px;right:36px;top:36px;height:560px;border-radius:28px;background-size:cover;box-shadow:0 18px 40px rgba(20,35,63,.18)}
.lux .tag{position:absolute;left:26px;top:26px;font:600 20px BVP;letter-spacing:.14em;text-transform:uppercase;padding:11px 20px;border-radius:999px;background:rgba(247,242,232,.92);color:#8a6a2b}
.lux .in{position:absolute;left:64px;right:64px;top:630px;bottom:36px;display:flex;flex-direction:column}
.lux h1{font:700 64px/1.02 CSC;margin:0 0 12px;letter-spacing:.01em;background:linear-gradient(180deg,#b97a45 0%,#7a3f18 55%,#a8693a 100%);-webkit-background-clip:text;color:transparent;padding-bottom:4px}
.lux .sub{font:500 27px/1.35 BVP;color:#9a7433;margin:0 0 24px}
.lux .stats{display:grid;grid-template-columns:repeat(4,1fr);border-top:1.5px solid #d9c9a6;border-bottom:1.5px solid #d9c9a6;margin-bottom:22px}
.lux .st{padding:18px 8px;text-align:center}.lux .st+.st{border-left:1px solid #e3d6b9}
.lux .st b{display:block;font:700 36px/1.1 CG;color:#9a5a28;white-space:nowrap;font-variant-numeric:lining-nums}
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
await p.evaluate(()=>document.querySelectorAll('.pos .ln').forEach(l=>{const w=l.scrollWidth;if(w>960){const k=960/w;l.querySelectorAll('.l').forEach(x=>{x.style.fontSize=(parseFloat(getComputedStyle(x).fontSize)*k)+'px';});}}));
const o=await p.evaluate(()=>[...document.querySelectorAll('.lux h1:not(.hl),.sub,.st b,li b,li span,.box')].filter(e=>e.scrollWidth>e.clientWidth+1||e.getBoundingClientRect().right>1080).map(e=>e.textContent));
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
