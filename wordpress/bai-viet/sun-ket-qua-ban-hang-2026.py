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

    # Biểu đồ 2 tầng cùng trục thời gian: trên = diễn biến thị trường (định tính), dưới = số sản phẩm bán ra.
    x0, x1 = 44, W - 44
    sh = Image.new('RGBA', im.size, (0, 0, 0, 0)); ImageDraw.Draw(sh).rounded_rectangle((x0, 492, x1, 1176), 24, fill=(22, 40, 66, 20)); im.alpha_composite(sh)
    d = ImageDraw.Draw(im)
    d.rounded_rectangle((x0, 486, x1, 1170), 24, fill=(255, 255, 255), outline=LINE, width=2)
    n = len(ROWS); cw = (x1 - x0 - 40) / n; cx = [x0 + 20 + cw * k + cw / 2 for k in range(n)]
    MK = (88, 104, 128)  # thị trường: xám xanh (1 chuỗi – không cần chú thích màu)
    # --- Tầng trên: thị trường ---
    d.text((x0 + 28, 506), 'THỊ TRƯỜNG BĐS CHUNG', font=sans(20, 'ExtraBold'), fill=BLUE)
    d.text((x1 - 28, 508), 'diễn biến minh họa', font=sans(16, 'Medium'), fill=GREY, anchor='ra')
    ty, by_ = 560, 700  # đỉnh (tốt) – đáy (trầm)
    d.text((x0 + 28, ty - 10), 'Tốt', font=sans(15, 'SemiBold'), fill=GREY)
    d.text((x0 + 28, by_ - 4), 'Trầm', font=sans(15, 'SemiBold'), fill=GREY)
    for gy in (ty, (ty + by_) / 2, by_):
        d.line([(x0 + 80, gy), (x1 - 24, gy)], fill=(236, 240, 246), width=1)
    lv = [1.0, 0.78, 0.55, 0.36, 0.18, 0.06]
    pts = [(cx[k], by_ - (by_ - ty) * lv[k]) for k in range(n)]
    area = Image.new('RGBA', im.size, (0, 0, 0, 0)); ImageDraw.Draw(area).polygon(pts + [(pts[-1][0], by_), (pts[0][0], by_)], fill=(88, 104, 128, 30)); im.alpha_composite(area)
    d = ImageDraw.Draw(im)
    d.line(pts, fill=MK, width=4, joint='curve')
    for k, (px, py) in enumerate(pts):
        d.ellipse((px - 8, py - 8, px + 8, py + 8), fill=(255, 255, 255), outline=MK, width=3)
        ctx = ROWS[k][4].replace('Thị trường ', '').capitalize()
        f = sans(15, 'SemiBold'); lab = ctx
        tx = min(max(px, x0 + 90), x1 - 70)
        d.text((tx, py + 14), lab, font=f, fill=INK, anchor='ma')
    # --- Trục thời gian chung ---
    my = 748
    d.line([(x0 + 20, my), (x1 - 20, my)], fill=LINE, width=2)
    for k in range(n):
        d.rounded_rectangle((cx[k] - 62, my - 18, cx[k] + 62, my + 18), 18, fill=OR if ROWS[k][5] else NV)
        d.text((cx[k], my), ROWS[k][0].replace('/2026', ''), font=sans(19, 'ExtraBold'), fill=(255, 255, 255), anchor='mm')
    # --- Tầng dưới: kết quả bán ---
    d.text((x0 + 28, 784), 'KẾT QUẢ BÁN HÀNG SUN GROUP', font=sans(20, 'ExtraBold'), fill=BLUE)
    d.text((x1 - 28, 786), 'số sản phẩm bán ra', font=sans(16, 'Medium'), fill=GREY, anchor='ra')
    base = 1050; hmax = 170; bw = 84
    NM = ['Đất nền\nVõ Chí Công', 'FourS Tower\nF1, F5', 'Symphony 5', 'S-Light\nTower', 'Penthouse &\nShop khối đế', 'FourS Tower\nF2']
    d.line([(x0 + 20, base), (x1 - 20, base)], fill=(196, 206, 220), width=2)
    for k, (t, name, val, lab, ctx, hot) in enumerate(ROWS):
        h = max(8, int(hmax * val / 1000))
        d.rounded_rectangle((cx[k] - bw / 2, base - h, cx[k] + bw / 2, base), 6, fill=OR if hot else (232, 168, 120))
        d.rectangle((cx[k] - bw / 2, base - 6, cx[k] + bw / 2, base), fill=OR if hot else (232, 168, 120))
        num = lab.split(' ')[0]; unit = lab[len(num):].strip()
        d.text((cx[k], base - h - 30), num, font=sans(24, 'ExtraBold'), fill=INK, anchor='ms')
        if unit:
            d.text((cx[k], base - h - 8), unit, font=sans(14, 'SemiBold'), fill=OR if hot else GREY, anchor='ms')
        # tên dự án dưới trục, tối đa 2 dòng
        for q, ln in enumerate(NM[k].split('\n')):
            d.text((cx[k], base + 12 + q * 22), ln, font=sans(17, 'SemiBold'), fill=INK, anchor='ma')
    d.text((W // 2, 1118), 'Thị trường đi xuống, kết quả bán hàng vẫn giữ vững', font=script(30), fill=OR, anchor='ma')
    y = 1186
    d.text((W // 2, y), 'Mua sản phẩm thanh khoản tốt – an tâm cả khi thị trường khó', font=sans(24, 'SemiBold'), fill=NV, anchor='ma')

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
