<?php
/**
 * FPT Plaza 4 – bộ tài liệu chủ đầu tư (thư mục Drive anh Hiệp gửi 06/11/2026): bảng hỏi đáp 04/12/2025, danh mục vật liệu
 * bàn giao, tài liệu đào tạo 04/12/2025 (giá mở bán, lịch thanh toán, ngân hàng), phối cảnh, tiện ích, mặt bằng tầng, căn mẫu.
 * Không đăng: mã căn, tên / số điện thoại cán bộ ngân hàng, hợp đồng mẫu, biểu mẫu, tên đơn vị phân phối, ảnh có logo đại lý.
 * Ảnh layout căn đã cắt bỏ phần đầu ghi mã căn. Giá là giá mở bán giai đoạn 1 (12/2025) – ghi "tham khảo".
 * Ô anh đã tự sửa thì không đè (fix_meta chỉ thay giá trị web tự nhập trước đây); ô trống thì điền.
 */

defined( 'ABSPATH' ) || exit;

/** Các dòng ảnh (plugin:img/fpt-plaza-4/…). */
function hh_fpt_plaza_4_images() {
	$l = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/fpt-plaza-4/fpt-plaza-4-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );
	return array(
		$l( 'phoi-canh-tong-the-cong-vien-noi-khu', 'FPT Plaza 4 – hai tòa The Nimbus và The Sunrise bên công viên nội khu, FPT City Đà Nẵng, phối cảnh chủ đầu tư', 'đại diện', 'Toàn cảnh dự án' ),
		$l( 'phoi-canh-hai-toa-nimbus-sunrise', 'Hai tòa The Nimbus và The Sunrise – FPT Plaza 4, phối cảnh chủ đầu tư', 'thư viện', 'Hai tòa Nimbus – Sunrise' ),
		$l( 'phoi-canh-ve-dem-hoang-minh-thang', 'FPT Plaza 4 về đêm trên trục Hoàng Minh Thắng, phối cảnh chủ đầu tư', 'thư viện', 'Về đêm' ),
		$l( 'phoi-canh-truc-duong-hoang-minh-thang', 'FPT Plaza 4 nhìn từ đường Hoàng Minh Thắng, phối cảnh chủ đầu tư', 'thư viện', 'Mặt tiền Hoàng Minh Thắng' ),
		$l( 'phoi-canh-quang-truong-ban-ngay', 'FPT Plaza 4 nhìn từ quảng trường FPT City ban ngày, phối cảnh chủ đầu tư', 'thư viện', 'Quảng trường ban ngày' ),
		$l( 'phoi-canh-quang-truong-ve-dem', 'FPT Plaza 4 nhìn từ quảng trường FPT City về đêm, phối cảnh chủ đầu tư', 'thư viện', 'Quảng trường về đêm' ),
		$l( 'phoi-canh-binh-minh', 'FPT Plaza 4 lúc bình minh, phối cảnh chủ đầu tư', 'thư viện', 'Bình minh' ),
		$l( 'phoi-canh-tren-cao-hoang-hon', 'FPT Plaza 4 nhìn từ trên cao lúc hoàng hôn, phối cảnh chủ đầu tư', 'thư viện', 'Trên cao lúc hoàng hôn' ),
		$l( 'phoi-canh-fpt-city-ve-dem', 'FPT Plaza 4 giữa khu đô thị FPT City về đêm, phối cảnh chủ đầu tư', 'thư viện', 'FPT City về đêm' ),
		$l( 'phoi-canh-khoi-de-shophouse', 'Khối đế shophouse FPT Plaza 4, phối cảnh chủ đầu tư', 'thư viện', 'Khối đế shophouse' ),
		$l( 'sanh-don-mat-tien', 'Sảnh đón mặt tiền FPT Plaza 4, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh đón' ),
		$l( 'sanh-hop-thu-tang-1', 'Sảnh hộp thư tầng 1 FPT Plaza 4, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh tầng 1' ),
		$l( 'sanh-thang-may', 'Sảnh thang máy FPT Plaza 4, phối cảnh chủ đầu tư', 'thư viện', 'Sảnh thang máy' ),
		$l( 'vi-tri-ket-noi', 'Vị trí FPT Plaza 4 trong FPT City và thời gian di chuyển, sơ đồ chủ đầu tư', 'thư viện', 'Vị trí kết nối' ),
		$l( 'ho-boi-tang-20', 'Hồ bơi tầng 20 FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Hồ bơi tầng 20' ),
		$l( 'ho-boi-tang-20-cau-ngam-canh', 'Hồ bơi tầng 20 và cầu ngắm cảnh FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Cầu ngắm cảnh' ),
		$l( 'ho-boi-tang-20-thu-gian', 'Khu thư giãn bên hồ bơi tầng 20 FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Thư giãn hồ bơi tầng 20' ),
		$l( 'vuon-tang-17-hoang-hon', 'Vườn thượng uyển tầng 17 FPT Plaza 4 lúc hoàng hôn, phối cảnh chủ đầu tư', 'tiện ích', 'Vườn tầng 17' ),
		$l( 'vuon-tang-17', 'Vườn thượng uyển tầng 17 FPT Plaza 4 – khu thiền, đọc sách, phối cảnh chủ đầu tư', 'tiện ích', 'Vườn thiền tầng 17' ),
		$l( 'ho-boi-cong-vien-tang-1', 'Hồ bơi công viên nội khu tầng 1 FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Hồ bơi tầng 1' ),
		$l( 'cong-vien-noi-khu', 'Công viên nội khu 5.400 m² FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Công viên nội khu' ),
		$l( 'khu-foodcourt-cong-vien', 'Khu foodcourt trong công viên nội khu FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Foodcourt' ),
		$l( 'loi-dao-cong-vien', 'Lối dạo bộ trong công viên FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Lối dạo bộ' ),
		$l( 'cong-chao-du-an', 'Cổng chào FPT Plaza 4, phối cảnh chủ đầu tư', 'tiện ích', 'Cổng chào' ),
		$l( 'noi-that-can-mau-2pn-phong-khach', 'Nội thất căn mẫu 2 phòng ngủ FPT Plaza 4 – phòng khách, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 2PN – phòng khách' ),
		$l( 'noi-that-can-mau-2pn-phong-an', 'Nội thất căn mẫu 2 phòng ngủ FPT Plaza 4 – phòng ăn, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 2PN – phòng ăn' ),
		$l( 'noi-that-can-mau-2pn-bep', 'Nội thất căn mẫu 2 phòng ngủ FPT Plaza 4 – bếp, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 2PN – bếp' ),
		$l( 'noi-that-can-mau-2pn-1-phong-an', 'Nội thất căn mẫu 2PN+1 FPT Plaza 4 – phòng ăn, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 2PN+1 – phòng ăn' ),
		$l( 'noi-that-can-mau-2pn-1-phong-khach', 'Nội thất căn mẫu 2PN+1 FPT Plaza 4 – phòng khách, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 2PN+1 – phòng khách' ),
		$l( 'noi-that-can-mau-3pn-phong-khach', 'Nội thất căn mẫu 3 phòng ngủ FPT Plaza 4 – phòng khách, phối cảnh chủ đầu tư', 'thư viện', 'Căn mẫu 3PN' ),
		$l( 'mat-bang-tang-1-tien-ich', 'Mặt bằng tầng 1 FPT Plaza 4: sảnh, công viên nội khu, hồ bơi, tiện ích', 'tổng thể', 'Tổng mặt bằng tầng 1' ),
		$l( 'mat-bang-tang-2', 'Mặt bằng tầng 2 FPT Plaza 4', 'mặt bằng', 'Tầng 2' ),
		$l( 'mat-bang-tang-3-16', 'Mặt bằng tầng điển hình 3 – 16 FPT Plaza 4', 'mặt bằng', 'Tầng 3 – 16' ),
		$l( 'mat-bang-tang-17', 'Mặt bằng tầng 17 FPT Plaza 4 (vườn thượng uyển)', 'mặt bằng', 'Tầng 17' ),
		$l( 'mat-bang-tang-18', 'Mặt bằng tầng 18 FPT Plaza 4', 'mặt bằng', 'Tầng 18' ),
		$l( 'mat-bang-tang-19', 'Mặt bằng tầng 19 FPT Plaza 4 (căn duplex)', 'mặt bằng', 'Tầng 19' ),
		$l( 'mat-bang-tang-20', 'Mặt bằng tầng 20 FPT Plaza 4 (hồ bơi tầng thượng, duplex)', 'mặt bằng', 'Tầng 20' ),
		$l( 'layout-2pn-69m2', 'Layout căn 2 phòng ngủ FPT Plaza 4 – diện tích 69,69 m²', 'layout', '2PN 69,7 m²' ),
		$l( 'layout-2pn-1-78m2', 'Layout căn 2 phòng ngủ + 1 FPT Plaza 4 – diện tích 78,16 m²', 'layout', '2PN+1 78,2 m²' ),
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'fpt-plaza-4' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			// Giá trị cũ đang có trên web (data-du-an.php + data-du-an-chi-tiet.php) → được phép thay; ô anh tự sửa thì giữ.
			$enrich = function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['fpt-plaza-4']['meta'] ?? array() ) : array();
			$old    = static fn( $k ) => (string) ( $p['meta'][ $k ] ?? ( $enrich[ $k ] ?? '' ) );
			$fix    = static function ( $k, $new, $olds ) use ( &$p ) {
				$olds = array_values( array_unique( array_filter( array_map( 'strval', (array) $olds ), static fn( $v ) => '' !== $v && $v !== $new ) ) );
				$p['meta'][ $k ] = $new;
				if ( $olds ) {
					$p['fix_meta'][ $k ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), $olds ) ) );
				}
			};
			$was = array();
			foreach ( array( 'hh_p_units', 'hh_p_handover', 'hh_p_highlights', 'hh_p_amenities_in', 'hh_p_progress', 'hh_p_location_desc' ) as $k ) {
				$was[ $k ] = $old( $k );
			}

			// Ảnh chủ đầu tư (web chưa có ảnh riêng cho FPT Plaza 4).
			$p['meta']['hh_p_image_links'] = implode( "\n", hh_fpt_plaza_4_images() );

			// Thông tin theo bảng hỏi đáp chủ đầu tư 04/12/2025.
			$fix( 'hh_p_units', '1.395 căn hộ (1PN – 3PN+1, căn thông tầng, duplex)', array( $was['hh_p_units'] ) );
			$fix( 'hh_p_handover', 'Dự kiến quý IV/2027', array( $was['hh_p_handover'] ) );
			$fix(
				'hh_p_highlights',
				"4 mặt tiền đường: Hoàng Minh Thắng 33 m, Trần Quốc Vượng 17,5 m, D15, N27\nCông viên nội khu 5.400 m² với hồ bơi, foodcourt, vườn nhiệt đới, khu vui chơi trẻ em\nHồ bơi tầng thượng (tầng 20), vườn thượng uyển tầng 17\nBàn giao hoàn thiện nội thất liền tường; sở hữu lâu dài\nTổng vốn đầu tư khoảng 2.790 tỷ đồng",
				array( $was['hh_p_highlights'] )
			);
			$fix(
				'hh_p_amenities_in',
				"Sảnh đón 2 tòa\nCông viên nội khu 5.400 m²: hồ bơi 335 m², foodcourt, vườn nghỉ mát, hồ tiểu cảnh, vườn nhiệt đới\nKhu vui chơi trẻ em, khu thể thao ngoài trời, hồ bơi trẻ em\nHồ bơi tầng thượng (tầng 20) 128 m², cầu ngắm cảnh\nVườn thượng uyển tầng 17: khu thiền, khu đọc sách\nTrường mầm non, nhà hàng, phòng sinh hoạt cộng đồng\nShophouse khối đế\n808 chỗ đỗ ô tô ở 3 tầng hầm, chờ trạm sạc xe điện",
				array( $was['hh_p_amenities_in'] )
			);
			$fix(
				'hh_p_progress',
				"19/3/2025 | Khởi công (tổng thầu Central)\nTháng 7/2025 | Gần hoàn thiện phần móng, đóng nắp hầm\n12/2025 | Mở bán giai đoạn 1 – dự án đủ điều kiện bán hàng, ký HĐMB nhà ở hình thành trong tương lai (theo chủ đầu tư)\nTháng 12/2026 | Cất nóc (kế hoạch)\nQuý IV/2027 | Bàn giao căn hộ (dự kiến)",
				array( $was['hh_p_progress'] )
			);
			$fix(
				'hh_p_location_desc',
				'FPT Plaza 4 nằm tại lô B5-3 trung tâm Khu đô thị công nghệ FPT City, Ngũ Hành Sơn, với 4 mặt tiền đường: Hoàng Minh Thắng (33 m – trục nối thẳng ra sân bay), Trần Quốc Vượng (17,5 m), D15 (16,5 m) và N27 (14,5 m). Khu đất khoảng 18.905 m², gồm 2 tòa The Nimbus và The Sunrise cao 20 tầng với 1.395 căn hộ.',
				array( $was['hh_p_location_desc'] )
			);

			// Ô còn trống thì điền.
			$p['meta'] += array(
				'hh_p_builder'      => 'Công ty CP Xây dựng Central',
				'hh_p_designer'     => 'Công ty CP Tư vấn Archivina (kiến trúc)',
				'hh_p_scale'        => 'Khu đất 18.905 m², mật độ xây dựng 43%, tổng sàn xây dựng 190.577 m²',
				'hh_p_blocks'       => '2 tòa: The Nimbus (N) và The Sunrise (S) – thông nhau từ tầng 1 đến 20 (trừ tầng 18, 19)',
				'hh_p_unit_area'    => '1PN – 3PN+1 khoảng 45 – 128 m²; căn thông tầng 117 – 246 m²; duplex 147 – 269 m²',
				'hh_p_price_from'   => '2100',
				'hh_p_ownership'    => 'Sở hữu lâu dài',
				'hh_p_legal'        => 'Đủ điều kiện bán hàng (theo chủ đầu tư); ký hợp đồng mua bán nhà ở hình thành trong tương lai. Người nước ngoài không thuộc đối tượng mua.',
				'hh_p_handover_std' => 'Căn hộ thường bàn giao hoàn thiện nội thất liền tường: sàn gỗ công nghiệp / SPC vân gỗ ở phòng khách, bếp, phòng ngủ; trần thạch cao, sơn Jotun/Dulux/Nippon; tủ bếp trên – dưới, mặt đá, bếp từ và hút mùi Hafele/Panasonic/Teka; thiết bị vệ sinh Hafele/American Standard/Jomoo, vách kính tắm; bình nóng lạnh Ariston/Ferroli/Rossi; điều hòa cục bộ multi; khóa điện tử cửa chính Philips/Hafele/Yale (hoặc tương đương). Căn thông tầng và duplex bàn giao thô (hoàn thiện trong 6 tháng).',
				'hh_p_connections'  => "1 phút | Công viên trung tâm, quảng trường, tiện ích FPT City, FPT Schools\n3 phút | Bãi tắm Tân Trà, Đại học FPT, trường quốc tế SIS, APU, Legend Danang Golf Resort\n5 phút | Danh thắng Ngũ Hành Sơn, Montgomerie Links, chợ Non Nước, bệnh viện\n10 phút | Sân bay quốc tế Đà Nẵng, Da Nang Downtown, Lotte Mart",
				'hh_p_unit_types'   => "1PN | 46,3 – 49,8 m² | 1 | Từ 2,1x tỷ\n1PN+1 | 45,5 – 50,1 m² | 1 | Từ 2,1x tỷ\n2PN | 58,8 – 74,1 m² | 2 | Từ 2,9 tỷ\n2PN+1 | 72,9 – 80,3 m² | 2 | Từ 2,9 tỷ\n3PN | 87,9 – 90,3 m² | 3 | Từ 4,9 tỷ\n3PN+1 | 96 – 127,8 m² | 3 | Từ 4,9 tỷ\nCăn thông tầng | 116,7 – 246,4 m² | 2 – 4 | Liên hệ\nDuplex | 146,6 – 268,7 m² | 3 – 4 | Liên hệ",
				'hh_p_payment'      => "Đặt cọc | Trong 7 ngày từ ngày giữ chỗ | 100 triệu (1PN – 2PN+1) · 200 triệu (3PN) · 250 triệu (3PN+1)\nĐợt 1 | Ký hợp đồng mua bán | 30% (gồm tiền cọc)\nĐợt 2 | Hoàn thành tầng 5 | 10%\nĐợt 3 | Hoàn thành tầng 10 | 10%\nĐợt 4 | Hoàn thành tầng 15 | 10%\nĐợt 5 | Cất nóc | 10%\nĐợt 6 | Thông báo bàn giao (dự kiến quý IV/2027) | 25% + 2% phí bảo trì\nĐợt 7 | Khi có thông báo nhận giấy chứng nhận | 5%",
				'hh_p_loan'         => 'Ngân hàng hỗ trợ: TPBank, VietinBank, MB, Vietcombank, Public Bank – cho vay khoảng 70 – 80% giá trị căn hộ, thời hạn đến 25 – 35 năm, có gói lãi suất ưu đãi 12 – 36 tháng đầu (theo thông báo ngân hàng 11–12/2025; liên hệ để nhận lãi suất hiện hành).',
				'hh_p_offer_note'   => 'Giá mở bán giai đoạn 1 (12/2025) đã gồm hoàn thiện nội thất liền tường; giá từng căn thay đổi theo tầng, hướng và đợt bán – liên hệ để nhận bảng giá mới nhất.',
				'hh_p_faq'          => "Phí quản lý FPT Plaza 4 bao nhiêu? | Dự kiến 13.000 đồng/m²/tháng, chưa gồm VAT (theo chủ đầu tư).\nTiện ích có mất phí không? | Hầu hết miễn phí (công viên, sinh hoạt cộng đồng, lễ tân); hồ bơi tầng 1 miễn phí 2 năm đầu; dịch vụ ở khối đế shophouse trả phí.\nCăn hộ bàn giao thế nào? | Căn thường bàn giao hoàn thiện nội thất liền tường theo danh mục trong hợp đồng; căn thông tầng, duplex bàn giao thô.\nCó chỗ đỗ ô tô không? | 808 chỗ ô tô ở 3 tầng hầm, có vị trí chờ lắp trạm sạc xe điện.\nNgười nước ngoài có mua được không? | Không – dự án không bán cho người nước ngoài.\nCó được nuôi thú cưng không? | Theo quy định của chủ đầu tư, cư dân không được nuôi thú cưng.",
			);
		}
		unset( $p );
		return $projects;
	},
	32
);
