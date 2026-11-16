"""Ảnh vệ tinh lịch sử Esri World Imagery Wayback cho Đà Nẵng: chỉ giữ các bản mà ảnh tại Đà Nẵng thực sự thay đổi,
kèm ngày chụp (metadata). Ghi vào dn-ecity/out/wayback.json. Chạy trên GitHub Actions."""
import hashlib, json, math, os, re, urllib.request
OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'out')
UA = {'User-Agent': 'hoang-hiep-crm-ecity'}
def get(u, t=60): return urllib.request.urlopen(urllib.request.Request(u, headers=UA), timeout=t).read()
def tile(lon, lat, z): n = 2 ** z; return int((lon + 180) / 360 * n), int((1 - math.asinh(math.tan(math.radians(lat))) / math.pi) / 2 * n)
PTS = [(108.2318, 16.0405), (108.2235, 16.0680), (108.2300, 16.0200), (108.2460, 16.0600)]   # Downtown, Hải Châu, Hòa Xuân, Mỹ Khê
cfg = json.loads(get('https://s3-us-west-2.amazonaws.com/config.maptiles.arcgis.com/waybackconfig.json'))
rel = []
for k, v in cfg.items():
    m = re.search(r'(\d{4}-\d{2}-\d{2})', v.get('itemTitle', ''))
    if m: rel.append((m.group(1), int(k), v))
rel.sort()
out, prev = [], None
for d, k, v in rel:
    url = v['itemURL']; hs = []
    for lon, lat in PTS:
        x, y = tile(lon, lat, 16)
        try: hs.append(hashlib.md5(get(url.replace('{level}', '16').replace('{row}', str(y)).replace('{col}', str(x)))).hexdigest()[:10])
        except Exception as ex: hs.append('x')
    sig = '|'.join(hs)
    if sig == prev: continue
    prev = sig
    cap = None; mu = v.get('metadataLayerUrl')
    if mu:
        for L in range(0, 16):
            try:
                q = json.loads(get(f'{mu}/{L}/query?f=json&geometry=108.2235,16.068&geometryType=esriGeometryPoint&inSR=4326&spatialRel=esriSpatialRelIntersects&outFields=*&returnGeometry=false', 30))
                fs = q.get('features') or []
                if fs:
                    a = {kk.upper(): vv for kk, vv in fs[0]['attributes'].items()}
                    sd = a.get('SRC_DATE') or a.get('SRC_DATE2')
                    if sd:
                        sd = str(sd); cap = f'{sd[:4]}-{sd[4:6]}-{sd[6:8]}' if len(sd) == 8 and sd.isdigit() else sd; break
            except Exception: pass
    out.append({'release': k, 'published': d, 'captured': cap, 'url': url.replace('{level}', '{z}').replace('{row}', '{y}').replace('{col}', '{x}')})
    print(d, cap, sig, flush=True)
json.dump(out, open(os.path.join(OUT, 'wayback.json'), 'w'), ensure_ascii=False)
print('bản khác nhau', len(out))
