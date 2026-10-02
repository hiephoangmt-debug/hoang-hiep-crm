<?php
// Chooses the right card for the current post in mixed loops.
$map = array(
	'du-an'        => 'template-parts/project-card',
	'bat-dong-san' => 'template-parts/listing-card',
);
get_template_part( $map[ get_post_type() ] ?? 'template-parts/post-card' );
