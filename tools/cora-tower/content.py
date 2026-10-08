"""Long-form SEO articles for the Cora Tower site (imported by build.py)."""

TEL, TEL_TXT = "0904567009", "0904 567 009"


def article(kicker, title, body, toc=None, cls="alt"):
    nav = ""
    if toc:
        nav = '<nav class="toc" aria-label="Mục lục"><b>Nội dung bài viết</b><ol>' + "".join(
            f'<li><a href="#{i}">{t}</a></li>' for i, t in toc) + "</ol></nav>"
    return f'''<section class="{cls}" id="bai-viet">
    <div class="wrap article">
      <div class="center reveal"><span class="kicker">{kicker}</span><h2>{title}</h2></div>
      {nav}
      <div class="prose">{body}</div>
    </div>
  </section>'''


CTA = (f'<p class="prose-cta">📞 Nhận bảng giá, mặt bằng và giỏ hàng mới nhất: gọi/Zalo '
       f'<a href="tel:{TEL}"><b>{TEL_TXT}</b></a> hoặc <a href="#dang-ky">để lại thông tin</a>.</p>')

# ---------------------------------------------------------------- TRANG CHỦ
INDEX_TOC = [("ct-tong-quan", "Cora Tower là dự án gì?"), ("ct-vi-tri", "Vị trí vòng xoay 29/3 – Nguyễn Phước Lan"),
             ("ct-thiet-ke", "Kiến trúc khối mái cam biểu tượng"), ("ct-can-ho", "Các loại căn hộ và diện tích"),
             ("ct-gia", "Giá bán và chính sách thanh toán"), ("ct-tien-ich", "Tiện ích tầng 2 riêng từng tòa"),
             ("ct-phap-ly", "Pháp lý Cora Tower"), ("ct-ai-nen-mua", "Ai nên mua Cora Tower?")]
