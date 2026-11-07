<?php
/**
 * Nhà ở xã hội / căn hộ thu nhập thấp: mục riêng "Nhà ở xã hội – thu nhập thấp" (loai-du-an/nha-o-xa-hoi),
 * không trộn vào danh sách dự án thương mại (trang Dự án, các nhóm Cao tầng / Thấp tầng, "Hot & mới").
 * Tìm kiếm theo tên vẫn ra (gõ "nhà ở xã hội", tên dự án…). Dự án được nhận diện theo tên, đường dẫn, loại hình.
 */

defined( 'ABSPATH' ) || exit;

/** Dự án có phải nhà ở xã hội / thu nhập thấp không. */
function hh_is_noxh( $post_id ) {
	$text = remove_accents( mb_strtolower( get_post_field( 'post_title', $post_id ) . ' ' . get_post_field( 'post_name', $post_id ) . ' ' . get_post_meta( $post_id, 'hh_p_type', true ) ) );
	return (bool) preg_match( '/nha o xa hoi|nha-o-xa-hoi|\bnoxh\b|thu nhap thap|nha o cong nhan|nha luu tru cong nhan/u', $text );
}

/** Term "Nhà ở xã hội – thu nhập thấp". */
function hh_noxh_term() {
	static $t = null;
	if ( null === $t ) {
		$t = get_term_by( 'slug', 'nha-o-xa-hoi', 'loai-du-an' ) ?: false;
	}
	return $t;
}

function hh_is_noxh_term( $term_id ) {
	$t = hh_noxh_term();
	return $t && (int) $t->term_id === (int) $term_id;
}

/** Điều kiện tax_query loại nhà ở xã hội ra khỏi danh sách dự án thương mại. */
function hh_noxh_tax_exclude() {
	$t = hh_noxh_term();
	return $t ? array( 'taxonomy' => 'loai-du-an', 'terms' => array( (int) $t->term_id ), 'operator' => 'NOT IN' ) : array();
}

/** Gắn mục Nhà ở xã hội cho các dự án nhận diện được (giữ nguyên các mục khác). */
function hh_noxh_assign( $ids = null ) {
	$t = hh_noxh_term();
	if ( ! $t ) {
		return;
	}
	$ids = null === $ids ? get_posts( array( 'post_type' => 'du-an', 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) ) : (array) $ids;
	foreach ( $ids as $id ) {
		if ( hh_is_noxh( $id ) ) {
			wp_set_object_terms( (int) $id, (int) $t->term_id, 'loai-du-an', true );
		}
	}
}

// Chạy một lần sau khi cài (và mỗi khi có dự án mới được lưu / nhập).
add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_noxh_assigned' ) || ! hh_noxh_term() ) {
			return;
		}
		hh_noxh_assign();
		if ( ! term_exists( 'nha-o-xa-hoi', 'loai-du-an' ) ) {
			return;
		}
		$t = hh_noxh_term();
		if ( '' === $t->description ) {
			wp_update_term( $t->term_id, 'loai-du-an', array( 'description' => 'Các dự án nhà ở xã hội, căn hộ cho người thu nhập thấp tại Đà Nẵng: vị trí, giá bán, đối tượng và điều kiện mua, hồ sơ đăng ký.' ) );
		}
		update_option( 'hh_noxh_assigned', '1', false );
	}
);
add_action( 'save_post_du-an', static function ( $id ) { hh_noxh_assign( array( $id ) ); }, 30 );

// Trang Dự án, các nhóm loại dự án: bỏ nhà ở xã hội (trừ khi đang ở mục Nhà ở xã hội hoặc đang tìm kiếm).
add_action(
	'pre_get_posts',
	static function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() || $q->get( 'tk' ) || $q->get( 's' ) ) {
			return;
		}
		if ( ! ( $q->is_post_type_archive( 'du-an' ) || $q->is_tax( 'loai-du-an' ) ) || $q->is_tax( 'loai-du-an', 'nha-o-xa-hoi' ) ) {
			return;
		}
		$ex = hh_noxh_tax_exclude();
		if ( $ex ) {
			$q->set( 'tax_query', array_merge( (array) ( $q->get( 'tax_query' ) ?: array() ), array( $ex ) ) );
		}
	},
	20
);
