"""Sinh logo Cầu Vàng kiểu nét vẽ tay (SVG). Chạy: python3 ve_net.py
Lớp vẽ từ sau ra trước: tay xa · 4 ngón tay lớn · cầu (tô nền giấy che chân ngón) · trụ Y ·
lòng bàn tay dưới mặt cầu · ngón cái (tô nền giấy che cầu) · vách đá & mây."""
import os

def yt(x):  # mép trên lan can (cầu hơi dốc xuống bên phải, cong nhẹ)
    return 112 + 0.045 * x + 0.00006 * (x - 200) ** 2

def build(ink, paper, bridge, name):
    W = 4.2
    yd = lambda x: yt(x) + 15   # mặt cầu trên
    yb = lambda x: yt(x) + 25   # mặt cầu dưới
    P = []
    a = P.append
    st0 = f'stroke="{ink}" stroke-linecap="round" stroke-linejoin="round"'
    st = st0 + f' stroke-width="{W}"'
    # --- tay xa (bên trái) ---
    a(f'<g fill="{paper}" {st0} stroke-width="3.4">')
    for (x, top, w) in [(60, 92, 11), (73, 86, 11), (86, 92, 10)]:
        a(f'<path d="M{x} 128 L{x} {top+6} C{x} {top-1} {x+w} {top-1} {x+w} {top+6} L{x+w} 128"/>')
    a('</g>')
    # --- 4 ngón tay lớn (phía sau cầu) ---
    a(f'<g fill="{paper}" {st}>')
    for (xl, top, w, lean) in [(262, 96, 20, 3), (286, 66, 23, 4), (314, 54, 24, 6), (343, 76, 21, 8)]:
        xr = xl + w
        a(f'<path d="M{xl} 150 C{xl+lean*.3:.1f} 128 {xl+lean*.7:.1f} {top+18} {xl+lean:.1f} {top+10} '
          f'C{xl+lean+1:.1f} {top-3} {xr+lean-1:.1f} {top-3} {xr+lean:.1f} {top+10} '
          f'C{xr+lean*.7:.1f} {top+18} {xr+lean*.3:.1f} 128 {xr} 150"/>')
        # đường nếp móng / đốt ngón
        cx = xl + w / 2 + lean
        a(f'<path d="M{cx-5:.1f} {top+22} C{cx-2:.1f} {top+24} {cx+2:.1f} {top+24} {cx+5:.1f} {top+22}" stroke-width="2.6"/>')
    a('</g>')
    # --- cầu ---
    xs = list(range(-10, 411, 6))
    band = 'M' + ' L'.join(f'{x} {yt(x)-2:.1f}' for x in xs) + ' L' + ' L'.join(f'{x} {yb(x):.1f}' for x in reversed(xs)) + 'Z'
    a(f'<path d="{band}" fill="{paper}"/>')
    line = lambda f: 'M' + ' L'.join(f'{x} {f(x):.1f}' for x in xs)
    a(f'<g fill="none" stroke="{bridge}" stroke-width="{W}" stroke-linecap="round">')
    a(f'<path d="{line(yt)}"/><path d="{line(yd)}"/><path d="{line(yb)}"/>')
    hatch = ' '.join(f'M{x} {yt(x)+3.5:.1f} L{x+7} {yt(x+7)+11:.1f}' for x in range(-4, 404, 13))
    a(f'<path d="{hatch}" stroke-width="2.6"/></g>')
    # --- tay xa: lòng bàn tay dưới cầu + ngón cái phía trước ---
    a(f'<path d="M34 176 C40 168 46 {yb(46)+6:.1f} 48 {yb(48):.1f} L100 {yb(100):.1f} C102 {yb(100)+14:.1f} 94 170 80 178" fill="{paper}" {st0} stroke-width="3.4"/>')
    a(f'<path d="M30 182 C36 160 42 138 46 116 C48 104 58 102 60 112 C61 122 58 138 56 {yb(56):.1f}" fill="{paper}" {st0} stroke-width="3.4"/>')
    # --- trụ chữ Y ---
    a(f'<g fill="none" {st0} stroke-width="3.4">')
    for x, h in [(112, 236), (176, 246)]:
        y0 = yb(x)
        a(f'<path d="M{x} {y0+24:.1f} L{x} {h} M{x} {y0+24:.1f} L{x-17} {y0+1:.1f} M{x} {y0+24:.1f} L{x+17} {y0+1:.1f} M{x-6} {y0+30:.1f} L{x+6} {y0+30:.1f}"/>')
    a('</g>')
    # --- lòng bàn tay dưới mặt cầu + ngón cái phía trước ---
    palm_top = ' L'.join(f'{x} {yb(x):.1f}' for x in range(372, 249, -6))
    hand = (f'M182 282 C194 244 208 204 220 168 C228 142 232 116 236 94 '
            f'C238 74 250 66 258 72 C265 78 264 92 261 106 '
            f'C257 126 254 146 254 {yb(254):.1f} '
            )
    pts = [f'{x} {yb(x):.1f}' for x in range(254, 373, 6)]
    hand += 'L' + ' L'.join(pts) + f' C386 {yb(372)+18:.1f} 372 218 336 240 C304 260 276 272 250 282 Z'
    a(f'<path d="{hand}" fill="{paper}" {st}/>')
    # nét móng ngón cái + nếp lòng bàn tay
    a(f'<g fill="none" {st0} stroke-width="2.8">'
      f'<path d="M244 82 C248 78 254 79 257 84"/>'
      f'<path d="M272 196 C292 200 314 196 332 188"/></g>')
    # --- vách đá phía trước + mây ---
    a(f'<path d="M112 282 L116 262 L126 252 L124 240 L138 232 L152 238 L162 234 L172 244 L178 262 L184 282 Z" fill="{paper}" {st}/>')
    a(f'<path d="M130 256 L142 250 M150 246 L160 252 M138 268 L150 262" fill="none" {st0} stroke-width="2.6"/>')
    a(f'<g fill="none" {st0} stroke-width="3.2">'
      f'<path d="M8 214 C14 204 28 204 32 212 C38 204 52 206 54 216"/>'
      f'<path d="M58 238 C64 230 76 230 80 238"/>'
      f'<path d="M282 270 C288 260 302 260 306 268 C314 260 328 262 330 272 C338 266 350 268 352 276"/>'
      f'<path d="M352 252 C358 246 368 246 372 252"/></g>')
    svg = (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 290" role="img" aria-label="Cầu Vàng – nét vẽ tay">\n'
           + '\n'.join(P) + '\n</svg>\n')
    open(os.path.join(os.path.dirname(os.path.abspath(__file__)), name), 'w').write(svg)

build('#0B2447', '#FFFDF8', '#0B2447', 'cau-vang-net-xanh.svg')
build('#0B2447', '#FFFDF8', '#C8902B', 'cau-vang-net-vang.svg')
build('#F7E7C6', '#0B2447', '#E9C46A', 'cau-vang-net-nen-toi.svg')
print('ok')
