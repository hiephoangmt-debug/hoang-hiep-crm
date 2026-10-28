"""Lấy giá các kênh đầu tư mỗi ngày và lưu vào data/*.json để trang index.html vẽ biểu đồ.

Kênh tự động:
  - Vàng miếng SJC (mua/bán, triệu đồng/lượng)    – SJC, dự phòng PNJ / Bảo Tín Minh Châu / DOJI
  - Vàng thế giới (USD/oz), bạc, dầu Brent, S&P 500, lợi suất TP Mỹ 10 năm, USD/VND, Bitcoin – Yahoo Finance
  - Lãi suất liên ngân hàng qua đêm → 9 tháng và doanh số – Ngân hàng Nhà nước (API công khai sbv.gov.vn)
  - Lãi suất Fed: biên độ mục tiêu (trên/dưới) và lãi suất thực tế EFFR – Fed New York (dự phòng: FRED)
  - VN-Index, VN30, HNX-Index, UPCoM và ~30 cổ phiếu lớn             – DNSE (dự phòng: VNDirect)
  - Khối ngoại mua/bán ròng toàn sàn HOSE và từng mã lớn – CafeF
  - Tin tức thị trường: RSS CafeF, Vietstock, VnEconomy, VnExpress (chứng khoán, ngân hàng, BĐS, vàng, vĩ mô)
  - Lãi vay tín chấp / thế chấp (Techcombank, Topi) và vay mua nhà ưu đãi (Smartland) theo ngân hàng
  - Lãi suất tiết kiệm tại quầy / online ~38 ngân hàng – 24hMoney (dự phòng: Người Quan Sát)
Kênh nhập tay (sửa file CSV trong data/):
  - bds.csv       – giá BĐS theo khu vực (triệu đồng/m²)
  - lai_suat.csv  – lãi suất tiết kiệm (%/năm)

Lần chạy đầu tự lấy lùi ~1 năm lịch sử (trừ giá SJC chỉ có từ ngày bắt đầu chạy).
Nguồn nào lỗi thì bỏ qua, giữ số cũ, các nguồn khác vẫn chạy.
"""

from __future__ import annotations

import html
import json
import os
import math
import re
import sys
import time
from datetime import datetime, timedelta, timezone
from pathlib import Path

import requests

VN_TZ = timezone(timedelta(hours=7))
DATA = Path(__file__).parent / "data"
PRICES_FILE = DATA / "prices.json"
STOCKS_FILE = DATA / "stocks.json"
RATES_FILE = DATA / "lai_suat_auto.json"
TICKERS_FILE = DATA / "ma_ck.json"
LOANS_FILE = DATA / "lai_vay_auto.json"
NEWS_FILE = DATA / "tin_tuc.json"
TERMS = ("1", "3", "6", "12", "18", "24", "36")
KEEP_DAYS = 800  # giữ tối đa ~2 năm cho chỉ số / vàng
STOCK_KEEP = 260  # ~1 năm phiên cho từng mã

# Cổ phiếu vốn hoá lớn trên HOSE (gần với rổ VN30). Thêm / bớt mã tuỳ ý.
BIG_STOCKS = {
    "VCB": "Vietcombank", "BID": "BIDV", "CTG": "VietinBank", "TCB": "Techcombank",
    "VPB": "VPBank", "MBB": "MB Bank", "ACB": "ACB", "HDB": "HDBank", "STB": "Sacombank",
    "LPB": "LPBank", "SHB": "SHB", "VIB": "VIB", "TPB": "TPBank", "SSI": "Chứng khoán SSI",
    "VHM": "Vinhomes", "VIC": "Vingroup", "VRE": "Vincom Retail", "BCM": "Becamex",
    "HPG": "Hoà Phát", "FPT": "FPT", "MWG": "Thế Giới Di Động", "VNM": "Vinamilk",
    "MSN": "Masan", "SAB": "Sabeco", "GAS": "PV Gas", "PLX": "Petrolimex",
    "GVR": "Cao su VN", "POW": "PV Power", "VJC": "Vietjet", "BVH": "Bảo Việt",
}

S = requests.Session()
S.headers.update({
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
                  "(KHTML, like Gecko) Chrome/126.0 Safari/537.36",
    "Accept": "application/json, text/plain, */*",
})


def log(*a):
    print(*a, flush=True)


def today() -> str:
    return datetime.now(VN_TZ).strftime("%Y-%m-%d")


def ts_to_date(ts: float) -> str:
    return datetime.fromtimestamp(ts, VN_TZ).strftime("%Y-%m-%d")


def get(url, **kw):
    kw.setdefault("timeout", 25)
    for i in range(3):
        try:
            r = S.get(url, **kw)
            r.raise_for_status()
            return r
        except Exception as e:  # noqa: BLE001
            if i == 2:
                raise
            log(f"   thử lại ({e})")
            time.sleep(2 * (i + 1))


def load(path: Path, default):
    """Đọc JSON. File chưa có -> default. File có mà hỏng -> dừng hẳn, để không ghi đè mất lịch sử."""
    if not path.exists():
        return default
    try:
        return json.loads(path.read_text(encoding="utf-8"))
    except Exception as e:  # noqa: BLE001
        raise SystemExit(f"File {path.name} bị hỏng ({e}) – dừng để giữ lịch sử, cần sửa file trước.")


def save(path: Path, obj):
    """Ghi JSON qua file tạm rồi thay thế, tránh file bị cắt dở."""
    tmp = path.with_suffix(path.suffix + ".tmp")
    tmp.write_text(json.dumps(obj, ensure_ascii=False, separators=(",", ":")), encoding="utf-8")
    os.replace(tmp, path)


