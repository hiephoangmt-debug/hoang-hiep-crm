<?php
/**
 * Tin bán biệt thự Đà Nẵng – tổng hợp tin rao công khai ngày 06/11/2026 (alonhadat, mục Bán biệt thự Đà Nẵng).
 * Chỉ lấy thông số (tên đường / khu đô thị, diện tích, số tầng, phòng ngủ, hướng, giá); KHÔNG ghi số nhà, tên,
 * số điện thoại người đăng, KHÔNG dùng ảnh của tin rao – ảnh thẻ tin tự vẽ (wordpress/bai-viet/biet-thu-ban-11-2026-anh.py).
 * Bỏ các số dòng tiền / doanh thu người đăng tự công bố. Nhập cùng nút Nhập dữ liệu (hh_import_single_listings).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_single_listing_dataset',
	static function ( $list ) {
		// slug, tiêu đề, khu-vuc, ảnh, giá (triệu), vị trí, map, m², ngang, tầng, PN, đường, hướng, đoạn mở, đặc điểm.
		$bt = array(
			array(
				'slug'  => 'ban-biet-thu-premier-village-vo-nguyen-giap-my-an-300m2-sat-bien',
				'title' => 'Bán biệt thự Premier Village mặt tiền Võ Nguyên Giáp, Mỹ An – 300 m², sát biển Mỹ Khê – 42 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'biet-thu-premier-village-vo-nguyen-giap-300m2', 'price' => 42000,
				'addr'  => 'Khu biệt thự Premier Village, mặt tiền Võ Nguyên Giáp, Mỹ An, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Premier Village Danang Resort, Võ Nguyên Giáp, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 300, 'w' => 15, 'floors' => 3, 'beds' => 5, 'road' => 0, 'dir' => 'dong',
				'lead'  => 'biệt thự <strong>3 tầng, 5 phòng ngủ</strong> trong khu biệt thự Premier Village, mặt tiền Võ Nguyên Giáp, sát biển Mỹ Khê, cạnh phố Tây An Thượng. Đất <strong>300 m²</strong> (15 × 20 m), hướng Đông.',
				'feat'  => array( 'Sát biển Mỹ Khê, cạnh phố Tây An Thượng', 'Đất 300 m² (15 × 20 m), hướng Đông', '3 tầng, 5 phòng ngủ', 'Khu biệt thự Premier Village' ),
			),
			array(
				'slug'  => 'ban-biet-thu-le-manh-trinh-son-tra-234m2-5-tang-thang-may-gan-bien',
				'title' => 'Bán biệt thự 5 tầng có thang máy đường Lê Mạnh Trinh, Sơn Trà – 234 m², cách biển 200 m – 59 tỷ',
				'area'  => 'son-tra', 'img' => 'biet-thu-le-manh-trinh-234m2-5-tang', 'price' => 59000,
				'addr'  => 'Đường Lê Mạnh Trinh, An Hải, Sơn Trà, Đà Nẵng',
				'map'   => 'Lê Mạnh Trinh, Sơn Trà, Đà Nẵng',
				'm2' => 234, 'w' => 12, 'floors' => 5, 'beds' => 5, 'road' => 0, 'dir' => 'dong',
				'lead'  => 'biệt thự thiết kế tối giản <strong>5 tầng có thang máy</strong>, 5 phòng ngủ (có thể chia 7), đường Lê Mạnh Trinh – cách biển khoảng 200 m. Đất <strong>234 m²</strong>, ngang khoảng 12 m, hướng Đông.',
				'feat'  => array( '5 tầng, thang máy, 5 – 7 phòng ngủ', 'Cách biển khoảng 200 m', 'Đất 234 m², ngang khoảng 12 m', 'Hướng Đông' ),
			),
			array(
				'slug'  => 'ban-biet-thu-3-tang-le-kim-lang-cam-le-400m2-mat-tien-20m',
				'title' => 'Bán biệt thự 3 tầng đường Lê Kim Lăng, Cẩm Lệ – đất 400 m², mặt tiền 20 m – 32 tỷ',
				'area'  => 'cam-le', 'img' => 'biet-thu-le-kim-lang-400m2', 'price' => 32000,
				'addr'  => 'Đường Lê Kim Lăng, Cẩm Lệ, Đà Nẵng',
				'map'   => 'Lê Kim Lăng, Cẩm Lệ, Đà Nẵng',
				'm2' => 400, 'w' => 20, 'floors' => 3, 'beds' => 6, 'road' => 7.5, 'dir' => '',
				'lead'  => 'biệt thự <strong>3 tầng, 6 phòng ngủ</strong> hoàn thiện cao cấp trên đường Lê Kim Lăng (đường 7,5 m). Đất <strong>400 m²</strong> (20 × 20 m), mặt tiền ngang 20 m, sân đậu ô tô.',
				'feat'  => array( 'Đất 400 m² vuông 20 × 20 m', 'Mặt tiền ngang 20 m, đường 7,5 m', '3 tầng, 6 phòng ngủ, hoàn thiện cao cấp', 'Sân đậu ô tô' ),
			),
			array(
				'slug'  => 'ban-biet-thu-nam-viet-a-duong-le-huu-khanh-200m2-7-phong-ngu-ho-boi',
				'title' => 'Bán biệt thự 7 phòng ngủ, hồ bơi riêng đường Lê Hữu Khánh, KĐT Nam Việt Á – 200 m² – 33 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'biet-thu-nam-viet-a-le-huu-khanh-200m2', 'price' => 33000,
				'addr'  => 'Đường Lê Hữu Khánh, KĐT Nam Việt Á, Khuê Mỹ, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Lê Hữu Khánh, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 200, 'w' => 10, 'floors' => 3, 'beds' => 7, 'road' => 7.5, 'dir' => 'bac',
				'lead'  => 'biệt thự cao cấp <strong>3 tầng, 7 phòng ngủ, hồ bơi riêng</strong> trên đường Lê Hữu Khánh, KĐT Nam Việt Á (đường 7,5 m). Đất <strong>200 m²</strong> (10 × 20 m), hướng Bắc, phù hợp ở hoặc khai thác lưu trú.',
				'feat'  => array( 'Hồ bơi riêng, 7 phòng ngủ', 'KĐT Nam Việt Á, đường 7,5 m', 'Đất 200 m² (10 × 20 m), hướng Bắc', 'Phù hợp ở hoặc cho thuê lưu trú' ),
			),
			array(
				'slug'  => 'ban-villa-doan-khue-nam-viet-a-272m2-4-tang-2-ho-boi',
				'title' => 'Bán villa mới 4 tầng, 2 hồ bơi đường Đoàn Khuê, KĐT Nam Việt Á – 272 m² – 35,5 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-doan-khue-nam-viet-a-272m2', 'price' => 35500,
				'addr'  => 'Đường Đoàn Khuê, KĐT Nam Việt Á, Khuê Mỹ, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Đoàn Khuê, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 272, 'w' => 10, 'floors' => 4, 'beds' => 7, 'road' => 0, 'dir' => 'dong',
				'lead'  => 'villa xây mới <strong>4 tầng, 7 phòng ngủ</strong>, tổng sàn khoảng 680 m², có <strong>2 hồ bơi</strong>, phòng gym, xông hơi – đường Đoàn Khuê, KĐT Nam Việt Á. Đất <strong>272 m²</strong> (10 × 27 m), hướng Đông.',
				'feat'  => array( 'Mới 100%, sàn khoảng 680 m²', '2 hồ bơi, gym, xông hơi', '4 tầng, 7 phòng ngủ', 'Đất 272 m² (10 × 27 m), hướng Đông' ),
			),
			array(
				'slug'  => 'ban-biet-thu-goc-2-mat-tien-kdt-hoa-xuan-duong-anh-duc-182m2',
				'title' => 'Bán biệt thự góc 2 mặt tiền đường Anh Đức, KĐT Hòa Xuân – 182 m², 3 tầng – 17 tỷ',
				'area'  => 'cam-le', 'img' => 'biet-thu-goc-hoa-xuan-anh-duc-182m2', 'price' => 17000,
				'addr'  => 'Đường Anh Đức, KĐT Hòa Xuân, Cẩm Lệ, Đà Nẵng',
				'map'   => 'Anh Đức, Hòa Xuân, Cẩm Lệ, Đà Nẵng',
				'm2' => 182, 'w' => 0, 'floors' => 3, 'beds' => 4, 'road' => 7.5, 'dir' => '',
				'lead'  => 'biệt thự <strong>góc 2 mặt tiền, 3 tầng, 4 phòng ngủ</strong> đường Anh Đức, KĐT Hòa Xuân (đường 7,5 m). Đất <strong>182 m²</strong>, đang có khách thuê.',
				'feat'  => array( 'Lô góc 2 mặt tiền', 'KĐT Hòa Xuân, đường 7,5 m', 'Đất 182 m², 3 tầng, 4 phòng ngủ', 'Đang có khách thuê' ),
			),
			array(
				'slug'  => 'ban-biet-thu-goc-tran-van-giap-hai-chau-154m2-4-tang-thang-may',
				'title' => 'Bán biệt thự góc 2 mặt tiền đường Trần Văn Giáp, Hải Châu – 154 m², 4 tầng thang máy – 22,5 tỷ',
				'area'  => 'hai-chau', 'img' => 'biet-thu-goc-tran-van-giap-154m2', 'price' => 22500,
				'addr'  => 'Đường Trần Văn Giáp, Hòa Cường Bắc, Hải Châu, Đà Nẵng',
				'map'   => 'Trần Văn Giáp, Hải Châu, Đà Nẵng',
				'm2' => 154, 'w' => 14, 'floors' => 4, 'beds' => 4, 'road' => 5.5, 'dir' => 'dong-bac',
				'lead'  => 'biệt thự <strong>góc 2 mặt tiền, 4 tầng có thang máy</strong>, 4 phòng ngủ – đường Trần Văn Giáp (5,5 m, vỉa hè 3 m), trung tâm Hải Châu. Đất <strong>154 m²</strong> (14 × 13 m), hướng Đông Bắc – Tây Bắc.',
				'feat'  => array( 'Lô góc 2 mặt tiền, trung tâm Hải Châu', '4 tầng, thang máy, 4 phòng ngủ', 'Đất 154 m², ngang 14 m', 'Đậu ô tô' ),
			),
			array(
				'slug'  => 'ban-villa-3-tang-pham-nhu-tang-thanh-khe-225m2-ngang-10m',
				'title' => 'Bán villa 3 tầng mới, có nội thất đường Phạm Nhữ Tăng, Thanh Khê – 225 m², ngang 10 m – 22 tỷ',
				'area'  => 'thanh-khe', 'img' => 'villa-pham-nhu-tang-225m2', 'price' => 22000,
				'addr'  => 'Đường Phạm Nhữ Tăng, Thanh Khê, Đà Nẵng',
				'map'   => 'Phạm Nhữ Tăng, Thanh Khê, Đà Nẵng',
				'm2' => 225, 'w' => 10, 'floors' => 3, 'beds' => 3, 'road' => 7.5, 'dir' => 'tay-nam',
				'lead'  => 'villa <strong>3 tầng mới, có nội thất</strong>, 3 phòng ngủ – đường Phạm Nhữ Tăng (đường 7,5 m), Thanh Khê. Đất <strong>225 m²</strong> (10 × 23 m), hướng Tây Nam.',
				'feat'  => array( 'Mới xây, có nội thất', 'Đất 225 m², ngang 10 m', 'Đường 7,5 m, hướng Tây Nam', 'Có thương lượng' ),
			),
			array(
				'slug'  => 'ban-biet-thu-3-5-tang-2-mat-tien-an-xuan-thanh-khe-ham-o-to',
				'title' => 'Bán biệt thự 3,5 tầng 2 mặt tiền đường An Xuân, Thanh Khê – có hầm ô tô, 198 m² – 15,5 tỷ',
				'area'  => 'thanh-khe', 'img' => 'biet-thu-an-xuan-thanh-khe-198m2', 'price' => 15500,
				'addr'  => 'Đường An Xuân, An Khê, Thanh Khê, Đà Nẵng',
				'map'   => 'An Xuân, Thanh Khê, Đà Nẵng',
				'm2' => 198, 'w' => 10, 'floors' => 3.5, 'beds' => 4, 'road' => 0, 'dir' => '',
				'lead'  => 'biệt thự <strong>3,5 tầng, 2 mặt tiền, có hầm để ô tô</strong>, 4 phòng ngủ – đường An Xuân, Thanh Khê. Đất <strong>198 m²</strong> (10 × 19,76 m).',
				'feat'  => array( '2 mặt tiền, hầm để ô tô', '3,5 tầng, 4 phòng ngủ', 'Đất 198 m², ngang 10 m', 'Có thương lượng' ),
			),
			array(
				'slug'  => 'ban-villa-4-tang-ho-boi-sat-bien-man-thai-son-tra-duong-vo-duy-ninh',
				'title' => 'Bán villa 4 tầng hồ bơi riêng sát biển Mân Thái, đường Võ Duy Ninh, Sơn Trà – 8,95 tỷ',
				'area'  => 'son-tra', 'img' => 'villa-vo-duy-ninh-man-thai-4-tang', 'price' => 8950,
				'addr'  => 'Đường Võ Duy Ninh, Mân Thái, Sơn Trà, Đà Nẵng',
				'map'   => 'Võ Duy Ninh, Sơn Trà, Đà Nẵng',
				'm2' => 63.2, 'w' => 5, 'floors' => 4, 'beds' => 4, 'road' => 0, 'dir' => 'dong-nam',
				'lead'  => 'villa <strong>4 tầng, 4 phòng ngủ, hồ bơi riêng</strong>, phòng xông hơi – đường Võ Duy Ninh, cách biển Mân Thái khoảng 200 m. Đất <strong>khoảng 63 m²</strong> (ngang 5 m), hướng Đông Nam.',
				'feat'  => array( 'Hồ bơi riêng, phòng xông hơi', 'Cách biển Mân Thái khoảng 200 m', '4 tầng, 4 phòng ngủ', 'Hướng Đông Nam, chủ cần bán' ),
			),
			array(
				'slug'  => 'ban-villa-mini-3-tang-ho-boi-duong-tra-lo-hoa-hai-ngu-hanh-son',
				'title' => 'Bán villa mini 3 tầng có hồ bơi đường Trà Lộ, Hòa Hải, Ngũ Hành Sơn – 100 m² – 7,5 tỷ',
				'area'  => 'ngu-hanh-son', 'img' => 'villa-mini-tra-lo-hoa-hai-100m2', 'price' => 7500,
				'addr'  => 'Đường Trà Lộ, Hòa Hải, Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Trà Lộ, Ngũ Hành Sơn, Đà Nẵng',
				'm2' => 100, 'w' => 5, 'floors' => 3, 'beds' => 3, 'road' => 5.5, 'dir' => 'nam',
				'lead'  => 'villa mini <strong>3 tầng mới, có hồ bơi</strong>, 3 phòng ngủ, full nội thất – đường Trà Lộ (5,5 m), cách biển khoảng 400 m. Đất <strong>100 m²</strong> (5 × 20 m), hướng Nam.',
				'feat'  => array( 'Mới 100%, hồ bơi, full nội thất', 'Cách biển khoảng 400 m', 'Đất 100 m² (5 × 20 m), hướng Nam', '3 tầng, 3 phòng ngủ' ),
			),
		);
		$fmt = static fn( $n ) => str_replace( '.', ',', (string) $n );
		foreach ( $bt as $k ) {
			$gia  = rtrim( rtrim( number_format( $k['price'] / 1000, 2, ',', '.' ), '0' ), ',' ) . ' tỷ';
			$rows = array_filter(
				array(
					'Vị trí'        => $k['addr'],
					'Diện tích đất' => $fmt( $k['m2'] ) . ' m²' . ( $k['w'] ? ' (ngang ' . $fmt( $k['w'] ) . ' m)' : '' ),
					'Số tầng'       => $fmt( $k['floors'] ) . ' tầng',
					'Phòng ngủ'     => $k['beds'] . ' phòng ngủ',
					'Đường trước nhà' => $k['road'] ? $fmt( $k['road'] ) . ' m' : '',
					'Hướng'         => HH_DIRECTIONS[ $k['dir'] ] ?? '',
					'Giá'           => $gia . ' – có thương lượng',
				)
			);
			if ( '' === $k['dir'] ) {
				unset( $rows['Hướng'] );
			}
			$tbl = '';
			foreach ( $rows as $th => $td ) {
				$tbl .= '<tr><th>' . esc_html( $th ) . '</th><td>' . esc_html( $td ) . '</td></tr>';
			}
			$list[] = array(
				'rev'     => 1,
				'slug'    => $k['slug'],
				'title'   => $k['title'],
				'excerpt' => wp_strip_all_tags( 'Bán ' . $k['lead'] ) . ' Giá ' . $gia . '.',
				'kind'    => 'biet-thu',
				'area'    => $k['area'],
				'image'   => 'img/nha-dat/' . $k['img'] . '-4x3.jpg',
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
						'hh_bedrooms'    => $k['beds'],
						'hh_road'        => $k['road'] ?: '',
						'hh_direction'   => $k['dir'],
						'hh_features'    => implode( "\n", $k['feat'] ),
					),
					static fn( $v ) => '' !== $v && null !== $v
				),
				'content' => '<p>Bán ' . $k['lead'] . ' Giá <strong>' . esc_html( $gia ) . '</strong>, có thương lượng.</p>
<h2>Thông tin chính</h2>
<table><tbody>' . $tbl . '</tbody></table>
<h2>Trước khi đặt cọc mua biệt thự, cần kiểm tra</h2>
<ul>
<li><strong>Pháp lý</strong>: sổ hồng, đất ở hay đất trồng cây lâu năm, giấy phép xây dựng và hoàn công đúng số tầng hiện trạng.</li>
<li><strong>Quy hoạch</strong>: lộ giới, chỉ giới xây dựng, mật độ và tầng cao được phép tại khu đô thị.</li>
<li><strong>Hiện trạng</strong>: kết cấu, chống thấm, hồ bơi, thang máy, hệ thống điện nước và nội thất bàn giao.</li>
<li><strong>Khai thác cho thuê</strong>: nếu mua để cho thuê lưu trú, kiểm tra giấy phép kinh doanh, PCCC và doanh thu thực tế – không dựa vào số người bán tự công bố.</li>
</ul>
<p>Thông tin tổng hợp từ tin rao bán công khai tháng 11/2026; giá và tình trạng có thể thay đổi. Hoàng Hiệp kiểm tra tình trạng tin, pháp lý và hẹn xem thực tế – liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem thêm <a href="/mua-ban/biet-thu/">các biệt thự đang bán tại Đà Nẵng</a>.</p>',
			);
		}
		return $list;
	}
);
