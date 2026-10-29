"""Trình bày mặt bằng 3D kiểu bản vẽ bán hàng: nền xám nhạt, đường kích thước (mm), nhãn loại căn, sơ đồ vị trí căn trên tầng.
Dùng: python3 compose_top.py <thư mục render (có top.png, top.json)> <tên: 30-07 | T-03 | G3-03 | G2-01> <ảnh ra .png>"""
import json, math, os, sys
from PIL import Image, ImageDraw, ImageFont
S = os.path.dirname(os.path.abspath(__file__)); C = json.load(open(S + '/ccl2.json'))
d, name, out = sys.argv[1], sys.argv[2], sys.argv[3]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'; FR = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
NAVY, ORANGE, BG = (10, 37, 64), (232, 92, 30), (226, 226, 224)
T30 = {'07': '1PN+1', '08': '1PN', '09': '1PN+1', '10': '1PN', '11': '1PN+1', '06': '2PN', '05': '1PN', '03A': '1PN', '03': '1PN+1', '02': '1PN+1', '01': '1PN',
       '16': '1PN+1', '15': '1PN', '12B': '1PN', '12A': '1PN', '12': '1PN'}
LBL = {'STU': 'STUDIO', 'STUL': 'STUDIO', '1PN': '1 PHÒNG NGỦ', '1PN+1': '1 PHÒNG NGỦ +', '2PN': '2 PHÒNG NGỦ', '2PN1': '2 PHÒNG NGỦ'}
k, uid = name.split('-', 1); fl = '30' if k == '30' else None
parts_all = C['u30'] if k == '30' else C['u']
lay = max(parts_all[uid], key=lambda p: C['spec'][p[0]]['W'] * C['spec'][p[0]]['D'])[0]
typ = T30.get(uid, lay) if k == '30' else lay
code = ('SP30' + uid) if k == '30' else ('Căn mã ' + uid + (' · tầng 3' if k == 'G3' else ' · tầng 2' if k == 'G2' else ' · tầng 3A–29'))

im = Image.open(d + '/top.png').convert('RGBA'); W0, H0 = im.size
J = json.load(open(d + '/top.json'))
cv = Image.new('RGBA', (W0, H0), BG + (255,)); cv.alpha_composite(im); g = ImageDraw.Draw(cv)
# đường kích thước
for p0, p1, mm in J['dims']:
    g.line([tuple(p0), tuple(p1)], fill=(20, 20, 20, 255), width=3)
    ang = math.atan2(p1[1] - p0[1], p1[0] - p0[0]); nx, ny = -math.sin(ang), math.cos(ang)
    for q in (p0, p1): g.line([(q[0] - nx * 12 - math.cos(ang) * 6, q[1] - ny * 12 - math.sin(ang) * 6), (q[0] + nx * 12 + math.cos(ang) * 6, q[1] + ny * 12 + math.sin(ang) * 6)], fill=(20, 20, 20, 255), width=3)
    t = str(int(round(mm / 50.0) * 50)); f = ImageFont.truetype(FR, 30); tw, th = g.textbbox((0, 0), t, font=f)[2:]
    tl = Image.new('RGBA', (tw + 8, th + 8), (0, 0, 0, 0)); ImageDraw.Draw(tl).text((4, 0), t, font=f, fill=(20, 20, 20, 255))
    a = -math.degrees(ang)
    if a < -90 or a > 90: a += 180
    tl = tl.rotate(a, expand=True, resample=Image.BICUBIC)
    mx, my = (p0[0] + p1[0]) / 2, (p0[1] + p1[1]) / 2; sgn = 1 if ny > 0 else -1
    cv.alpha_composite(tl, (int(mx + nx * 28 * sgn - tl.size[0] / 2), int(my + ny * 28 * sgn - tl.size[1] / 2)))
# tiêu đề dự án (chữ, không dùng logo)
g.text((48, 38), 'Sun Saphia', font=ImageFont.truetype(F, 46), fill=ORANGE + (255,)); g.text((48, 92), 'RESIDENCE · ĐÀ NẴNG', font=ImageFont.truetype(F, 22), fill=NAVY + (255,))
# nhãn loại căn
f1 = ImageFont.truetype(F, 40); f2 = ImageFont.truetype(F, 20); t1 = LBL.get(typ, typ)
w1 = max(g.textbbox((0, 0), t1, font=f1)[2], g.textbbox((0, 0), code, font=f2)[2]) + 70
g.rectangle([48, H0 - 150, 48 + w1, H0 - 70], fill=ORANGE + (255,))
g.text((48 + 35, H0 - 145), t1, font=f1, fill=NAVY + (255,)); g.text((48 + 35, H0 - 98), code, font=f2, fill=NAVY + (255,))
# sơ đồ vị trí căn trên tầng: vẽ lại từ đúng hình các căn (đo theo bản vẽ CĐT), căn đang xem tô đỏ (biển ở trên)
pk = 12.0; ONLY2 = ['01', '02', '03A', '03', '05', '06', '07', '08', '09', '10', '18', '19']
def ppoly(lay_, m): return [(m[0] * x + m[2] * y + m[4], m[1] * x + m[3] * y + m[5]) for x, y in C['spec'][lay_]['floor']]
allu = {uk: v for uk, v in parts_all.items() if not (k == 'G2' and uk not in ONLY2)}
PP = [q for v in allu.values() for lay_, m in v for q in ppoly(lay_, m)]
GD = C['gard']['T' + k[1]] if k in ('G3', 'G2') else {}
PP += [tuple(q) for gv in GD.values() for q in gv['poly']]
ou, ov = min(q[0] for q in PP) - 1, min(q[1] for q in PP) - 1; mw, mh = max(q[0] for q in PP) + 1 - ou, max(q[1] for q in PP) + 1 - ov
mini = Image.new('RGBA', (int(mw * pk), int(mh * pk)), (0, 0, 0, 0)); md = ImageDraw.Draw(mini)
T_ = lambda q: ((q[0] - ou) * pk, (q[1] - ov) * pk)
for gk, gv in GD.items(): md.polygon([T_(q) for q in gv['poly']], fill=(150, 205, 140, 255) if gk == uid else (210, 228, 204, 255), outline=(150, 170, 150, 255))
for uk, v in allu.items():
    for lay_, m in v: md.polygon([T_(q) for q in ppoly(lay_, m)], fill=(222, 40, 40, 255) if uk == uid else (238, 238, 236, 255), outline=(90, 90, 90, 255) if uk != uid else (120, 0, 0, 255))
KW = 300 if H0 > W0 else 340; mini = mini.resize((KW, round(mini.size[1] * KW / mini.size[0])), Image.LANCZOS); KH = mini.size[1]
kx, ky = (W0 - KW - 46, 78) if H0 > W0 else (W0 - KW - 56, H0 - KH - 110)
g.rounded_rectangle([kx - 12, ky - 12, kx + KW + 12, ky + KH + 12], 10, fill=(255, 255, 255, 240), outline=(170, 170, 170, 255))
cv.alpha_composite(mini, (kx, ky)); g = ImageDraw.Draw(cv)
g.text((kx, ky - 40), '↑ Biển Đông', font=ImageFont.truetype(F, 18), fill=NAVY + (255,))
g.text((W0 - 640 if W0 > 900 else 40, H0 - 50), 'Hình ảnh chỉ mang tính chất minh họa' + ('' if os.environ.get('CRM') else ' · 0904567009'), font=ImageFont.truetype(FR, 20), fill=(30, 30, 30, 255))
cv.convert('RGB').save(out)
