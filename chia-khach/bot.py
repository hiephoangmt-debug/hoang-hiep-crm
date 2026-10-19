#!/usr/bin/env python3
"""
BOT CHIA KHÁCH CHO ĐỘI SALE — Telegram.

  • Nhận khách từ form LadiPage (webhook) hoặc quản lý nhập tay
  • Chia LẦN LƯỢT cho từng sale; sale phải bấm "Nhận khách"
  • 30 phút không nhận           → thu hồi, giao người kế tiếp
  • Nhận rồi 2 giờ không báo cáo → thu hồi
  • 3 ngày chưa xác nhận "khách nóng" → thu hồi
  • Thời hạn chỉ tính trong giờ làm việc (mặc định 7:30–21:30)
  • Riêng tư: nhóm chỉ thấy số đã che; số đầy đủ chỉ người đang giữ khách xem được
    (bấm nút, có ghi nhật ký, chặn chuyển tiếp/lưu); thu hồi là xoá tin cũ
  • Báo cáo tự động mỗi sáng + xếp hạng thứ Hai

Chỉ dùng thư viện chuẩn Python 3.9+.  Chạy:  python3 bot.py
"""

import csv
import io
import json
import queue
import os
import random
import re
import sys
import threading
import time
import urllib.error
import urllib.request
import uuid
from datetime import datetime, timedelta
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer
from pathlib import Path
from urllib.parse import parse_qs, urlparse

BASE_DIR = Path(__file__).resolve().parent
ENV_FILE = BASE_DIR / ".env"
DATA_DIR = BASE_DIR / "data"
DATA_FILE = DATA_DIR / "du_lieu.json"
AUDIT_FILE = DATA_DIR / "nhat_ky.csv"

try:
    sys.stdout.reconfigure(errors="replace")
except (AttributeError, ValueError):
    pass


# =============================================================== CẤU HÌNH
def load_env():
    if not ENV_FILE.exists():
        return
    for line in ENV_FILE.read_text(encoding="utf-8").splitlines():
        line = line.strip()
        if line and not line.startswith("#") and "=" in line:
            k, v = line.split("=", 1)
            os.environ.setdefault(k.strip(), v.strip().strip('"').strip("'"))


def save_env(key, value):
    lines = ENV_FILE.read_text(encoding="utf-8").splitlines() if ENV_FILE.exists() else []
    for i, line in enumerate(lines):
        if line.split("=", 1)[0].strip() == key:
            lines[i] = f"{key}={value}"
            break
    else:
        lines.append(f"{key}={value}")
    ENV_FILE.write_text("\n".join(lines) + "\n", encoding="utf-8")
    os.environ[key] = str(value)


load_env()


def env_int(key, default):
    try:
        return int(os.environ.get(key, default))
    except ValueError:
        return default


def env_hm(key, default):
    m = re.match(r"^(\d{1,2})[:h](\d{2})$", os.environ.get(key, default).strip())
    return (int(m.group(1)), int(m.group(2))) if m else tuple(map(int, default.split(":")))


TG_TOKEN = os.environ.get("TG_TOKEN", "").strip()
PORT = env_int("PORT", 8090)
LEAD_KEY = os.environ.get("LEAD_KEY", "").strip()
OFFER_MIN = env_int("HAN_NHAN_PHUT", 30)          # phút để bấm nhận
REPORT_MIN = env_int("HAN_BAO_CAO_PHUT", 120)     # phút để báo cáo sau khi nhận
HOT_DAYS = env_int("HAN_KHACH_NONG_NGAY", 3)      # ngày để xác nhận khách nóng
MAX_ROUNDS = env_int("SO_LUOT_TOI_DA", 3)         # quá số lượt thu hồi → về quản lý
DEDUP_DAYS = env_int("TRUNG_KHACH_NGAY", 30)
WORK_START = env_hm("GIO_BAT_DAU", "7:30")
WORK_END = env_hm("GIO_KET_THUC", "21:30")
REPORT_HOUR = env_hm("GIO_BAO_CAO", "8:00")
DELETE_LIMIT_H = 47                                # Telegram chỉ cho xoá tin < 48 giờ

TG_API = os.environ.get("TG_API_BASE", "https://api.telegram.org").rstrip("/") + "/bot{token}/{method}"
SHEET_URL = os.environ.get("SHEET_WEBHOOK_URL", "").strip()
SHEET_SECRET = os.environ.get("SHEET_SECRET", "").strip()
LOCK = threading.RLock()


def log(*a):
    print(datetime.now().strftime("%H:%M:%S"), *a, flush=True)


def now():
    return datetime.now()


def fmt(dt):
    return dt.strftime("%H:%M %d/%m") if dt else "-"


def parse(s):
    return datetime.fromisoformat(s) if s else None


def iso(dt):
    return dt.isoformat(timespec="seconds") if dt else None


def norm_phone(s):
    d = re.sub(r"\D", "", str(s or ""))
    if d.startswith("84") and len(d) >= 11:
        d = "0" + d[2:]
    return d


def mask_phone(p):
    p = norm_phone(p)
    return p[:3] + "****" + p[-3:] if len(p) >= 7 else "***"


def esc(s):
    return str(s or "").replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")


# =============================================================== GIỜ LÀM VIỆC
def _work_bounds(day):
    s = day.replace(hour=WORK_START[0], minute=WORK_START[1], second=0, microsecond=0)
    e = day.replace(hour=WORK_END[0], minute=WORK_END[1], second=0, microsecond=0)
    return s, e


def add_work_minutes(start, minutes):
    """Cộng số phút làm việc: ngoài giờ làm thì đồng hồ dừng."""
    t, left = start, timedelta(minutes=minutes)
    for _ in range(400):
        s, e = _work_bounds(t)
        if t < s:
            t = s
        if t >= e:
            t = _work_bounds(t + timedelta(days=1))[0]
            continue
        room = e - t
        if left <= room:
            return t + left
        left -= room
        t = _work_bounds(t + timedelta(days=1))[0]
    return t


def in_work_hours(t=None):
    t = t or now()
    s, e = _work_bounds(t)
    return s <= t < e


# =============================================================== DỮ LIỆU
def empty_db():
    return {"sales": {}, "order": [], "leads": {}, "next_id": 1, "admins": [], "group_id": None,
            "pending": {}, "last_daily": None, "last_weekly": None, "claim_code": None}


def load_db():
    DATA_DIR.mkdir(exist_ok=True)
    if DATA_FILE.exists():
        try:
            d = json.loads(DATA_FILE.read_text(encoding="utf-8"))
            base = empty_db()
            base.update(d)
            return base
        except ValueError:
            bak = DATA_FILE.with_suffix(".hong.json")
            DATA_FILE.replace(bak)
            log("⚠️ File dữ liệu hỏng, đã đổi tên thành", bak.name)
    return empty_db()


