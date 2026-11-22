"""Dựng trang tin pháp luật BĐS: bai/tin-phap-luat-bat-dong-san.html từ bai-src/tin-luat.json.
Thêm tin mới: thêm 1 phần tử vào tin-luat.json (date, effective, status, title, summary, for_sale, doc, tags, sources),
đổi UPDATED bên dưới, chạy lại script rồi cập nhật trang trên LadiPage.
"""
import html, json, os, re, datetime

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
S = 'https://www.tuyendungsaledanang.com'
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
SLUG = 'tin-phap-luat-bat-dong-san'
UPDATED, UPDATED_VN = '2026-11-22', '22/11/2026'
e = lambda x: html.escape(x or '', quote=True)
vn = lambda d: datetime.date.fromisoformat(d).strftime('%d/%m/%Y') if d else ''

news = sorted(json.load(open(os.path.join(ROOT, 'bai-src', 'tin-luat.json'), encoding='utf-8')), key=lambda n: n['date'], reverse=True)
ST = {'hieu-luc': ('Đang hiệu lực', 'ok'), 'ban-hanh': ('Đã ban hành, chưa hiệu lực', 'wait'), 'du-thao': ('Dự thảo', 'draft')}
tags = []
for n in news:
    for t in n['tags']:
        if t not in tags:
            tags.append(t)

ref = open(os.path.join(ROOT, 'bai', 'lo-trinh-sale-moi-60-ngay-dau.html'), encoding='utf-8').read()
HEAD_CSS = ref[ref.index('<link href="https://fonts.googleapis.com'):ref.index('</style>')]
CRM = re.search(r'<script src="https://script\.google\.com[^>]*></script>', ref).group(0)
TOPBAR = ref[ref.index('<div class="top">'):ref.index('<header class="hero">')].replace(f'{S}/#dang-ky', f'{S}/ung-tuyen')
TOPBAR = TOPBAR.replace('<a href="#muc-luc">📑 Mục lục</a>', '<a href="#tin">📰 Tin mới</a>')
TAIL = ref[ref.index('<footer'):]

today = datetime.date.fromisoformat(UPDATED)
upcoming = sorted([n for n in news if n.get('effective') and datetime.date.fromisoformat(n['effective']) > today], key=lambda n: n['effective'])
up_html = ''.join(f'<li><b>{vn(n["effective"])}</b> · {e(n["title"])}</li>' for n in upcoming)

cards = []
for i, n in enumerate(news):
    lab, cls = ST[n['status']]
    src = ' · '.join(f'<a href="{e(s["url"])}" target="_blank" rel="noopener nofollow">{e(s["name"])}</a>' for s in n['sources'])
    eff = f'<span>Hiệu lực: <b>{vn(n["effective"])}</b></span>' if n.get('effective') else ''
    cards.append(f'''<article class="nw" id="tin-{i+1}" data-tags="{e('|'.join(n['tags']))}">
<div class="nw-top"><time datetime="{n['date']}">{vn(n['date'])}</time><span class="st {cls}">{lab}</span>{''.join(f'<span class="tg">{e(t)}</span>' for t in n['tags'])}</div>
<h3>{e(n['title'])}</h3>
<p>{e(n['summary'])}</p>
<div class="fs"><b>Sale cần biết:</b> {e(n['for_sale'])}</div>
<p class="meta">{f'Văn bản: <b>{e(n["doc"])}</b> · ' if n.get('doc') else ''}{eff}</p>
<p class="src">Nguồn: {src}</p>
</article>''')

title = 'Tin pháp luật bất động sản mới nhất 2026–2027 cho sale | Tuyển Sale Đà Nẵng'
desc = (f'Cập nhật {UPDATED_VN}: Luật Kinh doanh BĐS sửa đổi hiệu lực 1/7/2027, Nghị định 339/2026 xử phạt môi giới, '
        'bảng giá đất Đà Nẵng, thuế chuyển nhượng. Tóm tắt dễ hiểu, sale cần làm gì.')
url = f'{S}/{SLUG}'
ld = [{'@context': 'https://schema.org', '@type': 'CollectionPage', 'name': title, 'description': desc, 'url': url,
       'dateModified': UPDATED, 'inLanguage': 'vi',
       'mainEntity': {'@type': 'ItemList', 'itemListElement': [
           {'@type': 'ListItem', 'position': i + 1, 'item': {'@type': 'NewsArticle', 'headline': n['title'], 'datePublished': n['date'],
                                                            'description': n['summary'], 'url': f'{url}#tin-{i+1}',
                                                            'author': {'@type': 'Person', 'name': 'Hoàng Hiệp'}}}
           for i, n in enumerate(news)]}}]
ldj = ''.join(f'<script type="application/ld+json">{json.dumps(x, ensure_ascii=False)}</script>' for x in ld)

