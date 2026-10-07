<?php
get_header();

while ( have_posts() ) :
	the_post();
	$id      = get_the_ID();
	$schema  = hh_listing_schema();
	$deal    = hh_meta( 'hh_deal' ) ?: 'ban';
	$status  = hh_meta( 'hh_status' );
	$photos  = array_values( array_unique( array_filter( array_merge( array( get_post_thumbnail_id() ), hh_ids( 'hh_gallery' ) ) ) ) );
	$project = (int) hh_meta( 'hh_project' );

	$quick = array_filter(
		array(
			'Giá'       => hh_listing_price(),
			'Diện tích' => hh_meta( 'hh_area' ) ? hh_meta( 'hh_area' ) . ' m²' : '',
			'Phòng ngủ' => hh_meta( 'hh_bedrooms' ),
			'Phòng tắm' => hh_meta( 'hh_bathrooms' ),
			'Hướng'     => hh_meta( 'hh_direction' ) ? hh_option_label( $schema, 'hh_direction', hh_meta( 'hh_direction' ) ) : '',
		)
	);
	$rent = array_filter(
		array(
			'Tiền cọc'          => hh_meta( 'hh_deposit' ),
			'Thuê tối thiểu'    => hh_meta( 'hh_min_term' ),
			'Phí quản lý'       => hh_meta( 'hh_service_fee' ),
			'Dọn vào'           => hh_meta( 'hh_available' ),
			'Giá đã bao gồm'    => hh_meta( 'hh_rent_incl' ),
		)
	);
	?>
	<div class="page-head page-head--slim">
		<div class="container">
			<p class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
				<a href="<?php echo esc_url( hh_deal_url( $deal ) ); ?>"><?php echo 'thue' === $deal ? 'Cho thuê' : 'Mua bán'; ?></a>
				<?php $crumb_area = get_the_terms( $id, 'khu-vuc' ); ?>
				<?php if ( $crumb_area && ! is_wp_error( $crumb_area ) ) : ?>
					/ <a href="<?php echo esc_url( hh_deal_term_url( $deal, $crumb_area[0] ) ); ?>"><?php echo esc_html( $crumb_area[0]->name ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</div>

	<div class="container layout">
		<article class="layout__main">
			<header class="listing-head">
				<div class="listing-head__pills">
					<?php hh_pill( 'thue' === $deal ? 'Cho thuê' : 'Bán', $deal ); ?>
					<?php hh_pill( hh_option_label( $schema, 'hh_status', $status ), $status ); ?>
				</div>
				<h1 class="listing-head__title"><?php the_title(); ?></h1>
				<?php if ( hh_meta( 'hh_address' ) ) : ?>
					<p class="meta-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_address' ) ); ?></p>
				<?php endif; ?>
				<p class="listing-head__code">Mã tin: <strong><?php echo esc_html( hh_listing_code() ); ?></strong> · Đăng ngày <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time><?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) : ?> · Cập nhật <?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?><?php endif; ?></p>
			</header>

			<?php if ( $photos ) : ?>
				<div class="photo-stage">
					<?php
					foreach ( $photos as $i => $pid ) :
						$full = wp_get_attachment_image_url( $pid, 'full' );
						if ( ! $full ) {
							continue;
						}
						?>
						<a class="photo-stage__item<?php echo 0 === $i ? ' photo-stage__item--main' : ''; ?><?php echo $i > 4 ? ' is-extra' : ''; ?>" href="<?php echo esc_url( $full ); ?>" data-lightbox="nha">
							<?php echo wp_get_attachment_image( $pid, 0 === $i ? 'large' : 'hh-card', false, array( 'loading' => 0 === $i ? 'eager' : 'lazy', 'fetchpriority' => 0 === $i ? 'high' : 'auto' ) ); ?>
							<?php if ( 4 === $i && count( $photos ) > 5 ) : ?>
								<span class="photo-stage__more">+<?php echo count( $photos ) - 5; ?> ảnh</span>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<dl class="quick-facts">
				<?php foreach ( $quick as $label => $value ) : ?>
					<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
				<?php endforeach; ?>
			</dl>

			<section class="block">
				<h2 class="block__title">Thông tin chi tiết</h2>
				<?php hh_spec_list( hh_listing_specs() ); ?>
			</section>

			<?php if ( get_the_content() ) : ?>
				<section class="block">
					<h2 class="block__title">Mô tả</h2>
					<div class="entry-content"><?php the_content(); ?></div>
				</section>
			<?php endif; ?>

			<?php if ( hh_lines( 'hh_features' ) || hh_lines( 'hh_nearby' ) ) : ?>
				<section class="block">
					<div class="two-col">
						<?php if ( hh_lines( 'hh_features' ) ) : ?>
							<div>
								<h2 class="block__title">Đặc điểm nổi bật</h2>
								<?php hh_check_list( hh_lines( 'hh_features' ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( hh_lines( 'hh_nearby' ) ) : ?>
							<div>
								<h2 class="block__title">Tiện ích xung quanh</h2>
								<?php hh_check_list( hh_lines( 'hh_nearby' ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( 'thue' === $deal && $rent ) : ?>
				<section class="block">
					<h2 class="block__title">Điều kiện thuê</h2>
					<?php hh_spec_list( $rent ); ?>
				</section>
			<?php endif; ?>

			<?php if ( 'ban' === $deal ) : ?>
				<section class="block" id="tai-chinh">
					<h2 class="block__title">Tính khoản vay &amp; dòng tiền</h2>
					<?php get_template_part( 'template-parts/finance', null, array( 'mode' => 'listing' ) ); ?>
				</section>
			<?php endif; ?>

			<?php if ( hh_meta( 'hh_video' ) ) : ?>
				<section class="block">
					<h2 class="block__title">Video</h2>
					<?php hh_video( hh_meta( 'hh_video' ) ); ?>
				</section>
			<?php endif; ?>

			<?php $map_addr = hh_meta( 'hh_map_address' ) ?: hh_meta( 'hh_address' ); ?>
			<?php if ( $map_addr ) : ?>
				<section class="block">
					<h2 class="block__title">Vị trí</h2>
					<?php hh_map( $map_addr ); ?>
				</section>
			<?php endif; ?>

			<?php if ( $project && 'publish' === get_post_status( $project ) ) : ?>
				<a class="project-link" href="<?php echo esc_url( get_permalink( $project ) ); ?>">
					<?php echo get_the_post_thumbnail( $project, 'thumbnail' ); ?>
					<span><small>Thuộc dự án</small><strong><?php echo esc_html( get_the_title( $project ) ); ?></strong></span>
					<?php echo hh_icon( 'arrow' ); // phpcs:ignore ?>
				</a>
			<?php endif; ?>
		</article>

		<aside class="layout__side">
			<div class="sticky" id="lien-he">
				<div class="side-price">
					<span>Giá <?php echo 'thue' === $deal ? 'thuê' : 'bán'; ?></span>
					<strong><?php echo esc_html( hh_listing_price() ); ?></strong>
					<?php if ( hh_listing_price_m2() ) : ?><small><?php echo esc_html( hh_listing_price_m2() ); ?></small><?php endif; ?>
					<?php if ( '1' === hh_meta( 'hh_negotiable' ) ) : ?><small>Còn thương lượng</small><?php endif; ?>
				</div>
				<?php hh_agent_card( true ); ?>
				<?php
				echo hh_lead_form( // phpcs:ignore
					array(
						'ref_id' => $id,
						'title'  => 'Đặt lịch xem nhà',
						'need'   => 'Đặt lịch xem nhà',
						'button' => 'Đặt lịch xem',
					)
				);
				?>
			</div>
		</aside>
	</div>

	<?php
	// Phía dưới: tin hot mới cùng hình thức (bán → bán, cho thuê → cho thuê).
	$hot = hh_hot_query( 'bat-dong-san', array( 'exclude' => array( $id ), 'limit' => 8, 'deal' => $deal ) );
	if ( $hot->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( 'thue' === $deal ? 'Cho thuê' : 'Mua bán', 'thue' === $deal ? 'Nhà cho thuê hot mới' : 'Nhà đất bán hot mới', hh_deal_url( $deal ) ); ?>
				<div class="grid grid--4">
					<?php
					while ( $hot->have_posts() ) :
						$hot->the_post();
						get_template_part( 'template-parts/listing-card' );
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
