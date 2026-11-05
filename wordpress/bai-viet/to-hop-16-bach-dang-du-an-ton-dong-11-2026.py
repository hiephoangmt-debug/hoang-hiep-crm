"""Ảnh bìa tự vẽ: tổ hợp 25 tầng 16 Bạch Đằng + 3 tiêu chí gỡ dự án tồn đọng (Đà Nẵng, 11/2026)."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, LINE, RIVER = '#d8b16a', '#f7f1e3', '#0f2240', '#2b4a7c', '#1d3d6b'
W, H = 1600, 1067
im = Image.new('RGB', (W, H), NAVY)
d = ImageDraw.Draw(im)
# Sông Hàn cách điệu + tòa tháp 25 tầng
d.rectangle([1080, 760, 1600, 1067], fill=RIVER)
for i in range(6):
    d.line([(1100 + i * 80, 800 + i * 40), (1180 + i * 80, 800 + i * 40)], fill='#3a6aa8', width=4)
d.rectangle([1250, 250, 1400, 760], fill='#22406e', outline=GOLD, width=4)
for r in range(24):
    y = 270 + r * 20
    for c in range(4):
        d.rectangle([1265 + c * 33, y, 1288 + c * 33, y + 10], fill='#d8b16a' if (r + c) % 3 else '#4c6fa3')
d.text((1218, 200), '99 m · 25 tầng', font=f(30, True), fill=GOLD)
d.text((70, 60), 'ĐÀ NẴNG · HẠ TẦNG & QUY HOẠCH · 11/2026', font=f(28, True), fill=GOLD)
d.text((70, 105), 'Tổ hợp 25 tầng', font=f(70, True), fill=CREAM)
d.text((70, 190), 'tại 16 Bạch Đằng', font=f(70, True), fill=CREAM)
rows = [('Khu đất', '1.795 m²'), ('Quy mô', '25 nổi · 4 hầm'), ('Sàn xây dựng', '30.430,56 m²'), ('Gỡ dự án tồn đọng', '3 tiêu chí tài chính')]
y = 340
for label, val in rows:
    d.line([(70, y - 14), (1130, y - 14)], fill=LINE, width=2)
    d.text((70, y), label, font=f(40), fill=CREAM)
    tw = d.textlength(val, font=f(44, True))
    d.text((1130 - tw, y - 2), val, font=f(44, True), fill=GOLD)
    y += 105
d.text((70, H - 110), 'QĐ 5050/QĐ-UBND ngày 3/11/2026 · công văn ngày 5/11/2026', font=f(28), fill=CREAM)
d.text((70, H - 60), 'Hoàng Hiệp tổng hợp – hình minh hoạ · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
im.save(os.path.join(OUT, 'to-hop-16-bach-dang-du-an-ton-dong-11-2026.jpg'), quality=88, optimize=True, progressive=True)
