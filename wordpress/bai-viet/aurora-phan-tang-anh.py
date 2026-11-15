"""Sơ đồ phân tầng tháp Aurora (tháp biểu tượng Đà Nẵng Downtown, Sun Group) – đồ hoạ tự vẽ (không dùng ảnh của đơn vị phân phối), nhãn liên hệ qua scripts/dong-dau-anh.py."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); ORANGE = (242, 85, 29); W, H = 1600, 1100
# (tầng thấp, tầng cao, nhãn, nhóm màu)
G = [
    (70, 70, 'Tầng mái: bể nước, phòng kỹ thuật', 'tech'),
    (68, 69, 'Penthouse siêu sang – 2 căn (1 căn/tầng)', 'res'),
    (67, 67, 'Phòng lưu trú du lịch + Sky Bar – 14 phòng', 'hotel'),
    (44, 66, 'Phòng lưu trú du lịch – 368 phòng (16 phòng/tầng)', 'hotel'),
    (43, 43, 'Phòng lưu trú du lịch + Sky Bar – 14 phòng', 'hotel'),
    (28, 42, 'Căn hộ cao cấp – 240 căn (16 căn/tầng)', 'res'),
    (24, 27, 'Trung tâm mua sắm cao cấp', 'svc'),
    (23, 23, 'Nhà hàng ẩm thực', 'svc'),
    (11, 22, 'Căn hộ cao cấp – 264 căn (22 căn/tầng)', 'res'),
    (6, 10, 'Nhà hàng ẩm thực cao cấp, phòng yoga', 'svc'),
    (5, 5, 'Không gian hội nghị, rạp chiếu phim', 'svc'),
    (4, 4, 'Trưng bày, phòng hội nghị, gym, spa, mua sắm', 'svc'),
    (1, 3, 'Trung tâm thương mại dịch vụ khối đế', 'svc'),
]
COL = {'res': ORANGE, 'hotel': (64, 140, 200), 'svc': (232, 176, 74), 'tech': (110, 125, 145)}
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(20, 38, 58))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(20, 38, 58))
d.rectangle([0, 0, W, 8], fill=ORANGE)
d.text((56, 36), 'THÁP AURORA · ĐÀ NẴNG DOWNTOWN', font=f(24, True), fill=ORANGE)
d.text((56, 72), 'Sơ đồ phân tầng tiện ích', font=f(46, True), fill='white')
d.text((56, 128), 'Cao 408 m · 504 căn hộ, 396 phòng lưu trú, 2 penthouse · theo tài liệu giới thiệu, sơ đồ minh hoạ', font=f(21), fill=(180, 200, 220))
# tháp
TX0, TX1, TOP, BOT = 190, 400, 214, 920
fh = (BOT - TOP) / 70
yof = lambda fl: BOT - fl * fh  # mép trên của tầng fl
for lo, hi, lab, k in G:
    y0, y1 = yof(hi), yof(lo - 1)
    d.rectangle([TX0, y0 + 1, TX1, y1 - 1], fill=COL[k])
    for fl in range(lo, hi):
        yy = yof(fl); d.line([TX0 + 6, yy, TX1 - 6, yy], fill=tuple(max(0, c - 40) for c in COL[k]), width=1)
d.rectangle([TX0, TOP, TX1, BOT], outline='white', width=2)
d.line([TX0 - 40, BOT, TX1 + 40, BOT], fill='white', width=3)
# nhãn tầng bên trái tháp
for lo, hi, lab, k in G:
    t = 'Mái' if lo == 70 else (f'{lo:02d}' if lo == hi else f'{lo:02d}–{hi:02d}')
    yc = (yof(hi) + yof(lo - 1)) / 2
    if hi - lo >= 1 or lo in (70, 67, 43, 23, 5):
        d.text((TX0 - 14, yc), t, font=f(15, True), fill=(200, 215, 230), anchor='rm')
# danh sách bên phải
LX, RY0, RH = 560, 214, 54
for i, (lo, hi, lab, k) in enumerate(G):
    ry = RY0 + i * RH; yc_t = (yof(hi) + yof(lo - 1)) / 2; yc_r = ry + RH / 2 - 1
    d.line([TX1 + 4, yc_t, TX1 + 60, yc_t, LX - 24, yc_r, LX - 6, yc_r], fill=(120, 140, 165), width=1)
    d.rounded_rectangle([LX, ry + 3, LX + 960, ry + RH - 5], 8, fill=(16, 40, 64), outline=COL[k], width=2)
    t = 'TẦNG MÁI' if lo == 70 else (f'TẦNG {lo:02d}' if lo == hi else f'TẦNG {lo:02d} – {hi:02d}')
    d.text((LX + 18, yc_r), t, font=f(20, True), fill=COL[k], anchor='lm')
    d.text((LX + 230, yc_r), lab, font=f(22), fill='white', anchor='lm')
# chú giải
lx = 56
for k, name in (('res', 'Căn hộ'), ('hotel', 'Phòng lưu trú'), ('svc', 'Dịch vụ, tiện ích'), ('tech', 'Kỹ thuật')):
    d.rectangle([lx, 168, lx + 20, 188], fill=COL[k]); d.text((lx + 30, 178), name, font=f(18), fill=(200, 215, 230), anchor='lm')
    lx += 30 + d.textlength(name, font=f(18)) + 34
p = f'{O}/da-nang-downtown-thap-aurora-phan-tang.jpg'; im.save(p, quality=92)
print(p, dd.stamp(p, tile=False))
