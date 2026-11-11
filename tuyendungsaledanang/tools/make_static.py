"""Chuyển trang chính, 5 trang vị trí và 3 bài kéo-thả sang bản tĩnh (menu ☰, SEO đủ, không cần menu.js)."""
import re, os, json, glob, subprocess, sys
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
S = 'https://www.tuyendungsaledanang.com'
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
SEO = json.load(open(sys.argv[1], encoding='utf-8'))
MENUJS = re.compile(r'<script src="https://cdn\.jsdelivr\.net/gh/hiephoangmt-debug/hoang-hiep-crm@[0-9a-f]+/tuyendungsaledanang/menu\.js" defer></script>\n?')

def seo_tags(s, k):
    d = SEO[k]; url = 'https://' + d['url']
    s = re.sub(r'<meta name="keywords"[^>]*>\n?', '', s)
    s = re.sub(r'<meta property="og:(?:url|type|image)"[^>]*>\n?', '', s)
    s = re.sub(r'<link rel="(?:icon|apple-touch-icon)"[^>]*>\n?', '', s)
    add = (f'<meta name="keywords" content="{d["Từ khoá về trang"]}">\n'
           f'<meta property="og:url" content="{url}">\n<meta property="og:type" content="website">\n'
           f'<meta property="og:image" content="{d["Hình ảnh khi chia sẻ"]}">\n'
           f'<link rel="icon" href="{IMG}favicon-tuyen-sale.png">\n<link rel="apple-touch-icon" href="{IMG}favicon-tuyen-sale.png">\n')
    if 'og:title' not in s: add += f'<meta property="og:title" content="{d["Tiêu đề trang"]}">\n'
    if 'og:description' not in s: add += f'<meta property="og:description" content="{d["Mô tả trang"]}">\n'
    if '<link rel="canonical"' not in s: add += f'<link rel="canonical" href="{url}">\n'
    return s.replace('</head>', add + '</head>', 1)

# ---------- trang chính: header có nút ☰ ----------
p = os.path.join(ROOT, 'index.html'); s = open(p, encoding='utf-8').read()
old = s[s.index('<header class="top">'):s.index('</header>') + 9]
hdr = f'''<header class="top"><input type="checkbox" id="hm-tg" class="hm-tg" aria-hidden="true">
  <div class="wrap">
    <a class="brand" href="{S}/" style="text-decoration:none;white-space:nowrap">TUYỂN SALE <span>ĐÀ NẴNG</span></a>
    <div class="hm-act"><a class="hm-call" href="tel:0904567009">📞<span> 0904 567 009</span></a><a class="hm-apply" href="{S}/#dang-ky">Ứng tuyển</a><label for="hm-tg" class="hm-bg" aria-label="Mở menu"><span class="o">☰</span><span class="x">✕</span></label></div>
  </div>
  <nav class="hm-menu" onclick="document.getElementById('hm-tg').checked=false"><div class="wrap"><a href="{S}/">Trang chủ</a><a href="{S}/#vi-tri">Vị trí tuyển</a><a href="{S}/#chinh-sach">Chính sách</a><a href="{S}/#mkt-3-lop">Marketing 3 lớp</a><a href="{S}/#du-an">Dự án</a><a href="{S}/#cam-nang">Cẩm nang</a><a href="{S}/#doi-ngu">Đội ngũ</a><a href="{S}/#faq">Hỏi đáp</a><a href="https://zalo.me/0904567009" target="_blank" rel="noopener">Zalo</a></div></nav>
</header>'''
s = s.replace(old, hdr)
CSS = ('.hm-tg{display:none}.hm-bg{display:none;width:42px;height:38px;border:1px solid rgba(255,255,255,.35);border-radius:8px;color:#fff;font-size:22px;line-height:36px;text-align:center;cursor:pointer;user-select:none}.hm-bg .x{display:none}\n'
       '@media(max-width:760px){.hm-bg{display:inline-block}.top .hm-menu{display:none;max-height:calc(100vh - 60px);overflow-y:auto}.hm-tg:checked~.hm-menu{display:block}'
       '.hm-tg:checked~.wrap .hm-bg .o{display:none}.hm-tg:checked~.wrap .hm-bg .x{display:inline}'
       '.top .hm-menu .wrap{display:block;white-space:normal;overflow:visible;padding-top:4px;padding-bottom:10px}.top .hm-menu a{display:block;padding:12px 4px;border-bottom:1px solid rgba(255,255,255,.08);font-size:15px}}\n'
       '@media(max-width:520px){.hm-call span{display:none}}\n')
