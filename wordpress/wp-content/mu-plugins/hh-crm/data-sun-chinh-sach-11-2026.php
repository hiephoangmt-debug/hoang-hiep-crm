<?php
/**
 * Chính sách bán hàng các dự án Sun Group Đà Nẵng cập nhật 11/2026 (thư mục chính sách anh Hiệp gửi 05/11/2026):
 * văn bản CSƯĐ/CSBH ban hành + mức thanh toán sớm tháng 11 (hạn 25/11/2026) theo phiếu tính giá.
 * Không ghi hoa hồng đại lý, mã căn, tài khoản. Thay giá trị cũ nếu web chưa sửa tay (fix_meta).
 */

defined( 'ABSPATH' ) || exit;

function hh_sun_policy_11_2026() {
	$loan = static fn( $months, $until ) => "Vay ngân hàng tối đa 70%, chủ đầu tư hỗ trợ lãi suất $months tháng (không muộn hơn $until), ân hạn gốc cùng thời gian, miễn phí trả nợ trước hạn trong thời gian hỗ trợ";
	$end  = "Chiết khấu tính trên giá chưa VAT và phí bảo trì · Sun Early Key: thanh toán đủ 70% là nhận nhà sử dụng\nTrả trước hạn từng đợt (≥ 10 ngày): hưởng 8%/năm; 5% cuối đóng khi bàn giao, chủ đầu tư trả lãi 8%/năm\nThông tin tham khảo 11/2026 – chính sách thay đổi theo từng đợt, liên hệ Hoàng Hiệp 0904 567 009 để nhận phiếu tính giá căn cụ thể";
	return array(
		'spana-tower'              => "Theo CSƯĐ 03/Spana Tower (từ 03/6/2026)\nQuà tặng an cư 3%\nKhông vay ngân hàng: chiết khấu thêm 5%\nThanh toán sớm tháng 11/2026 (hạn 25/11): 95% chiết khấu 6% · 70% chiết khấu 1%\nĐặt cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 38 tháng\n" . $loan( 24, '30/6/2028' ) . "\nMiễn phí quản lý 1 năm · Khách đã sở hữu BĐS Sun: thêm 1 – 1,5% theo hạng thành viên\n" . $end,
		'cora-tower'               => "Căn hộ A1, A2 – CSƯĐ 06.1 (từ 21/8/2026): đặc quyền hoàn thiện nội thất 7%\nShop khối đế A1, A2 – CSƯĐ 06 (từ 17/8/2026): Early Bird 3% (có thời hạn) + hỗ trợ nội thất kinh doanh 4%, đặt cọc 300 triệu; tiến độ chuẩn: cọc → 15% → mỗi quý 10% đến 70% (nhận nhà 31/10/2027) → 5% mỗi 4 tháng → 5% khi nhận sổ\nKhông vay ngân hàng: chiết khấu thêm 5%\nThanh toán sớm tháng 11/2026 (hạn 25/11): 95% chiết khấu 7,5% · 70% chiết khấu 1,5%\nĐặt cọc căn hộ 100 triệu (3PN 150 triệu, penthouse 300 triệu), giãn tiến độ đến 40 tháng\n" . $loan( 24, '30/9/2028' ) . "\nMiễn phí quản lý 1 năm · Điểm thưởng Sun Signature 0,7 – 2% theo hạng\n" . $end,
		's-light-tower'            => "Căn hộ – CSBH 01/SL (từ 9/7/2026) · Penthouse – CSBH 01/SL (từ 17/8/2026)\nEarly Bird 3% (có thời hạn – hỏi còn áp dụng không) · Không lấy bảo lãnh ngân hàng: chiết khấu thêm 1% khi ký hợp đồng mua bán\nKhông vay ngân hàng: chiết khấu thêm 3%\nThanh toán sớm tháng 11/2026 (hạn 25/11): 95% chiết khấu 10% · 70% chiết khấu 3%\nĐặt cọc: Studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu, penthouse 300 triệu; giãn tiến độ đến 48 tháng\n" . $loan( 24, '30/9/2028' ) . "\nMiễn phí quản lý 1 năm · Điểm thưởng Sun Signature 0,7 – 2% theo hạng\n" . $end,
		'fours-tower-f1-thap-tung' => "Theo CSBH 04/FT (ký mới từ 8/8/2026): hỗ trợ hoàn thiện nội thất 7%\nKhông vay ngân hàng: chiết khấu thêm 5%\nThanh toán sớm tháng 11/2026 (hạn 25/11): 95% chiết khấu 9% · 70% chiết khấu 2,5%\nĐặt cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 45 tháng\n" . $loan( 24, '31/10/2028' ) . "\nMiễn phí quản lý 1 năm · Điểm thưởng Sun Signature 0,7 – 2% theo hạng\n" . $end,
		'fours-tower-f5-thap-cuc'  => "Theo CSBH 04/FT (ký mới từ 8/8/2026): hỗ trợ hoàn thiện nội thất 7%\nKhông vay ngân hàng: chiết khấu thêm 5%\nThanh toán sớm tháng 11/2026 (hạn 25/11): 95% chiết khấu 9% · 70% chiết khấu 2,5%\nĐặt cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 45 tháng\n" . $loan( 24, '31/10/2028' ) . "\nMiễn phí quản lý 1 năm · Điểm thưởng Sun Signature 0,7 – 2% theo hạng\n" . $end,
		'fours-tower-f2-thap-mai'  => "Theo CSBH 4.2/FT tòa F2 (từ 26/9/2026)\nQuà nội thất Nhà Xinh: Studio 35 triệu · 1PN/1PN+ 50 triệu · 2PN 75 triệu · 3PN 100 triệu\nKhông vay ngân hàng: chiết khấu thêm 3%\nThanh toán sớm: mức tháng 11/2026 liên hệ để cập nhật (mức trước 25/10: 95% – 12%, 70% – 5%, 50% – 2,5%)\nĐặt cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 45 tháng\n" . $loan( 24, '31/1/2029' ) . "\nMiễn phí quản lý 2 năm · Điểm thưởng Sun Signature 0,7 – 2% theo hạng\n" . $end,
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = hh_sun_policy_11_2026();
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( empty( $new[ $slug ] ) ) {
				continue;
			}
			$cur = $p['meta']['hh_p_policy'] ?? '';
			$projects[ $i ]['meta']['hh_p_policy'] = $new[ $slug ];
			$old = array_filter( array_merge( (array) ( $p['fix_meta']['hh_p_policy'] ?? array() ), is_string( $cur ) && '' !== $cur ? array( $cur ) : array() ) );
			if ( $old ) {
				$projects[ $i ]['fix_meta']['hh_p_policy'] = array_values( array_unique( $old ) );
			}
		}
		return $projects;
	},
	75
);
