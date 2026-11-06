"""Ảnh bìa web 1600×1000 và ảnh FB dọc 1080×1350 – 3 khu tái định cư tại Duy Xuyên phục vụ đường sắt tốc độ cao (QĐ 5082/QĐ-UBND).
Sơ đồ cách điệu, không theo tỷ lệ, vị trí các khu chỉ minh hoạ.
Chạy: python3 tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao.py <anh-dai-dien.jpg> <out-web.jpg> <out-fb.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, OUT_WEB, OUT_FB = sys.argv[1:4]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
SEA, LAND, GREEN = (34, 74, 120), (28, 52, 88), (64, 128, 104)
STATS = [('Hơn 392 tỷ đồng', 'Tổng mức đầu tư (QĐ 5082/QĐ-UBND)'), ('~31 ha · 3 khu', 'Duy Trung, Duy Sơn, Duy Trinh – Duy Sơn'),
         ('2026 – 2029', 'Thời gian thực hiện dự kiến')]


def map_panel(d, P, x0, y0, w, h, F):
    """Sơ đồ cách điệu: tuyến đường sắt tốc độ cao Bắc – Nam qua Duy Xuyên, sông Thu Bồn, 3 khu tái định cư."""
    d.rounded_rectangle(P(x0, y0, x0 + w, y0 + h), radius=24, fill=LAND)
    # sông Thu Bồn chảy ngang ra biển (phía Đông)
    d.line([P(x0 + 10, y0 + h * 0.30), P(x0 + w * 0.35, y0 + h * 0.24), P(x0 + w * 0.65, y0 + h * 0.30), P(x0 + w - 10, y0 + h * 0.22)], fill=(90, 150, 200), width=14)
    d.text(P(x0 + w * 0.58, y0 + h * 0.15), 'Sông Thu Bồn', font=F('Inter-Medium.otf', 20), fill=(170, 210, 240))
    d.text(P(x0 + w * 0.06, y0 + h * 0.08), '↑ Hội An · Điện Bàn', font=F('Inter-Medium.otf', 20), fill=MUTED)
    # tuyến đường sắt tốc độ cao (nét đứt dọc)
    rx = x0 + w * 0.42
    yy = y0 + 20
    while yy < y0 + h - 20:
        d.line(P(rx, yy, rx, min(yy + 34, y0 + h - 20)), fill=(230, 120, 90), width=10)
        yy += 54
    d.rounded_rectangle(P(rx - 150, y0 + h - 76, rx + 150, y0 + h - 36), radius=8, fill=(230, 120, 90))
    d.text(P(rx, y0 + h - 56), 'Đường sắt tốc độ cao Bắc – Nam', font=F('Inter-Bold.otf', 19), fill=CREAM, anchor='mm')
    # 3 khu tái định cư
    zones = [(0.68, 0.45, 'Duy Trung', '~5,27 ha'), (0.18, 0.55, 'Duy Sơn', '~10,99 ha'), (0.66, 0.72, 'Duy Trinh – Duy Sơn', '~14,74 ha')]
    for fx, fy, name, ha in zones:
        cx, cy = x0 + w * fx, y0 + h * fy
        d.ellipse(P(cx - 22, cy - 22, cx + 22, cy + 22), fill=GOLD)
        d.text(P(cx, cy + 34), name, font=F('Inter-Bold.otf', 22), fill=CREAM, anchor='ma')
        d.text(P(cx, cy + 64), ha, font=F('Inter-Medium.otf', 20), fill=GOLD, anchor='ma')
    d.text(P(x0 + 24, y0 + h * 0.38), 'Xã Duy Xuyên', font=F('InterDisplay-Bold.otf', 30), fill=(255, 200, 140))
    d.polygon([P(x0 + w - 40, y0 + 40), P(x0 + w - 50, y0 + 70), P(x0 + w - 30, y0 + 70)], fill=CREAM)
    d.text(P(x0 + w - 47, y0 + 74), 'B', font=F('Inter-Bold.otf', 20), fill=CREAM)


def web():
    W, H, S = 1600, 1000, 2
    F = lambda n, s: ImageFont.truetype(I + n, s * S)
    P = lambda *v: tuple(int(x * S) for x in v)
    im = Image.new('RGB', (W * S, H * S), NAVY)
    d = ImageDraw.Draw(im, 'RGBA')
    map_panel(d, P, 60, 60, 700, 880, F)
    x0 = 820
    d.text(P(x0, 80), 'HẠ TẦNG & QUY HOẠCH · ĐÀ NẴNG', font=F('Inter-Bold.otf', 24), fill=GOLD)
    d.text(P(x0, 124), '3 khu tái định cư', font=F('InterDisplay-ExtraBold.otf', 66), fill=CREAM)
    d.text(P(x0, 200), 'tại Duy Xuyên', font=F('InterDisplay-ExtraBold.otf', 66), fill=(255, 200, 140))
    d.text(P(x0, 282), 'Phục vụ đường sắt tốc độ cao Bắc – Nam', font=F('Inter-Medium.otf', 26), fill=MUTED)
    y = 360
    for big, lab in STATS:
        d.rounded_rectangle(P(x0, y, W - 70, y + 120), radius=18 * S, fill=NAVY2)
        d.text(P(x0 + 26, y + 16), big, font=F('InterDisplay-Bold.otf', 40 if len(big) < 20 else 30), fill=CREAM)
        d.text(P(x0 + 26, y + 74), lab, font=F('Inter-Regular.otf', 24), fill=MUTED)
        y += 140
    d.text(P(x0, y + 10), 'Hạ tầng: san nền, đường, thoát nước, cấp điện,', font=F('Inter-Medium.otf', 25), fill=CREAM)
    d.text(P(x0, y + 46), 'cấp nước, xử lý nước thải, chiếu sáng, cây xanh', font=F('Inter-Medium.otf', 25), fill=CREAM)
    d.text(P(x0, H - 60), 'Hoàng Hiệp · BĐS Đà Nẵng · Zalo 0904 567 009 · Sơ đồ minh hoạ', font=F('Inter-SemiBold.otf', 21), fill=GOLD)
    im.resize((W, H), Image.LANCZOS).save(OUT_WEB, quality=88, optimize=True, progressive=True)


def fb():
    W, H, S = 1080, 1350, 2
    F = lambda n, s: ImageFont.truetype(I + n, s * S)
    P = lambda *v: tuple(int(x * S) for x in v)
    im = Image.new('RGB', (W * S, H * S), NAVY)
    d = ImageDraw.Draw(im, 'RGBA')
    tag = 'HẠ TẦNG & QUY HOẠCH'
    ft = F('Inter-Bold.otf', 21)
    tw = d.textlength(tag, font=ft) / S
    d.rounded_rectangle(P(60, 56, 60 + tw + 40, 96), radius=20 * S, fill=GOLD)
    d.text(P(80, 64), tag, font=F('Inter-Bold.otf', 21), fill=NAVY)
    d.text(P(58, 116), 'Tái định cư Duy Xuyên', font=F('InterDisplay-ExtraBold.otf', 64), fill=CREAM)
    d.text(P(60, 200), 'cho đường sắt tốc độ cao', font=F('InterDisplay-Bold.otf', 42), fill=(255, 200, 140))
    d.text(P(60, 262), 'Đà Nẵng duyệt 3 khu, tổng mức đầu tư hơn 392 tỷ đồng', font=F('Inter-Medium.otf', 24), fill=MUTED)
    map_panel(d, P, 60, 320, 960, 520, F)
    y = 870
    for big, lab in STATS:
        d.text(P(60, y), big, font=F('InterDisplay-Bold.otf', 34 if len(big) < 20 else 28), fill=CREAM)
        d.text(P(W - 60, y + 6), lab, font=F('Inter-Regular.otf', 22), fill=MUTED, anchor='ra')
        y += 62
        d.line(P(60, y - 12, W - 60, y - 12), fill=(255, 255, 255, 28), width=S)
    ay = 1200
    a = Image.open(AVA).convert('RGB').resize((100 * S, 100 * S), Image.LANCZOS)
    mk = Image.new('L', a.size, 0)
    ImageDraw.Draw(mk).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
    d.ellipse(P(60, ay - 4, 168, ay + 104), fill=GOLD)
    im.paste(a, P(64, ay), mk)
    d = ImageDraw.Draw(im, 'RGBA')
    d.text(P(192, ay + 10), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 32), fill=CREAM)
    d.text(P(192, ay + 56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 25), fill=GOLD)
    d.text(P(W - 60, 1322), 'Sơ đồ minh hoạ, không theo tỷ lệ', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
    im.resize((W, H), Image.LANCZOS).save(OUT_FB, quality=92, optimize=True, progressive=True)


web()
fb()
