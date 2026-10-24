"""Vẽ bản đồ Đà Nẵng (SVG) đúng tỷ lệ.
- Trong khung ảnh Google Maps tham chiếu (google-maps-tham-chieu.png, thước 2 km): bờ biển, vịnh, sông lấy từ nuoc.json (trich_nuoc.py).
- Ngoài khung (Liên Chiểu, Hải Vân, mũi Sơn Trà): phác theo Natural Earth + tọa độ mốc, nối khớp với mép khung."""
import math, json, pathlib
here = pathlib.Path(__file__).parent
D = json.load(open(here / 'nuoc.json'))
(BX0, BY0), (BX1, BY1) = D['box']          # lon trái, lat trên, lon phải, lat dưới
COS = math.cos(math.radians(16.05))

# Biển ngoài khung (chỉ phần nằm ngoài khung được vẽ)
SEA_OUT = [(108.205,16.40),(108.60,16.40),(108.60,15.90),(108.300,15.90),(108.285,15.960),(108.276,15.991),
 (108.290,16.05),(108.300,16.104),
 (108.311,16.1074),(108.325,16.108),(108.335,16.112),(108.340,16.118),(108.334,16.124),(108.322,16.1275),(108.311,16.129),
 (108.290,16.145),(108.270,16.1450),(108.266,16.152),(108.256,16.158),(108.246,16.157),(108.239,16.151),(108.235,16.1445),
 (108.20,16.12),(108.176,16.0753),(108.172,16.0770),(108.160,16.087),(108.148,16.100),(108.139,16.114),
 (108.134,16.128),(108.137,16.148),(108.150,16.170),(108.172,16.190),(108.195,16.203),(108.205,16.40)]
HAIVAN = [(107.90,16.40),(108.205,16.40),(108.196,16.205),(108.176,16.193),(108.155,16.175),(108.142,16.152),
 (108.120,16.150),(108.090,16.140),(108.060,16.150),(107.90,16.170)]
SONTRA_G = [(108.214,16.30),(108.45,16.30),(108.45,16.1035),(108.262,16.1035),(108.251,16.1065),(108.243,16.110),
 (108.233,16.115),(108.222,16.120),(108.214,16.13)]
CUDE = [(108.1360,16.1225),(108.120,16.126),(108.100,16.124),(108.080,16.130),(108.055,16.128),(107.98,16.135)]
COAST = [tuple(p) for p in D['coast']]      # bờ đông, theo hàng từ bắc xuống nam

def coast_lon(lat):
    best = min(COAST, key=lambda p: abs(p[1] - lat)); return best[0]
def river(lat):
    ks = sorted(D['river'].items(), key=lambda kv: abs(BY0 - (int(kv[0])) / 9133.0 - lat))
    for k, v in ks:
        if v: return v[0]
VNG = [(coast_lon(la) - 0.0016, la) for la in [16.092 - i * 0.004 for i in range(26)] if la > BY1 + 0.001]
BR = {n: river(la) for n, la in [('Cầu Thuận Phước', 16.0905), ('Cầu sông Hàn', 16.0720), ('Cầu Rồng', 16.0612),
                                  ('Cầu Trần Thị Lý', 16.0485), ('Cầu Tiên Sơn', 16.0372)]}

