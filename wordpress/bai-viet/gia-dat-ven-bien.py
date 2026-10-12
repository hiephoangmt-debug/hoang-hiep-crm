# Đồ hoạ bài "Giá đất ven biển Đà Nẵng 10/2026": khoảng giá rao lô nhỏ / lô lớn theo tuyến (triệu đồng/m²).
import os
from PIL import Image, ImageDraw, ImageFont
W, H = 1200, 675
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 132], fill='#1f3a50')
d.text((48, 22), 'GIÁ ĐẤT VEN BIỂN ĐÀ NẴNG · THÁNG 10/2026', font=f(22, True), fill='#e8b04a')
d.text((48, 58), 'Mặt tiền biển: lô nhỏ và lô lớn theo tuyến đường', font=f(36, True), fill='white')
rows = [  # tuyến, (lô nhỏ min, max), (lô lớn min, max)
    ('Hoàng Sa', (330, 415), (170, 400)),
    ('Võ Nguyên Giáp', (130, 390), (200, 200)),
    ('Nguyễn Tất Thành (Thanh Khê)', (110, 170), (80, 180)),
    ('Trường Sa', (100, 100), (60, 130)),
    ('Nguyễn Tất Thành (Liên Chiểu)', (47, 58), (65, 135)),
    ('Lạc Long Quân (Điện Bàn)', (31, 46), (16, 30)),
]
x0, x1, vmax = 440, 1150, 450
X = lambda v: x0 + (x1 - x0) * v / vmax
y = 196
for v in range(0, 451, 50):
    d.line([X(v), 168, X(v), 600], fill='#e2d6c8', width=1)
    d.text((X(v), 604), str(v), font=f(15), fill='#8a7a68', anchor='mt')
for name, s, l in rows:
    d.text((48, y + 12), name, font=f(21, True), fill='#1f3a50')
    for (a, b), col, dy in ((s, '#c2410c', 0), (l, '#1f6f8b', 24)):
        d.rounded_rectangle([X(a), y + dy, max(X(b), X(a) + 8), y + dy + 18], 5, fill=col)
        d.text((max(X(b), X(a) + 8) + 8, y + dy + 9), f'{a} – {b}' if a != b else f'≈ {a} (ít tin)', font=f(15, True), fill=col, anchor='lm')
    y += 68
d.rounded_rectangle([X(170), 140, X(170) + 18, 156], 4, fill='#c2410c'); d.text((X(170) + 26, 148), 'Lô nhỏ, vừa (< 350 m²)', font=f(17, True), fill='#c2410c', anchor='lm')
d.rounded_rectangle([X(395), 140, X(395) + 18, 156], 4, fill='#1f6f8b'); d.text((X(395) + 26, 148), 'Lô lớn', font=f(17, True), fill='#1f6f8b', anchor='lm')
d.text((48, 148), 'Triệu đồng/m², giá rao', font=f(17), fill='#6b5a48', anchor='lm')
d.text((48, 640), 'Nguồn: tin rao Batdongsan, Alonhadat, Nhatot, Homedy… 2026 (giá chào bán, không phải giá giao dịch)', font=f(15), fill='#6b5a48')
d.text((W - 48 - d.textlength('hiephoangmt.com', font=f(18, True)), 637), 'hiephoangmt.com', font=f(18, True), fill='#1f3a50')
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'tin-tuc', 'gia-dat-ven-bien-da-nang-10-2026.jpg')
im.save(out, quality=88); print(out)
