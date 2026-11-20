"""Ảnh gửi khách (Zalo/Facebook) – Sun Group Đà Nẵng: kết quả bán hàng 3 – 10/2026 (số liệu anh Hiệp gửi 20/11/2026).
Khổ dọc 1080×1350, tông sáng như thẻ tin thống nhất anh Hiệp duyệt (nền trắng xanh nhạt, chữ navy, số cam, thẻ liên hệ navy – vàng).
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
    BG_TOP = (238, 244, 250); BG_MID = (246, 249, 252); INK = (20, 24, 32); BLUE = (30, 70, 112)
    NV = (22, 40, 66); OR = (214, 104, 40); LINE = (214, 224, 236); GREY = (110, 122, 138)
    im = Image.new('RGBA', (W, H), BG_MID + (255,))
    g = ImageDraw.Draw(im)
    for y in range(H):
        t = y / H; g.line([(0, y), (W, y)], fill=tuple(int(BG_TOP[k] * (1 - t) + BG_MID[k] * t) for k in range(3)) + (255,))
    # Phối cảnh FourS Tower góc phải trên, mờ dần sang trái và xuống dưới (như thẻ tin web).
    PW, PH = 640, 500
    ph = ImageOps.fit(Image.open(f'{IMG}/fours-tower/fours-tower-toan-canh-hoang-hon.jpg').convert('RGB'), (PW, PH), Image.LANCZOS, centering=(0.55, 0.5))
    m = Image.new('L', (PW, PH), 0); mg = ImageDraw.Draw(m)
    for x in range(PW):
        for y in range(0, PH, 2):
            a = min(1, max(0, (x - 20) / 320)) ** 1.4 * min(1, max(0, (PH - 20 - y) / 200))
            mg.line([(x, y), (x, y + 1)], fill=int(255 * a))
    im.paste(ph, (W - PW, 0), m)
    d = ImageDraw.Draw(im)

    spaced(d, (60, 50), 'HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG', sans(20, 'ExtraBold'), BLUE, 4)
    spaced(d, (60, 86), 'KẾT QUẢ BÁN HÀNG · 2026', serif(26, 600), INK, 4)
    d.text((60, 128), 'Sun Group Đà Nẵng', font=serif(66, 600), fill=NV)
    d.text((60, 204), 'Thị trường chững lại,', font=serif(44, 500), fill=NV)
    d.text((70, 256), 'Sun vẫn bán tốt', font=script(56), fill=OR)
    d.text((60, 340), '~3.000', font=serif(140, 700), fill=OR, features=['lnum'])
    tw = d.textlength('~3.000', font=serif(140, 700))
    d.text((60 + tw + 22, 372), 'sản phẩm bán ra', font=sans(30, 'ExtraBold'), fill=INK)
    d.text((60 + tw + 22, 414), 'trong 8 tháng (3 – 10/2026)', font=sans(23, 'Medium'), fill=GREY)

    # Biểu đồ trục thời gian ở giữa: phía trên = số sản phẩm Sun bán ra (cột lên), phía dưới = thị trường chung (cột xuống, càng dài càng trầm – định tính).
    x0, x1 = 44, W - 44
    sh = Image.new('RGBA', im.size, (0, 0, 0, 0)); ImageDraw.Draw(sh).rounded_rectangle((x0, 492, x1, 1176), 24, fill=(22, 40, 66, 20)); im.alpha_composite(sh)
    d = ImageDraw.Draw(im)
    d.rounded_rectangle((x0, 486, x1, 1170), 24, fill=(255, 255, 255), outline=LINE, width=2)
    n = len(ROWS); cw = (x1 - x0 - 40) / n; cx = [x0 + 20 + cw * k + cw / 2 for k in range(n)]
    NM = ['Đất nền Võ Chí Công', 'FourS Tower F1, F5', 'Symphony 5', 'S-Light Tower', 'Penthouse & Shop', 'FourS Tower F2']
    d.text((x0 + 28, 504), 'SẢN PHẨM SUN GROUP BÁN RA (số sản phẩm)', font=sans(20, 'ExtraBold'), fill=OR)
    ax_ = 812; base = ax_ - 26; hmax = 170; bw = 92
    for k, (t, name, val, lab, ctx, hot) in enumerate(ROWS):
        h = max(8, int(hmax * val / 1000)); col = OR if hot else (232, 168, 120)
        d.rounded_rectangle((cx[k] - bw / 2, base - h, cx[k] + bw / 2, base), 6, fill=col)
        d.rectangle((cx[k] - bw / 2, base - 6, cx[k] + bw / 2, base), fill=col)
        num = lab.split(' ')[0]; unit = lab[len(num):].strip()
        d.text((cx[k], base - h - 50), NM[k], font=sans(15, 'SemiBold'), fill=GREY, anchor='ms')
        d.text((cx[k], base - h - 24), num, font=sans(24, 'ExtraBold'), fill=INK, anchor='ms')
        if unit:
            d.text((cx[k], base - h - 6), unit, font=sans(14, 'SemiBold'), fill=OR if hot else GREY, anchor='ms')
    # Trục thời gian
    d.line([(x0 + 20, ax_), (x1 - 20, ax_)], fill=(196, 206, 220), width=3)
    for k in range(n):
        d.rounded_rectangle((cx[k] - 60, ax_ - 18, cx[k] + 60, ax_ + 18), 18, fill=NV)
        d.text((cx[k], ax_), ROWS[k][0].replace('/2026', ''), font=sans(19, 'ExtraBold'), fill=(255, 255, 255), anchor='mm')
    # Thị trường (cột xuống)
    top = ax_ + 62; dmax = 210; sev = [0.12, 0.32, 0.52, 0.7, 0.86, 1.0]; MK = (120, 134, 156)
    d.text((x0 + 28, ax_ + 28), 'THỊ TRƯỜNG BĐS CHUNG – cột càng dài càng trầm (minh họa)', font=sans(18, 'ExtraBold'), fill=BLUE)
    for k in range(n):
        h = int(dmax * sev[k])
        d.rounded_rectangle((cx[k] - bw / 2, top, cx[k] + bw / 2, top + h), 6, fill=MK)
        d.rectangle((cx[k] - bw / 2, top, cx[k] + bw / 2, top + 6), fill=MK)
        ctx = ROWS[k][4].replace('Thị trường ', '').capitalize()
        d.text((cx[k], top + h + 8), ctx, font=sans(15, 'SemiBold'), fill=INK, anchor='ma')
    y = 1182
    d.text((W // 2, y), 'Thị trường đi xuống – sản phẩm Sun vẫn bán đều', font=script(32), fill=OR, anchor='ma')

    box = (32, H - 128, W - 32, H - 26); bx, by0, bx2, by1 = box; h = by1 - by0
    ov = Image.new('RGBA', im.size, (0, 0, 0, 0)); ImageDraw.Draw(ov).rounded_rectangle(box, 22, fill=(24, 40, 70, 240)); im.alpha_composite(ov)
    d = ImageDraw.Draw(im)
    a = int(h * 0.74); ax, ay = bx + 18, by0 + (h - a) // 2
    av = ImageOps.fit(Image.open(AVA).convert('RGB'), (a, a), Image.LANCZOS)
    mk = Image.new('L', (a, a), 0); ImageDraw.Draw(mk).ellipse((0, 0, a - 1, a - 1), fill=255)
    d.ellipse((ax - 3, ay - 3, ax + a + 3, ay + a + 3), fill=(228, 186, 110)); im.paste(av, (ax, ay), mk)
    tx = ax + a + 22
    d.text((tx, by0 + 16), 'Hoàng Hiệp', font=sans(32, 'ExtraBold'), fill=(255, 255, 255))
    d.text((tx, by0 + 58), 'BĐS Đà Nẵng · hiephoangmt.com', font=sans(20, 'SemiBold'), fill=(232, 190, 112))
    d.text((bx2 - 26, by0 + h / 2), 'Zalo 0904 567 009', font=sans(34, 'ExtraBold'), fill=(232, 190, 112), anchor='rm')
    d.text((W // 2, H - 10), 'Số liệu tổng hợp theo kết quả bán hàng các đợt mở bán 2026 · Phối cảnh FourS Tower', font=sans(14, 'Medium'), fill=GREY, anchor='ms')
    im.convert('RGB').save(out, quality=90, optimize=True, progressive=True)


if __name__ == '__main__':
    main(sys.argv[1])
