<?php
/**
 * Newtown Diamond – tòa The Ruby: 3 căn 1PN view biển (căn ngoại giao) anh Hiệp gửi 07/11/2026.
 * Không ghi mã căn, số tầng cụ thể, tên đơn vị phân phối, link phiếu tính giá. Giá thanh toán sớm đã trừ chiết khấu 12%.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_single_listing_dataset',
	static function ( $list ) {
		$link = '<a href="/du-an/newtown-the-ruby/">The Ruby – Newtown Diamond</a>';
		$list[] = array(
			'rev'     => 1,
			'slug'    => 'ban-can-ho-1pn-newtown-diamond-the-ruby-view-bien-tu-3-17-ty',
			'project' => 'newtown-the-ruby',
			'title'   => 'Bán căn hộ 1PN Newtown Diamond tòa The Ruby 47 m², tầng cao view biển – từ 3,17 tỷ (3 căn ngoại giao)',
			'excerpt' => '3 căn 1 phòng ngủ 47 – 47,85 m² tòa The Ruby – Newtown Diamond, tầng cao view biển và Ngũ Hành Sơn: giá thanh toán sớm (đã trừ chiết khấu 12%) 3,167 – 3,293 tỷ. Tặng gói nội thất 180 triệu, miễn phí quản lý 1 năm.',
			'kind'    => 'can-ho-chung-cu',
			'area'    => 'ngu-hanh-son',
			'image'   => 'img/nha-dat/newtown-ruby-1pn-view-bien-11-2026.jpg',
			'alt'     => 'Căn hộ 1 phòng ngủ Newtown Diamond tòa The Ruby view biển – từ 3,17 tỷ',
			'meta'    => array(
				'hh_deal'        => 'ban',
				'hh_status'      => 'con-hang',
				'hh_price'       => 3167,
				'hh_price_max'   => 3293,
				'hh_address'     => 'Tòa The Ruby, Newtown Diamond, đường Trường Sa, Ngũ Hành Sơn, Đà Nẵng',
				'hh_map_address' => 'Newtown Diamond, Trường Sa, Ngũ Hành Sơn, Đà Nẵng',
				'hh_area'        => 47,
				'hh_bedrooms'    => 1,
				'hh_direction'   => 'dong-bac',
				'hh_features'    => "3 căn 1PN 47 – 47,85 m², tầng cao\nView biển, núi Ngũ Hành Sơn, hướng trung tâm thành phố\nGiá thanh toán sớm đã trừ chiết khấu 12%: 3,167 – 3,293 tỷ\nTặng gói nội thất 180 triệu, quà tân gia 150 triệu\nMiễn phí quản lý 1 năm, gửi xe miễn phí 5 năm, đặc quyền golf 15 năm",
			),
			'content' => '<p>Bán 3 căn hộ <strong>1 phòng ngủ</strong> tầng cao tại ' . $link . ' (đường Trường Sa, Ngũ Hành Sơn), view biển và núi Ngũ Hành Sơn. Đây là các căn ngoại giao, giá thanh toán sớm đã trừ chiết khấu 12% <strong>từ 3,167 tỷ</strong>.</p>
<h2>Các căn đang có</h2>
<table><thead><tr><th>Căn</th><th>Diện tích</th><th>View, hướng</th><th>Giá TT sớm (đã CK 12%)</th></tr></thead><tbody>
<tr><td>1PN tầng cao</td><td>47 m²</td><td>View biển, hướng trung tâm thành phố – hướng Đông Bắc</td><td>3,170 tỷ</td></tr>
<tr><td>1PN tầng cao</td><td>47 m²</td><td>View biển + núi Ngũ Hành Sơn – hướng Đông Bắc</td><td>3,293 tỷ</td></tr>
<tr><td>1PN tầng cao</td><td>47,85 m²</td><td>View xéo biển + núi Ngũ Hành Sơn</td><td>3,167 tỷ</td></tr>
</tbody></table>
<h2>Chính sách đi kèm</h2>
<ul>
<li>Chiết khấu thanh toán sớm 12% (đã tính trong giá trên); thanh toán theo tiến độ chiết khấu 3%.</li>
<li>Chiết khấu thêm 150 triệu (quà tân gia).</li>
<li>Tặng gói nội thất 180 triệu.</li>
<li>Miễn phí phí quản lý 1 năm, miễn phí chỗ đậu xe 5 năm, gói đặc quyền golf 15 năm.</li>
</ul>
<p>Căn 1PN vốn thấp, hợp đầu tư cho thuê gần biển Mỹ Khê – Non Nước. Giá và chính sách tham khảo tháng 11/2026, căn có thể đã có khách – gọi trước để kiểm tra và nhận phiếu tính giá từng căn.</p>
<p>Xem tiến độ, mặt bằng tòa tại <a href="/du-an/newtown-the-ruby/">trang dự án The Ruby</a>. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>',
		);
		return $list;
	}
);
