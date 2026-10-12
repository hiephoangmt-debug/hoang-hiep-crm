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

# vùng cắt quanh sông Hàn
CX0, CY0, CX1, CY1 = 230, 30, 1110, 1770
mapimg = base.crop((CX0, CY0, CX1, CY1))
MH = 1080; s = MH / (CY1 - CY0); MW = round((CX1 - CX0) * s)
mapimg = mapimg.resize((MW, MH), Image.LANCZOS)

P = [('Hòa Bình Green', 35, 40, 'Đ', 650, 98), ('The Peninsula', 68, 80, 'Đ', 742, 348), ('Blue House', 42, 44, 'Đ', 788, 276),
     ('Vicoland', 44, 46, 'Đ', 841, 399), ('Sun Symphony', 100, 124, 'Đ', 769, 475), ('Azura', 85, 95, 'Đ', 836, 997),
     ('Capital Square', 90, 98, 'Đ', 843, 1045), ('The Legend City', 132, 145, 'Đ', 928, 1313), ('Sun Ponte', 99, 116, 'Đ', 860, 1441),
     ('The Monarchy', 69, 72, 'Đ', 930, 1531), ('Sun Cosmo', 86, 106, 'Đ', 1014, 1672),
     ('Blooming Tower', 39, 41, 'T', 355, 345), ('SAM Towers', 81, 88, 'T', 538, 468), ('F.Home', 65, 66, 'T', 515, 690),
     ('Đà Nẵng Plaza', 54, 57, 'T', 590, 718), ('La Paz Tower', 58, 67, 'T', 511, 835), ('M Landmark', 208, 228, 'T', 646, 965),
     ('Sun Solar', 112, 122, 'T', 578, 992), ('Indochina Riverside', 72, 85, 'T', 651, 1036), ('Landmark Tower', 118, 128, 'T', 614, 1469),
     ('The Filmore', 174, 212, 'T', 610, 1522)]
P.sort(key=lambda p: -p[2])
def tier(v):
    return '#22c55e' if v < 60 else '#f5b301' if v < 100 else '#fb7a2c' if v < 150 else '#ef4444'

W, H = 1080, 1350
im = Image.new('RGB', (W, H), '#0f2236'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 150], fill='#0b1a2a'); d.rectangle([0, 148, W, 152], fill='#e8b04a')
d.text((36, 24), 'GIÁ CĂN HỘ VEN SÔNG HÀN · 10/2026', font=F(24, True), fill='#e8b04a')
d.text((36, 60), 'Bản đồ 21 dự án hai bờ sông Hàn', font=F(40, True), fill='white')
d.text((36, 112), 'Giá rao tham khảo, triệu đồng/m² · ghim số = hạng giá', font=F(19), fill='#c9d6e3')
MX, MY = 20, 172
im.paste(mapimg, (MX, MY)); d.rounded_rectangle([MX, MY, MX + MW, MY + MH], 14, outline='#e8b04a', width=3)
T = lambda x, y: (MX + (x - CX0) * s, MY + (y - CY0) * s)
for name, x, y, ox, oy in (('Cầu Thuận Phước', 514, 190, 0, 18), ('Cầu Sông Hàn', 725, 962, 30, -26), ('Cầu Rồng', 754, 1336, 0, 18), ('Cầu Trần Thị Lý', 826, 1702, -20, -26)):
    px, py = T(x, y)
    d.rectangle([px - 34, py - 4, px + 34, py + 4], fill='#c9d6e3')
    w = d.textlength(name, font=F(14, True)); lx, ly2 = px + ox, py + oy
    d.rounded_rectangle([lx - w / 2 - 6, ly2 - 10, lx + w / 2 + 6, ly2 + 10], 5, fill='#e8b04a')
    d.text((lx, ly2), name, font=F(14, True), fill='#0b1a2a', anchor='mm')
px, py = T(560, 150); d.text((px, py), 'Sông Hàn', font=F(18, True), fill='#d6ecff', anchor='mm')
px, py = T(340, 700); d.text((px, py), 'HẢI CHÂU', font=F(16, True), fill='#8fa9c4', anchor='mm')
px, py = T(1020, 820); d.text((px, py), 'SƠN TRÀ', font=F(16, True), fill='#8fa9c4', anchor='mm')
# nhãn giá cạnh ghim: bờ Tây ghi bên trái, bờ Đông bên phải; vài ghim sát nhau dời lên / xuống
NUDGE = {'M Landmark': (0, -26), 'Sun Solar': (0, 0), 'Indochina Riverside': (0, 22), 'Azura': (0, -20), 'Capital Square': (0, 14),
         'F.Home': (0, -14), 'Đà Nẵng Plaza': (0, 14), 'Landmark Tower': (0, -8), 'The Filmore': (0, 10), 'Sun Cosmo': (0, -30)}
for i, (name, a, b, bank, x, y) in enumerate(P, 1):
    px, py = T(x, y)
    txt = f'{a}–{b}'; f = F(14, True); w = d.textlength(txt, font=f) + 14
    dx, dy = NUDGE.get(name, (0, 0)); ly2 = py + dy
    left = (bank == 'T') != (name in ('Blooming Tower', 'Sun Cosmo'))  # 2 ghim sát mép khung: đổi bên
    if left:
        lx1 = px - 19; lx0 = lx1 - w
    else:
        lx0 = px + 19; lx1 = lx0 + w
    if dy:
        d.line([px, py, (lx1 if left else lx0), ly2], fill=tier(b), width=2)
    d.rounded_rectangle([lx0, ly2 - 11, lx1, ly2 + 11], 6, fill='#0b1a2a', outline=tier(b), width=2)
    d.text(((lx0 + lx1) / 2, ly2), txt, font=f, fill=tier(b), anchor='mm')
for i, (name, a, b, bank, x, y) in enumerate(P, 1):
    px, py = T(x, y)
    d.ellipse([px - 15, py - 15, px + 15, py + 15], fill=tier(b), outline='#0b1a2a', width=3)
    d.text((px, py), str(i), font=F(14, True), fill='#0b1a2a', anchor='mm')
# bảng xếp hạng
TX = MX + MW + 26; ty = 176
d.text((TX, ty), 'Xếp hạng giá', font=F(24, True), fill='#e8b04a'); ty += 40
for i, (name, a, b, bank, x, y) in enumerate(P, 1):
    yy = ty + (i - 1) * 46
    d.rounded_rectangle([TX, yy, W - 24, yy + 40], 8, fill='#1b3550')
    d.ellipse([TX + 8, yy + 6, TX + 36, yy + 34], fill=tier(b)); d.text((TX + 22, yy + 20), str(i), font=F(14, True), fill='#0b1a2a', anchor='mm')
    d.text((TX + 46, yy + 20), name, font=F(17, True), fill='white', anchor='lm')
    d.text((W - 34, yy + 20), f'{a} – {b}', font=F(17, True), fill=tier(b), anchor='rm')
ly = MY + MH + 16
x = 36
for lab, v in (('Dưới 60', 50), ('60 – 100', 80), ('100 – 150', 120), ('Trên 150', 200)):
    d.ellipse([x, ly, x + 22, ly + 22], fill=tier(v)); d.text((x + 30, ly + 11), lab, font=F(19), fill='#e6eef6', anchor='lm'); x += 30 + d.textlength(lab, font=F(19)) + 30
d.text((36, H - 20), 'Số liệu giá rao: Biggee.vn (không phải giá giao dịch). Đồ hoạ: Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(15), fill='#8fa9c4', anchor='lm')
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'gia-can-ho-song-han-10-2026-zalo.jpg')
im.save(out, quality=90); print(out, MW)
