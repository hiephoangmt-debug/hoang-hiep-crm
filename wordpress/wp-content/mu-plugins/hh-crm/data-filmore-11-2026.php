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
			$projects[ $i ]['meta']     = array_merge( $old, $upd );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	30
);
