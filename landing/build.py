#!/usr/bin/env python3
"""Build the main page + sub pages for www.giohangvinhaivanbay.com from src/page.html.

Sections in src/page.html are delimited by HTML comments like <!-- CART -->.
Each sub page reuses those sections, so edit src/page.html only, then run:

    python3 landing/build.py
"""
import json
import re
import shutil
from datetime import date
from pathlib import Path

from zones import ZONES, faq_html, zone_analysis_html, zone_detail_html, zone_info_html, zone_links_html, zone_toc_html

ROOT = Path(__file__).parent
SRC = ROOT / "src" / "page.html"
DIST = ROOT / "dist"
SITE = "https://www.giohangvinhaivanbay.com"

PAGES = [
    {
        "file": "index.html", "path": "/",
        "sections": None,  # all
    },
    {
        "file": "gio-hang.html", "path": "/gio-hang", "crumb": "Giỏ hàng",
        "title": "Giỏ Hàng Vinhomes Hải Vân Bay – Quỹ Căn Độc Quyền, Bảng Giá, Chính Sách & Phân Tích T10/2026",
        "desc": "Giỏ hàng Vinhomes Hải Vân Bay cập nhật hằng ngày: quỹ căn độc quyền, căn giá tốt từng phân khu, tra cứu mã căn, chính sách bán hàng mới nhất, phân tích chi phí từng phương án thanh toán và công cụ tính giá. Liên hệ 0909 882 555.",
        "badge": "Giỏ hàng cập nhật hằng ngày",
        "h1": "Giỏ hàng Vinhomes Hải Vân Bay<span>Quỹ căn độc quyền · Căn giá tốt từng phân khu</span>",
        "sub": "Tra cứu mã căn, xem nhanh thông số và nhận <b>giá tốt nhất</b> trực tiếp. Gõ mã căn bất kỳ để tra cứu toàn bộ rổ hàng, nhắn Zalo nhận giá & tình trạng căn.",
        "sections": ["RIBBON", "CART", "CTABAND", "POLICIES", "PHAPLY", "PHANTICH", "CALCULATOR", "NEWS", "GALLERY", "FAQ", "CONTACT"],
    "faq": [
            ("Nên thanh toán sớm hay vay 70% khi mua Vinhomes Hải Vân Bay?", "Theo phiếu giá căn mẫu T10/2026, thanh toán sớm rẻ hơn tiến độ chuẩn khoảng 3,4%, vay 70% đắt hơn khoảng 2,7%. Có vốn nhàn rỗi thì thanh toán sớm (chiết khấu tương đương 11%/năm); muốn giữ vốn thì vay 70%."),
            ("Vay lãi cố định (PA01) hay hỗ trợ lãi suất 0% (PA02) lợi hơn?", "Trên cùng giá trị gốc và vay đủ 70% suốt kỳ hạn, PA01 rẻ hơn PA02 từ 0,35% (18 tháng) đến 3,75% (36 tháng) và càng lợi khi trả trước hạn. PA02 phù hợp khi không muốn trả tiền hằng tháng."),
            ("Đảo Ngọc nên chọn cam kết thuê 7% hay Về ở sớm 10%?", "CKTT 7%/năm × 3 năm tổng 21% danh nghĩa, quy về hiện tại khoảng 18%, phù hợp đầu tư thụ động. Về ở sớm giảm ngay 10% vào giá HĐMB, phù hợp khi muốn tự ở hoặc tự khai thác."),
            ("Giãn thanh toán 24 hay 36 tháng có đắt không?", "Tại Vịnh Mây và Đảo Ngọc, giãn 24 tháng đắt hơn tiến độ chuẩn khoảng 7,6%, 36 tháng khoảng 13,2%. Tại Bạch Vân chênh lớn hơn (khoảng 16% và 21%)."),
            ("Phân khu nào phù hợp để cho thuê?", "Đảo Ngọc phù hợp nhất cho thuê nhờ sát biển, cạnh VinWonders và có căn hoàn thiện nhận cam kết tiền thuê 7%/năm trong 3 năm."),
        ],
    },
]


