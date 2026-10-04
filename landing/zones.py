"""Content for the 4 zone pages (/bach-van, /vinh-may, /dao-ngoc, /tinh-van).

Facts come from developer sales material (policy flyers, unit sheets) and
public project information; anything not confirmed by the developer is
worded as "dự kiến" / "theo thông tin thị trường".
"""
from html import escape

ZONES = [
    {
        "slug": "bach-van", "name": "Bạch Vân", "zone_key": "Bạch Vân",
        "title": "Phân Khu Bạch Vân Vinhomes Hải Vân Bay – Giỏ Hàng, Giá & Chính Sách Về Ở Sớm 10%",
        "desc": "Phân khu Bạch Vân Vinhomes Hải Vân Bay (~112ha): cửa ngõ dự án, nhà phố, shophouse, biệt thự phong cách Hong Kong. Chính sách Về ở sớm 10%, vay 70%, HTLS 0%. Giỏ hàng độc quyền – 0909 882 555.",
        "badge": "Về ở sớm – chiết khấu đến 10%",
        "h1": "Phân khu Bạch Vân<span>Cửa ngõ Vinhomes Hải Vân Bay · Phong cách Hong Kong</span>",
        "sub": "Nhà phố, shophouse, biệt thự cạnh chợ Hong Kong, làng ẩm thực ven suối và Lifestyle Hub. Dòng <b>Thô xây luôn</b> nhận chiết khấu Về ở sớm đến <b>10%</b>.",
        "hero_img": "aerial-bach-van", "imgs": ["aerial-bach-van", "river-bach-van", "house-bach-van"],
        "policy_tab": "p-bv",
        "intro": "Bạch Vân là phân khu cửa ngõ của Vinhomes Hải Vân Bay, nằm sát trục kết nối về trung tâm Đà Nẵng và cảng Liên Chiểu. Phân khu được quy hoạch theo cảm hứng Hong Kong sôi động, tập trung nhà phố, shophouse và biệt thự bên hệ thống thương mại – dịch vụ, phù hợp cả an cư lẫn kinh doanh.",
        "facts": [("Diện tích", "~111,98 ha"), ("Phong cách", "Hong Kong"), ("Sản phẩm", "Liền kề, shophouse, biệt thự"),
                  ("Bàn giao", "Xây thô · Giãn xây"), ("Chính sách nổi bật", "Về ở sớm 10%"), ("Vị trí", "Cửa ngõ dự án")],
        "why": [("Vị trí cửa ngõ", "Gần trục giao thông chính, kết nối nhanh trung tâm Đà Nẵng, cảng Liên Chiểu và hầm Hải Vân."),
                ("Tiện ích thương mại", "Làng ẩm thực ven suối, chợ Hong Kong, Lifestyle Hub thể thao – giải trí, Hồ Ngọc Trai."),
                ("Dòng tiền linh hoạt", "Về ở sớm: 5% chiết khấu khi ký HĐMB + 5% hoàn lại khi đủ điều kiện; giãn 24/36 tháng.")],
        "products": [("Liền kề", "70 – 80 m²", "~213 – 245 m²", "Xây thô"),
                     ("Shophouse", "Theo bảng hàng", "Theo bảng hàng", "Xây thô / Giãn xây"),
                     ("Biệt thự", "Theo bảng hàng", "Theo bảng hàng", "Giãn xây")],
        "amenities": [("Làng ẩm thực ven suối", "Phố ẩm thực dọc suối cảnh quan, điểm hẹn cư dân & du khách."),
                      ("Chợ Hong Kong", "Khu thương mại sôi động theo cảm hứng Hong Kong."),
                      ("Lifestyle Hub", "Tổ hợp thể thao & giải trí ngoài trời."),
                      ("Hồ Ngọc Trai", "Hồ cảnh quan trung tâm, đường dạo ven hồ."),
                      ("Suối & thác cảnh quan", "Dòng suối xuyên phân khu, thác nước và công viên xanh."),
                      ("Kết nối cửa ngõ", "Gần trục giao thông chính, cảng Liên Chiểu, hầm Hải Vân.")],
        "prices": [("Liền kề 70 m² · xây thô", "6,4", "6,5", "6,8", "7,6", "7,9"),
                   ("Liền kề 80 m² · xây thô", "8,2", "8,4", "8,7", "9,7", "10,2")],
        "analysis": {
            "verdict": "Điểm vào vốn dễ tiếp cận nhất dự án, phù hợp an cư và kinh doanh thương mại.",
            "strategy": "Ưu tiên tiến độ chuẩn hoặc vay 70% (chỉ +3,5% so với chuẩn) kết hợp Về ở sớm để nhận đủ 10%. Hạn chế giãn 24/36 tháng vì theo phiếu giá căn mẫu chênh tới +16% / +21%.",
            "pros": ["Vốn từ ~6,5 tỷ (đã gồm VAT & KPBT)", "Chiết khấu Về ở sớm tổng 10%", "Gần chợ Hong Kong, làng ẩm thực, Lifestyle Hub – lợi thế khai thác kinh doanh", "Cửa ngõ, kết nối nhanh trung tâm & cảng Liên Chiểu"],
            "cons": ["Giãn thanh toán đắt hơn các phân khu khác", "Không sát biển như Đảo Ngọc", "5% Về ở sớm thứ hai chỉ hoàn khi đủ điều kiện"],
            "table": [("Thanh toán sớm", "−2,7%"), ("Tiến độ chuẩn", "0%"), ("Vay 70% · 18T", "+3,5%"), ("Giãn 24 tháng", "+16,0%"), ("Giãn 36 tháng", "+21,3%")],
        },
        "faq": [
            ("Phân khu Bạch Vân Vinhomes Hải Vân Bay ở đâu?", "Bạch Vân là phân khu cửa ngõ của Vinhomes Hải Vân Bay tại Làng Vân, Hòa Hiệp Bắc, Liên Chiểu, Đà Nẵng, gần trục kết nối trung tâm thành phố và cảng Liên Chiểu."),
            ("Bạch Vân có những loại sản phẩm nào?", "Bạch Vân gồm nhà phố liền kề, shophouse và biệt thự. Các căn liền kề phổ biến diện tích đất 70–80 m², diện tích xây dựng khoảng 213–245 m², bàn giao xây thô."),
            ("Chương trình Về ở sớm Bạch Vân là gì?", "Áp dụng cho dòng Thô xây luôn (Khu 1) từ 20/09/2026: chiết khấu 5% vào giá HĐMB khi ký và hoàn lại 5% khi đủ điều kiện Về ở sớm, tổng 10%."),
            ("Giá nhà phố Bạch Vân bao nhiêu?", "Giá liền kề Bạch Vân tham khảo từ khoảng 6,5–9 tỷ đồng/căn (đã gồm VAT & KPBT) tùy vị trí và phương án thanh toán. Giá căn độc quyền vui lòng liên hệ 0909 882 555."),
            ("Mua Bạch Vân được hỗ trợ vay thế nào?", "Vay tới 70%: PA01 tự trả lãi cố định 3%–9%/năm (18–60 tháng) hoặc PA02 hỗ trợ lãi suất 0% 18–36 tháng với giá điều chỉnh +3,5% đến +19,5%."),
        ],
    },
    {
        "slug": "vinh-may", "name": "Vịnh Mây", "zone_key": "Vịnh Mây",
        "title": "Phân Khu Vịnh Mây Vinhomes Hải Vân Bay – Giỏ Hàng, Giá & Chính Sách Giãn Xây 2026",
        "desc": "Phân khu Vịnh Mây Vinhomes Hải Vân Bay (~99,6ha, phong cách Malibu): liền kề, shophouse, biệt thự đơn lập trên đồi hướng vịnh. Giãn xây từ 01/10/2026 – thanh toán phần xây từ D+540 ngày. Giỏ hàng độc quyền – 0909 882 555.",
        "badge": "Giãn xây áp dụng từ 01/10/2026",
        "h1": "Phân khu Vịnh Mây<span>Đồi vịnh phong cách Malibu · Giãn xây D+540</span>",
        "sub": "Liền kề, shophouse và biệt thự đơn lập trên đồi giật cấp hướng vịnh. Chỉ thanh toán phần đất & thương mại trước, <b>phần xây dựng từ D+540 ngày</b>.",
        "hero_img": "villa-vinh-may", "imgs": ["aerial-vinh-may", "villa-vinh-may", "street-vinh-may"],
        "policy_tab": "p-vm",
        "intro": "Vịnh Mây trải rộng khoảng 99,59 ha trên địa hình đồi giật cấp, hướng tầm nhìn ra vịnh biển và thành phố Đà Nẵng. Phân khu mang tinh thần Malibu phóng khoáng với khoảng 689 sản phẩm, gồm dãy liền kề – shophouse dọc trục thương mại và quần thể biệt thự đơn lập ẩn mình giữa rừng.",
        "facts": [("Diện tích", "~99,59 ha"), ("Phong cách", "Malibu"), ("Quy mô", "~689 sản phẩm"),
                  ("Sản phẩm", "Liền kề, góc, biệt thự đơn lập"), ("Bàn giao", "Giãn xây 24T"), ("Tiện ích", "Oceania Clubhouse 6.500m²")],
        "why": [("Tầm nhìn vịnh", "Địa thế cao trên sườn đồi, nhiều căn hướng biển và thành phố, không gian riêng tư."),
                ("Giãn xây – nhẹ vốn", "Giai đoạn đầu chỉ thanh toán đất & thương mại; phần xây từ D+540 ngày, đợt đầu 10%."),
                ("Biệt thự hiếm", "Quỹ biệt thự đơn lập lớn trên đồi, diện tích đất tới hơn 275 m², phù hợp nghỉ dưỡng cao cấp.")],
        "products": [("Liền kề", "~75 m²", "~231 m²", "Giãn xây 24T"),
                     ("Liền kề góc", "~148 m²", "~338 m²", "Giãn xây 24T"),
                     ("Biệt thự đơn lập", "~275 m²", "~463 m²", "Giãn xây 24T")],
        "amenities": [("Oceania Clubhouse 6.500 m²", "Nhà hàng, lounge, không gian thư giãn dành riêng cư dân."),
                      ("Đồi biệt thự hướng vịnh", "Quần thể biệt thự đơn lập trên địa hình giật cấp, view biển."),
                      ("Phố thương mại", "Dãy liền kề – shophouse dọc trục chính, kinh doanh dịch vụ."),
                      ("Bãi biển & vịnh", "Tầm nhìn vịnh biển, kết nối bãi tắm trong dự án."),
                      ("Rừng & đường dạo", "Cảnh quan rừng tự nhiên, đường dạo bộ ven đồi."),
                      ("Trục ven biển", "Liền kề trục đường ven biển, kết nối nhanh trung tâm Đà Nẵng.")],
        "prices": [("Liền kề 75 m² · giãn xây 24T", "6,4", "6,6", "6,8", "7,1", "7,5"),
                   ("Liền kề góc 148 m² · giãn xây 24T", "11,3", "11,8", "12,1", "12,7", "13,5"),
                   ("Biệt thự đơn lập 275 m² · giãn xây 24T", "16,3", "17,1", "17,5", "18,4", "19,5")],
        "analysis": {
            "verdict": "Lựa chọn nhẹ vốn nhất để sở hữu view vịnh – nhờ giãn xây, 18 tháng đầu chỉ trả phần đất & thương mại.",
            "strategy": "Vốn vừa: tiến độ thường hoặc vay 70% PA01 18–24T cho phần đất & thương mại, dồn tiền xây từ D+540. Vốn dồi dào: thanh toán sớm tiết kiệm ~4% so với tiến độ chuẩn.",
            "pros": ["Giãn xây: phần xây từ D+540 ngày, đợt đầu chỉ 10%", "Địa thế đồi, nhiều căn view vịnh & thành phố", "Quỹ biệt thự đơn lập lớn – sản phẩm hiếm", "Thanh toán sớm tiết kiệm ~3,6–4,4% (căn mẫu)"],
            "cons": ["Phải chuẩn bị dòng tiền xây dựng từ D+540", "Giãn 36 tháng cộng ~13–14% tổng giá", "Biệt thự vốn lớn (~17 tỷ trở lên)"],
            "table": [("Thanh toán sớm", "−4,1%"), ("Tiến độ chuẩn", "0%"), ("Vay 70% · 18T", "+2,6%"), ("Giãn 24 tháng", "+7,3%"), ("Giãn 36 tháng", "+13,8%")],
        },
        "faq": [
            ("Phân khu Vịnh Mây có gì đặc biệt?", "Vịnh Mây rộng khoảng 99,59 ha, phong cách Malibu, nằm trên đồi giật cấp hướng vịnh với khoảng 689 sản phẩm gồm liền kề, shophouse và biệt thự đơn lập, có Oceania Clubhouse 6.500 m²."),
            ("Chính sách giãn xây Vịnh Mây áp dụng thế nào?", "Từ 01/10/2026, giá trị căn nhà gồm phần đất & thương mại và phần xây dựng. Khách thanh toán phần đất & thương mại theo phương án lựa chọn; phần xây dựng bắt đầu từ D+540 ngày, đợt đầu 10%, các đợt sau theo tiến độ và thông báo bàn giao."),
            ("Giá Vịnh Mây bao nhiêu?", "Liền kề Vịnh Mây tham khảo từ khoảng 6,6 tỷ, căn góc khoảng 11–12 tỷ, biệt thự đơn lập từ khoảng 17 tỷ (đã gồm VAT & KPBT, tiến độ chuẩn). Giá căn độc quyền vui lòng liên hệ 0909 882 555."),
            ("Vịnh Mây thanh toán giãn được bao lâu?", "Phần đất & thương mại có thể giãn 24 tháng (cộng 10%) hoặc 36 tháng (cộng 15%), hoặc thanh toán theo tiến độ thường trong hợp đồng."),
            ("Vay mua Vịnh Mây lãi suất bao nhiêu?", "Vay tối đa 70% giá trị đất & thương mại: PA01 lãi cố định 3% (18T), 4,5% (24T), 6% (30T), 7,5% (36T), 8,5% (48T), 9% (60T); PA02 lãi suất 0% 18–36 tháng, giá cộng +3,5% đến +19,5%."),
        ],
    },
    {
        "slug": "dao-ngoc", "name": "Đảo Ngọc", "zone_key": "Đảo Ngọc",
        "title": "Phân Khu Đảo Ngọc Vinhomes Hải Vân Bay – Giỏ Hàng, Giá & Cam Kết Thuê 7%/Năm",
        "desc": "Phân khu Đảo Ngọc Vinhomes Hải Vân Bay (~139ha, phong cách Ý): liền kề, shophouse sát biển cạnh VinWonders. Bản hoàn thiện cam kết tiền thuê 7%/năm × 3 năm, HTLS 0%, vay 70%. Giỏ hàng độc quyền – 0909 882 555.",
        "badge": "Cam kết tiền thuê 7%/năm × 3 năm",
        "h1": "Phân khu Đảo Ngọc<span>Trái tim giải trí bên vịnh biển · Phong cách Ý</span>",
        "sub": "Liền kề, shophouse sát biển bên VinWonders, Botanica Park và Pearl Garden. Bản hoàn thiện nội thất nhận <b>cam kết tiền thuê 7%/năm trong 3 năm</b>.",
        "hero_img": "aerial-dao-ngoc", "imgs": ["aerial-bay", "pool-dao-ngoc", "house-classic"],
        "policy_tab": "p-dn",
        "intro": "Đảo Ngọc rộng khoảng 138,84 ha, là trái tim giải trí của Vinhomes Hải Vân Bay với bãi biển nội khu, VinWonders Hải Vân, Botanica Park 8 ha và Pearl Garden 6.500 m². Kiến trúc lấy cảm hứng nước Ý, sản phẩm liền kề – shophouse có cả bản hoàn thiện nội thất để khai thác cho thuê ngay.",
        "facts": [("Diện tích", "~138,84 ha"), ("Phong cách", "Ý (Italia)"), ("Sản phẩm", "Liền kề, shophouse"),
                  ("Bàn giao", "Hoàn thiện · Giãn xây 18T"), ("Chính sách nổi bật", "CKTT 7%/năm × 3 năm"), ("Tiện ích", "VinWonders, Botanica Park")],
        "why": [("Sát biển & VinWonders", "Gần bãi biển nội khu và tổ hợp vui chơi VinWonders – nguồn khách du lịch quanh năm."),
                ("Thu nhập cam kết", "Căn hoàn thiện nhận CKTT 7%/năm × 3 năm; hoặc chọn chiết khấu Về ở sớm 10% (223 căn theo danh sách)."),
                ("Đa dạng phương án", "Hoàn thiện nội thất hoặc giãn xây 18 tháng; vay 70%, HTLS 0% 18–36 tháng.")],
        "products": [("Liền kề hoàn thiện", "~80 m²", "~232 m²", "Hoàn thiện nội thất"),
                     ("Liền kề", "~70 m²", "~214 – 217 m²", "Giãn xây 18T"),
                     ("Shophouse", "Theo bảng hàng", "Theo bảng hàng", "Theo bảng hàng")],
        "amenities": [("VinWonders Hải Vân", "Tổ hợp vui chơi giải trí đa chủ đề cho mọi thế hệ."),
                      ("Botanica Park 8 ha", "Công viên thực vật, không gian xanh trung tâm."),
                      ("Pearl Garden 6.500 m²", "Vườn cảnh quan và hồ bơi – công viên trung tâm."),
                      ("Bãi biển nội khu", "Bãi cát trắng, vịnh nước xanh ngay trước dãy nhà phố."),
                      ("Phố shophouse phong cách Ý", "Trục thương mại – dịch vụ phục vụ du khách."),
                      ("Hồ bơi & quảng trường", "Không gian sự kiện, vui chơi cho cư dân và du khách.")],
        "prices": [("Liền kề 70 m² · giãn xây 18T", "9,2", "9,4", "9,7", "10,2", "10,5"),
                   ("Liền kề 70 m² vị trí đẹp · giãn xây 18T", "12,5", "12,9", "13,2", "13,9", "14,5"),
                   ("Liền kề 80 m² · hoàn thiện (CKTT)", "15,4", "15,8", "16,4", "—", "—")],
        "analysis": {
            "verdict": "Phân khu mạnh nhất cho mục tiêu cho thuê và thu nhập thụ động nhờ biển, VinWonders và CKTT 7%/năm.",
            "strategy": "Đầu tư thụ động: chọn căn hoàn thiện nhận CKTT 7%/năm × 3 năm (≈18% quy về hiện tại). Muốn tự ở/tự khai thác: chọn Về ở sớm 10% trong danh sách 223 căn. Căn giãn xây 18T: vay 70% chỉ +2,7–3%.",
            "pros": ["Sát bãi biển nội khu, cạnh VinWonders, Botanica Park", "CKTT 7%/năm × 3 năm cho căn hoàn thiện", "Có cả bản hoàn thiện nội thất – khai thác ngay", "Bảo lãnh ngân hàng 0,5%"],
            "cons": ["Mức vốn cao hơn Bạch Vân, Vịnh Mây", "HTLS 0% không áp dụng với căn nhận CKTT", "Căn CKTT phải giao CĐT khai thác trong 3 năm"],
            "table": [("Thanh toán sớm", "−2,5%"), ("Tiến độ chuẩn", "0%"), ("Vay 70% · 18T", "+2,9%"), ("Giãn 24 tháng", "+8,2%"), ("Giãn 36 tháng", "+12,3%")],
        },
        "faq": [
            ("Phân khu Đảo Ngọc có tiện ích gì?", "Đảo Ngọc rộng khoảng 138,84 ha với bãi biển nội khu, VinWonders Hải Vân, Botanica Park 8 ha, Pearl Garden 6.500 m² và hồ bơi – công viên trung tâm."),
            ("Cam kết tiền thuê Đảo Ngọc thế nào?", "Căn hoàn thiện nhận cam kết tiền thuê (CKTT) 7%/năm trong 3 năm, khách bàn giao lại nhà cho Chủ đầu tư khai thác. Gói HTLS 0% không áp dụng với căn nhận CKTT."),
            ("223 căn Đảo Ngọc được quyền lợi gì?", "223 căn hữu hạn theo danh sách được chọn một trong hai: CKTT 7%/năm × 3 năm, hoặc chiết khấu Về ở sớm 10% vào giá HĐMB (trước VAT & KPBT), cam kết VOS trong 3 tháng từ ngày nhận nhà."),
            ("Giá Đảo Ngọc bao nhiêu?", "Liền kề giãn xây Đảo Ngọc tham khảo từ khoảng 9–13 tỷ, bản hoàn thiện khoảng 15–16 tỷ (đã gồm VAT & KPBT, tiến độ chuẩn), tùy vị trí. Giá căn độc quyền vui lòng liên hệ 0909 882 555."),
            ("Đảo Ngọc có hỗ trợ vay không?", "Có. Vay tối đa 70% theo điều kiện ngân hàng; lãi cố định 3%–9%/năm (18–60 tháng) hoặc HTLS 0% 18–36 tháng với giá cộng +3,5% đến +19,5%. Bảo lãnh ngân hàng 0,5%."),
        ],
    },
    {
        "slug": "tinh-van", "name": "Tinh Vân", "zone_key": "Tinh Vân",
        "title": "Phân Khu Tinh Vân Vinhomes Hải Vân Bay – Thông Tin, Quy Hoạch & Đăng Ký Sớm",
        "desc": "Phân khu Tinh Vân Vinhomes Hải Vân Bay (~162ha, phong cách Nhật Bản) – phân khu lớn nhất dự án, định hướng nghỉ dưỡng cao cấp. Đăng ký nhận thông tin, bảng giá và chính sách sớm nhất – 0909 882 555.",
        "badge": "Đăng ký nhận thông tin sớm",
        "h1": "Phân khu Tinh Vân<span>Phân khu lớn nhất · Nghỉ dưỡng phong cách Nhật Bản</span>",
        "sub": "Tinh Vân đang được chuẩn bị ra mắt. Để lại thông tin để <b>nhận bảng giá, chính sách và quỹ căn đầu tiên</b> ngay khi Chủ đầu tư công bố.",
        "hero_img": "beach", "imgs": ["beach", "beach-sunset", "aerial-bay"],
        "policy_tab": None,
        "intro": "Tinh Vân là phân khu có quy mô lớn nhất Vinhomes Hải Vân Bay với khoảng 161,75 ha, định hướng nghỉ dưỡng cao cấp lấy cảm hứng từ Nhật Bản, hòa vào cảnh quan rừng – biển dưới chân đèo Hải Vân. Thông tin sản phẩm, giá và chính sách chính thức sẽ được cập nhật ngay khi Chủ đầu tư công bố.",
        "facts": [("Diện tích", "~161,75 ha"), ("Phong cách", "Nhật Bản"), ("Định hướng", "Nghỉ dưỡng cao cấp"),
                  ("Sản phẩm", "Đang cập nhật"), ("Chính sách", "Chờ CĐT công bố"), ("Trạng thái", "Nhận đăng ký sớm")],
        "why": [("Quy mô lớn nhất", "Hơn 160 ha – chiếm gần 1/3 diện tích dự án, quỹ đất nghỉ dưỡng hiếm có tại Đà Nẵng."),
                ("Cảnh quan rừng – biển", "Không gian xanh, yên tĩnh, phù hợp biệt thự nghỉ dưỡng và khách sạn cao cấp."),
                ("Ưu tiên khách sớm", "Khách đăng ký trước được ưu tiên nhận thông tin, chọn căn và chính sách giai đoạn đầu.")],
        "products": [("Biệt thự nghỉ dưỡng", "Đang cập nhật", "Đang cập nhật", "Đang cập nhật"),
                     ("Sản phẩm khác", "Đang cập nhật", "Đang cập nhật", "Đang cập nhật")],
        "amenities": [("Cảnh quan rừng – biển", "Không gian xanh dưới chân đèo Hải Vân."),
                      ("Định hướng nghỉ dưỡng", "Biệt thự nghỉ dưỡng, khách sạn – resort cao cấp."),
                      ("Kết nối toàn dự án", "Dùng chung hệ sinh thái tiện ích 512 ha của Hải Vân Bay.")],
        "prices": [],
        "analysis": {
            "verdict": "Phân khu đón đầu – phù hợp khách muốn có thông tin và quỹ căn sớm nhất khi Chủ đầu tư công bố.",
            "strategy": "Đăng ký nhận thông tin sớm; trong lúc chờ, tham khảo chính sách hiện hành của Bạch Vân, Vịnh Mây, Đảo Ngọc để chuẩn bị phương án vốn.",
            "pros": ["Quy mô lớn nhất dự án (~162 ha)", "Định hướng nghỉ dưỡng cao cấp, cảnh quan rừng – biển", "Khách đăng ký sớm được ưu tiên thông tin giai đoạn đầu"],
            "cons": ["Chưa có sản phẩm, giá và chính sách chính thức", "Tiến độ mở bán chưa xác định"],
            "table": [],
        },
        "faq": [
            ("Phân khu Tinh Vân Vinhomes Hải Vân Bay rộng bao nhiêu?", "Tinh Vân rộng khoảng 161,75 ha, là phân khu lớn nhất trong 4 phân khu của Vinhomes Hải Vân Bay."),
            ("Tinh Vân theo phong cách gì?", "Theo thông tin dự án, Tinh Vân được định hướng nghỉ dưỡng cao cấp lấy cảm hứng phong cách Nhật Bản."),
            ("Khi nào Tinh Vân mở bán?", "Chủ đầu tư chưa công bố lịch mở bán chính thức. Để lại số điện thoại hoặc gọi 0909 882 555 để nhận thông tin sớm nhất."),
            ("Tinh Vân có chính sách bán hàng chưa?", "Chưa có chính sách chính thức cho Tinh Vân. Hiện các phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc đang áp dụng vay 70%, HTLS 0%, chiết khấu thanh toán sớm 11%/năm và voucher tới 30%."),
        ],
    },
]