INDEX_ARTICLE = article("Cẩm nang mua căn hộ", "Cora Tower Đà Nẵng: tất cả những gì cần biết trước khi xuống tiền", f'''
<h3 id="ct-tong-quan">Cora Tower là dự án gì?</h3>
<p><strong>Cora Tower</strong> là tên thương mại của hai tòa căn hộ chung cư do <strong>Sun Group</strong> (Công ty CP Tập đoàn Mặt Trời) phát triển trên lô A2-19 và A2-20, thuộc Khu đô thị sinh thái ven sông Hòa Xuân – nay là <strong>Sun Neo City</strong>, phường Hòa Xuân, TP Đà Nẵng. Dự án gồm <strong>Tòa A1 (672 căn)</strong> và <strong>Tòa A2 (670 căn)</strong>, tổng <strong>1.342 căn hộ</strong>, mỗi tòa 25 tầng nổi và 2 tầng hầm, cao 97,95 m.</p>
<p>Khác với nhiều <a href="can-ho-sun-da-nang.html">căn hộ Sun Đà Nẵng</a> khác đang mở bán, Cora Tower có đủ “bộ sưu tập” sản phẩm trong cùng một dự án: studio cho người trẻ, 1PN+ cho vợ chồng son, 2PN – 3PN cho gia đình, căn sân vườn tầng 3, <a href="penthouse.html">penthouse – duplex tầng 25</a> và <a href="khoi-de-shophouse.html">shophouse khối đế</a> tầng 1.</p>

<h3 id="ct-vi-tri">Vị trí vòng xoay 29/3 – Nguyễn Phước Lan: “cửa ngõ” Nam trung tâm</h3>
<p>Hai tòa tháp đứng đối xứng hai bên trục đường 29/3, mặt chính hướng ra vòng xoay giao Nguyễn Phước Lan – nơi chủ đầu tư đang hoàn tất thủ tục để cải tạo thành <strong>đài phun nước</strong>. Hạ tầng quanh dự án (29/3, Nguyễn Phước Lan, Đinh Văn Chấp, Hoàng Thế Thiện) đã cơ bản hoàn thành, nên cư dân dọn về là dùng được ngay.</p>
<ul>
<li>Qua cầu Hòa Xuân là tới MM Mega Market, đường Cách Mạng Tháng 8.</li>
<li>Kết nối Lotte Mart, cầu Rồng, cầu Trần Thị Lý và trung tâm Hải Châu.</li>
<li>Ra biển qua đường Hồ Xuân Hương; đi Hội An qua cầu Trung Lương; về sân bay quốc tế Đà Nẵng thuận tiện.</li>
<li>Cầu Bùi Tá Hán đã có trong quy hoạch, đang nghiên cứu phương án thi công.</li>
</ul>
<p>Khu Nam trung tâm Đà Nẵng đang được định hướng thành một cực phát triển mới của thành phố đa trung tâm, với các dự án “Dòng sông ánh sáng” và tuyến du lịch đường thủy sông Cổ Cò được báo chí nhắc tới – đây là nền tảng cho giá trị dài hạn của căn hộ và shophouse tại đây.</p>

<h3 id="ct-thiet-ke">Kiến trúc khối mái cam: nhận diện từ xa</h3>
<p>Điểm dễ nhận ra nhất của Cora Tower là <strong>khối mái kiến trúc màu cam</strong> ôm trọn tầng 25 – nơi bố trí các căn penthouse. Thân tháp trắng – xám với hệ lam đứng, kính lớn đón sáng; khối đế bo cong theo vòng xoay, mặt kính kịch trần và sân vườn trên cao ở tầng 3. Căn hộ điển hình có trần cao 3,5 m, hành lang rộng 1,8 m – thông thoáng hơn mặt bằng chung của chung cư cùng phân khúc.</p>

<h3 id="ct-can-ho">Các loại căn hộ Cora Tower và diện tích</h3>
<table><thead><tr><th>Loại căn</th><th>DT thông thủy</th><th>Phù hợp</th></tr></thead><tbody>
<tr><td>Studio</td><td>32,2 – 32,3 m²</td><td>Người trẻ, cho thuê ngắn hạn</td></tr>
<tr><td>1PN+</td><td>52,5 – 59,6 m²</td><td>Vợ chồng trẻ, đầu tư cho thuê – dòng căn chủ lực</td></tr>
<tr><td>2PN / 2PN+1</td><td>60,6 – 73,1 m²</td><td>Gia đình nhỏ, nhiều căn góc 2 mặt thoáng</td></tr>
<tr><td>3PN</td><td>78,9 – 81,8 m²</td><td>Gia đình đa thế hệ – mỗi sàn mỗi tòa 1 căn</td></tr>
<tr><td>Căn sân vườn tầng 3</td><td>+ sân vườn 10 – 151 m²</td><td>Người thích không gian xanh riêng</td></tr>
<tr><td>Penthouse tầng 25</td><td>51,9 – 88,6 m² sàn chính, trần ~7 m</td><td>Làm duplex, sống đẳng cấp</td></tr>
</tbody></table>
<p>Mỗi sàn điển hình (tầng 3A–24) có 28 căn, hành lang giữa, 2 lõi thang. Xem chi tiết từng mã căn ở mục <a href="#mat-bang">mặt bằng</a>.</p>

<h3 id="ct-gia">Giá bán Cora Tower và chính sách thanh toán</h3>
<p>Căn 1PN+ tầng 15 hiện có giá dự kiến khoảng <strong>3,1 – 3,85 tỷ/căn</strong> (giá trần gồm VAT và phí bảo trì, theo chính sách bán hàng); shophouse 43 – 61,5 m² khoảng <strong>4,96 – 6,04 tỷ/căn</strong>. Chính sách nổi bật:</p>
<ul>
<li>Chiết khấu <strong>7%</strong> “Đặc quyền hoàn thiện nội thất”; khách không vay chiết khấu thêm <strong>5%</strong> và giãn tiến độ đến <strong>40 tháng</strong>.</li>
<li>Ngân hàng cho vay tối đa <strong>70%</strong>, hỗ trợ lãi suất đến <strong>24 tháng</strong> (không muộn hơn 30/09/2028), miễn phí trả nợ trước hạn trong thời gian hỗ trợ.</li>
<li><strong>Sun Early Key</strong>: thanh toán 70% là nhận nhà để sử dụng, dự kiến <strong>31/10/2027</strong>.</li>
<li>Đặt cọc khi ký hợp đồng thực hiện nguyện vọng chỉ <strong>100 triệu</strong> (3PN 150 triệu, penthouse 300 triệu); miễn phí dịch vụ quản lý 1 năm.</li>
<li>Ký hợp đồng thỏa thuận nguyên tắc trước để kịp chuẩn bị hồ sơ vay, sau đó ký hợp đồng mua bán.</li>
</ul>
<p>Giá thay đổi theo tầng, hướng và từng đợt chính sách – hãy <a href="#chinh-sach">xem chính sách</a> và <a href="#dang-ky">nhận bảng giá đầy đủ</a> để có con số chính xác.</p>

<h3 id="ct-tien-ich">Tiện ích tầng 2 riêng cho cư dân từng tòa</h3>
<p>Thay vì dồn tiện ích lên mái, Cora Tower dành trọn <strong>tầng 2</strong> mỗi tòa cho cư dân: hồ bơi trong nhà kính bốn mùa, <strong>Jjimjilbang</strong> – xông hơi kiểu Hàn Quốc và spa (tòa A1), gym và golf mô phỏng (tòa A2), khu trẻ em, thư viện, phòng sinh hoạt cộng đồng. Tầng 1 là shophouse với cafe, cửa hàng, dịch vụ ngay chân tòa nhà.</p>

<h3 id="ct-phap-ly">Pháp lý Cora Tower: đủ điều kiện bán, có bảo lãnh</h3>
<p>Đây là điểm khiến Cora Tower khác biệt: đất đã có sổ đỏ từng lô (DI 103576, DI 103577), Sở Xây dựng có văn bản <strong>7117/SXD-QLN</strong> về điều kiện đưa nhà ở hình thành trong tương lai vào kinh doanh, chủ đầu tư ký hợp đồng <strong>bảo lãnh với VietinBank</strong> và hợp đồng mẫu đã đăng ký tại Sở Công Thương. Xem và tải bản scan tại trang <a href="phap-ly.html">Pháp lý Cora Tower</a>.</p>

<h3 id="ct-ai-nen-mua">Ai nên mua Cora Tower?</h3>
<ul>
<li><strong>Người mua để ở</strong> làm việc ở Hải Châu, Cẩm Lệ, Ngũ Hành Sơn muốn căn hộ mới, pháp lý rõ, tổng tiền vừa phải.</li>
<li><strong>Nhà đầu tư cho thuê</strong>: studio và 1PN+ dễ khai thác nhờ cộng đồng 1.342 căn và nhu cầu thuê quanh Hòa Xuân.</li>
<li><strong>Người tìm tài sản khan hiếm</strong>: penthouse trần 7 m và shophouse khối đế – số lượng có hạn trong cả khu đô thị.</li>
</ul>
{CTA}''', INDEX_TOC)

