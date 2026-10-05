import re,json,html,sys
sys.path.insert(0,'hd'); from kb import KB,CATS
U='https://www.sun-fours-tower.com'
t=open('lp-phap-ly.html').read()
def sub(old,new,cnt=1):
    global t; assert t.count(old)==cnt,(old[:80],t.count(old)); t=t.replace(old,new)
def plain(a): return html.unescape(re.sub(r'\s+',' ',re.sub('<[^>]+>','',a))).replace(' →','').replace(' ↗','').strip()
N=len(KB)
# ---------- HEAD ----------
head_old=t[t.index('<title>'):t.index('<meta name="twitter:card"')]
head_new=f'''<title>Hỏi đáp Sun FourS Tower – {N} câu về giá, vay, pháp lý, bàn giao</title>
<meta name="description" content="{N} câu hỏi khách hay hỏi về Sun FourS Tower Đà Nẵng: giá Tòa F2, chiết khấu 19%, vay 70% lãi suất 0%, sổ đỏ, bảo lãnh Techcombank, bàn giao 2028 – trả lời rõ ràng, có văn bản đi kèm.">
<meta name="keywords" content="hỏi đáp Sun FourS Tower, FourS Tower có nên mua, giá FourS Tower, pháp lý FourS Tower, vay mua FourS Tower, Tòa F2 FourS Tower, Căn hộ Sun Đà Nẵng">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<link rel="canonical" href="{U}/hoi-dap">
<meta name="theme-color" content="#13285a">
<meta property="og:type" content="article">
<meta property="og:locale" content="vi_VN">
<meta property="og:site_name" content="Sun FourS Tower Đà Nẵng">
<meta property="og:title" content="Hỏi đáp Sun FourS Tower – {N} câu khách hay hỏi">
<meta property="og:description" content="Giá, chiết khấu, vay 70%, pháp lý, bàn giao, đầu tư – mọi câu hỏi về Tòa F2 FourS Tower, trả lời rõ ràng.">
<meta property="og:url" content="{U}/hoi-dap">
<meta property="og:image" content="https://fourstower.netlify.app/img/sun-fours-tower-og.jpg">
'''
t=t.replace(head_old,head_new)
# JSON-LD
i=t.index('<script type="application/ld+json">'); j=t.index('</script>',i)+9
ld={"@context":"https://schema.org","@graph":[
 {"@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Sun FourS Tower","item":U+"/"},{"@type":"ListItem","position":2,"name":"Hỏi đáp","item":U+"/hoi-dap"}]},
 {"@type":"WebPage","@id":U+"/hoi-dap#webpage","url":U+"/hoi-dap","name":"Hỏi đáp Sun FourS Tower","inLanguage":"vi-VN","datePublished":"2026-10-05","dateModified":"2026-10-05","isPartOf":{"@id":U+"/#website"},"about":{"@id":U+"/#project"}},
 {"@type":"FAQPage","mainEntity":[{"@type":"Question","name":q,"acceptedAnswer":{"@type":"Answer","text":plain(a)}} for c,i_,q,a,k in KB]}]}
