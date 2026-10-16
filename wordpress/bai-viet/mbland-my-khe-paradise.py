import json, math
from PIL import Image, ImageDraw, ImageFont
slug = 'mbland-my-khe-paradise-268-vo-nguyen-giap-kinh-te-dem'
title = 'MBLand Mỹ Khê Paradise: đề xuất tổ hợp 5.000 tỷ đồng ở 268 Võ Nguyên Giáp – kinh tế đêm, khách sạn 400 phòng, đường mở lối An Thượng ra biển'
content = """<p><strong>MBLand Mỹ Khê Paradise</strong> là tổ hợp kinh tế đêm – khách sạn – văn phòng mà MBLand Đà Nẵng vừa đề xuất trên khu đất <strong>11.465 m²</strong> tại <strong>số 268 Võ Nguyên Giáp</strong>, phường Ngũ Hành Sơn, đối diện bãi biển Mỹ Khê và khu phố du lịch An Thượng. Tổng mức đầu tư dự kiến <strong>5.000 tỷ đồng</strong>, chia 3 giai đoạn. Thông tin được Cổng Thông tin điện tử TP Đà Nẵng công bố trong thông tin báo chí chiều 23/9/2026.</p>

<!--hh-featured-->

<h2>MBLand Mỹ Khê Paradise gồm những gì?</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Nội dung đề xuất</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Số 268 Võ Nguyên Giáp, phường Ngũ Hành Sơn – khu đất hai mặt tiền, đối diện biển Mỹ Khê và phố du lịch An Thượng</td></tr>
<tr><td>Diện tích</td><td>11.465 m²</td></tr>
<tr><td>Tổng mức đầu tư</td><td>Khoảng 5.000 tỷ đồng, triển khai 3 giai đoạn</td></tr>
<tr><td>Khu kinh tế đêm</td><td>Khoảng 8.000 m²: ẩm thực, chợ hải sản Vạn Chài, vui chơi giải trí, văn hóa nghệ thuật, sản phẩm OCOP, sân khấu biểu diễn</td></tr>
<tr><td>Khách sạn – văn phòng</td><td>Khối 10 tầng, khoảng 400 phòng; khối đế thương mại có không gian ẩm thực, sự kiện, triển lãm</td></tr>
<tr><td>Giao thông</td><td>Tuyến đường nội khu nối đường Trần Bạch Đằng với Võ Nguyên Giáp, mở lối từ khu An Thượng ra biển Mỹ Khê</td></tr>
<tr><td>Cầu đi bộ</td><td>Cầu cảnh quan bắc qua đường Võ Nguyên Giáp, nối tổ hợp với bãi biển – doanh nghiệp tự bỏ vốn</td></tr>
</tbody>
</table>

<h2>Tuyến đường mở lối từ An Thượng ra biển</h2>
<p>Điểm đáng chú ý nhất với người dân và nhà đầu tư quanh khu An Thượng là <strong>tuyến đường nội khu nối Trần Bạch Đằng với Võ Nguyên Giáp</strong>. Nếu tuyến đường này cùng cầu đi bộ qua Võ Nguyên Giáp được làm, khu phố du lịch An Thượng có thêm một lối đi thẳng ra bãi biển Mỹ Khê, nối dòng khách giữa phố đêm, tổ hợp và bãi tắm.</p>

<h2>Không chỉ Mỹ Khê: MBLand đề xuất hơn 10.000 tỷ đồng tại Đà Nẵng</h2>
<p>Cùng đợt làm việc với thành phố, MBLand còn đề xuất <strong>MBLand Retreat</strong> – khu nghỉ dưỡng tại Đồng Nà – Bến Trễ (phường Hội An Tây), tổng mức đầu tư dự kiến <strong>5.500 tỷ đồng</strong>. Tính chung, doanh nghiệp dự kiến đầu tư hơn <strong>10.000 tỷ đồng</strong> tại Đà Nẵng trong 5 năm tới, đồng thời đề nghị được giao khai thác hoặc tham gia đấu thầu dịch vụ du lịch trên bãi biển Mỹ Khê. Tại Đà Nẵng, MBLand đang phát triển dự án căn hộ <a href="/du-an/the-camellia-son-tra/">The Camellia Sơn Trà</a>.</p>
<p>Theo Cổng Thông tin điện tử thành phố, các đề xuất đã được lãnh đạo thành phố ghi nhận và đang xem xét. Chủ tịch UBND TP Nguyễn Mạnh Hùng đánh giá các đề xuất phù hợp định hướng phát triển du lịch chất lượng cao, kinh tế đêm và du lịch văn hóa, đồng thời lưu ý thành phố cần chú trọng hơn đến thời gian lưu trú và mức chi tiêu của du khách.</p>

<h2>MBLand Mỹ Khê Paradise tác động gì đến bất động sản ven biển?</h2>
<ul>
<li><strong>Khu An Thượng – Mỹ An:</strong> nhà phố, homestay, khách sạn nhỏ quanh phố du lịch hưởng lợi trực tiếp nếu có lối đi bộ ra biển và một khu kinh tế đêm quy mô lớn kéo khách ở lại buổi tối.</li>
<li><strong>Khách sạn ven biển:</strong> thêm khoảng 400 phòng khách sạn – văn phòng ngay mặt tiền Võ Nguyên Giáp. Cạnh tranh tăng với khách sạn 3 – 4 sao quanh đó, nhưng cũng nâng mặt bằng dịch vụ của khu. Xem bảng giá khách sạn hiện nay tại bài <a href="/ban-khach-san-da-nang-ven-bien-gia-cong-suat/">bán khách sạn Đà Nẵng ven biển</a>.</li>
<li><strong>Đất mặt tiền Võ Nguyên Giáp:</strong> mặt bằng rao bán đã cao, khoảng 130 – 390 triệu/m² tùy lô (giá rao tham khảo, xem <a href="/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/">giá đất ven biển Võ Nguyên Giáp</a>). Tin dự án dễ bị dùng để "thổi" giá, nhất là các lô trong kiệt quanh An Thượng.</li>
</ul>

<h2>Lưu ý: MBLand Mỹ Khê Paradise mới ở bước đề xuất</h2>
<p>Dự án mới là <strong>ý tưởng doanh nghiệp đề xuất</strong>, thành phố đang xem xét; chưa có quyết định chấp thuận chủ trương đầu tư, chưa có quy hoạch chi tiết, chưa mở bán sản phẩm nào. Các con số về quy mô, số phòng, tiến độ có thể thay đổi khi thẩm định. Người mua nhà đất quanh khu vực nên kiểm tra quy hoạch từng thửa và không xuống tiền chỉ vì tin "sắp có dự án".</p>
<p>Cần định giá nhà phố, khách sạn khu An Thượng – Võ Nguyên Giáp hoặc tìm <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Mỹ Khê</a>, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'MBLand Đà Nẵng đề xuất tổ hợp MBLand Mỹ Khê Paradise 5.000 tỷ đồng trên 11.465 m² tại 268 Võ Nguyên Giáp: khu kinh tế đêm 8.000 m², khách sạn – văn phòng 10 tầng 400 phòng, đường nội khu nối Trần Bạch Đằng ra biển Mỹ Khê.',
 'keyword': 'MBLand Mỹ Khê Paradise',
 'keywords_extra': ['MBLand Đà Nẵng', '268 Võ Nguyên Giáp', 'kinh tế đêm Mỹ Khê', 'An Thượng', 'MBLand Retreat Hội An'],
 'category': 'Hạ tầng & quy hoạch',
 'tags': ['MBLand', 'Biển Mỹ Khê', 'Kinh tế đêm Đà Nẵng', 'Bất động sản Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'MBLand Mỹ Khê Paradise: tổ hợp 5.000 tỷ ở 268 Võ Nguyên Giáp',
  'desc': 'MBLand Mỹ Khê Paradise: đề xuất 5.000 tỷ đồng, 11.465 m² tại 268 Võ Nguyên Giáp – kinh tế đêm 8.000 m², khách sạn 400 phòng, đường nối An Thượng ra biển.',
  'points': [
   'Tổ hợp 5.000 tỷ đồng, 3 giai đoạn, trên 11.465 m² tại 268 Võ Nguyên Giáp, đối diện biển Mỹ Khê',
   'Khu kinh tế đêm khoảng 8.000 m², khách sạn – văn phòng 10 tầng khoảng 400 phòng',
   'Đường nội khu nối Trần Bạch Đằng – Võ Nguyên Giáp và cầu đi bộ qua đường ra biển',
   'Mới là đề xuất, thành phố ghi nhận và đang xem xét; chưa có chủ trương đầu tư',
  ],
  'faq': [
   ['MBLand Mỹ Khê Paradise ở đâu?', 'Tại số 268 Võ Nguyên Giáp, phường Ngũ Hành Sơn, Đà Nẵng – khu đất hai mặt tiền khoảng 11.465 m², đối diện bãi biển Mỹ Khê và khu phố du lịch An Thượng.'],
   ['MBLand Mỹ Khê Paradise có những gì?', 'Theo đề xuất: khu kinh tế đêm khoảng 8.000 m² (ẩm thực, chợ hải sản Vạn Chài, giải trí, sân khấu, OCOP), khối khách sạn – văn phòng 10 tầng khoảng 400 phòng, đường nội khu nối Trần Bạch Đằng với Võ Nguyên Giáp và cầu đi bộ qua đường ra biển.'],
   ['Tổng vốn MBLand Mỹ Khê Paradise bao nhiêu?', 'Khoảng 5.000 tỷ đồng, chia 3 giai đoạn. Cùng đợt, MBLand đề xuất khu nghỉ dưỡng MBLand Retreat ở Hội An Tây khoảng 5.500 tỷ đồng.'],
   ['Dự án đã được duyệt chưa?', 'Chưa. Theo Cổng Thông tin điện tử TP Đà Nẵng, các đề xuất đã được lãnh đạo thành phố ghi nhận và đang xem xét; chưa có quyết định chấp thuận chủ trương đầu tư.'],
  ],
 },
 'sources': [
  'https://danang.gov.vn/en/w/thong-tin-bao-chi-chieu-23-9-2026',
 ],
 'follow_sources': False,
 'follow_domains': ['danang.gov.vn'],
 'image': {'name': slug, 'alt': 'MBLand Mỹ Khê Paradise tại 268 Võ Nguyên Giáp: tổ hợp 5.000 tỷ đồng, kinh tế đêm, khách sạn 400 phòng', 'caption': 'Đồ hoạ minh hoạ (không theo tỷ lệ): hiephoangmt.com, tổng hợp từ Cổng Thông tin điện tử TP Đà Nẵng, 23/9/2026.', 'file': slug + '.jpg'},
}
json.dump(n, open('mbland-my-khe-paradise.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

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
d.text((56, 40), 'ĐỀ XUẤT ĐẦU TƯ · BIỂN MỸ KHÊ', font=f(22, True), fill=GOLD)
d.text((56, 80), 'MBLand Mỹ Khê Paradise', font=f(52, True), fill='white')
d.text((56, 148), 'Số 268 Võ Nguyên Giáp, phường Ngũ Hành Sơn, Đà Nẵng', font=f(26), fill=(190, 210, 230))
stats = [('5.000 tỷ', 'tổng mức đầu tư · 3 giai đoạn'), ('11.465 m²', 'diện tích khu đất'), ('8.000 m²', 'khu kinh tế đêm'), ('400 phòng', 'khách sạn – văn phòng 10 tầng')]
for i, (big, small) in enumerate(stats):
    x = 56 + (i % 2) * 330; y = 220 + (i // 2) * 150
    d.rounded_rectangle([x, y, x + 305, y + 128], 14, fill=(16, 40, 64), outline=GOLD, width=2)
    d.text((x + 22, y + 18), big, font=f(40, True), fill=GOLD)
    d.text((x + 22, y + 84), small, font=f(17), fill=(200, 215, 230))
# Sơ đồ minh hoạ vị trí (không theo tỷ lệ): phố An Thượng – tổ hợp – Võ Nguyên Giáp – biển
X0, X1 = 740, 1150
d.text((X0, 220), 'Sơ đồ minh hoạ (không theo tỷ lệ)', font=f(17), fill=(170, 190, 210))
d.rectangle([1080, 250, 1150, 560], fill=(40, 110, 160))
d.text((1115, 380), 'BIỂN', font=f(15, True), fill='white', anchor='mm')
d.text((1115, 402), 'MỸ', font=f(15, True), fill='white', anchor='mm')
d.text((1115, 424), 'KHÊ', font=f(15, True), fill='white', anchor='mm')
d.rectangle([1050, 250, 1068, 560], fill=(120, 130, 140))
d.text((1059, 575), 'Võ Nguyên Giáp', font=f(15), fill=(200, 215, 230), anchor='mm')
d.rounded_rectangle([900, 330, 1040, 470], 10, fill=(232, 176, 74))
d.text((970, 385), 'Tổ hợp', font=f(18, True), fill=NAVY, anchor='mm')
d.text((970, 412), 'MBLand', font=f(18, True), fill=NAVY, anchor='mm')
d.line([(1040, 470 - 10), (1080, 470 - 10)], fill='white', width=3)
d.text((1000, 495), 'cầu đi bộ qua đường →', font=f(14), fill='white', anchor='mm')
d.rectangle([X0, 250, X0 + 18, 560], fill=(120, 130, 140))
d.text((X0 + 9, 575), 'Trần Bạch Đằng', font=f(15), fill=(200, 215, 230), anchor='lm')
d.line([(X0 + 18, 400), (900, 400)], fill=GOLD, width=5)
d.text((828, 422), 'đường nội khu', font=f(15, True), fill=GOLD, anchor='mm')
d.rounded_rectangle([775, 270, 880, 350], 8, fill=(52, 80, 110))
d.text((827, 310), 'Phố An Thượng', font=f(14, True), fill='white', anchor='mm')
d.text((56, 600), 'Mới là đề xuất – TP đang xem xét · Nguồn: Cổng TTĐT TP Đà Nẵng 23/9/2026', font=f(19), fill=(170, 190, 210))
d.text((W - 56, 632), 'hiephoangmt.com', font=f(22, True), fill='white', anchor='ra')
im.save(slug + '.jpg', quality=88)
print('ok')
