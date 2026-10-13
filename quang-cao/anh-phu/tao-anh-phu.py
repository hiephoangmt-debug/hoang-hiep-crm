import unicodedata as U
from PIL import Image, ImageDraw, ImageFont, ImageFilter
D='/tmp/claude-0/-home-user-hoang-hiep-crm/04904dc5-f0d4-5f74-b258-32836a553812/scratchpad/'
SRC='/home/user/hoang-hiep-crm/landing-pages/assets/sun-fours-tower-phoi-canh-bien-hoang-hon.jpg'
F=lambda n,s: ImageFont.truetype(D+'fonts/'+n+'.ttf', s)
NAVY=(11,26,58); NAVY2=(19,40,90); OR=(244,122,31); ORH=(255,160,74); WHITE=(255,255,255); MUTE=(205,213,230)
N=lambda s: U.normalize('NFC', s)

def cover(img, w, h, ay=0.5):
    r=max(w/img.width, h/img.height); im=img.resize((round(img.width*r), round(img.height*r)), Image.LANCZOS)
    x=(im.width-w)//2; y=int((im.height-h)*ay); return im.crop((x,y,x+w,y+h))

def grad(base, y0, y1, color, a0=0, a1=255):
    ov=Image.new('RGBA', base.size, (0,0,0,0)); d=ImageDraw.Draw(ov)
    for y in range(y0, y1):
        a=int(a0+(a1-a0)*(y-y0)/max(1,y1-y0)); d.line([(0,y),(base.width,y)], fill=color+(a,))
    base.alpha_composite(ov)

def text(d, xy, s, font, fill, anchor='la'):
    d.text(xy, N(s), font=font, fill=fill, anchor=anchor)

