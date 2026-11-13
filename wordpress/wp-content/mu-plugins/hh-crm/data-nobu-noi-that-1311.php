<?php
/**
 * Nobu Residences Đà Nẵng – bổ sung 13/11/2026 (anh Hiệp gửi 13 ảnh + bài giới thiệu "Bộ sưu tập sản phẩm đa dạng" của dự án):
 * - 8 ảnh mới (bỏ 5 ảnh trùng ảnh đã có): phòng khách – bếp view biển, toàn cảnh tháp mặt tiền Võ Văn Kiệt, sky lounge hồ bơi,
 *   Sky Villa hồ bơi riêng, 3 ảnh nội thất có chú thích vật liệu, bộ sưu tập căn The Signature. Chỉ có tên vật liệu / thương hiệu
 *   thiết bị trên ảnh, không logo đại lý.
 * - Tiêu chuẩn bàn giao: thêm danh mục nội thất theo chú thích trên ảnh giới thiệu của dự án (sàn gỗ xương cá, sofa Wendelbo hoặc
 *   tương đương, nệm Serta Simmons, đầu giường bọc giấy washi, mặt bếp đá marble nhập khẩu, máy pha cà phê, chậu rửa Kohler, tủ lạnh Smeg).
 * Ô nào anh đã tự sửa trong quản trị thì giữ nguyên.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/nobu-da-nang/nobu-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'toan-canh-thap-mat-tien-vo-van-kiet', 'Toàn cảnh tháp Nobu Residences Đà Nẵng nhìn từ đường Võ Văn Kiệt (phối cảnh chủ đầu tư)', 'thư viện' ),
			$im( 'phong-khach-bep-view-bien-cong', 'Phòng khách liền bếp đảo, vách kính cong nhìn biển Mỹ Khê (hình ảnh minh họa của dự án)', 'thư viện' ),
			$im( 'sky-villa-ho-boi-rieng', 'Sky Villa tầng cao có hồ bơi riêng hướng biển (phối cảnh chủ đầu tư)', 'thư viện' ),
			$im( 'bo-suu-tap-the-signature', 'Bộ sưu tập căn hộ The Signature: phòng tắm bồn view biển, phòng khách, phòng ngủ (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-phong-khach-san-go-xuong-ca', 'Nội thất phòng khách bàn giao: sàn gỗ xương cá, sofa Wendelbo hoặc tương đương (tài liệu giới thiệu dự án)', 'thư viện' ),
			$im( 'noi-that-phong-ngu-nem-serta-simmons', 'Nội thất phòng ngủ: nệm Serta Simmons, đầu giường bọc giấy washi (tài liệu giới thiệu dự án)', 'thư viện' ),
			$im( 'noi-that-bep-an-kohler-smeg', 'Bếp – phòng ăn: mặt đá marble nhập khẩu, máy pha cà phê, chậu rửa Kohler, tủ lạnh Smeg (tài liệu giới thiệu dự án)', 'thư viện' ),
			$im( 'sky-lounge-ho-boi-hoang-hon', 'Sky lounge và hồ bơi vô cực ngắm hoàng hôn trên biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Sky lounge hồ bơi' ),
		);
		$std_old = 'Hoàn thiện nội thất theo tiêu chuẩn Nobu, phong cách Japandi';
		$std_new = 'Hoàn thiện nội thất theo tiêu chuẩn Nobu, phong cách Japandi. Theo tài liệu giới thiệu nội thất của dự án: sàn gỗ xương cá, sofa Wendelbo (hoặc tương đương), nệm Serta Simmons, đầu giường bọc giấy washi, mặt bếp đá marble nhập khẩu, máy pha cà phê, chậu rửa Kohler, tủ lạnh Smeg – danh mục chính xác theo phụ lục hợp đồng từng căn.';
		foreach ( $projects as $i => $p ) {
			if ( 'nobu-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, 'sky-villa-ho-boi-rieng' ) ) {
				$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $imgs ) );
				if ( '' !== $cur ) {
					$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
				}
			}
			$cur_s = (string) ( $p['meta']['hh_p_handover_std'] ?? '' );
			if ( $std_old === $cur_s ) {
				$p['meta']['hh_p_handover_std']     = $std_new;
				$p['fix_meta']['hh_p_handover_std'] = array_merge( (array) ( $p['fix_meta']['hh_p_handover_std'] ?? array() ), array( $cur_s ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	30
);
