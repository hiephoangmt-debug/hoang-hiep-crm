<?php
/**
 * Capital Square – Broadway Place (S3) & Hudson Place (S4): "Bộ 3 chính sách" anh Hiệp gửi 10/11/2026.
 * Không ghi tên đơn vị phân phối trên ấn phẩm; không dùng ảnh ấn phẩm (có logo đơn vị phân phối).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new3 = "Chính sách 11/2026 cho tòa Broadway Place (S3) và Hudson Place (S4):\nVay ngân hàng: 5 năm không lo lãi suất (hỏi Hoàng Hiệp điều kiện và hạn mức cụ thể)\nChiết khấu thêm 5%\nQuà tặng gói Smart Home: 1PN 100 triệu · 2PN 200 triệu · 3PN 300 triệu\nTặng chuyến du lịch châu Âu trị giá 100 triệu\nQuà tặng sự kiện – số lượng giới hạn";
		$set  = array(
			'capital-square-hudson-place-s4' => array(
				'hh_p_policy'      => $new3 . "\nMiễn phí phí quản lý dịch vụ 1 năm\nƯu đãi theo phương thức thanh toán (tài liệu 28/9/2026 – hỏi lại khi đặt căn): theo tiến độ 8%, thanh toán nhanh 100% giá chuyển nhượng hợp đồng 12%, thanh toán sớm 95% 18%\nChính sách thay đổi theo đợt – liên hệ để nhận phiếu tính giá từng căn",
				'hh_p_offer_title' => 'Bộ 3 ưu đãi 11/2026: vay 5 năm không lo lãi suất, chiết khấu thêm 5%, quà Smart Home tới 300 triệu',
			),
			'capital-square-da-nang'         => array(
				'hh_p_policy' => null, // Nối thêm vào chính sách hiện có.
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $set[ $slug ] ) ) {
				continue;
			}
			foreach ( $set[ $slug ] as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( null === $v ) {
					if ( '' === $cur || false !== strpos( $cur, 'Broadway Place (S3) và Hudson Place (S4)' ) ) {
						continue;
					}
					$v = $cur . "\n" . $new3;
				}
				if ( '' !== $cur && $cur !== $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				$p['meta'][ $k ] = $v;
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	990 // Sau các file dữ liệu Capital Square khác.
);
