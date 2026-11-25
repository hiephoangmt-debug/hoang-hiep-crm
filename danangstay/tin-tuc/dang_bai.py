"""Đăng 1 bài lên danangstay.com.vn qua REST (khóa X-DS-Token do proxy môi trường tự gắn).

python3 dang_bai.py <file.html> "<Tiêu đề>" "<slug>" "<Mô tả 140-160 ký tự>" [--lang vi] [--cat news] [--tags quy-dinh-moi] [--dich-cua 213]

--cat   : news | plan | places | food | culture   (mặc định news)
--lang  : vi | ko | en                            (mặc định vi)
--tags  : slug thẻ, cách nhau dấu phẩy; thẻ chưa có sẽ được tạo
--dich-cua : ID bài gốc (vd bản VI) để liên kết bản dịch qua Polylang
"""
import argparse, json, sys, urllib.request, urllib.parse

BASE = "https://danangstay.com.vn/wp-json"
CATS = {  # slug gốc -> ID theo ngôn ngữ
    "vi": {"news": 129, "plan": 91, "places": 75, "food": 59, "culture": 43},
    "ko": {"news": 120, "plan": 85, "places": 69, "food": 53, "culture": 37},
    "en": {"news": 115},
}


def call(method, path, body=None):
    req = urllib.request.Request(BASE + path, method=method,
                                 data=json.dumps(body).encode() if body is not None else None,
                                 headers={"Content-Type": "application/json", "User-Agent": "DanangStayBot"})
    try:
        return json.loads(urllib.request.urlopen(req, timeout=60).read())
    except urllib.error.HTTPError as e:
        print("LỖI", method, path, e.code, e.read().decode()[:400])
        sys.exit(1)


def cat_id(lang, slug):
    if slug in CATS.get(lang, {}):
        return CATS[lang][slug]
    r = call("GET", "/wp/v2/categories?per_page=100&_fields=id,slug")
    for c in r:
        if c["slug"] in (f"{slug}-{lang}", slug if lang == "en" else ""):
            return c["id"]
    print("Không tìm thấy chuyên mục", slug, lang); sys.exit(1)


def tag_ids(lang, slugs):
    ids = []
    for s in [x.strip() for x in slugs.split(",") if x.strip()]:
        full = s if lang == "vi" else f"{s}-{lang}"
        r = call("GET", "/wp/v2/tags?slug=" + urllib.parse.quote(full) + "&_fields=id")
        ids.append(r[0]["id"] if r else call("POST", f"/wp/v2/tags?lang={lang}", {"name": s.replace("-", " ").capitalize(), "slug": full})["id"])
    return ids


ap = argparse.ArgumentParser()
ap.add_argument("file"); ap.add_argument("title"); ap.add_argument("slug"); ap.add_argument("excerpt")
ap.add_argument("--lang", default="vi"); ap.add_argument("--cat", default="news")
ap.add_argument("--tags", default=""); ap.add_argument("--dich-cua", type=int, default=0)
a = ap.parse_args()

body = {"title": a.title, "slug": a.slug, "content": open(a.file, encoding="utf-8").read(), "excerpt": a.excerpt,
        "status": "publish", "categories": [cat_id(a.lang, a.cat)], "lang": a.lang}
if a.tags:
    body["tags"] = tag_ids(a.lang, a.tags)
r = call("POST", f"/wp/v2/posts?lang={a.lang}", body)
out = {"id": r["id"], "link": r["link"], "status": r["status"]}
if a.dich_cua:
    src = call("GET", f"/wp/v2/posts/{a.dich_cua}?_fields=id,lang")
    src_lang = src.get("lang") or "vi"
    out["translations"] = call("POST", "/danangstay/v1/translations", {"translations": {src_lang: a.dich_cua, a.lang: r["id"]}}).get("translations")
print(json.dumps(out, ensure_ascii=False))
