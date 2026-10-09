#!/usr/bin/env python3
"""Tạo toàn bộ trang HTML tĩnh cho the-tin-dung-da-nang.com.

Cách dùng:  python3 build.py
- Sửa giá ở FEES, thông tin liên hệ ở SITE.
- Nội dung trang chủ: src/pages/index.body.html (+ src/index.head.html).
- Nội dung trang con: PAGES bên dưới.
Kết quả ghi đè index.html, các thư mục trang con và sitemap.xml.
"""
import html, json, os, re

HERE = os.path.dirname(os.path.abspath(__file__))
DOMAIN = "https://www.the-tin-dung-da-nang.com/"
SISTER = "https://www.dichvuthetindungdanang.com/"  # web cũ (trang đang xếp hạng), liên kết qua lại
UPDATED = "2026-10-05"  # ngày cập nhật hiển thị + dateModified

SITE = {
    "name": "Dịch Vụ Thẻ Tín Dụng Đà Nẵng – Vân Trần",
    "short": "Thẻ Tín Dụng Vân Trần",
    "phone": "0909669325",
    "phone_text": "0909 669 325",
    "email": "Km.camvan@gmail.com",
    "brand": "VT – Vân Trần",
    "street": "Đường Nguyễn Thị Minh Khai",
    "address": "Đường Nguyễn Thị Minh Khai, Đà Nẵng",
    "maps": "https://www.google.com/maps/search/?api=1&query=Nguy%E1%BB%85n+Th%E1%BB%8B+Minh+Khai+%C4%90%C3%A0+N%E1%BA%B5ng",
    # Ảnh chính (đã có trên LadiPage, dùng cho ảnh chia sẻ + dữ liệu Google)
    "image": "https://static.ladipage.net/5f03d62c83e96d333758e1a6/dich-vu-the-tin-dung-da-nang-20250607094115-lh3ye.png",
    "image_alt": "Dịch vụ thẻ tín dụng Đà Nẵng – rút tiền, đáo hạn, mở thẻ nhanh",
}

# ===== BẢNG PHÍ – SỬA GIÁ Ở ĐÂY =====
# (loại thẻ, phí đáo hạn, phí rút tiền)
FEES = [
    ("Thẻ Visa (trừ Sacombank, VPBank)", "1,9%", "1,8%"),
    ("Thẻ JCB, Mastercard (trừ Sacombank, VPBank)", "2,0%", "1,9%"),
    ("Thẻ Sacombank, VPBank", "2,1%", "1,9%"),
]
FEE_MIN = "1,9%"        # phí đáo hạn thấp nhất
FEE_MIN_RUT = "1,8%"    # phí rút tiền thấp nhất
FEE_SPECIAL = FEES[2][1]  # phí đáo hạn thẻ Sacombank, VPBank
SPECIAL_BANKS = ("sacombank", "vpbank")


AREA_LIST = ["Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn", "Liên Chiểu", "Cẩm Lệ", "Hòa Vang", "Điện Bàn"]
HOURS = "7h30 – 21h00, tất cả các ngày trong tuần (kể cả cuối tuần, lễ Tết)"
BUSINESS_ID = DOMAIN + "#business"


