"""Xử lý cuối cho mọi trang khi build:
- Câu chữ đúng chính sách quảng cáo (không hứa tăng giá, không "sổ hồng lâu dài").
- Ảnh/video từ GitHub raw → jsDelivr (nhanh hơn), giữ nguyên commit; file > 20 MB giữ link raw.
- Đoạn dự phòng: ảnh jsDelivr nào lỗi thì tự lấy lại từ GitHub raw.
Không đụng link .js."""
import re, subprocess, os

TEXT = [
    ("<li>Sổ hồng lâu dài 50 năm</li>", "<li>Sở hữu 50 năm · pháp lý rõ ràng</li>"),
    ("<li><b>3 căn view biển đẹp nhất</b> còn trống</li>", "<li><b>Danh sách căn view biển</b> còn trống theo tầng</li>"),
    ("bảng giá gốc + 3 căn view biển đẹp nhất", "bảng giá gốc + danh sách căn view biển"),
    ("bảng giá gốc và 3 căn view biển đẹp nhất", "bảng giá gốc và danh sách căn view biển"),
    ("Người vào sớm hưởng trọn phần tăng này.", "Hạ tầng hoàn thiện dần là yếu tố hỗ trợ giá trị khu vực; diễn biến giá không được bảo đảm."),
]

PAT = re.compile(r'https://raw\.githubusercontent\.com/([^/\s"\']+)/([^/\s"\']+)/([0-9a-f]{7,40})/([^\s"\'()<>\\?#]+?\.(?:webp|png|jpg|jpeg|gif|svg|mp4))', re.I)

FB = ('<script>/*jsd-fallback: ảnh jsDelivr lỗi thì tự lấy lại từ GitHub*/(function(){var J="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@",'
      'R="https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/";function f(v){return v&&v.indexOf(J)>-1?v.split(J).join(R):v}'
      'function fix(el){var c=0;["src","srcset","poster"].forEach(function(a){var v=el.getAttribute&&el.getAttribute(a),w=f(v);if(w!==v){el.setAttribute(a,w);c=1}});return c}'
      'document.addEventListener("error",function(e){var t=e.target;if(!t||!t.tagName)return;var c=fix(t),p=t.parentNode;'
      'if(p&&(p.tagName==="PICTURE"||p.tagName==="VIDEO")){[].forEach.call(p.querySelectorAll("source,img"),function(s){if(fix(s))c=1});if(c&&p.load)p.load()}},true);'
      'var pr=new Image();pr.onerror=function(){function all(){[].forEach.call(document.querySelectorAll("[style*=\'cdn.jsdelivr.net/gh/\']"),function(el){el.setAttribute("style",f(el.getAttribute("style")))});'
      '[].forEach.call(document.querySelectorAll("style"),function(s){if(s.textContent.indexOf(J)>-1)s.textContent=f(s.textContent)});[].forEach.call(document.querySelectorAll("video[poster]"),fix)}'
      'if(document.readyState==="loading")document.addEventListener("DOMContentLoaded",all);else all()};'
      'pr.src=J+"70e1c77ea2547183b73cf92800ebaf33218a083b/landing/sun-saphia/v4/img/logo-mark.webp"})();</script>')

_ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..', '..'))
_size = {}


def _big(sha, path):
    k = (sha, path)
    if k not in _size:
        r = subprocess.run(['git', '-C', _ROOT, 'cat-file', '-s', sha + ':' + path], capture_output=True, text=True)
        _size[k] = int(r.stdout.strip() or 0)
    return _size[k] > 20 * 1024 * 1024


