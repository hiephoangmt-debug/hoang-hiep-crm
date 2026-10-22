"""Ảnh tự vẽ: 2 mặt cắt điển hình cao tốc nội thị Đà Nẵng – Chu Lai (minh hoạ, không theo tỉ lệ chính xác)."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(20, 38, 56))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(20, 38, 56))
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((48, 32), 'HẠ TẦNG · MẶT CẮT ĐIỂN HÌNH', font=f(22, True), fill=GOLD)
d.text((48, 66), 'Cao tốc nội thị Đà Nẵng – Chu Lai', font=f(44, True), fill='white')
d.text((48, 124), 'Hai dạng mặt cắt và quỹ đất hai bên tuyến', font=f(26), fill=(190, 210, 230))

def section(y, title, sub, total_label, parts):
    d.text((48, y), title, font=f(24, True), fill='white')
    d.text((48, y + 32), sub, font=f(18), fill=(185, 205, 225))
    x0, x1, yb = 60, 1140, y + 78
    tot = sum(w for w, _, _ in parts); x = x0
    for w, col, lab in parts:
        xe = x + (x1 - x0) * w / tot
        d.rectangle([x, yb, xe, yb + 46], fill=col, outline=NAVY, width=2)
        tw = d.textlength(lab, font=f(15, True))
        if tw < xe - x - 6:
            d.text(((x + xe - tw) / 2, yb + 14), lab, font=f(15, True), fill=NAVY)
        x = xe
    d.line([x0, yb + 62, x1, yb + 62], fill=GOLD, width=2)
    for xx in (x0, x1): d.line([xx, yb + 54, xx, yb + 70], fill=GOLD, width=2)
    tw = d.textlength(total_label, font=f(20, True))
    d.rectangle([(x0 + x1 - tw) / 2 - 10, yb + 50, (x0 + x1 + tw) / 2 + 10, yb + 76], fill=NAVY)
    d.text(((x0 + x1 - tw) / 2, yb + 52), total_label, font=f(20, True), fill=GOLD)

G = (110, 190, 120); R = (200, 200, 210); M = (230, 176, 74); Q = (90, 140, 190)
section(180, 'Mặt cắt 1 – tuyến mở mới phía Tây sông Trường Giang', 'Giải tỏa đủ 138 m, giai đoạn đầu mỗi bên 3 làn (Sở Xây dựng Đà Nẵng)',
        'Khoảng 138 m', [(8, G, 'cây xanh'), (14, R, 'đường gom'), (30, R, 'cao tốc đô thị'), (10, M, 'dải giữa'), (30, R, 'cao tốc đô thị'), (14, R, 'đường gom'), (8, G, 'cây xanh')])
section(380, 'Mặt cắt 2 – bám ĐT 619 (đường ven biển 129) hiện trạng', 'Mở rộng nền đường hai bên để dự trữ đất, đường gom, dải cây xanh cách ly',
        'Khoảng 170 m (đo trên bản đồ mô phỏng)', [(16, G, 'cây xanh cách ly'), (14, R, 'đường gom'), (16, Q, 'dự trữ'), (24, R, 'ĐT 619 nâng cấp'), (16, Q, 'dự trữ'), (14, R, 'đường gom'), (16, G, 'cây xanh cách ly')])
d.text((48, 556), 'Phương án hoàn chỉnh: thu hồi thêm 100 m mỗi bên để khai thác quỹ đất – tổng mức hơn 30.800 tỷ đồng.', font=f(19), fill=(230, 220, 190))
d.text((48, 640), 'Sơ đồ tự vẽ minh hoạ, không theo tỉ lệ · Nguồn: báo chí 3 – 5/2026', font=f(16), fill=(150, 170, 190))
p = f'{O}/cao-toc-noi-thi-mat-cat-quy-dat.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
