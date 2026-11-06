<?php
/**
 * Sun Saphia Residence: mô hình 4D và công cụ chọn căn (ứng dụng riêng, lưu trong kho mã – projects/sun-saphia/).
 * Trên web: 4D xem tự do (bản công khai, có chữ chìm số điện thoại); "Chọn căn, xem chi tiết" hỏi số Zalo trước.
 * Link dán nguyên bản – giao diện tự bỏ tham số nội bộ (crm, k) và thêm pub=1 khi hiện cho khách.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== $p['slug'] ) {
				continue;
			}
			$p['meta'] += array(
				'hh_p_tour_4d'    => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/db77ab0f3df33e3f284972356c99e6ff658ca5d7/projects/sun-saphia/4d/sun-saphia-4d.html', // Bản 26/10/2026 (chiều): 4D trỏ công cụ chọn căn mới.
				'hh_p_tour_poster' => 'plugin:img/sun-saphia/sun-saphia-mo-hinh-4d-xem-truoc.jpg', // Ảnh chụp từ chính mô hình 4D.
				'hh_p_tour_units' => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/79e9fad50d4250d512aa23783767a3b30669b846/projects/sun-saphia/chon-can/chon-can-app.html',
				'hh_p_home_poster' => 'plugin:img/sun-saphia/sun-saphia-poster-trang-chu.jpg', // Poster anh Hiệp gửi 06/11/2026 – slide đầu trang chủ.
			);
			// Đổi link 4D cũ sang bản điện thoại (chỉ khi ô vẫn là link cũ do web nhập).
			$p['fix_meta'] = ( $p['fix_meta'] ?? array() ) + array( 'hh_p_tour_4d' => array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/e6e0970dcea56a7da0ceeddfd7fbedcc5f870a1c/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/958389ad9aeaa5dade1e26076db7fe00b6c0366c/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/a4125c9ea5215c30fb8feed85fe041b8ab21997e/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/352fddb9ce3faf2e3fd2cd009ba7e7e651583507/projects/sun-saphia/4d/sun-saphia-4d.html' ) );
			$p['fix_meta']['hh_p_tour_units'] = array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c361b624026a585531075b74aefde75ca4cfc756/projects/sun-saphia/chon-can/chon-can-app.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c0d1be39dc2a04c79e210554f2726774420ea5a0/projects/sun-saphia/chon-can/chon-can-app.html' );
			// Ảnh đại diện nét hơn (phối cảnh tòa tháp bên biển lúc hoàng hôn, không có chữ in sẵn) thay ảnh cũ bị mờ.
			$old_img = 'plugin:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg | Phối cảnh Sun Saphia Residence – căn hộ 30 tầng của Sun Group bên biển Sơn Thủy, Đà Nẵng | đại diện';
			$new_img = 'plugin:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg | Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên biển Sơn Thủy lúc hoàng hôn, Đà Nẵng | đại diện';
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$new   = str_replace( $old_img, $new_img, $links );
			// Mặt bằng từng tầng (tài liệu chủ đầu tư 10/2026, đã che mã căn).
			foreach ( array(
				'tang-2'               => 'Mặt bằng tầng 2 Sun Saphia Residence: bể bơi, gym & yoga và 12 căn hộ | mặt bằng | Tầng 2',
				'tang-3'               => 'Mặt bằng tầng 3 Sun Saphia Residence: 28 căn studio, 1PN+, 2PN | mặt bằng | Tầng 3',
				'tang-3a-28-dien-tich' => 'Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích từng căn | mặt bằng | Tầng 3A – 28',
				'tang-29'              => 'Mặt bằng tầng 29 Sun Saphia Residence: 26 căn hộ, vườn trên cao | mặt bằng | Tầng 29',
				'tang-30'              => 'Mặt bằng tầng 30 Sun Saphia Residence: 19 căn 1PN, 1PN+, 2PN | mặt bằng | Tầng 30',
			) as $f => $line ) {
				$row = 'plugin:img/sun-saphia/sun-saphia-mat-bang-' . $f . '.jpg | ' . $line;
				if ( false === strpos( $new, 'sun-saphia-mat-bang-' . $f . '.jpg' ) ) {
					$new .= "\n" . $row;
				}
			}
			if ( $new !== $links ) {
				$p['meta']['hh_p_image_links'] = $new;
				$olds                          = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$olds[]                        = $links; // Chỉ đổi khi ô ảnh vẫn là giá trị web nhập (chưa sửa tay).
				$olds[]                        = str_replace( $old_img, $new_img, $links ); // Bản đã đổi ảnh đại diện (2.20.82).
				$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( $olds ) );
			}
		}
		unset( $p );
		return $projects;
	},
	22
);

// 05/11/2026: 6 layout căn bản nét của chủ đầu tư (anh Hiệp gửi) thay 3 layout cũ bị mờ.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = array(
			'studio-30m2'     => 'Layout căn Studio Sun Saphia Residence – thông thủy 30 m², tim tường 43,88 m² | layout | Studio 30 m²',
			'studio-goc-40m2' => 'Layout căn Studio góc Sun Saphia Residence – thông thủy 40,03 m², tim tường 46,38 m² | layout | Studio góc 40 m²',
			'1pn-plus-51m2'   => 'Layout căn 1PN+ Sun Saphia Residence – thông thủy 51,11 m², tim tường 56,42 m² | layout | 1PN+ 51 m²',
			'2pn-61m2'        => 'Layout căn 2PN góc Sun Saphia Residence – thông thủy 61,14 m², tim tường 68,67 m² | layout | 2PN 61 m²',
			'2pn-67m2'        => 'Layout căn 2PN góc Sun Saphia Residence – thông thủy 67,69 m², tim tường 76,36 m² | layout | 2PN 67 m²',
			'2pn-70m2'        => 'Layout căn 2PN góc có lô gia rộng Sun Saphia Residence – thông thủy 70,21 m², tim tường 77,35 m² | layout | 2PN 70 m²',
		);
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' === $links || false !== strpos( $links, 'sun-saphia-layout-studio-30m2.jpg' ) ) {
				continue;
			}
			$kept = array_filter( explode( "\n", $links ), static fn( $l ) => ! preg_match( '/sun-saphia-layout-can-(studio|1pn-plus|2pn)\.jpg/', $l ) );
			foreach ( $new as $f => $line ) {
				$kept[] = 'plugin:img/sun-saphia/sun-saphia-layout-' . $f . '.jpg | ' . $line;
			}
			$p['meta']['hh_p_image_links']     = implode( "\n", $kept );
			$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links ) ) ) );
		}
		unset( $p );
		return $projects;
	},
	23 // Ngay sau bộ lọc 4D / mặt bằng tầng (22).
);

// 06/11/2026: ảnh đại diện mới – bộ phối cảnh 4K của chủ đầu tư (Drive "Sun Saphia Residence / Ảnh phối cảnh", anh Hiệp gửi):
// toàn cảnh từ trên cao lúc hoàng hôn làm ảnh đại diện; 4 ảnh còn lại vào Thư viện; ảnh đại diện cũ chuyển vào Thư viện.
// Chạy sau cùng (24) để ô ảnh đang có trên web (kết quả bộ lọc 23, hoặc bản 2.15.79–80 có ảnh 900 px) nằm trong danh sách được phép thay.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' === $links || false !== strpos( $links, 'sun-saphia-cdt-hoang-hon-bien-tren-cao.jpg' ) ) {
				continue;
			}
			$base = str_replace( ' | đại diện', ' | thư viện', $links );
			$l    = static fn( $f, $alt, $where, $t ) => "plugin:img/sun-saphia/sun-saphia-cdt-$f.jpg | $alt | $where | $t";
			$new  = array(
				$l( 'hoang-hon-bien-tren-cao', 'Sun Saphia Residence – toàn cảnh tòa tháp 30 tầng bên biển Sơn Thủy lúc hoàng hôn, phối cảnh chủ đầu tư', 'đại diện', 'Toàn cảnh lúc hoàng hôn' ),
				$l( 'dem-tren-cao-bien', 'Sun Saphia Residence về đêm nhìn từ trên cao, trục biển Võ Nguyên Giáp – Trường Sa, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh về đêm' ),
				$l( 'toa-thap-ngay', 'Tòa tháp Sun Saphia Residence 30 tầng ban ngày, phối cảnh chủ đầu tư', 'thư viện', 'Tòa tháp ban ngày' ),
				$l( 'toa-thap-dem', 'Tòa tháp Sun Saphia Residence lên đèn, phối cảnh chủ đầu tư', 'thư viện', 'Tòa tháp về đêm' ),
				$l( 'khoi-de-pho-bien', 'Khối đế thương mại Sun Saphia Residence mặt tiền trục biển, phối cảnh chủ đầu tư', 'tiện ích', 'Khối đế thương mại' ),
			);
			$p['meta']['hh_p_image_links'] = implode( "\n", $new ) . "\n" . $base;
			$was_900 = 'plugin:img/sun-saphia/sun-saphia-phoi-canh-hoang-hon-toan-canh.jpg | Sun Saphia Residence – tòa tháp 30 tầng của Sun Group bên biển Sơn Thủy lúc hoàng hôn, phối cảnh chủ đầu tư | đại diện | Toàn cảnh lúc hoàng hôn' . "\n" . $base;
			$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links, $was_900 ) ) ) );
		}
		unset( $p );
		return $projects;
	},
	24
);
