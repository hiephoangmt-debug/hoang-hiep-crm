"""Ảnh đại diện bài đánh giá Sun Saphia Residence (11/2026): sơ đồ tầm nhìn 4 hướng tự vẽ + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(22, 38, 56))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(22, 38, 56))
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((56, 40), 'ĐÁNH GIÁ DỰ ÁN · CẬP NHẬT 11/2026', font=f(22, True), fill=GOLD)
d.text((56, 78), 'Review Sun Saphia Residence', font=f(50, True), fill='white')
d.text((56, 148), 'Vị trí · view 4 hướng · giá dự kiến · dòng tiền', font=f(26), fill=(190, 210, 230))
# Sơ đồ la bàn tầm nhìn
cx, cy, r = 860, 372, 112
d.ellipse([cx - r - 40, cy - r - 40, cx + r + 40, cy + r + 40], outline=(60, 90, 120), width=2)
d.pieslice([cx - r, cy - r, cx + r, cy + r], -45, 45, fill=(40, 110, 160))      # Đông
d.pieslice([cx - r, cy - r, cx + r, cy + r], 45, 135, fill=(60, 120, 90))       # Nam
d.pieslice([cx - r, cy - r, cx + r, cy + r], 135, 225, fill=(120, 100, 60))     # Tây
d.pieslice([cx - r, cy - r, cx + r, cy + r], 225, 315, fill=(70, 80, 130))      # Bắc
d.rounded_rectangle([cx - 34, cy - 60, cx + 34, cy + 60], 8, fill=GOLD)
d.text((cx, cy), 'SAPHIA', font=f(13, True), fill=NAVY, anchor='mm')
for txt, sub, x, y in [('ĐÔNG', 'Biển Mỹ Khê', cx + r + 18, cy), ('NAM', 'Ngũ Hành Sơn · Hội An', cx, cy + r + 34),
                       ('TÂY', 'Trung tâm, sông Hàn', cx - r - 18, cy), ('BẮC', 'Sơn Trà · cầu sông Hàn', cx, cy - r - 34)]:
    anchor = 'lm' if x > cx else ('rm' if x < cx else 'mm')
    d.text((x, y - 12), txt, font=f(22, True), fill=GOLD, anchor=anchor)
    d.text((x, y + 14), sub, font=f(16), fill=(200, 215, 230), anchor=anchor)
for i, (big, small) in enumerate([('400 m', 'ra bãi tắm Sơn Thủy'), ('782 căn', '30 tầng · 114 m'), ('2,13 – 2,85 tỷ', 'studio tầng 15 (giá dự kiến)'), ('28/11/2026', 'sự kiện bán hàng (dự kiến)')]):
    y = 220 + i * 92
    d.rounded_rectangle([56, y, 520, y + 78], 12, fill=(16, 40, 64), outline=GOLD, width=2)
    d.text((76, y + 12), big, font=f(28, True), fill=GOLD)
    d.text((76, y + 48), small, font=f(18), fill=(200, 215, 230))
d.text((56, 600), 'Sơ đồ minh hoạ, không theo tỷ lệ', font=f(16), fill=(150, 170, 190))
p = f'{O}/review-sun-saphia-residence.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
