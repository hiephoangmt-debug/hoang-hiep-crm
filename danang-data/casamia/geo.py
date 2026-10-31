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
# --- Park Home (SL1–SL4): dãy, song lập/đơn lập, hướng mặt tiền ---
RU, RN = np.array([0.975, -0.22]), np.array([0.22, 0.975])   # dọc dãy, vuông góc dãy (hướng xuống)
def wang(px, v):
    la, lo = geo(*px); la2, lo2 = geo(px[0] + v[0] * 10, px[1] + v[1] * 10)
    return round(float(np.arctan2(-(la2 - la) * 110600, (lo2 - lo) * 107072)), 4)
blocks = collections.defaultdict(list)
for l in lots:
    if l['t'] != 'SL' or l['px'][0] >= 900: continue
    c = l['px'][1] + 0.226 * l['px'][0]
    row = 'SL1' if c < 730 else 'SL2' if c < 790 else 'SL3' if c < 860 else 'SL4'
    t = float(np.dot(l['px'], RU)); side = 'L' if t < 420 else 'R'
    front = RN if row in ('SL1', 'SL3') else -RN
    l.update(t='PH', row=row, fa=wang(l['px'], front), ua=wang(l['px'], RU), w=8, d=22.25, f=3)
    blocks[(row, side)].append((t, l))
for (row, side), items in blocks.items():
    items.sort(key=lambda it: it[0]); ls = [l for _, l in items]
    single = set()
    if row in ('SL3', 'SL4'): single |= {0, len(ls) - 1}                       # đơn lập ở đầu hồi
    else: single |= {len(ls) - 1} if side == 'L' else {0}                       # đơn lập giáp vệt cây xanh giữa dãy
    i = 0
    while i < len(ls):
        if i in single or i + 1 >= len(ls) or (i + 1) in single:
            ls[i].update(pair=0); i += 1
        else:
            ls[i].update(pair=1); ls[i + 1].update(pair=-1); i += 2               # pair = phía (dọc dãy) có nhà ghép
print('park home', {k: len(v) for k, v in sorted(blocks.items())}, 'đơn lập', sum(1 for l in lots if l.get('pair') == 0))
G = lambda pts: [list(geo(x, y)) for x, y in pts]
def zone(sel):
    ps = [l['px'] for l in lots if sel(l)]
    return list(geo(sum(p[0] for p in ps) / len(ps), sum(p[1] for p in ps) / len(ps)))
extras = {
    # khách sạn Đảo Dừa: dãy khối đất nung cong ôm mép đảo dừa phía đông nam
    'hotelArc': G([(1655, 945), (1690, 985), (1730, 1022), (1775, 1050), (1825, 1072), (1880, 1088)]),
    'hotelPool': list(geo(1830, 1130)), 'conf': list(geo(1770, 990)),
    # đường từ Grand Central -> cầu cong qua kênh -> dọc đảo dừa tới khách sạn
    'road': G([(1180, 965), (1300, 870), (1400, 778), (1440, 760)]),
    'bridge': G([(1440, 760), (1470, 746), (1500, 740), (1540, 750), (1568, 778), (1580, 815), (1585, 860)]),
    'roadHotel': G([(1585, 860), (1610, 910), (1640, 950), (1670, 1000), (1695, 1050), (1720, 1090), (1745, 1130)]),
    # đại lộ La Duna: cổng chào hoa giấy -> trung tâm thương mại -> quảng trường nhạc nước
    'boulevard': G([(395, 910), (475, 893), (600, 870), (750, 843), (900, 818), (975, 805), (1040, 785)]),
    'gate': list(geo(400, 905)),
    'mall': {'ll': list(geo(870, 725)), 'glass': list(geo(905, 700))},
    'club': {'ll': list(geo(1110, 905)), 'pool': list(geo(1100, 852))},
    'fountain': {'ll': list(geo(1175, 765)), 'r': 75 * MPP},
    'plaza': {'ll': list(geo(1085, 770)), 'r': 45 * MPP},
    'bungalows': G([(1900 + 25 * np.sin(i / 3), 440 + i * 22) for i in range(22)]),
    'zones': {
        'Phân khu La Riva – Waterside Villa': zone(lambda l: l['t'] in ('B1', 'B3', 'B4') and l['px'][1] > 850),
        'Forestside Villa': zone(lambda l: l['t'] in ('B2', 'B5', 'B3', 'B1') and l['px'][1] < 700 and l['px'][0] > 1000),
        'Park Villa': zone(lambda l: l['t'] == 'SL' and l['px'][0] > 900),
        'Park Home (SL1–SL4)': zone(lambda l: l['t'] == 'PH'),
        'The Boutique (Đại lộ La Duna)': zone(lambda l: l['t'].startswith('LK')),
    },
}
json.dump({'site': site, 'lots': lots, 'extras': extras}, open(S + 'dn/casamia.json', 'w'), ensure_ascii=False, separators=(',', ':'))
vis = Image.open(src).convert('RGB'); dr = ImageDraw.Draw(vis)
for l in lots:
    dr.ellipse([l['px'][0] - 4, l['px'][1] - 4, l['px'][0] + 4, l['px'][1] + 4], outline=(0, 0, 255), width=2)
dr.polygon(SITE, outline=(255, 0, 0))
vis.save(S + 'casa/lots-geo.jpg', quality=80)
