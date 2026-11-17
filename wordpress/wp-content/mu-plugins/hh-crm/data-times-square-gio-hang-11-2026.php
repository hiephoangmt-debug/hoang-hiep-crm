<?php
/**
 * Times Square Đà Nẵng – giỏ hàng tháng 11/2026 (anh Hiệp gửi 17/11/2026): 23 căn tòa CT3, CT7.
 * Anh Hiệp yêu cầu đưa MÃ CĂN các căn giá tốt lên trang dự án để khách quan tâm; các căn còn lại chỉ ghi "liên hệ".
 * Giá là giá thanh toán chuẩn theo bảng hàng (tham khảo, thay đổi theo thời điểm). Không dùng ảnh bảng hàng có logo đơn vị phân phối.
 */

defined( 'ABSPATH' ) || exit;

function hh_tsq_1126_meta() {
	return array(
		'hh_p_price_from'     => 7244,
		'hh_p_offer_title'    => 'Giỏ hàng tháng 11/2026: studio view biển Mỹ Khê chỉ từ 7,24 tỷ – 23 căn đẹp tòa CT3, CT7',
		'hh_p_offer_deadline' => '30/11/2026',
		'hh_p_unit_types'     => implode(
			"\n",
			array(
				'Studio | 45,14 – 46,21 m² | 1 | Chỉ từ 7,24 tỷ',
				'Căn 1PN | 45,49 – 46,88 m² | 1 | Từ 9,39 tỷ',
				'Căn 1PN+ | 75,19 m² | 1 | Từ 17,53 tỷ',
				'Căn 2PN | 84,59 – 91,67 m² | 2 | Từ 17,23 tỷ',
			)
		),
		'hh_p_price_table'    => implode(
			"\n",
			array(
				'CT7-15.07 – Studio | 45,28 m² | 7,244 tỷ | Giá tốt nhất giỏ hàng tháng 11',
				'CT7-16.08 – Studio | 45,28 m² | 7,35 tỷ | Tầng 16 tòa CT7',
				'CT7-15.01 – Studio | 45,49 m² | 8,577 tỷ | Tầng 15 tòa CT7',
				'CT7-14.02 – 1PN | 45,49 m² | 9,388 tỷ | Căn 1 phòng ngủ giá tốt nhất',
				'CT7-15.03 – 2PN | 84,93 m² | 17,228 tỷ | Căn 2 phòng ngủ giá tốt nhất',
				'CT3-08.03 – 2PN Ocean Panorama | 91,67 m² | Khoảng 33,56 tỷ | Tầng 8, view biển 2 mặt, nội thất liền tường; thanh toán sớm khoảng 30,36 tỷ',
				'Các căn khác tòa CT3, CT7 | Studio, 1PN, 1PN+, 2PN | Liên hệ | Hoàng Hiệp gửi bảng giá từng căn qua Zalo',
			)
		),
	);
}

function hh_tsq_1126_html() {
	return <<<'HTML'

<h2>Giỏ hàng Times Square Đà Nẵng tháng 11/2026</h2>
<p>Tháng 11/2026 có <strong>23 căn</strong> tại 2 tòa CT3 và CT7 – studio, 1PN, 1PN+ và 2PN, diện tích thông thủy 45 – 92 m². Căn studio view biển Mỹ Khê <strong>chỉ từ 7,24 tỷ</strong>.</p>
<h3>Các căn giá tốt</h3>
<ul>
<li><strong>CT7-15.07</strong> – studio 45,28 m²: <strong>7,244 tỷ</strong> (giá tốt nhất giỏ hàng).</li>
<li><strong>CT7-16.08</strong> – studio 45,28 m²: 7,35 tỷ.</li>
<li><strong>CT7-14.02</strong> – 1 phòng ngủ 45,49 m²: 9,388 tỷ.</li>
<li><strong>CT7-15.03</strong> – 2 phòng ngủ 84,93 m²: 17,228 tỷ.</li>
<li><strong>CT3-08.03</strong> – 2 phòng ngủ Ocean Panorama 91,67 m², tầng 8, view biển 2 mặt, nội thất liền tường: khoảng 33,56 tỷ, thanh toán sớm khoảng 30,36 tỷ.</li>
</ul>
<p>Giá là giá thanh toán chuẩn theo bảng hàng tháng 11/2026, chỉ để tham khảo; căn có thể đã có khách giữ chỗ. Bảng giá từng căn, phương án vay và thanh toán sớm: liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>
HTML;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'times-square-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$projects[ $i ]['meta']    = array_merge( $p['meta'], hh_tsq_1126_meta() );
			$projects[ $i ]['content'] = ( $p['content'] ?? '' ) . hh_tsq_1126_html();
		}
		return $projects;
	},
	70
);
