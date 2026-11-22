"""Chèn hộp "Kinh nghiệm của Hiệp" vào bài viết, nhắc thương hiệu Hoàng Hiệp xuyên suốt bài.
Ghi chú nằm trong bai-src/hiep-notes-*.json: {slug: [{"h2": "đoạn chữ trong tiêu đề mục", "text": "..."}]}.
Mỗi ghi chú được đặt cuối <section> có <h2> chứa đoạn chữ đó. Chạy lại nhiều lần không bị nhân đôi.
Dùng: python3 tools/add_hiep_notes.py [slug ...]   (không truyền slug = mọi bài có ghi chú)
build_bai_moi.py gọi apply() nên bài dựng lại vẫn giữ ghi chú.
"""
import glob, html as H, json, os, re, sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
CSS = ('/*hiep-note*/.hiep{display:flex;gap:12px;align-items:flex-start;background:#f3f6fc;border:1px solid #d9e1f2;'
       'border-left:4px solid #1B2D6B;border-radius:12px;padding:12px 14px;margin:16px 0 4px}'
       '.hiep img{width:40px;height:40px;border-radius:50%;object-fit:cover;flex:none}'
       '.hiep p{margin:0;text-align:justify;text-justify:inter-word}'
       '.hiep .hn{display:block;font-weight:800;color:#1B2D6B;font-size:14px;margin-bottom:2px;text-align:left}')
RX_OLD = re.compile(r'<!--hiep-->.*?<!--/hiep-->', re.S)


def load():
    notes = {}
    for f in sorted(glob.glob(os.path.join(ROOT, 'bai-src', 'hiep-notes-*.json'))):
        notes.update(json.load(open(f, encoding='utf-8')))
    return notes


def box(text):
    return (f'<!--hiep--><div class="hiep"><img src="{IMG}hoang-hiep-portrait.jpg" alt="Hoàng Hiệp" width="40" height="40" loading="lazy">'
            f'<p><span class="hn">💬 Hiệp chia sẻ</span>{text}</p></div><!--/hiep-->')


def apply(page, slug, notes=None):
    notes = load() if notes is None else notes
    page = RX_OLD.sub('', page)
    items = notes.get(slug)
    if not items:
        return page, 0
    if '/*hiep-note*/' not in page:
        i = page.index('</style>')
        page = page[:i] + CSS + page[i:]
    n = 0
    for it in items:
        key = it['h2']
        pos = None
        for m in re.finditer(r'<h2[^>]*>(.*?)</h2>', page, re.S):
            plain = H.unescape(re.sub(r'<[^>]+>', '', m.group(1)))
            if key in plain:
                pos = m.end()
                break
        if pos is None:
            print(f'  ! {slug}: không thấy mục "{key}"')
            continue
        end = page.find('</section>', pos)
        if end < 0 or page.rfind('<section', 0, pos) < 0:
            print(f'  ! {slug}: mục "{key}" không nằm trong <section>')
            continue
        page = page[:end] + box(it['text']) + '\n' + page[end:]
        n += 1
    return page, n


if __name__ == '__main__':
    notes = load()
    slugs = sys.argv[1:] or list(notes)
    for s in slugs:
        f = os.path.join(ROOT, 'bai', s + '.html')
        page, n = apply(open(f, encoding='utf-8').read(), s, notes)
        open(f, 'w', encoding='utf-8').write(page)
        print(s, n, '/', len(notes.get(s, [])))
