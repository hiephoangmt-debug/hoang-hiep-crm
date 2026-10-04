<?php
/**
 * Reusable template components.
 */

defined( 'ABSPATH' ) || exit;

/** Inline SVG icon (stroke icons, 24×24). */
function hh_icon( $name ) {
	$paths = array(
		'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
		'pin'      => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
		'area'     => '<path d="M3 3h18v18H3z"/><path d="M3 9h18M9 21V9"/>',
		'bed'      => '<path d="M2 4v16M2 8h18a2 2 0 0 1 2 2v10M2 17h20M6 8v9"/>',
		'bath'     => '<path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-2.1 0L3.5 4.4A1.5 1.5 0 0 0 3 5.5V17a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5H3"/><path d="M7 19v2M17 19v2"/>',
		'compass'  => '<circle cx="12" cy="12" r="10"/><path d="m16.2 7.8-2.1 6.4-6.4 2.1 2.1-6.4z"/>',
		'check'    => '<path d="M20 6 9 17l-5-5"/>',
		'clock'    => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'arrow'    => '<path d="M5 12h14M12 5l7 7-7 7"/>',
		'search'   => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'building' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/>',
		'file'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M12 18v-6M9 15l3 3 3-3"/>',
		'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
		'handshake' => '<path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.9-3.9a3 3 0 0 0-4.2 0l-.9.9a1 1 0 1 1-3-3l2.8-2.8a5 5 0 0 1 6 0l.4.3a2 2 0 0 0 1.5.3L21 4"/><path d="m21 3 1 11h-2M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3M3 4h8"/>',
		'star'     => '<path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8-6.2-3.2-6.2 3.2L7 14.2 2 9.3l6.9-1z"/>',
		'play'     => '<polygon points="6 3 20 12 6 21 6 3"/>',
		'gift'     => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M19 12v9H5v-9M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8s1-5 4.5-5a2.5 2.5 0 0 1 0 5"/>',
		'menu'     => '<path d="M4 6h16M4 12h16M4 18h16"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths[ $name ] . '</svg>';
}

function hh_section_head( $eyebrow, $title, $link = '', $link_text = 'Xem tất cả' ) {
	?>
	<div class="section-head">
		<div>
			<?php if ( $eyebrow ) : ?><p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
			<h2 class="section-head__title"><?php echo esc_html( $title ); ?></h2>
		</div>
		<?php if ( $link ) : ?>
			<a class="link-arrow" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $link_text ); ?> <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</div>
	<?php
}

/** Grid of images that open in the lightbox. */
function hh_gallery( $ids, $group, $class = 'gallery-grid' ) {
	$ids = array_filter( (array) $ids );
	if ( ! $ids ) {
		return;
	}
	printf( '<div class="%s">', esc_attr( $class ) );
	foreach ( $ids as $id ) {
		$full = wp_get_attachment_image_url( $id, 'full' );
		if ( ! $full ) {
			continue;
		}
		printf(
			'<a href="%s" data-lightbox="%s">%s</a>',
			esc_url( $full ),
			esc_attr( $group ),
			wp_get_attachment_image( $id, 'hh-card', false, array( 'loading' => 'lazy' ) )
		);
	}
	echo '</div>';
}

/** "16.0602, 108.2280" → array( lat, lng ) hoặc null. */
function hh_parse_coords( $text ) {
	if ( preg_match( '/^\s*(-?\d{1,2}(?:\.\d+)?)\s*[,;\s]\s*(-?\d{1,3}(?:\.\d+)?)\s*$/', (string) $text, $m ) && abs( (float) $m[1] ) <= 90 && abs( (float) $m[2] ) <= 180 ) {
		return array( (float) $m[1], (float) $m[2] );
	}
	return null;
}

/** Bản đồ Google: ưu tiên tọa độ (ghim chính xác), sau đó tên / địa chỉ. Kèm nút mở Google Maps, chỉ đường. */
function hh_map( $address, $coords = '' ) {
	$point = hh_parse_coords( $coords );
	$query = $point ? $point[0] . ',' . $point[1] : trim( (string) $address );
	if ( '' === $query ) {
		return;
	}
	printf(
		'<div class="map"><iframe title="Bản đồ" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=%s&amp;z=%d&amp;output=embed"></iframe></div>',
		rawurlencode( $query ),
		$point ? 16 : 15
	);
	printf(
		'<p class="map-links"><a href="https://www.google.com/maps/search/?api=1&amp;query=%1$s" target="_blank" rel="noopener">Mở trên Google Maps</a> · <a href="https://www.google.com/maps/dir/?api=1&amp;destination=%1$s" target="_blank" rel="noopener">Chỉ đường</a></p>',
		rawurlencode( $query )
	);
}

