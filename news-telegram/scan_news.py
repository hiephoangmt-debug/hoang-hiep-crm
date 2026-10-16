"""Quét tin tức Sở Xây dựng / quy hoạch / hạ tầng / BĐS và gửi về Telegram.

Biến môi trường:
  TELEGRAM_BOT_TOKEN  token bot (lấy từ @BotFather)
  TELEGRAM_CHAT_ID    id nhóm/kênh/người nhận (vd -1001234567890)
  DRY_RUN=1           chỉ in ra màn hình, không gửi, không lưu trạng thái

Trạng thái các bài đã gửi lưu ở seen.json để không gửi trùng.
Lần chạy đầu tiên chỉ ghi nhận bài hiện có (không gửi) để tránh spam,
trừ khi đặt SEND_ON_FIRST_RUN=1.
TEST_MESSAGE=1: gửi 1 tin thử (bài mới nhất), không lưu trạng thái.
"""
import hashlib
import html
import json
import os
import re
import sys
import time
import unicodedata
from datetime import datetime, timedelta, timezone
from email.utils import parsedate_to_datetime
from pathlib import Path
from urllib.parse import urljoin, urlparse

import requests
import urllib3
from bs4 import BeautifulSoup

ROOT = Path(__file__).resolve().parent
CONFIG = json.loads((ROOT / "sources.json").read_text(encoding="utf-8"))
SEEN_FILE = ROOT / "seen.json"
DIGEST_DIR = ROOT / "digest"  # tin đã gửi theo ngày, để đăng bản tin lên web
DIGEST_KEEP_DAYS = 30
VN_TZ = timezone(timedelta(hours=7))
SEEN_LIMIT = 5000
MAX_PER_RUN = 30
HEADERS = {
    "User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 "
    "(KHTML, like Gecko) Chrome/126.0 Safari/537.36",
    "Accept-Language": "vi-VN,vi;q=0.9",
}


def norm(text):
    return re.sub(r"\s+", " ", unicodedata.normalize("NFC", text or "")).strip().lower()


def clean(text):
    return re.sub(r"\s+", " ", unicodedata.normalize("NFC", text or "")).strip()


KEYWORDS = [norm(k) for k in CONFIG["keywords"]]


def matched_keywords(text):
    t = norm(text)
    return [k for k in KEYWORDS if re.search(r"(?<!\w)" + re.escape(k) + r"(?!\w)", t)]


def fetch(url, src=None):
    """Tải trang. Với nguồn .gov.vn khó tính:
    - fallback_urls: thử thêm địa chỉ khác (vd http://) khi https không vào được;
    - ssl_fallback: trang thiếu chứng chỉ trung gian thì vẫn đọc (chỉ đọc tin công khai);
    - vn_proxy: đi qua proxy Việt Nam (secret VN_PROXY_URL) nếu trang chặn IP nước ngoài.
    """
    src = src or {}
    proxy = os.environ.get("VN_PROXY_URL", "").strip() if src.get("vn_proxy") else ""
    proxies = {"http": proxy, "https": proxy} if proxy else None
    last_err = None
    for u in [url] + src.get("fallback_urls", []):
        try:
            try:
                r = requests.get(u, headers=HEADERS, timeout=(15, 30), proxies=proxies)
            except requests.exceptions.SSLError:
                if not src.get("ssl_fallback"):
                    raise
                urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
                r = requests.get(u, headers=HEADERS, timeout=(15, 30), proxies=proxies, verify=False)
            r.raise_for_status()
            return r.content
        except requests.RequestException as e:
            last_err = e
    raise last_err


def parse_rss(src):
    soup = BeautifulSoup(fetch(src["url"], src), "xml")
    items = []
    for it in soup.find_all(["item", "entry"]):
        title = clean(it.title.get_text()) if it.title else ""
        link_tag = it.find("link")
        link = (link_tag.get("href") or link_tag.get_text(strip=True)) if link_tag else ""
        desc_tag = it.find(["description", "summary"])
        desc = BeautifulSoup(desc_tag.get_text(), "html.parser").get_text(" ", strip=True) if desc_tag else ""
        date_tag = it.find(["pubDate", "published", "updated"])
        published = None
        if date_tag:
            try:
                published = parsedate_to_datetime(date_tag.get_text(strip=True)).timestamp()
            except (TypeError, ValueError):
                pass
        if title and link:
            items.append({"title": title, "link": link, "summary": desc, "published": published})
    return items


# Link trong menu/chân trang thường ngắn hoặc trỏ tới mục chung: bỏ qua.
SKIP_LINK = re.compile(r"(lien-he|dang-nhap|so-do|tim-kiem|rss|javascript:|mailto:|tel:|#)", re.I)