def merge(series: dict, key: str, points: dict):
    """Gộp {ngày: giá} vào series[key], bỏ điểm cũ quá KEEP_DAYS."""
    cur = series.setdefault(key, {})
    for d, v in points.items():
        if v is None:
            continue
        cur[d] = round(float(v), 4)
    keys = sorted(cur)[-KEEP_DAYS:]
    series[key] = {k: cur[k] for k in keys}
    return len(points)


def to_num(x):
    if x is None:
        return None
    if isinstance(x, (int, float)):
        return float(x)
    s = re.sub(r"[^\d.,-]", "", str(x))
    if not s:
        return None
    # "120,500" hoặc "120.500" kiểu VN -> bỏ dấu phân cách nghìn
    if s.count(",") + s.count(".") >= 1 and re.fullmatch(r"-?\d{1,3}([.,]\d{3})+", s):
        s = re.sub(r"[.,]", "", s)
    else:
        s = s.replace(",", "")
    try:
        return float(s)
    except ValueError:
        return None


# ---------------------------------------------------------------- Vàng SJC
LUONG_PER_OZ = 37.5 / 31.1034768
SJC_SOURCES = (
    # (tên, phương thức, url, dữ liệu POST)
    ("SJC", "post", "https://sjc.com.vn/GoldPrice/Services/PriceService.ashx",
     {"method": "GetCurrentGoldPricesByBranch", "BranchId": "1"}),
    ("PNJ", "get", "https://edge-api.pnj.io/ecom-frontend/v1/get-gold-price?zone=00", None),
    ("Bảo Tín Minh Châu", "get",
     "http://api.btmc.vn/api/BTMCAPI/getpricebtmc?key=3kd8ub1llcg9t45hnoh8hmn7t5kc2v", None),
    ("DOJI", "get", "http://update.giavang.doji.vn/banggia/doji_92411/92411", None),
)
BUY_KEYS = ("buy", "mua", "pb")
SELL_KEYS = ("sell", "ban", "bán", "ps")
SKIP_WORDS = ("NHẪN", "NỮ TRANG", "TRANG SỨC", "NHAN", "NU TRANG")


def _records(resp_text):
    """Mọi bản ghi (dict) trong JSON, hoặc mọi thẻ XML có thuộc tính."""
    try:
        data = json.loads(resp_text)
    except ValueError:
        return [dict(re.findall(r'([\w@:-]+)="([^"]*)"', attrs))
                for attrs in re.findall(r"<\w+\s([^>]+?)/?>", resp_text)]
    out, stack = [], [data]
    while stack:
        x = stack.pop()
        if isinstance(x, dict):
            out.append(x)
            stack.extend(x.values())
        elif isinstance(x, list):
            stack.extend(x)
    return out[::-1]


def _pick_sjc(records):
    """Dòng vàng miếng SJC: (giá mua, giá bán) ở đơn vị gốc của nguồn."""
    best = None
    for d in records:
        name = " ".join(str(v) for v in d.values() if isinstance(v, str)).upper()
        if "SJC" not in name or any(w in name for w in SKIP_WORDS):
            continue
        buy = sell = None
        for k, v in d.items():
            kl = k.lower()
            n = to_num(v) if not isinstance(v, (dict, list)) else None
            if not n or n <= 0:
                continue
            if buy is None and any(t in kl for t in BUY_KEYS):
                buy = n
            elif sell is None and any(t in kl for t in SELL_KEYS):
                sell = n
        if buy and sell:
            score = ("MIẾNG" in name or "1L" in name or "1 L" in name)
            if best is None or (score and not best[2]):
                best = (buy, sell, score)
    if not best:
        raise ValueError("không thấy dòng vàng miếng SJC")
    return best[0], best[1]


def _to_trieu_luong(v, ref):
    """Đổi giá về triệu đồng/lượng; đơn vị gốc có thể là đồng, nghìn, lượng hay chỉ.
    Chọn cách đổi cho kết quả gần giá vàng thế giới quy đổi (ref) nhất."""
    cands = [v * f for f in (1e-6, 1e-5, 1e-3, 1e-2, 1, 10)]
    if ref:
        c = min(cands, key=lambda x: abs(math.log(x / ref)))
        if 0.7 * ref <= c <= 1.8 * ref:
            return c
        raise ValueError(f"giá {v} không khớp giá thế giới quy đổi {ref:.1f}")
    ok = [c for c in cands if 50 <= c <= 1000]
    if not ok:
        raise ValueError(f"không đổi được đơn vị giá {v}")
    return ok[0]


def fetch_sjc(ref=None):
    """Giá vàng miếng SJC (triệu đồng/lượng). Thử lần lượt SJC, PNJ, BTMC, DOJI."""
    errs = []
    for name, method, url, data in SJC_SOURCES:
        try:
            if method == "post":
                r = S.post(url, data=data, timeout=25, headers={
                    "Referer": "https://sjc.com.vn/", "Origin": "https://sjc.com.vn",
                    "X-Requested-With": "XMLHttpRequest"})
                r.raise_for_status()
            else:
                r = get(url)
            buy, sell = _pick_sjc(_records(r.text))
            # cùng một hệ số cho mua và bán
            sell_t = _to_trieu_luong(sell, ref)
            k = sell_t / sell
            return round(buy * k, 3), round(sell_t, 3), name
        except Exception as e:  # noqa: BLE001
            errs.append(f"{name}: {e}")
            log(f"   {name} lỗi: {e}")
    raise ValueError(" | ".join(errs))


# ---------------------------------------------------------------- Yahoo
def fetch_yahoo(symbol: str, rng: str):
    last = None
    for host in ("query1", "query2"):
        try:
            r = get(f"https://{host}.finance.yahoo.com/v8/finance/chart/{symbol}",
                    params={"range": rng, "interval": "1d"})
            res = r.json()["chart"]["result"][0]
            ts = res["timestamp"]
            closes = res["indicators"]["quote"][0]["close"]
            return {ts_to_date(t): c for t, c in zip(ts, closes) if c is not None}
        except Exception as e:  # noqa: BLE001
            last = e
    raise last


