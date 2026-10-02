<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Bỏ qua đến nội dung</a>
<div class="topbar">
	<div class="container topbar__inner">
		<p class="topbar__slogan"><?php echo esc_html( hoanghiep_opt( 'hh_person_slogan' ) ); ?></p>
		<ul class="topbar__contact">
			<li><?php echo hh_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_hours' ) ); ?></li>
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
						<span class="brand__tag"><?php echo esc_html( hoanghiep_opt( 'hh_person_title' ) ); ?></span>
					</span>
				</a>
			<?php endif; ?>
		</div>
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
		</nav>
		<a class="header-hotline" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>">
			<span class="header-hotline__icon"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?></span>
			<span><small>Hotline tư vấn</small><strong><?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></strong></span>
		</a>
		<button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Mở menu"><?php echo hh_icon( 'menu' ); // phpcs:ignore ?></button>
	</div>
</header>
<main id="main" class="site-main">
