<?php
/**
 * Casamia Hội An – 22 ảnh thực tế khu đã bàn giao (anh Hiệp gửi 14/11/2026), đi kèm plugin trong img/casamia-hoi-an/.
 * Bỏ ảnh có biển hiệu homestay của chủ nhà khác và ảnh chân dung người mẫu. Ảnh văn phòng có bảng hiệu chủ đầu tư (Đạt Phương) – được dùng.
 * Nhập dữ liệu → web tự đưa ảnh vào Thư viện: flycam toàn cảnh làm ảnh đại diện.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$f   = static fn( $n, $alt, $where ) => "plugin:img/casamia-hoi-an/casamia-hoi-an-$n.jpg | $alt | $where";
		$add = array(
			$f( 'toan-canh-flycam-ven-bien', 'Toàn cảnh Casamia Hội An bên sông Cổ Cò, nhìn ra biển Cửa Đại – ảnh thực tế', 'đại diện' ),
			$f( 'flycam-toa-xanh-ho-boi', 'Flycam khu biệt thự, tòa nhà phủ cây xanh và hồ bơi ven sông – Casamia Hội An', 'thư viện' ),
			$f( 'flycam-ho-boi-vuon-dua', 'Hồ bơi lớn giữa vườn dừa cạnh sông – Casamia Hội An, ảnh thực tế', 'tiện ích' ),
			$f( 'song-noi-khu-ben-go', 'Dòng sông nội khu với bến gỗ trước dãy biệt thự – Casamia Hội An', 'thư viện' ),
			$f( 'ho-boi-vo-cuc-ven-song', 'Hồ bơi vô cực nhìn dọc sông nội khu và dãy biệt thự – Casamia Hội An', 'tiện ích' ),
			$f( 'ho-boi-vo-cuc-rung-dua', 'Hồ bơi tràn bờ giữa rừng dừa nước – Casamia Hội An', 'tiện ích' ),
			$f( 'biet-thu-ho-boi-rieng-hoang-hon', 'Biệt thự có hồ bơi riêng lúc hoàng hôn – Casamia Hội An, ảnh thực tế', 'thư viện' ),
			$f( 'ho-boi-rieng-hang-rao-tre', 'Hồ bơi riêng sân sau biệt thự, rào tre và dừa nước – Casamia Hội An', 'thư viện' ),
			$f( 'san-vuon-biet-thu-ve-dem', 'Sân vườn biệt thự về đêm với lối đá và chòi lá – Casamia Hội An', 'thư viện' ),
			$f( 'phong-ngu-ban-cong-view-song', 'Phòng ngủ có ban công nhìn ra sông và dãy biệt thự – Casamia Hội An (nội thất tham khảo)', 'thư viện' ),
			$f( 'ben-go-ngam-song', 'Bến gỗ ngắm sông dưới mái lá – Casamia Hội An', 'thư viện' ),
			$f( 'duong-noi-khu-hang-dua', 'Đường nội khu rợp hàng dừa – Casamia Hội An, ảnh thực tế', 'thư viện' ),
			$f( 'duong-noi-khu-day-biet-thu', 'Dãy biệt thự hai bên đường nội khu nhiều cây xanh – Casamia Hội An', 'thư viện' ),
			$f( 'biet-thu-mat-tien-gach-hoa-gio', 'Mặt tiền biệt thự ốp gạch hoa gió đặc trưng – Casamia Hội An', 'thư viện' ),
			$f( 'duong-noi-khu-cay-xanh', 'Đường nội khu rộng, hai bên cây xanh – Casamia Hội An', 'thư viện' ),
			$f( 'cong-vien-noi-khu-hang-dua', 'Công viên nội khu với dừa và hoa dâm bụt – Casamia Hội An', 'tiện ích' ),
			$f( 'loi-dao-cong-vien-ghe-da', 'Lối dạo bộ có ghế đá dưới tán cây – Casamia Hội An', 'tiện ích' ),
			$f( 'san-choi-tre-em', 'Sân chơi trẻ em trên thảm cỏ – Casamia Hội An', 'tiện ích' ),
			$f( 'vuon-cay-cham-soc-hang-ngay', 'Vườn cây được chăm sóc hằng ngày trong khu – Casamia Hội An', 'thư viện' ),
			$f( 'phong-gym-view-vuon', 'Phòng gym nhìn ra vườn nhiệt đới – Casamia Hội An', 'tiện ích' ),
			$f( 'phong-gym-ve-dem', 'Phòng gym đầy đủ máy tập – Casamia Hội An', 'tiện ích' ),
			$f( 'shophouse-chu-dau-tu', 'Dãy shophouse mặt đường nội khu, văn phòng chủ đầu tư Đạt Phương – Casamia Hội An', 'thư viện' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'casamia-hoi-an' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$new = array_filter( $add, static fn( $l ) => false === strpos( $cur, trim( explode( '|', $l )[0] ) ) );
			if ( ! $new ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $new ) );
			if ( '' !== $cur ) {
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
		}
		return $projects;
	},
	50
);
