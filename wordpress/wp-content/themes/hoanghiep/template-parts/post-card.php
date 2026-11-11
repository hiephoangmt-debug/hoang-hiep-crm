<article <?php post_class( 'post-card' ); ?>>
	<a class="post-card__media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 400px' ) ); // Ảnh bìa 1200×630 có chữ: không cắt khung (bản hh-card 3:2 làm mất chữ hai bên). ?>
		<?php else : ?>
			<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
		<?php endif; ?>
	</a>
	<div class="post-card__body">
		<?php $cat = get_the_category(); ?>
		<?php if ( $cat ) : ?>
			<span class="post-card__cat"><?php echo esc_html( $cat[0]->name ); ?></span>
		<?php endif; ?>
		<p class="post-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?> · <?php echo esc_html( hh_reading_time() ); ?></p>
		<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
	</div>
</article>
