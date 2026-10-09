<?php
/**
 * Gói cập nhật nhanh (.zip) cho ô "Dự án → Nhập nhanh": cập nhật code plugin Hoàng Hiệp CRM và/hoặc giao diện Hoàng Hiệp
 * ngay trên điện thoại, không cần cPanel.
 *
 * Zip chỉ được chứa thư mục gốc "hoang-hiep-crm/" và/hoặc "hoanghiep/" (tạo bằng wordpress/scripts/build-zip.sh →
 * dist/cap-nhat-nhanh.zip). Tệp trong zip được CHÉP ĐÈ lên bản đang chạy; tệp không có trong zip (ảnh dự án…) giữ nguyên,
 * nên gói chỉ cần chứa code – nhẹ, tải lên được cả khi hosting giới hạn 2 MB.
 */

defined( 'ABSPATH' ) || exit;

/** Áp dụng gói .zip. Trả về danh sách dòng kết quả hoặc WP_Error. */
function hh_quick_patch_apply( $zip ) {
	if ( ! current_user_can( 'update_plugins' ) || ! current_user_can( 'update_themes' ) ) {
		return new WP_Error( 'cap', 'Tài khoản không có quyền cập nhật plugin / giao diện.' );
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	if ( ! WP_Filesystem() ) {
		return new WP_Error( 'fs', 'Hosting không cho ghi tệp trực tiếp – cập nhật bằng Plugin → Tải plugin lên.' );
	}
	global $wp_filesystem;

	$tmp = trailingslashit( WP_CONTENT_DIR ) . 'upgrade/hh-patch-' . wp_generate_password( 8, false );
	wp_mkdir_p( $tmp );
	$res = unzip_file( $zip, $tmp );
	if ( is_wp_error( $res ) ) {
		$wp_filesystem->delete( $tmp, true );
		return new WP_Error( 'zip', 'Không giải nén được gói: ' . $res->get_error_message() );
	}

	$targets = array(
		'hoang-hiep-crm' => dirname( HH_CRM_DIR ),
		'hoanghiep'      => get_theme_root() . '/hoanghiep',
	);
	$found = array_values( array_diff( scandir( $tmp ), array( '.', '..', '__MACOSX' ) ) );
	if ( ! $found || array_diff( $found, array_keys( $targets ) ) ) {
		$wp_filesystem->delete( $tmp, true );
		return new WP_Error( 'zip', 'Gói không đúng – zip chỉ được chứa thư mục hoang-hiep-crm/ và/hoặc hoanghiep/.' );
	}

	$lines = array();
	foreach ( $found as $name ) {
		$dest = $targets[ $name ];
		if ( 'hoang-hiep-crm' === $name && 'hoang-hiep-crm' !== basename( $dest ) ) {
			$lines[] = 'Bỏ qua plugin: bản đang chạy không nằm trong thư mục plugins/hoang-hiep-crm.';
			continue;
		}
		if ( ! is_dir( $dest ) ) {
			$lines[] = 'Bỏ qua ' . $name . ': chưa cài trên web.';
			continue;
		}
		$copied = copy_dir( "$tmp/$name", $dest );
		if ( is_wp_error( $copied ) ) {
			$wp_filesystem->delete( $tmp, true );
			return new WP_Error( 'copy', 'Chép tệp lỗi (' . $name . '): ' . $copied->get_error_message() );
		}
		$file    = 'hoang-hiep-crm' === $name ? "$dest/hoang-hiep-crm.php" : "$dest/style.css";
		$ver     = get_file_data( $file, array( 'v' => 'Version' ) )['v'] ?? '';
		$lines[] = ( 'hoang-hiep-crm' === $name ? 'Plugin Hoàng Hiệp CRM' : 'Giao diện Hoàng Hiệp' ) . ' → phiên bản ' . $ver;
	}
	$wp_filesystem->delete( $tmp, true );
	if ( function_exists( 'opcache_reset' ) ) {
		opcache_reset(); // Code mới có hiệu lực ngay.
	}
	return $lines;
}
