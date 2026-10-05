#!/usr/bin/env python3
"""Xuất trang chủ thành 1 file HTML tĩnh theo luật LadiPage (ladipage-rules v2).

Cách dùng:  python3 build.py && python3 export_ladipage.py
Kết quả: ladipage/index.html – HTML tự chứa (CSS inline, icon inline, không JS)
- Form báo phí -> form thu lead của LadiPage (họ tên, SĐT, dịch vụ, ngân hàng, số tiền, ngày đến hạn)
- Công cụ tính tiền phạt -> bảng ví dụ tĩnh
- FAQ dùng <details> (accordion LadiPage)
"""
import os, re

import build

HERE = os.path.dirname(os.path.abspath(__file__))
s = open(os.path.join(HERE, "index.html"), encoding="utf-8").read()
css = open(os.path.join(HERE, "assets/site.css"), encoding="utf-8").read()
ZALO, TEL = "https://zalo.me/" + build.SITE["phone"], "tel:" + build.SITE["phone"]

# 1) Icon: thay <use href="#id"> bằng nội dung symbol (LadiPage không giữ sprite)
symbols = {m.group(1): (m.group(2), m.group(3)) for m in
           re.finditer(r'<symbol id="([^"]+)" (viewBox="[^"]+"[^>]*)>(.*?)</symbol>', s, re.S)}
s = re.sub(r'<svg width="0" height="0".*?</svg>\n', "", s, count=1, flags=re.S)
def inline_icon(m):
    attrs, inner = symbols[m.group(2)]
    return f'<svg{m.group(1)} {attrs}>{inner}</svg>'
s = re.sub(r'<svg([^>]*)><use href="#([^"]+)"/></svg>', inline_icon, s)

# 2) Link Zalo / gọi điện cố định (không cần JS)
s = re.sub(r'href="#"([^>]*?)data-zalo', rf'href="{ZALO}" target="_blank" rel="noopener"\1data-zalo', s)
s = re.sub(r'href="#"([^>]*?)data-tel', rf'href="{TEL}"\1data-tel', s)

# Head: marker LadiPage + CSS inline (trước bước đổi link)
s = s.replace('<link rel="stylesheet" href="assets/site.css">',
              '<meta name="ladipage-rules" content="v2">\n<style>\n' + css + "\n.calc .tbl{background:#fff;color:#0f1b33}\n</style>")
s = s.replace('<script src="assets/site.js"></script>', "")

# Logo: bỏ dòng phụ (LadiPage phóng to chữ nhỏ -> tràn dòng trên mobile)
s = s.replace("<span>Thẻ Tín Dụng Đà Nẵng<small>ĐÁO HẠN · RÚT TIỀN · MỞ THẺ</small></span>",
              '<span style="white-space:nowrap">Thẻ Tín Dụng Đà Nẵng</span>')

# Menu cho bản 1 trang
s = re.sub(r'<nav class="menu".*?</nav>', '''<nav class="menu" aria-label="Menu chính">
      <a href="#dich-vu">Dịch vụ</a>
      <a href="#bang-phi">Bảng phí</a>
      <a href="#dao-han-la-gi">Đáo hạn là gì?</a>
      <a href="#quy-trinh">Quy trình</a>
      <a href="#hoi-dap">Hỏi đáp</a>
    </nav>''', s, count=1, flags=re.S)

# 3) Link trang con -> mục trong trang (bản LadiPage chỉ có 1 trang)
def relink(m):
    h = m.group(1)
    if h.startswith(("http", "#", "tel:", "mailto:", "data:")):
        return m.group(0)
    if h in ("./", ""):
        return 'href="#"'
    if "bang-phi" in h or h.startswith("dao-han-the-") and h != "dao-han-the-tin-dung-da-nang/":
        return 'href="#bang-phi"'
    if "gioi-thieu" in h:
        return 'href="#lien-he"'
    if "dao-han" in h or "rut-tien" in h:
        return 'href="#dich-vu"'
    return 'href="#hoi-dap"'
s = re.sub(r'href="([^"]*)"', relink, s)

# 4) Form báo phí -> form thu lead LadiPage
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

# 5) Công cụ tính -> bảng ví dụ tĩnh
calc = '''<div class="calc-box" style="grid-template-columns:1fr">
      <div style="min-width:0">''' + build.example_table() + '''
        <p class="note">* Ước tính: lãi 28%/năm trên toàn bộ dư nợ trong 30 ngày + phí phạt 5% khoản tối thiểu (tối thiểu 99.000đ). Mức thực tế theo biểu phí từng ngân hàng.</p>
        <a href="''' + ZALO + '''" target="_blank" rel="noopener" class="btn btn-zalo">So sánh phí đáo hạn qua Zalo</a>
      </div>
    </div>'''
s = re.sub(r'<div class="calc-box">.*?</div>\s*</div>\s*</div>\s*</section>', calc + "\n  </div>\n</section>", s, count=1, flags=re.S)
s = s.replace(">Công cụ tính nhanh<", ">Ví dụ chi phí<")
s = s.replace("Kéo thanh trượt để xem ước tính chi phí khi để thẻ trễ hạn.", "Bảng ước tính chi phí khi để thẻ trễ hạn 1 tháng.")

# 6) Bỏ phần cần JS / trỏ sang trang con
s = re.sub(r'<!-- KNOWLEDGE -->.*?(?=<!-- FAQ -->)', "", s, flags=re.S)
s = re.sub(r'<span class="status" id="status">.*?</span></span>', '<span class="status"><i></i><span>Trả lời Zalo trong 5 phút (7h30 – 21h00)</span></span>', s, flags=re.S)
s = re.sub(r'<script src="assets/site.js"></script>', "", s)
s = s.replace("<details open>", "<details>")
s = s.replace(' class="reveal"', "").replace(" reveal", "")
s = s.replace('<span id="yr">2026</span>', "2026")
s = s.replace('<span data-address>Phục vụ tận nơi toàn TP</span>', "Phục vụ tận nơi toàn TP")
s = s.replace('<div class="foot">\n      <div>', '<div class="foot">\n      <div id="lien-he">', 1)


os.makedirs(os.path.join(HERE, "ladipage"), exist_ok=True)
open(os.path.join(HERE, "ladipage/index.html"), "w", encoding="utf-8").write(s)
print("ladipage/index.html", len(s), "bytes; leftover <use>:", s.count("<use "), "; scripts:", len(re.findall(r"<script(?! type=\"application/ld\+json\")", s)))
