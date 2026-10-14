<?php
/**
 * Mặt bằng giá đất lớn và khách sạn ven biển Đà Nẵng – tổng hợp từ tin rao, báo cáo thị trường công khai (10/2026).
 * Chỉ là khoảng giá tham khảo theo khu vực, không phải tin rao cụ thể.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_market_boards', 'hh_board_dat_khach_san' );
function hh_board_dat_khach_san( $boards ) {
	$boards['dat-lon'] = array(
		'title'   => 'Giá đất ven biển, đất lớn xây khách sạn Đà Nẵng theo tuyến đường',
		'intro'   => 'Khoảng giá chào bán tổng hợp từ tin rao tháng 10/2026, tách lô nhỏ – vừa (dưới khoảng 350 m²) và lô lớn trên từng trục biển, cùng các trục gần biển, trung tâm phù hợp xây khách sạn, căn hộ dịch vụ. Giá thực tế phụ thuộc mặt tiền, hình dáng lô, quy hoạch tầng cao và pháp lý; cần thẩm định từng lô trước khi giao dịch.',
		'columns' => array( 'Khu vực / tuyến đường', 'Diện tích phổ biến', 'Giá tham khảo', 'Ghi chú' ),
		'rows'    => array(
			array(
				'Hoàng Sa (Sơn Trà) – lô nhỏ, vừa',
				'200 – 330 m² (ngang 10 – 15 m)',
				'Khoảng 330 – 415 triệu/m²; 212 m² ngang 10 m rao 70 tỷ, 213 m² rao 74,5 tỷ, 327 m² ngang 15 m khoảng 350 triệu/m²',
				'Mặt biển Mân Thái – Phạm Văn Đồng, lô nhỏ khan hàng nên đơn giá cao hơn lô lớn. Đất kiệt gần Hoàng Sa khoảng 75 – 150 triệu/m².',
			),
			array(
				'Hoàng Sa (Sơn Trà) – lô lớn',
				'580 – 1.000 m²',
				'Khoảng 170 – 400 triệu/m²; 583 m² khoảng 326 triệu/m², 775 m² khoảng 250 triệu/m², 600 m² ngang 30 m khoảng 240 tỷ, 1.000 m² khoảng 170 tỷ',
				'Quy hoạch cao tầng, phù hợp khách sạn, căn hộ dịch vụ cao cấp; biên độ rộng do mặt tiền, lô góc, khoảng cách tới phố du lịch.',
			),
			array(
				'Võ Nguyên Giáp (Sơn Trà – Ngũ Hành Sơn) – lô nhỏ, vừa',
				'150 – 300 m²',
				'Khoảng 130 – 390 triệu/m²; lô ngang 6 m (150 – 156 m²) khoảng 22 – 25 tỷ (≈ 145 – 165 triệu/m²); 285 m² ngang 12 m khoảng 130 triệu/m²; 280 m² ngang 14 m rao 108 tỷ',
				'Mặt biển Mỹ Khê – Non Nước; lô ngang 6 m chỉ hợp khách sạn mini, lô ngang từ 12 – 14 m đơn giá cao hơn hẳn.',
			),
			array(
				'Võ Nguyên Giáp (Sơn Trà – Ngũ Hành Sơn) – lô lớn',
				'500 – 900 m²',
				'Khoảng 200 triệu/m² (lô 826 m² khu An Thượng); lô lớn ít tin rao, giá thỏa thuận',
				'Bảng giá đất nhà nước đầu 2026 (Nghị quyết 32/2025) khoảng 220 – 280 triệu/m² tùy đoạn; từ 10/6/2026 áp dụng Nghị quyết 28/2026 – cần tra lại theo đoạn.',
			),
			array(
				'Trường Sa (Ngũ Hành Sơn) – lô nhỏ, vừa',
				'Khoảng 300 m²',
				'Khoảng 100 triệu/m²; 300 m² ngang 8 m rao 99,9 triệu/m²',
				'Gần biển Tân Trà, resort và Newtown; giá mềm hơn Võ Nguyên Giáp phía Bắc.',
			),
			array(
				'Trường Sa (Ngũ Hành Sơn) – lô lớn',
				'500 – 1.000 m²',
				'Khoảng 60 – 130 triệu/m²; lô góc 2 mặt tiền 500 m² rao 64,6 tỷ, 998 m² ngang 25 m khoảng 60 tỷ',
				'Quỹ đất resort, khách sạn nghỉ dưỡng; phù hợp đầu tư dài hạn.',
			),
			array(
				'Võ Văn Kiệt (Sơn Trà)',
				'400 – 800 m² (có lô góc 2.635 m²)',
				'Lô 400 m² khoảng 125 – 160 tỷ (≈ 310 – 400 triệu/m²); lô góc 3 mặt tiền 2.635 m² rao 1.500 tỷ',
				'Trục sân bay – biển Mỹ Khê, cách biển khoảng 300 m; một số lô đã có phép xây 17 tầng.',
			),
			array(
				'Phạm Văn Đồng (Sơn Trà)',
				'250 – 825 m²',
				'Khoảng 190 – 280 triệu/m²; 250 m² khoảng 63 tỷ, 777 m² khoảng 150 tỷ, 825 m² khoảng 200 tỷ',
				'Gần biển; có lô kèm thiết kế khách sạn 87 phòng, mật độ 69%.',
			),
			array(
				'Bạch Đằng (Hải Châu)',
				'1.000 – 1.500 m²',
				'Nhà, đất mặt tiền rao khoảng 300 triệu/m²; lô góc 2 mặt tiền khoảng 1.000 m² rao 125 tỷ (số liệu tin rao chưa nhất quán)',
				'Mặt sông Hàn, gần cầu Rồng; bảng giá nhà nước 2026 đoạn Lê Duẩn – Nguyễn Văn Linh khoảng 341 triệu/m² (cao nhất thành phố). Giá lô lớn chênh lệch rất mạnh giữa các tin.',
			),
			array(
				'Nguyễn Văn Linh (Hải Châu – Thanh Khê)',
				'300 – 1.750 m²',
				'Khoảng 250 – 400 triệu/m²; 1.200 m² ngang 30 m khoảng 360 tỷ, lô góc 1.750 m² khoảng 600 tỷ',
				'Trục thương mại trung tâm nối sân bay – cầu Rồng; phù hợp văn phòng, khách sạn thành phố.',
			),
			array(
				'Nguyễn Tất Thành (Thanh Khê – Hải Châu) – lô nhỏ',
				'Khoảng 125 m² (5 × 25 m)',
				'Khoảng 110 – 172 triệu/m²; lô 125 m² rao 13,8 – 21,5 tỷ, đối diện bãi tắm Thanh Khê khoảng 15 tỷ, lô có đường sau 5 m khoảng 14,75 tỷ',
				'Mặt biển Thanh Khê – Xuân Hà, đường 6 làn, vỉa hè rộng; lô 125 m² là quy cách phổ biến nhất.',
			),
			array(
				'Nguyễn Tất Thành (Thanh Khê – Hải Châu) – lô lớn',
				'250 – 500 m²',
				'Khoảng 80 – 180 triệu/m²; 250 m² ngang 10 m khoảng 35 tỷ, cặp lô 273 m² rao 49 tỷ, 400 m² ngang 15 m khoảng 32,9 tỷ',
				'Có lô góc 3 mặt tiền khoảng 436 m² phía Hải Châu; phù hợp khách sạn, nhà hàng. Tin lô 500 m² ghi giá chưa nhất quán (25,5 – 50 tỷ).',
			),
			array(
				'Nguyễn Tất Thành nối dài (Liên Chiểu) – lô nhỏ',
				'100 – 120 m²',
				'Khoảng 47 – 58 triệu/m²; 105 m² Hòa Hiệp Nam rao 4,95 tỷ; lô sát biển đường Dũng Sĩ Thanh Khê khoảng 57,5 triệu/m²',
				'Mặt bằng giá thấp nhất trong các trục biển nội thành; hưởng lợi cảng Liên Chiểu, đường tránh Nam Hải Vân.',
			),
			array(
				'Nguyễn Tất Thành (Liên Chiểu) – lô lớn',
				'375 – 900 m²',
				'Khoảng 65 – 135 triệu/m²; 375 m² khoảng 30 tỷ, 479 m² mặt biển khoảng 65 tỷ, 897 m² ngang 35 m khoảng 72 triệu/m²',
				'Đất song song Nguyễn Tất Thành (đường Xuân Thiều) khoảng 38 triệu/m² – không phải mặt biển.',
			),
			array(
				'Võ Chí Công (Ngũ Hành Sơn – Cẩm Lệ)',
				'100 – 125 m² (ít lô lớn)',
				'Khoảng 45 – 70 triệu/m²',
				'Chủ yếu đất nền dự án, lô lớn hiếm; Sun Group dự kiến mở bán đất nền Võ Chí Công nối dài.',
			),
			array(
				'Hòa Xuân – ven sông Cổ Cò',
				'100 – 300 m²',
				'Khoảng 50 – 115 triệu/m² (đất thổ cư Hòa Xuân); đất nền dự án ven sông Cổ Cò phía Điện Bàn khoảng 18 – 19 triệu/m²',
				'Mặt sông, đô thị sinh thái; ít lô ≥ 300 m² trên tin rao, cần khảo sát thêm.',
			),
			array(
				'Lạc Long Quân (Điện Bàn – Hội An) – lô nhỏ, vừa',
				'240 – 250 m²',
				'Khoảng 31 – 46 triệu/m²; 240 m² ngang 6 m khoảng 7,4 tỷ, 252 m² (13 × 16 m) Cẩm An rao 11,5 tỷ',
				'Trục biển Đà Nẵng – Hội An; địa chỉ tin rao hay lẫn Điện Ngọc, Điện Dương, Cẩm An – cần đối chiếu vị trí trên sổ.',
			),
			array(
				'Lạc Long Quân (Điện Bàn – Hội An) – lô lớn',
				'580 – 4.000 m²',
				'Khoảng 16 – 30 triệu/m²; 580 m² khoảng 26 triệu/m², 1.150 m² ngang 32 m khoảng 33,5 tỷ',
				'Ven biển gần resort Nam Hải, Hà My; phù hợp quỹ đất resort, villa nghỉ dưỡng.',
			),
		),
		'sources' => array(
			'https://guland.vn/bang-gia-dat/da-nang/thanh-pho-da-nang-cu-da-nang/vo-nguyen-giap',
			'https://kenhrao.com/tin-dang/mat-bien-vo-nguyen-giap-280m2-ngang-14m-gia-108-ty-da-nang.1009275/',
			'https://batdongsan.com.vn/ban-dat-duong-hoang-sa-49',
			'https://batdongsan.com.vn/ban-dat-duong-vo-van-kiet-49',
			'https://www.nhadatdanang.asia/2026/07/ban-lo-at-kem-du-office-tel-uong-pham.html',
			'https://nhadat.cafeland.vn/can-ban-lo-dat-1408m2-mat-tien-duong-bach-dang-view-truc-dien-song-han-da-nang-2032530.html',
			'https://www.nhatot.com/tags/mua-ban-dat-duong-nguyen-tat-thanh-da-nang',
			'https://alonhadat.com.vn/nha-dat/can-ban/dat-tho-cu-dat-o/duong-lac-long-quan-thi-xa-dien-ban-dp24382.html',
			'https://alonhadat.com.vn/nha-dat/can-ban/nha-dat/duong-hoang-sa-quan-son-tra-dp2774.html',
			'https://www.nhatot.com/tags/ban-dat-mat-tien-duong-hoang-sa-da-nang',
			'https://homedy.com/ban-dat-duong-vo-nguyen-giap-quan-ngu-hanh-son-da-nang',
			'https://alonhadat.com.vn/nha-dat/can-ban/nha-dat/duong-truong-sa-quan-ngu-hanh-son-dp2959.html',
			'https://batdongsan.com.vn/ban-dat-duong-nguyen-tat-thanh-50',
			'https://alonhadat.com.vn/nha-dat/can-ban/dat-tho-cu-dat-o/duong-nguyen-tat-thanh-quan-thanh-khe-dp2705.html',
			'https://homedy.com/ban-dat-quan-lien-chieu-da-nang/mat-tien-duong-nguyen-tat-thanh-noi-dai-vi-tri-rat-dep-es3151085',
			'https://batdongsan.com.vn/ban-dat-duong-lac-long-quan-520',
		),
	);
	$boards['khach-san'] = array(
		'title'   => 'Giá khách sạn ven biển Đà Nẵng theo khu vực',
		'intro'   => 'Khoảng giá chào bán khách sạn đang kinh doanh gần biển Mỹ Khê, Sơn Trà và Hội An theo tin rao năm 2026. Năm 2026 thị trường phân hóa mạnh, công suất phòng 4 – 5 sao quý I đạt khoảng 85 – 88%; giá chào thường còn biên độ thương lượng.',
		'columns' => array( 'Khu vực', 'Quy mô', 'Giá tham khảo', 'Ghi chú' ),
		'rows'    => array(
			array(
				'Võ Nguyên Giáp – mặt biển (boutique)',
				'140 m² đất, 7 – 12 tầng, 26 – 52 phòng',
				'Khoảng 48 – 90 tỷ',
				'Khách sạn 52 phòng 12 tầng rao 90 tỷ, công suất mùa cao điểm khoảng 95%.',
			),
			array(
				'Võ Nguyên Giáp – mặt biển (4 sao, quy mô lớn)',
				'500 – 900 m² đất, 12 – 26 tầng, 84 – 165 phòng',
				'Khoảng 650 – 1.350 tỷ',
				'Có hồ bơi vô cực, spa, phòng hội nghị; tin rao 84 phòng khoảng 710 tỷ, 118 phòng khoảng 650 tỷ.',
			),
			array(
				'An Thượng (phố Tây Mỹ Khê)',
				'80 – 300 m² đất, 5 – 11 tầng, 16 – 40 phòng',
				'Khoảng 28 – 125 tỷ (phổ biến 59 – 65 tỷ cho 40 phòng)',
				'Đang kinh doanh; An Thượng 1 – 16 phòng doanh thu khoảng 300 triệu/tháng rao 28 tỷ; 3 sao 40 phòng 295 m² rao 65 tỷ.',
			),
			array(
				'Trần Bạch Đằng – Đỗ Bá (Mỹ An)',
				'155 – 300 m² đất, 11 – 15 tầng, 40 – 57 phòng',
				'Khoảng 75 – 170 tỷ',
				'Cách biển Mỹ Khê khoảng 150 – 300 m; 3 sao 40 phòng 155 m² rao 75 tỷ; 3 sao 12 tầng 57 phòng doanh thu hơn 450 triệu/tháng chào 130 tỷ.',
			),
			array(
				'Hồ Nghinh (Sơn Trà)',
				'100 – 300 m² đất, 9 – 16 tầng, 16 – 68 phòng',
				'Khoảng 30 – 125 tỷ',
				'Gần tháp đôi Vương Thừa Vũ; khách sạn có hồ bơi doanh thu khoảng 600 triệu/tháng rao 99 tỷ.',
			),
			array(
				'Phạm Văn Đồng (Sơn Trà)',
				'235 – 345 m² đất, 12 – 16 tầng, 60 – 81 phòng',
				'Khoảng 88 – 165 tỷ',
				'2 mặt tiền 12 tầng 60 phòng doanh thu hơn 600 triệu/tháng chào 88 tỷ; 4 sao 16 tầng 74 phòng chào 160 tỷ (10/2026).',
			),
			array(
				'Sơn Thủy – An Tư Công Chúa – Hồ Xuân Hương (Ngũ Hành Sơn)',
				'258 – 381 m² đất, 9 – 12 tầng, 45 – 56 phòng',
				'Khoảng 68 – 115 tỷ',
				'Căn góc 9 tầng 45 phòng biển Sơn Thủy chào 68 tỷ; 2 mặt tiền An Tư Công Chúa 52 phòng chào 85 tỷ (10/2026).',
			),
			array(
				'Phan Tôn – Dương Đình Nghệ – Võ Văn Kiệt (Sơn Trà)',
				'180 – 270 m² đất, 11 – 12 tầng, 37 – 53 phòng',
				'Khoảng 97 – 170 tỷ',
				'Phan Tôn 42 phòng doanh thu hơn 700 triệu/tháng chào 125 tỷ; Võ Văn Kiệt 53 phòng cho thuê khoán 220 triệu/tháng chào 170 tỷ.',
			),
			array(
				'Mỹ Khê – đường nhánh gần biển',
				'124 – 370 m² đất',
				'Khoảng 30 – 165 tỷ',
				'Boutique 285 m² rao 38 tỷ, 124 m² rao 30 tỷ; lô 368 m² ngang 18,5 m rao 165 tỷ.',
			),
			array(
				'Hội An – An Bàng, Tân Thành',
				'650 – 1.600 m² đất, 3 – 7 tầng, 20 – 39 phòng',
				'Khoảng 50 – 91 tỷ; resort 5 sao 80 phòng rao khoảng 900 tỷ',
				'Villa 20 phòng cách biển An Bàng 50 m rao 50 tỷ; khách sạn 39 phòng trên 1.600 m² rao 91 tỷ.',
			),
		),
		'sources' => array(
			'https://batdongsan.com.vn/ban-nha-mat-pho-duong-vo-nguyen-giap-phuong-man-thai/chinh-chu-can-ban-toa-khach-san-bien-4sao-sang-trong-son-tra-da-nang-pr44422978',
			'https://www.nhadatdanang.asia/2026/05/ban-khach-san-uong-vo-nguyen-giap-bien.html',
			'https://alonhadat.com.vn/ban-khach-san-mat-tien-vo-nguyen-giap-my-an-ngu-hanh-son-da-nang-48-ty-140m2-16782649.html',
			'https://www.nhadatdanang.asia/2026/06/ban-khach-san-uong-thuong-29-khu-loi.html',
			'https://batdongsan.com.vn/ban-nha-mat-pho-duong-tran-bach-dang-phuong-my-an-48/ban-khach-san-11-tang-2-tien-khu-tay-thuong-gia-dau-tu-125ty-pr43688018',
			'https://www.nhadatdanang.asia/2026/07/ban-khach-san-uong-ho-nghinh-gan-toa.html',
			'https://homedy.com/ban-khach-san-da-nang/gia-tu-30-ty-den-40-ty',
			'https://cafef.vn/bds-da-nang-2026-phan-hoa-manh-de-thanh-loc-thi-truong-188260615112835053.chn',
		),
	);
	return $boards;
}
