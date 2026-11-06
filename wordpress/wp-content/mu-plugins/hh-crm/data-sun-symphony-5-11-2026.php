<?php
/**
 * Symphony 5 – Sun Symphony Residence: bộ tài liệu chủ đầu tư (thư mục Drive "Sun Symphony 5" anh Hiệp gửi 06/11/2026).
 * - 19 phối cảnh / tiện ích sạch, tổng mặt bằng phân khu, mặt bằng 7 nhóm tầng, layout 5 căn mẫu;
 * - pháp lý (đấu giá, chấp thuận nhà đầu tư, giao đất 50 năm, quy hoạch 1/500) theo slide đào tạo 05/2026;
 * - CSBH 02/S5 (áp dụng từ 20/07/2026): Sun Early Key, không vay 5%, vay 70% hỗ trợ lãi suất, lịch thanh toán;
 * - tiêu chuẩn bàn giao thô + đơn giá tuỳ chọn hoàn thiện.
 * Không đăng: bảng giá (phiếu tính giá chỉ là mẫu tính), mốc chiết khấu thanh toán sớm 95% / 70% hạn 25/07/2026 (đã hết),
 * tên đơn vị phân phối, mẫu biểu, thẻ sales. Ô anh đã tự sửa thì không đè (fix_meta chỉ thay giá trị web nhập).
 */

defined( 'ABSPATH' ) || exit;

