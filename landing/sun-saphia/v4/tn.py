"""Trang thử /trai-nghiem: kể chuyện bằng cuộn trang kiểu điện ảnh (chữ lồng ảnh, hạ cánh từ trên cao,
toà tháp, dải tiện ích kéo ngang, chọn tầng → bấm căn). Giữ nguyên trang chủ; trang này chưa cho Google lập chỉ mục."""
from parts import RAW, form

I = RAW + '56fd71521ca2c6ebc408537433be5cf07e3e75d8/landing/sun-saphia/v4/img/'

AMEN = [('tv-pool-1', 'Hồ bơi tràn bờ', 'Tầng tiện ích nhìn thẳng ra biển Sơn Thủy'),
        ('tv-sanh-1', 'Sảnh đón', 'Sảnh cao, lễ tân đón khách như khách sạn'),
        ('tv-view-25', 'Phòng ngủ view biển', 'Mở rèm là thấy biển và bình minh'),
        ('tv-pool-3', 'Bể sục riêng tư', 'Góc thư giãn giữa cây xanh'),
        ('tv-gym-1', 'Phòng tập', 'Tập luyện mỗi sáng, nhìn ra phố biển')]

CSS = '''<style>
.tn{--tn-bg:#071423;--tn-ac:#FFAA01;background:var(--tn-bg);color:#fff}
.tn h2,.tn h3{color:#fff}
.tn-s{position:relative}
.tn-pin{position:sticky;top:0;height:100vh;height:100svh;overflow:hidden}
.tn-lbl{position:absolute;right:14px;bottom:14px;z-index:5;font-size:12px;background:rgba(0,0,0,.42);color:#fff;padding:3px 10px;border-radius:999px}
/* 1. chữ lồng ảnh */
#tn-1{height:260vh}
#tn-1 .tn-pin{display:flex;align-items:center;justify-content:center;background:#071423}
.tn-word{position:relative;z-index:2;font:900 clamp(64px,17vw,300px)/.86 "Be Vietnam Pro",system-ui,sans-serif;letter-spacing:-.04em;text-align:center;
  background:url(IMG/cover-saphia-hoang-hon.webp) center 40%/cover;-webkit-background-clip:text;background-clip:text;color:transparent;will-change:transform;transform-origin:50% 52%}
.tn-word small{display:block;font-size:.2em;letter-spacing:.5em;font-weight:700;margin-top:.35em}
.tn-full{position:absolute;inset:0;background:url(IMG/cover-saphia-hoang-hon.webp) center 40%/cover;opacity:0;z-index:1}
.tn-full:after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(7,20,35,.25),rgba(7,20,35,.05) 40%,rgba(7,20,35,.7))}
.tn-cap{position:absolute;left:0;right:0;bottom:12vh;z-index:3;text-align:center;padding:0 16px;opacity:0}
.tn-cap p{margin:0;font-size:clamp(17px,2.2vw,26px);font-weight:600;text-shadow:0 2px 18px rgba(0,0,0,.5)}
.tn-cap span{display:block;margin-top:8px;font-size:13px;letter-spacing:.3em;color:var(--tn-ac);font-weight:800}
.tn-hint{position:absolute;bottom:22px;left:50%;transform:translateX(-50%);z-index:3;font-size:12px;letter-spacing:.3em;opacity:.7;animation:tnb 1.8s ease-in-out infinite}
@keyframes tnb{50%{transform:translate(-50%,8px)}}
/* 2. hạ cánh từ trên cao */
#tn-2{height:280vh}
.tn-air{position:absolute;inset:-4%;background:url(IMG/phoi-canh-binh-minh.webp) center/cover;will-change:transform}
.tn-cl{position:absolute;inset:-20%;z-index:2;pointer-events:none;will-change:transform,opacity;
  background:radial-gradient(40% 30% at 30% 40%,rgba(255,255,255,.95),transparent 70%),radial-gradient(45% 35% at 72% 55%,rgba(255,255,255,.92),transparent 70%),radial-gradient(35% 25% at 50% 75%,rgba(255,255,255,.9),transparent 70%);filter:blur(18px)}
.tn-cl.b{background:radial-gradient(38% 28% at 65% 30%,rgba(255,255,255,.9),transparent 70%),radial-gradient(42% 30% at 25% 70%,rgba(255,255,255,.92),transparent 70%)}
.tn-st{position:absolute;left:6vw;bottom:14vh;z-index:3;max-width:560px;opacity:0;transform:translateY(30px)}
.tn-st b{display:block;font:800 clamp(30px,4.6vw,64px)/1.02 "Be Vietnam Pro",system-ui,sans-serif;text-shadow:0 4px 28px rgba(0,0,0,.45)}
.tn-st span{display:block;margin-top:10px;font-size:clamp(15px,1.5vw,19px);text-shadow:0 2px 12px rgba(0,0,0,.6)}
.tn-alt{position:absolute;right:6vw;top:50%;z-index:3;transform:translateY(-50%);text-align:right;font-weight:800;font-size:13px;letter-spacing:.2em}
.tn-alt b{display:block;font-size:clamp(40px,6vw,88px);letter-spacing:-.03em;color:#fff;text-shadow:0 4px 24px rgba(0,0,0,.4)}
/* 3. toà tháp */
#tn-3{height:230vh}
.tn-tw{position:absolute;inset:0;background:url(IMG/hero-tt02.webp) center 60%/cover;will-change:transform}
.tn-tw:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(7,20,35,.75),rgba(7,20,35,.1) 55%,rgba(7,20,35,.25))}
.tn-big{position:absolute;left:6vw;top:50%;z-index:3;transform:translateY(-50%);font:300 clamp(44px,8vw,128px)/.95 "Playfair Display",Georgia,serif;letter-spacing:.02em;text-transform:uppercase}
.tn-big span{display:block;will-change:transform,opacity}
.tn-big small{display:block;font:600 clamp(14px,1.4vw,18px)/1.5 "Be Vietnam Pro",system-ui,sans-serif;text-transform:none;letter-spacing:0;margin-top:22px;max-width:420px;opacity:.9}
.tn-big a{display:inline-block;margin-top:22px;font:800 15px/1 "Be Vietnam Pro",system-ui,sans-serif;letter-spacing:.08em;color:#071423;background:var(--tn-ac);padding:14px 22px;border-radius:999px;text-decoration:none}
/* 4. dải tiện ích kéo ngang */
#tn-4{height:320vh}
#tn-4 .tn-pin{display:flex;flex-direction:column;justify-content:center}
.tn-h{padding:0 6vw;margin-bottom:24px}
.tn-h span{color:var(--tn-ac);font-size:13px;letter-spacing:.3em;font-weight:800}
.tn-h h2{margin:6px 0 0;font:800 clamp(28px,4vw,52px)/1.05 "Be Vietnam Pro",system-ui,sans-serif}
.tn-rail{display:flex;gap:22px;padding:0 6vw;will-change:transform}
.tn-card{position:relative;flex:0 0 min(62vw,720px);aspect-ratio:3/2;border-radius:20px;overflow:hidden;margin:0}
.tn-card img{width:100%;height:100%;object-fit:cover;display:block;transform:scale(1.12);transition:transform 1.2s cubic-bezier(.16,1,.3,1)}
.tn-card.in img{transform:scale(1)}
.tn-card figcaption{position:absolute;left:0;right:0;bottom:0;padding:60px 22px 18px;background:linear-gradient(transparent,rgba(0,0,0,.72))}
.tn-card b{display:block;font-size:clamp(19px,2vw,26px)}
.tn-card span{font-size:14px;opacity:.9}
.tn-card i{position:absolute;top:12px;right:12px;font-style:normal;font-size:11px;background:rgba(0,0,0,.45);padding:3px 9px;border-radius:999px}
/* 5. chọn tầng */
#tn-5{padding:90px 0 70px;background:#f6f3ec;color:#0A2540}
#tn-5 .tn-h{padding:0;margin-bottom:8px}#tn-5 .tn-h h2{color:#0A2540}
#tn-2 .tn-pin:after{content:"";position:absolute;inset:auto 0 0 0;height:55%;z-index:2;background:linear-gradient(transparent,rgba(7,20,35,.6));pointer-events:none}
.pill,.wvb{display:none!important}
#tn-5 .tn-lv{font:900 clamp(56px,10vw,150px)/.9 "Be Vietnam Pro",system-ui,sans-serif;letter-spacing:-.04em;color:#0A2540;opacity:.07;margin:-10px 0 -20px;white-space:nowrap;pointer-events:none;user-select:none}
/* 6. đăng ký */
#tn-6{padding:80px 0;background:linear-gradient(160deg,#0B2447,#071423)}
#tn-6 .wrap{display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center}
#tn-6 h2{font:800 clamp(28px,3.6vw,46px)/1.1 "Be Vietnam Pro",system-ui,sans-serif;margin:8px 0 14px}
#tn-6 p{color:#cfdbea}
@media(max-width:760px){
  #tn-1{height:200vh}#tn-2{height:220vh}#tn-3{height:170vh}
  .tn-word{font-size:25vw}.tn-word small{font-size:.17em;letter-spacing:.28em;white-space:nowrap}#tn-5 .tn-lv{display:none}
  .tn-cap{bottom:16vh;padding:0 70px 0 16px}.tn-cap p{font-size:17px}
  .tn-st{left:16px;right:70px;bottom:14vh}.tn-alt{right:16px;top:22%}
  .tn-tw{background-position:52% 60%}.tn-tw:after{background:linear-gradient(180deg,rgba(7,20,35,.15),rgba(7,20,35,.75))}
  .tn-big{left:16px;right:70px;top:auto;bottom:12vh;transform:none}
  #tn-4{height:auto}#tn-4 .tn-pin{position:static;height:auto;padding:70px 0 40px}
  .tn-rail{overflow-x:auto;scroll-snap-type:x mandatory;padding:0 16px 10px;transform:none!important;-webkit-overflow-scrolling:touch;scrollbar-width:none}
  .tn-rail::-webkit-scrollbar{display:none}.tn-card{flex-basis:82vw;scroll-snap-align:center}.tn-h{padding:0 16px}
  #tn-6 .wrap{grid-template-columns:1fr}
}
@media(prefers-reduced-motion:reduce){
  #tn-1,#tn-2,#tn-3,#tn-4{height:auto}.tn-pin{position:relative;height:100svh}
  .tn-full,.tn-cap,.tn-st{opacity:1!important;transform:none!important}.tn-cl{display:none}.tn-word{display:none}
  #tn-4 .tn-pin{height:auto;padding:60px 0}.tn-rail{overflow-x:auto;transform:none!important}.tn-card img{transform:none}
}
</style>'''

