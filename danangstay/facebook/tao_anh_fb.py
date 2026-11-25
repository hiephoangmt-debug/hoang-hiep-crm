#!/usr/bin/env python3
"""Tạo ảnh Facebook 1080x1350 có chữ cho một bài trên danangstay.com.vn, tải lên Media của web.

python3 tao_anh_fb.py <ID bài> "<TIÊU ĐỀ IN HOA, xuống dòng bằng |>" "<câu gợi tò mò>" "<dòng ý chính>" [--nhan "CẨM NANG"|"TIN MỚI"|"QUY ĐỊNH MỚI"]
In ra JSON {"url": ..., "media": ..., "credit": ...}. Ảnh nền là ảnh bìa của bài.
Cần: node + playwright (có sẵn trong môi trường), ảnh logo ../logo/final/danangstay-logo.png.
"""
import html, json, os, re, subprocess, sys, tempfile, urllib.request

WP = "https://danangstay.com.vn/wp-json"
HERE = os.path.dirname(os.path.abspath(__file__))
LOGO = os.path.join(HERE, "..", "logo", "final", "danangstay-logo.png")


def get(u):
    return json.load(urllib.request.urlopen(urllib.request.Request(u, headers={"User-Agent": "DanangStayBot"}), timeout=60))


def main():
    a = sys.argv[1:]
    nhan = "CẨM NANG"
    if "--nhan" in a:
        i = a.index("--nhan"); nhan = a[i + 1]; del a[i:i + 2]
    pid, tieude, cau, dong = a[0], a[1], a[2], a[3]
    p = get(f"{WP}/wp/v2/posts/{pid}?_fields=id,slug,featured_media")
    if not p.get("featured_media"):
        sys.exit("Bài chưa có ảnh bìa")
    m = get(f"{WP}/wp/v2/media/{p['featured_media']}?_fields=source_url,caption")
    credit = re.sub("<[^>]+>", "", html.unescape(m["caption"]["rendered"])).strip() or "Unsplash"
    d = tempfile.mkdtemp()
    bg = os.path.join(d, "bg.jpg")
    urllib.request.urlretrieve(m["source_url"], bg)
    e = html.escape
    t = "<br>".join(e(x.strip()) for x in tieude.split("|"))
    page = f'''<!doctype html><meta charset="utf-8"><link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@500;700;800&family=Cormorant+Garamond:ital,wght@1,600&display=swap" rel="stylesheet">
<style>html,body{{margin:0}}.c{{width:1080px;height:1350px;position:relative;overflow:hidden;font-family:'Be Vietnam Pro',sans-serif;color:#fff}}
.bg{{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}}
.sh{{position:absolute;inset:0;background:linear-gradient(180deg,rgba(7,26,50,.72) 0%,rgba(7,26,50,.25) 14%,rgba(7,26,50,0) 26%,rgba(7,26,50,0) 42%,rgba(7,26,50,.78) 66%,rgba(7,26,50,.96) 100%)}}
.lg{{position:absolute;left:44px;top:34px;width:300px;filter:drop-shadow(0 4px 14px rgba(0,0,0,.45))}}
.tag{{position:absolute;right:44px;top:52px;background:#E8590C;padding:12px 20px;border-radius:999px;font:700 22px/1 'Be Vietnam Pro';letter-spacing:.06em}}
.tx{{position:absolute;left:64px;right:64px;bottom:210px}}
h1{{margin:0;font:800 108px/1.1 'Be Vietnam Pro';text-shadow:0 4px 22px rgba(0,0,0,.35)}}
h2{{margin:22px 0 0;font:italic 600 58px/1.12 'Cormorant Garamond',serif;color:#FFC93C}}
p{{margin:22px 0 0;font:500 30px/1.4 'Be Vietnam Pro';color:#dfe8f3}}
.ft{{position:absolute;left:0;right:0;bottom:0;height:150px;display:flex;align-items:center;gap:22px;padding:0 64px;background:#fff;color:#0B2447}}
.ft b{{background:#0068ff;color:#fff;border-radius:14px;padding:16px 22px;font:700 30px/1 'Be Vietnam Pro'}}.ft span{{font:700 30px/1 'Be Vietnam Pro'}}
.cr{{position:absolute;right:20px;bottom:160px;font:400 16px/1 'Be Vietnam Pro';color:rgba(255,255,255,.7)}}</style>
<div class="c"><img class="bg" src="file://{bg}"><div class="sh"></div><img class="lg" src="file://{os.path.abspath(LOGO)}"><div class="tag">{e(nhan)}</div>
<div class="tx"><h1>{t}</h1><h2>{e(cau)}</h2><p>{e(dong)}</p></div><div class="cr">Ảnh: {e(credit)}</div>
<div class="ft"><b>Zalo · WhatsApp 0909 669 325</b><span>danangstay.com.vn</span></div></div>'''
    hp = os.path.join(d, "a.html"); open(hp, "w").write(page)
    out = os.path.join(d, "fb.jpg")
    js = ("const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1350}});"
          f"await p.goto('file://{hp}',{{waitUntil:'networkidle'}});await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(300);"
          f"await p.screenshot({{path:'{out}',type:'jpeg',quality:90}});await b.close();}})();")
    subprocess.run(["node", "-e", js], check=True)
    name = f"fb-{p['slug'][:60]}.jpg"
    r = urllib.request.Request(f"{WP}/wp/v2/media", data=open(out, "rb").read(), method="POST", headers={
        "Content-Type": "image/jpeg", "Content-Disposition": "attachment; filename=" + name, "User-Agent": "DanangStayBot"})
    j = json.load(urllib.request.urlopen(r, timeout=120))
    keep = os.path.join(HERE, "anh-bai", name)
    os.makedirs(os.path.dirname(keep), exist_ok=True)
    os.replace(out, keep)
    print(json.dumps({"url": j["source_url"], "media": j["id"], "credit": credit, "file": keep}, ensure_ascii=False))


if __name__ == "__main__":
    main()
