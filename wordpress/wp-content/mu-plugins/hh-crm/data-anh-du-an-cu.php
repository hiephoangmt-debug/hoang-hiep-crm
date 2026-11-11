<?php
/**
 * Ảnh cho trang dự án cũ chưa có ảnh thật – từ thư mục Drive "dự án cũ" anh Hiệp gửi 11/11/2026.
 * Hòa Bình Green Đà Nẵng (Danang Golden Bay): ảnh thực tế 2017 – 2019 (đã bỏ ảnh có logo đơn vị phân phối, chữ chìm
 * trang khác, ghi tên nhiếp ảnh gia, ảnh người mẫu, banner sự kiện). Web tải thẳng từ link Drive (công khai).
 * Sun Cosmo Residence: mặt bằng tổng thể gốc của chủ đầu tư (bản 50 MB thu nhỏ, đi kèm plugin); bỏ bản có chữ chào bán chèn lên.
 * Ariyana, Mường Thanh, Soleil: thư mục không có ảnh dùng được (chỉ bảng giá, hợp đồng, chính sách cũ) → chưa thêm.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$d    = static fn( $id, $alt, $where ) => "https://drive.google.com/file/d/$id/view | $alt | $where";
		$add  = array(
			'hoa-binh-green-da-nang' => array(
				$d( '1Ie7pC7gjmkjtZ8M9f6_AXuqhkuhtV8uu', 'Hòa Bình Green Đà Nẵng (Danang Golden Bay) về đêm – ảnh thực tế', 'đại diện' ),
				$d( '1w5RdHXwMKm0xirWg9Tu1u2nNwtJOcvuy', 'Tổ hợp Hòa Bình Green Đà Nẵng bên vịnh Đà Nẵng lúc hoàng hôn', 'thư viện' ),
				$d( '1380n0QlP5u9JuTqZRdySuD922Etjzrym', 'Hồ bơi vô cực tầng mái Hòa Bình Green Đà Nẵng nhìn ra vịnh – ảnh thực tế', 'tiện ích' ),
				$d( '1W3CK7eb-SVmvkILbzAu_MikkUdPlq4r3', 'Hồ bơi tầng mái về đêm, nhìn xuống sông Hàn và cầu Thuận Phước – ảnh thực tế', 'tiện ích' ),
				$d( '1v7SEuwwap7_M7vCRWokmCHiqvb2bOUwU', 'Sảnh tiệc trong tòa Danang Golden Bay – ảnh thực tế', 'tiện ích' ),
				$d( '1Fg7RZJ7gpDmCu2oM24_I1OGs8tvhG2Mc', 'Hoàng hôn trên cầu Thuận Phước nhìn từ hồ bơi tầng mái – ảnh thực tế', 'thư viện' ),
				$d( '15tRC6EKQU_t6OIbTwlN0JRbSXDr0NUIi', 'Hồ bơi vô cực và cầu Thuận Phước trong sương sớm – ảnh thực tế', 'thư viện' ),
				$d( '1QF5_-d1m_ysO6OgN5AG3YysfTnHdxOio', 'Phòng khách – bàn ăn căn hộ Hòa Bình Green Đà Nẵng – ảnh thực tế', 'thư viện' ),
				$d( '1CdShBvz2R18vRzBxbddP96oQiVCF48NZ', 'Phòng ngủ có ban công nhìn ra vịnh tại Danang Golden Bay – ảnh thực tế', 'thư viện' ),
			),
			'sun-cosmo-residence'    => array(
				'plugin:img/sun-cosmo/sun-cosmo-mat-bang-tong-the.jpg | Mặt bằng tổng thể Sun Cosmo Residence bên cầu Trần Thị Lý: nhà phố, biệt thự song lập, đơn lập và khối cao tầng (bản vẽ chủ đầu tư) | đại diện | Mặt bằng tổng thể',
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $add[ $slug ] ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$new = array_filter( $add[ $slug ], static fn( $l ) => false === strpos( $cur, trim( explode( '|', $l )[0] ) ) );
			if ( ! $new ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $new ) );
			if ( '' !== $cur ) {
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
		}
		return $projects;
	},
	50
);
