<?php
get_header();
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / Liên hệ</p>
		<h1 class="page-head__title">Liên hệ với <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></h1>
		<p class="page-head__lead">Gọi điện, nhắn Zalo hoặc để lại thông tin – Hiệp sẽ phản hồi ngay trong giờ làm việc.</p>
	</div>
</div>

<div class="container layout" id="lien-he">
	<div class="layout__main">
		<?php echo hh_lead_form( array( 'title' => 'Gửi yêu cầu tư vấn' ) ); // phpcs:ignore ?>
		<?php
		while ( have_posts() ) :
			the_post();
			$content = hh_is_builder_page() ? '' : trim( str_replace( '[hh_lead_form]', '', get_the_content() ) );
			if ( $content ) :
				?>
				<div class="entry-content block"><?php echo apply_filters( 'the_content', $content ); // phpcs:ignore ?></div>
				<?php
			endif;
		endwhile;
		?>
	</div>
	<aside class="layout__side">
		<div class="sticky">
			<?php hh_agent_card(); ?>
			<ul class="contact-list">
				<li><?php echo hh_icon( 'mail' ); // phpcs:ignore ?><span><small>Email</small><a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></span></li>
				<li><?php echo hh_icon( 'pin' ); // phpcs:ignore ?><span><small>Khu vực hoạt động</small><?php echo esc_html( hoanghiep_opt( 'hh_address' ) ); ?></span></li>
				<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?><span><small>Giờ làm việc</small><?php echo esc_html( hoanghiep_opt( 'hh_hours' ) ); ?></span></li>
			</ul>
		</div>
	</aside>
</div>
<?php
get_footer();
