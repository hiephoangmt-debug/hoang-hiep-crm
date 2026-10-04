#!/usr/bin/env python3
"""Import the Hai Van Bay cart from the internal spreadsheet into src/units.json.

    python3 landing/import_cart.py /path/to/GH_HVB.xlsx

Only public fields are written (code, zone, type, handover, land area, flags).
Prices are used for ranking only; sources, fees, managers and prices are
never written, so the spreadsheet itself must not be committed.
"""
import json
import re
import sys
from collections import Counter, defaultdict
from datetime import date
from pathlib import Path

import openpyxl

SHEET = "CỤM 6 - HVB"
OUT = Path(__file__).parent / "src" / "units.json"
# column indexes in SHEET (data rows are offset from the header row)
C_ZONE, C_CODE, C_TYPE, C_HAND, C_LAND, C_PRICE, C_SOURCE, C_STATUS = 1, 2, 4, 5, 6, 7, 8, 12
# units from these sources are the exclusive inventory (shown in full); the source name is never published
EXCLUSIVE_SOURCES = ("AKA HOMES", "AKAHOMES", "AKA REAL", "AKAREAL")

ZONES = {"BẠCH VÂN": "Bạch Vân", "VỊNH MÂY": "Vịnh Mây", "ĐẢO NGỌC": "Đảo Ngọc", "TINH VÂN": "Tinh Vân"}

FLAG_SHOW, FLAG_TOP, FLAG_BEST, FLAG_TYPE, FLAG_OTHER, FLAG_EXCL = 1, 2, 4, 8, 16, 32


def norm_type(t):
    t = (t or "").strip().lower()
    if not t or t in ("hoàn thiện", "giãn xây 18t"):
        return "Liền kề"
    if "xẻ khe" in t:
        return "Liền kề xẻ khe"
    if "góc" in t:
        return "Liền kề góc"
    if t in ("đl", "đơn lập") or "đơn lập" in t:
        return "Biệt thự đơn lập"
    if t in ("sl", "song lập") or "song lập" in t:
        return "Biệt thự song lập"
    if "shop" in t:
        return "Shophouse"
    return "Liền kề"


def norm_hand(h, t):
    h = (h or "").strip().upper()
    if "VOS" in h:
        return "Xây thô + Về ở sớm"
    if h.startswith("THÔ"):
        return "Xây thô"
    if "HOÀN THIỆN" in h or (t or "").strip().lower() == "hoàn thiện":
        return "Hoàn thiện"
    m = re.search(r"(\d+)\s*T", h)
    if "GIÃN" in h:
        return "Giãn xây %sT" % m.group(1) if m else "Giãn xây"
    return "Liên hệ"


def num(v):
    if isinstance(v, (int, float)):
        return float(v)
    if isinstance(v, str):
        s = v.strip()
        if re.fullmatch(r"\d{1,3}(\.\d{3})+", s):        # 8.440.454.311
            return float(s.replace(".", ""))
        if re.fullmatch(r"\d+(,\d+)?", s):                # 75,0
            return float(s.replace(",", "."))
    return None


def img_for(zone, typ, hand):
    if zone == "Vịnh Mây":
        return "villa-vinh-may" if "Biệt thự" in typ else "street-vinh-may"
    if zone == "Bạch Vân":
        return "house-bach-van"
    if hand == "Hoàn thiện":
        return "pool-dao-ngoc"
    return "house-classic" if "Biệt thự" not in typ else "house-dao-ngoc"


def tag_for(typ, hand):
    if "Về ở sớm" in hand:
        return "Về ở sớm"
    if "góc" in typ:
        return "Căn góc"
    if "Biệt thự" in typ:
        return "Biệt thự"
    if hand == "Hoàn thiện":
        return "Hoàn thiện"
    return "Giá tốt"


