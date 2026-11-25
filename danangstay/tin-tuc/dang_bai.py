"""Đăng 1 bài tin tức tiếng Việt lên danangstay.com.vn (chuyên mục news-vi).
Dùng: python3 dang_bai.py <file.html> "<Tiêu đề>" "<slug>" "<Mô tả ngắn 140-160 ký tự>"
Khóa X-DS-Token do proxy của môi trường tự gắn, không cần truyền."""
import json, sys, urllib.request

API = "https://danangstay.com.vn/wp-json/wp/v2/posts?lang=vi"
NEWS_VI = 129

path, title, slug, excerpt = sys.argv[1:5]
content = open(path, encoding="utf-8").read()
body = {"title": title, "slug": slug, "content": content, "excerpt": excerpt,
        "status": "publish", "categories": [NEWS_VI], "lang": "vi"}
req = urllib.request.Request(API, data=json.dumps(body).encode(), method="POST",
                             headers={"Content-Type": "application/json", "User-Agent": "DanangStayBot"})
try:
    r = json.loads(urllib.request.urlopen(req, timeout=60).read())
    print(json.dumps({"id": r["id"], "link": r["link"], "status": r["status"]}, ensure_ascii=False))
except urllib.error.HTTPError as e:
    print("LỖI", e.code, e.read().decode()[:500])
    sys.exit(1)
