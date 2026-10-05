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
css=open('hd/page.css').read()
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
exec(open('hd/page_main.py').read())
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
js=open('hd/page.js').read()
ci=t.index('<style>\n/* ===== Chat tư vấn')
t=t[:ci]+js+t[ci:]
# chat block mới
cc=open('chat-common.html').read()
ci=t.index('<style>\n/* ===== Chat tư vấn'); t=t[:ci]+cc.rstrip()+'\n'+t[t.index('</body>'):]
assert t.rstrip().endswith('</html>'), t[-200:]
open('lp-hoi-dap.html','w').write(t)
print('ok',len(t))
