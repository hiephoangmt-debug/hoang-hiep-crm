"""Khu sông Hàn chi tiết: nhà Overture + chiều cao OSM (hoặc ước lượng) + màu mái lấy từ ảnh vệ tinh, cây từ ảnh vệ tinh.
python3 dn-chi-tiet/build.py <thư mục ra>  -> bld.bin, trees.bin, sat.jpg, meta.json"""
import gzip, json, math, os, struct, sys, hashlib
import numpy as np
from PIL import Image
H = os.path.dirname(os.path.abspath(__file__)); OUT = sys.argv[1]; os.makedirs(OUT, exist_ok=True)
sat = json.load(open(os.path.join(H, 'raw/sat.json'))); S, W, N, E = sat['bbox']
LAT0, LON0 = (S + N) / 2, (W + E) / 2
KX = 111320 * math.cos(math.radians(LAT0)); KZ = 110600
P = lambda lat, lon: ((lon - LON0) * KX, -(lat - LAT0) * KZ)
img = Image.open(os.path.join(H, 'raw/sat.jpg')).convert('RGB'); IW, IH = img.size; A = np.asarray(img).astype(np.int32)
def tx(lon): return (lon + 180) / 360
def ty(lat): return (1 - math.asinh(math.tan(math.radians(lat))) / math.pi) / 2
X0, X1, Y0, Y1 = tx(W), tx(E), ty(N), ty(S)
def pix(lat, lon): return (tx(lon) - X0) / (X1 - X0) * IW, (ty(lat) - Y0) / (Y1 - Y0) * IH
# --- chiều cao OSM ---
osm = []
raw = os.path.join(H, '../danang-data/raw/buildings.json.gz')
for e in json.load(gzip.open(raw))['elements']:
    t = e.get('tags', {}); g = e.get('geometry')
    if not g or e['type'] != 'way': continue
    h = None
    try:
        if 'height' in t: h = float(str(t['height']).split()[0].replace(',', '.').rstrip('m'))
        elif 'building:levels' in t: h = float(t['building:levels']) * 3.4 + 1
    except ValueError: pass
    if not h: continue
    la = [p['lat'] for p in g]; lo = [p['lon'] for p in g]
    if max(la) < S or min(la) > N or max(lo) < W or min(lo) > E: continue
    osm.append((min(la), max(la), min(lo), max(lo), [(p['lon'], p['lat']) for p in g], h, t.get('name', '')))
def inpoly(x, y, poly):
    c = False
    for i in range(len(poly)):
        x1, y1 = poly[i]; x2, y2 = poly[i - 1]
        if (y1 > y) != (y2 > y) and x < (x2 - x1) * (y - y1) / (y2 - y1) + x1: c = not c
    return c
def osm_h(lat, lon):
    for a, b, c, d, poly, h, n in osm:
        if a <= lat <= b and c <= lon <= d and inpoly(lon, lat, poly): return h, n
    return None, ''
