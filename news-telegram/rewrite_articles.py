"""Viết lại tin xây dựng – quy hoạch – hạ tầng Đà Nẵng thành bài riêng bằng AI và đăng lên web.

Mỗi lần chạy:
  1. Lấy tin Đà Nẵng về quy hoạch / xây dựng / hạ tầng / nhà ở (hôm qua + hôm nay) trong digest/.
  2. Claude chọn tối đa MAX_ARTICLES chủ đề nổi bật, gộp các bài trùng chủ đề, bỏ chủ đề đã viết.
  3. Với mỗi chủ đề: Claude tra cứu (web search / web fetch), viết bài mới bằng lời văn riêng,
     có dẫn nguồn, rồi đăng lên WordPress và báo link về Telegram.

Biến môi trường:
  ANTHROPIC_API_KEY                API key Claude
  WP_APP_PASSWORD (+ WP_USER)      như publish_digest.py
  WP_STATUS                        publish (mặc định) hoặc draft
  MAX_ARTICLES                     số bài tối đa mỗi lần chạy (mặc định 3)
  TELEGRAM_BOT_TOKEN, TELEGRAM_CHAT_ID   báo link bài mới (không bắt buộc)
  DRY_RUN=1                        chỉ chọn chủ đề và viết, in ra, không đăng
"""
import html
import json
import os
import re
import sys
from datetime import datetime, timedelta

import anthropic
import requests

from publish_digest import DA_NANG_WORDS, login, slugify, split_publisher, tag_ids, wp_request
from scan_news import DIGEST_DIR, ROOT, VN_TZ, matched_keywords, norm, send_telegram, title_key

MODEL = "claude-opus-5-5"
DONE_FILE = ROOT / "rewritten.json"
DONE_KEEP_DAYS = 30
FALLBACK_BETA = "server-side-fallback-2026-07-01"
VI_CHARS = re.compile("[ăâđêôơưạảấầẩẫậắằẳẵặẹẻẽếềểễệỉịọỏốồổỗộớờởỡợụủứừửữựỳỵỷỹ]")
SKIP_TITLES = re.compile(r"thông tin báo chí|chỉ đạo, điều hành|^video", re.I)

SELECT_SYSTEM = """Bạn là biên tập viên chuyên mục "Hạ tầng & quy hoạch" của hiephoangmt.com, \
trang về bất động sản Đà Nẵng. Từ danh sách tin trong ngày, hãy chọn các chủ đề đáng viết thành bài riêng.

Tiêu chí:
- Thuộc lĩnh vực của Sở Xây dựng Đà Nẵng hoặc ảnh hưởng trực tiếp tới bất động sản Đà Nẵng: quy hoạch, \
xây dựng, hạ tầng giao thông, nhà ở, khu đô thị, khu thương mại tự do, đất đai, tái định cư, giá đất.
- Ưu tiên tin có số liệu, quyết định, phê duyệt, tiến độ cụ thể; bỏ tin quảng cáo dự án, tin chung chung.
- Nhiều bài cùng nói một sự kiện thì gộp thành MỘT chủ đề, liệt kê đủ số thứ tự các bài đó.
- Không chọn chủ đề trùng với các bài đã viết gần đây (danh sách kèm theo).
- Có thể trả về ít hơn số lượng tối đa, kể cả danh sách rỗng, nếu không có gì đáng viết."""

