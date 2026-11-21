"""Dựng 10 bài "Nhập môn Sale BĐS" từ bai-src/<slug>.html thành trang tĩnh trong bai/.

Khung (CSS, thanh menu, dự án đang bán, footer, widget liên hệ) lấy từ bài mẫu
lo-trinh-sale-moi-60-ngay-dau.html để mọi bài giống nhau.
Chạy: python3 tools/build_bai_moi.py [slug ...]   (không truyền slug = dựng tất cả)
"""
import html, json, os, re, sys, datetime

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
S = 'https://www.tuyendungsaledanang.com'
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
TODAY = '2026-11-22'
TODAY_VN = '22/11/2026'

ORDER = [
    ('sale-bat-dong-san-la-gi', 'Sale bất động sản là gì'),
    ('luong-sale-bat-dong-san', 'Sale bất động sản lương bao nhiêu'),
    ('hoa-hong-moi-gioi-bat-dong-san', 'Hoa hồng môi giới bất động sản'),
    ('co-nen-lam-sale-bat-dong-san', 'Có nên làm sale bất động sản'),
    ('chung-chi-moi-gioi-bat-dong-san', 'Chứng chỉ môi giới bất động sản'),
    ('thuat-ngu-bat-dong-san', 'Thuật ngữ bất động sản'),
    ('cach-tim-khach-hang-bat-dong-san', 'Cách tìm khách hàng bất động sản'),
    ('kich-ban-telesale-bat-dong-san', 'Kịch bản telesale bất động sản'),
    ('ky-nang-chot-sale-bat-dong-san', 'Kỹ năng chốt sale bất động sản'),
    ('can-ho-hinh-thanh-trong-tuong-lai', 'Căn hộ hình thành trong tương lai'),
]
# Ảnh thật minh hoạ đúng nội dung từng bài (chèn sau hộp Trả lời nhanh). Bài không có ảnh khớp thì để trống.
FIG = {
    'sale-bat-dong-san-la-gi': ('hop-dau-ngay.jpg', 'Họp đầu ngày 8:30 của đội kinh doanh tại văn phòng 23–25 Nguyễn Phước Lan'),
    'luong-sale-bat-dong-san': ('thu-nhap-khong-tran.png', 'Cấu trúc thu nhập của Pro Sales: lương sàn 7–10 triệu, hoa hồng, thưởng marketing, thưởng nóng'),
    'hoa-hong-moi-gioi-bat-dong-san': ('vinh-danh-2026-11-thuong-nong-mkt.jpg', 'Trao thưởng nóng marketing tại buổi Tổng kết & Vinh danh kinh doanh 02/11/2026'),
    'co-nen-lam-sale-bat-dong-san': ('dao-tao.jpg', 'Buổi đào tạo cho đội kinh doanh tại văn phòng'),
    'cach-tim-khach-hang-bat-dong-san': ('lead-moi-ngay.png', 'Lead từ marketing đầu tổng được chia cho cả đội mỗi ngày'),
    'ky-nang-chot-sale-bat-dong-san': ('ky-ket-casamia-1.jpg', 'Lễ ký kết phân phối dự án Casamia Balanca Hội An'),
}

ref = open(os.path.join(ROOT, 'bai', 'lo-trinh-sale-moi-60-ngay-dau.html'), encoding='utf-8').read()
HEAD_CSS = ref[ref.index('<link href="https://fonts.googleapis.com'):ref.index('</style>')]
CRM = re.search(r'<script src="https://script\.google\.com[^>]*></script>', ref).group(0)
TOPBAR = ref[ref.index('<div class="top">'):ref.index('<header class="hero">')]
TOPBAR = TOPBAR.replace(f'{S}/#dang-ky', f'{S}/ung-tuyen')
PROJECTS = ref[ref.index('<section class="card" id="du-an-dang-ban">'):ref.index('<section class="cta"')]
TAIL = ref[ref.index('<footer'):]

NEW_CSS = '''
.tldr{background:#fff;border:2px solid #f47c20;border-radius:14px;padding:16px 18px;margin:20px 0;font-size:16.5px}
.tldr b:first-child{color:#e06a10}
.byline{display:flex;flex-wrap:wrap;gap:6px 14px;align-items:center;color:#c9d3ea;font-size:14px;margin:18px 0 0}
.byline img{width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:top}
.byline b{color:#fff}
.hl{background:#fff4ea;border:1px solid #ffd2ad;border-radius:12px;padding:14px 16px;margin:14px 0}
.ex{background:#eef3fc;border-left:4px solid #1B2D6B;border-radius:10px;padding:12px 16px;margin:12px 0;font-size:15.5px}
.ex p{margin:6px 0}
.fig img{width:100%;height:auto;border-radius:12px;display:block}
.fig figcaption{font-size:13.5px;color:#6b7896;margin-top:6px}
.midcta{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;background:#0b2a5b;color:#fff;border-radius:14px;padding:16px 18px;margin:24px 0}
.midcta p{margin:0;font-weight:700;font-size:16.5px;flex:1 1 260px}
.midcta p span{display:block;font-weight:500;font-size:14px;color:#d6dff0}
.midcta a{background:#f47c20;color:#fff;text-decoration:none;font-weight:800;padding:12px 18px;border-radius:10px;white-space:nowrap}
.cta .urg{background:rgba(244,124,32,.18);border:1px solid rgba(255,179,122,.5);border-radius:10px;padding:10px 14px;font-size:15px;margin:12px 0 0}
.card table{width:100%;border-collapse:collapse;font-size:15px;display:block;overflow-x:auto}
.card details{border-bottom:1px solid #e3e8f2;padding:10px 0}
.card summary{font-weight:700;cursor:pointer;color:#1B2D6B}
'''


