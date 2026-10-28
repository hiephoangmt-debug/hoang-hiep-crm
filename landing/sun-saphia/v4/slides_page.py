# Trang slide trên web: /trinh-chieu (cho khách, slide 1–22) và /dao-tao-sale (cho đội sale, đủ 31 slide + ghi chú).
# Nguồn slide: thư mục slides/ (xuất từ bộ slide "Sun Saphia – Bài toán đầu tư").
import json, os, re
from parts import *
from blocks import *

SD = os.path.join(os.path.dirname(__file__), 'slides') + '/'
BLOB = {  # ảnh trong bộ slide → ảnh dự án trên GitHub
    '32c352a92cf27ee8abfeaacc38978459': 'thap-tren-cao-ngay.webp',
    '633fa6299d90e81096896dfc55c58231': 'can-studio.webp',
    'b8521d6c99253e0c7a92757439469cb3': 'can-1br.webp',
    '61b2e5b2dd20d3330b11ebf26cd10a23': 'can-2br.webp',
    'f62f4dff03f1383a3064bd9a64994ee2': 'mo-rong-duong-bien-900.webp',
    'e517c482f01cd18fef7a51cba73cc2d7': 'khach-du-lich-900.webp',
    'b1d35360fb183472b182e57f9fcf6e22': 'thap-bien-hoang-hon-900.webp',
}

D4 = ('<section class="sec alt" id="xem-4d"><div class="wrap"><span class="ey">Mô hình 3D · 4D minh họa</span>'
      '<h2 class="dp" style="margin:6px 0 10px">Xoay tòa tháp, xem <b>nắng theo giờ</b> và view từ căn</h2>'
      '<p class="lead" style="margin:0 0 16px">Chọn tầng, kéo để xoay, xem hướng biển và hướng nắng. Mô hình dựng lại để minh họa, không phải bản vẽ thiết kế của chủ đầu tư.</p>'
      '<div id="chon-can"></div></div></section>')
FONTS = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800&family=Playfair+Display:wght@500..800&display=swap">'
# Chỗ để trống trong slide chỉ dành cho sale; bản cho khách bỏ đi
KHACH_FIX = [(' [__ triệu] trước khi cho thuê', ' trước khi cho thuê')]

CSS = '''<style>
.sp{max-width:1240px;margin:0 auto;padding:0 16px}
.sp-bar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin:0 0 18px}
.sp-bar button{font:inherit;font-weight:700;font-size:15px;border:0;border-radius:999px;padding:11px 20px;cursor:pointer;background:#0E2A47;color:#F7F3EC}
.sp-bar button.alt{background:#E06A2C;color:#0E2A47}
.sp-bar small{color:#6A7280;font-size:13px}
.sp-it{margin:0 0 22px}
.sp-s{position:relative;width:100%;aspect-ratio:16/9;overflow:hidden;border-radius:12px;box-shadow:0 6px 24px rgba(14,42,71,.14);cursor:zoom-in;background:#0E2A47}
.sp-n{position:absolute;right:10px;top:8px;font:700 12px/1 sans-serif;color:#fff;background:rgba(14,42,71,.7);padding:5px 8px;border-radius:999px}
.sp-c section,.sp-c section *:not(svg):not(svg *){all:revert}
.sp .sp-c>section,.sp-pv .sp-c>section{position:absolute;left:0;top:0;width:1920px;height:1080px;box-sizing:border-box;transform-origin:0 0;transform:scale(var(--k,.5));overflow:hidden}
.sp .sp-c section h1,.sp .sp-c section h2,.sp .sp-c section h3,.sp .sp-c section p,.sp-pv .sp-c section h1,.sp-pv .sp-c section h2,.sp-pv .sp-c section h3,.sp-pv .sp-c section p{margin:0}
.sp .sp-c section p,.sp-pv .sp-c section p{line-height:1.4}
.sp .sp-c section h1,.sp-pv .sp-c section h1{line-height:1.1}
.sp .sp-c section h2,.sp-pv .sp-c section h2{line-height:1.15}
.sp .sp-c section h3,.sp-pv .sp-c section h3{line-height:1.2}
.sp .sp-c section table,.sp-pv .sp-c section table{border-collapse:collapse;width:100%}
.sp .sp-c section td,.sp .sp-c section th,.sp-pv .sp-c section td,.sp-pv .sp-c section th{border:1px solid rgba(14,42,71,.14);padding:.35em .6em;text-align:left;vertical-align:top;line-height:1.4}
.sp .sp-c section img,.sp-pv .sp-c section img{display:block}
.sp .sp-c section>:not([style*="position:absolute"]),.sp-pv .sp-c section>:not([style*="position:absolute"]){position:relative}
.sp .sp-c section aside,.sp-pv .sp-c section aside{display:none}
.sp-note{background:#FFF1E6;border-left:4px solid #E06A2C;border-radius:8px;padding:10px 14px;margin:10px 0 0;font-size:15px;line-height:1.55;color:#3D4A5C}
.sp-note b{color:#B9501B}
.sp-pv{position:fixed;inset:0;z-index:2147483000;background:#0b1626;display:none}
.sp-pv.on{display:block}
.sp-pv-s{position:absolute;overflow:hidden}
.sp-pv button{position:absolute;border:0;border-radius:999px;background:rgba(255,255,255,.14);color:#fff;font:700 22px/1 sans-serif;width:48px;height:48px;cursor:pointer}
.sp-pv .px{right:14px;top:14px}.sp-pv .pp{left:14px;top:50%}.sp-pv .pn{right:14px;top:50%}
.sp-pv .pc{position:absolute;left:50%;bottom:12px;transform:translateX(-50%);color:#C9D6E3;font:600 14px sans-serif}
.sp-rot{display:none;position:absolute;left:50%;top:14px;transform:translateX(-50%);color:#F2A46E;font:600 13px sans-serif;white-space:nowrap}
@media (orientation:portrait) and (max-width:760px){.sp-rot{display:block}}
@media print{@page{size:A4 landscape;margin:0}
 body *{visibility:hidden}.sp,.sp *{visibility:visible}.sp{position:absolute;left:0;top:0;max-width:none;padding:0;width:297mm}
 .sp-bar,.sp-note,.sp-n{display:none}.sp-it{margin:0;page-break-after:always;break-after:page}
 .sp-s{width:297mm;height:167mm;aspect-ratio:auto;border-radius:0;box-shadow:none}}
</style>'''

