<?php
/**
 * The Filmore Đà Nẵng – tiêu chuẩn vật liệu bàn giao thực tế (bảng của chủ đầu tư ngày 25/02/2025)
 * và ảnh brochure "High tech + High touch" (anh Hiệp gửi 18/11/2026).
 * Chạy sau data-filmore-11-2026.php (ưu tiên 40). Chỉ thay khi trên web còn giá trị cũ.
 */

defined( 'ABSPATH' ) || exit;

/** Mục "Tiêu chuẩn bàn giao" trong bài giới thiệu The Filmore. */
function hh_filmore_ban_giao_html() {
	return <<<'HTML'

<h2>Tiêu chuẩn bàn giao căn hộ The Filmore Đà Nẵng</h2>
<p>Theo bảng tiêu chuẩn bàn giao thực tế của chủ đầu tư (cập nhật 25/02/2025), căn 1PN, 2PN và căn ghép đều bàn giao hoàn thiện, kèm máy lạnh, thiết bị bếp, thiết bị vệ sinh và hệ thống nhà thông minh. Khách chỉ cần bổ sung nội thất rời (sofa, giường, bàn ăn…) là vào ở hoặc cho thuê.</p>
<table>
<thead><tr><th>Khu vực</th><th>Hạng mục bàn giao</th><th>Thương hiệu</th></tr></thead>
<tbody>
<tr><td>Phòng khách, phòng ăn</td><td>Sàn gạch porcelain 600×600; tường trát sơn hoàn thiện dễ lau chùi; trần thạch cao</td><td>Vietceramic, Jotun, Gyproc Vĩnh Tường</td></tr>
<tr><td>Cửa vào căn hộ</td><td>Cửa gỗ chống cháy, khóa điện tử</td><td>An Cường, Yale</td></tr>
<tr><td>Cửa sổ, ban công</td><td>Kính hộp Low-E khung nhôm; lan can kính dán an toàn; sàn ban công chống thấm, lát gạch porcelain</td><td>Sinh Nam, Vietceramic</td></tr>
<tr><td>Máy lạnh</td><td>Máy lạnh âm trần 1 hướng thổi dòng WindFree, phòng khách và từng phòng ngủ</td><td>Samsung</td></tr>
<tr><td>Điện, nhà thông minh</td><td>Tủ điện, công tắc, ổ cắm; hệ thống nhà thông minh; ổ mạng internet / IPTV; đèn âm trần; chuông cửa màn hình</td><td>Schneider, Hikvision</td></tr>
<tr><td>Phòng ngủ</td><td>Sàn gỗ AGT nhập khẩu Thổ Nhĩ Kỳ; cửa gỗ; tủ áo gỗ hoàn thiện Melamine</td><td>AGT, An Cường, Häfele, Mỹ Khang</td></tr>
<tr><td>Phòng tắm</td><td>Gạch porcelain 600×600 nhập khẩu Ấn Độ; trần thạch cao kháng ẩm; chậu rửa, sen tắm (phòng tắm master có bát sen âm trần), bồn cầu (master treo tường); tủ gương, tủ vanity mặt đá thạch anh; quạt hút; máy nước nóng</td><td>Kohler, Mỹ Khang, Kruger, Ferroli</td></tr>
<tr><td>Bếp</td><td>Tủ bếp gỗ hoàn thiện Melamine, mặt đá thạch anh; kính ốp tường cường lực; chậu rửa inox kèm vòi; bếp điện từ và máy hút mùi</td><td>Mỹ Khang, Häfele, Bosch</td></tr>
</tbody>
</table>
<p>Căn penthouse loại 2 bàn giao hoàn thiện cơ bản theo bảng riêng của chủ đầu tư. Màu sắc, mẫu mã thiết bị thực tế có thể khác hình minh họa; Hoàng Hiệp gửi bảng chi tiết từng loại căn (1PN, 2PN, căn ghép 2+1, 2+2, penthouse) khi anh chị cần – liên hệ 0904 567 009.</p>
HTML;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'the-filmore-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old = (array) ( $p['meta'] ?? array() );
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$upd = array();

			// Tiêu chuẩn bàn giao (một dòng tóm tắt; bảng chi tiết nằm trong bài giới thiệu).
			$upd['hh_p_handover_std'] = 'Hoàn thiện: sàn gỗ AGT phòng ngủ, máy lạnh âm trần Samsung WindFree, bếp từ và hút mùi Bosch, thiết bị vệ sinh Kohler, nhà thông minh Schneider, khóa điện tử Yale, kính hộp Low-E';

			// Ảnh brochure "High tech + High touch" của chủ đầu tư (không trùng 21 ảnh bản 2.20.315).
			$add = array(
				'plugin:img/the-filmore/the-filmore-ban-do-vi-tri-tien-ich-xung-quanh.jpg | Bản đồ vị trí The Filmore Đà Nẵng và tiện ích xung quanh: cầu Rồng, sông Hàn, sân bay, biển Mỹ Khê (chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-toan-canh-ket-noi-song-han-son-tra-my-khe.jpg | Toàn cảnh kết nối của The Filmore: chợ Hàn, cầu Rồng, bán đảo Sơn Trà, quảng trường Bạch Đằng, biển Mỹ Khê (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-ven-song-han-cau-rong-ve-dem.jpg | The Filmore Đà Nẵng bên sông Hàn, nhìn về cầu Rồng về đêm (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-toa-thap-25-tang-ve-dem.jpg | Tòa tháp 25 tầng The Filmore về đêm (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-thap-can-ho-ban-cong-view-thanh-pho.jpg | Ban công căn hộ The Filmore nhìn toàn thành phố Đà Nẵng (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-phong-ngu-master.jpg | Phòng ngủ master căn hộ The Filmore, sàn gỗ, kính lớn nhìn sông Hàn (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-phong-tam-master.jpg | Phòng tắm master căn hộ The Filmore (phối cảnh chủ đầu tư) | thư viện',
				'plugin:img/the-filmore/the-filmore-sanh-vao-toa-nha.jpg | Sảnh vào tòa nhà The Filmore Đà Nẵng (phối cảnh chủ đầu tư) | tiện ích',
			);
			$links = trim( (string) ( $old['hh_p_image_links'] ?? '' ) );
			if ( '' !== $links && false === strpos( $links, 'the-filmore-uu-dai-chiet-khau' ) ) {
				$fix['hh_p_image_links'][] = $links . "\n" . implode( "\n", $add ); // Bản 2.20.317.
				// Ảnh ưu đãi của chủ đầu tư (anh Hiệp gửi 18/11/2026).
				$add[] = 'plugin:img/the-filmore/the-filmore-uu-dai-chiet-khau-6-mien-phi-quan-ly.jpg | Ưu đãi The Filmore Đà Nẵng: chiết khấu 6% khi thanh toán nhanh, miễn phí quản lý 1 năm (ảnh chủ đầu tư) | thư viện';
				$upd['hh_p_image_links'] = $links . "\n" . implode( "\n", $add );
			}

			// Khung ưu đãi: con số nổi bật theo chính sách bán hàng từ 01/11/2026.
			$upd['hh_p_offer_stats'] = "6% | Chiết khấu khi thanh toán nhanh\n1 năm | Miễn phí quản lý\n8 tháng | Hỗ trợ lãi suất khi vay VPBank (tối đa 10%/năm)\n100 triệu | Đặt cọc giữ căn";
			$upd['hh_p_offer_start'] = '01/11/2026';

			// Hỏi đáp: thêm câu về bàn giao.
			$faq = trim( (string) ( $old['hh_p_faq'] ?? '' ) );
			if ( '' !== $faq && false === strpos( $faq, 'bàn giao những gì' ) ) {
				$upd['hh_p_faq'] = $faq . "\n" . 'Căn hộ The Filmore bàn giao những gì? | Bàn giao hoàn thiện: sàn gỗ AGT phòng ngủ, gạch porcelain phòng khách, máy lạnh âm trần Samsung WindFree, bếp từ và máy hút mùi Bosch, tủ bếp mặt đá thạch anh, thiết bị vệ sinh Kohler, máy nước nóng, tủ áo, nhà thông minh Schneider, khóa điện tử Yale, kính hộp Low-E (bảng chủ đầu tư 25/02/2025). Penthouse loại 2 bàn giao hoàn thiện cơ bản.';
			}

			foreach ( $upd as $k => $v ) {
				if ( isset( $old[ $k ] ) && '' !== (string) $old[ $k ] ) {
					$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( $old[ $k ] ) );
				}
			}
			$fix['hh_p_handover_std'] = array_merge( (array) ( $fix['hh_p_handover_std'] ?? array() ), array( 'Hoàn thiện nội thất cao cấp' ) );

			// Bài giới thiệu: thêm mục tiêu chuẩn bàn giao.
			$c0 = (string) ( $p['content'] ?? '' );
			if ( '' !== $c0 && false === strpos( $c0, 'Tiêu chuẩn bàn giao căn hộ The Filmore' ) ) {
				$projects[ $i ]['content']     = $c0 . hh_filmore_ban_giao_html();
				$projects[ $i ]['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}

			$projects[ $i ]['meta']     = array_merge( $old, $upd );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	40
);
