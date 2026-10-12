# Ảnh đại diện (đồ hoạ tự vẽ) cho 8 trang dự án đất nền Điện Ngọc.
# Chạy: python3 -I dien-ngoc-anh-dai-dien.py  → wp-content/mu-plugins/hh-crm/img/dien-ngoc/<slug>.jpg
import math, os, random
from PIL import Image, ImageDraw, ImageFont

OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'dien-ngoc')
os.makedirs(OUT, exist_ok=True)
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
FR = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
f = lambda p, s: ImageFont.truetype(p, s)
W, H = 1200, 800
NAVY, GOLD, SKY = (11, 26, 42), '#e8b04a', (120, 190, 235)

P = [
    ('khu-do-thi-1a-1b-dien-ngoc', 'Khu đô thị 1A – 1B', 'Điện Ngọc · sát ĐH FPT',
     [('Vị trí', 'Trịnh Hoài Đức – Trần Đại Nghĩa'), ('Lô phổ biến', '122,5 – 153 m²'), ('Pháp lý', 'Đất ở đô thị, sổ từng lô*')], '27 – 40'),
    ('khu-do-thi-so-3-dien-ngoc', 'Khu đô thị số 3', 'Điện Nam – Điện Ngọc',
     [('Quy mô', '36,5 ha · Vinaconex 25'), ('Lô phổ biến', '121 – 157 m²'), ('Tiện ích', 'ĐH Phan Châu Trinh, hồ 3,6 ha')], '25 – 38'),
    ('khu-do-thi-7b-dien-ngoc', 'Khu đô thị 7B', 'Coco Center House · Sentosa City',
     [('Quy mô', 'khoảng 29,7 ha'), ('Lô phổ biến', '87,5 – 150 m²'), ('Vị trí', 'Ven sông Cổ Cò, đối diện golf')], '14 – 28'),
    ('khu-do-thi-so-9-dien-ngoc', 'Khu đô thị số 9', 'Điện Ngọc · quanh chợ Điện Ngọc',
     [('Quy mô', '54,6 ha'), ('Lô phổ biến', '110 – 147 m²'), ('Lưu ý', 'Kiểm tra sổ từng lô')], '19 – 25'),
    ('pho-cho-dien-ngoc', 'Phố chợ Điện Ngọc', 'Trung tâm khu đô thị số 9',
     [('Quy mô', 'khoảng 1 ha · 70 nền'), ('Lô phổ biến', '85 – 128 m²'), ('Hợp với', 'Ở kết hợp kinh doanh')], '27 – 46'),
    ('sentosa-riverside-dien-ngoc', 'Sentosa Riverside', 'Peaceful Land · Điện Ngọc',
     [('Quy mô', '20,33 ha · 677 lô'), ('Lô phổ biến', '108 – 150 m²'), ('Vị trí', 'Ven sông Cổ Cò, cách biển 500 m')], '18 – 26'),
    ('gaia-city-dien-ngoc', 'GAIA City', 'Đường Dũng Sĩ Điện Ngọc',
     [('Mở bán', '8/2017 · 475 lô'), ('Lô phổ biến', '100 – 120 m²'), ('Gần', 'Cocobay, biển Viêm Đông')], '20 – 30'),
    ('tropical-palm-dien-ngoc', 'Tropical Palm', 'Ngọc Dương Riverside mở rộng',
     [('Quy mô', 'khoảng 20 ha · 533 sản phẩm'), ('Lô phổ biến', '100 – 125 m²'), ('Vị trí', 'Sông Cổ Cò – Võ Nguyên Giáp')], '17 – 30'),
]


def background():
    base = Image.new('RGBA', (W, H), NAVY + (255,))
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(ov)
    # Sông Cổ Cò cách điệu (dải cong mờ bên phải)
    left = [(860 + 70 * math.sin(y / 120), y) for y in range(-10, H + 11, 2)]
    d.polygon(left + [(x + 46, y) for x, y in reversed(left)], fill=(64, 132, 186, 60))
    base = Image.alpha_composite(base, ov)
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(ov)
    for x in range(0, W, 32): d.line([x, 0, x, H], fill=(255, 255, 255, 16))
    for y in range(0, H, 32): d.line([0, y, W, y], fill=(255, 255, 255, 16))
    for k in range(5):
        amp, per, by, a = 6 + k * 2, 220 + k * 50, H - 14 - k * 16, 80 - k * 13
        d.line([(x, by + amp * math.sin(2 * math.pi * (x + k * 61) / per)) for x in range(0, W + 1, 4)], fill=SKY + (a,), width=3)
    return Image.alpha_composite(base, ov).convert('RGB')


