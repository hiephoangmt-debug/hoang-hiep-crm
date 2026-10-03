<?php
/**
 * Trang "Giới thiệu" – hồ sơ cá nhân của Hiệp.
 * Nội dung soạn trong trang Giới thiệu sẽ hiển thị ở phần "Câu chuyện".
 */
get_header();

$name  = hoanghiep_opt( 'hh_person_name' );
$photo = hoanghiep_photo( 'portrait2' );
$stats = hoanghiep_stats();
?>
<section class="profile-hero">
	<div class="container profile-hero__grid">
		<div class="profile-hero__photo">
			<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name . ' – ' . hoanghiep_opt( 'hh_person_title' ) ); ?>" width="900" height="1350">
		</div>
		<div>
			<p class="eyebrow eyebrow--light"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?></p>
			<h1 class="display display--xl"><?php echo esc_html( $name ); ?></h1>
			<p class="profile-hero__slogan">“<?php echo esc_html( hoanghiep_opt( 'hh_person_slogan' ) ); ?>”</p>
			<?php if ( hoanghiep_opt( 'hh_person_company' ) ) : ?>
				<p class="company-badge">Hiện công tác tại <strong><?php echo esc_html( hoanghiep_opt( 'hh_person_company' ) ); ?></strong></p>
			<?php endif; ?>
			<p class="lead"><?php echo esc_html( hoanghiep_opt( 'hh_person_bio' ) ); ?></p>
			<?php if ( $stats ) : ?>
				<dl class="stats stats--light">
					<?php foreach ( $stats as list( $num, $label ) ) : ?>
						<div><dt><?php echo esc_html( $num ); ?></dt><dd><?php echo esc_html( $label ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>
			<div class="hero__actions">
				<a class="btn btn--gold" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
				<a class="btn btn--ghost" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Kết bạn Zalo</a>
			</div>
		</div>
	</div>
</section>

<?php while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() && ! hh_is_builder_page() ) : ?>
		<section class="section">
			<div class="container narrow">
				<p class="eyebrow">Câu chuyện</p>
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>

<?php $career = hoanghiep_career(); ?>
<?php if ( $career ) : ?>
	<section class="section">
		<div class="container">
			<?php hh_section_head( 'Kinh nghiệm', 'Hành trình nghề nghiệp' ); ?>
			<ol class="career">
				<?php foreach ( $career as $i => list( $role, $note ) ) : ?>
					<li class="<?php echo 0 === mb_stripos( $note, 'Hiện' ) ? 'is-current' : ''; ?>">
						<strong><?php echo esc_html( $role ); ?></strong>
						<?php if ( $note ) : ?><span><?php echo esc_html( $note ); ?></span><?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>
<?php endif; ?>

<?php if ( hoanghiep_highlights() ) : ?>
	<section class="section section--navy">
		<div class="container">
			<div class="section-head section-head--light">
				<div>
					<p class="eyebrow eyebrow--light">Hoạt động</p>
					<h2 class="section-head__title">Hoạt động &amp; dấu ấn</h2>
				</div>
			</div>
			<?php hh_highlights( 0, 'highlights highlights--dark' ); ?>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tint">
	<div class="container">
		<?php hh_section_head( 'Dịch vụ', 'Hiệp có thể giúp gì cho bạn?' ); ?>
		<div class="services">
			<div class="service"><?php echo hh_icon( 'building' ); // phpcs:ignore ?><h3>Tư vấn dự án mới</h3><p>Phân tích vị trí, chủ đầu tư, pháp lý và chính sách để chọn căn phù hợp nhất.</p></div>
			<div class="service"><?php echo hh_icon( 'handshake' ); // phpcs:ignore ?><h3>Mua bán nhà đất</h3><p>Tìm nguồn hàng chính chủ, thẩm định giá và đàm phán giá tốt.</p></div>
			<div class="service"><?php echo hh_icon( 'search' ); // phpcs:ignore ?><h3>Cho thuê &amp; tìm thuê</h3><p>Căn hộ, nhà phố, mặt bằng kinh doanh – đúng nhu cầu, đúng ngân sách.</p></div>
			<div class="service"><?php echo hh_icon( 'shield' ); // phpcs:ignore ?><h3>Hỗ trợ pháp lý</h3><p>Kiểm tra giấy tờ, công chứng, sang tên, hỗ trợ vay ngân hàng.</p></div>
			<div class="service"><?php echo hh_icon( 'file' ); // phpcs:ignore ?><h3>Ký gửi bất động sản</h3><p>Nhận ký gửi bán / cho thuê, chụp ảnh và quảng bá chuyên nghiệp.</p></div>
			<div class="service"><?php echo hh_icon( 'star' ); // phpcs:ignore ?><h3>Tư vấn đầu tư</h3><p>Đánh giá dòng tiền, tiềm năng tăng giá và rủi ro trước khi xuống tiền.</p></div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