function hh_video( $url ) {
	$id = hh_youtube_id( $url );
	if ( ! $id ) {
		return;
	}
	printf(
		'<div class="video"><iframe title="Video" loading="lazy" src="https://www.youtube-nocookie.com/embed/%s" allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe></div>',
		esc_attr( $id )
	);
}

function hh_check_list( $items, $class = 'check-list' ) {
	if ( ! $items ) {
		return;
	}
	printf( '<ul class="%s">', esc_attr( $class ) );
	foreach ( $items as $item ) {
		printf( '<li>%s<span>%s</span></li>', hh_icon( 'check' ), esc_html( $item ) ); // phpcs:ignore
	}
	echo '</ul>';
}

/** Simple data table with a header row. */
function hh_data_table( $headers, $rows ) {
	if ( ! $rows ) {
		return;
	}
	echo '<div class="table-wrap"><table class="data-table"><thead><tr>';
	foreach ( $headers as $h ) {
		printf( '<th>%s</th>', esc_html( $h ) );
	}
	echo '</tr></thead><tbody>';
	foreach ( $rows as $row ) {
		echo '<tr>';
		foreach ( $row as $i => $cell ) {
			printf( '<td data-label="%s">%s</td>', esc_attr( $headers[ $i ] ?? '' ), esc_html( $cell ) );
		}
		echo '</tr>';
	}
	echo '</tbody></table></div>';
}

/** Label/value spec grid. */
function hh_spec_list( $rows ) {
	if ( ! $rows ) {
		return;
	}
	echo '<dl class="spec-list">';
	foreach ( $rows as $label => $value ) {
		printf( '<div><dt>%s</dt><dd>%s</dd></div>', esc_html( $label ), esc_html( $value ) );
	}
	echo '</dl>';
}

