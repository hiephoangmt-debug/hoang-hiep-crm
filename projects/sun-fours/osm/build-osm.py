"""Bản đồ OpenStreetMap quanh Sun FourS Tower (~6 km) cho mô hình 3D·4D·5D sun-fours-4d.html.
Dùng đúng hệ toạ độ 'world' và hàm W(lat, lon) của bản Sun Saphia (để giữ nguyên toạ độ mọi điểm mốc đã đo),
rồi lọc theo khoảng cách tới tâm FourS (giao lộ Minh Mạng – Nguyễn Phước Lan) thay vì tâm Saphia.
Nguồn: sf-osm-*.json (tải quanh FourS bằng GitHub Actions) + ss-osm-*.json (bản Saphia, nhánh claude/sweet-knuth-g4n4j5).
Dữ liệu © OpenStreetMap contributors (ODbL)."""
import json, math, pathlib, re, subprocess, sys
H = pathlib.Path(__file__).parent
REPO = H.parents[2]
LAT0, LON0 = 16.0213, 108.257659          # gốc hệ world của bản Saphia (giữ nguyên)
OX, OZ = 26.888, -33.847
TH = 0.427
DX = -9
KX = 111320 * math.cos(math.radians(LAT0)); KZ = 110574
def W(lat, lon):
    sx = (lon - LON0) * KX - OX; sz = -(lat - LAT0) * KZ - OZ
    c, s = math.cos(TH), math.sin(TH)
    return (sx * c - sz * s + DX, sx * s + sz * c)
FC = W(16.009588, 108.242570)             # tâm FourS (GPS dự án) → world ≈ (-2053, 530)
def dF(p): return math.hypot(p[0] - FC[0], p[1] - FC[1])
def dS(p): return math.hypot(p[0], p[1])  # tới Saphia (gốc world)

SS_COMMIT = '75ff1fe7b3d5e08d31b1e3a0ee247f1555a94a31'
def load(n):
    p = H / n
    if p.exists(): d = json.load(open(p))
    else:   # dữ liệu bản Saphia: đọc thẳng từ git
        try: d = json.loads(subprocess.check_output(['git', '-C', str(REPO), 'show', SS_COMMIT + ':projects/sun-saphia/osm/' + n]))
        except subprocess.CalledProcessError: return [], {}
    d = d['elements']
    return d, {e['id']: (e['lat'], e['lon']) for e in d if e['type'] == 'node'}
def flat(P, q=1): return [round(v, q) if q else int(round(v)) for p in P for v in p]
def area(P): return abs(sum(P[i][0]*P[i-1][1]-P[i-1][0]*P[i][1] for i in range(len(P))))/2
def simp(P, tol):
    if len(P) < 3: return P
    a, b = P[0], P[-1]; dx, dz = b[0]-a[0], b[1]-a[1]; L = math.hypot(dx, dz) or 1e-9
    i, dm = 0, -1
    for k in range(1, len(P)-1):
        d = abs(dz*(P[k][0]-a[0]) - dx*(P[k][1]-a[1])) / L
        if d > dm: i, dm = k, d
    if dm <= tol: return [a, b]
    return simp(P[:i+1], tol)[:-1] + simp(P[i:], tol)
def rring(P, tol):
    if len(P) > 1 and P[0] == P[-1]: P = P[:-1]
    if len(P) < 4: return P
    k = max(range(len(P)), key=lambda i: (P[i][0]-P[0][0])**2 + (P[i][1]-P[0][1])**2)
    return simp(P[:k+1], tol)[:-1] + simp(P[k:] + [P[0]], tol)[:-1]
def cen(P): return (sum(p[0] for p in P)/len(P), sum(p[1] for p in P)/len(P))

out = {'roads': [], 'water': [], 'green': [], 'coast': [], 'bld': [], 'poi': []}
WID = {'motorway': 26, 'trunk': 26, 'primary': 22, 'secondary': 18, 'tertiary': 13, 'unclassified': 8, 'residential': 7, 'living_street': 6, 'pedestrian': 6}
# gộp 2 nguồn đường (theo id)
ways, N, rels = {}, {}, {}
for f in ('sf-osm-roads.json', 'ss-osm-roads.json'):
    d, n = load(f); N.update(n)
    for e in d:
        if e['type'] == 'way': ways.setdefault(e['id'], e)
        elif e['type'] == 'relation': rels.setdefault(e['id'], e)
