# Sinh public/config3.js + public/tuyen_data.js: camera bay dọc hành trình ven biển Sun Saphia → Hội An, có điểm dừng và thanh km.
import json, math
P = json.load(open('public/data/tuyen.json'))
K = lambda a, b: math.hypot((a[0] - b[0]) * 111.32 * math.cos(math.radians(16)), (a[1] - b[1]) * 110.57)
cum = [0.0]
for a, b in zip(P, P[1:]): cum.append(cum[-1] + K(a, b))
TOT = cum[-1]
def at(km):
    km = max(0, min(TOT, km)); i = 0
    while i < len(cum) - 2 and cum[i + 1] < km: i += 1
    t = (km - cum[i]) / max(1e-9, cum[i + 1] - cum[i]); a, b = P[i], P[i + 1]
    return [a[0] + (b[0] - a[0]) * t, a[1] + (b[1] - a[1]) * t]
def proj(pt):   # km trên tuyến gần nhất với 1 điểm
    best = min(range(len(P)), key=lambda i: K(P[i], pt)); return cum[best]
def bearing(a, b):
    y = math.sin(math.radians(b[0] - a[0])) * math.cos(math.radians(b[1]))
    x = math.cos(math.radians(a[1])) * math.sin(math.radians(b[1])) - math.sin(math.radians(a[1])) * math.cos(math.radians(b[1])) * math.cos(math.radians(b[0] - a[0]))
    return math.degrees(math.atan2(y, x))
PROJ = [108.2577158, 16.0211116]; HOIAN = [108.3262, 15.8770]
STOPS = [  # tên, biểu tượng, tọa độ (None = mốc trên tuyến theo km), km cố định nếu có
    ('Sun Saphia', 'star', PROJ, 0.0),
    ('Công viên biển Sơn Thủy', 'tree', [108.261437, 16.019729], None),
    ('Hyatt Regency', 'hotel', [108.26417, 16.01301], None),
    ('Marriott Resort', 'hotel', [108.2661, 16.00695], None),
    ('Ngũ Hành Sơn', 'mountain', [108.26382, 16.00292], None),
    ('Đường Lạc Long Quân', 'road', None, 17.97),
    ('Biển Cửa Đại', 'beach', None, 23.0),
    ('Phố cổ Hội An', 'star', HOIAN, TOT),
]
stops = []
for n, ic, pt, k in STOPS:
    k = k if k is not None else proj(pt)
    stops.append(dict(name=n, icon=ic, at=pt or at(k), km=round(k, 2)))
# ---- lịch trình: km theo khung hình (đi nhanh, chậm lại quanh điểm dừng) ----
F0, F1 = 150, 1080          # bắt đầu chạy / tới Hội An
def ease_sched():
    # vận tốc tương đối: thấp gần các điểm dừng
    N = 2000; ks = [TOT * i / N for i in range(N + 1)]
    def v(k): return 1 - 0.78 * max(math.exp(-((k - s['km']) / 0.35) ** 2) for s in stops)
    tt = [0.0]
    for a, b in zip(ks, ks[1:]): tt.append(tt[-1] + (b - a) / v((a + b) / 2))
    T = tt[-1]; out = []
    for f in range(F0, F1 + 1):
        u = (f - F0) / (F1 - F0); u = u * u * (3 - 2 * u) * 0.25 + u * 0.75   # khởi hành/dừng mềm
        tgt = u * T; j = 0
        while j < len(tt) - 2 and tt[j + 1] < tgt: j += 1
        out.append(ks[j] + (ks[j + 1] - ks[j]) * (tgt - tt[j]) / max(1e-9, tt[j + 1] - tt[j]))
    return out
KM = ease_sched()
DUR = 1350
kmf = [0.0] * F0 + KM + [TOT] * (DUR - F1 - 1)
# ---- camera ----
cam = [dict(f=0, c=[108.300, 15.952], z=11.15, p=18, b=-25), dict(f=70, c=[108.298, 15.955], z=11.2, p=22, b=-22, hold=True),
       dict(f=140, c=at(0.25), z=15.2, p=60, b=round(bearing(at(0), at(0.8)), 1), hold=True)]
prevb = cam[-1]['b']
for f in range(F0 + 20, F1 + 1, 18):
    k = kmf[f]; c = at(k + 0.35)
    b = bearing(at(max(0, k - 0.6)), at(min(TOT, k + 1.2)))
    while b - prevb > 180: b -= 360
    while b - prevb < -180: b += 360
    b = prevb + max(-14, min(14, b - prevb)); prevb = b
    z = 14.35 if 3 < k < TOT - 2 else 14.9
    cam.append(dict(f=f, c=[round(c[0], 6), round(c[1], 6)], z=z, p=60, b=round(b, 1)))
