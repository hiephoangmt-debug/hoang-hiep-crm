"""Tạo sun-saphia-4d-embed.js từ sun-saphia-4d.html: chèn mô hình 4D vào trang LadiPage (iframe srcdoc, tải khi cuộn tới)."""
import json, pathlib
here = pathlib.Path(__file__).parent
body = (here / 'sun-saphia-4d.html').read_text(encoding='utf-8')
doc = ('<!doctype html><html lang="vi"><head><meta charset="utf-8">'
       '<meta name="viewport" content="width=device-width,initial-scale=1"><base target="_blank">'
       + body + '</html>')
js = r'''/* Sun Saphia 3D·4D·5D – chèn vào trang (dán loader trong "Trước </body>"). Sinh tự động bởi build-embed.py */
(function(){
  if (window.__ss4d) return; window.__ss4d = 1;
  var DOC = __DOC__;
  function anchor(){
    var img = document.querySelector('img[src*="ss-bien-hd"], [style*="ss-bien-hd"], img[src*="ss-thap-hd"]:not(.hero *)');
    var el = img && (img.closest('.ladi-section') || img.closest('section'));
    if (el) return el;
    var s = document.querySelectorAll('.ladi-section, section'); return s.length ? s[Math.min(3, s.length-1)] : null;
  }
  function build(){
    var a = anchor(); if (!a) return;
    var wrap = document.createElement('div'); wrap.id = 'ss4d';
    wrap.style.cssText = 'position:relative;width:100%;background:linear-gradient(160deg,#0B2447,#275286);padding:28px 0 22px;clear:both';
    wrap.innerHTML = '<div style="max-width:1140px;margin:0 auto;padding:0 16px;font-family:inherit">'
      + '<div style="color:#FFAA01;font-size:12px;letter-spacing:.14em;font-weight:700;text-transform:uppercase">Mô hình 3D · 4D · 5D minh họa</div>'
      + '<h2 style="color:#fff;font-family:Fahkwang,inherit;font-size:28px;line-height:1.25;margin:6px 0 6px;font-weight:300">Sun Saphia Residence: xoay 3D, xem nắng theo giờ (4D), đứng ở tầng nhìn ra biển (5D)</h2>'
      + '<p style="color:#c7d3e3;font-size:14px;line-height:1.5;margin:0 0 14px">Kéo để xoay · chọn “5D · View từ căn” rồi kéo để nhìn ra biển, Cù Lao Chàm, sông Hàn, sân bay. Mô hình dựng lại để minh họa, không phải bản vẽ của chủ đầu tư.</p>'
      + '<style>#ss4d-box{position:relative;width:100%;height:min(78vh,640px);min-height:440px;border-radius:14px;overflow:hidden;background:#1b2b44}'
      + '@media(max-width:760px){#ss4d-box{height:calc(100svh - 160px);min-height:500px}}'
      + '#ss4d-box.full{position:fixed;inset:0;width:100%;height:100%;min-height:0;border-radius:0;z-index:2147483600}'
      + '#ss4d-fs{display:inline-flex;align-items:center;gap:6px;margin:0 0 12px;border:1.5px solid rgba(255,255,255,.6);background:rgba(255,255,255,.1);color:#fff;font:700 14px/1 inherit;padding:10px 16px;border-radius:999px;cursor:pointer}'
      + '#ss4d-x{display:none;position:fixed;top:calc(10px + env(safe-area-inset-top,0px));right:10px;z-index:2147483601;border:0;background:#E96118;color:#fff;font:800 14px/1 inherit;padding:10px 14px;border-radius:999px;box-shadow:0 4px 14px rgba(0,0,0,.3);cursor:pointer}'
      + 'html.ss4d-on,html.ss4d-on body{overflow:hidden!important}html.ss4d-on #ss4d-x{display:block}</style>'
      + '<button type="button" id="ss4d-fs">⛶ Xem toàn màn hình</button><button type="button" id="ss4d-x">✕ Đóng</button>'
      + '<div id="ss4d-box">'
      + '<button type="button" id="ss4d-go" style="position:absolute;inset:0;margin:auto;width:220px;height:52px;border:0;border-radius:26px;background:#E96118;color:#fff;font-weight:800;font-size:16px;cursor:pointer">▶ Mở mô hình 3D · 4D · 5D</button>'
      + '</div></div>';
    a.parentNode.insertBefore(wrap, a.nextSibling);
    var box = document.getElementById('ss4d-box'), done = false;
    function load(){ if (done) return; done = true;
      var f = document.createElement('iframe'); f.title = 'Mô hình Sun Saphia'; f.setAttribute('allow', 'fullscreen');
      f.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0'; f.srcdoc = DOC.replace('<head>', '<head><script>window.SS4D_CFG=' + JSON.stringify({gate: +(window.SS4D_GATE || 0), ctx: location.pathname}) + '<\/script>'); box.innerHTML = ''; box.appendChild(f);
    }
    document.getElementById('ss4d-go').onclick = load;
    var root = document.documentElement;
    function full(on){ load(); box.classList.toggle('full', on); root.classList.toggle('ss4d-on', on); }
    window.ss4dFull = function(){ full(true); };
    document.getElementById('ss4d-fs').onclick = function(){ full(true); };
    document.getElementById('ss4d-x').onclick = function(){ full(false); try { wrap.scrollIntoView({ block: 'start' }); } catch (e) {} };
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && box.classList.contains('full')) full(false); });
    // link gửi khách: .../#ss4d (hoặc ?xem=4d) → cuộn thẳng tới mô hình và mở luôn
    if (/#(ss4d|hm4d|4d)\b|[?&]xem=4d/i.test(location.hash + ' ' + location.search)) setTimeout(function(){ try { wrap.scrollIntoView({ behavior: 'smooth', block: 'start' }); } catch (e) { wrap.scrollIntoView(); } load(); }, 400);
    if ('IntersectionObserver' in window) { var io = new IntersectionObserver(function(es){ if (es[0].isIntersecting){ io.disconnect(); load(); } }, { rootMargin: '200px' }); io.observe(box); }
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', build); else build();
})();
'''.replace('__DOC__', json.dumps(doc, ensure_ascii=False).replace('</', '<\\/'))
(here / 'sun-saphia-4d-embed.js').write_text(js, encoding='utf-8')
print(len(js))
