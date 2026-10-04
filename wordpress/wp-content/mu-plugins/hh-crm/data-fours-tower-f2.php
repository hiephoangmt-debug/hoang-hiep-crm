<?php
/**
 * FourS Tower – cập nhật 10/2026 theo phiếu tính giá Tòa F2 của chủ đầu tư (CSBH 4.2, áp dụng từ 26/9/2026):
 * chiết khấu Early Bird 3%, không vay 3%, thanh toán sớm 50% / 70% / 95% (2,5% / 5% / 12%, hạn 25/10/2026),
 * cọc 100 triệu (Studio – 2PN) / 150 triệu (3PN), Sun Early Key nhận nhà khi thanh toán 70% (dự kiến 31/5/2028).
 * Thêm trang riêng Tòa F2 – Tháp Mai (dạng landing page) và đưa ưu đãi, phương án thanh toán lên trang FourS Tower.
 * Ví dụ số tiền tính theo căn mẫu giá niêm yết 3 tỷ (gồm VAT & KPBT) trong phiếu của CĐT – không phải giá một căn cụ thể.
 * Chỉ điền ô trống / thay ô còn đúng bản cũ do web nhập – ô anh đã tự sửa trong quản trị giữ nguyên.
 */

defined( 'ABSPATH' ) || exit;

/** Các ô chung cho FourS Tower và Tòa F2 (chính sách F2 đang mở bán). */
function hh_fours_f2_policy_meta() {
	return array(
		'hh_p_offer_title'    => 'Chiết khấu lên đến 19% – chỉ cần 25% vốn đến khi nhận nhà',
		'hh_p_offer_note'     => 'CSBH 4.2 Tòa F2 – hạn chiết khấu thanh toán sớm 25/10/2026.',
		'hh_p_offer_stats'    => "19% | Chiết khấu lên đến\n25% | Vốn tự có đến khi nhận nhà (vay 70%)\n15% | Thanh toán đến khi ký HĐMB\n70% | Đã nhận nhà – Sun Early Key",
		'hh_p_capital_title'  => 'Chỉ từ khoảng 405 triệu vốn tự có – ngân hàng cho vay 70%',
		'hh_p_capital_table'  => "Studio | Giá từ ~1,7 tỷ | ~405 triệu | Ngân hàng cho vay ~1,13 tỷ\n1PN+ | Giá từ ~2,6 tỷ | ~619 triệu | Ngân hàng cho vay ~1,73 tỷ\n2PN | Giá từ ~3,6 tỷ | ~857 triệu | Ngân hàng cho vay ~2,4 tỷ",
		'hh_p_capital_note'   => 'Giá từ: tham khảo theo nguồn phân phối FourS Tower. Vốn tự có = 25% giá sau Early Bird 3% (gồm VAT) – phương án vay 70% theo CSBH 4.2 Tòa F2, thanh toán trước khi nhận nhà; chưa gồm kinh phí bảo trì 2% và 5% khi nhận nhà. Căn 1PN, 3PN, căn góc, sân vườn: nhận giá qua Zalo.',
		'hh_p_offer_start'    => '26/09/2026',
		'hh_p_offer_deadline' => '25/10/2026',
		'hh_p_discount_table' => "Thanh toán sớm 95% | Trước 25/10/2026 | 17,2% | Early Bird 3% + không vay 3% + thanh toán sớm 12%\nThanh toán sớm 70% – nhận nhà rồi trả 25% còn lại | Trước 25/10/2026 | 10,6% | Early Bird 3% + không vay 3% + thanh toán sớm 5%\nThanh toán sớm 50% | Trước 25/10/2026 | 8,3% | Early Bird 3% + không vay 3% + thanh toán sớm 2,5%\nTiến độ chuẩn, không vay ngân hàng | Early Bird có thời hạn | 5,9% | Early Bird 3% + không vay 3%\nVay ngân hàng – giải ngân 70% | Early Bird có thời hạn | 3% | Early Bird 3%",
		'hh_p_policy'         => "Early Bird 3% (có thời hạn) áp dụng khi ký thỏa thuận đặt cọc\nKhông vay ngân hàng: chiết khấu thêm 3%\nThanh toán sớm 95% / 70% / 50% trước 25/10/2026: chiết khấu thêm 12% / 5% / 2,5%\nĐặt cọc 100 triệu (Studio, 1PN, 1PN+, 2PN) – 150 triệu (3PN)\nSun Early Key: nhận bàn giao sử dụng khi đã thanh toán 70% (dự kiến 31/5/2028), 25% còn lại trả dần sau khi nhận nhà\nVay ngân hàng: ngân hàng giải ngân 70% ngay sau ký hợp đồng mua bán\nChính sách theo CSBH 4.2 Tòa F2 từ 26/9/2026 – thay đổi theo đợt, liên hệ để nhận bản mới nhất",
		'hh_p_payment'        => "Đặt cọc | Ký thỏa thuận đặt cọc | 100 – 150 triệu\nĐợt 2 | Khoảng 2 tuần sau đặt cọc | 15%\nKý hợp đồng mua bán | Khoảng 3 tuần sau đặt cọc | –\nĐợt 3 – 7 | Mỗi 3 tháng (từ quý 1/2027) | 10% mỗi đợt\nĐợt 8 | Trước bàn giao | 5%\nNhận bàn giao sử dụng (Sun Early Key) | Dự kiến 31/5/2028 | Đã thanh toán 70%\nĐợt 9 – 13 | Mỗi 4 tháng sau khi nhận nhà | 5% mỗi đợt\nĐợt cuối | Khi nhận giấy chứng nhận | 5% + kinh phí bảo trì",
		'hh_p_loan'           => 'Phương án vay: ngân hàng giải ngân 70% giá trị căn ngay sau khi ký hợp đồng mua bán; khách thanh toán 15% (gồm tiền cọc) và 10% theo tiến độ. Phương án vay không áp dụng chiết khấu "không vay" 3%, vẫn được Early Bird 3%. Lãi suất, ân hạn theo gói ngân hàng liên kết từng thời điểm – liên hệ để nhận bảng tính khoản vay theo căn cụ thể.',
	);
}

