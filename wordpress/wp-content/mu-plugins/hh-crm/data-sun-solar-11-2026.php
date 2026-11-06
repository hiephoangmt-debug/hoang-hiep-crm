<?php
/**
 * Sun Solar Residence – bộ tài liệu chủ đầu tư (thư mục Drive anh Hiệp gửi 06/11/2026):
 * - 22 phối cảnh / tiện ích / sảnh sạch (không chữ in sẵn) thay 8 ảnh poster mạng xã hội cũ;
 * - mặt bằng tầng 5, 6, 7 – 19 (bản cập nhật diện tích, thay "tầng 8 – 19" cũ) và tầng 20 (bể bơi bốn mùa, gym & yoga);
 * - layout 5 loại căn (Studio, 1PN, 1PN+1, 2PN, 3PN);
 * - tiêu chuẩn bàn giao (bảng TCBG của chủ đầu tư);
 * - tour 360° (Kuula).
 * Ưu đãi thanh toán sớm hạn 25/10/2026 đã hết → bỏ khỏi trang (giữ các ưu đãi CSBH04 không ghi hạn).
 * Chạy sau data-sun-solar-csbh04.php (30). Ô nào anh đã tự sửa thì không đè (fix_meta chỉ thay giá trị web nhập).
 */

defined( 'ABSPATH' ) || exit;

/** Các dòng ảnh mới (plugin:img/sun-solar/…). */
function hh_sun_solar_11_2026_images() {
	$l = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/sun-solar/sun-solar-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );
	return array(
		$l( 'cdt-tong-the-hoang-hon', 'Sun Solar Residence – tòa căn hộ 20 tầng trên đường Lê Duẩn bên sông Hàn lúc hoàng hôn, phối cảnh chủ đầu tư', 'đại diện', 'Toàn cảnh lúc hoàng hôn' ),
		$l( 'cdt-toan-canh-song-han', 'Toàn cảnh Sun Solar Residence nhìn sông Hàn, cầu sông Hàn và cầu Rồng, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh sông Hàn' ),
		$l( 'cdt-toa-thap-ban-ngay', 'Tòa tháp Sun Solar Residence ban ngày giữa trung tâm Hải Châu, phối cảnh chủ đầu tư', 'thư viện', 'Tòa tháp ban ngày' ),
		$l( 'cdt-tang-cao-nhin-song-han', 'Các tầng cao Sun Solar Residence nhìn sông Hàn và cầu sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Tầng cao nhìn sông Hàn' ),
		$l( 'cdt-ban-cong-view-cau-song-han', 'Ban công xanh Sun Solar Residence nhìn thẳng cầu sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Ban công nhìn cầu sông Hàn' ),
		$l( 'cdt-can-ho-nhin-thanh-pho', 'Căn hộ Sun Solar Residence nhìn toàn cảnh thành phố Đà Nẵng, phối cảnh chủ đầu tư', 'thư viện', 'Căn hộ nhìn thành phố' ),
		$l( 'cdt-khoi-de-san-vuon', 'Khối đế và sân vườn trên cao Sun Solar Residence, trục đường Lê Duẩn, phối cảnh chủ đầu tư', 'thư viện', 'Khối đế, sân vườn trên cao' ),
		$l( 'cdt-sanh-don-tang-1', 'Sảnh đón tầng 1 Sun Solar Residence, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh đón tầng 1' ),
		$l( 'cdt-sanh-tang-1', 'Sảnh cư dân tầng 1 Sun Solar Residence, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh cư dân' ),
		$l( 'cdt-sanh-thang-may', 'Sảnh thang máy Sun Solar Residence, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh thang máy' ),
		$l( 'cdt-vi-tri-le-duan', 'Vị trí Sun Solar Residence trên đường Lê Duẩn, gần cầu sông Hàn, sơ đồ chủ đầu tư', 'tổng thể', 'Vị trí trên đường Lê Duẩn' ),
		$l( 'cdt-be-boi-bon-mua', 'Bể bơi bốn mùa Sun Solar Residence nhìn sông Hàn, phối cảnh chủ đầu tư', 'tiện ích', 'Bể bơi bốn mùa' ),
		$l( 'cdt-be-boi-buoi-sang', 'Bể bơi bốn mùa Sun Solar Residence buổi sáng, phối cảnh chủ đầu tư', 'tiện ích', 'Bể bơi buổi sáng' ),
		$l( 'cdt-san-thuong-bar', 'Sân thượng thư giãn Sun Solar Residence nhìn thành phố về đêm, phối cảnh chủ đầu tư', 'tiện ích', 'Sân thượng thư giãn' ),
		$l( 'cdt-phong-gym', 'Phòng gym Sun Solar Residence nhìn thành phố, phối cảnh chủ đầu tư', 'tiện ích', 'Phòng gym' ),
		$l( 'cdt-gym-yoga', 'Khu gym & yoga Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Gym & yoga' ),
		$l( 'cdt-sanh-spa', 'Sảnh spa Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Sảnh spa' ),
		$l( 'cdt-spa', 'Khu spa Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Spa' ),
		$l( 'cdt-thu-vien-kids-club', 'Thư viện & kids club Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Thư viện & kids club' ),
		$l( 'cdt-thu-vien', 'Thư viện cư dân Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Thư viện' ),
		$l( 'cdt-kids-club', 'Kids club Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Kids club' ),
		$l( 'cdt-phong-thu-gian', 'Phòng thư giãn – sinh hoạt cộng đồng Sun Solar Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Phòng thư giãn' ),
		$l( 'mat-bang-tang-5-cdt', 'Mặt bằng tầng 5 Sun Solar Residence: sinh hoạt cộng đồng, thư viện & kids club, spa, phòng thư giãn, gym & yoga', 'mặt bằng', 'Tầng 5 – Tiện ích' ),
		$l( 'mat-bang-tang-6-cdt', 'Mặt bằng tầng 6 Sun Solar Residence kèm diện tích từng căn', 'mặt bằng', 'Tầng 6' ),
		$l( 'mat-bang-tang-7-19-cdt', 'Mặt bằng tầng điển hình 7 – 19 Sun Solar Residence, bản cập nhật diện tích từng căn', 'mặt bằng', 'Tầng 7 – 19' ),
		$l( 'mat-bang-tang-20-cdt', 'Mặt bằng tầng 20 Sun Solar Residence: bể bơi bốn mùa, gym & yoga và các căn hộ', 'mặt bằng', 'Tầng 20' ),
		$l( 'layout-studio-33m2', 'Layout căn Studio Sun Solar Residence – diện tích 33,1 m²', 'layout', 'Studio 33,1 m²' ),
		$l( 'layout-1pn-41m2', 'Layout căn 1 phòng ngủ Sun Solar Residence – diện tích 41,3 m²', 'layout', '1PN 41,3 m²' ),
		$l( 'layout-1pn-plus-46m2', 'Layout căn 1 phòng ngủ + 1 Sun Solar Residence – diện tích 46,4 m²', 'layout', '1PN+1 46,4 m²' ),
		$l( 'layout-2pn-55m2', 'Layout căn 2 phòng ngủ Sun Solar Residence – diện tích 55,3 m²', 'layout', '2PN 55,3 m²' ),
		$l( 'layout-3pn-99m2', 'Layout căn 3 phòng ngủ Sun Solar Residence – diện tích 99,7 m²', 'layout', '3PN 99,7 m²' ),
	);
}

