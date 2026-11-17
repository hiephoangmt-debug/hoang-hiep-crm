"""Tạo chon-can-embed.js từ chon-can.html: chèn công cụ "Chọn căn theo view" ngay sau mô hình 4D (#ss4d / #hm4d).
Dùng: python3 build-embed.py <sha mô hình 4D>"""
import json, pathlib, sys
here = pathlib.Path(__file__).parent
sha = sys.argv[1] if len(sys.argv) > 1 else 'main'
model = 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/%s/projects/sun-saphia/4d/sun-saphia-4d.html' % sha
import subprocess
# ảnh / video nội thất: dùng commit mới nhất có thay đổi thư mục images/noi-that (link cố định, không bị cache cũ)
ntsha = subprocess.run(['git', 'log', '-1', '--format=%H', '--', str(here.parent / 'images' / 'noi-that')], capture_output=True, text=True, cwd=here).stdout.strip() or 'main'
body = (here / 'chon-can.html').read_text(encoding='utf-8').replace('__MODEL__', model).replace('__NTSHA__', ntsha)
doc = ('<!doctype html><html lang="vi"><head><meta charset="utf-8">'
       '<meta name="viewport" content="width=device-width,initial-scale=1"><base target="_blank">' + body + '</html>')
js = r'''/* Sun Saphia – Chọn căn theo view (mặt bằng tầng theo tỷ lệ + 3D căn + nắng theo giờ). Sinh tự động bởi build-embed.py */
(function(){
  if (window.__sscc) return; window.__sscc = 1;
  var DOC = __DOC__;
  function anchor(){
    var a = document.getElementById('ss4d') || document.getElementById('hm4d');
    if (a) return a;
    var img = document.querySelector('img[src*="mat-bang-tang-dien-hinh"], img[src*="layout-can-ho"]');
    return img && (img.closest('.ladi-section') || img.closest('section') || img.parentNode);
  }
  function build(){
    var a = anchor(); if (!a) return false;
    var wrap = document.createElement('div'); wrap.id = 'sscc';
    wrap.style.cssText = 'position:relative;width:100%;background:#f7f4ee;padding:26px 0 20px;clear:both';
    wrap.innerHTML = '<div style="max-width:1180px;margin:0 auto;padding:0 12px;font-family:inherit">'
      + '<div style="color:#E8460F;font-size:12px;letter-spacing:.14em;font-weight:800;text-transform:uppercase">Chọn căn theo view</div>'
      + '<h2 style="color:#0A2540;font-size:24px;line-height:1.25;margin:6px 0 6px;font-weight:800">Bấm vào từng căn trên mặt bằng tầng: xem 3D, nắng theo giờ và view thật</h2>'
      + '<p style="color:#41505f;font-size:14px;line-height:1.5;margin:0 0 12px">Mặt bằng từng tầng 2 → 30 theo bản vẽ chủ đầu tư, có hệ cửa kính và ban công. Lọc căn hướng biển, sông Hàn, Sơn Trà hoặc đô thị.</p>'
      + '<div id="sscc-box" style="position:relative;width:100%;height:1080px;border-radius:14px;overflow:hidden;background:#fff;box-shadow:0 8px 24px rgba(10,37,64,.10)">'
      + '<button type="button" id="sscc-go" style="position:absolute;inset:0;margin:auto;width:230px;height:52px;border:0;border-radius:26px;background:#FF6A2B;color:#fff;font-weight:800;font-size:16px;cursor:pointer">▶ Mở công cụ chọn căn</button>'
      + '</div></div>';
    a.parentNode.insertBefore(wrap, a.nextSibling);
    var box = document.getElementById('sscc-box'), done = false;
    function fit(){ box.style.height = (window.innerWidth < 820 ? 2080 : 1060) + 'px'; }
    fit(); window.addEventListener('resize', fit);
    function load(){ if (done) return; done = true;
      var f = document.createElement('iframe'); f.title = 'Chọn căn Sun Saphia'; f.setAttribute('allow', 'fullscreen');
      f.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0'; f.srcdoc = DOC; box.innerHTML = ''; box.appendChild(f);
    }
    document.getElementById('sscc-go').onclick = load;
    if ('IntersectionObserver' in window) { var io = new IntersectionObserver(function(es){ if (es[0].isIntersecting){ io.disconnect(); load(); } }, { rootMargin: '200px' }); io.observe(box); }
    if (/#(sscc|chon-can)\b|[?&]xem=chon-can/i.test(location.hash + ' ' + location.search)) setTimeout(function(){ try { wrap.scrollIntoView({ behavior: 'smooth', block: 'start' }); } catch (e) {} load(); }, 600);
    return true;
  }
  // chờ mô hình 4D được chèn xong rồi đặt ngay sau
  var tries = 0; (function tick(){ if (build() || ++tries > 40) return; setTimeout(tick, 250); })();
})();
'''.replace('__DOC__', json.dumps(doc, ensure_ascii=False).replace('</', '<\\/'))
(here / 'chon-can-embed.js').write_text(js, encoding='utf-8')
# bản mở riêng (gửi khách / gắn CRM)
(here / 'chon-can-app.html').write_text(doc.replace('<base target="_blank">',''), encoding='utf-8')
print(len(js))
