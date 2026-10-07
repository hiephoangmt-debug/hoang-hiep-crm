<?php
get_header();

while ( have_posts() ) :
	the_post();
	$id       = get_the_ID();
	$cats     = get_the_category();
	$news_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
	list( $content, $toc ) = hh_content_with_toc( apply_filters( 'the_content', get_the_content() ) );
	$share    = rawurlencode( get_permalink() );
	?>
	<div class="page-head page-head--article">
		<div class="container article-head">
			<p class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
				<a href="<?php echo esc_url( $news_url ); ?>">Tin tức</a>
				<?php if ( $cats ) : ?>/ <a href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a><?php endif; ?>
			</p>
			<?php if ( $cats ) : ?>
				<a class="pill pill--cat" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
			<?php endif; ?>
			<h1 class="article-head__title"><?php the_title(); ?></h1>
			<p class="article-head__meta">
				<img class="article-head__author" src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="40" height="40">
				<span><strong><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></strong> · <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time> · <?php echo esc_html( hh_reading_time() ); ?><?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) : ?> · Cập nhật <?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?><?php endif; ?></span>
			</p>
		</div>
	</div>

	<div class="container layout">
		<article class="layout__main article">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="article__cover"><?php the_post_thumbnail( 'large', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?></figure>
			<?php endif; ?>

			<?php if ( has_excerpt() ) : ?>
				<p class="article__sapo"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<?php if ( count( $toc ) >= 2 ) : ?>
				<nav class="toc" aria-label="Mục lục bài viết">
					<p class="toc__title">Nội dung bài viết</p>
					<ul>
						<?php foreach ( $toc as $item ) : ?>
							<li class="toc__l<?php echo (int) $item['level']; ?>"><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>

			<div class="entry-content"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput -- filtered post content. ?></div>

			<?php $tags = get_the_tags(); ?>
			<?php if ( $tags ) : ?>
				<p class="article__tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</p>
			<?php endif; ?>

			<?php $post_faq = hh_table( 'hh_post_faq', 2, $id ); ?>
			<?php if ( $post_faq && false === mb_strpos( $content, 'Câu hỏi thường gặp' ) ) : ?>
				<section class="faq-block">
					<h2>Câu hỏi thường gặp</h2>
					<div class="faq">
						<?php foreach ( $post_faq as list( $q, $a ) ) : ?>
							<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php $project_id = (int) get_post_meta( $id, 'hh_post_project', true ); ?>
			<?php if ( $project_id && 'publish' === get_post_status( $project_id ) ) : ?>
				<div class="related-project">
					<p class="related-project__title">Dự án trong bài viết</p>
					<?php
					$GLOBALS['post'] = get_post( $project_id ); // phpcs:ignore
					setup_postdata( $GLOBALS['post'] );
					get_template_part( 'template-parts/project-card' );
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>

			<nav class="see-also" aria-label="Xem thêm">
				<p class="see-also__title">Xem thêm</p>
				<ul>
					<?php foreach ( hh_post_cluster_links( $id ) as list( $label, $url ) ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<div class="share">
				<span>Chia sẻ bài viết:</span>
				<a class="share__btn share__btn--fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $share ); ?>" target="_blank" rel="noopener">Facebook</a>
				<button type="button" class="share__btn share__btn--zalo" data-share="<?php echo esc_url( get_permalink() ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>">Gửi qua Zalo</button>
				<button type="button" class="share__btn" data-share-copy="<?php echo esc_url( get_permalink() ); ?>">Sao chép link</button>
				<span class="share__msg" role="status"></span>
			</div>

			<aside class="author-box">
				<img src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="72" height="72" loading="lazy">
				<div>
					<p class="author-box__name"><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></p>
					<p class="author-box__title"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?><?php echo hoanghiep_opt( 'hh_person_company' ) ? ' · ' . esc_html( hoanghiep_opt( 'hh_person_company' ) ) : ''; ?></p>
					<p><?php echo esc_html( hoanghiep_opt( 'hh_person_bio' ) ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( home_url( '/gioi-thieu/' ) ); ?>">Tìm hiểu thêm về <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?> <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a>
				</div>
			</aside>
		</article>

		<aside class="layout__side">
			<div class="sticky" id="lien-he">
				<?php hh_agent_card( true ); ?>
				<?php
				$latest = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5, 'post__not_in' => array( $id ), 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
				if ( $latest->have_posts() ) :
					?>
					<div class="side-news">
						<p class="side-news__title">Tin mới nhất</p>
						<ol>
							<?php
							while ( $latest->have_posts() ) :
								$latest->the_post();
								?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span></li>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</ol>
					</div>
				<?php endif; ?>
				<?php echo hh_lead_form(); // phpcs:ignore ?>
			</div>
		</aside>
	</div>

	<?php
	// Phía dưới: chỉ tin tức, ưu tiên cùng chuyên mục.
	$related_args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => array( $id ), 'ignore_sticky_posts' => true, 'no_found_rows' => true );
	if ( $cats ) {
		$related_args['category__in'] = wp_list_pluck( $cats, 'term_id' );
	}
	$related = new WP_Query( $related_args );
	if ( $related->post_count < 3 ) {
		unset( $related_args['category__in'] );
		$related = new WP_Query( $related_args );
	}
	if ( $related->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( 'Tin tức', $cats ? 'Cùng chuyên mục ' . $cats[0]->name : 'Tin liên quan', $cats ? get_category_link( $cats[0] ) : $news_url ); ?>
				<div class="grid grid--3">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/post-card' );
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
