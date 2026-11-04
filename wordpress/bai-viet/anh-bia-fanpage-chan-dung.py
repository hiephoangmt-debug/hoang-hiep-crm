"""Ảnh đại diện + ảnh bìa Page có ảnh chân dung anh Hiệp (ảnh anh gửi 04/11/2026) và phong cảnh Đà Nẵng tự vẽ
(núi Sơn Trà, cầu Rồng, sông Hàn – không dùng ảnh có chữ chìm của bên khác)."""
import sys, random
from PIL import Image, ImageDraw, ImageFont, ImageFilter
SRC, AVA, COV = sys.argv[1], sys.argv[2], sys.argv[3]
p = Image.open(SRC).convert('RGB')
PW, PH = p.size
# Ảnh đại diện: khuôn mặt + vai (người nằm khoảng 50 – 90% chiều ngang, đầu ~27% chiều cao).
cx, cy, r = int(PW * 0.715), int(PH * 0.33), int(PW * 0.24)
p.crop((cx - r, cy - r, cx + r, cy + r)).resize((960, 960), Image.LANCZOS).save(AVA, quality=92, optimize=True)

W, H = 1640, 856
im = Image.new('RGB', (W, H))
d = ImageDraw.Draw(im)
for y in range(H):  # trời đêm xanh → chân trời ấm
    k = y / H
    d.line([(0, y), (W, y)], fill=(int(12 + 30 * k), int(26 + 30 * k), int(58 + 30 * k)))
glow = Image.new('L', (W, H), 0)
ImageDraw.Draw(glow).ellipse([200, 420, 1100, 760], fill=255)
glow = glow.filter(ImageFilter.GaussianBlur(120))
im = Image.composite(Image.new('RGB', (W, H), (190, 120, 80)), im, glow.point(lambda v: int(v * 0.35)))
d = ImageDraw.Draw(im)
# Núi Sơn Trà phía xa
d.polygon([(0, 640), (120, 600), (260, 560), (380, 575), (520, 610), (700, 640), (0, 640)], fill=(22, 40, 70))
# Phố hai bờ sông Hàn
random.seed(3)
base = 660
x = 0
while x < 1300:
    w = random.randint(26, 60)
    hgt = random.randint(30, 150)
    d.rectangle([x, base - hgt, x + w, base], fill=(14, 28, 56))
    for wy in range(base - hgt + 8, base - 6, 14):
        for wx in range(x + 5, x + w - 5, 11):
            if random.random() < 0.3:
                d.rectangle([wx, wy, wx + 3, wy + 5], fill=(232, 192, 112))
    x += w + random.randint(4, 14)
# Sông Hàn + cầu Rồng (vòm uốn lượn)
d.rectangle([0, base, W, H], fill=(16, 44, 78))
d.line([(40, base + 18), (1000, base + 18)], fill=(222, 178, 90), width=5)
for i in range(5):
    x0 = 80 + i * 170
    d.arc([x0, base - 40, x0 + 170, base + 76], 195, 345, fill=(240, 196, 96), width=8)
for y in range(base + 34, H, 12):  # ánh đèn phản chiếu
    for x0 in range(0, 1100, 70):
        if random.random() < 0.45:
            d.line([(x0 + random.randint(0, 30), y), (x0 + random.randint(36, 64), y)], fill=(170, 140, 80), width=2)
# Lớp phủ tối phía trên để chữ rõ
shade = Image.new('L', (W, H), 0)
ImageDraw.Draw(shade).rectangle([0, 0, W, 560], fill=110)
shade = shade.filter(ImageFilter.GaussianBlur(80))
im = Image.composite(Image.new('RGB', (W, H), (10, 20, 44)), im, shade)
# Người: cắt từ đầu tới gối, đặt sát mép phải, mờ dần mép trái và trên.
body = p.crop((int(PW * 0.46), int(PH * 0.20), PW, int(PH * 0.82)))
h = 820
body = body.resize((int(body.width * h / body.height), h), Image.LANCZOS)
bw, bh = body.size
L, T = 170, 120
mask = Image.new('L', body.size)
mask.putdata([int(255 * min(1, x / L) * min(1, y / T)) for y in range(bh) for x in range(bw)])
im.paste(body, (W - bw, H - h), mask)
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, MUTED = (216, 177, 106), (247, 241, 227), (200, 208, 228)
x0 = 420
d.text((x0, 150), 'HOÀNG HIỆP', font=f(84, True), fill=CREAM)
d.text((x0, 252), 'BẤT ĐỘNG SẢN ĐÀ NẴNG', font=f(42, True), fill=GOLD)
d.line([(x0, 318), (x0 + 120, 318)], fill=GOLD, width=4)
d.text((x0, 342), 'Mua bán · Chuyển nhượng · Cho thuê', font=f(32), fill=CREAM)
d.text((x0, 390), 'Căn hộ · Nhà phố · Đất nền · Biệt thự', font=f(30), fill=MUTED)
d.rounded_rectangle([x0, 452, x0 + 470, 522], radius=34, fill=GOLD)
d.text((x0 + 36, 463), 'Zalo 0904 567 009', font=f(38, True), fill=(14, 28, 60))
d.text((x0, 548), 'hiephoangmt.com', font=f(30, True), fill=CREAM)
im.save(COV, quality=92, optimize=True, progressive=True)
