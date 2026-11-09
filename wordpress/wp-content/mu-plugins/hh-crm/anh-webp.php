<?php
/**
 * Ảnh PNG dạng ảnh chụp/phối cảnh rất nặng (có ảnh 6,6 MB, bản 1024px vẫn 1,4 MB) → làm trang tải chậm trên điện thoại.
 * - Ảnh PNG tải lên từ nay: các cỡ thu nhỏ (1536, 1024, 768, 300…) lưu dạng WebP (nhẹ hơn 10 – 20 lần, giữ nền trong suốt).
 * - Ảnh PNG lớn đã có: mỗi lần mở trang quản trị, tạo lại các cỡ thu nhỏ dạng WebP cho vài ảnh (đến khi hết).
 *   File PNG cũ giữ nguyên (bài viết cũ có thể đang dùng), chỉ đổi cỡ ảnh web hiển thị.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'image_editor_output_format',
	static function ( $formats ) {
		if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			$formats['image/png'] = 'image/webp';
		}
		return $formats;
	}
);

add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || get_option( 'hh_png_webp_xong_v1' ) || ! current_user_can( 'upload_files' ) || ! wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			return;
		}
		$ids = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => 'image/png',
				'posts_per_page' => 40,
				'fields'         => 'ids',
				'meta_query'     => array( array( 'key' => '_hh_png_webp', 'compare' => 'NOT EXISTS' ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
			)
		);
		if ( ! $ids ) {
			update_option( 'hh_png_webp_xong_v1', 1, false );
			return;
		}
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$start = microtime( true );
		$done  = 0;
		foreach ( $ids as $id ) {
			if ( $done >= 3 || microtime( true ) - $start > 15 ) {
				break;
			}
			update_post_meta( $id, '_hh_png_webp', 1 );
			$file = get_attached_file( $id );
			if ( ! $file || ! is_file( $file ) || filesize( $file ) < 300 * 1024 ) {
				continue; // Ảnh PNG nhỏ (logo, biểu tượng): để nguyên.
			}
			$meta = wp_generate_attachment_metadata( $id, $file );
			if ( $meta && ! is_wp_error( $meta ) ) {
				wp_update_attachment_metadata( $id, $meta );
			}
			++$done;
		}
	}
);

/** Chất lượng WebP 85: đo SSIM ≈ 0,97 – 0,98 so với ảnh gốc (mắt thường không phân biệt), vẫn nhẹ hơn nhiều lần. */
add_filter(
	'wp_editor_set_quality',
	static function ( $quality, $mime = '' ) {
		return 'image/webp' === $mime ? 85 : $quality;
	},
	10,
	2
);

/* -------------------------------------------------------------------------
 * Ảnh JPG: tạo bản WebP chất lượng 85 cạnh từng cỡ thu nhỏ (x-720x480.jpg → x-720x480.jpg.webp),
 * web tự dùng bản WebP khi đã có (nhẹ hơn ~30 – 50%, nét như gốc). Ảnh mới tải lên làm ngay; ảnh cũ làm dần.
 * ---------------------------------------------------------------------- */

/** Đường dẫn file trên ổ đĩa ↔ địa chỉ web trong thư mục uploads. */
function hh_upload_path_from_url( $url ) {
	$up = wp_get_upload_dir();
	$u  = preg_replace( '#^https?:#', '', (string) $url );
	$b  = preg_replace( '#^https?:#', '', $up['baseurl'] );
	return 0 === strpos( $u, $b ) ? $up['basedir'] . substr( $u, strlen( $b ) ) : '';
}

/** URL bản WebP nếu đã có, ngược lại trả nguyên URL. */
function hh_webp_url( $url ) {
	// Ảnh chia sẻ (og:image trong <head>, sơ đồ trang, REST): giữ JPG – Zalo, một số app chưa đọc WebP.
	if ( doing_action( 'wp_head' ) || doing_action( 'rank_math/head' ) || is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ! preg_match( '/\.jpe?g$/i', (string) $url ) ) {
		return $url;
	}
	$path = hh_upload_path_from_url( $url );
	return ( $path && is_file( $path . '.webp' ) ) ? $url . '.webp' : $url;
}

