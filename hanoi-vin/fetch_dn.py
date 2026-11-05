"""Tải ranh giới / vị trí các dự án BĐS ở Đà Nẵng – Hội An từ OpenStreetMap."""
import json, os, time, urllib.parse, urllib.request
OUT = os.path.join(os.path.dirname(__file__), 'raw'); os.makedirs(OUT, exist_ok=True)
BB = '15.80,107.95,16.25,108.45'
NAMES = ('sun |sun group|saphia|fours|four s|riverpolis|neo city|cora|symphony|peninsula|marina|ponte|galaxy|downtown|times square|hiyori|regal|mia plaza|legend|spana|s-light|s light|filmore|masteri|fpt city|fpt plaza|vinhomes|làng vân|casamia|balanca|hoiana|cocobay|asia park|công viên châu á|the sang|ariyana|furama|novotel|hilton|alphanam|monarchy|sơn trà ocean|wyndham|vinpearl|indochina riverside|euro village|son tra|hòa xuân|nam việt á|đa phước|golden hills|lakeside|bàu tràm')
Q = f'''[out:json][timeout:300];
(way["name"~"{NAMES}",i]["landuse"]({BB}); relation["name"~"{NAMES}",i]["landuse"]({BB});
 way["name"~"{NAMES}",i]["building"]({BB}); way["name"~"{NAMES}",i]["place"]({BB}); relation["name"~"{NAMES}",i]["place"]({BB});
 way["landuse"="construction"]["name"]({BB}); way["landuse"="residential"]["name"~"khu đô thị|kđt|khu dân cư|resort|villa",i]({BB}););
out geom;'''
EP = ['https://overpass-api.de/api/interpreter', 'https://overpass.kumi.systems/api/interpreter', 'https://overpass.private.coffee/api/interpreter']
for a in range(6):
    try:
        body = urllib.request.urlopen(urllib.request.Request(EP[a % 3], data=urllib.parse.urlencode({'data': Q}).encode(), headers={'User-Agent': 'hoang-hiep-crm dn-projects'}), timeout=400).read()
        print(len(json.loads(body)['elements']), 'elements'); open(os.path.join(OUT, 'dn-projects.json'), 'wb').write(body); break
    except Exception as e:
        print('lỗi', e); time.sleep(20)
else:
    raise SystemExit('không tải được')
