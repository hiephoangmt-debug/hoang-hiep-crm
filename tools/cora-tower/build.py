"""Static site generator for www.cora-tower.com.

Run:  python3 tools/cora-tower/build.py
Writes web/cora-tower/{index,khoi-de-shophouse,penthouse}.html
"""
import json
import sys

sys.path.insert(0, str(__import__("pathlib").Path(__file__).parent))
from content import INDEX_ARTICLE, SHOP_ARTICLE, PH_ARTICLE, SUN_BODY, SUN_TOC, SUN_FAQ, article  # noqa: E402
import pathlib

ROOT = pathlib.Path(__file__).resolve().parents[2]
SITE = ROOT / "web" / "cora-tower"
D = "https://www.cora-tower.com/"
TEL, TEL_TXT, TEL_INTL = "0904567009", "0904 567 009", "+84904567009"
EMAIL = "hiephoangmt@gmail.com"
ZALO = f"https://zalo.me/{TEL}"
AGENT = "Hoàng Phạm Đình Hiệp – Tư vấn Cora Tower"
AGENT_TITLE = "Hoàng Phạm Đình Hiệp – Giám đốc kinh doanh"
UPDATED = "07/10/2026"
MAPS = "https://www.google.com/maps/search/?api=1&query=Cora+Tower+v%C3%B2ng+xoay+29%2F3+Nguy%E1%BB%85n+Ph%C6%B0%E1%BB%9Bc+Lan+H%C3%B2a+Xu%C3%A2n+%C4%90%C3%A0+N%E1%BA%B5ng"

# name: (width, height, small width, alt)
IMG = {
    "hero": ("phoi-canh-cora-tower-hoang-hon", 1600, 900, 800, "Phối cảnh hai tòa tháp Cora Tower Đà Nẵng lúc hoàng hôn"),
    "a1a2": ("phoi-canh-cora-tower-toa-a1-a2", 1600, 900, 800, "Phối cảnh tòa A1 và A2 dự án Cora Tower với khối đế thương mại"),
    "shop": ("cora-tower-khoi-de-shophouse", 1600, 900, 800, "Khối đế shophouse Cora Tower mặt tiền đường 29/3"),
    "aerial": ("toan-canh-cora-tower-song-cam-le", 1920, 1080, 960, "Toàn cảnh Cora Tower giữa khu đô thị Nam Hòa Xuân, hướng sông Cẩm Lệ"),
    "struct": ("cau-truc-toa-can-ho-cora-tower", 1600, 900, 800, "Cấu trúc tòa căn hộ Cora Tower: tầng 1 shophouse, tầng 2 dịch vụ tiện ích, tầng 3 căn hộ sân vườn, tầng 4–24 căn hộ điển hình, tầng 25 căn hộ duplex"),
    "loc": ("vi-tri-cora-tower-29-3-nguyen-phuoc-lan", 960, 540, 480, "Vị trí tòa A1, A2 Cora Tower tại vòng xoay đường 29/3 giao Nguyễn Phước Lan"),
    "ph": ("penthouse-duplex-san-vuon-cora-tower", 1120, 756, 560, "Không gian sân vườn trên cao căn duplex penthouse Cora Tower nhìn ra thành phố Đà Nẵng"),
    "river": ("khu-do-thi-hoa-xuan-ven-song", 1280, 788, 640, "Khu đô thị Hòa Xuân ven sông, Đà Nẵng"),
    "planA1": ("mat-bang-toa-a1-tang-3a-24-cora-tower", 2000, 1414, 1000, "Mặt bằng tòa A1 Cora Tower tầng 3A–24 với 28 căn mỗi sàn"),
    "planA2": ("mat-bang-toa-a2-tang-3a-24-cora-tower", 2000, 1415, 1000, "Mặt bằng tòa A2 Cora Tower tầng 3A–24 với 28 căn mỗi sàn"),
    "g3A1": ("mat-bang-tang-3-san-vuon-toa-a1-cora-tower", 2000, 1059, 1000, "Mặt bằng tầng 3 căn hộ sân vườn tòa A1 Cora Tower, diện tích sân vườn từng căn"),
    "g3A2": ("mat-bang-tang-3-san-vuon-toa-a2-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng 3 căn hộ sân vườn tòa A2 Cora Tower, diện tích sân vườn từng căn"),
    "iso1pn": ("phoi-canh-3d-can-1pn-cora-tower", 1024, 1536, 512, "Phối cảnh 3D nội thất căn hộ 1PN+ Cora Tower với logia, bếp, phòng khách và phòng ngủ"),
    "int1pn": ("noi-that-can-ho-1pn-cora-tower", 1080, 1080, 540, "Phối cảnh nội thất căn hộ 1PN+ Cora Tower"),
    "unit1pn": ("mat-bang-can-a10803-1pn-cora-tower", 1076, 1521, 538, "Mặt bằng căn hộ điển hình A10803 loại 1PN+1 tòa A1 Cora Tower, kích thước 6,2 x 9,6 m"),
    "pA10801": ("mat-bang-can-a10801-2pn-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ A10801 loại 2PN tòa A1 Cora Tower, căn góc chữ L"),
    "pA10805": ("mat-bang-can-a10805-2pn-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ A10805 loại 2PN tòa A1 Cora Tower, 2 vệ sinh có bồn tắm"),
    "pA10817": ("mat-bang-can-a10817-2pn-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ A10817 loại 2PN tòa A1 Cora Tower, căn góc"),
    "pA20827": ("mat-bang-can-a20827-2pn-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ A20827 loại 2PN tòa A2 Cora Tower"),
    "pA10828": ("mat-bang-can-a10828-1pn-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ A10828 loại 1PN+1 tòa A1 Cora Tower"),
    "pA10823": ("mat-bang-can-a10823-studio-cora-tower", 900, 1272, 450, "Mặt bằng căn hộ Studio A10823 tòa A1 Cora Tower"),
    "amA1": ("mat-bang-tien-ich-tang-2-toa-a1-cora-tower", 1800, 1273, 900, "Mặt bằng tiện ích tầng 2 tòa A1 Cora Tower: hồ bơi, Jjimjilbang và spa, khu trẻ em, thư viện, sinh hoạt cộng đồng"),
    "amA2": ("mat-bang-tien-ich-tang-2-toa-a2-cora-tower", 1800, 1273, 900, "Mặt bằng tiện ích tầng 2 tòa A2 Cora Tower: hồ bơi, spa, gym, golf mô phỏng, thư viện, khu trẻ em"),
    "shA1": ("mat-bang-shophouse-tang-1-toa-a1-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng 1 shophouse tòa A1 Cora Tower với mã căn và diện tích từng shop"),
    "shA2": ("mat-bang-shophouse-tang-1-toa-a2-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng 1 shophouse tòa A2 Cora Tower với mã căn và diện tích từng shop"),
    "mtA1": ("mat-tien-shophouse-tang-1-toa-a1-cora-tower", 1590, 1125, 795, "Kích thước mặt tiền từng shophouse tầng 1 tòa A1 Cora Tower"),
    "mtA2": ("mat-tien-shophouse-tang-1-toa-a2-cora-tower", 1590, 1125, 795, "Kích thước mặt tiền từng shophouse tầng 1 tòa A2 Cora Tower"),
    "ph25A1": ("mat-bang-penthouse-tang-25-toa-a1-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng 25 penthouse tòa A1 Cora Tower với mã căn và diện tích"),
    "phL25A1": ("mat-bang-penthouse-tang-lung-25-toa-a1-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng lửng 25 penthouse duplex tòa A1 Cora Tower"),
    "ph25A2": ("mat-bang-penthouse-tang-25-toa-a2-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng 25 penthouse tòa A2 Cora Tower với mã căn và diện tích"),
    "phL25A2": ("mat-bang-penthouse-tang-lung-25-toa-a2-cora-tower", 2000, 1415, 1000, "Mặt bằng tầng lửng 25 penthouse duplex tòa A2 Cora Tower"),
    "sr01": ("phoi-canh-shophouse-khoi-de-cora-tower-01", 1600, 1066, 800, "Phố shophouse khối đế Cora Tower dọc vỉa hè rợp cây"),
    "sr02": ("phoi-canh-shophouse-khoi-de-cora-tower-02", 1600, 1066, 800, "Sảnh đón và shophouse khối đế Cora Tower"),
    "sr03": ("phoi-canh-shophouse-khoi-de-cora-tower-03", 1600, 1066, 800, "Lối xe đón trả khách trước shophouse Cora Tower"),
    "sr04": ("phoi-canh-shophouse-khoi-de-cora-tower-04", 1600, 1066, 800, "Mái sảnh và dãy shophouse Cora Tower"),
    "sr05": ("phoi-canh-shophouse-khoi-de-cora-tower-05", 1600, 1066, 800, "Dãy shophouse Cora Tower và sân đón khách"),
    "sr06": ("phoi-canh-shophouse-khoi-de-cora-tower-06", 1600, 1066, 800, "Shophouse Cora Tower mặt kính kịch trần cạnh sảnh"),
    "sr07": ("phoi-canh-shophouse-khoi-de-cora-tower-07", 1600, 1066, 800, "Shophouse khối đế Cora Tower bo cong theo đường 29/3"),
    "sr08": ("phoi-canh-shophouse-khoi-de-cora-tower-08", 1600, 1066, 800, "Mặt tiền shophouse Cora Tower dọc đường 29/3"),
    "sr09": ("phoi-canh-shophouse-khoi-de-cora-tower-09", 1600, 1066, 800, "Shophouse khối đế dưới tòa tháp Cora Tower"),
    "sr10": ("phoi-canh-shophouse-khoi-de-cora-tower-10", 1600, 1066, 800, "Góc bo cong khối đế Cora Tower và khu shophouse"),
    "sr11": ("phoi-canh-shophouse-khoi-de-cora-tower-11", 1600, 1066, 800, "Mặt tiền shophouse Cora Tower với biển hiệu thương hiệu"),
    "vBan": ("view-bien-tu-ban-cong-cora-tower", 1600, 900, 800, "View biển từ ban công căn hộ Cora Tower"),
    "vSun": ("view-thanh-pho-hoang-hon-cora-tower", 1600, 900, 800, "View thành phố Đà Nẵng lúc hoàng hôn từ căn hộ Cora Tower"),
    "vHan": ("view-song-han-tu-can-ho-cora-tower", 1600, 900, 800, "View sông Hàn và trung tâm Đà Nẵng từ ban công Cora Tower"),
    "vKdt": ("view-khu-do-thi-tu-ban-cong-cora-tower", 1600, 900, 800, "View khu đô thị Sun Neo City từ ban công Cora Tower"),
    "rPod": ("khoi-de-thuong-mai-cora-tower", 1600, 900, 800, "Khối đế thương mại và sân vườn trên cao Cora Tower"),
    "rAxis": ("truc-duong-giua-hai-toa-cora-tower", 1600, 900, 800, "Trục đường 29/3 giữa hai tòa Cora Tower hướng vòng xoay đài phun nước"),
    "rTwin": ("hai-toa-cora-tower-khoi-mai-cam", 1600, 900, 800, "Hai tòa tháp Cora Tower với khối mái màu cam bên vòng xoay 29/3"),
    "rPool": ("ho-boi-trong-nha-cora-tower", 1600, 900, 800, "Hồ bơi trong nhà tầng 2 Cora Tower"),
    "rBridge": ("toa-thap-cora-tower-va-cau", 1600, 900, 800, "Tòa tháp Cora Tower bên vòng xoay đài phun nước, hướng cầu và biển"),
    "rJjim": ("jjimjilbang-cora-tower", 1600, 900, 800, "Phòng xông hơi Jjimjilbang kiểu Hàn Quốc tại Cora Tower"),
    "rRound": ("vong-xoay-dai-phun-nuoc-cora-tower", 1600, 900, 800, "Vòng xoay đài phun nước trước Cora Tower nhìn từ sân vườn trên cao"),
    "vRiver": ("view-song-va-bien-cora-tower", 1600, 900, 800, "View sông và biển từ ban công căn hộ Cora Tower"),
    "aSea": ("toan-canh-cora-tower-huong-bien", 1600, 900, 800, "Toàn cảnh Cora Tower giữa khu đô thị Nam Hòa Xuân hướng biển"),
    "aRiver": ("toan-canh-cora-tower-ven-song", 1600, 900, 800, "Toàn cảnh Cora Tower bên vòng xoay và sông Cổ Cò"),
    "aHan": ("toan-canh-cora-tower-song-han-bien", 1600, 900, 800, "Toàn cảnh Cora Tower nhìn về sông Hàn, vòng quay Sun Wheel và biển"),
    "rNear": ("hai-toa-cora-tower-nhin-gan", 1600, 900, 800, "Hai tòa Cora Tower và khối đế thương mại nhìn gần"),
    "rCorner": ("khoi-de-vong-xoay-cora-tower", 1600, 900, 800, "Khối đế Cora Tower bo cong bên vòng xoay với spa, cafe, phòng gym"),
    "night": ("phoi-canh-cora-tower-ve-dem", 1600, 930, 800, "Phối cảnh Cora Tower về đêm với khối mái màu cam phát sáng"),
    "site": ("tong-mat-bang-cora-tower-vong-xoay-29-3", 1600, 1022, 800, "Tổng mặt bằng hai tòa Cora Tower hai bên đường 29/3 cạnh vòng xoay Nguyễn Phước Lan"),
    "siteAir": ("tong-mat-bang-cora-tower-anh-flycam", 1478, 966, 739, "Tổng mặt bằng Cora Tower trên ảnh flycam thực tế: phân bố căn 3PN, 2PN, 1PN+ và Studio"),
    "cross": ("vi-tri-cora-tower-nga-tu-29-3-nguyen-phuoc-lan", 1478, 1012, 739, "Vị trí Cora Tower tại nút giao đường 29/3 và Nguyễn Phước Lan, hướng sông Cẩm Lệ, sông Đô Toà, cầu Trung Lương"),
    "land": ("khu-dat-cora-tower-huong-song-han", 1422, 1016, 711, "Khu đất Cora Tower bên vòng xoay 29/3, nhìn về sông Hàn và trung tâm Đà Nẵng"),
}


def src(key, big=True):
    n = IMG[key][0]
    return f"assets/img/{n}.jpg" if big else f"assets/img/{n}-{IMG[key][3]}.jpg"