/** Bảng chiết khấu bản trước (đã gửi) – thay nếu anh chưa sửa. */
function hh_fours_f2_old_meta() {
	return array(
		'hh_p_offer_title' => array( 'Tiết kiệm đến khoảng 17% giá niêm yết khi thanh toán sớm 95% – Tòa F2', 'Chiết khấu lên đến 18% – chỉ cần 25% vốn đến khi nhận nhà' ),
		'hh_p_offer_stats' => "18% | Chiết khấu cộng dồn tối đa\n25% | Vốn tự có đến khi nhận nhà (vay 70%)\n15% | Thanh toán đến khi ký HĐMB\n70% | Đã nhận nhà – Sun Early Key",
		'hh_p_offer_note'  => 'CSBH 4.2 Tòa F2 áp dụng từ 26/9/2026 – hạn thanh toán sớm 25/10/2026. Ví dụ căn niêm yết 3 tỷ còn khoảng 2,48 tỷ (theo phiếu tính giá CĐT).',
		'hh_p_discount_table' => "Thanh toán sớm 95% (cộng dồn Early Bird 3% + không vay 3%) | Trước 25/10/2026 | 12%\nThanh toán sớm 70% – nhận nhà rồi trả 25% còn lại | Trước 25/10/2026 | 5%\nThanh toán sớm 50% | Trước 25/10/2026 | 2,5%\nTiến độ chuẩn, không vay ngân hàng (Early Bird 3% + không vay 3%) | Theo tiến độ | 6%\nVay ngân hàng – giải ngân 70% (Early Bird) | Theo tiến độ | 3%" );
}