JS = '''<script>(function(){
if(matchMedia("(prefers-reduced-motion:reduce)").matches)return;
var $=function(s){return document.querySelector(s)},M=innerWidth<=760;
function pr(el){var r=el.getBoundingClientRect(),h=el.offsetHeight-innerHeight;return h>0?Math.min(1,Math.max(0,-r.top/h)):0}
function seg(p,a,b){return Math.min(1,Math.max(0,(p-a)/(b-a)))}
function ease(t){return 1-Math.pow(1-t,3)}
var s1=$("#tn-1"),w=$(".tn-word"),full=$(".tn-full"),cap=$("#tn-1 .tn-cap"),hint=$(".tn-hint"),
s2=$("#tn-2"),air=$(".tn-air"),cl=document.querySelectorAll(".tn-cl"),st=document.querySelectorAll(".tn-st"),alt=$(".tn-alt b"),
s3=$("#tn-3"),tw=$(".tn-tw"),bl=document.querySelectorAll(".tn-big span"),
s4=$("#tn-4"),rail=$(".tn-rail"),cards=document.querySelectorAll(".tn-card"),tk=0;
function f(){tk=0;
 var p=pr(s1),z=ease(seg(p,0,.6));
 w.style.transform="scale("+(1+z*(M?3:4))+")";w.style.opacity=1-seg(p,.18,.45);
 full.style.opacity=seg(p,.12,.45);full.style.transform="scale("+(1.15-.15*seg(p,.35,1))+")";
 cap.style.opacity=seg(p,.72,.9);cap.style.transform="translateY("+(30-30*seg(p,.72,.9))+"px)";hint.style.opacity=.7-seg(p,0,.1);
 var q=pr(s2);air.style.transform="scale("+(1.55-.55*ease(seg(q,0,.8)))+")";
 cl[0].style.transform="translate("+(-q*60)+"%,"+(-q*10)+"%) scale("+(1+q)+")";cl[0].style.opacity=1-seg(q,.05,.45);
 cl[1].style.transform="translate("+(q*60)+"%,"+(q*12)+"%) scale("+(1+q)+")";cl[1].style.opacity=1-seg(q,.1,.5);
 var a=[[.3,.55],[.58,.8],[.82,1.01]];st.forEach(function(e,i){var v=seg(q,a[i][0],a[i][0]+.08)*(1-seg(q,a[i][1]-.06,a[i][1]));e.style.opacity=v;e.style.transform="translateY("+(30-30*v)+"px)"});
 alt.textContent=Math.round(150-120*ease(seg(q,0,.95)))+" m";
 var r=pr(s3);tw.style.transform="scale("+(1.18-.18*ease(seg(r,0,.7)))+") translateY("+(-r*3)+"%)";
 bl.forEach(function(e,i){var v=ease(seg(r,.1+i*.12,.35+i*.12));e.style.opacity=v;e.style.transform="translateX("+((i%2?1:-1)*(1-v)*80)+"px)"});
 if(!M&&rail){var t=pr(s4),mx=rail.scrollWidth-innerWidth;rail.style.transform="translateX("+(-t*Math.max(0,mx))+"px)"}
 cards.forEach(function(c){var b=c.getBoundingClientRect();if(b.left<innerWidth*.92&&b.right>0&&b.top<innerHeight)c.classList.add("in")})}
addEventListener("scroll",function(){if(!tk)tk=requestAnimationFrame(f)},{passive:true});addEventListener("resize",function(){M=innerWidth<=760;f()});
if(rail)rail.addEventListener("scroll",function(){if(!tk)tk=requestAnimationFrame(f)},{passive:true});f()})();</script>'''


