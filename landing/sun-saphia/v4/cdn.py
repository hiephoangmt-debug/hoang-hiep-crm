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


def finish(h):
    for a, b in TEXT:
        h = h.replace(a, b)
    h = PAT.sub(lambda m: m.group(0) if _big(m.group(3), m.group(4)) else
                'https://cdn.jsdelivr.net/gh/%s/%s@%s/%s' % (m.group(1), m.group(2), m.group(3), m.group(4)), h)
    if 'jsd-fallback' not in h and '<meta charset="utf-8">' in h:
        h = h.replace('<meta charset="utf-8">', '<meta charset="utf-8">\n' + FB, 1)
    return h
