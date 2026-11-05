"""Ảnh bìa FB dọc 1080×1350 – FPT Plaza 3, các căn đã có sổ đang bán (giá theo bài FB 05/11/2026).
Chạy: python3 fb-fpt-plaza-3-can-co-so-11-2026.py <anh-phoi-canh.jpg> <anh-dai-dien.jpg> <out.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

PHOTO, AVA, OUT = sys.argv[1:4]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
ROWS = [
    ('1PN', '42 m²', 'Ban công Tây Bắc', '2,35 – 2,5 tỷ'),
    ('1PN+', '50 m²', 'Hướng Bắc, đủ nội thất', '2,3x tỷ'),
    ('2PN', '57 m²', 'Đông / Bắc, nội thất CĐT', '2,6x tỷ'),
    ('2PN', '62 – 64 m²', 'Có căn góc hướng Nam', '3,05 – 3,5 tỷ'),
    ('2PN', '67 m²', 'Nội thất CĐT', '3,5x tỷ'),
    ('2PN', '69 m²', 'Tầng cao, Đông Nam', '3,8 tỷ'),
    ('3PN', '74 m²', 'Đông Bắc, đủ nội thất', '4,25 tỷ'),
]
W, H, S = 1080, 1350, 2
F = lambda n, s: ImageFont.truetype(I + n, s * S)
P = lambda *v: tuple(int(x * S) for x in v)


def cover(img, w, h, fy=0.5):
    r = max(w / img.width, h / img.height)
    img = img.resize((int(img.width * r) + 1, int(img.height * r) + 1), Image.LANCZOS)
    x, y = (img.width - w) // 2, int((img.height - h) * fy)
    return img.crop((x, y, x + w, y + h))


im = Image.new('RGB', (W * S, H * S), NAVY)
d = ImageDraw.Draw(im)
for y in range(540 * S):
    t = y / (540 * S)
    d.line([(0, y), (W * S, y)], fill=tuple(int(a + (b - a) * t) for a, b in zip((10, 24, 48), (22, 44, 80))))
# Ảnh tòa nhà bên phải phần đầu, chữ bên trái
ph = cover(Image.open(PHOTO).convert('RGB'), 430 * S, 470 * S, 0.35)
m = Image.new('L', ph.size, 0)
ImageDraw.Draw(m).rounded_rectangle((0, 0, ph.size[0] - 1, ph.size[1] - 1), radius=26 * S, fill=255)
im.paste(ph, P(590, 50), m)
d = ImageDraw.Draw(im, 'RGBA')
tag = 'FPT CITY · NGŨ HÀNH SƠN'
ft = F('Inter-Bold.otf', 21)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 60, 60 + tw + 40, 100), radius=20 * S, fill=GOLD)
d.text(P(80, 68), tag, font=ft, fill=NAVY)
d.text(P(58, 126), 'FPT Plaza 3', font=F('InterDisplay-ExtraBold.otf', 74), fill=CREAM)
d.text(P(60, 214), 'Căn hộ đã có sổ', font=F('InterDisplay-Bold.otf', 46), fill=(255, 200, 140))
d.text(P(60, 280), 'Giá từ 2,3x tỷ đồng', font=F('Inter-SemiBold.otf', 32), fill=CREAM)
d.text(P(60, 330), 'Công chứng sang tên nhanh', font=F('Inter-Regular.otf', 26), fill=MUTED)
d.text(P(60, 368), 'Gần Đại học FPT, FPT Complex', font=F('Inter-Regular.otf', 26), fill=MUTED)
d.text(P(60, 406), 'Ở hoặc cho thuê đều phù hợp', font=F('Inter-Regular.otf', 26), fill=MUTED)

# Bảng giá
y0 = 552
d.line(P(0, y0 - 14, W, y0 - 14), fill=GOLD, width=3 * S)
d.text(P(60, y0 + 4), 'Các căn đang bán', font=F('Inter-Bold.otf', 28), fill=GOLD)
y = y0 + 56
for i, (loai, dt, mt, gia) in enumerate(ROWS):
    if i % 2 == 0:
        d.rounded_rectangle(P(48, y - 8, W - 48, y + 58), radius=12 * S, fill=NAVY2)
    d.text(P(64, y + 2), loai, font=F('Inter-Bold.otf', 28), fill=CREAM)
    d.text(P(170, y + 2), dt, font=F('Inter-SemiBold.otf', 26), fill=CREAM)
    d.text(P(170, y + 33), mt, font=F('Inter-Regular.otf', 20), fill=MUTED)
    d.text(P(W - 64, y + 10), gia, font=F('Inter-Bold.otf', 30), fill=GOLD, anchor='ra')
    y += 74

ay = 1200
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1322), 'Ảnh: phối cảnh dự án', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
