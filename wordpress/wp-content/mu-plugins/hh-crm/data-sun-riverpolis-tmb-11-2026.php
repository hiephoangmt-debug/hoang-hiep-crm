<?php
/**
 * Sun Riverpolis – tổng mặt bằng toàn khu Hòa Quý (anh Hiệp gửi 09/11/2026, bản đồ quy hoạch của chủ đầu tư).
 * Thêm vào trang Sun Riverpolis (ảnh tổng thể + danh sách tiện ích theo chú thích bản đồ)
 * và trang FourS Tower, Tòa F2 (ảnh cắt vị trí 4 ô chung cư tại ngã tư Nguyễn Phước Lan – Minh Mạng).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$tmb   = 'plugin:img/sun-riverpolis/sun-riverpolis-tong-mat-bang-toan-khu-hoa-quy.jpg | Tổng mặt bằng toàn khu Sun Riverpolis Hòa Quý: nhà phố (townhouse), nhà liền kề, biệt thự ven sông, chung cư và công viên ven sông | tổng thể | Tổng mặt bằng toàn khu';
		$fours = 'plugin:img/fours-tower/fours-tower-vi-tri-tren-tong-mat-bang-sun-riverpolis.jpg | Vị trí FourS Tower trên tổng mặt bằng Sun Riverpolis: 4 ô chung cư (màu xanh) tại ngã tư Nguyễn Phước Lan – Minh Mạng | tổng thể | Vị trí trên tổng mặt bằng';
		$add   = array(
			'sun-riverpolis'          => array( $tmb ),
			'fours-tower'             => array( $fours, $tmb ),
			'fours-tower-f2-thap-mai' => array( $fours ),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $add[ $slug ] ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $cur ) {
				$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$p['fix_meta']['hh_p_image_links'][] = $cur;
			}
			$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $add[ $slug ] ) );
			if ( 'sun-riverpolis' === $slug && empty( $p['meta']['hh_p_amenities_in'] ) ) {
				$p['meta']['hh_p_amenities_in'] = "Công viên ven sông và đường dạo bộ bao quanh khu đô thị\nCông viên bến du thuyền, công viên nghệ thuật, công viên phong cách sống\nCông viên ven hồ, đồi ánh sáng, đồi hoa, đồi biển tên\nCông viên thể thao, công viên trẻ em, sân đa năng, khu thể thao, clubhouse\nTrường mẫu giáo, tiểu học, THCS, THPT và khu phát triển giáo dục\nTrung tâm văn hóa, công trình tôn giáo, vườn tiểu cảnh";
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	70
);
