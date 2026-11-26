<?php
/**
 * Tự cập nhật plugin Hoàng Hiệp CRM + giao diện Hoàng Hiệp từ kho code công khai (anh Hiệp yêu cầu 25/11/2026:
 * "Làm tự cập nhật" – giống cổng self-update của danangstay.com.vn).
 *
 * Cách chạy:
 * - Kho code có wordpress/tu-dong/cap-nhat/version.json = { version, theme, commit, manifest_sha }. manifest.json liệt kê
 *   từng tệp (đường dẫn trên web, đường dẫn trong kho, sha256, dung lượng) ở đúng commit đó – tải bằng đường dẫn có mã
 *   commit nên không bị lệch bản do bộ nhớ đệm của GitHub.
 * - Web kiểm tra mỗi giờ; ngoài ra phiên Claude gọi POST /wp-json/hh/v1/self-update (kèm khoá bí mật ở tiêu đề X-HH-Key)
 *   ngay sau khi đẩy code để web cập nhật trong vài phút. Người gọi KHÔNG gửi được code: web chỉ tải từ đúng kho, đúng nhánh.
 * - Tệp code (.php, .js, .css, .json…) tải hết về thư mục tạm, kiểm tra sha256 + cú pháp PHP, sao lưu bản cũ rồi mới chép đè
 *   một lượt. Sau đó web tự gọi /wp-json/hh/v1/su-ping (chạy bằng code mới); lỗi → chép lại bản cũ ngay.
 * - Thành công → hẹn "Nhập / cập nhật dữ liệu" + xoá bộ nhớ đệm LiteSpeed ở lượt chạy kế tiếp (code mới); ảnh mới tải dần
 *   từng đợt để không quá thời gian chạy của hosting.
 * Bật / tắt, tạo khoá, xem nhật ký: Dự án → Tự cập nhật.
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

const HH_SU_REPO = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/';
const HH_SU_REF  = 'refs/heads/claude/wordpress-hiephoangmt-domain-rf8u3u';

/* ---------------------------------------------------------------- Tiện ích ---------------------------------------------------------------- */

function hh_su_enabled() {
	return '0' !== (string) get_option( 'hh_su_enabled', '1' );
}

function hh_su_log( $msg ) {
	$log   = (array) get_option( 'hh_su_log', array() );
	$log[] = array( time(), (string) $msg );
	update_option( 'hh_su_log', array_slice( $log, -40 ), false );
}

/** Thư mục gốc trên web cho từng nhóm tệp: p = plugin, t = giao diện. */
function hh_su_roots() {
	$roots = array();
	$p     = dirname( HH_CRM_DIR );
	if ( 'hoang-hiep-crm' === basename( $p ) && is_dir( $p ) ) {
		$roots['p'] = $p;
	}
	$t = get_theme_root() . '/hoanghiep';
	if ( is_dir( $t ) ) {
		$roots['t'] = $t;
	}
	return $roots;
}

function hh_su_fetch( $url, $timeout = 30 ) {
	$res = wp_remote_get( $url, array( 'timeout' => $timeout, 'redirection' => 2 ) );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	if ( 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
		return new WP_Error( 'http', 'HTTP ' . wp_remote_retrieve_response_code( $res ) . ' – ' . $url );
	}
	return (string) wp_remote_retrieve_body( $res );
}

/** Đường dẫn an toàn (không "..", chỉ ký tự thường gặp). */
function hh_su_safe_path( $rel ) {
	return is_string( $rel ) && '' !== $rel && ! preg_match( '#(^|/)\.\.(/|$)#', $rel ) && preg_match( '#^[A-Za-z0-9._/@+-]+$#', $rel ) && '/' !== $rel[0];
}

/** sha256 tệp trên web, có nhớ theo (dung lượng, giờ sửa) để không băm lại hàng trăm MB ảnh mỗi lần. */
function hh_su_local_sha( $abs, &$cache ) {
	if ( ! is_file( $abs ) ) {
		return '';
	}
	$k = md5( $abs );
	$s = filesize( $abs ) . ':' . filemtime( $abs );
	if ( isset( $cache[ $k ] ) && $cache[ $k ][0] === $s ) {
		return $cache[ $k ][1];
	}
	$h           = (string) hash_file( 'sha256', $abs );
	$cache[ $k ] = array( $s, $h );
	return $h;
}

