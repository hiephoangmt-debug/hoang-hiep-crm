<?php
/**
 * Sun Solar Residence – chính sách bán hàng CSBH04 (áp dụng từ 07/08/2026), bảng hàng, lịch thanh toán, vay vốn và ảnh
 * (phối cảnh, tiện ích, mặt bằng tầng 5 / 6 / 8 – 19) do anh Hiệp gửi 09/10/2026. Dữ liệu ở data/sun-solar-csbh04.json
 * (cùng nội dung gói Nhập nhanh), ảnh ở img/sun-solar/.
 * Nhập dữ liệu Đà Nẵng: chỉ điền ô còn trống; ảnh tải ngầm vào Thư viện. Dự án đã nhập gói Nhập nhanh thì bỏ qua phần ảnh
 * (tránh ảnh trùng).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$file = HH_CRM_DIR . 'data/sun-solar-csbh04.json';
		$data = is_readable( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null; // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! $data || ! function_exists( 'hh_quick_project_fields' ) ) {
			return $projects;
		}
		$fields = hh_quick_project_fields();
		foreach ( $projects as $i => $p ) {
			if ( 'sun-solar-residence' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $data['meta'] as $key => $value ) {
				if ( isset( $fields[ $key ] ) ) {
					$projects[ $i ]['meta'][ $key ] = hh_quick_project_value( $fields[ $key ][0], $value );
				}
			}
			$post = get_page_by_path( 'sun-solar-residence', OBJECT, 'du-an' );
			if ( ! $post || ! get_post_meta( $post->ID, '_hh_quick_post', true ) ) {
				$projects[ $i ]['meta']['hh_p_image_links'] = implode( "\n", $data['image_links'] );
			}
		}
		return $projects;
	},
	30
);
