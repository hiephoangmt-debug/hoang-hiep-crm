<?php
/**
 * Sun Ponte Residence – giá cho thuê theo bảng căn cho thuê anh Hiệp gửi 04/11/2026 (khoảng 40 căn).
 * Chỉ ghi khoảng giá theo loại căn – không ghi mã căn, tầng cụ thể.
 * Anh Hiệp yêu cầu cập nhật → ghi đè ô "Giá thuê tham khảo" và "Nhận định thị trường thứ cấp" một lần sau khi cài bản này.
 */

defined( 'ABSPATH' ) || exit;

/** Giá thuê & nhận định mới của Sun Ponte. */
function hh_ponte_rent_data() {
	return array(
		'hh_p_rent_price'  => 'Studio 26 – 30 m²: 11 – 17 triệu/tháng · 1PN+ 49 – 50 m²: 18 – 27 triệu/tháng · 2PN 68 – 78 m²: 25 – 38 triệu/tháng · 2PN 91 m²: 45 – 50 triệu/tháng · 3PN 91 m²: khoảng 48 triệu/tháng (bảng giá cho thuê 11/2026, full nội thất, tham khảo)',
		'hh_p_resale_note' => 'Giá chuyển nhượng tổng hợp từ tin rao công khai tháng 10/2026. Giá thuê theo bảng căn cho thuê tháng 11/2026 (khoảng 40 căn): tất cả bàn giao full nội thất, không nuôi thú cưng, thuê tối thiểu 3 tháng (một số studio nhận thuê từ 1 tháng). View gồm 100% sông Hàn, cầu Rồng, cầu Trần Thị Lý, biển và thành phố; khoảng 1/3 số căn trong bảng đã có khách thuê. Căn 3PN 102 m² và căn Dual 105 m² liên hệ giá. Giá thực tế phụ thuộc tầng, view, thời điểm – liên hệ Hoàng Hiệp để nhận danh sách căn đang trống.',
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'sun-ponte-residence' === ( $p['slug'] ?? '' ) ) {
				$projects[ $i ]['meta'] = array_merge( (array) ( $p['meta'] ?? array() ), hh_ponte_rent_data() );
			}
		}
		return $projects;
	},
	40 // Sau hh_dataset_gia_thi_truong (ưu tiên 30).
);

// Ghi đè một lần trên web (kể cả khi ô đã có giá cũ), không cần bấm nhập dữ liệu.
add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_ponte_rent_2026_11' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$post = get_page_by_path( 'sun-ponte-residence', OBJECT, 'du-an' );
		if ( ! $post ) {
			return;
		}
		foreach ( hh_ponte_rent_data() as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
		delete_transient( 'hh_chat_kb' );
		delete_transient( 'hh_chat_faq2' );
		clean_post_cache( $post->ID );
		do_action( 'litespeed_purge_all' ); // Trang dự án, bảng giá thuê hiện giá mới ngay.
		update_option( 'hh_ponte_rent_2026_11', 1, false );
	}
);
