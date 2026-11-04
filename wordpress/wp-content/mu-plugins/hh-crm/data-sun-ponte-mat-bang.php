<?php
/**
 * Sun Ponte Residence: bộ ảnh chủ đầu tư anh Hiệp gửi 04/11/2026 – phối cảnh, mặt bằng tổng thể, mặt bằng tầng 3A – 18,
 * 19/21/23, 20/22/24, sơ đồ chiều cao tầng, layout căn 1PN+, 2PN, 3PN; mô tả thiết kế, đơn giá tham khảo theo view.
 * Bỏ ảnh có logo/chữ chìm của đơn vị phân phối, đơn vị dựng hình. Chỉ điền ô còn trống (thay bản 2.20.115 nếu chưa sửa tay).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/sun-ponte/sun-ponte-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$lines = array(
			$img( 'toan-canh-cau-rong', 'Toàn cảnh Sun Ponte Residence bên sông Hàn, cạnh cầu Rồng, phía trước là phân khu The Rio', 'đại diện' ),
			$img( 'nhin-tu-song-han', 'Sun Ponte Residence và dãy nhà phố The Rio nhìn từ sông Hàn', 'thư viện' ),
			$img( 'nhin-tu-cau-rong', 'Sun Ponte Residence nhìn từ cầu Rồng, xa xa là cầu Trần Thị Lý', 'thư viện' ),
			$img( 'thap-va-cau-tran-thi-ly', 'Tòa tháp Sun Ponte và cầu Trần Thị Lý', 'thư viện' ),
			$img( 'hoang-hon-song-han', 'Sun Ponte Residence lúc hoàng hôn, nhìn qua sông Hàn về trung tâm Đà Nẵng', 'thư viện' ),
			$img( 'hoang-hon-huong-bien', 'Sun Ponte Residence nhìn về biển Mỹ Khê lúc hoàng hôn', 'thư viện' ),
			$img( 'toan-canh-ban-dao-son-tra', 'Sun Ponte Residence nhìn về bán đảo Sơn Trà', 'thư viện' ),
			$img( 've-dem-phao-hoa', 'Sun Ponte Residence về đêm, pháo hoa bên cầu Rồng', 'thư viện' ),
			$img( 'pho-thuong-mai-khoi-de', 'Phố thương mại khối đế Sun Ponte và nhà phố The Rio', 'tiện ích', 'Phố thương mại' ),
			$img( 'shophouse-khoi-de-ve-dem', 'Shophouse khối đế Sun Ponte về đêm', 'tiện ích', 'Shophouse khối đế' ),
			$img( 'sanh-thap-can-ho', 'Sảnh tòa căn hộ và lối vào hầm xe Sun Ponte', 'tiện ích', 'Sảnh tòa căn hộ' ),
			$img( 'nha-pho-the-rio', 'Nhà phố The Rio cạnh tòa tháp Sun Ponte', 'thư viện' ),
			$img( 'mat-bang-tong-the', 'Mặt bằng tổng thể Sun Ponte Residence: tháp căn hộ The Ponte, townhouse và biệt thự The Rio, tiện ích nội khu', 'tổng thể' ),
			$img( 'chieu-cao-tang', 'Sơ đồ chiều cao tầng Sun Ponte: shophouse tầng 1 – 2, tiện ích tầng 3, căn hộ 3A – 17, tầng loft 18, tầng connection 19 – 24, penthouse 25 – 26', 'mặt bằng', 'Chiều cao tầng' ),
			$img( 'mat-bang-tang-3a-18', 'Mặt bằng điển hình tầng 3A – 18 Sun Ponte Residence (bản vẽ chủ đầu tư, tham khảo)', 'mặt bằng', 'Tầng 3A – 18' ),
			$img( 'mat-bang-tang-19-21-23', 'Mặt bằng điển hình tầng 19, 21, 23 Sun Ponte Residence – tầng connection nối hai khối', 'mặt bằng', 'Tầng 19, 21, 23' ),
			$img( 'mat-bang-tang-20-22-24', 'Mặt bằng điển hình tầng 20, 22, 24 Sun Ponte Residence – tầng connection nối hai khối', 'mặt bằng', 'Tầng 20, 22, 24' ),
			$img( 'layout-1pn-plus', 'Layout căn hộ 1PN+ Sun Ponte, kích thước khoảng 7,5 × 7,8 m', 'layout', 'Căn 1PN+' ),
			$img( 'layout-2pn', 'Layout căn hộ 2PN Sun Ponte, kích thước khoảng 10,5 × 7,8 m', 'layout', 'Căn 2PN' ),
			$img( 'layout-3pn', 'Layout căn hộ 3PN Sun Ponte, kích thước khoảng 13,1 × 7,8 m', 'layout', 'Căn 3PN' ),
		);
		$design = 'Tòa tháp The Ponte 26 tầng gồm hai khối, nối với nhau ở các tầng cao. Theo sơ đồ chiều cao tầng của chủ đầu tư: tầng 1 – 2 là shophouse (tầng 1 cao 7 m, tầng 2 cao 4,5 m); tầng 3 là tầng tiện ích cao 5 m với bể bơi ngoài trời, pool bar, kid pool, gym, yoga, phòng xông hơi (steam, sauna), kids club, khu vui chơi trẻ em và phòng sinh hoạt cộng đồng; tầng 3A – 17 là căn hộ điển hình cao 3,5 m; tầng 18 là tầng loft cao 5 m; tầng 19 – 24 là các tầng connection nối hai khối, cao 3,5 – 3,8 m; tầng 25 – 26 là penthouse, cao 7 m. Tầng 3A – 18 có studio 25,8 – 29,4 m², 1PN+ 48,7 – 53,2 m², 2PN 68 – 77,1 m², 3PN 85,1 – 91,1 m² và căn double key 92,2 m²; tầng 19 – 24 thêm căn 1PN 43,5 – 52 m², 1PN+ khoảng 69 m², 2PN 77,9 m², 3PN đến khoảng 112 m², double key 88,2 – 105,3 m². Mặt trước nhìn trực diện sông Hàn; đầu hồi một bên nhìn sông Hàn – cầu Trần Thị Lý, bên kia nhìn sông Hàn – cầu Rồng; mặt sau nhìn về biển Mỹ Khê và thành phố. Khối đế có sảnh căn hộ, sảnh nhà trẻ riêng và lối xuống hầm. Phân khu thấp tầng The Rio nằm giữa đường Trần Hưng Đạo và sông Hàn, có đường dạo bộ và công viên ven sông: nhà phố (townhouse) lô khoảng 133 – 246 m² trên các đường Rio 1, 2, 3, 5; biệt thự song lập khoảng 180 – 256 m² và biệt thự đơn lập khoảng 369 m² dọc đường Rio 6.';
		// Bản plugin 2.20.115 (nếu đã cài và chưa sửa tay) → thay bằng bản đầy đủ.
		$old_lines  = "plugin:img/sun-ponte/sun-ponte-mat-bang-tang-3a-18.jpg | Mặt bằng tầng 3A – 18 Sun Ponte Residence: studio, 1PN+, 2PN, 3PN, căn double key, mặt trước hướng sông Hàn (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | Tầng 3A – 18\nplugin:img/sun-ponte/sun-ponte-tang-tien-ich.jpg | Tầng tiện ích Sun Ponte Residence: bể bơi ngoài trời, kid pool, pool bar, gym – spa, khu vui chơi trẻ em, sinh hoạt cộng đồng | tiện ích | Tầng tiện ích";
		$old_design = 'Mỗi tầng điển hình (tầng 3A – 18) chia hai cánh quanh hai lõi thang, có studio 25,8 – 29,4 m², 1PN+ 48,7 – 53,2 m², 2PN 68 – 77,1 m², 3PN 85,1 – 91,1 m² và căn double key 92,2 m² (thiết kế hai không gian có thể tách riêng, tiện vừa ở vừa cho thuê). Mặt trước nhìn trực diện sông Hàn; đầu hồi một bên nhìn sông Hàn – cầu Trần Thị Lý, bên kia nhìn sông Hàn – cầu Rồng; mặt sau nhìn về biển Mỹ Khê và thành phố. Tầng tiện ích có bể bơi ngoài trời, kid pool, pool bar, gym – spa, khu vui chơi trẻ em, đường dạo bộ và phòng sinh hoạt cộng đồng; khối đế có sảnh căn hộ, sảnh nhà trẻ riêng và lối xuống hầm. Phân khu thấp tầng The Rio nằm giữa đường Trần Hưng Đạo và sông Hàn: nhà phố (townhouse) lô khoảng 133 – 246 m² trên các đường Rio 1, 2, 3, 5; biệt thự song lập khoảng 180 – 256 m² và biệt thự đơn lập khoảng 369 m² dọc đường Rio 6.';
		foreach ( $projects as $i => $p ) {
			if ( 'sun-ponte-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta'] = (array) ( $p['meta'] ?? array() ) + array(
				'hh_p_image_links' => implode( "\n", $lines ),
				'hh_p_design_desc' => $design,
				'hh_p_price_m2'    => 'Khoảng 64 – 96 triệu/m² tùy view (bảng giá tầng 8, tham khảo): trực diện sông Hàn 86 – 96; hướng cầu Rồng ~82; hướng cầu Trần Thị Lý 66 – 74; hướng biển Mỹ Khê – thành phố 64 – 72',
			);
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$fix['hh_p_image_links'] = array_merge( (array) ( $fix['hh_p_image_links'] ?? array() ), array( $old_lines ) );
			$fix['hh_p_design_desc'] = array_merge( (array) ( $fix['hh_p_design_desc'] ?? array() ), array( $old_design ) );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	60
);