DB = load_db()


def save_db():
    with LOCK:
        tmp = DATA_FILE.with_suffix(".tmp")
        tmp.write_text(json.dumps(DB, ensure_ascii=False, indent=1), encoding="utf-8")
        tmp.replace(DATA_FILE)


def audit(actor, action, lead_id="", detail=""):
    new = not AUDIT_FILE.exists()
    with LOCK, AUDIT_FILE.open("a", encoding="utf-8-sig" if new else "utf-8", newline="") as f:
        w = csv.writer(f)
        if new:
            w.writerow(["thoi_gian", "nguoi", "hanh_dong", "khach", "chi_tiet"])
        row = [now().strftime("%Y-%m-%d %H:%M:%S"), sale_name(actor) if str(actor) in DB["sales"] else str(actor), action, lead_id, detail]
        w.writerow(row)
    if SHEET_URL:
        SYNC_Q.put(row)


def sale_name(sid):
    s = DB["sales"].get(str(sid))
    return s["name"] if s else f"#{sid}"


def is_admin(uid):
    return str(uid) in [str(a) for a in DB["admins"]]


# =============================================================== TELEGRAM
def tg(method, body=None, timeout=60):
    url = TG_API.format(token=TG_TOKEN, method=method)
    req = urllib.request.Request(url, data=json.dumps(body or {}).encode("utf-8"), method="POST")
    req.add_header("Content-Type", "application/json")
    try:
        with urllib.request.urlopen(req, timeout=timeout) as r:
            return json.loads(r.read().decode("utf-8"))
    except urllib.error.HTTPError as e:
        try:
            return json.loads(e.read().decode("utf-8"))
        except ValueError:
            return {"ok": False, "description": str(e)}
    except Exception as e:  # mạng chập chờn
        return {"ok": False, "description": str(e)}


def send(chat_id, text, buttons=None, protect=False):
    body = {"chat_id": chat_id, "text": text, "parse_mode": "HTML",
            "disable_web_page_preview": True, "protect_content": protect}
    if buttons:
        body["reply_markup"] = {"inline_keyboard": buttons}
    r = tg("sendMessage", body)
    if not r.get("ok"):
        log("Lỗi gửi tin", chat_id, r.get("description"))
        return None
    return r["result"]["message_id"]


def edit(chat_id, msg_id, text, buttons=None):
    body = {"chat_id": chat_id, "message_id": msg_id, "text": text, "parse_mode": "HTML",
            "disable_web_page_preview": True}
    body["reply_markup"] = {"inline_keyboard": buttons or []}
    tg("editMessageText", body)


def delete(chat_id, msg_id):
    tg("deleteMessage", {"chat_id": chat_id, "message_id": msg_id}, timeout=20)


def answer_cb(cb_id, text="", alert=False):
    tg("answerCallbackQuery", {"callback_query_id": cb_id, "text": text, "show_alert": alert}, timeout=20)


def send_document(chat_id, filename, content: bytes, caption=""):
    boundary = uuid.uuid4().hex
    parts = []
    for k, v in (("chat_id", str(chat_id)), ("caption", caption), ("protect_content", "true")):
        parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="{k}"\r\n\r\n{v}\r\n'.encode())
    parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="document"; filename="{filename}"\r\n'
                 f'Content-Type: text/csv\r\n\r\n'.encode() + content + b"\r\n")
    parts.append(f"--{boundary}--\r\n".encode())
    req = urllib.request.Request(TG_API.format(token=TG_TOKEN, method="sendDocument"), data=b"".join(parts))
    req.add_header("Content-Type", f"multipart/form-data; boundary={boundary}")
    try:
        urllib.request.urlopen(req, timeout=60).read()
    except Exception as e:
        log("Lỗi gửi file", e)


def notify_admins(text, buttons=None):
    for a in DB["admins"]:
        send(a, text, buttons)


def notify_group(text):
    if DB.get("group_id"):
        send(DB["group_id"], text)


def remember_msg(lead, sid, msg_id):
    if msg_id:
        lead.setdefault("msgs", []).append({"chat": str(sid), "id": msg_id, "at": iso(now())})


def purge_msgs(lead, sid):
    """Xoá các tin có thông tin khách đã gửi cho sale (Telegram chỉ cho xoá tin < 48 giờ)."""
    keep = []
    for m in lead.get("msgs", []):
        if m["chat"] != str(sid):
            keep.append(m)
            continue
        if now() - parse(m["at"]) < timedelta(hours=DELETE_LIMIT_H):
            delete(m["chat"], m["id"])
    lead["msgs"] = keep


# =============================================================== KHÁCH
STATUS = {
    "cho_giao": "⏳ Chờ giao",
    "cho_nhan": "📨 Chờ sale nhận",
    "dang_cham": "📞 Đang chăm (chưa báo cáo)",
    "da_bao_cao": "📝 Đã báo cáo, chờ xác nhận nóng",
    "nong": "🔥 Khách nóng",
    "dong": "✖️ Đã đóng",
    "ve_quan_ly": "🙋 Về quản lý",
}

REPORTS = [
    ("quan_tam", "✅ Đã gọi – quan tâm"),
    ("khong_nghe", "📵 Không nghe máy"),
    ("hen_lai", "🕐 Hẹn gọi lại"),
    ("nong", "🔥 Khách nóng"),
    ("sai_so", "❌ Sai số"),
    ("khong_nhu_cau", "🚫 Không nhu cầu"),
]
REPORT_LABEL = dict(REPORTS)


def lead_card(lead, show_phone=False):
    phone = lead["phone"] if show_phone else mask_phone(lead["phone"])
    rows = [f"<b>Khách #{lead['id']}</b> · {esc(lead.get('name') or 'Chưa có tên')}",
            f"SĐT: <b>{esc(phone)}</b>"]
    for k, label in (("need", "Nhu cầu"), ("budget", "Ngân sách"), ("purpose", "Mục đích"),
                     ("note", "Lời nhắn"), ("source", "Nguồn")):
        if lead.get(k):
            rows.append(f"{label}: {esc(lead[k])}")
    rows.append(f"Vào lúc: {fmt(parse(lead['created']))}")
    return "\n".join(rows)


def find_by_phone(phone):
    p = norm_phone(phone)
    lim = now() - timedelta(days=DEDUP_DAYS)
    for lead in DB["leads"].values():
        if norm_phone(lead["phone"]) == p and parse(lead["created"]) > lim:
            return lead
    return None


