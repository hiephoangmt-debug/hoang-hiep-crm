"""Chuyển trang landing Sun Saphia v4 (landing/sun-saphia/v4/out/trang-chu.html, nhánh claude/zen-goldberg-vxb9dg)
thành trang dự án trên hiephoangmt.com: wordpress/wp-content/themes/hoanghiep/landing/sun-saphia-residence.html.

- Giữ nguyên bố cục, CSS, ảnh, form nhận khách, chat, 4D, chọn căn của landing.
- Bỏ: title/meta/canonical/schema/xác minh/gtag riêng của landing (web dùng SEO của WordPress), mục chứng nhận đại lý.
- Không ghi tên Tati: thay bằng "Hoàng Hiệp – tư vấn dự án".
- Link sang các trang con sun-saphia-residence.com: trỏ về bài cùng chủ đề trên hiephoangmt.com khi đã có.

Dùng: python3 landing-sun-saphia.py <trang-chu.html> <đầu ra .html>
      python3 landing-sun-saphia.py <quy-hoach.html> <sun-saphia-residence--quy-hoach.html> quy-hoach   (trang con)
Trang con: /du-an/sun-saphia-residence/<tên>/, tiêu đề + mô tả lấy từ trang gốc (dòng HH-LANDING-META, sửa lại sau khi viết lại chữ).
Sau đó: landing-loc-anh.py (bỏ ảnh không được đăng), landing-viet-lai.py (viết lại chữ), landing-kiem-tra.py.
"""
import re
import sys

src, out = sys.argv[1], sys.argv[2]
sub = sys.argv[3] if len(sys.argv) > 3 else ''
SUBS = ('quy-hoach', 'cho-thue', 'tinh-dong-tien', 'chinh-sach-bao-mat')
s = open(src, encoding='utf-8').read()

head = s[s.find('<head>') + 6:s.find('</head>')]
body = s[s.find('>', s.find('<body')) + 1:s.rfind('</body>')]

# Phần <head> giữ lại: font + CSS của landing.
keep = re.findall(r'<link[^>]+fonts\.(?:googleapis|gstatic)[^>]*>', head)
keep += re.findall(r'<style[^>]*>.*?</style>', head, flags=re.S)
head_out = '\n'.join(keep)


def cut_element(html, start):
    """Cắt phần tử bắt đầu tại vị trí start (thẻ div/section lồng nhau)."""
    tag = re.match(r'<(\w+)', html[start:]).group(1)
    depth, i = 0, start
    pat = re.compile(r'<(/?)%s\b[^>]*>' % tag)
    for m in pat.finditer(html, start):
        depth += -1 if m.group(1) else 1
        if depth == 0:
            return html[:start] + html[m.end():]
    return html


# Mục chứng nhận đại lý (ảnh giấy chứng nhận + giới thiệu đơn vị) – không đăng trên hiephoangmt.com.
i = body.find('id="dai-ly"')
if i >= 0:
    body = cut_element(body, body.rfind('<', 0, i))

# Script quảng cáo / đo lường riêng của landing (web có đo lường riêng).
body = re.sub(r'<script[^>]*googletagmanager[^>]*>\s*</script>', '', body)
body = re.sub(r'<script>\s*window\.dataLayer.*?</script>', '', body, flags=re.S)

rep = [
    ('– Giám đốc kinh doanh <b>TATILAND</b> (Công ty CP Đầu tư Địa ốc TATI), đại lý phân phối chính thức dự án theo chứng nhận của Sun Property ngày 23/10/2026', '– tư vấn bất động sản tại Đà Nẵng (hiephoangmt.com)'),
    ('– Giám đốc kinh doanh TATILAND (Công ty CP Đầu tư Địa ốc TATI), đại lý phân phối chính thức dự án theo chứng nhận của Sun Property ngày 23/10/2026', '– tư vấn bất động sản tại Đà Nẵng (hiephoangmt.com)'),
    ('<b>Hoàng Phạm Đình Hiệp</b> – Giám đốc kinh doanh TATILAND, đại lý phân phối chính thức · ', '<b>Hoàng Hiệp</b> – tư vấn dự án · Zalo 0904 567 009 · '),
    ('do <b>Hoàng Phạm Đình Hiệp</b> – Giám đốc kinh doanh TATILAND (Công ty CP Đầu tư Địa ốc TATI), đại lý phân phối chính thức dự án theo chứng nhận của Sun Property ngày 23/10/2026 – thực hiện', 'do <b>Hoàng Hiệp</b> (hiephoangmt.com) thực hiện'),
    (' · TATILAND – đại lý phân phối chính thức', ''),
    ('tài khoản TATILAND/chủ đầu tư', 'tài khoản công ty / chủ đầu tư'),
    ('TATILAND nhận đặt chỗ', 'Đặt chỗ'),
    ('Hoàng Phạm Đình Hiệp – Giám đốc kinh doanh', 'Hoàng Hiệp – Zalo 0904 567 009'),
    ('Hoàng Phạm Đình Hiệp', 'Hoàng Hiệp'),
    ('Đại lý phân phối chính thức TATILAND', 'Tư vấn Hoàng Hiệp'),
    ('Đại lý phân phối chính thức', 'Tư vấn Hoàng Hiệp'),
    ('đại lý phân phối chính thức', 'tư vấn dự án'),
]
for a, b in rep:
    body = body.replace(a, b)

