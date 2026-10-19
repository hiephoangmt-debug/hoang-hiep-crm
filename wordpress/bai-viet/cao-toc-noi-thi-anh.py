"""Ảnh tự vẽ: sơ đồ hướng tuyến cao tốc nội thị Đà Nẵng – Chu Lai (minh hoạ, không theo tỉ lệ)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 12))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 12))
# biển phía Đông (bên phải sơ đồ)
coast = [(1010 + 40 * math.sin(y / 90), y) for y in range(0, H + 1, 5)]
g.polygon(coast + [(W, H), (W, 0)], fill=(30, 80, 120, 120))
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((48, 36), 'HẠ TẦNG · SƠ ĐỒ MINH HOẠ', font=f(22, True), fill=GOLD)
d.text((48, 72), 'Cao tốc nội thị Đà Nẵng – Chu Lai', font=f(46, True), fill='white')
d.text((48, 134), 'Gần 90 km · 80 km/h · giai đoạn đầu 4 – 6 làn', font=f(26), fill=(190, 210, 230))
d.text((1050, 300), 'BIỂN', font=f(22, True), fill=(160, 205, 235))
# tuyến: đi từ trên (Đà Nẵng) xuống dưới (Chu Lai), chéo sang phải
pts = [(560, 205), (630, 272), (700, 339), (770, 406), (840, 473), (900, 540)]
d.line(pts, fill=GOLD, width=10, joint='curve')
labels = [
    ('Nút Hồ Xuân Hương – cầu Tiên Sơn', 'điểm đầu, trung tâm Đà Nẵng'),
    ('Lê Văn Hiến hiện trạng', 'khoảng 9,5 km nâng cấp'),
    ('Nút Phạm Như Xương', 'mở tuyến mới phía Tây sông Trường Giang'),
    ('Nút Bình Sa – ĐT 619', 'đoạn 1 khoảng 46,9 km'),
    ('Bám ĐT 619 (ven biển 129)', 'đoạn 2 khoảng 41,8 km'),
    ('Sân bay Chu Lai', 'điểm cuối'),
]
for (x, y), (a, b) in zip(pts, labels):
    d.ellipse([x - 13, y - 13, x + 13, y + 13], fill=NAVY, outline=GOLD, width=5)
    tw = max(d.textlength(a, font=f(21, True)), d.textlength(b, font=f(17)))
    tx = x - 30 - tw
    d.text((tx, y - 24), a, font=f(21, True), fill='white')
    d.text((tx, y + 2), b, font=f(17), fill=(185, 205, 225))
# Sun Saphia gần đầu tuyến, phía biển
sx, sy = 720, 225
d.rounded_rectangle([sx, sy - 22, sx + 230, sy + 22], 10, fill=(16, 40, 64), outline=(120, 190, 235), width=2)
d.text((sx + 14, sy - 12), 'Sun Saphia · Sơn Thủy', font=f(19, True), fill=(160, 215, 245))
d.line([(sx, sy), (600, 222)], fill=(120, 190, 235), width=3)
d.text((48, 640), 'Sơ đồ tự vẽ, không theo tỉ lệ · Nguồn: báo chí 3 – 5/2026', font=f(17), fill=(150, 170, 190))
p = f'{O}/cao-toc-noi-thi-da-nang-chu-lai.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
