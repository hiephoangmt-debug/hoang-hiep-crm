# Bản đồ giá căn hộ ven sông Hàn – kiểu riêng hiephoangmt.com: tô lại nền bản đồ sáng màu theo từng điểm (bỏ nhãn, chấm, viền, logo bản gốc),
# ghim đánh số theo hạng giá + bảng xếp hạng bên phải. Số liệu giá rao: Biggee.vn.
# Chạy: python3 -I gia-can-ho-song-han-ban-do.py <ảnh gốc 1440×1800>   (cần numpy, scipy)
import os, sys
import numpy as np
from PIL import Image, ImageDraw, ImageFont
from scipy import ndimage
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)

src = np.asarray(Image.open(sys.argv[1]).convert('RGB')).astype(int)
R, G, B = src[..., 0], src[..., 1], src[..., 2]
mx, mn = src.max(-1), src.min(-1); g = src.mean(-1)
cls = np.full(g.shape, 9, np.uint8)            # 9 = cần lấp
neutral = (mx - mn) < 18
cls[neutral & (g < 50)] = 0                     # nước
cls[neutral & (g >= 50) & (g < 88)] = 1         # đất
cls[neutral & (g >= 88) & (g < 150)] = 2        # đường
cls[(B - R > 40) & (B < 170)] = 0               # vùng tô sông của bản gốc → nước
# ô nhãn sáng của bản gốc (cả chữ bên trong) → lấp; vệt "nước" nhỏ (chữ tên đường, chữ trong nhãn) → lấp
box = ndimage.binary_closing((g > 170) & neutral, iterations=6)
box = ndimage.binary_fill_holes(box)
lab, n = ndimage.label(box); sz = ndimage.sum(np.ones_like(lab), lab, range(1, n + 1))
cls[np.isin(lab, np.nonzero(sz > 4000)[0] + 1)] = 9
lab, n = ndimage.label(cls == 0); sz = ndimage.sum(np.ones_like(lab), lab, range(1, n + 1))
cls[np.isin(lab, np.nonzero(sz < 6000)[0] + 1)] = 9
# lấp nhãn, chấm vàng, đường kẻ, dấu cầu, viền xanh, logo theo điểm gần nhất (ưu tiên đất)
unk = cls == 9
unk = ndimage.binary_dilation(unk, iterations=3)
idx = ndimage.distance_transform_edt(unk, return_distances=False, return_indices=True)
cls = cls[idx[0], idx[1]]
# làm mượt, bỏ chữ tên đường
best = np.zeros(cls.shape, np.float32); out = cls.copy()
for k in (0, 1, 2):
    sc = ndimage.uniform_filter((cls == k).astype(np.float32), 5); m = sc > best; out[m] = k; best[m] = sc[m]
cls = out
PAL = np.array([(64, 132, 186), (27, 49, 74), (52, 80, 110)], np.uint8)  # nước, đất, đường – tông navy
base = Image.fromarray(PAL[cls])

# Bố cục như ảnh mẫu: cả bản đồ, mỗi dự án một nhãn tên + giá, đường nối về vị trí.
def tier(v):
    return '#22c55e' if v < 60 else '#f5b301' if v < 100 else '#fb7a2c' if v < 150 else '#ef4444'