JS = '''<script>(function(){
var R=document.getElementById("sp");if(!R)return;
var S=[].slice.call(R.querySelectorAll(".sp-s"));
function fit(){S.forEach(function(s){s.style.setProperty("--k",s.clientWidth/1920)})}
window.addEventListener("resize",fit);window.addEventListener("beforeprint",function(){S.forEach(function(s){s.style.setProperty("--k",(297*96/25.4)/1920)})});
window.addEventListener("afterprint",fit);fit();setTimeout(fit,300);
var P=document.createElement("div");P.className="sp-pv";P.setAttribute("role","dialog");P.setAttribute("aria-label","Trình chiếu");
P.innerHTML='<div class="sp-pv-s"><div class="sp-c"></div></div><span class="sp-rot">Xoay ngang điện thoại để xem rõ hơn</span><button class="pp" aria-label="Slide trước">‹</button><button class="pn" aria-label="Slide sau">›</button><button class="px" aria-label="Đóng">×</button><span class="pc"></span>';
document.body.appendChild(P);var box=P.querySelector(".sp-pv-s"),C=box.firstChild,i=0;
function show(n){i=(n+S.length)%S.length;C.innerHTML=S[i].querySelector(".sp-c").innerHTML;place();P.querySelector(".pc").textContent=(i+1)+" / "+S.length}
function place(){var w=innerWidth,h=innerHeight,k=Math.min(w/1920,h/1080);box.style.width=1920*k+"px";box.style.height=1080*k+"px";box.style.left=(w-1920*k)/2+"px";box.style.top=(h-1080*k)/2+"px";C.firstChild&&C.firstChild.style.setProperty("--k",k)}
function open(n){P.classList.add("on");document.documentElement.style.overflow="hidden";show(n);try{if(window.gtag)gtag("event","slide_present",{event_label:R.getAttribute("data-ctx")})}catch(e){}}
function close(){P.classList.remove("on");document.documentElement.style.overflow="";if(document.fullscreenElement)document.exitFullscreen()}
S.forEach(function(s,n){s.addEventListener("click",function(){open(n)})});
P.querySelector(".pp").onclick=function(){show(i-1)};P.querySelector(".pn").onclick=function(){show(i+1)};P.querySelector(".px").onclick=close;
addEventListener("resize",function(){if(P.classList.contains("on"))place()});
addEventListener("keydown",function(e){if(!P.classList.contains("on"))return;if(e.key==="ArrowRight"||e.key===" "||e.key==="PageDown"){e.preventDefault();show(i+1)}else if(e.key==="ArrowLeft"||e.key==="PageUp"){show(i-1)}else if(e.key==="Escape")close()});
var x0=null;P.addEventListener("touchstart",function(e){x0=e.touches[0].clientX},{passive:true});
P.addEventListener("touchend",function(e){if(x0===null)return;var d=e.changedTouches[0].clientX-x0;if(Math.abs(d)>40)show(i+(d<0?1:-1));x0=null});
var b=R.querySelector("[data-sp-play]");if(b)b.onclick=function(){open(0);try{if(P.requestFullscreen)P.requestFullscreen()}catch(e){}};
var d=R.querySelector("[data-sp-pdf]");if(d)d.onclick=function(){try{if(window.gtag)gtag("event","slide_pdf",{event_label:R.getAttribute("data-ctx")})}catch(e){}window.print()};
})();</script>'''

