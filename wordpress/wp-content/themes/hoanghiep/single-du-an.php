<?php
get_header();

while ( have_posts() ) :
	the_post();
	$id         = get_the_ID();
	$status_key = hh_meta( 'hh_p_status' );
	$status     = hh_option_label( hh_project_schema(), 'hh_p_status', $status_key );

	$connections = hh_project_connections();
	$nearby      = hh_project_nearby();
	$products    = hh_project_products();
	$price_table = hh_table( 'hh_p_price_table', 4 );
	$payment     = hh_table( 'hh_p_payment', 3 );
	$timeline    = hh_project_timeline();
	$faq         = hh_project_faq();
	$news        = hh_project_news();
	$gallery     = hh_ids( 'hh_p_gallery' );
	$type        = hh_project_type();
	$title       = get_the_title();

	// Mọi trang dự án đều đủ các mục; mục chưa nhập sẽ tự soạn hoặc ghi "đang cập nhật".
	$sections = array(
		'gioi-thieu' => 'Giới thiệu',
		'tong-quan'  => 'Tổng quan',
		'vi-tri'     => 'Vị trí',
		'lien-ket'   => 'Liên kết vùng',
		'tien-ich'   => 'Tiện ích',
		'mat-bang'   => 'Mặt bằng',
		'san-pham'   => 'Loại sản phẩm',
		'chinh-sach' => 'Chính sách',
		'tien-do'    => 'Tiến độ',
		'thu-vien'   => ( $gallery || hh_meta( 'hh_p_video' ) ) ? 'Hình ảnh' : '',
		'tin-tuc'    => 'Tin tức',
		'hoi-dap'    => 'Hỏi đáp',
		'lien-he'    => 'Liên hệ',
	);
	$sections = array_filter( $sections );

	$key_facts = array_filter(
		array(
			'Giá bán'   => hh_meta( 'hh_p_price_from' ) ? hh_project_price() : 'Liên hệ',
			'Loại hình' => hh_project_types_label(),
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
			<?php $parent_id = (int) hh_meta( 'hh_p_parent' ); ?>
			<?php if ( $parent_id && 'publish' === get_post_status( $parent_id ) ) : ?>
				<a class="parent-link" href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>"><?php echo esc_html( hh_parent_label( $parent_id ) ); ?> <strong><?php echo esc_html( get_the_title( $parent_id ) ); ?></strong> <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
			<?php hh_pill( $status, $status_key ); ?>
			<?php foreach ( get_the_terms( $id, 'loai-du-an' ) ?: array() as $t ) : ?><?php if ( $t->parent ) : ?><a class="pill pill--type" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a><?php endif; ?><?php endforeach; ?>
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
		</div>
	</nav>

	<div class="container layout">
		<div class="layout__main">

			<section class="block" id="gioi-thieu">
				<h2 class="block__title">Giới thiệu <?php echo esc_html( $title ); ?></h2>
				<?php if ( has_excerpt() ) : ?>
					<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<?php if ( trim( get_the_content() ) ) : ?>
					<div class="entry-content"><?php the_content(); ?></div>
				<?php else : ?>
					<div class="entry-content">
						<?php foreach ( hh_project_intro() as $para ) : ?>
							<p><?php echo esc_html( $para ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if ( hh_lines( 'hh_p_highlights' ) ) : ?>
					<h3 class="block__sub">Điểm nổi bật</h3>
					<?php hh_check_list( hh_lines( 'hh_p_highlights' ), 'check-list check-list--boxed' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="tong-quan">
				<h2 class="block__title">Tổng quan dự án</h2>
				<?php hh_spec_list( hh_project_specs() ); ?>
				<?php $zones = hh_table( 'hh_p_zones', 4 ); ?>
				<?php if ( $zones ) : ?>
					<h3 class="block__sub">Các phân khu &amp; loại sản phẩm</h3>
					<?php hh_data_table( array( 'Phân khu', 'Loại sản phẩm', 'Quy mô', 'Tình trạng' ), $zones ); ?>
				<?php endif; ?>
				<?php
				$subzones = new WP_Query(
					array(
						'post_type'      => 'du-an',
						'posts_per_page' => 12,
						'post__not_in'   => array( $id ),
						'meta_query'     => array( array( 'key' => 'hh_p_parent', 'value' => $id ) ),
						'orderby'        => 'title',
						'order'          => 'ASC',
						'no_found_rows'  => true,
					)
				);
				if ( $subzones->have_posts() ) :
					?>
					<h3 class="block__sub"><?php echo has_term( 'to-hop', 'loai-du-an', $id ) ? 'Dự án thành phần &amp; phân khu' : 'Phân khu có trang thông tin riêng'; ?></h3>
					<div class="grid grid--2">
						<?php
						while ( $subzones->have_posts() ) :
							$subzones->the_post();
							get_template_part( 'template-parts/project-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php endif; ?>
			</section>

			<section class="block" id="vi-tri">
				<h2 class="block__title">Vị trí dự án</h2>
				<?php if ( hh_meta( 'hh_p_address' ) ) : ?>
					<p class="address-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <strong><?php echo esc_html( hh_meta( 'hh_p_address' ) ); ?></strong></p>
				<?php endif; ?>
				<?php $profile = hh_project_area_profile(); ?>
				<?php if ( hh_meta( 'hh_p_location_desc' ) ) : ?>
					<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_location_desc' ) ) ); ?></p>
				<?php elseif ( $profile ) : ?>
					<p class="prose"><?php echo esc_html( $title . ' thuộc khu vực ' . $profile['name'] . '. ' . $profile['desc'] ); ?></p>
				<?php endif; ?>
				<?php hh_gallery( hh_ids( 'hh_p_location_img' ), 'vi-tri', 'gallery-single' ); ?>
				<?php hh_map( hh_meta( 'hh_p_map_address' ) ?: hh_meta( 'hh_p_address' ) ); ?>
			</section>

			<section class="block" id="lien-ket">
				<h2 class="block__title">Liên kết vùng</h2>
				<?php if ( $connections[0] ) : ?>
					<ul class="connections">
						<?php foreach ( $connections[0] as list( $time, $place ) ) : ?>
							<li><strong><?php echo esc_html( $time ); ?></strong><span><?php echo esc_html( $place ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<?php if ( $connections[1] ) : ?>
						<p class="note">Thời gian di chuyển bằng ô tô, tham khảo theo khu vực dự án; thực tế phụ thuộc giờ cao điểm.</p>
					<?php endif; ?>
				<?php else : ?>
					<?php hh_pending( 'Sơ đồ liên kết vùng của dự án đang được cập nhật.' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="tien-ich">
				<h2 class="block__title">Tiện ích</h2>
				<div class="two-col">
					<div>
						<h3 class="block__sub">Nội khu</h3>
						<?php if ( hh_lines( 'hh_p_amenities_in' ) ) : ?>
							<?php hh_check_list( hh_lines( 'hh_p_amenities_in' ) ); ?>
						<?php else : ?>
							<?php hh_pending( 'Danh sách tiện ích nội khu đang được cập nhật.', 'Nhận brochure' ); ?>
						<?php endif; ?>
					</div>
					<div>
						<h3 class="block__sub">Ngoại khu<?php echo $nearby[1] ? ' (khu vực xung quanh)' : ''; ?></h3>
						<?php if ( $nearby[0] ) : ?>
							<?php hh_check_list( $nearby[0] ); ?>
						<?php else : ?>
							<?php hh_pending( 'Tiện ích ngoại khu đang được cập nhật.' ); ?>
						<?php endif; ?>
					</div>
				</div>
				<?php hh_gallery( hh_ids( 'hh_p_amenities_img' ), 'tien-ich' ); ?>
			</section>

			<section class="block" id="mat-bang">
				<h2 class="block__title">Mặt bằng</h2>
				<?php $has_plan = hh_ids( 'hh_p_masterplan_img' ) || hh_meta( 'hh_p_design_desc' ) || hh_ids( 'hh_p_floorplans' ); ?>
				<?php hh_gallery( hh_ids( 'hh_p_masterplan_img' ), 'mat-bang-tong', 'gallery-single' ); ?>
				<?php if ( hh_meta( 'hh_p_design_desc' ) ) : ?>
					<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_design_desc' ) ) ); ?></p>
				<?php endif; ?>
				<?php if ( hh_ids( 'hh_p_floorplans' ) ) : ?>
					<h3 class="block__sub">Mặt bằng tầng / căn</h3>
					<?php hh_gallery( hh_ids( 'hh_p_floorplans' ), 'mat-bang' ); ?>
				<?php endif; ?>
				<?php if ( ! $has_plan ) : ?>
					<?php hh_pending( 'Mặt bằng tổng thể và mặt bằng chi tiết từng loại sản phẩm: liên hệ Hiệp để nhận bản PDF đầy đủ.', 'Nhận mặt bằng' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="san-pham">
				<h2 class="block__title">Loại sản phẩm</h2>
				<?php if ( $products ) : ?>
					<?php if ( count( $products ) > 1 ) : ?>
						<div class="ptabs" role="tablist">
							<?php $first = true; foreach ( $products as $key => $p ) : ?>
								<button type="button" role="tab" class="ptabs__tab<?php echo $first ? ' is-active' : ''; ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" data-ptab="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $p['label'] ); ?></button>
							<?php $first = false; endforeach; ?>
						</div>
					<?php endif; ?>
					<?php $first = true; foreach ( $products as $key => $p ) : ?>
						<div class="ptabs__panel<?php echo $first ? ' is-active' : ''; ?>" data-ppanel="<?php echo esc_attr( $key ); ?>">
							<h3 class="block__sub"><?php echo esc_html( $p['label'] ); ?></h3>
							<?php if ( $p['desc'] ) : ?>
								<p class="prose"><?php echo nl2br( esc_html( $p['desc'] ) ); ?></p>
							<?php endif; ?>
							<?php if ( $p['in_zones'] && ! $p['rows'] ) : ?>
								<?php hh_data_table( array( 'Phân khu', 'Loại sản phẩm', 'Quy mô', 'Tình trạng' ), $p['in_zones'] ); ?>
							<?php endif; ?>
							<?php hh_data_table( $p['cols'], $p['rows'] ); ?>
							<?php hh_gallery( $p['gallery'], 'san-pham-' . $key ); ?>
							<?php if ( ! $p['rows'] ) : ?>
								<?php hh_pending( 'Rổ hàng ' . hh_lcfirst( $p['label'] ) . ' (mã căn, diện tích, giá) đang được cập nhật theo từng đợt mở bán.', 'Nhận rổ hàng' ); ?>
							<?php endif; ?>
						</div>
					<?php $first = false; endforeach; ?>
				<?php else : ?>
					<?php hh_pending( 'Thông tin các loại sản phẩm đang được cập nhật.', 'Nhận rổ hàng' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="chinh-sach">
				<h2 class="block__title">Chính sách bán hàng &amp; thanh toán</h2>
				<h3 class="block__sub">Bảng giá</h3>
				<?php if ( $price_table ) : ?>
					<?php hh_data_table( array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), $price_table ); ?>
				<?php else : ?>
					<?php hh_pending( 'Giá ' . $title . ' thay đổi theo từng đợt mở bán và vị trí căn. Liên hệ để nhận bảng giá mới nhất.', 'Nhận bảng giá' ); ?>
				<?php endif; ?>
				<h3 class="block__sub">Lịch thanh toán</h3>
				<?php if ( $payment ) : ?>
					<?php hh_data_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $payment ); ?>
				<?php else : ?>
					<?php hh_pending( 'Lịch thanh toán chuẩn và các phương án thanh toán nhanh / vay ngân hàng đang được cập nhật.', 'Nhận lịch thanh toán' ); ?>
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
				<?php if ( hh_meta( 'hh_p_rental' ) ) : ?>
					<div class="policy">
						<h3 class="block__sub">Chương trình cho thuê &amp; lợi nhuận</h3>
						<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_rental' ) ) ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( hh_meta( 'hh_p_pricelist_url' ) ) : ?>
					<p><a class="btn btn--outline" href="<?php echo esc_url( hh_meta( 'hh_p_pricelist_url' ) ); ?>" target="_blank" rel="noopener"><?php echo hh_icon( 'file' ); // phpcs:ignore ?> Tải bảng giá / brochure</a></p>
				<?php endif; ?>
				<h3 class="block__sub" id="tai-chinh">Bảng tính dòng tiền &amp; vay ngân hàng</h3>
				<?php get_template_part( 'template-parts/finance', null, array( 'mode' => 'project' ) ); ?>
				<p class="note">Giá và chính sách có thể thay đổi theo từng đợt mở bán. Liên hệ để nhận thông tin mới nhất.</p>
			</section>

			<section class="block" id="tien-do">
				<h2 class="block__title">Cập nhật tiến độ</h2>
				<?php if ( $timeline[0] ) : ?>
					<ol class="timeline">
						<?php foreach ( $timeline[0] as list( $when, $what ) ) : ?>
							<li><time><?php echo esc_html( $when ); ?></time><span><?php echo esc_html( $what ); ?></span></li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>
				<?php hh_gallery( hh_ids( 'hh_p_progress_gallery' ), 'tien-do' ); ?>
				<?php if ( $timeline[1] && ! hh_ids( 'hh_p_progress_gallery' ) ) : ?>
					<?php hh_pending( 'Hình ảnh và báo cáo tiến độ thi công thực tế được cập nhật định kỳ.', 'Nhận ảnh tiến độ' ); ?>
				<?php endif; ?>
			</section>

			<?php if ( isset( $sections['thu-vien'] ) ) : ?>
				<section class="block" id="thu-vien">
					<h2 class="block__title">Hình ảnh &amp; video</h2>
					<?php hh_video( hh_meta( 'hh_p_video' ) ); ?>
					<?php hh_gallery( $gallery, 'thu-vien' ); ?>
				</section>
			<?php endif; ?>

			<section class="block" id="tin-tuc">
				<h2 class="block__title">Tin tức <?php echo esc_html( $title ); ?></h2>
				<?php if ( $news && $news->have_posts() ) : ?>
					<div class="grid grid--2">
						<?php
						while ( $news->have_posts() ) :
							$news->the_post();
							get_template_part( 'template-parts/post-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php else : ?>
					<?php hh_pending( 'Chưa có bài viết riêng về ' . $title . '. Đăng ký để nhận tin mở bán, bảng giá và tiến độ mới nhất.', 'Đăng ký nhận tin' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="hoi-dap">
				<h2 class="block__title">Câu hỏi thường gặp</h2>
				<div class="faq">
					<?php foreach ( $faq as list( $q, $a ) ) : ?>
						<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="block contact-block" id="lien-he">
				<div class="contact-block__text">
					<h2 class="block__title">Liên hệ tư vấn <?php echo esc_html( $title ); ?></h2>
					<p>Để lại thông tin, Hiệp sẽ gọi lại và gửi bạn:</p>
					<?php hh_check_list( array( 'Bảng giá, rổ hàng căn đẹp mới nhất', 'Lịch thanh toán, chính sách chiết khấu, hỗ trợ vay', 'Mặt bằng, brochure, pháp lý dự án', 'Lịch đi xem dự án, nhà mẫu' ) ); ?>
					<p class="contact-block__phone">
						<a class="btn btn--gold" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
						<a class="btn btn--zalo" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Chat Zalo</a>
					</p>
				</div>
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
			</section>
		</div>

		<aside class="layout__side">
			<div class="sticky">
				<?php hh_agent_card( true ); ?>
				<div class="side-box">
					<p class="side-box__title">Nhận ngay về <?php echo esc_html( $title ); ?></p>
					<?php hh_check_list( array( 'Bảng giá & rổ hàng mới nhất', 'Lịch thanh toán, chính sách', 'Mặt bằng, brochure' ) ); ?>
					<a class="btn btn--navy btn--block" href="#lien-he">Nhận bảng giá</a>
				</div>
			</div>
		</aside>
	</div>

	<?php
	// Phía dưới: dự án hot mới – ưu tiên cùng nhóm (cao tầng / thấp tầng), chỉ dự án.
	$group = null;
	if ( $type ) {
		$ancestors = get_ancestors( $type->term_id, 'loai-du-an', 'taxonomy' );
		$group     = $ancestors ? get_term( (int) end( $ancestors ), 'loai-du-an' ) : $type;
	}
	$hot = hh_hot_query( 'du-an', array( 'exclude' => array( $id ), 'limit' => 6, 'type_term' => $group ? $group->term_id : 0 ) );
	if ( $hot->post_count < 3 && $group ) {
		$hot = hh_hot_query( 'du-an', array( 'exclude' => array( $id ), 'limit' => 6 ) );
	}
	if ( $hot->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( 'Dự án', 'Dự án hot mới', $group ? get_term_link( $group ) : get_post_type_archive_link( 'du-an' ) ); ?>
				<div class="grid grid--3">
					<?php
					while ( $hot->have_posts() ) :
						$hot->the_post();
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
