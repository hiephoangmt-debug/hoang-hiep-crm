"""Từng lô Casamia Balanca: tách màu trên mặt bằng -> toạ độ thật (lat/lon) qua phép biến đổi affine."""
import json, collections, sys
import numpy as np
from PIL import Image, ImageDraw
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
src = '/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg'
M = np.array(json.load(open(S + 'casa/affine.json')))  # plan px -> zoom px
N_, W_, SCX, SCY = 15.889, 108.366, 57678.0, 60000.0
def geo(px, py):
    zx, zy = np.array([px, py, 1.0]) @ M
    return N_ - zy / SCY, W_ + zx / SCX
mz = np.sqrt(abs(np.linalg.det(M[:2])))            # zoom px / plan px
MPP = mz * 1.85                                     # mét / plan px
PXM = 1 / MPP
print('m per plan px', round(MPP, 3))
SITE = [(300, 450), (1080, 330), (1480, 40), (1760, 60), (1960, 400), (1960, 1180), (1700, 1420), (1430, 1400), (900, 1120), (480, 1100), (380, 1100), (300, 600)]
def inside(x, y, poly=SITE):
    c = False
    for i in range(len(poly)):
        x1, y1 = poly[i]; x2, y2 = poly[i - 1]
        if (y1 > y) != (y2 > y) and x < (x2 - x1) * (y - y1) / (y2 - y1) + x1: c = not c
    return c
im = np.asarray(Image.open(src).convert('RGB')).astype(np.int32)
H, W, _ = im.shape
# mã, màu, số tầng, bề ngang lô (m), chiều sâu (m)
PAL = [('SL', (244, 199, 114), 3, 8, 22.5), ('LK1', (240, 153, 110), 3, 7.3, 25), ('LK2', (248, 106, 118), 3, 7, 25), ('LK', (251, 250, 110), 3, 7, 24.5),
       ('LK5', (195, 244, 137), 3, 7.75, 24), ('B2', (247, 179, 170), 3, 10, 26), ('B1', (250, 220, 210), 3, 10, 25), ('B3', (238, 125, 240), 3, 12, 25),
       ('B4', (224, 176, 228), 2, 12, 28), ('B5', (55, 172, 240), 2, 12, 26)]
cols = np.array([c[1] for c in PAL])
d = ((im[:, :, None, :] - cols[None, None]) ** 2).sum(-1)
cls = d.argmin(-1); cls[d.min(-1) > 34 ** 2] = -1
cls[1290:, :1400] = -1
lab = np.full((H, W), -1, np.int32); comps = []
for y in range(H):
    for x in np.nonzero(cls[y] >= 0)[0]:
        if lab[y, x] >= 0 or not inside(x, y): continue
        c = cls[y, x]; q = collections.deque([(y, x)]); lab[y, x] = len(comps); px = []
        while q:
            cy, cx = q.popleft(); px.append((cx, cy))
            for ny, nx in ((cy + 1, cx), (cy - 1, cx), (cy, cx + 1), (cy, cx - 1)):
                if 0 <= ny < H and 0 <= nx < W and lab[ny, nx] < 0 and cls[ny, nx] == c:
                    lab[ny, nx] = len(comps); q.append((ny, nx))
        comps.append((c, px))
lots = []
for c, px in comps:
    if len(px) < 0.35 * PAL[c][3] * PAL[c][4] * PXM * PXM: continue
    code, _, fl, lw, ld = PAL[c]
    p = np.array(px, float); m = p.mean(0); _, _, vt = np.linalg.svd(p - m, full_matrices=False)
    a, b = vt[0], vt[1]
    pa, pb = (p - m) @ a, (p - m) @ b
    L, Wd = pa.max() - pa.min(), pb.max() - pb.min()
    if Wd < 5: continue
    ctr = m + a * (pa.max() + pa.min()) / 2 + b * (pb.max() + pb.min()) / 2
    D = ld * PXM
    if L <= 1.5 * D:      # một lô: trục dài = chiều sâu
        items = [(ctr, a)]
    else:                 # dải nhiều lô chưa tách: chia đều theo bề ngang lô
        k = max(1, round(L / (lw * PXM)))
        items = [(ctr + a * ((i + 0.5) / k - 0.5) * L, b) for i in range(k)]
    for (cx, cy), axis in items:
        lat, lon = geo(cx, cy)
        # hướng trục chiều sâu sang toạ độ thật (bắc = -z)
        e = np.array([cx + axis[0] * 10, cy + axis[1] * 10]); la2, lo2 = geo(*e)
        ang = float(np.arctan2(-(la2 - lat) * 110600, (lo2 - lon) * 107072))
        lots.append({'t': code, 'f': fl, 'lat': round(lat, 7), 'lon': round(lon, 7), 'w': lw, 'd': ld, 'a': round(ang, 4), 'px': [round(float(cx)), round(float(cy))]})
lots = [l for l in lots if not (l['px'][1] < 90 or (l['px'][0] > 1780 and l['px'][1] < 360))]
for l in lots:
    if l['px'][1] > 1255 and l['px'][0] > 1420 and l['t'] in ('B1', 'B3'): l.update(t='B4', f=2, w=12, d=28)
cnt = collections.Counter(l['t'] for l in lots)
print('lots', len(lots), dict(cnt))
site = [list(map(lambda v: round(v, 7), geo(x, y))) for x, y in SITE]
extras = {
    'hotel': {'name': 'Khách sạn Đảo Dừa', 'll': geo(1090, 880), 'w': 34, 'd': 70, 'h': 26, 'a_px': [1, -0.35]},
    'club': {'name': 'Clubhouse (3 tầng)', 'll': geo(840, 705), 'w': 22, 'd': 34, 'h': 12},
    'mall': {'name': 'Trung tâm thương mại & dịch vụ (5 tầng)', 'll': geo(870, 610), 'w': 26, 'd': 40, 'h': 19},
    'pool': {'name': 'Grand Central Park – hồ vô cực', 'll': geo(1150, 770), 'r': 45 * MPP},
    'bungalows': [geo(1900 + 25 * np.sin(i / 3), 440 + i * 22) for i in range(22)],
    'entrance': geo(395, 905),
}
json.dump({'site': site, 'lots': lots, 'extras': extras}, open(S + 'dn/casamia.json', 'w'), ensure_ascii=False, separators=(',', ':'))
vis = Image.open(src).convert('RGB'); dr = ImageDraw.Draw(vis)
for l in lots:
    dr.ellipse([l['px'][0] - 4, l['px'][1] - 4, l['px'][0] + 4, l['px'][1] + 4], outline=(0, 0, 255), width=2)
dr.polygon(SITE, outline=(255, 0, 0))
vis.save(S + 'casa/lots-geo.jpg', quality=80)
