<?php
/**
 * Trang ngoại ngữ cho khách nước ngoài: /en/ (tiếng Anh), /ko/ (tiếng Hàn).
 *
 * Mỗi ngôn ngữ là 1 trang WordPress (tự tạo, slug "en" / "ko"), hiển thị bằng mẫu page-en.php / page-ko.php của giao diện.
 * Các trang tiếng Việt khác: nút EN / KO mở bản dịch tự động của Google (translate.goog) – không tạo trang trùng lặp.
 */

defined( 'ABSPATH' ) || exit;

/** Ngôn ngữ phụ: mã => [locale, tên hiển thị, tiêu đề SEO, mô tả SEO, tiêu đề trang]. */
function hh_langs() {
	return array(
		'en' => array(
			'locale' => 'en_US',
			'name'   => 'English',
			'title'  => 'Da Nang Real Estate Advisor for Foreigners – Hoang Hiep',
			'desc'   => 'Buy, rent or invest in Da Nang property with an English-speaking advisor: new condos, resale apartments, villas, foreign ownership rules, legal checks. Zalo +84 904 567 009.',
			'page'   => 'Da Nang Real Estate for Foreign Buyers',
		),
		'ko' => array(
			'locale' => 'ko_KR',
			'name'   => '한국어',
			'title'  => '다낭 부동산 상담 – 외국인 아파트 구매 | 호앙 히엡',
			'desc'   => '다낭 아파트·빌라 구매, 임대, 투자 상담. 외국인 소유 규정, 분양 프로젝트, 법적 서류 확인까지 안내합니다. Zalo +84 904 567 009.',
			'page'   => '다낭 부동산 – 외국인 구매 안내',
		),
	);
}

/** Tạo trang /en/, /ko/ nếu chưa có (chạy 1 lần mỗi phiên bản plugin). */
add_action(
	'init',
	static function () {
		if ( wp_installing() || get_option( 'hh_lang_pages_ver' ) === HH_CRM_VERSION ) {
			return;
		}
		$ids = array();
		foreach ( hh_langs() as $code => $l ) {
			$page = get_page_by_path( $code );
			$ids[ $code ] = $page ? $page->ID : wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_name'   => $code,
					'post_title'  => $l['page'],
				)
			);
		}
		update_option( 'hh_lang_pages', array_map( 'intval', $ids ) );
		update_option( 'hh_lang_pages_ver', HH_CRM_VERSION );
	},
	30
);

/** Mã ngôn ngữ trang đang xem: 'en', 'ko' hoặc 'vi'. */
function hh_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	if ( ! did_action( 'wp' ) ) {
		return 'vi';
	}
	$lang = 'vi';
	foreach ( (array) get_option( 'hh_lang_pages', array() ) as $code => $id ) {
		if ( $id && is_page( $id ) ) {
			$lang = $code;
		}
	}
	return $lang;
}

function hh_lang_url( $code ) {
	$id = (int) ( get_option( 'hh_lang_pages', array() )[ $code ] ?? 0 );
	return 'vi' === $code || ! $id ? home_url( '/' ) : get_permalink( $id );
}

/** Bản dịch tự động của Google cho 1 URL tiếng Việt (https://hiephoangmt-com.translate.goog/...). */
function hh_translate_url( $url, $code ) {
	$p = wp_parse_url( $url );
	if ( empty( $p['host'] ) ) {
		return $url;
	}
	// Trang của web: dùng bản dịch chạy bằng code (/en/…, /ko/…) – không qua Google Dịch.
	if ( function_exists( 'hh_tl_path_ok' ) && in_array( $code, array( 'en', 'ko' ), true ) && wp_parse_url( home_url(), PHP_URL_HOST ) === $p['host'] && hh_tl_path_ok( $p['path'] ?? '/' ) ) {
		return home_url( '/' . $code . ( $p['path'] ?? '/' ) ) . ( isset( $p['query'] ) ? '?' . $p['query'] : '' );
	}
	$host = str_replace( '.', '-', str_replace( '-', '--', $p['host'] ) ) . '.translate.goog';
	$out  = 'https://' . $host . ( $p['path'] ?? '/' ) . ( isset( $p['query'] ) ? '?' . $p['query'] : '' );
	return add_query_arg( array( '_x_tr_sl' => 'vi', '_x_tr_tl' => $code, '_x_tr_hl' => $code ), $out );
}

