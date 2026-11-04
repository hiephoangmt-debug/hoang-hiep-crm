<?php
/**
 * Spana Tower – tiến độ xây dựng tháng 11/2026: ảnh flycam công trường anh Hiệp gửi 04/11/2026 (img/spana-tower/*tien-do-11-2026*),
 * thêm vào "Ảnh tiến độ thực tế" và bảng "Tiến độ xây dựng". Ảnh nối thêm vào danh sách ảnh hiện có (không đụng chỗ đã sửa tay).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt ) => "plugin:img/spana-tower/spana-tower-tien-do-11-2026-$file.jpg | $alt (tiến độ 11/2026) | tiến độ";
		$lines = array(
			$img( '2-toa-ven-song-cau-hoa-xuan', 'Hai tòa Spana Tower đang thi công phần thân bên sông Cẩm Lệ, cạnh cầu Hòa Xuân' ),
			$img( 'nhin-tu-bo-song-cam-le', 'Công trường Spana Tower nhìn từ bờ sông Cẩm Lệ, hai tòa hai bên đường dẫn cầu Hòa Xuân' ),
			$img( 'nhin-tu-cau-hoa-xuan', 'Spana Tower nhìn từ cầu Hòa Xuân, hai tòa S1, S2 với cẩu tháp' ),
			$img( '2-toa-hai-ben-duong-dan-cau', 'Hai tòa Spana Tower hai bên đường dẫn cầu Hòa Xuân, phủ lưới an toàn' ),
			$img( 'toa-thap-nhin-chinh-dien', 'Tòa tháp Spana Tower đang lên khoảng tầng 10' ),
			$img( 'toa-thap-huong-ngu-hanh-son', 'Tòa tháp Spana Tower nhìn về Ngũ Hành Sơn' ),
			$img( 'nhin-tu-tren-cao', 'Flycam từ trên cao: hai tòa Spana Tower hai bên đường dẫn cầu Hòa Xuân' ),
			$img( 'nhin-tu-tren-cao-huong-nguoc', 'Flycam từ trên cao hướng ngược lại: mặt sàn hai tòa Spana Tower' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'spana-tower' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false === strpos( $cur, 'tien-do-11-2026' ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $lines ) );
				// Web đang có đúng danh sách ảnh cũ (chưa sửa tay) → thay bằng danh sách có thêm ảnh tiến độ.
				if ( '' !== $cur ) {
					$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
				}
			}
			$projects[ $i ]['meta'] += array(
				'hh_p_progress' => "11/2026 | Hai tòa S1, S2 hai bên đường dẫn cầu Hòa Xuân đang thi công phần thân, lên khoảng tầng 10 (theo ảnh flycam công trường); cẩu tháp hoạt động, lưới an toàn phủ kín\n30/06/2027 | Bàn giao căn hộ (dự kiến theo chủ đầu tư)",
			);
		}
		return $projects;
	},
	60
);
