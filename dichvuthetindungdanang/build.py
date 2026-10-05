#!/usr/bin/env python3
"""Tạo toàn bộ trang HTML tĩnh cho dichvuthetindungdanang.com.

Cách dùng:  python3 build.py
- Sửa giá ở FEES, thông tin liên hệ ở SITE.
- Nội dung trang chủ: src/pages/index.body.html (+ src/index.head.html).
- Nội dung trang con: PAGES bên dưới.
Kết quả ghi đè index.html, các thư mục trang con và sitemap.xml.
"""
import html, json, os, re

HERE = os.path.dirname(os.path.abspath(__file__))
DOMAIN = "https://www.dichvuthetindungdanang.com/"
UPDATED = "2026-10-05"  # ngày cập nhật hiển thị + dateModified

SITE = {
    "name": "Dịch Vụ Thẻ Tín Dụng Đà Nẵng",
    "phone": "0909669325",
    "phone_text": "0909 669 325",
    "email": "Km.camvan@gmail.com",
}

# ===== BẢNG PHÍ – SỬA GIÁ Ở ĐÂY =====
# (mức tiền, phí đáo hạn, phí rút tiền)
FEES = [
    ("Dưới 10 triệu", "2,0%", "2,2%"),
    ("10 – 50 triệu", "1,8%", "2,0%"),
    ("50 – 100 triệu", "1,7%", "1,9%"),
    ("Trên 100 triệu", "Thoả thuận", "Thoả thuận"),
]
FEE_MIN = "1,7%"


def read(p):
    with open(os.path.join(HERE, p), encoding="utf-8") as f:
        return f.read()


def write(p, s):
    full = os.path.join(HERE, p)
    os.makedirs(os.path.dirname(full), exist_ok=True)
    with open(full, "w", encoding="utf-8") as f:
        f.write(s)


def fee_table():
    rows = "".join(
        f"<tr><td>{a}</td><td class=\"fee\">{b}</td><td class=\"fee\">{c}</td></tr>" for a, b, c in FEES
    )
    return (
        '<div class="tbl"><table><thead><tr><th>Số tiền giao dịch</th><th>Phí đáo hạn</th>'
        f"<th>Phí rút tiền</th></tr></thead><tbody>{rows}</tbody></table></div>"
    )


def pct(s):
    return float(s.replace("%", "").replace(",", ".")) / 100


def example_table():
    rows = ""
    for debt, tier in ((10, 1), (30, 1), (50, 2)):
        fee = debt * 1e6 * pct(FEES[tier][1])
        late = debt * 1e6 * 0.28 * 30 / 365 + max(debt * 1e6 * 0.05 * 0.05, 99000)
        f = lambda n: f"{round(n, -4):,.0f}đ".replace(",", ".")
        rows += f"<tr><td>{debt}.000.000đ</td><td class=\"fee\">{f(fee)}</td><td>≈ {f(late)} + nguy cơ nợ xấu</td></tr>"
    return ('<div class="tbl"><table><thead><tr><th>Dư nợ</th><th>Phí đáo hạn (tham khảo)</th>'
            f"<th>Nếu trễ hạn 1 tháng*</th></tr></thead><tbody>{rows}</tbody></table></div>")


def fill(s, root):
    return (s.replace("{{R}}", root).replace("{{FEE_TABLE}}", fee_table()).replace("{{EXAMPLE_TABLE}}", example_table())
             .replace("{{FEE_MIN}}", FEE_MIN).replace("{{UPDATED}}", vn_date(UPDATED))
             .replace("{{BANK_LINKS}}", "".join(f'<a href="{root}dao-han-the-{k}-da-nang/" class="bank">{n}</a>' for k, n, *_ in BANKS)))


def vn_date(iso):
    y, m, d = iso.split("-")
    return f"{d}/{m}/{y}"


def jsonld(obj):
    return '<script type="application/ld+json">' + json.dumps(obj, ensure_ascii=False) + "</script>"


def faq_html(faqs):
    if not faqs:
        return ""
    items = "".join(f"<details><summary>{q}</summary><p>{a}</p></details>" for q, a in faqs)
    return f'<h2 id="hoi-dap">Câu hỏi thường gặp</h2><div class="faq" style="margin-top:12px">{items}</div>'


def toc_html(body):
    heads = re.findall(r'<h2 id="([^"]+)">(.*?)</h2>', body)
    if len(heads) < 3:
        return ""
    li = "".join(f'<li><a href="#{i}">{re.sub("<.*?>", "", t)}</a></li>' for i, t in heads)
    return f'<nav class="toc" aria-label="Mục lục"><b>Nội dung chính</b><ol>{li}</ol></nav>'


INLINE_CTA = (
    '<div class="inline-cta"><p>📲 Thẻ sắp đến hạn? Nhắn Zalo để được báo phí chính xác trong 1 phút.</p>'
    '<a href="#" class="btn btn-zalo" data-zalo><svg><use href="#i-zalo"/></svg>Chat Zalo ngay</a></div>'
)


def side(root, slug):
    links = [(p["slug"], p["h1"]) for p in PAGES if p["slug"] != slug and not p.get("bank")][:6]
    li = "".join(f'<li><a href="{root}{s}/">› {t}</a></li>' for s, t in links)
    return f"""<aside class="side">
  <div class="side-card">
    <h3>Báo phí trong 1 phút</h3>
    <p>Gửi ngân hàng, số tiền và ngày đến hạn qua Zalo. Tư vấn miễn phí, không ràng buộc.</p>
    <a href="#" class="btn btn-zalo pulse" data-zalo><svg><use href="#i-zalo"/></svg>Chat Zalo</a>
    <a href="#" class="btn btn-navy" data-tel><svg><use href="#i-phone"/></svg><span data-phone-text>{SITE['phone_text']}</span></a>
  </div>
  <div class="side-links"><b>Xem thêm</b><ul>{li}</ul></div>
</aside>"""


def head_common(title, desc, url, root, og_type="website"):
    return f"""<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title}</title>
<meta name="description" content="{html.escape(desc)}">
<meta name="robots" content="index, follow, max-image-preview:large">
<link rel="canonical" href="{url}">
<meta name="theme-color" content="#0b1f44">
<meta name="geo.region" content="VN-DN"><meta name="geo.placename" content="Đà Nẵng">
<meta property="og:type" content="{og_type}"><meta property="og:locale" content="vi_VN">
<meta property="og:site_name" content="{SITE['name']}">
<meta property="og:title" content="{html.escape(title)}">
<meta property="og:description" content="{html.escape(desc)}">
<meta property="og:url" content="{url}">
<meta property="og:image" content="{DOMAIN}og-image.png">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%230b1f44'/%3E%3Crect x='10' y='18' width='44' height='28' rx='5' fill='%23ff7a00'/%3E%3Crect x='10' y='24' width='44' height='6' fill='%230b1f44'/%3E%3C/svg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{root}assets/site.css">
"""


