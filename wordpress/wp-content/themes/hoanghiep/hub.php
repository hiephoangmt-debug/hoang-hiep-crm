<?php
/**
 * Trang tổng hợp (hub) theo từ khoá: /can-ho-sun-group-da-nang/, /biet-thu-hoi-an/,
 * /can-ho-chuyen-nhuong-da-nang/, /dat-nen-hoa-xuan/ (dữ liệu: plugin hh-crm/hub-pages.php).
 */
get_header();

$key      = hh_hub_key();
$hub      = hh_hub_pages()[ $key ];
$projects = hh_hub_projects( $key );
$listings = hh_hub_listings( $key );
$posts    = hh_hub_posts( $key );
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a> / <?php echo esc_html( $hub['h1'] ); ?></p>
		<h1 class="page-head__title"><?php echo esc_html( $hub['h1'] ); ?></h1>
		<p class="page-head__lead"><?php echo esc_html( $hub['desc'] ); ?></p>
		<nav class="deal-tabs" aria-label="Chủ đề">
			<?php foreach ( hh_hub_pages() as $k => $h ) : ?>
				<a class="<?php echo $k === $key ? 'is-active' : ''; ?>" href="<?php echo esc_url( hh_hub_url( $k ) ); ?>"><?php echo esc_html( $h['h1'] ); ?></a>
			<?php endforeach; ?>
		</nav>
	</div>
</div>

<div class="container section">
	<section class="block">
		<h2 class="block__title">Tổng quan <?php echo esc_html( hh_lcfirst( $hub['h1'] ) ); ?></h2>
		<div class="prose entry-content">
			<?php foreach ( $hub['intro'] as $para ) : ?>
				<p><?php echo wp_kses( $para, array( 'strong' => array(), 'a' => array( 'href' => array() ) ) ); ?></p>
			<?php endforeach; ?>
		</div>
	</section>

	<?php if ( $projects ) : ?>
		<section class="block price-board">
			<h2 class="block__title">Dự án <?php echo esc_html( hh_lcfirst( $hub['h1'] ) ); ?> (<?php echo count( $projects ); ?>)</h2>
			<div class="table-wrap">
				<table class="data-table">
					<thead><tr><th>Dự án</th><th>Khu vực</th><th>Tình trạng</th><th>Giá tham khảo</th></tr></thead>
					<tbody>
						<?php foreach ( $projects as $id ) : ?>
							<?php $area = hh_project_area( $id ); ?>
							<tr>
								<td><a href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></td>
								<td data-label="Khu vực"><?php echo esc_html( $area ? $area->name : '' ); ?></td>
								<td data-label="Tình trạng"><?php echo esc_html( hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status', $id ) ) ); ?></td>
								<td data-label="Giá tham khảo"><?php echo esc_html( preg_replace( '/^Giá:\s*/u', '', hh_project_price( $id ) ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	<?php endif; ?>

	<?php global $post; ?>
	<?php if ( $listings ) : ?>
		<section class="block">
			<h2 class="block__title">Tin bán mới nhất</h2>
			<div class="grid grid--3">
				<?php
				foreach ( $listings as $id ) {
					$post = get_post( $id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
					setup_postdata( $post );
					get_template_part( 'template-parts/listing-card' );
				}
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $posts ) : ?>
		<section class="block">
			<h2 class="block__title">Bài viết liên quan</h2>
			<div class="grid grid--3">
				<?php
				foreach ( $posts as $id ) {
					$post = get_post( $id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
					setup_postdata( $post );
					get_template_part( 'template-parts/post-card' );
				}
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>

	<section class="block faq-block">
		<h2 class="block__title">Hỏi đáp về <?php echo esc_html( hh_lcfirst( $hub['h1'] ) ); ?></h2>
		<div class="faq">
			<?php foreach ( $hub['faq'] as list( $q, $a ) ) : ?>
				<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
			<?php endforeach; ?>
		</div>
	</section>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