if '.hm-tg{' not in s:
    i = s.index('</style>'); s = s[:i] + CSS + s[i:]
s = MENUJS.sub('', s)
open(p, 'w', encoding='utf-8').write(s)
# 5 trang vị trí sinh lại từ trang chính
subprocess.run([sys.executable, os.path.join(ROOT, 'tools', 'build_vitri.py')], check=True, stdout=subprocess.DEVNULL)
s = open(p, encoding='utf-8').read(); open(p, 'w', encoding='utf-8').write(seo_tags(s, 'chinh'))
for f, k in [('nhan-vien', 'nv'), ('chuyen-vien', 'cv'), ('pro-sales', 'pro'), ('truong-nhom', 'tn'), ('moi-ra-truong', 'sv')]:
    q = os.path.join(ROOT, 'vi-tri', f + '.html'); t = MENUJS.sub('', open(q, encoding='utf-8').read())
    open(q, 'w', encoding='utf-8').write(seo_tags(t, k))

# ---------- 3 bài kéo-thả: header ☰ giống bài tĩnh ----------
ref = open(os.path.join(ROOT, 'bai', 'lo-trinh-sale-moi-60-ngay-dau.html'), encoding='utf-8').read()
refcss = re.search(r'\.hm-tg\{display:none\}.*?\n.*?\n@media\(max-width:760px\)\{[^\n]*\n[^\n]*\}\}', ref, re.S).group(0)
for f, k in [('cham-khach-qua-zalo', 'b5'), ('quay-video-ngan-ban-bds', 'b4'), ('chay-quang-cao-facebook-cho-nguoi-moi', 'b2')]:
    q = os.path.join(ROOT, 'bai', f + '.html'); t = open(q, encoding='utf-8').read()
    a = t.index('<div class="top">'); b = t.index('</nav></div>', a) + len('</nav></div>')
    toc = '<a href="#muc-luc">📑 Mục lục</a>' if 'id="muc-luc"' in t else ''
    bar = (f'<div class="top"><input type="checkbox" id="hm-tg" class="hm-tg" aria-hidden="true"><div class="wrap"><a class="brand" href="{S}/">TUYỂN SALE <em>ĐÀ NẴNG</em></a>'
           f'<div class="act"><a class="call" href="tel:0904567009">📞<span> 0904 567 009</span></a><a class="apply-btn" href="{S}/#dang-ky">Ứng tuyển</a>'
           f'<label for="hm-tg" class="bg" aria-label="Mở menu"><span class="o">☰</span><span class="x">✕</span></label></div></div>'
           f'<nav class="menu" onclick="document.getElementById(\'hm-tg\').checked=false"><div class="wrap">{toc}<a href="{S}/">Trang chủ</a><a href="{S}/#vi-tri">Vị trí tuyển</a>'
           f'<a href="{S}/#chinh-sach">Chính sách</a><a href="{S}/#cam-nang">Cẩm nang</a><a href="#du-an-dang-ban">Dự án</a><a href="https://zalo.me/0904567009" target="_blank" rel="noopener">Zalo</a></div></nav></div>')
    t = t[:a] + bar + t[b:]
    if '.hm-tg{display:none}' not in t: t = t.replace('</style>', refcss + '\n</style>', 1)
    t = MENUJS.sub('', t)
    open(q, 'w', encoding='utf-8').write(seo_tags(t, k))
# 7 bài tĩnh còn lại: chỉ bổ sung SEO
for f, k in [('lo-trinh-sale-moi-60-ngay-dau', 'b7'), ('dang-tin-rao-vat-bat-dong-san', 'b6'), ('luu-y-truoc-khi-chay-quang-cao-facebook', 'b1'), ('chay-google-ads-cho-nguoi-moi', 'b3')]:
    q = os.path.join(ROOT, 'bai', f + '.html'); t = open(q, encoding='utf-8').read()
    open(q, 'w', encoding='utf-8').write(seo_tags(t, k))
print('done')
