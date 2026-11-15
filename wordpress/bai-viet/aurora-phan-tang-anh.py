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

# ---- tháp
CX, BASE, TOPF = 300, 1010, 140          # tâm tháp, chân tháp, mép trên tầng 70
NF = 70
fh = (BASE - TOPF) / NF
yof = lambda fl: BASE - fl * fh          # mép trên tầng fl
wid = lambda y: 205 - 50 * ((BASE - y) / (BASE - TOPF)) ** 1.1   # thân thon dần
tower = Image.new('RGBA', im.size, (0, 0, 0, 0)); g = ImageDraw.Draw(tower)
for lo, hi, _, _, _, col in G:
    y0, y1 = yof(hi), yof(lo - 1)
    for yy in range(int(y0 * S), int(y1 * S)):
        y = yy / S; w = wid(y)
        # dải màu, sáng ở giữa (kính phản chiếu)
        L, R = (CX - w / 2) * S, (CX + w / 2) * S
        steps = 24
        for k in range(steps):
            u = (k + 0.5) / steps; sh = 1 - 0.35 * abs(u - 0.42) * 2
            cc = tuple(min(255, int(col[i] * (0.72 + 0.4 * sh) + 30 * sh)) for i in range(3))
            g.line([(L + (R - L) * k / steps, yy), (L + (R - L) * (k + 1) / steps, yy)], fill=cc + (255,))
    # vạch sàn
    for fl in range(lo - 1, hi):
        y = yof(fl); w = wid(y)
        g.line([P(CX - w / 2, y), P(CX + w / 2, y)], fill=(255, 255, 255, 70), width=S)
    # mép khối
    y = yof(hi); w = wid(y)
    g.line([P(CX - w / 2, y), P(CX + w / 2, y)], fill=(255, 255, 255, 200), width=2 * S)
# đố kính dọc
for k in range(1, 11):
    u = k / 11
    pts = [P(CX - wid(y) / 2 + wid(y) * u, y) for y in range(int(TOPF), BASE + 1, 6)]
    g.line(pts, fill=(255, 255, 255, 46), width=S)
# vòm đỉnh
wt = wid(TOPF); top_y = TOPF - 56
g.polygon([P(CX - wt / 2, TOPF), P(CX - wt / 2 + 6, top_y), P(CX + wt / 2 - 8, top_y), P(CX + wt / 2, TOPF)], fill=(70, 118, 190, 255))
g.arc(P(CX - wt / 2 + 22, top_y + 12, CX + wt / 2 - 22, TOPF + 110), 180, 360, fill=(255, 236, 190, 255), width=8 * S)
for k in range(1, 9):
    x = CX - wt / 2 + 8 + (wt - 16) * k / 9
    g.line([P(x, top_y), P(x, TOPF)], fill=(255, 255, 255, 60), width=S)
g.rectangle(P(CX - wt / 2 + 8, top_y - 6, CX + wt / 2 - 8, top_y), fill=(230, 236, 246, 255))
# viền thân
L = [P(CX - wid(y) / 2, y) for y in range(int(TOPF), BASE + 1, 4)]
R = [P(CX + wid(y) / 2, y) for y in range(int(TOPF), BASE + 1, 4)]
g.line(L, fill=(255, 255, 255, 220), width=2 * S); g.line(R, fill=(255, 255, 255, 220), width=2 * S)
# cánh cong trắng ở chân (như vạt áo)
def bez(p0, p1, p2, p3, n=60):
    return [tuple((1 - t) ** 3 * p0[i] + 3 * (1 - t) ** 2 * t * p1[i] + 3 * (1 - t) * t ** 2 * p2[i] + t ** 3 * p3[i] for i in range(2)) for t in (j / n for j in range(n + 1))]
yT = yof(24)
c1 = bez((CX - 125, BASE), (CX - 80, 880), (CX - 10, 740), (CX + wid(yT) / 2 - 6, yT))
c2 = bez((CX - 104, BASE), (CX - 58, 888), (CX + 12, 756), (CX + wid(yT) / 2 - 6, yT))
g.polygon([P(*p) for p in c1 + c2[::-1]], fill=(250, 250, 252, 235))
c3 = bez((CX + 130, BASE), (CX + 112, 920), (CX + 100, 830), (CX + wid(yof(16)) / 2, yof(16)))
g.line([P(*p) for p in c3], fill=(250, 250, 252, 220), width=7 * S)
# khối đế cong ven sông
pod = bez((CX + 90, BASE - 56), (CX + 170, BASE - 86), (CX + 260, BASE - 64), (CX + 315, BASE))
g.polygon([P(*p) for p in pod] + [P(CX + 90, BASE)], fill=(236, 112, 70, 255))
for k in range(1, 14):
    x = CX + 90 + 220 * k / 14
    g.line([P(x, BASE - 4), P(x, BASE - 50 + 30 * (k / 14) ** 2)], fill=(255, 220, 190, 120), width=S)
g.line([P(*p) for p in pod], fill=(255, 255, 255, 230), width=3 * S)
im.paste(tower, (0, 0), tower)
# phản chiếu dưới nước
refl = tower.crop(P(0, BASE - 260, W, BASE)).transpose(Image.FLIP_TOP_BOTTOM)
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
    x0 = CX - wid(yc) / 2 - 14
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
p = f'{O}/da-nang-downtown-thap-aurora-dang-toa.jpg'
im.resize((W, H), Image.LANCZOS).save(p, quality=90)
print(p, dd.stamp(p, tile=False))
