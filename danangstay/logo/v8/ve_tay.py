"""Bàn tay Cầu Vàng – nét vẽ, đo theo lưới trên ảnh thật (CC0, DvTor8303 / Wikimedia Commons).
Toạ độ trong khung 800×720 của ảnh đã cắt. Chạy: python3 ve_tay.py"""
import os

def deck_bottom(x):  # mép dưới mặt cầu: thấp dần về bên phải (phối cảnh)
    return 340 + 0.000140 * x * x

def build(ink, paper, gold, name, W=7):
    o = []
    a = o.append
    S0 = f'stroke="{ink}" stroke-linecap="round" stroke-linejoin="round"'
    S = S0 + f' stroke-width="{W}"'
    # 1) bốn ngón phía sau cầu (đo từ ảnh)
    fingers = [
        "M345 262 L347 150 C349 126 369 124 372 150 L372 262",                      # trỏ (khuất sau ngón cái)
        "M408 262 L410 122 C412 66 486 66 488 122 L486 262",                        # giữa
        "M500 262 L502 72 C504 8 598 8 598 72 L594 262",                            # áp út
        "M626 262 L632 152 C640 82 668 56 700 58 C740 60 750 92 742 132 L722 262",  # út
    ]
    a(f'<g fill="{paper}" {S}>' + ''.join(f'<path d="{d}"/>' for d in fingers) + '</g>')
    # nếp đá trên ngón
    a(f'<g fill="none" {S0} stroke-width="{W*.55:.1f}">'
      '<path d="M432 170 C442 176 456 176 466 170"/><path d="M528 120 C540 128 558 128 570 120"/>'
      '<path d="M660 140 C672 146 690 146 700 140"/></g>')
    # 2) cầu: tô nền giấy che chân ngón, rồi vẽ lan can + mặt cầu
    xs = list(range(-20, 821, 10))
    top = lambda x: 232 + 0.01 * x
    band = 'M' + ' L'.join(f'{x} {top(x)-4:.1f}' for x in xs) + ' L' + ' L'.join(f'{x} {deck_bottom(x):.1f}' for x in reversed(xs)) + 'Z'
    a(f'<path d="{band}" fill="{paper}"/>')
    ln = lambda f: 'M' + ' L'.join(f'{x} {f(x):.1f}' for x in xs)
    a(f'<g fill="none" stroke="{gold}" stroke-width="{W}" stroke-linecap="round">'
      f'<path d="{ln(top)}"/><path d="{ln(lambda x: top(x)+20)}" stroke-width="{W*.6:.1f}"/>'
      f'<path d="{ln(lambda x: 290 + 0.012*x)}"/><path d="{ln(deck_bottom)}"/>'
      + '<path d="' + ' '.join(f'M{x} {top(x)+2:.1f} L{x} {288+0.012*x:.1f}' for x in range(0, 801, 26)) + f'" stroke-width="{W*.45:.1f}"/>'
      '</g>')
    # 3) ngón cái (phía trước cầu) + lòng bàn tay + cổ tay – một khối
    palm_top = ' L'.join(f'{x} {deck_bottom(x):.1f}' for x in range(292, 561, 12))
    hand = ("M0 690 L0 486 C44 454 92 414 130 372 C160 338 180 290 200 222 "
            "C220 160 250 110 285 88 C306 75 345 80 352 106 C358 132 346 190 331 232 "
            f"C318 268 302 318 292 {deck_bottom(292):.1f} L{palm_top} "
            "C548 420 506 456 462 482 C402 522 322 562 232 600 C150 634 72 664 0 690 Z")
    a(f'<path d="{hand}" fill="{paper}" {S}/>')
    a(f'<g fill="none" {S0} stroke-width="{W*.55:.1f}">'
      '<path d="M236 178 C256 186 280 186 300 176"/>'         # nếp đốt ngón cái
      '<path d="M150 470 C200 470 250 452 290 430"/>'         # nếp lòng bàn tay
      '<path d="M60 560 C100 556 140 544 170 528"/></g>')
    # 4) mây dưới chân
    a(f'<g fill="none" {S0} stroke-width="{W*.7:.1f}">'
      '<path d="M520 620 C532 598 562 598 570 614 C584 598 612 602 616 622 C630 612 652 616 656 632"/>'
      '<path d="M640 540 C650 526 670 526 676 538"/></g>')
    svg = (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="-10 0 820 710" width="820" height="710" role="img" aria-label="Cầu Vàng – Đà Nẵng">\n'
           + '\n'.join(o) + '\n</svg>\n')
    open(os.path.join(os.path.dirname(os.path.abspath(__file__)), name), 'w').write(svg)

build('#0B2447', '#FFFDF8', '#0B2447', 'tay-xanh.svg')
build('#0B2447', '#FFFDF8', '#C8902B', 'tay-vang.svg')
build('#F7E7C6', '#0B2447', '#E9C46A', 'tay-nen-toi.svg')
print('ok')
