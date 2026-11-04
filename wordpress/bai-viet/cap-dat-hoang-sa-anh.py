"""Ảnh tin cặp đất view biển đường Hoàng Sa 224 m² (tự vẽ, không dùng ảnh có logo trang khác)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
for k in range(4):
    g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((56, 44), 'BÁN ĐẤT · VIEW BIỂN · SƠN TRÀ', font=f(22, True), fill=GOLD)
d.text((56, 84), 'Cặp đất view biển đường Hoàng Sa', font=f(50, True), fill='white')
d.text((56, 160), 'Mặt tiền đường biển · Sơn Trà, Đà Nẵng', font=f(28), fill=(190, 210, 230))
for i, (big, small) in enumerate([('224 m²', 'tổng diện tích cặp đất'), ('420 tr/m²', 'giá chào, thương lượng'), ('~94,08 tỷ', 'tổng giá tham khảo'), ('View biển', 'trực diện, bên kia đường là bãi cát')]):
    x = 56 + i * 272; y = 250
    d.rounded_rectangle([x, y, x + 250, y + 170], 14, fill=(16, 40, 64), outline=GOLD, width=2)
    bs = 40
    while d.textlength(big, font=f(bs, True)) > 220: bs -= 2
    d.text((x + 20, y + 26), big, font=f(bs, True), fill=GOLD)
    words, line, lines = small.split(), '', []
    for w_ in words:
        t = (line + ' ' + w_).strip()
        if d.textlength(t, font=f(19)) > 215: lines.append(line); line = w_
        else: line = t
    lines.append(line)
    for j, l in enumerate(lines[:3]): d.text((x + 20, y + 96 + j * 24), l, font=f(19), fill=(200, 215, 230))
d.text((56, 470), 'Phù hợp xây khách sạn, căn hộ dịch vụ hoặc giữ tài sản trên trục biển', font=f(20), fill=(170, 190, 210))
p = f'{O}/cap-dat-view-bien-hoang-sa-224-m2.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
