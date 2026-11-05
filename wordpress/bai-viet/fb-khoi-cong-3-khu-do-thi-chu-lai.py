"""Ảnh bài Facebook dọc 1080×1350 (4:5, chiếm trọn màn hình điện thoại) – tin 3 khu đô thị Chu Lai.
Cảnh minh hoạ tự vẽ: hoàng hôn ven biển, cần cẩu đang dựng, 3 ghim vị trí; khối thông tin gọn; góc dưới có ảnh đại diện anh Hiệp.
Chạy: python3 fb-khoi-cong-3-khu-do-thi-chu-lai.py <anh-dai-dien.jpg> <out.jpg>"""
import sys, random
from PIL import Image, ImageDraw, ImageFont, ImageFilter

AVA, OUT = sys.argv[1], sys.argv[2]
W, H = 1080, 1350
S = 2  # vẽ gấp đôi rồi thu nhỏ cho nét mịn
im = Image.new('RGB', (W * S, H * S))
d = ImageDraw.Draw(im, 'RGBA')
I = '/usr/share/fonts/opentype/inter/'
F = lambda n, s: ImageFont.truetype(I + n, s * S)
NAVY, NAVY2 = (15, 34, 64), (10, 24, 46)
GOLD, CREAM, PEACH = (216, 177, 106), (248, 242, 230), (255, 196, 140)
P = lambda *v: tuple(int(x * S) for x in v)

# --- Bầu trời hoàng hôn (0 → 700) ---
SKY_H = 700
stops = [(0, (14, 30, 62)), (0.45, (63, 58, 104)), (0.75, (201, 110, 92)), (1, (255, 186, 120))]
def lerp(a, b, t): return tuple(int(a[i] + (b[i] - a[i]) * t) for i in range(3))
for y in range(SKY_H * S):
    t = y / (SKY_H * S)
    for i in range(len(stops) - 1):
        if stops[i][0] <= t <= stops[i + 1][0]:
            c = lerp(stops[i][1], stops[i + 1][1], (t - stops[i][0]) / (stops[i + 1][0] - stops[i][0]))
    d.line([(0, y), (W * S, y)], fill=c)
# Mặt trời + quầng sáng
glow = Image.new('L', im.size, 0)
ImageDraw.Draw(glow).ellipse(P(560, 470, 940, 850), fill=170)
glow = glow.filter(ImageFilter.GaussianBlur(60 * S))
im.paste(Image.new('RGB', im.size, (255, 214, 150)), (0, 0), glow)
d = ImageDraw.Draw(im, 'RGBA')
d.ellipse(P(680, 560, 820, 700), fill=(255, 226, 170))
# Vài ngôi sao trên cao
random.seed(7)
for _ in range(40):
    x, y = random.randint(0, W), random.randint(0, 220)
    r = random.choice([1, 1, 1.5, 2])
    d.ellipse(P(x - r, y - r, x + r, y + r), fill=(255, 255, 255, random.randint(90, 200)))

# --- Dải đất + đô thị (silhouette) ---
land = NAVY2
d.polygon(P(0, 640, 0, 668, W, 668, W, 660, 900, 652, 600, 646, 300, 640), fill=land)
# Biển phía trước, phản chiếu hoàng hôn
for y in range(668 * S, 770 * S):
    t = (y - 668 * S) / (102 * S)
    d.line([(0, y), (W * S, y)], fill=lerp((120, 84, 110), (28, 40, 76), t ** 0.7))
for i in range(12):
    y = 676 + i * 8
    w = 40 + i * 16
    d.line(P(750 - w, y, 750 + w, y), fill=(255, 210, 160, max(25, 170 - i * 13)), width=2 * S)
random.seed(11)
for _ in range(30):
    x, y = random.randint(0, W), random.randint(676, 765)
    w = random.randint(10, 40)
    d.line(P(x, y, x + w, y), fill=(255, 220, 180, 50), width=S)

random.seed(3)
x = 10
while x < 560:  # nhà thấp hiện có
    w, h = random.randint(26, 46), random.randint(20, 70)
    d.rectangle(P(x, 645 - h, x + w, 650), fill=(22, 34, 60))
    for wy in range(645 - h + 8, 640, 14):
        for wx in range(x + 6, x + w - 6, 12):
            if random.random() < 0.35:
                d.rectangle(P(wx, wy, wx + 4, wy + 6), fill=(255, 210, 140, 200))
    x += w + random.randint(4, 14)
# 3 toà đang xây: khung giàn giáo vàng
def building(x, top, w):
    d.rectangle(P(x, top, x + w, 650), fill=(26, 40, 70))
    for yy in range(top, 650, 22):
        d.line(P(x, yy, x + w, yy), fill=GOLD + (170,), width=2 * S)
    for xx in range(x, x + w + 1, 22):
        d.line(P(xx, top, xx, 650), fill=GOLD + (120,), width=2 * S)
    for yy in range(top, 640, 22):
        d.line(P(x, yy, x + 22, yy + 22), fill=GOLD + (60,), width=S)
