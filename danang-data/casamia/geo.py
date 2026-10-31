"""Từng lô Casamia Balanca: tách màu trên mặt bằng -> toạ độ thật (lat/lon) qua phép biến đổi affine."""
import json, collections, sys
import numpy as np
from PIL import Image, ImageDraw
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
src = '/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg'
import os
M = np.array(json.load(open(S + ('casa/affine2.json' if os.path.exists(S + 'casa/affine2.json') else 'casa/affine.json'))))  # plan px -> zoom px (affine2: đã hiệu chỉnh theo kích thước lô chuẩn)
N_, W_, SCX, SCY = 15.889, 108.366, 57678.0, 60000.0
def geo(px, py):
    zx, zy = np.array([px, py, 1.0]) @ M
    return N_ - zy / SCY, W_ + zx / SCX
KM = np.diag([107072 / SCX, 110600 / SCY]); JM = KM @ M[:2].T; TM = KM @ M[2]   # plan px -> mét (đông, nam)
MPP = float(np.sqrt(abs(np.linalg.det(JM))))          # mét / plan px
PXM = 1 / MPP
print('m per plan px', round(MPP, 3))
SITE = [(330, 465), (560, 395), (1065, 330), (1360, 100), (1500, 38), (1640, 40), (1790, 110), (1880, 400), (1955, 700), (1950, 1010), (1870, 1180), (1700, 1290), (1480, 1400), (1440, 1395), (1410, 1335), (1150, 1225), (940, 1110), (930, 1080), (500, 1080), (440, 1095), (395, 1100), (380, 900), (340, 700)]
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
# --- Nhận nguyên DẢI nhà theo màu (lấp các vạch chia lô), rồi chia đều thành lô theo bề ngang chuẩn ---
from PIL import ImageFilter
sitem = np.zeros((H, W), bool)
_m = Image.new('L', (W, H), 0); ImageDraw.Draw(_m).polygon(SITE, fill=1); sitem = np.asarray(_m).astype(bool)
def components(mask):
    lab = np.full(mask.shape, -1, np.int32); out = []
    ys, xs = np.nonzero(mask)
    for y0, x0 in zip(ys, xs):
        if lab[y0, x0] >= 0: continue
        q = collections.deque([(y0, x0)]); lab[y0, x0] = len(out); px = []
        while q:
            cy, cx = q.popleft(); px.append((cx, cy))
            for ny, nx in ((cy + 1, cx), (cy - 1, cx), (cy, cx + 1), (cy, cx - 1)):
                if 0 <= ny < H and 0 <= nx < W and lab[ny, nx] < 0 and mask[ny, nx]:
                    lab[ny, nx] = len(out); q.append((ny, nx))
        out.append(np.array(px, float))
    return out
mlen = lambda v: float(np.linalg.norm(JM @ v))
lots = []
def place(p, code, fl, lw, ld, depth=0, pax=None):
    if len(p) < 30: return
    m = p.mean(0); _, _, vt = np.linalg.svd(p - m, full_matrices=False); a, b = vt[0], vt[1]
    if pax is not None and abs(b @ pax) > abs(a @ pax): a, b = b, a           # giữ trục dọc dãy theo dải mẹ (dải cong)
    pa, pb = (p - m) @ a, (p - m) @ b
    L, Wd = pa.max() - pa.min(), pb.max() - pb.min()
    Lm, Wm = L * mlen(a), Wd * mlen(b)
    if pax is None and Lm < Wm: a, b, pa, pb, L, Wd, Lm, Wm = b, a, pb, pa, Wd, L, Wm, Lm   # trục dài = dọc dãy
    fill = len(p) / max(1, L * Wd)
    if fill < 0.72 and Lm > 3 * lw and depth < 5:                            # dải cong: cắt đôi
        cut = np.median(pa); place(p[pa <= cut], code, fl, lw, ld, depth + 1, a); place(p[pa > cut], code, fl, lw, ld, depth + 1, a); return
    if Wm < 0.55 * ld or Lm < 0.6 * lw: return
    nr = max(1, round(Wm / ld)); n = max(1, round(Lm / lw))
    ctr = m + a * (pa.max() + pa.min()) / 2 + b * (pb.max() + pb.min()) / 2
    for r in range(nr):
        for i in range(n):
            c = ctr + a * ((i + 0.5) / n - 0.5) * L + b * ((r + 0.5) / nr - 0.5) * Wd
            lat, lon = geo(*c)
            e = c + b * 10; la2, lo2 = geo(*e)
            ang = float(np.arctan2(-(la2 - lat) * 110600, (lo2 - lon) * 107072))
            lots.append({'t': code, 'f': fl, 'lat': round(lat, 7), 'lon': round(lon, 7), 'w': round(Lm / n, 2), 'd': round(Wm / nr, 2), 'a': round(ang, 4),
                         'px': [round(float(c[0])), round(float(c[1]))], 'strip': len(STRIPS), 'si': i, 'sn': n, 'sr': r, 'snr': nr})
    STRIPS.append(code)