def create_lead(data, actor="webhook"):
    phone = norm_phone(data.get("phone"))
    if len(phone) < 9:
        return None, "Số điện thoại không hợp lệ"
    with LOCK:
        old = find_by_phone(phone)
        if old:
            old.setdefault("history", []).append({"at": iso(now()), "who": actor, "act": "quay_lai",
                                                   "note": data.get("note") or data.get("need") or ""})
            save_db()
            msg = (f"🔁 <b>Khách cũ quay lại</b> (#{old['id']}, {STATUS[old['status']]})\n"
                   f"Người giữ: {sale_name(old['owner']) if old.get('owner') else 'chưa có'}\n"
                   + lead_card(old))
            notify_admins(msg)
            if old.get("owner") and old["status"] in ("dang_cham", "da_bao_cao", "nong"):
                remember_msg(old, old["owner"], send(old["owner"], "🔁 Khách bạn đang giữ vừa để lại thông tin lần nữa:\n" + lead_card(old)))
                save_db()
            audit(actor, "khach_quay_lai", old["id"], mask_phone(phone))
            return old, "trung"
        lid = str(DB["next_id"])
        DB["next_id"] += 1
        lead = {"id": lid, "phone": phone, "name": (data.get("name") or "").strip()[:80],
                "need": (data.get("need") or "")[:200], "budget": (data.get("budget") or "")[:100],
                "purpose": (data.get("purpose") or "")[:100], "note": (data.get("note") or "")[:400],
                "source": (data.get("source") or "")[:120], "created": iso(now()), "status": "cho_giao",
                "owner": None, "excluded": [], "rounds": 0, "history": [], "msgs": [], "notes": []}
        DB["leads"][lid] = lead
        save_db()
    audit(actor, "khach_moi", lid, mask_phone(phone))
    notify_admins("🆕 <b>Khách mới</b>\n" + lead_card(lead))
    assign_next(lead)
    return lead, "moi"


def available_sales(lead):
    out = []
    for sid in DB["order"]:
        s = DB["sales"].get(sid)
        if s and s.get("active") and not s.get("paused") and sid not in lead.get("excluded", []):
            out.append(sid)
    return out


def assign_next(lead):
    with LOCK:
        if lead["rounds"] >= MAX_ROUNDS:
            to_manager(lead, f"đã qua {lead['rounds']} lượt sale")
            return
        cands = available_sales(lead)
        if not cands:
            to_manager(lead, "không còn sale nào sẵn sàng")
            return
        sid = cands[0]
        DB["order"].remove(sid)
        DB["order"].append(sid)          # xoay vòng: người vừa nhận xuống cuối hàng
        assign_to(lead, sid, auto=True)


def assign_to(lead, sid, auto=False):
    with LOCK:
        lead["owner"] = sid
        lead["status"] = "cho_nhan"
        lead["assigned_at"] = iso(now())
        lead["offer_deadline"] = iso(add_work_minutes(now(), OFFER_MIN))
        lead["accepted_at"] = lead["report_deadline"] = lead["hot_deadline"] = None
        lead["rounds"] += 1
        lead["history"].append({"at": iso(now()), "who": sid, "act": "giao"})
        DB["sales"][sid].setdefault("stats", {}).setdefault("offered", 0)
        DB["sales"][sid]["stats"]["offered"] += 1
        text = ("🆕 <b>Bạn được giao khách mới</b>\n" + lead_card(lead) +
                f"\n\n⏰ Bấm <b>Nhận khách</b> trước <b>{fmt(parse(lead['offer_deadline']))}</b>, "
                f"quá hạn khách sẽ chuyển người khác.")
        mid = send(sid, text, [[{"text": "✅ Nhận khách", "callback_data": f"nhan:{lead['id']}"},
                                {"text": "↩️ Trả lại", "callback_data": f"tra:{lead['id']}"}]], protect=True)
        remember_msg(lead, sid, mid)
        save_db()
    audit("bot" if auto else "quan_ly", "giao", lead["id"], sale_name(sid))
    notify_group(f"📨 Khách #{lead['id']} ({mask_phone(lead['phone'])}) đã giao cho <b>{esc(sale_name(sid))}</b>")


def to_manager(lead, reason):
    with LOCK:
        lead["status"] = "ve_quan_ly"
        lead["owner"] = None
        lead["history"].append({"at": iso(now()), "who": "bot", "act": "ve_quan_ly", "note": reason})
        save_db()
    audit("bot", "ve_quan_ly", lead["id"], reason)
    notify_admins(f"🙋 <b>Khách #{lead['id']} về quản lý</b> ({esc(reason)})\n" + lead_card(lead, True) +
                  f"\n\nGiao tay: <code>/giao {lead['id']} số_sale</code>", )


def revoke(lead, reason, actor="bot"):
    with LOCK:
        sid = lead.get("owner")
        if not sid:
            return
        purge_msgs(lead, sid)
        lead["excluded"].append(sid)
        lead["history"].append({"at": iso(now()), "who": actor, "act": "thu_hoi", "from": sid, "note": reason})
        st = DB["sales"].get(sid, {}).setdefault("stats", {})
        st["revoked"] = st.get("revoked", 0) + 1
        lead["owner"] = None
        lead["status"] = "cho_giao"
        save_db()
    send(sid, f"⚠️ Khách #{lead['id']} đã được <b>thu hồi</b>: {esc(reason)}.")
    audit(actor, "thu_hoi", lead["id"], f"{sale_name(sid)}: {reason}")
    notify_admins(f"♻️ Thu hồi khách #{lead['id']} từ <b>{esc(sale_name(sid))}</b>: {esc(reason)}")
    notify_group(f"♻️ Khách #{lead['id']} thu hồi từ {esc(sale_name(sid))} ({esc(reason)})")
    assign_next(lead)


def owner_buttons(lid):
    rows = [[{"text": "📞 Xem SĐT", "callback_data": f"so:{lid}"}]]
    rows += [[{"text": REPORT_LABEL[a], "callback_data": f"bc:{lid}:{a}"},
              {"text": REPORT_LABEL[b], "callback_data": f"bc:{lid}:{b}"}]
             for a, b in (("quan_tam", "khong_nghe"), ("hen_lai", "nong"), ("sai_so", "khong_nhu_cau"))]
    return rows


# =============================================================== XỬ LÝ NÚT BẤM
AWAIT_NOTE = {}   # sale_id -> (lead_id, report_code)