add_filter(
	'wp_get_attachment_image_src',
	static function ( $image ) {
		if ( is_array( $image ) && ! empty( $image[0] ) && ! is_admin() ) {
			$image[0] = hh_webp_url( $image[0] );
		}
		return $image;
	},
	20
);
add_filter(
	'wp_calculate_image_srcset',
	static function ( $sources ) {
		if ( is_array( $sources ) && ! is_admin() ) {
			foreach ( $sources as $w => $s ) {
				$sources[ $w ]['url'] = hh_webp_url( $s['url'] );
			}
		}
		return $sources;
	},
	20
);

/** Tạo bản WebP cho các cỡ thu nhỏ của một ảnh JPG. */
function hh_make_jpg_webp( $id, $meta = null ) {
	$meta = $meta ?: wp_get_attachment_metadata( $id );
	$file = get_attached_file( $id );
	if ( ! $file || empty( $meta['sizes'] ) || ! preg_match( '/\.jpe?g$/i', $file ) ) {
		return;
	}
	$dir = dirname( $file );
	foreach ( $meta['sizes'] as $size ) {
		$src = $dir . '/' . $size['file'];
		if ( ! preg_match( '/\.jpe?g$/i', $src ) || ! is_file( $src ) || is_file( $src . '.webp' ) ) {
			continue;
		}
		$ed = wp_get_image_editor( $src );
		if ( is_wp_error( $ed ) ) {
			continue;
		}
		$ed->set_quality( 85 );
		$ed->save( $src . '.webp', 'image/webp' );
		if ( is_file( $src . '.webp' ) && filesize( $src . '.webp' ) >= filesize( $src ) ) {
			wp_delete_file( $src . '.webp' ); // WebP không nhẹ hơn: bỏ, giữ JPG.
		}
	}
}

add_filter(
	'wp_generate_attachment_metadata',
	static function ( $meta, $id ) {
		if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			hh_make_jpg_webp( $id, $meta );
			update_post_meta( $id, '_hh_jpg_webp', 1 );
		}
		return $meta;
	},
	20,
	2
);

