<?php
get_header();

$deal   = get_query_var( 'hh_deal' );
$deal   = in_array( $deal, array( 'ban', 'thue' ), true ) ? $deal : '';
$action = $deal ? hh_deal_url( $deal ) : get_post_type_archive_link( 'bat-dong-san' );
$landing = hh_current_deal_term();
$cur    = static function ( $k ) use ( $landing ) {
	$v = sanitize_text_field( (string) get_query_var( $k ) );
	if ( '' === $v && $landing && $landing->taxonomy === $k ) {
		$v = $landing->slug;
	}
	return $v;
};
$stats  = hh_listing_stats();
$place  = $landing && 'khu-vuc' === $landing->taxonomy ? $landing->name . ', Đà Nẵng' : 'Đà Nẵng';
$what   = hh_lcfirst( hh_listing_archive_title() );

$selects = array(
	'khu-vuc'  => array( 'Khu vực', wp_list_pluck( get_terms( array( 'taxonomy' => 'khu-vuc', 'hide_empty' => false ) ) ?: array(), 'name', 'slug' ) ),
	'loai-bds' => array( 'Loại nhà đất', wp_list_pluck( get_terms( array( 'taxonomy' => 'loai-bds', 'hide_empty' => false ) ) ?: array(), 'name', 'slug' ) ),
	'gia'      => array( 'Mức giá', $deal ? hh_price_ranges( $deal ) : array() ),
	'dt'       => array( 'Diện tích', hh_area_ranges() ),
	'pn'       => array( 'Phòng ngủ', array( '1' => '1 phòng', '2' => '2 phòng', '3' => '3 phòng', '4' => '4+ phòng' ) ),
	'huong'    => array( 'Hướng nhà', array_slice( HH_DIRECTIONS, 1, null, true ) ),
);

global $wp_query;
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
			<?php if ( $deal && $landing ) : ?>
				<a href="<?php echo esc_url( hh_deal_url( $deal ) ); ?>"><?php echo 'ban' === $deal ? 'Mua bán' : 'Cho thuê'; ?></a> / <?php echo esc_html( $landing->name ); ?>
			<?php else : ?>
				<?php echo esc_html( hh_listing_archive_title() ); ?>
			<?php endif; ?>
		</p>
		<h1 class="page-head__title"><?php echo esc_html( hh_listing_archive_title() ); ?></h1>
		<p class="page-head__lead">
			<?php if ( $stats['count'] ) : ?>
				Hiện có <strong><?php echo (int) $stats['count']; ?></strong> tin <?php echo esc_html( 'thue' === $deal ? 'cho thuê' : ( 'ban' === $deal ? 'bán' : 'nhà đất' ) ); ?> tại <?php echo esc_html( $place ); ?><?php if ( $stats['min'] ) : ?>, giá <strong><?php echo esc_html( hh_price_range( $stats['min'], $stats['max'], 'thue' === $deal ) ); ?></strong><?php endif; ?>. Thông tin được <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?> kiểm tra pháp lý và cập nhật ngày <?php echo esc_html( wp_date( 'd/m/Y', $stats['latest'] ?: time() ) ); ?>.
			<?php else : ?>
				Hiện chưa có tin phù hợp tại <?php echo esc_html( $place ); ?>. Để lại nhu cầu, Hiệp sẽ gửi sản phẩm mới nhất cho bạn.
			<?php endif; ?>
		</p>
		<style>@media (max-width: 600px) { .search-box { padding: 6px 14px 16px; } .search-box__tabs { overflow-x: auto; scrollbar-width: none; } .search-box__tabs::-webkit-scrollbar { display: none; } .search-box__tab { flex: 1 0 auto; padding: 12px 8px; font-size: .95rem; } }</style>
		<div class="page-search" style="margin-top:22px">
			<?php
			hh_search_box(
				array(
					'active' => $deal ?: 'all',
					'links'  => true,
					'all'    => true,
					'action' => $action,
					'values' => array(
						'tk'       => $cur( 'tk' ),
						'khu-vuc'  => $cur( 'khu-vuc' ),
						'loai-bds' => $cur( 'loai-bds' ),
					),
					'hidden' => array( 'duan' => $cur( 'duan' ) ),
				)
			);
			?>
		</div>
		<?php if ( $cur( 'tk' ) ) : ?>
			<p class="quick-search__state">Kết quả cho “<?php echo esc_html( $cur( 'tk' ) ); ?>” · <a href="<?php echo esc_url( $action ); ?>">Xoá tìm kiếm</a></p>
		<?php endif; ?>
		<?php if ( 'ban' === $deal ) : ?>
			<p class="market-cards__title">Bảng giá thị trường Đà Nẵng</p>
			<?php hh_market_cards( $landing ? $landing->slug : '' ); ?>
		<?php endif; ?>
	</div>
