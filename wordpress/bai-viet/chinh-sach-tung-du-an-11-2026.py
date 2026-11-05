"""Ảnh bìa tự vẽ cho bài chính sách bán hàng tháng 11/2026 của từng dự án Sun."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY = '#d8b16a', '#f7f1e3', '#0f2240'
CARDS = {
    'spana-tower': ('Spana Tower', [('Quà tặng an cư', '3%'), ('Không vay', '5%'), ('TT sớm 95%', '6%'), ('TT sớm 70%', '1%'), ('Hỗ trợ lãi suất', '24 tháng')]),
    'cora-tower': ('Cora Tower', [('Nội thất (căn hộ)', '7%'), ('Không vay', '5%'), ('TT sớm 95%', '7,5%'), ('TT sớm 70%', '1,5%'), ('Hỗ trợ lãi suất', '24 tháng')]),
    's-light-tower': ('S-Light Tower', [('Early Bird', '3%'), ('Không vay', '3%'), ('TT sớm 95%', '10%'), ('TT sớm 70%', '3%'), ('Hỗ trợ lãi suất', '24 tháng')]),
    'fours-f1-f5': ('FourS Tower F1, F5', [('Nội thất', '7%'), ('Không vay', '5%'), ('TT sớm 95%', '9%'), ('TT sớm 70%', '2,5%'), ('Hỗ trợ lãi suất', '24 tháng')]),
    'fours-f2': ('FourS Tower F2', [('Quà nội thất', '35–100 tr'), ('Không vay', '3%'), ('TT sớm 95%', 'liên hệ'), ('Miễn phí quản lý', '2 năm'), ('Hỗ trợ lãi suất', '24 tháng')]),
}
for key, (name, rows) in CARDS.items():
    W, H = 1600, 1067
    im = Image.new('RGB', (W, H), NAVY)
    d = ImageDraw.Draw(im)
    d.text((70, 60), 'CHÍNH SÁCH BÁN HÀNG · THÁNG 11/2026', font=f(30, True), fill=GOLD)
    d.text((70, 110), name, font=f(78, True), fill=CREAM)
    y = 260
    for label, val in rows:
        d.line([(70, y - 14), (1530, y - 14)], fill='#2b4a7c', width=2)
        d.text((70, y), label, font=f(44), fill=CREAM)
        tw = d.textlength(val, font=f(52, True))
        d.text((1530 - tw, y - 4), val, font=f(52, True), fill=GOLD)
        y += 118
    d.text((70, y + 6), 'Vay tối đa 70% · trả 70% nhận nhà (Sun Early Key) · TT sớm hạn 25/11/2026', font=f(28), fill=CREAM)
    d.text((70, H - 70), 'Hoàng Hiệp tổng hợp – thông tin tham khảo · Zalo 0904 567 009', font=f(26, True), fill=GOLD)
    im.save(os.path.join(OUT, f'chinh-sach-{key}-11-2026.jpg'), quality=88, optimize=True, progressive=True)
