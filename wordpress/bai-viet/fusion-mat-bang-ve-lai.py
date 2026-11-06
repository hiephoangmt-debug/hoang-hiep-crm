"""Mặt bằng Fusion Resort & Villas Đà Nẵng vẽ lại bám theo mặt bằng tổng thể chủ đầu tư (đủ 85 căn, đúng hàng – đúng loại, ghi mã căn theo mặt bằng chủ đầu tư)."""
import math
import os
import sys
from PIL import Image, ImageDraw, ImageFont

OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)

W, H = 2400, 1400
BG, NAVY, GOLD, MUTED = '#f7f3ea', '#0f2240', '#b8893c', '#5a6472'
C = {
    'pres': '#6bbf3a',  # Presidential 6PN
    'b5': '#2f5fd0',    # Beach Front 5PN / Premier 5PN
    'p4': '#f2a03d',    # Premier 4PN
    'v3': '#d9a514',    # Premier / Beach Garden 3PN
    'bg4': '#9b4fc0',   # Beach Garden 4PN
    'gt': '#f3d43a',    # Garden Terrace 2PN
    'gf': '#c4501f',    # Garden Front 1PN
}
S = 1.32  # tỷ lệ từ toạ độ mặt bằng gốc sang khung vẽ


def P(x, y):
    """Toạ độ theo mặt bằng gốc (2000×1125) → khung vẽ."""
    return (int(560 + (x - 480) * S), int(150 + (y - 210) * S))


im = Image.new('RGB', (W, H), BG)
d = ImageDraw.Draw(im)


def rect(x0, y0, x1, y1, fill, r=6, outline=None, width=1):
    d.rounded_rectangle([P(x0, y0), P(x1, y1)], radius=r, fill=fill, outline=outline, width=width)



def _codes():
    a = ['A3', 'A4'] + ['A%d' % i for i in (5, 6, 7, 8, 9, 10, 11, 12, 14, 15)] + ['A16', 'A2', 'A1', 'B1'] + ['B%d' % i for i in range(2, 12)]
    a += ['C%d' % i for i in range(1, 7)] + ['D%d' % i for i in range(1, 8)] + ['J1'] + ['J%d' % i for i in range(2, 6)]
    a += ['H%d' % i for i in range(1, 6)] + ['M%d' % i for i in range(1, 8)] + ['K%d' % i for i in range(1, 6)]
    a += ['G1'] + ['G%d' % i for i in range(2, 11)] + ['E1', 'E2', 'E3', 'E4'] + ['E%d' % i for i in (5, 6, 7, 8, 9, 10, 11, 12, 14)] + ['E15']
    return iter(a)


CODES = _codes()


def code_at(cx, cy):
    d.text(P(cx, cy), next(CODES), font=f(15, True), fill='white', anchor='mm', stroke_width=3, stroke_fill='#0f2240')

def villa(x0, y0, x1, y1, key):
    rect(x0, y0, x1, y1, C[key], 5, 'white', 2)
    code_at((x0 + x1) / 2, (y0 + y1) / 2)


def row(x0, x1, y0, y1, n, key, gap=4):
    w = (x1 - x0 - gap * (n - 1)) / n
    for i in range(n):
        a = x0 + i * (w + gap)
        villa(a, y0, a + w, y1, key)


def col(x0, x1, y0, y1, keys, gap=5):
    n = len(keys)
    h = (y1 - y0 - gap * (n - 1)) / n
    for i, k in enumerate(keys):
        a = y0 + i * (h + gap)
        villa(x0, a, x1, a + h, k)


def diag(cx, cy, s, key):
    """Biệt thự xếp chéo 45° (dãy Beach Garden)."""
    pts = []
    for a in (45, 135, 225, 315):
        r = math.radians(a + 45)
        pts.append(P(cx + s * math.cos(r), cy + s * math.sin(r)))
    d.polygon(pts, fill=C[key], outline='white', width=2)
    code_at(cx, cy)


def text(x, y, t, size=20, col=NAVY, bold=True):
    d.text(P(x, y), t, font=f(size, bold), fill=col, anchor='mm')


