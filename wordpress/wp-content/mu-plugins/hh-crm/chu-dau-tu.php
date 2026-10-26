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
	if ( 'tat-ca' === $key || isset( hh_cdt_groups()[ $key ] ) ) {
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
	// Đơn vị phân phối / hợp tác bán hàng không phải chủ đầu tư: bỏ phần "; phân phối …", "; phát triển: …", "; hợp tác: …".
	$text = preg_replace( '/\s*[;–]\s*(?:phân phối|phát triển\s*(?:,\s*phân phối)?\s*:|hợp tác\s*:)[^;]*/iu', '', $text );
	$text = preg_replace( '/\s*phân phối\s*:?\s*[^;()]*/iu', '', $text );
	$out  = array();
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

/* -------------------------------------------------------------------------
 * Nhóm chủ đầu tư theo khu vực / loại hình: /chu-dau-tu/<nhóm>/ (VD đất nền Điện Bàn – Quảng Nam cũ).
 * ---------------------------------------------------------------------- */

/** Khóa nhóm => cấu hình. */
function hh_cdt_groups() {
	// Tạm không dùng trang theo khu vực (chưa gom đủ chủ đầu tư từng vùng) – link cũ chuyển về /chu-dau-tu/.
	// Muốn bật lại: bỏ dòng return array() dưới đây.
	return array();
	return array( // phpcs:ignore Squiz.PHP.NonExecutableCode
		'phia-bac-da-nang' => array(
			'menu'    => 'Phía Bắc Đà Nẵng (Liên Chiểu – Hải Vân)',
			'h1'      => 'Chủ đầu tư dự án phía Bắc Đà Nẵng (Liên Chiểu – Hải Vân)',
			'title'   => 'Chủ đầu tư phía Bắc Đà Nẵng: Liên Chiểu, Hải Vân, Làng Vân',
			'desc'    => 'Ai đang làm dự án ở phía Bắc Đà Nẵng – Liên Chiểu, Hải Vân, Làng Vân: Vinhomes Hải Vân Bay (Vingroup), các khu đô thị của SDN… dự án, tình trạng, lưu ý pháp lý.',
			'area'    => 'lien-chieu',
			'types'   => array(),
			'where'   => '/Liên Chiểu|Hải Vân|Làng Vân|Hòa Hiệp|Hòa Khánh|Hòa Minh|Nam Ô|Hòa Bắc|Hòa Liên|Bàu Tràm/u',
			'kind'    => '/./u',
			'exclude' => '/khu công nghiệp|\bKCN\b/iu',
			'intro'   => array(
				'Phía Bắc Đà Nẵng – khu Liên Chiểu, chân đèo Hải Vân, vịnh Làng Vân – là hướng phát triển mới của thành phố: cảng Liên Chiểu, tuyến đường ven biển Nguyễn Tất Thành nối dài và các khu đô thị quanh hồ Bàu Tràm. Nổi bật nhất là khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân, ra mắt dưới tên <strong>Vinhomes Hải Vân Bay</strong>, do Công ty CP Vinpearl (Tập đoàn Vingroup) làm chủ đầu tư.',
				'Ngoài Làng Vân, khu Tây Bắc có các khu đô thị, đất nền đã hình thành từ nhiều năm, phần lớn do Công ty CP Đầu tư Sài Gòn – Đà Nẵng (SDN) làm chủ đầu tư. Mức độ hoàn thiện pháp lý khác nhau giữa các khu – có khu đã cấp sổ, có khu từng chậm sổ nhiều năm – nên người mua cần xem hồ sơ của đúng dự án và đúng lô.',
				'Bảng dưới đây gom các chủ đầu tư có dự án ở phía Bắc thành phố, kèm link hồ sơ từng chủ đầu tư. Trang chỉ ghi chủ đầu tư được giao dự án, không ghi đơn vị phân phối.',
			),
			'faq'     => array(
				array( 'Vinhomes Hải Vân Bay (Làng Vân) do ai làm chủ đầu tư?', 'Chủ đầu tư là Công ty CP Vinpearl, thuộc Tập đoàn Vingroup; Vinhomes – công ty cùng tập đoàn – phát triển và ra mắt dự án dưới tên Vinhomes Hải Vân Bay.' ),
				array( 'Phía Bắc Đà Nẵng gồm những khu nào?', 'Chủ yếu là Liên Chiểu cũ (nay gồm các phường Hải Vân, Liên Chiểu, Hòa Khánh) cùng khu vực chân đèo Hải Vân, vịnh Làng Vân và quanh hồ Bàu Tràm.' ),
				array( 'Mua đất nền Liên Chiểu cần lưu ý gì?', 'Kiểm tra sổ của đúng lô, chủ đầu tư được giao dự án, văn bản cho phép chuyển nhượng và tình trạng hạ tầng xung quanh; một số khu từng chậm cấp sổ nên cần xác nhận tiến độ trước khi đặt cọc.' ),
			),
		),
		'dat-nen-dien-ban' => array(
			'menu'   => 'Đất nền Điện Bàn (Quảng Nam cũ)',
			'h1'     => 'Chủ đầu tư đất nền Điện Bàn (Quảng Nam cũ)',
			'title'  => 'Chủ đầu tư đất nền Điện Bàn, Điện Ngọc (Quảng Nam cũ)',
			'desc'   => 'Ai làm chủ đầu tư các khu đất nền Điện Bàn – Điện Ngọc, Điện Dương, Điện Nam (Quảng Nam cũ, nay thuộc Đà Nẵng): dự án, tình trạng, lưu ý pháp lý. Hoàng Hiệp tổng hợp.',
			'area'   => 'dien-ban',
			'types'  => array( 'dat-nen' ),
			'where'  => '/Điện\s*(Bàn|Ngọc|Dương|Nam|Thắng|Phong|Minh|Phương|Hồng|Tiến|Hòa|Hoà|An|Thọ|Quang|Trung|Phước)/u',
			'kind'   => '/đất|khu đô thị|khu dân cư|lô|shophouse|nhà phố/iu',
			'intro'  => array(
				'Điện Bàn – nhất là dải Điện Ngọc, Điện Dương, Điện Nam giáp ranh Ngũ Hành Sơn – là nơi tập trung nhiều khu đất nền nhất của vùng Quảng Nam cũ. Từ ngày 1/7/2025, khu vực này thuộc thành phố Đà Nẵng, nên các khu đô thị ven biển, ven sông Cổ Cò ở đây được nhiều người mua Đà Nẵng quan tâm vì giá mềm hơn nội thành và gần biển.',
				'Điểm cần lưu ý ở Điện Bàn là pháp lý không đồng đều giữa các dự án: có khu đã cấp sổ từng lô, có khu còn vướng giải phóng mặt bằng, chậm giao sổ hoặc đang được rà soát. Vì vậy, trước khi xuống tiền, nên biết rõ <strong>ai là chủ đầu tư</strong> được giao dự án, dự án đã đủ điều kiện chuyển nhượng quyền sử dụng đất chưa và lô định mua đã có sổ hay chưa. Trang này gom các chủ đầu tư có đất nền ở Điện Bàn, kèm dự án của từng bên và link hồ sơ chi tiết.',
				'Trang chỉ ghi chủ đầu tư – pháp nhân được giao dự án – không ghi đơn vị phân phối hay sàn môi giới. Hoàng Hiệp hỗ trợ kiểm tra sổ, quy hoạch và tình trạng từng lô trước khi anh chị đặt cọc.',
			),
			'faq'    => array(
				array( 'Đất nền Điện Bàn nay thuộc Đà Nẵng phải không?', 'Đúng. Từ 1/7/2025, tỉnh Quảng Nam hợp nhất vào thành phố Đà Nẵng; các phường Điện Ngọc, Điện Dương, Điện Nam… nay thuộc Đà Nẵng. Giấy tờ cũ vẫn có giá trị, địa chỉ hành chính được cập nhật khi làm thủ tục.' ),
				array( 'Mua đất nền Điện Bàn cần kiểm tra gì?', 'Tên chủ đầu tư và quyết định giao dự án, văn bản cho phép chuyển nhượng quyền sử dụng đất đã có hạ tầng, sổ của đúng lô (hoặc tiến độ cấp sổ), quy hoạch chi tiết và tình trạng giải phóng mặt bằng xung quanh lô.' ),
				array( 'Vì sao có khu đất nền Điện Bàn chậm cấp sổ?', 'Thường do chưa xong giải phóng mặt bằng, chủ đầu tư chưa hoàn thành nghĩa vụ tài chính hoặc dự án đang bị rà soát. Hồ sơ từng chủ đầu tư trên trang này có ghi các lưu ý pháp lý đã được báo chí đưa tin.' ),
			),
		),
	);
}

/**
 * Nội dung nhóm: [ [slug hồ sơ|'' , tên chủ đầu tư, [ [tên dự án, url|'' , tình trạng], … ] ], … ] – dự án trên web (theo loại + khu vực)
 * và dự án trong hồ sơ chủ đầu tư có vị trí, loại hình khớp nhóm. Chủ đầu tư nhiều dự án đứng trước.
 */
function hh_cdt_group_rows( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$g    = hh_cdt_groups()[ $key ];
	$rows = array();
	$seen = array();
	$ids  = get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 400, 'fields' => 'ids', 'orderby' => 'title', 'order' => 'ASC' ) );
	foreach ( $ids as $id ) {
		$types = wp_list_pluck( get_the_terms( $id, 'loai-du-an' ) ?: array(), 'slug' );
		$areas = wp_list_pluck( get_the_terms( $id, 'khu-vuc' ) ?: array(), 'slug' );
		if ( ( $g['types'] && ! array_intersect( $types, $g['types'] ) ) || ! in_array( $g['area'], $areas, true ) ) {
			continue;
		}
		$parent = (int) get_post_meta( $id, 'hh_p_parent', true ) ?: wp_get_post_parent_id( $id );
		if ( $parent && in_array( $parent, $ids, true ) && in_array( $g['area'], wp_list_pluck( get_the_terms( $parent, 'khu-vuc' ) ?: array(), 'slug' ), true ) ) {
			$seen[ get_post_field( 'post_name', $id ) ] = true; // Phân khu: đã có dự án chính.
			continue;
		}
		$dev   = (string) hh_meta( 'hh_p_developer', $id );
		$slugs = hh_cdt_match( $dev );
		$k     = $slugs ? $slugs[0] : 'x:' . $dev;
		if ( ! isset( $rows[ $k ] ) ) {
			$rows[ $k ] = array( $slugs ? $slugs[0] : '', $slugs ? hh_cdt_all()[ $slugs[0] ]['name'] : ( '' !== $dev ? $dev : 'Đang cập nhật' ), array() );
		}
		$rows[ $k ][2][]                         = array( get_the_title( $id ), get_permalink( $id ), hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status', $id ) ) );
		$seen[ get_post_field( 'post_name', $id ) ] = true;
	}
	foreach ( hh_cdt_all() as $slug => $d ) {
		foreach ( (array) ( $d['projects'] ?? array() ) as $p ) {
			if ( ! empty( $p['site_slug'] ) && isset( $seen[ $p['site_slug'] ] ) ) {
				continue;
			}
			if ( ! preg_match( $g['where'], (string) ( $p['where'] ?? '' ) ) || ! preg_match( $g['kind'], ( $p['type'] ?? '' ) . ' ' . $p['name'] ) || ( ! empty( $g['exclude'] ) && preg_match( $g['exclude'], ( $p['type'] ?? '' ) . ' ' . $p['name'] ) ) ) {
				continue;
			}
			if ( ! isset( $rows[ $slug ] ) ) {
				$rows[ $slug ] = array( $slug, $d['name'], array() );
			}
			$post            = ! empty( $p['site_slug'] ) ? get_page_by_path( $p['site_slug'], OBJECT, 'du-an' ) : null;
			$rows[ $slug ][2][] = array( $p['name'], $post && 'publish' === $post->post_status ? get_permalink( $post ) : '', (string) ( $p['status'] ?? '' ) );
		}
	}
	$rows = array_values( $rows );
	usort( $rows, static fn( $a, $b ) => count( $b[2] ) <=> count( $a[2] ) );
	return $cache[ $key ] = $rows; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
}

/** Trang khu vực đã bỏ: /chu-dau-tu/phia-bac-da-nang/, /chu-dau-tu/dat-nen-dien-ban/ → 301 về danh sách chủ đầu tư. */
add_action(
	'template_redirect',
	static function () {
		$k = sanitize_title( (string) get_query_var( 'hh_cdt' ) );
		if ( in_array( $k, array( 'phia-bac-da-nang', 'dat-nen-dien-ban' ), true ) && ! isset( hh_cdt_groups()[ $k ] ) ) {
			wp_safe_redirect( hh_cdt_url(), 301 );
			exit;
		}
	},
	1
);
