<?php
/**
 * Tự đăng bài: mỗi giờ web đọc danh sách bài (index.json) trong thư mục wordpress/tu-dong/ của kho code công khai
 * hiephoangmt-debug/hoang-hiep-crm, bài nào tới giờ đăng thì tải gói bài (HHBAI1, có ảnh) và đăng luôn – không cần
 * tải gói zip hay dán gói bài. Bật / tắt và xem nhật ký tại Dự án → Tự đăng bài.
 *
 * index.json: { "posts": [ { "slug": "…", "publish": "2026-10-20 08:00", "file": "bai/slug.txt" }, … ] } – giờ Việt Nam.
 * Không ghi đè bài đã có cùng đường dẫn, trừ bài do web tự tạo mà chưa ai sửa tay (Lên lịch / Bản nháp).
 */

defined( 'ABSPATH' ) || exit;

const HH_AUTO_FEED = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/refs/heads/claude/wordpress-hiephoangmt-domain-rf8u3u/wordpress/tu-dong/';

// Kiểm tra danh sách bài mỗi 15 phút; ngoài ra hẹn riêng đúng phút đăng của bài kế tiếp (hh_auto_posts_at).
add_filter(
	'cron_schedules',
	static function ( $s ) {
		$s['hh_15min'] = array( 'interval' => 15 * MINUTE_IN_SECONDS, 'display' => 'Mỗi 15 phút' );
		return $s;
	}
);
add_action(
	'init',
	static function () {
		$next = wp_get_scheduled_event( 'hh_auto_posts' );
		if ( $next && 'hh_15min' !== $next->schedule ) {
			wp_clear_scheduled_hook( 'hh_auto_posts' ); // Bản cũ chạy mỗi giờ → đổi sang 15 phút.
			$next = false;
		}
		if ( ! $next ) {
			wp_schedule_event( time() + 60, 'hh_15min', 'hh_auto_posts' );
		}
	}
);
add_action( 'hh_auto_posts', 'hh_auto_posts_run' );
add_action( 'hh_auto_posts_at', 'hh_auto_posts_run' );

/*
 * Trang được LiteSpeed lưu đệm nên lượt xem không chạy được lịch hẹn của WordPress.
 * Trình duyệt khách gọi nhẹ wp-cron.php (tối đa 5 phút/lần mỗi khách) để lịch chạy đúng giờ.
 */
