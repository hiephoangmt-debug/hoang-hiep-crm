<?php
/**
 * Capital Square Đà Nẵng – cập nhật 11/2026 từ bộ tài liệu dự án anh Hiệp gửi (Drive "Link Full", giỏ hàng Excel, tin tổng quan):
 * ảnh phối cảnh, tiện ích ngoài trời, flycam tiến độ 9/2025 và 5/2026, mặt bằng điển hình tòa C1 / C7 / S3;
 * tiêu chuẩn bàn giao (danh mục vật liệu của chủ đầu tư); chính sách đặt cọc – thưởng nóng; sở hữu cho người nước ngoài;
 * tour 360 trên web dự án; thêm tòa S3 Broadway vào bảng giá (giỏ hàng 11/2026, gồm VAT & KPBT, chưa chiết khấu).
 * Không dùng ảnh có logo đơn vị phân phối; không đăng mã căn, hợp đồng mẫu, tài khoản ngân hàng trong bảng hàng.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im  = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/capital-square/capital-square-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$img = array(
			$im( 'phoi-canh-toan-canh-ban-ngay', 'Phối cảnh Capital Square Đà Nẵng – các tòa căn hộ bên bờ Đông sông Hàn', 'đại diện' ),
			$im( 'phoi-canh-ngay-ven-song-han', 'Phối cảnh tổ hợp Capital Square nhìn từ sông Hàn ban ngày', 'thư viện' ),
			$im( 'phoi-canh-dem-ven-song-han', 'Phối cảnh Capital Square về đêm bên sông Hàn', 'thư viện' ),
			$im( 'phoi-canh-hoang-hon', 'Phối cảnh các tòa Capital Square lúc hoàng hôn', 'thư viện' ),
			$im( 'phoi-canh-ve-dem', 'Phối cảnh Capital Square ven sông Hàn về đêm', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-truc-dien', 'Phối cảnh một tòa tháp Capital Square nhìn trực diện', 'thư viện' ),
			$im( 'phoi-canh-tien-ich-tren-cao', 'Phối cảnh tổng thể khu tiện ích nội khu Capital Square nhìn từ trên cao', 'tiện ích' ),
			$im( 'tien-ich-ho-boi-lon', 'Hồ bơi lớn nội khu Capital Square', 'tiện ích' ),
			$im( 'tien-ich-ho-boi-noi-khu', 'Hồ bơi giữa các tòa căn hộ Capital Square', 'tiện ích' ),
			$im( 'tien-ich-ho-boi-tre-em', 'Hồ bơi trẻ em, khu thư giãn ven hồ', 'tiện ích' ),
			$im( 'tien-ich-ho-boi-tre-em-tren-cao', 'Khu hồ bơi và sân chơi nước cho trẻ em nhìn từ trên cao', 'tiện ích' ),
			$im( 'tien-ich-cong-vien-nuoc-tre-em', 'Công viên nước mini cho trẻ em', 'tiện ích' ),
			$im( 'tien-ich-san-choi-nuoc', 'Sân chơi nước cho trẻ em giữa các tòa', 'tiện ích' ),
			$im( 'tien-ich-khu-vui-choi-tre-em', 'Khu vui chơi trẻ em ngoài trời', 'tiện ích' ),
			$im( 'tien-ich-khu-vui-choi-ve-dem', 'Khu vui chơi ngoài trời về đêm', 'tiện ích' ),
			$im( 'tien-ich-san-tap-golf', 'Sân tập golf mini (putting green) nội khu', 'tiện ích' ),
			$im( 'tien-ich-san-tap-golf-luoi', 'Khu tập golf có lưới', 'tiện ích' ),
			$im( 'tien-ich-san-tap-the-thao', 'Sân tập thể thao, yoga ngoài trời', 'tiện ích' ),
			$im( 'tien-ich-san-bong-ro-mini', 'Sân bóng rổ mini', 'tiện ích' ),
			$im( 'tien-ich-vuon-cay-noi-khu', 'Vườn cây, lối dạo nội khu', 'tiện ích' ),
			$im( 'tien-ich-vuon-thu-gian', 'Vườn thư giãn nhiều cây xanh', 'tiện ích' ),
			$im( 'tien-ich-cong-vien-tieu-canh', 'Công viên tiểu cảnh giữa các tòa', 'tiện ích' ),
			$im( 'tien-ich-loi-dao-ho-nuoc', 'Lối dạo và hồ nước cảnh quan', 'tiện ích' ),
			$im( 'tien-ich-loi-dao-canh-quan', 'Lối dạo cảnh quan nội khu', 'tiện ích' ),
			$im( 'tien-ich-san-vuon-tren-cao', 'Sân vườn trên cao nhìn ra sông Hàn', 'tiện ích' ),
			$im( 'tien-ich-vuon-treo-ban-cong', 'Vườn treo, ban công xanh', 'tiện ích' ),
			$im( 'tien-ich-pho-di-bo-noi-khu', 'Phố đi bộ nội khu', 'tiện ích' ),
			$im( 'tien-ich-pho-di-bo-hang-cay', 'Phố đi bộ hai hàng cây', 'tiện ích' ),
			$im( 'tien-ich-cong-chao-pho-di-bo', 'Cổng chào phố đi bộ thương mại', 'tiện ích' ),
			$im( 'tien-ich-quang-truong-thuong-mai', 'Quảng trường thương mại khối đế', 'tiện ích' ),
			$im( 'tien-ich-quang-truong-anh-sang', 'Quảng trường ánh sáng', 'tiện ích' ),
			$im( 'tien-ich-pho-am-thuc-ngoai-troi', 'Phố ẩm thực, café ngoài trời', 'tiện ích' ),
			$im( 'tien-ich-khoi-de-thuong-mai', 'Khối đế thương mại dọc tuyến phố', 'tiện ích' ),
			$im( 'tien-ich-sanh-toa-nha-ve-dem', 'Sảnh tòa nhà về đêm', 'tiện ích' ),
			$im( 'mat-bang-dien-hinh-toa-c1-tang-5-8', 'Mặt bằng điển hình tòa C1 tầng 5 – 8: căn 1PN, 2PN, 2PN+1', 'mặt bằng', 'Tòa C1' ),
			$im( 'mat-bang-dien-hinh-toa-c1-2', 'Mặt bằng điển hình tòa C1 (tầng cao)', 'mặt bằng', 'Tòa C1' ),
			$im( 'mat-bang-dien-hinh-toa-c1-3', 'Mặt bằng điển hình tòa C1 (tầng cao, có căn 3PN)', 'mặt bằng', 'Tòa C1' ),
			$im( 'mat-bang-dien-hinh-toa-c7-victory', 'Mặt bằng điển hình tòa C7 Victory tầng 5 – 10 và 11 – 27', 'mặt bằng', 'Tòa C7' ),
			$im( 'mat-bang-dien-hinh-toa-c7-victory-2', 'Mặt bằng điển hình tòa C7 Victory', 'mặt bằng', 'Tòa C7' ),
			$im( 'mat-bang-dien-hinh-toa-s3-broadway', 'Mặt bằng điển hình tòa S3 Broadway tầng 5 – 12, 14 – 24: căn 1PN, 2PN, 3PN', 'mặt bằng', 'Tòa S3' ),
			$im( 'mat-bang-dien-hinh-toa-s3-broadway-2', 'Mặt bằng điển hình tòa S3 Broadway', 'mặt bằng', 'Tòa S3' ),
		);
		for ( $k = 1; $k <= 12; $k++ ) {
			$img[] = $im( sprintf( 'tien-do-5-2026-flycam-%02d', $k ), 'Tiến độ thi công Capital Square tháng 5/2026 – ảnh flycam công trường bên sông Hàn', 'tiến độ', 'Thực tế 5/2026' );
		}
		for ( $k = 1; $k <= 4; $k++ ) {
			$img[] = $im( sprintf( 'tien-do-9-2025-flycam-%02d', $k ), 'Tiến độ thi công Capital Square tháng 9/2025 – ảnh flycam', 'tiến độ', 'Thực tế 9/2025' );
		}
		$s3 = 'S3 Broadway | 47 – 101 m² | 4,78 – 11,61 tỷ | 1PN từ 4,78 tỷ, 2PN từ 6,58 tỷ, 3PN từ 8,50 tỷ';
		foreach ( $projects as $i => $p ) {
			if ( 'capital-square-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$m   = $p['meta'];
			$old = (string) ( $m['hh_p_price_table'] ?? '' );
			if ( $old && false === strpos( $old, 'S3 Broadway' ) ) {
				$new = preg_replace( '/\nGhi chú \|/u', "\n$s3\nGhi chú |", $old, 1 );
				$new = str_replace( 'Giỏ hàng 10/2026', 'Giỏ hàng 11/2026', $new );
				$p['fix_meta']['hh_p_price_table']   = (array) ( $p['fix_meta']['hh_p_price_table'] ?? array() );
				$p['fix_meta']['hh_p_price_table'][] = $old;
				$p['meta']['hh_p_price_table']       = $new;
			}
			$add = array(
				'hh_p_image_links'     => implode( "\n", $img ),
				'hh_p_handover'        => 'Quý I/2027 (dự kiến)',
				'hh_p_ownership'       => 'Sở hữu lâu dài (khách hàng Việt Nam); 50 năm (khách hàng nước ngoài, trong hạn mức được phép)',
				'hh_p_offer_title'     => 'Đặt cọc 100 triệu – thưởng nóng đến 66 triệu/căn',
				'hh_p_policy'          => "Đặt cọc 100 triệu đồng/căn\nThưởng nóng 44 triệu đồng/căn với căn 2PN, 2PN+1 (đã gồm VAT)\nThưởng nóng 66 triệu đồng/căn với căn 3PN (đã gồm VAT)\nĐiều kiện thưởng nóng: ký hợp đồng mua bán và thanh toán đợt 1\nCó các phương án thanh toán: vay 0% lãi, thanh toán sớm 95% / 100% có chiết khấu – hỏi Hoàng Hiệp phiếu tính giá từng căn",
				'hh_p_handover_std'    => 'Bàn giao liền tường theo danh mục vật liệu của chủ đầu tư: cửa chính chống cháy, khóa từ kỹ thuật số (thẻ, mã số, vân tay, chìa cơ), chuông hình; phòng khách, phòng ngủ, bếp sàn BTCT cán nền, tường trát phẳng – khách hàng tự hoàn thiện sàn, trần, chân tường, đèn và cửa thông phòng; ban công, lô gia lát gạch chống trơn, lan can kính cường lực, cửa nhôm kính Xingfa hoặc tương đương; vệ sinh ốp lát Viglacera/Thạch Bàn, trần thạch cao chống ẩm, thiết bị Toto/American Standard, vách tắm kính, tủ lavabo, bình nóng lạnh; bếp có đầu chờ hút mùi (tủ bếp, thiết bị bếp khách tự lắp); điều hòa khách tự lắp (hệ Multi, vị trí cục nóng theo thiết kế); điện, internet bàn giao đến tủ tổng căn hộ.',
				'hh_p_tour_360'        => 'https://capitalsquare.vn/360/',
				'hh_p_tour_360_poster' => 'plugin:img/capital-square/capital-square-phoi-canh-dem-ven-song-han.jpg',
			);
			foreach ( $add as $k => $v ) {
				if ( '' === (string) ( $m[ $k ] ?? '' ) ) {
					$p['meta'][ $k ] = $v;
				}
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	97
);
