<article <?php post_class( 'post-card' ); ?>>
	<a class="post-card__media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
		<?php endif; ?>
	</a>
	<div class="post-card__body">
		<p class="post-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
		<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
	</div>
</article>
