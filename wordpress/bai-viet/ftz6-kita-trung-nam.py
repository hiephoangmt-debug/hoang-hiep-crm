import json, math
from PIL import Image, ImageDraw, ImageFont
slug = 'khu-thuong-mai-tu-do-da-nang-ftz6-kita-trung-nam-ba-na'
title = 'Khu thương mại tự do Đà Nẵng: KITA Trung Nam làm nhà đầu tư vị trí số 6 ở Bà Nà, 154 ha, hơn 3.354 tỷ đồng'
content = """<p><strong>Khu thương mại tự do Đà Nẵng</strong> vừa có thêm nhà đầu tư hạ tầng: ngày 13/10/2026, UBND TP Đà Nẵng công bố Quyết định 4648/QĐ-UBND chấp thuận chủ trương đầu tư, đồng thời chấp thuận <strong>Công ty TNHH FTZ KITA Trung Nam</strong> làm nhà đầu tư dự án kết cấu hạ tầng khu chức năng tại <strong>vị trí số 6</strong> – khoảng <strong>154 ha</strong> ở xã Bà Nà, tổng vốn <strong>hơn 3.354 tỷ đồng</strong>. Bài tóm tắt nội dung quyết định và tác động đến bất động sản phía Tây Đà Nẵng.</p>

<!--hh-featured-->

<h2>Thông tin chính về dự án FTZ số 6</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Nội dung</th></tr></thead>
<tbody>
<tr><td>Văn bản</td><td>Quyết định 4648/QĐ-UBND của Chủ tịch UBND TP Đà Nẵng – chấp thuận chủ trương đầu tư, đồng thời chấp thuận nhà đầu tư</td></tr>
<tr><td>Nhà đầu tư</td><td>Công ty TNHH FTZ KITA Trung Nam</td></tr>
<tr><td>Vị trí</td><td>Vị trí số 6 – Khu thương mại tự do Đà Nẵng, xã Bà Nà (theo Quyết định thành lập 1142/QĐ-TTg, vị trí này thuộc địa bàn xã Hòa Nhơn, Hòa Ninh, huyện Hòa Vang cũ)</td></tr>
<tr><td>Quy mô</td><td>Khoảng 154 ha</td></tr>
<tr><td>Tổng vốn</td><td>Hơn 3.354 tỷ đồng: vốn chủ sở hữu 800 tỷ, vốn huy động hơn 2.554 tỷ</td></tr>
<tr><td>Thời hạn</td><td>70 năm kể từ ngày Nhà nước quyết định cho thuê đất</td></tr>
<tr><td>Tiến độ</td><td>Dự kiến hoàn thành quý IV/2029</td></tr>
</tbody>
</table>

<h2>Dự án làm gì?</h2>
<p>Đây là dự án <strong>đầu tư xây dựng và kinh doanh kết cấu hạ tầng</strong> trong khu thương mại tự do: nhà đầu tư làm đường, điện, nước, hạ tầng kỹ thuật, sau đó <strong>cho thuê đất đã có hạ tầng</strong> và <strong>cho thuê công trình thương mại – dịch vụ</strong> cho các doanh nghiệp vào hoạt động. Hồ sơ đề xuất dự án được nộp từ khoảng tháng 8/2026, định hướng khu phức hợp thương mại – dịch vụ, có kho bãi và logistics.</p>
<p>Nói cách khác, KITA Trung Nam là "chủ nhà" của khu 154 ha, còn nhà máy, kho vận, trung tâm thương mại sẽ do các doanh nghiệp thuê lại đầu tư sau.</p>

<h2>Ai đứng sau FTZ KITA Trung Nam?</h2>
<ul>
<li>Công ty TNHH FTZ KITA Trung Nam thành lập ngày 31/7/2026, vốn điều lệ 800 tỷ đồng.</li>
<li><strong>Công ty CP Trung Nam</strong> góp 560 tỷ đồng (70%) – tập đoàn có nhiều dự án hạ tầng, năng lượng, bất động sản ở Đà Nẵng.</li>
<li><strong>Công ty CP Tập đoàn KITA</strong> góp 240 tỷ đồng (30%) – nhà phát triển bất động sản.</li>
</ul>

<h2>Khu thương mại tự do Đà Nẵng đang ở bước nào?</h2>
<p>Khu thương mại tự do Đà Nẵng được Thủ tướng thành lập theo Quyết định 1142/QĐ-TTg (2025), tổng quy mô khoảng <strong>1.881 ha tại 7 vị trí</strong>, gồm các khu sản xuất, logistics, thương mại – dịch vụ, công nghệ số và đổi mới sáng tạo. Cùng xã Bà Nà, <strong>vị trí số 5</strong> rộng khoảng 90 ha đã có nhà đầu tư là doanh nghiệp thuộc Sun Group. Với quyết định cho vị trí số 6, phía Tây thành phố đã có hai khu chức năng có chủ đầu tư hạ tầng.</p>
<p>Xem thêm tổng quan về cảng và khu thương mại tự do phía Tây Bắc tại bài <a href="/cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu/">cảng Liên Chiểu và khu thương mại tự do</a>.</p>

<h2>Tác động đến bất động sản Hòa Vang – Bà Nà</h2>
<ul>
<li><strong>Nhu cầu ở và thuê tăng dần:</strong> khi hạ tầng xong (dự kiến cuối 2029) và doanh nghiệp vào thuê, sẽ cần nhà cho chuyên gia, nhân viên, công nhân – lợi cho nhà phố, căn hộ cho thuê ở khu Tây và các khu dân cư dọc trục đi Bà Nà.</li>
<li><strong>Hạ tầng kết nối:</strong> khu vực Hòa Vang còn đón <a href="/ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang/">ga đường sắt tốc độ cao Đà Nẵng ở Hòa Sơn</a> theo quy hoạch – các dự án hạ tầng lớn cùng hướng về phía Tây.</li>
<li><strong>Đây là câu chuyện dài hạn:</strong> dự án mới ở bước chấp thuận chủ trương, chưa giao đất, chưa xây dựng. Giá đất quanh khu vực có thể bị "thổi" theo tin tức; người mua nên kiểm tra quy hoạch sử dụng đất từng thửa (đất ở hay đất nông nghiệp, có nằm trong ranh khu thương mại tự do hoặc diện thu hồi không) trước khi xuống tiền.</li>
</ul>
<p>Cần kiểm tra quy hoạch một thửa đất ở Hòa Vang – Bà Nà, hoặc tìm nhà cho thuê, căn hộ đón đầu khu thương mại tự do, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem thêm <a href="/tin-quy-hoach-xay-dung-da-nang-6-12-10-2026/">tin quy hoạch Đà Nẵng tuần 6 – 12/10/2026</a>.</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Đà Nẵng chấp thuận Công ty TNHH FTZ KITA Trung Nam làm nhà đầu tư hạ tầng vị trí số 6 Khu thương mại tự do: khoảng 154 ha ở xã Bà Nà, vốn hơn 3.354 tỷ đồng, thời hạn 70 năm, dự kiến xong quý IV/2029.',
 'keyword': 'khu thương mại tự do Đà Nẵng',
 'keywords_extra': ['FTZ KITA Trung Nam', 'khu thương mại tự do Bà Nà', 'FTZ số 6 Đà Nẵng', 'bất động sản Hòa Vang'],
 'category': 'Hạ tầng & quy hoạch',
 'tags': ['Khu thương mại tự do Đà Nẵng', 'Quy hoạch Đà Nẵng', 'Hòa Vang', 'Bất động sản Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'Khu thương mại tự do Đà Nẵng: KITA Trung Nam làm FTZ số 6',
  'desc': 'Khu thương mại tự do Đà Nẵng: FTZ KITA Trung Nam làm nhà đầu tư vị trí số 6 ở Bà Nà, 154 ha, hơn 3.354 tỷ đồng, 70 năm, xong quý IV/2029. Tác động BĐS.',
  'points': [
   'Quyết định 4648/QĐ-UBND chấp thuận chủ trương và nhà đầu tư FTZ KITA Trung Nam',
   'Vị trí số 6, khoảng 154 ha ở xã Bà Nà; vốn hơn 3.354 tỷ đồng, thời hạn 70 năm',
   'Trung Nam góp 70%, Tập đoàn KITA góp 30% vốn điều lệ 800 tỷ đồng',
   'Hạ tầng dự kiến hoàn thành quý IV/2029 – cơ hội dài hạn cho BĐS phía Tây',
  ],
  'faq': [
   ['FTZ số 6 Đà Nẵng ở đâu?', 'Tại xã Bà Nà, TP Đà Nẵng; theo Quyết định 1142/QĐ-TTg, vị trí số 6 thuộc địa bàn xã Hòa Nhơn, Hòa Ninh, huyện Hòa Vang cũ, quy mô khoảng 154 ha.'],
   ['Nhà đầu tư FTZ số 6 là ai?', 'Công ty TNHH FTZ KITA Trung Nam, thành lập 31/7/2026, vốn điều lệ 800 tỷ đồng: Công ty CP Trung Nam 70%, Công ty CP Tập đoàn KITA 30%.'],
   ['Khi nào hạ tầng FTZ số 6 hoàn thành?', 'Theo phương án sơ bộ, dự kiến hoàn thành quý IV/2029; thời hạn hoạt động 70 năm kể từ ngày được cho thuê đất.'],
   ['Có nên mua đất quanh khu thương mại tự do Bà Nà?', 'Chỉ nên mua khi đã kiểm tra quy hoạch sử dụng đất từng thửa, đất ở có sổ, không nằm trong diện thu hồi; dự án mới ở bước chấp thuận chủ trương nên đây là kênh đầu tư dài hạn.'],
  ],
 },
 'sources': [
  'https://tuoitre.vn/khu-thuong-mai-tu-do-da-nang-kita-trung-nam-dau-tu-khu-chuc-nang-154ha-von-hon-3354-ti-dong-100261013133140801.htm',
  'https://www.sggp.org.vn/da-nang-hon-3300-ty-dong-dau-tu-du-an-ha-tang-ket-noi-khu-thuong-mai-tu-do-post876361.html',
  'https://danviet.vn/khu-thuong-mai-tu-do-da-nang-co-nha-dau-tu-du-an-hon-3300-ty-dong-d1466850.html',
  'https://tienphong.vn/dau-tu-du-an-70-nam-tai-khu-thuong-mai-tu-do-da-nang-post1884827.tpo',
  'https://viettimes.vn/da-nang-chap-thuan-cho-kita-trung-nam-lam-nha-dau-tu-ha-tang-ftz-so-6-post206956.html',
  'https://nhadautu.vn/kita-trung-nam-tham-gia-cuoc-dua-dau-tu-vao-khu-thuong-mai-tu-do-da-nang-d106898.html',
  'https://tapchicongthuong.vn/thanh-lap-khu-thuong-mai-tu-do-da-nang-quy-mo-hon-1-880-ha-141815.htm',
 ],
 'follow_sources': False,
 'follow_domains': ['tuoitre.vn', 'sggp.org.vn', 'tienphong.vn'],
 'image': {'name': slug, 'alt': 'Khu thương mại tự do Đà Nẵng vị trí số 6 ở Bà Nà: KITA Trung Nam, 154 ha, hơn 3.354 tỷ đồng', 'caption': 'Đồ hoạ: hiephoangmt.com, tổng hợp từ Tuổi Trẻ, SGGP, Tiền Phong, 13/10/2026.', 'file': slug + '.jpg'},
}
json.dump(n, open('ftz6-kita-trung-nam.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

W, H = 1200, 675
NAVY = (11, 26, 42)
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
for k in range(4):
    g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD = '#e8b04a'
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((56, 40), 'KHU THƯƠNG MẠI TỰ DO ĐÀ NẴNG · 13/10/2026', font=f(22, True), fill=GOLD)
d.text((56, 80), 'FTZ số 6 – xã Bà Nà', font=f(54, True), fill='white')
d.text((56, 150), 'Nhà đầu tư: Công ty TNHH FTZ KITA Trung Nam', font=f(28), fill=(190, 210, 230))
stats = [('154 ha', 'quy mô khu chức năng'), ('> 3.354 tỷ', 'tổng vốn đầu tư'), ('70 năm', 'thời hạn dự án'), ('Quý IV/2029', 'dự kiến hoàn thành')]
for i, (big, small) in enumerate(stats):
    x = 56 + (i % 2) * 330; y = 225 + (i // 2) * 150
    d.rounded_rectangle([x, y, x + 305, y + 128], 14, fill=(16, 40, 64), outline=GOLD, width=2)
    d.text((x + 22, y + 18), big, font=f(42 if len(big) < 10 else 36, True), fill=GOLD)
    d.text((x + 22, y + 80), small, font=f(21), fill=(200, 215, 230))
# sơ đồ minh hoạ 7 vị trí FTZ (không theo tỷ lệ)
d.text((760, 225), 'Khu thương mại tự do Đà Nẵng', font=f(22, True), fill='white')
d.text((760, 256), '1.881 ha · 7 vị trí (minh hoạ)', font=f(18), fill=(170, 190, 210))
pts = [(820, 330), (900, 300), (980, 340), (1060, 310), (850, 430), (960, 450), (1080, 420)]
for i, (x, y) in enumerate(pts, 1):
    hot = i in (5, 6)
    r = 34 if i == 6 else 24
    d.ellipse([x - r, y - r, x + r, y + r], fill=(232, 176, 74) if i == 6 else ((64, 132, 186) if hot else (52, 80, 110)), outline='white', width=2)
    d.text((x, y), str(i), font=f(22 if i == 6 else 18, True), fill=NAVY if i == 6 else 'white', anchor='mm')
d.text((760, 500), 'Số 6: KITA Trung Nam (154 ha)', font=f(19, True), fill=GOLD)
d.text((760, 530), 'Số 5: doanh nghiệp Sun Group (~90 ha)', font=f(19), fill=(120, 190, 235))
d.text((56, 600), 'Vốn điều lệ 800 tỷ: Trung Nam 70% · Tập đoàn KITA 30% · QĐ 4648/QĐ-UBND', font=f(19), fill=(170, 190, 210))
d.text((W - 56, 632), 'hiephoangmt.com', font=f(22, True), fill='white', anchor='ra')
im.save(slug + '.jpg', quality=88)
print('ok')