def pic(key, sizes, eager=False, cls="", alt=None):
    n, w, h, s, a = IMG[key]
    load = 'fetchpriority="high" decoding="async"' if eager else 'loading="lazy" decoding="async"'
    c = f' class="{cls}"' if cls else ""
    return (f'<picture{c}><source type="image/webp" srcset="assets/img/{n}-{s}.webp {s}w, assets/img/{n}.webp {w}w" sizes="{sizes}">'
            f'<img src="assets/img/{n}.jpg" srcset="assets/img/{n}-{s}.jpg {s}w, assets/img/{n}.jpg {w}w" sizes="{sizes}" '
            f'width="{w}" height="{h}" alt="{alt or a}" {load}></picture>')


# ----------------------------------------------------------------- shared data
UNIT_TYPES = [
    ("Studio", "32,2 – 32,3 m²", "36,0 – 36,1 m²", "Ở một mình, cho thuê ngắn hạn"),
    ("1PN+", "52,5 – 59,6 m²", "56,5 – 63,5 m²", "Vợ chồng trẻ, đầu tư cho thuê"),
    ("2PN", "60,6 – 71,3 m²", "66,1 – 78,0 m²", "Gia đình nhỏ, nhiều căn góc"),
    ("2PN+1 (tòa A2)", "73,1 m²", "79,3 m²", "Gia đình 4 người, có phòng linh hoạt"),
    ("3PN", "78,9 – 81,8 m²", "85,7 – 89,1 m²", "Gia đình đa thế hệ, mỗi sàn 1 căn"),
    ("Sân vườn tầng 3", "theo loại căn", "+ sân vườn 10 – 151 m²", "Thích không gian xanh riêng"),
]
PRICES = [
    ("Tòa A1 – 1PN+ (dãy phía Bắc)", "A10802 – A10810", "3,2 – 3,65 tỷ"),
    ("Tòa A1 – 1PN+ (dãy phía Nam)", "A10819 – A10825", "3,3 – 3,65 tỷ"),
    ("Tòa A1 – 1PN+ (A10812A, A10812B)", "Căn sát góc", "3,6 – 3,85 tỷ"),
    ("Tòa A2 – 1PN+ (dãy phía Bắc)", "A20803 – A20809", "3,1 – 3,4 tỷ"),
    ("Tòa A2 – 1PN+ (A20812B, A20815)", "Căn sát góc", "3,6 – 3,8 tỷ"),
    ("Tòa A2 – 1PN+ (dãy phía Nam)", "A20818 – A20826", "3,3 – 3,85 tỷ"),
]
CONNECT = [
    "Vòng xoay đường 29/3 giao Nguyễn Phước Lan – trục chính Nam Hòa Xuân",
    "Qua cầu Hòa Xuân tới MM Mega Market, đường Cách Mạng Tháng 8",
    "Kết nối Quảng trường 29/3, Lotte Mart, cầu Rồng, cầu Trần Thị Lý, trung tâm Đà Nẵng",
    "Ra biển Đà Nẵng qua đường Hồ Xuân Hương; hướng đi Hội An qua cầu Trung Lương",
    "Sân bay quốc tế Đà Nẵng, hướng ra đường Võ Chí Công",
    "Liền kề sông Cẩm Lệ, sông Đô Toà; cầu mới dự kiến nối Bùi Tá Hán",
]
FAQ_INDEX = [
    ("Cora Tower ở đâu?", "Tại vòng xoay đường 29/3 giao Nguyễn Phước Lan, trung tâm khu đô thị Nam Hòa Xuân (Sun Neo City), Đà Nẵng."),
        ("Cora Tower có những loại căn nào?", "Studio 32–32,2 m², 1PN+ 52,3–59,6 m², 2PN 60,6–73,4 m², 3PN 78,9 m² (diện tích thông thủy), căn hộ sân vườn tầng 3, duplex tầng 25 và shophouse tầng 1."),
    ("Mỗi sàn Cora Tower có bao nhiêu căn?", "Theo mặt bằng tầng 3A–24, mỗi tòa A1, A2 có 28 căn/sàn."),
    ("Giá căn 1PN+ Cora Tower bao nhiêu?", "Thông tin thị trường cho căn 1PN+ tầng 15 khoảng 3,1–3,85 tỷ/căn (giá trần gồm VAT, phí bảo trì, theo chính sách bán hàng). Giá chính thức theo công bố của chủ đầu tư."),
    ("Pháp lý Cora Tower thế nào?", "Đất lô A2-19 (Tòa A1) và A2-20 (Tòa A2) đã có Giấy chứng nhận QSDĐ số DI 103576, DI 103577 cấp 12/4/2023. Sở Xây dựng Đà Nẵng có văn bản 7117/SXD-QLN ngày 05/5/2026 về điều kiện nhà ở hình thành trong tương lai đưa vào kinh doanh; VietinBank cam kết phát hành bảo lãnh; hợp đồng mẫu đã đăng ký tại Sở Công Thương."),
    ("Chủ đầu tư Cora Tower là công ty nào?", "Công ty Cổ phần Tập đoàn Mặt Trời (Sun Group), mã số doanh nghiệp 0305016195, trụ sở Tầng 1M, 36-38 Bạch Đằng, phường Hải Châu, TP Đà Nẵng."),
    ("Cora Tower có bao nhiêu căn hộ?", "Tổng 1.342 căn hộ: Tòa A1 (lô A2-19) 672 căn, Tòa A2 (lô A2-20) 670 căn; mỗi tòa 25 tầng nổi + tum, 2 tầng hầm, cao 97,95 m."),
    ("Khi nào Cora Tower bàn giao?", "Theo chính sách bán hàng CSƯĐ 06.1, khách thanh toán tối thiểu 70% được nhận căn hộ để sử dụng ngay khi dự án nghiệm thu đưa vào sử dụng, dự kiến ngày 31/10/2027; tiêu chuẩn hoàn thiện trần, tường, sàn. Mốc chính thức theo hợp đồng mua bán."),
    ("Chính sách bán hàng Cora Tower hiện nay thế nào?", "Theo CSƯĐ 06.1 (từ 21/08/2026): chiết khấu 7% gói hoàn thiện nội thất; không vay chiết khấu thêm 5% và giãn tiến độ đến 40 tháng; vay tối đa 70%, hỗ trợ lãi suất đến 24 tháng (không muộn hơn 30/09/2028); Sun Early Key thanh toán 70% nhận nhà; thanh toán sớm được ưu đãi 8%/năm; miễn phí dịch vụ quản lý 1 năm."),
    ("Mua Cora Tower ký hợp đồng gì?", "Dự án đã đủ điều kiện ký hợp đồng mua bán (HĐMB). Khách ký hợp đồng thỏa thuận nguyên tắc (HĐTHNV) trước để có thời gian chuẩn bị tài chính, hồ sơ vay, sau đó ký HĐMB theo thông báo của chủ đầu tư."),
]
FAQ_SHOP = [
    ("Shophouse Cora Tower nằm ở tầng nào?", "Shophouse thương mại nằm ở tầng 1 khối đế, hướng ra vòng xoay 29/3 – Nguyễn Phước Lan; tầng 2 là dịch vụ – tiện ích."),
    ("Shophouse khối đế Cora Tower có sở hữu lâu dài không?", "Có. Theo chủ đầu tư, shophouse khối đế có pháp lý sở hữu lâu dài như căn hộ: vừa ở vừa kinh doanh được, và đăng ký được hộ khẩu thường trú."),
    ("Shophouse cao bao nhiêu, làm tầng lửng được không?", "Chiều cao tầng khối đế lên tới khoảng 7 m nên có thể làm thêm tầng lửng. Chủ nhà tự hoàn thiện tầng lửng, miễn không ảnh hưởng kết cấu, cơ điện, kiến trúc tòa nhà; hồ sơ phương án gửi Ban quản lý duyệt trong khoảng 1–2 tuần."),
    ("Shophouse có đăng ký giấy phép kinh doanh tại căn được không?", "Shophouse sở hữu lâu dài như căn hộ nên không đăng ký giấy phép kinh doanh tại căn. Cách làm phổ biến: cho thương hiệu thuê bằng hợp đồng thuê ghi mã căn, hoặc tự kinh doanh với doanh nghiệp/hộ kinh doanh đăng ký ở địa chỉ khác và dùng shophouse làm địa điểm kinh doanh."),
    ("Mua shophouse Cora Tower được vay ngân hàng bao nhiêu?", "Chính sách vay tương tự căn hộ: khách đủ điều kiện được vay tối đa 70% giá trị, hỗ trợ lãi suất 0% trong 24 tháng."),
    ("Có gộp (đập thông) 2 căn shophouse được không?", "Được với tường ngăn cách 20 cm và tường ngăn phòng 10 cm; vách chịu lực 30 cm thì không. Phương án cần Ban quản lý phê duyệt cuối cùng."),
    ("Shophouse khối đế phù hợp kinh doanh gì?", "Showroom, cafe, nhà hàng, thời trang, mỹ phẩm, văn phòng giao dịch, phòng khám và các dịch vụ phục vụ 1.342 căn hộ phía trên."),
]
FAQ_PH = [
    ("Penthouse Cora Tower ở tầng mấy?", "Penthouse nằm ở tầng 25 – tầng cao nhất, trong khối mái kiến trúc màu cam đặc trưng."),
    ("Penthouse Cora Tower trần cao bao nhiêu, làm duplex được không?", "Chiều cao tầng penthouse lên tới khoảng 7 m, nên khách có thể làm thêm tầng lửng thành duplex 2 tầng. Chủ đầu tư có layout duplex gợi ý; nhà vệ sinh tầng 2 nên bố trí theo trục kỹ thuật."),
    ("Giá penthouse tính theo căn hay theo diện tích sàn?", "Giá penthouse tính theo đơn nguyên 1 căn hộ, không tính thêm phần tầng lửng khách tự làm."),
    ("Chính sách bán hàng penthouse có giống căn hộ không?", "Cơ bản giống căn hộ điển hình (thanh toán sớm, vay 70%, hỗ trợ lãi suất 24 tháng), trừ gói hỗ trợ nội thất của căn hộ Cora."),
    ("Thời hạn hoàn thiện penthouse là bao lâu?", "Shophouse và penthouse áp dụng thời hạn hoàn thiện 12 tháng kể từ ngày bàn giao; quá hạn, chủ nhà đóng phí 8% giá trị căn để tiếp tục hoàn thiện."),
    ("Giá penthouse Cora Tower bao nhiêu?", "Giá tùy vị trí, diện tích và hướng view. Vui lòng liên hệ 0904 567 009 để nhận bảng giá cập nhật."),
]

DEVELOPER = {"name": "Công ty Cổ phần Tập đoàn Mặt Trời", "short": "Sun Group", "tax": "0305016195",
             "addr": "Tầng 1M, 36-38 Bạch Đằng, phường Hải Châu, TP Đà Nẵng", "tel": "0236 3890999",
             "rep": "Ông Đặng Minh Trường – Tổng Giám đốc"}