/** Ảnh cũ (poster, mặt bằng cũ) gỡ khỏi trang khi ảnh mới đã tải xong – vẫn giữ trong Thư viện. */
const HH_SUN_SOLAR_OLD_IMAGES = array(
	'plugin:img/sun-solar/sun-solar-residence-phoi-canh-le-duan-song-han.jpg',
	'plugin:img/sun-solar/sun-solar-residence-toan-canh.jpg',
	'plugin:img/sun-solar/sun-solar-residence-vi-tri.jpg',
	'plugin:img/sun-solar/sun-solar-residence-mat-tien.jpg',
	'plugin:img/sun-solar/sun-solar-residence-cong-dong-song.jpg',
	'plugin:img/sun-solar/sun-solar-residence-256-can-ho.jpg',
	'plugin:img/sun-solar/sun-solar-residence-ho-boi-view-song-han.jpg',
	'plugin:img/sun-solar/sun-solar-residence-phong-gym.jpg',
	'plugin:img/sun-solar/sun-solar-residence-mat-bang-tang-5-tien-ich.jpg',
	'plugin:img/sun-solar/sun-solar-residence-mat-bang-tang-6.jpg',
	'plugin:img/sun-solar/sun-solar-residence-mat-bang-tang-8-19.jpg',
);

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-solar-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$fix = static function ( $key, $new, $olds ) use ( &$p ) {
				$olds = array_values( array_unique( array_filter( array_map( 'strval', (array) $olds ), static fn( $v ) => '' !== $v && $v !== $new ) ) );
				if ( $olds ) {
					$p['meta'][ $key ]     = $new;
					$p['fix_meta'][ $key ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), $olds ) ) );
				}
			};

			// Ảnh: bộ mới đứng đầu, giữ các dòng cũ (để web nhớ ảnh đã tải); ảnh cũ được gỡ khỏi trang ở bước dọn bên dưới.
			$file  = HH_CRM_DIR . 'data/sun-solar-csbh04.json';
			$data  = is_readable( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : array(); // phpcs:ignore WordPress.WP.AlternativeFunctions
			$old   = implode( "\n", (array) ( $data['image_links'] ?? array() ) );
			$keep  = str_replace( ' | đại diện', ' | thư viện', $old );
			$new   = implode( "\n", hh_sun_solar_11_2026_images() ) . ( '' !== $keep ? "\n" . $keep : '' );
			$p['meta']['hh_p_image_links'] = $new;
			$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $old ) ) ) );

			// Tour 360° của chủ đầu tư (Kuula, anh Hiệp gửi 06/11/2026) – ảnh xem trước là phối cảnh căn hộ nhìn thành phố.
			$p['meta']['hh_p_tour_360']        = 'https://kuula.co/share/collection/71lrB?logo=1&info=1&fs=1&vr=0&thumbs=1';
			$p['meta']['hh_p_tour_360_poster'] = 'plugin:img/sun-solar/sun-solar-cdt-can-ho-nhin-thanh-pho.jpg';

			// Tiêu chuẩn bàn giao (ô đang trống thì điền).
			$p['meta']['hh_p_handover_std'] = 'Bàn giao hoàn thiện theo bảng tiêu chuẩn của chủ đầu tư: trần thạch cao, sơn Dulux/Jotun; phòng ngủ lát gỗ công nghiệp; rèm 2 lớp; tủ bếp, mặt đá, bếp và hút mùi Hafele/Teka; thiết bị vệ sinh Toto/Grohe, vách tắm kính cường lực (nếu có), bình nóng lạnh Ariston/Ferroli; điều hòa Daikin/Mitsubishi/Panasonic (âm trần phòng khách, treo tường phòng ngủ); cửa chính gỗ chống cháy, khóa thông minh; lô gia lát gạch chống trơn, lan can kính cường lực (hoặc tương đương).';

			// Ưu đãi thanh toán sớm hạn 25/10/2026 đã hết: bỏ dòng hết hạn, giữ ưu đãi không ghi hạn của CSBH04.
			$m = $p['meta'];
			$fix( 'hh_p_offer_title', 'Quà tặng an cư 5% + không vay thêm 5%, nhận căn sử dụng khi thanh toán 70%', array( $m['hh_p_offer_title'] ?? '', 'Chiết khấu tổng 20% khi thanh toán sớm 95% trước 25/10/2026', 'Chiết khấu tổng khoảng 18,8% khi thanh toán sớm 95% trước 25/10/2026' ) );
			$fix( 'hh_p_offer_deadline', '', array( '25/10/2026' ) );
			$fix(
				'hh_p_offer_stats',
				"~9,75% | Quà tặng an cư 5% + không vay 5% (CSBH04, trừ nối tiếp)\n70% | Vay tối đa, hỗ trợ lãi suất đến 30 tháng\n28/04/2027 | Dự kiến nhận căn sử dụng (Sun Early Key)\n3 năm | Miễn phí dịch vụ quản lý căn hộ",
				array_merge( array( $m['hh_p_offer_stats'] ?? '' ), (array) ( $p['fix_meta']['hh_p_offer_stats'] ?? array() ) )
			);
			$fix(
				'hh_p_policy',
				implode( "\n", array_map( static fn( $l ) => 0 === strpos( $l, 'Thanh toán sớm 95%' ) ? 'Thanh toán sớm: mức chiết khấu theo phiếu tính giá hiện hành của chủ đầu tư – liên hệ để nhận phiếu tính giá căn cụ thể' : $l, explode( "\n", (string) ( $m['hh_p_policy'] ?? '' ) ) ) ),
				array( $m['hh_p_policy'] ?? '' )
			);
			// Bảng giá: bỏ mã căn, gộp cùng loại căn + diện tích thành khoảng giá; xếp theo loại căn, diện tích.
			$order  = array( 'Studio' => 0, '1PN' => 1, '1PN+' => 2, '2PN' => 3, '2PN+' => 4, '3PN' => 5 );
			$num    = static fn( $v ) => (float) str_replace( ',', '.', preg_replace( '/[^0-9,]/', '', (string) $v ) );
			$groups = array();
			$note   = '';
			foreach ( array_filter( explode( "\n", (string) ( $m['hh_p_price_table'] ?? '' ) ) ) as $line ) {
				$c    = array_map( 'trim', explode( '|', $line ) );
				$type = trim( preg_replace( '/^[A-Z0-9]+\s*[–-]\s*/u', '', $c[0] ) );
				$note = $c[3] ?? $note;
				$groups[ $type . '|' . $c[1] ][] = $num( $c[2] ?? '' );
			}
			uksort( $groups, static function ( $a, $b ) use ( $order, $num ) {
				list( $ta, $aa ) = explode( '|', $a );
				list( $tb, $ab ) = explode( '|', $b );
				return array( $order[ $ta ] ?? 9, $num( $aa ) ) <=> array( $order[ $tb ] ?? 9, $num( $ab ) );
			} );
			$ty    = static fn( $v ) => number_format( $v, 2, ',', '.' );
			$lines = array();
			foreach ( $groups as $k => $prices ) {
				list( $type, $area ) = explode( '|', $k );
				$lo      = min( $prices );
				$hi      = max( $prices );
				$lines[] = "$type | $area | " . ( $lo === $hi ? $ty( $lo ) : $ty( $lo ) . ' – ' . $ty( $hi ) ) . ' tỷ | ' . $note;
			}
			$fix( 'hh_p_price_table', implode( "\n", $lines ), array( $m['hh_p_price_table'] ?? '' ) );
			$fix(
				'hh_p_discount_table',
				implode( "\n", array_map( static fn( $l ) => 0 === strpos( $l, 'Thanh toán sớm 95%' ) ? 'Thanh toán sớm | Theo phiếu tính giá hiện hành | Liên hệ | Quà tặng an cư 5% + không vay 5% + chiết khấu thanh toán sớm theo phiếu tính giá' : $l, explode( "\n", (string) ( $m['hh_p_discount_table'] ?? '' ) ) ) ),
				array( $m['hh_p_discount_table'] ?? '' )
			);
		}
		unset( $p );
		return $projects;
	},
	31
);

