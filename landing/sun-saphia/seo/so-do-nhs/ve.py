"""Sơ đồ minh họa định hướng quy hoạch danh thắng Ngũ Hành Sơn (không theo tỷ lệ)."""
W,H=1400,900
F="'Be Vietnam Pro',sans-serif"
o=[f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" width="{W}" height="{H}">',
'''<defs><linearGradient id="bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f3f7ee"/><stop offset="1" stop-color="#e7efe3"/></linearGradient>
<radialGradient id="mt" cx=".45" cy=".35" r=".7"><stop offset="0" stop-color="#5aa86f"/><stop offset=".7" stop-color="#2f7d4f"/><stop offset="1" stop-color="#235f3c"/></radialGradient>
<linearGradient id="rv" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#5fb3e6"/><stop offset="1" stop-color="#2f86c8"/></linearGradient>
<pattern id="field" width="18" height="18" patternUnits="userSpaceOnUse"><rect width="18" height="18" fill="#a7d38a"/><path d="M0 9h18" stroke="#8cc06f" stroke-width="2"/></pattern>
<filter id="sh"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="#0b2447" flood-opacity=".25"/></filter></defs>''',
f'<rect width="{W}" height="{H}" fill="url(#bg)"/>']
# river Cổ Cò (west & south)
o.append('<path d="M120 0 C 150 160, 90 300, 140 430 S 230 640, 380 720 S 640 820, 900 800 S 1200 860, 1400 830 L1400 900 L0 900 L0 0 Z" fill="url(#rv)" opacity=".9"/>')
o.append('<path d="M120 0 C 150 160, 90 300, 140 430 S 230 640, 380 720 S 640 820, 900 800 S 1200 860, 1400 830" fill="none" stroke="#e9f4fb" stroke-width="5"/>')
# rice fields west
o.append('<path d="M175 120 L380 140 L360 430 L205 440 C185 330 190 220 175 120Z" fill="url(#field)" opacity=".85"/>')
# roads
def road(d,w=26,c='#fff'):
    o.append(f'<path d="{d}" fill="none" stroke="#c9d0c4" stroke-width="{w+6}" stroke-linecap="round"/><path d="{d}" fill="none" stroke="{c}" stroke-width="{w}" stroke-linecap="round"/>')
road('M560 0 C 575 200, 600 420, 640 620 S 700 760, 720 800')   # Lê Văn Hiến (N-S)
road('M640 470 C 820 450, 1050 430, 1400 400',22)               # Huyền Trân Công Chúa (ra biển)
road('M210 520 C 360 500, 480 480, 640 470',16)                 # đường nội bộ phía tây
road('M640 640 C 820 640, 960 660, 1110 700',14)
def lab(x,y,t,s=16,c='#5b6b5f',w=700,a='middle',rot=0):
    r=f' transform="rotate({rot} {x} {y})"' if rot else ''
    o.append(f'<text x="{x}" y="{y}"{r} text-anchor="{a}" style="font:{w} {s}px {F}" fill="{c}" stroke="#fff" stroke-width="4" paint-order="stroke">{t}</text>')
lab(586,150,'Đường Lê Văn Hiến',15,rot=84); lab(1180,405,'Đường Huyền Trân Công Chúa → biển',15,rot=-3)
o.append(f'<text x="250" y="830" style="font:italic 800 24px {F}" fill="#ffffff">Sông Cổ Cò</text>'); lab(270,300,'Cánh đồng',15,'#4b7a3a')
# mountains
def mt(d,name,x,y,sub=''):
    o.append(f'<path d="{d}" fill="url(#mt)" stroke="#1f5536" stroke-width="2" filter="url(#sh)"/>')
    o.append(f'<text x="{x}" y="{y}" text-anchor="middle" style="font:800 20px {F}" fill="#fff" stroke="#1f5536" stroke-width="4" paint-order="stroke">{name}</text>')
    if sub: o.append(f'<text x="{x}" y="{y+22}" text-anchor="middle" style="font:600 13px {F}" fill="#fff" stroke="#1f5536" stroke-width="3" paint-order="stroke">{sub}</text>')