function hh_su_is_code( $rel ) {
	return (bool) preg_match( '/\.(php|js|css|json|html?|txt|md|htaccess|svg)$/i', $rel ) || false === strpos( basename( $rel ), '.' );
}

function hh_su_php_ok( $code ) {
	try {
		token_get_all( $code, TOKEN_PARSE );
		return true;
	} catch ( \Throwable $e ) {
		return false;
	}
}

/* ---------------------------------------------------------------- Chạy cập nhật ---------------------------------------------------------------- */

/**
 * Một lượt cập nhật. Trả về chuỗi kết quả ngắn (đồng thời ghi nhật ký).
 * $force = true: bỏ qua so sánh manifest đã áp dụng (nút "Kiểm tra ngay").
 */
function hh_su_run( $force = false ) {
	if ( ! hh_su_enabled() ) {
		return 'Đang tắt tự cập nhật.';
	}
	if ( get_transient( 'hh_su_lock' ) ) {
		return 'Đang có lượt cập nhật khác chạy.';
	}
	set_transient( 'hh_su_lock', 1, 10 * MINUTE_IN_SECONDS );
	try {
		$out = hh_su_run_inner( $force );
	} catch ( \Throwable $e ) {
		$out = 'Lỗi: ' . $e->getMessage();
		hh_su_log( $out );
	}
	delete_transient( 'hh_su_lock' );
	update_option( 'hh_su_last_check', time(), false );
	return $out;
}

function hh_su_run_inner( $force ) {
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 420 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	$repo = (string) apply_filters( 'hh_su_repo', HH_SU_REPO );
	$ver  = hh_su_fetch( $repo . HH_SU_REF . '/wordpress/tu-dong/cap-nhat/version.json?t=' . time(), 20 );
	if ( is_wp_error( $ver ) ) {
		return 'Không đọc được version.json: ' . $ver->get_error_message();
	}
	$v = json_decode( $ver, true );
	if ( ! is_array( $v ) || empty( $v['commit'] ) || ! preg_match( '/^[0-9a-f]{40}$/', (string) $v['commit'] ) || empty( $v['manifest_sha'] ) ) {
		return 'version.json không hợp lệ.';
	}
	$applied = (string) get_option( 'hh_su_applied', '' );
	$pending = (array) get_option( 'hh_su_img_queue', array() );
	if ( ! $force && $applied === $v['manifest_sha'] ) {
		if ( ! empty( $pending['items'] ) && ! wp_next_scheduled( 'hh_su_images' ) ) {
			wp_schedule_single_event( time() + 10, 'hh_su_images' );
		}
		return 'Đã là bản mới nhất (' . HH_CRM_VERSION . ').';
	}
	if ( version_compare( (string) $v['version'], HH_CRM_VERSION, '<' ) ) {
		return 'Bản trên kho (' . $v['version'] . ') cũ hơn bản đang chạy (' . HH_CRM_VERSION . ') – bỏ qua.';
	}
	$base = $repo . $v['commit'] . '/wordpress/';
	$man  = hh_su_fetch( $repo . HH_SU_REF . '/wordpress/tu-dong/cap-nhat/manifest.json?t=' . time(), 60 ); // Tệp code tải theo mã commit ($base).
	if ( is_wp_error( $man ) ) {
		return 'Không đọc được manifest: ' . $man->get_error_message();
	}
	if ( ! hash_equals( (string) $v['manifest_sha'], hash( 'sha256', $man ) ) ) {
		return 'Manifest không khớp mã kiểm tra – thử lại sau.';
	}
	$m = json_decode( $man, true );
	if ( ! is_array( $m ) || empty( $m['files'] ) || ! is_array( $m['files'] ) ) {
		return 'Manifest không hợp lệ.';
	}
	$roots = hh_su_roots();
	$cache = (array) get_option( 'hh_su_hash_cache', array() );
	$code  = array();
	$imgs  = array();
	foreach ( $m['files'] as $f ) {
		list( $grp, $rel, $src, $sha ) = array_pad( (array) $f, 4, '' );
		if ( empty( $roots[ $grp ] ) || ! hh_su_safe_path( $rel ) || ! hh_su_safe_path( $src ) || ! preg_match( '/^[0-9a-f]{64}$/', $sha ) ) {
			continue;
		}
		$abs = $roots[ $grp ] . '/' . $rel;
		if ( hh_su_local_sha( $abs, $cache ) === $sha ) {
			continue;
		}
		$item = array( $abs, $src, $sha, $rel );
		if ( hh_su_is_code( $rel ) ) {
			$code[] = $item;
		} else {
			$imgs[] = $item;
		}
	}
	update_option( 'hh_su_hash_cache', $cache, false );

	$msg = array();
	if ( $code ) {
		$r = hh_su_apply_code( $code, $base, (string) $v['version'] );
		if ( is_wp_error( $r ) ) {
			hh_su_log( 'Không cập nhật code: ' . $r->get_error_message() );
			return 'Không cập nhật code: ' . $r->get_error_message();
		}
		$msg[] = 'đã cập nhật ' . count( $code ) . ' tệp code lên ' . $v['version'];
		update_option( 'hh_su_need_import', 1, false );
		wp_schedule_single_event( time() + 5, 'hh_su_after' );
	}
	update_option( 'hh_su_applied', $v['manifest_sha'], false );
	update_option( 'hh_su_img_queue', array( 'base' => $base, 'items' => $imgs ), false );
	if ( $imgs ) {
		$msg[] = count( $imgs ) . ' ảnh mới chờ tải dần';
		wp_schedule_single_event( time() + 30, 'hh_su_images' );
	}
	if ( ! $msg ) {
		$msg[] = 'không có tệp nào khác bản trên web';
	}
	$text = 'Bản ' . $v['version'] . ': ' . implode( ', ', $msg ) . '.';
	hh_su_log( $text );
	if ( function_exists( 'spawn_cron' ) ) {
		spawn_cron();
	}
	return $text;
}

