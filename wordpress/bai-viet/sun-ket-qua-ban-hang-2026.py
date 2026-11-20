"""Ảnh gửi khách (Zalo/Facebook) – Sun Group Đà Nẵng: kết quả bán hàng 3 – 10/2026 (số liệu anh Hiệp gửi 20/11/2026).
Khổ dọc 1080×1350, cùng tông thẻ tin thống nhất (navy – cam – vàng, Cormorant + Be Vietnam Pro).
Dùng: python3.13 bai-viet/sun-ket-qua-ban-hang-2026.py <file ảnh ra .jpg>"""
import sys, os
from PIL import Image, ImageDraw, ImageFont, ImageOps, ImageEnhance

HERE = os.path.dirname(os.path.abspath(__file__)); FD = f'{HERE}/fonts'
IMG = os.path.normpath(f'{HERE}/../wp-content/mu-plugins/hh-crm/img')
AVA = os.path.normpath(f'{HERE}/../wp-content/themes/hoanghiep/assets/img/hoang-hiep-avatar.jpg')
W, H = 1080, 1350
NAVY = (16, 32, 58); NAVY2 = (24, 44, 78); ORANGE = (232, 120, 52); GOLD = (232, 190, 112); WHITE = (255, 255, 255); SOFT = (196, 208, 226)


def serif(s, w=600):
    f = ImageFont.truetype(f'{FD}/CormorantGaramond[wght].ttf', s); f.set_variation_by_axes([w]); return f


def sans(s, w='SemiBold'):
    return ImageFont.truetype(f'{FD}/BeVietnamPro-{w}.ttf', s)


def script(s):
    f = ImageFont.truetype(f'{FD}/DancingScript[wght].ttf', s); f.set_variation_by_axes([600]); return f


def spaced(d, xy, t, f, fill, tr):
    x, y = xy
    for ch in t:
        d.text((x, y), ch, font=f, fill=fill); x += d.textlength(ch, font=f) + tr


ROWS = [  # (thời điểm, dự án, số bán, nhãn số, bối cảnh thị trường – diễn đạt nhẹ khi gửi khách, nổi bật)
    ('T3/2026', 'Đất nền Võ Chí Công', 350, '350 lô', 'Thị trường còn tốt', False),
    ('T4 – T5', 'FourS Tower F1, F5', 1000, '1.000/1.100 SP', 'Lãi suất cao', True),
    ('T6/2026', 'Symphony 5', 500, '500 SP', 'Thị trường khó khăn', False),
    ('T7 – T8', 'S-Light Tower', 750, '750 SP · Sold out', 'Thanh khoản yếu', True),
    ('T9/2026', 'Penthouse & Shop khối đế', 50, '50 SP (kỷ lục)', 'Thị trường trầm lắng', False),
    ('T10/2026', 'FourS Tower F2', 350, '350 SP', 'Thị trường rất trầm', False),
]