/**
 * Gỡ ảnh cũ khỏi các ô ảnh của trang (khi toàn bộ ảnh mới đã tải xong). Chạy khi vào trang quản trị và sau mỗi lượt tải ảnh ngầm.
 */
function hh_sun_solar_11_2026_cleanup() {
	if ( get_option( 'hh_sun_solar_img_2026_11' ) ) {
		return;
	}
	$post = get_page_by_path( 'sun-solar-residence', OBJECT, 'du-an' );
	if ( ! $post || ! function_exists( 'hh_img_link_key' ) ) {
		return;
	}
	$done = (array) get_post_meta( $post->ID, '_hh_img_links', true );
	foreach ( hh_sun_solar_11_2026_images() as $line ) {
		$key = hh_img_link_key( trim( explode( '|', $line )[0] ) );
		if ( ! isset( $done[ $key ] ) ) {
			return; // Còn ảnh mới chưa tải – chưa gỡ ảnh cũ.
		}
	}
	$old_ids = array();
	foreach ( HH_SUN_SOLAR_OLD_IMAGES as $key ) {
		if ( isset( $done[ $key ] ) && is_int( $done[ $key ] ) ) {
			$old_ids[] = $done[ $key ];
		}
	}
	foreach ( array( 'hh_p_gallery', 'hh_p_amenities_img', 'hh_p_floorplans', 'hh_p_unit_layouts', 'hh_p_masterplan_img' ) as $meta_key ) {
		$ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, $meta_key, true ) ) ) );
		$keep = array_values( array_diff( $ids, $old_ids ) );
		if ( count( $keep ) !== count( $ids ) ) {
			update_post_meta( $post->ID, $meta_key, implode( ',', $keep ) );
		}
	}
	$hero = (int) ( $done[ hh_img_link_key( 'plugin:img/sun-solar/sun-solar-cdt-tong-the-hoang-hon.jpg' ) ] ?? 0 );
	if ( $hero && in_array( (int) get_post_thumbnail_id( $post->ID ), $old_ids, true ) ) {
		set_post_thumbnail( $post->ID, $hero );
	}
	update_option( 'hh_sun_solar_img_2026_11', 1, false );
}
add_action( 'admin_init', 'hh_sun_solar_11_2026_cleanup' );
add_action( 'hh_img_links_cron', 'hh_sun_solar_11_2026_cleanup', 20 );
