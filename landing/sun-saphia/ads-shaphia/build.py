# Trang ads cho sun-shaphiaresidence.com: lấy bản /ads (ads-v3) đã dựng, đổi tên miền, ảnh đầu trang phối cảnh, sau sự kiện 23/10 tự bỏ mục sự kiện
import re
D='/home/user/hoang-hiep-crm/landing/sun-saphia/'
s=open(D+'ads-v3/index.html',encoding='utf8').read()
IMG='https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/3986107e7e19e455f2ac286123672addf10671d7/projects/sun-saphia/images/'
PC=IMG+'ss-phoi-canh-bien-hoang-hon.webp'
def rp(a,b,n=1):
    global s
    c=s.count(a); assert c==n,(a[:80],c); s=s.replace(a,b)
rp('<meta property="og:url" content="https://www.sun-saphia-residence.com/ads">','<meta property="og:url" content="https://www.sun-shaphiaresidence.com/ads">\n<link rel="canonical" href="https://www.sun-shaphiaresidence.com/ads">')
s=s.replace('| Mở bán cuối 11/2026</title>','| Nhận bảng giá</title>')
s=re.sub(r'<meta property="og:title" content="[^"]*">','<meta property="og:title" content="Sun Saphia Residence Đà Nẵng – căn hộ trục biển của Sun">',s)
s=re.sub(r'<meta property="og:description" content="[^"]*">','<meta property="og:description" content="Studio · 1PN+ · 2PN trên trục biển Võ Nguyên Giáp – Trường Sa, ra biển khoảng 400 m. Đăng ký nhận bảng giá, mặt bằng và chính sách qua Zalo, không thu tiền.">',s)
s=re.sub(r'<meta property="og:image" content="[^"]*">','<meta property="og:image" content="'+IMG+'chia-se-ss-phoi-canh-1200x630.jpg">',s)
s=re.sub(r'<link rel="preload" as="image" href="[^"]*kick-off-sun-saphia-23-10-1200\.jpg">','<link rel="preload" as="image" href="'+PC+'">',s)
# Ảnh đầu trang: phối cảnh tòa tháp; dòng sự kiện tự ẩn sau 23/10
a=s.index('<a class="banner" href="#su-kien"'); b=s.index('</a>',a)+4
s=s[:a]+('<a class="banner" href="#su-kien" aria-label="Phối cảnh Sun Saphia Residence – đăng ký nhận thông tin">'
 '<img src="'+PC+'" width="1280" height="720" alt="Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên bờ biển Đà Nẵng lúc hoàng hôn" fetchpriority="high" decoding="async">'
 '<span class="cap"><span class="hero-cap-ev">📅 <b>Kick-off 8:30 · Thứ Sáu 23/10</b> · KOI Resorts &amp; Residence · </span>Phối cảnh minh hoạ</span></a>')+s[b:]
# Menu "Sự kiện 23/10" bỏ hẳn sau sự kiện
open(D+'ads-shaphia/index.html','w',encoding='utf8').write(s); print('ok',len(s))
