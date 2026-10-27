"""Chuyển dữ liệu OpenStreetMap (fours-osm-roads.json, fours-osm-buildings.json) thành osm-data.js cho mô hình 4D.
Toạ độ cảnh: mét quanh vị trí dự án (anh Hiệp cung cấp), +x = Đông, +z = Nam — khớp hàm LL() trong scene.js."""
import json, math, pathlib

here = pathlib.Path(__file__).parent
LAT0, LON0 = 16.009588, 108.242570
KX = math.cos(math.radians(LAT0)) * 111320
KZ = 110574

def xz(lat, lon):
    return [round((lon - LON0) * KX, 1), round(-(lat - LAT0) * KZ, 1)]

def load(name):
    p = here / name
    return json.load(open(p))['elements'] if p.exists() else []

els = load('fours-osm-roads.json') + load('fours-osm-buildings.json')
nodes = {e['id']: (e['lat'], e['lon']) for e in els if e['type'] == 'node'}
ways = {e['id']: e for e in els if e['type'] == 'way'}

# bề rộng mặt đường (m) theo loại đường OSM – ước lượng thông dụng ở đô thị Việt Nam
W = {'motorway': 24, 'trunk': 22, 'primary': 20, 'secondary': 16, 'tertiary': 13, 'unclassified': 9,
     'residential': 8, 'living_street': 6, 'service': 5, 'pedestrian': 5, 'trunk_link': 9, 'primary_link': 9,
     'secondary_link': 8, 'tertiary_link': 7}

def pts(w):
    return [xz(*nodes[n]) for n in w.get('nodes', []) if n in nodes]

roads, water, rivers, parks, builds = [], [], [], [], []
for w in ways.values():
    t = w.get('tags', {})
    P = pts(w)
    if len(P) < 2:
        continue
    hw = t.get('highway')
    if hw in W:
        roads.append({'n': t.get('name', ''), 'w': W[hw], 'c': hw, 'b': 1 if t.get('bridge') == 'yes' else 0, 'p': P})
    elif t.get('natural') == 'water' or t.get('landuse') in ('reservoir', 'basin'):
        if P[0] == P[-1]:
            water.append(P)
    elif t.get('waterway') in ('river', 'canal', 'stream'):
        rivers.append({'n': t.get('name', ''), 'w': 60 if t['waterway'] == 'river' else 12, 'p': P})
    elif t.get('leisure') in ('park', 'golf_course', 'pitch', 'garden') or t.get('landuse') in ('grass', 'recreation_ground', 'village_green'):
        if P[0] == P[-1]:
            parks.append(P)
    elif 'building' in t and P[0] == P[-1]:
        lv = t.get('building:levels')
        h = float(t['height']) if t.get('height', '').replace('.', '', 1).isdigit() else (float(lv) * 3.4 if lv and lv.replace('.', '', 1).isdigit() else 0)
        builds.append({'h': round(h, 1), 'p': P})

# mặt nước dạng quan hệ (multipolygon): ghép các đoạn "outer" / "inner" thành vòng kín
def rings(members, role):
    segs = [pts(ways[m['ref']]) for m in members if m.get('type') == 'way' and m.get('role') == role and m['ref'] in ways]
    segs = [s for s in segs if len(s) > 1]
    out = []
    while segs:
        r = segs.pop(0)
        changed = True
        while r[0] != r[-1] and changed:
            changed = False
            for i, s in enumerate(segs):
                if s[0] == r[-1]: r += s[1:]
                elif s[-1] == r[-1]: r += s[::-1][1:]
                elif s[-1] == r[0]: r = s + r[1:]
                elif s[0] == r[0]: r = s[::-1] + r[1:]
                else: continue
                segs.pop(i); changed = True; break
        out.append(r)
    return out

water_mp = []
for e in els:
    if e['type'] == 'relation' and e.get('tags', {}).get('natural') == 'water':
        water_mp.append({'o': rings(e.get('members', []), 'outer'), 'i': rings(e.get('members', []), 'inner')})

data = {'roads': roads, 'water': water, 'waterMP': water_mp, 'rivers': rivers, 'parks': parks, 'buildings': builds}
js = '/* Dữ liệu OpenStreetMap (© OpenStreetMap contributors, ODbL) quanh dự án FourS – sinh bởi build_osm.py */\nwindow.FS_OSM=' + json.dumps(data, ensure_ascii=False, separators=(',', ':')) + ';\n'
(here / 'osm-data.js').write_text(js, encoding='utf-8')
names = sorted({r['n'] for r in roads if r['n']})
print('roads', len(roads), 'water', len(water), 'waterMP', len(water_mp), 'rivers', len(rivers), 'parks', len(parks), 'buildings', len(builds), 'size', len(js))
print('tên đường:', ', '.join(names[:60]))
