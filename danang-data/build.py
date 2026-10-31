"""Chuyển dữ liệu thô (danang-data/raw) thành dữ liệu gọn cho trang 3D Đà Nẵng.
Toạ độ: mét, gốc tại cầu Rồng; x = hướng đông, z = hướng nam (y = độ cao).
Kết quả trong thư mục đích (mặc định danang-data/out):
  land-near.jpg / mask-near.png : màu mặt đất + mặt nạ đất/nước vùng nội thành (chi tiết)
  land-far.jpg  / mask-far.png  : như trên cho vùng rộng (biển, núi xa)
  dem.bin      : độ cao địa hình (Int16, mét) lưới đều vùng rộng
  bld.bin      : nhà (đa giác + chiều cao)
  meta.json    : khung toạ độ, đường chính (xe chạy), cầu, nhãn địa danh
"""
import gzip, io, json, math, os, struct, sys
import numpy as np
from PIL import Image, ImageDraw

HERE = os.path.dirname(os.path.abspath(__file__))
RAW = os.path.join(HERE, 'raw')
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(HERE, 'out')
os.makedirs(OUT, exist_ok=True)

LAT0, LON0 = 16.0612, 108.2270          # cầu Rồng
KX = 111320 * math.cos(math.radians(LAT0))
KZ = 110600
def P(lat, lon): return ((lon - LON0) * KX, -(lat - LAT0) * KZ)

NEAR = (15.84, 108.10, 16.17, 108.40)   # nam, tây, bắc, đông
WIDE = (15.76, 107.90, 16.30, 108.60)
def box(b):
    s, w, n, e = b
    x0, z1 = P(s, w); x1, z0 = P(n, e)
    return x0, z0, x1, z1                # x0<x1, z0<z1 (z0 = phía bắc)

def load(name):
    with gzip.open(os.path.join(RAW, name + '.json.gz')) as f:
        return json.load(f)['elements']

def geom(el):
    """Trả về danh sách vòng (outer, [inner...]) toạ độ mét."""
    if el['type'] == 'way' and 'geometry' in el:
        return [([P(p['lat'], p['lon']) for p in el['geometry']], [])]
    if el['type'] == 'relation':
        outers, inners = [], []
        for m in el.get('members', []):
            if 'geometry' not in m: continue
            pts = [P(p['lat'], p['lon']) for p in m['geometry'] if p]
            (inners if m.get('role') == 'inner' else outers).append(pts)
        rings = join_rings(outers)
        return [(r, join_rings(inners)) for r in rings]
    return []

def join_rings(parts):
    parts = [p[:] for p in parts if len(p) >= 2]
    rings = []
    while parts:
        cur = parts.pop()
        changed = True
        while changed and cur[0] != cur[-1]:
            changed = False
            for i, p in enumerate(parts):
                if p[0] == cur[-1]: cur += p[1:]
                elif p[-1] == cur[-1]: cur += p[::-1][1:]
                elif p[-1] == cur[0]: cur = p + cur[1:]
                elif p[0] == cur[0]: cur = p[::-1] + cur[1:]
                else: continue
                parts.pop(i); changed = True; break
        rings.append(cur)
    return rings

# ---------- Mặt nạ đất / nước ----------
water_els = load('water')
place_els = load('places')
road_els = load('roads')