EVBAR = ('<div id="evbar" class="evb" role="region" aria-label="Thư mời sự kiện"><style>'
         '#evbar{position:relative!important;inset:auto!important;top:auto!important;left:auto!important;right:auto!important;bottom:auto!important;width:auto!important;z-index:40!important;display:block!important;transform:none!important;border-radius:0!important;margin:0!important;box-shadow:none!important;background:linear-gradient(90deg,#c2410c,#ea580c 55%,#f59e0b)!important;color:#fff!important}'
         '.evb{background:linear-gradient(90deg,#c2410c,#f26b1d 55%,#f59e0b);color:#fff;font-size:14.5px;line-height:1.35}'
         '.evb .w{max-width:1180px;margin:0 auto;padding:9px 46px 9px 16px;display:flex;align-items:center;justify-content:center;gap:10px 16px;flex-wrap:wrap;text-align:center}'
         '.evb b{font-weight:800;letter-spacing:.2px}.evb .q{opacity:.95}.evb .k{background:rgba(0,0,0,.22);border-radius:999px;padding:2px 10px;font-weight:700;font-size:13px}'
         '.evb button.go{background:#fff;color:#c2410c;border:0;border-radius:999px;padding:7px 16px;font-weight:800;font-size:14px;cursor:pointer;font-family:inherit;animation:evp 1.8s infinite}'
         '@keyframes evp{0%,100%{box-shadow:0 0 0 0 rgba(255,255,255,.7)}60%{box-shadow:0 0 0 9px rgba(255,255,255,0)}}'
         '.evb .x{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:0;color:#fff;font-size:22px;line-height:1;cursor:pointer;padding:4px 8px}'
         '.evb i{font-style:normal}.evb .m{display:none}'
         '@media(max-width:700px){.evb{font-size:13px}.evb .q,.evb .l{display:none}.evb .m{display:inline}.evb .t{flex:1 1 100%}.evb .w{padding:7px 36px 8px 10px;gap:5px 8px}.evb .k{font-size:12px;padding:2px 8px}.evb button.go{padding:6px 14px;font-size:13px}}'
         '@media(prefers-reduced-motion:reduce){.evb button.go{animation:none}}</style>'
         '<div class="w"><span class="t">🎁 <b>THƯ MỜI · 9:00 CN 15/11</b><i class="l"> · Sự kiện Sun Saphia tại</i><i class="m"> ·</i> <b>Sun Gallery Đà Nẵng</b><i class="l"> (01 Phan Đăng Lưu)</i></span>'
         '<span class="q">· Bốc thăm quà Sharp, Philips, Sony</span><span class="k" id="evk"></span>'
         '<button type="button" class="go" data-evreg data-interest="Dải thư mời – đăng ký thư mời sự kiện 15/11 Sun Gallery Đà Nẵng" data-ev-t="Chất sống tinh hoa – Giao hòa nắng biển" data-ev-d="9:00 CN 15/11 · Đà Nẵng" data-ev-n="Sun Gallery Da Nang · 01 Phan Đăng Lưu, Hoà Cường">Giữ thư mời</button></div>'
         '<button type="button" class="x" aria-label="Ẩn thông báo" onclick="this.parentNode.remove();try{sessionStorage.setItem(\'evx\',1)}catch(e){}">×</button>'
         '<script>(function(){var b=document.getElementById("evbar"),end=Date.parse("2026-11-15T11:00:00+07:00"),n=Date.now();'
         'try{if(sessionStorage.getItem("evx"))n=end}catch(e){}if(n>=end){b.remove();return}'
         'var d=Math.ceil((Date.parse("2026-11-15T00:00:00+07:00")-n)/864e5),k=document.getElementById("evk");'
         'k.textContent=d>1?"Còn "+d+" ngày":d===1?"Ngày mai":"Hôm nay"})();</script></div>')


