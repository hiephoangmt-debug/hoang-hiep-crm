<?php
/**
 * Sự kiện giới thiệu Sun Saphia Residence 09:00 Chủ nhật 15/11/2026 tại Sun Gallery Đà Nẵng (thư mời chủ đầu tư, anh Hiệp gửi 11/11).
 * Chỉ thay cách HIỂN THỊ trên trang dự án (không ghi vào dữ liệu, trang quản trị vẫn thấy giá trị gốc):
 * – Lịch triển khai: thêm dòng 15/11/2026 (giữ lâu dài).
 * – Đến 12:00 ngày 15/11: tiêu đề khung đăng ký thành lời mời dự sự kiện, thêm câu hỏi đáp về sự kiện; sau đó tự trở lại như cũ.
 */

defined( 'ABSPATH' ) || exit;

function hh_sk_saphia_dang_dien_ra() {
	return time() < strtotime( '2026-11-15 12:00:00 Asia/Ho_Chi_Minh' );
}

add_filter(
	'get_post_metadata',
	static function ( $value, $post_id, $key, $single ) {
		static $busy = false;
		if ( $busy || is_admin() || ! in_array( $key, array( 'hh_p_progress', 'hh_p_offer_title', 'hh_p_faq' ), true ) || 'du-an' !== get_post_type( $post_id ) || 'sun-saphia-residence' !== get_post_field( 'post_name', $post_id ) ) {
			return $value;
		}
		$busy = true;
		$cur  = (string) get_post_meta( $post_id, $key, true );
		$busy = false;
		$new  = $cur;
		if ( 'hh_p_progress' === $key && ! preg_match( '/^15\/11\/2026\s*\|/mu', $cur ) ) {
			$row   = '15/11/2026 | Sự kiện giới thiệu dự án "Chất sống tinh hoa – Giao hòa nắng biển" 09:00 tại Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu';
			$lines = preg_split( '/\R/u', $cur );
			$at    = count( $lines );
			foreach ( $lines as $i => $l ) {
				if ( preg_match( '/^(\d{2})\/(\d{2})\/(\d{4})/', trim( $l ), $d ) && $d[3] . $d[2] . $d[1] > '20261115' ) {
					$at = $i;
					break;
				}
			}
			array_splice( $lines, $at, 0, array( $row ) );
			$new = trim( implode( "\n", $lines ) );
		} elseif ( 'hh_p_offer_title' === $key && hh_sk_saphia_dang_dien_ra() ) {
			$new = 'Mời dự sự kiện giới thiệu 09:00 Chủ nhật 15/11 –';
		} elseif ( 'hh_p_faq' === $key && hh_sk_saphia_dang_dien_ra() && false === strpos( $cur, 'Sun Gallery' ) ) {
			$new = 'Sự kiện giới thiệu Sun Saphia Residence diễn ra khi nào, ở đâu? | 09:00 Chủ nhật 15/11/2026 (đón khách từ 08:30) tại Sun Gallery Đà Nẵng, 01 Phan Đăng Lưu, Hòa Cường; có bốc thăm quà cho khách tham dự. Đăng ký qua Hoàng Hiệp 0904 567 009.' . "\n" . $cur;
		}
		return $single ? $new : array( $new );
	},
	10,
	4
);
