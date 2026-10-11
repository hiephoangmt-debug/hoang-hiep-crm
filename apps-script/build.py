#!/usr/bin/env python3
"""Gộp trang web thành file HTML một-tệp cho Google Apps Script.

- bao-cao-mkt/index.html (+ config.js, app.js)       -> apps-script/Index.html  (?page=baocao)
- crm/crm.html (+ config.js, app.js, crm.js)          -> apps-script/Crm.html    (trang mặc định)
"""
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
OUT = Path(__file__).resolve().parent
CDN = {
    "jszip.min.js": "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js",
    "xlsx.full.min.js": "https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js",
}
NOTE = "<!-- File sinh tự động bởi apps-script/build.py – sửa trong bao-cao-mkt/ hoặc crm/ rồi chạy lại. -->"


def build(src: Path, out_name: str):
    html = src.read_text(encoding="utf-8")
    html = re.sub(r'<script src="https://accounts\.google\.com/gsi/client"[^>]*></script>\n?', "", html)

    def inline(m):
        ref = m.group(1)
        name = ref.split("/")[-1]
        if name in CDN:
            return f'<script src="{CDN[name]}"></script>'
        code = (src.parent / ref).resolve().read_text(encoding="utf-8")
        assert "</script" not in code, ref
        return f"<script>\n{code}</script>"

    html = re.sub(r'<script src="([^"]+)"></script>', inline, html)
    # Apps Script coi "<?" … "?>" là scriptlet và cắt bỏ khi nạp trang -> cấm trong mã nhúng
    for m in re.finditer(r"<script>(.*?)</script>", html, re.S):
        assert "<?" not in m.group(1) and "?>" not in m.group(1), out_name + ': mã JS chứa "<?" hoặc "?>" (dùng \\x3c / \\x3e)'
    assert "vendor/" not in html, out_name
    html = html.replace("<head>", "<head>\n" + NOTE, 1)
    out = OUT / out_name
    out.write_text(html, encoding="utf-8")
    print(f"Đã ghi {out} ({out.stat().st_size // 1024} KB)")


build(ROOT / "bao-cao-mkt" / "index.html", "Index.html")
build(ROOT / "crm" / "crm.html", "Crm.html")
