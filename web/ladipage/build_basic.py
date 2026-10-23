"""Dựng 3 trang cho LadiPage ở chế độ "basic" (giữ nguyên HTML, như trang Sun FourS Tower).

Khác bản kéo-thả (build.py): giữ đủ chat tự động, popup tài liệu, máy tính vay, nút nổi
và bố cục gốc. CSS và JS được nhúng thẳng vào trang, ảnh lấy qua jsDelivr từ repo public,
liên kết giữa các trang trỏ về tên miền thật.

Chạy: python3 web/ladipage/build_basic.py  ->  web/ladipage/basic/*.html
"""
import pathlib
import re

WEB = pathlib.Path(__file__).resolve().parent.parent
OUT = WEB / 'ladipage' / 'basic'
SITE = 'https://www.sun-danangdowntown.com'
CDN = 'https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@claude/great-tesla-ki0len/web/images/'
PAGES = {
    'index.html': ('da-nang-downtown.html', True),
    'sun-galaxy-complex/index.html': ('sun-galaxy-complex.html', False),
    'thap-69-tang/index.html': ('thap-69-tang.html', False),
}


def fix_urls(text, is_home):
    # Trang con trên LadiPage không có dấu "/" cuối
    for slug in ('sun-galaxy-complex', 'thap-69-tang'):
        text = text.replace(f'{SITE}/{slug}/', f'{SITE}/{slug}')
        text = re.sub(rf'href="/{slug}/(#[^"]*)?"', lambda m: f'href="{SITE}/{slug}{m.group(1) or ""}"', text)
        text = text.replace(f'href=\\"/{slug}/\\"', f'href=\\"{SITE}/{slug}\\"')  # trong chuỗi JS
    # Ảnh: tên miền chưa chứa ảnh, lấy qua CDN
    text = text.replace(f'{SITE}/images/', CDN)
    text = re.sub(r'(?<=["\s,(])/images/', CDN, text)
    # Liên kết về trang chủ
    if is_home:
        text = re.sub(r'href="/#([^"]*)"', r'href="#\1"', text)
        text = text.replace('href="/"', 'href="#"')
        text = text.replace('href="/#tinh-vay"', 'href="#tinh-vay"')
    else:
        text = re.sub(r'href="/#([^"]*)"', rf'href="{SITE}/#\1"', text)
        text = text.replace('href="/"', f'href="{SITE}/"')
    return text


def build():
    OUT.mkdir(parents=True, exist_ok=True)
    css = (WEB / 'assets' / 'site.css').read_text(encoding='utf-8')
    js = (WEB / 'assets' / 'site.js').read_text(encoding='utf-8')
    # Bọc toàn bộ để không trùng tên biến với jQuery/biến toàn cục LadiPage chèn vào
    js = '(function () {\n' + js + '\n})();'
    for src, (dest, is_home) in PAGES.items():
        html = (WEB / src).read_text(encoding='utf-8')
        html = html.replace('<link rel="stylesheet" href="/assets/site.css">', '<style>\n' + css + '</style>')
        page_js = fix_urls(js, is_home)
        html = html.replace('<script src="/assets/site.js" defer></script>', '<script>\n' + page_js + '\n</script>')
        html = fix_urls(html, is_home)
        for bad in ('/assets/', 'href="/', 'src="/', '"/images/'):
            if bad in html:
                raise SystemExit(f'{dest}: còn sót {bad}')
        (OUT / dest).write_text(html, encoding='utf-8')
        print(OUT / dest, len(html), 'bytes')
        if src == 'sun-galaxy-complex/index.html':
            build_galaxy_domain(html)



GALAXY_SITE = 'https://www.sun-galaxy-complex.com.vn'


def build_galaxy_domain(html):
    """Bản trang Sun Galaxy Complex cho tên miền riêng www.sun-galaxy-complex.com.vn.

    Canonical, og:url, schema và liên kết tới chính trang trỏ về tên miền riêng;
    liên kết sang Da Nang Downtown và Tháp 69 tầng giữ nguyên tên miền sun-danangdowntown.com.
    """
    own = f'{SITE}/sun-galaxy-complex'
    html = html.replace(f'"{own}"', f'"{GALAXY_SITE}/"')
    html = html.replace(f'"{own}#', f'"{GALAXY_SITE}/#')
    html = html.replace(f'href="{own}"', f'href="{GALAXY_SITE}/"')
    html = html.replace(f'content="{own}"', f'content="{GALAXY_SITE}/"')
    if own + '"' in html or own + '#' in html:
        raise SystemExit('sun-galaxy-complex-vn: còn sót liên kết về trang con')
    dest = OUT / 'sun-galaxy-complex-vn.html'
    dest.write_text(html, encoding='utf-8')
    print(dest, len(html), 'bytes')


if __name__ == '__main__':
    build()
