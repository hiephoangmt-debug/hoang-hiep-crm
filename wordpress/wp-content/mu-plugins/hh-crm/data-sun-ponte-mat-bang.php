<?php
/**
 * Sun Ponte Residence: mặt bằng tầng 3A – 18, tầng tiện ích (anh Hiệp gửi 04/11/2026; đã che/cắt logo đơn vị phân phối),
 * cơ cấu căn theo hướng view, đơn giá tham khảo theo view và quy hoạch The Rio (số liệu đọc từ ảnh – ảnh có chữ chìm
 * của trang khác nên không đăng). Chỉ điền ô còn trống.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$lines = array(
			'plugin:img/sun-ponte/sun-ponte-mat-bang-tang-3a-18.jpg | Mặt bằng tầng 3A – 18 Sun Ponte Residence: studio, 1PN+, 2PN, 3PN, căn double key, mặt trước hướng sông Hàn (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | Tầng 3A – 18',
			'plugin:img/sun-ponte/sun-ponte-tang-tien-ich.jpg | Tầng tiện ích Sun Ponte Residence: bể bơi ngoài trời, kid pool, pool bar, gym – spa, khu vui chơi trẻ em, sinh hoạt cộng đồng | tiện ích | Tầng tiện ích',
		);
		$design = 'Mỗi tầng điển hình (tầng 3A – 18) chia hai cánh quanh hai lõi thang, có studio 25,8 – 29,4 m², 1PN+ 48,7 – 53,2 m², 2PN 68 – 77,1 m², 3PN 85,1 – 91,1 m² và căn double key 92,2 m² (thiết kế hai không gian có thể tách riêng, tiện vừa ở vừa cho thuê). Mặt trước nhìn trực diện sông Hàn; đầu hồi một bên nhìn sông Hàn – cầu Trần Thị Lý, bên kia nhìn sông Hàn – cầu Rồng; mặt sau nhìn về biển Mỹ Khê và thành phố. Tầng tiện ích có bể bơi ngoài trời, kid pool, pool bar, gym – spa, khu vui chơi trẻ em, đường dạo bộ và phòng sinh hoạt cộng đồng; khối đế có sảnh căn hộ, sảnh nhà trẻ riêng và lối xuống hầm. Phân khu thấp tầng The Rio nằm giữa đường Trần Hưng Đạo và sông Hàn: nhà phố (townhouse) lô khoảng 133 – 246 m² trên các đường Rio 1, 2, 3, 5; biệt thự song lập khoảng 180 – 256 m² và biệt thự đơn lập khoảng 369 m² dọc đường Rio 6.';
		foreach ( $projects as $i => $p ) {
			if ( 'sun-ponte-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] = (array) ( $p['meta'] ?? array() ) + array(
				'hh_p_image_links' => implode( "\n", $lines ),
				'hh_p_design_desc' => $design,
				'hh_p_price_m2'    => 'Khoảng 64 – 96 triệu/m² tùy view (bảng giá tầng 8, tham khảo): trực diện sông Hàn 86 – 96; hướng cầu Rồng ~82; hướng cầu Trần Thị Lý 66 – 74; hướng biển Mỹ Khê – thành phố 64 – 72',
			);
		}
		return $projects;
	},
	60
);
