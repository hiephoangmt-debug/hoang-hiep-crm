<?php
/**
 * Bài viết kế hoạch nội dung – tuần 3 (cụm Casamia Balanca Hội An: bài toán dòng tiền đầu tư, so sánh với biệt thự nghỉ dưỡng Hội An – Đà Nẵng). Nạp qua filter hh_news_posts; nút Dự án → Nhập dữ liệu Đà Nẵng tạo bài, tự lên lịch theo tuần.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_casamia_dong_tien' );
function hh_posts_casamia_dong_tien( $posts ) {
	$posts[] = array(
		'slug'     => 'dau-tu-biet-thu-casamia-balanca-bai-toan-dong-tien',
		'title'    => 'Đầu tư biệt thự Casamia Balanca: bài toán dòng tiền 5–10 năm',
		'excerpt'  => 'Dòng tiền Casamia Balanca theo 3 kịch bản: trả đủ tự cho thuê, vay 50–70%, giao đơn vị vận hành. Bảng tính công suất 40/55/70% và điểm hòa vốn.',
		'keyword'  => 'dòng tiền Casamia Balanca',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 3,
		'category' => 'Kinh nghiệm mua bán',
		'content'  => <<<'HTML'
<p>Dòng tiền Casamia Balanca từ cho thuê nghỉ dưỡng, với giả định thận trọng, chỉ đạt khoảng 1,5 – 3%/năm trên tổng vốn khi mua bằng tiền mặt. Khi vay ngân hàng 50 – 70%, tiền thuê không đủ trả lãi sau thời gian ân hạn. Vì vậy biệt thự ở đây nên được xem là tài sản tích lũy dài hạn, không phải sản phẩm dòng tiền. Bài viết cập nhật tháng 10/2026, mọi con số đều ghi rõ nguồn hoặc đánh dấu "giả định".</p>

<h2>Dữ liệu đầu vào và các giả định</h2>
<p>Dự án mới bắt đầu bàn giao (kế hoạch khoảng 100 căn trong tháng 11 – 12/2026), nên <strong>chưa có doanh thu thực tế công khai</strong>. Hiệp dùng một căn mẫu để minh họa.</p>
<table>
<thead><tr><th>Thông số</th><th>Giá trị dùng trong bài</th><th>Nguồn / tính chất</th></tr></thead>
<tbody>
<tr><td>Giá căn mẫu</td><td>Khoảng 13,75 tỷ (lô 250 m² x 55 triệu/m²)</td><td>Tạp chí Công Thương, thời điểm 12/2024</td></tr>
<tr><td>Dải giá tham khảo</td><td>Từ khoảng 8,8 tỷ; phổ biến 10 – 20 tỷ/căn</td><td>Báo chí, trang phân phối</td></tr>
<tr><td>Nội thất, chi phí ban đầu</td><td>0,75 tỷ → tổng vốn khoảng 14,5 tỷ</td><td><strong>Giả định</strong></td></tr>
<tr><td>Giá thuê bình quân</td><td>3,5 triệu/đêm</td><td>Mức thấp của villa nhiều phòng tại Cẩm Thanh (khoảng 3,5 – 5,5 triệu/đêm, trang du lịch)</td></tr>
<tr><td>Công suất phòng</td><td>40% / 55% / 70%</td><td><strong>Giả định</strong></td></tr>
<tr><td>Chi phí vận hành, phí OTA, thuế</td><td>45% doanh thu gộp</td><td><strong>Giả định</strong></td></tr>
<tr><td>Chi phí cố định (bảo trì lớn, bảo hiểm, phí khu)</td><td>60 triệu/năm</td><td><strong>Giả định</strong></td></tr>
</tbody>
</table>
<p>Doanh thu gộp năm = 3,5 triệu x 365 đêm x công suất. Tương ứng khoảng 511 triệu (40%), 703 triệu (55%) và 894 triệu (70%).</p>

<h2>Kịch bản A: thanh toán đủ, tự cho thuê homestay – nghỉ dưỡng</h2>
<table>
<thead><tr><th>Công suất (giả định)</th><th>Doanh thu gộp/năm</th><th>Chi phí vận hành 45%</th><th>Chi phí cố định</th><th>Dòng tiền ròng/năm</th><th>Lợi suất trên 14,5 tỷ</th></tr></thead>
<tbody>
<tr><td>40%</td><td>511 triệu</td><td>230 triệu</td><td>60 triệu</td><td>Khoảng 221 triệu</td><td>Khoảng 1,5%</td></tr>
<tr><td>55%</td><td>703 triệu</td><td>316 triệu</td><td>60 triệu</td><td>Khoảng 327 triệu</td><td>Khoảng 2,3%</td></tr>
<tr><td>70%</td><td>894 triệu</td><td>402 triệu</td><td>60 triệu</td><td>Khoảng 432 triệu</td><td>Khoảng 3,0%</td></tr>
</tbody>
</table>
<p>Cộng dồn 5 năm ở công suất 55%, dòng tiền ròng khoảng 1,6 tỷ; 10 năm khoảng 3,3 tỷ, tức chưa tới một phần tư vốn bỏ ra. Theo đơn vị phân phối, khách không vay được chiết khấu khoảng 9%; khi đó giá căn mẫu còn khoảng 12,5 tỷ và lợi suất ở mức 55% nhích lên khoảng 2,5%.</p>

<h2>Kịch bản B: vay ngân hàng 50 – 70%</h2>
<p>Các đơn vị phân phối giới thiệu hỗ trợ vay tối đa 70% giá trị hợp đồng, ân hạn gốc và lãi suất 0% đến 24 tháng. Đây là thông tin phân phối, chưa phải văn bản của chủ đầu tư. Sau ân hạn, Hiệp <strong>giả định lãi suất 10%/năm</strong> (thả nổi) và chỉ tính tiền lãi, chưa tính trả gốc.</p>
<table>
<thead><tr><th>Mức vay</th><th>Lãi vay/năm (giả định 10%)</th><th>Dòng tiền ròng 40%</th><th>Dòng tiền ròng 55%</th><th>Dòng tiền ròng 70%</th></tr></thead>
<tbody>
<tr><td>50% (6,875 tỷ)</td><td>Khoảng 688 triệu</td><td>Âm khoảng 467 triệu</td><td>Âm khoảng 361 triệu</td><td>Âm khoảng 256 triệu</td></tr>
<tr><td>70% (9,625 tỷ)</td><td>Khoảng 963 triệu</td><td>Âm khoảng 742 triệu</td><td>Âm khoảng 636 triệu</td><td>Âm khoảng 531 triệu</td></tr>
</tbody>
</table>
<p>Trong 24 tháng ân hạn, vốn tự có khi vay 70% chỉ khoảng 4,9 tỷ nên lợi suất trên vốn tự có đạt khoảng 4,5 – 8,9%. Nhưng ân hạn có thể trôi qua một phần trước khi căn đi vào khai thác.</p>
<p>Với kịch bản vay 70%, sau 10 năm (2 năm ân hạn, 8 năm trả lãi) ở công suất 55%, tổng dòng tiền âm khoảng 4,4 tỷ.</p>

<h2>Kịch bản C: giao đơn vị vận hành, chia doanh thu</h2>
<p>Một số trang phân phối giới thiệu gói chia cho chủ khoảng 45% doanh thu thuần, kèm mức tối thiểu khoảng 30 triệu/tháng. Hiệp chưa thấy văn bản chính thức của chủ đầu tư về gói này. Bảng dưới <strong>giả định</strong> doanh thu thuần bằng 85% doanh thu gộp, chủ nhà tự chịu khoảng 30 triệu/năm chi phí cố định.</p>
<table>
<thead><tr><th>Công suất (giả định)</th><th>Phần chia 45%</th><th>Ròng nếu không có mức sàn</th><th>Lợi suất</th><th>Ròng nếu mức sàn 360 triệu/năm được thực hiện</th></tr></thead>
<tbody>
<tr><td>40%</td><td>Khoảng 195 triệu</td><td>Khoảng 165 triệu</td><td>Khoảng 1,1%</td><td>Khoảng 330 triệu (2,3%)</td></tr>
<tr><td>55%</td><td>Khoảng 269 triệu</td><td>Khoảng 239 triệu</td><td>Khoảng 1,6%</td><td>Khoảng 330 triệu (2,3%)</td></tr>
<tr><td>70%</td><td>Khoảng 342 triệu</td><td>Khoảng 312 triệu</td><td>Khoảng 2,2%</td><td>Khoảng 330 triệu (2,3%)</td></tr>
</tbody>
</table>
<p>Ở cả ba mức công suất, mức sàn đều cao hơn phần chia thực. Nghĩa là bên vận hành phải bù tiền, nên năng lực tài chính và điều khoản ràng buộc của họ quan trọng hơn con số cam kết.</p>

<h2>Điểm hòa vốn của dòng tiền Casamia Balanca</h2>
<ul>
<li><strong>Hòa vốn chi phí vận hành (kịch bản A):</strong> chỉ cần công suất khoảng 9% là đủ bù 60 triệu chi phí cố định. Rủi ro lỗ vận hành thấp nếu không vay.</li>
<li><strong>Hòa vốn tiền lãi (kịch bản B):</strong> ở công suất 70%, giá thuê bình quân cần khoảng 5,3 triệu/đêm (vay 50%) hoặc 7,3 triệu/đêm (vay 70%). Mức này tương đương villa 4 phòng ngủ có hồ bơi ở Hội An (khoảng 6 – 8 triệu/đêm theo trang villa), cao hơn đáng kể mặt bằng chung 1,5 – 4 triệu/đêm ở Cẩm Thanh.</li>
<li><strong>Thu hồi vốn chỉ bằng tiền thuê:</strong> khoảng 34 – 66 năm theo kịch bản A. Phần còn lại phụ thuộc giá bán lại, Hiệp không dự báo.</li>
</ul>

<h2>Rủi ro cần tính</h2>
<h3>Mùa thấp điểm</h3>
<p>Hội An có mùa mưa cuối năm, công suất giảm mạnh. Hãy tính công suất bình quân cả năm.</p>
<h3>Ngập lụt khu vực Cẩm Thanh</h3>
<p>Dự án nằm ven sông, giữa rừng dừa Bảy Mẫu. Hiệp chưa có số liệu ngập riêng cho dự án; trước khi chọn căn, hãy hỏi cao độ nền, hệ thống thoát nước và lịch sử nước lên của khu vực.</p>
<h3>Pháp lý sổ hồng</h3>
<p>Chủ đầu tư đặt mục tiêu hoàn thiện thủ tục cấp giấy chứng nhận từng lô trong năm 2026. Xem chi tiết tại bài <a href="/phap-ly-so-hong-casamia-balanca/">pháp lý sổ hồng Casamia Balanca</a>.</p>
<h3>Thanh khoản</h3>
<p>Biệt thự 10 – 20 tỷ có tệp khách mua lại hẹp; biệt thự Vinpearl Nam Hội An hiện được rao thấp hơn giá bán gốc là ví dụ cần lưu ý.</p>

<h2>Hiệp tư vấn chọn kịch bản nào?</h2>
<p>Nếu có sẵn vốn và muốn vừa nghỉ dưỡng vừa khai thác, kịch bản A (kèm chiết khấu thanh toán) an toàn nhất. Nếu vay, chỉ nên vay ở mức bạn trả được lãi bằng thu nhập chính, không trông vào tiền thuê. Kịch bản C hợp với chủ ở xa, nhưng phải đọc kỹ hợp đồng vận hành.</p>
<p>Đọc thêm: <a href="/du-an/casamia-balanca-hoi-an/">trang dự án Casamia Balanca</a>, <a href="/gia-biet-thu-casamia-balanca-2026/">giá biệt thự Casamia Balanca 2026</a>, <a href="/chinh-sach-ban-hang-casamia-balanca/">chính sách bán hàng</a>, <a href="/cho-thue-biet-thu-casamia-balanca-dong-tien/">cách ước tính dòng tiền cho thuê</a> và danh mục <a href="/loai-du-an/biet-thu/">dự án biệt thự</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) hoặc qua trang <a href="/lien-he/">liên hệ</a> để nhận file tính dòng tiền theo đúng căn, giá và mức vay của bạn.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Dòng tiền Casamia Balanca: 3 kịch bản đầu tư 5–10 năm',
			'desc'      => 'Dòng tiền Casamia Balanca: trả đủ, vay 50–70%, chia doanh thu; bảng công suất 40/55/70%, điểm hòa vốn. Gọi Hoàng Hiệp 0904 567 009 nhận file tính.',
			'points'    => array(
				'Mua bằng tiền mặt, tự cho thuê: lợi suất ròng giả định khoảng 1,5 – 3%/năm trên tổng vốn.',
				'Vay 50 – 70% với lãi giả định 10%/năm: tiền thuê không đủ trả lãi sau ân hạn.',
				'Gói chia doanh thu do phân phối giới thiệu chưa có văn bản chủ đầu tư; mức sàn phụ thuộc năng lực bên vận hành.',
			),
			'faq'       => array(
				array( 'Đầu tư biệt thự Casamia Balanca cho thuê lời bao nhiêu?', 'Chưa có doanh thu thực tế công khai. Với giá thuê 3,5 triệu/đêm và giả định chi phí 45%, lợi suất ròng khoảng 1,5 – 3%/năm trên tổng vốn khi không vay.' ),
				array( 'Vay 70% mua Casamia Balanca có trả được lãi bằng tiền thuê không?', 'Với lãi suất giả định 10%/năm, giá thuê cần khoảng 7,3 triệu/đêm ở công suất 70% mới đủ trả lãi – cao hơn mặt bằng villa Cẩm Thanh.' ),
				array( 'Casamia Balanca có ân hạn lãi vay không?', 'Theo đơn vị phân phối, khách vay được ân hạn gốc, lãi suất 0% đến 24 tháng; cần xác nhận bằng văn bản theo từng đợt.' ),
				array( 'Có nên chọn gói chia doanh thu?', 'Phù hợp chủ ở xa, nhưng cần kiểm tra bên vận hành, cách tính doanh thu thuần, mức sàn và điều kiện chấm dứt hợp đồng.' ),
			),
		),
		'sources'  => array( 'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg-trien-vong-tai-dinh-gia-tu-viec-mo-ban-du-an-casamia-balanca-141395.htm', 'https://estuaryresidental.com/du-an/khu-do-thi-casamia-balanca-hoi-an-chinh-sach-bang-hang-va-gia-ban/', 'https://vinwondersnamhoian.com/Du-lich-Hoi-An/Villa-Cam-Thanh-Hoi-An', 'https://duanbdsdanang.com/du-an/casamia-balanca-hoi-an/' ),
	);

	$posts[] = array(
		'slug'     => 'casamia-balanca-so-sanh-biet-thu-hoi-an',
		'title'    => 'So sánh Casamia Balanca với biệt thự nghỉ dưỡng khác ở Hội An – Đà Nẵng',
		'excerpt'  => 'Casamia Balanca có nên mua? So sánh vị trí, sở hữu, giá, hình thức khai thác với Hoiana Beach Villas, Vinpearl Nam Hội An, The Ocean Villas, Casamia Hội An.',
		'keyword'  => 'Casamia Balanca có nên mua',
		'project'  => 'casamia-balanca-hoi-an',
		'week'     => 3,
		'category' => 'Dự án',
		'content'  => <<<'HTML'
<p>Casamia Balanca có nên mua? Câu trả lời phụ thuộc vào mục đích. Đây là lựa chọn hợp lý nếu bạn muốn biệt thự sinh thái ven sông, đã có sổ hồng từng lô, gần phố cổ, với mức giá tham khảo khoảng 10 – 20 tỷ/căn. Nếu ưu tiên mặt biển, thương hiệu resort hoặc nhà đã vận hành, các dự án như Hoiana Beach Villas, Vinpearl Nam Hội An hay The Ocean Villas sẽ phù hợp hơn. Thông tin cập nhật tháng 10/2026.</p>

<h2>Bảng so sánh biệt thự nghỉ dưỡng Hội An – Đà Nẵng</h2>
<table>
<thead><tr><th>Dự án</th><th>Vị trí</th><th>Sở hữu</th><th>Giá tham khảo</th><th>Hình thức</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Casamia Balanca</td><td>Cẩm Thanh, Hội An – ven sông, rừng dừa Bảy Mẫu</td><td>Lâu dài (người Việt Nam)</td><td>Khoảng 10 – 20 tỷ; từ khoảng 8,8 tỷ theo phân phối</td><td>Tự ở, tự cho thuê; gói chia doanh thu do phân phối giới thiệu</td><td>Đang mở bán; kế hoạch bàn giao khoảng 100 căn 11 – 12/2026</td></tr>
<tr><td>Casamia Hội An</td><td>Võng Nhi, Cẩm Thanh, Hội An</td><td>Cần kiểm tra theo từng căn</td><td>Liên hệ (giao dịch chuyển nhượng)</td><td>Biệt thự sinh thái "2 trong 1": ở và nghỉ dưỡng</td><td>Đã bàn giao (quý 4/2020)</td></tr>
<tr><td>Casamia Calm</td><td>Cẩm Hà, Hội An – bên sông Cổ Cò</td><td>Lâu dài (sổ hồng)</td><td>Liên hệ</td><td>Biệt thự sinh thái tự ở, nghỉ dưỡng</td><td>Đã bàn giao</td></tr>
<tr><td>Hoiana Beach Villas</td><td>Duy Hải, Duy Xuyên – khoảng 700 m bờ biển</td><td>Theo chính sách chủ đầu tư, cần kiểm tra</td><td>Liên hệ</td><td>Biệt thự biển 3 – 9 phòng ngủ trong quần thể resort</td><td>Đang mở bán; bàn giao dự kiến quý 1/2028</td></tr>
<tr><td>Hoiana Shores Golf Villas</td><td>Quần thể Hoiana, Duy Xuyên</td><td>Lâu dài, sổ đỏ từng căn</td><td>Liên hệ</td><td>Biệt thự sân golf, đất 710 – 1.500 m²</td><td>Đang mở bán</td></tr>
<tr><td>Biệt thự Vinpearl Nam Hội An</td><td>Bình Minh – Bình Dương, Thăng Bình (cũ), ven biển</td><td>Lâu dài theo chính sách mở bán, cần kiểm tra sổ từng căn</td><td>Chuyển nhượng khoảng 9 – 16 tỷ (tin rao); giá gốc từ khoảng 16,8 tỷ</td><td>Cam kết chia lợi nhuận tối thiểu 10%/năm trong 10 năm (chính sách mở bán)</td><td>Đã bàn giao, đang vận hành</td></tr>
<tr><td>The Ocean Villas</td><td>Trường Sa, Ngũ Hành Sơn, Đà Nẵng – sát biển</td><td>Cần kiểm tra theo từng căn</td><td>Chuyển nhượng khoảng 28,5 – 70 tỷ (tin rao)</td><td>Biệt thự đơn lập 2 – 8 phòng ngủ, hồ bơi riêng, trong khu resort</td><td>Đã bàn giao, chuyển nhượng</td></tr>
</tbody>
</table>
<p>Giá trong bảng là mức tham khảo tổng hợp từ báo chí, trang phân phối và tin rao chuyển nhượng; giá thật phụ thuộc vị trí, diện tích và đợt bán.</p>

<h2>Điểm mạnh và điểm yếu của Casamia Balanca</h2>
<h3>Điểm mạnh</h3>
<ul>
<li>Quy mô 31,1 ha với 363 sản phẩm thấp tầng (173 biệt thự đơn lập, 116 song lập, 74 shophouse), có dòng sông trong nội khu và bến du thuyền.</li>
<li>Nằm trong Khu dự trữ sinh quyển thế giới Cù Lao Chàm – Hội An, tiếp giáp trục Võ Chí Công nối Đà Nẵng – Hội An – Chu Lai.</li>
<li>Đã cấp sổ hồng các lô tháng 8/2026 (đất ở tại đô thị); chủ đầu tư Đạt Phương đã bàn giao Casamia Hội An và Casamia Calm.</li>
<li>Mức giá vào cửa thấp hơn nhiều so với biệt thự mặt biển Ngũ Hành Sơn.</li>
</ul>
<h3>Điểm cần cân nhắc</h3>
<ul>
<li>Không có mặt biển trực tiếp như Hoiana Beach Villas hay The Ocean Villas.</li>
<li>Giấy chứng nhận từng lô đang được hoàn thiện theo kế hoạch 2026, chưa phải sổ có sẵn.</li>
<li>Chưa có thương hiệu khách sạn quốc tế vận hành, chưa có doanh thu cho thuê thực tế công khai.</li>
</ul>

<h2>So sánh theo từng nhóm đối thủ</h2>
<h3>Với Casamia Hội An và Casamia Calm</h3>
<p>Cùng chủ đầu tư, cùng phong cách sinh thái ven sông. <a href="/du-an/casamia-hoi-an/">Casamia Hội An</a> (15,6 ha, 216 căn) và <a href="/du-an/casamia-calm-hoi-an/">Casamia Calm</a> (6,4 ha, 112 biệt thự) đã bàn giao, có thể xem nhà thật và cộng đồng cư dân. Casamia Balanca quy mô lớn hơn, có shophouse và khách sạn, nhưng còn đang hoàn thiện.</p>
<h3>Với biệt thự biển trong quần thể resort</h3>
<p><a href="/du-an/hoiana-beach-villas/">Hoiana Beach Villas</a> có mặt biển, hồ bơi riêng từng căn và hệ tiện ích golf, spa; đổi lại bàn giao dự kiến tới quý 1/2028. <a href="/du-an/vinpearl-nam-hoi-an-villa/">Biệt thự Vinpearl Nam Hội An</a> đã vận hành từ 2018 và có giá chuyển nhượng khoảng 9 – 16 tỷ, ngang vùng giá Casamia Balanca. Tuy vậy, mức giá này thấp hơn giá gốc, cho thấy rủi ro thanh khoản của biệt thự nghỉ dưỡng.</p>
<h3>Với biệt thự biển Đà Nẵng</h3>
<p><a href="/du-an/the-ocean-villas-da-nang/">The Ocean Villas</a> ở Ngũ Hành Sơn nằm sát biển, sát trung tâm, giá chuyển nhượng khoảng 28,5 – 70 tỷ. Với cùng ngân sách, Casamia Balanca cho diện tích, không gian xanh lớn hơn; Đà Nẵng cho vị trí và tính thanh khoản tốt hơn.</p>

<h2>Casamia Balanca có nên mua? Kết luận theo nhu cầu</h2>
<table>
<thead><tr><th>Nhu cầu</th><th>Gợi ý</th></tr></thead>
<tbody>
<tr><td>Nghỉ dưỡng gia đình, thích không gian sông nước, gần phố cổ</td><td>Casamia Balanca, Casamia Calm</td></tr>
<tr><td>Muốn nhà đã hoàn thiện, xem thực tế trước khi mua</td><td>Casamia Hội An, Casamia Calm, Vinpearl Nam Hội An (chuyển nhượng)</td></tr>
<tr><td>Ưu tiên mặt biển, tiện ích resort</td><td>Hoiana Beach Villas, The Ocean Villas</td></tr>
<tr><td>Ưu tiên dòng tiền cho thuê ổn định</td><td>Cân nhắc kỹ mọi lựa chọn; xem bài tính dòng tiền bên dưới</td></tr>
</tbody>
</table>
<p>Nếu mua để đầu tư, hãy đọc bài <a href="/dau-tu-biet-thu-casamia-balanca-bai-toan-dong-tien/">bài toán dòng tiền Casamia Balanca 5 – 10 năm</a> trước khi quyết định. Danh sách đầy đủ có tại mục <a href="/loai-du-an/biet-thu/">dự án biệt thự</a> và trang <a href="/du-an/casamia-balanca-hoi-an/">dự án Casamia Balanca</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) hoặc qua trang <a href="/lien-he/">liên hệ</a> để nhận bảng so sánh căn cụ thể giữa Casamia Balanca và các dự án biệt thự Hội An – Đà Nẵng đang có hàng.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Casamia Balanca có nên mua? So sánh biệt thự Hội An',
			'desc'      => 'Casamia Balanca có nên mua? So sánh vị trí, sở hữu, giá với Hoiana Beach Villas, Vinpearl Nam Hội An, The Ocean Villas. Gọi Hoàng Hiệp 0904 567 009.',
			'points'    => array(
				'Casamia Balanca: biệt thự sinh thái ven sông, đã có sổ hồng từng lô, giá tham khảo khoảng 10 – 20 tỷ.',
				'Hoiana Beach Villas có mặt biển nhưng bàn giao dự kiến quý 1/2028; Vinpearl Nam Hội An chuyển nhượng khoảng 9 – 16 tỷ.',
				'The Ocean Villas Đà Nẵng sát biển, giá chuyển nhượng khoảng 28,5 – 70 tỷ.',
			),
			'faq'       => array(
				array( 'Casamia Balanca có nên mua không?', 'Nên cân nhắc nếu bạn cần biệt thự sinh thái ven sông, đã có sổ hồng từng lô, gần phố cổ Hội An và nắm giữ dài hạn; nếu cần mặt biển hoặc nhà đã vận hành, hãy so sánh thêm Hoiana, Vinpearl Nam Hội An.' ),
				array( 'Casamia Balanca khác Casamia Hội An thế nào?', 'Cùng chủ đầu tư Đạt Phương; Casamia Hội An 15,6 ha đã bàn giao từ 2020, còn Casamia Balanca 31,1 ha đang mở bán, có thêm shophouse và khách sạn.' ),
				array( 'Biệt thự nào gần Hội An có mặt biển?', 'Hoiana Beach Villas (Duy Xuyên, khoảng 700 m bờ biển) và biệt thự Vinpearl Nam Hội An (Thăng Bình cũ).' ),
				array( 'Giá Casamia Balanca so với biệt thự biển Đà Nẵng ra sao?', 'Casamia Balanca khoảng 10 – 20 tỷ, trong khi The Ocean Villas chuyển nhượng khoảng 28,5 – 70 tỷ (tham khảo).' ),
			),
		),
		'sources'  => array( 'https://casamiabalanca.com/', 'https://www.hoiana.com/hoiana-beach-villas', 'https://namhoianvillas.com/chinh-sach-dau-tu-vinpearl-nam-hoi-an/', 'https://alonhadat.com.vn/du-an-khu-biet-thu-the-ocean-villas-pj938' ),
	);

	return $posts;
}
