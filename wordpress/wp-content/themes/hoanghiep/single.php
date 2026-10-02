<?php
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-head">
		<div class="container narrow-left">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <?php the_category( ', ' ); ?></p>
			<h1 class="page-head__title"><?php the_title(); ?></h1>
			<p class="page-head__lead"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
		</div>
	</div>
	<div class="container layout">
		<article class="layout__main entry-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="cover"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>
			<?php the_content(); ?>
		</article>
		<aside class="layout__side">
			<div class="sticky" id="lien-he">
				<?php hh_agent_card( true ); ?>
				<?php echo hh_lead_form(); // phpcs:ignore ?>
			</div>
		</aside>
	</div>
	<?php
endwhile;

get_footer();
