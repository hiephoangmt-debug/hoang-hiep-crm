# Sơ đồ mặt bằng Sunneva Island – tự vẽ minh họa (không theo tỉ lệ), bám bố cục mặt bằng tổng thể dự án:
# đảo Đồng Nò hướng Tây Bắc – Đông Nam, 3 phân khu, 2 cầu (Bắc: ra đường Chương D hướng biển; Nam: sang KĐT Nam Hòa Xuân).
import math, os
from PIL import Image, ImageDraw, ImageFont
W, H = 2000, 1377
img = Image.new('RGB', (W, H), '#bfe6f5'); d = ImageDraw.Draw(img)
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)

def inside(pt, poly):
    x, y = pt; c = False
    for i in range(len(poly)):
        x1, y1 = poly[i]; x2, y2 = poly[i - 1]
        if (y1 > y) != (y2 > y) and x < (x2 - x1) * (y - y1) / (y2 - y1) + x1: c = not c
    return c

# đất liền: bờ Bắc (đường Chương D), bờ Tây Nam (KĐT Nam Hòa Xuân), bờ Đông
d.polygon([(640, 0), (W, 0), (W, 470), (1800, 420), (1500, 320), (1250, 225), (900, 125)], fill='#cfe8c4')
d.polygon([(W, 470), (W, H), (1760, H), (1840, 1150), (1890, 900), (1880, 520)], fill='#cfe8c4')
d.polygon([(0, 690), (260, 700), (500, 830), (700, 960), (780, 1110), (900, 1290), (980, H), (0, H)], fill='#e4e4dc')
for pts in (((660, 0), (920, 140), (1260, 240), (1510, 335), (1810, 435), (W, 485)), ((0, 705), (255, 715), (490, 845), (690, 975), (765, 1120), (885, 1300), (960, H))):
    d.line(pts, fill='#9a9a9a', width=10)
d.line([(1890, 520), (1900, 900), (1850, 1150), (1775, H)], fill='#9a9a9a', width=10)

isl = [(230, 360), (290, 300), (420, 285), (700, 310), (1000, 360), (1250, 420), (1410, 490), (1570, 585), (1690, 690), (1755, 810), (1765, 930), (1725, 1040), (1645, 1120), (1525, 1165), (1385, 1165), (1250, 1115), (1100, 1010), (950, 935), (800, 870), (600, 790), (420, 705), (300, 610), (230, 500), (210, 420)]
d.polygon(isl, fill='#9ccc7d')
road = [(275, 375), (330, 325), (430, 315), (700, 338), (1000, 388), (1250, 450), (1400, 518), (1550, 605), (1655, 705), (1712, 815), (1720, 925), (1685, 1020), (1615, 1090), (1515, 1128), (1395, 1128), (1265, 1082), (1115, 980), (955, 905), (805, 840), (610, 760), (440, 678), (330, 590), (268, 495), (255, 425)]
d.polygon(road, fill='#d6d6d6')

C = {'sl': '#f08a3c', 'dl': '#4aa8e0', 'th': '#f5e03a'}
HAB = [(320, 330), (1240, 452), (1240, 492), (1160, 498), (895, 845), (335, 572), (300, 385)]
CEN = [(1168, 500), (1278, 548), (1012, 888), (902, 850)]
RIV = [(1272, 466), (1622, 735), (1718, 900), (1680, 1040), (1550, 1118), (1400, 1118), (1015, 895), (1285, 548)]
TIP = (1530, 895)

def lot(cx, cy, ang, w, h, col):
    ca, sa = math.cos(ang), math.sin(ang)
    pts = [(cx + dx*ca - dy*sa, cy + dx*sa + dy*ca) for dx, dy in ((-w/2, -h/2), (w/2, -h/2), (w/2, h/2), (-w/2, h/2))]
    d.polygon(pts, fill=col, outline='white')

# dãy ven sông phía Bắc (Habora 1 – 71 → sát chân cầu Bắc; Rivera 2 – 38 phía Đông cầu)
def row(p, q, n, col, w, h, off):
    ang = math.atan2(q[1]-p[1], q[0]-p[0]); nx, ny = -math.sin(ang), math.cos(ang)
    for i in range(n):
        t = (i + .5) / n; lot(p[0] + (q[0]-p[0])*t + nx*off, p[1] + (q[1]-p[1])*t + ny*off, ang, w, h, col if i else C['dl'])
row((335, 350), (1225, 468), 34, C['sl'], 24, 38, 0)
row((1290, 488), (1600, 730), 12, C['sl'], 24, 38, 0)
# các dãy chéo theo trục Ánh Dương (hướng Tây Nam – Đông Bắc)
dirv = (0.414, -0.910); perp = (0.910, 0.414); ANG = math.atan2(dirv[1], dirv[0])
def strips(zone, start, n, gap, kinds, skip=()):
    for s in range(n):
        if s in skip: continue
        base = (start[0] + perp[0]*gap*s, start[1] + perp[1]*gap*s)
        for half, k in ((-19, kinds(s)), (19, kinds(s))):
            pts = []
            for j in range(-30, 30):
                c = (base[0] + perp[0]*half + dirv[0]*j*27, base[1] + perp[1]*half + dirv[1]*j*27)
                if inside(c, zone) and math.dist(c, TIP) > 235: pts.append(c)
            for i, c in enumerate(pts):
                lot(c[0], c[1], ANG, 25, 36, C['dl'] if i in (0, len(pts)-1) else C[k])
