<?php
/**
 * SEO cho Google và công cụ tìm kiếm AI (ChatGPT, Perplexity, Gemini…):
 * meta description, Open Graph, schema.org JSON-LD, robots.txt, sitemap, /llms.txt.
 *
 * Nếu cài Rank Math / Yoast SEO / AIOSEO: plugin lo tiêu đề, meta, Open Graph, sitemap chính;
 * theme chỉ bổ sung phần plugin không có (schema dự án / tin nhà đất / hỏi đáp, mô tả tự sinh khi
 * plugin để trống, noindex trang lọc, sitemap trang Mua bán – Cho thuê theo khu vực) để không trùng.
 */

defined( 'ABSPATH' ) || exit;

/** Trang đích mua bán / cho thuê theo khu vực, loại nhà: số tin tối thiểu để Google lập chỉ mục. */
const HH_SEO_MIN_LISTINGS = 3;

function hh_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/**
 * Câu hỏi thường gặp tự sinh từ dữ liệu tin đăng (trang Mua bán / Cho thuê).
 * Returns [[question, answer], ...].
 */
function hh_listing_faq( $stats, $deal, $place, $what ) {
	$rent  = 'thue' === $deal;
	$verb  = $rent ? 'thuê' : 'mua';
	$faq   = array();
	$date  = wp_date( 'd/m/Y', $stats['latest'] ?: time() );
	if ( $stats['count'] && $stats['min'] ) {
		$answer = sprintf(
			'Theo %d tin đang đăng trên website (cập nhật %s), giá %s %s',
			$stats['count'],
			$date,
			$what,
			abs( $stats['min'] - $stats['max'] ) < 0.001 ? 'khoảng ' . hh_format_price( $stats['min'], $rent ) : 'dao động ' . hh_price_range( $stats['min'], $stats['max'], $rent )
		);
		if ( ! $rent && $stats['avg_m2'] ) {
			$answer .= ', trung bình khoảng ' . rtrim( rtrim( number_format( $stats['avg_m2'], 1, ',', '.' ), '0' ), ',' ) . ' triệu/m²';
		}
		$faq[] = array( 'Giá ' . $what . ' hiện nay khoảng bao nhiêu?', $answer . '. Giá thực tế phụ thuộc vị trí, pháp lý và hiện trạng từng căn.' );
	}
	if ( count( $stats['areas'] ) > 1 && false === strpos( $place, ',' ) ) {
		$parts = array();
		foreach ( $stats['areas'] as $name => $n ) {
			$parts[] = $name . ' (' . $n . ' tin)';
		}
		$faq[] = array( 'Khu vực nào ở Đà Nẵng đang có nhiều tin ' . ( $rent ? 'cho thuê' : 'bán' ) . ' nhất?', 'Hiện nhiều tin nhất là ' . implode( ', ', $parts ) . '.' );
	}
	$who = hoanghiep_opt( 'hh_person_name' ) . ' – ' . mb_strtolower( hoanghiep_opt( 'hh_person_title' ) ) . ( hoanghiep_opt( 'hh_person_company' ) ? ', hiện công tác tại ' . hoanghiep_opt( 'hh_person_company' ) : '' );
	$faq[] = array( 'Làm sao để xem nhà và được tư vấn ' . $what . '?', 'Gọi hoặc nhắn Zalo ' . hoanghiep_opt( 'hh_phone' ) . ', hoặc để lại thông tin trên website. ' . $who . ' sẽ sắp xếp lịch xem thực tế và kiểm tra pháp lý trước khi giao dịch.' );
	if ( ! $rent ) {
		$faq[] = array( 'Mua nhà đất ở ' . $place . ' có được hỗ trợ vay ngân hàng không?', 'Có. Mỗi tin bán có công cụ tính khoản vay, lãi và số tiền trả hằng tháng. Hiệp hỗ trợ kết nối ngân hàng và hồ sơ vay khi bạn chọn được căn phù hợp.' );
	} else {
		$faq[] = array( 'Thuê nhà ở ' . $place . ' cần đặt cọc bao nhiêu?', 'Thông thường đặt cọc 1–2 tháng tiền thuê, hợp đồng tối thiểu 6–12 tháng. Điều kiện cụ thể ghi trong mục "Điều kiện thuê" của từng tin.' );
	}
	return $faq;
}

/* -------------------------------------------------------------------------
 * Titles
 * ---------------------------------------------------------------------- */

/** Tiêu đề / mô tả SEO nhập sẵn cho bài (ô của Rank Math / Yoast), dùng cả khi chưa cài plugin. */
function hh_seo_custom_meta( $kind ) {
	if ( ! is_singular() || ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) ) {
		return '';
	}
	$keys  = 'title' === $kind ? array( 'rank_math_title', '_yoast_wpseo_title' ) : array( 'rank_math_description', '_yoast_wpseo_metadesc' );
	foreach ( $keys as $key ) {
		$value = trim( (string) get_post_meta( get_queried_object_id(), $key, true ) );
		if ( '' !== $value && ! preg_match( '/%%?[a-z_]+%%?/i', $value ) ) { // Bỏ qua mẫu có biến của plugin (%title%, %%sep%%…).
			return $value;
		}
	}
	return '';
}

add_filter( 'document_title_parts', 'hh_seo_title_parts' );
/** "Page 2" → "Trang 2" trong tiêu đề trang phân trang. */
add_filter(
	'document_title_parts',
	static function ( $parts ) {
		if ( ! empty( $parts['page'] ) ) {
			$parts['page'] = 'Trang ' . max( (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ), 2 );
		}
		return $parts;
	},
	20
);
/** Bảng tính căn: canonical là chính nó (trang noindex – không trỏ canonical sang trang dự án). */
add_filter( 'get_canonical_url', static fn( $url ) => function_exists( 'hh_is_units_page' ) && hh_is_units_page() ? hh_units_url( get_the_ID() ) : $url );
function hh_seo_title_parts( $parts ) {
	if ( hh_seo_custom_meta( 'title' ) ) {
		return array( 'title' => hh_seo_custom_meta( 'title' ) );
	}
	if ( hh_seo_hub_key() ) {
		return array( 'title' => hh_hub_pages()[ hh_seo_hub_key() ]['title'] );
	}
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		// Tháng của tin mới nhất (dữ liệu thật), không lấy ngày hôm nay.
		$latest         = get_query_var( 'hh_deal' ) ? (int) ( hh_listing_stats()['latest'] ?? 0 ) : 0;
		$parts['title'] = hh_listing_archive_title() . ( $latest ? ' – Cập nhật ' . wp_date( 'm/Y', $latest ) : '' );
	} elseif ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) {
		$name           = function_exists( 'hh_seo_project_short_name' ) ? hh_seo_project_short_name( get_the_ID() ) : get_the_title();
		$parts['title'] = 'Bảng tính căn ' . $name . ': chiết khấu, lịch thanh toán';
	} elseif ( hh_seo_special_key() ) {
		$latest         = hh_seo_latest_modified( array_keys( hh_special_projects( hh_seo_special_key() ) ) );
		$parts['title'] = hh_special_title( hh_seo_special_key() ) . ( $latest ? ' ' . wp_date( 'm/Y', $latest ) : '' );
	} elseif ( is_post_type_archive( 'du-an' ) ) {
		$parts['title'] = hh_pillar_heading() . ' – Căn hộ, biệt thự, đất nền';
	} elseif ( is_tax( 'loai-du-an' ) ) {
		$parts['title'] = hh_pillar_heading( get_queried_object() );
	} elseif ( is_tax( 'khu-vuc' ) ) {
		$parts['title'] = 'Dự án ' . single_term_title( '', false ) . ', Đà Nẵng: căn hộ, biệt thự, đất nền';
	} elseif ( is_singular( 'bat-dong-san' ) ) {
		$title = get_the_title();
		$deal  = 'thue' === hh_meta( 'hh_deal' ) ? 'Cho thuê' : 'Bán';
		if ( 0 !== mb_stripos( $title, $deal ) ) {
			$title = $deal . ' ' . mb_strtolower( mb_substr( $title, 0, 1 ) ) . mb_substr( $title, 1 );
		}
		$extra          = array_filter( array( hh_listing_price(), hh_meta( 'hh_area' ) ? hh_meta( 'hh_area' ) . 'm²' : '' ) );
		$parts['title'] = $title . ' – ' . implode( ', ', $extra ) . ' | ' . hh_listing_code();
	} elseif ( is_singular( 'du-an' ) && hh_meta( 'hh_p_status' ) ) {
		$parts['title'] = get_the_title() . ' – ' . hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status' ) );
	} elseif ( is_front_page() ) {
		// Trang chủ là trang tĩnh "Trang chủ" hay trang tin: luôn dùng tên thương hiệu, không ra "Trang chủ - …".
		return array( 'title' => hh_seo_home_title() );
	}
	return $parts;
}