mt('M700 90 C 820 40, 1010 60, 1080 140 C 1140 220, 1090 330, 990 370 C 880 410, 760 380, 710 300 C 670 230, 650 140, 700 90Z','THỦY SƠN',890,220,'núi lớn nhất · chùa Linh Ứng, động Huyền Không')
mt('M1110 470 C 1160 450, 1230 470, 1240 520 C 1250 570, 1190 600, 1140 585 C 1100 570, 1080 500, 1110 470Z','MỘC SƠN',1170,530)
mt('M380 170 C 430 140, 500 160, 510 220 C 520 290, 470 330, 420 320 C 370 310, 350 220, 380 170Z','HỎA SƠN',445,240,'(Dương Hỏa)')
mt('M400 350 C 440 335, 490 350, 495 390 C 500 430, 455 450, 420 440 C 385 430, 375 370, 400 350Z','',445,395)
lab(445,470,'(Âm Hỏa)',13,'#2f5d3f')
mt('M760 560 C 820 520, 930 530, 980 580 C 1020 630, 980 700, 900 710 C 820 720, 750 680, 740 630 C 735 600, 740 575, 760 560Z','THỔ SƠN',860,615,'vườn thiền · bảo tháp Báo Thiên')
mt('M300 610 C 340 585, 400 595, 410 635 C 420 675, 380 700, 340 695 C 300 690, 280 640, 300 610Z','KIM SƠN',350,645,'chùa Quán Thế Âm')
# planned features (badges)
def badge(x,y,num,t,c):
    o.append(f'<circle cx="{x}" cy="{y}" r="17" fill="{c}" stroke="#fff" stroke-width="3" filter="url(#sh)"/><text x="{x}" y="{y+6}" text-anchor="middle" style="font:900 16px {F}" fill="#fff">{num}</text>')
    lab(x+24,y+6,t,14,'#203a2a',800,'start')
# lakes
o.append('<ellipse cx="1010" cy="460" rx="45" ry="24" fill="#6fc0ea" stroke="#fff" stroke-width="3"/>')
o.append('<path d="M780 420 C 820 405, 880 410, 900 430 C 870 450, 800 452, 780 420Z" fill="#6fc0ea" stroke="#fff" stroke-width="3"/>')
badge(640,470,'1','Quảng trường lễ hội','#E96118')
badge(870,770,'2','Bảo tháp Báo Thiên 58 m','#c0392b')
badge(980,690,'3','Vườn thiền ~5.528 m²','#2f9e6a')
badge(690,700,'4','Vườn tượng ~8.988 m²','#8e44ad')
badge(1010,455,'5','Hồ cảnh quan','#2a6fd0')
badge(250,560,'6','Làng đá Non Nước','#d99a00')
badge(560,40,'P','Bãi đỗ xe','#275286')
badge(1240,640,'P','Bãi đỗ xe','#275286')
# title card
o.append(f'<g filter="url(#sh)"><rect x="920" y="20" width="460" height="92" rx="14" fill="#0b2447"/></g>')
o.append(f'<text x="940" y="54" style="font:800 20px {F}" fill="#FFAA01">DANH THẮNG NGŨ HÀNH SƠN</text>')
o.append(f'<text x="940" y="80" style="font:600 15px {F}" fill="#fff">Sơ đồ minh họa định hướng quy hoạch</text>')
o.append(f'<text x="940" y="100" style="font:500 13px {F}" fill="#c7d3e3">QĐ 822/QĐ-TTg · ~105 ha · công viên VH-LS ~92 ha</text>')
# legend
o.append(f'<g filter="url(#sh)"><rect x="20" y="20" width="250" height="60" rx="12" fill="#fff"/></g><text x="36" y="46" style="font:800 14px {F}" fill="#0b2447">Minh họa, không theo tỷ lệ</text><text x="36" y="66" style="font:500 12px {F}" fill="#5b6b85">Vị trí hạng mục mang tính tham khảo</text>')
# watermark
wm='sun-saphia-residence.com · 0904 567 009'
g=[f'<g transform="rotate(-22 {W//2} {H//2})" style="font:700 22px {F}" pointer-events="none">']
y=-500
while y<H+600:
    x=-700+((y//150)%2)*280
    while x<W+700:
        g.append(f'<text x="{x}" y="{y}" fill="#0b2447" fill-opacity=".07">{wm}</text>'); x+=560
    y+=150
g.append('</g>'); o.append(''.join(g))
o.append('</svg>')
open('so-do-ngu-hanh-son.svg','w',encoding='utf8').write('\n'.join(o))