def faq_html(items):
    det = "\n".join(
        '      <details%s><summary>%s</summary><p>%s</p></details>' % (" open" if i == 0 else "", escape(q), escape(a))
        for i, (q, a) in enumerate(items))
    return ('<!-- FAQ -->\n<section class="section alt" id="faq">\n  <div class="container">\n'
            '    <div class="center">\n      <span class="eyebrow">Hỏi đáp</span>\n'
            '      <h2 class="title">Câu hỏi thường gặp</h2>\n    </div>\n'
            '    <div class="faq">\n' + det + '\n    </div>\n  </div>\n</section>\n\n')


def zone_info_html(z):
    facts = "".join('<div class="fact"><small>%s</small><b>%s</b></div>' % (escape(k), escape(v)) for k, v in z["facts"])
    why = "".join('<div class="card"><h3>%s</h3><p>%s</p></div>' % (escape(h), escape(t)) for h, t in z["why"])
    rows = "".join("<tr><td><b>%s</b></td><td>%s</td><td>%s</td><td>%s</td></tr>" % tuple(map(escape, r)) for r in z["products"])
    imgs = "".join('<img src="img/%s.webp" alt="Phối cảnh phân khu %s Vinhomes Hải Vân Bay" loading="lazy">' % (i, escape(z["name"])) for i in z["imgs"])
    return f'''<!-- ZONEINFO -->
<section class="section" id="tong-quan">
  <div class="container overview" style="align-items:start">
    <div>
      <span class="eyebrow">Tổng quan phân khu</span>
      <h2 class="title">Phân khu {escape(z["name"])} có gì?</h2>
      <p class="lead">{escape(z["intro"])}</p>
      <div class="facts zfacts">{facts}</div>
      <h3 style="color:var(--navy-700);margin-top:8px">Loại sản phẩm tại {escape(z["name"])}</h3>
      <div style="overflow-x:auto"><table class="ptable"><thead><tr><th>Loại căn</th><th>Diện tích đất</th><th>Diện tích XD</th><th>Bàn giao</th></tr></thead><tbody>{rows}</tbody></table></div>
      <p class="disc">Thông số tham khảo theo tài liệu bán hàng; thông số chính thức theo HĐMB.</p>
    </div>
    <div class="zimgs">{imgs}</div>
  </div>
  <div class="container">
    <div class="why">{why}</div>
    <div class="more"><a href="#gio-hang" class="btn btn-primary">Xem giỏ hàng {escape(z["name"])}</a><a href="#lien-he" class="btn btn-outline" data-need="Bảng giá phân khu {escape(z["name"])}" data-pop>Nhận bảng giá {escape(z["name"])}</a></div>
  </div>
</section>

'''