cam += [dict(f=1150, c=[108.3180, 15.9540], z=11.6, p=24, b=-22, hold=True), dict(f=DUR, c=[108.3180, 15.9550], z=11.68, p=28, b=-18)]
ev = []
ev.append(dict(type='project', **{'in': 0}, lotsIn=10, out=None, rise=[95, 170]))
ev.append(dict(type='route', coords=P, solid=True, color='#5CF2E6', width=4, glowW=16, **{'in': 6}, dur=60, out=146, preview=True))
for s in stops:
    fin = next((f for f in range(DUR) if kmf[f] >= s['km'] - 0.15 and f >= F0), F0) if s['km'] > 0 else 150
    if s['km'] >= TOT - 0.01: fin = F1 - 10
    ev.append(dict(type='poi', name=s['name'], icon=s['icon'], at=[round(s['at'][0], 6), round(s['at'][1], 6)], **{'in': fin}, out=1350 if s['name'] in ('Sun Saphia', 'Phố cổ Hội An') else fin + 120,
                   beam=110, small=True, showDist=False, sub='km ' + f"{s['km']:.1f}".replace('.', ','), dx={'Sun Saphia': 150, 'Phố cổ Hội An': -170, 'Công viên biển Sơn Thủy': -120}.get(s['name'], 0)))
    s['f'] = fin
FINAL = {'Ngũ Hành Sơn': -170, 'Biển Cửa Đại': 150}
for s in stops:   # vài điểm dừng hiện lại ở toàn cảnh cuối, lệch trái/phải cho khỏi chồng
    if s['name'] in FINAL:
        ev.append(dict(type='poi', name=s['name'], icon=s['icon'], at=[round(s['at'][0], 6), round(s['at'][1], 6)], **{'in': 1160 + 8 * stops.index(s)}, out=DUR, beam=70, small=True, showDist=False, sub='', dx=FINAL[s['name']]))
ev.append(dict(type='route', coords=P, solid=True, color='#5CF2E6', width=7, glowW=26, **{'in': F0}, dur=F1 - F0, out=None, track=True, head=True))
ev.append(dict(type='area', **{'in': 1100}, out=DUR))
ev.append(dict(type='fade', at=148, dur=6))
def js(v):
    if isinstance(v, dict): return '{ ' + ', '.join(f"{k}: {js(x)}" for k, x in v.items()) + ' }'
    if isinstance(v, list): return '[' + ', '.join(js(x) for x in v) + ']'
    if v is None: return 'null'
    if v is True: return 'true'
    if v is False: return 'false'
    if isinstance(v, str): return "'" + v.replace("'", "\\'") + "'"
    return str(round(v, 6) if isinstance(v, float) else v)
cfg = f"""// KỊCH BẢN VIDEO 3: hành trình ven biển Sun Saphia → phố cổ Hội An (sinh bởi scripts/gen_tuyen.py, đừng sửa tay)
const PROJECT_CENTER = {js(PROJ)};
const HOIAN = {js(HOIAN)};
window.TUYEN_KM = {js([round(x, 4) for x in kmf])};
window.CONFIG = {{
  duration: {DUR},
  fadeIn: 10,
  logo: null,
  palette: {{
    sea: '#050F24', land: '#0C2042', green: '#0F2B4D', sand: '#1A3358', water: '#071A36', coast: '#7FB2FF',
    roadMinor: '#7F95BA', bldLow: '#16335D', bldHigh: '#2A5288', navy800: '#0A1C3A',
    orange: '#FF7A1A', orange300: '#FFB547', lotB: '#FF9A3C', lotC: '#F06414', park: '#E8EEF8',
  }},
  project: {{ center: PROJECT_CENTER,
    polygon: [[108.2573513, 16.0212283], [108.2573647, 16.0212651], [108.2577708, 16.021462], [108.2578002, 16.0214697], [108.2578437, 16.0214596], [108.2578738, 16.021427], [108.258007, 16.0211467], [108.2580933, 16.0209651], [108.2575848, 16.0207368], [108.2574985, 16.0209185]],
    parcels: [], buildingUrl: 'data/saphia.geojson' }},
  camera: [
{chr(10).join('    ' + js(c) + ',' for c in cam)}
  ],
  events: [
{chr(10).join('    ' + js(e) + ',' for e in ev)}
  ],
}};
"""
open('public/config3.js', 'w').write(cfg)
open('public/tuyen_data.js', 'w').write('window.TUYEN = ' + json.dumps(dict(total=round(TOT, 2), km=[round(x, 3) for x in kmf], stops=[dict(name=s['name'], km=s['km'], f=s['f']) for s in stops])) + ';')
print('tổng', round(TOT, 2), 'km'); [print(s['name'], s['km'], s['f']) for s in stops]
