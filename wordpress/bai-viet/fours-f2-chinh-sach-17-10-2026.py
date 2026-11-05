"""Ảnh chính sách FourS Tower Tòa F2 – CSBH 4.2 cập nhật 17/10/2026 (quà nội thất Nhà Xinh).
Số liệu theo phiếu tính giá của chủ đầu tư (file CSBH4.2 ver 1 áp dụng từ 17.10.2026).
Xuất 2 ảnh: FB dọc 1080×1350 và ảnh bìa web 1600×1000.
Chạy: python3 fours-f2-chinh-sach-17-10-2026.py <anh-phoi-canh.jpg> <anh-dai-dien.jpg> <out-fb.jpg> <out-web.jpg>"""
import sys
from PIL import Image, ImageDraw, ImageFont, ImageFilter

PHOTO, AVA, OUT_FB, OUT_WEB = sys.argv[1:5]
I = '/usr/share/fonts/opentype/inter/'
NAVY, NAVY2, GOLD, CREAM, MUTED = (15, 34, 64), (24, 48, 86), (216, 177, 106), (248, 242, 230), (190, 198, 214)
GIFTS = [('Studio', '35 triệu'), ('1PN · 1PN+', '50 triệu'), ('2PN', '75 triệu'), ('3PN', '100 triệu')]
DISC = [('Không vay ngân hàng', '3%'), ('Thanh toán sớm 95%', '12%'), ('Thanh toán sớm 70% / 50%', '5% / 2,5%')]


def cover(img, w, h):
    r = max(w / img.width, h / img.height)
    img = img.resize((int(img.width * r) + 1, int(img.height * r) + 1), Image.LANCZOS)
    x, y = (img.width - w) // 2, (img.height - h) // 2
    return img.crop((x, y, x + w, y + h))


def avatar(im, d, F, P, S, x, y, size=104):
    a = Image.open(AVA).convert('RGB').resize((size * S, size * S), Image.LANCZOS)
    m = Image.new('L', a.size, 0)
    ImageDraw.Draw(m).ellipse((0, 0, a.size[0] - 1, a.size[1] - 1), fill=255)
    d.ellipse(P(x - 4, y - 4, x + size + 4, y + size + 4), fill=GOLD)
    im.paste(a, P(x, y), m)


def fb():
    W, H, S = 1080, 1350, 2
    F = lambda n, s: ImageFont.truetype(I + n, s * S)
    P = lambda *v: tuple(int(x * S) for x in v)
    im = Image.new('RGB', (W * S, H * S), NAVY)
    d0 = ImageDraw.Draw(im)
    for y in range(350 * S):  # nền chữ: xanh đậm chuyển nhẹ
        t = y / (350 * S)
        d0.line([(0, y), (W * S, y)], fill=tuple(int(a + (b - a) * t) for a, b in zip((10, 24, 48), (22, 44, 80))))
    top = cover(Image.open(PHOTO).convert('RGB'), W * S, 290 * S)
    im.paste(top, (0, 350 * S))
    d = ImageDraw.Draw(im, 'RGBA')
    tag = 'SUN FOURS TOWER · TÒA F2'
    ft = F('Inter-Bold.otf', 22)
    tw = d.textlength(tag, font=ft) / S
    d.rounded_rectangle(P(60, 60, 60 + tw + 44, 102), radius=21 * S, fill=GOLD)
    d.text(P(82, 68), tag, font=ft, fill=NAVY)
    d.text(P(58, 122), 'Chính sách mới', font=F('InterDisplay-ExtraBold.otf', 76), fill=CREAM)
    d.text(P(58, 208), 'từ ngày 17/10/2026', font=F('InterDisplay-Bold.otf', 52), fill=(255, 200, 140))
    d.text(P(60, 288), 'Tặng gói nội thất Nhà Xinh đến 100 triệu đồng', font=F('Inter-SemiBold.otf', 30), fill=CREAM)
    # khối quà Nhà Xinh
    d.rectangle(P(0, 640, W, H), fill=NAVY)
    d.line(P(0, 640, W, 640), fill=GOLD, width=3 * S)
    d.text(P(60, 668), 'Quà tặng nội thất Nhà Xinh (trừ vào giá bán)', font=F('Inter-Bold.otf', 28), fill=GOLD)
    cw = (W - 120 - 3 * 18) / 4
    for i, (k, v) in enumerate(GIFTS):
        x = 60 + i * (cw + 18)
        d.rounded_rectangle(P(x, 716, x + cw, 840), radius=18 * S, fill=NAVY2)
        f1, f2 = F('Inter-Medium.otf', 22), F('InterDisplay-ExtraBold.otf', 36)
        d.text((int((x + cw / 2) * S), 742 * S), k, font=f1, fill=MUTED, anchor='mt')
        d.text((int((x + cw / 2) * S), 780 * S), v, font=f2, fill=CREAM, anchor='mt')
    d.text(P(60, 872), 'Chiết khấu cộng thêm', font=F('Inter-Bold.otf', 28), fill=GOLD)
    y = 918
    for k, v in DISC:
        d.text(P(60, y), k, font=F('Inter-Medium.otf', 28), fill=CREAM)
        d.text(P(W - 60, y), v, font=F('Inter-Bold.otf', 30), fill=CREAM, anchor='ra')
        y += 50
        d.line(P(60, y - 10, W - 60, y - 10), fill=(255, 255, 255, 28), width=S)
    d.text(P(60, y + 4), 'Thanh toán sớm áp dụng theo thời hạn chủ đầu tư công bố từng đợt', font=F('Inter-Regular.otf', 21), fill=MUTED)
    ay = 1178
    avatar(im, d, F, P, S, 64, ay)
    d = ImageDraw.Draw(im, 'RGBA')
    d.text(P(196, ay + 14), 'Hoàng Hiệp', font=F('Inter-Bold.otf', 34), fill=CREAM)
    d.text(P(196, ay + 60), 'BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-Medium.otf', 26), fill=GOLD)
    d.text(P(W - 60, 1318), 'Ảnh: phối cảnh dự án', font=F('Inter-Regular.otf', 18), fill=(150, 160, 180), anchor='rs')
    im.resize((W, H), Image.LANCZOS).save(OUT_FB, quality=92, optimize=True, progressive=True)


