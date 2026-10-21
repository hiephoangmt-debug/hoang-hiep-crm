"""Lấy giá các kênh đầu tư mỗi ngày và lưu vào data/*.json để trang index.html vẽ biểu đồ.

Kênh tự động:
  - Vàng SJC (mua/bán, triệu đồng/lượng)          – sjc.com.vn
  - Vàng thế giới (USD/oz), bạc, dầu Brent, S&P 500, USD/VND, Bitcoin – Yahoo Finance
  - VN-Index, VN30, HNX-Index, UPCoM và ~30 cổ phiếu lớn             – DNSE (dự phòng: VNDirect)
  - Khối ngoại mua/bán ròng toàn sàn HOSE và từng mã lớn – CafeF
Kênh nhập tay (sửa file CSV trong data/):
  - bds.csv       – giá BĐS theo khu vực (triệu đồng/m²)
  - lai_suat.csv  – lãi suất tiết kiệm (%/năm)

Lần chạy đầu tự lấy lùi ~1 năm lịch sử (trừ giá SJC chỉ có từ ngày bắt đầu chạy).
Nguồn nào lỗi thì bỏ qua, giữ số cũ, các nguồn khác vẫn chạy.
"""

from __future__ import annotations

import json
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
    try:
        return json.loads(path.read_text(encoding="utf-8"))
    except Exception:  # noqa: BLE001
        return default


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
def fetch_sjc():
    r = S.post(
        "https://sjc.com.vn/GoldPrice/Services/PriceService.ashx",
        data={"method": "GetCurrentGoldPricesByBranch", "BranchId": "1"},
        headers={"Referer": "https://sjc.com.vn/", "Origin": "https://sjc.com.vn",
                 "X-Requested-With": "XMLHttpRequest"},
        timeout=25,
    )
    r.raise_for_status()
    rows = r.json().get("data") or []
    pick = None
    for row in rows:
        name = (row.get("TypeName") or "").upper()
        if "SJC" in name and ("1L" in name or "1 L" in name or "LƯỢNG" in name):
            pick = row
            break
    pick = pick or (rows[0] if rows else None)
    if not pick:
        raise ValueError("SJC không trả dữ liệu")
    buy = to_num(pick.get("BuyValue") or pick.get("Buy"))
    sell = to_num(pick.get("SellValue") or pick.get("Sell"))

    def mil(v):  # quy về triệu đồng/lượng
        if v is None:
            return None
        if v > 1e6:
            return v / 1e6
        if v > 1e3:  # nghìn đồng
            return v / 1e3
        return v

    return mil(buy), mil(sell)


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
        return fetch_dnse(kind, symbol, days)
    except Exception as e:  # noqa: BLE001
        log(f"   DNSE lỗi {symbol}: {e} -> thử VNDirect")
        return fetch_vndirect(symbol, days, index=(kind == "index"))


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
                    dd, mm, yy = re.split(r"[/-]", d)[:3]
                    key = f"{yy[:4]}-{int(mm):02d}-{int(dd):02d}"
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
        buy, sell = fetch_sjc()
        merge(series, "sjc_mua", {today(): buy})
        merge(series, "sjc_ban", {today(): sell})
        log(f"   SJC mua {buy} / bán {sell} triệu/lượng")

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

    step("Vàng SJC", sjc)
    step("Vàng thế giới", yahoo("vang_tg", "GC=F"))
    step("USD/VND", usd)
    step("Bitcoin", yahoo("btc", "BTC-USD"))
    step("Bạc", yahoo("bac", "SI=F"))
    step("Dầu Brent", yahoo("dau", "BZ=F"))
    step("S&P 500", yahoo("sp500", "^GSPC"))
    step("VN-Index", index("vnindex", "VNINDEX"))
    step("VN30", index("vn30", "VN30"))
    step("HNX-Index", index("hnx", "HNX"))
    step("UPCoM", index("upcom", "UPCOM"))
    step("Khối ngoại HOSE", foreign)

    # ---- cổ phiếu lớn
    stocks = load(STOCKS_FILE, {"symbols": {}})
    syms = stocks.setdefault("symbols", {})
    for code, name in BIG_STOCKS.items():
        def run(code=code, name=name):
            item = syms.setdefault(code, {})
            item["name"] = name
            hist = {r[0]: r for r in item.get("closes", [])}
            data = fetch_ohlc("stock", code, 400 if len(hist) < 30 else 20)
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
    PRICES_FILE.write_text(json.dumps(prices, ensure_ascii=False, separators=(",", ":")), encoding="utf-8")
    STOCKS_FILE.write_text(json.dumps(stocks, ensure_ascii=False, separators=(",", ":")), encoding="utf-8")
    log(f"\nXong. {len(errors)} nguồn lỗi.")
    for e in errors:
        log("  -", e)
    # Chỉ báo lỗi (đỏ) khi TẤT CẢ nguồn chính đều hỏng
    main_keys = ["vnindex", "vang_tg", "usd_vnd"]
    if all(not series.get(k) for k in main_keys):
        sys.exit(1)


if __name__ == "__main__":
    main()
