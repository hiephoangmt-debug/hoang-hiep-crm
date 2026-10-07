<?php
// Loại dự án dùng giao diện danh sách dự án.
if ( is_tax( 'loai-du-an' ) ) {
	require get_theme_file_path( 'archive-du-an.php' );
	return;
}

// Loại nhà đất dùng giao diện danh sách nhà đất có bộ lọc.
if ( is_tax( 'loai-bds' ) ) {
	require get_theme_file_path( 'archive-bat-dong-san.php' );
	return;
}

// Khu vực: các dự án trong khu vực (tin mua bán / cho thuê theo khu vực ở /mua-ban/{x}/, /cho-thue/{x}/).
get_header();
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / Khu vực</p>
		<h1 class="page-head__title"><?php single_term_title(); ?></h1>
		<?php the_archive_description( '<div class="page-head__lead">', '</div>' ); ?>
		<?php if ( function_exists( 'hh_deal_term_url' ) ) : ?>
			<p class="page-head__links">Nhà đất <?php echo esc_html( single_term_title( '', false ) ); ?>: <a href="<?php echo esc_url( hh_deal_term_url( 'ban', get_queried_object() ) ); ?>">tin mua bán</a> · <a href="<?php echo esc_url( hh_deal_term_url( 'thue', get_queried_object() ) ); ?>">tin cho thuê</a></p>
		<?php endif; ?>
	</div>
</div>
<div class="container section">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid--3">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p class="empty">Chưa có dự án trong khu vực này.</p>
	<?php endif; ?>
</div>
<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
