<?php
get_header();

$deal   = get_query_var( 'hh_deal' );
$deal   = in_array( $deal, array( 'ban', 'thue' ), true ) ? $deal : '';
$action = $deal ? hh_deal_url( $deal ) : get_post_type_archive_link( 'bat-dong-san' );
$cur    = static fn( $k ) => sanitize_text_field( (string) get_query_var( $k ) );

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
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <?php echo esc_html( hh_listing_archive_title() ); ?></p>
		<h1 class="page-head__title"><?php echo esc_html( hh_listing_archive_title() ); ?></h1>
		<nav class="deal-tabs" aria-label="Hình thức">
			<a class="<?php echo '' === $deal ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'bat-dong-san' ) ); ?>">Tất cả</a>
			<a class="<?php echo 'ban' === $deal ? 'is-active' : ''; ?>" href="<?php echo esc_url( hh_deal_url( 'ban' ) ); ?>">Mua bán</a>
			<a class="<?php echo 'thue' === $deal ? 'is-active' : ''; ?>" href="<?php echo esc_url( hh_deal_url( 'thue' ) ); ?>">Cho thuê</a>
		</nav>
	</div>
</div>

<div class="container layout layout--filters">
	<aside class="layout__side layout__side--left">
		<form class="filter-panel" action="<?php echo esc_url( $action ); ?>" method="get">
			<p class="filter-panel__title">Lọc kết quả</p>
			<label class="filter-panel__field">
				<span>Từ khóa</span>
				<input type="search" name="tk" value="<?php echo esc_attr( $cur( 'tk' ) ); ?>" placeholder="Tên đường, dự án…">
			</label>
			<?php foreach ( $selects as $name => list( $label, $options ) ) : ?>
				<?php if ( ! $options ) { continue; } ?>
				<label class="filter-panel__field">
					<span><?php echo esc_html( $label ); ?></span>
					<select name="<?php echo esc_attr( $name ); ?>">
						<option value="">Tất cả</option>
						<?php foreach ( $options as $value => $text ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $cur( $name ), (string) $value ); ?>><?php echo esc_html( $text ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endforeach; ?>
			<input type="hidden" name="sx" value="<?php echo esc_attr( $cur( 'sx' ) ); ?>">
			<button class="btn btn--gold btn--block" type="submit">Áp dụng</button>
			<a class="filter-panel__reset" href="<?php echo esc_url( $action ); ?>">Xoá bộ lọc</a>
		</form>
	</aside>

	<div class="layout__main">
		<div class="results-bar">
			<p><strong><?php echo (int) $wp_query->found_posts; ?></strong> tin phù hợp</p>
			<form method="get" action="<?php echo esc_url( $action ); ?>" data-autosubmit>
				<?php foreach ( array_merge( array( 'tk' ), array_keys( $selects ) ) as $keep ) : ?>
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
	</div>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