/** Tải – kiểm tra – sao lưu – chép đè – tự kiểm tra; lỗi thì trả lại bản cũ. */
function hh_su_apply_code( $items, $base, $version ) {
	$stage = trailingslashit( WP_CONTENT_DIR ) . 'upgrade/hh-su-' . wp_generate_password( 8, false, false );
	$bak   = trailingslashit( WP_CONTENT_DIR ) . 'upgrade/hh-su-backup';
	wp_mkdir_p( $stage );
	$clean = static function () use ( $stage ) {
		foreach ( glob( $stage . '/*' ) ?: array() as $f ) {
			@unlink( $f ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
		@rmdir( $stage ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	};
	foreach ( $items as $i => $it ) {
		$body = hh_su_fetch( $base . $it[1], 60 );
		if ( is_wp_error( $body ) ) {
			$clean();
			return $body;
		}
		if ( ! hash_equals( $it[2], hash( 'sha256', $body ) ) ) {
			$clean();
			return new WP_Error( 'sha', 'Sai mã kiểm tra: ' . $it[3] );
		}
		if ( preg_match( '/\.php$/i', $it[3] ) && ! hh_su_php_ok( $body ) ) {
			$clean();
			return new WP_Error( 'php', 'Lỗi cú pháp PHP: ' . $it[3] );
		}
		file_put_contents( "$stage/$i", $body );
	}
	// Hosting chặn web tự gọi chính nó (loopback) thì không tự kiểm tra được sau khi chép – vẫn cập nhật, ghi nhật ký cảnh báo.
	$pre       = wp_remote_get( rest_url( 'hh/v1/su-ping' ) . '?t=' . time(), array( 'timeout' => 20 ) );
	$can_check = ! is_wp_error( $pre ) && 200 === (int) wp_remote_retrieve_response_code( $pre );
	if ( ! $can_check ) {
		hh_su_log( 'Cảnh báo: web không tự gọi được chính nó (loopback) – bỏ bước tự kiểm tra sau khi chép.' );
	}
	// Sao lưu bản cũ (ghi đè lần sao lưu trước).
	foreach ( glob( $bak . '/*' ) ?: array() as $f ) {
		@unlink( $f ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	wp_mkdir_p( $bak );
	$undo = array();
	foreach ( $items as $i => $it ) {
		$had = is_file( $it[0] );
		if ( $had ) {
			copy( $it[0], "$bak/$i" );
		}
		$undo[ $i ] = $had;
	}
	$restore = static function () use ( $items, $undo, $bak ) {
		foreach ( $items as $i => $it ) {
			if ( $undo[ $i ] ) {
				copy( "$bak/$i", $it[0] );
			} elseif ( is_file( $it[0] ) ) {
				@unlink( $it[0] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
			}
		}
		if ( function_exists( 'opcache_reset' ) ) {
			opcache_reset();
		}
	};
	foreach ( $items as $i => $it ) {
		wp_mkdir_p( dirname( $it[0] ) );
		$tmp = $it[0] . '.hh-su-new';
		if ( ! copy( "$stage/$i", $tmp ) || ! rename( $tmp, $it[0] ) ) {
			@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
			$restore();
			$clean();
			return new WP_Error( 'write', 'Không ghi được tệp ' . $it[3] . ' (quyền thư mục hosting).' );
		}
	}
	$clean();
	foreach ( $items as $it ) {
		if ( function_exists( 'opcache_invalidate' ) && preg_match( '/\.php$/i', $it[0] ) ) {
			@opcache_invalidate( $it[0], true ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
	}
	if ( function_exists( 'opcache_reset' ) ) {
		opcache_reset();
	}
	// Tự kiểm tra bằng code mới: trang chủ + cổng su-ping phải chạy và báo đúng phiên bản.
	if ( ! $can_check ) {
		return true;
	}
	// Hosting thường giữ bộ đệm mã PHP (OPcache) tới ~60 giây → hỏi lại su-ping tối đa ~2 phút trước khi kết luận.
	$ok   = false;
	$why  = '';
	$errs = 0;
	for ( $try = 0; $try < 12 && ! $ok; $try++ ) {
		if ( $try ) {
			sleep( 10 );
		}
		$ping = wp_remote_get( rest_url( 'hh/v1/su-ping' ) . '?t=' . time() . '-' . $try, array( 'timeout' => 30, 'headers' => array( 'Cache-Control' => 'no-cache' ) ) );
		if ( ! is_wp_error( $ping ) && 200 === (int) wp_remote_retrieve_response_code( $ping ) ) {
			$pv  = json_decode( (string) wp_remote_retrieve_body( $ping ), true );
			$ok  = is_array( $pv ) && ( $pv['v'] ?? '' ) === $version;
			$why = $ok ? '' : 'su-ping vẫn báo phiên bản ' . ( $pv['v'] ?? '?' ) . ' sau ' . ( $try * 10 ) . ' giây';
		} else {
			$why = 'su-ping lỗi ' . ( is_wp_error( $ping ) ? $ping->get_error_message() : wp_remote_retrieve_response_code( $ping ) );
			if ( ++$errs >= 3 ) {
				break; // Lỗi thật (500…) – trả bản cũ ngay.
			}
		}
	}
	if ( $ok ) {
		$home = wp_remote_get( add_query_arg( 'hh_su', time(), home_url( '/' ) ), array( 'timeout' => 30 ) );
		$code = is_wp_error( $home ) ? 0 : (int) wp_remote_retrieve_response_code( $home );
		if ( $code >= 500 || false !== stripos( (string) wp_remote_retrieve_body( $home ), 'critical error' ) ) {
			$ok  = false;
			$why = 'trang chủ lỗi ' . $code;
		}
	}
	if ( ! $ok ) {
		$restore();
		return new WP_Error( 'health', 'Bản mới không chạy được (' . $why . ') – đã trả lại bản cũ.' );
	}
	return true;
}

/* ---------------------------------------------------------------- Sau cập nhật: nhập dữ liệu, ảnh ---------------------------------------------------------------- */

add_action(
	'hh_su_after',
	static function () {
		if ( ! get_option( 'hh_su_need_import' ) ) {
			return;
		}
		delete_option( 'hh_su_need_import' );
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
		try {
			$GLOBALS['hh_import_full'] = false;
			$r = function_exists( 'hh_import_projects' ) ? hh_import_projects() : null;
			do_action( 'litespeed_purge_all' );
			hh_su_log( 'Đã nhập / cập nhật dữ liệu (bản ' . HH_CRM_VERSION . ')' . ( is_array( $r ) ? ': ' . (int) $r[0] . ' dự án mới, ' . (int) $r[1] . ' dự án cập nhật, ' . (int) ( $r[2] ?? 0 ) . ' bài mới' : '' ) . ' và xoá bộ nhớ đệm LiteSpeed.' );
		} catch ( \Throwable $e ) {
			hh_su_log( 'Nhập dữ liệu lỗi: ' . $e->getMessage() . ' (' . basename( $e->getFile() ) . ':' . $e->getLine() . ')' );
		}
	}
);

add_action(
	'hh_su_images',
	static function () {
		$q = (array) get_option( 'hh_su_img_queue', array() );
		if ( empty( $q['items'] ) || empty( $q['base'] ) ) {
			return;
		}
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 120 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
		$done  = 0;
		$bytes = 0;
		$left  = array();
		foreach ( $q['items'] as $it ) {
			if ( $done >= 25 || $bytes > 30 * MB_IN_BYTES ) {
				$left[] = $it;
				continue;
			}
			$body = hh_su_fetch( $q['base'] . $it[1], 60 );
			if ( is_wp_error( $body ) || ! hash_equals( $it[2], hash( 'sha256', $body ) ) ) {
				$left[] = $it; // Thử lại lượt sau.
				continue;
			}
			wp_mkdir_p( dirname( $it[0] ) );
			file_put_contents( $it[0], $body );
			++$done;
			$bytes += strlen( $body );
		}
		update_option( 'hh_su_img_queue', array( 'base' => $q['base'], 'items' => $left ), false );
		if ( $left ) {
			wp_schedule_single_event( time() + 120, 'hh_su_images' );
		} else {
			do_action( 'litespeed_purge_all' );
		}
		if ( $done ) {
			hh_su_log( 'Đã tải ' . $done . ' ảnh mới' . ( $left ? ', còn ' . count( $left ) . ' ảnh' : '' ) . '.' );
		}
	}
);

/* ---------------------------------------------------------------- Lịch, cổng gọi ---------------------------------------------------------------- */

add_action(
	'init',
	static function () {
		if ( ! wp_next_scheduled( 'hh_su_check' ) ) {
			wp_schedule_event( time() + 300, 'hourly', 'hh_su_check' );
		}
	}
);
add_action( 'hh_su_check', static function () {
	hh_su_run( false );
} );
add_action( 'hh_su_now', static function () {
	hh_su_run( false );
} );

add_action(
	'rest_api_init',
	static function () {
		register_rest_route(
			'hh/v1',
			'/su-ping',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => static function () {
					do_action( 'litespeed_control_set_nocache', 'hh su-ping' );
					$r = new WP_REST_Response( array( 'v' => HH_CRM_VERSION ) );
					$r->header( 'Cache-Control', 'no-store, max-age=0' );
					return $r;
				},
			)
		);
		register_rest_route(
			'hh/v1',
			'/self-update',
			array(
				'methods'             => 'POST',
				'permission_callback' => static function ( $req ) {
					$hash = (string) get_option( 'hh_su_key_hash', '' );
					$key  = (string) $req->get_header( 'x_hh_key' );
					return '' !== $hash && '' !== $key && hash_equals( $hash, hash( 'sha256', $key ) );
				},
				'callback'            => static function () {
					if ( ! hh_su_enabled() ) {
						return array( 'ok' => false, 'msg' => 'Tự cập nhật đang tắt.', 'v' => HH_CRM_VERSION );
					}
					if ( get_transient( 'hh_su_called' ) ) {
						return array( 'ok' => true, 'msg' => 'Vừa gọi – lượt cập nhật đã được hẹn.', 'v' => HH_CRM_VERSION );
					}
					set_transient( 'hh_su_called', 1, MINUTE_IN_SECONDS );
					if ( ! wp_next_scheduled( 'hh_su_now' ) ) {
						wp_schedule_single_event( time(), 'hh_su_now' );
					}
					if ( function_exists( 'spawn_cron' ) ) {
						spawn_cron();
					}
					if ( ! wp_next_scheduled( 'hh_auto_posts' ) || wp_next_scheduled( 'hh_auto_posts' ) > time() + 60 ) {
						wp_schedule_single_event( time(), 'hh_auto_posts_at' ); // Kiểm tra luôn bài tự đăng có bản sửa mới.
					}
					$log = (array) get_option( 'hh_su_log', array() );
					$ap  = (int) get_option( 'hh_auto_posts_checked' );
					return array(
						'ok'    => true,
						'msg'   => 'Đã hẹn cập nhật ngay.',
						'v'     => HH_CRM_VERSION,
						'last'  => $log ? end( $log )[1] : '',
						// Tình trạng Tự đăng bài (chỉ tiêu đề bài + giờ, không có dữ liệu riêng tư) để kiểm tra từ xa.
						'posts' => array(
							'checked' => $ap ? wp_date( 'd/m H:i', $ap ) : '',
							'next'    => wp_next_scheduled( 'hh_auto_posts' ) ? wp_date( 'd/m H:i', wp_next_scheduled( 'hh_auto_posts' ) ) : '',
							'log'     => array_slice( (array) get_option( 'hh_auto_posts_log', array() ), -6 ),
						),
					);
				},
			)
		);
	}
);

/* ---------------------------------------------------------------- Trang quản trị ---------------------------------------------------------------- */

add_action(
	'admin_menu',
	static function () {
		add_submenu_page( 'edit.php?post_type=du-an', 'Tự cập nhật', 'Tự cập nhật', 'manage_options', 'hh-tu-cap-nhat', 'hh_su_page' );
	},
	30
);

function hh_su_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$notice = '';
	$newkey = '';
	if ( isset( $_POST['hh_su_act'] ) && check_admin_referer( 'hh_su' ) ) {
		$act = sanitize_key( wp_unslash( $_POST['hh_su_act'] ) );
		if ( 'save' === $act ) {
			update_option( 'hh_su_enabled', empty( $_POST['hh_su_enabled'] ) ? '0' : '1', false );
			$notice = 'Đã lưu.';
		} elseif ( 'key' === $act ) {
			$newkey = 'hhsu_' . wp_generate_password( 40, false, false );
			update_option( 'hh_su_key_hash', hash( 'sha256', $newkey ), false );
			hh_su_log( 'Đã tạo khoá gọi cập nhật mới (khoá cũ hết hiệu lực).' );
		} elseif ( 'now' === $act ) {
			$notice = hh_su_run( true );
		}
	}
	$log = array_reverse( (array) get_option( 'hh_su_log', array() ) );
	$q   = (array) get_option( 'hh_su_img_queue', array() );
	?>
	<div class="wrap">
		<h1>Tự cập nhật plugin &amp; giao diện</h1>
		<?php if ( $notice ) : ?>
			<div class="notice notice-info"><p><?php echo esc_html( $notice ); ?></p></div>
		<?php endif; ?>
		<?php if ( $newkey ) : ?>
			<div class="notice notice-warning"><p><strong>Khoá mới (chỉ hiện 1 lần):</strong> <code style="user-select:all"><?php echo esc_html( $newkey ); ?></code></p><p>Sao chép khoá này và nhập vào ô bảo mật Claude gửi (máy chủ <code>hiephoangmt.com</code>, tiêu đề <code>X-HH-Key</code>). Không gửi khoá qua chat.</p></div>
		<?php endif; ?>
		<p>Web đang chạy plugin <strong><?php echo esc_html( HH_CRM_VERSION ); ?></strong>. Mỗi giờ web tự kiểm tra kho code; Claude cũng gọi cổng cập nhật ngay sau khi đẩy code. Tệp lỗi hoặc web lỗi sau khi chép → tự trả lại bản cũ. Sau khi cập nhật, web tự <em>Nhập / cập nhật dữ liệu</em> và xoá bộ nhớ đệm LiteSpeed.</p>
		<p>Lần kiểm tra gần nhất: <?php echo get_option( 'hh_su_last_check' ) ? esc_html( wp_date( 'd/m/Y H:i', (int) get_option( 'hh_su_last_check' ) ) ) : 'chưa có'; ?>
			<?php echo ! empty( $q['items'] ) ? ' · còn ' . count( $q['items'] ) . ' ảnh đang tải dần' : ''; ?>
			· Khoá gọi cập nhật: <?php echo get_option( 'hh_su_key_hash' ) ? 'đã có' : '<strong>chưa tạo</strong>'; ?></p>
		<form method="post">
			<?php wp_nonce_field( 'hh_su' ); ?>
			<p><label><input type="checkbox" name="hh_su_enabled" value="1" <?php checked( hh_su_enabled() ); ?>> Bật tự cập nhật</label>
				<button class="button" name="hh_su_act" value="save">Lưu</button></p>
			<p><button class="button button-primary" name="hh_su_act" value="now">Kiểm tra &amp; cập nhật ngay</button>
				<button class="button" name="hh_su_act" value="key" onclick="return confirm('Tạo khoá mới? Khoá cũ sẽ hết hiệu lực.')">Tạo khoá gọi cập nhật</button></p>
		</form>
		<h2>Nhật ký</h2>
		<table class="widefat striped"><tbody>
			<?php foreach ( array_slice( $log, 0, 30 ) as $l ) : ?>
				<tr><td style="width:150px"><?php echo esc_html( wp_date( 'd/m/Y H:i', (int) $l[0] ) ); ?></td><td><?php echo esc_html( $l[1] ); ?></td></tr>
			<?php endforeach; ?>
			<?php if ( ! $log ) : ?><tr><td>Chưa có.</td></tr><?php endif; ?>
		</tbody></table>
	</div>
	<?php
}
