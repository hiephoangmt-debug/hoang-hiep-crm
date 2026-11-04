"""Chuyển ảnh tin nhà đất (16:9, 3:2) sang khổ 4:3 1200×900, nội dung nằm trong vùng an toàn:
WordPress cắt ảnh thẻ 3:2 (bỏ trên/dưới ~50 px) rồi thẻ tin hiện 4:3 (bỏ hai bên ~67 px) – chữ không bị che.
Dùng: python3 anh-tin-4x3.py <ảnh gốc> <ảnh ra> [màu nền]"""
import sys
from PIL import Image
src, dst = sys.argv[1], sys.argv[2]
im = Image.open(src).convert('RGB')
bg = sys.argv[3] if len(sys.argv) > 3 else im.getpixel((2, im.height // 2))
W, H, SW, SH = 1200, 900, 1040, 760  # khổ 4:3 và vùng an toàn
r = min(SW / im.width, SH / im.height)
im2 = im.resize((round(im.width * r), round(im.height * r)), Image.LANCZOS)
out = Image.new('RGB', (W, H), bg)
out.paste(im2, ((W - im2.width) // 2, (H - im2.height) // 2))
out.save(dst, quality=92)
print(dst, out.size, im2.size)