t=t[:i]+'<script type="application/ld+json">\n'+json.dumps(ld,ensure_ascii=False,indent=1)+'\n</script>'+t[j:]
# CSS
css='''
/* ===== Trang hỏi đáp ===== */
.hd-search{margin-top:26px;max-width:720px;position:relative}
.hd-search input{width:100%;padding:17px 22px 17px 52px;border-radius:999px;border:2px solid transparent;font:inherit;font-size:16.5px;color:var(--ink);background:#fff;box-shadow:0 14px 34px -14px rgba(0,0,0,.5)}
.hd-search input:focus{outline:none;border-color:var(--gold)}
.hd-search svg{position:absolute;left:19px;top:50%;transform:translateY(-50%);color:var(--gold-dark)}
.hd-hint{margin-top:12px;font-size:14px;opacity:.85}
.hd-hint button{background:none;border:1px solid rgba(255,255,255,.45);color:#fff;border-radius:999px;padding:4px 11px;margin:4px 4px 0 0;font:inherit;font-size:13.5px;cursor:pointer}
.hd-hint button:hover{border-color:var(--gold-light);color:var(--gold-light)}
.hd-cats{position:sticky;top:64px;z-index:20;background:#fff;border-bottom:1px solid var(--line)}
.hd-cats .container{display:flex;gap:8px;overflow-x:auto;padding-top:12px;padding-bottom:12px;scrollbar-width:none}
.hd-cats .container::-webkit-scrollbar{display:none}
.hd-cats a{flex:none;border:1.5px solid var(--line);border-radius:999px;padding:8px 14px;font-weight:600;font-size:14px;color:var(--green-800);white-space:nowrap}
.hd-cats a:hover,.hd-cats a.on{border-color:var(--gold);background:#fff3e8}
.hd-cats a small{color:var(--muted);font-weight:500;margin-left:4px}
.ph section.hd-sec{padding:44px 0 8px}
.hd-sec h2{font-family:var(--serif);font-size:clamp(24px,3vw,32px);color:var(--green-800);display:flex;align-items:center;gap:10px;max-width:860px;margin:0 auto}
.hd-sec .faq-list{margin-top:18px}
.faq.hd-sec{background:transparent}
.faq details .ans p{padding:0 0 10px}
.faq details .ans p b{color:var(--green-800)}
.faq details .ans a{color:var(--gold-dark);font-weight:600;text-decoration:underline;text-underline-offset:3px}
.ask-more{display:inline-flex;align-items:center;gap:6px;margin:0 0 18px;background:#fff3e8;border:1px solid #f6c79d;color:var(--gold-dark);border-radius:999px;padding:7px 13px;font:600 13.5px/1.2 var(--sans);cursor:pointer}
.ask-more:hover{background:#ffe6cf}
.faq details[hidden]{display:none}
.hd-sec[hidden]{display:none}
mark{background:#ffe1c2;color:inherit;border-radius:3px;padding:0 1px}
.hd-none{max-width:860px;margin:36px auto 0;background:var(--green-900);color:#fff;border-radius:16px;padding:22px;display:flex;gap:16px;align-items:center;justify-content:space-between;flex-wrap:wrap}
.hd-none[hidden]{display:none}
.hd-none b{display:block;font-size:17px}.hd-none span{opacity:.85;font-size:14.5px}
.hd-ask{max-width:860px;margin:44px auto 0;background:#fff;border:1px solid var(--line);border-radius:18px;padding:24px;display:flex;gap:18px;align-items:center;justify-content:space-between;flex-wrap:wrap;box-shadow:var(--shadow)}
.hd-ask b{display:block;color:var(--green-900);font-size:18px}.hd-ask span{color:var(--muted)}
@media (max-width:760px){.hd-cats{top:56px}.hd-none .btn,.hd-ask .btn{width:100%}}
'''
k=t.index('--green-900'); e=t.index('</style>',k); t=t[:e]+css+t[e:]
sub('<body data-subject="Khách hỏi pháp lý FourS Tower">','<body data-subject="Khách hỏi đáp FourS Tower">')
# ---------- MENU ----------
mi=t.index('<ul class="menu" id="menu">'); me=t.index('</ul>',mi)+5
t=t[:mi]+f'''<ul class="menu" id="menu">
      <li><a href="{U}/">Sun FourS Tower</a></li>
      <li><a href="{U}/toa-f2">Tòa F2</a></li>
      <li><a href="{U}/gio-hang">Giỏ hàng</a></li>
      <li><a href="{U}/bang-tinh-f2">Bảng tính</a></li>
      <li><a href="{U}/phap-ly">Pháp lý</a></li>
      <li><a href="#hd-gia">Giá</a></li>
      <li><a href="#hd-thanh-toan">Vay &amp; thanh toán</a></li>
    </ul>'''+t[me:]