/* -------------------------------------------------------------------------
 * Meta description, canonical helpers, Open Graph
 * ---------------------------------------------------------------------- */

function hh_seo_description() {
	if ( hh_seo_custom_meta( 'description' ) ) {
		return hh_seo_custom_meta( 'description' );
	}
	if ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) {
		$d = hh_units_data( get_the_ID() );
		return 'Bảng tính căn ' . get_the_title() . ( $d ? ' (' . hh_units_summary( $d ) . ')' : '' ) . ': chọn căn hoặc nhập giá để xem giá sau chiết khấu, lịch thanh toán, khoản vay. Báo giá: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_front_page() ) {
		return hh_seo_home_description();
	}
	if ( hh_seo_hub_key() ) {
		return hh_hub_pages()[ hh_seo_hub_key() ]['desc'];
	}
	if ( is_singular( 'du-an' ) ) {
		$bits = array_filter(
			array(
				get_the_title(),
				hh_project_type() ? 'dự án ' . mb_strtolower( hh_project_type()->name ) : hh_meta( 'hh_p_type' ),
				hh_meta( 'hh_p_address' ) ? 'tại ' . hh_meta( 'hh_p_address' ) : '',
				hh_meta( 'hh_p_developer' ) ? 'chủ đầu tư ' . hh_meta( 'hh_p_developer' ) : '',
				hh_meta( 'hh_p_price_from' ) ? 'giá ' . mb_strtolower( hh_project_price() ) : '',
			)
		);
		$lead = has_excerpt() ? get_the_excerpt() : '';
		$tail = hh_project_is_resale() ? ' Căn chuyển nhượng, cho thuê và giá thị trường mới nhất.' : ' Bảng giá, mặt bằng, tiến độ, chính sách mới nhất.';
		return trim( $lead ? $lead . ' ' . implode( ', ', $bits ) . '.' : implode( ', ', $bits ) . '.' . $tail );
	}
	if ( is_singular( 'bat-dong-san' ) ) {
		$deal = 'thue' === hh_meta( 'hh_deal' ) ? 'Cho thuê' : 'Bán';
		$bits = array_filter(
			array(
				0 === mb_stripos( get_the_title(), $deal ) ? get_the_title() : $deal . ' ' . mb_strtolower( mb_substr( get_the_title(), 0, 1 ) ) . mb_substr( get_the_title(), 1 ),
				'giá ' . hh_listing_price(),
				hh_meta( 'hh_area' ) ? hh_meta( 'hh_area' ) . ' m²' : '',
				hh_meta( 'hh_bedrooms' ) ? hh_meta( 'hh_bedrooms' ) . ' phòng ngủ' : '',
				hh_meta( 'hh_address' ),
			)
		);
		return implode( ', ', $bits ) . '. Mã tin ' . hh_listing_code() . '.';
	}
	if ( is_page( 'gioi-thieu' ) ) {
		return hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) . '. ' . hoanghiep_opt( 'hh_person_bio' );
	}
	if ( is_page( 'lien-he' ) ) {
		return 'Liên hệ ' . hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) . '. Hotline/Zalo ' . hoanghiep_opt( 'hh_phone' ) . ', email ' . hoanghiep_opt( 'hh_email' ) . '.';
	}
	if ( is_singular() ) {
		$post = get_post();
		return has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 30, '…' );
	}
	if ( is_tax() || is_category() ) {
		$desc = term_description();
		if ( $desc ) {
			return wp_strip_all_tags( $desc );
		}
	}
	if ( is_home() ) {
		return 'Tin tức bất động sản Đà Nẵng: thị trường, giá căn hộ, đất nền, hạ tầng, chính sách dự án và kinh nghiệm mua bán, cho thuê do Hoàng Hiệp tổng hợp.';
	}
	if ( is_category() ) {
		$cat = single_cat_title( '', false );
		return 'Chuyên mục ' . $cat . ': tin bất động sản Đà Nẵng mới nhất về ' . hh_lcfirst( $cat ) . ' – phân tích, số liệu tham khảo và lời khuyên từ Hoàng Hiệp. Hotline ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_tax( 'khu-vuc' ) ) {
		$name = single_term_title( '', false );
		return 'Dự án ' . $name . ', Đà Nẵng: căn hộ, biệt thự, đất nền đang mở bán và chuyển nhượng – vị trí, giá tham khảo, pháp lý. Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( hh_seo_special_key() ) {
		return hh_special_intro( hh_seo_special_key() )['lead'] . ' Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_tax( 'loai-du-an' ) ) {
		return 'Dự án ' . mb_strtolower( single_term_title( '', false ) ) . ' Đà Nẵng: danh sách dự án, vị trí, giá bán, mặt bằng, chính sách bán hàng và tiến độ. Tư vấn miễn phí: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_post_type_archive( 'du-an' ) ) {
		return 'Dự án Đà Nẵng: căn hộ, căn hộ dịch vụ, biệt thự, đất nền, shophouse – vị trí, giá bán, mặt bằng, tiến độ, chính sách mới nhất. Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		$st = hh_listing_stats();
		if ( $st['count'] && $st['min'] ) {
			$rent = 'thue' === get_query_var( 'hh_deal' );
			return hh_listing_archive_title() . ': ' . $st['count'] . ' tin đang có, giá ' . hh_price_range( $st['min'], $st['max'], $rent ) . ', thông tin pháp lý rõ ràng, cập nhật ' . wp_date( 'd/m/Y', $st['latest'] ?: time() ) . '. Đặt lịch xem nhà: ' . hoanghiep_opt( 'hh_phone' ) . '.';
		}
		return hh_listing_archive_title() . ': tin chính chủ, thông tin pháp lý rõ ràng, lọc theo giá, diện tích, khu vực. Đặt lịch xem nhà: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	return get_bloginfo( 'description' );
}

/** Ảnh chia sẻ khổ ngang 1200×630 (ảnh chân dung dọc bị Zalo/Facebook cắt mất đầu). */
function hh_seo_share_image() {
	return get_theme_file_uri( 'assets/img/og-hoang-hiep.jpg' );
}

function hh_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
	}
	if ( is_page( 'gioi-thieu' ) || is_front_page() ) {
		return hh_seo_share_image();
	}
	$fallback = hoanghiep_opt( 'hh_hero_image' );
	if ( ! $fallback ) {
		$latest = get_posts( array( 'post_type' => 'du-an', 'numberposts' => 1, 'meta_key' => '_thumbnail_id', 'fields' => 'ids' ) ); // phpcs:ignore
		$fallback = $latest ? wp_get_attachment_image_url( get_post_thumbnail_id( $latest[0] ), 'large' ) : '';
	}
	return $fallback;
}

/** Cắt mô tả ~155 ký tự (Google hiển thị khoảng 150–160), không cắt giữa chữ. */
function hh_seo_trim( $text, $max = 155 ) {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $text ) ) );
	if ( mb_strlen( $text ) <= $max ) {
		return $text;
	}
	$cut = mb_substr( $text, 0, $max - 1 );
	$sp  = mb_strrpos( $cut, ' ' );
	return rtrim( $sp > $max * 0.6 ? mb_substr( $cut, 0, $sp ) : $cut, " ,;:–-" ) . '…';
}

/** Ngày sửa gần nhất trong danh sách bài (dữ liệu thật để ghi "cập nhật", lastmod). */
function hh_seo_latest_modified( $ids ) {
	$max = 0;
	foreach ( array_filter( array_map( 'intval', (array) $ids ) ) as $id ) {
		$max = max( $max, (int) get_post_modified_time( 'U', true, $id ) );
	}
	return $max;
}

/** URL chuẩn của trang đang xem, có số trang (trang 2, 3… trỏ về chính nó, không về trang 1). */
function hh_seo_url() {
	$url   = hh_seo_base_url();
	$paged = max( (int) get_query_var( 'paged' ), 1 );
	if ( $paged > 1 && ! is_singular() && ! is_wp_error( $url ) ) {
		$url = trailingslashit( $url ) . user_trailingslashit( 'page/' . $paged, 'paged' );
	}
	return $url;
}