/** Ảnh JPG cũ: mỗi lượt xử lý vài chục ảnh (mở trang quản trị, hoặc lịch chạy mỗi giờ). */
function hh_jpg_webp_batch( $budget = 12 ) {
	if ( get_option( 'hh_jpg_webp_xong_v1' ) || ! wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
		return;
	}
	$ids = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'post_mime_type' => 'image/jpeg',
			'posts_per_page' => 30,
			'fields'         => 'ids',
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'meta_query'     => array( array( 'key' => '_hh_jpg_webp', 'compare' => 'NOT EXISTS' ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	if ( ! $ids ) {
		update_option( 'hh_jpg_webp_xong_v1', 1, false );
		return;
	}
	$start = microtime( true );
	foreach ( $ids as $id ) {
		if ( microtime( true ) - $start > $budget ) {
			break;
		}
		update_post_meta( $id, '_hh_jpg_webp', 1 );
		hh_make_jpg_webp( $id );
	}
}
add_action(
	'admin_init',
	static function () {
		if ( ! wp_doing_ajax() && current_user_can( 'upload_files' ) ) {
			hh_jpg_webp_batch( 4 );
		}
	}
);
add_action( 'hh_jpg_webp_cron', static fn() => hh_jpg_webp_batch( 25 ) );
add_action(
	'init',
	static function () {
		if ( ! get_option( 'hh_jpg_webp_xong_v1' ) && ! wp_next_scheduled( 'hh_jpg_webp_cron' ) ) {
			wp_schedule_event( time() + 300, 'hourly', 'hh_jpg_webp_cron' );
		}
	}
);

/**
 * Ảnh trình chiếu trang chủ trên điện thoại: khung đứng (~412×570) → bản cắt dọc 1080×1440 WebP chất lượng 85
 * (nét hơn và nhẹ hơn bản ngang 1920×900). Tạo một lần, lưu cạnh ảnh gốc.
 */
function hh_hero_mobile_url( $id ) {
	$id   = (int) $id;
	$file = $id ? get_attached_file( $id ) : '';
	if ( ! $file || ! is_file( $file ) ) {
		return '';
	}
	$out = preg_replace( '/\.\w+$/', '', $file ) . '-hh-hero-m.webp';
	if ( ! is_file( $out ) ) {
		if ( get_transient( 'hh_hero_m_fail_' . $id ) || ! wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
			return '';
		}
		$ed = wp_get_image_editor( $file );
		$sz = is_wp_error( $ed ) ? array() : $ed->get_size();
		if ( empty( $sz['width'] ) || empty( $sz['height'] ) ) {
			set_transient( 'hh_hero_m_fail_' . $id, 1, DAY_IN_SECONDS );
			return '';
		}
		// Cắt khung 3:4 ở giữa ảnh (ảnh gốc thấp hơn 1440px: giữ nguyên chiều cao, không phóng to).
		$cw = min( $sz['width'], (int) round( $sz['height'] * 3 / 4 ) );
		$ch = (int) round( $cw * 4 / 3 );
		$dw = min( 1080, $cw );
		if ( is_wp_error( $ed->crop( (int) ( ( $sz['width'] - $cw ) / 2 ), (int) ( ( $sz['height'] - $ch ) / 2 ), $cw, $ch, $dw, (int) round( $dw * 4 / 3 ) ) ) ) {
			set_transient( 'hh_hero_m_fail_' . $id, 1, DAY_IN_SECONDS );
			return '';
		}
		$ed->set_quality( 85 );
		if ( is_wp_error( $ed->save( $out, 'image/webp' ) ) ) {
			set_transient( 'hh_hero_m_fail_' . $id, 1, DAY_IN_SECONDS );
			return '';
		}
	}
	$up = wp_get_upload_dir();
	return 0 === strpos( $out, $up['basedir'] ) ? $up['baseurl'] . substr( $out, strlen( $up['basedir'] ) ) : '';
}

/**
 * Ảnh chia sẻ (og:image) luôn là JPG – Zalo và một số ứng dụng chưa đọc WebP.
 * Ảnh đại diện chỉ còn cỡ WebP (PNG đã chuyển): tạo một bản JPG 1200px chất lượng 85, lưu cạnh ảnh gốc.
 */
function hh_share_jpg_url( $id ) {
	$id  = (int) $id;
	$src = $id ? wp_get_attachment_image_src( $id, 'large' ) : false;
	$url = $src ? preg_replace( '/(\.jpe?g)\.webp$/i', '$1', (string) $src[0] ) : '';
	if ( '' === $url || ! preg_match( '/\.webp$/i', $url ) ) {
		return $url;
	}
	$file = get_attached_file( $id );
	if ( ! $file || ! is_file( $file ) ) {
		return $url;
	}
	$out = preg_replace( '/\.\w+$/', '', $file ) . '-share.jpg';
	if ( ! is_file( $out ) ) {
		$ed = wp_get_image_editor( $file );
		if ( is_wp_error( $ed ) ) {
			return $url;
		}
		$ed->resize( 1200, 1200, false );
		$ed->set_quality( 85 );
		if ( is_wp_error( $ed->save( $out, 'image/jpeg' ) ) ) {
			return $url;
		}
	}
	$up = wp_get_upload_dir();
	return 0 === strpos( $out, $up['basedir'] ) ? $up['baseurl'] . substr( $out, strlen( $up['basedir'] ) ) : $url;
}