def load():
    deck = json.load(open(SD + 'deck.json', encoding='utf8'))
    out = []
    for sid in deck['order']:
        h = open(SD + 'slides/' + sid + '.html', encoding='utf8').read().strip()
        h = re.sub(r'/_blob/([0-9a-f]{32})', lambda m: SK + BLOB[m.group(1)], h)
        note = ''
        m = re.search(r'<aside>(.*?)</aside>', h, re.S)
        if m:
            note = m.group(1).strip()
        h = h.replace('<section id="' + sid + '"', '<section id="sl-' + sid + '"', 1)
        out.append((sid, h, note))
    return out

def viewer(slides, ctx, notes=False, pdf=True):
    items = ''
    for n, (sid, h, note) in enumerate(slides, 1):
        h = h.replace('src="', 'loading="lazy" src="') if n > 2 else h
        nt = ('<p class="sp-note"><b>Ghi chú cho sale:</b> %s</p>' % note) if (notes and note) else ''
        items += '<div class="sp-it"><div class="sp-s" aria-label="Slide %d"><div class="sp-c">%s</div><span class="sp-n">%d/%d</span></div>%s</div>' % (n, h, n, len(slides), nt)
    bar = ('<div class="sp-bar"><button type="button" data-sp-play>▶ Trình chiếu toàn màn hình</button>'
           + ('<button type="button" class="alt" data-sp-pdf>⬇ Tải về (PDF)</button>' if pdf else '')
           + '<a href="#xem-4d" style="font-weight:700;font-size:15px;border-radius:999px;padding:11px 20px;background:#16406A;color:#F7F3EC;text-decoration:none">🧭 Xem 3D · 4D</a>'
           + '<small>%d slide · chạm vào slide để phóng to, vuốt để chuyển</small></div>' % len(slides))
    return CSS + '<div class="sp" id="sp" data-ctx="%s">%s<div class="sp-list">%s</div></div>' % (ctx, bar, items) + JS

def trinh_chieu(page, ORG, RES):
    slides = load()[:22]
    fixed = []
    for sid, h, note in slides:
        for a, b in KHACH_FIX:
            h = h.replace(a, b)
        fixed.append((sid, h, note))
    title = 'Sun Saphia Residence – Bài toán đầu tư căn hộ mặt biển (slide)'
    desc = 'Bộ slide Sun Saphia Residence: thị trường Đà Nẵng, quy hoạch 2050, giá tham khảo tầng 15, thanh toán 25%, bài toán cho thuê, bản đồ giá thuê khách sạn, so sánh khách sạn mini và villa.'
    b = ('<section class="sec" style="padding-top:28px"><div class="wrap" style="max-width:1240px">'
         '<span class="ey">Trình chiếu · 22 slide</span><h1 class="dp" style="margin:6px 0 10px">Sun Saphia – <b>bài toán đầu tư</b> căn hộ mặt biển</h1>'
         '<p class="lead" style="margin:0 0 18px">Thị trường, sản phẩm, giá tham khảo, dòng tiền cho thuê và so sánh với khách sạn, villa. Giá là giá tham khảo từ chủ đầu tư, bài toán là minh họa, không phải cam kết.</p></div>'
         + viewer(fixed, 'khach') + '</section>' + D4 +
         '<section class="sec" id="dang-ky"><div class="wrap" style="max-width:640px">'
         + form('tc', 'Trình chiếu – nhận bảng tính', title='Nhận bảng tính dòng tiền đúng căn anh/chị chọn',
                note='Bảng tính theo giá thật khi chủ đầu tư công bố, mặt bằng 3D và lịch sự kiện – gửi qua Zalo.', btn='Nhận qua Zalo')
         + '</div></section>')
    return page('/trinh-chieu', title, desc, 'slide sun saphia, bài toán đầu tư sun saphia, giá thuê khách sạn đà nẵng, so sánh khách sạn mini villa đà nẵng',
                b, [], '/trinh-chieu', tools=True).replace('</head>', FONTS + '\n</head>', 1)