/** Personal card of Hiệp with call / Zalo buttons. */
function hh_agent_card( $compact = false ) {
	$name  = hoanghiep_opt( 'hh_person_name' );
	?>
	<div class="agent-card<?php echo $compact ? ' agent-card--compact' : ''; ?>">
		<div class="agent-card__head">
			<img class="agent-card__photo" src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( $name ); ?>" width="72" height="72" loading="lazy">
			<div>
				<p class="agent-card__name"><?php echo esc_html( $name ); ?></p>
				<p class="agent-card__title"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?></p>
				<?php
				$extra = array_filter(
					array(
						hoanghiep_opt( 'hh_person_company' ),
						0 === mb_stripos( hoanghiep_opt( 'hh_stat1_label' ), 'Năm' ) && hoanghiep_opt( 'hh_stat1_num' ) ? hoanghiep_opt( 'hh_stat1_num' ) . ' năm kinh nghiệm' : '',
					)
				);
				?>
				<?php if ( $extra ) : ?>
					<p class="agent-card__company"><?php echo esc_html( implode( ' · ', $extra ) ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<a class="btn btn--gold btn--cta btn--block" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
		<a class="btn btn--zalo btn--block" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Chat Zalo</a>
	</div>
	<?php
}

function hh_initials( $name ) {
	$words = preg_split( '/\s+/u', trim( $name ) );
	$first = mb_substr( $words[0] ?? '', 0, 1 );
	$last  = count( $words ) > 1 ? mb_substr( end( $words ), 0, 1 ) : '';
	return mb_strtoupper( $first . $last );
}

/** Small status pill. */
function hh_pill( $text, $variant = '' ) {
	if ( $text ) {
		printf( '<span class="pill%s">%s</span>', $variant ? ' pill--' . esc_attr( $variant ) : '', esc_html( $text ) );
	}
}

/**
 * Search box with Mua bán / Cho thuê / Dự án tabs (trang chủ và các trang nhà đất dùng chung).
 * $args: active (ban|thue|du-an|all), links (tab là đường dẫn thay vì nút chuyển form),
 *        all (thêm tab "Tất cả"), values (tk, khu-vuc, loai-bds đang chọn), hidden (ô ẩn giữ lại), action.
 */
function hh_search_box( $args = array() ) {
	$args  = wp_parse_args( $args, array( 'active' => 'ban', 'links' => false, 'all' => false, 'values' => array(), 'hidden' => array(), 'action' => '' ) );
	$areas = get_terms( array( 'taxonomy' => 'khu-vuc', 'hide_empty' => false, 'parent' => 0 ) );
	$types = get_terms( array( 'taxonomy' => 'loai-bds', 'hide_empty' => false ) );
	$tabs  = array();
	if ( $args['all'] ) {
		$tabs['all'] = array( 'Tất cả', get_post_type_archive_link( 'bat-dong-san' ) );
	}
	$tabs += array(
		'ban'   => array( 'Mua bán', hh_deal_url( 'ban' ) ),
		'thue'  => array( 'Cho thuê', hh_deal_url( 'thue' ) ),
		'du-an' => array( 'Dự án', get_post_type_archive_link( 'du-an' ) ),
	);
	$active = isset( $tabs[ $args['active'] ] ) ? $args['active'] : 'ban';
	$val    = static fn( $k ) => (string) ( $args['values'][ $k ] ?? '' );
	$ph     = array(
		'thue'  => 'Tìm căn hộ, nhà, mặt bằng cho thuê theo dự án, đường, khu vực…',
		'du-an' => 'Nhập tên dự án, chủ đầu tư, khu vực…',
	);
	?>
	<div class="search-box" data-search-box>
		<div class="search-box__tabs" role="tablist">
			<?php foreach ( $tabs as $key => list( $label, $url ) ) : ?>
				<?php if ( $args['links'] ) : ?>
					<a class="search-box__tab<?php echo $key === $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $url ); ?>"<?php echo $key === $active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a>
				<?php else : ?>
					<button type="button" role="tab" class="search-box__tab<?php echo $key === $active ? ' is-active' : ''; ?>" data-action="<?php echo esc_url( $url ); ?>" data-kind="<?php echo esc_attr( $key ); ?>" aria-selected="<?php echo $key === $active ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<form class="search-box__form" action="<?php echo esc_url( $args['action'] ?: $tabs[ $active ][1] ); ?>" method="get" role="search">
			<label class="search-box__field search-box__field--grow">
				<?php echo hh_icon( 'search' ); // phpcs:ignore ?>
				<input type="search" name="tk" value="<?php echo esc_attr( $val( 'tk' ) ); ?>" placeholder="<?php echo esc_attr( $ph[ $active ] ?? 'Nhập tên dự án, đường, khu vực…' ); ?>" aria-label="Từ khóa">
			</label>
			<?php if ( $areas && ! is_wp_error( $areas ) ) : ?>
				<select name="khu-vuc" aria-label="Khu vực" class="search-box__field">
					<option value="">Tất cả khu vực</option>
					<?php foreach ( $areas as $t ) : ?>
						<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $val( 'khu-vuc' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
			<?php if ( $types && ! is_wp_error( $types ) && 'du-an' !== $active ) : ?>
				<select name="loai-bds" aria-label="Loại nhà đất" class="search-box__field" data-hide-for="du-an">
					<option value="">Loại nhà đất</option>
					<?php foreach ( $types as $t ) : ?>
						<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $val( 'loai-bds' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
			<?php foreach ( array_filter( (array) $args['hidden'], 'strlen' ) as $k => $v ) : ?>
				<input type="hidden" name="<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $v ); ?>">
			<?php endforeach; ?>
			<button class="btn btn--gold" type="submit">Tìm kiếm</button>
		</form>
	</div>
	<?php
}

/* -------------------------------------------------------------------------
 * Tin tức
 * ---------------------------------------------------------------------- */

/** "4 phút đọc" – based on ~220 words per minute. */
function hh_reading_time( $post = null ) {
	$words = count( preg_split( '/\s+/u', trim( wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post ) ) ) ), -1, PREG_SPLIT_NO_EMPTY ) );
	return max( 1, (int) ceil( $words / 220 ) ) . ' phút đọc';
}

/** "Chuyên mục · 02/10/2026" */
function hh_post_meta_line() {
	$cat = get_the_category();
	return ( $cat ? $cat[0]->name . ' · ' : '' ) . get_the_date( 'd/m/Y' );
}

/**
 * Adds ids to h2/h3 in post content and returns [content, toc items].
 */
