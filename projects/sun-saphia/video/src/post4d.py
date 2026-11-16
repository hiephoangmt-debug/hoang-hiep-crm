# Finish 4D frames: warm bloom, gentle grade, titles.  python post4d.py INDIR OUTDIR
import sys, os, glob
import numpy as np
from PIL import Image, ImageDraw, ImageFont, ImageFilter
ind, outd = sys.argv[1], sys.argv[2]; os.makedirs(outd, exist_ok=True)
fs = sorted(glob.glob(os.path.join(ind, 'r*.png'))); N = len(fs)
OW, OH = 720, 900; rng = np.random.default_rng(2)
fT = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', 58)
fS = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', 32)
fN = ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf', 13)
oy, ox = np.mgrid[0:OH, 0:OW]; vig = (1 - .22 * (np.hypot((ox - OW / 2) / OW, (oy - OH / 2) / OH) * 1.5) ** 2)[..., None]
def ease(x): x = min(max(x, 0), 1); return x * x * (3 - 2 * x)
for i, f in enumerate(fs):
    t = i / max(1, N - 1)
    im = Image.open(f).convert('RGB').resize((OW, OH), Image.LANCZOS)
    a = np.asarray(im, np.float32) / 255
    a = np.clip(a * np.array([1.04, .97, .86]) + np.array([.02, .005, -.01]), 0, 1)          # warm grade
    a = np.clip((a - .5) * 1.08 + .5, 0, 1)
    b = np.asarray(Image.fromarray((a * 255).astype(np.uint8)).filter(ImageFilter.GaussianBlur(16)), np.float32) / 255
    a = 1 - (1 - a) * (1 - np.clip(b - .55, 0, 1) * .9)                                         # bloom on highlights
    a = a * vig * 255 + rng.normal(0, 1.6, (OH, OW, 1))
    img = Image.fromarray(np.clip(a, 0, 255).astype(np.uint8)).convert('RGBA')
    ov = Image.new('RGBA', (OW, OH), (0, 0, 0, 0)); dr = ImageDraw.Draw(ov)
    al = ease((t - .10) / .12); al2 = ease((t - .16) / .12)
    def ctext(y, s, ft, col, a_):
        w = dr.textlength(s, font=ft); x = (OW - w) / 2
        dr.text((x + 1.5, y + 1.5), s, font=ft, fill=(255, 220, 160, int(90 * a_))); dr.text((x, y), s, font=ft, fill=(*col, int(255 * a_)))
    ctext(40, 'SUN SAPHIA', fT, (52, 24, 6), al)
    ctext(104, 'hoàng hôn bên biển Đà Nẵng', fS, (70, 32, 8), al2)
    dr.text((12, OH - 22), 'Hình ảnh minh họa · mô hình 4D', font=fN, fill=(255, 255, 255, 210))
    Image.alpha_composite(img, ov).convert('RGB').save(os.path.join(outd, 'o%04d.png' % (i + 1)))
print('POST', N)
