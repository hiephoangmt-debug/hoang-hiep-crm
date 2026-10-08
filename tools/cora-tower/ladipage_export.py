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
.split-media,.media-stack,.split-media.zoom{position:relative!important;top:auto!important;min-height:0!important}
.split-media>picture,.split-media>a.zoom-link,.split-media img,.media-stack img{position:static!important;inset:auto!important;height:auto!important;width:100%!important;object-fit:initial!important}
.split{align-items:start!important}
.toc ol{columns:auto!important}
.cs-wrap{margin-top:24px}
.cs-frame{overflow:hidden}
.cs-track{display:flex;gap:16px;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;padding-bottom:4px}
.cs-track::-webkit-scrollbar{display:none}
.cs-slide{flex:0 0 100%;scroll-snap-align:center}
.cs-portrait .cs-slide{flex:0 0 min(340px,86%)}
.cs-card{background:#fff;border:1px solid var(--line);border-radius:18px;overflow:hidden}
.cs-cap{margin:0;padding:12px 16px;display:flex;flex-wrap:wrap;gap:4px 12px;justify-content:space-between;align-items:baseline;color:var(--brand);font-size:1rem;border-bottom:1px solid var(--line)}
.cs-cap span{color:var(--muted);font-size:.9rem}
.cs-card img{display:block;width:100%;height:auto;aspect-ratio:1.414/1;object-fit:contain;background:#fff}
.cs-portrait .cs-card img{aspect-ratio:900/1272}
.cs-nav{display:flex;align-items:center;justify-content:center;gap:16px;margin-top:16px}
.cs-go{width:46px;height:46px;border-radius:50%;border:0;background:var(--brand);color:#fff;font-size:20px;cursor:pointer}
.cs-go:hover{background:var(--brand-2)}
.cs-hint{color:var(--muted);font-size:.9rem;text-align:center}
.plan-stack{display:grid;gap:28px;margin-top:24px}
.plan-head{margin:32px 0 12px;color:var(--brand);font-size:1.15rem;text-align:center}
.plan-stack h4{margin:0 0 10px;color:var(--brand);font-size:1.1rem;text-align:center}
.plan-stack .plan,.plan-stack .unit-plans{display:block}
.plan-stack .unit-plans{display:grid!important}
"""

CAROUSEL_JS = """<script>
document.querySelectorAll('[data-slide]').forEach(function(b){b.addEventListener('click',function(){
  var t=document.getElementById(b.getAttribute('aria-controls'));if(!t)return;
  t.scrollBy({left:(b.dataset.slide==='next'?1:-1)*t.clientWidth*0.9,behavior:'smooth'});
});});
</script>"""

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

    # ---- tabs -> LadiPage carousel (swipe + prev/next), one slide per image
    state = {"s": s}
    def carousel(m):
        block = m.group(0)
        labels = re.findall(r'<button role="tab" aria-selected="(?:true|false)" data-tab="([^"]+)">(.*?)</button>', block)
        slides, portrait = [], False
        for pid, lab in labels:
            pm = re.search(r'<div class="[^"]+" id="' + re.escape(pid) + r'"(?: hidden)?>(.*?)</div>\n?', state["s"], flags=re.S)
            if not pm:
                continue
            state["s"] = state["s"].replace(pm.group(0), "", 1)
            inner = pm.group(1)
            figs = re.findall(r"<figure[^>]*>(.*?)</figure>", inner, flags=re.S) or [inner]
            for f in figs:
                img = re.search(r"<img [^>]*>", f).group(0)
                img = re.sub(r'\s(class|style)="[^"]*"', "", img)
                w, h = re.search(r'width="(\d+)"', img), re.search(r'height="(\d+)"', img)
                if w and h and int(h.group(1)) > int(w.group(1)):
                    portrait = True
                cap = re.search(r"<b>(.*?)</b>(?:<span>(.*?)</span>)?", f)
                title = cap.group(1) if cap else lab
                sub = (cap.group(2) or "") if cap else ""
                slides.append('<div class="cs-slide" aria-roledescription="slide"><div class="cs-card"><p class="cs-cap"><b>'
                              + title + "</b>" + (f"<span>{sub}</span>" if sub else "") + "</p>" + img + "</div></div>")
        cid = "cs-" + labels[0][0]
        kind = " cs-portrait" if portrait else ""
        nav = (f'<div class="cs-nav"><button type="button" class="cs-go" aria-controls="{cid}" data-slide="prev" aria-label="Previous">&#8592;</button>'
               f'<span class="cs-hint">Vuốt hoặc bấm mũi tên · {len(slides)} mặt bằng</span>'
               f'<button type="button" class="cs-go" aria-controls="{cid}" data-slide="next" aria-label="Next">&#8594;</button></div>')
        return (f'<div class="cs-wrap{kind}"><div class="cs-frame" aria-roledescription="carousel"><div class="cs-track" id="{cid}">'
                + "".join(slides) + "</div></div>" + nav + "</div>")
    while True:
        m = re.search(r'<div class="tabs reveal" role="tablist"(?: style="[^"]*")?>.*?</div>', state["s"], flags=re.S)
        if not m:
            break
        rep = carousel(m)
        state["s"] = state["s"].replace(m.group(0), rep, 1)
    s = state["s"].replace("</body>", CAROUSEL_JS + "\n</body>")
    s = re.sub(r'\sloading="lazy"', "", s)

    # Floating call/Zalo buttons are not exported: LadiPage turns them into static boxes.
    # Paste marketing/ladipage-nut-lien-he.html into an HTML element in the builder instead.
    return s


if __name__ == "__main__":
    OUT.mkdir(exist_ok=True)
    for src, _ in PAGES.items():
        html = convert(src)
        (OUT / src).write_text(html)
        print(src, len(html) // 1024, "KB")
