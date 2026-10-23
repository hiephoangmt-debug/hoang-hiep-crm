S=.45
def P(x,y): return x*S,y*S
body=open('v3.txt').read(); vcc=open('vcc.txt').read()
o=[]
o.append('<rect x="0" y="0" width="920" height="834" fill="#f4f6f3"/>')
o.append('<path d="M858 0 H920 V834 H868 C905 640 915 560 905 470 C895 380 880 300 868 210 C860 140 858 70 858 0Z" fill="#d6ebf5"/>')
# đại lộ Võ Chí Công
o.append(f'<path id="vcc" d="{vcc}" fill="none" stroke="#c9d1dc" stroke-width="37" stroke-linecap="butt" stroke-linejoin="round"/>')
o.append(f'<path d="{vcc}" fill="none" stroke="#eef1f5" stroke-width="34" stroke-linejoin="round"/>')
o.append(f'<path d="{vcc}" fill="none" stroke="#9fc48f" stroke-width="2.4" stroke-linejoin="round"/>')
o.append(body)
o.append('<text class="road" dy="-5"><textPath href="#vcc" startOffset="30%">ĐƯỜNG VÕ CHÍ CÔNG</textPath></text>')
o.append('<polygon points="14,128 44,124 26,150" fill="#0b2a5b"/><polygon points="160,700 182,700 171,716" fill="#0b2a5b"/>')
o.append('<text x="40" y="118" class="dir">↖ Đi Đà Nẵng · sân bay</text>')
o.append('<text x="190" y="706" class="dir">Đi Tam Kỳ ↓</text>')
def lab(x,y,t,cls='lm',anchor='middle'):
    X,Y=P(x,y); o.append(f'<text x="{X:.0f}" y="{Y:.0f}" class="{cls}" text-anchor="{anchor}">{t}</text>')
lab(560,425,'KHU TTTM &amp; DỊCH VỤ')
lab(800,470,'Nhà trẻ')
lab(318,948,'Lối vào chính →','lm','end')
lab(1890,500,'22 Bungalow')
lab(1150,315,'LA PALMA','zone'); lab(650,1040,'LA SUNA','zone'); lab(1060,1205,'LA RIVA','zone')
def icon(code,x,y,label,dx=10,anchor='start'):
    X,Y=P(x,y); o.append(f'<g class="ic"><circle cx="{X:.0f}" cy="{Y:.0f}" r="8"/><text x="{X:.0f}" y="{Y+2.8:.1f}">{code}</text></g><text x="{X+dx:.0f}" y="{Y+3:.0f}" class="lm" text-anchor="{anchor}">{label}</text>')
# 2 sân pickleball
for cx,cy in ((826,600),(856,600)):
    X,Y=P(cx,cy); o.append(f'<rect x="{X-5.5:.1f}" y="{Y-10:.1f}" width="11" height="20" rx="1.5" fill="#3f8fc4" stroke="#fff" stroke-width="1.2"/><line x1="{X-5.5:.1f}" y1="{Y:.1f}" x2="{X+5.5:.1f}" y2="{Y:.1f}" stroke="#fff" stroke-width=".8"/>')
X,Y=P(874,578); o.append(f'<g class="ic"><circle cx="{X:.0f}" cy="{Y:.0f}" r="8"/><text x="{X:.0f}" y="{Y+2.8:.1f}">PB</text></g>')
lab(841,648,'Sân pickleball')
# clubhouse
# khách sạn 5*
X,Y=P(1092,895); o.append(f'<rect x="{X-7:.1f}" y="{Y-11:.1f}" width="14" height="22" rx="2" fill="#e9eef5" stroke="#9aa9bd"/>')
lab(1065,903,'Clubhouse','lm','end')
icon('KS',1790,1150,'Khách sạn 6 sao Đảo Dừa',-12,'end')
for n,(x,y),c in [('P1',(1010,585),''),('P2',(862,712),''),('P3',(1172,722),'lake'),('P4',(1330,815),'flo'),('P5',(1790,660),'')]:
    X,Y=P(x,y); o.append(f'<g class="pk {c}"><circle cx="{X:.0f}" cy="{Y:.0f}" r="12"/><text x="{X:.0f}" y="{Y+4:.0f}">{n}</text></g>')
for n,(x,y) in [('01',(430,900)),('02',(640,455)),('03',(880,485)),('04',(1885,620)),('05',(1240,670)),('06',(1092,895)),('07',(1130,905)),('08',(905,785))]:
    X,Y=P(x,y); o.append(f'<g class="nt"><circle cx="{X:.0f}" cy="{Y:.0f}" r="9"/><text x="{X:.0f}" y="{Y+3.4:.1f}">{n}</text></g>')
