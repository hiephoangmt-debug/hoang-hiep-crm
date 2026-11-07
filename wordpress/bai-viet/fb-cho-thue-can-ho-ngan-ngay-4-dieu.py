"""Ảnh FB dọc 1080×1350 – 4 điều cần biết khi cho thuê căn hộ ngắn ngày (theo bài web 04/11/2026).
Nửa trên: ảnh biển Mỹ Khê (marketing/anh-khu-vuc/bien-my-khe-tren-cao-nhin-ve-son-tra.jpg, XC 0.62).
Chạy: python3 fb-cho-thue-can-ho-ngan-ngay-4-dieu.py <anh-dai-dien.jpg> <anh-bien.jpg> <out.jpg> [tam-cat-ngang]"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, BIEN, OUT = sys.argv[1:4]
XC = float(sys.argv[4]) if len(sys.argv) > 4 else 0.60  # tâm cắt ngang của ảnh biển (0–1)
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


PH = 640
im = Image.new('RGB', (W * S, H * S), NAVY)
# Ảnh biển phủ kín bề ngang, lấy phần bãi cát + cây dừa; dải tối phía dưới để đọc chữ
src = Image.open(BIEN).convert('RGB')
sc = max(W * S / src.width, PH * S / src.height)
src = src.resize((int(src.width * sc) + 1, int(src.height * sc) + 1), Image.LANCZOS)
x0 = min(max(0, int(src.width * XC) - W * S // 2), src.width - W * S)
im.paste(src.crop((x0, 0, x0 + W * S, PH * S)), (0, 0))
ov = Image.new('RGBA', (W * S, PH * S))
od = ImageDraw.Draw(ov)
for y in range(PH * S):
    t = y / (PH * S)
    a = 90 * (1 - t / 0.2) if t < 0.2 else (240 * ((t - 0.34) / 0.66) ** 0.7 if t > 0.34 else 0)
    od.line([(0, y), (W * S, y)], fill=NAVY + (int(a),))
im.paste(ov, (0, 0), ov)
d = ImageDraw.Draw(im, 'RGBA')
d.line(P(0, PH, W, PH), fill=GOLD, width=3 * S)

tag = 'KINH NGHIỆM CHO THUÊ'
ft = F('Inter-Bold.otf', 21)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 52, 60 + tw + 40, 92), radius=20 * S, fill=GOLD)
d.text(P(80, 60), tag, font=ft, fill=NAVY)
d.text(P(58, 404), 'Cho thuê căn hộ theo ngày', font=F('InterDisplay-ExtraBold.otf', 58), fill=CREAM)
d.text(P(60, 478), '4 điều nên biết', font=F('InterDisplay-Bold.otf', 46), fill=(255, 200, 140))
d.text(P(60, 542), 'trước khi tính dòng tiền cho khách du lịch', font=F('Inter-Medium.otf', 27), fill=(225, 230, 240))

y = 676
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
        yy += 31
    y = yy + 18

ay = 1200
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1322), 'Ảnh: biển Mỹ Khê · Tham khảo, không thay tư vấn pháp lý, thuế', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