PAGES.append({
    "file": "uu-dai.html", "path": "/uu-dai", "crumb": "Ưu đãi", "ads": True, "nohero": True,
    "title": "Vinhomes Hải Vân Bay – Nhà Phố Đà Nẵng Chỉ Từ ~5,3 Tỷ, Vay 70%, Lãi Suất 0% 36 Tháng",
    "desc": "Về Đà Nẵng ở luôn: nhà phố Vinhomes Hải Vân Bay chỉ từ ~5,3 tỷ (gồm VAT), vay 70%, lãi suất 0% đến 36 tháng, giãn xây D+540. Mở khóa bảng giá nội bộ & đặt lịch tham quan miễn phí – 0909 882 555.",
    "extra_file": "ads.html",
    "faq": [
        ("Giá nhà phố Vinhomes Hải Vân Bay thấp nhất bao nhiêu?", "Theo bảng hàng hiện tại, liền kề Bạch Vân từ khoảng 5,3 tỷ, Vịnh Mây từ khoảng 5,6 tỷ, biệt thự song lập từ khoảng 9,4 tỷ, Đảo Ngọc từ khoảng 10,2 tỷ (giá đã gồm VAT). Giá từng căn thay đổi theo vị trí – liên hệ 0909 882 555 để nhận bảng giá nội bộ."),
        ("Cần bao nhiêu vốn ban đầu?", "Với gói vay 70% theo điều kiện ngân hàng, vốn tự có khoảng 30% giá trị căn – ví dụ căn khoảng 5,3 tỷ cần chuẩn bị khoảng 1,6 tỷ. Có gói hỗ trợ lãi suất 0% từ 18 đến 36 tháng."),
        ("Có được đi xem dự án không?", "Có. Đặt lịch qua form hoặc Zalo 0909 882 555, chuyên viên đưa đón tham quan miễn phí, xem nhà mẫu và tiến độ thực tế."),
        ("Sản phẩm có sở hữu lâu dài không?", "Phần lớn (~90%) sản phẩm thấp tầng có quyền sở hữu lâu dài; dự án có chủ trương đầu tư, quy hoạch 1/500 và giấy phép xây dựng hạ tầng."),
    ],
    "sections": ["ADSHERO", "ADSNUM", "ADSLIFE", "OVERVIEW", "LOCATION", "ZONES", "CART", "ADSOFFER", "ADSQUIZ", "ADSPOTENTIAL", "PHAPLY", "GALLERY", "ADSVISIT", "FAQ", "CONTACT", "ADSSCRIPT"],
})

for _z in ZONES:
    PAGES.append({
        "file": _z["slug"] + ".html", "path": "/" + _z["slug"], "crumb": "Phân khu " + _z["name"],
        "title": _z["title"], "desc": _z["desc"], "badge": _z["badge"], "h1": _z["h1"], "sub": _z["sub"],
        "zone": _z["zone_key"], "hero_img": _z["hero_img"], "policy_tab": _z["policy_tab"], "faq": _z["faq"],
        "extra": {"ZONEINFO": zone_toc_html(_z) + zone_info_html(_z), "ZONEDETAIL": zone_detail_html(_z), "ZONEANALYSIS": zone_analysis_html(_z), "ZONELINKS": zone_links_html(_z["slug"])},
        "sections": ["ZONEINFO", "ZONEDETAIL", "CART"] + (["POLICIES"] if _z["policy_tab"] else []) + ["PHAPLY"] +
                    ["ZONEANALYSIS", "RIBBON", "CALCULATOR", "GALLERY", "NEWS", "ZONELINKS", "FAQ", "CONTACT"],
    })


def split_sections(main):
    """Return ordered list of (NAME, html) from the <main> body."""
    parts = re.split(r"(<!-- ([A-Z]+) -->)", main)
    out = []
    for i in range(1, len(parts), 3):
        out.append((parts[i + 1], parts[i] + parts[i + 2]))
    return out


