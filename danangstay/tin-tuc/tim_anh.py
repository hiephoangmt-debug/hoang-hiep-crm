"""Tìm ảnh tự do trên Wikimedia Commons, tải bản nhỏ để xem, và tải ảnh lên thư viện Media của danangstay.com.vn.

  python3 tim_anh.py tim "Hoi An ancient town" [so=12]
      -> in danh sách: tên file, kích thước, giấy phép, tác giả, link xem
  python3 tim_anh.py xem "File:Ten anh.jpg" /tmp/anh/x.jpg
      -> tải bản rộng 400px để XEM bằng công cụ Read trước khi dùng
  python3 tim_anh.py dang "File:Ten anh.jpg" "<alt tiếng Việt>" "<chủ đề/tags>"
      -> tải bản 1600px lên Media WordPress, ghi vào anh_commons.json, in JSON {media, url, credit}

Chỉ nhận giấy phép cho phép dùng thương mại: CC0, Public domain, CC BY, CC BY-SA (mọi phiên bản).
Khi chèn vào bài luôn ghi nguồn đúng cột "credit", ví dụ:  Ảnh: <tác giả> / Wikimedia Commons (CC BY-SA 4.0)
"""
import html, json, os, re, sys, time, urllib.parse, urllib.request

UA = {"User-Agent": "DanangStayImageBot/1.0 (https://danangstay.com.vn; low-volume editorial use)"}
API = "https://commons.wikimedia.org/w/api.php"
WP = "https://danangstay.com.vn/wp-json"
POOL = os.environ.get("DS_POOL") or os.path.join(os.path.dirname(os.path.abspath(__file__)), "anh_commons.json")
OK = re.compile(r"^(cc0|public domain|pd|cc by(-sa)? ?[\d.]*( [a-z]+)?)$", re.I)


def get(url, tries=4):
    for i in range(tries):
        try:
            return urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=60).read()
        except urllib.error.HTTPError as e:
            if e.code == 429 and i < tries - 1:
                time.sleep(8 * (i + 1)); continue
            raise


def info(titles, width):
    q = {"action": "query", "titles": "|".join(titles), "prop": "imageinfo", "iiprop": "url|size|extmetadata", "iiurlwidth": width, "format": "json"}
    return json.loads(get(API + "?" + urllib.parse.urlencode(q)))["query"]["pages"].values()


def clean(s):
    return html.unescape(re.sub(r"<[^>]+>", "", s or "")).strip()


def meta(p):
    ii = p["imageinfo"][0]; m = ii.get("extmetadata", {})
    lic = clean(m.get("LicenseShortName", {}).get("value"))
    return {"title": p["title"], "w": ii.get("width"), "h": ii.get("height"), "license": lic,
            "author": clean(m.get("Artist", {}).get("value"))[:80] or "không rõ",
            "desc": clean(m.get("ImageDescription", {}).get("value"))[:160],
            "thumb": ii.get("thumburl", ""), "page": ii.get("descriptionurl", ""), "ok": bool(OK.match(lic))}


def upload_url(thumb):
    # thumb.wikimedia.org -> upload.wikimedia.org (cùng đường dẫn), bỏ tham số utm
    return re.sub(r"^https://thumb\.wikimedia\.org/", "https://upload.wikimedia.org/", thumb.split("?")[0])


cmd = sys.argv[1] if len(sys.argv) > 1 else ""
if cmd == "tim":
    n = int(sys.argv[3]) if len(sys.argv) > 3 else 12
    q = {"action": "query", "generator": "search", "gsrsearch": sys.argv[2] + " filetype:bitmap", "gsrnamespace": 6, "gsrlimit": n,
         "prop": "imageinfo", "iiprop": "url|size|extmetadata", "iiurlwidth": 400, "format": "json"}
    pages = json.loads(get(API + "?" + urllib.parse.urlencode(q))).get("query", {}).get("pages", {}).values()
    for p in sorted(pages, key=lambda x: x.get("index", 0)):
        d = meta(p)
        if (d["w"] or 0) < 1200:
            continue
        print(("✔ " if d["ok"] else "✘ ") + json.dumps({k: d[k] for k in ("title", "w", "h", "license", "author", "desc")}, ensure_ascii=False))
elif cmd == "xem":
    d = meta(next(iter(info([sys.argv[2]], 400))))
    os.makedirs(os.path.dirname(sys.argv[3]) or ".", exist_ok=True)
    open(sys.argv[3], "wb").write(get(upload_url(d["thumb"])))
    print(json.dumps(d, ensure_ascii=False))
elif cmd == "dang":
    title, alt, tags = sys.argv[2], sys.argv[3], sys.argv[4] if len(sys.argv) > 4 else ""
    d = meta(next(iter(info([title], 1600))))
    if not d["ok"]:
        sys.exit("Giấy phép không phù hợp: " + d["license"])
    data = get(upload_url(d["thumb"]))
    name = re.sub(r"[^a-z0-9]+", "-", urllib.parse.unquote(title.split(":", 1)[1]).lower())[:60].strip("-") + ".jpg"
    req = urllib.request.Request(WP + "/wp/v2/media", data=data, method="POST", headers={
        "Content-Type": "image/jpeg", "Content-Disposition": "attachment; filename=" + name, "User-Agent": "DanangStayBot"})
    r = json.loads(urllib.request.urlopen(req, timeout=120).read())
    credit = f"{d['author']} / Wikimedia Commons ({d['license']})"
    req = urllib.request.Request(WP + f"/wp/v2/media/{r['id']}", data=json.dumps({"alt_text": alt, "title": alt, "caption": credit}).encode(),
                                 method="POST", headers={"Content-Type": "application/json", "User-Agent": "DanangStayBot"})
    urllib.request.urlopen(req, timeout=60).read()
    rec = {"media": r["id"], "url": r["source_url"], "alt": alt, "tags": tags, "credit": credit, "source": d["page"]}
    pool = json.load(open(POOL, encoding="utf-8")) if os.path.exists(POOL) else []
    pool.append(rec)
    json.dump(pool, open(POOL, "w", encoding="utf-8"), ensure_ascii=False, indent=1)
    print(json.dumps(rec, ensure_ascii=False))
else:
    print(__doc__)