def on_callback(cb):
    uid = str(cb["from"]["id"])
    data = cb.get("data", "")
    msg = cb.get("message") or {}
    chat_id, msg_id = msg.get("chat", {}).get("id"), msg.get("message_id")
    parts = data.split(":")
    kind = parts[0]

    if kind in ("duyet", "tuchoi") and is_admin(uid):
        return on_registration(cb, parts[1], kind == "duyet")

    lead = DB["leads"].get(parts[1]) if len(parts) > 1 else None
    if not lead:
        return answer_cb(cb["id"], "Không tìm thấy khách.")
    if lead.get("owner") != uid:
        audit(uid, "bam_khi_khong_giu", lead["id"], kind)
        return answer_cb(cb["id"], "Bạn không còn giữ khách này.", True)

    if kind == "nhan":
        if lead["status"] != "cho_nhan":
            return answer_cb(cb["id"], "Khách đã được xử lý.")
        with LOCK:
            lead["status"] = "dang_cham"
            lead["accepted_at"] = iso(now())
            lead["report_deadline"] = iso(add_work_minutes(now(), REPORT_MIN))
            lead["hot_deadline"] = iso(now() + timedelta(days=HOT_DAYS))
            lead["history"].append({"at": iso(now()), "who": uid, "act": "nhan"})
            st = DB["sales"][uid].setdefault("stats", {})
            st["accepted"] = st.get("accepted", 0) + 1
            secs = (now() - parse(lead["assigned_at"])).total_seconds()
            st["accept_secs"] = st.get("accept_secs", 0) + secs
            save_db()
        audit(uid, "nhan", lead["id"])
        edit(chat_id, msg_id,
             f"✅ <b>Bạn đã nhận khách #{lead['id']}</b>\n" + lead_card(lead) +
             f"\n\n📝 Báo cáo lần đầu trước <b>{fmt(parse(lead['report_deadline']))}</b>"
             f"\n🔥 Xác nhận khách nóng trước <b>{fmt(parse(lead['hot_deadline']))}</b>"
             "\nBấm <b>Xem SĐT</b> để lấy số gọi khách.", owner_buttons(lead["id"]))
        notify_group(f"✅ {esc(sale_name(uid))} đã nhận khách #{lead['id']}")
        return answer_cb(cb["id"], "Đã nhận. Gọi khách ngay nhé!")

    if kind == "tra":
        answer_cb(cb["id"], "Đã trả lại khách.")
        edit(chat_id, msg_id, f"↩️ Bạn đã trả lại khách #{lead['id']}.")
        return revoke(lead, "sale tự trả lại", uid)

    if lead["status"] not in ("dang_cham", "da_bao_cao", "nong"):
        return answer_cb(cb["id"], "Bạn cần bấm Nhận khách trước.", True)

    if kind == "so":
        audit(uid, "xem_so", lead["id"], mask_phone(lead["phone"]))
        mid = send(uid, f"📞 Khách #{lead['id']} · {esc(lead.get('name') or '')}\n"
                        f"<b>{lead['phone']}</b>\n<i>Tin này tự xoá nếu khách bị thu hồi.</i>", protect=True)
        with LOCK:
            remember_msg(lead, uid, mid)
            save_db()
        return answer_cb(cb["id"])

    if kind == "bc":
        code = parts[2]
        if code == "nong":
            AWAIT_NOTE[uid] = (lead["id"], code)
            answer_cb(cb["id"])
            return send(uid, f"🔥 Khách #{lead['id']}: gửi <b>1 tin ghi chú</b> về nhu cầu thật của khách "
                             "(ngân sách, loại căn, thời gian mua, đã hẹn gì). Bắt buộc để xác nhận khách nóng.")
        record_report(uid, lead, code, "")
        return answer_cb(cb["id"], "Đã ghi báo cáo.")


def record_report(uid, lead, code, note):
    with LOCK:
        first = lead["status"] == "dang_cham"
        lead.setdefault("notes", []).append({"at": iso(now()), "who": uid, "code": code, "note": note})
        lead["history"].append({"at": iso(now()), "who": uid, "act": "bao_cao", "note": f"{code} {note}".strip()})
        st = DB["sales"][uid].setdefault("stats", {})
        if first:
            st["reported"] = st.get("reported", 0) + 1
        lead["last_report"] = iso(now())
        if code in ("sai_so", "khong_nhu_cau"):
            lead["status"] = "dong"
            lead["closed_reason"] = REPORT_LABEL[code]
            purge_msgs(lead, uid)
        elif code == "nong":
            lead["status"] = "nong"
            st["hot"] = st.get("hot", 0) + 1
        else:
            lead["status"] = "da_bao_cao"
        save_db()
    audit(uid, "bao_cao", lead["id"], f"{REPORT_LABEL[code]} {note}".strip())
    send(uid, f"📝 Đã ghi: khách #{lead['id']} – {REPORT_LABEL[code]}"
              + ("" if lead["status"] in ("nong", "dong") else
                 f"\n🔥 Nhớ xác nhận khách nóng trước {fmt(parse(lead['hot_deadline']))}."))
    if code == "nong":
        notify_admins(f"🔥 <b>{esc(sale_name(uid))}</b> xác nhận khách nóng #{lead['id']}\nGhi chú: {esc(note)}")
        notify_group(f"🔥 {esc(sale_name(uid))} có khách nóng #{lead['id']}")
    elif code in ("sai_so", "khong_nhu_cau"):
        notify_admins(f"✖️ Khách #{lead['id']} đóng bởi {esc(sale_name(uid))}: {REPORT_LABEL[code]}\n"
                      f"Mở lại nếu nghi ngờ: <code>/mo {lead['id']}</code>")


# =============================================================== ĐĂNG KÝ SALE
def on_registration(cb, sid, ok):
    p = DB["pending"].pop(sid, None)
    if not p:
        return answer_cb(cb["id"], "Yêu cầu đã xử lý.")
    if ok:
        DB["sales"][sid] = {"name": p["name"], "active": True, "paused": False, "joined": iso(now()), "stats": {}}
        DB["order"].append(sid)
        send(sid, f"🎉 Quản lý đã duyệt. Từ giờ bạn sẽ được chia khách lần lượt.\n\n{SALE_HELP}")
        audit(str(cb["from"]["id"]), "duyet_sale", "", p["name"])
    else:
        send(sid, "Yêu cầu tham gia chưa được duyệt.")
    save_db()
    msg = cb.get("message") or {}
    edit(msg["chat"]["id"], msg["message_id"], f"{'✅ Đã duyệt' if ok else '✖️ Đã từ chối'}: {esc(p['name'])}")
    answer_cb(cb["id"])


# =============================================================== LỆNH
SALE_HELP = ("Lệnh của sale:\n"
             "/cuatoi – khách bạn đang giữ và hạn chót\n"
             "/nghi – tạm ngưng nhận khách (nghỉ phép)\n"
             "/dilam – nhận khách trở lại\n"
             "/ghichu 12 nội dung – thêm ghi chú cho khách #12")

