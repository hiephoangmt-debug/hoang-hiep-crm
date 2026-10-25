"""Sơ đồ quy hoạch danh thắng Ngũ Hành Sơn – vẽ lại theo đúng hình dạng, vị trí trên
'Bản đồ định hướng tổ chức không gian kiến trúc, cảnh quan' (QĐ 822/QĐ-TTg), tọa độ lấy từ ảnh tham chiếu (x2)."""
F="'Be Vietnam Pro',sans-serif"
VX,VY,VW,VH=0,60,1100,820
def P(pts): return 'M'+' L'.join('%d %d'%p for p in pts)+' Z'
def S(pts,close=True):
    n=len(pts); d='M%.1f %.1f'%pts[0]
    for i in range(n if close else n-1):
        p1=pts[i]; p2=pts[(i+1)%n]
        p0=pts[(i-1)%n] if (close or i>0) else p1
        p3=pts[(i+2)%n] if (close or i+2<n) else p2
        c1=(p1[0]+(p2[0]-p0[0])/6,p1[1]+(p2[1]-p0[1])/6); c2=(p2[0]-(p3[0]-p1[0])/6,p2[1]-(p3[1]-p1[1])/6)
        d+=' C%.1f %.1f %.1f %.1f %.1f %.1f'%(c1+c2+p2)
    return d+(' Z' if close else '')
o=[f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="{VX} {VY} {VW} {VH}" width="1600" height="{round(1600*VH/VW)}">',
'''<defs><radialGradient id="mt" cx=".45" cy=".35" r=".75"><stop offset="0" stop-color="#4f9a5f"/><stop offset=".75" stop-color="#2c6f45"/><stop offset="1" stop-color="#1f5535"/></radialGradient>
<linearGradient id="rv" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#7cc6ea"/><stop offset="1" stop-color="#3f95cf"/></linearGradient>
<pattern id="field" width="14" height="14" patternUnits="userSpaceOnUse" patternTransform="rotate(-35)"><rect width="14" height="14" fill="#9fd07d"/><path d="M0 7h14" stroke="#86bf62" stroke-width="2"/></pattern>
<pattern id="urb" width="10" height="10" patternUnits="userSpaceOnUse"><rect width="10" height="10" fill="#ece9e2"/><rect x="1" y="1" width="4" height="3" fill="#ddd8cd"/><rect x="6" y="5" width="3" height="4" fill="#ddd8cd"/></pattern>
<filter id="sh"><feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#0b2447" flood-opacity=".3"/></filter></defs>''',
f'<rect x="{VX}" y="{VY}" width="{VW}" height="{VH}" fill="url(#urb)"/>']
# vùng quy hoạch (ranh giới)
BND=[(78,290),(130,230),(205,185),(330,195),(600,192),(650,180),(760,140),(900,122),(1050,122),(1140,290),(1000,425),(990,625),(810,680),(700,585),(690,700),(660,860),(600,860),(560,830),(420,790),(330,770),(240,720),(260,640),(270,590),(245,520),(195,420),(140,330)]
o.append(f'<path d="{S(BND)}" fill="#c9e7b0" stroke="#d23b2f" stroke-width="3" stroke-dasharray="10 6"/>')
# ruộng lúa phía tây
o.append(f'<path d="{S([(140,355),(230,345),(300,420),(310,500),(250,505),(190,420)])}" fill="url(#field)"/>')
# sông Cổ Cò
import json
for poly in json.load(open('water.json')):
    poly=[(x if x>4 else VX-10, y) for x,y in poly]
    o.append(f'<path d="{S(poly)}" fill="url(#rv)" stroke="#e9f4fb" stroke-width="3"/>')