def tail(root):
    return fill(read("src/partials/footer.html"), root) + f'\n<script src="{root}assets/site.js"></script>\n</body>\n</html>\n'


def build_page(p):
    slug = p["slug"]
    depth = slug.count("/") + 1
    root = "../" * depth
    url = DOMAIN + slug + "/"
    body = fill(p["body"], root).replace("{{POSTS}}", "".join(
        f'<a href="{root}{q["slug"]}/">{q["h1"]}<small>{q["desc"][:110]}…</small></a>' for q in PAGES if q.get("article")))
    crumbs = [("Trang chủ", DOMAIN)] + [(t, DOMAIN + s + "/") for s, t in p.get("parents", [])] + [(p["crumb"], url)]
    schemas = [
        {"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [
            {"@type": "ListItem", "position": i + 1, "name": n, "item": u} for i, (n, u) in enumerate(crumbs)]},
        {"@context": "https://schema.org", "@type": "Article" if p.get("article") else "Service",
         **({"headline": p["h1"], "datePublished": p.get("published", UPDATED), "dateModified": UPDATED,
             "author": {"@type": "Organization", "name": SITE["name"], "url": DOMAIN},
             "publisher": {"@type": "Organization", "name": SITE["name"], "url": DOMAIN},
             "mainEntityOfPage": url, "image": DOMAIN + "og-image.png"}
            if p.get("article") else
            {"name": p["h1"], "serviceType": p["crumb"], "url": url, "areaServed": {"@type": "City", "name": "Đà Nẵng"},
             "provider": {"@type": "FinancialService", "name": SITE["name"], "telephone": "+84-909-669-325",
                          "url": DOMAIN, "address": {"@type": "PostalAddress", "addressLocality": "Đà Nẵng", "addressCountry": "VN"}}}),
         "description": p["desc"]},
    ]
    if p.get("faqs"):
        schemas.append({"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
            {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": re.sub("<.*?>", "", a)}}
            for q, a in p["faqs"]]})
    crumb_html = "".join(
        f'<a href="{root}">Trang chủ</a>' if i == 0 else
        (f'<span><a href="{root}{c[1][len(DOMAIN):]}">{c[0]}</a></span>' if i < len(crumbs) - 1 else f"<span>{c[0]}</span>")
        for i, c in enumerate(crumbs))
    header = fill(read("src/partials/header.html"), root)
    header = header.replace(f'<a href="{root}{slug.split("/")[0]}/">', f'<a href="{root}{slug.split("/")[0]}/" aria-current="page">', 1)
    related = ""
    if p.get("related"):
        cards = "".join(
            f'<a href="{root}{q["slug"]}/">{q["h1"]}<small>{q["desc"][:95]}…</small></a>'
            for q in PAGES if q["slug"] in p["related"])
        related = f'<h2 id="bai-lien-quan">Bài viết liên quan</h2><div class="related">{cards}</div>'
    out = (head_common(p["title"], p["desc"], url, root, "article" if p.get("article") else "website")
           + "\n".join(jsonld(s) for s in schemas) + "\n</head>\n<body>\n" + header
           + f"""
<main>
<section class="phero">
  <div class="container">
    <nav class="crumbs" aria-label="Breadcrumb">{crumb_html}</nav>
    <h1>{p['h1']}</h1>
    <p class="intro">{p['intro']}</p>
    <div class="hero-cta">
      <a href="#" class="btn btn-zalo pulse" data-zalo><svg><use href="#i-zalo"/></svg>Nhắn Zalo – Báo phí ngay</a>
      <a href="#" class="btn btn-ghost" data-tel><svg><use href="#i-phone"/></svg><span data-phone-text>{SITE['phone_text']}</span></a>
    </div>
    <p class="meta">Cập nhật: {vn_date(UPDATED)} · Bởi {SITE['name']}</p>
  </div>
</section>
<div class="container page">
  <article class="prose">
    {toc_html(body + ('<h2 id="hoi-dap">Câu hỏi thường gặp</h2>' if p.get('faqs') else ''))}
    {body}
    {INLINE_CTA}
    {faq_html(p.get('faqs'))}
    {related}
  </article>
  {side(root, slug)}
</div>
</main>
""" + tail(root))
    write(slug + "/index.html", out)


def build_index():
    root = ""
    blog = "".join(
        f'<a class="post reveal" href="{q["slug"]}/"><span class="thumb">{q.get("icon","₫")}</span>'
        f'<div class="c"><h3>{q["h1"]}</h3><p>{q["desc"][:110]}…</p></div></a>'
        for q in PAGES if q.get("article"))[:6000]
    body = fill(read("src/pages/index.body.html"), root).replace("{{POSTS}}", blog)
    out = (fill(read("src/index.head.html"), root) + '<link rel="stylesheet" href="assets/site.css">\n</head>\n<body>\n'
           + fill(read("src/partials/header.html"), root).replace('<a href="">Trang chủ</a>', '<a href="./" aria-current="page">Trang chủ</a>').replace('href=""', 'href="./"')
           + "\n" + body + "\n" + tail(root))
    write("index.html", out)


def build_sitemap():
    urls = [(DOMAIN, "1.0")] + [(DOMAIN + p["slug"] + "/", "0.7" if p.get("article") else ("0.8" if p.get("bank") else "0.9")) for p in PAGES]
    items = "".join(f"  <url><loc>{u}</loc><lastmod>{UPDATED}</lastmod><priority>{pr}</priority></url>\n" for u, pr in urls)
    write("sitemap.xml", '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n' + items + "</urlset>\n")


AREAS = "Hải Châu, Thanh Khê, Sơn Trà, Ngũ Hành Sơn, Liên Chiểu, Cẩm Lệ, Hòa Vang và Điện Bàn"

