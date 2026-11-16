"""Ảnh tin tức kiểu thống nhất (mẫu anh Hiệp gửi 15/11/2026 – thẻ "Hoàn thành sổ hồng FPT Plaza 3"):
nền trắng xanh nhạt, dòng HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG giãn chữ, nhóm tin chữ có chân in hoa,
tiêu đề chữ có chân navy, tên dự án / ý chính cỡ lớn màu cam, dòng viết tay cam, câu tóm tắt đậm,
hàng 3 con số có vạch ngăn, ảnh thật / phối cảnh mờ dần vào nền, thẻ liên hệ có ảnh chân dung ở đáy.

Hai khổ: web 1200×630 (ảnh đại diện bài, xem trước Facebook) và fb 1080×1350 (bài đăng Facebook dọc).\nThêm khổ 4x3 (1200×900, chế độ '4x3', trường out_43) cho ảnh thẻ tin Mua bán / Cho thuê.
Dùng: python3 bai-viet/the-tin-tuc.py spec.json <thư mục img plugin> [web|fb|ca-hai]
spec.json: danh sách {slug, out, bg, title, tag, cap, [cat, head, big, script, lead, stats:[[số, nhãn]×≤3], src, out_fb]}.
Thiếu head/big/script/lead thì tự tách từ tiêu đề (tên dự án trong tag → chữ cam lớn).
Font: bai-viet/fonts (Cormorant Garamond, Be Vietnam Pro, Dancing Script – OFL)."""
import sys, json, os, re
from PIL import Image, ImageDraw, ImageFont, ImageOps, ImageEnhance

J, IMG = sys.argv[1], sys.argv[2].rstrip('/')
MODE = sys.argv[3] if len(sys.argv) > 3 else 'web'
HERE = os.path.dirname(os.path.abspath(__file__)); FD = f'{HERE}/fonts'
AVA = os.path.normpath(f'{HERE}/../wp-content/themes/hoanghiep/assets/img/hoang-hiep-avatar.jpg')
NAVY = (22, 40, 66); BLUE = (30, 70, 112); ORANGE = (214, 104, 40); INK = (20, 24, 32); GREY = (110, 122, 138)
BG_TOP = (238, 244, 250); BG_MID = (246, 249, 252)


def serif(size, wght=500):
    f = ImageFont.truetype(f'{FD}/CormorantGaramond[wght].ttf', size); f.set_variation_by_axes([wght]); return f


def script(size):
    f = ImageFont.truetype(f'{FD}/DancingScript[wght].ttf', size); f.set_variation_by_axes([600]); return f


def sans(size, w='SemiBold'):
    return ImageFont.truetype(f'{FD}/BeVietnamPro-{w}.ttf', size)


def spaced(d, xy, text, font, fill, track, anchor='l'):
    """Chữ giãn khoảng; anchor l = trái, m = giữa."""
    w = sum(d.textlength(c, font=font) for c in text) + track * (len(text) - 1)
    x, y = xy
    if anchor == 'm': x -= w / 2
    for c in text:
        d.text((x, y), c, font=font, fill=fill, features=['lnum']); x += d.textlength(c, font=font) + track
    return w


def wrap(d, text, font, maxw):
    lines, line = [], ''
    for w in text.split():
        t = (line + ' ' + w).strip()
        if d.textlength(t, font=font) > maxw and line: lines.append(line); line = w
        else: line = t
    return lines + ([line] if line else [])


def fit(d, text, mk, maxw, top, low, lines=1):
    for s in range(top, low - 1, -2):
        f = mk(s); L = wrap(d, text, f, maxw)
        if len(L) <= lines: return f, L
    f = mk(low); L = wrap(d, text, f, maxw)
    if len(L) > lines: L = L[:lines]; L[-1] = L[-1].rstrip(' ,:;–-') + '…'
    return f, L


def parts(s):
    """head / big / script / lead: lấy từ spec, thiếu thì tách từ tiêu đề."""
    title = re.sub(r'\s+', ' ', s['title']).strip()
    m = re.search(r'(: |\? )', title)
    main, lead = (title[:m.start() + (1 if m.group(1) == '? ' else 0)], title[m.end():]) if m else (title, '')
    proj = ''
    tag = s.get('tag') or ''
    if '·' in tag:
        name = tag.split('·', 1)[1].strip()
        for cand in (name, re.sub(r'\s+ĐÀ NẴNG$', '', name)):
            i = main.lower().find(cand.lower())
            if cand and i >= 0: proj = main[i:i + len(cand)]; break
    head = big = scr = ''
    if proj:
        i = main.find(proj); before = main[:i].rstrip(); after = main[i + len(proj):].lstrip()
        if before.endswith('(') and after.startswith(')'): before, after = before[:-1], after[1:]
        before = before.strip(' ,:–-('); after = after.strip(' ,:–-)')
        big = proj
        head = before if before else ''
        scr = after
    else:
        big = main
    head = s.get('head', head) or (s.get('cat') or '')
    if head: head = head[0].upper() + head[1:]
    big = s.get('big', big); scr = s.get('script', scr); lead = s.get('lead', lead)
    if scr and len(scr) > 46: lead = (scr + (' – ' + lead if lead else '')).strip(); scr = ''
    return head, big, scr, lead


