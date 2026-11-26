<?php
/**
 * S-Light Tower – cập nhật theo thư mục tài liệu anh Hiệp gửi 26/11/2026: CSBH 01/SL (09/07/2026) + phiếu tính giá
 * tháng 11/2026 (căn 1PN+ 49,3 m² thông thủy) và mức thanh toán sớm tháng 12/2026 (chủ đầu tư thông báo 25/11).
 * Giá "chỉ từ" theo giá niêm yết thấp nhất trong phiếu (gồm VAT & KPBT, trước chiết khấu); không ghi mã căn.
 * Chạy sau bộ lọc thanh toán sớm tháng 12 (ưu tiên 99).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 's-light-tower' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$m   = $p['meta'] ?? array();
			$set = static function ( $key, $val ) use ( &$projects, $i, $m, $p ) {
				$cur = $m[ $key ] ?? '';
				if ( $cur === $val ) {
					return;
				}
				$projects[ $i ]['meta'][ $key ] = $val;
				$old = array_filter( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), is_string( $cur ) && '' !== $cur ? array( $cur ) : array() ) );
				if ( $old ) {
					$projects[ $i ]['fix_meta'][ $key ] = array_values( array_unique( $old ) );
				}
			};

			$set( 'hh_p_price_from', '3011' );
			$set( 'hh_p_price_hint', 'Căn 1PN+ 49,3 m² (thông thủy) niêm yết khoảng 3,01 – 3,20 tỷ, đã gồm VAT và phí bảo trì, trước chiết khấu (phiếu tính giá 11/2026, tham khảo). Studio, 2PN, 3PN: liên hệ.' );
			$set( 'hh_p_offer_title', 'Thanh toán sớm 95% chiết khấu 9,5% – hạn 25/12/2026' );
			$set( 'hh_p_offer_note', 'Cộng dồn với Early Bird 3% và chiết khấu không vay 3%. Ví dụ căn 1PN+ 49,3 m² niêm yết 3,20 tỷ: thanh toán sớm 95% còn khoảng 2,73 tỷ; thanh toán sớm 70% khoảng 2,94 tỷ; không vay theo tiến độ khoảng 3,01 tỷ; vay ngân hàng khoảng 3,11 tỷ (đã gồm VAT, phí bảo trì – Hoàng Hiệp tự tính theo phiếu tính giá, chưa phải phiếu chính thức).' );
			$set( 'hh_p_handover', 'Nhận nhà sử dụng dự kiến 30/06/2028 (Sun Early Key – thanh toán tối thiểu 70%)' );

			$ut = (string) ( $m['hh_p_unit_types'] ?? '' );
			if ( false !== strpos( $ut, "Căn 1PN+ | – | 1 | Liên hệ" ) ) {
				$set( 'hh_p_unit_types', str_replace( "Căn 1PN+ | – | 1 | Liên hệ", "Căn 1PN+ | 49,3 m² | 1 | Chỉ từ khoảng 3,01 tỷ", $ut ) );
			}

			$pol = (string) ( $projects[ $i ]['meta']['hh_p_policy'] ?? '' );
			$pol = str_replace( 'Early Bird 3% (có thời hạn – hỏi còn áp dụng không)', 'Early Bird 3% (vẫn có trong phiếu tính giá 11/2026 – có thời hạn)', $pol );
			if ( false === strpos( $pol, 'không áp dụng cùng gói hỗ trợ lãi suất' ) ) {
				$pol = str_replace( 'Thông tin tham khảo 12/2026', "Ưu đãi thanh toán sớm 95% / 70% không áp dụng cùng gói hỗ trợ lãi suất · Nhận nhà sử dụng dự kiến 30/06/2028\nThông tin tham khảo 12/2026", $pol );
			}
			$set( 'hh_p_policy', $pol );

			$set(
				'hh_p_discount_table',
				"Thanh toán sớm 95% | Trước 25/12/2026 | ≈ 14,8% | Early Bird 3% → không vay 3% → thanh toán sớm 9,5% (trừ nối tiếp trên giá chưa VAT & phí bảo trì)\n" .
				"Thanh toán sớm 70% – nhận nhà rồi trả phần còn lại theo tiến độ | Trước 25/12/2026 | ≈ 8,3% | Early Bird 3% → không vay 3% → thanh toán sớm 2,5%\n" .
				"Tiến độ chuẩn, không vay – giãn đến 48 tháng | Theo tiến độ | ≈ 5,9% | Early Bird 3% → không vay 3%\n" .
				"Vay ngân hàng tối đa 70%, hỗ trợ lãi suất 24 tháng | Theo tiến độ | 3% | Early Bird 3%"
			);
		}
		return $projects;
	},
	100
);
