<?php
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-head">
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<p class="page-head__meta"><?php echo esc_html( get_the_date() ); ?> · <?php the_category( ', ' ); ?></p>
		</div>
	</div>
	<div class="container layout">
		<article class="layout__main entry-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="property-cover"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<?php the_content(); ?>
		</article>
		<aside class="layout__side" id="lien-he">
			<div class="sticky">
				<?php echo function_exists( 'hh_lead_form' ) ? hh_lead_form() : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</aside>
	</div>
	<?php
endwhile;

get_footer();