function hh_seo_base_url() {
	if ( hh_seo_hub_key() ) {
		return hh_hub_url( hh_seo_hub_key() );
	}
	if ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) {
		return hh_units_url( get_the_ID() );
	}
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_tax() || is_category() || is_tag() ) {
		return get_term_link( get_queried_object() );
	}
	if ( hh_seo_special_key() ) {
		return hh_special_url( hh_seo_special_key() );
	}
	if ( is_post_type_archive() ) {
		$deal = get_query_var( 'hh_deal' );
		$term = $deal ? hh_current_deal_term() : null;
		if ( $term ) {
			return hh_deal_term_url( $deal, $term );
		}
		return $deal ? hh_deal_url( $deal ) : get_post_type_archive_link( get_query_var( 'post_type' ) );
	}
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return get_permalink( get_option( 'page_for_posts' ) );
	}
	return home_url( '/' );
}

add_action( 'wp_head', 'hh_seo_head', 1 );
function hh_seo_head() {
	if ( hh_seo_plugin_active() || is_404() ) {
		return;
	}
	$desc  = hh_seo_trim( hh_seo_description() ?: get_bloginfo( 'description' ) );
	$image = hh_seo_image();
	$url   = hh_seo_url();
	$type  = is_singular( 'post' ) ? 'article' : 'website';

	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	if ( ! is_singular() && ! is_wp_error( $url ) ) {
		// Core prints canonical for singular pages only.
		printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( $url ) );
	}
	printf( "<meta property=\"og:locale\" content=\"vi_VN\">\n<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $type ) );
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( wp_get_document_title() ) );
	printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	if ( ! is_wp_error( $url ) ) {
		printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	}
	if ( $image ) {
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
		if ( hh_seo_share_image() === $image ) {
			echo "<meta property=\"og:image:width\" content=\"1200\">\n<meta property=\"og:image:height\" content=\"630\">\n";
		}
	}
	printf( "<meta name=\"twitter:card\" content=\"%s\">\n", $image ? 'summary_large_image' : 'summary' );
	if ( is_singular( 'post' ) ) {
		printf( "<meta property=\"article:published_time\" content=\"%s\">\n", esc_attr( get_the_date( 'c' ) ) );
		printf( "<meta property=\"article:modified_time\" content=\"%s\">\n", esc_attr( get_the_modified_date( 'c' ) ) );
	}
}

