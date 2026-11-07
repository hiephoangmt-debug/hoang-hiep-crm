<?php
/**
 * Nam Hội An City – giỏ hàng mua bán, cho thuê anh Hiệp gửi 07/11/2026 (đất nền, nhà phố thô, shophouse hoàn thiện, nhà cho thuê).
 * KHÔNG ghi mã lô / số căn, tên người phụ trách; gộp theo nhóm. Bỏ dòng đã gạch (đã cho thuê) và căn "đang làm giá".
 * Giá tham khảo, có thương lượng. Nhập cùng nút Nhập dữ liệu (hh_import_single_listings).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_single_listing_dataset',
	static function ( $list ) {
		$link  = '<a href="/du-an/nam-hoi-an-city/">Nam Hội An City</a>';
		$addr  = 'Nam Hội An City, chân cầu Cửa Đại, ven sông Thu Bồn, xã Duy Nghĩa (Duy Xuyên cũ), Đà Nẵng';
		$map   = 'Nam Hội An City, Duy Nghĩa, Duy Xuyên';
		$foot  = '<p>Giỏ hàng cập nhật 07/11/2026; giá tham khảo, có thể thay đổi hoặc đã có khách – gọi trước để kiểm tra. Xem vị trí, mặt bằng phân lô và tiện ích tại <a href="/du-an/nam-hoi-an-city/">trang dự án Nam Hội An City</a>. Xem nhà, nhận thông tin từng căn: <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';
		$tbl   = static function ( $head, $rows ) {
			$h = '<table><thead><tr><th>' . implode( '</th><th>', $head ) . '</th></tr></thead><tbody>';
			foreach ( $rows as $r ) {
				$h .= '<tr><td>' . implode( '</td><td>', array_map( 'esc_html', $r ) ) . '</td></tr>';
			}
			return $h . '</tbody></table>';
		};
		$why = '<h2>Vì sao Nam Hội An City</h2>
<ul>
<li>Chân cầu Cửa Đại, ven sông Thu Bồn, cách phố cổ Hội An khoảng 5 km, biển Cửa Đại khoảng 15 phút.</li>
<li>Nhà phố 3 tầng kiến trúc phố cổ, khu đã bàn giao, có khách sạn, nhà hàng, bến du thuyền – hợp ở kết hợp kinh doanh homestay, cho thuê.</li>
<li>Khu vực Duy Xuyên đang được đầu tư hạ tầng (đường ven biển 129, các khu tái định cư phục vụ đường sắt tốc độ cao).</li>
</ul>';
		$base = static function ( $l ) use ( $addr, $map ) {
			$l['rev']     = 1;
			$l['project'] = 'nam-hoi-an-city';
			$l['area']    = 'duy-xuyen';
			$l['meta']    = array_filter(
				$l['meta'] + array(
					'hh_status'      => 'con-hang',
					'hh_address'     => $addr,
					'hh_map_address' => $map,
				),
				static fn( $v ) => '' !== (string) $v
			);
			return $l;
		};

		// 1. Nhà phố (lô, căn thô) 100 – 123 m².
		$list[] = $base(
			array(
				'slug'    => 'ban-nha-pho-nam-hoi-an-city-100-123m2-tu-3-65-ty',
				'title'   => 'Bán nhà phố Nam Hội An City 100 – 123 m², đường 7,5 – 10,5 m – từ 3,65 tỷ (6 căn, có lô góc)',
				'excerpt' => '6 căn nhà phố Nam Hội An City (chân cầu Cửa Đại, Duy Xuyên) 100 – 122,9 m², đường 7,5 – 10,5 m, có lô góc và căn thô: giá 3,65 – 4,5 tỷ, thương lượng.',
				'kind'    => 'nha-pho',
				'image'   => 'img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg',
				'alt'     => 'Ảnh thực tế flycam Nam Hội An City bên sông Thu Bồn, chân cầu Cửa Đại – bán nhà phố từ 3,65 tỷ',
				'meta'    => array(
					'hh_deal'       => 'ban',
					'hh_price'      => 3650,
					'hh_price_max'  => 4500,
					'hh_negotiable' => '1',
					'hh_area'       => 100,
					'hh_road'       => 7.5,
					'hh_features'   => "6 căn để chọn: 100 – 122,9 m², có lô góc\nĐường 7,5 m (lề 4 m) và đường 10,5 m (lề 5 m)\nCó căn thô – tự hoàn thiện theo nhu cầu ở, homestay\nGiá 3,65 – 4,5 tỷ, thương lượng",
				),
				'content' => '<p>Bán nhà phố tại ' . $link . ' – chân phía Nam cầu Cửa Đại, ven sông Thu Bồn. Giỏ hàng hiện có <strong>6 căn 100 – 122,9 m²</strong>, giá <strong>3,65 – 4,5 tỷ</strong>, thương lượng.</p>
<h2>Các căn đang bán</h2>' . $tbl(
					array( 'Loại', 'Diện tích', 'Đường / lề', 'Hướng', 'Giá' ),
					array(
						array( 'Lô góc', '122,9 m²', '7,5 m / 4 m', 'Nam – Đông', '3,65 tỷ, thương lượng' ),
						array( 'Nhà phố', '100,1 m²', '7,5 m / 4 m', 'Bắc', '4,5 tỷ, thương lượng' ),
						array( 'Căn thô', '100 m²', '7,5 m / 4 m', 'Đông', '4,2 tỷ, thương lượng' ),
						array( 'Căn thô', '—', '—', '—', '4,25 tỷ, thương lượng' ),
						array( 'Nhà phố', '101,8 m²', '10,5 m / 5 m', 'Tây Bắc', '4 tỷ, thương lượng' ),
						array( 'Nhà phố', '100,9 m²', '10,5 m / 5 m', 'Tây Bắc', '3,65 tỷ' ),
					)
				) . $why . $foot,
			)
		);

		// 2. Nhà phố hoàn thiện đang có hợp đồng thuê.
		$list[] = $base(
			array(
				'slug'    => 'ban-nha-pho-nam-hoi-an-city-100m2-dang-cho-thue-34-trieu-6-ty',
				'title'   => 'Bán nhà phố Nam Hội An City 100 m² đang có hợp đồng thuê 34 triệu/tháng – 6 tỷ (3 căn)',
				'excerpt' => '3 căn nhà phố Nam Hội An City 100 m², đường 7,5 m, hướng Tây và Đông, đang có hợp đồng thuê 1 năm 34 triệu/tháng. Giá 6 tỷ/căn.',
				'kind'    => 'nha-pho',
				'image'   => 'img/vinh-an-hoa/nam-hoi-an-city-phoi-canh-chu-thich.jpg',
				'alt'     => 'Nam Hội An City – bán nhà phố 100 m² đang cho thuê 34 triệu/tháng, giá 6 tỷ',
				'meta'    => array(
					'hh_deal'       => 'ban',
					'hh_price'      => 6000,
					'hh_area'       => 100,
					'hh_road'       => 7.5,
					'hh_features'   => "Đang có hợp đồng thuê 1 năm, 34 triệu/tháng – nhận nhà là có dòng tiền\n3 căn 100 m², đường 7,5 m (lề 4 m)\n2 căn hướng Tây, 1 căn hướng Đông\nGiá 6 tỷ/căn",
				),
				'content' => '<p>Bán nhà phố <strong>100 m²</strong> tại ' . $link . ' đang có <strong>hợp đồng thuê 1 năm, 34 triệu/tháng</strong> – người mua nhận lại hợp đồng, có dòng tiền ngay. Giá <strong>6 tỷ/căn</strong>.</p>
<h2>Các căn đang bán</h2>' . $tbl(
					array( 'Diện tích', 'Đường / lề', 'Hướng', 'Hợp đồng thuê', 'Giá' ),
					array(
						array( '100 m²', '7,5 m / 4 m', 'Tây', '1 năm – 34 triệu/tháng', '6 tỷ' ),
						array( '100 m²', '7,5 m / 4 m', 'Tây', '1 năm – 34 triệu/tháng', '6 tỷ' ),
						array( '100 m²', '7,5 m / 4 m', 'Đông', '1 năm – 34 triệu/tháng', '6 tỷ' ),
					)
				) . '<h2>Lưu ý khi mua nhà đang cho thuê</h2>
<ul>
<li>Xem hợp đồng thuê gốc: thời hạn còn lại, tiền cọc của khách thuê, điều khoản khi đổi chủ.</li>
<li>Thỏa thuận rõ việc bàn giao tiền cọc và tiền thuê đã nhận trước khi công chứng.</li>
</ul>' . $why . $foot,
			)
		);

		// 3. Shophouse hoàn thiện.
		$list[] = $base(
			array(
				'slug'    => 'ban-shophouse-hoan-thien-nam-hoi-an-city-100m2-tu-6-2-ty',
				'title'   => 'Bán shophouse hoàn thiện Nam Hội An City 100 m² – từ 6,2 tỷ, có dãy 5 căn liền kề 30 tỷ',
				'excerpt' => 'Shophouse hoàn thiện Nam Hội An City 100 m²: căn lẻ 6,2 – 6,5 tỷ, cặp 2 căn hướng Nam 12,8 tỷ, dãy 5 căn liền kề hướng Đông 30 tỷ.',
				'kind'    => 'shophouse',
				'image'   => 'img/vinh-an-hoa/nam-hoi-an-city-phoi-canh-tren-cao.jpg',
				'alt'     => 'Phối cảnh Nam Hội An City bên sông Thu Bồn – bán shophouse hoàn thiện 100 m² từ 6,2 tỷ',
				'meta'    => array(
					'hh_deal'       => 'ban',
					'hh_price'      => 6200,
					'hh_price_from' => '1',
					'hh_area'       => 100,
					'hh_road'       => 7.5,
					'hh_features'   => "Shophouse đã hoàn thiện, 100 m², đường 7,5 m (lề 4 m)\nCăn lẻ 6,2 – 6,5 tỷ\nCặp 2 căn liền kề hướng Nam: 12,8 tỷ\nDãy 5 căn liền kề hướng Đông: 30 tỷ – hợp làm khách sạn mini, chuỗi homestay",
				),
				'content' => '<p>Bán <strong>shophouse đã hoàn thiện</strong> tại ' . $link . ', diện tích 100 m²/căn, đường 7,5 m. Có căn lẻ từ <strong>6,2 tỷ</strong>, cặp 2 căn và <strong>dãy 5 căn liền kề</strong> cho khách cần quy mô lớn làm lưu trú, homestay.</p>
<h2>Giỏ hàng shophouse</h2>' . $tbl(
					array( 'Sản phẩm', 'Diện tích', 'Đường / lề', 'Hướng', 'Giá' ),
					array(
						array( 'Dãy 5 căn liền kề', '5 × 100 m²', '7,5 m / 4 m', 'Đông', '30 tỷ cả dãy' ),
						array( 'Căn lẻ', '100 m²', '7,5 m / 4 m', 'Đông', '6,5 tỷ' ),
						array( 'Cặp 2 căn liền kề', '2 × 100 m²', '7,5 m / 4 m', 'Nam', '12,8 tỷ cả cặp' ),
						array( 'Căn lẻ', '—', '—', '—', '6,2 tỷ' ),
					)
				) . $why . $foot,
			)
		);

		// 4. Đất nền.
		$list[] = $base(
			array(
				'slug'    => 'ban-dat-nen-nam-hoi-an-city-101m2-tu-2-95-ty',
				'title'   => 'Bán đất nền Nam Hội An City khoảng 101 m² – từ 2,95 tỷ (2 lô)',
				'excerpt' => '2 lô đất nền Nam Hội An City (chân cầu Cửa Đại, Duy Xuyên): lô 101,4 m² hướng Nam – Đông Nam 2,95 tỷ thương lượng, lô thứ hai 3 tỷ.',
				'kind'    => 'dat-nen',
				'image'   => 'img/vinh-an-hoa/nam-hoi-an-city-mat-bang-phan-lo.jpg',
				'alt'     => 'Mặt bằng phân lô Nam Hội An City – bán đất nền khoảng 101 m² từ 2,95 tỷ',
				'meta'    => array(
					'hh_deal'       => 'ban',
					'hh_price'      => 2950,
					'hh_price_max'  => 3000,
					'hh_negotiable' => '1',
					'hh_area'       => 101.4,
					'hh_features'   => "2 lô đất nền trong khu đô thị đã có hạ tầng\nLô 101,4 m², hướng Nam – Đông Nam: 2,95 tỷ, thương lượng\nLô thứ hai: 3 tỷ\nXây nhà phố theo thiết kế khu",
				),
				'content' => '<p>Bán <strong>đất nền</strong> tại ' . $link . ' – 2 lô, giá <strong>2,95 – 3 tỷ</strong>, thương lượng.</p>
<h2>Các lô đang bán</h2>' . $tbl(
					array( 'Diện tích', 'Hướng', 'Giá' ),
					array(
						array( '101,4 m²', 'Nam – Đông Nam', '2,95 tỷ, thương lượng' ),
						array( '—', '—', '3 tỷ' ),
					)
				) . '<p>Trước khi đặt cọc nên xem sổ, kiểm tra thời hạn sử dụng đất ghi trên sổ và quy định xây dựng của khu (số tầng, kiến trúc mặt đứng).</p>' . $why . $foot,
			)
		);

		// 5. Cho thuê nhà nguyên căn.
		$rent = array(
			array( '3 phòng ngủ', 'Trống, vào ở ngay', '40 triệu, thương lượng' ),
			array( '4 phòng ngủ', '—', '30 triệu' ),
			array( '5 phòng ngủ', 'Trống từ 25/9', '40 triệu, thương lượng' ),
			array( '5 phòng ngủ', '—', '42 triệu' ),
			array( '5 phòng ngủ', '—', '42 triệu' ),
			array( '5 phòng ngủ', 'Sắp hoàn thiện', '40 triệu, thương lượng' ),
			array( '5 phòng ngủ', 'Sắp hoàn thiện', '40 triệu, thương lượng' ),
			array( '5 phòng ngủ', 'Sắp trả nhà', '35 triệu' ),
			array( '5 phòng ngủ', '—', '38 triệu' ),
			array( '5 phòng ngủ', 'Cho thuê lẻ từng phòng khoảng 10 triệu', '50 triệu nguyên căn, thương lượng' ),
			array( '5 phòng ngủ', 'Cho thuê lẻ từng phòng khoảng 10 triệu', '50 triệu nguyên căn, thương lượng' ),
			array( '6 phòng ngủ', 'Trống từ 1/10', '40 triệu, thương lượng' ),
			array( '6 phòng ngủ', 'Trống từ 1/10', '40 triệu' ),
			array( '6 phòng ngủ', 'Trống từ 1/10', '30 triệu' ),
			array( 'Thuê phòng lẻ', 'Còn 2 phòng trống', '1PN khoảng 10 triệu · 2PN khoảng 13 triệu' ),
		);
		$list[] = $base(
			array(
				'slug'    => 'cho-thue-nha-nguyen-can-nam-hoi-an-city-3-6-phong-ngu',
				'title'   => 'Cho thuê nhà nguyên căn Nam Hội An City 3 – 6 phòng ngủ – 30 – 50 triệu/tháng (14 căn)',
				'excerpt' => '14 căn nhà phố Nam Hội An City cho thuê nguyên căn 3 – 6 phòng ngủ, 30 – 50 triệu/tháng – hợp làm homestay, văn phòng, nhà ở chuyên gia; có phòng lẻ 10 – 13 triệu.',
				'kind'    => 'nha-pho',
				'image'   => 'img/da-nang/duy-xuyen-flycam-song-thu-bon-cau-cua-dai-hoi-an.jpg',
				'alt'     => 'Ảnh thực tế flycam Nam Hội An City – cho thuê nhà nguyên căn 3 – 6 phòng ngủ',
				'meta'    => array(
					'hh_deal'       => 'thue',
					'hh_price'      => 30,
					'hh_price_max'  => 50,
					'hh_negotiable' => '1',
					'hh_bedrooms'   => 5,
					'hh_features'   => "14 căn nguyên căn 3 – 6 phòng ngủ để chọn\nGiá 30 – 50 triệu/tháng, nhiều căn thương lượng\nHợp làm homestay, nhà ở chuyên gia, văn phòng\nCó phòng lẻ 1PN khoảng 10 triệu, 2PN khoảng 13 triệu",
				),
				'content' => '<p>Cho thuê <strong>nhà phố nguyên căn 3 – 6 phòng ngủ</strong> tại ' . $link . ', giá <strong>30 – 50 triệu/tháng</strong>. Phù hợp kinh doanh homestay, lưu trú cho khách du lịch Hội An, nhà ở chuyên gia hoặc văn phòng.</p>
<h2>Các căn đang cho thuê</h2>' . $tbl( array( 'Loại', 'Tình trạng', 'Giá thuê/tháng' ), $rent ) . '<h2>Lưu ý khi thuê làm homestay</h2>
<ul>
<li>Thỏa thuận rõ việc chủ nhà cho phép kinh doanh lưu trú, đăng ký kinh doanh và PCCC.</li>
<li>Hỏi kỹ tình trạng nội thất bàn giao, thời hạn hợp đồng và kỳ thanh toán.</li>
</ul>' . $why . $foot,
			)
		);
		return $list;
	}
);
