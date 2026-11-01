"""Sơ đồ vị trí lô đất 4 mặt tiền Hoàng Sa – Hồ Học Lãm (Thọ Quang, Sơn Trà): tự vẽ, không dùng ảnh vệ tinh / bản đồ."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
W, H = 1200, 800
im = Image.new('RGB', (W, H), '#eef0ea'); d = ImageDraw.Draw(im)
# Biển (bên phải) và bãi cát
d.polygon([(860, 0), (W, 0), (W, H), (700, H)], fill='#9cc8e2')
d.polygon([(760, 0), (860, 0), (700, H), (590, H)], fill='#efdcae')
for y in range(40, H, 70):
    x = 900 + (y * -0.2) + 60
    d.arc([x, y, x + 80, y + 26], 200, 340, fill='white', width=3)
t = Image.new('RGBA', (300, 60), (0, 0, 0, 0)); ImageDraw.Draw(t).text((150, 30), 'BIỂN', font=f(40, True), fill='#1f5f86', anchor='mm')
im.paste(t.rotate(-70, expand=True), (930, 260), t.rotate(-70, expand=True))
# Đường Hoàng Sa (chéo, song song bờ biển)
road = [(640, 0), (740, 0), (580, H), (480, H)]
d.polygon(road, fill='#a9a39b')
for k in range(0, H, 60):
    x1 = 690 - k * 0.2; d.line([(x1, k), (x1 - 6, k + 30)], fill='white', width=4)
for cy in (250, 620):
    cx = 690 - cy * 0.2
    d.rounded_rectangle([cx - 78, cy - 20, cx + 78, cy + 20], 10, fill='#3d4a57')
    d.text((cx, cy), 'Hoàng Sa', font=f(22, True), fill='white', anchor='mm')
# Đường Hồ Học Lãm (vuông góc, đi vào trong)
d.polygon([(130, 470), (520, 545), (512, 590), (122, 515)], fill='#bdb7ae')
t = Image.new('RGBA', (300, 40), (0, 0, 0, 0)); ImageDraw.Draw(t).text((150, 20), 'Hồ Học Lãm', font=f(22, True), fill='#444', anchor='mm')
r = t.rotate(-11, expand=True); im.paste(r, (170, 488), r)
# Đường phía Bắc lô (lối hai bên)
d.polygon([(260, 250), (580, 310), (574, 340), (254, 280)], fill='#cdc8bf')
d.polygon([(250, 285), (282, 285), (250, 470), (218, 470)], fill='#cdc8bf')
# Lô đất
lot = [(285, 300), (560, 352), (528, 535), (255, 482)]
d.polygon(lot, fill='#f2b8a8', outline='#c0392b')
d.line(lot + [lot[0]], fill='#c0392b', width=6)
d.text((405, 405), '583,6 m²', font=f(34, True), fill='#7a1f12', anchor='mm')
d.text((405, 445), 'ngang 27,6 m', font=f(22, True), fill='#7a1f12', anchor='mm')
d.text((405, 475), '4 mặt tiền', font=f(20), fill='#7a1f12', anchor='mm')
# Chú thích
d.rounded_rectangle([30, 30, 560, 200], 16, fill='#1f384d')
d.text((56, 52), 'VỊ TRÍ LÔ ĐẤT', font=f(22, True), fill='#e8b04b')
d.text((56, 88), 'Hoàng Sa – Hồ Học Lãm', font=f(32, True), fill='white')
d.text((56, 132), 'Phường Thọ Quang (cũ), Sơn Trà, Đà Nẵng', font=f(20), fill='#cfe0ec')
d.text((56, 162), 'Mặt tiền đường biển · view trực diện biển', font=f(20), fill='#cfe0ec')
d.polygon([(1110, 80), (1095, 125), (1125, 125)], fill='#1f384d'); d.text((1110, 140), 'B', font=f(22, True), fill='#1f384d', anchor='mm')
d.text((30, H - 34), 'Sơ đồ minh hoạ, không theo tỷ lệ. Kích thước theo chủ đất cung cấp.', font=f(18), fill='#555')
p = f'{O}/lo-dat-4-mat-tien-hoang-sa-son-tra.jpg'; im.save(p, quality=90)
print(dd.stamp(p, tile=False))
