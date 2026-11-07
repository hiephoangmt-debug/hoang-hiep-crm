<?php
/**
 * Ảnh flycam thực tế anh Hiệp gửi (thư mục Drive Hòa Xuân, chụp 8/2025):
 * – Sun NeO City: toàn cảnh khu Hòa Xuân ven sông Cẩm Lệ;
 * – Sun Riverpolis (Nam Hòa Xuân): công viên ven sông, sân thể thao, Ngũ Hành Sơn, dãy nhà phố ven sông.
 * Thêm vào mục Ảnh thực tế (tiến độ), giữ nguyên ảnh đại diện và các ảnh cũ. Chỉ thay ô ảnh khi còn đúng giá trị web nhập.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$add = array(
			'sun-neo-city'   => array(
				'hoa-xuan/hoa-xuan-flycam-8-2025-toan-canh-ven-song-cam-le' => 'Toàn cảnh khu đô thị ven sông Hòa Xuân, sông Cẩm Lệ uốn quanh, nhìn về trung tâm Đà Nẵng và Sơn Trà',
				'hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-nhin-ve-trung-tam' => 'Sông Cẩm Lệ và khu Hòa Xuân nhìn về trung tâm Đà Nẵng, cầu qua sông',
				'hoa-xuan/hoa-xuan-flycam-8-2025-day-pho-ven-song-nhin-ve-cau-rong' => 'Dãy nhà phố ven sông Hòa Xuân, phía xa là vòng quay Asia Park và các cây cầu sông Hàn',
				'hoa-xuan/hoa-xuan-flycam-8-2025-song-cam-le-va-trung-tam-da-nang' => 'Bờ sông Hòa Xuân – sông Cẩm Lệ, cầu nối sang trung tâm Đà Nẵng',
				'hoa-xuan/hoa-xuan-flycam-8-2025-bo-song-hoa-xuan-asia-park' => 'Bờ sông Hòa Xuân rợp cây, đối diện trung tâm thành phố',
			),
			'sun-riverpolis' => array(
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-cong-vien-ven-song-ngu-hanh-son' => 'Công viên, sân thể thao ven sông khu Nam Hòa Xuân, phía sau là Ngũ Hành Sơn và biển',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-san-bong-cong-vien-ven-song' => 'Sân bóng và công viên ven sông khu Nam Hòa Xuân, nhìn về trung tâm Đà Nẵng',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-ngu-hanh-son-nhin-tu-cong-vien' => 'Ngũ Hành Sơn và chùa bên hồ, nhìn từ công viên khu Nam Hòa Xuân',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-quang-truong-cong-vien-ven-song' => 'Quảng trường, công viên ven sông khu Nam Hòa Xuân',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-quang-truong-ho-va-ngu-hanh-son' => 'Quảng trường bên hồ, phía sau là Ngũ Hành Sơn – khu Nam Hòa Xuân',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-duong-noi-khu-san-the-thao' => 'Đường nội khu, sân thể thao và mảng xanh ven sông khu Nam Hòa Xuân',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-toan-canh-nhin-ra-bien' => 'Toàn cảnh khu Nam Hòa Xuân bên sông, Ngũ Hành Sơn và biển phía xa',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-8-2025-phan-lo-ven-song-ngu-hanh-son' => 'Các dãy lô ven sông khu Nam Hòa Xuân, đối diện Ngũ Hành Sơn',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-day-nha-pho-ven-song' => 'Dãy nhà phố ven sông khu Nam Hòa Xuân',
				'nam-hoa-xuan/nam-hoa-xuan-flycam-nha-pho-duong-ven-song' => 'Nhà phố và đường dạo ven sông khu Nam Hòa Xuân',
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $add[ $slug ] ) ) {
				continue;
			}
			$lines = array();
			foreach ( $add[ $slug ] as $file => $alt ) {
				$month   = false !== strpos( $file, '8-2025' ) ? 'Thực tế 8/2025' : 'Ảnh thực tế';
				$lines[] = "plugin:img/$file.jpg | $alt (ảnh flycam thực tế" . ( 'Ảnh thực tế' === $month ? '' : ' 8/2025' ) . ") | tiến độ | $month";
			}
			$old = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['meta']['hh_p_image_links']     = trim( $old . "\n" . implode( "\n", $lines ) );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $old;
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	95
);
