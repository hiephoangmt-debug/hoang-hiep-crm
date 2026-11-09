"""Ghép video giới thiệu Sun Saphia 9:16 (1080x1920, 24 hình/giây):
khung flycam từ render.js + ảnh phối cảnh 4K (hiệu ứng zoom chậm) + chữ + nhạc nền.
Dùng: python3 ghep.py <thư-mục-khung-flycam> <thư-mục-ảnh-4K> <nhạc> <file-ra.mp4>
Thư mục khung: các thư mục con p*/fNNNNN.jpg (đánh số theo plan.json)."""
import sys, os, glob, math, subprocess, tempfile, shutil
from PIL import Image, ImageDraw, ImageFont, ImageFilter

W, H, FPS = 1080, 1920, 24
FLY, PICS, MUSIC, OUT = sys.argv[1:5]
F = '/usr/share/fonts/opentype/inter/'
def font(n, s): return ImageFont.truetype(F + n, s)
ORANGE, WHITE = (255, 154, 69), (255, 255, 255)

# ---------- các cảnh ----------
FLY_LEN = 36.0                          # 4 cảnh flycam = 8 + 12 + 8 + 8 giây
STILLS = [  # (giây bắt đầu, dài, ảnh, (tâm x, tâm y theo tỉ lệ ảnh), zoom đầu → cuối)
    (36.0, 5.0, '1oQcbk62K1LZk-PyXAe6-PXnHmTyKVZTh.jpg', (.555, .52), (1.0, 1.12)),   # phối cảnh hoàng hôn trên cao
    (41.0, 5.0, '15SrGpVsw_MZgpmIjj_urJf7hqnQ67BmI.jpg', (.5, .5), (1.12, 1.0)),      # tòa tháp ban ngày (ảnh dọc)
    (46.0, 8.0, '1rtPUtBi7YFF-nxtuCQhKnBx0dOCUaNcX.jpg', (.5, .46), (1.0, 1.1)),      # tòa tháp ban đêm (ảnh dọc) – kêu gọi
]
TOTAL = 54.0
XF = 0.4                                 # thời gian chuyển cảnh mờ dần (giây)
CUTS = [8.0, 20.0, 28.0, 36.0, 41.0, 46.0]

# ---------- chữ ----------
TXT = [
    (0.3, 3.7, 'top', [('CĂN HỘ MẶT BIỂN ĐẦU TIÊN', WHITE, 'InterDisplay-Black.otf', 78), ('của Sun Group tại Đà Nẵng', WHITE, 'Inter-SemiBold.otf', 54)]),
    (3.9, 7.8, 'top', [('Chỉ ~450 triệu', ORANGE, 'InterDisplay-Black.otf', 112), ('đến khi nhận nhà', WHITE, 'Inter-Bold.otf', 60)]),
    (8.6, 13.9, 'bottom', [('PHÍA TRƯỚC', ORANGE, 'Inter-ExtraBold.otf', 42), ('Biển Sơn Thủy & dải resort cao cấp', WHITE, 'InterDisplay-Bold.otf', 60)]),
    (14.3, 19.7, 'bottom', [('XOAY VỀ THÀNH PHỐ', ORANGE, 'Inter-ExtraBold.otf', 42), ('Ngũ Hành Sơn & trung tâm Đà Nẵng', WHITE, 'InterDisplay-Bold.otf', 60)]),
    (20.4, 24.0, 'top', [('Trục biển Võ Nguyên Giáp – Trường Sa', WHITE, 'InterDisplay-Bold.otf', 56), ('MỞ RỘNG · vốn dự kiến 2.633 tỷ', ORANGE, 'Inter-ExtraBold.otf', 48)]),
    (24.3, 27.8, 'top', [('Công viên 2,45 ha trước dự án', WHITE, 'InterDisplay-Bold.otf', 58), ('nối thẳng ra bãi tắm · đã phê duyệt', ORANGE, 'Inter-ExtraBold.otf', 46)]),
    (28.4, 31.7, 'top', [('Đường sắt đô thị Sân bay – Hội An', WHITE, 'InterDisplay-Bold.otf', 56), ('Ga cách dự án ~500 m · đang đề xuất', ORANGE, 'Inter-ExtraBold.otf', 46)]),
    (31.9, 35.8, 'list', [('Sân bay', '~8 km · 15–20 phút'), ('Cầu Rồng', '~6 km · 15 phút'), ('Ngũ Hành Sơn', '~3 km · 5 phút'), ('Phố cổ Hội An', '~25 km · 30 phút')]),
    (36.4, 40.8, 'bottom', [('Ra biển chỉ', WHITE, 'InterDisplay-Bold.otf', 60), ('HƠN 300 M', ORANGE, 'InterDisplay-Black.otf', 130)]),
    (41.4, 45.8, 'bottom', [('Studio dự kiến từ', WHITE, 'InterDisplay-Bold.otf', 54), ('~1,8 TỶ', ORANGE, 'InterDisplay-Black.otf', 128),
                            ('Đóng ~25% đến khi nhận nhà', WHITE, 'Inter-Bold.otf', 48), ('Vay 70% · hỗ trợ lãi suất tới 24 tháng', WHITE, 'Inter-SemiBold.otf', 42)]),
    (46.5, 54.0, 'cta', None),
]


