<?php
/**
 * Giá giỏ hàng tháng 10/2026 – NewTown Diamond (tòa R The Ruby, S The Sapphire, D The Diamond) và Capital Square
 * (C1 The Times, C4 The Queens, C6 The Kings, C7 Victory, S4 Hudson Place). Nguồn: bảng hàng đại lý gửi ekip (Google Sheets,
 * Excel). Chỉ ghi khoảng giá theo tòa / loại căn – không đăng mã căn, tên đơn vị, tài khoản ngân hàng trong bảng hàng.
 * NewTown: chỉ tính căn còn hàng (bỏ căn tô đỏ đã bán, vàng lock, xanh khóa). Capital Square: giá các căn có trong bảng (chưa lọc trạng thái).
 * Giá gồm VAT & kinh phí bảo trì, chưa trừ chiết khấu / quà tặng. Số liệu do Hoàng Hiệp tổng hợp, có thể thay đổi theo từng đợt.
 * Trang nào anh đã sửa tay ô giá thì giữ nguyên (fix_meta chỉ thay khi ô vẫn là bản cũ do web nhập).
 */

defined( 'ABSPATH' ) || exit;

function hh_gio_hang_10_2026() {
	$note = 'Giỏ hàng 10/2026, gồm VAT & KPBT, chưa chiết khấu';
	return array(
		'newtown-the-ruby'            => array(
			'hh_p_price_from'  => 3520,
			'hh_p_price_m2'    => 'Khoảng 73 – 97 triệu/m² thông thủy (gồm VAT & KPBT, giỏ hàng 10/2026)',
			'hh_p_unit_types'  => "Căn 1PN | 44,9 – 47,9 m² | 1 | Khoảng 3,52 – 4,45 tỷ\nCăn 2PN | 73,3 – 84,1 m² | 2 | Khoảng 5,64 – 7,03 tỷ\nCăn 3PN | 88,1 – 98,4 m² | 3 | Khoảng 7,22 – 9,18 tỷ",
			'hh_p_price_table' => "Căn 1PN (bàn giao thô) | 44,9 – 47,9 m² | 3,52 – 4,45 tỷ | {$note}\nCăn 2PN (hoàn thiện) | 73,3 – 84,1 m² | 5,64 – 7,03 tỷ | Khoảng 77 – 85 triệu/m²\nCăn 3PN (thô / hoàn thiện) | 88,1 – 98,4 m² | 7,22 – 9,18 tỷ | Hướng Đông Bắc cao hơn Tây Nam",
		),
		'newtown-the-sapphire'        => array(
			'hh_p_price_from'  => 5740,
			'hh_p_price_m2'    => 'Khoảng 69 – 92 triệu/m² thông thủy (gồm VAT & KPBT, giỏ hàng 10/2026)',
			'hh_p_unit_types'  => "Căn 2PN | 79,1 – 83,6 m² | 2 | Khoảng 5,74 – 6,97 tỷ\nCăn 3PN | 94,5 – 95,4 m² | 3 | Khoảng 6,90 – 8,76 tỷ",
			'hh_p_price_table' => "Căn 2PN (hoàn thiện Demi) | 79,1 – 83,6 m² | 5,74 – 6,97 tỷ | {$note}\nCăn 3PN (thô / hoàn thiện Demi) | 94,5 – 95,4 m² | 6,90 – 8,76 tỷ | Hướng Đông Bắc cao hơn Tây Nam",
		),
		'newtown-the-diamond'         => array(
			'hh_p_price_from'  => 5470,
			'hh_p_price_m2'    => 'Khoảng 80 – 120 triệu/m² thông thủy (gồm VAT & KPBT, giỏ hàng 10/2026)',
			'hh_p_unit_types'  => "Căn 1PN+1 | 68,1 m² | 1 + phòng đa năng | Khoảng 5,47 – 6,27 tỷ\nCăn 2PN | 78,2 – 94,4 m² | 2 | Khoảng 6,55 – 8,33 tỷ\nCăn 3PN | 100,8 – 131,5 m² | 3 | Khoảng 9,20 – 14,03 tỷ",
			'hh_p_price_table' => "Căn 1PN+1 (thô) | 68,1 m² | 5,47 – 6,27 tỷ | {$note}\nCăn 2PN (thô) | 78,2 – 94,4 m² | 6,55 – 8,33 tỷ | Khoảng 83 – 88 triệu/m²\nCăn 3PN (thô) | 100,8 – 131,5 m² | 9,20 – 14,03 tỷ | Khoảng 90 – 120 triệu/m²",
		),
		'newtown-diamond-da-nang'     => array(
			'hh_p_price_from'  => 3520,
			'hh_p_unit_types'  => "Căn 1PN | 44,9 – 47,9 m² | 1 | Khoảng 3,52 – 4,45 tỷ (The Ruby)\nCăn 1PN+1 | 68,1 m² | 1 + phòng đa năng | Khoảng 5,47 – 6,27 tỷ (The Diamond)\nCăn 2PN | 73,3 – 94,4 m² | 2 | Khoảng 5,64 – 8,33 tỷ\nCăn 3PN | 88,1 – 131,5 m² | 3 | Khoảng 6,90 – 14,03 tỷ",
			'hh_p_price_table' => "The Ruby – 1PN, 2PN, 3PN | 44,9 – 98,4 m² | 3,52 – 9,18 tỷ | {$note}\nThe Sapphire – 2PN, 3PN | 79,1 – 95,4 m² | 5,74 – 8,76 tỷ | Khoảng 69 – 92 triệu/m²\nThe Diamond – 1PN+1, 2PN, 3PN | 68,1 – 131,5 m² | 5,47 – 14,03 tỷ | Khoảng 80 – 120 triệu/m²",
		),
		'capital-square-hudson-place-s4' => array(
			'hh_p_price_from'  => 4320,
			'hh_p_price_m2'    => 'Khoảng 92 – 146 triệu/m² thông thủy tùy tầng, hướng (gồm VAT & KPBT, giỏ hàng 10/2026)',
			'hh_p_unit_types'  => "Căn 1PN | 46,33 – 47,17 m² | 1 | Khoảng 4,32 – 4,91 tỷ\nCăn 2PN (2 logia) | 72,00 – 74,31 m² | 2 | Khoảng 6,61 – 10,58 tỷ\nCăn 3PN | 91,29 – 91,40 m² | 3 | Khoảng 10,16 – 13,32 tỷ\nCăn 3PN dualkey (2PN + studio) | 101,00 – 101,62 m² | 3 | Khoảng 9,33 – 13,41 tỷ",
			'hh_p_price_table' => "Căn 1PN | 46,3 – 47,2 m² | 4,32 – 4,91 tỷ | {$note}\nCăn 2PN | 72,0 – 74,3 m² | 6,61 – 10,58 tỷ | Hướng Nam view sông Hàn, cầu Rồng cao nhất\nCăn 3PN, 3PN dualkey | 91,3 – 101,6 m² | 9,33 – 13,41 tỷ | Tầng 7 – 22\nThanh toán | – | Vay 0%, thanh toán sớm có chiết khấu | Hỏi Hoàng Hiệp mức chiết khấu từng phương án",
		),
		'capital-square-da-nang'      => array(
			'hh_p_price_from'  => 4320,
			'hh_p_unit_types'  => "Căn 1PN | 45 – 47 m² | 1 | Khoảng 4,3 – 5,1 tỷ\nCăn 2PN | 61,6 – 81 m² | 2 | Khoảng 6,2 – 10,6 tỷ\nCăn 2PN+1 | 77,7 – 84,6 m² | 2 + phòng đa năng | Khoảng 7,3 – 10,8 tỷ\nCăn 3PN | 91,3 – 120 m² | 3 | Khoảng 9,3 – 13,9 tỷ",
			'hh_p_price_table' => "C6 The Kings | 45 – 104 m² | 5,08 – 13,11 tỷ | 2PN từ 6,29 tỷ, 2PN+1 từ 7,27 tỷ, 3PN từ 10,27 tỷ\nC7 Victory | 45 – 104 m² | 4,77 – 13,32 tỷ | Căn trực diện biển, căn góc 3PN 12,6 – 13,3 tỷ\nS4 Hudson Place | 46 – 102 m² | 4,32 – 13,41 tỷ | View sông Hàn, cầu Rồng\nC1 The Times | 66 – 120 m² | 6,53 – 12,21 tỷ | Tầng 20 – 24\nC4 The Queens | 69 – 113 m² | 7,07 – 13,93 tỷ | Tầng 22 – 26\nGhi chú | – | {$note} | Giá theo tầng, hướng – hỏi Hoàng Hiệp căn cụ thể",
		),
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$prices = hh_gio_hang_10_2026();
		foreach ( $projects as &$p ) {
			$set = $prices[ $p['slug'] ?? '' ] ?? null;
			if ( ! $set ) {
				continue;
			}
			$p['fix_meta'] = (array) ( $p['fix_meta'] ?? array() );
			foreach ( $set as $k => $v ) {
				// Giá cũ do web nhập (thường ghi "Liên hệ") → thay bằng giá giỏ hàng; ô trống thì web tự điền.
				if ( isset( $p['meta'][ $k ] ) && '' !== (string) $p['meta'][ $k ] && $p['meta'][ $k ] !== $v ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( (string) $p['meta'][ $k ] ) );
				}
				$p['meta'][ $k ] = $v;
			}
		}
		unset( $p );
		return $projects;
	},
	95
);
