<?php
/**
 * Nobu Residences Đà Nẵng – chính sách bán hàng (3 ảnh chính sách anh Hiệp gửi 20/11/2026: vay hỗ trợ lãi suất,
 * chiết khấu mua nhiều căn, ưu đãi nhiều tầng). Chỉ lấy thông tin, không dùng ảnh. Ảnh không ghi ngày áp dụng →
 * ghi "theo chính sách đang áp dụng 11/2026". Chỉ điền ô còn trống trên web (ô anh đã nhập giữ nguyên).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = array(
			'hh_p_offer_title'  => 'Chiết khấu theo phương thức thanh toán tới 14%',
			'hh_p_offer_note'   => 'Theo chính sách bán hàng Nobu Residences Đà Nẵng đang áp dụng (cập nhật 20/11/2026) – điều kiện chi tiết từng căn liên hệ Hoàng Hiệp.',
			'hh_p_offer_stats'  => "14% | Chiết khấu theo phương thức thanh toán (tối đa)\n2% | Chiết khấu chọn căn\n24 tháng | Ân hạn gốc, hỗ trợ lãi suất\n100 triệu | Đặt chỗ",
			'hh_p_policy'       => "Chiết khấu theo phương thức thanh toán: tối đa 14%\nChiết khấu chọn căn: 2%\nQuyết định trong 24 giờ: chiết khấu thêm 0,5%\nMua nhiều căn: 2 căn giảm 1%, 3 căn giảm 1,5%, từ 4 căn giảm 2% (đặt cọc không hoàn lại trong 15 ngày kể từ giao dịch đầu tiên)\nCó chiết khấu riêng cho khách hàng thân thiết mua thêm căn – liên hệ để biết mức cụ thể\nVay ngân hàng: ân hạn gốc, hỗ trợ lãi suất 24 tháng kể từ ngày giải ngân đầu tiên",
			'hh_p_loan'         => 'Phương án vay hỗ trợ lãi suất: khách thanh toán 5% mỗi đợt (tổng khoảng 30%), ngân hàng giải ngân khoảng 70% (20% – 20% – 30% ở các đợt 25%, 25%, 35%); ân hạn gốc và chủ đầu tư hỗ trợ lãi suất 24 tháng kể từ ngày giải ngân đầu tiên.',
			'hh_p_loan_ratio'   => '70',
			'hh_p_loan_grace'   => '24',
			'hh_p_payment'      => "Đặt chỗ | Khi chọn căn | 100 triệu đồng\nĐợt 1 | Sau đặt chỗ khoảng 7 ngày | 5%\nĐợt 2 | Khoảng 60 ngày sau đợt 1 | 25% (khách 5%, ngân hàng 20%)\nĐợt 3 | Khoảng 60 ngày sau đợt 2 | 5%\nĐợt 4 | Khoảng 60 ngày sau đợt 3 | 25% (khách 5%, ngân hàng 20%)\nĐợt 5 | Theo tiến độ / thông báo chủ đầu tư | 35% (khách 5%, ngân hàng 30%)\nĐợt 6 | Bàn giao / theo thông báo | 5%",
		);
		foreach ( $projects as $i => $p ) {
			if ( 'nobu-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				if ( '' === trim( (string) ( $p['meta'][ $k ] ?? '' ) ) ) {
					$projects[ $i ]['meta'][ $k ] = $v;
				}
			}
		}
		return $projects;
	},
	40
);
