"""Ảnh tự vẽ: sơ đồ các khu vực dự kiến cải tạo cảnh quan hai bờ sông Hàn (minh hoạ, không theo tỉ lệ)."""
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
d.text((40, 30), 'HẠ TẦNG · SÔNG HÀN', font=f(22, True), fill=GOLD)
d.text((40, 62), 'Cải tạo cảnh quan', font=f(40, True), fill='white')
d.text((40, 110), 'hai bờ sông Hàn', font=f(40, True), fill='white')
d.text((40, 170), 'Khoảng 29,22 ha · 5 phường', font=f(24), fill=(190, 210, 230))
d.text((40, 204), 'Sơn Trà, An Hải, Hải Châu,', font=f(20), fill=(170, 195, 220))
d.text((40, 230), 'Hòa Cường, Ngũ Hành Sơn', font=f(20), fill=(170, 195, 220))
for i, (c, t) in enumerate([((235, 90, 110), 'Bờ Tây: khu vực 1 – 4.3'), ((90, 160, 235), 'Bờ Đông: khu vực 5.1 – 6'), ((230, 230, 240), 'Cầu qua sông')]):
    y = 300 + i * 36
    d.rectangle([40, y + 4, 72, y + 20], fill=c); d.text((84, y), t, font=f(19), fill='white')
d.text((40, 430), 'Bến thủy nội địa, tuyến đi bộ,', font=f(19), fill=(230, 220, 190))
d.text((40, 456), 'chiếu sáng công trình và cầu,', font=f(19), fill=(230, 220, 190))
d.text((40, 482), 'mở lối tiếp cận mặt nước.', font=f(19), fill=(230, 220, 190))
# sông: dải dọc
rx0, rx1, top, bot = 640, 800, 30, 600
d.rectangle([rx0, top, rx1, bot], fill=(30, 80, 120))
d.text((690, 258), 'SÔNG', font=f(20, True), fill=(160, 205, 235)); d.text((694, 284), 'HÀN', font=f(20, True), fill=(160, 205, 235))
bridges = [(70, 'Cầu Thuận Phước'), (210, 'Cầu Sông Hàn'), (360, 'Cầu Rồng'), (500, 'Cầu Trần Thị Lý'), (585, 'Cầu Tiên Sơn')]
for y, name in bridges:
    d.rectangle([rx0 - 30, y - 4, rx1 + 30, y + 4], fill=(230, 230, 240))
    d.text((rx1 + 40, y - 11), name, font=f(17, True), fill=(230, 230, 240))
west = [(90, 190, '1'), (150, 205, '2'), (220, 350, '3.1'), (370, 430, '3.2'), (440, 492, '4.1'), (512, 540, '4.2'), (548, 576, '4.3')]
east = [(90, 200, '6'), (220, 350, '5.1'), (370, 430, '5.2'), (440, 492, '5.3')]
for y0, y1, lab in west:
    d.rectangle([rx0 - 16, y0, rx0 - 4, y1], fill=(235, 90, 110))
    d.text((rx0 - 30 - d.textlength('KV ' + lab, font=f(16, True)), (y0 + y1) / 2 - 9), 'KV ' + lab, font=f(16, True), fill=(250, 170, 180))
for y0, y1, lab in east:
    d.rectangle([rx1 + 4, y0, rx1 + 16, y1], fill=(90, 160, 235))
    d.text((rx1 + 24, (y0 + y1) / 2 - 9), 'KV ' + lab, font=f(16, True), fill=(160, 205, 245))
d.text((40, 640), 'Sơ đồ tự vẽ theo bản đồ khu vực dự kiến đang được chia sẻ, không theo tỉ lệ', font=f(15), fill=(150, 170, 190))
p = f'{O}/cai-tao-canh-quan-hai-bo-song-han.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
