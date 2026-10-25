"""Chuyển bộ landing Sun FourS Tower (nhánh telegram-notify, thư mục landing-pages/) thành trang trên hiephoangmt.com.

  trang-chu.html    → /du-an/fours-tower/                 (landing/fours-tower.html)
  toa-f2.html       → /du-an/fours-tower-f2-thap-mai/     (landing/fours-tower-f2-thap-mai.html)
  gio-hang.html     → /du-an/fours-tower/gio-hang/        (landing/fours-tower--gio-hang.html)
  phap-ly.html      → /du-an/fours-tower/phap-ly/
  hoi-dap.html      → /du-an/fours-tower/hoi-dap/
  bang-tinh-f2.html → /du-an/fours-tower/bang-tinh-f2/

Trang dự án: tiêu đề, mô tả, canonical, schema của WordPress (Rank Math). Trang con: lấy tiêu đề, mô tả, schema của landing,
canonical / link đổi sang hiephoangmt.com. Bỏ gtag riêng của landing. Không có tên đơn vị phân phối nào được ghi (kiểm tra tự động).

Dùng: python3 landing-fours.py <thư mục landing-pages> <thư mục landing của giao diện>
"""
import json
import os
import re
import sys

SRC, OUT = sys.argv[1], sys.argv[2]
DOMAIN = 'https://www.sun-fours-tower.com'
SITE = 'https://hiephoangmt.com'
PAGES = {
    'trang-chu': ('fours-tower', '/du-an/fours-tower/'),
    'toa-f2': ('fours-tower-f2-thap-mai', '/du-an/fours-tower-f2-thap-mai/'),
    'gio-hang': ('fours-tower--gio-hang', '/du-an/fours-tower/gio-hang/'),
    'phap-ly': ('fours-tower--phap-ly', '/du-an/fours-tower/phap-ly/'),
    'hoi-dap': ('fours-tower--hoi-dap', '/du-an/fours-tower/hoi-dap/'),
    'bang-tinh-f2': ('fours-tower--bang-tinh-f2', '/du-an/fours-tower/bang-tinh-f2/'),
}
LINKS = {'': '/du-an/fours-tower/', 'toa-f2-ads': '/du-an/fours-tower-f2-thap-mai/'}
LINKS.update({k: v[1] for k, v in PAGES.items() if k != 'trang-chu'})


def link(path_query):
    m = re.match(r'([^?#]*)(\?[^#]*)?(#.*)?$', path_query)
    path, q, h = m.group(1).strip('/'), m.group(2) or '', m.group(3) or ''
    return (LINKS[path] + q + h) if path in LINKS else None


def fix_links(html):
    def rep(m):
        to = link(m.group(2))
        return '%s="%s"' % (m.group(1), to) if to else m.group(0)
    html = re.sub(r'(href)="%s/?([^"]*)"' % re.escape(DOMAIN), rep, html)
    # Còn lại (JSON, chữ): đổi tên miền thành hiephoangmt.com.
    return html.replace(DOMAIN + '/', SITE + '/du-an/fours-tower/').replace(DOMAIN, SITE + '/du-an/fours-tower')


bad = re.compile(r'\bTATI\w*|\bTati\w*')
for name, (slug, url) in PAGES.items():
    s = open(os.path.join(SRC, name + '.html'), encoding='utf-8').read()
    head = s[s.find('<head>') + 6:s.find('</head>')]
    body = s[s.find('>', s.find('<body')) + 1:s.rfind('</body>')]

    keep = re.findall(r'<link[^>]+fonts\.(?:googleapis|gstatic)[^>]*>', head)
    keep += re.findall(r'<link[^>]+rel="preload"[^>]*>', head)
    keep += re.findall(r'<style[^>]*>.*?</style>', head, flags=re.S)
    meta = {}
    if '--' in slug:  # Trang con: tiêu đề, mô tả, schema riêng.
        t = re.search(r'<title>(.*?)</title>', head, flags=re.S)
        d = re.search(r'<meta name="description" content="([^"]*)"', head)
        meta = {'title': t.group(1).strip() if t else '', 'description': d.group(1) if d else '', 'url': url}
        keep += re.findall(r'<script type="application/ld\+json">.*?</script>', head, flags=re.S)
    head_out = fix_links('\n'.join(keep))

    body = re.sub(r'<script[^>]*googletagmanager[^>]*>\s*</script>', '', body)
    body = re.sub(r'<script>\s*window\.dataLayer.*?</script>', '', body, flags=re.S)
    body = fix_links(body)

    left = bad.findall(head_out + body)
    if left:
        sys.exit('%s: còn tên %s' % (name, sorted(set(left))))
    out = '<!--HH-LANDING-META ' + json.dumps(meta, ensure_ascii=False) + ' -->\n' if meta else ''
    out += '<!--HH-LANDING-HEAD-->\n' + head_out + '\n<!--HH-LANDING-BODY-->\n' + body
    open(os.path.join(OUT, slug + '.html'), 'w', encoding='utf-8').write(out)
    print('OK', name, '→', url, len(out))