/** Ví dụ trong phiếu tính giá CĐT: căn niêm yết 3 tỷ (gồm VAT & KPBT). */
function hh_fours_f2_example_rows() {
	return array(
		array( 'Thanh toán sớm 95%', 'Early Bird 3% + không vay 3% + 12%', '2,484 tỷ', '516 triệu' ),
		array( 'Thanh toán sớm 70%', 'Early Bird 3% + không vay 3% + 5%', '2,682 tỷ', '318 triệu' ),
		array( 'Thanh toán sớm 50%', 'Early Bird 3% + không vay 3% + 2,5%', '2,752 tỷ', '248 triệu' ),
		array( 'Tiến độ chuẩn (không vay)', 'Early Bird 3% + không vay 3%', '2,823 tỷ', '177 triệu' ),
		array( 'Vay ngân hàng 70%', 'Early Bird 3%', '2,910 tỷ', '90 triệu' ),
	);
}

add_filter( 'hh_project_dataset', 'hh_dataset_fours_f2', 50 );
function hh_dataset_fours_f2( $projects ) {
	$policy = hh_fours_f2_policy_meta();
	foreach ( $projects as $i => $p ) {
		if ( 'fours-tower' !== ( $p['slug'] ?? '' ) ) {
			continue;
		}
		$upd = $policy + array(
			'hh_p_zones'      => "F1 – Tháp Tùng (Mùa Đông) | Căn hộ Studio – 3PN | 20 tầng | Đang mở bán (đợt đầu từ 3/2026)\nF5 – Tháp Cúc (Mùa Thu) | Căn hộ Studio – 3PN | 20 tầng | Đang mở bán (đợt đầu từ 3/2026)\nF2 – Tháp Mai (Mùa Xuân) | Căn hộ Studio – 3PN | 20 tầng | Đang mở bán – CSBH 4.2 từ 26/9/2026, 1.369 lượt đặt chỗ ngày ra mắt\nF3 – Tháp Trúc (Mùa Hạ) | Căn hộ | 20 tầng | Chưa công bố mở bán",
			'hh_p_highlights' => "Ngã tư Nguyễn Phước Lan – Minh Mạng, trung tâm khu Nam Đà Nẵng – trong đại đô thị Sun Riverpolis\n4 tháp Mai – Trúc – Cúc – Tùng cao 20 tầng, khoảng 2.291 căn Studio – 3PN, sở hữu lâu dài\nTòa F2 – Tháp Mai ra mắt 26/9/2026 với 1.369 lượt đặt chỗ (theo VnExpress)\nTiết kiệm đến khoảng 17% giá niêm yết khi thanh toán sớm 95% (CSBH 4.2 Tòa F2)\nCọc 100 triệu, đợt 2 chỉ 15% – nhận nhà khi thanh toán 70% theo Sun Early Key\nTiện ích resort trọn tầng 2: hồ bơi bốn mùa, gym, spa, khu trẻ em",
			'hh_p_handover'   => 'Tòa F2: bàn giao sử dụng dự kiến 31/5/2028 (Sun Early Key, theo phiếu tính giá CĐT)',
			'hh_p_progress'   => "19/3/2026 | Sun Property ra mắt FourS Tower – mở bán Tháp Tùng (F1), Tháp Cúc (F5)\n26/9/2026 | Ra mắt Tòa F2 – Tháp Mai (Mùa Xuân): 1.369 lượt đặt chỗ\n26/9/2026 | Áp dụng CSBH 4.2 Tòa F2 – chiết khấu đến 12% khi thanh toán sớm 95%\n25/10/2026 | Hạn thanh toán sớm 50% / 70% / 95% theo CSBH 4.2\n31/5/2028 | Tòa F2 bàn giao sử dụng (dự kiến)",
			'hh_p_faq'        => "FourS Tower ở đâu? | Ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng – phân khu căn hộ đầu tiên của Sun Riverpolis.\nFourS Tower có mấy tòa? | 4 tòa: F1 Tháp Tùng, F2 Tháp Mai, F3 Tháp Trúc, F5 Tháp Cúc (không dùng số 4), mỗi tòa 20 tầng nổi, 2 tầng hầm, tổng khoảng 2.291 căn.\nTòa nào đang mở bán? | F1 và F5 mở bán từ 3/2026; Tòa F2 – Tháp Mai ra mắt 26/9/2026 với chính sách bán hàng 4.2. F3 chưa công bố mở bán.\nChính sách FourS Tower F2 có gì? | Early Bird 3%, không vay thêm 3%, thanh toán sớm 95% / 70% / 50% trước 25/10/2026 thêm 12% / 5% / 2,5%. Ví dụ căn niêm yết 3 tỷ, thanh toán sớm 95% còn khoảng 2,48 tỷ.\nMua FourS Tower cần bao nhiêu tiền ban đầu? | Đặt cọc 100 triệu (Studio – 2PN) hoặc 150 triệu (3PN), khoảng 2 tuần sau thanh toán đủ 15%. Phương án vay: ngân hàng giải ngân 70%.\nKhi nào nhận nhà FourS Tower F2? | Theo phiếu tính giá CĐT, Tòa F2 dự kiến bàn giao sử dụng 31/5/2028 theo Sun Early Key, khi khách đã thanh toán 70%.\nFourS Tower có sở hữu lâu dài không? | Có, căn hộ FourS Tower sở hữu lâu dài cho người Việt Nam.",
			'rank_math_title'       => 'FourS Tower Đà Nẵng: Giá & Chính sách Tòa F2 T10/2026',
			'rank_math_description' => 'FourS Tower (Tháp Bốn Mùa) Sun Group – ngã tư Nguyễn Phước Lan, Đà Nẵng. Tòa F2 cọc 100 triệu, tiết kiệm đến ~17% khi thanh toán sớm, nhận nhà khi trả 70%.',
		);
		$projects[ $i ]['fix_meta'] = hh_fours_f2_old_meta() + array_intersect_key( $p['meta'], $upd ) + ( $p['fix_meta'] ?? array() );
		$projects[ $i ]['meta']     = array_merge( $p['meta'], $upd );
		$projects[ $i ]['content']     = hh_fours_tower_content();
		$projects[ $i ]['fix_content'] = array( hh_fours_tower_content( 1 ), hh_fours_18( hh_fours_tower_content() ) );
	}

	$projects[] = array(
		'slug'    => 'fours-tower-f2-thap-mai',
		'title'   => 'FourS Tower F2 – Tháp Mai (Mùa Xuân) Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'ngu-hanh-son',
		'parent'  => 'fours-tower',
		'order'   => 1,
		'hot'     => true,
		'excerpt' => 'Tòa F2 – Tháp Mai (Mùa Xuân) FourS Tower Đà Nẵng: ra mắt 26/9/2026 với 1.369 lượt đặt chỗ. Cọc 100 triệu, đợt 2 chỉ 15%, tiết kiệm đến khoảng 17% giá niêm yết khi thanh toán sớm, nhận nhà khi mới trả 70%.',
		'meta'    => $policy + array(
			'hh_p_status'      => 'dang-mo-ban',
			'hh_p_developer'   => 'Tập đoàn Sun Group (Sun Property phát triển)',
			'hh_p_type'        => 'Căn hộ Studio – 3 phòng ngủ, căn sân vườn',
			'hh_p_address'     => 'Ngã tư Nguyễn Phước Lan – Minh Mạng, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_blocks'      => 'Tòa F2 – Tháp Mai (Mùa Xuân), 1 trong 4 tháp FourS Tower',
			'hh_p_floors'      => '20 tầng nổi, 2 tầng hầm',
			'hh_p_ownership'   => 'Sở hữu lâu dài',
			'hh_p_handover'    => 'Bàn giao sử dụng dự kiến 31/5/2028 (Sun Early Key – đã thanh toán 70%)',
			'hh_p_unit_types'  => "Studio | – | – | Liên hệ\nCăn 1PN / 1PN+ | – | 1 | Liên hệ\nCăn 2PN | – | 2 | Liên hệ\nCăn 3PN | – | 3 | Liên hệ",
			'hh_p_highlights'  => "1.369 lượt đặt chỗ ngày ra mắt 26/9/2026 (theo VnExpress)\nTiết kiệm đến khoảng 17% giá niêm yết – ví dụ căn 3 tỷ còn khoảng 2,48 tỷ khi thanh toán sớm 95%\nCọc 100 triệu, khoảng 2 tuần sau mới thanh toán đủ 15%\nSun Early Key: nhận nhà khi mới thanh toán 70%, 25% còn lại trả dần sau khi ở\nVay ngân hàng: giải ngân 70% ngay sau ký hợp đồng mua bán\nTiện ích resort trọn tầng 2, thương mại tầng 1 – sở hữu lâu dài",
			'hh_p_amenities_in' => "Hồ bơi bốn mùa\nGym, yoga, spa\nKhu vui chơi trẻ em\nKhông gian sinh hoạt cộng đồng\nPhòng khám Mặt Trời\n(Tiện ích bố trí trọn tầng 2, thương mại tầng 1)",
			'hh_p_location_desc' => 'Tòa F2 nằm trong cụm 4 tháp FourS Tower tại ngã tư Nguyễn Phước Lan – Minh Mạng, trung tâm khu Nam Đà Nẵng, thuộc đại đô thị Sun Riverpolis (Hòa Quý). Từ đây về trung tâm Hải Châu, biển Mỹ Khê, sân bay và Hội An đều thuận tiện qua các trục Nguyễn Phước Lan, Minh Mạng, Võ Chí Công.',
			'hh_p_progress'    => "26/9/2026 | Ra mắt Tòa F2 – Tháp Mai tại Royal Lotus Đà Nẵng: 1.369 lượt đặt chỗ\n26/9/2026 | Áp dụng CSBH 4.2 Tòa F2\n25/10/2026 | Hạn thanh toán sớm 50% / 70% / 95%\n31/5/2028 | Bàn giao sử dụng (dự kiến)",
			'hh_p_faq'         => "FourS Tower F2 là tháp nào? | Tòa F2 là Tháp Mai – Mùa Xuân, một trong 4 tháp Mai, Trúc, Cúc, Tùng của FourS Tower (Sun Group) tại ngã tư Nguyễn Phước Lan – Minh Mạng, Đà Nẵng.\nGiá FourS Tower F2 bao nhiêu? | Giá từng căn theo tầng, hướng, loại căn – liên hệ để nhận bảng giá. Ví dụ trong phiếu tính giá CĐT: căn niêm yết 3 tỷ (gồm VAT, KPBT) thanh toán sớm 95% còn khoảng 2,48 tỷ, tiến độ chuẩn không vay khoảng 2,82 tỷ.\nChiết khấu FourS Tower F2 tối đa bao nhiêu? | Theo CSBH 4.2: Early Bird 3%, không vay 3%, thanh toán sớm 95% thêm 12% (cộng dồn lần lượt trên giá chưa VAT) – tương đương tiết kiệm khoảng 17% so với giá niêm yết.\nCần bao nhiêu tiền để mua căn F2? | Đặt cọc 100 triệu (Studio – 2PN) hoặc 150 triệu (3PN); khoảng 2 tuần sau thanh toán đủ 15%; sau đó 10% mỗi quý theo tiến độ chuẩn.\nSun Early Key là gì? | Chính sách cho khách nhận bàn giao sử dụng khi đã thanh toán 70% giá trị căn (Tòa F2 dự kiến 31/5/2028), phần còn lại trả dần 5% mỗi đợt sau khi nhận nhà.\nCó vay ngân hàng được không? | Được. Ngân hàng giải ngân 70% ngay sau ký hợp đồng mua bán; phương án vay không có chiết khấu không vay 3% nhưng vẫn được Early Bird 3%.\nHạn ưu đãi thanh toán sớm đến khi nào? | Theo CSBH 4.2, mốc thanh toán sớm muộn nhất là 25/10/2026. Chính sách có thể thay đổi theo đợt – liên hệ để nhận bản mới nhất.",
			'rank_math_title'         => 'FourS Tower F2 Tháp Mai: Giá, CSBH 4.2 – Tiết kiệm ~17%',
			'rank_math_description'   => 'FourS Tower F2 – Tháp Mai Đà Nẵng: 1.369 lượt đặt chỗ ngày ra mắt. Cọc 100 triệu, 15% ký HĐMB, nhận nhà khi trả 70%, thanh toán sớm tiết kiệm ~17%. Nhận phiếu tính giá.',
			'rank_math_focus_keyword' => 'FourS Tower F2,tòa F2 FourS Tower,giá FourS Tower F2',
		),
		'fix_meta' => hh_fours_f2_old_meta(),
		'content' => hh_fours_f2_content(),
		'fix_content' => array( hh_fours_f2_content( 1 ), hh_fours_18( hh_fours_f2_content( 2 ) ), hh_fours_18( hh_fours_f2_content( 3 ) ) ),
		'sources' => array(
			'https://vnexpress.net/thap-f2-fours-tower-ghi-nhan-gan-1-400-luot-dat-cho-5125919.html',
			'https://tuoitre.vn/fours-tower-an-cu-dau-tu-tai-trung-tam-nam-da-nang-20260410181212744.htm',
		),
	);
	return $projects;
}

