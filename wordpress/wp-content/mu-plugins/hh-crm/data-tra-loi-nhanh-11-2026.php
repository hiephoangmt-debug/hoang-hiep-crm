<?php
/**
 * Khung "trả lời nhanh" đầu trang dự án (09/11/2026) – câu trả lời ngắn + bảng giá theo loại căn + ngày cập nhật + người tổng hợp,
 * để Google (AI Overview, đoạn trích nổi bật) và ChatGPT dễ trích dẫn. Chỉ dùng số đã có trong dữ liệu dự án (giỏ hàng, tài liệu CĐT).
 * Trang dựng sẵn (FourS Tower) chèn thẳng trong landing/fours-tower.html.
 */

defined( 'ABSPATH' ) || exit;

function hh_answer_by() {
	return '<p><small>Tổng hợp: Hoàng Hiệp – môi giới bất động sản Đà Nẵng hơn 15 năm, từ giỏ hàng và tài liệu chủ đầu tư · cập nhật 09/11/2026. Giá tham khảo, thay đổi theo đợt; liên hệ 0904 567 009 để nhận giỏ hàng mới nhất.</small></p>';
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$by  = hh_answer_by();
		$ans = array(
			'cora-tower' => '<p><strong>Giá bán Cora Tower Đà Nẵng (giỏ hàng 11/2026):</strong> căn hộ Cora Tower của Sun Group tại Hòa Xuân có giá từ khoảng <strong>2,42 tỷ/căn studio 32,3 m²</strong>; căn 1PN+ khoảng 3,45 – 3,84 tỷ; shop khối đế tầng 1 tòa A2 khoảng 5,17 – 9,12 tỷ. Giá đã gồm VAT và phí bảo trì, chưa trừ chiết khấu (không vay ngân hàng thêm 5%). Bàn giao dự kiến 30/07/2027, sở hữu lâu dài.</p>
<table><thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead><tbody>
<tr><td>Studio</td><td>32,3 m²</td><td>Khoảng 2,42 – 2,74 tỷ</td></tr>
<tr><td>Căn 1PN+</td><td>53,2 – 54,2 m²</td><td>Khoảng 3,45 – 3,84 tỷ</td></tr>
<tr><td>Căn 2PN, 3PN</td><td>–</td><td>Liên hệ</td></tr>
<tr><td>Shop khối đế tầng 1 (tòa A2)</td><td>43,8 – 87,3 m²</td><td>Khoảng 5,17 – 9,12 tỷ</td></tr>
</tbody></table>' . $by,
			'symphony-5-sun-symphony-residence' => '<p><strong>Giá bán Symphony 5 – Sun Symphony Residence (giỏ hàng 11/2026):</strong> căn studio 30 – 33 m² khoảng <strong>2,50 – 3,30 tỷ</strong>; căn 1PN khoảng 3,09 – 3,30 tỷ; căn 1PN+ khoảng 3,45 – 4,54 tỷ. Giá đã gồm VAT và phí bảo trì, chưa trừ chiết khấu (không vay ngân hàng 5%). Sở hữu 50 năm (đất thương mại dịch vụ); nhận căn sử dụng dự kiến 30/06/2028 khi thanh toán từ 70% (Sun Early Key).</p>
<table><thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead><tbody>
<tr><td>Studio</td><td>30 – 33 m²</td><td>Khoảng 2,50 – 3,30 tỷ</td></tr>
<tr><td>Căn 1PN</td><td>46,4 – 47,8 m²</td><td>Khoảng 3,09 – 3,30 tỷ</td></tr>
<tr><td>Căn 1PN+</td><td>44 – 53 m²</td><td>Khoảng 3,45 – 4,54 tỷ</td></tr>
<tr><td>Căn 2PN, penthouse</td><td>63 – 70 m² (2PN)</td><td>Liên hệ</td></tr>
</tbody></table>' . $by,
			'the-legend-da-nang' => '<p><strong>Giá bán The Legend Đà Nẵng (giỏ hàng chủ đầu tư):</strong> căn 1PN 54 – 60 m² khoảng <strong>7,65 – 9,59 tỷ</strong>, căn 2PN khoảng 8,96 – 14,60 tỷ, căn 3PN góc khoảng 16,83 – 18,98 tỷ (tầng 6 – 25), tương đương khoảng 119 – 188 triệu/m². Giá đã gồm VAT và phí bảo trì, chưa trừ quà nội thất và chiết khấu thanh toán sớm (tới 12%). Bàn giao dự kiến quý I/2028, căn hộ sở hữu lâu dài; shop khối đế đang mở bán 19 căn.</p>
<table><thead><tr><th>Loại căn</th><th>Diện tích</th><th>Giá bán (tham khảo)</th></tr></thead><tbody>
<tr><td>Căn 1PN</td><td>54,4 – 60,3 m²</td><td>Khoảng 7,65 – 9,59 tỷ</td></tr>
<tr><td>Căn 1PN+1 (góc)</td><td>58,4 m²</td><td>Khoảng 9,39 – 10,97 tỷ</td></tr>
<tr><td>Căn 2PN</td><td>74,9 – 84,5 m²</td><td>Khoảng 8,96 – 14,60 tỷ</td></tr>
<tr><td>Căn 3PN (góc)</td><td>114,1 – 114,2 m²</td><td>Khoảng 16,83 – 18,98 tỷ</td></tr>
<tr><td>Shop khối đế</td><td>19 căn</td><td>Liên hệ</td></tr>
</tbody></table>' . $by,
		);
		foreach ( $projects as $i => $p ) {
			if ( isset( $ans[ $p['slug'] ?? '' ] ) ) {
				$projects[ $i ]['meta']['hh_p_answer'] = $ans[ $p['slug'] ];
			}
			// FourS F2: căn đã giữ chỗ trước 26/10/2026 vẫn hưởng thanh toán sớm (anh Hiệp xác nhận 09/11/2026).
			if ( 'fours-tower-f2-thap-mai' === ( $p['slug'] ?? '' ) && ! empty( $p['meta']['hh_p_policy'] ) ) {
				$cur = (string) $p['meta']['hh_p_policy'];
				$new = preg_replace( '/Thanh toán sớm: mức tháng 11\/2026 liên hệ để cập nhật \(mức trước 25\/10: 95% – 12%, 70% – 5%, 50% – 2,5%\)/u', 'Thanh toán sớm 95% / 70% / 50%: chiết khấu 12% / 5% / 2,5% – còn áp dụng cho một số căn đã giữ chỗ trước 26/10/2026 (số lượng có hạn, liên hệ để kiểm tra căn còn ưu đãi)', $cur );
				if ( $new !== $cur ) {
					$projects[ $i ]['meta']['hh_p_policy']       = $new;
					$projects[ $i ]['fix_meta']['hh_p_policy']   = array_values( array_unique( array_merge( (array) ( $p['fix_meta']['hh_p_policy'] ?? array() ), array( $cur ) ) ) );
				}
			}
		}
		return $projects;
	},
	80
);