PLAN_ROWS = [  # (chỉ tiêu, đơn vị, A1 = lô A2-19, A2 = lô A2-20)
    ("Diện tích khu đất", "m²", "4.580", "4.536"),
    ("Diện tích xây dựng công trình", "m²", "3.067,8", "3.039,0"),
    ("Diện tích cây xanh", "m²", "936,5", "907,7"),
    ("Mật độ xây dựng", "%", "67", "67"),
    ("Tổng diện tích sàn xây dựng", "m²", "61.660,7", "61.758"),
    ("Diện tích tiện ích cư dân", "m²", "2.439,0", "2.424,0"),
    ("Diện tích đỗ xe (2 tầng hầm)", "m²", "8.842,8", "8.891,7"),
    ("Hệ số sử dụng đất", "lần", "10,7", "10,8"),
    ("Số tầng nổi / tầng hầm", "tầng", "25 + tum / 2", "25 + tum / 2"),
    ("Chiều cao công trình", "m", "97,95", "97,95"),
    ("Tổng số căn hộ", "căn", "672", "670"),
    ("Tổng diện tích sử dụng căn hộ", "m²", "36.817,7", "37.023,8"),
    ("Diện tích sinh hoạt cộng đồng", "m²", "540", "541"),
]
LEGAL_DOCS = [  # (nhóm, tiêu đề, mô tả, file pdf hoặc None)
    ("Đầu tư", "Giấy chứng nhận đầu tư số 32121000048", "UBND TP Đà Nẵng chứng nhận lần đầu ngày 28/5/2010 – Dự án Khu đô thị sinh thái ven sông Hòa Xuân.", "gcn-dau-tu-32121000048-kdt-ven-song-hoa-xuan.pdf"),
    ("Đầu tư", "Quyết định 206/QĐ-UBND ngày 13/01/2026", "UBND TP Đà Nẵng chấp thuận chủ trương đầu tư điều chỉnh dự án Khu đô thị sinh thái ven sông Hòa Xuân.", "qd-206-ubnd-2026-chu-truong-dau-tu-dieu-chinh.pdf"),
    ("Quyền sử dụng đất", "Sổ đỏ lô A2-19 (Tòa A1) – số DI 103576", "Giấy chứng nhận QSDĐ, quyền sở hữu nhà ở và tài sản gắn liền với đất, số vào sổ CT 68097, Sở TN&MT Đà Nẵng cấp ngày 12/4/2023.", "so-do-lo-a2-19-toa-a1-cora-tower.pdf"),
    ("Quyền sử dụng đất", "Sổ đỏ lô A2-20 (Tòa A2) – số DI 103577", "Giấy chứng nhận QSDĐ, quyền sở hữu nhà ở và tài sản gắn liền với đất, số vào sổ CT 68098, Sở TN&MT Đà Nẵng cấp ngày 12/4/2023.", "so-do-lo-a2-20-toa-a2-cora-tower.pdf"),
    ("Quy hoạch", "Quyết định 2451/QĐ-UBND ngày 07/11/2023", "UBND TP Đà Nẵng phê duyệt đồ án quy hoạch phân khu Ven sông Hàn và bờ Đông tỷ lệ 1/2000.", None),
    ("Quy hoạch", "Quyết định 365/QĐ-UBND ngày 11/3/2026", "UBND phường Hòa Xuân phê duyệt điều chỉnh quy hoạch chi tiết 1/500 dự án Khu đô thị sinh thái ven sông Hòa Xuân.", "qd-365-ubnd-2026-dieu-chinh-qhct-1-500.pdf"),
    ("Thiết kế – xây dựng", "Công văn 6979/SXD-CPXD ngày 29/4/2026", "Sở Xây dựng thông báo kết quả thẩm định Báo cáo nghiên cứu khả thi dự án Tòa căn hộ chung cư lô A2-19, A2-20.", "cv-6979-sxd-2026-tham-dinh-bao-cao-kha-thi-cora-tower.pdf"),
    ("Thiết kế – xây dựng", "Quyết định 40/QĐ/2026-SHD ngày 04/5/2026", "Chủ đầu tư phê duyệt thiết kế xây dựng triển khai sau thiết kế cơ sở công trình.", None),
    ("Thiết kế – xây dựng", "Giấy phép xây dựng: thuộc diện miễn", "Theo điểm h khoản 2 Điều 89 Luật Xây dựng 2014 (sửa đổi bởi điểm c khoản 1 Điều 56 Luật Đường sắt 2025).", None),
    ("Bảo lãnh ngân hàng", "Hợp đồng bảo lãnh 01/2026-HĐBL/NHCT106-SHD", "Ký giữa VietinBank – Chi nhánh TP Hà Nội và chủ đầu tư ngày 07/5/2026 cho nhà ở hình thành trong tương lai.", None),
    ("Bảo lãnh ngân hàng", "VietinBank cam kết phát hành thư bảo lãnh", "Văn bản cam kết phát hành thư bảo lãnh nhà ở hình thành trong tương lai ngày 07/5/2026.", "vietinbank-cam-ket-phat-hanh-bao-lanh-cora-tower.pdf"),
    ("Đủ điều kiện bán", "Văn bản 7117/SXD-QLN ngày 05/5/2026", "Sở Xây dựng TP Đà Nẵng về điều kiện nhà ở hình thành trong tương lai đưa vào kinh doanh tại Tòa căn hộ chung cư lô A2-19, A2-20.", "cv-7117-sxd-2026-du-dieu-kien-ban-cora-tower.pdf"),
    ("Hợp đồng", "Thông báo 1737/TB-SCT ngày 09/4/2026", "Sở Công Thương thông báo hoàn thành đăng ký hợp đồng theo mẫu, điều kiện giao dịch chung.", "tb-1737-sct-2026-dang-ky-hop-dong-mau.pdf"),
    ("Thương hiệu", "Thông báo 373-1/2025/TB-SHD ngày 27/9/2025", "Chủ đầu tư thông báo tên thương mại Cora Tower cho nhà chung cư tại lô A2-19, A2-20.", "tb-373-1-shd-2025-ten-thuong-mai-cora-tower.pdf"),
]
FAQ_LEGAL = [
    ("Cora Tower đã đủ điều kiện bán chưa?", "Sở Xây dựng TP Đà Nẵng đã có văn bản 7117/SXD-QLN ngày 05/5/2026 về điều kiện nhà ở hình thành trong tương lai đưa vào kinh doanh tại Tòa căn hộ chung cư lô A2-19, A2-20 (Cora Tower)."),
    ("Cora Tower có bảo lãnh ngân hàng không?", "Có. Chủ đầu tư ký hợp đồng bảo lãnh số 01/2026-HĐBL/NHCT106-SHD với VietinBank – Chi nhánh TP Hà Nội ngày 07/5/2026, kèm văn bản cam kết phát hành thư bảo lãnh."),
    ("Cora Tower có giấy phép xây dựng chưa?", "Công trình thuộc đối tượng miễn giấy phép xây dựng theo điểm h khoản 2 Điều 89 Luật Xây dựng 2014 (sửa đổi bởi điểm c khoản 1 Điều 56 Luật Đường sắt 2025); thiết kế đã được Sở Xây dựng thẩm định (CV 6979/SXD-CPXD)."),
    ("Đất dự án Cora Tower đã có sổ đỏ chưa?", "Đã có. Lô A2-19 (Tòa A1) GCN số DI 103576 và lô A2-20 (Tòa A2) GCN số DI 103577, Sở TN&MT Đà Nẵng cấp ngày 12/4/2023."),
    ("Dự án Cora Tower có đang thế chấp không?", "Theo công bố của chủ đầu tư: không thế chấp tại thời điểm ký hợp đồng mua bán nhà ở."),
]

ICON = {
 "pin": '<path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
 "shield": '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
 "store": '<path d="M3 9l1.5-5h15L21 9"/><path d="M3 9h18v2a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0z"/><path d="M5 13v8h14v-8"/><path d="M10 21v-5h4v5"/>',
 "crown": '<path d="M3 7l4 4 5-6 5 6 4-4-2 11H5z"/><path d="M5 21h14"/>',
 "pool": '<path d="M2 18c2 0 2-1.5 4-1.5S8 18 10 18s2-1.5 4-1.5 2 1.5 4 1.5 2-1.5 4-1.5"/><path d="M8 14V5a2 2 0 0 1 4 0M16 14V5a2 2 0 0 0-4 0M8 9h8"/>',
 "dumbbell": '<path d="M6 7v10M18 7v10M3 10v4M21 10v4M6 12h12"/>',
 "kid": '<circle cx="12" cy="6" r="3"/><path d="M12 9v6M8 12h8M9 21l3-6 3 6"/>',
 "leaf": '<path d="M5 19c0-9 6-14 15-14 0 9-5 15-14 15"/><path d="M5 19l7-7"/>',
 "ceiling": '<path d="M12 3v18M8 7l4-4 4 4M8 17l4 4 4-4"/>',
 "eye": '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
 "people": '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3 20c0-3.5 2.7-6 6-6s6 2.5 6 6M15 14.5c3 0 6 2 6 5.5"/>',
 "chart": '<path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 6-6"/>',
 "layers": '<path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/>',
 "book": '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M4 20.5A2.5 2.5 0 0 0 6.5 23H20v-5"/><path d="M8 7h8M8 11h6"/>',
 "office": '<path d="M4 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/><path d="M16 9h2a2 2 0 0 1 2 2v10"/><path d="M8 7h4M8 11h4M8 15h4M3 21h18"/>',
 "spa": '<path d="M12 21c-4.5 0-8-3-8-7 3 0 6 1.5 8 4 2-2.5 5-4 8-4 0 4-3.5 7-8 7z"/><path d="M12 18c-1.8-2.2-2.5-4.6-2-7.5C10.6 7.8 12 5.5 12 5.5s1.4 2.3 2 5c.5 2.9-.2 5.3-2 7.5z"/>',
 "golf": '<path d="M7 21V3l9 4-9 4"/><path d="M4 21h12"/><circle cx="18" cy="18" r="2"/>',
 "phone": '<path d="M5 3h4l2 5-2.5 1.5a11 11 0 0 0 6 6L16 13l5 2v4a2 2 0 0 1-2 2A17 17 0 0 1 3 5a2 2 0 0 1 2-2z"/>',
 "mail": '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
 "chat": '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/>',
 "arrow": '<path d="M5 12h14M13 6l6 6-6 6"/>',
 "key": '<circle cx="8" cy="15" r="4"/><path d="M11 12l9-9M17 6l3 3"/>',
}


def icon(k):
    return f'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{ICON[k]}</svg>'


def card(k, title, text):
    return f'<div class="card reveal"><div class="icon">{icon(k)}</div><h3>{title}</h3><p class="sub">{text}</p></div>'


LOGO = ('<svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect x="5" y="6" width="8" height="21" rx="1.5" fill="#0b2a5b"/>'
        '<rect x="16" y="3" width="9" height="24" rx="1.5" fill="#f26b1d"/><rect x="2" y="26" width="26" height="2.5" rx="1" fill="#0b2a5b"/></svg>')

NAV = [("./", "Tổng quan", "index"), ("./#mat-bang", "Mặt bằng", ""), ("./#gia", "Bảng giá", ""),
       ("khoi-de-shophouse.html", "Shophouse", "shop"), ("penthouse.html", "Duplex – Penthouse", "ph"), ("./#tien-ich", "Tiện ích", ""), ("./#vi-tri", "Vị trí", ""), ("phap-ly.html", "Pháp lý", "legal")]


# ----------------------------------------------------------------- head
def head(page, title, desc, keywords, og_img, og_alt, preload_key, graph):
    url = D if page == "index" else f"{D}{page}.html"
    agent = {
        "@type": "RealEstateAgent", "@id": f"{D}#agent", "name": AGENT, "url": D,
        "telephone": TEL_INTL, "email": EMAIL, "areaServed": "Đà Nẵng",
        "address": {"@type": "PostalAddress", "addressLocality": "Đà Nẵng", "addressCountry": "VN"},
    }
    ld = json.dumps({"@context": "https://schema.org", "@graph": [agent] + graph}, ensure_ascii=False, indent=1)
    n, w, h, s, _ = IMG[preload_key]
    return f'''<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<script>document.documentElement.classList.add('js')</script>
<title>{title}</title>
<meta name="description" content="{desc}">
<meta name="keywords" content="{keywords}">
<link rel="canonical" href="{url}">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="theme-color" content="#0b2a5b">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:site_name" content="Cora Tower Đà Nẵng">
<meta property="og:title" content="{title}">
<meta property="og:description" content="{desc}">
<meta property="og:url" content="{url}">
<meta property="og:image" content="{D}assets/{og_img}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{og_alt}">
<meta name="twitter:card" content="summary_large_image">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800&family=Cormorant+Garamond:ital,wght@1,600&display=swap" rel="stylesheet">
<link rel="preload" as="image" type="image/webp" href="assets/img/{n}.webp" imagesrcset="assets/img/{n}-{s}.webp {s}w, assets/img/{n}.webp {w}w" imagesizes="100vw" fetchpriority="high">
<link rel="stylesheet" href="assets/style.css">
<script type="application/ld+json">
{ld}
</script>
</head>'''


# ----------------------------------------------------------------- blocks
def header(cur, cta):
    nav = "".join(f'<a href="{h}"' + (' aria-current="page"' if k == cur else "") + f'>{t}</a>' for h, t, k in NAV)
    return f'''<div class="topbar">Đang nhận đăng ký giỏ hàng căn hộ · shophouse · duplex Cora Tower — Hotline/Zalo <a href="tel:{TEL}">{TEL_TXT}</a></div>
<header class="site-head">
  <div class="wrap">
    <a class="logo" href="./" aria-label="Cora Tower – Trang chủ">{LOGO}CORA <span>TOWER</span></a>
    <nav class="nav" aria-label="Điều hướng chính">{nav}</nav>
    <a class="btn head-cta" href="tel:{TEL}" aria-label="Gọi tư vấn">{PHONE_SVG}Gọi ngay</a>
    <a class="btn head-cta-alt" href="#dang-ky">{cta}</a>
  </div>
</header>'''


def form(interest=None, button="Nhận bảng giá ngay"):
    sel = (f'<input type="hidden" name="interest" value="{interest}">' if interest else
           '<select name="interest" aria-label="Sản phẩm quan tâm"><option>Căn hộ 1PN+</option><option>Studio</option>'
           '<option>2PN – 3PN</option><option>Shophouse khối đế</option><option>Duplex – Penthouse</option></select>')
    return f'''<form class="lead">
          <input name="name" placeholder="Họ và tên" required autocomplete="name" aria-label="Họ và tên">
          <input name="phone" type="tel" placeholder="Số điện thoại / Zalo" required autocomplete="tel" aria-label="Số điện thoại">
          {sel}
          <button class="btn lg" type="submit">{button}</button>
          <div class="form-msg" role="status"></div>
        </form>'''


def hero_form(title, text, interest=None, button="Nhận bảng giá ngay"):
    return f'''<aside class="hero-form">
        <h2>{title}</h2>
        <p>{text}</p>
        {form(interest, button)}
        <small>Hoặc gọi/Zalo ngay <a href="tel:{TEL}">{TEL_TXT}</a> · Thông tin được bảo mật.</small>
      </aside>'''


def stats(items):
    cells = "".join(f'<div class="stat"><b data-count="{n}" data-suffix="{suf}">{disp}</b><span>{lab}</span></div>' for n, suf, disp, lab in items)
    return f'<div class="stats"><div class="wrap"><div>{cells}</div></div></div>'


def faq(items):
    return "\n".join(f'      <details><summary>{q}</summary><p>{a}</p></details>' for q, a in items)


def faq_ld(items):
    return {"@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}} for q, a in items]}


def crumbs(name, url):
    return {"@type": "BreadcrumbList", "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Cora Tower", "item": D},
        {"@type": "ListItem", "position": 2, "name": name, "item": url}]}


def lead_section(title, text, interest=None, button="Gửi thông tin"):
    return f'''<section id="dang-ky">
    <div class="wrap">
      <div class="lead-box reveal">
        <span class="kicker">Ưu tiên khách đăng ký sớm</span>
        <h2>{title}</h2>
        <p>{text}</p>
        {form(interest, button)}
        <p class="lead-alt">Cần gấp? Gọi/Zalo <a href="tel:{TEL}">{TEL_TXT}</a> · Email <a href="mailto:{EMAIL}">{EMAIL}</a></p>
      </div>
    </div>
  </section>'''


def faq_section(title, items, extra=""):
    return f'''<section class="alt" id="faq">
    <div class="wrap" style="max-width:860px">
      <div class="center reveal"><span class="kicker">Hỏi đáp</span><h2>{title}</h2></div>
{faq(items)}
      {extra}
    </div>
  </section>'''


PHONE_SVG = '<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.6a1 1 0 0 1-.25 1z"/></svg>'
CHAT_SVG = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/><path d="M8.5 11h.01M12 11h.01M15.5 11h.01"/></svg>'

