import json, re

T = json.load(open("timing.json"))
S = {s["id"]: s for s in T}
TOTAL = round(T[-1]["start"] + T[-1]["dur"] + 1.2, 2)
GAP = 0.45


def norm(w):
    return re.sub(r"[^\w]", "", w.lower())


def w(sid, key, nth=0):
    s = S[sid]
    hits = [x for x in s["words"] if norm(x["word"]).startswith(key)]
    x = hits[min(nth, len(hits) - 1)] if hits else s["words"][0]
    return round(s["start"] + x["start"], 3)


st = lambda sid: S[sid]["start"]
en = lambda sid: round(S[sid]["start"] + S[sid]["dur"] + GAP, 3)

# kind: gold (gold box, dark text) | chip (navy box, white text) | big (gold text) | title (white italic) | small
E = []
def add(text, kind, x, y, t0, t1, size=None, align="c"):
    E.append(dict(text=text, kind=kind, x=x, y=y, t0=round(t0, 3), t1=round(t1, 3), size=size, align=align))

add("ĐÀ NẴNG", "gold", 540, 640, st("s1"), en("s1"))
add("CHỌN MỘT GÓC BIỂN?", "title", 540, 800, w("s1", "chọn"), en("s1"), 78)

add("DẢI BIỂN ĐÀ NẴNG", "gold", 540, 330, st("s2"), en("s2"))
add("↑ Bán đảo Sơn Trà", "chip", 540, 520, w("s2", "sơn"), en("s2"))
add("↓ Hội An", "chip", 540, 1360, w("s2", "hội"), en("s2"))

add("TRỤC VÕ NGUYÊN GIÁP", "gold", 540, 330, st("s3"), en("s4"))
add("1 · Võ Nguyên Giáp", "chip", 90, 1130, w("s3", "võ", 1), en("s3"), align="l")
add("2 · Trường Sa", "chip", 90, 1240, w("s3", "trường"), en("s3"), align="l")
add("3 · Nguyễn Đức Thuận", "chip", 90, 1350, w("s3", "nguyễn"), en("s3"), align="l")

add("SUN SAPHIA", "big", 540, 600, w("s4", "sun"), en("s4"), 130)
add("RESIDENCE", "big", 540, 740, w("s4", "sun") + 0.15, en("s4"), 96)

add("BÃI TẮM SƠN THỦY", "gold", 540, 330, st("s5"), en("s5"))
add("~400 m", "big", 540, 1180, w("s5", "bốn"), en("s5"), 170)
add("đi bộ", "chip", 540, 1330, w("s5", "đi"), en("s5"))

add("KẾT NỐI", "gold", 540, 330, st("s6"), en("s7"))
add("Ngũ Hành Sơn · 5–10 phút", "chip", 540, 1130, w("s6", "năm"), en("s7"))
add("Sân bay quốc tế · 10–15 phút", "chip", 540, 1240, w("s6", "mười", 1), en("s7"))
add("Phố cổ Hội An · ~30 phút", "chip", 540, 1350, w("s7", "ba"), en("s7"))

add("TRƯỚC MẶT: BIỂN", "title", 540, 560, w("s8", "trước"), TOTAL, 70)
add("SAU LƯNG: NÚI", "title", 540, 660, w("s8", "sau"), TOTAL, 70)
add("BÊN CẠNH: SÔNG", "title", 540, 760, w("s8", "bên"), TOTAL, 70)
add("VIEW BIỂN hay VIEW NÚI?", "gold", 540, 940, w("s8", "nếu"), TOTAL, 56)
add("hiephoangmt.com · Zalo 0904 567 009", "small", 540, 1100, w("s8", "bình"), TOTAL, 34)

SRC = [("Bản đồ: GEOlayers 3 · minh họa, không theo tỷ lệ", 0, st("s5")),
       ("Thời gian di chuyển ước tính · nguồn: hiephoangmt.com", st("s5"), en("s7"))]

# captions: chunks of <=5 words
CAP = []
for s in T:
    cur = []
    for i, x in enumerate(s["words"]):
        cur.append(x)
        if len(cur) >= 5 or re.search(r"[.,:?!]$", x["word"]) or i == len(s["words"]) - 1:
            CAP.append(dict(text=" ".join(y["word"] for y in cur).upper(),
                            t0=round(s["start"] + cur[0]["start"], 3), t1=round(s["start"] + cur[-1]["end"] + 0.12, 3)))
            cur = []

CAM = [
    (0.0, "CAM 1 · Toàn cảnh miền Trung Việt Nam (zoom ~6), camera từ từ tiến vào Đà Nẵng"),
    (st("s2"), "CAM 2 · Dải biển Đà Nẵng từ Sơn Trà xuống Hội An (zoom ~11). Tô sáng đường bờ biển"),
    (st("s3"), "CAM 3 · Zoom vào trục Võ Nguyên Giáp – Trường Sa (zoom ~15). Tô sáng 3 tuyến đường"),
    (st("s4"), "CAM 4 · Zoom sát khu đất (zoom ~17), đặt khu đất ĐÚNG GIỮA khung (540, 960) – vòng định vị ở đây. Nghiêng 3D nhẹ"),
    (st("s5"), "CAM 5 · Pan về phía biển, vẽ đường đi bộ ~400 m ra bãi tắm Sơn Thủy"),
    (st("s6"), "CAM 6 · Zoom out (zoom ~13) thấy Ngũ Hành Sơn + sân bay, vẽ 2 đường nối"),
    (st("s7"), "CAM 7 · Zoom out (zoom ~11) thấy Hội An, vẽ đường nối"),
    (st("s8"), "CAM 8 · Quay lại khu đất, xoay 3D chậm (orbit) đến hết"),
]
RING = (w("s3", "góc"), en("s5"))

data = dict(total=TOTAL, els=E, caps=CAP, src=SRC, cams=CAM, ring=RING)
js = open("template.jsx", encoding="utf-8").read().replace("/*DATA*/", "var D = " + json.dumps(data, ensure_ascii=True) + ";")
open("SunSaphia_ViTri_GEOlayers.jsx", "w", encoding="ascii").write(js)
print("ok", TOTAL, len(E), "els", len(CAP), "caps")