# Biển và bãi cát phía Đông
d.polygon([P(1700, 200), P(1880, 200), P(1880, 1090), P(1610, 1090)], fill='#bfe0ef')
d.polygon([P(1662, 200), P(1740, 200), P(1650, 1090), P(1572, 1090)], fill='#f1e2bd')
text(1800, 600, 'BIỂN', 40, '#2c6f95')
text(1800, 640, 'Bãi biển riêng', 19, '#2c6f95', False)
text(1800, 662, 'khoảng 300 m', 19, '#2c6f95', False)

# Ranh khu đất
d.polygon([P(515, 220), P(1660, 228), P(1570, 1072), P(495, 1072)], fill='#e6ede1', outline='#8e9a8e', width=4)

# Đường nội khu
ROAD = '#ffffff'
for box in ((720, 240, 1365, 462), (720, 828, 1322, 1058)):
    d.rounded_rectangle([P(box[0], box[1]), P(box[2], box[3])], radius=28, outline=ROAD, width=12)
d.line([P(520, 645), P(1610, 645)], fill=ROAD, width=16)
d.line([P(712, 230), P(712, 1065)], fill=ROAD, width=10)
d.line([P(1372, 236), P(1372, 1062)], fill=ROAD, width=10)
d.line([P(1508, 236), P(1450, 1062)], fill=ROAD, width=8)
d.ellipse([P(668, 622), P(712, 668)], fill='#cfe3c6', outline=ROAD, width=6)

# Khu tiện ích phía Tây: bãi đỗ xe, khu dịch vụ
for b in ((585, 255, 700, 440), (575, 700, 690, 832), (585, 852, 700, 1040)):
    rect(*b, '#d6dce1', 8)
text(642, 348, 'Bãi đỗ xe', 17)
text(632, 766, 'Bãi đỗ xe', 17)
text(642, 946, 'Bãi đỗ xe', 17)
rect(578, 462, 690, 560, '#cfdcc6', 8)
text(634, 511, 'Sân tennis', 15)

# Lối vào từ đường Trường Sa (phía Tây)
d.polygon([P(470, 628), P(505, 645), P(470, 662)], fill=GOLD)
d.text(P(462, 645), 'Lối vào', font=f(21, True), fill=NAVY, anchor='rm')
d.text(P(462, 672), 'đường Trường Sa', font=f(16), fill=MUTED, anchor='rm')

# Trục trung tâm: khách sạn – sảnh, spa, nhà hàng, hồ bơi chính sát biển
rect(770, 540, 860, 752, '#cbbfa8', 8)
text(815, 628, 'Khách sạn', 17)
text(815, 652, '18 tầng', 17)
rect(870, 598, 1100, 692, '#ddd5c5', 10)
text(985, 645, 'Spa · khu thư giãn', 18)
rect(1200, 598, 1312, 700, '#ddd5c5', 10)
text(1256, 638, 'Nhà hàng', 17)
text(1256, 660, 'chính', 17)
rect(1325, 606, 1535, 688, '#6fbde3', 14)
text(1430, 647, 'Hồ bơi chính', 19, 'white')
# Hồ bơi nhỏ hai cụm
rect(750, 482, 812, 512, '#8fcbe8', 6)
rect(750, 772, 812, 802, '#8fcbe8', 6)

# Cụm trên – Garden Front 1PN & Garden Terrace 2PN
villa(783, 258, 822, 318, 'gf')
villa(828, 258, 867, 318, 'gf')
row(875, 1290, 256, 330, 10, 'gt')
villa(1295, 318, 1345, 352, 'gt')
villa(738, 318, 790, 352, 'gf')
villa(738, 356, 790, 390, 'gf')
villa(790, 392, 830, 442, 'gf')
row(836, 1252, 376, 442, 10, 'gt')

# Dãy chéo trên – Beach Garden
for i in range(6):
    diag(1010 + i * 62, 520, 27, 'bg4' if i < 5 else 'v3')

# Cột Premier trên (4PN, cuối dãy 3PN)
col(1388, 1498, 262, 562, ['p4'] * 6 + ['v3'])

# Presidential và Beach Front phía trên
villa(1555, 258, 1650, 352, 'pres')
col(1522, 1640, 362, 562, ['b5'] * 4)

