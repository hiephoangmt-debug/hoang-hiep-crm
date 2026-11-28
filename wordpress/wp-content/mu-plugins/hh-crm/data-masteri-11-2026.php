<?php
/**
 * Masteri Rivera Danang – bổ sung từ bộ tài liệu chủ đầu tư anh Hiệp gửi 18/11/2026
 * (tên pháp lý, pháp nhân chủ đầu tư, tháp A/B, sông Cẩm Lệ, căn Dual Key ~101 m², phương thức thanh toán).
 * Không ghi giá mới (chính sách trong tài liệu là 2025, đã hết hạn).
 * Chỉ thay khi trên web còn giá trị cũ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old = (array) ( $p['meta'] ?? array() );
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$upd = array(
				'hh_p_developer'     => 'Masterise Homes (pháp nhân chủ đầu tư: Công ty CP Phát triển Nhà Tuyên Sơn)',
				'hh_p_type'          => 'Căn hộ cao cấp sở hữu lâu dài, Dual Key, khối đế thương mại (tên pháp lý: Dự án khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn)',
				'hh_p_blocks'        => '2 tòa tháp (tháp A và tháp B)',
				'hh_p_highlights'    => "Dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng\n2 tháp A – B cao 39 tầng, gần 1.200 căn, nhìn ra sông Cẩm Lệ khu Hòa Cường Nam\nCạnh Cung thể thao Tiên Sơn, 3 mặt tiền Quy Mỹ – Trần Đăng Ninh – Nguyễn Lộ Trạch\n31 tiện ích nội khu từ tầng 1 đến tầng 4\nĐã cất nóc tháng 12/2025, tổng thầu Central\nSở hữu lâu dài cho người Việt Nam",
				'hh_p_design_desc'   => 'Hai tháp A và B cao 39 tầng trên khối đế thương mại tầng 1 – 3 (shophouse, trung tâm thương mại khoảng 2.500 m²), tầng 4 là hồ bơi resort, vườn dạo bộ và sân chơi trẻ em; 2 tầng hầm đỗ xe. Cơ cấu căn: 1PN+, 2PN, 2PN+, 3PN và Dual Key (căn Dual Key khoảng 101 m² thông thủy, 2 cửa vào riêng).',
				'hh_p_location_desc' => 'Dự án nằm trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu), nhìn ra sông Cẩm Lệ, cạnh Cung thể thao Tiên Sơn; gần Lotte Mart, Asia Park (Sun World Đà Nẵng Wonders), từ đây đi cầu Rồng và trung tâm Hải Châu khoảng 10 phút.',
				'hh_p_connections'   => "Vài phút | Sông Cẩm Lệ, Cung thể thao Tiên Sơn\nVài phút | Lotte Mart, Asia Park, đường 2/9\nKhoảng 10 phút | Cầu Rồng, trung tâm Hải Châu\nKhoảng 10 phút | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_out' => "Lotte Mart, Asia Park\nSông Cẩm Lệ, Cung thể thao Tiên Sơn\nTrường học, bệnh viện khu Hải Châu\nCầu Rồng, trung tâm hành chính",
				'hh_p_policy'        => "Phương thức thanh toán theo chính sách của chủ đầu tư: thanh toán theo tiến độ chuẩn, thanh toán sớm (chiết khấu cao hơn) hoặc kết hợp vay ngân hàng có hỗ trợ lãi suất\nThường có ưu đãi thêm cho khách hàng là người Đà Nẵng\nĐặt cọc, chiết khấu và tiến độ cụ thể thay đổi theo từng đợt – liên hệ Hoàng Hiệp 0904 567 009 để nhận chính sách đang áp dụng",
			);
			$upd['hh_p_image_links'] = trim( (string) ( $old['hh_p_image_links'] ?? '' ) . "\nplugin:img/masteri-rivera-danang/masteri-rivera-danang-ho-boi-phoi-canh.jpg | Hồ bơi resort Masteri Rivera Danang (phối cảnh chủ đầu tư Masterise Homes) | tiện ích" );
			foreach ( $upd as $k => $v ) {
				$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( (string) ( $old[ $k ] ?? '' ) ) );
			}

			// Bài giới thiệu: sông Cẩm Lệ, tên pháp lý, cách thanh toán (không ghi giá mới).
			$c0 = (string) ( $p['content'] ?? '' );
			$c1 = strtr(
				$c0,
				array(
					'<p>Dự án có ba mặt tiền Quy Mỹ – Trần Đăng Ninh – Nguyễn Lộ Trạch, gần sông Hàn, Lotte Mart và Asia Park. Theo chủ đầu tư, phần lớn căn hộ có hướng nhìn về sông Hàn.</p>' => '<p>Dự án có ba mặt tiền Quy Mỹ – Trần Đăng Ninh – Nguyễn Lộ Trạch, gồm tháp A và tháp B nhìn ra sông Cẩm Lệ, cạnh Cung thể thao Tiên Sơn; gần Lotte Mart và Asia Park, đi cầu Rồng khoảng 10 phút.</p>',
					'<h2>Pháp lý & tiến độ</h2>' . "\n" . '<p>Dự án đã có văn bản đủ điều kiện bán,' => '<h2>Pháp lý & tiến độ</h2>' . "\n" . '<p>Tên pháp lý là Dự án khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn, pháp nhân chủ đầu tư là Công ty CP Phát triển Nhà Tuyên Sơn (Masterise Homes phát triển). Dự án đã có văn bản đủ điều kiện bán,',
					'<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá' => '<h2>Cách thanh toán Masteri Rivera Danang</h2>' . "\n" . '<p>Chủ đầu tư thường có ba phương án: thanh toán theo tiến độ chuẩn, thanh toán sớm để nhận chiết khấu cao hơn, hoặc kết hợp vay ngân hàng có hỗ trợ lãi suất trong một thời gian. Khách hàng là người Đà Nẵng thường được ưu đãi thêm. Mức đặt cọc, chiết khấu và lịch thanh toán thay đổi theo từng đợt chính sách.</p>' . "\n" . '<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá',
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

/*
 * 23/11/2026: Masterise Homes công bố Lễ bàn giao căn hộ Masteri Rivera Danang "Trọn vẹn nhịp sống giao hòa"
 * 10:00 Chủ nhật 29/11/2026 tại văn phòng bán hàng 50 Quy Mỹ (thông báo chủ đầu tư, anh Hiệp gửi).
 */
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$prog = (string) ( $p['meta']['hh_p_progress'] ?? '' );
			$upd  = array(
				'hh_p_handover' => 'Lễ bàn giao căn hộ ngày 29/11/2026 (theo thông báo của Masterise Homes)',
				'hh_p_progress' => str_replace( 'Quý III/2026 | Dự kiến bàn giao', '29/11/2026 | Lễ bàn giao căn hộ "Trọn vẹn nhịp sống giao hòa" – đón cư dân đầu tiên', $prog ),
			);
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $links && false === strpos( $links, 'le-ban-giao-29-11-2026' ) ) {
				$upd['hh_p_image_links'] = $links . "\nplugin:img/masteri-rivera-danang/masteri-rivera-danang-le-ban-giao-29-11-2026.jpg | Masteri Rivera Danang tổ chức lễ bàn giao căn hộ ngày 29/11/2026 (ảnh chủ đầu tư Masterise Homes) | thư viện | Lễ bàn giao 29/11/2026";
			}
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
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	40
);

