"""Ảnh bìa tự vẽ: chính sách bán hàng các dự án Sun Group Đà Nẵng tháng 11/2026."""
import sys
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
W, H = 1600, 1067
im = Image.new('RGB', (W, H), '#0f2240')
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM = '#d8b16a', '#f7f1e3'
d.text((70, 55), 'SUN GROUP ĐÀ NẴNG · 11/2026', font=f(30, True), fill=GOLD)
d.text((70, 100), 'Chính sách bán hàng tháng 11', font=f(62, True), fill=CREAM)
heads = ['Dự án', 'Không vay', 'TT sớm 95%', 'Hỗ trợ LS']
xs = [70, 560, 850, 1180]
y = 230
for x, h in zip(xs, heads):
    d.text((x, y), h, font=f(30, True), fill=GOLD)
rows = [('Spana Tower', '5%', '6%', '24 tháng'), ('Cora Tower', '5%', '7,5%', '24 tháng'),
        ('S-Light Tower', '3%', '10%', '24 tháng'), ('FourS F1, F5', '5%', '9%', '24 tháng'),
        ('FourS F2', '3%', 'liên hệ', '24 tháng')]
y = 290
for r in rows:
    d.line([(70, y - 12), (1530, y - 12)], fill='#2b4a7c', width=2)
    for x, t in zip(xs, r):
        d.text((x, y), t, font=f(38, x == 70), fill=CREAM)
    y += 92
d.text((70, y + 10), 'Vay tối đa 70% · Sun Early Key: trả 70% nhận nhà · TT sớm hạn 25/11/2026', font=f(30), fill=CREAM)
d.text((70, H - 70), 'Hoàng Hiệp tổng hợp – thông tin tham khảo · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
im.save(OUT, quality=88, optimize=True, progressive=True)
