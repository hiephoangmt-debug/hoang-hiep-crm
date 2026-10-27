"""Chuyển dữ liệu OpenStreetMap (tải bằng GitHub Actions) thành ss-osm-scene.js cho mô hình 4D.
Toạ độ: hệ 'world' của mô hình (gốc = ngã ba Nguyễn Đức Thuận – đại lộ ven biển, x = vuông góc ra biển, z = dọc đại lộ về phía Nam), mét.
Dữ liệu © OpenStreetMap contributors (ODbL)."""
import json, math, pathlib
H = pathlib.Path(__file__).parent
LAT0, LON0 = 16.0213, 108.257659          # ghim vị trí dự án
OX, OZ = 26.888, -33.847                  # ngã ba NĐT – đại lộ so với ghim (m)
TH = 0.427                                # world.rotation.y của mô hình (= góc đại lộ ven biển đo trên bản đồ)
DX = -9                                   # dời để tim đại lộ thật trùng tim đại lộ vẽ sẵn (x = 0)
KX = 111320 * math.cos(math.radians(LAT0)); KZ = 110574
def W(lat, lon):
    sx = (lon - LON0) * KX - OX; sz = -(lat - LAT0) * KZ - OZ
    c, s = math.cos(TH), math.sin(TH)
    return (sx * c - sz * s + DX, sx * s + sz * c)
def load(n):
    p = H / n
    if not p.exists(): return [], {}
    d = json.load(open(p))['elements']
    return d, {e['id']: (e['lat'], e['lon']) for e in d if e['type'] == 'node'}
def flat(P, q=1): return [round(v, q) if q else int(round(v)) for p in P for v in p]
def area(P): return abs(sum(P[i][0]*P[i-1][1]-P[i-1][0]*P[i][1] for i in range(len(P))))/2
def simp(P, tol):   # Douglas–Peucker
    if len(P) < 3: return P
    a, b = P[0], P[-1]; dx, dz = b[0]-a[0], b[1]-a[1]; L = math.hypot(dx, dz) or 1e-9
    i, dm = 0, -1
    for k in range(1, len(P)-1):
        d = abs(dz*(P[k][0]-a[0]) - dx*(P[k][1]-a[1])) / L
        if d > dm: i, dm = k, d
    if dm <= tol: return [a, b]
    return simp(P[:i+1], tol)[:-1] + simp(P[i:], tol)
def rring(P, tol):   # vùng khép kín: bỏ điểm lặp, tách đôi tại điểm xa nhất rồi rút gọn từng nửa
    if len(P) > 1 and P[0] == P[-1]: P = P[:-1]
    if len(P) < 4: return P
    k = max(range(len(P)), key=lambda i: (P[i][0]-P[0][0])**2 + (P[i][1]-P[0][1])**2)
    return simp(P[:k+1], tol)[:-1] + simp(P[k:] + [P[0]], tol)[:-1]
def r(P): return math.hypot(sum(p[0] for p in P)/len(P), sum(p[1] for p in P)/len(P))

out = {'roads': [], 'water': [], 'green': [], 'coast': [], 'bld': [], 'poi': []}
d, N = load('ss-osm-roads.json')
WID = {'motorway': 26, 'trunk': 26, 'primary': 22, 'secondary': 18, 'tertiary': 13, 'unclassified': 8, 'residential': 7, 'living_street': 6, 'pedestrian': 6}
ways = {e['id']: e for e in d if e['type'] == 'way'}
for w in ways.values():
    t = w.get('tags', {}); P = [W(*N[n]) for n in w['nodes'] if n in N]
    if len(P) < 2: continue
    hw = t.get('highway', '').replace('_link', '')
    if hw in WID:
        if min(math.hypot(*p) for p in P) > (4200 if WID[hw] >= 13 else 2600): continue
        # bỏ các đoạn trùng dải đại lộ ven biển đã vẽ sẵn (|x| < 26 m, |z| < 1300 m) – tránh thấy 2 con đường
        inb = lambda q: abs(q[0]) < 26 and abs(q[1]) < 1300
        run = [P[0]]
        for a2, b2 in zip(P, P[1:]):
            if inb(a2) and inb(b2):
                if len(run) > 1: out['roads'].append([WID[hw], flat(simp(run, .8))])
                run = [b2]
            else: run.append(b2)
        if len(run) > 1: out['roads'].append([WID[hw], flat(simp(run, .8))])
    elif t.get('natural') == 'coastline':
        out['coast'].append(flat(simp(P, 1.5)))
    elif t.get('natural') == 'water' or t.get('waterway') in ('riverbank',) or t.get('leisure') == 'swimming_pool':
        if len(P) > 3 and area(P) > 1500 and r(P) < 9000: out['water'].append(flat(rring(P, 1.5)))
    elif t.get('leisure') in ('park', 'garden', 'pitch') or t.get('landuse') in ('grass', 'recreation_ground', 'forest'):
        if len(P) > 3 and area(P) > 400 and r(P) < 3500: out['green'].append(flat(rring(P, 1)))
