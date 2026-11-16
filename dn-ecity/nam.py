"""e-City Đà Nẵng – "thay đổi qua các năm" (chạy trên GitHub Actions):
 1) GHSL GHS-BUILT-S (EU JRC) diện tích xây dựng theo từng mốc 5 năm 1975–2025, ô 100 m -> năm mỗi ô bắt đầu đô thị hoá
 2) GHSL GHS-BUILT-H AGBH 2018 – chiều cao trung bình công trình trong ô 100 m (thay cho chiều cao ước lượng)
 3) Gắn vào từng nhà Overture: y = năm xuất hiện, h = chiều cao -> buildings.pmtiles (thay bản cũ)
 4) Ảnh đô thị hoá do-thi-hoa.png + danh sách ảnh vệ tinh lịch sử Esri Wayback có ngày chụp thật tại Đà Nẵng
Kết quả: dn-ecity/out/"""
import io, json, math, os, re, subprocess, urllib.request, zipfile, hashlib
import numpy as np, rasterio
from pyproj import Transformer
from PIL import Image
D = os.path.dirname(os.path.abspath(__file__)); OUT = os.path.join(D, 'out'); TMP = os.path.join(D, 'tmp'); os.makedirs(TMP, exist_ok=True)
UA = {'User-Agent': 'hoang-hiep-crm-ecity'}
def get(url, t=600): return urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=t).read()
info = json.load(open(os.path.join(OUT, 'info.json')))
W, S, E, N = 108.10, 15.85, 108.37, 16.14
tr = Transformer.from_crs('EPSG:4326', 'ESRI:54009', always_xy=True)