building(600, 470, 88)
building(730, 520, 66)
building(870, 430, 110)
# Cần cẩu tháp
def crane(x, base, h, jib_l, jib_r):
    top = base - h
    d.rectangle(P(x - 6, top, x + 6, base), fill=GOLD)
    for yy in range(top, base, 16):
        d.line(P(x - 6, yy, x + 6, yy + 16), fill=NAVY2, width=S)
    d.rectangle(P(x - jib_l, top - 6, x + jib_r, top + 4), fill=GOLD)
    d.polygon(P(x - 6, top - 6, x, top - 40, x + 6, top - 6), fill=GOLD)
    d.line(P(x, top - 40, x + jib_r, top - 4), fill=GOLD, width=2 * S)
    d.line(P(x, top - 40, x - jib_l, top - 4), fill=GOLD, width=2 * S)
    d.rectangle(P(x - jib_l, top + 4, x - jib_l + 26, top + 22), fill=GOLD)  # đối trọng
    hx = x + jib_r - 30
    d.line(P(hx, top + 4, hx, top + 90), fill=CREAM, width=S)
    d.rectangle(P(hx - 12, top + 90, hx + 12, top + 104), fill=PEACH)
crane(820, 650, 330, 70, 190)
crane(1010, 650, 260, 50, 60)
# Ghim vị trí 1-2-3
def pin(x, y, n):
    d.ellipse(P(x - 26, y - 26, x + 26, y + 26), fill=GOLD)
    d.polygon(P(x - 16, y + 18, x + 16, y + 18, x, y + 46), fill=GOLD)
    d.ellipse(P(x - 18, y - 18, x + 18, y + 18), fill=NAVY)
    f = F('Inter-Bold.otf', 26)
    tw = d.textlength(str(n), font=f)
    d.text((x * S - tw / 2, (y - 17) * S), str(n), font=f, fill=CREAM)
pin(644, 410, 1)
pin(763, 470, 2)
pin(925, 370, 3)

# --- Chữ trên trời ---
tag = 'CHU LAI · NÚI THÀNH'
ft = F('Inter-Bold.otf', 22)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(64, 70, 64 + tw + 44, 112), radius=21 * S, fill=GOLD)
d.text(P(86, 78), tag, font=ft, fill=NAVY)
d.text(P(60, 136), 'Chu Lai sắp', font=F('InterDisplay-ExtraBold.otf', 82), fill=CREAM)
d.text(P(60, 228), '“thay áo mới”', font=F('InterDisplay-ExtraBold.otf', 82), fill=PEACH)
d.text(P(64, 336), '3 khu đô thị · hơn 40.400 tỷ', font=F('Inter-SemiBold.otf', 34), fill=CREAM)
d.text(P(64, 382), 'Lần này có hẳn hạn chót khởi công', font=F('Inter-Regular.otf', 28), fill=(235, 225, 215))

# --- Khối thông tin (770 → 1350) ---
d.rectangle(P(0, 770, W, H), fill=NAVY)
d.line(P(0, 770, W, 770), fill=GOLD, width=3 * S)
rows = [
    (1, 'KĐT Chu Lai', '~188,56 ha · hơn 18.854 tỷ', 'trước 29/3/2027'),
    (2, 'Ven sông Trường Giang', '74,05 ha · hơn 3.069 tỷ', 'trước 30/4/2027'),
    (3, 'Phía Nam trục Nguyễn Tất Thành', 'Khu đô thị hỗn hợp', 'trước 30/4/2027'),
]
y = 812
for n, name, sub, due in rows:
    d.ellipse(P(64, y + 4, 116, y + 56), fill=GOLD)
    f = F('Inter-Bold.otf', 28)
    tw = d.textlength(str(n), font=f)
    d.text((90 * S - tw / 2, (y + 13) * S), str(n), font=f, fill=NAVY)
    d.text(P(140, y), name, font=F('Inter-Bold.otf', 32), fill=CREAM)
    d.text(P(140, y + 44), sub, font=F('Inter-Regular.otf', 26), fill=(190, 198, 214))
    fd = F('Inter-SemiBold.otf', 24)
    dw = d.textlength('Khởi công ' + due, font=fd) / S
    d.rounded_rectangle(P(W - 64 - dw - 36, y + 40, W - 64, y + 80), radius=20 * S, outline=GOLD, width=2 * S)
    d.text(P(W - 64 - dw - 18, y + 46), 'Khởi công ' + due, font=fd, fill=GOLD)
    y += 118
    if n < 3:
        d.line(P(140, y - 20, W - 64, y - 20), fill=(255, 255, 255, 30), width=S)

# Chân: ảnh đại diện tròn + tên + Zalo
ay = 1196
ava = Image.open(AVA).convert('RGB').resize((112 * S, 112 * S), Image.LANCZOS)
m = Image.new('L', ava.size, 0)
ImageDraw.Draw(m).ellipse((0, 0, ava.size[0] - 1, ava.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 180, ay + 116), fill=GOLD)
im.paste(ava, P(64, ay), m)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(204, ay + 14), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 34), fill=CREAM)
d.text(P(204, ay + 62), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 26), fill=GOLD)
d.text(P(W - 64, ay + 100), 'Hình minh hoạ', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')

im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
