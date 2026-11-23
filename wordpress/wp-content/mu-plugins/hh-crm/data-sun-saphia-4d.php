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
				'hh_p_tour_units' => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/9fd61b92616889f6e1f36418c5472ad4bfbd1bb2/projects/sun-saphia/chon-can/chon-can-app.html', // 17/11/2026: mặt bằng căn căn giữa, không tràn chữ.
				'hh_p_home_poster' => 'plugin:img/sun-saphia/sun-saphia-poster-trang-chu.jpg', // Poster anh Hiệp gửi 06/11/2026 – slide đầu trang chủ.
			);
			// Đổi link 4D cũ sang bản điện thoại (chỉ khi ô vẫn là link cũ do web nhập).
			$p['fix_meta'] = ( $p['fix_meta'] ?? array() ) + array( 'hh_p_tour_4d' => array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/e6e0970dcea56a7da0ceeddfd7fbedcc5f870a1c/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/958389ad9aeaa5dade1e26076db7fe00b6c0366c/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/a4125c9ea5215c30fb8feed85fe041b8ab21997e/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/352fddb9ce3faf2e3fd2cd009ba7e7e651583507/projects/sun-saphia/4d/sun-saphia-4d.html' ) );
			$p['fix_meta']['hh_p_tour_units'] = array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/79e9fad50d4250d512aa23783767a3b30669b846/projects/sun-saphia/chon-can/chon-can-app.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c361b624026a585531075b74aefde75ca4cfc756/projects/sun-saphia/chon-can/chon-can-app.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c0d1be39dc2a04c79e210554f2726774420ea5a0/projects/sun-saphia/chon-can/chon-can-app.html' );
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

// 22/11/2026: phối cảnh chủ đầu tư bản sạch (không chữ) – tòa tháp bên biển Sơn Thủy lúc hoàng hôn, hồ nước và khối thấp tầng (anh Hiệp gửi).
// Thêm vào Thư viện ngay sau 5 ảnh phối cảnh 4K; chỉ đổi khi ô ảnh vẫn là bản web đã nhập.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' === $links || false !== strpos( $links, 'sun-saphia-cdt-ven-bien-son-thuy-ho-nuoc.jpg' ) ) {
				continue;
			}
			$rows = explode( "\n", $links );
			array_splice( $rows, min( 5, count( $rows ) ), 0, array( 'plugin:img/sun-saphia/sun-saphia-cdt-ven-bien-son-thuy-ho-nuoc.jpg | Sun Saphia Residence bên bãi biển Sơn Thủy lúc hoàng hôn, phía trước là công viên ven biển và hồ nước – phối cảnh chủ đầu tư | thư viện | Bên biển Sơn Thủy lúc hoàng hôn' ) );
			$p['meta']['hh_p_image_links']     = implode( "\n", $rows );
			$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links ) ) ) );
		}
		unset( $p );
		return $projects;
	},
	25
);

// 22/11/2026: chủ đầu tư chính thức công bố Early Bird chiết khấu 3% và 938 booking tại sự kiện Radiance of Heritage (ảnh anh Hiệp chụp).
// Thêm khung ưu đãi + poster Early Bird của chủ đầu tư vào Thư viện. Chỉ thay ô còn đúng bản web đã nhập.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$upd = array(
				'hh_p_offer_title' => 'Early Bird chiết khấu 3% cho khách hàng tiên phong',
				'hh_p_offer_note'  => 'Sun Property chính thức công bố Early Bird 3% tại sự kiện Radiance of Heritage ở Đà Nẵng. Thời hạn và điều kiện áp dụng theo chính sách bán hàng của chủ đầu tư – liên hệ Hoàng Hiệp để kiểm tra booking của anh chị.',
				'hh_p_offer_stats' => "3% | Chiết khấu Early Bird\n938 | Booking chủ đầu tư công bố\n782 | Căn hộ của dự án\n05/12/2026 | Sự kiện bán hàng dự kiến",
			);
			foreach ( $upd as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( $cur === $v ) {
					continue;
				}
				if ( '' !== trim( $cur ) ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) );
				}
				$p['meta'][ $k ] = $v;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $links && false === strpos( $links, 'sun-saphia-early-bird-3-phan-tram-poster.jpg' ) ) {
				$rows = explode( "\n", $links );
				array_splice( $rows, min( 6, count( $rows ) ), 0, array( 'plugin:img/sun-saphia/sun-saphia-early-bird-3-phan-tram-poster.jpg | Sun Saphia Residence chính thức công bố Early Bird chiết khấu 3% – poster chủ đầu tư Sun Property | thư viện | Early Bird 3%' ) );
				$p['meta']['hh_p_image_links']     = implode( "\n", $rows );
				$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links ) ) ) );
			}
		}
		unset( $p );
		return $projects;
	},
	26
);