def parse_html(src):
    base = src["url"]
    host = urlparse(base).netloc
    soup = BeautifulSoup(fetch(base, src), "html.parser")
    for tag in soup(["header", "footer", "nav", "script", "style"]):
        tag.decompose()
    items, seen = [], set()
    for a in soup.find_all("a", href=True):
        title = clean(a.get_text(" ") or a.get("title", ""))
        link = urljoin(base, a["href"]).split("#")[0]
        if len(title) < 35 or len(title.split()) < 7 or SKIP_LINK.search(a["href"]):
            continue
        if urlparse(link).netloc != host or link in seen:
            continue
        seen.add(link)
        items.append({"title": title, "link": link, "summary": "", "published": None})
    return items


def item_id(item):
    link = item["link"]
    return hashlib.sha1(link.encode()).hexdigest()[:16]


def title_key(title):
    # Google News thêm " - Tên báo" ở cuối: bỏ đi để gộp bài trùng giữa các nguồn.
    t = re.sub(r"\s+-\s+[^-]{2,40}$", "", title)
    return hashlib.sha1(norm(t).encode()).hexdigest()[:16]


class TelegramError(Exception):
    pass


HINTS = {
    "chat not found": "TELEGRAM_CHAT_ID sai, hoặc chưa nhắn /start cho bot / chưa thêm bot vào nhóm.",
    "bots can't send messages to bots": "TELEGRAM_CHAT_ID đang là id của bot; cần id người nhận (lấy từ @userinfobot).",
    "bot was blocked by the user": "Bạn đã chặn bot: mở bot trên Telegram, bỏ chặn và bấm Start.",
    "Unauthorized": "TELEGRAM_BOT_TOKEN sai: lấy lại bằng /token trong @BotFather.",
    "Not Found": "TELEGRAM_BOT_TOKEN sai: lấy lại bằng /token trong @BotFather.",
}


def send_telegram(token, chat_id, text):
    for attempt in range(3):
        r = requests.post(
            f"https://api.telegram.org/bot{token}/sendMessage",
            json={"chat_id": chat_id, "text": text, "parse_mode": "HTML", "disable_web_page_preview": False},
            timeout=30,
        )
        if r.status_code == 429:
            time.sleep(r.json().get("parameters", {}).get("retry_after", 5) + 1)
            continue
        if r.ok:
            return
        try:
            desc = r.json().get("description", r.text)
        except ValueError:
            desc = r.text
        hint = next((h for k, h in HINTS.items() if k.lower() in desc.lower()), "")
        raise TelegramError(f"Telegram {r.status_code}: {desc}" + (f" → {hint}" if hint else ""))
    raise TelegramError("Telegram 429: gửi quá nhanh, thử lại sau.")


def find_chats(token):
    """Các cuộc trò chuyện vừa nhắn cho bot (để tìm đúng Chat ID)."""
    r = requests.get(f"https://api.telegram.org/bot{token}/getUpdates", timeout=30)
    chats = {}
    for u in r.json().get("result", []):
        for key in ("message", "channel_post", "my_chat_member", "edited_message"):
            chat = (u.get(key) or {}).get("chat")
            if chat:
                name = chat.get("title") or " ".join(filter(None, [chat.get("first_name"), chat.get("last_name")]))
                chats[chat["id"]] = f"{name} ({chat.get('type')})"
    return chats


def format_message(item):
    tags = " ".join("#" + re.sub(r"\W+", "_", k).strip("_") for k in item["keywords"][:4])
    lines = [f"🏗 <b>{html.escape(item['title'])}</b>", f"📰 {html.escape(item['source'])}"]
    if item["summary"] and norm(item["summary"])[:40] not in norm(item["title"]):
        lines.append(html.escape(item["summary"][:300]))
    lines.append(f'🔗 <a href="{html.escape(item["link"], quote=True)}">Đọc bài</a>')
    if tags:
        lines.append(tags)
    return "\n".join(lines)


def save_digest(items):
    """Ghi tin đã gửi vào digest/YYYY-MM-DD.json (giờ Việt Nam)."""
    if not items:
        return
    DIGEST_DIR.mkdir(exist_ok=True)
    now = datetime.now(VN_TZ)
    path = DIGEST_DIR / f"{now:%Y-%m-%d}.json"
    data = json.loads(path.read_text(encoding="utf-8")) if path.exists() else []
    for it in items:
        data.append({
            "title": it["title"], "link": it["link"], "source": it["source"],
            "summary": it["summary"][:400], "keywords": it["keywords"][:6],
            "time": now.strftime("%H:%M"),
        })
    path.write_text(json.dumps(data, ensure_ascii=False, indent=1) + "\n", encoding="utf-8")
    cutoff = f"{now - timedelta(days=DIGEST_KEEP_DAYS):%Y-%m-%d}"
    for old in DIGEST_DIR.glob("*.json"):
        if old.stem < cutoff:
            old.unlink()


