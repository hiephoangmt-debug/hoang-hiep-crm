# Ảnh giá căn hộ ven sông Hàn (giá rao, triệu/m²) – số liệu Biggee.vn, tự vẽ lại: bản dọc (Zalo) + bản ngang (ảnh đại diện bài).
import os
from PIL import Image, ImageDraw, ImageFont
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)
WEST = [('Blooming Tower', 39, 41), ('SAM Towers', 81, 88), ('F.Home Apartment', 65, 66), ('Đà Nẵng Plaza', 54, 57), ('La Paz Tower', 58, 67),
        ('M Landmark Residence', 208, 228), ('Sun Solar', 112, 122), ('Indochina Riverside', 72, 85), ('Landmark Tower', 118, 128), ('The Filmore', 174, 212)]
EAST = [('Hòa Bình Green', 35, 40), ('The Peninsula', 68, 80), ('Blue House', 42, 44), ('Vicoland', 44, 46), ('Sun Symphony', 100, 124),
        ('Azura', 85, 95), ('Capital Square', 90, 98), ('The Legend City', 132, 145), ('Sun Ponte', 99, 116), ('The Monarchy', 69, 72), ('Sun Cosmo', 86, 106)]
def tier(v):
    return ('#2e7d4f', 'Dưới 60') if v < 60 else ('#b7791f', '60 – 100') if v < 100 else ('#c2410c', '100 – 150') if v < 150 else ('#b91c1c', 'Trên 150')
OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'tin-tuc')

# ---------- Bản dọc 1080 × 1350 (Zalo, Facebook) ----------
W, H = 1080, 1350
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 150], fill='#1f3a50')
d.text((40, 24), 'GIÁ CĂN HỘ VEN SÔNG HÀN · 10/2026', font=F(24, True), fill='#e8b04a')
d.text((40, 62), '21 dự án hai bờ sông Hàn', font=F(44, True), fill='white')
d.text((40, 116), 'Giá rao tham khảo, triệu đồng/m²', font=F(20), fill='#c9d6e3')
top, bot = 210, 1215
rx0, rx1 = 470, 610
d.polygon([(rx0 + 10, top - 20), (rx1 + 30, top - 20), (rx1 - 10, bot + 20), (rx0 - 25, bot + 20)], fill='#9fd3ee')
d.text((540, 770), 'S\nÔ\nN\nG\n\nH\nÀ\nN', font=F(19, True), fill='#2b6f99', anchor='mm', align='center', spacing=2)
bridges = [('Cầu Thuận Phước', top + 20), ('Cầu Sông Hàn', 640), ('Cầu Rồng', 900), ('Cầu Trần Thị Lý', bot - 20)]
for name, y in bridges:
    d.rectangle([rx0 - 35, y - 7, rx1 + 35, y + 7], fill='#7a7a7a')
    w = d.textlength(name, font=F(18, True)); ty = y + 22 if name == 'Cầu Trần Thị Lý' else y - 22
    d.rounded_rectangle([540 - w / 2 - 10, ty - 12, 540 + w / 2 + 10, ty + 12], 6, fill='#b91c1c')
    d.text((540, ty), name, font=F(18, True), fill='white', anchor='mm')
d.text((rx0 - 40, top - 48), 'Hải Châu – Thanh Khê', font=F(20, True), fill='#1f3a50', anchor='rm')
d.text((rx1 + 40, top - 48), 'Sơn Trà', font=F(20, True), fill='#1f3a50', anchor='lm')
def side(items, ys, left):
    for (name, a, b), y in zip(items, ys):
        col, _ = tier(b)
        bx = rx0 - 6 if left else rx1 + 6
        d.ellipse([bx - 7, y - 7, bx + 7, y + 7], fill='#facc15', outline='#1f3a50', width=2)
        x1 = 440 if left else 640
        d.line([bx, y, x1, y], fill='#8a7a68', width=2)
        bw = 400
        x = x1 - bw if left else x1
        d.rounded_rectangle([x, y - 34, x + bw, y + 34], 10, fill='white')
        d.rounded_rectangle([x + (bw - 8 if left else 0), y - 34, x + (bw if left else 8), y + 34], 4, fill=col)
        d.text((x + 18, y - 15), name, font=F(21, True), fill='#1f3a50', anchor='lm')
        d.text((x + 18, y + 15), f'{a} – {b}', font=F(21, True), fill=col, anchor='lm')