ADMIN_HELP = ("Lệnh quản lý:\n"
              "/baocao – báo cáo hôm nay + 7 ngày\n"
              "/khach – khách đang mở · /khach 12 – chi tiết khách #12\n"
              "/sale – danh sách sale và số thứ tự\n"
              "/them Tên | SĐT | nhu cầu – nhập khách tay\n"
              "/giao 12 3 – giao khách #12 cho sale số 3\n"
              "/thuhoi 12 – thu hồi khách #12\n"
              "/dong 12 · /mo 12 – đóng / mở lại khách\n"
              "/tamdung 3 · /bat 3 · /xoasale 3 – quản lý sale số 3\n"
              "/xuat – tải file khách + nhật ký (CSV)\n"
              "/nhom – gõ trong nhóm Telegram để bot báo tin vào nhóm (chỉ số đã che)\n"
              "/themquanly – tạo mã mời thêm người quản lý")


def sale_by_no(no):
    try:
        return DB["order"][int(no) - 1] if 0 < int(no) <= len(DB["order"]) else None
    except ValueError:
        return None


def on_message(m):
    chat = m["chat"]
    uid = str(m["from"]["id"])
    text = (m.get("text") or "").strip()
    name = " ".join(x for x in (m["from"].get("first_name"), m["from"].get("last_name")) if x)
    if not text:
        return
    cmd, _, arg = text.partition(" ")
    cmd = cmd.split("@")[0].lower()

    # Nhận quyền quản lý lần đầu
    if cmd == "/quanly" and DB.get("claim_code") and arg.strip() == DB["claim_code"]:
        if uid not in DB["admins"]:
            DB["admins"].append(uid)
        DB["claim_code"] = None
        save_db()
        audit(uid, "nhan_quyen_quan_ly", "", name)
        return send(chat["id"], f"✅ Bạn là quản lý.\n\n{ADMIN_HELP}")

    if chat["type"] in ("group", "supergroup"):
        if cmd == "/nhom" and is_admin(uid):
            DB["group_id"] = chat["id"]
            save_db()
            send(chat["id"], "✅ Bot sẽ báo tin chia khách vào nhóm này (chỉ hiện số đã che).")
        return

    # Ghi chú đang chờ (xác nhận khách nóng)
    if uid in AWAIT_NOTE and not text.startswith("/"):
        lid, code = AWAIT_NOTE.pop(uid)
        lead = DB["leads"].get(lid)
        if lead and lead.get("owner") == uid:
            if len(text) < 15:
                AWAIT_NOTE[uid] = (lid, code)
                return send(uid, "Ghi chú hơi ngắn, bạn mô tả rõ hơn nhu cầu của khách nhé (tối thiểu 15 ký tự).")
            return record_report(uid, lead, code, text[:500])

    if is_admin(uid):
        if admin_command(uid, cmd, arg):
            return

    if uid in DB["sales"]:
        return sale_command(uid, cmd, arg)

    # Người lạ → xin tham gia
    if cmd == "/start":
        if uid in DB["pending"]:
            return send(uid, "Yêu cầu của bạn đang chờ quản lý duyệt.")
        DB["pending"][uid] = {"name": name or uid, "at": iso(now())}
        save_db()
        notify_admins(f"🙋 <b>{esc(name)}</b> xin tham gia đội sale.",
                      [[{"text": "✅ Duyệt", "callback_data": f"duyet:{uid}"},
                        {"text": "✖️ Từ chối", "callback_data": f"tuchoi:{uid}"}]])
        return send(uid, "Đã gửi yêu cầu tham gia. Chờ quản lý duyệt nhé.")
    send(uid, "Gõ /start để xin tham gia đội sale.")


def sale_command(uid, cmd, arg):
    s = DB["sales"][uid]
    if cmd == "/cuatoi":
        mine = [l for l in DB["leads"].values() if l.get("owner") == uid and l["status"] not in ("dong",)]
        if not mine:
            return send(uid, "Bạn chưa giữ khách nào.")
        rows = []
        for l in mine:
            due = {"cho_nhan": f"nhận trước {fmt(parse(l['offer_deadline']))}",
                   "dang_cham": f"báo cáo trước {fmt(parse(l['report_deadline']))}",
                   "da_bao_cao": f"xác nhận nóng trước {fmt(parse(l['hot_deadline']))}",
                   "nong": "đang chăm khách nóng"}.get(l["status"], "")
            rows.append(f"#{l['id']} {esc(l.get('name') or '')} – {STATUS[l['status']]} – {due}")
        return send(uid, "Khách bạn đang giữ:\n" + "\n".join(rows))
    if cmd == "/nghi":
        s["paused"] = True
        save_db()
        audit(uid, "tam_nghi")
        return send(uid, "⏸ Đã tạm ngưng nhận khách mới. Gõ /dilam để nhận lại.")
    if cmd == "/dilam":
        s["paused"] = False
        save_db()
        audit(uid, "di_lam")
        return send(uid, "▶️ Bạn đã nhận khách trở lại.")
    if cmd == "/ghichu":
        lid, _, note = arg.partition(" ")
        lead = DB["leads"].get(lid.strip("#"))
        if not lead or lead.get("owner") != uid:
            return send(uid, "Bạn không giữ khách này.")
        if not note.strip():
            return send(uid, "Cú pháp: /ghichu 12 nội dung")
        if lead["status"] == "cho_nhan":
            return send(uid, "Bấm Nhận khách trước đã.")
        return record_report(uid, lead, "quan_tam" if lead["status"] == "dang_cham" else "hen_lai", note.strip()) \
            if lead["status"] in ("dang_cham",) else _add_note(uid, lead, note.strip())
    send(uid, SALE_HELP)


def _add_note(uid, lead, note):
    with LOCK:
        lead.setdefault("notes", []).append({"at": iso(now()), "who": uid, "code": "ghi_chu", "note": note})
        lead["last_report"] = iso(now())
        save_db()
    audit(uid, "ghi_chu", lead["id"], note)
    send(uid, f"📝 Đã thêm ghi chú cho khách #{lead['id']}.")