FOOTER = f'''<footer>
  <div class="wrap foot">
    <div class="foot-brand">
      <div class="wordmark proj"><span>Cora</span><small>Tower</small></div>
      <p>Cora Tower – hai tòa căn hộ biểu tượng khối mái cam của Sun Group tại vòng xoay 29/3, trung tâm khu đô thị Sun Neo City Đà Nẵng.</p>
    </div>
    <div class="foot-col">
      <span class="foot-label">Địa chỉ dự án</span>
      <p>Vòng xoay 29/3 – Nguyễn Phước Lan,<br>phường Hòa Xuân, TP. Đà Nẵng</p>
      <a class="map-link" href="{MAPS}" target="_blank" rel="noopener">{icon("pin")}Chỉ đường Google Maps ↗</a>
    </div>
    <div class="foot-col">
      <span class="foot-label">Tư vấn &amp; bán hàng</span>
      <p class="agent">{AGENT_TITLE}</p>
      <a class="contact-row" href="tel:{TEL}"><i>{icon("phone")}</i><span><small>Hotline</small><b>{TEL_TXT}</b></span></a>
      <a class="contact-row" href="{ZALO}" target="_blank" rel="noopener nofollow"><i>{icon("chat")}</i><span><small>Zalo</small><b>{TEL_TXT}</b></span></a>
      <a class="contact-row" href="mailto:{EMAIL}"><i>{icon("mail")}</i><span><small>Email</small><b>{EMAIL}</b></span></a>
    </div>
    <nav class="foot-links" aria-label="Liên kết Cora Tower">
      <a href="./">Tổng quan</a><a href="./#mat-bang">Mặt bằng</a><a href="./#gia">Bảng giá</a><a href="khoi-de-shophouse.html">Shophouse</a>
      <a href="penthouse.html">Penthouse</a><a href="phap-ly.html">Pháp lý</a><a href="can-ho-sun-da-nang.html">Căn hộ Sun Đà Nẵng</a>
    </nav>
    <div class="legal">Trang thông tin dự án do Giám đốc kinh doanh Hoàng Phạm Đình Hiệp cung cấp, không phải website chính thức của chủ đầu tư. Hình ảnh phối cảnh, mặt bằng mang tính minh họa. Thông tin, giá bán và chính sách có thể thay đổi theo quy định của chủ đầu tư tại từng thời điểm. Cập nhật lần cuối: {UPDATED}.</div>
  </div>
</footer>

<div class="fab" aria-label="Liên hệ nhanh">
  <a class="fab-call" href="tel:{TEL}" aria-label="Gọi tư vấn">{PHONE_SVG}</a>
  <a class="fab-zalo" href="{ZALO}" target="_blank" rel="noopener nofollow" aria-label="Chat Zalo {TEL_TXT}">Zalo</a>
  <button class="fab-chat" type="button" aria-label="Mở chat tư vấn" data-chat-open>{CHAT_SVG}<i class="dot"></i></button>
</div>
<nav class="float-cta" aria-label="Liên hệ nhanh trên điện thoại">
  <a href="tel:{TEL}" class="fc-call">{PHONE_SVG}Gọi ngay</a>
  <a href="{ZALO}" target="_blank" rel="noopener nofollow" class="fc-zalo"><b>Zalo</b>Nhắn Zalo</a>
  <button type="button" class="fc-chat" data-chat-open>{CHAT_SVG}Tư vấn</button>
</nav>

<div class="chat" id="chat" hidden>
  <div class="chat-head">
    <div class="chat-ava">{LOGO}</div>
    <div><b>Tư vấn Cora Tower</b><small><i class="dot"></i> Trực tuyến · phản hồi ngay</small></div>
    <button type="button" class="chat-x" aria-label="Đóng chat" data-chat-close>×</button>
  </div>
  <div class="chat-body" aria-live="polite"></div>
  <div class="chat-chips"></div>
  <form class="chat-input" autocomplete="off">
    <input type="text" placeholder="Nhập câu hỏi hoặc số điện thoại…" aria-label="Tin nhắn">
    <button type="submit" aria-label="Gửi"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 20l18-8L3 4v6l12 2-12 2z"/></svg></button>
  </form>
</div>
<div class="chat-teaser" hidden><button type="button" class="t-x" aria-label="Ẩn">×</button><p data-chat-open><small>Tư vấn trực tuyến</small><b>Nhận bảng giá &amp; giỏ hàng mới nhất</b></p></div>

<script>window.CORA = {{ tel: "{TEL}", telText: "{TEL_TXT}", zalo: "{ZALO}", email: "{EMAIL}" }};</script>
<script src="assets/main.js" defer></script>
<script src="assets/chat.js" defer></script>'''

LIGHTBOX = '<div class="lightbox" role="dialog" aria-label="Xem ảnh"><button type="button" aria-label="Đóng">×</button><img alt=""></div>'


def uplan(key, title, size):
    return (f'<figure class="zoom reveal"><a href="{src(key)}" class="zoom-link">{pic(key, "(max-width:760px) 100vw, 360px")}'
            f'<span class="zoom-hint">Phóng to</span></a><figcaption><b>{title}</b><span>Kích thước {size}</span></figcaption></figure>')


def plan_tabs():
    tabs = [("plan-a1", "Tòa A1 · tầng 3A–24", "planA1"), ("plan-a2", "Tòa A2 · tầng 3A–24", "planA2"),
            ("plan-g1", "Tòa A1 · tầng 3 sân vườn", "g3A1"), ("plan-g2", "Tòa A2 · tầng 3 sân vườn", "g3A2")]
    btn = "".join(f'<button role="tab" aria-selected="{"true" if i == 0 else "false"}" data-tab="{t}">{l}</button>' for i, (t, l, _) in enumerate(tabs))
    panes = "".join(f'<div class="plan zoom" id="{t}"{"" if i == 0 else " hidden"}><a href="{src(k)}" class="zoom-link">{pic(k, "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>'
                    for i, (t, _, k) in enumerate(tabs))
    return (f'<div class="tabs reveal" role="tablist">{btn}</div>{panes}'
            '<p class="note">Tầng 3A–24 mỗi tòa 28 căn/sàn, có mã căn và diện tích (thông thủy / tim tường). Tầng 3 là căn hộ sân vườn, ghi thêm diện tích sân vườn (DTSV). '
            'Thông số chính thức theo văn bản ký kết với khách hàng.</p>')


def units_table():
    rows = "".join(f"<tr><td><b>{t}</b></td><td>{a}</td><td>{b}</td><td>{c}</td></tr>" for t, a, b, c in UNIT_TYPES)
    return f'''<div class="table-wrap reveal"><table>
          <thead><tr><th>Loại căn</th><th>DT thông thủy</th><th>DT tim tường</th><th>Phù hợp</th></tr></thead>
          <tbody>{rows}</tbody></table></div>'''


def price_table():
    rows = "".join(f'<tr><td>{a}</td><td>{b}</td><td class="price">{c}</td><td><a href="#dang-ky">Giữ căn →</a></td></tr>' for a, b, c in PRICES)
    return f'''<div class="table-wrap reveal"><table>
          <thead><tr><th>Căn 1PN+ tầng 15</th><th>Mã căn</th><th>Giá dự kiến / căn</th><th></th></tr></thead>
          <tbody>{rows}
            <tr><td>Studio · 2PN · 3PN</td><td>Theo tầng, hướng</td><td class="price">Liên hệ</td><td><a href="#dang-ky">Nhận giá →</a></td></tr>
            <tr><td>Shophouse khối đế</td><td>Tầng 1 · 43 – 61,5 m²</td><td class="price">4,96 – 6,04 tỷ</td><td><a href="khoi-de-shophouse.html">Chi tiết →</a></td></tr>
          </tbody></table></div>
      <p class="note">Giá 1PN+ tầng 15 là thông tin thị trường (giá trần đã gồm VAT + phí bảo trì, theo chính sách bán hàng), chưa phải bảng giá chính thức. Giá các tầng khác chênh lệch theo tầng và hướng. Bảng giá, chính sách chính thức theo công bố của chủ đầu tư.</p>'''


