<?php
/**
 * Trang Tin tức (danh sách bài viết) và trang chuyên mục.
 */
get_header();

$current_cat = is_category() ? get_queried_object() : null;
$news_url    = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
$cats        = array_filter( get_categories( array( 'hide_empty' => false, 'orderby' => 'term_id' ) ), fn( $c ) => 'uncategorized' !== $c->slug );
$title       = $current_cat ? $current_cat->name : 'Tin tức bất động sản Đà Nẵng';
$paged       = max( 1, (int) get_query_var( 'paged' ) );

global $wp_query;
$posts = $wp_query->posts;
$lead  = 1 === $paged ? array_slice( $posts, 0, 5 ) : array();
$rest  = 1 === $paged ? array_slice( $posts, 5 ) : $posts;
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( $news_url ); ?>">Tin tức</a><?php echo $current_cat ? ' / ' . esc_html( $current_cat->name ) : ''; ?></p>
		<h1 class="page-head__title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $current_cat && $current_cat->description ) : ?>
			<p class="page-head__lead"><?php echo esc_html( $current_cat->description ); ?></p>
		<?php else : ?>
			<p class="page-head__lead">Thị trường, tin dự án, kinh nghiệm mua bán và pháp lý nhà đất Đà Nẵng – cập nhật bởi <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?>.</p>
		<?php endif; ?>
		<?php if ( $cats ) : ?>
			<nav class="deal-tabs" aria-label="Chuyên mục">
				<a class="<?php echo $current_cat ? '' : 'is-active'; ?>" href="<?php echo esc_url( $news_url ); ?>">Tất cả</a>
				<?php foreach ( $cats as $c ) : ?>
					<a class="<?php echo $current_cat && $current_cat->term_id === $c->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	</div>
</div>

<div class="container section">
	<?php if ( ! $posts ) : ?>
		<p class="empty">Chuyên mục đang được cập nhật.</p>
	<?php endif; ?>

	<?php if ( $lead ) : ?>
		<div class="news-layout news-layout--page">
			<?php
			global $post;
			foreach ( $lead as $i => $post ) :
				setup_postdata( $post );
				if ( 0 === $i ) :
					?>
					<article class="news-lead">
						<a class="news-lead__media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large' ); ?>
							<?php else : ?>
								<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
							<?php endif; ?>
						</a>
						<div class="news-lead__body">
							<p class="post-card__date"><?php echo esc_html( hh_post_meta_line() ); ?></p>
							<h2 class="news-lead__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
					</article>
					<ul class="news-list">
				<?php else : ?>
					<li>
						<a class="news-list__media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							<?php else : ?>
								<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
							<?php endif; ?>
						</a>
						<div>
							<p class="post-card__date"><?php echo esc_html( hh_post_meta_line() ); ?></p>
							<a class="news-list__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
					</li>
					<?php
				endif;
			endforeach;
			wp_reset_postdata();
			?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ( $rest ) : ?>
		<?php if ( $lead ) : ?>
			<h2 class="news-more">Bài viết khác</h2>
		<?php endif; ?>
		<div class="grid grid--3">
			<?php
			foreach ( $rest as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/post-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	<?php endif; ?>

	<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
