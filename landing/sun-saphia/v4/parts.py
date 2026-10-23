# Thành phần dùng chung cho bộ trang Sun Saphia Residence (giao diện Kick-off 23/10/2026)
import json, os, re

RAW = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/'
SK_HASH = 'cd20c0301cdcc17d5fbb47dd9797b6c2abb8c9be'
SK = RAW + SK_HASH + '/projects/sun-saphia/sk2310/'
SK_DIR = '/home/user/hoang-hiep-crm/projects/sun-saphia/sk2310/'
CERT = RAW + '0822bbe92e25ca0891b57c3d82a52bc4a2621c88/projects/sun-saphia/images/tatiland-dai-ly-chinh-thuc-sun-saphia.jpg'
D = '/home/user/hoang-hiep-crm/landing/sun-saphia/'
MAIN = 'https://www.sun-saphia-residence.com'
TEL = '0904567009'
TEL_S = '0904 567 009'
ZALO = 'https://zalo.me/0904567009'
UPDATED = '23/10/2026'
CC_SHA = 'b36d37dd422a487fd4545e37635fe9c3ecacdf55'
D4_SHA = 'df42c7854c3d33ad678fa9e08157fca320e02e5b'
SLOGAN = '<p class="slogan">Trước mặt là <b>Biển</b> · Sau lưng là <b>Sông</b> · Bên cạnh là <b>Núi</b></p>'

def esc(s):
    return s.replace('&', '&amp;').replace('"', '&quot;').replace('<', '&lt;')

def img(name, alt, cls='', eager=False, sizes='(max-width: 760px) 100vw, 900px'):
    """Ảnh từ bộ slide Kick-off; tự thêm bản 900px cho điện thoại nếu có."""
    from PIL import Image
    f = SK_DIR + name + '.webp'
    w, h = Image.open(f).size
    src = SK + name + '.webp'
    ss = ''
    if os.path.exists(SK_DIR + name + '-900.webp'):
        ss = ' srcset="%s-900.webp 900w, %s.webp %dw" sizes="%s"' % (SK + name, SK + name, w, sizes)
    ld = ' fetchpriority="high"' if eager else ' loading="lazy"'
    c = ' class="%s"' % cls if cls else ''
    return '<img%s src="%s"%s width="%d" height="%d" alt="%s"%s decoding="async">' % (c, src, ss, w, h, esc(alt), ld)

def fig(name, alt, cap='', cls='', wm=False, eager=False):
    k = 'fg' + (' wm' if wm else '') + (' ' + cls if cls else '')
    return '<figure class="%s">%s%s</figure>' % (k, img(name, alt, eager=eager), ('<figcaption>%s</figcaption>' % cap) if cap else '')

def sh(num, ey, title, ring='o'):
    """Đầu mục kiểu slide: vòng số + nhãn + tiêu đề hai màu (chữ trong <b> màu cam)."""
    return ('<div class="sh"><span class="ring r-%s" aria-hidden="true">%s</span><div><span class="ey">%s</span>'
            '<h2 class="dp">%s</h2></div></div>') % (ring, num, ey, title)

def form(fid, label, title='Nhận bảng giá Sun Saphia Residence',
         note='Bảng giá, mặt bằng tầng, chính sách – gửi qua Zalo ngay khi chủ đầu tư công bố.',
         btn='Nhận bảng giá qua Zalo', pick=True, h='h3'):
    sel = ''
    if pick:
        sel = ('<label for="lc-%s">Anh/chị quan tâm</label><select id="lc-%s" name="loai_can">'
               '<option value="">Chưa chọn</option><option>Studio 30 m²</option><option>1BR+ 50 m²</option>'
               '<option>2BR 60–70 m²</option><option>Căn góc / view đẹp nhất</option></select>') % (fid, fid)
    return ('<div class="fc"><%s class="fct">%s</%s><p class="fcn">%s</p>'
            '<form class="hm-form" data-form="%s">'
            '<label for="t-%s">Họ và tên</label><input id="t-%s" name="name" type="text" autocomplete="name" placeholder="Anh/chị tên gì ạ?">'
            '<label for="p-%s">Số điện thoại / Zalo</label><input id="p-%s" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="09xx xxx xxx" required>'
            '%s<p class="urg">⚡ Người đăng ký trước được ưu tiên chọn căn và nhận chính sách sớm nhất</p><button class="btn" type="submit">%s</button>'
            '<span class="alt">Hoặc <a href="%s" target="_blank" rel="noopener">nhắn Zalo</a> · <a href="tel:%s">gọi %s</a></span>'
            '</form><p class="fcs">✔ Không thu tiền giữ chỗ · ✔ Đại lý phân phối chính thức</p></div>') % (
        h, title, h, note, label, fid, fid, fid, fid, sel, btn, ZALO, TEL, TEL_S)

