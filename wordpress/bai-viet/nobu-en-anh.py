"""Ảnh đại diện bài tiếng Anh Nobu (13/11/2026): nền là phối cảnh dự án (chủ đầu tư), khổ 1200×630 đúng khung thẻ bài + Facebook – không bị cắt."""
import sys, importlib.util
from PIL import Image, ImageDraw, ImageFont, ImageOps
O = sys.argv[1]; SRC = sys.argv[2]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
SER = '/usr/share/fonts/truetype/liberation/LiberationSerif-Bold.ttf'; SANS = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; SANSB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
W, H = 1200, 630; GOLD = (232, 176, 74)
CARDS = [
 ('nobu-residences-da-nang-buyers-guide', 'nobu-da-nang-phoi-canh-thap-ven-bien-my-khe.jpg', (0.62, 0.45), "BUYER'S GUIDE", ['Nobu Residences', 'Da Nang'], 'Branded residences on My Khe Beach · 43 storeys · 2027'),
 ('branded-residences-da-nang-foreign-buyers', 'nobu-da-nang-sky-lounge-ho-boi-hoang-hon.jpg', (0.5, 0.5), 'INSIGHT · DA NANG PROPERTY', ['Branded Residences', 'in Da Nang'], 'What international buyers should know'),
]
for name, src, centre, tag, lines, sub in CARDS:
    im = ImageOps.fit(Image.open(f'{SRC}/{src}').convert('RGB'), (W, H), Image.LANCZOS, centering=centre).convert('RGBA')
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for x in range(W):  # nền tối dần sang trái để chữ rõ, phần phải giữ ảnh dự án
        a = 225 if x < 420 else int(225 * max(0, 1 - (x - 420) / 480))
        g.line([x, 0, x, H], fill=(8, 20, 34, a))
    im = Image.alpha_composite(im, ov).convert('RGB'); d = ImageDraw.Draw(im)
    d.rectangle([56, 150, 60, 420], fill=GOLD)
    d.text((80, 150), tag, font=ImageFont.truetype(SANSB, 22), fill=GOLD)
    fs = 74
    while max(d.textlength(l, font=ImageFont.truetype(SER, fs)) for l in lines) > 620: fs -= 2
    for i, l in enumerate(lines): d.text((78, 192 + i * (fs + 8)), l, font=ImageFont.truetype(SER, fs), fill='white')
    d.text((80, 200 + len(lines) * (fs + 8) + 14), sub, font=ImageFont.truetype(SANS, 24), fill=(225, 232, 240))
    d.text((80, 572), "Artist's impression – developer", font=ImageFont.truetype(SANS, 15), fill=(200, 210, 222))
    p = f'{O}/{name}.jpg'; im.save(p, quality=90)
    print(name, dd.stamp(p, tile=False))
