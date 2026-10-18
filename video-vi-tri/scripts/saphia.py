# Sinh khối tòa nhà Sun Saphia Residence (minh họa) + ranh 2 thửa đất.
# Hệ tọa độ địa phương (mét): gốc = góc Võ Nguyên Giáp × Nguyễn Đức Thuận,
# trục s dọc VNG về phía nam, trục w dọc Nguyễn Đức Thuận về phía tây.
# Thửa 6 (2.399 m², góc bo tròn) + thửa 11 (1.320 m², 60 × 22,1 m) = 3.719 m².
import math, json, sys
from shapely.geometry import Polygon, Point, box as sbox
from shapely.ops import unary_union
LAT=16.021; KX=111320*math.cos(math.radians(LAT)); KY=110540
def u(b): r=math.radians(b); return (math.sin(r), math.cos(r))
S=u(155.3); W=u(243.4); C0=(108.257841, 16.021496)
def pt(w,s): return [round(C0[0]+(w*W[0]+s*S[0])/KX,7), round(C0[1]+(w*W[1]+s*S[1])/KY,7)]
def ring(g): return [[pt(x,y) for x,y in g.exterior.coords]]
R=8.4  # bán kính góc bo (cung 13,2 m)
arc=[(R-R*math.cos(a),R-R*math.sin(a)) for a in [i*math.pi/2/8 for i in range(9)]]  # từ (0,R) tới (R,0)
T6=Polygon(arc+[(57,0),(60,3),(60,40.7),(0,42.5)])
T11=Polygon([(0,42.5),(60,40.7),(60,62.8),(0,64.6)])
LOT=unary_union([T6,T11])
F=[]
def add(g,b,h,col): F.append({"type":"Feature","geometry":{"type":"Polygon","coordinates":ring(g)},"properties":{"b":round(b,2),"h":round(h,2),"col":col}})
POD=LOT.buffer(-2,join_style=2)
add(POD,0,6.3,'#F2A54A'); add(POD,6.3,7.0,'#FFFFFF')        # tầng 1 cao 7 m
add(POD,7.0,12.4,'#2E5F96'); add(POD,12.4,13.0,'#FFFFFF')   # tầng 2 cao 6 m
add(sbox(28,27,52,56),13.0,13.35,'#47C1F2')                 # hồ bơi sàn tầng 3
for (w,s) in [(26,25),(54,25),(26,58),(54,58),(40,59),(56,40)]:
    add(sbox(w-.9,s-.9,w+.9,s+.9),13.0,17.0,'#2F9E62')
TOW=Polygon([(3,3),(57,3),(57,22),(23,22),(23,56),(3,56)])   # tháp chữ L: lưng VNG, chân Nguyễn Đức Thuận
top=13.0+28*3.4
for i in range(28):
    b=13.0+i*3.4
    add(TOW,b,b+2.6,'#2E5F96'); add(TOW,b+2.6,b+3.4,'#F2F5FA')
add(sbox(1.8,25,6,33),13.0,top+2,'#E0662A')
add(sbox(28,1.8,36,6),13.0,top+2,'#E0662A')
add(sbox(16,15,26,25),13.0,top+2,'#E0662A')
add(TOW.buffer(-1.5,join_style=2),top,top+2.8,'#FFB547')
add(sbox(7,7,19,42),top+2.8,114.0,'#C9D7EE')
json.dump({"type":"FeatureCollection","features":F},open(sys.argv[1],"w"))
print(len(F),"features; area T6",round(T6.area),"T11",round(T11.area),"total",round(LOT.area))
print("LOT=",json.dumps([pt(x,y) for x,y in list(LOT.exterior.coords)[:-1]]))
print("T6=",json.dumps([pt(x,y) for x,y in list(T6.exterior.coords)[:-1]]))
print("T11=",json.dumps([pt(x,y) for x,y in list(T11.exterior.coords)[:-1]]))
c=LOT.centroid; print("CENTER=",pt(c.x,c.y))