PAGES = [
# ---------------------------------------------------------------- ĐÁO HẠN
{
"slug": "dao-han-the-tin-dung-da-nang",
"crumb": "Đáo hạn thẻ tín dụng Đà Nẵng",
"title": "Đáo Hạn Thẻ Tín Dụng Đà Nẵng ✔️ Phí Từ {{FEE_MIN}}, Tận Nơi 15 Phút".replace("{{FEE_MIN}}", FEE_MIN),
"desc": f"Đáo hạn thẻ tín dụng Đà Nẵng phí từ {FEE_MIN}, xong 15 phút, tận nơi mọi quận. Tránh phạt trễ hạn, giữ điểm tín dụng. Zalo 0909 669 325.",
"h1": "Đáo Hạn Thẻ Tín Dụng Đà Nẵng – Nhanh 15 Phút, Phí Từ " + FEE_MIN,
"intro": "Thẻ sắp đến hạn mà chưa kịp xoay tiền? Chúng tôi thanh toán dư nợ giúp bạn trước ngày đến hạn, bạn tránh được phí phạt, lãi trả chậm và nguy cơ nợ xấu – có mặt tận nơi khắp Đà Nẵng.",
"related": ["bang-phi", "kien-thuc/dao-han-the-tin-dung-la-gi", "kien-thuc/ngay-sao-ke-va-ngay-den-han"],
"faqs": [
    ("Đáo hạn thẻ tín dụng ở Đà Nẵng mất bao lâu?", "Thông thường 15–30 phút kể từ khi bạn có mặt tại cửa hàng hoặc nhân viên đến tận nơi."),
    ("Phí đáo hạn thẻ tín dụng là bao nhiêu?", f"Phí từ {FEE_MIN} tùy số tiền và ngân hàng. Xem chi tiết tại bảng phí hoặc nhắn Zalo để được báo phí chính xác."),
    ("Đáo hạn có ảnh hưởng điểm tín dụng (CIC) không?", "Không. Ngược lại, khoản nợ được thanh toán đúng hạn nên lịch sử tín dụng của bạn luôn tốt."),
    ("Có đáo hạn được thẻ của mọi ngân hàng không?", "Hỗ trợ thẻ Visa, Mastercard, JCB, Amex, Napas của hầu hết ngân hàng: Vietcombank, VietinBank, BIDV, Techcombank, VPBank, MB, ACB, Sacombank, TPBank, VIB, HSBC, Shinhan…"),
    ("Đến hạn hôm nay có làm kịp không?", "Kịp, nếu bạn liên hệ sớm trong ngày. Hãy nhắn Zalo ngay để được ưu tiên xếp lịch."),
],
"body": """
<p><strong>Đáo hạn thẻ tín dụng Đà Nẵng</strong> là dịch vụ giúp bạn thanh toán khoản dư nợ thẻ đúng hạn khi chưa có sẵn tiền mặt. Chúng tôi nộp tiền vào thẻ giúp bạn, sau đó bạn dùng lại hạn mức vừa được giải phóng để hoàn trả. Kết quả: bạn <strong>không bị phạt trễ hạn, không bị tính lãi</strong> và có thêm một chu kỳ miễn lãi tới 45–55 ngày.</p>

<h2 id="vi-sao">Vì sao nên đáo hạn thay vì để thẻ trễ hạn?</h2>
<p>Khi trễ hạn dù chỉ 1 ngày, ngân hàng thường áp dụng đồng thời nhiều khoản:</p>
<ul>
<li><strong>Phí chậm thanh toán:</strong> khoảng 4–6% số tiền thanh toán tối thiểu (có mức sàn, thường từ vài chục đến vài trăm nghìn đồng).</li>
<li><strong>Lãi suất 25–35%/năm</strong> tính trên <em>toàn bộ</em> dư nợ, kể từ ngày giao dịch – không chỉ phần còn thiếu.</li>
<li><strong>Nguy cơ nợ xấu CIC</strong> nếu trễ kéo dài, ảnh hưởng tới việc vay mua nhà, mua xe sau này.</li>
</ul>
<p>Trong khi đó, phí đáo hạn chỉ từ <strong>{{FEE_MIN}}</strong> và trả <em>một lần</em>. Với dư nợ 20 triệu, chi phí đáo hạn thường thấp hơn đáng kể so với tổng lãi + phí phạt nếu để trễ một tháng.</p>

<figure>
<svg viewBox="0 0 640 170" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Quy trình đáo hạn 3 bước">
<defs><marker id="a1" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto"><path d="M0 0L10 5L0 10z" fill="#ff7a00"/></marker></defs>
<g font-family="Be Vietnam Pro,Arial" text-anchor="middle">
<rect x="10" y="20" width="180" height="130" rx="16" fill="#fff" stroke="#e3e8f2"/><circle cx="100" cy="58" r="22" fill="#0b1f44"/><text x="100" y="65" fill="#fff" font-weight="800" font-size="18">1</text>
<text x="100" y="104" font-weight="700" font-size="14" fill="#0b1f44">Thẻ đến hạn</text><text x="100" y="126" font-size="12" fill="#5a6785">Dư nợ 20 triệu</text>
<path d="M196 85h48" stroke="#ff7a00" stroke-width="3" marker-end="url(#a1)"/>
<rect x="230" y="20" width="180" height="130" rx="16" fill="#fff3e8" stroke="#ffd2a8"/><circle cx="320" cy="58" r="22" fill="#ff7a00"/><text x="320" y="65" fill="#fff" font-weight="800" font-size="18">2</text>
<text x="320" y="104" font-weight="700" font-size="14" fill="#0b1f44">Chúng tôi nộp tiền</text><text x="320" y="126" font-size="12" fill="#5a6785">Tất toán đúng hạn</text>
<path d="M416 85h48" stroke="#ff7a00" stroke-width="3" marker-end="url(#a1)"/>
<rect x="450" y="20" width="180" height="130" rx="16" fill="#0b1f44"/><circle cx="540" cy="58" r="22" fill="#1bb35a"/><path d="M530 58l7 7 13-14" stroke="#fff" stroke-width="3.5" fill="none" stroke-linecap="round"/>
<text x="540" y="104" font-weight="700" font-size="14" fill="#fff">Bạn dùng lại hạn mức</text><text x="540" y="126" font-size="12" fill="#c9d4ec">Thêm 45–55 ngày</text>
</g></svg>
<figcaption>Đáo hạn thẻ tín dụng: 3 bước, hoàn tất trong khoảng 15 phút</figcaption>
</figure>

<h2 id="quy-trinh">Quy trình đáo hạn thẻ tại Đà Nẵng</h2>
<ol>
<li><strong>Nhắn Zalo 0909 669 325:</strong> gửi tên ngân hàng, số tiền cần đáo hạn và ngày đến hạn.</li>
<li><strong>Nhận báo phí:</strong> báo phí trọn gói, rõ ràng. Bạn đồng ý mới thực hiện.</li>
<li><strong>Thanh toán dư nợ:</strong> chúng tôi nộp tiền vào thẻ, bạn kiểm tra trên app ngân hàng.</li>
<li><strong>Hoàn trả:</strong> thực hiện giao dịch bằng hạn mức vừa được giải phóng, nhận hoá đơn đầy đủ.</li>
</ol>
<div class="box"><p><strong>Chuẩn bị:</strong> thẻ tín dụng chính chủ + CCCD. Không cần cung cấp mã OTP, CVV hay mật khẩu ngân hàng.</p></div>

<h2 id="bang-phi">Phí đáo hạn thẻ tín dụng Đà Nẵng</h2>
<p>Mức phí tham khảo, cập nhật {{UPDATED}}. Phí cố định theo số tiền, đã bao gồm công đến tận nơi trong nội thành:</p>
{{FEE_TABLE}}
<p>Xem thêm so sánh chi phí chi tiết tại <a href="{{R}}bang-phi/">bảng phí dịch vụ thẻ tín dụng</a>.</p>

<h2 id="khu-vuc">Đáo hạn tận nơi tại các quận Đà Nẵng</h2>
<p>Không tiện ra cửa hàng? Nhân viên sẽ đến tận nhà hoặc văn phòng của bạn tại <strong>""" + AREAS + """</strong> trong khoảng 20–30 phút. Thời gian phục vụ 7h30 – 21h00 tất cả các ngày trong tuần, kể cả cuối tuần và ngày lễ – thời điểm ngân hàng nghỉ nhưng thẻ của bạn vẫn đến hạn.</p>

<h2 id="luu-y">Lưu ý để đáo hạn an toàn</h2>
<ul>
<li>Chỉ giao dịch trực tiếp, có hoá đơn; không chuyển khoản đặt cọc cho người lạ.</li>
<li>Thẻ luôn nằm trong tầm mắt bạn trong suốt quá trình.</li>
<li>Kiểm tra dư nợ đã được thanh toán trên app ngân hàng trước khi thực hiện bước tiếp theo.</li>
<li>Nên liên hệ trước ngày đến hạn 1–3 ngày để chủ động thời gian.</li>
</ul>
<h2 id="theo-ngan-hang">Đáo hạn theo ngân hàng</h2>
<p>Xem hướng dẫn riêng cho thẻ của bạn:</p>
<div class="banks" style="justify-content:flex-start">{{BANK_LINKS}}</div>
<p>Tìm hiểu kỹ hơn: <a href="{{R}}kien-thuc/dao-han-the-tin-dung-la-gi/">Đáo hạn thẻ tín dụng là gì? Có nên đáo hạn không?</a></p>
""",
},
# ---------------------------------------------------------------- RÚT TIỀN
{
"slug": "rut-tien-the-tin-dung-da-nang",
"crumb": "Rút tiền thẻ tín dụng Đà Nẵng",
"title": f"Rút Tiền Thẻ Tín Dụng Đà Nẵng ✔️ Phí Thấp, Nhận Tiền 15 Phút",
"desc": "Rút tiền thẻ tín dụng Đà Nẵng phí thấp hơn rút ATM, nhận tiền mặt hoặc chuyển khoản trong 15 phút, tận nơi mọi quận. Zalo 0909 669 325.",
"h1": "Rút Tiền Thẻ Tín Dụng Đà Nẵng – Phí Thấp, Nhận Tiền Trong 15 Phút",
"intro": "Cần tiền mặt gấp cho kinh doanh, viện phí, học phí? Chuyển hạn mức thẻ tín dụng thành tiền mặt nhanh chóng, phí thấp hơn rút tại ATM, có mặt tận nơi khắp Đà Nẵng.",
"related": ["bang-phi", "dao-han-the-tin-dung-da-nang", "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu"],
"faqs": [
    ("Rút tiền thẻ tín dụng ở Đà Nẵng phí bao nhiêu?", "Phí phụ thuộc số tiền, xem bảng phí trên trang hoặc nhắn Zalo để được báo chính xác."),
    ("Rút tiền tại ATM bằng thẻ tín dụng có được không?", "Được, nhưng ngân hàng thường thu phí ứng tiền mặt khoảng 3–4% và tính lãi ngay từ ngày rút, không có thời gian miễn lãi."),
    ("Nhận tiền bằng cách nào?", "Nhận tiền mặt trực tiếp hoặc chuyển khoản vào tài khoản chính chủ, tùy bạn chọn."),
    ("Có rút được toàn bộ hạn mức không?", "Có thể hỗ trợ theo hạn mức khả dụng của thẻ. Nhắn Zalo để được tư vấn số tiền phù hợp."),
],
"body": """
<p><strong>Rút tiền thẻ tín dụng Đà Nẵng</strong> giúp bạn sử dụng hạn mức tín dụng như một khoản tiền mặt linh hoạt khi cần gấp. Thay vì rút tại ATM với phí cao và bị tính lãi ngay, dịch vụ giúp bạn nhận tiền nhanh, chi phí rõ ràng và vẫn tận dụng được chu kỳ thanh toán của thẻ.</p>

<h2 id="so-sanh">Rút tại ATM và dùng dịch vụ: khác nhau thế nào?</h2>
<div class="tbl"><table><thead><tr><th>Tiêu chí</th><th>Rút tại ATM/ngân hàng</th><th>Dịch vụ của chúng tôi</th></tr></thead><tbody>
<tr><td>Phí</td><td>Khoảng 3–4% số tiền rút</td><td class="fee">Từ {{FEE_MIN}}</td></tr>
<tr><td>Lãi</td><td>Tính lãi ngay từ ngày rút</td><td>Theo chu kỳ thẻ</td></tr>
<tr><td>Hạn mức</td><td>Thường giới hạn 50–70% hạn mức</td><td>Theo hạn mức khả dụng</td></tr>
<tr><td>Thời gian</td><td>Phụ thuộc giờ làm việc</td><td>15 phút, 7h30–21h00 cả tuần</td></tr>
</tbody></table></div>
<p style="font-size:.88rem;color:#5a6785">Mức phí ATM là tham khảo phổ biến trên thị trường, mỗi ngân hàng có biểu phí riêng.</p>

<h2 id="khi-nao">Khi nào nên rút tiền từ thẻ tín dụng?</h2>
<ul>
<li>Cần vốn lưu động ngắn hạn cho kinh doanh, nhập hàng.</li>
<li>Chi phí khẩn cấp: viện phí, học phí, sửa chữa nhà, xe.</li>
<li>Khoản thu sắp về nhưng cần tiền ngay hôm nay.</li>
</ul>
<div class="box navy"><p><strong>Lời khuyên:</strong> chỉ rút số tiền bạn chắc chắn trả được trong kỳ sao kê tới. Thẻ tín dụng là công cụ tài chính ngắn hạn, không nên dùng như khoản vay dài hạn.</p></div>

<h2 id="quy-trinh">Quy trình rút tiền thẻ tín dụng</h2>
<ol>
<li>Nhắn Zalo <strong>0909 669 325</strong>: ngân hàng, số tiền cần rút.</li>
<li>Nhận báo phí trọn gói, đồng ý mới thực hiện.</li>
<li>Thực hiện giao dịch tại cửa hàng hoặc tận nơi, thẻ không rời tay bạn.</li>
<li>Nhận tiền mặt hoặc chuyển khoản vào tài khoản chính chủ, kèm hoá đơn.</li>
</ol>

<h2 id="bang-phi">Bảng phí rút tiền thẻ tín dụng</h2>
{{FEE_TABLE}}

<h2 id="khu-vuc">Hỗ trợ tận nơi khắp Đà Nẵng</h2>
<p>Phục vụ tận nhà, văn phòng, cửa hàng tại <strong>""" + AREAS + """</strong>. Nhắn vị trí qua Zalo, nhân viên có mặt trong khoảng 20–30 phút.</p>
""",
},
# ---------------------------------------------------------------- BẢNG PHÍ
{
"slug": "bang-phi",
"crumb": "Bảng phí",
"title": f"Bảng Phí Đáo Hạn, Rút Tiền Thẻ Tín Dụng Đà Nẵng 2026 – Từ {FEE_MIN}",
"desc": f"Bảng phí đáo hạn và rút tiền thẻ tín dụng tại Đà Nẵng cập nhật 2026, phí từ {FEE_MIN}, không phí ẩn. So sánh với phí trễ hạn và phí rút ATM.",
"h1": "Bảng Phí Đáo Hạn & Rút Tiền Thẻ Tín Dụng Đà Nẵng 2026",
"intro": f"Phí minh bạch từ {FEE_MIN}, báo trước khi làm, không phát sinh. So sánh nhanh để thấy vì sao đáo hạn đúng lúc giúp bạn tiết kiệm.",
"related": ["dao-han-the-tin-dung-da-nang", "rut-tien-the-tin-dung-da-nang", "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu"],
"faqs": [
    ("Phí đã bao gồm công đến tận nơi chưa?", "Đã bao gồm trong nội thành Đà Nẵng. Khu vực xa sẽ được báo trước khi thực hiện."),
    ("Có phí ẩn nào không?", "Không. Bạn nhận báo phí trọn gói trước, đồng ý mới thực hiện, có hoá đơn cho từng giao dịch."),
    ("Số tiền lớn có được giảm phí không?", "Có. Giao dịch trên 100 triệu hoặc khách hàng thường xuyên được áp dụng mức phí thoả thuận tốt hơn."),
],
"body": """
<h2 id="bang-phi-chinh">Bảng phí dịch vụ (cập nhật {{UPDATED}})</h2>
{{FEE_TABLE}}
<p>Mức phí áp dụng cho thẻ Visa, Mastercard, JCB, Amex, Napas của hầu hết ngân hàng. Một số dòng thẻ đặc biệt có thể chênh lệch nhẹ – bạn luôn được báo trước.</p>

<h2 id="vi-du">Ví dụ chi phí thực tế</h2>
{{EXAMPLE_TABLE}}
<p style="font-size:.88rem;color:#5a6785">* Ước tính lãi 28%/năm trên toàn bộ dư nợ trong 30 ngày + phí phạt 5% khoản thanh toán tối thiểu (tối thiểu 99.000đ). Mức thực tế theo biểu phí từng ngân hàng.</p>

<h2 id="so-sanh">So sánh các lựa chọn khi thẻ đến hạn</h2>
<div class="tbl"><table><thead><tr><th>Lựa chọn</th><th>Chi phí</th><th>Ảnh hưởng CIC</th></tr></thead><tbody>
<tr><td>Đáo hạn qua dịch vụ</td><td class="fee">Từ {{FEE_MIN}}, một lần</td><td>Không – thanh toán đúng hạn</td></tr>
<tr><td>Chỉ trả tối thiểu</td><td>Lãi 25–35%/năm trên toàn bộ dư nợ</td><td>Không, nhưng nợ tăng nhanh</td></tr>
<tr><td>Để trễ hạn</td><td>Phí phạt + lãi trên toàn bộ dư nợ</td><td>Có nguy cơ ghi nhận nợ xấu</td></tr>
<tr><td>Rút ATM để trả</td><td>Phí ứng tiền 3–4% + lãi ngay</td><td>Không, nhưng chi phí cao</td></tr>
</tbody></table></div>
<p>Muốn tính nhanh theo số dư của bạn? Dùng <a href="{{R}}#tinh-phi">công cụ tính tiền phạt trễ hạn</a> trên trang chủ.</p>
""",
},
# ---------------------------------------------------------------- KIẾN THỨC (hub)
{
"slug": "kien-thuc",
"crumb": "Kiến thức",
"title": "Kiến Thức Thẻ Tín Dụng – Hướng Dẫn Đáo Hạn, Tránh Phí Phạt, Nợ Xấu",
"desc": "Chia sẻ kiến thức thẻ tín dụng dễ hiểu: đáo hạn là gì, ngày sao kê và ngày đến hạn, trả chậm bị phạt bao nhiêu, cách giữ điểm tín dụng đẹp.",
"h1": "Kiến Thức Thẻ Tín Dụng – Dùng Thẻ Thông Minh, Không Lo Phí Phạt",
"intro": "Những bài viết ngắn gọn, dễ hiểu giúp bạn dùng thẻ tín dụng hiệu quả, tránh phí phạt và giữ lịch sử tín dụng đẹp.",
"body": """
<h2 id="bai-viet">Bài viết mới nhất</h2>
<div class="related">{{POSTS}}</div>
""",
},
# ---------------------------------------------------------------- BÀI 1
{
"slug": "kien-thuc/dao-han-the-tin-dung-la-gi",
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Đáo hạn thẻ tín dụng là gì?",
"article": True, "icon": "?",
"title": "Đáo Hạn Thẻ Tín Dụng Là Gì? Có Nên Đáo Hạn Không? (2026)",
"desc": "Giải thích dễ hiểu đáo hạn thẻ tín dụng là gì, cách hoạt động, chi phí, lợi ích và rủi ro, khi nào nên và không nên đáo hạn thẻ.",
"h1": "Đáo Hạn Thẻ Tín Dụng Là Gì? Có Nên Đáo Hạn Không?",
"intro": "Hiểu đúng về đáo hạn thẻ tín dụng trong 3 phút: cách hoạt động, chi phí thật sự và khi nào thì nên dùng.",
"related": ["dao-han-the-tin-dung-da-nang", "kien-thuc/ngay-sao-ke-va-ngay-den-han", "bang-phi"],
"faqs": [
    ("Đáo hạn thẻ tín dụng có hợp pháp không?", "Thanh toán dư nợ thẻ đúng hạn là việc bình thường. Bạn nên chọn đơn vị giao dịch minh bạch, có hoá đơn và chỉ dùng thẻ chính chủ."),
    ("Bao lâu nên đáo hạn một lần?", "Chỉ khi cần – tức là khi đến hạn mà chưa đủ tiền thanh toán. Tốt nhất vẫn là chủ động trả nợ từ thu nhập."),
],
"body": """
<p><strong>Đáo hạn thẻ tín dụng</strong> là việc thanh toán toàn bộ dư nợ thẻ trước hoặc đúng ngày đến hạn bằng một nguồn tiền tạm thời, sau đó chủ thẻ sử dụng lại hạn mức vừa được khôi phục để hoàn trả nguồn tiền đó. Về bản chất, bạn “dời” khoản nợ sang chu kỳ sao kê tiếp theo mà không bị phạt.</p>

<h2 id="cach-hoat-dong">Đáo hạn hoạt động như thế nào?</h2>
<p>Ví dụ: thẻ hạn mức 50 triệu, dư nợ 20 triệu đến hạn ngày 15.</p>
<ol>
<li>Ngày 14, đơn vị đáo hạn nộp 20 triệu vào thẻ → dư nợ về 0, hạn mức khả dụng trở lại 50 triệu.</li>
<li>Bạn thực hiện giao dịch 20 triệu (+ phí) bằng thẻ để hoàn trả.</li>
<li>Khoản 20 triệu mới rơi vào kỳ sao kê sau, bạn có thêm 45–55 ngày để thanh toán.</li>
</ol>

<h2 id="loi-ich">Lợi ích của đáo hạn</h2>
<ul>
<li>Tránh phí chậm thanh toán và lãi suất 25–35%/năm trên toàn bộ dư nợ.</li>
<li>Giữ lịch sử tín dụng (CIC) sạch, thuận lợi khi vay mua nhà, mua xe.</li>
<li>Có thêm thời gian xoay xở tài chính mà không cần vay nóng.</li>
</ul>

<h2 id="rui-ro">Rủi ro cần biết</h2>
<ul>
<li><strong>Đáo hạn liên tục</strong> nhiều kỳ khiến phí cộng dồn – chỉ nên dùng như giải pháp tạm thời.</li>
<li><strong>Chọn sai đơn vị</strong> có thể gặp lừa đảo: yêu cầu đặt cọc, giữ thẻ, hỏi OTP. Đơn vị uy tín không bao giờ làm vậy.</li>
</ul>
<div class="box"><p>Nguyên tắc vàng: <strong>chỉ đáo hạn khi tổng phí thấp hơn chi phí trễ hạn</strong>, và có kế hoạch trả hết dư nợ trong 1–2 kỳ tới.</p></div>

<h2 id="khi-nao-nen">Khi nào nên đáo hạn?</h2>
<ul>
<li>Đến hạn nhưng tiền lương/tiền hàng về sau vài ngày.</li>
<li>Dư nợ lớn, nếu trễ hạn tiền lãi + phạt sẽ cao hơn phí đáo hạn.</li>
<li>Bạn sắp vay ngân hàng và cần hồ sơ tín dụng đẹp.</li>
</ul>
<p>Ở Đà Nẵng, bạn có thể <a href="{{R}}dao-han-the-tin-dung-da-nang/">đáo hạn thẻ tín dụng tận nơi trong 15 phút</a> với phí từ {{FEE_MIN}}.</p>
""",
},
# ---------------------------------------------------------------- BÀI 2
{
"slug": "kien-thuc/ngay-sao-ke-va-ngay-den-han",
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Ngày sao kê và ngày đến hạn",
"article": True, "icon": "📅",
"title": "Ngày Sao Kê Và Ngày Đến Hạn Thẻ Tín Dụng: Cách Tính Để Không Bị Phạt",
"desc": "Phân biệt ngày sao kê, ngày đến hạn thanh toán thẻ tín dụng, cách tính 45–55 ngày miễn lãi và mẹo chọn thời điểm chi tiêu thông minh.",
"h1": "Ngày Sao Kê Và Ngày Đến Hạn Thẻ Tín Dụng – Hiểu Đúng Để Không Bị Phạt",
"intro": "Nắm rõ hai mốc ngày quan trọng nhất của thẻ tín dụng để tận dụng tối đa thời gian miễn lãi và không bao giờ trễ hạn.",
"related": ["kien-thuc/dao-han-the-tin-dung-la-gi", "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu", "dao-han-the-tin-dung-da-nang"],
"body": """
<h2 id="ngay-sao-ke">Ngày sao kê là gì?</h2>
<p><strong>Ngày sao kê</strong> là ngày ngân hàng chốt toàn bộ giao dịch trong một chu kỳ (thường 30 ngày) và gửi bảng sao kê cho bạn. Mọi khoản chi tiêu sau ngày này sẽ được tính sang kỳ tiếp theo.</p>

<h2 id="ngay-den-han">Ngày đến hạn thanh toán là gì?</h2>
<p><strong>Ngày đến hạn</strong> thường cách ngày sao kê khoảng 15–25 ngày, tùy ngân hàng. Đây là hạn cuối để bạn thanh toán dư nợ trên sao kê. Thanh toán đủ trước ngày này → không bị tính lãi.</p>

<figure>
<svg viewBox="0 0 640 150" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Dòng thời gian chu kỳ thẻ tín dụng">
<g font-family="Be Vietnam Pro,Arial" font-size="13" text-anchor="middle">
<rect x="30" y="60" width="380" height="14" rx="7" fill="#13306b"/><rect x="410" y="60" width="200" height="14" rx="7" fill="#ff7a00"/>
<circle cx="30" cy="67" r="10" fill="#13306b"/><text x="40" y="40" fill="#0b1f44" font-weight="700">Giao dịch đầu kỳ</text>
<circle cx="410" cy="67" r="12" fill="#fff" stroke="#13306b" stroke-width="4"/><text x="410" y="40" fill="#0b1f44" font-weight="700">Ngày sao kê</text>
<circle cx="610" cy="67" r="12" fill="#fff" stroke="#ff7a00" stroke-width="4"/><text x="590" y="40" fill="#d65f00" font-weight="700">Ngày đến hạn</text>
<text x="220" y="105" fill="#5a6785">Chu kỳ chi tiêu ~30 ngày</text><text x="510" y="105" fill="#5a6785">15–25 ngày để thanh toán</text>
<text x="320" y="138" fill="#0b1f44" font-weight="700">Tổng tối đa 45–55 ngày miễn lãi</text>
</g></svg>
<figcaption>Chi tiêu càng sát đầu kỳ sao kê, thời gian miễn lãi càng dài</figcaption>
</figure>

<h2 id="meo">Mẹo tận dụng thời gian miễn lãi</h2>
<ul>
<li>Chi tiêu lớn ngay <strong>sau ngày sao kê</strong> để có thời gian miễn lãi dài nhất.</li>
<li>Cài nhắc nhở trên điện thoại trước ngày đến hạn 3 ngày.</li>
<li>Đăng ký trích nợ tự động từ tài khoản thanh toán nếu có thu nhập ổn định.</li>
<li>Nếu đến hạn mà chưa đủ tiền, <a href="{{R}}dao-han-the-tin-dung-da-nang/">đáo hạn thẻ</a> thay vì để trễ hạn.</li>
</ul>
<div class="box navy"><p>Lưu ý: rút tiền mặt tại ATM bằng thẻ tín dụng <strong>không được miễn lãi</strong> – lãi tính ngay từ ngày rút.</p></div>
""",
},
# ---------------------------------------------------------------- BÀI 3
{
"slug": "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu",
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Trả chậm thẻ tín dụng bị phạt bao nhiêu?",
"article": True, "icon": "⚠",
"title": "Trả Chậm Thẻ Tín Dụng Bị Phạt Bao Nhiêu? Có Bị Nợ Xấu Không?",
"desc": "Trả chậm thẻ tín dụng 1 ngày bị phạt bao nhiêu, lãi tính thế nào, bao lâu thì bị nợ xấu CIC và cách xử lý khi lỡ trễ hạn.",
"h1": "Trả Chậm Thẻ Tín Dụng Bị Phạt Bao Nhiêu? Có Bị Nợ Xấu Không?",
"intro": "Chỉ một ngày trễ hạn có thể khiến bạn mất nhiều hơn bạn nghĩ. Đây là cách các khoản phạt được tính và cách xử lý kịp thời.",
"related": ["bang-phi", "dao-han-the-tin-dung-da-nang", "kien-thuc/ngay-sao-ke-va-ngay-den-han"],
"faqs": [
    ("Trễ hạn thẻ tín dụng 1 ngày có bị nợ xấu không?", "Thường chưa bị ghi nợ xấu ngay, nhưng vẫn bị phí phạt và lãi. Trễ từ 10 ngày trở lên có thể bị ghi nhận nợ cần chú ý trên CIC."),
    ("Đã trễ hạn rồi thì làm gì?", "Thanh toán càng sớm càng tốt (ít nhất khoản tối thiểu) để dừng phát sinh phạt, sau đó liên hệ ngân hàng nếu cần."),
],
"body": """
<h2 id="cac-khoan-phat">Các khoản bạn phải trả khi trễ hạn</h2>
<h3>1. Phí chậm thanh toán</h3>
<p>Thường khoảng <strong>4–6% số tiền thanh toán tối thiểu</strong>, có mức tối thiểu (vài chục đến vài trăm nghìn đồng) và mức tối đa tùy ngân hàng.</p>
<h3>2. Lãi trên toàn bộ dư nợ</h3>
<p>Đây là khoản nhiều người không biết: khi không thanh toán đủ, ngân hàng tính lãi <strong>25–35%/năm trên toàn bộ dư nợ sao kê</strong>, kể từ ngày phát sinh từng giao dịch – không chỉ trên phần còn thiếu.</p>
<h3>3. Ảnh hưởng điểm tín dụng</h3>
<p>Trễ hạn kéo dài sẽ được ghi nhận trên hệ thống CIC, khiến bạn khó vay vốn, mở thẻ mới hoặc bị giảm hạn mức.</p>

<h2 id="vi-du">Ví dụ cụ thể</h2>
<p>Dư nợ sao kê 20.000.000đ, bạn trễ hạn 30 ngày (lãi 28%/năm, phí phạt 5% tối thiểu):</p>
<ul>
<li>Lãi: 20.000.000 × 28% × 30/365 ≈ <strong>460.000đ</strong></li>
<li>Phí phạt: tối thiểu ≈ <strong>99.000đ</strong></li>
<li>Tổng ≈ <strong>560.000đ</strong> – chưa kể ảnh hưởng tín dụng.</li>
</ul>
<p>So với phí đáo hạn 20 triệu theo <a href="{{R}}bang-phi/">bảng phí</a>, đáo hạn đúng lúc thường rẻ hơn và không ảnh hưởng CIC.</p>

<h2 id="nhom-no">Các nhóm nợ trên CIC</h2>
<div class="tbl"><table><thead><tr><th>Nhóm</th><th>Số ngày quá hạn</th><th>Ý nghĩa</th></tr></thead><tbody>
<tr><td>Nhóm 1</td><td>Dưới 10 ngày</td><td>Nợ đủ tiêu chuẩn</td></tr>
<tr><td>Nhóm 2</td><td>10 – 90 ngày</td><td>Nợ cần chú ý</td></tr>
<tr><td>Nhóm 3–5</td><td>Trên 90 ngày</td><td>Nợ xấu</td></tr>
</tbody></table></div>

<h2 id="xu-ly">Cách xử lý khi sắp hoặc đã trễ hạn</h2>
<ol>
<li><strong>Sắp đến hạn:</strong> <a href="{{R}}dao-han-the-tin-dung-da-nang/">đáo hạn thẻ</a> để thanh toán đủ, tránh toàn bộ phí phạt.</li>
<li><strong>Đã trễ vài ngày:</strong> thanh toán ngay để dừng phát sinh, tránh rơi vào nhóm 2.</li>
<li><strong>Khó khăn kéo dài:</strong> liên hệ ngân hàng để chuyển đổi trả góp dư nợ.</li>
</ol>
""",
},
]