def web():
    W, H, S = 1600, 1000, 2
    F = lambda n, s: ImageFont.truetype(I + n, s * S)
    P = lambda *v: tuple(int(x * S) for x in v)
    im = Image.new('RGB', (W * S, H * S), NAVY)
    ph = cover(Image.open(PHOTO).convert('RGB'), 760 * S, H * S)
    im.paste(ph, (0, 0))
    fade = Image.new('L', (220 * S, H * S))
    fd = ImageDraw.Draw(fade)
    for x in range(220 * S):
        fd.line([(x, 0), (x, H * S)], fill=int(255 * (x / (220 * S)) ** 1.3))
    im.paste(Image.new('RGB', (220 * S, H * S), NAVY), (540 * S, 0), fade)
    d = ImageDraw.Draw(im, 'RGBA')
    x0 = 800
    d.text(P(x0, 90), 'SUN FOURS TOWER · TÒA F2', font=F('Inter-Bold.otf', 26), fill=GOLD)
    d.text(P(x0, 136), 'Chính sách mới', font=F('InterDisplay-ExtraBold.otf', 78), fill=CREAM)
    d.text(P(x0, 226), 'từ 17/10/2026', font=F('InterDisplay-Bold.otf', 56), fill=(255, 200, 140))
    d.text(P(x0, 330), 'Quà nội thất Nhà Xinh (trừ vào giá bán)', font=F('Inter-Bold.otf', 28), fill=GOLD)
    y = 378
    for k, v in GIFTS:
        d.text(P(x0, y), k, font=F('Inter-Medium.otf', 30), fill=CREAM)
        d.text(P(W - 90, y), v, font=F('Inter-Bold.otf', 32), fill=CREAM, anchor='ra')
        y += 50
    d.text(P(x0, y + 20), 'Chiết khấu cộng thêm', font=F('Inter-Bold.otf', 28), fill=GOLD)
    y += 68
    for k, v in DISC:
        d.text(P(x0, y), k, font=F('Inter-Medium.otf', 28), fill=CREAM)
        d.text(P(W - 90, y), v, font=F('Inter-Bold.otf', 30), fill=CREAM, anchor='ra')
        y += 48
    d.text(P(x0, H - 70), 'Hoàng Hiệp · BĐS Đà Nẵng · Zalo 0904 567 009', font=F('Inter-SemiBold.otf', 26), fill=GOLD)
    im.resize((W, H), Image.LANCZOS).save(OUT_WEB, quality=88, optimize=True, progressive=True)


fb()
web()
