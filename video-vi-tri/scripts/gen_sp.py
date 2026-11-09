# Sinh public/config4.js (hoàng hôn: lao xuống, bay vòng, hạ tầng; 0–30 s) và config5.js (đêm: đường sắt + thời gian di chuyển; 30–38 s).
import json, math
P = json.load(open('public/data/tuyen.json'))
PROJ = [108.2577158, 16.0211116]
POLY = [[108.2573513, 16.0212283], [108.2573647, 16.0212651], [108.2577708, 16.021462], [108.2578002, 16.0214697], [108.2578437, 16.0214596], [108.2578738, 16.021427], [108.258007, 16.0211467], [108.2580933, 16.0209651], [108.2575848, 16.0207368], [108.2574985, 16.0209185]]
def js(v):
    if isinstance(v, dict): return '{ ' + ', '.join(f"{k}: {js(x)}" for k, x in v.items()) + ' }'
    if isinstance(v, list): return '[' + ', '.join(js(x) for x in v) + ']'
    if v is None: return 'null'
    if v is True: return 'true'
    if v is False: return 'false'
    if isinstance(v, str): return "'" + v.replace("'", "\\'") + "'"
    return str(round(v, 6) if isinstance(v, float) else v)
def write(name, dur, pal, cam, ev, note):
    open(f'public/{name}', 'w').write(f"""// {note} (sinh bởi scripts/gen_sp.py, đừng sửa tay)
window.CONFIG = {{
  duration: {dur}, fadeIn: 0, logo: null,
  palette: {js(pal)},
  project: {{ center: {js(PROJ)}, polygon: {js(POLY)}, parcels: [], buildingUrl: 'data/saphia.geojson' }},
  camera: [
{chr(10).join('    ' + js(c) + ',' for c in cam)}
  ],
  events: [
{chr(10).join('    ' + js(e) + ',' for e in ev)}
  ],
}};
""")
I = lambda **k: {('in' if a == 'i' else a): b for a, b in k.items()}
# ---------- hoàng hôn ----------
SUN = dict(sea='#0E5F6B', land='#2A2337', green='#2F3B3A', sand='#8A6550', water='#0F4E5C', coast='#5CE6D6', coastLine='#CFFAF4',
           roadMinor='#A98478', roadMid='#F0BE96', roadGlow='#FFAA66', roadMajor='#FFE9CC', bldLow='#4B3448', bldHigh='#8C5E5A',
           navy800='#2A1E33', orange='#FF7A1A', orange300='#FFB547', lotB='#FF9A3C', lotC='#F06414', park='#E8EEF8')
cam = [
  dict(f=0, c=[108.2450, 16.0300], z=10.3, p=0, b=0),
  dict(f=80, c=[108.2560, 16.0230], z=12.9, p=0, b=0),
  dict(f=200, c=PROJ, z=15.6, p=12, b=40),
  dict(f=300, c=PROJ, z=16.75, p=50, b=90, hold=True),       # dừng trên tháp, nhìn ra biển
  dict(f=420, c=PROJ, z=16.55, p=56, b=135),
  dict(f=520, c=PROJ, z=15.9, p=60, b=195),                   # Ngũ Hành Sơn phía nam
  dict(f=650, c=PROJ, z=15.0, p=63, b=275, hold=True),        # nhìn về thành phố, sông Hàn
  dict(f=740, c=[108.2620, 16.0090], z=13.75, p=38, b=160, hold=True),   # trục biển chạy dọc khung
  dict(f=790, c=[108.2618, 16.0110], z=13.9, p=40, b=162),
  dict(f=830, c=[108.2600, 16.0196], z=16.55, p=18, b=72, hold=True),    # công viên → bãi biển
  dict(f=900, c=[108.2602, 16.0196], z=16.75, p=22, b=74),
]
PARK = [[108.259309, 16.01923], [108.261644, 16.020269], [108.261995, 16.01953], [108.25966, 16.01849]]
def lerp(a, b, t): return [a[0] + (b[0] - a[0]) * t, a[1] + (b[1] - a[1]) * t]
strips = []   # công viên lan dần từ phía dự án ra biển (5 dải)
A0, A1, B1, B0 = PARK[0], PARK[1], PARK[2], PARK[3]
for i in range(5):
    t0, t1 = i / 5, (i + 1) / 5
    strips.append([lerp(A0, A1, t0), lerp(A0, A1, t1), lerp(B0, B1, t1), lerp(B0, B1, t0)])
