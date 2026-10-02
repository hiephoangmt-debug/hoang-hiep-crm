<?php
get_header();

$filters = array(
	'khu-vuc'  => 'Tất cả khu vực',
	'loai-bds' => 'Tất cả loại BĐS',
);
?>
<div class="page-head">
	<div class="container">
		<h1><?php echo is_tax() ? esc_html( single_term_title( '', false ) ) : 'Bất động sản'; ?></h1>
		<?php the_archive_description( '<div class="page-head__meta">', '</div>' ); ?>
	</div>
</div>

<div class="container section">
	<form class="filters" action="<?php echo esc_url( get_post_type_archive_link( 'bat-dong-san' ) ); ?>" method="get">
		<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Từ khóa…" aria-label="Từ khóa">
		<input type="hidden" name="post_type" value="bat-dong-san">
		<?php foreach ( $filters as $taxonomy => $all_label ) : ?>
			<?php
			$terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => true ) );
			if ( ! $terms || is_wp_error( $terms ) ) {
				continue;
			}
			$current = get_query_var( $taxonomy );
			?>
			<select name="<?php echo esc_attr( $taxonomy ); ?>" aria-label="<?php echo esc_attr( $all_label ); ?>">
				<option value=""><?php echo esc_html( $all_label ); ?></option>
				<?php foreach ( $terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php endforeach; ?>
		<button class="btn btn--primary" type="submit">Lọc</button>
	</form>

	<?php if ( have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/property-card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p class="muted">Không tìm thấy bất động sản phù hợp. Hãy để lại thông tin để được tư vấn nguồn hàng mới nhất.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
