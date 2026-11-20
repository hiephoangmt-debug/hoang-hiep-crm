"""Mẫu ảnh "NẮNG CAM" (anh Hiệp 20/11/2026: làm mẫu mới theo kiểu bộ ảnh Sun Saphia của chủ đầu tư):
nền kem – cam nhạt, tiêu đề chữ khối cực lớn màu cam → đỏ, nhãn xanh, ảnh phối cảnh hoà vào nền phía dưới.
Thương hiệu Hoàng Hiệp, KHÔNG dùng logo chủ đầu tư / đại lý.
Chạy: python3 wordpress/bai-viet/the-nang-cam.py <cau-hinh.json> <anh-dai-dien.jpg> <out.jpg> [vuong|doc|tiktok]
  doc = 1080x1350 (mặc định, Facebook), vuong = 1080x1080, tiktok = 1080x1920.
Cấu hình:
{
 "project": "Sun Saphia",            chữ viết tay cam ở đầu ảnh (tuỳ chọn)
 "pill": "Tòa 30 tầng",              nhãn xanh (tuỳ chọn)
 "kicker": "DẤU ẤN",                 dòng nhỏ cam trên tiêu đề (tuỳ chọn)
 "lines": ["VEN BIỂN"],              tiêu đề chữ khối, mỗi phần tử 1 dòng (tự co cho vừa khung)
 "side": ["CĂN HỘ", "VEN BIỂN"],     2 dòng xanh đặt cạnh dòng tiêu đề đầu (tuỳ chọn, hợp con số lớn)
 "sub": "Sơn Thủy · Đà Nẵng",        dòng phụ xanh, căn phải (tuỳ chọn)
 "photo": "ảnh phối cảnh / ảnh thật", "photo_top": 0.42, "pos": "50% 50%",
 "note": "nguồn / ghi chú nhỏ"
}"""
import base64, html, json, os, subprocess, sys

CFG, AVA, OUT = sys.argv[1:4]
SIZE = sys.argv[4] if len(sys.argv) > 4 else 'doc'
W, H = 1080, {'doc': 1350, 'vuong': 1080, 'tiktok': 1920}[SIZE]
c = json.load(open(CFG, encoding='utf-8'))
HERE = os.path.dirname(os.path.abspath(__file__))
FD = os.path.join(HERE, 'fonts')
e = html.escape
R = {'vietnamese': 'U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB',
     'latin-ext': 'U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+1E00-1E9F,U+1EF2-1EFF', 'latin': 'U+0000-00FF,U+2000-206F,U+2190-21FF'}
faces = ''
for fam, key, ws in (('BVP', 'be-vietnam-pro', (500, 600, 700, 800, 900)), ('OS', 'oswald', (700,)), ('GV', 'great-vibes', (400,))):
    for w in ws:
        for sub, rng in R.items():
            f = f'{FD}/{key}-{w}-{sub}.woff2'
            if os.path.exists(f):
                faces += "@font-face{font-family:%s;font-weight:%d;src:url('file://%s');unicode-range:%s}\n" % (fam, w, f, rng)


def b64(p):
    return 'data:image/jpeg;base64,' + base64.b64encode(open(p, 'rb').read()).decode()


tt = SIZE == 'tiktok'
top0 = 150 if tt else 60                      # TikTok: chừa vùng trên cho thanh trạng thái
ptop = int(H * c.get('photo_top', 0.42))
lines = ''.join(f'<div class="ln"><span class="g">{e(x)}</span></div>' for x in c['lines'])
if c.get('side'):
    first, rest = c['lines'][0], c['lines'][1:]
    lines = (f'<div class="ln row"><span class="g">{e(first)}</span><div class="side">'
             + ''.join(f'<b>{e(s)}</b>' for s in c['side']) + '</div></div>'
             + ''.join(f'<div class="ln"><span class="g">{e(x)}</span></div>' for x in rest))
