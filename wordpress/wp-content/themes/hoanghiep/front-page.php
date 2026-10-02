<?php
get_header();

$featured_projects = new WP_Query(
	array(
		'post_type'      => 'du-an',
		'posts_per_page' => 5,
		'meta_query'     => array(
			array( 'key' => 'hh_p_featured', 'value' => '1' ),
			array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ),
		),
	)
);
$hero_image = hoanghiep_opt( 'hh_hero_image' );
?>
<section class="hero" data-slider>
	<?php if ( $featured_projects->have_posts() ) : ?>
		<h1 class="sr-only"><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) ); ?></h1>
		<?php
		$i = 0;
		while ( $featured_projects->have_posts() ) :
			$featured_projects->the_post();
			$status = hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status' ) );
			?>
			<div class="hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
				<?php the_post_thumbnail( 'hh-hero', array( 'class' => 'hero__bg', 'loading' => 0 === $i ? 'eager' : 'lazy', 'alt' => '' ) ); ?>
				<div class="container hero__content">
					<p class="eyebrow eyebrow--light">Dự án nổi bật<?php echo $status ? ' · ' . esc_html( $status ) : ''; ?></p>
					<h2 class="hero__title"><?php the_title(); ?></h2>
					<?php if ( hh_meta( 'hh_p_address' ) ) : ?>
						<p class="hero__meta"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_p_address' ) ); ?></p>
					<?php endif; ?>
					<p class="hero__price"><?php echo esc_html( hh_project_price() ); ?></p>
					<div class="hero__actions">
						<a class="btn btn--gold" href="<?php the_permalink(); ?>">Xem chi tiết dự án</a>
						<a class="btn btn--ghost" href="<?php the_permalink(); ?>#lien-he">Nhận bảng giá</a>
					</div>
				</div>
			</div>
			<?php
			++$i;
		endwhile;
		wp_reset_postdata();
		?>
		<?php if ( $i > 1 ) : ?>
			<div class="hero__dots">
				<?php for ( $d = 0; $d < $i; $d++ ) : ?>
					<button class="<?php echo 0 === $d ? 'is-active' : ''; ?>" aria-label="Slide <?php echo (int) $d + 1; ?>"></button>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<div class="hero__slide is-active">
			<?php if ( $hero_image ) : ?>
				<img class="hero__bg" src="<?php echo esc_url( $hero_image ); ?>" alt="">
			<?php endif; ?>
			<div class="container hero__content hero__content--person">
				<img class="hero__portrait" src="<?php echo esc_url( hoanghiep_photo( 'portrait2' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="900" height="1350">
				<p class="eyebrow eyebrow--light"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?></p>
				<h1 class="hero__title"><?php echo esc_html( hoanghiep_opt( 'hh_hero_title' ) ); ?></h1>
				<p class="hero__text"><?php echo esc_html( hoanghiep_opt( 'hh_hero_text' ) ); ?></p>
				<div class="hero__actions">
					<a class="btn btn--gold" href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Xem dự án</a>
					<a class="btn btn--ghost" href="#lien-he">Nhận tư vấn miễn phí</a>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>

<div class="container search-wrap">
	<?php hh_search_box(); ?>
</div>

