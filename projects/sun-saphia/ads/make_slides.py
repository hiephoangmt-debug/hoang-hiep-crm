"""Tạo bộ slide carousel quảng cáo Sun Saphia Residence (1080x1350)."""
from PIL import Image, ImageDraw, ImageFont, ImageFilter
import os
HERE=os.path.dirname(os.path.abspath(__file__)); IMG=os.path.join(HERE,'..','images'); DN=os.path.join(HERE,'..','..','hai-minh-da-nang','landing','images')
B='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'; R='/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
F=lambda p,s:ImageFont.truetype(p,s)
W,H=1080,1350; NAVY=(10,37,64); ORANGE=(255,106,43); GOLD=(255,176,103); WHITE=(255,255,255); SOFT=(220,232,244)
TOTAL=13

def cover(path,box=None,focus=0.5):
    im=Image.open(path).convert('RGB')
    if box: im=im.crop(box)
    r=max(W/im.width,H/im.height); im=im.resize((int(im.width*r)+1,int(im.height*r)+1),Image.LANCZOS)
    x=int((im.width-W)*focus); y=(im.height-H)//2
    return im.crop((x,y,x+W,y+H))

def shade(im,top=0,bottom=235,start=0.35):
    ov=Image.new('RGBA',(W,H)); d=ImageDraw.Draw(ov)
    for y in range(H):
        t=max(0,(y/H-start)/(1-start)) if y/H>start else 0
        a=int(top*(1-y/H)+bottom*t)
        d.line([(0,y),(W,y)],fill=(6,22,40,min(255,a)))
    return Image.alpha_composite(im.convert('RGBA'),ov)

def wrap(d,text,font,maxw):
    out=[]
    for para in text.split('\n'):
        line=''
        for w in para.split(' '):
            t=(line+' '+w).strip()
            if d.textlength(t,font=font)<=maxw: line=t
            else: out.append(line); line=w
        out.append(line)
    return out

def text(d,x,y,s,font,fill,maxw=W-120,gap=1.25):
    for ln in wrap(d,s,font,maxw):
        d.text((x,y),ln,font=font,fill=fill); y+=int(font.size*gap)
    return y

