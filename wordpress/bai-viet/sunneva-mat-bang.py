# Sơ đồ mặt bằng Sunneva Island: tô lại theo màu từng điểm của mặt bằng tổng thể dự án (giữ đúng vị trí lô, đường, cầu, sông),
# bỏ toàn bộ chữ, số lô, logo, địa chỉ web của bản gốc; chữ và chú thích viết lại.
# Chạy: python3 -I sunneva-mat-bang.py <ảnh mặt bằng gốc> (cần numpy, scipy).
import os, sys
import numpy as np
from PIL import Image, ImageDraw, ImageFont
from scipy import ndimage

src = np.asarray(Image.open(sys.argv[1]).convert('RGB')).astype(int)
Hs, Ws = src.shape[:2]
R, G, B = src[..., 0], src[..., 1], src[..., 2]
mx, mn = src.max(-1), src.min(-1)

PAL = {  # lớp: màu phẳng
    0: (191, 230, 245),  # sông
    1: (240, 138, 60),   # biệt thự song lập
    2: (74, 168, 224),   # biệt thự đơn lập
    3: (245, 224, 58),   # townhouse
    4: (126, 186, 92),   # cây xanh, công viên
    5: (196, 196, 196),  # đường
    6: (255, 255, 255),  # vỉa, khe giữa lô
    7: (226, 226, 220),  # đất liền / lô khu lân cận
    8: (31, 63, 191),    # viền Habora
    9: (192, 36, 154),   # viền Centria
    10: (198, 40, 40),   # viền Rivera
}
cls = np.full((Hs, Ws), 255, np.uint8)
gray = (mx - mn) < 22
cls[gray & (mx >= 215)] = 6
cls[gray & (mx < 215) & (mx >= 150)] = 7
cls[gray & (mx < 150) & (mx >= 70)] = 5
cls[(G > R + 12) & (G > B + 12)] = 4
cls[(R > 70) & (R < 175) & (G > 170) & (B > 215) & (B - R > 50)] = 0
cls[(R < 70) & (B > 180) & (G > 120)] = 2
cls[(R > 200) & (G > 90) & (G < 165) & (B < 110)] = 1
cls[(R > 195) & (G > 195) & (B < 110)] = 3
cls[(R > 180) & (G < 70) & (B < 80)] = 10
cls[(R > 150) & (B > 140) & (G < 100)] = 9
cls[(B > 110) & (R < 70) & (G < 90)] = 8
cls[(R > 240) & (G > 165) & (B > 95) & (B < 170)] = 255  # vòng tròn số tiện ích → lấp theo xung quanh

# lấp điểm chưa phân loại (chữ, số, viền) theo lớp phổ biến nhất xung quanh
def majority(c, size, keep=()):
    best = np.zeros(c.shape, np.float32); out = c.copy()
    for k in PAL:
        if k in keep: continue
        sc = ndimage.uniform_filter((c == k).astype(np.float32), size)
        m = sc > best; out[m] = k; best[m] = sc[m]
    return out
lines = np.isin(cls, (8, 9, 10))
for _ in range(3):
    unk = cls == 255
    if not unk.any(): break
    fill = majority(cls, 15, keep=(8, 9, 10))
    cls[unk] = fill[unk]
# chữ trắng trên đường → đường; khe trắng giữa các lô giữ nguyên
frac = lambda ks, n: ndimage.uniform_filter(np.isin(cls, ks).astype(np.float32), n)
roadtxt = (cls == 6) & (frac((5, 7), 13) > 0.35) & (frac((1, 2, 3), 13) < 0.12)
cls[roadtxt] = 5
watertxt = np.isin(cls, (6, 7)) & (frac((0,), 25) > 0.55) & (frac((1, 2, 3), 25) < 0.02)
cls[watertxt] = 0
# số diện tích màu đỏ trên lô → lô (viền phân khu là nét mảnh nằm ngoài lô)
for k in (8, 9, 10):
    near = (cls == k) & (frac((1, 2, 3), 9) > 0.45)
    cls[near] = 255
for _ in range(2):
    unk = cls == 255
    if not unk.any(): break
    fill = majority(cls, 9, keep=(8, 9, 10))
    cls[unk] = fill[unk]