STRIPS = []
_br = im.mean(-1); TEXT = (_br < 85) & ((im.max(-1) - im.min(-1)) < 30)
for ci, (code, col, fl, lw, ld) in enumerate(PAL):
    m1 = (cls == ci) & sitem
    near = np.asarray(Image.fromarray(m1.astype(np.uint8) * 255).filter(ImageFilter.MaxFilter(13))) > 127
    m1 = m1 | (near & TEXT)                                                 # chữ/số in trên lô thuộc về dải
    mk = Image.fromarray(m1.astype(np.uint8) * 255).filter(ImageFilter.MaxFilter(5)).filter(ImageFilter.MinFilter(7))
    for p in components(np.asarray(mk) > 127):
        if len(p) * MPP * MPP < 0.6 * lw * ld: continue
        place(p, code, fl, lw, ld)
print('dải', len(STRIPS))
# --- Dải đo tay trên mặt bằng (nơi chữ in đè làm vỡ dải): P0 -> P1 dọc dãy, v = vectơ chiều sâu, n lô ---
def manual(code, fl, P0, P1, v, n):
    P0, P1, v = np.array(P0, float), np.array(P1, float), np.array(v, float)
    Lm, Dm = mlen(P1 - P0), mlen(v)
    for i in range(n):
        c = P0 + (P1 - P0) * (i + 0.5) / n + v / 2
        lat, lon = geo(*c); la2, lo2 = geo(*(c + v / np.linalg.norm(v) * 10))
        lots.append({'t': code, 'f': fl, 'lat': round(lat, 7), 'lon': round(lon, 7), 'w': round(Lm / n, 2), 'd': round(Dm, 2),
                     'a': round(float(np.arctan2(-(la2 - lat) * 110600, (lo2 - lon) * 107072)), 4), 'px': [round(float(c[0])), round(float(c[1]))]})
inbox = lambda l, x0, y0, x1, y1: x0 <= l['px'][0] <= x1 and y0 <= l['px'][1] <= y1
lots = [l for l in lots if not (l['t'] in ('B3', 'B4', 'B1', 'B2') and inbox(l, 1440, 1150, 1720, 1420))]
lots = [l for l in lots if not (l['t'].startswith('LK') and inbox(l, 820, 680, 930, 800))]     # khu bãi xe, không phải lô
_bt3 = [(1395, 1196), (1625, 1075), (1651, 1124), (1421, 1245)]
lots = [l for l in lots if not inside(l['px'][0], l['px'][1], _bt3)]
manual('B1', 3, (1395, 1196), (1625, 1075), (26, 49), 10)      # BT3: 10 lô 10 × 25 m
manual('B3', 3, (1477, 1250), (1652, 1177), (23, 57), 7)        # BT2: 7 lô 12 × 25 m
manual('B4', 2, (1467, 1342), (1695, 1240), (28, 53), 9)        # BT1: 9 lô 12 × 28 m (2 tầng)
lk4 = [l for l in lots if l['t'] == 'LK' and l['px'][1] > 860]
if lk4:
    ang = float(np.median([l['a'] for l in lk4]))
    for l in lots:
        if l['t'] == 'LK5': l['a'] = ang
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
    l.update(t='PH', row=row, side=side, fa=wang(l['px'], front), ua=wang(l['px'], RU), w=8, d=22.25, f=3)
    blocks[(row, side)].append((t, l))
