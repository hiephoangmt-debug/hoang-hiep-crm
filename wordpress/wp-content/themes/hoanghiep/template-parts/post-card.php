<article <?php post_class( 'card' ); ?>>
	<a class="card__media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="card__placeholder">📰</span>
		<?php endif; ?>
	</a>
	<div class="card__body">
		<p class="card__meta"><?php echo esc_html( get_the_date() ); ?></p>
		<h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
	</div>
</article>
