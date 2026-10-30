"""Ảnh mặt bằng tầng CĐT (bản gốc) cắt theo từng tòa, nền trắng → trong suốt, để đặt lên mặt cắt tòa nhà trong mô hình 4D.
Toạ độ đặt ảnh = đúng hệ toạ độ thân tháp (plans-data.js / mặt bằng chuẩn F2) nên ảnh trùng khít khối tháp và vùng bấm căn.
Chạy: python3 build-planimg.py <thư mục ảnh F2 gốc> <thư mục ảnh F1, F5 (2560 px)>"""
import json, pathlib, sys
import numpy as np
from PIL import Image
H = pathlib.Path(__file__).parent; R = H.parents[2]
F2DIR, UP = pathlib.Path(sys.argv[1]), pathlib.Path(sys.argv[2])
s = (R / 'projects/fours/plans/plans-data.js').read_text(encoding='utf-8'); PL = json.loads(s[s.index('{'):s.rindex('}') + 1])
s = (H / 'src/f2-mbc.js').read_text(encoding='utf-8'); MBC = json.loads(s[s.index('=') + 1:s.rindex(';')])['F2']['sheets']
MI = json.load(open(H / 'src/f2-mbc-img.json'))
OUT = H / 'plan-img'; OUT.mkdir(exist_ok=True)
def bb(B):
    P = list(B['foot']) + [p for G in B.get('gardens', []) for p in G]
    return [min(p[0] for p in P), min(p[1] for p in P), max(p[0] for p in P), max(p[1] for p in P)]
def cut(img, key, b, toPx, MAXW=2600):
    m = 2.5; b = [b[0] - m, b[1] - m, b[2] + m, b[3] + m]
    x0, y0 = toPx(b[0], b[1]); x1, y1 = toPx(b[2], b[3])
    im = Image.open(img).convert('RGB'); x0, y0 = max(0, int(x0)), max(0, int(y0)); x1, y1 = min(im.width, int(x1) + 1), min(im.height, int(y1) + 1)
    c = im.crop((x0, y0, x1, y1)); sc = min(1, MAXW / c.width)
    if sc < 1: c = c.resize((round(c.width * sc), round(c.height * sc)), Image.LANCZOS)
    a = np.asarray(c).astype(np.int16); al = np.clip((255 - a.min(axis=2)) * 6, 0, 255).astype(np.uint8)   # nền trắng → trong suốt
    o = Image.fromarray(np.dstack([a.astype(np.uint8), al]), 'RGBA'); o.save(OUT / (key + '.webp'), 'WEBP', quality=82, method=6)
    # toạ độ thật (m) của mép ảnh sau khi cắt
    return key
info = {}
for k, B in MBC.items():
    d = MI[B['key']]; src = F2DIR / d['src']
    toPx = lambda x, y, d=d: ((x - d['dx']) / d['mpp'], (y - d['dy']) / d['mpp'])
    b = bb(B); m = 2.5; x0, y0 = toPx(b[0] - m, b[1] - m); x0, y0 = max(0, int(x0)), max(0, int(y0))
    x1, y1 = toPx(b[2] + m, b[3] + m); im = Image.open(src); x1, y1 = min(im.width, int(x1) + 1), min(im.height, int(y1) + 1)
    cut(src, B['key'], b, toPx)
    info[B['key']] = [round(x0 * d['mpp'] + d['dx'], 3), round(y0 * d['mpp'] + d['dy'], 3), round(x1 * d['mpp'] + d['dx'], 3), round(y1 * d['mpp'] + d['dy'], 3)]
for t in ('F1', 'F5'):
    T = PL[t]; mpp = T['mpp']; ox, oy = T['originPx']
    toPx = lambda x, y: (x / mpp + ox, y / mpp + oy)
    for B in T['bands']:
        src = UP / B['src']; b = bb(B); m = 2.5; x0, y0 = toPx(b[0] - m, b[1] - m); x0, y0 = max(0, int(x0)), max(0, int(y0))
        x1, y1 = toPx(b[2] + m, b[3] + m); im = Image.open(src); x1, y1 = min(im.width, int(x1) + 1), min(im.height, int(y1) + 1)
        cut(src, B['key'], b, toPx)
        info[B['key']] = [round((x0 - ox) * mpp, 3), round((y0 - oy) * mpp, 3), round((x1 - ox) * mpp, 3), round((y1 - oy) * mpp, 3)]
(H / 'src/plan-img.js').write_text('/* Ảnh mặt bằng CĐT cắt theo tòa: [x0,y0,x1,y1] (m, hệ toạ độ thân tháp) – sinh bởi build-planimg.py */\nwindow.FS_PIMG=' + json.dumps(info) + ';\n')
for k in sorted(info): print(k, info[k], (OUT / (k + '.webp')).stat().st_size // 1024, 'KB')