/*
 * 27/11/2026: ảnh gốc độ nét cao (1920 px) và dữ liệu chính thức từ trang dự án của Masterise Homes
 * (masterisehomes.com/masteri-rivera-danang): kết nối 1/5/10/15/30 phút, 31 tiện ích theo tầng, tháp A – B.
 * Thay ảnh poster / ảnh mờ cũ (gỡ khỏi trang khi ảnh mới đã tải xong).
 */
const HH_MASTERI_2711_OLD_IMAGES = array(
	'plugin:img/masteri-rivera-danang/masteri-rivera-danang-ho-boi-phoi-canh.jpg',
	'plugin:img/masteri-rivera-danang/masteri-rivera-danang-hai-toa-thap.jpg',
	'plugin:img/masteri-rivera-danang/masteri-rivera-danang-so-do-vi-tri.jpg',
);

/** Ảnh gốc chủ đầu tư (27/11/2026): Link | Chú thích | Mục. */
function hh_masteri_2711_images() {
	$d = 'plugin:img/masteri-rivera-danang/masteri-rivera-danang-';
	return array(
		$d . 'phoi-canh-tren-cao-song-cam-le.jpg | Phối cảnh Masteri Rivera Danang nhìn từ trên cao: 2 tháp A – B bên sông Cẩm Lệ, Hải Châu (ảnh chủ đầu tư Masterise Homes) | đại diện',
		$d . 'hai-thap-a-b-nhin-tu-song.jpg | Hai tòa tháp A – B Masteri Rivera Danang 39 tầng nhìn từ phía sông (phối cảnh chủ đầu tư) | thư viện',
		$d . 'ban-do-vi-tri-ket-noi.jpg | Bản đồ vị trí Masteri Rivera Danang kết nối Asia Park, cầu Rồng, biển Mỹ Khê, sân bay Đà Nẵng (tài liệu chủ đầu tư) | thư viện',
		$d . 'tong-mat-bang-tren-cao.jpg | Tổng mặt bằng Masteri Rivera Danang nhìn từ trên cao (tài liệu chủ đầu tư) | thư viện',
		$d . 'sa-ban-can-ho-mau-50-quy-my.jpg | Khách tham quan sa bàn và căn hộ mẫu Masteri Rivera Danang tại 50 Quy Mỹ (ảnh chủ đầu tư) | thư viện',
		$d . 'ho-boi-resort-huong-song.jpg | Hồ bơi resort hướng sông tầng 4 Masteri Rivera Danang (phối cảnh chủ đầu tư) | tiện ích',
		$d . 'toan-canh-san-vuon-tien-ich-tang-4.jpg | Toàn cảnh sân vườn tiện ích tầng 4 Masteri Rivera Danang: hồ bơi, sân pickleball, vườn trên mây (phối cảnh chủ đầu tư) | tiện ích',
		$d . 'sanh-don-tiep-khoi-de-thuong-mai.jpg | Sảnh đón tiếp và khối đế thương mại Masteri Rivera Danang (phối cảnh chủ đầu tư) | tiện ích',
		$d . 'oc-dao-nhiet-doi.jpg | Ốc đảo nhiệt đới tầng 1 Masteri Rivera Danang (phối cảnh chủ đầu tư) | tiện ích',
		$d . 'khu-vui-choi-tham-hiem-rung-sau.jpg | Khu vui chơi "Thám hiểm rừng sâu" Masteri Rivera Danang (phối cảnh chủ đầu tư) | tiện ích',
		$d . 'san-choi-tre-em-tang-4.jpg | Sân chơi trẻ em trên cao tầng 4 Masteri Rivera Danang (phối cảnh chủ đầu tư) | tiện ích',
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = array();
			foreach ( explode( "\n", (string) ( $p['meta']['hh_p_image_links'] ?? '' ) ) as $line ) {
				$key = trim( explode( '|', $line )[0] );
				if ( '' !== trim( $line ) && ! in_array( $key, HH_MASTERI_2711_OLD_IMAGES, true ) ) {
					$links[] = trim( $line );
				}
			}
			// Giá trị đang có trên web = danh sách ảnh trước đây + 3 ảnh web cũ nối thêm (bo-sung-anh-11-2026.json bản trước) → ghi vào fix_meta để được thay.
			$cur_links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$was_json  = array(
				'plugin:img/masteri-rivera-danang/masteri-rivera-danang-hai-toa-thap.jpg | Hai tòa tháp 39 tầng Masteri Rivera Danang với 1.112 căn hộ, phối cảnh dự án | thư viện',
				'plugin:img/masteri-rivera-danang/masteri-rivera-danang-mat-bang-tong-the-tien-ich.jpg | Mặt bằng tổng thể và tiện ích Masteri Rivera Danang: bể bơi resort, sân pickleball, vườn trên mây, tiện ích trong nhà tầng 1 – 3 | tổng thể',
				'plugin:img/masteri-rivera-danang/masteri-rivera-danang-so-do-vi-tri.jpg | Sơ đồ vị trí Masteri Rivera Danang gần đường 2 Tháng 9 bên sông Hàn, kết nối sân bay và biển | thư viện',
			);
			$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( implode( "\n", array_merge( array_filter( array_map( 'trim', explode( "\n", $cur_links ) ) ), $was_json ) ) ) );
			$upd = array(
				'hh_p_image_links'   => implode( "\n", array_merge( $links, hh_masteri_2711_images() ) ),
				'hh_p_handover'      => 'Ngày 29/11/2026',
				'hh_p_highlights'    => "Dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng\n2 tháp A – B cao 39 tầng, gần 1.200 căn, nhìn ra sông Cẩm Lệ khu Hòa Cường Nam\nCạnh Cung thể thao Tiên Sơn, 3 mặt tiền Quy Mỹ – Trần Đăng Ninh – Nguyễn Lộ Trạch\n1 phút tới Lotte Mart, 10 phút ra biển Mỹ Khê, 15 phút tới sân bay\n31 tiện ích nội khu từ tầng 1 đến tầng 4\nCất nóc 12/2025, lễ bàn giao căn hộ ngày 29/11/2026\nSở hữu lâu dài cho người Việt Nam",
				'hh_p_location_desc' => 'Masteri Rivera Danang nằm tại 50 Quy Mỹ, khu Hòa Cường Nam – một trong những khu dân cư hiện hữu sầm uất nhất của Hải Châu. Dự án có 3 mặt tiền Quy Mỹ, Trần Đăng Ninh và Nguyễn Lộ Trạch; hai tháp A và B hướng ra sông Cẩm Lệ, ngay cạnh Cung thể thao Tiên Sơn, phía trước là khoảng mở không bị che chắn. Theo chủ đầu tư, từ dự án chỉ 1 phút tới Lotte Mart, 10 phút ra biển Mỹ Khê, 15 phút tới sân bay và 30 phút tới phố cổ Hội An.',
				'hh_p_connections'   => "1 phút | Lotte Mart, hệ thống giáo dục Sky-Line\n5 phút | Asia Park, Cung thể thao Tiên Sơn, Cung thiếu nhi Đà Nẵng\n5 phút | Quảng trường 2/9, chợ Bắc Mỹ An, Trung tâm hội chợ triển lãm\n10 phút | Biển Mỹ Khê, cầu Rồng, Bệnh viện Vinmec Đà Nẵng\n15 phút | Cầu sông Hàn, chợ Cồn, chợ Hàn, Trung tâm hành chính\n15 phút | Sân bay quốc tế Đà Nẵng\n30 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Tầng 1 ngoài trời: sảnh đón căn hộ, điểm lên xuống hầm có mái che, ốc đảo nhiệt đới\nKhu vui chơi \"Thám hiểm rừng sâu\", cafe ngoài trời, bậc nghỉ thư giãn, vườn thú cưng\nTầng 4: bể bơi resort, bể bơi trẻ em, khu tắm nắng, hồ cạn, lounge chìm, cabana\nTầng 4: vườn BBQ, sân chơi vườn trên mây, sân chơi cát, sân pickleball\nTầng 4: khu võng, thể thao đa năng, vườn thư giãn, vườn yoga, vườn đọc sách, điểm vọng cảnh\nTrong nhà tầng 1 – 2: sảnh cư dân, hòm thư, sảnh thang máy, teen's club, kid's area\nTrong nhà tầng 3: phòng gym & yoga, business hub, phòng đa chức năng\nTrung tâm thương mại khoảng 2.500 m², shophouse khối đế, 2 tầng hầm đỗ xe",
				'hh_p_amenities_out' => "Lotte Mart, hệ thống giáo dục Sky-Line\nAsia Park, Cung thể thao Tiên Sơn, Cung thiếu nhi\nBiển Mỹ Khê, cầu Rồng, Bệnh viện Vinmec\nChợ Cồn, chợ Hàn, Trung tâm hành chính, sân bay",
				'hh_p_faq'           => "Masteri Rivera Danang ở đâu? | 50 Quy Mỹ, khu Hòa Cường Nam, Hải Châu, Đà Nẵng – 3 mặt tiền Quy Mỹ, Trần Đăng Ninh, Nguyễn Lộ Trạch, nhìn ra sông Cẩm Lệ, cạnh Cung thể thao Tiên Sơn.\nChủ đầu tư là ai? | Dự án do Masterise Homes phát triển, pháp nhân chủ đầu tư là Công ty CP Phát triển Nhà Tuyên Sơn; tổng thầu thi công là Central (Centralcons).\nKhi nào nhận nhà? | Chủ đầu tư tổ chức lễ bàn giao căn hộ ngày 29/11/2026. Căn hộ bàn giao hoàn thiện sàn, trần, tường và nội thất cơ bản.\nCó sở hữu lâu dài không? | Có. Người Việt Nam được sở hữu lâu dài; người nước ngoài được sở hữu 50 năm theo quy định.\nDự án có những tiện ích gì? | 31 tiện ích nội khu từ tầng 1 đến tầng 4: bể bơi resort, bể bơi trẻ em, sân pickleball, vườn trên mây, vườn BBQ, vườn yoga, gym & yoga, business hub, khu vui chơi trẻ em trong nhà và ngoài trời, cùng trung tâm thương mại khoảng 2.500 m².\nCăn Dual Key là gì? | Căn khoảng 101 m² thông thủy có 2 cửa vào riêng: chủ nhà ở một phần và cho thuê phần còn lại, hoặc cho gia đình nhiều thế hệ ở chung mà vẫn riêng tư.\nGiá Masteri Rivera Danang bao nhiêu? | Giá chỉ từ khoảng 4,1 tỷ đồng/căn (tham khảo). Giá từng căn, giỏ hàng còn lại và chính sách thay đổi theo từng đợt – liên hệ Hoàng Hiệp 0904 567 009 để nhận bảng giá mới nhất.\nCó xem căn hộ thực tế được không? | Được. Văn phòng bán hàng, căn hộ mẫu và sa bàn ở 50 Quy Mỹ; anh chị liên hệ Hoàng Hiệp – 0904 567 009 để hẹn lịch xem căn và tiện ích.",
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

			// Bài giới thiệu: thêm kết nối, 31 tiện ích, Masterise Homes; cập nhật mốc bàn giao.
			$c0  = (string) ( $p['content'] ?? '' );
			$add = '<h2>Kết nối từ Masteri Rivera Danang</h2>' . "\n"
				. '<ul>' . "\n"
				. '<li><strong>1 phút:</strong> Lotte Mart, hệ thống giáo dục Sky-Line.</li>' . "\n"
				. '<li><strong>5 phút:</strong> Asia Park, Cung thể thao Tiên Sơn, Cung thiếu nhi Đà Nẵng, Quảng trường 2/9, chợ Bắc Mỹ An, Trung tâm hội chợ triển lãm Đà Nẵng.</li>' . "\n"
				. '<li><strong>10 phút:</strong> biển Mỹ Khê, cầu Rồng, Bệnh viện Đa khoa Vinmec Đà Nẵng.</li>' . "\n"
				. '<li><strong>15 phút:</strong> cầu sông Hàn, chợ Cồn, chợ Hàn, Trung tâm hành chính TP Đà Nẵng, sân bay quốc tế Đà Nẵng.</li>' . "\n"
				. '<li><strong>30 phút:</strong> phố cổ Hội An.</li>' . "\n"
				. '</ul>' . "\n"
				. '<h2>31 tiện ích nội khu Masteri Rivera Danang</h2>' . "\n"
				. '<p>Tầng 1 là không gian đón tiếp và vườn cảnh với 8 tiện ích ngoài trời: sảnh đón căn hộ, điểm lên xuống hầm có mái che, ốc đảo nhiệt đới, khu vui chơi "Thám hiểm rừng sâu", cafe ngoài trời, bậc nghỉ thư giãn, vườn thú cưng. Tầng 4 là "công viên trên cao" với 16 tiện ích: bể bơi resort, bể bơi trẻ em, khu tắm nắng, hồ cạn, lounge chìm, cabana, vườn BBQ, sân chơi vườn trên mây, sân chơi cát, sân pickleball, khu võng, sân thể thao đa năng, vườn thư giãn, vườn yoga, vườn đọc sách và điểm vọng cảnh.</p>' . "\n"
				. '<p>Trong nhà có sảnh cư dân, hòm thư, sảnh thang máy, khu vui chơi teen\'s club và kid\'s area (tầng 1 – 2); phòng gym & yoga, không gian làm việc chung business hub và phòng đa chức năng (tầng 3). Khối đế tầng 1 – 3 có shophouse và trung tâm thương mại khoảng 2.500 m².</p>' . "\n"
				. '<h2>Về Masterise Homes</h2>' . "\n"
				. '<p>Masterise Homes, thành viên tập đoàn Masterise, là nhà phát triển bất động sản hàng hiệu, đứng sau dòng căn hộ Masteri Collection tại TP.HCM và Hà Nội (Masteri Centre Point, Masteri Waterfront, Masteri Lakeside, Masteri Trinity Square, Masteri West Heights…). Theo chủ đầu tư, Masterise Homes sở hữu danh mục bất động sản hàng hiệu lớn nhất Đông Nam Á và hợp tác với Marriott International. Masteri Rivera Danang là dự án đầu tiên của Masterise Homes tại Đà Nẵng; văn phòng bán hàng, căn hộ mẫu và sa bàn khai trương tháng 7/2025 tại 50 Quy Mỹ.</p>' . "\n";
			$c1 = strtr(
				$c0,
				array(
					'Bàn giao dự kiến Quý III/2026 (một số nguồn ghi Quý IV/2026).' => 'Chủ đầu tư tổ chức lễ bàn giao căn hộ "Trọn vẹn nhịp sống giao hòa" ngày 29/11/2026.',
					'<h2>Cách thanh toán Masteri Rivera Danang</h2>' => $add . '<h2>Cách thanh toán Masteri Rivera Danang</h2>',
				)
			);
			if ( $c1 !== $c0 && false === strpos( $c0, '<h2>Kết nối từ Masteri Rivera Danang</h2>' ) ) {
				$p['content']     = $c1;
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	50
);

/** Gỡ ảnh poster / ảnh mờ cũ khỏi các ô ảnh khi ảnh gốc mới đã tải xong; ảnh đại diện chuyển sang phối cảnh trên cao. */
function hh_masteri_2711_cleanup() {
	if ( get_option( 'hh_masteri_img_2026_11_27' ) ) {
		return;
	}
	$post = get_page_by_path( 'masteri-da-nang', OBJECT, 'du-an' );
	if ( ! $post || ! function_exists( 'hh_img_link_key' ) ) {
		return;
	}
	// Danh sách link ảnh trên web chưa có ảnh mới (giá trị trên web khác bản cũ đã biết): thay trực tiếp rồi đưa vào hàng chờ tải.
	$cur = (string) get_post_meta( $post->ID, 'hh_p_image_links', true );
	if ( false === strpos( $cur, 'phoi-canh-tren-cao-song-cam-le' ) ) {
		$keep = array();
		foreach ( explode( "\n", $cur ) as $line ) {
			if ( '' !== trim( $line ) && ! in_array( trim( explode( '|', $line )[0] ), HH_MASTERI_2711_OLD_IMAGES, true ) ) {
				$keep[] = trim( $line );
			}
		}
		update_post_meta( $post->ID, 'hh_p_image_links', implode( "\n", array_merge( $keep, hh_masteri_2711_images() ) ) );
		if ( function_exists( 'hh_img_links_queue' ) ) {
			hh_img_links_queue( $post->ID );
		}
		return;
	}
	$done = (array) get_post_meta( $post->ID, '_hh_img_links', true );
	foreach ( hh_masteri_2711_images() as $line ) {
		$key = hh_img_link_key( trim( explode( '|', $line )[0] ) );
		if ( ! isset( $done[ $key ] ) ) {
			return; // Còn ảnh mới chưa tải – chưa gỡ ảnh cũ.
		}
	}
	$old_ids = array();
	foreach ( HH_MASTERI_2711_OLD_IMAGES as $line ) {
		$key = hh_img_link_key( $line );
		if ( isset( $done[ $key ] ) && is_int( $done[ $key ] ) ) {
			$old_ids[] = $done[ $key ];
		}
	}
	foreach ( array( 'hh_p_gallery', 'hh_p_amenities_img', 'hh_p_floorplans', 'hh_p_unit_layouts', 'hh_p_masterplan_img', 'hh_p_progress_gallery' ) as $meta_key ) {
		$ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, $meta_key, true ) ) ) );
		$keep = array_values( array_diff( $ids, $old_ids ) );
		if ( count( $keep ) !== count( $ids ) ) {
			update_post_meta( $post->ID, $meta_key, implode( ',', $keep ) );
		}
	}
	$hero = $done[ hh_img_link_key( 'plugin:img/masteri-rivera-danang/masteri-rivera-danang-phoi-canh-tren-cao-song-cam-le.jpg' ) ] ?? 0;
	if ( is_int( $hero ) && $hero && (int) get_post_thumbnail_id( $post->ID ) !== $hero ) {
		set_post_thumbnail( $post->ID, $hero );
	}
	update_option( 'hh_masteri_img_2026_11_27', 1, false );
	do_action( 'litespeed_purge_all' );
}
add_action( 'admin_init', 'hh_masteri_2711_cleanup' );
add_action( 'hh_img_links_cron', 'hh_masteri_2711_cleanup', 20 );
add_action(
	'init',
	static function () {
		if ( wp_doing_cron() && ! get_option( 'hh_masteri_img_2026_11_27' ) ) {
			hh_masteri_2711_cleanup();
		}
	},
	99
);

