"""Đăng bản tin tổng hợp trong ngày lên website WordPress (hiephoangmt.com).

Đọc tin đã gửi Telegram trong digest/YYYY-MM-DD.json, dựng 1 bài viết
"Bản tin quy hoạch – hạ tầng Đà Nẵng sáng dd/mm/yyyy" (tin của cả ngày hôm trước)
và đăng vào chuyên mục. Chạy lại thì cập nhật đúng bài đó (không tạo bài trùng).

Biến môi trường:
  WP_USER, WP_APP_PASSWORD  tài khoản WordPress + Application Password
  WP_URL                    mặc định https://hiephoangmt.com
  WP_CATEGORY_ID            mặc định 121 (Hạ tầng & quy hoạch)
  WP_STATUS                 publish (mặc định) hoặc draft
  DIGEST_DATE               YYYY-MM-DD; mặc định: trước 12h trưa là hôm qua, sau đó là hôm nay
  PREVIEW=1                 xem thử: lấy tin mới nhất từ các nguồn, lưu thành bản nháp riêng
  DRY_RUN=1                 chỉ in HTML, không đăng
"""
import html
import json
import os
import re
import sys
import unicodedata
from datetime import datetime, timedelta

import requests

import scan_news
from scan_news import DIGEST_DIR, VN_TZ, norm, title_key

DA_NANG_WORDS = [
    "đà nẵng", "da nang", "danang", "quảng nam", "hội an", "tam kỳ", "chu lai", "hòa vang",
    "liên chiểu", "sơn trà", "ngũ hành sơn", "cẩm lệ", "hải châu", "thanh khê", "điện bàn", "núi thành",
]
# Thẻ (tag) giúp Google/AI hiểu chủ đề và tạo trang gom bài theo từ khoá.
DIGEST_TAGS = ["quy hoạch Đà Nẵng", "hạ tầng Đà Nẵng", "bất động sản Đà Nẵng", "bản tin quy hoạch"]
HINTS = {
    401: "Sai WP_USER hoặc WP_APP_PASSWORD (dùng Application Password, không phải mật khẩu đăng nhập).",
    403: "Tài khoản không có quyền đăng bài, hoặc plugin bảo mật/host chặn REST API.",
}


def slugify(text, max_len=80):
    """'Cầu Trần Thị Lý – Đà Nẵng' -> 'cau-tran-thi-ly-da-nang' (URL ngắn, không dấu, dễ đọc)."""
    t = unicodedata.normalize("NFD", text.lower().replace("đ", "d"))
    t = re.sub(r"[^a-z0-9]+", "-", "".join(c for c in t if unicodedata.category(c) != "Mn")).strip("-")
    return t[:max_len].rsplit("-", 1)[0] if len(t) > max_len else t


def tag_ids(base, auth, names):
    """Tìm hoặc tạo thẻ WordPress, trả về danh sách id. Lỗi thì bỏ qua (không chặn việc đăng bài)."""
    url, ids = base.replace("/posts", "/tags"), []
    for name in dict.fromkeys(n.strip() for n in names if n.strip()):
        try:
            found = requests.get(url, auth=auth, params={"search": name, "_fields": "id,name"}, timeout=30).json()
            hit = next((t["id"] for t in found if norm(t["name"]) == norm(name)), None)
            if hit is None:
                r = requests.post(url, auth=auth, json={"name": name}, timeout=30)
                data = r.json()
                # Thẻ đã có nhưng search không ra: WordPress trả term_exists kèm id.
                hit = data.get("id") or (data.get("data") or {}).get("term_id")
            if hit:
                ids.append(int(hit))
        except (requests.RequestException, ValueError, TypeError, AttributeError) as e:
            print(f"Không gắn được thẻ '{name}': {e}", file=sys.stderr)
    return ids


def digest_date():
    if os.environ.get("DIGEST_DATE"):
        return datetime.strptime(os.environ["DIGEST_DATE"], "%Y-%m-%d").date()
    now = datetime.now(VN_TZ)
    return (now - timedelta(days=1)).date() if now.hour < 12 else now.date()


def split_publisher(item):
    """Google News để tên báo ở cuối tiêu đề: 'Tiêu đề - Báo Tuổi Trẻ'."""
    title, source = item["title"], item["source"]
    if source.startswith("Google News"):
        m = re.match(r"^(.*\S)\s+-\s+([^-]{2,40})$", title)
        if m:
            return m.group(1), m.group(2)
        return title, "Google News"
    return title, source.split(" · ")[0]


def is_da_nang(item):
    text = norm(item["title"] + " " + item["summary"] + " " + item["source"])
    return any(w in text for w in DA_NANG_WORDS)


def render_item(item):
    title, publisher = split_publisher(item)
    link = html.escape(item["link"], quote=True)
    out = (f'<li><strong><a href="{link}" target="_blank" rel="nofollow noopener">{html.escape(title)}</a></strong>'
           f' <em>({html.escape(publisher)})</em>')
    # Tóm tắt của Google News chỉ lặp lại tiêu đề + tên báo: bỏ.
    if (item["summary"] and not item["source"].startswith("Google News")
            and norm(item["summary"])[:40] not in norm(item["title"])):
        out += f"<br>{html.escape(item['summary'][:300])}"
    return out + "</li>"


