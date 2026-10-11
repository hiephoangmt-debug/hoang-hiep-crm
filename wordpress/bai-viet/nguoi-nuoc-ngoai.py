import json
from PIL import Image, ImageDraw, ImageFont
slug = 'du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026'
title = 'Dự án người nước ngoài được mua tại Đà Nẵng 2026: danh sách, số căn và dự án đang mở bán'
L = lambda s, t: f'<a href="/du-an/{s}/">{t}</a>'
import urllib.parse
M = lambda q: f'<a href="https://www.google.com/maps/search/?api=1&amp;query={urllib.parse.quote(q)}" target="_blank" rel="noopener nofollow">Xem</a>'
content = f"""<p>Người nước ngoài được mua căn hộ ở những dự án nào tại Đà Nẵng? Từ khi Luật Nhà ở 2023 có hiệu lực (1/8/2024), Sở Xây dựng và UBND TP Đà Nẵng đã công bố nhiều đợt danh mục <strong>dự án nhà ở thương mại cho phép tổ chức, cá nhân nước ngoài sở hữu</strong>. Mỗi dự án có số căn tối đa riêng. Hiệp tổng hợp đầy đủ danh sách đến tháng 10/2026, kèm các dự án đang có hàng để bán.</p>

<!--hh-featured-->

<h2>Người nước ngoài mua nhà tại Đà Nẵng: 4 quy định chính</h2>
<ul>
<li><strong>Được mua:</strong> căn hộ và nhà ở riêng lẻ trong dự án nhà ở thương mại đã được công bố cho phép người nước ngoài sở hữu, ngoài khu vực bảo đảm quốc phòng, an ninh.</li>
<li><strong>Hạn mức:</strong> tối đa 30% số căn hộ của một tòa nhà. Nhà ở riêng lẻ tối đa 250 căn trên khu vực có dân số tương đương một phường. Giao dịch vượt hạn mức không có giá trị pháp lý.</li>
<li><strong>Thời hạn:</strong> tối đa 50 năm kể từ ngày cấp giấy chứng nhận, được gia hạn theo quy định. Người Việt mua cùng căn hộ thì được sở hữu lâu dài.</li>
<li><strong>Rủi ro cần biết:</strong> nếu khu vực dự án sau này được xác định thuộc diện bảo đảm quốc phòng, an ninh, chủ đầu tư phải dừng bán và xử lý hợp đồng đã ký với người nước ngoài.</li>
</ul>

<h2>Danh sách dự án được bán cho người nước ngoài tại Đà Nẵng (từ 2024)</h2>
<p>Tên dự án ghi theo văn bản công bố của UBND/Sở Xây dựng, tên thương mại trong ngoặc. Bấm "Xem" để mở vị trí trên Google Maps.</p>
<table>
<thead><tr><th>Đợt</th><th>Dự án (theo văn bản)</th><th>Vị trí · Chủ đầu tư</th><th>Số căn tối đa cho người nước ngoài</th><th>Bản đồ</th></tr></thead>
<tbody>
<tr><td>Đợt 4<br>11/2024</td><td>Olalani Riverside Towers</td><td>Nại Hiên Đông, Sơn Trà · CTCP Mỹ Phúc</td><td>427 căn hộ + 87 nhà ở riêng lẻ</td><td>{M('Olalani Riverside Towers Đà Nẵng')}</td></tr>
<tr><td>Đợt 4<br>11/2024</td><td>Tòa nhà chung cư tại khu đất B4-1 và B4-2 thuộc dự án Khu dịch vụ du lịch ven sông Hàn (The Panoma)</td><td>Mỹ An, Ngũ Hành Sơn · CTCP Thương mại Du lịch Đầu tư Cù Lao Chàm (Sun Group)</td><td>203 căn hộ (trên 679 căn)</td><td>{M('The Panoma Đà Nẵng')}</td></tr>
<tr><td>Đợt 4<br>11/2024</td><td>Khu đô thị ven sông Hòa Quý – Đồng Nò</td><td>Hòa Quý, Ngũ Hành Sơn · CTCP Địa Cầu</td><td>250 biệt thự (trên 390 căn)</td><td>{M('Khu đô thị ven sông Hòa Quý Đồng Nò Đà Nẵng')}</td></tr>
<tr><td>Đợt 4<br>11/2024</td><td>Khu đô thị thương mại và dịch vụ thể thao cao cấp New Town ({L('newtown-diamond-da-nang','Newtown')})</td><td>Hòa Hải, Ngũ Hành Sơn · Công ty TNHH Phát triển New Town</td><td>519 căn hộ + 250 biệt thự</td><td>{M('Newtown Diamond Đà Nẵng')}</td></tr>
<tr><td>Đợt 5<br>2/2025</td><td>Khu đô thị {L('capital-square-da-nang','Capital Square')} 2</td><td>An Hải Bắc, Sơn Trà · Công ty TNHH Mega Assets</td><td>502 căn (trên 1.681 căn)</td><td>{M('Capital Square Đà Nẵng')}</td></tr>
<tr><td>Đợt 5<br>2/2025</td><td>Khu đô thị Capital Square 3</td><td>An Hải Bắc, Sơn Trà · Công ty TNHH Bất động sản SIH</td><td>512 căn (trên 1.710 căn)</td><td>{M('Capital Square Đà Nẵng')}</td></tr>
<tr><td>Đợt 6<br>2/2026</td><td>Khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn ({L('masteri-da-nang','Masteri Rivera Danang')})</td><td>Đường Quy Mỹ, Hòa Cường · CTCP Phát triển nhà Tuyên Sơn</td><td>332 căn (trên 1.112 căn, mỗi tháp 166 căn)</td><td>{M('Masteri Rivera Danang')}</td></tr>
<tr><td>Đợt 7<br>2026</td><td>Tháp ven sông (The Royal Đà Nẵng)</td><td>Ven sông Hàn · Công ty TNHH MTV The Royal Đà Nẵng</td><td>Theo văn bản công bố</td><td>{M('The Royal Đà Nẵng')}</td></tr>
<tr><td>Đợt 7<br>2026</td><td>Khu phức hợp Trung tâm thương mại – Căn hộ điểm nhấn Đà Nẵng ({L('danang-landmark','DaNang Landmark')})</td><td>Ven sông Hàn · CTCP Cosmos Housing</td><td>Theo văn bản công bố</td><td>{M('Danang Landmark Tower Đà Nẵng')}</td></tr>
</tbody>
</table>
<p><em>Số căn là mức tối đa được phép bán cho người nước ngoài, không phải số căn còn trống. Số còn lại phải hỏi chủ đầu tư tại thời điểm mua.</em></p>

<h2>Dự án nào đang có hàng để mua?</h2>
<p>Theo tin rao tuần 5 – 11/10/2026 (xem <a href="/gia-nha-dat-da-nang-tuan-5-11-10-2026/">giá nhà đất Đà Nẵng tuần này</a>):</p>
<ul>
<li><strong>{L('capital-square-da-nang','Capital Square')} (Sơn Trà):</strong> căn 1 – 2PN rao 3,26 – 4,8 tỷ, khoảng 54 – 74 triệu/m², view sông Hàn. Chủ đầu tư có chính sách lãi suất 0% 24 tháng.</li>
<li><strong>{L('masteri-da-nang','Masteri Rivera Danang')} (Hải Châu):</strong> 2 tháp 39 tầng ven sông Hàn, room 332 căn cho người nước ngoài – liên hệ để kiểm tra căn còn trống.</li>
<li><strong>{L('newtown-diamond-da-nang','Newtown Diamond')} (Ngũ Hành Sơn):</strong> căn 1PN trực diện biển rao khoảng 2,8 tỷ (khoảng 80 triệu/m²).</li>
<li><strong>{L('danang-landmark','Danang Landmark')} (Hải Châu):</strong> căn hạng sang ven sông Hàn, mới được bổ sung vào danh mục năm 2026.</li>

</ul>
<p>Về {L('sun-symphony-residence','Sun Symphony Residence')}: một số đơn vị phân phối giới thiệu dự án đã được phép bán cho người nước ngoài. Hiệp chưa tìm thấy văn bản công bố này trên báo chí chính thống, nên chưa đưa vào bảng. Nếu quan tâm, liên hệ để Hiệp kiểm tra hồ sơ trực tiếp với chủ đầu tư.</p>

<h2>Các dự án trong danh sách cũ (trước 2024)</h2>
<p>Trước Luật Nhà ở 2023, Đà Nẵng từng công bố 17 dự án cho phép người nước ngoài sở hữu. Trong đó có Blooming Tower, Golden Square, P.A Tower, Lapaz Tower, Danang Plaza, HAGL Lakeview, Monarchy, Harmony Tower, The Summit, An Viên, Azura, khu đô thị Thủy Tú và {L('fpt-city-da-nang','FPT City Đà Nẵng')}. Ngoài ra có Tổ hợp khách sạn và căn hộ cao cấp Duyên hải Miền Trung (Central Coast, Công ty TNHH Dịch vụ Du lịch và Thương mại Minh Đông) được phép bán tối đa 102 căn cho người nước ngoài. Phần lớn đã bàn giao. Người nước ngoài mua lại (thứ cấp) cần kiểm tra tòa nhà còn trong hạn mức 30% hay không.</p>
<p>Cùng đợt đó, 3 dự án được công bố <strong>không cho phép</strong> người nước ngoài sở hữu: chung cư F-Home, Danang Diamond Tower và Indochina Riverside Tower.</p>

<h2>Checklist cho người nước ngoài trước khi đặt cọc</h2>
<ol>
<li>Dự án có trong danh mục công bố của UBND/Sở Xây dựng Đà Nẵng không, tòa/căn định mua còn trong hạn mức (room) không?</li>
<li>Hộ chiếu có thị thực hoặc dấu nhập cảnh hợp lệ tại thời điểm ký hợp đồng.</li>
<li>Thanh toán qua ngân hàng tại Việt Nam, giữ chứng từ để chuyển tiền ra nước ngoài sau này.</li>
<li>Kiểm tra pháp lý dự án: đủ điều kiện bán, bảo lãnh ngân hàng, hợp đồng mẫu. Xem cách kiểm tra: <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</li>
<li>Phân biệt căn hộ để ở với căn hộ du lịch (condotel) trên đất thương mại dịch vụ – hai loại có quy định khác nhau: <a href="/can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam/">căn hộ sở hữu lâu dài hay căn hộ 50 năm</a>.</li>
</ol>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Từ 2024 đến nay, Đà Nẵng mở room cho người nước ngoài chủ yếu ở các dự án ven sông Hàn (Capital Square, Masteri Rivera, The Royal, Danang Landmark, The Panoma) và ven biển Ngũ Hành Sơn (New Town, Hòa Quý – Đồng Nò). Đây đều là vị trí khách quốc tế ưa chuộng để ở và cho thuê. Room 30% mỗi tòa có giới hạn: căn đẹp, tầng cao view sông thường được khách nước ngoài chọn trước. Nếu anh chị có bạn bè, đối tác nước ngoài muốn mua, nên kiểm tra room và chọn căn sớm.</p>
<p>Hiệp hỗ trợ khách nước ngoài bằng tiếng Anh và tiếng Hàn: <a href="/en/">trang tiếng Anh</a> · <a href="/ko/">한국어 페이지</a>. Liên hệ <strong>0904 567 009</strong> (Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': '9 dự án người nước ngoài được mua tại Đà Nẵng theo các đợt công bố 4 – 7 (11/2024 – 2026): Capital Square 2, 3, Masteri Rivera, New Town, Olalani, The Royal, DaNang Landmark… kèm số căn tối đa, bản đồ và dự án đang có hàng.',
 'keyword': 'người nước ngoài mua nhà Đà Nẵng',
 'keywords_extra': ['dự án cho người nước ngoài sở hữu Đà Nẵng', 'căn hộ cho người nước ngoài Đà Nẵng', 'người nước ngoài sở hữu nhà ở Đà Nẵng'],
 'category': 'Kinh nghiệm mua bán',
 'tags': ['Bất động sản Đà Nẵng', 'Người nước ngoài mua nhà', 'Pháp lý bất động sản', 'Căn hộ Đà Nẵng', 'Luật Nhà ở 2023'],
 'content': content,
 'seo': {
  'seo_title': 'Người nước ngoài mua nhà Đà Nẵng: 9 dự án được bán 2026',
  'desc': 'Người nước ngoài mua nhà Đà Nẵng ở dự án nào? 9 dự án được phép bán (đợt 4 – 7), số căn tối đa, quy định 30%, 50 năm và dự án đang có hàng.',
 },
 'sources': ['https://vnexpress.net/them-du-an-chung-cu-o-da-nang-duoc-ban-cho-nguoi-nuoc-ngoai-5042668.html', 'https://doanhnhan.baophapluat.vn/da-nang-cong-bo-2-du-an-nha-o-thuong-mai-cho-phep-nguoi-nuoc-ngoai-so-huu.html', 'https://doanhnhan.baophapluat.vn/da-nang-cho-phep-nguoi-nuoc-ngoai-so-huu-332-can-ho-tai-du-an-tuyen-son.html', 'https://vnexpress.net/da-nang-co-them-1-000-can-ho-duoc-ban-cho-nguoi-nuoc-ngoai-4853706.html', 'https://vietnamnet.vn/danh-sach-4-du-an-nha-o-tai-da-nang-nguoi-nuoc-ngoai-duoc-so-huu-2345743.html', 'https://congluan.vn/da-nang-co-them-mot-du-an-duoc-phep-ban-cho-nguoi-nuoc-ngoai-post117618.html', 'https://vnexpress.net/17-du-an-cho-nguoi-nuoc-ngoai-so-huu-o-da-nang-4262385.html'],
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
rows = [('Capital Square 2 · 3', '502 + 512 căn'), ('New Town', '519 căn hộ + 250 biệt thự'), ('Olalani Riverside', '427 căn hộ + 87 nhà'), ('Masteri Rivera (Tuyên Sơn)', '332 căn'), ('Hòa Quý – Đồng Nò', '250 biệt thự'), ('The Panoma (B4-1, B4-2)', '203 căn'), ('The Royal · Danang Landmark', 'mới công bố 2026')]
y = 168
for k, v in rows:
    d.rounded_rectangle([48, y, W - 48, y + 46], 8, fill='white', outline='#e0d6c8')
    d.text((68, y + 11), k, font=f(21, True), fill='#1f3a50')
    d.text((640, y + 11), v, font=f(21), fill='#c2410c')
    y += 54
d.text((48, 638), 'Tối đa 30% căn mỗi tòa · sở hữu 50 năm, được gia hạn', font=f(17), fill='#6b5a48')
d.text((W - 48 - d.textlength('hiephoangmt.com', font=f(18, True)), 636), 'hiephoangmt.com', font=f(18, True), fill='#1f3a50')
im.save(slug + '.jpg', quality=88)