def admin_command(uid, cmd, arg):
    a = arg.strip()
    if cmd in ("/start", "/help", "/trogiup"):
        send(uid, ADMIN_HELP)
    elif cmd == "/baocao":
        send(uid, build_report(days=1, title="Hôm nay") + "\n\n" + build_report(days=7, title="7 ngày qua"))
    elif cmd == "/sale":
        rows = []
        for i, sid in enumerate(DB["order"], 1):
            s = DB["sales"][sid]
            st = s.get("stats", {})
            flag = "⏸" if s.get("paused") else ("✅" if s.get("active") else "⛔")
            rows.append(f"{i}. {flag} {esc(s['name'])} – giao {st.get('offered', 0)}, nhận {st.get('accepted', 0)}, "
                        f"nóng {st.get('hot', 0)}, bị thu hồi {st.get('revoked', 0)}")
        send(uid, "Đội sale (thứ tự chia tiếp theo):\n" + ("\n".join(rows) or "Chưa có sale. Sale nhắn /start cho bot để xin tham gia."))
    elif cmd == "/khach":
        if a:
            lead = DB["leads"].get(a.strip("#"))
            if not lead:
                return send(uid, "Không có khách này.") or True
            audit(uid, "quan_ly_xem", lead["id"])
            hist = "\n".join(f"• {fmt(parse(h['at']))} {esc(sale_name(h['who']) if h['who'] in DB['sales'] else h['who'])}: "
                             f"{h['act']} {esc(h.get('note', ''))}" for h in lead["history"][-15:])
            notes = "\n".join(f"• {fmt(parse(n['at']))} {esc(sale_name(n['who']))}: {REPORT_LABEL.get(n['code'], 'Ghi chú')} {esc(n['note'])}"
                              for n in lead.get("notes", [])[-10:])
            send(uid, lead_card(lead, True) + f"\n\nTrạng thái: {STATUS[lead['status']]}"
                      f"\nNgười giữ: {esc(sale_name(lead['owner'])) if lead.get('owner') else '-'}"
                      f"\n\n<b>Báo cáo</b>\n{notes or '-'}\n\n<b>Lịch sử</b>\n{hist}", protect=True)
        else:
            open_ = [l for l in DB["leads"].values() if l["status"] not in ("dong",)]
            rows = [f"#{l['id']} {esc(l.get('name') or '')} – {STATUS[l['status']]} – "
                    f"{esc(sale_name(l['owner'])) if l.get('owner') else '-'}" for l in open_[-40:]]
            send(uid, "Khách đang mở:\n" + ("\n".join(rows) or "Không có."))
    elif cmd == "/them":
        p = [x.strip() for x in a.split("|")]
        if len(p) < 2:
            send(uid, "Cú pháp: /them Tên | SĐT | nhu cầu")
        else:
            lead, kind = create_lead({"name": p[0], "phone": p[1], "need": p[2] if len(p) > 2 else "",
                                      "source": "Quản lý nhập tay"}, actor=uid)
            send(uid, "Đã tạo khách." if kind == "moi" else ("Khách trùng, đã báo." if lead else kind))
    elif cmd == "/giao":
        lid, _, no = a.partition(" ")
        lead, sid = DB["leads"].get(lid.strip("#")), sale_by_no(no.strip())
        if not lead or not sid:
            send(uid, "Cú pháp: /giao 12 3 (khách #12 cho sale số 3, xem /sale)")
        else:
            if lead.get("owner"):
                purge_msgs(lead, lead["owner"])
                send(lead["owner"], f"⚠️ Quản lý đã chuyển khách #{lead['id']} cho người khác.")
            lead["rounds"] = max(0, lead["rounds"] - 1)
            if sid in lead["excluded"]:
                lead["excluded"].remove(sid)
            assign_to(lead, sid)
            send(uid, f"Đã giao khách #{lead['id']} cho {esc(sale_name(sid))}.")
    elif cmd == "/thuhoi":
        lead = DB["leads"].get(a.strip("#"))
        if not lead or not lead.get("owner"):
            send(uid, "Khách không có người giữ.")
        else:
            revoke(lead, "quản lý thu hồi", uid)
    elif cmd in ("/dong", "/mo"):
        lead = DB["leads"].get(a.strip("#"))
        if not lead:
            send(uid, "Không có khách này.")
        elif cmd == "/dong":
            if lead.get("owner"):
                purge_msgs(lead, lead["owner"])
            lead.update(status="dong", owner=None, closed_reason="quản lý đóng")
            save_db()
            audit(uid, "dong", lead["id"])
            send(uid, f"Đã đóng khách #{lead['id']}.")
        else:
            lead.update(status="cho_giao", owner=None, rounds=0, excluded=[])
            save_db()
            audit(uid, "mo_lai", lead["id"])
            assign_next(lead)
            send(uid, f"Đã mở lại và chia khách #{lead['id']}.")
    elif cmd in ("/tamdung", "/bat", "/xoasale"):
        sid = sale_by_no(a)
        if not sid:
            send(uid, "Sai số thứ tự sale, xem /sale.")
        else:
            nm = sale_name(sid)
            if cmd == "/xoasale":
                for l in DB["leads"].values():
                    if l.get("owner") == sid and l["status"] not in ("dong",):
                        revoke(l, "sale rời đội", uid)
                DB["sales"][sid]["active"] = False
                DB["order"].remove(sid)
            else:
                DB["sales"][sid]["paused"] = cmd == "/tamdung"
            save_db()
            audit(uid, cmd[1:], "", nm)
            send(uid, f"Đã cập nhật: {esc(nm)}.")
    elif cmd == "/xuat":
        export(uid)
    elif cmd == "/themquanly":
        DB["claim_code"] = str(random.randint(100000, 999999))
        save_db()
        send(uid, f"Người cần thêm làm quản lý nhắn cho bot: <code>/quanly {DB['claim_code']}</code>")
    else:
        return False
    return True


def export(uid):
    buf = io.StringIO()
    w = csv.writer(buf)
    w.writerow(["id", "ngay", "ten", "sdt", "nhu_cau", "ngan_sach", "nguon", "trang_thai", "nguoi_giu", "so_luot", "bao_cao_cuoi"])
    for l in DB["leads"].values():
        last = (l.get("notes") or [{}])[-1]
        w.writerow([l["id"], l["created"], l.get("name"), l["phone"], l.get("need"), l.get("budget"), l.get("source"),
                    STATUS[l["status"]], sale_name(l["owner"]) if l.get("owner") else "", l["rounds"],
                    f"{REPORT_LABEL.get(last.get('code'), '')} {last.get('note', '')}".strip()])
    audit(uid, "xuat_file")
    send_document(uid, f"khach_{now():%Y%m%d}.csv", ("\ufeff" + buf.getvalue()).encode("utf-8"), "Danh sách khách")
    if AUDIT_FILE.exists():
        send_document(uid, f"nhat_ky_{now():%Y%m%d}.csv", AUDIT_FILE.read_bytes(), "Nhật ký thao tác")


