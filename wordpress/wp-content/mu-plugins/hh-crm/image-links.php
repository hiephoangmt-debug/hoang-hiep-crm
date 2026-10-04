<?php
/**
 * Ảnh từ link (Google Drive hoặc link ảnh trực tiếp): dán link vào ô "Link ảnh" của dự án, máy chủ web tự tải ảnh về
 * Thư viện, gắn vào Thư viện ảnh / Ảnh tiện ích / Ảnh mặt bằng, và đặt ảnh đại diện nếu dự án chưa có.
 * Mỗi dòng: Link | Chú thích (alt) | Mục: thư viện (mặc định) / tiện ích / mặt bằng / đại diện.
 * Link Google Drive phải chia sẻ "Bất kỳ ai có đường liên kết"; link THƯ MỤC không tải được – dán link từng file.
 * Mỗi link chỉ tải một lần (ghi nhớ trong _hh_img_links).
 */

defined( 'ABSPATH' ) || exit;

/** Link Drive / Docs → link tải trực tiếp; trả về '' nếu là link thư mục. */
function hh_img_link_download_url( $url ) {
	if ( preg_match( '#drive\.google\.com/drive/(u/\d+/)?folders/#', $url ) ) {
		return '';
	}
	if ( preg_match( '#drive\.google\.com/(?:file/d/|open\?id=|uc\?(?:[^"\s]*&)?id=)([\w-]{10,})#', $url, $m ) ) {
		return 'https://drive.google.com/uc?export=download&id=' . $m[1];
	}
	return $url;
}

/** Tải các link chưa tải của một dự án. Trả về array( số ảnh mới, danh sách lỗi ). */
function hh_img_links_import( $post_id, $limit = 15 ) {
	$lines = hh_lines( 'hh_p_image_links', $post_id );
	if ( ! $lines ) {
		return array( 0, array() );
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$done   = (array) get_post_meta( $post_id, '_hh_img_links', true );
	$title  = get_the_title( $post_id );
	$targets = array(
		'thu-vien' => 'hh_p_gallery',
		'tien-ich' => 'hh_p_amenities_img',
		'mat-bang' => 'hh_p_floorplans',
	);
	$added  = 0;
	$errors = array();
	foreach ( $lines as $n => $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		$url   = esc_url_raw( $parts[0] ?? '' );
		if ( ! $url || isset( $done[ $url ] ) ) {
			continue;
		}
		if ( $added >= $limit ) {
			$errors[] = 'Còn ảnh chưa tải – bấm Cập nhật lần nữa để tải tiếp.';
			break;
		}
		$alt    = $parts[1] ?? '';
		$where  = sanitize_title( remove_accents( $parts[2] ?? '' ) );
		$where  = preg_match( '/tien-ich/', $where ) ? 'tien-ich' : ( preg_match( '/mat-bang/', $where ) ? 'mat-bang' : ( preg_match( '/dai-dien/', $where ) ? 'dai-dien' : 'thu-vien' ) );
		$source = hh_img_link_download_url( $url );
		if ( '' === $source ) {
			$errors[]     = 'Dòng ' . ( $n + 1 ) . ': link thư mục Drive không tải được – mở thư mục, bấm chuột phải từng ảnh → Chia sẻ → Sao chép đường liên kết.';
			$done[ $url ] = 'folder';
			continue;
		}
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 120 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
		$tmp = download_url( $source, 60 );
		if ( is_wp_error( $tmp ) ) {
			$errors[] = 'Dòng ' . ( $n + 1 ) . ': không tải được (' . $tmp->get_error_message() . ') – kiểm tra quyền chia sẻ "Bất kỳ ai có đường liên kết".';
			continue; // Thử lại lần sau.
		}
		$info = @getimagesize( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		$ext  = array( 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif' )[ $info['mime'] ?? '' ] ?? '';
		if ( ! $ext ) {
			wp_delete_file( $tmp );
			$errors[]     = 'Dòng ' . ( $n + 1 ) . ': file không phải ảnh (có thể là PDF / video) – bỏ qua.';
			$done[ $url ] = 'not-image';
			continue;
		}
		$name = sanitize_title( remove_accents( $alt ?: $title ) ) . '-' . ( count( array_filter( $done, 'is_int' ) ) + 1 ) . '.' . $ext;
		$id   = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), $post_id, $alt ?: $title );
		if ( is_wp_error( $id ) ) {
			wp_delete_file( $tmp );
			$errors[] = 'Dòng ' . ( $n + 1 ) . ': ' . $id->get_error_message();
			continue;
		}
		update_post_meta( $id, '_wp_attachment_image_alt', $alt ?: $title );
		if ( $alt ) {
			wp_update_post( array( 'ID' => $id, 'post_excerpt' => $alt ) );
		}
		if ( 'dai-dien' === $where || ! has_post_thumbnail( $post_id ) ) {
			set_post_thumbnail( $post_id, $id );
		}
		if ( 'dai-dien' !== $where ) {
			$key = $targets[ $where ];
			$ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post_id, $key, true ) ) ) );
			$ids[] = $id;
			update_post_meta( $post_id, $key, implode( ',', array_unique( $ids ) ) );
		}
		$done[ $url ] = (int) $id;
		++$added;
	}
	update_post_meta( $post_id, '_hh_img_links', $done );
	return array( $added, $errors );
}

/** Sau khi lưu dự án (các ô đã ghi ở ưu tiên 10). */
add_action(
	'save_post_du-an',
	static function ( $post_id ) {
		if ( wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'upload_files' ) ) {
			return;
		}
		list( $added, $errors ) = hh_img_links_import( $post_id );
		if ( $added || $errors ) {
			set_transient( 'hh_img_links_msg_' . get_current_user_id(), array( $added, $errors ), 120 );
		}
	},
	25
);

add_action(
	'admin_notices',
	static function () {
		$msg = get_transient( 'hh_img_links_msg_' . get_current_user_id() );
		if ( ! $msg ) {
			return;
		}
		delete_transient( 'hh_img_links_msg_' . get_current_user_id() );
		printf(
			'<div class="notice notice-%s is-dismissible"><p>Ảnh từ link: đã tải %d ảnh.%s</p></div>',
			$msg[1] ? 'warning' : 'success',
			(int) $msg[0],
			$msg[1] ? '<br>' . implode( '<br>', array_map( 'esc_html', $msg[1] ) ) : ''
		);
	}
);