def area(r): return abs(sum(r[i][0] * r[i - 1][1] - r[i - 1][0] * r[i][1] for i in range(len(r)))) / 2
def rnd(s): return int(hashlib.md5(s.encode()).hexdigest()[:8], 16) / 0xffffffff
out = bytearray(); n = 0; tall = []; stat = {'osm': 0, 'ov': 0, 'est': 0}
mask = Image.new('L', (IW, IH), 0)
from PIL import ImageDraw
md = ImageDraw.Draw(mask)
for f in json.load(gzip.open(os.path.join(H, 'raw/buildings.geojson.gz')))['features']:
    g = f['geometry']; polys = [g['coordinates']] if g['type'] == 'Polygon' else g['coordinates'] if g['type'] == 'MultiPolygon' else []
    pr = f['properties']
    if pr.get('is_underground'): continue
    for poly in polys:
        ring = poly[0][:-1] if poly[0][0] == poly[0][-1] else poly[0]
        if len(ring) < 3: continue
        clat = sum(p[1] for p in ring) / len(ring); clon = sum(p[0] for p in ring) / len(ring)
        if not (S < clat < N and W < clon < E): continue
        loc = [P(la, lo) for lo, la in ring]; ar = area(loc)
        if ar < 12: continue
        h, name = osm_h(clat, clon)
        if h: stat['osm'] += 1
        elif pr.get('height'): h = float(pr['height']); stat['ov'] += 1
        elif pr.get('num_floors'): h = float(pr['num_floors']) * 3.4 + 1; stat['ov'] += 1
        else:
            r = rnd(f'{clat:.6f}{clon:.6f}'); stat['est'] += 1
            fl = 1 + r * 1.5 if ar < 30 else 2 + r * 3 if ar < 160 else 3 + r * 4 if ar < 600 else 2 + r * 4
            h = fl * 3.4 + 0.6
        # màu mái: trung vị điểm ảnh trong mái
        pts = [pix(la, lo) for lo, la in ring]
        xs = [p[0] for p in pts]; ys = [p[1] for p in pts]
        x0_, x1_, y0_, y1_ = max(0, int(min(xs))), min(IW - 1, int(max(xs)) + 1), max(0, int(min(ys))), min(IH - 1, int(max(ys)) + 1)
        if x1_ <= x0_ or y1_ <= y0_: continue
        sub = A[y0_:y1_ + 1, x0_:x1_ + 1].reshape(-1, 3)
        col = np.median(sub, axis=0).astype(int) if len(sub) else np.array([180, 180, 180])
        md.polygon(pts, fill=255)
        loc = loc[:250]
        out += struct.pack('<BBHBBB', len(loc), 1 if h > 30 else 0, min(65535, int(h * 10)), *[int(v) for v in col])
        for x, z in loc: out += struct.pack('<hh', max(-32768, min(32767, round(x * 4))), max(-32768, min(32767, round(z * 4))))
        n += 1
        if h >= 45: tall.append({'name': name, 'x': round(sum(p[0] for p in loc) / len(loc)), 'z': round(sum(p[1] for p in loc) / len(loc)), 'h': round(h)})
open(os.path.join(OUT, 'bld.bin'), 'wb').write(out)
# --- cây: điểm ảnh xanh lá, không phải nhà, không phải nước ---
M = np.asarray(mask) > 0
r, g_, b = A[..., 0], A[..., 1], A[..., 2]
green = (g_ > r + 6) & (g_ > b - 2) & (g_ > 45) & (g_ < 170) & ~M
trees = bytearray(); nt = 0; rng = np.random.default_rng(5)
ys, xs = np.nonzero(green[::5, ::5])
for y, x in zip(ys * 5, xs * 5):
    if rng.random() > 0.55: continue
    lon = W + (x + rng.random() * 5) / IW * (E - W)
    lat = math.degrees(math.atan(math.sinh(math.pi * (1 - 2 * (Y0 + (y + rng.random() * 5) / IH * (Y1 - Y0))))))
    px, pz = P(lat, lon); trees += struct.pack('<hhBBB', round(px * 4), round(pz * 4), *[int(v) for v in A[y, x]]); nt += 1
open(os.path.join(OUT, 'trees.bin'), 'wb').write(trees)
im2 = img if max(IW, IH) <= 4096 else img.resize((IW * 4096 // max(IW, IH), IH * 4096 // max(IW, IH)))
im2.save(os.path.join(OUT, 'sat.jpg'), quality=84, optimize=True)
x0p, z0p = P(N, W); x1p, z1p = P(S, E)
json.dump({'origin': [LAT0, LON0], 'kx': KX, 'kz': KZ, 'bounds': [x0p, z0p, x1p, z1p], 'tall': tall, 'n': n, 'trees': nt},
          open(os.path.join(OUT, 'meta.json'), 'w'), ensure_ascii=False)
print('nhà', n, stat, 'cây', nt, 'cao>=45m', len(tall), 'bld', len(out) // 1024, 'KB')