/** Liên kết nút chuyển ngôn ngữ: trang chủ / trang ngoại ngữ → trang riêng; trang tiếng Việt khác → bản dịch tự động. */
/** Trang dự án có bản tiếng Anh viết riêng (theme landing/<slug>--en.html): trả về đường dẫn bản VI / EN, rỗng nếu không có. */
function hh_project_en_pair() {
	if ( ! is_singular( 'du-an' ) || ! function_exists( 'get_theme_file_path' ) ) {
		return array();
	}
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	if ( ! $slug || ! is_file( get_theme_file_path( 'landing/' . $slug . '--en.html' ) ) ) {
		return array();
	}
	$vi = trailingslashit( get_permalink( get_queried_object_id() ) );
	return array(
		'vi'    => $vi,
		'en'    => $vi . 'en/',
		'is_en' => 'en' === get_query_var( 'hh_landing_sub' ),
	);
}

function hh_lang_switch_url( $code ) {
	$pair = hh_project_en_pair();
	if ( $pair && in_array( $code, array( 'vi', 'en' ), true ) ) {
		return $pair[ $code ];
	}
	if ( function_exists( 'hh_tl' ) && ( hh_tl() || ( ! is_front_page() && 'vi' === hh_lang() && hh_tl_path_ok( hh_tl_path() ) ) ) ) {
		return hh_tl_url( $code );
	}
	if ( 'vi' === $code || 'vi' !== hh_lang() || is_front_page() ) {
		return hh_lang_url( $code );
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/'; // phpcs:ignore
	return hh_translate_url( home_url( $uri ), $code );
}

/* SEO: thẻ lang, og:locale, hreflang, tiêu đề + mô tả riêng. */
add_filter(
	'language_attributes',
	static function ( $out ) {
		$pair = hh_project_en_pair();
		if ( $pair && $pair['is_en'] ) {
			return 'lang="en-US"';
		}
		return 'vi' === hh_lang() ? $out : 'lang="' . esc_attr( str_replace( '_', '-', hh_langs()[ hh_lang() ]['locale'] ) ) . '"';
	}
);
add_filter( 'rank_math/opengraph/facebook/og_locale', static fn( $l ) => ( hh_project_en_pair()['is_en'] ?? false ) ? 'en_US' : ( 'vi' === hh_lang() ? $l : hh_langs()[ hh_lang() ]['locale'] ) );
add_action(
	'wp_head',
	static function () {
		$pair = hh_project_en_pair();
		if ( $pair ) {
			printf( "<link rel=\"alternate\" hreflang=\"vi\" href=\"%s\">\n<link rel=\"alternate\" hreflang=\"en\" href=\"%s\">\n<link rel=\"alternate\" hreflang=\"x-default\" href=\"%s\">\n", esc_url( $pair['vi'] ), esc_url( $pair['en'] ), esc_url( $pair['vi'] ) );
			return;
		}
		if ( ! is_front_page() && 'vi' === hh_lang() ) {
			return;
		}
		printf( "<link rel=\"alternate\" hreflang=\"vi\" href=\"%s\">\n", esc_url( home_url( '/' ) ) );
		foreach ( array_keys( hh_langs() ) as $code ) {
			printf( "<link rel=\"alternate\" hreflang=\"%s\" href=\"%s\">\n", esc_attr( $code ), esc_url( hh_lang_url( $code ) ) );
		}
		printf( "<link rel=\"alternate\" hreflang=\"x-default\" href=\"%s\">\n", esc_url( home_url( '/' ) ) );
	},
	2
);
foreach ( array( 'rank_math/frontend/title', 'rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title', 'wpseo_title', 'wpseo_opengraph_title' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => 'vi' === hh_lang() ? $v : hh_langs()[ hh_lang() ]['title'], 120 );
}
foreach ( array( 'rank_math/frontend/description', 'rank_math/opengraph/facebook/og_description', 'rank_math/opengraph/twitter/twitter_description', 'wpseo_metadesc', 'wpseo_opengraph_desc' ) as $hh_filter ) {
	add_filter( $hh_filter, static fn( $v ) => 'vi' === hh_lang() ? $v : hh_langs()[ hh_lang() ]['desc'], 120 );
}
unset( $hh_filter );
add_filter( 'document_title_parts', static fn( $parts ) => 'vi' === hh_lang() ? $parts : array( 'title' => hh_langs()[ hh_lang() ]['title'] ), 120 );

/**
 * Bản dịch Google (translate.goog): thay sẵn thuật ngữ bất động sản & nhãn giao diện bằng bản dịch chuẩn (đánh dấu translate="no"
 * để Google không dịch lại), sửa nút ngôn ngữ cho đúng trang đang xem. Chạy trước khi Google dịch trang.
 */
function hh_lang_glossary() {
	return array(
		// Tình trạng, loại dự án.
		'Sắp mở bán'               => array( 'Coming soon', '분양 예정' ),
		'Đang mở bán'              => array( 'On sale', '분양 중' ),
		'Đang bàn giao'            => array( 'Handover in progress', '입주 진행 중' ),
		'Đã bàn giao'              => array( 'Handed over', '입주 완료' ),
		'Đã bán hết từ chủ đầu tư' => array( 'Sold out by the developer', '시행사 분양 완료' ),
		'✔ Đã bán hết từ chủ đầu tư' => array( '✔ Sold out by the developer', '✔ 시행사 분양 완료' ),
		'Tất cả tình trạng'        => array( 'All statuses', '전체 상태' ),
		'Tất cả'                   => array( 'All', '전체' ),
		'Tất cả khu vực'           => array( 'All areas', '전체 지역' ),
		'Tổ hợp dự án'             => array( 'Mixed-use township', '복합 단지' ),
		'Cao tầng'                 => array( 'High-rise', '고층' ),
		'Thấp tầng'                => array( 'Low-rise', '저층' ),
		'Căn hộ sở hữu lâu dài'    => array( 'Condominium (long-term ownership)', '아파트(영구 소유)' ),
		'Căn hộ dịch vụ (50 năm)'  => array( 'Serviced apartment (50-year)', '서비스 아파트(50년)' ),
		'Biệt thự nghỉ dưỡng'      => array( 'Resort villas', '리조트 빌라' ),
		'Nhà phố – Shophouse'      => array( 'Townhouses & shophouses', '타운하우스·샵하우스' ),
		'Đất nền'                  => array( 'Land plots', '토지(필지)' ),
		// Menu, nút liên hệ.
		'Trang chủ'                => array( 'Home', '홈' ),
		'Dự án'                    => array( 'Projects', '분양 프로젝트' ),
		'Mua bán'                  => array( 'Buy & sell', '매매' ),
		'Cho thuê'                 => array( 'For rent', '임대' ),
		'Tin tức'                  => array( 'News', '뉴스' ),
		'Về Hiệp'                  => array( 'About Hiep', '히엡 소개' ),
		'Liên hệ'                  => array( 'Contact', '문의' ),
		'Gọi ngay'                 => array( 'Call now', '전화하기' ),
		'Chat Zalo'                => array( 'Chat on Zalo', 'Zalo 상담' ),
		'Nhận tư vấn'              => array( 'Get advice', '상담 신청' ),
		'Hotline tư vấn'           => array( 'Hotline', '상담 전화' ),
		'Tìm dự án'                => array( 'Find projects', '프로젝트 찾기' ),
		'Nhận bảng giá'            => array( 'Get the price list', '분양가표 받기' ),
		'Nhận danh sách căn'       => array( 'Get available units', '매물 목록 받기' ),
		'Nhận danh sách căn đang bán' => array( 'Get units for sale', '매매 매물 목록 받기' ),
		'Gửi thông tin căn qua Zalo' => array( 'Send your unit details via Zalo', 'Zalo로 매물 정보 보내기' ),
		'Loại căn'                 => array( 'Unit types', '세대 유형' ),
		'Giá'                      => array( 'Prices', '가격' ),
		'Sản phẩm'                 => array( 'Units', '세대' ),
		'Giá chuyển nhượng'        => array( 'Resale price', '전매 가격' ),
		'Giá thuê'                 => array( 'Rent', '임대료' ),
		'Vận hành'                 => array( 'Operator', '운영사' ),
		'Tiêu chuẩn bàn giao'      => array( 'Handover standard', '인도 기준' ),
		'Loại / mã căn'            => array( 'Unit type', '세대 유형' ),
		'Diện tích đất'            => array( 'Land area', '대지 면적' ),
		'Quy cách'                 => array( 'Features', '특징' ),
		'Giá bán'                  => array( 'Price', '가격' ),
		// Mục lục trang dự án.
		'Giới thiệu'               => array( 'Overview', '소개' ),
		'Tổng quan'                => array( 'Key facts', '개요' ),
		'Vị trí'                   => array( 'Location', '입지' ),
		'Tiện ích'                 => array( 'Amenities', '편의시설' ),
		'Mặt bằng'                 => array( 'Floor plans', '평면도' ),
		'Layout căn'               => array( 'Unit layouts', '세대 평면' ),
		'Giá & chính sách'         => array( 'Prices & sales policy', '분양가·분양 정책' ),
		'Tiến độ'                  => array( 'Construction progress', '공사 진행' ),
		'Hình ảnh'                 => array( 'Gallery', '사진' ),
		'Hỏi đáp'                  => array( 'FAQ', '자주 묻는 질문' ),
		// Bảng thông tin dự án.
		'Tên thương mại'           => array( 'Project name', '단지명' ),
		'Chủ đầu tư'               => array( 'Developer', '시행사' ),
		'Loại hình'                => array( 'Property type', '상품 유형' ),
		'Quy mô'                   => array( 'Site area', '대지 규모' ),
		'Mật độ xây dựng'          => array( 'Building density', '건폐율' ),
		'Số tòa'                   => array( 'Buildings', '동 수' ),
		'Số tầng'                  => array( 'Floors', '층수' ),
		'Tổng số sản phẩm'         => array( 'Total units', '총 세대수' ),
		'Pháp lý'                  => array( 'Legal status', '법적 상태' ),
		'Hình thức sở hữu'         => array( 'Ownership', '소유 형태' ),
		'Sở hữu lâu dài'           => array( 'Long-term ownership', '영구 소유' ),
		'Bàn giao'                 => array( 'Handover', '입주(인도)' ),
		'Tình trạng'               => array( 'Status', '분양 상태' ),
		'Diện tích'                => array( 'Area', '면적' ),
		'Phòng ngủ'                => array( 'Bedrooms', '침실' ),
		'Giá tham khảo'            => array( 'Reference price', '참고 가격' ),
		'Bảng giá'                 => array( 'Price list', '분양가표' ),
		'Lịch thanh toán'          => array( 'Payment schedule', '납부 일정' ),
		'Chính sách & ưu đãi'      => array( 'Sales policy & incentives', '분양 정책·혜택' ),
		'Hỗ trợ vay ngân hàng'     => array( 'Bank loan support', '은행 대출 지원' ),
		'Tiện ích nội khu'         => array( 'On-site amenities', '단지 내 편의시설' ),
		'Tiện ích ngoại khu (khu vực xung quanh)' => array( 'Nearby amenities', '주변 편의시설' ),
		'Căn hộ'                   => array( 'Apartments', '아파트' ),
		'Shop khối đế'             => array( 'Podium shophouses', '포디움 상가' ),
		'Ưu đãi có hạn'            => array( 'Limited-time offer', '기간 한정 혜택' ),
		'Giá tốt nhất'             => array( 'Best price', '최저가' ),
		'Hình minh họa'            => array( 'Illustration', '예시 이미지' ),
		'Ngày'                     => array( 'Days', '일' ),
		'Giờ'                      => array( 'Hours', '시간' ),
		'Phút'                     => array( 'Min', '분' ),
		'Giây'                     => array( 'Sec', '초' ),
		// Ô tìm kiếm.
		'Tên dự án, chủ đầu tư…'   => array( 'Project name, developer…', '프로젝트명, 시행사…' ),
	);
}

/**
 * Cụm từ trong câu (thay một phần câu): địa danh, thuật ngữ BĐS. Chữ thường tự có thêm bản viết hoa chữ đầu.
 * Lưu ý địa danh: "cầu sông Hàn" Google dịch thành 한강대교 (cầu ở Seoul) – phải ghi rõ là Đà Nẵng.
 */
function hh_lang_phrases() {
	return array(
		'Bảng giá, chính sách bán hàng' => array( 'Price list & sales policy', '분양가표·분양 정책' ),
		'Ưu đãi & chính sách tháng'     => array( 'Offers & sales policy', '혜택·분양 정책' ),
		'cầu quay sông Hàn'             => array( 'Han River swing bridge', '다낭 한강 회전교' ),
		'cầu sông Hàn'                  => array( 'Han River Bridge', '다낭 한강교' ),
		'sông Hàn'                      => array( 'Han River', '다낭 한강' ),
		'cầu Rồng'                      => array( 'Dragon Bridge', '용다리' ),
		'cầu Trần Thị Lý'               => array( 'Tran Thi Ly Bridge', '쩐티리 다리' ),
		'cầu Hòa Xuân'                  => array( 'Hoa Xuan Bridge', '호아쑤언 다리' ),
		'giao dịch chuyển nhượng'       => array( '', '전매 거래' ), // Google dịch "chuyển nhượng" thành 픽업/이동 (đưa đón).
		'giá chuyển nhượng'             => array( '', '전매 가격' ),
		'chuyển nhượng'                 => array( '', '전매' ),
		'Cá Chuồn Cồ'                   => array( 'Ca Chuon Co', 'Ca Chuon Co' ),
		'bán đảo Sơn Trà'               => array( 'Son Tra Peninsula', '선짜 반도' ),
		'Bà Nà'                         => array( 'Ba Na Hills', '바나힐' ),
		'phố cổ Hội An'                 => array( 'Hoi An Ancient Town', '호이안 올드타운' ),
		'Hội An'                        => array( 'Hoi An', '호이안' ),
		'sân bay quốc tế Đà Nẵng'       => array( 'Da Nang International Airport', '다낭 국제공항' ),
		'sân bay Đà Nẵng'               => array( 'Da Nang Airport', '다낭 공항' ),
		'pháo hoa DIFF'                 => array( 'DIFF fireworks festival', '다낭 국제 불꽃축제(DIFF)' ),
		'Sun Early Key'                 => array( 'Sun Early Key', 'Sun Early Key(조기 입주 프로그램)' ),
		'sở hữu lâu dài'                => array( 'long-term ownership', '영구 소유' ),
		'căn hộ dịch vụ'                => array( 'serviced apartment', '서비스 아파트' ),
		'sổ hồng'                       => array( 'Pink Book (ownership certificate)', '핑크북(소유권 증서)' ),
		'thông thủy'                    => array( 'net area', '전용면적' ),
		'tim tường'                     => array( 'gross area', '공급면적' ),
		'bảo lãnh ngân hàng'            => array( 'bank guarantee', '은행 지급보증' ),
		'hợp đồng mua bán'              => array( 'sale and purchase agreement (SPA)', '매매계약서(SPA)' ),
		'phiếu tính giá'                => array( 'price quotation', '세대별 가격 견적서' ),
		'hỗ trợ lãi suất'               => array( 'interest-rate support', '이자 지원' ),
		'ân hạn nợ gốc'                 => array( 'principal grace period', '원금 상환 유예' ),
		'shophouse'                     => array( 'shophouse', '샵하우스' ),
		'penthouse'                     => array( 'penthouse', '펜트하우스' ),
	);
}

/** Tên riêng giữ nguyên (không để Google phiên âm "Sun Solar" thành 썬솔라): tên dự án (bỏ dấu) và thương hiệu chủ đầu tư. */
function hh_lang_brands() {
	$out = get_transient( 'hh_lang_brands' );
	if ( is_array( $out ) ) {
		return $out;
	}
	$out = array();
	foreach ( get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 400, 'post_status' => 'publish' ) ) as $p ) {
		$title = trim( preg_replace( '/\s*\([^)]*\)/u', '', $p->post_title ) );
		if ( preg_match( '/^[A-Z0-9]/', remove_accents( $title ) ) && ! preg_match( '/^(Khu|Dự án|Nhà|Căn|Đất|Biệt)/u', $title ) ) {
			$out[ $title ] = trim( preg_replace( '/\s+/u', ' ', remove_accents( $title ) ) );
		}
	}
	foreach ( array( 'Sun Group', 'Sun Property', 'Vinhomes', 'Vingroup', 'Masterise', 'Novaland', 'FPT City', 'Đất Xanh', 'Danh Khôi', 'Sun World', 'Sun NeO City', 'Accor', 'VietinBank', 'Vietcombank', 'BIDV', 'Techcombank', 'MB Bank' ) as $b ) {
		$out[ $b ] = remove_accents( $b );
	}
	set_transient( 'hh_lang_brands', $out, 12 * HOUR_IN_SECONDS );
	return $out;
}
add_action( 'save_post_du-an', static fn() => delete_transient( 'hh_lang_brands' ) );

