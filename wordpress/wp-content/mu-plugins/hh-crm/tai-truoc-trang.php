<?php
/**
 * Bấm link mở trang nhanh hơn (anh Hiệp 06/11/2026: "nhấp vào link chuyển hơi lâu").
 * Dùng Speculation Rules có sẵn của WordPress: rê chuột / chạm vào link là trình duyệt dựng sẵn trang.
 * - Khách: prerender, mức "moderate" (trang đã có bộ nhớ đệm LiteSpeed nên nhẹ cho máy chủ).
 * - Đã đăng nhập (quản trị): chỉ tải trước (prefetch), mức "moderate" – trang không qua bộ nhớ đệm nên tránh dựng thừa.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'wp_speculation_rules_configuration',
	static function ( $config ) {
		return is_user_logged_in()
			? array( 'mode' => 'prefetch', 'eagerness' => 'moderate' )
			: array( 'mode' => 'prerender', 'eagerness' => 'moderate' );
	},
	20
);