# ----------------------------------------------------------------- INDEX
def build_index():
    graph = [
        {"@type": "ApartmentComplex", "@id": f"{D}#project", "name": "Cora Tower Đà Nẵng", "alternateName": "Sun Cora Tower",
         "description": "Tổ hợp 2 tòa tháp A1, A2 cao 25 tầng với khoảng 1.342 căn hộ: studio, 1PN+, 2PN, 3PN, căn hộ sân vườn, duplex và shophouse khối đế tại vòng xoay 29/3 – Nguyễn Phước Lan, Nam Hòa Xuân, Đà Nẵng.",
         "url": D, "numberOfAccommodationUnits": 1342,
         "image": [f"{D}{src(k)}" for k in ("rTwin", "aHan", "aSea", "rBridge", "rPool", "rJjim", "vSun", "hero", "a1a2", "night", "aerial", "struct", "site", "planA1", "planA2", "unit1pn", "iso1pn", "amA1", "amA2")],
         "address": {"@type": "PostalAddress", "streetAddress": "Vòng xoay đường 29/3 – Nguyễn Phước Lan, KĐT Nam Hòa Xuân", "addressLocality": "Đà Nẵng", "addressCountry": "VN"},
         "amenityFeature": [{"@type": "LocationFeatureSpecification", "name": n, "value": True} for n in ("Hồ bơi", "Jjimjilbang & Spa", "Gym", "Golf mô phỏng", "Khu trẻ em", "Thư viện", "Sinh hoạt cộng đồng", "Shophouse thương mại", "Hầm để xe")]},
        faq_ld(FAQ_INDEX),
    ]
    h = head("index", "Cora Tower Đà Nẵng – Căn hộ Sun Group vòng xoay 29/3 | Bảng giá, mặt bằng 2026",
             "Cora Tower (Sun Group) – 2 tòa A1, A2 cao 25 tầng tại vòng xoay 29/3 – Nguyễn Phước Lan, Hòa Xuân. Căn 1PN+ tầng 15 từ ~3,1 tỷ, mặt bằng 28 căn/sàn, shophouse khối đế, duplex tầng 25. Gọi 0904 567 009.",
             "Cora Tower, Sun Cora Tower, Cora Tower Đà Nẵng, giá Cora Tower, mặt bằng Cora Tower, căn hộ 1PN+ Cora Tower, shophouse Cora Tower, duplex Cora Tower, căn hộ 29/3 Hòa Xuân",
             "og-cora-tower.jpg", "Phối cảnh Cora Tower Đà Nẵng", "rTwin", graph)
    body = f'''{header("index", "Nhận bảng giá")}

<main>
  <section class="hero">
    {pic("rTwin", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap hero-grid">
      <div>
        <span class="eyebrow">Sun Neo City · Vòng xoay 29/3 · Đà Nẵng</span>
        <h1>Cora Tower – <em>biểu tượng sống mới</em> bên sông Đà Nẵng</h1>
        <p class="lead">Hai tòa tháp A1 – A2 cao 25 tầng với khối mái kiến trúc màu cam đặc trưng, ngay vòng xoay 29/3 – Nguyễn Phước Lan. Căn hộ 1PN+ tầng 15 chỉ từ khoảng <b>3,1 tỷ</b>.</p>
        <ul class="ticks"><li>Chủ đầu tư Sun Group</li><li>Đủ điều kiện bán – có bảo lãnh</li><li>28 căn/sàn – nhiều lựa chọn</li></ul>
        <div class="cta">
          <a class="btn lg" href="#gia">Xem bảng giá</a>
          <a class="btn ghost lg" href="tel:{TEL}">Gọi {TEL_TXT}</a>
        </div>
      </div>
      {hero_form("Nhận bảng giá &amp; giỏ hàng", "Mặt bằng, giá từng căn và chính sách bán hàng gửi qua Zalo trong 5 phút.")}
    </div>
  </section>
  {stats([(2, "", "2", "tòa tháp A1 &amp; A2"), (25, "", "25", "tầng nổi"), (1342, "", "1.342", "căn hộ"), (28, "", "28", "căn mỗi sàn")])}

  <section>
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Vì sao chọn Cora Tower</span>
        <h2>Tổng quan dự án Cora Tower</h2>
        <p class="sub">Tổ hợp căn hộ – thương mại dịch vụ ngay cửa ngõ khu đô thị Nam Hòa Xuân, nơi hội tụ vị trí, pháp lý và mức giá còn dễ tiếp cận.</p>
      </div>
      <div class="grid g4" style="margin-top:36px">
        {card("pin", "Vị trí vòng xoay", "Góc vòng xoay 29/3 – Nguyễn Phước Lan, trục giao thông chính Nam Hòa Xuân.")}
        {card("shield", "Sun Group phát triển", "Công ty CP Tập đoàn Mặt Trời. Đất đã có sổ đỏ, Sở Xây dựng xác nhận đủ điều kiện bán.")}
        {card("layers", "Đủ loại hình", "Studio, 1PN+, 2PN, 3PN, căn sân vườn, duplex tầng 25 và shophouse.")}
        {card("chart", "Giá dễ tiếp cận", "1PN+ tầng 15 khoảng 3,1–3,85 tỷ/căn – phù hợp ở thực và cho thuê.")}
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap split">
      <div class="split-media reveal zoom"><a href="{src("struct")}" class="zoom-link">{pic("struct", "(max-width:900px) 100vw, 600px")}</a></div>
      <div class="reveal">
        <span class="kicker">Cấu trúc tòa</span>
        <h2>5 tầng công năng rõ ràng</h2>
        <div class="floors">
          <div class="fl fl-25"><b>Tầng 25</b><span>Căn hộ duplex – penthouse</span></div>
          <div class="fl fl-4"><b>Tầng 4 – 24</b><span>Căn hộ điển hình: Studio, 1PN+, 2PN, 3PN</span></div>
          <div class="fl fl-3"><b>Tầng 3</b><span>Căn hộ sân vườn</span></div>
          <div class="fl fl-2"><b>Tầng 2</b><span>Dịch vụ – tiện ích</span></div>
          <div class="fl fl-1"><b>Tầng 1</b><span>Shophouse thương mại</span></div>
        </div>
      </div>
    </div>
  </section>

  <section id="mat-bang">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Mặt bằng</span>
        <h2>Mặt bằng tòa A1 – A2 có mã căn</h2>
        <p class="sub">Mỗi tòa 28 căn/sàn, hành lang giữa, 2 lõi thang. Xem cả tầng 3 căn hộ sân vườn – bấm vào mặt bằng để phóng to từng mã căn.</p>
      </div>
      {plan_tabs()}
      <h3 style="margin-top:40px" class="reveal">Diện tích các loại căn</h3>
      {units_table()}
      <div class="split" style="margin-top:56px">
        <div class="split-media reveal zoom"><a href="{src("site")}" class="zoom-link">{pic("site", "(max-width:900px) 100vw, 600px")}</a></div>
        <div class="reveal">
          <span class="kicker">Tổng mặt bằng</span>
          <h3 style="font-size:1.5rem">Hai tòa đối xứng hai bên đường 29/3</h3>
          <p class="sub">Hai tòa tháp ôm hai bên trục đường 29/3, mặt chính hướng ra vòng xoay Nguyễn Phước Lan. Căn 3PN nằm ở đầu hồi phía vòng xoay, căn 2PN ở các góc, 1PN+ và Studio xen giữa hành lang.</p>
          <ul class="legend"><li><i style="background:#f48fc6"></i>3PN</li><li><i style="background:#a6e05a"></i>2PN</li><li><i style="background:#bfe3f2"></i>1PN+</li><li><i style="background:#f7c9a8"></i>Studio</li></ul>
        </div>
      </div>
      <figure class="shot zoom reveal"><a href="{src("siteAir")}" class="zoom-link">{pic("siteAir", "(max-width:1180px) 100vw, 1148px")}</a><figcaption>Tổng mặt bằng trên ảnh flycam thực tế khu đất</figcaption></figure>
    </div>
  </section>

  <section class="alt" id="can-ho">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Căn hộ mẫu</span>
        <h2>Căn hộ 1PN+ – căng tràn cảm hứng</h2>
        <p class="sub">Dòng căn chủ lực của Cora Tower: 53,8 m² thông thủy, bố trí 1 phòng ngủ chính + 1 phòng linh hoạt (làm việc, phòng trẻ, phòng khách), logia rộng 1,6 m.</p>
      </div>
      <div class="unit-grid">
        <figure class="zoom reveal"><a href="{src("unit1pn")}" class="zoom-link">{pic("unit1pn", "(max-width:900px) 100vw, 380px")}</a><figcaption>Mặt bằng căn A10803 – 1PN+1, tòa A1</figcaption></figure>
        <figure class="zoom reveal"><a href="{src("iso1pn")}" class="zoom-link">{pic("iso1pn", "(max-width:900px) 100vw, 380px")}</a><figcaption>Phối cảnh 3D bố trí nội thất</figcaption></figure>
        <div class="reveal unit-info">
          <h3>Thông số căn A10803</h3>
          <ul class="check">
            <li>Kích thước 6,2 m × 9,6 m (tim tường)</li>
            <li>Phòng khách + bếp, bàn ăn liên thông</li>
            <li>Phòng ngủ 1 – 4,1 m chiều sâu</li>
            <li>Phòng ngủ 2 / phòng linh hoạt</li>
            <li>Vệ sinh, logia 1,6 m có chỗ máy giặt</li>
            <li>Giá dự kiến tầng 15: 3,1 – 3,85 tỷ</li>
          </ul>
          <a class="btn" href="#dang-ky">Nhận mặt bằng các căn</a>
          {pic("int1pn", "(max-width:900px) 100vw, 380px", cls="unit-thumb")}
        </div>
      </div>
      <div class="center reveal" style="margin-top:64px"><span class="kicker">Căn hộ điển hình</span><h2 style="font-size:clamp(1.5rem,2.6vw,2rem)">Mặt bằng các căn điển hình</h2><p class="sub">Chọn loại căn để xem bố trí, kích thước và vị trí trên sàn. Bấm vào ảnh để phóng to.</p></div>
      <div class="tabs reveal" role="tablist">
        <button role="tab" aria-selected="true" data-tab="u-stu">Studio</button>
        <button role="tab" aria-selected="false" data-tab="u-1pn">1PN+</button>
        <button role="tab" aria-selected="false" data-tab="u-2pn">2PN</button>
      </div>
      <div class="unit-plans" id="u-stu">{uplan("pA10823","A10823 · Studio · Tòa A1","3,8 × 9,6 m")}</div>
      <div class="unit-plans" id="u-1pn" hidden>{uplan("unit1pn","A10803 · 1PN+1 · Tòa A1","6,2 × 9,6 m")}{uplan("pA10828","A10828 · 1PN+1 · Tòa A1","5,4 × 11,9 m")}</div>
      <div class="unit-plans" id="u-2pn" hidden>{uplan("pA10801","A10801 · 2PN góc · Tòa A1","8,7 × 11,4 m")}{uplan("pA10805","A10805 · 2PN · 2 WC · Tòa A1","7,6 × 9,6 m")}{uplan("pA10817","A10817 · 2PN góc · Tòa A1","8,9 × 9,5 m")}{uplan("pA20827","A20827 · 2PN · Tòa A2","8,8 × 11,4 m")}</div>
    </div>
  </section>

  <section id="tien-ich">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Tiện ích</span>
        <h2>Tầng 2 tiện ích riêng cho cư dân mỗi tòa</h2>
        <p class="sub">Toàn bộ tầng 2 dành cho tiện ích nội khu – hồ bơi, spa, khu trẻ em, thư viện… chỉ cách căn hộ một chuyến thang máy.</p>
      </div>
      <div class="grid g4" style="margin-top:30px">
        {card("pool", "Hồ bơi tầng 2", "Hồ bơi người lớn và hồ trẻ em, sân deck tắm nắng – có ở cả hai tòa.")}
        {card("spa", "Jjimjilbang &amp; Spa", "Xông hơi kiểu Hàn Quốc và spa (tòa A1), spa thư giãn (tòa A2).")}
        {card("golf", "Gym &amp; golf mô phỏng", "Phòng gym và phòng golf mô phỏng 3 làn tại tòa A2.")}
        {card("kid", "Khu trẻ em", "Sân chơi trong nhà, khu vui chơi kết nối gia đình (bi-a, bàn chơi).")}
        {card("people", "Sinh hoạt cộng đồng", "Không gian sinh hoạt chung, tiệc nhỏ, gặp gỡ cư dân.")}
        {card("book", "Thư viện", "Thư viện – góc đọc, làm việc yên tĩnh ngay trong tòa nhà.")}
        {card("office", "Văn phòng BQL", "Ban quản lý, kỹ thuật, kho hồ sơ đặt tại tầng 2 – hỗ trợ cư dân nhanh.")}
        {card("store", "Shophouse tầng 1", "Cafe, cửa hàng, dịch vụ ngay chân tòa tháp.")}
      </div>
      <div class="grid g2" style="margin-top:28px">
        <figure class="shot reveal" style="margin:0"><a href="{src("rPool")}" class="zoom-link">{pic("rPool", "(max-width:760px) 100vw, 560px")}</a><figcaption>Hồ bơi trong nhà tầng 2</figcaption></figure>
        <figure class="shot reveal" style="margin:0"><a href="{src("rJjim")}" class="zoom-link">{pic("rJjim", "(max-width:760px) 100vw, 560px")}</a><figcaption>Jjimjilbang – xông hơi kiểu Hàn Quốc</figcaption></figure>
      </div>
      <div class="tabs reveal" role="tablist" style="margin-top:36px">
        <button role="tab" aria-selected="true" data-tab="am-a1">Tiện ích tòa A1</button>
        <button role="tab" aria-selected="false" data-tab="am-a2">Tiện ích tòa A2</button>
      </div>
      <div class="plan" id="am-a1"><a href="{src("amA1")}" class="zoom-link">{pic("amA1", "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>
      <div class="plan" id="am-a2" hidden><a href="{src("amA2")}" class="zoom-link">{pic("amA2", "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>
    </div>
  </section>

  <section id="chinh-sach">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Chính sách bán hàng</span><h2>Chính sách căn hộ Cora Tower tòa A1 – A2</h2>
        <p class="sub">Chính sách ưu đãi CSƯĐ 06.1 áp dụng từ 21/08/2026 đến khi có chính sách mới. Ví dụ: căn studio 30,2 m² tòa A2 niêm yết khoảng 2,11 tỷ, còn khoảng 1,86 tỷ khi áp dụng chiết khấu 7% + 5% không vay*.</p></div>
      <div class="policy reveal">
        <div><b>7%</b><span>Chiết khấu “Đặc quyền hoàn thiện nội thất”</span></div>
        <div><b>5%</b><span>Chiết khấu không vay</span></div>
        <div><b>40</b><span>tháng giãn tiến độ (70% – 30%) khi không vay</span></div>
        <div><b>70%</b><span>Sun Early Key – nhận nhà dự kiến 31/10/2027</span></div>
        <div><b>70%</b><span>vay tối đa, hỗ trợ lãi suất đến 24 tháng</span></div>
        <div><b>8%</b><span>/năm ưu đãi cho khoản thanh toán sớm</span></div>
        <div><b>1</b><span>năm miễn phí dịch vụ quản lý</span></div>
        <div><b>100tr</b><span>đặt cọc ký HĐTHNV (3PN 150tr, penthouse 300tr)</span></div>
      </div>
      <p class="note">* Giá đã gồm VAT và kinh phí bảo trì, tạm tính. Hỗ trợ lãi suất tính từ ngày giải ngân đầu tiên, không muộn hơn 30/09/2028; ưu đãi thanh toán sớm không áp dụng đồng thời với hỗ trợ lãi suất. Khách mua mới còn được tích điểm chương trình Sun Signature của Sun Group. Chủ đầu tư có quyền thay đổi chính sách; liên hệ để nhận phiếu tính giá từng căn.</p>
    </div>
  </section>

  <section class="alt" id="gia">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Bảng giá</span>
        <h2>Giá căn hộ Cora Tower tham khảo</h2>
        <p class="sub">Căn 1PN+ diện tích 53,8 m² thông thủy (58,9 m² tim tường) tại tầng 15.</p>
      </div>
      <div style="margin-top:24px">{price_table()}</div>
      <div class="center" style="margin-top:26px"><a class="btn lg" href="#dang-ky">Nhận bảng giá đầy đủ các tầng</a></div>
    </div>
  </section>

  <section>
    <div class="wrap split">
      <div class="split-media reveal">
        {pic("rPod", "(max-width:900px) 100vw, 600px")}
        <div class="badge">4,96 – 6,04 tỷ<small>shophouse 43 – 61,5 m²</small></div>
      </div>
      <div class="reveal">
        <span class="kicker">Tầng 1 · Khối đế</span>
        <h2>Shophouse khối đế – kinh doanh ngay chân tòa tháp</h2>
        <p class="sub">Mặt tiền vòng xoay 29/3 – Nguyễn Phước Lan, mặt kính lớn kịch trần. Lượng khách sẵn có từ cư dân hai tòa tháp và dòng người qua lại cửa ngõ phía Nam.</p>
        <ul class="check">
          <li>Phù hợp cafe, F&amp;B, showroom, thời trang, spa, phòng khám</li>
          <li>Tự kinh doanh hoặc cho thuê tạo dòng tiền</li>
          <li>Sở hữu lâu dài, trần ~7 m làm được tầng lửng</li>
        </ul>
        <a class="btn" href="khoi-de-shophouse.html">Khám phá shophouse →</a>
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap split rev">
      <div class="split-media reveal">
        {pic("ph", "(max-width:900px) 100vw, 600px")}
        <div class="badge">Tầng 25<small>duplex · số lượng giới hạn</small></div>
      </div>
      <div class="reveal">
        <span class="kicker">Tầng 25 · Duplex</span>
        <h2>Duplex – Penthouse trong khối mái biểu tượng</h2>
        <p class="sub">Những căn duplex tầng cao nhất, nằm trong khối kiến trúc màu cam đặc trưng của hai tòa tháp – không gian thông tầng, sân vườn trên cao và tầm nhìn toàn cảnh sông, thành phố.</p>
        <ul class="check">
          <li>Trần cao ~7 m, làm thêm tầng lửng thành duplex</li>
          <li>Riêng tư tuyệt đối ở tầng cao nhất</li>
          <li>Sản phẩm khan hiếm, giữ giá trị dài hạn</li>
        </ul>
        <a class="btn" href="penthouse.html">Khám phá duplex – penthouse →</a>
      </div>
    </div>
  </section>

  <section id="vi-tri">
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Vị trí</span>
        <h2>Vòng xoay 29/3 – kết nối mọi hướng</h2>
        <p class="sub">Hai tòa A1, A2 đứng ngay vòng xoay giao đường 29/3 và Nguyễn Phước Lan – cửa ngõ phía Nam trung tâm Đà Nẵng.</p>
        <ul class="check">{"".join(f"<li>{c}</li>" for c in CONNECT)}</ul>
      </div>
      <div class="split-media reveal zoom"><a href="{src("cross")}" class="zoom-link">{pic("cross", "(max-width:900px) 100vw, 600px")}</a></div>
    </div>
    <div class="wrap reveal" style="margin-top:36px">
      <iframe title="Bản đồ vị trí Cora Tower Đà Nẵng" src="https://www.google.com/maps?q=29%2F3+Nguy%E1%BB%85n+Ph%C6%B0%E1%BB%9Bc+Lan+H%C3%B2a+Xu%C3%A2n+%C4%90%C3%A0+N%E1%BA%B5ng&amp;output=embed" width="100%" height="360" style="border:0;border-radius:20px;box-shadow:var(--shadow)" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

  <section class="alt" id="phap-ly">
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Pháp lý</span>
        <h2>Pháp lý đầy đủ – đã đủ điều kiện bán</h2>
        <ul class="legal-list">
          <li><b>Sổ đỏ từng lô</b><span>DI 103576 (A2-19 · Tòa A1), DI 103577 (A2-20 · Tòa A2), cấp 12/4/2023</span></li>
          <li><b>Đủ điều kiện bán</b><span>Văn bản 7117/SXD-QLN ngày 05/5/2026 của Sở Xây dựng</span></li>
          <li><b>Bảo lãnh ngân hàng</b><span>VietinBank – HĐ 01/2026-HĐBL/NHCT106-SHD ngày 07/5/2026</span></li>
          <li><b>Hợp đồng mẫu</b><span>Đã đăng ký tại Sở Công Thương (TB 1737/TB-SCT)</span></li>
          <li><b>Thiết kế</b><span>Sở Xây dựng thẩm định (6979/SXD-CPXD); miễn GPXD theo luật</span></li>
          <li><b>Không thế chấp</b><span>tại thời điểm ký hợp đồng mua bán</span></li>
        </ul>
        <a class="btn" href="phap-ly.html">Xem &amp; tải toàn bộ hồ sơ pháp lý →</a>
      </div>
      <div class="reveal">
        <div class="card legal-card">
          <div class="icon">{icon("shield")}</div>
          <h3>Chủ đầu tư</h3>
          <p class="sub"><b>{DEVELOPER["name"]}</b> ({DEVELOPER["short"]})<br>MST: {DEVELOPER["tax"]}<br>{DEVELOPER["addr"]}</p>
          <h3 style="margin-top:18px">Quy mô chính thức</h3>
          <p class="sub">Tòa A1 (lô A2-19): 672 căn · Tòa A2 (lô A2-20): 670 căn<br>25 tầng nổi + tum, 2 tầng hầm, cao 97,95 m</p>
        </div>
      </div>
    </div>
  </section>

  <section class="dark" id="view">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Tầm nhìn</span><h2>View từ căn hộ Cora Tower</h2>
        <p class="sub">Đứng giữa khu đô thị thấp tầng nên tầm nhìn từ các căn rất thoáng: về sông Hàn, vòng quay Sun Wheel và trung tâm thành phố, về biển hoặc trọn khu đô thị Sun Neo City.</p></div>
      <div class="view-grid">
        {"".join(f'<a class="reveal" href="{src(k)}">{pic(k, "(max-width:760px) 100vw, 560px")}<span>{l}</span></a>' for k, l in [("vSun", "Thành phố lúc hoàng hôn"), ("vRiver", "Sông và biển"), ("vHan", "Sông Hàn – trung tâm"), ("vBan", "Hướng biển"), ("vKdt", "Khu đô thị xanh")])}
      </div>
    </div>
  </section>

  <section id="hinh-anh">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Hình ảnh</span>
        <h2>Phối cảnh Cora Tower</h2>
      </div>
      <div class="gallery reveal">
        <a href="{src("aHan")}">{pic("aHan", "(max-width:760px) 100vw, 600px")}<span>Toàn cảnh</span></a>
        <a href="{src("rTwin")}">{pic("rTwin", "(max-width:760px) 50vw, 300px")}<span>Khối mái cam</span></a>
        <a href="{src("rBridge")}">{pic("rBridge", "(max-width:760px) 50vw, 300px")}<span>Bên vòng xoay</span></a>
        <a href="{src("aSea")}">{pic("aSea", "(max-width:760px) 50vw, 300px")}<span>Hướng biển</span></a>
        <a href="{src("rAxis")}">{pic("rAxis", "(max-width:760px) 50vw, 300px")}<span>Trục 29/3</span></a>
        <a href="{src("rNear")}">{pic("rNear", "(max-width:760px) 50vw, 300px")}<span>Hai tòa A1 – A2</span></a>
        <a href="{src("rCorner")}">{pic("rCorner", "(max-width:760px) 50vw, 300px")}<span>Khối đế bo cong</span></a>
        <a href="{src("rRound")}">{pic("rRound", "(max-width:760px) 50vw, 300px")}<span>Đài phun nước</span></a>
        <a href="{src("aRiver")}">{pic("aRiver", "(max-width:760px) 50vw, 300px")}<span>Ven sông</span></a>
        <a href="{src("night")}">{pic("night", "(max-width:760px) 50vw, 300px")}<span>Về đêm</span></a>
        <a href="{src("land")}">{pic("land", "(max-width:760px) 50vw, 300px")}<span>Khu đất thực tế</span></a>
        <a href="{src("loc")}">{pic("loc", "(max-width:760px) 50vw, 300px")}<span>Vị trí</span></a>
      </div>
    </div>
  </section>

  <section class="dark">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Quy trình</span>
        <h2>4 bước sở hữu Cora Tower</h2>
        <p class="sub">Chuyên viên đồng hành từ lúc chọn căn đến khi ký hợp đồng.</p>
      </div>
      <div class="steps">
        <div class="step reveal"><h3>Đăng ký</h3><p>Để lại thông tin hoặc gọi {TEL_TXT}.</p></div>
        <div class="step reveal"><h3>Chọn căn</h3><p>Nhận giỏ hàng, mặt bằng, lọc căn theo tầng – hướng.</p></div>
        <div class="step reveal"><h3>Tham quan</h3><p>Xem dự án, sa bàn và căn thực tế.</p></div>
        <div class="step reveal"><h3>Ký hợp đồng</h3><p>Hỗ trợ thủ tục, thanh toán, vay vốn.</p></div>
      </div>
    </div>
  </section>

  {INDEX_ARTICLE}

  {faq_section("Câu hỏi thường gặp về Cora Tower", FAQ_INDEX)}

  {lead_section("Nhận bảng giá &amp; mặt bằng Cora Tower", "Để lại thông tin, chuyên viên gửi bảng giá các tầng, chính sách và giỏ hàng căn đẹp mới nhất qua Zalo.")}
</main>
'''
    return h + "\n<body>\n" + body + LIGHTBOX + "\n" + FOOTER + "\n</body>\n</html>\n"


