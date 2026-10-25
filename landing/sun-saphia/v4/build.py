# Dựng bộ trang Sun Saphia Residence theo giao diện Kick-off 23/10/2026
# Cách chạy: python3 build.py <commit chứa thư mục v4/img>
import sys
sys.path.insert(0, __import__('os').path.dirname(__file__))
from parts import *
from blocks import *
import calc_page

H = sys.argv[1] if len(sys.argv) > 1 else 'HASH'
V4 = RAW + H + '/landing/sun-saphia/v4/img/'
LOGO = V4 + 'logo-mark.webp'
FAV = V4 + 'favicon.png'
OG = V4 + 'chia-se-1200x630.jpg'
OUT = D + 'v4/out/'
ORG = {'@type': 'RealEstateAgent', '@id': MAIN + '/#tatiland', 'name': 'TATILAND – Công ty CP Đầu tư Địa ốc TATI', 'telephone': '+84904567009',
       'email': 'hiephoangmt@gmail.com', 'url': MAIN + '/', 'areaServed': 'Đà Nẵng', 'description': 'Đại lý phân phối chính thức dự án Sun Saphia Residence theo chứng nhận của Sun Property ngày 23/10/2026'}
RES = {'@type': 'Residence', '@id': MAIN + '/#du-an', 'name': 'Sun Saphia Residence', 'description': 'Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng: 30 tầng, 782 căn Studio, 1BR+, 2BR',
       'address': {'@type': 'PostalAddress', 'streetAddress': 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa', 'addressLocality': 'Phường Ngũ Hành Sơn', 'addressRegion': 'Đà Nẵng', 'addressCountry': 'VN'}}
PERSON = {'@type': 'Person', 'name': 'Hoàng Phạm Đình Hiệp', 'jobTitle': 'Giám đốc kinh doanh', 'worksFor': ORG}

def article_ld(title, desc, url, pub='2026-10-17', mod='2026-10-24'):
    return {'@type': 'Article', 'headline': title, 'description': desc, 'datePublished': pub, 'dateModified': mod,
            'author': PERSON, 'publisher': ORG, 'image': OG, 'mainEntityOfPage': url, 'inLanguage': 'vi', 'about': {'@id': MAIN + '/#du-an'}}

def page(path, title, desc, kw, body, lds, cur, tools=False, canon=None, robots='index,follow'):
    url = MAIN + path
    body = body.replace('{M}', MAIN)
    html = head(title, desc, canon or url, OG, kw, lds + [ORG, RES], FAV)
    html += '<body>\n' + header(cur, MAIN, LOGO) + '\n<main id="dau-trang">' + body + '</main>\n' + footer(MAIN) + '\n' + popup() + tail(tools) + '</body>\n</html>\n'
    return copy_fix(html)

def band(*a, **k):
    return '<div class="bandw">' + cta_band(*a, **k) + '</div>'

def ins(b, marker, html):
    assert marker in b, marker
    return b.replace(marker, html + marker, 1)

def bands_at(b, items):
    """Chèn dải CTA trước mục thứ n (đếm các thẻ <section class="sec ...>, mục đầu = 0)."""
    import re as _re
    pos = [m.start() for m in _re.finditer(r'<section class="sec', b)]
    for n, html in sorted(items, key=lambda x: -x[0]):
        if n < len(pos):
            b = b[:pos[n]] + html + b[pos[n]:]
    return b

def hero_home():
    return ('<section class="hero"><img class="sun" src="%smat-troi.webp" alt="" width="700" height="898" aria-hidden="true">'
            '<div class="wrap"><nav class="crumb" aria-label="Đường dẫn"><a href="{M}/">Trang chủ</a> › <span>Dự án Đà Nẵng</span> › <span>Sun Saphia Residence</span></nav>'
            '<div class="g2" style="margin-top:14px"><div>'
            '<span class="tag">🔥 Vừa Kick-off 23/10/2026 · <b>Dự kiến mở bán cuối 11/2026</b></span>'
            '<img class="ribbon" src="%sruy-bang.webp" alt="" width="608" height="232" style="margin-top:16px" aria-hidden="true">'
            '<h1 class="dp">Sun Saphia Residence – căn hộ <b>mặt biển đầu tiên</b> của Sun Group tại Đà Nẵng</h1>'
            + SLOGAN
            + author() +
            '<p class="lead just">Tòa tháp 30 tầng (114 m) trên cung đường tỷ đô Võ Nguyên Giáp – Trường Sa, 782 căn Studio, 1BR+, 2BR, trần cao 3,5 m, pháp lý 50 năm, '
            'Vietcombank – BIDV – NCB hỗ trợ vay. Bài viết tổng hợp toàn bộ thông tin chủ đầu tư công bố tại sự kiện Kick-off '
            '"Đón ánh dương – Giao hòa nhịp sống" ngày 23/10/2026.</p>'
            '<div class="stats"><div><b>30 tầng</b><span>114 m · 2 hầm</span></div><div><b>782 căn</b><span>Studio · 1BR+ · 2BR</span></div>'
            '<div><b>~400 m</b><span>ra bãi tắm Sơn Thủy</span></div><div><b>50 năm</b><span>thời hạn dự án</span></div></div>'
            '</div>'
            '<div class="hr">%s<div class="pic">%s<span>Phối cảnh minh họa</span></div></div></div></div></section>') % (
        SK, SK, form('dau', 'Web – trang chủ đầu trang', h='h2'),
        img('thap-bien-hoang-hon', 'Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên bờ biển Đà Nẵng lúc hoàng hôn', eager=True))

def home():
    fq, fld = faq([
        ('Sun Saphia Residence ở đâu?', 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng, trên trục biển Võ Nguyên Giáp – Trường Sa; ra bãi tắm Sơn Thủy khoảng 400 m qua công viên ven biển.'),
        ('Chủ đầu tư Sun Saphia Residence là ai?', 'Dự án do Sun Property – thành viên Tập đoàn Sun Group – phát triển, được giới thiệu là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng.'),
        ('Sun Saphia Residence có bao nhiêu tầng, bao nhiêu căn?', '1 tòa tháp 30 tầng, cao 114 m, 2 tầng hầm, tổng 782 căn trên khu đất 3.720,1 m². Căn hộ bố trí từ tầng 3A đến tầng 28, trần cao 3,5 m.'),
        ('Có những loại căn nào?', 'Studio 30–31 m² (513 căn), 1BR+ 50–51 m² (108 căn), 2BR 60–70 m² (133 căn), bàn giao hoàn thiện cơ bản.'),
        ('Pháp lý Sun Saphia Residence thế nào?', 'GCN đăng ký đầu tư mã dự án 2572746483 do Sở Tài chính TP Đà Nẵng cấp, chứng nhận lần đầu 17/09/2026; thời hạn dự án 50 năm; công trình cấp I, niên hạn sử dụng 100 năm. Nghị quyết 278/NQ-CP (18/9/2026) xác định thời hạn sử dụng chung cư theo niên hạn công trình.'),
        ('Giá bán Sun Saphia Residence bao nhiêu?', 'Chủ đầu tư chưa công bố bảng giá chính thức. Căn hộ mặt biển Đà Nẵng đang chào bán khoảng: studio 5,2–10,5 tỷ, 1BR 7,7–11,5 tỷ, 2BR 17,4–21,7 tỷ (tham khảo tại Kick-off).'),
        ('Khi nào mở bán, khi nào bàn giao?', 'Dự kiến mở bán cuối tháng 11/2026, bàn giao tháng 11/2028 (kế hoạch, có thể thay đổi theo công bố của chủ đầu tư).'),
        ('Vì sao nên quan tâm từ bây giờ?', 'Lãi suất đang có tín hiệu giảm, giai đoạn đầu thường có chính sách giá và hỗ trợ lãi suất tốt nhất, và người đăng ký sớm được chọn căn đẹp trước. Chính sách cụ thể theo công bố khi mở bán.'),
        ('Bây giờ có phải đặt cọc không?', 'Không. Hiện chỉ đăng ký nhận thông tin, bảng giá và mặt bằng; không thu bất kỳ khoản tiền nào.')])
    toc = [('thoi-diem', 'Thời điểm thị trường'), ('vi-sao-mua-som', 'Vì sao nên mua sớm'), ('tong-quan', 'Thông tin tổng quan'), ('vi-tri', '01 Vị trí'),
           ('tam-nhin', '02 Sông – Núi – Biển'), ('thiet-ke', '03 Cảm hứng thiết kế'), ('mat-bang', '04 Cơ cấu sản phẩm & chọn căn'), ('phap-ly', '05 Pháp lý'),
           ('tien-ich', '06 Tiện ích "may đo"'), ('chu-nhan', '07 Chủ nhân tương lai'), ('khan-hiem', '08 Mức độ khan hiếm'), ('cho-thue', '09 Dòng tiền cho thuê'),
           ('tien-do', 'Tiến độ'), ('hoi-dap', 'Hỏi đáp')]
    b = hero_home()
    b += tldr('Sun Saphia Residence', [('Là gì', 'Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng, do Sun Property phát triển'), ('Vị trí', 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, phường Ngũ Hành Sơn; ra biển Sơn Thủy ~400 m'),
        ('Quy mô', '1 tòa 30 tầng (114 m), 2 hầm, 782 căn trên 3.720,1 m²'), ('Loại căn', 'Studio 30–31 m² (513) · 1BR+ 50–51 m² (108) · 2BR 60–70 m² (133), trần 3,5 m'),
        ('Pháp lý', 'GCN đầu tư 2572746483 (17/09/2026), thời hạn 50 năm, công trình cấp I niên hạn 100 năm'), ('Ngân hàng', 'Vietcombank, BIDV, NCB hỗ trợ vay'),
        ('Mở bán · bàn giao', 'Dự kiến cuối 11/2026 · tháng 11/2028'), ('Giá bán', 'Chưa công bố; đăng ký để nhận bảng giá gốc qua Zalo 0904 567 009')])
    b += '<section class="sec" style="padding-top:0"><div class="wrap">' + daily() + '<div class="toc" style="margin-top:26px">' + ''.join('<a href="#%s">%s</a>' % t for t in toc) + '</div></div></section>'
    # Thời điểm
    b += ('<section class="sec nv" id="thoi-diem">' + tiles('tr') + '<div class="wrap">'
          + sh('★', 'Thời điểm', 'Bất động sản <b>dòng tiền – giá trị thực – nghỉ dưỡng</b> lên ngôi', 'y') +
          '<div class="g2" style="align-items:start"><div class="txt">'
          '<h3>Tín hiệu cắt giảm lãi suất dứt khoát</h3><p>Ngày 15/10/2026, thông điệp "lãi suất ngân hàng phải giảm xuống" được đưa ra; ngày 19/10/2026 Ngân hàng Nhà nước họp các ngân hàng thương mại. '
          'Chỉ trong 4 ngày có 2 công văn yêu cầu các ngân hàng giảm lãi suất; Agribank, Vietcombank, BIDV, MB, ACB, Sacombank, LPBank, VietBank, Nam A Bank đồng loạt giảm lãi suất cho vay (báo chí 10/2026).</p>'
          '<h3>Tín dụng khách sạn, khu nghỉ dưỡng được tách khỏi dư nợ bất động sản</h3><p>Mục tiêu thúc đẩy du lịch nghỉ dưỡng và BĐS nghỉ dưỡng, tạo điều kiện cho tổ chức tín dụng cấp tín dụng phù hợp, phát triển thị trường bền vững. Thị trường Đà Nẵng được hưởng lợi trực tiếp.</p>'
          '<h3>Du lịch nghỉ dưỡng có nền tăng trưởng dài hạn</h3><p>AI có thể tự động hóa 60–70% thời gian làm việc, giải phóng thời gian và thu nhập cho tiêu dùng trải nghiệm; chi tiêu của nhóm 60+ tuổi toàn cầu dự kiến đạt 34 nghìn tỷ USD vào 2036 (từ 19 nghìn tỷ USD năm 2024); '
          'thị trường du lịch nghỉ dưỡng – sức khỏe toàn cầu dự kiến tăng từ 525 tỷ USD (2025) lên 910 tỷ USD (2030), khoảng +11,6%/năm. Thứ máy móc không làm hộ được: chăm sóc, cảm xúc, trải nghiệm của con người.</p>'
          '<p class="src">Nguồn: WEF Future of Jobs Report 2025 · McKinsey · World Data Lab · ResearchAndMarkets (ước tính) – theo tài liệu Kick-off.</p>'
          '<h3>Chính sách nhà nước đưa BĐS nghỉ dưỡng cất cánh</h3><p>Nghị quyết 08 (16/1/2017) của Bộ Chính trị đưa du lịch thành ngành kinh tế mũi nhọn; Nghị quyết 26 xác định Đà Nẵng là 1 trong 3 cực tăng trưởng du lịch cùng Hà Nội và TP.HCM. '
          'Mục tiêu 2030: 45–50 triệu lượt khách quốc tế (gấp 2 lần 2025) và 80–90 tỷ USD tổng doanh thu du lịch (gấp 3 lần 2025). Bộ Tài chính cũng đề xuất thuế suất 0,2% với đất bỏ hoang, chậm đưa vào sử dụng – bỏ hoang càng lâu, chi phí càng tăng.</p>'
          '</div><div>'
          '<span class="ey">Đà Nẵng · 9 tháng đầu năm 2026</span><div class="kpi" style="grid-template-columns:1fr">'
          '<div><b>15,86 triệu</b><span>Lượt khách du lịch</span><small>+29,6% so với cùng kỳ 2025</small></div>'
          '<div><b>7,69 triệu</b><span>Lượt khách quốc tế</span><small>+28,9% so với cùng kỳ 2025</small></div>'
          '<div><b>52.945 tỷ đồng</b><span>Doanh thu du lịch</span><small>+26,2% so với cùng kỳ 2025</small></div></div>'
          '<div style="margin-top:16px">' + nq278() + '</div></div></div></div></section>')
    b += ('<section class="sec" id="vi-sao-mua-som"><div class="wrap">' + sh('?', 'Mua sớm', 'Tại sao nên chọn <b>thời điểm này</b>?', 'o') + why_now() + '</div></section>')
    # Tổng quan
    b += ('<section class="sec alt" id="tong-quan">' + tiles('tr') + '<div class="wrap">' + sh('i', 'Thông tin tổng quan', 'Dự án căn hộ <b>mặt biển đầu tiên</b> của Sun Group tại Đà Nẵng', 'n') +
          '<div class="g2 eq"><div>' + overview() + '<p class="note" style="margin-top:10px">Theo tài liệu công bố tại Kick-off 23/10/2026; giá bán và chính sách theo công bố chính thức của chủ đầu tư. <a class="lk" href="{M}/vi-sao-sun-group">Vì sao Sun Group ra mắt căn hộ mặt biển đầu tiên tại Đà Nẵng →</a></p></div>'
          '<div class="hr">' + fig('thap-cat-3', 'Tòa tháp Sun Saphia Residence 30 tầng giữa cây xanh, mặt đứng kính và ban công màu đồng', 'Tòa tháp 30 tầng – 114 m (phối cảnh minh họa)', cls='fill ct') + '<a class="btn" href="#" data-pop data-interest="Trang chủ – thông tin tổng quan">Nhận brochure &amp; bảng giá</a></div></div></div></section>')
    # 01 Vị trí
    b += pband('30 tầng bên <b>biển Mỹ Khê</b>', 'Tòa tháp cao 114 m – biểu tượng mới của Sun Group bên biển Đà Nẵng.', 'Web – dải ảnh tòa tháp')
    b += ('<section class="sec" id="vi-tri"><div class="wrap">' + sh('01', 'Vị trí', 'Tọa độ <b>trung điểm</b> hệ di sản Đà Nẵng', 'y') +
          '<div class="g2 eq"><div class="txt"><p>Dự án nằm ở giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, đúng đoạn nối đại lộ ven biển với "cung đường tỷ đô" của chuỗi resort Đà Nẵng – Hội An. '
          'Một hướng về trung tâm và bán đảo Sơn Trà, một hướng về Ngũ Hành Sơn và phố cổ Hội An; trước mặt là biển Mỹ Khê – Sơn Thủy.</p>'
          '<ul class="ck"><li><b>~400 m</b> ra bãi tắm Sơn Thủy qua công viên ven biển</li><li><b>~500 m</b> tới nhà ga LRT 09 (quy hoạch tuyến sân bay – Hội An)</li>'
          '<li><b>4 km</b> tới tổ hợp Galaxy và Đà Nẵng Downtown – đủ gần để kết nối, đủ xa để riêng tư</li><li><b>5–10 phút</b> tới Ngũ Hành Sơn, phố An Thượng · <b>10–15 phút</b> tới sân bay · <b>~30 phút</b> tới Hội An</li></ul>'
          '<p class="src">Khoảng cách theo tài liệu Kick-off; thời gian ước tính bằng ô tô.</p></div>'
          + ('<figure class="fg sodo"><img src="%s.webp" srcset="%s-800.webp 800w, %s.webp 1000w" sizes="(max-width: 760px) 100vw, 560px" width="1000" height="1400" alt="Sơ đồ kết nối Sun Saphia Residence với trung tâm Đà Nẵng, sân bay, Ngũ Hành Sơn, hướng đi Hội An" loading="lazy" decoding="async"><figcaption>Sơ đồ minh họa, không theo tỷ lệ</figcaption></figure>' % ((RAW + '7f7a743766755fec9902ed74af5562cdfdd7f1d8/landing/sun-saphia/v4/img/so-do-vi-tri',) * 3)) + '</div>'
          '<h3 style="margin-top:34px" class="dp" >Những yếu tố hạ tầng <b>thúc đẩy giá trị</b></h3>'
          '<div class="g3" style="margin-top:16px">'
          '<article class="card">' + img('mo-rong-duong-bien', 'Trục đường biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân được mở rộng', 'r') + '<h3 style="margin-top:12px">Mở rộng trục biển 2.633 tỷ</h3><p class="just">TP Đà Nẵng quyết định mở rộng đường Võ Nguyên Giáp, Trường Sa, Lạc Long Quân; tổng mức đầu tư dự kiến 2.633 tỷ đồng.</p></article>'
          '<article class="card">' + img('lrt', 'Minh họa tàu điện đô thị LRT trên cao', 'r') + '<h3 style="margin-top:12px">500 m tới nhà ga LRT 09</h3><p class="just">Từ sân bay về Saphia thuận tiện, từ Saphia đến các địa danh du lịch; mở ra tiềm năng thương mại dịch vụ, khai thác cho thuê và gia tăng giá trị. Giai đoạn 1 dự kiến khởi công 2/2027.</p></article>'
          '<article class="card">' + img('galaxy-downtown', 'Phối cảnh tổ hợp Galaxy và Đà Nẵng Downtown cách dự án khoảng 4 km', 'r') + '<h3 style="margin-top:12px">4 km tới Galaxy – Downtown</h3><p class="just">Trung tâm mới của thành phố đủ gần để kết nối mỗi ngày; Khu thương mại tự do Đà Nẵng (QĐ 1142/QĐ-TTg, 6/2025) kéo theo chuyên gia, doanh nghiệp.</p></article></div>'
          '<div class="g2 eq" style="margin-top:34px"><div class="txt"><span class="ey">Công viên bãi tắm ngay trước thềm nhà</span><h3 class="dp" style="font-size:28px">Từ dự án bỏ hoang <b>thành công viên công cộng</b></h3>'
          '<p>Dự án Hòn Ngọc Á Châu quy mô 12 ha khởi công năm 2010, triển khai thời gian ngắn rồi bỏ hoang, gây lãng phí đất đai. Theo các quyết định điều chỉnh, thành phố chủ trương thu hồi khoảng <b>2,45 ha đất phía Nam (rộng 90 m)</b> để làm công viên công cộng – ngay trước Sun Saphia Residence.</p>'
          '<p>Dự án Công viên, Câu lạc bộ thể thao biển và Bãi tắm Sơn Thủy có phương án khảo sát được phê duyệt theo Quyết định 130 ngày 20/3/2025, quy mô khoảng 3 ha, mật độ xây dựng khoảng 3,9% – chủ yếu cây xanh, bãi cát, sân thể thao.</p>'
          '<p><b>Mới nhất:</b> UBND TP Đà Nẵng đã ban hành <b>Quyết định 2958/QĐ-UBND</b> phê duyệt dự án đầu tư xây dựng <b>Công viên công cộng</b> trên phần đất thu hồi, diện tích khoảng <b>2,45 ha</b>, tổng mức đầu tư <b>hơn 47 tỷ đồng</b> từ ngân sách thành phố, thực hiện giai đoạn 2025–2027.</p>'
          '<ul class="ck"><li>Quảng trường biển, khu tổ chức sự kiện</li><li>Đường dạo, sân tập thể dục, khu vui chơi trẻ em, khu dã ngoại</li><li>Bãi đậu xe, nhà vệ sinh, khu tắm nước ngọt, nhà gửi đồ</li></ul>'
          '<p class="src">Nguồn: VietnamPlus · Báo Pháp luật · Báo Văn Hóa · VnEconomy · tài liệu Kick-off. Phần đất còn lại của dự án đang được xử lý theo kết luận thanh tra (9/2026).</p></div>'
          + ('<figure class="fg"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 900px" width="1600" height="786" alt="Ảnh vệ tinh có chú thích: Sun Saphia Residence, khu đất ven biển quy hoạch công viên phía trước, cách biển khoảng 400 m" loading="lazy" decoding="async"><figcaption>Khu đất công viên ven biển trước dự án</figcaption></figure>' % ((RAW + '07557a38e28b15379350b5b9ac36fc91356ef704/landing/sun-saphia/v4/img/vi-tri-saphia',) * 3)) + '</div></div></section>')
    # 02 Tầm nhìn
    b += ('<section class="sec alt" id="tam-nhin">' + tiles('tr') + '<div class="wrap">' + sh('02', 'Tầm nhìn', 'Sông, Núi, Biển <b>chung một tầm nhìn</b>', 'o') +
          '<div class="g2 eq"><div class="txt"><p>Từ tầng cao, thiên nhiên mở ra như một vũ điệu đa tầng cảnh sắc: dòng sông, dáng Ngũ Hành Sơn và sắc xanh biển Mỹ Khê cùng hiện diện trong một tầm nhìn khoáng đạt. '
          'Sông mềm mại, núi trùng điệp, biển mênh mang – ba lớp thiên nhiên hòa quyện, mang đến trải nghiệm sống giữa những chuyển động đặc trưng của Đà Nẵng.</p>'
          '<div class="trio"><div>Trước mặt là <b>Biển</b></div><div>Sau lưng là <b>Sông</b></div><div>Bên cạnh là <b>Núi</b></div></div></div>'
          + fig('song-nui-bien-art', 'Tranh minh họa sông, núi, biển Đà Nẵng hòa chung một tầm nhìn') + '</div>'
          '<div style="margin-top:26px">' + views() + '</div></div></section>')
    # 03 Thiết kế
    b += ('<section class="sec" id="thiet-ke"><div class="wrap">' + sh('03', 'Cảm hứng thiết kế', 'Vũ điệu Di sản – <b>dấu ấn Apsara</b> trong hình hài đương đại', 'n') +
          '<div class="g2 eq"><div class="txt"><p>Lấy cảm hứng từ nghệ thuật điêu khắc Chăm Pa và hình tượng vũ nữ Apsara, kiến trúc dự án chắt lọc tinh thần di sản để tái hiện bằng ngôn ngữ đương đại.</p>'
          '<p>Sự kết hợp giữa <b>bản sắc văn hóa địa phương</b> và <b>phong cách hiện đại</b> tạo nên một biểu tượng mới của Sun Group bên biển Đà Nẵng: khối tháp thẳng, mặt dài hướng biển, mặt đứng kính xanh nhạt với ban công và trụ màu đồng.</p></div>'
          + fig('apsara-art', 'Tranh vũ nữ Apsara cách điệu – cảm hứng thiết kế Vũ điệu Di sản của Sun Saphia Residence') + '</div></div></section>')
    # 04 Sản phẩm
    b += ('<section class="sec alt" id="mat-bang">' + tiles('tr') + '<div class="wrap">' + sh('04', 'Cơ cấu sản phẩm', 'Nhỏ diện tích – <b>lớn dư địa giá trị</b>', 'o') +
          '<p class="lead just">Căn diện tích gọn, vốn vào vừa sức, dễ ở và dễ cho thuê. Trần căn hộ cao 3,5 m, bàn giao hoàn thiện cơ bản. Mặt bằng tầng thiết kế tối ưu về tầm view biển Mỹ Khê.</p>'
          + units_table() +
          '<div class="g2 eq" style="margin-top:26px">' + fig('mat-bang-tong-the', 'Mặt bằng tổng thể Sun Saphia Residence hướng ra biển Mỹ Khê, phía trước là công viên ven biển', 'Mặt bằng tổng thể – tối ưu tầm view biển Mỹ Khê', wm=True)
          + fig('layout-tang-3a-28', 'Layout tầng điển hình 3A–28 tòa Saphia, 28 căn mỗi tầng', 'Layout tầng 3A–28', wm=True) + '</div>'
          '<div style="margin-top:22px">' + units_drawings() + '</div>'
          '<p style="margin-top:18px"><a class="btn sm nv" href="{M}/mat-bang">Xem chi tiết mặt bằng từng loại căn →</a></p>'
          '<div id="chon-can"></div></div></section>')
    # 05 Pháp lý
    b += ('<section class="sec" id="phap-ly"><div class="wrap">' + sh('05', 'Pháp lý dự án', 'Pháp lý <b>rõ ràng</b>, ngân hàng lớn đồng hành', 'n') + legal_box() +
          '<p style="margin-top:18px"><a class="btn sm nv" href="{M}/phap-ly">Pháp lý chi tiết &amp; Nghị quyết 278 →</a></p></div></section>')
    # 06 Tiện ích
    b += ('<section class="sec alt" id="tien-ich">' + tiles('tr') + '<div class="wrap">' + sh('06', 'Hệ tiện ích', 'Tiện ích <b>"may đo"</b> nghỉ dưỡng', 'y') +
          '<div class="g3">'
          '<article class="card">' + ('<img class="r" src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 400px" width="1600" height="900" alt="Hồ bơi tầng 3 nhìn ra biển lúc hoàng hôn – Sun Saphia Residence (ảnh minh họa)" loading="lazy" decoding="async">' % ((RAW + 'a0a6849c15880dc681b6e91708d2a0752bd2aa43/landing/sun-saphia/v4/img/ho-boi-tang-3',) * 3)) + '<h3 style="margin-top:12px">Wellness</h3><p>Hồ bơi tầng 3 view biển, phòng yoga – ngắm hoàng hôn từ mặt nước.</p></article>'
          '<article class="card">' + img('tien-ich-gym', 'Phòng gym, pilates hiện đại – tiện ích Healthy (ảnh minh họa)', 'r') + '<h3 style="margin-top:12px">Healthy</h3><p>Gym, pilates tại khu Gym &amp; Yoga; nhà trẻ, shop khối đế ngay trong tòa nhà.</p></article>'
          '<article class="card">' + img('the-thao-bien', 'Thể thao biển: bơi, dù lượn, kayak, jetski – tiện ích Waterfront (ảnh minh họa)', 'r') + '<h3 style="margin-top:12px">Waterfront</h3><p>Sống gắn với biển mỗi ngày: kayak, SUP, dù lượn, jetski ngay trước nhà.</p></article></div>'
          '<div class="g2 eq" style="margin-top:30px"><div class="txt"><span class="ey">Chuỗi 03 công viên bãi tắm</span><h3 class="dp" style="font-size:28px">Bãi biển hiện hữu <b>ngay trước thềm nhà</b></h3>'
          '<p>Bãi biển và vùng nước biển tại Việt Nam là tài sản công thuộc sở hữu toàn dân, do Nhà nước đại diện quản lý. Tại Saphia, bãi biển hiện hữu ngay trước "thềm nhà", cùng chuỗi 3 công viên bãi tắm:</p>'
          '<ul class="ck"><li><b>Bãi tắm Sơn Thủy</b> – bãi tắm đầu tiên trong chuỗi, sát khu Saphia</li><li><b>Công viên bãi tắm đối diện</b> – thuộc dự án thu hồi KDL Hòn Ngọc Á Châu, ngay trước dự án</li><li><b>Công viên bãi tắm Huyền Trân Công Chúa</b> – cuối đường Huyền Trân Công Chúa, gần Ngũ Hành Sơn</li></ul></div>'
          + ('<figure class="fg"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 900px" width="1600" height="785" alt="Ảnh vệ tinh khu Saphia: Sun Saphia Residence bên đường ven biển Võ Nguyên Giáp – Trường Sa, 3 đường xuống biển Mỹ Khê – Sơn Thủy, khu đất quy hoạch công viên" loading="lazy" decoding="async"><figcaption>3 đường xuống biển ngay trước khu Saphia</figcaption></figure>' % ((RAW + '120376417ef276742a1870df38743bff7bb94046/landing/sun-saphia/v4/img/ba-duong-xuong-bien',) * 3)) + '</div>'
          '<div class="g4 k2" style="margin-top:26px">'
          + fig('kayak', 'Chèo kayak trên mặt nước phẳng', '<b>Chèo kayak</b> – lướt trên mặt nước phẳng') + fig('sup', 'Chèo SUP đón bình minh trên biển', '<b>Chèo SUP</b> – đứng trên ván, đón bình minh')
          + fig('du-luon', 'Dù lượn trên biển xanh', '<b>Dù lượn</b> – nhìn Đà Nẵng từ trên cao') + fig('jetski', 'Jetski lướt sóng trên biển', '<b>Jetski</b> – tốc độ và sóng') + '</div>'
          '<p class="note">*Ảnh tiện ích, thể thao biển là ảnh minh họa.</p></div></section>')
    # 07 Chủ nhân
    b += ('<section class="sec" id="chu-nhan"><div class="wrap">' + sh('07', 'Chân dung khách hàng', 'Các chủ nhân tương lai của Saphia – <b>họ là ai?</b>', 'n') + personas() + '</div></section>')
    # 08 Khan hiếm
    b += ('<section class="sec alt" id="khan-hiem">' + tiles('tr') + '<div class="wrap">' + sh('08', 'Mức độ khan hiếm', 'Căn hộ mặt biển Đà Nẵng – <b>nguồn cung rất hữu hạn</b>', 'y') +
          '<div class="g2 eq"><div><p class="lead">Biển là tài nguyên hữu hạn. Sun Saphia Residence là căn hộ mặt biển hiếm hoi trên chuỗi resort Đà Nẵng – Hội An, cung đường tỷ đô Võ Nguyên Giáp – Trường Sa.</p>'
          + price_table() + '<p style="margin-top:14px"><a class="btn sm nv" href="{M}/bang-gia">Xem bảng giá &amp; tính vay →</a></p></div>'
          + fig('ban-do-gia-ban', 'Bản đồ giá chào bán các dự án căn hộ ven biển Đà Nẵng', 'Giá chào bán các dự án ven biển (tham khảo)') + '</div></div></section>')
    # 09 Dòng tiền
    b += ('<section class="sec" id="cho-thue"><div class="wrap">' + sh('09', 'Tiềm năng khai thác', 'Tiềm năng khai thác <b>dòng tiền vượt trội</b>', 'o') +
          '<p class="lead just">Đà Nẵng là điểm hội tụ 3 dòng di dân – một điểm đến: nhóm khách hàng thực, nguồn cầu thuê nhà bền vững.</p>' + migration() +
          '<div style="margin-top:30px">' + rent_night() + '</div><div class="g2 eq" style="margin-top:18px"><div>' + rent_month_table() + '</div>' + occ_chart() + '</div>'
          '<h3 class="dp" style="font-size:28px;margin:30px 0 14px">Ba nhóm <b>khách thuê</b> chính</h3>' + tenants() +
          '<div style="margin-top:26px">' + rent_case() + '</div><p><a class="btn sm nv" href="{M}/tinh-dong-tien">Tự tính dòng tiền theo căn →</a></p></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('♥', 'Giá trị', 'Bốn giá trị <b>cộng hưởng</b> trong một sản phẩm', 'n') + values4() + '</div></section>')
    b += ('<section class="sec" id="tien-do"><div class="wrap">' + sh('⌛', 'Tiến độ', 'Mốc thời gian <b>quan trọng</b>', 'y') + timeline() + '</div></section>')
    b += ('<section class="sec alt" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Câu hỏi thường gặp về <b>Sun Saphia Residence</b>', 'o') + fq +
          '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/') + '</div></section>')
    b = ins(b, '<section class="sec" id="vi-sao-mua-som">', band('Thời điểm vàng – đừng để lỡ đợt đầu', 'Nhận phân tích thị trường và bảng giá gốc ngay khi chủ đầu tư công bố.', 'Nhận bảng giá sớm', 'Trang chủ – sau mục thời điểm', ('/bang-gia', 'Xem trang Bảng giá')))
    b = ins(b, '<section class="sec alt" id="tam-nhin">', band('Muốn xem thực tế vị trí?', 'Chuyên viên gọi video Zalo, đi từ dự án ra biển cho anh/chị xem – miễn phí.', 'Đặt lịch xem vị trí', 'Trang chủ – đặt lịch xem vị trí', ('/mat-bang', 'Xem mặt bằng & hướng view')))
    b = ins(b, '<section class="sec" id="phap-ly">', band('Căn view biển đẹp có hạn trên mỗi tầng', 'Để lại số để được ưu tiên giữ chỗ căn anh/chị chọn ngay khi mở bán.', 'Ưu tiên chọn căn', 'Trang chủ – ưu tiên chọn căn', ('/mat-bang', 'Chọn căn trên mặt bằng tầng')))
    b = ins(b, '<section class="sec alt" id="tien-ich">', band('Nhận bản sao pháp lý &amp; chính sách vay', 'GCN đầu tư, tiến độ, chính sách Vietcombank – BIDV – NCB gửi qua Zalo.', 'Nhận hồ sơ pháp lý', 'Trang chủ – hồ sơ pháp lý', ('/phap-ly', 'Xem trang Pháp lý')))
    b = ins(b, '<section class="sec alt"><div class="wrap">' + sh('♥', 'Giá trị', 'Bốn giá trị <b>cộng hưởng</b> trong một sản phẩm', 'n'), band('Nhận bảng tính dòng tiền theo căn', 'Tính theo giá thật khi có bảng giá: giá thuê, lấp đầy, lợi nhuận từng căn.', 'Nhận bảng tính', 'Trang chủ – bảng tính dòng tiền', ('/tinh-dong-tien', 'Mở bảng tính dòng tiền')))
    b += cta_block('Web – trang chủ cuối trang')
    title = 'Sun Saphia Residence Đà Nẵng: Giá, Mặt bằng, Pháp lý 2026'
    desc = 'Sun Saphia Residence – căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng: 30 tầng, 782 căn, pháp lý 50 năm, Vietcombank, BIDV, NCB hỗ trợ vay. Mở bán cuối 11/2026.'
    lds = [article_ld(title, desc, MAIN + '/'), fld]
    kw = 'sun saphia residence, sun saphia đà nẵng, căn hộ sun saphia, giá sun saphia residence, mặt bằng sun saphia, pháp lý sun saphia, căn hộ mặt biển đà nẵng, căn hộ sun group đà nẵng'
    return page('/', title, desc, kw, b, lds, '/', tools=True)

# ---------- Trang nhánh ----------

TB2 = RAW + '3c076ddb411cdc4df18a30f1fd09bd98b60ff86a/landing/sun-saphia/v4/img/thap-bien-hoang-hon-2'
def pband(title, sub, interest):
    """Dải ảnh lớn: phối cảnh tòa tháp bên biển, chữ ở góc dưới, ảnh không bị che."""
    return ('<section class="pband"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1280w" sizes="100vw" width="1280" height="720" '
            'alt="Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên biển Mỹ Khê – Sơn Thủy, Đà Nẵng lúc hoàng hôn" loading="lazy" decoding="async">'
            '<span class="cap">Phối cảnh minh họa</span><div class="wrap"><div class="pbt"><h2 class="dp">%s</h2><p>%s</p>'
            '<button type="button" class="btn" data-pop data-interest="%s">Nhận bảng giá gốc</button></div></div></section>') % (TB2, TB2, TB2, title, sub, interest)

def sub_hero(path, name, h1, lead, img_name, alt, label):
    cr, ld = crumbs([('Trang chủ', MAIN + '/'), ('Sun Saphia Residence', MAIN + '/'), (name, MAIN + path)])
    return ('<section class="hero" style="padding-bottom:40px"><img class="sun" src="%smat-troi.webp" alt="" width="700" height="898" aria-hidden="true"><div class="wrap">%s'
            '<div class="g2" style="margin-top:14px"><div><span class="tag">🔥 Vừa Kick-off 23/10/2026 · <b>Dự kiến mở bán cuối 11/2026</b></span><img class="ribbon" src="%sruy-bang.webp" alt="" width="608" height="232" style="margin-top:14px" aria-hidden="true">'
            '<h1 class="dp">%s</h1>' + SLOGAN + '%s<p class="lead just">%s</p>%s</div><div class="hr">%s<div class="pic">%s</div></div></div></div></section>') % (
        SK, cr, SK, h1, author(), lead, hero_perks(), form('dau', label, h='h2'), (img_name if img_name.startswith('<') else img(img_name, alt, eager=True))), ld

def bang_gia():
    hero, cld = sub_hero('/bang-gia', 'Bảng giá', 'Giá Sun Saphia Residence – <b>bảng giá</b> căn hộ mặt biển Đà Nẵng',
                         'Đến ngày 23/10/2026, chủ đầu tư chưa công bố bảng giá chính thức Sun Saphia Residence; dự kiến công bố tại sự kiện mở bán cuối tháng 11/2026. Trang này tổng hợp giá thị trường căn hộ mặt biển Đà Nẵng, những yếu tố làm giá từng căn khác nhau, cách vay ngân hàng – và sẽ cập nhật ngay khi có giá.',
                         'thap-tren-cao-ngay', 'Toàn cảnh Sun Saphia Residence bên bờ biển Đà Nẵng nhìn từ trên cao', 'Web – bảng giá đầu trang')
    fq, fld = faq([
        ('Khi nào có bảng giá Sun Saphia Residence?', 'Dự kiến công bố tại sự kiện mở bán cuối tháng 11/2026. Anh/chị để lại số Zalo để nhận bảng giá gốc ngay khi chủ đầu tư công bố.'),
        ('Giá căn hộ mặt biển Đà Nẵng hiện bao nhiêu?', 'Theo giá chào bán trình bày tại Kick-off: studio khoảng 5,2–10,5 tỷ, 1BR 7,7–11,5 tỷ, 2BR 17,4–21,7 tỷ tùy dự án (The Soleil, Futa Residence, Nobu). The Newtown Diamond: 1BR+ 5,3–5,6 tỷ, 2BR 6,8–8,3 tỷ.'),
        ('Giá tham khảo 3 tỷ và 4,5 tỷ trong bài toán cho thuê là giá bán?', 'Không. Đó là giá giả định chủ đầu tư dùng để minh họa bài toán cho thuê (studio 30 m² và 1BR 50 m²), chưa phải giá bán chính thức.'),
        ('Ngân hàng nào cho vay mua Sun Saphia Residence?', 'Vietcombank, BIDV và NCB hỗ trợ cho vay. Tỷ lệ vay, thời gian ân hạn và hỗ trợ lãi suất theo chính sách bán hàng công bố khi mở bán.'),
        ('Mua qua đại lý có đắt hơn mua trực tiếp?', 'Không. TATILAND là đại lý phân phối chính thức do Sun Property chứng nhận, áp dụng bảng giá và chính sách gốc của chủ đầu tư.'),
        ('Bây giờ có phải đặt cọc để giữ giá?', 'Không. Hiện chỉ đăng ký nhận thông tin, không thu bất kỳ khoản tiền nào.')])
    b = hero
    b += tldr('giá Sun Saphia Residence', [('Giá chính thức', 'Chưa công bố đến 23/10/2026; dự kiến công bố khi mở bán cuối 11/2026'), ('Giá tham khảo trong bài toán', '3 tỷ (studio 30 m²), 4,5 tỷ (1BR 50 m²) – giá giả định, không phải giá bán'),
        ('Giá thị trường ven biển', 'Studio 5,2–10,5 tỷ · 1BR 7,7–11,5 tỷ · 2BR 17,4–21,7 tỷ (The Soleil, Futa, Nobu)'), ('Vay', 'Vietcombank, BIDV, NCB; hỗ trợ lãi suất theo chính sách khi mở bán'),
        ('Nhận bảng giá gốc', 'Đại lý chính thức TATILAND · Zalo 0904 567 009 · không thu tiền giữ chỗ')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('1', 'Tình trạng giá', 'Giá Sun Saphia Residence <b>hiện tại</b>', 'o') +
          '<div class="g2 eq"><div class="txt"><p>Chủ đầu tư Sun Property chưa công bố giá bán chính thức. Mọi con số "giá Sun Saphia" đang lan truyền trước ngày mở bán chỉ là phỏng đoán.</p>'
          '<p>Tại Kick-off, chủ đầu tư dùng <b>giá tham khảo 3 tỷ cho studio 30 m²</b> và <b>4,5 tỷ cho 1BR 50 m²</b> để minh họa bài toán cho thuê – đây là giá giả định, không phải giá bán.</p>'
          '<ul class="ck"><li>Bảng giá chính thức: dự kiến công bố cuối 11/2026</li><li>Phương thức thanh toán, hỗ trợ lãi suất: công bố cùng chính sách bán hàng</li><li>Người đăng ký trước nhận bảng giá và mặt bằng căn còn trống sớm nhất</li></ul>'
          + slogan_box('Bảng giá – giữa trang') + '</div>'
          '<div class="g2" style="gap:14px">' + why_cards() + '</div></div></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('2', 'So sánh', 'Giá căn hộ <b>mặt biển Đà Nẵng</b> đang chào bán', 'y') +
          '<div class="g2" style="align-items:start"><div>' + price_table() + '<p class="just" style="margin-top:14px">Sun Saphia Residence có lợi thế thương hiệu Sun Group, vị trí ngay trục biển Võ Nguyên Giáp – Trường Sa và cơ cấu căn nhỏ (65% là studio) giúp tổng vốn mỗi căn vừa sức hơn so với các dự án mặt biển hạng sang.</p></div>'
          + fig('ban-do-gia-ban', 'Bản đồ giá chào bán các dự án căn hộ ven biển Đà Nẵng: The Soleil, Futa Residence, Nobu, The Newtown Diamond', 'Vị trí và giá chào bán các dự án ven biển') + '</div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('3', 'Giá từng căn', 'Vì sao <b>mỗi căn một giá</b>?', 'n') +
          '<div class="g4"><div class="card"><h3 class="oc">Loại căn</h3><p>Studio 30 m², 1BR+ 50 m², 2BR 60–70 m² – tổng giá khác nhau theo diện tích.</p></div>'
          '<div class="card"><h3 class="oc">Tầng</h3><p>Căn hộ từ tầng 3A đến 28; tầng càng cao tầm view biển – sông – núi càng thoáng.</p></div>'
          '<div class="card"><h3 class="oc">Hướng view</h3><p>Hướng biển Mỹ Khê, hướng Ngũ Hành Sơn, hướng sông Hàn, hướng đô thị.</p></div>'
          '<div class="card"><h3 class="oc">Căn góc</h3><p>Căn góc bo tròn có hai mặt thoáng, số lượng ít trên mỗi tầng.</p></div></div>'
          '<p style="margin-top:16px"><a class="btn sm nv" href="{M}/mat-bang">Xem mặt bằng và chọn căn →</a></p></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('4', 'Vay ngân hàng', 'Vay mua căn hộ – <b>Vietcombank, BIDV, NCB</b>', 'o') +
          '<div class="g2" style="align-items:start"><div class="txt"><p>Ba ngân hàng hỗ trợ cho vay dự án: Vietcombank, BIDV, NCB. Lãi suất cho vay đang có xu hướng giảm sau chỉ đạo tháng 10/2026; chủ đầu tư thông tin mức hỗ trợ lãi suất cao nhất đang áp dụng cho giai đoạn đầu.</p>'
          + banks() +
          '<h3 style="margin-top:18px">Hồ sơ vay thường cần</h3><ul class="ck"><li>CCCD, giấy tờ cư trú, tình trạng hôn nhân</li><li>Chứng minh thu nhập: sao kê lương, hợp đồng thuê, kinh doanh</li><li>Hợp đồng mua bán / thỏa thuận đặt cọc với chủ đầu tư</li></ul>'
          '<p class="note" style="margin-top:10px">Bảng tính bên cạnh chỉ để ước lượng; con số thực tế theo hồ sơ vay và chính sách từng ngân hàng.</p>'
          '<button type="button" class="btn sm" data-pop data-interest="Bảng giá – tư vấn vay">Nhận tư vấn phương án vay</button></div>'
          '<div class="calc" id="tinh-vay"><h3>Tính trả góp hàng tháng</h3>'
          '<label>Giá căn (tỷ đồng) <output id="vg">3</output></label><input type="range" id="ig" min="2" max="12" step="0.1" value="3">'
          '<label>Tỷ lệ vay <output id="vt">50%%</output></label><input type="range" id="it" min="10" max="70" step="5" value="50">'
          '<label>Lãi suất (%%/năm) <output id="vl">8</output></label><input type="range" id="il" min="5" max="12" step="0.1" value="8">'
          '<label>Thời hạn (năm) <output id="vn">20</output></label><input type="range" id="in" min="5" max="30" step="1" value="20">'
          '<div class="res"><div><b id="r1">–</b><span>Số tiền vay</span></div><div><b id="r2">–</b><span>Trả mỗi tháng (gốc + lãi đều)</span></div><div><b id="r3">–</b><span>Vốn tự có</span></div></div></div></div></div></section>'
          '<script>(function(){function $(i){return document.getElementById(i)}function f(v){return v>=1e9?(v/1e9).toFixed(2).replace(".",",")+" tỷ":Math.round(v/1e6).toLocaleString("vi-VN")+" tr"}'
          'function u(){var g=+$("ig").value*1e9,t=+$("it").value/100,l=+$("il").value/1200,n=+$("in").value*12,v=g*t,m=v*l/(1-Math.pow(1+l,-n));'
          '$("vg").textContent=$("ig").value.replace(".",",");$("vt").textContent=$("it").value+"%%";$("vl").textContent=$("il").value.replace(".",",");$("vn").textContent=$("in").value;'
          '$("r1").textContent=f(v);$("r2").textContent=f(m);$("r3").textContent=f(g-v);}["ig","it","il","in"].forEach(function(i){$(i).addEventListener("input",u)});u();})();</script>') % ()
    b += ('<section class="sec alt" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp về <b>giá Sun Saphia</b>', 'y') + fq + '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/bang-gia') + '</div></section>')
    b = bands_at(b, [(1, band('Bảng giá sắp công bố – nhận sớm nhất', 'Đăng ký ngay để nhận bảng giá gốc, chính sách thanh toán qua Zalo trước ngày mở bán.', 'Nhận bảng giá gốc', 'Bảng giá – giữa trang', ('/mat-bang', 'Xem mặt bằng trước khi chọn'))),
                     (3, band('Muốn biết căn nào hợp túi tiền?', 'Chuyên viên tư vấn phương án vốn, vay ngân hàng theo từng loại căn.', 'Tư vấn phương án vốn', 'Bảng giá – tư vấn vốn', ('/cho-thue', 'Xem dòng tiền cho thuê')))])
    b += cta_block('Web – bảng giá cuối trang', title='Nhận <b>bảng giá gốc</b> ngay khi công bố')
    title = 'Giá Sun Saphia Residence 2026 – Bảng giá, so sánh, vay ngân hàng'
    desc = 'Giá Sun Saphia Residence Đà Nẵng: tình trạng bảng giá, so sánh giá căn hộ mặt biển, vay Vietcombank, BIDV, NCB, bảng tính trả góp. Nhận bảng giá gốc qua Zalo.'
    return page('/bang-gia', title, desc, 'giá sun saphia residence, bảng giá sun saphia, giá căn hộ sun saphia đà nẵng, giá căn hộ mặt biển đà nẵng, vay mua sun saphia',
                b, [article_ld(title, desc, MAIN + '/bang-gia'), cld, fld], '/bang-gia')

def mat_bang():
    hero, cld = sub_hero('/mat-bang', 'Mặt bằng', 'Mặt bằng Sun Saphia Residence – <b>chọn căn</b> tầng 3A–28',
                         'Tòa tháp 30 tầng, căn hộ bố trí từ tầng 3A đến tầng 28. Mặt bằng tầng thiết kế tối ưu tầm view biển Mỹ Khê, gồm Studio 30–31 m², 1BR+ 50–51 m², 2BR 60–70 m² và các căn góc bo tròn. Bấm từng căn trên mặt bằng bên dưới để xem bản vẽ nội thất, hướng view.',
                         'mat-bang-tong-the', 'Mặt bằng tổng thể Sun Saphia Residence hướng ra biển Mỹ Khê', 'Web – mặt bằng đầu trang')
    fq, fld = faq([
        ('Mỗi tầng Sun Saphia Residence có bao nhiêu căn?', 'Layout tầng điển hình 3A–28 gồm 28 căn mỗi tầng, trong đó phần lớn là Studio, xen các căn 1BR+ và 2BR ở hai đầu và góc tòa.'),
        ('Căn Studio rộng bao nhiêu?', 'Studio 30–31 m², kích thước 3,8 × 9 m, có logia, giường + sofa không gian mở, bếp chữ L, WC tách khu tắm. Tổng 513 căn.'),
        ('Căn 1BR+1 khác căn 2BR thế nào?', '1BR+1 rộng 50–51 m² (6,2 × 9 m) gồm 1 phòng ngủ và phòng đa năng; 2BR rộng 60–70 m² (7,25 × 9,9 m) với 2 phòng ngủ, phòng khách, bếp.'),
        ('Trần căn hộ cao bao nhiêu?', 'Chiều cao căn hộ 3,5 m, bàn giao hoàn thiện cơ bản.'),
        ('Căn nào view biển?', 'Mặt dài tòa tháp hướng biển Mỹ Khê. Các hướng còn lại nhìn về Ngũ Hành Sơn, sông Hàn và đô thị. Dùng công cụ chọn căn để xem hướng từng căn.'),
        ('Mặt bằng đã là bản chính thức chưa?', 'Mặt bằng theo tài liệu giới thiệu dự án tại Kick-off; bản chính thức theo hồ sơ bán hàng và Hợp đồng mua bán.')])
    b = hero
    b += tldr('mặt bằng Sun Saphia Residence', [('Tầng căn hộ', 'Từ tầng 3A đến tầng 28, 28 căn mỗi tầng điển hình'), ('Studio', '30–31 m², 3,8 × 9 m, 513 căn'), ('1BR+1', '50–51 m², 6,2 × 9 m, 108 căn'),
        ('2BR', '60–70 m², 7,25 × 9,9 m, 133 căn, có căn góc bo tròn'), ('Chiều cao căn hộ', '3,5 m, bàn giao hoàn thiện cơ bản'), ('Hướng view', 'Biển Mỹ Khê – Sơn Thủy, Ngũ Hành Sơn, sông Hàn, đô thị')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('1', 'Cơ cấu', '782 căn – <b>3 loại căn</b>', 'o') + units_table() +
          '<div style="margin-top:24px">' + units_drawings() + '</div></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('2', 'Layout tầng', 'Mặt bằng tầng điển hình <b>3A–28</b>', 'n') +
          '<div class="g2"><div class="txt"><p>Mặt bằng tầng điển hình 3A–28 tòa Saphia có 28 căn: dãy Studio chạy dọc hành lang giữa, hai đầu tòa bố trí 1BR+ và 2BR, các căn góc bo tròn có hai mặt thoáng. '
          'Lõi thang máy, thang bộ đặt giữa tòa, giúp quãng đi từ thang tới căn ngắn.</p>'
          '<p>Hướng chính: <b>trước mặt là biển</b> Mỹ Khê – Sơn Thủy; một bên về thành phố, biển Mỹ Khê phía Sơn Trà; một bên về Ngũ Hành Sơn – Hội An; phía sau là sông Hàn, sân bay, Hòa Xuân.</p>'
          '<ul class="ck"><li><b>Studio</b> – 19 căn/tầng, dãy giữa, hai mặt hướng biển và hướng thành phố</li><li><b>1BR+1</b> – 4 căn/tầng ở hai đầu hành lang</li><li><b>2BR</b> – 5 căn/tầng, có căn góc bo tròn hai mặt thoáng</li><li>Trần 3,5 m, logia kính lớn đón gió biển</li></ul>'
          '<button type="button" class="btn sm" data-pop data-interest="Mặt bằng – nhận layout từng tầng">Nhận mặt bằng từng tầng qua Zalo</button></div>'
          + fig('layout-tang-3a-28', 'Layout tầng điển hình 3A–28 Sun Saphia Residence, 28 căn mỗi tầng', 'Layout tầng 3A–28 (tài liệu chủ đầu tư)', wm=True) + '</div>'
          '<div id="chon-can"></div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('3', 'Hướng view', 'Mỗi hướng <b>một khung tranh</b>', 'y') + views() + '</div></section>')
    b += ('<section class="sec" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp về <b>mặt bằng</b>', 'o') + fq + '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/mat-bang') + '</div></section>')
    b = bands_at(b, [(1, band('Căn view biển đẹp có hạn trên mỗi tầng', 'Để lại số để được ưu tiên chọn căn trên mặt bằng ngay khi mở bán.', 'Ưu tiên chọn căn', 'Mặt bằng – ưu tiên chọn căn', ('/bang-gia', 'Xem giá từng loại căn'))),
                     (3, band('Nhận mặt bằng căn còn trống', 'Gửi mặt bằng từng tầng, bản vẽ căn và hướng view qua Zalo.', 'Nhận mặt bằng', 'Mặt bằng – nhận mặt bằng tầng', ('/phap-ly', 'Xem pháp lý dự án')))])
    b += cta_block('Web – mặt bằng cuối trang', title='Nhận <b>mặt bằng căn còn trống</b>')
    title = 'Mặt bằng Sun Saphia Residence – Layout tầng 3A–28, chọn căn'
    desc = 'Mặt bằng tầng 3A–28 Sun Saphia Residence, 28 căn mỗi tầng: Studio 30 m², 1BR+ 50 m², 2BR 60–70 m², căn góc. Bấm từng căn xem nội thất, hướng view, mô hình 4D.'
    return page('/mat-bang', title, desc, 'mặt bằng sun saphia residence, layout căn hộ sun saphia, mặt bằng tầng sun saphia, chọn căn sun saphia, căn studio sun saphia',
                b, [article_ld(title, desc, MAIN + '/mat-bang'), cld, fld], '/mat-bang', tools=True)

def phap_ly():
    hero, cld = sub_hero('/phap-ly', 'Pháp lý', 'Pháp lý Sun Saphia Residence – <b>thời hạn 50 năm</b>, tiến độ',
                         'Sun Saphia Residence có Giấy chứng nhận đăng ký đầu tư mã dự án 2572746483, chứng nhận lần đầu ngày 17/09/2026; thời hạn dự án 50 năm, công trình cấp I niên hạn 100 năm. Trang này giải thích các mốc pháp lý, ý nghĩa của Nghị quyết 278/NQ-CP và tiến độ mở bán – bàn giao.',
                         'thap-dem-resort', 'Sun Saphia Residence về đêm trên trục biển Võ Nguyên Giáp – Trường Sa', 'Web – pháp lý đầu trang')
    fq, fld = faq([
        ('Sun Saphia Residence sở hữu bao lâu?', 'Thời hạn dự án 50 năm kể từ ngày 17/09/2026 theo GCN đăng ký đầu tư. Công trình cấp I, niên hạn sử dụng 100 năm. Quyền lợi cụ thể của người mua ghi trong Hợp đồng mua bán.'),
        ('Nghị quyết 278/NQ-CP ảnh hưởng gì tới căn hộ 50 năm?', 'Nghị quyết (18/9/2026) xác định thời hạn sử dụng chung cư theo niên hạn công trình và hồ sơ thiết kế, làm rõ quyền và nghĩa vụ khi hết thời hạn, tách bạch quyền sở hữu căn hộ và quyền sử dụng đất – qua đó thu hẹp khoảng cách giữa sản phẩm 50 năm và căn hộ sở hữu lâu dài.'),
        ('Vì sao thời hạn 50 năm của Sun Saphia có lợi hơn?', 'Thời hạn được tính từ 17/09/2026 nên vừa mới bắt đầu, kéo dài tới 09/2076; khi nhận nhà 11/2028 còn khoảng 48 năm. Nhiều dự án 50 năm khác tính từ năm giao đất cách đây 10–15 năm nên người mua chỉ còn khoảng 35–40 năm. Còn nhiều năm hơn thì giữ giá, vay ngân hàng và bán lại đều thuận lợi hơn.'),
        ('Hết 50 năm thì căn hộ Sun Saphia ra sao?', '50 năm là thời hạn dự án (thời hạn đất) từ 17/09/2026; khi hết hạn, Luật Đất đai 2024 cho phép xem xét gia hạn nếu sử dụng đúng mục đích. Toà nhà là công trình cấp I, niên hạn 100 năm. Quyền lợi cụ thể theo quy định tại thời điểm đó và Hợp đồng mua bán.'),
        ('Hết niên hạn công trình có bị mất nhà không?', 'Theo Luật Nhà ở 2023, hết niên hạn không tự động mất quyền sở hữu. Toà nhà được kiểm định: còn an toàn thì tiếp tục sử dụng; không an toàn thì cải tạo, xây lại và chủ sở hữu được bồi thường, tái định cư hoặc nhận căn hộ mới theo phương án được duyệt.'),
        ('Dự án đã có giấy tờ gì?', 'GCN đăng ký đầu tư mã dự án 2572746483 do Sở Tài chính TP Đà Nẵng cấp, chứng nhận lần đầu 17/09/2026. Các giấy tờ tiếp theo theo tiến độ chủ đầu tư công bố.'),
        ('Khi nào được ký hợp đồng mua bán?', 'Theo quy trình và chính sách chủ đầu tư công bố khi mở bán (dự kiến cuối 11/2026). Đại lý chính thức sẽ hướng dẫn từng bước giữ chỗ – đặt cọc – ký hợp đồng.'),
        ('Mua qua TATILAND có an toàn không?', 'TATILAND được Sun Property chứng nhận là đại lý phân phối chính thức ngày 23/10/2026; giao dịch theo đúng quy trình, hợp đồng của chủ đầu tư.')])
    b = hero
    b += tldr('pháp lý Sun Saphia Residence', [('GCN đăng ký đầu tư', 'Mã dự án 2572746483, Sở Tài chính TP Đà Nẵng cấp, lần đầu 17/09/2026'), ('Thời hạn', '50 năm kể từ 17/09/2026 – vừa bắt đầu, còn ~48 năm khi nhận nhà 11/2028'),
        ('Công trình', 'Cấp I, niên hạn sử dụng 100 năm'), ('Chính sách mới', 'Nghị quyết 278/NQ-CP (18/9/2026) xác định thời hạn chung cư theo niên hạn công trình'),
        ('Tiến độ', 'Mở bán dự kiến cuối 11/2026 · bàn giao 11/2028'), ('Mua ở đâu', 'Đại lý phân phối chính thức TATILAND (Sun Property chứng nhận 23/10/2026)')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('1', 'Giấy tờ dự án', 'Pháp lý <b>đã có</b>', 'o') + legal_box() + '</div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('2', 'Căn hộ 50 năm', 'Giá trị căn hộ 50 năm <b>đang được định hình lại</b>', 'n') +
          '<div class="g2" style="align-items:start"><div class="txt"><p>Căn hộ trong dự án có thời hạn 50 năm thường bị so sánh thiệt thòi với căn hộ sở hữu lâu dài. Nghị quyết 278/NQ-CP ngày 18/9/2026 của Chính phủ đang thay đổi cách nhìn này, '
          'khi thời hạn sử dụng chung cư được xác định theo niên hạn công trình và hồ sơ thiết kế.</p>'
          '<p>Với Sun Saphia Residence, công trình được xếp <b>cấp I, niên hạn sử dụng 100 năm</b>. Quyền lợi cụ thể của người mua khi hết thời hạn dự án sẽ theo quy định pháp luật và Hợp đồng mua bán; anh/chị nên đọc kỹ điều khoản này khi ký.</p>'
          '<h3>Khi ký Hợp đồng mua bán nên xem kỹ</h3><ul class="ck"><li>Điều khoản thời hạn sở hữu và quyền lợi khi hết hạn</li><li>Tiến độ thanh toán, bàn giao, phạt chậm bàn giao</li><li>Phí quản lý, quy định cho thuê căn hộ</li></ul>'
          '<p class="note">Nội dung mang tính giải thích chung, không thay thế tư vấn pháp lý.</p></div>' + nq278() + '</div></div></section>')
    b += ('<section class="sec alt" id="thoi-han-moi"><div class="wrap">' + sh('3', 'Lợi thế thời hạn', 'Đồng hồ 50 năm <b>vừa mới bắt đầu</b>', 'y') +
          '<div class="g2" style="align-items:stretch"><div class="txt just">'
          '<p>Cùng là căn hộ 50 năm, nhưng <b>còn lại bao nhiêu năm</b> mới là điều quyết định giá trị. Thời hạn 50 năm của Sun Saphia Residence được tính từ <b>17/09/2026</b> theo Giấy chứng nhận đăng ký đầu tư – tức là vừa mới bắt đầu, kéo dài tới <b>09/2076</b>.</p>'
          '<p>Nhiều dự án căn hộ 50 năm khác ven biển Đà Nẵng có thời hạn tính từ năm được giao đất, thường từ nhiều năm trước. Đồng hồ đã chạy 10–15 năm trước khi khách nhận nhà, nên người mua hôm nay chỉ còn khoảng 35–40 năm.</p>'
          '<h3>Thời gian còn lại dài hơn nghĩa là gì?</h3><ul class="ck">'
          '<li><b>Giữ giá tốt hơn</b>: căn hộ còn nhiều năm sử dụng thì giá bán lại cao hơn.</li>'
          '<li><b>Vay ngân hàng dễ hơn</b>: thời hạn còn lại dài, ngân hàng dễ duyệt khoản vay dài hạn.</li>'
          '<li><b>Thêm nhiều năm cho thuê</b>: mỗi năm còn lại là thêm một năm dòng tiền.</li>'
          '<li><b>Bán lại dễ hơn</b>: người mua sau vẫn còn trên 40 năm nếu anh/chị bán sau 5–7 năm.</li></ul>'
          '<div style="background:#fff;border:2px dashed #275286;border-radius:16px;padding:16px 20px;margin:18px 0 12px"><b style="color:#E96118">🔑 Khách hỏi “50 năm dự án nào cũng vậy?”</b>'
          '<p style="margin:8px 0 0;font-style:italic">“Dạ khác ở chỗ tính từ khi nào ạ. Saphia tính từ 17/09/2026, hết hạn 09/2076 – nhận nhà vẫn còn khoảng 48 năm. Nhiều dự án khác tính từ năm giao đất cách đây 10–15 năm, mua bây giờ chỉ còn khoảng 34–38 năm.”</p></div>'
          '<p class="note">Các dự án so sánh là ví dụ minh họa theo năm giao đất, không chỉ đích danh dự án nào. Thời hạn chính thức của từng căn theo Hợp đồng mua bán.</p></div>'
          '<div class="hhr" style="position:static;height:100%"><div class="card" style="padding:22px"><span class="n">THỜI GIAN CÒN LẠI KHI NHẬN NHÀ</span><h3 class="oc" style="margin-bottom:14px">Cùng 50 năm – còn lại khác nhau</h3>'
          + ''.join('<div style="margin:12px 0"><div style="display:flex;justify-content:space-between;font-size:14px;font-weight:600"><span>%s</span><span style="color:%s">%s</span></div>'
                    '<div style="height:14px;border-radius:99px;background:#e6ecf4;overflow:hidden;margin-top:6px"><div style="height:100%%;width:%d%%;border-radius:99px;background:%s"></div></div></div>'
                    % (t, c, v, w, c) for t, v, w, c in [
                        ('Sun Saphia · từ 09/2026, nhận nhà 11/2028', '~48 năm', 96, '#E96118'),
                        ('Dự án giao đất 2016 (minh họa)', '~38 năm', 76, '#7a8aa6'),
                        ('Dự án giao đất 2012 (minh họa)', '~34 năm', 68, '#9aa7bd')]) +
          '<p style="font-size:13px;color:#5b6b85;margin-top:10px">Tính tới thời điểm nhận nhà 11/2028 · thời hạn 50 năm theo GCN đầu tư/giao đất.</p>'
          '<button type="button" class="btn sm" data-pop data-interest="Pháp lý – lợi thế thời hạn 50 năm" style="margin-top:8px">Nhận bản sao GCN đầu tư</button></div>'
          '<div class="card" style="padding:22px;flex:1;display:flex;flex-direction:column;justify-content:space-between"><span class="n" style="display:block;margin-bottom:12px">MỐC THỜI GIAN 50 NĂM CỦA SAPHIA</span><div style="display:flex;gap:14px;position:relative;padding-bottom:10px"><span style="position:absolute;left:6px;top:20px;bottom:0;width:2px;background:#dbe3ee"></span><div style="flex:none;width:14px;height:14px;border-radius:50%;background:#E96118;margin-top:5px;box-shadow:0 0 0 4px #E9611822;position:relative"></div><div><b style="color:#E96118">17/09/2026</b> · <b>Bắt đầu tính 50 năm</b><div style="font-size:13.5px;color:#5b6b85;line-height:1.35">Theo GCN đăng ký đầu tư</div></div></div><div style="display:flex;gap:14px;position:relative;padding-bottom:10px"><span style="position:absolute;left:6px;top:20px;bottom:0;width:2px;background:#dbe3ee"></span><div style="flex:none;width:14px;height:14px;border-radius:50%;background:#275286;margin-top:5px;box-shadow:0 0 0 4px #27528622;position:relative"></div><div><b style="color:#275286">Cuối 11/2026</b> · <b>Dự kiến mở bán</b><div style="font-size:13.5px;color:#5b6b85;line-height:1.35">Còn ~50 năm</div></div></div><div style="display:flex;gap:14px;position:relative;padding-bottom:10px"><span style="position:absolute;left:6px;top:20px;bottom:0;width:2px;background:#dbe3ee"></span><div style="flex:none;width:14px;height:14px;border-radius:50%;background:#275286;margin-top:5px;box-shadow:0 0 0 4px #27528622;position:relative"></div><div><b style="color:#275286">11/2028</b> · <b>Nhận nhà</b><div style="font-size:13.5px;color:#5b6b85;line-height:1.35">Còn ~48 năm để ở, cho thuê</div></div></div><div style="display:flex;gap:14px;position:relative;padding-bottom:10px"><span style="position:absolute;left:6px;top:20px;bottom:0;width:2px;background:#dbe3ee"></span><div style="flex:none;width:14px;height:14px;border-radius:50%;background:#275286;margin-top:5px;box-shadow:0 0 0 4px #27528622;position:relative"></div><div><b style="color:#275286">2033–2035</b> · <b>Nếu bán lại sau 5–7 năm</b><div style="font-size:13.5px;color:#5b6b85;line-height:1.35">Người mua sau vẫn còn ~41–43 năm</div></div></div><div style="display:flex;gap:14px;position:relative;padding-bottom:0"><div style="flex:none;width:14px;height:14px;border-radius:50%;background:#2f9e6a;margin-top:5px;box-shadow:0 0 0 4px #2f9e6a22;position:relative"></div><div><b style="color:#2f9e6a">09/2076</b> · <b>Hết thời hạn dự án</b><div style="font-size:13.5px;color:#5b6b85;line-height:1.35">Được xem xét gia hạn theo Luật Đất đai 2024</div></div></div></div></div></div></div></section>')
    b += ('<section class="sec" id="het-han"><div class="wrap">' + sh('4', 'Hết hạn thì sao?', 'Hết 50 năm, hết niên hạn – <b>quyền lợi người mua</b>', 'o') +
          '<div class="g2" style="align-items:start"><div class="txt just">'
          '<p>Nhiều người nhầm hai mốc thời gian. Với Sun Saphia Residence:</p>'
          + tbl(['Mốc', 'Sun Saphia', 'Nghĩa là gì'], [['Thời hạn dự án', '50 năm từ 17/09/2026', 'Thời hạn sử dụng đất của dự án theo GCN đầu tư'], ['Niên hạn công trình', '100 năm (công trình cấp I)', 'Tuổi thọ thiết kế của toà nhà']]) +
          '<h3 style="margin-top:18px">Khi hết niên hạn công trình</h3>'
          '<p>Theo <b>Điều 58 Luật Nhà ở 2023</b> (Luật số 27/2023/QH15), thời hạn sử dụng chung cư được xác định theo hồ sơ thiết kế và thời gian sử dụng thực tế theo kết luận kiểm định. Hết niên hạn, cơ quan có thẩm quyền tổ chức <b>kiểm định chất lượng</b>:</p>'
          '<ul class="ck"><li><b>Còn an toàn</b>: tiếp tục sử dụng theo thời hạn ghi trong kết luận kiểm định.</li>'
          '<li><b>Không còn an toàn</b> (các trường hợp tại Điều 59): phá dỡ để cải tạo, xây dựng lại; chủ sở hữu được bồi thường, tái định cư hoặc nhận căn hộ mới, giá trị tương ứng theo phương án được duyệt.</li>'
          '<li>Luật hiện hành <b>không quy định tự động mất quyền sở hữu</b> khi hết niên hạn.</li></ul>'
          '<h3>Khi hết thời hạn dự án 50 năm</h3>'
          '<p>Luật Đất đai 2024 (Luật số 31/2024/QH15) cho phép người sử dụng đất có thời hạn <b>được xem xét gia hạn</b> khi có nhu cầu, sử dụng đúng mục đích và chấp hành pháp luật. Cách gia hạn và nghĩa vụ tài chính đối với từng căn hộ theo quy định tại thời điểm đó và điều khoản trong Hợp đồng mua bán.</p>'
          '<p class="note">Nội dung mang tính giải thích chung, không thay thế tư vấn pháp lý. Đọc thêm: '
          '<a href="https://thuvienphapluat.vn/chinh-sach-phap-luat-moi/vn/ho-tro-phap-luat/tu-van-phap-luat/57443/thoi-han-su-dung-nha-chung-cu-theo-luat-nha-o-2023" target="_blank" rel="noopener">Thời hạn sử dụng nhà chung cư theo Luật Nhà ở 2023 (Thư viện Pháp luật)</a> · '
          '<a href="https://dantri.com.vn/bat-dong-san/luat-su-chung-cu-co-nien-han-khong-dong-nghia-het-quyen-khi-het-han-20260805121957957.htm" target="_blank" rel="noopener">Chung cư có niên hạn không đồng nghĩa “hết quyền” khi hết hạn (Dân trí)</a></p>'
          '</div><div class="hhr"><div class="card" style="padding:22px"><span class="n">KHI KÝ HỢP ĐỒNG</span><h3 class="oc">3 điều khoản cần đọc kỹ</h3>'
          '<ul class="ck" style="margin-top:10px"><li>Thời hạn sở hữu căn hộ và quyền gia hạn khi hết 50 năm</li><li>Trách nhiệm của chủ đầu tư, ban quản trị khi kiểm định, cải tạo toà nhà</li><li>Nghĩa vụ tài chính phát sinh (nếu có) khi gia hạn</li></ul>'
          '<button type="button" class="btn sm" data-pop data-interest="Pháp lý – hỏi về hết hạn 50 năm" style="margin-top:12px">Nhận giải thích từ đại lý</button></div><div class="hfl"><span class="n">QUY TRÌNH KHI HẾT NIÊN HẠN</span><div class="fs">🏢 Hết niên hạn theo hồ sơ thiết kế<small>Điều 58 Luật Nhà ở 2023</small></div><div class="fa">▼</div><div class="fs">🔍 Kiểm định chất lượng toà nhà<small>Cơ quan có thẩm quyền tổ chức</small></div><div class="fa">▼</div><div class="fb"><div class="fs ok"><b>✅ Còn an toàn</b>Tiếp tục sử dụng</div><div class="fs no"><b>⚠️ Không an toàn</b>Cải tạo, xây lại – bồi thường, tái định cư hoặc căn mới<small>Điều 59</small></div></div><div class="fs gr"><b>50 năm thời hạn đất</b>Hết hạn được xem xét gia hạn<small>Luật Đất đai 2024</small></div></div></div></div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('5', 'Tiến độ', 'Mốc thời gian <b>dự án</b>', 'y') + timeline() + '</div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('6', 'Mua ở đâu', 'Mua qua <b>đại lý phân phối chính thức</b>', 'o') + daily() +
          '<div class="g4" style="margin-top:24px"><div class="card"><span class="n">BƯỚC 1</span><h3 class="oc">Đăng ký</h3><p>Để lại số Zalo, nhận tài liệu, mặt bằng. Không thu tiền.</p></div>'
          '<div class="card"><span class="n">BƯỚC 2</span><h3 class="oc">Nhận bảng giá</h3><p>Bảng giá, chính sách gốc khi chủ đầu tư công bố; chọn căn trên mặt bằng.</p></div>'
          '<div class="card"><span class="n">BƯỚC 3</span><h3 class="oc">Giữ chỗ / đặt cọc</h3><p>Theo quy trình chủ đầu tư tại sự kiện mở bán; tiền chuyển vào tài khoản theo hướng dẫn chính thức.</p></div>'
          '<div class="card"><span class="n">BƯỚC 4</span><h3 class="oc">Ký hợp đồng</h3><p>Ký Hợp đồng mua bán với chủ đầu tư, thanh toán theo tiến độ, vay ngân hàng nếu cần.</p></div></div></div></section>')
    b += ('<section class="sec alt" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp về <b>pháp lý</b>', 'n') + fq + '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/phap-ly') + '</div></section>')
    b = bands_at(b, [(1, band('Nhận bản sao pháp lý dự án', 'GCN đăng ký đầu tư, Nghị quyết 278, tiến độ – gửi qua Zalo.', 'Nhận hồ sơ pháp lý', 'Pháp lý – nhận hồ sơ', ('/bang-gia', 'Xem bảng giá & vay'))),
                     (3, band('Đăng ký sớm để được giữ chỗ đầu tiên', 'Đại lý chính thức – bảng giá gốc, giữ chỗ đúng quy trình chủ đầu tư.', 'Đăng ký giữ chỗ', 'Pháp lý – đăng ký giữ chỗ', ('/mat-bang', 'Chọn căn trên mặt bằng')))])
    b += cta_block('Web – pháp lý cuối trang', title='Nhận <b>hồ sơ pháp lý</b> và chính sách')
    title = 'Pháp lý Sun Saphia Residence – GCN đầu tư, thời hạn 50 năm, tiến độ'
    desc = 'Pháp lý Sun Saphia Residence: GCN đầu tư 2572746483 (17/09/2026), thời hạn 50 năm, công trình cấp I niên hạn 100 năm, Nghị quyết 278/NQ-CP, tiến độ mở bán – bàn giao.'
    return page('/phap-ly', title, desc, 'pháp lý sun saphia residence, sun saphia sở hữu bao lâu, căn hộ 50 năm đà nẵng, nghị quyết 278, tiến độ sun saphia',
                b, [article_ld(title, desc, MAIN + '/phap-ly'), cld, fld], '/phap-ly')

def cho_thue():
    hero, cld = sub_hero('/cho-thue', 'Cho thuê', 'Đầu tư căn hộ cho thuê Đà Nẵng – <b>dòng tiền</b> Sun Saphia',
                         'Studio view biển Đà Nẵng đang cho thuê 2,2–2,9 triệu/đêm, 1BR+ 3,4–3,7 triệu/đêm (ngoài mùa cao điểm); khách sạn Sun Group miền Trung lấp đầy 81,3% năm 2026. Trang này tổng hợp nguồn khách thuê, giá thuê theo đêm và theo tháng, và công cụ để anh/chị tự tính dòng tiền theo từng căn.',
                         ('<img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 900px" width="1600" height="900" alt="Hồ bơi tầng 3 nhìn ra biển Đà Nẵng lúc hoàng hôn – Sun Saphia Residence (ảnh minh họa)" fetchpriority="high" decoding="async">' % ((RAW + 'a0a6849c15880dc681b6e91708d2a0752bd2aa43/landing/sun-saphia/v4/img/ho-boi-tang-3',) * 3)), 'Hồ bơi tầng 3', 'Web – cho thuê đầu trang')
    fq, fld = faq([
        ('Cho thuê căn hộ Sun Saphia được bao nhiêu?', 'Giá thuê căn hộ view biển Đà Nẵng hiện khoảng 2,2–2,9 triệu/đêm (studio) và 3,4–3,7 triệu/đêm (1BR+), chưa tính mùa cao điểm. Thuê tháng các tòa ven sông Hàn: studio 18–20 triệu, 1PN 14–27 triệu, 2PN 20–45 triệu.'),
        ('Tỷ lệ lấp đầy thực tế ra sao?', 'Bài toán minh họa của chủ đầu tư dùng 60%. Khách sạn của Sun Group tại miền Trung đạt 81,3% năm 2026 (từ 70,65% năm 2025) – cao nhất cả nước.'),
        ('Lợi nhuận 11,7% có phải cam kết?', 'Không. Đó là bài toán minh họa với giá giả định 3 tỷ, giá thuê 2,5 triệu/đêm, lấp đầy 60%, lợi nhuận 65% doanh thu. Kết quả thực tế phụ thuộc giá mua, mùa vụ và cách vận hành.'),
        ('Ai sẽ thuê căn hộ?', 'Ba nhóm chính: nhân sự chuỗi resort ven biển (thuê trung hạn), khách thuê ngắn ngày kiểu Airbnb và khách du lịch ưu tiên căn hộ mặt biển.'),
        ('Người mới chưa từng cho thuê có làm được không?', 'Được. Có 4 cách: tự cho thuê ngắn ngày, giao đơn vị vận hành, cho thuê tháng hoặc cho thuê dài hạn. Người ở xa, bận rộn thường giao đơn vị vận hành (phí thường 15–30% doanh thu) hoặc cho thuê tháng cho nhàn.'),
        ('Cho thuê căn hộ có phải đóng thuế không?', 'Có, nếu doanh thu trên 100 triệu đồng/năm: khoảng 10% doanh thu (5% GTGT + 5% TNCN) theo Thông tư 40/2021/TT-BTC. Dưới 100 triệu/năm không phải nộp.'),
        ('Cần chuẩn bị gì để cho thuê?', 'Nội thất phong cách nghỉ dưỡng, thiết bị cơ bản (máy lạnh, wifi, bếp, máy giặt, khoá mã số), đồ dùng (ga gối 3 bộ xoay vòng, khăn, đồ vệ sinh), đồ an toàn (bình chữa cháy, hộp sơ cứu), ảnh chụp đẹp và tài khoản trên Airbnb, Booking, Agoda.'),
        ('Có đơn vị vận hành cho thuê không?', 'Phương án vận hành theo công bố của chủ đầu tư khi mở bán; đại lý sẽ tư vấn các lựa chọn tự vận hành hoặc thuê đơn vị quản lý.')])
    b = hero
    b += tldr('cho thuê căn hộ Sun Saphia', [('Giá thuê theo đêm', 'Studio view biển 2,2–2,9 triệu · 1BR+ 3,4–3,7 triệu (ngoài mùa cao điểm)'), ('Giá thuê theo tháng (khu lân cận)', 'Studio 18–20 triệu · 1PN 14–27 triệu · 2PN 20–45 triệu'),
        ('Lấp đầy', 'Khách sạn Sun Group miền Trung 81,3% năm 2026'), ('Bài toán minh họa', 'Studio 3 tỷ, 2,5 tr/đêm, lấp đầy 60% → ~351 triệu/năm (11,7%) – không phải cam kết'),
        ('Khách thuê', 'Nhân sự chuỗi resort, khách Airbnb ngắn ngày, khách du lịch')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('1', 'Nguồn cầu', '3 dòng di dân – <b>1 điểm đến</b>', 'o') + migration() + '</div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('2', 'Giá thuê', 'Giá thuê căn hộ mặt biển <b>siêu ấn tượng</b>', 'y') +
          rent_night() + '<div class="g2 eq" style="margin-top:18px"><div>' + rent_month_table() + '</div>' + occ_chart() + '</div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('3', 'Khách thuê', 'Ba nhóm <b>khách thuê</b> chính', 'n') + tenants() + '</div></section>')
    # 4 cách cho thuê
    b += ('<section class="sec"><div class="wrap">' + sh('4', 'Chọn cách cho thuê', '4 cách cho thuê – <b>chọn cách hợp với mình</b>', 'o') +
          '<p class="just" style="max-width:860px">Không có cách nào “tốt nhất” cho mọi người. Có thời gian và thích tự làm thì tự cho thuê ngắn ngày; bận rộn thì giao đơn vị vận hành; muốn nhàn, ổn định thì cho thuê theo tháng hoặc theo năm.</p>'
          + tbl(['', 'Ngắn ngày – tự vận hành', 'Ngắn ngày – giao đơn vị vận hành', 'Theo tháng (3–6 tháng)', 'Dài hạn (từ 1 năm)'], [
            ['Khách là ai', 'Khách du lịch, gia đình, cặp đôi', 'Khách du lịch, khách quốc tế', 'Chuyên gia, nhân sự resort, người làm việc từ xa', 'Gia đình, nhân sự ở lâu'],
            ['Giá tham khảo', 'Studio 2,2–2,9 tr/đêm', 'Studio 2,2–2,9 tr/đêm', 'Studio khu vực ~18–20 tr/tháng', 'Thấp hơn thuê tháng, đổi lại ổn định'],
            ['Công sức của chủ nhà', 'Nhiều: đăng tin, nhắn khách, dọn phòng', 'Ít: chỉ theo dõi báo cáo', 'Ít: tìm khách vài lần/năm', 'Rất ít'],
            ['Chi phí chính', 'Phí nền tảng, dọn phòng, điện nước, giặt là', 'Phí quản lý (thường 15–30% doanh thu) + chi phí vận hành', 'Môi giới (thường ~nửa tháng–1 tháng tiền nhà)', 'Môi giới 1 lần, bảo trì'],
            ['Dòng tiền', 'Cao nhất, lên xuống theo mùa', 'Cao, đều hơn tự làm', 'Đều, thấp hơn ngắn ngày', 'Đều nhất, thấp nhất'],
            ['Hợp với ai', 'Người ở Đà Nẵng, có thời gian', 'Người ở xa, bận rộn', 'Muốn nhàn mà vẫn tốt', 'Muốn “để đó” an tâm']]) +
          '<p class="src">Mức phí tham khảo thị trường Đà Nẵng, thay đổi theo đơn vị và hợp đồng. Phương án vận hành chính thức theo công bố của chủ đầu tư khi mở bán.</p>'
          '<div class="g3" style="margin-top:20px"><div class="card"><span class="n">MẸO 1</span><h3 class="oc">Kết hợp theo mùa</h3><p>Cao điểm (khoảng 4–8, Tết, mùa pháo hoa) cho thuê theo đêm; mùa mưa (khoảng 9–12) chuyển sang thuê tháng để không bỏ trống.</p></div>'
          '<div class="card"><span class="n">MẸO 2</span><h3 class="oc">Chọn căn theo khách</h3><p>Studio hợp cặp đôi, khách đi công tác; 1BR+ hợp gia đình nhỏ, ở dài; 2BR hợp nhóm bạn, gia đình đông người.</p></div>'
          '<div class="card"><span class="n">MẸO 3</span><h3 class="oc">View là giá thuê</h3><p>Căn nhìn thẳng biển, tầng cao thường đặt được giá cao hơn và kín lịch hơn – chọn căn ngay từ đầu là bước quan trọng nhất.</p></div></div>'
          '</div></section>')
    # 7 bước
    steps = [('Chọn đúng căn', 'Xác định khách mục tiêu trước (du lịch, gia đình hay ở dài), rồi chọn loại căn, hướng view, tầng phù hợp. Đại lý gửi mặt bằng căn trống để so sánh.'),
             ('Nhận nhà, làm nội thất', 'Căn bàn giao hoàn thiện cơ bản. Làm nội thất theo phong cách nghỉ dưỡng, sáng màu, dễ lau dọn – ảnh đẹp thì khách đặt nhiều.'),
             ('Làm thủ tục', 'Kiểm tra nội quy toà nhà về lưu trú; khai báo tạm trú cho khách (khách nước ngoài khai báo theo quy định); kê khai, nộp thuế cho thuê tài sản.'),
             ('Chụp ảnh, đăng tin', 'Chụp ảnh chuyên nghiệp lúc ban ngày và hoàng hôn. Ngắn ngày: Airbnb, Booking, Agoda, Traveloka. Thuê tháng: nhóm Facebook, Zalo, trang bất động sản.'),
             ('Định giá theo mùa', 'Giá cao vào hè, lễ Tết, sự kiện; giảm nhẹ hoặc chuyển sang thuê tháng vào mùa mưa. Theo dõi giá các căn view biển quanh khu vực.'),
             ('Vận hành hằng ngày', 'Khoá cửa mã số để khách tự nhận phòng; thuê dọn phòng, giặt là theo lượt; trả lời khách nhanh để giữ đánh giá tốt.'),
             ('Theo dõi tiền và thuế', 'Ghi chép doanh thu, chi phí từng tháng; nộp thuế đúng hạn; xem lại giá và lịch trống mỗi quý.')]
    b += ('<section class="sec alt"><div class="wrap">' + sh('5', 'Cho người mới', '7 bước từ <b>nhận nhà đến có khách</b>', 'y') +
          '<div class="stp">' + ''.join('<div class="card"><span class="sn">%d</span><h3>%s</h3><p>%s</p></div>' % (k + 1, t, d) for k, (t, d) in enumerate(steps)) +
          '<div class="card cta-c"><h3>Chưa rõ bước nào?</h3><p>Chuyên viên hướng dẫn từng bước, giới thiệu đơn vị nội thất và vận hành.</p><button type="button" class="btn sm" data-pop data-interest="Cho thuê – hướng dẫn người mới">Nhận hướng dẫn miễn phí</button></div></div>'
          '</div></section>')
    # chuẩn bị gì, cho thuê thêm gì
    b += ('<section class="sec"><div class="wrap">' + sh('6', 'Chuẩn bị gì', 'Cho thuê cần <b>những gì</b> – và kiếm thêm từ đâu', 'n') +
          '<div class="g4 prep">'
          '<div class="card"><span class="n">🛋 NỘI THẤT</span><ul class="ck"><li>Giường tốt, nệm êm</li><li>Sofa bed (thêm chỗ ngủ)</li><li>Bàn ăn, bàn làm việc nhỏ</li><li>Rèm cản sáng, đèn vàng ấm</li><li>Ghế, bàn trà ngoài ban công</li></ul></div>'
          '<div class="card"><span class="n">🔌 THIẾT BỊ</span><ul class="ck"><li>Máy lạnh, wifi mạnh</li><li>Smart TV (Netflix, YouTube)</li><li>Bếp từ, tủ lạnh, lò vi sóng</li><li>Máy giặt, bàn ủi, máy sấy tóc</li><li>Khoá cửa mã số</li></ul></div>'
          '<div class="card"><span class="n">🧺 ĐỒ DÙNG</span><ul class="ck"><li>Ga gối, khăn: 3 bộ xoay vòng</li><li>Đồ vệ sinh cá nhân</li><li>Chén bát, ly, ấm nước</li><li>Nước suối, cà phê chào khách</li><li>Sổ hướng dẫn nhà, wifi</li></ul></div>'
          '<div class="card"><span class="n">🛟 AN TOÀN</span><ul class="ck"><li>Bình chữa cháy nhỏ</li><li>Hộp sơ cứu</li><li>Két sắt mini</li><li>Số khẩn cấp, lối thoát hiểm</li><li>Bảo hiểm tài sản (nên có)</li></ul></div></div>'
          '<h3 style="margin-top:26px">Kiếm thêm ngoài tiền phòng</h3>'
          '<div class="g3"><div class="card"><h3 class="oc">Dịch vụ đi lại</h3><p>Đưa đón sân bay (10–15 phút), cho thuê xe máy, đặt xe đi Hội An, Bà Nà.</p></div>'
          '<div class="card"><h3 class="oc">Trải nghiệm biển</h3><p>Giới thiệu SUP, kayak, dù lượn, jetski ngay bãi biển trước nhà; tour Sơn Trà, Ngũ Hành Sơn.</p></div>'
          '<div class="card"><h3 class="oc">Tiện ích ở lâu</h3><p>Gói dọn phòng hằng tuần, giặt ủi, nấu ăn theo yêu cầu cho khách thuê tháng.</p></div></div>'
          '</div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('7', 'Dòng tiền', 'Bài toán vận hành – <b>tự tính theo căn</b>', 'o') +
          '<div class="g2" style="align-items:start"><div>' + rent_case() + '</div>'
          '<div class="calc" id="tinh-dong-tien"><h3>Tự tính dòng tiền</h3>'
          '<label>Giá mua (tỷ đồng) <output id="og">3</output></label><input type="range" id="cg" min="2" max="10" step="0.1" value="3">'
          '<label>Giá thuê (triệu/đêm) <output id="ot">2,5</output></label><input type="range" id="ct" min="1" max="6" step="0.1" value="2.5">'
          '<label>Tỷ lệ lấp đầy <output id="ol">60%</output></label><input type="range" id="cl" min="30" max="90" step="5" value="60">'
          '<label>Lợi nhuận sau chi phí vận hành <output id="op">65%</output></label><input type="range" id="cp" min="40" max="80" step="5" value="65">'
          '<div class="res"><div><b id="k1">–</b><span>Doanh thu/năm</span></div><div><b id="k2">–</b><span>Thực nhận/năm</span></div><div><b id="k3">–</b><span>Tỷ lệ trên giá mua</span></div></div>'
          '<p class="note" style="margin-top:10px">Chỉ để ước lượng, không phải cam kết lợi nhuận.</p></div></div></div></section>'
          '<script>(function(){function $(i){return document.getElementById(i)}function f(v){return Math.round(v).toLocaleString("vi-VN")+" tr"}'
          'function u(){var g=+$("cg").value*1000,t=+$("ct").value,l=+$("cl").value/100,p=+$("cp").value/100,d=t*365*l,n=d*p;'
          '$("og").textContent=$("cg").value.replace(".",",");$("ot").textContent=$("ct").value.replace(".",",");$("ol").textContent=$("cl").value+"%";$("op").textContent=$("cp").value+"%";'
          '$("k1").textContent=f(d);$("k2").textContent=f(n)+" (~"+f(n/12)+"/th)";$("k3").textContent=(n/g*100).toFixed(1).replace(".",",")+"%";}["cg","ct","cl","cp"].forEach(function(i){$(i).addEventListener("input",u)});u();})();</script>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('8', 'Lưu ý', 'Chi phí, thuế và <b>rủi ro</b> cần tính', 'y') +
          '<div class="g4"><div class="card"><h3 class="oc">Mùa vụ</h3><p>Hè và lễ Tết lấp đầy cao; mùa mưa (khoảng 9–12) thấp hơn.</p></div>'
          '<div class="card"><h3 class="oc">Chi phí vận hành</h3><p>Phí quản lý, dọn phòng, điện nước, hoa hồng nền tảng đặt phòng, khấu hao nội thất.</p></div>'
          '<div class="card"><h3 class="oc">Nội thất</h3><p>Bàn giao hoàn thiện cơ bản – cần dự trù chi phí nội thất trước khi cho thuê.</p></div>'
          '<div class="card"><h3 class="oc">Quy định</h3><p>Lưu trú ngắn ngày theo nội quy toà nhà và quy định địa phương; khai báo tạm trú cho khách.</p></div></div>'
          '<div class="card" style="margin-top:18px"><h3 class="oc">Thuế cho thuê</h3><p class="just">Cá nhân cho thuê tài sản có doanh thu trên 100 triệu đồng/năm nộp thuế khoảng <b>10% doanh thu</b> (5% GTGT + 5% TNCN, theo Thông tư 40/2021/TT-BTC); dưới mức này không phải nộp. Có thể tự kê khai hoặc để đơn vị vận hành, bên thuê khai nộp thay theo hợp đồng.</p></div></div></section>')
    b += ('<section class="sec" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp về <b>cho thuê</b>', 'n') + fq + '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/cho-thue') + '</div></section>')
    b = bands_at(b, [(1, band('Nhận bảng tính dòng tiền theo căn', 'Tính theo giá thật khi có bảng giá: giá thuê, lấp đầy, lợi nhuận từng căn.', 'Nhận bảng tính', 'Cho thuê – bảng tính dòng tiền', ('/bang-gia', 'Xem bảng giá'))),
                     (3, band('Studio hay 1BR+ cho thuê tốt hơn?', 'Chuyên viên so sánh dòng tiền từng loại căn theo nhu cầu của anh/chị.', 'Tư vấn chọn căn cho thuê', 'Cho thuê – tư vấn chọn căn', ('/mat-bang', 'Xem mặt bằng Studio, 1BR+')))])
    b += cta_block('Web – cho thuê cuối trang', title='Nhận <b>bảng tính dòng tiền</b> theo căn')
    title = 'Đầu tư căn hộ cho thuê Đà Nẵng – Dòng tiền Sun Saphia Residence'
    desc = 'Giá thuê căn hộ view biển Đà Nẵng 2,2–3,7 triệu/đêm, lấp đầy khách sạn Sun Group miền Trung 81,3%. Tự tính dòng tiền studio, 1BR+ Sun Saphia Residence theo giá và lấp đầy.'
    return page('/cho-thue', title, desc, 'đầu tư căn hộ cho thuê đà nẵng, cho thuê căn hộ sun saphia, giá thuê căn hộ view biển đà nẵng, airbnb đà nẵng, dòng tiền căn hộ',
                b, [article_ld(title, desc, MAIN + '/cho-thue'), cld, fld], '/cho-thue')

# ---------- Trang chạy quảng cáo ----------
def ads(domain):
    url = MAIN + '/ads'  # cả hai tên miền chuẩn hóa về trang ads chính
    HB = RAW + '90c9302fe8dca2fa597009660b9635821c7d1eb5/landing/sun-saphia/v4/img/hero-bien'
    b = ('<section class="hero cine2"><div class="hban"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1668w" sizes="100vw" width="1668" height="943" '
         'alt="Căn hộ cao tầng mặt biển Đà Nẵng – ban công nhìn ra biển lúc hoàng hôn (ảnh minh họa)" fetchpriority="high" decoding="async">'
         '<span class="cap">Ảnh minh họa</span></div>'
         '<div class="hbody"><div class="wrap"><div class="g2"><div class="hl">'
         '<span class="tag">🔥 Dự kiến mở bán <b>cuối tháng 11</b></span>'
         '<h1 class="dp">Sun Saphia Residence – căn hộ <b>mặt biển</b> Đà Nẵng</h1>'
         + SLOGAN +
         '<ul class="ck"><li><b>Đại lý chính thức TATILAND</b> – bảng giá gốc từ đại lý, gửi qua Zalo khi công bố</li>'
         '<li><b>Studio 30 m², 1BR+ 50 m², 2BR 60–70 m²</b> · trần cao 3,5 m, view biển</li>'
         '<li><b>400 m ra bãi tắm Sơn Thủy</b> · giao lộ Võ Nguyên Giáp – Trường Sa</li>'
         '<li><b>Pháp lý 50 năm</b> · Vietcombank, BIDV, NCB hỗ trợ vay</li></ul>'
         '<a class="play" href="#ss4d" data-4d><i aria-hidden="true">▶</i><span><b>Xem dự án 3D · 4D</b><small>Xoay tòa tháp · nắng theo giờ · view biển từ căn</small></span></a>'
         '</div><div class="hr">%s</div></div></div></div></section>'
         '<section class="hstrip"><div class="wrap">%s'
         '<div class="qlinks"><a href="{M}/bang-gia">Bảng giá</a><a href="#mat-bang">Mặt bằng &amp; chọn căn</a><a href="{M}/tinh-dong-tien">Tính dòng tiền</a><a href="{M}/phap-ly">Pháp lý &amp; tiến độ</a></div></div></section>'
         '<script>document.addEventListener("click",function(e){var a=e.target.closest&&e.target.closest("[data-4d]");if(!a)return;var b=document.getElementById("ss4d-box");if(!b)return;e.preventDefault();if(innerWidth<=760&&window.ss4dFull){ss4dFull();return}'
         'try{b.scrollIntoView({behavior:"smooth",block:"center"})}catch(x){b.scrollIntoView()}var g=document.getElementById("ss4d-go");if(g)g.click();'
         'try{if(window.gtag)gtag("event","xem_4d",{event_label:"hero"})}catch(x){}});</script>') % (
        HB, HB, HB,
        form('dau', 'ADS – form đầu trang', title='Nhận bảng giá gốc từ đại lý', note='Bảng giá gốc, mặt bằng tầng, chính sách – gửi qua Zalo ngay khi chủ đầu tư công bố. Đăng ký miễn phí.', h='h2'),
        hero_perks())
    b += tldr('Sun Saphia Residence', [('Dự án', 'Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng, 30 tầng, 782 căn'), ('Loại căn', 'Studio 30 m² · 1BR+ 50 m² · 2BR 60–70 m²'),
        ('Pháp lý', '50 năm · Vietcombank, BIDV, NCB hỗ trợ vay'), ('Mở bán', 'Dự kiến cuối 11/2026'), ('Nhận bảng giá', 'Zalo 0904 567 009 · đại lý chính thức · không thu tiền')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('★', 'Thời điểm vàng', 'Vì sao <b>đăng ký sớm</b>?', 'o') + why_now() + '</div></section>')
    b += pband('30 tầng bên <b>biển Mỹ Khê</b>', 'Căn hộ cao tầng mặt biển đầu tiên của Sun Group tại Đà Nẵng – mở bán dự kiến cuối tháng 11.', 'ADS – dải ảnh tòa tháp')
    b += ('<section class="sec"><div class="wrap">' + sh('01', 'Vị trí', 'Trung điểm <b>hệ di sản</b> Đà Nẵng', 'y') +
          '<figure class="fg sodo-l"><img src="' + RAW + '7f7a743766755fec9902ed74af5562cdfdd7f1d8/landing/sun-saphia/v4/img/so-do-vi-tri-ngang.webp" srcset="' + RAW + '7f7a743766755fec9902ed74af5562cdfdd7f1d8/landing/sun-saphia/v4/img/so-do-vi-tri-ngang-1100.webp 1100w, ' + RAW + '7f7a743766755fec9902ed74af5562cdfdd7f1d8/landing/sun-saphia/v4/img/so-do-vi-tri-ngang.webp 1600w" sizes="(max-width: 1200px) 100vw, 1140px" width="1600" height="900" alt="Sơ đồ vị trí Sun Saphia Residence: cầu Rồng, Trần Thị Lý, Tiên Sơn, đường Hồ Xuân Hương, phố Tây An Thượng, các resort ven biển, ~400 m ra bãi tắm Sơn Thủy" loading="lazy" decoding="async"></figure>' + '<div class="g2 vt" style="align-items:center"><div><div class="kn"><div><b>~400 m</b><span>ra bãi tắm Sơn Thủy</span></div><div><b>~500 m</b><span>tới ga LRT 09 (quy hoạch)</span></div><div><b>4 km</b><span>Downtown, Galaxy</span></div><div><b>5–10 phút</b><span>Ngũ Hành Sơn</span></div><div><b>10–15 phút</b><span>sân bay quốc tế</span></div><div><b>~30 phút</b><span>phố cổ Hội An</span></div></div><p class="just" style="margin-top:18px">Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa: một hướng về trung tâm, Sơn Trà; một hướng về Ngũ Hành Sơn, Hội An. Trục biển đang mở rộng <b>2.633 tỷ</b>, phía trước là công viên bãi tắm quy hoạch khoảng <b>2,45 ha</b>.</p>''<button type="button" class="btn sm" data-pop data-interest="ADS – đặt lịch xem vị trí qua video">Đặt lịch xem vị trí qua video</button></div>' + ('<figure class="fg sodo"><img src="%s.webp" srcset="%s-800.webp 800w, %s.webp 1000w" sizes="(max-width: 760px) 100vw, 560px" width="1000" height="1400" alt="Sơ đồ vị trí Sun Saphia Residence: ~400 m ra bãi tắm Sơn Thủy, ~500 m ga LRT 09, 4 km Downtown, 10–15 phút sân bay, ~30 phút Hội An" loading="lazy" decoding="async"><figcaption>Sơ đồ minh họa, không theo tỷ lệ</figcaption></figure>' % ((RAW + '7f7a743766755fec9902ed74af5562cdfdd7f1d8/landing/sun-saphia/v4/img/so-do-vi-tri',) * 3)) + '</div></div></section>')
    b += ('<section class="sec alt" id="mat-bang"><div class="wrap">' + sh('04', 'Mặt bằng', 'Chọn căn trên <b>mặt bằng tầng</b>', 'n') + units_table() +
          '<div style="margin-top:20px">' + units_drawings() + '</div><div id="chon-can"></div></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('02', 'Tầm nhìn', 'Mỗi hướng <b>một khung tranh</b>', 'o') + views('<img class="vb" src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1668w" sizes="(max-width: 760px) 100vw, 900px" width="1668" height="943" alt="Biển ngay ngoài ban công – căn hộ cao tầng mặt biển Đà Nẵng lúc hoàng hôn (ảnh minh họa)" loading="lazy" decoding="async">' % (HB, HB, HB)) + '</div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('06', 'Tiện ích', 'Sống gắn với <b>biển mỗi ngày</b>', 'y') +
          '<div class="g3"><article class="card">' + ('<img class="r" src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 400px" width="1600" height="900" alt="Hồ bơi tầng 3 nhìn ra biển – Sun Saphia Residence (ảnh minh họa)" loading="lazy" decoding="async">' % ((RAW + 'a0a6849c15880dc681b6e91708d2a0752bd2aa43/landing/sun-saphia/v4/img/ho-boi-tang-3',) * 3)) + '<h3 style="margin-top:12px">Hồ bơi tầng 3 view biển</h3></article>'
          '<article class="card">' + img('tien-ich-gym', 'Gym, pilates (ảnh minh họa)', 'r') + '<h3 style="margin-top:12px">Gym · Yoga · Pilates</h3></article>'
          '<article class="card">' + img('the-thao-bien', 'Thể thao biển (ảnh minh họa)', 'r') + '<h3 style="margin-top:12px">Kayak · SUP · Jetski</h3></article></div></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('09', 'Cho thuê', 'Tiềm năng <b>dòng tiền</b>', 'o') + rent_night() + '<div style="margin-top:20px">' + rent_case() + '</div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('05', 'Pháp lý', 'Pháp lý <b>rõ ràng</b>', 'n') + legal_box() + '<div style="margin-top:26px">' + daily() + '</div></div></section>')
    b = bands_at(b, [(1, band('Thời điểm vàng – đừng để lỡ đợt đầu', 'Nhận bảng giá gốc và chính sách sớm nhất qua Zalo.', 'Nhận bảng giá sớm', 'ADS – sau lý do mua sớm')),
                     (3, band('Căn view biển đẹp có hạn trên mỗi tầng', 'Để lại số để được ưu tiên chọn căn ngay khi mở bán.', 'Ưu tiên chọn căn', 'ADS – ưu tiên chọn căn')),
                     (6, band('Nhận bảng tính dòng tiền theo căn', 'Giá thuê, lấp đầy, lợi nhuận từng căn – gửi qua Zalo.', 'Nhận bảng tính', 'ADS – bảng tính dòng tiền'))])
    b += ('<section class="sec alt"><div class="wrap"><h2 class="dp" style="font-size:30px;margin-bottom:16px">Tìm hiểu <b>thêm</b></h2>' + related('/ads') + '</div></section>')
    b += cta_block('ADS – form cuối trang')
    title = 'Sun Saphia Residence – Căn hộ mặt biển Đà Nẵng | Đại lý chính thức TATILAND'
    desc = 'Căn hộ mặt biển Đà Nẵng: Studio 30m², 1BR+ 50m², 2BR 60–70m², ra biển 400m, pháp lý 50 năm, Vietcombank, BIDV, NCB hỗ trợ vay. Bảng giá gốc từ đại lý chính thức TATILAND.'
    html = head(title, desc, url, OG, 'sun saphia residence, căn hộ mặt biển đà nẵng, bảng giá sun saphia', [article_ld(title, desc, url), ORG, RES], FAV)
    b = b.replace('{M}', MAIN)
    html += '<body>\n' + header('/ads', MAIN, LOGO) + '\n<main id="dau-trang">' + b + '</main>\n' + footer(MAIN) + '\n' + popup() + tail(True) + '</body>\n</html>\n'
    return copy_fix(html)

def tinh_dong_tien():
    cr, cld = crumbs([('Trang chủ', MAIN + '/'), ('Sun Saphia Residence', MAIN + '/'), ('Tính dòng tiền', MAIN + '/tinh-dong-tien')])
    fq, fld = faq([
        ('Cho thuê studio Sun Saphia được bao nhiêu mỗi tháng?', 'Với giả định 2,5 triệu/đêm, lấp đầy 60%, chi phí vận hành 35% doanh thu, studio mang về khoảng 356 triệu/năm, tức khoảng 30 triệu/tháng. Anh/chị có thể kéo các thanh để tính theo giả định của mình.'),
        ('Nên cho thuê ngày hay cho thuê tháng?', 'Cho thuê ngày (kiểu Airbnb) doanh thu cao hơn nhưng cần đơn vị vận hành, chi phí 30–40% doanh thu. Cho thuê tháng ổn định, ít công, chi phí khoảng 10% nhưng giá thấp hơn: studio khu vực khoảng 18–20 triệu/tháng.'),
        ('Tỷ lệ lấp đầy bao nhiêu là hợp lý?', 'Bài toán của chủ đầu tư dùng 60%. Khách sạn Sun Group tại miền Trung đạt 81,3% năm 2026; mùa mưa (khoảng tháng 9–12) thường thấp hơn.'),
        ('Kết quả bảng tính có phải cam kết?', 'Không. Đây là ước tính theo giả định; kết quả thực tế phụ thuộc giá mua, mùa du lịch, cách vận hành và chi phí thực tế.')])
    b = ('<section class="sec nv" style="padding:30px 0 40px"><div class="wrap">' + cr.replace('class="crumb"', 'class="crumb" style="color:#AFC0DA"') +
         '<span class="ey" style="margin-top:14px">Sun Saphia Residence · Đà Nẵng</span><h1 class="dp" style="color:#fff">Bảng tính <b>dòng tiền</b> cho thuê</h1>'
         '<p class="lead" style="color:#C9D6EA">Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng. Anh/chị chọn loại căn, kéo các thanh để tính thử tiền về túi mỗi tháng theo ý mình.</p>'
         '</div></section>')
    b += '<section class="sec alt" style="padding-top:30px"><div class="wrap">' + calc_page.page_body() + '</div></section>'
    b += ('<section class="sec" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp về <b>dòng tiền cho thuê</b>', 'o') + fq +
          '<h3 style="margin-top:26px">Xem thêm</h3>' + related('/tinh-dong-tien') + '</div></section>')
    b += cta_block('Web – tính dòng tiền cuối trang', title='Nhận <b>bảng tính chi tiết</b> theo căn anh/chị chọn')
    title = 'Bảng tính dòng tiền cho thuê căn hộ Sun Saphia Residence Đà Nẵng'
    desc = 'Tự tính tiền cho thuê căn hộ Sun Saphia Residence: Studio, 1PN+, 2PN, cho thuê ngày hoặc tháng, giá thuê, lấp đầy, chi phí, lợi nhuận và thời gian hoàn vốn.'
    return page('/tinh-dong-tien', title, desc, 'tính dòng tiền căn hộ, cho thuê căn hộ đà nẵng, lợi nhuận cho thuê studio, airbnb đà nẵng, sun saphia cho thuê',
                b, [article_ld(title, desc, MAIN + '/tinh-dong-tien'), cld, fld], '/tinh-dong-tien')

def vi_sao():
    P = '/vi-sao-sun-group'
    hero, cld = sub_hero(P, 'Vì sao mặt biển', 'Có phải lần đầu tiên Sun Group làm <b>căn hộ cao tầng ngay mặt biển</b> Đà Nẵng?',
                         'Đúng. Sun Saphia Residence là dự án căn hộ cao tầng mặt biển đầu tiên của Sun Group tại Đà Nẵng (trước đó tập đoàn mới có resort, biệt thự biển), ra mắt tại Kick-off 23/10/2026. Bài viết phân tích 6 lý do khiến thời điểm này và vị trí này phù hợp: '
                         'quỹ đất mặt biển gần như cạn, du lịch Đà Nẵng tăng gần 30%, hạ tầng trục biển và đường sắt đô thị, dân số mới sau sáp nhập, lãi suất đi xuống và nhu cầu căn hộ nhỏ để ở – cho thuê.',
                         'thap-tren-cao-ngay', 'Sun Saphia Residence trên trục biển Võ Nguyên Giáp – Trường Sa nhìn từ trên cao', 'Web – vì sao mặt biển đầu trang')
    fq, fld = faq([
        ('Sun Saphia Residence có phải căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng?', 'Đúng. Dự án do Sun Property – thành viên Tập đoàn Sun Group – phát triển, được giới thiệu tại Kick-off 23/10/2026 là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng, trên trục Võ Nguyên Giáp – Trường Sa, cách bãi tắm Sơn Thủy khoảng 400 m. Trước đó Sun Group đã có resort và biệt thự biển (InterContinental, Premier Village), nhưng đây là sản phẩm căn hộ cao tầng mặt biển đầu tiên.'),
        ('Sun Group đã làm những dự án nào ở Đà Nẵng?', 'Du lịch – nghỉ dưỡng: Sun World Ba Na Hills (cáp treo, Cầu Vàng), InterContinental Danang Sun Peninsula Resort, Premier Village Danang Resort, Sun World Asia Park; biệt thự biển tại Premier Village. Căn hộ: Sun Cosmo, Sun Ponte, Sun Symphony ven sông Hàn; Sun Galaxy Complex; FourS Tower (Sun Riverpolis). Sun Saphia Residence là dự án căn hộ cao tầng mặt biển đầu tiên.'),
        ('Khu đất trước Sun Saphia sẽ làm gì?', 'UBND TP Đà Nẵng đã phê duyệt dự án Công viên công cộng (Quyết định 2958/QĐ-UBND) trên khoảng 2,45 ha đất thu hồi từ dự án Hòn Ngọc Á Châu, tổng mức đầu tư hơn 47 tỷ đồng, giai đoạn 2025–2027, gồm quảng trường biển, đường dạo, khu vui chơi, bãi đậu xe, khu tắm nước ngọt.'),
        ('Vì sao căn hộ mặt biển ở Đà Nẵng hiếm?', 'Biển là tài nguyên hữu hạn; dải đất ven biển Đà Nẵng phần lớn đã dành cho resort, khách sạn và không gian công cộng. Bãi biển là tài sản công, nên căn hộ có thể nhìn thẳng ra biển và đi bộ ra bãi tắm chỉ còn rất ít vị trí.'),
        ('Căn hộ mặt biển Đà Nẵng đang chào bán giá bao nhiêu?', 'Theo giá chào bán trình bày tại Kick-off: studio khoảng 5,2–10,5 tỷ, 1BR 7,7–11,5 tỷ, 2BR 17,4–21,7 tỷ tùy dự án (The Soleil, Futa Residence, Nobu). Giá Sun Saphia Residence chưa công bố, dự kiến cuối 11/2026.'),
        ('Mua căn hộ mặt biển để cho thuê có tốt không?', 'Đà Nẵng đón 15,86 triệu lượt khách 9 tháng đầu 2026 (+29,6%); khách sạn Sun Group miền Trung lấp đầy 81,3% năm 2026. Studio view biển đang cho thuê 2,2–2,9 triệu/đêm ngoài mùa cao điểm. Kết quả thực tế phụ thuộc giá mua, mùa vụ và cách vận hành.'),
        ('Khi nào mở bán Sun Saphia Residence?', 'Dự kiến cuối tháng 11/2026, bàn giao tháng 11/2028. Đăng ký nhận thông tin, bảng giá là miễn phí.')])
    b = hero
    b += tldr('vì sao Sun Group ra mắt căn hộ mặt biển tại Đà Nẵng', [
        ('Hành trình', 'Núi (Bà Nà) → resort, biệt thự biển (InterContinental, Premier Village) → căn hộ sông Hàn (Sun Cosmo, Ponte, Symphony) → Nam trung tâm (Galaxy, FourS) → căn hộ cao tầng mặt biển (Saphia)'),
        ('1. Quỹ đất', 'Đất mặt biển Đà Nẵng gần như cạn; khu Saphia là một trong rất ít vị trí căn hộ đi bộ ra biển (~400 m)'),
        ('2. Du lịch', '15,86 triệu lượt khách 9 tháng 2026 (+29,6%); Đà Nẵng là 1 trong 3 cực tăng trưởng du lịch cả nước'),
        ('3. Hạ tầng', 'Mở rộng trục biển 2.633 tỷ; ga LRT 09 cách ~500 m; Khu thương mại tự do Đà Nẵng'),
        ('4. Dân số', '~3 triệu dân sau sáp nhập Quảng Nam; di cư ròng 15–16 nghìn người/năm'),
        ('5. Thời điểm', 'Lãi suất cho vay đồng loạt giảm 10/2026; Nghị quyết 278/NQ-CP định hình lại giá trị căn hộ 50 năm'),
        ('6. Sản phẩm', 'Studio, 1BR+ diện tích gọn, vốn vừa sức, hợp để ở và cho thuê – 513/782 căn là Studio')])
    b += ('<section class="sec alt"><div class="wrap">' + sh('1', 'Quỹ đất', 'Đất mặt biển Đà Nẵng – <b>gần như không còn</b>', 'o') +
          '<div class="g2"><div class="txt just"><p>Biển là tài nguyên hữu hạn. Dải đất ven biển Đà Nẵng từ Sơn Trà về Hội An phần lớn đã thuộc về resort, khách sạn và không gian công cộng; '
          'bãi biển và vùng nước biển là tài sản công do Nhà nước quản lý. Vì vậy những vị trí <b>căn hộ để ở</b> mà đi bộ được ra biển là rất hiếm.</p>'
          '<p>Sun Saphia Residence nằm ở giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, trên khu đất 3.720,1 m², cách bãi tắm Sơn Thủy khoảng 400 m qua công viên ven biển. '
          'Phía trước, thành phố thu hồi khoảng <b>2,45 ha</b> đất của dự án Hòn Ngọc Á Châu bỏ hoang để làm <b>công viên công cộng hơn 47 tỷ đồng</b> (Quyết định 2958/QĐ-UBND, giai đoạn 2025–2027) với quảng trường biển, đường dạo, khu vui chơi – tầm nhìn ra biển được giữ thoáng.</p>'
          '<ul class="ck"><li>Trước mặt là biển Mỹ Khê – Sơn Thủy</li><li>Sau lưng là sông Hàn, bên cạnh là Ngũ Hành Sơn</li><li><b>3 đường xuống biển</b> ngay trước khu Saphia – băng qua đường là tới bãi cát</li><li>Chuỗi 3 công viên bãi tắm: Sơn Thủy, công viên đối diện, Huyền Trân Công Chúa</li></ul></div>'
          + '<div style="display:flex;flex-direction:column;gap:18px">' + ('<figure class="fg"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 900px" width="1600" height="785" alt="Ảnh vệ tinh khu Saphia: Sun Saphia Residence bên đường ven biển Võ Nguyên Giáp – Trường Sa, phía trước có 3 đường xuống biển Mỹ Khê – Sơn Thủy" loading="lazy" decoding="async"><figcaption>3 đường xuống biển ngay trước khu Saphia (ảnh vệ tinh theo tài liệu Kick-off)</figcaption></figure>' % ((RAW + '120376417ef276742a1870df38743bff7bb94046/landing/sun-saphia/v4/img/ba-duong-xuong-bien',) * 3)) + ('<figure class="fg"><img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 900px" width="1600" height="786" alt="Bản đồ vị trí Sun Saphia Residence tại giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận, cách biển Mỹ Khê – Sơn Thủy khoảng 400 m, phía trước là khu đất quy hoạch công viên" loading="lazy" decoding="async"><figcaption>Vị trí dự án trên ảnh vệ tinh – trước mặt là khu đất ven biển quy hoạch công viên, rồi tới bãi biển</figcaption></figure>' % ((RAW + '07557a38e28b15379350b5b9ac36fc91356ef704/landing/sun-saphia/v4/img/vi-tri-saphia',) * 3)) + '</div>' + '</div></div></section>')
    b += pband('Căn hộ cao tầng <b>mặt biển đầu tiên</b>', 'Tòa tháp 30 tầng – 114 m của Sun Group trên trục biển Võ Nguyên Giáp – Trường Sa.', 'Vì sao mặt biển – dải ảnh tòa tháp')
    b += ('<section class="sec"><div class="wrap">' + sh('2', 'Hành trình Sun Group', 'Từ núi, qua sông, <b>ra biển</b> Đà Nẵng', 'n') +
          '<div class="txt just"><p>Bà Nà Hills là dự án đầu tiên đánh dấu chặng đường của Sun Group tại Việt Nam (từ 2007). Gần 20 năm qua, tập đoàn đã đi một vòng trọn vẹn quanh Đà Nẵng: '
          '<b>lên núi</b> với Bà Nà, <b>ra bán đảo và bờ biển</b> với khu nghỉ dưỡng, biệt thự biển, <b>về sông Hàn</b> với chuỗi căn hộ trung tâm, mở rộng <b>về phía Nam</b> – và nay là <b>căn hộ cao tầng mặt biển đầu tiên</b>: Sun Saphia Residence.</p></div>'
          '<div class="g4 jr">'
          '<div class="card"><span class="n">CHẶNG 1 · NÚI</span><h3 class="oc"><a href="https://banahills.sunworld.vn/" target="_blank" rel="noopener">Sun World Ba Na Hills</a></h3><p>Cáp treo Bà Nà (2009) giữ 2 kỷ lục Guinness, tuyến dài 5.042,62 m; Cầu Vàng (6/2018) thành biểu tượng du lịch Đà Nẵng ra thế giới.</p></div>'
          '<div class="card"><span class="n">CHẶNG 2 · RESORT &amp; BIỆT THỰ BIỂN</span><h3 class="oc">InterContinental · Premier Village</h3><p><a href="https://www.danang.intercontinental.com/" target="_blank" rel="noopener">InterContinental Danang Sun Peninsula Resort</a> trên bán đảo Sơn Trà – được World Travel Awards vinh danh khu nghỉ dưỡng sang trọng hàng đầu thế giới; Premier Village Danang Resort với các biệt thự ven biển Võ Nguyên Giáp. Cùng Sun World Asia Park bên sông Hàn.</p></div>'
          '<div class="card"><span class="n">CHẶNG 3 · SÔNG HÀN</span><h3 class="oc">Sun Cosmo · Sun Ponte · Sun Symphony</h3><p>Chuỗi căn hộ ven sông Hàn: Sun Cosmo (cầu Trần Thị Lý, tòa The Panoma đã bàn giao), Sun Ponte (cạnh cầu Rồng, 2 tháp 26 tầng, gần 500 căn), <a href="https://www.sun-symphony5.com/" target="_blank" rel="noopener">Sun Symphony</a> (bến Bạch Đằng, 3 tháp, khoảng 1.313 căn) – đã lần lượt bàn giao cho cư dân.</p></div>'
          '<div class="card"><span class="n">CHẶNG 4 · NAM TRUNG TÂM</span><h3 class="oc">Sun Galaxy · FourS Tower</h3><p><a href="https://www.sun-galaxy-complex.com.vn/" target="_blank" rel="noopener">Sun Galaxy Complex</a> 47 tầng cạnh cầu Trần Thị Lý (căn hộ mang thương hiệu Accor); <a href="https://www.sun-fours-tower.com/" target="_blank" rel="noopener">FourS Tower</a> trong khu đô thị Sun Riverpolis, Ngũ Hành Sơn – đã mở bán tháp F2 (Tháp Mùa Xuân).</p></div>'
          '</div>'
          '<div class="g2" style="margin-top:22px;align-items:center"><div class="sbox2"><span class="ey">CHẶNG 5 · BIỂN</span><h3 class="dp" style="font-size:30px;margin:6px 0 10px">Căn hộ cao tầng mặt biển – <b>mảnh ghép còn thiếu</b></h3>'
          '<p class="just">Sun Group đã có núi (Bà Nà), có sông (chuỗi căn hộ sông Hàn), có resort và <b>biệt thự biển</b> – nhưng chưa có <b>căn hộ cao tầng</b> nào ngay mặt biển Đà Nẵng. Biệt thự biển giá trị lớn, số lượng ít; căn hộ cao tầng mở cánh cửa sở hữu “nhà mặt biển” cho nhiều người hơn, với vốn vừa sức. Saphia lấp đúng khoảng trống đó: '
          'trên trục Võ Nguyên Giáp – Trường Sa, cách bãi tắm Sơn Thủy khoảng 400 m, tầm nhìn cùng lúc về biển Mỹ Khê, sông Hàn và Ngũ Hành Sơn. '
          'Vì vậy thông điệp của dự án là <b>“Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi”</b>.</p></div>'
          '<div><ul class="ck"><li><b>Kinh nghiệm bàn giao</b> – chuỗi căn hộ sông Hàn đã về tay cư dân, người mua có thể đến xem chất lượng thực tế</li>'
          '<li><b>Thương hiệu cho thuê</b> – các tòa Sun Group sông Hàn (như The Panoma) đang cho thuê 18–35 triệu/tháng, là mốc tham chiếu cho căn mặt biển</li>'
          '<li><b>Hệ sinh thái du lịch</b> – Bà Nà, Sun World, resort của tập đoàn kéo khách về Đà Nẵng, tạo nguồn khách thuê</li>'
          '<li><b>Bước lên của sản phẩm</b> – từ căn hộ ven sông và biệt thự biển sang căn hộ cao tầng mặt biển: quỹ đất hiếm hơn, vốn vừa sức hơn biệt thự, dòng tiền nghỉ dưỡng rõ hơn</li></ul>'
          '<a class="lk" href="{M}/cho-thue">So sánh giá thuê các tòa ven sông →</a></div></div>'
          '<p class="src">Nguồn: báo chí (VnExpress, Reatimes, Cafeland…) và thông tin chủ đầu tư công bố; quy mô, tiến độ từng dự án theo công bố của chủ đầu tư. '
          'Phần phân tích là góc nhìn của đại lý phân phối TATILAND, không phải phát biểu chính thức của chủ đầu tư.</p></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('3', 'Du lịch', 'Du lịch Đà Nẵng <b>tăng gần 30%</b>', 'y') +
          '<div class="stats"><div><b>15,86 triệu</b><span>lượt khách 9 tháng 2026 · +29,6%</span></div><div><b>7,69 triệu</b><span>khách quốc tế · +28,9%</span></div>'
          '<div><b>52.945 tỷ</b><span>doanh thu du lịch · +26,2%</span></div><div><b>81,3%</b><span>lấp đầy khách sạn Sun Group miền Trung 2026</span></div></div>'
          '<div class="g2" style="margin-top:22px"><div class="txt just"><p>Nghị quyết 26 xác định Đà Nẵng là 1 trong 3 cực tăng trưởng du lịch cùng Hà Nội và TP.HCM. Mục tiêu đến 2030 của cả nước: 45–50 triệu lượt khách quốc tế và 80–90 tỷ USD doanh thu du lịch.</p>'
          '<p>Khách ngày càng ưu tiên chỗ ở phía biển. Studio view biển Đà Nẵng đang cho thuê <b>2,2–2,9 triệu/đêm</b>, 1BR+ <b>3,4–3,7 triệu/đêm</b> ngoài mùa cao điểm – nền cầu thuê cho căn hộ mặt biển.</p>'
          '<a class="lk" href="{M}/cho-thue">Xem dòng tiền cho thuê →</a></div>'
          + fig('khach-du-lich', 'Khách du lịch trên bãi biển Đà Nẵng', 'Khách du lịch đến Đà Nẵng vì biển') + '</div>'
          '<p class="src">Nguồn: Sở VH-TT-DL, Cục Thống kê TP Đà Nẵng (9 tháng 2026) · Sun Group · theo tài liệu Kick-off.</p></div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('4', 'Hạ tầng', 'Hạ tầng <b>mở đường</b> cho trục biển', 'o') +
          '<div class="g3"><div class="card"><span class="n">TRỤC BIỂN</span><h3 class="oc">2.633 tỷ</h3><p>Mở rộng đường Võ Nguyên Giáp, Trường Sa, Lạc Long Quân – trục chính trước dự án.</p></div>'
          '<div class="card"><span class="n">ĐƯỜNG SẮT ĐÔ THỊ</span><h3 class="oc">~500 m tới ga LRT 09</h3><p>Tuyến sân bay – Hội An, giai đoạn 1 dự kiến khởi công 2/2027.</p></div>'
          '<div class="card"><span class="n">KHU THƯƠNG MẠI TỰ DO</span><h3 class="oc">QĐ 1142/QĐ-TTg</h3><p>Khu thương mại tự do Đà Nẵng (6/2025) kéo theo chuyên gia, doanh nghiệp; Galaxy – Downtown cách 4 km.</p></div></div>'
          '<div class="g2" style="margin-top:20px">' + fig('mo-rong-duong-bien', 'Tuyến đường ven biển Võ Nguyên Giáp – Trường Sa được mở rộng', 'Trục biển Võ Nguyên Giáp – Trường Sa mở rộng (2.633 tỷ)')
          + fig('lrt-ban-do', 'Bản đồ quy hoạch tuyến đường sắt đô thị sân bay – Hội An đi qua khu Ngũ Hành Sơn', 'Tuyến đường sắt đô thị sân bay – Hội An (quy hoạch)') + '</div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('5', 'Dân số', 'Đà Nẵng mới – <b>~3 triệu dân</b>', 'n') + migration() + '</div></section>')
    b += ('<section class="sec"><div class="wrap">' + sh('6', 'Thời điểm', 'Lãi suất giảm, <b>chính sách mở</b>', 'y') +
          '<div class="g2"><div class="txt just"><p>Tháng 10/2026, Ngân hàng Nhà nước yêu cầu giảm lãi suất; Agribank, Vietcombank, BIDV, MB, ACB, Sacombank… đồng loạt giảm lãi suất cho vay. '
          'Tín dụng khách sạn, khu nghỉ dưỡng được tách khỏi dư nợ bất động sản để thúc đẩy du lịch nghỉ dưỡng.</p>'
          '<p>Nghị quyết 278/NQ-CP (18/9/2026) xác định thời hạn sử dụng chung cư theo niên hạn công trình – Sun Saphia Residence là công trình cấp I, niên hạn 100 năm, thời hạn dự án 50 năm.</p>'
          '<a class="lk" href="{M}/phap-ly">Xem pháp lý chi tiết →</a></div>' + nq278() + '</div></div></section>')
    b += ('<section class="sec alt"><div class="wrap">' + sh('7', 'Sản phẩm', 'Căn nhỏ – <b>vừa túi tiền, dễ cho thuê</b>', 'o') +
          '<div class="txt just"><p>Thay vì căn lớn giá chục tỷ như phần lớn căn hộ ven biển đang chào bán, Sun Saphia Residence tập trung căn gọn: <b>513 Studio 30–31 m²</b>, 108 căn 1BR+ 50–51 m², 133 căn 2BR 60–70 m², trần cao 3,5 m. '
          'Vốn vào vừa sức người trẻ, người mua second home và nhà đầu tư cho thuê.</p></div>' + price_table() +
          '<p style="margin-top:14px"><a class="lk" href="{M}/bang-gia">Xem bảng giá &amp; tính vay →</a> · <a class="lk" href="{M}/mat-bang">Chọn căn trên mặt bằng →</a></p></div></section>')
    b += ('<section class="sec" id="hoi-dap"><div class="wrap">' + sh('?', 'Hỏi đáp', 'Hỏi đáp: <b>căn hộ mặt biển</b> Sun Group Đà Nẵng', 'n') + fq +
          '<h3 style="margin-top:26px">Xem thêm</h3>' + related(P) + '</div></section>')
    b = bands_at(b, [(2, band('Căn hộ mặt biển có hạn – đợt đầu chọn căn đẹp nhất', 'Nhận bảng giá gốc và mặt bằng căn trống qua Zalo.', 'Nhận bảng giá sớm', 'Vì sao mặt biển – giữa trang', ('/bang-gia', 'Xem bảng giá'))),
                     (5, band('Muốn biết căn nào cho thuê tốt nhất?', 'Nhận bảng tính dòng tiền theo căn anh/chị quan tâm.', 'Nhận bảng tính', 'Vì sao mặt biển – dòng tiền', ('/tinh-dong-tien', 'Tự tính dòng tiền')))])
    b += cta_block('Web – vì sao mặt biển cuối trang', title='Sở hữu căn hộ <b>mặt biển đầu tiên</b> của Sun Group tại Đà Nẵng')
    title = 'Có phải lần đầu tiên Sun Group làm căn hộ cao tầng ngay mặt biển Đà Nẵng?'
    desc = 'Đúng. Sun Saphia Residence là căn hộ cao tầng mặt biển đầu tiên của Sun Group tại Đà Nẵng. Vì sao là lúc này: đất biển hiếm, du lịch +29,6%, lãi suất giảm.'
    return page(P, title, desc, 'căn hộ mặt biển đầu tiên sun group, căn hộ cao tầng mặt biển đà nẵng, vì sao sun group đà nẵng, các dự án sun group đà nẵng, sun saphia residence',
                b, [article_ld(title, desc, MAIN + P, '2026-10-24', '2026-10-24'), cld, fld], P)

if __name__ == '__main__':
    import os
    os.makedirs(OUT, exist_ok=True)
    out = {'trang-chu.html': home(), 'bang-gia.html': bang_gia(), 'mat-bang.html': mat_bang(), 'phap-ly.html': phap_ly(), 'cho-thue.html': cho_thue(), 'tinh-dong-tien.html': tinh_dong_tien(), 'vi-sao-sun-group.html': vi_sao(),
           'ads.html': ads(MAIN), 'ads-shaphia.html': ads('https://www.sun-shaphiaresidence.com')}
    # Trang chủ tên miền phụ: cùng nội dung, chuẩn hóa về tên miền chính để tránh trùng nội dung
    out['shaphia.html'] = out['trang-chu.html']
    for k, v in out.items():
        left = re.findall(r'\{\{|%[sd]\b', v)
        open(OUT + k, 'w', encoding='utf8').write(v)
        print(k, len(v))