def zone_links_html(current):
    cards = "".join('<a href="/%s"><b>Phân khu %s</b><small>%s</small></a>' % (z["slug"], escape(z["name"]), escape(z["badge"]))
                    for z in ZONES if z["slug"] != current)
    return ('<!-- ZONELINKS -->\n<section class="section" style="padding:56px 0">\n  <div class="container">\n'
            '    <div class="center"><span class="eyebrow">Khám phá thêm</span><h2 class="title" style="font-size:clamp(22px,3vw,30px)">Các phân khu khác tại Hải Vân Bay</h2></div>\n'
            '    <div class="qlinks" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">' + cards +
            '<a href="/"><b>Tổng quan dự án</b><small>Vinhomes Hải Vân Bay 512ha</small></a></div>\n  </div>\n</section>\n\n')


def zone_analysis_html(z):
    a = z["analysis"]
    pros = "".join("<li><i>+</i><span>%s</span></li>" % escape(x) for x in a["pros"])
    cons = "".join("<li><i>!</i><span>%s</span></li>" % escape(x) for x in a["cons"])
    rows = "".join('<tr><td><b>%s</b></td><td class="%s">%s</td></tr>' % (escape(k), "good" if v.startswith("−") else ("bad" if v.startswith("+") else ""), escape(v)) for k, v in a["table"])
    table = ('<div class="an-box"><h3>Chi phí theo phương án thanh toán</h3><p class="sub">So với tiến độ chuẩn, theo phiếu giá căn mẫu %s T10/2026.</p>'
             '<table class="cmp"><thead><tr><th>Phương án</th><th>Chênh lệch tổng giá</th></tr></thead><tbody>%s</tbody></table></div>' % (escape(z["name"]), rows)) if rows else ""
    return f'''<!-- ZONEANALYSIS -->
<section class="section alt" id="phan-tich">
  <div class="container">
    <div class="center">
      <span class="eyebrow">Phân tích đầu tư</span>
      <h2 class="title">Có nên mua phân khu {escape(z["name"])}?</h2>
      <p class="lead">{escape(a["verdict"])}</p>
    </div>
    <div class="insight" style="max-width:900px;margin:22px auto 0"><b>Chiến lược gợi ý:</b> {escape(a["strategy"])}</div>
    <div class="drivers">
      <div class="an-box up"><h3>Điểm mạnh</h3><ul>{pros}</ul></div>
      <div class="an-box risk"><h3>Cần cân nhắc</h3><ul>{cons}</ul></div>
    </div>
    <div class="an-grid">{table}<div class="an-box"><h3>Xem phân tích toàn dự án</h3><p class="sub">PA01 hay PA02, CKTT hay Về ở sớm, so sánh 4 phân khu và động lực tăng giá.</p><a href="/gio-hang#phan-tich" class="btn btn-outline">Đọc phân tích chi tiết →</a><a href="#lien-he" class="btn btn-gold" style="margin-top:10px;width:100%" data-need="Báo cáo phân tích phân khu {escape(z["name"])}" data-pop>Nhận báo cáo phân khu {escape(z["name"])}</a></div></div>
  </div>
</section>

'''


