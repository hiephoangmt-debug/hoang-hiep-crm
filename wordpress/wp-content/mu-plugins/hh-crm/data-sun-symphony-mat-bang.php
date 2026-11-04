<?php
/**
 * Sun Symphony Residence: mặt bằng tầng tòa S1, S2, S3 (bản vẽ chủ đầu tư, anh Hiệp gửi 04/11/2026), ảnh trong img/sun-symphony/.
 * Nhập dữ liệu Đà Nẵng: đưa vào "Ảnh mặt bằng tầng" của trang dự án (mỗi ảnh một tab), tải ngầm tối đa 15 ảnh mỗi lượt.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$floors = array(
			'S1' => array(
				'3'        => '3',
				'3a-12a'   => '3A – 12A',
				'12b'      => '12B',
				'15'       => '15',
				'16'       => '16',
				'17-19-21' => '17, 19, 21',
				'18-20-22' => '18, 20, 22',
				'23'       => '23',
				'24'       => '24',
				'25'       => '25',
				'26'       => '26',
				'27'       => '27',
				'28'       => '28',
				'29'       => '29',
				'30'       => '30',
			),
			'S2' => array(
				'3'          => '3',
				'3a'         => '3A',
				'5-9-12a'    => '5, 9, 12A',
				'6-10-12b'   => '6, 10, 12B',
				'7-11'       => '7, 11',
				'8-12'       => '8, 12',
				'15'         => '15',
				'16'         => '16',
				'17'         => '17',
				'18-22'      => '18 – 22',
				'24'         => '24 (penthouse 23 – 24)',
			),
			'S3' => array(
				'3'            => '3',
				'3a'           => '3A',
				'5-9-12a-17'   => '5, 9, 12A, 17',
				'6-10-12b-18'  => '6, 10, 12B, 18',
				'7-11-15-19'   => '7, 11, 15, 19',
				'8-12-16'      => '8, 12, 16',
				'20'           => '20',
				'21'           => '21',
				'22'           => '22',
				'23-28'        => '23 – 28',
				'29'           => '29',
				'30'           => '30',
			),
		);
		$lines = array();
		foreach ( $floors as $tower => $list ) {
			if ( 'S2' === $tower ) {
				// Sơ đồ Hoàng Hiệp tự vẽ từ số liệu chủ đầu tư (ảnh gốc có logo đơn vị phân phối nên không dùng).
				$lines[] = 'plugin:img/sun-symphony/sun-symphony-s2-chieu-cao-tang.jpg | Sơ đồ chiều cao tầng tòa S2 Sun Symphony Residence: shophouse tầng 1 – 2, tiện ích tầng 3, căn hộ tầng 3A – 22, penthouse tầng 15 – 16 và 23 – 24 | mặt bằng | S2 · Chiều cao tầng';
			}
			foreach ( $list as $file => $floor ) {
				$lines[] = sprintf(
					'plugin:img/sun-symphony/sun-symphony-mat-bang-%s-tang-%s.jpg | Mặt bằng tầng %s tòa %s Sun Symphony Residence, mặt sông Hàn (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | %s · Tầng %s',
					strtolower( $tower ),
					$file,
					$floor,
					$tower,
					$tower,
					$floor
				);
			}
		}
		foreach ( $projects as $i => $p ) {
			if ( 'sun-symphony-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] = (array) ( $p['meta'] ?? array() ) + array(
				'hh_p_image_links' => implode( "\n", $lines ),
				'hh_p_design_desc' => 'Ba tòa căn hộ hướng mặt sông Hàn: S1 và S3 cao 30 tầng, S2 cao 24 tầng. Tòa S2 theo tài liệu chủ đầu tư: tầng 1 – 2 là shophouse (tầng 1 cao 7 m, tầng 2 cao 4,5 m); tầng 3 là tầng tiện ích kèm căn Garden House, cao 5,5 m, có hồ bơi vô cực khoảng 450 m², phòng sinh hoạt cộng đồng 325 m² và phòng gym 125 m²; tầng 3A – 22 là căn hộ điển hình, cao tầng 3,5 m (tầng 22 cao 4,1 m), trong đó tầng 3A – 15 có các căn Dual Front; penthouse thông tầng ở tầng 15 – 16 (khối thấp) và tầng 23 – 24 (khối cao), cao tầng 3,5 m. Mặt bằng từng tầng xem ở các tab bên dưới; thông số chính thức theo hợp đồng mua bán.',
			);
		}
		return $projects;
	},
	60
);
