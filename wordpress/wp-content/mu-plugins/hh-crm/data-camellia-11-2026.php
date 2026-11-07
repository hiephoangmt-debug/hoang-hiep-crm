<?php
/**
 * The Camellia Sơn Trà – cập nhật 11/2026 từ bộ tài liệu dự án anh Hiệp gửi (Drive MBLand – WeLand):
 * CSBH hiệu lực 07/10/2026 (+ chương trình thanh toán sớm 95%), giá bán định hướng theo phương án thanh toán,
 * danh mục vật liệu bàn giao, pháp lý (công văn Sở Xây dựng 13/7/2026), 44 ảnh: phối cảnh không logo, tiện ích,
 * flycam 8/2026, layout căn 2D/3D. Không đăng mã căn, biểu mẫu, quy trình nội bộ. Thay ô cũ nếu web chưa sửa tay.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/the-camellia/the-camellia-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-toan-canh-ban-ngay', 'Phối cảnh The Camellia Sơn Trà ban ngày, chân bán đảo Sơn Trà nhìn ra biển', 'thư viện' ),
			$im( 'phoi-canh-ben-bai-bien-hoang-hon', 'The Camellia Sơn Trà bên bãi biển lúc hoàng hôn', 'thư viện' ),
			$im( 'phoi-canh-mat-tien-ngay', 'Phối cảnh mặt tiền tòa tháp The Camellia', 'thư viện' ),
			$im( 'phoi-canh-mat-tien-le-van-luong', 'Phối cảnh tòa tháp góc Lê Văn Lương – Lê Đức Thọ', 'thư viện' ),
			$im( 'phoi-canh-khoi-de-thuong-mai', 'Khối đế thương mại, sảnh vào tòa tháp', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-goc-nhin-thap', 'Tòa tháp The Camellia nhìn từ dưới lên', 'thư viện' ),
			$im( 'phoi-canh-vinh-da-nang-tu-tren-cao', 'The Camellia nhìn từ trên cao về vịnh và trung tâm Đà Nẵng', 'thư viện' ),
			$im( 'phoi-canh-chan-ban-dao-son-tra', 'The Camellia dưới chân bán đảo Sơn Trà, hướng biển', 'thư viện' ),
			$im( 'phoi-canh-binh-minh', 'Phối cảnh The Camellia lúc bình minh trên biển', 'thư viện' ),
			$im( 'phoi-canh-bai-bien-man-thai', 'Dải bãi biển gần dự án và tòa tháp The Camellia', 'thư viện' ),
			$im( 'phoi-canh-huong-bien-hoang-hon', 'Tòa tháp nhìn ra biển lúc hoàng hôn', 'thư viện' ),
			$im( 'phoi-canh-hoang-hon-ban-dao-2', 'The Camellia và bán đảo Sơn Trà lúc hoàng hôn', 'thư viện' ),
			$im( 'phoi-canh-vi-tri-tu-tren-cao', 'Vị trí dự án nhìn từ trên cao, gần biển', 'tổng thể' ),
			$im( 'tien-ich-vuon-tren-cao-nhin-bien', 'Vườn trên cao nhìn ra biển', 'tiện ích', 'Vườn trên cao' ),
			$im( 'tien-ich-ho-boi-trong-nha', 'Hồ bơi trong nhà', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-ho-boi-trong-nha-2', 'Hồ bơi trong nhà, khu thư giãn', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-ho-boi-view-bien', 'Hồ bơi nhìn ra biển', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-mat-bang-ho-boi', 'Mặt bằng tầng hồ bơi và tiện ích', 'tiện ích', 'Hồ bơi' ),
			$im( 'tien-ich-phong-gym', 'Phòng gym', 'tiện ích', 'Gym' ),
			$im( 'tien-ich-phong-yoga', 'Phòng yoga nhìn ra biển', 'tiện ích', 'Yoga' ),
			$im( 'tien-ich-phong-yoga-2', 'Phòng yoga', 'tiện ích', 'Yoga' ),
			$im( 'tien-ich-sanh-can-ho', 'Sảnh căn hộ', 'tiện ích', 'Sảnh' ),
			$im( 'tien-ich-sanh-can-ho-2', 'Sảnh căn hộ', 'tiện ích', 'Sảnh' ),
			$im( 'tien-ich-sanh-le-tan', 'Sảnh lễ tân', 'tiện ích', 'Sảnh' ),
			$im( 'tien-ich-sanh-le-tan-2', 'Sảnh lễ tân', 'tiện ích', 'Sảnh' ),
			$im( 'tien-ich-khu-ve-sinh-chung', 'Khu vệ sinh khu tiện ích', 'tiện ích' ),
			$im( 'layout-studio', 'Layout căn studio 27,8 – 31,4 m²', 'layout', 'Studio' ),
			$im( 'layout-studio-2', 'Layout căn studio', 'layout', 'Studio' ),
			$im( 'layout-3d-1-5pn', 'Layout 3D căn 1PN+1 (1,5PN) 47 – 47,3 m²', 'layout', '1PN+1' ),
			$im( 'layout-2pn-noi-khu', 'Layout căn 2PN view nội khu 57,4 – 72,1 m²', 'layout', '2PN' ),
			$im( 'layout-3d-2pn-noi-khu', 'Layout 3D căn 2PN view nội khu', 'layout', '2PN' ),
			$im( 'layout-2pn-mat-duong', 'Layout căn 2PN mặt Lê Đức Thọ, Lê Văn Lương 65,1 – 69,9 m²', 'layout', '2PN' ),
			$im( 'layout-2pn-mat-duong-2', 'Layout căn 2PN mặt đường', 'layout', '2PN' ),
			$im( 'layout-2pn-goc-view-nui-bien', 'Layout căn 2PN góc view núi Sơn Trà và biển 70,1 – 72,7 m²', 'layout', '2PN góc' ),
			$im( 'layout-3d-2pn-goc', 'Layout 3D căn 2PN góc', 'layout', '2PN góc' ),
			$im( 'layout-3pn-goc-view-bien', 'Layout căn 3PN góc view biển 84,2 – 103,6 m²', 'layout', '3PN' ),
			$im( 'layout-3pn-goc-view-bien-2', 'Layout căn 3PN góc view biển', 'layout', '3PN' ),
			$im( 'layout-3d-3pn-goc', 'Layout 3D căn 3PN góc', 'layout', '3PN' ),
			$im( 'layout-3d-3pn-goc-2', 'Layout 3D căn 3PN góc', 'layout', '3PN' ),
			$im( 'layout-3d-1', 'Layout 3D căn hộ', 'layout' ),
			$im( 'layout-3d-2', 'Layout 3D căn hộ', 'layout' ),
			$im( 'tien-do-8-2026-flycam-tu-tren-cao', 'Tiến độ The Camellia tháng 8/2026 – flycam từ trên cao', 'tiến độ', 'Thực tế 8/2026' ),
			$im( 'tien-do-8-2026-flycam-huong-bien', 'Tiến độ The Camellia tháng 8/2026 – flycam nhìn ra biển', 'tiến độ', 'Thực tế 8/2026' ),
			$im( 'tien-do-8-2026-flycam-huong-nui', 'Khu vực dự án nhìn về bán đảo Sơn Trà, tháng 8/2026', 'tiến độ', 'Thực tế 8/2026' ),
		);
		$new = array(
			'hh_p_price_table' => "Studio | 27,8 – 31,4 m² | 1,98 – 2,64 tỷ | Thanh toán sớm 95%: 1,72 – 2,30 tỷ\nCăn 1PN+1 (1,5PN) | 47 – 47,3 m² | 3,28 – 4,11 tỷ | Thanh toán sớm 95%: 2,85 – 3,58 tỷ\nCăn 2PN view nội khu | 57,4 – 72,1 m² | 3,90 – 4,99 tỷ | Thanh toán sớm 95%: 3,39 – 4,34 tỷ\nCăn 2PN mặt Lê Đức Thọ, Lê Văn Lương | 65,1 – 69,9 m² | 4,49 – 5,37 tỷ | Thanh toán sớm 95%: 3,91 – 4,67 tỷ\nCăn 2PN góc view núi Sơn Trà + biển | 70,1 – 72,7 m² | 4,63 – 5,99 tỷ | Thanh toán sớm 95%: 4,03 – 5,21 tỷ\nCăn 3PN góc view biển | 84,2 – 103,6 m² | 7,50 – 8,99 tỷ | Thanh toán sớm 95%: 6,53 – 7,82 tỷ\nGhi chú | – | Giá định hướng toàn dự án (mọi tầng), phương án vay hỗ trợ lãi suất | Gồm VAT, KPBT; phương án thanh toán chuẩn / thảnh thơi thấp hơn khoảng 2 – 4%",
			'hh_p_policy'      => "CSBH hiệu lực từ 07/10/2026:\n• Đặt cọc 100 triệu đồng/căn\n• Thanh toán sớm 95%: chiết khấu 13% (không cộng các phương án khác)\n• Thanh toán sớm 70%: chiết khấu 10%\n• Thanh toán thông thường (12 đợt, phần lớn mỗi đợt 5%/2 tháng): chiết khấu 4%\n• Thanh toán giãn (đợt 5 tháng/lần): chiết khấu 2%\n• Vay ngân hàng: hỗ trợ lãi suất 0% khoản vay đến 70% trong 18 tháng (không muộn hơn ngày bàn giao), miễn phí trả nợ trước hạn trong thời gian hỗ trợ; ngân hàng SHB, MB\n• Tặng gói dịch vụ quản lý 1 năm\n• Member Get Member: khách mới tặng 1 chỉ vàng (14,5 triệu) và chiết khấu 1%; người giới thiệu nhận 1 chỉ vàng\n• Nhóm người thân mua chung: chiết khấu 2%/căn khi mua 2 căn, 3%/căn từ 3 căn (không áp dụng studio; không cộng với Member Get Member)",
			'hh_p_payment'     => "Đặt cọc | 100 triệu/căn | Khi ký thỏa thuận đặt cọc\nĐợt 1 | 15% | Ký HĐMB, trong 10 ngày từ ngày cọc\nĐợt 2 | 15% | Trong 1 tháng từ ngày ký HĐMB\nĐợt 3 – 10 | 5%/đợt | Mỗi 2 tháng (phương án thông thường, CK 4%)\nNhận nhà | 25% + KPBT | Dự kiến quý I/2028\nNhận sổ | 5% | Khi làm thủ tục cấp giấy chứng nhận",
			'hh_p_loan'        => 'Vay đến 70% giá trị căn hộ (gồm VAT) tại ngân hàng chủ đầu tư chỉ định (SHB, MB); hỗ trợ lãi suất 0% trong 18 tháng từ lần giải ngân đầu (không muộn hơn ngày thông báo bàn giao); thời hạn vay đến 35 năm tùy ngân hàng; khách thanh toán tối thiểu 25% trước khi ngân hàng giải ngân.',
			'hh_p_legal'       => "Giấy chứng nhận quyền sử dụng đất do UBND TP Đà Nẵng cấp\nCông văn Sở Xây dựng Đà Nẵng ngày 13/7/2026: đủ điều kiện bán nhà ở hình thành trong tương lai\nCăn hộ sở hữu lâu dài",
			'hh_p_handover_std' => 'Bàn giao hoàn thiện liền tường (căn 1PN+1, 2PN, 3PN): cửa chính gỗ công nghiệp chống cháy hoặc thép vân gỗ, khóa điện tử ADEL/KAADAS/Samsung; sàn phòng khách, phòng ngủ gỗ công nghiệp hoặc SPC vân gỗ; trần thạch cao, sơn Dulux/Jotun/Toa; cửa sổ nhôm Xingfa; điều hòa Daikin/Mitsubishi/Panasonic/LG/Samsung (âm trần phòng khách); đèn chiếu sáng cơ bản, đầu ra internet, truyền hình; bếp: tủ trên dưới MDF chống ẩm An Cường, bếp từ, hút mùi, bồn rửa Hafele/Teka/Giovani; vệ sinh: gạch Prime/Viglacera, thiết bị Bravat/Grohe/Kohler, tủ lavabo chống nước, cabin kính cường lực, bình nóng lạnh Picenza/Rossi/Ferroli. Căn studio có danh mục riêng (hỏi Hoàng Hiệp).',
		);
		foreach ( $projects as $i => $p ) {
			if ( 'the-camellia-son-tra' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( '' !== $cur && $cur !== $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				$p['meta'][ $k ] = $v;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
			$p['fix_meta']['hh_p_image_links'][] = $cur;
			$p['meta']['hh_p_image_links']       = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	98
);
