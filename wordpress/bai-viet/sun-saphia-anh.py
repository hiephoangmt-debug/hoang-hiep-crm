"""Ảnh trang Sun Saphia Residence: cắt từ ảnh anh Hiệp gửi + sơ đồ vị trí tự vẽ, rồi đóng dấu (scripts/dong-dau-anh.py).
Dùng: python3 -I sun-saphia-anh.py <thư mục ảnh gốc> <thư mục img/sun-saphia>"""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
I, O = sys.argv[1], sys.argv[2]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
out = []
def save(im, name, w):
    im = im.convert('RGB')
    if im.width > w: im = im.resize((w, round(im.height * w / im.width)), Image.LANCZOS)
    p = f'{O}/sun-saphia-{name}.jpg'; im.save(p, quality=92); out.append(p)
save(Image.open(f'{I}/158.jpg'), 'phoi-canh-ven-bien-son-thuy', 1280)
save(Image.open(f'{I}/159.jpg'), 'poster-can-ho-mat-bien', 900)
save(Image.open(f'{I}/160.jpg').crop((40, 20, 560, 1150)), 'phoi-canh-toa-thap-30-tang', 700)
save(Image.open(f'{I}/157.jpg'), 'ban-do-ket-noi', 1600)
W, H = 1280, 760; NAVY = (11, 26, 42); GOLD = '#e8b04a'
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((48, 34), 'VỊ TRÍ SUN SAPHIA RESIDENCE · SƠN THỦY – NGŨ HÀNH SƠN', font=f(24, True), fill=GOLD)
d.text((48, 72), 'Sơ đồ minh hoạ, không theo tỷ lệ – tổng hợp từ tài liệu chủ đầu tư và báo chí', font=f(18), fill=(170, 190, 210))
d.rectangle([1040, 120, 1280, 700], fill=(36, 100, 150))
for k in range(5):
    d.line([(1040 + 30 * k + 10 * math.sin(y / 30), y) for y in range(120, 700, 6)], fill=(120, 190, 235), width=2)
d.text((1160, 410), 'BIỂN', font=f(22, True), fill='white', anchor='mm'); d.text((1160, 440), 'SƠN THỦY', font=f(18, True), fill='white', anchor='mm')
d.rectangle([990, 120, 1040, 700], fill=(214, 190, 140))
d.rectangle([560, 120, 600, 700], fill=(120, 130, 140))
d.text((580, 722), 'Đường Trường Sa (dự kiến mở rộng)', font=f(17, True), fill='white', anchor='mm')
d.rectangle([600, 130, 990, 470], outline=(110, 160, 110), width=2)
d.text((795, 300), 'Khu du lịch ven biển', font=f(17), fill=(170, 200, 170), anchor='mm'); d.text((795, 325), 'Hòn Ngọc Á Châu', font=f(17), fill=(170, 200, 170), anchor='mm')
d.rounded_rectangle([600, 480, 990, 590], 6, fill=(70, 140, 80))
d.text((795, 520), 'Công viên bãi tắm Sơn Thủy', font=f(19, True), fill='white', anchor='mm'); d.text((795, 552), '~2,45 ha (đất thu hồi)', font=f(16), fill='white', anchor='mm')
d.rectangle([600, 600, 990, 690], outline=(160, 120, 100), width=2); d.text((795, 645), 'Khu nghỉ dưỡng ven biển', font=f(16), fill=(200, 170, 150), anchor='mm')
d.rounded_rectangle([380, 430, 555, 620], 10, fill=(232, 176, 74))
d.text((467, 495), 'SUN', font=f(22, True), fill=NAVY, anchor='mm'); d.text((467, 525), 'SAPHIA', font=f(22, True), fill=NAVY, anchor='mm'); d.text((467, 565), '30 tầng', font=f(17), fill=NAVY, anchor='mm')
d.line([(555, 525), (600, 525)], fill=GOLD, width=4)
d.rectangle([60, 130, 360, 690], outline=(90, 110, 140), width=2)
for y in range(150, 680, 40): d.line([(80, y), (340, y)], fill=(60, 80, 105), width=8)
d.rounded_rectangle([90, 145, 330, 200], 6, fill=NAVY)
d.text((210, 160), 'Khu dân cư Hòa Hải', font=f(17, True), fill='white', anchor='mm')
d.text((210, 186), '(Nam Bắc Mỹ An)', font=f(15), fill=(170, 190, 210), anchor='mm')
p = f'{O}/sun-saphia-so-do-vi-tri.jpg'; im.save(p, quality=92); out.append(p)
for p in out: print(p.rsplit('/', 1)[1], dd.stamp(p))