/** Trang lọc / sắp xếp / tìm kiếm hoặc danh sách rỗng: cho Google đi qua nhưng không lập chỉ mục. */
function hh_seo_noindex_request() {
	if ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) {
		// Bảng tính căn: công cụ tính theo từng căn, nội dung giá trùng trang dự án (trang dự án giữ từ khoá
		// "bảng giá {Tên}") → noindex, follow; không đưa vào sitemap.
		return true;
	}
	foreach ( array( 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'tt', 'duan', 'lien-he', 'khu-vuc', 'loai-bds' ) as $var ) {
		if ( isset( $_GET[ $var ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return true;
		}
	}
	if ( hh_seo_special_key() ) {
		return ! hh_special_projects( hh_seo_special_key() );
	}
	if ( hh_seo_hub_key() ) {
		return ! hh_hub_projects( hh_seo_hub_key() ) && ! hh_hub_listings( hh_seo_hub_key() );
	}
	// Trang Mua bán có bảng giá thị trường (biệt thự, đất lớn, khách sạn): vẫn lập chỉ mục dù chưa có tin.
	$landing = 'ban' === get_query_var( 'hh_deal' ) ? hh_current_deal_term() : null;
	if ( $landing && ( 'biet-thu' === $landing->slug || ( function_exists( 'hh_market_board' ) && hh_market_board( $landing->slug ) ) ) ) {
		return false;
	}
	// Trang đích tự sinh /mua-ban/{x}/, /cho-thue/{x}/: chỉ lập chỉ mục khi có từ 3 tin trở lên (tránh trang mỏng).
	if ( get_query_var( 'hh_deal' ) && hh_current_deal_term() ) {
		global $wp_query;
		return (int) $wp_query->found_posts < HH_SEO_MIN_LISTINGS;
	}
	// Trang thẻ /tag/…/: dưới 3 bài là trang mỏng → noindex, follow.
	if ( is_tag() ) {
		$tag = get_queried_object();
		return ! $tag || (int) $tag->count < 3;
	}
	return ( is_post_type_archive( array( 'bat-dong-san', 'du-an' ) ) || is_tax() ) && ! have_posts();
}

add_filter( 'wp_robots', 'hh_seo_robots' );
function hh_seo_robots( $robots ) {
	if ( hh_seo_noindex_request() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	if ( ! is_search() && ! isset( $robots['noindex'] ) ) {
		$robots['max-image-preview'] = 'large';
	}
	return $robots;
}

/** Images without alt text fall back to the post title. */
add_filter( 'wp_get_attachment_image_attributes', 'hh_seo_image_alt', 10, 2 );
function hh_seo_image_alt( $attr, $attachment ) {
	if ( empty( $attr['alt'] ) ) {
		$parent      = $attachment->post_parent ? get_the_title( $attachment->post_parent ) : '';
		$attr['alt'] = $parent ?: ( in_the_loop() || is_singular() ? get_the_title() : '' );
	}
	return $attr;
}

/* -------------------------------------------------------------------------
 * Structured data (schema.org JSON-LD)
 * ---------------------------------------------------------------------- */

/** Cách gọi khác của thương hiệu (tên đảo, tên miền) để Google gộp về một người. */
function hh_brand_aliases() {
	$name  = trim( (string) hoanghiep_opt( 'hh_person_name' ) );
	$parts = preg_split( '/\s+/u', $name );
	$alias = array( count( $parts ) === 2 ? $parts[1] . ' ' . $parts[0] : '', $name . ' Đà Nẵng', $name . ' BĐS Đà Nẵng', 'HiepHoangMT' );
	return array_values( array_unique( array_filter( $alias ) ) );
}

function hh_schema_person() {
	$person = array(
		'@type'       => 'Person',
		'@id'         => home_url( '/#person' ),
		'name'        => hoanghiep_opt( 'hh_person_name' ),
		'alternateName' => hh_brand_aliases(),
		'jobTitle'    => hoanghiep_opt( 'hh_person_title' ),
		'description' => hoanghiep_opt( 'hh_person_bio' ),
		'url'         => home_url( '/gioi-thieu/' ),
		'telephone'   => hoanghiep_tel(),
		'email'       => hoanghiep_opt( 'hh_email' ),
		'knowsLanguage' => 'vi',
		'hasOccupation' => array(
			'@type'          => 'Occupation',
			'name'           => 'Môi giới, tư vấn bất động sản',
			'occupationLocation' => array( '@type' => 'City', 'name' => 'Đà Nẵng' ),
		),
	);
	if ( hoanghiep_opt( 'hh_person_company' ) ) {
		$person['worksFor'] = array( '@type' => 'Organization', 'name' => hoanghiep_opt( 'hh_person_company' ) );
	}
	$person['image'] = array( hoanghiep_photo( 'portrait' ), hoanghiep_photo( 'portrait2' ), hoanghiep_photo( 'avatar' ) );
	return $person;
}

/** Giờ làm việc từ ô "Giờ làm việc" (VD "8:00 – 21:00, tất cả các ngày") → openingHoursSpecification. */
function hh_schema_hours() {
	if ( ! preg_match( '/(\d{1,2})[:h](\d{2})?\D+(\d{1,2})[:h](\d{2})?/u', (string) hoanghiep_opt( 'hh_hours' ), $m ) ) {
		return null;
	}
	return array(
		'@type'     => 'OpeningHoursSpecification',
		'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
		'opens'     => sprintf( '%02d:%02d', $m[1], $m[2] ?? 0 ),
		'closes'    => sprintf( '%02d:%02d', $m[3], $m[4] ?? 0 ),
	);
}

function hh_schema_agent() {
	$same_as = array_values( array_filter( array( hoanghiep_opt( 'hh_facebook' ), hoanghiep_opt( 'hh_youtube' ), hoanghiep_opt( 'hh_tiktok' ) ) ) );
	$agent   = array(
		'@type'       => 'RealEstateAgent',
		'@id'         => home_url( '/#agent' ),
		'name'        => hoanghiep_opt( 'hh_person_name' ),
		'alternateName' => hh_brand_aliases(),
		'description' => hoanghiep_opt( 'hh_person_bio' ),
		'slogan'      => hoanghiep_opt( 'hh_person_slogan' ),
		'url'         => home_url( '/' ),
		'telephone'   => hoanghiep_tel(),
		'email'       => hoanghiep_opt( 'hh_email' ),
		'address'     => array( '@type' => 'PostalAddress', 'streetAddress' => hoanghiep_opt( 'hh_address' ), 'addressLocality' => 'Đà Nẵng', 'addressRegion' => 'Đà Nẵng', 'postalCode' => '550000', 'addressCountry' => 'VN' ),
		'priceRange'  => 'Theo từng dự án',
		'openingHoursSpecification' => hh_schema_hours(),
		'areaServed'  => array( '@type' => 'City', 'name' => 'Đà Nẵng' ),
		'knowsLanguage' => 'vi',
		'founder'     => hh_schema_person(),
		'knowsAbout'  => array( 'Bất động sản Đà Nẵng', 'Căn hộ', 'Căn hộ dịch vụ', 'Đất nền', 'Biệt thự', 'Shophouse', 'Vay mua nhà' ),
	);
	$agent['image'] = hoanghiep_photo( 'avatar' );
	if ( $same_as ) {
		$agent['sameAs'] = $same_as;
	}
	return array_filter( $agent, static fn( $v ) => null !== $v && '' !== $v );
}

function hh_schema_breadcrumb() {
	$items = array( array( 'Trang chủ', home_url( '/' ) ) );
	if ( is_singular( 'du-an' ) || is_post_type_archive( 'du-an' ) || is_tax( 'loai-du-an' ) ) {
		$items[] = array( 'Dự án', get_post_type_archive_link( 'du-an' ) );
	}
	if ( is_singular( 'bat-dong-san' ) ) {
		$deal    = hh_meta( 'hh_deal' ) ?: 'ban';
		$items[] = array( 'thue' === $deal ? 'Cho thuê' : 'Mua bán', hh_deal_url( $deal ) );
		$areas   = get_the_terms( get_the_ID(), 'khu-vuc' );
		if ( $areas && ! is_wp_error( $areas ) ) {
			$items[] = array( $areas[0]->name, hh_deal_term_url( $deal, $areas[0] ) );
		}
	}
	if ( is_post_type_archive( 'bat-dong-san' ) && get_query_var( 'hh_deal' ) && hh_current_deal_term() ) {
		$items[] = array( 'ban' === get_query_var( 'hh_deal' ) ? 'Mua bán' : 'Cho thuê', hh_deal_url( get_query_var( 'hh_deal' ) ) );
	}
	if ( is_singular() && ! is_front_page() ) {
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( hh_seo_hub_key() ) {
		$items[] = array( hh_hub_pages()[ hh_seo_hub_key() ]['h1'], hh_seo_url() );
	} elseif ( hh_seo_special_key() ) {
		$items[] = array( HH_SPECIAL_PAGES[ hh_seo_special_key() ][1], hh_seo_url() );
	} elseif ( is_tax() || is_post_type_archive( 'bat-dong-san' ) ) {
		$items[] = array( wp_get_document_title(), hh_seo_url() );
	}
	if ( count( $items ) < 2 ) {
		return null;
	}
	$list = array();
	foreach ( $items as $i => list( $name, $url ) ) {
		$list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => wp_strip_all_tags( $name ), 'item' => is_wp_error( $url ) ? home_url( '/' ) : $url );
	}
	return array( '@type' => 'BreadcrumbList', 'itemListElement' => $list );
}

function hh_schema_faq( $rows ) {
	if ( ! $rows ) {
		return null;
	}
	return array(
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			fn( $r ) => array( '@type' => 'Question', 'name' => $r[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $r[1] ) ),
			array_filter( $rows, fn( $r ) => '' !== $r[0] && '' !== $r[1] )
		),
	);
}

function hh_schema_images( $ids ) {
	return array_values( array_filter( array_map( fn( $id ) => wp_get_attachment_image_url( $id, 'large' ), array_filter( $ids ) ) ) );
}

/** Giá cao nhất (đồng) đọc từ bảng giá, loại căn, vốn tự có của dự án ("3,35 tỷ", "4,8 – 5,6 tỷ", "850 triệu"). */
function hh_schema_project_high_price( $id ) {
	$max = 0.0;
	foreach ( array( array( 'hh_p_price_table', 4, 2 ), array( 'hh_p_unit_types', 4, 3 ), array( 'hh_p_capital_table', 4, 1 ) ) as list( $key, $cols, $col ) ) {
		foreach ( hh_table( $key, $cols, $id ) as $row ) {
			$cell = str_replace( array( '.', ',' ), array( '', '.' ), (string) ( $row[ $col ] ?? '' ) );
			if ( preg_match_all( '/(\d+(?:\.\d+)?)\s*(tỷ|ty|triệu|tr)(?!\p{L})/iu', $cell, $m, PREG_SET_ORDER ) ) {
				foreach ( $m as $x ) {
					$max = max( $max, (float) $x[1] * ( preg_match( '/^t[ỷy]/iu', $x[2] ) ? 1e9 : 1e6 ) );
				}
			} elseif ( preg_match_all( '/(\d+(?:\.\d+)?)\s*[–-]\s*(\d+(?:\.\d+)?)\s*tỷ/iu', $cell, $m ) ) {
				$max = max( $max, (float) max( $m[2] ) * 1e9 );
			}
		}
	}
	return $max;
}

function hh_schema_project() {
	$id     = get_the_ID();
	$images = hh_schema_images( array_merge( array( get_post_thumbnail_id() ), hh_ids( 'hh_p_gallery' ) ) );
	$type   = hh_is_high_rise( $id ) ? 'ApartmentComplex' : 'Residence';
	$data = array(
		'@type'       => array( $type, 'Product' ),
		'@id'         => get_permalink() . '#du-an',
		'name'        => get_the_title(),
		'url'         => get_permalink(),
		'description' => hh_seo_description(),
		'address'     => array( '@type' => 'PostalAddress', 'streetAddress' => hh_meta( 'hh_p_address' ), 'addressRegion' => 'Đà Nẵng', 'addressCountry' => 'VN' ),
		'geo'         => hh_parse_coords( hh_meta( 'hh_p_map_coords' ) ) ? array( '@type' => 'GeoCoordinates', 'latitude' => hh_parse_coords( hh_meta( 'hh_p_map_coords' ) )[0], 'longitude' => hh_parse_coords( hh_meta( 'hh_p_map_coords' ) )[1] ) : null,
		'category'    => hh_project_type( $id ) ? hh_project_type( $id )->name : null,
		'brand'       => hh_meta( 'hh_p_developer' ) ? array( '@type' => 'Organization', 'name' => hh_meta( 'hh_p_developer' ) ) : null,
		'image'       => $images ?: null,
		'amenityFeature' => array_map(
			fn( $a ) => array( '@type' => 'LocationFeatureSpecification', 'name' => $a, 'value' => true ),
			hh_lines( 'hh_p_amenities_in' )
		) ?: null,
		'additionalProperty' => array_map(
			fn( $k, $v ) => array( '@type' => 'PropertyValue', 'name' => $k, 'value' => $v ),
			array_keys( hh_project_specs() ),
			array_values( hh_project_specs() )
		),
		'dateModified' => get_the_modified_date( 'c' ),
	);
	if ( hh_meta( 'hh_p_price_from' ) ) {
		$low            = (float) hh_meta( 'hh_p_price_from' ) * 1000000;
		$data['offers'] = array(
			'@type'         => 'AggregateOffer',
			'priceCurrency' => 'VND',
			'lowPrice'      => $low,
			'highPrice'     => max( $low, hh_schema_project_high_price( $id ) ),
			'offerCount'    => max( 1, count( hh_table( 'hh_p_price_table', 4 ) ) ),
			'availability'  => 'https://schema.org/InStock',
			'seller'        => array( '@id' => home_url( '/#agent' ) ),
		);
	}
	return array_filter( $data, fn( $v ) => null !== $v && '' !== $v );
}

function hh_schema_listing() {
	$id    = get_the_ID();
	$terms = get_the_terms( $id, 'loai-bds' );
	$slug  = $terms && ! is_wp_error( $terms ) ? $terms[0]->slug : '';
	$map   = array( 'can-ho' => 'Apartment', 'penthouse' => 'Apartment', 'duplex' => 'Apartment', 'nha-pho' => 'House', 'nha-kiet' => 'House', 'shophouse' => 'House', 'biet-thu' => 'SingleFamilyResidence' );
	$kind  = 'Place';
	foreach ( $map as $prefix => $type ) {
		if ( 0 === strpos( $slug, $prefix ) ) {
			$kind = $type;
		}
	}
	$item = array(
		'@type'   => $kind,
		'name'    => get_the_title(),
		'address' => array( '@type' => 'PostalAddress', 'streetAddress' => hh_meta( 'hh_address' ), 'addressRegion' => 'Đà Nẵng', 'addressCountry' => 'VN' ),
	);
	if ( 'Place' !== $kind ) {
		if ( hh_meta( 'hh_area' ) ) {
			$item['floorSize'] = array( '@type' => 'QuantitativeValue', 'value' => (float) hh_meta( 'hh_area' ), 'unitCode' => 'MTK' );
		}
		if ( hh_meta( 'hh_bedrooms' ) ) {
			$item['numberOfBedrooms'] = (int) hh_meta( 'hh_bedrooms' );
		}
		if ( hh_meta( 'hh_bathrooms' ) ) {
			$item['numberOfBathroomsTotal'] = (int) hh_meta( 'hh_bathrooms' );
		}
	}
	$data = array(
		'@type'         => 'RealEstateListing',
		'@id'           => get_permalink() . '#tin',
		'name'          => get_the_title(),
		'url'           => get_permalink(),
		'description'   => hh_seo_description(),
		'datePosted'    => get_the_date( 'c' ),
		'dateModified'  => get_the_modified_date( 'c' ),
		'identifier'    => hh_listing_code(),
		'image'         => hh_schema_images( array_merge( array( get_post_thumbnail_id() ), hh_ids( 'hh_gallery' ) ) ),
		'about'         => $item,
		'offers'        => array(
			'@type'          => 'Offer',
			'businessFunction' => 'thue' === hh_meta( 'hh_deal' ) ? 'http://purl.org/goodrelations/v1#LeaseOut' : 'http://purl.org/goodrelations/v1#Sell',
			'priceCurrency'  => 'VND',
			'availability'   => 'da-giao-dich' === hh_meta( 'hh_status' ) ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock',
			'seller'         => array( '@id' => home_url( '/#agent' ) ),
		),
	);
	if ( (float) hh_meta( 'hh_price' ) > 0 ) {
		$data['offers']['price'] = (float) hh_meta( 'hh_price' ) * 1000000;
		if ( (float) hh_meta( 'hh_price_max' ) > (float) hh_meta( 'hh_price' ) ) {
			// Tin tổng hợp khoảng giá.
			$data['offers']['@type']     = 'AggregateOffer';
			$data['offers']['lowPrice']  = $data['offers']['price'];
			$data['offers']['highPrice'] = (float) hh_meta( 'hh_price_max' ) * 1000000;
			unset( $data['offers']['price'] );
		} elseif ( 'thue' === hh_meta( 'hh_deal' ) ) {
			$data['offers']['priceSpecification'] = array( '@type' => 'UnitPriceSpecification', 'price' => $data['offers']['price'], 'priceCurrency' => 'VND', 'unitCode' => 'MON' );
		}
	}
	return $data;
}

add_action( 'wp_head', 'hh_seo_schema', 20 );
function hh_seo_schema() {
	if ( is_404() ) {
		return;
	}
	// Có plugin SEO: plugin đã xuất WebSite, bài viết, breadcrumb – theme chỉ thêm schema bất động sản.
	$plugin = hh_seo_plugin_active();
	$graph  = array( hh_schema_agent() );

	if ( is_front_page() && ! $plugin ) {
		$graph[] = array(
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => get_bloginfo( 'name' ),
			'description'     => get_bloginfo( 'description' ),
			'inLanguage'      => 'vi-VN',
			'publisher'       => array( '@id' => home_url( '/#agent' ) ),
		);
	}

	if ( hh_seo_special_key() ) {
		$graph[] = hh_schema_faq( hh_special_intro( hh_seo_special_key() )['faq'] );
	}
	if ( hh_seo_hub_key() ) {
		$hub     = hh_hub_pages()[ hh_seo_hub_key() ];
		$graph[] = hh_schema_faq( $hub['faq'] );
		$list    = array();
		foreach ( hh_hub_projects( hh_seo_hub_key() ) as $i => $pid ) {
			$list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'url' => get_permalink( $pid ), 'name' => get_the_title( $pid ) );
		}
		if ( $list ) {
			$graph[] = array( '@type' => 'ItemList', 'name' => $hub['h1'], 'itemListElement' => $list );
		}
	}
	if ( is_singular( 'du-an' ) ) {
		$graph[] = hh_schema_project();
		$graph[] = hh_schema_faq( hh_project_faq() );
	} elseif ( is_singular( 'bat-dong-san' ) ) {
		$graph[] = hh_schema_listing();
	}
	if ( is_singular( 'post' ) ) {
		$graph[] = hh_schema_faq( hh_table( 'hh_post_faq', 2 ) );
	}
	if ( is_singular( 'post' ) && ! $plugin ) {
		$graph[] = array(
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'description'      => hh_seo_description(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'mainEntityOfPage' => get_permalink(),
			'image'            => has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' ) : null,
			'author'           => hh_schema_person(),
			'publisher'        => array( '@id' => home_url( '/#agent' ) ),
			'inLanguage'       => 'vi-VN',
		);
	} elseif ( is_page( 'gioi-thieu' ) && ! $plugin ) {
		$graph[] = array(
			'@type'      => 'ProfilePage',
			'url'        => get_permalink(),
			'mainEntity' => hh_schema_person(),
		);
	}

	if ( ! hh_seo_hub_key() && ! hh_seo_special_key() && ( is_post_type_archive( array( 'du-an', 'bat-dong-san' ) ) || is_tax( array( 'loai-du-an', 'loai-bds', 'khu-vuc' ) ) ) ) {
		global $wp_query;
		$list = array();
		foreach ( $wp_query->posts as $i => $p ) {
			$list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'url' => get_permalink( $p ), 'name' => get_the_title( $p ) );
		}
		if ( $list ) {
			$graph[] = array( '@type' => 'ItemList', 'name' => wp_get_document_title(), 'itemListElement' => $list );
		}
	}

	if ( ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) && ! array_intersect( array_keys( $_GET ), array( 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'khu-vuc', 'loai-bds' ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$deal    = get_query_var( 'hh_deal' );
		$term    = hh_current_deal_term();
		$place   = $term && 'khu-vuc' === $term->taxonomy ? $term->name . ', Đà Nẵng' : 'Đà Nẵng';
		$graph[] = hh_schema_faq( hh_listing_faq( hh_listing_stats(), $deal, $place, hh_lcfirst( hh_listing_archive_title() ) ) );
	}

	if ( ! $plugin ) {
		$graph[] = hh_schema_breadcrumb();
	}
	$graph = array_values( array_filter( $graph ) );

	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ) . "</script>\n";
}