add_action(
	'wp_footer',
	static function () {
		if ( is_admin() || '0' === (string) get_option( 'hh_auto_posts_on', '1' ) ) {
			return;
		}
		$url = wp_json_encode( site_url( 'wp-cron.php' ) );
		echo "<script>try{var hk='hhCron',hn=Date.now();if(!(hn-(+sessionStorage.getItem(hk)||0)<3e5)){sessionStorage.setItem(hk,hn);fetch($url,{credentials:'omit',keepalive:true}).catch(function(){});}}catch(e){}</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	},
	99
);

/** Hẹn chạy đúng phút đăng của bài sắp tới gần nhất (cộng 20 giây). */
function hh_auto_posts_schedule_next( $index, $done ) {
	$tz   = new DateTimeZone( 'Asia/Ho_Chi_Minh' );
	$next = 0;
	foreach ( (array) ( $index['posts'] ?? array() ) as $item ) {
		$slug = sanitize_title( (string) ( $item['slug'] ?? '' ) );
		$at   = date_create( (string) ( $item['publish'] ?? '' ), $tz );
		if ( ! $slug || ! $at || isset( $done[ $slug ] ) ) {
			continue;
		}
		$ts = max( $at->getTimestamp(), time() + 100 ); // Bài tới hạn còn sót (lượt trước giới hạn 3 bài, lỗi mạng) → thử lại sau ~2 phút.
		if ( ! $next || $ts < $next ) {
			$next = $ts;
		}
	}
	$current = wp_next_scheduled( 'hh_auto_posts_at' );
	if ( $next && $current === $next + 20 ) {
		return;
	}
	wp_clear_scheduled_hook( 'hh_auto_posts_at' );
	if ( $next ) {
		wp_schedule_single_event( $next + 20, 'hh_auto_posts_at' );
	}
}

/** Ghi nhật ký (giữ 40 dòng gần nhất). */
function hh_auto_posts_log( $msg ) {
	$log   = (array) get_option( 'hh_auto_posts_log', array() );
	$log[] = wp_date( 'd/m H:i' ) . ' – ' . $msg;
	update_option( 'hh_auto_posts_log', array_slice( $log, -40 ), false );
}

/** Tải một tệp trong thư mục tu-dong/ của kho code. */
function hh_auto_posts_get( $path ) {
	$res = wp_remote_get( apply_filters( 'hh_auto_feed_url', HH_AUTO_FEED ) . ltrim( $path, '/' ) . '?t=' . time(), array( 'timeout' => 20 ) );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	if ( 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
		return new WP_Error( 'http', 'HTTP ' . wp_remote_retrieve_response_code( $res ) . ' khi tải ' . $path );
	}
	return (string) wp_remote_retrieve_body( $res );
}

/**
 * Kiểm tra danh sách, đăng các bài đã tới giờ. Trả về số bài vừa đăng.
 */
function hh_auto_posts_run( $force = false ) {
	if ( ! $force && '0' === (string) get_option( 'hh_auto_posts_on', '1' ) ) {
		return 0;
	}
	if ( get_transient( 'hh_auto_posts_lock' ) ) {
		return 0;
	}
	set_transient( 'hh_auto_posts_lock', 1, 10 * MINUTE_IN_SECONDS );
	update_option( 'hh_auto_posts_checked', time(), false );
	$raw   = hh_auto_posts_get( 'index.json' );
	$index = is_wp_error( $raw ) ? null : json_decode( $raw, true );
	if ( ! is_array( $index ) || ! isset( $index['posts'] ) ) {
		hh_auto_posts_log( 'Không đọc được danh sách bài' . ( is_wp_error( $raw ) ? ': ' . $raw->get_error_message() : '' ) );
		delete_transient( 'hh_auto_posts_lock' );
		return 0;
	}
	if ( ! get_current_user_id() ) { // Chạy theo lịch: đứng tên quản trị viên đầu tiên (tác giả bài).
		$admin = get_users( array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID', 'fields' => 'ID' ) );
		if ( $admin ) {
			wp_set_current_user( (int) $admin[0] );
		}
	}
	$done = (array) get_option( 'hh_auto_posts_done', array() );
	$revs = (array) get_option( 'hh_auto_posts_rev', array() ); // Phiên bản nội dung đã áp dụng cho từng bài.
	$tz   = new DateTimeZone( 'Asia/Ho_Chi_Minh' );
	$made = 0;
	foreach ( (array) $index['posts'] as $item ) {
		$slug = sanitize_title( (string) ( $item['slug'] ?? '' ) );
		$at   = date_create( (string) ( $item['publish'] ?? '' ), $tz );
		$file = (string) ( $item['file'] ?? '' );
		$rev  = (int) ( $item['rev'] ?? 1 );
		if ( ! $slug || ! $at || ! preg_match( '#^[a-z0-9/_.-]+\.txt$#', $file ) || $at->getTimestamp() > time() ) {
			continue;
		}
		if ( isset( $done[ $slug ] ) ) {
			// Bài đã đăng có bản sửa mới (rev tăng): cập nhật nếu chưa ai sửa tay.
			if ( ! is_int( $done[ $slug ] ) || $rev <= (int) ( $revs[ $slug ] ?? 1 ) ) {
				continue;
			}
			$pack = hh_auto_posts_get( $file );
			$n    = is_wp_error( $pack ) ? $pack : hh_quick_post_decode( $pack );
			$res  = is_wp_error( $n ) ? $n : hh_auto_post_update( $done[ $slug ], $n );
			if ( is_wp_error( $res ) && 'http' === $res->get_error_code() ) {
				hh_auto_posts_log( $slug . ': ' . $res->get_error_message() );
				continue; // Lỗi mạng – thử lại lượt sau.
			}
			$revs[ $slug ] = $rev;
			hh_auto_posts_log( is_wp_error( $res ) ? $slug . ': không cập nhật – ' . $res->get_error_message() : 'Đã cập nhật: ' . get_the_title( $res ) );
			$made += is_wp_error( $res ) ? 0 : 1;
			if ( $made >= 3 ) {
				break;
			}
			continue;
		}
		$revs[ $slug ] = $rev;
		$pack = hh_auto_posts_get( $file );
		$n    = is_wp_error( $pack ) ? $pack : hh_quick_post_decode( $pack );
		if ( is_wp_error( $n ) ) {
			hh_auto_posts_log( $slug . ': ' . $n->get_error_message() );
			continue;
		}
		$id = hh_auto_post_publish( $n, $at->getTimestamp() );
		if ( is_wp_error( $id ) ) {
			hh_auto_posts_log( $slug . ': ' . $id->get_error_message() );
			$done[ $slug ] = 'bo-qua';
			continue;
		}
		$done[ $slug ] = (int) $id;
		++$made;
		hh_auto_posts_log( 'Đã đăng: ' . get_the_title( $id ) );
		if ( $made >= 3 ) {
			break; // Mỗi lượt tối đa 3 bài – tránh quá tải.
		}
	}
	update_option( 'hh_auto_posts_done', $done, false );
	update_option( 'hh_auto_posts_rev', $revs, false );
	hh_auto_posts_schedule_next( $index, $done );
	if ( $made ) {
		do_action( 'litespeed_purge_all' ); // Xoá bộ nhớ đệm LiteSpeed để bài mới hiện ngay.
	}
	delete_transient( 'hh_auto_posts_lock' );
	return $made;
}

/**
 * Tạo bài từ gói (dùng chung trình Nhập nhanh) rồi đăng với ngày giờ hẹn.
 * Bài cùng đường dẫn đã có: chỉ thay bài do web tự tạo, chưa đăng và chưa sửa tay; còn lại bỏ qua.
 */
function hh_auto_post_publish( $n, $ts ) {
	if ( ! empty( $n['kind'] ) ) {
		return new WP_Error( 'kind', 'Gói không phải bài tin tức.' );
	}
	$n['content'] = wp_kses_post( (string) $n['content'] );
	$old          = get_posts( array( 'name' => $n['slug'], 'post_type' => 'post', 'post_status' => array( 'publish', 'future', 'draft', 'pending', 'private' ), 'numberposts' => 1 ) )[0] ?? null;
	if ( $old ) {
		$auto  = get_post_meta( $old->ID, '_hh_news_hash', true ) === md5( $old->post_content ) || get_post_meta( $old->ID, '_hh_auto_post', true );
		if ( 'publish' === $old->post_status || ! $auto ) {
			return new WP_Error( 'exists', 'đã có bài cùng đường dẫn (giữ nguyên).' );
		}
		wp_update_post( array( 'ID' => $old->ID, 'post_status' => 'draft' ) ); // Trình Nhập nhanh chỉ cập nhật bản nháp.
	}
	$id = hh_quick_post_create( $n );
	if ( is_wp_error( $id ) ) {
		return $id;
	}
	$date = wp_date( 'Y-m-d H:i:s', $ts );
	wp_update_post(
		array(
			'ID'            => $id,
			'post_status'   => 'publish',
			'post_date'     => $date,
			'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $ts ),
			'edit_date'     => true,
		)
	);
	update_post_meta( $id, '_hh_auto_post', current_time( 'mysql' ) );
	update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
	return $id;
}

/**
 * Cập nhật bài đã tự đăng theo gói mới: chỉ khi bài do web tự đăng và nội dung chưa bị sửa tay.
 * Giữ nguyên ngày đăng, đường dẫn và ảnh đại diện.
 */
function hh_auto_post_update( $id, $n ) {
	$post = get_post( $id );
	if ( ! $post || 'post' !== $post->post_type || ! get_post_meta( $id, '_hh_auto_post', true ) ) {
		return new WP_Error( 'missing', 'bài không còn hoặc không do web tự đăng.' );
	}
	if ( get_post_meta( $id, '_hh_news_hash', true ) !== md5( $post->post_content ) ) {
		return new WP_Error( 'edited', 'bài đã được sửa tay (giữ nguyên).' );
	}
	if ( ! empty( $n['kind'] ) || $n['slug'] !== $post->post_name ) {
		return new WP_Error( 'kind', 'gói không khớp bài.' );
	}
	$n['content'] = wp_kses_post( (string) $n['content'] );
	$keep         = array( 'post_status' => $post->post_status, 'post_date' => $post->post_date, 'post_date_gmt' => $post->post_date_gmt );
	wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) ); // Trình Nhập nhanh chỉ ghi vào bản nháp.
	if ( ! empty( $n['image_replace'] ) && ! empty( $n['image'] ) ) {
		delete_post_thumbnail( $id ); // Gói đánh dấu thay ảnh đại diện (ảnh cũ có số liệu sai).
	}
	$new = hh_quick_post_create( $n );
	wp_update_post( array( 'ID' => $id ) + $keep + array( 'edit_date' => true ) );
	if ( is_wp_error( $new ) ) {
		return $new;
	}
	update_post_meta( $id, '_hh_news_hash', md5( get_post_field( 'post_content', $id ) ) );
	return $id;
}

