"""Ảnh khổ điện thoại (1080×1350): chuyển nhượng 2 căn Sun Symphony Residence – không ghi mã căn, tên khách."""
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
d.text((64, 70), 'CHUYỂN NHƯỢNG · VEN SÔNG HÀN', font=f(30, True), fill=GOLD)
d.text((64, 125), 'Sun Symphony', font=f(84, True), fill='white')
d.text((64, 225), 'Residence', font=f(84, True), fill='white')
d.text((64, 335), 'Sở hữu lâu dài · Sơn Trà, Đà Nẵng', font=f(34), fill=(190, 210, 230))
units = [('1PN+1', 'Tòa S1 · tầng cao', [('56,4 m²', 'thông thủy'), ('62,8 m²', 'tim tường')]),
         ('Studio', 'Tòa S3A · tầng thấp', [('49,8 m²', 'thông thủy'), ('54,5 m²', 'tim tường')])]
for i, (kind, where, st) in enumerate(units):
    y = 430 + i * 285
    d.rounded_rectangle([64, y, W - 64, y + 255], 20, fill=(16, 40, 64), outline=GOLD, width=3)
    d.text((100, y + 32), kind, font=f(62, True), fill=GOLD)
    d.text((100, y + 120), where, font=f(32), fill=(220, 230, 240))
    for j, (big, small) in enumerate(st):
        x = 600 + j * 200
        d.text((x, y + 60), big, font=f(40, True), fill='white')
        d.text((x, y + 116), small, font=f(26), fill=(190, 210, 230))
    d.text((100, y + 185), 'Hợp đồng mua bán với chủ đầu tư · sang tên hợp đồng', font=f(26), fill=(170, 190, 210))
d.text((64, 1015), 'Giá tốt – liên hệ để nhận giá và xem căn', font=f(36, True), fill=GOLD)
p = f'{O}/sun-symphony-chuyen-nhuong-2-can-kho-dien-thoai.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
