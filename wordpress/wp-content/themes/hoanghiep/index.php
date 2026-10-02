<?php
get_header();

if ( is_search() ) {
	$heading = sprintf( 'Kết quả tìm kiếm: “%s”', get_search_query() );
} elseif ( is_archive() ) {
	$heading = wp_strip_all_tags( get_the_archive_title() );
} elseif ( is_home() && get_option( 'page_for_posts' ) ) {
	$heading = get_the_title( get_option( 'page_for_posts' ) );
} else {
	$heading = 'Tin tức';
}
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <?php echo esc_html( $heading ); ?></p>
		<h1 class="page-head__title"><?php echo esc_html( $heading ); ?></h1>
	</div>
</div>

<div class="container section">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid--3">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p class="empty">Chưa có nội dung.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
