# Tìm hành trình ven biển từ Sun Saphia xuống Hội An trên dữ liệu đường phố (ưu tiên trục ven biển).
import json, math, networkx as nx
d = json.load(open('public/data/roads.geojson'))
G = nx.Graph()
def km(a, b):
    dx = (a[0] - b[0]) * 111.32 * math.cos(math.radians(16)); dy = (a[1] - b[1]) * 110.57
    return math.hypot(dx, dy)
COAST = ('Trường Sa', 'Lạc Long Quân', 'Võ Nguyên Giáp', 'Cửa Đại', 'Hai Bà Trưng')
for f in d['features']:
    n = f['properties'].get('n') or ''; r = f['properties'].get('r', 0)
    fac = 1.0 if any(k in n for k in COAST) and not n.startswith(('Kiệt', 'Hẻm')) else (1.4 if r >= 3 else 2.2 if r == 2 else 4)
    c = [tuple(round(v, 6) for v in p) for p in f['geometry']['coordinates']]
    for a, b in zip(c, c[1:]):
        G.add_edge(a, b, w=km(a, b) * fac, km=km(a, b), n=n)
nodes = list(G.nodes)
near = lambda p: min(nodes, key=lambda q: km(p, q))
WP = [(108.2580, 16.0213), (108.3830, 15.8920), (108.3268, 15.8775)]   # Sun Saphia → bãi biển Cửa Đại → phố cổ Hội An
path = []
for a, b in zip(WP, WP[1:]):
    p = nx.shortest_path(G, near(a), near(b), weight='w'); path += p if not path else p[1:]
L = 0; names = []
for a, b in zip(path, path[1:]):
    e = G[a][b]; L += e['km']
    if not names or names[-1][0] != e['n']: names.append([e['n'], round(L, 2)])
print('tổng', round(L, 2), 'km,', len(path), 'điểm')
for n in names:
    if n[0]: print(n)
json.dump(path, open('public/data/tuyen.json', 'w'))
