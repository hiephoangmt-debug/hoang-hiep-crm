"""Ảnh tự vẽ: sơ đồ khu đất TMDV 12 Hoàng Văn Thái (minh hoạ, theo thông số bên bán cung cấp, không theo tỉ lệ chính xác)."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(20, 38, 56))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(20, 38, 56))
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((40, 30), 'CHUYỂN NHƯỢNG · ĐẤT THƯƠNG MẠI DỊCH VỤ', font=f(20, True), fill=GOLD)
d.text((40, 62), 'Mặt tiền Hoàng Văn Thái, Đà Nẵng', font=f(40, True), fill='white')
d.text((40, 116), '2.404,4 m² · mặt tiền ~42 m · đường ~35 m', font=f(24), fill=(190, 210, 230))
stats = [('50 tỷ', 'giá chuyển nhượng, gồm VAT'), ('~20,8 tr/m²', 'tính trên diện tích đất'), ('đến 20/01/2066', 'thuê đất trả tiền 1 lần'), ('4 tầng', 'công trình ~195 m² + sân ~2.200 m²')]
for i, (big, small) in enumerate(stats):
    y = 180 + i * 104
    d.rounded_rectangle([40, y, 520, y + 90], 12, fill=(16, 40, 64), outline=GOLD, width=2)
    d.text((60, y + 12), big, font=f(30, True), fill=GOLD); d.text((60, y + 54), small, font=f(18), fill=(200, 215, 230))
# sơ đồ lô: ngang 42 m (mặt tiền, phía dưới), sâu 60 m
x0, y0, sw, sh = 720, 170, 230, 300
d.rectangle([x0 - 140, y0 + sh + 18, x0 + sw + 140, y0 + sh + 70], fill=(60, 70, 85))
d.text((x0 + sw / 2 - 150, y0 + sh + 32), 'ĐƯỜNG HOÀNG VĂN THÁI (~35 m)', font=f(18, True), fill='white')
d.rectangle([x0, y0, x0 + sw, y0 + sh], fill=(40, 60, 70), outline=GOLD, width=3)
for yy in range(y0 + 10, y0 + sh, 22): d.line([x0 + 4, yy, x0 + sw - 4, yy], fill=(55, 78, 88))
d.text((x0 + 38, y0 + sh / 2 - 34), '2.404,4 m²', font=f(22, True), fill=(230, 235, 240)); d.text((x0 + 24, y0 + sh / 2), 'nhà 4 tầng + sân', font=f(17), fill=(210, 220, 230))
d.line([x0, y0 + sh + 8, x0 + sw, y0 + sh + 8], fill=GOLD, width=2); d.text((x0 + sw / 2 - 30, y0 + sh - 6 + 0), '', font=f(14))
d.text((x0 + sw / 2 - 28, y0 - 30), '~42 m', font=f(18, True), fill=GOLD); d.line([x0, y0 - 8, x0 + sw, y0 - 8], fill=GOLD, width=2)
d.line([x0 + sw + 14, y0, x0 + sw + 14, y0 + sh], fill=GOLD, width=2); d.text((x0 + sw + 22, y0 + sh / 2 - 10), '~60 m', font=f(18, True), fill=GOLD)
d.text((40, 640), 'Sơ đồ tự vẽ minh hoạ theo thông số bên bán cung cấp, không theo tỉ lệ', font=f(15), fill=(150, 170, 190))
p = f'{O}/chuyen-nhuong-dat-tmdv-mat-tien-hoang-van-thai.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
