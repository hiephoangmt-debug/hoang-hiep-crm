"""Nền dự án vẽ theo mặt bằng: đường, kênh/hồ, cây xanh, sân -> casa-ground.png (có kênh alpha theo ranh dự án).
Ghi thêm vào casamia.json: toạ độ 3 góc ảnh (để phủ đúng chỗ) và phía giáp nước của từng lô (ws)."""
import json, numpy as np
from PIL import Image, ImageDraw, ImageFilter
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
src = '/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg'
exec(open(S + 'casa/geo.py').read().split("im = np.asarray")[0])   # lấy M, geo, SITE, KM...
img = Image.open(src).convert('RGB'); a = np.asarray(img).astype(int); H, W, _ = a.shape
r, g, b = a[..., 0], a[..., 1], a[..., 2]; mx, mn = a.max(-1), a.min(-1); br = a.mean(-1)
cat = np.zeros((H, W), np.uint8)                                   # 0 khác/giữ nguyên
LOTC = np.array([(244, 199, 114), (240, 153, 110), (248, 106, 118), (251, 250, 110), (195, 244, 137), (247, 179, 170), (250, 220, 210), (238, 125, 240), (224, 176, 228), (55, 172, 240)])
lot = (((a[:, :, None, :] - LOTC[None, None]) ** 2).sum(-1).min(-1) < 40 ** 2)
road = (mx - mn < 22) & (br > 140) & (br < 225)
lilac = (r > 170) & (b > 170) & (g < 160)                             # vòng tròn ký hiệu T trên đường
water = (g > r + 12) & (np.abs(g - b) < 28) & (g < 165) & (r < 120)
pool = (g > 165) & (b > 150) & (r < 160)
green = (g > r + 8) & (g > b + 10) & ~water
cat[road | lilac] = 1; cat[lot] = 2; cat[water] = 3; cat[pool] = 4; cat[green] = 5
cim = Image.fromarray(cat).filter(ImageFilter.ModeFilter(7)); cat = np.asarray(cim)
out = np.asarray(img.filter(ImageFilter.MedianFilter(5))).copy()
out[cat == 1] = (92, 96, 102); out[cat == 2] = (212, 204, 186); out[cat == 3] = (46, 98, 112); out[cat == 4] = (110, 200, 205)
mask = Image.new('L', (W, H), 0); ImageDraw.Draw(mask).polygon(SITE, fill=255)
rgba = Image.fromarray(out.astype(np.uint8)).convert('RGBA'); rgba.putalpha(mask)
rgba = rgba.crop((300, 30, 1970, 1410))
rgba.quantize(64, method=Image.Quantize.FASTOCTREE).save(S + 'dn/casa-ground.png', optimize=True)
d = json.load(open(S + 'dn/casamia.json'))
d['ground'] = {'img': 'casa-ground.png', 'c00': list(geo(300, 30)), 'c10': list(geo(1970, 30)), 'c01': list(geo(300, 1410))}
# phía giáp nước của từng lô (theo mặt bằng)
Ji = np.linalg.inv(JM)
def topx(lat, lon): return Ji @ (np.array([(lon - W_) * 107072, (N_ - lat) * 110600]) - TM)
wat = (cat == 3)
for l in d['lots']:
    c = np.array([(l['lon'] - W_) * 107072, (N_ - l['lat']) * 110600]); u = np.array([np.cos(l['a']), np.sin(l['a'])])
    l['ws'] = 0
    for sg in (1, -1):
        hits = 0
        for k in (2, 5, 8):
            px = Ji @ (c + u * sg * (l['d'] / 2 + k) - TM); x, y = int(px[0]), int(px[1])
            hits += 0 <= x < W and 0 <= y < H and wat[y, x]
        if hits >= 2: l['ws'] = sg
print('lô giáp nước', sum(1 for l in d['lots'] if l['ws']), '/', len(d['lots']))
json.dump(d, open(S + 'dn/casamia.json', 'w'), ensure_ascii=False, separators=(',', ':'))
Image.fromarray(out.astype(np.uint8)).resize((1024, 793)).save(S + 'casa/ground-prev.jpg', quality=80)
