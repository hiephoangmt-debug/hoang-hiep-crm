"""Tải dữ liệu thô Đà Nẵng: OpenStreetMap (Overpass) + độ cao địa hình (Terrarium).
Chạy trên GitHub Actions, kết quả lưu ở danang-data/raw/."""
import gzip, json, math, os, time, urllib.parse, urllib.request

OUT = os.path.join(os.path.dirname(__file__), 'raw')
os.makedirs(OUT, exist_ok=True)
CITY = '15.84,108.10,16.17,108.40'      # nam, tây, bắc, đông: Đà Nẵng + Hội An
WIDE = '15.76,107.90,16.30,108.60'      # rộng hơn: biển, núi, Cù Lao Chàm
ENDPOINTS = ['https://overpass-api.de/api/interpreter', 'https://overpass.kumi.systems/api/interpreter',
             'https://overpass.private.coffee/api/interpreter', 'https://maps.mail.ru/osm/tools/overpass/api/interpreter']
QUERIES = {
    'buildings': f'[out:json][timeout:300];(way["building"]({CITY});relation["building"]({CITY}););out tags geom;',
    'water': f'[out:json][timeout:600];(way["natural"="coastline"]({WIDE});way["natural"="water"]({WIDE});relation["natural"="water"]({WIDE});'
             f'way["waterway"="riverbank"]({WIDE});relation["waterway"="riverbank"]({WIDE});way["waterway"~"^(river|canal)$"]({WIDE}););out geom;',
    'roads': f'[out:json][timeout:600];way["highway"~"^(motorway|trunk|primary|secondary|tertiary|residential|unclassified|living_street|service|motorway_link|trunk_link|primary_link|secondary_link)$"]({CITY});out tags geom;',
    'places': f'[out:json][timeout:600];(way["aeroway"~"^(runway|aerodrome|apron|taxiway)$"]({CITY});way["leisure"~"^(park|stadium|golf_course)$"]({CITY});'
              f'way["natural"~"^(beach|wood|sand)$"]({WIDE});way["landuse"~"^(forest|grass|cemetery)$"]({CITY});node["natural"="peak"]({WIDE});'
              f'nwr["tourism"~"^(attraction|viewpoint|theme_park)$"]({WIDE});way["man_made"~"^(bridge|pier|breakwater)$"]({CITY});node["place"~"^(island|islet)$"]({WIDE}););out tags geom;',
    'projects': '[out:json][timeout:300];(nwr["name"~"Casamia|Balanca|Võng Nhi|Cồn Tiến|Bảy Mẫu|Chùa Cầu|An Bàng|Cửa Đại",i](15.80,108.28,15.95,108.42);'
                'way["landuse"="residential"]["name"](15.84,108.30,15.92,108.40);nwr["historic"](15.86,108.31,15.89,108.34);'
                'nwr["name"~"Làng Vân|Lang Van|Hải Vân Bay|Hai Van Bay|Vinhomes|Vinpearl",i](16.12,108.08,16.24,108.22);'
                'way["landuse"~"^(construction|residential|brownfield|greenfield)$"](16.14,108.10,16.22,108.18);'
                'way["natural"="beach"](16.14,108.10,16.22,108.18););out geom;',
}

def overpass(name, q):
    for attempt in range(8):
        url = ENDPOINTS[attempt % len(ENDPOINTS)]
        try:
            print(name, '->', url, flush=True)
            req = urllib.request.Request(url, data=urllib.parse.urlencode({'data': q}).encode(), headers={'User-Agent': 'hoang-hiep-crm danang-3d'})
            body = urllib.request.urlopen(req, timeout=1200).read()
            js = json.loads(body)
            print(name, len(js.get('elements', [])), 'elements', len(body) // 1024, 'KB', flush=True)
            with gzip.open(os.path.join(OUT, name + '.json.gz'), 'wb', 9) as f:
                f.write(body)
            return
        except Exception as e:
            print('  lỗi:', e, flush=True)
            time.sleep(20 + attempt * 15)
    raise SystemExit('Không tải được ' + name)

def tiles(z=12):
    s, w, n, e = map(float, WIDE.split(','))
    def xy(lat, lon):
        x = (lon + 180) / 360 * 2 ** z
        y = (1 - math.asinh(math.tan(math.radians(lat))) / math.pi) / 2 * 2 ** z
        return int(x), int(y)
    x0, y0 = xy(n, w); x1, y1 = xy(s, e)
    d = os.path.join(OUT, f'terrain{z}'); os.makedirs(d, exist_ok=True)
    for x in range(x0, x1 + 1):
        for y in range(y0, y1 + 1):
            p = os.path.join(d, f'{x}_{y}.png')
            if os.path.exists(p): continue
            url = f'https://s3.amazonaws.com/elevation-tiles-prod/terrarium/{z}/{x}/{y}.png'
            for a in range(4):
                try:
                    open(p, 'wb').write(urllib.request.urlopen(url, timeout=60).read()); break
                except Exception as e:
                    print('tile', x, y, e); time.sleep(5)
    print('terrain tiles', x0, y0, x1, y1, flush=True)

def tiled(name, q, n=3):
    """Chia vùng nội thành thành n×n ô để máy chủ không quá tải, rồi gộp lại."""
    s, w, nn, e = map(float, CITY.split(','))
    seen, els = set(), []
    for i in range(n):
        for j in range(n):
            bb = f'{s + (nn - s) * i / n:.4f},{w + (e - w) * j / n:.4f},{s + (nn - s) * (i + 1) / n:.4f},{w + (e - w) * (j + 1) / n:.4f}'
            part = f'{name}_{i}{j}'
            overpass(part, q.replace(CITY, bb))
            with gzip.open(os.path.join(OUT, part + '.json.gz')) as f:
                for el in json.load(f)['elements']:
                    if (el['type'], el['id']) not in seen:
                        seen.add((el['type'], el['id'])); els.append(el)
            os.remove(os.path.join(OUT, part + '.json.gz'))
    with gzip.open(os.path.join(OUT, name + '.json.gz'), 'wb', 9) as f:
        f.write(json.dumps({'elements': els}).encode())
    print(name, len(els), 'elements (gộp)', flush=True)

tiles()
for k, q in QUERIES.items():
    if not os.path.exists(os.path.join(OUT, k + '.json.gz')):
        if k in ('buildings', 'roads'): tiled(k, q)
        else: overpass(k, q)
