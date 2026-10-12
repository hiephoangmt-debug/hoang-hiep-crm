import json
from PIL import Image, ImageDraw, ImageFont
slug = 'du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026'
title = 'Dự án người nước ngoài được mua tại Đà Nẵng: danh sách đầy đủ đợt 1 – 7 (2021 – 2026)'
L = lambda s, t: f'<a href="/du-an/{s}/">{t}</a>'
X = lambda s: f'<a href="/du-an/{s}/">Xem dự án</a>'
import urllib.parse
M = lambda q: f'<a href="https://www.google.com/maps/search/?api=1&amp;query={urllib.parse.quote(q)}" target="_blank" rel="noopener nofollow">Bản đồ</a>'
content = f"""<p>Người nước ngoài được mua căn hộ ở những dự án nào tại Đà Nẵng? Từ khi Luật Nhà ở 2023 có hiệu lực (1/8/2024), Sở Xây dựng và UBND TP Đà Nẵng đã công bố nhiều đợt danh mục <strong>dự án nhà ở thương mại cho phép tổ chức, cá nhân nước ngoài sở hữu</strong>. Mỗi dự án có số căn tối đa riêng. Hiệp tổng hợp đầy đủ danh sách đến tháng 10/2026, kèm các dự án đang có hàng để bán.</p>

<!--hh-featured-->

<h2>Người nước ngoài mua nhà tại Đà Nẵng: 4 quy định chính</h2>
<ul>
<li><strong>Được mua:</strong> căn hộ và nhà ở riêng lẻ trong dự án nhà ở thương mại đã được công bố cho phép người nước ngoài sở hữu, ngoài khu vực bảo đảm quốc phòng, an ninh.</li>
<li><strong>Hạn mức:</strong> tối đa 30% số căn hộ của một tòa nhà. Nhà ở riêng lẻ tối đa 250 căn trên khu vực có dân số tương đương một phường. Giao dịch vượt hạn mức không có giá trị pháp lý.</li>
<li><strong>Thời hạn:</strong> tối đa 50 năm kể từ ngày cấp giấy chứng nhận, được gia hạn theo quy định. Người Việt mua cùng căn hộ thì được sở hữu lâu dài.</li>
<li><strong>Rủi ro cần biết:</strong> nếu khu vực dự án sau này được xác định thuộc diện bảo đảm quốc phòng, an ninh, chủ đầu tư phải dừng bán và xử lý hợp đồng đã ký với người nước ngoài.</li>
</ul>

<h2>Tổng quan các đợt công bố</h2>
<table>
<thead><tr><th>Đợt</th><th>Thời điểm · Căn cứ</th><th>Số dự án</th></tr></thead>
<tbody>
<tr><td>Đợt 1</td><td>4/2021 · Luật Nhà ở 2014, Nghị định 99/2015</td><td>17 dự án (và 3 dự án không cho phép)</td></tr>
<tr><td>Đợt 2, 3</td><td>2021 – 2024 · bổ sung từng dự án</td><td>Trong đó có Central Coast</td></tr>
<tr><td>Đợt 4</td><td>11/2024 · Luật Nhà ở 2023, Nghị định 95/2024</td><td>4 dự án</td></tr>
<tr><td>Đợt 5</td><td>2/2025</td><td>2 dự án</td></tr>
<tr><td>Đợt 6</td><td>2/2026</td><td>1 dự án</td></tr>
<tr><td>Đợt 7</td><td>4/2026 · Văn bản 2381/UBND-SXD (theo đề nghị của Sở Xây dựng tại Công văn 23/SXD-QLN ngày 13/3/2026)</td><td>2 dự án</td></tr>
</tbody>
</table>

<h2>Dự án được bán cho người nước ngoài theo luật mới (đợt 4 – 7)</h2>
<p>Ghi theo dạng <strong>tên thương mại (tên trong văn bản công bố)</strong>. Văn bản của Sở chỉ ghi tên pháp lý; tên thương mại Hiệp đối chiếu theo vị trí, chủ đầu tư và số căn do chủ đầu tư công bố.</p>
<table>
<thead><tr><th>Đợt</th><th>Dự án</th><th>Vị trí · Chủ đầu tư</th><th>Số căn tối đa cho người nước ngoài</th><th>Tìm hiểu</th></tr></thead>
<tbody>
<tr><td>4 · 11/2024</td><td>{L('sun-symphony-residence','Sun Symphony Residence')} (Olalani Riverside Towers)</td><td>Nại Hiên Đông, Sơn Trà · CTCP Mỹ Phúc (Sun Group)</td><td>427 căn hộ + 87 nhà ở riêng lẻ</td><td>{X('sun-symphony-residence')} · {M('Sun Symphony Residence Đà Nẵng')}</td></tr>
<tr><td>4 · 11/2024</td><td>{L('sun-cosmo-residence','Sun Cosmo Residence')} – The Panoma (Tòa chung cư khu đất B4-1, B4-2, Khu dịch vụ du lịch ven sông Hàn)</td><td>Mỹ An, Ngũ Hành Sơn · CTCP TM Du lịch Đầu tư Cù Lao Chàm (Sun Group)</td><td>203 căn hộ (trên 679 căn)</td><td>{X('sun-cosmo-residence')} · {M('Sun Cosmo Residence Đà Nẵng')}</td></tr>
<tr><td>4 · 11/2024</td><td>Sunneva Island (Khu đô thị ven sông Hòa Quý – Đồng Nò)</td><td>Hòa Quý, Ngũ Hành Sơn · CTCP Địa Cầu</td><td>250 biệt thự (trên 390 căn)</td><td>{M('Sunneva Island Đà Nẵng')}</td></tr>
<tr><td>4 · 11/2024</td><td>{L('newtown-diamond-da-nang','Newtown')} (Khu đô thị thương mại và dịch vụ thể thao cao cấp New Town)</td><td>Hòa Hải, Ngũ Hành Sơn · Công ty TNHH Phát triển New Town</td><td>519 căn hộ + 250 biệt thự</td><td>{X('newtown-diamond-da-nang')} · {M('Newtown Diamond Đà Nẵng')}</td></tr>
<tr><td>5 · 2/2025</td><td>{L('capital-square-da-nang','Capital Square')} 2 (Khu đô thị Capital Square 2)</td><td>Ngô Quyền, An Hải · Công ty TNHH Mega Assets</td><td>502 căn (trên 1.681 căn)</td><td>{X('capital-square-da-nang')} · {M('Capital Square Đà Nẵng')}</td></tr>
<tr><td>5 · 2/2025</td><td>Capital Square 3 (Khu đô thị Capital Square 3)</td><td>Ngô Quyền, An Hải · Công ty TNHH Bất động sản SIH</td><td>512 căn (trên 1.710 căn)</td><td>{X('capital-square-da-nang')} · {M('Capital Square Đà Nẵng')}</td></tr>
<tr><td>6 · 2/2026</td><td>{L('masteri-da-nang','Masteri Rivera Danang')} (Khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn)</td><td>Quy Mỹ, Hòa Cường · CTCP Phát triển nhà Tuyên Sơn</td><td>332 căn (trên 1.112 căn, mỗi tháp 166 căn)</td><td>{X('masteri-da-nang')} · {M('Masteri Rivera Danang')}</td></tr>
<tr><td>7 · 4/2026</td><td>The Royal Boutique Hotel &amp; Condo Da Nang (Tháp ven sông)</td><td>Bạch Đằng, Hải Châu · Công ty TNHH MTV The Royal Đà Nẵng</td><td>Theo văn bản công bố</td><td>{M('The Royal Đà Nẵng Bạch Đằng')}</td></tr>
<tr><td>7 · 4/2026</td><td>{L('danang-landmark','Đà Nẵng Landmark Tower')} (Khu phức hợp TTTM – căn hộ điểm nhấn Đà Nẵng)</td><td>Ven sông Hàn, cạnh công viên APEC · CTCP Cosmos Housing</td><td>Theo văn bản công bố</td><td>{X('danang-landmark')} · {M('Danang Landmark Tower Đà Nẵng')}</td></tr>
</tbody>
</table>
<p><em>Số căn là mức tối đa được bán cho người nước ngoài, không phải số căn còn trống – phải hỏi chủ đầu tư tại thời điểm mua.</em></p>

<h2>Đợt 1 (4/2021): 17 dự án và các dự án bổ sung</h2>
<p>Danh sách theo Luật Nhà ở 2014. Phần lớn đã bàn giao, người nước ngoài mua lại (thứ cấp) cần kiểm tra tòa nhà còn trong hạn mức 30% hay không.</p>
<table>
<thead><tr><th>Khu vực</th><th>Dự án</th></tr></thead>
<tbody>
<tr><td>Hải Châu</td><td>Blooming Tower Đà Nẵng · Golden Square · Chung cư thương mại Quang Nguyễn · P.A Tower · Lapaz Tower (38 Nguyễn Chí Thanh) · Danang Plaza (6 Nguyễn Du)</td></tr>
<tr><td>Sơn Trà</td><td>HAGL Lakeview · Khu đô thị Thủy Tú · Monarchy · Harmony Tower · The Summit · Khu phức hợp Hòa Bình Xanh Đà Nẵng · Khu căn hộ Tháp Vườn · Bất động sản và Bến du thuyền Đà Nẵng</td></tr>
<tr><td>Ngũ Hành Sơn, Liên Chiểu…</td><td>Khu dân cư An Viên · Azura · {L('fpt-city-da-nang','Khu đô thị công nghệ FPT Đà Nẵng')}</td></tr>
<tr><td>Bổ sung (đợt 2)</td><td>Tổ hợp khách sạn và căn hộ cao cấp Duyên hải Miền Trung (Central Coast) – Công ty TNHH Dịch vụ Du lịch và Thương mại Minh Đông, tối đa 102 căn trên 340 căn</td></tr>
</tbody>
</table>
<p><em>Khu vực của từng dự án đợt 1 ghi theo địa chỉ thông dụng, có thể thay đổi sau sắp xếp phường năm 2025.</em></p>

<h2>Dự án KHÔNG cho phép người nước ngoài sở hữu</h2>
<ul>
<li><strong>{L('vinhomes-hai-van-bay','Vinhomes Hải Vân Bay (Làng Vân)')}:</strong> Sở Xây dựng xác định dự án thuộc khu vực không cho phép tổ chức, cá nhân nước ngoài sở hữu nhà ở (khi xác nhận 2.437 căn thấp tầng đủ điều kiện bán, 4/2026). Một số trang quảng cáo ghi "50 năm cho người nước ngoài" – không đúng với văn bản của Sở.</li>
<li><strong>Chung cư F-Home, Danang Diamond Tower, Indochina Riverside Tower</strong> (công bố đợt 1, 2021).</li>
</ul>

<h2>Dự án nào đang có hàng để mua?</h2>
<p>Theo tin rao tuần 5 – 11/10/2026 (xem <a href="/gia-nha-dat-da-nang-tuan-5-11-10-2026/">giá nhà đất Đà Nẵng tuần này</a>):</p>
<ul>
<li><strong>{L('sun-symphony-residence','Sun Symphony Residence')}:</strong> căn 2 – 3PN 5,7 – 13,3 tỷ, 67 – 129 triệu/m², view sông Hàn – room 427 căn hộ cho người nước ngoài.</li>
<li><strong>{L('capital-square-da-nang','Capital Square')}:</strong> căn 1 – 2PN 3,26 – 4,8 tỷ, 54 – 74 triệu/m², chủ đầu tư có chính sách lãi suất 0% 24 tháng.</li>
<li><strong>{L('newtown-diamond-da-nang','Newtown Diamond')}:</strong> căn 1PN trực diện biển khoảng 2,8 tỷ (khoảng 80 triệu/m²).</li>
<li><strong>{L('danang-landmark','Danang Landmark')}:</strong> căn hạng sang ven sông Hàn, 454 căn đủ điều kiện bán.</li>
<li><strong>{L('masteri-da-nang','Masteri Rivera Danang')}:</strong> 2 tháp 39 tầng ven sông Hàn – liên hệ để kiểm tra căn còn trống trong room 332 căn.</li>
</ul>

<h2>Checklist cho người nước ngoài trước khi đặt cọc</h2>
<ol>
<li>Dự án có trong danh mục công bố của UBND/Sở Xây dựng Đà Nẵng không, tòa/căn định mua còn trong hạn mức (room) không?</li>
<li>Hộ chiếu có thị thực hoặc dấu nhập cảnh hợp lệ tại thời điểm ký hợp đồng.</li>
<li>Thanh toán qua ngân hàng tại Việt Nam, giữ chứng từ để chuyển tiền ra nước ngoài sau này.</li>
<li>Kiểm tra pháp lý dự án: đủ điều kiện bán, bảo lãnh ngân hàng, hợp đồng mẫu. Xem cách kiểm tra: <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</li>
<li>Phân biệt căn hộ để ở với căn hộ du lịch (condotel) trên đất thương mại dịch vụ – hai loại có quy định khác nhau: <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">căn hộ sở hữu lâu dài hay căn hộ 50 năm</a>.</li>
</ol>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Theo luật mới, Đà Nẵng mở room cho người nước ngoài chủ yếu ở các dự án ven sông Hàn (Sun Symphony, Sun Cosmo, Capital Square, Masteri Rivera, The Royal, Danang Landmark) và ven biển Ngũ Hành Sơn (Newtown, Sunneva Island). Đáng chú ý, 3 dự án của Sun Group nằm trong danh sách đợt 4. Room 30% mỗi tòa có giới hạn: căn đẹp, tầng cao view sông thường được khách nước ngoài chọn trước. Nếu anh chị có bạn bè, đối tác nước ngoài muốn mua, nên kiểm tra room và chọn căn sớm – và tránh các dự án không được phép như Vinhomes Hải Vân Bay.</p>
<p>Hiệp hỗ trợ khách nước ngoài bằng tiếng Anh và tiếng Hàn: <a href="/en/">trang tiếng Anh</a> · <a href="/ko/">한국어 페이지</a>. Liên hệ <strong>0904 567 009</strong> (Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Danh sách đầy đủ dự án người nước ngoài được mua tại Đà Nẵng (đợt 1 – 7, 2021 – 2026): Sun Symphony, Sun Cosmo, Sunneva Island, Newtown, Capital Square, Masteri Rivera, The Royal, Danang Landmark… số căn tối đa, link dự án, bản đồ và dự án không được phép.',
 'keyword': 'người nước ngoài mua nhà Đà Nẵng',
 'keywords_extra': ['dự án cho người nước ngoài sở hữu Đà Nẵng', 'căn hộ cho người nước ngoài Đà Nẵng', 'người nước ngoài sở hữu nhà ở Đà Nẵng'],
 'category': 'Kinh nghiệm mua bán',
 'tags': ['Bất động sản Đà Nẵng', 'Người nước ngoài mua nhà', 'Pháp lý bất động sản', 'Căn hộ Đà Nẵng', 'Luật Nhà ở 2023'],
 'content': content,
 'seo': {
  'seo_title': 'Người nước ngoài mua nhà Đà Nẵng: danh sách dự án 2026',
  'desc': 'Người nước ngoài mua nhà Đà Nẵng ở dự án nào? Danh sách đợt 1 – 7: Sun Symphony, Capital Square, Masteri, Newtown… số căn tối đa, dự án không được phép.',
 },
 'sources': ['https://znews.vn/hon-2400-can-thap-tang-tai-du-an-lang-van-du-dieu-kien-mo-ban-post1643245.html', 'https://vov.vn/kinh-te/bat-dong-san/nguoi-nuoc-ngoai-duoc-so-huu-nha-o-tai-nhung-du-an-nao-tai-da-nang-849985.vov', 'https://cttdt.danangportal.gov.vn/vi/web/dng/w/cong-bo-danh-muc-du-an-dau-tu-xay-dung-nha-o-thuong-mai-cho-phep-to-chuc-ca-nhan-nuoc-ngoai-duoc-so-huu-nha-o-tren-dia-ban-thanh-pho-da-nang-dot-4-i', 'https://danang.gov.vn/vi/web/dng/w/cong-bo-danh-muc-du-an-dau-tu-xay-dung-nha-o-thuong-mai-cho-phep-to-chuc-ca-nhan-nuoc-ngoai-duoc-so-huu-nha-o-tren-dia-ban-thanh-pho-da-nang-dot-7', 'https://vnexpress.net/them-du-an-chung-cu-o-da-nang-duoc-ban-cho-nguoi-nuoc-ngoai-5042668.html', 'https://doanhnhan.baophapluat.vn/da-nang-cong-bo-2-du-an-nha-o-thuong-mai-cho-phep-nguoi-nuoc-ngoai-so-huu.html', 'https://doanhnhan.baophapluat.vn/da-nang-cho-phep-nguoi-nuoc-ngoai-so-huu-332-can-ho-tai-du-an-tuyen-son.html', 'https://vnexpress.net/da-nang-co-them-1-000-can-ho-duoc-ban-cho-nguoi-nuoc-ngoai-4853706.html', 'https://vietnamnet.vn/danh-sach-4-du-an-nha-o-tai-da-nang-nguoi-nuoc-ngoai-duoc-so-huu-2345743.html', 'https://congluan.vn/da-nang-co-them-mot-du-an-duoc-phep-ban-cho-nguoi-nuoc-ngoai-post117618.html', 'https://vnexpress.net/17-du-an-cho-nguoi-nuoc-ngoai-so-huu-o-da-nang-4262385.html'],
 'follow_sources': False,
 'image': {'name': slug, 'alt': 'Dự án người nước ngoài được mua tại Đà Nẵng 2026 và số căn tối đa', 'caption': 'Đồ hoạ: hiephoangmt.com, tổng hợp danh mục UBND/Sở Xây dựng Đà Nẵng đến 10/2026.'},
}
json.dump(n, open('nguoi-nuoc-ngoai.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

W, H = 1200, 675
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 150], fill='#1f3a50')
d.text((48, 24), 'NGƯỜI NƯỚC NGOÀI MUA NHÀ ĐÀ NẴNG · 10/2026', font=f(22, True), fill='#e8b04a')
d.text((48, 60), 'Dự án được bán & số căn tối đa', font=f(42, True), fill='white')
rows = [('Sun Symphony Residence', '427 căn hộ + 87 nhà'), ('Capital Square 2 · 3', '502 + 512 căn'), ('Newtown', '519 căn hộ + 250 biệt thự'), ('Masteri Rivera (Tuyên Sơn)', '332 căn'), ('Sunneva Island (Hòa Quý – Đồng Nò)', '250 biệt thự'), ('Sun Cosmo – The Panoma', '203 căn'), ('The Royal · Danang Landmark', 'đợt 7 · 4/2026')]
y = 168
for k, v in rows:
    d.rounded_rectangle([48, y, W - 48, y + 46], 8, fill='white', outline='#e0d6c8')
    d.text((68, y + 11), k, font=f(21, True), fill='#1f3a50')
    d.text((640, y + 11), v, font=f(21), fill='#c2410c')
    y += 54
d.text((48, 638), 'Tối đa 30% căn mỗi tòa · sở hữu 50 năm, được gia hạn', font=f(17), fill='#6b5a48')
d.text((W - 48 - d.textlength('hiephoangmt.com', font=f(18, True)), 636), 'hiephoangmt.com', font=f(18, True), fill='#1f3a50')
im.save(slug + '.jpg', quality=88)
