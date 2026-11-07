"""Ảnh FB dọc 1080×1350 – 4 điều cần biết khi cho thuê căn hộ ngắn ngày (theo bài web 04/11/2026).
Cảnh minh hoạ tự vẽ: vali, chìa khoá, toà căn hộ. Chạy: python3 fb-cho-thue-can-ho-ngan-ngay-4-dieu.py <anh-dai-dien.jpg> <out.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, OUT = sys.argv[1:3]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
TEAL, CORAL = (94, 196, 178), (240, 140, 110)
ITEMS = [
    ('Đúng công năng căn hộ', 'Xem hợp đồng: căn hộ để ở hay căn hộ dịch vụ, lưu trú; quy chế toà nhà có cho thuê theo ngày'),
    ('Đăng ký cơ sở lưu trú', 'Cho khách du lịch thuê theo đêm là kinh doanh lưu trú; hỏi phường và cơ quan du lịch'),
    ('Khai báo lưu trú mọi khách', 'Theo Luật Cư trú, kể cả căn tự nhận phòng bằng mật khẩu'),
    ('Kê khai thuế', 'Doanh thu cho thuê trên 100 triệu đồng/năm kê khai thuế GTGT và TNCN'),
]
W, H, S = 1080, 1350, 2
F = lambda n, s: ImageFont.truetype(I + n, s * S)
P = lambda *v: tuple(int(x * S) for x in v)
lerp = lambda a, b, t: tuple(int(x + (y - x) * t) for x, y in zip(a, b))


def wrap(d, text, font, maxw):
    words, lines, cur = text.split(), [], ''
    for w in words:
        t = (cur + ' ' + w).strip()
        if d.textlength(t, font=font) / S <= maxw:
            cur = t
        else:
            lines.append(cur)
            cur = w
    lines.append(cur)
    return lines


im = Image.new('RGB', (W * S, H * S), NAVY)
d = ImageDraw.Draw(im, 'RGBA')
for y in range(420 * S):
    d.line([(0, y), (W * S, y)], fill=lerp((14, 30, 60), (36, 66, 110), y / (420 * S)))
# Toà căn hộ bên phải, cửa sổ sáng
bx = 700
d.rectangle(P(bx, 120, bx + 260, 420), fill=(28, 46, 80))
for r in range(9):
    for c in range(5):
        on = (r * 5 + c) % 3 != 0
        d.rectangle(P(bx + 22 + c * 46, 140 + r * 30, bx + 50 + c * 46, 158 + r * 30),
                    fill=(255, 214, 150, 230) if on else (60, 80, 120))
# Vali
vx, vy = 560, 300
d.rounded_rectangle(P(vx, vy, vx + 110, vy + 120), radius=16, fill=CORAL)
d.rounded_rectangle(P(vx + 30, vy - 26, vx + 80, vy + 4), radius=10, outline=CORAL, width=8)
d.line(P(vx + 36, vy + 10, vx + 36, vy + 110), fill=(200, 100, 80), width=6)
d.line(P(vx + 74, vy + 10, vx + 74, vy + 110), fill=(200, 100, 80), width=6)
# Chìa khoá
kx, ky = 520, 210
d.ellipse(P(kx, ky, kx + 54, ky + 54), outline=GOLD, width=10)
d.line(P(kx + 50, ky + 27, kx + 140, ky + 27), fill=GOLD, width=10)
d.line(P(kx + 112, ky + 27, kx + 112, ky + 50), fill=GOLD, width=10)
d.line(P(kx + 132, ky + 27, kx + 132, ky + 44), fill=GOLD, width=10)
d.line(P(0, 420, W, 420), fill=GOLD, width=3 * S)

tag = 'KINH NGHIỆM CHO THUÊ'
ft = F('Inter-Bold.otf', 21)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 56, 60 + tw + 40, 96), radius=20 * S, fill=GOLD)
d.text(P(80, 64), tag, font=ft, fill=NAVY)
d.text(P(58, 116), 'Cho thuê căn hộ', font=F('InterDisplay-ExtraBold.otf', 60), fill=CREAM)
d.text(P(58, 190), 'theo ngày:', font=F('InterDisplay-ExtraBold.otf', 60), fill=CREAM)
d.text(P(60, 270), '4 điều nên biết', font=F('InterDisplay-Bold.otf', 46), fill=(255, 200, 140))
d.text(P(60, 334), 'trước khi tính dòng tiền', font=F('Inter-Medium.otf', 28), fill=MUTED)

y = 452
for i, (t, sub) in enumerate(ITEMS):
    d.ellipse(P(60, y + 2, 112, y + 54), fill=TEAL)
    f = F('Inter-Bold.otf', 28)
    tw = d.textlength(str(i + 1), font=f)
    d.text((86 * S - tw / 2, (y + 10) * S), str(i + 1), font=f, fill=NAVY)
    d.text(P(136, y), t, font=F('Inter-Bold.otf', 30), fill=CREAM)
    fs = F('Inter-Regular.otf', 23)
    yy = y + 42
    for line in wrap(d, sub, fs, W - 136 - 60):
        d.text(P(136, yy), line, font=fs, fill=MUTED)
        yy += 32
    y = yy + 22

ay = 1200
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1322), 'Tham khảo, không thay tư vấn pháp lý, thuế', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
