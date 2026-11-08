<?php
/**
 * Peninsula Đà Nẵng – cập nhật 08/11/2026 từ bộ tài liệu dự án anh Hiệp gửi (Drive):
 * danh mục sản phẩm – giá niêm yết 25/07/2026, chính sách giao dịch đợt 25/07 – 25/08/2026 của chủ đầu tư (đã hết hạn, giữ làm tham khảo),
 * link 360°, 7 phối cảnh, 7 mặt bằng tầng, 14 ảnh tiện ích, 12 ảnh nội thất mẫu, 11 ảnh tiến độ thực tế 6/2026 và 10/2026
 * (ảnh tiến độ đã cắt dải trên có logo đơn vị phân phối). Không đăng mã căn, chương trình riêng của đơn vị phân phối, tài liệu đào tạo.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/peninsula/peninsula-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-dem-phao-hoa-song-han', 'Peninsula Đà Nẵng về đêm bên sông Hàn mùa pháo hoa (phối cảnh chủ đầu tư)', 'đại diện' ),
			$im( 'phoi-canh-ben-song-nhin-ban-dao-son-tra', 'Peninsula Đà Nẵng bên sông Hàn, phía sau là bán đảo Sơn Trà (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-song-han-tu-tren-cao', 'Sông Hàn và vịnh Đà Nẵng nhìn từ trên cao, vị trí Peninsula Đà Nẵng (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-ven-song-han-ban-ngay', 'Hai tòa tháp Peninsula Đà Nẵng ven sông Hàn ban ngày (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-ban-ngay', 'Tòa tháp Peninsula Đà Nẵng nhìn từ đường Lê Văn Duyệt (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-hoang-hon', 'Peninsula Đà Nẵng lúc hoàng hôn (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-tong-the-ben-song', 'Tổng thể Peninsula Đà Nẵng bên sông Hàn nhìn từ trên cao', 'tổng thể' ),
			$im( 'tien-do-6-2026-nhin-tu-song-han', 'Ảnh thực tế tháng 6/2026: Peninsula Đà Nẵng nhìn từ sông Hàn, phía sau là bán đảo Sơn Trà', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-ben-song-han-ban-dao-son-tra', 'Ảnh thực tế tháng 6/2026: hai tòa tháp bên sông Hàn', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-tu-bo-tay-song-han', 'Ảnh thực tế tháng 6/2026: Peninsula Đà Nẵng nhìn từ bờ Tây sông Hàn', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-toa-thap-giua-pho', 'Ảnh thực tế tháng 6/2026: tòa tháp giữa khu phố Sơn Trà', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-toa-thap-can-canh', 'Ảnh thực tế tháng 6/2026: cận cảnh tòa tháp đang hoàn thiện mặt ngoài', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-goc-nhin-tu-duong', 'Ảnh thực tế tháng 6/2026: tòa tháp nhìn từ đường', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-6-2026-mat-tien-le-van-duyet', 'Ảnh thực tế tháng 6/2026: mặt tiền dự án trên đường Lê Văn Duyệt', 'tiến độ', 'Thực tế 6/2026' ),
			$im( 'tien-do-10-2026-lap-cua-kinh', 'Ảnh thực tế tháng 10/2026: lắp cửa kính căn hộ', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-cua-kinh-view-song', 'Ảnh thực tế tháng 10/2026: cửa kính căn hộ nhìn ra sông', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-cua-so-nhin-cau-thuan-phuoc', 'Ảnh thực tế tháng 10/2026: từ căn hộ nhìn ra cầu Thuận Phước', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-hoan-thien-can-ho', 'Ảnh thực tế tháng 10/2026: hoàn thiện bên trong căn hộ', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-ich-be-boi-vo-cuc-hoang-hon', 'Bể bơi vô cực trên cao nhìn vịnh Đà Nẵng lúc hoàng hôn (phối cảnh)', 'tiện ích', 'Bể bơi vô cực' ),
			$im( 'tien-ich-be-boi-vo-cuc', 'Bể bơi vô cực điện phân muối Peninsula Đà Nẵng (phối cảnh)', 'tiện ích', 'Bể bơi vô cực' ),
			$im( 'tien-ich-sanh-don', 'Sảnh đón chuẩn khách sạn Peninsula Đà Nẵng (phối cảnh)', 'tiện ích', 'Sảnh đón' ),
			$im( 'tien-ich-gym', 'Phòng gym hơn 600 m² nhìn ra sông (phối cảnh)', 'tiện ích', 'Gym' ),
			$im( 'tien-ich-yoga', 'Phòng yoga nhìn ra sông Hàn (phối cảnh)', 'tiện ích', 'Yoga' ),
			$im( 'tien-ich-spa', 'Phòng spa (phối cảnh)', 'tiện ích', 'Spa' ),
			$im( 'tien-ich-spa-le-tan', 'Quầy lễ tân khu spa (phối cảnh)', 'tiện ích', 'Spa' ),
			$im( 'tien-ich-cafe', 'Cafe khối đế nhìn sông Hàn mùa pháo hoa (phối cảnh)', 'tiện ích', 'Cafe' ),
			$im( 'tien-ich-thu-vien', 'Thư viện cư dân (phối cảnh)', 'tiện ích', 'Thư viện' ),
			$im( 'tien-ich-khu-tre-em', 'Khu vui chơi trẻ em trong nhà (phối cảnh)', 'tiện ích', 'Khu trẻ em' ),
			$im( 'tien-ich-phong-sinh-hoat-chung', 'Phòng sinh hoạt cộng đồng cư dân (phối cảnh)', 'tiện ích', 'Sinh hoạt cộng đồng' ),
			$im( 'tien-ich-mini-mart', 'Mini mart khối đế (phối cảnh)', 'tiện ích', 'Mini mart' ),
			$im( 'tien-ich-san-vuon', 'Sân vườn và nhà hàng khối đế (phối cảnh)', 'tiện ích', 'Sân vườn' ),
			$im( 'tien-ich-khoi-de-ve-dem', 'Khối đế thương mại Peninsula Đà Nẵng về đêm (phối cảnh)', 'tiện ích', 'Khối đế' ),
			$im( 'noi-that-2pn-phong-khach-view-my-khe', 'Phòng khách căn 2PN view biển Mỹ Khê (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-2pn-phong-khach-view-son-tra', 'Phòng khách căn 2PN view bán đảo Sơn Trà (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-2pn-phong-ngu-view-my-khe', 'Phòng ngủ căn 2PN view biển Mỹ Khê (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-2pn-phong-ngu-view-son-tra', 'Phòng ngủ căn 2PN view Sơn Trà (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-ban-cong-dem-phao-hoa', 'Ban công căn hộ nhìn pháo hoa sông Hàn (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-ban-cong-binh-minh', 'Ban công căn hộ lúc bình minh trên sông Hàn (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-goc-phong-ngu-view-bien', 'Phòng ngủ căn góc nhìn biển và Ngũ Hành Sơn (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-can-goc-phong-ngu-song-han', 'Phòng ngủ căn góc nhìn sông Hàn (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-3pn-phong-khach-ban-cong', 'Phòng khách căn 3PN mở ra ban công (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-3pn-phong-khach', 'Phòng khách căn 3PN (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-3pn-phong-khach-an', 'Phòng khách – bàn ăn căn 3PN (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-bep', 'Bếp căn hộ bàn giao nội thất liền tường (phối cảnh)', 'thư viện' ),
			$im( 'mat-bang-tang-1', 'Mặt bằng tầng 1 Peninsula Đà Nẵng: sảnh, cafe, nhà hàng, thương mại', 'mặt bằng', 'Tầng 1' ),
			$im( 'mat-bang-tang-2', 'Mặt bằng tầng 2 Peninsula Đà Nẵng', 'mặt bằng', 'Tầng 2' ),
			$im( 'mat-bang-tang-3', 'Mặt bằng tầng 3 Peninsula Đà Nẵng: gym, spa, khu trẻ em, thư viện', 'mặt bằng', 'Tầng 3' ),
			$im( 'mat-bang-tang-4-29', 'Mặt bằng tầng điển hình 4 – 29 Peninsula Đà Nẵng', 'mặt bằng', 'Tầng 4 – 29' ),
			$im( 'mat-bang-tang-30', 'Mặt bằng tầng 30 Peninsula Đà Nẵng', 'mặt bằng', 'Tầng 30' ),
			$im( 'mat-bang-tang-thuong', 'Mặt bằng tầng thượng: bể bơi vô cực, sky park', 'mặt bằng', 'Tầng thượng' ),
			$im( 'mat-bang-mai', 'Mặt bằng mái Peninsula Đà Nẵng', 'mặt bằng', 'Mái' ),
		);
		$new = array(
			'hh_p_blocks'          => '2 tháp P1 và P2 chung khối đế',
			'hh_p_floors'          => '30 tầng nổi, 3 tầng hầm',
			'hh_p_handover'        => 'Dự kiến từ 30/3/2027',
			'hh_p_handover_std'    => 'Bàn giao toàn bộ nội thất liền tường, thiết bị – vật liệu hạng sang (theo chủ đầu tư)',
			'hh_p_ownership'       => 'Sở hữu lâu dài (đất ở, Nhà nước giao đất có thu tiền sử dụng đất)',
			'hh_p_tour_360'        => 'https://vr.peninsuladanang.vn/',
			'hh_p_tour_360_poster' => 'plugin:img/peninsula/peninsula-da-nang-phoi-canh-song-han-tu-tren-cao.jpg',
			'hh_p_price_from'      => 5210,
			'hh_p_price_table'     => "Căn 2PN view biển Mỹ Khê – bán đảo Sơn Trà | 77,6 m² | 5,85 tỷ | Thanh toán nhanh (CK 12%): khoảng 5,21 tỷ\nCăn 2PN view vịnh Đà Nẵng – Sơn Trà / city – sông Hàn | 94,4 – 96 m² | 7,26 – 7,80 tỷ | Thanh toán nhanh: khoảng 6,47 – 6,95 tỷ\nĐơn giá niêm yết | – | 75,4 – 82,6 triệu/m² | Danh mục sản phẩm ngày 25/07/2026, tầng 4 – 6",
			'hh_p_policy'          => "Chính sách giao dịch của chủ đầu tư đợt 25/07 – 25/08/2026 (đã hết hạn – tham khảo, hỏi Hoàng Hiệp chính sách hiện hành):\nThanh toán nhanh 70%: giảm 12% giá niêm yết\nThanh toán theo tiến độ: giảm 5% giá niêm yết\nMừng lễ cất nóc: chiết khấu thêm 2%/giao dịch\nĐặt cọc 200 triệu đồng/căn",
			'hh_p_payment'         => "Đặt cọc | 200 triệu/căn | Ký phiếu đặt cọc\nKý HĐMB | 30% | Trong 7 ngày từ ngày đặt cọc\nThanh toán nhanh | Đủ 70% | Trong 20 ngày từ đợt 1 (giảm 12%)\nHoặc theo tiến độ | Mỗi tháng thêm 10% đến 70% | Phương án tiến độ (giảm 5%)\nNhận nhà | Đủ 95% + 2% phí bảo trì | Trong 5 ngày từ thông báo bàn giao\nNhận sổ | 5% | Khi có thông báo lệ phí trước bạ",
			'hh_p_amenities_in'    => "3 tầng hầm đỗ ô tô\nSảnh đón chuẩn khách sạn 5 sao, phòng chờ thương gia\nBể bơi vô cực điện phân muối và Sky Park trên tầng thượng\nPhòng gym hơn 600 m², yoga, spa\nThư viện, khu vui chơi trẻ em trong nhà, phòng họp cư dân\nKhối đế: nhà hàng, cafe, mini mart, văn phòng",
		);
		foreach ( $projects as $i => $p ) {
			if ( 'peninsula-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['peninsula-da-nang']['meta'][ $k ] ?? '' ) : '' ) );
				if ( '' !== $cur && $cur !== (string) $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				$p['meta'][ $k ] = $v;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $cur;
			$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	70
);