/*
 * 27/11/2026 (2): mặt bằng tầng 10 – 19 tháp A, tháp B (tài liệu chủ đầu tư, 3.425 px), tổng mặt bằng có tên đường;
 * diện tích từng loại căn theo mặt bằng chính thức; chính sách 4 ý, tiến độ thêm mốc 7/2025.
 */
function hh_masteri_2711b_images() {
	$d = 'plugin:img/masteri-rivera-danang/masteri-rivera-danang-';
	return array(
		$d . 'mat-bang-tang-10-19-thap-a.jpg | Mặt bằng tầng 10 – 19 tháp A Masteri Rivera Danang: 16 căn/sàn gồm 1PN+, 2PN, 2PN+, 3PN, Dual Key (tài liệu chủ đầu tư Masterise Homes) | mặt bằng',
		$d . 'mat-bang-tang-10-19-thap-b.jpg | Mặt bằng tầng 10 – 19 tháp B Masteri Rivera Danang: 16 căn/sàn gồm 1PN+, 2PN, 2PN+, 3PN, Dual Key (tài liệu chủ đầu tư Masterise Homes) | mặt bằng',
		$d . 'tong-mat-bang-thap-a-b-duong-quy-my-nguyen-lo-trach.jpg | Tổng mặt bằng Masteri Rivera Danang: tháp A, tháp B, hồ bơi và sân vườn nội khu (tài liệu chủ đầu tư) | tổng thể',
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$add   = array_filter( hh_masteri_2711b_images(), static fn( $l ) => false === strpos( $links, trim( explode( '|', $l )[0] ) ) );
			$prog  = (string) ( $p['meta']['hh_p_progress'] ?? '' );
			$upd   = array(
				'hh_p_image_links' => trim( $links . "\n" . implode( "\n", $add ) ),
				'hh_p_unit_area'   => 'Khoảng 47 – 101 m² thông thủy (52,8 – 113,2 m² tim tường)',
				'hh_p_unit_types'  => "Căn 1PN+ | 47,4 m² thông thủy | 1+ | Khoảng 4,13 – 4,51 tỷ\nCăn 2PN | 66,6 – 68,7 m² thông thủy | 2 | Khoảng 5,14 – 6,3 tỷ\nCăn 2PN+ | 76,2 m² thông thủy | 2+ | Khoảng 5,9 – 6,65 tỷ\nCăn 3PN | 78,7 – 79,2 m² thông thủy | 3 | Khoảng 6,68 – 8,11 tỷ\nDual Key | 101,3 m² thông thủy | 2 cửa vào riêng | Khoảng 9,43 – 10,34 tỷ",
				'hh_p_policy'      => "Thanh toán theo tiến độ chuẩn của chủ đầu tư\nThanh toán sớm để nhận chiết khấu cao hơn\nKết hợp vay ngân hàng, có hỗ trợ lãi suất theo từng đợt chính sách\nKhách hàng là người Đà Nẵng thường có ưu đãi thêm",
				'hh_p_progress'    => false === strpos( $prog, '7/2025 |' ) ? str_replace( "\n8/2025 |", "\n7/2025 | Khai trương văn phòng bán hàng, căn hộ mẫu và sa bàn tại 50 Quy Mỹ\n8/2025 |", $prog ) : $prog,
			);
			// Bản 2.20.395 đã ghi chính sách 4 ý (ý cuối dài) lên web → thay bằng bản ngắn.
			$p['fix_meta']['hh_p_policy'] = array_merge( (array) ( $p['fix_meta']['hh_p_policy'] ?? array() ), array( "Thanh toán theo tiến độ chuẩn của chủ đầu tư\nThanh toán sớm để nhận chiết khấu cao hơn\nKết hợp vay ngân hàng, có hỗ trợ lãi suất theo từng đợt chính sách\nKhách hàng là người Đà Nẵng thường có ưu đãi thêm; đặt cọc, chiết khấu và tiến độ thay đổi theo từng đợt – liên hệ Hoàng Hiệp 0904 567 009" ) );
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
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	55
);

/** Danh sách ảnh trên web chưa có mặt bằng tầng (đợt 2): nối thêm rồi đưa vào hàng chờ tải. */
function hh_masteri_2711b_links() {
	if ( get_option( 'hh_masteri_img_2026_11_27b' ) ) {
		return;
	}
	$post = get_page_by_path( 'masteri-da-nang', OBJECT, 'du-an' );
	if ( ! $post ) {
		return;
	}
	$cur = (string) get_post_meta( $post->ID, 'hh_p_image_links', true );
	$add = array_filter( hh_masteri_2711b_images(), static fn( $l ) => false === strpos( $cur, trim( explode( '|', $l )[0] ) ) );
	if ( $add ) {
		update_post_meta( $post->ID, 'hh_p_image_links', trim( $cur . "\n" . implode( "\n", $add ) ) );
	}
	if ( function_exists( 'hh_img_links_queue' ) ) {
		hh_img_links_queue( $post->ID );
	}
	update_option( 'hh_masteri_img_2026_11_27b', 1, false );
}
add_action( 'admin_init', 'hh_masteri_2711b_links' );
add_action(
	'init',
	static function () {
		if ( wp_doing_cron() && ! get_option( 'hh_masteri_img_2026_11_27b' ) ) {
			hh_masteri_2711b_links();
		}
	},
	99
);

/*
 * 27/11/2026 (3): đủ mặt bằng tầng 4 – 9, 20, 21 – 24, 25 – 29, 30 – 37 hai tháp và mặt bằng 5 loại căn
 * theo trang sản phẩm chính thức của Masterise Homes (masterisehomes.com/masteri-rivera-danang/san-pham);
 * diện tích theo bảng căn hộ chính thức (tim tường / thông thủy).
 */
function hh_masteri_2711c_images() {
	$d   = 'plugin:img/masteri-rivera-danang/masteri-rivera-danang-';
	$src = ' (tài liệu chủ đầu tư Masterise Homes)';
	$out = array();
	foreach ( array( 'a' => 'A', 'b' => 'B' ) as $k => $t ) {
		foreach ( array( '4-9' => '4 – 9', '20' => '20', '21-24' => '21 – 24', '25-29' => '25 – 29', '30-37' => '30 – 37' ) as $f => $lb ) {
			$out[] = $d . 'mat-bang-tang-' . $f . '-thap-' . $k . '.jpg | Mặt bằng tầng ' . $lb . ' tháp ' . $t . ' Masteri Rivera Danang' . $src . ' | mặt bằng';
		}
	}
	$out[] = $d . 'mat-bang-can-1pn-plus.jpg | Mặt bằng căn 1PN+ Masteri Rivera Danang: 47,4 – 47,7 m² thông thủy' . $src . ' | layout';
	$out[] = $d . 'mat-bang-can-2pn.jpg | Mặt bằng căn 2PN Masteri Rivera Danang: 66,5 – 68,8 m² thông thủy' . $src . ' | layout';
	$out[] = $d . 'mat-bang-can-2pn-plus.jpg | Mặt bằng căn 2PN+ Masteri Rivera Danang: 76,2 – 76,9 m² thông thủy' . $src . ' | layout';
	$out[] = $d . 'mat-bang-can-3pn.jpg | Mặt bằng căn 3PN Masteri Rivera Danang: 78,6 – 80,0 m² thông thủy' . $src . ' | layout';
	$out[] = $d . 'mat-bang-can-dual-key.jpg | Mặt bằng căn Dual Key Masteri Rivera Danang: 101,2 – 102,1 m² thông thủy, 2 cửa vào riêng' . $src . ' | layout';
	return $out;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$add   = array_filter( hh_masteri_2711c_images(), static fn( $l ) => false === strpos( $links, trim( explode( '|', $l )[0] ) ) );
			$old   = array(
				'hh_p_unit_area'  => 'Khoảng 47 – 101 m² thông thủy (52,8 – 113,2 m² tim tường)',
				'hh_p_unit_types' => "Căn 1PN+ | 47,4 m² thông thủy | 1+ | Khoảng 4,13 – 4,51 tỷ\nCăn 2PN | 66,6 – 68,7 m² thông thủy | 2 | Khoảng 5,14 – 6,3 tỷ\nCăn 2PN+ | 76,2 m² thông thủy | 2+ | Khoảng 5,9 – 6,65 tỷ\nCăn 3PN | 78,7 – 79,2 m² thông thủy | 3 | Khoảng 6,68 – 8,11 tỷ\nDual Key | 101,3 m² thông thủy | 2 cửa vào riêng | Khoảng 9,43 – 10,34 tỷ",
			);
			$upd   = array(
				'hh_p_image_links' => trim( $links . "\n" . implode( "\n", $add ) ),
				'hh_p_unit_area'   => 'Khoảng 47 – 102 m² thông thủy (52,8 – 113,2 m² tim tường)',
				'hh_p_unit_types'  => "Căn 1PN+ | 47,4 – 47,7 m² thông thủy | 1+ | Khoảng 4,13 – 4,51 tỷ\nCăn 2PN | 66,5 – 68,8 m² thông thủy | 2 | Khoảng 5,14 – 6,3 tỷ\nCăn 2PN+ | 76,2 – 76,9 m² thông thủy | 2+ | Khoảng 5,9 – 6,65 tỷ\nCăn 3PN | 78,6 – 80,0 m² thông thủy | 3 | Khoảng 6,68 – 8,11 tỷ\nDual Key | 101,2 – 102,1 m² thông thủy | 2 cửa vào riêng | Khoảng 9,43 – 10,34 tỷ",
			);
			foreach ( $upd as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( $cur === $v ) {
					continue;
				}
				$p['fix_meta'][ $k ] = array_values( array_filter( array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur, $old[ $k ] ?? '' ) ) ) );
				$p['meta'][ $k ]     = $v;
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	56
);

