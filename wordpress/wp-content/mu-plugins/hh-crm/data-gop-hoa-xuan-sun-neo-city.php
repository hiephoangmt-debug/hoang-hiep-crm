<?php
/**
 * "Khu đô thị sinh thái Hòa Xuân" và "Sun NeO City" là một dự án (tên cũ – tên mới, anh Hiệp 07/11/2026):
 * gộp về trang Sun NeO City. Trang cũ /du-an/kdt-sinh-thai-hoa-xuan/ chuyển bản nháp và tự chuyển hướng (301);
 * phân khu Đất nền Cồn Dầu, Euro Village 2 chuyển thành dự án thành phần của Sun NeO City.
 */

defined( 'ABSPATH' ) || exit;

const HH_HOA_XUAN_OLD = 'kdt-sinh-thai-hoa-xuan';

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$out = array();
		foreach ( $projects as $p ) {
			$slug = $p['slug'] ?? '';
			if ( HH_HOA_XUAN_OLD === $slug ) {
				continue; // Không nhập lại trang cũ.
			}
			if ( HH_HOA_XUAN_OLD === ( $p['parent'] ?? '' ) ) {
				$p['parent'] = 'sun-neo-city';
			}
			if ( 'sun-neo-city' === $slug ) {
				$m   = $p['meta'];
				$new = array(
					'hh_p_scale' => 'Khoảng 450 ha (Khu đô thị sinh thái ven sông Hòa Xuân); cùng Sun Riverpolis tạo hệ sinh thái hơn 1.000 ha',
					'hh_p_type'  => 'Căn hộ, shophouse khối đế, đất nền, nhà phố, biệt thự ven sông',
					'hh_p_zones' => trim( (string) ( $m['hh_p_zones'] ?? '' ) ) . "\nĐất nền Cồn Dầu | Đất nền phân lô | Khoảng 10 ha – 600 lô | Đang mở bán\nEuro Village 2 (giai đoạn 1B) | Nhà phố liền kề, biệt thự | 23,7 ha – 245 nhà phố, 175 biệt thự | Đã có sổ, giao dịch thứ cấp",
				);
				foreach ( $new as $k => $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = (string) ( $m[ $k ] ?? '' );
					$p['meta'][ $k ]       = $v;
				}
				$p['fix_excerpt'] = $p['excerpt'];
				$p['excerpt']     = 'Sun NeO City – trước đây quen gọi là Khu đô thị sinh thái Hòa Xuân – khu đô thị khoảng 450 ha của Sun Group ven sông Cẩm Lệ, phía Nam Đà Nẵng. Gồm các tòa căn hộ Cora, Spana, S-Light, đất nền Cồn Dầu, Euro Village 2 và phân khu Sunneva Island.';
				$p['type']        = array_values( array_unique( array_merge( (array) $p['type'], array( 'dat-nen' ) ) ) );
			}
			$out[] = $p;
		}
		return $out;
	},
	96
);

// Một lần: chuyển phân khu sang Sun NeO City, đưa trang cũ về bản nháp (không xoá).
add_action(
	'admin_init',
	static function () {
		if ( '1' === get_option( 'hh_gop_hoa_xuan_v1' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$old = get_page_by_path( HH_HOA_XUAN_OLD, OBJECT, 'du-an' );
		$neo = get_page_by_path( 'sun-neo-city', OBJECT, 'du-an' );
		if ( ! $neo ) {
			return;
		}
		if ( $old ) {
			foreach ( get_posts( array( 'post_type' => 'du-an', 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => 'hh_p_parent', 'meta_value' => $old->ID ) ) as $child ) {
				update_post_meta( $child, 'hh_p_parent', $neo->ID );
			}
			if ( 'publish' === $old->post_status ) {
				wp_update_post( array( 'ID' => $old->ID, 'post_status' => 'draft' ) );
			}
		}
		update_option( 'hh_gop_hoa_xuan_v1', '1', false );
	}
);

// Đường dẫn cũ → trang Sun NeO City (301), giữ khách và thứ hạng tìm kiếm.
add_action(
	'template_redirect',
	static function () {
		$path = (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( preg_match( '#/du-an/' . HH_HOA_XUAN_OLD . '/?$#', $path ) ) {
			wp_safe_redirect( home_url( '/du-an/sun-neo-city/' ), 301 );
			exit;
		}
	},
	1
);
