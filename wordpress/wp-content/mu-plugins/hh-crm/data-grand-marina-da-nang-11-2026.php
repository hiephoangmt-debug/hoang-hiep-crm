<?php
/**
 * Grand Marina Da Nang (Khu căn hộ cao cấp Đà Nẵng) – trang dự án mới, 09/11/2026, từ bộ tài liệu anh Hiệp gửi:
 * hồ sơ pháp lý (QĐ 3023/QĐ-UBND ngày 08/7/2026 về giá đất, danh mục văn bản), phối cảnh, mặt bằng tầng, mặt bằng căn hộ.
 * Ảnh mặt bằng căn hộ đã cắt bỏ cột thông tin có logo đơn vị phân phối và mã căn; phối cảnh, mặt bằng tầng chỉ có logo dự án.
 * Chưa có bảng giá công khai → giá "Liên hệ". Không đăng scan văn bản, tài liệu bán hàng nội bộ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $p ) {
			if ( 'grand-marina-da-nang' === ( $p['slug'] ?? '' ) ) {
				return $projects;
			}
		}
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/grand-marina-da-nang/grand-marina-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-toa-thap-ven-bien', 'Grand Marina Da Nang – tòa căn hộ 34 tầng trên đường Nguyễn Tất Thành, ven vịnh Đà Nẵng (phối cảnh)', 'đại diện' ),
			$im( 'phoi-canh-mat-tien-nguyen-tat-thanh', 'Mặt tiền Grand Marina Da Nang trên đường Nguyễn Tất Thành (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-ban-ngay', 'Tòa tháp Grand Marina Da Nang ban ngày (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-nhin-ra-bien-nguyen-tat-thanh', 'Grand Marina Da Nang nhìn ra biển Nguyễn Tất Thành (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-va-vinh-da-nang', 'Grand Marina Da Nang bên vịnh Đà Nẵng (phối cảnh)', 'tổng thể' ),
			$im( 'phoi-canh-ve-dem', 'Grand Marina Da Nang về đêm (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-goc-thap', 'Tòa tháp Grand Marina Da Nang nhìn từ dưới lên (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-dinh-thap', 'Đỉnh tháp và logo Grand Marina Da Nang (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-khoi-de-va-san-vuon', 'Khối đế và sân vườn Grand Marina Da Nang (phối cảnh)', 'thư viện' ),
			$im( 'tien-ich-khoi-de-thuong-mai', 'Khối đế thương mại dịch vụ (phối cảnh)', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'tien-ich-cua-hang-khoi-de', 'Cửa hàng khối đế mặt đường Nguyễn Tất Thành (phối cảnh)', 'tiện ích', 'Khối đế thương mại' ),
			$im( 'tien-ich-ho-boi', 'Hồ bơi Grand Marina Da Nang (phối cảnh)', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-ho-boi-ghe-tam-nang', 'Hồ bơi và khu tắm nắng (phối cảnh)', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-san-vuon-tren-cao', 'Sân vườn, lounge trên cao (phối cảnh)', 'tiện ích', 'Sân vườn' ),
			$im( 'mat-bang-tang-ham-b1', 'Mặt bằng tầng hầm B1 Grand Marina Da Nang', 'mặt bằng', 'Hầm B1' ),
			$im( 'mat-bang-tang-1', 'Mặt bằng tầng 1: sảnh đón, mini mart, cơ sở giáo dục mầm non, sân vườn', 'mặt bằng', 'Tầng 1' ),
			$im( 'mat-bang-tang-2', 'Mặt bằng tầng 2 Grand Marina Da Nang', 'mặt bằng', 'Tầng 2' ),
			$im( 'mat-bang-tang-3', 'Mặt bằng tầng 3 Grand Marina Da Nang', 'mặt bằng', 'Tầng 3' ),
			$im( 'mat-bang-tang-5', 'Mặt bằng tầng 5: hồ bơi và tiện ích', 'mặt bằng', 'Tầng 5' ),
			$im( 'mat-bang-tang-6', 'Mặt bằng căn hộ tầng 6', 'mặt bằng', 'Tầng 6' ),
			$im( 'mat-bang-tang-7-9-11-dien-hinh', 'Mặt bằng căn hộ điển hình tầng 7, 9, 11, 12A, 16, 18, 22, 24, 26, 28', 'mặt bằng', 'Tầng 7, 9, 11…' ),
			$im( 'mat-bang-tang-8-10-dien-hinh', 'Mặt bằng căn hộ điển hình tầng 8, 10, 12, 15, 17, 19, 21, 23, 25, 27, 29', 'mặt bằng', 'Tầng 8, 10, 12…' ),
			$im( 'mat-bang-tang-12b-lanh-nan', 'Mặt bằng tầng 12B (tầng lánh nạn)', 'mặt bằng', 'Tầng 12B' ),
			$im( 'mat-bang-tang-20', 'Mặt bằng căn hộ tầng 20', 'mặt bằng', 'Tầng 20' ),
			$im( 'mat-bang-tang-30', 'Mặt bằng căn hộ tầng 30', 'mặt bằng', 'Tầng 30' ),
			$im( 'mat-bang-tang-34', 'Mặt bằng căn hộ tầng 34', 'mặt bằng', 'Tầng 34' ),
			$im( 'mat-bang-tang-tum', 'Mặt bằng tầng tum Grand Marina Da Nang', 'mặt bằng', 'Tầng tum' ),
			$im( 'layout-can-1pn-41-29m2', 'Mặt bằng căn hộ 1 phòng ngủ 41,29 m² thông thủy', 'layout', '1PN 41,29 m²' ),
			$im( 'layout-can-2pn-64-93m2', 'Mặt bằng căn hộ 2 phòng ngủ 64,93 m² thông thủy, view sông Cu Đê', 'layout', '2PN 64,93 m²' ),
			$im( 'layout-can-2pn-69-48m2', 'Mặt bằng căn hộ 2 phòng ngủ 69,48 m² thông thủy', 'layout', '2PN 69,48 m²' ),
			$im( 'layout-can-2pn-73-1m2', 'Mặt bằng căn hộ 2 phòng ngủ 73,1 m² thông thủy, view biển', 'layout', '2PN 73,1 m²' ),
			$im( 'layout-can-2pn-73-8m2', 'Mặt bằng căn hộ 2 phòng ngủ 73,8 m² thông thủy, view biển', 'layout', '2PN 73,8 m²' ),
			$im( 'layout-can-2pn-79-9m2', 'Mặt bằng căn hộ 2 phòng ngủ góc 79,9 m² thông thủy', 'layout', '2PN 79,9 m²' ),
			$im( 'layout-can-3pn-84-07m2', 'Mặt bằng căn hộ 3 phòng ngủ 84,07 m² thông thủy', 'layout', '3PN 84,07 m²' ),
		);

		$projects[] = array(
			'slug'    => 'grand-marina-da-nang',
			'title'   => 'Grand Marina Da Nang',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'lien-chieu',
			'excerpt' => 'Grand Marina Da Nang – tòa căn hộ 34 tầng, 3 hầm của BNC Land trên đường Nguyễn Tất Thành (Hòa Hiệp, phường Hải Vân), view vịnh Đà Nẵng và sông Cu Đê; 379 căn được Sở Xây dựng xác nhận đủ điều kiện bán (9/2026).',
			'meta'    => array(
				'hh_p_status'       => 'dang-mo-ban',
				'hh_p_developer'    => 'Công ty Cổ phần BNC Land',
				'hh_p_designer'     => 'Viện Quy hoạch Xây dựng Đà Nẵng',
				'hh_p_type'         => 'Căn hộ chung cư 1 – 3 phòng ngủ, khối đế thương mại dịch vụ',
				'hh_p_address'      => 'Lô 3 và Lô 4 khu A2-1 đường Nguyễn Tất Thành, KDC Hòa Hiệp 2, phường Hải Vân (Hòa Hiệp Nam, Liên Chiểu cũ), Đà Nẵng',
				'hh_p_map_address'  => 'Nguyễn Tất Thành, Hòa Hiệp Nam, Liên Chiểu, Đà Nẵng',
				'hh_p_scale'        => 'Khu đất 3.440,8 m²',
				'hh_p_blocks'       => '1 tòa căn hộ',
				'hh_p_floors'       => '34 tầng nổi, 3 tầng hầm và tầng tum',
				'hh_p_units'        => '379 căn hộ đủ điều kiện bán nhà ở hình thành trong tương lai (Công văn 17683/SXD-QLN của Sở Xây dựng)',
				'hh_p_unit_area'    => 'Khoảng 41 – 84 m² thông thủy (1PN – 3PN, theo mặt bằng căn hộ điển hình)',
				'hh_p_unit_types'   => "Căn 1PN | 41,29 m² | 1 | Liên hệ\nCăn 2PN | 64,93 – 79,9 m² | 2 | Liên hệ\nCăn 3PN | 84,07 m² | 3 | Liên hệ",
				'hh_p_ownership'    => 'Sở hữu lâu dài (căn hộ chung cư thương mại)',
				'hh_p_legal'        => "Sở Xây dựng xác nhận 379 căn hộ đủ điều kiện bán nhà ở hình thành trong tương lai (Công văn 17683/SXD-QLN, báo chí đưa tin 9/2026)\nQuy hoạch tổng mặt bằng duyệt theo Quyết định 151/QĐ-UBND ngày 15/01/2025 của UBND quận Liên Chiểu (cũ)\nQuyết định 3023/QĐ-UBND ngày 08/7/2026 của UBND thành phố phê duyệt giá đất cụ thể để tính nghĩa vụ tài chính bổ sung do điều chỉnh quy hoạch\nĐã có quyết định chấp thuận chủ trương đầu tư, phê duyệt thiết kế cơ sở và các thỏa thuận đấu nối điện, nước, giao thông",
				'hh_p_highlights'   => "Mặt tiền đường Nguyễn Tất Thành, view biển vịnh Đà Nẵng; phía sau view sông Cu Đê, hướng đèo Hải Vân – Nam Ô\nTòa 34 tầng nổi, 3 tầng hầm, khối đế thương mại dịch vụ\n379 căn đủ điều kiện bán theo xác nhận của Sở Xây dựng\nCăn 1 – 3 phòng ngủ khoảng 41 – 84 m², nhiều căn view biển trực diện\nGần cảng Liên Chiểu, Khu công nghệ cao và các vị trí Khu thương mại tự do phía Bắc thành phố",
				'hh_p_design_desc'  => 'Tòa tháp 34 tầng nổi, 3 tầng hầm và tum; tầng 1 bố trí sảnh đón, mini mart, cơ sở giáo dục mầm non và sân vườn; tầng 5 có hồ bơi và khu tắm nắng; tầng 12B là tầng lánh nạn. Mỗi tầng căn hộ điển hình chia 2 cánh, hành lang rộng khoảng 1,8 m; căn phía trước nhìn ra biển Nguyễn Tất Thành, căn phía sau nhìn sông Cu Đê, hai đầu hồi hướng Hải Vân – Nam Ô và thành phố.',
				'hh_p_location_desc' => 'Grand Marina Da Nang nằm trên trục ven biển Nguyễn Tất Thành, khu dân cư Hòa Hiệp 2 (nay thuộc phường Hải Vân), phía Bắc Đà Nẵng. Quy hoạch chung thành phố đến 2050 xác định trục phát triển dọc Nguyễn Tất Thành; khu vực gần cảng Liên Chiểu, Khu công nghệ cao, các vị trí Khu thương mại tự do và khu du lịch Làng Vân.',
				'hh_p_connections'  => "Mặt tiền | Đường ven biển Nguyễn Tất Thành, biển vịnh Đà Nẵng\nPhía Bắc | Cảng Liên Chiểu, đèo Hải Vân, Làng Vân\nPhía Tây | Khu công nghệ cao, Khu thương mại tự do\nHướng Nam | Trung tâm Thanh Khê – Hải Châu theo trục Nguyễn Tất Thành",
				'hh_p_amenities_in' => "Hồ bơi và khu tắm nắng tầng 5\nSân vườn, lounge trên cao\nKhối đế thương mại dịch vụ, mini mart\nCơ sở giáo dục mầm non tầng 1\n3 tầng hầm để xe",
				'hh_p_amenities_out' => "Biển Nguyễn Tất Thành, công viên ven biển\nCảng Liên Chiểu, Khu công nghệ cao, Khu thương mại tự do\nKhu du lịch Làng Vân, đèo Hải Vân",
				'hh_p_progress'     => "15/01/2025 | Duyệt quy hoạch tổng mặt bằng (QĐ 151/QĐ-UBND)\n08/7/2026 | Phê duyệt giá đất cụ thể (QĐ 3023/QĐ-UBND)\n9/2026 | Sở Xây dựng xác nhận 379 căn đủ điều kiện bán\n26/10/2026 | Bắt đầu nhận đặt chỗ (booking)",
				'hh_p_image_links'  => implode( "\n", $imgs ),
			),
			'content' => '<p><strong>Grand Marina Da Nang</strong> (tên dự án: Khu căn hộ cao cấp Đà Nẵng) là tòa căn hộ 34 tầng nổi, 3 tầng hầm của <strong>Công ty Cổ phần BNC Land</strong> trên đường ven biển Nguyễn Tất Thành, khu dân cư Hòa Hiệp 2 (nay thuộc phường Hải Vân). Dự án có <strong>379 căn hộ</strong> được Sở Xây dựng Đà Nẵng xác nhận đủ điều kiện bán nhà ở hình thành trong tương lai.</p>
<h2>Vị trí ven vịnh Đà Nẵng</h2>
<p>Mặt trước nhìn ra biển vịnh Đà Nẵng, phía sau nhìn sông Cu Đê, hai đầu hồi hướng đèo Hải Vân – Nam Ô và thành phố. Khu vực phía Bắc Đà Nẵng đang tập trung hạ tầng lớn: cảng Liên Chiểu, Khu công nghệ cao, các vị trí Khu thương mại tự do.</p>
<h2>Thiết kế và loại căn</h2>
<ul>
<li>Căn 1 phòng ngủ khoảng 41 m².</li>
<li>Căn 2 phòng ngủ khoảng 65 – 80 m², nhiều căn view biển trực diện.</li>
<li>Căn 3 phòng ngủ khoảng 84 m².</li>
</ul>
<p>Tầng 1 có sảnh đón, mini mart, cơ sở giáo dục mầm non; tầng 5 có hồ bơi và khu tắm nắng.</p>
<h2>Pháp lý</h2>
<p>Quy hoạch tổng mặt bằng được duyệt theo Quyết định 151/QĐ-UBND ngày 15/01/2025; ngày 08/7/2026 UBND thành phố ban hành Quyết định 3023/QĐ-UBND phê duyệt giá đất cụ thể để tính nghĩa vụ tài chính bổ sung do điều chỉnh quy hoạch; Sở Xây dựng xác nhận 379 căn đủ điều kiện bán (Công văn 17683/SXD-QLN).</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, mặt bằng và chính sách bán hàng Grand Marina Da Nang.</p>',
			'sources' => array(
				'https://doanhnghieptiepthi.vn/379-can-ho-du-an-grand-marina-da-nang-du-dieu-kien-ban-161260926162631454.htm',
				'https://thuvienphapluat.vn/phap-luat-nha-dat/du-an-khu-can-ho-cao-cap-grand-marina-da-nang-se-co-nhung-gi-529.html',
			),
		);
		return $projects;
	},
	70
);
