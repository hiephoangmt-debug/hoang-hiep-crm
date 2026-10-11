import json
from PIL import Image, ImageDraw, ImageFont
slug = 'du-an-da-nang-du-dieu-kien-mo-ban-2026'
title = 'Dự án Đà Nẵng đủ điều kiện mở bán: danh sách đầy đủ 2024 – 2026, số căn từng dự án'
L = lambda s, t: f'<a href="/du-an/{s}/">{t}</a>'
X = lambda s: f'<a href="/du-an/{s}/">Xem dự án →</a>'
content = f"""<p>Từ năm 2024 đến nay, Sở Xây dựng Đà Nẵng đã xác nhận hàng chục dự án <strong>đủ điều kiện bán nhà ở hình thành trong tương lai</strong>. Đợt mới nhất (tháng 6/2026) có <strong>12 dự án, gần 10.500 căn hộ và nhà liền kề</strong>. Hiệp tổng hợp đầy đủ các đợt, số căn được phép bán và link đến từng dự án để anh chị tìm hiểu.</p>

<!--hh-featured-->

<h2>Tổng quan các đợt công bố dự án đủ điều kiện mở bán</h2>
<table>
<thead><tr><th>Đợt</th><th>Số dự án</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>1/1 – 31/7/2024</td><td>7 dự án</td><td>Gần 5.000 sản phẩm, chủ yếu căn hộ Sơn Trà, Ngũ Hành Sơn, Hải Châu</td></tr>
<tr><td>1/8/2024 – 10/2025 (Luật Kinh doanh BĐS 2023)</td><td>10 dự án</td><td>Thêm FPT Plaza 4 (11/2025)</td></tr>
<tr><td>Đầu 2026</td><td>Từng dự án</td><td>Capital Square 2, Spana Tower</td></tr>
<tr><td>6/2026</td><td>12 dự án</td><td>Gần 10.500 căn; thêm Regal Complex, The Poet Residence</td></tr>
</tbody>
</table>

<h2>Đợt mới nhất 6/2026: 12 dự án, gần 10.500 căn</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí · Chủ đầu tư</th><th>Số căn đủ điều kiện bán</th><th>Tìm hiểu</th></tr></thead>
<tbody>
<tr><td>Tổ hợp TTTM, khách sạn và căn hộ Thành phố huyền thoại Đà Nẵng (The Legend City)</td><td>Chân cầu Rồng, An Hải · Công ty TNHH MTV VIPICO</td><td>800 căn hộ</td><td>{X('the-legend-da-nang')}</td></tr>
<tr><td>Khu đô thị Capital Square 3 – tháp MAT 7, 8, 9</td><td>Ngô Quyền, An Hải · CTCP Bất động sản SIH</td><td>750 căn hộ</td><td>{X('capital-square-da-nang')}</td></tr>
<tr><td>Tháp CT3 và CT7 – Đà Nẵng Times Square</td><td>Võ Nguyên Giáp, An Hải · CTCP Kim Long Nam</td><td>569 căn hộ</td><td>{X('times-square-da-nang')}</td></tr>
<tr><td>Khu phức hợp TTTM – căn hộ điểm nhấn Đà Nẵng (Danang Landmark)</td><td>Ven sông Hàn, Hòa Cường · CTCP Cosmos Housing</td><td>454 căn hộ</td><td>{X('danang-landmark')}</td></tr>
<tr><td>Khu đô thị sinh thái ven sông Hòa Xuân (Sun NeO City)</td><td>Hòa Xuân · Sun Group</td><td>Theo thông báo của Sở</td><td>{X('sun-neo-city')}</td></tr>
<tr><td>Chung cư Ánh Bình Minh</td><td>Đà Nẵng</td><td>Theo thông báo của Sở</td><td>–</td></tr>
<tr><td>Khu đô thị Thanh Hà (Phân khu 1)</td><td>Đà Nẵng</td><td>Theo thông báo của Sở</td><td>–</td></tr>
</tbody>
</table>
<p>Cùng thời gian, Sở xác nhận thêm:</p>
<table>
<thead><tr><th>Dự án</th><th>Vị trí · Chủ đầu tư</th><th>Số căn · Ngày xác nhận</th><th>Tìm hiểu</th></tr></thead>
<tbody>
<tr><td>Khu đô thị Capital Square 2 – tòa 2.1, 2.5, 2.7</td><td>Ngô Quyền, An Hải · Công ty TNHH Mega Assets</td><td>737 căn hộ · 2/2026</td><td>{X('capital-square-da-nang')}</td></tr>
<tr><td>Spana Tower – tòa S1, S2 (Khu đô thị sinh thái ven sông Hòa Xuân)</td><td>Chân cầu Hòa Xuân · Sun Group</td><td>VB 7111/SXD-QLN · 5/5/2026</td><td>{X('spana-tower')}</td></tr>
<tr><td>Regal Complex – tòa C1, C2 (20 tầng)</td><td>Hòa Hải, Ngũ Hành Sơn</td><td>683 căn hộ · 25/6/2026</td><td>–</td></tr>
<tr><td>Chung cư Hồ Xuân Hương (The Poet Residence)</td><td>CTCP Địa ốc Phúc Thanh An</td><td>263 căn hộ · 24/6/2026</td><td>–</td></tr>
<tr><td>Khu dịch vụ du lịch ven sông Hàn</td><td>An Hải · CTCP TM Du lịch Đầu tư Cù Lao Chàm</td><td>17 căn · 6/2026</td><td>–</td></tr>
<tr><td>Dự án Bất động sản và Bến du thuyền Đà Nẵng</td><td>Sơn Trà</td><td>4 nhà ở 3 tầng · 6/2026</td><td>–</td></tr>
</tbody>
</table>

<h2>Đợt 1/8/2024 – 10/2025: 10 dự án và FPT Plaza 4</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí · Chủ đầu tư</th><th>Số căn đủ điều kiện bán</th><th>Tìm hiểu</th></tr></thead>
<tbody>
<tr><td>Khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn (Masteri Rivera Danang)</td><td>Quy Mỹ, Hòa Cường · CTCP Phát triển nhà Tuyên Sơn</td><td>1.112 căn hộ</td><td>{X('masteri-da-nang')}</td></tr>
<tr><td>Tổ hợp căn hộ bên bờ sông Hàn</td><td>Sơn Trà · CTCP Tập đoàn Đông Đô</td><td>941 căn hộ</td><td>–</td></tr>
<tr><td>FPT Plaza 3</td><td>FPT City, Ngũ Hành Sơn · CTCP Đô thị FPT Đà Nẵng</td><td>837 căn hộ</td><td>{X('fpt-plaza-3')}</td></tr>
<tr><td>Khu đô thị du lịch Thủy Tú</td><td>Hải Vân · CTCP Tài chính và Phát triển doanh nghiệp (FBS)</td><td>695 căn (689 biệt thự, 6 liền kề)</td><td>–</td></tr>
<tr><td>Khu đô thị Capital Square 3 – tòa MAT 5-6</td><td>An Hải · CTCP Bất động sản SIH</td><td>586 căn hộ</td><td>{X('capital-square-da-nang')}</td></tr>
<tr><td>Khu đô thị Capital Square 2 – tòa A2.4, A2.6</td><td>An Hải · Công ty TNHH Mega Assets</td><td>530 căn hộ</td><td>{X('capital-square-da-nang')}</td></tr>
<tr><td>Khu đô thị Cồn Tiến (Casamia Balanca)</td><td>Hội An Đông · CTCP Đạt Phương Hội An</td><td>340 căn liền kề, song lập, biệt thự</td><td>{X('casamia-balanca-hoi-an')}</td></tr>
<tr><td>Mia Plaza</td><td>Liên Chiểu · CTCP Đầu tư Mia</td><td>167 căn</td><td>–</td></tr>
<tr><td>Dự án Bất động sản và Bến du thuyền Đà Nẵng</td><td>Sơn Trà</td><td>34 biệt thự</td><td>–</td></tr>
<tr><td>The Nam Khang Resort Residences</td><td>Ngũ Hành Sơn · CTCP The Nam Khang</td><td>18 biệt thự</td><td>–</td></tr>
<tr><td>FPT Plaza 4</td><td>FPT City, Ngũ Hành Sơn · CTCP Đô thị FPT Đà Nẵng</td><td>1.395 căn hộ · 11/2025</td><td>{X('fpt-plaza-4')}</td></tr>
</tbody>
</table>

<h2>Đợt 1/1 – 31/7/2024: 7 dự án</h2>
<table>
<thead><tr><th>Dự án (theo văn bản)</th><th>Tên thương mại · Vị trí</th><th>Số căn</th><th>Tìm hiểu</th></tr></thead>
<tbody>
<tr><td>Khu căn hộ cao tầng thuộc Khu đô thị New Town</td><td>Newtown · Hòa Hải, Ngũ Hành Sơn</td><td>1.733 căn hộ</td><td>{X('newtown-diamond-da-nang')}</td></tr>
<tr><td>Olalani Riverside Towers</td><td>Sun Symphony Residence · Nại Hiên Đông, Sơn Trà</td><td>1.425 căn hộ</td><td>{X('sun-symphony-residence')}</td></tr>
<tr><td>Tòa B4-1, B4-2 thuộc Khu dịch vụ du lịch ven sông Hàn</td><td>Sun Cosmo Residence (The Panoma) · Ngũ Hành Sơn</td><td>679 căn hộ</td><td>{X('sun-cosmo-residence')}</td></tr>
<tr><td>Khu căn hộ phía Đông đường Trần Hưng Đạo (Cù Lao Chàm)</td><td>Sun Ponte Residence · Sơn Trà</td><td>528 căn</td><td>{X('sun-ponte-residence')}</td></tr>
<tr><td>P.A Tower</td><td>Hải Châu</td><td>300 căn hộ</td><td>–</td></tr>
<tr><td>Nhà ở liền kề và biệt thự Tuyên Sơn</td><td>Hải Châu</td><td>219 căn</td><td>–</td></tr>
<tr><td>Chung cư Bắc Cường (Bac Cuong Tower)</td><td>Hải Châu</td><td>112 căn hộ</td><td>–</td></tr>
</tbody>
</table>
<p><em>Tên thương mại ghép theo vị trí, chủ đầu tư và số căn trùng khớp với thông tin chủ đầu tư công bố. Văn bản của Sở chỉ ghi tên pháp lý.</em></p>

<h2>"Đủ điều kiện bán" có ý nghĩa gì với người mua?</h2>
<p>Theo Luật Kinh doanh bất động sản 2023, chủ đầu tư chỉ được ký hợp đồng mua bán nhà ở hình thành trong tương lai khi:</p>
<ul>
<li>Sở Xây dựng có <strong>văn bản xác nhận nhà ở đủ điều kiện được bán</strong>.</li>
<li>Có <strong>bảo lãnh của ngân hàng thương mại</strong> cho nghĩa vụ tài chính của chủ đầu tư với khách hàng – nếu chủ đầu tư không bàn giao đúng cam kết, ngân hàng hoàn tiền cho khách.</li>
<li>Dự án hoặc căn nhà đang thế chấp phải được <strong>giải chấp</strong> trước khi ký hợp đồng mua bán.</li>
<li>Tiền đặt cọc tối đa 5% giá bán. Lần thanh toán đầu (gồm cọc) không quá 30%, tổng thanh toán trước khi bàn giao không quá 70% giá trị hợp đồng.</li>
</ul>
<p>Mua đúng dự án trong danh sách, có bảo lãnh ngân hàng là cách an toàn nhất khi mua nhà đang xây. Cách kiểm tra chi tiết: <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>

<h2>Giá rao các dự án trong danh sách (tuần 5 – 11/10/2026)</h2>
<ul>
<li><strong>{L('capital-square-da-nang','Capital Square')}:</strong> căn 1 – 2PN 3,26 – 4,8 tỷ, khoảng 54 – 74 triệu/m².</li>
<li><strong>{L('sun-symphony-residence','Sun Symphony Residence')}:</strong> căn 2 – 3PN 5,7 – 13,3 tỷ, 67 – 129 triệu/m².</li>
<li><strong>{L('newtown-diamond-da-nang','Newtown Diamond')}:</strong> căn 1PN trực diện biển khoảng 2,8 tỷ.</li>
<li><strong>{L('danang-landmark','Danang Landmark')}:</strong> bộ 3 căn liền kề 200 m² rao 28,87 tỷ (khoảng 144 triệu/m²).</li>
<li><strong>{L('fpt-city-da-nang','FPT City')} (FPT Plaza):</strong> đất nền 39 – 59 triệu/m²; căn hộ FPT Plaza liên hệ để nhận giá.</li>
</ul>
<p>Xem bảng giá tổng hợp: <a href="/gia-nha-dat-da-nang-tuan-5-11-10-2026/">giá nhà đất Đà Nẵng tuần 5 – 11/10/2026</a>. Nhiều dự án trong danh sách cũng được phép bán cho người nước ngoài: <a href="/du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026/">dự án người nước ngoài được mua tại Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Chỉ trong hơn 2 năm, Đà Nẵng có hàng chục nghìn căn nhà ở hình thành trong tương lai đủ điều kiện bán, tập trung ven sông Hàn (Capital Square, Legend City, Danang Landmark, Sun Symphony, Sun Ponte), ven biển (Times Square, Newtown) và khu Nam (FPT City, Hòa Xuân, Regal Complex). Nguồn cung dồi dào giúp người mua có nhiều lựa chọn và chính sách tốt hơn. Nên ưu tiên dự án có bảo lãnh ngân hàng, tiến độ thi công thực tế và chủ đầu tư uy tín.</p>
<p>Anh chị cần bảng giá, chính sách hoặc so sánh các dự án trong danh sách, liên hệ Hiệp <strong>0904 567 009</strong> (Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Danh sách đầy đủ dự án Đà Nẵng đủ điều kiện bán nhà hình thành trong tương lai 2024 – 2026: đợt mới nhất 12 dự án gần 10.500 căn (Legend City, Capital Square, Times Square, Danang Landmark), Regal Complex, FPT Plaza, Masteri, Sun Symphony, Sun Ponte… kèm số căn và link dự án.',
 'keyword': 'dự án đủ điều kiện mở bán Đà Nẵng',
 'keywords_extra': ['nhà ở hình thành trong tương lai Đà Nẵng', 'dự án đủ điều kiện bán Đà Nẵng 2026', 'căn hộ mở bán Đà Nẵng 2026'],
 'category': 'Thị trường',
 'tags': ['Bất động sản Đà Nẵng', 'Căn hộ Đà Nẵng', 'Pháp lý bất động sản', 'Dự án mở bán', 'Sở Xây dựng Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'Dự án đủ điều kiện mở bán Đà Nẵng 2024–2026: danh sách đủ',
  'desc': 'Dự án đủ điều kiện mở bán Đà Nẵng 2024 – 2026: 12 dự án mới nhất gần 10.500 căn, Regal Complex, FPT Plaza 4, Masteri, Sun Symphony… số căn, link dự án.',
 },
 'sources': ['https://thanhnien.vn/da-nang-danh-sach-10-du-an-nha-o-thuong-mai-du-dieu-kien-mo-ban-185251011160808354.htm', 'https://cafef.vn/danh-sach-7-du-an-du-dieu-kien-ban-nha-hinh-thanh-trong-tuong-lai-tai-da-nang-188240812145656668.chn', 'https://doanhnhan.baophapluat.vn/da-nang-hon-700-can-ho-tai-capital-square-2-du-dieu-kien-mo-ban.html', 'https://baophapluat.vn/chap-thuan-phap-ly-tai-regal-complex-cot-moc-kich-hoat-dong-von-chien-luoc-vao-thi-truong-da-nang.html', 'https://nhadautu.vn/da-nang-don-them-hang-nghin-can-ho-moi-du-dieu-kien-mo-ban-d100940.html', 'https://vietnamfinance.vn/khao-sat-tien-do-cac-du-an-nha-o-thuong-mai-sap-tung-ra-10500-can-ho-o-da-nang-d145814.html', 'https://danviet.vn/tien-do-cac-du-an-nha-o-thuong-mai-sap-tung-ra-10500-can-ho-o-da-nang-d1441085.html', 'https://vietnamfinance.vn/800-can-ho-tai-the-legend-city-danang-du-dieu-kien-mo-ban-d139616.html', 'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html', 'https://24hmoney.vn/news/thang-6-2026-26-du-an-nha-o-xa-hoi-gan-102-ngan-can-du-dieu-kien-mo-ban-c3a2802918.html'],
 'follow_sources': False,
 'image': {'name': slug, 'alt': 'Dự án Đà Nẵng đủ điều kiện mở bán 2026 và số căn', 'caption': 'Đồ hoạ: hiephoangmt.com, tổng hợp thông báo của Sở Xây dựng Đà Nẵng (qua báo chí) đến 10/2026.'},
}
json.dump(n, open('du-dieu-kien-ban-2026.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

W, H = 1200, 675
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 150], fill='#1f3a50')
d.text((48, 24), 'SỞ XÂY DỰNG ĐÀ NẴNG · DANH SÁCH ĐẦY ĐỦ', font=f(22, True), fill='#e8b04a')
d.text((48, 60), 'Dự án đủ điều kiện mở bán 2024 – 2026', font=f(42, True), fill='white')
rows = [('6/2026 · 12 dự án', 'gần 10.500 căn'), ('The Legend City · Capital Square 3', '800 · 750 căn hộ'), ('Regal Complex · Capital Square 2', '683 · 737 căn hộ'), ('Times Square · Danang Landmark', '569 · 454 căn hộ'), ('2025: Masteri · FPT Plaza 3 · 4', '1.112 · 837 · 1.395 căn'), ('2024: Newtown · Sun Symphony', '1.733 · 1.425 căn hộ'), ('2024: Sun Cosmo · Sun Ponte', '679 · 528 căn')]
y = 170
for k, v in rows:
    d.rounded_rectangle([48, y, W - 48, y + 52], 8, fill='white', outline='#e0d6c8')
    d.text((70, y + 13), k, font=f(22, True), fill='#1f3a50')
    d.text((640, y + 13), v, font=f(22), fill='#c2410c')
    y += 62
d.text((48, 638), 'Nguồn: thông báo Sở Xây dựng Đà Nẵng (qua báo chí)', font=f(16), fill='#6b5a48')
d.text((W - 48 - d.textlength('hiephoangmt.com', font=f(18, True)), 636), 'hiephoangmt.com', font=f(18, True), fill='#1f3a50')
im.save(slug + '.jpg', quality=88)
