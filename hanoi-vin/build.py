"""Ranh giới các dự án Vin Hà Nội (OSM) -> vin-hanoi.geojson (đã đơn giản hoá)."""
import json, math, os
H = os.path.dirname(os.path.abspath(__file__))
E = {(x['type'], x['id']): x for x in json.load(open(os.path.join(H, 'raw/vin.json')))['elements']}
P = [  # (loại, id OSM, tên hiển thị, khu vực, nhóm)
 ('way', 761986888, 'Vinhomes Ocean Park 1', 'Gia Lâm, Hà Nội', 'dt'),
 ('way', 1145184206, 'Vinhomes Ocean Park 2 – The Empire', 'Văn Giang, Hưng Yên', 'dt'),
 ('way', 1183925307, 'Vinhomes Ocean Park 3 – The Crown', 'Văn Giang, Hưng Yên', 'dt'),
 ('relation', 21430511, 'Vinhomes Smart City', 'Tây Mỗ, Nam Từ Liêm', 'dt'),
 ('way', 1332178977, 'Vinhomes Global Gate (Cổ Loa)', 'Đông Anh, Hà Nội', 'dt'),
 ('way', 1363046622, 'Vinhomes Wonder City', 'Đan Phượng, Hà Nội', 'dt'),
 ('way', 1528197092, 'Vinhomes King Park', 'phía Bắc Hà Nội (giáp Bắc Ninh)', 'dt'),
 ('way', 208359485, 'Vinhomes Riverside', 'Long Biên, Hà Nội', 'dt'),
 ('way', 660081320, 'Vinhomes Times City', 'Hai Bà Trưng, Hà Nội', 'ch'),
 ('way', 892577321, 'Vinhomes Royal City', 'Thanh Xuân, Hà Nội', 'ch'),
 ('way', 893386372, 'Vinhomes Green Bay', 'Nam Từ Liêm, Hà Nội', 'ch'),
 ('way', 560585064, 'Vinhomes Gardenia', 'Hàm Nghi, Nam Từ Liêm', 'ch'),
 ('relation', 21357708, "Vinhomes D'Capitale", 'Trần Duy Hưng, Cầu Giấy', 'ch'),
 ('relation', 21425898, 'Vinhomes Skylake', 'Phạm Hùng, Nam Từ Liêm', 'ch'),
 ('way', 942827335, 'Vinhomes Thăng Long', 'Hoài Đức, Hà Nội', 'ch'),
 ('way', 1228015939, 'Vinhomes Green Villas', 'Tây Mỗ, Nam Từ Liêm', 'ch'),
 ('way', 37778547, 'Vinhomes The Gallery', 'Giảng Võ, Ba Đình', 'ch'),
]
def ring_of(x):
    if x['type'] == 'way': return [[p['lon'], p['lat']] for p in x['geometry']]
    parts = [[[p['lon'], p['lat']] for p in m['geometry']] for m in x['members'] if m.get('role') != 'inner' and 'geometry' in m]
    ring = parts.pop(0)
    while parts:
        for i, q in enumerate(parts):
            if q[0] == ring[-1]: ring += q[1:]
            elif q[-1] == ring[-1]: ring += q[::-1][1:]
            else: continue
            parts.pop(i); break
        else: break
    return ring
def simp(pts, tol=0.00004):
    if len(pts) < 4: return pts
    a, b = pts[0], pts[-1]; dmax, k = 0, 0
    for i in range(1, len(pts) - 1):
        x, y = pts[i]; L = math.hypot(b[0] - a[0], b[1] - a[1]) or 1e-12
        d = abs((b[0] - a[0]) * (a[1] - y) - (a[0] - x) * (b[1] - a[1])) / L
        if d > dmax: dmax, k = d, i
    return simp(pts[:k + 1], tol)[:-1] + simp(pts[k:], tol) if dmax > tol else [a, b]
def area_ha(r):
    lat0 = sum(p[1] for p in r) / len(r); kx = 111320 * math.cos(math.radians(lat0)); ky = 110540
    return abs(sum(r[i][0] * kx * r[i - 1][1] * ky - r[i - 1][0] * kx * r[i][1] * ky for i in range(len(r)))) / 2 / 1e4
F = []
for t, i, name, area, grp in P:
    r = ring_of(E[(t, i)]); r = r[:-1] if r[0] == r[-1] else r; h = len(r) // 2; r = simp(r[:h + 1])[:-1] + simp(r[h:] + [r[0]]); r = [[round(x, 6), round(y, 6)] for x, y in r]
    if r[0] != r[-1]: r.append(r[0])
    F.append({'type': 'Feature', 'properties': {'name': name, 'area': area, 'grp': grp, 'ha': round(area_ha(r), 1), 'osm': f'{t}/{i}'}, 'geometry': {'type': 'Polygon', 'coordinates': [r]}})
# tiện ích Vin (điểm)
for x in E.values():
    n = x.get('tags', {}).get('name', '')
    k = next((k for k in ('Vinmec', 'Vinschool', 'Vincom', 'VinUni') if k.lower() in n.lower()), None)
    if not k: continue
    if x['type'] == 'node': lo, la = x['lon'], x['lat']
    elif 'bounds' in x: b = x['bounds']; lo, la = (b['minlon'] + b['maxlon']) / 2, (b['minlat'] + b['maxlat']) / 2
    else: continue
    F.append({'type': 'Feature', 'properties': {'name': n, 'poi': k}, 'geometry': {'type': 'Point', 'coordinates': [round(lo, 6), round(la, 6)]}})
json.dump({'type': 'FeatureCollection', 'features': F}, open(sys_out := os.path.join(H, 'vin-hanoi.geojson'), 'w'), ensure_ascii=False, separators=(',', ':'))
print(len(F), os.path.getsize(sys_out) // 1024, 'KB'); [print(f['properties']['name'], f['properties']['ha'], 'ha') for f in F if 'ha' in f['properties']]
