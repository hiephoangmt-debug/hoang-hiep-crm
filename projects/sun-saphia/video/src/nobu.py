# Golden-sunset beach clip with the Sun Saphia tower (layered 2.5D parallax).  python nobu.py OUTDIR NFRAMES [only_frames,comma]
import sys, os, math
import numpy as np
from PIL import Image, ImageDraw, ImageFont, ImageFilter
outd = sys.argv[1]; N = int(sys.argv[2]); ONLY = [int(x) for x in sys.argv[3].split(',')] if len(sys.argv) > 3 else None
os.makedirs(outd, exist_ok=True)
OW, OH = 720, 900; K = 1.5; W, H = int(OW * K), int(OH * K)
HERE = os.path.dirname(os.path.abspath(__file__))
rng = np.random.default_rng(4)
def ease(x): x = min(max(x, 0), 1); return x * x * (3 - 2 * x)

# ---------- tower layer (user-supplied clean rendering, sky removed)
T = np.asarray(Image.open(os.path.join(HERE, 'up/tower.jpg')).convert('RGB'), np.float32) / 255
tm = np.load(os.path.join(HERE, 't/tmask.npy')).astype(np.float32)
tm = np.asarray(Image.fromarray((tm * 255).astype(np.uint8)).filter(ImageFilter.GaussianBlur(1.3)), np.float32) / 255
cx0, cy0, cx1, cy1 = 470, 125, 1245, 1700
T = T[cy0:cy1, cx0:cx1]; tm = tm[cy0:cy1, cx0:cx1]
# golden grade: warm the facade, keep window glow, add warm rim on the sun-facing (top/left) edges
lum = (T @ np.array([.3, .55, .15], np.float32))[..., None]
Tg = np.clip(T * np.array([1.08, .93, .74]) + lum * np.array([.10, .05, -.02]), 0, 1)
Tg = Tg * .9 + .1 * np.array([1, .72, .38])
edge = np.clip(tm - np.asarray(Image.fromarray((tm * 255).astype(np.uint8)).filter(ImageFilter.MinFilter(9)), np.float32) / 255, 0, 1)
edge = np.asarray(Image.fromarray((edge * 255).astype(np.uint8)).filter(ImageFilter.GaussianBlur(3)), np.float32) / 255
yy = np.linspace(1, .2, Tg.shape[0])[:, None, None]
Tg = np.clip(Tg + edge[..., None] * np.array([1, .8, .45]) * .9 * yy, 0, 1)
# fade facade to warm haze toward the base (sits behind the palm band)
TH = (cy1 - cy0); tow_h = .56 * H; ts = tow_h / TH
tower = Image.fromarray(np.dstack([Tg, tm]).__mul__(255).astype(np.uint8), 'RGBA').resize((int((cx1 - cx0) * ts), int(tow_h)), Image.LANCZOS)
TX = W * .5 - tower.width * .52; TY = H * .155
# sun sits behind the crown
SX, SY = TX + (925 - cx0) * ts - 10 * K, TY + (330 - cy0) * ts

# ---------- foreground: palms, dunes, beach and surf (developer's beach perspective), badge area excluded
B = Image.open('/home/user/hoang-hiep-crm/projects/sun-saphia/images/ss-bien-hd.webp').convert('RGB')
SK = .15  # shear so the shoreline runs level, as in a straight-on shot
B = B.transform((1700, 635 + int(SK * 1700)), Image.AFFINE, (1, 0, 0, SK, 1, -SK * 1700), Image.BICUBIC)
B = B.crop((250, 222, 1450, 668))
ext = B.crop((0, B.height - 110, B.width, B.height)).transpose(Image.FLIP_TOP_BOTTOM); B2 = Image.new('RGB', (B.width, B.height + 105)); B2.paste(B, (0, 0)); B2.paste(ext, (0, B.height - 5))
B2.paste(Image.blend(B.crop((0, B.height - 5, B.width, B.height)), ext.crop((0, 0, B.width, 5)), .5), (0, B.height - 5)); B = B2; fs = W / B.width; B = B.resize((W, int(B.height * fs)), Image.LANCZOS)
Bn = np.asarray(B, np.float32) / 255; FH = Bn.shape[0]
blum = (Bn @ np.array([.3, .55, .15], np.float32))[..., None]
fy = np.arange(FH)[:, None, None] / FH
sea_w = np.clip((fy - .42) / .15, 0, 1) * (Bn[..., 2:3] > Bn[..., 0:1])        # blue water keeps some blue
land = np.clip(Bn * np.array([1.12, .94, .70]) + blum * np.array([.08, .03, -.03]), 0, 1)
water = np.clip(Bn * np.array([.9, .9, .95]) + blum * np.array([.18, .08, -.02]), 0, 1)
Bg = land * (1 - sea_w) + water * sea_w
fa = np.clip((np.arange(FH) - 10 * K) / (55 * K), 0, 1)[:, None] * np.ones((1, W))   # soft top edge into the haze
# haze over the far part of the plate
Bg = Bg * (1 - (1 - fy) ** 3 * .55) + np.array([1, .70, .38]) * (1 - fy) ** 3 * .55
FY = H - FH
fg = Image.fromarray(np.dstack([Bg, fa[..., None]]).__mul__(255).astype(np.uint8), 'RGBA')
fgsea = (fy[..., 0] > .40)