def build_post(day, items):
    # Bỏ tin trùng (cùng tiêu đề ở nhiều nguồn), giữ thứ tự thời gian.
    seen, unique = set(), []
    for it in items:
        k = title_key(it["title"])
        if k not in seen:
            seen.add(k)
            unique.append(it)
    dn = [it for it in unique if is_da_nang(it)]
    vn = [it for it in unique if not is_da_nang(it)]

    d = f"{day:%d/%m/%Y}"
    pub = day + timedelta(days=1)  # đăng sáng hôm sau
    title = f"Bản tin quy hoạch – hạ tầng Đà Nẵng sáng {pub:%d/%m/%Y}"
    intro = (f"Tổng hợp {len(unique)} tin quy hoạch, hạ tầng và bất động sản ngày {d}"
             f" ({len(dn)} tin Đà Nẵng, {len(vn)} tin cả nước), cập nhật từ Sở Xây dựng, Bộ Xây dựng,"
             " Cổng thông tin điện tử Đà Nẵng và các báo uy tín.")
    parts = [f"<p>{html.escape(intro)}</p>"]
    if dn:
        parts += ["<h2>Tin Đà Nẵng</h2>", "<ul>", *map(render_item, dn), "</ul>"]
    if vn:
        parts += ["<h2>Tin cả nước</h2>", "<ul>", *map(render_item, vn), "</ul>"]
    parts.append("<p><em>Bản tin được tổng hợp tự động. Nội dung chi tiết thuộc về các nguồn được dẫn link;"
                 " bấm vào tiêu đề để đọc bài gốc.</em></p>")
    return {
        "title": title,
        "slug": f"ban-tin-quy-hoach-ha-tang-da-nang-sang-{pub:%d-%m-%Y}",
        "content": "\n".join(parts),
        "excerpt": intro,
    }


def wp_request(method, url, auth, **kw):
    r = requests.request(method, url, auth=auth, timeout=60, **kw)
    if not r.ok:
        try:
            msg = r.json().get("message", r.text[:300])
        except ValueError:
            msg = r.text[:300]
        hint = HINTS.get(r.status_code, "")
        sys.exit(f"LỖI WordPress {r.status_code}: {msg}" + (f" → {hint}" if hint else ""))
    return r.json()


def preview_items(limit=20):
    """Tin mới nhất (có từ khoá) từ các nguồn, dùng cho bản nháp xem thử."""
    items = []
    for src in scan_news.CONFIG["sources"]:
        try:
            got = scan_news.parse_rss(src) if src["type"] == "rss" else scan_news.parse_html(src)
        except Exception as e:
            print("LỖI", src["name"], e)
            continue
        for it in got[:15]:
            kws = scan_news.matched_keywords(it["title"] + " " + it["summary"])
            if kws:
                items.append(dict(it, source=src["name"], keywords=kws, summary=it["summary"][:400]))
    items.sort(key=lambda x: x["published"] or 0, reverse=True)
    return items[:limit]


def login(base, user, password):
    """Đăng nhập bằng Application Password. Thiếu WP_USER thì thử các tác giả công khai của web."""
    me_url = base.replace("/posts", "/users/me")
    candidates = [user] if user else []
    if not user:
        try:
            authors = requests.get(base.replace("/posts", "/users"), params={"_fields": "slug,name"}, timeout=30).json()
            candidates = [c for a in authors for c in (a.get("slug"), a.get("name")) if c]
        except (requests.RequestException, ValueError):
            pass
    for name in dict.fromkeys(candidates):
        r = requests.get(me_url, auth=(name, password), params={"_fields": "name"}, timeout=30)
        if r.ok:
            print(f"Đăng nhập WordPress OK: {r.json().get('name')} (tài khoản '{name}')")
            return (name, password)
    if user:
        wp_request("GET", me_url, (user, password))  # in lỗi chi tiết
    sys.exit("Không đăng nhập được WordPress: thêm secret WP_USER = tên đăng nhập, kiểm tra WP_APP_PASSWORD.")


def main():
    preview = os.environ.get("PREVIEW") == "1"
    day = digest_date()
    if preview:
        day = datetime.now(VN_TZ).date() - timedelta(days=1)
        items = preview_items()
    else:
        path = DIGEST_DIR / f"{day:%Y-%m-%d}.json"
        items = json.loads(path.read_text(encoding="utf-8")) if path.exists() else []
    if not items:
        print(f"Ngày {day:%d/%m/%Y} chưa có tin nào, không đăng.")
        return

    post = build_post(day, items)
    if preview:
        post["title"] = "[XEM THỬ] " + post["title"]
        post["slug"] += "-xem-thu"
    if os.environ.get("DRY_RUN") == "1":
        print(post["title"], "\n", post["slug"], "\n", post["content"])
        return

    base = os.environ.get("WP_URL", "https://hiephoangmt.com").rstrip("/") + "/wp-json/wp/v2/posts"
    password = os.environ.get("WP_APP_PASSWORD", "").strip()
    if not password:
        sys.exit("Thiếu WP_APP_PASSWORD.")
    auth = login(base, os.environ.get("WP_USER", "").strip(), password)
    post.update(
        status="draft" if preview else (os.environ.get("WP_STATUS") or "publish"),
        categories=[int(os.environ.get("WP_CATEGORY_ID") or 121)],
        tags=tag_ids(base, auth, DIGEST_TAGS),
    )

    existing = wp_request("GET", base, auth, params={
        "slug": post["slug"], "status": "publish,draft,pending,future,private", "_fields": "id,link"})
    if existing:
        res = wp_request("POST", f"{base}/{existing[0]['id']}", auth, json=post)
        print(f"Đã cập nhật bản tin ({len(items)} tin): {res['link']}")
    else:
        res = wp_request("POST", base, auth, json=post)
        print(f"Đã đăng bản tin mới ({len(items)} tin): {res['link']}")


if __name__ == "__main__":
    main()
