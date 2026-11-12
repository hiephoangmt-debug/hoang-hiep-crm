"""Sơ đồ phân bổ chức năng tầng Nobu Residences Đà Nẵng – đồ hoạ tự vẽ (không dùng ảnh của đơn vị phân phối), nhãn liên hệ qua scripts/dong-dau-anh.py."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); ORANGE = (242, 85, 29); W, H = 1600, 1000
# (tầng thấp, tầng cao, nhãn, nhóm màu)
G = [
    (43, 43, 'Nhà hàng – bar trên không Tsukimidai', 'svc'),
    (42, 42, 'Nhà hàng Nobu', 'svc'),
    (41, 41, 'Penthouse', 'res'),
    (38, 40, 'Biệt thự trên không (Sky Villa)', 'res'),
    (37, 37, 'Tầng lánh nạn', 'tech'),
    (19, 36, 'Căn hộ thương hiệu Nobu', 'res'),
    (18, 18, 'Tầng tiện ích (hồ bơi nước ấm)', 'svc'),
    (17, 17, 'Tầng lánh nạn', 'tech'),
    (7, 16, 'Khách sạn Nobu', 'hotel'),
    (6, 6, 'Nhà hàng Taste of Asia', 'svc'),
    (5, 5, 'Sảnh hội nghị', 'svc'),
    (3, 4, 'Trung tâm spa & chăm sóc sức khỏe', 'svc'),
    (2, 2, 'Văn phòng', 'tech'),
    (1, 1, 'Sảnh đón', 'svc'),
]
COL = {'res': ORANGE, 'hotel': (64, 140, 200), 'svc': (232, 176, 74), 'tech': (110, 125, 145)}
im = Image.new('RGB', (W, H), NAVY); d = ImageDraw.Draw(im)
for x in range(0, W, 32): d.line([x, 0, x, H], fill=(20, 38, 58))
for y in range(0, H, 32): d.line([0, y, W, y], fill=(20, 38, 58))
d.rectangle([0, 0, W, 8], fill=ORANGE)
d.text((56, 36), 'NOBU RESIDENCES ĐÀ NẴNG', font=f(24, True), fill=ORANGE)
d.text((56, 72), 'Phân bổ chức năng 43 tầng', font=f(46, True), fill='white')
d.text((56, 128), 'Tháp cao khoảng 186 m · 01 Võ Văn Kiệt, phường An Hải · sơ đồ minh hoạ, không theo tỷ lệ', font=f(21), fill=(180, 200, 220))
# tháp
TX0, TX1, TOP, BOT = 150, 420, 214, 940
fh = (BOT - TOP) / 43
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
    t = f'{lo:02d}' if lo == hi else f'{lo:02d}–{hi:02d}'
    yc = (yof(hi) + yof(lo - 1)) / 2
    if hi - lo >= 1 or lo in (43, 37, 18, 17, 6, 1):
        d.text((TX0 - 14, yc), t, font=f(15, True), fill=(200, 215, 230), anchor='rm')
# danh sách bên phải
LX, RY0, RH = 560, 214, 46
for i, (lo, hi, lab, k) in enumerate(G):
    ry = RY0 + i * RH; yc_t = (yof(hi) + yof(lo - 1)) / 2; yc_r = ry + RH / 2 - 1
    d.line([TX1 + 4, yc_t, TX1 + 60, yc_t, LX - 24, yc_r, LX - 6, yc_r], fill=(120, 140, 165), width=1)
    d.rounded_rectangle([LX, ry + 3, LX + 960, ry + RH - 5], 8, fill=(16, 40, 64), outline=COL[k], width=2)
    t = f'TẦNG {lo:02d}' if lo == hi else f'TẦNG {lo:02d} – {hi:02d}'
    d.text((LX + 18, yc_r), t, font=f(20, True), fill=COL[k], anchor='lm')
    d.text((LX + 230, yc_r), lab, font=f(22), fill='white', anchor='lm')
# chú giải
lx = 56
for k, name in (('res', 'Căn hộ'), ('hotel', 'Khách sạn'), ('svc', 'Dịch vụ, tiện ích'), ('tech', 'Kỹ thuật, văn phòng')):
    d.rectangle([lx, 168, lx + 20, 188], fill=COL[k]); d.text((lx + 30, 178), name, font=f(18), fill=(200, 215, 230), anchor='lm')
    lx += 30 + d.textlength(name, font=f(18)) + 34
p = f'{O}/nobu-da-nang-phan-bo-chuc-nang-tang.jpg'; im.save(p, quality=92)
print(p, dd.stamp(p, tile=False))
