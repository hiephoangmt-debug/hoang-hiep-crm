"""Ảnh bìa Facebook Page Hoàng Hiệp – tự vẽ (1640×856, chữ trong vùng an toàn giữa để điện thoại không cắt)."""
import sys, random
from PIL import Image, ImageDraw, ImageFont, ImageFilter
OUT = sys.argv[1]
W, H = 1640, 856
im = Image.new('RGB', (W, H))
d = ImageDraw.Draw(im)
# Trời hoàng hôn → biển
for y in range(H):
    t = y / H
    if t < 0.62:
        k = t / 0.62
        c = (int(18 + 40 * k), int(34 + 50 * k), int(72 + 40 * k))
    else:
        k = (t - 0.62) / 0.38
        c = (int(14 + 10 * k), int(70 - 20 * k), int(110 - 30 * k))
    d.line([(0, y), (W, y)], fill=c)
# Mặt trời
glow = Image.new('L', (W, H), 0)
ImageDraw.Draw(glow).ellipse([1180, 330, 1420, 570], fill=255)
glow = glow.filter(ImageFilter.GaussianBlur(60))
im = Image.composite(Image.new('RGB', (W, H), (240, 170, 90)), im, glow.point(lambda v: int(v * 0.55)))
d = ImageDraw.Draw(im)
d.ellipse([1250, 400, 1350, 500], fill=(250, 200, 120))
# Đường chân trời thành phố
random.seed(7)
base = int(H * 0.62)
x = 0
while x < W:
    w = random.randint(28, 70)
    h = random.randint(40, 200) if not (520 < x < 1120) else random.randint(30, 110)
    d.rectangle([x, base - h, x + w, base], fill=(12, 24, 52))
    for wy in range(base - h + 10, base - 8, 16):
        for wx in range(x + 6, x + w - 6, 12):
            if random.random() < 0.35:
                d.rectangle([wx, wy, wx + 4, wy + 6], fill=(230, 190, 110))
    x += w + random.randint(2, 10)
# Cầu (vòm cách điệu)
for i in range(4):
    cx = 140 + i * 110
    d.arc([cx - 60, base - 70, cx + 60, base + 40], 200, 340, fill=(222, 178, 90), width=6)
d.line([(60, base + 6), (560, base + 6)], fill=(222, 178, 90), width=5)
# Phản chiếu nước
for y in range(base + 20, H, 14):
    for x0 in range(0, W, 90):
        if random.random() < 0.4:
            d.line([(x0 + random.randint(0, 40), y), (x0 + random.randint(50, 85), y)], fill=(60, 110, 150), width=2)
# Khối chữ vùng an toàn (giữa)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
panel = Image.new('RGBA', (W, H), (0, 0, 0, 0))
ImageDraw.Draw(panel).rounded_rectangle([420, 180, 1220, 560], radius=28, fill=(10, 22, 48, 190))
im = Image.alpha_composite(im.convert('RGBA'), panel).convert('RGB')
d = ImageDraw.Draw(im)
def c(t, y, font, fill):
    d.text(((W - d.textlength(t, font=font)) / 2, y), t, font=font, fill=fill)
c('HOÀNG HIỆP', 215, f(78, True), (247, 241, 227))
c('BẤT ĐỘNG SẢN ĐÀ NẴNG', 312, f(40, True), (216, 177, 106))
c('Mua bán · Chuyển nhượng · Cho thuê', 380, f(32), (230, 234, 242))
c('Căn hộ · Nhà phố · Đất nền · Biệt thự', 426, f(30), (190, 200, 220))
d.rounded_rectangle([590, 478, 1050, 538], radius=30, fill=(216, 177, 106))
c('Zalo 0904 567 009', 486, f(36, True), (10, 22, 48))
c('hiephoangmt.com', 580, f(28, True), (247, 241, 227))
im.save(OUT, quality=92, optimize=True, progressive=True)