# ---------------------------------------------------------------- Lãi suất Fed
def fetch_nyfed(n: int):
    """Fed New York: lãi suất EFFR mỗi ngày làm việc kèm biên độ mục tiêu.
    Trả (trần, sàn, thực tế) dạng {ngày: %}."""
    r = get(f"https://markets.newyorkfed.org/api/rates/unsecured/effr/last/{n}.json", timeout=40)
    up, lo, ef = {}, {}, {}
    for row in r.json().get("refRates") or []:
        d = row.get("effectiveDate")
        if not d:
            continue
        if row.get("targetRateTo") is not None:
            up[d] = float(row["targetRateTo"])
        if row.get("targetRateFrom") is not None:
            lo[d] = float(row["targetRateFrom"])
        if row.get("percentRate") is not None:
            ef[d] = float(row["percentRate"])
    if not up:
        raise ValueError("Fed New York rỗng")
    return up, lo, ef


def fetch_fred(series_id: str, days: int):
    """Chuỗi số liệu FRED (Fed St. Louis) dạng CSV, không cần khoá API. {ngày: giá trị}."""
    start = (datetime.now(VN_TZ) - timedelta(days=days)).strftime("%Y-%m-%d")
    r = get("https://fred.stlouisfed.org/graph/fredgraph.csv", params={"id": series_id, "cosd": start}, timeout=60)
    out = {}
    for line in r.text.strip().splitlines()[1:]:
        parts = line.split(",")
        if len(parts) >= 2 and re.fullmatch(r"\d{4}-\d{2}-\d{2}", parts[0]):
            v = to_num(parts[1])
            if v is not None:
                out[parts[0]] = v
    if not out:
        raise ValueError(f"FRED rỗng cho {series_id}")
    return out


# ---------------------------------------------------------------- Vietcombank (dự phòng USD)
def fetch_vcb_usd():
    r = get("https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx")
    m = re.search(r'CurrencyCode="USD"[^>]*Sell="([\d.,]+)"', r.text)
    if not m:
        raise ValueError("không thấy USD trong XML VCB")
    return {today(): to_num(m.group(1))}


# ---------------------------------------------------------------- DNSE / VNDirect
def fetch_dnse(kind: str, symbol: str, days: int):
    now = int(time.time())
    r = get(f"https://services.entrade.com.vn/chart-api/v2/ohlcs/{kind}",
            params={"from": now - days * 86400, "to": now + 86400,
                    "symbol": symbol, "resolution": "1D"})
    j = r.json()
    out = {}
    for t, c, v in zip(j.get("t") or [], j.get("c") or [], j.get("v") or [0] * len(j.get("t") or [])):
        if c is not None:
            out[ts_to_date(t)] = (float(c), float(v or 0))
    if not out:
        raise ValueError(f"DNSE rỗng cho {symbol}")
    return out


def fetch_vndirect(symbol: str, days: int, index=False):
    start = (datetime.now(VN_TZ) - timedelta(days=days)).strftime("%Y-%m-%d")
    path = "vnmarket_prices" if index else "stock_prices"
    r = get(f"https://api-finfo.vndirect.com.vn/v4/{path}",
            params={"sort": "date", "q": f"code:{symbol}~date:gte:{start}", "size": 1000})
    out = {}
    for row in r.json().get("data") or []:
        c = row.get("close")
        if c is not None:
            out[row["date"][:10]] = (float(c), float(row.get("nmVolume") or row.get("accumulatedVol") or 0))
    if not out:
        raise ValueError(f"VNDirect rỗng cho {symbol}")
    return out


def fetch_ohlc(kind: str, symbol: str, days: int):
    try:
        data = fetch_dnse(kind, symbol, days)
    except Exception as e:  # noqa: BLE001
        log(f"   DNSE lỗi {symbol}: {e} -> thử VNDirect")
        return fetch_vndirect(symbol, days, index=(kind == "index"))
    # DNSE chỉ có nến ngày sau khi hết phiên -> lấy giá đang khớp hôm nay từ VNDirect
    if today() not in data:
        try:
            live = fetch_vndirect(symbol, 5, index=(kind == "index"))
            for d, v in live.items():
                if d not in data:
                    data[d] = v
        except Exception as e:  # noqa: BLE001
            log(f"   không lấy được giá trong phiên {symbol}: {e}")
    return data


# ---------------------------------------------------------------- CafeF khối ngoại
CAFEF_URLS = (
    "https://cafef.vn/du-lieu/Ajax/PageNew/DataHistory/GDKhoiNgoai.ashx",
    "https://s.cafef.vn/Ajax/PageNew/DataHistory/GDKhoiNgoai.ashx",
)