seenW = set()
for w in ways.values():
    t = w.get('tags', {}); P = [W(*N[n]) for n in w['nodes'] if n in N]
    if len(P) < 2: continue
    hw = t.get('highway', '').replace('_link', '')
    if hw in WID:
        big = WID[hw] >= 13
        near = min(min(dF(p) for p in P) - (6000 if big else 3000), min(dS(p) for p in P) - (4200 if big else 2600))
        if near > 0: continue
        inb = lambda q: abs(q[0]) < 26 and abs(q[1]) < 1300       # dải đại lộ ven biển vẽ sẵn
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
        if len(P) > 3 and area(P) > 1500 and min(dF(cen(P)), dS(cen(P))) < 9000: out['water'].append(flat(rring(P, 1.5)))
    elif t.get('leisure') in ('park', 'garden', 'pitch') or t.get('landuse') in ('grass', 'recreation_ground', 'forest'):
        if len(P) > 3 and area(P) > 400 and min(dF(cen(P)), dS(cen(P))) < 3500: out['green'].append(flat(rring(P, 1)))
# sông Hàn và các hồ lớn: quan hệ multipolygon – ghép các đoạn 'outer'
for rel in rels.values():
    segs = [[n for n in ways[m['ref']]['nodes']] for m in rel['members'] if m['type'] == 'way' and m.get('role', 'outer') == 'outer' and m['ref'] in ways]
    rings = []
    while segs:
        ring = segs.pop(0); changed = True
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
# bỏ mặt nước trùng lặp (cùng một vùng có trong cả 2 nguồn)
seenWa, wa = set(), []
for P in out['water']:
    k = (round(sum(P[0::2]) / len(P) * 2), round(sum(P[1::2]) / len(P) * 2), len(P) // 4)
    if k in seenWa: continue
    seenWa.add(k); wa.append(P)
out['water'] = wa
# nhà: footprint + chiều cao; bỏ nhà trong khu đất FourS (dựng riêng 4 tòa) và khu đất Saphia
seen = set()
for f in ('sf-osm-buildings.json', 'sf-osm-tall.json', 'ss-osm-buildings2.json', 'ss-osm-buildings.json', 'ss-osm-tall.json'):
    d, Nb = load(f)
    for w in d:
        if w['type'] != 'way' or w['id'] in seen or 'building' not in w.get('tags', {}): continue
        seen.add(w['id']); t = w['tags']; P = [W(*Nb[n]) for n in w['nodes'] if n in Nb]
        if len(P) < 4 or area(P) < 25: continue
        c = cen(P)
        if dS(c) < 70 or dF(c) < 150: continue   # khu đất 4 tòa FourS (dựng riêng)
        if dF(c) > 6500 and dS(c) > 3000: continue
        try: h = float(str(t.get('height', '')).replace('m', '').split(';')[0])
        except ValueError:
            try: h = float(str(t.get('building:levels')).split(';')[0]) * 3.3 + 1
            except ValueError: h = {'roof': 5, 'house': 10, 'hangar': 12}.get(t['building'], 11)
        out['bld'].append([round(h), flat(rring(P, .4))] + ([t['name']] if t.get('name') and h >= 30 else []))
seenP = set()
for f in ('sf-osm-poi.json', 'ss-osm-poi.json'):
    d, _ = load(f)
    for e in d:
        t = e.get('tags', {}); c = e.get('center') or ({'lat': e['lat'], 'lon': e['lon']} if 'lat' in e else None)
        if not c or not t.get('name') or e['id'] in seenP: continue
        seenP.add(e['id']); p = W(c['lat'], c['lon']); k = t.get('tourism') or t.get('shop') or t.get('amenity') or t.get('aeroway') or t.get('natural')
        out['poi'].append([t.get('name:vi') or t['name'], k, round(p[0]), round(p[1])])
data = 'var OSM=' + json.dumps(out, separators=(',', ':'), ensure_ascii=False) + ';'
(H / 'sf-osm-scene.js').write_text('/* Bản đồ quanh Sun FourS (© OpenStreetMap contributors, ODbL) – sinh bởi build-osm.py, toạ độ world của mô hình 4D (m) */\n' + data + '\n', encoding='utf-8')
print({k: len(v) for k, v in out.items()}, len(data) // 1024, 'KB')
f4 = H.parent / '4d' / 'sun-fours-4d.html'
if f4.exists():
    html = f4.read_text(encoding='utf-8')
    html, n = re.subn(r'/\*OSM-DATA\*/.*?/\*/OSM-DATA\*/', lambda m: '/*OSM-DATA*/' + data + '/*/OSM-DATA*/', html, flags=re.S)
    assert n == 1
    f4.write_text(html, encoding='utf-8'); print('đã chèn vào', f4.name, len(html) // 1024, 'KB')