sm = majority(cls, 3)
cls = np.where(np.isin(cls, (6, 8, 9, 10)), cls, sm)
# đốm cam nhỏ còn sót của vòng tròn tiện ích
lab, n = ndimage.label(cls == 1)
sizes = ndimage.sum(np.ones_like(lab), lab, range(1, n + 1))
small = np.isin(lab, np.nonzero(sizes < 700)[0] + 1)
cls[small] = 255
fill = majority(cls, 15)
cls[small] = fill[small]
# làm rõ khe giữa các lô (sau khi thu nhỏ vẫn thấy từng căn)
lotm = np.isin(cls, (1, 2, 3))
gap = ndimage.binary_dilation(cls == 6, iterations=2) & lotm & (frac((1, 2, 3), 9) > 0.5)
cls[gap] = 6

img = Image.fromarray(np.array([PAL.get(i, (255, 255, 255)) for i in range(256)], np.uint8)[cls])
W = 1600; Hh = round(Hs * W / Ws)
img = img.resize((W, Hh), Image.LANCZOS)
d = ImageDraw.Draw(img)
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)
sx = W / 2000  # toạ độ dưới đây theo bản gốc rộng 2000 px

def tag(x, y, text, col='#333', size=22, bold=True, bg='white'):
    x, y = x * sx, y * sx; f = F(size, bold); w = d.textlength(text, font=f)
    if bg: d.rounded_rectangle((x - w/2 - 10, y - size*0.78, x + w/2 + 10, y + size*0.78), 9, fill=bg, outline=col, width=3)
    d.text((x, y), text, font=f, fill=col, anchor='mm')

# che logo, địa chỉ web của bản gốc
d.rectangle((1660*sx, 20*sx, 1980*sx, 110*sx), fill=PAL[4])
# tiêu đề
d.rounded_rectangle((20, 20, 790, 112), 14, fill='white', outline='#0d3b66', width=2)
d.text((40, 30), 'SƠ ĐỒ MẶT BẰNG SUNNEVA ISLAND', font=F(36, True), fill='#0d3b66')
d.text((40, 76), 'Đảo Đồng Nò, Hòa Quý (Ngũ Hành Sơn) · 3 phân khu · 2 cầu', font=F(22), fill='#333')
# nhãn
tag(1290, 205, 'Cầu → đường Chương D, hướng đi biển', size=20)
tag(700, 1155, 'Cầu → KĐT Nam Hòa Xuân', size=20)
tag(560, 600, 'HABORA', '#1f3fbf', 26)
tag(1080, 640, 'CENTRIA', '#c0249a', 22)
tag(1420, 760, 'RIVERA', '#c62828', 26)
for x, y in ((420, 205), (1640, 520), (720, 868), (1130, 1230)):
    tag(x, y, 'Sông Đô Toả', '#2b6f99', 24, False, bg=None)
tag(1135, 62, 'Đường Chương D', '#555', 18, False, bg='white')
# chú thích
x0, y0, x1, y1 = 20, 770, 400, 1288
d.rounded_rectangle((x0, y0*sx, 395, y1*sx - 12), 14, fill='white', outline='#0d3b66', width=2)
yy = y0*sx + 14
d.text((x0 + 18, yy), 'Chú thích', font=F(22, True), fill='#0d3b66')
for i, (k, t) in enumerate(((3, 'Townhouse'), (1, 'Biệt thự song lập'), (2, 'Biệt thự đơn lập'), (4, 'Công viên, cây xanh'))):
    y = yy + 36 + i*30; d.rectangle((x0+18, y, x0+48, y+20), fill=PAL[k]); d.text((x0+60, y+10), t, font=F(19), fill='#222', anchor='lm')
for i, (k, t) in enumerate(((8, 'Habora'), (9, 'Centria'), (10, 'Rivera'))):
    x = x0 + 18 + i*118; y = yy + 160; d.rectangle((x, y+3, x+26, y+19), outline=PAL[k], width=4); d.text((x+34, y+11), t, font=F(18), fill='#222', anchor='lm')
d.text((x0 + 18, yy + 200), 'Tiện ích', font=F(20, True), fill='#0d3b66')
for i, t in enumerate(('Công viên ven sông, đường dạo bộ', 'Công viên nội khu, cảnh quan', 'Khu thể thao, khu giáo dục', 'Nhà sinh hoạt cộng đồng, hồ bơi')):
    d.text((x0 + 18, yy + 232 + i*26), '• ' + t, font=F(17), fill='#333')
# chân trang (che cả địa chỉ web bản gốc)
d.rectangle((0, 1288*sx, W, Hh), fill='white')
d.text((20, (1288*sx + Hh)/2), 'Sơ đồ tô lại theo mặt bằng tổng thể dự án Sunneva Island (Sun Group) – để tham khảo. Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(19), fill='#333', anchor='lm')

out = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'sunneva-island', 'sunneva-island-mat-bang-chi-tiet.jpg')
img.save(out, quality=88); print(out, img.size)
