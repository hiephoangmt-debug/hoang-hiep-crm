</main>
<footer class="site-footer">
	<div class="container site-footer__grid">
		<div class="site-footer__brand">
			<img class="site-footer__avatar" src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="64" height="64" loading="lazy">
			<p class="site-footer__name"><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></p>
			<p class="site-footer__title"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?></p>
			<p><?php echo esc_html( hoanghiep_opt( 'hh_person_slogan' ) ); ?></p>
			<?php if ( hoanghiep_opt( 'hh_person_company' ) ) : ?>
				<p>Hiện công tác tại <strong><?php echo esc_html( hoanghiep_opt( 'hh_person_company' ) ); ?></strong></p>
			<?php endif; ?>
			<ul class="socials">
				<?php
				foreach ( array( 'hh_facebook' => 'Facebook', 'hh_youtube' => 'YouTube', 'hh_tiktok' => 'TikTok' ) as $key => $label ) :
					if ( hoanghiep_opt( $key ) ) :
						?>
						<li><a href="<?php echo esc_url( hoanghiep_opt( $key ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a></li>
						<?php
					endif;
				endforeach;
				?>
				<li><a href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Zalo</a></li>
			</ul>
		</div>
		<div>
			<h3>Liên hệ</h3>
			<ul class="site-footer__contact">
				<li><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <a href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a></li>
				<li><?php echo hh_icon( 'mail' ); // phpcs:ignore ?> <a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
				<li><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_address' ) ); ?></li>
				<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_hours' ) ); ?></li>
			</ul>
		</div>
		<div>
			<h3>Danh mục</h3>
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
		<div>
			<h3>Khu vực</h3>
			<ul>
				<?php
				$areas = get_terms( array( 'taxonomy' => 'khu-vuc', 'hide_empty' => true, 'number' => 8 ) );
				if ( $areas && ! is_wp_error( $areas ) ) :
					foreach ( $areas as $t ) :
						?>
						<li><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
						<?php
					endforeach;
				else :
					?>
					<li>Đang cập nhật</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="site-footer__bottom">
		<div class="container">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?> · hiephoangmt.com</div>
	</div>
</footer>

<div class="contact-dock" aria-label="Liên hệ nhanh">
	<a class="contact-dock__btn contact-dock__btn--call" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?><span>Gọi ngay</span></a>
	<a class="contact-dock__btn contact-dock__btn--zalo" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener"><b>Zalo</b><span>Chat Zalo</span></a>
	<a class="contact-dock__btn contact-dock__btn--form" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" data-form-link><?php echo hh_icon( 'mail' ); // phpcs:ignore ?><span>Nhận tư vấn</span></a>
</div>

<div class="lightbox" hidden>
	<button class="lightbox__close" aria-label="Đóng">×</button>
	<button class="lightbox__prev" aria-label="Ảnh trước">‹</button>
	<img alt="">
	<button class="lightbox__next" aria-label="Ảnh sau">›</button>
	<p class="lightbox__count"></p>
</div>
<?php wp_footer(); ?>
</body>
</html>
