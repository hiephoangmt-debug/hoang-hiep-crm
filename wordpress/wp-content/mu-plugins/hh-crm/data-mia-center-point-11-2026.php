<?php
/**
 * MIA Center Point (Liên Chiểu) – trang dự án mới, 08/11/2026, từ bộ tài liệu dự án anh Hiệp gửi (Drive):
 * brochure, Q&A chủ đầu tư, giấy phép xây dựng, phiếu tính giá 4/2026 (giỏ hàng 1/2026), chính sách 10/2025 (đã hết hạn).
 * 53 ảnh: phối cảnh, tiện ích tầng 1 và hồ bơi tầng 25, nhà mẫu thực tế, nội thất mẫu căn A/C/D, layout 3D căn A – G,
 * mặt bằng tầng, tiến độ 3/2025 và 8/2025 (ảnh 8/2025 đã cắt dải trên có logo đơn vị phân phối).
 * Không đăng mã căn, tờ/thửa, hợp đồng mẫu, tài liệu ngân hàng, quy trình giao dịch, tài liệu đào tạo.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/mia-center-point/mia-center-point-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-toa-nha', 'Tòa căn hộ MIA Center Point 25 tầng trên đường Ngô Thì Nhậm, Liên Chiểu (phối cảnh)', 'đại diện' ),
			$im( 'phoi-canh-tong-the-ban-ngay', 'MIA Center Point giữa khu dân cư Hòa Khánh Bắc, phía sau là núi (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-tong-the-ban-dem', 'MIA Center Point về đêm nhìn ra vịnh Đà Nẵng (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-nhin-tu-tren-cao', 'MIA Center Point nhìn từ trên cao (phối cảnh)', 'tổng thể' ),
			$im( 'tien-ich-ho-boi-tang-25', 'Hồ bơi trên cao tầng 25 MIA Center Point (phối cảnh)', 'tiện ích', 'Hồ bơi tầng 25' ),
			$im( 'tien-ich-sinh-hoat-cong-dong', 'Khu sinh hoạt cộng đồng tầng 1 (phối cảnh)', 'tiện ích', 'Sinh hoạt cộng đồng' ),
			$im( 'tien-ich-hoi-truong-cu-dan', 'Phòng họp cư dân tầng 1 (phối cảnh)', 'tiện ích', 'Sinh hoạt cộng đồng' ),
			$im( 'tien-ich-khong-gian-doc-sach', 'Góc đọc sách, bàn trà khu cộng đồng (phối cảnh)', 'tiện ích', 'Sinh hoạt cộng đồng' ),
			$im( 'tien-ich-san-vuon-tang-1', 'Sân vườn khu cộng đồng tầng 1 (phối cảnh)', 'tiện ích', 'Sân vườn' ),
			$im( 'tien-ich-gym', 'Khu tập thể thao cư dân (phối cảnh)', 'tiện ích', 'Gym' ),
			$im( 'tien-ich-nha-tre-san-choi', 'Sân chơi trẻ em trong khu nhà trẻ (phối cảnh)', 'tiện ích', 'Nhà trẻ' ),
			$im( 'tien-ich-nha-tre-lop-hoc', 'Lớp học nhà trẻ tầng 1 (phối cảnh)', 'tiện ích', 'Nhà trẻ' ),
			$im( 'tien-ich-nha-tre-khu-vui-choi', 'Khu vui chơi nhà trẻ (phối cảnh)', 'tiện ích', 'Nhà trẻ' ),
			$im( 'tien-ich-nha-tre-goc-doc-sach', 'Góc đọc sách cho bé (phối cảnh)', 'tiện ích', 'Nhà trẻ' ),
			$im( 'tien-ich-sanh-le-tan', 'Sảnh lễ tân tòa nhà (phối cảnh)', 'tiện ích', 'Sảnh đón' ),
			$im( 'tien-ich-sanh-don', 'Sảnh đón cư dân tầng 1 (phối cảnh)', 'tiện ích', 'Sảnh đón' ),
			$im( 'tien-ich-sanh-thang-may', 'Sảnh thang máy (phối cảnh)', 'tiện ích', 'Sảnh đón' ),
			$im( 'nha-mau-thuc-te-phong-khach-an', 'Căn hộ mẫu thực tế: phòng khách và bàn ăn', 'thư viện' ),
			$im( 'nha-mau-thuc-te-phong-khach', 'Căn hộ mẫu thực tế: phòng khách thông lô gia', 'thư viện' ),
			$im( 'nha-mau-thuc-te-bep', 'Căn hộ mẫu thực tế: bếp và phòng ăn', 'thư viện' ),
			$im( 'nha-mau-thuc-te-loi-vao', 'Căn hộ mẫu thực tế: lối vào', 'thư viện' ),
			$im( 'noi-that-can-a-phong-khach', 'Phòng khách căn A 67,2 m² (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-a-phong-khach-an', 'Phòng khách – bàn ăn căn A (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-a-phong-ngu-master', 'Phòng ngủ master căn A (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-a-phong-ngu', 'Phòng ngủ căn A (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-c-phong-khach', 'Phòng khách căn C 64,9 m² (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-c-bep', 'Bếp căn C (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-c-phong-ngu-master', 'Phòng ngủ master căn C (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-c-phong-ngu-tre-em', 'Phòng ngủ trẻ em căn C (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-d-phong-khach', 'Phòng khách căn D Dual Key 97,7 m² (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-d-phong-an', 'Phòng ăn căn D Dual Key (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-d-phong-ngu-master', 'Phòng ngủ master căn D (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-d-can-nho', 'Căn nhỏ tách riêng của căn D Dual Key (phối cảnh nội thất)', 'thư viện' ),
			$im( 'layout-can-a-67-2m2', 'Layout 3D căn A 2PN 2WC 67,2 m²', 'layout', 'Căn A 2PN 67,2 m²' ),
			$im( 'layout-can-b-63-3m2', 'Layout 3D căn B 2PN 2WC 63,3 m²', 'layout', 'Căn B 2PN 63,3 m²' ),
			$im( 'layout-can-c-64-9m2', 'Layout 3D căn C 2PN 2WC 64,9 m²', 'layout', 'Căn C 2PN 64,9 m²' ),
			$im( 'layout-can-d-dual-key-97-7m2', 'Layout 3D căn D 3PN Dual Key 97,7 m²', 'layout', 'Căn D Dual Key 97,7 m²' ),
			$im( 'layout-duplex-e-tang-duoi', 'Layout 3D căn duplex E tầng dưới', 'layout', 'Duplex E – tầng dưới' ),
			$im( 'layout-duplex-e-tang-tren', 'Layout 3D căn duplex E tầng trên', 'layout', 'Duplex E – tầng trên' ),
			$im( 'layout-duplex-g-tang-duoi', 'Layout 3D căn duplex G tầng dưới', 'layout', 'Duplex G – tầng dưới' ),
			$im( 'layout-duplex-g-tang-tren', 'Layout 3D căn duplex G tầng trên', 'layout', 'Duplex G – tầng trên' ),
			$im( 'mat-bang-tang-ham-tang-1', 'Mặt bằng tầng hầm và tầng 1 MIA Center Point', 'mặt bằng', 'Tầng hầm, tầng 1' ),
			$im( 'mat-bang-tang-2-3', 'Mặt bằng tầng 2 – 3: để xe máy, dịch vụ', 'mặt bằng', 'Tầng 2 – 3' ),
			$im( 'mat-bang-tang-4', 'Mặt bằng tầng 4: để xe ô tô', 'mặt bằng', 'Tầng 4' ),
			$im( 'mat-bang-tang-5-20', 'Mặt bằng căn hộ điển hình tầng 5 – 20 (17 căn/tầng)', 'mặt bằng', 'Tầng 5 – 20' ),
			$im( 'mat-bang-tang-21-23', 'Mặt bằng căn hộ tầng 21 – 23 (16 căn/tầng)', 'mặt bằng', 'Tầng 21 – 23' ),
			$im( 'mat-bang-tang-24', 'Mặt bằng căn hộ tầng 24, có căn duplex', 'mặt bằng', 'Tầng 24' ),
			$im( 'mat-bang-tang-25', 'Mặt bằng tầng 25: căn duplex và hồ bơi', 'mặt bằng', 'Tầng 25' ),
			$im( 'mat-bang-tang-mai', 'Mặt bằng tầng mái MIA Center Point', 'mặt bằng', 'Tầng mái' ),
			$im( 'tien-do-3-2025-nhin-tu-tren-cao', 'Ảnh thực tế tháng 3/2025: công trình MIA Center Point nhìn từ trên cao', 'tiến độ', 'Thực tế 3/2025' ),
			$im( 'tien-do-3-2025-tong-the', 'Ảnh thực tế tháng 3/2025: công trình giữa khu Hòa Khánh Bắc', 'tiến độ', 'Thực tế 3/2025' ),
			$im( 'tien-do-8-2025-toa-thap-ban-dem', 'Ảnh thực tế tháng 8/2025: tòa nhà lên tầng cao, trước khi cất nóc', 'tiến độ', 'Thực tế 8/2025' ),
			$im( 'tien-do-8-2025-ban-dem-nhin-thanh-pho', 'Ảnh thực tế tháng 8/2025: từ công trình nhìn ra Liên Chiểu về đêm', 'tiến độ', 'Thực tế 8/2025' ),
		);

		$projects[] = array(
			'slug'    => 'mia-center-point-da-nang',
			'title'   => 'MIA Center Point (Mia Plaza)',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'lien-chieu',
			'excerpt' => 'MIA Center Point – tòa căn hộ 25 tầng, 335 căn tại 61 Ngô Thì Nhậm (Hòa Khánh Bắc, Liên Chiểu), sở hữu lâu dài, căn 2PN 63 – 67 m² giá tham khảo khoảng 3 – 3,5 tỷ, bàn giao nội thất.',
			'meta'    => array(
				'hh_p_status'       => 'dang-mo-ban',
				'hh_p_developer'    => 'Công ty Cổ phần Đầu tư MIA (MIA Invest)',
				'hh_p_builder'      => 'Tổng thầu Tracodi',
				'hh_p_designer'     => 'Inconarch và Tư vấn xây dựng Tín An',
				'hh_p_type'         => 'Căn hộ chung cư 2PN, 3PN Dual Key, duplex, penthouse',
				'hh_p_address'      => '61 Ngô Thì Nhậm, phường Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng',
				'hh_p_map_address'  => '61 Ngô Thì Nhậm, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng',
				'hh_p_scale'        => 'Khu đất 2.639,7 m², tổng sàn xây dựng 38.030,6 m², cao 89,9 m',
				'hh_p_density'      => '60%',
				'hh_p_blocks'       => '1 tòa căn hộ',
				'hh_p_floors'       => '25 tầng nổi, 1 tầng hầm (tầng hầm – tầng 4 là khối đế dịch vụ và để xe)',
				'hh_p_units'        => '335 căn hộ, 167 căn đã được Sở Xây dựng xác nhận đủ điều kiện bán (10/2025); 17 căn/tầng ở tầng 5 – 20, 16 căn/tầng ở tầng 21 – 23, 15 căn/tầng ở tầng 24 – 25)',
				'hh_p_unit_area'    => '63,3 – 259,5 m² (căn 2PN tiêu chuẩn 63,3 – 67,2 m²)',
				'hh_p_price_m2'     => 'Khoảng 47,7 – 57,1 triệu/m² thông thủy, gồm VAT, chưa gồm 2% phí bảo trì (giỏ hàng 1/2026, tham khảo)',
				'hh_p_price_from'   => 3018,
				'hh_p_price_table'  => "Căn 2PN 2WC (căn B) | 63,3 m² | Khoảng 3,02 – 3,36 tỷ | Tầng 7 – 24\nCăn 2PN 2WC (căn C) | 64,9 m² | Khoảng 3,46 tỷ | Tầng 24\nCăn 3PN Dual Key (căn D) | 97,7 m² | Khoảng 5,04 tỷ | Tầng 21 – 22\nCăn duplex | 138,9 m² | Khoảng 7,93 tỷ | Tầng 24 – 25\nĐơn giá | – | Khoảng 47,7 – 57,1 triệu/m² | Giỏ hàng 1/2026, gồm VAT, chưa gồm 2% phí bảo trì",
				'hh_p_price_example' => 'Căn 2PN 64,9 m² tầng 24 | 3,46 tỷ | 3,32 tỷ | Thanh toán sớm 95%: chiết khấu 4% trên giá trước VAT (phiếu tính giá 4/2026, tham khảo)',
				'hh_p_policy'       => "Chính sách theo phiếu tính giá của chủ đầu tư tháng 4/2026 (tham khảo – hỏi Hoàng Hiệp chính sách hiện hành):\nThanh toán sớm 95%: chiết khấu 4% căn 2PN, 3PN; 3% căn duplex (tính trên giá trước VAT)\nThanh toán tiêu chuẩn: đặt cọc 100 triệu, thanh toán theo 4 đợt đến khi nhận sổ\nGiá đã gồm VAT, chưa gồm 2% kinh phí bảo trì",
				'hh_p_payment'      => "Đặt cọc | 100 triệu/căn | Khi ký xác nhận nhu cầu\nĐợt 1 | 30% | Trong 10 ngày, ký hợp đồng mua bán\nĐợt 2 | 40% | Trong 60 ngày từ khi ký HĐMB\nĐợt 3 | 25% | Trong 7 ngày từ thông báo bàn giao căn hộ (kèm 2% phí bảo trì)\nĐợt 4 | 5% | Khi chủ đầu tư thông báo bàn giao sổ\nHoặc thanh toán sớm | 95% | Trong 20 ngày từ khi ký xác nhận nhu cầu (chiết khấu 3 – 4%)",
				'hh_p_legal'        => "Giấy phép xây dựng số 11/GPXD ngày 12/6/2024 của Sở Xây dựng Đà Nẵng (công trình cấp I, 1 tầng hầm + 25 tầng)\nĐất ở, sở hữu lâu dài\nNgân hàng bảo lãnh nghĩa vụ tài chính của chủ đầu tư: Nam A Bank\nSở Xây dựng xác nhận 167 căn đủ điều kiện bán nhà ở hình thành trong tương lai (danh sách công bố 10/2025)\nTháng 12/2025 cơ quan chuyên môn xác định lại giá đất cụ thể do quy hoạch điều chỉnh (theo báo chí); chủ đầu tư cho biết đã hoàn thành nghĩa vụ tài chính về đất\nNếu dự án đang thế chấp, chủ đầu tư phải giải chấp trước khi ký hợp đồng mua bán – nên kiểm tra khi giao dịch",
				'hh_p_ownership'    => 'Sở hữu lâu dài',
				'hh_p_start'        => 'Hoàn thành móng 15/10/2024',
				'hh_p_handover'     => 'Dự kiến Quý 2/2026 theo tài liệu chủ đầu tư (một số tin rao ghi bàn giao từ 8/2026 – hỏi Hoàng Hiệp tình trạng bàn giao hiện tại)',
				'hh_p_handover_std' => 'Bàn giao nội thất: sàn gỗ công nghiệp An Cường/Formica, tủ bếp An Cường/KES, bếp từ đôi và máy hút mùi Sunhouse/Electrolux, thiết bị vệ sinh TOTO/Bravat/Clara/Rhenwear, bồn cầu thông minh phòng master, khóa vân tay Kin Long/Kaadas, nhôm Xingfa, kính Việt Nhật hoặc tương đương',
				'hh_p_highlights'   => "Căn 2PN 2WC 63 – 67 m², giá tham khảo khoảng 3 – 3,5 tỷ, sở hữu lâu dài\n100% căn có 2 mặt thoáng, 2 lô gia trở lên; phòng khách và bếp đều thông lô gia\nCăn hộ từ tầng 5 (cao từ 18 m trở lên), view thoáng ra núi và vịnh Đà Nẵng\nHồ bơi trên cao tầng 25 (bể người lớn và bể trẻ em), nhà trẻ ngay tầng 1\n6 thang máy (4 thang cư dân, 2 thang hàng), 2 thang nâng ô tô, cửa chống ngập hầm\nTrong bán kính khoảng 1 km: MM Mega Market, chợ Hòa Khánh, Đại học Bách khoa",
				'hh_p_design_desc'  => 'Tòa nhà cao 89,9 m: tầng hầm đến tầng 4 là khối đế dịch vụ và để xe (khoảng 4.931 m² đỗ xe: ô tô ở hầm và tầng 4, xe máy ở tầng 2 – 3); tầng 1 có sảnh đón, khu sinh hoạt cộng đồng, nhà trẻ và sân chơi. Căn hộ từ tầng 5 đến tầng 25; tầng 24 – 25 có căn duplex và penthouse, hồ bơi ở tầng 25. Khoảng 95% sản phẩm là căn 2PN tiêu chuẩn 63,3 – 67,2 m², còn lại là 8 căn Dual Key 97,7 m² và các căn duplex, penthouse.',
				'hh_p_unit_types'   => "Căn A 2PN 2WC (căn góc) | 67,2 m² | 2 | Liên hệ\nCăn B 2PN 2WC | 63,3 m² | 2 | Khoảng 3,02 – 3,36 tỷ (tham khảo)\nCăn C 2PN 2WC | 64,9 m² | 2 | Khoảng 3,46 tỷ (tham khảo)\nCăn D 3PN Dual Key | 97,7 m² | 3 | Khoảng 5,04 tỷ (tham khảo)\nDuplex E, G | 138 – 138,9 m² | 3 | Khoảng 7,93 tỷ (tham khảo)\nDuplex F, penthouse P | 215,2 – 259,5 m² | – | Liên hệ",
				'hh_p_location_desc' => 'MIA Center Point nằm trên đường Ngô Thì Nhậm (lộ giới 20,5 m), phường Hòa Khánh Bắc, Liên Chiểu – khu dân cư đông đúc gần các trường đại học và khu công nghiệp. Trong bán kính khoảng 1 km có MM Mega Market, công viên, chợ Hòa Khánh, Đại học Bách khoa Đà Nẵng và quảng trường biển Nguyễn Tất Thành.',
				'hh_p_connections'  => "Khoảng 1 km | MM Mega Market, chợ Hòa Khánh\nKhoảng 1 km | Đại học Bách khoa Đà Nẵng\nKhoảng 1 km | Quảng trường biển Nguyễn Tất Thành",
				'hh_p_amenities_in' => "Hồ bơi trên cao tầng 25: bể người lớn và bể trẻ em\nNhà trẻ và sân chơi trẻ em tầng 1\nKhu sinh hoạt cộng đồng, sảnh lễ tân, khu vui chơi – thể thao\nCafe, mini mart, gym khối đế\n4 tầng để xe (hầm, tầng 2 – 4), 2 thang nâng ô tô, cửa chống ngập hầm\nCamera 24/24, thẻ thang máy, khóa thông minh, nút SOS, hạ tầng sạc xe điện",
				'hh_p_amenities_out' => "MM Mega Market, chợ Hòa Khánh\nĐại học Bách khoa Đà Nẵng và các trường đại học khu Hòa Khánh\nBiển Nguyễn Tất Thành, quảng trường biển",
				'hh_p_progress'     => "15/10/2024 | Hoàn thành móng\n01/2025 | Đổ sàn tầng 5\n04/2025 | Đổ sàn tầng 10\n06/2025 | Đổ sàn tầng 18\n07/2025 | Đổ sàn tầng 20\n10/2025 | Sở Xây dựng công bố 167 căn đủ điều kiện bán\n09/2025 | Cất nóc (theo kế hoạch chủ đầu tư)\nQuý 2/2026 | Bàn giao dự kiến",
				'hh_p_kpbt'         => 2,
				'hh_p_image_links'  => implode( "\n", $imgs ),
			),
			'content' => '<p><strong>MIA Center Point</strong> là tòa căn hộ 25 tầng của Công ty Cổ phần Đầu tư MIA tại 61 Ngô Thì Nhậm, phường Hòa Khánh Bắc, Liên Chiểu. Dự án có 335 căn hộ, sở hữu lâu dài, khoảng 95% là căn 2 phòng ngủ 2 WC diện tích 63,3 – 67,2 m² – phù hợp gia đình trẻ, giảng viên, kỹ sư làm việc ở khu Hòa Khánh và nhà đầu tư cho thuê.</p>
<h2>Giá căn hộ MIA Center Point</h2>
<p>Theo giỏ hàng tháng 1/2026 của chủ đầu tư, căn 2PN 63,3 – 64,9 m² có giá khoảng 3,02 – 3,46 tỷ, căn 3PN Dual Key 97,7 m² khoảng 5,04 tỷ, căn duplex 138,9 m² khoảng 7,93 tỷ (đơn giá khoảng 47,7 – 57,1 triệu/m² gồm VAT, chưa gồm 2% phí bảo trì). Đây là giá tham khảo, giỏ hàng thay đổi theo thời điểm.</p>
<h2>Thiết kế căn hộ</h2>
<ul>
<li>Căn tiêu chuẩn A, B, C (2PN 2WC) 63,3 – 67,2 m²: phòng khách và bếp đều thông lô gia, 2 mặt thoáng.</li>
<li>Căn D Dual Key 97,7 m² (8 căn): tách được thành 2 căn riêng, vừa ở vừa cho thuê.</li>
<li>Căn duplex và penthouse ở tầng 24 – 25: 138 – 259,5 m².</li>
</ul>
<h2>Tiện ích</h2>
<p>Hồ bơi trên cao tầng 25, nhà trẻ và sân chơi tầng 1, khu sinh hoạt cộng đồng, 6 thang máy, 4 tầng để xe với 2 thang nâng ô tô và cửa chống ngập hầm. Căn hộ bàn giao nội thất: sàn gỗ, tủ bếp, bếp từ, máy hút mùi, thiết bị vệ sinh, khóa vân tay.</p>
<h2>Pháp lý &amp; tiến độ</h2>
<p>Dự án có giấy phép xây dựng số 11/GPXD ngày 12/6/2024 của Sở Xây dựng Đà Nẵng, Nam A Bank bảo lãnh, tổng thầu Tracodi. Tháng 10/2025, Sở Xây dựng công bố 167 căn đủ điều kiện bán nhà ở hình thành trong tương lai; tháng 12/2025 thành phố xác định lại giá đất cụ thể do quy hoạch điều chỉnh. Khi giao dịch, người mua nên kiểm tra việc giải chấp (nếu dự án đang thế chấp) trước khi ký hợp đồng. Công trình hoàn thành móng tháng 10/2024, đổ sàn tầng 20 tháng 7/2025; chủ đầu tư dự kiến bàn giao Quý 2/2026.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận giỏ hàng, mặt bằng và chính sách mới nhất của MIA Center Point.</p>',
			'sources' => array(
				'https://tienphong.vn/cong-bo-bang-danh-sach-10-du-an-du-dieu-kien-ban-nha-o-tai-da-nang-post1786144.html',
				'https://thanhtra.com.vn/nha-dat-57A4B2310/da-nang-xac-dinh-lai-gia-dat-du-an-can-ho-mia-plaza-fd59ff480.html',
				'https://cafeland.vn/tin-tuc/giua-con-sot-gia-nha-tai-da-nang-mia-center-point-giu-muc-gia-hap-dan-du-kien-cat-noc-vao-quy-32025-142254.html',
			),
		);
		// Trang đã tạo 26/10/2026 từ du-an-tong-hop.json (cùng slug): ô nào còn đúng bản cũ thì thay bằng bản mới.
		$new = &$projects[ count( $projects ) - 1 ];
		if ( function_exists( 'hh_du_an_tong_hop' ) ) {
			foreach ( hh_du_an_tong_hop()['projects'] as $j ) {
				if ( 'mia-center-point-da-nang' !== ( $j['slug'] ?? '' ) ) {
					continue;
				}
				foreach ( (array) ( $j['meta'] ?? array() ) as $k => $v ) {
					if ( '' !== (string) $v && isset( $new['meta'][ $k ] ) && (string) $new['meta'][ $k ] !== (string) $v ) {
						$new['fix_meta'][ $k ][] = (string) $v;
					}
				}
				$new['fix_content'] = array( (string) ( $j['content'] ?? '' ) );
				$new['fix_excerpt'] = (string) ( $j['excerpt'] ?? '' );
				$new['fix_title']   = array( (string) ( $j['title'] ?? '' ) );
			}
		}
		unset( $new );
		return $projects;
	},
	20 // Trước data-du-an-tong-hop.php (30) – bản JSON cùng slug sẽ không tạo trùng.
);

/**
 * Bản 2.20.221 lỡ tạo trang trùng "mia-center-point": chuyển ảnh đã tải sang trang chính "mia-center-point-da-nang"
 * (chỉ điền ô ảnh còn trống) rồi đưa trang trùng vào thùng rác. Chạy 1 lần khi mở trang quản trị.
 */
