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
	if ( ! is_singular() ) {
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
function hh_seo_title_parts( $parts ) {
	if ( hh_seo_custom_meta( 'title' ) ) {
		return array( 'title' => hh_seo_custom_meta( 'title' ) );
	}
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		$parts['title'] = hh_listing_archive_title() . ( get_query_var( 'hh_deal' ) ? ' – Cập nhật ' . wp_date( 'm/Y' ) : '' );
	} elseif ( is_post_type_archive( 'du-an' ) ) {
		$parts['title'] = 'Dự án bất động sản Đà Nẵng';
	} elseif ( is_tax( 'loai-du-an' ) ) {
		$parts['title'] = 'Dự án ' . mb_strtolower( single_term_title( '', false ) ) . ' Đà Nẵng';
	} elseif ( is_tax( 'khu-vuc' ) ) {
		$parts['title'] = 'Bất động sản ' . single_term_title( '', false ) . ', Đà Nẵng';
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
		$parts['tagline'] = hoanghiep_opt( 'hh_person_title' );
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
	if ( is_front_page() ) {
		return hoanghiep_opt( 'hh_hero_text' ) . ' ' . hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) . ', hotline ' . hoanghiep_opt( 'hh_phone' ) . '.';
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
	if ( is_tax( 'loai-du-an' ) ) {
		return 'Danh sách dự án ' . mb_strtolower( single_term_title( '', false ) ) . ' tại Đà Nẵng: vị trí, giá bán, mặt bằng, chính sách bán hàng mới nhất. Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_post_type_archive( 'du-an' ) ) {
		return 'Danh sách dự án cao tầng (căn hộ, căn hộ dịch vụ, penthouse, duplex, shop khối đế) và thấp tầng (biệt thự, đất nền, shophouse) tại Đà Nẵng: vị trí, giá bán, mặt bằng, tiến độ và chính sách mới nhất. Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		$st = hh_listing_stats();
		if ( $st['count'] && $st['min'] ) {
			$rent = 'thue' === get_query_var( 'hh_deal' );
			return hh_listing_archive_title() . ': ' . $st['count'] . ' tin đang có, giá ' . hh_price_range( $st['min'], $st['max'], $rent ) . ', thông tin pháp lý rõ ràng, cập nhật ' . wp_date( 'd/m/Y', $st['latest'] ?: time() ) . '. Đặt lịch xem nhà: ' . hoanghiep_opt( 'hh_phone' ) . '.';
		}
		return hh_listing_archive_title() . ', cập nhật hằng ngày, thông tin pháp lý rõ ràng. Lọc theo giá, diện tích, khu vực. Liên hệ ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	return get_bloginfo( 'description' );
}

function hh_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
	}
	if ( is_page( 'gioi-thieu' ) || is_front_page() && ! hoanghiep_opt( 'hh_hero_image' ) ) {
		return hoanghiep_photo( 'portrait' );
	}
	$fallback = hoanghiep_opt( 'hh_hero_image' );
	if ( ! $fallback ) {
		$latest = get_posts( array( 'post_type' => 'du-an', 'numberposts' => 1, 'meta_key' => '_thumbnail_id', 'fields' => 'ids' ) ); // phpcs:ignore
		$fallback = $latest ? wp_get_attachment_image_url( get_post_thumbnail_id( $latest[0] ), 'large' ) : '';
	}
	return $fallback;
}

function hh_seo_url() {
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_tax() || is_category() || is_tag() ) {
		return get_term_link( get_queried_object() );
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
	$desc  = trim( preg_replace( '/\s+/u', ' ', hh_seo_description() ) ) ?: get_bloginfo( 'description' );
	$desc  = mb_strlen( $desc ) > 300 ? mb_substr( $desc, 0, 297 ) . '…' : $desc;
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
	}
	printf( "<meta name=\"twitter:card\" content=\"%s\">\n", $image ? 'summary_large_image' : 'summary' );
	if ( is_singular( 'post' ) ) {
		printf( "<meta property=\"article:published_time\" content=\"%s\">\n", esc_attr( get_the_date( 'c' ) ) );
		printf( "<meta property=\"article:modified_time\" content=\"%s\">\n", esc_attr( get_the_modified_date( 'c' ) ) );
	}
}

