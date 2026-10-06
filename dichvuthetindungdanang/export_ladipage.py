#!/usr/bin/env python3
"""Xuất toàn bộ site thành các file HTML tĩnh theo luật LadiPage (ladipage-rules v2).

Cách dùng:  python3 build.py && python3 export_ladipage.py
Kết quả: ladipage/<duong-dan>.html – mỗi file là 1 landing page, xuất bản trên LadiPage
tại build.DOMAIN + <duong-dan> (hiện là the-tin-dung-da-nang.com) (trang chủ: index.html -> "/").
- CSS inline, icon inline, không JS (LadiPage không chạy JS tự viết)
- Link nội bộ trỏ tới URL thật trên tên miền (đường dẫn phẳng, không dấu "/" cuối)
- Trang chủ: form báo phí -> form thu lead; công cụ tính -> bảng ví dụ tĩnh
- FAQ dùng <details> (accordion LadiPage)
"""
import os, re

import build

HERE = os.path.dirname(os.path.abspath(__file__))
DOMAIN = build.DOMAIN
CSS = open(os.path.join(HERE, "assets/site.css"), encoding="utf-8").read()
ZALO, TEL = "https://zalo.me/" + build.SITE["phone"], "tel:" + build.SITE["phone"]


def flat(slug):
    """Đường dẫn trên LadiPage: 1 cấp, bỏ tiền tố kien-thuc/ của bài viết."""
    return slug.split("/")[-1] if slug.startswith("kien-thuc/") else slug


def lp_url(slug):
    return DOMAIN + flat(slug) if slug else DOMAIN


TLIST_CSS = """
/* Bản LadiPage: bảng -> danh sách xếp dọc (LadiPage cố định chiều cao ô bảng nên chữ bị che trên mobile) */
.tlist{list-style:none;margin:16px 0 20px;padding:0}
.tlist li{background:#f5f7fb;border-radius:12px;padding:14px 16px;margin:0 0 10px;line-height:1.65;color:#2a3654}
.tlist li strong{color:#0b1f44}
.tlist .fee{color:#d65f00;font-weight:800}
.calc .tlist li{background:#fff}
/* Lề đều hai bên trên điện thoại + chừa khoảng an toàn để chữ không chạm/tràn mép khung LadiPage */
@media(max-width:700px){
  .container{padding-left:28px!important;padding-right:28px!important}
  .prose p,.prose li,.prose h2,.prose h3,.phero h1,.phero .intro,.tldr li,.tlist li,.box p{padding-right:6px}
  .prose ul,.prose ol,.tldr ul{margin-left:18px;margin-right:0}
  .page{gap:28px}
  .btn{white-space:normal;max-width:100%;text-align:center}
  .center .btn,.calc .btn,.inline-cta .btn{width:100%;margin:6px 0}
}
"""


def cell(html):
    return re.sub(r"\s+", " ", html).strip()


def table_to_list(m):
    t = m.group(0)
    heads = [cell(re.sub(r"<.*?>", "", h)) for h in re.findall(r"<th[^>]*>(.*?)</th>", t, re.S)]
    items = []
    for row in re.findall(r"<tr>(.*?)</tr>", re.sub(r"<thead>.*?</thead>", "", t, flags=re.S), re.S):
        cells = re.findall(r"<td( class=\"fee\")?>(.*?)</td>", row, re.S)
        if not cells:
            continue
        vals = [(f'<span class="fee">{cell(v)}</span>' if fee else cell(v)) for fee, v in cells]
        first = re.sub(r"</?strong>", "", vals[0])
        if heads:
            rest = "<br>".join(f"{heads[i]}: {v}" for i, v in enumerate(vals[1:], 1))
            items.append(f"<li><strong>{first}</strong><br>{rest}</li>")
        else:
            items.append(f"<li><strong>{first}</strong>: {' · '.join(vals[1:])}</li>")
    return '<ul class="tlist">' + "".join(items) + "</ul>"


def facts_to_list(m):
    pairs = re.findall(r"<dt>(.*?)</dt><dd>(.*?)</dd>", m.group(0), re.S)
    return '<ul class="tlist">' + "".join(f"<li><strong>{d}</strong>: {v}</li>" for d, v in pairs) + "</ul>"


