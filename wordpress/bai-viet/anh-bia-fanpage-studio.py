"""Ảnh bìa + ảnh đại diện Page từ ảnh chụp studio anh Hiệp gửi (giữ nền xám studio, phối nền than chì, chi tiết vàng).
Vùng an toàn ảnh bìa: x 60–1580, y 116–740 (máy tính cắt trên/dưới, điện thoại cắt hai bên)."""
import sys
from PIL import Image, ImageDraw, ImageFont, ImageFilter, ImageEnhance
SRC, AVA, OUT = sys.argv[1], sys.argv[2], sys.argv[3]
p = Image.open(SRC).convert('RGB')
k = p.width / 1334  # toạ độ đo trên bản 1334×2000
sc = lambda b: tuple(int(v * k) for v in b)
# Ảnh đại diện vuông: mặt + vai, giữ nền studio
ava = p.crop(sc((245, 70, 1055, 880))).resize((1080, 1080), Image.LANCZOS)
ImageEnhance.Contrast(ava).enhance(1.04).save(AVA, quality=93, optimize=True)

W, H = 1640, 856
BG = (38, 36, 40)
im = Image.new('RGB', (W, H), BG)
d = ImageDraw.Draw(im)
for x in range(W):  # than chì → hơi sáng về phía ảnh
    t = x / W
    d.line([(x, 0), (x, H)], fill=(int(30 + 30 * t), int(29 + 27 * t), int(33 + 27 * t)))
# Người nhỏ lại, đầu nằm dưới mép cắt trên của máy tính (y ≥ 116); phần trên cùng nối bằng màu nền studio.
body = p.crop(sc((100, 0, 1334, 1150)))
bh = 770
body = body.resize((int(body.width * bh / body.height), bh), Image.LANCZOS)
bw = body.width
bx, by = W - bw + 20, H - bh
studio = body.crop((bw - 40, 0, bw - 10, 30)).resize((1, 1)).getpixel((0, 0))
top = body.crop((0, 0, bw, 6)).resize((bw, by + 10), Image.BILINEAR).filter(ImageFilter.GaussianBlur(6))
canvas = Image.new('RGB', (bw, H), studio)
canvas.paste(top, (0, 0))
canvas.paste(body, (0, by))
fade = 320
mask = Image.new('L', canvas.size, 255)
md = ImageDraw.Draw(mask)
for x in range(fade):
    md.line([(x, 0), (x, H)], fill=int(255 * (x / fade) ** 1.6))
im.paste(canvas, (bx, 0), mask)
d = ImageDraw.Draw(im, 'RGBA')
I = '/usr/share/fonts/opentype/inter/'
f = lambda n, s: ImageFont.truetype(I + n, s)
GOLD, CREAM, MUTED = (214, 176, 108), (246, 241, 232), (196, 192, 186)
x0 = 110
def spaced(t, xy, font, fill, sp):
    x, y = xy
    for ch in t:
        d.text((x, y), ch, font=font, fill=fill)
        x += d.textlength(ch, font=font) + sp
d.line([(x0, 176), (x0 + 46, 176)], fill=GOLD, width=3)
spaced('BẤT ĐỘNG SẢN ĐÀ NẴNG', (x0 + 62, 162), f('Inter-SemiBold.otf', 26), GOLD, 5)
d.text((x0 - 4, 205), 'Hoàng Hiệp', font=f('InterDisplay-SemiBold.otf', 118), fill=CREAM)
d.text((x0, 360), 'Tư vấn mua bán · chuyển nhượng · cho thuê', font=f('Inter-Light.otf', 33), fill=CREAM)
d.text((x0, 408), 'Căn hộ, nhà phố, đất nền, biệt thự tại Đà Nẵng', font=f('Inter-Light.otf', 29), fill=MUTED)
d.rounded_rectangle([x0, 478, x0 + 392, 540], radius=31, fill=GOLD)
d.text((x0 + 34, 490), 'Zalo  0904 567 009', font=f('Inter-SemiBold.otf', 31), fill=(30, 28, 32))
d.text((x0, 568), 'hiephoangmt.com', font=f('Inter-Medium.otf', 27), fill=MUTED)
im.save(OUT, quality=93, optimize=True, progressive=True)
