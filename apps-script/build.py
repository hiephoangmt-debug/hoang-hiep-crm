#!/usr/bin/env python3
"""Gộp trang web thành file HTML một-tệp cho Google Apps Script.

- bao-cao-mkt/index.html (+ config.js, app.js)       -> apps-script/Index.html  (?page=baocao)
- crm/crm.html (+ config.js, app.js, crm.js)          -> apps-script/Crm.html    (trang mặc định)
"""
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
OUT = Path(__file__).resolve().parent
CDN = {
    "jszip.min.js": "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js",
    "xlsx.full.min.js": "https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js",
}
NOTE = "<!-- File sinh tự động bởi apps-script/build.py – sửa trong bao-cao-mkt/ hoặc crm/ rồi chạy lại. -->"


# --cdn <commit>: tải config.js / app.js / crm.js từ jsDelivr (GitHub công khai) thay vì nhúng vào HTML.
# Apps Script xử lý đoạn JS nhúng dài theo cách riêng và làm hỏng nó; script tải ngoài thì không bị đụng tới.
REPO = "hiephoangmt-debug/hoang-hiep-crm"
CDN_SHA = sys.argv[sys.argv.index("--cdn") + 1] if "--cdn" in sys.argv else ""


def build(src: Path, out_name: str):
    html = src.read_text(encoding="utf-8")
    html = re.sub(r'<script src="https://accounts\.google\.com/gsi/client"[^>]*></script>\n?', "", html)

    def inline(m):
        ref = m.group(1)
        name = ref.split("/")[-1]
        if name in CDN:
            return f'<script src="{CDN[name]}"></script>'
        if CDN_SHA:
            rel = (src.parent / ref).resolve().relative_to(ROOT).as_posix()
            return f'<script src="https://cdn.jsdelivr.net/gh/{REPO}@{CDN_SHA}/{rel}"></script>'
        code = (src.parent / ref).resolve().read_text(encoding="utf-8")
        assert "</script" not in code, ref
        return f"<script>\n{code}</script>"

    html = re.sub(r'<script src="([^"]+)"></script>', inline, html)
    # Apps Script coi "<?" … "?>" là scriptlet và cắt bỏ khi nạp trang -> cấm trong mã nhúng
    for m in re.finditer(r"<script>(.*?)</script>", html, re.S):
        assert "<?" not in m.group(1) and "?>" not in m.group(1), out_name + ': mã JS chứa "<?" hoặc "?>"'
        # các kiểu viết thoát \r, \x.. bị Apps Script làm hỏng khi nạp trang -> dùng String.fromCharCode
        bad = re.findall(r"\\(?:r|x[0-9a-fA-F]{2})", m.group(1))
        assert not bad, out_name + ": mã JS chứa ký tự thoát " + ", ".join(sorted(set(bad)))
        astral = sorted({c for c in m.group(1) if ord(c) > 0xFFFF})
        assert not astral, out_name + ": mã JS chứa ký tự ngoài BMP (emoji) " + "".join(astral)
    assert "vendor/" not in html, out_name
    html = html.replace("<head>", "<head>\n" + NOTE, 1)
    out = OUT / out_name
    out.write_text(html, encoding="utf-8")
    print(f"Đã ghi {out} ({out.stat().st_size // 1024} KB)")


build(ROOT / "bao-cao-mkt" / "index.html", "Index.html")
build(ROOT / "crm" / "crm.html", "Crm.html")
