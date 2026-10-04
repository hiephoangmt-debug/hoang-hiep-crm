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