X360_SHA = 'c6587432e3bc13fd47d9eeefc9c1c50e57d24401'
X360 = ('<section class="sec" id="xem-360" style="background:linear-gradient(160deg,#0B2447,#1d4a7a);color:#fff"><div class="wrap">'
        '<style>#xem-360 .x3{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:26px;align-items:center}'
        '#xem-360 .x3p{position:relative;display:block;width:100%;border:0;padding:0;border-radius:16px;overflow:hidden;cursor:pointer;background:#123;box-shadow:0 18px 40px -18px rgba(0,0,0,.6);aspect-ratio:16/9}'
        '#xem-360 .x3p img{width:100%;height:100%;object-fit:cover;display:block}'
        '#xem-360 .x3p b{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);background:#E96118;color:#fff;font-weight:800;font-size:17px;padding:14px 22px;border-radius:999px;box-shadow:0 8px 24px rgba(0,0,0,.35);white-space:nowrap}'
        '#xem-360 .x3p i{position:absolute;left:12px;bottom:10px;font-style:normal;font-size:12px;background:rgba(0,0,0,.45);padding:3px 9px;border-radius:999px}'
        '#xem-360 .ey{color:#FFAA01}#xem-360 h2{color:#fff;margin:6px 0 10px}#xem-360 p,#xem-360 li{color:#d6e2f0;text-align:left!important}#xem-360 ul{margin:0 0 16px;padding-left:18px;line-height:1.7}'
        '#xem-360 .x3b{border:0;border-radius:999px;background:#E96118;color:#fff;font:800 16px/1 inherit;padding:14px 22px;cursor:pointer}'
        '@media(max-width:820px){#xem-360 .x3{grid-template-columns:1fr}#xem-360 .x3p b{font-size:15px;padding:12px 18px}}'
        '#x360{position:fixed;inset:0;z-index:2147483600;background:#0b1220}#x360[hidden]{display:none}#x360 iframe{position:absolute;inset:0;width:100%;height:100%;border:0}'
        '#x360 .xx{position:absolute;top:calc(10px + env(safe-area-inset-top,0px));right:10px;z-index:2;border:0;background:#E96118;color:#fff;font:800 14px/1 inherit;padding:10px 14px;border-radius:999px;box-shadow:0 4px 14px rgba(0,0,0,.3);cursor:pointer}'
        '#x360 .xl{position:absolute;inset:0;display:grid;place-items:center;color:#c7d3e3;font-size:14px}html.x360-on,html.x360-on body{overflow:hidden!important}</style>'
        '<div class="x3"><button type="button" class="x3p" data-x360 aria-label="Mở xem 360° khu đất Sun Saphia">'
        '<img loading="lazy" alt="Ảnh flycam thực tế khu đất Sun Saphia Residence trên trục biển Võ Nguyên Giáp – Trường Sa" src="https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/' + X360_SHA + '/projects/sun-saphia/360/xem-360-poster.webp">'
        '<b>🛸 Xoay 360° khu đất</b><i>Ảnh flycam thực tế · 21/10/2026</i></button>'
        '<div><span class="ey">360° khu đất thực tế</span><h2 class="dp">Đứng giữa khu đất, <b>nhìn trọn 360°</b></h2>'
        '<ul><li>Flycam thực tế ở độ cao 150 m và 120 m, kéo để xoay mọi hướng</li><li>Nhãn địa danh kèm khoảng cách: biển Sơn Thủy, Ngũ Hành Sơn, cầu Rồng, sân bay, Sơn Trà, Hội An</li>'
        '<li>Bật quy hoạch công viên phía trước, đặt mặt bằng tầng lên khu đất</li><li>Mặt bằng tầng, layout căn và layout căn 3D xem ngay trong khung</li></ul>'
        '<button type="button" class="x3b" data-x360>▶ Mở 360° khu đất</button></div></div></div>'
        '<div id="x360" hidden role="dialog" aria-label="360° khu đất Sun Saphia"><div class="xl">Đang tải ảnh 360°…</div><button type="button" class="xx">✕ Đóng</button></div>'
        '<script>(function(){var P="hiephoangmt-debug/hoang-hiep-crm",S="' + X360_SHA + '",D="/projects/sun-saphia/360/",'
        'B=["https://cdn.jsdelivr.net/gh/"+P+"@"+S+D,"https://raw.githubusercontent.com/"+P+"/"+S+D],M=document.getElementById("x360"),f=null,R=document.documentElement;'
        'function get(i){return fetch(B[i]+"xem-360.html").then(function(r){if(!r.ok)throw 0;return r.text()}).then(function(t){return [B[i],t]})}'
        'function load(){if(f)return;f=document.createElement("iframe");f.title="360° khu đất Sun Saphia";f.setAttribute("allow","fullscreen;gyroscope;accelerometer");'
        'get(0).catch(function(){return get(1)}).then(function(a){f.srcdoc="<!doctype html><html lang=\\"vi\\"><head><meta charset=\\"utf-8\\"><meta name=\\"viewport\\" content=\\"width=device-width,initial-scale=1,viewport-fit=cover\\"><base href=\\""+a[0]+"\\"><style>[hidden]{display:none!important}</style></head><body>"+a[1]+"</body></html>";M.appendChild(f)})'
        '.catch(function(){M.querySelector(".xl").textContent="Chưa tải được 360°, anh/chị thử lại sau ít phút."})}'
        'function op(){load();M.hidden=false;R.classList.add("x360-on");try{if(window.gtag)gtag("event","xem_360_open")}catch(e){}}'
        'function cl(){M.hidden=true;R.classList.remove("x360-on")}'
        'document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest("[data-x360]");if(b){e.preventDefault();op()}});'
        'M.querySelector(".xx").onclick=cl;document.addEventListener("keydown",function(e){if(e.key==="Escape"&&!M.hidden)cl()});'
        'if(/#xem-360\\b|[?&]xem=360/.test(location.hash+" "+location.search))setTimeout(op,500)})();</script></section>')


def _x360(h):
    """chèn khối 360° sau mục Vị trí (hoặc trước mục Công viên ở trang Quy hoạch)"""
    if 'id="xem-360"' in h:
        return h
    i = h.find('id="vi-tri"')
    if i > -1:
        j = h.find('</section>', i)
        if j > -1:
            return h[:j + 10] + X360 + h[j + 10:]
    i = h.find('<section class="sec alt" id="cong-vien"')
    if i > -1:
        return h[:i] + X360 + h[i:]
    return h


_EVREG = {}


def _evreg(h):
    """lấy khối popup thư mời (modal #evReg + script) từ trang có mục sự kiện"""
    if 'v' not in _EVREG and '<div id="evReg"' in h:
        a = h.index('<div id="evReg"')
        i = h.index('e.target.closest("[data-evreg]")', a)
        _EVREG['v'] = h[a:h.index('</script>', i) + 9]
    return _EVREG.get('v')


def finish(h):
    for a, b in TEXT:
        h = h.replace(a, b)
    h = PAT.sub(lambda m: m.group(0) if _big(m.group(3), m.group(4)) else
                'https://cdn.jsdelivr.net/gh/%s/%s@%s/%s' % (m.group(1), m.group(2), m.group(3), m.group(4)), h)
    if 'id="evbar"' not in h and '</header>' in h:
        h = h.replace('</header>', '</header>' + EVBAR, 1)
    if '</header>' in h and 'dao-tao' not in h[:3000] and 'trinh-chieu' not in h[:3000]:
        h = _x360(h)
    m = _evreg(h)
    if m and 'id="evReg"' not in h and 'id="evbar"' in h and '</body>' in h:
        h = h.replace('</body>', m + '</body>', 1)    # trang con: thêm popup thư mời cho nút "Giữ thư mời"
    if 'jsd-fallback' not in h and '<meta charset="utf-8">' in h:
        h = h.replace('<meta charset="utf-8">', '<meta charset="utf-8">\n' + FB, 1)
    return h
