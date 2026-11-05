"""Ảnh FB dọc 1080×1350 – thị trường căn hộ Đà Nẵng quý III/2026 (số liệu DKRA, báo chí trích dẫn).
Chạy: python3 fb-thi-truong-can-ho-da-nang-quy-3-2026.py <anh-dai-dien.jpg> <out.jpg>"""
import sys, random
from PIL import Image, ImageDraw, ImageFont

AVA, OUT = sys.argv[1], sys.argv[2]
W, H, S = 1080, 1350, 2
im = Image.new('RGB', (W * S, H * S), (12, 28, 54))
d = ImageDraw.Draw(im, 'RGBA')
I = '/usr/share/fonts/opentype/inter/'
F = lambda n, s: ImageFont.truetype(I + n, s * S)
P = lambda *v: tuple(int(x * S) for x in v)
NAVY, GOLD, CREAM, MINT, CORAL = (15, 34, 64), (216, 177, 106), (248, 242, 230), (120, 214, 190), (255, 140, 120)

# Nền: trời đêm xanh tím, trăng, sông Hàn, dãy nhà cao tầng có ô cửa sáng
for y in range(560 * S):
    t = y / (560 * S)
    c = tuple(int(a + (b - a) * t) for a, b in zip((10, 22, 48), (52, 60, 110)))
    d.line([(0, y), (W * S, y)], fill=c)
d.ellipse(P(860, 70, 960, 170), fill=(255, 236, 200))
d.ellipse(P(840, 60, 940, 160), fill=(10, 22, 48) + (0,))
random.seed(5)
for _ in range(50):
    x, y = random.randint(0, W), random.randint(0, 300)
    d.ellipse(P(x - 1.2, y - 1.2, x + 1.2, y + 1.2), fill=(255, 255, 255, random.randint(80, 200)))
x = 0
random.seed(9)
while x < W:  # dãy nhà
    w = random.randint(50, 110)
    h = random.randint(120, 330)
    top = 560 - h
    d.rectangle(P(x, top, x + w, 560), fill=(20, 32, 62))
    for wy in range(top + 14, 548, 22):
        for wx in range(x + 10, x + w - 12, 18):
            if random.random() < 0.45:
                d.rectangle(P(wx, wy, wx + 8, wy + 10), fill=(255, 214, 140, random.randint(120, 230)))
    x += w + random.randint(6, 16)
# cần cẩu nhỏ (nguồn cung mới đang xây)
cx = 760
d.rectangle(P(cx - 5, 250, cx + 5, 560), fill=GOLD)
d.rectangle(P(cx - 60, 244, cx + 170, 252), fill=GOLD)
d.line(P(cx, 210, cx + 170, 248), fill=GOLD, width=2 * S)
d.line(P(cx, 210, cx - 60, 248), fill=GOLD, width=2 * S)
d.polygon(P(cx - 5, 246, cx, 210, cx + 5, 246), fill=GOLD)
d.line(P(cx + 140, 252, cx + 140, 330), fill=CREAM, width=S)
d.rectangle(P(cx + 128, 330, cx + 152, 344), fill=CORAL)
# sông
for y in range(560 * S, 640 * S):
    t = (y - 560 * S) / (80 * S)
    d.line([(0, y), (W * S, y)], fill=tuple(int(a + (b - a) * t) for a, b in zip((40, 50, 92), (14, 30, 58))))
for i in range(10):
    yy = 570 + i * 7
    for xx in range(30, W, 140):
        d.line(P(xx + i * 9, yy, xx + 50 + i * 9, yy), fill=(255, 210, 150, 70), width=S)

# Chữ trên trời
tag = 'THỊ TRƯỜNG · QUÝ III/2026'
ft = F('Inter-Bold.otf', 22)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 64, 60 + tw + 44, 106), radius=21 * S, fill=GOLD)
d.text(P(82, 72), tag, font=ft, fill=NAVY)
d.text(P(58, 126), 'Căn hộ Đà Nẵng:', font=F('InterDisplay-ExtraBold.otf', 70), fill=CREAM)
d.text(P(58, 206), 'nguồn cung ít đi,', font=F('InterDisplay-ExtraBold.otf', 70), fill=CREAM)
d.text(P(58, 286), 'giá vẫn giữ vững', font=F('InterDisplay-ExtraBold.otf', 70), fill=(255, 196, 140))

# Khối số liệu
d.rectangle(P(0, 640, W, H), fill=NAVY)
d.line(P(0, 640, W, 640), fill=GOLD, width=3 * S)
cards = [
    ('4.385', 'căn sơ cấp đang chào bán', '▼ 14% so với quý II', CORAL),
    ('2.099', 'căn bán được trong quý', '▼ 25% so với quý II', CORAL),
    ('68%', 'giao dịch là căn hạng B', 'tổng tiền vừa phải bán nhanh', MINT),
    ('500–1.000', 'căn mới dự báo quý IV', 'Ngũ Hành Sơn · Hải Châu · Sơn Trà', GOLD),
]
cw, ch, gx, gy = 462, 196, 36, 24
for i, (big, lab, sub, col) in enumerate(cards):
    x = 60 + (i % 2) * (cw + gx)
    y = 676 + (i // 2) * (ch + gy)
    d.rounded_rectangle(P(x, y, x + cw, y + ch), radius=22 * S, fill=(24, 48, 86))
    d.rectangle(P(x, y + 24, x + 6, y + ch - 24), fill=col)
    fb = F('InterDisplay-ExtraBold.otf', 58 if len(big) < 7 else 50)
    d.text(P(x + 30, y + 22), big, font=fb, fill=CREAM)
    d.text(P(x + 30, y + 104), lab, font=F('Inter-SemiBold.otf', 25), fill=CREAM)
    d.text(P(x + 30, y + 142), sub, font=F('Inter-Medium.otf', 21), fill=col)

# Chân: ảnh đại diện + tên + nguồn
ay = 1146
ava = Image.open(AVA).convert('RGB').resize((112 * S, 112 * S), Image.LANCZOS)
m = Image.new('L', ava.size, 0)
ImageDraw.Draw(m).ellipse((0, 0, ava.size[0] - 1, ava.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 180, ay + 116), fill=GOLD)
im.paste(ava, P(64, ay), m)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(204, ay + 14), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 34), fill=CREAM)
d.text(P(204, ay + 62), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 26), fill=GOLD)
d.text(P(60, 1300), 'Số liệu: DKRA Consulting (báo chí trích dẫn) · Hình minh hoạ', font=F('Inter-Regular.otf', 19), fill=(150, 160, 180))

im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
