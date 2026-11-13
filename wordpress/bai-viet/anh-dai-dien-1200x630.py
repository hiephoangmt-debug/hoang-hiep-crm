"""Ảnh đại diện bài viết khổ 1200×630 (đúng khung thẻ bài trên web + Facebook, không bị cắt), nền là ảnh dự án.
Dùng: python3 bai-viet/anh-dai-dien-1200x630.py spec.json <thư mục img plugin>
spec: [{slug, out (đường dẫn trong img/), bg (ảnh nền trong img/), tag, title, cap}]"""
import sys, json, importlib.util
from PIL import Image, ImageDraw, ImageFont, ImageOps
J, IMG = sys.argv[1], sys.argv[2].rstrip('/')
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
SER = '/usr/share/fonts/truetype/liberation/LiberationSerif-Bold.ttf'; SANS = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; SANSB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
W, H = 1200, 630; GOLD = (232, 176, 74); TW = 660
def wrap(d, text, font, maxw):
    lines, line = [], ''
    for w in text.split():
        t = (line + ' ' + w).strip()
        if d.textlength(t, font=font) > maxw and line: lines.append(line); line = w
        else: line = t
    return lines + [line]
for s in json.load(open(J)):
    src = Image.open(f"{IMG}/{s['bg']}").convert('RGB')
    src = src.crop((0, 0, src.width, int(src.height * 0.86)))  # bỏ dải dưới (khung liên hệ đã đóng trên ảnh gốc) – không lặp hai khung
    im = ImageOps.fit(src, (W, H), Image.LANCZOS, centering=(0.62, 0.5)).convert('RGBA')
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for x in range(W):
        a = 228 if x < 560 else int(228 * max(0, 1 - (x - 560) / 420))
        g.line([x, 0, x, H], fill=(8, 20, 34, a))
    im = Image.alpha_composite(im, ov)
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)  # lớp riêng: tối dần phía dưới (không đè lớp bên trái)
    for y in range(H - 200, H):
        g.line([0, y, W, y], fill=(8, 20, 34, int(120 * ((y - H + 200) / 200) ** 2)))
    im = Image.alpha_composite(im, ov).convert('RGB'); d = ImageDraw.Draw(im)
    tag = s['tag']; tf = ImageFont.truetype(SANSB, 19)
    while d.textlength(tag, font=tf) > TW and ' · ' in tag: tag = tag.rsplit(' · ', 1)[0]
    title = s['title'].strip()
    for fs in range(58, 33, -2):
        f = ImageFont.truetype(SER, fs); lines = wrap(d, title, f, TW)
        if len(lines) <= 4: break
    if len(lines) > 5:
        lines = lines[:5]; lines[-1] = lines[-1].rstrip(' ,:–-') + '…'
    lh = int(fs * 1.16); block = 34 + len(lines) * lh
    y0 = max(60, (H - 70 - block) // 2)
    d.rectangle([56, y0, 60, y0 + block], fill=GOLD)
    d.text((80, y0), tag, font=tf, fill=GOLD)
    for i, l in enumerate(lines): d.text((78, y0 + 34 + i * lh), l, font=f, fill='white')
    d.text((80, 580), s['cap'], font=ImageFont.truetype(SANS, 15), fill=(205, 214, 226))
    p = s["out"] if s["out"].startswith("/") else f"{IMG}/{s['out']}"; im.save(p, quality=82, optimize=True, progressive=True)
    dd.stamp(p, tile=False)
    print(s['slug'])
