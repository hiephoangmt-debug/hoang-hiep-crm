<?php
/**
 * Tin nhà đất riêng lẻ (không thuộc dự án) – hàng Hoàng Hiệp nhận ký gửi / hợp tác môi giới.
 * Không ghi tên, số điện thoại bên bán; liên hệ qua Hoàng Hiệp. Nhập cùng nút Dự án → Nhập dữ liệu Đà Nẵng;
 * chạy lại không tạo trùng, không ghi đè tin đã sửa tay.
 */

defined( 'ABSPATH' ) || exit;

function hh_single_listing_dataset() {
	$list   = array();
	$list[] = array(
		'rev'     => 2, // Tăng số này khi sửa nội dung → tin đã đăng (chưa sửa tay) tự cập nhật.
			'slug'    => 'chuyen-nhuong-dat-thuong-mai-dich-vu-mat-tien-hoang-van-thai-2404-m2',
		'title'   => 'Chuyển nhượng 2.404 m² đất thương mại dịch vụ mặt tiền 42 m đường Hoàng Văn Thái, Đà Nẵng',
		'excerpt' => 'Khu đất TMDV 2.404,4 m² mặt tiền khoảng 42 m đường Hoàng Văn Thái (~35 m); thuê đất trả tiền một lần đến 20/01/2066; nhà 4 tầng và sân bê tông; giá 50 tỷ gồm VAT.',
		'kind'    => 'mat-bang-kinh-doanh',
		'area'    => 'lien-chieu',
		'image'   => 'img/nha-dat/chuyen-nhuong-dat-tmdv-mat-tien-hoang-van-thai.jpg',
		'alt'     => 'Sơ đồ khu đất thương mại dịch vụ 2.404,4 m² mặt tiền 42 m đường Hoàng Văn Thái, Đà Nẵng',
		'meta'    => array(
			'hh_deal'        => 'ban',
			'hh_status'      => 'con-hang',
			'hh_price'       => 50000,
			'hh_negotiable'  => '1',
			'hh_address'     => 'Mặt tiền đường Hoàng Văn Thái, Đà Nẵng (địa chỉ cụ thể gửi khi liên hệ)',
			'hh_area'        => 2404.4,
			'hh_area_use'    => 195.1,
			'hh_width'       => 42,
			'hh_length'      => 60,
			'hh_frontage'    => 35,
			'hh_floors'      => 4,
			'hh_legal'       => '', // Đất thuê trả tiền một lần – ghi rõ ở phần lưu ý pháp lý, không hiện "Khác".
			'hh_featured'    => '1',
			'hh_features'    => "Diện tích lớn 2.404,4 m², mặt tiền khoảng 42 m, sâu khoảng 60 m\nMặt tiền đường Hoàng Văn Thái rộng khoảng 35 m, khu vực đông dân cư, nhiều cơ sở thương mại\nĐất thương mại dịch vụ, thuê đất trả tiền một lần đến 20/01/2066\nCó sẵn nhà 4 tầng (xây dựng khoảng 195 m²) và hơn 2.200 m² sân bê tông\nPhù hợp nghiên cứu showroom ô tô, trung tâm dịch vụ, kinh doanh thương mại\nGiá 50 tỷ đã gồm VAT, thanh toán có thể thương lượng",
		),
		'content' => '<p>Chuyển nhượng khu đất <strong>thương mại dịch vụ 2.404,4 m²</strong> mặt tiền <strong>đường Hoàng Văn Thái, Đà Nẵng</strong> – rộng khoảng <strong>42 m</strong>, chiều sâu khoảng 60 m, nằm trên tuyến đường rộng khoảng 35 m. Đất thuê trả tiền một lần đến 20/01/2066 (còn khoảng 39 năm), hiện có nhà 4 tầng và hơn 2.200 m² sân bê tông. Giá 50 tỷ đã gồm VAT – khoảng 20,8 triệu/m² đất.</p>
<h2>Phù hợp kinh doanh gì?</h2>
<ul>
<li><strong>Showroom ô tô, xe máy</strong>: mặt tiền 42 m trưng bày rộng, sân bê tông lớn làm bãi xe, khu dịch vụ bảo dưỡng.</li>
<li><strong>Trung tâm dịch vụ, thương mại</strong>: siêu thị, trung tâm phân phối, nhà hàng tiệc cưới, trung tâm đào tạo.</li>
<li><strong>Văn phòng – kho trưng bày</strong> cho doanh nghiệp cần vừa mặt tiền vừa diện tích sân bãi.</li>
</ul>
<p>Mọi phương án khai thác, cải tạo, xây mới cần theo quy hoạch và quy định pháp luật về đất thương mại dịch vụ tại khu vực.</p>
<h2>Lưu ý pháp lý khi nhận chuyển nhượng</h2>
<ul>
<li>Đây là <strong>đất thuê trả tiền một lần</strong> – người mua nhận chuyển nhượng quyền sử dụng đất thuê và tài sản trên đất cho thời hạn còn lại đến 20/01/2066.</li>
<li>Thẩm định hồ sơ: giấy chứng nhận, hợp đồng thuê đất, chứng từ đã nộp tiền thuê một lần, giấy phép xây dựng công trình hiện hữu.</li>
<li>Bên bán là doanh nghiệp, ưu tiên làm việc trực tiếp với khách có nhu cầu thực tế, sẵn sàng khảo sát và thẩm định hồ sơ.</li>
</ul>
<p>Khách doanh nghiệp quan tâm, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận vị trí cụ thể, hồ sơ và đặt lịch khảo sát.</p>',
	);
	// 01/11/2026 – lô đất 4 mặt tiền Hoàng Sa – Hồ Học Lãm (Thọ Quang, Sơn Trà). Không ghi số tờ / thửa, tên chủ đất.
	$list[] = array(
		'rev'     => 3, // 01/11: phối cảnh 3D nhúng ngay trong trang tin (hh_3d_url).
		'slug'    => 'ban-dat-4-mat-tien-hoang-sa-son-tra-583-m2-giay-phep-khach-san',
		'title'   => 'Bán lô đất 4 mặt tiền đường biển Hoàng Sa, Sơn Trà – 583,6 m², ngang 27,6 m, kèm giấy phép khách sạn 22 tầng',
		'excerpt' => 'Lô đất 4 mặt tiền góc Hoàng Sa – Hồ Học Lãm (Thọ Quang, Sơn Trà), view trực diện biển, 583,6 m², ngang 27,6 m. Tặng kèm giấy phép xây dựng và thiết kế khách sạn 5 sao 22 tầng, 94 phòng. Giá 190 tỷ, thương lượng.',
		'kind'    => 'dat-nen',
		'area'    => 'son-tra',
		'image'   => 'img/nha-dat/lo-dat-4-mat-tien-hoang-sa-son-tra.jpg',
		'alt'     => 'Sơ đồ vị trí lô đất 4 mặt tiền 583,6 m² góc đường Hoàng Sa – Hồ Học Lãm, Sơn Trà, Đà Nẵng, view biển',
		'meta'    => array(
			'hh_deal'        => 'ban',
			'hh_status'      => 'con-hang',
			'hh_price'       => 190000,
			'hh_negotiable'  => '1',
			'hh_address'     => 'Góc đường Hoàng Sa – Hồ Học Lãm, phường Thọ Quang (cũ), Sơn Trà, Đà Nẵng',
			'hh_map_address' => 'Hoàng Sa, Hồ Học Lãm, Thọ Quang, Sơn Trà, Đà Nẵng',
			'hh_3d_url'      => 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/lo-dat-hoang-sa/',
			'hh_area'        => 583.6,
			'hh_width'       => 27.6,
			'hh_frontage'    => 27.6,
			'hh_direction'   => '',
			'hh_legal'       => '',
			'hh_featured'    => '1',
			'hh_features'    => "4 mặt tiền, góc đường biển Hoàng Sa – Hồ Học Lãm\nView trực diện biển, chỉ cách bãi cát một con đường\nDiện tích 583,6 m², ngang 27,6 m – hiếm lô lớn vuông vức trên trục biển\nTặng kèm giấy phép xây dựng và hồ sơ thiết kế khách sạn 5 sao 22 tầng, 94 phòng (theo chủ đất)\nKhu đông khách du lịch: dịch vụ chèo SUP, nhà hàng hải sản, khách sạn ven biển\nGiá 190 tỷ, còn thương lượng",
			'hh_nearby'      => "Bãi biển Hoàng Sa – bên kia đường\nKhu dịch vụ chèo SUP, nhà hàng hải sản – ngay quanh lô\nBán đảo Sơn Trà, chùa Linh Ứng – vài phút đi xe\nCầu Rồng, trung tâm Hải Châu – khoảng 10 – 15 phút",
		),
		'content' => '<p>Chủ gửi bán lô đất <strong>4 mặt tiền</strong> hiếm có trên trục biển <strong>Hoàng Sa</strong> (đoạn đường biển nối tiếp Võ Nguyên Giáp về phía bán đảo Sơn Trà), góc đường Hoàng Sa – Hồ Học Lãm, phường Thọ Quang (cũ), Sơn Trà, Đà Nẵng. Lô đất <strong>view trực diện biển</strong>, diện tích <strong>583,6 m²</strong>, ngang <strong>27,6 m</strong>. Giá <strong>190 tỷ, thương lượng</strong> – khoảng 325,6 triệu/m².</p>
<p><a href="#phoi-canh-3d"><strong>Xem phối cảnh 3D lô đất và khách sạn 22 tầng</strong></a> ngay trên trang này – xoay xem vị trí, view từ tầng 22, mặt đường Hoàng Sa, ban ngày và ban đêm (hình minh hoạ).</p>
<h2>Điểm đặc biệt: có sẵn giấy phép khách sạn 22 tầng</h2>
<p>Theo chủ đất, lô đất được <strong>tặng kèm giấy phép xây dựng và đầy đủ hồ sơ thiết kế khách sạn 5 sao 22 tầng, 94 phòng</strong>. Nhà đầu tư rút ngắn được thời gian xin phép, thiết kế – thường mất nhiều tháng với một dự án khách sạn cao tầng ven biển. Tính ra, giá đất khoảng 2,02 tỷ cho mỗi phòng khách sạn theo thiết kế (chưa gồm chi phí xây dựng).</p>
<h2>Thông tin lô đất</h2>
<table>
<tbody>
<tr><th>Vị trí</th><td>Góc Hoàng Sa – Hồ Học Lãm, Thọ Quang (cũ), Sơn Trà, Đà Nẵng</td></tr>
<tr><th>Diện tích</th><td>583,6 m²</td></tr>
<tr><th>Chiều ngang</th><td>27,6 m</td></tr>
<tr><th>Mặt tiền</th><td>4 mặt tiền (đường biển Hoàng Sa, Hồ Học Lãm và hai lối bên)</td></tr>
<tr><th>Hồ sơ kèm theo</th><td>Giấy phép xây dựng, thiết kế khách sạn 5 sao 22 tầng, 94 phòng (theo chủ đất)</td></tr>
<tr><th>Giá</th><td>190 tỷ, thương lượng (khoảng 325,6 triệu/m²)</td></tr>
</tbody>
</table>
<h2>Phù hợp với ai?</h2>
<ul>
<li><strong>Nhà đầu tư khách sạn</strong>: xây ngay theo giấy phép có sẵn, khai thác khách du lịch biển Đà Nẵng đang tăng mạnh.</li>
<li><strong>Doanh nghiệp cần tài sản trên trục biển</strong>: lô lớn, vuông vức, nhiều mặt tiền – hiếm trên tuyến Hoàng Sa – Võ Nguyên Giáp.</li>
<li><strong>Giữ tài sản dài hạn</strong>: đất mặt tiền biển Sơn Trà ngày càng ít lô lớn được giao dịch.</li>
</ul>
<h2>Lưu ý khi tìm hiểu</h2>
<ul>
<li>Diện tích, kích thước, giấy phép xây dựng và hồ sơ thiết kế theo thông tin chủ đất cung cấp; khách được xem bản gốc và kiểm tra tại cơ quan chức năng trước khi đặt cọc.</li>
<li>Nên kiểm tra quy hoạch chi tiết, chỉ tiêu xây dựng và thời hạn hiệu lực của giấy phép xây dựng (giấy phép có thời hạn khởi công).</li>
</ul>
<p>Xem bảng giá đất mặt tiền các tuyến biển tại <a href="/thong-ke-dau-tu/">Thống kê đầu tư</a>. Khách có nhu cầu thực, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận hồ sơ, vị trí chính xác và đặt lịch xem đất.</p>',
	);
	// 04/11/2026 – cặp đất view biển đường Hoàng Sa 224 m². Không ghi ký hiệu lô (gửi khi khách liên hệ).
	$list[] = array(
		'rev'     => 1,
		'slug'    => 'ban-cap-dat-view-bien-duong-hoang-sa-son-tra-224-m2',
		'title'   => 'Bán cặp đất view biển đường Hoàng Sa, Sơn Trà – 224 m², 420 triệu/m²',
		'excerpt' => 'Cặp đất liền kề mặt tiền đường biển Hoàng Sa (Sơn Trà, Đà Nẵng), view trực diện biển, tổng 224 m². Giá 420 triệu/m² (khoảng 94,08 tỷ), thương lượng.',
		'kind'    => 'dat-nen',
		'area'    => 'son-tra',
		'image'   => 'img/nha-dat/cap-dat-view-bien-hoang-sa-224-m2.jpg',
		'alt'     => 'Cặp đất view biển đường Hoàng Sa, Sơn Trà, Đà Nẵng – 224 m², giá 420 triệu/m²',
		'meta'    => array(
			'hh_deal'        => 'ban',
			'hh_status'      => 'con-hang',
			'hh_price'       => 94080,
			'hh_negotiable'  => '1',
			'hh_address'     => 'Mặt tiền đường Hoàng Sa, Sơn Trà, Đà Nẵng (vị trí cụ thể gửi khi liên hệ)',
			'hh_map_address' => 'Đường Hoàng Sa, Sơn Trà, Đà Nẵng',
			'hh_area'        => 224,
			'hh_legal'       => '',
			'hh_featured'    => '1',
			'hh_features'    => "Cặp 2 lô liền kề, tổng 224 m² – gộp được mặt tiền rộng\nMặt tiền đường biển Hoàng Sa, view trực diện biển\nBên kia đường là bãi cát, hàng dừa ven biển\nPhù hợp xây khách sạn, căn hộ dịch vụ hoặc giữ tài sản\nGiá 420 triệu/m², còn thương lượng",
			'hh_nearby'      => "Bãi biển Hoàng Sa – bên kia đường\nBán đảo Sơn Trà, chùa Linh Ứng – vài phút đi xe\nCầu Rồng, trung tâm Hải Châu – khoảng 10 – 15 phút",
		),
		'content' => '<p>Bán <strong>cặp đất view biển</strong> mặt tiền đường <strong>Hoàng Sa</strong>, Sơn Trà, Đà Nẵng – tổng diện tích <strong>224 m²</strong>, view trực diện biển, bên kia đường là bãi cát và hàng dừa. Giá <strong>420 triệu/m²</strong> (khoảng <strong>94,08 tỷ</strong> cho cả cặp), còn thương lượng.</p>
<h2>Thông tin cặp đất</h2>
<table>
<tbody>
<tr><th>Vị trí</th><td>Mặt tiền đường biển Hoàng Sa, Sơn Trà, Đà Nẵng</td></tr>
<tr><th>Diện tích</th><td>224 m² (cặp 2 lô liền kề)</td></tr>
<tr><th>Giá</th><td>420 triệu/m² – khoảng 94,08 tỷ, thương lượng</td></tr>
<tr><th>View</th><td>Trực diện biển</td></tr>
</tbody>
</table>
<h2>Vì sao cặp đất mặt biển Hoàng Sa đáng chú ý?</h2>
<ul>
<li><strong>Mặt tiền gộp rộng</strong>: hai lô liền kề cho phép thiết kế khách sạn, căn hộ dịch vụ có mặt đứng lớn hướng biển – điều một lô đơn khó làm.</li>
<li><strong>Trục biển Sơn Trà</strong>: đường Hoàng Sa nối tiếp Võ Nguyên Giáp về phía bán đảo Sơn Trà, khu khách du lịch đông, nhiều khách sạn ven biển.</li>
<li><strong>Quỹ đất mặt biển ngày càng hiếm</strong>: lô trống mặt tiền đường biển còn rất ít để xây mới.</li>
</ul>
<h2>Lưu ý khi tìm hiểu</h2>
<ul>
<li>Diện tích, ký hiệu lô và pháp lý theo thông tin chủ đất; khách được xem giấy tờ và kiểm tra tại cơ quan chức năng trước khi đặt cọc.</li>
<li>Nên kiểm tra quy hoạch chi tiết, chỉ tiêu xây dựng (tầng cao, mật độ) nếu dự định xây khách sạn.</li>
</ul>
<p>Xem bảng giá đất mặt tiền các tuyến biển tại <a href="/thong-ke-dau-tu/">Thống kê đầu tư</a>. Khách có nhu cầu thực, liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận vị trí, giấy tờ và đặt lịch xem đất.</p>',
	);
	return apply_filters( 'hh_single_listing_dataset', $list );
}

