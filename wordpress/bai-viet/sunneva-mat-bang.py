# Sơ đồ mặt bằng Sunneva Island – tự vẽ minh họa (không theo tỉ lệ), dựa trên bố cục mặt bằng tổng thể dự án.
import math, os
from PIL import Image, ImageDraw, ImageFont
W, H = 1600, 1000
img = Image.new('RGB', (W, H), '#bfe6f5'); d = ImageDraw.Draw(img)
F = lambda s, b=False: ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf' % ('-Bold' if b else ''), s)
A = math.radians(16); CX, CY = 210, 330
def T(u, v): return (CX + u*math.cos(A) - v*math.sin(A), CY + u*math.sin(A) + v*math.cos(A))
def poly(pts, fill, outline=None, w=1): d.polygon([T(*p) for p in pts], fill=fill, outline=outline, width=w)
# bờ sông hai bên (đất liền)
d.polygon([(0,0),(W,0),(W,170),(1150,120),(700,90),(0,140)], fill='#cfe8c4')
d.polygon([(0,H),(0,700),(300,690),(700,880),(1000,H)], fill='#e4e4dc')
# đảo: thân + mũi tròn phía Đông Nam
L, R = 1000, 165
isl = [(-40, -60), (40, -R+10), (L, -R)] + [(L + R*math.cos(t), R*math.sin(t)) for t in [math.radians(a) for a in range(-90, 91, 10)]] + [(40, R-20), (-60, 60)]
poly(isl, '#9ccc7d')
inner = [(10, -R+45), (L, -R+40)] + [(L + (R-40)*math.cos(math.radians(a)), (R-40)*math.sin(math.radians(a))) for a in range(-90, 91, 10)] + [(10, R-55)]
poly(inner, '#d9d9d9')
C = {'sl': '#f08a3c', 'dl': '#4aa8e0', 'th': '#f5e03a'}
def lot(u, v, du, dv, k): poly([(u, v), (u+du, v), (u+du, v+dv), (u, v+dv)], C[k], '#ffffff')
# Habora: dãy song lập ven sông phía Bắc + các dãy chéo phía Tây
for i in range(17): lot(40 + i*25, -R+48, 24, 26, 'dl' if i == 0 else 'sl')
for col in range(5):
    u0 = 60 + col*82
    for j in range(9):
        k = 'dl' if j in (0, 8) else 'sl'
        lot(u0, -95 + j*26, 34, 24, k); lot(u0+36, -95 + j*26, 34, 24, k)
# Centria: 2 dãy townhouse + song lập
for j in range(11):
    lot(490, -110 + j*22, 30, 20, 'th'); lot(522, -110 + j*22, 30, 20, 'sl')
    lot(570, -110 + j*22, 30, 20, 'th'); lot(602, -110 + j*22, 30, 20, 'sl')
# Rivera: dãy song lập ven sông + các dãy, mũi đảo là vòng đơn lập
for i in range(12): lot(660 + i*28, -R+48, 26, 26, 'sl')
for col in range(3):
    u0 = 670 + col*95
    for j in range(8):
        k = 'dl' if j in (0, 7) else 'sl'
        lot(u0, -85 + j*26, 34, 24, k); lot(u0+36, -85 + j*26, 34, 24, k)
for a in range(-80, 81, 12):
    t = math.radians(a); r1, r2 = R-55, R-95
    p = [(L + r*math.cos(t+dt), r*math.sin(t+dt)) for r, dt in ((r2, -.09), (r1, -.09), (r1, .09), (r2, .09))]
    poly(p, C['dl'], '#ffffff')
poly([(L + 50*math.cos(math.radians(a)), 50*math.sin(math.radians(a))) for a in range(0, 360, 20)], '#7cbf5a')
# viền phân khu
def zone(u1, u2, col, lab):
    pts = [T(u1, -R+40), T(u2, -R+40), T(u2, R-50), T(u1, R-50)]
    d.line(pts + [pts[0]], fill=col, width=4)
