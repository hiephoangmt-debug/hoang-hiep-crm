#!/usr/bin/env python3
"""Prepare dist/*.html for LadiPage.

    python3 landing/export_ladipage.py          # -> landing/ladipage-url/ (images as absolute GitHub URLs)
    python3 landing/export_ladipage.py --inline # -> landing/ladipage/     (images embedded as base64)
"""
import base64
import re
import sys
from pathlib import Path

ROOT = Path(__file__).parent
DIST = ROOT / "dist"
RAW = "https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/landing/vinhomes-hai-van-bay/landing/dist/img/"
INLINE = "--inline" in sys.argv
OUT = ROOT / ("ladipage" if INLINE else "ladipage-url")
OUT.mkdir(exist_ok=True)
cache = {}


def src(name):
    if not INLINE:
        return RAW + name
    if name not in cache:
        cache[name] = "data:image/webp;base64," + base64.b64encode((DIST / "img" / name).read_bytes()).decode()
    return cache[name]


for f in sorted(DIST.glob("*.html")):
    html = f.read_text(encoding="utf-8")
    # og:image is already an absolute URL and is left alone
    html = re.sub(r"(?<![/\w])img/([\w-]+\.webp)", lambda m: src(m.group(1)), html)
    # cart JS builds thumbnail paths at runtime
    used = sorted(set(re.findall(r'img:"([\w-]+)"', html)))
    if used:
        table = "var IMGDATA={%s};" % ",".join('"%s":"%s"' % (u, src(u + ".webp")) for u in used)
        html = html.replace("  var SITE = ", "  " + table + "\n  var SITE = ", 1)
        html = html.replace("""url(\\'img/' + esc(u.img||"aerial-bay") + '.webp\\')""", """url(\\'' + (IMGDATA[u.img] || "") + '\\')""")
    (OUT / f.name).write_text(html, encoding="utf-8")
    print(OUT.name, f.name, len(html) // 1024, "KB")