def faq(items):
    html = '<div class="faq">' + ''.join(
        '<details%s><summary>%s</summary><div class="fa">%s</div></details>' % (' open' if i == 0 else '', q, a)
        for i, (q, a) in enumerate(items)) + '</div>'
    ld = {'@type': 'FAQPage', 'mainEntity': [
        {'@type': 'Question', 'name': re.sub('<[^>]+>', '', q),
         'acceptedAnswer': {'@type': 'Answer', 'text': re.sub('<[^>]+>', '', a)}} for q, a in items]}
    return html, ld

def tiles(pos='tr'):
    return '<span class="tiles t-%s" aria-hidden="true"><img src="%stile-1.webp" alt="" width="201" height="201" loading="lazy"></span>' % (pos, SK)

PAGES = [('/', 'Tổng quan'), ('/bang-gia', 'Bảng giá'), ('/mat-bang', 'Mặt bằng'), ('/phap-ly', 'Pháp lý'), ('/cho-thue', 'Cho thuê')]

def header(cur, base, logo, cta='#dang-ky'):
    nav = ''.join('<a href="%s%s"%s>%s</a>' % (base, p if p != '/' else '/', ' aria-current="page"' if p == cur else '', t)
                  for p, t in PAGES)
    return ('<header class="top"><div class="wrap tb">'
            '<a class="lgc" href="%s/" aria-label="Sun Saphia Residence – trang chủ"><img src="%s" alt="" width="40" height="57"><span>SUN SAPHIA<i>RESIDENCE</i></span></a>'
            '<nav class="mnav" aria-label="Các trang dự án">%s</nav>'
            '<a class="tcta" href="%s">Nhận bảng giá</a></div></header>') % (base, logo, nav, cta)

def crumbs(items):
    """items: [(tên, url)] – mục cuối là trang hiện tại."""
    h = '<nav class="crumb" aria-label="Đường dẫn">' + ' › '.join(
        ('<a href="%s">%s</a>' % (u, n)) if i < len(items) - 1 else '<span>%s</span>' % n for i, (n, u) in enumerate(items)) + '</nav>'
    ld = {'@type': 'BreadcrumbList', 'itemListElement': [
        {'@type': 'ListItem', 'position': i + 1, 'name': n, 'item': u} for i, (n, u) in enumerate(items)]}
    return h, ld

def author():
    return ('<p class="by"><b>Hoàng Phạm Đình Hiệp</b> – Giám đốc kinh doanh TATILAND, đại lý phân phối chính thức · '
            'Cập nhật %s theo tài liệu Kick-off của chủ đầu tư</p>') % UPDATED

def footer(base):
    links = ' · '.join('<a href="%s%s">%s</a>' % (base, p, t) for p, t in PAGES)
    return ('<footer class="ft"><div class="wrap">'
            '<div class="fbr"><img src="' + RAW + '093918cb38d81f5e24fbe4d8477cea21e3de6ca8/landing/sun-saphia/v4/img/logo-mark.webp" alt="" width="34" height="48" loading="lazy">'
            '<div><b>SUN SAPHIA RESIDENCE</b><span>Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi</span></div>'
            '<a class="btn sm" href="#" data-pop data-interest="Chân trang">Nhận bảng giá gốc</a></div>'
            '<p class="fl">%s</p>'
            '<p>Trang thông tin dự án Sun Saphia Residence do <b>Hoàng Phạm Đình Hiệp</b> – Giám đốc kinh doanh TATILAND (Công ty CP Đầu tư Địa ốc TATI), '
            'đại lý phân phối chính thức dự án theo chứng nhận của Sun Property ngày 23/10/2026 – thực hiện. Đây không phải website của chủ đầu tư. '
            'Thông tin, hình ảnh tổng hợp từ tài liệu giới thiệu dự án và nguồn công khai, mang tính tham khảo; bảng giá, chính sách và thông tin chính thức '
            'theo công bố của Chủ đầu tư và Hợp đồng mua bán. Hình ảnh phối cảnh, tiện ích là minh họa.</p>'
            '<p>Liên hệ tư vấn: Hoàng Hiệp · Hotline/Zalo <a href="tel:%s">%s</a> · Email <a href="mailto:hiephoangmt@gmail.com">hiephoangmt@gmail.com</a></p>'
            '<p>Chính sách bảo mật: thông tin anh/chị gửi chỉ dùng để chuyên viên liên hệ tư vấn; không bán hay chia sẻ cho bên thứ ba; '
            'yêu cầu xóa dữ liệu qua Hotline/Zalo hoặc email trên (Nghị định 13/2023/NĐ-CP).</p></div></footer>'
            '<a class="pill" href="#dang-ky">📩 Nhận bảng giá ngay khi công bố</a>') % (links, TEL, TEL_S)