/** Tạo tin chưa có (theo đường dẫn); tin đã có chỉ cập nhật khi tăng 'rev' và tin chưa bị sửa tay. Trả về số tin tạo mới. */
function hh_import_single_listings() {
	$created = 0;
	foreach ( hh_single_listing_dataset() as $l ) {
		$old = get_page_by_path( $l['slug'], OBJECT, 'bat-dong-san' );
		if ( $old ) {
			$rev = (int) ( $l['rev'] ?? 1 );
			if ( $rev > (int) get_post_meta( $old->ID, '_hh_listing_rev', true ) && md5( $old->post_content ) === get_post_meta( $old->ID, '_hh_news_hash', true ) ) {
				wp_update_post( array( 'ID' => $old->ID, 'post_content' => $l['content'], 'post_excerpt' => $l['excerpt'] ) );
				foreach ( array_diff_key( $l['meta'], array_flip( array( 'hh_status', 'hh_price', 'hh_featured' ) ) ) as $k => $v ) { // Giữ trạng thái, giá anh tự đổi.
					update_post_meta( $old->ID, $k, $v );
				}
				update_post_meta( $old->ID, '_hh_news_hash', md5( get_post_field( 'post_content', $old->ID ) ) );
				update_post_meta( $old->ID, '_hh_listing_rev', $rev );
			}
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'bat-dong-san',
				'post_status'  => 'publish',
				'post_title'   => $l['title'],
				'post_name'    => $l['slug'],
				'post_excerpt' => $l['excerpt'],
				'post_content' => $l['content'],
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}
		foreach ( $l['meta'] as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		if ( term_exists( $l['kind'], 'loai-bds' ) ) {
			wp_set_object_terms( $id, $l['kind'], 'loai-bds' );
		}
		if ( ! empty( $l['area'] ) && term_exists( $l['area'], 'khu-vuc' ) ) {
			wp_set_object_terms( $id, $l['area'], 'khu-vuc' );
		}
		$file = HH_CRM_DIR . $l['image'];
		if ( ! empty( $l['image'] ) && is_file( $file ) && function_exists( 'hh_quick_post_image' ) ) {
			hh_quick_post_image( $id, array( 'name' => pathinfo( $file, PATHINFO_FILENAME ), 'alt' => $l['alt'], 'caption' => '', 'data' => base64_encode( file_get_contents( $file ) ) ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
		update_post_meta( $id, '_hh_listing_rev', (int) ( $l['rev'] ?? 1 ) );
		++$created;
	}
	return $created;
}
