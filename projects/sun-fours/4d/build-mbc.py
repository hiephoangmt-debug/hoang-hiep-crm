"""Mặt bằng chuẩn Tòa F2 (tường, kính, cửa, căn – vẽ lại từ bản gốc CĐT, projects/fours/mat-bang-chuan/data) → src/f2-mbc.js
cho mô hình 4D. Mỗi tờ được dời về cùng hệ toạ độ thân tháp F2 của mô hình (plans-data.js):
  - tờ tầng 8–19 khớp theo tâm đường bao thân tháp;
  - các tờ khác khớp với tờ 8–19 bằng tương quan ảnh tường (lõi thang, vách cố định trùng nhau giữa các tầng)."""
import json, pathlib, numpy as np
H = pathlib.Path(__file__).parent
R = H.parents[2]
MB = R / 'projects/fours/mat-bang-chuan/data'
s = (R / 'projects/fours/plans/plans-data.js').read_text(encoding='utf-8'); PLD = json.loads(s[s.index('{'):s.rindex('}') + 1])
ref = [b for b in PLD['F2']['bands'] if b['key'] == 'F2_8'][0]
def bb(P): xs = [p[0] for p in P]; ys = [p[1] for p in P]; return min(xs), min(ys), max(xs), max(ys)
KEYS = ['1', '2', '3', '3A', '5', '6', '7', '8']
D = {k: json.load(open(MB / f'F2_{k}.json')) for k in KEYS}
RES = .1
def raster(d, ox, oy, W, Hh):
    a = np.zeros((int(Hh / RES), int(W / RES)), np.float32)
    for w in d['walls']:
        x0, y0, x1, y1 = [int((v - o) / RES) for v, o in zip(w, (ox, oy, ox, oy))]
        a[max(0, y0):max(0, y1) + 1, max(0, x0):max(0, x1) + 1] = 1
    return a
W8 = max(d['W'] for d in D.values()) + 20; H8 = max(d['H'] for d in D.values()) + 20
A8 = raster(D['8'], -10, -10, W8, H8); F8 = np.fft.rfft2(A8)
off = {}
for k in KEYS:
    if k == '8': off[k] = (0., 0.); continue
    A = raster(D[k], -10, -10, W8, H8)
    c = np.fft.irfft2(F8 * np.conj(np.fft.rfft2(A)), A8.shape)
    iy, ix = np.unravel_index(np.argmax(c), c.shape)
    if iy > c.shape[0] // 2: iy -= c.shape[0]
    if ix > c.shape[1] // 2: ix -= c.shape[1]
    off[k] = (ix * RES, iy * RES)          # cộng vào toạ độ tờ k để trùng tờ 8–19
b8 = bb(D['8']['foot']); br = bb(ref['foot'])
gx = (br[0] + br[2]) / 2 - (b8[0] + b8[2]) / 2; gy = (br[1] + br[3]) / 2 - (b8[1] + b8[3]) / 2
out = {}; IMG = {}
for k in KEYS:
    d = D[k]; dx, dy = off[k][0] + gx, off[k][1] + gy
    P = lambda p: [round(p[0] + dx, 2), round(p[1] + dy, 2)]
    Rr = lambda r: [round(r[0] + dx, 2), round(r[1] + dy, 2), round(r[2] + dx, 2), round(r[3] + dy, 2)]
    IMG['MBC_F2_' + k] = {'src': d['src'], 'mpp': d['mpp'], 'dx': dx, 'dy': dy}
    out['F2_' + k] = {'key': 'MBC_F2_' + k, 'title': d['title'], 'foot': [P(p) for p in d['foot']], 'gardens': [],
        'walls': [Rr(r) for r in d['walls']], 'glass': [Rr(r) for r in d['glass']],
        'doors': [{'h': P(x['h']), 'l': P(x['leaf']), 'c': P(x['closed']), 'r': round(x['r'], 2)} for x in d['doors']],
        'units': [{'code': u['code'], 'type': u['type'], 'color': u['color'], 'tt': u.get('tt'), 'tim': u.get('tim'), 'san': u.get('san'), 'poly': [P(p) for p in u['poly']]} for u in d['units']]}
    print(k, 'dời', [round(v, 2) for v in off[k]], len(d['walls']), 'tường', len(d['units']), 'căn')
FLOORS = {'1': 'F2_1', '2': 'F2_2', '3': 'F2_3', '3A': 'F2_3A', '5': 'F2_5', '6': 'F2_6', '7': 'F2_7'}
for f in ['8', '9', '10', '11', '12', '12A', '15', '16', '17', '18', '19']: FLOORS[f] = 'F2_8'
js = '/* Mặt bằng chuẩn Tòa F2 (vẽ lại từ bản gốc CĐT) – sinh bởi build-mbc.py */\nwindow.FS_MBC=' + json.dumps({'F2': {'floors': FLOORS, 'sheets': out}}, separators=(',', ':'), ensure_ascii=False) + ';\n'
(H / 'src/f2-mbc.js').write_text(js, encoding='utf-8'); print(len(js) // 1024, 'KB')
json.dump(IMG, open(H / 'src/f2-mbc-img.json', 'w'), indent=1)
