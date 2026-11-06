<?php
/**
 * Fusion Resort & Villas Đà Nẵng – chính sách bán hàng chủ đầu tư cho căn biệt thự 4 phòng ngủ cuối cùng (anh Hiệp gửi 06/11/2026).
 * Không ghi mã căn; không dùng ảnh tài liệu có logo đơn vị phân phối khác. Phần "chính sách đặc biệt trước 30/9/2026" đã hết hạn → không đăng.
 * Thông tin dự án theo tài liệu hỏi đáp CĐT 07/5/2026 và bảng giá 10/12/2025.
 * Dự án chuyển từ "đã bán hết" sang "đang mở bán" để hiện mục Giá & chính sách; giá chuyển nhượng vẫn giữ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_sold_out'     => '0',
			'hh_p_offer_title'  => 'Chiết khấu 20% khi thanh toán nhanh – căn biệt thự 4 phòng ngủ cuối cùng',
			'hh_p_offer_note'   => 'Áp dụng cho căn Beach Garden Villa 4 phòng ngủ (đất 753 m²) cuối cùng chủ đầu tư còn bán (chính sách tháng 11/2026, tham khảo – liên hệ để xác nhận trước khi giao dịch).',
			'hh_p_policy'       => "Chiết khấu 20% trên giá bán khi thanh toán nhanh\nTặng trọn gói nội thất tiêu chuẩn 5 sao Fusion (giá trị khoảng 2 tỷ đồng)\nVilla mua để ở: tặng 5 năm phí quản lý\nVilla tham gia cho thuê: sở hữu 40 điểm ở mỗi năm\nVilla tham gia chương trình cho thuê: tặng thêm 30 điểm ở, dùng trong 2 năm\nGiá niêm yết Beach Garden Villa 4PN (đất 753 m², villa 463 m²): khoảng 58,41 tỷ đồng chưa VAT (bảng giá chủ đầu tư 12/2025) – giá sau chiết khấu liên hệ Hoàng Hiệp",
			'hh_p_price_table'  => 'Beach Garden Villa 4 phòng ngủ (căn cuối cùng) | Đất 753 m² · villa 463 m² | Khoảng 58,41 tỷ (chưa VAT, bảng giá CĐT 12/2025) | Chiết khấu 20% khi thanh toán nhanh',
		);
		// Thông tin dự án theo tài liệu hỏi đáp của chủ đầu tư (07/5/2026). Không đăng hồ sơ pháp lý (khách cần thì anh Hiệp gửi).
		$new += array(
			'hh_p_scale'        => '15,75 ha – khoảng 300 m bờ biển',
			'hh_p_units'        => '85 biệt thự 1 – 6 phòng ngủ (giai đoạn 1: 44 căn, giai đoạn 2: 41 căn) và khách sạn 18 tầng 157 phòng',
			'hh_p_unit_area'    => 'Đất khoảng 370 – 1.718 m², diện tích biệt thự 210 – 1.236 m²',
			'hh_p_manager'      => 'Fusion Hotel Group',
			'hh_p_villa_table'  => "Presidential Villa 6PN – 1 căn | 1.718 m² | Biệt thự 1.236 m² | Liên hệ
Beachfront Villa 5PN – 9 căn | 850 – 950 m² | Biệt thự 725 m², mặt biển | Chuyển nhượng – liên hệ
Premier Villa 3 – 5PN – 14 căn | 641 – 767 m² | Biệt thự 487 – 541 m² | Chuyển nhượng – liên hệ
Beach Garden Residence 3 – 4PN – 11 căn | 750 – 902 m² | Biệt thự 463 m² | Chủ đầu tư còn 1 căn 4PN – khoảng 58,41 tỷ (chưa VAT)
Garden Terrace Villa 2PN – 40 căn | 418 – 513 m² | Biệt thự 302 – 384 m² | Chuyển nhượng – liên hệ
Garden Front Villa 1PN – 10 căn | 370 – 535 m² | Biệt thự 210 m² | Chuyển nhượng – liên hệ",
			'hh_p_amenities_in' => "Hồ bơi chính 1.377 m² (trong nhà và ngoài trời), hồ bơi riêng từng biệt thự 24 – 192 m²
Bãi biển riêng khoảng 300 m
Spa, phòng tập, câu lạc bộ thể thao, sân tennis, sân golf mini
Nhà hàng chính bên hồ bơi (158 chỗ) và Grill House & Bar bên bãi biển
Khu vui chơi trẻ em
An ninh, vận hành, kỹ thuật 24/7; xe buggy nội khu
Bãi đỗ xe 3.653 m² (khoảng 143 ô tô, 200 xe máy)",
			'hh_p_design_desc'  => 'Biệt thự thiết kế hướng biển hoặc vườn riêng, đón ánh sáng và gió tự nhiên. Tầng trệt cao 3,7 m, tầng lầu 3 m (thông thủy 2,7 – 2,9 m); hồ bơi riêng 24 – 192 m² tùy loại; hàng rào cao 2 m, đường nội khu rộng 6 m. Bàn giao kèm nội thất gắn tường và nội thất rời theo chính sách bán hàng; bảo hành 24 tháng. Ngoại thất, cảnh quan giữ đồng bộ, nội thất thay đổi khi chủ đầu tư đồng ý.',
			'hh_p_rental'       => "Chủ sở hữu chọn: tự ở, cho thuê dài hạn từ 6 tháng, hoặc tham gia chương trình cho thuê (rental pool) do Fusion vận hành.
Rental pool: chủ nhận 35% doanh thu gộp cho thuê, chi trả theo quý; 40 điểm nghỉ mỗi năm (1 – 2 điểm/đêm tùy mùa), điểm chưa dùng chuyển sang 6 tháng đầu năm sau; giảm 10 – 20% dịch vụ resort.
Không cam kết lợi nhuận tối thiểu. Công suất phòng chủ đầu tư công bố: 50 – 55% (Q2/2024 – Q4/2025), dự kiến 55 – 65% năm tiếp theo.
Hợp đồng cho thuê 5 năm, muốn rút báo trước 9 tháng; tham gia cần mua gói nội thất rời tiêu chuẩn Fusion.
Tham gia cho thuê: không trả phí quản lý, đóng kinh phí bảo trì 2%. Tự ở: phí quản lý 25.000 đồng/m² diện tích biệt thự (chưa VAT), tăng tối đa 5%/năm từ 2026.
Khu biệt thự vận hành từ quý 1/2024, chương trình cho thuê từ tháng 3/2024.",
		);
		$old = array(
			'hh_p_status'   => array( 'da-ban-giao' ),
			'hh_p_sold_out' => array( '1' ),
			'hh_p_villa_table' => array( 'Biệt thự biển (tin rao) | 486 – 700 m² | – | Khoảng 32 – 54 tỷ' ),
			'hh_p_unit_area'   => array( 'Đất khoảng 486 – 700 m²' ),
			'hh_p_manager'     => array( 'Fusion' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'fusion-resort-villas-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				$projects[ $i ]['meta'][ $k ] = $v;
				$fix = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), $old[ $k ] ?? array(), '' !== $cur && $cur !== $v ? array( $cur ) : array() );
				if ( $fix ) {
					$projects[ $i ]['fix_meta'][ $k ] = array_values( array_unique( $fix ) );
				}
			}
			$projects[ $i ]['fix_excerpt'] = $p['excerpt'] ?? '';
			$projects[ $i ]['excerpt']     = 'Biệt thự biển Fusion Resort & Villas Đà Nẵng trên trục Trường Sa (Ngũ Hành Sơn): chủ đầu tư còn 1 căn Beach Garden Villa 4 phòng ngủ, đất 753 m², chiết khấu 20% khi thanh toán nhanh, tặng nội thất 5 sao khoảng 2 tỷ; các căn khác giao dịch chuyển nhượng.';
		}
		return $projects;
	},
	30 // Sau hh_dataset_biet_thu_ven_bien (20) – nơi khai báo dự án.
);