def ease(x): x = max(0., min(1., x)); return x * x * (3 - 2 * x)


def shade(img, where, h):
    """dải tối mờ sau chữ để đọc rõ trên mọi nền"""
    g = Image.new('L', (1, h))
    for y in range(h):
        k = y / (h - 1)
        g.putpixel((0, y), int(200 * ((1 - k) if where == 'top' else k) ** 1.4))
    g = g.resize((W, h)); black = Image.new('RGB', (W, h), (6, 18, 34))
    y0 = 0 if where == 'top' else H - h
    img.paste(black, (0, y0), g)


def draw_lines(img, lines, y, a, align_top=True):
    lay = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(lay)
    hs = []
    for txt, col, fn, sz in lines:
        f = font(fn, sz); bb = d.textbbox((0, 0), txt, font=f)
        while bb[2] - bb[0] > W - 110 and sz > 30: sz -= 2; f = font(fn, sz); bb = d.textbbox((0, 0), txt, font=f)
        hs.append((txt, col, f, bb))
    tot = sum(b[3] - b[1] + 22 for _, _, _, b in hs)
    yy = y if align_top else y - tot
    for txt, col, f, bb in hs:
        w = bb[2] - bb[0]; x = (W - w) // 2 - bb[0]
        d.text((x + 3, yy - bb[1] + 4), txt, font=f, fill=(0, 0, 0, int(140 * a)))
        d.text((x, yy - bb[1]), txt, font=f, fill=col + (int(255 * a),))
        yy += bb[3] - bb[1] + 22
    img.paste(lay, (0, 0), lay)


