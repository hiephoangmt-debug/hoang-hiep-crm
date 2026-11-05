"""Ảnh thẻ tin tự vẽ (4:3) cho 8 căn FPT Plaza 3 cần bán – 05/11/2026. Không dùng ảnh tin rao."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY = '#d8b16a', '#f7f1e3', '#0f2240'
DIRS = {'dong': 'Đông', 'tay': 'Tây', 'nam': 'Nam', 'bac': 'Bắc', 'dong-bac': 'Đông Bắc'}
UNITS = [
    (1, 50, 'bac', 'day-du', '2,3x tỷ', False), (2, 57, 'dong', 'co-ban', '2,6x tỷ', False),
    (2, 57, 'bac', 'co-ban', '2,6x tỷ', False), (2, 67, '', 'co-ban', '3,5x tỷ', False),
    (2, 64, 'tay', 'day-du', '3,1 tỷ', False), (2, 62, 'nam', '', '3,05 tỷ', True),
    (2, 62, 'nam', 'day-du', '3,5 tỷ', True), (3, 74, 'dong-bac', 'day-du', '4,25 tỷ', False),
]
for beds, m2, d, furn, gia, goc in UNITS:
    W, H = 1600, 1200
    im = Image.new('RGB', (W, H), NAVY)
    dr = ImageDraw.Draw(im)
    # toà nhà cách điệu
    bx = 1080
    dr.rectangle([bx, 230, bx + 330, 1020], fill='#1b3560')
    for r in range(14):
        for c in range(5):
            dr.rectangle([bx + 25 + c * 62, 260 + r * 52, bx + 65 + c * 62, 290 + r * 52], fill=GOLD if (r * 5 + c) % 7 == 3 else '#2b4a7c')
    dr.rectangle([60, 1020, W - 60, 1030], fill=GOLD)
    dr.text((80, 70), 'FPT CITY · NGŨ HÀNH SƠN · ĐÀ NẴNG', font=f(34, True), fill=GOLD)
    dr.text((80, 125), 'FPT Plaza 3', font=f(96, True), fill=CREAM)
    pn = '1PN+' if beds == 1 else f'{beds} phòng ngủ'
    dr.text((80, 260), f'{pn} · {m2} m²', font=f(70, True), fill=CREAM)
    rows = []
    if d: rows.append('Hướng ' + DIRS[d] + (' · căn góc' if goc else ''))
    if furn: rows.append('Full nội thất' if furn == 'day-du' else 'Nội thất chủ đầu tư')
    rows.append('Sẵn sổ hồng')
    y = 390
    for t in rows:
        dr.ellipse([84, y + 14, 106, y + 36], fill=GOLD)
        dr.text((130, y), t, font=f(48), fill=CREAM)
        y += 82
    dr.rounded_rectangle([80, 760, 700, 900], radius=26, fill=GOLD)
    dr.text((115, 785), 'Giá ' + gia, font=f(72, True), fill=NAVY)
    dr.text((80, 930), 'Có thương lượng', font=f(40), fill=CREAM)
    dr.text((80, 1070), 'Hoàng Hiệp · Zalo 0904 567 009 · hiephoangmt.com', font=f(40, True), fill=GOLD)
    name = f'fpt-plaza-3-{beds}pn-{m2}m2' + (f'-{d}' if d else '') + ('-goc' if goc else '') + (f'-{furn}' if furn else '') + '-4x3.jpg'
    im.save(os.path.join(OUT, name), quality=86, optimize=True, progressive=True)
    print(name)
