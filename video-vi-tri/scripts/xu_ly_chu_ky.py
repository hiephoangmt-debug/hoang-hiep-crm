# Chuyển video chữ ký có kênh trong suốt (.mov, ví dụ hoanghiep_1.mov) thành chuỗi ảnh PNG cho public/sig/.
# Làm nét dày hơn để thu nhỏ vẫn đọc rõ, đổi đầu bút xanh ngọc sang cam, lấy 30 khung/giây.
# Cách dùng: python3 scripts/xu_ly_chu_ky.py hoanghiep_1.mov public/sig
import os, sys, subprocess, tempfile, numpy as np
from PIL import Image, ImageFilter
src, out = sys.argv[1], sys.argv[2]
os.makedirs(out, exist_ok=True)
tmp = tempfile.mkdtemp()
subprocess.run(['ffmpeg', '-v', 'error', '-i', src, '-vf', 'fps=30', '-pix_fmt', 'rgba', f'{tmp}/f%03d.png'], check=True)
files = sorted(os.listdir(tmp))
bb = None
for f in files:
    b = Image.open(f'{tmp}/{f}').getchannel('A').getbbox()
    if b: bb = b if bb is None else (min(bb[0], b[0]), min(bb[1], b[1]), max(bb[2], b[2]), max(bb[3], b[3]))
pad = 24; box = (bb[0] - pad, bb[1] - pad, bb[2] + pad, bb[3] + pad)
W = 600; H = round((box[3] - box[1]) * W / (box[2] - box[0]))
for i, f in enumerate(files):
    a = np.array(Image.open(f'{tmp}/{f}').convert('RGBA').crop(box)).astype(np.float32)
    al = Image.fromarray(a[..., 3].astype(np.uint8)).filter(ImageFilter.MaxFilter(5)).filter(ImageFilter.GaussianBlur(0.8))
    cyan = (a[..., 2] > a[..., 0] + 40) & (a[..., 3] > 10)
    m = np.array(Image.fromarray((cyan * 255).astype(np.uint8)).filter(ImageFilter.MaxFilter(7))) > 0
    o = np.zeros_like(a); o[..., :3] = 255; o[m, :3] = [255, 170, 60]; o[..., 3] = np.array(al)
    Image.fromarray(o.astype(np.uint8), 'RGBA').resize((W, H), Image.LANCZOS).save(f'{out}/s{i:03d}.png')
print(len(files), 'khung,', W, 'x', H)