def build():
    src = SRC.read_text(encoding="utf-8")
    units = (ROOT / "src" / "units.json").read_text(encoding="utf-8").strip()
    src = re.sub(r"/\*HVB_DATA\*/\{[^\n]*?\};", lambda m: "/*HVB_DATA*/" + units + ";", src, count=1)
    m = re.search(r'(<main id="top">)(.*)(</main>)', src, re.S)
    before, main, after = src[:m.start(2)], m.group(2), src[m.end(2):]
    sections = dict(split_sections(main))
    order = [n for n, _ in split_sections(main)]

    if DIST.exists():
        shutil.rmtree(DIST)
    DIST.mkdir()
    shutil.copytree(ROOT / "src" / "img", DIST / "img")

    for pg in PAGES:
        names = pg["sections"] or order
        secs = dict(sections, **pg.get("extra", {}))
        if pg.get("extra_file"):
            secs.update(split_sections((ROOT / "src" / pg["extra_file"]).read_text(encoding="utf-8")))
        if pg.get("faq"):
            secs["FAQ"] = faq_html(pg["faq"])
        if pg.get("policy_tab") and "POLICIES" in secs:
            pol = secs["POLICIES"].replace('class="tab active"', 'class="tab"').replace('class="panel active"', 'class="panel"')
            pol = pol.replace('data-tab="%s"' % pg["policy_tab"], 'data-tab="%s" aria-selected="true"' % pg["policy_tab"])
            pol = pol.replace('class="tab" data-tab="%s"' % pg["policy_tab"], 'class="tab active" data-tab="%s"' % pg["policy_tab"])
            pol = pol.replace('<div class="panel" id="%s">' % pg["policy_tab"], '<div class="panel active" id="%s">' % pg["policy_tab"])
            secs["POLICIES"] = pol
        body = "\n".join(secs[n] for n in (([] if pg.get("nohero") else ["HERO"]) + [x for x in names if x != "HERO"]) if n in secs)
        head, tail = before, after
        url = SITE + pg["path"]

        if pg["sections"] and not pg.get("nohero"):
            hero = sections["HERO"]
            hero = re.sub(r"<h1>.*?</h1>", "<h1>" + pg["h1"] + "</h1>", hero, count=1, flags=re.S)
            hero = re.sub(r'<p class="sub">.*?</p>', '<p class="sub">' + pg["sub"] + "</p>", hero, count=1, flags=re.S)
            hero = re.sub(r'(<span class="badge"><i></i>).*?(</span>)', r"\g<1> " + pg["badge"] + r"\2", hero, count=1, flags=re.S)
            hero = hero.replace('data-source="Hero"', 'data-source="Hero ' + pg["path"] + '"')
            hero = hero.replace('<span class="badge">', '<nav class="crumb" aria-label="breadcrumb"><a href="/">Trang chủ</a> › <span>%s</span></nav>\n      <span class="badge">' % pg["crumb"], 1)
            if pg.get("zone"):
                hero = hero.replace("<option>Bảng giá & giỏ hàng độc quyền</option>", "<option>Bảng giá & giỏ hàng phân khu %s</option>" % pg["zone"], 1)
            if pg.get("hero_img"):
                hero = hero.replace('<section class="hero">', '<section class="hero" style="background-image:linear-gradient(100deg,rgba(4,13,32,.93) 0%%,rgba(6,20,46,.8) 45%%,rgba(10,31,68,.45) 100%%),url(\'img/%s.webp\')">' % pg["hero_img"], 1)
            body = body.replace(sections["HERO"], hero, 1)

        if pg["sections"]:
            head = re.sub(r"<title>.*?</title>", "<title>" + pg["title"] + "</title>", head, count=1)
            head = re.sub(r'(<meta name="description" content=")[^"]*', r"\g<1>" + pg["desc"], head, count=1)
            head = re.sub(r'(<meta property="og:title" content=")[^"]*', r"\g<1>" + pg["title"], head, count=1)
            head = re.sub(r'(<meta property="og:description" content=")[^"]*', r"\g<1>" + pg["desc"], head, count=1)
            crumb = {"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [
                {"@type": "ListItem", "position": 1, "name": "Trang chủ", "item": SITE + "/"},
                {"@type": "ListItem", "position": 2, "name": pg["crumb"], "item": url}]}
            head = head.replace("</head>", '<script type="application/ld+json">%s</script>\n</head>' % json.dumps(crumb, ensure_ascii=False), 1)
            if pg.get("hero_img"):
                head = re.sub(r'(<meta property="og:image" content=")[^"]*', r"\g<1>%s/img/%s.webp" % (SITE, pg["hero_img"]), head, count=1)
            if pg.get("faq"):
                ld = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
                    {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}} for q, a in pg["faq"]]}
                head = re.sub(r'(<script type="application/ld\+json" id="ld-faq">).*?(</script>)',
                              lambda mm: mm.group(1) + "\n" + json.dumps(ld, ensure_ascii=False) + "\n" + mm.group(2), head, count=1, flags=re.S)
        if pg.get("ads"):
            head = re.sub(r'<nav class="nav".*?</nav>', "", head, count=1, flags=re.S)
            head = head.replace('<meta name="robots" content="index,follow,max-image-preview:large">', '<meta name="robots" content="noindex,follow">', 1)
        if pg.get("zone"):
            head = head.replace("<body>", '<body data-zone="%s">' % pg["zone"], 1)

        head = re.sub(r'(<link rel="canonical" href=")[^"]*', r"\g<1>" + url, head, count=1)
        head = re.sub(r'(<link rel="alternate" hreflang="vi" href=")[^"]*', r"\g<1>" + url, head, count=1)
        head = re.sub(r'(<meta property="og:url" content=")[^"]*', r"\g<1>" + url, head, count=1)

        html = head + body + tail
        # Anchors to sections not on this page go to the main page.
        present = set(re.findall(r'<section[^>]*\sid="([^"]+)"', body)) | {"top"}
        html = re.sub(r'href="#([\w-]+)"',
                      lambda mm: mm.group(0) if mm.group(1) in present else 'href="/#%s"' % mm.group(1), html)
        for sec, page in (("gio-hang", "/gio-hang"),):
            html = html.replace('href="/#%s"' % sec, 'href="%s"' % page)
        (DIST / pg["file"]).write_text(html, encoding="utf-8")
        print("built", pg["file"], len(html) // 1024, "KB")

    today = date.today().isoformat()
    urls = "\n".join(
        "  <url><loc>%s%s</loc><lastmod>%s</lastmod><changefreq>daily</changefreq><priority>%s</priority></url>"
        % (SITE, p["path"], today, "1.0" if p["path"] == "/" else "0.8") for p in PAGES if not p.get("ads"))
    (DIST / "sitemap.xml").write_text(
        '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
        + urls + "\n</urlset>\n", encoding="utf-8")
    (DIST / "robots.txt").write_text("User-agent: *\nAllow: /\nSitemap: %s/sitemap.xml\n" % SITE, encoding="utf-8")


if __name__ == "__main__":
    build()
