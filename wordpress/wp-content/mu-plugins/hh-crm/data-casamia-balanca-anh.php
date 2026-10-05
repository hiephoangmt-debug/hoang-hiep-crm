<?php
/**
 * Casamia Balanca Hội An – ảnh tổng quan & phối cảnh (anh Hiệp gửi 05/10/2026), đi kèm plugin trong img/casamia-balanca/.
 * 05/10/2026: sơ đồ mặt bằng (5 công viên chủ đề, 8 tiện ích, Park Home / Park Villa), 4 ảnh sự kiện Sound of Balance 25/04/2026,
 * cập nhật tiện ích, điểm nổi bật, liên kết vùng, phân khu, tiến độ, bài giới thiệu.
 * Thêm 4 ảnh nội thất tham khảo (phòng khách, bếp – phòng ăn, phòng ngủ, phòng tắm).
 * Thêm 3 ảnh phân khu nhà vườn (ven sông, đường nội khu, phố thương mại về đêm).
 * Nhập dữ liệu → web tự đưa ảnh vào Thư viện: toàn cảnh làm ảnh đại diện, 3 phối cảnh vào thư viện ảnh / tiện ích.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'casamia-balanca-hoi-an' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old4 = implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-toan-canh.jpg | Phối cảnh toàn cảnh Casamia Balanca Hội An bên sông Cổ Cò | đại diện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ven-kenh.jpg | Dãy biệt thự ven kênh có bến du thuyền riêng – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ho-boi-ven-song.jpg | Biệt thự có hồ bơi riêng hướng sông – Casamia Balanca Hội An | tiện ích',
					'plugin:img/casamia-balanca/casamia-balanca-song-co-co-hoang-hon.jpg | Sông Cổ Cò lúc hoàng hôn giữa khu biệt thự Casamia Balanca | thư viện',
				)
			);
			$old7 = $old4 . "\n" . implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-ven-song.jpg | Phân khu nhà vườn ven sông – Casamia Balanca Hội An | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-duong-noi-khu.jpg | Đường nội khu phân khu nhà vườn rợp hoa giấy – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-pho-dem.jpg | Phố thương mại phân khu nhà vườn về đêm – Casamia Balanca Hội An | tiện ích',
				)
			);
			$old11 = $old7 . "\n" . implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-khach.jpg | Nội thất tham khảo: phòng khách mở ra hồ bơi hướng sông – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-bep-an.jpg | Nội thất tham khảo: bếp và phòng ăn view kênh – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-ngu.jpg | Nội thất tham khảo: phòng ngủ master view sông – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-tam.jpg | Nội thất tham khảo: phòng tắm bồn đứng view sông – Casamia Balanca | thư viện',
				)
			);
			// Thông tin theo sơ đồ mặt bằng CĐT (anh Hiệp gửi 05/10/2026). Ghi đè ô còn đúng bản web đã nhập trước đó.
			$details = function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['casamia-balanca-hoi-an']['meta'] ?? array() ) : array();
			$upd     = hh_casamia_balanca_meta();
			$old     = array_intersect_key( $p['meta'] + $details, $upd );
			$projects[ $i ]['fix_meta'] = array( 'hh_p_image_links' => array( $old4, $old7, $old11 ) ) + $old + ( $p['fix_meta'] ?? array() );
			$projects[ $i ]['meta']     = array_merge( $p['meta'], $upd );
			$projects[ $i ]['content']  = hh_casamia_balanca_content();
			$projects[ $i ]['meta']['hh_p_image_links'] = implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-toan-canh.jpg | Phối cảnh toàn cảnh Casamia Balanca Hội An bên sông Cổ Cò | đại diện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ven-kenh.jpg | Dãy biệt thự ven kênh có bến du thuyền riêng – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ho-boi-ven-song.jpg | Biệt thự có hồ bơi riêng hướng sông – Casamia Balanca Hội An | tiện ích',
					'plugin:img/casamia-balanca/casamia-balanca-song-co-co-hoang-hon.jpg | Sông Cổ Cò lúc hoàng hôn giữa khu biệt thự Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-ven-song.jpg | Phân khu nhà vườn ven sông – Casamia Balanca Hội An | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-duong-noi-khu.jpg | Đường nội khu phân khu nhà vườn rợp hoa giấy – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-nha-vuon-pho-dem.jpg | Phố thương mại phân khu nhà vườn về đêm – Casamia Balanca Hội An | tiện ích',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-khach.jpg | Nội thất tham khảo: phòng khách mở ra hồ bơi hướng sông – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-bep-an.jpg | Nội thất tham khảo: bếp và phòng ăn view kênh – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-ngu.jpg | Nội thất tham khảo: phòng ngủ master view sông – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-noi-that-phong-tam.jpg | Nội thất tham khảo: phòng tắm bồn đứng view sông – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-so-do-mat-bang.jpg | Sơ đồ mặt bằng Casamia Balanca Hội An 31,1 ha: 5 công viên chủ đề, Park Home, Park Villa | tổng thể',
					'plugin:img/casamia-balanca/casamia-balanca-su-kien-sound-of-balance.jpg | Sự kiện Sound of Balance tại Casamia Balanca Hội An ngày 25/04/2026 | tiến độ',
					'plugin:img/casamia-balanca/casamia-balanca-su-kien-khach-hang.jpg | Khách hàng tham dự sự kiện Sound of Balance – Casamia Balanca | tiến độ',
					'plugin:img/casamia-balanca/casamia-balanca-su-kien-tu-van.jpg | Tư vấn khách hàng tại sự kiện Casamia Balanca Hội An | tiến độ',
					'plugin:img/casamia-balanca/casamia-balanca-su-kien-tai-lieu.jpg | Khách hàng xem tài liệu dự án tại sự kiện Casamia Balanca | tiến độ',
				)
			);
		}
		return $projects;
	},
	60
);

function hh_casamia_balanca_meta() {
	return array(
		'hh_p_type'         => 'Nhà phố vườn (Park Home), biệt thự vườn (Park Villa), biệt thự ven kênh, shophouse',
		'hh_p_highlights'   => "Khu đô thị sinh thái 31,1 ha bên sông Cổ Cò, hướng vịnh Cửa Đại – Hội An\n5 công viên chủ đề: Wellness, Sport Park, Grand Central Park, Floral Park, Nipa Park\nBể bơi tiêu chuẩn Olympic, hồ vô cực, gym & fitness, co-working, coffee & bistro trong Grand Central Park\nKhách sạn 5*, sky bar, trung tâm hội nghị, bể bơi vô cực ven sông\nBiệt thự ven kênh có hồ bơi riêng, bến thuyền trước nhà\nTrục đường Võ Chí Công – hướng sân bay Đà Nẵng và sân bay Chu Lai; pháp lý sở hữu lâu dài",
		'hh_p_amenities_in' => "Công viên Wellness: vườn yoga, đường dạo sinh thái\nSport Park: sân bóng rổ, hệ thống sân Pickleball\nGrand Central Park: quảng trường, hồ vô cực, trạm đọc, co-working space, coffee & bistro, gym & fitness, zone game\nBể bơi tiêu chuẩn Olympic, khu vui chơi trẻ em, khu gym ngoài trời\nFloral Park: công viên hoa giấy\nNipa Park: đường dạo rừng dừa, cầu cảng, lầu vọng cảnh, tiểu cảnh check-in\nCổng chào hoa giấy\nTrung tâm thương mại\nTrường mầm non quốc tế\nBungalow ven sông\nBể bơi vô cực\nKhách sạn 5*\nSky bar\nTrung tâm hội nghị\nBến du thuyền",
		'hh_p_connections'  => "Đường Võ Chí Công | Hướng đi sân bay Đà Nẵng và sân bay Chu Lai\nGiáp sông Cổ Cò | Bến thuyền, cầu cảng, biệt thự hướng sông\nVịnh Cửa Đại | Ra biển Cửa Đại, An Bàng\nRừng dừa Bảy Mẫu | Khu dự trữ sinh quyển Cù Lao Chàm – Hội An\nPhố cổ Hội An | Di sản văn hóa thế giới UNESCO\nCổng chào hoa giấy | Lối vào chính từ đường Võ Chí Công",
		'hh_p_zones'        => "Park Home | Nhà phố vườn ven các công viên chủ đề | Theo bảng hàng | Liên hệ nhận bảng hàng\nPark Villa | Biệt thự vườn dọc trục đường La Riva | Theo bảng hàng | Liên hệ nhận bảng hàng\nLa Riva | Biệt thự ven kênh, hồ bơi riêng, bến thuyền (theo phối cảnh CĐT) | Theo bảng hàng | Liên hệ nhận bảng hàng\nLa Palma | Biệt thự ven sông Cổ Cò (theo phối cảnh CĐT) | Theo bảng hàng | Liên hệ nhận bảng hàng",
		'hh_p_progress'     => "2022 | Khởi công hạ tầng\n6/2025 | Ra mắt dự án\n25/4/2026 | Sự kiện Sound of Balance gặp gỡ khách hàng tại Casamia Balanca\n2025 – 2026 | Bàn giao (dự kiến)",
	);
}

function hh_casamia_balanca_content() {
	return <<<'HTML'
<p><strong>Casamia Balanca Hội An</strong> là khu đô thị sinh thái 31,1 ha của Tập đoàn Đạt Phương bên sông Cổ Cò, hướng vịnh Cửa Đại, nằm giữa rừng dừa Bảy Mẫu – Khu dự trữ sinh quyển thế giới Cù Lao Chàm – Hội An. Dự án gồm nhà phố vườn Park Home, biệt thự vườn Park Villa và các dãy biệt thự ven kênh có hồ bơi riêng, bến thuyền trước nhà.</p>

<h2>5 công viên chủ đề trong Casamia Balanca</h2>
<ul>
<li><strong>Công viên Wellness</strong> – vườn yoga, đường dạo sinh thái.</li>
<li><strong>Sport Park</strong> – sân bóng rổ, hệ thống sân Pickleball.</li>
<li><strong>Grand Central Park</strong> – quảng trường, hồ vô cực, trạm đọc, co-working, coffee &amp; bistro, gym &amp; fitness, zone game, bể bơi tiêu chuẩn Olympic, khu vui chơi trẻ em, gym ngoài trời.</li>
<li><strong>Floral Park</strong> – công viên hoa giấy.</li>
<li><strong>Nipa Park</strong> – đường dạo rừng dừa, cầu cảng, lầu vọng cảnh, tiểu cảnh check-in.</li>
</ul>
<p>Cùng với đó là khách sạn 5*, sky bar, trung tâm hội nghị, bể bơi vô cực ven sông, trung tâm thương mại, trường mầm non quốc tế và khu bungalow.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Mua để ở, nghỉ dưỡng gia đình:</strong> Park Home, Park Villa cạnh 5 công viên – tiện ích đi bộ vài phút.</li>
<li><strong>Đầu tư cho thuê nghỉ dưỡng:</strong> biệt thự ven kênh có hồ bơi riêng, bến thuyền – phù hợp khách du lịch Hội An.</li>
</ul>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng hàng từng phân khu, chính sách bán hàng mới nhất và sơ đồ vị trí căn.</p>
HTML;
}