/** 4 con số chính (chiết khấu cộng dồn 3% + 3% + 12%; vay: 15% + 10% vốn tự có trước bàn giao, ngân hàng giải ngân 70%). */
function hh_fours_stats() {
	return "<div class=\"lp-stats\">\n<p><b>19%</b><span>chiết khấu lên đến</span></p>\n<p><b>25%</b><span>vốn tự có đến khi nhận nhà (vay 70%)</span></p>\n<p><b>15%</b><span>thanh toán đến khi ký HĐMB</span></p>\n<p><b>70%</b><span>đã nhận nhà – Sun Early Key</span></p>\n</div>";
}

/** Bản bài đã nhập trước đó (con số 18%) – để thay bằng bản 19% nếu anh chưa sửa bài. */
function hh_fours_18( $html ) {
	return str_replace( '<p><b>19%</b><span>chiết khấu lên đến</span></p>', '<p><b>18%</b><span>chiết khấu cộng dồn tối đa</span></p>', $html );
}

/** Nút gọi nhận thông tin (mở form liên hệ, điền sẵn lời nhắn). */
function hh_fours_cta( $label, $msg, $class = 'btn btn--gold' ) {
	return '<a class="' . esc_attr( $class ) . '" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="' . esc_attr( $msg ) . '">' . esc_html( $label ) . '</a>';
}

