<section class="cta" id="lien-he">
	<div class="container cta__grid">
		<div class="cta__text">
			<div class="cta__person">
				<img src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="64" height="64" loading="lazy">
				<p><strong><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></strong><span><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?><?php echo hoanghiep_opt( 'hh_person_company' ) ? ' · ' . esc_html( hoanghiep_opt( 'hh_person_company' ) ) : ''; ?></span></p>
			</div>
			<p class="eyebrow eyebrow--light">Liên hệ</p>
			<h2 class="display">Bạn đang tìm nhà để ở hay để đầu tư?</h2>
			<p>Để lại số điện thoại, Hiệp sẽ trực tiếp gọi lại tư vấn và gửi danh sách sản phẩm phù hợp nhất với bạn.</p>
			<ul class="cta__contact">
				<li><?php echo hh_icon( 'phone' ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a></li>
				<li><?php echo hh_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
				<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?><?php echo esc_html( hoanghiep_opt( 'hh_hours' ) ); ?></li>
			</ul>
		</div>
		<?php echo hh_lead_form( array( 'title' => 'Đăng ký nhận tư vấn' ) ); // phpcs:ignore ?>
	</div>
</section>
