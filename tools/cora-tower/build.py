"""Static site generator for www.cora-tower.com.

Run:  python3 tools/cora-tower/build.py
Writes web/cora-tower/{index,khoi-de-shophouse,penthouse}.html
"""
import json
import pathlib

ROOT = pathlib.Path(__file__).resolve().parents[2]
SITE = ROOT / "web" / "cora-tower"
D = "https://www.cora-tower.com/"
TEL, TEL_TXT, TEL_INTL = "0904567009", "0904 567 009", "+84904567009"
EMAIL = "hiephoangmt@gmail.com"
ZALO = f"https://zalo.me/{TEL}"
AGENT = "Hoàng Hiệp Real Estate"

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
    "planA2": ("mat-bang-toa-a2-tang-3a-24-cora-tower", 2000, 1414, 1000, "Mặt bằng tòa A2 Cora Tower tầng 3A–24 với 28 căn mỗi sàn"),
    "iso1pn": ("phoi-canh-3d-can-1pn-cora-tower", 1024, 1536, 512, "Phối cảnh 3D nội thất căn hộ 1PN+ Cora Tower với logia, bếp, phòng khách và phòng ngủ"),
    "int1pn": ("noi-that-can-ho-1pn-cora-tower", 1080, 1080, 540, "Phối cảnh nội thất căn hộ 1PN+ Cora Tower"),
    "unit1pn": ("mat-bang-can-a10803-1pn-cora-tower", 1076, 1521, 538, "Mặt bằng căn hộ điển hình A10803 loại 1PN+1 tòa A1 Cora Tower, kích thước 6,2 x 9,6 m"),
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
    ("Studio", "32,0 – 32,2 m²", "36,1 m²", "Ở một mình, cho thuê ngắn hạn"),
    ("1PN+", "52,3 – 59,6 m²", "56,7 – 63,5 m²", "Vợ chồng trẻ, đầu tư cho thuê"),
    ("2PN", "60,6 – 73,4 m²", "66,1 – 79,4 m²", "Gia đình nhỏ, căn góc thoáng"),
    ("3PN", "78,9 m²", "85,7 – 86,7 m²", "Gia đình đa thế hệ, số lượng rất ít"),
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
    ("Khi nào Cora Tower bàn giao?", "Thông tin thị trường ghi bàn giao dự kiến 30/07/2027, tiêu chuẩn hoàn thiện trần, tường, sàn. Mốc chính thức theo hợp đồng mua bán."),
    ("Chính sách thanh toán, vay vốn Cora Tower thế nào?", "Ngân hàng cho vay tối đa 70% giá trị, hỗ trợ lãi suất 0% trong 24 tháng. Chương trình Sun Early Key: thanh toán 70% nhận nhà, 30% còn lại trong 24 tháng tiếp theo; có lựa chọn thanh toán sớm với ưu đãi theo từng đợt bán hàng."),
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
 "key": '<circle cx="8" cy="15" r="4"/><path d="M11 12l9-9M17 6l3 3"/>',
}


def icon(k):
    return f'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{ICON[k]}</svg>'


def card(k, title, text):
    return f'<div class="card reveal"><div class="icon">{icon(k)}</div><h3>{title}</h3><p class="sub">{text}</p></div>'


LOGO = ('<svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect x="5" y="6" width="8" height="21" rx="1.5" fill="#0b2a5b"/>'
        '<rect x="16" y="3" width="9" height="24" rx="1.5" fill="#f26b1d"/><rect x="2" y="26" width="26" height="2.5" rx="1" fill="#0b2a5b"/></svg>')

