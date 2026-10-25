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