def main():
    dry_run = os.environ.get("DRY_RUN") == "1"
    token = os.environ.get("TELEGRAM_BOT_TOKEN", "").strip()
    chat_id = os.environ.get("TELEGRAM_CHAT_ID", "").strip()
    if not dry_run and not (token and chat_id):
        sys.exit("Thiếu TELEGRAM_BOT_TOKEN hoặc TELEGRAM_CHAT_ID (hoặc đặt DRY_RUN=1).")

    first_run = not SEEN_FILE.exists()
    seen = json.loads(SEEN_FILE.read_text()) if not first_run else []
    seen_set = set(seen)
    max_age = time.time() - 3 * 86400

    test_mode = os.environ.get("TEST_MESSAGE") == "1"
    new_items, errors, latest = [], [], None
    for src in CONFIG["sources"]:
        try:
            items = parse_rss(src) if src["type"] == "rss" else parse_html(src)
        except Exception as e:  # một nguồn lỗi không làm hỏng cả lượt quét
            errors.append(f"{src['name']}: {e}")
            continue
        for it in items:
            if latest is None or (it["published"] or 0) > (latest["published"] or 0):
                latest = dict(it, source=src["name"], keywords=matched_keywords(it["title"] + " " + it["summary"]))
        kept = 0
        for it in items:
            ids = {item_id(it), title_key(it["title"])}
            if ids & seen_set:
                continue
            if it["published"] and it["published"] < max_age:
                continue
            kws = matched_keywords(it["title"] + " " + it["summary"])
            if src.get("require_keywords") and not kws:
                continue
            seen_set |= ids
            seen.extend(ids)
            it.update(source=src["name"], keywords=kws)
            new_items.append(it)
            kept += 1
        print(f"[{src['name']}] {len(items)} bài, {kept} bài mới")

    for e in errors:
        print("LỖI", e, file=sys.stderr)

    if test_mode:
        if latest is None:
            sys.exit("Không lấy được bài nào để gửi thử.")
        msg = "🧪 <b>TIN THỬ</b> – bot đã kết nối, tin mới sẽ về đây.\n\n" + format_message(latest)
        if dry_run:
            print(msg)
        else:
            try:
                send_telegram(token, chat_id, msg)
            except TelegramError as e:
                print(f"LỖI GỬI TIN THỬ: {e}")
                # Chat ID sai: hỏi Telegram xem ai vừa nhắn cho bot, gửi thử tới đó.
                chats = find_chats(token) if "chat" in str(e).lower() or "bot" in str(e).lower() else {}
                if not chats:
                    sys.exit("Không tìm thấy cuộc trò chuyện nào: hãy nhắn 'hello' cho bot rồi chạy lại.")
                for cid, name in chats.items():
                    print(f"==> Tìm thấy Chat ID: {cid}  –  {name}")
                cid = next(iter(chats))
                send_telegram(token, cid, msg + f"\n\n🔑 Chat ID đúng: <code>{cid}</code> – lưu vào TELEGRAM_CHAT_ID.")
                sys.exit(f"Đã gửi tin thử tới {cid}. Cập nhật TELEGRAM_CHAT_ID = {cid} rồi chạy lại.")
            print("Đã gửi 1 tin thử.")
        return

    new_items.sort(key=lambda x: x["published"] or 0)
    if first_run and os.environ.get("SEND_ON_FIRST_RUN") != "1":
        print(f"Lần chạy đầu: ghi nhận {len(new_items)} bài, không gửi.")
        to_send = []
    else:
        to_send = new_items[-MAX_PER_RUN:]

    sent, failed, delivered = 0, [], []
    for it in to_send:
        msg = format_message(it)
        if dry_run:
            print("-" * 60 + "\n" + msg)
            continue
        try:
            send_telegram(token, chat_id, msg)
            sent += 1
            delivered.append(it)
        except (TelegramError, requests.RequestException) as e:
            failed.append(it)
            print(f"LỖI GỬI \"{it['title'][:60]}\": {e}", file=sys.stderr)
        time.sleep(1.1)  # giới hạn Telegram ~1 tin/giây/chat
    print(f"Đã gửi {sent} tin, lỗi {len(failed)} tin.")

    # Gửi hỏng toàn bộ (sai token/chat id): không lưu trạng thái để lần sau gửi lại.
    if failed and not sent:
        sys.exit("Không gửi được tin nào, kiểm tra lỗi ở trên.")

    if not dry_run:
        SEEN_FILE.write_text(json.dumps(seen[-SEEN_LIMIT:], indent=0) + "\n")
        save_digest(delivered)


if __name__ == "__main__":
    main()
