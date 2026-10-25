# Ghép nhiều ảnh thành 1 ảnh 1080x1350 (4:5) cho Facebook: không cắt ảnh (ảnh nằm trọn trong ô, nền mờ của chính ảnh).
import sys
from PIL import Image, ImageDraw, ImageFont, ImageFilter
F = "/usr/share/fonts/opentype/inter/"
def f(w, s): return ImageFont.truetype(F + {"b": "Inter-Bold.otf", "sb": "Inter-SemiBold.otf"}[w], s)
NAVY = (16, 36, 72); OR = (242, 112, 36); WH = (255, 255, 255)
W, H, FOOT, G = 1080, 1350, 96, 8
def put(im, src, box):
    x0, y0, x1, y1 = box; bw, bh = x1 - x0, y1 - y0
    s = Image.open(src).convert("RGB")
    sc = max(bw / s.width, bh / s.height)          # nền: phủ kín ô, làm mờ
    bg = s.resize((int(s.width * sc) + 1, int(s.height * sc) + 1)).filter(ImageFilter.GaussianBlur(28))
    bg = bg.crop(((bg.width - bw) // 2, (bg.height - bh) // 2, (bg.width - bw) // 2 + bw, (bg.height - bh) // 2 + bh))
    bg = Image.blend(bg, Image.new("RGB", bg.size, NAVY), 0.35); im.paste(bg, (x0, y0))
    sc = min(bw / s.width, bh / s.height)          # ảnh chính: nằm trọn trong ô
    fg = s.resize((round(s.width * sc), round(s.height * sc)), Image.LANCZOS)
    im.paste(fg, (x0 + (bw - fg.width) // 2, y0 + (bh - fg.height) // 2))
def ghep(out, srcs):
    im = Image.new("RGB", (W, H), NAVY); A = H - FOOT; n = len(srcs)
    if n == 4: boxes = [(c * (W + G) // 2, r * (A + G) // 2, (c + 1) * (W + G) // 2 - G, (r + 1) * (A + G) // 2 - G) for r in range(2) for c in range(2)]
    else: boxes = [(0, i * (A + G) // n, W, (i + 1) * (A + G) // n - G) for i in range(n)]
    for s, b in zip(srcs, boxes): put(im, s, b)
    d = ImageDraw.Draw(im); y = A + (FOOT - 30) // 2
    d.text((48, y), "SUN SAPHIA RESIDENCE", font=f("b", 28), fill=WH)
    d.text((W - 48, y), "Hoàng Hiệp · Zalo 0904 567 009", font=f("sb", 26), fill=OR, anchor="ra")
    im.save(out, quality=90)
if __name__ == "__main__": ghep(sys.argv[1], sys.argv[2:])