css = f"""*{{margin:0;box-sizing:border-box;font-variant-numeric:lining-nums}}
body{{width:{W}px;height:{H}px;position:relative;overflow:hidden;font-family:BVP;
background:radial-gradient(circle at 78% 18%,#fff6e6 0,rgba(255,246,230,0) 38%),linear-gradient(180deg,#fdf3e3 0%,#fbe6cc 55%,#f8d9b6 100%)}}
.ph{{position:absolute;left:0;right:0;top:{ptop}px;bottom:0;background:url({b64(c['photo'])}) center/cover;background-position:{c.get('pos', '50% 50%')}}}
.ph:before{{content:'';position:absolute;inset:0;background:linear-gradient(180deg,#fbe8cf 0%,rgba(251,232,207,.92) 8%,rgba(251,232,207,.55) 22%,rgba(251,232,207,0) 42%)}}
.top{{position:absolute;top:{top0}px;left:60px;right:60px;display:flex;justify-content:space-between;align-items:center}}
.brand{{font:800 24px BVP;letter-spacing:.16em;color:#1f4f9a}}
.proj{{font:400 56px GV;color:#e8731f;line-height:1}}
.head{{position:absolute;top:{top0 + 90}px;left:56px;right:56px}}
.pill{{display:inline-block;background:linear-gradient(180deg,#2b63c4,#1c479a);color:#fff;font:800 34px BVP;padding:12px 26px;border-radius:12px 12px 12px 0;margin-bottom:6px;box-shadow:0 8px 20px rgba(28,71,154,.25)}}
.kick{{font:700 64px OS;color:#ef7d1a;letter-spacing:.02em;line-height:1}}
.ln{{font:700 220px/0.98 OS;text-transform:uppercase;white-space:nowrap;letter-spacing:-.005em}}
.g{{background:linear-gradient(180deg,#f9a825 0%,#f27420 45%,#e2381f 100%);-webkit-background-clip:text;color:transparent;
padding:.12em .04em .02em;margin:-.12em -.04em -.02em;filter:drop-shadow(0 6px 10px rgba(226,56,31,.18))}}
.row{{display:flex;align-items:center;gap:26px}}
.side b{{display:block;font:900 54px/1.08 BVP;color:#1f4f9a;text-transform:uppercase}}
.sub{{margin-top:14px;text-align:right;font:700 34px/1.3 BVP;color:#1f4f9a}}
.foot{{position:absolute;left:40px;right:40px;bottom:{260 if tt else 40}px;display:flex;align-items:center;gap:18px;background:rgba(20,35,63,.82);border-radius:26px;padding:16px 22px;color:#fff}}
.foot img{{width:84px;height:84px;border-radius:50%;object-fit:cover;border:3px solid #f6c27a}}
.foot b{{display:block;font:800 32px BVP}}.foot span{{display:block;font:700 26px BVP;color:#f6c27a;margin-top:2px}}
.foot i{{margin-left:auto;max-width:330px;text-align:right;font:500 19px/1.35 BVP;font-style:normal;color:#dfe6f0}}"""
body = f"""<div class="ph"></div>
<div class="top"><div class="brand">HOÀNG HIỆP · BĐS ĐÀ NẴNG</div><div class="proj">{e(c.get('project', ''))}</div></div>
<div class="head">{f'<div class="pill">{e(c["pill"])}</div>' if c.get('pill') else ''}{f'<div class="kick">{e(c["kicker"])}</div>' if c.get('kicker') else ''}{lines}{f'<div class="sub">{e(c["sub"])}</div>' if c.get('sub') else ''}</div>
<div class="foot"><img src="{b64(AVA)}"><div><b>Hoàng Hiệp</b><span>Zalo 0904 567 009</span></div><i>{e(c.get('note', ''))}</i></div>"""
page = f'<!doctype html><meta charset="utf-8"><style>{faces}{css}</style><body>{body}</body>'
tmp = OUT + '.tmp.html'
open(tmp, 'w', encoding='utf-8').write(page)
js = """const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:%d,height:%d}});
await p.goto('file://'+process.argv[2]);await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(300);
await p.evaluate(()=>{const head=document.querySelector('.head');for(const ln of document.querySelectorAll('.ln')){let f=parseFloat(getComputedStyle(ln).fontSize);while(ln.scrollWidth>head.clientWidth+2&&f>60){f-=6;ln.style.fontSize=f+'px';}}});
const over=await p.evaluate(()=>{const h=document.querySelector('.head').getBoundingClientRect(),ph=document.querySelector('.ph').getBoundingClientRect();return h.bottom>ph.top+%d});if(over)console.log('CHU DE LEN ANH');
await p.screenshot({path:process.argv[3],type:'jpeg',quality:92});await b.close();})();""" % (W, H, int(H * 0.12))
open(tmp + '.js', 'w').write(js)
subprocess.run(['node', tmp + '.js', os.path.abspath(tmp), OUT], check=True)
os.remove(tmp); os.remove(tmp + '.js')
print('ok', OUT)