def overlay(img, t):
    for t0, t1, kind, lines in TXT:
        if not (t0 <= t <= t1): continue
        a = min(ease((t - t0) / .35), ease((t1 - t) / .3)) if kind != 'cta' else ease((t - t0) / .4)
        off = int(36 * (1 - ease((t - t0) / .45)))
        if kind == 'top':
            shade(img, 'top', 620); draw_lines(img, lines, 170 + off, a)
        elif kind == 'bottom':
            shade(img, 'bottom', 760); draw_lines(img, lines, H - 210 + off, a, align_top=False)
        elif kind == 'list':
            shade(img, 'top', 900)
            lay = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(lay)
            d.text((W // 2, 150), 'KẾT NỐI NHANH', font=font('Inter-ExtraBold.otf', 44), fill=ORANGE + (int(255 * a),), anchor='mm')
            for i, (nm, v) in enumerate(lines):
                ai = ease((t - t0 - .25 * i) / .35) * a; y = 240 + i * 130 + int(30 * (1 - ai))
                d.rounded_rectangle((90, y, W - 90, y + 108), 26, fill=(10, 30, 56, int(200 * ai)), outline=(255, 154, 69, int(230 * ai)), width=3)
                d.ellipse((122, y + 36, 158, y + 72), fill=ORANGE + (int(255 * ai),))
                d.text((182, y + 54), nm, font=font('InterDisplay-Bold.otf', 46), fill=(255, 255, 255, int(255 * ai)), anchor='lm')
                d.text((W - 122, y + 54), v, font=font('Inter-SemiBold.otf', 40), fill=(255, 214, 170, int(255 * ai)), anchor='rm')
            img.paste(lay, (0, 0), lay)
        elif kind == 'cta':
            shade(img, 'bottom', 1100); shade(img, 'top', 420)
            lay = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(lay)
            A = lambda k: int(255 * a * k)
            d.text((W // 2, 190), 'MỞ BÁN', font=font('Inter-ExtraBold.otf', 56), fill=(255, 255, 255, A(1)), anchor='mm')
            d.text((W // 2, 300), '05/12/2026', font=font('InterDisplay-Black.otf', 132), fill=ORANGE + (A(1),), anchor='mm')
            a2 = ease((t - t0 - .6) / .4)
            d.text((W // 2, 1290), 'Bình luận “GIÁ”', font=font('InterDisplay-Black.otf', 84), fill=(255, 255, 255, int(255 * a2)), anchor='mm')
            d.text((W // 2, 1385), 'nhận bảng giá & giữ suất căn view biển đẹp', font=font('Inter-SemiBold.otf', 42), fill=(220, 232, 245, int(255 * a2)), anchor='mm')
            a3 = ease((t - t0 - 1.1) / .4); pulse = 1 + .045 * math.sin((t - t0) * 6.2)
            bw, bh = int(720 * pulse), int(132 * pulse); bx, by = (W - bw) // 2, 1500 - bh // 2 + 66
            d.rounded_rectangle((bx - 10, by - 10, bx + bw + 10, by + bh + 10), 76, fill=(255, 154, 69, int(70 * a3)))
            d.rounded_rectangle((bx, by, bx + bw, by + bh), 66, fill=(242, 107, 29, int(255 * a3)))
            d.text((W // 2, by + bh // 2), 'Nhắn Zalo 0904 567 009', font=font('InterDisplay-Black.otf', int(54 * pulse)), fill=(255, 255, 255, int(255 * a3)), anchor='mm')
            # mũi tên chỉ xuống phần bình luận
            ay = 1735 + int(14 * math.sin((t - t0) * 5))
            d.polygon([(W // 2 - 34, ay), (W // 2 + 34, ay), (W // 2, ay + 40)], fill=(255, 255, 255, int(220 * a3)))
            img.paste(lay, (0, 0), lay)
    # nhãn nhỏ suốt video
    d = ImageDraw.Draw(img); d.text((W - 36, H - 40), 'Phối cảnh minh họa', font=font('Inter-Medium.otf', 26), fill=(235, 240, 248), anchor='rm')


# ---------- nguồn hình ----------
FLYF = sorted(glob.glob(os.path.join(FLY, 'p*', 'f*.jpg')), key=lambda p: int(os.path.basename(p)[1:6]))
_pics = {}


def still(name, centre, zoom, t, D):
    if name not in _pics:
        im = Image.open(os.path.join(PICS, name)).convert('RGB'); iw, ih = im.size
        # cắt khung 9:16 quanh tâm, thu về 1.15 lần khung ra cho nhẹ
        cw = min(iw, ih * W / H); ch = cw * H / W
        x0 = min(max(0, centre[0] * iw - cw / 2), iw - cw); y0 = min(max(0, centre[1] * ih - ch / 2), ih - ch)
        _pics[name] = im.crop((int(x0), int(y0), int(x0 + cw), int(y0 + ch))).resize((int(W * 1.15), int(H * 1.15)), Image.LANCZOS)
    b = _pics[name]; z = zoom[0] + (zoom[1] - zoom[0]) * ease(t / D)
    cw, ch = b.width / 1.15 / z * 1.0, b.height / 1.15 / z * 1.0
    cw, ch = b.width / z, b.height / z
    x0, y0 = (b.width - cw) / 2, (b.height - ch) / 2
    return b.resize((W, H), Image.BICUBIC, box=(x0, y0, x0 + cw, y0 + ch))


def base(t):
    if t < FLY_LEN:
        i = min(int(round(t * FPS)), len(FLYF) - 1); return Image.open(FLYF[i]).convert('RGB').resize((W, H))
    for s0, D, name, c, z in STILLS:
        if s0 <= t < s0 + D + 1e-6: return still(name, c, z, t - s0, D)
    s0, D, name, c, z = STILLS[-1]; return still(name, c, z, D, D)


def frame(t):
    img = base(t)
    for c in CUTS:      # chuyển cảnh mờ dần
        if c - XF / 2 <= t < c + XF / 2:
            k = ease((t - (c - XF / 2)) / XF)
            prev = base(c - 1 / FPS); nxt = base(c + 1e-3)
            img = Image.blend(prev, nxt, k) if t >= c else Image.blend(prev, nxt, k)
    overlay(img, t)
    return img


if __name__ == '__main__':
    tmp = tempfile.mkdtemp()
    n = int(TOTAL * FPS)
    only = os.environ.get('ONLY')
    idx = [int(float(x) * FPS) for x in only.split(',')] if only else range(n)
    for i in idx:
        frame(i / FPS).save(os.path.join(tmp, 'g%05d.jpg' % i), quality=92)
    if only:
        for i in idx: shutil.copy(os.path.join(tmp, 'g%05d.jpg' % i), OUT.replace('.mp4', '-%05d.jpg' % i))
        sys.exit()
    af = 'afade=t=in:d=1.2,afade=t=out:st=%.2f:d=2.5,volume=0.9' % (TOTAL - 2.5)
    subprocess.run(['ffmpeg', '-y', '-v', 'error', '-framerate', str(FPS), '-i', os.path.join(tmp, 'g%05d.jpg'), '-i', MUSIC,
                    '-filter_complex', '[1:a]atrim=0:%.2f,%s[a]' % (TOTAL, af), '-map', '0:v', '-map', '[a]',
                    '-c:v', 'libx264', '-preset', 'slow', '-crf', '18', '-pix_fmt', 'yuv420p', '-c:a', 'aac', '-b:a', '160k',
                    '-movflags', '+faststart', '-shortest', OUT], check=True)
    shutil.rmtree(tmp); print('xong', OUT)
