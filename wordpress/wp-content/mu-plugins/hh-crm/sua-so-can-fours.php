<?php
/**
 * FourS Tower: số căn theo Văn bản 17239/SXD-QLN (19/9/2026) là 2.394 căn – thay số cũ "khoảng 2.291 căn"
 * đã lưu trên web (trang FourS Tower, các tòa F1/F2/F5, Sun Riverpolis). Chạy một lần.
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_fours_so_can_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$fix = static fn( $t ) => str_replace( '2.291', '2.394', preg_replace( '/([Kk])hoảng 2\.291/u', '2.394', (string) $t ) );
		foreach ( array( 'fours-tower', 'fours-tower-f1-thap-tung', 'fours-tower-f2-thap-mai', 'fours-tower-f5-thap-cuc', 'sun-riverpolis' ) as $slug ) {
			$p = get_page_by_path( $slug, OBJECT, 'du-an' );
			if ( ! $p ) {
				continue;
			}
			foreach ( get_post_meta( $p->ID ) as $key => $vals ) {
				$v = (string) ( $vals[0] ?? '' );
				if ( false !== strpos( $v, '2.291' ) && ! is_serialized( $v ) ) {
					update_post_meta( $p->ID, $key, $fix( $v ) );
				}
			}
			$upd = array();
			foreach ( array( 'post_excerpt', 'post_content' ) as $f ) {
				if ( false !== strpos( (string) $p->$f, '2.291' ) ) {
					$upd[ $f ] = $fix( $p->$f );
				}
			}
			if ( $upd ) {
				wp_update_post( array( 'ID' => $p->ID ) + $upd );
			}
		}
		update_option( 'hh_fours_so_can_v1', 1, false );
	}
);
