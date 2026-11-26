<?php
/**
 * Premier Village Đà Nẵng – bổ sung thông tin khu nghỉ dưỡng (anh Hiệp gửi trang giới thiệu dự án 26/11/2026):
 * 111 biệt thự (77 hướng vườn ~300 – 330 m², 28 có lối ra biển ~360 – 390 m², 6 trực diện biển đến ~511 m²), 15 ha,
 * chủ đầu tư Công ty CP Địa Cầu (Sun Group); không ghi Accor vận hành (anh Hiệp báo Accor không còn quản lý, 26/11); tiện ích; 10 ảnh chính thức của khu nghỉ dưỡng.
 * Bổ sung loại căn (Garden View / Ocean Access / Beachfront), liên kết vùng, tiện ích theo trang giới thiệu dự án anh Hiệp gửi 26/11 (viết lại, không ghi tên đơn vị môi giới).
 * Giá thuê tham khảo 11/2026 từ các trang đặt phòng và tin cho thuê (anh Hiệp yêu cầu 26/11).
 * Viết lại bằng lời mình, không ghi tên / số điện thoại đơn vị phân phối. Giá chỉ ghi "chỉ từ".
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'premier-village-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$img = static fn( $f, $cap, $role = 'thư viện' ) => "plugin:img/premier-village/$f.jpg | $cap | $role";
			$upd = array(
				'hh_p_developer'    => 'Công ty CP Địa Cầu – thành viên Tập đoàn Sun Group',
				'hh_p_address'      => '99 Võ Nguyên Giáp (khu Mỹ An cũ), giao Hồ Xuân Hương, bãi biển Mỹ Khê, Đà Nẵng',
				'hh_p_scale'        => 'Khoảng 15 ha',
				'hh_p_units'        => '111 biệt thự: 77 hướng vườn, 28 có lối đi riêng ra biển, 6 trực diện biển',
				'hh_p_unit_area'    => 'Đất khoảng 300 – 330 m² (hướng vườn), 360 – 390 m² (lối ra biển), đến khoảng 511 m² (trực diện biển)',
				'hh_p_resale_price' => 'Chỉ từ khoảng 39 tỷ (tin rao chuyển nhượng 2026, tham khảo)',
				'hh_p_rent_price'   => 'Thuê ngắn ngày chỉ từ khoảng 370 – 390 USD/đêm (căn trực diện biển có thể trên 1.000 USD/đêm) · Thuê nguyên căn theo tháng chỉ từ khoảng 80 triệu/tháng, căn hướng biển khoảng 100 – 120 triệu/tháng (tham khảo 11/2026)',
				'hh_p_resale_note'  => 'Quỹ chỉ 111 căn, không còn hàng mới nên giao dịch thưa nhưng giá giữ tốt. Tiền thuê nguyên căn khoảng 0,96 – 1,2 tỷ/năm, tương đương khoảng 2,5 – 3%/năm trên giá chào – khách mua chủ yếu để giữ tài sản ven biển và dùng cho gia đình. Nhận gửi bán, gửi cho thuê: Hoàng Hiệp 0904 567 009.',
				'hh_p_villa_table'  => "Garden View Villa – hướng vườn (77 căn) | Khoảng 300 – 330 m² | Hồ bơi riêng, vườn riêng | Chỉ từ khoảng 39 tỷ\nOcean Access Villa – có lối ra biển (28 căn) | Khoảng 360 – 390 m² | Lối đi riêng ra biển, hồ bơi riêng | Từ khoảng 47 tỷ\nBeachfront Villa – trực diện biển (6 căn) | Khoảng 511 m² | Sát bãi biển, hồ bơi vô cực riêng, quản gia riêng, ở tối đa 8 người lớn + 4 trẻ em | Liên hệ",
				'hh_p_handover_std' => 'Đã bàn giao, đầy đủ nội thất theo tiêu chuẩn khu nghỉ dưỡng 5 sao, mỗi căn có hồ bơi riêng',
				'hh_p_location_desc' => 'Nằm tại 99 Võ Nguyên Giáp (khu Mỹ An cũ), giao đường Hồ Xuân Hương, ngay trên bãi biển Mỹ Khê – đoạn biển gần trung tâm nhất của Đà Nẵng. Sát phố du lịch An Thượng, vài phút tới cầu Rồng, chợ Hàn; khoảng 10 – 15 phút ra sân bay quốc tế, khoảng 30 – 40 phút tới phố cổ Hội An.',
				'hh_p_connections'  => "3 phút | Phố du lịch An Thượng\n5 phút | Danh thắng Ngũ Hành Sơn\n5 – 7 phút | Cầu Rồng, chợ Hàn\n10 phút | Bệnh viện Vinmec, Hoàn Mỹ\n10 – 15 phút | Sân bay quốc tế Đà Nẵng\n12 phút | Ga Đà Nẵng\n20 – 25 phút | Bán đảo Sơn Trà, chùa Linh Ứng\n30 – 40 phút | Phố cổ Hội An\n45 phút | Bà Nà Hills\n1 giờ | Thánh địa Mỹ Sơn",
				'hh_p_amenities_in' => "Hồ bơi riêng tại từng biệt thự\nHồ bơi Nautica khoảng 550 m² sát biển, hồ trẻ em khoảng 200 m²\nNautica Beach Club, nhà hàng LemonGrass, Cá Chuồn Cồ\nSpa, phòng gym mở cửa 24/7\nCâu lạc bộ trẻ em, khu vui chơi trong nhà và ngoài trời\nPhòng hội nghị khoảng 720 m² (tối đa 150 khách)\nVườn nhiệt đới, lối đi bộ trong khuôn viên khoảng 15 ha\nDịch vụ quản gia, xe điện nội khu, dọn phòng, đầu bếp riêng theo yêu cầu",
				'hh_p_amenities_out' => "Bãi biển Mỹ Khê – ngay trước khu\nPhố du lịch An Thượng – khoảng 3 phút\nVincom Plaza, Lotte Mart, MM Mega Market – trong bán kính khoảng 5 – 10 km\nBệnh viện Vinmec, Hoàn Mỹ, Đa khoa Đà Nẵng – khoảng 10 phút",
				'hh_p_highlights'   => "111 biệt thự trên bãi biển Mỹ Khê, mỗi căn có hồ bơi riêng\nKhu nghỉ dưỡng 5 sao đang hoạt động, biệt thự có thể tham gia chương trình cho thuê\nHồ bơi Nautica khoảng 550 m² cạnh biển, hồ trẻ em khoảng 200 m²\nCâu lạc bộ trẻ em, phòng gym 24/7, phòng hội nghị khoảng 720 m² (tối đa 150 khách)\nNhà hàng LemonGrass và Cá Chuồn Cồ ngay trong khu\nVinh danh khu nghỉ dưỡng biệt thự cho gia đình hàng đầu thế giới 2019 (World Travel Awards)",
				'hh_p_image_links'  => implode(
					"\n",
					array(
						$img( 'premier-village-toan-canh-bien-my-khe', 'Toàn cảnh Premier Village bên bãi biển Mỹ Khê (ảnh khu nghỉ dưỡng)', 'đại diện' ),
						$img( 'premier-village-flycam-biet-thu-ven-bien', 'Biệt thự Premier Village giữa rừng dừa ven biển Mỹ Khê, nhìn từ trên cao' ),
						$img( 'premier-village-flycam-biet-thu-ho-boi-rieng', 'Cụm biệt thự có hồ bơi riêng trong Premier Village' ),
						$img( 'premier-village-biet-thu-huong-vuon', 'Biệt thự hướng vườn Premier Village – vườn riêng, hồ bơi riêng' ),
						$img( 'premier-village-phong-khach-biet-thu', 'Phòng khách biệt thự Premier Village' ),
						$img( 'premier-village-bep-biet-thu', 'Bếp biệt thự Premier Village – tủ lạnh, lò vi sóng, lò nướng' ),
						$img( 'premier-village-ho-boi-nautica-ven-bien', 'Hồ bơi Nautica khoảng 550 m² sát biển, tiện ích Premier Village', 'tiện ích' ),
						$img( 'premier-village-flycam-ho-boi-bai-bien', 'Hồ bơi và bãi biển riêng của khu nghỉ dưỡng Premier Village', 'tiện ích' ),
						$img( 'premier-village-nha-hang-ven-bien', 'Nhà hàng ven biển trong Premier Village', 'tiện ích' ),
						$img( 'premier-village-phong-gym', 'Phòng gym mở cửa 24/7 tại Premier Village', 'tiện ích' ),
					)
				),
			);
			$excerpt = 'Khu nghỉ dưỡng 111 biệt thự của Sun Group trên bãi biển Mỹ Khê (99 Võ Nguyên Giáp), khu nghỉ dưỡng 5 sao đang hoạt động – mỗi căn có hồ bơi riêng; giao dịch chuyển nhượng, giá chỉ từ khoảng 39 tỷ.';
			if ( ( $p['excerpt'] ?? '' ) !== $excerpt ) {
				$projects[ $i ]['fix_excerpt'] = array_merge( (array) ( $p['fix_excerpt'] ?? array() ), array( (string) ( $p['excerpt'] ?? '' ) ) );
				$projects[ $i ]['excerpt']     = $excerpt;
			}
			// Giá trị bản 2.20.356 đã ghi lên web (khác dữ liệu gốc) – cho phép thay bằng bản mới.
			$was = array(
				'hh_p_villa_table' => "Biệt thự hướng vườn (77 căn) | Khoảng 300 – 330 m² | Hồ bơi riêng, vườn riêng | Chỉ từ khoảng 39 tỷ\nBiệt thự có lối ra biển (28 căn) | Khoảng 360 – 390 m² | Lối đi riêng ra biển, hồ bơi riêng | Từ khoảng 47 tỷ\nBiệt thự trực diện biển (6 căn) | Đến khoảng 511 m² | Sát bãi biển, sân thượng cạnh hồ bơi | Liên hệ",
			);
			foreach ( $upd as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( $cur === $v ) {
					continue;
				}
				if ( '' !== trim( $cur ) ) {
					$projects[ $i ]['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) );
				}
				$projects[ $i ]['meta'][ $k ] = $v;
			}
			foreach ( $was as $k => $v ) {
				$projects[ $i ]['fix_meta'][ $k ] = array_merge( (array) ( $projects[ $i ]['fix_meta'][ $k ] ?? array() ), array( $v ) );
			}
		}
		return $projects;
	},
	60
);
