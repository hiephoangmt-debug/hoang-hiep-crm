"""Tải ranh giới các dự án Vin (Vinhomes, Vincom, Vinmec, Vinschool, VinUni...) ở Hà Nội và vùng giáp ranh từ OpenStreetMap."""
import json, os, time, urllib.parse, urllib.request
OUT = os.path.join(os.path.dirname(__file__), 'raw'); os.makedirs(OUT, exist_ok=True)
BB = '20.80,105.55,21.25,106.05'
Q = f'''[out:json][timeout:300];
(nwr["name"~"vinhomes|vin ?city|vincom|vinmec|vinschool|vinuni|vinpearl|vinfast|the empire|ocean park|smart city|times city|royal city|wonder park|global gate|cổ loa|imperia|the crown",i]({BB});
 nwr["operator"~"vinhomes|vingroup",i]({BB}); nwr["brand"~"vinhomes|vincom|vinmec|vinschool",i]({BB}););
out geom;'''
EP = ['https://overpass-api.de/api/interpreter', 'https://overpass.kumi.systems/api/interpreter', 'https://overpass.private.coffee/api/interpreter']
for a in range(6):
    try:
        body = urllib.request.urlopen(urllib.request.Request(EP[a % 3], data=urllib.parse.urlencode({'data': Q}).encode(), headers={'User-Agent': 'hoang-hiep-crm hanoi-vin'}), timeout=400).read()
        js = json.loads(body); print(len(js['elements']), 'elements')
        open(os.path.join(OUT, 'vin.json'), 'wb').write(body); break
    except Exception as e:
        print('lỗi', e); time.sleep(20)
else:
    raise SystemExit('không tải được')
