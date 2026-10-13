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
text(d,(W/2,y+43),'Đăng ký nhận thư mời · Zalo 0904 567 009',F('bvp-800',33),WHITE,'mm')
text(d,(W/2,H-22),'Phối cảnh minh họa · Số chỗ có hạn',F('bvp-400',20),(150,162,190),'mm')
im.convert('RGB').save(D+'zalo/thu-moi-su-kien-18-10-ha-noi.jpg',quality=88,optimize=True,progressive=True)

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
text(d,(W/2,H-38),'Căn 2PN 61 m² ~2,8 tỷ · vốn ~700 triệu · Zalo 0904 567 009',F('bvp-700',27),ORH,'mm')
im.convert('RGB').save(D+'zalo/vi-sao-gia-dinh-ha-noi-chon-da-nang.jpg',quality=88,optimize=True,progressive=True)
print('ok')
