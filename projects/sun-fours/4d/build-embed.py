"""Tạo sun-fours-4d-embed.js từ sun-fours-4d.html: chèn mô hình 4D vào trang LadiPage (iframe srcdoc, tải khi cuộn tới)."""
import json, pathlib
here = pathlib.Path(__file__).parent
body = (here / 'sun-fours-4d.html').read_text(encoding='utf-8')
doc = ('<!doctype html><html lang="vi"><head><meta charset="utf-8">'
       '<meta name="viewport" content="width=device-width,initial-scale=1"><base target="_blank">'
       + body + '</html>')
js = r'''/* Sun FourS Tower 3D·4D·5D – chèn vào trang (dán loader trong "Trước </body>"). Sinh tự động bởi build-embed.py */
(function(){
  if (window.__sf4d) return; window.__sf4d = 1;
  var DOC = __DOC__;
  function anchor(){
    var el = document.getElementById('sf4d-anchor') || document.getElementById('qua-nha-xinh') || document.getElementById('uu-dai') || document.getElementById('deadline');
    el = el && (el.closest('.ladi-section') || el.closest('section') || el);
    if (el) return el;
    var s = document.querySelectorAll('.ladi-section, section'); return s.length ? s[Math.min(3, s.length-1)] : null;
  }
  function build(){
    var a = anchor(); if (!a) return;
    var wrap = document.createElement('div'); wrap.id = 'sf4d';
    wrap.style.cssText = 'position:relative;width:100%;background:#0f1d33;padding:28px 0 22px;clear:both';
    wrap.innerHTML = '<div style="max-width:1140px;margin:0 auto;padding:0 16px;font-family:inherit">'
      + '<div style="color:#ff7a3d;font-size:12px;letter-spacing:.14em;font-weight:700;text-transform:uppercase">Mô hình 3D · 4D · 5D minh họa</div>'
      + '<h2 style="color:#fff;font-size:24px;line-height:1.25;margin:6px 0 6px;font-weight:800">Sun FourS Tower: xoay 3D, xem nắng theo giờ (4D), đứng trong căn nhìn ra xung quanh (5D)</h2>'
      + '<p style="color:#c7d3e3;font-size:14px;line-height:1.5;margin:0 0 14px">Kéo để xoay · “Mặt bằng tầng” để bấm từng căn · “5D · View từ căn” rồi kéo để nhìn quanh. Minh họa, thông số theo CĐT.</p>'
      + '<div id="sf4d-box" style="position:relative;width:100%;height:min(78vh,640px);min-height:440px;border-radius:14px;overflow:hidden;background:#1b2b44">'
      + '<button type="button" id="sf4d-go" style="position:absolute;inset:0;margin:auto;width:220px;height:52px;border:0;border-radius:26px;background:#ff6a2b;color:#fff;font-weight:800;font-size:16px;cursor:pointer">▶ Mở mô hình 3D · 4D · 5D</button>'
      + '</div></div>';
    a.parentNode.insertBefore(wrap, a.nextSibling);
    var box = document.getElementById('sf4d-box'), done = false;
    function load(){ if (done) return; done = true;
      var f = document.createElement('iframe'); f.title = 'Mô hình Sun FourS Tower'; f.setAttribute('allow', 'fullscreen');
      f.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0'; f.srcdoc = DOC; box.innerHTML = ''; box.appendChild(f);
    }
    document.getElementById('sf4d-go').onclick = load;
    // link gửi khách: .../#ss4d (hoặc ?xem=4d) → cuộn thẳng tới mô hình và mở luôn
    if (/#(sf4d|fs4d|4d)\b|[?&]xem=4d/i.test(location.hash + ' ' + location.search)) setTimeout(function(){ try { wrap.scrollIntoView({ behavior: 'smooth', block: 'start' }); } catch (e) { wrap.scrollIntoView(); } load(); }, 400);
    if ('IntersectionObserver' in window) { var io = new IntersectionObserver(function(es){ if (es[0].isIntersecting){ io.disconnect(); load(); } }, { rootMargin: '200px' }); io.observe(box); }
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', build); else build();
})();
'''.replace('__DOC__', json.dumps(doc, ensure_ascii=False).replace('</', '<\\/'))
(here / 'sun-fours-4d-embed.js').write_text(js, encoding='utf-8')
print(len(js))
