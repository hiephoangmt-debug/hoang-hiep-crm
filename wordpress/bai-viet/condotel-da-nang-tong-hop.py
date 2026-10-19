import json, math
from PIL import Image, ImageDraw, ImageFont
slug = 'condotel-can-ho-dich-vu-da-nang-tong-hop-gia-2026'
title = 'Condotel Đà Nẵng 2026: tổng hợp căn hộ dịch vụ, căn hộ khách sạn, căn hộ nghỉ dưỡng – thời gian bán, giá hiện tại'
T = lambda s: s  # giữ nguyên chuỗi
content = """<p><strong>Condotel Đà Nẵng</strong> và các dòng căn hộ dịch vụ, căn hộ khách sạn, căn hộ nghỉ dưỡng đang chia thành hai nhóm rất khác nhau: nhóm <strong>dự án mới</strong> của Sun Group, Nobu, Wyndham… đang mở bán hoặc nhận giữ chỗ với giá sơ cấp 70 – 170 triệu/m², và nhóm <strong>condotel đã vận hành</strong> từ 2014 – 2022 đang được rao chuyển nhượng 20 – 120 triệu/m², nhiều căn bán dưới giá gốc. Bài tổng hợp từng dự án theo thời gian mở bán, bàn giao, pháp lý và giá tham khảo tháng 10/2026, từ báo chí, văn bản cơ quan nhà nước, trang chủ đầu tư và tin rao trên các sàn (batdongsan.com.vn, homedy, alonhadat…).</p>

<!--hh-featured-->

<h2>Condotel Đà Nẵng, căn hộ dịch vụ, căn hộ khách sạn khác nhau thế nào?</h2>
<table>
<thead><tr><th>Loại hình</th><th>Pháp lý thường gặp</th><th>Ai hợp</th></tr></thead>
<tbody>
<tr><td>Condotel / căn hộ du lịch / căn hộ khách sạn</td><td>Trên đất thương mại dịch vụ, thời hạn theo dự án (thường 50 năm); Nghị định 10/2023 cho phép cấp giấy chứng nhận khi đủ điều kiện</td><td>Đầu tư cho thuê qua đơn vị vận hành khách sạn</td></tr>
<tr><td>Căn hộ thương mại dịch vụ (căn hộ dịch vụ)</td><td>Có thời hạn hoặc theo thời hạn đất của dự án – mỗi dự án ghi khác nhau, phải đọc kỹ hợp đồng</td><td>Cho thuê ngắn – dài hạn, ở kết hợp</td></tr>
<tr><td>Căn hộ hàng hiệu (branded residences)</td><td>Tùy dự án: có nơi là chung cư sở hữu lâu dài, có nơi là căn hộ du lịch có thời hạn</td><td>Khách mua tài sản cao cấp, giữ giá, có dịch vụ khách sạn</td></tr>
<tr><td>Căn hộ chung cư ven biển, ven sông</td><td>Đất ở, sở hữu lâu dài cho người Việt Nam</td><td>Mua để ở, cho thuê dài hạn</td></tr>
</tbody>
</table>
<p>Cùng gọi là "căn hộ biển" nhưng thời hạn sở hữu, khả năng vay ngân hàng và giá bán lại chênh nhau rất xa – vì vậy bài tách riêng từng loại.</p>

<h2>Dự án condotel Đà Nẵng đang bán và sắp bán (10/2026)</h2>
<table>
<thead><tr><th>Dự án</th><th>Chủ đầu tư · vị trí</th><th>Quy mô</th><th>Mở bán · bàn giao</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td><a href="/du-an/sun-costa-residence/">Sun Costa Residence</a></td><td>Sun Group · Vương Thừa Vũ – Hồ Nghinh, Sơn Trà, cách biển Mỹ Khê 200 – 300 m</td><td>2 tòa 25 tầng, khoảng 560 – 640 căn, phần lớn studio</td><td>Mở bán 15/5/2025 · bàn giao dự kiến quý IV/2026 – 2027 (nguồn khác nhau)</td><td>Giá bán 2025: studio 2,45 – 2,95 tỷ, 1PN+ 3,75 – 4,5 tỷ, 2PN 4,5 – 5,5 tỷ (chưa VAT). Chuyển nhượng 2026: khoảng 70 – 88 triệu/m² (tin rao)</td></tr>
<tr><td><a href="/du-an/nobu-da-nang/">Nobu Residences Đà Nẵng</a></td><td>VCRE · 01 Võ Văn Kiệt (góc Võ Nguyên Giáp), mặt biển Mỹ Khê</td><td>43 tầng (186 m): 264 căn hộ hàng hiệu, 186 phòng khách sạn Nobu</td><td>Bán từ quý 2/2024 · bàn giao dự kiến 2027</td><td>Chính sách 1/2025 "từ": studio 5,1 tỷ, 1PN 7 tỷ, 2PN 10 tỷ, 3PN 15 tỷ. Tin rao 2026: khoảng 150 – 170 triệu/m²</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil Đà Nẵng</a> – tòa A1</td><td>PPC An Thịnh · 02 Phạm Văn Đồng, Sơn Trà</td><td>Tòa A1 khoảng 1.168 căn hộ khách sạn</td><td>Đang bán · A1 bàn giao dự kiến quý 4/2027</td><td>Chính sách 1/2026: studio 2,95 – 3,69 tỷ, 1PN 4,5 – 5,6 tỷ, 2PN 6,5 – 10,5 tỷ</td></tr>
<tr><td><a href="/du-an/m-riverside-da-nang/">M Riverside Đà Nẵng</a></td><td>Kyoritsu Maintenance Việt Nam · số 6 đường 2/9, Hải Châu, ven sông Hàn</td><td>25 tầng, 312 căn (studio, 1PN, 2PN)</td><td>Đang hoàn tất thủ tục mở bán (báo chí 6 – 9/2026)</td><td>Dự kiến từ 3,5 tỷ/căn; khoảng 117 – 128 triệu/m² chưa VAT (trang dự án)</td></tr>
<tr><td><a href="/du-an/sun-galaxy-complex/">Sun Galaxy Complex</a></td><td>Sun Group · Chương Dương, Ngũ Hành Sơn, ven sông Hàn</td><td>Khoảng 1.400 phòng lưu trú (báo chí); đại lý nêu 2 tòa 47 tầng, khoảng 3.800 căn</td><td>Khởi công 25/7/2026 · thi công khoảng 36 tháng; đang nhận giữ chỗ</td><td>Chưa có bảng giá chính thức</td></tr>
<tr><td><a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a></td><td>Sun Group · Trường Sa – Nguyễn Đức Thuận, khu Sơn Thủy</td><td>30 tầng, 782 căn (513 studio 30 – 31 m²)</td><td>Nhận giữ chỗ từ 10/2026 · bàn giao dự kiến 11/2028</td><td>Chưa công bố giá</td></tr>
<tr><td><a href="/du-an/alize-da-nang/">Alizé Đà Nẵng</a></td><td>Vòng xoay Võ Nguyên Giáp – Võ Văn Kiệt, mặt biển Mỹ Khê</td><td>Tòa 40 tầng căn hộ khách sạn</td><td>Sắp mở bán – chưa có thông tin chính thức</td><td>Trang đại lý: từ khoảng 5 tỷ/căn (chưa kiểm chứng)</td></tr>
<tr><td>T&amp;T Twin Towers (dự án Times Square Đà Nẵng)</td><td>T&amp;T Group · Phạm Văn Đồng – Võ Nguyên Giáp</td><td>2 tòa khoảng 50 tầng, hơn 1.000 căn condotel</td><td>Chưa mở bán chính thức</td><td>Dự kiến 150 – 200 triệu/m² chưa VAT (theo trang T&amp;T Land)</td></tr>
</tbody>
</table>
<p>Ghi chú: giá "chính sách" là giá đơn vị phân phối công bố từng thời điểm, đã hoặc chưa trừ chiết khấu tùy nguồn; giá chuyển nhượng là giá chào trên tin rao, chưa phải giá giao dịch. Một số dự án hay bị gọi là "căn hộ biển" nhưng là <strong>chung cư sở hữu lâu dài</strong>, không phải condotel: <a href="/du-an/sun-ponte-residence/">Sun Ponte Residence</a> (đang bàn giao từ 2026, tin rao 64 – 99 triệu/m²), The Legend Đà Nẵng (800 căn đủ điều kiện bán từ 30/1/2026, bàn giao dự kiến quý I/2028), Sun Symphony, Hiyori, Peninsula.</p>

<h2>Condotel Đà Nẵng đã vận hành: giá chuyển nhượng 2026</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí · vận hành</th><th>Quy mô · năm</th><th>Pháp lý (theo nguồn công khai)</th><th>Giá rao 2026</th></tr></thead>
<tbody>
<tr><td>Meliá Vinpearl Danang Riverfront (Vinpearl Condotel Riverfront)</td><td>341 Trần Hưng Đạo, Sơn Trà, ven sông Hàn · Meliá (từ 2022)</td><td>36 tầng · mở bán khoảng 2016, giá 2 – 3,6 tỷ/căn</td><td>Tin rao ghi "sổ hồng"; chưa có nguồn chính thống xác nhận</td><td>Khoảng 23 – 53 triệu/m²; căn 37 – 52 m² khoảng 1,3 – 2,6 tỷ</td></tr>
<tr><td>À La Carte Đà Nẵng Beach</td><td>Võ Nguyên Giáp – Dương Đình Nghệ, Sơn Trà · À La Carte (TASECO)</td><td>21 tầng, 170 căn hộ khách sạn</td><td>Tin rao ghi "sổ hồng"; chưa có nguồn chính thống xác nhận</td><td>Khoảng 44 – 122 triệu/m² tùy view; căn 42 m² từ khoảng 2 tỷ, căn góc 2PN 115 m² khoảng 14 tỷ</td></tr>
<tr><td>Fusion Suites Đà Nẵng Beach</td><td>88 Võ Nguyên Giáp, Sơn Trà · Fusion</td><td>21 tầng, 124 căn · hoàn thành 2014</td><td>Tin rao ghi khác nhau ("sổ hồng", "chờ sổ")</td><td>Khoảng 42 – 138 triệu/m² (các sàn chênh nhiều); căn 37 – 65 m² khoảng 1,9 – 6,3 tỷ</td></tr>
<tr><td>TMS Luxury Hotel Đà Nẵng Beach</td><td>Võ Nguyên Giáp, Ngũ Hành Sơn · Welham</td><td>25 tầng, 146 căn hộ khách sạn · bán 2018</td><td>Chưa tìm thấy nguồn chính thống về sổ</td><td>Khoảng 43 – 48 triệu/m²; căn 45 m² khoảng 2,8 tỷ</td></tr>
<tr><td><a href="/du-an/wyndham-soleil-da-nang/">Wyndham Soleil</a> – tòa D</td><td>02 Phạm Văn Đồng, Sơn Trà · Wyndham</td><td>Bàn giao từ 2025</td><td>Căn hộ khách sạn 50 năm (theo nguồn phân phối)</td><td>Studio 35 – 38 m² khoảng 2,4 – 3,8 tỷ; khoảng 65 – 100 triệu/m²</td></tr>
<tr><td><a href="/du-an/hyatt-regency-danang-residences/">Hyatt Regency Danang Residences</a></td><td>Trường Sa, Ngũ Hành Sơn · Hyatt</td><td>174 căn hộ, 27 biệt thự · bán 2012 – 2014</td><td>Căn hộ nghỉ dưỡng, người Việt Nam được cấp sổ sở hữu lâu dài (Báo Pháp luật)</td><td>Khoảng 68 – 76 triệu/m²; 1PN khoảng 5 tỷ, 2PN 110 m² khoảng 8,4 tỷ</td></tr>
<tr><td><a href="/du-an/shantira-beach-resort-hoi-an/">Shantira Beach Resort Hội An</a></td><td>Lạc Long Quân, An Bàng – Điện Dương · Wyndham</td><td>2 tòa khoảng 430 căn · cất nóc 10/2020</td><td>Tin rao ghi thời hạn 50 – 70 năm; cần kiểm tra sổ từng căn</td><td>Khoảng 20 – 53 triệu/m²; studio 43 – 52 m² khoảng 1,6 – 2,65 tỷ, nhiều tin cắt lỗ</td></tr>
<tr><td>Wyndham Hội An Royal Beachfront</td><td>Cẩm An, Hội An · Wyndham</td><td>–</td><td>Căn hộ du lịch có thời hạn</td><td>Khoảng 34 – 50 triệu/m²; căn 46 m² khoảng 1,55 tỷ, nhiều tin cắt lỗ 500 – 700 triệu</td></tr>
<tr><td><a href="/du-an/hoiana-residences/">Hoiana Residences</a></td><td>Duy Hải, Hội An Nam · Rosewood Hotel Group</td><td>2 tòa 270 căn · vận hành từ cuối 2022</td><td>Có thời hạn đến 2080</td><td>Giá niêm yết từng công bố khoảng 70 – 79 triệu/m²; chưa thấy tin chuyển nhượng</td></tr>
</tbody>
</table>
<p>Giá rao condotel Đà Nẵng trên các sàn chênh rất nhiều giữa tin cũ và tin mới, giữa căn view biển và căn nội khu; một số tin là tin treo lâu. Hãy xem giá trong bảng là khoảng tham khảo, không phải giá giao dịch.</p>

<h2>Dự án condotel Đà Nẵng đang vướng pháp lý</h2>
<ul>
<li><strong>Cocobay Đà Nẵng</strong> (Trường Sa, Ngũ Hành Sơn; Công ty CP Thành Đô): khoảng 2.000 sản phẩm chủ yếu condotel, từng cam kết lợi nhuận 12%/năm trong 8 năm; ngừng chi trả từ 1/1/2020, năm 2024 chủ đầu tư đơn phương chấm dứt hợp đồng với khách hàng để tái khởi động dự án, thành phố yêu cầu báo cáo; tháng 9/2025 thành phố xác định lại giá đất, lộ trình thi công kéo đến 2029. Condotel chưa được cấp giấy chứng nhận.</li>
<li><strong>Ariyana Beach Resort &amp; Suites</strong> (Võ Nguyên Giáp, Ngũ Hành Sơn): 1.366 căn, khách đã thanh toán khoảng 95% giá trị trong 2017 – 2020 nhưng đến 5/2026 dự án chưa hoàn thành, chưa bàn giao; khách hàng kiến nghị thanh tra toàn diện, đã có bản án sơ thẩm bảo vệ quyền lợi khách hàng (CafeF, Người Lao Động, Bảo vệ Pháp luật).</li>
</ul>
<p>Với hai dự án này, mọi giao dịch mua lại hợp đồng đều rủi ro rất cao – cần luật sư kiểm tra trước khi đặt cọc.</p>

<h2>Thị trường condotel Đà Nẵng 2026 đang thế nào?</h2>
<ul>
<li><strong>Giao dịch condotel cũ rất chậm:</strong> theo DKRA, giao dịch condotel tại Đà Nẵng quý 2/2026 giảm hơn 94% so với quý trước (VietnamFinance). Nhiều căn ở Hội An, Riverfront đang rao dưới giá mở bán.</li>
<li><strong>Hàng mới định giá cao:</strong> dự án mới ven biển Mỹ Khê – sông Hàn chào 70 – 170 triệu/m², cao hơn nhiều so với mặt bằng chung cư Đà Nẵng khoảng 67 triệu/m² (Batdongsan.com.vn, quý 3/2026) hay giá sơ cấp trung bình khoảng 83 triệu/m² (CBRE).</li>
<li><strong>Pháp lý đã có lối ra:</strong> Nghị định 10/2023 cho phép cấp giấy chứng nhận quyền sở hữu cho căn hộ du lịch đủ điều kiện, nhưng việc cấp sổ thực tế vẫn chậm và tùy từng dự án.</li>
</ul>
<p>Xem thêm số liệu thị trường tại bài <a href="/thi-truong-bat-dong-san-da-nang-quy-3-2026/">thị trường bất động sản Đà Nẵng quý 3/2026</a> và <a href="/can-ho-view-bien-da-nang-my-khe/">căn hộ view biển Mỹ Khê</a>.</p>

<h2>6 điều cần kiểm tra trước khi mua condotel Đà Nẵng</h2>
<ol>
<li><strong>Loại đất và thời hạn:</strong> đất ở (lâu dài) hay đất thương mại dịch vụ (thường 50 năm, tính từ ngày giao đất chứ không phải ngày bạn mua).</li>
<li><strong>Giấy chứng nhận:</strong> dự án đã cấp sổ chưa; nếu chưa, hợp đồng ghi thời điểm và trách nhiệm cấp sổ thế nào.</li>
<li><strong>Văn bản đủ điều kiện bán</strong> nhà ở/công trình hình thành trong tương lai và bảo lãnh ngân hàng (với dự án đang xây).</li>
<li><strong>Hợp đồng vận hành:</strong> tỷ lệ chia lợi nhuận, phí quản lý, số đêm chủ nhà được ở, điều kiện chấm dứt – cam kết lợi nhuận cao là dấu hiệu cần cẩn trọng, như bài học Cocobay.</li>
<li><strong>Vay ngân hàng:</strong> condotel thường khó vay hơn chung cư; hỏi trước ngân hàng nào nhận thế chấp.</li>
<li><strong>Giá chuyển nhượng thực tế:</strong> so với giá mở bán và giá căn tương tự đã bán, không chỉ nhìn giá rao.</li>
</ol>
<p>Cần lọc danh sách căn condotel, căn hộ dịch vụ theo ngân sách, hoặc kiểm tra pháp lý một căn cụ thể trước khi đặt cọc, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
"""
n = {
 'slug': slug, 'title': title,
 'excerpt': 'Tổng hợp condotel Đà Nẵng, căn hộ dịch vụ, căn hộ khách sạn, căn hộ nghỉ dưỡng tháng 10/2026: dự án đang bán (Sun Costa, Nobu, Wyndham Soleil, M Riverside, Sun Galaxy, Sun Saphia…) và condotel đã vận hành đang chuyển nhượng – thời gian bán, pháp lý, giá tham khảo.',
 'keyword': 'condotel Đà Nẵng',
 'keywords_extra': ['căn hộ dịch vụ Đà Nẵng', 'căn hộ khách sạn Đà Nẵng', 'căn hộ nghỉ dưỡng Đà Nẵng', 'giá condotel Đà Nẵng 2026', 'căn hộ du lịch Đà Nẵng'],
 'category': 'Thị trường',
 'tags': ['Condotel Đà Nẵng', 'Căn hộ dịch vụ', 'Căn hộ biển Đà Nẵng', 'Bất động sản Đà Nẵng'],
 'content': content,
 'seo': {
  'seo_title': 'Condotel Đà Nẵng 2026: danh sách dự án, thời gian bán, giá',
  'desc': 'Condotel Đà Nẵng 2026: tổng hợp căn hộ dịch vụ, căn hộ khách sạn, nghỉ dưỡng đang bán và đã vận hành – thời gian mở bán, pháp lý, giá tham khảo 10/2026.',
  'points': [
   'Dự án mới ven biển Mỹ Khê – sông Hàn chào 70 – 170 triệu/m²: Sun Costa, Nobu, Wyndham Soleil, M Riverside',
   'Sun Galaxy, Sun Saphia đang nhận giữ chỗ, chưa có bảng giá chính thức',
   'Condotel đã vận hành rao chuyển nhượng 20 – 120 triệu/m², nhiều căn dưới giá gốc',
   'Cocobay, Ariyana đang vướng pháp lý – rủi ro cao khi mua lại hợp đồng',
  ],
  'faq': [
   ['Condotel Đà Nẵng có được cấp sổ không?', 'Nghị định 10/2023 cho phép cấp giấy chứng nhận quyền sở hữu cho căn hộ du lịch đủ điều kiện, thời hạn theo thời hạn sử dụng đất của dự án (thường 50 năm). Việc cấp sổ thực tế tùy từng dự án, cần kiểm tra hồ sơ từng căn.'],
   ['Giá condotel Đà Nẵng hiện nay bao nhiêu?', 'Theo tin rao tháng 10/2026: condotel đã vận hành khoảng 20 – 120 triệu/m² tùy dự án và view; dự án mới ven biển, ven sông chào khoảng 70 – 170 triệu/m². Đây là giá tham khảo, chưa phải giá giao dịch.'],
   ['Dự án căn hộ dịch vụ nào ở Đà Nẵng đang mở bán?', 'Sun Costa Residence, Nobu Residences, Wyndham Soleil tòa A1 đang bán; M Riverside đang hoàn tất thủ tục mở bán; Sun Galaxy Complex, Sun Saphia Residence đang nhận giữ chỗ; Alizé, T&T Twin Towers chưa mở bán chính thức.'],
   ['Có nên mua lại condotel Cocobay hay Ariyana?', 'Hai dự án đang vướng pháp lý: Cocobay ngừng chi trả cam kết từ 2020 và chủ đầu tư đơn phương chấm dứt hợp đồng năm 2024; Ariyana chưa bàn giao dù khách đã trả khoảng 95% giá trị. Rủi ro rất cao, cần luật sư kiểm tra trước khi giao dịch.'],
   ['Sun Ponte, The Legend có phải condotel không?', 'Không. Sun Ponte Residence và The Legend Đà Nẵng là chung cư trên đất ở, sở hữu lâu dài cho người Việt Nam.'],
  ],
 },
 'sources': [
  'https://vietnamnet.vn/sun-group-cong-bo-sieu-pham-sun-costa-residence-can-bien-my-khe-da-nang-2400409.html',
  'https://baodautu.vn/vcre-cung-nobu-hospitality-kien-tao-bieu-tuong-phong-cach-song-tai-da-nang-d189851.html',
  'https://vnexpress.net/tiem-nang-khai-thac-cua-can-ho-m-riverside-danang-ven-song-han-5117113.html',
  'https://cafeland.vn/tin-tuc/khoi-cong-du-an-gan-10750-ty-dong-tai-da-nang-153588.html',
  'https://vietnamfinance.vn/800-can-ho-tai-the-legend-city-danang-du-dieu-kien-mo-ban-d139616.html',
  'https://baophapluat.vn/bat-dong-san-cua-du-an-hyatt-regency-danang-residences-hut-khach-post89178.html',
  'https://baodautu.vn/batdongsan/cat-noc-toa-a-can-ho-resort-cao-nhat-hoi-an---du-an-shantira-beach-resort--spa-d130577.html',
  'https://tuoitre.vn/hien-trang-du-an-cocobay-ma-thanh-do-don-phuong-cham-dut-hop-dong-bi-yeu-cau-bao-cao-20240503173147718.htm',
  'https://dantri.com.vn/bat-dong-san/xac-dinh-lai-gia-dat-tai-sieu-du-an-cocobay-da-nang-20250911090736302.htm',
  'https://cafef.vn/vu-cham-ban-giao-can-ho-du-an-ariyana-khach-hang-kien-nghi-thanh-tra-toan-dien-188260511155712846.chn',
  'https://vietnamfinance.vn/condotel-giam-hon-94-giao-dich-bat-dong-san-nghi-duong-da-nang-dong-cung-d148414.html',
  'https://tuoitre.vn/cap-so-cho-condotel-van-vuong-20230713082553845.htm',
  'https://batdongsan.com.vn/ban-condotel-wyndham-soleil-da-nang',
  'https://homedy.com/ban-can-ho-condotel-da-nang',
 ],
 'follow_sources': False,
 'follow_domains': ['vnexpress.net', 'tuoitre.vn', 'baodautu.vn', 'vietnamfinance.vn'],
 'image': {'name': slug, 'alt': 'Biểu đồ khoảng giá condotel Đà Nẵng 2026: dự án mới và condotel đã vận hành (triệu/m², tham khảo)', 'caption': 'Đồ hoạ: hiephoangmt.com, tổng hợp từ báo chí, trang chủ đầu tư và tin rao các sàn, 10/2026 – giá tham khảo.', 'file': slug + '.jpg'},
}
json.dump(n, open('condotel-da-nang-tong-hop.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

# Biểu đồ khoảng giá (triệu/m²) – thanh ngang từ min đến max.
W, H = 1200, 675
NAVY = (11, 26, 42); GOLD = (232, 176, 74); BLUE = (120, 190, 235)
base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 12))
for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 12))
im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
d.rectangle([0, 0, W, 8], fill=GOLD)
d.text((48, 30), 'CONDOTEL ĐÀ NẴNG · GIÁ THAM KHẢO 10/2026', font=f(22, True), fill=GOLD)
d.text((48, 64), 'Khoảng giá (triệu/m²)', font=f(36, True), fill='white')
rows = [
 ('Nobu Residences', 150, 170, GOLD), ('M Riverside (dự kiến)', 117, 128, GOLD), ('Sun Costa (chuyển nhượng)', 70, 88, GOLD), ('Wyndham Soleil tòa D', 65, 100, BLUE),
 ('À La Carte', 44, 122, BLUE), ('Fusion Suites', 42, 138, BLUE), ('Hyatt Residences', 68, 76, BLUE), ('TMS Luxury', 43, 48, BLUE), ('Riverfront (Meliá)', 23, 53, BLUE), ('Shantira Hội An', 20, 53, BLUE),
]
X0, X1, vmax = 360, 1130, 180
sx = lambda v: X0 + (X1 - X0) * v / vmax
y0 = 130
for v in range(0, vmax + 1, 30):
    d.line([sx(v), y0 - 6, sx(v), y0 + 10 * 44], fill=(60, 80, 105), width=1)
    d.text((sx(v), y0 + 10 * 44 + 6), str(v), font=f(15), fill=(170, 190, 210), anchor='ma')
for i, (name, lo, hi, col) in enumerate(rows):
    y = y0 + i * 44 + 14
    d.text((48, y), name, font=f(18, i < 3), fill='white', anchor='lm')
    d.rounded_rectangle([sx(lo), y - 10, sx(hi), y + 10], 10, fill=col)
    d.text((sx(hi) + 10, y), f'{lo} – {hi}', font=f(16, True), fill=col, anchor='lm')
d.rounded_rectangle([48, 600, 66, 616], 4, fill=GOLD); d.text((74, 608), 'Dự án mới / đang bán', font=f(16), fill='white', anchor='lm')
d.rounded_rectangle([290, 600, 308, 616], 4, fill=BLUE); d.text((316, 608), 'Condotel đã vận hành – giá rao chuyển nhượng', font=f(16), fill='white', anchor='lm')
d.text((48, 640), 'Nguồn: báo chí, trang chủ đầu tư, batdongsan.com.vn, homedy, alonhadat – giá chào, không phải giá giao dịch', font=f(14), fill=(170, 190, 210))
d.text((W - 48, 640), 'hiephoangmt.com · 0904 567 009', font=f(16, True), fill='white', anchor='ra')
im.save(slug + '.jpg', quality=88)
print('ok')
