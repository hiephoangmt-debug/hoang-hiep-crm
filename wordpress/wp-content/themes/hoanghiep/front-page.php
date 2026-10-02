<?php
get_header();

$hero_image = hoanghiep_opt( 'hh_hero_image' );
$hero_style = $hero_image ? sprintf( ' style="--hero-image:url(%s)"', esc_url( $hero_image ) ) : '';
?>
<section class="hero"<?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above. ?>>
	<div class="container hero__inner">
		<div class="hero__text">
			<h1><?php echo esc_html( hoanghiep_opt( 'hh_hero_title' ) ); ?></h1>
			<p><?php echo esc_html( hoanghiep_opt( 'hh_hero_text' ) ); ?></p>
			<form class="hero__search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
				<input type="hidden" name="post_type" value="bat-dong-san">
				<input type="search" name="s" placeholder="Tìm dự án, khu vực, loại nhà…" aria-label="Tìm bất động sản">
				<button class="btn btn--primary" type="submit">Tìm kiếm</button>
			</form>
		</div>
	</div>
</section>

<section class="section stats">
	<div class="container"><div class="stats__grid">
		<div><strong>Uy tín</strong><span>Thông tin minh bạch, rõ ràng</span></div>
		<div><strong>Pháp lý</strong><span>Kiểm tra kỹ trước giao dịch</span></div>
		<div><strong>Tận tâm</strong><span>Đồng hành từ A đến Z</span></div>
		<div><strong>24/7</strong><span>Sẵn sàng hỗ trợ</span></div>
	</div></div>
</section>

<?php
$featured = new WP_Query(
	array(
		'post_type'      => 'bat-dong-san',
		'posts_per_page' => 6,
		'meta_key'       => 'hh_featured',
		'meta_value'     => '1',
	)
);
if ( ! $featured->have_posts() ) {
	$featured = new WP_Query( array( 'post_type' => 'bat-dong-san', 'posts_per_page' => 6 ) );
}
?>
<section class="section">
	<div class="container">
		<div class="section__head">
			<h2>Bất động sản nổi bật</h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'bat-dong-san' ) ); ?>">Xem tất cả →</a>
		</div>
		<?php if ( $featured->have_posts() ) : ?>
			<div class="grid">
				<?php
				while ( $featured->have_posts() ) :
					$featured->the_post();
					get_template_part( 'template-parts/property-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="muted">Danh sách bất động sản đang được cập nhật. Vui lòng liên hệ để nhận thông tin mới nhất.</p>
		<?php endif; ?>
	</div>
</section>

<section class="section section--alt">
	<div class="container">
		<h2 class="section__title">Dịch vụ của chúng tôi</h2>
		<div class="services">
			<div class="service"><span>🏡</span><h3>Mua bán nhà đất</h3><p>Tìm kiếm, thẩm định và đàm phán giá tốt nhất cho bạn.</p></div>
			<div class="service"><span>🔑</span><h3>Cho thuê</h3><p>Căn hộ, nhà phố, mặt bằng kinh doanh với nguồn hàng phong phú.</p></div>
			<div class="service"><span>📈</span><h3>Tư vấn đầu tư</h3><p>Phân tích tiềm năng khu vực, dòng tiền và rủi ro pháp lý.</p></div>
			<div class="service"><span>📝</span><h3>Hỗ trợ pháp lý</h3><p>Công chứng, sang tên, vay ngân hàng – trọn gói, nhanh gọn.</p></div>
		</div>
	</div>
</section>

<?php
$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
if ( $news->have_posts() ) :
	?>
	<section class="section">
		<div class="container">
			<div class="section__head">
				<h2>Tin tức thị trường</h2>
				<?php if ( get_option( 'page_for_posts' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Xem thêm →</a>
				<?php endif; ?>
			</div>
			<div class="grid">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--cta" id="lien-he">
	<div class="container cta">
		<div>
			<h2>Bạn đang tìm bất động sản phù hợp?</h2>
			<p>Để lại thông tin, chuyên viên Hoàng Hiệp sẽ gọi lại tư vấn miễn phí trong 15 phút.</p>
			<p><a class="cta__phone" href="tel:<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_phone' ) ) ); ?>">📞 <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a></p>
		</div>
		<?php echo function_exists( 'hh_lead_form' ) ? hh_lead_form( array( 'title' => '' ) ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>
<?php
get_footer();