def short_tag(s):
    t = (s.get('tag') or s.get('cat') or 'TIN TỨC').upper()
    return re.sub(r'\s+ĐÀ NẴNG$', '', t) if len(t) > 38 else t


def load_bg(p, size, c=(0.5, 0.5)):
    src = Image.open(f'{IMG}/{p}').convert('RGB')
    src = src.crop((0, 0, src.width, int(src.height * 0.9)))  # bỏ dải đáy (thường có chữ / nhãn của ảnh gốc)
    im = ImageOps.fit(src, size, Image.LANCZOS, centering=c)
    return ImageEnhance.Color(im).enhance(0.95)


def contact(im, box, cap, scale=1.0):
    """Thẻ liên hệ: nền navy bo góc, ảnh chân dung tròn viền vàng, tên + Zalo, ghi chú nguồn bên phải."""
    x0, y0, x1, y1 = box; h = y1 - y0
    ov = Image.new('RGBA', im.size, (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    g.rounded_rectangle(box, int(22 * scale), fill=(24, 40, 70, 232))
    im.alpha_composite(ov)
    a = int(h * 0.74); ax, ay = x0 + int(h * 0.16), y0 + (h - a) // 2
    av = ImageOps.fit(Image.open(AVA).convert('RGB'), (a, a), Image.LANCZOS)
    mk = Image.new('L', (a, a), 0); ImageDraw.Draw(mk).ellipse((0, 0, a - 1, a - 1), fill=255)
    d = ImageDraw.Draw(im); b = max(2, int(3 * scale))
    d.ellipse((ax - b, ay - b, ax + a + b, ay + a + b), fill=(228, 186, 110))
    im.paste(av, (ax, ay), mk)
    tx = ax + a + int(22 * scale)
    d.text((tx, y0 + h * 0.18), 'Hoàng Hiệp', font=sans(int(h * 0.30), 'ExtraBold'), fill='white')
    d.text((tx, y0 + h * 0.56), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=sans(int(h * 0.20), 'SemiBold'), fill=(232, 190, 112))
    if cap:
        cf = sans(max(11, int(h * 0.13)), 'Medium'); maxw = (x1 - tx) - d.textlength('BĐS Đà Nẵng · Zalo 0904 567 009', font=sans(int(h * 0.20))) - 60 * scale
        L = wrap(d, cap, cf, max(140, maxw))[:3]; lh = cf.size * 1.3; yy = y0 + (h - lh * len(L)) / 2
        for l in L:
            d.text((x1 - 22 * scale - d.textlength(l, font=cf), yy), l, font=cf, fill=(214, 222, 236)); yy += lh


def stats_row(d, xs, y, stats, nf, lf, maxw):
    n = len(stats); cw = (xs[1] - xs[0]) / n
    for i, (num, lab) in enumerate(stats):
        cx = xs[0] + cw * i + cw / 2
        f = nf; s = f.size
        while d.textlength(num, font=f) > cw - 20 and s > 20: s -= 2; f = serif(s, 600)
        d.text((cx, y), num, font=f, fill=ORANGE, anchor='ma', features=['lnum'])
        L = wrap(d, lab.replace('→', '–'), lf, cw - 16)[:2]
        ly = y + nf.size * 0.98
        for j, l in enumerate(L): d.text((cx, ly + j * lf.size * 1.25), l, font=lf, fill=INK, anchor='ma')
        if i: d.line([(xs[0] + cw * i, y + 4), (xs[0] + cw * i, ly + lf.size * 1.3)], fill=(196, 206, 220), width=2)


def web(s):
    W, H = 1200, 630
    im = Image.new('RGBA', (W, H), BG_MID + (255,))
    ph = load_bg(s['bg'], (700, H), (0.55, 0.45)).convert('RGBA')
    m = Image.new('L', ph.size, 0); g = ImageDraw.Draw(m)
    for x in range(ph.size[0]):  # mờ dần từ trái sang
        t = min(1.0, max(0.0, (x - 30) / 300)); g.line([(x, 0), (x, H)], fill=int(255 * t ** 1.4))
    im.paste(ph, (W - 700, 0), m)
    top = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(top)
    for y in range(150):  # trời sáng phía trên cho chữ đầu dễ đọc
        g.line([(0, y), (W, y)], fill=BG_TOP + (int(150 * (1 - y / 150)),))
    im.alpha_composite(top)
    d = ImageDraw.Draw(im)
    head, big, scr, lead = parts(s)
    X, MW = 56, 640
    spaced(d, (X, 34), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', sans(17, 'ExtraBold'), BLUE, 4)
    tag = short_tag(s)
    tf = serif(22, 600)
    while sum(d.textlength(c, font=tf) for c in tag) + 4 * len(tag) > MW and tf.size > 15: tf = serif(tf.size - 1, 600)
    spaced(d, (X, 64), tag, tf, INK, 4)
    layer = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d0, d = d, ImageDraw.Draw(layer)
    y = 106
    if head:
        hf, HL = fit(d, head, lambda z: serif(z, 500), MW, 46, 30, 1)
        d.text((X, y), HL[0], font=hf, fill=NAVY, features=['lnum']); y += int(hf.size * 1.12)
    bf, BL = fit(d, big, lambda z: serif(z, 600), MW, 92 if len(big) < 18 else 70, 44, 2)
    for l in BL:
        d.text((X + 2, y + 2), l, font=bf, fill=(255, 255, 255), features=['lnum']); d.text((X, y), l, font=bf, fill=ORANGE, features=['lnum']); y += int(bf.size * 0.98)
    y += int(bf.size * 0.2)
    if scr:
        sf, SL = fit(d, scr, script, MW - 40, 50, 30, 1)
        d.text((X + 120 if len(BL) == 1 and d.textlength(BL[0], font=bf) > 360 else X + 10, y - int(bf.size * 0.28)), SL[0], font=sf, fill=ORANGE); y += int(sf.size * 1.15)
    y += 6
    if lead:
        lf, LL = fit(d, lead, lambda z: sans(z, 'ExtraBold'), MW, 30, 20, 2)
        for l in LL: d.text((X, y), l, font=lf, fill=INK); y += int(lf.size * 1.32)
    st = s.get('stats') or []
    if st and y < 400:
        stats_row(d, (X - 10, X + MW), y + 16, st[:3], serif(52, 600), sans(18, 'Medium'), MW); y += 110
    dy = max(0, int((H - 128 - y) / 2))
    im.alpha_composite(layer, (0, dy))
    contact(im, (32, H - 108, W - 32, H - 22), s.get('src') or s.get('cap', ''))
    return im


def fb(s):
    W, H = 1080, 1350
    im = Image.new('RGBA', (W, H), BG_MID + (255,))
    ph = load_bg(s['bg'], (W, 760), (0.5, 0.5)).convert('RGBA')
    m = Image.new('L', ph.size, 0); g = ImageDraw.Draw(m)
    for y in range(ph.size[1]):  # mờ dần lên trên
        t = min(1.0, max(0.0, (y - 30) / 300)); g.line([(0, y), (W, y)], fill=int(255 * t ** 1.2))
    im.paste(ph, (0, H - 760), m)
    top = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(top)
    for y in range(260): g.line([(0, y), (W, y)], fill=BG_TOP + (int(160 * (1 - y / 260)),))
    im.alpha_composite(top)
    d = ImageDraw.Draw(im)
    head, big, scr, lead = parts(s)
    C, MW = W / 2, W - 120
    spaced(d, (C, 46), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', sans(30, 'ExtraBold'), BLUE, 6, 'm')
    tag = short_tag(s); tf = serif(36, 600)
    while sum(d.textlength(c, font=tf) for c in tag) + 6 * len(tag) > MW and tf.size > 22: tf = serif(tf.size - 1, 600)
    spaced(d, (C, 100), tag, tf, INK, 6, 'm')
    y = 168
    if head:
        hf, HL = fit(d, head, lambda z: serif(z, 500), MW, 74, 46, 1)
        d.text((C, y), HL[0], font=hf, fill=NAVY, anchor='ma', features=['lnum']); y += int(hf.size * 1.08)
    bf, BL = fit(d, big, lambda z: serif(z, 600), MW, 132 if len(big) < 16 else 104, 60, 2)
    for l in BL:
        d.text((C + 3, y + 3), l, font=bf, fill=(255, 255, 255), anchor='ma', features=['lnum']); d.text((C, y), l, font=bf, fill=ORANGE, anchor='ma', features=['lnum']); y += int(bf.size * 0.98)
    y += int(bf.size * 0.2)
    if scr:
        sf, SL = fit(d, scr, script, MW - 80, 78, 44, 1)
        d.text((C + 120, y - int(bf.size * 0.3)), SL[0], font=sf, fill=ORANGE, anchor='ma'); y += int(sf.size * 1.15)
    y += 14
    if lead:
        lf, LL = fit(d, lead, lambda z: sans(z, 'ExtraBold'), MW, 40, 28, 2)
        for l in LL: d.text((C, y), l, font=lf, fill=INK, anchor='ma'); y += int(lf.size * 1.3)
    st = s.get('stats') or []
    if st:
        stats_row(d, (60, W - 60), y + 26, st[:3], serif(72, 600), sans(26, 'Medium'), MW)
    contact(im, (36, H - 176, W - 36, H - 40), s.get('src') or s.get('cap', ''), 1.4)
    return im


def t43(s):
    """Khổ 4:3 (1200×900) cho ảnh thẻ tin Mua bán / Cho thuê – bố cục như bản dọc, chữ gọn hơn."""
    W, H = 1200, 900
    im = Image.new('RGBA', (W, H), BG_MID + (255,))
    ph = load_bg(s['bg'], (W, 470), (0.5, 0.5)).convert('RGBA')
    m = Image.new('L', ph.size, 0); g = ImageDraw.Draw(m)
    for y in range(ph.size[1]):
        t = min(1.0, max(0.0, (y - 20) / 200)); g.line([(0, y), (W, y)], fill=int(255 * t ** 1.2))
    im.paste(ph, (0, H - 470), m)
    top = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(top)
    for y in range(180): g.line([(0, y), (W, y)], fill=BG_TOP + (int(160 * (1 - y / 180)),))
    im.alpha_composite(top)
    d = ImageDraw.Draw(im)
    head, big, scr, lead = parts(s)
    C, MW = W / 2, W - 140
    spaced(d, (C, 30), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', sans(24, 'ExtraBold'), BLUE, 5, 'm')
    tag = short_tag(s); tf = serif(28, 600)
    while sum(d.textlength(c, font=tf) for c in tag) + 5 * len(tag) > MW and tf.size > 18: tf = serif(tf.size - 1, 600)
    spaced(d, (C, 70), tag, tf, INK, 5, 'm')
    y = 114
    if head:
        hf, HL = fit(d, head, lambda z: serif(z, 500), MW, 56, 36, 1)
        d.text((C, y), HL[0], font=hf, fill=NAVY, anchor='ma', features=['lnum']); y += int(hf.size * 1.08)
    bf, BL = fit(d, big, lambda z: serif(z, 600), MW, 104 if len(big) < 16 else 84, 52, 1)
    for l in BL:
        d.text((C + 3, y + 3), l, font=bf, fill=(255, 255, 255), anchor='ma', features=['lnum']); d.text((C, y), l, font=bf, fill=ORANGE, anchor='ma', features=['lnum']); y += int(bf.size * 0.98)
    y += int(bf.size * 0.2)
    if scr:
        sf, SL = fit(d, scr, script, MW - 80, 60, 36, 1)
        d.text((C + 120, y - int(bf.size * 0.3)), SL[0], font=sf, fill=ORANGE, anchor='ma'); y += int(sf.size * 1.1)
    y += 6
    if lead:
        lf, LL = fit(d, lead, lambda z: sans(z, 'ExtraBold'), MW, 32, 22, 1)
        for l in LL: d.text((C, y), l, font=lf, fill=INK, anchor='ma'); y += int(lf.size * 1.3)
    st = s.get('stats') or []
    if st:
        stats_row(d, (70, W - 70), y + 18, st[:3], serif(56, 600), sans(22, 'Medium'), MW)
    contact(im, (32, H - 130, W - 32, H - 28), s.get('src') or s.get('cap', ''), 1.05)
    return im


for s in json.load(open(J)):
    if MODE in ('web', 'ca-hai'):
        p = s['out'] if s['out'].startswith('/') else (f"{HERE}/../{s['out']}" if s['out'].startswith('tu-dong/') else f"{IMG}/{s['out']}")
        web(s).convert('RGB').save(p, quality=86, optimize=True, progressive=True)
    if MODE in ('fb', 'ca-hai'):
        p = s.get('out_fb') or re.sub(r'\.jpg$', '-fb.jpg', s['out'])
        p = p if p.startswith('/') else (f"{HERE}/../{p}" if p.startswith('tu-dong/') else f'{IMG}/{p}')
        fb(s).convert('RGB').save(p, quality=88, optimize=True, progressive=True)
    if MODE == '4x3':
        p = s.get('out_43') or re.sub(r'\.jpg$', '-4x3.jpg', s['out'])
        p = p if p.startswith('/') else (f"{HERE}/../{p}" if p.startswith('tu-dong/') else f'{IMG}/{p}')
        t43(s).convert('RGB').save(p, quality=86, optimize=True, progressive=True)
    print(s['slug'])
