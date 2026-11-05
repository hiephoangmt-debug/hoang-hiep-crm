"""Ảnh bìa tự vẽ cho trang dự án Hoiana Shores Golf Villas, Hoiana Residences (chưa có ảnh chủ đầu tư)."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, LINE = '#d8b16a', '#f7f1e3', '#0f2240', '#2b4a7c'
CARDS = {
    'hoiana-shores-golf-villas': ('Hoiana Shores Golf Villas', 'Biệt thự sân golf · Hoiana Resort & Golf',
        [('Số lượng', '88 biệt thự'), ('Phòng ngủ', '3 – 5 PN'), ('Diện tích đất', '710 – 1.500 m²'), ('Bên sân golf', 'Hoiana Shores 18 hố')]),
    'hoiana-residences': ('Hoiana Residences', 'Căn hộ khách sạn · Hoiana Resort & Golf',
        [('Quy mô', '2 tòa · 270 căn'), ('Loại căn', 'Studio – 3 PN'), ('Vận hành', 'New World – Rosewood'), ('Vị trí', 'Duy Hải, Nam Hội An')]),
}
for key, (name, sub, rows) in CARDS.items():
    W, H = 1600, 900
    im = Image.new('RGB', (W, H), NAVY)
    d = ImageDraw.Draw(im)
    d.text((70, 60), 'HOIANA RESORT & GOLF · NAM HỘI AN', font=f(30, True), fill=GOLD)
    d.text((70, 110), name, font=f(74, True), fill=CREAM)
    d.text((70, 210), sub, font=f(34), fill=CREAM)
    y = 320
    for label, val in rows:
        d.line([(70, y - 16), (1530, y - 16)], fill=LINE, width=2)
        d.text((70, y), label, font=f(42), fill=CREAM)
        tw = d.textlength(val, font=f(46, True))
        d.text((1530 - tw, y - 2), val, font=f(46, True), fill=GOLD)
        y += 110
    d.text((70, H - 70), 'Hoàng Hiệp – thông tin tham khảo · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
    im.save(os.path.join(OUT, f'{key}-thong-tin.jpg'), quality=88, optimize=True, progressive=True)
