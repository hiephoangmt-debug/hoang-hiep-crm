"""Ảnh FB dọc 1080×1350 – Hoiana Beach Villas: 7 dòng biệt thự (số liệu theo bài web 06/11/2026, tài liệu CĐT 05/2026).
Cảnh biển cách điệu tự vẽ. Chạy: python3 fb-hoiana-beach-villas-7-dong-biet-thu.py <anh-dai-dien.jpg> <out.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, OUT = sys.argv[1:3]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
ROWS = [
    ('Shore Villa', '3 PN', '350 m²', '36 căn'),
    ('Dune Villa', '3 PN', '544 m²', '70 căn'),
    ('Azure Villa', '4 PN', '630 m²', '46 căn'),
    ('Pearl Villa', '4 PN', '702 m²', '21 căn'),
    ('Marina Villa', '4 PN', '840 m²', '23 căn'),
    ('Patina · Veranda', '7 – 9 PN', '2.208 – 3.132 m²', '2 dinh thự'),
]
W, H, S = 1080, 1350, 2
F = lambda n, s: ImageFont.truetype(I + n, s * S)
P = lambda *v: tuple(int(x * S) for x in v)
lerp = lambda a, b, t: tuple(int(x + (y - x) * t) for x, y in zip(a, b))

im = Image.new('RGB', (W * S, H * S), NAVY)
d = ImageDraw.Draw(im, 'RGBA')
# Trời chiều → biển → cát (0–470)
for y in range(300 * S):
    t = y / (300 * S)
    d.line([(0, y), (W * S, y)], fill=lerp((22, 44, 86), (238, 170, 120), t ** 1.4))
d.ellipse(P(760, 210, 880, 330), fill=(255, 226, 170))
for y in range(300 * S, 400 * S):
    t = (y - 300 * S) / (100 * S)
    d.line([(0, y), (W * S, y)], fill=lerp((60, 110, 160), (30, 70, 120), t))
for i in range(8):
    yy = 312 + i * 11
    d.line(P(820 - 30 - i * 16, yy, 820 + 30 + i * 16, yy), fill=(255, 215, 160, 150 - i * 15), width=2 * S)
d.polygon([P(0, 400), P(W, 380), P(W, 470), P(0, 470)], fill=(222, 196, 150))
d.line([P(0, 400), P(W, 380)], fill=(255, 255, 255, 160), width=3 * S)
# Biệt thự mái dốc + cây dừa (silhouette)
for x, w in ((80, 150), (280, 120), (460, 170)):
    d.rectangle(P(x, 410, x + w, 455), fill=(30, 46, 72))
    d.polygon([P(x - 12, 412), P(x + w / 2, 384), P(x + w + 12, 412)], fill=(40, 58, 88))
    d.rectangle(P(x + 16, 422, x + 40, 444), fill=(255, 214, 150))
    d.rectangle(P(x + w - 40, 422, x + w - 16, 444), fill=(255, 214, 150))
    d.rectangle(P(x + 10, 456, x + w - 10, 466), fill=(90, 170, 200))
for px in (40, 250, 660, 950):
    d.line([P(px, 470), P(px + 14, 330)], fill=(24, 36, 56), width=7 * S)
    for ang in ((-70, -18), (-40, -38), (10, -40), (60, -20), (75, 8), (-75, 8)):
        d.line([P(px + 14, 330), P(px + 14 + ang[0], 330 + ang[1])], fill=(24, 36, 56), width=6 * S)
# Chữ trên trời
tag = 'NAM HỘI AN · HOIANA'
ft = F('Inter-Bold.otf', 21)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 52, 60 + tw + 40, 92), radius=20 * S, fill=GOLD)
d.text(P(80, 60), tag, font=ft, fill=NAVY)
d.text(P(58, 108), 'Hoiana Beach Villas', font=F('InterDisplay-ExtraBold.otf', 66), fill=CREAM)
d.text(P(60, 190), '198 biệt thự biển · hồ bơi riêng', font=F('InterDisplay-Bold.otf', 38), fill=(255, 236, 210))

# Bảng dòng biệt thự
d.rectangle(P(0, 470, W, H), fill=NAVY)
d.line(P(0, 470, W, 470), fill=GOLD, width=3 * S)
d.text(P(60, 496), '7 dòng biệt thự', font=F('Inter-Bold.otf', 28), fill=GOLD)
d.text(P(W - 60, 500), 'Đất · số căn', font=F('Inter-Medium.otf', 22), fill=MUTED, anchor='ra')
y = 548
for i, (ten, pn, dat, sl) in enumerate(ROWS):
    if i % 2 == 0:
        d.rounded_rectangle(P(48, y - 8, W - 48, y + 62), radius=12 * S, fill=NAVY2)
    d.text(P(64, y + 2), ten, font=F('Inter-Bold.otf', 28), fill=CREAM)
    d.text(P(64, y + 34), pn, font=F('Inter-Regular.otf', 21), fill=MUTED)
    d.text(P(W - 64, y + 2), dat, font=F('Inter-Bold.otf', 28), fill=GOLD, anchor='ra')
    d.text(P(W - 64, y + 34), sl, font=F('Inter-Regular.otf', 21), fill=MUTED, anchor='ra')
    y += 80
d.text(P(60, y + 6), 'Bàn giao đủ nội thất · garage riêng · dùng chung tiện ích Hoiana', font=F('Inter-Medium.otf', 22), fill=CREAM)

ay = 1200
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1322), 'Hình minh hoạ', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