o.append(f'<path d="{S([(192,610),(210,602),(228,612),(222,630),(198,632)])}" fill="#c9e7b0" stroke="#2f86c8" stroke-width="2"/>')  # cù lao
# hồ
o.append(f'<path d="{S([(700,345),(735,335),(770,350),(765,385),(725,392),(698,372)])}" fill="#7cc6ea" stroke="#fff" stroke-width="3"/>')
o.append(f'<path d="{S([(455,395),(480,383),(505,398),(495,418),(465,420)])}" fill="#7cc6ea" stroke="#fff" stroke-width="3"/>')
o.append(f'<path d="{S([(560,600),(595,590),(615,610),(600,640),(570,640)])}" fill="#7cc6ea" stroke="#fff" stroke-width="2"/>')
# đường
RC,RF=[],[]
def road(pts,w):
    d=S(pts,False); RC.append(f'<path d="{d}" fill="none" stroke="#9aa4ad" stroke-width="{w+5}" stroke-linecap="round" stroke-linejoin="round"/>'); RF.append(f'<path d="{d}" fill="none" stroke="#fff" stroke-width="{w}" stroke-linecap="round" stroke-linejoin="round"/>')
road([(165,160),(320,192),(600,192),(640,175),(760,140),(1050,120)],12)       # đường phía bắc
road([(590,62),(630,170),(648,260),(660,420),(668,560),(660,700),(640,885)],20) # Lê Văn Hiến
road([(1050,122),(1120,230),(1190,340)],12)                                    # đường phía đông
road([(232,622),(300,598),(330,566),(430,552),(560,556),(668,568)],12)         # trục ngang phía nam
road([(664,566),(705,630),(760,690),(830,760)],12)         # đường chéo đông nam
road([(240,500),(330,495),(405,495),(500,460),(545,430),(600,440),(660,452)],9)
road([(660,452),(800,462),(1000,440)],8)
road([(405,495),(418,530),(430,552)],7)
o.extend(RC); o.extend(RF)
# quảng trường & bùng binh
o.append('<circle cx="545" cy="425" r="40" fill="#f7efe0" stroke="#fff" stroke-width="5"/><circle cx="545" cy="425" r="18" fill="#e8d5b0"/>')
o.append('<circle cx="405" cy="495" r="17" fill="#fff" stroke="#9aa4ad" stroke-width="3"/>')
# núi
MTS={'THỦY SƠN':[(680,265),(760,225),(870,218),(980,235),(1045,290),(1050,360),(1000,420),(900,445),(800,430),(730,390),(690,330)],
     'HỎA SƠN':[(275,250),(330,215),(420,212),(480,225),(522,262),(500,300),(440,322),(360,328),(300,305)],
     'MỘC SƠN':[(735,565),(800,548),(890,562),(965,592),(952,630),(872,650),(790,640),(745,612)],
     'THỔ SƠN':[(320,610),(380,575),(450,570),(495,590),(490,640),(440,680),(370,686),(325,660)],
     'KIM SƠN':[(330,700),(400,672),(480,672),(550,700),(530,740),(470,765),(380,770),(335,748)]}
for n,pts in MTS.items():
    o.append(f'<path d="{S(pts)}" fill="url(#mt)" stroke="#1a4a2f" stroke-width="2" filter="url(#sh)"/>')
    cx=sum(p[0] for p in pts)/len(pts); cy=sum(p[1] for p in pts)/len(pts)
    o.append(f'<text x="{cx:.0f}" y="{cy+6:.0f}" text-anchor="middle" style="font:900 {20 if n=="THỦY SƠN" else 15}px {F}" fill="#fff" stroke="#1a4a2f" stroke-width="4" paint-order="stroke">{n}</text>')
# công trình (đỏ) theo bản đồ
for x,y in [(495,262),(570,265),(545,360),(580,365),(735,190),(850,190),(840,320),(1040,250),(520,520),(570,485),(600,505),(500,650),(540,690),(290,680),(830,195)]:
    o.append(f'<rect x="{x-9}" y="{y-6}" width="18" height="12" rx="2" fill="#c0392b" stroke="#fff" stroke-width="1.5"/>')