def badge(d,x,y,s,fill=ORANGE,size=30,col=WHITE):
    f=F(B,size); w=d.textlength(s,font=f)
    d.rounded_rectangle((x,y,x+w+44,y+size+26),(size+26)//2,fill=fill); d.text((x+22,y+11),s,font=f,fill=col)
    return y+size+26

def frame(im,n,photo_note=None):
    d=ImageDraw.Draw(im)
    # top brand line
    d.text((60,52),'SUN SAPHIA RESIDENCE',font=F(B,28),fill=WHITE)
    d.text((W-130,52),f'{n:02d}/{TOTAL}',font=F(B,26),fill=(255,255,255,200))
    # bottom bar
    d.rectangle((0,H-110,W,H),fill=NAVY)
    d.rounded_rectangle((60,H-90,500,H-24),33,fill=ORANGE)
    d.text((88,H-77),'☎ 0904 567 009',font=F(B,36),fill=WHITE)
    d.text((530,H-86),'Hotline/Zalo · Hoàng Hiệp',font=F(B,26),fill=WHITE)
    d.text((530,H-50),'chuyên viên tư vấn',font=F(R,22),fill=SOFT)
    if photo_note: d.text((60,H-140),photo_note,font=F(R,19),fill=(230,236,244))
    return im

def wm(im):
    tile=Image.new('RGBA',(W*2,H*2)); td=ImageDraw.Draw(tile); t='Hoàng Hiệp · 0904 567 009'; f=F(B,34)
    for y in range(0,H*2,170):
        for x in range(-300,W*2,620): td.text((x+(y//170)%2*310,y),t,font=f,fill=(255,255,255,26))
    tile=tile.rotate(25,center=(W,H)).crop((W//2,H//2,W//2+W,H//2+H))
    return Image.alpha_composite(im.convert('RGBA'),tile)

def card(d,x,y,w,h,title,sub,fill=(255,255,255,235)):
    d.rounded_rectangle((x,y,x+w,y+h),24,fill=fill)
    d.text((x+28,y+24),title,font=F(B,40),fill=NAVY)
    text(d,x+28,y+80,sub,F(R,27),(60,72,90),maxw=w-56)

slides=[]
def save(im,n): im=wm(frame(im,n)) if not isinstance(im,tuple) else im; im.convert('RGB').save(os.path.join(HERE,f'slide-{n:02d}.jpg'),quality=90); slides.append(n)

# 1 Hook
im=shade(cover(os.path.join(IMG,'ss-thap-hd.webp'),focus=0.3),top=120,bottom=245,start=0.42); d=ImageDraw.Draw(im)
badge(d,60,620,'Dự kiến mở bán cuối 11/2026')
y=text(d,60,710,'Căn hộ mặt biển khu Saphia',F(B,64),WHITE)
y=text(d,60,y,'sẽ có giá bao nhiêu khi mở bán?',F(B,64),GOLD)
text(d,60,y+20,'30 tầng · 782 căn · cạnh bãi tắm Sơn Thủy, Đà Nẵng\nVuốt để xem → ',F(R,32),SOFT)
save(im,1)

# 2 Scarcity
im=shade(cover(os.path.join(IMG,'ss-bien-hd.webp'),focus=0.35),top=170,bottom=245,start=0.30); d=ImageDraw.Draw(im)
badge(d,60,140,'Biển là tài nguyên hữu hạn',fill=(255,255,255),col=NAVY)
y=text(d,60,230,'Căn hộ thật sự sát biển Đà Nẵng ngày càng hiếm',F(B,60),WHITE)
d.rounded_rectangle((60,780,W-60,1160),26,fill=(6,22,40,215))
d.text((95,805),'Giá chào bán tham khảo căn hộ mặt biển Đà Nẵng',font=F(B,30),fill=GOLD)
for i,(a,b) in enumerate([('Studio','~4,6 – 10,5 tỷ'),('1 phòng ngủ','~5,4 – 11,5 tỷ'),('2 phòng ngủ','~6,8 – 21,7 tỷ')]):
    yy=870+i*80; d.text((95,yy),a,font=F(B,40),fill=WHITE); d.text((560,yy),b,font=F(B,40),fill=GOLD)
d.text((95,1110),'Tổng hợp thị trường, không phải giá Sun Saphia Residence',font=F(R,22),fill=SOFT)
save(im,2)

# 3 Overview
im=shade(cover(os.path.join(IMG,'ss-thap-hd.webp'),focus=0.1),top=60,bottom=250,start=0.25); d=ImageDraw.Draw(im)
badge(d,60,140,'Thông tin tổng quan')
y=text(d,60,230,'Tòa tháp 30 tầng\nmặt biển khu Saphia',F(B,64),WHITE)
rows=[('Diện tích đất','3.720,1 m²'),('Chiều cao','30 tầng · ~114 m'),('Tầng hầm','2 tầng'),('Tổng số căn','782 căn'),('Dự kiến bàn giao','Tháng 11/2028')]
d.rounded_rectangle((60,620,W-60,1180),26,fill=(6,22,40,220))
for i,(a,b) in enumerate(rows):
    yy=660+i*102; d.text((100,yy),a,font=F(R,34),fill=SOFT); d.text((560,yy),b,font=F(B,40),fill=WHITE)
    if i<4: d.line((100,yy+80,W-100,yy+80),fill=(255,255,255,60),width=2)
d.text((60,1200),'Theo tài liệu giới thiệu dự án',font=F(R,22),fill=SOFT)
save(im,3)

# 4 Units
im=shade(cover(os.path.join(IMG,'ss-bien-hd.webp'),focus=0.75),top=200,bottom=200,start=0.0); d=ImageDraw.Draw(im)
badge(d,60,140,'Cơ cấu sản phẩm')
text(d,60,230,'3 dòng căn cho\nnghỉ dưỡng & cho thuê',F(B,62),WHITE)
for i,(t,s) in enumerate([('Studio · 30–31 m²','513 căn – gọn, hợp khách du lịch thuê ngắn ngày'),('1PN+1 · 50–51 m²','108 căn – thêm góc linh hoạt cho gia đình nhỏ'),('2PN · 60–70 m²','149 căn – cả nhà nghỉ dưỡng bên biển')]):
    card(d,60,560+i*200,W-120,175,t,s)
save(im,4)

# 5 Beach
im=shade(cover(os.path.join(IMG,'ss-bai-tam-son-thuy.webp')),top=40,bottom=245,start=0.4); d=ImageDraw.Draw(im)
badge(d,60,700,'Bãi tắm ngay thềm nhà')
y=text(d,60,790,'Cạnh bãi tắm Sơn Thủy',F(B,66),WHITE)
text(d,60,y+10,'Cát mịn, bờ thoải, sóng êm mùa hè – sáng ra biển chỉ vài bước chân.',F(R,34),SOFT)
save(im,5)

# 6 Park
im=shade(cover(os.path.join(IMG,'ss-cong-vien-truoc-du-an.webp')),top=40,bottom=245,start=0.4); d=ImageDraw.Draw(im)
badge(d,60,640,'Công viên biển Trường Sa')
y=text(d,60,730,'~2,45 ha công viên công cộng ngay trước dự án',F(B,58),WHITE)
text(d,60,y+10,'Vốn ngân sách hơn 47 tỷ · kế hoạch 2025–2027\nQuảng trường biển, thảm cỏ, sân chơi trẻ em, lối xuống biển',F(R,31),SOFT)
d.text((60,1200),'Ảnh minh họa · Nguồn: Báo Văn Hóa, Báo Pháp luật',font=F(R,22),fill=SOFT)
save(im,6)

# 7 Proof
base=Image.new('RGB',(W,H),(245,239,228)); p=Image.open(os.path.join(IMG,'ss-ho-so-son-thuy.webp')).convert('RGB'); p.thumbnail((470,600)); q=Image.open(os.path.join(IMG,'ss-quy-hoach-son-thuy.webp')).convert('RGB'); q.thumbnail((470,600))
base.paste(p,(60,560)); base.paste(q,(W-60-q.width,560)); im=base.convert('RGBA'); d=ImageDraw.Draw(im)
d.rectangle((0,0,W,130),fill=NAVY)
badge(d,60,160,'Dẫn chứng có hồ sơ')
text(d,60,250,'Dự án Công viên, CLB thể thao biển & Bãi tắm Sơn Thủy',F(B,48),NAVY)
text(d,60,410,'Phương án khảo sát phê duyệt theo QĐ số 130 ngày 20/3/2025 · Sở Xây dựng thẩm tra 13/3/2025',F(R,28),(60,72,90))
d.text((60,1180),'Ảnh chụp hồ sơ tại hiện trường 2/4/2025',font=F(R,22),fill=(90,100,115))
save(im,7)

# 8 Location plan
base=Image.new('RGB',(W,H),NAVY); m=Image.open(os.path.join(IMG,'ss-mat-bang-vi-tri.webp')).convert('RGB'); m.thumbnail((W-120,920)); base.paste(m,((W-m.width)//2,280)); im=base.convert('RGBA'); d=ImageDraw.Draw(im)
badge(d,60,130,'Mặt bằng vị trí'); d.text((60,205),'Góc Trường Sa – công viên – bãi tắm',font=F(B,40),fill=WHITE)
save(im,8)

# 9 Connectivity
im=shade(cover(os.path.join(IMG,'ss-ban-do-ket-noi.webp'),focus=0.3),top=150,bottom=250,start=0.35); d=ImageDraw.Draw(im)
badge(d,60,620,'Đủ gần để kết nối')
for i,(a,b) in enumerate([('Sân bay quốc tế','10–15 phút'),('Ngũ Hành Sơn · An Thượng','5–10 phút'),('Cầu Rồng – trung tâm','~15 phút'),('Phố cổ Hội An','~30 phút'),('Bà Nà Hills','~45 phút')]):
    yy=720+i*82; d.text((60,yy),a,font=F(B,38),fill=WHITE); w=d.textlength(b,font=F(B,38)); d.text((W-60-w,yy),b,font=F(B,38),fill=GOLD)
d.text((60,1140),'Thời gian ước tính bằng ô tô',font=F(R,22),fill=SOFT)
save(im,9)

# 10 Da Nang collage
base=Image.new('RGB',(W,H),NAVY)
def tilep(path,box):
    t=Image.open(path).convert('RGB'); bw,bh=box[2]-box[0],box[3]-box[1]; r=max(bw/t.width,bh/t.height); t=t.resize((int(t.width*r)+1,int(t.height*r)+1)); x=(t.width-bw)//2; y=(t.height-bh)//2; base.paste(t.crop((x,y,x+bw,y+bh)),box[:2])
tilep(os.path.join(DN,'dn-cau-vang-ba-na.webp'),(0,0,540,560)); tilep(os.path.join(DN,'dn-pho-co-hoi-an.webp'),(540,0,1080,560))
tilep(os.path.join(DN,'dn-phao-hoa-song-han.webp'),(0,560,540,1120)); tilep(os.path.join(DN,'dn-cau-rong-song-han.webp'),(540,560,1080,1120))
im=shade(base,top=0,bottom=200,start=0.55); d=ImageDraw.Draw(im)
d.rounded_rectangle((60,430,W-60,690),26,fill=(6,22,40,225))
text(d,95,460,'Sáng tắm biển, chiều phố cổ, tối pháo hoa sông Hàn',F(B,46),WHITE,maxw=W-190)
d.text((60,1140),'Ảnh minh họa Đà Nẵng: Unsplash',font=F(R,22),fill=SOFT)
save(im,10)

# 11 Infrastructure
im=shade(cover(os.path.join(DN,'dn-ca-chep-hoa-rong-dem.webp'),focus=0.5),top=200,bottom=220,start=0.0); d=ImageDraw.Draw(im)
badge(d,60,140,'Đà Nẵng đang tăng tốc')
y=230
for t,s in [('🚆 Đường sắt đô thị sân bay – Hội An','Giai đoạn 1 ~30,2 km, dự kiến khởi công 2/2027 (Tuổi Trẻ)'),('🛣 Mở rộng trục ven biển','Võ Nguyên Giáp – Trường Sa – Hội An (Báo Đầu tư)'),('📈 16,5 triệu lượt khách lưu trú','11 tháng 2025, +18,9% – Cục Thống kê TP Đà Nẵng'),('🏦 Khu thương mại tự do','QĐ 1142/QĐ-TTg, 6/2025')]:
    d.rounded_rectangle((60,y,W-60,y+200),24,fill=(255,255,255,232)); d.text((90,y+28),t.split(' ',1)[1],font=F(B,38),fill=NAVY); text(d,90,y+92,s,F(R,29),(60,72,90),maxw=W-180); y+=225
d.text((60,1140),'Theo quy hoạch, tiến độ do Nhà nước quyết định',font=F(R,22),fill=SOFT)
save(im,11)

# 12 Why now
im=Image.new('RGBA',(W,H),NAVY+(255,)); d=ImageDraw.Draw(im)
badge(d,60,140,'Vì sao tìm hiểu ngay?')
y=250
for i,(t,s) in enumerate([('Nhận chính sách đợt đầu sớm nhất','Giá, chính sách mở bán gửi ngay khi công bố'),('Chọn căn trước','Căn view biển, tầng đẹp có hạn theo mặt bằng'),('Hỗ trợ tài chính (nếu có)','Bảng tính theo đúng căn và số vốn của anh/chị'),('Vị trí khan hiếm','Sát biển, cạnh bãi tắm và công viên công cộng')]):
    d.ellipse((60,y,130,y+70),fill=ORANGE); d.text((84,y+12),str(i+1),font=F(B,40),fill=WHITE)
    d.text((160,y+2),t,font=F(B,40),fill=WHITE); text(d,160,y+58,s,F(R,30),SOFT,maxw=W-220); y+=200
save(im,12)

# 13 CTA
im=shade(cover(os.path.join(IMG,'ss-thap-hd.webp'),focus=0.6),top=80,bottom=250,start=0.35); d=ImageDraw.Draw(im)
badge(d,60,560,'Dự kiến mở bán cuối 11/2026')
y=text(d,60,650,'Nhận bảng giá & mặt bằng Sun Saphia Residence',F(B,58),WHITE)
d.rounded_rectangle((60,y+30,W-60,y+140),55,fill=ORANGE); f=F(B,44); s='Nhắn Zalo 0904 567 009'; d.text(((W-d.textlength(s,font=f))//2,y+57),s,font=f,fill=WHITE)
text(d,60,y+175,'✔ Miễn phí, không thu tiền giữ chỗ\n✔ Tư vấn 1-1, gửi tài liệu chính thức khi có',F(R,32),SOFT)
save(im,13)

# contact sheet
sheet=Image.new('RGB',(5*216+60,3*270+60),(240,240,240))
for i,n in enumerate(slides):
    t=Image.open(os.path.join(HERE,f'slide-{n:02d}.jpg')); t.thumbnail((216,270)); sheet.paste(t,(10+(i%5)*226,10+(i//5)*280))
sheet.save(os.path.join(HERE,'tong-quan-13-slide.jpg'),quality=85)
print('ok',slides)
