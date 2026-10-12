# Bản đồ giá căn hộ ven sông Hàn: giữ nền bản đồ của ảnh gốc, phủ nhãn mới (kiểu hiephoangmt.com) đúng vị trí, che logo bản gốc.
# Chạy: python3 -I gia-can-ho-song-han-ban-do.py <ảnh gốc 1440×1800>
import os, sys
from PIL import Image, ImageDraw, ImageFont
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)
src = Image.open(sys.argv[1]).convert('RGB')
TOP, BOT = 170, 120
im = Image.new('RGB', (src.width, src.height + TOP + BOT), '#1f3a50'); im.paste(src, (0, TOP)); d = ImageDraw.Draw(im)
def tier(v):
    return '#2e7d4f' if v < 60 else '#b7791f' if v < 100 else '#c2410c' if v < 150 else '#b91c1c'
# (tên, giá thấp, giá cao, ô nhãn cũ x0, y0, x1, y1)
P = [('Hòa Bình Green', 35, 40, 663, 56, 944, 132), ('The Peninsula', 68, 80, 708, 165, 935, 240), ('Blue House', 42, 44, 880, 280, 1096, 356),
     ('Chung cư Vicoland', 44, 46, 891, 393, 1189, 468), ('Sun Symphony Residence', 100, 124, 814, 529, 1213, 604), ('Azura Đà Nẵng', 85, 95, 827, 842, 1062, 916),
     ('Capital Square', 90, 98, 908, 1020, 1141, 1096), ('The Legend City', 132, 145, 977, 1266, 1234, 1342), ('Sun Ponte Residence', 99, 116, 930, 1382, 1260, 1458),
     ('The Monarchy', 69, 72, 1001, 1503, 1227, 1578), ('Sun Cosmo Residence', 86, 106, 1060, 1649, 1408, 1724),
     ('Blooming Tower', 39, 41, 24, 309, 282, 384), ('SAM Towers', 81, 88, 254, 438, 470, 513), ('F.Home Apartment', 65, 66, 244, 556, 532, 632),
     ('Đà Nẵng Plaza', 54, 57, 227, 696, 457, 772), ('La Paz Tower', 58, 67, 234, 811, 449, 886), ('M Landmark Residence', 208, 228, 92, 937, 450, 1013),
     ('Sun Solar', 112, 122, 285, 1067, 532, 1143), ('Indochina Riverside Towers', 72, 85, 138, 1202, 560, 1278), ('Landmark Tower', 118, 128, 272, 1426, 535, 1501),
     ('The Filmore Da Nang', 174, 212, 239, 1587, 563, 1663)]
for name, a, b, x0, y0, x1, y1 in P:
    y0 += TOP; y1 += TOP
    fn, fp = F(25, True), F(27, True)
    w = max(d.textlength(name, font=fn), d.textlength(f'{a} – {b} triệu/m²', font=fp)) + 44
    cx = (x0 + x1) / 2; bx0 = min(max(cx - max(w, x1 - x0 + 10) / 2, 8), im.width - 8 - max(w, x1 - x0 + 10)); bx1 = bx0 + max(w, x1 - x0 + 10)
    d.rounded_rectangle([bx0, y0 - 6, bx1, y1 + 6], 12, fill='white')
    d.rounded_rectangle([bx0, y0 - 6, bx0 + 12, y1 + 6], 6, fill=tier(b))
    d.text((bx0 + 28, y0 + 6), name, font=fn, fill='#1f3a50')
    d.text((bx0 + 28, y0 + 38), f'{a} – {b} triệu/m²', font=fp, fill=tier(b))
# cầu: phủ nhãn cũ bằng nhãn mới
for name, x0, y0, x1, y1 in (('Cầu Thuận Phước', 293, 107, 557, 157), ('Cầu Sông Hàn', 557, 880, 770, 928), ('Cầu Rồng', 645, 1256, 797, 1305), ('Cầu Trần Thị Lý', 627, 1630, 857, 1680)):
    y0 += TOP; y1 += TOP; f = F(26, True); w = d.textlength(name, font=f) + 36; cx = (x0 + x1) / 2
    d.rounded_rectangle([min(cx - w / 2, x0 - 4), y0 - 4, max(cx + w / 2, x1 + 4), y1 + 4], 10, fill='#e8b04a')
    d.text((cx, (y0 + y1) / 2), name, font=f, fill='#1f3a50', anchor='mm')
# che logo bản gốc bằng nhãn tên web
d.rounded_rectangle([1060, TOP + 50, 1410, TOP + 150], 14, fill='#1f3a50', outline='#e8b04a', width=3)
d.text((1235, TOP + 85), 'hiephoangmt.com', font=F(30, True), fill='white', anchor='mm')
d.text((1235, TOP + 122), 'Hoàng Hiệp · 0904 567 009', font=F(20), fill='#e8b04a', anchor='mm')
# tiêu đề, chú thích, nguồn
d.text((40, 28), 'GIÁ CĂN HỘ VEN SÔNG HÀN ĐÀ NẴNG · 10/2026', font=F(30, True), fill='#e8b04a')
d.text((40, 74), '21 dự án hai bờ sông Hàn – giá rao tham khảo', font=F(46, True), fill='white')
x = 40; y = TOP + src.height + 26
for lab, v in (('Dưới 60', 50), ('60 – 100', 80), ('100 – 150', 120), ('Trên 150', 200)):
    d.rounded_rectangle([x, y, x + 30, y + 26], 5, fill=tier(v)); d.text((x + 40, y + 13), lab + ' triệu/m²', font=F(22), fill='white', anchor='lm'); x += 40 + d.textlength(lab + ' triệu/m²', font=F(22)) + 40
d.text((40, y + 50), 'Nền bản đồ, số liệu giá rao: Biggee.vn (không phải giá giao dịch). Nhãn, đồ hoạ: hiephoangmt.com', font=F(19), fill='#c9d6e3')
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'gia-can-ho-song-han-10-2026-zalo.jpg')
im.resize((1080, round(im.height * 1080 / im.width)), Image.LANCZOS).save(out, quality=90)
print(out, im.size)
