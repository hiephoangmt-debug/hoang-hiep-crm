<?php
/**
 * Tin bán khách sạn / tòa căn hộ dịch vụ Đà Nẵng – quét tin rao công khai ngày 06/11/2026 (Homedy, mục Bán khách sạn Đà Nẵng).
 * Chỉ lấy thông số (vị trí theo tên đường, diện tích, số tầng, số phòng, giá); KHÔNG ghi tên, số điện thoại người đăng,
 * KHÔNG dùng ảnh của tin rao (ảnh thuộc người đăng, có số điện thoại trong ảnh) – ảnh thẻ tin tự vẽ
 * (wordpress/bai-viet/khach-san-ban-11-2026-anh.py). Doanh thu, dòng tiền là số người đăng tự công bố – ghi rõ "theo tin rao".
 * Nhập cùng nút Nhập dữ liệu (hh_import_single_listings); chạy lại không tạo trùng, không ghi đè tin đã sửa tay.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_single_listing_dataset',
	static function ( $list ) {
		$ks = array(
			array(
				'slug'  => 'ban-khach-san-duong-loseby-son-tra-20-phong-gan-bien-pham-van-dong',
				'title' => 'Bán khách sạn 20 phòng đường Loseby, Sơn Trà – cách biển Phạm Văn Đồng khoảng 100 m – 25 tỷ',
				'area'  => 'son-tra',
				'img'   => 'khach-san-loseby-son-tra-20-phong',
				'price' => 25000,
				'addr'  => 'Đường Loseby (phố khách sạn nối Võ Nguyên Giáp – Phạm Văn Đồng), Sơn Trà, Đà Nẵng',
				'map'   => 'Loseby, Sơn Trà, Đà Nẵng',
				'm2'    => 115, 'w' => 5, 'floors' => 0, 'rooms' => 20, 'road' => 7.5, 'dir' => 'bac', 'legal' => 'so-hong',
				'lead'  => 'khách sạn <strong>20 phòng</strong> trên đường Loseby – tuyến phố khách sạn, căn hộ dịch vụ nối Võ Nguyên Giáp với Phạm Văn Đồng, đi bộ khoảng 100 m ra biển. Đất <strong>115 m²</strong> (ngang 5 m), hướng Bắc, đường 7,5 m xe du lịch ra vào được.',
				'rows'  => array( 'Số phòng' => '20 phòng, thiết kế chuẩn lưu trú du lịch', 'PCCC' => 'Đầy đủ (theo tin rao)', 'Tình trạng' => 'Vào vận hành ngay' ),
				'feat'  => array( '20 phòng lưu trú, PCCC đầy đủ, vận hành ngay', 'Phố khách sạn sát biển Phạm Văn Đồng – khoảng 100 m ra biển', 'Đường 7,5 m, xe du lịch ra vào thoải mái', 'Sổ hồng' ),
			),
			array(
				'slug'  => 'ban-khach-san-3-sao-7-tang-duong-le-van-quy-son-tra-18-phong',
				'title' => 'Bán khách sạn 3 sao 7 tầng, 18 phòng mặt tiền Lê Văn Quý, Sơn Trà – cách biển 700 m – 18,5 tỷ',
				'area'  => 'son-tra',
				'img'   => 'khach-san-le-van-quy-son-tra-7-tang',
				'price' => 18500,
				'addr'  => 'Mặt tiền đường Lê Văn Quý (gần Chính Hữu), Sơn Trà, Đà Nẵng',
				'map'   => 'Lê Văn Quý, Sơn Trà, Đà Nẵng',
				'm2'    => 100, 'w' => 0, 'floors' => 7, 'rooms' => 18, 'road' => 7.5, 'dir' => '', 'legal' => 'so-hong',
				'lead'  => 'khách sạn tiêu chuẩn 3 sao <strong>7 tầng, 18 phòng</strong> đang vận hành, mặt tiền đường Lê Văn Quý (đường 7,5 m, vỉa hè 4,5 m), gần Chính Hữu – cách biển khoảng 700 m, sân bay khoảng 10 phút.',
				'rows'  => array( 'Kết cấu' => '7 tầng, 18 phòng, có lễ tân, thang máy', 'Kinh doanh' => 'Đang vận hành; lợi nhuận khoảng 70 triệu/tháng (theo tin rao)', 'Diện tích đất' => 'Khoảng 100 m²' ),
				'feat'  => array( 'Khách sạn 3 sao đang vận hành, có thang máy, lễ tân', 'Cách biển khoảng 700 m, sân bay khoảng 10 phút', 'Đường 7,5 m, vỉa hè 4,5 m, đậu đỗ ô tô', 'Sổ vuông vức, có thương lượng' ),
			),
			array(
				'slug'  => 'ban-khach-san-4-sao-17-tang-102-phong-duong-ha-bong-bien-my-khe',
				'title' => 'Bán khách sạn 4 sao 17 tầng, 102 phòng đường Hà Bổng, biển Mỹ Khê – đất 510 m² – 230 tỷ',
				'area'  => 'son-tra',
				'img'   => 'khach-san-ha-bong-17-tang-102-phong',
				'price' => 230000,
				'addr'  => 'Đường Hà Bổng, khu biển Mỹ Khê, Sơn Trà, Đà Nẵng',
				'map'   => 'Hà Bổng, Sơn Trà, Đà Nẵng',
				'm2'    => 510, 'w' => 23, 'floors' => 17, 'rooms' => 102, 'road' => 8, 'dir' => '', 'legal' => '',
				'lead'  => 'khách sạn 4 sao <strong>17 tầng, 102 phòng</strong> trên đường Hà Bổng – khu biển Mỹ Khê. Đất <strong>510 m²</strong>, mặt tiền ngang 23 m, tổng sàn sử dụng khoảng 7.000 m²; có phòng hội nghị, bể bơi, phòng gym.',
				'rows'  => array( 'Kết cấu' => '17 tầng, 102 phòng, sàn sử dụng khoảng 7.000 m²', 'Tiện ích' => 'Phòng hội nghị, bể bơi, phòng gym, thang máy', 'Doanh thu' => 'Khoảng 2 – 3 tỷ/tháng (theo tin rao, cần đối chiếu sổ sách)', 'Đường' => '8 m, lề 5 m' ),
				'feat'  => array( 'Khách sạn 4 sao 17 tầng, 102 phòng', 'Đất 510 m², ngang 23 m, sàn khoảng 7.000 m²', 'Hội nghị, bể bơi, gym', 'Đường 8 m, lề 5 m, khu biển Mỹ Khê' ),
			),
			array(
				'slug'  => 'ban-khach-san-boutique-9-tang-ho-boi-vo-cuc-duong-do-the-chap-son-tra',
				'title' => 'Bán khách sạn boutique 9 tầng, hồ bơi vô cực, 18 phòng đường Đỗ Thế Chấp, Sơn Trà – 29 tỷ',
				'area'  => 'son-tra',
				'img'   => 'khach-san-boutique-do-the-chap-9-tang',
				'price' => 29000,
				'addr'  => 'Đường Đỗ Thế Chấp, khu biển Mỹ Khê, Sơn Trà, Đà Nẵng',
				'map'   => 'Đỗ Thế Chấp, Sơn Trà, Đà Nẵng',
				'm2'    => 123.5, 'w' => 5, 'floors' => 9, 'rooms' => 18, 'road' => 0, 'dir' => 'dong', 'legal' => '',
				'lead'  => 'khách sạn boutique <strong>9 tầng có tầng hầm</strong>, hồ bơi vô cực trên sân thượng, nội thất chuẩn 4 sao – <strong>18 phòng</strong> (13 studio có bếp, 5 phòng khách sạn) và 2 phòng massage. Đất <strong>123,5 m²</strong> (5 × 25 m), hướng Đông, view biển Mỹ Khê, đã hoàn công.',
				'rows'  => array( 'Kết cấu' => '9 tầng + hầm, hồ bơi vô cực sân thượng', 'Phòng' => '13 studio có bếp, 5 phòng khách sạn, 2 phòng massage', 'Doanh thu' => 'Trên 200 triệu/tháng mùa thấp điểm (theo tin rao)', 'Pháp lý' => 'Đã hoàn công (theo tin rao)' ),
				'feat'  => array( 'Boutique 9 tầng + hầm, hồ bơi vô cực sân thượng', '18 phòng: 13 studio có bếp, 5 phòng khách sạn', 'Hướng Đông, view biển Mỹ Khê', 'Đã hoàn công, chủ cần bán, thương lượng mạnh' ),
			),
			array(
				'slug'  => 'ban-khach-san-3-sao-12-tang-56-phong-ho-boi-khu-an-thuong-my-khe',
				'title' => 'Bán khách sạn 3 sao 12 tầng, 56 phòng, hồ bơi – khu An Thượng, cách biển Mỹ Khê 100 m – 64 tỷ',
				'area'  => 'ngu-hanh-son',
				'img'   => 'khach-san-an-thuong-12-tang-56-phong',
				'price' => 64000,
				'addr'  => 'Khu phố du lịch An Thượng (gần Trần Bạch Đằng), Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'An Thượng, Ngũ Hành Sơn, Đà Nẵng',
				'm2'    => 243, 'w' => 13.5, 'floors' => 12, 'rooms' => 56, 'road' => 5.5, 'dir' => '', 'legal' => '',
				'lead'  => 'khách sạn 3 sao <strong>1 hầm + 11 tầng nổi, 56 phòng</strong>, hồ bơi tầng thượng, nhà hàng buffet – mặt tiền khu phố Tây An Thượng, gần Trần Bạch Đằng, cách bãi tắm Mỹ Khê khoảng 100 m. Đất <strong>243 m²</strong> (13,5 × 18 m), sàn 2.670 m², mới xây.',
				'rows'  => array( 'Kết cấu' => '1 hầm + 11 tầng nổi, 56 phòng, sàn 2.670 m²', 'Tiện ích' => 'Hồ bơi tầng thượng, nhà hàng buffet', 'Đường' => '5,5 m, khu phố Tây An Thượng', 'Pháp lý' => 'Đầy đủ (theo tin rao)' ),
				'feat'  => array( 'Khách sạn 3 sao mới, 56 phòng', 'Hồ bơi tầng thượng, nhà hàng buffet', 'Cách biển Mỹ Khê khoảng 100 m', 'Đất 243 m², ngang 13,5 m' ),
			),
			array(
				'slug'  => 'ban-toa-can-ho-khach-san-27-can-ho-boi-khue-my-dong-gan-bien-my-khe',
				'title' => 'Bán tòa căn hộ – khách sạn 27 căn, hồ bơi view biển, khu Khuê Mỹ Đông, đi biển 500 m – 34 tỷ',
				'area'  => 'ngu-hanh-son',
				'img'   => 'toa-can-ho-khach-san-khue-my-dong-27-can',
				'price' => 34000,
				'addr'  => 'Khu Khuê Mỹ Đông (gần Hồ Xuân Hương, Furama), Ngũ Hành Sơn, Đà Nẵng',
				'map'   => 'Khuê Mỹ Đông, Ngũ Hành Sơn, Đà Nẵng',
				'm2'    => 180, 'w' => 10, 'floors' => 8, 'rooms' => 27, 'road' => 0, 'dir' => '', 'legal' => '',
				'lead'  => 'tòa căn hộ – khách sạn <strong>1 hầm, 7 tầng nổi, sân thượng hồ bơi view biển</strong> với <strong>27 căn hộ</strong> nội thất cao cấp (căn nào cũng có ban công, bếp, máy giặt riêng), gần Hồ Xuân Hương – Furama, đi biển khoảng 500 m. Đất <strong>180 m²</strong> (ngang 10 m), tổng sàn 1.650 m².',
				'rows'  => array( 'Kết cấu' => '1 hầm + 7 tầng nổi + sân thượng hồ bơi, 27 căn hộ', 'Kinh doanh' => 'Đang full phòng; doanh thu khoảng 250 triệu/tháng, giá thuê ngày 600 – 800 nghìn (theo tin rao)', 'Cho thuê lại' => 'Chủ nhà đề nghị thuê lại 160 triệu/tháng, hợp đồng trên 5 năm (theo tin rao)' ),
				'feat'  => array( '27 căn hộ full nội thất, có bếp, máy giặt riêng', 'Sân thượng hồ bơi view biển', 'Đi biển khoảng 500 m, gần Hồ Xuân Hương – Furama', 'Có phương án chủ nhà thuê lại (theo tin rao)' ),
			),
			array(
				'slug'  => 'ban-toa-can-ho-boutique-8-tang-ho-boi-duong-le-thuoc-son-tra',
				'title' => 'Bán tòa căn hộ boutique 8 tầng, hồ bơi, 14 căn hộ đường Lê Thước, Sơn Trà – cách biển 500 m – 38 tỷ',
				'area'  => 'son-tra',
				'img'   => 'toa-can-ho-boutique-le-thuoc-8-tang',
				'price' => 38000,
				'addr'  => 'Mặt tiền đường Lê Thước, gần biển Phạm Văn Đồng, Sơn Trà, Đà Nẵng',
				'map'   => 'Lê Thước, Sơn Trà, Đà Nẵng',
				'm2'    => 200, 'w' => 17, 'floors' => 8, 'rooms' => 14, 'road' => 0, 'dir' => '', 'legal' => '',
				'lead'  => 'tòa căn hộ boutique <strong>8 tầng</strong>, nội thất 4 sao, <strong>14 căn hộ</strong> full nội thất, phòng gym và hồ bơi – mặt tiền đường Lê Thước, cách biển Phạm Văn Đồng khoảng 500 m, gần công viên Biển Đông. Đất <strong>200 m²</strong>, mặt tiền ngang 17 m, sàn 1.118 m².',
				'rows'  => array( 'Kết cấu' => '8 tầng, sàn 1.118 m², 14 căn hộ + phòng gym + hồ bơi', 'Dòng tiền' => 'Khoảng 200 triệu/tháng, 1,2 tỷ/năm (theo tin rao)', 'Mặt tiền' => 'Ngang 17 m' ),
				'feat'  => array( 'Tòa boutique 8 tầng, nội thất chuẩn 4 sao', '14 căn hộ, phòng gym, hồ bơi', 'Mặt tiền ngang 17 m, đất 200 m²', 'Cách biển Phạm Văn Đồng khoảng 500 m' ),
			),
			array(
				'slug'  => 'ban-toa-can-ho-dich-vu-7-tang-11-phong-gan-bien-pham-van-dong-ho-nghinh',
				'title' => 'Bán tòa căn hộ dịch vụ 7 tầng, 11 phòng mới 100% gần biển Phạm Văn Đồng, sát công viên Hồ Nghinh – 2x tỷ',
				'area'  => 'son-tra',
				'img'   => 'toa-can-ho-dich-vu-gan-ho-nghinh-11-phong',
				'price' => 20000, 'from' => true,
				'addr'  => 'Gần biển Phạm Văn Đồng, sát công viên Hồ Nghinh, Sơn Trà, Đà Nẵng',
				'map'   => 'Công viên Hồ Nghinh, Sơn Trà, Đà Nẵng',
				'm2'    => 90, 'w' => 0, 'floors' => 7, 'rooms' => 11, 'road' => 0, 'dir' => '', 'legal' => '',
				'lead'  => 'tòa căn hộ dịch vụ <strong>7 tầng, 11 phòng</strong> mới 100%, full nội thất – gần biển Phạm Văn Đồng, sát công viên Hồ Nghinh, trung tâm khu du lịch biển Mỹ Khê. Đất <strong>90 m²</strong>, xây tối đa công năng.',
				'rows'  => array( 'Kết cấu' => '7 tầng, 11 phòng full nội thất, tiêu chuẩn căn hộ dịch vụ', 'Doanh thu' => 'Khoảng 100 – 110 triệu/tháng (theo tin rao)', 'Giá' => 'Khoảng 2x tỷ, thỏa thuận' ),
				'feat'  => array( 'Mới 100%, full nội thất', '7 tầng, 11 phòng căn hộ dịch vụ', 'Sát công viên Hồ Nghinh, gần biển Phạm Văn Đồng', 'Giá thỏa thuận' ),
			),
		);
		$dirs = array( 'bac' => 'Bắc', 'dong' => 'Đông' );
		foreach ( $ks as $k ) {
			$gia  = ! empty( $k['from'] ) ? '2x tỷ' : rtrim( rtrim( number_format( $k['price'] / 1000, 1, ',', '.' ), '0' ), ',' ) . ' tỷ';
			$rows = array_filter(
				array(
					'Vị trí'        => $k['addr'],
					'Diện tích đất' => $k['m2'] ? str_replace( '.', ',', (string) $k['m2'] ) . ' m²' . ( $k['w'] ? ' (ngang ' . str_replace( '.', ',', (string) $k['w'] ) . ' m)' : '' ) : '',
					'Số tầng'       => $k['floors'] ? $k['floors'] . ' tầng' : '',
					'Số phòng'      => $k['rooms'] . ' phòng / căn',
					'Hướng'         => $dirs[ $k['dir'] ] ?? '',
				)
			) + $k['rows'] + array( 'Giá' => $gia . ( ! empty( $k['from'] ) ? '' : ' – có thương lượng' ) );
			$tbl  = '';
			foreach ( $rows as $th => $td ) {
				$tbl .= '<tr><th>' . esc_html( $th ) . '</th><td>' . esc_html( $td ) . '</td></tr>';
			}
			$list[] = array(
				'rev'     => 1,
				'slug'    => $k['slug'],
				'title'   => $k['title'],
				'excerpt' => wp_strip_all_tags( 'Bán ' . $k['lead'] ) . ' Giá ' . $gia . '.',
				'kind'    => 'khach-san',
				'area'    => $k['area'],
				'image'   => 'img/nha-dat/' . $k['img'] . '-4x3.jpg',
				'alt'     => wp_strip_all_tags( $k['title'] ),
				'meta'    => array_filter(
					array(
						'hh_deal'        => 'ban',
						'hh_status'      => 'con-hang',
						'hh_price'       => $k['price'],
						'hh_price_from'  => ! empty( $k['from'] ) ? '1' : '',
						'hh_negotiable'  => '1',
						'hh_address'     => $k['addr'],
						'hh_map_address' => $k['map'],
						'hh_area'        => $k['m2'],
						'hh_width'       => $k['w'] ?: '',
						'hh_floors'      => $k['floors'] ?: '',
						'hh_road'        => $k['road'] ?: '',
						'hh_direction'   => $k['dir'],
						'hh_legal'       => $k['legal'],
						'hh_features'    => implode( "\n", $k['feat'] ),
					),
					static fn( $v ) => '' !== $v && null !== $v
				),
				'content' => '<p>Bán ' . $k['lead'] . ' Giá <strong>' . esc_html( $gia ) . '</strong>' . ( ! empty( $k['from'] ) ? ', thỏa thuận' : ', có thương lượng' ) . '.</p>
<h2>Thông tin chính</h2>
<table><tbody>' . $tbl . '</tbody></table>
<h2>Trước khi xuống tiền mua khách sạn, cần kiểm tra</h2>
<ul>
<li><strong>Pháp lý</strong>: giấy chứng nhận, giấy phép xây dựng và hoàn công đúng số tầng hiện trạng, thẩm duyệt và nghiệm thu PCCC.</li>
<li><strong>Kinh doanh</strong>: doanh thu, công suất phòng là số người bán công bố – đối chiếu sổ sách, hóa đơn, báo cáo thuế và các kênh đặt phòng.</li>
<li><strong>Hiện trạng</strong>: thang máy, hệ thống điện nước, điều hòa, nội thất và chi phí bảo trì sắp tới.</li>
<li><strong>Thuế, phí chuyển nhượng</strong> và phương án tiếp tục vận hành hoặc cho thuê lại.</li>
</ul>
<p>Thông tin tổng hợp từ tin rao bán công khai tháng 11/2026; giá và tình trạng có thể thay đổi. Hoàng Hiệp kiểm tra tình trạng tin, pháp lý và hẹn xem thực tế – liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem thêm <a href="/mua-ban/khach-san/">các khách sạn đang bán và mặt bằng giá khách sạn ven biển Đà Nẵng</a>.</p>',
			);
		}
		return $list;
	}
);