add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_mia_gop_trang_v1' ) ) {
			return;
		}
		$dup  = get_page_by_path( 'mia-center-point', OBJECT, 'du-an' );
		$main = get_page_by_path( 'mia-center-point-da-nang', OBJECT, 'du-an' );
		if ( ! $dup ) {
			update_option( 'hh_mia_gop_trang_v1', '1', false );
			return;
		}
		if ( ! $main ) {
			return; // Chờ "Nhập / cập nhật dữ liệu" tạo trang chính.
		}
		foreach ( array( 'hh_p_gallery', 'hh_p_amenities_img', 'hh_p_floorplans', 'hh_p_unit_layouts', 'hh_p_masterplan_img', 'hh_p_progress_gallery', 'hh_p_location_img', '_thumbnail_id' ) as $k ) {
			$v = get_post_meta( $dup->ID, $k, true );
			if ( $v && ! get_post_meta( $main->ID, $k, true ) ) {
				update_post_meta( $main->ID, $k, $v );
			}
		}
		$links = (array) get_post_meta( $dup->ID, '_hh_img_links', true );
		if ( $links ) {
			update_post_meta( $main->ID, '_hh_img_links', array_merge( $links, (array) get_post_meta( $main->ID, '_hh_img_links', true ) ) );
		}
		wp_trash_post( $dup->ID );
		update_option( 'hh_mia_gop_trang_v1', '1', false );
	}
);
