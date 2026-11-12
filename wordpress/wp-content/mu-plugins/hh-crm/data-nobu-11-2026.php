<?php
/**
 * Nobu Residences Đà Nẵng – cập nhật 10/11/2026 từ trang chính thức nobudanang.vn (anh Hiệp yêu cầu):
 * - 24 ảnh: phối cảnh tháp, nội thất, tiện ích (ảnh chủ đầu tư) và ảnh công trường tháng 8, 10/2026 (logo dự án/chủ đầu tư, không logo phân phối).
 * - Tiến độ tháng 10/2026 (đăng 09/11/2026): kết cấu đến tầng 22, mặt dựng kính tầng 7 – 13, cơ điện & PCCC tầng 17.
 * - Sửa số liệu: 186 là chiều cao (m) chứ không phải số phòng khách sạn – Nobu Hotels công bố khoảng 200 phòng, gồm 18 suite.
 * - Địa chỉ theo trang chính thức: Số 01 Võ Văn Kiệt, phường An Hải.
 * - 12/11/2026: phân bổ chức năng 43 tầng (theo tài liệu giới thiệu dự án anh Hiệp gửi) – sơ đồ tự vẽ (bai-viet/nobu-phan-bo-tang-anh.py),
 *   không dùng ảnh gốc vì có logo đơn vị phân phối; thêm mục nội dung + vị trí tầng cho tiện ích.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/nobu-da-nang/nobu-da-nang-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-thap-ven-bien-my-khe', 'Phối cảnh tháp Nobu Residences Đà Nẵng bên biển Mỹ Khê (ảnh chủ đầu tư)', 'đại diện' ),
			$im( 'phoi-canh-thap-nhin-tu-tren-cao', 'Tháp Nobu Đà Nẵng 43 tầng nhìn từ trên cao về sông Hàn (phối cảnh)', 'thư viện' ),
			$im( 'ban-cong-kep-view-bien', 'Ban công kép nhìn ra biển Mỹ Khê lúc hoàng hôn (phối cảnh)', 'thư viện' ),
			$im( 'khoi-de-sanh-don', 'Khối đế và sảnh đón Nobu Đà Nẵng trên đường Võ Nguyên Giáp (phối cảnh)', 'thư viện' ),
			$im( 'phong-ngu-view-phao-hoa', 'Phòng ngủ nhìn ra sông Hàn, pháo hoa (phối cảnh nội thất)', 'thư viện' ),
			$im( 'phong-khach-tran-cao-3m', 'Phòng khách trần cao gần 3 m nhìn biển (phối cảnh nội thất)', 'thư viện' ),
			$im( 'noi-that-japandi', 'Nội thất phong cách Japandi (phối cảnh)', 'thư viện' ),
			$im( 'can-dual-key', 'Không gian căn hộ Dual-Key (phối cảnh nội thất)', 'thư viện' ),
			$im( 'ho-boi-nuoc-am-tren-cao', 'Hồ bơi nước ấm trên cao (phối cảnh)', 'tiện ích', 'Hồ bơi nước ấm' ),
			$im( 'bar-tren-khong-tsukimidai', 'Nhà hàng bar trên không Tsukimidai (phối cảnh)', 'tiện ích', 'Bar trên không' ),
			$im( 'nha-hang-nobu', 'Nhà hàng Nobu (phối cảnh)', 'tiện ích', 'Nhà hàng Nobu' ),
			$im( 'nha-hang-taste-of-asia', 'Nhà hàng Taste of Asia (phối cảnh)', 'tiện ích', 'Nhà hàng' ),
			$im( 'quay-bar-ben-ho-boi', 'Quầy bar bên hồ bơi (phối cảnh)', 'tiện ích', 'Quầy bar' ),
			$im( 'beach-club', 'Beach club bên biển (phối cảnh)', 'tiện ích', 'Beach club' ),
			$im( 'sanh-hoi-nghi', 'Sảnh hội nghị (phối cảnh)', 'tiện ích', 'Sảnh hội nghị' ),
			$im( 'phong-tap-tren-khong', 'Phòng tập thể thao trên không (phối cảnh)', 'tiện ích', 'Phòng tập' ),
			$im( 'khu-vui-choi-tre-em', 'Khu vui chơi trẻ em (phối cảnh)', 'tiện ích', 'Khu trẻ em' ),
			$im( 'tien-do-10-2026-toan-canh', 'Công trường Nobu Đà Nẵng tháng 10/2026 – kết cấu đến tầng 22 (ảnh thực tế của chủ đầu tư)', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-do-san-tang-22', 'Thi công cốp pha, cốt thép, đổ bê tông sàn tầng 22 – tháng 10/2026', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-lap-cua-kinh', 'Lắp khung cửa kính lùa, lan can kính tầng 7 – 12 – tháng 10/2026', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-co-dien-tang-14-16', 'Thi công cơ điện MEP, PCCC tầng 14 – 16 – tháng 10/2026', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-xay-to-khoi-de', 'Xây tô, sơn nước tầng 2 – 6 khối đế – tháng 10/2026', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-tang-ham', 'Xây tô, sơn nước và cơ điện tầng hầm B1, B2 – tháng 10/2026', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'phan-bo-chuc-nang-tang', 'Sơ đồ phân bổ chức năng 43 tầng Nobu Residences Đà Nẵng: khách sạn tầng 7 – 16, căn hộ tầng 19 – 36, Sky Villa tầng 38 – 40, penthouse tầng 41', 'mặt bằng', 'Phân bổ chức năng tầng' ),
			$im( 'tien-do-8-2026-cong-truong', 'Công trường Nobu Đà Nẵng tháng 8/2026 (ảnh thực tế của chủ đầu tư)', 'tiến độ', 'Thực tế 8/2026' ),
		);
		$sw = array(
			'264 căn hộ hàng hiệu Nobu và 186 phòng khách sạn' => '264 căn hộ du lịch hàng hiệu Nobu và khách sạn Nobu khoảng 200 phòng',
			'264 căn hộ hàng hiệu và 186 phòng khách sạn'      => '264 căn hộ du lịch hàng hiệu và khách sạn Nobu khoảng 200 phòng (gồm 18 suite)',
			'Khách sạn Nobu 186 phòng'                        => 'Khách sạn Nobu khoảng 200 phòng (gồm 18 suite)',
			'264 căn hộ và 186 phòng khách sạn'               => '264 căn hộ du lịch hàng hiệu và khách sạn Nobu khoảng 200 phòng',
		);
		$fix = static fn( $s ) => str_replace( array_keys( $sw ), array_values( $sw ), (string) $s );
		// 12/11/2026: vị trí tầng của tiện ích, khách sạn.
		$sw2  = array(
			"Khách sạn Nobu khoảng 200 phòng (gồm 18 suite)\n" => "Khách sạn Nobu khoảng 200 phòng, gồm 18 suite (tầng 7 – 16)\n",
			'Spa, phòng gym'                                  => "Trung tâm spa & chăm sóc sức khỏe (tầng 3 – 4), phòng gym\nSảnh hội nghị (tầng 5)\nNhà hàng Taste of Asia (tầng 6)\nNhà hàng – bar trên không Tsukimidai (tầng 43)",
		);
		$fix2 = static fn( $s ) => str_replace( array_keys( $sw2 ), array_values( $sw2 ), (string) $s );
		$tang = '<h2>Phân bổ chức năng các tầng Nobu Residences Đà Nẵng</h2>
<p>Tháp Nobu Đà Nẵng cao 43 tầng được chia thành các khối rõ ràng: khối đế dịch vụ (tầng 1 – 6), khách sạn Nobu (tầng 7 – 16), căn hộ thương hiệu Nobu (tầng 19 – 36), Sky Villa và penthouse (tầng 38 – 41), trên cùng là nhà hàng Nobu và bar trên không. Tầng 17 và 37 là tầng lánh nạn, tầng 18 là tầng tiện ích.</p>
<table>
<tr><th>Tầng</th><th>Chức năng</th></tr>
<tr><td>43</td><td>Nhà hàng – bar trên không Tsukimidai</td></tr>
<tr><td>42</td><td>Nhà hàng Nobu</td></tr>
<tr><td>41</td><td>Penthouse</td></tr>
<tr><td>38 – 40</td><td>Biệt thự trên không (Sky Villa)</td></tr>
<tr><td>37</td><td>Tầng lánh nạn</td></tr>
<tr><td>19 – 36</td><td>Căn hộ thương hiệu Nobu</td></tr>
<tr><td>18</td><td>Tầng tiện ích (hồ bơi nước ấm)</td></tr>
<tr><td>17</td><td>Tầng lánh nạn</td></tr>
<tr><td>7 – 16</td><td>Khách sạn Nobu</td></tr>
<tr><td>6</td><td>Nhà hàng Taste of Asia</td></tr>
<tr><td>5</td><td>Sảnh hội nghị</td></tr>
<tr><td>3 – 4</td><td>Trung tâm spa &amp; chăm sóc sức khỏe</td></tr>
<tr><td>2</td><td>Văn phòng</td></tr>
<tr><td>1</td><td>Sảnh đón</td></tr>
</table>
<p>Căn hộ bắt đầu từ tầng 19, nằm trên khối khách sạn và tầng tiện ích nên tầm nhìn ra biển Mỹ Khê, sông Hàn thoáng hơn. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận mặt bằng từng tầng và danh sách căn còn trống.</p>
';
		foreach ( $projects as $i => $p ) {
			if ( 'nobu-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( array( 'hh_p_units', 'hh_p_amenities_in', 'hh_p_highlights' ) as $k ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				$v1  = $fix( $cur );
				$new = $fix2( $v1 );
				if ( $new !== $cur ) {
					$p['meta'][ $k ]       = $new;
					$p['fix_meta'][ $k ]   = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array_unique( array( $cur, $v1 ) ) );
				}
			}
			$upd = array(
				'hh_p_address'  => '01 Võ Văn Kiệt (góc Võ Nguyên Giáp), phường An Hải (Phước Mỹ, Sơn Trà cũ), Đà Nẵng',
				'hh_p_progress' => "Quý 2/2024 | Khởi công, Newtecons thi công\n01 – 02/2026 | Hoàn thành sàn chuyển L6M, chuyển sang thi công tầng điển hình\n05/2026 | Đổ bê tông sàn tầng 8, lắp hệ leo tầng 9\n06/2026 | Thi công hệ bao che trượt tầng 10; xây tô, cơ điện từ tầng hầm đến tầng 5\n10/2026 | Kết cấu đến tầng 22; lắp mặt dựng, kính tầng 7 – 13; cơ điện & PCCC tới tầng 17 (chủ đầu tư cập nhật 09/11/2026)\n2027 | Dự kiến hoàn thiện, bàn giao và vận hành",
			);
			foreach ( $upd as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( '' !== $cur && $cur !== $v ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) );
				}
				$p['meta'][ $k ] = $v;
			}
			$cur_img = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['meta']['hh_p_image_links'] = trim( $cur_img . "\n" . implode( "\n", $imgs ) );
			// Bản 10/11 (chưa có sơ đồ phân bổ tầng) đã nhập lên web → cho phép thay.
			$imgs_10 = array_values( array_filter( $imgs, static fn( $l ) => false === strpos( $l, 'phan-bo-chuc-nang-tang' ) ) );
			$p['fix_meta']['hh_p_image_links'] = array_merge(
				(array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ),
				array_filter( array( $cur_img, trim( $cur_img . "\n" . implode( "\n", $imgs_10 ) ) ) )
			);
			$old_ex = (string) ( $p['excerpt'] ?? '' );
			if ( $fix( $old_ex ) !== $old_ex ) {
				$p['excerpt']     = $fix( $old_ex );
				$p['fix_excerpt'] = array_merge( (array) ( $p['fix_excerpt'] ?? array() ), array( $old_ex ) );
			}
			$old_ct = (string) ( $p['content'] ?? '' );
			$ct1    = $fix( $old_ct );
			$ct2    = false === strpos( $ct1, 'Phân bổ chức năng các tầng' ) ? str_replace( '<h2>Pháp lý &amp; tiến độ</h2>', $tang . '<h2>Pháp lý &amp; tiến độ</h2>', $ct1 ) : $ct1;
			if ( $ct2 !== $old_ct ) {
				$p['content']     = $ct2;
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array_unique( array( $old_ct, $ct1 ) ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	25
);
