<?php
get_header();

while ( have_posts() ) :
	the_post();
	$meta  = function_exists( 'hh_property_meta' ) ? hh_property_meta() : array();
	$facts = array(
		'Giá'        => $meta['hh_price'] ?? '',
		'Diện tích'  => ! empty( $meta['hh_area'] ) ? $meta['hh_area'] . ' m²' : '',
		'Phòng ngủ'  => $meta['hh_bedrooms'] ?? '',
		'Pháp lý'    => $meta['hh_legal'] ?? '',
		'Địa chỉ'    => $meta['hh_address'] ?? '',
		'Trạng thái' => $meta['status_label'] ?? '',
	);
	?>
	<div class="page-head">
		<div class="container">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'bat-dong-san' ) ); ?>">Bất động sản</a></p>
			<h1><?php the_title(); ?></h1>
			<?php echo get_the_term_list( get_the_ID(), 'khu-vuc', '<p class="page-head__meta">📍 ', ', ', '</p>' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>

	<div class="container layout">
		<article class="layout__main">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="property-cover"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<ul class="property-facts">
				<?php foreach ( $facts as $label => $value ) : ?>
					<?php if ( $value ) : ?>
						<li><span><?php echo esc_html( $label ); ?></span><strong><?php echo esc_html( $value ); ?></strong></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>

			<div class="entry-content"><?php the_content(); ?></div>
		</article>

		<aside class="layout__side" id="lien-he">
			<div class="sticky">
				<p class="side-price"><?php echo esc_html( ( $meta['hh_price'] ?? '' ) ?: 'Giá: Liên hệ' ); ?></p>
				<a class="btn btn--primary btn--block" href="tel:<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_phone' ) ) ); ?>">📞 Gọi <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
				<?php echo function_exists( 'hh_lead_form' ) ? hh_lead_form( array( 'property_id' => get_the_ID(), 'title' => 'Đăng ký xem nhà' ) ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</aside>
	</div>

	<?php
	$related = new WP_Query(
		array(
			'post_type'      => 'bat-dong-san',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
		)
	);
	if ( $related->have_posts() ) :
		?>
		<section class="section section--alt">
			<div class="container">
				<h2 class="section__title">Bất động sản khác</h2>
				<div class="grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/property-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<?php
endwhile;

get_footer();
