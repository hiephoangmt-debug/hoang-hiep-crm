<?php
/**
 * Mã theo dõi Metricool (anh Hiệp yêu cầu 13/11/2026) – kết nối hiephoangmt.com với brand
 * "Sun Đà Nẵng by Hoàng Hiệp" trên Metricool để thống kê lượt xem web cùng Facebook.
 * Đoạn mã giống hệt plugin chính thức của Metricool (views/public/tracking-script.php),
 * không dùng cookie. Không chèn cho tài khoản đang đăng nhập quản trị để số liệu không bị lẫn.
 * Đổi brand: thay HH_METRICOOL_HASH bằng hash của brand khác (Hoàng Hiệp BĐS Đà Nẵng: 2a069f12db8a9ff858eaad6c47bf443d).
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HH_METRICOOL_HASH' ) ) {
	define( 'HH_METRICOOL_HASH', '98e3ebf035a1741f40952af350e2e637' );
}

add_action(
	'wp_head',
	static function () {
		if ( is_admin() || current_user_can( 'edit_posts' ) || current_user_can( 'hh_sale_portal' ) || '' === HH_METRICOOL_HASH ) {
			return;
		}
		$src  = 'https://tracker.metricool.com/resources/be.js';
		$hash = HH_METRICOOL_HASH;
		echo '<script data-no-optimize="1" data-cfasync="false">function loadScript(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.type="text/javascript",c.src="' . esc_attr( $src ) . '",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}loadScript(function(){beTracker.t({hash:"' . esc_html( $hash ) . '"})});</script>' . "\n";
	},
	20
);