/* -------------------------------------------------------------------------
 * Sitemaps & robots.txt
 * ---------------------------------------------------------------------- */

// Không đưa danh sách tài khoản (lộ tên đăng nhập) vào sitemap.
add_filter( 'wp_sitemaps_add_provider', fn( $provider, $name ) => 'users' === $name ? false : $provider, 10, 2 );

add_filter( 'robots_txt', 'hh_seo_robots_txt', 10, 2 );
function hh_seo_robots_txt( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	$ai = array( 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'PerplexityBot', 'ClaudeBot', 'Claude-SearchBot', 'Google-Extended', 'Applebot-Extended', 'Bingbot' );
	$out  = "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\n\n";
	$out .= '# Cho phép công cụ tìm kiếm AI đọc nội dung' . "\n";
	foreach ( $ai as $bot ) {
		$out .= "User-agent: {$bot}\nAllow: /\nDisallow: /wp-admin/\n\n";
	}
	if ( hh_seo_plugin_active() ) {
		$out .= 'Sitemap: ' . home_url( defined( 'AIOSEO_VERSION' ) ? '/sitemap.xml' : '/sitemap_index.xml' ) . "\n";
		$out .= 'Sitemap: ' . home_url( '/nhadat-sitemap.xml' ) . "\n";
	} else {
		$out .= 'Sitemap: ' . home_url( '/wp-sitemap.xml' ) . "\n";
	}
	return $out;
}

/** Sitemap of SEO landing pages: /mua-ban/{khu-vuc|loai}/, /cho-thue/{…}/. */
add_action( 'init', 'hh_seo_register_sitemap', 20 );
function hh_seo_register_sitemap() {
	if ( ! class_exists( 'WP_Sitemaps_Provider' ) || ! function_exists( 'wp_register_sitemap_provider' ) ) {
		return;
	}
	if ( ! class_exists( 'HH_Landing_Sitemap' ) ) {
		class HH_Landing_Sitemap extends WP_Sitemaps_Provider {
			public function __construct() {
				$this->name        = 'nhadat';
				$this->object_type = 'nhadat';
			}
			public function get_url_list( $page_num, $object_subtype = '' ) {
				return array_map( static fn( $e ) => array_filter( array( 'loc' => $e[0], 'lastmod' => $e[1] ? gmdate( 'c', $e[1] ) : '' ) ), hh_seo_landing_entries() );
			}
			public function get_max_num_pages( $object_subtype = '' ) {
				return 1;
			}
		}
	}
	wp_register_sitemap_provider( 'nhadat', new HH_Landing_Sitemap() );
}

