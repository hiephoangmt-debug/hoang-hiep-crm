"""Ảnh thẻ tin tự vẽ (4:3) cho FPT Plaza 2 – 6 căn 2PN 68 – 73 m² cần bán (16/11/2026). Chỉ hiện giá thấp nhất."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY = '#d8b16a', '#f7f1e3', '#0f2240'
W, H = 1600, 1200
im = Image.new('RGB', (W, H), NAVY)
dr = ImageDraw.Draw(im)
bx = 1080
dr.rectangle([bx, 230, bx + 330, 1020], fill='#1b3560')
for r in range(14):
    for c in range(5):
        dr.rectangle([bx + 25 + c * 62, 260 + r * 52, bx + 65 + c * 62, 290 + r * 52], fill=GOLD if (r * 5 + c) % 6 == 2 else '#2b4a7c')
dr.rectangle([60, 1020, W - 60, 1030], fill=GOLD)
dr.text((80, 70), 'FPT CITY · NGŨ HÀNH SƠN · ĐÀ NẴNG', font=f(34, True), fill=GOLD)
dr.text((80, 125), 'FPT Plaza 2', font=f(96, True), fill=CREAM)
dr.text((80, 260), '6 căn 2 phòng ngủ · 68 – 73 m²', font=f(54, True), fill=CREAM)
y = 390
for t in ['View biển, công viên, thành phố', 'Có căn góc · full nội thất', 'Sẵn sổ hồng, công chứng ngay']:
    dr.ellipse([84, y + 14, 106, y + 36], fill=GOLD)
    dr.text((130, y), t, font=f(48), fill=CREAM)
    y += 82
dr.rounded_rectangle([80, 760, 760, 900], radius=26, fill=GOLD)
dr.text((115, 785), 'Chỉ từ 2,8 tỷ', font=f(72, True), fill=NAVY)
dr.text((80, 930), 'Giá từng căn: liên hệ Hoàng Hiệp', font=f(38), fill=CREAM)
dr.text((80, 1070), 'Hoàng Hiệp · Zalo 0904 567 009 · hiephoangmt.com', font=f(40, True), fill=GOLD)
im.save(os.path.join(OUT, 'fpt-plaza-2-2pn-68-73m2-4x3.jpg'), quality=86, optimize=True, progressive=True)
