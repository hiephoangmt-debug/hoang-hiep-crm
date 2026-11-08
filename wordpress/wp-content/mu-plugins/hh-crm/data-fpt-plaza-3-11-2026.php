<?php
/**
 * FPT Plaza 3 – cập nhật 08/11/2026 từ bộ tài liệu dự án anh Hiệp gửi (Drive):
 * thông tin tổng quan, bộ hỏi đáp chủ đầu tư, leaflet, danh mục vật liệu hoàn thiện, thông báo 7190/SXD-QLN ngày 25/09/2024.
 * 39 ảnh: ảnh thực tế căn hộ mẫu 2PN, 3PN (có nội thất), ảnh thực tế căn 1PN+ bàn giao hoàn thiện cơ bản, văn phòng bán hàng,
 * flycam thực tế FPT City, phối cảnh, tiện ích, mặt bằng tầng 3, layout từng loại căn. Chỉ có logo chủ đầu tư (FPT City / FPT Plaza 3).
 * Không đăng hợp đồng mẫu, phiếu giữ chỗ, tài liệu đào tạo, file thông tin khách hàng. Thay ô cũ nếu web chưa sửa tay.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/fpt-plaza-3/fpt-plaza-3-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'flycam-quang-truong-fpt-city', 'Ảnh flycam thực tế: các tòa FPT Plaza bên quảng trường trung tâm FPT City', 'tiến độ', 'Flycam thực tế' ),
			$im( 'flycam-cac-toa-fpt-plaza', 'Ảnh flycam thực tế: cụm tòa căn hộ FPT Plaza trong khu đô thị FPT City, nhìn về biển', 'tiến độ', 'Flycam thực tế' ),
			$im( 'flycam-nhin-ve-bien', 'Ảnh flycam thực tế khu FPT City nhìn về biển Đà Nẵng', 'tiến độ', 'Flycam thực tế' ),
			$im( 'flycam-song-co-co-san-golf', 'Ảnh flycam thực tế sông Cổ Cò và sân golf cạnh khu đô thị FPT City', 'tiến độ', 'Flycam thực tế' ),
			$im( 'can-mau-2pn-phong-khach', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: phòng khách và bàn ăn', 'thư viện' ),
			$im( 'can-mau-2pn-phong-khach-2', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: phòng khách liền bếp', 'thư viện' ),
			$im( 'can-mau-2pn-phong-khach-ban-cong', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: phòng khách mở ra lô gia', 'thư viện' ),
			$im( 'can-mau-2pn-bep', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: bếp tủ gỗ, mặt đá', 'thư viện' ),
			$im( 'can-mau-2pn-phong-ngu', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: phòng ngủ', 'thư viện' ),
			$im( 'can-mau-2pn-ve-sinh', 'Ảnh thực tế căn hộ mẫu 2PN FPT Plaza 3: phòng tắm vách kính', 'thư viện' ),
			$im( 'can-mau-3pn-phong-khach-an', 'Ảnh thực tế căn hộ mẫu 3PN FPT Plaza 3: phòng khách và bàn ăn', 'thư viện' ),
			$im( 'can-mau-3pn-phong-khach', 'Ảnh thực tế căn hộ mẫu 3PN FPT Plaza 3: phòng khách nhìn ra lô gia', 'thư viện' ),
			$im( 'can-mau-3pn-bep', 'Ảnh thực tế căn hộ mẫu 3PN FPT Plaza 3: bếp chữ L', 'thư viện' ),
			$im( 'can-mau-3pn-phong-ngu', 'Ảnh thực tế căn hộ mẫu 3PN FPT Plaza 3: phòng ngủ', 'thư viện' ),
			$im( 'can-mau-3pn-ve-sinh', 'Ảnh thực tế căn hộ mẫu 3PN FPT Plaza 3: phòng tắm', 'thư viện' ),
			$im( 'ban-giao-1pn-plus-phong-khach-bep', 'Ảnh thực tế căn 1PN+ FPT Plaza 3 bàn giao hoàn thiện cơ bản: phòng khách, bếp, sàn gỗ', 'thư viện' ),
			$im( 'ban-giao-1pn-plus-bep', 'Ảnh thực tế căn 1PN+ FPT Plaza 3 khi bàn giao: tủ bếp trên dưới, mặt đá', 'thư viện' ),
			$im( 'ban-giao-1pn-plus-phong-khach', 'Ảnh thực tế căn 1PN+ FPT Plaza 3 khi bàn giao: phòng khách và phòng ngủ', 'thư viện' ),
			$im( 'ban-giao-1pn-plus-ve-sinh', 'Ảnh thực tế phòng tắm căn 1PN+ FPT Plaza 3 khi bàn giao', 'thư viện' ),
			$im( 'van-phong-ban-hang-sa-ban', 'Văn phòng bán hàng FPT Plaza 3 với sa bàn khu đô thị FPT City (ảnh thực tế)', 'thư viện' ),
			$im( 'van-phong-ban-hang-mo-hinh', 'Mô hình FPT Plaza 3 và quảng trường FPT City tại văn phòng bán hàng (ảnh thực tế)', 'thư viện' ),
			$im( 'van-phong-ban-hang-mo-hinh-tong-the', 'Sa bàn tổng thể khu đô thị FPT City tại văn phòng bán hàng (ảnh thực tế)', 'thư viện' ),
			$im( 'phoi-canh-ve-dem-quang-truong', 'Phối cảnh FPT Plaza 3 về đêm bên quảng trường trung tâm FPT City', 'thư viện' ),
			$im( 'phoi-canh-tu-tren-cao-huong-cong-vien', 'Phối cảnh FPT Plaza 3 từ trên cao, hướng công viên và quảng trường', 'thư viện' ),
			$im( 'phoi-canh-canh-quang-truong-trung-tam', 'Phối cảnh hai tháp FPT Plaza 3 cạnh quảng trường trung tâm', 'thư viện' ),
			$im( 'phoi-canh-khoi-de-shophouse-hoang-minh-thang', 'Phối cảnh khối đế shophouse FPT Plaza 3 trên đại lộ Hoàng Minh Thắng', 'thư viện' ),
			$im( 'phoi-canh-san-vuon-ban-cong', 'Phối cảnh sân vườn trên cao và lô gia FPT Plaza 3', 'thư viện' ),
			$im( 'phoi-canh-mat-dung-hai-thap', 'Phối cảnh mặt đứng hai tháp W và E FPT Plaza 3', 'thư viện' ),
			$im( 'tien-ich-be-boi-trong-nha', 'Bể bơi trong nhà tầng 3 FPT Plaza 3 (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể bơi trong nhà' ),
			$im( 'tien-ich-sanh-le-tan-thap-w', 'Sảnh lễ tân tháp W FPT Plaza 3 (phối cảnh)', 'tiện ích', 'Sảnh lễ tân' ),
			$im( 'tien-ich-sanh-cho-thap-e', 'Sảnh chờ tháp E FPT Plaza 3 (phối cảnh)', 'tiện ích', 'Sảnh lễ tân' ),
			$im( 'tien-ich-sanh-thang-may', 'Sảnh thang máy FPT Plaza 3 (phối cảnh)', 'tiện ích', 'Sảnh thang máy' ),
			$im( 'mat-bang-tang-3', 'Mặt bằng tầng 3 FPT Plaza 3: bể bơi trong nhà, bể trẻ em, sân vườn trên không', 'mặt bằng', 'Tầng 3' ),
			$im( 'layout-1pn', 'Layout căn 1PN FPT Plaza 3 (41,7 – 63,5 m²)', 'layout', '1PN' ),
			$im( 'layout-1pn-plus-1', 'Layout căn 1PN+1 FPT Plaza 3 (46,88 – 50,6 m²)', 'layout', '1PN+1' ),
			$im( 'layout-2pn-plus-1', 'Layout căn 2PN+1 FPT Plaza 3 (72,67 – 86,32 m²)', 'layout', '2PN+1' ),
			$im( 'layout-3pn', 'Layout căn 3PN FPT Plaza 3 (71,48 – 80,12 m²)', 'layout', '3PN' ),
			$im( 'layout-3pn-plus-1', 'Layout căn 3PN+1 FPT Plaza 3 (81,14 – 123,55 m²)', 'layout', '3PN+1' ),
			$im( 'layout-can-2-tang', 'Layout căn hộ 2 tầng FPT Plaza 3 (88,22 – 148,41 m²)', 'layout', 'Căn 2 tầng' ),
		);
		$new = array(
			'hh_p_scale'        => '6.512 m² đất, mật độ xây dựng 49,98%, tổng sàn xây dựng khoảng 89.278 m²',
			'hh_p_blocks'       => '2 tháp W và E, nối thông tại tầng 3 (bể bơi) và tầng 12B (sân chơi chung)',
			'hh_p_floors'       => '25 tầng nổi, 2 tầng hầm; 12 thang máy căn hộ, 2 thang máy chữa cháy',
			'hh_p_units'        => '837 căn hộ và shophouse khối đế',
			'hh_p_address'      => 'Lô B5-4 đường Hoàng Minh Thắng, Khu đô thị FPT City, Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_unit_area'    => '1PN 41,7 – 63,5 m² · 1PN+1 46,9 – 50,6 m² · 2PN 54,7 – 69,2 m² · 2PN+1 72,7 – 86,3 m² · 3PN 71,5 – 80,1 m² · 3PN+1 81,1 – 123,6 m² · căn 2 tầng 88,2 – 148,4 m²',
			'hh_p_handover'     => 'Đã bàn giao từ 17/4/2026',
			'hh_p_ownership'    => 'Sở hữu lâu dài (khách Việt Nam); có thời hạn với khách nước ngoài theo quy định',
			'hh_p_designer'     => 'Công ty TNHH GK Archi',
			'hh_p_builder'      => 'CTCP Đầu tư và Xây dựng ACE Thái Bình Dương (ACEFIC); giám sát: Viện Khoa học Công nghệ Xây dựng (IBST)',
			'hh_p_amenities_in' => "Bể bơi trong nhà tầng 3 (khu bơi 140 m², 25,2 × 5,7 m) và bể bơi trẻ em\nSân vườn trên không (Sky Garden)\nSân chơi chung trên mái tầng 4 và tầng 12B\nSân vườn chung tầng 1\nPhòng sinh hoạt cộng đồng, lễ tân\nShophouse khối đế\nHầm 116 chỗ ô tô, 1.683 chỗ xe máy – xe đạp; tầng 1 thêm 6 chỗ ô tô, 69 chỗ xe máy\nHầm có hệ thống chống ngập, kiểm soát xe thông minh",
			'hh_p_highlights'   => "4 mặt tiền: Hoàng Minh Thắng 33 m, D11 18,5 m, N16 17,5 m, N18 15,5 m\nTrung tâm Khu đô thị FPT City, cạnh quảng trường – công viên khoảng 30.000 m²\nĐã bàn giao từ 4/2026, sổ hồng lâu dài\nPhí quản lý dự kiến 13.000 đồng/m²/tháng (chưa VAT)\nBể bơi miễn phí năm đầu cho cư dân",
			'hh_p_legal'        => "Thông báo 7190/SXD-QLN ngày 25/09/2024 của Sở Xây dựng Đà Nẵng: nhà ở hình thành trong tương lai đủ điều kiện được bán\nHợp đồng mua bán theo mẫu đã đăng ký với cơ quan nhà nước\nSở hữu lâu dài với khách Việt Nam",
			'hh_p_loan_bank'    => 'TPBank, VietinBank, MB, VPBank, Public Bank',
			'hh_p_handover_std' => 'Hoàn thiện cơ bản theo danh mục vật liệu ký kèm hợp đồng mua bán: sàn phòng khách, ăn, ngủ gỗ công nghiệp; bếp, phòng tắm, lô gia lát gạch men; trần thạch cao khung chìm (Vĩnh Tường/Nanotech); sơn Jotun/Dulux/Nippon; cửa sổ nhôm sơn tĩnh điện kính dán; cửa chính chống cháy, khóa điện tử Kaadas/PHG Lock; cửa phòng gỗ công nghiệp hoặc composite; tủ bếp trên dưới gỗ công nghiệp, mặt đá, chậu và vòi inox.',
		);
		foreach ( $projects as $i => $p ) {
			if ( 'fpt-plaza-3' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['fpt-plaza-3']['meta'][ $k ] ?? '' ) : '' ) );
				if ( '' !== $cur && $cur !== $v ) {
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

/**
 * 08/11/2026: ảnh mặt bằng căn 2PN 57,84 m² bị xếp vào "Ảnh mặt bằng tầng" (hiện lẫn giữa các tab tầng) –
 * chuyển sang "Layout loại căn". Chạy một lần.
 */
