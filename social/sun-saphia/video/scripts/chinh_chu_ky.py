"""Chỉnh chữ ký Hoàng Hiệp: assets/chu-ky-goc (tách từ video Hành trình xây dựng) -> assets/chu-ky.
1) Nét gạch ngang chữ "Hoàng": nửa phải vẽ lại cùng độ dày nửa trái, tiếp tục đi lên.
2) Bỏ chữ "ĐÀ NẴNG", thay bằng số điện thoại 0904 567 009 nghiêng theo nét cuối.
3) Nét gạch cuối kéo dài hết dãy số, cùng độ dày nét gốc, thon nhẹ ở đầu mút.
Chạy: python3 scripts/chinh_chu_ky.py
"""
import os, math, numpy as np
from PIL import Image, ImageDraw, ImageFont
HERE = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SRC, DST = f"{HERE}/assets/chu-ky-goc", f"{HERE}/assets/chu-ky"
W, H, SS, N = 330, 231, 8, 194
PHONE = "0904 567 009"

def polystroke(p0, p1, w, taper=6, tw_end=1.3):
    """Nét thẳng từ p0 tới p1 dày w (px), thon dần `taper` px cuối; trả về kênh alpha W x H."""
    L = Image.new("L", (W * SS, H * SS), 0); d = ImageDraw.Draw(L)
    (x0, y0), (x1, y1) = p0, p1; ln = math.hypot(x1 - x0, y1 - y0)
    if ln < 0.5: return np.zeros((H, W), np.uint8)
    ux, uy = (x1 - x0) / ln, (y1 - y0) / ln; px, py = -uy, ux; pl, pr = [], []
    for s in np.linspace(0, ln, 60):
        ww = w if ln - s > taper else max(tw_end, w - (w - tw_end) * (1 - (ln - s) / taper))
        x, y = x0 + ux * s, y0 + uy * s
        pl.append(((x + px * ww / 2) * SS, (y + py * ww / 2) * SS)); pr.append(((x - px * ww / 2) * SS, (y - py * ww / 2) * SS))
    d.polygon(pl + pr[::-1], fill=255); r = w / 2 * SS * 0.95
    d.ellipse((x0 * SS - r, y0 * SS - r, x0 * SS + r, y0 * SS + r), fill=255)
    return np.array(L.resize((W, H), Image.LANCZOS))

def band(f, x_from, x_to, half):
    m = np.zeros((H, W), bool)
    for x in range(x_from, x_to):
        yc = f(x); m[max(0, int(yc - half)):int(yc + half + 1), x] = True
    return m

# 1) nét ngang chữ Hoàng
bar_old = lambda x: 102.8 - 0.146 * (x - 140)          # nửa phải cũ (gần nằm ngang, mảnh)
bar_new = lambda x: 109.0 - 0.33 * (x - 116)           # nối tiếp nửa trái, đi lên đều
BAR_ERASE = band(bar_old, 139, 186, 3.5)
BAR_P0, BAR_X1, BAR_W = (120, bar_new(120)), 183, 3.05
# 2) + 3) nét cuối và số điện thoại
m_end = -0.4358; b_end = 272.44; line = lambda x: m_end * x + b_end
ly = lambda x: 170 - 0.42 * (x - 230)
DN = np.zeros((H, W), bool)
for x in range(236, 284):
    DN[int(ly(x) + 3.5):187, x] = True
TAIL = band(line, 276, 290, 4)
ang = math.degrees(math.atan(-m_end))
f = ImageFont.truetype("/usr/share/fonts/opentype/inter/Inter-ExtraBold.otf", 48)
tw = ImageDraw.Draw(Image.new("L", (1, 1))).textlength(PHONE, font=f) / 4
cx = 256; XE = cx + (tw / 2) * math.cos(math.radians(ang)) + 4
tl = Image.new("RGBA", (int(tw * 4) + 20, 64), (0, 0, 0, 0)); ImageDraw.Draw(tl).text((10, 0), PHONE, font=f, fill=(255, 255, 255, 255))
tl = tl.rotate(ang, expand=True, resample=Image.BICUBIC)
off = 10.5; nx, ny = math.sin(math.radians(ang)), math.cos(math.radians(ang))
t = Image.new("RGBA", (W * 4, H * 4), (0, 0, 0, 0))
t.alpha_composite(tl, (int((cx + off * nx) * 4 - tl.width / 2), int((line(cx) + off * ny) * 4 - tl.height / 2)))
PHONE_IMG = t.resize((W, H), Image.LANCZOS)

def add(a, alpha):
    a[..., 3] = np.maximum(a[..., 3], alpha); a[alpha > 0, :3] = 255

os.makedirs(DST, exist_ok=True)
for i in range(N):
    a = np.array(Image.open(f"{SRC}/s{i:03d}.png").convert("RGBA"))
    a[DN, 3] = 0
    if i >= 17:                                   # nét ngang viết ra trong khung 17-19
        a[BAR_ERASE, 3] = 0
        k = min(1.0, (i - 16) / 3); x1 = 140 + (BAR_X1 - 140) * k
        add(a, polystroke(BAR_P0, (x1, bar_new(x1)), BAR_W))
    if i >= 131:                                  # nét cuối viết tiếp qua dãy số
        a[TAIL, 3] = 0
        k = min(1.0, (i - 130) / 6); x1 = 282 + (XE - 282) * k
        add(a, polystroke((274, line(274)), (x1, line(x1)), 3.12 * 0.92, taper=9))
    im = Image.fromarray(a, "RGBA")
    if i >= 128:
        k = min(1.0, (i - 127) / 10); p = PHONE_IMG.copy(); p.putalpha(p.getchannel("A").point(lambda v: int(v * k))); im.alpha_composite(p)
    im.save(f"{DST}/s{i:03d}.png")
print("xong", N, "khung")