def _scale(rows):
    """Hệ số chia để đổi giá trị giao dịch CafeF ra tỷ đồng.

    Không biết chắc CafeF trả đồng, triệu hay tỷ, nên suy ra từ chính dữ liệu:
    giá trị mua / khối lượng mua phải ra giá 1 cổ phiếu cỡ vài chục nghìn đồng.
    Chọn đơn vị (1, 1e3, 1e6, 1e9 đồng) cho kết quả gần 30.000 đ/cp nhất.
    """
    ratios = []
    for r in rows:
        gt, kl = to_num(r.get("GtMua")), to_num(r.get("KLMua"))
        if gt and kl and gt > 0 and kl > 0:
            ratios.append(gt / kl)
    if ratios:
        ratios.sort()
        mid = ratios[len(ratios) // 2]
        unit = min((1.0, 1e3, 1e6, 1e9), key=lambda u: abs(math.log10(mid * u / 30000)))
        return 1e9 / unit
    # Không có khối lượng: đoán theo độ lớn
    mx = max([abs(to_num(r.get(k)) or 0) for r in rows for k in ("GtMua", "GtBan", "GTDGRong")] or [0])
    return 1e9 if mx >= 1e8 else 1e3 if mx >= 1e5 else 1.0


def fetch_foreign(symbol: str, pages: int = 1, size: int = 20):
    last = None
    for base in CAFEF_URLS:
        try:
            out = {}
            for p in range(1, pages + 1):
                r = get(base, params={"Symbol": symbol, "StartDate": "", "EndDate": "",
                                      "PageIndex": p, "PageSize": size})
                data = r.json().get("Data") or {}
                rows = data.get("Data") if isinstance(data, dict) else data
                if not rows:
                    break
                k = _scale(rows)
                ty = lambda v: None if to_num(v) is None else to_num(v) / k  # noqa: E731
                for row in rows:
                    d = row.get("Ngay") or row.get("Date")
                    if not d:
                        continue
                    try:
                        if re.match(r"\d{4}-\d{2}-\d{2}", d):
                            key = d[:10]
                        else:
                            dd, mm, yy = re.split(r"[/-]", d)[:3]
                            key = f"{yy[:4]}-{int(mm):02d}-{int(dd):02d}"
                    except ValueError:
                        continue
                    buy, sell = ty(row.get("GtMua")), ty(row.get("GtBan"))
                    net = ty(row.get("GTDGRong"))
                    if net is None and buy is not None and sell is not None:
                        net = buy - sell
                    out[key] = {"mua": buy, "ban": sell, "rong": net}
                if len(rows) < size:
                    break
            if out:
                return out
        except Exception as e:  # noqa: BLE001
            last = e
    raise last or ValueError("CafeF rỗng")


# ---------------------------------------------------------------- Liên ngân hàng (NHNN)
LNH_KEYS = {"qua đêm": "lnh_on", "1 tuần": "lnh_1w", "2 tuần": "lnh_2w", "1 tháng": "lnh_1m",
            "3 tháng": "lnh_3m", "6 tháng": "lnh_6m", "9 tháng": "lnh_9m"}


def fetch_interbank(pages: int):
    """Lãi suất bình quân liên ngân hàng NHNN công bố mỗi ngày làm việc.
    Trả {khoá chuỗi: {ngày: %}}, thêm 'lnh_on_ds' = doanh số qua đêm (tỷ đồng)."""
    out = {}
    base = "https://sbv.gov.vn/o/headless-delivery/v1.0/content-structures/3450260/structured-contents"
    for page in range(1, pages + 1):
        if page > 1:
            time.sleep(3)  # NHNN chặn khi gọi dồn dập
        try:
            r = get(base, params={"pageSize": 100, "page": page, "sort": "datePublished:desc"},
                    headers={"Accept": "application/json"}, timeout=40)
            d = r.json()
        except Exception as e:  # noqa: BLE001
            if page == 1:
                raise
            log(f"   trang {page} lỗi ({e}) – giữ {page - 1} trang đã lấy")
            break
        for it in d.get("items") or []:
            fields = it.get("contentFields") or []
            raw = next((f.get("contentFieldValue", {}).get("data") for f in fields if f.get("name") == "ngayApDung"), None)
            if not raw:
                continue
            # NHNN lưu nửa đêm giờ VN dạng UTC (17:00 hôm trước) -> đổi về ngày VN
            day = datetime.fromisoformat(raw.replace("Z", "+00:00")).astimezone(VN_TZ).strftime("%Y-%m-%d")
            for f in fields:
                if f.get("name") != "laiSuatThiTruongNganHangs":
                    continue
                sub = {n.get("name"): (n.get("contentFieldValue") or {}).get("data") for n in f.get("nestedContentFields") or []}
                key = LNH_KEYS.get((sub.get("thoihan") or "").strip().lower())
                if not key:
                    continue
                try:
                    out.setdefault(key, {})[day] = float(str(sub.get("laiSuatBQLienNganHang")).replace(",", "."))
                except (TypeError, ValueError):
                    continue
                if key == "lnh_on":
                    try:
                        out.setdefault("lnh_on_ds", {})[day] = float(str(sub.get("doanhSo")).replace(".", "").replace(",", "."))
                    except (TypeError, ValueError):
                        pass
        if d.get("lastPage", 1) <= page:
            break
    if not out.get("lnh_on"):
        raise ValueError("NHNN không trả lãi suất liên ngân hàng")
    return out


# ---------------------------------------------------------------- Lãi suất tiết kiệm
def _html_cells(row_html):
    out = []
    for c in re.findall(r"<t[hd][^>]*>(.*?)</t[hd]>", row_html, flags=re.S):
        out.append(re.sub(r"\s+", " ", html.unescape(re.sub(r"<[^>]+>", " ", c))).strip())
    return out


def _rate_tables(page):
    """[(tiêu đề trước bảng, [hàng ô])] cho mọi bảng có cột 'x tháng'."""
    out = []
    for m in re.finditer(r"<table.*?</table>", page, flags=re.S):
        rows = [_html_cells(r) for r in re.findall(r"<tr.*?</tr>", m.group(0), flags=re.S)]
        rows = [r for r in rows if r]
        if not rows or not any(re.search(r"\d+\s*tháng", c) for c in rows[0]):
            continue
        before = re.sub(r"<[^>]+>", " ", page[max(0, m.start() - 2500):m.start()])
        out.append((html.unescape(re.sub(r"\s+", " ", before))[-400:], rows))
    return out


def _parse_rate_rows(rows):
    head = rows[0]
    cols = {}
    for i, c in enumerate(head):
        mm = re.search(r"(\d+)\s*tháng", c)
        if mm:
            cols[i] = int(mm.group(1))
    banks = {}
    for r in rows[1:]:
        if len(r) < 2 or not r[0] or r[0] == head[0]:
            continue
        vals = {}
        for i, k in cols.items():
            if i < len(r):
                v = to_num(r[i])
                if v is not None and 0 < v < 20:
                    vals[str(k)] = v
        if vals:
            banks[r[0]] = vals
    return banks


def fetch_rates():
    """Lãi suất tiền gửi VND cá nhân: {'Tại quầy': {ngân hàng: {kỳ hạn: %}}, 'Online': {...}}."""
    errs = []
    # 1) 24hMoney – có 2 bảng tại quầy / online, kỳ hạn 1–36 tháng
    try:
        page = get("https://24hmoney.vn/lai-suat-gui-ngan-hang").text
        res = {}
        for before, rows in _rate_tables(page):
            low = before.lower()
            # loại bảng = từ khoá xuất hiện gần bảng nhất
            pq, po = low.rfind("quầy"), max(low.rfind("trực tuyến"), low.rfind("online"))
            kind = "Online" if po > pq else "Tại quầy" if pq >= 0 else None
            if kind and kind not in res:
                res[kind] = _parse_rate_rows(rows)
        upd = re.search(r"Cập nhật lúc:?\s*([\d:]+\s+\d{1,2}/\d{1,2}/\d{4})", page)
        if sum(len(v) for v in res.values()) >= 4:
            return res, "24hMoney", upd.group(1) if upd else None
        errs.append("24hMoney: không đọc được bảng")
    except Exception as e:  # noqa: BLE001
        errs.append(f"24hMoney: {e}")
    # 2) Người Quan Sát – 1 bảng (1, 6, 12 tháng), không tách tại quầy / online
    try:
        page = get("https://dulieu.nguoiquansat.vn/lai-suat").text
        tabs = _rate_tables(page)
        if tabs:
            upd = re.search(r"Cập nhật lúc:?\s*([\d:]+\s+\d{1,2}/\d{1,2}/\d{4})", page)
            return {"Tổng hợp": _parse_rate_rows(tabs[0][1])}, "Người Quan Sát", upd.group(1) if upd else None
        errs.append("Người Quan Sát: không thấy bảng")
    except Exception as e:  # noqa: BLE001
        errs.append(f"Người Quan Sát: {e}")
    raise ValueError(" | ".join(errs))


# ---------------------------------------------------------------- Lãi vay (bảng tổng hợp)
BANK_ALIAS = {"mb": "MB", "mbbank": "MB", "bidv": "BIDV", "vietinbank": "VietinBank", "vietcombank": "Vietcombank",
              "agribank": "Agribank", "techcombank": "Techcombank", "vpbank": "VPBank", "acb": "ACB",
              "sacombank": "Sacombank", "tpbank": "TPBank", "vib": "VIB", "hdbank": "HDBank", "shb": "SHB",
              "ocb": "OCB", "msb": "MSB", "seabank": "SeABank", "banviet": "BVBank", "bvbank": "BVBank",
              "lpbank": "LPBank", "eximbank": "Eximbank", "namabank": "Nam A Bank", "shinhanbank": "Shinhan Bank",
              "shinhan": "Shinhan Bank", "uob": "UOB", "hsbc": "HSBC", "standardchartered": "Standard Chartered",
              "woori": "Woori Bank", "wooribank": "Woori Bank", "abbank": "ABBank", "pvcombank": "PVcomBank"}


def bank_name(raw):
    import unicodedata
    t = unicodedata.normalize("NFD", raw).encode("ascii", "ignore").decode().lower()
    t = re.sub(r"\(.*?\)", "", t)
    key = re.sub(r"[^a-z0-9]", "", t)
    return BANK_ALIAS.get(key) or BANK_ALIAS.get(key.replace("bank", "")) or raw.strip()


def parse_rate_cell(cell):
    """'Từ 12.9' / '14.9 - 20.5' / '8,0% (6 tháng); 8,5% (12 tháng)' / '10,0% cố định 36 tháng'
    -> {tu, den, ky: {tháng: %}}. Số đứng trước 'tháng/năm/ngày…' là thời hạn, không phải lãi suất."""
    out = {"tu": None, "den": None, "ky": {}}
    num = r"(\d+(?:[.,]\d+)?)"
    f = lambda x: float(x.replace(",", "."))  # noqa: E731
    nums = []
    for m in re.finditer(num + r"(?:\s*[–-]\s*" + num + r")?", cell):
        if re.match(r"\s*(tháng|năm|th\b|ngày|tuần|tỷ|triệu|lần)", cell[m.end():m.end() + 10], re.I):
            continue
        a, b = f(m.group(1)), (f(m.group(2)) if m.group(2) else None)
        if not (2 <= a <= 40):
            continue
        nums += [a] + ([b] if b is not None and 2 <= b <= 40 else [])
    # kỳ cố định: '8,0% (6 tháng)', '10,0% cố định 36 tháng', 'cố định 3 năm 8,5%'
    for m in re.finditer(num + r"(?:\s*[–-]\s*\d+(?:[.,]\d+)?)?\s*%[^;%\d]{0,25}(\d+)\s*(tháng|năm)", cell, re.I):
        months = int(m.group(2)) * (12 if m.group(3).lower() == "năm" else 1)
        if 2 <= f(m.group(1)) <= 40:
            out["ky"].setdefault(str(months), f(m.group(1)))
    for m in re.finditer(r"(\d+)\s*(tháng|năm)[^;%\d]{0,20}" + num + r"\s*%", cell, re.I):
        months = int(m.group(1)) * (12 if m.group(2).lower() == "năm" else 1)
        if 2 <= f(m.group(3)) <= 40:
            out["ky"].setdefault(str(months), f(m.group(3)))
    if nums:
        out["tu"], out["den"] = min(nums), (max(nums) if len(nums) > 1 else None)
    return out


def fetch_loans():
    """Bảng lãi vay theo ngân hàng từ các trang tổng hợp (cập nhật hằng ngày/tháng).
    Trả {'bang': {loại: {ngân hàng: {nguồn: {tu, den, ky, raw}}}}, 'nguon': [...]}"""
    bang, used, errs = {}, [], []

    def add(kind, bank, src, cell):
        v = parse_rate_cell(cell)
        if v["tu"] is None:
            return
        v["raw"] = cell[:80]
        bang.setdefault(kind, {}).setdefault(bank_name(bank), {})[src] = v

    def tables(url):
        page = get(url).text
        return [[_html_cells(r) for r in re.findall(r"<tr.*?</tr>", t, flags=re.S)]
                for t in re.findall(r"<table.*?</table>", page, flags=re.S)]

    # 1) Techcombank & 2) Topi: cột 'tín chấp' / 'thế chấp'
    for src, url in (("Techcombank", "https://techcombank.com/thong-tin/blog/lai-suat-vay-ngan-hang"),
                     ("Topi", "https://topi.vn/so-sanh-lai-suat-vay-ngan-hang.html")):
        try:
            n = 0
            for rows in tables(url):
                rows = [r for r in rows if r]
                if not rows:
                    continue
                head = [h.lower() for h in rows[0]]
                ci = next((i for i, h in enumerate(head) if "tín chấp" in h), None)
                cm = next((i for i, h in enumerate(head) if "thế chấp" in h), None)
                if ci is None and cm is None:
                    continue
                for r in rows[1:]:
                    if len(r) < 2 or not r[0]:
                        continue
                    if ci is not None and ci < len(r):
                        add("Tín chấp", r[0], src, r[ci])
                    if cm is not None and cm < len(r):
                        add("Thế chấp", r[0], src, r[cm])
                    n += 1
            if n:
                used.append(src)
            else:
                errs.append(f"{src}: không thấy bảng")
        except Exception as e:  # noqa: BLE001
            errs.append(f"{src}: {e}")
    # 3) Smartland: vay mua nhà – lãi ưu đãi theo kỳ cố định
    try:
        n = 0
        for rows in tables("https://smartland.vn/lai-suat-vay-mua-nha-2026/"):
            rows = [r for r in rows if r]
            if rows and any("ưu đãi" in h.lower() for h in rows[0]):
                for r in rows[1:]:
                    if len(r) >= 2 and r[0]:
                        add("Mua nhà ưu đãi", r[0], "Smartland", r[1])
                        n += 1
        if n:
            used.append("Smartland")
    except Exception as e:  # noqa: BLE001
        errs.append(f"Smartland: {e}")
    if not bang:
        raise ValueError(" | ".join(errs) or "không có bảng lãi vay")
    for e in errs:
        log("   " + e)
    return {"bang": bang, "nguon": used}


# ---------------------------------------------------------------- Tin tức thị trường (RSS)
NEWS_FEEDS = (
    ("Chứng khoán", "CafeF", "https://cafef.vn/thi-truong-chung-khoan.rss"),
    ("Chứng khoán", "Vietstock", "https://vietstock.vn/830/chung-khoan/co-phieu.rss"),
    ("Chứng khoán", "VnEconomy", "https://vneconomy.vn/chung-khoan.rss"),
    ("Ngân hàng – lãi suất", "CafeF", "https://cafef.vn/tai-chinh-ngan-hang.rss"),
    ("Ngân hàng – lãi suất", "VnEconomy", "https://vneconomy.vn/tai-chinh.rss"),
    ("Bất động sản", "CafeF", "https://cafef.vn/bat-dong-san.rss"),
    ("Bất động sản", "VnExpress", "https://vnexpress.net/rss/bat-dong-san.rss"),
    ("Vàng – hàng hoá", "Vietstock", "https://vietstock.vn/759/hang-hoa/vang-va-kim-loai-quy.rss"),
    ("Vàng – hàng hoá", "CafeF", "https://cafef.vn/thi-truong.rss"),
    ("Vĩ mô", "CafeF", "https://cafef.vn/vi-mo-dau-tu.rss"),
    ("Vĩ mô", "VnExpress", "https://vnexpress.net/rss/kinh-doanh.rss"),
)
NEWS_KEEP_DAYS = 7


def _xml_text(x):
    x = re.sub(r"<!\[CDATA\[(.*?)\]\]>", r"\1", x or "", flags=re.S)
    x = html.unescape(re.sub(r"<[^>]+>", " ", html.unescape(x)))
    return re.sub(r"\s+", " ", x).strip()


def fetch_news():
    """Tin mới từ RSS các báo kinh tế. Trả danh sách {t, l, s, c, d, m} (tiêu đề, link, nguồn, nhóm, giờ ISO, tóm tắt)."""
    from email.utils import parsedate_to_datetime
    out, errs = [], []
    for cat, src, url in NEWS_FEEDS:
        try:
            xml = get(url, timeout=20).text
            for it in re.findall(r"<item\b.*?</item>", xml, flags=re.S):
                tag = lambda n: (re.search(rf"<{n}\b[^>]*>(.*?)</{n}>", it, flags=re.S) or [None, ""])[1]  # noqa: E731
                title, link = _xml_text(tag("title")), _xml_text(tag("link")) or _xml_text(tag("guid"))
                if not title or not link.startswith("http"):
                    continue
                try:
                    d = parsedate_to_datetime(_xml_text(tag("pubDate"))).astimezone(VN_TZ)
                except Exception:  # noqa: BLE001
                    continue
                desc = _xml_text(tag("description"))[:220]
                out.append({"t": title, "l": link, "s": src, "c": cat, "d": d.isoformat(timespec="minutes"), "m": desc})
        except Exception as e:  # noqa: BLE001
            errs.append(f"{src} {cat}: {e}")
    for e in errs:
        log("   " + e)
    if not out:
        raise ValueError(" | ".join(errs) or "không có tin")
    return out


# ---------------------------------------------------------------- main
def main():
    DATA.mkdir(exist_ok=True)
    prices = load(PRICES_FILE, {"series": {}})
    series = prices.setdefault("series", {})
    errors = []

    sources = prices.setdefault("sources", {})

    def step(name, fn):
        log(f"• {name}")
        try:
            fn()
            if not name.startswith("Mã "):
                sources[name] = datetime.now(VN_TZ).isoformat(timespec="minutes")
        except Exception as e:  # noqa: BLE001
            errors.append(f"{name}: {e}")
            log(f"   LỖI: {e}")

    first = lambda key: len(series.get(key, {})) < 30  # noqa: E731

    def sjc():
        ref = None
        g, u = series.get("vang_tg", {}), series.get("usd_vnd", {})
        if g and u:
            ref = g[max(g)] * u[max(u)] * LUONG_PER_OZ / 1e6
        buy, sell, src = fetch_sjc(ref)
        merge(series, "sjc_mua", {today(): buy})
        merge(series, "sjc_ban", {today(): sell})
        prices["sjc_nguon"] = src
        log(f"   SJC mua {buy} / bán {sell} triệu/lượng (nguồn {src})")

    def yahoo(key, sym):
        def run():
            n = merge(series, key, fetch_yahoo(sym, "2y" if first(key) else "1mo"))
            log(f"   {n} điểm")
        return run

    def usd():
        try:
            yahoo("usd_vnd", "VND=X")()
        except Exception as e:  # noqa: BLE001
            log(f"   Yahoo lỗi ({e}) -> Vietcombank")
            merge(series, "usd_vnd", fetch_vcb_usd())

    def index(key, sym):
        def run():
            data = fetch_ohlc("index", sym, 760 if first(key) else 40)
            merge(series, key, {d: c for d, (c, _) in data.items()})
            log(f"   {len(data)} phiên")
        return run

    def foreign():
        data = fetch_foreign("VNINDEX", pages=15 if first("kn_rong") else 1)
        merge(series, "kn_mua", {d: v["mua"] for d, v in data.items()})
        merge(series, "kn_ban", {d: v["ban"] for d, v in data.items()})
        merge(series, "kn_rong", {d: v["rong"] for d, v in data.items()})
        log(f"   {len(data)} phiên khối ngoại")

    step("Vàng thế giới", yahoo("vang_tg", "GC=F"))
    step("USD/VND", usd)
    step("Vàng SJC", sjc)  # sau vàng thế giới + USD để kiểm tra đơn vị
    step("Bitcoin", yahoo("btc", "BTC-USD"))
    step("Bạc", yahoo("bac", "SI=F"))
    step("Dầu Brent", yahoo("dau", "BZ=F"))
    step("S&P 500", yahoo("sp500", "^GSPC"))
    def us10y():
        pts_ = fetch_yahoo("^TNX", "2y" if first("us10y") else "1mo")
        # Yahoo từng trả ^TNX nhân 10 (42,5 = 4,25%) -> quy về %
        pts_ = {d: (v / 10 if v > 20 else v) for d, v in pts_.items()}
        log(f"   {merge(series, 'us10y', pts_)} điểm")
    step("Lợi suất TP Mỹ 10 năm", us10y)

    def fed():
        try:
            up, lo, ef = fetch_nyfed(550 if first("fed_tren") else 30)
            merge(series, "fed_tren", up)
            merge(series, "fed_duoi", lo)
            merge(series, "fed_thuc", ef)
            log(f"   Fed New York: {len(up)} ngày")
        except Exception as e:  # noqa: BLE001
            log(f"   Fed New York lỗi ({e}) -> thử FRED")
            days = 800 if first("fed_tren") else 60
            for key, sid in (("fed_tren", "DFEDTARU"), ("fed_duoi", "DFEDTARL"), ("fed_thuc", "DFF")):
                log(f"   {sid}: {merge(series, key, fetch_fred(sid, days))} điểm")
    step("Lãi suất Fed", fed)

    def lien_ngan_hang():
        data = fetch_interbank(4 if first("lnh_on") else 1)
        for key, pts_ in data.items():
            merge(series, key, pts_)
        last = max(data["lnh_on"])
        log(f"   {len(data['lnh_on'])} ngày, qua đêm {data['lnh_on'][last]}% ({last})")
    step("Liên ngân hàng", lien_ngan_hang)
    step("VN-Index", index("vnindex", "VNINDEX"))
    step("VN30", index("vn30", "VN30"))
    step("HNX-Index", index("hnx", "HNX"))
    step("UPCoM", index("upcom", "UPCOM"))
    step("Khối ngoại HOSE", foreign)

    rates = load(RATES_FILE, {})

    def lai_suat():
        res, src, upd = fetch_rates()
        rates.update({"nguon": src, "nguon_cap_nhat": upd, "ngay": today(), "bang": res})
        # lịch sử lãi suất 12 tháng từng ngân hàng, mỗi ngày 1 điểm
        hist = rates.setdefault("lich_su_12t", {})
        for kind, banks in res.items():
            for bank, v in banks.items():
                if "12" in v:
                    h = hist.setdefault(f"{kind}|{bank}", {})
                    h[today()] = v["12"]
                    for d in sorted(h)[:-KEEP_DAYS]:
                        del h[d]
        # lịch sử đủ kỳ hạn: {loại|ngân hàng: {ngày: [1T, 3T, 6T, 12T, 18T, 24T, 36T]}}
        full = rates.setdefault("lich_su", {})
        for kind, banks in res.items():
            for bank, v in banks.items():
                h = full.setdefault(f"{kind}|{bank}", {})
                h[today()] = [v.get(t) for t in TERMS]
                for d in sorted(h)[:-KEEP_DAYS]:
                    del h[d]
        log(f"   {src}: " + ", ".join(f"{k} {len(v)} ngân hàng" for k, v in res.items()))

    step("Lãi suất", lai_suat)

    loans = load(LOANS_FILE, {})

    def lai_vay():
        res = fetch_loans()
        loans["ngay"] = today()
        # nguồn nào hôm nay lỗi thì giữ số lần trước của nguồn đó (đánh dấu 'cu')
        for kind, banks in (loans.get("bang") or {}).items():
            for bank, by in banks.items():
                for src, v in by.items():
                    if src not in res["nguon"]:
                        res["bang"].setdefault(kind, {}).setdefault(bank, {})[src] = {**v, "cu": True}
        loans["bang"] = res["bang"]
        loans["nguon"] = res["nguon"]
        # lịch sử mức thấp nhất mỗi ngày: {loại|ngân hàng|nguồn: {ngày: từ}}
        hist = loans.setdefault("lich_su", {})
        for kind, banks in res["bang"].items():
            for bank, by_src in banks.items():
                for src, v in by_src.items():
                    if v.get("tu") is None:
                        continue
                    h = hist.setdefault(f"{kind}|{bank}|{src}", {})
                    h[today()] = v["tu"]
                    for d in sorted(h)[:-KEEP_DAYS]:
                        del h[d]
        log("   " + ", ".join(f"{k}: {len(v)} ngân hàng" for k, v in res["bang"].items()) + f" ({', '.join(res['nguon'])})")

    step("Lãi vay", lai_vay)

    news = load(NEWS_FILE, {"items": []})

    def tin_tuc():
        fresh = fetch_news()
        # gộp với tin đã lưu, bỏ trùng theo link / tiêu đề, giữ 7 ngày gần nhất
        cutoff = (datetime.now(VN_TZ) - timedelta(days=NEWS_KEEP_DAYS)).isoformat()
        seen, items = set(), []
        for it in sorted(fresh + news.get("items", []), key=lambda x: x["d"], reverse=True):
            k1, k2 = it["l"].split("?")[0], re.sub(r"\W+", "", it["t"].lower())[:80]
            if it["d"] < cutoff or k1 in seen or k2 in seen:
                continue
            seen.update((k1, k2))
            items.append(it)
        news["items"] = items[:400]
        news["updated"] = datetime.now(VN_TZ).isoformat(timespec="minutes")
        log(f"   {len(fresh)} tin mới đọc, lưu {len(news['items'])} tin")

    step("Tin tức", tin_tuc)

    def ds_ma():
        # danh sách mã cho ô tra cứu – mỗi ngày lấy 1 lần
        old = load(TICKERS_FILE, {})
        if old.get("ngay") == today() and old.get("ma"):
            log("   đã có danh sách hôm nay")
            return
        r = get("https://api-finfo.vndirect.com.vn/v4/stocks",
                params={"q": "type:STOCK~status:LISTED", "fields": "code,companyName,floor", "size": 5000})
        rows = [[x["code"], (x.get("companyName") or "").strip(), x.get("floor") or ""]
                for x in r.json().get("data") or [] if x.get("code")]
        if len(rows) < 500:
            raise ValueError(f"danh sách mã quá ít ({len(rows)})")
        rows.sort()
        save(TICKERS_FILE, {"ngay": today(), "ma": rows})
        log(f"   {len(rows)} mã")
    step("Danh sách mã", ds_ma)

    # ---- cổ phiếu lớn
    stocks = load(STOCKS_FILE, {"symbols": {}})
    syms = stocks.setdefault("symbols", {})
    for code, name in BIG_STOCKS.items():
        def run(code=code, name=name):
            item = syms.setdefault(code, {})
            item["name"] = name
            hist = {r[0]: r for r in item.get("closes", [])}
            full = len(hist) < 30 or datetime.now(VN_TZ).hour >= 18
            data = fetch_ohlc("stock", code, 400 if full else 20)
            if full and len(data) >= 30:
                hist = {}  # thay toàn bộ để giá cũ cùng kiểu điều chỉnh với giá mới
            for d, (c, v) in data.items():
                hist[d] = [d, round(c, 3), int(v)]
            item["closes"] = [hist[k] for k in sorted(hist)][-STOCK_KEEP:]
            try:
                fr = fetch_foreign(code, pages=1, size=20)
                kn = dict(item.get("kn", {}))
                for d, v in fr.items():
                    if v["rong"] is not None:
                        kn[d] = round(v["rong"], 3)
                item["kn"] = {k: kn[k] for k in sorted(kn)[-60:]}
            except Exception as e:  # noqa: BLE001
                log(f"   khối ngoại {code} lỗi: {e}")
            time.sleep(0.3)
        step(f"Mã {code}", run)
    # bỏ mã đã xoá khỏi danh sách
    for code in list(syms):
        if code not in BIG_STOCKS:
            del syms[code]

    now = datetime.now(VN_TZ).isoformat(timespec="minutes")
    prices["updated"] = now
    prices["errors"] = errors
    stocks["updated"] = now
    save(PRICES_FILE, prices)
    if news.get("items"):
        save(NEWS_FILE, news)
    if loans:
        save(LOANS_FILE, loans)
    if rates:
        save(RATES_FILE, rates)
    save(STOCKS_FILE, stocks)
    log(f"\nXong. {len(errors)} nguồn lỗi.")
    for e in errors:
        log("  -", e)
    # Chỉ báo lỗi (đỏ) khi TẤT CẢ nguồn chính đều hỏng
    main_keys = ["vnindex", "vang_tg", "usd_vnd"]
    if all(not series.get(k) for k in main_keys):
        sys.exit(1)


if __name__ == "__main__":
    main()
