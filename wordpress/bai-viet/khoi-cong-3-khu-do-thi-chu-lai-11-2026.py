"""Ảnh bìa tự vẽ: thời hạn khởi công 3 khu đô thị tại Chu Lai (11/2026)."""
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
d.text((70, 60), 'HẠ TẦNG & QUY HOẠCH · CHU LAI · 11/2026', font=f(30, True), fill=GOLD)
d.text((70, 108), '3 khu đô thị hơn 40.400 tỷ', font=f(64, True), fill=CREAM)
d.text((70, 188), 'được ấn định thời hạn khởi công', font=f(56, True), fill=CREAM)
rows = [
    ('KĐT Chu Lai', '~188,56 ha · >18.854 tỷ · khởi công chậm nhất 29/3/2027'),
    ('Ven sông T.Giang', '74,05 ha · >3.069 tỷ · khởi công trước 30/4/2027'),
    ('Nam Ng.T.Thành', 'Khu đô thị hỗn hợp · khởi công trước 30/4/2027'),
]
y = 330
for tag, txt in rows:
    d.rounded_rectangle([70, y, 400, y + 96], radius=16, fill=GOLD)
    tw = d.textlength(tag, font=f(30, True))
    d.text((235 - tw / 2, y + 30), tag, font=f(30, True), fill='#0f2240')
    d.text((430, y + 30), txt, font=f(31), fill=CREAM)
    y += 130
# trục đơn giản: Đà Nẵng → Hội An → Tam Kỳ → Chu Lai
yy = 780
d.line([(120, yy), (1480, yy)], fill=GOLD, width=6)
for x, name in [(120, 'Đà Nẵng'), (560, 'Hội An'), (1000, 'Tam Kỳ'), (1440, 'Chu Lai')]:
    r = 20 if name == 'Chu Lai' else 13
    d.ellipse([x - r, yy - r, x + r, yy + r], fill=GOLD if name == 'Chu Lai' else CREAM)
    tw = d.textlength(name, font=f(30, True))
    d.text((x - tw / 2, yy + 34), name, font=f(30, True), fill=GOLD if name == 'Chu Lai' else CREAM)
d.text((70, H - 70), 'Sơ đồ minh hoạ, không theo tỷ lệ · Hoàng Hiệp tổng hợp · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
im.save(OUT, quality=88, optimize=True, progressive=True)