/** Trang lọc / sắp xếp / tìm kiếm hoặc danh sách rỗng: cho Google đi qua nhưng không lập chỉ mục. */
function hh_seo_noindex_request() {
	foreach ( array( 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'tt', 'duan', 'lien-he', 'khu-vuc', 'loai-bds' ) as $var ) {
		if ( isset( $_GET[ $var ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return true;
		}
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

function hh_schema_person() {
	$person = array(
		'@type'       => 'Person',
		'@id'         => home_url( '/#person' ),
		'name'        => hoanghiep_opt( 'hh_person_name' ),
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

function hh_schema_agent() {
	$same_as = array_values( array_filter( array( hoanghiep_opt( 'hh_facebook' ), hoanghiep_opt( 'hh_youtube' ), hoanghiep_opt( 'hh_tiktok' ) ) ) );
	$agent   = array(
		'@type'       => 'RealEstateAgent',
		'@id'         => home_url( '/#agent' ),
		'name'        => hoanghiep_opt( 'hh_person_name' ),
		'description' => hoanghiep_opt( 'hh_person_bio' ),
		'slogan'      => hoanghiep_opt( 'hh_person_slogan' ),
		'url'         => home_url( '/' ),
		'telephone'   => hoanghiep_tel(),
		'email'       => hoanghiep_opt( 'hh_email' ),
		'address'     => array( '@type' => 'PostalAddress', 'addressLocality' => hoanghiep_opt( 'hh_address' ), 'addressRegion' => 'Đà Nẵng', 'addressCountry' => 'VN' ),
		'areaServed'  => array( '@type' => 'City', 'name' => 'Đà Nẵng' ),
		'knowsLanguage' => 'vi',
		'founder'     => hh_schema_person(),
		'knowsAbout'  => array( 'Bất động sản Đà Nẵng', 'Căn hộ', 'Căn hộ dịch vụ', 'Đất nền', 'Biệt thự', 'Shophouse', 'Vay mua nhà' ),
	);
	$agent['image'] = hoanghiep_photo( 'avatar' );
	if ( $same_as ) {
		$agent['sameAs'] = $same_as;
	}
	return $agent;
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
		$data['offers'] = array(
			'@type'         => 'AggregateOffer',
			'priceCurrency' => 'VND',
			'lowPrice'      => (float) hh_meta( 'hh_p_price_from' ) * 1000000,
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
		if ( 'thue' === hh_meta( 'hh_deal' ) ) {
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
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => array( '@type' => 'EntryPoint', 'urlTemplate' => hh_deal_url( 'ban' ) . '?tk={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);
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

	if ( is_post_type_archive( array( 'du-an', 'bat-dong-san' ) ) || is_tax( array( 'loai-du-an', 'loai-bds', 'khu-vuc' ) ) ) {
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
				return array_map( static fn( $loc ) => array( 'loc' => $loc ), hh_seo_landing_urls() );
			}
			public function get_max_num_pages( $object_subtype = '' ) {
				return 1;
			}
		}
	}
	wp_register_sitemap_provider( 'nhadat', new HH_Landing_Sitemap() );
}

/** URL các trang Mua bán / Cho thuê theo khu vực và loại nhà đất. */
function hh_seo_landing_urls() {
	$urls = array();
	foreach ( array( 'ban', 'thue' ) as $deal ) {
		$urls[] = hh_deal_url( $deal );
		foreach ( array( 'khu-vuc', 'loai-bds' ) as $tax ) {
			foreach ( hh_deal_landing_terms( $deal, $tax ) as list( $term ) ) {
				$urls[] = hh_deal_term_url( $deal, $term );
			}
		}
	}
	return $urls;
}

/* -------------------------------------------------------------------------
 * Tương thích Rank Math / Yoast SEO / AIOSEO
 * ---------------------------------------------------------------------- */

/** Mô tả tự sinh khi plugin SEO để trống ô mô tả. */
function hh_seo_fill_description( $desc ) {
	if ( '' !== trim( (string) $desc ) || is_404() ) {
		return $desc;
	}
	$auto = trim( preg_replace( '/\s+/u', ' ', hh_seo_description() ) );
	return mb_strlen( $auto ) > 300 ? mb_substr( $auto, 0, 297 ) . '…' : $auto;
}
add_filter( 'rank_math/frontend/description', 'hh_seo_fill_description' );
add_filter( 'wpseo_metadesc', 'hh_seo_fill_description' );
add_filter( 'wpseo_opengraph_desc', 'hh_seo_fill_description' );
add_filter( 'aioseo_description', 'hh_seo_fill_description' );

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
	return $xml . '<sitemap><loc>' . esc_url( home_url( '/nhadat-sitemap.xml' ) ) . '</loc><lastmod>' . esc_html( gmdate( 'c' ) ) . "</lastmod></sitemap>\n";
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
	foreach ( hh_seo_landing_urls() as $url ) {
		echo '<url><loc>' . esc_url( $url ) . "</loc></url>\n";
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
