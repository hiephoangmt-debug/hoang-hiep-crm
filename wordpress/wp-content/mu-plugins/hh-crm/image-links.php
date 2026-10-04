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
function hh_img_links_import( $post_id, $limit = 2 ) {
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
	$tried  = 0;
	$errors = array();
	foreach ( $lines as $n => $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		$url   = esc_url_raw( $parts[0] ?? '' );
		if ( ! $url || isset( $done[ $url ] ) ) {
			continue;
		}
		if ( $tried >= $limit ) {
			$errors[] = 'Còn ảnh chưa tải – sẽ tải tiếp ở lượt sau.';
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
			@set_time_limit( 90 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
		++$tried;
		$tmp = download_url( $source, 30 );
		if ( is_wp_error( $tmp ) ) {
			$errors[] = 'Dòng ' . ( $n + 1 ) . ': không tải được (' . $tmp->get_error_message() . ') – kiểm tra quyền chia sẻ "Bất kỳ ai có đường liên kết".';
			$fails = (int) get_post_meta( $post_id, '_hh_img_fail_' . md5( $url ), true ) + 1;
			update_post_meta( $post_id, '_hh_img_fail_' . md5( $url ), $fails );
			if ( $fails >= 2 ) {
				$done[ $url ] = 'failed'; // Bấm Cập nhật dự án để thử lại.
			}
			continue;
		}
		if ( @filesize( $tmp ) > 15 * MB_IN_BYTES ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors
			wp_delete_file( $tmp );
			$errors[]     = 'Dòng ' . ( $n + 1 ) . ': ảnh lớn hơn 15 MB – giảm dung lượng rồi tải lên tay.';
			$done[ $url ] = 'too-big';
			continue;
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

/** Đưa dự án vào hàng chờ tải ảnh ngầm (WP-Cron) – không tải ngay để trang quản trị không bị quá thời gian. */
function hh_img_links_queue( $post_id ) {
	$queue = array_map( 'absint', (array) get_option( 'hh_img_links_queue', array() ) );
	if ( ! in_array( (int) $post_id, $queue, true ) ) {
		$queue[] = (int) $post_id;
		update_option( 'hh_img_links_queue', $queue, false );
	}
	if ( ! wp_next_scheduled( 'hh_img_links_cron' ) ) {
		wp_schedule_single_event( time() + 5, 'hh_img_links_cron' );
	}
}

/** Số link chưa tải của dự án. */
function hh_img_links_pending( $post_id ) {
	$done = (array) get_post_meta( $post_id, '_hh_img_links', true );
	$n    = 0;
	foreach ( hh_lines( 'hh_p_image_links', $post_id ) as $line ) {
		$url = esc_url_raw( trim( explode( '|', $line )[0] ) );
		if ( $url && ! isset( $done[ $url ] ) ) {
			++$n;
		}
	}
	return $n;
}

/** Mỗi lượt cron tải tối đa 2 ảnh, còn thì hẹn lượt sau. Link lỗi thử lại tối đa 3 lần. */
add_action(
	'hh_img_links_cron',
	static function () {
		$queue = array_values( array_filter( array_map( 'absint', (array) get_option( 'hh_img_links_queue', array() ) ) ) );
		if ( ! $queue ) {
			return;
		}
		$post_id = $queue[0];
		$tries   = (int) get_post_meta( $post_id, '_hh_img_links_tries', true );
		$before  = hh_img_links_pending( $post_id );
		try {
			list( , $errors ) = hh_img_links_import( $post_id, 2 );
			update_post_meta( $post_id, '_hh_img_links_err', $errors );
			$tries = hh_img_links_pending( $post_id ) < $before ? 0 : $tries + 1;
		} catch ( \Throwable $e ) {
			update_post_meta( $post_id, '_hh_img_links_err', array( 'Lỗi khi tải ảnh: ' . $e->getMessage() ) );
			$tries += 1;
		}
		update_post_meta( $post_id, '_hh_img_links_tries', $tries );
		if ( 'du-an' !== get_post_type( $post_id ) || ! hh_img_links_pending( $post_id ) || $tries >= 3 ) {
			array_shift( $queue );
			delete_post_meta( $post_id, '_hh_img_links_tries' );
		}
		update_option( 'hh_img_links_queue', $queue, false );
		if ( $queue ) {
			wp_schedule_single_event( time() + 20, 'hh_img_links_cron' );
		}
	}
);

/** Sau khi lưu dự án (các ô đã ghi ở ưu tiên 10). */
add_action(
	'save_post_du-an',
	static function ( $post_id ) {
		if ( wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}
		// Lưu tay: thử lại các link trước đó tải lỗi.
		$done = (array) get_post_meta( $post_id, '_hh_img_links', true );
		$keep = array_filter( $done, static function ( $v ) { return 'failed' !== $v; } );
		if ( count( $keep ) !== count( $done ) ) {
			update_post_meta( $post_id, '_hh_img_links', $keep );
			foreach ( array_diff_key( $done, $keep ) as $url => $v ) {
				delete_post_meta( $post_id, '_hh_img_fail_' . md5( $url ) );
			}
		}
		if ( hh_img_links_pending( $post_id ) ) {
			hh_img_links_queue( $post_id );
		}
	},
	25
);

/** Thông báo trên trang sửa dự án. */
add_action(
	'admin_notices',
	static function () {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		$post   = get_post();
		if ( ! $screen || 'du-an' !== $screen->post_type || 'post' !== $screen->base || ! $post ) {
			return;
		}
		$pending = hh_img_links_pending( $post->ID );
		$errors  = (array) get_post_meta( $post->ID, '_hh_img_links_err', true );
		$errors  = array_filter( $errors, static function ( $e ) { return is_string( $e ) && 0 !== strpos( $e, 'Còn ảnh chưa tải' ); } );
		$failed  = count( array_keys( (array) get_post_meta( $post->ID, '_hh_img_links', true ), 'failed', true ) );
		if ( $failed ) {
			$errors[] = $failed . ' link tải lỗi 2 lần – kiểm tra Google Drive đã chia sẻ "Bất kỳ ai có đường liên kết", rồi bấm Cập nhật để thử lại.';
		}
		if ( ! $pending && ! $errors ) {
			return;
		}
		$queued = in_array( (int) $post->ID, array_map( 'absint', (array) get_option( 'hh_img_links_queue', array() ) ), true );
		printf(
			'<div class="notice notice-%s"><p>Ảnh từ link: %s%s</p></div>',
			$errors ? 'warning' : 'info',
			$pending ? ( $queued ? 'đang tải ngầm ' . (int) $pending . ' ảnh (vài phút, tải lại trang để xem).' : 'còn ' . (int) $pending . ' ảnh chưa tải – bấm Cập nhật để tải tiếp.' ) : '',
			$errors ? '<br>' . implode( '<br>', array_map( 'esc_html', $errors ) ) : ''
		);
	}
);
