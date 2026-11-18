<?php
/**
 * Masteri Rivera Danang – bổ sung từ bộ tài liệu chủ đầu tư anh Hiệp gửi 18/11/2026
 * (tên pháp lý, pháp nhân chủ đầu tư, tháp A/B, sông Cẩm Lệ, căn Dual Key ~101 m², phương thức thanh toán).
 * Không ghi giá mới (chính sách trong tài liệu là 2025, đã hết hạn).
 * Chỉ thay khi trên web còn giá trị cũ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'masteri-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old = (array) ( $p['meta'] ?? array() );
			$fix = (array) ( $p['fix_meta'] ?? array() );
			$upd = array(
				'hh_p_developer'     => 'Masterise Homes (pháp nhân chủ đầu tư: Công ty CP Phát triển Nhà Tuyên Sơn)',
				'hh_p_type'          => 'Căn hộ cao cấp sở hữu lâu dài, Dual Key, khối đế thương mại (tên pháp lý: Dự án khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn)',
				'hh_p_blocks'        => '2 tòa tháp (tháp A và tháp B)',
				'hh_p_highlights'    => "Dự án căn hộ đầu tiên của Masterise Homes tại Đà Nẵng\n2 tháp A – B cao 39 tầng, gần 1.200 căn, nhìn ra sông Cẩm Lệ khu Hòa Cường Nam\nCạnh Cung thể thao Tiên Sơn, 3 mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch\n31 tiện ích nội khu từ tầng 1 đến tầng 4\nĐã cất nóc tháng 12/2025, tổng thầu Central\nSở hữu lâu dài cho người Việt Nam",
				'hh_p_design_desc'   => 'Hai tháp A và B cao 39 tầng trên khối đế thương mại tầng 1 – 3 (shophouse, trung tâm thương mại khoảng 2.500 m²), tầng 4 là hồ bơi resort, vườn dạo bộ và sân chơi trẻ em; 2 tầng hầm đỗ xe. Cơ cấu căn: 1PN+, 2PN, 2PN+, 3PN và Dual Key (căn Dual Key khoảng 101 m² thông thủy, 2 cửa vào riêng).',
				'hh_p_location_desc' => 'Dự án nằm trên đường Quy Mỹ, khu Hòa Cường Nam (Hải Châu), nhìn ra sông Cẩm Lệ, cạnh Cung thể thao Tiên Sơn; gần Lotte Mart, Asia Park (Sun World Đà Nẵng Wonders), từ đây đi cầu Rồng và trung tâm Hải Châu khoảng 10 phút.',
				'hh_p_connections'   => "Vài phút | Sông Cẩm Lệ, Cung thể thao Tiên Sơn\nVài phút | Lotte Mart, Asia Park, đường 2/9\nKhoảng 10 phút | Cầu Rồng, trung tâm Hải Châu\nKhoảng 10 phút | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_out' => "Lotte Mart, Asia Park\nSông Cẩm Lệ, Cung thể thao Tiên Sơn\nTrường học, bệnh viện khu Hải Châu\nCầu Rồng, trung tâm hành chính",
				'hh_p_policy'        => "Phương thức thanh toán theo chính sách của chủ đầu tư: thanh toán theo tiến độ chuẩn, thanh toán sớm (chiết khấu cao hơn) hoặc kết hợp vay ngân hàng có hỗ trợ lãi suất\nThường có ưu đãi thêm cho khách hàng là người Đà Nẵng\nĐặt cọc, chiết khấu và tiến độ cụ thể thay đổi theo từng đợt – liên hệ Hoàng Hiệp 0904 567 009 để nhận chính sách đang áp dụng",
			);
			$upd['hh_p_image_links'] = trim( (string) ( $old['hh_p_image_links'] ?? '' ) . "\nplugin:img/masteri-rivera-danang/masteri-rivera-danang-ho-boi-phoi-canh.jpg | Hồ bơi resort Masteri Rivera Danang (phối cảnh chủ đầu tư Masterise Homes) | tiện ích" );
			foreach ( $upd as $k => $v ) {
				$fix[ $k ] = array_merge( (array) ( $fix[ $k ] ?? array() ), array( (string) ( $old[ $k ] ?? '' ) ) );
			}

			// Bài giới thiệu: sông Cẩm Lệ, tên pháp lý, cách thanh toán (không ghi giá mới).
			$c0 = (string) ( $p['content'] ?? '' );
			$c1 = strtr(
				$c0,
				array(
					'<p>Dự án có ba mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch, gần sông Hàn, Lotte Mart và Asia Park. Theo chủ đầu tư, phần lớn căn hộ có hướng nhìn về sông Hàn.</p>' => '<p>Dự án có ba mặt tiền Quy Mỹ – Nguyễn An Ninh – Nguyễn Lộ Trạch, gồm tháp A và tháp B nhìn ra sông Cẩm Lệ, cạnh Cung thể thao Tiên Sơn; gần Lotte Mart và Asia Park, đi cầu Rồng khoảng 10 phút.</p>',
					'<h2>Pháp lý & tiến độ</h2>' . "\n" . '<p>Dự án đã có văn bản đủ điều kiện bán,' => '<h2>Pháp lý & tiến độ</h2>' . "\n" . '<p>Tên pháp lý là Dự án khu chung cư cao tầng, văn phòng thương mại và nhà ở Tuyên Sơn, pháp nhân chủ đầu tư là Công ty CP Phát triển Nhà Tuyên Sơn (Masterise Homes phát triển). Dự án đã có văn bản đủ điều kiện bán,',
					'<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá' => '<h2>Cách thanh toán Masteri Rivera Danang</h2>' . "\n" . '<p>Chủ đầu tư thường có ba phương án: thanh toán theo tiến độ chuẩn, thanh toán sớm để nhận chiết khấu cao hơn, hoặc kết hợp vay ngân hàng có hỗ trợ lãi suất trong một thời gian. Khách hàng là người Đà Nẵng thường được ưu đãi thêm. Mức đặt cọc, chiết khấu và lịch thanh toán thay đổi theo từng đợt chính sách.</p>' . "\n" . '<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá',
				)
			);
			if ( $c1 !== $c0 ) {
				$projects[ $i ]['content']     = $c1;
				$projects[ $i ]['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}
			$projects[ $i ]['meta']     = array_merge( $old, $upd );
			$projects[ $i ]['fix_meta'] = $fix;
		}
		return $projects;
	},
	30
);