WRITE_SYSTEM = """Bạn là phóng viên chuyên mục "Hạ tầng & quy hoạch" của hiephoangmt.com (Hoàng Hiệp – \
bất động sản Đà Nẵng). Nhiệm vụ: viết MỘT bài báo tiếng Việt mới về chủ đề được giao.

Cách làm:
- Dùng web search / web fetch để đọc các bài nguồn và đối chiếu thông tin (ưu tiên trang chính thức: \
danang.gov.vn, sxd.danang.gov.vn, báo Đà Nẵng, báo Xây dựng…).
- Chỉ viết những gì nguồn xác nhận: số liệu, tên dự án, địa điểm, cơ quan, thời gian phải đúng như nguồn. \
Không bịa, không suy đoán con số. Nếu không đọc được nguồn nào đáng tin, trả về đúng thẻ <skip>lý do</skip>.
- Viết bằng lời văn của bạn, không chép nguyên câu, nguyên đoạn của báo khác.
- Dài khoảng 600–900 từ: mở bài nêu ngay thông tin chính; 3–5 mục có tiêu đề <h2>; có một mục ngắn về ý nghĩa \
đối với thị trường bất động sản / người mua nhà ở khu vực liên quan, chỉ dựa trên thông tin đã có, \
giọng trung lập, không khuyến nghị mua bán.
- Không tự thêm mục nguồn tham khảo hay câu hỏi thường gặp vào content (hệ thống tự thêm).

Tối ưu cho Google và các trợ lý AI (ChatGPT, Gemini, Perplexity) trích dẫn:
- Chọn 1 từ khoá chính người dùng hay tìm (ví dụ "quy hoạch phân khu Hòa Xuân Đà Nẵng"); đặt nó trong tiêu đề, \
câu đầu tiên và ít nhất một tiêu đề <h2>.
- Đoạn mở bài 2–3 câu trả lời thẳng: cái gì, ở đâu, ai quyết định, khi nào, quy mô bao nhiêu. \
Ngay sau đó là <ul> "điểm chính" 3–5 ý, mỗi ý một dữ kiện cụ thể (con số, ngày, số quyết định).
- Ghi ngày cụ thể (ngày 24/10/2026), không viết "hôm qua", "tuần này"; ghi tên đầy đủ của cơ quan, dự án, \
phường/xã (theo địa giới hiện hành) ở lần nhắc đầu tiên.
- Tiêu đề <h2> viết như câu hỏi hoặc cụm từ người dùng hay gõ khi tìm kiếm, nếu tự nhiên.
- Câu ngắn, mỗi đoạn một ý, để AI dễ trích nguyên câu.

Trả lời đúng định dạng sau, không thêm gì khác:
<title>Tiêu đề bài (dưới 90 ký tự, có từ khoá chính và "Đà Nẵng")</title>
<excerpt>Tóm tắt 1–2 câu, dưới 160 ký tự, có từ khoá chính, dùng làm mô tả SEO</excerpt>
<keyword>từ khoá chính</keyword>
<tags>3–5 thẻ ngắn, cách nhau bằng dấu phẩy (tên dự án, khu vực, loại tin)</tags>
<content>Nội dung HTML, chỉ dùng các thẻ p, h2, h3, ul, ol, li, strong, em</content>
<faq>3–4 câu hỏi người đọc hay hỏi về chủ đề, trả lời 1–3 câu chỉ dựa trên thông tin trong bài, dạng:
<q>Câu hỏi?</q><a>Trả lời.</a></faq>"""

WEB_TOOLS = [
    {"type": "web_search_20260209", "name": "web_search", "max_uses": 6,
     "user_location": {"type": "approximate", "country": "VN", "city": "Da Nang"}},
    {"type": "web_fetch_20260209", "name": "web_fetch", "max_uses": 6, "max_content_tokens": 20000},
]
SELECT_SCHEMA = {
    "type": "object",
    "properties": {
        "topics": {
            "type": "array",
            "items": {
                "type": "object",
                "properties": {
                    "topic": {"type": "string", "description": "Chủ đề, 1 câu"},
                    "items": {"type": "array", "items": {"type": "integer"},
                              "description": "Số thứ tự các bài trong danh sách thuộc chủ đề này"},
                },
                "required": ["topic", "items"],
                "additionalProperties": False,
            },
        }
    },
    "required": ["topics"],
    "additionalProperties": False,
}
ALLOWED_TAGS = {"p", "h2", "h3", "ul", "ol", "li", "strong", "em", "b", "i", "br"}


def candidates():
    """Tin Đà Nẵng có từ khoá xây dựng / quy hoạch / hạ tầng, hôm qua + hôm nay, bỏ trùng tiêu đề."""
    today = datetime.now(VN_TZ).date()
    out, seen = [], set()
    for day in (today - timedelta(days=1), today):
        path = DIGEST_DIR / f"{day:%Y-%m-%d}.json"
        if not path.exists():
            continue
        for it in json.loads(path.read_text(encoding="utf-8")):
            title, publisher = split_publisher(it)
            t = norm(title)
            if not VI_CHARS.search(t) or SKIP_TITLES.search(t):
                continue
            if not any(w in t for w in DA_NANG_WORDS) or not matched_keywords(title):
                continue
            key = title_key(it["title"])
            if key not in seen:
                seen.add(key)
                out.append({"title": title, "publisher": publisher, "link": it["link"], "summary": it["summary"]})
    return out


def load_done():
    if not DONE_FILE.exists():
        return []
    cutoff = f"{datetime.now(VN_TZ) - timedelta(days=DONE_KEEP_DAYS):%Y-%m-%d}"
    return [d for d in json.loads(DONE_FILE.read_text(encoding="utf-8")) if d["date"] >= cutoff]


