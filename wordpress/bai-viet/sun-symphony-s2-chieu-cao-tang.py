"""Sơ đồ chiều cao tầng tòa S2 Sun Symphony Residence – tự vẽ từ số liệu chủ đầu tư (không dùng ảnh có logo đơn vị khác)."""
import sys
from PIL import Image, ImageDraw, ImageFont

OUT = sys.argv[1]
W, H = 1600, 1200
im = Image.new('RGB', (W, H), '#f6f8fb')
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY, GOLD, GREY = '#1d2b53', '#b8893b', '#5b6577'

d.text((60, 44), 'SUN SYMPHONY RESIDENCE', font=f(30, True), fill=GOLD)
d.text((60, 86), 'Chiều cao tầng – Tòa S2 (24 tầng)', font=f(52, True), fill=NAVY)
d.text((60, 156), 'Sơ đồ minh hoạ, không theo tỷ lệ · số liệu theo tài liệu chủ đầu tư, tham khảo', font=f(24), fill=GREY)

# Thang cao độ: 0 m ở y0, 88 m ở y1.
x0, x1, y0, y1 = 300, 820, 1110, 250
Y = lambda m: y0 - (y0 - y1) * m / 93.0
bands = [  # (từ m, tới m, màu, nhãn)
    (0, 11.5, '#e8a0a8', 'Tầng 1 – 2 · Shophouse'),
    (11.5, 17, '#8fd3d6', 'Tầng 3 · Tiện ích + Garden House'),
    (17, 84.5, '#c9d6ea', 'Tầng 3A – 22 · Căn hộ điển hình'),
    (84.5, 91.5, '#f3d77a', 'Tầng 23 – 24 · Penthouse'),
]
for a, b, c, _ in bands:
    d.rectangle([x0, Y(b), x1, Y(a)], fill=c, outline='#ffffff', width=3)
# Khối thấp phía sông: penthouse 15 – 16 trên cao độ 55,5 m.
xs = 600
d.rectangle([xs, Y(91.5) - 2, x1 + 2, Y(62.5)], fill='#f6f8fb')
d.rectangle([xs, Y(62.5), x1, Y(55.5)], fill='#f3d77a', outline='#ffffff', width=3)
d.line([xs, Y(84.5), xs, Y(62.5)], fill='#ffffff', width=3)
d.text((xs + 20, Y(62.5) - 40), 'PH 15 – 16', font=f(26, True), fill=NAVY)
for a, b, c, lab in bands:
    mid = (Y(a) + Y(b)) / 2
    w = x0 + 20
    d.text((w, mid - 16), lab.split(' · ')[0], font=f(26, True), fill=NAVY)
# Cột cao độ bên trái.
for m, t in [(0, '±0'), (7, '+7 m'), (11.5, '+11,5 m'), (17, '+17 m'), (55.5, '+55,5 m'), (84.5, '+84,5 m')]:
    d.line([x0 - 30, Y(m), x0, Y(m)], fill=GREY, width=2)
    tw = d.textlength(t, font=f(24))
    d.text((x0 - 40 - tw, Y(m) - (24 if m == 0 else 14)), t, font=f(24), fill=GREY)
d.line([x0, Y(7), x1, Y(7)], fill='#ffffff', width=2)
d.line([x0 - 60, y0, x1 + 60, y0], fill=NAVY, width=4)

# Chú thích bên phải.
rx, ry = 900, 250
rows = [
    ('Tầng 23 – 24 · Penthouse', 'Cao độ sàn 84,5 m · cao tầng 3,5 m'),
    ('Tầng 15 – 16 · Penthouse (khối thấp)', 'Cao độ sàn 55,5 m · cao tầng 3,5 m'),
    ('Tầng 3A – 22 · Căn hộ điển hình', 'Từ cao độ 17 m · cao tầng 3,5 m (tầng 22: 4,1 m)'),
    ('Tầng 3A – 15 · Căn Dual Front', 'Cao tầng 3,5 m'),
    ('Tầng 3 · Garden House + tiện ích', 'Cao độ sàn 11,5 m · cao tầng 5,5 m'),
    ('Tầng 1 – 2 · Shophouse', 'Tầng 1 cao 7 m · tầng 2 cao 4,5 m'),
]
for t, s in rows:
    d.text((rx, ry), t, font=f(28, True), fill=NAVY)
    d.text((rx, ry + 38), s, font=f(24), fill=GREY)
    ry += 98
ry += 10
d.rounded_rectangle([rx - 20, ry, W - 50, ry + 210], radius=16, fill='#ffffff', outline='#e2e6ee', width=2)
d.text((rx, ry + 20), 'Tiện ích tầng 3', font=f(30, True), fill=GOLD)
for i, t in enumerate(['Hồ bơi vô cực – 450 m²', 'Phòng sinh hoạt cộng đồng – 325 m²', 'Phòng gym – 125 m²']):
    d.text((rx, ry + 70 + i * 42), '•  ' + t, font=f(26), fill=NAVY)
d.text((rx, H - 70), 'Hoàng Hiệp · Zalo 0904 567 009', font=f(26, True), fill=NAVY)
im.save(OUT, quality=88, optimize=True, progressive=True)