# ---------- distant city band (developer perspective, far city + lagoon), mirrored to fill, heavy golden haze
P = Image.open('/home/user/hoang-hiep-crm/projects/sun-saphia/images/ss-phoi-canh-thap.webp').convert('RGB').crop((300, 292, 850, 455))
ps = (W / 2 + 20) / P.width; P = P.resize((int(P.width * ps), int(P.height * ps)), Image.LANCZOS)
band = Image.new('RGB', (W, P.height)); band.paste(P.transpose(Image.FLIP_LEFT_RIGHT), (0, 0)); band.paste(P, (W - P.width, 0))
bn = np.asarray(band, np.float32) / 255; bl_ = (bn @ np.array([.3, .55, .15], np.float32))[..., None]
bn = np.clip(bl_ * np.array([1.15, .82, .45]) + .08, 0, 1)
by = np.arange(bn.shape[0])[:, None, None] / bn.shape[0]
hzc = np.array([1, .74, .42]); bn = bn * (1 - (.62 - .3 * by)) + hzc * (.62 - .3 * by)
ba = np.clip(np.arange(bn.shape[0]) / (25 * K), 0, 1)[:, None] * np.ones((1, W))
sk = Image.new('RGBA', (W, H)); base = FY + 55 * K
sk.paste(Image.fromarray(np.dstack([bn, ba[..., None]]).__mul__(255).astype(np.uint8), 'RGBA'), (0, int(base - bn.shape[0])))
# ---------- sky
def fbm(w, h, octv, base_, seed):
    r = np.random.default_rng(seed); acc = np.zeros((h, w), np.float32); amp = 1; tot = 0
    for o in range(octv):
        n = base_ * 2 ** o; g = r.random((n + 1, int(n * w / h) + 2))
        acc += amp * np.asarray(Image.fromarray((g * 255).astype(np.uint8)).resize((w, h), Image.BICUBIC), np.float32) / 255; tot += amp; amp *= .5
    return acc / tot
CW = int(W * 1.25)
cl = fbm(CW, H, 7, 3, 21) * .65 + fbm(CW, H, 6, 5, 22) * .35
Y, X = np.mgrid[0:H, 0:W].astype(np.float32)
D = np.hypot(X - SX, Y - SY); R = .17 * W
vy = np.clip(Y / (FY + 80 * K), 0, 1)[..., None]
top = np.array([.93, .50, .07]); hor = np.array([1.0, .80, .40])
skybase = top * (1 - vy ** 1.3) + hor * vy ** 1.3

fT = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', int(58 * K))
fS = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', int(34 * K))
fN = ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf', int(14 * K))

def zoomed(layer, z, fx, fy_, dx=0, dy=0):
    # scale layer (full-frame RGBA) by z about focal point
    a = 1 / z
    return layer.transform((W, H), Image.AFFINE, (a, 0, fx - a * fx - dx, 0, a, fy_ - a * fy_ - dy), Image.BICUBIC)