def ask(client, **kw):
    """Gọi Claude (stream), tự nối tiếp khi server tool tạm dừng (pause_turn)."""
    messages = kw.pop("messages")
    for _ in range(5):
        with client.beta.messages.stream(
            model=MODEL, betas=[FALLBACK_BETA], fallbacks="default", messages=messages, **kw
        ) as stream:
            msg = stream.get_final_message()
        if msg.stop_reason != "pause_turn":
            return msg
        messages = messages + [{"role": "assistant", "content": msg.content}]
    return msg


def text_of(msg):
    return "".join(b.text for b in msg.content if b.type == "text")


def select_topics(client, items, done, limit):
    listing = "\n".join(f"{i}. {it['title']} ({it['publisher']})" for i, it in enumerate(items))
    recent = "\n".join(f"- {d['title']}" for d in done[-40:]) or "(chưa có)"
    msg = ask(
        client,
        max_tokens=8000,
        system=SELECT_SYSTEM,
        output_config={"effort": "low", "format": {"type": "json_schema", "schema": SELECT_SCHEMA}},
        messages=[{"role": "user", "content":
                   f"Chọn tối đa {limit} chủ đề.\n\nBài đã viết gần đây:\n{recent}\n\nTin trong ngày:\n{listing}"}],
    )
    if msg.stop_reason == "refusal":
        print("Claude từ chối bước chọn chủ đề.")
        return []
    topics = json.loads(text_of(msg))["topics"][:limit]
    return [(t["topic"], [items[i] for i in t["items"] if 0 <= i < len(items)]) for t in topics if t["items"]]


def clean_html(content):
    """Chỉ giữ các thẻ cho phép, bỏ thuộc tính (bài đăng thẳng lên web)."""
    def fix(m):
        closing, tag = m.group(1), m.group(2).lower()
        return f"<{closing}{tag}>" if tag in ALLOWED_TAGS else ""
    content = re.sub(r"<(script|style|iframe)\b.*?</\1>", "", content, flags=re.S | re.I)
    return re.sub(r"<(/?)([a-zA-Z0-9]+)[^>]*>", fix, content).strip()


def strip_tags(text):
    return re.sub(r"\s+", " ", re.sub(r"<[^>]+>", "", text)).strip()


def faq_block(faq):
    """Mục hỏi – đáp: người đọc lướt nhanh, Google/AI dễ lấy làm câu trả lời."""
    if not faq:
        return ""
    qa = "".join(f"<h3>{html.escape(q)}</h3><p>{html.escape(a)}</p>" for q, a in faq)
    return f"<h2>Câu hỏi thường gặp</h2>{qa}"


def related_block(article, done, limit=3):
    """Liên kết tới bài cũ cùng chủ đề (liên kết nội bộ giúp Google hiểu và xếp hạng cả cụm bài)."""
    stop = {"đà", "nẵng", "và", "của", "các", "cho", "tại", "với", "được", "trong", "dự", "án", "thành", "phố"}
    words = lambda t: {w for w in re.findall(r"\w+", norm(t)) if len(w) > 1 and w not in stop}
    mine = words(article["title"] + " " + article["keyword"] + " " + " ".join(article["tags"]))
    scored = sorted(((len(mine & words(d["title"])), i, d) for i, d in enumerate(done) if d.get("link")),
                    key=lambda x: (x[0], x[1]), reverse=True)
    picks = [d for score, _, d in scored if score >= 2][:limit]
    if not picks:
        return ""
    lis = "".join(f'<li><a href="{html.escape(d["link"], quote=True)}">{html.escape(d["title"])}</a></li>'
                  for d in picks)
    return f"<h3>Bài liên quan</h3><ul>{lis}</ul>"