# ---------------------------------------------------------------- SHOPHOUSE
SHOP_TOC = [("sh-buoi-sang", "Một buổi sáng ở shop của anh/chị"), ("sh-vi-sao", "Ba thứ làm nên một shophouse “đẻ ra tiền”"),
            ("sh-gia-dat", "Đất Nguyễn Phước Lan 150–230 triệu/m²"), ("sh-dep", "Mặt tiền tự bán hàng thay chủ"), ("sh-7m", "Trần 7 m: mua một, dùng hai"),
            ("sh-khai-thac", "Kinh doanh gì để có dòng tiền?"), ("sh-tai-chinh", "Chỉ từ 1,5 tỷ để bắt đầu"),
            ("sh-phap-ly", "Sở hữu lâu dài – tài sản để lại cho con"), ("sh-chon-can", "Chọn căn: căn đẹp đi trước"),
            ("sh-rui-ro", "Kiểm tra gì trước khi cọc?")]


def _fig(name, alt, cap, h=1066):
    return (f'<figure class="prose-fig"><picture><source type="image/webp" srcset="assets/img/{name}-800.webp 800w, assets/img/{name}.webp 1600w" '
            f'sizes="(max-width:820px) 100vw, 800px"><img src="assets/img/{name}.jpg" srcset="assets/img/{name}-800.jpg 800w, assets/img/{name}.jpg 1600w" '
            f'sizes="(max-width:820px) 100vw, 800px" width="1600" height="{h}" alt="{alt}" loading="lazy" decoding="async"></picture>'
            f'<figcaption>{cap}</figcaption></figure>')


