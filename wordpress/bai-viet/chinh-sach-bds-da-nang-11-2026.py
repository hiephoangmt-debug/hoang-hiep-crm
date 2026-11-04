"""Ảnh bìa tự vẽ: chính sách mới ảnh hưởng BĐS Đà Nẵng (11/2026)."""
import sys
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
W, H = 1600, 1067
im = Image.new('RGB', (W, H), '#0f2240')
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM = '#d8b16a', '#f7f1e3'
d.text((70, 60), 'BẢN TIN CHÍNH SÁCH · 11/2026', font=f(30, True), fill=GOLD)
d.text((70, 108), 'Chính sách mới ảnh hưởng', font=f(64, True), fill=CREAM)
d.text((70, 188), 'bất động sản Đà Nẵng', font=f(64, True), fill=CREAM)
rows = [
    ('Quy hoạch', 'Quy hoạch chung Đà Nẵng đến 2050 – QĐ 2016/QĐ-TTg'),
    ('Đất đai', 'Thủ tục hành chính đất đai mới – QĐ 135/2026'),
    ('Giá đất', 'Hệ số điều chỉnh giá đất 2026 – QĐ 101/2026'),
    ('Phân lô', 'Khu vực được chuyển nhượng đất có hạ tầng – QĐ 30/2026'),
    ('Nhà ở XH', 'Chỉ thị 10 và QĐ 111/2026 về nhà ở xã hội'),
    ('Sắp tới', 'Dự thảo Luật Đất đai sửa đổi (dự kiến 2027)'),
]
y = 310
for tag, txt in rows:
    d.rounded_rectangle([70, y, 290, y + 74], radius=14, fill=GOLD)
    tw = d.textlength(tag, font=f(28, True))
    d.text((180 - tw / 2, y + 20), tag, font=f(28, True), fill='#0f2240')
    d.text((320, y + 20), txt, font=f(30), fill=CREAM)
    y += 102
d.text((70, H - 70), 'Hoàng Hiệp tổng hợp – thông tin tham khảo · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
im.save(OUT, quality=88, optimize=True, progressive=True)
