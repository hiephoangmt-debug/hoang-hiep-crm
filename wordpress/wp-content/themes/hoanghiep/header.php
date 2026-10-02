<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="topbar">
	<div class="container topbar__inner">
		<span>📍 <?php echo esc_html( hoanghiep_opt( 'hh_address' ) ); ?></span>
		<span>
			<a href="tel:<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_phone' ) ) ); ?>">📞 <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
			<a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>">✉️ <?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a>
		</span>
	</div>
</div>
<header class="site-header">
	<div class="container site-header__inner">
		<div class="site-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-brand__name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-brand__mark">HH</span><?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>
		<button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Mở menu">
			<span></span><span></span><span></span>
		</button>
		<nav id="primary-nav" class="primary-nav" aria-label="Menu chính">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'hoanghiep_fallback_menu',
				)
			);
			?>
			<a class="btn btn--primary primary-nav__cta" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Nhận tư vấn</a>
		</nav>
	</div>
</header>
<main id="main" class="site-main">
