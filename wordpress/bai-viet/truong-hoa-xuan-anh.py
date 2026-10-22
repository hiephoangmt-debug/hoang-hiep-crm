"""Ảnh tự vẽ: sơ đồ mặt bằng chức năng Trường Tiểu học Hòa Xuân (minh hoạ theo bản vẽ quy hoạch, không theo tỉ lệ)."""
import sys, math, importlib.util
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
d.text((40, 30), 'GIÁO DỤC · KĐT SINH THÁI HÒA XUÂN', font=f(21, True), fill=GOLD)
d.text((40, 62), 'Trường Tiểu học Hòa Xuân', font=f(40, True), fill='white')
d.text((40, 114), 'Khu đất 13.655 m² · 3 mặt tiền', font=f(24), fill=(190, 210, 230))
legend = [((240, 200, 120), 'Khối lớp học 4 tầng, mái pin mặt trời'), ((235, 150, 140), 'Khối phục vụ học tập'), ((225, 120, 110), 'Khối hành chính quản trị'),
          ((120, 160, 220), 'Bể bơi, nhà thi đấu mái vòm'), ((150, 210, 140), 'Sân chào cờ, sân khấu, vườn dạo'), ((110, 180, 110), 'Vườn thực nghiệm'), ((200, 200, 210), 'Cổng vào/ra, vịnh đón trả học sinh')]
for i, (c, t) in enumerate(legend):
    y = 168 + i * 36
    d.rectangle([40, y + 4, 66, y + 22], fill=c); d.text((78, y + 2), t, font=f(18), fill='white')
d.text((40, 440), 'Cổng chính và chỗ dừng đón trả học sinh', font=f(17), fill=(230, 220, 190))
d.text((40, 464), 'phía đường Lê Sỹ; lối xe kỹ thuật riêng.', font=f(17), fill=(230, 220, 190))
# khu đất: hình thoi xoay 45° như bản vẽ
cx, cy, r = 860, 340, 230
P = lambda dx, dy: (cx + (dx - dy) * r / math.sqrt(2) / 1.0 * 0.72, cy + (dx + dy) * r / math.sqrt(2) * 0.72)
def poly(pts, **k): d.polygon([P(*p) for p in pts], **k)
poly([(-1, -1), (1, -1), (1, 1), (-1, 1)], fill=(24, 52, 40), outline=GOLD, width=3)
poly([(-0.85, -0.85), (-0.1, -0.85), (-0.1, -0.55), (-0.85, -0.55)], fill=(240, 200, 120))      # lớp học 1
poly([(-0.85, -0.45), (-0.05, -0.45), (-0.05, -0.15), (-0.85, -0.15)], fill=(240, 200, 120))    # lớp học 2
poly([(-0.75, 0.05), (-0.15, 0.05), (-0.15, 0.55), (-0.75, 0.55)], fill=(235, 150, 140))      # phục vụ
poly([(0.35, -0.2), (0.85, -0.2), (0.85, 0.2), (0.35, 0.2)], fill=(225, 120, 110))            # hành chính
poly([(0.05, 0.4), (0.6, 0.4), (0.6, 0.85), (0.05, 0.85)], fill=(120, 160, 220))              # bể bơi
poly([(0.05, -0.55), (0.3, -0.55), (0.3, 0.3), (0.05, 0.3)], fill=(150, 210, 140))            # sân
poly([(-0.85, 0.65), (-0.45, 0.65), (-0.45, 0.9), (-0.85, 0.9)], fill=(110, 180, 110))        # vườn
poly([(0.55, -0.95), (0.95, -0.95), (0.95, -0.7), (0.55, -0.7)], fill=(200, 200, 210))        # cổng
def side(a, b, txt):
    (x1, y1), (x2, y2) = P(*a), P(*b); mx, my = (x1 + x2) / 2, (y1 + y2) / 2
    tw = d.textlength(txt, font=f(18, True)); d.text((mx - tw / 2, my - 11), txt, font=f(18, True), fill=GOLD)
side((-1.5, -1.5), (1.6, -1.6), 'Đường Lê Sỹ')
side((-1.6, -1.6), (-1.5, 1.5), 'Đường Đỗ Quỳ')
side((1.45, -1.45), (1.45, 1.45), 'Đường Cồn Dầu 18')
side((-1.4, 1.45), (1.4, 1.45), 'Đất trống')
d.text((40, 640), 'Sơ đồ tự vẽ minh hoạ theo bản vẽ quy hoạch đang được chia sẻ, không theo tỉ lệ', font=f(15), fill=(150, 170, 190))
p = f'{O}/truong-tieu-hoc-hoa-xuan.jpg'; im.save(p, quality=92)
print(dd.stamp(p, tile=False))
