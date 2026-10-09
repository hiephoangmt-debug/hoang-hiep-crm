<?php
$schema = hh_listing_schema();
$deal   = hh_meta( 'hh_deal' ) ?: 'ban';
$status = hh_meta( 'hh_status' );
$areas  = get_the_terms( get_the_ID(), 'khu-vuc' );
$place  = $areas && ! is_wp_error( $areas ) ? $areas[0]->name : hh_meta( 'hh_address' );
$photos = count( hh_ids( 'hh_gallery' ) ) + ( has_post_thumbnail() ? 1 : 0 );
?>
<article class="listing-card<?php echo 'da-giao-dich' === $status ? ' is-closed' : ''; ?>">
	<a class="listing-card__media" href="<?php the_permalink(); ?>">
		<?php $proj_thumb = has_post_thumbnail() ? 0 : get_post_thumbnail_id( (int) hh_meta( 'hh_project' ) ); ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy' ) ); ?>
		<?php elseif ( $proj_thumb ) : ?>
			<?php echo wp_get_attachment_image( $proj_thumb, 'hh-card', false, array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
		<?php else : ?>
			<span class="media-placeholder"><?php echo hh_icon( 'building' ); // phpcs:ignore ?></span>
		<?php endif; ?>
		<?php hh_pill( 'thue' === $deal ? 'Cho thuê' : 'Bán', $deal ); ?>
		<?php if ( $status && 'con-hang' !== $status ) : ?>
			<?php hh_pill( hh_option_label( $schema, 'hh_status', $status ), $status ); ?>
		<?php endif; ?>
		<?php if ( hh_is_hot() && 'da-giao-dich' !== $status ) : ?><span class="hot-badge hot-badge--left notranslate" translate="no">HOT</span><?php endif; ?>
		<?php if ( $photos > 1 ) : ?>
			<span class="listing-card__count"><?php echo (int) $photos; ?> ảnh</span>
		<?php endif; ?>
	</a>
	<div class="listing-card__body">
		<h3 class="listing-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="listing-card__price">
			<strong><?php echo esc_html( hh_listing_price() ); ?></strong>
			<?php if ( hh_listing_price_m2() ) : ?><span><?php echo esc_html( hh_listing_price_m2() ); ?></span><?php endif; ?>
		</p>
		<ul class="listing-card__facts">
			<?php if ( hh_meta( 'hh_area' ) ) : ?><li><?php echo hh_icon( 'area' ); // phpcs:ignore ?><?php echo esc_html( hh_meta( 'hh_area' ) ); ?> m²</li><?php endif; ?>
			<?php if ( hh_meta( 'hh_bedrooms' ) ) : ?><li><?php echo hh_icon( 'bed' ); // phpcs:ignore ?><?php echo esc_html( hh_meta( 'hh_bedrooms' ) ); ?> PN</li><?php endif; ?>
			<?php if ( hh_meta( 'hh_bathrooms' ) ) : ?><li><?php echo hh_icon( 'bath' ); // phpcs:ignore ?><?php echo esc_html( hh_meta( 'hh_bathrooms' ) ); ?> WC</li><?php endif; ?>
			<?php if ( hh_meta( 'hh_direction' ) ) : ?><li><?php echo hh_icon( 'compass' ); // phpcs:ignore ?><?php echo esc_html( hh_option_label( $schema, 'hh_direction', hh_meta( 'hh_direction' ) ) ); ?></li><?php endif; ?>
		</ul>
		<?php if ( $place ) : ?>
			<p class="meta-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( $place ); ?></p>
		<?php endif; ?>
		<p class="listing-card__foot"><span><?php echo esc_html( hh_listing_code() ); ?></span><span><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span></p>
	</div>
</article>