GATE = '''<section class="sec" id="sp-gate" style="padding-top:40px"><div class="wrap" style="max-width:560px">
<span class="ey">Tài liệu nội bộ đội sale</span><h1 class="dp" style="margin:6px 0 10px">Đào tạo sale <b>Sun Saphia</b></h1>
<p class="lead">31 slide: thị trường, sản phẩm, bài toán dòng tiền, bản đồ giá thuê, 3 khách mẫu, xử lý từ chối, tin nhắn Zalo. Nhập số Zalo của bạn để xem và tải về.</p>
<style>.sp-gf label{display:block;font-size:13px;font-weight:700;color:#0E2A47;margin:10px 0 6px}.sp-gf input{width:100%;box-sizing:border-box;padding:14px 15px;font-size:16px;font-family:inherit;border:1.5px solid #d6dce5;border-radius:12px;background:#f8fafc}.sp-gf button{width:100%;margin-top:14px}</style><form class="sp-gf" id="sp-gf" style="margin-top:16px"><label for="sg-n">Họ và tên</label><input id="sg-n" name="name" type="text" autocomplete="name" placeholder="Tên của bạn" required>
<label for="sg-p">Số Zalo</label><input id="sg-p" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="09xx xxx xxx" required>
<p id="sg-e" style="color:#A33A12;font-size:14px;margin:8px 0 0;display:none">Số Zalo cần đủ 10 số, ví dụ 0904 567 009.</p>
<button class="btn" type="button" id="sg-b">Xem tài liệu</button></form></div></section>'''

GATE_JS = '''<script>(function(){
var K="sp_sale_ok",g=document.getElementById("sp-gate"),m=document.getElementById("sp-main"),f=document.getElementById("sp-gf");
function on(){g.style.display="none";m.style.display="";window.dispatchEvent(new Event("resize"))}
try{if(localStorage.getItem(K)){on();return}}catch(e){}
function go(){
var n=document.getElementById("sg-n").value.trim(),p=document.getElementById("sg-p").value.replace(/\\D/g,"");if(p.indexOf("84")===0)p="0"+p.slice(2);
if(!/^0\\d{9}$/.test(p)){document.getElementById("sg-e").style.display="block";return}
try{if(window.hhcLead)window.hhcLead({name:n,phone:p,interest:"ĐÀO TẠO SALE – mở tài liệu slide"})}catch(x){}
try{if(window.gtag)gtag("event","sale_training_open")}catch(x){}
try{localStorage.setItem(K,p)}catch(x){}on()}
document.getElementById("sg-b").addEventListener("click",go);f.addEventListener("keydown",function(e){if(e.key==="Enter"){e.preventDefault();go()}});f.addEventListener("submit",function(e){e.preventDefault()});
})();</script>'''

def dao_tao(head, header, tail, FAV, OG, LOGO):
    slides = load()
    title = 'Đào tạo sale Sun Saphia Residence'
    desc = 'Tài liệu nội bộ đội sale Sun Saphia Residence.'
    html = head(title, desc, MAIN + '/dao-tao-sale', OG, 'đào tạo sale', [], FAV, robots='noindex,nofollow,noarchive')
    html = html.replace('</head>', FONTS + '\n</head>', 1)
    html += ('<body>\n' + header('/dao-tao-sale', MAIN, LOGO, menu=False, cta='https://zalo.me/0904567009') + '\n<main id="dau-trang">' + GATE
             + '<section class="sec" id="sp-main" style="display:none;padding-top:28px"><div class="wrap" style="max-width:1240px"><span class="ey">Đào tạo sale · 31 slide</span>'
             '<h1 class="dp" style="margin:6px 0 16px">Sun Saphia – <b>tài liệu đào tạo</b></h1></div>'
             + viewer(slides, 'dao-tao', notes=True) + D4 + '</section></main>\n' + tail(True) + GATE_JS + '</body>\n</html>\n')
    return html.replace('>Nhận bảng giá</a></div></header>', '>Zalo anh Hiệp</a></div></header>')
