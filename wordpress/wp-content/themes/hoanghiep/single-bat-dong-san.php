<?php
/**
 * Trang chi tiết tin rao (anh Hiệp 28/11/2026): Hình chính → Tiêu đề → Giới thiệu → Thông tin → Mặt bằng & hình ảnh → Liên hệ.
 * Chỉ hiện dữ liệu thật của tin; mục nào không có dữ liệu thì ẩn. Giữ nguyên URL, breadcrumb, schema.
 */
get_header();

while ( have_posts() ) :
	the_post();
	$id      = get_the_ID();
	$schema  = hh_listing_schema();
	$deal    = hh_meta( 'hh_deal' ) ?: 'ban';
	$rent_d  = 'thue' === $deal;
	$status  = hh_meta( 'hh_status' );
	$project = (int) hh_meta( 'hh_project' );
	list( $photos, $plans ) = hh_ld_photos( $id );
	$pmedia  = hh_ld_project_media( $id );
	$facts   = hh_ld_facts( $id );
	$areas   = get_the_terms( $id, 'khu-vuc' );
	$types   = get_the_terms( $id, 'loai-bds' );
	$area_t  = $areas && ! is_wp_error( $areas ) ? $areas[0] : null;
	$type_t  = $types && ! is_wp_error( $types ) ? $types[0] : null;
	$tagline = trim( (string) hh_meta( 'hh_tagline' ) );
	$intro   = has_excerpt() ? get_the_excerpt() : '';
	$price   = hh_listing_price();
	$pm2     = $rent_d ? '' : hh_listing_price_m2();
	$policy  = hh_lines( 'hh_policy' );
	$tel     = hoanghiep_tel();
	$zalo    = 'https://zalo.me/' . hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) );
	$rent    = array_filter(
		array(
			'Tiền cọc'       => hh_meta( 'hh_deposit' ),
			'Thuê tối thiểu' => hh_meta( 'hh_min_term' ),
			'Phí quản lý'    => hh_meta( 'hh_service_fee' ),
			'Dọn vào'        => hh_meta( 'hh_available' ),
			'Giá đã bao gồm' => hh_meta( 'hh_rent_incl' ),
		)
	);
	$view3d = hh_meta( 'hh_3d_url' );
	$has3d  = $view3d && 0 === strpos( $view3d, 'https://' );
	$sec    = array_filter(
		array(
			'gioi-thieu' => ( $intro || get_the_content() || hh_lines( 'hh_features' ) || hh_meta( 'hh_video' ) ) ? 'Giới thiệu' : '',
			'thong-tin'  => 'Thông tin',
			'mat-bang'   => ( $plans || $pmedia || $has3d || count( $photos ) > 1 ) ? 'Mặt bằng & hình ảnh' : '',
			'lien-he'    => 'Liên hệ',
		)
	);
	?>
	<div class="page-head page-head--slim">
		<div class="container">
			<p class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
				<a href="<?php echo esc_url( hh_deal_url( $deal ) ); ?>"><?php echo $rent_d ? 'Cho thuê' : 'Mua bán'; ?></a>
				<?php if ( $area_t ) : ?>
					/ <a href="<?php echo esc_url( hh_deal_term_url( $deal, $area_t ) ); ?>"><?php echo esc_html( $area_t->name ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</div>

	<?php /* Bố cục tin rao (anh Hiệp 28/11/2026): Hình chính → Tiêu đề → Giới thiệu → Thông tin → Mặt bằng & hình ảnh → Liên hệ. Một cột giữa trang, không kéo khách sang tin khác. */ ?>
	<div class="container ld ld2">
		<?php /* 1. Hình chính */ ?>
		<?php if ( $photos ) : ?>
			<div class="ld-hero<?php echo $tagline ? ' ld-hero--msg' : ''; ?>">
				<?php hh_fb_album( $photos, 'nha', array( 'eager' => true, 'label' => 'Ảnh ' . get_the_title() ) ); ?>
				<?php if ( $tagline ) : ?><p class="ld-hero__msg"><?php echo esc_html( $tagline ); ?></p><?php endif; ?>
			</div>
		<?php endif; ?>

		<article class="ld2-main">
			<?php /* 2. Tiêu đề */ ?>
			<header class="ld-head ld2-head">
				<div class="listing-head__pills">
					<?php hh_pill( $rent_d ? 'Cho thuê' : 'Bán', $deal ); ?>
					<?php hh_pill( hh_option_label( $schema, 'hh_status', $status ), $status ); ?>
					<?php if ( $type_t ) : ?><a class="pill pill--type" href="<?php echo esc_url( get_term_link( $type_t ) ); ?>"><?php echo esc_html( $type_t->name ); ?></a><?php endif; ?>
				</div>
				<h1 class="ld-head__title"><?php the_title(); ?></h1>
				<?php if ( hh_meta( 'hh_address' ) ) : ?>
					<p class="meta-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_address' ) ); ?></p>
				<?php endif; ?>
				<div class="ld2-pricebar">
					<p class="ld-head__price"><strong><?php echo esc_html( $price ); ?></strong><?php if ( $pm2 ) : ?> <span><?php echo esc_html( $pm2 ); ?></span><?php endif; ?><?php if ( '1' === hh_meta( 'hh_negotiable' ) ) : ?> <em>Còn thương lượng</em><?php endif; ?></p>
					<a class="btn btn--cta" href="#lien-he">Hẹn xem nhà</a>
				</div>
				<p class="listing-head__code">Mã tin: <strong><?php echo esc_html( hh_listing_code() ); ?></strong> · Đăng ngày <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time><?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) : ?> · Cập nhật <?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?><?php endif; ?></p>
			</header>

			<nav class="ld-toc ld2-toc" aria-label="Mục trong tin">
				<?php foreach ( $sec as $k => $label ) : ?><a href="#<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $label ); ?></a><?php endforeach; ?>
			</nav>

			<?php /* 3. Giới thiệu */ ?>
			<?php if ( isset( $sec['gioi-thieu'] ) ) : ?>
				<section class="block ld-sec" id="gioi-thieu">
					<h2 class="block__title">Giới thiệu</h2>
					<?php if ( $intro ) : ?><p class="ld-intro"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
					<?php if ( hh_lines( 'hh_features' ) ) : ?>
						<div class="ld-features"><h3>Điểm nổi bật</h3><?php hh_check_list( hh_lines( 'hh_features' ) ); ?></div>
					<?php endif; ?>
					<?php if ( get_the_content() ) : ?><div class="entry-content"><?php echo preg_replace( array( '#<h2(\s|>)#i', '#</h2>#i' ), array( '<h3$1', '</h3>' ), apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore -- H2 trong mô tả hạ thành H3. ?></div><?php endif; ?>
					<?php if ( hh_meta( 'hh_video' ) ) : ?><div class="ld2-video"><?php hh_video( hh_meta( 'hh_video' ) ); ?></div><?php endif; ?>
				</section>
			<?php endif; ?>

			<?php /* 4. Thông tin */ ?>
			<section class="block ld-sec" id="thong-tin">
				<h2 class="block__title">Thông tin <?php echo $rent_d ? 'cho thuê' : 'căn bán'; ?></h2>
				<?php if ( $facts ) : ?>
					<dl class="ld-facts ld2-facts">
						<?php foreach ( $facts as $f ) : ?>
							<div class="ld-fact<?php echo $f[2] ? ' ld-fact--' . esc_attr( $f[2] ) : ''; ?>"><dt><?php echo esc_html( $f[0] ); ?></dt><dd><?php echo esc_html( $f[1] ); ?></dd></div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
				<?php if ( $rent_d && $rent ) : ?><?php hh_spec_list( $rent ); ?><?php endif; ?>
				<?php if ( $policy ) : ?><div class="ld2-policy"><h3><?php echo $rent_d ? 'Điều kiện thuê' : 'Chính sách'; ?></h3><?php hh_check_list( $policy ); ?></div><?php endif; ?>
				<?php if ( $project && 'publish' === get_post_status( $project ) ) : ?>
					<a class="project-link" href="<?php echo esc_url( get_permalink( $project ) ); ?>">
						<?php echo get_the_post_thumbnail( $project, 'thumbnail' ); ?>
						<span><small>Thuộc dự án – xem vị trí, tiện ích, pháp lý dự án</small><strong><?php echo esc_html( get_the_title( $project ) ); ?></strong></span>
						<?php echo hh_icon( 'arrow' ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
				<details class="ld-specs"><summary>Toàn bộ thông tin tin đăng</summary><?php hh_spec_list( hh_listing_specs() ); ?></details>
			</section>

			<?php /* 5. Mặt bằng & hình ảnh */ ?>
			<?php if ( isset( $sec['mat-bang'] ) ) : ?>
				<section class="block ld-sec" id="mat-bang">
					<h2 class="block__title">Mặt bằng và hình ảnh</h2>
					<?php if ( $plans ) : ?>
						<h3 class="ld2-sub">Mặt bằng căn</h3>
						<div class="ld-plans ld2-grid">
							<?php foreach ( $plans as $pid ) : ?>
								<?php $full = wp_get_attachment_image_url( $pid, 'full' ); ?>
								<?php if ( ! $full ) { continue; } ?>
								<a class="ld-plan" href="<?php echo esc_url( $full ); ?>" data-lightbox="mat-bang">
									<?php echo wp_get_attachment_image( $pid, 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
									<?php $cap = wp_get_attachment_caption( $pid ) ?: get_post_meta( $pid, '_wp_attachment_image_alt', true ); ?>
									<?php if ( $cap ) : ?><span><?php echo esc_html( $cap ); ?></span><?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if ( count( $photos ) > 1 ) : ?>
						<h3 class="ld2-sub">Hình ảnh thực tế</h3>
						<div class="ld-plans ld2-grid ld2-photos">
							<?php foreach ( $photos as $pid ) : ?>
								<?php $full = wp_get_attachment_image_url( $pid, 'full' ); ?>
								<?php if ( ! $full ) { continue; } ?>
								<a class="ld-plan" href="<?php echo esc_url( $full ); ?>" data-lightbox="anh"><?php echo wp_get_attachment_image( $pid, 'medium_large', false, array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if ( $pmedia ) : ?>
						<h3 class="ld2-sub"><?php echo $pmedia['tower'] ? 'Tòa nhà và mặt bằng' : 'Phối cảnh và mặt bằng'; ?> dự án <a href="<?php echo esc_url( $pmedia['url'] ); ?>"><?php echo esc_html( $pmedia['title'] ); ?></a></h3>
						<div class="ld-plans ld2-grid">
							<?php if ( $pmedia['building'] ) : ?>
								<a class="ld-plan ld-plan--bld" href="<?php echo esc_url( wp_get_attachment_image_url( $pmedia['building'], 'full' ) ); ?>" data-lightbox="mat-bang">
									<?php echo wp_get_attachment_image( $pmedia['building'], 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => ( $pmedia['tower'] ? 'Hình tòa nhà ' : 'Phối cảnh ' ) . $pmedia['title'] ) ); ?>
									<span><?php echo esc_html( ( $pmedia['tower'] ? 'Hình tòa nhà ' : 'Phối cảnh ' ) . $pmedia['title'] ); ?></span>
								</a>
							<?php endif; ?>
							<?php foreach ( $pmedia['plans'] as $pl ) : ?>
								<a class="ld-plan" href="<?php echo esc_url( wp_get_attachment_image_url( $pl[0], 'full' ) ); ?>" data-lightbox="mat-bang">
									<?php echo wp_get_attachment_image( $pl[0], 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $pl[1] ) ); ?>
									<span><?php echo esc_html( $pl[1] ); ?></span>
								</a>
							<?php endforeach; ?>
						</div>
						<?php if ( $pmedia['units'] || $pmedia['tour'] ) : ?>
							<div class="ld-proj__cta">
								<a class="btn btn--cta" href="<?php echo esc_url( $pmedia['url'] . '#xem-4d' ); ?>"><?php echo $pmedia['units'] ? 'Chọn căn trên mặt bằng tầng' : 'Xem mô hình 4D tòa nhà'; ?></a>
								<small><?php echo $pmedia['tower'] ? 'Xem tòa nhà, chọn tầng, xem mặt bằng và hướng nhìn từng căn' : 'Xem phối cảnh, mặt bằng và vị trí từng lô'; ?><?php echo $pmedia['tour'] ? ' trên mô hình 4D' : ''; ?>.</small>
							</div>
						<?php endif; ?>
						<p class="ld-note">Ảnh của dự án, minh hoạ vị trí và thiết kế chung; căn thực tế theo mô tả của tin.</p>
					<?php endif; ?>
					<?php if ( $has3d ) : ?>
						<div class="view3d" id="phoi-canh-3d"><iframe src="<?php echo esc_url( $view3d ); ?>" title="Phối cảnh 3D <?php echo esc_attr( get_the_title() ); ?>" loading="lazy" allow="fullscreen; xr-spatial-tracking" allowfullscreen></iframe></div>
						<p class="map-links">Kéo để xoay, chụm hai ngón để phóng to (hình minh hoạ) · <a href="<?php echo esc_url( $view3d ); ?>" target="_blank" rel="noopener">Mở toàn màn hình ↗</a></p>
					<?php endif; ?>
					<p class="ld-note">Bấm vào hình để phóng to, xem toàn màn hình.</p>
				</section>
			<?php endif; ?>

			<?php /* 6. Liên hệ */ ?>
			<section class="block ld-sec ld2-contact" id="lien-he">
				<h2 class="block__title">Liên hệ xem nhà</h2>
				<div class="ld2-contact__grid">
					<div class="ld2-contact__info">
						<div class="side-price">
							<span>Giá <?php echo $rent_d ? 'thuê' : 'bán'; ?></span>
							<strong><?php echo esc_html( $price ); ?></strong>
							<?php if ( $pm2 ) : ?><small><?php echo esc_html( $pm2 ); ?></small><?php endif; ?>
							<?php if ( '1' === hh_meta( 'hh_negotiable' ) ) : ?><small>Còn thương lượng</small><?php endif; ?>
						</div>
						<?php hh_agent_card( true ); ?>
					</div>
					<div class="ld2-contact__form">
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
				</div>
			</section>
		</article>
	</div>

	<?php /* Thanh liên hệ cố định trên điện thoại */ ?>
	<div class="ld-bar" role="region" aria-label="Liên hệ nhanh">
		<div class="ld-bar__price"><small><?php echo $rent_d ? 'Giá thuê' : 'Giá bán'; ?></small><strong><?php echo esc_html( $price ); ?></strong></div>
		<a class="ld-bar__btn ld-bar__btn--call" href="tel:<?php echo esc_attr( $tel ); ?>">Gọi ngay</a>
		<a class="ld-bar__btn ld-bar__btn--zalo" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Zalo</a>
		<a class="ld-bar__btn ld-bar__btn--msg" href="#lien-he">Nhắn tin</a>
	</div>
	<?php
endwhile;

get_footer();
