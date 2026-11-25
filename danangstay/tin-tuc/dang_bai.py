"""Đăng 1 bài lên danangstay.com.vn qua REST (khóa X-DS-Token do proxy môi trường tự gắn).

python3 dang_bai.py <file.html> "<Tiêu đề>" "<slug>" "<Mô tả 140-160 ký tự>" [--lang vi] [--cat news] [--tags quy-dinh-moi] [--dich-cua 213]

--cat   : news | plan | places | food | culture   (mặc định news)
--lang  : vi | ko | en                            (mặc định vi)
--tags  : slug thẻ, cách nhau dấu phẩy; thẻ chưa có sẽ được tạo
--dich-cua : ID bài gốc (vd bản VI) để liên kết bản dịch qua Polylang
--anh   : ảnh đại diện. Một trong:
          • link ảnh https://images.unsplash.com/photo-... (ảnh miễn phí, đúng chủ đề) hoặc https://danangstay.com.vn/wp-content/uploads/...
          • số ID media đã có trên site (vd 241), dùng lại ảnh của bản VI cho bản KO
          • "auto" (mặc định): chọn trong anh.json ảnh hợp tiêu đề nhất và ít dùng gần đây nhất
--alt   : mô tả ảnh (alt); mặc định lấy theo anh.json hoặc tiêu đề
"""
import argparse, json, os, re, sys, urllib.request, urllib.parse

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
ap.add_argument("--anh", default="auto"); ap.add_argument("--alt", default="")
a = ap.parse_args()


def pick_pool(title):
    pool = json.load(open(os.path.join(os.path.dirname(os.path.abspath(__file__)), "anh.json"), encoding="utf-8"))
    recent = call("GET", "/wp/v2/media?per_page=30&_fields=source_url")
    used = " ".join(m["source_url"] for m in recent)
    words = set(re.findall(r"\w+", title.lower()))
    def score(p):
        tw = p["tags"].lower().split()
        hit = sum(1 for w in tw if w in words) + sum(2 for ph in re.findall(r"[^ ]+ [^ ]+", p["tags"].lower()) if ph in title.lower())
        return (hit, -used.count(p["id"]))
    best = max(pool, key=score)
    return "https://images.unsplash.com/photo-" + best["id"], best["alt"], best["id"]


def upload(url, slug, alt, tag):
    if not re.match(r"^https://(images\.unsplash\.com|danangstay\.com\.vn)/", url):
        print("Ảnh phải từ images.unsplash.com hoặc danangstay.com.vn"); sys.exit(1)
    if "images.unsplash.com" in url:
        url = url.split("?")[0] + "?auto=format&fit=crop&w=1600&h=900&q=75"
    data = urllib.request.urlopen(urllib.request.Request(url, headers={"User-Agent": "DanangStayBot"}), timeout=60).read()
    req = urllib.request.Request(BASE + "/wp/v2/media", data=data, method="POST", headers={
        "Content-Type": "image/jpeg", "Content-Disposition": f"attachment; filename={slug[:50]}-{tag[:24]}.jpg", "User-Agent": "DanangStayBot"})
    mid = json.loads(urllib.request.urlopen(req, timeout=120).read())["id"]
    call("POST", f"/wp/v2/media/{mid}", {"alt_text": alt, "title": alt})
    return mid


def featured():
    if a.anh.isdigit():
        return int(a.anh)
    if a.anh == "auto":
        url, alt, tag = pick_pool(a.title)
    else:
        url, alt, tag = a.anh, "", re.sub(r"\W+", "", a.anh.split("photo-")[-1])[:24] or "anh"
    return upload(url, a.slug, a.alt or alt or a.title, tag)

body = {"title": a.title, "slug": a.slug, "content": open(a.file, encoding="utf-8").read(), "excerpt": a.excerpt,
        "status": "publish", "categories": [cat_id(a.lang, a.cat)], "lang": a.lang}
if a.tags:
    body["tags"] = tag_ids(a.lang, a.tags)
if a.anh != "none":
    body["featured_media"] = featured()
r = call("POST", f"/wp/v2/posts?lang={a.lang}", body)
out = {"id": r["id"], "link": r["link"], "status": r["status"], "featured_media": r.get("featured_media")}
if a.dich_cua:
    src = call("GET", f"/wp/v2/posts/{a.dich_cua}?_fields=id,lang")
    src_lang = src.get("lang") or "vi"
    out["translations"] = call("POST", "/danangstay/v1/translations", {"translations": {src_lang: a.dich_cua, a.lang: r["id"]}}).get("translations")
print(json.dumps(out, ensure_ascii=False))