function hh_fours_tower_content( $v = 2 ) {
	$cta   = hh_fours_cta( 'Nhận bảng giá & căn trống F2', 'Gửi tôi bảng giá, căn trống Tòa F2 và phiếu tính giá FourS Tower.' );
	$stats = 1 === $v
		? "<div class=\"lp-stats\">\n<p><b>1.369</b><span>lượt đặt chỗ ngày ra mắt Tòa F2</span></p>\n<p><b>~17%</b><span>tiết kiệm tối đa khi thanh toán sớm 95%</span></p>\n<p><b>100 triệu</b><span>đặt cọc giữ căn</span></p>\n<p><b>70%</b><span>đã nhận nhà (Sun Early Key)</span></p>\n</div>"
		: hh_fours_stats();
	return <<<HTML
<p><strong>FourS Tower</strong> (Tháp Bốn Mùa) là phân khu căn hộ đầu tiên của Sun Riverpolis – 4 tháp Mai, Trúc, Cúc, Tùng cao 20 tầng tại ngã tư Nguyễn Phước Lan – Minh Mạng, trung tâm khu Nam Đà Nẵng, sở hữu lâu dài. Tòa đang được quan tâm nhất hiện nay là <a href="/du-an/fours-tower-f2-thap-mai/">Tòa F2 – Tháp Mai</a>, ra mắt 26/9/2026 với 1.369 lượt đặt chỗ.</p>

{$stats}

<p class="lp-cta">{$cta} <a href="/du-an/fours-tower-f2-thap-mai/">Xem trang Tòa F2 →</a></p>

<h2>Nhận định của Hoàng Hiệp: nên chọn tòa nào?</h2>
<ul>
<li><strong>Muốn giá tốt nhất:</strong> Tòa F2 đang có chính sách 4.2 – thanh toán sớm 95% tiết kiệm khoảng 17% giá niêm yết, hạn 25/10/2026.</li>
<li><strong>Vốn mỏng, mua để ở:</strong> tiến độ chuẩn – cọc 100 triệu, 15% khi ký, 10% mỗi quý, nhận nhà khi mới trả 70%.</li>
<li><strong>Cần nhận nhà sớm:</strong> so sánh tiến độ F1, F5 (mở bán từ 3/2026) với F2 – Hiệp gửi bảng so sánh theo căn cụ thể.</li>
</ul>
<p>Xem thêm: <a href="/du-an/sun-riverpolis/">đại đô thị Sun Riverpolis</a> · <a href="/fours-tower-f2-thap-mai-mua-xuan/">FourS Tower F2 khác gì 3 tháp còn lại?</a> · <a href="/mua-ban/">căn hộ mua bán Đà Nẵng</a>.</p>
HTML;
}

