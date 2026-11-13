"""Ảnh đại diện bài viết 1200×630 kiểu tạp chí (mẫu anh Hiệp gửi 13/11/2026): ảnh dự án nền mờ dần sang trắng,
chữ viết tay (nhóm bài), tiêu đề in hoa cam đậm, dòng phụ xanh navy, 2 ảnh nhỏ viền trắng xếp nghiêng bên phải.
Khổ đúng khung thẻ bài web + Facebook nên không bị cắt. Font: bai-viet/fonts (Be Vietnam Pro, Dancing Script – OFL).
Dùng: python3 bai-viet/anh-dai-dien-1200x630.py spec.json <thư mục img plugin>"""
import sys, json, os
from PIL import Image, ImageDraw, ImageFont, ImageOps, ImageFilter, ImageEnhance
J, IMG = sys.argv[1], sys.argv[2].rstrip('/')
FD = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'fonts')
SCRIPT = ImageFont.truetype(f'{FD}/DancingScript[wght].ttf', 76); SCRIPT.set_variation_by_axes([700])
XB = f'{FD}/BeVietnamPro-ExtraBold.ttf'; SB = f'{FD}/BeVietnamPro-SemiBold.ttf'; MD = f'{FD}/BeVietnamPro-Medium.ttf'
W, H = 1200, 630; ORANGE = (226, 96, 24); GOLD = (196, 146, 62); NAVY = (14, 34, 58)
def wrap(d, words, font, maxw):
    lines, line = [], ''
    for w in words:
        t = (line + ' ' + w).strip()
        if d.textlength(t, font=font) > maxw and line: lines.append(line); line = w
        else: line = t
    return lines + ([line] if line else [])
def load(p, size, c=(0.5, 0.5)):
    src = Image.open(f'{IMG}/{p}').convert('RGB'); src = src.crop((0, 0, src.width, int(src.height * 0.86)))
    return ImageOps.fit(src, size, Image.LANCZOS, centering=c)
def card(p, size, angle):
    im = load(p, size); b = 7
    c = Image.new('RGBA', (size[0] + 2 * b, size[1] + 2 * b), (255, 255, 255, 255)); c.paste(im, (b, b))
    m = Image.new('L', c.size, 0); ImageDraw.Draw(m).rounded_rectangle([0, 0, c.size[0] - 1, c.size[1] - 1], 14, fill=255); c.putalpha(m)
    c = c.rotate(angle, expand=True, resample=Image.BICUBIC)
    sh = Image.new('RGBA', (c.size[0] + 40, c.size[1] + 40), (0, 0, 0, 0)); sh.paste((0, 0, 0, 90), (20, 26), c.split()[3]); sh = sh.filter(ImageFilter.GaussianBlur(10))
    sh.alpha_composite(c, (20, 20)); return sh
for s in json.load(open(J)):
    bg = load(s['bg'], (W, H), (0.6, 0.45))
    bg = ImageEnhance.Color(bg).enhance(0.9); bg = Image.blend(bg, Image.new('RGB', (W, H), (236, 241, 246)), 0.18).convert('RGBA')
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for y in range(H):  # trắng dần từ giữa xuống đáy, giữ trời + toà nhà phía trên
        t = max(0.0, (y - 170) / 230); g.line([0, y, W, y], fill=(255, 255, 255, int(250 * min(1, t) ** 1.2)))
    im = Image.alpha_composite(bg, ov)
    ins = s.get('ins') or []
    if len(ins) >= 2:
        im.alpha_composite(card(ins[0], (280, 184), 4), (585, 96))
        im.alpha_composite(card(ins[1], (300, 200), -3), (800, 58))
    elif ins:
        im.alpha_composite(card(ins[0], (320, 214), -3), (790, 60))
    d = ImageDraw.Draw(im)
    # nhãn liên hệ
    pf = ImageFont.truetype(SB, 16); pt = 'HOÀNG HIỆP  ·  0904 567 009  ·  hiephoangmt.com'; pw = d.textlength(pt, font=pf)
    d.rounded_rectangle([36, 30, 36 + pw + 32, 66], 18, fill=NAVY + (230,)); d.text((52, 37), pt, font=pf, fill='white')
    # tách tiêu đề: phần chính in hoa (≤ 2 dòng), phần còn lại làm dòng phụ
    title = s['title'].strip(); main, sep, sub = title.partition(': ')
    if not sep: main, sub = title, ''
    words = main.upper().split()
    for fs in range(56, 33, -2):
        f = ImageFont.truetype(XB, fs); L = wrap(d, words, f, W - 100)
        if len(L) <= 2: break
    if len(L) > 2:  # quá dài: giữ 2 dòng in hoa, phần dư chuyển xuống dòng phụ
        keep = len(' '.join(L[:2]).split()); sub = (' '.join(main.split()[keep:]) + (': ' + sub if sub else '')).strip(); L = L[:2]
    sf = ImageFont.truetype(SB, 28); SL = wrap(d, sub.split(), sf, W - 100) if sub else []
    if len(SL) > 2: SL = SL[:2]; SL[-1] = SL[-1].rstrip(' ,:;–-') + '…'
    lh = int(fs * 1.18); y = H - 34 - len(SL) * 38 - (10 if SL else 0) - len(L) * lh
    cat = (s.get('cat') or 'Bất động sản').strip(); cat = cat[0].upper() + cat[1:]
    d.text((44, y - 92), cat, font=SCRIPT, fill=GOLD)
    for i, l in enumerate(L):
        d.text((50 + 2, y + i * lh + 3), l, font=f, fill=(255, 255, 255))
        d.text((50, y + i * lh), l, font=f, fill=ORANGE)
    y += len(L) * lh + 10
    for i, l in enumerate(SL): d.text((50, y + i * 38), l, font=sf, fill=NAVY)
    cf = ImageFont.truetype(MD, 13); cw = d.textlength(s['cap'], font=cf)
    d.text((W - 24 - cw, H - 24), s['cap'], font=cf, fill=(120, 132, 146))
    p = s['out'] if s['out'].startswith('/') else f"{IMG}/{s['out']}"
    im.convert('RGB').save(p, quality=84, optimize=True, progressive=True)
    print(s['slug'])