# ----------------------------------------------------------------- SHOPHOUSE
def build_shop():
    url = f"{D}khoi-de-shophouse.html"
    graph = [
        {"@type": "Product", "name": "Shophouse khối đế Cora Tower", "category": "Shophouse thương mại", "url": url,
         "description": "Shophouse tầng 1 khối đế Cora Tower, mặt tiền vòng xoay 29/3 – Nguyễn Phước Lan, KĐT Nam Hòa Xuân, Đà Nẵng. Pháp lý đầy đủ, phù hợp kinh doanh và cho thuê.",
         "image": [f"{D}{src('sr06')}", f"{D}{src('sr01')}", f"{D}{src('shop')}", f"{D}{src('a1a2')}", f"{D}{src('struct')}", f"{D}{src('shA1')}", f"{D}{src('shA2')}"], "brand": {"@type": "Brand", "name": "Cora Tower"}},
        crumbs("Shophouse khối đế", url), faq_ld(FAQ_SHOP),
    ]
    h = head("khoi-de-shophouse", "Shophouse Cora Tower – Shop khối đế Sun Group Đà Nẵng, sở hữu lâu dài, trần 7m",
             "Shophouse khối đế Cora Tower (Sun Group) tầng 1, mặt tiền vòng xoay 29/3 – Nguyễn Phước Lan, Hòa Xuân. Kính kịch trần, pháp lý đầy đủ, giá 4,96 – 6,04 tỷ/căn (43 – 61,5 m²). Gọi 0904 567 009.",
             "shophouse Cora Tower, khối đế Cora Tower, shophouse khối đế Đà Nẵng, shophouse Hòa Xuân, shophouse 29/3, shophouse Sun Neo City",
             "og-shophouse.jpg", "Khối đế shophouse Cora Tower", "sr06", graph)
    body = f'''{header("shop", "Nhận giỏ hàng")}

<main>
  <section class="hero">
    {pic("sr06", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap hero-grid">
      <div>
        <nav class="breadcrumb" aria-label="breadcrumb"><a href="./">Cora Tower</a> › Shophouse khối đế</nav>
        <span class="eyebrow">Tầng 1 · Mặt tiền vòng xoay 29/3</span>
        <h1>Shophouse khối đế Cora Tower – <em>kinh doanh</em> tại tâm điểm Nam Hòa Xuân</h1>
        <p class="lead">Mặt bằng thương mại ngay chân hai tòa tháp 1.342 căn hộ, mặt kính kịch trần, pháp lý minh bạch – vừa kinh doanh, vừa cho thuê, vừa tích lũy tài sản.</p>
        <ul class="ticks"><li>Sở hữu lâu dài</li><li>Trần ~7 m</li><li>Khách hàng sẵn có</li><li>Góc vòng xoay</li></ul>
        <div class="cta"><a class="btn ghost lg" href="tel:{TEL}">Gọi {TEL_TXT}</a></div>
      </div>
      {hero_form("Nhận giỏ hàng shophouse", "Diện tích, giá từng căn và chính sách thanh toán mới nhất.", "Shophouse khối đế", "Nhận giỏ hàng")}
    </div>
  </section>
  {stats([(4.96, " tỷ", "4,96 tỷ", "giá shophouse từ"), (1, "", "1", "tầng shophouse thương mại"), (1342, "", "1.342", "căn hộ phía trên"), (2, "", "2", "tòa tháp A1 &amp; A2")])}

  <section>
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Lợi thế đầu tư</span><h2>Vì sao shophouse khối đế Cora Tower đáng đầu tư?</h2></div>
      <div class="grid g4" style="margin-top:36px">
        {card("people", "Khách hàng sẵn có", "1.342 căn hộ phía trên tạo nhu cầu tiêu dùng thường xuyên ngay chân tòa nhà.")}
        {card("pin", "Góc vòng xoay", "Vòng xoay 29/3 giao Nguyễn Phước Lan – cửa ngõ phía Nam, lưu lượng qua lại lớn.")}
        {card("store", "Trần ~7 m, làm tầng lửng", "Mặt kính kịch trần, chiều cao tầng ~7 m làm thêm tầng lửng – gấp đôi diện tích sử dụng.")}
        {card("chart", "Dòng tiền bền vững", "Tự kinh doanh hoặc cho thuê tạo thu nhập ổn định từ cư dân và khách vãng lai.")}
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Thông tin</span>
        <h2>Thông tin shophouse khối đế</h2>
        <div class="table-wrap">
          <table>
            <tbody>
              <tr><th scope="row">Vị trí</th><td>Tầng 1 khối đế tòa A1 &amp; A2 – Cora Tower, vòng xoay 29/3 – Nguyễn Phước Lan, Đà Nẵng</td></tr>
              <tr><th scope="row">Tầng 2</th><td>Dịch vụ – tiện ích, tăng lượng khách cho khối đế</td></tr>
              <tr><th scope="row">Chiều cao tầng</th><td>~7 m – làm thêm tầng lửng (Ban quản lý duyệt 1–2 tuần)</td></tr>
              <tr><th scope="row">Sở hữu</th><td>Lâu dài như căn hộ; đăng ký được hộ khẩu thường trú</td></tr>
              <tr><th scope="row">Vay ngân hàng</th><td>Tối đa 70%, hỗ trợ lãi suất 0% trong 24 tháng</td></tr>
              <tr><th scope="row">Pháp lý</th><td>Đất lô A2-19, A2-20 đã có GCN QSDĐ; đủ điều kiện bán theo văn bản 7117/SXD-QLN – <a href="phap-ly.html">xem hồ sơ</a></td></tr>
              <tr><th scope="row">Giá tham khảo</th><td class="price">4,96 – 6,04 tỷ/căn (đã gồm VAT &amp; phí bảo trì)</td></tr>
              <tr><th scope="row">Diện tích</th><td>Khoảng 38 – 127 m² thông thủy (42 – 138 m² tim tường), mặt tiền 3,5 – 13 m</td></tr>
              <tr><th scope="row">Số lượng</th><td>Khoảng 33 shop tòa A1, 30 shop tòa A2 – <a href="#mat-bang-shop">xem mặt bằng</a></td></tr>
            </tbody>
          </table>
        </div>
        <p class="note">Số liệu tổng hợp, chỉ mang tính tham khảo. Giá và chính sách chính thức theo chủ đầu tư tại từng thời điểm.</p>
      </div>
      <div class="media-stack reveal"><div class="split-media zoom"><a href="{src("struct")}" class="zoom-link">{pic("struct", "(max-width:900px) 100vw, 600px", alt="Cấu trúc tòa Cora Tower: tầng 1 shophouse thương mại, tầng 2 dịch vụ tiện ích")}</a></div><figure class="stack-photo">{pic("sr07", "(max-width:900px) 100vw, 600px", alt="Shophouse khối đế Cora Tower mặt kính kịch trần bên vòng xoay")}<figcaption>Mặt tiền shophouse kính kịch trần, trần cao ~7 m</figcaption></figure></div>
    </div>
  </section>

  <section id="chinh-sach-shop">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Chính sách bán hàng</span><h2>Chính sách shophouse khối đế Cora Tower</h2>
        <p class="sub">Nhiều tầng ưu đãi cộng dồn theo phương án thanh toán – vốn ban đầu nhẹ, nhận shop sớm để kinh doanh.</p></div>
      <div class="policy reveal">
        <div><b>3%</b><span>Chiết khấu Early Bird</span></div>
        <div><b>4%</b><span>Quà tặng hỗ trợ hoàn thiện nội thất kinh doanh</span></div>
        <div><b>5%</b><span>Chiết khấu không vay</span></div>
        <div><b>70%</b><span>Sun Early Key – thanh toán 70% nhận nhà</span></div>
        <div><b>24</b><span>tháng hỗ trợ lãi suất (vay tối đa 70%)</span></div>
        <div><b>40</b><span>tháng tiến độ thanh toán</span></div>
        <div><b>8%</b><span>/năm ưu đãi cho khoản thanh toán sớm*</span></div>
        <div><b>1</b><span>năm miễn phí dịch vụ quản lý*</span></div>
      </div>
      <p class="note">* Theo chủ đầu tư, chính sách bán hàng shophouse tương tự căn hộ (CSƯĐ 06.1); ưu đãi thanh toán sớm không áp dụng đồng thời với hỗ trợ lãi suất. Các mức chiết khấu thanh toán sớm 95%/70% theo từng đợt – liên hệ {TEL_TXT} để nhận chính sách đang áp dụng.</p>
    </div>
  </section>

  <section class="alt" id="tinh-dong-tien">
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Công cụ</span>
        <h2>Ước tính dòng tiền shophouse</h2>
        <p class="sub">Nhập giá căn, tỷ lệ vay và giá thuê anh/chị khảo sát được để xem vốn tự có và tỷ suất cho thuê. Kết quả chỉ mang tính tham khảo.</p>
        <form class="calc" onsubmit="return false">
          <label>Giá căn (tỷ đồng)<input type="number" step="0.01" min="1" id="c-price" value="5.2"></label>
          <label>Tỷ lệ vay (%)<input type="number" step="5" min="0" max="70" id="c-loan" value="70"></label>
          <label>Giá thuê dự kiến (triệu/tháng)<input type="number" step="1" min="0" id="c-rent" value="35"></label>
        </form>
      </div>
      <div class="calc-out reveal" aria-live="polite">
        <div><span>Vốn tự có ban đầu</span><b id="o-own">–</b></div>
        <div><span>Khoản vay (HTLS 0% 24 tháng)</span><b id="o-loan">–</b></div>
        <div><span>Tiền thuê một năm</span><b id="o-year">–</b></div>
        <div><span>Tỷ suất thuê trên giá mua</span><b id="o-yield">–</b></div>
        <div class="hl"><span>Tỷ suất trên vốn tự có (trong thời gian HTLS)</span><b id="o-roe">–</b></div>
        <small>Giá thuê 35 triệu/tháng là mức thấp trong khoảng 35–100 triệu/tháng mà báo chí dẫn lời một số chủ shophouse khu Nam trung tâm Đà Nẵng – không phải cam kết. Chưa tính thuế, phí quản lý và thời gian trống.</small>
      </div>
    </div>
  </section>

  <section class="alt" id="phoi-canh-shop">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Phối cảnh</span><h2>Phối cảnh shophouse khối đế</h2>
        <p class="sub">Mặt kính kịch trần cao gần 7 m, biển hiệu đồng bộ, mái đón sảnh và vỉa hè rộng rợp cây – không gian kinh doanh chuẩn phố thương mại.</p></div>
      <div class="gallery reveal">
        {"".join(f'<a href="{src(k)}">{pic(k, "(max-width:760px) 100vw, 600px" if i == 0 else "(max-width:760px) 50vw, 300px")}</a>' for i, k in enumerate(["sr01","sr07","sr05","sr04","sr10","sr08","sr11","sr02","sr03"]))}
      </div>
    </div>
  </section>

  <section id="mat-bang-shop">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Mặt bằng tầng 1</span>
        <h2>Mặt bằng shophouse khối đế tòa A1 – A2</h2>
        <p class="sub">Shop bao quanh khối đế, mặt chính hướng đường 29/3 và vòng xoay; sảnh cư dân, lõi thang và lối xuống hầm nằm giữa. Bấm để xem rõ mã căn, diện tích (tim tường / thông thủy) và chiều rộng mặt tiền.</p>
      </div>
      <div class="tabs reveal" role="tablist">
        <button role="tab" aria-selected="true" data-tab="sh-a1">Tòa A1 · mã căn</button>
        <button role="tab" aria-selected="false" data-tab="sh-a2">Tòa A2 · mã căn</button>
        <button role="tab" aria-selected="false" data-tab="mt-a1">Tòa A1 · mặt tiền</button>
        <button role="tab" aria-selected="false" data-tab="mt-a2">Tòa A2 · mặt tiền</button>
      </div>
      {"".join(f'<div class="plan" id="{t}"{"" if i == 0 else " hidden"}><a href="{src(k)}" class="zoom-link">{pic(k, "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>' for i, (t, k) in enumerate([("sh-a1", "shA1"), ("sh-a2", "shA2"), ("mt-a1", "mtA1"), ("mt-a2", "mtA2")]))}
      <p class="note">Thông số bản vẽ mang tính tương đối; thông số chính thức theo văn bản ký kết giữa chủ đầu tư và khách hàng.</p>
      <div class="center" style="margin-top:22px"><a class="btn lg" href="#dang-ky">Nhận giỏ hàng shop còn trống</a></div>
    </div>
  </section>

  <section>
    <div class="wrap split rev">
      <div class="split-media reveal">{pic("rCorner", "(max-width:900px) 100vw, 600px")}</div>
      <div class="reveal">
        <span class="kicker">Ngành hàng</span>
        <h2>Phù hợp kinh doanh gì?</h2>
        <ul class="check">
          <li><b>F&amp;B:</b> cafe, trà sữa, nhà hàng, bakery</li>
          <li><b>Bán lẻ:</b> thời trang, mỹ phẩm, siêu thị mini</li>
          <li><b>Dịch vụ:</b> spa, salon, phòng khám, nhà thuốc</li>
          <li><b>Showroom:</b> nội thất, điện máy, văn phòng giao dịch, ngân hàng</li>
        </ul>
        <a class="btn" href="#dang-ky">Nhận giỏ hàng shophouse</a>
      </div>
    </div>
  </section>

  {SHOP_ARTICLE}

  {faq_section("Hỏi đáp về shophouse khối đế Cora Tower", FAQ_SHOP, '<p class="center" style="margin-top:20px">Xem thêm: <a href="./">Tổng quan dự án Cora Tower</a> · <a href="penthouse.html">Duplex – Penthouse Cora Tower</a></p>')}

  {lead_section("Nhận giỏ hàng shophouse khối đế", "Nhận mặt bằng, diện tích, giá từng căn và chính sách thanh toán mới nhất.", "Shophouse khối đế", "Nhận giỏ hàng")}
</main>
'''
    return h + "\n<body>\n" + body + "\n" + FOOTER + "\n</body>\n</html>\n"


