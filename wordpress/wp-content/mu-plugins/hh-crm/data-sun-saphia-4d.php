<?php
/**
 * Sun Saphia Residence: mô hình 4D và công cụ chọn căn (ứng dụng riêng, lưu trong kho mã – projects/sun-saphia/).
 * Trên web: 4D xem tự do (bản công khai, có chữ chìm số điện thoại); "Chọn căn, xem chi tiết" hỏi số Zalo trước.
 * Link dán nguyên bản – giao diện tự bỏ tham số nội bộ (crm, k) và thêm pub=1 khi hiện cho khách.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'sun-saphia-residence' !== $p['slug'] ) {
				continue;
			}
			$p['meta'] += array(
				'hh_p_tour_4d'    => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/958389ad9aeaa5dade1e26076db7fe00b6c0366c/projects/sun-saphia/4d/sun-saphia-4d.html', // Bản điện thoại: tòa nằm giữa, tiêu đề gọn, logo dự án.
				'hh_p_tour_poster' => 'plugin:img/sun-saphia/sun-saphia-mo-hinh-4d-xem-truoc.jpg', // Ảnh chụp từ chính mô hình 4D.
				'hh_p_tour_units' => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c0d1be39dc2a04c79e210554f2726774420ea5a0/projects/sun-saphia/chon-can/chon-can-app.html',
			);
			// Đổi link 4D cũ sang bản điện thoại (chỉ khi ô vẫn là link cũ do web nhập).
			$p['fix_meta'] = ( $p['fix_meta'] ?? array() ) + array( 'hh_p_tour_4d' => array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/a4125c9ea5215c30fb8feed85fe041b8ab21997e/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/352fddb9ce3faf2e3fd2cd009ba7e7e651583507/projects/sun-saphia/4d/sun-saphia-4d.html' ) );
		}
		unset( $p );
		return $projects;
	},
	22
);
