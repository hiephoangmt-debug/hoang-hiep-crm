"""Ảnh nội thất đăng web: chỉ thanh chú thích "minh họa, thông số theo CĐT" (không chèn số điện thoại, không chèn web)."""
import sys
from PIL import Image, ImageDraw, ImageFont, ImageFilter, ImageChops
import random as _rnd
def photo(im):
    W_, H_ = im.size; vg = Image.radial_gradient('L').resize((W_, H_)); vg = vg.point(lambda v: 255 - int(v * .16)); im = ImageChops.multiply(im, Image.merge('RGB', (vg, vg, vg)))   # tối nhẹ 4 góc như ống kính thật
    r_, g_, b_ = im.split(); r_ = r_.point(lambda v: min(255, int(v * 1.02 + 2))); b_ = b_.point(lambda v: int(v * .97)); im = Image.merge('RGB', (r_, g_, b_))   # tông ấm nhẹ
    gn = Image.effect_noise((W_, H_), 7).convert('L'); gn = Image.merge('RGB', (gn, gn, gn)); im = Image.blend(im, ImageChops.overlay(im, gn), .25)   # hạt phim rất nhẹ
    return im
src, dst, txt = sys.argv[1], sys.argv[2], sys.argv[3]
im = Image.open(src).convert('RGB').filter(ImageFilter.UnsharpMask(radius=1.4, percent=70, threshold=2)); im = photo(im).convert('RGBA'); W, H = im.size
ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(ov)
f2 = ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf', 22)
d.rectangle([0, H - 40, W, H], fill=(10, 37, 64, 235)); d.text((16, H - 33), txt, font=f2, fill=(255, 255, 255, 255))
Image.alpha_composite(im, ov).convert('RGB').save(dst, 'WEBP', quality=86, method=6)