# vị trí dọc theo bờ (bám thứ tự Bắc → Nam, cầu Sông Hàn ở giữa, cầu Rồng phía dưới)
side(WEST, [265, 355, 445, 535, 610, 690, 770, 850, 1060, 1150], True)
side(EAST, [255, 335, 415, 495, 575, 660, 740, 930, 1010, 1090, 1165], False)
ly = 1250
d.text((40, ly + 10), 'Mức giá:', font=F(19, True), fill='#1f3a50', anchor='lm')
x = 140
for v in (50, 80, 120, 200):
    col, lab = tier(v)
    d.rounded_rectangle([x, ly, x + 22, ly + 20], 4, fill=col); d.text((x + 30, ly + 10), lab, font=F(19), fill='#333', anchor='lm'); x += 30 + d.textlength(lab, font=F(19)) + 34
d.text((40, H - 34), 'Số liệu: Biggee.vn (giá rao, không phải giá giao dịch). Đồ hoạ: Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(16), fill='#6b5a48')
im.save(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'gia-can-ho-song-han-10-2026-zalo.jpg'), quality=90)

# ---------- Bản ngang 1200 × 675 (ảnh đại diện bài) ----------
W, H = 1200, 675
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 112], fill='#1f3a50')
d.text((40, 18), 'GIÁ CĂN HỘ VEN SÔNG HÀN · 10/2026', font=F(20, True), fill='#e8b04a')
d.text((40, 50), 'Xếp hạng giá rao 21 dự án hai bờ (triệu/m²)', font=F(32, True), fill='white')
rows = sorted([(n, a, b, 'Tây') for n, a, b in WEST] + [(n, a, b, 'Đông') for n, a, b in EAST], key=lambda r: -r[2])
colw = 560
BANK = {'Tây': '#1f3a50', 'Đông': '#1f8a8a'}
for i, (n, a, b, bank) in enumerate(rows):
    c, r = divmod(i, 11)
    x = 40 + c * (colw + 40); y = 130 + r * 44
    col, _ = tier(b)
    d.ellipse([x, y + 10, x + 12, y + 22], fill=BANK[bank])
    d.text((x + 20, y + 16), {'M Landmark Residence': 'M Landmark'}.get(n, n), font=F(17, True), fill='#1f3a50', anchor='lm')
    bx = x + 232; scale = 240 / 230
    d.rounded_rectangle([bx, y + 7, bx + b * scale, y + 25], 5, fill='#e5dccf')
    d.rounded_rectangle([bx + a * scale, y + 7, bx + b * scale, y + 25], 5, fill=col)
    d.text((bx + b * scale + 8, y + 16), f'{a} – {b}', font=F(15, True), fill=col, anchor='lm')
lx = 640; ly = 130 + 10 * 44 + 4
for k, (lab, colr) in enumerate((('Bờ Tây (Hải Châu – Thanh Khê)', BANK['Tây']), ('Bờ Đông (Sơn Trà)', BANK['Đông']))):
    d.ellipse([lx, ly + 10 + k * 26, lx + 12, ly + 22 + k * 26], fill=colr); d.text((lx + 20, ly + 16 + k * 26), lab, font=F(15), fill='#333', anchor='lm')
d.text((40, H - 28), 'Số liệu: Biggee.vn (giá rao, không phải giá giao dịch). Đồ hoạ: Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(15), fill='#6b5a48')
im.save(os.path.join(OUT, 'gia-can-ho-song-han-10-2026.jpg'), quality=88)
print('ok')