NAV = [("./", "Tổng quan", "index"), ("./#mat-bang", "Mặt bằng", ""), ("./#gia", "Bảng giá", ""),
       ("khoi-de-shophouse.html", "Shophouse", "shop"), ("penthouse.html", "Duplex – Penthouse", "ph"), ("./#vi-tri", "Vị trí", ""), ("phap-ly.html", "Pháp lý", "legal")]


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
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800&display=swap" rel="stylesheet">
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
    <a class="btn head-cta" href="tel:{TEL}">{TEL_TXT}</a>
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
  <div class="wrap">
    <div><strong>{AGENT}</strong>Tư vấn, phân phối căn hộ – shophouse – duplex Cora Tower và bất động sản Đà Nẵng.</div>
    <div><strong>Liên hệ</strong>Hotline/Zalo: <a href="tel:{TEL}">{TEL_TXT}</a><br>Email: <a href="mailto:{EMAIL}">{EMAIL}</a></div>
    <div><strong>Cora Tower</strong><a href="./">Tổng quan dự án</a><br><a href="./#mat-bang">Mặt bằng A1 – A2</a><br><a href="khoi-de-shophouse.html">Shophouse khối đế</a><br><a href="penthouse.html">Duplex – Penthouse</a><br><a href="phap-ly.html">Pháp lý dự án</a></div>
    <div class="legal">Website do đơn vị tư vấn độc lập xây dựng, không phải website chính thức của chủ đầu tư. Hình ảnh phối cảnh, mặt bằng mang tính minh họa; thông tin, giá bán mang tính tham khảo và theo công bố chính thức của chủ đầu tư tại từng thời điểm.</div>
  </div>
</footer>

<div class="fab" aria-label="Liên hệ nhanh">
  <a class="fab-call" href="tel:{TEL}" aria-label="Gọi {TEL_TXT}">{PHONE_SVG}<span>{TEL_TXT}</span></a>
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
<div class="chat-teaser" hidden><button type="button" class="t-x" aria-label="Ẩn">×</button><p data-chat-open>Anh/chị cần <b>bảng giá 1PN+</b> hoặc chọn căn đẹp? Em tư vấn ngay ạ 👋</p></div>