sub('<a href="#dang-ky" class="btn btn-gold">Nhận hồ sơ pháp lý</a>','<a href="#dang-ky" class="btn btn-gold">Nhận tư vấn 1-1</a>')
# ---------- MAIN ----------
cnt={c:sum(1 for x in KB if x[0]==c) for c,_,_ in CATS}
chips=''.join(f'<a href="#hd-{c}">{ic} {nm}<small>{cnt[c]}</small></a>' for c,nm,ic in CATS)
secs=''
for c,nm,ic in CATS:
    rows=''.join(f'\n      <details id="{i_}"><summary>{html.escape(q)}</summary><div class="ans"><p>{a}</p><button type="button" class="ask-more" data-q="{html.escape(q)}">💬 Hỏi thêm trợ lý về câu này</button></div></details>' for cc,i_,q,a,k in KB if cc==c)
    secs+=f'''
<section class="faq hd-sec" id="hd-{c}" aria-labelledby="h-{c}">
  <div class="container">
    <h2 id="h-{c}"><span aria-hidden="true">{ic}</span>{nm}</h2>
    <div class="faq-list">{rows}
    </div>
  </div>
</section>
'''
hot=['Giá bao nhiêu?','Vay được bao nhiêu?','Có sổ đỏ không?','Khi nào nhận nhà?','Cách biển bao xa?']
main=f'''<main id="main" class="ph">
<section class="ph-hero" style="padding:120px 0 52px">
  <div class="container">
    <nav class="crumbs" aria-label="Breadcrumb"><ol><li><a href="{U}/">Sun FourS Tower</a></li><li aria-current="page">Hỏi đáp</li></ol></nav>
    <h1>Hỏi – đáp <span>Sun FourS Tower</span></h1>
    <p>{N} câu khách hay hỏi nhất về Tòa F2: giá, chiết khấu, vay 70%, pháp lý, bàn giao, đầu tư. Mỗi câu trả lời đều dựa trên văn bản và chính sách bán hàng CSBH 4.2. Chưa thấy câu mình cần, gõ vào ô dưới hoặc hỏi trợ lý – trả lời ngay.</p>
    <form class="hd-search" role="search" onsubmit="return false"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input id="hdQ" type="search" placeholder="Gõ câu hỏi, vd: vay bao nhiêu, sổ đỏ, cách biển…" aria-label="Tìm câu hỏi" autocomplete="off" enterkeyhint="search"></form>
    <p class="hd-hint">Hay hỏi: {''.join(f'<button type="button" data-hq="{h}">{h}</button>' for h in hot)}</p>
  </div>
</section>
<nav class="hd-cats" aria-label="Nhóm câu hỏi"><div class="container">{chips}</div></nav>
<div class="container"><div class="hd-none" id="hdNone" hidden><div><b>Chưa có sẵn câu này trong trang</b><span>Trợ lý trả lời ngay, hoặc chuyên viên kiểm tra và nhắn lại qua Zalo.</span></div><button type="button" class="btn btn-gold" id="hdAskNone">💬 Hỏi trợ lý ngay</button></div></div>
{secs}
<section class="hd-sec" style="padding-bottom:20px">
  <div class="container">
    <div class="hd-ask"><div><b>Còn thắc mắc chưa có ở đây?</b><span>Nhắn trợ lý – trả lời tự động 24/7, hoặc gọi trực tiếp 0904 567 009.</span></div><button type="button" class="btn btn-gold" data-ask="">💬 Hỏi trợ lý</button></div>
    <div class="related">
      <a href="{U}/toa-f2">Tòa F2 FourS Tower<span>Mặt bằng, giá, chính sách</span></a>
      <a href="{U}/gio-hang">Giỏ hàng căn còn trống<span>Lọc theo loại căn, giá, view</span></a>
      <a href="{U}/phap-ly">Hồ sơ pháp lý<span>Đủ điều kiện bán, sổ đỏ, bảo lãnh</span></a>
    </div>
  </div>
</section>
'''
a0=t.index('<main id="main" class="ph">'); a1=t.index('<section class="cta" id="dang-ky"')
t=t[:a0]+main+'\n'+t[a1:]
# CTA
sub('<span class="eyebrow">Minh bạch pháp lý</span>','<span class="eyebrow">Tư vấn 1-1</span>')
sub('<h2 class="title" id="h-cta">Nhận bộ hồ sơ pháp lý FourS Tower</h2>','<h2 class="title" id="h-cta">Muốn hỏi kỹ hơn cho đúng căn của mình?</h2>')
sub('''        <li>Văn bản đủ điều kiện bán của Sở Xây dựng</li>
        <li>Giấy chứng nhận quyền sử dụng đất 4 lô</li>
        <li>Hợp đồng mua bán mẫu &amp; cam kết bảo lãnh Techcombank</li>''','''        <li>Danh sách căn còn trống đúng tầm tài chính</li>
        <li>Bảng tính giá sau chiết khấu &amp; lịch vay theo ngày</li>
        <li>Bản scan văn bản pháp lý để tự đối chiếu</li>''')
