"""Ảnh FB dọc 1080×1350 – phân tích Sun Saphia Residence: điểm mạnh, điểm cần cân nhắc (số liệu bài web, 06/11/2026).
Nửa trên: phối cảnh CĐT img/sun-saphia/sun-saphia-cdt-hoang-hon-bien-tren-cao.jpg.
Chạy: python3 fb-sun-saphia-phan-tich-11-2026.py <anh-dai-dien.jpg> <phoi-canh.jpg> <out.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, BG, OUT = sys.argv[1:4]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
TEAL, CORAL = (94, 196, 178), (240, 150, 120)
W, H, S = 1080, 1350, 2
F = lambda n, s: ImageFont.truetype(I + n, s * S)
P = lambda *v: tuple(int(x * S) for x in v)
STATS = [('782', 'căn hộ'), ('30', 'tầng'), ('2,13 tỷ', 'studio từ*'), ('11/2028', 'bàn giao')]
PLUS = ['Cách bãi tắm Sơn Thủy ~400 m, công viên biển 2,45 ha phía trước',
        'Studio có bếp, tổng tiền vừa, hợp cho thuê khách du lịch',
        'Hỗ trợ lãi suất tới 24 tháng, gần trùng thời gian xây']
MINUS = ['Thời hạn 50 năm, hợp đầu tư, nghỉ dưỡng hơn để lại lâu dài',
         '513 studio trong một tòa, cạnh tranh khi cho thuê, bán lại',
         'Chưa có bảng giá chính thức, cần so giá/m² khi công bố']

PH = 560
im = Image.new('RGB', (W * S, H * S), NAVY)
src = Image.open(BG).convert('RGB')
sc = max(W * S / src.width, PH * S / src.height)
src = src.resize((int(src.width * sc) + 1, int(src.height * sc) + 1), Image.LANCZOS)
x0 = min(max(0, int(src.width * 0.5) - W * S // 2), src.width - W * S)
im.paste(src.crop((x0, 0, x0 + W * S, PH * S)), (0, 0))
ov = Image.new('RGBA', (W * S, PH * S))
od = ImageDraw.Draw(ov)
for y in range(PH * S):
    t = y / (PH * S)
    a = 110 * (1 - t / 0.3) if t < 0.3 else (245 * ((t - 0.42) / 0.58) ** 0.8 if t > 0.42 else 0)
    od.line([(0, y), (W * S, y)], fill=NAVY + (int(a),))
im.paste(ov, (0, 0), ov)
d = ImageDraw.Draw(im, 'RGBA')

tag = 'GÓC NHÌN PHÂN TÍCH · 11/2026'
ft = F('Inter-Bold.otf', 21)
tw = d.textlength(tag, font=ft) / S
d.rounded_rectangle(P(60, 52, 60 + tw + 40, 92), radius=20 * S, fill=GOLD)
d.text(P(80, 60), tag, font=ft, fill=NAVY)
d.text(P(58, 388), 'Sun Saphia Residence', font=F('InterDisplay-ExtraBold.otf', 62), fill=CREAM)
d.text(P(60, 464), 'Mạnh ở đâu, cần cân nhắc gì?', font=F('InterDisplay-Bold.otf', 38), fill=(255, 200, 140))

# Hàng số liệu
y = PH
d.rectangle(P(0, y, W, y + 108), fill=NAVY2)
d.line(P(0, y, W, y), fill=GOLD, width=3 * S)
cw = (W - 120) / 4
for i, (big, lab) in enumerate(STATS):
    cx = 60 + cw * i + cw / 2
    d.text(P(cx, y + 20), big, font=F('InterDisplay-ExtraBold.otf', 36), fill=GOLD, anchor='ma')
    d.text(P(cx, y + 66), lab, font=F('Inter-Medium.otf', 21), fill=MUTED, anchor='ma')
    if i:
        d.line(P(60 + cw * i, y + 24, 60 + cw * i, y + 86), fill=(255, 255, 255, 40), width=S)


def block(y, title, col, sign, items):
    d.text(P(60, y), title, font=F('Inter-Bold.otf', 28), fill=col)
    y += 46
    for it in items:
        d.ellipse(P(62, y + 4, 92, y + 34), fill=col)
        d.text(P(77, y + 19), sign, font=F('Inter-Bold.otf', 24), fill=NAVY, anchor='mm')
        d.text(P(110, y + 4), it, font=F('Inter-Medium.otf', 24), fill=CREAM)
        y += 46
    return y


y = block(y + 136, 'Điểm mạnh', TEAL, '+', PLUS)
y = block(y + 18, 'Cần cân nhắc', CORAL, '!', MINUS)
d.rounded_rectangle(P(60, y + 16, W - 60, y + 70), radius=14 * S, outline=GOLD, width=2 * S)
d.text(P(W / 2, y + 43), 'Hợp nhất: đầu tư cho thuê · căn nghỉ dưỡng gia đình', font=F('Inter-SemiBold.otf', 24), fill=GOLD, anchor='mm')

ay = 1196
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1326), '*Giá dự kiến studio tầng 15, có vay, chưa VAT · Phối cảnh CĐT', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
