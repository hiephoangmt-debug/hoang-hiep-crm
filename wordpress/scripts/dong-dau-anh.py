"""Đóng dấu ảnh: chữ chìm chéo lặp khắp ảnh + dòng giữa ảnh + dải chân ảnh (số điện thoại, web).
Chữ chìm trải toàn ảnh nên cắt góc nào cũng còn, khó tẩy. Dùng: python3 -I dong-dau-anh.py anh1.jpg anh2.jpg …
(ghi đè file; thêm --khong-dai để bỏ dải chân ảnh)."""
import sys, math
from PIL import Image, ImageDraw, ImageFont

FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
TXT = 'Hoàng Hiệp · 0904 567 009 · hiephoangmt.com'
SHORT = '0904 567 009 · hiephoangmt.com'


def stamp(path, strip=True):
    im = Image.open(path).convert('RGBA')
    W, H = im.size
    # 1) Chữ chìm chéo lặp khắp ảnh.
    size = max(14, round(min(W, H) * 0.035))
    f = ImageFont.truetype(FB, size)
    tile_w = int(ImageDraw.Draw(im).textlength(SHORT, font=f)) + size * 4
    diag = int(math.hypot(W, H)) + tile_w
    layer = Image.new('RGBA', (diag, diag), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    step_y = size * 5
    for row, y in enumerate(range(0, diag, step_y)):
        off = (row % 2) * tile_w // 2
        for x in range(-tile_w, diag, tile_w):
            d.text((x + off + 1, y + 1), SHORT, font=f, fill=(0, 0, 0, 34))
            d.text((x + off, y), SHORT, font=f, fill=(255, 255, 255, 46))
    layer = layer.rotate(28, resample=Image.BICUBIC)
    lx, ly = (layer.width - W) // 2, (layer.height - H) // 2
    im = Image.alpha_composite(im, layer.crop((lx, ly, lx + W, ly + H)))
    # 2) Dòng rõ giữa ảnh.
    big = max(18, round(W * 0.045))
    fb = ImageFont.truetype(FB, big)
    ov = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    o = ImageDraw.Draw(ov)
    while o.textlength(TXT, font=fb) > W * 0.9 and big > 12:
        big -= 1
        fb = ImageFont.truetype(FB, big)
    cx, cy = W / 2, H * 0.55
    o.text((cx + 2, cy + 2), TXT, font=fb, fill=(0, 0, 0, 70), anchor='mm')
    o.text((cx, cy), TXT, font=fb, fill=(255, 255, 255, 120), anchor='mm')
    im = Image.alpha_composite(im, ov).convert('RGB')
    # 3) Dải chân ảnh.
    if strip:
        bh = max(34, round(W * 0.045))
        out = Image.new('RGB', (W, H + bh), (11, 26, 42))
        out.paste(im, (0, 0))
        s = ImageDraw.Draw(out)
        s.rectangle([0, H, W, H + 3], fill='#e8b04a')
        fs_size = round(bh * 0.5)
        fs = ImageFont.truetype(FB, fs_size)
        while s.textlength(TXT, font=fs) > W - 24 and fs_size > 10:
            fs_size -= 1
            fs = ImageFont.truetype(FB, fs_size)
        s.text((W / 2, H + 2 + bh / 2), TXT, font=fs, fill='white', anchor='mm')
        im = out
    im.save(path, quality=86, optimize=True, progressive=True)
    return im.size


if __name__ == '__main__':
    args = [a for a in sys.argv[1:] if not a.startswith('--')]
    for p in args:
        print(p.split('/')[-1], stamp(p, '--khong-dai' not in sys.argv))
