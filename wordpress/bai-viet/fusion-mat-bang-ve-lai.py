"""Sơ đồ mặt bằng Fusion Resort & Villas Đà Nẵng vẽ lại (minh họa theo mặt bằng chủ đầu tư, không theo tỷ lệ, không ghi mã căn)."""
import math
import os
import sys
from PIL import Image, ImageDraw, ImageFont

OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)

W, H = 2200, 1300
BG, NAVY, GOLD = '#f7f3ea', '#0f2240', '#b8893c'
C = {
    'pres': '#6bbf3a',   # Presidential 6PN
    'beach': '#2f5fd0',  # Beach Front 5PN / Premier 5PN
    'p4': '#f2a03d',     # Premier 4PN
    'p3': '#d9a514',     # Premier / Beach Garden 3PN
    'bg4': '#9b4fc0',    # Beach Garden 4PN
    'gt': '#f3d43a',     # Garden Terrace 2PN
    'gf': '#c4501f',     # Garden Front 1PN
}
im = Image.new('RGB', (W, H), BG)
d = ImageDraw.Draw(im)

OX = 200  # dịch toàn bộ sơ đồ sang phải để chừa chỗ chú thích


def P(x, y):
    return (x + OX, y)


def box(x, y, w, h, col, r=6):
    d.rounded_rectangle([P(x, y), P(x + w, y + h)], radius=r, fill=col, outline='white', width=2)


def diamond(cx, cy, s, col):
    pts = [P(cx + s * math.cos(a), cy + s * math.sin(a)) for a in (k * math.pi / 2 for k in range(4))]
    d.polygon(pts, fill=col, outline='white')


def label(x, y, text, size=22, col=NAVY, bold=True):
    d.text(P(x, y), text, font=f(size, bold), fill=col, anchor='mm')


# Biển, bãi cát, ranh khu đất
d.polygon([P(1690, 200), P(2000, 200), P(2000, 1110), P(1600, 1110)], fill='#bfe0ef')
d.polygon([P(1660, 200), P(1760, 200), P(1680, 1110), P(1570, 1110)], fill='#f1e2bd')
d.polygon([P(500, 205), P(1665, 210), P(1575, 1105), P(480, 1105)], fill='#e8eee3', outline='#9aa69a', width=4)
d.text(P(1840, 640), 'BIỂN', font=f(46, True), fill='#2c6f95', anchor='mm')
d.text(P(1840, 700), 'Bãi biển riêng', font=f(22), fill='#2c6f95', anchor='mm')
d.text(P(1840, 728), '~300 m', font=f(22), fill='#2c6f95', anchor='mm')

# Đường nội khu
road = '#ffffff'
for rect in ((720, 240, 1370, 470), (720, 820, 1335, 1080)):
    d.rounded_rectangle([P(rect[0], rect[1]), P(rect[2], rect[3])], radius=40, outline=road, width=14)
d.line([P(500, 640), P(1600, 640)], fill=road, width=18)
d.line([P(1370, 230), P(1350, 1090)], fill=road, width=12)
d.line([P(1500, 230), P(1460, 1090)], fill=road, width=10)

# Khu trung tâm: sảnh, hồ bơi chính, nhà hàng
d.rounded_rectangle([P(760, 560), P(880, 760)], radius=10, fill='#d9d2c3')
label(820, 650, 'Sảnh', 22)
label(820, 678, 'đón', 22)
d.rounded_rectangle([P(900, 575), P(1160, 705)], radius=18, fill='#7cc3e6')
label(1030, 640, 'Hồ bơi chính', 24, 'white')
d.rounded_rectangle([P(1180, 580), P(1300, 700)], radius=10, fill='#d9d2c3')
label(1240, 628, 'Nhà hàng', 20)
label(1240, 655, 'Spa', 20)
d.rounded_rectangle([P(1390, 590), P(1560, 690)], radius=10, fill='#d9d2c3')
label(1475, 628, 'Grill House', 20)
label(1475, 655, '& Bar', 20)
d.rounded_rectangle([P(540, 690), P(690, 840)], radius=10, fill='#cfd6dc')
label(615, 752, 'Bãi đỗ xe', 20)
d.rounded_rectangle([P(560, 270), P(680, 470)], radius=10, fill='#cfd6dc')
label(620, 360, 'Khu dịch vụ', 20)

