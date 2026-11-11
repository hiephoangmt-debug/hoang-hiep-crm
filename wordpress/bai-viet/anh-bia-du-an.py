"""Ảnh đại diện tự vẽ cho trang dự án chưa có ảnh (không dùng ảnh quảng cáo trang khác): nền navy, loại hình, tên dự án, khu vực + nhãn liên hệ.
Dùng: python3 bai-viet/anh-bia-du-an.py bai-viet/anh-bia-du-an.json <thư mục ra>   (mỗi phần tử: [slug, tên, loại hình, khu vực])"""
import sys, json, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
J, O = sys.argv[1], sys.argv[2]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
def wrap(d, text, font, maxw):
    lines, line = [], ''
    for w in text.split():
        t = (line + ' ' + w).strip()
        if d.textlength(t, font=font) > maxw and line: lines.append(line); line = w
        else: line = t
    return lines + [line]
for slug, name, typ, area in json.load(open(J)):
    base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
    for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
    # Đường chân trời tòa nhà cách điệu bên phải
    import random; random.seed(slug)
    x = 640
    while x < W - 20:
        w_ = random.randint(40, 80); h_ = random.randint(120, 330)
        g.rectangle([x, H - 60 - h_, x + w_, H - 60], fill=(255, 255, 255, 18), outline=(232, 176, 74, 60))
        for yy in range(H - 50 - h_, H - 70, 22):
            for xx in range(x + 8, x + w_ - 8, 16): g.rectangle([xx, yy, xx + 6, yy + 9], fill=(232, 176, 74, 38))
        x += w_ + random.randint(6, 18)
    for k in range(4):
        g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
    im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
    d.rectangle([0, 0, W, 8], fill=GOLD)
    tag = 'DỰ ÁN · ' + ((area + ', ') if area else '') + ('HỘI AN' if 'Hội An' in (area + name) else 'ĐÀ NẴNG')
    d.text((64, 70), tag.upper().replace('ĐÀ NẴNG, ĐÀ NẴNG', 'ĐÀ NẴNG'), font=f(24, True), fill=GOLD)
    ts = 62
    while True:
        lines = wrap(d, name, f(ts, True), 640)
        if len(lines) <= 3 or ts <= 38: break
        ts -= 4
    y = 122
    for l in lines[:3]: d.text((64, y), l, font=f(ts, True), fill='white'); y += int(ts * 1.25)
    d.rectangle([64, y + 18, 184, y + 22], fill=GOLD); y += 46
    for t in [t.strip() for t in typ.split(',') if t.strip()][:2]:
        tw = d.textlength(t, font=f(22)) + 32
        d.rounded_rectangle([64, y, 64 + tw, y + 40], 20, outline=GOLD, width=2)
        d.text((80, y + 8), t, font=f(22), fill=(220, 230, 240)); y += 52
    p = f'{O}/{slug}.jpg'; im.save(p, quality=88)
    dd.stamp(p, tile=False)
