import json,re
content = """<p>Người dân thường đi qua nút giao <strong>Cách Mạng Tháng Tám – Lê Thanh Nghị</strong> (phường Hòa Cường) cần chuẩn bị đổi lộ trình: liên danh nhà thầu sắp triển khai thi công <strong>hầm chui Cách Mạng Tháng Tám</strong> tại nút giao này – một hạng mục chính của cụm nút giao cầu Hòa Xuân đã khởi công ngày 25/8/2026. Theo thông tin được trang Danang 35K Feet chia sẻ ngày 9/10/2026, việc thi công hầm được chia làm <strong>2 giai đoạn</strong>, trong đó giai đoạn 1 dự kiến bắt đầu từ <strong>tháng 11/2026</strong>.</p>

<!--hh-featured-->

<h2>Hầm chui Cách Mạng Tháng Tám: thông tin chính</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Thông tin</th></tr></thead>
<tbody>
<tr><td>Vị trí</td><td>Nút giao Cách Mạng Tháng Tám – Lê Thanh Nghị, phường Hòa Cường, trên trục từ trung tâm về cầu Hòa Xuân</td></tr>
<tr><td>Thuộc dự án</td><td>Cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn cầu Hòa Xuân (khởi công 25/8/2026)</td></tr>
<tr><td>Chức năng hầm</td><td>Phục vụ hướng đi thẳng và rẽ trái gián tiếp lên cầu Hòa Xuân, tách luồng xe khỏi mặt bằng nút giao</td></tr>
<tr><td>Phân kỳ thi công hầm</td><td>2 giai đoạn (theo Danang 35K Feet)</td></tr>
<tr><td>Giai đoạn 1</td><td>Dự kiến từ tháng 11/2026 (theo Danang 35K Feet – chưa thấy thông báo chính thức nêu ngày cụ thể)</td></tr>
<tr><td>Thời gian thực hiện cả cụm nút</td><td>2026 – 2029; thi công dự kiến 730 ngày</td></tr>
</tbody>
</table>

<h2>Vì sao phải làm hầm chui tại nút Cách Mạng Tháng Tám – Lê Thanh Nghị?</h2>
<p>Đây là "cổ chai" trên trục Bắc – Nam nối trung tâm Hải Châu với cầu Hòa Xuân và toàn bộ khu đô thị phía Nam (Hòa Xuân, Hòa Quý, Điện Ngọc). Giờ cao điểm, dòng xe từ chợ đầu mối Hòa Cường, đường Lê Thanh Nghị và hướng cầu Hòa Xuân dồn về cùng một nút đèn tín hiệu, gây ùn ứ kéo dài. Hầm chui đưa dòng xe đi thẳng xuống dưới, mặt đất chỉ còn xe rẽ – nút giao sẽ thông thoáng hơn hẳn khi hoàn thành.</p>
<p>Cùng dự án còn có hầm chui trên đường Thăng Long, mở rộng đường Lê Thanh Nghị và xây thêm một cầu mới phía hạ lưu cầu Hòa Xuân hiện hữu. Chi tiết: <a href="/cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang/">cầu Hòa Xuân đã khởi công: cụm nút giao, 2 hầm chui</a>.</p>

<h2>Phương án phân luồng giao thông khi thi công</h2>
<p>Sở Xây dựng Đà Nẵng đã thống nhất phương án phân luồng phục vụ thi công cụm nút giao. Theo các báo đã đưa tin, một số điểm chính:</p>
<ul>
<li><strong>Xe container, xe tải trọng lớn được điều hướng từ xa:</strong> từ Quốc lộ 14B qua Quốc lộ 1A về đường Nam Kỳ Khởi Nghĩa, hạn chế xe nặng đi vào khu vực thi công.</li>
<li><strong>Cấm đỗ xe</strong> trên đường Nguyễn Hữu Thọ, đoạn từ Cách Mạng Tháng Tám đến Lê Đại Hành.</li>
<li><strong>Điều chỉnh dải phân cách</strong> giữa đường Cách Mạng Tháng Tám tại nút Xuân Thủy để xe quay đầu an toàn.</li>
<li><strong>Bổ sung camera giám sát</strong> để theo dõi ùn tắc, xung đột trong quá trình phân luồng; lập nhóm phối hợp gồm công an, Sở Xây dựng, UBND phường Hòa Cường, Hòa Xuân, ban quản lý dự án và nhà thầu.</li>
<li><strong>Vận hành thử phân luồng</strong> khoảng 1 tuần trước khi thi công chính thức.</li>
</ul>
<p><em>Sơ đồ rào chắn chi tiết từng giai đoạn sẽ theo thông báo của Sở Xây dựng và biển báo tại hiện trường – anh chị nên chú ý biển chỉ dẫn khi đi qua khu vực.</em></p>

<h2>Lộ trình gợi ý cho người thường xuyên qua nút giao</h2>
<ul>
<li><strong>Đi từ trung tâm về Hòa Xuân, Nam Đà Nẵng:</strong> cân nhắc đi sớm hoặc muộn hơn giờ cao điểm, chọn tuyến song song phù hợp điểm đến và theo biển chỉ dẫn phân luồng tại hiện trường.</li>
<li><strong>Đi chợ đầu mối Hòa Cường:</strong> dự trù thêm thời gian vào sáng sớm – khung giờ xe hàng hoá đông.</li>
<li><strong>Xe tải, xe container:</strong> tuân thủ hướng Quốc lộ 14B – Quốc lộ 1A – Nam Kỳ Khởi Nghĩa theo phương án phân luồng.</li>
</ul>
<p>Thời gian thi công kéo dài nhiều tháng; người dân trong khu vực sẽ phải chịu khó một thời gian, đổi lại là nút giao không còn ùn tắc khi công trình hoàn thành.</p>

<h2>Ảnh hưởng đến bất động sản phía Nam Đà Nẵng</h2>
<ul>
<li><strong>Ngắn hạn (thời gian thi công):</strong> đi lại qua nút chậm hơn, nhà mặt tiền sát công trường bị ảnh hưởng buôn bán do rào chắn, bụi, tiếng ồn.</li>
<li><strong>Dài hạn (khi hoàn thành):</strong> kết nối trung tâm – Hòa Xuân thông suốt, thời gian di chuyển ổn định – điểm cộng rõ ràng cho căn hộ, đất nền phía Nam như <a href="/du-an/sun-neo-city/">Sun NeO City</a> (Cora, Spana, S-Light Tower), <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a> (FourS Tower) và khu đô thị sinh thái Hòa Xuân.</li>
<li><strong>Với người mua để ở:</strong> nếu nhận nhà trong 2026 – 2028, nên tính trước thời gian đi lại trong giai đoạn thi công. Nhà đầu tư dài hạn có thể tận dụng giai đoạn này để chọn sản phẩm hợp lý trước khi hạ tầng hoàn thiện.</li>
</ul>
<p>Xem thêm: <a href="/tin-ha-tang-da-nang-thang-10-2026/">tin hạ tầng Đà Nẵng tháng 10/2026</a> · <a href="/khu-vuc/cam-le/">dự án khu vực Cẩm Lệ</a>. Cần tư vấn căn hộ, đất nền Hòa Xuân, gọi/Zalo <strong>Hoàng Hiệp – 0904 567 009</strong>.</p>
<p><em>Nguồn tham khảo: trang Danang 35K Feet (phân kỳ 2 giai đoạn, mốc tháng 11/2026 – ngày 9/10/2026); phương án phân luồng và thông tin dự án tổng hợp từ các báo dẫn bên dưới.</em></p>"""
d = {
 "slug": "thi-cong-ham-chui-cach-mang-thang-tam-le-thanh-nghi",
 "title": "Thi công hầm chui Cách Mạng Tháng Tám – Lê Thanh Nghị: 2 giai đoạn, phân luồng thế nào?",
 "excerpt": "Nút giao Cách Mạng Tháng Tám – Lê Thanh Nghị (Hòa Cường) sắp thi công hầm chui thuộc cụm nút giao cầu Hòa Xuân, chia 2 giai đoạn, giai đoạn 1 dự kiến từ tháng 11/2026. Phương án phân luồng, lộ trình gợi ý và tác động đến bất động sản phía Nam.",
 "keyword": "hầm chui Cách Mạng Tháng Tám",
 "keywords_extra": ["nút giao Cách Mạng Tháng Tám Lê Thanh Nghị", "phân luồng cầu Hòa Xuân"],
 "category": "Hạ tầng & quy hoạch",
 "tags": ["Hạ tầng Đà Nẵng", "Bất động sản Đà Nẵng", "Cầu Hòa Xuân", "Hòa Xuân", "Cẩm Lệ", "Hầm chui Cách Mạng Tháng Tám", "Phân luồng giao thông"],
 "content": content,
 "seo": {
  "seo_title": "Hầm chui Cách Mạng Tháng Tám: thi công 2 giai đoạn, lộ trình",
  "desc": "Hầm chui Cách Mạng Tháng Tám – Lê Thanh Nghị thi công 2 giai đoạn, giai đoạn 1 dự kiến từ 11/2026. Phương án phân luồng, lộ trình gợi ý, tác động BĐS Hòa Xuân.",
  "points": [
   "Hầm chui tại nút Cách Mạng Tháng Tám – Lê Thanh Nghị thuộc cụm nút giao cầu Hòa Xuân (khởi công 25/8/2026).",
   "Thi công hầm chia 2 giai đoạn; giai đoạn 1 dự kiến từ tháng 11/2026 (theo Danang 35K Feet).",
   "Xe container điều hướng QL14B – QL1A – Nam Kỳ Khởi Nghĩa; cấm đỗ Nguyễn Hữu Thọ (CMT8 – Lê Đại Hành).",
   "Vận hành thử phân luồng khoảng 1 tuần trước khi thi công chính thức."
  ],
  "faq": [
   ["Khi nào thi công hầm chui Cách Mạng Tháng Tám – Lê Thanh Nghị?", "Theo thông tin được chia sẻ ngày 9/10/2026, thi công hầm chia 2 giai đoạn, giai đoạn 1 dự kiến bắt đầu từ tháng 11/2026. Ngày cụ thể theo thông báo phân luồng của Sở Xây dựng Đà Nẵng."],
   ["Xe tải, container đi đường nào khi thi công nút giao?", "Theo phương án phân luồng, xe container, xe tải trọng lớn được điều hướng từ Quốc lộ 14B qua Quốc lộ 1A về đường Nam Kỳ Khởi Nghĩa."],
   ["Hầm chui Cách Mạng Tháng Tám thuộc dự án nào?", "Thuộc cụm nút giao Lê Thanh Nghị – Cách Mạng Tháng Tám – Thăng Long – đường dẫn cầu Hòa Xuân, khởi công ngày 25/8/2026, thực hiện 2026 – 2029."],
   ["Thi công hầm ảnh hưởng thế nào đến bất động sản Hòa Xuân?", "Trong thời gian thi công, đi lại qua nút chậm hơn; khi hoàn thành, kết nối trung tâm – Hòa Xuân thông suốt, là điểm cộng cho căn hộ, đất nền phía Nam."]
  ]
 },
 "sources": [
  "https://baoxaydung.vn/da-nang-phan-luong-giao-thong-ra-sao-de-thi-cong-nut-giao-hon-1500-ty-dong-192261007094213023.htm",
  "https://baodanang.vn/phan-luong-giao-thong-cum-nut-giao-le-thanh-nghi-cach-mang-thang-tam-thang-long-duong-dan-len-cau-hoa-xuan-3354433.html",
  "http://vov.vn/xa-hoi/da-nang-phan-luong-phuc-vu-thi-cong-nut-giao-cau-hoa-xuan-post1339122.vov",
  "https://www.sggp.org.vn/khoi-cong-cum-nut-giao-cau-hoa-xuan-go-diem-nghen-giao-thong-phia-nam-da-nang-post868701.html"
 ],
 "follow_sources": True,
 "image": {"name": "thi-cong-ham-chui-cach-mang-thang-tam-le-thanh-nghi", "alt": "Thi công hầm chui Cách Mạng Tháng Tám – Lê Thanh Nghị: 2 giai đoạn, phân luồng giao thông", "caption": "Đồ hoạ: hiephoangmt.com, tổng hợp thông tin đến ngày 9/10/2026."}
}
json.dump(d, open('ham-chui-cmt8.json','w'), ensure_ascii=False, indent=1)
print(len(d['seo']['seo_title']), len(d['seo']['desc']), len(re.sub('<[^>]+>',' ',content).split()))