for (row, side), items in list(blocks.items()): pass
# --- Xếp thẳng hàng từng dãy lô đúng bề ngang chuẩn ---
tom = lambda p: JM @ np.asarray(p, float) + TM
frm = lambda m: (N_ - m[1] / 110600, W_ + m[0] / 107072)
groups = collections.defaultdict(list)
for l in lots: groups[(l['t'], l.get('row'), l.get('side'), l['px'][0] < 900 if l['t'] == 'SL' else 0)].append(l)
# số căn mỗi nửa dãy Park Home theo số ghi trên mặt bằng (SL1 18, SL2–SL4 17)
TARGET = {('SL1', 'L'): 9, ('SL1', 'R'): 9, ('SL2', 'L'): 8, ('SL2', 'R'): 9, ('SL3', 'L'): 8, ('SL3', 'R'): 9, ('SL4', 'L'): 7, ('SL4', 'R'): 10}
newlots = []
nchain = 0
for key, G0 in groups.items():
    if key[0] != 'PH': continue
    P = np.array([tom(l['px']) for l in G0]); w = G0[0]['w']
    dep = np.array([[np.cos(l['a']), np.sin(l['a'])] for l in G0])
    par = list(range(len(G0)))
    def f(i):
        while par[i] != i: par[i] = par[par[i]]; i = par[i]
        return i
    for i in range(len(G0)):
        for j in range(i + 1, len(G0)):
            v = P[j] - P[i]
            if np.linalg.norm(v) < 1.45 * w and abs(v @ dep[i]) < 4: par[f(i)] = f(j)
    comps = collections.defaultdict(list)
    for i in range(len(G0)): comps[f(i)].append(i)
    if key[0] == 'PH': comps = {0: list(range(len(G0)))}   # mỗi nửa dãy Park Home là một dãy liền
    for idx in comps.values():
        Q = P[idx]; c = Q.mean(0)
        if len(idx) >= 3: d = np.linalg.svd(Q - c)[2][0]
        elif len(idx) == 2: d = (Q[1] - Q[0]) / np.linalg.norm(Q[1] - Q[0])
        else: d = np.array([-dep[idx[0]][1], dep[idx[0]][0]])
        if key[0] == 'PH':
            ru = JM @ RU
            if d @ ru < 0: d = -d
        order = sorted(range(len(idx)), key=lambda k: (Q[k] - c) @ d)
        if key[0] == 'PH' and len(comps) == 1:
            tg = TARGET[(key[1], key[2])]
            while len(order) > tg: lots.remove(G0[idx[order.pop()]])
            while len(order) < tg:
                cp = dict(G0[idx[order[-1]]]); newlots.append(cp); G0.append(cp); idx.append(len(G0) - 1); order.append(len(idx) - 1)
        nrm = np.array([-d[1], d[0]])
        for rank, k in enumerate(order):
            l = G0[idx[k]]; m = c + d * (rank - (len(idx) - 1) / 2) * w
            l['lat'], l['lon'] = [round(v, 7) for v in frm(m)]
            l['a'] = round(float(np.arctan2(nrm[1], nrm[0])), 4)
            if key[0] == 'PH':
                fr = JM @ (RN if l['row'] in ('SL1', 'SL3') else -RN)
                fn = nrm if fr @ nrm > 0 else -nrm
                l['ua'] = round(float(np.arctan2(d[1], d[0])), 4); l['fa'] = round(float(np.arctan2(fn[1], fn[0])), 4)
        nchain += 1
lots += newlots
# ghép song lập / đơn lập Park Home theo thứ tự dọc dãy (sau khi căn thẳng)
for (row, side) in TARGET:
    ls = sorted([l for l in lots if l['t'] == 'PH' and l['row'] == row and l['side'] == side], key=lambda l: (l['lon'] * 107072) * np.cos(l['ua']) + (-l['lat'] * 110600) * np.sin(l['ua']))
    single = {0, len(ls) - 1} if row in ('SL3', 'SL4') else ({len(ls) - 1} if side == 'L' else {0})
    i = 0
    while i < len(ls):
        if i in single or i + 1 >= len(ls) or (i + 1) in single: ls[i]['pair'] = 0; i += 1
        else: ls[i]['pair'], ls[i + 1]['pair'] = 1, -1; i += 2
print('dãy lô đã căn thẳng', nchain, '| Park Home', sum(l['t'] == 'PH' for l in lots), 'đơn lập', sum(l.get('pair') == 0 for l in lots if l['t'] == 'PH'))
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