/* ---------------- Trang quản trị: Dự án → Tự đăng bài ---------------- */

add_action(
	'admin_menu',
	static function () {
		add_submenu_page( 'edit.php?post_type=du-an', 'Tự đăng bài', 'Tự đăng bài', 'manage_options', 'hh-tu-dong-dang-bai', 'hh_auto_posts_page' );
	}
);

function hh_auto_posts_page() {
	$msg = '';
	if ( isset( $_POST['hh_auto_save'] ) && check_admin_referer( 'hh_auto_posts' ) ) {
		update_option( 'hh_auto_posts_on', empty( $_POST['on'] ) ? '0' : '1' );
		$msg = 'Đã lưu.';
		if ( ! empty( $_POST['run_now'] ) ) {
			delete_transient( 'hh_auto_posts_lock' );
			$msg .= ' Vừa đăng ' . hh_auto_posts_run( true ) . ' bài.';
		}
	}
	$on      = '0' !== (string) get_option( 'hh_auto_posts_on', '1' );
	$checked = (int) get_option( 'hh_auto_posts_checked' );
	$next    = wp_next_scheduled( 'hh_auto_posts' );
	$raw     = hh_auto_posts_get( 'index.json' );
	$index   = is_wp_error( $raw ) ? array() : (array) json_decode( $raw, true );
	$done    = (array) get_option( 'hh_auto_posts_done', array() );
	?>
	<div class="wrap">
		<h1>Tự đăng bài</h1>
		<?php if ( $msg ) : ?><div class="notice notice-success"><p><?php echo esc_html( $msg ); ?></p></div><?php endif; ?>
		<p>Web tự đọc danh sách bài Hoàng Hiệp / Claude soạn sẵn và đăng đúng ngày giờ hẹn (kiểm tra mỗi giờ), kèm ảnh đại diện, tiêu đề – mô tả – từ khoá Rank Math, hỏi đáp. Không ghi đè bài anh đã sửa tay.</p>
		<form method="post">
			<?php wp_nonce_field( 'hh_auto_posts' ); ?>
			<p><label><input type="checkbox" name="on" value="1" <?php checked( $on ); ?>> Bật tự đăng bài</label></p>
			<p><label><input type="checkbox" name="run_now" value="1"> Kiểm tra và đăng bài tới hạn ngay bây giờ</label></p>
			<p><button class="button button-primary" name="hh_auto_save" value="1">Lưu</button></p>
		</form>
		<p>Lần kiểm tra gần nhất: <?php echo $checked ? esc_html( wp_date( 'd/m/Y H:i', $checked ) ) : 'chưa'; ?> · Lần tới: <?php echo $next ? esc_html( wp_date( 'd/m/Y H:i', $next ) ) : '–'; ?><?php $at_next = wp_next_scheduled( 'hh_auto_posts_at' ); echo $at_next ? ' · Hẹn đăng bài kế tiếp: ' . esc_html( wp_date( 'd/m/Y H:i', $at_next ) ) : ''; ?></p>
		<h2>Lịch bài</h2>
		<table class="widefat striped"><thead><tr><th>Giờ đăng</th><th>Bài</th><th>Trạng thái</th></tr></thead><tbody>
		<?php foreach ( (array) ( $index['posts'] ?? array() ) as $item ) : ?>
			<?php $s = sanitize_title( (string) ( $item['slug'] ?? '' ) ); $d = $done[ $s ] ?? null; ?>
			<tr><td><?php echo esc_html( (string) ( $item['publish'] ?? '' ) ); ?></td><td><?php echo esc_html( (string) ( $item['title'] ?? $s ) ); ?></td>
			<td><?php echo is_int( $d ) ? '<a href="' . esc_url( get_permalink( $d ) ) . '" target="_blank">Đã đăng</a>' : ( $d ? 'Bỏ qua (đã có bài)' : 'Chờ' ); ?></td></tr>
		<?php endforeach; ?>
		</tbody></table>
		<h2>Nhật ký</h2>
		<pre style="background:#fff;padding:10px;max-height:260px;overflow:auto"><?php echo esc_html( implode( "\n", array_reverse( (array) get_option( 'hh_auto_posts_log', array() ) ) ) ); ?></pre>
	</div>
	<?php
}