def make_layers(b, W):
    x0, z0, x1, z1 = box(b)
    H = int(round(W * (z1 - z0) / (x1 - x0)))
    if H > 4096: W, H = int(W * 4096 / H), 4096
    sx = W / (x1 - x0)
    tp = lambda pts: [((x - x0) * sx, (z - z0) * sx) for x, z in pts]
    # 1) biển: vẽ đường bờ biển rồi loang từ điểm giữa biển
    m = Image.new('L', (W, H), 255)
    d = ImageDraw.Draw(m)
    coast = [e for e in water_els if e.get('tags', {}).get('natural') == 'coastline']
    for e in coast:
        for outer, _ in geom(e):
            d.line(tp(outer), fill=128, width=2)
    for lat, lon in [(16.05, 108.40), (16.15, 108.17), (15.90, 108.50), (16.25, 108.30), (15.80, 108.55)]:
        px, pz = tp([P(lat, lon)])[0]
        if 0 <= px < W and 0 <= pz < H and m.getpixel((int(px), int(pz))) == 255:
            ImageDraw.floodfill(m, (int(px), int(pz)), 0)
    a = np.array(m)
    a[a == 128] = 255            # đường bờ biển tính là đất
    m = Image.fromarray(a)
    d = ImageDraw.Draw(m)
    # 2) sông, hồ
    for e in water_els:
        t = e.get('tags', {})
        if t.get('natural') == 'water' or t.get('waterway') == 'riverbank':
            for outer, inners in geom(e):
                if len(outer) > 2:
                    d.polygon(tp(outer), fill=0)
                    for r in inners:
                        if len(r) > 2: d.polygon(tp(r), fill=255)
        elif t.get('waterway') in ('river', 'canal') and 'geometry' in e:
            wpx = max(1, int((12 if t.get('waterway') == 'river' else 6) * sx))
            d.line(tp(geom(e)[0][0]), fill=0, width=wpx)
    # 3) màu mặt đất
    col = Image.new('RGB', (W, H), (92, 100, 112))
    c = ImageDraw.Draw(col)
    for e in place_els:
        t = e.get('tags', {})
        fill = None
        if t.get('natural') in ('wood',) or t.get('landuse') == 'forest': fill = (52, 82, 60)
        elif t.get('leisure') in ('park', 'golf_course') or t.get('landuse') in ('grass', 'cemetery'): fill = (70, 104, 72)
        elif t.get('natural') in ('beach', 'sand'): fill = (214, 196, 156)
        elif t.get('aeroway') in ('aerodrome',): fill = (104, 112, 104)
        elif t.get('leisure') == 'stadium': fill = (80, 120, 80)
        if fill:
            for outer, _ in geom(e):
                if len(outer) > 2: c.polygon(tp(outer), fill=fill)
    for e in place_els:
        t = e.get('tags', {})
        if t.get('aeroway') in ('runway', 'taxiway', 'apron'):
            for outer, _ in geom(e):
                if t['aeroway'] == 'apron' and len(outer) > 2: c.polygon(tp(outer), fill=(70, 74, 80))
                else: c.line(tp(outer), fill=(48, 50, 56), width=max(1, int((45 if t['aeroway'] == 'runway' else 18) * sx)))
    widths = {'motorway': 24, 'trunk': 22, 'primary': 20, 'secondary': 16, 'tertiary': 12, 'residential': 7, 'unclassified': 7,
              'living_street': 5, 'service': 4}
    for e in sorted(road_els, key=lambda e: widths.get(e['tags'].get('highway', '').replace('_link', ''), 5)):
        hw = e['tags'].get('highway', '').replace('_link', '')
        w = widths.get(hw, 5)
        if 'geometry' not in e: continue
        shade = 40 if w >= 12 else 52
        c.line(tp(geom(e)[0][0]), fill=(shade, shade + 2, shade + 8), width=max(1, round(w * sx)))
    return col, m, (x0, z0, x1, z1)

col, mask, bn = make_layers(NEAR, 4096)
col.save(os.path.join(OUT, 'land-near.jpg'), quality=80, optimize=True)
mask.save(os.path.join(OUT, 'mask-near.png'), optimize=True)
colf, maskf, bf = make_layers(WIDE, 2048)
colf.save(os.path.join(OUT, 'land-far.jpg'), quality=75, optimize=True)
maskf.save(os.path.join(OUT, 'mask-far.png'), optimize=True)
print('mask', mask.size, maskf.size)

# ---------- Địa hình ----------
tdir = os.path.join(RAW, 'terrain12')
tiles = {}
for f in os.listdir(tdir):
    x, y = map(int, f[:-4].split('_'))
    a = np.array(Image.open(os.path.join(tdir, f)).convert('RGB')).astype(np.float64)
    tiles[(x, y)] = a[:, :, 0] * 256 + a[:, :, 1] + a[:, :, 2] / 256 - 32768
