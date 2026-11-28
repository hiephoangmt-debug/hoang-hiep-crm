<?php
/**
 * Thứ tự khu vực trên web (anh Hiệp 28/11/2026): các quận trung tâm Đà Nẵng lên trước – Hải Châu, Sơn Trà, Ngũ Hành Sơn,
 * Thanh Khê, Cẩm Lệ, Liên Chiểu, Hòa Vang – rồi vùng Quảng Nam cũ (Hội An, Điện Bàn, Duy Xuyên, Thăng Bình, Tam Kỳ, Núi Thành),
 * khu còn lại xếp theo tên. Áp cho mọi danh sách khu vực lấy theo tên (ô lọc, chân trang, danh mục); danh sách đã chọn
 * sắp theo số tin (orderby count) giữ nguyên.
 *
 * @package HoangHiep
 */

defined( 'ABSPATH' ) || exit;

/** Thứ hạng của một khu vực (số nhỏ đứng trước). */
function hoanghiep_khu_vuc_rank( $name ) {
	static $order = array( 'hải châu', 'sơn trà', 'ngũ hành sơn', 'thanh khê', 'cẩm lệ', 'liên chiểu', 'hòa vang', 'hoà vang', 'hội an', 'điện bàn', 'duy xuyên', 'thăng bình', 'tam kỳ', 'núi thành' );
	$n = trim( mb_strtolower( (string) $name ) );
	$i = array_search( $n, $order, true );
	return false === $i ? 100 : $i;
}

/** Mục khu vực thừa (trùng nghĩa, không có tin) – ẩn khỏi danh sách và xóa nếu trống. */
function hoanghiep_khu_vuc_bo() {
	return array( 'p-hoa-xuan', 'da-nang' );
}

/** Xóa một lần các mục khu vực thừa khi chúng không còn tin nào (anh Hiệp 28/11/2026). */
function hoanghiep_khu_vuc_don() {
	if ( get_option( 'hh_khu_vuc_don_2026_11_28' ) || ! taxonomy_exists( 'khu-vuc' ) ) {
		return;
	}
	foreach ( hoanghiep_khu_vuc_bo() as $slug ) {
		$t = get_term_by( 'slug', $slug, 'khu-vuc' );
		if ( $t && 0 === (int) $t->count ) {
			wp_delete_term( (int) $t->term_id, 'khu-vuc' );
		}
	}
	update_option( 'hh_khu_vuc_don_2026_11_28', 1, false );
}
add_action( 'admin_init', 'hoanghiep_khu_vuc_don' );
add_action( 'init', static function () {
	if ( wp_doing_cron() ) {
		hoanghiep_khu_vuc_don();
	}
}, 99 );

/** Sắp danh sách term khu vực theo thứ tự trên. */
function hoanghiep_khu_vuc_sort( $terms ) {
	if ( ! is_array( $terms ) || ! $terms || ! is_object( reset( $terms ) ) ) {
		return $terms;
	}
	usort(
		$terms,
		static function ( $a, $b ) {
			$r = hoanghiep_khu_vuc_rank( $a->name ) <=> hoanghiep_khu_vuc_rank( $b->name );
			return 0 !== $r ? $r : strcmp( remove_accents( $a->name ), remove_accents( $b->name ) );
		}
	);
	return $terms;
}

add_filter(
	'get_terms',
	static function ( $terms, $taxonomies, $args ) {
		if ( is_admin() || array( 'khu-vuc' ) !== array_values( (array) $taxonomies ) ) {
			return $terms;
		}
		$orderby = (string) ( $args['orderby'] ?? 'name' );
		if ( ! in_array( $orderby, array( 'name', '' ), true ) || ( isset( $args['fields'] ) && ! in_array( $args['fields'], array( 'all', 'all_with_object_id' ), true ) ) ) {
			return $terms;
		}
		$terms = array_values( array_filter( (array) $terms, static fn( $t ) => ! is_object( $t ) || ! in_array( $t->slug, hoanghiep_khu_vuc_bo(), true ) ) );
		return hoanghiep_khu_vuc_sort( $terms );
	},
	10,
	3
);
