"""Viết lại chữ trang landing cho hiephoangmt.com (giữ bố cục, số liệu) để không trùng nguyên văn với web landing gốc.

  python3 landing-viet-lai.py tach <trang.html> <chu.json>       – tách các khối chữ (tiêu đề, đoạn văn, dòng liệt kê, hỏi đáp)
  python3 landing-viet-lai.py ghep <trang.html> <chu-moi.json>    – ghép chữ đã viết lại vào trang (ghi đè file)

chu.json: {"k0001": "<nội dung HTML trong khối>", ...}. Khối có thẻ con dạng khối (div, ul…) thì bỏ qua – chỉ lấy khối "lá".
"""
import json
import re
import sys

BLOCK = r'h1|h2|h3|h4|p|li|dd|dt|figcaption|blockquote|summary|div|label'
INLINE_OK = re.compile(r'</?(?:b|strong|i|em|a|span|br|small|sup|sub|mark|u)\b[^>]*>', re.I)
SKIP = re.compile(r'<(script|style|noscript|svg|template)\b.*?</\1>', re.S | re.I)


def blocks(html):
    """Trả về [(start, end_inner_start, end_inner_end, inner)] cho khối lá ngoài script/style."""
    masked = SKIP.sub(lambda m: ' ' * len(m.group(0)), html)
    # Bỏ qua phần trong thuộc tính / JSON: chỉ xét thân trang đã che script.
    out = []
    for m in re.finditer(r'<(%s)\b[^>]*>' % BLOCK, masked, re.I):
        tag = m.group(1).lower()
        close = re.search(r'</%s\s*>' % tag, masked[m.end():], re.I)
        if not close:
            continue
        a, b = m.end(), m.end() + close.start()
        inner = html[a:b]
        if re.search(r'<(?:%s|div|ul|ol|table|section|form|img|picture|button|input|select)\b' % BLOCK, inner, re.I):
            continue  # Không phải khối lá.
        text = re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', ' ', inner)).strip()
        if len(text) < 28 or not re.search(r'[a-zà-ỹ]{3}', text, re.I):
            continue
        out.append((a, b, inner))
    return out


def main():
    cmd, page, js = sys.argv[1], sys.argv[2], sys.argv[3]
    html = open(page, encoding='utf-8').read()
    marker = '<!--HH-LANDING-BODY-->'
    pre, body = (html.split(marker, 1) if marker in html else ('', html))
    bl = blocks(body)
    if cmd == 'tach':
        data = {'k%04d' % i: inner.strip() for i, (_, _, inner) in enumerate(bl)}
        json.dump(data, open(js, 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
        print(len(data), 'khối,', sum(len(re.sub(r'<[^>]+>', '', v)) for v in data.values()), 'ký tự')
        return
    new = json.load(open(js, encoding='utf-8'))
    parts, last, n = [], 0, 0
    for i, (a, b, inner) in enumerate(bl):
        k = 'k%04d' % i
        if k not in new or not str(new[k]).strip():
            continue
        v = str(new[k]).strip()
        if v == inner.strip():
            continue  # Không đổi chữ: giữ nguyên khối (kể cả biểu tượng SVG bên trong).
        # Chỉ cho phép thẻ trong dòng (b, a, span…) và biểu tượng SVG; thẻ khác → bỏ.
        v = re.sub(r'<(?!/?(?:b|strong|i|em|a|span|br|small|sup|sub|mark|u|svg|path|circle|rect|g|line|polyline|polygon|use)\b)[^>]*>', '', v)
        parts.append(body[last:a] + v)
        last, n = b, n + 1
    parts.append(body[last:])
    out = (pre + marker if pre else '') + ''.join(parts)
    open(page, 'w', encoding='utf-8').write(out)
    print('Đã ghép', n, '/', len(bl), 'khối')


main()
