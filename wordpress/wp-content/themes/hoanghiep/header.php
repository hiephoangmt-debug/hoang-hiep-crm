<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$hh_lang = function_exists( 'hh_lang' ) ? hh_lang() : 'vi';
$hh_t    = 'vi' !== $hh_lang ? hh_lang_strings( $hh_lang ) : null;
?>
<a class="skip-link" href="#main"><?php echo esc_html( $hh_t ? $hh_t['skip'] : 'Bỏ qua đến nội dung' ); ?></a>
<div class="topbar">
	<div class="container topbar__inner">
		<p class="topbar__slogan"><?php echo esc_html( $hh_t ? $hh_t['slogan'] : hoanghiep_opt( 'hh_person_slogan' ) ); ?></p>
		<ul class="topbar__contact">
			<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( $hh_t ? $hh_t['hours'] : hoanghiep_opt( 'hh_hours' ) ); ?></li>
			<li><a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo hh_icon( 'mail' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
		</ul>
	</div>
</div>
<header class="site-header">
	<div class="container site-header__inner">
		<div class="brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="brand__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="brand__mark" src="<?php echo esc_url( hoanghiep_photo( 'avatar' ) ); ?>" alt="<?php echo esc_attr( hoanghiep_opt( 'hh_person_name' ) ); ?>" width="46" height="46">
					<span class="brand__text">
						<span class="brand__name"><?php echo esc_html( hoanghiep_opt( 'hh_person_name' ) ); ?></span>
						<span class="brand__tag"><?php echo esc_html( $hh_t ? $hh_t['brand_tag'] : hoanghiep_opt( 'hh_person_title' ) ); ?></span>
					</span>
				</a>
			<?php endif; ?>
		</div>
		<nav id="primary-nav" class="primary-nav" aria-label="<?php echo esc_attr( $hh_t ? 'Menu' : 'Menu chính' ); ?>">
			<?php if ( $hh_t ) : ?>
				<ul>
					<?php foreach ( $hh_t['nav'] as $anchor => $label ) : ?>
						<li><a href="#<?php echo esc_attr( $anchor ); ?>"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'hoanghiep_fallback_menu',
				)
			);
			?>
			<?php endif; ?>
		</nav>
		<a class="header-hotline" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>">
			<span class="header-hotline__icon"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?></span>
			<span><small><?php echo esc_html( $hh_t ? $hh_t['hotline'] : 'Hotline tư vấn' ); ?></small><strong><?php echo esc_html( $hh_t ? '+84 ' . ltrim( hoanghiep_opt( 'hh_phone' ), '0' ) : hoanghiep_opt( 'hh_phone' ) ); ?></strong></span>
		</a>
		<?php if ( function_exists( 'hh_langs' ) ) : ?>
			<nav class="lang-switch notranslate" translate="no" aria-label="Ngôn ngữ / Language">
				<?php foreach ( array_merge( array( 'vi' => 'VI' ), array_combine( array_keys( hh_langs() ), array_map( 'strtoupper', array_keys( hh_langs() ) ) ) ) as $code => $label ) : ?>
					<?php if ( $code === $hh_lang ) : ?>
						<span class="lang-switch__item is-active" aria-current="true"><?php echo esc_html( $label ); ?></span>
					<?php else : ?>
						<?php $hh_lurl = hh_lang_switch_url( $code ); ?>
						<a class="lang-switch__item" href="<?php echo esc_url( $hh_lurl ); ?>" hreflang="<?php echo esc_attr( $code ); ?>" lang="<?php echo esc_attr( $code ); ?>"<?php echo false !== strpos( $hh_lurl, 'translate.goog' ) ? ' rel="nofollow"' : ''; ?> title="<?php echo esc_attr( 'vi' === $code ? 'Tiếng Việt' : hh_langs()[ $code ]['name'] ); ?>"><?php echo esc_html( $label ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
		<button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Mở menu"><?php echo hh_icon( 'menu' ); // phpcs:ignore ?></button>
	</div>
</header>
<main id="main" class="site-main">
