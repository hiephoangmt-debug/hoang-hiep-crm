"""Ảnh bìa web 1600×1000 và ảnh FB dọc 1080×1350 – Quy hoạch chung đô thị Thăng Điền đến 2050 (QĐ 5047/QĐ-UBND, 5/11/2026).
Bản đồ cách điệu (không theo tỷ lệ): Quốc lộ 1, trục Đông – Tây, biển phía Đông.
Chạy: python3 quy-hoach-chung-do-thi-thang-dien-2050.py <anh-dai-dien.jpg> <out-web.jpg> <out-fb.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont

AVA, OUT_WEB, OUT_FB = sys.argv[1:4]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206)
SEA, LAND, GREEN = (34, 74, 120), (28, 52, 88), (64, 128, 104)
STATS = [('~6.158,71 ha', 'Diện tích lập quy hoạch'), ('~96.498 người', 'Dân số dự báo năm 2050'),
         ('Bình Tú · Bình Trung · Bình An', 'Hợp nhất thành xã Thăng Điền')]


def map_panel(d, P, x0, y0, w, h, F):
    """Bản đồ cách điệu: đất liền bên trái, biển bên phải, QL1 dọc, trục Đông–Tây ngang."""
    d.rounded_rectangle(P(x0, y0, x0 + w, y0 + h), radius=24, fill=LAND)
    # biển phía Đông (bờ cong)
    pts = [(x0 + w * 0.72, y0)]
    for i in range(0, 11):
        t = i / 10
        pts.append((x0 + w * (0.72 + 0.06 * ((-1) ** i) * 0.3 + 0.05 * t), y0 + h * t))
    pts += [(x0 + w, y0 + h), (x0 + w, y0)]
    d.polygon([P(*p) for p in pts], fill=SEA)
    for k in range(6):
        yy = y0 + 40 + k * h / 6
        d.line(P(x0 + w * 0.84, yy, x0 + w * 0.95, yy), fill=(120, 170, 210, 110), width=4)
    d.text(P(x0 + w * 0.80, y0 + h - 60), 'Biển', font=F('Inter-SemiBold.otf', 26), fill=(170, 210, 240))
    # sông Trường Giang chạy song song bờ biển
    d.line([P(x0 + w * 0.66, y0 + 10), P(x0 + w * 0.63, y0 + h * 0.5), P(x0 + w * 0.67, y0 + h - 10)], fill=(90, 150, 200), width=10)
    # vùng xã Thăng Điền
    cx, cy = x0 + w * 0.45, y0 + h * 0.5
    d.rounded_rectangle(P(cx - w * 0.33, cy - h * 0.26, cx + w * 0.17, cy + h * 0.26), radius=40,
                        fill=(216, 177, 106, 70), outline=GOLD, width=5)
    d.text(P(cx - w * 0.17, cy - 26), 'Thăng Điền', font=F('InterDisplay-Bold.otf', 34), fill=CREAM)
    # QL1 dọc
    qx = x0 + w * 0.2
    d.line(P(qx, y0, qx, y0 + h), fill=(230, 120, 90), width=12)
    d.rounded_rectangle(P(qx - 34, y0 + 30, qx + 34, y0 + 66), radius=8, fill=(230, 120, 90))
    d.text(P(qx - 24, y0 + 34), 'QL1', font=F('Inter-Bold.otf', 22), fill=CREAM)
    # trục Đông – Tây
    for yy in (cy - h * 0.12, cy + h * 0.16):
        d.line(P(x0 + 10, yy, x0 + w * 0.66, yy), fill=GOLD, width=7)
    d.text(P(x0 + w * 0.24, cy + h * 0.18), 'Trục Đông – Tây', font=F('Inter-Medium.otf', 20), fill=GOLD)
    # mũi tên Bắc
    d.polygon([P(x0 + 40, y0 + 70), P(x0 + 30, y0 + 100), P(x0 + 50, y0 + 100)], fill=CREAM)
    d.text(P(x0 + 33, y0 + 40), 'B', font=F('Inter-Bold.otf', 20), fill=CREAM)


def web():
    W, H, S = 1600, 1000, 2
    F = lambda n, s: ImageFont.truetype(I + n, s * S)
    P = lambda *v: tuple(int(x * S) for x in v)
    im = Image.new('RGB', (W * S, H * S), NAVY)
    d = ImageDraw.Draw(im, 'RGBA')
    map_panel(d, P, 60, 60, 700, 880, F)
    x0 = 820
    d.text(P(x0, 80), 'HẠ TẦNG & QUY HOẠCH · ĐÀ NẴNG', font=F('Inter-Bold.otf', 24), fill=GOLD)
    d.text(P(x0, 124), 'Quy hoạch chung', font=F('InterDisplay-ExtraBold.otf', 66), fill=CREAM)
    d.text(P(x0, 200), 'đô thị Thăng Điền', font=F('InterDisplay-ExtraBold.otf', 66), fill=(255, 200, 140))
    d.text(P(x0, 282), 'Đến năm 2050 · QĐ 5047/QĐ-UBND ngày 5/11/2026', font=F('Inter-Medium.otf', 26), fill=MUTED)
    y = 360
    for big, lab in STATS:
        d.rounded_rectangle(P(x0, y, W - 70, y + 120), radius=18 * S, fill=NAVY2)
        d.text(P(x0 + 26, y + 16), big, font=F('InterDisplay-Bold.otf', 40 if len(big) < 20 else 30), fill=CREAM)
        d.text(P(x0 + 26, y + 74), lab, font=F('Inter-Regular.otf', 24), fill=MUTED)
        y += 140
    d.text(P(x0, y + 10), 'Định hướng: dịch vụ, logistics, công nghiệp sạch,', font=F('Inter-Medium.otf', 25), fill=CREAM)
    d.text(P(x0, y + 46), 'nông nghiệp công nghệ cao phía Nam Đà Nẵng', font=F('Inter-Medium.otf', 25), fill=CREAM)
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
    d.text(P(58, 116), 'Đô thị Thăng Điền', font=F('InterDisplay-ExtraBold.otf', 70), fill=CREAM)
    d.text(P(60, 200), 'có định hướng đến năm 2050', font=F('InterDisplay-Bold.otf', 42), fill=(255, 200, 140))
    d.text(P(60, 262), 'Phê duyệt nhiệm vụ quy hoạch chung ngày 5/11/2026', font=F('Inter-Medium.otf', 24), fill=MUTED)
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