def main(out):
    im = Image.new('RGBA', (W, H), NAVY + (255,))
    # Ảnh nền phối cảnh FourS Tower phía trên, mờ dần vào nền navy.
    ph = Image.open(f'{IMG}/fours-tower/fours-tower-toan-canh-hoang-hon.jpg').convert('RGB')
    ph = ImageEnhance.Brightness(ImageOps.fit(ph, (W, 560), Image.LANCZOS, centering=(0.5, 0.45))).enhance(0.42)
    m = Image.new('L', (W, 560))
    for y in range(560):
        ImageDraw.Draw(m).line([(0, y), (W, y)], fill=int(255 * min(1, max(0, (520 - y) / 300))))
    im.paste(ph, (0, 0), m)
    d = ImageDraw.Draw(im)

    spaced(d, (64, 52), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', sans(22, 'ExtraBold'), GOLD, 4)
    d.text((64, 100), 'Sun Group Đà Nẵng 2026', font=serif(58, 600), fill=WHITE)
    d.text((64, 166), 'Thị trường chững lại,', font=serif(46, 500), fill=SOFT)
    d.text((64, 222), 'sản phẩm Sun vẫn có người mua', font=script(52), fill=GOLD)
    # Con số tổng
    d.text((64, 300), '~3.000', font=serif(150, 700), fill=ORANGE, features=['lnum'])
    tw = d.textlength('~3.000', font=serif(150, 700))
    d.text((64 + tw + 24, 342), 'sản phẩm', font=sans(34, 'ExtraBold'), fill=WHITE)
    d.text((64 + tw + 24, 390), 'bán ra trong 8 tháng', font=sans(26, 'Medium'), fill=SOFT)
    d.text((64 + tw + 24, 426), '(tháng 3 – tháng 10/2026)', font=sans(22, 'Medium'), fill=SOFT)

    # Bảng tiến trình: mỗi đợt một hàng, thanh ngang tỉ lệ số sản phẩm.
    y0 = 512; rh = 98; x0, x1 = 64, W - 64; L = 236
    d.text((x0, y0 - 14), 'KẾT QUẢ TỪNG ĐỢT MỞ BÁN', font=sans(22, 'ExtraBold'), fill=GOLD)
    y = y0 + 26
    bx0, bx1 = 400, x1 - 10
    for t, name, n, lab, ctx, hot in ROWS:
        card = (x0, y, x1, y + rh - 14)
        d.rounded_rectangle(card, 18, fill=(30, 52, 90) if hot else NAVY2)
        d.rounded_rectangle((x0 + 18, y + 20, x0 + 140, y + 56), 18, fill=ORANGE if hot else (52, 78, 120))
        d.text((x0 + 79, y + 38), t, font=sans(20, 'ExtraBold'), fill=WHITE, anchor='mm')
        d.text((x0 + 18, y + 62), ctx, font=sans(16, 'Medium'), fill=(150, 168, 196))
        d.text((x0 + L, y + 14), name, font=sans(26, 'ExtraBold'), fill=WHITE)
        # thanh
        bw = int((bx1 - x0 - L) * n / 1000)
        by = y + 56
        d.rounded_rectangle((x0 + L, by, bx1, by + 16), 8, fill=(44, 66, 104))
        d.rounded_rectangle((x0 + L, by, x0 + L + max(16, bw), by + 16), 8, fill=ORANGE if hot else GOLD)
        f = sans(26, 'ExtraBold')
        d.text((x1 - 20, y + 14), lab, font=f, fill=ORANGE if hot else GOLD, anchor='ra')
        y += rh

    # Thông điệp
    y += 2
    d.text((W // 2, y), 'Mua sản phẩm thanh khoản tốt – an tâm cả khi thị trường khó', font=sans(25, 'SemiBold'), fill=WHITE, anchor='ma')
    d.text((W // 2, y + 36), 'Nhận giỏ hàng & chính sách mới nhất Sun Group Đà Nẵng', font=sans(21, 'Medium'), fill=SOFT, anchor='ma')

    # Thẻ liên hệ
    box = (32, H - 128, W - 32, H - 26); bx, by0, bx2, by1 = box; h = by1 - by0
    d.rounded_rectangle(box, 22, fill=(232, 120, 52))
    a = int(h * 0.76); ax, ay = bx + 18, by0 + (h - a) // 2
    av = ImageOps.fit(Image.open(AVA).convert('RGB'), (a, a), Image.LANCZOS)
    mk = Image.new('L', (a, a), 0); ImageDraw.Draw(mk).ellipse((0, 0, a - 1, a - 1), fill=255)
    d.ellipse((ax - 3, ay - 3, ax + a + 3, ay + a + 3), fill=WHITE); im.paste(av, (ax, ay), mk)
    tx = ax + a + 22
    d.text((tx, by0 + 16), 'Hoàng Hiệp', font=sans(32, 'ExtraBold'), fill=WHITE)
    d.text((tx, by0 + 58), 'Chuyên gia BĐS Đà Nẵng · hiephoangmt.com', font=sans(20, 'Medium'), fill=(255, 236, 214))
    d.text((bx2 - 26, by0 + h / 2), 'Zalo 0904 567 009', font=sans(34, 'ExtraBold'), fill=WHITE, anchor='rm')
    d.text((W // 2, H - 14), 'Số liệu tổng hợp theo kết quả bán hàng các đợt mở bán 2026 · Phối cảnh FourS Tower', font=sans(14, 'Medium'), fill=(120, 140, 170), anchor='ms')
    im.convert('RGB').save(out, quality=90, optimize=True, progressive=True)


if __name__ == '__main__':
    main(sys.argv[1])
