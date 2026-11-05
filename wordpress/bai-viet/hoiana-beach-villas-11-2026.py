"""Ảnh bìa tự vẽ: Hoiana Beach Villas – 7 dòng biệt thự (số liệu thông tin dự án chủ đầu tư 27/5/2026)."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, LINE = '#d8b16a', '#f7f1e3', '#0f2240', '#2b4a7c'
ROWS = [('Shore Villa', '3PN', '350 m²', '36'), ('Dune Villa', '3PN', '544 m²', '70'), ('Azure Villa', '4PN', '630 m²', '46'),
        ('Pearl Villa', '4PN', '702 m²', '21'), ('Marina Villa', '4PN', '840 m²', '23'), ('Patina Mansion', '7PN', '2.208 m²', '1'),
        ('Veranda Mansion', '9PN', '3.132 m²', '1')]
W, H = 1600, 1067
im = Image.new('RGB', (W, H), NAVY)
d = ImageDraw.Draw(im)
d.text((70, 55), 'HOIANA RESORT & GOLF · NAM HỘI AN', font=f(30, True), fill=GOLD)
d.text((70, 100), 'Hoiana Beach Villas', font=f(80, True), fill=CREAM)
d.text((70, 200), '198 biệt thự biển · hồ bơi riêng từng căn · bàn giao full nội thất', font=f(32), fill=CREAM)
cols = [70, 720, 960, 1330]
y = 285
for i, h in enumerate(['Dòng biệt thự', 'Phòng ngủ', 'Diện tích đất', 'Số căn']):
    d.text((cols[i], y), h, font=f(28, True), fill=GOLD)
y += 52
for name, br, land, n in ROWS:
    d.line([(70, y - 10), (1530, y - 10)], fill=LINE, width=2)
    d.text((cols[0], y), name, font=f(40, True), fill=CREAM)
    d.text((cols[1], y), br, font=f(40), fill=CREAM)
    d.text((cols[2], y), land, font=f(40), fill=CREAM)
    d.text((cols[3], y), n, font=f(40, True), fill=GOLD)
    y += 82
d.text((70, H - 70), 'Hoàng Hiệp tổng hợp từ tài liệu chủ đầu tư 05/2026 · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
im.save(os.path.join(OUT, 'hoiana-beach-villas-7-dong-biet-thu.jpg'), quality=88, optimize=True, progressive=True)