sub('<h3 id="cta-form-title">Gửi hồ sơ pháp lý cho tôi</h3>','<h3 id="cta-form-title">Nhận tư vấn qua Zalo</h3>')
sub('<input type="hidden" name="yeu_cau" value="Hồ sơ pháp lý">','<input type="hidden" name="yeu_cau" value="Tư vấn từ trang Hỏi đáp">')
sub('<button class="btn btn-gold" type="submit">Nhận hồ sơ</button>','<button class="btn btn-gold" type="submit">Gửi cho tôi</button>')
sub('<a href="#dang-ky">Nhận hồ sơ</a>','<a href="#dang-ky">Nhận tư vấn</a>')
sub('<p>Chuyên viên sẽ gửi hồ sơ pháp lý FourS Tower cho Quý khách sớm nhất.</p>','<p>Chuyên viên sẽ liên hệ qua Zalo cho Quý khách sớm nhất.</p>')
sub('Thông tin tóm tắt từ hồ sơ pháp lý do chủ đầu tư công bố; văn bản gốc có giá trị pháp lý.','Thông tin tổng hợp từ hồ sơ pháp lý và chính sách bán hàng CSBH 4.2 do chủ đầu tư công bố; văn bản gốc và hợp đồng ký kết có giá trị pháp lý.')
sub('Cập nhật: 02/10/2026.','Cập nhật: 05/10/2026.')
# Script trang hỏi đáp (đặt trước khối chat)
js='''<script>
/* Trang hỏi đáp: tìm câu hỏi (gõ không dấu cũng được), mở câu theo link #, hỏi trợ lý */
(function () {
'use strict';
var fold = function (s) { return String(s).toLowerCase().normalize('NFD').replace(/[\\u0300-\\u036f]/g, '').replace(/đ/g, 'd'); };
var q = document.getElementById('hdQ'), none = document.getElementById('hdNone');
var items = [].slice.call(document.querySelectorAll('.hd-sec details'));
items.forEach(function (d) { d._t = ' ' + fold(d.textContent).replace(/[^a-z0-9%]+/g, ' ') + ' '; });
var timer, lastLogged = '';
function filter() {
  var v = fold(q.value).replace(/[^a-z0-9%]+/g, ' ').trim(), words = v.split(' ').filter(function (w) { return w.length > 1; }), shown = 0;
  // Ưu tiên khớp nguyên cụm (vd "so do"); không có thì khớp đủ từng chữ
  var phrase = words.length > 1 && items.some(function (d) { return d._t.indexOf(' ' + v + ' ') > -1; });
  items.forEach(function (d) {
    var ok = !words.length || (phrase ? d._t.indexOf(' ' + v + ' ') > -1 : words.every(function (w) { return d._t.indexOf(' ' + w) > -1; }));
    d.hidden = !ok; if (ok) shown++;
    d.open = !!(words.length && ok && shown <= 3);
  });
  [].forEach.call(document.querySelectorAll('.hd-sec[id^="hd-"]'), function (s) { s.hidden = !s.querySelector('details:not([hidden])'); });
  none.hidden = !(words.length && !shown);
  clearTimeout(timer);
  if (words.length && v !== lastLogged) timer = setTimeout(function () { lastLogged = v; try { if (window.gtag) gtag('event', 'search', {search_term: q.value}); } catch (e) {} }, 1500);
}
q.addEventListener('input', filter);
q.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); var f = document.querySelector('.hd-sec details:not([hidden])'); if (f) { f.open = true; f.scrollIntoView({behavior: 'smooth', block: 'center'}); } else if (window.sftAsk) window.sftAsk(q.value); } });
[].forEach.call(document.querySelectorAll('[data-hq]'), function (b) { b.addEventListener('click', function () { if (window.sftAsk) window.sftAsk(b.dataset.hq); }); });
document.getElementById('hdAskNone').addEventListener('click', function () { if (window.sftAsk) window.sftAsk(q.value); });
document.addEventListener('click', function (e) {
  var b = e.target.closest && e.target.closest('.ask-more, [data-ask]'); if (!b || !window.sftAsk) return;
  window.sftAsk(b.classList.contains('ask-more') ? b.dataset.q : '');
});
// Mở đúng câu khi vào bằng link #ma-cau (từ chat ở trang khác)
function openHash() { var d = location.hash && document.getElementById(location.hash.slice(1)); if (d && d.tagName === 'DETAILS') { d.open = true; setTimeout(function () { d.scrollIntoView({block: 'center'}); }, 60); } }
addEventListener('hashchange', openHash); openHash();
// Đánh dấu nhóm đang xem trên thanh nhóm câu hỏi
var chips = [].slice.call(document.querySelectorAll('.hd-cats a'));
addEventListener('scroll', function () {
  var cur = ''; [].forEach.call(document.querySelectorAll('.hd-sec[id^="hd-"]'), function (s) { if (s.getBoundingClientRect().top < 160) cur = s.id; });
  chips.forEach(function (a) { a.classList.toggle('on', a.getAttribute('href') === '#' + cur); });
}, {passive: true});
})();
</script>
'''
ci=t.index('<style>\n/* ===== Chat tư vấn')
t=t[:ci]+js+t[ci:]
# chat block mới
cc=open('chat-common.html').read()
ci=t.index('<style>\n/* ===== Chat tư vấn'); t=t[:ci]+cc.rstrip()+'\n'+t[t.index('</body>'):]
assert t.rstrip().endswith('</html>'), t[-200:]
open('lp-hoi-dap.html','w').write(t)
print('ok',len(t))
