<?php
$meta  = function_exists( 'hh_property_meta' ) ? hh_property_meta() : array();
$areas = get_the_terms( get_the_ID(), 'khu-vuc' );
?>
<article class="card">
	<a class="card__media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="card__placeholder">🏠</span>
		<?php endif; ?>
		<?php if ( ! empty( $meta['status_label'] ) ) : ?>
			<span class="badge badge--<?php echo esc_attr( $meta['hh_status'] ); ?>"><?php echo esc_html( $meta['status_label'] ); ?></span>
		<?php endif; ?>
	</a>
	<div class="card__body">
		<h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $areas && ! is_wp_error( $areas ) ) : ?>
			<p class="card__location">📍 <?php echo esc_html( $areas[0]->name ); ?></p>
		<?php elseif ( ! empty( $meta['hh_address'] ) ) : ?>
			<p class="card__location">📍 <?php echo esc_html( $meta['hh_address'] ); ?></p>
		<?php endif; ?>
		<ul class="card__facts">
			<?php if ( ! empty( $meta['hh_area'] ) ) : ?>
				<li>📐 <?php echo esc_html( $meta['hh_area'] ); ?> m²</li>
			<?php endif; ?>
			<?php if ( ! empty( $meta['hh_bedrooms'] ) ) : ?>
				<li>🛏 <?php echo esc_html( $meta['hh_bedrooms'] ); ?> PN</li>
			<?php endif; ?>
		</ul>
		<p class="card__price"><?php echo esc_html( ( $meta['hh_price'] ?? '' ) ?: 'Liên hệ' ); ?></p>
	</div>
</article>
