"""Ảnh bìa tự vẽ: penthouse tầng đỉnh Spana, Cora, S-Light (không dùng ảnh/bản vẽ có logo đơn vị khác)."""
import sys
from PIL import Image, ImageDraw, ImageFont

OUT = sys.argv[1]
W, H = 1600, 1067
im = Image.new('RGB', (W, H), '#0f1d3d')
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, MUTED = '#d8b16a', '#f7f1e3', '#b9c3d8'

# Đường chân trời ba tòa tháp, tầng đỉnh tô vàng.
base = 1000
for x, w, h in [(110, 140, 300), (280, 110, 240), (560, 120, 260), (720, 160, 330), (920, 120, 270), (1190, 140, 290), (1360, 120, 230)]:
    d.rectangle([x, base - h, x + w, base], fill='#17295a')
    d.rectangle([x, base - h, x + w, base - h + 26], fill=GOLD)
d.rectangle([0, base, W, H], fill='#0b1530')

def center(t, y, font, fill):
    d.text(((W - d.textlength(t, font=font)) / 2, y), t, font=font, fill=fill)

center('SUN GROUP ĐÀ NẴNG', 60, f(30, True), GOLD)
center('PENTHOUSE TẦNG ĐỈNH', 108, f(78, True), CREAM)
center('Spana · Cora · S-Light – số căn giới hạn, tầm nhìn thoáng nhất dự án', 210, f(30), MUTED)

cards = [
    ('SPANA TOWER', 'Tầng 22 · tòa S1, S2', ['1PN+ · 2PN · 3PN', 'Gợi ý duplex tầng lửng', 'Chân cầu Hòa Xuân']),
    ('CORA TOWER', 'Tầng 25 · tòa A1, A2', ['1PN · 2PN · 2PN+1', 'Gợi ý duplex tầng lửng', 'Nguyễn Phước Lan – 29/3']),
    ('S-LIGHT TOWER', 'Tầng 22 · tòa SL1, SL2', ['View sông Hàn', 'Sông Cẩm Lệ, sông Đô Tỏa', 'Sun NeO City']),
]
cw, gap, top = 440, 50, 300
x0 = (W - 3 * cw - 2 * gap) // 2
for i, (name, floor, rows) in enumerate(cards):
    x = x0 + i * (cw + gap)
    d.rounded_rectangle([x, top, x + cw, top + 330], radius=22, fill='#f7f1e3')
    d.rectangle([x, top + 22, x + cw, top + 30], fill=GOLD)
    d.text((x + 30, top + 48), name, font=f(36, True), fill='#0f1d3d')
    d.text((x + 30, top + 100), floor, font=f(27, True), fill='#9a7333')
    for j, r in enumerate(rows):
        d.text((x + 30, top + 158 + j * 50), '•  ' + r, font=f(27), fill='#25324f')
center('Nhận layout từng căn penthouse: Zalo Hoàng Hiệp 0904 567 009', 1018, f(30, True), GOLD)
im.save(OUT, quality=88, optimize=True, progressive=True)
