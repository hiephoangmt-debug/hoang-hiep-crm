<?php
/**
 * Trang chủ đầu tư: /chu-dau-tu/ (danh sách) và /chu-dau-tu/<slug>/ (hồ sơ) – dữ liệu: plugin hh-crm/chu-dau-tu.json.
 */
get_header();

$key  = hh_cdt_key();
$all  = hh_cdt_all();
$tags = array( 'strong' => array(), 'b' => array(), 'em' => array(), 'a' => array( 'href' => array() ) );
$dom  = static fn( $u ) => preg_replace( '/^www\./', '', (string) wp_parse_url( $u, PHP_URL_HOST ) );
?>
<?php if ( 'tat-ca' === $key ) : ?>
	<?php
	$rows = array();
	foreach ( $all as $slug => $d ) {
		$rows[] = array( $slug, $d, count( hh_cdt_projects( $slug ) ), count( (array) ( $d['projects'] ?? array() ) ) );
	}
	usort( $rows, static fn( $a, $b ) => array( $b[2], $b[3] ) <=> array( $a[2], $a[3] ) );
	?>
	<div class="page-head">
		<div class="container">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a> / Chủ đầu tư</p>
			<h1 class="page-head__title">Chủ đầu tư bất động sản tại Đà Nẵng</h1>
			<p class="page-head__lead"><?php echo esc_html( hh_cdt_index_meta()['desc'] ); ?></p>
		</div>
	</div>
	<div class="container section">
		<section class="block">
			<h2 class="block__title">Ai đang xây dự án ở Đà Nẵng?</h2>
			<div class="prose entry-content">
				<?php foreach ( hh_cdt_index_meta()['intro'] as $para ) : ?>
					<p><?php echo wp_kses( $para, $tags ); ?></p>
				<?php endforeach; ?>
			</div>
		</section>
		<section class="block price-board">
			<h2 class="block__title">Danh sách chủ đầu tư (<?php echo count( $rows ); ?>)</h2>
			<div class="table-wrap">
				<table class="data-table cdt-table">
					<thead><tr><th>Chủ đầu tư</th><th>Lĩnh vực</th><th>Dự án tiêu biểu tại Đà Nẵng</th><th>Trên web</th></tr></thead>
					<tbody>
						<?php foreach ( $rows as list( $slug, $d, $n ) ) : ?>
							<?php
							$field = '';
							foreach ( (array) ( $d['facts'] ?? array() ) as $f ) {
								if ( false !== mb_stripos( $f[0], 'Lĩnh vực' ) ) {
									$field = $f[1];
									break;
								}
							}
							if ( '' === $field ) {
								$field = (string) ( $d['seo_desc'] ?? '' );
							}
							$top = array_slice( array_column( (array) ( $d['projects'] ?? array() ), 'name' ), 0, 3 );
							?>
							<tr>
								<td><a href="<?php echo esc_url( hh_cdt_url( $slug ) ); ?>"><strong><?php echo esc_html( $d['name'] ); ?></strong></a><?php echo ! empty( $d['full_name'] ) && $d['full_name'] !== $d['name'] ? '<br><small>' . esc_html( $d['full_name'] ) . '</small>' : ''; ?></td>
								<td data-label="Lĩnh vực"><?php echo esc_html( wp_trim_words( preg_replace( '/\s*\((?:theo|nguồn)[^)]*\)/u', '', $field ), 16, '…' ) ); ?></td>
								<td data-label="Dự án tiêu biểu"><?php echo esc_html( implode( ' · ', $top ) ); ?></td>
								<td data-label="Trên web"><?php echo $n ? esc_html( $n . ' dự án' ) : '–'; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
		<section class="block faq-block">
			<h2 class="block__title">Hỏi đáp về chủ đầu tư tại Đà Nẵng</h2>
			<div class="faq">
				<?php foreach ( hh_cdt_index_meta()['faq'] as list( $q, $a ) ) : ?>
					<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

