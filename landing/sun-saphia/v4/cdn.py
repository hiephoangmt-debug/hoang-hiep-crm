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
         '@media(max-width:700px){.evb{font-size:13.5px}.evb .q{display:none}.evb .w{padding:8px 40px 8px 12px;gap:6px 10px}}'
         '@media(prefers-reduced-motion:reduce){.evb button.go{animation:none}}</style>'
         '<div class="w"><span>🎁 <b>THƯ MỜI · 9:00 CN 15/11</b> · Sự kiện Sun Saphia tại <b>Sun Gallery Đà Nẵng</b> (01 Phan Đăng Lưu)</span>'
         '<span class="q">· Bốc thăm quà Sharp, Philips, Sony</span><span class="k" id="evk"></span>'
         '<button type="button" class="go" data-pop data-interest="Thư mời sự kiện 15/11 – Sun Gallery Đà Nẵng">Giữ thư mời</button></div>'
         '<button type="button" class="x" aria-label="Ẩn thông báo" onclick="this.parentNode.remove();try{sessionStorage.setItem(\'evx\',1)}catch(e){}">×</button>'
         '<script>(function(){var b=document.getElementById("evbar"),end=Date.parse("2026-11-15T11:00:00+07:00"),n=Date.now();'
         'try{if(sessionStorage.getItem("evx"))n=end}catch(e){}if(n>=end){b.remove();return}'
         'var d=Math.ceil((Date.parse("2026-11-15T00:00:00+07:00")-n)/864e5),k=document.getElementById("evk");'
         'k.textContent=d>1?"Còn "+d+" ngày":d===1?"Ngày mai":"Hôm nay"})();</script></div>')


def finish(h):
    for a, b in TEXT:
        h = h.replace(a, b)
    h = PAT.sub(lambda m: m.group(0) if _big(m.group(3), m.group(4)) else
                'https://cdn.jsdelivr.net/gh/%s/%s@%s/%s' % (m.group(1), m.group(2), m.group(3), m.group(4)), h)
    if 'id="evbar"' not in h and '</header>' in h:
        h = h.replace('</header>', '</header>' + EVBAR, 1)
    if 'jsd-fallback' not in h and '<meta charset="utf-8">' in h:
        h = h.replace('<meta charset="utf-8">', '<meta charset="utf-8">\n' + FB, 1)
    return h