</div>

<div class="container section listing-page">
	<div class="layout__main">
		<div class="results-bar">
			<p><strong><?php echo (int) $wp_query->found_posts; ?></strong> tin phù hợp</p>
			<form method="get" action="<?php echo esc_url( $action ); ?>" data-autosubmit>
				<?php foreach ( array_merge( array( 'tk', 'duan' ), array_keys( $selects ) ) as $keep ) : ?>
					<?php if ( $cur( $keep ) ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $keep ); ?>" value="<?php echo esc_attr( $cur( $keep ) ); ?>">
					<?php endif; ?>
				<?php endforeach; ?>
				<label>Sắp xếp
					<select name="sx">
						<?php foreach ( hh_sort_options() as $value => $text ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $cur( 'sx' ), $value ); ?>><?php echo esc_html( $text ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</form>
		</div>

		<?php
		// Đất lớn, khách sạn: bảng giá thị trường lên trước danh sách tin.
		if ( 'ban' === $deal && $landing && function_exists( 'hh_market_board' ) && hh_market_board( $landing->slug ) ) {
			get_template_part( 'template-parts/market-board', null, array( 'board' => hh_market_board( $landing->slug ), 'what' => $landing->name ) );
		}
		?>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/listing-card' );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
		<?php else : ?>
			<div class="empty">
				<p><strong>Chưa có tin phù hợp với bộ lọc.</strong></p>
				<p>Để lại nhu cầu, Hiệp sẽ tìm và gửi sản phẩm phù hợp cho bạn.</p>
				<a class="btn btn--gold" href="#lien-he">Gửi nhu cầu</a>
			</div>
		<?php endif; ?>

		<?php
		// Trang Mua bán biệt thự: bảng giá thị trường các dự án biệt thự (chủ đầu tư + chuyển nhượng).
		if ( 'ban' === $deal && $landing && 'biet-thu' === $landing->slug ) {
			get_template_part( 'template-parts/project-price-board', null, array( 'type' => 'biet-thu', 'title' => 'Giá biệt thự Đà Nẵng – Hội An theo dự án' ) );
		} elseif ( $deal && ( ! $landing || 'khu-vuc' === $landing->taxonomy || in_array( $landing->slug, array( 'can-ho-chung-cu', 'can-ho-dich-vu', 'penthouse', 'duplex' ), true ) ) ) {
			// Mua bán / Cho thuê căn hộ: bảng giá thị trường theo dự án (lọc theo khu vực khi ở trang khu vực).
			$where = $landing && 'khu-vuc' === $landing->taxonomy ? $landing->name : 'Đà Nẵng';
			get_template_part(
				'template-parts/project-price-board',
				null,
				array(
					'type'  => array( 'can-ho-so-huu-lau-dai', 'can-ho-dich-vu' ),
					'deal'  => $deal,
					'area'  => $landing && 'khu-vuc' === $landing->taxonomy ? $landing->slug : '',
					'title' => ( 'thue' === $deal ? 'Giá thuê căn hộ ' : 'Giá bán căn hộ ' ) . $where . ' theo dự án',
				)
			);
		}
		?>


		<?php
		// Liên kết nội bộ tới các trang đích (chuẩn SEO) cùng hình thức.
		if ( $deal ) :
			foreach ( array( 'khu-vuc' => 'Theo khu vực', 'loai-bds' => 'Theo loại nhà đất' ) as $tax => $heading ) :
				$links = hh_deal_landing_terms( $deal, $tax );
				if ( ! $links ) {
					continue;
				}
				?>
				<nav class="seo-links" aria-label="<?php echo esc_attr( $heading ); ?>">
					<p class="seo-links__title"><?php echo esc_html( ( 'ban' === $deal ? 'Nhà đất bán ' : 'Cho thuê ' ) . mb_strtolower( $heading ) ); ?></p>
					<?php foreach ( $links as list( $t, $count ) ) : ?>
						<a class="<?php echo $landing && $landing->term_id === $t->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( hh_deal_term_url( $deal, $t ) ); ?>"><?php echo esc_html( ( 'khu-vuc' === $tax ? '' : ( 'ban' === $deal ? 'Bán ' : 'Thuê ' ) ) . ( 'khu-vuc' === $tax ? $t->name : mb_strtolower( $t->name ) ) ); ?> <span><?php echo (int) $count; ?></span></a>
					<?php endforeach; ?>
				</nav>
				<?php
			endforeach;
		endif;

		$faq = hh_listing_faq( $stats, $deal, $place, $what );
		if ( $faq ) :
			?>
			<section class="block faq-block">
				<h2 class="block__title">Câu hỏi thường gặp về <?php echo esc_html( $what ); ?></h2>
				<div class="faq">
					<?php foreach ( $faq as list( $q, $a ) ) : ?>
						<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
	</div>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