/** Ảnh Symphony 5 (plugin:img/sun-symphony-5/…). */
function hh_sym5_images() {
	$l = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/sun-symphony-5/sun-symphony-5-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );
	return array(
		$l( 'pc-11-hoang-hon', 'Symphony 5 – Sun Symphony Residence bên sông Hàn lúc hoàng hôn, phối cảnh chủ đầu tư', 'đại diện', 'Toàn cảnh lúc hoàng hôn' ),
		$l( 'pc-01-tong-the-1', 'Toàn cảnh tổ hợp Sun Symphony Residence và tháp Symphony 5 bên sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh sông Hàn' ),
		$l( 'pc-02-tong-the-2', 'Sun Symphony Residence nhìn từ sông Hàn về bán đảo Sơn Trà, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh hướng Sơn Trà' ),
		$l( 'pc-08-dem-phao-hoa', 'Symphony 5 đêm pháo hoa DIFF bên sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Đêm pháo hoa' ),
		$l( 'pc-09-ban-ngay', 'Tổ hợp Sun Symphony Residence ban ngày nhìn về trung tâm Đà Nẵng, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh ban ngày' ),
		$l( 'pc-10-ban-ngay-2', 'Symphony 5 và bờ Đông sông Hàn lúc bình minh, phối cảnh chủ đầu tư', 'thư viện', 'Bờ Đông sông Hàn' ),
		$l( 'pc-03-view-cau-thuan-phuoc', 'Ban công Symphony 5 nhìn cầu Thuận Phước về đêm, phối cảnh chủ đầu tư', 'thư viện', 'View cầu Thuận Phước' ),
		$l( 'pc-04-view-cang-tho-quang-son-tra', 'Phòng ngủ Symphony 5 nhìn cảng Thọ Quang, bán đảo Sơn Trà, phối cảnh chủ đầu tư', 'thư viện', 'View bán đảo Sơn Trà' ),
		$l( 'pc-06-ban-cong-tang-10-song-han', 'Ban công tầng 10 Symphony 5 nhìn sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Ban công tầng 10' ),
		$l( 'pc-07-tang-19-view-song-cau', 'Căn hộ tầng 19 Symphony 5 nhìn sông Hàn và cầu Thuận Phước, phối cảnh chủ đầu tư', 'thư viện', 'Căn hộ tầng 19' ),
		$l( 'pc-12-tang-3-san-vuon', 'Ban công sân vườn tầng 3 Symphony 5, phối cảnh chủ đầu tư', 'thư viện', 'Sân vườn tầng 3' ),
		$l( 'pc-13-be-boi', 'Bể bơi Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Bể bơi' ),
		$l( 'ti-be-boi-02', 'Bể bơi giữa khối đế Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Bể bơi khối đế' ),
		$l( 'pc-14-gym', 'Phòng gym Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Gym' ),
		$l( 'ti-yoga-tang-27', 'Sân yoga tầng 27 Symphony 5 nhìn biển, phối cảnh chủ đầu tư', 'tiện ích', 'Yoga tầng 27 view biển' ),
		$l( 'ti-spa-sauna', 'Spa & sauna Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Spa, sauna' ),
		$l( 'ti-kidclub', 'Kids club Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Kids club' ),
		$l( 'ti-shophouse-mat-ngoai', 'Phố shophouse khối đế Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Phố thương mại khối đế' ),
		$l( 'ti-shophouse', 'Shophouse khối đế Symphony 5, phối cảnh chủ đầu tư', 'tiện ích', 'Shophouse' ),
		$l( 'tmb', 'Tổng mặt bằng phân khu Symphony 5 – Sun Symphony Residence: tháp căn hộ, công viên Central Park, công viên ven sông, bến du thuyền', 'tổng thể', 'Tổng mặt bằng phân khu' ),
		$l( 'mb-tang-3', 'Mặt bằng tầng 3 tòa Symphony 5', 'mặt bằng', 'Tầng 3' ),
		$l( 'mb-tang-3a-18', 'Mặt bằng tầng 3A – 18 tòa Symphony 5', 'mặt bằng', 'Tầng 3A – 18' ),
		$l( 'mb-tang-12a', 'Mặt bằng tầng 12A tòa Symphony 5', 'mặt bằng', 'Tầng 12A' ),
		$l( 'mb-tang-19-21', 'Mặt bằng tầng 19 – 21 tòa Symphony 5', 'mặt bằng', 'Tầng 19 – 21' ),
		$l( 'mb-tang-22-26', 'Mặt bằng tầng 22 – 26 tòa Symphony 5', 'mặt bằng', 'Tầng 22 – 26' ),
		$l( 'mb-tang-27-30', 'Mặt bằng tầng 27 – 30 tòa Symphony 5', 'mặt bằng', 'Tầng 27 – 30' ),
		$l( 'mb-tang-31', 'Mặt bằng tầng 31 tòa Symphony 5', 'mặt bằng', 'Tầng 31' ),
		$l( 'lo-studio', 'Layout căn Studio Symphony 5 – diện tích 30,1 m²', 'layout', 'Studio 30,1 m²' ),
		$l( 'lo-1br-plus-a', 'Layout căn 1PN+ Symphony 5 – diện tích 44,1 m²', 'layout', '1PN+ 44,1 m²' ),
		$l( 'lo-1br-plus', 'Layout căn 1PN+ Symphony 5 – diện tích 50,3 m²', 'layout', '1PN+ 50,3 m²' ),
		$l( 'lo-1br-plus-b', 'Layout căn 1PN+ Symphony 5 – diện tích 50,6 m²', 'layout', '1PN+ 50,6 m²' ),
		$l( 'lo-2br-plus-a', 'Layout căn 2PN Symphony 5 – diện tích 62,7 m²', 'layout', '2PN 62,7 m²' ),
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as &$p ) {
			if ( 'symphony-5-sun-symphony-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$m   = (array) ( $p['meta'] ?? array() );
			$fix = static function ( $key, $new, $olds ) use ( &$p ) {
				$olds = array_values( array_filter( array_map( 'strval', (array) $olds ), static fn( $v ) => '' !== $v && $v !== $new ) );
				$p['meta'][ $key ] = $new;
				if ( $olds ) {
					$p['fix_meta'][ $key ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), $olds ) ) );
				}
			};
			$p['parent'] = $p['parent'] ?? 'sun-symphony-residence'; // Thuộc tổ hợp Sun Symphony Residence – hai trang link qua lại.

			$p['meta']['hh_p_image_links'] = implode( "\n", hh_sym5_images() );

			$fix( 'hh_p_ownership', 'Sở hữu 50 năm (đất thương mại dịch vụ – quyết định giao đất 50 năm)', array( $m['hh_p_ownership'] ?? '' ) );
			$fix( 'hh_p_legal', 'Đấu giá quyền sử dụng đất 14/12/2025; chấp thuận nhà đầu tư 12/03/2026; quyết định giao đất thời hạn 50 năm; phê duyệt quy hoạch 1/500 ngày 23/4/2026 (theo tài liệu chủ đầu tư)', array( $m['hh_p_legal'] ?? '' ) );
			$fix( 'hh_p_unit_area', 'Thông thủy khoảng 30 – 70 m² (Studio, 1PN+, 2PN) và 12 penthouse', array( $m['hh_p_unit_area'] ?? '', 'Studio khoảng 30–33 m²' ) );
			$fix( 'hh_p_handover', 'Nhận căn sử dụng dự kiến 30/06/2028 (Sun Early Key, thanh toán tối thiểu 70%); bàn giao chính thức theo tiến độ không vay dự kiến 30/06/2030', array( $m['hh_p_handover'] ?? '', 'Dự kiến 8/2028' ) );
			$fix(
				'hh_p_highlights',
				"Mảnh ghép cuối của tổ hợp Sun Symphony Residence, bờ Đông sông Hàn – ngay điểm ngắm pháo hoa DIFF\n1.228 căn, phần lớn studio và 1PN+ phù hợp ở và khai thác cho thuê\nCông viên thể thao 10.000 m², Central Park 5.000 m², công viên ven sông 4.000 m², bến du thuyền\nSun Early Key: thanh toán 70% nhận căn sử dụng (dự kiến 30/06/2028)",
				array( $m['hh_p_highlights'] ?? '' )
			);
			$fix(
				'hh_p_progress',
				"14/12/2025 | Đấu giá quyền sử dụng đất\n12/03/2026 | Chấp thuận nhà đầu tư\n23/4/2026 | Phê duyệt quy hoạch 1/500\n27/5/2026 | Ban hành CSBH 01 – ký thẳng hợp đồng mua bán\n20/7/2026 | Áp dụng CSBH 02 – ký hợp đồng thực hiện nguyện vọng\n30/6/2028 | Dự kiến nhận căn sử dụng (Sun Early Key)",
				array( $m['hh_p_progress'] ?? '' )
			);
			$p['meta'] += array(
				'hh_p_unit_types'    => "Studio | 30 – 33 m² (725 căn) | 0 | Liên hệ\nCăn 1PN+ | 44 – 53 m² (331 căn) | 1 | Liên hệ\nCăn 2PN | 63 – 70 m² (160 căn) | 2 | Liên hệ\nPenthouse | 12 căn | | Liên hệ",
				'hh_p_handover_std'  => 'Bàn giao thô: mặt ngoài, cửa nhôm kính, lô gia (sàn lát, lan can kính cường lực) hoàn thiện; bên trong để thô (trần, sàn, tường); cửa chính gỗ chống cháy; đầu chờ điện, nước, internet; điều hòa khách tự lắp. Tuỳ chọn bàn giao hoàn thiện liền tường (đăng ký khi ký HĐMB): khoảng 10,1 triệu/m² căn studio, 9,5 triệu/m² căn 1PN/1PN+, 11 triệu/m² căn 2PN/3PN (đã gồm VAT, tạm tính theo diện tích thông thủy).',
				'hh_p_amenities_in'  => "Bể bơi\nGym\nSân yoga tầng 27 nhìn biển\nSpa, sauna\nKids club, club house\nPhố thương mại khối đế\nCông viên thể thao 10.000 m²\nCentral Park 5.000 m², công viên ven sông 4.000 m²\nBến du thuyền, đường dạo bộ sông Hàn",
				'hh_p_connections'   => "1,5 km | Cầu Rồng\n2 km | Trung tâm hành chính thành phố\n2,5 km | Biển Mỹ Khê\n5 km | Đà Nẵng Downtown\n6 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_offer_title'   => 'Sun Early Key: thanh toán 70% nhận căn sử dụng (dự kiến 30/06/2028)',
				'hh_p_offer_note'    => 'Theo CSBH 02/S5 của chủ đầu tư, áp dụng từ 20/07/2026 đến khi có chính sách mới. Chủ đầu tư có quyền thay đổi chính sách – liên hệ để nhận phiếu tính giá căn cụ thể.',
				'hh_p_offer_start'   => '20/07/2026',
				'hh_p_offer_stats'   => "5% | Chiết khấu không vay, giãn tiến độ đến 50 tháng\n70% | Vay tối đa, hỗ trợ lãi suất đến 30 tháng\n30/06/2028 | Dự kiến nhận căn sử dụng (Sun Early Key)\n8%/năm | Lãi thanh toán sớm bằng vốn tự có",
				'hh_p_policy'        => "Sun Early Key: thanh toán tối thiểu 70% (gồm VAT) là được nhận căn để sử dụng, khai thác – dự kiến 30/06/2028\nKhông vay: chiết khấu 5% trên giá chưa VAT & KPBT, giãn tiến độ đến 50 tháng (giai đoạn 70% – 30%)\nVay ngân hàng tối đa 70% giá trị căn hộ, chủ đầu tư hỗ trợ lãi suất tối đa 30 tháng (không muộn hơn 31/03/2029), miễn phí trả nợ trước hạn trong thời gian hỗ trợ\nThanh toán sớm hơn tiến độ bằng vốn tự có: hưởng lãi 8%/năm trên số tiền và số ngày trả trước\nMiễn phí dịch vụ quản lý căn hộ 1 năm từ ngày bàn giao chính thức\nKhoản 5% ký quỹ cấp sổ: chủ đầu tư trả lãi 8%/năm đến khi nhận giấy chứng nhận\nTích điểm hội viên Sun Signature 0,7% – 2% giá trị hợp đồng theo hạng",
				'hh_p_payment'       => "Ký hợp đồng thực hiện nguyện vọng | Khi ký | 100 triệu (mọi loại căn)\nĐợt 2 | Ngày 10 kể từ ký HĐTHNV | 15% (gồm đợt 1)\nKý HĐMB | Dự kiến ngày 7 sau hạn đợt 2 | –\nĐợt 3 → 7 | Ngày 130, 250, 370, 490, 610 | Mỗi đợt 10%\nĐợt 8 | Ngày 730 | 5%\nNhận căn sử dụng (Sun Early Key) | Dự kiến 30/06/2028 | Đã thanh toán tối thiểu 70%\nĐợt 9 → 13 | Ngày 850, 970, 1090, 1210, 1330 | Mỗi đợt 5%\nĐợt 14 – bàn giao chính thức | Dự kiến 30/06/2030 | KPBT + VAT phần 5% còn lại\nĐợt cuối – nhận sổ | Khi cấp giấy chứng nhận | 5% (nộp ký quỹ khi bàn giao, chủ đầu tư trả lãi 8%/năm)",
				'hh_p_loan'          => 'Vay tối đa 70% giá trị căn hộ (gồm VAT) tại ngân hàng do chủ đầu tư chỉ định; hỗ trợ lãi suất tối đa 30 tháng kể từ lần giải ngân đầu, không muộn hơn 31/03/2029; ân hạn nợ gốc theo thời gian hỗ trợ; sau đó lãi suất cơ sở + biên độ của ngân hàng. Lịch vay: 15% vốn tự có → ngân hàng giải ngân đến 70% trong 15 ngày sau ký HĐMB → 10% ngày 130 → 5% khi bàn giao.',
			);
			$p['fix_content'] = (array) ( $p['fix_content'] ?? array() );
			if ( ! empty( $p['content'] ) ) {
				$p['fix_content'][] = $p['content'];
			}
			$p['content'] = '<h2>Giới thiệu</h2><p><strong>Symphony 5</strong> là tháp căn hộ 31 tầng, giai đoạn cuối của tổ hợp <a href="/du-an/sun-symphony-residence/">Sun Symphony Residence</a> ở bờ Đông sông Hàn, do Công ty TNHH Mặt Trời Sông Hàn – thành viên Sun Group – làm chủ đầu tư.</p>'
				. '<h2>Vị trí</h2><p>Đường Lê Văn Duyệt, phường Sơn Trà (Nại Hiên Đông cũ), ngay bờ sông Hàn – điểm ngắm pháo hoa quốc tế DIFF. Cách cầu Rồng khoảng 1,5 km, trung tâm hành chính 2 km, biển Mỹ Khê 2,5 km, sân bay 6 km.</p>'
				. '<h2>Sản phẩm</h2><ul><li>1 tháp 31 tầng nổi, 1 tầng hầm, trên khoảng 11.371 m² đất thương mại dịch vụ.</li><li>1.228 căn: 725 studio (30 – 33 m²), 331 căn 1PN+ (44 – 53 m²), 160 căn 2PN (63 – 70 m²), 12 penthouse.</li><li>Bàn giao thô, có tuỳ chọn hoàn thiện liền tường.</li></ul>'
				. '<h2>Pháp lý &amp; tiến độ</h2><p>Đấu giá quyền sử dụng đất 14/12/2025, chấp thuận nhà đầu tư 12/03/2026, giao đất thời hạn 50 năm, quy hoạch 1/500 phê duyệt 23/4/2026. Nhận căn sử dụng dự kiến 30/06/2028 theo chính sách Sun Early Key.</p>';
		}
		unset( $p );
		return $projects;
	},
	31
);
