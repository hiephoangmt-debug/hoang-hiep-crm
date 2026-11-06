<?php
/**
 * Tin bán biệt thự BIỂN Đà Nẵng – tổng hợp tin rao công khai ngày 06/11/2026 (alonhadat, mục Bán biệt thự Đà Nẵng).
 * Chỉ lấy căn mặt biển / cách biển trong khoảng 500 m (Mỹ Khê, Mân Thái, Phạm Văn Đồng, Non Nước).
 * Chỉ lấy thông số (tên đường / khu, diện tích, số tầng, phòng ngủ, hướng, giá); KHÔNG ghi số nhà, tên,
 * số điện thoại người đăng, KHÔNG dùng ảnh của tin rao – ảnh thẻ tin tự vẽ (wordpress/bai-viet/biet-thu-ban-11-2026-anh.py).
 * Bỏ các số dòng tiền / doanh thu người đăng tự công bố. Nhập cùng nút Nhập dữ liệu (hh_import_single_listings).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_single_listing_dataset',
	static function ( $list ) {
		$bt = array(
			array(
				'slug'  => 'ban-biet-thu-bien-tay-an-thuong-mat-tien-tran-bach-dang-300m2',
				'title' => 'Bán biệt thự biển 5 tầng mặt tiền Trần Bạch Đằng, phố Tây An Thượng – 300 m², ngang 15 m, sát biển Mỹ Khê – 125 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'biet-thu-bien-tran-bach-dang-an-thuong-300m2', 'price' => 125000,
				'addr'  => 'Mặt tiền Trần Bạch Đằng, khu phố Tây An Thượng, Mỹ An, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Trần Bạch Đằng, An Thượng, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 300, 'w' => 15, 'floors' => 5, 'beds' => 11, 'road' => 0, 'dir' => '', 'sea' => 'Sát biển Mỹ Khê',
				'lead'  => 'villa <strong>5 tầng, 11 phòng ngủ</strong> mặt tiền đường Trần Bạch Đằng – khu phố Tây An Thượng, sát biển Mỹ Khê. Đất <strong>300 m²</strong>, mặt tiền ngang <strong>15 m</strong> – hiếm trong khu.',
				'feat'  => array( 'Sát biển Mỹ Khê, phố Tây An Thượng', 'Mặt tiền Trần Bạch Đằng, ngang 15 m', 'Đất 300 m², 5 tầng, 11 phòng ngủ', 'Phù hợp ở hoặc khai thác lưu trú cao cấp' ),
			),
			array(
				'slug'  => 'ban-villa-bien-nguyen-van-thoai-an-hai-240m2-cach-bien-my-khe-150m',
				'title' => 'Bán villa biển đường Nguyễn Văn Thoại, cách biển Mỹ Khê 150 m – 240 m², 3 tầng, 8 phòng ngủ – 64,5 tỷ',
				'area'  => 'son-tra', 'img' => 'villa-bien-nguyen-van-thoai-240m2', 'price' => 64500,
				'addr'  => 'Đường Nguyễn Văn Thoại, An Hải, Sơn Trà, Đà Nẵng',
				'map'   => 'Nguyễn Văn Thoại, Sơn Trà, Đà Nẵng',
				'm2' => 240, 'w' => 0, 'floors' => 3, 'beds' => 8, 'road' => 0, 'dir' => '', 'sea' => 'Khoảng 150 m ra biển Mỹ Khê',
				'lead'  => 'villa <strong>3 tầng, 8 phòng ngủ</strong> trên đường Nguyễn Văn Thoại – trục ra biển Mỹ Khê, đi bộ khoảng <strong>150 m</strong> ra bãi tắm. Đất <strong>240 m²</strong>; bố trí căn penthouse chủ nhà và các căn hộ cho thuê.',
				'feat'  => array( 'Khoảng 150 m ra biển Mỹ Khê', 'Đất 240 m², 3 tầng, 8 phòng ngủ', 'Bố trí ở + căn hộ cho thuê', 'Trục Nguyễn Văn Thoại – khu khách sạn, nhà hàng' ),
			),
			array(
				'slug'  => 'ban-biet-thu-le-manh-trinh-son-tra-234m2-5-tang-thang-may-gan-bien',
				'title' => 'Bán biệt thự 5 tầng có thang máy đường Lê Mạnh Trinh, Sơn Trà – 234 m², cách biển 200 m – 59 tỷ',
				'area'  => 'son-tra', 'img' => 'biet-thu-le-manh-trinh-234m2-5-tang', 'price' => 59000,
				'addr'  => 'Đường Lê Mạnh Trinh, An Hải, Sơn Trà, Đà Nẵng',
				'map'   => 'Lê Mạnh Trinh, Sơn Trà, Đà Nẵng',
				'm2' => 234, 'w' => 12, 'floors' => 5, 'beds' => 5, 'road' => 0, 'dir' => 'dong', 'sea' => 'Khoảng 200 m ra biển',
				'lead'  => 'biệt thự thiết kế tối giản <strong>5 tầng có thang máy</strong>, 5 phòng ngủ (có thể chia 7), đường Lê Mạnh Trinh – cách biển khoảng <strong>200 m</strong>. Đất <strong>234 m²</strong>, ngang khoảng 12 m, hướng Đông.',
				'feat'  => array( 'Cách biển khoảng 200 m', '5 tầng, thang máy, 5 – 7 phòng ngủ', 'Đất 234 m², ngang khoảng 12 m', 'Hướng Đông' ),
			),
			array(
				'slug'  => 'ban-biet-thu-3-tang-pham-quang-anh-gan-bien-my-khe-357m2',
				'title' => 'Bán biệt thự 3 tầng mặt tiền Phạm Quang Ảnh, gần biển Mỹ Khê – khoảng 360 m², hướng Đông – 45 tỷ',
				'area'  => 'son-tra', 'img' => 'biet-thu-pham-quang-anh-gan-bien-357m2', 'price' => 45000,
				'addr'  => 'Mặt tiền đường Phạm Quang Ảnh, An Hải, Sơn Trà, Đà Nẵng',
				'map'   => 'Phạm Quang Ảnh, Sơn Trà, Đà Nẵng',
				'm2' => 357, 'w' => 0, 'floors' => 3, 'beds' => 0, 'road' => 0, 'dir' => 'dong', 'sea' => 'Gần biển Mỹ Khê',
				'lead'  => 'biệt thự <strong>3 tầng</strong> mặt tiền đường Phạm Quang Ảnh – khu phố du lịch gần biển Mỹ Khê. Đất khoảng <strong>357 – 366 m²</strong> (tin rao ghi hai con số), hướng Đông.',
				'feat'  => array( 'Gần biển Mỹ Khê, khu phố du lịch', 'Đất khoảng 360 m², hướng Đông', 'Mặt tiền Phạm Quang Ảnh', 'Có thương lượng' ),
			),
			array(
				'slug'  => 'ban-biet-thu-premier-village-vo-nguyen-giap-my-an-300m2-sat-bien',
				'title' => 'Bán biệt thự Premier Village mặt tiền Võ Nguyên Giáp, Mỹ An – 300 m², sát biển Mỹ Khê – 42 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'biet-thu-premier-village-vo-nguyen-giap-300m2', 'price' => 42000,
				'addr'  => 'Khu biệt thự Premier Village, mặt tiền Võ Nguyên Giáp, Mỹ An, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Premier Village Danang Resort, Võ Nguyên Giáp, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 300, 'w' => 15, 'floors' => 3, 'beds' => 5, 'road' => 0, 'dir' => 'dong', 'sea' => 'Sát biển Mỹ Khê',
				'lead'  => 'biệt thự <strong>3 tầng, 5 phòng ngủ</strong> trong khu biệt thự Premier Village, mặt tiền Võ Nguyên Giáp, <strong>sát biển Mỹ Khê</strong>, cạnh phố Tây An Thượng. Đất <strong>300 m²</strong> (15 × 20 m), hướng Đông.',
				'feat'  => array( 'Sát biển Mỹ Khê, cạnh phố Tây An Thượng', 'Đất 300 m² (15 × 20 m), hướng Đông', '3 tầng, 5 phòng ngủ', 'Khu biệt thự Premier Village' ),
			),
			array(
				'slug'  => 'ban-villa-goc-che-lan-vien-my-an-1-phut-ra-bien-ho-boi',
				'title' => 'Bán villa góc mới đường Chế Lan Viên, Mỹ An – 1 phút ra biển, hồ bơi lớn, 4 tầng – 20 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-goc-che-lan-vien-110m2', 'price' => 20000,
				'addr'  => 'Đường Chế Lan Viên, Mỹ An, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Chế Lan Viên, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 110, 'w' => 0, 'floors' => 4, 'beds' => 4, 'road' => 0, 'dir' => 'nam', 'sea' => 'Khoảng 1 phút ra biển',
				'lead'  => 'villa <strong>lô góc, mới 100%, 4 tầng, 4 phòng ngủ</strong>, hồ bơi lớn và sân thượng – đường Chế Lan Viên, đi bộ khoảng 1 phút ra biển. Đất khoảng <strong>110 m²</strong>, hướng Nam.',
				'feat'  => array( 'Khoảng 1 phút ra biển', 'Lô góc, mới 100%', 'Hồ bơi lớn, sân thượng', '4 tầng, 4 phòng ngủ, hướng Nam' ),
			),
			array(
				'slug'  => 'ban-villa-4-tang-sat-bien-phuoc-truong-5-son-tra-80m2',
				'title' => 'Bán villa 4 tầng sát biển đường Phước Trường 5, Sơn Trà – 80 m², hướng Đông Bắc – 18,2 tỷ',
				'area'  => 'son-tra', 'img' => 'villa-phuoc-truong-5-sat-bien-80m2', 'price' => 18200,
				'addr'  => 'Đường Phước Trường 5, Phước Mỹ, Sơn Trà, Đà Nẵng',
				'map'   => 'Phước Trường 5, Sơn Trà, Đà Nẵng',
				'm2' => 80, 'w' => 5, 'floors' => 4, 'beds' => 4, 'road' => 0, 'dir' => 'dong-bac', 'sea' => 'Sát biển Phạm Văn Đồng',
				'lead'  => 'villa <strong>4 tầng, 4 phòng ngủ</strong> đường Phước Trường 5 – khu phố du lịch sát biển Phạm Văn Đồng. Đất <strong>80 m²</strong> (5 × 16 m), hướng Đông Bắc.',
				'feat'  => array( 'Sát biển, khu phố du lịch Phước Mỹ', 'Đất 80 m² (5 × 16 m), hướng Đông Bắc', '4 tầng, 4 phòng ngủ', 'Có thương lượng' ),
			),
			array(
				'slug'  => 'ban-villa-bien-son-thuy-dong-1-ngu-hanh-son-5-tang-cach-bien-200m',
				'title' => 'Bán villa biển xây mới 5 tầng đường Sơn Thủy Đông 1, Ngũ Hành Sơn – cách biển 200 m – 16 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-bien-son-thuy-dong-90m2', 'price' => 16000,
				'addr'  => 'Đường Sơn Thủy Đông 1, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Sơn Thủy Đông 1, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 90, 'w' => 5.5, 'floors' => 5, 'beds' => 5, 'road' => 0, 'dir' => '', 'sea' => 'Khoảng 200 m ra biển',
				'lead'  => 'villa <strong>xây mới 5 tầng, 5 phòng ngủ</strong> đường Sơn Thủy Đông 1 – khu bãi tắm Sơn Thủy, cách biển khoảng <strong>200 m</strong>. Đất <strong>90 m²</strong>, ngang 5,5 m.',
				'feat'  => array( 'Mới 100%, cách biển khoảng 200 m', 'Khu bãi tắm Sơn Thủy', '5 tầng, 5 phòng ngủ', 'Đất 90 m², ngang 5,5 m' ),
			),
			array(
				'slug'  => 'ban-villa-bien-3-tang-da-man-dong-4-khue-my-135m2-ho-boi',
				'title' => 'Bán villa biển 3 tầng có hồ bơi đường Đa Mặn Đông 4, Khuê Mỹ – 135 m², 7 phòng ngủ – 11,8 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-bien-da-man-dong-135m2', 'price' => 11800,
				'addr'  => 'Đường Đa Mặn Đông 4, Khuê Mỹ, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Đa Mặn Đông 4, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 135, 'w' => 0, 'floors' => 3, 'beds' => 7, 'road' => 0, 'dir' => '', 'sea' => 'Khoảng 3 – 5 phút ra biển Mỹ Khê',
				'lead'  => 'villa <strong>3 tầng, 7 phòng ngủ, có hồ bơi</strong> đường Đa Mặn Đông 4, Khuê Mỹ – khoảng 3 – 5 phút ra biển Mỹ Khê. Đất <strong>135 m²</strong>.',
				'feat'  => array( 'Khoảng 3 – 5 phút ra biển Mỹ Khê', 'Hồ bơi, 7 phòng ngủ', 'Đất 135 m², 3 tầng', 'Phù hợp ở hoặc cho thuê lưu trú' ),
			),
			array(
				'slug'  => 'ban-villa-4-tang-ho-boi-sat-bien-man-thai-son-tra-duong-vo-duy-ninh',
				'title' => 'Bán villa 4 tầng hồ bơi riêng sát biển Mân Thái, đường Võ Duy Ninh, Sơn Trà – 8,95 tỷ',
				'area'  => 'son-tra', 'img' => 'villa-vo-duy-ninh-man-thai-4-tang', 'price' => 8950,
				'addr'  => 'Đường Võ Duy Ninh, Mân Thái, Sơn Trà, Đà Nẵng',
				'map'   => 'Võ Duy Ninh, Sơn Trà, Đà Nẵng',
				'm2' => 63.2, 'w' => 5, 'floors' => 4, 'beds' => 4, 'road' => 0, 'dir' => 'dong-nam', 'sea' => 'Khoảng 200 m ra biển Mân Thái',
				'lead'  => 'villa <strong>4 tầng, 4 phòng ngủ, hồ bơi riêng</strong>, phòng xông hơi – đường Võ Duy Ninh, cách biển Mân Thái khoảng <strong>200 m</strong>. Đất <strong>khoảng 63 m²</strong> (ngang 5 m), hướng Đông Nam.',
				'feat'  => array( 'Hồ bơi riêng, phòng xông hơi', 'Cách biển Mân Thái khoảng 200 m', '4 tầng, 4 phòng ngủ', 'Hướng Đông Nam, chủ cần bán' ),
			),
			array(
				'slug'  => 'ban-villa-4-tang-ho-boi-tran-van-thanh-khue-my-cach-bien-my-khe-400m',
				'title' => 'Bán villa 4 tầng có hồ bơi đường Trần Văn Thành, Khuê Mỹ – cách biển Mỹ Khê 400 m – 8,6 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-tran-van-thanh-khue-my-4-tang', 'price' => 8600,
				'addr'  => 'Đường Trần Văn Thành, Khuê Mỹ, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Trần Văn Thành, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 50, 'w' => 5.5, 'floors' => 4, 'beds' => 4, 'road' => 0, 'dir' => '', 'sea' => 'Khoảng 400 m ra biển Mỹ Khê',
				'lead'  => 'villa <strong>4 tầng, 4 phòng ngủ, có hồ bơi</strong> đường Trần Văn Thành, Khuê Mỹ – cách biển Mỹ Khê khoảng <strong>400 m</strong>. Đất <strong>50 m²</strong>, ngang 5,5 m.',
				'feat'  => array( 'Cách biển Mỹ Khê khoảng 400 m', 'Hồ bơi, 4 phòng ngủ', '4 tầng, đất 50 m², ngang 5,5 m', 'Phù hợp cho thuê lưu trú' ),
			),
			array(
				'slug'  => 'ban-villa-mini-3-tang-ho-boi-duong-tra-lo-hoa-hai-ngu-hanh-son',
				'title' => 'Bán villa mini 3 tầng có hồ bơi đường Trà Lộ, Hòa Hải, gần biển Non Nước – 100 m² – 7,5 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-mini-tra-lo-hoa-hai-100m2', 'price' => 7500,
				'addr'  => 'Đường Trà Lộ, Hòa Hải, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Trà Lộ, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 100, 'w' => 5, 'floors' => 3, 'beds' => 3, 'road' => 5.5, 'dir' => 'nam', 'sea' => 'Khoảng 400 m ra biển',
				'lead'  => 'villa mini <strong>3 tầng mới, có hồ bơi</strong>, 3 phòng ngủ, full nội thất – đường Trà Lộ (5,5 m), cách biển khoảng <strong>400 m</strong>. Đất <strong>100 m²</strong> (5 × 20 m), hướng Nam.',
				'feat'  => array( 'Mới 100%, hồ bơi, full nội thất', 'Cách biển khoảng 400 m', 'Đất 100 m² (5 × 20 m), hướng Nam', '3 tầng, 3 phòng ngủ' ),
			),
		);
		$fmt = static fn( $n ) => str_replace( '.', ',', (string) $n );
		foreach ( $bt as $k ) {
			$gia  = rtrim( rtrim( number_format( $k['price'] / 1000, 2, ',', '.' ), '0' ), ',' ) . ' tỷ';
			$rows = array_filter(
				array(
					'Vị trí'          => $k['addr'],
					'Khoảng cách biển' => $k['sea'],
					'Diện tích đất'   => $fmt( $k['m2'] ) . ' m²' . ( $k['w'] ? ' (ngang ' . $fmt( $k['w'] ) . ' m)' : '' ),
					'Số tầng'         => $fmt( $k['floors'] ) . ' tầng',
					'Phòng ngủ'       => $k['beds'] ? $k['beds'] . ' phòng ngủ' : '',
					'Đường trước nhà' => $k['road'] ? $fmt( $k['road'] ) . ' m' : '',
					'Hướng'           => $k['dir'] ? HH_DIRECTIONS[ $k['dir'] ] : '',
					'Giá'             => $gia . ' – có thương lượng',
				)
			);
			$tbl = '';
			foreach ( $rows as $th => $td ) {
				$tbl .= '<tr><th>' . esc_html( $th ) . '</th><td>' . esc_html( $td ) . '</td></tr>';
			}
			$list[] = array(
				'rev'     => 2,
				'slug'    => $k['slug'],
				'title'   => $k['title'],
				'excerpt' => wp_strip_all_tags( 'Bán ' . $k['lead'] ) . ' Giá ' . $gia . '.',
				'kind'    => 'biet-thu',
				'area'    => $k['area'],
				'image'   => 'img/nha-dat/' . $k['img'] . '.jpg', // Ảnh 3:2 (bản 2) – tin đã nhập tự đổi ảnh khi rev tăng.
				'alt'     => wp_strip_all_tags( $k['title'] ),
				'meta'    => array_filter(
					array(
						'hh_deal'        => 'ban',
						'hh_status'      => 'con-hang',
						'hh_price'       => $k['price'],
						'hh_negotiable'  => '1',
						'hh_address'     => $k['addr'],
						'hh_map_address' => $k['map'],
						'hh_area'        => $k['m2'],
						'hh_width'       => $k['w'] ?: '',
						'hh_floors'      => $k['floors'],
						'hh_bedrooms'    => $k['beds'] ?: '',
						'hh_road'        => $k['road'] ?: '',
						'hh_direction'   => $k['dir'],
						'hh_features'    => implode( "\n", $k['feat'] ),
					),
					static fn( $v ) => '' !== $v && null !== $v
				),
				'content' => '<p>Bán ' . $k['lead'] . ' Giá <strong>' . esc_html( $gia ) . '</strong>, có thương lượng.</p>
<h2>Thông tin chính</h2>
<table><tbody>' . $tbl . '</tbody></table>
<h2>Trước khi đặt cọc mua biệt thự biển, cần kiểm tra</h2>
<ul>
<li><strong>Pháp lý</strong>: sổ hồng, đất ở hay đất thương mại dịch vụ (có thời hạn), giấy phép xây dựng và hoàn công đúng số tầng hiện trạng.</li>
<li><strong>Quy hoạch ven biển</strong>: lộ giới, chỉ giới xây dựng, tầng cao được phép; với lô sát biển, kiểm tra hành lang bảo vệ bờ biển.</li>
<li><strong>Hiện trạng</strong>: nhà gần biển dễ ăn mòn do hơi muối – xem kết cấu, cửa, lan can, hồ bơi, thang máy, điện nước.</li>
<li><strong>Khai thác cho thuê</strong>: nếu mua để cho thuê lưu trú, kiểm tra giấy phép kinh doanh, PCCC và doanh thu thực tế – không dựa vào số người bán tự công bố.</li>
</ul>
<p>Thông tin tổng hợp từ tin rao bán công khai tháng 11/2026; giá và tình trạng có thể thay đổi. Hoàng Hiệp kiểm tra tình trạng tin, pháp lý và hẹn xem thực tế – liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem thêm <a href="/mua-ban/biet-thu/">các biệt thự biển đang bán tại Đà Nẵng</a>.</p>',
			);
		}
		return $list;
	}
);