# =============================================================== BÁO CÁO
def build_report(days=1, title="", end=None):
    end = end or now()
    since = (end - timedelta(days=days - 1)).replace(hour=0, minute=0, second=0, microsecond=0)
    within = lambda dt: since <= dt <= end  # noqa: E731
    per = {}
    new = hot = closed = mgr = 0
    for l in DB["leads"].values():
        if within(parse(l["created"])):
            new += 1
        for h in l["history"]:
            at = parse(h["at"])
            if not within(at):
                continue
            if h["act"] == "giao":
                per.setdefault(h["who"], {"g": 0, "n": 0, "t": 0, "s": 0.0, "nong": 0})["g"] += 1
            elif h["act"] == "nhan":
                d = per.setdefault(h["who"], {"g": 0, "n": 0, "t": 0, "s": 0.0, "nong": 0})
                d["n"] += 1
                give = next((parse(x["at"]) for x in reversed(l["history"]) if x["act"] == "giao" and x["who"] == h["who"] and parse(x["at"]) <= at), at)
                d["s"] += (at - give).total_seconds()
            elif h["act"] == "thu_hoi" and h.get("from"):
                per.setdefault(h["from"], {"g": 0, "n": 0, "t": 0, "s": 0.0, "nong": 0})["t"] += 1
            elif h["act"] == "ve_quan_ly":
                mgr += 1
        for n in l.get("notes", []):
            if within(parse(n["at"])) and n["code"] == "nong":
                per.setdefault(n["who"], {"g": 0, "n": 0, "t": 0, "s": 0.0, "nong": 0})["nong"] += 1
                hot += 1
            if within(parse(n["at"])) and n["code"] in ("sai_so", "khong_nhu_cau"):
                closed += 1
    rows = []
    for sid, d in sorted(per.items(), key=lambda x: (-x[1]["nong"], x[1]["t"], -x[1]["n"])):
        avg = f"{int(d['s'] / d['n'] / 60)}′" if d["n"] else "-"
        rows.append(f"• {esc(sale_name(sid))}: giao {d['g']} · nhận {d['n']} (TB {avg}) · 🔥 {d['nong']} · ♻️ {d['t']}")
    waiting = sum(1 for l in DB["leads"].values() if l["status"] in ("cho_giao", "ve_quan_ly"))
    return (f"📊 <b>{title}</b>\nKhách mới: {new} · 🔥 nóng: {hot} · ✖️ đóng: {closed} · 🙋 về quản lý: {mgr}"
            f"\nĐang chờ xử lý: {waiting}\n" + ("\n".join(rows) or "Chưa có hoạt động."))


# =============================================================== VÒNG KIỂM TRA HẠN
def tick():
    t = now()
    with LOCK:
        leads = list(DB["leads"].values())
    for l in leads:
        st = l["status"]
        if st == "cho_nhan" and parse(l.get("offer_deadline")) and t >= parse(l["offer_deadline"]):
            revoke(l, f"quá {OFFER_MIN} phút không bấm nhận")
        elif st == "dang_cham" and parse(l.get("report_deadline")) and t >= parse(l["report_deadline"]):
            revoke(l, f"nhận rồi quá {REPORT_MIN // 60} giờ không báo cáo")
        elif st in ("dang_cham", "da_bao_cao") and parse(l.get("hot_deadline")) and t >= parse(l["hot_deadline"]):
            revoke(l, f"quá {HOT_DAYS} ngày chưa xác nhận khách nóng")
        elif st == "cho_giao" and not l.get("owner"):
            assign_next(l)
        # nhắc trước hạn
        elif st == "dang_cham" and not l.get("warned_report") and parse(l.get("report_deadline")) \
                and parse(l["report_deadline"]) - t < timedelta(minutes=20):
            l["warned_report"] = True
            send(l["owner"], f"⏰ Còn dưới 20 phút để báo cáo khách #{l['id']}, nếu không khách sẽ bị thu hồi.")
            save_db()
        elif st in ("dang_cham", "da_bao_cao") and not l.get("warned_hot") and parse(l.get("hot_deadline")) \
                and parse(l["hot_deadline"]) - t < timedelta(hours=12):
            l["warned_hot"] = True
            send(l["owner"], f"⏰ Khách #{l['id']} còn dưới 12 giờ để xác nhận khách nóng, nếu không sẽ thu hồi.")
            save_db()

    today = t.strftime("%Y-%m-%d")
    if (t.hour, t.minute) >= REPORT_HOUR and DB.get("last_daily") != today:
        DB["last_daily"] = today
        save_db()
        y = t - timedelta(days=1)
        rep = build_report(days=1, title=f"Báo cáo ngày {y:%d/%m}", end=y.replace(hour=23, minute=59, second=59))
        notify_admins(rep)
        notify_group(rep)
        if t.weekday() == 0 and DB.get("last_weekly") != today:
            DB["last_weekly"] = today
            save_db()
            wk = build_report(days=7, title="🏆 Xếp hạng tuần", end=y.replace(hour=23, minute=59, second=59))
            notify_admins(wk)
            notify_group(wk)


def ticker():
    while True:
        try:
            tick()
        except Exception as e:
            log("Lỗi kiểm tra hạn:", e)
        time.sleep(30)


# =============================================================== LƯU GOOGLE DRIVE (Google Sheet + file sao lưu)
SYNC_Q = queue.Queue()
_synced = {}


def sheet_post(body):
    body["secret"] = SHEET_SECRET
    req = urllib.request.Request(SHEET_URL, data=json.dumps(body, ensure_ascii=False).encode("utf-8"), method="POST")
    req.add_header("Content-Type", "application/json")
    try:
        with urllib.request.urlopen(req, timeout=60) as r:
            res = json.loads(r.read().decode("utf-8", "replace") or "{}")
        if res.get("ok") is False:
            log("Lỗi Google Sheet:", res)
            return False
        return True
    except Exception as e:
        log("Không gửi được Google Sheet:", e)
        return False


def lead_row(l):
    notes = l.get("notes") or []
    last = notes[-1] if notes else {}
    return {"id": l["id"], "ngay_vao": (l["created"] or "").replace("T", " "), "ten": l.get("name", ""),
            "sdt": l["phone"], "nhu_cau": l.get("need", ""), "ngan_sach": l.get("budget", ""),
            "muc_dich": l.get("purpose", ""), "loi_nhan": l.get("note", ""), "nguon": l.get("source", ""),
            "trang_thai": STATUS.get(l["status"], l["status"]),
            "nguoi_giu": sale_name(l["owner"]) if l.get("owner") else "",
            "so_luot": l.get("rounds", 0),
            "da_qua": ", ".join(sale_name(x) for x in l.get("excluded", [])),
            "bao_cao_cuoi": f"{REPORT_LABEL.get(last.get('code'), 'Ghi chú') if last else ''} {last.get('note', '')}".strip(),
            "luc_bao_cao": (l.get("last_report") or "").replace("T", " "),
            "tat_ca_ghi_chu": "\n".join(f"{(n['at'] or '')[:16].replace('T', ' ')} {sale_name(n['who'])}: "
                                         f"{REPORT_LABEL.get(n['code'], 'Ghi chú')} {n.get('note', '')}".strip() for n in notes)}