add_action(
	'wp_footer',
	static function () {
		if ( is_admin() || ( function_exists( 'hh_tl' ) && hh_tl() ) ) { // Trang /en/, /ko/ đã dịch sẵn trên máy chủ (ngon-ngu-trang.php).
			return;
		}
		$phr = array();
		foreach ( hh_lang_phrases() as $vi => list( $en, $ko ) ) {
			$phr[ $vi ] = array( 'en' => $en, 'ko' => $ko );
			$up         = mb_strtoupper( mb_substr( $vi, 0, 1 ) ) . mb_substr( $vi, 1 );
			if ( $up !== $vi && ! isset( $phr[ $up ] ) ) {
				$phr[ $up ] = array( 'en' => '' === $en ? '' : ucfirst( $en ), 'ko' => $ko );
			}
		}
		foreach ( hh_lang_brands() as $vi => $latin ) {
			$phr[ $vi ] = array( 'en' => '', 'ko' => $latin ); // Tiếng Anh: Google giữ nguyên tên Latin – không khóa để câu không bị cắt khúc.
		}
		$map = array();
		foreach ( hh_lang_glossary() as $vi => list( $en, $ko ) ) {
			$map[ $vi ] = array( 'en' => $en, 'ko' => $ko );
		}
		foreach ( hh_lang_page_dict() as $vi => $tr ) { // Bảng dịch viết sẵn theo trang (chuẩn hơn bản dịch máy).
			if ( ! empty( $tr[0] ) || ! empty( $tr[1] ) ) {
				$map[ $vi ] = array( 'en' => (string) ( $tr[0] ?? '' ), 'ko' => (string) ( $tr[1] ?? '' ) );
			}
		}
		?>
<script>
(function () {
	var host = location.hostname;
	if ( ! /\.translate\.goog$/.test( host ) ) { return; }
	var tl = ( new URLSearchParams( location.search ).get( '_x_tr_tl' ) || '' ).slice( 0, 2 );
	var map = <?php echo wp_json_encode( $map, JSON_UNESCAPED_UNICODE ); ?>;
	var norm = function ( s ) { return s.replace( /\s+/g, ' ' ).trim(); };
	var lock = function ( el ) { el.setAttribute( 'translate', 'no' ); el.classList.add( 'notranslate' ); };
	if ( tl === 'en' || tl === 'ko' ) {
		// Tiêu đề dạng "Tổng quan <em>Tên dự án</em>": ghép lại đúng trật tự từng thứ tiếng ("Premier Village at a glance").
		var heads = <?php echo wp_json_encode( hh_lang_heading_patterns(), JSON_UNESCAPED_UNICODE ); ?>;
		document.querySelectorAll( 'h1, h2, h3' ).forEach( function ( h ) {
			var em = h.querySelector( 'em' );
			if ( ! em || h.closest( '[translate="no"]' ) ) { return; }
			var pre = norm( h.textContent.slice( 0, h.textContent.indexOf( em.textContent ) ) ), pat = heads[ pre ] && heads[ pre ][ tl === 'en' ? 0 : 1 ];
			if ( ! pat ) { return; }
			var name = norm( em.textContent ), tn = map[ name ] && map[ name ][ tl ];
			var parts = pat.split( '{n}' ), mk = function ( t ) { var sp = document.createElement( 'span' ); sp.textContent = t; lock( sp ); return sp; };
			var after = [], nx = em.nextSibling; // Phần sau <em> (VD ", khoảng 56 triệu/m²") giữ nguyên để Google dịch.
			while ( nx ) { after.push( nx ); nx = nx.nextSibling; }
			h.textContent = '';
			if ( parts[0] ) { h.appendChild( mk( parts[0] ) ); }
			if ( tn ) { em.textContent = tn; lock( em ); } // Chưa có bản dịch viết sẵn: để Google dịch phần trong <em>.
			h.appendChild( em );
			if ( parts[1] ) { h.appendChild( mk( parts[1] ) ); }
			after.forEach( function ( x ) { h.appendChild( x ); } );
		} );
		var doMap = function ( root ) {
		var walker = document.createTreeWalker( root, NodeFilter.SHOW_TEXT ), nodes = [], n;
		while ( ( n = walker.nextNode() ) ) { nodes.push( n ); }
		nodes.forEach( function ( node ) {
			var key = norm( node.nodeValue ), t = map[ key ] && map[ key ][ tl ];
			if ( ! t || ! node.parentNode || /^(SCRIPT|STYLE)$/.test( node.parentNode.nodeName ) ) { return; }
			node.nodeValue = node.nodeValue.replace( key, t );
			var p = node.parentNode;
			if ( p.childNodes.length === 1 || p.nodeName === 'OPTION' ) { lock( p ); return; }
			var span = document.createElement( 'span' );
			lock( span );
			p.replaceChild( span, node );
			span.appendChild( node );
		} );
		};
		doMap( document.body );
		// Khung chat, popup… chèn sau khi tải trang: dịch tiếp phần mới thêm (theo dõi 8 giây đầu).
		if ( window.MutationObserver ) {
			var mo = new MutationObserver( function ( ms ) { ms.forEach( function ( m ) { m.addedNodes.forEach( function ( a ) { if ( a.nodeType === 1 && ! a.closest( '[translate="no"]' ) ) { doMap( a ); } } ); } ); } );
			mo.observe( document.body, { childList: true, subtree: true } );
			setTimeout( function () { mo.disconnect(); }, 8000 );
		}
		// Cụm từ trong câu: thay phần khớp bằng <span translate="no">, phần còn lại để Google dịch.
		var phr = <?php echo wp_json_encode( $phr, JSON_UNESCAPED_UNICODE ); ?>;
		var keys = Object.keys( phr ).filter( function ( k ) { return phr[ k ][ tl ]; } ).sort( function ( a, b ) { return b.length - a.length; } );
		if ( keys.length ) {
			var re = new RegExp( '(' + keys.map( function ( k ) { return k.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' ); } ).join( '|' ) + ')', 'g' );
			var w2 = document.createTreeWalker( document.body, NodeFilter.SHOW_TEXT ), list = [], m2;
			while ( ( m2 = w2.nextNode() ) ) { list.push( m2 ); }
			list.forEach( function ( node ) {
				var p = node.parentNode;
				if ( ! p || /^(SCRIPT|STYLE|OPTION|TEXTAREA)$/.test( p.nodeName ) || p.closest( '[translate="no"]' ) ) { return; }
				var txt = node.nodeValue;
				re.lastIndex = 0;
				if ( ! re.test( txt ) ) { return; }
				re.lastIndex = 0;
				var frag = document.createDocumentFragment(), last = 0, mm;
				while ( ( mm = re.exec( txt ) ) ) {
					if ( mm.index > last ) { frag.appendChild( document.createTextNode( txt.slice( last, mm.index ) ) ); }
					var sp = document.createElement( 'span' ), bef = txt.charAt( mm.index - 1 ), aft = txt.charAt( mm.index + mm[0].length );
					// Google bỏ khoảng trắng sát cụm giữ nguyên → chữ dính ("Sun Groupon the beach"): đặt khoảng trắng bên trong cụm.
					sp.textContent = ( /\s/.test( bef ) ? ' ' : '' ) + phr[ mm[0] ][ tl ] + ( /\s/.test( aft ) ? ' ' : '' );
					lock( sp );
					frag.appendChild( sp );
					last = mm.index + mm[0].length;
				}
				if ( last < txt.length ) { frag.appendChild( document.createTextNode( txt.slice( last ) ) ); }
				p.replaceChild( frag, node );
			} );
		}
		document.querySelectorAll( '[placeholder]' ).forEach( function ( el ) {
			var t = map[ norm( el.getAttribute( 'placeholder' ) ) ];
			if ( t ) { el.setAttribute( 'placeholder', t[ tl ] ); lock( el ); }
		} );
	}
	// Nút ngôn ngữ: đánh dấu ngôn ngữ đang xem, VI về trang gốc.
	var origin = 'https://' + host.replace( /\.translate\.goog$/, '' ).replace( /--/g, '\u0000' ).replace( /-/g, '.' ).replace( /\u0000/g, '-' );
	document.querySelectorAll( '.lang-switch__item' ).forEach( function ( el ) {
		var code = ( el.getAttribute( 'hreflang' ) || el.textContent || '' ).trim().toLowerCase();
		if ( el.classList.contains( 'is-active' ) ) { code = 'vi'; }
		var a = document.createElement( code === tl ? 'span' : 'a' );
		a.className = 'lang-switch__item' + ( code === tl ? ' is-active' : '' );
		a.textContent = code.toUpperCase();
		if ( code !== tl ) {
			if ( code === 'vi' ) {
				var q = new URLSearchParams( location.search );
				[ '_x_tr_sl', '_x_tr_tl', '_x_tr_hl', '_x_tr_pto' ].forEach( function ( k ) { q.delete( k ); } );
				a.href = origin + location.pathname + ( q.toString() ? '?' + q : '' );
			} else {
				var u = new URL( location.href );
				u.searchParams.set( '_x_tr_tl', code );
				u.searchParams.set( '_x_tr_hl', code );
				a.href = u.toString();
			}
		}
		lock( a );
		el.parentNode.replaceChild( a, el );
	} );
})();
</script>
		<?php
	},
	1
);

/**
 * Bảng dịch viết sẵn (tr/chung.json cho nhãn dùng chung + tr/<loại>/<slug>.json theo trang): { "câu tiếng Việt": ["English", "한국어"] }.
 * Nhúng vào chân trang; mã JS chỉ dùng tới khi trang được mở qua bản dịch translate.goog.
 */
function hh_lang_page_dict() {
	if ( is_admin() ) {
		return array();
	}
	// tieu-de.json: tiêu đề + mô tả ngắn mọi bài, dự án, tin rao (thẻ bài liên quan, danh sách) – trang nào cũng dùng được.
	$files = array( HH_CRM_DIR . 'tr/chung.json', HH_CRM_DIR . 'tr/tieu-de.json' );
	$obj   = get_queried_object();
	// Bảng dịch theo đường dẫn (trang danh mục, khu vực, chủ đầu tư, trang lọc…): tr/duong-dan/<đường-dẫn với "/" thay bằng "__">.json.
	$path = function_exists( 'hh_tl_path' ) ? hh_tl_path() : (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '/' ), PHP_URL_PATH ); // phpcs:ignore
	$key  = preg_replace( '#[^a-z0-9_-]#', '', str_replace( '/', '__', strtolower( trim( $path, '/' ) ) ) );
	if ( '' !== $key ) {
		$files[] = HH_CRM_DIR . 'tr/duong-dan/' . $key . '.json';
	}
	if ( $obj instanceof WP_Post ) {
		$files[] = HH_CRM_DIR . 'tr/' . sanitize_key( $obj->post_type ) . '/' . sanitize_title( $obj->post_name ) . '.json';
	} elseif ( is_front_page() ) {
		$files[] = HH_CRM_DIR . 'tr/trang-chu.json';
	} elseif ( is_post_type_archive() ) {
		$files[] = HH_CRM_DIR . 'tr/luu-tru-' . sanitize_key( (string) get_query_var( 'post_type' ) ) . '.json';
	}
	$out = array();
	foreach ( $files as $f ) {
		if ( is_file( $f ) ) {
			$d = json_decode( (string) file_get_contents( $f ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			if ( is_array( $d ) ) {
				$out = array_merge( $out, $d );
			}
		}
	}
	return $out;
}

/** Tiêu đề mục trang dự án "Tiền tố <em>Tên</em>" → mẫu câu đúng trật tự EN / KO ({n} = tên dự án hoặc giá đã dịch). */
function hh_lang_heading_patterns() {
	return array(
		'Tổng quan'              => array( '{n} at a glance', '{n} 개요' ),
		'Vị trí'                 => array( 'Location of {n}', '{n} 입지' ),
		'Tiện ích'               => array( '{n} amenities', '{n} 편의시설' ),
		'Mặt bằng'               => array( '{n} floor plans', '{n} 평면도' ),
		'Các loại sản phẩm'      => array( '{n} unit types', '{n} 세대 유형' ),
		'Pháp lý'                => array( '{n} legal status', '{n} 법적 상태' ),
		'Giá chuyển nhượng'      => array( 'Resale price: {n}', '전매 가격: {n}' ),
		'Bảng giá'               => array( '{n} price list', '{n} 분양가표' ),
		'Giá'                    => array( 'Price: {n}', '가격: {n}' ),
		'Các dự án trong'        => array( 'Projects in {n}', '{n} 내 프로젝트' ),
		'Các dự án khác cùng tổ hợp' => array( 'Other projects in the {n} complex', '{n} 단지 내 다른 프로젝트' ),
		'Chính sách bán hàng'    => array( '{n} sales policy', '{n} 분양 정책' ),
		'Tiến độ'                => array( '{n} construction progress', '{n} 공사 진행' ),
		'Tin mới về'             => array( 'Latest news on {n}', '{n} 최신 소식' ),
		'Khách hay hỏi về'       => array( 'FAQs about {n}', '{n} 자주 묻는 질문' ),
		'Danh sách căn đang bán' => array( '{n} units for sale', '{n} 매물 목록' ),
		'Nội thất bàn giao'      => array( '{n} handover interiors', '{n} 인도 인테리어' ),
		'Căn hộ mẫu'             => array( '{n} show apartment', '{n} 모델하우스' ),
		'Bảng giá & chính sách'  => array( '{n} prices & sales policy', '{n} 분양가·분양 정책' ),
		'Giá bất động sản quanh' => array( 'Property prices around {n}', '{n} 주변 부동산 시세' ),
	);
}