/** Thời điểm sửa gần nhất của tin nhà đất theo giao dịch (và khu vực / loại nhà nếu có). */
function hh_seo_listing_lastmod( $deal, $term = null ) {
	$args = array(
		'post_type'      => 'bat-dong-san',
		'posts_per_page' => 1,
		'orderby'        => 'modified',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'meta_query'     => array( array( 'key' => 'hh_deal', 'value' => $deal ) ),
	);
	if ( $term ) {
		$args['tax_query'] = array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id ) );
	}
	$ids = get_posts( $args );
	return $ids ? (int) get_post_modified_time( 'U', true, $ids[0] ) : 0;
}

/**
 * Sitemap riêng: [url, lastmod] các trang Mua bán / Cho thuê theo khu vực, loại nhà và trang tổng hợp /san-pham/.
 * Chỉ gồm trang được lập chỉ mục: bỏ trang đích dưới 3 tin, bỏ bảng tính căn (noindex), không trùng URL.
 */
function hh_seo_landing_entries() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$out = array();
	foreach ( array( 'ban', 'thue' ) as $deal ) {
		$out[ hh_deal_url( $deal ) ] = hh_seo_listing_lastmod( $deal );
		foreach ( array( 'khu-vuc', 'loai-bds' ) as $tax ) {
			foreach ( hh_deal_landing_terms( $deal, $tax ) as list( $term, $n ) ) {
				if ( $n >= HH_SEO_MIN_LISTINGS ) {
					$out[ hh_deal_term_url( $deal, $term ) ] = hh_seo_listing_lastmod( $deal, $term );
				}
			}
		}
	}
	foreach ( array( 'biet-thu', 'dat-nen', 'khach-san' ) as $slug ) {
		$t = get_term_by( 'slug', $slug, 'loai-bds' );
		if ( $t && ( 'biet-thu' === $slug || ( function_exists( 'hh_market_board' ) && hh_market_board( $slug ) ) ) ) {
			$url         = hh_deal_term_url( 'ban', $t );
			$out[ $url ] = $out[ $url ] ?? hh_seo_listing_lastmod( 'ban', $t );
		}
	}
	if ( function_exists( 'hh_special_projects' ) ) {
		foreach ( array_keys( HH_SPECIAL_PAGES ) as $key ) {
			$ids = array_keys( hh_special_projects( $key ) );
			if ( $ids ) {
				$out[ hh_special_url( $key ) ] = hh_seo_latest_modified( $ids );
			}
		}
	}
	if ( function_exists( 'hh_hub_pages' ) ) {
		foreach ( array_keys( hh_hub_pages() ) as $key ) {
			$out[ hh_hub_url( $key ) ] = hh_hub_lastmod( $key );
		}
	}
	$list = array();
	foreach ( $out as $url => $mod ) {
		$list[] = array( $url, (int) $mod );
	}
	return $cache = $list; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
}

/** Chỉ danh sách URL (tương thích code cũ). */
function hh_seo_landing_urls() {
	return array_column( hh_seo_landing_entries(), 0 );
}

/** Khóa trang hub (/can-ho-sun-group-da-nang/…) đang xem, ngược lại ''. */
function hh_seo_hub_key() {
	return function_exists( 'hh_hub_key' ) ? hh_hub_key() : '';
}

/** Khóa sản phẩm khi đang ở trang tổng hợp /san-pham/…/ (shop, penthouse, duplex), ngược lại ''. */
function hh_seo_special_key() {
	return function_exists( 'hh_special_key' ) ? hh_special_key( (string) get_query_var( 'hh_sp' ) ) : '';
}

/* -------------------------------------------------------------------------
 * Tương thích Rank Math / Yoast SEO / AIOSEO
 * ---------------------------------------------------------------------- */

/** Mô tả tự sinh khi plugin SEO để trống ô mô tả. */
function hh_seo_fill_description( $desc ) {
	if ( '' !== trim( (string) $desc ) || is_404() ) {
		return $desc;
	}
	return hh_seo_trim( hh_seo_description() );
}
add_filter( 'rank_math/frontend/description', 'hh_seo_fill_description' );
add_filter( 'wpseo_metadesc', 'hh_seo_fill_description' );
add_filter( 'wpseo_opengraph_desc', 'hh_seo_fill_description' );
add_filter( 'aioseo_description', 'hh_seo_fill_description' );

/** Mô tả nhập tay quá dài (Google cắt ở ~155–160 ký tự): rút gọn khi xuất ra, không sửa dữ liệu đã lưu. */
foreach ( array( 'rank_math/frontend/description', 'wpseo_metadesc', 'aioseo_description' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $d ) => is_string( $d ) && mb_strlen( $d ) > 160 ? hh_seo_trim( $d ) : $d, 100 );
}
unset( $hh_filter );

/** Trang lọc / tìm kiếm: noindex cả khi plugin SEO tự xuất thẻ robots. */
add_filter(
	'rank_math/frontend/robots',
	static function ( $robots ) {
		if ( hh_seo_noindex_request() ) {
			$robots['index']  = 'noindex';
			$robots['follow'] = 'follow';
		}
		return $robots;
	}
);
add_filter( 'wpseo_robots', static fn( $robots ) => hh_seo_noindex_request() ? 'noindex, follow' : $robots );

/** Đưa trang Mua bán – Cho thuê theo khu vực vào sitemap của plugin. */
function hh_seo_sitemap_index_entry( $xml = '' ) {
	$mods = array_column( hh_seo_landing_entries(), 1 );
	$last = $mods ? max( $mods ) : 0;
	return $xml . '<sitemap><loc>' . esc_url( home_url( '/nhadat-sitemap.xml' ) ) . '</loc>' . ( $last ? '<lastmod>' . esc_html( gmdate( 'c', $last ) ) . '</lastmod>' : '' ) . "</sitemap>\n";
}
add_filter( 'rank_math/sitemap/index', 'hh_seo_sitemap_index_entry', 11 );
add_filter( 'wpseo_sitemap_index', 'hh_seo_sitemap_index_entry' );

add_action( 'parse_request', 'hh_seo_landing_sitemap' );
function hh_seo_landing_sitemap( $wp ) {
	if ( 'nhadat-sitemap.xml' !== trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		return;
	}
	status_header( 200 );
	header( 'Content-Type: application/xml; charset=utf-8' );
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	foreach ( hh_seo_landing_entries() as list( $url, $mod ) ) {
		echo '<url><loc>' . esc_url( $url ) . '</loc>' . ( $mod ? '<lastmod>' . esc_html( gmdate( 'c', $mod ) ) . '</lastmod>' : '' ) . "</url>\n";
	}
	echo "</urlset>\n";
	exit;
}

/* -------------------------------------------------------------------------
 * /llms.txt – bản tóm tắt website dạng Markdown cho ChatGPT & AI khác
 * ---------------------------------------------------------------------- */