add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_fpt3_layout_2pn_v1' ) ) {
			return;
		}
		$p = get_page_by_path( 'fpt-plaza-3', OBJECT, 'du-an' );
		if ( ! $p ) {
			return;
		}
		$done = (array) get_post_meta( $p->ID, '_hh_img_links', true );
		$id   = (int) ( $done['plugin:img/fpt-plaza-3/fpt-plaza-3-mat-bang-can-2pn-57m2.jpg'] ?? 0 );
		if ( ! $id ) {
			return; // Ảnh chưa tải về – lúc tải sẽ vào đúng mục layout.
		}
		$ids   = static fn( $k ) => array_values( array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $p->ID, $k, true ) ) ) ) );
		$floor = $ids( 'hh_p_floorplans' );
		if ( in_array( $id, $floor, true ) ) {
			update_post_meta( $p->ID, 'hh_p_floorplans', implode( ',', array_diff( $floor, array( $id ) ) ) );
			$lay = $ids( 'hh_p_unit_layouts' );
			if ( ! in_array( $id, $lay, true ) ) {
				array_unshift( $lay, $id );
				update_post_meta( $p->ID, 'hh_p_unit_layouts', implode( ',', $lay ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_title' => '2PN' ) );
		}
		update_option( 'hh_fpt3_layout_2pn_v1', '1', false );
	}
);