def zone_toc_html(z):
    items = [("tong-quan", "Thông số"), ("tien-ich-pk", "Tiện ích"), ("bang-gia", "Giá bán"), ("mat-bang", "Mặt bằng & layout"),
             ("gio-hang", "Bảng hàng"), ("chinh-sach", "Chính sách"), ("phap-ly", "Pháp lý"), ("phan-tich", "Phân tích"), ("faq", "Hỏi đáp")]
    if not z["policy_tab"]:
        items = [x for x in items if x[0] != "chinh-sach"]
    return ('<nav class="ztoc" aria-label="Mục lục phân khu"><div class="container">' +
            "".join('<a href="#%s">%s</a>' % (a, t) for a, t in items) + "</div></nav>\n")


def zone_detail_html(z):
    n = escape(z["name"])
    amen = "".join('<div class="card"><div class="ic">✦</div><h3>%s</h3><p>%s</p></div>' % (escape(a), escape(b)) for a, b in z["amenities"])
    if z["prices"]:
        rows = "".join("<tr><td><b>%s</b></td>%s</tr>" % (escape(r[0]), "".join("<td>%s</td>" % ("từ ~%s tỷ" % v if v != "—" else "—") for v in r[1:])) for r in z["prices"])
        price = (f'''<div style="overflow-x:auto"><table class="cmp" style="min-width:720px"><thead><tr><th>Loại căn</th><th>Thanh toán sớm</th><th>Tiến độ chuẩn</th><th>Vay 70% · 18T</th><th>Giãn 24T</th><th>Giãn 36T</th></tr></thead><tbody>{rows}</tbody></table></div>
      <p class="disc">Giá tham khảo đã gồm VAT & KPBT, theo phiếu giá căn mẫu T10/2026. Giá từng căn thay đổi theo vị trí, hướng, tầng – <b>liên hệ để nhận giá chính xác và giá ưu đãi độc quyền</b>.</p>''')
    else:
        price = '<div class="empty"><h3>Bảng giá đang chờ công bố</h3><p>Để lại thông tin để nhận bảng giá Tinh Vân ngay khi Chủ đầu tư phát hành.</p><a href="#lien-he" class="btn btn-primary" data-need="Bảng giá Tinh Vân khi công bố" data-pop>Đăng ký nhận bảng giá</a></div>'
    img0, img1 = z["imgs"][0], z["imgs"][-1]
    return f'''<!-- ZONEAMEN -->
<section class="section alt" id="tien-ich-pk">
  <div class="container">
    <div class="center"><span class="eyebrow">Tiện ích phân khu</span><h2 class="title">Tiện ích nổi bật tại {n}</h2>
      <p class="lead">Cư dân {n} sử dụng tiện ích riêng của phân khu và toàn bộ hệ sinh thái 512 ha của Vinhomes Hải Vân Bay.</p></div>
    <div class="grid amen" style="margin-top:28px">{amen}</div>
  </div>
</section>

<!-- ZONEPRICE -->
<section class="section" id="bang-gia">
  <div class="container">
    <div class="center"><span class="eyebrow">Giá bán</span><h2 class="title">Bảng giá tham khảo phân khu {n}</h2>
      <p class="lead">So sánh nhanh giá theo loại căn và phương án thanh toán.</p></div>
    <div class="an-box" style="margin-top:24px">{price}</div>
  </div>
</section>

<!-- ZONEPLAN -->
<section class="section alt" id="mat-bang">
  <div class="container">
    <div class="center"><span class="eyebrow">Mặt bằng & layout</span><h2 class="title">Tổng mặt bằng & layout mẫu nhà {n}</h2>
      <p class="lead">Tài liệu chính thức từ Chủ đầu tư, bản nét cao – gửi qua Zalo trong 5 phút.</p></div>
    <div class="an-grid">
      <a class="locked-doc" href="#lien-he" data-need="Tổng mặt bằng phân khu {n} (bản nét)" data-pop>
        <span class="ld-img" style="background-image:url(\'img/{img0}.webp\')"></span>
        <span class="ld-body"><b>Tổng mặt bằng phân khu {n}</b><small>Vị trí từng lô, hướng, trục đường, tiện ích theo quy hoạch điều chỉnh mới nhất.</small><span class="btn btn-primary">🔒 Nhận TMB bản nét</span></span>
      </a>
      <a class="locked-doc" href="#lien-he" data-need="Layout mẫu nhà (LOSK) phân khu {n}" data-pop>
        <span class="ld-img" style="background-image:url(\'img/{img1}.webp\')"></span>
        <span class="ld-body"><b>Layout mẫu nhà (LOSK)</b><small>Mặt bằng công năng từng tầng, kích thước phòng, phương án bố trí kinh doanh – ở.</small><span class="btn btn-primary">🔒 Nhận layout chi tiết</span></span>
      </a>
    </div>
    <div class="cta-band" style="margin-top:28px">
      <div>
        <h3>Nhận trọn bộ hồ sơ phân khu {n}</h3>
        <ul><li>Bảng giá & giỏ hàng độc quyền cập nhật hôm nay</li><li>Tổng mặt bằng, layout từng tầng, brochure</li><li>Phiếu tính giá theo phương án bạn chọn</li><li>Ưu tiên giữ căn đẹp & lịch tham quan miễn phí</li></ul>
      </div>
      <form class="js-lead" data-source="Hồ sơ phân khu {n}" novalidate>
        <input name="name" placeholder="Họ và tên" required autocomplete="name" aria-label="Họ và tên">
        <input name="phone" type="tel" placeholder="Số điện thoại / Zalo" required autocomplete="tel" aria-label="Số điện thoại">
        <input type="hidden" name="need" value="Trọn bộ hồ sơ phân khu {n}">
        <button class="btn btn-gold" type="submit">NHẬN HỒ SƠ {n.upper()}</button>
      </form>
    </div>
  </div>
</section>

'''