def convert(s, slug):
    # CSS inline + marker LadiPage
    s = re.sub(r'<link rel="stylesheet" href="[./]*assets/site.css">',
               lambda m: '<meta name="ladipage-rules" content="v2">\n<style>\n' + CSS +
               "\n.reveal{opacity:1;transform:none}\n" + TLIST_CSS + "</style>", s)
    s = re.sub(r'<script src="[./]*assets/site.js"></script>', "", s)

    # Icon: thay <use href="#id"> bằng nội dung symbol (LadiPage không giữ sprite)
    symbols = {m.group(1): (m.group(2), m.group(3)) for m in
               re.finditer(r'<symbol id="([^"]+)" (viewBox="[^"]+"[^>]*)>(.*?)</symbol>', s, re.S)}
    s = re.sub(r'<svg width="0" height="0".*?</svg>\n', "", s, count=1, flags=re.S)
    s = re.sub(r'<svg([^>]*)><use href="#([^"]+)"/></svg>',
               lambda m: f'<svg{m.group(1)} {symbols[m.group(2)][0]}>{symbols[m.group(2)][1]}</svg>', s)

    # Logo 1 dòng (LadiPage phóng to chữ nhỏ -> tràn dòng trên mobile)
    s = s.replace("<span>Thẻ Tín Dụng Đà Nẵng<small>ĐÁO HẠN · RÚT TIỀN · MỞ THẺ</small></span>",
                  '<span style="white-space:nowrap">Thẻ Tín Dụng Đà Nẵng</span>')

    # Zalo / gọi điện cố định
    s = re.sub(r'href="#"([^>]*?)data-zalo', rf'href="{ZALO}" target="_blank" rel="noopener"\1data-zalo', s)
    s = re.sub(r'href="#"([^>]*?)data-tel', rf'href="{TEL}"\1data-tel', s)

    # URL tuyệt đối (canonical, og:url, JSON-LD) -> đường dẫn phẳng
    for p in sorted(build.PAGES, key=lambda q: -len(q["slug"])):
        s = s.replace(DOMAIN + p["slug"] + "/", lp_url(p["slug"]))

    # Link tương đối -> URL thật trên tên miền
    def relink(m):
        h = m.group(1)
        if h.startswith(("http", "tel:", "mailto:", "data:", "#")):
            return m.group(0)
        path, _, anchor = h.partition("#")
        target = os.path.normpath(os.path.join(slug or ".", path)) if path else ""
        target = "" if target in (".", "") else target.strip("/")
        return f'href="{lp_url(target)}{"#" + anchor if anchor else ""}"'
    s = re.sub(r'href="([^"]*)"', relink, s)

    # Bảng & danh sách thông tin -> danh sách xếp dọc
    s = re.sub(r'<div class="tbl"><table>.*?</table></div>', table_to_list, s, flags=re.S)
    s = re.sub(r'<dl class="facts">.*?</dl>', facts_to_list, s, flags=re.S)

    # Link "#..." tới trang khác: LadiPage không nhảy được tới mục -> trỏ thẳng trang đó
    s = re.sub(r'href="(' + re.escape(DOMAIN) + r'[^"#]*)#[^"]*"', r'href="\1"', s)
    s = re.sub(r'\s*<li><a href="[^"]*">Câu hỏi thường gặp</a></li>', "", s)

    # Mục lục: LadiPage bỏ id của tiêu đề nên link "#..." không nhảy -> bỏ mục lục
    s = re.sub(r'<nav class="toc".*?</nav>', "", s, flags=re.S)

    # Dọn phần cần JS
    s = s.replace("<details open>", "<details>")
    s = s.replace(' class="reveal"', "").replace(" reveal", "")
    s = s.replace('<span id="yr">2026</span>', "2026")
    s = s.replace('<span data-address>Phục vụ tận nơi toàn TP</span>', "Phục vụ tận nơi toàn TP")
    return s


