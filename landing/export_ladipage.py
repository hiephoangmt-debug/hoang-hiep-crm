#!/usr/bin/env python3
"""Make self-contained copies of dist/*.html for LadiPage (images inlined as base64)."""
import base64
import re
from pathlib import Path

ROOT = Path(__file__).parent
DIST, OUT = ROOT / "dist", ROOT / "ladipage"
OUT.mkdir(exist_ok=True)
cache = {}


def data_uri(name):
    if name not in cache:
        cache[name] = "data:image/webp;base64," + base64.b64encode((DIST / "img" / name).read_bytes()).decode()
    return cache[name]


for f in sorted(DIST.glob("*.html")):
    html = f.read_text(encoding="utf-8")
    # og:image must stay an absolute URL
    html = re.sub(r"(?<![/\w])img/([\w-]+\.webp)", lambda m: data_uri(m.group(1)), html)
    # cart JS builds thumbnail paths at runtime: map them to inlined data too
    used = sorted(set(re.findall(r'img:"([\w-]+)"', html)))
    if used:
        table = "var IMGDATA={%s};" % ",".join('"%s":"%s"' % (u, data_uri(u + ".webp")) for u in used)
        html = html.replace("  var SITE = ", "  " + table + "\n  var SITE = ", 1)
        html = html.replace("""url(\\'img/' + esc(u.img||"aerial-bay") + '.webp\\')""", """url(\\'' + (IMGDATA[u.img] || "") + '\\')""")
    (OUT / f.name).write_text(html, encoding="utf-8")
    print(f.name, len(html) // 1024, "KB")