def trai_nghiem(page, mb_tuongtac):
    cards = ''.join('<figure class="tn-card"><img src="%s%s-720.webp" srcset="%s%s-720.webp 720w, %s%s.webp 1600w" sizes="(max-width:760px) 82vw, 720px" width="1600" height="1066" loading="lazy" decoding="async" alt="%s – Sun Saphia Residence (phối cảnh minh họa)">'
                    '<i>Phối cảnh minh họa</i><figcaption><b>%s</b><span>%s</span></figcaption></figure>' % (I, k, I, k, I, k, t, t, d) for k, t, d in AMEN)
    body = ('<div class="tn">' + CSS.replace('IMG/', I) +
            # 1
            '<section class="tn-s" id="tn-1" aria-label="Sun Saphia Residence"><div class="tn-pin">'
            '<h1 class="tn-word" aria-label="Sun Saphia Residence Đà Nẵng">SUN<br>SAPHIA<small>RESIDENCE · ĐÀ NẴNG</small></h1>'
            '<div class="tn-full" role="img" aria-label="Phối cảnh Sun Saphia Residence lúc hoàng hôn bên biển Sơn Thủy"></div>'
            '<div class="tn-cap"><p>Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi</p><span>SUN GROUP · MẶT BIỂN SƠN THỦY</span></div>'
            '<span class="tn-lbl">Phối cảnh minh họa</span><div class="tn-hint">CUỘN XUỐNG ↓</div></div></section>'
            # 2
            '<section class="tn-s" id="tn-2" aria-label="Vị trí nhìn từ trên cao"><div class="tn-pin">'
            '<div class="tn-air" role="img" aria-label="Phối cảnh từ trên cao: toà tháp Sun Saphia bên bờ biển Sơn Thủy"></div><div class="tn-cl"></div><div class="tn-cl b"></div>'
            '<div class="tn-alt">ĐỘ CAO<b>150 m</b></div>'
            '<div class="tn-st"><b>Ngay mặt biển Sơn Thủy</b><span>Bãi tắm đẹp bậc nhất Đà Nẵng, giữa dải resort ven biển Ngũ Hành Sơn.</span></div>'
            '<div class="tn-st"><b>Một toà tháp · 30 tầng</b><span>782 căn hộ theo chủ đầu tư, phần lớn nhìn thẳng ra biển Đông.</span></div>'
            '<div class="tn-st"><b>Phía trước là công viên biển</b><span>Quy hoạch công viên – quảng trường biển đối diện, giữ tầm nhìn thoáng lâu dài.</span></div>'
            '<span class="tn-lbl">Phối cảnh minh họa</span></div></section>'
            # 3
            '<section class="tn-s" id="tn-3" aria-label="Khám phá căn hộ"><div class="tn-pin"><div class="tn-tw" role="img" aria-label="Toà tháp Sun Saphia Residence nhìn từ phía biển"></div>'
            '<h2 class="tn-big"><span>Khám phá</span><span>căn hộ</span><small>Studio, 1PN+1 và 2PN góc bo – chọn tầng, bấm từng căn để xem diện tích, hướng view và bố trí.</small>'
            '<a href="#tn-5">CHỌN TẦNG ↓</a></h2><span class="tn-lbl">Phối cảnh minh họa</span></div></section>'
            # 4
            '<section class="tn-s" id="tn-4" aria-label="Tiện ích"><div class="tn-pin"><div class="tn-h"><span>TIỆN ÍCH</span><h2>Sống như nghỉ dưỡng, mỗi ngày</h2></div>'
            '<div class="tn-rail">' + cards + '</div></div></section>'
            # 5
            '<section class="tn-s" id="tn-5"><div class="wrap"><div class="tn-lv" aria-hidden="true">TẦNG 3A–29</div>'
            '<div class="tn-h"><span>CHỌN TẦNG · CHỌN CĂN</span><h2>Bấm vào một căn để xem chi tiết</h2></div>'
            + mb_tuongtac('Web – trải nghiệm') + '</div></section>'
            # 6
            + '<section class="tn-s" id="tn-6"><div class="wrap"><div><span style="color:#FFAA01;font-size:13px;letter-spacing:.3em;font-weight:800">ĐĂNG KÝ</span>'
            '<h2>Nhận bảng giá và giỏ căn view biển</h2><p>Gửi qua Zalo ngay khi chủ đầu tư công bố: bảng giá, mặt bằng tầng, chính sách thanh toán đúng căn anh/chị chọn.</p></div>'
            + form('tn', 'Web – trang trải nghiệm', title='Nhận bảng giá qua Zalo', h='h3') + '</div></section>'
            '</div>' + JS)
    h = page('/trai-nghiem', 'Trải nghiệm Sun Saphia Residence Đà Nẵng – căn hộ mặt biển Sơn Thủy',
                'Khám phá Sun Saphia Residence bằng hình ảnh: toà tháp 30 tầng mặt biển Sơn Thủy, tiện ích nghỉ dưỡng, chọn tầng và bấm từng căn xem diện tích, hướng view.',
                'sun saphia residence, căn hộ mặt biển đà nẵng', body, [], '/')
    import re
    return re.sub(r'<meta name="robots" content="[^"]*">', '<meta name="robots" content="noindex,follow">', h, count=1)