<?php else : ?>
	<?php
	$d        = $all[ $key ];
	$projects = hh_cdt_projects( $key );
	// Dự án trên web đã có trong bảng dự án của hồ sơ → không lặp ở bảng "trên hiephoangmt.com".
	$named = array_filter( array_column( (array) ( $d['projects'] ?? array() ), 'site_slug' ) );
	$extra = array_values( array_filter( $projects, static fn( $id ) => ! in_array( get_post_field( 'post_name', $id ), $named, true ) ) );
	?>
	<div class="page-head">
		<div class="container">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( hh_cdt_url() ); ?>">Chủ đầu tư</a> / <?php echo esc_html( $d['name'] ); ?></p>
			<h1 class="page-head__title">Chủ đầu tư <?php echo esc_html( $d['name'] ); ?> tại Đà Nẵng</h1>
			<p class="page-head__lead"><?php echo esc_html( $d['seo_desc'] ?? '' ); ?></p>
		</div>
	</div>

	<div class="container section">
		<?php if ( ! empty( $d['facts'] ) ) : ?>
			<section class="block">
				<h2 class="block__title">Thông tin doanh nghiệp</h2>
				<div class="table-wrap">
					<table class="data-table cdt-facts">
						<tbody>
							<?php if ( ! empty( $d['full_name'] ) ) : ?>
								<tr><th scope="row">Tên doanh nghiệp</th><td><?php echo esc_html( $d['full_name'] ); ?></td></tr>
							<?php endif; ?>
							<?php foreach ( $d['facts'] as $f ) : ?>
								<tr><th scope="row"><?php echo esc_html( $f[0] ); ?></th><td><?php echo esc_html( $f[1] ); ?></td></tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>

		<section class="block">
			<h2 class="block__title"><?php echo esc_html( $d['name'] ); ?> là ai?</h2>
			<div class="prose entry-content">
				<?php foreach ( (array) ( $d['intro'] ?? array() ) as $para ) : ?>
					<p><?php echo wp_kses( $para, $tags ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $d['elsewhere'] ) ) : ?>
					<p><strong>Ngoài Đà Nẵng:</strong> <?php echo wp_kses( $d['elsewhere'], $tags ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<?php if ( ! empty( $d['projects'] ) ) : ?>
			<section class="block">
				<h2 class="block__title">Các dự án <?php echo esc_html( $d['name'] ); ?> đã và đang triển khai tại Đà Nẵng</h2>
				<div class="table-wrap">
					<table class="data-table cdt-projects">
						<thead><tr><th>Dự án</th><th>Vị trí</th><th>Loại hình · quy mô</th><th>Tình trạng</th></tr></thead>
						<tbody>
							<?php foreach ( $d['projects'] as $p ) : ?>
								<?php
								$pid  = ! empty( $p['site_slug'] ) ? get_page_by_path( $p['site_slug'], OBJECT, 'du-an' ) : null;
								$name = esc_html( $p['name'] );
								?>
								<tr>
									<td><?php echo $pid && 'publish' === $pid->post_status ? '<a href="' . esc_url( get_permalink( $pid ) ) . '">' . $name . '</a>' : $name; ?><?php echo ! empty( $p['note'] ) ? '<br><small>' . esc_html( $p['note'] ) . '</small>' : ''; ?></td>
									<td data-label="Vị trí"><?php echo esc_html( $p['where'] ?? '' ); ?></td>
									<td data-label="Loại hình"><?php echo esc_html( trim( ( $p['type'] ?? '' ) . ( ! empty( $p['scale'] ) ? ' · ' . $p['scale'] : '' ), ' ·' ) ); ?></td>
									<td data-label="Tình trạng"><?php echo esc_html( $p['status'] ?? '' ); ?><?php echo $pid && 'publish' === $pid->post_status && '' !== hh_meta( 'hh_p_price_from', $pid->ID ) ? '<br><small>Giá tham khảo: ' . esc_html( preg_replace( '/^Giá:\s*/u', '', hh_project_price( $pid->ID ) ) ) . '</small>' : ''; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $extra ) : ?>
			<section class="block price-board">
				<h2 class="block__title"><?php echo $d['projects'] ? 'Thêm dự án' : 'Dự án'; ?> của <?php echo esc_html( $d['name'] ); ?> có bảng giá trên hiephoangmt.com</h2>
				<div class="table-wrap">
					<table class="data-table">
						<thead><tr><th>Dự án</th><th>Khu vực</th><th>Tình trạng</th><th>Giá tham khảo</th></tr></thead>
						<tbody>
							<?php foreach ( $extra as $id ) : ?>
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

		<?php if ( ! empty( $d['timeline'] ) ) : ?>
			<section class="block">
				<h2 class="block__title">Các mốc của <?php echo esc_html( $d['name'] ); ?> tại Đà Nẵng</h2>
				<ol class="cdt-timeline">
					<?php foreach ( $d['timeline'] as $t ) : ?>
						<li><b><?php echo esc_html( $t[0] ); ?></b><span><?php echo wp_kses( $t[1], $tags ); ?></span></li>
					<?php endforeach; ?>
				</ol>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $d['buyer_notes'] ) ) : ?>
			<section class="block">
				<h2 class="block__title">Lưu ý khi mua dự án của <?php echo esc_html( $d['name'] ); ?></h2>
				<div class="prose entry-content">
					<ul>
						<?php foreach ( $d['buyer_notes'] as $n ) : ?>
							<li><?php echo wp_kses( $n, $tags ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $d['faq'] ) ) : ?>
			<section class="block faq-block">
				<h2 class="block__title">Hỏi đáp về chủ đầu tư <?php echo esc_html( $d['name'] ); ?></h2>
				<div class="faq">
					<?php foreach ( $d['faq'] as list( $q, $a ) ) : ?>
						<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $d['sources'] ) ) : ?>
			<section class="block cdt-sources">
				<h2 class="block__title">Nguồn tham khảo</h2>
				<p>Thông tin tổng hợp từ website doanh nghiệp, cổng thông tin nhà nước và báo chí; số liệu dự án có thể thay đổi theo từng giai đoạn – Hoàng Hiệp cập nhật khi có thông tin mới.</p>
				<ul>
					<?php foreach ( array_unique( $d['sources'] ) as $u ) : ?>
						<li><a href="<?php echo esc_url( $u ); ?>" rel="nofollow noopener" target="_blank"><?php echo esc_html( $dom( $u ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<nav class="block cdt-others" aria-label="Chủ đầu tư khác">
			<h2 class="block__title">Chủ đầu tư khác tại Đà Nẵng</h2>
			<p>
				<?php
				$links = array();
				foreach ( $all as $slug => $o ) {
					if ( $slug !== $key ) {
						$links[] = '<a href="' . esc_url( hh_cdt_url( $slug ) ) . '">' . esc_html( $o['name'] ) . '</a>';
					}
				}
				echo implode( ' · ', $links ) . ' · <a href="' . esc_url( hh_cdt_url() ) . '">Xem tất cả →</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
				?>
			</p>
		</nav>
	</div>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