# ---------------------------------------------------------------- TRANG THEO NGÂN HÀNG
# (slug, tên, tên đầy đủ, app ngân hàng, ghi chú riêng)
BANKS = [
    ("vietcombank", "Vietcombank", "Ngân hàng TMCP Ngoại thương Việt Nam", "VCB Digibank", ""),
    ("vietinbank", "VietinBank", "Ngân hàng TMCP Công Thương Việt Nam", "VietinBank iPay",
     'Biểu phí chính thức: <a href="https://www.vietinbank.vn/ca-nhan/cong-cu-tien-ich/bieu-phi-va-bieu-mau/bieu-phi-dich-vu-ap-dung-cho-san-pham-the-tin-dung-quoc-te-40-html" rel="nofollow noopener" target="_blank">biểu phí thẻ tín dụng quốc tế VietinBank</a>.'),
    ("bidv", "BIDV", "Ngân hàng TMCP Đầu tư và Phát triển Việt Nam", "BIDV SmartBanking", ""),
    ("techcombank", "Techcombank", "Ngân hàng TMCP Kỹ Thương Việt Nam", "Techcombank Mobile",
     'Biểu phí chính thức: <a href="https://techcombank.com/content/dam/techcombank/public-site/documents/techcombank-bieu-phi-dich-vu-the-tin-dung-cho-khach-hang-thuong.pdf" rel="nofollow noopener" target="_blank">biểu phí dịch vụ thẻ tín dụng Techcombank (PDF)</a>.'),
    ("vpbank", "VPBank", "Ngân hàng TMCP Việt Nam Thịnh Vượng", "VPBank NEO", ""),
    ("mb-bank", "MB Bank", "Ngân hàng TMCP Quân đội", "MB Bank", ""),
    ("acb", "ACB", "Ngân hàng TMCP Á Châu", "ACB ONE", ""),
    ("sacombank", "Sacombank", "Ngân hàng TMCP Sài Gòn Thương Tín", "Sacombank Pay", ""),
    ("tpbank", "TPBank", "Ngân hàng TMCP Tiên Phong", "TPBank Mobile", ""),
    ("vib", "VIB", "Ngân hàng TMCP Quốc tế Việt Nam", "MyVIB",
     'Ví dụ: với thẻ VIB Financial Free, phí chậm thanh toán là 6% số tiền chậm thanh toán (tối thiểu 200.000đ, tối đa 2.000.000đ) – theo <a href="https://www.vib.com.vn/vn/the-tin-dung/vib-financial-free/bieu-phi-va-dieu-kien" rel="nofollow noopener" target="_blank">biểu phí VIB</a>.'),
]


