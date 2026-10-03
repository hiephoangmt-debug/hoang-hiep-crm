<?php
/**
 * Trang tổng hợp loại sản phẩm: /san-pham/shop-khoi-de/, /san-pham/penthouse/, /san-pham/duplex/.
 * Chỉ liệt kê dự án đang / sắp mở bán có nhập thông tin loại sản phẩm đó.
 */
get_header();

$key      = hh_special_key( (string) get_query_var( 'hh_sp' ) );
$label    = HH_SPECIAL_PAGES[ $key ][1];
$projects = hh_special_projects( $key );
$intro    = hh_special_intro( $key );
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a> / <?php echo esc_html( $label ); ?></p>
		<h1 class="page-head__title"><?php echo esc_html( hh_special_title( $key ) ); ?></h1>
		<p class="page-head__lead"><?php echo esc_html( $intro['lead'] ); ?></p>
		<nav class="deal-tabs" aria-label="Loại sản phẩm">
			<?php foreach ( HH_SPECIAL_PAGES as $k => list( , $name ) ) : ?>
				<a class="<?php echo $k === $key ? 'is-active' : ''; ?>" href="<?php echo esc_url( hh_special_url( $k ) ); ?>"><?php echo esc_html( $name ); ?></a>
			<?php endforeach; ?>
		</nav>
	</div>
</div>

<div class="container section">
	<?php if ( $projects ) : ?>
		<section class="block price-board">
			<h2 class="block__title"><?php echo esc_html( $label ); ?> theo dự án</h2>
			<p class="prose"><?php echo esc_html( count( $projects ) . ' dự án đang hoặc sắp mở bán có ' . hh_lcfirst( $label ) . '. Cập nhật ' . wp_date( 'm/Y' ) . '. Bấm tên dự án để xem danh sách căn, mặt bằng và chính sách.' ); ?></p>
			<div class="table-wrap">
				<table class="data-table">
					<thead><tr><th>Dự án</th><th>Khu vực</th><th>Tình trạng</th><th>Chủ đầu tư</th></tr></thead>
					<tbody>
						<?php foreach ( $projects as $id => $p ) : ?>
							<?php $area = hh_project_area( $id ); ?>
							<tr>
								<td><a href="#du-an-<?php echo (int) $id; ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></td>
								<td><?php echo esc_html( $area ? $area->name : '' ); ?></td>
								<td><?php echo esc_html( hh_option_label( hh_project_schema(), 'hh_p_status', hh_meta( 'hh_p_status', $id ) ) ); ?></td>
								<td><?php echo esc_html( hh_meta( 'hh_p_developer', $id ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>

		<?php foreach ( $projects as $id => $p ) : ?>
			<section class="block" id="du-an-<?php echo (int) $id; ?>">
				<h2 class="block__title"><?php echo esc_html( $label . ' ' . get_the_title( $id ) ); ?></h2>
				<?php if ( hh_meta( 'hh_p_address', $id ) ) : ?>
					<p class="note"><?php echo esc_html( hh_meta( 'hh_p_address', $id ) ); ?></p>
				<?php endif; ?>
				<?php if ( $p['desc'] ) : ?>
					<p class="prose"><?php echo nl2br( esc_html( $p['desc'] ) ); ?></p>
				<?php endif; ?>
				<?php hh_data_table( $p['cols'], $p['rows'] ); ?>
				<?php hh_gallery( $p['gallery'], 'sp-' . $key . '-' . $id ); ?>
				<p>
					<a class="btn btn--navy btn--sm" href="<?php echo esc_url( get_permalink( $id ) . '#sp-' . $key ); ?>">Xem dự án <?php echo esc_html( get_the_title( $id ) ); ?></a>
					<a class="btn btn--gold btn--sm" href="#lien-he" data-need="<?php echo esc_attr( 'Nhận rổ hàng ' . hh_lcfirst( $label ) . ' ' . get_the_title( $id ) ); ?>">Nhận rổ hàng</a>
				</p>
			</section>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="empty">
			<p><strong>Hiện chưa có dự án đang mở bán <?php echo esc_html( hh_lcfirst( $label ) ); ?>.</strong></p>
			<p>Để lại số điện thoại, Hiệp sẽ báo ngay khi có đợt mở bán mới.</p>
		</div>
	<?php endif; ?>

	<section class="block faq-block">
		<h2 class="block__title">Hỏi đáp về <?php echo esc_html( hh_lcfirst( $label ) ); ?></h2>
		<div class="faq">
			<?php foreach ( $intro['faq'] as list( $q, $a ) ) : ?>
				<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
			<?php endforeach; ?>
		</div>
	</section>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