def main(path):
    wb = openpyxl.load_workbook(path, data_only=True, read_only=True)
    rows = list(wb[SHEET].iter_rows(values_only=True))[1:]
    units, exclusive = {}, set()
    for r in rows:
        if not r or not r[C_CODE] or str(r[C_STATUS]).strip() != "Còn hàng":
            continue
        zone = ZONES.get(str(r[C_ZONE]).strip().upper())
        if not zone:
            continue
        code = re.sub(r"[^0-9A-ZĐ-]", "", str(r[C_CODE]).upper())
        typ = norm_type(r[C_TYPE])
        hand = norm_hand(r[C_HAND], r[C_TYPE])
        price = num(r[C_PRICE])
        if re.sub(r"\s+", " ", str(r[C_SOURCE] or "")).strip().upper() in EXCLUSIVE_SOURCES:
            exclusive.add(code)
        if price is not None and price < 1e9:              # malformed price cell
            price = None
        u = {"code": code, "zone": zone, "type": typ, "hand": hand, "land": num(r[C_LAND]), "price": price}
        old = units.get(code)
        # duplicates come from several sources: keep the best known price
        if old is None or (price is not None and (old["price"] is None or price < old["price"])):
            units[code] = u

    # fix zone typos: a code prefix that is >=90% in one zone (and common) belongs to that zone
    pref = lambda c: re.match(r"[^\d-]+", c).group(0)
    stats = defaultdict(Counter)
    for u in units.values():
        stats[pref(u["code"])][u["zone"]] += 1
    fixed = []
    for u in units.values():
        z, n = stats[pref(u["code"])].most_common(1)[0]
        total = sum(stats[pref(u["code"])].values())
        if z != u["zone"] and total >= 10 and n / total >= 0.9:
            fixed.append((u["code"], u["zone"], z))
            u["zone"] = z
    print("zone fixed", fixed)

    ul = sorted(units.values(), key=lambda u: (u["price"] is None, u["price"] or 0, u["code"]))
    for i, u in enumerate(ul, 1):
        u["rank"] = i if u["price"] is not None else 9999
        u["flags"] = 0
    for u in ul:
        if u["code"] in exclusive:
            u["flags"] |= FLAG_EXCL | FLAG_SHOW
    priced = [u for u in ul if u["price"] is not None]

    # ★ best price now: 5 cheapest, at most 2 per zone
    per_zone = Counter()
    for u in priced:
        if per_zone[u["zone"]] < 2:
            u["flags"] |= FLAG_TOP | FLAG_SHOW
            per_zone[u["zone"]] += 1
        if sum(per_zone.values()) == 5:
            break
    # top 5 per type, top 6 per zone, next 3 per zone as "other inventory"
    by_type, by_zone = defaultdict(list), defaultdict(list)
    for u in priced:
        by_type[u["type"]].append(u)
        by_zone[u["zone"]].append(u)
    for lst in by_type.values():
        for u in lst[:5]:
            u["flags"] |= FLAG_TYPE | FLAG_SHOW
    for lst in by_zone.values():
        for u in lst[:6]:
            u["flags"] |= FLAG_BEST | FLAG_SHOW
        rest = [u for u in lst if not u["flags"] & FLAG_SHOW]
        for u in rest[:3]:
            u["flags"] |= FLAG_OTHER | FLAG_SHOW

    # scarce lines: (zone, type) groups with the fewest units left
    groups = defaultdict(list)
    for u in ul:
        groups[(u["zone"], u["type"])].append(u)
    lines = []
    for (zone, typ), lst in sorted(groups.items(), key=lambda kv: (len(kv[1]), kv[0])):
        lands = sorted(u["land"] for u in lst if u["land"])
        area = "~%s m² đất" % fmt(lands[0]) if lands and lands[0] == lands[-1] else (
            "%s – %s m² đất" % (fmt(lands[0]), fmt(lands[-1])) if lands else "Liên hệ")
        lines.append({"name": "%s %s" % (typ, zone), "zone": zone, "type": typ, "area": area,
                      "img": img_for(zone, typ, lst[0]["hand"]), "codes": [u["code"] for u in lst[:3]],
                      "left": len(lst), "note": "Chỉ còn %d căn trong rổ hàng" % len(lst)})
        if len(lines) == 5:
            break

    zones = sorted({u["zone"] for u in ul})
    types = sorted({u["type"] for u in ul})
    hands = sorted({u["hand"] for u in ul})
    out = {
        "updated": date.today().isoformat(), "count": len(ul),
        "zones": zones, "types": types, "hands": hands,
        # [code, zone#, type#, hand#, land, rank, flags, img, tag]
        "units": [[u["code"], zones.index(u["zone"]), types.index(u["type"]), hands.index(u["hand"]),
                   u["land"] or 0, u["rank"], u["flags"], img_for(u["zone"], u["type"], u["hand"]),
                   tag_for(u["type"], u["hand"])] for u in ul],
        "lines": lines,
    }
    OUT.write_text(json.dumps(out, ensure_ascii=False, separators=(",", ":")), encoding="utf-8")
    shown = sum(1 for u in ul if u["flags"] & FLAG_SHOW)
    print("exclusive", sorted(exclusive))
    print("units", len(ul), "shown", shown, "hidden (search only)", len(ul) - shown, "->", OUT)
    print("zones", Counter(u["zone"] for u in ul))
    print("types", Counter(u["type"] for u in ul))
    print("scarce", [(l["name"], l["left"]) for l in lines])


def fmt(x):
    return ("%.1f" % x).replace(".", ",")


if __name__ == "__main__":
    main(sys.argv[1])
