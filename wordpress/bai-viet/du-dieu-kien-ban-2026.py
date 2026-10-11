import json
from PIL import Image, ImageDraw, ImageFont
slug = 'du-an-da-nang-du-dieu-kien-mo-ban-2026'
title = 'Dự án Đà Nẵng đủ điều kiện mở bán 2026: Legend City, Times Square, Danang Landmark, Capital Square'
L = lambda s, t: f'<a href="/du-an/{s}/">{t}</a>'
content = f"""<p>Sở Xây dựng Đà Nẵng đã công bố danh sách <strong>12 dự án nhà ở thương mại đủ điều kiện bán nhà ở hình thành trong tương lai</strong>, bổ sung gần <strong>10.500 căn hộ và nhà liền kề</strong> cho thị trường. Đây là đợt bổ sung nguồn cung lớn nhất từ khi Luật Kinh doanh bất động sản 2023 có hiệu lực. Hiệp tổng hợp các dự án đáng chú ý, số căn được phép bán và ý nghĩa với người mua.</p>

<!--hh-featured-->

<h2>Các dự án nổi bật trong danh sách 12 dự án đủ điều kiện mở bán</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Chủ đầu tư</th><th>Số căn đủ điều kiện bán</th></tr></thead>
<tbody>
<tr><td>Tổ hợp TTTM, khách sạn và căn hộ Thành phố huyền thoại Đà Nẵng ({L('the-legend-da-nang','The Legend City Danang')})</td><td>Chân cầu Rồng, An Hải</td><td>Công ty TNHH MTV VIPICO</td><td>800 căn hộ</td></tr>
<tr><td>Tháp CT3 và CT7 – {L('times-square-da-nang','Đà Nẵng Times Square')}</td><td>Võ Nguyên Giáp, An Hải (biển Mỹ Khê)</td><td>CTCP Kim Long Nam</td><td>569 căn hộ</td></tr>
<tr><td>Khu phức hợp TTTM – căn hộ điểm nhấn Đà Nẵng ({L('danang-landmark','Danang Landmark')})</td><td>Ven sông Hàn, cạnh công viên APEC, Hòa Cường</td><td>CTCP Cosmos Housing</td><td>454 căn hộ</td></tr>
<tr><td>Khu đô thị {L('capital-square-da-nang','Capital Square')} 3 – tháp MAT 7, MAT 8, MAT 9</td><td>Ngô Quyền, An Hải (ven sông Hàn)</td><td>CTCP Bất động sản SIH</td><td>750 căn hộ</td></tr>
<tr><td>Khu đô thị sinh thái ven sông Hòa Xuân ({L('sun-neo-city','Sun NeO City')})</td><td>Hòa Xuân</td><td>Sun Group</td><td>Theo thông báo của Sở</td></tr>
<tr><td>Chung cư Ánh Bình Minh</td><td>Đà Nẵng</td><td>–</td><td>Theo thông báo của Sở</td></tr>
<tr><td>Khu đô thị Thanh Hà (Phân khu 1)</td><td>Đà Nẵng</td><td>–</td><td>Theo thông báo của Sở</td></tr>
</tbody>
</table>
<p><em>Các dự án còn lại trong danh sách 12 dự án sẽ được Hiệp cập nhật khi có văn bản đầy đủ của Sở Xây dựng.</em></p>

<h2>Các dự án khác được Sở Xây dựng xác nhận đủ điều kiện bán trong năm 2026</h2>
<ul>
<li><strong>{L('capital-square-da-nang','Khu đô thị Capital Square 2')}</strong> (Ngô Quyền, An Hải): 737 căn hộ đủ điều kiện bán, xác nhận ngày 12/2/2026.</li>
<li><strong>{L('spana-tower','Spana Tower')}</strong> (tòa S1, S2 – Khu đô thị sinh thái ven sông Hòa Xuân): Sở Xây dựng xác nhận nhà ở hình thành trong tương lai đủ điều kiện bán tại văn bản 7111/SXD-QLN ngày 5/5/2026.</li>
<li><strong>Chung cư Hồ Xuân Hương (The Poet Residence):</strong> 263 căn hộ đủ điều kiện bán, thông báo ngày 24/6/2026, chủ đầu tư CTCP Địa ốc Phúc Thanh An.</li>
<li><strong>Khu dịch vụ du lịch ven sông Hàn</strong> (CTCP Thương mại Du lịch Đầu tư Cù Lao Chàm): thêm 17 căn đủ điều kiện bán trong tháng 6/2026.</li>
<li><strong>Dự án bất động sản và bến du thuyền Đà Nẵng:</strong> 4 căn nhà ở 3 tầng đủ điều kiện bán trong tháng 6/2026.</li>
</ul>

<h2>"Đủ điều kiện bán" có ý nghĩa gì với người mua?</h2>
<p>Theo Luật Kinh doanh bất động sản 2023, chủ đầu tư chỉ được ký hợp đồng mua bán nhà ở hình thành trong tương lai khi:</p>
<ul>
<li>Sở Xây dựng có <strong>văn bản xác nhận nhà ở đủ điều kiện được bán</strong>.</li>
<li>Có <strong>bảo lãnh của ngân hàng thương mại</strong> cho nghĩa vụ tài chính của chủ đầu tư với khách hàng – nếu chủ đầu tư không bàn giao đúng cam kết, ngân hàng hoàn tiền cho khách.</li>
<li>Tiền đặt cọc trước khi đủ điều kiện bán không quá 5% giá bán. Lần thanh toán đầu (gồm cọc) không quá 30%, tổng thanh toán trước khi bàn giao không quá 70% giá trị hợp đồng.</li>
</ul>
<p>Vì vậy, mua đúng dự án trong danh sách và có bảo lãnh ngân hàng là cách an toàn nhất khi mua căn hộ đang xây. Cách kiểm tra chi tiết: <a href="/kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang/">kiểm tra pháp lý, quy hoạch nhà đất Đà Nẵng</a>.</p>

<h2>Giá rao các dự án trong danh sách (tuần 5 – 11/10/2026)</h2>
<ul>
<li><strong>Capital Square:</strong> căn 1 – 2PN 3,26 – 4,8 tỷ, khoảng 54 – 74 triệu/m².</li>
<li><strong>Danang Landmark:</strong> căn liền kề ven sông Hàn, ví dụ bộ 3 căn 200 m² rao 28,87 tỷ (khoảng 144 triệu/m²).</li>
<li><strong>The Legend City:</strong> chủ đầu tư đang áp dụng chính sách ưu đãi tháng 10, giá theo từng căn.</li>
<li><strong>Spana Tower:</strong> căn Studio đến 3PN, ngay chân cầu Hòa Xuân – liên hệ để nhận bảng giá.</li>
</ul>
<p>Xem bảng giá tổng hợp: <a href="/gia-nha-dat-da-nang-tuan-5-11-10-2026/">giá nhà đất Đà Nẵng tuần 5 – 11/10/2026</a>. Nhiều dự án trong danh sách cũng được phép bán cho người nước ngoài: <a href="/du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026/">dự án người nước ngoài được mua tại Đà Nẵng</a>.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Gần 10.500 căn được phép bán cùng lúc cho thấy nguồn cung căn hộ Đà Nẵng 2026 – 2027 sẽ dồi dào, tập trung ven sông Hàn (Capital Square, Legend City, Danang Landmark), ven biển Mỹ Khê (Times Square) và khu Nam (Hòa Xuân). Nguồn cung nhiều giúp người mua có thêm lựa chọn và chính sách tốt hơn từ chủ đầu tư. Nên ưu tiên dự án có bảo lãnh ngân hàng, tiến độ thi công thực tế và chủ đầu tư uy tín.</p>
<p>Anh chị cần bảng giá, chính sách hoặc so sánh các dự án trong danh sách, liên hệ Hiệp <strong>0904 567 009</strong> (Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Sở Xây dựng Đà Nẵng công bố 12 dự án đủ điều kiện bán nhà ở hình thành trong tương lai, gần 10.500 căn: The Legend City 800 căn, Times Square 569 căn, Danang Landmark 454 căn, Capital Square 3 750 căn… và các dự án được xác nhận năm 2026.',
 'keyword': 'dự án đủ điều kiện mở bán Đà Nẵng',
 'keywords_extra': ['nhà ở hình thành trong tương lai Đà Nẵng', 'dự án đủ điều kiện bán Đà Nẵng 2026', 'căn hộ mở bán Đà Nẵng 2026'],
 'category': 'Thị trường',
 'tags': ['Bất động sản Đà Nẵng', 'Căn hộ Đà Nẵng', 'Pháp lý bất động sản', 'Dự án mở bán', 'Sở Xây dựng Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'Dự án đủ điều kiện mở bán Đà Nẵng 2026: 12 dự án, 10.500 căn',
  'desc': 'Dự án đủ điều kiện mở bán Đà Nẵng 2026: The Legend City 800 căn, Times Square 569, Danang Landmark 454, Capital Square 3 750 căn… Ý nghĩa với người mua.',
 },
 'sources': ['https://danviet.vn/tien-do-cac-du-an-nha-o-thuong-mai-sap-tung-ra-10500-can-ho-o-da-nang-d1441085.html', 'https://vietnamfinance.vn/800-can-ho-tai-the-legend-city-danang-du-dieu-kien-mo-ban-d139616.html', 'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html', 'https://24hmoney.vn/news/thang-6-2026-26-du-an-nha-o-xa-hoi-gan-102-ngan-can-du-dieu-kien-mo-ban-c3a2802918.html'],
 'follow_sources': False,
 'image': {'name': slug, 'alt': 'Dự án Đà Nẵng đủ điều kiện mở bán 2026 và số căn', 'caption': 'Đồ hoạ: hiephoangmt.com, tổng hợp thông báo của Sở Xây dựng Đà Nẵng (qua báo chí) đến 10/2026.'},
}
json.dump(n, open('du-dieu-kien-ban-2026.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

W, H = 1200, 675
im = Image.new('RGB', (W, H), '#f3ede6'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 150], fill='#1f3a50')
d.text((48, 24), 'SỞ XÂY DỰNG ĐÀ NẴNG · 12 DỰ ÁN · GẦN 10.500 CĂN', font=f(22, True), fill='#e8b04a')
d.text((48, 60), 'Dự án đủ điều kiện mở bán 2026', font=f(42, True), fill='white')
rows = [('The Legend City Danang', '800 căn hộ'), ('Capital Square 3 (MAT 7 – 9)', '750 căn hộ'), ('Capital Square 2', '737 căn hộ (12/2/2026)'), ('Đà Nẵng Times Square (CT3, CT7)', '569 căn hộ'), ('Danang Landmark', '454 căn hộ'), ('The Poet Residence', '263 căn hộ (24/6/2026)'), ('Spana Tower', 'VB 7111/SXD-QLN · 5/5/2026')]
y = 170
for k, v in rows:
    d.rounded_rectangle([48, y, W - 48, y + 52], 8, fill='white', outline='#e0d6c8')
    d.text((70, y + 13), k, font=f(22, True), fill='#1f3a50')
    d.text((640, y + 13), v, font=f(22), fill='#c2410c')
    y += 62
d.text((48, 638), 'Nguồn: thông báo Sở Xây dựng Đà Nẵng (qua báo chí)', font=f(16), fill='#6b5a48')
d.text((W - 48 - d.textlength('hiephoangmt.com', font=f(18, True)), 636), 'hiephoangmt.com', font=f(18, True), fill='#1f3a50')
im.save(slug + '.jpg', quality=88)
