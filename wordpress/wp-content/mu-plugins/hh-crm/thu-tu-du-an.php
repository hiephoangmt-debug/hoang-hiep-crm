<?php
/**
 * Thứ tự dự án ngoài web: dự án đang bán lên trước, dự án đã bán xong xuống sau (anh Hiệp, 06/11/2026).
 * Hạng: 0 Đang mở bán · 1 Sắp mở bán · 2 Đang bàn giao / chưa ghi tình trạng · 3 Đã bàn giao hoặc "Chủ đầu tư đã bán hết".
 * Trong cùng hạng giữ thứ tự cũ (mới nhất, HOT…). Trang quản trị không đổi.
 */

defined( 'ABSPATH' ) || exit;

/** Hạng sắp xếp của một dự án (số nhỏ lên trước). */
function hh_project_rank( $id ) {
	if ( hh_meta( 'hh_p_sold_out', $id ) ) {
		return 3;
	}
	return array( 'dang-mo-ban' => 0, 'sap-mo-ban' => 1, 'dang-ban-giao' => 2, 'da-ban-giao' => 3 )[ (string) hh_meta( 'hh_p_status', $id ) ] ?? 2;
}

/** Xếp lại danh sách ID dự án theo hạng, giữ nguyên thứ tự trong cùng hạng. */
function hh_sort_projects_by_rank( array $ids ) {
	$pos = array_flip( array_values( $ids ) );
	usort( $ids, static fn( $a, $b ) => array( hh_project_rank( $a ), $pos[ $a ] ) <=> array( hh_project_rank( $b ), $pos[ $b ] ) );
	return $ids;
}

/** Truy vấn dự án ngoài web (danh sách, trang chủ, loại dự án) với thứ tự mặc định: thêm hạng lên đầu ORDER BY. */
add_filter(
	'posts_clauses',
	static function ( $clauses, $q ) {
		if ( is_admin() && ! wp_doing_ajax() ) {
			return $clauses;
		}
		$pt         = $q->get( 'post_type' );
		$is_project = 'du-an' === $pt || ( array( 'du-an' ) === $pt ) || ( '' === $pt && $q->is_tax( 'loai-du-an' ) );
		$orderby    = $q->get( 'orderby' );
		if ( ! $is_project || ! in_array( $orderby, array( '', 'date', 'menu_order', 'menu_order date', 'modified' ), true ) || $q->get( 'hh_no_rank' ) || $q->get( 'tk' ) || $q->get( 's' ) ) { // Đang tìm kiếm: giữ thứ tự khớp tên (dự án đúng tên lên đầu).
			return $clauses;
		}
		global $wpdb;
		$p    = $wpdb->posts;
		$m    = $wpdb->postmeta;
		$rank = "(CASE WHEN EXISTS (SELECT 1 FROM $m hr1 WHERE hr1.post_id = $p.ID AND hr1.meta_key = 'hh_p_sold_out' AND hr1.meta_value = '1') THEN 3"
			. " ELSE COALESCE((SELECT CASE hr2.meta_value WHEN 'dang-mo-ban' THEN 0 WHEN 'sap-mo-ban' THEN 1 WHEN 'dang-ban-giao' THEN 2 WHEN 'da-ban-giao' THEN 3 ELSE 2 END"
			. " FROM $m hr2 WHERE hr2.post_id = $p.ID AND hr2.meta_key = 'hh_p_status' LIMIT 1), 2) END)";
		$clauses['orderby'] = $rank . ' ASC' . ( '' !== trim( (string) $clauses['orderby'] ) ? ', ' . $clauses['orderby'] : '' );
		return $clauses;
	},
	10,
	2
);
