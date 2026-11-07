"""Thẻ tin 1500×1000 – 3 căn 1PN Newtown Diamond tòa The Ruby (11/2026). Tự vẽ, không dùng ảnh tin rao.
Chạy: python3 newtown-ruby-1pn-11-2026-anh.py <out.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont
I = '/usr/share/fonts/opentype/inter/'
F = lambda n, s: ImageFont.truetype(I + n, s)
NAVY, NAVY2, GOLD, CREAM, MUTED, SEA = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (176, 186, 206), (40, 96, 150)
im = Image.new('RGB', (1500, 1000), NAVY)
d = ImageDraw.Draw(im, 'RGBA')
# sóng biển cách điệu phía dưới
for k in range(7):
    y = 760 + k * 34
    d.rounded_rectangle((-40 + k * 30, y, 1540, y + 16), radius=8, fill=SEA + (90 - k * 10,))
# tòa tháp cách điệu
for x, h in ((1080, 520), (1200, 600), (1320, 470)):
    d.rectangle((x, 760 - h, x + 90, 760), fill=NAVY2)
    for yy in range(760 - h + 20, 750, 34):
        d.rectangle((x + 14, yy, x + 76, yy + 12), fill=(255, 220, 160, 60))
d.text((260, 58), 'NEWTOWN DIAMOND · THE RUBY', font=F('Inter-Bold.otf', 34), fill=GOLD)
d.text((80, 150), 'Căn 1 phòng ngủ', font=F('InterDisplay-ExtraBold.otf', 92), fill=CREAM)
d.text((80, 262), 'tầng cao, căn ngoại giao', font=F('InterDisplay-Bold.otf', 70), fill=(255, 200, 140))
d.text((80, 380), '47 – 47,85 m² · view biển, Ngũ Hành Sơn', font=F('Inter-Medium.otf', 42), fill=MUTED)
d.rounded_rectangle((80, 470, 760, 600), radius=24, fill=GOLD)
d.text((110, 488), 'Từ 3,17 tỷ', font=F('InterDisplay-ExtraBold.otf', 80), fill=NAVY)
d.text((80, 640), 'Giá thanh toán sớm, đã trừ chiết khấu 12% · 3 căn', font=F('Inter-Medium.otf', 34), fill=CREAM)
d.text((80, 930), 'Hoàng Hiệp · BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-SemiBold.otf', 32), fill=GOLD)
im.save(sys.argv[1], quality=88, optimize=True, progressive=True)