# ----------------------------------------------------------------- PENTHOUSE
def build_ph():
    url = f"{D}penthouse.html"
    graph = [
        {"@type": "Apartment", "name": "Duplex – Penthouse Cora Tower", "url": url, "floorLevel": "25",
         "description": "Căn hộ duplex – penthouse tầng 25 Cora Tower trong khối mái kiến trúc đặc trưng, sân vườn trên cao, tầm nhìn sông và thành phố Đà Nẵng.",
         "image": [f"{D}{src('ph')}", f"{D}{src('night')}", f"{D}{src('struct')}", f"{D}{src('ph25A1')}", f"{D}{src('phL25A1')}"],
         "containedInPlace": {"@id": f"{D}#project"},
         "address": {"@type": "PostalAddress", "streetAddress": "Vòng xoay đường 29/3 – Nguyễn Phước Lan, KĐT Nam Hòa Xuân", "addressLocality": "Đà Nẵng", "addressCountry": "VN"}},
        crumbs("Duplex – Penthouse", url), faq_ld(FAQ_PH),
    ]
    h = head("penthouse", "Penthouse Cora Tower – Duplex trần 7m tầng 25, view sông Hàn | Sun Group Đà Nẵng",
             "Penthouse Cora Tower tầng 25 trong khối mái cam biểu tượng: trần cao ~7m làm được duplex, tầm nhìn sông Hàn, phố thị và biển Đà Nẵng. Mỗi tòa chỉ khoảng 24 căn – gọi 0904 567 009.",
             "penthouse Cora Tower, duplex Cora Tower, căn hộ tầng 25 Cora Tower, penthouse Đà Nẵng, penthouse Hòa Xuân, duplex Đà Nẵng",
             "og-penthouse.jpg", "Ban công penthouse Cora Tower lúc hoàng hôn", "vSun", graph)
    body = f'''{header("ph", "Nhận giá duplex")}

<main>
  <section class="hero">
    {pic("vSun", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap hero-grid">
      <div>
        <nav class="breadcrumb" aria-label="breadcrumb"><a href="./">Cora Tower</a> › Duplex – Penthouse</nav>
        <span class="eyebrow">Tầng 25 · Duplex · Số lượng giới hạn</span>
        <h1>Penthouse Cora Tower – <em>nơi bầu trời</em> trở thành phòng khách</h1>
        <p class="lead">Có những buổi chiều, cả Đà Nẵng như chậm lại dưới chân mình. Tầng 25, trần cao gần 7 mét, khối mái cam ôm lấy ánh hoàng hôn – penthouse Cora Tower dành cho người muốn mỗi ngày đều được sống giữa trời.</p>
        <ul class="ticks"><li>Tầng cao nhất</li><li>Trần ~7 m</li><li>Làm được duplex</li></ul>
        <div class="cta"><a class="btn ghost lg" href="tel:{TEL}">Gọi {TEL_TXT}</a></div>
      </div>
      {hero_form("Đăng ký ưu tiên duplex", "Số lượng rất giới hạn – nhận mặt bằng và giá trước khi công bố rộng rãi.", "Duplex – Penthouse", "Đăng ký ưu tiên")}
    </div>
  </section>
  {stats([(25, "", "25", "tầng cao nhất"), (2, "", "2", "tầng thông (duplex)"), (360, "°", "360°", "tầm nhìn thành phố"), (2, "", "2", "tòa tháp A1 &amp; A2")])}

  <section class="dark day-sec">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Một ngày ở tầng 25</span><h2>Từ bình minh đến khi thành phố lên đèn</h2>
        <p class="sub">Ở trên cao, thời gian trôi theo ánh sáng. Đây là một ngày bình thường của chủ nhân penthouse Cora Tower.</p></div>
      <ol class="day">
        <li class="reveal"><figure>{pic("vBan", "(max-width:560px) 100vw, (max-width:960px) 50vw, 300px", alt="Ban công căn hộ Cora Tower đón nắng sớm hướng biển")}</figure><time>05:45</time><h3>Nắng đầu tiên</h3><p>Ánh bình minh từ phía biển tràn qua ô kính cao gấp đôi bình thường. Bạn pha ly cà phê, cả căn nhà sáng lên trước khi thành phố kịp thức giấc.</p></li>
        <li class="reveal"><figure>{pic("rPool", "(max-width:560px) 100vw, (max-width:960px) 50vw, 300px", alt="Hồ bơi trong nhà kính tầng 2 Cora Tower buổi sáng")}</figure><time>09:00</time><h3>Kỳ nghỉ không cần xếp vali</h3><p>Một chuyến thang máy xuống tầng 2: vài vòng bơi trong hồ kính đầy nắng, rồi xông hơi Jjimjilbang kiểu Hàn. Trở lên nhà, tầng lửng là góc làm việc yên tĩnh nhìn ra trời xanh.</p></li>
        <li class="reveal"><figure>{pic("vRiver", "(max-width:560px) 100vw, (max-width:960px) 50vw, 300px", alt="Ban công nhìn ra sông và biển Đà Nẵng lúc chiều")}</figure><time>17:30</time><h3>Hoàng hôn sông Hàn</h3><p>Mặt trời lặn sau rặng núi phía Tây, sông đổi màu bạc rồi tím. Bọn trẻ về nhà, cả gia đình ra ban công – khoảnh khắc mà không bức ảnh nào chụp đủ.</p></li>
        <li class="reveal"><figure>{pic("night", "(max-width:560px) 100vw, (max-width:960px) 50vw, 300px", alt="Khối mái cam Cora Tower phát sáng khi thành phố lên đèn")}</figure><time>20:30</time><h3>Thành phố lên đèn</h3><p>Phố xá Đà Nẵng trải dài lấp lánh dưới chân, vòng quay Sun Wheel sáng ở phía xa. Những đêm lễ hội, ban công nhà bạn là khán đài riêng.</p></li>
      </ol>
    </div>
  </section>

  <section>
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Khác biệt</span><h2>Những điều chỉ có ở tầng cao nhất</h2></div>
      <div class="grid g3" style="margin-top:36px">
        {card("ceiling", "Khoảng trời trong nhà", "Trần cao gần 7 m – đủ cho một phòng khách thông tầng với ô kính lớn, hoặc tầng lửng riêng cho phòng ngủ, thư viện. Giá tính theo một căn, phần lửng không tính thêm.")}
        {card("eye", "Không ai che tầm mắt", "Cora Tower đứng giữa khu đô thị thấp tầng, nên từ tầng 25 nhìn ra là sông Hàn, phố thị, rặng núi phía Tây và xa hơn là biển.")}
        {card("crown", "Ngôi nhà ai cũng nhận ra", "Căn hộ nằm trong khối mái cam – “vương miện” của hai tòa tháp. Chỉ cần nói “nhà tôi ở trên mái cam ấy”, bạn bè sẽ biết.")}
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Thông tin</span>
        <h2>Thông tin duplex – penthouse</h2>
        <div class="table-wrap">
          <table>
            <tbody>
              <tr><th scope="row">Vị trí</th><td>Tầng 25 – tòa A1 &amp; A2, Cora Tower, vòng xoay 29/3 – Nguyễn Phước Lan, Đà Nẵng</td></tr>
              <tr><th scope="row">Chiều cao tầng</th><td>~7 m – làm thêm tầng lửng thành duplex, có layout gợi ý của CĐT</td></tr>
              <tr><th scope="row">Số lượng</th><td>Khoảng 24 căn mỗi tòa (A12501 – A12524, A22501 – A22524)</td></tr>
              <tr><th scope="row">Diện tích sàn chính</th><td>51,9 – 88,6 m² thông thủy (56,3 – 94,7 m² tim tường)</td></tr>
              <tr><th scope="row">Sau khi làm lửng</th><td>1PN → 2PN+1, 2PN → 3PN, 2PN+1 → 3PN+1 theo layout gợi ý</td></tr>
              <tr><th scope="row">Cách tính giá</th><td>Theo đơn nguyên 1 căn – phần lửng không tính thêm</td></tr>
              <tr><th scope="row">Hoàn thiện</th><td>Trong 12 tháng từ ngày bàn giao</td></tr>
              <tr><th scope="row">Tiện ích</th><td>Sân vườn trên cao; dịch vụ – tiện ích tại tầng 2 khối đế</td></tr>
              <tr><th scope="row">Pháp lý</th><td>Đủ điều kiện bán, bảo lãnh VietinBank – <a href="phap-ly.html">xem hồ sơ</a></td></tr>
              <tr><th scope="row">Diện tích, giá</th><td>Liên hệ {TEL_TXT} để nhận mặt bằng và bảng giá</td></tr>
            </tbody>
          </table>
        </div>
        <p class="note">Thông tin tổng hợp, chỉ mang tính tham khảo. Thông số chính thức theo hồ sơ của chủ đầu tư.</p>
      </div>
      <div class="media-stack reveal"><div class="split-media zoom"><a href="{src("struct")}" class="zoom-link">{pic("struct", "(max-width:900px) 100vw, 600px", alt="Cấu trúc tòa Cora Tower: tầng 25 căn hộ duplex trong khối mái")}</a></div><figure class="stack-photo">{pic("ph", "(max-width:900px) 100vw, 600px", alt="Sân vườn trên cao của căn penthouse Cora Tower nhìn ra thành phố")}<figcaption>Sân vườn trên cao – không gian riêng của tầng 25</figcaption></figure></div>
    </div>
  </section>

  <section id="mat-bang-penthouse">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Mặt bằng tầng 25</span>
        <h2>Mặt bằng penthouse &amp; tầng lửng gợi ý</h2>
        <p class="sub">Tầng 25 mỗi tòa khoảng 24 căn. Với chiều cao ~7 m, căn 1PN làm thêm lửng thành 2PN+1, căn 2PN thành 3PN, căn 2PN+1 thành 3PN+1 – xem so sánh sàn chính và tầng lửng bên dưới.</p>
      </div>
      <div class="tabs reveal" role="tablist">
        <button role="tab" aria-selected="true" data-tab="p-a1">A1 · tầng 25</button>
        <button role="tab" aria-selected="false" data-tab="pl-a1">A1 · tầng lửng</button>
        <button role="tab" aria-selected="false" data-tab="p-a2">A2 · tầng 25</button>
        <button role="tab" aria-selected="false" data-tab="pl-a2">A2 · tầng lửng</button>
      </div>
      {"".join(f'<div class="plan" id="{t}"{"" if i == 0 else " hidden"}><a href="{src(k)}" class="zoom-link">{pic(k, "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>' for i, (t, k) in enumerate([("p-a1", "ph25A1"), ("pl-a1", "phL25A1"), ("p-a2", "ph25A2"), ("pl-a2", "phL25A2")]))}
      <p class="note">Tầng lửng là layout gợi ý của chủ đầu tư, chủ nhà tự thi công sau bàn giao và nộp phương án cho Ban quản lý. Thông số chính thức theo văn bản ký kết.</p>
      <div class="center" style="margin-top:22px"><a class="btn lg" href="#dang-ky">Nhận giỏ hàng penthouse</a></div>
    </div>
  </section>

  <section>
    <div class="wrap split rev">
      <div class="split-media reveal">{pic("night", "(max-width:900px) 100vw, 600px", alt="Khối mái màu cam phát sáng về đêm – nơi bố trí căn duplex tầng 25 Cora Tower")}<div class="badge">Dành cho số ít<small>ưu tiên khách đăng ký sớm</small></div></div>
      <div class="reveal">
        <span class="kicker">Chủ nhân</span>
        <h2>Dành cho những người đã đi đủ xa để biết mình muốn gì</h2>
        <ul class="check">
          <li><b>Gia đình ba thế hệ</b> – ông bà có phòng riêng ở tầng dưới, con cái có góc riêng trên tầng lửng, bữa tối vẫn chung một bàn.</li>
          <li><b>Người thành đạt</b> muốn một nơi tiếp bạn bè, đối tác mà chỉ cần bước vào là không cần giới thiệu thêm.</li>
          <li><b>Người yêu cái đẹp</b> muốn tự tay vẽ nên ngôi nhà thông tầng của mình, không theo khuôn mẫu nào.</li>
          <li><b>Người nghĩ dài hạn</b> – mỗi tòa tháp chỉ có một tầng mái, và tầm nhìn này không thể xây thêm.</li>
        </ul>
        <a class="btn" href="#dang-ky">Hẹn lịch ngắm căn penthouse</a>
      </div>
    </div>
  </section>

  {PH_ARTICLE}

  {faq_section("Hỏi đáp về duplex – penthouse Cora Tower", FAQ_PH, '<p class="center" style="margin-top:20px">Xem thêm: <a href="./">Tổng quan dự án Cora Tower</a> · <a href="khoi-de-shophouse.html">Shophouse khối đế Cora Tower</a></p>')}

  {lead_section("Giữ cho mình một góc trời ở tầng 25", "Mỗi tòa chỉ khoảng 24 căn penthouse. Để lại thông tin, anh Hiệp sẽ gửi mặt bằng, giá từng căn và hẹn lịch xem dự án vào giờ hoàng hôn.", "Duplex – Penthouse", "Đăng ký ưu tiên")}
</main>
'''
    return h + "\n<body>\n" + body + "\n" + FOOTER + "\n</body>\n</html>\n"