BEACH = [lerp(A0, A1, 1), [A1[0] + .0011, A1[1] + .0005], [B1[0] + .0012, B1[1] + .0004], lerp(B0, B1, 1)]
RESORT = [[108.2618, 16.0168], [108.2700, 15.9990], [108.2735, 16.0000], [108.2652, 16.0178]]   # dải ven biển phía nam dự án
VNGN = [[108.2490, 16.0420], [108.2530, 16.0330], [108.25679, 16.02422]]
road = VNGN + [p for p in P[:260]]
ev = [
  dict(type='project', **I(i=0), lotsIn=60, out=None, rise=[150, 260]),
  dict(type='pin', at=PROJ, **I(i=200), out=300, lift=150),
  dict(type='label', text='BÃI TẮM SƠN THỦY', style='sea', at=[108.2635, 16.0228], width=900, bearing=155, **I(i=310), out=470),
  dict(type='zone', polygon=RESORT, color='#FFC27A', **I(i=340), out=470),
  dict(type='poi', name='Dải resort cao cấp ven biển', icon='beach', at=[108.2668, 16.0080], **I(i=350), out=470, beam=90, small=True, showDist=False, sub=''),
  dict(type='poi', name='Ngũ Hành Sơn', icon='mountain', at=[108.26382, 16.00292], **I(i=480), out=650, beam=140, small=True, showDist=False, sub='≈ 2 km'),
  dict(type='poi', name='Trung tâm thành phố', icon='city', at=[108.2205, 16.0680], **I(i=570), out=700, beam=120, small=True, showDist=False, sub=''),
  dict(type='label', text='SÔNG HÀN', style='sea', at=[108.2290, 16.0700], width=1400, bearing=-20, **I(i=580), out=700),
  dict(type='route', coords=road, solid=True, color='#FFD27A', width=6, glowW=34, **I(i=690), dur=60, out=820, widen=[6, 18]),
  dict(type='label', text='TRỤC BIỂN VÕ NGUYÊN GIÁP – TRƯỜNG SA', style='road', at=[108.2636, 16.0080], width=900, bearing=152, **I(i=720), out=820),
] + [dict(type='zone', polygon=st, color='#3EE07A', **I(i=835 + i * 8), out=None) for i, st in enumerate(strips)] + [
  dict(type='zone', polygon=BEACH, color='#7FF2E0', **I(i=880), out=None),
  dict(type='poi', name='Công viên 2,45 ha', icon='tree', at=[108.2612, 16.0196], **I(i=860), out=None, beam=110, small=True, showDist=False, sub='nối thẳng ra bãi tắm', dx=-60),
]
write('config4.js', 900, SUN, cam, ev, 'VIDEO GIỚI THIỆU – phần hoàng hôn 0–30 s')
# ---------- đêm: đường sắt đề xuất + thời gian di chuyển ----------
NIGHT = dict(sea='#04101F', land='#0A1428', green='#0C1A2A', sand='#16233A', water='#06162B', coast='#2D6FA8', coastLine='#7FB2FF',
             roadMinor='#6B5A50', roadMid='#C8925E', roadGlow='#FF9F4A', roadMajor='#FFD9A8', bldLow='#152640', bldHigh='#2B4568',
             navy800='#0A1C3A', orange='#FF7A1A', orange300='#FFB547', lotB='#FF9A3C', lotC='#F06414', park='#E8EEF8')
RAIL = [[108.2030, 16.0552], [108.2240, 16.0450], [108.2420, 16.0330], [108.2530, 16.0215], [108.2580, 16.0060], [108.2700, 15.9800], [108.2900, 15.9420], [108.3080, 15.9060], [108.3262, 15.8770]]
STA = [108.2532, 16.0212]
cam5 = [dict(f=0, c=[108.2480, 16.0230], z=13.3, p=45, b=-15), dict(f=110, c=[108.2560, 15.9900], z=11.75, p=38, b=-12), dict(f=240, c=[108.2620, 15.9780], z=11.5, p=36, b=-10)]
ev5 = [
  dict(type='project', **I(i=0), lotsIn=0, out=None, rise=[0, 1]),
  dict(type='route', coords=RAIL, dash=True, color='#5CF2E6', width=6, glowW=22, **I(i=6), dur=100, out=None, plane=True, icon='train'),
  dict(type='poi', name='Ga dự kiến', icon='train', at=STA, **I(i=30), out=112, beam=80, small=True, showDist=False, sub='≈ 500 m', dx=-150),
  dict(type='poi', name='Sun Saphia', icon='star', at=PROJ, **I(i=20), out=None, beam=150, small=True, showDist=False, sub='', dx=150),
  dict(type='poi', name='Sân bay', icon='plane', at=[108.2030, 16.0552], **I(i=120), out=None, beam=90, small=True, showDist=False, sub='~8 km · 15–20 phút', dx=-110),
  dict(type='poi', name='Cầu Rồng', icon='bridge', at=[108.2272, 16.0612], **I(i=138), out=None, beam=150, small=True, showDist=False, sub='~6 km · 15 phút', dx=60),
  dict(type='poi', name='Ngũ Hành Sơn', icon='mountain', at=[108.26382, 16.00292], **I(i=156), out=None, beam=70, small=True, showDist=False, sub='~3 km · 5 phút', dx=170),
  dict(type='poi', name='Phố cổ Hội An', icon='star', at=[108.3262, 15.8770], **I(i=174), out=None, beam=90, small=True, showDist=False, sub='~25 km · 30 phút', dx=-80),
]
write('config5.js', 240, NIGHT, cam5, ev5, 'VIDEO GIỚI THIỆU – phần đêm 30–38 s')
print('ok')
