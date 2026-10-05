<?php
/**
 * Casamia Balanca Hội An – ảnh tổng quan & phối cảnh (anh Hiệp gửi 05/10/2026), đi kèm plugin trong img/casamia-balanca/.
 * Nhập dữ liệu → web tự đưa ảnh vào Thư viện: toàn cảnh làm ảnh đại diện, 3 phối cảnh vào thư viện ảnh / tiện ích.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'casamia-balanca-hoi-an' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-toan-canh.jpg | Phối cảnh toàn cảnh Casamia Balanca Hội An bên sông Cổ Cò | đại diện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ven-kenh.jpg | Dãy biệt thự ven kênh có bến du thuyền riêng – Casamia Balanca | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-biet-thu-ho-boi-ven-song.jpg | Biệt thự có hồ bơi riêng hướng sông – Casamia Balanca Hội An | tiện ích',
					'plugin:img/casamia-balanca/casamia-balanca-song-co-co-hoang-hon.jpg | Sông Cổ Cò lúc hoàng hôn giữa khu biệt thự Casamia Balanca | thư viện',
				)
			);
		}
		return $projects;
	},
	60
);