Z = 12
def elev(lat, lon):
    x = (lon + 180) / 360 * 2 ** Z
    y = (1 - math.asinh(math.tan(math.radians(lat))) / math.pi) / 2 * 2 ** Z
    tx, ty = int(x), int(y)
    t = tiles.get((tx, ty))
    if t is None: return 0
    return t[min(255, int((y - ty) * 256)), min(255, int((x - tx) * 256))]
DW, DH = 640, 0
x0, z0, x1, z1 = bf
DH = int(DW * (z1 - z0) / (x1 - x0))
dem = np.zeros((DH, DW), np.int16)
mf = np.array(maskf.resize((DW, DH), Image.BILINEAR))
for j in range(DH):
    for i in range(DW):
        x = x0 + (i + 0.5) / DW * (x1 - x0); z = z0 + (j + 0.5) / DH * (z1 - z0)
        lat = LAT0 - z / KZ; lon = LON0 + x / KX
        h = elev(lat, lon)
        dem[j, i] = max(-20, min(2000, round(h))) if mf[j, i] > 100 else -20
open(os.path.join(OUT, 'dem.bin'), 'wb').write(dem.tobytes())
print('dem', DW, DH, dem.max())

# ---------- Nhà ----------
def bheight(t, eid):
    def num(v):
        try: return float(str(v).split()[0].replace(',', '.').rstrip('m'))
        except Exception: return None
    h = num(t.get('height')) if 'height' in t else None
    lv = num(t.get('building:levels')) if 'building:levels' in t else None
    if h: return h
    if lv: return lv * 3.4 + 1
    b = t.get('building', 'yes')
    r = (eid * 2654435761 % 1000) / 1000
    return {'apartments': 30, 'hotel': 40, 'commercial': 14, 'office': 24, 'retail': 9, 'industrial': 9, 'warehouse': 8,
            'school': 12, 'university': 14, 'hospital': 15, 'church': 14, 'temple': 9, 'pagoda': 12, 'roof': 4, 'shed': 3,
            'garage': 3}.get(b, 7 + r * 6)
def simplify(pts, tol=0.8):
    if len(pts) < 4: return pts
    a, b = np.array(pts[0]), np.array(pts[-1])
    dmax, idx = 0, 0
    for i in range(1, len(pts) - 1):
        p = np.array(pts[i])
        ab = b - a
        L = np.hypot(*ab)
        dd = np.hypot(*(p - a)) if L == 0 else abs(ab[0] * (p - a)[1] - ab[1] * (p - a)[0]) / L
        if dd > dmax: dmax, idx = dd, i
    if dmax > tol:
        return simplify(pts[:idx + 1], tol)[:-1] + simplify(pts[idx:], tol)
    return [pts[0], pts[-1]]
def area(r):
    return 0.5 * sum(r[i][0] * r[i - 1][1] - r[i - 1][0] * r[i][1] for i in range(len(r)))

TYPE = {'apartments': 1, 'hotel': 2, 'commercial': 3, 'office': 3, 'retail': 3, 'industrial': 4, 'warehouse': 4,
        'school': 5, 'university': 5, 'hospital': 5, 'church': 6, 'temple': 6, 'pagoda': 6}
out = io.BytesIO()
n = 0; heights = []
named = []
for e in load('buildings'):
    t = e.get('tags', {})
    for outer, _ in geom(e):
        if len(outer) < 4: continue
        r = outer[:-1] if outer[0] == outer[-1] else outer
        r = simplify(r + [r[0]])[:-1]
        if len(r) < 3 or abs(area(r)) < 25: continue
        if area(r) < 0: r = r[::-1]
        r = r[:250]
        h = bheight(t, e['id'])
        mn = t.get('min_height')
        try: mn = float(mn) if mn else 0
        except Exception: mn = 0
        out.write(struct.pack('<BBHH', len(r), TYPE.get(t.get('building'), 0), min(65535, int(h * 10)), min(65535, int(mn * 10))))
        for x, z in r:
            out.write(struct.pack('<hh', max(-32768, min(32767, round(x / 2))), max(-32768, min(32767, round(z / 2)))))
        n += 1; heights.append(h)
        if t.get('name') and h >= 60:
            cx = sum(p[0] for p in r) / len(r); cz = sum(p[1] for p in r) / len(r)
            named.append({'name': t['name'], 'x': round(cx), 'z': round(cz), 'h': round(h)})
