<?php
/**
 * The Filmore Đà Nẵng – cập nhật theo bộ tài liệu dự án anh Hiệp gửi 17/11/2026 (mặt bằng tầng 3 – 24 của chủ đầu tư):
 * cơ cấu căn theo tầng, căn ghép 3PN (1PN+2PN, 2PN+2PN), loft, 4 căn penthouse thông tầng; đặt cọc 100 triệu/căn.
 * Không đăng: bảng giá / CSBH cũ (2024), hợp đồng mẫu, pháp lý, tài liệu đào tạo, nội dung chuyển khoản đặt cọc.
 * Giá chỉ hiện mức thấp nhất (anh Hiệp 16/11/2026). Chạy sau data-filmore.php (20).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'the-filmore-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old = $p['meta'];
			$upd = array(
				'hh_p_units'           => '206 căn hộ hạng sang (4 căn penthouse)',
				'hh_p_unit_area'       => '1PN 48 – 51 m², 2PN 66 – 80 m², 3PN ghép 126,5 – 152,6 m², penthouse 218,8 – 269,1 m² (diện tích tim tường)',
				'hh_p_design_desc'     => 'Theo mặt bằng tầng của chủ đầu tư: tầng 3 – 8 mỗi tầng 11 căn (1PN 47,3 – 47,8 m², 2PN 66,6 – 71,1 m² thông thủy); từ tầng 9 trở lên mỗi tầng 9 căn (1PN 45,7 – 47,1 m², 2PN 62,1 – 76,3 m² thông thủy). Tầng 14 – 20 có căn ghép 3 phòng ngủ: 1PN + 2PN 126,5 m² (thông thủy 120 m²) và 2PN + 2PN 152,6 m² (thông thủy 144,8 m²). Tầng 21 – 22 có căn loft thông tầng 122,6 m²; tầng 21 – 24 có 4 căn penthouse thông tầng 218,8 – 269,1 m² (thông thủy 206,4 – 254 m²).',
				'hh_p_unit_types'      => "Căn 2PN view vịnh – núi Sơn Trà | 75,5 m² (thông thủy 71,3 – 71,5 m²) | 2 | Chỉ từ 9,89 tỷ (chưa VAT)\nCăn góc 2PN view sông Hàn – biển | 74,8 m² (thông thủy 71,1 m²) | 2 | Liên hệ\nCăn 3PN ghép (2PN + 2PN) view sông – biển | 152,6 m² (thông thủy 144,8 m²) | 3 | Liên hệ\nPenthouse thông tầng view sông – biển | 218,8 m² (thông thủy 206,4 m²) | – | Liên hệ",
				'hh_p_penthouse_desc'  => '4 căn penthouse thông tầng trên các tầng 21 – 24, diện tích tim tường 218,8 – 269,1 m² (thông thủy 206,4 – 254 m²), tầm nhìn toàn cảnh sông Hàn, cầu Rồng và biển Mỹ Khê.',
				'hh_p_penthouse_table' => "Penthouse thông tầng (4 căn) | 218,8 – 269,1 m² | – | Liên hệ",
			);
			$upd['hh_p_price_m2']   = 'Từ khoảng 131 triệu/m² (giỏ hàng 11/2026, chưa VAT)';
			$upd['hh_p_price_from'] = 9889; // Giỏ hàng tồn 01/11/2026: căn thấp nhất 2PN 75,5 m² – 9,89 tỷ chưa VAT (1PN đã hết).
			$upd['hh_p_payment']    = "Đặt cọc | 100 triệu/căn | Không hoàn lại\nThanh toán nhanh – đợt 1 | 10% | Ký hợp đồng đặt cọc trong 7 ngày kể từ ngày đặt cọc\nThanh toán nhanh – đợt 2 | 85% + 2% phí bảo trì | Ký hợp đồng mua bán trong 30 ngày kể từ hạn đợt 1, bàn giao căn hộ (chiết khấu 6%)\nThanh toán nhanh – đợt cuối | 5% | Khi nhận giấy chứng nhận quyền sở hữu\nVay VPBank – đợt 1 | 10% | Ký hợp đồng đặt cọc trong 7 ngày kể từ ngày đặt cọc\nVay VPBank – đợt 2 | Khách 15% + 2% phí bảo trì, ngân hàng giải ngân 70% | Ký hợp đồng mua bán trong 30 ngày; ngân hàng giải ngân trong 45 ngày kể từ hạn đợt 1\nVay VPBank – đợt cuối | Ngân hàng 5% | Khi nhận giấy chứng nhận quyền sở hữu";
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$fix['hh_p_unit_types'] = array( 'Căn 1PN | 48,1 – 51,3 m² | 1 | Chỉ từ khoảng 5,5 tỷ' . "\n" . 'Căn 2PN | 66,4 – 80,5 m² | 2 | Liên hệ' . "\n" . 'Căn 3PN ghép (1PN + 2PN) | 126,5 m² | 3 | Liên hệ' . "\n" . 'Căn 3PN ghép (2PN + 2PN) | 152,6 m² | 3 | Liên hệ' . "\n" . 'Căn loft thông tầng | 122,6 m² | – | Liên hệ' );
			$fix['hh_p_price_from'] = array( 5500, '5500' );
			$fix['hh_p_unit_types'][] = str_replace( '152,6 m² | 3 |', '152,6 m² | 4 |', $fix['hh_p_unit_types'][0] ); // Bản thử nội bộ.
			$fix['hh_p_policy']       = array( "Thanh toán nhanh: chiết khấu 6%\nVay ngân hàng VPBank: chủ đầu tư hỗ trợ lãi suất 8 tháng, tối đa 10%/năm\nMiễn phí quản lý 1 năm\nĐặt cọc giữ căn 100 triệu đồng/căn\nLiên hệ Hoàng Hiệp – 0904 567 009 để nhận bảng giá và đặt lịch xem căn hộ thực tế" ); // Bản 2.20.311.
			$fix['hh_p_offer_title']  = array( 'Chính sách mới: chiết khấu 6% khi thanh toán nhanh, hỗ trợ lãi suất 8 tháng khi vay VPBank, miễn phí quản lý 1 năm' );
			$fix['hh_p_highlights']   = array();
			foreach ( $upd as $k => $v ) {
				if ( isset( $old[ $k ] ) && $old[ $k ] !== $v ) {
					$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( $old[ $k ] ) ); // Chỉ thay khi trên web còn giá trị cũ.
				}
			}
			// Chính sách mới nhất của chủ đầu tư (anh Hiệp gửi 17/11/2026).
			$pol_v1 = "Đặt cọc giữ căn 100 triệu đồng/căn\nLiên hệ Hoàng Hiệp – 0904 567 009 để nhận chính sách bán hàng và bảng giá căn đang mở bán";
			$upd['hh_p_policy']      = "Chính sách chủ đầu tư áp dụng từ 01/11/2026 đến khi có thông báo khác\nThanh toán nhanh: chiết khấu 6%\nVay ngân hàng VPBank: chủ đầu tư hỗ trợ lãi suất 8 tháng kể từ ngày giải ngân theo lịch (lãi suất tối đa 10%/năm), khách thanh toán 25% + 2% phí bảo trì\nMiễn phí quản lý 1 năm (30.000 đồng/m², chưa VAT)\nĐặt cọc giữ căn 100 triệu đồng/căn\nLiên hệ Hoàng Hiệp – 0904 567 009 để nhận bảng giá và đặt lịch xem căn hộ thực tế";
			$upd['hh_p_offer_title'] = 'Giỏ hàng tháng 11/2026 chỉ còn 5 căn – 2PN chỉ từ 9,89 tỷ; chiết khấu 6% khi thanh toán nhanh, hỗ trợ lãi suất 8 tháng khi vay VPBank';
			$upd['hh_p_highlights']  = "Căn góc 2 phòng ngủ view trực diện sông Hàn, ban công hướng sông\nKính Low-E kịch trần mở rộng tầm nhìn\nNgay phố đi bộ Bạch Đằng, kết nối tiện ích trung tâm Hải Châu\nHoàn thiện cao cấp, hệ tiện ích Wellness by Well-tech\nChỉ 206 căn – mật độ cư dân thấp; tổng thầu Delta, quản lý vận hành CBRE\nĐã hoàn thiện, nhận nhà ở ngay, sổ hồng sở hữu lâu dài";
			$fix['hh_p_policy']      = array_merge( (array) ( $fix['hh_p_policy'] ?? array() ), array_filter( array( $pol_v1, (string) ( $old['hh_p_policy'] ?? '' ) ) ) );
			foreach ( array( 'hh_p_offer_title', 'hh_p_highlights' ) as $k ) {
				if ( ! empty( $old[ $k ] ) ) {
					$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( $old[ $k ] ) );
				}
			}
			$links = (string) ( $old['hh_p_image_links'] ?? '' );
			$upd['hh_p_image_links'] = trim( $links . "\nhttps://drive.google.com/file/d/1vMBLpNIEltjrT175rYie4Jmr5SDXztF9/view | Phối cảnh Lounge Pavilion trên tầng thượng The Filmore Đà Nẵng (ảnh chủ đầu tư) | thư viện" );
			if ( '' !== $links ) {
				$fix['hh_p_image_links'] = array_merge( (array) ( $fix['hh_p_image_links'] ?? array() ), array( $links ) );
			}
			// Hỏi đáp, tiện ích, đơn vị thiết kế theo bộ câu hỏi thường gặp của chủ đầu tư (anh Hiệp gửi 18/11/2026; bỏ các mục đã cũ như tiến độ 2023).
			$upd['hh_p_designer']     = 'Kiến trúc Mercurio Lab (Ý), cảnh quan LandArch, nội thất ID Dept (Singapore), ánh sáng Lightbox (Singapore), nhận diện thương hiệu Landor (Mỹ)';
			$upd['hh_p_amenities_in'] = "Tầng trệt: sảnh lễ tân, khu thương mại – café, khu vui chơi trẻ em ngoài trời, phòng thư tín\nTầng 2: không gian sáng tạo cho trẻ em\nRooftop tầng 25: hồ bơi nhiệt vô cực khoảng 18 × 6 m và hồ bơi trẻ em\nRooftop: ghế tắm nắng, khu ngắm cảnh ngoài trời, phòng gym\nThư viện và không gian làm việc chung trên tầng thượng\nPhòng xông hơi tia hồng ngoại, phòng thay đồ, Nucalm\nKhu tổ chức tiệc trong nhà có bếp, khu BBQ ngoài trời\nAn ninh 24/7, lễ tân, quản lý tài sản và tiện ích";
			$upd['hh_p_duplex_table'] = 'Loft 3PN thông tầng (4 căn) | 122,6 m² | 3 | Liên hệ';
			$upd['hh_p_faq']          = implode(
				"\n",
				array(
					'Ai là chủ đầu tư The Filmore Đà Nẵng? | Công ty CP Phát triển Bất động sản Filmore (Filmore Development). Tổng thầu thi công kết cấu Delta, ngân hàng bảo lãnh MSB.',
					'Dự án có bao nhiêu căn hộ, bao nhiêu tầng? | 1 tòa 25 tầng nổi, 3 tầng hầm, 206 căn hộ. Tầng trệt và tầng 25 dành cho tiện ích; các căn tại tầng 9 có sân vườn.',
					'Trần căn hộ cao bao nhiêu? | Chiều cao từ sàn đến sàn căn hộ điển hình 3,35 m; căn loft 6 m.',
					'Căn hộ có ban công không? | Tất cả các căn đều có ban công hoặc lô gia, rộng 1,4 m (một số căn hướng Bắc 0,9 m), dài 3 – 4,4 m. Kính cửa sổ dày 13,52 mm, lan can kính 20 mm.',
					'Tòa nhà có bao nhiêu thang máy, chỗ đậu ô tô? | 4 thang máy (3 thang khách 1.000 kg, 1 thang hàng/PCCC 1.275 kg, tốc độ 2,5 m/s), 2 thang nâng ô tô, 63 chỗ đậu ô tô dưới 3 tầng hầm.',
					'Hồ bơi rộng bao nhiêu? | Hồ bơi người lớn khoảng 18 × 6 m, sâu 1,5 m; hồ bơi trẻ em khoảng 8 × 5 m, sâu 0,85 m – trên rooftop tầng 25.',
					'Phí quản lý bao nhiêu? | Khoảng 30.000 đồng/m²/tháng tính trên diện tích thông thủy. Điện nước do nhà cung cấp lập hóa đơn, cư dân tự thanh toán. Chính sách từ 01/11/2026 miễn phí quản lý 1 năm.',
					'Căn hộ sở hữu lâu dài hay 50 năm? | Người Việt Nam sở hữu lâu dài. Cá nhân nước ngoài sở hữu tối đa 50 năm kể từ ngày cấp giấy chứng nhận (được gia hạn theo luật); người nước ngoài được mua tối đa 30% số căn của dự án.',
					'Giá bán đã gồm tiền sử dụng đất chưa? | Giá bán đã gồm giá trị quyền sử dụng đất, chưa gồm VAT và 2% phí bảo trì.',
					'Bảo hành công trình bao lâu? | 24 tháng kể từ ngày nghiệm thu bàn giao; máy lạnh, thiết bị bếp và thiết bị khác bảo hành theo nhà sản xuất.',
					'Tòa nhà có chống động đất, máy phát điện dự phòng không? | Thiết kế chống động đất cấp VII (thang MSK-64) theo QCVN 02:2009/BXD, TCVN 9386:2012; có máy phát điện dự phòng cho khu công cộng và PCCC.',
				)
			);
			foreach ( array( 'hh_p_designer', 'hh_p_amenities_in', 'hh_p_duplex_table', 'hh_p_faq' ) as $k ) {
				if ( ! empty( $old[ $k ] ) ) {
					$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( $old[ $k ] ) );
				}
			}
			// Bài giới thiệu: bỏ giá cũ (1PN 5,5 – 6 tỷ… – 1PN đã hết), chỉ giữ giá thấp nhất hiện tại.
			$c0 = (string) ( $p['content'] ?? '' );
			$c1 = strtr(
				$c0,
				array(
					'<li>75 căn 1 phòng ngủ, 48 – 50 m², giá tham khảo khoảng 5,5 – 6 tỷ.</li>' => '<li>Căn 1 phòng ngủ 48 – 51 m² (đã bán hết trong giỏ hàng chủ đầu tư tháng 11/2026).</li>',
					'<li>106 căn 2 phòng ngủ, 71 – 81 m², khoảng 8,2 – 9,3 tỷ.</li>' => '<li>Căn 2 phòng ngủ 66 – 80 m² – giỏ hàng tháng 11/2026 chỉ từ 9,89 tỷ (chưa VAT).</li>',
					'Mức giá khoảng 130 – 150 triệu/m² thuộc nhóm cao nhất Đà Nẵng' => 'Đơn giá từ khoảng 131 triệu/m² (chưa VAT) thuộc nhóm cao nhất Đà Nẵng',
				)
			);
			if ( $c1 !== $c0 ) {
				$projects[ $i ]['content']     = $c1;
				$projects[ $i ]['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}
			$projects[ $i ]['meta']     = array_merge( $old, $upd );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	30
);