o.append('<text transform="translate(892 250) rotate(80)" class="water">SÔNG CỔ CÒ</text>')
o.append('<g transform="translate(840 70)"><circle r="18" fill="#fff" stroke="#c9d6ea"/><path d="M0 -14 L5 4 L0 0 L-5 4Z" fill="#0b2a5b"/><text y="-22" class="nb">B</text></g>')
AMEN=[('P1','Công viên Wellness','g'),('P2','Sport Park','g'),('P3','Grand Central Park · hồ vô cực','l'),('P4','Floral Park','f'),('P5','Nipa Park · rừng dừa','g'),
 ('01','Cổng chào hoa giấy','n'),('02','Trung tâm thương mại','n'),('03','Trường mầm non quốc tế','n'),('04','Bungalow','n'),('05','Bể bơi vô cực','n'),('06','Clubhouse 3 tầng · hồ bơi, gym','n'),('07','Sky bar','n'),('08','Trung tâm hội nghị','n'),('PB','Sân pickleball','i'),('KS','Khách sạn 6 sao Đảo Dừa','i')]
bx,by,bw,bh=222,726,680,100
L=[f'<g class="sp-legend"><rect x="{bx}" y="{by}" width="{bw}" height="{bh}" rx="10" fill="#fff" stroke="#dfe6ee"/>',
   f'<text x="{bx+14}" y="{by+16}" class="lg-h">TIỆN ÍCH NỘI KHU</text>']
cols=[AMEN[0:5],AMEN[5:10],AMEN[10:15]]
for ci,col in enumerate(cols):
    for ri,(n,t,k) in enumerate(col):
        x=bx+14+ci*225; y=by+35+ri*13.4; cx=x+6
        if k=='i': L.append(f'<g class="ic"><circle cx="{cx}" cy="{y-3:.1f}" r="6.4"/><text x="{cx}" y="{y-0.8:.1f}" style="font-size:6px">{n}</text></g>')
        elif k=='n': L.append(f'<g class="nt"><circle cx="{cx}" cy="{y-3:.1f}" r="6.4"/><text x="{cx}" y="{y-0.8:.1f}" style="font-size:7px">{n}</text></g>')
        else:
            cls={'g':'','l':'lake','f':'flo'}[k]
            L.append(f'<g class="pk {cls}"><circle cx="{cx}" cy="{y-3:.1f}" r="6.4" style="stroke-width:1.5"/><text x="{cx}" y="{y-0.6:.1f}" style="font-size:7px">{n}</text></g>')
        L.append(f'<text x="{x+17}" y="{y:.1f}" class="lg-t">{t}</text>')
L.append('</g>'); o.append(''.join(L))
svg='<svg viewBox="0 0 920 834" aria-label="Sơ đồ phân khu Casamia Balanca, vẽ lại theo mặt bằng chủ đầu tư">\n'+'\n'.join(o)+'\n</svg>'
open('plan2.svg','w').write(svg)
css='''<style>body{margin:0;background:#fff}svg{width:1000px;display:block}
svg .pk circle{fill:#fff;stroke:#5fa35a;stroke-width:2.5}svg .pk.lake circle{stroke:#2aa3b5}svg .pk.flo circle{stroke:#e46aa0}
svg .pk text{font:800 11px sans-serif;fill:#0b2a5b;text-anchor:middle}
svg .zone{font:700 15px serif;fill:#0b2a5b;opacity:.55;letter-spacing:4px;text-anchor:middle}
svg .nt circle{fill:#9a1b1b;stroke:#fff;stroke-width:1.5}svg .nt text{font:700 9px sans-serif;fill:#fff;text-anchor:middle}
svg .dir{font:800 13px sans-serif;fill:#0b2a5b}
svg .road{font:800 11px sans-serif;fill:#0b2a5b;letter-spacing:2px}
svg .water{font:800 13px sans-serif;fill:#2c6e98;letter-spacing:2px}
svg .nb{font:800 11px sans-serif;text-anchor:middle;fill:#0b2a5b}
svg .lg-h{font:800 10.5px sans-serif;fill:#0b2a5b;letter-spacing:1.5px}svg .lg-t{font:600 10.2px sans-serif;fill:#33433a}svg .ic circle{fill:#f07c22;stroke:#fff;stroke-width:1.5}svg .ic text{font:800 7px sans-serif;fill:#fff;text-anchor:middle}svg .lm{font:700 10.5px sans-serif;fill:#33433a;paint-order:stroke;stroke:#fff;stroke-width:3px}</style>'''
open('p2.html','w').write('<!doctype html><meta charset="utf-8">'+css+svg)
print(len(svg)//1024,'KB')