def syncer():
    while True:
        time.sleep(60)
        if not SHEET_URL:
            continue
        try:
            with LOCK:
                rows = [lead_row(l) for l in DB["leads"].values()]
            changed = [r for r in rows if _synced.get(r["id"]) != json.dumps(r, ensure_ascii=False, sort_keys=True)]
            for i in range(0, len(changed), 200):
                part = changed[i:i + 200]
                if sheet_post({"loai": "khach", "rows": part}):
                    for r in part:
                        _synced[r["id"]] = json.dumps(r, ensure_ascii=False, sort_keys=True)
            logs = []
            while not SYNC_Q.empty() and len(logs) < 500:
                logs.append(SYNC_Q.get())
            if logs and not sheet_post({"loai": "nhatky", "rows": logs}):
                for r in logs:
                    SYNC_Q.put(r)
            today = now().strftime("%Y-%m-%d")
            if DB.get("last_backup") != today:
                with LOCK:
                    snap = json.dumps(DB, ensure_ascii=False)
                if sheet_post({"loai": "saoluu", "ten": f"chia_khach_{now():%Y%m%d_%H%M}.json", "noi_dung": snap}):
                    DB["last_backup"] = today
                    save_db()
        except Exception as e:
            log("Lỗi đồng bộ Drive:", e)


# =============================================================== WEBHOOK LADIPAGE
FIELD_MAP = {
    "name": ("name", "ho_ten", "hoten", "full_name", "fullname", "ten", "họ và tên"),
    "phone": ("phone", "sdt", "so_dien_thoai", "phone_number", "mobile", "tel", "số điện thoại"),
    "need": ("nhu_cau", "need", "loai_can", "san_pham", "product"),
    "budget": ("ngan_sach", "budget"),
    "purpose": ("muc_dich", "purpose", "so_thich"),
    "note": ("message", "note", "ghi_chu", "loi_nhan", "content"),
    "source": ("source", "nguon", "url", "link", "utm_source", "page"),
}


def flatten(obj, out=None):
    out = {} if out is None else out
    if isinstance(obj, dict):
        for k, v in obj.items():
            if isinstance(v, (dict, list)):
                flatten(v, out)
            else:
                out.setdefault(str(k).strip().lower(), v)
    elif isinstance(obj, list):
        for v in obj:
            if isinstance(v, dict) and "name" in v and "value" in v:   # [{"name":"phone","value":"09..."}]
                out.setdefault(str(v["name"]).strip().lower(), v["value"])
            else:
                flatten(v, out)
    return out


def map_fields(raw):
    flat = flatten(raw)
    data = {}
    for key, names in FIELD_MAP.items():
        for n in names:
            if flat.get(n) not in (None, ""):
                data[key] = str(flat[n])
                break
    if not data.get("phone"):
        for v in flat.values():
            if len(norm_phone(v)) in (10, 11) and norm_phone(v).startswith("0"):
                data["phone"] = str(v)
                break
    extra = {k: v for k, v in flat.items() if k not in sum(FIELD_MAP.values(), ()) and v not in ("", None)}
    if extra and not data.get("note"):
        data["note"] = "; ".join(f"{k}: {v}" for k, v in list(extra.items())[:6])[:400]
    data.setdefault("source", "LadiPage")
    return data


class Hook(BaseHTTPRequestHandler):
    def log_message(self, *a):
        pass

    def _reply(self, code, body):
        self.send_response(code)
        self.send_header("Content-Type", "application/json; charset=utf-8")
        self.send_header("Access-Control-Allow-Origin", "*")
        self.end_headers()
        self.wfile.write(json.dumps(body, ensure_ascii=False).encode("utf-8"))

    def do_GET(self):
        if urlparse(self.path).path == "/health":
            return self._reply(200, {"ok": True})
        self._reply(404, {"ok": False})

    def do_OPTIONS(self):
        self.send_response(204)
        self.send_header("Access-Control-Allow-Origin", "*")
        self.send_header("Access-Control-Allow-Headers", "Content-Type")
        self.end_headers()

    def do_POST(self):
        u = urlparse(self.path)
        if u.path != "/lead" or parse_qs(u.query).get("key", [""])[0] != LEAD_KEY:
            return self._reply(403, {"ok": False})
        n = int(self.headers.get("Content-Length") or 0)
        body = self.rfile.read(min(n, 200_000)).decode("utf-8", "replace")
        try:
            raw = json.loads(body)
        except ValueError:
            raw = {k: v[0] for k, v in parse_qs(body).items()}
        data = map_fields(raw)
        if not data.get("phone"):
            log("Webhook không có SĐT:", body[:200])
            return self._reply(200, {"ok": False, "error": "no phone"})
        threading.Thread(target=create_lead, args=(data,), daemon=True).start()
        self._reply(200, {"ok": True})


# =============================================================== CHẠY
def setup():
    global TG_TOKEN, LEAD_KEY
    if not TG_TOKEN:
        print("\nDán TOKEN bot Telegram (lấy từ @BotFather):")
        TG_TOKEN = input("> ").strip()
    me = tg("getMe")
    if not me.get("ok"):
        print("✘ Token chưa đúng:", me.get("description"))
        sys.exit(1)
    save_env("TG_TOKEN", TG_TOKEN)
    if not LEAD_KEY:
        LEAD_KEY = uuid.uuid4().hex[:20]
        save_env("LEAD_KEY", LEAD_KEY)
    bot_name = me["result"]["username"]
    print(f"✔ Bot: @{bot_name}")
    if not DB["admins"]:
        DB["claim_code"] = str(random.randint(100000, 999999))
        save_db()
        print(f"\n👉 Mở Telegram, nhắn cho @{bot_name} đúng câu:  /quanly {DB['claim_code']}\n")
    print(f"Webhook LadiPage:  http://<địa-chỉ-máy>:{PORT}/lead?key={LEAD_KEY}")
    print("Lưu Google Drive:", "đã bật" if SHEET_URL else "chưa bật (xem HUONG_DAN.md mục 4)")
    print(f"Giờ tính hạn: {WORK_START[0]}:{WORK_START[1]:02d}–{WORK_END[0]}:{WORK_END[1]:02d}\n")


def poll():
    offset = 0
    while True:
        r = tg("getUpdates", {"offset": offset, "timeout": 50,
                              "allowed_updates": ["message", "callback_query"]}, timeout=70)
        if not r.get("ok"):
            time.sleep(5)
            continue
        for u in r["result"]:
            offset = u["update_id"] + 1
            try:
                if "callback_query" in u:
                    on_callback(u["callback_query"])
                elif "message" in u:
                    on_message(u["message"])
            except Exception as e:
                log("Lỗi xử lý:", repr(e))


def main():
    setup()
    threading.Thread(target=ticker, daemon=True).start()
    threading.Thread(target=syncer, daemon=True).start()
    srv = ThreadingHTTPServer(("0.0.0.0", PORT), Hook)
    threading.Thread(target=srv.serve_forever, daemon=True).start()
    log(f"Bot chia khách đang chạy. Cổng webhook {PORT}. Ctrl+C để dừng.")
    try:
        poll()
    except KeyboardInterrupt:
        log("Đã dừng.")


if __name__ == "__main__":
    main()
