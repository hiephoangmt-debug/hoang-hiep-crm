"""Thêm nút "Theo dõi Fanpage" (Tuyển Sale BĐS Đà Nẵng) vào chân trang mọi trang và cụm liên hệ nổi của bài viết.
Chạy lại không bị nhân đôi. Dùng: python3 tools/add_fb_follow.py"""
import glob, os, re
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
FB = 'https://www.facebook.com/profile.php?id=1509370688917506'
SVG = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="fill:#fff;flex:none"><path d="M14 8.5V6.8c0-.8.2-1.3 1.4-1.3H17V2.6c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.4-4 4.1v1.9H8v3.2h2.6V21h3.4v-9.3h2.6l.4-3.2H14z"/></svg>'
FOOT = (f'<!--fbf--><p style="margin:14px 0 0"><a href="{FB}" target="_blank" rel="noopener" '
        f'style="display:inline-flex;align-items:center;gap:8px;background:#1877F2;color:#fff;font-weight:800;'
        f'text-decoration:none;padding:10px 16px;border-radius:999px;font-size:15px;white-space:nowrap">{SVG}Theo dõi Fanpage tuyển dụng</a></p><!--/fbf-->')
WID = (f'<!--fbw--><a class="hhf-fb" href="{FB}" target="_blank" rel="noopener" aria-label="Theo dõi Fanpage Tuyển Sale BĐS Đà Nẵng">'
       f'<span class="hhf-lb">Theo dõi <b>Fanpage</b></span><span class="hhf-ic" style="background:#1877F2">{SVG.replace("18","24")}</span></a><!--/fbw-->\n  ')
NHS = ('<!--nhs--><a class="hhf-nhs" href="https://www.tuyendungsaledanang.com/ung-tuyen" aria-label="Nộp hồ sơ ứng tuyển" '
       'style="background:#FF6B1A;color:#fff;font-weight:900;font-size:15px;padding:12px 16px;border-radius:999px;border:3px solid #fff;'
       'box-shadow:0 8px 20px rgba(21,36,90,.28);white-space:nowrap;gap:6px">📄 Nộp hồ sơ</a><!--/nhs-->\n  ')
RX = re.compile(r'<!--(?:fb[fw]|nhs)-->.*?<!--/(?:fb[fw]|nhs)-->\n?\s*', re.S)

def apply(s):
    s = RX.sub('', s)
    if '<footer' in s:
        f0 = s.index('<footer')
        m = s.find('mailto:hiephoangmt@gmail.com', f0)
        if m > 0:
            e = s.index('</p>', m) + 4
            s = s[:e] + FOOT + s[e:]
    z = s.find('<a class="hhf-zalo"')
    if z > 0:
        s = s[:z] + NHS + WID + s[z:]
    return s

if __name__ == '__main__':
    files = ['index.html'] + sorted(glob.glob(os.path.join(ROOT, 'vi-tri', '*.html'))) + sorted(glob.glob(os.path.join(ROOT, 'bai', '*.html')))
    for f in files:
        p = os.path.join(ROOT, f) if not f.startswith('/') else f
        s = open(p, encoding='utf-8').read(); n = apply(s)
        open(p, 'w', encoding='utf-8').write(n)
        print(os.path.relpath(p, ROOT), n.count('<!--fbf-->'), n.count('<!--fbw-->'))
