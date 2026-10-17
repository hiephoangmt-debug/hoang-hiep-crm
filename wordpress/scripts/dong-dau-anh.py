"""Đóng dấu ảnh nhẹ nhàng, thẩm mỹ: chữ chìm mảnh lặp chéo rất mờ khắp ảnh (cắt góc nào cũng còn)
+ nhãn nhỏ góc phải dưới (nền navy trong mờ, vạch vàng): HOÀNG HIỆP / 0904 567 009 · hiephoangmt.com.
Dùng: python3 -I dong-dau-anh.py anh1.jpg anh2.jpg …  (ghi đè file)."""
import sys, math
from PIL import Image, ImageDraw, ImageFont, ImageFilter

F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
NAME, LINE = 'HOÀNG HIỆP', '0904 567 009  ·  hiephoangmt.com'
TILE = 'hiephoangmt.com  ·  0904 567 009'


def stamp(path):
    im = Image.open(path).convert('RGBA')
    W, H = im.size
    m = min(W, H)
    # 1) Chữ chìm mảnh, rất mờ, lặp chéo.
    size = max(11, round(m * 0.022))
    f = ImageFont.truetype(F, size)
    tw = int(ImageDraw.Draw(im).textlength(TILE, font=f)) + size * 6
    diag = int(math.hypot(W, H)) + tw * 2
    layer = Image.new('RGBA', (diag, diag), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    for row, y in enumerate(range(0, diag, size * 7)):
        off = (row % 2) * tw // 2
        for x in range(-tw, diag, tw):
            d.text((x + off, y), TILE, font=f, fill=(255, 255, 255, 30))
    layer = layer.rotate(30, resample=Image.BICUBIC)
    lx, ly = (layer.width - W) // 2, (layer.height - H) // 2
    im = Image.alpha_composite(im, layer.crop((lx, ly, lx + W, ly + H)))
    # 2) Nhãn góc phải dưới.
    s1 = max(10, round(m * 0.024))
    s2 = max(11, round(m * 0.03))
    f1, f2 = ImageFont.truetype(FB, s1), ImageFont.truetype(FB, s2)
    probe = ImageDraw.Draw(im)
    name_w = probe.textlength(NAME, font=f1) + s1 * 0.25 * len(NAME)
    w = int(max(name_w, probe.textlength(LINE, font=f2)) + s2 * 2.2)
    h = int(s1 + s2 + s2 * 1.6)
    pad = max(10, round(m * 0.025))
    x0, y0 = W - w - pad, H - h - pad
    shadow = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    ImageDraw.Draw(shadow).rounded_rectangle([x0 + 2, y0 + 4, x0 + w + 2, y0 + h + 4], radius=h // 4, fill=(0, 0, 0, 70))
    im = Image.alpha_composite(im, shadow.filter(ImageFilter.GaussianBlur(max(2, h // 8))))
    badge = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    b = ImageDraw.Draw(badge)
    b.rounded_rectangle([x0, y0, x0 + w, y0 + h], radius=h // 4, fill=(11, 26, 42, 175), outline=(232, 176, 74, 200), width=max(1, s1 // 9))
    tx, ty = x0 + s2 * 1.1, y0 + s2 * 0.55
    cx = tx
    for ch in NAME:  # giãn chữ
        b.text((cx, ty), ch, font=f1, fill=(232, 176, 74, 255))
        cx += b.textlength(ch, font=f1) + s1 * 0.25
    b.text((tx, ty + s1 + s2 * 0.35), LINE, font=f2, fill=(255, 255, 255, 245))
    im = Image.alpha_composite(im, badge).convert('RGB')
    im.save(path, quality=86, optimize=True, progressive=True)
    return im.size


if __name__ == '__main__':
    for p in sys.argv[1:]:
        print(p.split('/')[-1], stamp(p))