add_action( 'parse_request', 'hh_seo_llms_txt' );
function hh_seo_llms_txt( $wp ) {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore
	$home = trim( (string) wp_parse_url( home_url(), PHP_URL_PATH ), '/' );
	if ( ( $home ? $home . '/' : '' ) . 'llms.txt' !== $path ) {
		return;
	}

	$name  = hoanghiep_opt( 'hh_person_name' );
	$lines = array(
		'# ' . $name . ' – ' . hoanghiep_opt( 'hh_person_title' ),
		'',
		'> ' . hoanghiep_opt( 'hh_person_bio' ),
		'',
		'- Đơn vị đang công tác: ' . hoanghiep_opt( 'hh_person_company' ),
		'- Kinh nghiệm: ' . implode( ' → ', wp_list_pluck( hoanghiep_career(), 0 ) ),
		'- Khu vực hoạt động: ' . ( false !== mb_stripos( hoanghiep_opt( 'hh_address' ), 'Đà Nẵng' ) ? hoanghiep_opt( 'hh_address' ) : 'Đà Nẵng (' . hoanghiep_opt( 'hh_address' ) . ')' ),
		'- Hotline / Zalo: ' . hoanghiep_opt( 'hh_phone' ),
		'- Email: ' . hoanghiep_opt( 'hh_email' ),
		'- Giờ làm việc: ' . hoanghiep_opt( 'hh_hours' ),
		'- Website: ' . home_url( '/' ),
		'',
		'## Trang chính',
		'',
		'- [Dự án Đà Nẵng](' . get_post_type_archive_link( 'du-an' ) . '): dự án cao tầng (căn hộ sở hữu lâu dài, căn hộ dịch vụ 50 năm) và thấp tầng (biệt thự, đất nền, shophouse)',
		'- [Nhà đất bán Đà Nẵng](' . hh_deal_url( 'ban' ) . ')',
		'- [Nhà đất cho thuê Đà Nẵng](' . hh_deal_url( 'thue' ) . ')',
		'- [Giới thiệu ' . $name . '](' . home_url( '/gioi-thieu/' ) . ')',
		'- [Liên hệ](' . home_url( '/lien-he/' ) . ')',
		'',
		'## Dự án',
		'',
	);
	foreach ( get_posts( array( 'post_type' => 'du-an', 'numberposts' => 50 ) ) as $p ) {
		$facts   = array_filter(
			array(
				hh_project_type( $p->ID ) ? hh_project_type( $p->ID )->name : '',
				hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status', $p->ID ) ),
				hh_meta( 'hh_p_address', $p->ID ),
				hh_project_price( $p->ID ),
				hh_meta( 'hh_p_developer', $p->ID ) ? 'CĐT ' . hh_meta( 'hh_p_developer', $p->ID ) : '',
			)
		);
		$lines[] = '- [' . get_the_title( $p ) . '](' . get_permalink( $p ) . '): ' . implode( '; ', $facts );
	}
	foreach ( array( 'ban' => 'Nhà đất bán mới nhất', 'thue' => 'Nhà đất cho thuê mới nhất' ) as $deal => $title ) {
		$lines[] = '';
		$lines[] = '## ' . $title;
		$lines[] = '';
		foreach ( array( 'khu-vuc', 'loai-bds' ) as $tax ) {
			foreach ( hh_deal_landing_terms( $deal, $tax ) as list( $term, $n ) ) {
				$label   = 'khu-vuc' === $tax ? ( 'ban' === $deal ? 'Nhà đất bán ' : 'Nhà đất cho thuê ' ) . $term->name : ( 'ban' === $deal ? 'Bán ' : 'Cho thuê ' ) . mb_strtolower( $term->name );
				$lines[] = '- [' . $label . ', Đà Nẵng](' . hh_deal_term_url( $deal, $term ) . '): ' . $n . ' tin';
			}
		}
		$posts   = get_posts( array( 'post_type' => 'bat-dong-san', 'numberposts' => 30, 'meta_key' => 'hh_deal', 'meta_value' => $deal ) ); // phpcs:ignore
		foreach ( $posts as $p ) {
			$facts   = array_filter(
				array(
					hh_listing_price( $p->ID ),
					hh_meta( 'hh_area', $p->ID ) ? hh_meta( 'hh_area', $p->ID ) . ' m²' : '',
					hh_meta( 'hh_bedrooms', $p->ID ) ? hh_meta( 'hh_bedrooms', $p->ID ) . ' PN' : '',
					hh_meta( 'hh_address', $p->ID ),
					hh_option_label( hh_listing_schema(), 'hh_status', hh_meta( 'hh_status', $p->ID ) ),
				)
			);
			$lines[] = '- [' . get_the_title( $p ) . '](' . get_permalink( $p ) . '): ' . implode( '; ', $facts );
		}
	}
	$news = get_posts( array( 'post_type' => 'post', 'numberposts' => 20 ) );
	if ( $news ) {
		$lines[] = '';
		$lines[] = '## Tin tức';
		$lines[] = '';
		foreach ( $news as $p ) {
			$lines[] = '- [' . get_the_title( $p ) . '](' . get_permalink( $p ) . '): ' . wp_strip_all_tags( get_the_excerpt( $p ) );
		}
	}

	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: noindex' );
	echo implode( "\n", $lines ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- plain text.
	exit;
}

/* -------------------------------------------------------------------------
 * Trang chủ: tiêu đề, mô tả, ảnh chia sẻ chuẩn (kể cả khi Rank Math / Yoast tự lấy "Trang chủ"
 * và chữ đầu tiên của trang dựng bằng Elementor, VD "streamline-icon-check-badge@40x40").
 * Chỉ áp dụng khi bạn chưa tự nhập tiêu đề / mô tả cho trang chủ trong plugin SEO.
 * ---------------------------------------------------------------------- */

function hh_seo_home_title() {
	return hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' );
}

function hh_seo_home_description() {
	return hoanghiep_opt( 'hh_person_name' ) . ' – ' . mb_strtolower( mb_substr( hoanghiep_opt( 'hh_person_title' ), 0, 1 ) ) . mb_substr( hoanghiep_opt( 'hh_person_title' ), 1 ) . ': dự án mới, căn hộ, biệt thự, đất nền mua bán và cho thuê, pháp lý minh bạch. Hotline/Zalo ' . hoanghiep_opt( 'hh_phone' ) . '.';
}

function hh_seo_home_override( $value, $kind ) {
	if ( ! is_front_page() || hh_seo_custom_meta( $kind ) || is_paged() ) {
		return $value;
	}
	if ( 'title' === $kind ) {
		return hh_seo_home_title();
	}
	return hh_seo_home_description();
}

foreach ( array( 'rank_math/frontend/title', 'rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title', 'wpseo_title', 'wpseo_opengraph_title', 'wpseo_twitter_title', 'aioseo_title' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => hh_seo_home_override( $v, 'title' ), 99 );
}
foreach ( array( 'rank_math/frontend/description', 'rank_math/opengraph/facebook/og_description', 'rank_math/opengraph/twitter/twitter_description', 'wpseo_metadesc', 'wpseo_opengraph_desc', 'wpseo_twitter_description', 'aioseo_description' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => hh_seo_home_override( $v, 'description' ), 99 );
}
unset( $hh_filter );

/** Ảnh chia sẻ trang chủ / giới thiệu: luôn dùng ảnh ngang 1200×630 (không để plugin SEO lấy ảnh dọc hay icon nhỏ). */
foreach ( array( 'rank_math/opengraph/facebook/image', 'rank_math/opengraph/twitter/image', 'wpseo_opengraph_image', 'wpseo_twitter_image' ) as $hh_filter ) {
	add_filter(
		$hh_filter,
		static function ( $img ) {
			return is_front_page() || is_page( 'gioi-thieu' ) || ( ! $img || preg_match( '/icon|@\d+x\d+|\.svg/i', (string) $img ) ) ? ( hh_seo_image() ?: $img ) : $img;
		},
		99
	);
}
unset( $hh_filter );

/* -------------------------------------------------------------------------
 * Rank Math: đưa Dự án, Nhà đất và các trang loại dự án / khu vực vào sitemap (kể cả khi chưa bật trong cài đặt),
 * và gộp schema để không trùng (1 RealEstateAgent của theme thay cho Organization/LocalBusiness của plugin;
 * bỏ "Article" trên trang chủ).
 * ---------------------------------------------------------------------- */

add_filter( 'rank_math/sitemap/exclude_post_type', static fn( $exclude, $type ) => in_array( $type, array( 'du-an', 'bat-dong-san' ), true ) ? false : $exclude, 99, 2 );
add_filter( 'rank_math/sitemap/exclude_taxonomy', static fn( $exclude, $tax ) => in_array( $tax, array( 'loai-du-an', 'khu-vuc' ), true ) ? false : ( 'loai-bds' === $tax ? true : $exclude ), 99, 2 );
// /loai-nha-dat/{x}/ đã chuyển 301 sang /mua-ban/{x}/ – không đưa vào sitemap.
add_filter( 'wp_sitemaps_taxonomies', static function ( $taxes ) {
	unset( $taxes['loai-bds'] );
	return $taxes;
} );

/** Đổi mọi tham chiếu {"@id": cũ} sang @id của theme. */
function hh_seo_repoint_ids( $node, $ids, $to ) {
	if ( ! is_array( $node ) ) {
		return $node;
	}
	if ( isset( $node['@id'] ) && 1 === count( $node ) && in_array( $node['@id'], $ids, true ) ) {
		return array( '@id' => $to );
	}
	foreach ( $node as $k => $v ) {
		$node[ $k ] = hh_seo_repoint_ids( $v, $ids, $to );
	}
	return $node;
}

add_filter(
	'rank_math/json_ld',
	static function ( $data ) {
		if ( ! is_array( $data ) ) {
			return $data;
		}
		$ids = array();
		foreach ( $data as $k => $entity ) {
			if ( ! is_array( $entity ) ) {
				continue;
			}
			$types = (array) ( $entity['@type'] ?? array() );
			$id    = (string) ( $entity['@id'] ?? '' );
			if ( array_intersect( $types, array( 'Organization', 'LocalBusiness', 'RealEstateAgent', 'Corporation' ) ) && preg_match( '/#(organization|localbusiness)$/i', $id ) ) {
				$ids[] = $id;
				unset( $data[ $k ] );
			} elseif ( is_front_page() && array_intersect( $types, array( 'Article', 'BlogPosting', 'NewsArticle' ) ) ) {
				unset( $data[ $k ] );
			}
		}
		return $ids ? hh_seo_repoint_ids( $data, $ids, home_url( '/#agent' ) ) : $data;
	},
	99
);

/* -------------------------------------------------------------------------
 * Trang danh sách (Mua bán, Cho thuê, Dự án, loại dự án, khu vực, /san-pham/…): dùng tiêu đề, mô tả của theme
 * thay cho mẫu chung của Rank Math / Yoast ("Nhà đất Archive - …").
 * ---------------------------------------------------------------------- */

function hh_seo_is_listing_page() {
	return ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) || is_post_type_archive( array( 'bat-dong-san', 'du-an' ) ) || is_tax( array( 'loai-du-an', 'khu-vuc', 'loai-bds' ) ) || hh_seo_special_key() || hh_seo_hub_key();
}

