<?php
/**
 * FourS Tower – bổ sung 08/11/2026 từ bộ tài liệu anh Hiệp gửi (Drive):
 * tổng mặt bằng 4 tháp, 7 phối cảnh mới, 13 phối cảnh Tòa F2 (kiến trúc, ban công, view), 5 layout 3D căn hộ F2,
 * mặt bằng tầng 1 – 3 Tòa F2 và bảng tiêu chuẩn bàn giao căn hộ (T5/2026) của chủ đầu tư.
 * Không đăng giỏ ngân hàng, kế hoạch marketing, slide đào tạo, giấy đăng ký doanh nghiệp.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/fours-tower/fours-tower-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$main = array(
			$im( 'tong-mat-bang-nga-tu-nguyen-phuoc-lan-minh-mang', 'Tổng mặt bằng 4 tháp FourS Tower tại ngã tư Nguyễn Phước Lan – Minh Mạng', 'tổng thể' ),
			$im( 'phoi-canh-dem-trang', 'FourS Tower về đêm (phối cảnh chủ đầu tư)', 'thư viện' ),
			$im( 'phoi-canh-ban-ngay', 'Cụm tháp FourS Tower ban ngày (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-tren-cao-song-co-co', 'FourS Tower nhìn từ trên cao giữa đô thị Sun Riverpolis (phối cảnh)', 'thư viện' ),
			$im( 'cong-vien-noi-khu', 'Công viên nội khu cạnh FourS Tower (phối cảnh)', 'tiện ích', 'Công viên' ),
			$im( 'khoi-de-thuong-mai', 'Khối đế thương mại FourS Tower (phối cảnh)', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'pho-thuong-mai-hoang-hon', 'Phố thương mại dưới chân tháp lúc hoàng hôn (phối cảnh)', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'truc-duong-giua-hai-cum-thap', 'Trục đường giữa hai cụm tháp FourS Tower (phối cảnh)', 'thư viện' ),
		);
		$f2   = array(
			$im( 'f2-kien-truc-toa-f2', 'Kiến trúc Tòa F2 – Tháp Mai FourS Tower (phối cảnh)', 'thư viện' ),
			$im( 'f2-kien-truc-toa-f2-goc-2', 'Tòa F2 – Tháp Mai nhìn từ trục đường (phối cảnh)', 'thư viện' ),
			$im( 'f2-kien-truc-toa-f2-f3', 'Tòa F2 và tòa bên cạnh nhìn từ ngã tư (phối cảnh)', 'thư viện' ),
			$im( 'f2-tong-the-hoang-hon', 'FourS Tower và Tòa F2 lúc hoàng hôn, hướng sông và biển (phối cảnh)', 'thư viện' ),
			$im( 'f2-hai-cum-thap-truc-duong', 'Hai cụm tháp FourS Tower hai bên trục đường (phối cảnh)', 'thư viện' ),
			$im( 'f2-thap-nhin-ve-trung-tam', 'Tòa tháp nhìn về sông Hàn và trung tâm Đà Nẵng (phối cảnh)', 'thư viện' ),
			$im( 'f2-thap-nhin-ra-song', 'Căn hộ sân vườn trên cao nhìn ra sông (phối cảnh)', 'thư viện' ),
			$im( 'f2-view-song-bien', 'Từ tháp nhìn ra sông và biển (phối cảnh)', 'thư viện' ),
			$im( 'f2-san-vuon-tren-cao', 'Sân vườn trên cao của căn hộ sân vườn (phối cảnh)', 'thư viện' ),
			$im( 'f2-ban-cong-hoang-hon', 'Ban công căn hộ lúc hoàng hôn (phối cảnh)', 'thư viện' ),
			$im( 'f2-ban-cong-view-khu-biet-thu', 'Ban công căn hộ nhìn ra khu biệt thự Sun Riverpolis (phối cảnh)', 'thư viện' ),
			$im( 'f2-ban-cong-view-ngu-hanh-son', 'Ban công căn hộ nhìn về Ngũ Hành Sơn và biển (phối cảnh)', 'thư viện' ),
			$im( 'f2-kien-truc-khoi-de', 'Khối đế Tòa F2 (phối cảnh)', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'f2-layout-studio', 'Layout 3D căn Studio Tòa F2', 'layout', 'Studio' ),
			$im( 'f2-layout-1pn-plus', 'Layout 3D căn 1PN+ Tòa F2', 'layout', '1PN+' ),
			$im( 'f2-layout-2pn-1wc', 'Layout 3D căn 2PN 1WC Tòa F2', 'layout', '2PN 1WC' ),
			$im( 'f2-layout-2pn', 'Layout 3D căn 2PN 2WC Tòa F2', 'layout', '2PN 2WC' ),
			$im( 'f2-layout-3pn', 'Layout 3D căn 3PN Tòa F2', 'layout', '3PN' ),
			$im( 'f2-mat-bang-tang-1', 'Mặt bằng tầng 1 Tòa F2 – Tháp Mai FourS Tower', 'mặt bằng', 'Tầng 1' ),
			$im( 'f2-mat-bang-tang-2', 'Mặt bằng tầng 2 Tòa F2 – Tháp Mai FourS Tower', 'mặt bằng', 'Tầng 2' ),
			$im( 'f2-mat-bang-tang-3', 'Mặt bằng tầng 3 Tòa F2 – Tháp Mai FourS Tower', 'mặt bằng', 'Tầng 3' ),
		);
		$std  = 'Bàn giao hoàn thiện cơ bản theo bảng tiêu chuẩn của chủ đầu tư (T5/2026): trần thạch cao, sơn Dulux/Jotun; phòng khách – bếp lát gạch, phòng ngủ lát gạch hoặc gỗ công nghiệp; cửa chính gỗ chống cháy, cửa nhôm Xingfa kính dán an toàn, lan can lô gia kính cường lực; điện chiếu sáng, ổ cắm; ống chờ điều hòa, cấp thoát nước. Khách tự trang bị tủ bếp, thiết bị bếp, thiết bị vệ sinh, bình nóng lạnh, đồ rời.';
		$add  = array(
			'fours-tower'             => $main,
			'fours-tower-f2-thap-mai' => array_merge( $f2, array( $main[0] ) ),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! in_array( $slug, array( 'fours-tower', 'fours-tower-f1-thap-tung', 'fours-tower-f5-thap-cuc', 'fours-tower-f2-thap-mai' ), true ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_handover_std'] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()[ $slug ]['meta']['hh_p_handover_std'] ?? '' ) : '' ) );
			if ( '' !== $cur && $cur !== $std ) {
				$p['fix_meta']['hh_p_handover_std']   = (array) ( $p['fix_meta']['hh_p_handover_std'] ?? array() );
				$p['fix_meta']['hh_p_handover_std'][] = $cur;
			}
			$p['meta']['hh_p_handover_std'] = $std;
			if ( isset( $add[ $slug ] ) ) {
				$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
				$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$p['fix_meta']['hh_p_image_links'][] = $cur;
				$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $add[ $slug ] ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	65 // Sau data-fours-f2-mat-bang.php (ưu tiên 60).
);