/** Nối mặt bằng các tầng còn lại và mặt bằng căn vào danh sách ảnh trên web rồi đưa vào hàng chờ tải. */
function hh_masteri_2711c_links() {
	if ( get_option( 'hh_masteri_img_2026_11_27c' ) ) {
		return;
	}
	$post = get_page_by_path( 'masteri-da-nang', OBJECT, 'du-an' );
	if ( ! $post ) {
		return;
	}
	$cur = (string) get_post_meta( $post->ID, 'hh_p_image_links', true );
	$add = array_filter( hh_masteri_2711c_images(), static fn( $l ) => false === strpos( $cur, trim( explode( '|', $l )[0] ) ) );
	if ( $add ) {
		update_post_meta( $post->ID, 'hh_p_image_links', trim( $cur . "\n" . implode( "\n", $add ) ) );
	}
	if ( function_exists( 'hh_img_links_queue' ) ) {
		hh_img_links_queue( $post->ID );
	}
	update_option( 'hh_masteri_img_2026_11_27c', 1, false );
}
add_action( 'admin_init', 'hh_masteri_2711c_links' );
add_action(
	'init',
	static function () {
		if ( wp_doing_cron() && ! get_option( 'hh_masteri_img_2026_11_27c' ) ) {
			hh_masteri_2711c_links();
		}
	},
	99
);

