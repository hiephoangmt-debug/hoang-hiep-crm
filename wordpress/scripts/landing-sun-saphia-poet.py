"""Dựng lại trang Sun Saphia Residence theo mẫu The Poet (06/11/2026, anh Hiệp yêu cầu "viết lại theo mẫu Poet").
Giữ đủ nội dung trang cũ (lấy từ landing v4 đã viết lại chữ), CSS = CSS trang The Poet; 4D + chọn căn vẫn dùng bộ nhúng cũ.
Dùng: python3 landing-sun-saphia-poet.py  (ghi đè themes/hoanghiep/landing/sun-saphia-residence.html)
"""
import os, re
T = os.path.join(os.path.dirname(__file__), '..', 'wp-content', 'themes', 'hoanghiep')
poet = open(os.path.join(T, 'landing', 'the-poet-residence-da-nang.html'), encoding='utf-8').read()
head = poet[:poet.index('<!--HH-LANDING-BODY-->')]
extra = open(os.path.join(T, 'assets', 'css', 'landing-mau.css'), encoding='utf-8').read().split('/* Phần thêm cho mẫu tự động */', 1)[1]
head = head.replace('/* Landing The Poet Residence – tông xanh đêm + vàng đồng theo nhận diện dự án. */', '/* Landing Sun Saphia Residence – dựng theo mẫu The Poet (06/11/2026). */').replace('</style>', '/* Thêm */' + extra + '''
.stat3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:22px}
.stat3 div{background:#fff;border:1px solid var(--line);border-radius:var(--r);padding:18px}
.stat3 b{display:block;font-family:'Playfair Display',serif;font-size:28px;color:var(--gold)}
.stat3 span{font-size:14px;color:var(--muted)}
.dark .stat3 div{background:var(--navy2);border-color:rgba(255,255,255,.08)}.dark .stat3 span{color:rgba(255,255,255,.75)}
.dark .tbl td{color:var(--ink)}
.dark .tbl td:first-child{font-weight:600}
.more{display:inline-block;margin-top:14px;font-weight:600;color:var(--gold);text-decoration:none}
.dark .more{color:var(--gold2)}
.day{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-top:18px}
.day div{background:#fff;border:1px solid var(--line);border-radius:14px;padding:14px 16px;font-size:14px}
.day b{display:block;color:var(--gold);font-size:13px;letter-spacing:.06em}
@media (max-width:980px){.stat3,.day{grid-template-columns:1fr 1fr}}
@media (max-width:600px){.stat3,.day{grid-template-columns:1fr}}
</style>''', 1)

G = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/'
SK = G + 'cd20c0301cdcc17d5fbb47dd9797b6c2abb8c9be/projects/sun-saphia/sk2310/'
V4 = lambda c, f: G + c + '/landing/sun-saphia/v4/img/' + f
P = '{{HH_CRM_URL}}img/sun-saphia/'
IMG = {
    'bia': V4('cf6083d846b6a2282f9f7a26e40607819b2cee3d', 'anh-bia-kickoff.webp'),
    'binhminh': V4('cf6083d846b6a2282f9f7a26e40607819b2cee3d', 'phoi-canh-binh-minh.webp'),
    'hoanghon': V4('3c076ddb411cdc4df18a30f1fd09bd98b60ff86a', 'thap-bien-hoang-hon-2.webp'),
    'thapcat': SK + 'thap-cat-3.webp',
    'sodovitri': V4('7f7a743766755fec9902ed74af5562cdfdd7f1d8', 'so-do-vi-tri.webp'),
    'sodongang': V4('7f7a743766755fec9902ed74af5562cdfdd7f1d8', 'so-do-vi-tri-ngang.webp'),
    'quyhoach': V4('68c1e86b7ea36c01f79e9e0a49b668d2cf9f2498', 'so-do-quy-hoach.webp'),
    'cv': V4('21d0fab0bf193ae2747bd437d255b77abc204126', 'mini-cv.webp'),
    'ga': V4('21d0fab0bf193ae2747bd437d255b77abc204126', 'mini-ga.webp'),
    'nhs': V4('21d0fab0bf193ae2747bd437d255b77abc204126', 'mini-nhs.webp'),
    'tb': V4('21d0fab0bf193ae2747bd437d255b77abc204126', 'mini-tb.webp'),
    'snb': SK + 'song-nui-bien-art.webp',
    'bien': V4('fc04110b48e042d4acb3890ea1d46686aea154f0', 'hero-bien.webp'),
    'nui': SK + 'view-nui-ngu-hanh-son.webp',
    'song': SK + 'view-song-han.webp',
    'dem': V4('fc04110b48e042d4acb3890ea1d46686aea154f0', 'bien-dem-ban-cong.webp'),
    'apsara': SK + 'apsara-art.webp',
    'hoboi': V4('a0a6849c15880dc681b6e91708d2a0752bd2aa43', 'ho-boi-tang-3.webp'),
    'gym': SK + 'tien-ich-gym.webp',
    'shop': V4('7a03668bc5f37f2d88ff71cb75c89278cfd633fc', 'khoi-de-shop.webp'),
    'kickoff': V4('7a03668bc5f37f2d88ff71cb75c89278cfd633fc', 'phoi-canh-kickoff.webp'),
    'giadinh': V4('fc04110b48e042d4acb3890ea1d46686aea154f0', 'gia-dinh-ban-cong.webp'),
    'ongba': V4('fc04110b48e042d4acb3890ea1d46686aea154f0', 'ong-ba-ban-cong.webp'),
    'resort': SK + 'thap-dem-resort.webp',
    'trencao': SK + 'thap-tren-cao-ngay.webp',
    'tongthe': SK + 'mat-bang-tong-the.webp',
}

def card(src, alt, cap='', style=''):
    return f'<a class="card-img" href="{src}"{style}><img src="{src}" alt="{alt}" loading="lazy" decoding="async">' + (f'<span>{cap}</span>' if cap else '') + '</a>'

floors = [
    ('tang-2', 'Tầng 2', 'Tầng 2 – tầng tiện ích: bể bơi, khu gym & yoga, kèm 12 căn studio, 1PN+ và 2PN'),
    ('tang-3', 'Tầng 3', 'Tầng 3 – 28 căn, nhìn xuống khu vườn trên mái khối đế'),
    ('tang-3a-28-dien-tich', 'Tầng 3A–28', 'Tầng 3A–28 – tầng điển hình, 28 căn mỗi tầng: 19 studio, 4 căn 1PN+, 5 căn 2PN'),
    ('tang-29', 'Tầng 29', 'Tầng 29 – 26 căn, có vườn trên cao'),
    ('tang-30', 'Tầng 30', 'Tầng 30 – tầng trên cùng, 19 căn 1PN, 1PN+ và 2PN diện tích lớn'),
]
first = 2
tabs = ''.join(f'<button class="tab{" on" if i == first else ""}" type="button" data-floor="mb-{k}">{n}</button>' for i, (k, n, c) in enumerate(floors))
panes = ''.join(f'<div class="floor{" on" if i == first else ""}" id="mb-{k}"><a class="plan" href="{P}sun-saphia-mat-bang-{k}.jpg"><img src="{P}sun-saphia-mat-bang-{k}.jpg" alt="Mặt bằng {n.lower()} Sun Saphia Residence" loading="lazy" decoding="async"></a><p class="plan-cap">{c}. Bấm để phóng to.</p></div>' for i, (k, n, c) in enumerate(floors))