def convert_home(s):
    s = convert(s, "")
    form = f'''<form class="qform" id="qform">
        <span class="eyebrow">Miễn phí · Không ràng buộc</span>
        <h3 id="bp">Nhận báo phí trong 1 phút</h3>
        <p class="sub">Để lại thông tin, chúng tôi gọi/nhắn Zalo báo phí ngay. Không cần cung cấp số thẻ.</p>
        <label for="hoten">Họ và tên</label><input id="hoten" name="name" type="text" placeholder="Nguyễn Văn A">
        <label for="sdt">Số điện thoại / Zalo</label><input id="sdt" name="phone" type="tel" placeholder="09xx xxx xxx">
        <label for="dichvu">Bạn cần</label>
        <select id="dichvu" name="dich_vu"><option value="" disabled selected>Chọn dịch vụ</option><option>Đáo hạn thẻ</option><option>Rút tiền thẻ</option><option>Tư vấn mở thẻ</option></select>
        <label for="bank">Ngân hàng</label>
        <select id="bank" name="ngan_hang"><option value="" disabled selected>Chọn ngân hàng</option>{"".join(f"<option>{b[1]}</option>" for b in build.BANKS)}<option>Ngân hàng khác</option></select>
        <label for="amt">Số tiền (triệu đồng)</label><input id="amt" name="so_tien" type="number" placeholder="Ví dụ: 20">
        <label for="dueDate">Ngày đến hạn thanh toán</label><input id="dueDate" name="ngay_den_han" type="date">
        <button type="submit" class="btn btn-zalo">Gửi – nhận báo phí ngay</button>
        <p class="qhint">Cần gấp? <a href="{ZALO}" target="_blank" rel="noopener">Chat Zalo 0909 669 325</a></p>
      </form>'''
    s = re.sub(r'<form class="qform" id="qform".*?</form>', form, s, count=1, flags=re.S)
    calc = ('<div class="calc-box" style="grid-template-columns:1fr">\n      <div style="min-width:0">' + build.example_table() +
            '\n        <p class="note">* Ước tính: lãi 28%/năm trên toàn bộ dư nợ trong 30 ngày + phí phạt 5% khoản tối thiểu (tối thiểu 99.000đ). Mức thực tế theo biểu phí từng ngân hàng.</p>'
            f'\n        <a href="{ZALO}" target="_blank" rel="noopener" class="btn btn-zalo">So sánh phí đáo hạn qua Zalo</a>\n      </div>\n    </div>')
    s = re.sub(r'<div class="calc-box">.*?</div>\s*</div>\s*</div>\s*</section>', calc + "\n  </div>\n</section>", s, count=1, flags=re.S)
    s = s.replace(">Công cụ tính nhanh<", ">Ví dụ chi phí<")
    s = s.replace("Kéo thanh trượt để xem ước tính chi phí khi để thẻ trễ hạn.", "Bảng ước tính chi phí khi để thẻ trễ hạn 1 tháng.")
    s = re.sub(r'<span class="status" id="status">.*?</span></span>',
               '<span class="status"><i></i><span>Trả lời Zalo trong 5 phút (7h30 – 21h00)</span></span>', s, flags=re.S)
    s = re.sub(r'<div class="tbl"><table>.*?</table></div>', table_to_list, s, flags=re.S)
    return s


def main():
    out = os.path.join(HERE, "ladipage")
    os.makedirs(out, exist_ok=True)
    for f in os.listdir(out):
        os.remove(os.path.join(out, f))
    files = [("index.html", convert_home(open(os.path.join(HERE, "index.html"), encoding="utf-8").read()))]
    for p in build.PAGES:
        src = open(os.path.join(HERE, p["slug"], "index.html"), encoding="utf-8").read()
        files.append((flat(p["slug"]) + ".html", convert(src, p["slug"])))
    for name, s in files:
        open(os.path.join(out, name), "w", encoding="utf-8").write(s)
        bad = s.count("<use ") + len(re.findall(r'<script(?! type="application/ld\+json")', s))
        print(f"{name:52s} {len(s)//1024:4d} KB{'  !! use/script: ' + str(bad) if bad else ''}")


if __name__ == "__main__":
    main()