towL = Image.new('RGBA', (W, H)); towL.paste(tower, (int(TX), int(TY)))
fgL = Image.new('RGBA', (W, H)); fgL.paste(fg, (0, int(FY)))
frames = ONLY or range(1, N + 1)
for fi in frames:
    t = (fi - 1) / max(1, N - 1); e = ease(t / .18)
    # sky
    off = int(t * W * .08); c = cl[:, off:off + W]
    c = np.clip((c - .5) * 3.0, 0, 1) * np.clip(1.15 - vy[..., 0] * 1.1, 0, 1)
    lit = np.exp(-D / (W * .33))[..., None]
    ccol = np.array([.96, .58, .18]) * (1 - lit) + np.array([1, .93, .72]) * lit
    s = skybase * (1 - c[..., None] * .7) + (ccol * .72 + np.array([.70, .32, .06]) * .28 * (1 - lit)) * c[..., None] * .7
    p = 1 + .025 * math.sin(t * 2 * math.pi * 1.2)
    core = np.clip(1.25 - D / (R * p), 0, 1) ** .55
    s = s + (np.array([1, .98, .86]) - s) * core[..., None]
    bloom = np.exp(-(D / (R * 1.9)) ** 2) * .5 + np.exp(-D / (R * 2.4)) * .3
    ring = np.exp(-((D - R * 2.3) / (R * .045)) ** 2) * .09
    s = np.clip(s + np.array([1, .76, .30]) * (bloom + ring)[..., None] * .6, 0, 1)
    img = Image.fromarray((s * 255).astype(np.uint8)).convert('RGBA')
    # camera: pull back from the crown to the wide view, with parallax
    z0 = 1.0 + .14 * (1 - e) + .035 * t
    fx, fy_ = W * .5, H * .45
    img = zoomed(img, 1 + (z0 - 1) * .25, fx, fy_)
    img = Image.alpha_composite(img, zoomed(sk, 1 + (z0 - 1) * .85, fx, fy_))
    img = Image.alpha_composite(img, zoomed(towL, z0, fx, fy_))
    # waves: displace sea rows of the foreground, travelling toward the shore
    ph = 2 * math.pi * t * 3.2
    fa_ = np.asarray(fgL, np.float32)
    rows = np.arange(H)[:, None]; cols = np.arange(W)[None, :]
    sea_m = np.zeros((H, W), bool); sea_m[int(FY):] = fgsea[:H - int(FY)]
    amp = np.clip((rows - FY - .4 * FH) / (.3 * FH), 0, 1)
    dy = amp * 1.6 * K * np.sin(cols / (40 * K) + rows / (8 * K) - ph)
    dx = amp * 2.2 * K * np.sin(rows / (13 * K) - ph * 1.2 + cols / (70 * K))
    yi = np.clip(rows + dy, 0, H - 1).astype(np.int32); xi = np.clip(cols + dx, 0, W - 1).astype(np.int32)
    fa_ = np.where(sea_m[..., None], fa_[yi, xi], fa_)
    fgl = Image.fromarray(fa_.astype(np.uint8), 'RGBA')
    img = Image.alpha_composite(img, zoomed(fgl, z0 * 1.0, fx, fy_))
    a = np.asarray(img.convert('RGB'), np.float32) / 255
    # sun spill + glow over everything near the sun
    spill = np.exp(-(D / (R * 1.7)) ** 2)[..., None] * (1 - core[..., None])
    a = np.clip(a + np.array([1, .70, .28]) * spill * .22, 0, 1)
    # light shafts from the sun
    ang = np.arctan2(Y - SY, X - SX); shafts = (np.sin(ang * 22 + t * .8) * .5 + .5) ** 6 * np.exp(-D / (W * .55)) * (Y > SY)
    a = np.clip(a + np.array([1, .8, .45]) * shafts[..., None] * .07, 0, 1)
    a = np.clip((a - .5) * 1.12 + .5 + (a - a.mean(-1, keepdims=True)) * .1, 0, 1); a = a ** 1.08
    im = Image.fromarray((a * 255).astype(np.uint8))
    bl = im.filter(ImageFilter.GaussianBlur(18 * K))
    im = Image.fromarray(np.maximum(np.asarray(im), (np.asarray(bl) * .9).astype(np.uint8)))
    im = im.resize((OW, OH), Image.LANCZOS).filter(ImageFilter.UnsharpMask(1.2, 60, 2))
    v = np.asarray(im, np.float32); oy, ox = np.mgrid[0:OH, 0:OW]
    v = v * (1 - .22 * (np.hypot((ox - OW / 2) / OW, (oy - OH / 2) / OH) * 1.5) ** 2)[..., None] + rng.normal(0, 1.8, (OH, OW, 1))
    im = Image.fromarray(np.clip(v, 0, 255).astype(np.uint8)).convert('RGBA')
    ov = Image.new('RGBA', (OW, OH), (0, 0, 0, 0)); dr = ImageDraw.Draw(ov)
    fT2 = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', 58)
    fS2 = ImageFont.truetype('/usr/share/fonts/truetype/liberation/LiberationSerif-Italic.ttf', 32)
    fN2 = ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf', 13)
    al = ease((t - .12) / .12); al2 = ease((t - .18) / .12)
    def ctext(y, s_, f_, col, a_):
        w = dr.textlength(s_, font=f_); xx = (OW - w) / 2
        dr.text((xx + 1.5, y + 1.5), s_, font=f_, fill=(255, 210, 140, int(90 * a_))); dr.text((xx, y), s_, font=f_, fill=(*col, int(255 * a_)))
    ctext(38, 'SUN SAPHIA', fT2, (38, 20, 6), al)
    ctext(102, 'hoàng hôn bên biển Đà Nẵng', fS2, (55, 26, 6), al2)
    dr.text((12, OH - 22), 'Hình ảnh minh họa', font=fN2, fill=(255, 255, 255, 200))
    Image.alpha_composite(im, ov).convert('RGB').save(os.path.join(outd, 'n%04d.png' % fi))
print('NOBU', len(list(frames)))
