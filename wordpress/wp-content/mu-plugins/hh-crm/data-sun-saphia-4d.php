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
				'hh_p_tour_4d'    => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/e6e0970dcea56a7da0ceeddfd7fbedcc5f870a1c/projects/sun-saphia/4d/sun-saphia-4d.html', // Bản 26/10/2026: mặt bằng tầng 30 trên tòa nhà, bấm từng căn.
				'hh_p_tour_poster' => 'plugin:img/sun-saphia/sun-saphia-mo-hinh-4d-xem-truoc.jpg', // Ảnh chụp từ chính mô hình 4D.
				'hh_p_tour_units' => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c361b624026a585531075b74aefde75ca4cfc756/projects/sun-saphia/chon-can/chon-can-app.html',
			);
			// Đổi link 4D cũ sang bản điện thoại (chỉ khi ô vẫn là link cũ do web nhập).
			$p['fix_meta'] = ( $p['fix_meta'] ?? array() ) + array( 'hh_p_tour_4d' => array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/958389ad9aeaa5dade1e26076db7fe00b6c0366c/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/a4125c9ea5215c30fb8feed85fe041b8ab21997e/projects/sun-saphia/4d/sun-saphia-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/352fddb9ce3faf2e3fd2cd009ba7e7e651583507/projects/sun-saphia/4d/sun-saphia-4d.html' ) );
			$p['fix_meta']['hh_p_tour_units'] = array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c0d1be39dc2a04c79e210554f2726774420ea5a0/projects/sun-saphia/chon-can/chon-can-app.html' );
			// Ảnh đại diện nét hơn (phối cảnh tòa tháp bên biển lúc hoàng hôn, không có chữ in sẵn) thay ảnh cũ bị mờ.
			$old_img = 'plugin:img/sun-saphia/sun-saphia-phoi-canh-ven-bien-son-thuy.jpg | Phối cảnh Sun Saphia Residence – căn hộ 30 tầng của Sun Group bên biển Sơn Thủy, Đà Nẵng | đại diện';
			$new_img = 'plugin:img/sun-saphia/sun-saphia-phoi-canh-thap-bien-hoang-hon.jpg | Phối cảnh Sun Saphia Residence – tòa tháp 30 tầng bên biển Sơn Thủy lúc hoàng hôn, Đà Nẵng | đại diện';
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$new   = str_replace( $old_img, $new_img, $links );
			// Mặt bằng từng tầng (tài liệu chủ đầu tư 10/2026, đã che mã căn).
			foreach ( array(
				'tang-2'               => 'Mặt bằng tầng 2 Sun Saphia Residence: bể bơi, gym & yoga và 12 căn hộ | mặt bằng | Tầng 2',
				'tang-3'               => 'Mặt bằng tầng 3 Sun Saphia Residence: 28 căn studio, 1PN+, 2PN | mặt bằng | Tầng 3',
				'tang-3a-28-dien-tich' => 'Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence kèm diện tích từng căn | mặt bằng | Tầng 3A – 28',
				'tang-29'              => 'Mặt bằng tầng 29 Sun Saphia Residence: 26 căn hộ, vườn trên cao | mặt bằng | Tầng 29',
				'tang-30'              => 'Mặt bằng tầng 30 Sun Saphia Residence: 19 căn 1PN, 1PN+, 2PN | mặt bằng | Tầng 30',
			) as $f => $line ) {
				$row = 'plugin:img/sun-saphia/sun-saphia-mat-bang-' . $f . '.jpg | ' . $line;
				if ( false === strpos( $new, 'sun-saphia-mat-bang-' . $f . '.jpg' ) ) {
					$new .= "\n" . $row;
				}
			}
			if ( $new !== $links ) {
				$p['meta']['hh_p_image_links'] = $new;
				$olds                          = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$olds[]                        = $links; // Chỉ đổi khi ô ảnh vẫn là giá trị web nhập (chưa sửa tay).
				$olds[]                        = str_replace( $old_img, $new_img, $links ); // Bản đã đổi ảnh đại diện (2.20.82).
				$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( $olds ) );
			}
		}
		unset( $p );
		return $projects;
	},
	22
);
