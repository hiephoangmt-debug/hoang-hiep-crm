<?php
/**
 * FPT Plaza 3 – 13/11/2026: chủ đầu tư (Công ty CP Đô thị FPT Đà Nẵng – FPT City) thông báo hoàn thành cấp
 * Giấy chứng nhận quyền sở hữu cho 100% căn hộ, sau khoảng 7 tháng bàn giao (anh Hiệp gửi thông báo + 6 ảnh sự kiện trao sổ).
 * Cập nhật ô pháp lý, điểm nổi bật, tiến độ; thêm 6 ảnh thực tế buổi trao sổ (chỉ logo chủ đầu tư).
 * Ô nào anh đã tự sửa trong quản trị thì giữ nguyên.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $title = 'Trao sổ 13/11/2026' ) => "plugin:img/fpt-plaza-3/fpt-plaza-3-$f.jpg | $alt | tiến độ | $title";
		$imgs = array(
			$im( 'trao-so-11-2026-gia-dinh-1', 'Cư dân FPT Plaza 3 nhận Giấy chứng nhận quyền sở hữu căn hộ ngày 13/11/2026 (ảnh thực tế)' ),
			$im( 'trao-so-11-2026-gia-dinh-2', 'Gia đình cư dân FPT Plaza 3 nhận sổ hồng căn hộ (ảnh thực tế 13/11/2026)' ),
			$im( 'trao-so-11-2026-gia-dinh-3', 'Cư dân nhận Giấy chứng nhận quyền sở hữu căn hộ FPT Plaza 3 (ảnh thực tế 13/11/2026)' ),
			$im( 'trao-so-11-2026-thu-tuc-1', 'Khách hàng làm thủ tục nhận sổ hồng FPT Plaza 3 tại văn phòng chủ đầu tư (ảnh thực tế 13/11/2026)' ),
			$im( 'trao-so-11-2026-thu-tuc-2', 'Quầy làm thủ tục trao Giấy chứng nhận cho cư dân FPT Plaza 3 (ảnh thực tế 13/11/2026)' ),
			$im( 'trao-so-11-2026-thu-tuc-3', 'Cư dân FPT Plaza 3 chờ nhận sổ hồng tại văn phòng FPT City (ảnh thực tế 13/11/2026)' ),
		);
		$sw = array(
			'hh_p_highlights' => array( 'Đã bàn giao từ 4/2026, sổ hồng lâu dài', 'Đã bàn giao từ 17/4/2026; ngày 13/11/2026 hoàn thành cấp sổ hồng cho 100% căn hộ (sở hữu lâu dài với khách Việt Nam)' ),
			'hh_p_legal'      => array( 'Sở hữu lâu dài với khách Việt Nam', "Sở hữu lâu dài với khách Việt Nam\n13/11/2026: chủ đầu tư thông báo hoàn thành cấp Giấy chứng nhận quyền sở hữu cho 100% căn hộ, khoảng 7 tháng sau bàn giao" ),
			'hh_p_progress'   => array( '17/4/2026 | Khánh thành và bàn giao căn hộ', "17/4/2026 | Khánh thành và bàn giao căn hộ\n13/11/2026 | Hoàn thành cấp Giấy chứng nhận quyền sở hữu (sổ hồng) cho 100% căn hộ" ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'fpt-plaza-3' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $sw as $k => list( $from, $to ) ) {
				$cur = (string) ( $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()['fpt-plaza-3']['meta'][ $k ] ?? '' ) : '' ) );
				if ( '' === $cur || false !== strpos( $cur, '13/11/2026' ) ) {
					continue;
				}
				$new = false !== strpos( $cur, $from ) ? str_replace( $from, $to, $cur ) : $cur . "\n" . ( 'hh_p_highlights' === $k ? $to : trim( substr( $to, strlen( $from ) ) ) );
				$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
				$p['fix_meta'][ $k ][] = $cur;
				$p['meta'][ $k ]       = $new;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $cur ) {
				$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$p['fix_meta']['hh_p_image_links'][] = $cur;
			}
			$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	80
);
