"""Ảnh tự vẽ làm nền đầu trang Nam Việt Á: sơ đồ cách điệu khu đất ven sông, không chữ (tiêu đề trang đè lên không bị rối)."""
import sys, random
from PIL import Image, ImageDraw, ImageFilter
O = sys.argv[1]; W, H = 1600, 900; random.seed(7)
im = Image.new('RGB', (W, H), (14, 32, 52)); d = ImageDraw.Draw(im)
# Sông cong bên phải
pts = [(W * 0.70 + 140 * __import__('math').sin(y / 260), y) for y in range(0, H + 1, 10)]
d.polygon(pts + [(W, H), (W, 0)], fill=(28, 72, 108))
for k in range(6):
    d.line([(x + 40 + k * 38, y) for x, y in pts], fill=(40, 92, 132), width=2)
# Lưới lô đất
bw, bh, gap = 92, 58, 22
for r in range(0, H // (bh + gap) + 1):
    for c in range(0, int(W * 0.66) // (bw + gap) + 1):
        x, y = 30 + c * (bw + gap), 20 + r * (bh + gap)
        shade = random.choice([(30, 52, 74), (34, 58, 82), (38, 64, 90)])
        d.rounded_rectangle([x, y, x + bw, y + bh], 6, fill=shade)
        if random.random() < .12:
            d.rounded_rectangle([x + 8, y + 8, x + bw - 8, y + bh - 8], 4, fill=(70, 112, 84))
# Công viên và trục đường ven sông
d.rounded_rectangle([30 + 3 * (bw + gap), 20 + 4 * (bh + gap), 30 + 5 * (bw + gap) - gap, 20 + 6 * (bh + gap) - gap], 10, fill=(58, 110, 78))
d.line([(x - 26, y) for x, y in pts], fill=(232, 176, 74), width=5)
im = im.filter(ImageFilter.GaussianBlur(1.2))
im.save(O, quality=84, optimize=True, progressive=True)