strips([(300, 400), (1170, 512), (895, 845), (335, 572)], (330, 420), 12, 76, lambda s: 'sl', skip=(4,))
strips(CEN, (940, 610), 3, 76, lambda s: 'th' if s != 1 else 'sl')
strips([(1300, 548), (1585, 772), (1718, 900), (1680, 1040), (1550, 1118), (1400, 1118), (1015, 895)], (1080, 780), 6, 82, lambda s: 'sl')
# mũi đảo: vòng biệt thự đơn lập ngoài, song lập trong, công viên giữa
for a in range(-75, 200, 13):
    t = math.radians(a); lot(TIP[0] + 175*math.cos(t), TIP[1] + 175*math.sin(t), t + math.pi/2, 34, 44, C['dl'])
for a in range(-60, 190, 18):
    t = math.radians(a); lot(TIP[0] + 115*math.cos(t), TIP[1] + 115*math.sin(t), t + math.pi/2, 28, 34, C['sl'])
d.ellipse((TIP[0]-70, TIP[1]-70, TIP[0]+70, TIP[1]+70), fill='#7cbf5a')
# công viên trong Habora
d.polygon([(700, 560), (790, 470), (840, 500), (760, 640)], fill='#7cbf5a')
# viền phân khu
for z, col in ((HAB, '#1f3fbf'), (CEN, '#c0249a'), (RIV, '#c62828')):
    d.line(z + [z[0]], fill=col, width=6, joint='curve')

# cầu: Bắc (chân cầu giữa dãy Habora và Rivera → đường Chương D), Nam (góc Habora – Centria → KĐT Nam Hòa Xuân)
def bridge(p, q):
    d.line([p, q], fill='#7a7a7a', width=34); d.line([p, q], fill='#c9c9c9', width=24)
    d.line([p, q], fill='#ffffff', width=2)
bridge((1252, 445), (1318, 150))
bridge((905, 885), (765, 1115))
d.line([(1318, 150), (1340, 40)], fill='#c9c9c9', width=24)

def tag(x, y, text, col='#333', size=28, bold=True, rot=0, bg='white'):
    f = F(size, bold); w = d.textlength(text, font=f)
    if bg: d.rounded_rectangle((x - w/2 - 12, y - size*0.75, x + w/2 + 12, y + size*0.75), 10, fill=bg, outline=col, width=3)
    d.text((x, y), text, font=f, fill=col, anchor='mm')
tag(1500, 150, 'Cầu → đường Chương D, hướng đi biển', size=30)
tag(745, 1235, 'Cầu → KĐT Nam Hòa Xuân', size=28)
tag(560, 520, 'HABORA', '#1f3fbf', 38)
tag(1080, 700, 'CENTRIA', '#c0249a', 34)
tag(1330, 820, 'RIVERA', '#c62828', 38)
for x, y in ((520, 210), (1810, 640), (1250, 1250)):
    tag(x, y, 'Sông Đô Toả', '#2b6f99', 34, False, bg=None)
tag(1530, 895, 'Công viên', '#2e6b1f', 22, False, bg=None)

# tiêu đề, chú thích
d.rounded_rectangle((30, 28, 940, 140), 16, fill='white')
d.text((56, 40), 'SƠ ĐỒ MẶT BẰNG SUNNEVA ISLAND', font=F(44, True), fill='#0d3b66')
d.text((56, 96), 'Đảo Đồng Nò, Hòa Quý (Ngũ Hành Sơn) · 3 phân khu · 2 cầu', font=F(28), fill='#333')
x0, y0 = 30, 760
d.rounded_rectangle((x0, y0 + 300, 520, H - 70), 16, fill='white')
yy = y0 + 318
d.text((x0+24, yy), 'Chú thích', font=F(30, True), fill='#0d3b66')
for i, (k, t) in enumerate((('th', 'Townhouse'), ('sl', 'Biệt thự song lập'), ('dl', 'Biệt thự đơn lập'))):
    y = yy + 50 + i*40; d.rectangle((x0+24, y, x0+64, y+28), fill=C[k]); d.text((x0+80, y+14), t, font=F(25), fill='#222', anchor='lm')
for i, (col, t) in enumerate((('#1f3fbf', 'Habora'), ('#c0249a', 'Centria'), ('#c62828', 'Rivera'))):
    x = x0 + 24 + i*160; y = yy + 178; d.rectangle((x, y+4, x+34, y+26), outline=col, width=5); d.text((x+44, y+15), t, font=F(24), fill='#222', anchor='lm')
d.rectangle((0, H-56, W, H), fill='white')
d.text((30, H-28), 'Sơ đồ minh họa, không theo tỉ lệ – vẽ lại theo bố cục mặt bằng tổng thể dự án. Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(25), fill='#333', anchor='lm')

img = img.resize((1600, 1102), Image.LANCZOS)
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'sunneva-island', 'sunneva-island-so-do-mat-bang.jpg')
img.save(out, quality=88); print(out)