zone(30, 475, '#1f3fbf', 'Habora'); zone(480, 645, '#c0249a', 'Centria')
d.line([T(650, -R+40), T(L, -R+40)] + [T(L + (R-30)*math.cos(math.radians(a)), (R-30)*math.sin(math.radians(a))) for a in range(-90, 91, 10)] + [T(L, R-50), T(650, R-50), T(650, -R+40)], fill='#c62828', width=4)
for u, lab, col in ((250, 'HABORA', '#1f3fbf'), (562, 'CENTRIA', '#c0249a'), (830, 'RIVERA', '#c62828')):
    x, y = T(u, R-25); f = F(26, True); w = d.textlength(lab, font=f)
    d.rounded_rectangle((x-w/2-10, y-18, x+w/2+10, y+18), 8, fill='white', outline=col, width=3); d.text((x, y), lab, font=f, fill=col, anchor='mm')
# cầu
def bridge(p, q, lab, side):
    d.line([p, q], fill='#808080', width=16); d.line([p, q], fill='#bdbdbd', width=10)
    d.text((q[0]+side*10, q[1]), lab, font=F(22, True), fill='#333', anchor='lm' if side > 0 else 'rm')
bridge(T(650, -R), (T(650, -R)[0] + 150*math.sin(A)/math.cos(A), 120), 'Cầu → đường Chương D, hướng đi biển', 1)
bridge(T(470, R), (T(470, R)[0] - 130*math.sin(A)/math.cos(A), T(470, R)[1] + 130), 'Cầu → KĐT Nam Hòa Xuân', 1)
for (x, y, t) in ((420, 170, 'Sông Đô Toả'), (1450, 460, 'Sông Đô Toả'), (1100, 930, 'Sông Đô Toả')):
    d.text((x, y), t, font=F(26), fill='#2b6f99', anchor='mm')
# tiêu đề + chú thích
d.rounded_rectangle((24, 22, 760, 110), 14, fill='white')
d.text((44, 32), 'SƠ ĐỒ MẶT BẰNG SUNNEVA ISLAND', font=F(36, True), fill='#0d3b66')
d.text((44, 76), 'Đảo Đồng Nò, Hòa Quý (Ngũ Hành Sơn) · 3 phân khu', font=F(22), fill='#333')
x0, y0 = 24, 560
d.rounded_rectangle((x0, y0, 424, 900), 14, fill='white')
d.text((x0+20, y0+14), 'Chú thích', font=F(24, True), fill='#0d3b66')
for i, (k, t) in enumerate((('th', 'Townhouse'), ('sl', 'Biệt thự song lập'), ('dl', 'Biệt thự đơn lập'))):
    y = y0 + 56 + i*38; d.rectangle((x0+20, y, x0+56, y+26), fill=C[k]); d.text((x0+70, y+13), t, font=F(21), fill='#222', anchor='lm')
for i, (col, t) in enumerate((('#1f3fbf', 'Phân khu Habora'), ('#c0249a', 'Phân khu Centria'), ('#c62828', 'Phân khu Rivera'))):
    y = y0 + 176 + i*36; d.rectangle((x0+20, y+4, x0+56, y+22), outline=col, width=4); d.text((x0+70, y+13), t, font=F(21), fill='#222', anchor='lm')
d.text((x0+20, y0+292), 'Công viên ven sông, đường dạo bộ,', font=F(18), fill='#444')
d.text((x0+20, y0+314), 'khu thể thao, giáo dục, nhà cộng đồng', font=F(18), fill='#444')
d.text((24, H-34), 'Sơ đồ minh họa, không theo tỉ lệ – vẽ lại theo mặt bằng tổng thể dự án. Hoàng Hiệp · hiephoangmt.com · 0904 567 009', font=F(19), fill='#333')
out = os.path.join(os.path.dirname(__file__), '..', 'wp-content', 'mu-plugins', 'hh-crm', 'img', 'sunneva-island', 'sunneva-island-mat-bang-tong-the.jpg')
img.save(out, quality=88); print(out)