def cover(slug, name):
    # Ảnh đại diện không chữ lớn (làm nền hero): sơ đồ cách điệu các block đất ven sông Cổ Cò.
    rnd = random.Random(slug)
    base = Image.new('RGBA', (W, H), NAVY + (255,))
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(ov)
    ph = rnd.random() * 6
    left = [(860 + 70 * math.sin(y / 120 + ph), y) for y in range(-10, H + 11, 2)]
    right = [(x + 80 + 14 * math.sin(y / 60 + ph), y) for x, y in reversed(left)]
    d.polygon(left + right, fill=(64, 132, 186, 150))
    base = Image.alpha_composite(base, ov)
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(ov)
    for x in range(0, W, 32): d.line([x, 0, x, H], fill=(255, 255, 255, 14))
    for y in range(0, H, 32): d.line([0, y, W, y], fill=(255, 255, 255, 14))
    # Đường quy hoạch + block lô đất
    xs = [40]
    while xs[-1] < 760: xs.append(xs[-1] + rnd.choice([110, 130, 150]))
    ys = [40]
    while ys[-1] < 660: ys.append(ys[-1] + rnd.choice([90, 110]))
    for i in range(len(xs) - 1):
        for j in range(len(ys) - 1):
            x0, y0, x1, y1 = xs[i] + 10, ys[j] + 10, xs[i + 1] - 10, ys[j + 1] - 10
            if x1 > 800: continue
            hot = rnd.random() < 0.12
            d.rounded_rectangle([x0, y0, x1, y1], radius=6, fill=(232, 176, 74, 70) if hot else (52, 80, 110, 120), outline=(255, 255, 255, 40))
            for k in range(1, 4):
                lx = x0 + (x1 - x0) * k // 4
                d.line([lx, y0 + 4, lx, y1 - 4], fill=(255, 255, 255, 28))
    for k in range(5):
        amp, per, by, a = 6 + k * 2, 220 + k * 50, H - 14 - k * 16, 90 - k * 15
        d.line([(x, by + amp * math.sin(2 * math.pi * (x + k * 61) / per)) for x in range(0, W + 1, 4)], fill=SKY + (a,), width=3)
    im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
    d.text((W - 40, H - 112), name, font=f(FB, 28), fill='white', anchor='ra')
    d.text((W - 40, H - 74), 'Minh hoạ · hiephoangmt.com', font=f(FR, 20), fill=GOLD, anchor='ra')
    return im


def wrap(d, text, font, maxw):
    words, lines, cur = text.split(), [], ''
    for w in words:
        t = (cur + ' ' + w).strip()
        if d.textlength(t, font=font) <= maxw: cur = t
        else: lines.append(cur); cur = w
    lines.append(cur)
    return lines


P += [
    ('nam-hoi-an-city', 'Nam Hội An City', 'Chân cầu Cửa Đại · ven sông Thu Bồn',
     [('Quy mô', 'khoảng 19,34 ha · FVG'), ('Sản phẩm', 'Nhà phố 3 tầng 5 × 20 m'), ('Vị trí', 'Cách phố cổ Hội An 5 km')], '35 – 62', 'NHÀ PHỐ NAM HỘI AN · ĐÀ NẴNG', 'vinh-an-hoa'),
    ('vinh-an-hoa-city', 'Vịnh An Hòa City', 'Núi Thành · ven vịnh An Hòa',
     [('Quy mô', '99,6 ha · khoảng 2.700 sản phẩm'), ('Lô phổ biến', '150 – 160 m²'), ('Gần', 'Sân bay Chu Lai, KKT Chu Lai')], '8 – 11', 'ĐẤT NỀN NÚI THÀNH · ĐÀ NẴNG', 'vinh-an-hoa'),
]

for row in P:
    slug, name, sub, facts, price = row[:5]
    head = row[5] if len(row) > 5 else 'ĐẤT NỀN ĐIỆN NGỌC · ĐÀ NẴNG'
    out = os.path.join(OUT, '..', row[6]) if len(row) > 6 else OUT
    os.makedirs(out, exist_ok=True)
    im = background(); d = ImageDraw.Draw(im)
    d.rectangle([0, 0, W, 8], fill=GOLD)
    d.text((64, 56), head, font=f(FB, 26), fill=GOLD)
    y = 104
    for ln in wrap(d, name, f(FB, 72), 1000):
        d.text((64, y), ln, font=f(FB, 72), fill='white'); y += 86
    d.text((64, y + 4), sub, font=f(FR, 32), fill=(190, 210, 230)); y += 76
    for k, v in facts:
        d.ellipse([66, y + 12, 80, y + 26], fill=GOLD)
        d.text((100, y), k + ':', font=f(FB, 30), fill=(160, 185, 210))
        d.text((100 + d.textlength(k + ': ', font=f(FB, 30)), y), v, font=f(FB, 30), fill='white')
        y += 52
    # Hộp giá
    bx, by = 64, H - 230
    d.rounded_rectangle([bx, by, bx + 560, by + 120], radius=16, fill=(16, 40, 64), outline=GOLD, width=3)
    d.text((bx + 26, by + 16), 'Giá rao tham khảo 2026', font=f(FR, 24), fill=(190, 210, 230))
    d.text((bx + 26, by + 50), price + ' triệu/m²', font=f(FB, 46), fill=GOLD)
    d.text((W - 64, H - 150), 'hiephoangmt.com', font=f(FB, 34), fill='white', anchor='ra')
    d.text((W - 64, H - 106), 'Hoàng Hiệp · 0904 567 009', font=f(FR, 26), fill=GOLD, anchor='ra')
    d.text((64, H - 92), '* Kiểm tra sổ bản gốc từng lô. Giá rao, không phải giá giao dịch.', font=f(FR, 20), fill=(150, 170, 195))
    im.save(os.path.join(out, slug + '-thong-tin.jpg'), quality=86, optimize=True)
    cover(slug, name).save(os.path.join(out, slug + '.jpg'), quality=86, optimize=True)
    print(slug)