# ---------- tìm ô GHSL chứa Đà Nẵng ----------
BASE = 'https://jeodpp.jrc.ec.europa.eu/ftp/jrc-opendata/GHSL'
def tiles_dir(prod, name): return f'{BASE}/{prod}/{name}/V1-0/tiles/'
def find_tile(prod, name):
    html = get(tiles_dir(prod, name)).decode('utf-8', 'ignore')
    ids = sorted(set(re.findall(r'_R(\d+)_C(\d+)\.zip', html)), key=lambda t: (int(t[0]), int(t[1])))
    x, y = tr.transform(108.22, 16.05)
    col = int((x + 18041000) // 1000000) + 1; row = int((9000000 - y) // 1000000) + 1
    cand = sorted(ids, key=lambda t: abs(int(t[0]) - row) + abs(int(t[1]) - col))[:6]
    return cand
def load_tile(prod, name, rc):
    fn = f'{name}_V1_0_R{rc[0]}_C{rc[1]}.zip'; p = os.path.join(TMP, fn)
    if not os.path.exists(p): open(p, 'wb').write(get(tiles_dir(prod, name) + fn, 900))
    z = zipfile.ZipFile(p); tif = [n for n in z.namelist() if n.endswith('.tif')][0]
    z.extract(tif, TMP); return os.path.join(TMP, tif)

YEARS = list(range(1975, 2030, 5))
name0 = 'GHS_BUILT_S_E1975_GLOBE_R2023A_54009_100'
cands = find_tile('GHS_BUILT_S_GLOBE_R2023A', name0); print('ô ứng viên', cands, flush=True)
rc = None
for c in cands:
    with rasterio.open(load_tile('GHS_BUILT_S_GLOBE_R2023A', name0, c)) as ds:
        x, y = tr.transform(108.22, 16.05); b = ds.bounds
        if b.left <= x <= b.right and b.bottom <= y <= b.top: rc = c; break
print('ô GHSL', rc, flush=True)
# cắt khung Đà Nẵng
x0, y0 = tr.transform(W, S); x1, y1 = tr.transform(E, N); xs = [tr.transform(lo, la)[0] for lo in (W, E) for la in (S, N)]; ys = [tr.transform(lo, la)[1] for lo in (W, E) for la in (S, N)]
def window(path):
    ds = rasterio.open(path); win = rasterio.windows.from_bounds(min(xs), min(ys), max(xs), max(ys), ds.transform).round_offsets().round_lengths()
    return ds.read(1, window=win).astype(np.float32), ds.window_transform(win)
BS = {}
for yr in YEARS:
    a, T = window(load_tile('GHS_BUILT_S_GLOBE_R2023A', f'GHS_BUILT_S_E{yr}_GLOBE_R2023A_54009_100', rc)); a[a > 10000] = 0; BS[yr] = a
H, TH = window(load_tile('GHS_BUILT_H_GLOBE_R2023A', 'GHS_BUILT_H_AGBH_E2018_GLOBE_R2023A_54009_100', rc)); H[(H < 0) | (H > 400)] = 0
first = np.full(BS[1975].shape, 9999, np.int16)
for yr in YEARS[::-1]: first[BS[yr] >= 800] = yr           # >= 8% diện tích ô là công trình -> coi là đã đô thị hoá
print('đô thị hoá theo năm', {yr: int((first == yr).sum()) for yr in YEARS}, flush=True)
inv = ~T
def cell(lon, lat):
    x, y = tr.transform(lon, lat); c, r = inv * (x, y); r, c = int(r), int(c)
    return (r, c) if 0 <= r < first.shape[0] and 0 <= c < first.shape[1] else None

# ---------- gắn năm + chiều cao vào từng nhà ----------
def rnd(s): return int(hashlib.md5(s.encode()).hexdigest()[:8], 16) / 0xffffffff
src = os.path.join(TMP, 'b.geojsonseq'); dst = os.path.join(TMP, 'b2.geojsonseq'); st = {'n': 0, 'gh': 0, 'y': {}}
with open(src) as fi, open(dst, 'w') as fo:
    for line in fi:
        f = json.loads(line); g = f['geometry']; ring = g['coordinates'][0] if g['type'] == 'Polygon' else g['coordinates'][0][0]
        lon = sum(q[0] for q in ring) / len(ring); lat = sum(q[1] for q in ring) / len(ring); p = f['properties']; rcl = cell(lon, lat)
        y = 2025
        if rcl:
            fy = int(first[rcl]); y = fy if fy != 9999 else 2025
            if p.get('e') == 1 and H[rcl] > 0:                                  # chưa có số liệu thật -> theo chiều cao trung bình GHSL của ô
                r = rnd(f'{lat:.6f}{lon:.6f}'); h = float(H[rcl]) * (0.7 + 0.6 * r)
                p['h'] = round(max(3.5, min(h, 160)), 1); p['e'] = 3; st['gh'] += 1
        p['y'] = y; st['y'][y] = st['y'].get(y, 0) + 1; st['n'] += 1
        fo.write(json.dumps({'type': 'Feature', 'properties': p, 'geometry': g}, separators=(',', ':')) + '\n')
print('nhà', st, flush=True)
subprocess.check_call(['tippecanoe', '-o', os.path.join(OUT, 'buildings.pmtiles'), '--force', '-l', 'b', '-Z12', '-z16', '--drop-densest-as-needed', '--extend-zooms-if-still-dropping', '-P', dst])
info['stat']['ghsl_h'] = st['gh']; info['stat']['est'] = info['stat'].get('est', 0) - st['gh']; info['years'] = st['y']

# ---------- ảnh đô thị hoá (WGS84) ----------
PX = 1600; PY = int(PX * (N - S) / (E - W) * 1.04)
pal = {1975: (122, 22, 32), 1980: (150, 30, 36), 1985: (178, 42, 38), 1990: (204, 62, 40), 1995: (224, 92, 44), 2000: (236, 124, 48), 2005: (244, 158, 56), 2010: (248, 190, 70), 2015: (250, 218, 96), 2020: (252, 238, 140), 2025: (255, 252, 196)}
img = np.zeros((PY, PX, 4), np.uint8)
for j in range(PY):
    lat = N - (j + 0.5) / PY * (N - S)
    for i in range(PX):
        c = cell(W + (i + 0.5) / PX * (E - W), lat)
        if c and first[c] != 9999: img[j, i] = (*pal[int(first[c])], 175)
Image.fromarray(img, 'RGBA').save(os.path.join(OUT, 'do-thi-hoa.png'), optimize=True)
info['dothihoa'] = {'bounds': [W, S, E, N], 'palette': {k: '#%02x%02x%02x' % v for k, v in pal.items()}, 'cells': {yr: int((first == yr).sum()) for yr in YEARS}}

# ---------- ảnh vệ tinh lịch sử Esri Wayback: ngày chụp thật tại Đà Nẵng ----------
cfg = json.loads(get('https://s3-us-west-2.amazonaws.com/config.maptiles.arcgis.com/waybackconfig.json'))
rel = []
for k, v in cfg.items():
    m = re.search(r'(\d{4}-\d{2}-\d{2})', v.get('itemTitle', ''))
    if m: rel.append((m.group(1), int(k), v))
rel.sort(); seen = {}; out = []
for d, k, v in rel:
    murl = v.get('metadataLayerUrl')
    src = None
    if murl:
        try:
            q = json.loads(get(murl + '/0/query?f=json&geometry=108.222,16.062&geometryType=esriGeometryPoint&inSR=4326&spatialRel=esriSpatialRelIntersects&outFields=SRC_DATE,SRC_DESC,SRC_RES&returnGeometry=false', 60))
            a = (q.get('features') or [{}])[0].get('attributes', {}); src = a.get('SRC_DATE'); desc = a.get('SRC_DESC')
        except Exception as ex: src = None
    key = src or d
    if key in seen: continue
    seen[key] = 1
    sd = str(src) if src else ''
    capt = f'{sd[:4]}-{sd[4:6]}-{sd[6:8]}' if len(sd) == 8 else (sd if sd else None)
    out.append({'release': k, 'published': d, 'captured': capt, 'url': v.get('itemURL', '').replace('{level}', '{z}').replace('{row}', '{y}').replace('{col}', '{x}')})
info['wayback'] = out; print('wayback', len(out), [o['captured'] for o in out], flush=True)
json.dump(info, open(os.path.join(OUT, 'info.json'), 'w'), ensure_ascii=False)
