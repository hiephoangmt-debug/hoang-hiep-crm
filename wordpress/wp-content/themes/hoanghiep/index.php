<?php
get_header();

if ( is_search() ) {
	/* translators: %s: search query */
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
	<div class="container"><h1><?php echo esc_html( $heading ); ?></h1></div>
</div>

<div class="container section">
	<?php if ( have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'bat-dong-san' === get_post_type() ? 'template-parts/property-card' : 'template-parts/post-card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p class="muted">Chưa có nội dung.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
