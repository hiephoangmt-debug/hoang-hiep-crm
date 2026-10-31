"""Hiệu chỉnh tỉ lệ mặt bằng theo kích thước lô chuẩn (bề ngang lô) -> affine2.json.
Giữ nguyên hướng xoay và giữ lối vào chính trên đường Võ Chí Công cố định."""
import json, numpy as np
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
M = np.array(json.load(open(S + 'casa/affine.json')))
K = np.diag([107072 / 57678, 110600 / 60000])           # zoom px -> mét
J0 = K @ M[:2].T; t0 = K @ M[2]                           # mét = J0 @ px + t0
lots = json.load(open(S + 'dn/casamia.json'))['lots']
W = {'PH': 8, 'SL': 8, 'LK': 7, 'LK1': 7.3, 'LK2': 7, 'LK5': 7.75, 'B1': 10, 'B2': 10, 'B3': 12, 'B4': 12, 'B5': 12}
rows, rhs = [], []
for t, w in W.items():
    P = np.array([l['px'] for l in lots if l['t'] == t], float)
    for i, p in enumerate(P):
        d = np.linalg.norm(P - p, axis=1); d[i] = 1e9; j = d.argmin()
        v = P[j] - p
        if d[j] > 1.6 * w / 0.5: continue
        rows.append([v[0] ** 2, 2 * v[0] * v[1], v[1] ** 2]); rhs.append(w ** 2)
A, b = np.array(rows), np.array(rhs)
g = np.linalg.lstsq(A, b, rcond=None)[0]
for _ in range(3):  # bỏ ngoại lai (cặp không kề nhau)
    r = np.sqrt(np.abs(A @ g)) - np.sqrt(b); keep = np.abs(r) < 2.5
    g = np.linalg.lstsq(A[keep], b[keep], rcond=None)[0]
G = np.array([[g[0], g[1]], [g[1], g[2]]])
ev, V = np.linalg.eigh(G); Sq = V @ np.diag(np.sqrt(ev)) @ V.T
U, _, Vt = np.linalg.svd(J0); R = U @ Vt                  # hướng xoay cũ
J = R @ Sq
ent = np.array([395, 905.]); t = J0 @ ent + t0 - J @ ent   # giữ lối vào cố định
print('m/px cũ', np.linalg.norm(J0, axis=0), '-> mới', np.linalg.norm(J, axis=0), 'dùng', keep.sum(), 'cặp lô')
Ki = np.linalg.inv(K)
M2 = np.vstack([(Ki @ J).T, Ki @ t])
json.dump(M2.tolist(), open(S + 'casa/affine2.json', 'w'))
