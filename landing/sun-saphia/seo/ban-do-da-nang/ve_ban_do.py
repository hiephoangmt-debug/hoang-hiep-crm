"""Vẽ bản đồ Đà Nẵng (SVG) theo tọa độ thật (lon/lat, phép chiếu đều có hiệu chỉnh cos vĩ độ).
Đường bờ biển: phác theo Natural Earth 10m + tọa độ các điểm mốc; mang tính minh họa."""
import math, sys

SEA = [  # (lon, lat) – vùng biển: vịnh Đà Nẵng + Biển Đông
 (108.205,16.30),(108.60,16.30),(108.60,15.90),(108.305,15.90),(108.290,15.950),(108.280,15.985),(108.272,16.010),
 (108.2685,16.024),(108.264,16.040),(108.259,16.058),(108.256,16.072),(108.256,16.085),(108.259,16.098),
 (108.270,16.104),(108.284,16.100),(108.300,16.101),(108.316,16.108),(108.333,16.118),(108.347,16.130),
 (108.343,16.143),(108.328,16.152),(108.308,16.142),(108.288,16.150),(108.265,16.160),(108.246,16.156),
 (108.234,16.145),(108.224,16.133),(108.217,16.122),(108.221,16.110),(108.228,16.101),(108.229,16.094),
 (108.222,16.092),(108.212,16.086),(108.200,16.079),(108.188,16.075),(108.172,16.081),(108.157,16.091),
 (108.146,16.103),(108.137,16.116),(108.133,16.128),(108.137,16.148),(108.150,16.170),(108.172,16.190),
 (108.195,16.203),(108.205,16.30)]
SONTRA = [(108.2300,16.0985)] + SEA[SEA.index((108.259,16.098)):SEA.index((108.228,16.101))+1]
HAIVAN = [(108.00,16.30),(108.205,16.30),(108.196,16.205),(108.176,16.193),(108.155,16.175),(108.142,16.152),
 (108.120,16.150),(108.090,16.140),(108.060,16.150),(108.00,16.170)]
WEST_HILLS = [(107.95,16.10),(108.05,16.10),(108.085,16.06),(108.10,16.00),(108.09,15.95),(107.95,15.95)]
HAN = [(108.2245,16.0935),(108.2240,16.082),(108.2262,16.070),(108.2278,16.060),(108.2300,16.048),(108.2310,16.037),
 (108.2290,16.025),(108.2250,16.012),(108.2210,16.000),(108.2150,15.988),(108.2080,15.975)]
CUDE = [(108.1340,16.1225),(108.120,16.126),(108.100,16.124),(108.080,16.130),(108.055,16.128),(108.02,16.135)]
CAMLE = [(108.2200,15.998),(108.205,15.995),(108.190,15.990),(108.170,15.985),(108.140,15.990)]
ROADS = {  # tên: (điểm, độ đậm)
 'Võ Nguyên Giáp – Trường Sa': ([(108.2525,16.090),(108.2525,16.072),(108.2555,16.058),(108.2605,16.040),(108.2645,16.024),(108.2685,16.008),(108.2745,15.990),(108.283,15.965)],1),
 'Nguyễn Tất Thành': ([(108.2205,16.088),(108.205,16.0815),(108.190,16.077),(108.172,16.083),(108.157,16.094),(108.146,16.106),(108.139,16.120)],1),
 'Nguyễn Văn Linh – Võ Văn Kiệt': ([(108.206,16.0605),(108.2275,16.0612),(108.240,16.0625),(108.2565,16.0635)],1),
 'Điện Biên Phủ': ([(108.208,16.0665),(108.190,16.0665),(108.172,16.0640)],0),
 'Trần Thị Lý – Hồ Xuân Hương': ([(108.216,16.0478),(108.2310,16.0485),(108.2355,16.0480)],0),
 'Hồ Xuân Hương': ([(108.2190,16.0372),(108.2305,16.0370),(108.244,16.0350),(108.2585,16.0335),(108.2620,16.0332)],0),
 'Lê Văn Hiến': ([(108.2355,16.0480),(108.2410,16.035),(108.2480,16.020),(108.2560,16.005),(108.262,15.995)],0),
 'Nguyễn Hữu Thọ': ([(108.212,16.0600),(108.214,16.040),(108.2165,16.020),(108.218,16.000)],0),
 'Tôn Đức Thắng – QL1A': ([(108.172,16.0640),(108.160,16.0700),(108.148,16.080),(108.135,16.095),(108.122,16.112)],0),
 'Ngô Quyền': ([(108.2410,16.100),(108.2400,16.0800),(108.2380,16.0620),(108.2365,16.0490)],0),
}
BRIDGES = [('Cầu Thuận Phước',(108.2245,16.0915),'r'),('Cầu sông Hàn',(108.2262,16.0720),'u'),('Cầu Rồng',(108.2278,16.0612),'l'),
 ('Cầu Trần Thị Lý',(108.2302,16.0485),'l'),('Cầu Tiên Sơn',(108.2308,16.0370),'r')]

