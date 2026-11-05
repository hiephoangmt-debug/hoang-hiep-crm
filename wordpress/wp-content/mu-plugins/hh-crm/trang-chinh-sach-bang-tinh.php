<?php
/**
 * Trang "Chính sách & bảng tính giá" (/chinh-sach-bang-tinh/): mỗi dự án một thẻ gồm chính sách bán hàng đang áp dụng,
 * nút mở bảng tính giá (/du-an/<dự án>/bang-tinh/) và danh sách bài "Chính sách bán hàng" theo từng tháng của dự án đó.
 * Kèm: phiếu tính giá Excel của chủ đầu tư đóng gói trong plugin (thư mục ptg/) được tự nạp vào bảng tính từng dự án
 * khi bấm "Nhập / cập nhật dữ liệu" (chỉ khi ô file của dự án còn trống hoặc vẫn là file web tự nạp lần trước).
 * Tự tạo trang một lần khi quản trị viên vào trang quản trị; xóa trang thì không tự tạo lại.
 */

defined( 'ABSPATH' ) || exit;

const HH_CSBT_SLUG = 'chinh-sach-bang-tinh';
const HH_CSBT_CAT  = 'Chính sách bán hàng';

/** Dự án hiện trên trang, theo thứ tự (dự án chưa có chính sách thì ẩn). */
function hh_csbt_projects() {
	return apply_filters(
		'hh_csbt_projects',
		array( 'sun-saphia-residence', 'spana-tower', 'cora-tower', 's-light-tower', 'fours-tower-f1-thap-tung', 'fours-tower-f5-thap-cuc', 'fours-tower-f2-thap-mai', 'sun-solar-residence', 'sun-costa-residence' )
	);
}

/**
 * Phiếu tính giá đóng gói trong plugin: slug dự án => danh sách file trong hh-crm/ptg/.
 * Đổi tên file (VD thêm tháng) khi có phiếu mới → web nạp lại.
 */
function hh_units_bundled_files() {
	return apply_filters( 'hh_units_bundled_files', array() );
}

/** Nạp phiếu tính giá đóng gói vào bảng tính dự án (gọi cuối "Nhập / cập nhật dữ liệu"). Trả về số dự án đã nạp. */
function hh_units_import_bundled() {
	if ( ! function_exists( 'hh_units_refresh' ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$done = 0;
	foreach ( hh_units_bundled_files() as $slug => $files ) {
		$post = get_page_by_path( $slug, OBJECT, 'du-an' );
		if ( ! $post ) {
			continue;
		}
		$key  = implode( ',', $files );
		$auto = (string) get_post_meta( $post->ID, '_hh_units_auto', true );
		$cur  = (string) get_post_meta( $post->ID, 'hh_p_units_file', true );
		$mine = (string) get_post_meta( $post->ID, '_hh_units_auto_ids', true );
		if ( $auto === $key || ( '' !== $cur && $cur !== $mine ) ) {
			continue; // Đã nạp bản này, hoặc anh đã tự chọn file khác.
		}
		$ids = array();
		foreach ( $files as $f ) {
			$src = HH_CRM_DIR . 'ptg/' . $f;
			if ( ! is_readable( $src ) ) {
				continue;
			}
			$up = wp_upload_bits( wp_basename( $f ), null, file_get_contents( $src ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			if ( ! empty( $up['error'] ) ) {
				continue;
			}
			$id = wp_insert_attachment(
				array(
					'post_mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					'post_title'     => preg_replace( '/\.xlsx?$/i', '', wp_basename( $f ) ),
					'post_status'    => 'inherit',
				),
				$up['file'],
				$post->ID
			);
			if ( $id && ! is_wp_error( $id ) ) {
				$ids[] = (int) $id;
			}
		}
		if ( ! $ids ) {
			continue;
		}
		update_post_meta( $post->ID, 'hh_p_units_file', implode( ',', $ids ) );
		update_post_meta( $post->ID, '_hh_units_auto_ids', implode( ',', $ids ) );
		update_post_meta( $post->ID, '_hh_units_auto', $key );
		hh_units_refresh( $post->ID );
		++$done;
	}
	return $done;
}

/** Bài "Chính sách bán hàng" của 1 dự án, mới nhất trước. */
function hh_csbt_posts( $project_id, $limit = 6 ) {
	$cat = get_term_by( 'name', HH_CSBT_CAT, 'category' );
	if ( ! $cat ) {
		return array();
	}
	return get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'cat'            => (int) $cat->term_id,
			'posts_per_page' => $limit,
			'meta_key'       => 'hh_post_project', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => (string) $project_id, // phpcs:ignore WordPress.DB.SlowDBQuery
			'no_found_rows'  => true,
		)
	);
}

add_shortcode(
	'hh_chinh_sach_bang_tinh',
	static function () {
		$zalo = 'https://zalo.me/' . preg_replace( '/\D/', '', function_exists( 'hoanghiep_opt' ) ? hoanghiep_opt( 'hh_zalo' ) : '0904567009' );
		$out  = '<div class="hh-csbt">';
		$out .= '<p class="hh-csbt__intro">Chính sách bán hàng đang áp dụng của từng dự án, cập nhật theo tháng. Bấm <strong>Bảng tính giá</strong> để nhập giá căn, chọn phương án thanh toán (không vay, vay ngân hàng, thanh toán sớm) và xem số tiền từng đợt. Thông tin tham khảo – liên hệ để nhận phiếu tính giá căn cụ thể.</p>';
		$cat  = get_term_by( 'name', HH_CSBT_CAT, 'category' );
		foreach ( hh_csbt_projects() as $slug ) {
			$p = get_page_by_path( $slug, OBJECT, 'du-an' );
			if ( ! $p || 'publish' !== $p->post_status ) {
				continue;
			}
			$policy = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( $p->ID, 'hh_p_policy', true ) ) ) );
			if ( ! $policy ) {
				continue;
			}
			$thumb = get_the_post_thumbnail_url( $p->ID, 'medium_large' );
			$calc  = function_exists( 'hh_units_data' ) && hh_units_data( $p->ID ) ? hh_units_url( $p->ID ) : '';
			$posts = hh_csbt_posts( $p->ID );
			if ( ! $posts && 'fours-tower-f5-thap-cuc' === $slug ) { // F1, F5 chung chính sách – dùng bài của F1.
				$f1    = get_page_by_path( 'fours-tower-f1-thap-tung', OBJECT, 'du-an' );
				$posts = $f1 ? hh_csbt_posts( $f1->ID ) : array();
			}
			$out  .= '<section class="hh-csbt__card" id="' . esc_attr( $slug ) . '">';
			if ( $thumb ) {
				$out .= '<a class="hh-csbt__img" href="' . esc_url( get_permalink( $p ) ) . '"><img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( get_the_title( $p ) ) . '" loading="lazy"></a>';
			}
			$out .= '<div class="hh-csbt__body"><h2><a href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( get_the_title( $p ) ) . '</a></h2><ul>';
			foreach ( array_slice( $policy, 0, 8 ) as $line ) {
				$out .= '<li>' . esc_html( $line ) . '</li>';
			}
			$out .= '</ul><p class="hh-csbt__btns">';
			$out .= $calc
				? '<a class="btn btn--gold" href="' . esc_url( $calc ) . '">Bảng tính giá</a> '
				: '<a class="btn btn--gold" href="' . esc_url( $zalo ) . '" target="_blank" rel="noopener">Nhận phiếu tính giá qua Zalo</a> ';
			$out .= '<a class="btn btn--ghost" href="' . esc_url( get_permalink( $p ) ) . '">Trang dự án</a></p>';
			if ( $posts ) {
				$out .= '<p class="hh-csbt__h">Chính sách các tháng</p><ul class="hh-csbt__months">';
				foreach ( $posts as $post ) {
					$out .= '<li><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a> <small>' . esc_html( get_the_date( 'd/m/Y', $post ) ) . '</small></li>';
				}
				$out .= '</ul>';
			}
			$out .= '</div></section>';
		}
		if ( $cat ) {
			$out .= '<p class="hh-csbt__all"><a href="' . esc_url( get_category_link( $cat ) ) . '">Xem tất cả bài Chính sách bán hàng →</a></p>';
		}
		return $out . '</div>';
	}
);

