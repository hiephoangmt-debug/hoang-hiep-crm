<?php
/**
 * Sun Symphony Residence (tổ hợp S1 – S3): bổ sung tài liệu chủ đầu tư (thư mục Drive "Sun Symphony Residence" và "Sun Symphony 5"
 * anh Hiệp gửi 06/11/2026): phối cảnh toàn tổ hợp, công viên nội khu Central Park S1 – S2, River Park, ảnh nhà mẫu Studio / 1PN+1,
 * layout khối đế (tầng 1 – 2 từng tòa) và layout căn hộ từng tòa. Trang trước đây chỉ có mặt bằng tầng.
 * Chạy sau data-sun-symphony-mat-bang.php (60); chỉ thay ô ảnh khi vẫn là giá trị web nhập.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$l   = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/sun-symphony/sun-symphony-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );
		$new = array(
			$l( 'to-hop-tong-the-1', 'Toàn cảnh tổ hợp Sun Symphony Residence bên sông Hàn lúc hoàng hôn, phối cảnh chủ đầu tư', 'đại diện', 'Toàn cảnh lúc hoàng hôn' ),
			$l( 'to-hop-tong-the-2', 'Sun Symphony Residence nhìn từ sông Hàn về bán đảo Sơn Trà, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh hướng Sơn Trà' ),
			$l( 'to-hop-dem-phao-hoa', 'Sun Symphony Residence đêm pháo hoa DIFF bên sông Hàn, phối cảnh chủ đầu tư', 'thư viện', 'Đêm pháo hoa' ),
			$l( 'to-hop-ban-ngay', 'Tổ hợp Sun Symphony Residence ban ngày nhìn về trung tâm Đà Nẵng, phối cảnh chủ đầu tư', 'thư viện', 'Toàn cảnh ban ngày' ),
			$l( 'to-hop-ban-ngay-2', 'Sun Symphony Residence và bờ Đông sông Hàn lúc bình minh, phối cảnh chủ đầu tư', 'thư viện', 'Bờ Đông sông Hàn' ),
			$l( 'cp-01-tong-the-cong-vien', 'Công viên nội khu Central Park giữa hai tòa S1 – S2 và bến du thuyền, phối cảnh chủ đầu tư', 'tiện ích', 'Central Park S1 – S2' ),
			$l( 'cp-02-vuon-chim', 'Vườn chim trong công viên nội khu Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Vườn chim' ),
			$l( 'cp-03-tu-cau-tau', 'Công viên nội khu nhìn từ cầu tàu, Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Công viên nội khu' ),
			$l( 'cp-04-kidzone', 'Khu vui chơi trẻ em trong công viên nội khu Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Khu vui chơi trẻ em' ),
			$l( 'cp-05-sanh-s2', 'Sảnh đón tòa S2 Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Sảnh tòa S2' ),
			$l( 'cp-06-cau-tau-nhin-cong-vien', 'Bến du thuyền và phố thương mại ven sông Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Bến du thuyền' ),
			$l( 'cp-07-duong-dao', 'Đường dạo trong công viên nội khu Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Đường dạo' ),
			$l( 'rp-1', 'Công viên ven sông River Park, Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'River Park' ),
			$l( 'rp-3', 'Đường dạo ven sông Hàn trong River Park, phối cảnh chủ đầu tư', 'tiện ích', 'Đường dạo ven sông' ),
			$l( 'rp-4', 'Khu nghỉ ven sông trong River Park, Sun Symphony Residence, phối cảnh chủ đầu tư', 'tiện ích', 'Bờ sông Hàn' ),
		);
		foreach ( array( 'studio-01', 'studio-02', 'studio-03', 'studio-05', 'studio-07', 'studio-10' ) as $i => $f ) {
			$new[] = $l( 'nm-' . $f, 'Nội thất căn mẫu Studio Sun Symphony Residence – ảnh ' . ( $i + 1 ), 'thư viện', 'Căn mẫu Studio' );
		}
		foreach ( array( '1pn1-01', '1pn1-02', '1pn1-04', '1pn1-06', '1pn1-08', '1pn1-10' ) as $i => $f ) {
			$new[] = $l( 'nm-' . $f, 'Nội thất căn mẫu 1PN+1 Sun Symphony Residence – ảnh ' . ( $i + 1 ), 'thư viện', 'Căn mẫu 1PN+1' );
		}
		foreach ( array( 'S1' => 1, 'S2' => 3, 'S3' => 5 ) as $toa => $k ) {
			$new[] = $l( sprintf( 'kd-%02d', $k ), "Layout tầng 1 khối đế tòa $toa Sun Symphony Residence (shophouse)", 'mặt bằng', "Tòa $toa · Tầng 1 khối đế" );
			$new[] = $l( sprintf( 'kd-%02d', $k + 1 ), "Layout tầng 2 khối đế tòa $toa Sun Symphony Residence (shophouse)", 'mặt bằng', "Tòa $toa · Tầng 2 khối đế" );
		}
		for ( $i = 1; $i <= 13; $i++ ) {
			$new[] = $l( sprintf( 'lo-s1-%02d', $i ), sprintf( 'Layout căn hộ tòa S1 Sun Symphony Residence – mẫu %02d', $i ), 'layout', sprintf( 'Tòa S1 – mẫu %02d', $i ) );
		}
		for ( $i = 1; $i <= 10; $i++ ) {
			$new[] = $l( sprintf( 'lo-s2-%02d', $i ), sprintf( 'Layout căn hộ tòa S2 Sun Symphony Residence – mẫu %02d', $i ), 'layout', sprintf( 'Tòa S2 – mẫu %02d', $i ) );
		}
		foreach ( array( '03' => '58,6', '04' => '96,8', '05' => '58,2', '07' => '70,8', '08' => '99', '09' => '37,4', '10' => '71,7', '11' => '34,8' ) as $i => $m2 ) {
			$new[] = $l( 'lo-s3-' . $i, "Layout căn hộ tòa S3 Sun Symphony Residence – diện tích $m2 m²", 'layout', "Tòa S3 – $m2 m²" );
		}
		foreach ( $projects as &$p ) {
			if ( 'sun-symphony-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$p['meta']['hh_p_image_links'] = implode( "\n", $new ) . ( '' !== $old ? "\n" . str_replace( ' | đại diện', ' | thư viện', $old ) : '' );
			if ( '' !== $old ) {
				$p['fix_meta']['hh_p_image_links'] = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $old ) ) ) );
			}
		}
		unset( $p );
		return $projects;
	},
	61
);