function hh_content_with_toc( $content ) {
	$toc  = array();
	$used = array();
	$content = preg_replace_callback(
		'/<h([23])([^>]*)>(.*?)<\/h\1>/is',
		function ( $m ) use ( &$toc, &$used ) {
			$text = wp_strip_all_tags( $m[3] );
			if ( preg_match( '/\sid="([^"]+)"/', $m[2], $idm ) ) {
				$id = $idm[1];
				$attrs = $m[2];
			} else {
				$id = sanitize_title( remove_accents( $text ) ) ?: 'muc';
				$base = $id;
				$n    = 2;
				while ( isset( $used[ $id ] ) ) {
					$id = $base . '-' . $n++;
				}
				$attrs = $m[2] . ' id="' . esc_attr( $id ) . '"';
			}
			$used[ $id ] = true;
			$toc[]       = array( 'level' => (int) $m[1], 'id' => $id, 'text' => $text );
			return '<h' . $m[1] . $attrs . '>' . $m[3] . '</h' . $m[1] . '>';
		},
		$content
	);
	return array( $content, $toc );
}

add_action( 'pre_get_posts', 'hh_news_query' );
function hh_news_query( $q ) {
	if ( ! is_admin() && $q->is_main_query() && ( $q->is_home() || $q->is_category() ) ) {
		$q->set( 'posts_per_page', 14 ); // Trang 1: 1 bài lớn + 4 bài nhỏ + 9 bài dạng lưới.
	}
}

/** Grid of activity photos with captions (lightbox group "hoat-dong"). */
function hh_highlights( $limit = 0, $class = 'highlights' ) {
	$items = hoanghiep_highlights();
	if ( $limit ) {
		$items = array_slice( $items, 0, $limit );
	}
	if ( ! $items ) {
		return;
	}
	printf( '<div class="%s">', esc_attr( $class ) );
	foreach ( $items as list( $url, $caption ) ) {
		printf(
			'<figure><a href="%1$s" data-lightbox="hoat-dong"><img src="%1$s" alt="%2$s" loading="lazy"></a>%3$s</figure>',
			esc_url( $url ),
			esc_attr( $caption ?: hoanghiep_opt( 'hh_person_name' ) ),
			$caption ? '<figcaption>' . esc_html( $caption ) . '</figcaption>' : ''
		);
	}
	echo '</div>';
}

/** "Thuộc tổ hợp" when the parent is a complex, otherwise "Phân khu của". */
function hh_parent_label( $parent_id ) {
	return has_term( 'to-hop', 'loai-du-an', $parent_id ) ? 'Thuộc tổ hợp' : 'Phân khu của';
}

/** Ô "đang cập nhật" cho mục dự án chưa có dữ liệu, kèm nút nhận thông tin. */
function hh_pending( $text, $button = 'Nhận thông tin mới nhất' ) {
	?>
	<div class="pending">
		<span class="pending__icon"><?php echo hh_icon( 'clock' ); // phpcs:ignore ?></span>
		<p><?php echo esc_html( $text ); ?></p>
		<?php if ( $button ) : ?>
			<a class="btn btn--outline btn--sm" href="#lien-he"><?php echo esc_html( $button ); ?></a>
		<?php endif; ?>
	</div>
	<?php
}

/** Trang dựng bằng Elementor cho giao diện cũ (Houzez…): bỏ qua nội dung để không vỡ bố cục. */
function hh_is_builder_page( $post_id = null ) {
	return 'builder' === get_post_meta( $post_id ?: get_the_ID(), '_elementor_edit_mode', true );
}

/**
 * Khung kêu gọi để lại thông tin trong từng mục trang dự án.
 * Nút chính kéo xuống form liên hệ, chọn sẵn nhu cầu và điền sẵn lời nhắn.
 */
