"""Convert built Cora Tower pages into LadiPage-compatible HTML (editable mode).

Usage: python3 tools/cora-tower/ladipage_export.py <git-sha>
Writes web/cora-tower/ladipage/<page>.html

- Images point to raw.githubusercontent.com at the given commit (repo is public).
- Follows LadiPage HTML rules v2: tabs (role/aria-controls), form, <details> FAQ.
- Drops JS widgets LadiPage cannot convert (chat, lightbox, calculator, floating bars).
"""
import pathlib
import re
import sys

ROOT = pathlib.Path(__file__).resolve().parents[2]
SITE = ROOT / "web" / "cora-tower"
OUT = SITE / "ladipage"
SHA = sys.argv[1]
BASE = f"https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/{SHA}/web/cora-tower/"
DOMAIN = "https://www.cora-tower.com/"
PAGES = {"index.html": "", "khoi-de-shophouse.html": "khoi-de-shophouse.html", "penthouse.html": "penthouse.html"}

EXTRA_CSS = """
/* LadiPage export overrides */
.reveal{opacity:1!important;transform:none!important}
.plan-panel>.plan{border:1px solid var(--line);border-radius:18px;overflow:hidden;background:#fff}
.map-cta{display:inline-flex;margin-top:18px}
"""

TAB_JS = """<script>
document.querySelectorAll('[role="tablist"]').forEach(function(list){
  var btns=list.querySelectorAll('[role="tab"]');
  btns.forEach(function(b){b.addEventListener('click',function(){
    btns.forEach(function(x){var on=x===b;x.setAttribute('aria-selected',on);var p=document.getElementById(x.getAttribute('aria-controls'));if(p){if(on){p.removeAttribute('hidden')}else{p.setAttribute('hidden','')}}});
  });});
});
</script>"""


