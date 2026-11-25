"""Lấy tin du lịch Đà Nẵng – Hội An – Huế mới (48 giờ) từ RSS, bỏ tin đã viết trên danangstay.com.vn.
In ra JSON danh sách ứng viên. Chạy: python3 lay_tin.py"""
import json, re, sys, html, urllib.request, urllib.parse, email.utils, datetime as dt
FEEDS = {"Tuổi Trẻ": "https://tuoitre.vn/rss/du-lich.rss", "VietNamNet": "https://vietnamnet.vn/rss/du-lich.rss", "Báo Văn hóa": "https://baovanhoa.vn/rss/du-lich.rss"}
KEY = re.compile(r"Đà Nẵng|Hội An|Huế|Sơn Trà|Bà Nà|Mỹ Sơn|Cù Lao Chàm|Quảng Nam|Ngũ Hành Sơn|Hải Vân|Mỹ Khê|Mân Thái|Lăng Cô|Tam Kỳ|miền Trung", re.I)
SITE = "https://danangstay.com.vn/wp-json/wp/v2/posts"
def get(url):
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0 DanangStayBot"})
    return urllib.request.urlopen(req, timeout=30).read().decode("utf-8", "replace")
def used(link):
    try:
        q = SITE + "?status=publish,draft&per_page=1&_fields=id&search=" + urllib.parse.quote(link)
        return len(json.loads(get(q))) > 0
    except Exception:
        return False
now = dt.datetime.now(dt.timezone.utc); out = []
for name, url in FEEDS.items():
    try:
        x = get(url)
    except Exception as e:
        print(f"# lỗi {name}: {e}", file=sys.stderr); continue
    for it in re.findall(r"<item>(.*?)</item>", x, re.S)[:120]:
        f = lambda t: html.unescape(re.sub(r"<!\[CDATA\[|\]\]>", "", (re.search(fr"<{t}[^>]*>(.*?)</{t}>", it, re.S) or [None, ""])[1])).strip()
        title, link, desc = f("title"), f("link"), re.sub(r"<[^>]+>", " ", f("description"))
        try:
            pub = email.utils.parsedate_to_datetime(f("pubDate"))
        except Exception:
            continue
        if (now - pub).total_seconds() > 48 * 3600 or not KEY.search(title + " " + desc):
            continue
        out.append({"nguon": name, "tieu_de": title, "link": link, "ngay": pub.isoformat(), "tom_tat": re.sub(r"\s+", " ", desc)[:300]})
seen, res = set(), []
for o in sorted(out, key=lambda o: o["ngay"], reverse=True):
    k = re.sub(r"\W+", "", o["tieu_de"].lower())[:40]
    if k in seen or used(o["link"]):
        continue
    seen.add(k); res.append(o)
print(json.dumps(res[:15], ensure_ascii=False, indent=1))