function hh_cta_box( $args ) {
	$args = wp_parse_args( $args, array( 'icon' => 'star', 'title' => '', 'text' => '', 'button' => 'Nhận thông tin', 'need' => 'Nhận bảng giá dự án', 'msg' => '', 'variant' => '', 'link' => '', 'link_text' => '' ) );
	?>
	<div class="cta-box<?php echo $args['variant'] ? ' cta-box--' . esc_attr( $args['variant'] ) : ''; ?>">
		<span class="cta-box__icon"><?php echo hh_icon( $args['icon'] ); // phpcs:ignore ?></span>
		<div class="cta-box__body">
			<p class="cta-box__title"><?php echo esc_html( $args['title'] ); ?></p>
			<?php if ( $args['text'] ) : ?>
				<p class="cta-box__text"><?php echo esc_html( $args['text'] ); ?></p>
			<?php endif; ?>
		</div>
		<div class="cta-box__actions">
			<a class="btn btn--gold btn--sm" href="#lien-he" data-need="<?php echo esc_attr( $args['need'] ); ?>" data-msg="<?php echo esc_attr( $args['msg'] ); ?>"><?php echo esc_html( $args['button'] ); ?></a>
			<a class="btn btn--zalo btn--sm" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Zalo</a>
			<?php if ( $args['link'] ) : ?>
				<a class="cta-box__link" href="<?php echo esc_url( $args['link'] ); ?>"><?php echo esc_html( $args['link_text'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/** Ưu đãi đầu trang dự án: lấy từ ô "Chính sách & ưu đãi", chưa nhập thì dùng các quyền lợi chung khi đăng ký. */
function hh_project_offer( $post_id = null ) {
	return hh_project_offer_lines( $post_id ) ?: array(
		'Bảng giá và chính sách chiết khấu của đợt mở bán hiện tại',
		'Danh sách căn đẹp còn trống: tầng cao, căn góc, view đẹp',
		'Phương án thanh toán và hỗ trợ vay ngân hàng phù hợp số vốn của bạn',
	);
}

/** "dd/mm/yyyy" → thời điểm cuối ngày đó (giờ Việt Nam), sai định dạng trả 0. */
function hh_parse_vn_date( $text ) {
	if ( ! preg_match( '#(\d{1,2})[/.\-](\d{1,2})[/.\-](\d{4})#', (string) $text, $m ) || ! checkdate( (int) $m[2], (int) $m[1], (int) $m[3] ) ) {
		return 0;
	}
	$d = date_create( sprintf( '%04d-%02d-%02d 23:59:59', $m[3], $m[2], $m[1] ), new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );
	return $d ? $d->getTimestamp() : 0;
}

/** Các dòng ưu đãi tách từ ô "Chính sách & ưu đãi" (tối đa 3, mỗi dòng ≤ 140 ký tự). */
function hh_project_offer_lines( $post_id = null ) {
	$text  = preg_replace( '/^[^:\n]{0,45}:\s*/u', '', trim( (string) hh_meta( 'hh_p_policy', $post_id ) ) ); // Bỏ "Chính sách … :" ở đầu.
	$lines = array_values( array_filter( array_map( 'trim', preg_split( '/\R|;\s*|(?<=\.)\s+(?=\p{Lu})/u', $text ) ) ) );
	$lines = array_map( static fn( $l ) => mb_strtoupper( mb_substr( $l, 0, 1 ) ) . mb_substr( rtrim( $l, '.' ), 1 ), $lines );
	$lines = array_map( static fn( $l ) => mb_strlen( $l ) > 140 ? mb_substr( $l, 0, 137 ) . '…' : $l, array_slice( $lines, 0, 3 ) );
	return $lines;
}

/** Các trang bảng giá thị trường (slug loại nhà đất => [tên, mô tả, icon]). */
function hh_market_pages() {
	$boards = apply_filters( 'hh_market_boards', array() );
	$rows   = static fn( $k ) => isset( $boards[ $k ]['rows'] ) ? count( $boards[ $k ]['rows'] ) : 0;
	return array(
		'can-ho-chung-cu' => array( 'Căn hộ theo dự án', 'Giá bán lại, giá thuê từng dự án', 'building' ),
		'biet-thu'        => array( 'Biệt thự, villa ven biển', 'Giá villa các dự án Đà Nẵng – Hội An', 'star' ),
		'dat-nen'         => array( 'Đất lớn, đất xây khách sạn', $rows( 'dat-lon' ) ? 'Giá theo ' . $rows( 'dat-lon' ) . ' tuyến đường' : 'Giá theo tuyến đường', 'area' ),
		'khach-san'       => array( 'Khách sạn ven biển', $rows( 'khach-san' ) ? 'Giá theo ' . $rows( 'khach-san' ) . ' khu vực ven biển' : 'Giá theo khu vực ven biển', 'pin' ),
	);
}

/** Thẻ dẫn tới các trang bảng giá thị trường (trang Mua bán, trang chủ). */
function hh_market_cards( $current = '' ) {
	if ( ! function_exists( 'hh_deal_term_url' ) ) {
		return;
	}
	// CSS đi kèm ngay trong trang: vẫn hiển thị đúng khi plugin cache / gộp CSS còn giữ bản main.css cũ.
	static $styled = false;
	if ( ! $styled ) {
		$styled = true;
		echo '<style id="hh-market-cards">.market-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,230px),1fr));gap:12px}.market-card{display:flex;align-items:center;gap:12px;padding:16px;border:1px solid #e2e7ef;border-radius:16px;background:#fff;color:#14223a;box-shadow:0 10px 30px rgba(10,35,66,.08);text-decoration:none;transition:transform .2s,border-color .2s}.market-card:hover{transform:translateY(-2px);border-color:#ea580c}.market-card__icon{display:grid;place-items:center;flex:none;width:46px;height:46px;border-radius:12px;background:#0a2342;color:#ffb627}.market-card__body{display:grid;gap:2px;flex:1;min-width:0}.market-card__body strong{color:#0a2342;font-size:1rem}.market-card__body small{color:#7a869a;font-size:.84rem}.market-card>.icon--arrow{flex:none;color:#ea580c}.market-card.is-active{border-color:#0a2342;background:#0a2342}.market-card.is-active strong{color:#fff}.market-card.is-active small{color:#c4d0e0}.market-card.is-active .market-card__icon{background:#ea580c;color:#fff}.market-cards__title{margin:22px 0 10px;font-weight:700;color:#0a2342}</style>'; // phpcs:ignore
	}
	echo '<div class="market-cards">';
	foreach ( hh_market_pages() as $slug => list( $name, $desc, $icon ) ) {
		$term = get_term_by( 'slug', $slug, 'loai-bds' );
		if ( ! $term ) {
			continue;
		}
		printf(
			'<a class="market-card%s" href="%s"><span class="market-card__icon">%s</span><span class="market-card__body"><strong>%s</strong><small>%s</small></span>%s</a>',
			$current === $slug ? ' is-active' : '',
			esc_url( hh_deal_term_url( 'ban', $term ) ),
			hh_icon( $icon ), // phpcs:ignore
			esc_html( $name ),
			esc_html( $desc ),
			hh_icon( 'arrow' ) // phpcs:ignore
		);
	}
	echo '</div>';
}

/**
 * Trang trụ cột (pillar) theo từ khóa chính: tiêu đề H1 / title cho trang Dự án và các loại dự án.
 * VD: /loai-du-an/cao-tang/ → "Căn hộ Đà Nẵng – các dự án đang mở bán 2026".
 */
function hh_pillar_heading( $term = null ) {
	$year = wp_date( 'Y' );
	if ( ! $term ) {
		return 'Dự án bất động sản Đà Nẵng ' . $year;
	}
	$map = array(
		'cao-tang'              => 'Căn hộ Đà Nẵng – các dự án đang mở bán ' . $year,
		'can-ho-so-huu-lau-dai' => 'Căn hộ sở hữu lâu dài Đà Nẵng ' . $year,
		'can-ho-dich-vu'        => 'Căn hộ dịch vụ, condotel Đà Nẵng ' . $year,
		'thap-tang'             => 'Biệt thự, nhà phố, đất nền Đà Nẵng ' . $year,
		'biet-thu'              => 'Biệt thự nghỉ dưỡng Đà Nẵng – Hội An ' . $year,
		'dat-nen'               => 'Dự án đất nền Đà Nẵng ' . $year,
		'shophouse'             => 'Nhà phố, shophouse Đà Nẵng ' . $year,
		'to-hop'                => 'Tổ hợp dự án bất động sản Đà Nẵng ' . $year,
	);
	return $map[ $term->slug ] ?? 'Dự án ' . mb_strtolower( $term->name ) . ' Đà Nẵng ' . $year;
}

/**
 * Cụm chủ đề cho bài viết: link về trang dự án (trang chính), tổ hợp, bài cùng dự án, trang trụ cột, khu vực, liên hệ.
 * Returns [[label, url], ...].
 */
function hh_post_cluster_links( $post_id ) {
	$links   = array();
	$project = (int) get_post_meta( $post_id, 'hh_post_project', true );
	if ( $project && 'publish' === get_post_status( $project ) ) {
		$name    = get_the_title( $project );
		$links[] = array( $name . ' – tổng quan, giá bán, mặt bằng, chính sách', get_permalink( $project ) );
		$parent  = (int) get_post_meta( $project, 'hh_p_parent', true );
		if ( $parent && 'publish' === get_post_status( $parent ) ) {
			$links[] = array( get_the_title( $parent ) . ' – toàn bộ phân khu', get_permalink( $parent ) );
		}
		$siblings = get_posts( array( 'post_type' => 'post', 'numberposts' => 4, 'post__not_in' => array( $post_id ), 'meta_key' => 'hh_post_project', 'meta_value' => $project ) ); // phpcs:ignore
		foreach ( $siblings as $p ) {
			$links[] = array( get_the_title( $p ), get_permalink( $p ) );
		}
		$types = get_the_terms( $project, 'loai-du-an' ) ?: array();
		foreach ( $types as $t ) {
			$top     = $t->parent ? get_term( $t->parent, 'loai-du-an' ) : $t;
			$links[] = array( hh_pillar_heading( $top ), get_term_link( $top ) );
			break;
		}
		$areas = get_the_terms( $project, 'khu-vuc' ) ?: array();
		if ( $areas ) {
			$links[] = array( 'Dự án, nhà đất ' . $areas[0]->name, get_term_link( $areas[0] ) );
		}
	} else {
		$cao = get_term_by( 'slug', 'cao-tang', 'loai-du-an' );
		$links[] = array( hh_pillar_heading(), get_post_type_archive_link( 'du-an' ) );
		if ( $cao ) {
			$links[] = array( hh_pillar_heading( $cao ), get_term_link( $cao ) );
		}
		if ( function_exists( 'hh_deal_url' ) ) {
			$links[] = array( 'Mua bán nhà đất Đà Nẵng – bảng giá thị trường', hh_deal_url( 'ban' ) );
		}
	}
	$links[] = array( 'Liên hệ ' . hoanghiep_opt( 'hh_person_name' ) . ' – tư vấn, nhận bảng giá', home_url( '/lien-he/' ) );
	return array_values( array_filter( $links, static fn( $l ) => $l[1] && ! is_wp_error( $l[1] ) ) );
}

/** Phân khu / tòa con chưa có ảnh đại diện: dùng ảnh của dự án mẹ. */
add_filter(
	'post_thumbnail_id',
	static function ( $thumb_id, $post ) {
		if ( $thumb_id || ! $post || 'du-an' !== get_post_type( $post ) ) {
			return $thumb_id;
		}
		$parent = (int) get_post_meta( is_object( $post ) ? $post->ID : (int) $post, 'hh_p_parent', true );
		return $parent ? (int) get_post_thumbnail_id( $parent ) : $thumb_id;
	},
	10,
	2
);

/**
 * Thẻ "Vốn tự có theo loại căn" (ô Vốn tự có theo loại căn – tab Giá & chính sách): mỗi loại căn một thẻ,
 * số vốn lớn, nút nhận căn chi tiết qua Zalo. Dùng trong mục Chính sách và shortcode [hh_von_tu_co] trong bài.
 */
function hoanghiep_capital_cards( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$rows    = hh_table( 'hh_p_capital_table', 4, $post_id );
	if ( ! $rows ) {
		return '';
	}
	$title = get_the_title( $post_id );
	$zalo  = 'https://zalo.me/' . hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) );
	ob_start();
	?>
	<div class="capital">
		<p class="capital__title"><?php echo esc_html( hh_meta( 'hh_p_capital_title', $post_id ) ?: 'Vốn tự có theo loại căn – ' . $title ); ?></p>
		<div class="capital__grid">
			<?php foreach ( $rows as list( $type, $price, $own, $note ) ) : ?>
				<div class="capital__item">
					<p class="capital__type"><?php echo esc_html( $type ); ?></p>
					<p class="capital__own"><?php echo esc_html( $own ); ?></p>
					<p class="capital__price"><?php echo esc_html( $price ); ?></p>
					<?php if ( $note ) : ?><p class="capital__note"><?php echo esc_html( $note ); ?></p><?php endif; ?>
					<a class="btn btn--zalo btn--sm" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Nhận căn qua Zalo</a>
				</div>
			<?php endforeach; ?>
		</div>
		<a class="btn btn--zalo capital__all" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Nhận căn chi tiết &amp; giá từng căn qua Zalo</a>
		<?php if ( hh_meta( 'hh_p_capital_note', $post_id ) ) : ?>
			<p class="capital__foot"><?php echo esc_html( hh_meta( 'hh_p_capital_note', $post_id ) ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hh_von_tu_co', static fn() => hoanghiep_capital_cards() );