SC = 0.75; TOP, BOT = 150, 110
W = round(base.width * SC); MH = round(base.height * SC); H = TOP + MH + BOT
im = Image.new('RGB', (W, H), '#0f2236'); im.paste(base.resize((W, MH), Image.LANCZOS), (0, TOP)); d = ImageDraw.Draw(im)
T = lambda x, y: (x * SC, TOP + y * SC)
# (tên, giá thấp, giá cao, vị trí dự án x, y, ô nhãn x0, y0, x1, y1 – toạ độ ảnh gốc 1440×1800)
P = [('Hòa Bình Green', 35, 40, 650, 98, 690, 56, 944, 132), ('The Peninsula', 68, 80, 742, 348, 708, 165, 935, 240),
     ('Blue House', 42, 44, 788, 276, 880, 280, 1096, 356), ('Chung cư Vicoland', 44, 46, 841, 399, 891, 393, 1189, 468),
     ('Sun Symphony Residence', 100, 124, 769, 475, 814, 529, 1213, 604), ('Azura Đà Nẵng', 85, 95, 836, 997, 827, 842, 1062, 916),
     ('Capital Square', 90, 98, 843, 1045, 908, 1020, 1141, 1096), ('The Legend City', 132, 145, 928, 1313, 977, 1266, 1234, 1342),
     ('Sun Ponte Residence', 99, 116, 860, 1441, 930, 1382, 1260, 1458), ('The Monarchy', 69, 72, 930, 1531, 1001, 1503, 1227, 1578),
     ('Sun Cosmo Residence', 86, 106, 1014, 1672, 1060, 1649, 1408, 1724),
     ('Blooming Tower', 39, 41, 355, 345, 24, 309, 282, 384), ('SAM Towers', 81, 88, 538, 468, 254, 438, 470, 513),
     ('F.Home Apartment', 65, 66, 515, 690, 244, 556, 532, 632), ('Đà Nẵng Plaza', 54, 57, 590, 718, 227, 696, 457, 772),
     ('La Paz Tower', 58, 67, 511, 835, 234, 811, 449, 886), ('M Landmark Residence', 208, 228, 646, 965, 92, 937, 450, 1013),
     ('Sun Solar', 112, 122, 578, 992, 285, 1067, 532, 1143), ('Indochina Riverside Towers', 72, 85, 651, 1036, 138, 1202, 560, 1278),
     ('Landmark Tower', 118, 128, 614, 1469, 272, 1426, 535, 1501), ('The Filmore Da Nang', 174, 212, 610, 1522, 239, 1587, 563, 1663)]
# cầu
for name, x, y, ox, oy in (('Cầu Thuận Phước', 514, 190, -10, -34), ('Cầu Sông Hàn', 725, 962, -100, -40), ('Cầu Rồng', 754, 1336, 0, -34), ('Cầu Trần Thị Lý', 826, 1702, 0, 34)):
    px, py = T(x, y)
    d.rectangle([px - 44, py - 5, px + 44, py + 5], fill='#c9d6e3')
    f = F(19, True); w = d.textlength(name, font=f); lx, ly = px + ox, py + oy
    d.rounded_rectangle([lx - w / 2 - 9, ly - 14, lx + w / 2 + 9, ly + 14], 7, fill='#e8b04a')
    d.text((lx, ly), name, font=f, fill='#0b1a2a', anchor='mm')
# nhãn dự án: thẻ navy viền màu giá, đường nối về chấm vị trí
cards = []
for name, a, b, x, y, x0, y0, x1, y1 in P:
    fn, fp = F(19, True), F(21, True)
    price = f'{a} – {b} triệu/m²'
    w = max(d.textlength(name, font=fn), d.textlength(price, font=fp)) + 34
    cx, cy = (x0 + x1) / 2 * SC, TOP + (y0 + y1) / 2 * SC
    bx0 = min(max(cx - w / 2, 10), W - 10 - w); by0 = cy - 30
    cards.append((name, price, a, b, x, y, bx0, by0, bx0 + w, by0 + 60))
for name, price, a, b, x, y, bx0, by0, bx1, by1 in cards:
    px, py = T(x, y)
    ex = min(max(px, bx0), bx1); ey = by0 + 30 if not (bx0 <= px <= bx1) else (by0 if py < by0 else by1)
    d.line([px, py, ex, ey], fill=tier(b), width=3)
for name, price, a, b, x, y, bx0, by0, bx1, by1 in cards:
    d.rounded_rectangle([bx0, by0, bx1, by1], 10, fill='#0b1a2a', outline=tier(b), width=3)
    d.text((bx0 + 16, by0 + 17), name, font=F(19, True), fill='white', anchor='lm')
    d.text((bx0 + 16, by0 + 43), price, font=F(21, True), fill=tier(b), anchor='lm')
