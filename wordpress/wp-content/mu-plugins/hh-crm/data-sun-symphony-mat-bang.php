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
				'24'         => '24',
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
			$projects[ $i ]['meta'] = (array) ( $p['meta'] ?? array() ) + array( 'hh_p_image_links' => implode( "\n", $lines ) );
		}
		return $projects;
	},
	60
);