# sông Hàn: quan hệ multipolygon – ghép các đoạn 'outer'
for rel in (e for e in d if e['type'] == 'relation'):
    segs = [[n for n in ways[m['ref']]['nodes']] for m in rel['members'] if m['type'] == 'way' and m.get('role', 'outer') == 'outer' and m['ref'] in ways]
    rings = []
    while segs:
        ring = segs.pop(0)
        changed = True
        while changed and ring[0] != ring[-1]:
            changed = False
            for i, s in enumerate(segs):
                if s[0] == ring[-1]: ring += s[1:]
                elif s[-1] == ring[-1]: ring += s[::-1][1:]
                elif s[-1] == ring[0]: ring = s + ring[1:]
                elif s[0] == ring[0]: ring = s[::-1] + ring[1:]
                else: continue
                segs.pop(i); changed = True; break
        rings.append(ring)
    for ring in rings:
        P = [W(*N[n]) for n in ring if n in N]
        if len(P) > 3 and area(P) > 1500: out['water'].append(flat(rring(P, 2)))
# nhà: footprint + chiều cao (height, hoặc số tầng × 3,3 m, mặc định 3 tầng)
seen = set()
for f in ('ss-osm-buildings2.json', 'ss-osm-buildings.json', 'ss-osm-tall.json'):
    d, N = load(f)
    for w in d:
        if w['type'] != 'way' or w['id'] in seen or 'building' not in w.get('tags', {}): continue
        seen.add(w['id']); t = w['tags']; P = [W(*N[n]) for n in w['nodes'] if n in N]
        if len(P) < 4 or area(P) < 25: continue
        if r(P) < 70: continue                                   # chính khu đất dự án
        try: h = float(str(t.get('height', '')).replace('m', '').split(';')[0])
        except ValueError:
            try: h = float(str(t.get('building:levels')).split(';')[0]) * 3.3 + 1
            except ValueError: h = {'roof': 5, 'house': 10, 'hangar': 12}.get(t['building'], 11)
        out['bld'].append([round(h), flat(rring(P, .4))] + ([t['name']] if t.get('name') and h >= 30 else []))
d, N = load('ss-osm-poi.json')
for e in d:
    t = e.get('tags', {}); c = e.get('center') or ({'lat': e['lat'], 'lon': e['lon']} if 'lat' in e else None)
    if not c or not t.get('name'): continue
    p = W(c['lat'], c['lon']); k = t.get('tourism') or t.get('shop') or t.get('amenity') or t.get('aeroway') or t.get('natural')
    out['poi'].append([t.get('name:vi') or t['name'], k, round(p[0]), round(p[1])])
js = ('/* Dữ liệu bản đồ quanh Sun Saphia (© OpenStreetMap contributors, ODbL) – sinh bởi build-osm.py, toạ độ world của mô hình 4D (m) */\n'
      'var OSM=' + json.dumps(out, separators=(',', ':'), ensure_ascii=False) + ';\n')
(H / 'ss-osm-scene.js').write_text(js, encoding='utf-8')
print({k: len(v) for k, v in out.items()}, len(js) // 1024, 'KB')
# chèn thẳng vào mô hình 4D (giữa 2 mốc /*OSM-DATA*/ … /*/OSM-DATA*/)
import re
f4 = H.parent / '4d' / 'sun-saphia-4d.html'
html = f4.read_text(encoding='utf-8')
data = 'var OSM=' + json.dumps(out, separators=(',', ':'), ensure_ascii=False) + ';'
html, n = re.subn(r'/\*OSM-DATA\*/.*?/\*/OSM-DATA\*/', lambda m: '/*OSM-DATA*/' + data + '/*/OSM-DATA*/', html, flags=re.S)
assert n == 1
f4.write_text(html, encoding='utf-8'); print('đã chèn vào', f4.name, len(html) // 1024, 'KB')
