# Sinh khối tòa nhà Sun Saphia Residence (minh họa) theo hệ tọa độ địa phương:
# gốc = góc Võ Nguyên Giáp × Nguyễn Đức Thuận, trục s dọc VNG về phía nam, trục w dọc NĐT về phía tây (mét).
import math, json, sys
LAT=16.021; KX=111320*math.cos(math.radians(LAT)); KY=110540
def u(b): r=math.radians(b); return (math.sin(r), math.cos(r))
S=u(155.3); W=u(243.4); C0=(108.257841, 16.021496)
def pt(w,s):
    return [round(C0[0]+(w*W[0]+s*S[0])/KX,7), round(C0[1]+(w*W[1]+s*S[1])/KY,7)]
def poly(pts): return [[pt(*p) for p in pts+[pts[0]]]]
def box(w0,s0,w1,s1): return [(w0,s0),(w1,s0),(w1,s1),(w0,s1)]
F=[]
def add(pts,b,h,col): F.append({"type":"Feature","geometry":{"type":"Polygon","coordinates":poly(pts)},"properties":{"b":round(b,2),"h":round(h,2),"col":col}})
LOT=[(0,0),(75,0),(75,29),(50,29),(50,59),(0,59)]
POD=[(2,2),(73,2),(73,27),(48,27),(48,57),(2,57)]
# Khối đế: tầng 1 cao 7 m (kính sáng ấm), tầng 2 cao 6 m
add(POD,0,6.3,'#F2A54A'); add(POD,6.3,7.0,'#FFFFFF')
add(POD,7.0,12.4,'#2E5F96'); add(POD,12.4,13.0,'#FFFFFF')
# Sàn tầng 3: hồ bơi + cây
add(box(25,30,45,52),13.0,13.35,'#47C1F2')
for (w,s) in [(24,28),(46,28),(24,54),(46,54),(35,55),(60,24),(68,24)]:
    add(box(w-.9,s-.9,w+.9,s+.9),13.0,17.0,'#2F9E62')
# Thân tháp chữ L: 28 tầng (tầng 3 → 30), mỗi tầng 3,4 m: dải kính + ban công trắng
TOW=[(3,3),(60,3),(60,21),(22,21),(22,52),(3,52)]
top=13.0+28*3.4
for i in range(28):
    b=13.0+i*3.4
    add(TOW,b,b+2.6,'#2E5F96'); add(TOW,b+2.6,b+3.4,'#F2F5FA')
# Gân cam đồng chạy suốt chiều cao (giống phối cảnh)
add(box(1.8,22,6,30),13.0,top+2,'#E0662A')
add(box(28,1.8,36,6),13.0,top+2,'#E0662A')
add(box(16,15,26,25),13.0,top+2,'#E0662A')
# Mái: viền cam + khối kỹ thuật, tổng cao 114 m
add([(4.5,4.5),(58.5,4.5),(58.5,19.5),(20.5,19.5),(20.5,50.5),(4.5,50.5)],top,top+2.8,'#FFB547')
add(box(7,7,19,40),top+2.8,114.0,'#C9D7EE')
json.dump({"type":"FeatureCollection","features":F},open(sys.argv[1],"w"))
print(len(F),"features, top",round(top,1))
print("LOT",[pt(*p) for p in LOT])