# Trợ lý chat của landing: không nói "đại lý chính thức", link về trang của hiephoangmt.com, chữ chìm đổi tên miền.
for a, b in [
    ("t: 'Anh/Chị muốn mua đúng kênh chính thức ạ? Em giải thích:', q: ['Mua qua đại lý nào chính thức?', 'Booking bao nhiêu, có hoàn không?']",
     "t: 'Dạ anh/chị đặt chỗ và ký hợp đồng theo đúng quy trình của chủ đầu tư ạ; Hoàng Hiệp tư vấn chọn căn, tính dòng tiền và hỗ trợ hồ sơ từ đặt chỗ tới ký HĐMB. Anh/chị để lại số Zalo, em gửi quy trình chi tiết nhé.', q: ['Booking bao nhiêu, có hoàn không?', 'Khi nào có giá chính thức?']"),
    ('Bản vẽ và hồ sơ em để ở sun-saphia-residence.com', 'Thông tin chi tiết em tóm tắt ở sun-saphia-residence.com'),
    ('Sơ đồ hướng tuyến ở sun-saphia-residence.com', 'Chi tiết hướng tuyến ở sun-saphia-residence.com'),
    ('sun-saphia-residence.com/quy-hoach', 'hiephoangmt.com/du-an/sun-saphia-residence/quy-hoach'),
    ('%3Esun-saphia-residence.com · 0904 567 009%3C', '%3Ehiephoangmt.com · 0904 567 009%3C'),
]:
    body = body.replace(a, b)

links = {
    '': '/du-an/sun-saphia-residence/',
    'bang-gia': '/gia-sun-saphia-residence-bao-nhieu/',
    'mat-bang': '/mat-bang-can-ho-sun-saphia-residence/',
    'phap-ly': '/phap-ly-sun-saphia-residence-so-huu-bao-lau/',
    'vi-sao-sun-group': '/du-an-can-ho-sun-group-da-nang-2026/',
}
links.update({k: '/du-an/sun-saphia-residence/%s/' % k for k in SUBS})


def fix_link(m):
    path = m.group(1).strip('/').split('#')[0]
    return 'href="%s"' % links[path] if path in links else m.group(0)


# Đường dẫn đầu trang con: Trang chủ (hiephoangmt.com) › Sun Saphia Residence › …
body = body.replace('<a href="https://www.sun-saphia-residence.com/">Trang chủ</a> › <a href="https://www.sun-saphia-residence.com/">Sun Saphia Residence</a>', '<a href="/">Trang chủ</a> › <a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>')
body = re.sub(r'href="https://www\.sun-saphia-residence\.com/([^"]*)"', fix_link, body)

# Đường dẫn đầu trang: Trang chủ / Dự án của hiephoangmt.com.
body = body.replace('<nav class="crumb" aria-label="Đường dẫn"><a href="/du-an/sun-saphia-residence/">Trang chủ</a> › <span>Dự án Đà Nẵng</span>', '<nav class="crumb" aria-label="Đường dẫn"><a href="/">Trang chủ</a> › <a href="/du-an/">Dự án Đà Nẵng</a>')

left = [re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', ' ', body[max(0, m.start() - 80):m.end() + 60])) for m in re.finditer(r'(?i)\btati', body)]
if left:
    print('CÒN TÊN TATI – sửa danh sách thay thế:')
    for x in left:
        print(' -', x)
    sys.exit(1)

meta = ''
if sub:
    import json
    t = re.search(r'<title>(.*?)</title>', head, flags=re.S)
    d = re.search(r'<meta name="description" content="([^"]*)"', head)
    meta = '<!--HH-LANDING-META ' + json.dumps({'title': t.group(1).strip() if t else '', 'description': d.group(1) if d else '', 'url': '/du-an/sun-saphia-residence/%s/' % sub}, ensure_ascii=False) + ' -->\n'
open(out, 'w', encoding='utf-8').write(meta + '<!--HH-LANDING-HEAD-->\n' + head_out + '\n<!--HH-LANDING-BODY-->\n' + body)
print('OK', len(head_out), len(body))