// 23/11/2026: ảnh chủ đầu tư mới (Drive "Sun Saphia Residence / Ảnh phối cảnh", anh Hiệp gửi): 5 phối cảnh tầm view theo tầng
// và 16 phối cảnh tiện ích (hồ bơi, gym, yoga, kid club). Thêm vào Thư viện / Tiện ích; chỉ đổi khi ô ảnh vẫn là bản web đã nhập.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$l   = static fn( $f, $alt, $where, $t ) => "plugin:img/sun-saphia/sun-saphia-$f.jpg | $alt | $where | $t";
		$add = array(
			$l( 'view-tang-5-phong-khach-bien', 'Tầm view tầng 5 Sun Saphia Residence: phòng khách nhìn ra biển lúc bình minh (phối cảnh chủ đầu tư)', 'thư viện', 'View tầng 5' ),
			$l( 'view-tang-10-ban-cong-bien', 'Tầm view tầng 10 Sun Saphia Residence: ban công nhìn biển Sơn Thủy lúc bình minh (phối cảnh chủ đầu tư)', 'thư viện', 'View tầng 10' ),
			$l( 'view-tang-15-studio-san-bay-thanh-pho', 'Tầm view tầng 15 Sun Saphia Residence: phòng ngủ studio nhìn về sân bay, thành phố và biển (phối cảnh chủ đầu tư)', 'thư viện', 'View tầng 15' ),
			$l( 'view-tang-20-ngu-hanh-son-song-co-co', 'Tầm view tầng 20 Sun Saphia Residence: nhìn Ngũ Hành Sơn và sông Cổ Cò (phối cảnh chủ đầu tư)', 'thư viện', 'View tầng 20' ),
			$l( 'view-tang-25-phong-ngu-song', 'Tầm view tầng 25 Sun Saphia Residence: phòng ngủ nhìn về sông và thành phố (phối cảnh chủ đầu tư)', 'thư viện', 'View tầng 25' ),
			$l( 'tien-ich-ho-boi-1', 'Bể bơi view biển Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể bơi view biển' ),
			$l( 'tien-ich-ho-boi-2', 'Bể bơi ngoài trời dưới chân tòa tháp Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể bơi ngoài trời' ),
			$l( 'tien-ich-ho-boi-3', 'Bể sục, bể trẻ em khu hồ bơi Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể sục' ),
			$l( 'tien-ich-ho-boi-4', 'Khu ghế nghỉ cạnh hồ bơi nhìn ra biển, Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu nghỉ hồ bơi' ),
			$l( 'tien-ich-ho-boi-5', 'Hành lang ghế tắm nắng khu hồ bơi Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Ghế tắm nắng' ),
			$l( 'tien-ich-ho-boi-6', 'Bể tròn nhìn biển lúc hoàng hôn, Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể tròn view biển' ),
			$l( 'tien-ich-gym-1', 'Phòng gym Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Phòng gym' ),
			$l( 'tien-ich-gym-2', 'Khu chạy bộ, máy tập cardio phòng gym Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu cardio' ),
			$l( 'tien-ich-gym-3', 'Khu tập tạ phòng gym Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu tập tạ' ),
			$l( 'tien-ich-sanh-gym-yoga', 'Sảnh lễ tân khu gym và yoga Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Sảnh gym & yoga' ),
			$l( 'tien-ich-lounge-gym-yoga', 'Khu lounge nghỉ ngơi cạnh gym và yoga, Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Lounge' ),
			$l( 'tien-ich-yoga-1', 'Phòng yoga mở ra vườn, Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Phòng yoga' ),
			$l( 'tien-ich-yoga-2', 'Phòng yoga nhìn ra sân vườn, Sun Saphia Residence (phối cảnh chủ đầu tư)', 'tiện ích', 'Yoga sân vườn' ),
			$l( 'tien-ich-kid-club-1', 'Kid club Sun Saphia Residence: khu đọc sách và vui chơi (phối cảnh chủ đầu tư)', 'tiện ích', 'Kid club' ),
			$l( 'tien-ich-kid-club-2', 'Kid club Sun Saphia Residence: khu cầu trượt, đồ chơi (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu vui chơi trẻ em' ),
			$l( 'tien-ich-kid-club-3', 'Kid club Sun Saphia Residence nhìn ra thành phố (phối cảnh chủ đầu tư)', 'tiện ích', 'Kid club view thành phố' ),
		);
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' === $links || false !== strpos( $links, 'sun-saphia-view-tang-5-phong-khach-bien.jpg' ) ) {
				continue;
			}
			$p['meta']['hh_p_image_links']     = $links . "\n" . implode( "\n", $add );
			$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links ) ) ) );
		}
		unset( $p );
		return $projects;
	},
	27
);