/*
 * 28/11/2026: tên đường mặt tiền theo tổng mặt bằng chính thức của Masterise Homes là "Trần Đăng Ninh" (trước ghi "Nguyễn An Ninh"
 * theo báo chí). Nguồn dữ liệu đã đổi; ở đây ghi bản cũ vào fix_meta / fix_content để web thay giá trị đang hiển thị.
 */
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( (array) ( $p['meta'] ?? array() ) as $k => $v ) {
				if ( is_string( $v ) && false !== strpos( $v, 'Trần Đăng Ninh' ) ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( str_replace( 'Trần Đăng Ninh', 'Nguyễn An Ninh', $v ) ) );
				}
			}
			if ( false !== strpos( (string) ( $p['content'] ?? '' ), 'Trần Đăng Ninh' ) ) {
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( str_replace( 'Trần Đăng Ninh', 'Nguyễn An Ninh', (string) $p['content'] ) ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	1000
);

/** 28/11/2026: sửa thẳng tên đường trong các bài viết Masteri đã đăng (Nguyễn An Ninh → Trần Đăng Ninh), chạy một lần. */
function hh_masteri_2811_street_posts() {
	if ( get_option( 'hh_masteri_street_2026_11_28' ) ) {
		return;
	}
	$done = true;
	foreach ( array( 'can-ho-masteri-rivera-danang-phan-tich', 'masteri-da-nang-gia-tien-do-ban-giao' ) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $p ) {
			$done = false;
			continue;
		}
		if ( false !== strpos( $p->post_content, 'Nguyễn An Ninh' ) || false !== strpos( $p->post_excerpt, 'Nguyễn An Ninh' ) ) {
			wp_update_post(
				array(
					'ID'           => $p->ID,
					'post_content' => str_replace( 'Nguyễn An Ninh', 'Trần Đăng Ninh', $p->post_content ),
					'post_excerpt' => str_replace( 'Nguyễn An Ninh', 'Trần Đăng Ninh', $p->post_excerpt ),
				)
			);
			$hash = get_post_meta( $p->ID, '_hh_news_hash', true );
			if ( $hash ) {
				update_post_meta( $p->ID, '_hh_news_hash', md5( get_post( $p->ID )->post_content ) );
			}
		}
		foreach ( get_post_meta( $p->ID ) as $k => $vals ) {
			$v = maybe_unserialize( $vals[0] ?? '' );
			if ( is_string( $v ) && false !== strpos( $v, 'Nguyễn An Ninh' ) ) {
				update_post_meta( $p->ID, $k, str_replace( 'Nguyễn An Ninh', 'Trần Đăng Ninh', $v ) );
			}
		}
	}
	if ( $done ) {
		update_option( 'hh_masteri_street_2026_11_28', 1, false );
	}
}
add_action( 'admin_init', 'hh_masteri_2811_street_posts', 30 );
add_action( 'init', static function () {
	if ( wp_doing_cron() ) {
		hh_masteri_2811_street_posts();
	}
}, 120 );