def business_schema():
    """Thực thể doanh nghiệp dùng chung – giúp Google/ChatGPT nhận diện một thương hiệu nhất quán."""
    return {
        "@context": "https://schema.org", "@type": "FinancialService", "@id": BUSINESS_ID,
        "name": SITE["name"], "url": DOMAIN, "image": SITE["image"], "logo": SITE["image"],
        "alternateName": [SITE["brand"], "Vân Trần", "Thẻ Tín Dụng Vân Trần", "Dịch vụ rút tiền thẻ tín dụng Đà Nẵng", "Đáo hạn thẻ tín dụng Đà Nẵng"],
        "hasMap": SITE["maps"], "sameAs": ["https://zalo.me/" + SITE["phone"], SISTER],
        "description": f"Dịch vụ đáo hạn thẻ tín dụng, rút tiền thẻ tín dụng và tư vấn mở thẻ tại Đà Nẵng. Phí từ {FEE_MIN}, xử lý khoảng 15 phút, hỗ trợ tận nơi.",
        "telephone": "+84909669325", "email": SITE["email"], "priceRange": f"Phí từ {FEE_MIN}",
        "address": {"@type": "PostalAddress", "streetAddress": SITE["street"], "addressLocality": "Đà Nẵng", "addressRegion": "Đà Nẵng", "addressCountry": "VN"},
        "areaServed": [{"@type": "Place", "name": a + ", Đà Nẵng"} for a in AREA_LIST],
        "openingHoursSpecification": [{"@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            "opens": "07:30", "closes": "21:00"}],
        "contactPoint": [{"@type": "ContactPoint", "telephone": "+84909669325", "contactType": "customer service",
                          "availableLanguage": "Vietnamese", "areaServed": "VN"}],
        "knowsAbout": ["Đáo hạn thẻ tín dụng", "Rút tiền thẻ tín dụng", "Thẻ tín dụng", "Phí trả chậm thẻ tín dụng", "Điểm tín dụng CIC"],
        "makesOffer": [
            {"@type": "Offer", "url": DOMAIN + "dao-han-the-tin-dung-da-nang/", "description": f"Phí từ {FEE_MIN}",
             "itemOffered": {"@type": "Service", "name": "Đáo hạn thẻ tín dụng Đà Nẵng"}},
            {"@type": "Offer", "url": DOMAIN + "rut-tien-the-tin-dung-da-nang/", "description": f"Phí từ {FEE_MIN_RUT}",
             "itemOffered": {"@type": "Service", "name": "Rút tiền thẻ tín dụng Đà Nẵng"}},
            {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Tư vấn mở thẻ tín dụng"}, "description": "Miễn phí"},
        ],
    }


THUMB_ICONS = {
    "question": '<circle cx="200" cy="60" r="34" fill="#ff7a00"/><text x="200" y="75" text-anchor="middle" font-family="Be Vietnam Pro,Arial" font-weight="800" font-size="44" fill="#fff">?</text>',
    "calendar": '<rect x="166" y="30" width="68" height="62" rx="10" fill="#fff"/><rect x="166" y="30" width="68" height="18" rx="9" fill="#ff7a00"/><rect x="166" y="40" width="68" height="8" fill="#ff7a00"/>'
                '<rect x="180" y="22" width="6" height="16" rx="3" fill="#ff9a3c"/><rect x="214" y="22" width="6" height="16" rx="3" fill="#ff9a3c"/>'
                '<text x="200" y="83" text-anchor="middle" font-family="Be Vietnam Pro,Arial" font-weight="800" font-size="26" fill="#0b1f44">15</text>',
    "warning": '<path d="M200 24L240 94H160Z" fill="#ff7a00" stroke="#ff7a00" stroke-width="8" stroke-linejoin="round"/>'
               '<rect x="196" y="46" width="8" height="26" rx="4" fill="#fff"/><circle cx="200" cy="82" r="5" fill="#fff"/>',
}


def thumb_svg(key):
    """Ảnh đầu thẻ bài viết: SVG tự căn giữa (giữ đúng bố cục khi chuyển sang LadiPage)."""
    return ('<svg class="thumb" viewBox="0 0 400 120" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
            '<defs><linearGradient id="tg-' + key + '" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#0b1f44"/><stop offset="1" stop-color="#1d4391"/></linearGradient></defs>'
            '<rect width="400" height="120" fill="url(#tg-' + key + ')"/><circle cx="200" cy="60" r="52" fill="#fff" opacity=".06"/>'
            + THUMB_ICONS.get(key, THUMB_ICONS["question"]) + "</svg>")


def short(text, n):
    """Cắt mô tả ở ranh giới từ, không cắt giữa chữ."""
    return text if len(text) <= n else text[:n].rsplit(" ", 1)[0].rstrip(",.;:–-") + "…"


def tldr_html(items):
    if not items:
        return ""
    li = "".join(f"<li>{x}</li>" for x in items)
    return f'<div class="tldr"><b>Trả lời nhanh</b><ul>{li}</ul></div>'


def read(p):
    with open(os.path.join(HERE, p), encoding="utf-8") as f:
        return f.read()


HL = '<span class="hl">{}</span>'
# Tiêu đề H2 chứa từ khoá chính của từng trang: path -> (từ khoá, {H2 cũ (chữ thuần): H2 mới (HTML)})
H2_SEO = {
    "index.html": ("dịch vụ thẻ tín dụng Đà Nẵng", {
        "Bạn cần gì? Chúng tôi lo hết": "Dịch vụ thẻ tín dụng Đà Nẵng – " + HL.format("bạn cần gì, chúng tôi lo hết"),
        "Đáo hạn thẻ tín dụng là gì?": "Đáo hạn thẻ tín dụng Đà Nẵng là gì?",
        "Trễ hạn 1 tháng, bạn mất bao nhiêu?": "Trễ hạn thẻ tín dụng 1 tháng, bạn mất bao nhiêu?",
        "4 bước – xong trong 15 phút": "Rút tiền, đáo hạn thẻ tín dụng: 4 bước – " + HL.format("xong trong 15 phút"),
        "Khách hàng Đà Nẵng tin chọn vì": "Vì sao chọn dịch vụ thẻ tín dụng Đà Nẵng Vân Trần?",
        "Có mặt khắp Đà Nẵng": "Rút tiền, đáo hạn thẻ tín dụng tận nơi khắp Đà Nẵng",
        "Hàng nghìn khách hàng hài lòng": "Khách hàng nói gì về dịch vụ thẻ tín dụng Đà Nẵng",
        "Dùng thẻ thông minh – không lo phí phạt": "Kiến thức thẻ tín dụng – dùng thông minh, không lo phí phạt",
        "Giải đáp nhanh": "Câu hỏi thường gặp về dịch vụ thẻ tín dụng Đà Nẵng",
        "Thẻ sắp đến hạn? Đừng chờ đến ngày cuối!": "Thẻ sắp đến hạn? Đáo hạn thẻ tín dụng Đà Nẵng ngay hôm nay",
    }),
    "bang-phi/index.html": ("phí thẻ tín dụng Đà Nẵng", {
        "Ví dụ chi phí thực tế": "Ví dụ phí đáo hạn thẻ tín dụng thực tế",
        "So sánh các lựa chọn khi thẻ đến hạn": "So sánh phí đáo hạn thẻ tín dụng và trả chậm",
    }),
    "dao-han-the-tin-dung-da-nang/index.html": ("đáo hạn thẻ tín dụng Đà Nẵng", {
        "Vì sao nên đáo hạn thay vì để thẻ trễ hạn?": "Vì sao nên đáo hạn thẻ tín dụng thay vì để trễ hạn?",
        "Quy trình đáo hạn thẻ tại Đà Nẵng": "Quy trình đáo hạn thẻ tín dụng tại Đà Nẵng",
        "Đáo hạn tận nơi tại các quận Đà Nẵng": "Đáo hạn thẻ tín dụng tận nơi các quận Đà Nẵng",
        "Lưu ý để đáo hạn an toàn": "Lưu ý để đáo hạn thẻ tín dụng an toàn",
        "Đáo hạn theo ngân hàng": "Đáo hạn thẻ tín dụng Đà Nẵng theo ngân hàng",
    }),
    "kien-thuc/dao-han-the-tin-dung-la-gi/index.html": ("đáo hạn thẻ tín dụng", {
        "Đáo hạn hoạt động như thế nào?": "Đáo hạn thẻ tín dụng hoạt động như thế nào?",
        "Lợi ích của đáo hạn": "Lợi ích của đáo hạn thẻ tín dụng",
        "Rủi ro cần biết": "Rủi ro khi đáo hạn thẻ tín dụng",
        "Khi nào nên đáo hạn?": "Khi nào nên đáo hạn thẻ tín dụng?",
    }),
    "gioi-thieu/index.html": ("dịch vụ thẻ tín dụng Đà Nẵng", {
        "Về thương hiệu Vân Trần (VT)": "Về Vân Trần (VT) – dịch vụ thẻ tín dụng Đà Nẵng",
        "Chúng tôi làm gì?": "Dịch vụ thẻ tín dụng Đà Nẵng chúng tôi cung cấp",
        "Cam kết với khách hàng": "Cam kết của dịch vụ thẻ tín dụng Vân Trần",
        "Thông tin liên hệ": "Liên hệ dịch vụ thẻ tín dụng Đà Nẵng",
    }),
    "kien-thuc/index.html": ("thẻ tín dụng", {
        "Bài viết mới nhất": "Bài viết kiến thức thẻ tín dụng mới nhất",
    }),
    "kien-thuc/ngay-sao-ke-va-ngay-den-han/index.html": ("ngày sao kê thẻ tín dụng", {
        "Ngày sao kê là gì?": "Ngày sao kê thẻ tín dụng là gì?",
        "Ngày đến hạn thanh toán là gì?": "Ngày đến hạn thanh toán thẻ tín dụng là gì?",
        "Mẹo tận dụng thời gian miễn lãi": "Mẹo dùng ngày sao kê thẻ tín dụng để được miễn lãi lâu nhất",
    }),
    "rut-tien-the-tin-dung-da-nang/index.html": ("rút tiền thẻ tín dụng Đà Nẵng", {
        "Rút tại ATM và dùng dịch vụ: khác nhau thế nào?": "Rút tiền thẻ tín dụng tại ATM và qua dịch vụ: khác nhau thế nào?",
        "Quy trình rút tiền thẻ tín dụng": "Quy trình rút tiền thẻ tín dụng tại Đà Nẵng",
        "Bảng phí rút tiền thẻ tín dụng": "Bảng phí rút tiền thẻ tín dụng Đà Nẵng",
        "Hỗ trợ tận nơi khắp Đà Nẵng": "Rút tiền thẻ tín dụng tận nơi khắp Đà Nẵng",
        "Xem thêm": "Xem thêm dịch vụ rút tiền thẻ tín dụng",
    }),
    "rut-tien-the-tin-dung-phi-thap/index.html": ("rút tiền thẻ tín dụng phí thấp", {
        "So sánh chi phí rút 10 triệu": "So sánh phí rút tiền thẻ tín dụng 10 triệu",
        "Bảng phí rút tiền theo loại thẻ": "Bảng phí rút tiền thẻ tín dụng theo loại thẻ",
    }),
    "rut-tien-the-tin-dung-tan-noi-da-nang/index.html": ("rút tiền thẻ tín dụng tận nơi", {
        "Đặt lịch rút tiền tận nơi trong 1 phút": "Đặt lịch rút tiền thẻ tín dụng tận nơi trong 1 phút",
        "Khu vực hỗ trợ tận nơi": "Khu vực rút tiền thẻ tín dụng tận nơi tại Đà Nẵng",
        "Phí rút tiền theo loại thẻ": "Phí rút tiền thẻ tín dụng tận nơi theo loại thẻ",
    }),
    "rut-tien-vi-tra-sau-da-nang/index.html": ("rút tiền ví trả sau", {
        "Các ví trả sau được hỗ trợ": "Các ví được hỗ trợ rút tiền ví trả sau tại Đà Nẵng",
        "Quy trình": "Quy trình rút tiền ví trả sau",
        "Lưu ý khi dùng ví trả sau": "Lưu ý khi rút tiền ví trả sau",
    }),
    "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu/index.html": ("trả chậm thẻ tín dụng", {
        "Các khoản bạn phải trả khi trễ hạn": "Các khoản phạt khi trả chậm thẻ tín dụng",
        "Ví dụ cụ thể": "Ví dụ trả chậm thẻ tín dụng bị phạt bao nhiêu",
        "Các nhóm nợ trên CIC": "Trả chậm thẻ tín dụng và các nhóm nợ trên CIC",
        "Cách xử lý khi sắp hoặc đã trễ hạn": "Cách xử lý khi trả chậm thẻ tín dụng",
    }),
}


def h2_seo_map(p):
    """Bảng đổi H2 cho trang p (gồm trang ngân hàng, quận) + 2 tiêu đề chung FAQ / Bài viết liên quan."""
    slug = p.rsplit("/", 1)[0] if "/" in p else ""
    kw, m = H2_SEO.get(p, (None, {}))
    m = dict(m)
    bank = re.match(r"dao-han-the-(.+)-da-nang$", slug)
    if bank and bank.group(1) != "tin-dung":
        name = next(b[1] for b in BANKS if b[0] == bank.group(1))
        kw = "đáo hạn thẻ " + name
        m.update({
            f"Cách xem ngày đến hạn thẻ {name}": f"Cách xem ngày đến hạn để đáo hạn thẻ {name}",
            f"Nếu để thẻ {name} trễ hạn thì sao?": f"Không đáo hạn thẻ {name} kịp thì sao?",
            f"Phí đáo hạn, rút tiền thẻ {name}": f"Phí đáo hạn, rút tiền thẻ {name} tại Đà Nẵng",
            "Hỗ trợ cả thẻ ngân hàng khác": "Đáo hạn thẻ tín dụng ngân hàng khác tại Đà Nẵng",
        })
    dist = re.match(r"dao-han-the-tin-dung-(.+)$", slug)
    if dist and dist.group(1) not in ("da-nang", "la-gi"):
        name = next(d[1] for d in DISTRICTS if d[0] == dist.group(1))
        kw = "đáo hạn thẻ tín dụng " + name
        m.update({
            f"Khu vực {name} chúng tôi thường hỗ trợ": f"Khu vực đáo hạn thẻ tín dụng {name} tận nơi",
            f"Quy trình đáo hạn tận nơi tại {name}": f"Quy trình đáo hạn thẻ tín dụng tận nơi tại {name}",
            "Phí đáo hạn, rút tiền thẻ tín dụng": f"Phí đáo hạn, rút tiền thẻ tín dụng {name}",
            "Khu vực lân cận": f"Đáo hạn thẻ tín dụng khu vực lân cận {name}",
        })
    if kw:
        m.setdefault("Câu hỏi thường gặp", f"Câu hỏi thường gặp về {kw}")
        m.setdefault("Bài viết liên quan", f"Bài viết liên quan về {kw}")
    return m


def apply_h2_seo(p, s):
    m = h2_seo_map(p)
    if not m:
        return s
    def h2(mt):
        text = re.sub(r"<.*?>", "", mt.group(2)).strip()
        if text.startswith("Bảng phí dịch vụ (cập nhật"):  # trang Bảng phí, ngày cập nhật thay đổi
            return mt.group(1) + mt.group(2).replace("Bảng phí dịch vụ", "Bảng phí đáo hạn, rút tiền thẻ tín dụng Đà Nẵng", 1) + "</h2>"
        return mt.group(1) + m.get(text, mt.group(2)) + "</h2>" if text in m else mt.group(0)
    s = re.sub(r'(<h2[^>]*>)(.*?)</h2>', h2, s, flags=re.S)
    # mục lục (TOC) dùng cùng chữ với H2
    return re.sub(r'(<a href="#[^"]*">)([^<]*)</a>',
                  lambda mt: mt.group(1) + re.sub(r"<.*?>", "", m.get(mt.group(2).strip(), mt.group(2))) + "</a>", s)


def write(p, s):
    s = apply_h2_seo(p, s)
    full = os.path.join(HERE, p)
    os.makedirs(os.path.dirname(full), exist_ok=True)
    with open(full, "w", encoding="utf-8") as f:
        f.write(s)


def fee_table():
    rows = "".join(
        f"<tr><td>{a}</td><td class=\"fee\">{b}</td><td class=\"fee\">{c}</td></tr>" for a, b, c in FEES
    )
    return (
        '<div class="tbl"><table><thead><tr><th>Loại thẻ</th><th>Phí đáo hạn</th>'
        f"<th>Phí rút tiền</th></tr></thead><tbody>{rows}</tbody></table></div>"
    )


def pct(s):
    return float(s.replace("%", "").replace(",", ".")) / 100


def example_table():
    rows = ""
    for debt in (10, 30, 50):
        fee = debt * 1e6 * pct(FEES[0][1])
        late = debt * 1e6 * 0.28 * 30 / 365 + max(debt * 1e6 * 0.05 * 0.05, 99000)
        f = lambda n: f"{round(n, -4):,.0f}đ".replace(",", ".")
        rows += f"<tr><td>{debt}.000.000đ</td><td class=\"fee\">{f(fee)}</td><td>≈ {f(late)} + nguy cơ nợ xấu</td></tr>"
    return ('<div class="tbl"><table><thead><tr><th>Dư nợ</th><th>Phí đáo hạn thẻ Visa</th>'
            f"<th>Nếu trễ hạn 1 tháng*</th></tr></thead><tbody>{rows}</tbody></table></div>")


def fill(s, root):
    return (s.replace("{{R}}", root).replace("{{FEE_TABLE}}", fee_table()).replace("{{EXAMPLE_TABLE}}", example_table())
             .replace("{{FEE_MIN}}", FEE_MIN).replace("{{UPDATED}}", vn_date(UPDATED))
             .replace("{{FEE_MIN_RUT}}", FEE_MIN_RUT).replace("{{ADDRESS}}", SITE["address"]).replace("{{MAPS}}", SITE["maps"].replace("&", "&amp;"))
             .replace("{{IMG}}", SITE["image"]).replace("{{IMG_ALT}}", SITE["image_alt"]).replace("{{AREAS}}", ", ".join(AREA_LIST)).replace("{{HOURS}}", HOURS)
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
    links = [(p["slug"], p["h1"]) for p in PAGES if p["slug"] != slug and not p.get("bank") and not p.get("extra")][:6]
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
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<meta name="author" content="{SITE['name']}">
<meta property="article:modified_time" content="{UPDATED}">
<link rel="canonical" href="{url}">
<meta name="theme-color" content="#0b1f44">
<meta name="geo.region" content="VN-DN"><meta name="geo.placename" content="Đà Nẵng">
<meta property="og:type" content="{og_type}"><meta property="og:locale" content="vi_VN">
<meta property="og:site_name" content="{SITE['name']}">
<meta property="og:title" content="{html.escape(title)}">
<meta property="og:description" content="{html.escape(desc)}">
<meta property="og:url" content="{url}">
<meta property="og:image" content="{SITE['image']}">
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
        f'<a href="{root}{q["slug"]}/">{q["h1"]}<small>{short(q["desc"], 110)}</small></a>' for q in PAGES if q.get("article")))
    crumbs = [("Trang chủ", DOMAIN)] + [(t, DOMAIN + s + "/") for s, t in p.get("parents", [])] + [(p["crumb"], url)]
    schemas = [
        {"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [
            {"@type": "ListItem", "position": i + 1, "name": n, "item": u} for i, (n, u) in enumerate(crumbs)]},
        {"@context": "https://schema.org", "@type": "Article" if p.get("article") else "Service",
         **({"headline": p["h1"], "datePublished": p.get("published", UPDATED), "dateModified": UPDATED,
             "author": {"@id": BUSINESS_ID}, "publisher": {"@id": BUSINESS_ID}, "inLanguage": "vi-VN",
             "mainEntityOfPage": url, "image": SITE["image"]}
            if p.get("article") else
            {"name": p["h1"], "serviceType": p["crumb"], "url": url, "areaServed": {"@type": "City", "name": "Đà Nẵng"},
             "provider": {"@id": BUSINESS_ID}}),
         "description": p["desc"]},
    ]
    schemas.append(business_schema())
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
            f'<a href="{root}{q["slug"]}/">{q["h1"]}<small>{short(q["desc"], 95)}</small></a>'
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
    {tldr_html(p.get('tldr'))}
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
        f'<a class="post reveal" href="{q["slug"]}/">{thumb_svg(q.get("icon", "question"))}'
        f'<div class="c"><h3>{q["h1"]}</h3><p>{short(q["desc"], 110)}</p></div></a>'
        for q in PAGES if q.get("article"))[:6000]
    body = fill(read("src/pages/index.body.html"), root).replace("{{POSTS}}", blog)
    website = {"@context": "https://schema.org", "@type": "WebSite", "@id": DOMAIN + "#website", "url": DOMAIN, "alternateName": ["Vân Trần", "Thẻ Tín Dụng Vân Trần"],
               "name": SITE["name"], "inLanguage": "vi-VN", "publisher": {"@id": BUSINESS_ID}}
    head = fill(read("src/index.head.html"), root).replace("{{BUSINESS_LD}}", jsonld(business_schema()) + "\n" + jsonld(website))
    out = (head + '<link rel="stylesheet" href="assets/site.css">\n</head>\n<body>\n'
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
"tldr": [
    "Đáo hạn thẻ tín dụng ở Đà Nẵng: liên hệ Zalo/điện thoại <strong>0909 669 325</strong>.",
    f"Phí đáo hạn từ <strong>{FEE_MIN}</strong> tùy loại thẻ (Visa {FEES[0][1]}, JCB/Mastercard {FEES[1][1]}, Sacombank/VPBank {FEE_SPECIAL}).",
    "Thời gian xử lý khoảng <strong>15–30 phút</strong>, tại cửa hàng hoặc tận nơi.",
    "Phục vụ: " + ", ".join(AREA_LIST) + ".",
    "Giờ làm việc: " + HOURS + ". Cần mang: thẻ chính chủ + CCCD.",
],
"crumb": "Đáo hạn thẻ tín dụng Đà Nẵng",
"title": "Đáo Hạn Thẻ Tín Dụng Đà Nẵng ✔️ Phí Từ {{FEE_MIN}}, Tận Nơi 15 Phút".replace("{{FEE_MIN}}", FEE_MIN),
"desc": f"Đáo hạn thẻ tín dụng Đà Nẵng phí từ {FEE_MIN}, xong 15 phút, tận nơi mọi quận. Tránh phạt trễ hạn, giữ điểm tín dụng. Zalo 0909 669 325.",
"h1": "Đáo Hạn Thẻ Tín Dụng Đà Nẵng – Nhanh 15 Phút, Phí Từ " + FEE_MIN,
"intro": "Thẻ sắp đến hạn mà chưa kịp xoay tiền? Chúng tôi thanh toán dư nợ giúp bạn trước ngày đến hạn, bạn tránh được phí phạt, lãi trả chậm và nguy cơ nợ xấu – có mặt tận nơi khắp Đà Nẵng.",
"related": ["bang-phi", "kien-thuc/dao-han-the-tin-dung-la-gi", "kien-thuc/ngay-sao-ke-va-ngay-den-han"],
"faqs": [
    ("Đáo hạn thẻ tín dụng ở Đà Nẵng mất bao lâu?", "Thông thường 15–30 phút kể từ khi bạn có mặt tại cửa hàng hoặc nhân viên đến tận nơi."),
    ("Phí đáo hạn thẻ tín dụng là bao nhiêu?", f"Phí từ {FEE_MIN} tùy loại thẻ: Visa {FEES[0][1]}, JCB/Mastercard {FEES[1][1]}, thẻ Sacombank/VPBank {FEE_SPECIAL}. Xem bảng phí hoặc nhắn Zalo để được báo phí chính xác."),
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
<li><strong>Nhận báo phí:</strong> báo phí rõ ràng theo loại thẻ. Bạn đồng ý mới thực hiện.</li>
<li><strong>Thanh toán dư nợ:</strong> chúng tôi nộp tiền vào thẻ, bạn kiểm tra trên app ngân hàng.</li>
<li><strong>Hoàn trả:</strong> thực hiện giao dịch bằng hạn mức vừa được giải phóng, nhận hoá đơn đầy đủ.</li>
</ol>
<div class="box"><p><strong>Chuẩn bị:</strong> thẻ tín dụng chính chủ + CCCD. Không cần cung cấp mã OTP, CVV hay mật khẩu ngân hàng.</p></div>

<h2 id="bang-phi">Phí đáo hạn thẻ tín dụng Đà Nẵng</h2>
<p>Phí theo loại thẻ, cập nhật {{UPDATED}}:</p>
{{FEE_TABLE}}
<p>Xem thêm so sánh chi phí chi tiết tại <a href="{{R}}bang-phi/">bảng phí dịch vụ thẻ tín dụng</a>.</p>

<h2 id="khu-vuc">Đáo hạn tận nơi tại các quận Đà Nẵng</h2>
<p>Không tiện ra cửa hàng? Nhân viên sẽ đến tận nhà hoặc văn phòng của bạn tại <strong>""" + AREAS + """</strong> trong khoảng 20–30 phút. Thời gian phục vụ 7h30 – 21h00 tất cả các ngày trong tuần, kể cả cuối tuần và ngày lễ – thời điểm ngân hàng nghỉ nhưng thẻ của bạn vẫn đến hạn.</p>

<p>Xem theo khu vực: <a href="{{R}}dao-han-the-tin-dung-hai-chau/">đáo hạn thẻ tín dụng Hải Châu</a> · <a href="{{R}}dao-han-the-tin-dung-thanh-khe/">Thanh Khê</a> · <a href="{{R}}dao-han-the-tin-dung-son-tra/">Sơn Trà</a>.</p>

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
"tldr": [
    "Rút tiền thẻ tín dụng ở Đà Nẵng: Zalo/điện thoại <strong>0909 669 325</strong>.",
    f"Phí rút tiền từ <strong>{FEE_MIN_RUT}</strong> (Visa), JCB/Mastercard và thẻ Sacombank/VPBank {FEES[1][2]} – thấp hơn phí ứng tiền mặt tại ATM (thường 3–4%).",
    "Nhận tiền mặt hoặc chuyển khoản trong khoảng <strong>15 phút</strong>.",
    "Hỗ trợ tận nơi: " + ", ".join(AREA_LIST) + ".",
],
"crumb": "Rút tiền thẻ tín dụng Đà Nẵng",
"title": f"Rút Tiền Thẻ Tín Dụng Đà Nẵng ✔️ Phí Từ {FEE_MIN_RUT}, Nhận Tiền 15 Phút",
"desc": f"Rút tiền thẻ tín dụng Đà Nẵng phí từ {FEE_MIN_RUT}, thấp hơn rút ATM, nhận tiền mặt hoặc chuyển khoản trong 15 phút, tận nơi mọi quận. Zalo 0909 669 325.",
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
<tr><td>Phí</td><td>Khoảng 3–4% số tiền rút</td><td class="fee">Từ {{FEE_MIN_RUT}}</td></tr>
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
<li>Nhận báo phí theo loại thẻ, đồng ý mới thực hiện.</li>
<li>Thực hiện giao dịch tại cửa hàng hoặc tận nơi, thẻ không rời tay bạn.</li>
<li>Nhận tiền mặt hoặc chuyển khoản vào tài khoản chính chủ, kèm hoá đơn.</li>
</ol>

<h2 id="bang-phi">Bảng phí rút tiền thẻ tín dụng</h2>
{{FEE_TABLE}}

<h2 id="khu-vuc">Hỗ trợ tận nơi khắp Đà Nẵng</h2>
<p>Phục vụ tận nhà, văn phòng, cửa hàng tại <strong>""" + AREAS + """</strong>. Nhắn vị trí qua Zalo, nhân viên có mặt trong khoảng 20–30 phút.</p>
<h2 id="xem-them">Xem thêm</h2>
<ul>
<li><a href="{{R}}rut-tien-the-tin-dung-phi-thap/">Rút tiền thẻ tín dụng phí thấp – so sánh chi phí</a></li>
<li><a href="{{R}}rut-tien-the-tin-dung-tan-noi-da-nang/">Rút tiền thẻ tín dụng gần đây, tận nơi</a></li>
<li><a href="{{R}}rut-tien-vi-tra-sau-da-nang/">Rút tiền ví trả sau Đà Nẵng</a></li>
</ul>
""",
},
# ---------------------------------------------------------------- BẢNG PHÍ
{
"slug": "bang-phi",
"tldr": [
    f"Phí đáo hạn thẻ tín dụng Đà Nẵng: Visa <strong>{FEES[0][1]}</strong>, JCB/Mastercard <strong>{FEES[1][1]}</strong>, thẻ Sacombank/VPBank <strong>{FEES[2][1]}</strong>.",
    f"Phí rút tiền: Visa <strong>{FEES[0][2]}</strong>, JCB/Mastercard <strong>{FEES[1][2]}</strong>, thẻ Sacombank/VPBank <strong>{FEES[2][2]}</strong>.",
    "Mức Visa, JCB, Mastercard áp dụng cho thẻ của các ngân hàng khác Sacombank và VPBank. Có hoá đơn từng giao dịch.",
    "Báo phí chính xác qua Zalo 0909 669 325.",
],
"crumb": "Bảng phí",
"title": f"Bảng Phí Đáo Hạn, Rút Tiền Thẻ Tín Dụng Đà Nẵng 2026 – Từ {FEE_MIN_RUT}",
"desc": f"Bảng phí đáo hạn (từ {FEE_MIN}) và rút tiền (từ {FEE_MIN_RUT}) thẻ tín dụng tại Đà Nẵng 2026 theo loại thẻ, không phí ẩn. So sánh với phí trễ hạn và phí rút ATM.",
"h1": "Bảng Phí Đáo Hạn & Rút Tiền Thẻ Tín Dụng Đà Nẵng 2026",
"intro": f"Phí theo loại thẻ: rút tiền từ {FEE_MIN_RUT}, đáo hạn từ {FEE_MIN}. Báo trước khi làm, không phát sinh. So sánh nhanh để thấy vì sao đáo hạn đúng lúc giúp bạn tiết kiệm.",
"related": ["dao-han-the-tin-dung-da-nang", "rut-tien-the-tin-dung-da-nang", "kien-thuc/tra-cham-the-tin-dung-bi-phat-bao-nhieu"],
"faqs": [
    ("Có phí ẩn nào không?", "Không. Bạn được báo phí trước theo loại thẻ, đồng ý mới thực hiện, có hoá đơn cho từng giao dịch."),
    ("Vì sao thẻ Sacombank, VPBank có mức phí riêng?", f"Thẻ của hai ngân hàng này áp dụng mức riêng: đáo hạn {FEES[2][1]}, rút tiền {FEES[2][2]}. Thẻ Visa, JCB, Mastercard của các ngân hàng khác theo bảng phí chung."),
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
# ---------------------------------------------------------------- GIỚI THIỆU
{
"slug": "gioi-thieu",
"crumb": "Giới thiệu & liên hệ",
"title": "Giới Thiệu Dịch Vụ Thẻ Tín Dụng Đà Nẵng – Liên Hệ 0909 669 325",
"desc": f"Thông tin về Dịch Vụ Thẻ Tín Dụng Đà Nẵng: dịch vụ, phí từ {FEE_MIN_RUT}, khu vực phục vụ, giờ làm việc, cam kết minh bạch và cách liên hệ.",
"h1": "Giới Thiệu & Liên Hệ – Dịch Vụ Thẻ Tín Dụng Đà Nẵng",
"intro": "Chúng tôi hỗ trợ người dùng thẻ tín dụng tại Đà Nẵng thanh toán đúng hạn, nhận tiền nhanh và dùng thẻ an toàn – minh bạch phí, có hoá đơn, thẻ không rời tay khách.",
"tldr": [
    "Tên: Dịch Vụ Thẻ Tín Dụng Đà Nẵng (VT – Vân Trần) – website the-tin-dung-da-nang.com.",
    "Địa chỉ: " + SITE["address"] + " (gọi trước khi đến).",
    "Liên hệ: Zalo/điện thoại <strong>0909 669 325</strong>, email Km.camvan@gmail.com.",
    "Giờ làm việc: " + HOURS + ".",
    "Khu vực: " + ", ".join(AREA_LIST) + ".",
],
"related": ["dao-han-the-tin-dung-da-nang", "rut-tien-the-tin-dung-da-nang", "bang-phi"],
"body": """
<h2 id="thuong-hieu">Về thương hiệu Vân Trần (VT)</h2>
<p><strong>Vân Trần (VT)</strong> là thương hiệu của Dịch Vụ Thẻ Tín Dụng Đà Nẵng, hỗ trợ chủ thẻ tại Đà Nẵng và Điện Bàn rút tiền, đáo hạn thẻ tín dụng minh bạch: báo phí trước, thẻ không rời tay khách, có hoá đơn cho từng giao dịch. Website chính thức: the-tin-dung-da-nang.com và dichvuthetindungdanang.com, liên hệ duy nhất qua <strong>0909 669 325</strong>.</p>

<h2 id="dich-vu">Chúng tôi làm gì?</h2>
<ul>
<li><a href="{{R}}dao-han-the-tin-dung-da-nang/">Đáo hạn thẻ tín dụng</a>: thanh toán dư nợ đúng hạn giúp khách, tránh phí phạt và nợ xấu.</li>
<li><a href="{{R}}rut-tien-the-tin-dung-da-nang/">Rút tiền thẻ tín dụng</a>: nhận tiền mặt hoặc chuyển khoản nhanh, phí thấp hơn rút ATM.</li>
<li>Tư vấn mở thẻ tín dụng phù hợp và hướng dẫn dùng thẻ an toàn, miễn phí.</li>
</ul>

<h2 id="cam-ket">Cam kết với khách hàng</h2>
<ul>
<li><strong>Báo phí trước</strong> – khách đồng ý mới thực hiện, không phát sinh thêm.</li>
<li><strong>Thẻ không rời tay khách</strong> – không giữ thẻ, không lưu số thẻ.</li>
<li><strong>Không bao giờ hỏi mã OTP, CVV, mật khẩu</strong>, không yêu cầu chuyển khoản đặt cọc.</li>
<li><strong>Hoá đơn đầy đủ</strong> cho từng giao dịch.</li>
<li>Chỉ phục vụ thẻ chính chủ, đối chiếu CCCD.</li>
</ul>

<h2 id="lien-he">Thông tin liên hệ</h2>
<div class="tbl"><table><tbody>
<tr><td><strong>Điện thoại / Zalo</strong></td><td>0909 669 325</td></tr>
<tr><td><strong>Email</strong></td><td>Km.camvan@gmail.com</td></tr>
<tr><td><strong>Địa chỉ</strong></td><td><a href="{{MAPS}}" target="_blank" rel="noopener">{{ADDRESS}}</a> (gọi trước khi đến)</td></tr>
<tr><td><strong>Website</strong></td><td>www.the-tin-dung-da-nang.com · <a href="https://www.dichvuthetindungdanang.com/" target="_blank" rel="noopener">www.dichvuthetindungdanang.com</a></td></tr>
<tr><td><strong>Giờ làm việc</strong></td><td>{{HOURS}}</td></tr>
<tr><td><strong>Khu vực phục vụ</strong></td><td>{{AREAS}}</td></tr>
</tbody></table></div>
<div class="box"><p><strong>Cảnh giác mạo danh:</strong> chúng tôi chỉ liên hệ qua số 0909 669 325. Mọi số điện thoại, tài khoản khác tự xưng là chúng tôi đều không phải.</p></div>
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
"tldr": [
    "Đáo hạn thẻ tín dụng là thanh toán dư nợ thẻ đúng hạn bằng nguồn tiền tạm thời, rồi dùng lại hạn mức để hoàn trả.",
    "Mục đích: tránh phí trả chậm, lãi 25–35%/năm trên toàn bộ dư nợ và nguy cơ nợ xấu CIC.",
    f"Chi phí thường 1,5–2,5% số tiền; tại Đà Nẵng phí từ {FEE_MIN}.",
    "Chỉ nên dùng như giải pháp tạm thời, có kế hoạch trả hết dư nợ trong 1–2 kỳ.",
],
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Đáo hạn thẻ tín dụng là gì?",
"article": True, "icon": "question",
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
"tldr": [
    "Ngày sao kê: ngày ngân hàng chốt giao dịch của chu kỳ (~30 ngày).",
    "Ngày đến hạn: thường sau ngày sao kê 15–25 ngày; trả đủ trước ngày này thì không bị tính lãi.",
    "Tổng thời gian miễn lãi tối đa thường 45–55 ngày; rút tiền mặt ATM không được miễn lãi.",
],
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Ngày sao kê và ngày đến hạn",
"article": True, "icon": "calendar",
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
"tldr": [
    "Phí chậm thanh toán thường 4–6% số tiền thanh toán tối thiểu (có mức sàn và trần).",
    "Lãi 25–35%/năm tính trên toàn bộ dư nợ sao kê, không chỉ phần còn thiếu.",
    "Quá hạn từ 10 ngày có thể bị xếp nhóm 2 (nợ cần chú ý) trên CIC; trên 90 ngày là nợ xấu.",
    "Ví dụ: dư nợ 20 triệu trễ 30 ngày tốn khoảng 560.000đ (lãi + phí phạt).",
],
"parents": [("kien-thuc", "Kiến thức")],
"crumb": "Trả chậm thẻ tín dụng bị phạt bao nhiêu?",
"article": True, "icon": "warning",
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
    dao = FEE_SPECIAL if key in SPECIAL_BANKS else FEE_MIN
    dao_txt = f"{FEE_SPECIAL}" if key in SPECIAL_BANKS else f"{FEES[0][1]} (Visa), {FEES[1][1]} (JCB, Mastercard)"
    others = "".join(f'<a href="{{{{R}}}}dao-han-the-{k}-da-nang/" class="bank">{n}</a>' for k, n, *_ in BANKS if k != key)
    return {
        "slug": f"dao-han-the-{key}-da-nang",
        "parents": [("dao-han-the-tin-dung-da-nang", "Đáo hạn thẻ tín dụng Đà Nẵng")],
        "crumb": f"Đáo hạn thẻ {name}",
        "bank": True,
        "title": f"Đáo Hạn Thẻ Tín Dụng {name} Tại Đà Nẵng ✔️ Phí Từ {dao}, 15 Phút",
        "desc": f"Đáo hạn, rút tiền thẻ tín dụng {name} tại Đà Nẵng: phí từ {dao}, xong 15 phút, tận nơi mọi quận. Zalo 0909 669 325.",
        "h1": f"Đáo Hạn Thẻ Tín Dụng {name} Tại Đà Nẵng",
        "intro": f"Thẻ {name} sắp đến hạn? Hỗ trợ đáo hạn và rút tiền thẻ tín dụng {name} (Visa, Mastercard, JCB…) trong 15 phút, tại cửa hàng hoặc tận nơi khắp Đà Nẵng.",
        "related": ["dao-han-the-tin-dung-da-nang", "bang-phi", "kien-thuc/ngay-sao-ke-va-ngay-den-han"],
        "tldr": [
            f"Đáo hạn, rút tiền thẻ tín dụng {name} tại Đà Nẵng: Zalo/điện thoại <strong>0909 669 325</strong>.",
            f"Phí đáo hạn thẻ {name}: <strong>{dao_txt}</strong>. Xử lý khoảng 15–30 phút, tận nơi mọi khu vực Đà Nẵng và Điện Bàn.",
            f"Xem ngày đến hạn thẻ {name} trong ứng dụng <strong>{app}</strong> → Thẻ → Sao kê.",
        ],
        "faqs": [
            (f"Đáo hạn thẻ {name} mất bao lâu?", "Khoảng 15–30 phút kể từ khi bắt đầu giao dịch, tại cửa hàng hoặc tận nơi trong nội thành Đà Nẵng."),
            (f"Phí đáo hạn thẻ {name} là bao nhiêu?", f"Phí đáo hạn thẻ {name}: {dao_txt}. Nhắn Zalo để được báo phí chính xác."),
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
<li>Nhận báo phí theo loại thẻ – đồng ý mới thực hiện.</li>
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

# ---------------------------------------------------------------- TRANG TỪ KHOÁ PHỤ
EXTRA_PAGES = [
{
"slug": "rut-tien-the-tin-dung-phi-thap", "extra": True,
"crumb": "Rút tiền thẻ tín dụng phí thấp",
"title": f"Rút Tiền Thẻ Tín Dụng Phí Thấp Đà Nẵng – Chỉ Từ {FEE_MIN_RUT}, Không Phí Ẩn",
"desc": f"Rút tiền thẻ tín dụng phí thấp tại Đà Nẵng: Visa {FEES[0][2]}, JCB/Mastercard {FEES[1][2]}, rẻ hơn rút ATM 3–4%. Báo phí trước, có hoá đơn. Zalo 0909 669 325.",
"h1": f"Rút Tiền Thẻ Tín Dụng Phí Thấp Tại Đà Nẵng – Từ {FEE_MIN_RUT}",
"intro": "So sánh chi phí thật khi rút tiền thẻ tín dụng: ATM, quầy ngân hàng hay dịch vụ. Phí công khai theo loại thẻ, báo trước khi làm, không phát sinh.",
"related": ["rut-tien-the-tin-dung-da-nang", "bang-phi", "rut-tien-the-tin-dung-tan-noi-da-nang"],
"tldr": [
    f"Phí rút tiền thẻ tín dụng tại Đà Nẵng: Visa <strong>{FEES[0][2]}</strong>, JCB/Mastercard <strong>{FEES[1][2]}</strong>, thẻ Sacombank/VPBank <strong>{FEES[2][2]}</strong>.",
    "Rút tại ATM/quầy ngân hàng thường mất phí 3–4% và bị tính lãi ngay từ ngày rút.",
    "Báo phí trước qua Zalo 0909 669 325, không phí ẩn, có hoá đơn.",
],
"faqs": [
    ("Rút tiền thẻ tín dụng ở đâu phí thấp nhất?", f"So sánh tổng chi phí: ATM thường 3–4% + lãi từ ngày rút; dịch vụ của chúng tôi từ {FEE_MIN_RUT} (thẻ Visa) và tính theo chu kỳ thẻ."),
    ("Có phí nào khác ngoài phần trăm không?", "Không. Bạn được báo đúng mức phí theo loại thẻ trước khi làm, có hoá đơn cho từng giao dịch."),
    ("Rút 10 triệu mất bao nhiêu phí?", f"Với thẻ Visa phí {FEES[0][2]}: khoảng 180.000đ. Thẻ JCB/Mastercard {FEES[1][2]}: khoảng 190.000đ."),
],
"body": """
<p>Khi cần tiền mặt gấp, nhiều người rút ngay tại ATM mà không biết đó thường là cách <strong>đắt nhất</strong>. Bài này so sánh chi phí thật để bạn chọn cách <strong>rút tiền thẻ tín dụng phí thấp</strong> nhất tại Đà Nẵng.</p>

<h2 id="so-sanh">So sánh chi phí rút 10 triệu</h2>
<div class="tbl"><table><thead><tr><th>Cách rút</th><th>Phí</th><th>Lãi phát sinh</th></tr></thead><tbody>
<tr><td>ATM</td><td>≈ 300.000 – 400.000đ (3–4%)</td><td>Tính ngay từ ngày rút</td></tr>
<tr><td>Quầy ngân hàng</td><td>≈ 300.000 – 400.000đ (3–4%)</td><td>Tính ngay từ ngày rút</td></tr>
<tr><td>Dịch vụ – thẻ Visa</td><td class="fee">≈ 180.000đ ({{FEE_MIN_RUT}})</td><td>Theo chu kỳ thẻ</td></tr>
</tbody></table></div>
<p style="font-size:.88rem;color:#5a6785">Mức phí ATM/ngân hàng là tham khảo phổ biến, mỗi ngân hàng có biểu phí riêng.</p>

<h2 id="bang-phi">Bảng phí rút tiền theo loại thẻ</h2>
{{FEE_TABLE}}

<h2 id="meo">4 mẹo để rút tiền thẻ tín dụng rẻ hơn</h2>
<ol>
<li><strong>Dùng thẻ Visa</strong> nếu có – mức phí thấp nhất ({{FEE_MIN_RUT}}).</li>
<li><strong>Rút ngay sau ngày sao kê</strong> để có thời gian trả lâu nhất, tránh lãi.</li>
<li><strong>Không rút tại ATM</strong> nếu không thật sự cần – vừa phí cao vừa bị tính lãi ngay.</li>
<li><strong>Hỏi phí trước</strong>: chỉ làm khi đã được báo mức phí rõ ràng.</li>
</ol>
<div class="box"><p>Lưu ý: phí thấp nhưng phải <strong>an toàn</strong>. Không đưa thẻ cho người lạ mang đi, không cung cấp OTP/CVV, không chuyển khoản đặt cọc.</p></div>
<p>Xem thêm: <a href="{{R}}rut-tien-the-tin-dung-da-nang/">dịch vụ rút tiền thẻ tín dụng Đà Nẵng</a> · <a href="{{R}}rut-tien-the-tin-dung-tan-noi-da-nang/">rút tiền tận nơi</a>.</p>
""",
},
{
"slug": "rut-tien-the-tin-dung-tan-noi-da-nang", "extra": True,
"crumb": "Rút tiền thẻ tín dụng tận nơi",
"title": "Rút Tiền Thẻ Tín Dụng Gần Đây, Tận Nơi Đà Nẵng – Có Mặt 20–30 Phút",
"desc": f"Rút tiền thẻ tín dụng gần đây tại Đà Nẵng: nhân viên đến tận nhà, văn phòng, cửa hàng. Phí từ {FEE_MIN_RUT}, 7h30–21h00 mỗi ngày. Gọi/Zalo 0909 669 325.",
"h1": "Rút Tiền Thẻ Tín Dụng Gần Đây – Hỗ Trợ Tận Nơi Tại Đà Nẵng",
"intro": "Không cần tìm điểm rút tiền thẻ tín dụng gần đây – nhắn vị trí qua Zalo, nhân viên đến tận nơi bạn ở Đà Nẵng và Điện Bàn.",
"related": ["rut-tien-the-tin-dung-da-nang", "rut-tien-the-tin-dung-phi-thap", "dao-han-the-tin-dung-hai-chau"],
"tldr": [
    "Nhắn vị trí qua Zalo <strong>0909 669 325</strong>, nhân viên có mặt khoảng 20–30 phút trong nội thành.",
    "Phục vụ: " + ", ".join(AREA_LIST) + ".",
    "Hoặc đến cửa hàng tại " + SITE["address"] + " (gọi trước khi đến).",
    f"Phí từ {FEE_MIN_RUT}, phục vụ " + HOURS + ".",
],
"faqs": [
    ("Gần tôi có chỗ rút tiền thẻ tín dụng không?", "Bạn không cần đi tìm: nhắn vị trí qua Zalo 0909 669 325, nhân viên đến tận nơi trong khu vực Đà Nẵng và Điện Bàn."),
    ("Rút tận nơi có mất thêm phí đi lại không?", "Bạn được báo phí rõ ràng trước khi nhân viên đến, đồng ý mới thực hiện."),
    ("Tận nơi có an toàn không?", "Có. Giao dịch thực hiện trước mặt bạn, thẻ không rời tay, không hỏi OTP/CVV và có hoá đơn."),
],
"body": """
<p>Gõ “<strong>rút tiền thẻ tín dụng gần đây</strong>” rồi phải chạy xe đi tìm? Với dịch vụ <strong>tận nơi</strong>, bạn chỉ cần ở nhà, văn phòng hay cửa hàng – chúng tôi mang thiết bị đến và hoàn tất ngay tại chỗ.</p>

<h2 id="cach-dat">Đặt lịch rút tiền tận nơi trong 1 phút</h2>
<ol>
<li>Nhắn Zalo <strong>0909 669 325</strong>: vị trí (hoặc ghim Google Maps), ngân hàng, số tiền.</li>
<li>Nhận báo phí và thời gian nhân viên đến.</li>
<li>Nhân viên đến, giao dịch trước mặt bạn, thẻ không rời tay.</li>
<li>Nhận tiền mặt hoặc chuyển khoản, kèm hoá đơn.</li>
</ol>

<h2 id="khu-vuc">Khu vực hỗ trợ tận nơi</h2>
<ul>
<li><a href="{{R}}dao-han-the-tin-dung-hai-chau/">Hải Châu</a> – gần cửa hàng trên đường Nguyễn Thị Minh Khai.</li>
<li><a href="{{R}}dao-han-the-tin-dung-thanh-khe/">Thanh Khê</a></li>
<li><a href="{{R}}dao-han-the-tin-dung-son-tra/">Sơn Trà</a></li>
<li>Ngũ Hành Sơn, Liên Chiểu, Cẩm Lệ, Hòa Vang và Điện Bàn.</li>
</ul>
<div class="box navy"><p>Thời gian phục vụ: <strong>{{HOURS}}</strong>. Nên nhắn trước 30 phút vào giờ cao điểm.</p></div>

<h2 id="bang-phi">Phí rút tiền theo loại thẻ</h2>
{{FEE_TABLE}}
<p>Xem thêm: <a href="{{R}}rut-tien-the-tin-dung-phi-thap/">cách rút tiền thẻ tín dụng phí thấp</a>.</p>
""",
},
{
"slug": "rut-tien-vi-tra-sau-da-nang", "extra": True,
"crumb": "Rút tiền ví trả sau",
"title": "Rút Tiền Ví Trả Sau Đà Nẵng – MoMo, SPayLater, Kredivo, Home PayLater",
"desc": "Rút tiền ví trả sau tại Đà Nẵng: MoMo Ví Trả Sau, SPayLater (Shopee), Kredivo, Home PayLater. Báo phí trước, nhận tiền nhanh. Zalo 0909 669 325.",
"h1": "Rút Tiền Ví Trả Sau Tại Đà Nẵng – MoMo, SPayLater, Kredivo",
"intro": "Hỗ trợ rút tiền từ các ví trả sau phổ biến tại Đà Nẵng, báo phí trước khi làm, nhận tiền nhanh.",
"related": ["rut-tien-the-tin-dung-da-nang", "rut-tien-the-tin-dung-tan-noi-da-nang", "bang-phi"],
"tldr": [
    "Hỗ trợ: <strong>MoMo Ví Trả Sau, SPayLater (Shopee), Kredivo, Home PayLater</strong> và các ví trả sau phổ biến.",
    "Phí tuỳ ví và hạn mức – báo trước qua Zalo <strong>0909 669 325</strong>.",
    "Cần tài khoản ví chính chủ; không cung cấp mật khẩu hay OTP cho người khác.",
],
"faqs": [
    ("Rút tiền ví trả sau phí bao nhiêu?", "Phí tuỳ loại ví và hạn mức khả dụng. Nhắn Zalo 0909 669 325 để được báo phí trước khi làm."),
    ("Ví trả sau nào rút được?", "MoMo Ví Trả Sau, SPayLater (Shopee), Kredivo, Home PayLater và các ví trả sau phổ biến khác."),
    ("Có phải đưa mật khẩu ví không?", "Không. Bạn tự thao tác trên điện thoại của mình, chúng tôi không hỏi mật khẩu hay mã OTP."),
],
"body": """
<p><strong>Ví trả sau</strong> (mua trước – trả sau) cho phép bạn dùng một hạn mức nhỏ để thanh toán. Khi cần tiền mặt, chúng tôi hỗ trợ <strong>rút tiền ví trả sau tại Đà Nẵng</strong> nhanh, phí báo trước.</p>

<h2 id="vi-ho-tro">Các ví trả sau được hỗ trợ</h2>
<ul>
<li><strong>MoMo Ví Trả Sau</strong></li>
<li><strong>SPayLater</strong> (Shopee)</li>
<li><strong>Kredivo</strong></li>
<li><strong>Home PayLater</strong> (Home Credit)</li>
<li>Các ví trả sau phổ biến khác – nhắn Zalo để kiểm tra.</li>
</ul>

<h2 id="quy-trinh">Quy trình</h2>
<ol>
<li>Nhắn Zalo <strong>0909 669 325</strong>: tên ví, hạn mức khả dụng, số tiền cần rút.</li>
<li>Nhận báo phí – đồng ý mới thực hiện.</li>
<li>Bạn tự thao tác thanh toán trên điện thoại của mình.</li>
<li>Nhận tiền mặt hoặc chuyển khoản, kèm hoá đơn.</li>
</ol>

<h2 id="luu-y">Lưu ý khi dùng ví trả sau</h2>
<ul>
<li>Ví trả sau cũng có <strong>ngày đến hạn</strong> và phí trễ hạn – hãy trả đúng hạn để không ảnh hưởng điểm tín dụng.</li>
<li>Chỉ rút số tiền bạn chắc chắn trả được trong kỳ.</li>
<li>Không bao giờ đưa mật khẩu, OTP ví cho người khác.</li>
</ul>
<p>Cần hạn mức lớn hơn? Xem <a href="{{R}}rut-tien-the-tin-dung-da-nang/">rút tiền thẻ tín dụng Đà Nẵng</a> – phí từ {{FEE_MIN_RUT}}.</p>
""",
},
]

# Trang đáo hạn theo khu vực: (slug, tên, mô tả khu vực, tuyến đường, địa điểm, khu vực lân cận)
DISTRICTS = [
    ("hai-chau", "Hải Châu", "trung tâm thành phố, cũng là nơi đặt cửa hàng của chúng tôi trên đường Nguyễn Thị Minh Khai",
     "Nguyễn Văn Linh, Lê Duẩn, Hùng Vương, Bạch Đằng, Nguyễn Thị Minh Khai, Phan Châu Trinh, Núi Thành, 2 Tháng 9",
     "Chợ Hàn, Chợ Cồn, đầu cầu Rồng, Công viên APEC", ["thanh-khe", "son-tra"]),
    ("thanh-khe", "Thanh Khê", "khu dân cư đông đúc phía tây bắc trung tâm, giáp vịnh Đà Nẵng",
     "Điện Biên Phủ, Hà Huy Tập, Hàm Nghi, Lê Độ, Nguyễn Tất Thành (ven biển)",
     "Công viên 29/3, tuyến ven biển Nguyễn Tất Thành", ["hai-chau", "son-tra"]),
    ("son-tra", "Sơn Trà", "phía đông sông Hàn, khu ven biển Mỹ Khê và bán đảo Sơn Trà",
     "Ngô Quyền, Võ Nguyên Giáp, Phạm Văn Đồng, Hồ Nghinh, Trần Hưng Đạo",
     "biển Mỹ Khê, đầu cầu Rồng phía Sơn Trà, khu Ngô Quyền", ["hai-chau", "thanh-khe"]),
]


def district_page(key, name, about, streets, places, near):
    near_links = " · ".join(f'<a href="{{{{R}}}}dao-han-the-tin-dung-{k}/">{n}</a>' for k, n, *_ in DISTRICTS if k in near)
    return {
        "slug": f"dao-han-the-tin-dung-{key}", "extra": True, "district": True,
        "parents": [("dao-han-the-tin-dung-da-nang", "Đáo hạn thẻ tín dụng Đà Nẵng")],
        "crumb": f"Đáo hạn thẻ tín dụng {name}",
        "title": f"Đáo Hạn Thẻ Tín Dụng {name} Đà Nẵng ✔️ Tận Nơi, Phí Từ {FEE_MIN}",
        "desc": f"Đáo hạn, rút tiền thẻ tín dụng tại {name}, Đà Nẵng: nhân viên đến tận nơi, phí từ {FEE_MIN}, 7h30–21h00 mỗi ngày. Gọi/Zalo 0909 669 325.",
        "h1": f"Đáo Hạn Thẻ Tín Dụng {name} – Tận Nơi, Nhanh 15 Phút",
        "intro": f"Hỗ trợ đáo hạn và rút tiền thẻ tín dụng tận nơi tại {name} – {about}.",
        "related": ["dao-han-the-tin-dung-da-nang", "bang-phi", "rut-tien-the-tin-dung-tan-noi-da-nang"],
        "tldr": [
            f"Đáo hạn thẻ tín dụng tại {name}: Zalo/điện thoại <strong>0909 669 325</strong>.",
            f"Phí đáo hạn: Visa <strong>{FEES[0][1]}</strong>, JCB/Mastercard <strong>{FEES[1][1]}</strong>, thẻ Sacombank/VPBank <strong>{FEES[2][1]}</strong>.",
            f"Hỗ trợ tận nơi các tuyến {streets.split(', ')[0]}, {streets.split(', ')[1]}… – " + HOURS + ".",
        ],
        "faqs": [
            (f"Đáo hạn thẻ tín dụng ở {name} có đến tận nơi không?", f"Có. Nhắn vị trí ở {name} qua Zalo 0909 669 325, nhân viên đến tận nhà, văn phòng hoặc cửa hàng của bạn."),
            (f"Ở {name} bao lâu thì có người đến?", "Thường khoảng 20–30 phút tuỳ thời điểm; nên nhắn trước vào giờ cao điểm."),
            (f"Phí đáo hạn thẻ ở {name} có khác khu vực khác không?", f"Không. Phí theo loại thẻ, áp dụng chung: Visa {FEES[0][1]}, JCB/Mastercard {FEES[1][1]}, Sacombank/VPBank {FEES[2][1]}."),
        ],
        "body": f"""
<p>Bạn ở <strong>{name}</strong> và thẻ tín dụng sắp đến hạn? Dịch vụ <strong>đáo hạn thẻ tín dụng {name}</strong> giúp bạn thanh toán đủ dư nợ trước ngày đến hạn, tránh phí trễ hạn và lãi trên toàn bộ dư nợ – nhân viên đến tận nơi, bạn không cần di chuyển.</p>

<h2 id="khu-vuc">Khu vực {name} chúng tôi thường hỗ trợ</h2>
<ul>
<li><strong>Tuyến đường:</strong> {streets}…</li>
<li><strong>Gần:</strong> {places}.</li>
<li>Nhà riêng, văn phòng, cửa hàng, khách sạn – nhắn vị trí là được.</li>
</ul>
<div class="box navy"><p>Từ năm 2025, cấp quận đã được sắp xếp lại; trên trang này chúng tôi dùng tên khu vực <strong>{name}</strong> quen thuộc để bạn dễ tìm.</p></div>

<h2 id="quy-trinh">Quy trình đáo hạn tận nơi tại {name}</h2>
<ol>
<li>Nhắn Zalo <strong>0909 669 325</strong>: vị trí ở {name}, ngân hàng, số tiền, ngày đến hạn.</li>
<li>Nhận báo phí theo loại thẻ – đồng ý mới thực hiện.</li>
<li>Nhân viên đến, thanh toán dư nợ vào thẻ; bạn kiểm tra trên app ngân hàng.</li>
<li>Hoàn trả bằng hạn mức vừa khôi phục, nhận hoá đơn.</li>
</ol>

<h2 id="bang-phi">Phí đáo hạn, rút tiền thẻ tín dụng</h2>
{{{{FEE_TABLE}}}}

<h2 id="lan-can">Khu vực lân cận</h2>
<p>Chúng tôi cũng hỗ trợ tại {near_links} và toàn bộ Đà Nẵng, Điện Bàn. Cần tiền mặt? Xem <a href="{{{{R}}}}rut-tien-the-tin-dung-tan-noi-da-nang/">rút tiền thẻ tín dụng tận nơi</a>.</p>
""",
    }


EXTRA_PAGES += [district_page(*d) for d in DISTRICTS]
PAGES += EXTRA_PAGES


def strip(h):
    return re.sub(r"\s+", " ", re.sub("<.*?>", "", h)).strip()


def build_llms():
    """llms.txt – bản tóm tắt cho ChatGPT, Perplexity, Claude… đọc nhanh nội dung website."""
    fees = "\n".join(f"- {a}: đáo hạn {b}, rút tiền {c}" for a, b, c in FEES)
    groups = [("Dịch vụ", lambda p: not p.get("article") and not p.get("bank") and not p.get("district") and p["slug"] != "kien-thuc"),
              ("Đáo hạn theo khu vực", lambda p: p.get("district")),
              ("Đáo hạn theo ngân hàng", lambda p: p.get("bank")),
              ("Kiến thức", lambda p: p.get("article"))]
    sec = ""
    for g, f in groups:
        sec += f"\n## {g}\n\n" + "".join(f"- [{q['h1']}]({DOMAIN}{q['slug']}/): {q['desc']}\n" for q in PAGES if f(q))
    out = f"""# {SITE['name']}

> Dịch vụ đáo hạn thẻ tín dụng, rút tiền thẻ tín dụng và tư vấn mở thẻ tại Đà Nẵng. Phí rút tiền từ {FEE_MIN_RUT}, đáo hạn từ {FEE_MIN}, xử lý khoảng 15–30 phút, hỗ trợ tận nơi. Liên hệ Zalo/điện thoại 0909 669 325.

## Thông tin chính

- Website: {DOMAIN}
- Thương hiệu: {SITE['brand']}
- Địa chỉ: {SITE['address']}
- Điện thoại / Zalo: 0909 669 325
- Email: {SITE['email']}
- Giờ làm việc: {HOURS}
- Khu vực phục vụ (tận nơi): {", ".join(AREA_LIST)}
- Thẻ hỗ trợ: Visa, Mastercard, JCB, Amex, Napas của hầu hết ngân hàng Việt Nam
- Rút tiền ví trả sau: MoMo Ví Trả Sau, SPayLater (Shopee), Kredivo, Home PayLater (phí báo trước)
- Cần chuẩn bị: thẻ tín dụng chính chủ + CCCD
- Cam kết: báo phí trước, không phí ẩn, thẻ không rời tay khách, không hỏi OTP/CVV, có hoá đơn

## Bảng phí theo loại thẻ (cập nhật {vn_date(UPDATED)})

{fees}
{sec}"""
    write("llms.txt", out)


def build_robots():
    bots = ["GPTBot", "OAI-SearchBot", "ChatGPT-User", "PerplexityBot", "ClaudeBot", "Claude-SearchBot",
            "Google-Extended", "Bingbot", "Applebot-Extended", "CCBot"]
    rules = "".join(f"User-agent: {b}\nAllow: /\n\n" for b in bots)
    write("robots.txt", f"# Cho phép công cụ tìm kiếm và trợ lý AI (ChatGPT, Perplexity, Claude, Gemini…) đọc website\n{rules}User-agent: *\nAllow: /\n\nSitemap: {DOMAIN}sitemap.xml\n")


if __name__ == "__main__":
    build_llms()
    build_robots()
    for p in PAGES:
        build_page(p)
    build_index()
    build_sitemap()
    print("Built", len(PAGES) + 1, "pages")