SHOP_ARTICLE = article("Câu chuyện đầu tư", "Shophouse Cora Tower: mặt bằng tự bán hàng, tài sản tự sinh tiền", f'''
<h3 id="sh-buoi-sang">Một buổi sáng ở shop của anh/chị</h3>
<p class="lead-in">6 giờ 30. Nắng sớm hắt qua lớp kính cao gần 7 m. Cư dân từ sảnh tòa tháp bước xuống, ghé mua ly cà phê, ổ bánh mì trước khi đi làm. Bên ngoài, dòng xe trên đường 29/3 chậm lại ở vòng xoay – và ai cũng nhìn thấy biển hiệu của anh/chị.</p>
<p>Đó không phải giấc mơ xa. Đó là một ngày bình thường của <strong>shophouse khối đế Cora Tower</strong> – nơi <strong>1.342 gia đình</strong> sống ngay phía trên, và vòng xoay 29/3 – Nguyễn Phước Lan đưa người qua lại suốt cả ngày. Anh/chị không phải đi tìm khách. Khách đã ở sẵn đó.</p>
{_fig("phoi-canh-shophouse-khoi-de-cora-tower-08", "Mặt tiền shophouse Cora Tower dọc đường 29/3", "Dãy shophouse khối đế dọc đường 29/3 – mặt kính kịch trần, vỉa hè rộng rợp cây.")}

<h3 id="sh-vi-sao">Ba thứ làm nên một shophouse “đẻ ra tiền”</h3>
<p>Người làm kinh doanh lâu năm đều biết: một mặt bằng tốt cần <strong>người đi qua, người ở trên và pháp lý chắc</strong>. Thiếu một trong ba, shop sẽ phải “gồng”. Cora Tower có đủ cả ba:</p>
<ul class="checks">
<li><strong>Người ở trên:</strong> hai tòa tháp 25 tầng, 1.342 căn hộ – một “khu dân cư” trọn vẹn là khách hàng mỗi ngày.</li>
<li><strong>Người đi qua:</strong> mặt tiền ôm vòng xoay 29/3 – Nguyễn Phước Lan, trục giao thông chính của Nam Hòa Xuân, cạnh đài phun nước đang được hoàn tất thủ tục.</li>
<li><strong>Pháp lý chắc:</strong> sở hữu lâu dài như căn hộ, do Sun Group phát triển.</li>
</ul>
<blockquote class="pull">Chỉ khoảng 60 căn shop tại Cora Tower – và chừng 150 căn khối đế cho cả khu đô thị. Đất có thể làm thêm, nhưng mặt tiền dưới chân 1.342 căn hộ thì không.</blockquote>

<h3 id="sh-gia-dat">Đất Nguyễn Phước Lan đã 150 – 230 triệu/m². Shophouse thì sao?</h3>
<p>Ai từng đi xem đất Hòa Xuân đều thấy rõ: đất mặt tiền <strong>Nguyễn Phước Lan</strong> hiện được rao bán khoảng <strong>150 – 230 triệu đồng/m²</strong>. Một lô 100 m² đã là <strong>15 – 23 tỷ</strong> – chưa tính tiền xây, và vẫn phải tự đi kéo khách.</p>
<p>Ngay tại vòng xoay 29/3 – Nguyễn Phước Lan, shophouse Cora Tower có giá chỉ khoảng <strong>4,96 – 6,04 tỷ/căn</strong> cho 43 – 61,5 m², tức khoảng <strong>100 – 115 triệu/m²</strong> (đã gồm VAT, phí bảo trì) – thấp hơn đáng kể so với đơn giá đất mặt tiền cùng tuyến đường.</p>
<div class="table-wrap"><table>
<thead><tr><th></th><th>Đất mặt tiền Nguyễn Phước Lan</th><th>Shophouse Cora Tower</th></tr></thead>
<tbody>
<tr><td>Đơn giá</td><td>150 – 230 triệu/m² đất</td><td><b>~100 – 115 triệu/m²</b></td></tr>
<tr><td>Tổng tiền</td><td>15 – 23 tỷ (lô 100 m²)</td><td><b>4,96 – 6,04 tỷ</b></td></tr>
<tr><td>Vốn ban đầu</td><td>Gần như toàn bộ</td><td><b>~1,5 – 1,8 tỷ</b> (vay 70%, 0% lãi 24 tháng)</td></tr>
<tr><td>Xây dựng</td><td>Tự xây, tự xin phép</td><td><b>Nhận bàn giao</b>, trần ~7 m làm được tầng lửng</td></tr>
<tr><td>Khách hàng</td><td>Tự kéo</td><td><b>1.342 căn hộ</b> ngay phía trên</td></tr>
<tr><td>Vận hành</td><td>Tự lo an ninh, vệ sinh</td><td>Ban quản lý chuyên nghiệp của Sun Group</td></tr>
</tbody></table></div>
<p class="note">Giá đất là mức rao bán tham khảo trên thị trường, thay đổi theo vị trí lô và thời điểm. Shophouse là sở hữu sàn trong tòa nhà, không phải sở hữu riêng thửa đất.</p>
<p>Khối đế Cora Tower hội tụ nhiều yếu tố mà một lô đất phố khó có cùng lúc: <strong>vị trí vòng xoay, khách sẵn có, mặt tiền kính kịch trần, trần cao làm tầng lửng, sở hữu lâu dài, thương hiệu Sun Group và chính sách vốn nhẹ</strong>. Cùng một tuyến đường, cùng một dòng người – nhưng số vốn bỏ ra chỉ bằng khoảng một phần ba.</p>

<h3 id="sh-dep">Mặt tiền tự bán hàng thay chủ</h3>
<p>Khối đế bo cong theo vòng xoay, <strong>mặt kính kịch trần</strong>, biển hiệu đồng bộ trên nền gỗ cam ấm, mái sảnh lam kim loại. Ban ngày, ánh sáng biến cả cửa hàng thành một tủ trưng bày khổng lồ; về đêm, dải đèn biển hiệu nối dài theo đường cong khối đế như một con phố thương mại thu nhỏ. Mặt tiền từng căn rộng <strong>3,5 – 13 m</strong>, nhiều căn góc hai mặt thoáng – đúng thứ các thương hiệu thời trang, F&amp;B, ngân hàng luôn săn tìm và sẵn sàng trả giá thuê cao.</p>
{_fig("khoi-de-vong-xoay-cora-tower", "Khối đế Cora Tower bo cong bên vòng xoay với spa, cafe, phòng gym", "Góc bo cong bên vòng xoay: nơi biển hiệu được nhìn thấy từ mọi hướng.", 900)}

<h3 id="sh-7m">Trần 7 m: mua một, dùng hai</h3>
<p>Chiều cao tầng khoảng <strong>7 m</strong> cho phép làm thêm <strong>tầng lửng</strong> – gần như nhân đôi diện tích sử dụng mà không phải trả thêm tiền đất. Tầng dưới bán hàng, tầng lửng làm kho, văn phòng, khu ngồi cafe hay phòng trị liệu spa. Hồ sơ tầng lửng gửi Ban quản lý duyệt khoảng <strong>1–2 tuần</strong>. Cần không gian lớn? Có thể gộp hai căn liền kề để làm showroom.</p>

<h3 id="sh-khai-thac">Kinh doanh gì để có dòng tiền?</h3>
<ul>
<li><strong>Tiện ích thiết yếu</strong> – mart, nhà thuốc, giặt là, tiệm bánh, phòng khám: khách là cư dân ngay phía trên, mua mỗi ngày.</li>
<li><strong>Cafe, F&amp;B</strong> – không gian hai tầng, góc kính nhìn ra vòng xoay đài phun nước.</li>
<li><strong>Thương hiệu, showroom</strong> – mặt kính dài, biển hiệu lớn, nhận diện từ xa trên đường 29/3.</li>
<li><strong>Dịch vụ</strong> – spa, salon, trung tâm ngoại ngữ, văn phòng giao dịch.</li>
</ul>
<p>Không tự kinh doanh? Cho thuê để thương hiệu khai thác. Báo chí dẫn lời một số chủ shophouse khu Nam trung tâm Đà Nẵng đang cho thuê <strong>35–100 triệu đồng/tháng</strong> tùy vị trí, diện tích (thông tin tham khảo, không phải cam kết).</p>
<p class="prose-cta inline">Muốn biết căn nào hợp ngành hàng của mình? Gọi/Zalo <a href="tel:{TEL}"><b>{TEL_TXT}</b></a> – chuyên viên gửi ngay mặt bằng và giỏ căn còn trống.</p>

<h3 id="sh-tai-chinh">Chỉ từ khoảng 1,5 tỷ để bắt đầu</h3>
<div class="num-row">
<div><b>70%</b><span>ngân hàng cho vay</span></div>
<div><b>0%</b><span>lãi suất 24 tháng</span></div>
<div><b>40</b><span>tháng giãn thanh toán</span></div>
<div><b>~1,5 tỷ</b><span>vốn tự có ban đầu</span></div>
</div>
<p>Với căn 4,96 – 6,04 tỷ, khoản vay tối đa 70% được hỗ trợ lãi suất 0% trong 24 tháng – vốn tự có ban đầu chỉ khoảng <strong>1,5 – 1,8 tỷ</strong>. Chương trình <strong>Sun Early Key</strong>: thanh toán 70% là nhận nhà, 30% còn lại trả trong 24 tháng – nghĩa là shop có thể <strong>mở cửa đón khách, tạo dòng tiền trước khi trả xong</strong>. Cộng thêm chiết khấu Early Bird 3%, chiết khấu không vay 5% và hỗ trợ hoàn thiện nội thất kinh doanh 4% (xem <a href="#chinh-sach-shop">chính sách</a>).</p>

<h3 id="sh-phap-ly">Sở hữu lâu dài – tài sản để lại cho con</h3>
<p>Nhiều shop chân đế ở Hà Nội, TP.HCM khai thác rất tốt nhưng chỉ sở hữu có thời hạn. Shophouse Cora Tower thì khác: theo chủ đầu tư, <strong>sở hữu lâu dài</strong> như căn hộ, hình thành đơn vị ở nên <strong>đăng ký được hộ khẩu thường trú</strong>. Hôm nay là cửa hàng của anh/chị, mai kia là tài sản trao lại cho thế hệ sau. (Lưu ý: shophouse không đăng ký giấy phép kinh doanh tại căn; cách làm phổ biến là cho thương hiệu thuê theo hợp đồng ghi mã căn, hoặc dùng làm địa điểm kinh doanh của doanh nghiệp/hộ kinh doanh đăng ký ở địa chỉ khác.)</p>
{_fig("phoi-canh-cora-tower-ve-dem", "Phối cảnh Cora Tower về đêm với khối mái màu cam phát sáng", "Khi phố lên đèn, khối đế Cora Tower vẫn sáng – và vẫn bán hàng.", 930)}

<h3 id="sh-chon-can">Chọn căn: căn đẹp luôn đi trước</h3>
<ul>
<li><strong>Căn góc, căn mặt vòng xoay</strong> – hiển thị tốt nhất, thương hiệu lớn thích; thường hết đầu tiên.</li>
<li><strong>Căn gần sảnh cư dân</strong> – lưu lượng qua lại mỗi ngày, hợp mart, nhà thuốc, cafe.</li>
<li><strong>Mặt tiền rộng hơn chiều sâu</strong> – dễ trưng bày; xem kích thước từng căn ở <a href="#mat-bang-shop">mặt bằng shophouse</a>.</li>
<li><strong>Diện tích 43 – 62 m²</strong> – tổng tiền vừa phải, dễ cho thuê, dễ thanh khoản.</li>
</ul>
<p>Với nguồn cung có hạn, mỗi đợt mở bán những căn góc và căn mặt vòng xoay thường được giữ chỗ sớm nhất. Người quyết sớm được chọn căn; người đến sau chọn phần còn lại.</p>

<h3 id="sh-rui-ro">Kiểm tra gì trước khi cọc?</h3>
<p>Đầu tư thông minh là đầu tư tỉnh táo: xem hồ sơ pháp lý tại <a href="phap-ly.html">trang Pháp lý</a>, đọc kỹ hợp đồng mẫu, hỏi rõ quy định vận hành của Ban quản lý (biển hiệu, giờ hoạt động, chỗ đỗ xe), thời hạn hoàn thiện <strong>12 tháng</strong> kể từ bàn giao (quá hạn đóng phí 8% giá trị căn) và tự khảo sát giá thuê khu vực. Chuyên viên sẽ gửi đầy đủ tài liệu để anh/chị đối chiếu – không vội, không ép.</p>
<div class="prose-cta big"><b>Giữ một mặt tiền trước khi nó thuộc về người khác.</b><span>Nhận giỏ căn shophouse còn trống, bảng giá và bảng tính dòng tiền cho riêng căn anh/chị quan tâm.</span><p><a class="btn" href="tel:{TEL}">Gọi {TEL_TXT}</a> <a class="btn ghost" href="#dang-ky">Nhận giỏ hàng</a></p></div>''', SHOP_TOC)

