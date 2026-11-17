<?php
/**
 * Trang chi tiết tin rao (anh Hiệp 17/11/2026): ảnh → thông điệp → H1 → giới thiệu → ô thông số → mô tả →
 * vị trí → tiện ích → mặt bằng → giá & chính sách → liên hệ → tin liên quan → hỏi đáp.
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
	$nearby  = hh_ld_nearby_groups( $id );
	$policy  = hh_lines( 'hh_policy' );
	$faq     = hh_ld_faq( $id );
	$map     = hh_meta( 'hh_map_address' ) ?: hh_meta( 'hh_address' );
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
	$sec = array_filter(
		array(
			'mo-ta'    => get_the_content() || hh_lines( 'hh_features' ) ? 'Mô tả' : '',
			'vi-tri'   => $map ? 'Vị trí' : '',
			'tien-ich' => $nearby ? 'Tiện ích' : '',
			'mat-bang' => $plans || $pmedia || ( hh_meta( 'hh_3d_url' ) && 0 === strpos( hh_meta( 'hh_3d_url' ), 'https://' ) ) ? 'Mặt bằng' : '',
			'gia'      => 'Giá & liên hệ',
			'hoi-dap'  => $faq ? 'Hỏi đáp' : '',
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

	<div class="container ld">
		<?php /* 1. Ảnh đại diện + thông điệp */ ?>
		<?php if ( $photos ) : ?>
			<div class="ld-hero<?php echo $tagline ? ' ld-hero--msg' : ''; ?>">
				<?php hh_fb_album( $photos, 'nha', array( 'eager' => true, 'label' => 'Ảnh ' . get_the_title() ) ); ?>
				<?php if ( $tagline ) : ?><p class="ld-hero__msg"><?php echo esc_html( $tagline ); ?></p><?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="layout ld-layout">
			<article class="layout__main">
				<?php /* 2. Tiêu đề + 3. giới thiệu */ ?>
				<header class="ld-head">
					<div class="listing-head__pills">
						<?php hh_pill( $rent_d ? 'Cho thuê' : 'Bán', $deal ); ?>
						<?php hh_pill( hh_option_label( $schema, 'hh_status', $status ), $status ); ?>
						<?php if ( $type_t ) : ?><a class="pill pill--type" href="<?php echo esc_url( get_term_link( $type_t ) ); ?>"><?php echo esc_html( $type_t->name ); ?></a><?php endif; ?>
					</div>
					<h1 class="ld-head__title"><?php the_title(); ?></h1>
					<?php if ( hh_meta( 'hh_address' ) ) : ?>
						<p class="meta-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_address' ) ); ?></p>
					<?php endif; ?>
					<p class="ld-head__price"><strong><?php echo esc_html( $price ); ?></strong><?php if ( $pm2 ) : ?> <span><?php echo esc_html( $pm2 ); ?></span><?php endif; ?><?php if ( '1' === hh_meta( 'hh_negotiable' ) ) : ?> <em>Còn thương lượng</em><?php endif; ?></p>
					<?php if ( $intro ) : ?><p class="ld-intro"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
					<p class="listing-head__code">Mã tin: <strong><?php echo esc_html( hh_listing_code() ); ?></strong> · Đăng ngày <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time><?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) : ?> · Cập nhật <?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?><?php endif; ?></p>
				</header>

				<?php /* 4. Thông số nổi bật */ ?>
				<?php if ( $facts ) : ?>
					<dl class="ld-facts">
						<?php foreach ( $facts as $f ) : ?>
							<div class="ld-fact<?php echo $f[2] ? ' ld-fact--' . esc_attr( $f[2] ) : ''; ?>"><dt><?php echo esc_html( $f[0] ); ?></dt><dd><?php echo esc_html( $f[1] ); ?></dd></div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>

				<?php if ( count( $sec ) > 2 ) : ?>
					<nav class="ld-toc" aria-label="Mục trong tin">
						<?php foreach ( $sec as $k => $label ) : ?><a href="#<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $label ); ?></a><?php endforeach; ?>
					</nav>
				<?php endif; ?>

				<?php /* 5. Mô tả chi tiết */ ?>
				<?php if ( isset( $sec['mo-ta'] ) ) : ?>
					<section class="block ld-sec" id="mo-ta">
						<h2 class="block__title">Mô tả chi tiết</h2>
						<?php if ( hh_lines( 'hh_features' ) ) : ?>
							<div class="ld-features">
								<h3>Đặc điểm nổi bật</h3>
								<?php hh_check_list( hh_lines( 'hh_features' ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( get_the_content() ) : ?><div class="entry-content"><?php echo preg_replace( array( '#<h2(\s|>)#i', '#</h2>#i' ), array( '<h3$1', '</h3>' ), apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore -- H2 trong mô tả hạ thành H3 (nằm dưới mục "Mô tả chi tiết"). ?></div><?php endif; ?>
					</section>
				<?php endif; ?>

				<?php if ( hh_meta( 'hh_video' ) ) : ?>
					<section class="block ld-sec">
						<h2 class="block__title">Video thực tế</h2>
						<?php hh_video( hh_meta( 'hh_video' ) ); ?>
					</section>
				<?php endif; ?>

				<?php /* 6. Vị trí */ ?>
				<?php if ( $map ) : ?>
					<section class="block ld-sec" id="vi-tri">
						<h2 class="block__title">Vị trí và kết nối</h2>
						<?php if ( hh_meta( 'hh_address' ) ) : ?><p class="ld-addr"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_address' ) ); ?></p><?php endif; ?>
						<?php hh_map( $map, $map ); ?>
						<?php if ( $project && 'publish' === get_post_status( $project ) ) : ?>
							<a class="project-link" href="<?php echo esc_url( get_permalink( $project ) ); ?>">
								<?php echo get_the_post_thumbnail( $project, 'thumbnail' ); ?>
								<span><small>Thuộc dự án – xem vị trí, tiện ích, pháp lý dự án</small><strong><?php echo esc_html( get_the_title( $project ) ); ?></strong></span>
								<?php echo hh_icon( 'arrow' ); // phpcs:ignore ?>
							</a>
						<?php endif; ?>
						<?php if ( $area_t ) : ?>
							<p class="ld-more">Xem thêm nhà đất <?php echo $rent_d ? 'cho thuê' : 'bán'; ?> tại <a href="<?php echo esc_url( hh_deal_term_url( $deal, $area_t ) ); ?>"><?php echo esc_html( $area_t->name ); ?></a><?php if ( $type_t ) : ?> · <a href="<?php echo esc_url( get_term_link( $type_t ) ); ?>"><?php echo esc_html( $type_t->name ); ?></a><?php endif; ?></p>
						<?php endif; ?>
					</section>
				<?php endif; ?>

				<?php /* 7. Tiện ích xung quanh */ ?>
				<?php if ( $nearby ) : ?>
					<section class="block ld-sec" id="tien-ich">
						<h2 class="block__title">Tiện ích xung quanh</h2>
						<div class="ld-near">
							<?php foreach ( $nearby as $g => $items ) : ?>
								<div class="ld-near__g"><h3><?php echo esc_html( $g ); ?></h3><?php hh_check_list( $items ); ?></div>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php /* 8. Mặt bằng & thiết kế */ ?>
				<?php $view3d = hh_meta( 'hh_3d_url' ); ?>
				<?php if ( isset( $sec['mat-bang'] ) ) : ?>
					<section class="block ld-sec" id="mat-bang">
						<h2 class="block__title">Mặt bằng và thiết kế</h2>
						<?php if ( $plans ) : ?>
							<div class="ld-plans">
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
							<p class="ld-note">Bấm vào hình để phóng to, xem toàn màn hình.</p>
						<?php endif; ?>
						<?php if ( $pmedia ) : ?>
							<div class="ld-proj">
								<h3 class="ld-proj__title">Tòa nhà và mặt bằng dự án <a href="<?php echo esc_url( $pmedia['url'] ); ?>"><?php echo esc_html( $pmedia['title'] ); ?></a></h3>
								<div class="ld-plans">
									<?php if ( $pmedia['building'] ) : ?>
										<a class="ld-plan ld-plan--bld" href="<?php echo esc_url( wp_get_attachment_image_url( $pmedia['building'], 'full' ) ); ?>" data-lightbox="mat-bang">
											<?php echo wp_get_attachment_image( $pmedia['building'], 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => 'Hình tòa nhà ' . $pmedia['title'] ) ); ?>
											<span>Hình tòa nhà <?php echo esc_html( $pmedia['title'] ); ?></span>
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
										<small>Xem tòa nhà, chọn tầng, xem mặt bằng và hướng nhìn từng căn<?php echo $pmedia['tour'] ? ' trên mô hình 4D' : ''; ?>.</small>
									</div>
								<?php endif; ?>
								<p class="ld-note">Ảnh của dự án, minh hoạ vị trí và thiết kế chung; căn thực tế theo mô tả của tin.</p>
							</div>
						<?php endif; ?>
						<?php if ( $view3d && 0 === strpos( $view3d, 'https://' ) ) : ?>
							<div class="view3d" id="phoi-canh-3d"><iframe src="<?php echo esc_url( $view3d ); ?>" title="Phối cảnh 3D <?php echo esc_attr( get_the_title() ); ?>" loading="lazy" allow="fullscreen; xr-spatial-tracking" allowfullscreen></iframe></div>
							<p class="map-links">Kéo để xoay, chụm hai ngón để phóng to (hình minh hoạ) · <a href="<?php echo esc_url( $view3d ); ?>" target="_blank" rel="noopener">Mở toàn màn hình ↗</a></p>
						<?php endif; ?>
					</section>
				<?php endif; ?>

				<?php /* 9. Giá & chính sách */ ?>
				<section class="block ld-sec" id="gia">
					<h2 class="block__title"><?php echo $rent_d ? 'Giá thuê và điều kiện' : 'Giá bán và chính sách'; ?></h2>
					<div class="ld-price">
						<div class="ld-price__main"><span><?php echo $rent_d ? 'Giá thuê' : 'Giá bán'; ?></span><strong><?php echo esc_html( $price ); ?></strong><?php if ( $pm2 ) : ?><small><?php echo esc_html( $pm2 ); ?></small><?php endif; ?><?php if ( '1' === hh_meta( 'hh_negotiable' ) ) : ?><small>Còn thương lượng cho khách thiện chí</small><?php endif; ?></div>
						<?php if ( $policy ) : ?><div class="ld-price__pol"><?php hh_check_list( $policy ); ?></div><?php endif; ?>
					</div>
					<?php if ( $rent_d && $rent ) : ?><?php hh_spec_list( $rent ); ?><?php endif; ?>
					<?php $show_calc = ! $rent_d && ! hh_meta( 'hh_no_finance' ) && (float) hh_meta( 'hh_price' ) < 30000 && (float) hh_meta( 'hh_price' ) > 0; ?>
					<?php if ( $show_calc ) : ?>
						<div id="tai-chinh" class="ld-calc">
							<h3>Tính khoản vay &amp; dòng tiền</h3>
							<?php get_template_part( 'template-parts/finance', null, array( 'mode' => 'listing', 'no_rent' => has_term( array( 'dat-nen', 'mat-bang-kinh-doanh' ), 'loai-bds', $id ) ) ); ?>
						</div>
					<?php endif; ?>
					<details class="ld-specs"><summary>Toàn bộ thông tin tin đăng</summary><?php hh_spec_list( hh_listing_specs() ); ?></details>
				</section>

				<?php /* 12. Hỏi đáp (10. Liên hệ: cột phải trên máy tính, cuối nội dung + thanh cố định trên điện thoại) */ ?>
				<?php if ( $faq ) : ?>
					<section class="block ld-sec" id="hoi-dap">
						<h2 class="block__title">Câu hỏi thường gặp</h2>
						<div class="ld-faq">
							<?php foreach ( $faq as $i => $q ) : ?>
								<details<?php echo 0 === $i ? ' open' : ''; ?>><summary><?php echo esc_html( $q[0] ); ?></summary><p><?php echo esc_html( $q[1] ); ?></p></details>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>
			</article>

			<aside class="layout__side">
				<div class="sticky" id="lien-he">
					<div class="side-price">
						<span>Giá <?php echo $rent_d ? 'thuê' : 'bán'; ?></span>
						<strong><?php echo esc_html( $price ); ?></strong>
						<?php if ( $pm2 ) : ?><small><?php echo esc_html( $pm2 ); ?></small><?php endif; ?>
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
	</div>

	<?php /* Thanh liên hệ cố định trên điện thoại */ ?>
	<div class="ld-bar" role="region" aria-label="Liên hệ nhanh">
		<div class="ld-bar__price"><small><?php echo $rent_d ? 'Giá thuê' : 'Giá bán'; ?></small><strong><?php echo esc_html( $price ); ?></strong></div>
		<a class="ld-bar__btn ld-bar__btn--call" href="tel:<?php echo esc_attr( $tel ); ?>">Gọi ngay</a>
		<a class="ld-bar__btn ld-bar__btn--zalo" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Zalo</a>
		<a class="ld-bar__btn ld-bar__btn--msg" href="#lien-he">Nhắn tin</a>
	</div>

	<?php
	/* 11. Tin liên quan: cùng hình thức, ưu tiên cùng khu vực / loại hình / khoảng giá; thiếu thì bù tin hot. */
	$rel_ids = array();
	$p0      = (float) hh_meta( 'hh_price' );
	$base    = array(
		'post_type'      => 'bat-dong-san',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'post__not_in'   => array( $id ),
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_query'     => array( array( 'key' => 'hh_deal', 'value' => $deal ) ),
	);
	$tries = array();
	if ( $area_t && $type_t ) {
		$tries[] = array( 'tax_query' => array( array( 'taxonomy' => 'khu-vuc', 'terms' => $area_t->term_id ), array( 'taxonomy' => 'loai-bds', 'terms' => $type_t->term_id ) ) );
	}
	if ( $type_t && $p0 > 0 ) {
		$tries[] = array( 'tax_query' => array( array( 'taxonomy' => 'loai-bds', 'terms' => $type_t->term_id ) ), 'meta_query' => array( array( 'key' => 'hh_deal', 'value' => $deal ), array( 'key' => 'hh_price', 'value' => array( $p0 * .6, $p0 * 1.5 ), 'type' => 'NUMERIC', 'compare' => 'BETWEEN' ) ) );
	}
	if ( $area_t ) {
		$tries[] = array( 'tax_query' => array( array( 'taxonomy' => 'khu-vuc', 'terms' => $area_t->term_id ) ) );
	}
	foreach ( $tries as $t ) {
		if ( count( $rel_ids ) >= 6 ) {
			break;
		}
		$q       = new WP_Query( array_merge( $base, $t, array( 'post__not_in' => array_merge( array( $id ), $rel_ids ), 'posts_per_page' => 6 - count( $rel_ids ) ) ) );
		$rel_ids = array_merge( $rel_ids, $q->posts );
	}
	if ( count( $rel_ids ) < 4 ) {
		$hot     = hh_hot_query( 'bat-dong-san', array( 'exclude' => array_merge( array( $id ), $rel_ids ), 'limit' => 6 - count( $rel_ids ), 'deal' => $deal ) );
		$rel_ids = array_merge( $rel_ids, wp_list_pluck( $hot->posts, 'ID' ) );
	}
	$rel_ids = array_slice( array_values( array_unique( array_map( 'intval', $rel_ids ) ) ), 0, 6 );
	if ( $rel_ids ) :
		$rel = new WP_Query( array( 'post_type' => 'bat-dong-san', 'post__in' => $rel_ids, 'orderby' => 'post__in', 'posts_per_page' => 6, 'no_found_rows' => true ) );
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( $rent_d ? 'Cho thuê' : 'Mua bán', 'Tin đăng liên quan', $area_t ? hh_deal_term_url( $deal, $area_t ) : hh_deal_url( $deal ) ); ?>
				<div class="grid grid--3 ld-rel">
					<?php
					while ( $rel->have_posts() ) :
						$rel->the_post();
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