def make(W, H, lon0, lat1, span_lon, fs=1.0, poster=False):
    k = W / (span_lon * COS)
    def P(lon, lat): return ((lon - lon0) * COS * k, (lat1 - lat) * k)
    def poly(pts, close=True):
        q = [P(*p) for p in pts]
        return 'M' + ' L'.join('%.1f %.1f' % p for p in q) + (' Z' if close else '')
    def smooth(pts, close=True):
        q = [P(*p) for p in pts]; n = len(q); d = 'M%.1f %.1f' % q[0]
        for i in range(n if close else n - 1):
            p0 = q[(i - 1) % n] if (close or i > 0) else q[i]; p1 = q[i]; p2 = q[(i + 1) % n]
            p3 = q[(i + 2) % n] if (close or i + 2 < n) else p2
            c1 = (p1[0] + (p2[0] - p0[0]) / 6, p1[1] + (p2[1] - p0[1]) / 6); c2 = (p2[0] - (p3[0] - p1[0]) / 6, p2[1] - (p3[1] - p1[1]) / 6)
            d += ' C%.1f %.1f %.1f %.1f %.1f %.1f' % (c1 + c2 + p2)
        return d + (' Z' if close else '')
    F = "'Be Vietnam Pro',sans-serif"
    def lab(lon, lat, t, size=15, w=600, col='#4a5a75', anchor='middle', dx=0, dy=0, ls=0, halo='#eef3f9', it=False):
        x, y = P(lon, lat); s = size * fs
        return ('<text x="%.1f" y="%.1f" text-anchor="%s" style="font:%s%d %.1fpx %s;letter-spacing:%.1fpx" fill="%s" stroke="%s" stroke-width="%.1f" paint-order="stroke" stroke-linejoin="round">%s</text>'
                % (x + dx * fs, y + dy * fs, anchor, 'italic ' if it else '', w, s, F, ls, col, halo or 'none', 4 * fs if halo else 0, t))
    def icon(lon, lat, emoji, t, side='r', sz=12.5, dx=0, dy=0):
        x, y = P(lon, lat); r = 12 * fs
        o = '<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#fff" stroke="#2a6fd0" stroke-width="%.1f"/><text x="%.1f" y="%.1f" text-anchor="middle" dominant-baseline="central" style="font-size:%.1fpx">%s</text>' % (x, y, r, 2 * fs, x, y + 1, 13 * fs, emoji)
        tx = x + (r + 5 * fs) * (1 if side == 'r' else -1) + dx * fs
        o += '<text x="%.1f" y="%.1f" text-anchor="%s" dominant-baseline="central" style="font:700 %.1fpx %s" fill="#28456f" stroke="#fff" stroke-width="%.1f" paint-order="stroke" stroke-linejoin="round">%s</text>' % (tx, y + dy * fs, 'start' if side == 'r' else 'end', sz * fs, F, 4 * fs, t)
        return o
    bx0, by0 = [round(v) for v in P(BX0, BY0)]; bx1, by1 = [round(v) for v in P(BX1, BY1)]
    boxr = 'M%d %d H%d V%d H%d Z' % (bx0, by0, bx1, by1, bx0)
    water_in = ' '.join(poly(p) for p in D['polys'])
    o = ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %d %d" width="%d" height="%d">' % (W, H, W, H)]
    o.append('''<defs>
<linearGradient id="sea" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="%d" y2="%d"><stop offset="0" stop-color="#1d6fd0"/><stop offset=".55" stop-color="#155cbc"/><stop offset="1" stop-color="#0c3f8f"/></linearGradient>
<radialGradient id="bay" cx=".5" cy=".5" r=".5"><stop offset="0" stop-color="#4aa8f2" stop-opacity=".55"/><stop offset="1" stop-color="#4aa8f2" stop-opacity="0"/></radialGradient>
<linearGradient id="hill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#2f7a62"/><stop offset="1" stop-color="#5aa585"/></linearGradient>
<filter id="sh" x="-20%%" y="-20%%" width="140%%" height="140%%"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="#0b2447" flood-opacity=".35"/></filter>
<filter id="glow"><feGaussianBlur stdDeviation="6"/></filter>
<clipPath id="out"><path clip-rule="evenodd" d="M-10 -10 H%d V%d H-10 Z %s"/></clipPath>
<clipPath id="in"><path d="%s"/></clipPath>
<clipPath id="in2"><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f"/></clipPath>
</defs>''' % (W, H, W + 10, H + 10, boxr, boxr, bx0 + 3, by0 + 3, bx1 - bx0 - 6, by1 - by0 - 6))
    o.append('<rect width="%d" height="%d" fill="#eaf0f7"/>' % (W, H))
    o.append('<path d="%s" fill="url(#hill)"/>' % smooth(HAIVAN))
    o.append('<path d="%s" fill="url(#hill)" opacity=".92"/>' % smooth(SONTRA_G))
    sea_out = smooth(SEA_OUT)
    o.append('<g id="water"><path clip-path="url(#out)" d="%s" fill="url(#sea)" shape-rendering="crispEdges"/><path clip-path="url(#in)" fill-rule="evenodd" d="%s" fill="url(#sea)"/>' % (sea_out, water_in))
    o.append('<path d="%s" fill="none" stroke="#2f86e0" stroke-width="%.1f" stroke-linecap="round"/></g>' % (smooth(CUDE, False), 7 * fs))
    # viền cát + vệt sáng
    o.append('<g fill="none" stroke-linejoin="round"><path clip-path="url(#out)" d="%s" stroke="#f3dfae" stroke-width="%.1f"/><path clip-path="url(#in2)" d="%s" stroke="#f3dfae" stroke-width="%.1f"/></g>' % (sea_out, 3 * fs, water_in, 2.2 * fs))
    cx, cy = P(108.20, 16.13)
    o.append('<clipPath id="wc"><path clip-path="url(#out)" d="%s"/><path clip-path="url(#in)" fill-rule="evenodd" d="%s"/></clipPath>' % (sea_out, water_in))
    o.append('<ellipse clip-path="url(#wc)" cx="%.1f" cy="%.1f" rx="%.1f" ry="%.1f" fill="url(#bay)"/>' % (cx, cy, 0.07 * k, 0.045 * k))
    # sân bay (theo ảnh Google: 2 đường băng song song)
    for d in (-0.0011, 0.0011):
        a, b = P(108.2004 + d, 16.0650), P(108.2052 + d, 16.0355)
        o.append('<line x1="%.1f" y1="%.1f" x2="%.1f" y2="%.1f" stroke="#b8c2d0" stroke-width="%.1f" stroke-linecap="round"/>' % (a + b + (6 * fs,)))
    # đường
    roads = [
        (VNG, 1),
        ([(108.2215, 16.0885), (108.2100, 16.0825), (108.1960, 16.0775), (108.1840, 16.0760), (108.1720, 16.0790), (108.1600, 16.0890), (108.1480, 16.1020), (108.1400, 16.1150)], 1),   # Nguyễn Tất Thành
        ([(108.2090, 16.0605), BR['Cầu Rồng'], (coast_lon(16.0625) - 0.0016, 16.0625)], 1),   # Nguyễn Văn Linh – Võ Văn Kiệt
        ([(108.2120, 16.0490), BR['Cầu Trần Thị Lý'], (coast_lon(16.0480) - 0.0016, 16.0480)], 0),
        ([(108.2150, 16.0400), BR['Cầu Tiên Sơn'], (108.2380, 16.0368), (coast_lon(16.0350) - 0.0016, 16.0350)], 0),   # Hồ Xuân Hương
        ([(108.2412, 16.0830), (108.2410, 16.0680), (108.2420, 16.0560), (108.2470, 16.0440), (108.2560, 16.0250), (108.2620, 16.0090), (108.2650, 15.995)], 0),   # Ngô Quyền – Lê Văn Hiến
        ([(108.1790, 16.0740), (108.1860, 16.0560), (108.1950, 16.0340), (108.1950, 16.0100)], 0),   # QL1A
        ([(108.2120, 16.0660), (108.1900, 16.0665), (108.1720, 16.0650)], 0),   # Điện Biên Phủ
    ]
    for pts, bold in roads:
        o.append('<path d="%s" fill="none" stroke="#c9d3e1" stroke-width="%.1f" stroke-linecap="round" stroke-linejoin="round"/>' % (smooth(pts, False), (6.5 if bold else 4.5) * fs))
        o.append('<path d="%s" fill="none" stroke="#ffffff" stroke-width="%.1f" stroke-linecap="round" stroke-linejoin="round"/>' % (smooth(pts, False), (4.5 if bold else 2.8) * fs))
    # cầu
    side = {'Cầu Thuận Phước': 'r', 'Cầu sông Hàn': 'u', 'Cầu Rồng': 'l', 'Cầu Trần Thị Lý': 'l', 'Cầu Tiên Sơn': 'l'}
    for n, (lo, la) in BR.items():
        x, y = P(lo, la)
        o.append('<rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" rx="%.1f" fill="#f2a516" stroke="#fff" stroke-width="%.1f"/>' % (x - 12 * fs, y - 3.5 * fs, 24 * fs, 7 * fs, 3 * fs, 1.2 * fs))
        sd = side[n]
        if sd == 'u': o.append(lab(lo, la, n, 12, 700, '#7a4a07', 'middle', dy=-10))
        else: o.append(lab(lo, la, n, 12, 700, '#7a4a07', 'start' if sd == 'r' else 'end', dx=(15 if sd == 'r' else -15), dy=4))
    for lo, la, t in ((108.140, 16.078, 'LIÊN CHIỂU'), (108.1795, 16.0660, 'THANH KHÊ'), (108.2135, 16.0540, 'HẢI CHÂU'),
                      (108.2470, 16.0790, 'SƠN TRÀ'), (108.2400, 16.0160, 'NGŨ HÀNH SƠN'), (108.2050, 16.0120, 'CẨM LỆ')):
        o.append(lab(lo, la, t, 16, 800, '#1f3a63', ls=1.5))
    o.append(lab(108.190, 16.128, 'VỊNH ĐÀ NẴNG', 25, 800, '#ffffff', halo='', ls=3))
    o.append(lab(108.330, 16.060, 'BIỂN ĐÔNG', 25, 800, '#ffffff', halo='', ls=3))
    o.append(lab(108.290, 16.122, 'Bán đảo Sơn Trà', 15, 700, '#ffffff', halo='', it=True))
    o.append(lab(108.110, 16.180, 'Đèo Hải Vân', 14, 700, '#ffffff', halo='', it=True))
    o.append(lab(108.1060, 16.1250, 'Sông Cu Đê', 11.5, 600, '#1d5fb8', dy=-8))
    o.append(lab(108.2312, 16.0250, 'Sông Hàn', 12, 700, '#1d5fb8', 'start', dx=4))
    o.append(lab(108.2620, 16.0680, 'Bãi biển Mỹ Khê', 12.5, 700, '#ffffff', 'start', halo='', it=True))
    o.append(lab(108.1820, 16.0860, 'Bãi biển Nguyễn Tất Thành', 11.5, 600, '#ffffff', halo='', it=True))
    o.append(icon(108.2030, 16.0400, '✈️', 'Sân bay quốc tế', 'l', dx=-4))
    o.append(icon(108.2330, 16.0715, '🏬', 'Vincom Plaza', 'r'))
    lm = BR['Cầu Tiên Sơn']; o.append(icon(lm[0] - 0.0030, 16.0418, '🛒', 'Lotte Mart', 'l'))
    o.append(icon(108.2095, 16.0717, '🚆', 'Ga Đà Nẵng', 'l'))
    o.append(icon(108.2300, 16.1150, '⚓', 'Cảng Tiên Sa', 'l', dx=-2))
    o.append(icon(108.2785, 16.0994, '🛕', 'Chùa Linh Ứng', 'r'))
    o.append(icon(108.1340, 16.1340, '🏭', 'Cảng Liên Chiểu', 'l'))
    o.append(icon(108.2625, 16.0035, '⛰️', 'Núi Ngũ Hành Sơn', 'l'))
    for la, t in ((16.0455, 'Premier Village'), (16.0420, 'Pullman'), (16.0385, 'Furama'), (16.0125, 'Hyatt Regency'), (16.0030, 'Sheraton Grand')):
        lo = coast_lon(la) - 0.0008; x, y = P(lo, la)
        o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#d9a441" stroke="#fff" stroke-width="%.1f"/>' % (x, y, 5 * fs, 1.6 * fs))
        o.append(lab(lo, la, t, 11, 700, '#ffffff', 'start', dx=10, dy=4, halo='#0f4fa8'))
    # SUN SAPHIA: cách mép biển ~400 m
    sla = 16.0260; slo = coast_lon(sla) - 0.4 / (111.32 * COS); x, y = P(slo, sla)
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#ff9a3c" opacity=".35" filter="url(#glow)"/>' % (x, y, 30 * fs))
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="none" stroke="#E96118" stroke-width="%.1f" opacity=".6"/>' % (x, y, 22 * fs, 2.5 * fs))
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#E96118" stroke="#fff" stroke-width="%.1f"/>' % (x, y, 11 * fs, 3 * fs))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" dominant-baseline="central" fill="#fff" style="font-size:%.1fpx">★</text>' % (x, y + 0.5, 12 * fs))
    bw, bh = 236 * fs, 58 * fs; px, py = x + 50 * fs, y - bh / 2
    o.append('<line x1="%.1f" y1="%.1f" x2="%.1f" y2="%.1f" stroke="#E96118" stroke-width="%.1f"/>' % (px, py + bh / 2, x + 11 * fs, y, 2.5 * fs))
    o.append('<g filter="url(#sh)"><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" rx="%.1f" fill="#E96118"/></g>' % (px, py, bw, bh, 12 * fs))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" style="font:800 %.1fpx %s;letter-spacing:1px" fill="#fff">SUN SAPHIA</text>' % (px + bw / 2, py + 26 * fs, 20 * fs, F))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" style="font:600 %.1fpx %s" fill="#fff">Võ Nguyên Giáp – Nguyễn Đức Thuận</text>' % (px + bw / 2, py + 46 * fs, 12.5 * fs, F))
    # la bàn + thước tỷ lệ 2 km
    cx, cy = W - 46 * fs, 46 * fs
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#0b2447" opacity=".55"/><path d="M%.1f %.1fl%.1f %.1fl-%.1f -%.1fl-%.1f %.1fz" fill="#fff"/><text x="%.1f" y="%.1f" text-anchor="middle" style="font:800 %.1fpx sans-serif" fill="#fff">B</text>'
             % (cx, cy, 24 * fs, cx, cy - 16 * fs, 8 * fs, 22 * fs, 8 * fs, 6 * fs, 8 * fs, 16 * fs, cx, cy + 17 * fs, 10 * fs))
    km = k / (111.32 * COS)
    sx, sy = 24 * fs, (H - 26 * fs) if not poster else 410
    o.append('<rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" fill="#0b2447"/><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" fill="#fff" stroke="#0b2447"/>' % (sx, sy, km, 6 * fs, sx + km, sy, km, 6 * fs))
    o.append('<text x="%.1f" y="%.1f" style="font:700 %.1fpx %s" fill="#0b2447" stroke="#eaf0f7" stroke-width="3" paint-order="stroke">0 · 1 · 2 km</text>' % (sx, sy - 6 * fs, 12 * fs, F))
    if not poster: o.append('<text x="%.1f" y="%.1f" text-anchor="end" style="font:500 %.1fpx %s" fill="#4a5a75" stroke="#eaf0f7" stroke-width="3" paint-order="stroke">Bờ biển, sông theo Google Maps · vị trí minh họa</text>' % (W - 16 * fs, sy + 5 * fs, 11 * fs, F))
    o.append('</svg>')
    return '\n'.join(o)

if __name__ == '__main__':
    (here / 'ban-do-da-nang.svg').write_text(make(1600, 1200, 108.085, 16.212, 0.305, fs=1.35), encoding='utf8')
    (here / 'ban-do-poster.svg').write_text(make(1080, 540, 108.045, 16.135, 0.330, fs=0.9, poster=True), encoding='utf8')