def pill(d, x, y, s, font, bg, fg, padx=22, h=52):
    w=d.textlength(N(s), font=font); d.rounded_rectangle([x,y,x+w+2*padx,y+h], radius=h//2, fill=bg)
    d.text((x+padx, y+h/2), N(s), font=font, fill=fg, anchor='lm'); return x+w+2*padx

def glass(im, box, r=22):
    ov=Image.new('RGBA', im.size, (0,0,0,0)); ImageDraw.Draw(ov).rounded_rectangle(box, radius=r, fill=(255,255,255,20), outline=OR+(170,), width=2); im.alpha_composite(ov)

def tile(d, x, y, w, h, big, small, fb, fs):
    glass(d._image, [x,y,x+w,y+h])
    d.text((x+w/2, y+h*0.40), N(big), font=fb, fill=ORH, anchor='mm')
    d.text((x+w/2, y+h*0.76), N(small), font=fs, fill=MUTE, anchor='mm')

photo=Image.open(SRC).convert('RGB')

# ===== Ảnh 1: Thư mời 4:5 =====
W,H=1080,1350; PH=800
im=Image.new('RGBA',(W,H),NAVY+(255,)); im.paste(cover(photo,W,PH,0.35),(0,0))
grad(im, 0, 170, NAVY, 150, 0); grad(im, PH-330, PH, NAVY, 0, 255)
d=ImageDraw.Draw(im)
text(d,(60,58),'SUN GROUP · TÒA F2 SUN FOURS TOWER',F('bvp-700',27),WHITE)
pill(d,60,108,'THƯ MỜI SỰ KIỆN',F('bvp-800',27),OR,WHITE)
text(d,(60,PH-215),'Căn nhà bên biển',F('pf-700',86),WHITE)
text(d,(60,PH-112),'Đà Nẵng cho cả gia đình',F('pf-700',72),ORH)
# Ngày – địa điểm
y=PH+18
d.rounded_rectangle([60,y,250,y+190],radius=26,fill=OR)
text(d,(155,y+80),'18',F('bvp-800',96),WHITE,'mm'); text(d,(155,y+158),'THÁNG 10',F('bvp-800',26),WHITE,'mm')
text(d,(285,y+18),'CHỦ NHẬT · 18/10/2026 · 9:00',F('bvp-800',33),WHITE)
text(d,(285,y+68),'Sun Gallery Tây Hồ View',F('pf-700',48),ORH)
text(d,(285,y+136),'58 Quảng Bá, Tây Hồ, Hà Nội',F('bvp-600',29),MUTE)
# 3 ô số
y=PH+240; w=(W-120-2*24)//3
for i,(b,s) in enumerate([('~700 tr','vốn ban đầu căn 2PN'),('0%','lãi suất 24 tháng'),('1h20','bay Hà Nội – Đà Nẵng')]):
    tile(d,60+i*(w+24),y,w,150,b,s,F('bvp-800',54),F('bvp-600',24)); d=ImageDraw.Draw(im)
# CTA
y=H-130
d.rounded_rectangle([60,y,W-60,y+86],radius=43,fill=OR)
text(d,(W/2,y+43),'Đăng ký nhận thư mời · Số chỗ có hạn',F('bvp-800',33),WHITE,'mm')
text(d,(W/2,H-22),'Phối cảnh minh họa · Số chỗ có hạn',F('bvp-400',20),(150,162,190),'mm')
im.convert('RGB').save(D+'zalo-phu/thu-moi-su-kien-18-10-ha-noi.jpg',quality=88,optimize=True,progressive=True)

# ===== Ảnh 2: Vì sao gia đình Hà Nội chọn Đà Nẵng 1:1 =====
W,H=1080,1080; PH=470
im=Image.new('RGBA',(W,H),NAVY+(255,)); im.paste(cover(photo,W,PH,0.3),(0,0))
grad(im, PH-200, PH, NAVY, 0, 255); grad(im,0,120,NAVY,120,0)
d=ImageDraw.Draw(im)
pill(d,60,50,'SỰ KIỆN CN 18/10 · SUN GALLERY TÂY HỒ VIEW',F('bvp-800',25),OR,WHITE,h=48)
text(d,(60,PH-130),'Bay một giờ hai mươi phút –',F('pf-700',60),WHITE)
text(d,(60,PH-60),'về nhà bên biển',F('pf-700',64),ORH)
items=[('1h20','Đi về thuận tiện','Xuống sân bay 10 phút là về tới nhà'),
       ('2 km','Hè tắm biển, đông tránh rét','5 phút ra biển Sơn Thủy'),
       ('Sun','Tài sản chắc chắn','Sun Group · đất ở lâu dài · bảo lãnh ngân hàng')]
y=PH+40
for b,t,s in items:
    glass(im,[60,y,W-60,y+132]); d=ImageDraw.Draw(im)
    d.rounded_rectangle([80,y+18,250,y+114],radius=18,fill=OR)
    text(d,(165,y+66),b,F('bvp-800',44),WHITE,'mm')
    text(d,(280,y+30),t,F('bvp-800',34),WHITE); text(d,(280,y+80),s,F('bvp-400',26),MUTE)
    y+=150
text(d,(W/2,H-38),'Căn 2PN 61 m² ~2,8 tỷ · vốn ban đầu chỉ ~700 triệu',F('bvp-700',27),ORH,'mm')
im.convert('RGB').save(D+'zalo-phu/vi-sao-gia-dinh-ha-noi-chon-da-nang.jpg',quality=88,optimize=True,progressive=True)
print('ok')

# ===== Ảnh 3: Địa điểm sự kiện (ảnh dọc khu Tây Hồ View) 4:5 =====
def shadow_text(im, xy, s, font, fill, anchor='la', r=8, a=170):
    lay=Image.new('RGBA', im.size, (0,0,0,0)); ImageDraw.Draw(lay).text(xy, N(s), font=font, fill=(0,0,0,a), anchor=anchor)
    im.alpha_composite(lay.filter(ImageFilter.GaussianBlur(r))); ImageDraw.Draw(im).text(xy, N(s), font=font, fill=fill, anchor=anchor)
def fit(d, s, name, size, maxw):
    while d.textlength(N(s), font=F(name,size)) > maxw: size-=2
    return F(name,size)
V=Image.open('/root/.claude/uploads/04904dc5-f0d4-5f74-b258-32836a553812/b1476578-image.jpg').convert('RGB')
W,H=1080,1350; PH=900
im=Image.new('RGBA',(W,H),NAVY+(255,)); im.paste(cover(V,W,PH,0.16),(0,0))
grad(im,0,170,NAVY,190,0); grad(im,PH-200,PH,NAVY,0,255)
d=ImageDraw.Draw(im)
pill(d,60,50,'THƯ MỜI · CHỦ NHẬT 18/10/2026',F('bvp-800',26),OR,WHITE,h=50)
d=ImageDraw.Draw(im)
# Khối thông tin
y0=PH-40
d.rounded_rectangle([40,y0,W-40,H-40],radius=30,fill=NAVY2,outline=OR,width=3)
text(d,(80,y0+38),'ĐỊA ĐIỂM SỰ KIỆN GIỚI THIỆU TÒA F2 – SUN FOURS TOWER',F('bvp-800',22),ORH)
ft=fit(d,'Sun Gallery Tây Hồ View','pf-700',66,W-160)
text(d,(80,y0+74),'Sun Gallery ',ft,WHITE); x=80+d.textlength(N('Sun Gallery '),font=ft)
text(d,(x,y0+74),'Tây Hồ View',ft,ORH)
d.ellipse([80,y0+172,104,y0+196],fill=OR); d.ellipse([88,y0+180,96,y0+188],fill=NAVY2)
text(d,(118,y0+165),'58 Quảng Bá, Tây Hồ, Hà Nội',F('bvp-700',34),WHITE)
# 2 chip thời gian
cy=y0+232; cw=(W-80-80-20)//2
for k,(a,b) in enumerate([('9:00 – 11:20','Đón khách & teabreak 9:00'),('Bốc thăm','may mắn cuối chương trình')]):
    x0=80+k*(cw+20); d.rounded_rectangle([x0,cy,x0+cw,cy+96],radius=18,fill=None,outline=(244,122,31),width=2)
    text(d,(x0+22,cy+16),a,F('bvp-800',32),ORH); text(d,(x0+22,cy+58),b,F('bvp-400',22),MUTE)
# CTA
by=H-40-24-78
d.rounded_rectangle([80,by,W-80,by+78],radius=39,fill=OR)
text(d,(W/2,by+39),'Đăng ký giữ chỗ tham dự sự kiện',F('bvp-800',34),WHITE,'mm')
im.convert('RGB').save(D+'zalo-phu/dia-diem-su-kien-18-10-sun-gallery-tay-ho-view.jpg',quality=90,optimize=True,progressive=True)
print('ok3')

# ===== Ảnh 4 & 5: Lồng ghép dự án (Đà Nẵng) + địa điểm sự kiện (Hà Nội) =====
def rounded(img, r):
    m=Image.new('L', img.size, 0); ImageDraw.Draw(m).rounded_rectangle([0,0,img.width-1,img.height-1], radius=r, fill=255)
    o=Image.new('RGBA', img.size, (0,0,0,0)); o.paste(img.convert('RGBA'), (0,0), m); return o
def card_shadow(im, box, r=26):
    lay=Image.new('RGBA', im.size, (0,0,0,0)); ImageDraw.Draw(lay).rounded_rectangle(box, radius=r, fill=(0,0,0,150))
    im.alpha_composite(lay.filter(ImageFilter.GaussianBlur(14)))
def tag(d, x, y, s, f):
    w=d.textlength(N(s), font=f); d.rounded_rectangle([x,y,x+w+28,y+40], radius=20, fill=(11,26,58)); d.text((x+14,y+20), N(s), font=f, fill=WHITE, anchor='lm')

def combo(W, H, PH, name, thumb_w, thumb_h, compact=False):
    im=Image.new('RGBA',(W,H),NAVY+(255,)); im.paste(cover(photo,W,PH,0.3),(0,0))
    grad(im,0,180,NAVY,170,0); grad(im,PH-300,PH,NAVY,0,255)
    d=ImageDraw.Draw(im)
    pill(d,56,48,'THƯ MỜI · CHỦ NHẬT 18/10/2026',F('bvp-800',25),OR,WHITE,h=48)
    tag(d,W-56-d.textlength(N('Phối cảnh dự án tại Đà Nẵng'),font=F('bvp-600',20))-28,52,'Phối cảnh dự án tại Đà Nẵng',F('bvp-600',20))
    hs=74 if not compact else 62
    shadow_text(im,(56,PH-hs*2-40),'Căn nhà bên biển Đà Nẵng',F('pf-700',hs),WHITE)
    shadow_text(im,(56,PH-hs-30),'Tòa F2 – Sun FourS Tower',F('pf-700',int(hs*0.86)),ORH)
    d=ImageDraw.Draw(im)
    # Thẻ địa điểm: ảnh Tây Hồ View + thông tin
    y0=PH-10; x0=56
    th=rounded(cover(V,thumb_w,thumb_h,0.45),24)
    card_shadow(im,[x0,y0,x0+thumb_w,y0+thumb_h]); im.alpha_composite(th,(x0,y0)); d=ImageDraw.Draw(im)
    d.rounded_rectangle([x0,y0,x0+thumb_w,y0+thumb_h],radius=24,outline=OR,width=3)
    tag(d,x0+14,y0+thumb_h-54,'Nơi tổ chức tại Hà Nội',F('bvp-600',19))
    tx=x0+thumb_w+32; tw=W-56-tx
    text(d,(tx,y0+6),'ĐỊA ĐIỂM SỰ KIỆN',F('bvp-800',22),ORH)
    ft=fit(d,'Tây Hồ View','pf-700',58,tw)
    text(d,(tx,y0+40),'Sun Gallery',ft,WHITE); text(d,(tx,y0+40+ft.size*1.12),'Tây Hồ View',ft,ORH)
    yy=y0+40+ft.size*2.35
    text(d,(tx,yy),'58 Quảng Bá, Tây Hồ, Hà Nội',fit(d,'58 Quảng Bá, Tây Hồ, Hà Nội','bvp-700',28,tw),WHITE)
    text(d,(tx,yy+44),'Chủ nhật 18/10 · 9:00 – 11:20',fit(d,'Chủ nhật 18/10 · 9:00 – 11:20','bvp-600',25,tw),MUTE)
    text(d,(tx,yy+82),'Teabreak · Bốc thăm may mắn',fit(d,'Teabreak · Bốc thăm may mắn','bvp-400',23,tw),MUTE)
    # Dải 3 con số
    sy=y0+thumb_h+28; sw=(W-112-2*16)//3
    for i,(b,s) in enumerate([('~700 tr','vốn ban đầu căn 2PN'),('0%','lãi 24 tháng · vay 70%'),('2 km','ra biển Sơn Thủy')]):
        glass(im,[56+i*(sw+16),sy,56+i*(sw+16)+sw,sy+110],r=18); d=ImageDraw.Draw(im)
        text(d,(56+i*(sw+16)+sw/2,sy+40),b,F('bvp-800',40),ORH,'mm'); text(d,(56+i*(sw+16)+sw/2,sy+84),s,F('bvp-600',20),MUTE,'mm')
    by=sy+110+26; assert by+76<=H-30, (name,by)
    d.rounded_rectangle([56,by,W-56,by+76],radius=38,fill=OR)
    text(d,(W/2,by+38),'Đăng ký giữ chỗ tham dự sự kiện',F('bvp-800',33),WHITE,'mm')
    im.convert('RGB').save(D+'zalo-phu/'+name,quality=90,optimize=True,progressive=True)

combo(1080,1350,720,'thu-moi-du-an-va-dia-diem-18-10.jpg',390,370)
combo(1080,1080,500,'thu-moi-du-an-va-dia-diem-18-10-vuong.jpg',330,290,compact=True)
print('ok45')
