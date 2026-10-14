import json, math
from PIL import Image, ImageDraw, ImageFont
slug = 'thi-truong-bat-dong-san-da-nang-quy-3-2026'
title = 'Thị trường bất động sản Đà Nẵng quý 3/2026: chung cư giữ giá, đất nền điều chỉnh 7%, nhà phố ven biển tăng mạnh'
P = lambda s, t: f'<a href="/du-an/{s}/">{t}</a>'
content = f"""<p><strong>Thị trường bất động sản Đà Nẵng quý 3/2026</strong> có hai chiều rõ rệt: <strong>chung cư</strong> giữ giá và hút thêm người mua ở thực, trong khi <strong>đất nền</strong> bước vào nhịp điều chỉnh sau giai đoạn tăng nóng. Bài tóm tắt các số liệu chính về Đà Nẵng trong báo cáo "Toàn cảnh thị trường Bất động sản quý 3/2026" của Batdongsan.com.vn, kèm nhận định của Hoàng Hiệp cho người mua.</p>

<!--hh-featured-->

<h2>Bức tranh chung: Đà Nẵng hút 62% lượng quan tâm ở miền Trung</h2>
<ul>
<li>Đà Nẵng chiếm <strong>62%</strong> lượng quan tâm bất động sản bán ở miền Trung trong quý 3/2026 (quý 1/2024 là 52%) – cao nhất từ trước đến nay.</li>
<li>Giá rao bán phổ biến khoảng <strong>81 triệu/m²</strong>, giảm so với mức 87 triệu/m² của quý 1 và quý 2/2026; giá rao thuê phổ biến khoảng <strong>25 triệu/tháng</strong> (quý 2: 30 triệu).</li>
<li>Khảo sát môi giới cả nước: rào cản lớn nhất khiến người mua đắn đo là <strong>lãi suất vay còn cao</strong> (46%), lo ngại biến động chính sách, quy hoạch (32%) và dòng tiền hạn chế (25%).</li>
<li>Người tìm mua bất động sản Đà Nẵng phần lớn là người địa phương (44%), tiếp theo là Hà Nội (15%) và TP.HCM cũ (13%).</li>
</ul>

<h2>Giá rao bán theo loại hình quý 3/2026</h2>
<table>
<thead><tr><th>Loại hình</th><th>Giá rao bán</th><th>So với quý 2/2026</th><th>Tỷ trọng quan tâm</th></tr></thead>
<tbody>
<tr><td>Chung cư</td><td>67 triệu/m²</td><td>-1%</td><td>24% (quý 1/2024: 12%)</td></tr>
<tr><td>Đất nền</td><td>78 triệu/m²</td><td>-7%</td><td>45% (quý 3/2025: 56%)</td></tr>
<tr><td>Nhà riêng</td><td>82 triệu/m²</td><td>-7%</td><td>14%</td></tr>
<tr><td>Nhà mặt phố</td><td>137 triệu/m²</td><td>-7%</td><td>13%</td></tr>
<tr><td>Biệt thự</td><td>100 triệu/m²</td><td>0%</td><td>5%</td></tr>
</tbody>
</table>
<p>Khi môi giới Đà Nẵng được hỏi loại hình nào tiềm năng nhất trong 6 tháng tới: <strong>chung cư 35%</strong>, nhà riêng 25%, đất nền 22%, nhà mặt phố 11%, biệt thự 7% – xu hướng ưu tiên sản phẩm ở thực tiếp tục rõ.</p>

<h2>Chung cư Đà Nẵng: giữ giá, lợi suất cho thuê thuộc nhóm cao nhất</h2>
<p>Giá rao bán chung cư khu Đà Nẵng cũ đi ngang quanh <strong>67 – 68 triệu/m²</strong> suốt từ quý 3/2025 (quý 1/2024 chỉ 46 triệu/m²). Lợi suất cho thuê (tiền thuê 11 tháng / giá bán) tăng lên <strong>4,5%/năm</strong> – nhờ du lịch: 9 tháng đầu 2026 Đà Nẵng cũ đón khoảng 15,8 triệu lượt khách, trong đó 7,7 triệu lượt khách quốc tế, bằng cả năm 2025.</p>
<table>
<thead><tr><th>Thành phố</th><th>Tổng giá rao phổ biến</th><th>Giá thuê phổ biến</th><th>Tỷ suất cho thuê</th><th>Tăng giá Q3/26 so Q1/24</th></tr></thead>
<tbody>
<tr><td><strong>Đà Nẵng</strong></td><td>4,2 tỷ</td><td>17 triệu/tháng</td><td>4,5%</td><td>46%</td></tr>
<tr><td>Hà Nội</td><td>6,9 tỷ</td><td>15 triệu/tháng</td><td>2,4%</td><td>77%</td></tr>
<tr><td>TP.HCM cũ</td><td>5,2 tỷ</td><td>16 triệu/tháng</td><td>3,4%</td><td>44%</td></tr>
<tr><td>Nha Trang</td><td>3,4 tỷ</td><td>14 triệu/tháng</td><td>4,5%</td><td>114%</td></tr>
<tr><td>Quy Nhơn</td><td>2,1 tỷ</td><td>7 triệu/tháng</td><td>3,7%</td><td>31%</td></tr>
<tr><td>Phan Thiết</td><td>2,0 tỷ</td><td>8 triệu/tháng</td><td>4,4%</td><td>17%</td></tr>
</tbody>
</table>
<p><strong>Theo khu vực:</strong> Hải Châu khoảng 85 triệu/m² (đi ngang), Sơn Trà 82 triệu/m² (-1%), Ngũ Hành Sơn 56 triệu/m² (-2%), Liên Chiểu 41 triệu/m² (+2%). Sơn Trà chiếm tới 40% lượng quan tâm chung cư, tiếp theo là Ngũ Hành Sơn 21%, Hải Châu 18%, Liên Chiểu 14%.</p>
<p><strong>Nguồn cung mới</strong> tập trung ở Ngũ Hành Sơn và Sơn Trà, phân khúc khoảng 50 – 60 triệu/m². Các dự án nổi bật quý 3/2026 và giá rao tham khảo theo báo cáo: {P('fours-tower','FourS Tower')} khoảng 49 triệu/m², {P('fpt-plaza-4','FPT Plaza 4')} khoảng 56, {P('s-light-tower','S-Light Tower')} khoảng 57, {P('spana-tower','Spana Tower')} và {P('cora-tower','Cora Tower')} khoảng 60, {P('the-camellia-son-tra','The Camellia')} khoảng 60, Regal Complex khoảng 60, {P('peninsula-private-da-nang','Peninsula Private')} khoảng 65, {P('newtown-diamond-da-nang','Newtown Diamond')} khoảng 69, {P('capital-square-da-nang','Capital Square')} khoảng 85, {P('sun-symphony-residence','Sun Symphony')} khoảng 89, {P('wyndham-soleil-da-nang','Wyndham Soleil')} khoảng 100, The Legend City khoảng 124, {P('times-square-da-nang','Đà Nẵng Times Square')} khoảng 177 triệu/m². Xem thêm <a href="/gia-thue-can-ho-da-nang-moi-thang/">giá thuê căn hộ Đà Nẵng</a>.</p>

<h2>Đất nền Đà Nẵng: điều chỉnh sau giai đoạn tăng nóng</h2>
<p>Giá rao bán đất nền khu Đà Nẵng cũ giảm từ 84 triệu/m² (quý 2) xuống <strong>78 triệu/m²</strong> (quý 3/2026), sau khi tăng gần gấp đôi từ mức 43 triệu/m² đầu năm 2024. Khu Quảng Nam cũ vẫn nhích lên khoảng <strong>22 triệu/m²</strong>. Lượng quan tâm đất nền giảm rõ từ cuối 2025 khi lãi suất tăng – báo cáo nhận định đất nền là loại hình nhạy cảm nhất với yếu tố vĩ mô.</p>
<table>
<thead><tr><th>Khu vực</th><th>Giá rao đất nền Q3/2026</th><th>So với quý 2</th></tr></thead>
<tbody>
<tr><td>Sơn Trà</td><td>144 triệu/m²</td><td>-5%</td></tr>
<tr><td>Hải Châu</td><td>140 triệu/m²</td><td>-3%</td></tr>
<tr><td>Ngũ Hành Sơn</td><td>74 triệu/m²</td><td>-3%</td></tr>
<tr><td>Cẩm Lệ</td><td>64 triệu/m²</td><td>-2%</td></tr>
<tr><td>Liên Chiểu</td><td>44 triệu/m²</td><td>-8%</td></tr>
<tr><td>Hội An</td><td>39 triệu/m²</td><td>+5%</td></tr>
<tr><td>Điện Bàn</td><td>25 triệu/m²</td><td>-4%</td></tr>
<tr><td>Tam Kỳ</td><td>14 triệu/m²</td><td>0%</td></tr>
<tr><td>Hòa Vang</td><td>13 triệu/m²</td><td>-7%</td></tr>
</tbody>
</table>
<p>Ngũ Hành Sơn vẫn là nơi được quan tâm nhiều nhất (26% lượng quan tâm đất nền năm 2026), tiếp theo là Liên Chiểu, Cẩm Lệ (13%), Hòa Vang, Điện Bàn, Sơn Trà (12%). Tham khảo dự án đất nền: {P('dat-nen-vo-chi-cong','709 lô đất nền Võ Chí Công')}, {P('dat-nen-dam-sen-sun-riverpolis','đất nền Đầm Sen – Sun Riverpolis')}, {P('khu-do-thi-1a-1b-dien-ngoc','khu đô thị 1A 1B Điện Ngọc')}.</p>

<h2>Nhà mặt phố: tăng 29% trong gần 2 năm, ven biển dẫn đầu</h2>
<p>Giá rao nhà mặt phố khu Đà Nẵng cũ khoảng <strong>137 triệu/m²</strong>, tăng 29% so với quý 1/2025 (106 triệu/m²) – trong khi Hà Nội tăng 22% và TP.HCM cũ giảm 6%. Mức tăng cao nhất ở <strong>Ngũ Hành Sơn (188 triệu/m², +45%)</strong> và <strong>Sơn Trà (181 triệu/m², +43%)</strong> nhờ lợi thế du lịch ven biển; Hải Châu 157 triệu/m² (+23%), Thanh Khê 124, Cẩm Lệ 84, Liên Chiểu 83 triệu/m². Hải Châu chiếm 31% lượng quan tâm nhà phố, Sơn Trà 21%. Xem thêm <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Đà Nẵng</a>.</p>

<h2>Nhận định cho người mua</h2>
<ul>
<li><strong>Mua để ở, cho thuê:</strong> chung cư Sơn Trà, Ngũ Hành Sơn, Hải Châu giữ giá tốt và lợi suất 4,5% – nên chọn dự án pháp lý rõ, gần biển hoặc sông Hàn, ưu tiên căn dễ cho thuê (1 – 2 phòng ngủ).</li>
<li><strong>Đất nền:</strong> giá đang điều chỉnh là lúc người có vốn nhàn rỗi thương lượng tốt hơn, nhưng tránh vay nhiều khi lãi suất còn cao; chọn lô có sổ, hạ tầng xong.</li>
<li><strong>Nhà phố ven biển:</strong> tăng mạnh nhất nhưng giá đã cao – phù hợp người kinh doanh lưu trú, cần tính kỹ dòng tiền.</li>
</ul>
<p>Số liệu là <strong>giá rao bán</strong> trên Batdongsan.com.vn, không phải giá giao dịch thành công. Cần đánh giá một căn hoặc một lô cụ thể theo số liệu mới nhất, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem thêm <a href="/thi-truong-bat-dong-san-da-nang-2026/">thị trường bất động sản Đà Nẵng 2026</a>.</p>
<p><em>Nguồn số liệu: Báo cáo "Toàn cảnh thị trường Bất động sản quý 3/2026" của Batdongsan.com.vn (PropertyGuru Group), dữ liệu tin đăng và khảo sát 530 môi giới; số liệu du lịch theo Cục Thống kê.</em></p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Thị trường bất động sản Đà Nẵng quý 3/2026 theo báo cáo Batdongsan.com.vn: chung cư giữ giá 67 triệu/m², lợi suất thuê 4,5%; đất nền giảm 7% về 78 triệu/m²; nhà phố Ngũ Hành Sơn, Sơn Trà tăng hơn 40%.',
 'keyword': 'thị trường bất động sản Đà Nẵng quý 3/2026',
 'keywords_extra': ['giá chung cư Đà Nẵng', 'giá đất nền Đà Nẵng', 'giá nhà phố Đà Nẵng', 'báo cáo bất động sản quý 3/2026'],
 'category': 'Thị trường',
 'tags': ['Thị trường bất động sản Đà Nẵng', 'Giá căn hộ Đà Nẵng', 'Đất nền Đà Nẵng', 'Nhà phố Đà Nẵng', 'Bất động sản Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'Thị trường bất động sản Đà Nẵng quý 3/2026: số liệu mới',
  'desc': 'Thị trường bất động sản Đà Nẵng quý 3/2026: chung cư giữ giá 67 triệu/m², đất nền giảm 7%, nhà phố ven biển tăng hơn 40%. Số liệu Batdongsan.com.vn.',
  'points': [
   'Đà Nẵng chiếm 62% lượng quan tâm bất động sản miền Trung',
   'Chung cư 67 triệu/m², lợi suất cho thuê 4,5% – thuộc nhóm cao nhất cả nước',
   'Đất nền giảm 7% về 78 triệu/m² sau giai đoạn tăng nóng',
   'Nhà phố Ngũ Hành Sơn 188 triệu/m² (+45%), Sơn Trà 181 triệu/m² (+43%)',
  ],
  'faq': [
   ['Giá chung cư Đà Nẵng quý 3/2026 bao nhiêu?', 'Theo Batdongsan.com.vn, giá rao bán phổ biến khoảng 67 triệu/m² (khu Đà Nẵng cũ); Hải Châu khoảng 85, Sơn Trà 82, Ngũ Hành Sơn 56, Liên Chiểu 41 triệu/m².'],
   ['Giá đất nền Đà Nẵng có giảm không?', 'Có. Quý 3/2026 giá rao đất nền khu Đà Nẵng cũ giảm khoảng 7% so với quý 2, còn khoảng 78 triệu/m²; hầu hết khu vực đều điều chỉnh, riêng Hội An tăng 5%.'],
   ['Cho thuê căn hộ Đà Nẵng lợi suất bao nhiêu?', 'Khoảng 4,5%/năm theo cách tính tiền thuê 11 tháng chia giá bán – ngang Nha Trang và cao hơn Hà Nội (2,4%), TP.HCM cũ (3,4%).'],
   ['Khu vực nào nhà phố Đà Nẵng tăng giá mạnh nhất?', 'Ngũ Hành Sơn (khoảng 188 triệu/m², +45% so với quý 1/2025) và Sơn Trà (khoảng 181 triệu/m², +43%), nhờ lợi thế du lịch ven biển.'],
  ],
 },
 'sources': ['https://batdongsan.com.vn/'],
 'follow_sources': False,
 'follow_domains': [],
 'image': {'name': slug, 'alt': 'Thị trường bất động sản Đà Nẵng quý 3/2026: giá chung cư, đất nền, nhà phố theo báo cáo Batdongsan.com.vn', 'caption': 'Đồ hoạ: hiephoangmt.com, số liệu Batdongsan.com.vn quý 3/2026.', 'file': slug + '.jpg'},
}
json.dump(n, open('thi-truong-quy-3-2026.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

# Ảnh: nền navy kẻ ô + biểu đồ giá đất nền vs chung cư theo quý (tự vẽ từ số liệu).
W, H = 1200, 675
NAVY = (11, 26, 42); GOLD = '#e8b04a'
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
for k in range(4):
    g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((56, 34), 'THỊ TRƯỜNG BĐS ĐÀ NẴNG · QUÝ 3/2026', font=f(22, True), fill=GOLD)
d.text((56, 72), 'Chung cư giữ giá, đất nền điều chỉnh', font=f(44, True), fill='white')
stats = [('67 tr/m²', 'Chung cư · -1%'), ('78 tr/m²', 'Đất nền · -7%'), ('137 tr/m²', 'Nhà mặt phố · -7%'), ('4,5%', 'Lợi suất thuê căn hộ')]
for i, (big, small) in enumerate(stats):
    x = 56 + i * 274; y = 150
    d.rounded_rectangle([x, y, x + 254, y + 112], 14, fill=(16, 40, 64), outline=GOLD, width=2)
    d.text((x + 18, y + 14), big, font=f(36, True), fill=GOLD)
    d.text((x + 18, y + 70), small, font=f(20), fill=(200, 215, 230))
# Biểu đồ đường giá theo quý
qs = ['Q1/24', 'Q2', 'Q3', 'Q4', 'Q1/25', 'Q2', 'Q3', 'Q4', 'Q1/26', 'Q2', 'Q3']
land = [43, 50, 49, 52, 55, 63, 73, 79, 83, 84, 78]
apt = [46, 53, 55, 59, 59, 62, 68, 68, 68, 68, 67]
x0, x1, y0, y1 = 110, 1140, 300, 590
lo, hi = 40, 90
d.text((56, 285), 'Giá rao bán (triệu/m²) – Đà Nẵng cũ', font=f(19, True), fill='white')
for v in (40, 60, 80):
    y = y1 - (v - lo) / (hi - lo) * (y1 - y0 - 30)
    d.line([x0, y, x1, y], fill=(60, 85, 110), width=1); d.text((x0 - 12, y), str(v), font=f(16), fill=(150, 170, 195), anchor='rm')
X = lambda i: x0 + 20 + i * (x1 - x0 - 40) / (len(qs) - 1)
Y = lambda v: y1 - (v - lo) / (hi - lo) * (y1 - y0 - 30)
for series, col, name in ((land, (232, 176, 74), 'Đất nền'), (apt, (120, 190, 235), 'Chung cư')):
    pts = [(X(i), Y(v)) for i, v in enumerate(series)]
    d.line(pts, fill=col, width=5, joint='curve')
    for p in pts: d.ellipse([p[0] - 6, p[1] - 6, p[0] + 6, p[1] + 6], fill=col)
    d.text((pts[-1][0] + 2, pts[-1][1] - 30), str(series[-1]), font=f(20, True), fill=col, anchor='mm')
for i, q in enumerate(qs):
    d.text((X(i), y1 + 14), q, font=f(15), fill=(160, 180, 205), anchor='mt')
d.rectangle([700, 286, 716, 302], fill=(232, 176, 74)); d.text((724, 284), 'Đất nền', font=f(18), fill='white')
d.rectangle([830, 286, 846, 302], fill=(120, 190, 235)); d.text((854, 284), 'Chung cư', font=f(18), fill='white')
d.text((56, 640), 'Số liệu: Batdongsan.com.vn, báo cáo quý 3/2026 (giá rao bán)', font=f(16), fill=(150, 170, 195))
d.text((W - 56, 636), 'hiephoangmt.com', font=f(22, True), fill='white', anchor='ra')
im.save(slug + '.jpg', quality=88)
print('ok')