def build_legal():
    url = f"{D}phap-ly.html"
    docs_ld = {"@type": "ItemList", "name": "Hồ sơ pháp lý dự án Cora Tower", "itemListElement": [
        {"@type": "ListItem", "position": i + 1, "name": t, "url": f"{D}phap-ly/{f}" if f else url}
        for i, (_, t, _d, f) in enumerate(LEGAL_DOCS)]}
    org = {"@type": "Organization", "name": DEVELOPER["name"], "alternateName": DEVELOPER["short"], "taxID": DEVELOPER["tax"],
           "telephone": "+842363890999", "address": {"@type": "PostalAddress", "streetAddress": DEVELOPER["addr"], "addressLocality": "Đà Nẵng", "addressCountry": "VN"}}
    graph = [org, docs_ld, crumbs("Pháp lý", url), faq_ld(FAQ_LEGAL)]
    h = head("phap-ly", "Pháp lý Cora Tower – Sổ đỏ, đủ điều kiện bán, bảo lãnh VietinBank | 0904 567 009",
             "Hồ sơ pháp lý Cora Tower (Sun Group) lô A2-19, A2-20 Hòa Xuân: sổ đỏ DI 103576, DI 103577; văn bản 7117/SXD-QLN đủ điều kiện bán; bảo lãnh VietinBank; quy mô 1.342 căn. Xem và tải PDF.",
             "pháp lý Cora Tower, sổ đỏ Cora Tower, Cora Tower đủ điều kiện bán, bảo lãnh Cora Tower, chủ đầu tư Cora Tower, Tập đoàn Mặt Trời, lô A2-19 A2-20 Hòa Xuân",
             "og-cora-tower.jpg", "Pháp lý Cora Tower", "night", graph)
    groups = []
    for g in dict.fromkeys(x[0] for x in LEGAL_DOCS):
        items = "".join(
            f'<li class="doc"><div><b>{t}</b><span>{d}</span></div>'
            + (f'<a class="btn doc-btn" href="phap-ly/{f}" target="_blank" rel="noopener">Xem PDF</a>' if f else '<em>Theo công bố CĐT</em>')
            + "</li>" for gg, t, d, f in LEGAL_DOCS if gg == g)
        groups.append(f'<div class="doc-group reveal"><h3>{g}</h3><ul>{items}</ul></div>')
    plan_rows = "".join(f"<tr><td>{a}</td><td>{u}</td><td>{x}</td><td>{y}</td></tr>" for a, u, x, y in PLAN_ROWS)
    body = f"""{header("legal", "Nhận hồ sơ")}

<main>
  <section class="hero hero-sm">
    {pic("night", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap">
      <nav class="breadcrumb" aria-label="breadcrumb"><a href="./">Cora Tower</a> › Pháp lý</nav>
      <span class="eyebrow">Công bố thông tin dự án bất động sản</span>
      <h1>Pháp lý Cora Tower – <em>đủ điều kiện bán</em>, có bảo lãnh ngân hàng</h1>
      <p class="lead">Nhà chung cư tại lô A2-19 (Tòa A1) và A2-20 (Tòa A2), Dự án Khu đô thị sinh thái ven sông Hòa Xuân (Sun Neo City), phường Hòa Xuân, TP Đà Nẵng.</p>
      <ul class="ticks"><li>Sổ đỏ từng lô</li><li>Văn bản 7117/SXD-QLN</li><li>Bảo lãnh VietinBank</li><li>Hợp đồng mẫu đã đăng ký</li></ul>
    </div>
  </section>

  <section>
    <div class="wrap split">
      <div class="reveal">
        <span class="kicker">Chủ đầu tư</span>
        <h2>{DEVELOPER["name"]}</h2>
        <div class="table-wrap"><table><tbody>
          <tr><th scope="row">Tên thương mại</th><td>{DEVELOPER["short"]} (Sun Group Corporation)</td></tr>
          <tr><th scope="row">Mã số doanh nghiệp</th><td>{DEVELOPER["tax"]}</td></tr>
          <tr><th scope="row">Trụ sở</th><td>{DEVELOPER["addr"]}</td></tr>
          <tr><th scope="row">Điện thoại</th><td>{DEVELOPER["tel"]}</td></tr>
          <tr><th scope="row">Người đại diện</th><td>{DEVELOPER["rep"]}</td></tr>
        </tbody></table></div>
      </div>
      <div class="reveal">
        <span class="kicker">Thông tin bất động sản</span>
        <h2>Căn hộ chung cư – hình thành trong tương lai</h2>
        <ul class="check">
          <li>Vị trí: lô A2-19 và A2-20, KĐT sinh thái ven sông Hòa Xuân, phường Hòa Xuân, TP Đà Nẵng</li>
          <li>Công năng: công trình dân dụng; chất lượng theo quy chuẩn, tiêu chuẩn Nhà nước</li>
          <li>Hạ tầng đường 29/3, Nguyễn Phước Lan, Đinh Văn Chấp, Hoàng Thế Thiện đã cơ bản hoàn thành</li>
          <li>Không hạn chế đặc biệt về quyền sở hữu, sử dụng; không thế chấp tại thời điểm ký HĐMB</li>
          <li>Giá bán phụ thuộc đơn giá và diện tích từng căn</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="alt" id="quy-mo">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Quy mô</span><h2>Quy hoạch &amp; quy mô từng tòa</h2>
        <p class="sub">Quy hoạch: dân số 1.070 người/lô, mật độ xây dựng tối đa 67%, hệ số sử dụng đất tối đa 11,5 lần, 1–25 tầng, cao tối đa 98 m.</p></div>
      <div class="table-wrap reveal" style="margin-top:24px"><table>
        <thead><tr><th>Chỉ tiêu</th><th>Đơn vị</th><th>Tòa A1 (lô A2-19)</th><th>Tòa A2 (lô A2-20)</th></tr></thead>
        <tbody>{plan_rows}</tbody></table></div>
      <p class="note">Chỉ tiêu quy hoạch, quy mô theo công bố của chủ đầu tư; có thể được điều chỉnh theo quyết định của cơ quan có thẩm quyền và kế hoạch kinh doanh tại từng thời điểm.</p>
    </div>
  </section>

  <section id="ho-so">
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Hồ sơ</span><h2>Hồ sơ, giấy tờ về dự án</h2>
        <p class="sub">Bấm “Xem PDF” để mở bản scan văn bản. Hồ sơ pháp lý được chủ đầu tư cập nhật tại từng thời điểm.</p></div>
      <div class="doc-grid">{"".join(groups)}</div>
    </div>
  </section>

  {faq_section("Hỏi đáp pháp lý Cora Tower", FAQ_LEGAL, '<p class="center" style="margin-top:20px">Xem thêm: <a href="./">Tổng quan dự án</a> · <a href="./#gia">Bảng giá</a> · <a href="./#mat-bang">Mặt bằng</a></p>')}

  {lead_section("Nhận trọn bộ hồ sơ pháp lý &amp; hợp đồng mẫu", "Chuyên viên gửi qua Zalo bộ hồ sơ pháp lý, hợp đồng mua bán mẫu và tiến độ thanh toán để anh/chị xem kỹ trước khi quyết định.", None, "Nhận hồ sơ")}
</main>
"""
    return h + "\n<body>\n" + body + "\n" + FOOTER + "\n</body>\n</html>\n"


def build_sun():
    url = f"{D}can-ho-sun-da-nang.html"
    graph = [{"@type": "Article", "headline": "Căn hộ Sun Đà Nẵng: so sánh Cora Tower, Spana, S-Light và kinh nghiệm chọn mua",
              "image": [f"{D}{src('aHan')}"], "inLanguage": "vi", "dateModified": "2026-10-07",
              "author": {"@id": f"{D}#agent"}, "publisher": {"@id": f"{D}#agent"}, "mainEntityOfPage": url},
             crumbs("Căn hộ Sun Đà Nẵng", url), faq_ld(SUN_FAQ)]
    h = head("can-ho-sun-da-nang", "Căn hộ Sun Đà Nẵng 2026 – So sánh Cora Tower, Spana, S-Light | Giá, pháp lý",
             "Tổng hợp căn hộ Sun Group Đà Nẵng tại Sun Neo City Hòa Xuân: so sánh Cora Tower, Spana Tower, S-Light Tower, giá 1PN+ từ ~3,1 tỷ, vay 70%, pháp lý đủ điều kiện bán. Gọi 0904 567 009.",
             "căn hộ Sun Đà Nẵng, căn hộ Sun Group Đà Nẵng, Sun Neo City, chung cư Sun Hòa Xuân, Cora Tower, Spana Tower, S-Light Tower",
             "og-cora-tower.jpg", "Căn hộ Sun Group Đà Nẵng", "aHan", graph)
    body = f"""{header("sun", "Nhận bảng giá")}

<main>
  <section class="hero hero-sm">
    {pic("aHan", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap">
      <nav class="breadcrumb" aria-label="breadcrumb"><a href="./">Cora Tower</a> › Căn hộ Sun Đà Nẵng</nav>
      <span class="eyebrow">Sun Neo City · Nam trung tâm Đà Nẵng</span>
      <h1>Căn hộ Sun Đà Nẵng 2026: <em>chọn dự án nào</em> để ở và đầu tư?</h1>
      <p class="lead">So sánh các tổ hợp căn hộ Sun Group tại Hòa Xuân, giá bán, pháp lý và kinh nghiệm chọn căn – cập nhật tháng 10/2026.</p>
    </div>
  </section>

  {article("Cẩm nang", "Căn hộ Sun Group Đà Nẵng: tổng quan và so sánh", SUN_BODY, SUN_TOC, cls="")}

  {faq_section("Hỏi đáp về căn hộ Sun Đà Nẵng", SUN_FAQ, '<p class="center" style="margin-top:20px">Xem thêm: <a href="./">Cora Tower</a> · <a href="khoi-de-shophouse.html">Shophouse Cora Tower</a> · <a href="penthouse.html">Penthouse Cora Tower</a></p>')}

  {lead_section("Nhận bảng giá căn hộ Sun Đà Nẵng", "Chuyên viên gửi bảng giá, mặt bằng và chính sách mới nhất qua Zalo trong ít phút.")}
</main>
"""
    return h + "\n<body>\n" + body + "\n" + FOOTER + "\n</body>\n</html>\n"


def sitemap():
    pages = {"": ["rTwin", "aHan", "aSea", "aRiver", "rBridge", "rAxis", "rNear", "rCorner", "rRound", "rPod", "rPool", "rJjim", "vSun", "vRiver", "vHan", "vBan", "vKdt", "hero", "a1a2", "night", "aerial", "struct", "site", "siteAir", "planA1", "planA2", "g3A1", "g3A2", "unit1pn", "iso1pn", "int1pn", "cross", "land", "river", "pA10801", "pA10805", "pA10817", "pA20827", "pA10828", "pA10823", "amA1", "amA2"],
             "khoi-de-shophouse.html": ["sr06", "shop", "a1a2", "struct", "shA1", "shA2", "mtA1", "mtA2"] + [f"sr{i:02d}" for i in range(1, 12) if i != 6], "penthouse.html": ["rBridge", "ph", "night", "struct", "ph25A1", "phL25A1", "ph25A2", "phL25A2"], "phap-ly.html": ["night"], "can-ho-sun-da-nang.html": ["aHan"]}
    out = ['<?xml version="1.0" encoding="UTF-8"?>',
           '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">']
    for p, imgs in pages.items():
        im = "".join(f"<image:image><image:loc>{D}{src(k)}</image:loc></image:image>" for k in imgs)
        out.append(f"  <url><loc>{D}{p}</loc><changefreq>weekly</changefreq><priority>{'1.0' if not p else '0.9'}</priority>{im}</url>")
    out.append("</urlset>")
    return "\n".join(out) + "\n"


if __name__ == "__main__":
    (SITE / "index.html").write_text(build_index())
    (SITE / "khoi-de-shophouse.html").write_text(build_shop())
    (SITE / "penthouse.html").write_text(build_ph())
    (SITE / "phap-ly.html").write_text(build_legal())
    (SITE / "can-ho-sun-da-nang.html").write_text(build_sun())
    (SITE / "sitemap.xml").write_text(sitemap())
    print("built", SITE)