<script>window.CORA = {{ tel: "{TEL}", telText: "{TEL_TXT}", zalo: "{ZALO}", email: "{EMAIL}" }};</script>
<script src="assets/main.js" defer></script>
<script src="assets/chat.js" defer></script>'''

LIGHTBOX = '<div class="lightbox" role="dialog" aria-label="Xem ảnh"><button type="button" aria-label="Đóng">×</button><img alt=""></div>'


def plan_tabs():
    return f'''<div class="tabs reveal" role="tablist">
        <button role="tab" aria-selected="true" data-tab="plan-a1">Tòa A1</button>
        <button role="tab" aria-selected="false" data-tab="plan-a2">Tòa A2</button>
      </div>
      <div class="plan zoom" id="plan-a1"><a href="{src("planA1")}" class="zoom-link">{pic("planA1", "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>
      <div class="plan zoom" id="plan-a2" hidden><a href="{src("planA2")}" class="zoom-link">{pic("planA2", "(max-width:1180px) 100vw, 1148px")}<span class="zoom-hint">Bấm để phóng to</span></a></div>
      <p class="note">Mặt bằng tầng 3A–24, mỗi tòa 28 căn/sàn. Diện tích ghi: thông thủy / tim tường. Thông số chính thức theo văn bản ký kết với khách hàng.</p>'''


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
         "image": [f"{D}{src(k)}" for k in ("hero", "a1a2", "night", "aerial", "struct", "site", "planA1", "planA2", "unit1pn", "iso1pn")],
         "address": {"@type": "PostalAddress", "streetAddress": "Vòng xoay đường 29/3 – Nguyễn Phước Lan, KĐT Nam Hòa Xuân", "addressLocality": "Đà Nẵng", "addressCountry": "VN"},
         "amenityFeature": [{"@type": "LocationFeatureSpecification", "name": n, "value": True} for n in ("Shophouse thương mại", "Dịch vụ – tiện ích tầng 2", "Căn hộ sân vườn", "Hầm để xe")]},
        faq_ld(FAQ_INDEX),
    ]
    h = head("index", "Cora Tower Đà Nẵng – Bảng giá, mặt bằng căn hộ, shophouse, duplex | Hotline 0904 567 009",
             "Cora Tower (Sun Group) – 2 tòa A1, A2 cao 25 tầng tại vòng xoay 29/3 – Nguyễn Phước Lan, Hòa Xuân. Căn 1PN+ tầng 15 từ ~3,1 tỷ, mặt bằng 28 căn/sàn, shophouse khối đế, duplex tầng 25. Gọi 0904 567 009.",
             "Cora Tower, Sun Cora Tower, Cora Tower Đà Nẵng, giá Cora Tower, mặt bằng Cora Tower, căn hộ 1PN+ Cora Tower, shophouse Cora Tower, duplex Cora Tower, căn hộ 29/3 Hòa Xuân",
             "og-cora-tower.jpg", "Phối cảnh Cora Tower Đà Nẵng", "hero", graph)
    body = f'''{header("index", "Nhận bảng giá")}

<main>
  <section class="hero">
    {pic("hero", "100vw", eager=True, cls="hero-bg")}
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
        <h2>Mặt bằng tòa A1 – A2, tầng 3A – 24</h2>
        <p class="sub">Mỗi tòa 28 căn/sàn, hành lang giữa, 2 lõi thang. Bấm vào mặt bằng để xem rõ từng mã căn.</p>
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
        {pic("shop", "(max-width:900px) 100vw, 600px")}
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

  <section id="hinh-anh">
    <div class="wrap">
      <div class="center reveal">
        <span class="kicker">Hình ảnh</span>
        <h2>Phối cảnh Cora Tower</h2>
      </div>
      <div class="gallery reveal">
        <a href="{src("aerial")}">{pic("aerial", "(max-width:760px) 100vw, 600px")}<span>Toàn cảnh</span></a>
        <a href="{src("a1a2")}">{pic("a1a2", "(max-width:760px) 50vw, 300px")}<span>Tòa A1 – A2</span></a>
        <a href="{src("hero")}">{pic("hero", "(max-width:760px) 50vw, 300px")}<span>Hoàng hôn</span></a>
        <a href="{src("shop")}">{pic("shop", "(max-width:760px) 50vw, 300px")}<span>Khối đế</span></a>
        <a href="{src("loc")}">{pic("loc", "(max-width:760px) 50vw, 300px")}<span>Vị trí A1 – A2</span></a>
        <a href="{src("night")}">{pic("night", "(max-width:760px) 50vw, 300px")}<span>Về đêm</span></a>
        <a href="{src("land")}">{pic("land", "(max-width:760px) 50vw, 300px")}<span>Khu đất thực tế</span></a>
        <a href="{src("int1pn")}">{pic("int1pn", "(max-width:760px) 50vw, 300px")}<span>Nội thất 1PN+</span></a>
        <a href="{src("river")}">{pic("river", "(max-width:760px) 50vw, 300px")}<span>Hòa Xuân ven sông</span></a>
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
         "image": [f"{D}{src('shop')}", f"{D}{src('a1a2')}", f"{D}{src('struct')}"], "brand": {"@type": "Brand", "name": "Cora Tower"}},
        crumbs("Shophouse khối đế", url), faq_ld(FAQ_SHOP),
    ]
    h = head("khoi-de-shophouse", "Shophouse khối đế Cora Tower Đà Nẵng – Mặt tiền vòng xoay 29/3 | 0904 567 009",
             "Shophouse khối đế Cora Tower (Sun Group) tầng 1, mặt tiền vòng xoay 29/3 – Nguyễn Phước Lan, Hòa Xuân. Kính kịch trần, pháp lý đầy đủ, giá 4,96 – 6,04 tỷ/căn (43 – 61,5 m²). Gọi 0904 567 009.",
             "shophouse Cora Tower, khối đế Cora Tower, shophouse khối đế Đà Nẵng, shophouse Hòa Xuân, shophouse 29/3, shophouse Sun Neo City",
             "og-shophouse.jpg", "Khối đế shophouse Cora Tower", "shop", graph)
    body = f'''{header("shop", "Nhận giỏ hàng")}

<main>
  <section class="hero">
    {pic("shop", "100vw", eager=True, cls="hero-bg")}
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
              <tr><th scope="row">Diện tích</th><td>43,1 – 61,5 m² thông thủy · liên hệ {TEL_TXT} nhận giỏ hàng từng căn</td></tr>
            </tbody>
          </table>
        </div>
        <p class="note">Số liệu tổng hợp, chỉ mang tính tham khảo. Giá và chính sách chính thức theo chủ đầu tư tại từng thời điểm.</p>
      </div>
      <div class="split-media reveal zoom"><a href="{src("struct")}" class="zoom-link">{pic("struct", "(max-width:900px) 100vw, 600px", alt="Cấu trúc tòa Cora Tower: tầng 1 shophouse thương mại, tầng 2 dịch vụ tiện ích")}</a></div>
    </div>
  </section>

  <section>
    <div class="wrap split rev">
      <div class="split-media reveal">{pic("a1a2", "(max-width:900px) 100vw, 600px")}</div>
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
         "image": [f"{D}{src('ph')}", f"{D}{src('hero')}", f"{D}{src('struct')}"],
         "containedInPlace": {"@id": f"{D}#project"},
         "address": {"@type": "PostalAddress", "streetAddress": "Vòng xoay đường 29/3 – Nguyễn Phước Lan, KĐT Nam Hòa Xuân", "addressLocality": "Đà Nẵng", "addressCountry": "VN"}},
        crumbs("Duplex – Penthouse", url), faq_ld(FAQ_PH),
    ]
    h = head("penthouse", "Penthouse – Duplex Cora Tower Đà Nẵng tầng 25 | Hotline 0904 567 009",
             "Căn duplex – penthouse tầng 25 Cora Tower (Sun Group) trong khối mái biểu tượng, thông tầng, sân vườn trên cao, view sông và thành phố Đà Nẵng. Số lượng giới hạn – gọi 0904 567 009.",
             "penthouse Cora Tower, duplex Cora Tower, căn hộ tầng 25 Cora Tower, penthouse Đà Nẵng, penthouse Hòa Xuân, duplex Đà Nẵng",
             "og-penthouse.jpg", "Không gian sân vườn duplex penthouse Cora Tower", "ph", graph)
    body = f'''{header("ph", "Nhận giá duplex")}