def write_article(client, topic, sources):
    refs = "\n".join(f"- {s['title']} ({s['publisher']}): {s['link']}" for s in sources)
    msg = ask(
        client,
        max_tokens=64000,
        system=WRITE_SYSTEM,
        output_config={"effort": "high"},
        tools=WEB_TOOLS,
        messages=[{"role": "user", "content": f"Chủ đề: {topic}\n\nCác bài nguồn:\n{refs}"}],
    )
    if msg.stop_reason == "refusal":
        return None, "Claude từ chối"
    out = text_of(msg)
    skip = re.search(r"<skip>(.*?)</skip>", out, re.S)
    if skip:
        return None, skip.group(1).strip()
    parts = {k: re.search(fr"<{k}>(.*?)</{k}>", out, re.S) for k in ("title", "excerpt", "content")}
    if not all(parts.values()):
        return None, f"sai định dạng (stop_reason={msg.stop_reason})"
    article = {k: m.group(1).strip() for k, m in parts.items()}
    article["content"] = clean_html(article["content"])
    opt = {k: re.search(fr"<{k}>(.*?)</{k}>", out, re.S) for k in ("keyword", "tags", "faq")}
    article["keyword"] = opt["keyword"].group(1).strip() if opt["keyword"] else ""
    article["tags"] = [t.strip() for t in opt["tags"].group(1).split(",")][:5] if opt["tags"] else []
    article["faq"] = [(strip_tags(q), strip_tags(a)) for q, a in
                      re.findall(r"<q>(.*?)</q>\s*<a>(.*?)</a>", opt["faq"].group(1), re.S)][:4] if opt["faq"] else []
    if len(re.sub(r"<[^>]+>", " ", article["content"]).split()) < 250:
        return None, "bài quá ngắn"
    return article, None


def source_block(sources):
    lis = "".join(
        f'<li><a href="{html.escape(s["link"], quote=True)}" target="_blank" rel="nofollow noopener">'
        f'{html.escape(s["title"])}</a> ({html.escape(s["publisher"])})</li>' for s in sources)
    return f"<h3>Nguồn tham khảo</h3><ul>{lis}</ul>"


def main():
    dry_run = os.environ.get("DRY_RUN") == "1"
    limit = int(os.environ.get("MAX_ARTICLES") or 3)
    items = candidates()
    done = load_done()
    print(f"{len(items)} tin ứng viên, {len(done)} bài đã viết trong {DONE_KEEP_DAYS} ngày.")
    if not items:
        return

    client = anthropic.Anthropic()
    topics = select_topics(client, items, done, limit)
    print(f"Chọn {len(topics)} chủ đề: " + " | ".join(t for t, _ in topics))
    if not topics:
        return

    if not dry_run:
        base = os.environ.get("WP_URL", "https://hiephoangmt.com").rstrip("/") + "/wp-json/wp/v2/posts"
        auth = login(base, os.environ.get("WP_USER", "").strip(), os.environ.get("WP_APP_PASSWORD", "").strip())
    token = os.environ.get("TELEGRAM_BOT_TOKEN", "").strip()
    chat_id = os.environ.get("TELEGRAM_CHAT_ID", "").strip()

    for topic, sources in topics:
        try:
            article, reason = write_article(client, topic, sources)
        except anthropic.APIError as e:
            print(f"LỖI Claude ({topic[:60]}): {e}", file=sys.stderr)
            continue
        if not article:
            print(f"Bỏ qua \"{topic[:60]}\": {reason}")
            continue
        if dry_run:
            print("=" * 70, f"\n{article['title']}\n/{slugify(article['keyword'] or article['title'])}/"
                  f"\n{article['excerpt']}\nThẻ: {', '.join(article['tags'])}\n\n{article['content']}"
                  f"\n{faq_block(article['faq'])}\n{source_block(sources)}\n{related_block(article, done)}")
            continue
        post = wp_request("POST", base, auth, json={
            "title": article["title"],
            "slug": slugify(article["keyword"] or article["title"]),
            "excerpt": article["excerpt"],
            "content": "\n".join(filter(None, [article["content"], faq_block(article["faq"]),
                                              source_block(sources), related_block(article, done)])),
            "status": os.environ.get("WP_STATUS") or "publish",
            "categories": [int(os.environ.get("WP_CATEGORY_ID") or 121)],
            "tags": tag_ids(base, auth, article["tags"] + ["quy hoạch Đà Nẵng"]),
        })
        print(f"Đã đăng: {article['title']} → {post['link']}")
        done.append({"date": f"{datetime.now(VN_TZ):%Y-%m-%d}", "title": article["title"],
                     "topic": topic, "link": post["link"]})
        DONE_FILE.write_text(json.dumps(done, ensure_ascii=False, indent=1) + "\n", encoding="utf-8")
        if token and chat_id:
            try:
                send_telegram(token, chat_id, f"✍️ <b>Bài mới trên web</b>\n{html.escape(article['title'])}\n"
                                              f'🔗 <a href="{html.escape(post["link"], quote=True)}">Đọc bài</a>')
            except Exception as e:  # báo Telegram lỗi không ảnh hưởng bài đã đăng
                print(f"Không gửi được Telegram: {e}", file=sys.stderr)


if __name__ == "__main__":
    main()