def strip_tags(x):
    return html.unescape(re.sub(r'<[^>]+>', '', x)).strip()


def esc(x):
    return html.escape(x, quote=True)


def build(slug):
    src = open(os.path.join(ROOT, 'bai-src', slug + '.html'), encoding='utf-8').read()
    m = re.search(r'<!--META\s*(\{.*?\})\s*META-->', src, re.S)
    meta = json.loads(m.group(1))
    body = src[m.end():].strip()
    url = f'{S}/{slug}'
    og = f'{IMG}og-{slug}.jpg'
    n = [s for s, _ in ORDER].index(slug) + 1

    # Mục lục từ các section
    secs = re.findall(r'<section class="card[^"]*" id="([^"]+)">\s*<h2>(.*?)</h2>', body, re.S)
    toc = ''.join(f'<li><a href="#{i}">{esc(strip_tags(h))}</a></li>' for i, h in secs)
    toc += '<li><a href="#hoi-dap">Câu hỏi thường gặp</a></li><li><a href="#ung-tuyen">Ứng tuyển</a></li>'

    # Ảnh minh hoạ sau hộp Trả lời nhanh
    if slug in FIG:
        f, cap = FIG[slug]
        fig = f'<figure class="fig"><img src="{IMG}{f}" alt="{esc(cap)}" loading="lazy" width="1200" height="675"><figcaption>{esc(cap)}</figcaption></figure>'
        body = re.sub(r'(<div class="tldr">.*?</div>)', lambda mm: mm.group(1) + '\n' + fig, body, count=1, flags=re.S)

    # Hộp CTA giữa bài, sau section thứ 2
    mid = (f'<div class="midcta"><p>Muốn có người kèm từ ngày đầu?<span>Data phân bổ mỗi ngày · hỗ trợ 50–100% quảng cáo · 03 tháng xét lương</span></p>'
           f'<a href="{S}/ung-tuyen">Gửi hồ sơ 30 giây →</a></div>')
    ends = [mm.end() for mm in re.finditer(r'</section>', body)]
    if len(ends) >= 2:
        body = body[:ends[1]] + '\n' + mid + body[ends[1]:]

    faq = meta['faq']
    faq_html = '<section class="card faq" id="hoi-dap">\n<h2>Câu hỏi <span>thường gặp</span></h2>\n' + ''.join(
        f'<details><summary>{esc(q)}</summary><p>{a}</p></details>\n' for q, a in faq) + '</section>\n'

    pts = ''.join(f'<li>{p}</li>' for p in meta['cta_points'])
    cta = f'''<section class="cta" id="ung-tuyen">
<h2>{meta['cta_h2']}</h2>
<ul>{pts}</ul>
<div class="formbox apply">
<p style="margin:0 0 12px;font-weight:700;font-size:17px;color:#1B2D6B">Gửi hồ sơ trong 30 giây, không cần CV</p>
<a class="ab ab1" href="{S}/ung-tuyen">📄 Gửi hồ sơ ứng tuyển ngay</a>
<a class="ab ab3" href="https://zalo.me/0904567009" target="_blank" rel="noopener">💬 Chat Zalo với Hiệp: 0904 567 009</a>
<a class="ab ab2" href="tel:0904567009">📞 Gọi 0904 567 009</a>
<a class="ab ab4" href="mailto:hiephoangmt@gmail.com?subject=CV%20%E1%BB%A9ng%20tuy%E1%BB%83n%20Sale%20%C4%90%C3%A0%20N%E1%BA%B5ng">✉️ Gửi file CV qua email</a>
<p style="font-size:13px;color:#6b7896;margin:10px 0 0">Miễn phí · CV không bắt buộc · Hiệp gọi lại trong ngày · Bảo mật thông tin</p></div>
<p class="urg">🎁 Thi đua <b>Bứt tốc F2 – Sun FourS Tower</b> đến 30/11/2026: chốt giao dịch tòa F2 nhận phiếu bốc thăm iPhone 18 Pro Max, DJI Pocket 4, AirPods 5.</p>
</section>
'''

    items = []
    for i, (s2, t2) in enumerate(ORDER, 1):
        if s2 == slug:
            items.append(f'<li><div class="cur"><b>{i}. {esc(t2)} <em>Bạn đang đọc</em></b><span>{esc(meta["series_desc"])}</span></div></li>')
        else:
            items.append(f'<li><div class="si"><b><a href="{S}/{s2}">{i}. {esc(t2)}</a></b><a class="si-go" href="{S}/{s2}">Đọc bài →</a></div></li>')
    series = f'''<section class="card" id="doc-tiep">
<h2>Chuỗi bài <span>Nhập môn Sale BĐS</span></h2>
<p class="lead">10 bài từ cơ bản đến kỹ năng, viết cho người mới. Đọc xong chuỗi này, tiếp tục với <a href="{S}/lo-trinh-sale-moi-60-ngay-dau">lộ trình 60 ngày đầu</a> và chuỗi bài marketing.</p>
<ol class="series">{''.join(items)}</ol>
<p class="more">Muốn học trực tiếp, có người kèm? <a href="{S}/ung-tuyen">Gửi hồ sơ 30 giây</a> · <a href="{S}/#vi-tri">Xem các vị trí đang tuyển</a></p>
</section>
'''

    ld = [{
        '@context': 'https://schema.org', '@type': 'Article', 'headline': meta['h1'], 'description': meta['description'],
        'image': og, 'datePublished': TODAY, 'dateModified': TODAY, 'inLanguage': 'vi',
        'author': {'@type': 'Person', 'name': 'Hoàng Hiệp', 'jobTitle': 'Giám đốc kinh doanh', 'url': S},
        'publisher': {'@type': 'Organization', 'name': 'Tuyển Sale Đà Nẵng', 'url': S, 'logo': {'@type': 'ImageObject', 'url': IMG + 'favicon-tuyen-sale.png'}},
        'mainEntityOfPage': url, 'keywords': meta['keywords'],
    }, {
        '@context': 'https://schema.org', '@type': 'FAQPage',
        'mainEntity': [{'@type': 'Question', 'name': q, 'acceptedAnswer': {'@type': 'Answer', 'text': strip_tags(a)}} for q, a in faq],
    }, {
        '@context': 'https://schema.org', '@type': 'BreadcrumbList', 'itemListElement': [
            {'@type': 'ListItem', 'position': 1, 'name': 'Tuyển Sale Đà Nẵng', 'item': S + '/'},
            {'@type': 'ListItem', 'position': 2, 'name': 'Cẩm nang', 'item': S + '/#cam-nang'},
            {'@type': 'ListItem', 'position': 3, 'name': meta['h1'], 'item': url}]},
    ]
    ldj = '\n'.join(f'<script type="application/ld+json">{json.dumps(x, ensure_ascii=False)}</script>' for x in ld)

    b1 = meta.get('btn1') or ['#' + secs[0][0], 'Đọc ngay']
    page = f'''<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="ladipage-rules" content="v2">
<title>{esc(meta['title'])}</title>
<meta name="description" content="{esc(meta['description'])}">
{HEAD_CSS}{NEW_CSS}</style>
{CRM}
<meta name="keywords" content="{esc(meta['keywords'])}">
<meta name="author" content="Hoàng Hiệp">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta property="og:url" content="{url}">
<meta property="og:type" content="article">
<meta property="og:image" content="{og}">
<meta property="og:title" content="{esc(meta['title'])}">
<meta property="og:description" content="{esc(meta['description'])}">
<meta property="article:published_time" content="{TODAY}">
<meta property="article:modified_time" content="{TODAY}">
<link rel="icon" href="{IMG}favicon-tuyen-sale.png">
<link rel="apple-touch-icon" href="{IMG}favicon-tuyen-sale.png">
<link rel="canonical" href="{url}">
{ldj}
</head>
<body>
{TOPBAR}<header class="hero"><div class="wrap">
<span class="tag">{esc(meta['tag'])}</span>
<h1>{esc(meta['h1'])}</h1>
<p>{meta['intro']}</p>
<a class="btn" href="{b1[0]}">{esc(b1[1])}</a><a class="btn2" href="{S}/ung-tuyen">Gửi hồ sơ, có người kèm</a>
<div class="byline"><img src="{IMG}hoang-hiep-portrait.jpg" alt="Hoàng Hiệp" width="34" height="34"><span>Viết bởi <b>Hoàng Hiệp</b> · Giám đốc kinh doanh</span><span>Cập nhật {TODAY_VN}</span></div>
</div></header>
<main class="wrap">
<nav class="mluc" id="muc-luc">
<h2>📑 Mục lục</h2>
<ul>{toc}</ul>
</nav>
{body}
{faq_html}
{PROJECTS}{cta}
{series}</main>
{TAIL}'''
    out = os.path.join(ROOT, 'bai', slug + '.html')
    open(out, 'w', encoding='utf-8').write(page)
    return out, meta


if __name__ == '__main__':
    slugs = sys.argv[1:] or [s for s, _ in ORDER]
    for s in slugs:
        if not os.path.exists(os.path.join(ROOT, 'bai-src', s + '.html')):
            print('chưa có', s); continue
        o, m = build(s)
        print('ok', s, len(open(o, encoding='utf-8').read()), 'bytes')
