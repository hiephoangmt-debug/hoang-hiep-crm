"""Tạo chon-can-embed.js từ chon-can.html: chèn công cụ "Chọn căn theo view" ngay sau mô hình 4D (#ss4d / #hm4d).
Dùng: python3 build-embed.py <sha mô hình 4D>"""
import json, pathlib, sys
here = pathlib.Path(__file__).parent
sha = sys.argv[1] if len(sys.argv) > 1 else 'main'
model = 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/%s/projects/sun-saphia/4d/sun-saphia-4d.html' % sha
body = (here / 'chon-can.html').read_text(encoding='utf-8').replace('__MODEL__', model)
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
      + '<div style="color:#E8460F;font-size:12px;letter-spacing:.14em;font-weight:800;text-transform:uppercase">Layout tầng 3A – 28</div>'
      + '<h2 style="color:#0A2540;font-size:26px;line-height:1.25;margin:6px 0 6px;font-weight:700">Chọn căn trên mặt bằng tầng 3A–28</h2>'
      + '<p style="color:#41505f;font-size:14px;line-height:1.5;margin:0 0 12px">Mặt bằng tầng điển hình 3A–28 vẽ theo tỷ lệ, có hệ cửa kính và ban công. Bấm vào căn để xem mặt bằng căn, phối cảnh 3D, nắng theo giờ và view; đăng ký ưu tiên căn ngay trong khung.</p>'
      + '<div id="sscc-box" style="position:relative;width:100%;height:1080px;border-radius:14px;overflow:hidden;background:#fff;box-shadow:0 8px 24px rgba(10,37,64,.10)">'
      + '<button type="button" id="sscc-go" style="position:absolute;inset:0;margin:auto;width:230px;height:52px;border:0;border-radius:26px;background:#FF6A2B;color:#fff;font-weight:800;font-size:16px;cursor:pointer">▶ Mở công cụ chọn căn</button>'
      + '</div></div>';
    a.parentNode.insertBefore(wrap, a.nextSibling);
    var box = document.getElementById('sscc-box'), done = false;
    box.style.height = (window.innerWidth < 820 ? 560 : 760) + 'px';
    window.addEventListener('message', function(e){ var d = e.data; if (!d || !d.sscc) return;
      if (d.sscc === 'h' && d.h > 200) box.style.height = Math.ceil(d.h) + 'px';
      if (d.sscc === 'open') { var off = 0; [].forEach.call(document.querySelectorAll('body *'), function(x){ if (x.closest('#sscc')) return; var cs = getComputedStyle(x); if (cs.position === 'fixed' || cs.position === 'sticky') { var r = x.getBoundingClientRect(); if (r.top < 200 && r.bottom > off && r.bottom < 280 && r.width > window.innerWidth * 0.6 && r.height > 20 && cs.display !== 'none' && cs.visibility !== 'hidden') off = r.bottom; } });
        var bt = box.getBoundingClientRect().top + window.pageYOffset, bh = box.offsetHeight, ih = window.innerHeight, S = window.pageYOffset, fr = box.querySelector('iframe');
        function win(S){ var t = Math.max(bt, S + off + 6), b2 = Math.min(bt + bh, S + ih - 6); return [t, b2]; }
        S = Math.max(0, bt - off - 6); var w = win(S); window.scrollTo({ top: S, behavior: 'smooth' });
        if (fr && fr.contentWindow) fr.contentWindow.postMessage({ sscc: 'vh', h: Math.max(300, w[1] - w[0]), top: w[0] - bt }, '*'); }
      if (d.sscc === 'lead') { var it = 'Web/ADS – chọn căn ' + d.unit + ' (' + d.type + ', tầng ' + d.floor + ')';
        var b = document.createElement('button'); b.type = 'button'; b.setAttribute('data-pop', ''); b.setAttribute('data-interest', (document.getElementById('leadPop') ? 'ADS' : 'Web') + ' – chọn căn ' + d.unit + ' (' + d.type + ', tầng ' + d.floor + ')');
        b.setAttribute('data-title', 'Đăng ký ưu tiên căn ' + d.unit); b.setAttribute('data-sub', 'Để lại số Zalo, chuyên viên báo giá và tình trạng căn này ngay khi chủ đầu tư công bố bảng hàng.'); b.setAttribute('data-btn', 'Giữ ưu tiên căn này →');
        if (document.getElementById('leadPop')) { b.style.display = 'none'; document.body.appendChild(b); b.click(); setTimeout(function(){ b.remove(); }, 100); }
        else { var sec = document.getElementById('dang-ky'), fm = sec && sec.querySelector('form[data-form]'); if (fm) { fm.setAttribute('data-form', b.getAttribute('data-interest')); sec.scrollIntoView({ behavior: 'smooth' }); var ph = fm.querySelector('input[type=tel]'); if (ph) setTimeout(function(){ ph.focus({ preventScroll: true }); }, 700); } }
      } });
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
