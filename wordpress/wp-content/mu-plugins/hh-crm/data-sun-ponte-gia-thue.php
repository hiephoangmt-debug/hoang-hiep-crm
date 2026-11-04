<?php
/**
 * Sun Ponte Residence – giá cho thuê theo bảng căn cho thuê anh Hiệp gửi 04/11/2026 (khoảng 40 căn).
 * Chỉ ghi khoảng giá theo loại căn – không ghi mã căn, tầng cụ thể. Thay giá thuê tổng hợp tin rao 10/2026 nếu web chưa sửa tay.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$rent = 'Studio 26 – 30 m²: 11 – 17 triệu/tháng · 1PN+ 49 – 50 m²: 18 – 27 triệu/tháng · 2PN 68 – 78 m²: 25 – 38 triệu/tháng · 2PN 91 m²: 45 – 50 triệu/tháng · 3PN 91 m²: khoảng 48 triệu/tháng (bảng giá cho thuê 11/2026, full nội thất, tham khảo)';
		$note = 'Giá chuyển nhượng tổng hợp từ tin rao công khai tháng 10/2026. Giá thuê theo bảng căn cho thuê tháng 11/2026 (khoảng 40 căn): tất cả bàn giao full nội thất, không nuôi thú cưng, thuê tối thiểu 3 tháng (một số studio nhận thuê từ 1 tháng). View gồm 100% sông Hàn, cầu Rồng, cầu Trần Thị Lý, biển và thành phố; khoảng 1/3 số căn trong bảng đã có khách thuê. Căn 3PN 102 m² và căn Dual 105 m² liên hệ giá. Giá thực tế phụ thuộc tầng, view, thời điểm – liên hệ Hoàng Hiệp để nhận danh sách căn đang trống.';
		foreach ( $projects as $i => $p ) {
			if ( 'sun-ponte-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_rent_price']  = $rent;
			$projects[ $i ]['meta']['hh_p_resale_note'] = $note;
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$fix['hh_p_rent_price']  = array_merge( (array) ( $fix['hh_p_rent_price'] ?? array() ), array( 'Studio khoảng 13 – 20 triệu/tháng; 1PN khoảng 20 – 30 triệu/tháng; 2PN khoảng 32 – 40 triệu/tháng' ) );
			$fix['hh_p_resale_note'] = array_merge( (array) ( $fix['hh_p_resale_note'] ?? array() ), array( 'Khoảng giá tổng hợp từ các tin rao bán, cho thuê công khai tháng 10/2026, chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc tầng, view, nội thất – liên hệ để nhận danh sách căn đang giao dịch thật.' ) );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	40 // Sau hh_dataset_gia_thi_truong (ưu tiên 30).
);
