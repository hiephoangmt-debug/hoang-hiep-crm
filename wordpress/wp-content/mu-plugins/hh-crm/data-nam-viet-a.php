<?php
/**
 * Khu đô thị Nam Việt Á (Khu đô thị sinh thái Nam cầu Tuyên Sơn) – Ngũ Hành Sơn, Đà Nẵng.
 * Nguồn: danh sách hàng chào bán Hoàng Hiệp tổng hợp gửi 25/10/2026 (lô ống, biệt thự, lô góc; giá chào bán, có lô thương lượng),
 * thông tin tổng quan từ các trang thông tin dự án (diện tích khoảng 704.105 m², chủ đầu tư, loại sản phẩm).
 * Giá/m² do web tính từ giá chào bán ÷ diện tích – không phải giá giao dịch. Không đăng ảnh chụp trên mạng (không rõ nguồn).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$content = '<p><strong>Khu đô thị Nam Việt Á</strong> (tên dự án: Khu đô thị sinh thái Nam cầu Tuyên Sơn) là khu đất nền, biệt thự đã hoàn thiện hạ tầng ven sông, thuộc phường Ngũ Hành Sơn (Khuê Mỹ cũ), Đà Nẵng. Khu có quy mô khoảng <strong>70 ha</strong>, lô đất từ 90 – 350 m², sổ đỏ từng lô và đã hình thành khu dân cư đông đúc. Dưới đây là bảng hàng chào bán Hoàng Hiệp cập nhật tháng 10/2026.</p>
<h2>Thông tin tổng quan</h2>
<table>
<tbody>
<tr><th>Tên dự án</th><td>Khu đô thị sinh thái Nam cầu Tuyên Sơn (Nam Việt Á)</td></tr>
<tr><th>Chủ đầu tư</th><td>Công ty CP Đầu tư Xây dựng và Phát triển Hạ tầng Nam Việt Á</td></tr>
<tr><th>Vị trí</th><td>Phía Nam cầu Tiên Sơn, ven sông, phường Ngũ Hành Sơn (Khuê Mỹ cũ), Đà Nẵng</td></tr>
<tr><th>Quy mô</th><td>Khoảng 704.105 m² (theo các trang thông tin dự án)</td></tr>
<tr><th>Sản phẩm</th><td>Đất nền liền kề (lô ống), đất biệt thự, lô góc; diện tích khoảng 90 – 350 m²</td></tr>
<tr><th>Pháp lý</th><td>Sổ đỏ từng lô, đất ở lâu dài</td></tr>
<tr><th>Hiện trạng</th><td>Hạ tầng hoàn thiện, khu dân cư hiện hữu, giao dịch chuyển nhượng</td></tr>
</tbody>
</table>
<h2>Bảng giá lô ống Nam Việt Á (chào bán 10/2026)</h2>
<table>
<thead><tr><th>Tuyến đường</th><th>Diện tích</th><th>Giá chào bán</th><th>Khoảng giá/m²</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>Trương Công Hy</td><td>105 m²</td><td>8,5 tỷ</td><td>~81 triệu</td><td>Có thương lượng</td></tr>
<tr><td>Mỹ Đa Tây 4</td><td>102,5 m²</td><td>9,x tỷ</td><td>~88 – 97 triệu</td><td>View công viên</td></tr>
<tr><td>Nước Mặn 5</td><td>95 m²</td><td>7,x tỷ</td><td>~74 – 83 triệu</td><td>Đối diện dãy biệt thự</td></tr>
<tr><td>Nguyễn Thế Kỷ</td><td>95 m²</td><td>7,5 tỷ</td><td>~79 triệu</td><td></td></tr>
<tr><td>Trịnh Lỗi</td><td>100 m²</td><td>8 tỷ</td><td>~80 triệu</td><td>Gần đường điện</td></tr>
<tr><td>Tuy Lý Vương</td><td>95 m²</td><td>7,35 tỷ</td><td>~77 triệu</td><td>Sát góc</td></tr>
<tr><td>Dương Tử Giang</td><td>90 m²</td><td>Thỏa thuận</td><td>–</td><td></td></tr>
<tr><td>Đoàn Khuê (giai đoạn 2)</td><td>100 m²</td><td>9,x tỷ</td><td>~90 – 99 triệu</td><td></td></tr>
<tr><td>Đoàn Khuê (giai đoạn 1)</td><td>110 m²</td><td>11,x tỷ</td><td>~100 – 108 triệu</td><td></td></tr>
<tr><td>Lê Hy Cát</td><td>100 m²</td><td>10,2 tỷ</td><td>~102 triệu</td><td></td></tr>
<tr><td>Nghiêm Xuân Yêm</td><td>95 m²</td><td>9,x tỷ</td><td>~95 – 104 triệu</td><td></td></tr>
<tr><td>Trần Hữu Độ</td><td>100 m²</td><td>12 tỷ</td><td>~120 triệu</td><td></td></tr>
<tr><td>Phạm Tuấn Tài</td><td>129 m²</td><td>1x tỷ</td><td>Liên hệ</td><td></td></tr>
</tbody>
</table>
<p>Lô ống 90 – 110 m² đang chào khoảng <strong>7,35 – 12 tỷ</strong>, tương đương khoảng <strong>77 – 120 triệu/m²</strong>; các tuyến Đoàn Khuê, Lê Hy Cát, Nghiêm Xuân Yêm, Trần Hữu Độ cao hơn mặt bằng chung.</p>
<h2>Bảng giá đất biệt thự</h2>
<table>
<thead><tr><th>Tuyến đường</th><th>Diện tích</th><th>Giá chào bán</th><th>Khoảng giá/m²</th></tr></thead>
<tbody>
<tr><td>Nước Mặn 1</td><td>182,5 m²</td><td>16 tỷ</td><td>~88 triệu</td></tr>
<tr><td>Nghiêm Xuân Yêm</td><td>285 m²</td><td>24 tỷ</td><td>~84 triệu</td></tr>
<tr><td>Bùi Tá Hán</td><td>250 m²</td><td>25,5 tỷ</td><td>~102 triệu</td></tr>
<tr><td>Anh Thơ</td><td>300 m²</td><td>29 tỷ</td><td>~97 triệu</td></tr>
<tr><td>Trần Trọng Khiêm</td><td>334 m²</td><td>32 tỷ</td><td>~96 triệu</td></tr>
<tr><td>Chương Dương (ven sông)</td><td>300 m²</td><td>58 tỷ</td><td>~193 triệu</td></tr>
<tr><td>Chương Dương (ven sông)</td><td>600 m²</td><td>100 tỷ</td><td>~167 triệu</td></tr>
</tbody>
</table>
<p>Đất biệt thự trong khu khoảng <strong>84 – 102 triệu/m²</strong>; riêng mặt tiền <strong>Chương Dương</strong> ven sông cao gấp gần 2 lần, khoảng 167 – 193 triệu/m².</p>
<h2>Bảng giá lô góc</h2>
<table>
<thead><tr><th>Vị trí góc</th><th>Diện tích</th><th>Hướng</th><th>Giá chào bán</th><th>Khoảng giá/m²</th></tr></thead>
<tbody>
<tr><td>Góc Đoàn Khuê – Phạm Tuấn Tài (đường 11,5 m)</td><td>177 m²</td><td>Đông Bắc, Tây Nam</td><td>25 tỷ (thương lượng)</td><td>~141 triệu</td></tr>
<tr><td>Góc Dương Tử Giang – Đa Phước 8</td><td>249 m²</td><td>–</td><td>23 tỷ</td><td>~92 triệu</td></tr>
<tr><td>Góc Lê Văn Thủ – Mỹ Đa Tây 6</td><td>170 m²</td><td>Đông Nam, Đông Bắc</td><td>22,x tỷ</td><td>~129 – 135 triệu</td></tr>
<tr><td>Góc Mạc Thiên Tích – Trương Công Hy</td><td>257 m²</td><td>Đông Nam, Tây Nam</td><td>Thỏa thuận</td><td>–</td></tr>
<tr><td>Góc K20 – Nước Mặn 2</td><td>241 m²</td><td>Tây Bắc, Tây Nam</td><td>27,5 tỷ</td><td>~114 triệu</td></tr>
</tbody>
</table>
<p>Giá trên là giá chào bán tham khảo do Hoàng Hiệp tổng hợp; giá/m² tính bằng giá chào ÷ diện tích, làm tròn – giá chốt tùy thương lượng từng lô. Mặt bằng tin rao trên các sàn cùng thời điểm khoảng 93 – 138 triệu/m².</p>
<h2>Vì sao Nam Việt Á giữ giá tốt?</h2>
<ul>
<li><strong>Hạ tầng xong, sổ đỏ từng lô</strong>: mua là xây được, không chờ dự án.</li>
<li><strong>Ven sông, gần cầu Tiên Sơn</strong>: đi trung tâm Hải Châu, sân bay và biển Mỹ Khê đều nhanh; trục Chương Dương ven sông là mặt tiền đẹp nhất khu.</li>
<li><strong>Khu dân cư hiện hữu</strong>: nhiều biệt thự, nhà ở đã xây, tiện ích quanh khu đầy đủ – phù hợp ở thật, xây nhà cho thuê, căn hộ dịch vụ.</li>
</ul>
<h2>Lưu ý khi mua đất Nam Việt Á</h2>
<ul>
<li>Kiểm tra sổ, chỉ giới xây dựng, mật độ và tầng cao cho phép từng lô (lô biệt thự khác lô liền kề).</li>
<li>Lô gần đường điện, sát trạm hoặc đối diện tường rào thường thấp giá hơn – cân nhắc theo mục đích.</li>
<li>Giá chào bán chênh nhau nhiều theo tuyến đường, hướng và chiều rộng mặt đường – nên so ít nhất 3 lô cùng tuyến.</li>
</ul>
<p>Cần xem lô cụ thể, sổ và vị trí trên bản đồ, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) hoặc gửi yêu cầu tại <a href="/lien-he/">trang liên hệ</a>.</p>';

		$projects[] = array(
			'slug'    => 'khu-do-thi-nam-viet-a',
			'title'   => 'Khu đô thị Nam Việt Á Đà Nẵng',
			'type'    => array( 'dat-nen', 'biet-thu' ),
			'area'    => 'ngu-hanh-son',
			'excerpt' => 'Khu đô thị Nam Việt Á (sinh thái Nam cầu Tuyên Sơn), Ngũ Hành Sơn: khoảng 70 ha ven sông, sổ đỏ từng lô. Bảng giá 10/2026: lô ống 7,35 – 12 tỷ, biệt thự 16 – 100 tỷ, lô góc 22 – 27,5 tỷ.',
			'meta'    => array(
				'hh_p_status'        => 'da-ban-giao',
				'hh_p_developer'     => 'Công ty CP Đầu tư Xây dựng và Phát triển Hạ tầng Nam Việt Á',
				'hh_p_type'          => 'Đất nền liền kề, đất biệt thự',
				'hh_p_address'       => 'Khu đô thị sinh thái Nam cầu Tuyên Sơn, phường Ngũ Hành Sơn (Khuê Mỹ cũ), Đà Nẵng',
				'hh_p_map_address'   => 'Khu đô thị Nam Việt Á, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'         => 'Khoảng 704.105 m² (70 ha)',
				'hh_p_unit_area'     => 'Lô liền kề 90 – 129 m² · đất biệt thự 182 – 600 m² · lô góc 170 – 257 m²',
				'hh_p_price_m2'      => 'Lô ống khoảng 77 – 120 triệu/m²; biệt thự 84 – 102 triệu/m² (mặt tiền Chương Dương 167 – 193 triệu/m²); lô góc 92 – 141 triệu/m² (chào bán 10/2026)',
				'hh_p_ownership'     => 'Đất ở lâu dài, sổ đỏ từng lô',
				'hh_p_legal'         => 'Sổ đỏ từng lô, đất ở lâu dài',
				'hh_p_handover'      => 'Hạ tầng hoàn thiện, giao dịch chuyển nhượng',
				'hh_p_dat-nen_desc'  => 'Lô ống (liền kề) 90 – 129 m² và lô góc 170 – 257 m² trong khu dân cư hiện hữu, hạ tầng hoàn thiện. Giá chào bán do Hoàng Hiệp tổng hợp 10/2026, có lô thương lượng.',
				'hh_p_dat-nen_table' => "Lô ống Trương Công Hy | 105 m² | Trương Công Hy | 8,5 tỷ (thương lượng)\nLô ống Mỹ Đa Tây 4, view công viên | 102,5 m² | Mỹ Đa Tây 4 | 9,x tỷ\nLô ống Nước Mặn 5, đối diện biệt thự | 95 m² | Nước Mặn 5 | 7,x tỷ\nLô ống Nguyễn Thế Kỷ | 95 m² | Nguyễn Thế Kỷ | 7,5 tỷ\nLô ống Trịnh Lỗi | 100 m² | Trịnh Lỗi | 8 tỷ\nLô ống Tuy Lý Vương, sát góc | 95 m² | Tuy Lý Vương | 7,35 tỷ\nLô ống Đoàn Khuê GĐ2 | 100 m² | Đoàn Khuê | 9,x tỷ\nLô ống Đoàn Khuê GĐ1 | 110 m² | Đoàn Khuê | 11,x tỷ\nLô ống Lê Hy Cát | 100 m² | Lê Hy Cát | 10,2 tỷ\nLô ống Nghiêm Xuân Yêm | 95 m² | Nghiêm Xuân Yêm | 9,x tỷ\nLô ống Trần Hữu Độ | 100 m² | Trần Hữu Độ | 12 tỷ\nGóc Đoàn Khuê – Phạm Tuấn Tài | 177 m² | Đường 11,5 m | 25 tỷ (thương lượng)\nGóc Dương Tử Giang – Đa Phước 8 | 249 m² | Dương Tử Giang | 23 tỷ\nGóc Lê Văn Thủ – Mỹ Đa Tây 6 | 170 m² | Lê Văn Thủ | 22,x tỷ\nGóc K20 – Nước Mặn 2 | 241 m² | K20 | 27,5 tỷ",
				'hh_p_villa_desc'    => 'Đất biệt thự 182 – 600 m², xây biệt thự theo quy hoạch; mặt tiền Chương Dương ven sông là vị trí đắt nhất khu.',
				'hh_p_villa_table'   => "Nước Mặn 1 | 182,5 m² | Đất biệt thự | 16 tỷ\nNghiêm Xuân Yêm | 285 m² | Đất biệt thự | 24 tỷ\nBùi Tá Hán | 250 m² | Đất biệt thự | 25,5 tỷ\nAnh Thơ | 300 m² | Đất biệt thự | 29 tỷ\nTrần Trọng Khiêm | 334 m² | Đất biệt thự | 32 tỷ\nChương Dương ven sông | 300 m² | Đất biệt thự | 58 tỷ\nChương Dương ven sông | 600 m² | Đất biệt thự | 100 tỷ",
				'hh_p_highlights'    => "Khu đô thị khoảng 70 ha ven sông, hạ tầng hoàn thiện, sổ đỏ từng lô\nLô ống 90 – 110 m² chào khoảng 7,35 – 12 tỷ (77 – 120 triệu/m²)\nĐất biệt thự 84 – 102 triệu/m²; mặt tiền Chương Dương ven sông 167 – 193 triệu/m²\nLô góc 170 – 257 m² khoảng 22 – 27,5 tỷ\nKhu dân cư hiện hữu, gần cầu Tiên Sơn, đi trung tâm và biển nhanh",
				'hh_p_location_desc' => 'Phía Nam cầu Tiên Sơn, ven sông, phường Ngũ Hành Sơn (Khuê Mỹ cũ); trục Chương Dương chạy dọc bờ sông là mặt tiền đẹp nhất khu.',
				'hh_p_connections'   => "Gần | Cầu Tiên Sơn, sông Hàn\nVài phút | Trung tâm Hải Châu, sân bay Đà Nẵng\nVài phút | Biển Mỹ Khê – Sơn Thủy",
				'hh_p_image_links'   => 'plugin:img/nam-viet-a/nam-viet-a-gia-dat-theo-lo-10-2026.jpg | Biểu đồ giá chào bán mỗi m² đất Nam Việt Á theo lô ống, biệt thự, lô góc tháng 10/2026 | đại diện',
				'hh_p_faq'           => "Đất Nam Việt Á giá bao nhiêu? | Chào bán 10/2026: lô ống 90 – 110 m² khoảng 7,35 – 12 tỷ (77 – 120 triệu/m²); đất biệt thự 84 – 102 triệu/m², mặt tiền Chương Dương ven sông 167 – 193 triệu/m²; lô góc khoảng 22 – 27,5 tỷ.\nNam Việt Á ở đâu? | Khu đô thị sinh thái Nam cầu Tuyên Sơn, phường Ngũ Hành Sơn (Khuê Mỹ cũ), Đà Nẵng – phía Nam cầu Tiên Sơn, ven sông.\nĐất Nam Việt Á có sổ đỏ không? | Có, sổ đỏ từng lô, đất ở lâu dài; hạ tầng đã hoàn thiện.\nNam Việt Á rộng bao nhiêu? | Khoảng 704.105 m² (70 ha), chủ đầu tư Công ty CP Đầu tư Xây dựng và Phát triển Hạ tầng Nam Việt Á.\nTuyến đường nào đắt nhất Nam Việt Á? | Mặt tiền Chương Dương ven sông (khoảng 167 – 193 triệu/m²); trong khu, các tuyến Trần Hữu Độ, Lê Hy Cát, Đoàn Khuê, lô góc Đoàn Khuê – Phạm Tuấn Tài thuộc nhóm giá cao.",
			),
			'content' => $content,
			'sources' => array(
				'https://guland.vn/du-an/khu-do-thi-nam-viet-a-da-nang',
				'https://homedy.com/khu-do-thi-nam-cau-tuyen-son-nam-viet-a-pj8945509',
				'https://tracuuquyhoach.com/du-an/khu-do-thi-nam-viet-a-pj4913',
			),
		);
		return $projects;
	},
	21
);