def daily():
    return ('<div class="daily" id="dai-ly"><img src="%s" width="900" height="1126" loading="lazy" decoding="async" '
            'alt="Chứng nhận TATILAND là đại lý phân phối chính thức dự án Sun Saphia Residence do Sun Property cấp ngày 23/10/2026">'
            '<div><span class="ey">Đại lý phân phối chính thức</span><h2 class="dp">TATILAND – <b>đại lý chính thức</b> Sun Saphia Residence</h2>'
            '<p>Công ty Cổ phần Đầu tư Địa ốc TATI (TATILAND) được Sun Property – thành viên Tập đoàn Sun Group – chứng nhận là đại lý phân phối chính thức '
            'dự án Sun Saphia Residence ngày 23/10/2026.</p><ul class="ck"><li>Bảng giá, chính sách bán hàng gốc từ chủ đầu tư</li>'
            '<li>Giữ chỗ, ký hợp đồng đúng quy trình chủ đầu tư</li><li>Tư vấn trực tiếp: Hoàng Phạm Đình Hiệp – Giám đốc kinh doanh</li></ul>'
            '<a class="btn sm" href="#dang-ky">Nhận bảng giá gốc từ đại lý chính thức</a></div></div>') % CERT

def tail(with_tools):
    """Phần script dùng chung lấy nguyên từ trang chủ đang chạy: CRM, nút liên hệ nhanh, chat, xử lý form, 4D + chọn căn."""
    s = open(D + 'chat/pages/trang-chu.html', encoding='utf8').read()
    a = s.index('<script src="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@afea225cd1c07439c244feaf9f6fa8e7bf42a111/projects/sun-saphia/crm/ss-all-nochat.js"')
    b = s.index('</body>')
    t = s[a:b]
    t = re.sub(r'hoang-hiep-crm@[0-9a-f]{40}/projects/sun-saphia/chon-can/chon-can-embed\.js', 'hoang-hiep-crm@' + CC_SHA + '/projects/sun-saphia/chon-can/chon-can-embed.js', t)
    t = re.sub(r'hoang-hiep-crm@[0-9a-f]{40}/projects/sun-saphia/4d/sun-saphia-4d-embed\.js', 'hoang-hiep-crm@' + D4_SHA + '/projects/sun-saphia/4d/sun-saphia-4d-embed.js', t)
    if not with_tools:
        x = t.index('<!-- 4D + CHỌN CĂN 3D -->'); y = t.index('<!-- /4D -->') + len('<!-- /4D -->')
        t = t[:x] + t[y:]
    return t

def anticopy():
    s = open(D + 'chat/pages/trang-chu.html', encoding='utf8').read()
    a = s.index('<style id="chong-copy">'); b = s.index('</script>', s.index('<script id="chong-copy-js">')) + 9
    return s[a:b]

def head(title, desc, canon, og_img, kw, ld_graph, favicon, robots='index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1', extra=''):
    ld = json.dumps({'@context': 'https://schema.org', '@graph': ld_graph}, ensure_ascii=False)
    return ('<!DOCTYPE html>\n<html lang="vi">\n<head>\n<meta charset="utf-8">\n'
            '<meta name="viewport" content="width=device-width, initial-scale=1">\n'
            '<meta name="ladipage-rules" content="v2">\n'
            '<title>%s</title>\n<meta name="description" content="%s">\n<meta name="keywords" content="%s">\n'
            '<meta name="robots" content="%s">\n<link rel="canonical" href="%s">\n'
            '<meta property="og:type" content="website">\n<meta property="og:url" content="%s">\n'
            '<meta property="og:title" content="%s">\n<meta property="og:description" content="%s">\n'
            '<meta property="og:image" content="%s">\n<meta property="og:image:width" content="1200">\n<meta property="og:image:height" content="630">\n'
            '<meta name="twitter:card" content="summary_large_image">\n<meta name="theme-color" content="#0B2447">\n'
            '<link rel="icon" type="image/png" href="%s">\n<link rel="apple-touch-icon" href="%s">\n'
            '<link rel="preconnect" href="https://fonts.googleapis.com">\n<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>\n'
            '<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&family=Fahkwang:wght@300;400;500&display=swap" rel="stylesheet">\n'
            '<script type="application/ld+json">%s</script>\n%s\n<style>%s</style>\n%s\n</head>\n') % (
        esc(title), esc(desc), esc(kw), robots, canon, canon, esc(title), esc(desc), og_img, favicon, favicon, ld,
        extra, open(os.path.join(os.path.dirname(__file__), 'brand.css'), encoding='utf8').read(), anticopy())

def tldr(title, items):
    """Ô tóm tắt đầu trang: câu trả lời ngắn, rõ để Google, Bing, ChatGPT trích dẫn."""
    return ('<section class="sec" style="padding:0 0 34px"><div class="wrap"><div class="tldr"><h2>Tóm tắt nhanh: %s</h2><dl>%s</dl>'
            '<p class="src" style="margin:10px 0 0">Cập nhật %s · Nguồn: tài liệu Kick-off của chủ đầu tư Sun Property · TATILAND – đại lý phân phối chính thức</p></div></div></section>') % (
        title, ''.join('<div><dt>%s</dt><dd>%s</dd></div>' % x for x in items), UPDATED)