for name, price, a, b, x, y, *_ in cards:
    px, py = T(x, y)
    d.ellipse([px - 10, py - 10, px + 10, py + 10], fill=tier(b), outline='#0b1a2a', width=3)
px, py = T(120, 1545); d.text((px, py), 'HẢI CHÂU', font=F(22, True), fill='#8fa9c4', anchor='mm')
px, py = T(1250, 1200); d.text((px, py), 'SƠN TRÀ', font=F(22, True), fill='#8fa9c4', anchor='mm')
px, py = T(740, 1150); d.text((px, py), 'Sông Hàn', font=F(22, True), fill='#d6ecff', anchor='mm')
# tiêu đề, logo chữ, chú thích, nguồn – nền navy có lưới kẻ ô mờ, sóng biển mờ ở dải dưới
import math
def texture(y0, y1, waves=False):
    h = y1 - y0
    base = Image.new('RGBA', (W, h), (11, 26, 42, 255))
    ov = Image.new('RGBA', (W, h), (0, 0, 0, 0)); ld = ImageDraw.Draw(ov)
    for gx in range(0, W, 28):
        ld.line([gx, 0, gx, h], fill=(255, 255, 255, 18), width=1)
    for gy in range(0, h, 28):
        ld.line([0, gy, W, gy], fill=(255, 255, 255, 18), width=1)
    if waves:
        for k in range(4):
            amp, per, base_y, alpha = 4 + k * 2, 180 + k * 40, h - 6 - k * 10, 70 - k * 12
            pts = [(x, base_y + amp * math.sin(2 * math.pi * (x + k * 53) / per)) for x in range(0, W + 1, 4)]
            ld.line(pts, fill=(120, 190, 235, alpha), width=2)
    im.paste(Image.alpha_composite(base, ov).convert('RGB'), (0, y0))
texture(0, TOP)
texture(TOP + MH, H, waves=True)
d = ImageDraw.Draw(im)
d.rectangle([0, TOP - 4, W, TOP], fill='#e8b04a'); d.rectangle([0, TOP + MH, W, TOP + MH + 3], fill='#e8b04a')
d.text((32, 22), 'GIÁ CĂN HỘ VEN SÔNG HÀN · 10/2026', font=F(24, True), fill='#e8b04a')
d.text((32, 58), '21 dự án hai bờ sông Hàn', font=F(40, True), fill='white')
d.text((32, 110), 'Giá rao tham khảo, triệu đồng/m²', font=F(19), fill='#c9d6e3')
d.rounded_rectangle([W - 300, 30, W - 28, 118], 12, fill='#0b1a2a', outline='#e8b04a', width=2)
d.text((W - 164, 62), 'hiephoangmt.com', font=F(24, True), fill='white', anchor='mm')
d.text((W - 164, 94), 'Hoàng Hiệp · 0904 567 009', font=F(17), fill='#e8b04a', anchor='mm')
ly = TOP + MH + 20; x = 32
for lab, v in (('Dưới 60', 50), ('60 – 100', 80), ('100 – 150', 120), ('Trên 150', 200)):
    d.ellipse([x, ly, x + 24, ly + 24], fill=tier(v)); d.text((x + 34, ly + 12), lab, font=F(20), fill='#e6eef6', anchor='lm'); x += 34 + d.textlength(lab, font=F(20)) + 34
d.text((32, H - 30), 'Số liệu giá rao: Biggee.vn (không phải giá giao dịch). Đồ hoạ: Hoàng Hiệp · hiephoangmt.com', font=F(16), fill='#8fa9c4', anchor='lm')
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'gia-can-ho-song-han-10-2026-zalo.jpg')
im.save(out, quality=90); print(out, im.size)