<main>
  <section class="hero">
    {pic("ph", "100vw", eager=True, cls="hero-bg")}
    <div class="wrap hero-grid">
      <div>
        <nav class="breadcrumb" aria-label="breadcrumb"><a href="./">Cora Tower</a> › Duplex – Penthouse</nav>
        <span class="eyebrow">Tầng 25 · Duplex · Số lượng giới hạn</span>
        <h1>Penthouse – Duplex Cora Tower – <em>đỉnh cao</em> sống giữa trời Đà Nẵng</h1>
        <p class="lead">Những căn duplex ở tầng cao nhất, nằm trong khối mái kiến trúc màu cam biểu tượng – không gian thông tầng, sân vườn trên cao, tầm nhìn toàn cảnh sông và thành phố.</p>
        <ul class="ticks"><li>Tầng cao nhất</li><li>Thông tầng</li><li>Pháp lý đầy đủ</li></ul>
        <div class="cta"><a class="btn ghost lg" href="tel:{TEL}">Gọi {TEL_TXT}</a></div>
      </div>
      {hero_form("Đăng ký ưu tiên duplex", "Số lượng rất giới hạn – nhận mặt bằng và giá trước khi công bố rộng rãi.", "Duplex – Penthouse", "Đăng ký ưu tiên")}
    </div>
  </section>
  {stats([(25, "", "25", "tầng cao nhất"), (2, "", "2", "tầng thông (duplex)"), (360, "°", "360°", "tầm nhìn thành phố"), (2, "", "2", "tòa tháp A1 &amp; A2")])}

  <section>
    <div class="wrap">
      <div class="center reveal"><span class="kicker">Khác biệt</span><h2>Điểm khác biệt của duplex – penthouse Cora Tower</h2></div>
      <div class="grid g3" style="margin-top:36px">
        {card("ceiling", "Trần cao ~7 m", "Đủ chiều cao làm thêm tầng lửng thành duplex 2 tầng; chủ đầu tư có layout duplex gợi ý.")}
        {card("eye", "Tầm nhìn toàn cảnh", "Tầng cao nhất tòa tháp, view sông Cẩm Lệ, trung tâm Đà Nẵng và khu Sun Neo City.")}
        {card("crown", "Khối mái biểu tượng", "Nằm trong khối kiến trúc màu cam đặc trưng – dấu ấn nhận diện của Cora Tower.")}
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
              <tr><th scope="row">Cách tính giá</th><td>Theo đơn nguyên 1 căn</td></tr>
              <tr><th scope="row">Hoàn thiện</th><td>Trong 12 tháng từ ngày bàn giao</td></tr>
              <tr><th scope="row">Tiện ích</th><td>Sân vườn trên cao; dịch vụ – tiện ích tại tầng 2 khối đế</td></tr>
              <tr><th scope="row">Pháp lý</th><td>Đủ điều kiện bán, bảo lãnh VietinBank – <a href="phap-ly.html">xem hồ sơ</a></td></tr>
              <tr><th scope="row">Diện tích, giá</th><td>Liên hệ {TEL_TXT} để nhận mặt bằng và bảng giá</td></tr>
            </tbody>
          </table>
        </div>
        <p class="note">Thông tin tổng hợp, chỉ mang tính tham khảo. Thông số chính thức theo hồ sơ của chủ đầu tư.</p>
      </div>
      <div class="split-media reveal zoom"><a href="{src("struct")}" class="zoom-link">{pic("struct", "(max-width:900px) 100vw, 600px", alt="Cấu trúc tòa Cora Tower: tầng 25 căn hộ duplex trong khối mái")}</a></div>
    </div>
  </section>

  <section>
    <div class="wrap split rev">
      <div class="split-media reveal">{pic("night", "(max-width:900px) 100vw, 600px", alt="Khối mái màu cam phát sáng về đêm – nơi bố trí căn duplex tầng 25 Cora Tower")}<div class="badge">Dành cho số ít<small>ưu tiên khách đăng ký sớm</small></div></div>
      <div class="reveal">
        <span class="kicker">Chủ nhân</span>
        <h2>Duplex – penthouse dành cho ai?</h2>
        <ul class="check">
          <li>Gia đình đa thế hệ cần không gian rộng, nhiều phòng</li>
          <li>Doanh nhân muốn nơi ở kiêm không gian tiếp khách đẳng cấp</li>
          <li>Nhà đầu tư tìm sản phẩm khan hiếm, giữ giá trị dài hạn</li>
          <li>Người yêu thiết kế muốn tự do cải tạo theo phong cách riêng</li>
        </ul>
        <a class="btn" href="#dang-ky">Đặt lịch tư vấn duplex</a>
      </div>
    </div>
  </section>

  {faq_section("Hỏi đáp về duplex – penthouse Cora Tower", FAQ_PH, '<p class="center" style="margin-top:20px">Xem thêm: <a href="./">Tổng quan dự án Cora Tower</a> · <a href="khoi-de-shophouse.html">Shophouse khối đế Cora Tower</a></p>')}

  {lead_section("Nhận mặt bằng &amp; giá duplex – penthouse", "Số lượng giới hạn – đăng ký để được ưu tiên xem căn và nhận chính sách mới nhất.", "Duplex – Penthouse", "Đăng ký ưu tiên")}
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


def sitemap():
    pages = {"": ["hero", "a1a2", "night", "aerial", "struct", "site", "siteAir", "planA1", "planA2", "unit1pn", "iso1pn", "int1pn", "cross", "land", "river"],
             "khoi-de-shophouse.html": ["shop", "a1a2", "struct"], "penthouse.html": ["ph", "night", "struct"], "phap-ly.html": ["night"]}
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
    (SITE / "sitemap.xml").write_text(sitemap())
    print("built", SITE)
