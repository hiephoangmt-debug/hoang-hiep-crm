<?php
/**
 * SEO cho Google và công cụ tìm kiếm AI (ChatGPT, Perplexity, Gemini…):
 * meta description, Open Graph, schema.org JSON-LD, robots.txt, sitemap, /llms.txt.
 *
 * Nếu cài Yoast SEO hoặc Rank Math, phần meta & schema ở đây tự tắt để tránh trùng.
 */

defined( 'ABSPATH' ) || exit;

function hh_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/* -------------------------------------------------------------------------
 * Titles
 * ---------------------------------------------------------------------- */

add_filter( 'document_title_parts', 'hh_seo_title_parts' );
function hh_seo_title_parts( $parts ) {
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		$parts['title'] = hh_listing_archive_title() . ' Đà Nẵng';
	} elseif ( is_post_type_archive( 'du-an' ) ) {
		$parts['title'] = 'Dự án bất động sản Đà Nẵng';
	} elseif ( is_tax( 'loai-du-an' ) ) {
		$parts['title'] = 'Dự án ' . mb_strtolower( single_term_title( '', false ) ) . ' Đà Nẵng';
	} elseif ( is_tax( 'khu-vuc' ) ) {
		$parts['title'] = 'Bất động sản ' . single_term_title( '', false ) . ', Đà Nẵng';
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
	if ( is_front_page() ) {
		return hoanghiep_opt( 'hh_hero_text' ) . ' ' . hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) . ', hotline ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_singular( 'du-an' ) ) {
		$bits = array_filter(
			array(
				get_the_title(),
				hh_meta( 'hh_p_type' ),
				hh_meta( 'hh_p_address' ) ? 'tại ' . hh_meta( 'hh_p_address' ) : '',
				hh_meta( 'hh_p_developer' ) ? 'chủ đầu tư ' . hh_meta( 'hh_p_developer' ) : '',
				'giá ' . mb_strtolower( hh_project_price() ),
			)
		);
		$lead = has_excerpt() ? get_the_excerpt() : '';
		return trim( $lead ? $lead . ' ' . implode( ', ', $bits ) . '.' : implode( ', ', $bits ) . '. Bảng giá, mặt bằng, tiến độ, chính sách mới nhất.' );
	}
	if ( is_singular( 'bat-dong-san' ) ) {
		$deal = 'thue' === hh_meta( 'hh_deal' ) ? 'Cho thuê' : 'Bán';
		$bits = array_filter(
			array(
				$deal . ' ' . get_the_title(),
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
	if ( is_post_type_archive( 'du-an' ) || is_tax( 'loai-du-an' ) ) {
		return 'Danh sách dự án căn hộ, đất nền, nhà phố tại Đà Nẵng: vị trí, giá bán, mặt bằng, tiến độ và chính sách mới nhất. Tư vấn: ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	if ( is_post_type_archive( 'bat-dong-san' ) || is_tax( 'loai-bds' ) ) {
		return hh_listing_archive_title() . ' tại Đà Nẵng, cập nhật hằng ngày, thông tin pháp lý rõ ràng. Lọc theo giá, diện tích, khu vực. Liên hệ ' . hoanghiep_opt( 'hh_phone' ) . '.';
	}
	return get_bloginfo( 'description' );
}

function hh_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
	}
	$fallback = hoanghiep_opt( 'hh_hero_image' ) ?: hoanghiep_opt( 'hh_person_photo' );
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

/** Filter / sort / search result pages: keep crawlable but out of the index. */
add_filter( 'wp_robots', 'hh_seo_robots' );
function hh_seo_robots( $robots ) {
	foreach ( array( 'tk', 'gia', 'dt', 'pn', 'huong', 'sx', 'tt', 'lien-he' ) as $var ) {
		if ( isset( $_GET[ $var ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$robots['noindex'] = true;
			$robots['follow']  = true;
			break;
		}
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
		'founder'     => array( '@type' => 'Person', 'name' => hoanghiep_opt( 'hh_person_name' ), 'jobTitle' => hoanghiep_opt( 'hh_person_title' ) ),
	);
	if ( hoanghiep_opt( 'hh_person_photo' ) ) {
		$agent['image'] = hoanghiep_opt( 'hh_person_photo' );
	}
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
	$type   = 'Residence';
	$terms  = get_the_terms( $id, 'loai-du-an' );
	if ( $terms && ! is_wp_error( $terms ) && 'can-ho' === $terms[0]->slug ) {
		$type = 'ApartmentComplex';
	}
	$data = array(
		'@type'       => array( $type, 'Product' ),
		'@id'         => get_permalink() . '#du-an',
		'name'        => get_the_title(),
		'url'         => get_permalink(),
		'description' => hh_seo_description(),
		'address'     => array( '@type' => 'PostalAddress', 'streetAddress' => hh_meta( 'hh_p_address' ), 'addressRegion' => 'Đà Nẵng', 'addressCountry' => 'VN' ),
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
	$map   = array( 'can-ho' => 'Apartment', 'nha-pho' => 'House', 'nha-hem' => 'House', 'biet-thu' => 'SingleFamilyResidence' );
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
	if ( hh_seo_plugin_active() || is_404() ) {
		return;
	}
	$graph = array( hh_schema_agent() );

	if ( is_front_page() ) {
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
		$graph[] = hh_schema_faq( hh_table( 'hh_p_faq', 2 ) );
	} elseif ( is_singular( 'bat-dong-san' ) ) {
		$graph[] = hh_schema_listing();
	} elseif ( is_singular( 'post' ) ) {
		$graph[] = array(
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'description'      => hh_seo_description(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'mainEntityOfPage' => get_permalink(),
			'image'            => has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' ) : null,
			'author'           => array( '@type' => 'Person', 'name' => hoanghiep_opt( 'hh_person_name' ), 'url' => home_url( '/gioi-thieu/' ) ),
			'publisher'        => array( '@id' => home_url( '/#agent' ) ),
			'inLanguage'       => 'vi-VN',
		);
	} elseif ( is_page( 'gioi-thieu' ) ) {
		$graph[] = array(
			'@type'      => 'ProfilePage',
			'url'        => get_permalink(),
			'mainEntity' => array(
				'@type'       => 'Person',
				'name'        => hoanghiep_opt( 'hh_person_name' ),
				'jobTitle'    => hoanghiep_opt( 'hh_person_title' ),
				'description' => hoanghiep_opt( 'hh_person_bio' ),
				'telephone'   => hoanghiep_tel(),
				'email'       => hoanghiep_opt( 'hh_email' ),
				'worksFor'    => array( '@id' => home_url( '/#agent' ) ),
				'image'       => hoanghiep_opt( 'hh_person_photo' ) ?: null,
			),
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

	$graph[] = hh_schema_breadcrumb();
	$graph   = array_values( array_filter( $graph ) );

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
	$out .= 'Sitemap: ' . home_url( '/wp-sitemap.xml' ) . "\n";
	return $out;
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
		'- Khu vực hoạt động: ' . ( false !== mb_stripos( hoanghiep_opt( 'hh_address' ), 'Đà Nẵng' ) ? hoanghiep_opt( 'hh_address' ) : 'Đà Nẵng (' . hoanghiep_opt( 'hh_address' ) . ')' ),
		'- Hotline / Zalo: ' . hoanghiep_opt( 'hh_phone' ),
		'- Email: ' . hoanghiep_opt( 'hh_email' ),
		'- Giờ làm việc: ' . hoanghiep_opt( 'hh_hours' ),
		'- Website: ' . home_url( '/' ),
		'',
		'## Trang chính',
		'',
		'- [Dự án Đà Nẵng](' . get_post_type_archive_link( 'du-an' ) . '): dự án căn hộ, đất nền, nhà phố đang phân phối',
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
