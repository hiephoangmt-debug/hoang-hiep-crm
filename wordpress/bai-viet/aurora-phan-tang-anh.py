"""Sơ đồ phân tầng tháp Aurora (tháp biểu tượng Đà Nẵng Downtown, Sun Group) – đồ hoạ tự vẽ theo bố cục tài liệu
anh Hiệp gửi 15/11/2026: khổ dọc, tháp lớn bên trái (thân mảnh, khung đỉnh có vòm, tà cong trắng ở chân, khối đế mái cong
ven sông), nhãn tầng có đường chỉ, bảng chức năng bên phải, nền hoàng hôn – sông Hàn. Không dùng ảnh gốc vì có chữ chìm
trang khác. Nhãn liên hệ qua scripts/dong-dau-anh.py. Dùng: python3 aurora-phan-tang-anh.py <thư mục ra>"""
import sys, math, importlib.util, os, random
from PIL import Image, ImageDraw, ImageFont, ImageFilter

O = sys.argv[1]
HERE = os.path.dirname(os.path.abspath(__file__))
spec = importlib.util.spec_from_file_location('dd', HERE.rsplit('/', 1)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
FD = f'{HERE}/fonts'
K = 1080 / 854            # vẽ theo hệ toạ độ 854 × 1280 của bố cục gốc rồi phóng lên 1080 × 1620
S = 2
W, H = 1080, 1620
Q = lambda v: int(round(v * K * S))
P = lambda *v: tuple(Q(x) for x in v)


def serif(z, w=600):
    f = ImageFont.truetype(f'{FD}/CormorantGaramond[wght].ttf', Q(z)); f.set_variation_by_axes([w]); return f


def sans(z, w='SemiBold'):
    return ImageFont.truetype(f'{FD}/BeVietnamPro-{w}.ttf', Q(z))


NAVY = (24, 44, 82); INK = (28, 32, 44)
# (y trên, y dưới trên tháp, nhãn, chức năng, số lượng, màu)
G = [
    (110, 145, 'TẦNG MÁI', 'Bể nước và phòng kỹ thuật', '–', (150, 158, 176)),
    (145, 178, 'TẦNG 68 – 69', 'Căn hộ Penthouse siêu sang', '2 căn (1 căn/tầng)', (222, 178, 40)),
    (178, 208, 'TẦNG 67', 'Phòng lưu trú du lịch + Sky Bar', '14 phòng lưu trú', (150, 70, 200)),
    (208, 418, 'TẦNG 44 – 66', 'Phòng lưu trú du lịch', '368 phòng (16 phòng/tầng)', (40, 100, 210)),
    (418, 452, 'TẦNG 43', 'Phòng lưu trú du lịch + Sky Bar', '14 phòng lưu trú', (150, 70, 200)),
    (452, 635, 'TẦNG 28 – 42', 'Căn hộ cao cấp', '240 căn hộ (16 căn/tầng)', (50, 170, 70)),
    (635, 668, 'TẦNG 24 – 27', 'Trung tâm mua sắm cao cấp', '–', (236, 90, 170)),
    (668, 692, 'TẦNG 23', 'Nhà hàng ẩm thực', '–', (246, 140, 30)),
    (692, 885, 'TẦNG 11 – 22', 'Căn hộ cao cấp', '264 căn hộ (22 căn/tầng)', (30, 175, 165)),
    (885, 930, 'TẦNG 6 – 10', 'Nhà hàng ẩm thực cao cấp & phòng yoga', '–', (232, 184, 40)),
    (930, 975, 'TẦNG 5', 'Không gian hội nghị & rạp chiếu phim', '–', (50, 100, 210)),
    (975, 1020, 'TẦNG 4', 'Trưng bày, hội nghị, gym, spa, mua sắm', '–', (30, 165, 155)),
    (1020, 1140, 'TẦNG 1 – 3', 'Trung tâm thương mại dịch vụ khối đế', '–', (236, 84, 60)),
]


def bez(p0, p1, p2, p3, n=90):
    return [tuple((1 - t) ** 3 * p0[i] + 3 * (1 - t) ** 2 * t * p1[i] + 3 * (1 - t) * t ** 2 * p2[i] + t ** 3 * p3[i] for i in range(2)) for t in (j / n for j in range(n + 1))]


# ---------------- nền: trời hoàng hôn, mây, núi, sông
im = Image.new('RGB', (W * S, H * S)); d = ImageDraw.Draw(im)
HZ, RIV = 1090, 1185
for yy in range(H * S):
    y = yy / S / K
    if y < RIV:
        t = min(1, y / HZ)
        a, b, c = (176, 206, 236), (236, 226, 222), (252, 206, 150)
        col = tuple(int(a[i] + (b[i] - a[i]) * t / 0.6) if t < 0.6 else int(b[i] + (c[i] - b[i]) * (t - 0.6) / 0.4) for i in range(3))
    else:
        t = (y - RIV) / (1280 - RIV)
        col = (int(96 + 30 * (1 - t)), int(110 + 20 * (1 - t)), int(140 - 10 * t))
    d.line([(0, yy), (W * S, yy)], fill=col)
cl = Image.new('RGBA', im.size, (0, 0, 0, 0)); gc = ImageDraw.Draw(cl)
random.seed(4)
for cx, cy, rw in ((120, 230, 160), (90, 520, 200), (700, 1030, 260), (160, 860, 180), (470, 1040, 200)):
    for _ in range(14):
        ox, oy, r = random.uniform(-rw, rw), random.uniform(-18, 18), random.uniform(28, 60)
        gc.ellipse(P(cx + ox - r * 1.8, cy + oy - r * 0.6, cx + ox + r * 1.8, cy + oy + r * 0.6), fill=(255, 255, 255, 34))
cl = cl.filter(ImageFilter.GaussianBlur(Q(10))); im.paste(cl, (0, 0), cl)
d = ImageDraw.Draw(im, 'RGBA')
mt = [(0, 1130)] + [(x, 1092 - 34 * math.sin(x / 95) ** 2 - 22 * math.sin(x / 41 + 1) ** 2) for x in range(0, 860, 6)] + [(854, 1185), (0, 1185)]
d.polygon([P(x, y) for x, y in mt], fill=(150, 150, 170, 255))
# cầu Rồng (bên trái, mờ xa)
arc = bez((0, 1168), (30, 1120), (90, 1120), (130, 1168), 40)
d.line([P(*q) for q in arc], fill=(210, 170, 70, 230), width=Q(4))
d.line([P(0, 1170), P(150, 1170)], fill=(120, 110, 120, 255), width=Q(5))
# cao ốc ven sông bên phải (có vườn mái)
for x0, x1, top in ((600, 690, 1040), (700, 800, 1010), (805, 854, 1060)):
    d.rectangle(P(x0, top, x1, 1175), fill=(140, 98, 78, 255))
    for yy in range(int(top) + 12, 1168, 12):
        for xx in range(x0 + 6, x1 - 6, 10):
            if (xx * 7 + yy * 3) % 5:
                d.rectangle(P(xx, yy, xx + 5, yy + 6), fill=(255, 210, 140, 210))
    for xx in range(x0, x1, 14):
        d.ellipse(P(xx, top - 12, xx + 18, top + 4), fill=(60, 110, 60, 255))

# ---------------- tháp
TOP_FRAME, BASE = 50, 1150


def edges(y):
    """mép trái / phải thân tháp (hệ 854)."""
    L = 200 - 10 * (y - 110) / (885 - 110) if y <= 885 else 190 - 15 * ((y - 885) / (BASE - 885)) ** 1.6
    R = 352 if y <= 980 else 352 + 50 * ((y - 980) / (BASE - 980)) ** 2.2
    return L, R


glass = Image.new('RGBA', im.size, (0, 0, 0, 0)); gg = ImageDraw.Draw(glass)
for yy in range(Q(TOP_FRAME), Q(BASE)):
    y = yy / S / K; L, R = edges(y)
    for k in range(32):
        u = (k + 0.5) / 32
        sh = math.exp(-((u - 0.35) / 0.2) ** 2)
        gg.line([(Q(L + (R - L) * k / 32), yy), (Q(L + (R - L) * (k + 1) / 32), yy)], fill=(int(70 + 40 * sh), int(110 + 50 * sh), int(160 + 60 * sh), 255))
# lớp màu từng khối tầng (trong suốt để thấy kính)
band = Image.new('RGBA', im.size, (0, 0, 0, 0)); gbd = ImageDraw.Draw(band)
for y0, y1, _, _, _, col in G:
    for yy in range(Q(y0), Q(y1)):
        y = yy / S / K; L, R = edges(y)
        gbd.line([(Q(L), yy), (Q(R), yy)], fill=col + (205,))
glass.alpha_composite(band)
gg = ImageDraw.Draw(glass)
for y in range(110, BASE, 9):
    L, R = edges(y); gg.line([P(L, y), P(R, y)], fill=(255, 255, 255, 46), width=Q(1))
for k in range(1, 13):
    pts = [P(edges(y)[0] + (edges(y)[1] - edges(y)[0]) * k / 13, y) for y in range(110, BASE, 5)]
    gg.line(pts, fill=(255, 255, 255, 40), width=Q(1))
for y0, *_ in G:
    L, R = edges(y0); gg.line([P(L, y0), P(R, y0)], fill=(255, 255, 255, 170), width=Q(1.5))
# khung đỉnh + vòm sáng
gg.rectangle(P(200, TOP_FRAME, 352, 110), fill=(60, 100, 170, 255))
for k in range(1, 12):
    x = 200 + 152 * k / 12; gg.line([P(x, TOP_FRAME), P(x, 110)], fill=(255, 255, 255, 50), width=Q(1))
gg.rectangle(P(198, TOP_FRAME - 6, 354, TOP_FRAME), fill=(225, 232, 244, 255))
glow = Image.new('RGBA', im.size, (0, 0, 0, 0)); gw = ImageDraw.Draw(glow)
gw.rounded_rectangle(P(238, 78, 314, 205), Q(38), fill=(255, 236, 180, 150))
glow = glow.filter(ImageFilter.GaussianBlur(Q(4))); glass.alpha_composite(glow); gg = ImageDraw.Draw(glass)
gg.arc(P(232, 72, 320, 160), 180, 360, fill=(255, 244, 214, 255), width=Q(5))
gg.line([P(232, 116), P(232, 208)], fill=(255, 244, 214, 255), width=Q(5))
gg.line([P(320, 116), P(320, 208)], fill=(255, 244, 214, 255), width=Q(5))
# viền thân
gg.line([P(edges(y)[0], y) for y in range(TOP_FRAME, BASE + 1, 4)], fill=(255, 255, 255, 210), width=Q(1.5))
gg.line([P(edges(y)[1], y) for y in range(TOP_FRAME, BASE + 1, 4)], fill=(255, 255, 255, 210), width=Q(1.5))
# tà cong trắng: từ mép phải ~tầng 22 quét xuống chân trái
o1 = bez((352, 690), (346, 880), (250, 1050), (176, 1150))
o2 = bez((352, 716), (350, 900), (268, 1060), (196, 1150))
gg.polygon([P(*q) for q in o1 + o2[::-1]], fill=(250, 250, 253, 250))
o3 = bez((352, 975), (372, 1040), (395, 1100), (404, 1150))
gg.line([P(*q) for q in o3], fill=(250, 250, 253, 240), width=Q(4))
im.paste(glass, (0, 0), glass)
# khối đế mái cong ven sông
pod = bez((360, 1078), (440, 1050), (540, 1080), (600, 1150))
pg = Image.new('RGBA', im.size, (0, 0, 0, 0)); gp = ImageDraw.Draw(pg)
poly = [P(*q) for q in pod] + [P(360, 1150)]
gp.polygon(poly, fill=(246, 168, 96, 255))
for k in range(1, 26):
    x = 360 + 240 * k / 26; gp.line([P(x, 1150), P(x, 1040)], fill=(255, 232, 196, 110), width=Q(1))
for yv in (1100, 1125):
    gp.line([P(360, yv), P(600, yv)], fill=(255, 236, 206, 130), width=Q(1))
m = Image.new('L', im.size, 0); ImageDraw.Draw(m).polygon(poly, fill=255)
pg.putalpha(Image.composite(pg.split()[3], Image.new('L', im.size, 0), m))
im.paste(pg, (0, 0), pg)
d = ImageDraw.Draw(im, 'RGBA')
d.line([P(*q) for q in pod], fill=(255, 255, 255, 240), width=Q(3))
# kè ven sông + hàng dừa + đèn
d.rectangle(P(0, 1150, 854, 1185), fill=(120, 116, 120, 255))
d.line([P(0, 1150), P(854, 1150)], fill=(240, 220, 190, 255), width=Q(2))
for x in list(range(130, 175, 20)) + list(range(380, 600, 26)):
    d.line([P(x, 1150), P(x + 2, 1112)], fill=(80, 64, 44, 255), width=Q(2))
    for ang in range(-10, 360, 40):
        r = math.radians(ang)
        d.line([P(x + 2, 1112), P(x + 2 + 15 * math.cos(r), 1112 + 7 * math.sin(r) + 5)], fill=(40, 100, 56, 255), width=Q(2))
for x in range(0, 854, 21):
    d.ellipse(P(x, 1158, x + 3, 1161), fill=(255, 230, 160, 255))
# phản chiếu
refl = im.crop(P(150, 700, 620, 1150)).transpose(Image.FLIP_TOP_BOTTOM).filter(ImageFilter.GaussianBlur(Q(3)))
mask = Image.new('L', refl.size, 0); gm = ImageDraw.Draw(mask)
for yy in range(refl.size[1]):
    gm.line([(0, yy), (refl.size[0], yy)], fill=int(90 * max(0, 1 - yy / Q(95))))
im.paste(refl, P(150, 1185), mask)
d = ImageDraw.Draw(im, 'RGBA')

# ---------------- nhãn tầng bên trái, đường chỉ nét đứt
lf = sans(13.5, 'ExtraBold')
for y0, y1, lab, _, _, col in G:
    yc = 1062 if lab == 'TẦNG 1 – 3' else (y0 + y1) / 2
    L = edges(yc)[0]
    d.ellipse(P(22, yc - 6, 34, yc + 6), fill=(255, 255, 255, 255)); d.ellipse(P(24, yc - 4, 32, yc + 4), fill=col)
    d.text(P(42, yc), lab, font=lf, fill=NAVY, anchor='lm')
    x = 42 + d.textlength(lab, font=lf) / S / K + 6
    while x < L - 4:
        d.line([P(x, yc), P(min(x + 3, L - 4), yc)], fill=(70, 80, 100, 200), width=Q(1)); x += 6

# ---------------- tiêu đề
d.text(P(420, 46), 'SUN GROUP', font=sans(17, 'ExtraBold'), fill=(176, 124, 52), anchor='lm')
d.line([P(536, 26), P(536, 70)], fill=(176, 124, 52, 200), width=Q(1))
d.text(P(690, 18), 'AURORA', font=serif(60, 700), fill=(184, 132, 54), anchor='ma')
d.line([P(560, 100), P(632, 100)], fill=(184, 132, 54, 220), width=Q(1)); d.line([P(748, 100), P(820, 100)], fill=(184, 132, 54, 220), width=Q(1))
d.text(P(690, 100), 'ĐÀ NẴNG', font=serif(17, 600), fill=(150, 108, 48), anchor='mm')
d.text(P(618, 138), 'SƠ ĐỒ PHÂN TẦNG TIỆN ÍCH', font=sans(19, 'ExtraBold'), fill=NAVY, anchor='mm')
d.text(P(618, 162), 'Theo tài liệu giới thiệu dự án · tham khảo · hình minh hoạ', font=sans(9, 'Medium'), fill=(80, 84, 100), anchor='mm')

# ---------------- bảng
X0, X1, X2, X3 = 410, 530, 714, 826
TY = 186
d.rounded_rectangle(P(X0, TY, X3, TY + 38), Q(6), fill=(26, 50, 96, 245))
for xa, xb, t in ((X0, X1, 'PHÂN KHU TẦNG'), (X1, X2, 'CHỨC NĂNG CHI TIẾT'), (X2, X3, 'SỐ LƯỢNG\nCĂN HỘ / PHÒNG')):
    d.multiline_text(P((xa + xb) / 2, TY + 19), t, font=sans(9.5, 'ExtraBold'), fill='white', anchor='mm', align='center', spacing=Q(1))
RH = 49.5
y = TY + 40
for y0, y1, lab, fn, num, col in G:
    d.rectangle(P(X0, y, X3, y + RH - 2), fill=(255, 255, 255, 236))
    d.rectangle(P(X0, y, X1 - 2, y + RH - 2), fill=col + (255,))
    d.text(P((X0 + X1) / 2, y + RH / 2 - 1), lab, font=sans(11.5, 'ExtraBold'), fill='white', anchor='mm')
    ff = sans(10.5, 'Medium')
    lines, cur = [], ''
    for w_ in fn.split():
        t = (cur + ' ' + w_).strip()
        if d.textlength(t, font=ff) / S / K > X2 - X1 - 16 and cur: lines.append(cur); cur = w_
        else: cur = t
    lines = (lines + [cur])[:2]
    for j, l in enumerate(lines):
        d.text(P(X1 + 10, y + RH / 2 - 1 + (j - (len(lines) - 1) / 2) * 14), l, font=ff, fill=INK, anchor='lm')
    nf = sans(10, 'SemiBold')
    if '(' in num:
        a_, b_ = num.split(' (', 1)
        d.text(P((X2 + X3) / 2, y + RH / 2 - 8), a_, font=nf, fill=INK, anchor='mm')
        d.text(P((X2 + X3) / 2, y + RH / 2 + 7), '(' + b_, font=nf, fill=INK, anchor='mm')
    else:
        d.text(P((X2 + X3) / 2, y + RH / 2 - 1), num, font=nf, fill=INK, anchor='mm')
    y += RH
# tổng
y += 10
d.rounded_rectangle(P(X0, y, X3, y + 88), Q(8), fill=(255, 255, 255, 238), outline=(200, 170, 110, 255), width=Q(1))
cw = (X3 - X0) / 3
for i, (n, t) in enumerate((('504', 'CĂN HỘ CAO CẤP'), ('396', 'PHÒNG LƯU TRÚ'), ('2', 'CĂN PENTHOUSE'))):
    cx = X0 + cw * i + cw / 2
    d.text(P(cx, y + 8), n, font=serif(40, 700), fill=((30, 120, 70), (30, 60, 120), (184, 132, 54))[i], anchor='ma', features=['lnum'])
    d.text(P(cx, y + 62), t, font=sans(10, 'ExtraBold'), fill=NAVY, anchor='ma')
    if i:
        d.line([P(X0 + cw * i, y + 14), P(X0 + cw * i, y + 74)], fill=(210, 200, 180, 255), width=Q(1))
y += 98
d.rounded_rectangle(P(X0, y, X3, y + 32), Q(5), fill=(26, 50, 96, 245))
d.text(P((X0 + X3) / 2, y + 16), 'THÁP BIỂU TƯỢNG AURORA – CAO 408M | 69 TẦNG + MÁI', font=sans(11.5, 'ExtraBold'), fill='white', anchor='mm')

p = f'{O}/da-nang-downtown-thap-aurora-dang-toa-3.jpg'
im.resize((W, H), Image.LANCZOS).save(p, quality=90)
print(p, dd.stamp(p, tile=False))
