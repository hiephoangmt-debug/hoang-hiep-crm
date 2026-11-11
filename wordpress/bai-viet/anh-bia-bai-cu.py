"""Ảnh đại diện tự vẽ cho các bài cũ (tuần 01 – 14) chưa có ảnh và không gắn dự án: nền navy, nhóm bài, tiêu đề + nhãn liên hệ.
Dùng: python3 bai-viet/anh-bia-bai-cu.py bai-viet/anh-bia-bai-cu.json <thư mục ra>"""
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
for slug, cat, title in json.load(open(J)):
    base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
    for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
    for k in range(4):
        g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
    im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
    d.rectangle([0, 0, W, 8], fill=GOLD)
    d.text((64, 64), (cat or 'Bất động sản').upper() + ' · ĐÀ NẴNG', font=f(24, True), fill=GOLD)
    main, _, sub = title.partition(':')
    ts = 60
    while True:
        lines = wrap(d, main.strip(), f(ts, True), W - 128)
        if len(lines) <= 3 or ts <= 40: break
        ts -= 4
    y = 120
    for l in lines[:3]: d.text((64, y), l, font=f(ts, True), fill='white'); y += int(ts * 1.25)
    d.rectangle([64, y + 18, 184, y + 22], fill=GOLD)
    if sub.strip():
        for l in wrap(d, sub.strip(), f(30), W - 128)[:3]: d.text((64, y + 44), l, font=f(30), fill=(190, 210, 230)); y += 42
    p = f'{O}/{slug}.jpg'; im.save(p, quality=90)
    print(slug, dd.stamp(p, tile=False))