def convert(name):
    s = (SITE / name).read_text()
    css = (SITE / "assets" / "style.css").read_text() + EXTRA_CSS

    # ---- head
    s = s.replace("<script>document.documentElement.classList.add('js')</script>\n", "")
    s = re.sub(r'<link rel="preload"[^>]*>\n?', "", s)
    s = s.replace('<link rel="stylesheet" href="assets/style.css">',
                  '<meta name="ladipage-rules" content="v2">\n<style>\n' + css + "\n</style>")

    # ---- remove JS widgets & floating UI
    s = re.sub(r'<div class="fab".*?</div>\n', "", s, flags=re.S)
    s = re.sub(r'<nav class="float-cta".*?</nav>\n', "", s, flags=re.S)
    s = re.sub(r'<div class="chat" id="chat" hidden>.*?</form>\n</div>\n', "", s, flags=re.S)
    s = re.sub(r'<div class="chat-teaser".*?</div>\n', "", s, flags=re.S)
    s = re.sub(r'<div class="lightbox".*?</div>', "", s, flags=re.S)
    s = re.sub(r"<script>window\.CORA.*?</script>\n?", "", s, flags=re.S)
    s = re.sub(r'<script src="assets/[^"]+" defer></script>\n?', "", s)
    s = re.sub(r'\s*<section class="alt" id="tinh-dong-tien">.*?</section>\n', "\n", s, flags=re.S)
    s = s.replace('<a href="#tinh-dong-tien">công cụ ước tính dòng tiền</a>', "bảng tính dòng tiền do chuyên viên gửi")

    # ---- map iframe -> link
    s = re.sub(r'<iframe title="Bản đồ[^>]*></iframe>',
               '<a class="btn map-cta" href="https://www.google.com/maps/search/?api=1&amp;query=Cora+Tower+29%2F3+Nguy%E1%BB%85n+Ph%C6%B0%E1%BB%9Bc+Lan+%C4%90%C3%A0+N%E1%BA%B5ng" target="_blank" rel="noopener">Xem vị trí trên Google Maps ↗</a>', s)

    # ---- pictures -> div wrapper + single absolute <img>
    def pic(m):
        cls, inner = m.group(1) or "", m.group(2)
        img = re.search(r"<img [^>]*>", inner).group(0)
        img = re.sub(r'\s(srcset|sizes)="[^"]*"', "", img)
        img = re.sub(r'\sfetchpriority="[^"]*"', "", img)
        return f'<div{cls}>{img}</div>' if cls else img
    s = re.sub(r"<picture( class=\"[^\"]+\")?>(.*?)</picture>", pic, s, flags=re.S)

    # ---- absolute asset URLs
    s = re.sub(r'(src|href)="assets/', lambda m: f'{m.group(1)}="{BASE}assets/', s)
    s = re.sub(r'href="phap-ly/', f'href="{BASE}phap-ly/', s)
    # links to sibling pages -> final domain
    # live LadiPage URLs on www.cora-tower.com
    LIVE = {"khoi-de-shophouse.html": "khoi-de-shophouse", "penthouse.html": "penthouse",
            "phap-ly.html": "#phap-ly", "can-ho-sun-da-nang.html": ""}
    s = re.sub(r'href="\./(#[^"]*)?"', lambda m: f'href="{DOMAIN}{m.group(1) or ""}"', s)
    for pg, slug in LIVE.items():
        if pg == name:
            continue
        s = re.sub(r'href="' + re.escape(pg) + r'(#[^"]*)?"', lambda m, slug=slug: f'href="{DOMAIN}{slug if not slug.startswith("#") or True else ""}{(m.group(1) or "") if not slug.startswith("#") else ""}"', s)
    # meta canonical / og:url to live URLs
    for pg, slug in LIVE.items():
        if not slug.startswith("#") and slug:
            s = s.replace(f"{DOMAIN}{pg}", f"{DOMAIN}{slug}")
    s = s.replace(f'href="{name}#', 'href="#')

    # ---- forms: no hidden inputs / status div, select placeholder
    s = re.sub(r'\s*<input type="hidden"[^>]*>', "", s)
    s = re.sub(r'\s*<div class="form-msg" role="status"></div>', "", s)
    s = s.replace('<select name="interest" aria-label="Sản phẩm quan tâm">',
                  '<select name="interest" aria-label="Sản phẩm quan tâm"><option value="" disabled selected>Sản phẩm quan tâm</option>')

    # ---- tabs: aria-controls + role=tabpanel; panel decoration moves to child
    s = re.sub(r'<button role="tab" aria-selected="(true|false)" data-tab="([^"]+)">',
               r'<button type="button" role="tab" aria-selected="\1" aria-controls="\2">', s)
    tab_ids = set(re.findall(r'aria-controls="([^"]+)"', s))

    def panel(m):
        cls, pid, hid, rest = m.group(1), m.group(2), m.group(3) or "", m.group(4)
        if pid not in tab_ids:
            return m.group(0)
        if "plan" in cls.split():
            return f'<div role="tabpanel" id="{pid}" class="plan-panel"{hid}><div class="{cls}">{rest}</div></div>'
        return f'<div role="tabpanel" class="{cls}" id="{pid}"{hid}>{rest}</div>'
    s = re.sub(r'<div class="([^"]+)" id="([^"]+)"( hidden)?>((?:(?!<div)(?!</div>).)*)</div>', panel, s, flags=re.S)
    found = set(re.findall(r'<div role="tabpanel"[^>]*?id="([^"]+)"', s))
    if tab_ids - found:
        print("WARN tabs without panel:", tab_ids - found)

    fab = (ROOT / "marketing" / "ladipage-nut-lien-he.html").read_text()
    s = s.replace("</body>", fab + "\n" + TAB_JS + "\n</body>")
    return s


if __name__ == "__main__":
    OUT.mkdir(exist_ok=True)
    for src, _ in PAGES.items():
        html = convert(src)
        (OUT / src).write_text(html)
        print(src, len(html) // 1024, "KB")
