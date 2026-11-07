<?php
/**
 * The Legend Đà Nẵng – cập nhật 11/2026 từ bộ tài liệu dự án anh Hiệp gửi (Drive):
 * CSBH của chủ đầu tư ban hành 17/7/2025 (áp dụng đến khi có chính sách thay thế), giỏ hàng tham khảo 64 căn,
 * bảng vật liệu bàn giao, công văn Sở Xây dựng 674/SXD-QLN ngày 19/3/2025 (đủ điều kiện huy động vốn),
 * 13 phối cảnh (đã cắt bỏ mã QR cá nhân ở góc ảnh) và 2 ảnh flycam công trường 6/2025.
 * Không đăng mã căn, tên/số điện thoại người đăng, mặt bằng có logo đơn vị phân phối, hợp đồng, tài liệu đào tạo.
 * Thay ô cũ nếu web chưa sửa tay; mô tả ngắn chỉ thay khi còn đúng bản cũ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/the-legend/the-legend-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'toan-canh-hoang-hon-song-han-cau-rong', 'The Legend Đà Nẵng lúc hoàng hôn – hai tòa tháp bên sông Hàn, ngay chân cầu Rồng', 'đại diện' ),
			$im( 'hai-toa-thap-ben-cau-rong', 'Hai tòa tháp The Legend bên cầu Rồng, nhìn dọc sông Hàn', 'thư viện' ),
			$im( 'ban-cong-nhin-cau-rong-song-han', 'Ban công căn hộ nhìn thẳng cầu Rồng và sông Hàn', 'thư viện' ),
			$im( 'dem-phao-hoa-song-han', 'Đêm pháo hoa sông Hàn nhìn từ vườn mái The Legend', 'thư viện' ),
			$im( 'toan-canh-dem-trung-tam-da-nang', 'The Legend về đêm giữa trung tâm Đà Nẵng, cầu Rồng rực sáng', 'thư viện' ),
			$im( 'vuon-mai-nhin-ve-bien-my-khe', 'Vườn mái trên cao nhìn về biển Mỹ Khê và bán đảo Sơn Trà', 'thư viện' ),
			$im( 'cau-rong-va-du-an-nhin-ra-bien', 'Cầu Rồng và The Legend, phía xa là biển Mỹ Khê', 'thư viện' ),
			$im( 'hai-toa-thap-truc-vo-van-kiet', 'Hai tòa tháp trên trục Võ Văn Kiệt lúc chiều muộn', 'thư viện' ),
			$im( 'toa-thap-goc-nhin-tu-duong', 'Tòa tháp The Legend nhìn từ góc đường', 'thư viện' ),
			$im( 'khoi-de-thuong-mai-mat-tien-vo-van-kiet', 'Khối đế thương mại mặt tiền Võ Văn Kiệt, hướng cầu Rồng', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'khoi-de-ve-dem', 'Khối đế thương mại lên đèn về đêm', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'mat-dung-khoi-de-ban-ngay', 'Mặt đứng khối đế và sảnh hai tòa tháp', 'tiện ích', 'Sảnh và khối đế' ),
			$im( 'vi-tri-chan-cau-rong-tu-tren-cao', 'Vị trí The Legend ngay chân cầu Rồng, nhìn từ trên cao', 'tổng thể' ),
			$im( 'tien-do-6-2025-flycam-cong-truong', 'Công trường The Legend tháng 6/2025 – flycam nhìn về sông Hàn', 'tiến độ', 'Thực tế 6/2025' ),
			$im( 'tien-do-6-2025-thi-cong-tang-ham', 'Thi công tầng hầm The Legend tháng 6/2025, mặt tiền Võ Văn Kiệt', 'tiến độ', 'Thực tế 6/2025' ),
		);
		$new = array(
			'hh_p_type'         => 'Căn hộ sở hữu lâu dài, penthouse duplex, khách sạn & căn hộ dịch vụ',
			'hh_p_address'      => 'Lô A20 Võ Văn Kiệt, An Hải Tây, Sơn Trà, Đà Nẵng – ngay chân cầu Rồng',
			'hh_p_scale'        => '11.487 m² đất (khoảng 1,2 ha), 4 mặt tiền',
			'hh_p_blocks'       => '2 tòa tháp: tháp căn hộ và tháp khách sạn',
			'hh_p_floors'       => 'Tháp căn hộ 29 tầng nổi, tháp khách sạn 25 tầng nổi, 3 tầng hầm chung',
			'hh_p_units'        => '800 căn hộ sở hữu lâu dài; 444 phòng khách sạn & căn hộ dịch vụ (50 năm)',
			'hh_p_unit_area'    => '40 – 415 m²',
			'hh_p_ownership'    => 'Căn hộ: sở hữu lâu dài. Khách sạn và căn hộ dịch vụ: 50 năm',
			'hh_p_handover'     => 'Dự kiến quý I/2028',
			'hh_p_price_from'   => 7650,
			'hh_p_offer_title'  => 'Tặng nội thất đến 1,8 tỷ – chiết khấu đến 12%',
			'hh_p_highlights'   => "Ngay chân cầu Rồng – mở cửa là sông Hàn, đêm cuối tuần xem rồng phun lửa từ ban công\n4 mặt tiền Võ Văn Kiệt – Ngô Quyền – Mai Hắc Đế – Lý Nam Đế, khoảng 1 km ra biển Mỹ Khê\nCăn hộ sở hữu lâu dài trên lô đất đấu giá A20 bên bờ sông Hàn\nMùa pháo hoa quốc tế DIFF ngắm từ vườn mái và ban công hướng sông\nBàn giao chuẩn cao cấp: sàn gỗ kỹ thuật châu Âu, thiết bị bếp Teka/Smeg, vệ sinh Bagnodesign/Axent, smarthome\nTặng gói nội thất 300 triệu – 1,8 tỷ, miễn phí quản lý 24 tháng",
			'hh_p_design_desc'  => 'Có những buổi chiều ở Đà Nẵng mà người ta chỉ muốn đứng yên: nắng rót vàng mặt sông Hàn, cầu Rồng uốn mình ngay dưới chân, xa xa biển Mỹ Khê và bán đảo Sơn Trà chuyển màu tím. The Legend được đặt đúng vào khung cảnh ấy – lô đất A20 đấu giá ngay đầu cầu Rồng, hai tòa tháp với những đường cong ban công gợi sóng nước, khối đế thương mại sáng đèn mỗi tối. Đây không chỉ là một căn hộ, mà là chỗ ngồi hàng đầu để ngắm thành phố lớn lên mỗi ngày.',
			'hh_p_zones'        => "Tháp căn hộ – cánh Legacy | Căn 1PN, 1PN+1, 2PN, 3PN | Phía sông Hàn | Tầng 5 – 26\nTháp căn hộ – cánh Infinity | Căn 1PN, 1PN+1, 2PN, 3PN | Phía biển Mỹ Khê | Tầng 5 – 26\nPenthouse duplex | 8 căn 256 – 415 m² | Tầng 27 trở lên | Hồ bơi, vườn riêng\nTháp khách sạn 25 tầng | 222 phòng khách sạn, 222 căn hộ dịch vụ | Thời hạn 50 năm | Vận hành theo chuẩn khách sạn\nKhối đế | Thương mại, nhà hàng, tiện ích | 4 mặt tiền | Mở cho cư dân và khách",
			'hh_p_unit_types'   => "Căn 1PN | 40 – 60 m² | 1 | 308 căn\nCăn 1PN+1 | 58 – 63 m² | 1 + phòng đa năng | 88 căn\nCăn 2PN | 73 – 85 m² | 2 | 308 căn\nCăn 3PN | 112 – 117 m² | 3 | 88 căn\nPenthouse duplex | 256 – 415 m² | 3 – 4 | 8 căn",
			'hh_p_price_table'  => "1PN | 54,4 – 60,3 m² | 7,65 – 9,59 tỷ | Giỏ hàng tầng 6 – 25, giá gồm VAT và kinh phí bảo trì, chưa trừ ưu đãi\n1PN+1 (góc) | 58,4 m² | 9,39 – 10,97 tỷ | Giỏ hàng tầng 6 – 25, giá gồm VAT và kinh phí bảo trì, chưa trừ ưu đãi\n2PN | 74,9 – 84,5 m² | 8,96 – 14,60 tỷ | Giỏ hàng tầng 6 – 25, giá gồm VAT và kinh phí bảo trì, chưa trừ ưu đãi\n3PN (góc) | 114,1 – 114,2 m² | 16,83 – 18,98 tỷ | Giỏ hàng tầng 6 – 25, giá gồm VAT và kinh phí bảo trì, chưa trừ ưu đãi",
			'hh_p_price_example' => 'Căn 2PN 84,5 m² tầng cao | 14,59 tỷ | 13,61 tỷ | Đã trừ quà nội thất 500 triệu và chiết khấu 3% (thanh toán theo tiến độ). Giá gồm VAT và kinh phí bảo trì; thanh toán sớm 95% chiết khấu đến 12% còn thấp hơn nữa.',
			'hh_p_policy'       => "Chính sách chủ đầu tư ban hành 17/7/2025, áp dụng đến khi có chính sách thay thế:\nThanh toán sớm 95%: chiết khấu 12%\nThanh toán sớm 95% linh hoạt: chiết khấu 9%\nThanh toán sớm 70%: chiết khấu 8%\nThanh toán sớm 50%: chiết khấu 6%\nThanh toán theo tiến độ: chiết khấu 3%\nTặng gói nội thất trừ thẳng vào giá: 1PN 300 triệu, 2PN 500 triệu, 3PN 700 triệu, penthouse 1,8 tỷ\nVay ngân hàng MSB, Vietcombank, MB: hỗ trợ lãi suất 0% trong 24 tháng\nNgân hàng cho vay đến 70% giá trị căn hộ\nMiễn phí quản lý vận hành 24 tháng từ khi nhận nhà\nKhông yêu cầu bảo lãnh ngân hàng: chiết khấu thêm 1%\n\"Chạm sớm biểu tượng\" cho 200 khách đầu tiên: ưu đãi thêm 1% (hỏi Hoàng Hiệp số suất còn lại)\nTrả từng đợt sớm hơn hạn: chiết khấu 6,5%/năm trên số tiền trả trước\nGiữ chỗ chỉ 200 triệu đồng/căn\nChính sách có thể đã điều chỉnh theo từng đợt mở bán – nhắn Hoàng Hiệp để nhận bản mới nhất và phiếu tính giá từng căn.",
			'hh_p_payment'      => "Giữ chỗ | 200 triệu/căn | Ký thỏa thuận giữ chỗ\nKý HĐ nguyên tắc | 10% (gồm tiền giữ chỗ) | Trong 15 ngày từ ngày giữ chỗ\nĐợt 2 | 15% | Trong 90 ngày từ ngày ký HĐ nguyên tắc\nKý HĐ mua bán | Bổ sung đủ 30% | Theo thông báo của chủ đầu tư\nĐợt tiếp theo | 5%/đợt, mỗi 30 ngày (7 đợt) | Từ ngày ký HĐ mua bán\nCất nóc | 5% | Dự kiến 31/12/2026\nNhận nhà | 25% + kinh phí bảo trì | Dự kiến 31/3/2028\nNhận sổ | 5% | Khi bàn giao giấy chứng nhận",
			'hh_p_loan'         => 'Vay đến 70% giá trị căn hộ (gồm VAT) tại MSB, Vietcombank hoặc MB; chủ đầu tư hỗ trợ lãi suất 0% trong 24 tháng; ân hạn nợ gốc 36 tháng (MSB) hoặc 24 tháng (Vietcombank, MB). Khách thanh toán tối thiểu 25% bằng vốn tự có trước khi ngân hàng giải ngân. Sau thời gian hỗ trợ, lãi suất theo ngân hàng từng thời điểm.',
			'hh_p_loan_ratio'   => '70',
			'hh_p_loan_zero_months' => '24',
			'hh_p_loan_grace'   => 'đến 36 tháng',
			'hh_p_loan_bank'    => 'MSB, Vietcombank, MB',
			'hh_p_legal'        => "Quyết định 4105/QĐ-UBND ngày 28/7/2017 công nhận kết quả đấu giá khu đất A20 Võ Văn Kiệt\nGiấy chứng nhận quyền sử dụng đất do UBND TP Đà Nẵng cấp ngày 25/9/2020\nQuy hoạch chi tiết 1/500 phê duyệt theo Quyết định 2941/QĐ-UBND ngày 24/5/2024\nGiấy chứng nhận đăng ký đầu tư điều chỉnh lần 1 ngày 15/7/2024\nGiấy phép xây dựng phần ngầm (3 tầng hầm) số 07/GPXD ngày 14/02/2025\nCông văn 674/SXD-QLN ngày 19/3/2025 của Sở Xây dựng Đà Nẵng: dự án đủ điều kiện huy động vốn\nCăn hộ sở hữu lâu dài",
			'hh_p_handover_std' => 'Bàn giao hoàn thiện cao cấp, tích hợp smarthome: sàn phòng khách, ăn, ngủ gỗ kỹ thuật sồi châu Âu dày 12 mm (Pergo, Imondi, Kronoswiss); gạch vệ sinh, bếp, logia nhập khẩu Florim, Porcelanosa, Vietceramic; cửa chính gỗ chống cháy EI30, khóa thông minh Igloohome/Yale; trần thạch cao Vĩnh Tường, sơn Jotun/TOA; cửa kính, lan can nhôm Xingfa kính dán an toàn; điều hòa Multi âm trần nối ống gió Daikin/Mitsubishi; đèn Philips, công tắc ổ cắm Legrand/Schneider màu gold kết nối smarthome, chuông hình camera IP; bếp: mặt đá Vicostone/Caesarstone, tủ Fomica/AICA, bếp từ 3 vùng, hút mùi, máy rửa bát Teka/Smeg; vệ sinh: bồn cầu treo, sen vòi Bagnodesign/Axent, bồn tắm cho căn 3PN, bình nóng lạnh Ariston/Ferroli; tủ quần áo phòng ngủ phụ kiện Hafele/Blum.',
			'hh_p_progress'     => "28/2/2025 | Khởi công\nTháng 6/2025 | Thi công tầng hầm (ảnh flycam thực tế)\nTháng 10/2025 | Hoàn thành khoảng 70% dầm, sàn, cột, vách hầm B2; thi công đào hầm B3\n31/12/2026 | Cất nóc (dự kiến theo chính sách bán hàng)\nQuý IV/2027 | Hoàn thành (dự kiến)\n31/3/2028 | Bàn giao căn hộ (dự kiến)",
		);
		// Bản chính sách đã nhập ở 2.20.215 (chữ liền, con số chìm) → thay bằng bản mỗi ưu đãi một dòng.
		$old_table  = "Căn 1PN | 54,4 – 60,3 m² | 7,65 – 9,59 tỷ | Tầng 6 – 25\nCăn 1PN+1 | 58,4 m² (căn góc) | 9,39 – 10,97 tỷ | Tầng 6 – 25\nCăn 2PN | 74,9 – 84,5 m² | 8,96 – 14,60 tỷ | Tầng 6 – 25\nCăn 3PN góc | 114,1 – 114,2 m² | 16,83 – 18,98 tỷ | Tầng 12 – 25\nVí dụ 2PN 84,5 m² tầng cao | – | Giá 14,59 tỷ → khoảng 13,61 tỷ | Sau quà nội thất 500 triệu và chiết khấu 3% (thanh toán chuẩn)\nGhi chú | – | Giỏ hàng tham khảo, giá gồm VAT và kinh phí bảo trì | Chưa trừ quà nội thất, chiết khấu thanh toán sớm (đến 12%)";
		$old_policy = "Chính sách của chủ đầu tư (ban hành 17/7/2025, áp dụng đến khi có chính sách thay thế):\n• Giữ chỗ 200 triệu đồng/căn\n• Tặng gói nội thất trừ thẳng vào giá: 1PN / 1PN+1: 300 triệu – 2PN: 500 triệu – 3PN: 700 triệu – penthouse tầng 27: 1,8 tỷ\n• Miễn phí phí quản lý vận hành 24 tháng từ khi nhận nhà\n• Thanh toán theo tiến độ: chiết khấu 3%\n• Thanh toán sớm 50%: chiết khấu 6% – sớm 70%: 8% – sớm 95%: 12% – sớm 95% linh hoạt: 9%\n• Thanh toán từng đợt sớm hơn hạn: chiết khấu thêm 6,5%/năm trên số tiền trả trước\n• Không yêu cầu bảo lãnh ngân hàng: chiết khấu thêm 1%\n• Ưu đãi \"Chạm sớm biểu tượng\": 1% cho 200 khách đầu tiên (hỏi Hoàng Hiệp số suất còn lại)\n• Vay đến 70%, hỗ trợ lãi suất 0% trong 24 tháng (MSB, Vietcombank, MB)\nChính sách có thể đã điều chỉnh theo từng đợt mở bán – nhắn Hoàng Hiệp để nhận bản mới nhất và phiếu tính giá từng căn.";
		foreach ( $projects as $i => $p ) {
			if ( 'the-legend-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( '' !== $cur && $cur !== (string) $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				$p['meta'][ $k ] = $v;
			}
			$p['fix_meta']['hh_p_policy'][] = $old_policy;
			$p['fix_meta']['hh_p_price_table'][] = $old_table;
			$p['fix_excerpt'] = $p['excerpt'] ?? '';
			$p['excerpt']     = 'Căn hộ sở hữu lâu dài ngay chân cầu Rồng, mở cửa là sông Hàn: 2 tòa tháp 29 và 25 tầng, 800 căn hộ 1PN – 3PN và 8 penthouse duplex, tặng nội thất đến 1,8 tỷ, vay 70% hỗ trợ lãi suất 0% 24 tháng. Bàn giao dự kiến quý I/2028.';
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $cur;
			$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	98
);