function hh_seo_listing_title() {
	if ( hh_seo_hub_key() ) {
		return hh_hub_pages()[ hh_seo_hub_key() ]['title']; // Đã ≤ 60 ký tự, không thêm tên web.
	}
	$parts = hh_seo_title_parts( array( 'title' => wp_strip_all_tags( (string) get_the_archive_title() ) ) );
	$paged = (int) get_query_var( 'paged' );
	return trim( $parts['title'] ) . ( $paged > 1 ? ' – Trang ' . $paged : '' ) . ' – ' . get_bloginfo( 'name' );
}

foreach ( array( 'rank_math/frontend/title', 'rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title', 'wpseo_title', 'wpseo_opengraph_title', 'aioseo_title' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => hh_seo_is_listing_page() ? hh_seo_listing_title() : $v, 98 );
}
foreach ( array( 'rank_math/frontend/description', 'rank_math/opengraph/facebook/og_description', 'rank_math/opengraph/twitter/twitter_description', 'wpseo_metadesc', 'wpseo_opengraph_desc', 'aioseo_description' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => hh_seo_is_listing_page() ? hh_seo_trim( hh_seo_description() ) : $v, 98 );
}
unset( $hh_filter );

/* -------------------------------------------------------------------------
 * URL trùng nội dung: 301 về một URL chuẩn
 * - /nha-dat/ (mọi tin, không phân mua / thuê)            → /mua-ban/
 * - /loai-nha-dat/{loại}/                                  → /mua-ban/{loại}/ (hoặc /cho-thue/{loại}/ nếu chỉ có tin thuê)
 * Giữ số trang và tham số lọc (?gia=…). /khu-vuc/{x}/ chỉ còn hiện dự án (khác /mua-ban/{x}/ là tin nhà đất).
 * ---------------------------------------------------------------------- */

add_action( 'template_redirect', 'hh_seo_redirect_duplicates', 2 );
function hh_seo_redirect_duplicates() {
	if ( is_admin() || is_feed() || is_preview() || ! function_exists( 'hh_deal_url' ) ) {
		return;
	}
	$target = '';
	$filtered = (bool) array_intersect( array_keys( $_GET ), array( 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'duan', 'khu-vuc', 'loai-bds' ) ); // phpcs:ignore WordPress.Security.NonceVerification
	if ( is_post_type_archive( 'bat-dong-san' ) && ! get_query_var( 'hh_deal' ) && ! get_query_var( 'hh_term' ) && ! $filtered ) {
		// Ô tìm kiếm "Tất cả" (/nha-dat/?tk=…) vẫn chạy, chỉ trang không lọc chuyển về /mua-ban/ (trang lọc đã noindex).
		$target = hh_deal_url( 'ban' );
	} elseif ( is_tax( 'loai-bds' ) ) {
		$term = get_queried_object();
		$deal = hh_seo_listing_lastmod( 'ban', $term ) || ! hh_seo_listing_lastmod( 'thue', $term ) ? 'ban' : 'thue';
		$target = hh_deal_term_url( $deal, $term );
	}
	if ( ! $target ) {
		return;
	}
	$paged = max( (int) get_query_var( 'paged' ), 1 );
	if ( $paged > 1 ) {
		$target = trailingslashit( $target ) . user_trailingslashit( 'page/' . $paged, 'paged' );
	}
	$query = (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	wp_safe_redirect( $target . ( $query ? '?' . $query : '' ), 301 );
	exit;
}

/** Trang khu vực /khu-vuc/{x}/: chỉ dự án (tin nhà đất theo khu vực ở /mua-ban/{x}/, /cho-thue/{x}/). */
add_action(
	'pre_get_posts',
	static function ( $q ) {
		if ( ! is_admin() && $q->is_main_query() && $q->is_tax( 'khu-vuc' ) ) {
			$q->set( 'post_type', 'du-an' );
		}
	},
	20
);

/* -------------------------------------------------------------------------
 * Canonical khi bật Rank Math / Yoast: trang dựng riêng (/mua-ban/{x}/, /cho-thue/{x}/, /san-pham/{x}/, trang 2, 3…)
 * trỏ đúng chính nó (plugin tự tính sẽ ra /nha-dat/ hoặc trang 1).
 * ---------------------------------------------------------------------- */

function hh_seo_canonical_filter( $canonical ) {
	if ( is_404() || ( is_singular() && ! ( function_exists( 'hh_is_units_page' ) && hh_is_units_page() ) ) ) {
		return $canonical;
	}
	if ( hh_seo_is_listing_page() || is_tax() || is_category() || is_home() || is_post_type_archive() ) {
		$url = hh_seo_url();
		return is_wp_error( $url ) || ! $url ? $canonical : $url;
	}
	return $canonical;
}
foreach ( array( 'rank_math/frontend/canonical', 'rank_math/opengraph/url', 'wpseo_canonical', 'wpseo_opengraph_url', 'aioseo_canonical_url' ) as $hh_filter ) {
	add_filter( $hh_filter, 'hh_seo_canonical_filter', 99 );
}
unset( $hh_filter );

/** Rank Math: phân trang của trang dựng riêng (rel prev/next) cũng theo URL đẹp. */
add_filter( 'rank_math/frontend/disable_adjacent_rel_links', static fn( $disable ) => get_query_var( 'hh_deal' ) || get_query_var( 'hh_sp' ) ? true : $disable );

/* -------------------------------------------------------------------------
 * Rank Math schema: tác giả bài viết = Hoàng Hiệp (#person); bỏ SearchAction (Google không còn dùng).
 * ---------------------------------------------------------------------- */

add_filter( 'rank_math/json_ld/disable_search', '__return_true' );
add_filter(
	'rank_math/json_ld',
	static function ( $data ) {
		if ( ! is_array( $data ) ) {
			return $data;
		}
		$person_ids = array();
		foreach ( $data as $k => $entity ) {
			if ( ! is_array( $entity ) ) {
				continue;
			}
			unset( $data[ $k ]['potentialAction'] ); // SearchAction trên WebSite.
			$types = (array) ( $entity['@type'] ?? array() );
			if ( in_array( 'Person', $types, true ) && ! empty( $entity['@id'] ) && false === strpos( $entity['@id'], '#person' ) ) {
				$person_ids[] = $entity['@id']; // Tác giả theo tài khoản WordPress (VD …/author/admin/).
				unset( $data[ $k ] );
			}
		}
		if ( ! is_singular( 'post' ) && ! $person_ids ) {
			return $data;
		}
		$data = $person_ids ? hh_seo_repoint_ids( $data, $person_ids, home_url( '/#person' ) ) : $data;
		foreach ( $data as $k => $entity ) {
			$types = (array) ( $entity['@type'] ?? array() );
			if ( array_intersect( $types, array( 'Article', 'BlogPosting', 'NewsArticle' ) ) ) {
				$data[ $k ]['author'] = array( '@id' => home_url( '/#person' ) );
			}
		}
		$data['hhPerson'] = hh_schema_person();
		return $data;
	},
	100
);
