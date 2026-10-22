"""Chuyển trang web/index.html thành HTML tĩnh theo luật LadiPage (rules v2).

LadiPage dựng trang kéo-thả từ HTML: form và FAQ <details> được nhận thành phần tử
LadiPage, còn widget chạy bằng JS (chat, popup, máy tính vay) không giữ được nên
được thay bằng nội dung tĩnh. Ảnh trỏ về bản public trên GitHub để LadiPage tải về.

Chạy: python3 web/ladipage/build.py  ->  web/ladipage/da-nang-downtown.html
"""
import pathlib
import re

WEB = pathlib.Path(__file__).resolve().parent.parent
RAW = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/claude/great-tesla-ki0len/web/images/'

LOAN = '''    <h3 id="tinh-vay">Ví dụ khoản vay minh họa</h3>
    <p>Giả định vay 70% giá trị, ân hạn gốc và hỗ trợ lãi 0% trong 30 tháng, sau đó lãi suất 10%/năm, thời hạn vay 20 năm. Kết quả chỉ để tham khảo, lãi suất thực tế theo ngân hàng tại thời điểm giải ngân.</p>
    <div class="table-wrap">
      <table class="loan">
        <caption>Bảng tính minh họa, chưa gồm phí và bảo hiểm khoản vay</caption>
        <thead><tr><th scope="col">Giá căn hộ</th><th scope="col">Vốn tự có (30%)</th><th scope="col">Khoản vay (70%)</th><th scope="col">30 tháng đầu</th><th scope="col">Trả hàng tháng sau ân hạn</th></tr></thead>
        <tbody>
          <tr><td>3,6 tỷ</td><td>1,08 tỷ</td><td>2,52 tỷ</td><td>0 đ</td><td>~25,5 triệu</td></tr>
          <tr><td>5 tỷ</td><td>1,5 tỷ</td><td>3,5 tỷ</td><td>0 đ</td><td>~35,4 triệu</td></tr>
          <tr><td>8 tỷ</td><td>2,4 tỷ</td><td>5,6 tỷ</td><td>0 đ</td><td>~56,6 triệu</td></tr>
        </tbody>
      </table>
    </div>
    <div class="cta-row"><a class="btn btn-accent" href="#dang-ky">Nhận phương án vay theo căn bạn chọn</a></div>
'''

DOCS_FORM = '''    <div class="lead-box quick-lead">
      <div><h3>Nhận trọn bộ tài liệu qua Zalo trong 5 phút</h3><p>Bảng giá, mặt bằng, brochure và bảng tính dòng tiền.</p></div>
      <form id="docs-form">
        <label for="d-name">Họ và tên</label>
        <input id="d-name" name="name" type="text" autocomplete="name" placeholder="Nguyễn Văn A" required>
        <label for="d-phone">Số điện thoại / Zalo</label>
        <input id="d-phone" name="phone" type="tel" autocomplete="tel" placeholder="09xx xxx xxx" required>
        <button class="btn btn-accent" type="submit">Gửi tài liệu cho tôi</button>
      </form>
    </div>

'''

LEAD_FORM = '''      <form id="lead-form">
        <label for="f-name">Họ và tên</label>
        <input id="f-name" name="name" type="text" autocomplete="name" placeholder="Nguyễn Văn A" required>
        <label for="f-phone">Số điện thoại / Zalo</label>
        <input id="f-phone" name="phone" type="tel" autocomplete="tel" placeholder="09xx xxx xxx" required>
        <label for="f-need">Nhu cầu</label>
        <select id="f-need" name="need">
          <option value="" disabled selected>Chọn nhu cầu</option>
          <option>Mua để ở</option>
          <option>Đầu tư cho thuê</option>
          <option>Shophouse kinh doanh</option>
          <option>Tìm hiểu thêm</option>
        </select>
        <label for="f-type">Loại căn quan tâm</label>
        <select id="f-type" name="unit_type">
          <option value="" disabled selected>Chọn loại căn</option>
          <option>Studio / 1PN</option>
          <option>2PN</option>
          <option>3PN</option>
          <option>Sky Villa / Penthouse</option>
          <option>Shophouse</option>
        </select>
        <button class="btn btn-accent" type="submit">Nhận bảng giá ngay</button>
      </form>'''

FAB = """<div class="ldp-fab">
  <a class="ldp-fab-btn ldp-fab-chat" href="#dang-ky" aria-label="Chat tư vấn, để lại lời nhắn" title="Chat tư vấn"><svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M12 3C6.5 3 2 6.6 2 11c0 2.4 1.3 4.6 3.4 6.1L5 21l4.1-2.2c.9.2 1.9.3 2.9.3 5.5 0 10-3.6 10-8s-4.5-8-10-8zm-4 9.3a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6zm4 0a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6zm4 0a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6z"/></svg></a>
  <a class="ldp-fab-btn ldp-fab-call" href="tel:+84904567009" aria-label="Gọi 0904 567 009" title="Gọi 0904 567 009"><svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2a1 1 0 011-.25 11.4 11.4 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.6a1 1 0 01-.25 1z"/></svg></a>
  <a class="ldp-fab-btn ldp-fab-zalo" href="https://zalo.me/0904567009" target="_blank" rel="noopener" aria-label="Nhắn Zalo 0904 567 009" title="Zalo 0904 567 009">Zalo</a>
</div>
"""

