<section class="cta" id="lien-he">
	<div class="container cta__grid">
		<div class="cta__text">
			<p class="eyebrow eyebrow--light">Liên hệ</p>
			<h2 class="display">Bạn đang tìm nhà để ở hay để đầu tư?</h2>
			<p>Để lại số điện thoại, Hiệp sẽ gọi lại tư vấn miễn phí và gửi danh sách sản phẩm phù hợp nhất với bạn.</p>
			<ul class="cta__contact">
				<li><?php echo hh_icon( 'phone' ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a></li>
				<li><?php echo hh_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
				<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?><?php echo esc_html( hoanghiep_opt( 'hh_hours' ) ); ?></li>
			</ul>
		</div>
		<?php echo hh_lead_form( array( 'title' => 'Đăng ký nhận tư vấn' ) ); // phpcs:ignore ?>
	</div>
</section>