CSS = '''
.chips{display:flex;flex-wrap:wrap;gap:8px;margin:6px 0 4px}
.chips button{border:1px solid #cfd6e4;background:#fff;border-radius:99px;padding:6px 12px;font:inherit;font-size:14px;cursor:pointer;color:#1B2D6B}
.chips button[aria-pressed=true]{background:#1B2D6B;color:#fff;border-color:#1B2D6B}
.nw{background:#fff;border-radius:14px;padding:18px;margin:14px 0;box-shadow:0 2px 10px rgba(11,42,91,.06);scroll-margin-top:70px}
.nw-top{display:flex;flex-wrap:wrap;gap:6px 8px;align-items:center;font-size:13px;color:#6b7896}
.nw-top time{font-weight:800;color:#1B2D6B;font-variant-numeric:tabular-nums}
.st{font-weight:700;padding:2px 9px;border-radius:99px}.st.ok{background:#ecf7ef;color:#1c6b35}.st.wait{background:#fff4ea;color:#a8520f}.st.draft{background:#eef0f4;color:#4b5570}
.tg{background:#eef3fc;color:#1B2D6B;padding:2px 9px;border-radius:99px}
.nw h3{font-size:18.5px;line-height:1.35;margin:10px 0 6px;color:#1d2433}
.nw p{margin:6px 0}
.fs{background:#fff4ea;border-left:4px solid #f47c20;border-radius:8px;padding:10px 14px;margin:10px 0;font-size:15.5px}
.nw .meta{font-size:14px;color:#4b5570}.nw .meta span{white-space:nowrap}
.nw .src{font-size:13.5px;color:#6b7896}.nw .src a{color:#1B2D6B}
.up{background:#0b2a5b;color:#fff;border-radius:14px;padding:16px 18px;margin:20px 0}
.up h2{color:#fff;font-size:19px;margin:0 0 8px}.up ul{margin:0;padding-left:20px}.up li{margin:4px 0}
.subcta{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;background:#fff;border:2px solid #f47c20;border-radius:14px;padding:14px 16px;margin:20px 0}
.subcta a{background:#f47c20;color:#fff;font-weight:800;text-decoration:none;padding:11px 16px;border-radius:10px;white-space:nowrap}
'''
JS = '''document.querySelectorAll('.chips button').forEach(b=>b.onclick=()=>{document.querySelectorAll('.chips button').forEach(x=>x.setAttribute('aria-pressed',x===b));const t=b.dataset.t;document.querySelectorAll('.nw').forEach(a=>a.hidden=t&&!a.dataset.tags.split('|').includes(t))});'''
chips = '<button data-t="" aria-pressed="true">Tất cả</button>' + ''.join(f'<button data-t="{e(t)}" aria-pressed="false">{e(t)}</button>' for t in tags)

page = f'''<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="ladipage-rules" content="v2">
<title>{e(title)}</title>
<meta name="description" content="{e(desc)}">
{HEAD_CSS}{CSS}</style>
{CRM}
<meta name="keywords" content="tin pháp luật bất động sản, luật kinh doanh bất động sản sửa đổi, luật kinh doanh bất động sản 2026, nghị định xử phạt môi giới bất động sản, bảng giá đất đà nẵng 2026, luật mới bất động sản">
<meta name="author" content="Hoàng Hiệp">
<meta property="og:url" content="{url}">
<meta property="og:type" content="website">
<meta property="og:image" content="{IMG}og-{SLUG}.jpg">
<meta property="og:title" content="{e(title)}">
<meta property="og:description" content="{e(desc)}">
<link rel="icon" href="{IMG}favicon-tuyen-sale.png">
<link rel="canonical" href="{url}">
{ldj}
</head>
<body>
{TOPBAR}<header class="hero"><div class="wrap">
<span class="tag">Tin pháp luật · Cập nhật {UPDATED_VN}</span>
<h1>Tin pháp luật bất động sản mới nhất cho sale</h1>
<p>Luật mới, nghị định mới, bảng giá đất Đà Nẵng: mỗi tin tóm tắt dễ hiểu, ghi rõ đã hiệu lực hay chưa, và <b>sale cần làm gì</b> khi khách hỏi. Nguồn dẫn từ cổng chính thức và báo uy tín.</p>
<a class="btn" href="#tin">Đọc tin mới nhất</a><a class="btn2" href="{S}/thi-thu-chung-chi-moi-gioi">Thi thử chứng chỉ môi giới</a>
</div></header>
<main class="wrap">
<section class="up"><h2>📅 Mốc luật sắp có hiệu lực</h2><ul>{up_html}</ul></section>
<div id="tin" style="scroll-margin-top:70px"><div class="chips" role="group" aria-label="Lọc theo chủ đề">{chips}</div>
{cards[0]}{''.join(cards[1:3])}
<div class="subcta"><span><b>Muốn làm sale ở nơi cập nhật luật cho cả đội?</b><br>Đào tạo từ 0 · có người kèm · data phân bổ mỗi ngày</span><a href="{S}/ung-tuyen">Gửi hồ sơ 30 giây →</a></div>
{''.join(cards[3:])}</div>
<section class="card">
<h2>Học sâu hơn <span>cho người mới</span></h2>
<ul><li><a href="{S}/luat-kinh-doanh-bat-dong-san">Luật Kinh doanh BĐS 2023 cho người mới: 10 điểm sale phải nhớ</a></li>
<li><a href="{S}/chung-chi-moi-gioi-bat-dong-san">Chứng chỉ môi giới BĐS: có bắt buộc không, thi ở đâu</a></li>
<li><a href="{S}/thi-thu-chung-chi-moi-gioi">Thi thử chứng chỉ môi giới: đề tự đảo mỗi lần làm</a></li>
<li><a href="{S}/can-ho-hinh-thanh-trong-tuong-lai">Căn hộ hình thành trong tương lai: cọc 5%, thanh toán 30%, 70%</a></li></ul>
<p class="note">Trang tổng hợp tin để sale tham khảo, không thay thế tư vấn pháp lý. Khi tư vấn khách, luôn đối chiếu văn bản gốc và hỏi bộ phận pháp lý của công ty.</p>
</section>
</main>
<script>{JS}</script>
{TAIL}'''
out = os.path.join(ROOT, 'bai', SLUG + '.html')
open(out, 'w', encoding='utf-8').write(page)
print('ok', out, len(news), 'tin,', len(upcoming), 'mốc sắp tới')
