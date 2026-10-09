<?php
/**
 * Thẻ (tag) cho bài tin hạ tầng – quy hoạch: nút Dự án → Nhập dữ liệu Đà Nẵng gắn thêm thẻ (không xoá thẻ anh tự thêm).
 * Thẻ dùng chung giữa nhiều bài để trang thẻ /tag/…/ có đủ bài; trang thẻ dưới 3 bài để noindex (giao diện, inc/seo.php).
 */

defined( 'ABSPATH' ) || exit;

/** slug bài => thẻ riêng (cộng thêm thẻ chung theo chuyên mục). */
function hh_news_tags_map() {
	return array(
		'toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san'          => array( 'Quy hoạch Đà Nẵng', 'Cầu Hòa Xuân', 'Quốc lộ 14D', 'Liên Chiểu', 'Cảng Liên Chiểu' ),
		'cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu'  => array( 'Liên Chiểu', 'Cảng Liên Chiểu', 'Khu thương mại tự do' ),
		'trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san'     => array( 'Trung tâm tài chính quốc tế', 'Sông Hàn', 'Sơn Trà' ),
		'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang'            => array( 'Cầu Hòa Xuân', 'Hòa Xuân', 'Cẩm Lệ' ),
		'duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an'   => array( 'Đường ven biển Võ Chí Công', 'Hội An' ),
		'mo-rong-nha-ga-t2-san-bay-da-nang-bat-dong-san-cho-thue'       => array( 'Sân bay Đà Nẵng', 'Căn hộ cho thuê' ),
		'ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang' => array( 'Đường sắt tốc độ cao', 'Hòa Vang', 'Quy hoạch Đà Nẵng' ),
		'hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh'        => array( 'Hợp nhất Đà Nẵng Quảng Nam', 'Quy hoạch Đà Nẵng', 'Hội An' ),
		'da-nang-de-xuat-xay-cau-moi-qua-song-han'                      => array( 'Sông Hàn', 'Cầu qua sông Hàn', 'Hầm chui qua sông Hàn', 'Quy hoạch Đà Nẵng', 'Đầu tư công Đà Nẵng', 'Hải Châu', 'Sơn Trà' ),
		'bang-gia-dat-da-nang-sua-doi-2026'                             => array( 'Bảng giá đất Đà Nẵng', 'Pháp lý nhà đất', 'HĐND Đà Nẵng', 'Quy hoạch Đà Nẵng' ),
		'duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu'         => array( 'Đường tránh Nam Hải Vân', 'Liên Chiểu', 'Cảng Liên Chiểu' ),
		'tin-ha-tang-da-nang-thang-10-2026'                             => array( 'Cầu Hòa Xuân', 'Quốc lộ 14D', 'Liên Chiểu', 'Đầu tư công Đà Nẵng', 'HĐND Đà Nẵng', 'Hợp nhất Đà Nẵng Quảng Nam' ),
		'cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy'           => array( 'Ngũ Hành Sơn', 'Biển Đà Nẵng', 'Bất động sản Đà Nẵng' ),
	);
}

add_filter(
	'hh_news_items',
	static function ( $items ) {
		$map = hh_news_tags_map();
		foreach ( $items as $i => $n ) {
			$tags = $map[ $n['slug'] ] ?? array();
			if ( 'Hạ tầng & quy hoạch' === ( $n['category'] ?? '' ) ) {
				$tags = array_merge( array( 'Hạ tầng Đà Nẵng', 'Bất động sản Đà Nẵng' ), $tags );
			}
			if ( $tags ) {
				$items[ $i ]['tags'] = array_values( array_unique( array_merge( (array) ( $n['tags'] ?? array() ), $tags ) ) );
			}
		}
		return $items;
	}
);
