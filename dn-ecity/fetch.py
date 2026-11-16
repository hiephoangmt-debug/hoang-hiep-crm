"""e-City Đà Nẵng – dữ liệu toàn thành phố (chạy trên GitHub Actions):
 1) Nhà Overture Maps (Đà Nẵng nội đô + Hội An) -> chiều cao (height / num_floors / ước lượng) -> buildings.pmtiles (tippecanoe)
 2) Ranh phường/xã OpenStreetMap (Overpass) -> phuong.geojson
Kết quả: dn-ecity/out/"""
import hashlib, json, math, os, subprocess, time, urllib.parse, urllib.request
from shapely.geometry import LineString, mapping, shape
from shapely.ops import linemerge, polygonize, unary_union

D = os.path.dirname(os.path.abspath(__file__)); OUT = os.path.join(D, 'out'); TMP = os.path.join(D, 'tmp')
os.makedirs(OUT, exist_ok=True); os.makedirs(TMP, exist_ok=True)
BOXES = {'danang': (108.10, 15.95, 108.33, 16.14), 'hoian': (108.29, 15.85, 108.37, 15.92)}   # W S E N
# khu đất dự án sẽ dựng mô hình riêng (tháp 408 m, Sun Galaxy, Downtown) -> bỏ lán trại/nhà cũ trong vòng tròn này
CLEAR = [(16.03866, 108.23323, 80), (16.04315, 108.2376, 110), (16.04427, 108.2252, 28), (16.04514, 108.22517, 24), (16.04243, 108.22631, 24)]

def rnd(s): return int(hashlib.md5(s.encode()).hexdigest()[:8], 16) / 0xffffffff
def area_m2(ring):
    la0 = sum(p[1] for p in ring) / len(ring); kx = 111320 * math.cos(math.radians(la0)); kz = 110600
    pts = [(p[0] * kx, p[1] * kz) for p in ring]
    return abs(sum(pts[i][0] * pts[i - 1][1] - pts[i - 1][0] * pts[i][1] for i in range(len(pts)))) / 2

# ---------- 1) nhà Overture ----------
seq = open(os.path.join(TMP, 'b.geojsonseq'), 'w'); stat = {'n': 0, 'h': 0, 'fl': 0, 'est': 0, 'clear': 0}
for name, (w, s, e, n) in BOXES.items():
    f = os.path.join(TMP, f'{name}.geojson')
    if not os.path.exists(f):
        subprocess.check_call(['overturemaps', 'download', f'--bbox={w},{s},{e},{n}', '-f', 'geojson', '--type=building', '-o', f])
    for ft in json.load(open(f))['features']:
        p = ft['properties'] or {}; g = ft['geometry']
        if p.get('is_underground') or g['type'] not in ('Polygon', 'MultiPolygon'): continue
        ring = g['coordinates'][0] if g['type'] == 'Polygon' else g['coordinates'][0][0]
        clon = sum(q[0] for q in ring) / len(ring); clat = sum(q[1] for q in ring) / len(ring)
        if any(math.hypot((clat - a) * 110600, (clon - b) * 106975) < r for a, b, r in CLEAR): stat['clear'] += 1; continue
        ar = area_m2(ring)
        if ar < 12: continue
        if p.get('height'): h = float(p['height']); est = 0; stat['h'] += 1
        elif p.get('num_floors'): h = float(p['num_floors']) * 3.4 + 1; est = 0; stat['fl'] += 1
        else:
            r = rnd(f'{clat:.6f}{clon:.6f}'); est = 1; stat['est'] += 1
            fl = 1 + r * 1.5 if ar < 30 else 2 + r * 3 if ar < 160 else 3 + r * 4 if ar < 600 else 2 + r * 4
            h = fl * 3.4 + 0.6
        nm = (p.get('names') or {}).get('primary') if isinstance(p.get('names'), dict) else None
        props = {'h': round(h, 1), 'e': est}
        if nm and h >= 30: props['n'] = nm
        seq.write(json.dumps({'type': 'Feature', 'properties': props, 'geometry': g}, separators=(',', ':')) + '\n'); stat['n'] += 1
seq.close(); print('nhà', stat, flush=True)
subprocess.check_call(['tippecanoe', '-o', os.path.join(OUT, 'buildings.pmtiles'), '--force', '-l', 'b', '-Z12', '-z16',
                       '--drop-densest-as-needed', '--extend-zooms-if-still-dropping', '-P', os.path.join(TMP, 'b.geojsonseq')])
print('pmtiles', os.path.getsize(os.path.join(OUT, 'buildings.pmtiles')) // 1024, 'KB', flush=True)

# ---------- 2) ranh phường/xã OSM ----------
Q = '[out:json][timeout:300];(relation["boundary"="administrative"]["admin_level"~"^(4|6|7|8)$"](15.80,107.90,16.25,108.45););out geom;'
data = None
for url in ['https://overpass-api.de/api/interpreter', 'https://overpass.kumi.systems/api/interpreter', 'https://overpass.private.coffee/api/interpreter']:
    for a in range(3):
        try:
            data = json.load(urllib.request.urlopen(urllib.request.Request(url, data=urllib.parse.urlencode({'data': Q}).encode(), headers={'User-Agent': 'hoang-hiep-crm-ecity'}), timeout=400)); break
        except Exception as ex: print('overpass', url, ex, flush=True); time.sleep(10)
    if data: break
feats = []
for rel in (data or {}).get('elements', []):
    t = rel.get('tags', {}); lines = []
    for m in rel.get('members', []):
        if m.get('type') == 'way' and m.get('role') in ('outer', '') and m.get('geometry'):
            lines.append(LineString([(q['lon'], q['lat']) for q in m['geometry']]))
    if not lines: continue
    polys = list(polygonize(linemerge(lines)))
    if not polys: continue
    geom = unary_union(polys).simplify(0.00005)
    feats.append({'type': 'Feature', 'properties': {'name': t.get('name', ''), 'lv': t.get('admin_level'), 'ref': t.get('ref:VN') or t.get('ref') or '', 'pop': t.get('population', '')},
                  'geometry': mapping(geom)})
json.dump({'type': 'FeatureCollection', 'features': feats}, open(os.path.join(OUT, 'phuong.geojson'), 'w'), ensure_ascii=False, separators=(',', ':'))
from collections import Counter
print('ranh', len(feats), Counter(f['properties']['lv'] for f in feats), flush=True)
for f in feats[:400]: print(' ', f['properties']['lv'], f['properties']['name'])
json.dump({'stat': stat, 'boxes': BOXES, 'time': time.strftime('%Y-%m-%d')}, open(os.path.join(OUT, 'info.json'), 'w'))