def make(W, H, lon0, lat1, span_lon, fs=1.0, poster=False):
    k = W / (span_lon * math.cos(math.radians(16.05)))
    def P(lon, lat): return ((lon - lon0) * math.cos(math.radians(16.05)) * k, (lat1 - lat) * k)
    def path(pts, close=True):
        q = [P(*p) for p in pts]
        # đường cong mềm (Catmull-Rom → Bezier)
        n = len(q); d = 'M%.1f %.1f' % q[0]
        rng = range(n if close else n - 1)
        for i in rng:
            p0 = q[(i - 1) % n] if (close or i > 0) else q[i]; p1 = q[i]; p2 = q[(i + 1) % n]
            p3 = q[(i + 2) % n] if (close or i + 2 < n) else p2
            c1 = (p1[0] + (p2[0] - p0[0]) / 6, p1[1] + (p2[1] - p0[1]) / 6)
            c2 = (p2[0] - (p3[0] - p1[0]) / 6, p2[1] - (p3[1] - p1[1]) / 6)
            d += ' C%.1f %.1f %.1f %.1f %.1f %.1f' % (c1 + c2 + p2)
        return d + (' Z' if close else '')
    def lab(lon, lat, t, size=15, w=600, col='#4a5a75', anchor='middle', dx=0, dy=0, ls=0, halo='#eef3f9', it=False):
        x, y = P(lon, lat); s = size * fs
        st = 'font-style:italic;' if it else ''
        return ('<text x="%.1f" y="%.1f" text-anchor="%s" style="font:%d %.1fpx \'Be Vietnam Pro\',sans-serif;letter-spacing:%.1fpx;%s" fill="%s" stroke="%s" stroke-width="%.1f" paint-order="stroke" stroke-linejoin="round">%s</text>'
                % (x + dx * fs, y + dy * fs, anchor, w, s, ls, st, col, halo, 4 * fs if halo else 0, t))
    def icon(lon, lat, emoji, t, side='r', col='#28456f', sz=13, dx=0, dy=0):
        x, y = P(lon, lat); x += dx * fs; y += dy * fs; r = 13 * fs
        o = '<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#fff" stroke="#2a6fd0" stroke-width="%.1f"/><text x="%.1f" y="%.1f" text-anchor="middle" dominant-baseline="central" style="font-size:%.1fpx">%s</text>' % (x, y, r, 2 * fs, x, y + 1, 14 * fs, emoji)
        tx = x + (r + 6 * fs) * (1 if side == 'r' else -1)
        o += '<text x="%.1f" y="%.1f" text-anchor="%s" dominant-baseline="central" style="font:700 %.1fpx \'Be Vietnam Pro\',sans-serif" fill="%s" stroke="#fff" stroke-width="%.1f" paint-order="stroke" stroke-linejoin="round">%s</text>' % (tx, y, 'start' if side == 'r' else 'end', sz * fs, col, 4 * fs, t)
        return o
    o = ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %d %d" width="%d" height="%d">' % (W, H, W, H)]
    o.append('''<defs>
<linearGradient id="sea" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#1d6fd0"/><stop offset=".55" stop-color="#155cbc"/><stop offset="1" stop-color="#0c3f8f"/></linearGradient>
<radialGradient id="bay" cx=".5" cy=".5" r=".5"><stop offset="0" stop-color="#3a9ff0" stop-opacity=".55"/><stop offset="1" stop-color="#3a9ff0" stop-opacity="0"/></radialGradient>
<linearGradient id="hill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#2f7a62"/><stop offset="1" stop-color="#5aa585"/></linearGradient>
<filter id="sh" x="-20%" y="-20%" width="140%" height="140%"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="#0b2447" flood-opacity=".35"/></filter>
<filter id="glow"><feGaussianBlur stdDeviation="6"/></filter>
</defs>''')
    o.append('<rect width="%d" height="%d" fill="#eaf0f7"/>' % (W, H))
    # khối phố (lưới nhẹ) vùng trung tâm
    o.append('<path d="%s" fill="url(#hill)" opacity=".9"/>' % path(HAIVAN))
    o.append('<clipPath id="sc0"><path d="%s"/></clipPath><path d="%s" fill="url(#sea)"/>' % (path(SEA), path(SEA)))
    # vệt sáng bờ biển + cát
    o.append('<path clip-path="url(#sc0)" d="%s" fill="none" stroke="#ffffff" stroke-opacity=".5" stroke-width="%.1f" filter="url(#glow)"/>' % (path(SEA), 16 * fs))
    o.append('<path d="%s" fill="none" stroke="#f3dfae" stroke-width="%.1f"/>' % (path(SEA), 3.5 * fs))
    bx, by = P(108.19, 16.135); o.append('<clipPath id="sc"><path d="%s"/></clipPath><ellipse clip-path="url(#sc)" cx="%.1f" cy="%.1f" rx="%.1f" ry="%.1f" fill="url(#bay)"/>' % (path(SEA), bx, by, 0.07 * k, 0.04 * k))
    o.append('<path d="%s" fill="url(#hill)" opacity=".92"/>' % path(SONTRA))
    # sông
    for r, wd in ((HAN, 11), (CUDE, 7), (CAMLE, 8)):
        o.append('<path d="%s" fill="none" stroke="#2f86e0" stroke-width="%.1f" stroke-linecap="round"/>' % (path(r, False), wd * fs))
    # sân bay
    a1, a2 = P(108.1985, 16.0690), P(108.1940, 16.0425)
    for off in (-5, 5):
        o.append('<line x1="%.1f" y1="%.1f" x2="%.1f" y2="%.1f" stroke="#b8c2d0" stroke-width="%.1f"/>' % (a1[0] + off * fs, a1[1], a2[0] + off * fs, a2[1], 7 * fs))
    # đường
    for name, (pts, bold) in ROADS.items():
        o.append('<path d="%s" fill="none" stroke="#c9d3e1" stroke-width="%.1f" stroke-linecap="round"/>' % (path(pts, False), (6.5 if bold else 4.5) * fs))
        o.append('<path d="%s" fill="none" stroke="#ffffff" stroke-width="%.1f" stroke-linecap="round"/>' % (path(pts, False), (4.5 if bold else 2.8) * fs))
    # cầu
    for n, (lo, la), side in BRIDGES:
        x, y = P(lo, la)
        o.append('<rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" rx="%.1f" fill="#f2a516" stroke="#fff" stroke-width="%.1f"/>' % (x - 13 * fs, y - 3.5 * fs, 26 * fs, 7 * fs, 3 * fs, 1.2 * fs))
        if side == 'u': o.append(lab(lo, la, n, 12.5, 700, '#7a4a07', 'middle', dy=-12))
        else: o.append(lab(lo, la, n, 12.5, 700, '#7a4a07', 'start' if side == 'r' else 'end', dx=(16 if side == 'r' else -16), dy=4))
    # vùng/quận
    for lo, la, t in ((108.128, 16.092, 'LIÊN CHIỂU'), (108.174, 16.0635, 'THANH KHÊ'), (108.2115, 16.026, 'HẢI CHÂU'),
                      (108.243, 16.084, 'SƠN TRÀ'), (108.240, 16.012, 'NGŨ HÀNH SƠN'), (108.185, 16.005, 'CẨM LỆ')):
        o.append(lab(lo, la, t, 17, 800, '#1f3a63', ls=1.5))
    o.append(lab(108.205, 16.135, 'VỊNH ĐÀ NẴNG', 26, 800, '#ffffff', halo='', ls=3))
    o.append(lab(108.345, 16.060, 'BIỂN ĐÔNG', 26, 800, '#ffffff', halo='', ls=3))
    o.append(lab(108.290, 16.128, 'Bán đảo Sơn Trà', 16, 700, '#ffffff', halo='', it=True))
    o.append(lab(108.115, 16.170, 'Đèo Hải Vân', 15, 700, '#ffffff', halo='', it=True))
    o.append(lab(108.1050, 16.124, 'Sông Cu Đê', 12, 600, '#1d5fb8', dy=-8))
    o.append(lab(108.2205, 16.016, 'Sông Hàn', 13, 700, '#1d5fb8', 'end', dx=-6))
    o.append(lab(108.2620, 16.066, 'Bãi biển Mỹ Khê', 13, 700, '#ffffff', 'start', halo='', it=True))
    o.append(lab(108.1880, 16.090, 'Bãi biển Nguyễn Tất Thành', 12, 600, '#ffffff', halo='', dy=-4, it=True))
    # biểu tượng địa điểm
    o.append(icon(108.1962, 16.0555, '✈️', 'Sân bay quốc tế', 'l', sz=13, dx=-12, dy=12))
    o.append(icon(108.2307, 16.0715, '🏬', 'Vincom Plaza', 'r', sz=12, dx=10))
    o.append(icon(108.2262, 16.0398, '🛒', 'Lotte Mart', 'l', sz=12, dx=-4))
    o.append(icon(108.2095, 16.0717, '🚆', 'Ga Đà Nẵng', 'l', sz=12))
    o.append(icon(108.2190, 16.1215, '⚓', 'Cảng Tiên Sa', 'l', sz=12))
    o.append(icon(108.2779, 16.1004, '🛕', 'Chùa Linh Ứng', 'r', sz=12, dy=10))
    o.append(icon(108.1330, 16.1320, '🏭', 'Cảng Liên Chiểu', 'l', sz=12))
    o.append(icon(108.2615, 16.0020, '⛰️', 'Núi Ngũ Hành Sơn', 'l', sz=12, dx=-4, dy=6))
    o.append(icon(108.2400, 16.0400, '🎡', 'Asia Park', 'l', sz=12, dx=-6, dy=4) if False else '')
    # resort ven biển
    for lo, la, t in ((108.2588, 16.0455, 'Premier Village'), (108.2600, 16.0420, 'Pullman'), (108.2615, 16.0385, 'Furama'),
                      (108.2680, 16.0125, 'Hyatt Regency'), (108.2715, 16.0030, 'Sheraton Grand')):
        x, y = P(lo, la); o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#d9a441" stroke="#fff" stroke-width="%.1f"/>' % (x, y, 5 * fs, 1.6 * fs))
        o.append(lab(lo, la, t, 11.5, 700, '#ffffff', 'start', dx=9, dy=4, halo='#0f4fa8'))
    # SUN SAPHIA
    x, y = P(108.2640, 16.0240)
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#ff9a3c" opacity=".35" filter="url(#glow)"/>' % (x, y, 30 * fs))
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="none" stroke="#E96118" stroke-width="%.1f" opacity=".6"/>' % (x, y, 22 * fs, 2.5 * fs))
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#E96118" stroke="#fff" stroke-width="%.1f"/>' % (x, y, 11 * fs, 3 * fs))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" dominant-baseline="central" fill="#fff" style="font-size:%.1fpx">★</text>' % (x, y + 0.5, 12 * fs))
    bw, bh = 236 * fs, 58 * fs; bx, by = x + 46 * fs, y - bh / 2
    o.append('<line x1="%.1f" y1="%.1f" x2="%.1f" y2="%.1f" stroke="#E96118" stroke-width="%.1f"/>' % (bx, by + bh / 2, x + 11 * fs, y, 2.5 * fs))
    o.append('<g filter="url(#sh)"><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" rx="%.1f" fill="#E96118"/></g>' % (bx, by, bw, bh, 12 * fs))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" style="font:800 %.1fpx \'Be Vietnam Pro\',sans-serif;letter-spacing:1px" fill="#fff">SUN SAPHIA</text>' % (bx + bw / 2, by + 26 * fs, 20 * fs))
    o.append('<text x="%.1f" y="%.1f" text-anchor="middle" style="font:600 %.1fpx \'Be Vietnam Pro\',sans-serif" fill="#fff">Võ Nguyên Giáp – Nguyễn Đức Thuận</text>' % (bx + bw / 2, by + 46 * fs, 12.5 * fs))
    # la bàn + thước tỷ lệ
    cx, cy = W - 46 * fs, 46 * fs
    o.append('<circle cx="%.1f" cy="%.1f" r="%.1f" fill="#0b2447" opacity=".55"/><path d="M%.1f %.1fl%.1f %.1fl-%.1f -%.1fl-%.1f %.1fz" fill="#fff"/><text x="%.1f" y="%.1f" text-anchor="middle" style="font:800 %.1fpx sans-serif" fill="#fff">B</text>'
             % (cx, cy, 24 * fs, cx, cy - 16 * fs, 8 * fs, 22 * fs, 8 * fs, 6 * fs, 8 * fs, 16 * fs, cx, cy + 17 * fs, 10 * fs))
    km = k * 1 / 111.32 / 1  # px cho 1 km theo vĩ độ
    sx, sy = 24 * fs, H - (130 if poster else 26) * fs
    o.append('<g><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" fill="#0b2447"/><rect x="%.1f" y="%.1f" width="%.1f" height="%.1f" fill="#fff" stroke="#0b2447"/>' % (sx, sy, km, 6 * fs, sx + km, sy, km, 6 * fs))
    o.append('<text x="%.1f" y="%.1f" style="font:700 %.1fpx \'Be Vietnam Pro\',sans-serif" fill="#0b2447" stroke="#eaf0f7" stroke-width="3" paint-order="stroke">0 · 1 · 2 km</text></g>' % (sx, sy - 6 * fs, 12 * fs))
    o.append('</svg>')
    return '\n'.join(o)

if __name__ == '__main__':
    import pathlib; here = pathlib.Path(__file__).parent
    # bản đứng riêng 1600×1200
    (here / 'ban-do-da-nang.svg').write_text(make(1600, 1200, 108.085, 16.205, 0.305, fs=1.35), encoding='utf8')
    # bản cho poster 1080×560
    (here / 'ban-do-poster.svg').write_text(make(1080, 540, 108.015, 16.150, 0.420, fs=0.85, poster=True), encoding='utf8')
