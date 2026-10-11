#!/usr/bin/env python3
"""Gộp bao-cao-mkt/ (index.html + config.js + app.js) thành apps-script/Index.html."""
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "bao-cao-mkt"
CDN = {
    "vendor/jszip.min.js": "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js",
    "vendor/xlsx.full.min.js": "https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js",
}

html = (SRC / "index.html").read_text(encoding="utf-8")
html = re.sub(r'<script src="https://accounts\.google\.com/gsi/client"[^>]*></script>\n?', "", html)
for local, url in CDN.items():
    html = html.replace(f'<script src="{local}"></script>', f'<script src="{url}"></script>')
for name in ("config.js", "app.js"):
    code = (SRC / name).read_text(encoding="utf-8")
    assert "</script" not in code, name
    html = html.replace(f'<script src="{name}"></script>', f"<script>\n{code}</script>")
assert 'src="vendor/' not in html and 'src="app.js"' not in html
out = Path(__file__).resolve().parent / "Index.html"
html = html.replace("<head>", "<head>\n<!-- File sinh tự động bởi apps-script/build.py – sửa trong bao-cao-mkt/ rồi chạy lại. -->", 1)
out.write_text(html, encoding="utf-8")
print(f"Đã ghi {out} ({out.stat().st_size // 1024} KB)")
