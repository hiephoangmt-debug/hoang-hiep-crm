<?php
get_header();

while ( have_posts() ) :
	the_post();
	$id         = get_the_ID();
	$status_key = hh_meta( 'hh_p_status' );
	$status     = hh_option_label( hh_project_schema(), 'hh_p_status', $status_key );

	// Build the section list from whatever has been filled in.
	$connections = hh_table( 'hh_p_connections', 2 );
	$unit_types  = hh_table( 'hh_p_unit_types', 4 );
	$price_table = hh_table( 'hh_p_price_table', 4 );
	$payment     = hh_table( 'hh_p_payment', 3 );
	$progress    = hh_table( 'hh_p_progress', 2 );
	$faq         = hh_table( 'hh_p_faq', 2 );
	$gallery     = hh_ids( 'hh_p_gallery' );

	$sections = array_filter(
		array(
			'tong-quan' => 'Tổng quan',
			'vi-tri'    => ( hh_meta( 'hh_p_location_desc' ) || $connections || hh_meta( 'hh_p_location_img' ) || hh_meta( 'hh_p_address' ) ) ? 'Vị trí' : '',
			'tien-ich'  => ( hh_lines( 'hh_p_amenities_in' ) || hh_lines( 'hh_p_amenities_out' ) || hh_ids( 'hh_p_amenities_img' ) ) ? 'Tiện ích' : '',
			'mat-bang'  => ( $unit_types || hh_meta( 'hh_p_masterplan_img' ) || hh_meta( 'hh_p_design_desc' ) || hh_ids( 'hh_p_floorplans' ) ) ? 'Mặt bằng' : '',
			'gia-ban'   => ( $price_table || $payment || hh_lines( 'hh_p_policy' ) || hh_meta( 'hh_p_loan' ) ) ? 'Giá & thanh toán' : '',
			'tien-do'   => ( $progress || hh_ids( 'hh_p_progress_gallery' ) ) ? 'Tiến độ' : '',
			'thu-vien'  => ( $gallery || hh_meta( 'hh_p_video' ) ) ? 'Hình ảnh' : '',
			'hoi-dap'   => $faq ? 'Hỏi đáp' : '',
		)
	);

	$key_facts = array_filter(
		array(
			'Giá bán'   => hh_project_price(),
			'Quy mô'    => hh_meta( 'hh_p_scale' ),
			'Sản phẩm'  => hh_meta( 'hh_p_unit_area' ),
			'Bàn giao'  => hh_meta( 'hh_p_handover' ),
			'Pháp lý'   => hh_meta( 'hh_p_legal' ),
		)
	);
	?>
	<section class="project-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-hero', array( 'class' => 'project-hero__bg', 'alt' => '' ) ); ?>
		<?php endif; ?>
		<div class="container project-hero__content">
			<p class="breadcrumb breadcrumb--light">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a>
			</p>
			<?php hh_pill( $status, $status_key ); ?>
			<h1 class="project-hero__title"><?php the_title(); ?></h1>
			<?php if ( hh_meta( 'hh_p_developer' ) ) : ?>
				<p class="project-hero__dev">Chủ đầu tư: <?php echo esc_html( hh_meta( 'hh_p_developer' ) ); ?></p>
			<?php endif; ?>
			<?php if ( hh_meta( 'hh_p_address' ) ) : ?>
				<p class="project-hero__addr"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_p_address' ) ); ?></p>
			<?php endif; ?>
			<p class="project-hero__updated">Cập nhật: <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?></time></p>
			<div class="hero__actions">
				<a class="btn btn--gold" href="#lien-he">Nhận bảng giá &amp; chính sách</a>
				<?php if ( hh_meta( 'hh_p_pricelist_url' ) ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( hh_meta( 'hh_p_pricelist_url' ) ); ?>" target="_blank" rel="noopener"><?php echo hh_icon( 'file' ); // phpcs:ignore ?> Tải brochure</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="container">
		<dl class="key-facts">
			<?php foreach ( $key_facts as $label => $value ) : ?>
				<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</div>

	<nav class="subnav" aria-label="Mục lục dự án">
		<div class="container subnav__inner">
			<?php foreach ( $sections as $anchor => $label ) : ?>
				<a href="#<?php echo esc_attr( $anchor ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
			<a class="subnav__cta" href="#lien-he">Nhận báo giá</a>
		</div>
	</nav>

	<div class="container layout">
		<div class="layout__main">

			<section class="block" id="tong-quan">
				<h2 class="block__title">Tổng quan dự án</h2>
				<?php if ( has_excerpt() ) : ?>
					<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<?php hh_spec_list( hh_project_specs() ); ?>
				<?php if ( hh_lines( 'hh_p_highlights' ) ) : ?>
					<h3 class="block__sub">Điểm nổi bật</h3>
					<?php hh_check_list( hh_lines( 'hh_p_highlights' ), 'check-list check-list--boxed' ); ?>
				<?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
			</section>

			<?php if ( isset( $sections['vi-tri'] ) ) : ?>
				<section class="block" id="vi-tri">
					<h2 class="block__title">Vị trí &amp; kết nối</h2>
					<?php if ( hh_meta( 'hh_p_location_desc' ) ) : ?>
						<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_location_desc' ) ) ); ?></p>
					<?php endif; ?>
					<?php if ( $connections ) : ?>
						<ul class="connections">
							<?php foreach ( $connections as list( $time, $place ) ) : ?>
								<li><strong><?php echo esc_html( $time ); ?></strong><span><?php echo esc_html( $place ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php hh_gallery( hh_ids( 'hh_p_location_img' ), 'vi-tri', 'gallery-single' ); ?>
					<?php hh_map( hh_meta( 'hh_p_map_address' ) ?: hh_meta( 'hh_p_address' ) ); ?>
				</section>
			<?php endif; ?>

			<?php if ( isset( $sections['tien-ich'] ) ) : ?>
				<section class="block" id="tien-ich">
					<h2 class="block__title">Tiện ích</h2>
					<div class="two-col">
						<?php if ( hh_lines( 'hh_p_amenities_in' ) ) : ?>
							<div>
								<h3 class="block__sub">Nội khu</h3>
								<?php hh_check_list( hh_lines( 'hh_p_amenities_in' ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( hh_lines( 'hh_p_amenities_out' ) ) : ?>
							<div>
								<h3 class="block__sub">Ngoại khu</h3>
								<?php hh_check_list( hh_lines( 'hh_p_amenities_out' ) ); ?>
							</div>
						<?php endif; ?>
					</div>
					<?php hh_gallery( hh_ids( 'hh_p_amenities_img' ), 'tien-ich' ); ?>
				</section>
			<?php endif; ?>

			<?php if ( isset( $sections['mat-bang'] ) ) : ?>
				<section class="block" id="mat-bang">
					<h2 class="block__title">Mặt bằng &amp; sản phẩm</h2>
					<?php hh_gallery( hh_ids( 'hh_p_masterplan_img' ), 'mat-bang-tong', 'gallery-single' ); ?>
					<?php if ( hh_meta( 'hh_p_design_desc' ) ) : ?>
						<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_design_desc' ) ) ); ?></p>
					<?php endif; ?>
					<?php hh_data_table( array( 'Loại sản phẩm', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), $unit_types ); ?>
					<?php if ( hh_ids( 'hh_p_floorplans' ) ) : ?>
						<h3 class="block__sub">Mặt bằng chi tiết</h3>
						<?php hh_gallery( hh_ids( 'hh_p_floorplans' ), 'mat-bang' ); ?>
					<?php endif; ?>
				</section>
			<?php endif; ?>

			<?php if ( isset( $sections['gia-ban'] ) ) : ?>
				<section class="block" id="gia-ban">
					<h2 class="block__title">Giá bán &amp; thanh toán</h2>
					<?php if ( $price_table ) : ?>
						<h3 class="block__sub">Bảng giá tham khảo</h3>
						<?php hh_data_table( array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), $price_table ); ?>
					<?php endif; ?>
					<?php if ( $payment ) : ?>
						<h3 class="block__sub">Tiến độ thanh toán</h3>
						<?php hh_data_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $payment ); ?>
					<?php endif; ?>
					<?php if ( hh_lines( 'hh_p_policy' ) ) : ?>
						<div class="policy">
							<h3 class="block__sub">Chính sách &amp; ưu đãi</h3>
							<?php hh_check_list( hh_lines( 'hh_p_policy' ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( hh_meta( 'hh_p_loan' ) ) : ?>
						<h3 class="block__sub">Hỗ trợ vay ngân hàng</h3>
						<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_loan' ) ) ); ?></p>
					<?php endif; ?>
					<p class="note">Giá và chính sách có thể thay đổi theo từng đợt mở bán. Liên hệ để nhận bảng giá mới nhất.</p>
				</section>
			<?php endif; ?>

			<?php if ( isset( $sections['tien-do'] ) ) : ?>
				<section class="block" id="tien-do">
					<h2 class="block__title">Tiến độ dự án</h2>
					<?php if ( $progress ) : ?>
						<ol class="timeline">
							<?php foreach ( $progress as list( $when, $what ) ) : ?>
								<li><time><?php echo esc_html( $when ); ?></time><span><?php echo esc_html( $what ); ?></span></li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>
					<?php hh_gallery( hh_ids( 'hh_p_progress_gallery' ), 'tien-do' ); ?>
				</section>
			<?php endif; ?>

			<?php if ( isset( $sections['thu-vien'] ) ) : ?>
				<section class="block" id="thu-vien">
					<h2 class="block__title">Hình ảnh &amp; video</h2>
					<?php hh_video( hh_meta( 'hh_p_video' ) ); ?>
					<?php hh_gallery( $gallery, 'thu-vien' ); ?>
				</section>
			<?php endif; ?>

			<?php if ( $faq ) : ?>
				<section class="block" id="hoi-dap">
					<h2 class="block__title">Câu hỏi thường gặp</h2>
					<div class="faq">
						<?php foreach ( $faq as list( $q, $a ) ) : ?>
							<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>
		</div>

		<aside class="layout__side">
			<div class="sticky" id="lien-he">
				<?php hh_agent_card( true ); ?>
				<?php
				echo hh_lead_form( // phpcs:ignore
					array(
						'ref_id' => $id,
						'title'  => 'Nhận bảng giá & chính sách',
						'need'   => 'Nhận bảng giá dự án',
						'button' => 'Nhận bảng giá',
					)
				);
				?>
			</div>
		</aside>
	</div>

	<?php
	$listings = new WP_Query(
		array(
			'post_type'      => 'bat-dong-san',
			'posts_per_page' => 8,
			'meta_query'     => array( array( 'key' => 'hh_project', 'value' => $id ) ),
		)
	);
	if ( $listings->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( 'Chuyển nhượng', 'Sản phẩm đang bán & cho thuê tại ' . get_the_title( $id ) ); ?>
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
	<?php endif; ?>

	<?php
	$others = new WP_Query( array( 'post_type' => 'du-an', 'posts_per_page' => 3, 'post__not_in' => array( $id ) ) );
	if ( $others->have_posts() ) :
		?>
		<section class="section">
			<div class="container">
				<?php hh_section_head( 'Dự án', 'Dự án khác', get_post_type_archive_link( 'du-an' ) ); ?>
				<div class="grid grid--3">
					<?php
					while ( $others->have_posts() ) :
						$others->the_post();
						get_template_part( 'template-parts/project-card' );
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
