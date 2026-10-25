"""Bỏ ảnh không được đăng trên hiephoangmt.com khỏi trang landing (chạy sau landing-sun-saphia.py / landing-fours.py):
ảnh vệ tinh / Google Maps, bản scan giấy tờ pháp lý, ảnh stock, ảnh chụp của nơi khác, bản vẽ quy hoạch chính thức.
Chỉ giữ phối cảnh, ảnh dựng mô hình và sơ đồ tự vẽ.

- Ảnh nằm trong <figure>: bỏ cả khung (kèm chú thích).
- Ảnh trong thẻ nội dung (article, card): chỉ bỏ ảnh, giữ chữ.
- Khung chứa chỉ còn trống sau khi bỏ: bỏ luôn.

Dùng: python3 landing-loc-anh.py trang1.html trang2.html …   (ghi đè file; in số ảnh đã bỏ)
"""
import re
import sys

BAN = [
    # Ảnh vệ tinh / bản đồ nền vệ tinh.
    'vi-tri-saphia', 'ban-do-gia-ban', 'ba-duong-xuong-bien', 'mo-rong-duong-bien', 'khu-dat-cong-vien', 'lrt-ban-do',
    # Giấy tờ pháp lý, hồ sơ, bản vẽ quy hoạch chính thức.
    'gcn-dau-tu-1', 'gcn-dau-tu-2', 'ho-so-son-thuy-ban-ve', 'ho-so-son-thuy-phuong-an', 'khop-noi-quy-hoach-nhs',
    'quy-hoach-vi-tri-cong-vien', 'mat-bang-cong-vien-2-45ha',
    # Ảnh stock / ảnh chụp của nơi khác.
    'lrt', 'the-thao-bien', 'kayak', 'sup', 'du-luon', 'jetski', 'kh-tre-tu-do', 'kh-nghi-duong-som', 'khach-du-lich',
    'bai-tam-son-thuy-thuc-te', 'bien-thuc-te-1', 'bien-thuc-te-2', 'bien-thuc-te-3', 'bien-thuc-te-4', 'bien-thuc-te-5',
    'flycam-ngu-hanh-son', 'phoi-canh-quang-truong-bien', 'galaxy-downtown',
]
IMG = re.compile(r'<img\b[^>]*\bsrc="[^"]*/(%s)(?:-\d{3,4})?\.(?:webp|jpe?g|png)"[^>]*>' % '|'.join(map(re.escape, BAN)), re.I)


def enclosing(html, pos, tag):
    """(đầu, cuối) của thẻ <tag> gần nhất bao quanh vị trí pos, hoặc None."""
    depth = 0
    for m in reversed(list(re.finditer(r'<(/?)%s\b[^>]*>' % tag, html[:pos], re.I))):
        if m.group(1):
            depth += 1
        elif depth:
            depth -= 1
        else:
            start = m.start()
            d = 0
            for n in re.finditer(r'<(/?)%s\b[^>]*>' % tag, html[start:], re.I):
                d += -1 if n.group(1) else 1
                if d == 0:
                    end = start + n.end()
                    return (start, end) if end > pos else None
            return None
    return None


def clean(html):
    removed = 0
    while True:
        m = IMG.search(html)
        if not m:
            break
        fig = enclosing(html, m.start(), 'figure')
        pic = enclosing(html, m.start(), 'picture')
        a, b = fig or pic or (m.start(), m.end())
        html = html[:a] + html[b:]
        removed += 1
    # Khung chứa trống (div/ul) sau khi bỏ ảnh.
    for _ in range(3):
        html = re.sub(r'<div\b[^>]*class="(?:g\d|gal|fg|k\d)[^"]*"[^>]*>\s*</div>', '', html)
    return html, removed


for f in sys.argv[1:]:
    s = open(f, encoding='utf-8').read()
    out, n = clean(s)
    left = IMG.findall(out) + re.findall(r'url\([^)]*/(?:%s)\.webp' % '|'.join(BAN), out)
    open(f, 'w', encoding='utf-8').write(out)
    print(f, '– bỏ', n, 'ảnh', '· CÒN: %s' % left if left else '')