# ---------------------------------------------------------------- PENTHOUSE
PH_TOC = [("ph-cam-xuc", "Sống trên đỉnh Cora Tower"), ("ph-7m", "Trần 7 m: tự viết căn nhà của riêng mình"),
          ("ph-view", "Tầm nhìn không bị che chắn"), ("ph-layout", "Mặt bằng và cách làm duplex"),
          ("ph-gia", "Giá penthouse và chính sách"), ("ph-dau-tu", "Giá trị đầu tư của penthouse"), ("ph-ai", "Penthouse dành cho ai?")]
PH_ARTICLE = article("Câu chuyện penthouse", "Penthouse Cora Tower: nơi bầu trời Đà Nẵng trở thành phòng khách", f'''
<h3 id="ph-cam-xuc">Sống trên đỉnh Cora Tower</h3>
<p>Ai từng đứng trên một tầng thật cao lúc chiều tà đều nhớ cảm giác ấy: tiếng ồn của phố xá lùi xa, gió mát hơn, và cả thành phố bỗng nhỏ lại vừa trong một khung nhìn. <strong>Penthouse Cora Tower</strong> giữ lại cảm giác đó – không phải cho một buổi chiều, mà cho mỗi ngày.</p>
<p>Buổi sáng, nắng từ phía biển tràn qua ô kính cao gấp đôi bình thường, đánh thức cả căn nhà. Chiều xuống, mặt trời lặn sau rặng núi phía Tây, sông Hàn đổi màu bạc rồi tím, vòng quay Sun Wheel lên đèn ở phía xa. Những tối lễ hội, cả gia đình ngồi trên ban công tầng 25 – nơi không có tòa nhà nào chắn tầm mắt. Đó không chỉ là một căn hộ cao nhất, mà là <strong>một góc trời riêng giữa lòng Đà Nẵng</strong>.</p>
<p>Các căn penthouse nằm trọn trong <strong>khối mái màu cam</strong> – phần kiến trúc dễ nhận ra nhất của hai tòa tháp. Từ vòng xoay 29/3 nhìn lên, đó là “vương miện” của Cora Tower; từ bên trong nhìn ra, đó là khung cửa sổ lớn nhất của cả dự án. Và mỗi tòa tháp chỉ có duy nhất một tầng như thế.</p>

<h3 id="ph-7m">Trần 7 m: tự viết căn nhà của riêng mình</h3>
<p>Penthouse Cora Tower có chiều cao tầng khoảng <strong>7 m</strong> – gấp đôi căn hộ thông thường. Bạn nhận một không gian còn để ngỏ, và toàn quyền kể câu chuyện của riêng mình trong đó: làm phòng khách thông tầng với đèn chùm buông dài, đặt thư viện trên tầng lửng nhìn xuống, hay chia thành <strong>duplex hai tầng</strong> với phòng ngủ riêng tư phía trên. Chủ đầu tư có sẵn <strong>layout duplex gợi ý</strong>:</p>
<ul>
<li>Căn 1PN làm lửng thành <strong>2PN+1</strong>.</li>
<li>Căn 2PN làm lửng thành <strong>3PN</strong>.</li>
<li>Căn 2PN+1 làm lửng thành <strong>3PN+1</strong>.</li>
</ul>
<p>Nhà vệ sinh tầng 2 nên bố trí theo trục kỹ thuật; phương án thi công gửi Ban quản lý duyệt khoảng 1–2 tuần. Điều đáng giá nhất: <strong>giá penthouse tính theo đơn nguyên một căn</strong> – phần tầng lửng anh/chị tự làm không tính thêm tiền.</p>

<h3 id="ph-view">Tầm nhìn không bị che chắn</h3>
<p>Cora Tower đứng giữa khu đô thị thấp tầng nên từ tầng 25, tầm nhìn trải rộng về mọi hướng: <strong>sông Hàn và trung tâm thành phố</strong>, <strong>biển</strong> phía Đông, rặng núi phía Tây và toàn cảnh Sun Neo City xanh mướt. Báo chí giới thiệu bộ sưu tập penthouse của Sun Group tại Nam trung tâm Đà Nẵng (Cora Tower, Spana Tower, S-Light Tower) có ban công như “khán đài” ngắm pháo hoa lễ hội quốc tế Đà Nẵng – trải nghiệm mà hiếm căn nhà nào trong thành phố có được.</p>

<h3 id="ph-layout">Mặt bằng penthouse và cách làm duplex</h3>
<p>Tầng 25 mỗi tòa có khoảng <strong>24 căn</strong>, sàn chính từ <strong>51,9 đến 88,6 m²</strong> thông thủy (56,3 – 94,7 m² tim tường), gồm các loại 1PN, 1PN+1, 2PN và 2PN+1. Xem từng mã căn và tầng lửng gợi ý ở mục <a href="#mat-bang-penthouse">mặt bằng penthouse</a>. Thời hạn hoàn thiện là <strong>12 tháng</strong> kể từ ngày bàn giao.</p>

<h3 id="ph-gia">Giá penthouse Cora Tower và chính sách</h3>
<p>Giá tùy vị trí, diện tích và hướng view. Đặt cọc khi ký hợp đồng thực hiện nguyện vọng 300 triệu; chính sách cơ bản giống căn hộ điển hình: vay tối đa 70%, hỗ trợ lãi suất đến 24 tháng, Sun Early Key thanh toán 70% nhận nhà dự kiến 31/10/2027. Vì số lượng rất ít, giỏ hàng penthouse thường chỉ gửi trực tiếp – <a href="#dang-ky">đăng ký ưu tiên</a> hoặc gọi <a href="tel:{TEL}">{TEL_TXT}</a>.</p>

<h3 id="ph-dau-tu">Giá trị đầu tư của penthouse</h3>
<p>Mỗi tòa tháp chỉ có một tầng mái. Trong khi căn hộ điển hình có hàng trăm căn tương tự, penthouse luôn là <strong>nhóm sản phẩm khan hiếm nhất</strong> – yếu tố giữ giá tốt theo thời gian. Diện tích sử dụng thực tế sau khi làm lửng lớn hơn đáng kể so với giá mua, cộng với tầm nhìn không thể tái tạo, khiến penthouse vừa là nơi ở vừa là tài sản để dành.</p>

<h3 id="ph-ai">Penthouse dành cho ai?</h3>
<ul>
<li>Gia đình đa thế hệ cần nhiều phòng nhưng vẫn muốn sống trong căn hộ có tiện ích, an ninh.</li>
<li>Doanh nhân muốn không gian tiếp khách khác biệt, có dấu ấn riêng.</li>
<li>Người yêu thiết kế, muốn tự tay tạo nên căn nhà thông tầng của mình.</li>
<li>Nhà đầu tư tìm tài sản hiếm, giữ giá trị dài hạn.</li>
</ul>
{CTA}''', PH_TOC)

