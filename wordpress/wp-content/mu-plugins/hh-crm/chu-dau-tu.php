<?php
/**
 * Trang chủ đầu tư tại Đà Nẵng:
 *   /chu-dau-tu/            danh sách chủ đầu tư (số dự án trên web, lĩnh vực, khu vực)
 *   /chu-dau-tu/<slug>/     hồ sơ từng chủ đầu tư: là ai, thông tin doanh nghiệp, các mốc tại Đà Nẵng,
 *                           dự án đã / đang triển khai (dự án có trên web tự lấy theo ô "Chủ đầu tư"), lưu ý khi mua, hỏi đáp, nguồn.
 * Dữ liệu: chu-dau-tu.json (tổng hợp từ nguồn công khai – website doanh nghiệp, báo chí, cổng thông tin – có link nguồn từng hồ sơ).
 * Giao diện: themes/hoanghiep/chu-dau-tu.php. SEO, sitemap: themes/hoanghiep/inc/seo.php.
 */

defined( 'ABSPATH' ) || exit;

/** Tất cả hồ sơ: [slug => hồ sơ], theo thứ tự trong file. */
function hh_cdt_all() {
	static $all = null;
	if ( null === $all ) {
		$all  = array();
		$file = __DIR__ . '/chu-dau-tu.json';
		$data = is_readable( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : array(); // phpcs:ignore WordPress.WP.AlternativeFunctions
		foreach ( (array) $data as $d ) {
			if ( ! empty( $d['slug'] ) && ! empty( $d['name'] ) ) {
				$all[ sanitize_title( $d['slug'] ) ] = $d;
			}
		}
	}
	return $all;
}

add_action(
	'init',
	static function () {
		add_rewrite_rule( '^chu-dau-tu/?$', 'index.php?post_type=du-an&hh_cdt=tat-ca', 'top' );
		add_rewrite_rule( '^chu-dau-tu/([^/]+)/?$', 'index.php?post_type=du-an&hh_cdt=$matches[1]', 'top' );
	},
	11
);
add_filter( 'query_vars', static fn( $vars ) => array_merge( $vars, array( 'hh_cdt' ) ) );

/** 'tat-ca' (trang danh sách), slug chủ đầu tư, hoặc '' (không phải trang chủ đầu tư / slug không có). */
function hh_cdt_key() {
	$key = sanitize_title( (string) get_query_var( 'hh_cdt' ) );
	if ( 'tat-ca' === $key ) {
		return $key;
	}
	return isset( hh_cdt_all()[ $key ] ) ? $key : '';
}

function hh_cdt_url( $slug = '' ) {
	return home_url( '/chu-dau-tu/' . ( $slug && 'tat-ca' !== $slug ? $slug . '/' : '' ) );
}

/** Truy vấn chính chỉ cần 1 bài để không 404; slug không có hồ sơ → 404. */
add_action(
	'pre_get_posts',
	static function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() || ! $q->get( 'hh_cdt' ) ) {
			return;
		}
		$q->set( 'posts_per_page', 1 );
		$q->set( 'no_found_rows', true );
	},
	5
);
add_action(
	'wp',
	static function () {
		if ( get_query_var( 'hh_cdt' ) && ! hh_cdt_key() ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
		}
	}
);

/** Slug chủ đầu tư khớp với chữ trong ô "Chủ đầu tư" của dự án (tên dài khớp trước; một dự án có thể có 2 bên). */
function hh_cdt_match( $text ) {
	$text = (string) $text;
	if ( '' === trim( $text ) ) {
		return array();
	}
	static $aliases = null;
	if ( null === $aliases ) {
		$aliases = array();
		foreach ( hh_cdt_all() as $slug => $d ) {
			foreach ( array_merge( array( $d['name'] ), (array) ( $d['aliases'] ?? array() ) ) as $a ) {
				$a = trim( (string) $a );
				if ( mb_strlen( $a ) >= 3 ) {
					$aliases[ $a ] = $slug;
				}
			}
		}
		uksort( $aliases, static fn( $a, $b ) => mb_strlen( $b ) - mb_strlen( $a ) );
	}
	$out = array();
	foreach ( $aliases as $a => $slug ) {
		// Tên ngắn (SDN, FPT, BRG…) phải đứng riêng một từ.
		$hit = mb_strlen( $a ) <= 4 ? preg_match( '/(?<![\p{L}\p{N}])' . preg_quote( $a, '/' ) . '(?![\p{L}\p{N}])/u', $text ) : false !== mb_stripos( $text, $a );
		if ( $hit && ! in_array( $slug, $out, true ) ) {
			$out[] = $slug;
		}
	}
	return $out;
}