# Dãy chéo dưới – Beach Garden
for i in range(5):
    diag(1012 + i * 62, 760, 27, 'bg4' if i < 4 else 'v3')

# Cột Premier dưới (5PN đầu dãy, 4PN, cuối dãy 3PN)
col(1330, 1448, 728, 1032, ['b5'] + ['p4'] * 5 + ['v3'])
rect(1515, 725, 1585, 788, '#ddd5c5', 8)

# Beach Front phía dưới
col(1475, 1592, 795, 1032, ['b5'] * 5)

# Cụm dưới – Garden Front 1PN & Garden Terrace 2PN
villa(790, 840, 830, 896, 'gf')
row(836, 1212, 840, 906, 9, 'gt')
villa(738, 904, 790, 938, 'gf')
villa(738, 942, 790, 976, 'gf')
villa(785, 976, 824, 1032, 'gf')
villa(830, 976, 869, 1032, 'gf')
row(876, 1235, 958, 1032, 9, 'gt')
villa(1240, 940, 1292, 976, 'gt')

# La bàn: hướng Bắc theo mặt bằng chủ đầu tư (lệch về trái)
cx, cy = 300, 1150
a = math.radians(-60)
d.line([(cx, cy), (cx + 62 * math.cos(a), cy + 62 * math.sin(a))], fill=NAVY, width=5)
d.polygon([(cx + 78 * math.cos(a), cy + 78 * math.sin(a)),
           (cx + 56 * math.cos(a + 0.22), cy + 56 * math.sin(a + 0.22)),
           (cx + 56 * math.cos(a - 0.22), cy + 56 * math.sin(a - 0.22))], fill=NAVY)
d.text((cx + 100 * math.cos(a), cy + 100 * math.sin(a)), 'B', font=f(26, True), fill=NAVY, anchor='mm')
d.text((cx + 50, cy + 10), 'Hướng Bắc', font=f(18), fill=MUTED)

# Tiêu đề và chú thích
d.text((60, 36), 'FUSION RESORT & VILLAS ĐÀ NẴNG – MẶT BẰNG TỔNG THỂ', font=f(42, True), fill=NAVY)
d.text((60, 94), '85 biệt thự trên 15,75 ha · tô màu theo loại, ghi mã căn · lối vào Trường Sa, biển hướng Đông – Đông Bắc', font=f(26), fill=MUTED)
legend = [
    ('pres', 'Presidential Villa', '6 phòng ngủ · 1 căn'),
    ('b5', 'Beach Front Villa', '5 phòng ngủ · 9 căn sát biển'),
    ('p4', 'Premier Villa', '3 – 5 phòng ngủ · 14 căn'),
    ('bg4', 'Beach Garden Villa', '3 – 4 phòng ngủ · 11 căn'),
    ('gt', 'Garden Terrace Villa', '2 phòng ngủ · 40 căn'),
    ('gf', 'Garden Front Villa', '1 phòng ngủ · 10 căn'),
    ('v3', 'Căn 3 phòng ngủ', 'Premier / Beach Garden'),
]
y = 200
for key, name, sub in legend:
    d.rounded_rectangle([60, y, 98, y + 38], radius=6, fill=C[key])
    d.text((114, y - 4), name, font=f(24, True), fill=NAVY)
    d.text((114, y + 26), sub, font=f(20), fill=MUTED)
    y += 92
d.text((60, y + 4), 'Premier 5 phòng ngủ cùng màu xanh', font=f(18), fill=MUTED)
d.text((60, y + 28), 'với Beach Front.', font=f(18), fill=MUTED)

d.text((60, H - 56), 'Vẽ lại theo mặt bằng tổng thể của chủ đầu tư – không theo tỷ lệ chính xác, vị trí từng căn để tham khảo.', font=f(21), fill=MUTED)
d.text((W - 60, H - 58), 'Hoàng Hiệp · 0904 567 009', font=f(24, True), fill=GOLD, anchor='ra')
assert next(CODES, None) is None, 'thừa mã căn'
im.save(os.path.join(OUT, 'fusion-mat-bang-ma-can.jpg'), quality=90, optimize=True, progressive=True)
