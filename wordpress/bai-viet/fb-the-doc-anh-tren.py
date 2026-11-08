"""Mẫu ảnh FB dọc 1080×1350 dùng chung: nửa trên ảnh thật/phối cảnh + tiêu đề (từ khoá chính),
hàng số liệu, danh sách điểm chính, dòng chốt, chân ảnh đại diện Hoàng Hiệp.
Chạy: python3 fb-the-doc-anh-tren.py <cau-hinh.json> <anh-dai-dien.jpg> <anh-nen.jpg> <out.jpg>
cau-hinh.json: {"tag","title","title_size","sub","xc","stats":[[so,nhan]],"heading","items":[[tieu_de,chi_tiet]],"box","note"}"""
import json, sys
from PIL import Image, ImageDraw, ImageFont

CFG, AVA, BG, OUT = sys.argv[1:5]
c = json.load(open(CFG, encoding='utf-8'))
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED, TEAL = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206), (94, 196, 178)
W, H, S, PH = 1080, 1350, 2, 560
F = lambda n, s: ImageFont.truetype(I + n, int(s * S))
P = lambda *v: tuple(int(x * S) for x in v)

im = Image.new('RGB', (W * S, H * S), NAVY)
src = Image.open(BG).convert('RGB')
sc = max(W * S / src.width, PH * S / src.height)
src = src.resize((int(src.width * sc) + 1, int(src.height * sc) + 1), Image.LANCZOS)
x0 = min(max(0, int(src.width * c.get('xc', 0.5)) - W * S // 2), src.width - W * S)
y0 = min(max(0, int(src.height * c.get('yc', 0.5)) - PH * S // 2), src.height - PH * S)
im.paste(src.crop((x0, y0, x0 + W * S, y0 + PH * S)), (0, 0))
ov = Image.new('RGBA', (W * S, PH * S))
od = ImageDraw.Draw(ov)
for y in range(PH * S):
    t = y / (PH * S)
    a = 110 * (1 - t / 0.3) if t < 0.3 else (245 * ((t - 0.4) / 0.6) ** 0.8 if t > 0.4 else 0)
    od.line([(0, y), (W * S, y)], fill=NAVY + (int(a),))
im.paste(ov, (0, 0), ov)
d = ImageDraw.Draw(im, 'RGBA')

ft = F('Inter-Bold.otf', 21)
tw = d.textlength(c['tag'], font=ft) / S
d.rounded_rectangle(P(60, 52, 60 + tw + 40, 92), radius=20 * S, fill=GOLD)
d.text(P(80, 60), c['tag'], font=ft, fill=NAVY)
ts = c.get('title_size', 56)
while d.textlength(c['title'], font=F('InterDisplay-ExtraBold.otf', ts)) / S > W - 120:
    ts -= 2
d.text(P(58, 470 - ts * 1.25), c['title'], font=F('InterDisplay-ExtraBold.otf', ts), fill=CREAM)
d.text(P(60, 478), c['sub'], font=F('InterDisplay-Bold.otf', 32), fill=(255, 200, 140))

y = PH
d.rectangle(P(0, y, W, y + 108), fill=NAVY2)
d.line(P(0, y, W, y), fill=GOLD, width=3 * S)
n = len(c['stats'])
cw = (W - 120) / n
for i, (big, lab) in enumerate(c['stats']):
    cx = 60 + cw * i + cw / 2
    fs = 36
    while d.textlength(big, font=F('InterDisplay-ExtraBold.otf', fs)) / S > cw - 16:
        fs -= 2
    d.text(P(cx, y + 20), big, font=F('InterDisplay-ExtraBold.otf', fs), fill=GOLD, anchor='ma')
    d.text(P(cx, y + 66), lab, font=F('Inter-Medium.otf', 20), fill=MUTED, anchor='ma')
    if i:
        d.line(P(60 + cw * i, y + 24, 60 + cw * i, y + 86), fill=(255, 255, 255, 40), width=S)

y += 132
if c.get('heading'):
    d.text(P(60, y), c['heading'], font=F('Inter-Bold.otf', 28), fill=GOLD)
    y += 48
for k, (t, sub) in enumerate(c['items'], 1):
    d.ellipse(P(60, y + 2, 100, y + 42), fill=TEAL)
    d.text(P(80, y + 22), str(k), font=F('Inter-Bold.otf', 22), fill=NAVY, anchor='mm')
    d.text(P(118, y), t, font=F('Inter-Bold.otf', 26), fill=CREAM)
    d.text(P(118, y + 36), sub, font=F('Inter-Regular.otf', 22), fill=MUTED)
    y += 82
if c.get('box'):
    d.rounded_rectangle(P(60, y + 4, W - 60, y + 58), radius=14 * S, outline=GOLD, width=2 * S)
    d.text(P(W / 2, y + 31), c['box'], font=F('Inter-SemiBold.otf', 23), fill=GOLD, anchor='mm')

ay = 1196
a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
mk = Image.new('L', a.size, 0)
ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
im.paste(a, P(64, ay), mk)
d = ImageDraw.Draw(im, 'RGBA')
d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
d.text(P(W - 60, 1326), c.get('note', ''), font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
im.resize((W, H), Image.LANCZOS).save(OUT, quality=92, optimize=True, progressive=True)
