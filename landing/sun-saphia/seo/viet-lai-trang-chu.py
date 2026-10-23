# Viết lại phần nội dung trang chủ Sun Saphia (SEO) theo thông tin Kick-off 23/10/2026
import json, re, sys
F = '/home/user/hoang-hiep-crm/landing/sun-saphia/chat/pages/trang-chu.html'
s = open(F, encoding='utf8').read()
RAW = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/'
IMG = RAW + '6adc4d532f6588cb7ce42192e5fc64c6ab2d6c53/projects/sun-saphia/images/'
IMG2 = RAW + 'dfc643572b07321edfe1599f19595985ebcb2db1/projects/sun-saphia/images/'
PC = RAW + '3986107e7e19e455f2ac286123672addf10671d7/projects/sun-saphia/images/'
MB = RAW + 'cf9ac96c873e8e01d9f17d7e6272cf7ce6180278/landing/sun-saphia/ads-v3/'
OG = PC + 'chia-se-ss-phoi-canh-1200x630.jpg'

TITLE = 'Sun Saphia Residence Đà Nẵng: Giá, Mặt bằng, Pháp lý 2026'
DESC = 'Sun Saphia Residence Đà Nẵng – căn hộ mặt biển đầu tiên của Sun Group: 30 tầng, 782 căn, pháp lý 50 năm, Vietcombank, BIDV, NCB hỗ trợ vay.'

FAQ = [
 ('Sun Saphia Residence ở đâu?', 'Góc đường Trường Sa – Nguyễn Đức Thuận, khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng, trên trục biển Võ Nguyên Giáp – Trường Sa, ra bãi tắm Sơn Thủy khoảng 400 m qua công viên ven biển.'),
 ('Chủ đầu tư Sun Saphia Residence là ai?', 'Dự án do Sun Property (thành viên Tập đoàn Sun Group) phát triển. Tại sự kiện Kick-off 23/10/2026, dự án được giới thiệu là căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng.'),
 ('Sun Saphia Residence có bao nhiêu tầng, bao nhiêu căn?', '1 tòa tháp 30 tầng nổi, cao khoảng 114 m, 2 tầng hầm, tổng 782 căn trên khu đất 3.720,1 m². Căn hộ bố trí từ tầng 3A đến tầng 28.'),
 ('Có những loại căn nào?', 'Studio 30–31 m² (513 căn), 1BR+ 50–51 m² (108 căn), 2BR 60–70 m² (133 căn). Trần căn hộ cao 3,5 m, bàn giao hoàn thiện cơ bản.'),
 ('Pháp lý Sun Saphia Residence thế nào?', 'Theo Giấy chứng nhận đăng ký đầu tư mã dự án 2572746483, cấp lần đầu ngày 17/09/2026: thời hạn hoạt động dự án 50 năm kể từ ngày cấp; công trình cấp I, niên hạn sử dụng 100 năm.'),
 ('Ngân hàng nào hỗ trợ vay mua Sun Saphia Residence?', 'Vietcombank, BIDV và NCB. Tỷ lệ vay, thời gian hỗ trợ lãi suất theo chính sách bán hàng của chủ đầu tư.'),
 ('Giá bán Sun Saphia Residence bao nhiêu?', 'Chủ đầu tư chưa công bố bảng giá chính thức. Căn hộ mặt biển Đà Nẵng hiện được chào bán khoảng: studio 5,2–10,5 tỷ, 1BR 7,7–11,5 tỷ, 2BR 17,4–21,7 tỷ (các dự án ven biển, tham khảo tại Kick-off).'),
 ('Khi nào mở bán, khi nào bàn giao?', 'Dự kiến mở bán cuối tháng 11/2026, bàn giao tháng 11/2028 (kế hoạch, có thể thay đổi theo công bố của chủ đầu tư).'),
 ('Cho thuê căn hộ Sun Saphia được bao nhiêu?', 'Giá thuê căn hộ view biển Đà Nẵng hiện khoảng 2,2–2,9 triệu/đêm (studio) và 3,4–3,7 triệu/đêm (1BR+), chưa tính mùa cao điểm. Đây là số liệu thị trường tham khảo, không phải cam kết lợi nhuận.'),
 ('Bây giờ có phải đặt cọc không?', 'Không. Hiện chỉ đăng ký nhận thông tin, bảng giá và mặt bằng; không thu bất kỳ khoản tiền nào.'),
]

