<?php
$status = hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status' ) );
$areas  = get_the_terms( get_the_ID(), 'khu-vuc' );
$place  = $areas && ! is_wp_error( $areas ) ? $areas[0]->name : hh_meta( 'hh_p_address' );
$type   = hh_project_type();
?>
<article class="project-card">
	<a class="project-card__media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="media-placeholder"><?php echo hh_icon( 'building' ); // phpcs:ignore ?></span>
		<?php endif; ?>
		<?php hh_pill( $status, hh_meta( 'hh_p_status' ) ); ?>
		<?php if ( hh_is_hot() ) : ?><span class="hot-badge">HOT</span><?php endif; ?>
		<?php if ( $type ) : ?>
			<span class="project-card__type"><?php echo esc_html( hh_project_types_label() ); ?></span>
		<?php endif; ?>
	</a>
	<div class="project-card__body">
		<?php if ( hh_meta( 'hh_p_developer' ) ) : ?>
			<p class="project-card__dev"><?php echo esc_html( hh_meta( 'hh_p_developer' ) ); ?></p>
		<?php endif; ?>
		<h3 class="project-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( (int) hh_meta( 'hh_p_parent' ) ) : ?>
			<p class="project-card__parent"><?php echo esc_html( hh_parent_label( (int) hh_meta( 'hh_p_parent' ) ) . ' ' . get_the_title( (int) hh_meta( 'hh_p_parent' ) ) ); ?></p>
		<?php endif; ?>
		<?php $parts = has_term( 'to-hop', 'loai-du-an' ) ? count( hh_project_children() ) : 0; ?>
		<?php if ( $parts ) : ?>
			<p class="project-card__parent">Gồm <?php echo (int) $parts; ?> dự án thành phần</p>
		<?php endif; ?>
		<?php if ( $place ) : ?>
			<p class="meta-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( $place ); ?></p>
		<?php endif; ?>
		<?php
		$extras = array();
		foreach ( HH_SPECIAL_PRODUCTS as $key => $label ) {
			if ( hh_meta( "hh_p_{$key}_table" ) || hh_meta( "hh_p_{$key}_desc" ) ) {
				$extras[] = $label;
			}
		}
		?>
		<?php if ( $extras ) : ?>
			<p class="project-card__extras">Có <?php echo esc_html( implode( ' · ', $extras ) ); ?></p>
		<?php endif; ?>
		<ul class="project-card__facts">
			<?php if ( hh_meta( 'hh_p_scale' ) ) : ?><li><span>Quy mô</span><?php echo esc_html( trim( preg_replace( '/\s*\(.*$/u', '', hh_meta( 'hh_p_scale' ) ) ) ); ?></li><?php endif; ?>
			<?php if ( hh_meta( 'hh_p_unit_area' ) ) : ?><li><span>Diện tích</span><?php echo esc_html( hh_meta( 'hh_p_unit_area' ) ); ?></li><?php endif; ?>
			<?php if ( hh_meta( 'hh_p_handover' ) ) : ?><li><span>Bàn giao</span><?php echo esc_html( hh_meta( 'hh_p_handover' ) ); ?></li><?php endif; ?>
		</ul>
		<div class="project-card__foot">
			<p class="price"><?php echo esc_html( hh_project_price() ); ?></p>
			<a class="link-arrow" href="<?php the_permalink(); ?>">Chi tiết <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</article>
