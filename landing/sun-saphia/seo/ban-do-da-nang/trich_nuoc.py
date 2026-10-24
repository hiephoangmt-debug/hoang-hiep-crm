"""Trích vùng nước (biển, vịnh, sông) từ ảnh chụp Google Maps có thước 2 km → đa giác kinh/vĩ độ (nuoc.json).
Quy đổi: thước 2 km = 165 px → 82,5 px/km; neo theo ghim cầu Thuận Phước & Ngũ Hành Sơn (kiểm tra bằng chùa Linh Ứng, lệch < 100 m)."""
import cv2, numpy as np, json, pathlib
here = pathlib.Path(__file__).parent
im = cv2.imread(str(here / 'google-maps-tham-chieu.png'))
X0, Y0 = 48, 500                       # góc trên-trái vùng bản đồ trong ảnh
c = im[Y0:1900, X0:1243].astype(int)
b, g, r = c[:, :, 0], c[:, :, 1], c[:, :, 2]
m = ((abs(r - 160) < 22) & (abs(g - 216) < 18) & (abs(b - 235) < 18)).astype(np.uint8) * 255
m = cv2.morphologyEx(m, cv2.MORPH_CLOSE, np.ones((9, 9), np.uint8))
m = cv2.morphologyEx(m, cv2.MORPH_OPEN, np.ones((5, 5), np.uint8))
# xoá chữ / ghim / nút của Google nằm trên mặt nước
for x1, y1, x2, y2 in [(195, 125, 352, 220), (25, 400, 372, 462), (372, 395, 432, 470), (705, 442, 892, 532),
                       (1080, 385, 1195, 445), (1145, 345, 1195, 385), (1060, 30, 1165, 130), (650, 688, 838, 790), (852, 1288, 1115, 1385),
                       (0, 0, 40, 40), (1150, 0, 1195, 40)]:
    m[y1:y2, x1:x2] = 255
m = m[:1400]
m = ((cv2.GaussianBlur(m, (0, 0), 6) > 127) * 255).astype(np.uint8)
# bỏ đốm nhỏ
n, lab, st, _ = cv2.connectedComponentsWithStats(m, 8)
for i in range(1, n):
    if st[i, 4] < 400: m[lab == i] = 0
inv = 255 - m; n, lab, st, _ = cv2.connectedComponentsWithStats(inv, 8)
for i in range(1, n):
    x, y, w, h, a = st[i]
    if a < 2500 and x > 0 and y > 0 and x + w < m.shape[1] and y + h < m.shape[0]: m[lab == i] = 255
cv2.imwrite(str(here / 'mat-na-nuoc.png'), m)
KX, KY = 8826.0, 9133.0                # px / độ kinh, px / độ vĩ
def ll(x, y): return (round(108.2232 + (x + X0 - 464.5) / KX, 6), round(16.0915 - (y + Y0 - 982) / KY, 6))
cs, hi = cv2.findContours(m, cv2.RETR_CCOMP, cv2.CHAIN_APPROX_NONE)
polys = []
for ct in cs:
    if cv2.contourArea(ct) < 300: continue
    ap = cv2.approxPolyDP(ct, 1.2, True)[:, 0, :]
    H_, W_ = m.shape
    def ex(x, y):   # điểm nằm sát mép khung → đẩy ra ngoài 3 px để khớp với phần vẽ ngoài khung
        x = -3 if x <= 1 else (W_ + 3 if x >= W_ - 2 else x); y = -3 if y <= 1 else (H_ + 3 if y >= H_ - 2 else y); return x, y
    polys.append([ll(*ex(int(x), int(y))) for x, y in ap])
# bờ biển phía đông (cột nước đầu tiên từ x=600) để dựng đường Võ Nguyên Giáp – Trường Sa
coast = []
for y in range(380, 1400, 10):
    row = m[y, :]; l = np.where(row == 0)[0]
    if len(l) and l[-1] + 1 < m.shape[1]: coast.append((y, int(l[-1]) + 1))
# tim sông Hàn theo hàng
def river(y, lo=400, hi=620):
    row = m[y, lo:hi]; w = np.where(row > 0)[0]
    if not len(w): return None
    # đoạn liền đầu tiên
    s = w[0]; e = s
    while e + 1 < len(row) and row[e + 1] > 0: e += 1
    return ll((s + e) / 2 + lo, y), ll(s + lo, y), ll(e + lo, y)
box = [ll(0, 0), ll(m.shape[1], m.shape[0])]
json.dump({'polys': polys, 'coast': [(ll(x, y)) for y, x in coast], 'box': box,
           'river': {str(y): river(y) for y in range(440, 1100, 4)}}, open(here / 'nuoc.json', 'w'))
print(len(polys), box)