function hh_fours_f2_content( $v = 3 ) {
	$rows = '';
	foreach ( hh_fours_f2_example_rows() as list( $plan, $ck, $pay, $save ) ) {
		$rows .= "<tr><td>{$plan}</td><td>{$ck}</td><td>{$pay}</td><td><strong>{$save}</strong></td></tr>\n";
	}
	$cta1 = hh_fours_cta( 'Nhận bảng giá & căn trống Tòa F2', 'Gửi tôi bảng giá và danh sách căn còn trống Tòa F2 FourS Tower.' );
	$cta2 = hh_fours_cta( 'Gửi mã căn – nhận phiếu tính giá', 'Tôi muốn nhận phiếu tính giá Tòa F2 FourS Tower cho căn: ', 'btn btn--navy' );
	$cta3 = hh_fours_cta( 'Xem căn tầng đẹp còn lại', 'Gửi tôi các căn tầng đẹp, view sông còn trống Tòa F2 FourS Tower.' );
	$intro = 1 === $v
		? "<p><strong>FourS Tower F2</strong> – Tháp Mai (Mùa Xuân) – ra mắt sáng 26/9/2026 tại Royal Lotus Đà Nẵng. 6 con số anh chị nên biết trước khi chọn căn Tòa F2:</p>\n\n<div class=\"lp-stats\">\n<p><b>1.369</b><span>lượt đặt chỗ ngày ra mắt 26/9</span></p>\n<p><b>~17%</b><span>tiết kiệm tối đa so với giá niêm yết</span></p>\n<p><b>100 triệu</b><span>đặt cọc (3PN: 150 triệu)</span></p>\n<p><b>15%</b><span>thanh toán đến khi ký HĐMB</span></p>\n<p><b>70%</b><span>đã nhận nhà – Sun Early Key</span></p>\n<p><b>25/10</b><span>hạn chiết khấu thanh toán sớm</span></p>\n</div>"
		: "<p><strong>FourS Tower F2</strong> – Tháp Mai (Mùa Xuân) – ra mắt sáng 26/9/2026 tại Royal Lotus Đà Nẵng với 1.369 lượt đặt chỗ. 4 con số đáng chú ý nhất:</p>\n\n" . hh_fours_stats() . ( $v >= 3 ? "\n\n[hh_von_tu_co]" : '' );
	return <<<HTML
{$intro}

<p class="lp-cta">{$cta1} {$cta2}</p>

<h2>Một căn 3 tỷ, trả bao nhiêu? 5 phương án thanh toán Tòa F2</h2>
<p>Ví dụ theo phiếu tính giá của chủ đầu tư (CSBH 4.2, từ 26/9/2026) cho căn giá niêm yết 3 tỷ đã gồm VAT và kinh phí bảo trì. Chiết khấu tính trên giá chưa VAT, cộng dồn lần lượt.</p>
<table>
<thead><tr><th>Phương án</th><th>Chiết khấu áp dụng</th><th>Tổng thanh toán</th><th>Tiết kiệm</th></tr></thead>
<tbody>
{$rows}</tbody>
</table>
<p>Số tiền là ví dụ minh họa trong phiếu của CĐT, không phải giá một căn cụ thể. Mỗi căn có giá theo tầng, hướng, loại căn – gửi mã căn anh chị quan tâm, Hiệp gửi lại phiếu tính giá đúng căn đó.</p>
<p class="lp-cta">{$cta2}</p>

<h2>Sun Early Key: nhận nhà khi mới thanh toán 70%</h2>
<p>Với tiến độ chuẩn, anh chị chỉ cần chuẩn bị tiền theo từng quý thay vì một khoản lớn:</p>
<ol>
<li><strong>Đặt cọc 100 triệu</strong> (3PN: 150 triệu) khi ký thỏa thuận.</li>
<li><strong>Khoảng 2 tuần sau:</strong> thanh toán đủ 15%, sau đó ký hợp đồng mua bán.</li>
<li><strong>Từ quý 1/2027:</strong> 10% mỗi 3 tháng (5 đợt), thêm 5% trước bàn giao.</li>
<li><strong>Nhận nhà dự kiến 31/5/2028</strong> khi đã thanh toán 70%.</li>
<li><strong>Sau khi ở:</strong> 25% còn lại trả 5% mỗi 4 tháng; 5% cuối khi nhận sổ.</li>
</ol>
<p>Ngày cụ thể tính từ ngày anh chị ký đặt cọc. Chọn vay ngân hàng thì ngân hàng giải ngân 70% ngay sau ký hợp đồng mua bán.</p>

<h2>Vì sao Tòa F2 – Tháp Mai được chọn nhiều?</h2>
<ul>
<li><strong>Chính sách mới nhất:</strong> đợt đầu áp dụng CSBH 4.2 với mức chiết khấu thanh toán sớm đến 12%.</li>
<li><strong>Tòa mới mở bán:</strong> từ 26/9/2026 – chọn sớm thì còn nhiều lựa chọn tầng, hướng, loại căn hơn.</li>
<li><strong>An cư đa thế hệ:</strong> cơ cấu Studio đến 3PN và căn sân vườn, cảm hứng hoa mai – khởi đầu mới.</li>
<li><strong>Tiện ích resort trọn tầng 2:</strong> hồ bơi bốn mùa, gym, spa, khu trẻ em; thương mại tầng 1.</li>
<li><strong>Sở hữu lâu dài</strong> tại trung tâm khu Nam Đà Nẵng, trong đại đô thị Sun Riverpolis.</li>
</ul>
<p class="lp-cta">{$cta3}</p>

<h2>Nên chọn phương án nào? Nhận định của Hoàng Hiệp</h2>
<ul>
<li><strong>Có sẵn vốn:</strong> thanh toán sớm 95% – mức tiết kiệm lớn nhất (ví dụ căn 3 tỷ tiết kiệm khoảng 516 triệu), nhưng cần thanh toán trước 25/10/2026.</li>
<li><strong>Vốn khoảng 70%:</strong> thanh toán sớm 70% – tiết kiệm khoảng 318 triệu, nhận nhà rồi mới trả 25% còn lại.</li>
<li><strong>Vốn mỏng, mua để ở:</strong> tiến độ chuẩn không vay – vẫn tiết kiệm khoảng 6%, chia nhỏ theo quý.</li>
<li><strong>Muốn giữ tiền mặt:</strong> vay ngân hàng 70% – lưu ý tính thêm lãi vay khi so sánh.</li>
</ul>
<p>Xem thêm: <a href="/du-an/fours-tower/">tổng quan FourS Tower 4 tòa</a> · <a href="/fours-tower-f2-thap-mai-mua-xuan/">F2 khác gì 3 tháp còn lại?</a> · <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng giá Tòa F2, danh sách căn còn trống và phiếu tính giá theo đúng căn, đúng phương án anh chị chọn.</p>
HTML;
}

/** Bài "F2 khác gì 3 tháp còn lại?" viết khi F2 chưa có trang riêng – trỏ sang trang Tòa F2. */
add_filter(
	'the_content',
	static function ( $html ) {
		return str_replace(
			'F2 chưa có trang riêng, thông tin chung xem tại <a href="/du-an/fours-tower/">dự án FourS Tower</a>',
			'bảng giá, chính sách và phiếu tính giá Tòa F2 xem tại trang <a href="/du-an/fours-tower-f2-thap-mai/">FourS Tower F2 – Tháp Mai</a>',
			$html
		);
	},
	9
);