d.polygon([P(480, 620), P(520, 640), P(480, 660)], fill=GOLD)
d.text(P(470, 640), 'Lối vào', font=f(22, True), fill=NAVY, anchor='rm')

# Cụm trên: Garden Front 1PN + Garden Terrace 2PN
for y in (325, 365):
    box(735, y, 32, 30, C['gf'])
for i in range(2):
    box(785 + i * 40, 262, 34, 50, C['gf'])
for i in range(11):
    box(870 + i * 42, 262, 36, 50, C['gt'])
box(745, 405, 34, 50, C['gf'])
for i in range(10):
    box(800 + i * 44, 405, 38, 50, C['gt'])
# Hàng chéo trên: Beach Garden
for i in range(6):
    diamond(990 + i * 62, 525, 30, C['bg4'] if i < 5 else C['p3'])
# Cột Premier phía trên
for i in range(7):
    box(1395, 255 + i * 44, 80, 36, C['p4'] if i < 6 else C['p3'])
# Presidential + Beach Front phía trên
box(1520, 245, 110, 90, C['pres'], 10)
for i in range(4):
    box(1520, 355 + i * 50, 105, 42, C['beach'])

# Hàng chéo dưới: Beach Garden
for i in range(5):
    diamond(1010 + i * 62, 760, 30, C['bg4'] if i < 4 else C['p3'])
# Cột Premier phía dưới
for i in range(7):
    col = C['beach'] if i == 0 else (C['p3'] if i == 6 else C['p4'])
    box(1360, 735 + i * 46, 80, 38, col)
# Beach Front phía dưới
for i in range(5):
    box(1475, 800 + i * 58, 100, 48, C['beach'])

# Cụm dưới: Garden Front + Garden Terrace
box(745, 845, 34, 50, C['gf'])
for i in range(9):
    box(800 + i * 46, 845, 38, 50, C['gt'])
for y in (915, 950):
    box(735, y, 32, 30, C['gf'])
for i in range(2):
    box(785 + i * 40, 1000, 34, 50, C['gf'])
for i in range(10):
    box(870 + i * 42, 1000, 36, 50, C['gt'])

# Tiêu đề và chú thích
d.text((60, 40), 'FUSION RESORT & VILLAS ĐÀ NẴNG', font=f(44, True), fill=NAVY)
d.text((60, 100), 'Mặt bằng tổng thể theo loại biệt thự · 85 biệt thự trên 15,75 ha', font=f(28), fill='#5a6472')
legend = [
    ('pres', 'Presidential Villa', '6 phòng ngủ · 1 căn'),
    ('beach', 'Beach Front Villa', '5 phòng ngủ · 9 căn'),
    ('p4', 'Premier Villa', '3 – 5 phòng ngủ · 14 căn'),
    ('bg4', 'Beach Garden Villa', '3 – 4 phòng ngủ · 11 căn'),
    ('gt', 'Garden Terrace Villa', '2 phòng ngủ · 40 căn'),
    ('gf', 'Garden Front Villa', '1 phòng ngủ · 10 căn'),
]
y = 230
for key, name, sub in legend:
    d.rounded_rectangle([60, y, 100, y + 40], radius=6, fill=C[key])
    d.text((118, y - 2), name, font=f(26, True), fill=NAVY)
    d.text((118, y + 30), sub, font=f(22), fill='#5a6472')
    y += 100
d.rounded_rectangle([60, y, 100, y + 40], radius=6, fill=C['p3'])
d.text((118, y + 6), 'Căn 3 phòng ngủ', font=f(22), fill='#5a6472')
y += 70
d.text((60, y), 'Premier 5PN cùng màu Beach Front', font=f(20), fill='#5a6472')

d.text((60, H - 70), 'Sơ đồ vẽ lại để minh họa, theo mặt bằng của chủ đầu tư – không theo tỷ lệ, vị trí từng căn tham khảo.', font=f(22), fill='#5a6472')
d.text((W - 60, H - 70), 'Hoàng Hiệp · 0904 567 009', font=f(24, True), fill=GOLD, anchor='ra')
im.save(os.path.join(OUT, 'fusion-mat-bang-ve-lai.jpg'), quality=90, optimize=True, progressive=True)
