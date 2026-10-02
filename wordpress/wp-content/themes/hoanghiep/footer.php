</main>
<footer class="site-footer">
	<div class="container site-footer__grid">
		<div>
			<h3><?php bloginfo( 'name' ); ?></h3>
			<p><?php bloginfo( 'description' ); ?></p>
		</div>
		<div>
			<h3>Liên hệ</h3>
			<ul class="site-footer__contact">
				<li>📍 <?php echo esc_html( hoanghiep_opt( 'hh_address' ) ); ?></li>
				<li>📞 <a href="tel:<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_phone' ) ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a></li>
				<li>✉️ <a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
				<?php if ( hoanghiep_opt( 'hh_facebook' ) ) : ?>
					<li>👍 <a href="<?php echo esc_url( hoanghiep_opt( 'hh_facebook' ) ); ?>" target="_blank" rel="noopener">Facebook</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<div>
			<h3>Liên kết</h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => 'hoanghiep_fallback_menu',
					'depth'          => 1,
				)
			);
			?>
		</div>
	</div>
	<div class="site-footer__bottom">
		<div class="container">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> · <a href="<?php echo esc_url( home_url( '/' ) ); ?>">hiephoangmt.com</a></div>
	</div>
</footer>

<div class="float-contact">
	<a class="float-contact__btn float-contact__btn--zalo" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener" aria-label="Chat Zalo">Zalo</a>
	<a class="float-contact__btn float-contact__btn--call" href="tel:<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_phone' ) ) ); ?>" aria-label="Gọi điện">📞</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