def lab(x,y,t,s=14,c='#203a2a',a='middle',rot=0,w=700):
    r=f' transform="rotate({rot} {x} {y})"' if rot else ''
    o.append(f'<text x="{x}" y="{y}"{r} text-anchor="{a}" style="font:{w} {s}px {F}" fill="{c}" stroke="#fff" stroke-width="4" paint-order="stroke">{t}</text>')
lab(683,300,'Đường Lê Văn Hiến',14,rot=86)
o.append(f'<text x="55" y="470" transform="rotate(-75 55 470)" style="font:italic 800 22px {F}" fill="#fff">Sông Cổ Cò</text>')
lab(240,440,'Ruộng lúa sinh thái',13,'#3d6b2a')
def badge(x,y,num,t,c,a='start',dx=22):
    o.append(f'<circle cx="{x}" cy="{y}" r="14" fill="{c}" stroke="#fff" stroke-width="3" filter="url(#sh)"/><text x="{x}" y="{y+5}" text-anchor="middle" style="font:900 14px {F}" fill="#fff">{num}</text>')
    lab(x+(dx if a=='start' else -dx),y+5,t,13,'#0b2447',a)
badge(545,425,'1','Quảng trường – trục lễ hội','#E96118','end',dx=48)
badge(405,495,'2','Bùng binh cảnh quan','#8e44ad','end')
badge(733,365,'3','Hồ cảnh quan','#2a6fd0')
badge(300,700,'4','Chùa Quán Thế Âm','#c0392b','end')
badge(210,618,'5','Cù lao sinh thái','#2f9e6a','end')
badge(540,615,'6','Vườn tượng · vườn thiền','#2f9e6a')
# chú giải + tiêu đề
o.append(f'<g filter="url(#sh)"><rect x="755" y="680" width="340" height="190" rx="12" fill="#fff"/></g>')
o.append(f'<text x="778" y="706" style="font:900 14px {F}" fill="#0b2447">QUY HOẠCH DANH THẮNG NGŨ HÀNH SƠN</text>')
o.append(f'<text x="778" y="726" style="font:600 11px {F}" fill="#5b6b85">Vẽ lại theo bản đồ định hướng (QĐ 822/QĐ-TTg)</text>')
items=[('<rect x="0" y="-9" width="22" height="12" rx="3" fill="url(#mt)"/>','Núi đá vôi (5 ngọn)'),('<rect x="0" y="-9" width="22" height="12" fill="#c9e7b0" stroke="#d23b2f" stroke-dasharray="4 3"/>','Ranh giới quy hoạch, cây xanh'),
       ('<rect x="0" y="-9" width="22" height="12" fill="url(#rv)"/>','Sông Cổ Cò, hồ'),('<rect x="4" y="-8" width="14" height="10" fill="#c0392b"/>','Công trình văn hóa, dịch vụ'),('<rect x="0" y="-9" width="22" height="12" fill="url(#urb)" stroke="#ccc"/>','Khu dân cư hiện hữu')]
for i,(sw,t) in enumerate(items):
    y=752+i*22; o.append(f'<g transform="translate(778 {y})">{sw}</g><text x="808" y="{y+1}" style="font:600 12.5px {F}" fill="#203a2a">{t}</text>')
# chữ chìm
wm='sun-saphia-residence.com · 0904 567 009'
g=[f'<g transform="rotate(-22 550 470)" style="font:700 20px {F}" pointer-events="none">']
y=-300
while y<1300:
    x=-600+((y//140)%2)*260
    while x<1800: g.append(f'<text x="{x}" y="{y}" fill="#0b2447" fill-opacity=".07">{wm}</text>'); x+=520
    y+=140
g.append('</g>'); o.append(''.join(g))
o.append('</svg>')
open('so-do-ngu-hanh-son.svg','w',encoding='utf8').write('\n'.join(o))