open(os.path.join(OUT, 'bld.bin'), 'wb').write(out.getvalue())
print('buildings', n, 'bytes', out.tell(), 'max h', max(heights) if heights else 0)

# ---------- Đường chính (cho xe chạy), cầu, nhãn ----------
roads, bridges = [], []
for e in road_els:
    t = e['tags']
    if 'geometry' not in e: continue
    pts = [[round(x, 1), round(z, 1)] for x, z in geom(e)[0][0]]
    hw = t.get('highway', '').replace('_link', '')
    if t.get('bridge') in ('yes', 'viaduct', 'cantilever', 'suspension', 'movable') and hw not in ('service',):
        bridges.append({'name': t.get('name', ''), 'hw': hw, 'pts': pts, 'layer': t.get('layer', '1')})
    if hw in ('motorway', 'trunk', 'primary', 'secondary', 'tertiary'):
        roads.append({'w': {'motorway': 3, 'trunk': 3, 'primary': 3, 'secondary': 2, 'tertiary': 1}[hw], 'pts': pts})
minor = []
for e in road_els:
    hw = e['tags'].get('highway', '')
    if hw in ('residential', 'unclassified', 'living_street') and 'geometry' in e:
        minor.append([[round(x), round(z)] for x, z in geom(e)[0][0]])
labels = []
for e in place_els:
    t = e.get('tags', {})
    nm = t.get('name:vi') or t.get('name')
    if not nm: continue
    if e['type'] == 'node': x, z = P(e['lat'], e['lon'])
    elif 'bounds' in e:
        bb = e['bounds']; x, z = P((bb['minlat'] + bb['maxlat']) / 2, (bb['minlon'] + bb['maxlon']) / 2)
    elif 'geometry' in e:
        g = e['geometry']; x, z = P(sum(p['lat'] for p in g) / len(g), sum(p['lon'] for p in g) / len(g))
    else: continue
    kind = 'peak' if t.get('natural') == 'peak' else 'island' if t.get('place') in ('island', 'islet') else \
        'beach' if t.get('natural') == 'beach' else 'airport' if t.get('aeroway') == 'aerodrome' else \
        'park' if t.get('leisure') else 'bridge' if t.get('man_made') == 'bridge' else 'poi'
    labels.append({'name': nm, 'kind': kind, 'x': round(x), 'z': round(z), 'ele': t.get('ele')})
projects = []
if os.path.exists(os.path.join(RAW, 'projects.json.gz')):
    for e in load('projects'):
        t = e.get('tags', {})
        item = {'id': e['type'][0] + str(e['id']), 'name': t.get('name', ''), 'tags': {k: v for k, v in t.items() if k in (
            'name', 'name:en', 'landuse', 'historic', 'tourism', 'natural', 'building', 'operator', 'start_date', 'construction', 'leisure', 'place')}}
        if e['type'] == 'node':
            x, z = P(e['lat'], e['lon']); item['pt'] = [round(x), round(z)]
        else:
            item['rings'] = [[[round(x), round(z)] for x, z in outer] for outer, _ in geom(e) if len(outer) > 2]
            if not item['rings']: continue
        projects.append(item)
meta = {'projects': projects, 'origin': [LAT0, LON0], 'kx': KX, 'kz': KZ, 'near': bn, 'far': bf, 'dem': [DW, DH],
        'roads': roads, 'minor': minor, 'bridges': bridges, 'labels': labels, 'tall': named}
json.dump(meta, open(os.path.join(OUT, 'meta.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print('roads', len(roads), 'minor', len(minor), 'bridges', len(bridges), 'labels', len(labels), 'tall', len(named))
for f in sorted(os.listdir(OUT)):
    print(f, os.path.getsize(os.path.join(OUT, f)) // 1024, 'KB')
