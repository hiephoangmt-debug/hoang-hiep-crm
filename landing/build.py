#!/usr/bin/env python3
"""Build the main page + sub pages for www.giohanghaivanbay.com from src/page.html.

Sections in src/page.html are delimited by HTML comments like <!-- CART -->.
Each sub page reuses those sections, so edit src/page.html only, then run:

    python3 landing/build.py
"""
import re
import shutil
from datetime import date
from pathlib import Path

ROOT = Path(__file__).parent
SRC = ROOT / "src" / "page.html"
DIST = ROOT / "dist"
SITE = "https://www.giohanghaivanbay.com"

PAGES = [
    {
        "file": "index.html", "path": "/",
        "sections": None,  # all
    },
    {
        "file": "gio-hang.html", "path": "/gio-hang",
        "title": "Giỏ Hàng Vinhomes Hải Vân Bay – Quỹ Căn Độc Quyền & Căn Giá Tốt T10/2026",
        "desc": "Giỏ hàng Vinhomes Hải Vân Bay cập nhật hằng ngày: quỹ căn độc quyền, 5 căn giá tốt, căn giá tốt từng phân khu Bạch Vân – Vịnh Mây – Đảo Ngọc, tra cứu mã căn. Liên hệ 0909 882 555.",
        "badge": "Giỏ hàng cập nhật hằng ngày",
        "h1": "Giỏ hàng Vinhomes Hải Vân Bay<span>Quỹ căn độc quyền · Căn giá tốt từng phân khu</span>",
        "sub": "Tra cứu mã căn, xem nhanh thông số và nhận <b>giá tốt nhất</b> trực tiếp. Quỹ căn chéo còn nhiều căn chưa đưa lên web – để lại số điện thoại để nhận đầy đủ.",
        "sections": ["RIBBON", "CART", "CTABAND", "CALCULATOR", "GALLERY", "FAQ", "CONTACT"],
    },
    {
        "file": "chinh-sach.html", "path": "/chinh-sach",
        "title": "Chính Sách Bán Hàng Vinhomes Hải Vân Bay T10/2026 – Giãn Xây, HTLS 0%, CKTT 7%",
        "desc": "Chính sách bán hàng Vinhomes Hải Vân Bay mới nhất: giãn xây Vịnh Mây từ 01/10/2026, Bạch Vân & Đảo Ngọc từ 20/09/2026, vay 70%, HTLS 0% 18–36 tháng, CKTT 7%/năm, chiết khấu TTS 11%/năm.",
        "badge": "Áp dụng từ 01/10/2026",
        "h1": "Chính sách bán hàng Hải Vân Bay<span>Giãn xây · HTLS 0% · Vay 70% · CKTT 7%/năm</span>",
        "sub": "Tổng hợp đầy đủ chính sách Chủ đầu tư cho từng phân khu. Nhận <b>phiếu tính giá</b> theo dòng tiền của bạn chỉ trong 5 phút.",
        "sections": ["RIBBON", "POLICIES", "CALCULATOR", "CTABAND", "CART", "FAQ", "CONTACT"],
    },
    {
        "file": "tinh-gia.html", "path": "/tinh-gia",
        "title": "Tính Giá Vinhomes Hải Vân Bay – So Sánh Thanh Toán Sớm, Vay 70%, Giãn 24/36 Tháng",
        "desc": "Công cụ tính giá thử Vinhomes Hải Vân Bay: so sánh thanh toán sớm, tiến độ chuẩn, vay 70% lãi cố định, HTLS 0%, giãn 24/36 tháng. Nhận phiếu tính chi tiết theo mã căn.",
        "badge": "Phiếu tính giá miễn phí",
        "h1": "Tính giá & dòng tiền Hải Vân Bay<span>So sánh 6 phương án thanh toán trong 30 giây</span>",
        "sub": "Nhập giá thuần để ước tính ngay. Cần <b>phiếu tính chính thức theo mã căn</b> – để lại thông tin, chuyên viên gửi qua Zalo.",
        "sections": ["CALCULATOR", "POLICIES", "CTABAND", "CART", "FAQ", "CONTACT"],
    },
    {
        "file": "tin-tuc.html", "path": "/tin-tuc",
        "title": "Tin Tức Vinhomes Hải Vân Bay – Dự Án, Hạ Tầng, Tiến Độ & Chính Sách Mới Nhất",
        "desc": "Tin tức mới nhất Vinhomes Hải Vân Bay: chính sách bán hàng, hạ tầng cảng Liên Chiểu, tuyến ven biển, tiến độ xây dựng, tiện ích VinWonders. Nhận bản tin qua Zalo.",
        "badge": "Bản tin dự án",
        "h1": "Tin tức Vinhomes Hải Vân Bay<span>Dự án · Hạ tầng · Tiến độ · Chính sách</span>",
        "sub": "Cập nhật nhanh những thay đổi quan trọng cho người mua và nhà đầu tư. Đăng ký để nhận <b>bản tin & ảnh tiến độ</b> qua Zalo.",
        "sections": ["NEWS", "GALLERY", "CTABAND", "RIBBON", "FAQ", "CONTACT"],
    },
]


