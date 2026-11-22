<?php
/**
 * Euro Village 2 Hòa Xuân – giỏ hàng đất biệt thự chuyển nhượng Hoàng Hiệp cập nhật 22/11/2026 (thay bản 26/10/2026).
 * Theo quy tắc giá 16/11/2026: chỉ đăng con số thấp nhất ("chỉ từ"), giá từng lô ghi "Liên hệ". Không số điện thoại người rao, không số lô đầy đủ.
 * Số lô ghi dạng "1x, 4x…" (không ghi số lô đầy đủ). Chỉ thay khi ô trên web vẫn là giá trị web nhập (chưa sửa tay).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$old_2610 = array(
			'hh_p_resale_price' => 'Đất biệt thự chào bán khoảng 83 – 105 triệu/m² (giỏ hàng 26/10/2026, tham khảo)',
			'hh_p_villa_desc'   => 'Giỏ hàng đất biệt thự chuyển nhượng Euro Village 2 do Hoàng Hiệp tổng hợp ngày 26/10/2026: giá chào bán, có lô thương lượng. Lô view sông, view kênh, view công viên và lô góc giá cao hơn lô thường. Ngoài danh sách còn vài lô kín diện tích lớn – liên hệ để nhận thông tin.',
			'hh_p_villa_table'  => implode(
				"\n",
				array(
					'Khu B2.8 – lô 2x, view sông | – | Đất biệt thự | Khoảng 100 triệu/m²',
					'Khu B2.11 – lô góc | 438 m² | Đất biệt thự | Khoảng 92 triệu/m²',
					'Khu B2.11 – lô 3x, kẹp vệt, hướng Đông Bắc | 312,5 m² | Đất biệt thự | Khoảng 90 triệu/m²',
					'Khu B2.11 – lô 4x, Giáng Hương 8, view công viên | 312,5 m² | Đất biệt thự | Khoảng 90 triệu/m²',
					'Khu B2.15 – lô 1x, Giáng Hương 7, view công viên | 300 m² | Đất biệt thự | Khoảng 89 triệu/m² (thương lượng)',
					'Khu B2.17 – lô 2x, lưng kênh | – | Đất biệt thự | Khoảng 89 triệu/m²',
					'Khu B2.16 – lô 4x, Giáng Hương 3, hướng Đông Nam | – | Đất biệt thự | Khoảng 87 triệu/m²',
					'Khu B2.12 – lô 2x, view kênh, Giáng Hương 2 | – | Đất biệt thự | 8x triệu/m² – liên hệ',
					'Khu B2.13 – lô 1x, Giáng Hương 10, hướng Tây Nam | 300 m² | Đất biệt thự | Khoảng 25 tỷ (~83 triệu/m²)',
					'Cặp lô B2.8 – view sông | – | Cặp đất biệt thự | Khoảng 105 triệu/m²',
					'Cặp lô B2.17 – lưng kênh | – | Cặp đất biệt thự | Khoảng 95 triệu/m²',
					'Cặp lô B2.11 – trục thông Giáng Hương 2 | – | Cặp đất biệt thự | Khoảng 90 triệu/m²',
					'Cặp lô B2.13 – Giáng Hương 10 | 600 m² | Cặp đất biệt thự | 8x triệu/m² – liên hệ',
					'Cặp góc B2.21 – vị trí đẹp | 670 m² | Cặp đất biệt thự góc | Giá tốt – liên hệ',
					'Một số lô kín, diện tích lớn | – | Đất biệt thự | Liên hệ',
				)
			),
		);
		$new = array(
			'hh_p_resale_price' => 'Đất biệt thự chào bán chỉ từ khoảng 80 triệu/m² (lô 300 m² khoảng 24 tỷ) – giỏ hàng 22/11/2026, giá tham khảo; lô view sông, view kênh, lô góc giá cao hơn – liên hệ Hoàng Hiệp nhận giá từng lô',
			'hh_p_villa_desc'   => 'Giỏ hàng đất biệt thự chuyển nhượng Euro Village 2 do Hoàng Hiệp cập nhật ngày 22/11/2026: khoảng 14 lô và cặp lô, có lô thương lượng. Giá chào bán chỉ từ khoảng 80 triệu/m²; lô view sông, view kênh, view công viên và lô góc giá cao hơn lô thường. Ngoài danh sách còn vài lô kín diện tích lớn – liên hệ để nhận giá từng lô.',
			'hh_p_villa_table'  => implode(
				"\n",
				array(
					'Khu B2.13 – lô 2x, Giáng Hương 10, hướng Tây Nam | 300 m² | Đất biệt thự | Chỉ từ khoảng 24 tỷ',
					'Khu B2.8 – lô 2x, view sông | – | Đất biệt thự | Liên hệ',
					'Khu B2.11 – lô góc | 438 m² | Đất biệt thự | Liên hệ',
					'Khu B2.11 – lô 3x, kẹp vệt, hướng Đông Bắc | 312,5 m² | Đất biệt thự | Liên hệ',
					'Khu B2.11 – lô 4x, Giáng Hương 8, view công viên | 312,5 m² | Đất biệt thự | Liên hệ',
					'Khu B2.15 – lô 1x, Giáng Hương 7, view công viên | 300 m² | Đất biệt thự | Liên hệ (thương lượng)',
					'Khu B2.17 – lô 2x, lưng kênh | – | Đất biệt thự | Liên hệ',
					'Khu B2.16 – lô 4x, Giáng Hương 3, hướng Đông Nam | – | Đất biệt thự | Liên hệ',
					'Khu B2.12 – lô 2x, view kênh, Giáng Hương 2 | – | Đất biệt thự | Liên hệ',
					'Cặp lô B2.8 – view sông | – | Cặp đất biệt thự | Liên hệ',
					'Cặp lô B2.17 – lưng kênh | – | Cặp đất biệt thự | Liên hệ',
					'Cặp lô B2.11 – trục thông Giáng Hương 2 | – | Cặp đất biệt thự | Liên hệ',
					'Cặp lô B2.13 – Giáng Hương 10 | 600 m² | Cặp đất biệt thự | Liên hệ',
					'Cặp góc B2.21 – vị trí đẹp | 670 m² | Cặp đất biệt thự góc | Liên hệ',
					'Một số lô kín, diện tích lớn | – | Đất biệt thự | Liên hệ',
				)
			),
		);
		foreach ( $projects as &$p ) {
			if ( 'euro-village-2' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$p['fix_meta'] = (array) ( $p['fix_meta'] ?? array() );
			foreach ( $new as $k => $v ) {
				$old = (string) ( $p['meta'][ $k ] ?? '' );
				$allow = array_filter( array( $old, $old_2610[ $k ] ?? '' ) ); // Bản trước + giỏ hàng 26/10 web đã nhập.
				$allow = array_values( array_diff( array_unique( $allow ), array( $v ) ) );
				if ( $allow ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), $allow );
				}
				$p['meta'][ $k ] = $v;
			}
		}
		unset( $p );
		return $projects;
	},
	96
);