EXTRA_CSS = '''
/* Bản LadiPage: một cột, không sticky, ảnh nền hero bằng CSS */
.site-header{position:relative}
/* Mọi khối cùng độ rộng 960px (khung desktop LadiPage), căn giữa đều hai bên */
.container,.layout{max-width:960px;margin-left:auto;margin-right:auto;padding-left:16px;padding-right:16px}
.layout{grid-template-columns:minmax(0,1fr);gap:0}
.hero .container{grid-template-columns:minmax(0,1.2fr) minmax(0,.8fr);gap:28px}
.nav{gap:16px}
.toc{display:none}
.hero.has-photo{background:linear-gradient(90deg,rgba(7,27,48,.92) 0%,rgba(7,27,48,.78) 45%,rgba(7,27,48,.4) 100%),url(''' + RAW + '''da-nang-downtown-phoi-canh-1920.webp) center/cover no-repeat}
.hero.has-photo::before{display:none}
.loan td,.loan th{text-align:right}
.loan td:first-child,.loan th:first-child{text-align:left}
.cta-row{display:flex;flex-wrap:wrap;gap:10px;margin:0 0 16px}
.quick-lead{grid-template-columns:1fr;margin:8px 0 28px}
.quick-lead h3{color:#fff;margin:0 0 6px}
.quick-lead p{margin:0}
.site-footer{padding-bottom:44px}
/* Nút nổi góc phải dưới: Chat, Gọi, Zalo */
.ldp-fab{position:fixed;right:20px;bottom:24px;z-index:999;display:flex;flex-direction:column;gap:14px}
.ldp-fab-btn{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#fff;font-weight:800;font-size:15px;box-shadow:0 8px 22px rgba(7,27,48,.35)}
.ldp-fab-chat{background:#0b2a4a;border:2px solid #ff7a1a}
.ldp-fab-call{background:#ff7a1a}
.ldp-fab-zalo{background:#0b2a4a;border:2px solid #ff7a1a;color:#fff}
@media (max-width:768px){.ldp-fab{right:14px;bottom:18px;gap:10px}.ldp-fab-btn{width:52px;height:52px;font-size:14px}}
'''


def sub_once(pattern, repl, text, flags=re.S):
    new, n = re.subn(pattern, repl, text, count=1, flags=flags)
    if n != 1:
        raise SystemExit(f'Không tìm thấy mẫu: {pattern[:60]}')
    return new


def build():
    src = (WEB / 'index.html').read_text(encoding='utf-8')
    css = (WEB / 'assets' / 'site.css').read_text(encoding='utf-8')
    head = re.search(r'<head>\n(.*?)</head>', src, re.S).group(1)
    body = re.search(r'<body>\n(.*)</body>', src, re.S).group(1)

    head = re.sub(r'<link rel="preload"[^>]*>\n', '', head)
    head = head.replace('<link rel="stylesheet" href="/assets/site.css">',
                        '<meta name="ladipage-rules" content="v2">\n<style>\n' + css + EXTRA_CSS + '</style>')

    b = body
    b = re.sub(r'<a class="skip".*?</a>\n', '', b)
    b = sub_once(r'  <picture class="hero-bg">.*?</picture>\n', '', b)
    b = sub_once(r'  <aside class="toc".*?</aside>\n', '', b)
    b = sub_once(r'<div class="float-cta">.*?</div>\n', '', b)
    b = re.sub(r'<script[^>]*src=[^>]*></script>\n?', '', b)
    b = b.replace('<details open>', '<details>')
    b = sub_once(r'    <h3 id="tinh-vay">.*?\n      </div>\n    </div>\n', DOCS_FORM + LOAN, b)
    b = sub_once(r'      <form id="lead-form".*?</form>', LEAD_FORM, b)
    # Nút mở popup/chat -> liên kết tới form đăng ký
    b = re.sub(r'<button class="([^"]*)" type="button" data-open="docs">(.*?)</button>', r'<a class="\1" href="#dang-ky">\2</a>', b)
    b = re.sub(r'<button class="link-btn" type="button" data-open="docs">(.*?)</button>', r'<a href="#dang-ky">\1</a>', b)
    b = b.replace(' data-open="docs"', '')
    b = b.replace('<button class="btn btn-ghost" type="button" data-open="chat">Chat tư vấn</button>',
                  '<a class="btn btn-ghost" href="tel:+84904567009">Gọi 0904 567 009</a>')
    # Trang con chưa có trên LadiPage: trỏ về mục tương ứng trong trang
    b = re.sub(r'href="/sun-galaxy-complex/[^"]*"', 'href="#sun-galaxy-complex"', b)
    b = re.sub(r'href="/thap-69-tang/[^"]*"', 'href="#thap-408m"', b)
    b = re.sub(r'href="/#([^"]*)"', r'href="#\1"', b)
    b = b.replace('href="/"', 'href="#tong-quan"')
    # Ảnh: bỏ srcset, dùng link tuyệt đối
    b = re.sub(r'\s(srcset|sizes)="[^"]*"', '', b)
    b = b.replace('/images/', RAW)

    out = '<!doctype html>\n<html lang="vi">\n<head>\n' + head + '</head>\n<body>\n' + b + FAB + '</body>\n</html>\n'
    for bad in ('data-open', 'type="button"', 'site.js', 'loan-calc', 'href="/'):
        if bad in out:
            raise SystemExit(f'Còn sót: {bad}')
    dest = WEB / 'ladipage' / 'da-nang-downtown.html'
    dest.write_text(out, encoding='utf-8')
    print(dest, len(out), 'bytes,', out.count('<form'), 'forms,', out.count('<details'), 'FAQ')


if __name__ == '__main__':
    build()
