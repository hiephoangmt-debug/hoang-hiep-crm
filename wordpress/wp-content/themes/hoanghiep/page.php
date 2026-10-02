<?php
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-head">
		<div class="container">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <?php the_title(); ?></p>
			<h1 class="page-head__title"><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="container section narrow entry-content" id="lien-he">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
