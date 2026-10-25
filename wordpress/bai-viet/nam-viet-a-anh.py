"""Ảnh tự vẽ: giá chào bán/m² đất Nam Việt Á theo tuyến đường (10/2026, danh sách Hoàng Hiệp tổng hợp)."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 880
C = {'ong': (120, 180, 235), 'bt': (110, 200, 140), 'goc': (232, 176, 74)}
rows = [  # (nhãn, triệu/m², loại)
    ('Tuy Lý Vương · 95 m²', 77, 'ong'), ('Nguyễn Thế Kỷ · 95 m²', 79, 'ong'), ('Trịnh Lỗi · 100 m²', 80, 'ong'),
    ('Trương Công Hy · 105 m²', 81, 'ong'), ('Lê Hy Cát · 100 m²', 102, 'ong'), ('Trần Hữu Độ · 100 m²', 120, 'ong'),
    ('Nghiêm Xuân Yêm · 285 m² (BT)', 84, 'bt'), ('Nước Mặn 1 · 182,5 m² (BT)', 88, 'bt'), ('Trần Trọng Khiêm · 334 m² (BT)', 96, 'bt'),
    ('Bùi Tá Hán · 250 m² (BT)', 102, 'bt'), ('Chương Dương · 600 m² (BT)', 167, 'bt'), ('Chương Dương · 300 m² (BT)', 193, 'bt'),
    ('Góc Dương Tử Giang · 249 m²', 92, 'goc'), ('Góc K20 – Nước Mặn 2 · 241 m²', 114, 'goc'), ('Góc Đoàn Khuê – Phạm Tuấn Tài · 177 m²', 141, 'goc'),
]
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(20, 38, 56))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(20, 38, 56))
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((40, 28), 'GIÁ CHÀO BÁN THAM KHẢO · 10/2026', font=f(20, True), fill=GOLD)
d.text((40, 58), 'Đất Nam Việt Á: giá mỗi m² theo lô', font=f(36, True), fill='white')
for i, (k, t) in enumerate([('ong', 'Lô ống'), ('bt', 'Đất biệt thự'), ('goc', 'Lô góc')]):
    x = 40 + i * 190; d.rectangle([x, 114, x + 22, 132], fill=C[k]); d.text((x + 30, 112), t, font=f(18), fill='white')
x0, x1, y0, bh = 470, 1110, 158, 30
mx = 200
for v in (50, 100, 150, 200):
    xx = x0 + (x1 - x0) * v / mx; d.line([xx, y0 - 6, xx, y0 + len(rows) * (bh + 7)], fill=(45, 70, 95)); d.text((xx - 14, y0 + len(rows) * (bh + 7) + 4), str(v), font=f(15), fill=(150, 170, 190))
for i, (lab, v, k) in enumerate(rows):
    y = y0 + i * (bh + 7)
    tw = d.textlength(lab, font=f(17)); d.text((x0 - 14 - tw, y + 5), lab, font=f(17), fill=(215, 225, 235))
    xe = x0 + (x1 - x0) * v / mx; d.rectangle([x0, y, xe, y + bh], fill=C[k])
    d.text((xe + 8, y + 5), f'{v} tr', font=f(17, True), fill='white')
d.text((40, 752), 'Triệu đồng/m², tính từ giá chào bán ÷ diện tích; chưa phải giá giao dịch. Sơ đồ tự vẽ.', font=f(15), fill=(150, 170, 190))
p = f'{O}/nam-viet-a-gia-dat-theo-lo-10-2026.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