def bank_page(key, name, full, app, note):
    others = "".join(f'<a href="{{{{R}}}}dao-han-the-{k}-da-nang/" class="bank">{n}</a>' for k, n, *_ in BANKS if k != key)
    return {
        "slug": f"dao-han-the-{key}-da-nang",
        "parents": [("dao-han-the-tin-dung-da-nang", "Đáo hạn thẻ tín dụng Đà Nẵng")],
        "crumb": f"Đáo hạn thẻ {name}",
        "bank": True,
        "title": f"Đáo Hạn Thẻ Tín Dụng {name} Tại Đà Nẵng ✔️ Phí Từ {FEE_MIN}, 15 Phút",
        "desc": f"Đáo hạn, rút tiền thẻ tín dụng {name} tại Đà Nẵng: phí từ {FEE_MIN}, xong 15 phút, tận nơi mọi quận. Hướng dẫn xem ngày đến hạn trên {app}. Zalo 0909 669 325.",
        "h1": f"Đáo Hạn Thẻ Tín Dụng {name} Tại Đà Nẵng",
        "intro": f"Thẻ {name} sắp đến hạn? Hỗ trợ đáo hạn và rút tiền thẻ tín dụng {name} (Visa, Mastercard, JCB…) trong 15 phút, tại cửa hàng hoặc tận nơi khắp Đà Nẵng.",
        "related": ["dao-han-the-tin-dung-da-nang", "bang-phi", "kien-thuc/ngay-sao-ke-va-ngay-den-han"],
        "faqs": [
            (f"Đáo hạn thẻ {name} mất bao lâu?", "Khoảng 15–30 phút kể từ khi bắt đầu giao dịch, tại cửa hàng hoặc tận nơi trong nội thành Đà Nẵng."),
            (f"Phí đáo hạn thẻ {name} là bao nhiêu?", f"Từ {FEE_MIN} tùy số tiền, áp dụng chung cho thẻ {name}. Nhắn Zalo để được báo phí trọn gói."),
            (f"Làm sao biết ngày đến hạn thẻ {name}?", f"Mở ứng dụng {app}, vào mục Thẻ → chọn thẻ tín dụng → xem sao kê, hoặc xem email/SMS sao kê hằng tháng của {name}."),
            (f"Đáo hạn có ảnh hưởng đến thẻ {name} của tôi không?", f"Không. Dư nợ được thanh toán đúng hạn nên lịch sử tín dụng với {name} và trên CIC luôn tốt."),
        ],
        "body": f"""
<p>Bạn đang dùng thẻ tín dụng <strong>{name}</strong> ({full}) và sắp đến kỳ thanh toán nhưng chưa xoay kịp tiền? Dịch vụ <strong>đáo hạn thẻ {name} tại Đà Nẵng</strong> giúp bạn thanh toán đủ dư nợ trước ngày đến hạn, tránh phí chậm thanh toán và lãi trên toàn bộ dư nợ, đồng thời có thêm một chu kỳ miễn lãi.</p>

<h2 id="xem-han">Cách xem ngày đến hạn thẻ {name}</h2>
<ol>
<li>Mở ứng dụng <strong>{app}</strong> và đăng nhập.</li>
<li>Vào mục <strong>Thẻ</strong>, chọn thẻ tín dụng {name} của bạn.</li>
<li>Xem <strong>sao kê kỳ gần nhất</strong>: dư nợ sao kê, số tiền thanh toán tối thiểu và ngày đến hạn.</li>
</ol>
<div class="box"><p>Mẹo: đặt nhắc lịch trước ngày đến hạn 3 ngày. Nếu chưa đủ tiền, nhắn Zalo sớm để được xếp lịch ưu tiên.</p></div>

<h2 id="tre-han">Nếu để thẻ {name} trễ hạn thì sao?</h2>
<p>Như hầu hết ngân hàng, {name} sẽ thu <strong>phí chậm thanh toán</strong> và tính <strong>lãi trên toàn bộ dư nợ sao kê</strong> khi bạn không thanh toán đủ đúng hạn; trễ kéo dài có thể bị ghi nhận trên CIC. {note or f"Mức phí cụ thể xem tại biểu phí chính thức trên website {name}."}</p>
<p>Xem ví dụ chi phí trễ hạn tại bài <a href="{{{{R}}}}kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu/">Trả chậm thẻ tín dụng bị phạt bao nhiêu?</a></p>

<h2 id="quy-trinh">Quy trình đáo hạn thẻ {name} tại Đà Nẵng</h2>
<ol>
<li>Nhắn Zalo <strong>0909 669 325</strong>: “Đáo hạn thẻ {name}, số tiền …, đến hạn ngày …”.</li>
<li>Nhận báo phí trọn gói – đồng ý mới thực hiện.</li>
<li>Chúng tôi thanh toán dư nợ vào thẻ {name}; bạn kiểm tra ngay trên {app}.</li>
<li>Bạn hoàn trả bằng hạn mức vừa được khôi phục, nhận hoá đơn đầy đủ.</li>
</ol>

<h2 id="bang-phi">Phí đáo hạn, rút tiền thẻ {name}</h2>
{{{{FEE_TABLE}}}}

<h2 id="ngan-hang-khac">Hỗ trợ cả thẻ ngân hàng khác</h2>
<div class="banks" style="justify-content:flex-start">{others}</div>
""",
    }


PAGES += [bank_page(*b) for b in BANKS]


if __name__ == "__main__":
    for p in PAGES:
        build_page(p)
    build_index()
    build_sitemap()
    print("Built", len(PAGES) + 1, "pages")