def split_sections(main):
    """Return ordered list of (NAME, html) from the <main> body."""
    parts = re.split(r"(<!-- ([A-Z]+) -->)", main)
    out = []
    for i in range(1, len(parts), 3):
        out.append((parts[i + 1], parts[i] + parts[i + 2]))
    return out


def build():
    src = SRC.read_text(encoding="utf-8")
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
        body = "\n".join(sections[n] for n in (["HERO"] + [x for x in names if x != "HERO"]) if n in sections)
        head, tail = before, after
        url = SITE + pg["path"]

        if pg["sections"]:
            hero = sections["HERO"]
            hero = re.sub(r"<h1>.*?</h1>", "<h1>" + pg["h1"] + "</h1>", hero, count=1, flags=re.S)
            hero = re.sub(r'<p class="sub">.*?</p>', '<p class="sub">' + pg["sub"] + "</p>", hero, count=1, flags=re.S)
            hero = re.sub(r'(<span class="badge"><i></i>).*?(</span>)', r"\g<1> " + pg["badge"] + r"\2", hero, count=1, flags=re.S)
            hero = hero.replace('data-source="Hero"', 'data-source="Hero ' + pg["path"] + '"')
            body = body.replace(sections["HERO"], hero, 1)

            head = re.sub(r"<title>.*?</title>", "<title>" + pg["title"] + "</title>", head, count=1)
            head = re.sub(r'(<meta name="description" content=")[^"]*', r"\g<1>" + pg["desc"], head, count=1)
            head = re.sub(r'(<meta property="og:title" content=")[^"]*', r"\g<1>" + pg["title"], head, count=1)
            head = re.sub(r'(<meta property="og:description" content=")[^"]*', r"\g<1>" + pg["desc"], head, count=1)

        head = re.sub(r'(<link rel="canonical" href=")[^"]*', r"\g<1>" + url, head, count=1)
        head = re.sub(r'(<link rel="alternate" hreflang="vi" href=")[^"]*', r"\g<1>" + url, head, count=1)
        head = re.sub(r'(<meta property="og:url" content=")[^"]*', r"\g<1>" + url, head, count=1)

        html = head + body + tail
        # Anchors to sections not on this page go to the main page.
        present = set(re.findall(r'<section[^>]*\sid="([^"]+)"', body)) | {"top"}
        html = re.sub(r'href="#([\w-]+)"',
                      lambda mm: mm.group(0) if mm.group(1) in present else 'href="/#%s"' % mm.group(1), html)
        for sec, page in (("gio-hang", "/gio-hang"), ("chinh-sach", "/chinh-sach"), ("tinh-gia", "/tinh-gia"), ("tin-tuc", "/tin-tuc")):
            html = html.replace('href="/#%s"' % sec, 'href="%s"' % page)
        (DIST / pg["file"]).write_text(html, encoding="utf-8")
        print("built", pg["file"], len(html) // 1024, "KB")

    today = date.today().isoformat()
    urls = "\n".join(
        "  <url><loc>%s%s</loc><lastmod>%s</lastmod><changefreq>daily</changefreq><priority>%s</priority></url>"
        % (SITE, p["path"], today, "1.0" if p["path"] == "/" else "0.8") for p in PAGES)
    (DIST / "sitemap.xml").write_text(
        '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
        + urls + "\n</urlset>\n", encoding="utf-8")
    (DIST / "robots.txt").write_text("User-agent: *\nAllow: /\nSitemap: %s/sitemap.xml\n" % SITE, encoding="utf-8")


if __name__ == "__main__":
    build()