<?php
// Dự án theo nhóm: Cao tầng, Thấp tầng (kèm các loại con).
$project_sections = array(
	'to-hop'    => array( 'Tổ hợp dự án', 'Khu đô thị · Khu phức hợp · Residence' ),
	'cao-tang'  => array( 'Dự án cao tầng', 'Căn hộ · Penthouse · Duplex · Shop khối đế' ),
	'thap-tang' => array( 'Dự án thấp tầng', 'Biệt thự · Đất nền · Shophouse' ),
);
$shown_projects   = 0;
$tint             = false;
foreach ( $project_sections as $slug => list( $title, $eyebrow ) ) :
	$group = get_term_by( 'slug', $slug, 'loai-du-an' );
	if ( ! $group ) {
		continue;
	}
	$projects = hh_hot_query( 'du-an', array( 'limit' => 6, 'type_term' => $group->term_id ) );
	if ( ! $projects->have_posts() ) {
		continue;
	}
	$shown_projects += $projects->post_count;
	$children        = get_terms( array( 'taxonomy' => 'loai-du-an', 'parent' => $group->term_id, 'hide_empty' => false, 'orderby' => 'term_id' ) );
	?>
	<section class="section<?php echo $tint ? ' section--tint' : ''; ?>">
		<div class="container">
			<?php hh_section_head( $eyebrow, $title, get_term_link( $group ), 'Xem tất cả' ); ?>
			<?php if ( $children && ! is_wp_error( $children ) ) : ?>
				<nav class="type-chips" aria-label="<?php echo esc_attr( $title ); ?>">
					<?php foreach ( $children as $child ) : ?>
						<a href="<?php echo esc_url( get_term_link( $child ) ); ?>"><?php echo esc_html( $child->name ); ?> <span><?php echo (int) $child->count; ?></span></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
			<div class="grid grid--3">
				<?php
				while ( $projects->have_posts() ) :
					$projects->the_post();
					get_template_part( 'template-parts/project-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
	$tint = ! $tint;
endforeach;

// Chưa phân loại dự án nào: hiện danh sách dự án chung.
if ( ! $shown_projects ) :
	$projects = new WP_Query( array( 'post_type' => 'du-an', 'posts_per_page' => 6 ) );
	if ( $projects->have_posts() ) :
		?>
		<section class="section">
			<div class="container">
				<?php hh_section_head( 'Dự án', 'Dự án Đà Nẵng', get_post_type_archive_link( 'du-an' ), 'Tất cả dự án' ); ?>
				<div class="grid grid--3">
					<?php
					while ( $projects->have_posts() ) :
						$projects->the_post();
						get_template_part( 'template-parts/project-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
endif;
?>

<?php
foreach ( array( 'ban' => array( 'Mua bán', 'Nhà đất bán hot mới' ), 'thue' => array( 'Cho thuê', 'Nhà cho thuê hot mới' ) ) as $deal => list( $eyebrow, $title ) ) :
	$listings = hh_hot_query( 'bat-dong-san', array( 'limit' => 8, 'deal' => $deal ) );
	if ( ! $listings->have_posts() ) {
		continue;
	}
	?>
	<section class="section">
		<div class="container">
			<?php hh_section_head( $eyebrow, $title, hh_deal_url( $deal ) ); ?>
			<div class="grid grid--4">
				<?php
				while ( $listings->have_posts() ) :
					$listings->the_post();
					get_template_part( 'template-parts/listing-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endforeach; ?>

<?php
$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5, 'ignore_sticky_posts' => true ) );
if ( $news->have_posts() ) :
	?>
	<section class="section">
		<div class="container">
			<?php hh_section_head( 'Tin tức', 'Tin tức mới nhất', get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : '' ); ?>
			<div class="news-layout">
				<?php
				$n = 0;
				while ( $news->have_posts() ) :
					$news->the_post();
					if ( 0 === $n ) :
						?>
						<article class="news-lead">
							<a class="news-lead__media" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
								<?php endif; ?>
							</a>
							<div class="news-lead__body">
								<p class="post-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?><?php $cat = get_the_category(); echo $cat ? ' · ' . esc_html( $cat[0]->name ) : ''; ?></p>
								<h3 class="news-lead__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							</div>
						</article>
						<ul class="news-list">
					<?php else : ?>
						<li>
							<a class="news-list__media" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<span class="media-placeholder"><?php echo hh_icon( 'file' ); // phpcs:ignore ?></span>
								<?php endif; ?>
							</a>
							<div>
								<p class="post-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
								<a class="news-list__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
						</li>
						<?php
					endif;
					++$n;
				endwhile;
				wp_reset_postdata();
				?>
				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tint about-home">
	<div class="container about-home__grid">
		<div class="about-home__photo">
			<img src="<?php echo esc_url( hoanghiep_photo( 'portrait' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) . ' – ' . hoanghiep_opt( 'hh_person_title' ) ); ?>" loading="lazy" width="900" height="1350">
			<p class="about-home__badge"><?php echo esc_html( hoanghiep_opt( 'hh_person_slogan' ) ); ?></p>
		</div>
		<div class="about-home__text">
			<p class="eyebrow">Về <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></p>
			<h2 class="display">Hơn 15 năm đồng hành cùng thị trường Đà Nẵng – miền Trung</h2>
			<p class="lead"><?php echo esc_html( hoanghiep_opt( 'hh_person_bio' ) ); ?></p>
			<?php if ( hoanghiep_opt( 'hh_person_company' ) ) : ?>
				<p class="company-badge company-badge--dark">Hiện công tác tại <strong><?php echo esc_html( hoanghiep_opt( 'hh_person_company' ) ); ?></strong></p>
			<?php endif; ?>
			<?php $stats = hoanghiep_stats(); ?>
			<?php if ( $stats ) : ?>
				<dl class="stats">
					<?php foreach ( $stats as list( $num, $label ) ) : ?>
						<div><dt><?php echo esc_html( $num ); ?></dt><dd><?php echo esc_html( $label ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
			<?php else : ?>
				<ul class="promises">
					<li><?php echo hh_icon( 'shield' ); // phpcs:ignore ?><span><strong>Pháp lý minh bạch</strong>Kiểm tra giấy tờ trước khi giới thiệu</span></li>
					<li><?php echo hh_icon( 'search' ); // phpcs:ignore ?><span><strong>Khảo sát thực tế</strong>Thông tin, hình ảnh đúng hiện trạng</span></li>
					<li><?php echo hh_icon( 'handshake' ); // phpcs:ignore ?><span><strong>Đồng hành trọn vẹn</strong>Từ xem nhà đến công chứng, bàn giao</span></li>
				</ul>
			<?php endif; ?>
			<?php hh_highlights( 1, 'highlights highlights--inline' ); ?>
			<div class="about-home__actions">
				<a class="btn btn--navy" href="<?php echo esc_url( home_url( '/gioi-thieu/' ) ); ?>">Tìm hiểu thêm</a>
				<a class="btn btn--outline" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php
$areas = get_terms( array( 'taxonomy' => 'khu-vuc', 'hide_empty' => true, 'number' => 8, 'orderby' => 'count', 'order' => 'DESC' ) );
if ( $areas && ! is_wp_error( $areas ) ) :
	?>
	<section class="section">
		<div class="container">
			<?php hh_section_head( 'Khu vực', 'Bất động sản theo khu vực Đà Nẵng' ); ?>
			<div class="area-grid">
				<?php foreach ( $areas as $t ) : ?>
					<a class="area-chip" href="<?php echo esc_url( get_term_link( $t ) ); ?>">
						<strong><?php echo esc_html( $t->name ); ?></strong>
						<span><?php echo (int) $t->count; ?> tin &amp; dự án</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--navy">
	<div class="container">
		<div class="section-head section-head--light">
			<div>
				<p class="eyebrow eyebrow--light">Quy trình</p>
				<h2 class="section-head__title">Làm việc cùng Hiệp như thế nào?</h2>
			</div>
		</div>
		<ol class="steps">
			<li><strong>Lắng nghe nhu cầu</strong><span>Ngân sách, khu vực, mục đích ở hay đầu tư.</span></li>
			<li><strong>Chọn lọc &amp; dẫn xem</strong><span>Gửi danh sách phù hợp, sắp xếp lịch xem thực tế.</span></li>
			<li><strong>Đàm phán &amp; pháp lý</strong><span>Thương lượng giá, kiểm tra giấy tờ, soạn hợp đồng.</span></li>
			<li><strong>Công chứng &amp; bàn giao</strong><span>Hỗ trợ vay, sang tên và nhận nhà trọn vẹn.</span></li>
		</ol>
	</div>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
