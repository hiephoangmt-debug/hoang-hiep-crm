"""Sơ đồ phân tầng tháp Aurora (tháp biểu tượng Đà Nẵng Downtown, Sun Group) – đồ hoạ tự vẽ theo dáng tòa tháp
(thân thon dần, vòm đỉnh, cánh cong ở chân, khối đế ven sông), mỗi khối tầng một màu; không dùng ảnh gốc vì có chữ chìm trang khác.
Nhãn liên hệ qua scripts/dong-dau-anh.py. Dùng: python3 aurora-phan-tang-anh.py <thư mục ra>"""
import sys, math, importlib.util, os
from PIL import Image, ImageDraw, ImageFont, ImageFilter

O = sys.argv[1]
HERE = os.path.dirname(os.path.abspath(__file__))
spec = importlib.util.spec_from_file_location('dd', HERE.rsplit('/', 1)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
FD = f'{HERE}/fonts'
S = 2
W, H = 1600, 1200


def serif(z, w=600):
    f = ImageFont.truetype(f'{FD}/CormorantGaramond[wght].ttf', z * S); f.set_variation_by_axes([w]); return f


def sans(z, w='SemiBold'):
    return ImageFont.truetype(f'{FD}/BeVietnamPro-{w}.ttf', z * S)


NAVY = (22, 40, 66); INK = (24, 30, 40)
# (tầng thấp, tầng cao, nhãn tầng, chức năng, số lượng, màu)
G = [
    (70, 70, 'TẦNG MÁI', 'Bể nước và phòng kỹ thuật', '–', (150, 160, 178)),
    (68, 69, 'TẦNG 68 – 69', 'Căn hộ penthouse siêu sang', '2 căn (1 căn/tầng)', (214, 170, 52)),
    (67, 67, 'TẦNG 67', 'Phòng lưu trú du lịch + Sky Bar', '14 phòng', (140, 82, 196)),
    (44, 66, 'TẦNG 44 – 66', 'Phòng lưu trú du lịch', '368 phòng (16 phòng/tầng)', (40, 110, 200)),
    (43, 43, 'TẦNG 43', 'Phòng lưu trú du lịch + Sky Bar', '14 phòng', (140, 82, 196)),
    (28, 42, 'TẦNG 28 – 42', 'Căn hộ cao cấp', '240 căn (16 căn/tầng)', (60, 160, 84)),
    (24, 27, 'TẦNG 24 – 27', 'Trung tâm mua sắm cao cấp', '–', (226, 92, 154)),
    (23, 23, 'TẦNG 23', 'Nhà hàng ẩm thực', '–', (238, 138, 40)),
    (11, 22, 'TẦNG 11 – 22', 'Căn hộ cao cấp', '264 căn (22 căn/tầng)', (32, 166, 160)),
    (6, 10, 'TẦNG 6 – 10', 'Nhà hàng ẩm thực cao cấp, phòng yoga', '–', (222, 178, 50)),
    (5, 5, 'TẦNG 5', 'Không gian hội nghị, rạp chiếu phim', '–', (48, 100, 196)),
    (4, 4, 'TẦNG 4', 'Trưng bày, hội nghị, gym, spa, mua sắm', '–', (38, 160, 150)),
    (1, 3, 'TẦNG 1 – 3', 'Trung tâm thương mại dịch vụ khối đế', '–', (232, 88, 60)),
]
P = lambda *v: tuple(int(x * S) for x in v)

# ---- nền trời hoàng hôn nhẹ + mặt sông
im = Image.new('RGB', (W * S, H * S)); d = ImageDraw.Draw(im)
WATER = 1040
for y in range(H * S):
    t = y / (WATER * S)
    if y < WATER * S:
        a, b = (214, 230, 246), (250, 234, 214)
        c = tuple(int(a[i] + (b[i] - a[i]) * min(1, t) ** 1.6) for i in range(3))
    else:
        tt = (y - WATER * S) / ((H - WATER) * S)
        c = tuple(int(x) for x in ((70, 110, 150) if tt > 0 else (90, 130, 168)))
        c = tuple(int(c[i] * (1 - 0.25 * tt)) for i in range(3))
    d.line([(0, y), (W * S, y)], fill=c)
# núi xa
mt = [(0, 900)] + [(x, 900 - 70 * math.sin(x / 210) ** 2 - 30 * math.sin(x / 57 + 1) ** 2) for x in range(0, 760, 8)] + [(760, 1040), (0, 1040)]
d.polygon([P(x, y) for x, y in mt], fill=(176, 186, 204))

# ---- tháp (dáng theo phối cảnh: thân mảnh thon dần, khung đỉnh có vòm sáng, vạt cong trắng ở chân, khối đế kính ven sông)
def bez(p0, p1, p2, p3, n=80):
    return [tuple((1 - t) ** 3 * p0[i] + 3 * (1 - t) ** 2 * t * p1[i] + 3 * (1 - t) * t ** 2 * p2[i] + t ** 3 * p3[i] for i in range(2)) for t in (j / n for j in range(n + 1))]
CX, BASE, TOPF = 300, 1010, 128          # tâm tháp, chân tháp, mép trên tầng 70
NF = 70
fh = (BASE - TOPF) / NF
yof = lambda fl: BASE - fl * fh          # mép trên tầng fl
hw = lambda y: 90 - 18 * ((BASE - y) / (BASE - TOPF))   # nửa bề rộng thân: 90 ở chân, 72 ở đỉnh
wid = lambda y: 2 * hw(y)
# cao ốc nền bên phải (sau khối đế)
bg = Image.new('RGBA', im.size, (0, 0, 0, 0)); gb = ImageDraw.Draw(bg)
for x0, x1, top in ((470, 540, 800), (548, 612, 840), (420, 462, 880)):
    gb.rectangle(P(x0, top, x1, BASE), fill=(150, 112, 92, 255))
    for yy in range(top + 10, BASE - 6, 14):
        for xx in range(x0 + 6, x1 - 6, 12):
            if (xx * 7 + yy * 3) % 5:
                gb.rectangle(P(xx, yy, xx + 6, yy + 6), fill=(255, 214, 150, 200))
    gb.rectangle(P(x0, top - 8, x1, top), fill=(96, 120, 80, 255))
im.paste(bg, (0, 0), bg)
# màu theo tầng
colmap = {}
for lo, hi, _, _, _, col in G:
    for fl in range(lo, hi + 1):
        colmap[fl] = col
tower = Image.new('RGBA', im.size, (0, 0, 0, 0)); g = ImageDraw.Draw(tower)
for yy in range(int(TOPF * S), int(BASE * S)):
    y = yy / S; fl = min(NF, int((BASE - y) / fh) + 1); col = colmap[fl]
    L, R = (CX - hw(y)) * S, (CX + hw(y)) * S
    steps = 30
    for k in range(steps):
        u = (k + 0.5) / steps
        sh = math.exp(-((u - 0.38) / 0.22) ** 2)          # dải sáng phản chiếu
        edge = 1 - 0.28 * abs(u - 0.5) * 2                 # tối dần ra 2 mép (thân tròn góc)
        cc = tuple(min(255, int(col[i] * (0.62 + 0.3 * edge) + 95 * sh)) for i in range(3))
        g.line([(L + (R - L) * k / steps, yy), (L + (R - L) * (k + 1) / steps, yy)], fill=cc + (255,))
# vạch sàn + đố kính
for fl in range(0, NF):
    y = yof(fl); g.line([P(CX - hw(y), y), P(CX + hw(y), y)], fill=(255, 255, 255, 60), width=S)
for k in range(1, 14):
    u = k / 14
    pts = [P(CX - hw(y) + 2 * hw(y) * u, y) for y in range(int(TOPF), BASE + 1, 6)]
    g.line(pts, fill=(255, 255, 255, 40), width=S)
for lo, hi, *_ in G:
    y = yof(hi); g.line([P(CX - hw(y), y), P(CX + hw(y), y)], fill=(255, 255, 255, 170), width=2 * S)
# khung đỉnh: mái phẳng + vòm sáng lớn trong khung (tầng 64 – 70)
wt = hw(TOPF)
g.polygon([P(CX - wt, TOPF), P(CX - wt + 4, TOPF - 34), P(CX + wt - 4, TOPF - 34), P(CX + wt, TOPF)], fill=(60, 96, 156, 255))
for k in range(1, 12):
    x = CX - wt + 4 + (2 * wt - 8) * k / 12
    g.line([P(x, TOPF - 34), P(x, TOPF)], fill=(255, 255, 255, 50), width=S)
g.rectangle(P(CX - wt + 2, TOPF - 40, CX + wt - 2, TOPF - 34), fill=(226, 232, 242, 255))
ay0, ay1 = TOPF - 26, yof(63)
aw = wt - 14
glow = Image.new('RGBA', im.size, (0, 0, 0, 0)); gg = ImageDraw.Draw(glow)
gg.rounded_rectangle(P(CX - aw, ay0, CX + aw, ay1), int(aw * S), fill=(255, 226, 160, 70))
glow = glow.filter(ImageFilter.GaussianBlur(5 * S)); tower.alpha_composite(glow); g = ImageDraw.Draw(tower)
g.arc(P(CX - aw, ay0, CX + aw, ay0 + 2 * aw), 180, 360, fill=(255, 240, 205, 255), width=6 * S)
g.line([P(CX - aw, ay0 + aw), P(CX - aw, ay1)], fill=(255, 240, 205, 255), width=6 * S)
g.line([P(CX + aw, ay0 + aw), P(CX + aw, ay1)], fill=(255, 240, 205, 255), width=6 * S)
# viền thân
g.line([P(CX - hw(y), y) for y in range(int(TOPF), BASE + 1, 4)], fill=(255, 255, 255, 200), width=2 * S)
g.line([P(CX + hw(y), y) for y in range(int(TOPF), BASE + 1, 4)], fill=(255, 255, 255, 200), width=2 * S)
# vạt cong ở chân: phần kính loe ra bên trái + dải trắng cong (như tà áo dài)
yT = yof(24)
outer = bez((CX - 175, BASE), (CX - 120, 900), (CX - 30, 760), (CX + hw(yT) - 4, yT))
inner = bez((CX - 150, BASE), (CX - 96, 906), (CX - 8, 772), (CX + hw(yT) - 4, yT))
skirt = [P(*q) for q in outer] + [P(CX - hw(BASE), BASE)]
g.polygon(skirt, fill=(150, 196, 230, 150))
g.polygon([P(*q) for q in outer + inner[::-1]], fill=(252, 252, 254, 245))
r_out = bez((CX + 150, BASE), (CX + 128, 930), (CX + hw(yof(14)) + 6, 900), (CX + hw(yof(18)), yof(18)))
g.polygon([P(*q) for q in r_out] + [P(CX + hw(BASE), BASE)], fill=(150, 196, 230, 140))
g.line([P(*q) for q in r_out], fill=(252, 252, 254, 240), width=6 * S)
# khối đế kính cong ven sông
pod_top = bez((CX + 70, BASE - 70), (CX + 180, BASE - 104), (CX + 300, BASE - 70), (CX + 330, BASE))
podg = Image.new('RGBA', im.size, (0, 0, 0, 0)); gp = ImageDraw.Draw(podg)
gp.polygon([P(*q) for q in pod_top] + [P(CX + 70, BASE)], fill=(240, 160, 96, 255))
for k in range(1, 22):
    x = CX + 70 + 260 * k / 22
    gp.line([P(x, BASE - 2), P(x, BASE - 100)], fill=(255, 232, 196, 120), width=S)
for yy in (BASE - 24, BASE - 48):
    gp.line([P(CX + 70, yy), P(CX + 330, yy)], fill=(255, 236, 206, 140), width=S)
m = Image.new('L', im.size, 0); ImageDraw.Draw(m).polygon([P(*q) for q in pod_top] + [P(CX + 70, BASE)], fill=255)
podg.putalpha(Image.composite(podg.split()[3], Image.new('L', im.size, 0), m))
tower.alpha_composite(podg); g = ImageDraw.Draw(tower)
g.line([P(*q) for q in pod_top], fill=(255, 255, 255, 240), width=4 * S)
# hàng dừa
for x in range(CX + 90, CX + 330, 34):
    g.line([P(x, BASE), P(x + 2, BASE - 34)], fill=(70, 60, 40, 255), width=2 * S)
    for ang in range(0, 360, 45):
        r = math.radians(ang)
        g.line([P(x + 2, BASE - 34), P(x + 2 + 14 * math.cos(r), BASE - 34 + 7 * math.sin(r) + 4)], fill=(40, 96, 56, 255), width=2 * S)
im.paste(tower, (0, 0), tower)
# phản chiếu dưới nước
refl = tower.crop(P(0, BASE - 260, 620, BASE)).transpose(Image.FLIP_TOP_BOTTOM)
a = refl.split()[3].point(lambda v: int(v * 0.28)); refl.putalpha(a)
refl = refl.filter(ImageFilter.GaussianBlur(3 * S))
im.paste(refl, P(0, BASE + 30), refl)
d = ImageDraw.Draw(im, 'RGBA')
d.rectangle(P(0, WATER - 2, W, WATER + 2), fill=(255, 255, 255, 90))
# nhãn tầng bên trái
lf = sans(14, 'ExtraBold')
for lo, hi, lab, _, _, col in G:
    yc = (yof(hi) + yof(lo - 1)) / 2
    t = 'MÁI' if lo == 70 else (f'{lo}' if lo == hi else f'{lo}–{hi}')
    x0 = CX - hw(yc) - 14 - (60 if lo <= 10 else 0)
    if lo in (4, 23, 67):
        continue
    d.ellipse(P(x0 - 7, yc - 5, x0 + 3, yc + 5), fill=col)
    d.text(P(x0 - 14, yc), t, font=lf, fill=NAVY, anchor='rm')

# ---- tiêu đề
X = 640
d.text(P(X, 54), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', font=sans(17, 'ExtraBold'), fill=(30, 70, 112))
d.text(P(X, 84), 'Tháp Aurora', font=serif(66, 600), fill=(196, 140, 52))
d.text(P(X, 160), 'ĐÀ NẴNG DOWNTOWN · SƠ ĐỒ PHÂN TẦNG TIỆN ÍCH', font=serif(25, 600), fill=INK)
# ---- bảng
TY, RH = 212, 48
hdr = [(X, 'PHÂN KHU TẦNG'), (X + 230, 'CHỨC NĂNG'), (X + 640, 'SỐ LƯỢNG')]
d.rounded_rectangle(P(X - 10, TY, W - 50, TY + 40), 10 * S, fill=(28, 52, 92))
for x, t in hdr:
    d.text(P(x + 8, TY + 20), t, font=sans(15, 'ExtraBold'), fill='white', anchor='lm')
y = TY + 48
for lo, hi, lab, fn, num, col in G:
    d.rounded_rectangle(P(X - 10, y, W - 50, y + RH - 6), 8 * S, fill=(255, 255, 255, 225))
    d.rounded_rectangle(P(X - 10, y, X + 210, y + RH - 6), 8 * S, fill=col)
    d.text(P(X + 100, y + (RH - 6) / 2), lab, font=sans(17, 'ExtraBold'), fill='white', anchor='mm')
    d.text(P(X + 238, y + (RH - 6) / 2), fn, font=sans(17, 'Medium'), fill=INK, anchor='lm')
    d.text(P(X + 648, y + (RH - 6) / 2), num, font=sans(16, 'SemiBold'), fill=NAVY, anchor='lm')
    y += RH
# ---- tổng
y += 10
boxes = [('504', 'căn hộ cao cấp'), ('396', 'phòng lưu trú'), ('2', 'căn penthouse')]
bw = (W - 50 - (X - 10)) / 3
for i, (n, t) in enumerate(boxes):
    x0 = X - 10 + bw * i
    d.rounded_rectangle(P(x0 + 4, y, x0 + bw - 4, y + 92), 10 * S, fill=(255, 255, 255, 235), outline=(196, 160, 90), width=2 * S)
    d.text(P(x0 + bw / 2, y + 8), n, font=serif(52, 700), fill=(196, 104, 40), anchor='ma', features=['lnum'])
    d.text(P(x0 + bw / 2, y + 64), t, font=sans(16, 'SemiBold'), fill=INK, anchor='ma')
y += 104
d.rounded_rectangle(P(X - 10, y, W - 50, y + 44), 10 * S, fill=(28, 52, 92))
d.text(P((X - 10 + W - 50) / 2, y + 22), 'THÁP AURORA – CAO 408 M · 69 TẦNG + MÁI · THEO TÀI LIỆU GIỚI THIỆU, THAM KHẢO', font=sans(16, 'ExtraBold'), fill='white', anchor='mm')
# (ghi chú tham khảo nằm trong dải trên – tránh bị nhãn liên hệ che)
p = f'{O}/da-nang-downtown-thap-aurora-dang-toa-2.jpg'
im.resize((W, H), Image.LANCZOS).save(p, quality=90)
print(p, dd.stamp(p, tile=False))
