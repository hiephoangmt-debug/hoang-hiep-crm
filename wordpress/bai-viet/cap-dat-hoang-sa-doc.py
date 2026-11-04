"""Ảnh khổ điện thoại (1080×1350) tin cặp đất view biển đường Hoàng Sa 224 m² – tự vẽ."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1080, 1350
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 36): g.line([x, 0, x, H], fill=(255, 255, 255, 12))
for y in range(0, H, 36): g.line([0, y, W, y], fill=(255, 255, 255, 12))
for k in range(5):
    g.line([(x, H - 40 - k * 18 + (6 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (260 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 80 - k * 14), width=3)
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 10], fill=GOLD)
d.text((64, 70), 'BÁN ĐẤT · VIEW BIỂN · SƠN TRÀ', font=f(30, True), fill=GOLD)
d.text((64, 125), 'Cặp đất view biển', font=f(76, True), fill='white')
d.text((64, 215), 'đường Hoàng Sa', font=f(76, True), fill='white')
d.text((64, 318), 'Mặt tiền đường biển · Sơn Trà, Đà Nẵng', font=f(34), fill=(190, 210, 230))
cards = [('224 m²', 'tổng diện tích – cặp 2 lô liền kề'), ('420 tr/m²', 'giá chào, còn thương lượng'), ('~94,08 tỷ', 'tổng giá tham khảo'), ('View biển', 'trực diện, bên kia đường là bãi cát')]
for i, (big, small) in enumerate(cards):
    col, row = i % 2, i // 2
    x = 64 + col * 486; y = 420 + row * 270
    d.rounded_rectangle([x, y, x + 456, y + 240], 18, fill=(16, 40, 64), outline=GOLD, width=3)
    bs = 64
    while d.textlength(big, font=f(bs, True)) > 410: bs -= 2
    d.text((x + 30, y + 36), big, font=f(bs, True), fill=GOLD)
    words, line, lines = small.split(), '', []
    for w_ in words:
        t = (line + ' ' + w_).strip()
        if d.textlength(t, font=f(28)) > 400: lines.append(line); line = w_
        else: line = t
    lines.append(line)
    for j, l in enumerate(lines[:3]): d.text((x + 30, y + 136 + j * 36), l, font=f(28), fill=(200, 215, 230))
d.text((64, 985), 'Phù hợp xây khách sạn, căn hộ dịch vụ', font=f(32), fill=(200, 215, 230))
d.text((64, 1030), 'hoặc giữ tài sản trên trục biển Sơn Trà', font=f(32), fill=(200, 215, 230))
p = f'{O}/cap-dat-hoang-sa-224-m2-kho-dien-thoai.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
