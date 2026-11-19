<?php
/**
 * The Sunrise Bay – Khu đô thị quốc tế Đa Phước (trang dự án mới 19/11/2026, anh Hiệp yêu cầu).
 * Nguồn: Quyết định 3605/QĐ-UBND ngày 12/8/2026 (Cổng TTĐT TP Đà Nẵng), báo chí về lễ tái khởi động 17/11/2026,
 * phối cảnh phân kỳ công bố cùng tin tái khởi động; sơ đồ phân khu năm 2017 trong tài liệu anh Hiệp lưu (logo The Sunrise Bay).
 * Chưa mở bán – không ghi giá; không đăng bảng hàng/chính sách 2017; không ghi tên cá nhân.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im = static fn( $path, $alt, $where, $title = '' ) => "plugin:img/$path.jpg | $alt | $where" . ( $title ? " | $title" : '' );

		$projects[] = array(
			'slug'    => 'the-sunrise-bay-da-phuoc',
			'title'   => 'The Sunrise Bay – Khu đô thị quốc tế Đa Phước',
			'type'    => 'biet-thu',
			'area'    => 'hai-chau',
			'hot'     => true,
			'excerpt' => 'The Sunrise Bay (Khu đô thị quốc tế Đa Phước) – khu đô thị lấn biển đầu tiên của Đà Nẵng ở cửa sông Hàn: khoảng 170,7 ha, khoảng 4.481 nhà phố – biệt thự, bệnh viện, trường học, khách sạn, hội nghị, khu vui chơi khoảng 12 ha; vốn gần 54.788 tỷ đồng, tái khởi động 17/11/2026.',
			'meta'    => array(
				'hh_p_status'        => 'sap-mo-ban',
				'hh_p_developer'     => 'Công ty TNHH The Sunrise Bay – FUTA Land (FUTA Group – Phương Trang) phát triển dự án',
				'hh_p_type'          => 'Khu đô thị lấn biển: nhà phố, biệt thự, shophouse thấp tầng; khách sạn, trung tâm hội nghị, thương mại – dịch vụ',
				'hh_p_address'       => 'Đường Nguyễn Tất Thành, cửa sông Hàn – vịnh Đà Nẵng, phường Hải Châu và phường Thanh Khê, TP Đà Nẵng',
				'hh_p_map_address'   => 'Khu đô thị quốc tế Đa Phước, Nguyễn Tất Thành, Đà Nẵng',
				'hh_p_scale'         => 'Khoảng 170,7 ha (1.707.462 m²), tổng vốn gần 54.788 tỷ đồng; dân số khoảng 16.132 người',
				'hh_p_units'         => 'Khoảng 4.481 căn nhà phố, biệt thự thấp tầng (theo Quyết định 3605/QĐ-UBND)',
				'hh_p_legal'         => "Quyết định 3605/QĐ-UBND ngày 12/8/2026 của UBND TP Đà Nẵng điều chỉnh chủ trương đầu tư (thay Quyết định 1443/QĐ-UBND ngày 17/3/2017)\nĐang hoàn thiện quy hoạch chi tiết 1/500 điều chỉnh (lấy ý kiến cộng đồng từ 9/2026)\nChưa có thông báo đủ điều kiện bán – chưa nhận đặt cọc",
				'hh_p_ownership'     => 'Nhà ở thương mại để bán, cho thuê, cho thuê mua; không bán cho tổ chức, cá nhân nước ngoài (theo Quyết định 3605/QĐ-UBND)',
				'hh_p_start'         => 'Tái khởi động 17/11/2026; nhà thấp tầng thi công từ tháng 9/2026',
				'hh_p_handover'      => 'Giai đoạn 1 hoàn thành quý IV/2028; toàn dự án vận hành quý II/2033',
				'hh_p_highlights'    => "Khu đô thị lấn biển đầu tiên của Đà Nẵng – 3 mặt giáp vịnh Đà Nẵng và cửa sông Hàn, ngay đường Nguyễn Tất Thành\nQuy mô khoảng 170,7 ha, khoảng 4.481 nhà phố – biệt thự, khoảng 16.132 cư dân\nBệnh viện đa khoa, trường học các cấp, 14 công trình dịch vụ công cộng, khu vui chơi giải trí khoảng 12 ha\nKhách sạn, trung tâm hội nghị, thương mại – dịch vụ khoảng 1,04 triệu m² sàn\nCông viên – quảng trường khoảng 25 ha\nFUTA Group (Phương Trang) đứng sau, vốn điều lệ chủ đầu tư khoảng 12.673 tỷ đồng (theo báo chí)\nTái khởi động 17/11/2026, có lộ trình 3 giai đoạn đến quý II/2033",
				'hh_p_design_desc'   => 'Bán đảo nhân tạo ở cửa sông Hàn, phía Tây cầu Thuận Phước: phía Bắc và Tây giáp vịnh Đà Nẵng, phía Nam giáp đường Nguyễn Tất Thành, phía Đông giáp sông Hàn và khu dân cư Thuận Phước. Sản phẩm là nhà ở thấp tầng (nhà phố, biệt thự, shophouse), xen kênh nội khu, công viên ven biển; các công trình khách sạn, hội nghị, bệnh viện, vui chơi giải trí tập trung ở giai đoạn sau.',
				'hh_p_zones'         => "Giai đoạn 1 | Nhà thấp tầng ven biển, kè, hạ tầng kỹ thuật | Khoảng 39,8 ha | Hoàn thành quý IV/2028\nGiai đoạn 2 | Kè biển còn lại, khu vui chơi giải trí, nhà thấp tầng, trường học, dịch vụ công cộng | Khoảng 117,9 ha | Hoàn thành quý III/2032\nGiai đoạn 3 | Bệnh viện, thương mại – dịch vụ, khách sạn, trung tâm hội nghị | Khoảng 13 ha | Hoàn thành quý II/2033",
				'hh_p_unit_types'    => "Nhà phố liền kề | Theo quy hoạch 1/500 | – | Chưa mở bán\nBiệt thự | Theo quy hoạch 1/500 | – | Chưa mở bán\nShophouse | Theo quy hoạch 1/500 | – | Chưa mở bán",
				'hh_p_location_desc' => 'The Sunrise Bay nằm ở cửa sông Hàn, phía Tây cầu Thuận Phước, trải trên hai phường Hải Châu và Thanh Khê – ngay trung tâm thành phố nhưng có mặt nước vịnh Đà Nẵng bao quanh. Từ dự án qua cầu Thuận Phước sang Sơn Trà, theo đường Nguyễn Tất Thành ven biển về Liên Chiểu, hoặc vào trung tâm Hải Châu đều thuận tiện.',
				'hh_p_connections'   => "Liền kề | Cầu Thuận Phước, sông Hàn\nVài phút | Trung tâm Hải Châu, đường Nguyễn Tất Thành ven biển\nKhoảng 10 – 15 phút | Sân bay quốc tế Đà Nẵng (ước tính)\nKhoảng 10 phút | Bán đảo Sơn Trà, biển Mỹ Khê (ước tính, qua cầu Thuận Phước)",
				'hh_p_amenities_in'  => "Bệnh viện đa khoa (khoảng 32.677 m² sàn)\nTrường học các cấp (khoảng 107.196 m² sàn)\n14 công trình dịch vụ công cộng\nKhu vui chơi giải trí khoảng 12,02 ha\nKhách sạn, trung tâm hội nghị\nThương mại – dịch vụ khoảng 1.036.000 m² sàn\nCông viên, quảng trường, cây xanh khoảng 25 ha",
				'hh_p_amenities_out' => "Cầu Thuận Phước, sông Hàn\nTrung tâm hành chính, thương mại Hải Châu\nBiển Nguyễn Tất Thành, công viên ven biển\nBán đảo Sơn Trà, biển Mỹ Khê",
				'hh_p_progress'      => "2006 | Đà Nẵng ký thỏa thuận hợp tác với nhà đầu tư Hàn Quốc Daewon\n17/3/2017 | Quyết định 1443/QĐ-UBND chấp thuận chủ trương đầu tư\n2017 – 2025 | Dự án tạm dừng, rà soát pháp lý, thanh tra\n12/8/2026 | Quyết định 3605/QĐ-UBND điều chỉnh chủ trương đầu tư\n9/2026 | Lấy ý kiến cộng đồng quy hoạch 1/500 điều chỉnh; khởi công nhà thấp tầng\n17/11/2026 | Lễ tái khởi động \"Đánh thức kỳ quan – Viết tiếp giấc mơ đô thị\"\nQuý IV/2028 | Hoàn thành giai đoạn 1\nQuý III/2032 | Hoàn thành giai đoạn 2\nQuý II/2033 | Hoàn thành giai đoạn 3, vận hành toàn dự án",
				'hh_p_policy'        => "Dự án chưa mở bán, chưa nhận đặt cọc – chỉ giao dịch khi có thông báo đủ điều kiện bán của Sở Xây dựng\nĐăng ký với Hoàng Hiệp 0904 567 009 để nhận thông tin mở bán, mặt bằng và giá chính thức sớm nhất",
				'hh_p_faq'           => implode(
					"\n",
					array(
						'The Sunrise Bay là dự án gì? | Tên thương mại của Khu đô thị quốc tế Đa Phước – khu đô thị lấn biển ở cửa sông Hàn, khoảng 170,7 ha, khoảng 4.481 nhà phố – biệt thự, vốn gần 54.788 tỷ đồng.',
						'Ai là chủ đầu tư? | Công ty TNHH The Sunrise Bay; FUTA Land (FUTA Group – Phương Trang) phát triển dự án từ năm 2026 (theo báo chí).',
						'Dự án đã mở bán chưa? | Chưa. Dự án mới tái khởi động 17/11/2026, chưa có thông báo đủ điều kiện bán – không nên đặt cọc qua kênh không chính thức.',
						'Khi nào hoàn thành? | Giai đoạn 1 quý IV/2028 (nhà thấp tầng xong quý II/2028), giai đoạn 2 quý III/2032, giai đoạn 3 quý II/2033.',
						'Người nước ngoài có mua được không? | Không. Quyết định 3605/QĐ-UBND ghi dự án không bán nhà ở cho tổ chức, cá nhân nước ngoài.',
						'Khách hàng mua giai đoạn trước được xử lý thế nào? | Quyết định điều chỉnh yêu cầu chủ đầu tư thực hiện đầy đủ nghĩa vụ với khách hàng theo quy định pháp luật; phương án cụ thể chờ chủ đầu tư công bố.',
					)
				),
				'hh_p_image_links'   => implode(
					"\n",
					array(
						$im( 'da-phuoc/da-phuoc-phoi-canh-tong-the-cua-song-han', 'The Sunrise Bay – Khu đô thị quốc tế Đa Phước ở cửa sông Hàn, nhìn về bán đảo Sơn Trà (phối cảnh)', 'đại diện' ),
						$im( 'da-phuoc/da-phuoc-giai-doan-1-39-8-ha', 'Giai đoạn 1 khoảng 39,8 ha – nhà thấp tầng ven biển (phối cảnh)', 'tổng thể' ),
						$im( 'da-phuoc/da-phuoc-giai-doan-2-117-9-ha', 'Giai đoạn 2 khoảng 117,9 ha – kè biển, kênh nội khu, đảo vui chơi giải trí (phối cảnh)', 'tổng thể' ),
						$im( 'da-phuoc/da-phuoc-giai-doan-3-dao-13-ha', 'Giai đoạn 3 khoảng 13 ha – bệnh viện, khách sạn, trung tâm hội nghị trên đảo (phối cảnh)', 'thư viện' ),
						$im( 'the-sunrise-bay/the-sunrise-bay-ban-do-vi-tri', 'Bản đồ vị trí The Sunrise Bay: giữa vịnh Đà Nẵng và sông Hàn, cạnh cầu Thuận Phước, đường Nguyễn Tất Thành', 'tổng thể' ),
						$im( 'the-sunrise-bay/the-sunrise-bay-phoi-canh-ban-dao-ve-dem', 'Bán đảo The Sunrise Bay về đêm, phía sau là bán đảo Sơn Trà và cầu Thuận Phước (phối cảnh)', 'thư viện' ),
						$im( 'the-sunrise-bay/the-sunrise-bay-phoi-canh-tong-the-ban-ngay', 'Toàn cảnh khu đô thị lấn biển The Sunrise Bay nhìn từ cầu Thuận Phước (phối cảnh)', 'thư viện' ),
						$im( 'the-sunrise-bay/the-sunrise-bay-phoi-canh-marina-khach-san', 'Bến du thuyền, khách sạn và nhà phố ven kênh The Sunrise Bay lúc hoàng hôn (phối cảnh)', 'tiện ích', 'Marina – khách sạn' ),
						$im( 'the-sunrise-bay/the-sunrise-bay-so-do-phan-khu-2017', 'Sơ đồ phân khu The Sunrise Bay giai đoạn đầu năm 2017 (tư liệu): Hừng Đông, Bình Minh, Hoàng Hôn – nhà phố, song lập, shophouse, trường học, bệnh viện', 'thư viện' ),
					)
				),
			),
			'content' => '<p><strong>The Sunrise Bay</strong> – tên thương mại của Khu đô thị quốc tế Đa Phước – là khu đô thị lấn biển đầu tiên của Đà Nẵng, nằm ở cửa sông Hàn, phía Tây cầu Thuận Phước. Sau nhiều năm tạm dừng, dự án được UBND thành phố điều chỉnh chủ trương đầu tư ngày 12/8/2026 và tái khởi động sáng 17/11/2026, với FUTA Group (Phương Trang) đứng sau phát triển.</p>
<h2>Vì sao The Sunrise Bay được chú ý?</h2>
<ul>
<li><strong>Vị trí không thể tạo lại:</strong> bán đảo nhân tạo giữa vịnh Đà Nẵng và cửa sông Hàn, ngay trung tâm thành phố – quỹ đất ven biển nội đô gần như không còn.</li>
<li><strong>Quy mô đô thị hoàn chỉnh:</strong> khoảng 170,7 ha, khoảng 4.481 nhà phố – biệt thự cho khoảng 16.132 cư dân, có bệnh viện, trường học các cấp, 14 công trình công cộng.</li>
<li><strong>Dịch vụ cao cấp:</strong> khu vui chơi giải trí khoảng 12 ha, khách sạn, trung tâm hội nghị, khoảng 1,04 triệu m² sàn thương mại – dịch vụ, khoảng 25 ha công viên – quảng trường.</li>
<li><strong>Pháp lý được tháo gỡ, có lộ trình rõ:</strong> Quyết định 3605/QĐ-UBND yêu cầu chủ đầu tư không chuyển nhượng dự án, thu xếp đủ vốn, ký quỹ hoặc bảo lãnh ngân hàng và hoàn thành nghĩa vụ tài chính về đất.</li>
</ul>
<h2>Tiến độ 3 giai đoạn</h2>
<table>
<thead><tr><th>Giai đoạn</th><th>Diện tích</th><th>Hạng mục</th><th>Hoàn thành</th></tr></thead>
<tbody>
<tr><td>1</td><td>Khoảng 39,8 ha</td><td>Nhà thấp tầng (thi công từ 9/2026, xong quý II/2028), kè biển, hạ tầng kỹ thuật</td><td>Quý IV/2028</td></tr>
<tr><td>2</td><td>Khoảng 117,9 ha</td><td>Kè biển còn lại, khu vui chơi giải trí, hạ tầng, nhà thấp tầng, trường học, dịch vụ công cộng</td><td>Quý III/2032</td></tr>
<tr><td>3</td><td>Khoảng 13 ha</td><td>Bệnh viện, thương mại – dịch vụ, khách sạn, trung tâm hội nghị</td><td>Quý II/2033</td></tr>
</tbody>
</table>
<h2>Chủ đầu tư và nhà phát triển</h2>
<p>Chủ đầu tư là Công ty TNHH The Sunrise Bay (tiền thân là doanh nghiệp vốn Hàn Quốc của Daewon). Theo báo chí, từ 2026 FUTA Land – thành viên FUTA Group (Phương Trang) – là đơn vị phát triển dự án; vốn điều lệ của chủ đầu tư được nâng lên khoảng 12.673 tỷ đồng.</p>
<h2>Lưu ý cho người quan tâm</h2>
<p>Dự án <strong>chưa mở bán và chưa đủ điều kiện nhận đặt cọc</strong>. Giá và sản phẩm cụ thể sẽ theo quy hoạch 1/500 được duyệt và thông báo của chủ đầu tư. Dự án không bán cho người nước ngoài. Khách hàng ký hợp đồng ở giai đoạn trước được thành phố yêu cầu chủ đầu tư thực hiện đầy đủ nghĩa vụ theo pháp luật.</p>
<p>Đăng ký với <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận thông tin mở bán, mặt bằng và giá chính thức của The Sunrise Bay sớm nhất. Xem thêm bài <a href="/khu-do-thi-quoc-te-da-phuoc-3-giai-doan/">tiến độ 3 giai đoạn Khu đô thị quốc tế Đa Phước</a>.</p>',
			'sources' => array(
				'https://danang.gov.vn/vi/w/dieu-chinh-chu-truong-dau-tu-du-an-khu-do-thi-quoc-te-da-phuoc',
				'https://baodanang.vn/da-nang-tai-khoi-dong-du-an-khu-do-thi-quoc-te-da-phuoc-3358693.html',
				'https://nhandan.vn/da-nang-tai-khoi-dong-du-an-khu-do-thi-quoc-te-da-phuoc-quy-mo-hon-170ha-post1003231.html',
				'https://www.vietnamplus.vn/da-nang-tai-khoi-dong-du-an-do-thi-quoc-te-da-phuoc-post1148847.vnp',
				'https://tuoitre.vn/sieu-du-an-da-phuoc-54787-ti-dong-co-dong-thai-moi-sau-nhieu-nam-dap-chieu-100260929151118704.htm',
			),
		);
		return $projects;
	},
	20
);