# ---------------------------------------------------------------- CĂN HỘ SUN ĐÀ NẴNG
SUN_TOC = [("sun-tong-quan", "Căn hộ Sun Group tại Đà Nẵng"), ("sun-neo-city", "Sun Neo City – khu đô thị Nam trung tâm"),
           ("sun-so-sanh", "So sánh Cora Tower, Spana Tower, S-Light Tower"), ("sun-vi-sao-cora", "Vì sao nhiều khách chọn Cora Tower?"),
           ("sun-gia", "Giá căn hộ Sun Đà Nẵng tại Cora Tower"), ("sun-quy-trinh", "Quy trình mua căn hộ Sun")]
SUN_BODY = f'''
<h3 id="sun-tong-quan">Căn hộ Sun Group tại Đà Nẵng: vì sao được quan tâm?</h3>
<p>Sun Group (Công ty CP Tập đoàn Mặt Trời) gắn bó với Đà Nẵng qua Bà Nà Hills, Cầu Vàng, Sun World Asia Park, Sun Wheel… Những năm gần đây, tập đoàn mở rộng sang <strong>căn hộ để ở</strong> với nhiều tổ hợp tại khu Nam trung tâm thành phố. Điểm chung của <strong>căn hộ Sun Đà Nẵng</strong>: thương hiệu chủ đầu tư lớn, nằm trong khu đô thị quy hoạch đồng bộ, chính sách tài chính linh hoạt.</p>

<h3 id="sun-neo-city">Sun Neo City – khu đô thị Nam trung tâm Đà Nẵng</h3>
<p>Các tổ hợp căn hộ Cora Tower, Spana Tower, S-Light Tower đều nằm trong <strong>Sun Neo City</strong> – Khu đô thị sinh thái ven sông Hòa Xuân, bao quanh bởi sông Cẩm Lệ, sông Hàn và sông Cổ Cò. Hạ tầng đường 29/3, Nguyễn Phước Lan đã cơ bản hoàn thành; khu vực được định hướng thành một cực phát triển mới của Đà Nẵng theo mô hình đô thị đa trung tâm.</p>

<h3 id="sun-so-sanh">So sánh nhanh các dự án căn hộ Sun tại Hòa Xuân</h3>
<table><thead><tr><th></th><th>Cora Tower</th><th>Spana Tower</th><th>S-Light Tower</th></tr></thead><tbody>
<tr><td>Vị trí</td><td>Vòng xoay 29/3 – Nguyễn Phước Lan</td><td>Nguyễn Phước Lan, ven sông Cẩm Lệ</td><td>Giao lộ Nguyễn Đình Thi – 29/3, gần sông Hàn</td></tr>
<tr><td>Quy mô</td><td>2 tòa, 25 tầng, <strong>1.342 căn</strong> (theo công bố CĐT)</td><td>2 tòa, ~22 tầng*</td><td>2 tòa, ~22 tầng, ~792 căn*</td></tr>
<tr><td>Sản phẩm</td><td>Studio → 3PN, sân vườn, penthouse, shophouse</td><td>Studio → duplex, shophouse*</td><td>Studio → 3PN, penthouse, shophouse*</td></tr>
<tr><td>Pháp lý</td><td>Sổ đỏ từng lô, VB 7117/SXD-QLN, bảo lãnh VietinBank</td><td colspan="2">Theo công bố riêng của từng dự án</td></tr>
</tbody></table>
<p class="note">* Số liệu Spana Tower và S-Light Tower tổng hợp từ thông tin thị trường, chỉ mang tính tham khảo.</p>

<h3 id="sun-vi-sao-cora">Vì sao nhiều khách chọn Cora Tower?</h3>
<ul>
<li><strong>Pháp lý công khai đầy đủ</strong>: sổ đỏ, văn bản đủ điều kiện bán, bảo lãnh ngân hàng, hợp đồng mẫu đã đăng ký – xem tại <a href="phap-ly.html">trang Pháp lý</a>.</li>
<li><strong>Vị trí vòng xoay</strong> – điểm nhận diện của cả khu đô thị, hạ tầng đã xong.</li>
<li><strong>Đủ loại sản phẩm</strong>: từ studio ~32 m² đến <a href="penthouse.html">penthouse trần 7 m</a> và <a href="khoi-de-shophouse.html">shophouse khối đế sở hữu lâu dài</a>.</li>
<li><strong>Tiện ích riêng từng tòa</strong> ở tầng 2: hồ bơi trong nhà, Jjimjilbang, gym, golf mô phỏng, khu trẻ em, thư viện.</li>
</ul>

<h3 id="sun-gia">Giá căn hộ Sun Đà Nẵng tại Cora Tower</h3>
<p>Căn 1PN+ tầng 15 khoảng <strong>3,1 – 3,85 tỷ</strong>, shophouse 43 – 61,5 m² khoảng <strong>4,96 – 6,04 tỷ</strong>. Vay tối đa 70%, hỗ trợ lãi suất 0% trong 24 tháng, Sun Early Key thanh toán 70% nhận nhà. Xem <a href="./#gia">bảng giá Cora Tower</a>.</p>

<h3 id="sun-quy-trinh">Quy trình mua căn hộ Sun</h3>
<ol>
<li>Nhận giỏ hàng, mặt bằng, chọn căn theo tầng – hướng – ngân sách.</li>
<li>Đặt chỗ, ký hợp đồng thỏa thuận nguyên tắc, chuẩn bị hồ sơ vay.</li>
<li>Ký hợp đồng mua bán theo thông báo của chủ đầu tư, thanh toán theo tiến độ.</li>
<li>Nhận bàn giao, hoàn thiện nội thất.</li>
</ol>
{CTA}'''
SUN_FAQ = [
    ("Căn hộ Sun Đà Nẵng nào đã đủ điều kiện bán?", "Cora Tower (lô A2-19, A2-20) có văn bản 7117/SXD-QLN ngày 05/5/2026 của Sở Xây dựng Đà Nẵng về điều kiện nhà ở hình thành trong tương lai đưa vào kinh doanh, kèm bảo lãnh VietinBank."),
    ("Căn hộ Sun Đà Nẵng giá bao nhiêu?", "Tại Cora Tower, căn 1PN+ tầng 15 khoảng 3,1 – 3,85 tỷ/căn; giá thay đổi theo tầng, hướng và đợt chính sách."),
    ("Mua căn hộ Sun Đà Nẵng được vay bao nhiêu?", "Ngân hàng cho vay tối đa 70% giá trị, hỗ trợ lãi suất 0% trong 24 tháng; có chương trình Sun Early Key thanh toán 70% nhận nhà."),
    ("Sun Neo City ở đâu?", "Sun Neo City là Khu đô thị sinh thái ven sông Hòa Xuân, phường Hòa Xuân, TP Đà Nẵng – khu Nam trung tâm thành phố."),
]
