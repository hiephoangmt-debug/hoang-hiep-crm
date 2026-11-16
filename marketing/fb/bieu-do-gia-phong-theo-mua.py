import os, subprocess, sys
OUT = sys.argv[1]
FD = '/home/user/hoang-hiep-crm/wordpress/bai-viet/fonts'
R = {'vietnamese': 'U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB',
     'latin-ext': 'U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+1E00-1E9F,U+1EF2-1EFF', 'latin': 'U+0000-00FF,U+2000-206F,U+2190-21FF'}
faces = ''
for fam, key, ws in (('BVP', 'be-vietnam-pro', (500, 600, 700)), ('CG', 'cormorant-garamond', (600, 700)), ('GV', 'great-vibes', (400,))):
    for w in ws:
        for sub, rng in R.items():
            f = f'{FD}/{key}-{w}-{sub}.woff2'
            if os.path.exists(f):
                faces += "@font-face{font-family:%s;font-weight:%d;src:url('file://%s');unicode-range:%s}\n" % (fam, w, f, rng)
rows = [("3 sao", "Mỹ Khê, An Thượng", [(0.4, 0.6), (0.6, 0.9), (0.9, 1.2)]),
        ("4 sao", "trục Võ Nguyên Giáp", [(1, 1.4), (1.4, 2), (2, 2.7)]),
        ("5 sao", "khách sạn ven biển", [(2, 2.6), (2.6, 3.4), (3.4, 4.5)]),
        ("Resort 5 sao", "Ngũ Hành Sơn", [(2.5, 3.5), (3.5, 5), (5, 8)])]
COL = ['#9cc9ea', '#3f88cc', '#c4561a']
X0, XW = 330, 680  # trục 0..8 triệu
def x(v): return X0 + v / 8 * XW
fmt = lambda v: ('%g' % v).replace('.', ',')
bars = ''
y = 505
for name, sub, segs in rows:
    bars += f'<div class="rn" style="top:{y+18}px"><b>{name}</b><span>{sub}</span></div>'
    for k, (a, b) in enumerate(segs):
        yy = y + k * 46
        bars += f'<div class="bar" style="left:{x(a):.0f}px;top:{yy}px;width:{x(b)-x(a):.0f}px;background:{COL[k]}"></div>'
        lab = f'{fmt(a)} – {fmt(b)}'
        if x(b) + 150 < 1040:
            bars += f'<div class="bl" style="left:{x(b)+12:.0f}px;top:{yy-6}px">{lab}</div>'
        else:
            bars += f'<div class="bl in" style="left:{x(a)+14:.0f}px;top:{yy-6}px">{lab}</div>'
    y += 160
grid = ''.join(f'<div class="g" style="left:{x(v):.0f}px"></div><div class="gl" style="left:{x(v)-20:.0f}px">{v}</div>' for v in range(0, 9))
HTML = f'''<!doctype html><meta charset="utf-8"><style>{faces}
*{{margin:0;box-sizing:border-box}}body{{width:1080px;height:1350px;position:relative;overflow:hidden;font-family:BVP;color:#14233f;
background:linear-gradient(180deg,#d9ecf9 0%,#eef6fc 45%,#ffffff 100%)}}
.brand{{position:absolute;top:44px;left:0;right:0;text-align:center;font:700 26px BVP;letter-spacing:.2em;color:#1f4f86}}
.tag{{position:absolute;top:88px;left:0;right:0;text-align:center;font:700 30px CG;letter-spacing:.16em;color:#14233f}}
.t1{{position:absolute;top:140px;left:0;right:0;text-align:center;font:600 64px CG;color:#14233f}}
.t2{{position:absolute;top:210px;left:0;right:0;text-align:center;font:700 92px/1 CG;letter-spacing:.02em;color:#c4561a;
background:linear-gradient(180deg,#e0701f,#b44d16);-webkit-background-clip:text;color:transparent;padding:.2em .1em .1em}}
.t3{{position:absolute;top:318px;left:560px;font:400 68px GV;color:#c4561a}}
.sub{{position:absolute;top:400px;left:0;right:0;text-align:center;font:700 32px BVP;color:#14233f}}
.lg{{position:absolute;top:452px;left:60px;right:60px;display:flex;justify-content:center;gap:34px;font:600 25px BVP;color:#3a4d66}}
.lg i{{display:inline-block;width:28px;height:18px;border-radius:5px;margin-right:9px;vertical-align:-1px}}
.g{{position:absolute;top:495px;height:650px;width:2px;background:rgba(20,35,63,.08)}}
.gl{{position:absolute;top:1150px;width:40px;text-align:center;font:600 24px BVP;color:#5a6b80}}
.unit{{position:absolute;top:1150px;left:{X0+XW+30}px;font:600 22px BVP;color:#5a6b80}}
.rn{{position:absolute;left:52px;width:275px}}.rn b{{display:block;font:700 33px BVP}}.rn span{{font:500 25px BVP;color:#4a5b70}}
.bar{{position:absolute;height:34px;border-radius:9px}}
.bl{{position:absolute;font:700 29px BVP;color:#14233f;white-space:nowrap}}.bl.in{{color:#fff}}
.note{{position:absolute;top:1188px;left:52px;right:52px;font:500 18px/1.42 BVP;color:#4a5b70}}
.foot{{position:absolute;left:40px;right:40px;bottom:16px;height:56px;white-space:nowrap;border-radius:18px;background:#14233f;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 28px;font:600 21px BVP}}.foot b{{color:#f2a25a}}
</style><body>
<div class="brand">HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG</div>
<div class="tag">THAM KHẢO · CĂN HỘ CHO THUÊ</div>
<div class="t1">Giá phòng khách sạn</div>
<div class="t2">GẦN BIỂN ĐÀ NẴNG</div>
<div class="t3">theo mùa</div>
<div class="sub">Giá 1 đêm, phòng tiêu chuẩn 2 người (triệu đồng)</div>
<div class="lg"><span><i style="background:{COL[0]}"></i>Thấp điểm T10 – T1</span><span><i style="background:{COL[1]}"></i>Trung bình T2 – T4, T9</span><span><i style="background:{COL[2]}"></i>Cao điểm T5 – T8, lễ</span></div>
{grid}{bars}
<div class="note">Ước tính theo mùa từ giá niêm yết trên Booking.com, Vietnambooking, Eholiday, Vivutour (11/2026); chưa gồm phí dịch vụ ở một số khách sạn, giá thay đổi theo ngày. Căn hộ không phải khách sạn: giá thuê thực tế thường thấp hơn; cho thuê theo đêm phải qua đơn vị đủ điều kiện kinh doanh lưu trú. Không phải cam kết doanh thu.</div>
<div class="foot"><span><b>Sun Saphia Residence</b> · ngay bãi tắm Sơn Thủy</span><span>Hoàng Hiệp · Zalo 0904 567 009</span></div>
</body>'''
open('c.html', 'w', encoding='utf-8').write(HTML)
js = "const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1350}});await p.goto('file://'+process.argv[2]);await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(300);await p.screenshot({path:process.argv[3],type:'jpeg',quality:92});await b.close();})();"
open('c.js', 'w').write(js)
subprocess.run(['node', 'c.js', os.path.abspath('c.html'), OUT], check=True)