body = f'''<!--HH-LANDING-BODY-->
<header class="top">
  <div class="container">
    <a class="brand" href="#top"><b>SUN SAPHIA</b><small>Residence · Đà Nẵng</small></a>
    <nav class="nav" aria-label="Mục lục">
      <a href="#tong-quan">Tổng quan</a><a href="#vi-tri">Vị trí</a><a href="#tien-ich">Tiện ích</a><a href="#loai-can">Mặt bằng</a><a href="#chon-can">Chọn căn 4D</a><a href="#bang-gia">Giá</a><a href="#phap-ly">Pháp lý</a><a href="#cho-thue">Cho thuê</a><a href="#hoi-dap">Hỏi đáp</a>
    </nav>
    <a class="btn btn-gold" href="#dang-ky">Nhận bảng giá</a>
  </div>
</header>

<main id="top">
<!-- HERO -->
<figure class="hero-view">
  <img src="{P}sun-saphia-phoi-canh-hoang-hon-toan-canh.jpg" width="1800" height="996" alt="Sun Saphia Residence – tòa tháp 30 tầng của Sun Group bên biển Sơn Thủy lúc hoàng hôn, phối cảnh chủ đầu tư" fetchpriority="high" decoding="async">
  <figcaption>Sun Saphia Residence · biển Sơn Thủy lúc hoàng hôn · phối cảnh chủ đầu tư</figcaption>
</figure>
<section class="hero" aria-labelledby="h1">
  <div class="container">
    <div>
      <span class="badge-ok">🔥 Sự kiện bán hàng chủ đầu tư 05/12/2026 tại Đà Nẵng</span>
      <h1 id="h1">Sun Saphia <em>Residence</em></h1>
      <p class="sub">Dự án căn hộ mặt biển đầu tiên Sun Group làm tại Đà Nẵng – phía trước Biển, phía sau Sông, kề bên Núi. Một tòa tháp 30 tầng (114 m) với 782 căn Studio, 1BR+, 2BR, trần cao 3,5 m, trên cung đường Võ Nguyên Giáp – Trường Sa; Vietcombank, BIDV, NCB hỗ trợ vay.</p>
      <div class="chips">
        <div class="chip"><b>30 tầng</b><span>114 m · 2 hầm</span></div>
        <div class="chip"><b>782 căn</b><span>Studio · 1BR+ · 2BR</span></div>
        <div class="chip"><b>~400 m</b><span>ra bãi tắm Sơn Thủy</span></div>
        <div class="chip"><b>50 năm</b><span>thời hạn dự án</span></div>
      </div>
      <div class="acts">
        <a class="btn btn-gold" href="#dang-ky">Nhận bảng giá khi công bố</a>
        <a class="btn btn-ghost js-zalo" href="https://zalo.me/0904567009" target="_blank" rel="noopener">Zalo 0904 567 009</a>
      </div>
    </div>
    <figure class="hero-img" style="margin:0">
      <img src="{IMG['binhminh']}" alt="Sun Saphia Residence trong nắng sớm – phối cảnh minh họa" decoding="async">
      <figcaption>Tòa tháp trong nắng sớm · phối cảnh minh họa</figcaption>
    </figure>
  </div>
</section>

<!-- TỔNG QUAN -->
<section id="tong-quan" aria-labelledby="h-tq">
  <div class="container">
    <div class="split">
      <div class="rv">
        <span class="eyebrow">Tổng quan dự án</span>
        <h2 class="title" id="h-tq">Căn hộ mặt biển <em>đầu tiên</em> của Sun Group tại Đà Nẵng</h2>
        <p class="lead">Sun Property – thành viên Tập đoàn Sun Group – phát triển dự án tại giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Saphia, phường Ngũ Hành Sơn. Tòa tháp 30 tầng – 114 m, 2 tầng hầm trên khu đất 3.720,1 m², căn hộ từ tầng 3A đến tầng 28, bàn giao hoàn thiện cơ bản.</p>
        <p class="note">Thông tin theo tài liệu Kick-off 23/10/2026 của chủ đầu tư; giá bán, chính sách căn cứ công bố chính thức. <a href="/du-an-can-ho-sun-group-da-nang-2026/" style="color:var(--gold)">Lý do Sun Group chọn Đà Nẵng cho căn hộ mặt biển đầu tiên →</a></p>
      </div>
      <img class="rv" src="{IMG['thapcat']}" alt="Phối cảnh tòa tháp Sun Saphia Residence 30 tầng – 114 m" loading="lazy" decoding="async">
    </div>
    <div class="facts rv">
      <div class="fact"><small>Đơn vị phát triển</small><b>Sun Property – Sun Group</b></div>
      <div class="fact"><small>Vị trí</small><b>Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa</b></div>
      <div class="fact"><small>Quy mô</small><b>1 tòa · 30 tầng · 782 căn</b></div>
      <div class="fact"><small>Cơ cấu</small><b>Studio 513 · 1BR+ 108 · 2BR 133</b></div>
      <div class="fact"><small>Trần cao</small><b>3,5 m · hoàn thiện cơ bản</b></div>
      <div class="fact"><small>Pháp lý</small><b>50 năm · công trình cấp I, niên hạn 100 năm</b></div>
      <div class="fact"><small>Ngân hàng</small><b>Vietcombank · BIDV · NCB</b></div>
      <div class="fact"><small>Mở bán · bàn giao</small><b>Sự kiện bán hàng 05/12/2026 · bàn giao 11/2028</b></div>
    </div>
  </div>
</section>

<!-- THỜI ĐIỂM -->
<section id="thoi-diem" style="background:#fff" aria-labelledby="h-td">
  <div class="container">
    <span class="eyebrow">Thời điểm</span>
    <h2 class="title" id="h-td">Thời của bất động sản <em>dòng tiền – giá trị thực</em></h2>
    <div class="pays">
      <div class="pay rv"><h3>Lãi suất giảm rõ</h3><ul><li>15/10/2026: thông điệp "lãi suất ngân hàng phải giảm xuống"</li><li>19/10/2026: Ngân hàng Nhà nước họp các ngân hàng thương mại – 2 công văn trong 4 ngày</li><li>Agribank, Vietcombank, BIDV, MB, ACB… cùng giảm lãi vay (báo chí 10/2026)</li></ul></div>
      <div class="pay rv"><h3>Tách dư nợ nghỉ dưỡng</h3><ul><li>Dư nợ khách sạn, khu nghỉ dưỡng không còn gộp vào dư nợ bất động sản</li><li>Tín dụng cho vay phù hợp hơn, thị trường bền vững hơn</li><li>Đà Nẵng hưởng lợi trực tiếp</li></ul></div>
      <div class="pay rv"><h3>Du lịch nghỉ dưỡng tăng dài hạn</h3><ul><li>Chi tiêu nhóm trên 60 tuổi toàn cầu dự báo 34 nghìn tỷ USD năm 2036 (19 nghìn tỷ năm 2024)</li><li>Du lịch nghỉ dưỡng – sức khỏe: 525 tỷ USD (2025) → 910 tỷ USD (2030)</li><li>Nguồn ước tính theo tài liệu Kick-off: WEF, McKinsey, World Data Lab</li></ul></div>
      <div class="pay rv"><h3>Chính sách tạo đà</h3><ul><li>NQ 08/2017: du lịch là ngành kinh tế mũi nhọn; NQ 26: Đà Nẵng thuộc 3 cực tăng trưởng du lịch</li><li>Mục tiêu 2030: 45–50 triệu lượt khách quốc tế, 80–90 tỷ USD doanh thu du lịch</li><li>Đề xuất thuế 0,2% với đất bỏ hoang, chậm sử dụng</li></ul></div>
    </div>
    <div class="loan rv">
      <div><b>15,86 triệu</b><span>lượt khách du lịch Đà Nẵng 9 tháng 2026 (+29,6%)</span></div>
      <div><b>7,69 triệu</b><span>lượt khách quốc tế (+28,9%)</span></div>
      <div><b>52.945 tỷ</b><span>doanh thu du lịch (+26,2%)</span></div>
      <div><b>NQ 278/NQ-CP</b><span>18/9/2026: thời hạn chung cư theo niên hạn công trình</span></div>
    </div>
    <div class="legal-box rv" style="margin-top:22px"><b>Nghị quyết 278/NQ-CP (18/9/2026)</b><br>Thời hạn sử dụng chung cư xác định theo niên hạn công trình và hồ sơ thiết kế; quy định rõ quyền, nghĩa vụ các bên khi chung cư hết thời hạn; phân định quyền sở hữu căn hộ với quyền sử dụng đất. Ý nghĩa: căn hộ 50 năm đang được nhìn nhận lại về giá trị, khoảng cách với căn hộ sở hữu lâu dài hẹp dần.</div>
    <h3 style="font-family:'Playfair Display',serif;font-size:26px;margin:34px 0 0;color:var(--navy)">Vì sao nên vào <em style="color:var(--gold)">đợt đầu</em></h3>
    <div class="pays">
      <div class="pay rv"><span class="tag">01</span><h3>Giá & chính sách tốt nhất</h3><ul><li>Giai đoạn đầu luôn được chủ đầu tư dành chính sách giá và bán hàng tốt nhất</li></ul></div>
      <div class="pay hot rv"><span class="tag">02</span><h3>Chọn căn đẹp nhất</h3><ul><li>Vị trí mặt biển trung tâm, số lượng hữu hạn – căn đẹp chỉ có ở đợt đầu</li></ul></div>
      <div class="pay rv"><span class="tag">03</span><h3>Hỗ trợ lãi suất đến 24 tháng</h3><ul><li>Chính sách đợt giới thiệu; đến lúc bàn giao cuối 2028 – đầu 2029 lãi suất được kỳ vọng đã giảm</li></ul></div>
      <div class="pay rv"><span class="tag">04</span><h3>Dòng tiền tìm đến trước</h3><ul><li>Khi thị trường đảo chiều, sản phẩm trung tâm, khan hiếm, có dòng tiền tốt thường được tìm đến đầu tiên</li></ul></div>
    </div>
    <p class="note">Giá trong quá khứ không bảo đảm cho diễn biến tương lai; mức giá và hỗ trợ lãi suất cụ thể theo công bố chính thức của chủ đầu tư lúc mở bán.</p>
  </div>
</section>

<!-- VỊ TRÍ -->
<section class="dark" id="vi-tri" aria-labelledby="h-vt">
  <div class="container">
    <span class="eyebrow">Vị trí</span>
    <h2 class="title" id="h-vt">Trung điểm <em>hệ di sản</em> Đà Nẵng</h2>
    <p class="lead">Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa: khúc chuyển từ đại lộ ven biển sang "cung đường tỷ đô" của dải resort Đà Nẵng – Hội An. Một hướng là trung tâm thành phố và bán đảo Sơn Trà, hướng kia là Ngũ Hành Sơn rồi phố cổ Hội An; phía trước là biển Mỹ Khê – Sơn Thủy.</p>
    <div class="times rv">
      <div class="time"><b>~400 <small>m</small></b><ul><li>Bãi tắm Sơn Thủy (băng qua công viên ven biển)</li><li>Ga LRT 09 ~500 m (tuyến sân bay – Hội An theo quy hoạch)</li></ul></div>
      <div class="time"><b>5 – 10 <small>phút</small></b><ul><li>Danh thắng Ngũ Hành Sơn</li><li>Phố An Thượng</li></ul></div>
      <div class="time"><b>10 – 15 <small>phút</small></b><ul><li>Sân bay quốc tế Đà Nẵng</li><li>Tổ hợp Galaxy, Đà Nẵng Downtown (~4 km)</li></ul></div>
      <div class="time"><b>~30 <small>phút</small></b><ul><li>Phố cổ Hội An</li></ul></div>
    </div>
    <p class="note" style="color:rgba(255,255,255,.6)">Khoảng cách theo tài liệu Kick-off; thời gian ước tính khi đi ô tô.</p>
    <div class="vband rv">
      {card(IMG['sodovitri'], 'Sơ đồ vị trí Sun Saphia Residence', 'Sơ đồ vị trí – minh họa, không đúng tỷ lệ')}
      {card(IMG['quyhoach'], 'Sơ đồ 4 quy hoạch quanh Sun Saphia Residence', '4 quy hoạch bao quanh dự án')}
    </div>
    <div class="views rv">
      <div class="view"><b>Ngay trước mặt – công viên 2,45 ha</b><br>QĐ 2958/QĐ-UBND duyệt dự án công viên công cộng trên khu đất thu hồi khoảng 2,45 ha, vốn ngân sách hơn 47 tỷ đồng, làm giai đoạn 2025–2027 – không bị công trình chắn view.</div>
      <div class="view"><b>Mặt tiền – mở rộng trục biển 2.633 tỷ</b><br>Đà Nẵng quyết định mở rộng Võ Nguyên Giáp, Trường Sa, Lạc Long Quân, tổng mức đầu tư dự kiến 2.633 tỷ đồng.</div>
      <div class="view"><b>~500 m – ga đường sắt đô thị</b><br>Tuyến sân bay – Hội An, giai đoạn 1 đề xuất khởi công 2/2027: thuận tiện đi lại, mở cơ hội thương mại, cho thuê.</div>
      <div class="view"><b>~2,5 km – công viên Ngũ Hành Sơn 92 ha</b><br>Du lịch tâm linh với vườn thiền, bảo tháp 58 m. Khu thương mại tự do Đà Nẵng (QĐ 1142/QĐ-TTg, 6/2025) thu hút thêm chuyên gia, doanh nghiệp.</div>
    </div>
    <p class="note" style="color:rgba(255,255,255,.6)">Công viên công cộng nằm trên phần đất thu hồi của dự án Hòn Ngọc Á Châu bỏ dở từ 2010; phương án Công viên, CLB thể thao biển và bãi tắm Sơn Thủy duyệt tại QĐ 130 (20/3/2025): khoảng 3 ha, mật độ xây dựng khoảng 3,9%. Nguồn: VietnamPlus, Báo Pháp luật, VnEconomy, tài liệu Kick-off. <a class="more" href="/du-an/sun-saphia-residence/quy-hoach/">Bản vẽ công viên & 4 quy hoạch xung quanh →</a></p>
    <div class="locmap rv">
      <iframe title="Bản đồ vị trí Sun Saphia Residence – Võ Nguyên Giáp, Trường Sa, Ngũ Hành Sơn, Đà Nẵng" src="https://www.google.com/maps?q=V%C3%B5+Nguy%C3%AAn+Gi%C3%A1p+Nguy%E1%BB%85n+%C4%90%E1%BB%A9c+Thu%E1%BA%ADn+Tr%C6%B0%E1%BB%9Dng+Sa+%C4%90%C3%A0+N%E1%BA%B5ng&z=16&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <div class="adj">
        <h3>Khu Saphia, phường Ngũ Hành Sơn</h3>
        <ul><li><b>Phía trước:</b> công viên 2,45 ha, bãi tắm Sơn Thủy – Mỹ Khê</li><li><b>Mặt tiền:</b> trục biển Võ Nguyên Giáp – Trường Sa</li><li><b>Phía sau:</b> sông Hàn và trung tâm thành phố</li><li><b>Bên cạnh:</b> danh thắng Ngũ Hành Sơn</li></ul>
        <a href="https://www.google.com/maps/dir/?api=1&destination=V%C3%B5+Nguy%C3%AAn+Gi%C3%A1p+Nguy%E1%BB%85n+%C4%90%E1%BB%A9c+Thu%E1%BA%ADn+%C4%90%C3%A0+N%E1%BA%B5ng" target="_blank" rel="noopener">📍 Chỉ đường tới dự án ↗</a>
        <p style="margin:12px 0 0;font-size:14px;opacity:.85">Muốn xem tận nơi? Hiệp gọi video Zalo dẫn anh/chị đi từ dự án ra biển – miễn phí.</p>
      </div>
    </div>
  </div>
</section>

<!-- TẦM NHÌN -->
<section id="tam-nhin" aria-labelledby="h-tn">
  <div class="container">
    <div class="split">
      <div class="rv">
        <span class="eyebrow">Tầm nhìn</span>
        <h2 class="title" id="h-tn">Sông, Núi, Biển <em>chung một tầm nhìn</em></h2>
        <p class="lead">Từ tầng cao, cảnh sắc trải ra nhiều lớp: dòng sông uốn lượn, dáng núi Ngũ Hành Sơn và mặt biển Mỹ Khê xanh mênh mông, gói gọn trong một khung nhìn rộng mở. Trước mặt là Biển, sau lưng là Sông, bên cạnh là Núi.</p>
      </div>
      <img class="rv" src="{IMG['snb']}" alt="Sông – Núi – Biển quanh Sun Saphia Residence" loading="lazy" decoding="async">
    </div>
    <div class="units" style="margin-top:26px">
      <article class="unit rv"><a class="pic" href="{IMG['bien']}"><img src="{IMG['bien']}" alt="Hướng biển Mỹ Khê – Sơn Thủy" loading="lazy" decoding="async"></a><div class="body"><h3>Hướng Biển</h3><p class="note" style="margin:0">Biển Mỹ Khê – Sơn Thủy ngay phía trước, mở ban công là thấy.</p></div></article>
      <article class="unit rv"><a class="pic" href="{IMG['nui']}"><img src="{IMG['nui']}" alt="Hướng núi Ngũ Hành Sơn" loading="lazy" decoding="async"></a><div class="body"><h3>Hướng Núi Ngũ Hành Sơn</h3><p class="note" style="margin:0">Biểu tượng Đà Nẵng hiện ra trước cửa sổ mỗi ngày.</p></div></article>
      <article class="unit rv"><a class="pic" href="{IMG['song']}"><img src="{IMG['song']}" alt="Hướng sông Hàn lúc hoàng hôn" loading="lazy" decoding="async"></a><div class="body"><h3>Hướng Sông Hàn · Đô thị</h3><p class="note" style="margin:0">Hoàng hôn trên sông Hàn mỗi chiều; đêm xuống phố phường lên đèn, tiếng ồn ở xa.</p></div></article>
    </div>
  </div>
</section>

<!-- THIẾT KẾ -->
<section id="thiet-ke" style="background:#fff" aria-labelledby="h-tk">
  <div class="container">
    <div class="split">
      <img class="rv" src="{IMG['apsara']}" alt="Cảm hứng Apsara trong kiến trúc Sun Saphia Residence" loading="lazy" decoding="async">
      <div class="rv">
        <span class="eyebrow">Cảm hứng thiết kế</span>
        <h2 class="title" id="h-tk">Vũ điệu Di sản – <em>dấu ấn Apsara</em></h2>
        <p class="lead">Kiến trúc mượn cảm hứng từ điêu khắc Chăm Pa và vũ nữ Apsara, thể hiện lại bằng ngôn ngữ đương đại: khối tháp thẳng, mặt dài quay ra biển, mặt đứng kính xanh nhạt điểm ban công và trụ màu đồng – biểu tượng mới của Sun Group bên biển Đà Nẵng.</p>
      </div>
    </div>
    <a class="card-img rv" style="aspect-ratio:21/9;margin-top:26px" href="{IMG['hoanghon']}"><img src="{IMG['hoanghon']}" alt="Sun Saphia Residence 30 tầng bên biển lúc hoàng hôn" loading="lazy" decoding="async"><span>30 tầng – 114 m bên biển Mỹ Khê · phối cảnh minh họa</span></a>
  </div>
</section>

<!-- TIỆN ÍCH -->
<section id="tien-ich" aria-labelledby="h-ti">
  <div class="container">
    <span class="eyebrow">Tiện ích</span>
    <h2 class="title" id="h-ti">Tiện ích nghỉ dưỡng <em>"may đo"</em></h2>
    <div class="tabs" role="tablist">
      <button class="tab on" type="button" data-floor="ti-1">Wellness · Healthy</button>
      <button class="tab" type="button" data-floor="ti-2">Khối đế thương mại</button>
      <button class="tab" type="button" data-floor="ti-3">Chuỗi bãi tắm</button>
    </div>
    <div class="floor on" id="ti-1">
      <p>Hồ bơi view biển ở tầng 3, phòng yoga ngắm hoàng hôn; khu Gym & Yoga có gym, pilates; nhà trẻ và shop khối đế ngay trong tòa. Trước cửa là kayak, SUP, dù lượn, jetski.</p>
      <div class="vband" style="margin-top:0">{card(IMG['hoboi'], 'Hồ bơi tầng 3 Sun Saphia Residence', 'Hồ bơi view biển tầng 3')}{card(IMG['gym'], 'Khu gym & yoga Sun Saphia Residence', 'Gym · Yoga · Pilates')}</div>
    </div>
    <div class="floor" id="ti-2">
      <p>Khối đế mặt tiền Võ Nguyên Giáp – phố biển nhộn nhịp ngay dưới chân nhà.</p>
      <div class="vband" style="margin-top:0">{card(IMG['shop'], 'Khối đế thương mại Sun Saphia Residence', 'Shop, café, nhà hàng hướng ra trục biển')}{card(IMG['kickoff'], 'Tòa tháp Sun Saphia trong nắng sớm', 'Phối cảnh trích thư mời Kick-off 23/10/2026')}</div>
      <ul class="list-ok" style="margin-top:18px"><li><b>Mua sắm:</b> tiện ích thiết yếu, cửa hàng ngay trong tòa</li><li><b>Ẩm thực:</b> café, nhà hàng ngắm trục biển</li><li><b>Dòng khách:</b> trục Võ Nguyên Giáp – Trường Sa đông khách du lịch nhất</li><li><b>Cho thuê:</b> ăn uống, mua sắm dưới chân nhà – điểm cộng với khách thuê</li></ul>
    </div>
    <div class="floor" id="ti-3">
      <p>Bãi biển nằm ngay trước "thềm nhà", đi kèm chuỗi 3 công viên bãi tắm: Sơn Thủy (sát khu Saphia), công viên bãi tắm đối diện dự án, và công viên bãi tắm Huyền Trân Công Chúa gần Ngũ Hành Sơn.</p>
      {card(IMG['sodongang'], 'Từ Sun Saphia ra bãi tắm Sơn Thủy khoảng 400 m', 'Từ dự án ra bãi tắm Sơn Thủy ~400 m · minh họa', ' style="aspect-ratio:21/9"')}
      <div class="day"><div><b>5:30</b>Đón bình minh trên biển từ ban công hướng Đông</div><div><b>6:00</b>Đi bộ ~400 m xuyên công viên ra bãi Sơn Thủy</div><div><b>17:00</b>Tắm biển cát trắng, sóng êm – mùa hè 6–7 tháng</div><div><b>19:00</b>Ngắm thành phố lên đèn, sông Hàn, Ngũ Hành Sơn</div></div>
    </div>
    <p class="note">Hình ảnh tiện ích và thể thao biển mang tính minh họa.</p>
  </div>
</section>

<!-- MẶT BẰNG & LOẠI CĂN -->
<section id="loai-can" style="background:#fff" aria-labelledby="h-lc">
  <div class="container">
    <span class="eyebrow">Mặt bằng & loại căn</span>
    <h2 class="title" id="h-lc">Diện tích nhỏ – <em>lớn dư địa giá trị</em></h2>
    <p class="lead">Căn gọn nên vốn ban đầu vừa sức, ở tiện mà cho thuê cũng dễ. Trần cao 3,5 m, bàn giao hoàn thiện cơ bản; mặt bằng tầng tối ưu view biển Mỹ Khê. Bấm ảnh để xem lớn.</p>
    <div class="units">
      <article class="unit rv"><a class="pic" href="{P}sun-saphia-layout-can-studio.jpg"><img src="{P}sun-saphia-layout-can-studio.jpg" alt="Layout căn Studio Sun Saphia Residence" loading="lazy" decoding="async"></a><div class="body"><h3>Studio · 30–31 m²</h3><div class="meta"><span>513 căn</span><span>3,8 × 9 m</span></div><p class="note" style="margin:0">Logia, giường + sofa không gian mở, bếp chữ L, WC tách khu tắm. Hợp người trẻ, cặp đôi, cho thuê theo đêm.</p><div class="price">Từ khoảng 2,13 tỷ (giá dự kiến)</div><a class="btn btn-navy" href="#dang-ky" data-type="Studio 30 m²">Nhận giá căn này</a></div></article>
      <article class="unit rv"><a class="pic" href="{P}sun-saphia-layout-can-1pn-plus.jpg"><img src="{P}sun-saphia-layout-can-1pn-plus.jpg" alt="Layout căn 1BR+ Sun Saphia Residence" loading="lazy" decoding="async"></a><div class="body"><h3>1BR+1 · 50–51 m²</h3><div class="meta"><span>108 căn</span><span>6,2 × 9 m</span></div><p class="note" style="margin:0">1 phòng ngủ + phòng đa năng (có kiểu 2 phòng ngủ 1 vệ sinh). Hợp gia đình nhỏ, làm việc từ xa.</p><div class="price">Chờ bảng giá chính thức</div><a class="btn btn-navy" href="#dang-ky" data-type="1BR+ 50 m²">Nhận giá căn này</a></div></article>
      <article class="unit rv"><a class="pic" href="{P}sun-saphia-layout-can-2pn.jpg"><img src="{P}sun-saphia-layout-can-2pn.jpg" alt="Layout căn 2BR Sun Saphia Residence" loading="lazy" decoding="async"></a><div class="body"><h3>2BR · 60–70 m²</h3><div class="meta"><span>133 căn</span><span>7,25 × 9,9 m</span></div><p class="note" style="margin:0">2 phòng ngủ, phòng khách, bếp; có căn góc bo tròn. Hợp gia đình, second home.</p><div class="price">Chờ bảng giá chính thức</div><a class="btn btn-navy" href="#dang-ky" data-type="2BR 60–70 m²">Nhận giá căn này</a></div></article>
    </div>
    <p class="note">754 căn thuộc ba loại đã có thông tin chi tiết; số căn còn lại trong tổng 782 căn chờ chủ đầu tư công bố.</p>
    <h3 style="font-family:'Playfair Display',serif;font-size:26px;margin:30px 0 0;color:var(--navy)">Mặt bằng các tầng <em style="color:var(--gold)">tòa Saphia</em></h3>
    <div class="tabs" role="tablist">{tabs}</div>
    {panes}
    <a class="plan" href="{IMG['tongthe']}" style="margin-top:10px"><img src="{IMG['tongthe']}" alt="Mặt bằng tổng thể Sun Saphia Residence – tối ưu view biển Mỹ Khê" loading="lazy" decoding="async"></a>
    <p class="plan-cap">Mặt bằng tổng thể – tối ưu tầm view biển Mỹ Khê. Mặt bằng theo tài liệu chủ đầu tư (10/2026), thông số tham khảo; số liệu chính thức theo hợp đồng mua bán. <a href="/mat-bang-can-ho-sun-saphia-residence/" style="color:var(--gold)">Xem mặt bằng chi tiết từng loại căn →</a></p>
  </div>
</section>

<!-- CHỌN CĂN 3D · 4D (bộ nhúng tự chèn ngay sau mục này) -->
<section class="dark" id="chon-can" aria-labelledby="h-cc">
  <div class="container">
    <span class="eyebrow">Chọn căn 3D · mô hình 4D</span>
    <h2 class="title" id="h-cc">Chọn căn trên mặt bằng, <em>xem view từng tầng</em></h2>
    <p class="lead">Mỗi tầng chỉ có vài căn view biển đẹp. Xoay mô hình, chọn tầng, chọn căn để xem hướng view; để lại số, Hiệp gửi mặt bằng căn còn trống và cách đặt chỗ theo quy trình chính thức.</p>
  </div>
</section>

<!-- GIÁ -->
<section id="bang-gia" aria-labelledby="h-bg">
  <div class="container">
    <span class="eyebrow">Giá dự kiến · 28/10/2026</span>
    <h2 class="title" id="h-bg">Studio tầng 15 từ khoảng <em>2,13 tỷ</em></h2>
    <p class="lead">Giá dự kiến chủ đầu tư đưa ra cho một số căn studio tầng 15, thông thủy 30 m², bàn giao hoàn thiện cơ bản – chưa phải bảng giá chính thức.</p>
    <div class="stat3">
      <div><b>2,85 tỷ</b><span>Dãy mặt biển · studio view biển trực diện · khoảng 95 triệu/m² thông thủy</span></div>
      <div><b>2,37 tỷ</b><span>Cánh bên · studio hông tòa · khoảng 79 triệu/m² thông thủy</span></div>
      <div><b>2,13 tỷ</b><span>Dãy phía sau · studio không hướng biển · khoảng 71 triệu/m² thông thủy</span></div>
    </div>
    <ul class="list-ok rv" style="margin-top:20px"><li>Giá áp dụng khi mua theo phương án có vay ngân hàng</li><li>Chưa gồm VAT và kinh phí bảo trì (2%), chưa trừ chiết khấu đặt chỗ sớm</li><li>Hỗ trợ lãi suất lên tới 24 tháng; không có chương trình nhận nhà sớm</li><li>Sự kiện bán hàng của chủ đầu tư dự kiến 05/12/2026 tại Đà Nẵng (khoảng 1.000 khách)</li></ul>
    <p class="note">Giá/m² do Hoàng Hiệp tính bằng cách chia cho 30 m² thông thủy; giá từng căn thay đổi theo tầng, hướng và chính sách khi mở bán. <a href="/gia-sun-saphia-residence-bao-nhieu/" style="color:var(--gold)">Xem bài phân tích giá →</a></p>
    <h3 style="font-family:'Playfair Display',serif;font-size:24px;margin:30px 0 0;color:var(--navy)">Nguồn cung hữu hạn – <em style="color:var(--gold)">giá căn hộ mặt biển</em> đang chào</h3>
    <div class="tbl-wrap"><table class="tbl">
      <thead><tr><th>Dự án ven biển</th><th>Studio</th><th>1BR</th><th>2BR</th><th>3BR</th></tr></thead>
      <tbody>
        <tr><td>The Soleil Đà Nẵng</td><td>5,2–5,5 tỷ</td><td>7,7–7,8 tỷ</td><td>17,5 tỷ</td><td>–</td></tr>
        <tr><td>Futa Residence Đà Nẵng</td><td>9,1–10,5 tỷ</td><td>10,3–11,5 tỷ</td><td>17,4–17,6 tỷ</td><td>–</td></tr>
        <tr><td>Nobu Đà Nẵng</td><td>6,3–6,4 tỷ</td><td>10,5–10,6 tỷ</td><td>21,4–21,7 tỷ</td><td>25,9 tỷ</td></tr>
        <tr><td>The Newtown Diamond</td><td>–</td><td>5,3–5,6 tỷ (1BR+)</td><td>6,8–8,3 tỷ</td><td>10–14 tỷ</td></tr>
      </tbody>
    </table></div>
    <p class="note">Giá chào bán tham khảo đưa ra tại Kick-off 23/10/2026, không phải giá Sun Saphia Residence.</p>
  </div>
</section>

<!-- PHÁP LÝ -->
<section id="phap-ly" style="background:#fff" aria-labelledby="h-pl">
  <div class="container">
    <div class="split" style="align-items:start">
      <div>
        <span class="eyebrow">Pháp lý & tiến độ</span>
        <h2 class="title" id="h-pl">Pháp lý <em>rõ ràng</em>, ngân hàng lớn đồng hành</h2>
        <div class="legal-box rv"><b>Giấy chứng nhận đăng ký đầu tư – mã dự án 2572746483</b><br>Sở Tài chính TP Đà Nẵng cấp lần đầu ngày 17/09/2026. Thời hạn dự án 50 năm tính từ 17/09/2026; công trình cấp I, niên hạn sử dụng 100 năm. Tính đến lúc nhận nhà 2028 vẫn còn khoảng 48 năm.</div>
        <div class="loan rv" style="grid-template-columns:repeat(3,1fr)"><div><b>Vietcombank</b><span>hỗ trợ vay</span></div><div><b>BIDV</b><span>hỗ trợ vay</span></div><div><b>NCB</b><span>hỗ trợ vay</span></div></div>
        <p class="note">Tỷ lệ cho vay và thời gian hỗ trợ lãi suất theo chính sách bán hàng công bố lúc mở bán. Bản sao pháp lý: nhắn Zalo 0904 567 009. <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/" style="color:var(--gold)">Chi tiết pháp lý & Nghị quyết 278 →</a></p>
      </div>
      <ol class="timeline rv">
        <li class="ok"><b>17/09/2026</b><span>Nhận Giấy chứng nhận đăng ký đầu tư</span></li>
        <li class="ok"><b>17/10/2026</b><span>Công bố thông tin dự án</span></li>
        <li class="ok"><b>23/10/2026</b><span>Kick-off "Đón ánh dương – Giao hòa nhịp sống" tại KOI Resorts & Residence</span></li>
        <li><b>08/11 – 02/12/2026</b><span>Chuỗi sự kiện giới thiệu: Hà Nội 08/11 và 22/11; Đà Nẵng 09/11 (ra quân, roadshow) và 15/11; livestream giới thiệu 11/11 và 02/12</span></li>
        <li><b>05/12/2026</b><span>Sự kiện bán hàng của chủ đầu tư tại Đà Nẵng (khoảng 1.000 khách) – công bố bảng giá, chính sách</span></li>
        <li><b>2/2027</b><span>Đường sắt đô thị sân bay – Hội An (giai đoạn 1) dự kiến khởi công</span></li>
        <li><b>11/2028</b><span>Căn hộ dự kiến bàn giao</span></li>
      </ol>
    </div>
    <p class="note">Lịch triển khai cập nhật 06/11/2026; các mốc kế hoạch dự kiến, có thể điều chỉnh theo công bố của chủ đầu tư và cơ quan nhà nước.</p>
  </div>
</section>

<!-- CHO THUÊ -->
<section class="dark" id="cho-thue" aria-labelledby="h-ct">
  <div class="container">
    <span class="eyebrow">Tiềm năng khai thác</span>
    <h2 class="title" id="h-ct">Dòng tiền cho thuê – <em>3 dòng khách</em> cùng đổ về Đà Nẵng</h2>
    <div class="stat3">
      <div><b>6,88 triệu</b><span>lượt khách quốc tế 8 tháng đầu 2026 (+26,3%) – nhiều chuyên gia, KOL, giáo viên ngoại ngữ ở lại làm việc lâu dài</span></div>
      <div><b>15–16 nghìn</b><span>người di cư ròng về Đà Nẵng mỗi năm – "đổi phố lấy biển", người về hưu, lao động trẻ trở về</span></div>
      <div><b>~3 triệu dân</b><span>sau sáp nhập Quảng Nam (từ 1/7/2025): cán bộ, doanh nghiệp, gia đình dịch chuyển về trung tâm</span></div>
    </div>
    <div class="loan rv">
      <div><b>2,2–2,9 tr</b><span>studio view biển / đêm, ngoài mùa cao điểm</span></div>
      <div><b>3,4–3,7 tr</b><span>1BR+ view biển / đêm, ngoài mùa cao điểm</span></div>
      <div><b>81,3%</b><span>công suất khách sạn Sun Group miền Trung 2026 (70,65% năm 2025)</span></div>
      <div><b>3 nhóm khách thuê</b><span>nhân sự chuỗi resort · thuê ngắn ngày kiểu Airbnb · khách du lịch</span></div>
    </div>
    <div class="vband rv">{card(IMG['resort'], 'Sun Saphia Residence về đêm giữa dải resort', 'Giữa dải resort ven biển · minh họa')}{card(IMG['trencao'], 'Sun Saphia Residence nhìn từ trên cao', 'Nhìn từ trên cao · minh họa')}</div>
    <div class="tbl-wrap"><table class="tbl">
      <thead><tr><th>Bài toán minh họa</th><th>Studio view biển</th><th>1BR view biển</th></tr></thead>
      <tbody>
        <tr><td>Diện tích · giá tham khảo</td><td>30 m² · 3 tỷ</td><td>50 m² · 4,5 tỷ</td></tr>
        <tr><td>Giá thuê · lấp đầy</td><td>2,5 tr/đêm · 60%</td><td>3,5 tr/đêm · 60%</td></tr>
        <tr><td>Doanh thu</td><td>540 triệu/năm</td><td>756 triệu/năm</td></tr>
        <tr><td>Lợi nhuận thực nhận (65%)</td><td>351 triệu/năm (~29,3 tr/tháng)</td><td>492 triệu/năm (~41 tr/tháng)</td></tr>
        <tr><td>Tỷ lệ trên giá tham khảo</td><td>11,7%/năm</td><td>10,9%/năm</td></tr>
      </tbody>
    </table></div>
    <p class="note" style="color:rgba(255,255,255,.65)">Bài toán chủ đầu tư đưa ra tại Kick-off theo giá giả định, chưa phải giá bán chính thức; con số thực tế tùy giá mua, mùa vụ, cách vận hành – không phải cam kết lợi nhuận. Giá thuê đối chiếu: Wyndham Soleil, Saha Casa, Radisson Đà Nẵng. Nguồn: Cục Thống kê, Sở VH-TT-DL Đà Nẵng, NQ 202/2025/QH15.</p>
    <a class="more" href="/du-an/sun-saphia-residence/tinh-dong-tien/">Tính dòng tiền cho từng căn →</a> &nbsp; <a class="more" href="/du-an/sun-saphia-residence/cho-thue/">Giá thuê căn hộ các tòa ven sông Hàn →</a>
  </div>
</section>

<!-- CHỦ NHÂN -->
<section id="chu-nhan" aria-labelledby="h-cn">
  <div class="container">
    <span class="eyebrow">Chân dung khách hàng</span>
    <h2 class="title" id="h-cn">Ai sẽ là <em>chủ nhân</em> Saphia?</h2>
    <div class="pays">
      <div class="pay rv"><h3>Khách hàng trẻ tự do</h3><ul><li>Ở chỗ mình muốn, làm việc mình yêu</li><li>Studio, 1BR+ gọn; SUP, kayak, jetski ngay trước nhà; cho thuê bù chi phí</li></ul></div>
      <div class="pay rv"><h3>Người thành đạt</h3><ul><li>Second home thương hiệu Sun Group cho cả nhà</li><li>Tòa 30 tầng view sông – núi – biển</li></ul></div>
      <div class="pay rv"><h3>Người nghỉ dưỡng sớm</h3><ul><li>Sống chậm sớm, nghỉ hưu sớm</li><li>Tiện ích đủ đầy, chuỗi bãi tắm, biển trước nhà</li></ul></div>
      <div class="pay rv"><h3>Người lớn tuổi</h3><ul><li>Gần biển là gần sức khỏe</li><li>Quanh nhà có biển, công viên, bệnh viện, siêu thị, trường học</li></ul></div>
    </div>
    <div class="vband rv">{card(IMG['giadinh'], 'Gia đình trên ban công nhìn ra biển', 'Second home cho cả nhà · minh họa')}{card(IMG['ongba'], 'Ông bà thư thái bên ban công', 'Gần biển là gần sức khỏe · minh họa')}</div>
    <ul class="list-ok rv" style="margin-top:20px"><li><b>Sức khỏe:</b> không gian sống xanh, biển và gió</li><li><b>Tinh thần:</b> thư thái, tự do, gần thiên nhiên</li><li><b>Tiện nghi:</b> trường học, siêu thị, bệnh viện đủ đầy</li><li><b>Đầu tư:</b> thương hiệu Sun Group, cho thuê tốt</li></ul>
  </div>
</section>

<!-- THƯ VIỆN -->
<section id="thu-vien" style="background:#fff" aria-labelledby="h-tv">
  <div class="container">
    <span class="eyebrow">Thư viện ảnh</span>
    <h2 class="title" id="h-tv">Sun Saphia <em>bên biển Đà Nẵng</em></h2>
    <div class="gallery">
      {card(IMG['hoanghon'], 'Sun Saphia Residence lúc hoàng hôn')}{card(IMG['binhminh'], 'Sun Saphia Residence trong nắng sớm')}{card(IMG['thapcat'], 'Tòa tháp Sun Saphia Residence')}{card(IMG['resort'], 'Sun Saphia Residence về đêm')}{card(IMG['trencao'], 'Sun Saphia Residence nhìn từ trên cao')}
    </div>
    <p class="note">Ảnh phối cảnh, minh họa của chủ đầu tư.</p>
  </div>
</section>

<!-- HỎI ĐÁP -->
<section class="faq" id="hoi-dap" aria-labelledby="h-hd">
  <div class="container">
    <span class="eyebrow">Hỏi đáp</span>
    <h2 class="title" id="h-hd">Khách hay hỏi về <em>Sun Saphia</em></h2>
    <div class="faq-cols">
      <div>
        <details><summary>Sun Saphia Residence ở đâu?</summary><p>Khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng, tại giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa; đi qua công viên ven biển khoảng 400 m là tới bãi tắm Sơn Thủy.</p></details>
        <details><summary>Ai là chủ đầu tư?</summary><p>Đơn vị phát triển là Sun Property, thành viên Tập đoàn Sun Group; đây là dự án căn hộ mặt biển đầu tiên Sun Group làm tại Đà Nẵng.</p></details>
        <details><summary>Quy mô gồm mấy tầng, mấy căn?</summary><p>1 tòa tháp 114 m, 30 tầng và 2 tầng hầm, trên khu đất 3.720,1 m², tổng 782 căn; căn hộ từ tầng 3A tới tầng 28, trần cao 3,5 m.</p></details>
        <details><summary>Có những loại căn nào?</summary><p>Bàn giao hoàn thiện cơ bản: Studio 30–31 m² (513 căn), 1BR+ 50–51 m² (108 căn), 2BR 60–70 m² (133 căn).</p></details>
      </div>
      <div>
        <details><summary>Pháp lý ra sao?</summary><p>GCN đăng ký đầu tư mã 2572746483, Sở Tài chính TP Đà Nẵng cấp lần đầu 17/09/2026; thời hạn dự án 50 năm; công trình cấp I, niên hạn 100 năm. Theo Nghị quyết 278/NQ-CP (18/9/2026), thời hạn sử dụng chung cư xác định theo niên hạn công trình.</p></details>
        <details><summary>Giá bao nhiêu?</summary><p>Chưa có bảng giá chính thức. Giá dự kiến 28/10/2026 cho studio tầng 15 (30 m²): khoảng 2,13 – 2,85 tỷ tùy hướng, chưa gồm VAT và phí bảo trì.</p></details>
        <details><summary>Bao giờ mở bán và bàn giao?</summary><p>Sự kiện bán hàng của chủ đầu tư dự kiến 05/12/2026 tại Đà Nẵng; trước đó có chuỗi sự kiện giới thiệu từ 08/11 đến 02/12/2026. Bàn giao dự kiến tháng 11/2028; các mốc có thể đổi theo công bố của chủ đầu tư.</p></details>
        <details><summary>Muốn đặt chỗ thì làm sao?</summary><p>Đăng ký nhận bảng giá, mặt bằng miễn phí. Theo chính sách chủ đầu tư, đặt chỗ 50 triệu nộp vào tài khoản công ty / chủ đầu tư, hoàn 100% nếu không mua; thứ tự chọn căn theo quy trình đặt chỗ chính thức.</p></details>
      </div>
    </div>
    <div class="kids" style="margin-top:26px">
      <a class="kid" href="/du-an/sun-saphia-residence/quy-hoach/"><div><small>Trang con</small><b>Quy hoạch xung quanh</b><span>Ngũ Hành Sơn, đường sắt, trục biển, công viên 2,45 ha</span></div></a>
      <a class="kid" href="/du-an/sun-saphia-residence/tinh-dong-tien/"><div><small>Công cụ</small><b>Tính dòng tiền</b><span>Vay ngân hàng, cho thuê từng căn</span></div></a>
      <a class="kid" href="/du-an/sun-saphia-residence/cho-thue/"><div><small>Trang con</small><b>Giá cho thuê</b><span>Căn hộ các tòa ven sông Hàn</span></div></a>
      <a class="kid" href="/du-an-can-ho-sun-group-da-nang-2026/"><div><small>Bài viết</small><b>Vì sao căn hộ mặt biển</b><span>Sun Group chọn mặt biển Đà Nẵng vì đâu</span></div></a>
    </div>
  </div>
</section>

<!-- ĐĂNG KÝ -->
<section class="cta" id="dang-ky" aria-labelledby="h-cta">
  <img class="bg" src="{IMG['hoanghon']}" alt="" loading="lazy" decoding="async">
  <div class="container">
    <div class="rv">
      <span class="eyebrow">Đăng ký nhận thông tin</span>
      <h2 class="title" id="h-cta">Nhận ngay <em style="color:var(--gold2)">khi có bảng giá</em></h2>
      <ul>
        <li>Chính sách thanh toán & bảng giá gốc</li>
        <li>Mặt bằng theo tầng, các căn còn trống</li>
        <li>Bảng tính dòng tiền cho căn anh/chị chọn</li>
        <li>Đăng ký trước để có chính sách sớm; chọn căn theo thứ tự đặt chỗ chính thức của chủ đầu tư</li>
      </ul>
      <div class="advisor"><div class="av">H</div><div><b>Hoàng Hiệp</b><span>Tư vấn dự án · trực tiếp, không qua tổng đài<br>Zalo/Hotline: <a href="https://zalo.me/0904567009" target="_blank" rel="noopener" class="js-zalo">0904 567 009</a></span></div></div>
    </div>
    <form class="form-card lead-form rv" data-form="Nhận bảng giá Sun Saphia Residence" aria-labelledby="f-title">
      <h3 id="f-title">Nhận bảng giá Sun Saphia</h3>
      <p>Chủ đầu tư công bố là gửi ngay qua Zalo · miễn phí, không ràng buộc</p>
      <div class="field"><label for="f-name">Họ và tên</label><input id="f-name" name="name" placeholder="Họ và tên *" autocomplete="name" required></div>
      <div class="field"><label for="f-phone">Số điện thoại</label><input id="f-phone" name="phone" type="tel" placeholder="Số Zalo / điện thoại *" autocomplete="tel" required pattern="[0-9 +.]{{9,14}}"></div>
      <div class="field"><label for="f-type">Anh/chị quan tâm</label><select id="f-type" name="type"><option value="">Anh/chị quan tâm</option><option>Studio 30 m²</option><option>1BR+ 50 m²</option><option>2BR 60–70 m²</option><option>Căn góc / view đẹp nhất</option></select></div>
      <button class="btn btn-gold" type="submit">Gửi tôi bảng giá</button>
      <div class="ok-msg" role="status">Cảm ơn anh/chị! Hoàng Hiệp sẽ gửi thông tin qua Zalo sớm nhất.</div>
    </form>
  </div>
</section>
</main>

<footer class="foot">
  <div class="container">Trang thông tin Sun Saphia Residence do Hoàng Hiệp (hiephoangmt.com) thực hiện, không phải website của chủ đầu tư. Nội dung, hình ảnh tổng hợp từ tài liệu giới thiệu dự án và nguồn công khai, chỉ để tham khảo; bảng giá, chính sách chính thức căn cứ công bố của chủ đầu tư và hợp đồng mua bán. Hình phối cảnh, tiện ích mang tính minh họa. Tư vấn: Hoàng Hiệp – 0904 567 009 – hiephoangmt@gmail.com. Thông tin anh/chị cung cấp chỉ dùng để liên hệ tư vấn, không chia sẻ cho bên thứ ba (Nghị định 13/2023/NĐ-CP) – <a href="/du-an/sun-saphia-residence/chinh-sach-bao-mat/" style="color:var(--gold2)">chính sách bảo mật</a>.</div>
</footer>

<div class="float"><a class="zl js-zalo" href="https://zalo.me/0904567009" target="_blank" rel="noopener" aria-label="Nhắn Zalo">Zalo</a><a class="call" href="tel:0904567009" aria-label="Gọi 0904 567 009">Gọi</a></div>
<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Xem ảnh"><button type="button" aria-label="Đóng">×</button><img alt=""></div>
'''
# Script của mẫu (tab, phóng ảnh, form, mục lục) – lấy nguyên từ trang The Poet, tab chỉ đổi trong cùng mục.
script = poet[poet.rindex('<script>'):poet.rindex('</script>') + 9]
script = script.replace("""  document.querySelectorAll('.tab').forEach(function(b){b.addEventListener('click',function(){
    document.querySelectorAll('.tab').forEach(function(x){x.classList.toggle('on',x===b);});
    document.querySelectorAll('.floor').forEach(function(f){f.classList.toggle('on',f.id===b.dataset.floor);});
  });});""", """  document.querySelectorAll('.tab').forEach(function(b){b.addEventListener('click',function(){
    var sec=b.closest('section');
    sec.querySelectorAll('.tab').forEach(function(x){x.classList.toggle('on',x===b);});
    sec.querySelectorAll('.floor').forEach(function(f){f.classList.toggle('on',f.id===b.dataset.floor);});
  });});""")
assert 'closest(\'section\')' in script
old = open(os.path.join(T, 'landing', 'sun-saphia-residence.html'), encoding='utf-8').read()
embed = old[old.index('<!-- 4D + CHỌN CĂN 3D -->'):old.index('<!-- /4D -->') + len('<!-- /4D -->')]
out = head + body + script + '\n' + embed + '\n'
open(os.path.join(T, 'landing', 'sun-saphia-residence.html'), 'w', encoding='utf-8').write(out)
print('ok', len(out))