/** ID dự án trên web của chủ đầu tư: theo ô "Chủ đầu tư" và theo danh sách dự án trong hồ sơ (site_slug). Dự án cha trước, con sau. */
function hh_cdt_projects( $slug ) {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$d     = hh_cdt_all()[ $slug ] ?? array();
	$named = array_filter( array_column( (array) ( $d['projects'] ?? array() ), 'site_slug' ) );
	$ids   = get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 400, 'fields' => 'ids', 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
	$out   = array();
	foreach ( $ids as $id ) {
		if ( in_array( $slug, hh_cdt_match( hh_meta( 'hh_p_developer', $id ) ), true ) || in_array( get_post_field( 'post_name', $id ), $named, true ) ) {
			$out[] = (int) $id;
		}
	}
	usort( $out, static fn( $a, $b ) => ( wp_get_post_parent_id( $a ) ? 1 : 0 ) <=> ( wp_get_post_parent_id( $b ) ? 1 : 0 ) );
	return $cache[ $slug ] = $out; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
}

/** Chữ "Chủ đầu tư" của dự án; tên chủ đầu tư có hồ sơ thành link sang trang hồ sơ (mỗi chủ đầu tư một link). */
function hh_cdt_link_html( $text ) {
	$html = esc_html( (string) $text );
	foreach ( hh_cdt_match( $text ) as $slug ) {
		$d     = hh_cdt_all()[ $slug ];
		$names = array_map( 'esc_html', array_merge( (array) ( $d['aliases'] ?? array() ), array( $d['name'] ) ) );
		// Chỗ xuất hiện sớm nhất trong phần chữ chưa có link (cùng chỗ thì tên dài hơn).
		$parts = preg_split( '/(<a\b[^>]*>.*?<\/a>)/u', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
		$best  = null;
		foreach ( $parts as $i => $part ) {
			if ( 0 === strpos( $part, '<a' ) ) {
				continue;
			}
			foreach ( $names as $n ) {
				$pos = '' === $n ? false : mb_stripos( $part, $n );
				if ( false !== $pos && ( ! $best || $pos < $best[1] || ( $pos === $best[1] && mb_strlen( $n ) > mb_strlen( $best[2] ) ) ) ) {
					$best = array( $i, $pos, $n );
				}
			}
			if ( $best ) {
				break;
			}
		}
		if ( $best ) {
			list( $i, $pos, $n ) = $best;
			$part        = $parts[ $i ];
			$parts[ $i ] = mb_substr( $part, 0, $pos ) . '<a href="' . esc_url( hh_cdt_url( $slug ) ) . '">' . mb_substr( $part, $pos, mb_strlen( $n ) ) . '</a>' . mb_substr( $part, $pos + mb_strlen( $n ) );
			$html        = implode( '', $parts );
		}
	}
	return $html;
}

/** Ngày cập nhật: file hồ sơ hoặc dự án mới nhất. */
function hh_cdt_lastmod( $slug ) {
	$max = (int) @filemtime( __DIR__ . '/chu-dau-tu.json' ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	foreach ( 'tat-ca' === $slug ? array() : hh_cdt_projects( $slug ) as $id ) {
		$max = max( $max, (int) get_post_modified_time( 'U', true, $id ) );
	}
	return $max;
}

/** Trang danh sách /chu-dau-tu/: tiêu đề, mô tả, đoạn giới thiệu, hỏi đáp. */
function hh_cdt_index_meta() {
	$n = count( hh_cdt_all() );
	return array(
		'title' => 'Chủ đầu tư bất động sản Đà Nẵng: hồ sơ, dự án đã làm',
		'desc'  => 'Hồ sơ ' . $n . ' chủ đầu tư có dự án tại Đà Nẵng: Sun Group, Vingroup, BRG, FPT, Đạt Phương… họ là ai, đã làm dự án nào, lưu ý khi mua. Hoàng Hiệp tổng hợp.',
		'intro' => array(
			'Trước khi chọn căn hộ, biệt thự hay lô đất, câu hỏi đầu tiên nên đặt ra là <strong>ai đứng sau dự án</strong>. Cùng một vị trí, sản phẩm của một chủ đầu tư đã bàn giao nhiều dự án đúng hẹn và có hệ sinh thái vận hành sẽ khác hẳn sản phẩm của một công ty lần đầu làm nhà ở. Trang này gom hồ sơ ' . $n . ' chủ đầu tư đang có hoặc đã có dự án tại Đà Nẵng – kể cả khu vực Hội An, Điện Bàn, Duy Xuyên thuộc Quảng Nam cũ, nay là một phần của thành phố từ ngày 1/7/2025.',
			'Mỗi hồ sơ trả lời bốn việc: doanh nghiệp là ai (tên pháp lý, công ty mẹ, lĩnh vực), họ đến Đà Nẵng từ khi nào, đã và đang làm những dự án gì, và người mua cần lưu ý gì với sản phẩm của họ – thời hạn sở hữu, ngân hàng bảo lãnh, kinh nghiệm bàn giao, mô hình cho thuê. Danh sách dự án trên trang hồ sơ có hai phần: dự án đang có trang riêng trên hiephoangmt.com (bảng giá, mặt bằng, tiến độ cập nhật) và các dự án khác của chủ đầu tư tại Đà Nẵng để anh chị có bức tranh đầy đủ.',
			'Thông tin được tổng hợp từ website doanh nghiệp, cổng thông tin của thành phố và báo chí, kèm link nguồn ở cuối mỗi hồ sơ. Hồ sơ không thay cho việc kiểm tra pháp lý từng căn: khi xuống tiền, anh chị vẫn cần xem văn bản đủ điều kiện bán nhà hình thành trong tương lai, hợp đồng mua bán và bảo lãnh ngân hàng của đúng dự án. Hoàng Hiệp hỗ trợ đối chiếu hồ sơ dự án miễn phí – gọi hoặc nhắn Zalo khi cần.',
		),
		'faq'   => array(
			array( 'Kiểm tra uy tín chủ đầu tư bằng cách nào?', 'Xem các dự án họ đã bàn giao (đúng hẹn không, đã có sổ chưa), tên pháp nhân trên hợp đồng mua bán có trùng chủ đầu tư được giao dự án không, dự án có văn bản đủ điều kiện bán nhà hình thành trong tương lai và có ngân hàng bảo lãnh nghĩa vụ tài chính hay không.' ),
			array( 'Chủ đầu tư và đơn vị phát triển dự án khác nhau thế nào?', 'Chủ đầu tư là pháp nhân được giao dự án và đứng tên trên hợp đồng mua bán. Đơn vị phát triển hoặc phân phối có thể là công ty khác (ví dụ thương hiệu bất động sản của tập đoàn). Khi ký hợp đồng, hãy kiểm tra đúng tên pháp nhân chủ đầu tư.' ),
			array( 'Dự án có thời hạn 50 năm khác sở hữu lâu dài ra sao?', 'Căn hộ trên đất ở có thể được sở hữu lâu dài; căn hộ dịch vụ, condotel hoặc sản phẩm trên đất thương mại dịch vụ thường theo thời hạn của dự án (ví dụ 50 năm). Thông tin này ghi trên giấy chứng nhận và hợp đồng – mỗi hồ sơ chủ đầu tư có nêu loại sản phẩm thường gặp.' ),
			array( 'Hội An, Điện Bàn có được tính là Đà Nẵng không?', 'Có. Từ ngày 1/7/2025, tỉnh Quảng Nam hợp nhất vào thành phố Đà Nẵng, nên các dự án ở Hội An, Điện Bàn, Duy Xuyên… nay thuộc Đà Nẵng; trên trang này ghi kèm "(Quảng Nam cũ)" để dễ nhận biết.' ),
		),
	);
}