/** Tạo trang (một lần). */
function hh_csbt_ensure_page() {
	if ( get_option( 'hh_csbt_page_created' ) || ! current_user_can( 'publish_pages' ) ) {
		return;
	}
	if ( ! get_page_by_path( HH_CSBT_SLUG ) ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Chính sách bán hàng & bảng tính giá',
				'post_name'    => HH_CSBT_SLUG,
				'post_content' => '[hh_chinh_sach_bang_tinh]',
				'post_excerpt' => 'Chính sách bán hàng từng tháng và bảng tính giá căn hộ các dự án Sun Group Đà Nẵng: Sun Saphia, Spana, Cora, S-Light, FourS – chiết khấu, thanh toán sớm, vay ngân hàng, tiến độ.',
			),
			true
		);
		if ( is_wp_error( $id ) || ! $id ) {
			return;
		}
	}
	if ( function_exists( 'hh_news_category' ) ) {
		hh_news_category( HH_CSBT_CAT );
	}
	update_option( 'hh_csbt_page_created', 1, false );
}
add_action( 'admin_init', 'hh_csbt_ensure_page' );

/** Trang đã xuất bản thì trả về link, chưa có thì rỗng (menu không có link chết). */
function hh_csbt_url() {
	static $url = null;
	if ( null === $url ) {
		$page = get_page_by_path( HH_CSBT_SLUG );
		$url  = ( $page && 'publish' === $page->post_status ) ? get_permalink( $page ) : '';
	}
	return $url;
}

add_action(
	'wp_head',
	static function () {
		if ( ! is_page( HH_CSBT_SLUG ) ) {
			return;
		}
		echo '<style id="hh-csbt">.hh-csbt__intro{font-size:16px;margin:0 0 18px}.hh-csbt__card{display:grid;grid-template-columns:260px 1fr;gap:18px;background:#fff;border-radius:14px;box-shadow:0 6px 20px rgba(11,37,69,.08);padding:16px;margin:0 0 18px}'
			. '.hh-csbt__img img{width:100%;height:100%;max-height:220px;object-fit:cover;border-radius:10px}.hh-csbt__body h2{margin:0 0 8px;font-size:22px}.hh-csbt__body ul{margin:0 0 10px;padding-left:18px}.hh-csbt__body li{margin:3px 0;font-size:15px}'
			. '.hh-csbt__btns{display:flex;gap:8px;flex-wrap:wrap;margin:8px 0}.hh-csbt__h{font-weight:700;margin:10px 0 4px}.hh-csbt__months small{color:#777}'
			. '@media(max-width:700px){.hh-csbt__card{grid-template-columns:1fr}.hh-csbt__img img{max-height:180px}}</style>' . "\n";
	}
);