LD = {"@context": "https://schema.org", "@graph": [
  {"@type": "Article", "headline": "Sun Saphia Residence Đà Nẵng: giá, mặt bằng, pháp lý, tiện ích và tiềm năng cho thuê",
   "datePublished": "2026-10-17", "dateModified": "2026-10-23", "author": {"@type": "Person", "name": "Hoàng Hiệp"},
   "image": OG, "mainEntityOfPage": "https://www.sun-saphia-residence.com/", "inLanguage": "vi"},
  {"@type": "Residence", "name": "Sun Saphia Residence", "description": DESC,
   "address": {"@type": "PostalAddress", "streetAddress": "Góc Trường Sa – Nguyễn Đức Thuận", "addressLocality": "Ngũ Hành Sơn, Đà Nẵng", "addressCountry": "VN"}},
  {"@type": "BreadcrumbList", "itemListElement": [
   {"@type": "ListItem", "position": 1, "name": "Trang chủ", "item": "https://www.sun-saphia-residence.com/"},
   {"@type": "ListItem", "position": 2, "name": "Sun Saphia Residence"}]},
  {"@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}} for q, a in FAQ]}]}

def form(fid, n, btn):
    return (f'<form class="hm-form" data-form="{fid}">\n'
            f'          <label for="ten{n}">Họ và tên</label>\n          <input id="ten{n}" name="name" type="text" placeholder="Anh/chị tên gì ạ?">\n'
            f'          <label for="sdt{n}">Số điện thoại / Zalo</label>\n          <input id="sdt{n}" name="phone" type="tel" placeholder="09xx xxx xxx">\n'
            f'          <button class="btn pulse" type="submit">{btn}</button>\n'
            '          <span class="alt">Hoặc <a href="https://zalo.me/0904567009">nhắn Zalo</a> · <a href="tel:0904567009">gọi 0904 567 009</a></span>\n'
            '        </form>')

faq_html = '\n'.join(f'  <details{" open" if i == 0 else ""}><summary>{q}</summary><p>{a}</p></details>' for i, (q, a) in enumerate(FAQ))

ART = f'''<article>
<!-- HERO -->
<section class="ahero" id="dau-trang">
  <div class="wrap">
    <p class="crumb"><a href="#dau-trang">Trang chủ</a> › Dự án Đà Nẵng › Sun Saphia Residence</p>
    <h1><span class="kim">Sun Saphia Residence</span> Đà Nẵng – căn hộ mặt biển đầu tiên của Sun Group: giá, mặt bằng, pháp lý (cập nhật 10/2026)</h1>
    <p class="hot">🔥 Vừa Kick-off 23/10/2026 · Dự kiến mở bán cuối 11/2026 · Đang nhận danh sách quan tâm</p>
    <p class="meta">Hoàng Hiệp – chuyên viên tư vấn bất động sản Đà Nẵng · Cập nhật: 23/10/2026 · Thời gian đọc ~12 phút</p>
    <div class="agrid">
      <div>
        <p class="sapo hook">Trước mặt là biển, sau lưng là sông, bên cạnh là núi. Một tòa tháp 30 tầng trên cung đường tỷ đô Võ Nguyên Giáp – Trường Sa.</p>
        <p class="sapo"><strong>Sun Saphia Residence</strong> là tòa căn hộ mặt biển 30 tầng (~114 m) do <strong>Sun Property</strong> (thành viên Tập đoàn Sun Group) phát triển tại góc Trường Sa – Nguyễn Đức Thuận, phường Ngũ Hành Sơn, Đà Nẵng. Dự án có 782 căn Studio, 1BR+ và 2BR, pháp lý 50 năm, Vietcombank – BIDV – NCB hỗ trợ vay; dự kiến mở bán cuối 11/2026, bàn giao 11/2028. Bài viết tổng hợp toàn bộ thông tin đã công bố tại sự kiện Kick-off ngày 23/10/2026, kèm nguồn dẫn.</p>
        <figure class="fig"><img src="{PC}ss-phoi-canh-bien-hoang-hon.webp" alt="Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên bờ biển Đà Nẵng lúc hoàng hôn" width="1280" height="720" fetchpriority="high"><figcaption>Phối cảnh minh họa Sun Saphia Residence (tài liệu giới thiệu dự án).</figcaption></figure>
      </div>
      <div class="rc"><aside class="card">
        <h3>Nhận bảng giá Sun Saphia Residence</h3>
        <p class="note">Bảng giá · mặt bằng tầng · chính sách – gửi qua Zalo ngay khi chủ đầu tư công bố.</p>
        {form("seo-dau-trang", 1, "Nhận bảng giá qua Zalo")}
        <p class="note" style="margin:12px 0 0">✔ Không thu tiền giữ chỗ · ✔ Thông tin có nguồn</p>
      </aside>
      <table class="qft">
        <tbody>
          <tr><td><b>30 tầng</b>~114 m · 2 hầm</td><td><b>782 căn</b>Studio · 1BR+ · 2BR</td></tr>
          <tr><td><b>50 năm</b>thời hạn dự án</td><td><b>3,5 m</b>trần căn hộ</td></tr>
          <tr><td><b>11/2026</b>dự kiến mở bán</td><td><b>11/2028</b>dự kiến bàn giao</td></tr>
        </tbody>
      </table></div>
    </div>
  </div>
</section>

<div class="wrap prose">

<table class="hotb">
  <tbody>
    <tr><td><i>🌊</i><b>~400 m ra bãi tắm Sơn Thủy</b>Băng qua công viên bãi tắm 2,45 ha ngay trước dự án</td><td><i>🏢</i><b>Sun Group đầu tiên ở biển Đà Nẵng</b>Căn hộ mặt biển đầu tiên của Sun Group tại thành phố</td></tr>
    <tr><td><i>🚆</i><b>~500 m tới ga LRT 09</b>Tuyến đường sắt đô thị sân bay – Hội An (quy hoạch)</td><td><i>🏦</i><b>Pháp lý rõ, ngân hàng lớn</b>GCN đăng ký đầu tư 2572746483; Vietcombank, BIDV, NCB</td></tr>
  </tbody>
</table>
<nav class="toc" aria-label="Mục lục">
  <b>Nội dung bài viết</b>
  <ol>
    <li><a href="#tong-quan">Thông tin tổng quan Sun Saphia Residence</a></li>
    <li><a href="#vi-tri">Vị trí: trung điểm hệ di sản Đà Nẵng</a></li>
    <li><a href="#ha-tang">Hạ tầng: LRT, mở rộng trục biển, Galaxy – Downtown</a></li>
    <li><a href="#cong-vien">Chuỗi 3 công viên bãi tắm trước thềm nhà</a></li>
    <li><a href="#kien-truc">Kiến trúc "Vũ điệu Di sản" và 3 hướng view</a></li>
    <li><a href="#tien-ich">Tiện ích "may đo" nghỉ dưỡng</a></li>
    <li><a href="#mat-bang">Mặt bằng và các loại căn hộ</a></li>
    <li><a href="#phap-ly">Pháp lý, ngân hàng và tiến độ</a></li>
    <li><a href="#gia-ban">Giá bán và so sánh căn hộ mặt biển</a></li>
    <li><a href="#cho-thue">Tiềm năng cho thuê và dòng tiền</a></li>
    <li><a href="#phu-hop">Sun Saphia Residence phù hợp với ai?</a></li>
    <li><a href="#hoi-dap">Câu hỏi thường gặp</a></li>
  </ol>
</nav>

<!-- 1 -->
<h2 id="tong-quan">1. Thông tin tổng quan dự án Sun Saphia Residence</h2>
<p>Sun Saphia Residence là dự án căn hộ mặt biển do <strong>Sun Property</strong> – thành viên Tập đoàn Sun Group – phát triển tại khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng. Tại sự kiện Kick-off "Đón ánh dương – Giao hòa nhịp sống" ngày 23/10/2026 ở KOI Resorts &amp; Residence Đà Nẵng, dự án được giới thiệu là <strong>căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng</strong>.</p>
<table class="tb">
  <caption>Bảng thông tin Sun Saphia Residence (theo tài liệu công bố tại Kick-off)</caption>
  <tbody>
    <tr><th>Tên dự án</th><td>Sun Saphia Residence</td></tr>
    <tr><th>Đơn vị phát triển</th><td>Sun Property (thành viên Tập đoàn Sun Group)</td></tr>
    <tr><th>Vị trí</th><td>Góc Trường Sa – Nguyễn Đức Thuận, khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng</td></tr>
    <tr><th>Diện tích khu đất</th><td>3.720,1 m²</td></tr>
    <tr><th>Quy mô</th><td>1 tòa tháp 30 tầng nổi (~114 m), 2 tầng hầm; căn hộ từ tầng 3A đến tầng 28</td></tr>
    <tr><th>Tổng số căn</th><td>782 căn</td></tr>
    <tr><th>Loại căn</th><td>Studio 30–31 m² (513 căn) · 1BR+ 50–51 m² (108 căn) · 2BR 60–70 m² (133 căn)</td></tr>
    <tr><th>Chiều cao trần căn hộ</th><td>3,5 m</td></tr>
    <tr><th>Tiêu chuẩn bàn giao</th><td>Hoàn thiện cơ bản</td></tr>
    <tr><th>Pháp lý</th><td>GCN đăng ký đầu tư mã dự án 2572746483, cấp lần đầu 17/09/2026; thời hạn dự án 50 năm; công trình cấp I, niên hạn 100 năm</td></tr>
    <tr><th>Ngân hàng hỗ trợ</th><td>Vietcombank, BIDV, NCB</td></tr>
    <tr><th>Dự kiến mở bán</th><td>Cuối tháng 11/2026</td></tr>
    <tr><th>Dự kiến bàn giao</th><td>Tháng 11/2028</td></tr>
  </tbody>
</table>
<p class="small">Các mốc thời gian là kế hoạch dự kiến; giá bán và chính sách theo công bố chính thức của chủ đầu tư.</p>

<!-- 2 -->
<h2 id="vi-tri">2. Vị trí Sun Saphia Residence: toạ độ trung điểm hệ di sản Đà Nẵng</h2>
<p>Dự án nằm ở góc Trường Sa – Nguyễn Đức Thuận, đúng đoạn nối đại lộ ven biển Võ Nguyên Giáp với Trường Sa – <strong>"cung đường tỷ đô"</strong> của chuỗi resort Đà Nẵng – Hội An. Một hướng về trung tâm và bán đảo Sơn Trà, một hướng về Ngũ Hành Sơn và phố cổ Hội An; trước mặt là biển Mỹ Khê – Sơn Thủy.</p>
<table class="locx">
  <tbody><tr>
    <td class="lx-map"><img src="{IMG2}so-do-vi-tri.webp" alt="Sơ đồ vị trí Sun Saphia Residence góc Trường Sa – Nguyễn Đức Thuận, gần bãi tắm Sơn Thủy, sân bay, Ngũ Hành Sơn, Hội An" width="1200" height="1560" loading="lazy"></td>
    <td class="lx-r">
      <span class="lx-k">Kết nối từ Sun Saphia Residence</span>
      <b class="lx-t">Biển trước nhà, phố ngay sau lưng</b>
      <table class="lx-d">
        <tbody>
          <tr><td class="i">🏖️</td><td><b>Bãi tắm Sơn Thủy – Mỹ Khê</b>Qua công viên ven biển</td><td class="t">~400 m</td></tr>
          <tr><td class="i">🚆</td><td><b>Ga LRT 09 (quy hoạch)</b>Tuyến sân bay – Hội An</td><td class="t">~500 m</td></tr>
          <tr><td class="i">🏙️</td><td><b>Tổ hợp Galaxy · Đà Nẵng Downtown</b>Đủ gần để kết nối</td><td class="t">~4 km</td></tr>
          <tr><td class="i">⛰️</td><td><b>Ngũ Hành Sơn · phố An Thượng</b>Danh thắng, ẩm thực quốc tế</td><td class="t">5–10′</td></tr>
          <tr><td class="i">✈️</td><td><b>Sân bay quốc tế Đà Nẵng</b></td><td class="t">10–15′</td></tr>
          <tr><td class="i">🏮</td><td><b>Phố cổ Hội An</b>Di sản văn hóa thế giới</td><td class="t">~30′</td></tr>
        </tbody>
      </table>
      <span class="lx-note">Khoảng cách theo tài liệu Kick-off; thời gian ước tính bằng ô tô. Sơ đồ minh họa, không theo tỷ lệ.</span>
    </td>
  </tr></tbody>
</table>
<div class="cta-strip"><div><b>Ở xa chưa ra được Đà Nẵng?</b><span>Chuyên viên gọi video Zalo, đi thực tế từ dự án ra biển cho anh/chị xem.</span></div><div class="cs-b"><a class="btn" href="#dang-ky">Đặt lịch xem</a><a class="btn zalo" href="https://zalo.me/0904567009">Nhắn Zalo</a></div></div>

<!-- 3 -->
<h2 id="ha-tang">3. Hạ tầng thúc đẩy giá trị: LRT, mở rộng trục biển, Galaxy – Downtown</h2>
<div class="dn2">
  <div><i>🚆</i><b>~500 m tới nhà ga LRT 09</b><span>Theo quy hoạch tuyến đường sắt đô thị sân bay – Hội An: từ sân bay về Saphia, từ Saphia tới các điểm du lịch. Giai đoạn 1 dự kiến khởi công 2/2027 (<a href="https://tuoitre.vn/tuyen-duong-sat-do-thi-da-nang-se-khoi-cong-vao-thang-2-2027-20260420182515178.htm" target="_blank" rel="noopener">Tuổi Trẻ</a>).</span></div>
  <div><i>🛣️</i><b>Mở rộng Võ Nguyên Giáp – Trường Sa – Lạc Long Quân</b><span>Thành phố đã quyết định mở rộng trục đường biển; tổng mức đầu tư dự kiến 2.633 tỷ đồng.</span></div>
  <div><i>🏙️</i><b>~4 km tới Galaxy và Đà Nẵng Downtown</b><span>Đủ gần để kết nối trung tâm mới, đủ xa để giữ sự riêng tư bên biển.</span></div>
  <div><i>🏦</i><b>Khu thương mại tự do Đà Nẵng</b><span>Thành lập theo Quyết định 1142/QĐ-TTg (6/2025), kéo theo chuyên gia, doanh nghiệp đến làm việc.</span></div>
</div>
<p class="small">Hạ tầng theo quy hoạch; tiến độ do cơ quan nhà nước quyết định.</p>

<!-- 4 -->
<h2 id="cong-vien">4. Chuỗi 3 công viên bãi tắm ngay trước thềm nhà</h2>
<p>Bãi biển và vùng nước biển tại Việt Nam là tài sản công thuộc sở hữu toàn dân, do Nhà nước đại diện quản lý. Tại Saphia, bãi biển hiện hữu ngay trước "thềm nhà", cùng chuỗi 3 công viên bãi tắm công cộng:</p>
<div class="pol">
  <div><img class="pimg" src="{IMG}ss-bai-tam-son-thuy.webp" alt="Bãi tắm Sơn Thủy Đà Nẵng với thuyền thúng" width="575" height="397" loading="lazy"><b>Bãi tắm Sơn Thủy</b><span>Bãi tắm đầu tiên trong chuỗi, đang hoạt động, sát khu Saphia.</span></div>
  <div><img class="pimg" src="{IMG}ss-cong-vien-truoc-du-an.webp" alt="Công viên bãi tắm đối diện Sun Saphia Residence, thu hồi từ khu du lịch Hòn Ngọc Á Châu" width="690" height="398" loading="lazy"><b>Công viên bãi tắm đối diện dự án (~2,45 ha)</b><span>Thành phố thu hồi phần đất phía Nam KDL Hòn Ngọc Á Châu (rộng 90 m) để làm công viên công cộng, vốn hơn 47 tỷ đồng.</span></div>
  <div><img class="pimg" src="{IMG}ss-cong-vien-htcc.webp" alt="Công viên bãi tắm cuối đường Huyền Trân Công Chúa" width="645" height="400" loading="lazy"><b>Công viên bãi tắm Huyền Trân Công Chúa</b><span>Dự án công viên bãi tắm cuối đường Huyền Trân Công Chúa, gần danh thắng Ngũ Hành Sơn.</span></div>
</div>
<p>Riêng <strong>dự án Công viên, Câu lạc bộ thể thao biển và Bãi tắm Sơn Thủy</strong> đã có phương án khảo sát được phê duyệt theo Quyết định số 130 ngày 20/3/2025, quy mô khoảng 3 ha, mật độ xây dựng chỉ khoảng 3,9% – chủ yếu là cây xanh, bãi cát, sân thể thao. Mặt nước phẳng trước dự án hợp chèo kayak, SUP đón bình minh và jetski.</p>
<p class="small">Nguồn: <a href="https://baovanhoa.vn/van-hoa/da-nang-dau-tu-hon-47-ti-dong-xay-dung-cong-vien-cong-cong-ven-bien-244295.html" target="_blank" rel="noopener">Báo Văn Hóa</a> · <a href="https://vneconomy.vn/da-nang-thu-hoi-dat-o-nhieu-du-an-de-lam-cong-vien-cong-cong.htm" target="_blank" rel="noopener">VnEconomy</a> · tài liệu Kick-off.</p>

<!-- 5 -->
<h2 id="kien-truc">5. Kiến trúc "Vũ điệu Di sản" và 3 hướng view biển – núi – sông</h2>
<p>Kiến trúc Sun Saphia Residence lấy cảm hứng từ nghệ thuật điêu khắc Chăm Pa và hình tượng vũ nữ <strong>Apsara</strong>: chắt lọc tinh thần di sản, tái hiện bằng ngôn ngữ đương đại – một biểu tượng mới của Sun Group bên biển Đà Nẵng. Khối tháp thẳng, mặt dài hướng biển, mặt đứng kính xanh nhạt với ban công và trụ màu đồng.</p>
<div class="two">
  <figure class="fig"><img src="{RAW}1c4bbd55096aabc92a9e46321d6b80e6662d64cf/projects/sun-saphia/images/ss-thap-cam.webp" alt="Mặt đứng Sun Saphia Residence – kính xanh, ban công màu đồng" width="1000" height="1300" loading="lazy"><figcaption>Mặt đứng: kính xanh, viền sáng chạy dọc, ban công màu đồng.</figcaption></figure>
  <figure class="fig"><img src="{IMG}ss-thap-hd.webp" alt="Sun Saphia Residence nhìn từ biển, bên hồ cảnh quan và hàng dừa" width="810" height="1125" loading="lazy"><figcaption>Nhìn từ biển: tòa tháp bên bãi cát, hồ cảnh quan, hàng dừa.</figcaption></figure>
</div>
<table class="v4h">
  <tbody><tr>
    <td><i>🌊</i><b>Hướng biển</b>Không cần đi nghỉ dưỡng, biển đã ở ngoài ban công</td>
    <td><i>⛰️</i><b>Hướng núi</b>Ngũ Hành Sơn – bức tranh treo ngay cửa sổ</td>
    <td><i>🌇</i><b>Hướng sông</b>Hoàng hôn sông Hàn, "vé xem" miễn phí mỗi chiều</td>
    <td><i>🏙️</i><b>Hướng phố</b>Trung tâm, cầu Rồng, xa xa Bà Nà</td>
  </tr></tbody>
</table>
<div class="g4">
  <figure class="fig"><img src="{IMG2}mo-hinh/ss-5d-view-bien-tang-24.webp" alt="View biển từ tầng 24 Sun Saphia Residence lúc bình minh" width="1600" height="1200" loading="lazy"><figcaption>Mô hình minh họa: bình minh trên biển nhìn từ tầng 24.</figcaption></figure>
  <figure class="fig"><img src="{IMG2}mo-hinh/ss-5d-view-thanh-pho-tang-24.webp" alt="View sông Hàn và thành phố từ tầng 24 Sun Saphia Residence" width="1600" height="1200" loading="lazy"><figcaption>Mô hình minh họa: hướng Tây về sông Hàn, trung tâm.</figcaption></figure>
  <figure class="fig"><img src="{IMG2}mo-hinh/ss-3d-tong-quan.webp" alt="Mô hình 3D Sun Saphia Residence tổng quan khu đất" width="1600" height="1200" loading="lazy"><figcaption>Mô hình 3D: góc Trường Sa – Nguyễn Đức Thuận.</figcaption></figure>
  <figure class="fig"><img src="{IMG2}mo-hinh/ss-4d-hoang-hon.webp" alt="Mô hình 4D Sun Saphia Residence lúc hoàng hôn" width="1600" height="1200" loading="lazy"><figcaption>Mô hình 4D: nắng chiều, bóng đổ ra biển.</figcaption></figure>
</div>
<p class="small">Mô hình dựng lại để minh họa vị trí, hướng nắng và tầm nhìn; không phải bản vẽ thiết kế của chủ đầu tư.</p>

<!-- 6 -->
<h2 id="tien-ich">6. Hệ tiện ích "may đo" nghỉ dưỡng – sống gắn với biển mỗi ngày</h2>
<ul class="chk">
  <li><b>Bể bơi view biển</b> trong khu wellness, ngắm hoàng hôn từ mặt nước.</li>
  <li><b>Gym, yoga, pilates</b> tại khu Gym &amp; Yoga tầng 2 (Level 02).</li>
  <li><b>Nhà trẻ, shop khối đế</b> ngay trong tòa nhà – tiện cho gia đình và khách thuê.</li>
  <li><b>Thể thao biển</b>: kayak trên mặt nước phẳng, SUP đón bình minh, jetski.</li>
  <li><b>Tiện ích đô thị</b> quanh khu vực: trường học, siêu thị, bệnh viện.</li>
</ul>

<!-- 7 -->
<h2 id="mat-bang">7. Mặt bằng và các loại căn hộ Sun Saphia Residence</h2>
<p>Cơ cấu sản phẩm "nhỏ diện tích – lớn dư địa giá trị": căn diện tích gọn, vốn vào vừa sức, dễ ở và dễ cho thuê. Trần căn hộ cao 3,5 m, bàn giao hoàn thiện cơ bản.</p>
<table class="tb">
  <thead><tr><th>Loại căn</th><th>Diện tích</th><th>Số lượng</th><th>Bố trí</th><th>Phù hợp</th></tr></thead>
  <tbody>
    <tr><td><strong>Studio</strong></td><td>30–31 m²</td><td>513 căn</td><td>Logia, giường + sofa không gian mở, bếp chữ L, WC tách khu tắm</td><td>Cặp đôi, người trẻ, cho thuê theo đêm</td></tr>
    <tr><td><strong>1BR+</strong></td><td>50–51 m²</td><td>108 căn</td><td>1 phòng ngủ + phòng đa năng (có kiểu 2 phòng ngủ 1 vệ sinh)</td><td>Gia đình nhỏ, làm việc từ xa</td></tr>
    <tr><td><strong>2BR</strong></td><td>60–70 m²</td><td>133 căn</td><td>2 phòng ngủ, phòng khách, bếp</td><td>Gia đình, second home</td></tr>
  </tbody>
</table>
<div class="g4">
  <figure class="fig"><a href="{MB}mat-bang-studio.jpg" target="_blank" rel="noopener"><img src="{MB}mat-bang-studio.jpg" alt="Mặt bằng căn Studio Sun Saphia Residence" width="1000" height="1884" loading="lazy"></a><figcaption>Mặt bằng Studio.</figcaption></figure>
  <figure class="fig"><a href="{MB}mat-bang-1pn-plus.jpg" target="_blank" rel="noopener"><img src="{MB}mat-bang-1pn-plus.jpg" alt="Mặt bằng căn 1BR+ phòng đa năng Sun Saphia Residence" width="1000" height="1483" loading="lazy"></a><figcaption>Mặt bằng 1BR+ · phòng đa năng.</figcaption></figure>
  <figure class="fig"><a href="{MB}mat-bang-1pn-plus-2pn.jpg" target="_blank" rel="noopener"><img src="{MB}mat-bang-1pn-plus-2pn.jpg" alt="Mặt bằng căn 1BR+ dạng 2 phòng ngủ 1 vệ sinh Sun Saphia Residence" width="1000" height="1589" loading="lazy"></a><figcaption>Mặt bằng 1BR+ · 2 phòng ngủ 1 vệ sinh.</figcaption></figure>
</div>
<p class="small">Hình ảnh mặt bằng mang tính minh họa. Tổng 3 loại căn công bố là 754 căn; số căn còn lại trong tổng 782 căn và mặt bằng từng tầng theo công bố chính thức.</p>

<!-- 8 -->
<h2 id="phap-ly">8. Pháp lý, ngân hàng hỗ trợ và tiến độ</h2>
<div class="dn2">
  <div><i>📜</i><b>Giấy chứng nhận đăng ký đầu tư</b><span>Mã dự án 2572746483, cấp lần đầu ngày 17/09/2026.</span></div>
  <div><i>⏳</i><b>Thời hạn dự án 50 năm</b><span>Kể từ ngày 17/09/2026. Công trình cấp I, niên hạn sử dụng 100 năm.</span></div>
  <div><i>🏦</i><b>Vietcombank · BIDV · NCB</b><span>Ngân hàng hỗ trợ cho vay; tỷ lệ vay, ưu đãi lãi suất theo chính sách bán hàng.</span></div>
  <div><i>🔑</i><b>Bàn giao 11/2028</b><span>Hoàn thiện cơ bản; mốc chính xác ghi trong hợp đồng mua bán.</span></div>
</div>
<ul class="tl">
  <li><b>17/09/2026</b><span>Cấp Giấy chứng nhận đăng ký đầu tư.</span></li>
  <li><b>23/10/2026</b><span>Sự kiện Kick-off "Đón ánh dương – Giao hòa nhịp sống" tại KOI Resorts &amp; Residence Đà Nẵng.</span></li>
  <li><b>Cuối 11/2026</b><span>Dự kiến mở bán.</span></li>
  <li><b>2/2027</b><span>Dự kiến khởi công đường sắt đô thị sân bay – Hội An (giai đoạn 1).</span></li>
  <li><b>11/2028</b><span>Dự kiến bàn giao căn hộ.</span></li>
</ul>

<!-- 9 -->
<h2 id="gia-ban">9. Giá bán Sun Saphia Residence và so sánh căn hộ mặt biển Đà Nẵng</h2>
<p class="lead2">Biển là tài nguyên hữu hạn – căn hộ mặt biển Đà Nẵng có nguồn cung rất hữu hạn.</p>
<p>Đến 23/10/2026, <strong>chủ đầu tư chưa công bố giá bán chính thức</strong> của Sun Saphia Residence. Để có góc nhìn thị trường, giá chào bán một số dự án căn hộ ven biển Đà Nẵng (trình bày tại Kick-off):</p>
<table class="tb">
  <thead><tr><th>Dự án ven biển</th><th>Studio</th><th>1BR</th><th>2BR</th></tr></thead>
  <tbody>
    <tr><td>The Soleil Đà Nẵng</td><td>5,2–5,5 tỷ</td><td>7,7–7,8 tỷ</td><td>17,5 tỷ</td></tr>
    <tr><td>Futa Residence Đà Nẵng</td><td>9,1–10,5 tỷ</td><td>10,3–11,5 tỷ</td><td>17,4–17,6 tỷ</td></tr>
    <tr><td>Nobu Đà Nẵng</td><td>6,3–6,4 tỷ</td><td>10,5–10,6 tỷ</td><td>21,4–21,7 tỷ</td></tr>
    <tr><td>The Newtown Diamond</td><td>–</td><td>5,3–5,6 tỷ (1BR+)</td><td>6,8–8,3 tỷ</td></tr>
  </tbody>
</table>
<div class="box">
  <b>Nhận bảng giá chính thức ngay khi công bố</b>
  <p>Để lại số điện thoại – chuyên viên gửi bảng giá, chính sách thanh toán và bảng tính theo từng căn qua Zalo. Miễn phí, không ràng buộc.</p>
  <form class="hm-form inl" data-form="seo-gia-ban">
    <div><label for="ten3">Họ và tên</label><input id="ten3" name="name" type="text" placeholder="Anh/chị tên gì ạ?"></div>
    <div><label for="sdt3">Số điện thoại / Zalo</label><input id="sdt3" name="phone" type="tel" placeholder="09xx xxx xxx"></div>
    <button class="btn" type="submit">Nhận bảng giá</button>
  </form>
</div>

<!-- 10 -->
<h2 id="cho-thue">10. Tiềm năng cho thuê và dòng tiền</h2>
<p>Đà Nẵng là điểm hội tụ <strong>3 dòng di dân cơ học</strong> – nguồn cầu thuê nhà thực tế và bền vững:</p>
<div class="dn2">
  <div><i>🌏</i><b>6,88 triệu lượt khách quốc tế</b><span>8 tháng đầu 2026, tăng 26,3%. Chuyên gia, giáo viên ngoại ngữ, KOL ở lại làm việc dài hạn.</span></div>
  <div><i>🧳</i><b>15–16 nghìn người nhập cư mỗi năm</b><span>Cư dân Hà Nội, TP.HCM "đổi phố lấy biển", người về hưu, lao động trẻ miền Trung.</span></div>
  <div><i>🗺️</i><b>Quy mô dân số mới ~3 triệu</b><span>Sau sáp nhập Quảng Nam (từ 1/7/2025); doanh nghiệp, cán bộ chuyển về trung tâm hành chính mới.</span></div>
  <div><i>🏨</i><b>Khách sạn Sun Group miền Trung lấp đầy 81,3%</b><span>Năm 2026, tăng từ 70,65% năm 2025 – cao nhất cả nước.</span></div>
</div>
<table class="tb">
  <caption>Giá thuê căn hộ view biển theo đêm hiện tại (ngoài mùa cao điểm)</caption>
  <thead><tr><th>Loại căn</th><th>Giá thuê trung bình</th></tr></thead>
  <tbody>
    <tr><td>Studio view biển</td><td>2,2–2,9 triệu/đêm</td></tr>
    <tr><td>1BR+ view biển</td><td>3,4–3,7 triệu/đêm</td></tr>
  </tbody>
</table>
<table class="tb">
  <caption>Bài toán vận hành cho thuê (minh họa tại Kick-off)</caption>
  <thead><tr><th></th><th>Studio view biển</th><th>1BR view biển</th></tr></thead>
  <tbody>
    <tr><td>Diện tích · giá giả định</td><td>30 m² · 3 tỷ</td><td>50 m² · 4,5 tỷ</td></tr>
    <tr><td>Giá thuê · lấp đầy</td><td>2,5 tr/đêm · 60%</td><td>3,5 tr/đêm · 60%</td></tr>
    <tr><td>Doanh thu</td><td>540 triệu/năm</td><td>756 triệu/năm</td></tr>
    <tr><td>Lợi nhuận (65%)</td><td>351 triệu/năm (~29,3 tr/tháng)</td><td>492 triệu/năm (~41 tr/tháng)</td></tr>
    <tr><td>Tỷ lệ</td><td>11,7%/năm</td><td>10,9%/năm</td></tr>
  </tbody>
</table>
<p class="small">Giá giả định dùng để tính, chưa phải giá bán chính thức. Kết quả thực tế phụ thuộc giá mua, mùa vụ, cách vận hành; không phải cam kết lợi nhuận. Nguồn số liệu di dân: Cục Thống kê &amp; Sở VH-TT-DL TP Đà Nẵng (8 tháng 2026), Nghị quyết 202/2025/QH15.</p>
<p>Ba nhóm khách thuê chính: <strong>nhân sự chuỗi resort ven biển</strong> (thuê trung hạn, ổn định), <strong>khách thuê ngắn ngày kiểu Airbnb</strong> (lấp đầy cao, thương hiệu Sun Group giúp căn dễ cho thuê hơn) và <strong>khách du lịch</strong> luôn ưu tiên căn hộ mặt biển.</p>

<!-- 11 -->
<h2 id="phu-hop">11. Sun Saphia Residence phù hợp với ai?</h2>
<ul class="chk">
  <li><b>Khách hàng trẻ tự do</b> – "Làm việc từ đâu cũng được, thì sao không từ Đà Nẵng, cạnh biển?" Căn Studio, 1BR+ nhỏ gọn; bãi biển cho SUP, kayak; cho thuê bù chi phí.</li>
  <li><b>Người thành đạt</b> – second home cho cả gia đình, sản phẩm của Sun Group, tòa 30 tầng, tầm nhìn sông – núi – biển.</li>
  <li><b>Người nghỉ dưỡng sớm</b> – "Anh chị đã làm đủ lâu rồi, giờ là lúc biển làm việc của biển." Biển trước nhà, chuỗi bãi tắm, tiện ích đủ đầy.</li>
  <li><b>Nhà đầu tư cho thuê</b> – căn diện tích gọn, nguồn khách từ 3 dòng di dân và chuỗi resort ven biển.</li>
</ul>
<p>Bốn giá trị dự án hướng tới: <strong>Sức khỏe</strong> (biển, gió, không gian sống xanh) · <strong>Tinh thần</strong> (tự do, thư thái, về với thiên nhiên) · <strong>Tiện nghi</strong> (trường học, siêu thị, bệnh viện) · <strong>Đầu tư</strong> (cho thuê tốt, thương hiệu Sun Group).</p>

<!-- 12 -->
<h2 id="hoi-dap">12. Câu hỏi thường gặp về Sun Saphia Residence</h2>
<div class="faq">
{faq_html}
</div>

<p>Xem thêm: <a href="https://www.sun-saphia-residence.com/ads">Sun Saphia Residence – bảng giá, mặt bằng, tính dòng tiền</a> · <a href="https://hiephoangmt.com/du-an/sun-saphia-residence/" target="_blank" rel="noopener">phân tích tại hiephoangmt.com</a>.</p>
</div>
</article>'''

a = s.index('<article>'); b = s.index('</article>') + len('</article>')
s = s[:a] + ART + s[b:]
s = re.sub(r'<title>[^<]*</title>', f'<title>{TITLE}</title>', s, 1)
s = re.sub(r'<meta name="description" content="[^"]*">', f'<meta name="description" content="{DESC}">', s, 1)
s = re.sub(r'<meta property="og:title" content="[^"]*">', f'<meta property="og:title" content="{TITLE}">', s, 1)
s = re.sub(r'<meta property="og:description" content="[^"]*">', f'<meta property="og:description" content="{DESC}">', s, 1)
s = re.sub(r'<meta name="keywords" content="[^"]*">', '<meta name="keywords" content="sun saphia residence, sun saphia đà nẵng, căn hộ sun saphia, giá sun saphia residence, mặt bằng sun saphia, pháp lý sun saphia, căn hộ mặt biển đà nẵng, căn hộ sun group đà nẵng, căn hộ trường sa, căn hộ ngũ hành sơn, studio view biển đà nẵng">', s, 1)
i = s.index('<script type="application/ld+json">'); j = s.index('</script>', i)
s = s[:i] + '<script type="application/ld+json">' + json.dumps(LD, ensure_ascii=False) + s[j:]
open(F, 'w', encoding='utf8').write(s)
print('ok', len(TITLE), len(DESC), len(s))
